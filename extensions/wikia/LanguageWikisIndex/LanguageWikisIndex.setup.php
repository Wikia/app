<?php
/*
 * Special page included on domain root when language wikis exist without the English wiki.
 */
$wgAutoloadClasses['LanguageWikisIndexController'] = __DIR__ . '/LanguageWikisIndexController.class.php';
$wgSpecialPages['LanguageWikisIndex'] = 'LanguageWikisIndexController';

$wgExtensionFunctions[] = function () {
	global $wgTitle, $wgOut, $wgRequest, $wgSuppressCommunityHeader, $wgSuppressPageHeader;

	$indexPage = '/language-wikis';

	switch( $wgRequest->getRequestURL() ) {
		case '/':
			// use 302, maybe at some point an English wiki gets created
			$wgRequest->response()->header( 'Location: ' . $indexPage , 302 );
			break;
		case $indexPage:
			$wgOut->disallowUserJs();

			$wgTitle = SpecialPage::getTitleFor( 'LanguageWikisIndex' );

			$context = $wgOut->getContext();

			$context->setTitle( $wgTitle );
			$context->setSkin( Skin::newFromKey( 'oasis' ) );
			$wgSuppressCommunityHeader = true;
			$wgSuppressPageHeader = true;

			SpecialPageFactory::executePath( $wgTitle, $context );
			$wgOut->output();
		default:
			// TODO: display something here?
			http_response_code( 404 );
	}

	exit( 0 );
};
