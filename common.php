<?php

namespace seraph_osm;

if( !defined( 'ABSPATH' ) )
	exit;

require_once( __DIR__ . '/Cmn/Gen.php' );
require_once( __DIR__ . '/Cmn/Ui.php' );
require_once( __DIR__ . '/Cmn/Plugin.php' );

const PLUGIN_SETT_VER								= 1;
const PLUGIN_DATA_VER								= 1;
const PLUGIN_EULA_VER								= 1;

function GetCompatiblePostsTypes()
{
	$a = Wp::GetSupportsPostsTypes( array( 'editor', 'thumbnail' ) );
	$a[] = 'attachment';
	return( $a );
}

function OnActivate()
{
}

function OnDeactivate()
{
}

