<?php

$GLOBALS['wgAutoloadClasses']['CloseWikiPage'] = __DIR__ . '/../Close/SpecialCloseWiki_body.php';
$GLOBALS['wgSpecialPages']['CloseWiki'] = 'CloseWikiPage';

$GLOBALS['wgSuppressCommunityHeader'] = true;
$GLOBALS['$wgAllowSiteCSSOnRestrictedPages'] = false;
$GLOBALS['wgInlineStartupScript'] = true;

// load ALL ResourceLoader modules from shared domain
$GLOBALS['wgLoadScript'] = $GLOBALS['wgCdnRootUrl'] . $GLOBALS['wgLoadScript'];

// reset theme
SassUtil::$oasisSettings = $GLOBALS['wgOasisThemes']['oasis'];

/**
 * SUS-4734: Hijack MediaWiki execution early on to render the closed wiki error page
 */
$GLOBALS['wgExtensionFunctions'][] = function () {
	global $wgTitle, $wgOut, $wgDBname;

	$wgTitle = SpecialPage::getTitleFor( 'CloseWiki', "information/$wgDBname" );

	$context = $wgOut->getContext();

	$context->setTitle( $wgTitle );
	$context->setSkin( Skin::newFromKey( 'oasis' ) );

	$wgOut->disallowUserJs();
	$wgOut->setStatusCode( 410 );

	SpecialPageFactory::executePath( $wgTitle, $context );

	$wgOut->output();

	exit( 0 );
};

/**
 * Remove the "Special page" subtitle from the error page
 * @param $subtitle
 * @return bool
 */
$GLOBALS['wgHooks']['AfterPageHeaderSubtitle'][] = function ( &$subtitle ): bool {
	$subtitle = '';
	return false;
};
