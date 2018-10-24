<?php
$wgExtensionFunctions[] = function () {
	global $wgTitle, $wgOut, $wgRequest;

	$indexPage = '/language-wikis';

	$url = $wgRequest->getRequestURL();
	switch( $wgRequest->getRequestURL() ) {
		case '/':
			$wgRequest->response()->header( 'Location: ' . $indexPage , 301 );
			break;
		case $indexPage:
			$wgOut->disallowUserJs();

			$wgTitle = SpecialPage::getTitleFor( 'LanguageWikisIndex' );

			$context = $wgOut->getContext();

			$context->setTitle( $wgTitle );
			$context->setSkin( Skin::newFromKey( 'oasis' ) );


			SpecialPageFactory::executePath( $wgTitle, $context );
			$wgOut->output();
		default:
			http_response_code( 404 );
	}

	exit( 0 );
};

// Set up the new special page
$wgAutoloadClasses['LanguageWikisIndexController'] = __DIR__ . '/LanguageWikisIndexController.class.php';
$wgSpecialPages['LanguageWikisIndex'] = 'LanguageWikisIndexController';

