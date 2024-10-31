<?php

namespace seraph_osm;

if( !defined( 'ABSPATH' ) )
	exit;

include( __DIR__ . '/common.php' );

Plugin::Init();

function OnInit( $isAdminMode )
{
	if( $isAdminMode )
		return;

	$sett = Plugin::SettGet();

	if( Gen::GetArrField( $sett, array( 'altSrch' ), false ) )
	{
		add_filter( 'old_slug_redirect_post_id',
			function( $id )
			{
				if( $id )
					return( $id );
				return( \_find_post_by_old_slug( 'page' ) );
			}
		);
	}
}

function _AddMenus( $accepted = false )
{
	add_options_page( Plugin::GetSettingsTitle(), Plugin::GetNavMenuTitle(), 'manage_options', 'seraph_osm_settings', $accepted ? 'seraph_osm\\_SettingsPage' : 'seraph_osm\\Plugin::OutputNotAcceptedPageContent' );
}

function OnInitAdminModeNotAccepted()
{
	add_action( 'admin_menu',
		function()
		{
			_AddMenus();
		}
	);
}

function OnInitAdminMode()
{
	add_action( 'admin_init',
		function()
		{
			if( isset( $_POST[ 'seraph_osm_saveSettings' ] ) )
			{
				unset( $_POST[ 'seraph_osm_saveSettings' ] );
				Plugin::ReloadWithPostOpRes( array( 'saveSettings' => wp_verify_nonce( (isset($_REQUEST[ '_wpnonce' ])?$_REQUEST[ '_wpnonce' ]:''), 'save' ) ? _OnSaveSettings( $_POST ) : Gen::E_CONTEXT_EXPIRED ) );
				exit;
			}
		}
	);

	add_action( 'seraph_osm_postOpsRes',
		function( $res )
		{
			if( ( $hr = @$res[ 'saveSettings' ] ) !== null )
				echo( Plugin::Sett_SaveResultBannerMsg( $hr, Ui::MsgOptDismissible ) );
		}
	);

	add_action( 'add_meta_boxes',
		function()
		{
			$rmtCfg = PluginRmtCfg::Get();
			$sett = Plugin::SettGet();

			$urlHelp = Plugin::RmtCfgFld_GetLoc( $rmtCfg, 'Help.PostEditor' );

			foreach( GetCompatiblePostsTypes() as $postType )
			{
				if( !Gen::GetArrField( $sett, array( 'postTypes', $postType, 'enable' ), true ) )
					continue;

				Ui::MetaboxAdd(
					'seraph_osm_editor',
					sprintf( esc_html_x( 'Title_%1$s', 'admin.PostEditor', 'seraphinite-old-slugs-mgr' ), esc_html( Wp::GetLocString( 'Slug' ) ) ) . Ui::Tag( 'span', Ui::AdminHelpBtn( $urlHelp, Ui::AdminHelpBtnModeBlockHeader ) ),
					'seraph_osm\\_OnPostSettingsMetaBox', null,
					$postType, 'normal', 'core'
				);
			}
		}
	);

	add_action( 'admin_menu',
		function()
		{
			_AddMenus( true );
		}
	);

	add_action( 'save_post', 'seraph_osm\\_OnPostSettingsSave' );
	add_action( 'edit_attachment', 'seraph_osm\\_OnPostSettingsSave' );
	add_action( 'add_attachment', 'seraph_osm\\_OnPostSettingsSave' );
}

