<?php
/**
 * @package MediaWiki
 * @subpackage SharedHelp
 *
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz <macbre(at)wikia-inc.com>
 * @author Lucas Garczewski <tor@wikia-inc.com>
 */

if(!defined('MEDIAWIKI')) {
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'SharedHelp',
	'version' => 0.24,
	'description' => 'Takes pages from [[w:c:Help|Help Wikia]] and inserts them into Help namespace on this wiki',
	'author' => array('Maciej Brencz', 'Inez Korczyński', 'Bartek Łapiński', "[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]", '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

$wgHooks['OutputPageBeforeHTML'][] = 'SharedHelpHook';
$wgHooks['EditPage::showEditForm:initial'][] = 'SharedHelpEditPageHook';
$wgHooks['BrokenLink'][] = 'SharedHelpBrokenLink';
$wgHooks['WantedPages::getSQL'][] = 'SharedHelpWantedPagesSql';

define( 'NOSHAREDHELP_MARKER', '<!--NOSHAREDHELP-->' );

class SharedHttp extends Http {
	static function get( $url, $timeout = 'default' ) {
		return self::request( "GET", $url, $timeout );
	}

	static function post( $url, $timeout = 'default' ) {
		return self::request( "POST", $url, $timeout );
	}

	static function request( $method, $url, $timeout = 'default' ) {
		global $wgHTTPTimeout, $wgHTTPProxy, $wgVersion, $wgTitle, $wgDevelEnvironment;

		wfDebug( __METHOD__ . ": $method $url\n" );
		# Use curl if available
		if ( function_exists( 'curl_init' ) ) {
			$c = curl_init( $url );
			/*
			if ( self::isLocalURL( $url ) ) {
				curl_setopt( $c, CURLOPT_PROXY, 'localhost:80' );
			} else if ($wgHTTPProxy) {
				curl_setopt($c, CURLOPT_PROXY, $wgHTTPProxy);
			}
			*/
			if (empty($wgDevelEnvironment)) {
				curl_setopt( $c, CURLOPT_PROXY, 'localhost:80' );
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
	global $wgTitle, $wgMemc, $wgSharedDB, $wgDBname, $wgCityId, $wgHelpWikiId, $wgContLang, $wgLanguageCode, $wgArticlePath;

	if(empty($wgHelpWikiId) || $wgCityId == $wgHelpWikiId) { # Do not proceed if we don't have a help wiki or are on it
		return true;
	}

	if(!$out->isArticle()) { # Do not process for pages other then articles
		return true;
	}

	# Do not process if explicitly told not to
	$mw = MagicWord::get('MAG_NOSHAREDHELP');
	if ( $mw->match( $text ) || strpos( $text, NOSHAREDHELP_MARKER ) !== false ) {
		return true;
	}

	if($wgTitle->getNamespace() == 12) { # Process only for pages in namespace Help (12)
		# Initialize shared and local variables
		# Canonical namespace is added here in case we ever want to share other namespaces (e.g. Advice)
		$sharedArticleKey = $wgSharedDB . ':sharedArticles:' . $wgHelpWikiId . ':' .
			MWNamespace::getCanonicalName( $wgTitle->getNamespace() ) .  ':' . $wgTitle->getDBkey();
		$sharedArticle = $wgMemc->get($sharedArticleKey);
		$sharedServer = unserialize(WikiFactory::getVarByName('wgServer', $wgHelpWikiId)->cv_value);
		$sharedScript = unserialize(WikiFactory::getVarByName('wgScript', $wgHelpWikiId)->cv_value);
		$sharedArticlePath = unserialize(WikiFactory::getVarByName('wgArticlePath', $wgHelpWikiId)->cv_value);
		$sharedArticlePathClean = str_replace('$1', '', $sharedArticlePath);
		$localArticlePathClean = str_replace('$1', '', $wgArticlePath);

		# Try to get content from memcache
		if ( !empty($sharedArticle['timestamp']) ) {
			if( (wfTimestamp() - (int) ($sharedArticle['timestamp'])) < 600) {
				if( isset($sharedArticle['exists']) && $sharedArticle['exists'] == 0 ) {
					return true;
				} else if (!empty($sharedArticle['cachekey'])) {
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
				}
			}
		}
		# If getting content from memcache failed (invalidate) then just download it via HTTP
		if(empty($content)) {
			$urlTemplate = $sharedServer . $sharedScript . "?title=Help:%s&action=render";
			$articleUrl = sprintf($urlTemplate, urlencode($wgTitle->getDBkey()));
			list($content, $c) = SharedHttp::get($articleUrl);

			# if we had redirect, then store it somewhere
			if(curl_getinfo($c, CURLINFO_HTTP_CODE) == 301) {
				if(preg_match("/^Location: ([^\n]+)/m", $content, $dest_url)) {
					$destinationUrl = $dest_url[1];
				}
			}
			global $wgServer, $wgArticlePath, $wgRequest, $wgTitle, $wgUser;
			$helpNs = $wgContLang->getNsText(NS_HELP);
			$sk = $wgUser->getSkin();

			if (!empty ($_SESSION ['SH_redirected'])) {
				$from_link = Title::newfromText( $helpNs . ":" . $_SESSION ['SH_redirected'] );
				$redir = $sk->makeKnownLinkObj( $from_link, '', 'redirect=no', '', '', 'rel="nofollow"' );
				$s = wfMsg( 'redirectedfrom', $redir );
				$out->setSubtitle( $s );
				$_SESSION ['SH_redirected'] = '';
			}

			if(isset($destinationUrl)) {
				$destinationPageIndex = strpos( $destinationUrl, "$helpNs:" );
				# if $helpNs was not found, assume we're on help.wikia.com and try again
				if ( $destinationPageIndex === false )
					$destinationPageIndex = strpos( $destinationUrl, MWNamespace::getCanonicalName(NS_HELP) . ":" );
				$destinationPage = substr( $destinationUrl, $destinationPageIndex );
				$link = $wgServer . str_replace( "$1", $destinationPage, $wgArticlePath );
				if ( 'no' != $wgRequest->getVal( 'redirect' ) ) {
					$_SESSION ['SH_redirected'] = $wgTitle->getText();
					$out->redirect( $link );
					$wasRedirected = true;
				} else {
					$content = "\n\n" . wfMsg( 'shared_help_was_redirect', "<a href=" . $link . ">$destinationPage</a>" );
				}
			} else {
				$tmp = split("\r\n\r\n", $content, 2);
				$content = isset($tmp[1]) ? $tmp[1] : '';
			}
			if(strpos($content, '"noarticletext"') > 0) {
				$sharedArticle = array('exists' => 0, 'timestamp' => wfTimestamp());
				$wgMemc->set($sharedArticleKey, $sharedArticle);
				return true;
			} else {
				$contentA = explode("\n", $content);
				$tmp = isset($contentA[count($contentA)-2]) ? $contentA[count($contentA)-2] : '';
				$idx1 = strpos($tmp, 'key');
				$idx2 = strpos($tmp, 'end');
				$key = trim(substr($tmp, $idx1+4, $idx2-$idx1));
				$sharedArticle = array('cachekey' => $key, 'timestamp' => wfTimestamp());
				$wgMemc->set($sharedArticleKey, $sharedArticle);
				wfDebug("SharedHelp: using parser cache {$sharedArticle['cachekey']}\n");
			}
			curl_close( $c );
		}

		if (empty($content)) return true;

		//process article if not redirected before
		if (empty($wasRedirected)) {
			# get rid of editsection links
			$content = preg_replace("|<span class=\"editsection\">\[<a href=\".*?\" title=\".*?\">.*?<\/a>\]<\/span>|", "", $content);
			$content = str_replace(
				array('showTocToggle();', '<table id="toc" class="toc"', '<div id="toctitle">'),
				array("showTocToggle('sharedtoctitle', 'sharedtoc', 'sharedtogglelink');", '<table id="sharedtoc" class="toc"', '<div id="sharedtoctitle" class="toctitle">'),
				$content);

			# namespaces to skip when replacing links
			$skipNamespaces = array();
			$skipNamespaces[] = $wgContLang->getNsText(NS_CATEGORY);
			$skipNamespaces[] = $wgContLang->getNsText(NS_IMAGE);
			$skipNamespaces[] = $wgContLang->getNsText(NS_FILE);
			if ( defined( NS_VIDEO ) ) {
				$skipNamespaces[] = $wgContLang->getNsText(NS_VIDEO);
			};
			$skipNamespaces[] = "Advice";
			if ($wgLanguageCode != 'en') {
				$skipNamespaces[] = MWNamespace::getCanonicalName(NS_CATEGORY);
				$skipNamespaces[] = MWNamespace::getCanonicalName(NS_IMAGE);
				if ( defined( NS_VIDEO ) ) {
					$skipNamespaces[] = MWNamespace::getCanonicalName(NS_VIDEO);
				}
			}

			# replace help wiki links with local links, except for special namespaces defined above
			$content = preg_replace("|{$sharedServer}{$sharedArticlePathClean}(?!" . implode(")(?!", $skipNamespaces) . ")|", $localArticlePathClean, $content);

			# replace help wiki project namespace with local project namespace
			$sharedMetaNamespace = unserialize(WikiFactory::getVarByName('wgMetaNamespace', $wgHelpWikiId)->cv_value);
			if ( empty( $sharedMetaNamespace ) ) {
				# use wgSitename if empty, per MW docs
				$sharedMetaNamespace = unserialize(WikiFactory::getVarByName('wgSitename', $wgHelpWikiId)->cv_value);
				$sharedMetaNamespace = str_replace( ' ', '_', $sharedMetaNamespace );
			}

			if ( !empty( $sharedMetaNamespace ) ) {
				global $wgMetaNamespace;
				$content = preg_replace(
					"|{$localArticlePathClean}{$sharedMetaNamespace}|",
					$localArticlePathClean . $wgMetaNamespace,
					$content
				);
			}

            /* Tomasz Odrobny #36016 */
            $sharedRedirectsArticlesKey = wfSharedMemcKey('sharedRedirectsArticles', $wgHelpWikiId, MWNamespace::getCanonicalName( $wgTitle->getNamespace() ), $wgTitle->getDBkey());
            $articleLink = $wgMemc->get($sharedRedirectsArticlesKey, null);

            if ( $articleLink == null ){
                $articleLink =  MWNamespace::getCanonicalName(NS_HELP_TALK) . ':' . $wgTitle->getDBkey();
                $apiUrl = $sharedServer."/api.php?action=query&redirects&format=json&titles=".$articleLink;
                $file = @file_get_contents($apiUrl, FALSE );
                $json = new Services_JSON();
                $APIOut = $json->decode($file);
                if (isset($APIOut->query) && isset($APIOut->query->redirects) && (count($APIOut->query->redirects) > 0) ){
                    $articleLink =  str_replace(" ", "_", $APIOut->query->redirects[0]->to);
                }
                $wgMemc->set($sharedRedirectsArticlesKey, $articleLink, 60*60*12);
            }

			// "this text is stored..."
            $info = '<div class="sharedHelpInfo plainlinks" style="text-align: right; font-size: smaller;padding: 5px">' . wfMsgExt('shared_help_info', 'parseinline', $sharedServer . $sharedArticlePathClean . $articleLink ) . '</div>';

			if(strpos($text, '"noarticletext"') > 0) {
				$text = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelp">' . $info . $content . '<div style="clear:both"></div></div>';
			} else {
				$text = $text . '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelp">' . $info . $content . '<div style="clear:both"></div></div>';
			}
		}
	}
	return true;
}

function SharedHelpEditPageHook(&$editpage) {
	global $wgTitle, $wgCityId, $wgHelpWikiId;

	// do not show this message on the help wiki
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

function SharedHelpBrokenLink( $linker, $nt, $query, $u, $style, $prefix, $text, $inside, $trail  ) {
	global $wgTitle;
	if (isset($wgTitle)) {
		$specialpage = SpecialPage::resolveAlias( $wgTitle->getDBkey() );
		if( ( $nt->getNamespace() == 12 ) && ( 'Wantedpages' != $specialpage ) ) {

			if (SharedHelpArticleExists($nt)) {
				//not red, blue
				$style = $linker->getInternalLinkAttributesObj( $nt, $text, '' );
				$u = str_replace( "&amp;action=edit&amp;redlink=1", "", $u );
				$u = str_replace( "?action=edit&amp;redlink=1&amp;", "?", $u );
				$u = str_replace( "?action=edit&amp;redlink=1", "", $u );
				$u .= $nt->getFragmentForURL();	//fix rt#11382
			}
		}
	}
	return true;
}

/**
 * does $title article exist @help.wikia?
 *
 * @see SharedHelpHook
 */
function SharedHelpArticleExists($title) {
	global $wgTitle, $wgMemc, $wgSharedDB, $wgHelpWikiId;

	$exists = false;

	$sharedLinkKey = $wgSharedDB . ':sharedLinks:' . $wgHelpWikiId . ':' .
		MWNamespace::getCanonicalName( $title->getNamespace() ) .  ':' . $title->getDBkey();
	$sharedLink = $wgMemc->get($sharedLinkKey);

	if ( $sharedLink ) {
		$exists =  true;
	} else {
		$sharedArticleKey = $wgSharedDB . ':sharedArticles:' . $wgHelpWikiId . ':' .
			MWNamespace::getCanonicalName( $title->getNamespace() ) .  ':' . $title->getDBkey();
		$sharedArticle = $wgMemc->get($sharedArticleKey);

		if ( !empty($sharedArticle['timestamp']) ) {
			$exists =  true;
		} else {
			wfProfileIn( __METHOD__ );

			$dbr = wfGetDB( DB_SLAVE, array(), WikiFactory::IDtoDB($wgHelpWikiId) );
			$res = $dbr->select(
				'page',
				'page_id',
				array(
					'page_namespace' => NS_HELP,
					'page_title' => $title->getDBkey(),
				),
				__METHOD__
			);

			if ( $row = $dbr->fetchObject( $res ) ) {
				if ( !empty($row->page_id) ) {
					$exists =  true;
				}
			}

			wfProfileOut( __METHOD__ );
		}

		if ($exists) $wgMemc->set($sharedLinkKey, true);
	}

	return $exists;
}

// basically modify the Wantedpages query to exclude pages that appear on the help wiki, as per #5866
function SharedHelpWantedPagesSql( $page, $sql ) {
	global $wgWantedPagesThreshold ;
	global $wgHelpWikiId, $wgMemc;
	wfProfileIn( __METHOD__ );

	$count = $wgWantedPagesThreshold - 1;
	$type = 'Wantedpages';

	$helpPages = "";
	$helpdb = WikiFactory::IDtoDB( $wgHelpWikiId  );

	if ($helpdb) {
		$helpPagesKey = "helppages:{$helpdb}";
		$helpArticles = $wgMemc->get($helpPagesKey);

		if ( empty($helpArticles) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $helpdb );
			$oRes = $dbr->select(
				'page',
				'page_title, page_namespace',
				array(
					'page_namespace' => NS_HELP,
					'page_is_redirect' => 0,
				),
				__METHOD__
			);

			$helpArticles = array(); while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$helpArticles[] = $oRow->page_title;
			}
			$helpPages = $dbr->makeList($helpArticles);
			$wgMemc->set($helpPagesKey, $helpPages, 12*60*60);
		} else {
			$helpPages = $helpArticles;
		}
	}

	$notInHelpPages = ""; if ( !empty($helpPages) ) {
		$notInHelpPages = " OR pl_title NOT IN (" . $helpPages . ") ";
	}

	$blogNamespaces = "";
	if ( defined('NS_BLOG_ARTICLE') ) {
		$blogNamespaces = "," . implode(",", array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK));
	}

	$sql = "SELECT '{$type}' AS type, pl_namespace AS namespace, pl_title AS title, COUNT(*) AS value
	FROM pagelinks
	LEFT JOIN page AS pg1 ON pl_namespace = pg1.page_namespace AND pl_title = pg1.page_title
	LEFT JOIN page AS pg2 ON pl_from = pg2.page_id
	WHERE pg1.page_namespace IS NULL
	AND pl_namespace NOT IN ( 2, 3 {$blogNamespaces})
	AND pg2.page_namespace != 8
	AND ( pl_namespace != 12 {$notInHelpPages} )
	{$page->excludetitles}
	GROUP BY pl_namespace, pl_title HAVING COUNT(*) > $count";

	wfProfileOut( __METHOD__ );
	return true;
}

# __NOSHAREDHELP__ magic word prevents rendering of shared content
$wgHooks['MagicWordwgVariableIDs'][] = 'efSharedHelpRegisterMagicWordID';
$wgHooks['LanguageGetMagic'][] = 'efSharedHelpGetMagicWord';
$wgHooks['InternalParseBeforeLinks'][] = 'efSharedHelpRemoveMagicWord';

function efSharedHelpRegisterMagicWordID(&$magicWords) {
	$magicWords[] = 'MAG_NOSHAREDHELP';
	return true;
}

function efSharedHelpGetMagicWord(&$magicWords, $langCode) {
	$magicWords['MAG_NOSHAREDHELP'] = array(0, '__NOSHAREDHELP__');
	return true;
}

function efSharedHelpRemoveMagicWord(&$parser, &$text, &$strip_state) {
	$found = MagicWord::get('MAG_NOSHAREDHELP')->matchAndRemove($text);
	if ( $found ) {
		$text .= NOSHAREDHELP_MARKER;
	}

	return true;
}
