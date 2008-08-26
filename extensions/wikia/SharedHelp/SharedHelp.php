<?php
/**
 * @package MediaWiki
 * @subpackage SharedHelp
 *
 * @author Inez Korczynski <inez@wikia.com>
 */

if(!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgHooks['OutputPageBeforeHTML'][] = 'SharedHelpHook';

function SharedHelpHook(&$out, &$text) {
	global $wgTitle, $wgMemc, $wgSharedDB, $wgDBname;

	if($wgDBname == 'help') { # Do not process for help.wikia.com
		return true;
	}

	if(!$out->isArticle()) { # Do not process for pages other then articles
		return true;
	}

	if($wgTitle->getNamespace() == 12) { # Process only for pages in namespace Help (12)

		$sharedArticlesKey = $wgSharedDB . ':' . 'sharedArticles';
		$sharedArticles = $wgMemc->get($sharedArticlesKey);

		# Try to get content from memcache
		if(is_array($sharedArticles)) {
			if(isset($sharedArticles[$wgTitle->getDBkey()])) {
				if(isset($sharedArticles[$wgTitle->getDBkey()]['timestamp'])) {
			 		if(wfTimestamp() - (int) $sharedArticles[$wgTitle->getDBkey()]['timestamp'] < 600) {
			 			if(isset($sharedArticles[$wgTitle->getDBkey()]['cachekey'])) {
			 				$key1 = str_replace('-1!', '-0!', $sharedArticles[$wgTitle->getDBkey()]['cachekey']);
			 				$key2 = str_replace('-0!', '-1!', $sharedArticles[$wgTitle->getDBkey()]['cachekey']);
			 				$parser = $wgMemc->get($key1);
			 				if(!empty($parser) && is_object($parser)) {
			 					$content = $parser->mText;
			 				} else {
			 					$parser = $wgMemc->get($key2);
			 					if(!empty($parser) && is_object($parser)) {
			 						$content = $parser->mText;
			 					}
			 				}
			 			} else if($sharedArticles[$wgTitle->getDBkey()]['exists'] == 0) {
			 				return true;
			 			}
			 		}
			 	}
			}
		}

		# If getting content from memcache failed (invalidate) then just download it via HTTP
		if(empty($content)) {
			$urlTemplate = "http://help.wikia.com/index.php?title=Help:%s&action=render";
			$articleUrl = sprintf($urlTemplate, $wgTitle->getDBkey());
			$content = HTTP::get($articleUrl);

			if(strpos($content, '"noarticletext"') > 0) {
				$sharedArticles[$wgTitle->getDBkey()] = array('exists' => 0, 'timestamp' => wfTimestamp());
				$wgMemc->set($sharedArticlesKey, $sharedArticles);
				return true;
			} else {
				$contentA = split("\n", $content);
				$tmp = $contentA[count($contentA)-2];
				$idx1 = strpos($tmp, 'key');
				$idx2 = strpos($tmp, 'end');
				$key = trim(substr($tmp, $idx1+4, $idx2-$idx1));
				$sharedArticles[$wgTitle->getDBkey()] = array('cachekey' => $key, 'timestamp' => wfTimestamp());
				$wgMemc->set($sharedArticlesKey, $sharedArticles);
			}
		}

		$content = preg_replace("|<span class=\"editsection\">\[<a href=\"(.*?)\" title=\"(.*?)\">(.*?)<\/a>\]<\/span>|", "", $content);
		$content = str_replace("http://help.wikia.com/wiki/Help:","/wiki/Help:",$content);

		if(strpos($text, '"noarticletext"') > 0) {
			$text = "<div style='border: solid 1px;padding: 10px;margin: 5px;'>" . $content . "</div>";
		} else {
			$text = "<div style='border: solid 1px;padding: 10px;margin: 5px;'>" . $content . "</div><br/>" . $text;
		}
	}
	return true;
}