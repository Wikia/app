<?php
/**
 * @author Sean Colombo
 * @date 20110621
 *
 * Extension that makes the text snippets returned by the ArticleService::getTextSnippet()
 * be more useful on LyricWiki.
 */
 
 if ( ! defined( 'MEDIAWIKI' ) ){
	die("Extension file.  Not a valid entry point");
}

// Credits
$wgExtensionCredits['other'][] = array(
	"name" => "BetterLyricWikiTextSnippets",
	'descriptionmsg' => 'lw-snippets-desc',
	"url" => "http://lyrics.wikia.com/User_talk:Sean_Colombo",
	"author" => array('[http://lyrics.wikia.com/User:Sean_Colombo Sean Colombo]')
);

$dir = dirname(__FILE__);

// Internalization
$wgExtensionMessagesFiles['BetterLyricWikiTextSnippets'] = $dir . '/BetterLyricWikiTextSnippets.i18n.php';

// Hooks
$wgHooks['ArticleService::getTextSnippet::beforeStripping'][] = 'efLyricWikiGetTextSnippet';

/**
 * Hooked into ArticleService::getTextSnippet to give a more helpful result when used on LyricWiki.
 *
 * Will modify the value of 'content' parameter to cause any changes desired.
 */
function efLyricWikiGetTextSnippet(&$article, &$content, $length){
	$matches = array();

	// If the page contains lyrics, use that as the summary.
	if(0 < preg_match("/<(gracenotelyric|lyric)s?>(.*?)<\/(gracenotelyric|lyric)/is", $content, $matches)){
		$content = $matches[2];
	}

	return true;
} // end efLyricWikiGetTextSnippet()
