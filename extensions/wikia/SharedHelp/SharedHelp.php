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
	'version' => '0.26',
	'descriptionmsg' => 'sharedhelp-desc',
	'author' => array('Maciej Brencz', 'Inez Korczyński', 'Bartek Łapiński', "[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]", '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SharedHelp'
);

$wgHooks['OutputPageBeforeHTML'][] = 'SharedHelpHook';
$wgHooks['EditPage::showEditForm:initial'][] = 'SharedHelpEditPageHook';
$wgHooks['LinkBegin'][] = 'SharedHelpLinkBegin';
$wgHooks['WikiaCanonicalHref'][] = 'SharedHelpCanonicalHook';
$wgHooks['SpecialSearchProfiles'][] = 'efSharedHelpSearchProfilesHook';


/* in MW 1.19 WantedPages::getSQL hook changes into WantedPages::getQueryInfo */
$wgHooks['WantedPages::getExcludedNamespaces'][] = 'SharedHelpWantedPagesSql';

define( 'NOSHAREDHELP_MARKER', '<!--NOSHAREDHELP-->' );
define( 'SHAREDHELP_CACHE_VERSION', 3 );

/**
 * @param OutputPage $out
 * @param string $text
 * @return bool
 * @throws MWException
 */
function SharedHelpHook( OutputPage $out, string &$text ): bool {
	global $wgMemc, $wgCityId, $wgHelpWikiId, $wgContLang, $wgLanguageCode, $wgArticlePath;

	/* Insurance that hook will be called only once #BugId:  */
	static $wasCalled = false;

	if($wasCalled == true){
		return true;
	}
	$wasCalled = true;

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

	$title = $out->getTitle();
	if ( $title->inNamespace( NS_HELP ) ) {
		# Initialize shared and local variables
		# Canonical namespace is added here in case we ever want to share other namespaces (e.g. Advice)
		$sharedArticleKey = wfSharedMemcKey(
			'sharedArticles',
			$wgHelpWikiId,
			md5(MWNamespace::getCanonicalName( $title->getNamespace() ) . ':' . $title->getDBkey() ),
			SHAREDHELP_CACHE_VERSION
		);
		$sharedArticle = $wgMemc->get($sharedArticleKey);
		$cityUrl = WikiFactory::cityIDtoUrl( $wgHelpWikiId );
		$sharedServer = WikiFactory::cityUrlToDomain( $cityUrl );
		$sharedScript = WikiFactory::cityUrlToWgScript( $cityUrl );
		$sharedArticlePath = WikiFactory::cityUrlToArticlePath( $cityUrl, $wgHelpWikiId );

		$sharedArticlePathClean = str_replace('$1', '', $sharedArticlePath);
		$localArticlePathClean = str_replace('$1', '', $wgArticlePath);

		# Try to get content from memcache
		if ( isset( $sharedArticle['exists'] ) && $sharedArticle['exists'] == 0 ) {
			return true;
		} elseif ( !empty( $sharedArticle['cachekey'] ) ) {
			wfDebug( "SharedHelp: trying parser cache {$sharedArticle['cachekey']}\n" );
			$key1 = str_replace( '-1!', '-0!', $sharedArticle['cachekey'] );
			$key2 = str_replace( '-0!', '-1!', $sharedArticle['cachekey'] );
			$parser = $wgMemc->get( $key1 );
			if ( !empty( $parser ) && is_object( $parser ) ) {
				$content = $parser->mText;
			} else {
				$parser = $wgMemc->get( $key2 );
				if ( !empty( $parser ) && is_object( $parser ) ) {
					$content = $parser->mText;
				}
			}
		}

		if(!empty($content)) {
			# get rid of magic word editsection (non parsed piece causing double section headers)
			$content = preg_replace("|<mw:editsection( .*)?>.*?</mw:editsection>|", "", $content);
		} else {# If getting content from memcache failed (invalidate) then just download it via HTTP
			$urlTemplate = $sharedServer . $sharedScript . "?title=Help:%s&action=render";
			$articleUrl = sprintf( $urlTemplate, urlencode( $title->getDBkey() ) );
			$content = Http::get( $articleUrl );

			if ( $content === false ) {
				$sharedArticle = [ 'exists' => 0, 'timestamp' => wfTimestamp() ];
				$wgMemc->set( $sharedArticleKey, $sharedArticle, 60 * 60 * 24 );
				return true;
			}

			if(strpos($content, '"noarticletext"') > 0) {
				$sharedArticle = array('exists' => 0, 'timestamp' => wfTimestamp());
				$wgMemc->set( $sharedArticleKey, $sharedArticle, 60 * 60 * 24 );
				return true;
			} else {
				$contentA = explode("\n", $content);
				$tmp = isset($contentA[count($contentA)-2]) ? $contentA[count($contentA)-2] : '';
				$idx1 = strpos($tmp, 'key');
				$key = trim( substr( $tmp, $idx1+4, -4 ) );
				$sharedArticle = array('cachekey' => $key, 'timestamp' => wfTimestamp());
				$wgMemc->set( $sharedArticleKey, $sharedArticle, 60 * 60 * 24 );
				wfDebug("SharedHelp: using parser cache {$sharedArticle['cachekey']}\n");
			}
		}

		if ( empty( $content ) ) {
			return true;
		} else {
			// So we don't return 404s for local requests to these pages as they have content (BugID: 44611)
			$out->setStatusCode( 200 );
		}

		//process article if not redirected before
		if (empty($wasRedirected)) {
			# get rid of editsection links
			$content = preg_replace("|<span class=\"editsection( .*)?\"><a href=\".*?\" title=\".*?\">.*?<\/a><\/span>|", "", $content);
			$content = strtr($content,
				array(
					'showTocToggle();' => "showTocToggle('sharedtoctitle', 'sharedtoc', 'sharedtogglelink');",
					'<table id="toc" class="toc"' => '<table id="sharedtoc" class="toc"',
					'<div id="toctitle">' => '<div id="sharedtoctitle" class="toctitle">',
					// BugId:981 - mark images coming from SharedHelp
					'data-image-name' => 'data-shared-help="true" data-image-name',
				));

			# namespaces to skip when replacing links
			$skipNamespaces = array();
			$skipNamespaces[] = $wgContLang->getNsText(NS_CATEGORY);
			$skipNamespaces[] = $wgContLang->getNsText(NS_IMAGE);
			$skipNamespaces[] = $wgContLang->getNsText(NS_FILE);

			$skipNamespaces[] = "Advice";
			if ($wgLanguageCode != 'en') {
				$skipNamespaces[] = MWNamespace::getCanonicalName(NS_CATEGORY);
				$skipNamespaces[] = MWNamespace::getCanonicalName(NS_IMAGE);
			}
			$skipNamespaces[] = 'Special:Search'; // Stop hard coded Search on Community Central being removed

			# replace help wiki links with local links, except for special namespaces defined above
			$content = preg_replace("|{$sharedServer}{$sharedArticlePathClean}(?!" . implode(")(?!", $skipNamespaces) . ")|", $localArticlePathClean, $content);

			# replace help wiki project namespace with local project namespace
			$sharedMetaNamespace = WikiFactory::getVarValueByName( 'wgMetaNamespace', $wgHelpWikiId );
			if ( empty( $sharedMetaNamespace ) ) {
				# use wgSitename if empty, per MW docs
				$sharedMetaNamespace = WikiFactory::getVarValueByName( 'wgSitename', $wgHelpWikiId );
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

			// "this text is stored..."
			$out->addStyle(AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/SharedHelp/css/shared-help.scss' ));
			$info = '<div class="sharedHelpInfo plainlinks" style="text-align: right; font-size: smaller;padding: 5px">' . wfMessage( 'shared_help_info' )->parse() . '</div>';

			if(strpos($text, '"noarticletext"') > 0) {
				$text = '<div class="sharedHelp">' . $info . $content . '<div style="clear:both"></div></div>';
			} else {
				$text = $text . '<div class="sharedHelp">' . $info . $content . '<div style="clear:both"></div></div>';
			}
		}
	}

	return true;
}

function SharedHelpEditPageHook( EditPage $editPage ): bool {
	global $wgCityId, $wgHelpWikiId;

	// do not show this message on the help wiki
	if ($wgCityId == $wgHelpWikiId) {
		return true;
	}

	$title = $editPage->getTitle();

	// show message only when editing pages from Help namespace
	if ( !$title->inNamespace( NS_HELP ) ) {
		return true;
	}

	if ( !SharedHelpArticleExists( $title ) ) {
		return true;
	}

	$helpSitename = WikiFactory::getVarValueByName( 'wgSitename', $wgHelpWikiId );

	$msg = '<div style="border: solid 1px; padding: 10px; margin: 5px" class="sharedHelpEditInfo">' . wfMessage( 'shared_help_edit_info', $title->getDBkey(), $helpSitename )->parse() .'</div>';

	$editPage->editFormPageTop .= $msg;

	return true;
}

function SharedHelpLinkBegin( $skin, Title $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
	global $wgTitle;

	// First do simple checks before going to more expensive ones
	if ( $target->getNamespace() == NS_HELP && isset($wgTitle) && !$wgTitle->isSpecial('Wantedpages') ) {
		if ( SharedHelpArticleExists($target) ) {
			// The link is known
			$options[] = 'known';
			// ...and not broken
			$key = array_search( 'broken', $options );
			if ($key !== false) {
				unset($options[$key]);
			}
		}
	}
		return true;
}


/**
 * does $title article exist @help.wikia?
 *
 * @param Title $title
 * @return bool
 * @throws DBUnexpectedError
 * @see SharedHelpHook
 */
function SharedHelpArticleExists(Title $title) {
	global $wgMemc, $wgHelpWikiId;

	$exists = false;

	$sharedLinkKey = wfSharedMemcKey(
		'sharedLinks',
		$wgHelpWikiId,
		md5(MWNamespace::getCanonicalName( $title->getNamespace() ) .  ':' . $title->getDBkey())
	);
	$sharedLink = $wgMemc->get($sharedLinkKey);

	if ( $sharedLink ) {
		$exists =  true;
	} else {
		$sharedArticleKey = wfSharedMemcKey(
			'sharedArticles',
			$wgHelpWikiId,
			md5(MWNamespace::getCanonicalName( $title->getNamespace() ) .  ':' . $title->getDBkey()),
			SHAREDHELP_CACHE_VERSION
		);
		$sharedArticle = $wgMemc->get($sharedArticleKey);

		if ( !empty($sharedArticle['timestamp']) ) {
			$exists =  true;
		} else {
			try {
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
			}
			catch ( DBConnectionError $e ) {
				\Wikia\Logger\WikiaLogger::instance()->error(
					'TechnicalDebtHotSpot',
					[ 'exception_message' => $e->getMessage() ]
				);
			}
		}

		if ($exists) {
			$wgMemc->set($sharedLinkKey, true);
		}
	}

	return $exists;
}

// basically modify the Wantedpages query to exclude help pages, as per #5866
function SharedHelpWantedPagesSql( array &$namespaces ) {
	$namespaces[] = NS_HELP;
	$namespaces[] = NS_HELP_TALK;
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

function efSharedHelpRemoveMagicWord( Parser $parser, string &$text, &$strip_state ): bool {
	$found = MagicWord::get('MAG_NOSHAREDHELP')->matchAndRemove($text);
	if ( $found ) {
		$text .= NOSHAREDHELP_MARKER;
	}

	return true;
}


/**
 * Replace meta information for canonical link
 * Article from shared help should point to it's origin
 */
function SharedHelpCanonicalHook( &$url ) {

	global $wgTitle, $wgHelpWikiId;

	if ( $wgTitle instanceof Title && $wgTitle->getNamespace() == NS_HELP && !$wgTitle->exists() ) {

		$sharedServer = WikiFactory::cityIDtoDomain( $wgHelpWikiId );
		$titleUrl = $wgTitle->getLinkURL();
		$url = $sharedServer . $titleUrl;  // language path should be a part of $titleUrl
	}

	return true;
}

/**
 * Adds a Help search filter on the Help Wiki
 */
function efSharedHelpSearchProfilesHook( &$profiles ) {
	global $wgCityId, $wgHelpWikiId;
	if ( empty( $wgHelpWikiId ) || $wgCityId != $wgHelpWikiId ) {
		return true;
	}
	$helpSearchProfile = array(
		'message' => 'sharedhelp-searchprofile',
		'tooltip' => 'sharedhelp-searchprofile-tooltip',
		'namespaces' => array( NS_HELP )
	);

	if ( !array_key_exists( 'advanced', $profiles ) ) {
		$profiles['help'] = $helpSearchProfile;
	} else {
		$newProfiles = array();
		foreach ( $profiles as $key => $value ) {
			if ( $key === 'advanced' ) {
				$newProfiles['help'] = $helpSearchProfile;
			}
			$newProfiles[$key] = $value;
		}
		$profiles = $newProfiles;
	}

	return true;
}
