<?php

$wgAutoloadClasses['CloseWikiPage'] = __DIR__ . '/../Close/SpecialCloseWiki_body.php';
$wgSpecialPages['CloseWiki'] = 'CloseWikiPage';

$wgSuppressCommunityHeader = true;
$wgAllowSiteCSSOnRestrictedPages = false;
$wgInlineStartupScript = true;

// load ALL ResourceLoader modules from shared domain
$wgLoadScript = $wgCdnRootUrl . $wgLoadScript;

// reset theme
SassUtil::$oasisSettings = $wgOasisThemes['oasis'];

/**
 * SUS-4734: Hijack MediaWiki execution early on to render the closed wiki error page
 */
$wgExtensionFunctions[] = function () {
	global $wgRequest, $wgTitle, $wgOut, $wgDBname;

	$requestUrl = $wgRequest->getRequestURL();

	// allow some other extensions  to render their content instead
	if ( !Hooks::run( 'ClosedWikiHandler', [ $requestUrl ] ) ) {
		return;
	}

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
$wgHooks['AfterPageHeaderSubtitle'][] = function ( &$subtitle ): bool {
	$subtitle = '';
	return false;
};

$wgHooks['GenerateRobotsRules'][] = function() {
	return false;
};
