<?php
/**
 * @package MediaWiki
 * @subpackage SharedHelp
 *
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz <macbre(at)wikia-inc.com>
 */

if(!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
        'name' => 'SharedHelp',
	'version' => 0.1,
        'description' => 'Takes pages from [[w:c:Help|Help Wikia]] and inserts them into Help namespace on this wiki',
        'author' => array('Maciej Brencz, Inez Korczyński')
);

$wgHooks['OutputPageBeforeHTML'][] = 'SharedHelpHook';
$wgHooks['EditPage::showEditForm:initial'][] = 'SharedHelpEditPageHook';
$wgHooks['SearchBeforeResults'][] = 'SharedHelpSearchHook';
$wgHooks['ParserReplaceLinkHolders'][] = 'SharedHelpReplaceLinkHolders';

function SharedHelpHook(&$out, &$text) {
	global $wgTitle, $wgMemc, $wgSharedDB, $wgDBname, $wgCityId;

	if($wgCityId == 3322) { # Do not process for help.wikia.com
		return true;
	}

	if(!$out->isArticle()) { # Do not process for pages other then articles
		return true;
	}

	if($wgTitle->getNamespace() == 12) { # Process only for pages in namespace Help (12)

		$sharedArticleKey = $wgSharedDB . ':sharedArticles:' . $wgTitle->getDBkey();
		$sharedArticle = $wgMemc->get($sharedArticleKey);

		# Try to get content from memcache
		if ( !empty($sharedArticle['timestamp']) ) {
	 		if( (wfTimestamp() - (int) ($sharedArticle['timestamp'])) < 600) {
	 			if(isset($sharedArticle['cachekey'])) {
					wfDebug("SharedHelp: trying parser cache {$sharedArticle['cachekey']}\n");
					$key1 = str_replace('-1!', '-0!', $sharedArticle['cachekey']);
	 				$key2 = str_replace('-0!', '-1!', $sharedArticle['cachekey']);
	 				$parser = $wgMemc->get($key1);
	 				if(!empty($parser) && is_object($parser)) {
						$content = $parser->mText;
					} else {
						$parser = $wgMemc->get($key2);
						if(!empty($parser) && is_object($parser)) {
							$content = $parser->mText;
						}
					}
				} else if($sharedArticle['exists'] == 0) {
	 				return true;
				}
			}
		}

		# If getting content from memcache failed (invalidate) then just download it via HTTP
		if(empty($content)) {
			if (empty($wgDevelEnvironment)) {
				$urlTemplate = "http://help.wikia.com/index.php?title=Help:%s&action=render";
			}
			else {
				$urlTemplate = "http://help.macbre.dev.poz.wikia-inc.com/index.php?title=Help:%s&action=render"; // for testing purposes
			}

			$articleUrl = sprintf($urlTemplate, $wgTitle->getDBkey());
			$content = HTTP::get($articleUrl);

			if(strpos($content, '"noarticletext"') > 0) {
				$sharedArticle = array('exists' => 0, 'timestamp' => wfTimestamp());
				$wgMemc->set($sharedArticleKey, $sharedArticle);
				return true;
			} else {
				$contentA = explode("\n", $content);
				$tmp = $contentA[count($contentA)-2];
				$idx1 = strpos($tmp, 'key');
				$idx2 = strpos($tmp, 'end');
				$key = trim(substr($tmp, $idx1+4, $idx2-$idx1));
				$sharedArticle = array('cachekey' => $key, 'timestamp' => wfTimestamp());
				$wgMemc->set($sharedArticleKey, $sharedArticle);
				wfDebug("SharedHelp: using parser cache {$sharedArticle['cachekey']}\n");
			}
		}

		$content = preg_replace("|<span class=\"editsection\">\[<a href=\"(.*?)\" title=\"(.*?)\">(.*?)<\/a>\]<\/span>|", "", $content);
		$content = str_replace("http://help.wikia.com/wiki/Help:", "/wiki/Help:", $content);

		// "this text is stored..."
		$info = '<div class="sharedHelpInfo" style="text-align: right; font-size: smaller;padding: 5px">' . wfMsgExt('shared_help_info', 'parseinline', $wgTitle->getDBkey()) . '</div>';

		if(strpos($text, '"noarticletext"') > 0) {
			$text = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelp">' . $info . $content . '</div>';
		} else {
			$text = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelp">' . $info . $content . '</div><br/>' . $text;
		}
	}
	return true;
}

function SharedHelpEditPageHook(&$editpage) {
	global $wgTitle, $wgCityId;

	// do not show this message on help.wikia.com
	if ($wgCityId == 3322) {
		return true;
	}

	// show message only when editing pages from Help namespace
	if ( $wgTitle->getNamespace() != 12 ) {
		return true;
	}

	$msg = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelpEditInfo">'.wfMsgExt('shared_help_edit_info', 'parseinline', $wgTitle->getDBkey()).'</div>';

	$editpage->editFormPageTop .= $msg;

	return true;
}

function SharedHelpSearchHook(&$searchPage, &$term) {
	global $wgOut, $wgCityId;

	// do not show this message on help.wikia.com
	if ($wgCityId == 3322) {
		return true;
	}

	$msg = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelpSearchInfo plainlinks">'.wfMsgExt('shared_help_search_info', 'parseinline', urlencode($term)).'</div>';

	$wgOut->addHTML($msg);

	return true;
}


function SharedHelpReplaceLinkHolders($title, $colours, $key) {
	if ($title->getNamespace() == 12) {
		$dbr = wfGetDB( DB_SLAVE );
		$table = 'help.'.$dbr->tableName('page');
		$page_title = $dbr->selectField($table, 'page_title', array('page_namespace' => 12, 'page_title' => $title->getDBkey()), __METHOD__);
		$colours[$key] = $page_title !== false ? '' : 'new';
	}
	return true;
}
