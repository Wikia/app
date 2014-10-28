<?php
/**
 * ArticleMetaDescription - adding meta-description tag containing snippet of the Article
 *
 * Puts the snippet from the ArticleService into <meta description="..." /> tag inside
 * page header section. It's possible to set predefined description for main
 * page (configured in MediaWiki:Mainpage) by putting desired text
 * into the MediaWiki:Description message.
 *
 * @author Adrian 'ADi' Wieczorek <adi@wikia.com>
 * @author Sean Colombo <sean@wikia.com>
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
    die();
}

$wgExtensionCredits['other'][] = [
    'name' => 'ArticleMetaDescription',
    'version' => '1.1',
    'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek], [http://seancolombo.com Sean Colombo]',
    'description' => 'adding meta-description tag containing snippet of the Article, provided by the ArticleService'
];

$wgHooks['OutputPageBeforeHTML'][] = 'wfArticleMetaDescription';

// Whether the description has already been added
$wgArticleMetaDescriptionAdded = false;

/**
 * @param OutputPage $out
 * @param string $text
 * @return bool
 */
function wfArticleMetaDescription( &$out, &$text ) {
	wfProfileIn( __METHOD__ );

	$wg = F::app()->wg;

	// The OutputPage::addParserOutput method calls the OutputPageBeforeHTML hook which can happen
	// more than once in a request.  Make sure we don't add two <meta> tags
	// https://wikia-inc.atlassian.net/browse/VID-2102
	if ( $wg->ArticleMetaDescriptionAdded ) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	$sMessage = null;
	$sMainPage = wfMessage( 'Mainpage' )->inContentLanguage()->text();
	if ( strpos( $sMainPage, ':' ) !== false ) {
	    $sTitle = $wg->Title->getFullText();
	} else {
	    $sTitle = $wg->Title->getText();
	}

	if ( strcmp( $sTitle, $sMainPage ) == 0 ) {
		// we're on Main Page, check MediaWiki:Description message
		$sMessage = wfMessage( 'Description' );
	}

	if ( ( $sMessage == null ) || wfEmptyMsg( 'Description', $sMessage ) ) {
		$DESC_LENGTH = 100;
		$article = new Article( $wg->Title );
		$articleService = new ArticleService( $article );
		$description = $articleService->getTextSnippet( $DESC_LENGTH );
	} else {
		// MediaWiki:Description message found, use it
		$description = $sMessage;
	}

	if ( !empty( $description ) ) {
		$out->addMeta( 'description', htmlspecialchars( $description ) );
		$wg->ArticleMetaDescriptionAdded = true;
	}

	wfProfileOut( __METHOD__ );
	return true;
}
