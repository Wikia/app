<?php
/**
 * Front and Back Matter and Forced Wikilinks extension by Tisane
 * URL: http://www.mediawiki.org/wiki/Extension:FrontBackMatterForcedWikilinks
 *
 * This program is free software. You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. You can also redistribute it and/or
 * modify it under the terms of the Creative Commons Attribution 3.0 license.
 *
 * This program prepends front matter and appends back matter to pages and
 * implements forced wikilinks.
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the
#	special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install the Front and Back Matter and Forced Wikilinks extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/FrontBackMatterForcedWikilinks/FrontBackMatterForcedWikilinks.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Front and Back Matter and Forced Wikilinks',
	'author' => 'Tisane',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FrontBackMatterForcedWikilinks',
	'descriptionmsg' => 'frontbackforced-desc',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FrontBackMatterForcedWikilinks'] = $dir . 'FrontBackMatterForcedWikilinks.i18n.php';

$wgHooks['ParserBeforeStrip'][] = 'FrontBackForcedParserBeforeStripHook';
$wgHooks['ArticleSaveComplete'][] = 'FrontBackForcedArticleSaveCompleteHook';

function FrontBackForcedParserBeforeStripHook( &$parser, &$text, &$strip_state ) {
	global $wgLang;
	
	$frontMsg=wfMsgForContent( 'frontbackforced-front' );
	$backMsg=wfMsgForContent( 'frontbackforced-back' );
	$forcedMsg=wfMsgForContent( 'frontbackforced-forced' );
	$dbr = wfGetDB( DB_SLAVE );
	$title=$parser->getTitle();
	if( $title->getNamespace() == NS_SPECIAL
		|| $title->getNamespace() == NS_MEDIA
		|| $title->getNamespace() == NS_FILE
		|| $title->isExternal()) {
			return true;
		}
	$myRevision=Revision::loadFromTitle($dbr,$title);
	if ($myRevision!=null){
		$myText=$myRevision->getRawText ();
		if ($text==$myText){
			$frontMatterTitle=Title::newFromDBkey($title->getPrefixedDBkey().$frontMsg);
			$frontMatterRev=Revision::loadFromTitle($dbr,$frontMatterTitle);
			if ($frontMatterRev!=null){
				$frontMatterText=$frontMatterRev->getRawText();
				$text=$frontMatterText.$text;
			}
			$backMatterTitle=Title::newFromDBkey($title->getPrefixedDBkey().$backMsg);
			$backMatterRev=Revision::loadFromTitle($dbr,$backMatterTitle);
			if ($backMatterRev!=null){
				$backMatterText=$backMatterRev->getRawText();
				$text=$text.$backMatterText;
			}
			$forcedMatterTitle=Title::newFromDBkey($title->getPrefixedDBkey().$forcedMsg);
			$forcedMatterRev=Revision::loadFromTitle($dbr,$forcedMatterTitle);
			if ($forcedMatterRev!=null){
				$forcedMatterText=$forcedMatterRev->getRawText();
				$strPosition=0;
				$endPosition=0;
				$endSubstPosition=0;
				$thisCount=0;
				while (1){
					$oldStrPosition=$strPosition;
					$strPosition=strpos($forcedMatterText,'>',$strPosition);
					if ($strPosition===false || $strPosition<=$oldStrPosition && $thisCount>0){
						break;
					}
					$oldEndPosition=$endPosition;
					$endPosition=strpos($forcedMatterText,'<',$strPosition);
					if ($endPosition===false || $endPosition<=$oldEndPosition && $thisCount>0){
						break;
					}
					$wfyText=substr($forcedMatterText,$strPosition+1,$endPosition-$strPosition-1);
					$oldEndSubstPosition=$endSubstPosition;
					$endSubstPosition=strpos($forcedMatterText,'#',$endPosition);
					if ($endSubstPosition===false || $endSubstPosition-$endPosition==1 || $endSubstPosition<=$oldEndSubstPosition  && $thisCount>0){
						$wfyToText=$wfyText;
					} else {
						$wfyToText=substr($forcedMatterText,$endPosition+1,$endSubstPosition-$endPosition-1);
					}
					$articleStartPos=strpos($text,$wfyText);
					$continueThis=true;
					if ($articleStartPos===false){
						$continueThis=false;
					}
					if ($articleStartPos>2){
						if (substr($text,$articleStartPos-2,2)=='[['){
							$continueThis=false;
						}
					}
					if ($continueThis==true){
						$text=substr($text,0,$articleStartPos).'[['.$wfyToText.'|'.$wfyText.']]'.substr($text,$articleStartPos+strlen($wfyText),strlen($text)-$articleStartPos-strlen($wfyText));
					}
					$thisCount++;
					$strPosition++;
				}
			}
		}
	}
		
	return true;
}

function FrontBackForcedArticleSaveCompleteHook (&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ){
	global $wgLang;
	
	$frontMsg=wfMsgForContent( 'frontbackforced-front' );
	$backMsg=wfMsgForContent( 'frontbackforced-back' );
	$forcedMsg=wfMsgForContent( 'frontbackforced-forced' );
	$myTitle=$article->getTitle()->getPrefixedDBkey();
	if (substr($myTitle,strlen($myTitle)-strlen($frontMsg),strlen($frontMsg))==$frontMsg){
		$frontBaseTitle=Title::newFromDBkey(substr($myTitle,0,strlen($myTitle)-strlen($frontMsg)));
		$frontBaseTitle->invalidateCache();
		Article::onArticleCreate($frontBaseTitle);
		Article::onArticleEdit($frontBaseTitle);
	}
	if (substr($myTitle,strlen($myTitle)-strlen($backMsg),strlen($backMsg))==$backMsg){
		$backBaseTitle=Title::newFromDBkey(substr($myTitle,0,strlen($myTitle)-strlen($backMsg)));
		$backBaseTitle->invalidateCache();
		Article::onArticleCreate($backBaseTitle);
		Article::onArticleEdit($backBaseTitle);
	}
	if (substr($myTitle,strlen($myTitle)-strlen($forcedMsg),strlen($forcedMsg))==$forcedMsg){
		$forcedBaseTitle=Title::newFromDBkey(substr($myTitle,0,strlen($myTitle)-strlen($forcedMsg)));
		$forcedBaseTitle->invalidateCache();
		Article::onArticleCreate($forcedBaseTitle);
		Article::onArticleEdit($forcedBaseTitle);
	}
	return true;
}