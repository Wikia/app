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
	'version' => 0.17,
        'description' => 'Takes pages from [[w:c:Help|Help Wikia]] and inserts them into Help namespace on this wiki',
        'author' => array('Maciej Brencz, Inez Korczyński, Bartek Łapiński')
);

$wgHooks['OutputPageBeforeHTML'][] = 'SharedHelpHook';
$wgHooks['EditPage::showEditForm:initial'][] = 'SharedHelpEditPageHook';
$wgHooks['SearchBeforeResults'][] = 'SharedHelpSearchHook';
$wgHooks['BrokenLink'][] = 'SharedHelpBrokenLink';

class SharedHttp extends Http {

        static function get( $url, $timeout = 'default' ) {
                return self::request( "GET", $url, $timeout );
        }

        static function post( $url, $timeout = 'default' ) {
                return self::request( "POST", $url, $timeout );
        }

        static function request( $method, $url, $timeout = 'default' ) {
		global $wgHTTPTimeout, $wgHTTPProxy, $wgVersion, $wgTitle;

		wfDebug( __METHOD__ . ": $method $url\n" );
		# Use curl if available
		if ( function_exists( 'curl_init' ) ) {
			$c = curl_init( $url );
			if ( self::isLocalURL( $url ) ) {
				curl_setopt( $c, CURLOPT_PROXY, 'localhost:80' );
			} else if ($wgHTTPProxy) {
				curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy);
			}

			if ( $timeout == 'default' ) {
				$timeout = $wgHTTPTimeout;
			}
			curl_setopt( $c, CURLOPT_TIMEOUT, $timeout );
	
			curl_setopt( $c, CURLOPT_HEADER, true );
			curl_setopt( $c, CURLOPT_FOLLOWLOCATION, false );
			
			curl_setopt( $c, CURLOPT_USERAGENT, "MediaWiki/$wgVersion" );
			if ( $method == 'POST' )
				curl_setopt( $c, CURLOPT_POST, true );
			else
				curl_setopt( $c, CURLOPT_CUSTOMREQUEST, $method );

			# Set the referer to $wgTitle, even in command-line mode
			# This is useful for interwiki transclusion, where the foreign
			# server wants to know what the referring page is.
			# $_SERVER['REQUEST_URI'] gives a less reliable indication of the
			# referring page.
			if ( is_object( $wgTitle ) ) {
				curl_setopt( $c, CURLOPT_REFERER, $wgTitle->getFullURL() );
			}

			ob_start();
			curl_exec( $c );
			$text = ob_get_contents();
			ob_end_clean();

                        # Don't return the text of error messages, return false on error
                        if ( ( curl_getinfo( $c, CURLINFO_HTTP_CODE ) != 200 ) && ( curl_getinfo( $c, CURLINFO_HTTP_CODE ) != 301 ) ) {
                        	$text = false;
			}
                        # Don't return truncated output
                        if ( curl_errno( $c ) != CURLE_OK ) {
                                $text = false;
                        }
                } else {
                }
                return array( $text, $c );
	}

}

function SharedHelpHook(&$out, &$text) {
	global $wgTitle, $wgMemc, $wgSharedDB, $wgDBname, $wgCityId, $wgHelpWikiId;

	if($wgCityId == $wgHelpWikiId) { # Do not process for help.wikia.com
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
			global $wgDevelEnvironment;
			if (empty($wgDevelEnvironment)) {
	
				$urlTemplate = "http://help.wikia.com/index.php?title=Help:%s&action=render";
			}
			else {
				$urlTemplate = "http://help.macbre.dev.poz.wikia-inc.com/index.php?title=Help:%s&action=render"; // for testing purposes
			}
	
			$articleUrl = sprintf($urlTemplate, $wgTitle->getDBkey());
			list($content, $c) = SharedHttp::get($articleUrl);

			# if we had redirect, then store it somewhere 
			if(curl_getinfo($c, CURLINFO_HTTP_CODE) == 301) {
				if(preg_match("/^Location: ([^\n]+)/m", $content, $dest_url)) {
					$destinationUrl = $dest_url[1];
				}
			}
			if(isset($destinationUrl)) {
				global $wgServer, $wgArticlePath ;
				$destinationPage = substr( $destinationUrl, strpos( $destinationUrl, 'Help:') );
				$out->redirect( $wgServer . str_replace( "$1", $destinationPage, $wgArticlePath ) );
			} else {
				$tmp = split("\r\n\r\n", $content, 2);
				$content = $tmp[1];
			}
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
                        curl_close( $c );
		}

		$content = preg_replace("|<span class=\"editsection\">\[<a href=\"(.*?)\" title=\"(.*?)\">(.*?)<\/a>\]<\/span>|", "", $content);
		$content = str_replace("http://help.wikia.com/wiki", "/wiki", $content);
                $content = str_replace("/wiki/Category", "http://help.wikia.com/wiki/Category", $content);
                $content = str_replace("/wiki/Advice", "http://help.wikia.com/wiki/Advice", $content);

		// "this text is stored..."
		$info = '<div class="sharedHelpInfo" style="text-align: right; font-size: smaller;padding: 5px">' . wfMsgExt('shared_help_info', 'parseinline', $wgTitle->getDBkey()) . '</div>';

		if(strpos($text, '"noarticletext"') > 0) {
			$text = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelp">' . $info . $content . '<div style="clear:both"></div></div>';
		} else {
			$text = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelp">' . $info . $content . '<div style="clear:both"></div></div><br/>' . $text;
		}
	}
	return true;
}

function SharedHelpEditPageHook(&$editpage) {
	global $wgTitle, $wgCityId, $wgHelpWikiId;

	// do not show this message on help.wikia.com
	if ($wgCityId == $wgHelpWikiId) {
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
	global $wgOut, $wgCityId, $wgHelpWikiId;

	// do not show this message on help.wikia.com
	if ($wgCityId == $wgHelpWikiId) {
		return true;
	}

	$msg = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelpSearchInfo plainlinks">'.wfMsgExt('shared_help_search_info', 'parseinline', urlencode($term)).'</div>';

	$wgOut->addHTML($msg);

	return true;
}


function SharedHelpBrokenLink( $linker, $nt, $query, $u, $style, $prefix, $text, $inside, $trail  ) {
	if ($nt->getNamespace() == 12) {
		//not red, blue
		$style = $linker->getInternalLinkAttributesObj( $nt, $text, '' );
		$u = str_replace( "&amp;action=edit&amp;redlink=1", "", $u );
		$u = str_replace( "?action=edit&amp;redlink=1&amp;", "?", $u );
		$u = str_replace( "?action=edit&amp;redlink=1", "", $u );	
	}
	return true;
}

