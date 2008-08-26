<?php
/**
 * ArticleMetaDescription - adding meta-description tag containing snippet of the Article
 * 
 * It takes first paragraph of the article and put into <meta description="..." /> tag inside
 * page header section. All templates (infoboxes, tables etc.) are ignored by default. It's
 * possible to set predefined description for main page (configured in MediaWiki:Mainpage) by 
 * putting desired text into MediaWiki:Description message. 
 *
 * @author Adrian 'ADi' Wieczorek <adi@wikia.com>
 *
 */

if(!defined('MEDIAWIKI')) {
    echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
    die();
}

$wgExtensionCredits['other'][] = array(
    'name' => 'ArticleMetaDescription',
    'version' => '1.0',
    'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
    'description' => 'adding meta-description tag containing snippet of the Article'
);

$wgHooks['OutputPageBeforeHTML'][] = 'wfArticleMetaDescription';

function wfArticleMetaDescription(&$out, &$text) {
	global $wgTitle;
		
	$sMessage = null;
	$sMainPage = wfMsgForContent('Mainpage');
	if(eregi(':', $sMainPage)) {
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
		$tmp = preg_replace('/<table[^>]*>.*<\/table>/siU', '', $text);
		$tmp = preg_replace('/<div[^>]*>.*<\/div>/siU', '', $tmp);
		$tmp = preg_replace('/<style[^>]*>.*<\/style>/siU', '', $tmp);
		$tmp = preg_replace('/<script[^>]*>.*<\/script>/siU', '', $tmp);
		$tmp = preg_replace('/\n|\t/', ' ', $tmp);
		$tmp = strip_tags($tmp, '<p>');
	
		$matches = null;
		preg_match_all('/<p>(.*)<\/p>/siU', $tmp, $matches);
		if(count($matches)) {
			$paragraphs = $matches[1];
			$description = "";
			foreach($paragraphs as $paragraph) {
				$paragraph = trim($paragraph);
				if(!empty($paragraph)) {
					$description = $paragraph;
					break;
				}
			}
		}		

	}
	else {
		// MediaWiki:Description message found, use it
		$description = $sMessage;

	}
	
	if(!empty($description)) {
		$out->addMeta('description', htmlspecialchars($description));
	}

	return true;
}
