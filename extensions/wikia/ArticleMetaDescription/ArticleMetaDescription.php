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
    'author' => array('[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]', '[http://seancolombo.com Sean Colombo]'),
    'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ArticleMetaDescription',
    'descriptionmsg' => 'articlemetadescription-desc'
];

//i18n
$wgExtensionMessagesFiles['ArticleMetaDescription'] = __DIR__ . '/ArticleMetaDescription.i18n.php';

$wgHooks['OutputPageBeforeHTML'][] = 'wfArticleMetaDescription';

/**
 * @param OutputPage $out
 * @param string $text
 * @return bool
 */
function wfArticleMetaDescription( OutputPage $out, string &$text ): bool {
	wfProfileIn( __METHOD__ );

	// Whether the description has already been added
	static $addedToPage = false;

	// The OutputPage::addParserOutput method calls the OutputPageBeforeHTML hook which can happen
	// more than once in a request.  Make sure we don't add two <meta> tags
	// https://wikia-inc.atlassian.net/browse/VID-2102
	if ( $addedToPage ) {
		wfProfileOut( __METHOD__ );
		return true;
	}

	$title = $out->getTitle();

	$sMessage = null;
	$sMainPage = wfMessage( 'Mainpage' )->inContentLanguage()->text();
	if ( strpos( $sMainPage, ':' ) !== false ) {
	    $sTitle = $title->getFullText();
	} else {
	    $sTitle = $title->getText();
	}

	if ( strcmp( $sTitle, $sMainPage ) == 0 ) {
		// we're on Main Page, check MediaWiki:Description message
		$sMessage = wfMessage( 'Description' )->text();
	}

	if ( $sMessage == null || wfEmptyMsg( 'Description' ) ) {
		$DESC_LENGTH = 300;
		$article = new Article( $title );
		$articleService = new ArticleService( $article );
		$description = $articleService->getTextSnippet( $DESC_LENGTH );
	} else {
		// MediaWiki:Description message found, use it
		$description = $sMessage;
	}

	if ( !empty( $description ) ) {
		$out->addMeta( 'description', htmlspecialchars( $description ) );
		$addedToPage = true;
	}

	wfProfileOut( __METHOD__ );
	return true;
}
