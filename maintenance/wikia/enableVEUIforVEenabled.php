<?php
/**
 * @author: Inez
 *
 * Get familiar with "How_to_run_maintenance_script" article on internal to figure out how to run it.
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

function enableVEUI( $id ) {
	WikiFactory::setVarByName( 'wgEnableVisualEditorUI', $id, true );
	WikiFactory::clearCache( $id );
}

function isVEenabled( $id ) {
	$out = WikiFactory::getVarByName( 'wgEnableVisualEditorExt', $id );
	return $out ? unserialize( $out->cv_value ) : false;
}

$varid = WikiFactory::getVarIdByName( 'wgEnableVisualEditorExt', true );

$list = WikiFactory::getListOfWikisWithVar(
	$varid,
	'bool',
	'=',
	true
);

foreach ( $list as $id => $val ) {
	echo "Wiki id: {$id}\n";
	$isVEenabled = isVEenabled( $id );
	if ( $isVEenabled ) {
		// IMPORTANT! Uncomment line below if you really want it to work.
		//enableVEUI( $id );
		echo "Enabled VEUI\n";
	} else {
		echo "Not enabled VEUI because VE not enabled\n";
	}
	echo "########################################\n";
}

WikiFactory::clearInterwikiCache();
