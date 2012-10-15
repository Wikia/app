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

if(!defined('MEDIAWIKI')) {
    echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
    die();
}

$wgExtensionCredits['other'][] = array(
    'name' => 'ArticleMetaDescription',
    'version' => '1.1',
    'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek], [http://seancolombo.com Sean Colombo]',
    'description' => 'adding meta-description tag containing snippet of the Article, provided by the ArticleService'
);

$wgHooks['OutputPageBeforeHTML'][] = 'wfArticleMetaDescription';

/**
 * @param OutputPage $out
 * @param string $text
 * @return bool
 */
function wfArticleMetaDescription(&$out, &$text) {
	global $wgTitle;
	wfProfileIn( __METHOD__ );

	$sMessage = null;
	$sMainPage = wfMsgForContent('Mainpage');
	if(strpos($sMainPage, ':') !== false) {
	    $sTitle = $wgTitle->getFullText();
	}
	else {
	    $sTitle = $wgTitle->getText();
	}

	if(strcmp($sTitle, $sMainPage) == 0) {
		// we're on Main Page, check MediaWiki:Description message
		$sMessage = wfMsg("Description");
	}

	if(($sMessage == null) || wfEmptyMsg("Description", $sMessage)) {
		$DESC_LENGTH = 100;
		$articleId = $wgTitle->getArticleID();
		$articleService = new ArticleService( $articleId );
		$description = $articleService->getTextSnippet( $DESC_LENGTH );
	} else {
		// MediaWiki:Description message found, use it
		$description = $sMessage;
	}

	if(!empty($description)) {
		$out->addMeta('description', htmlspecialchars($description));
	}

	wfProfileOut( __METHOD__ );
	return true;
}
