<?php
if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

// Hooks registration:
global $wgHooks;
$wgHooks['AjaxAddScript'][] = 'wfAjaxQueryPagesAddJS';

// Insert our javascript only for QueryPages
function wfAjaxQueryPagesAddJS( $out ) {
	global $wgTitle;
	if( $wgTitle->getNamespace() != NS_SPECIAL ) {
		return true;
	}
	global $wgQueryPages;
	if( !$spObj = SpecialPage::getPageByAlias( $wgTitle->getDBkey() )
		or !(isset($wgQueryPages) ) ) {
		return true;
	}

	global $wgJsMimeType, $wgScriptPath ;
	$out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgScriptPath/extensions/AjaxQueryPages/AjaxQueryPages.js\"></script>\n" );
	return true;
}