function _OnPostSettingsMetaBox( $post )
{
	Plugin::CmnScripts( array( 'Cmn', 'Gen', 'Ui', 'Net', 'AdminUi' ) );

	$rmtCfg = PluginRmtCfg::Get();

	$htmlContent = Plugin::SwitchToExt();
	if( !empty( $htmlContent ) )
		echo( Ui::Tag( 'p', $htmlContent ) . Ui::SepLine( 'p' ) );

	$htmlContent = Plugin::GetLockedFeatureLicenseContent();
	if( !empty( $htmlContent ) )
		echo( Ui::Tag( 'p', $htmlContent ) . Ui::SepLine( 'p' ) );

	wp_nonce_field( 'savePostSettings', 'seraph_osm/_nonce' );

	$vals = get_post_meta( $post -> ID, '_wp_old_slug' );

?>

	<style>
		#slugdiv.postbox #post_name
		{
			width:	100%;
		}
	</style>
	
	<?php

	$itemsListPrms = array( 'editorAreaCssPath' => '#seraph_osm_editor' );

	echo( Ui::Tag( 'p', Ui::ItemsList( $itemsListPrms, $vals, 'seraph_osm/items',
		function( $cbArgs, $idItems, $vals, $itemKey, $item )
		{
			extract( $cbArgs );

			$res = Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => array( 'std', 'ctlMaxSizeX ctlSpaceVAfter' ) ) ) . Ui::TagOpen( 'tr' );

			$res .= Ui::Tag( 'td', Ui::TextBox( $idItems . '/' . $itemKey, $item, array( 'class' => 'ctlMaxSizeX' ), true ) );
			$res .= Ui::Tag( 'td', Ui::ItemsList_ItemOperateBtns( $itemsListPrms ), array( 'class' => 'ctlMinSizeX' ) );

			$res .= Ui::TagClose( 'tr' ) . Ui::SettBlock_ItemSubTbl_End();

			return( $res );
		},

		function( $cbArgs, $attrs )
		{
			return( Ui::ItemsList_NoItemsContent( $attrs ) );
		},

		get_defined_vars(), array( 'class' => 'ctlMaxSizeX' )
	) ) );

	echo( Ui::Tag( 'p', Ui::ItemsList_OperateBtns( $itemsListPrms, array( 'class' => 'ctlSpaceAfter' ) ) ) );

	echo( Ui::ViewInitContent( '#seraph_osm_editor' ) );
}

function _OnPostSettingsSave( $postId )
{
	if( !current_user_can( 'edit_post', $postId ) )
		return;

	if( !wp_verify_nonce( Wp::SanitizeId( @$_REQUEST[ 'seraph_osm/_nonce' ] ), 'savePostSettings' ) )
		return;

	$valsPrev = get_post_meta( $postId, '_wp_old_slug' );

	foreach( Ui::ItemsList_GetSaveItems( 'seraph_osm/items', '/', $_REQUEST ) as $v )
	{
		$v = trim( $v );
		if( empty( $v ) )
			continue;

		$idx = array_search( $v, $valsPrev );
		if( $idx !== false )
			array_splice( $valsPrev, $idx, 1 );
		else
			add_post_meta( $postId, '_wp_old_slug', $v );
	}

	foreach( $valsPrev as $vPrev )
		delete_post_meta( $postId, '_wp_old_slug', $vPrev );
}

