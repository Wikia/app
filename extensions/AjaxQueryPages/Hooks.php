<?php
if ( !defined( 'MEDIAWIKI' ) )
	die( 1 );

// Insert our javascript only for QueryPages
function wfAjaxQueryPagesAddJS( $out ) {
	global $wgExtensionAssetsPath;

	if ( $out->getTitle()->getNamespace() == NS_SPECIAL &&
		SpecialPage::getPageByAlias( $out->getTitle()->getDBkey() )
	) {
		$out->addScriptFile( "$wgExtensionAssetsPath/AjaxQueryPages/AjaxQueryPages.js" );
	}

	return true;
}