function _SettingsPage()
{
	Plugin::CmnScripts( array( 'Cmn', 'Gen', 'Ui', 'Net', 'AdminUi' ) );

	Plugin::DisplayAdminFooterRateItContent();

	$rmtCfg = PluginRmtCfg::Get();
	$sett = Plugin::SettGet();

	{
		Ui::PostBoxes_MetaboxAdd( 'general', esc_html_x( 'Title', 'admin.Settings_General', 'seraphinite-old-slugs-mgr' ) . Ui::Tag( 'span', Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLoc( $rmtCfg, 'Help.Settings' ), Ui::AdminHelpBtnModeBlockHeader ) ), true,
			function( $callbacks_args, $box )
			{

				extract( $box[ 'args' ] );

				echo( Ui::SettBlock_Begin() );
				{
					echo( Ui::SettBlock_Item_Begin( esc_html_x( 'Common', 'admin.Settings_General', 'seraphinite-old-slugs-mgr' ) ) );
					{
						echo( Ui::SettBlock_ItemSubTbl_Begin() );
						{
							echo( Ui::TagOpen( 'tr' ) );
							{
								echo( Ui::TagOpen( 'td' ) );
								{
									$fldId = 'altSrch';
									echo( Ui::CheckBox( esc_html_x( 'AltSrchChk', 'admin.Settings_General', 'seraphinite-old-slugs-mgr' ), 'seraph_osm/' . $fldId, Gen::GetArrField( $sett, $fldId, false, '/' ), true ) );
								}
								echo( Ui::TagClose( 'td' ) );
							}
							echo( Ui::TagClose( 'tr' ) );
						}
						echo( Ui::SettBlock_ItemSubTbl_End() );
					}
					echo( Ui::SettBlock_Item_End() );

					echo( Ui::SettBlock_Item_Begin( esc_html_x( 'ContentTypes', 'admin.Settings_General', 'seraphinite-old-slugs-mgr' ) ) );
					{
						echo( Ui::SettBlock_ItemSubTbl_Begin() );
						{
							echo( Ui::TagOpen( 'tr' ) );
							{
								$i = 0;
								foreach( GetCompatiblePostsTypes() as $postType )
								{
									if( $i && !( $i % 3 ) )
										echo( Ui::TagClose( 'tr' ) . Ui::TagOpen( 'tr' ) );

									$fldId = 'postTypes/' . $postType . '/enable';

									echo( Ui::TagOpen( 'td' ) );
									{
										echo( Ui::CheckBox( get_post_type_object( $postType ) -> labels -> name, $fldId, Gen::GetArrField( $sett, $fldId, true, '/' ), true ) );
									}
									echo( Ui::TagClose( 'td' ) );

									$i++;
								}
							}
							echo( Ui::TagClose( 'tr' ) );
						}
						echo( Ui::SettBlock_ItemSubTbl_End() );

						echo( Ui::Tag( 'p', esc_html_x( 'ContentTypesDescr', 'admin.Settings_General', 'seraphinite-old-slugs-mgr' ), array( 'class' => array( "description" ) ) ) );
					}
					echo( Ui::SettBlock_Item_End() );
				}
				echo( Ui::SettBlock_End() );
			},
			get_defined_vars()
		);
	}

	{
		$htmlContent = Plugin::GetSettingsLicenseContent();
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'license', Plugin::GetSettingsLicenseTitle(), true, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'normal' );

		$htmlContent = Plugin::GetAdvertProductsContent( 'advertProducts' );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'advertProducts', Plugin::GetAdvertProductsTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'normal' );
	}

	{
		$htmlContent = Plugin::GetRateItContent( 'rateIt', Plugin::DisplayContent_SmallBlock );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'rateIt', Plugin::GetRateItTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'side' );

		$htmlContent = Plugin::GetLockedFeatureLicenseContent( Plugin::DisplayContent_SmallBlock );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'switchToFull', Plugin::GetSwitchToFullTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'side' );

		Ui::PostBoxes_MetaboxAdd( 'about', Plugin::GetAboutPluginTitle(), false, function( $callbacks_args, $box ) { echo( Plugin::GetAboutPluginContent() ); }, null, 'side' );
		Ui::PostBoxes_MetaboxAdd( 'aboutVendor', Plugin::GetAboutVendorTitle(), false, function( $callbacks_args, $box ) { echo( Plugin::GetAboutVendorContent() ); }, null, 'side' );
	}

	Ui::PostBoxes( Plugin::GetSettingsTitle(), array( 'body' => array( 'nosort' => true ), 'normal' => array(), 'side' => array( 'nosort' => true ) ),
		array(
			'bodyContentBegin' => function( $callbacks_args )
			{
				extract( $callbacks_args );

				echo( Ui::TagOpen( 'form', array( 'method' => 'post' ) ) );
			},

			'bodyContentEnd' => function( $callbacks_args )
			{
				extract( $callbacks_args );

				Ui::PostBoxes_BottomGroupPanel( function( $callbacks_args ) { echo( Plugin::Sett_SaveBtn( 'seraph_osm_saveSettings' ) ); } );
				echo( Ui::TagClose( 'form' ) );
			}
		),
		get_defined_vars()
	);
}

function _OnSaveSettings( $args )
{
	$sett = Plugin::SettGet();

	foreach( GetCompatiblePostsTypes() as $postType )
	{
		$fldId = 'postTypes/' . $postType . '/enable';
		Gen::SetArrField( $sett, $fldId, isset( $args[ $fldId ] ), '/' );
	}

	{ $fldId = 'altSrch';					Gen::SetArrField( $sett, $fldId, isset( $args[ 'seraph_osm/' . $fldId ] ), '/' ); }

	return( Plugin::SettSet( $sett ) );
}

