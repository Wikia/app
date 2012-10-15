<?php
/**
 * Polyglot extension - automatic redirects based on user language
 *
 * Features:
 *  * Magic redirects to localized page version
 *  * Interlanguage links in the sidebar point to localized local pages
 *
 * This can be combined with LanguageSelector and MultiLang to provide more internationalization support.
 *
 * See the README file for more information
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array( 
	'path' => __FILE__,
	'name' => 'Polyglot', 
	'author' => 'Daniel Kinzler', 
	'url' => 'http://mediawiki.org/wiki/Extension:Polyglot',
	'description' => 'Support for content in multiple languages in a single MediaWiki',
);

/**
* Set languages with polyglot support; applies to negotiation of interface language, 
* and to lookups for loclaized pages.
* Set this to a small set of languages that are likely to be used on your site to
* improve performance. Leave NULL to allow all languages known to MediaWiki via
* languages/Names.php.
* If the LanguageSelector extension is installed, $wgLanguageSelectorLanguages is used
* as a fallback.
*/
$wgPolyglotLanguages = null;

/**
* Namespaces to excempt from polyglot support, with respect to automatic redirects.
* All "magic" namespaces are excempt per default. There should be no reason to change this.
* Note: internationalizing templates is best done on-page, using the MultiLang extension.
*/
$wfPolyglotExcemptNamespaces = array(NS_CATEGORY, NS_TEMPLATE, NS_IMAGE, NS_MEDIA, NS_SPECIAL, NS_MEDIAWIKI);

/**
* Wether talk pages should be excempt from automatic polyglot support, with respect to
* automatic redirects. True per default.
*/
$wfPolyglotExcemptTalkPages = true;

/**
* Set to true if polyglot should resolve redirects that are encountered when applying an
* automatic redirect to a localized page. This requires additional database access every
* time a locaized page is accessed.
*/
$wfPolyglotFollowRedirects = false;

///// hook it up /////////////////////////////////////////////////////
$wgHooks['InitializeArticleMaybeRedirect'][] = 'wfPolyglotInitializeArticleMaybeRedirect';
$wgHooks['LinkBegin'][] = 'wfPolyglotLinkBegin';
$wgHooks['ParserAfterTidy'][] = 'wfPolyglotParserAfterTidy';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'wfPolyglotSkinTemplateOutputPageBeforeExec';

$wgExtensionFunctions[] = "wfPolyglotExtension";

function wfPolyglotExtension() {
	global $wgPolyglotLanguages;

	if ( $wgPolyglotLanguages === null ) {
		$wgPolyglotLanguages = @$GLOBALS['wgLanguageSelectorLanguages'];
	}
	
	if ( $wgPolyglotLanguages === null ) {
		$wgPolyglotLanguages = array_keys( Language::getLanguageNames() );
	}
}

function wfPolyglotInitializeArticleMaybeRedirect( &$title, &$request, &$ignoreRedirect, &$target, &$article ) {
	global $wfPolyglotExcemptNamespaces, $wfPolyglotExcemptTalkPages, $wfPolyglotFollowRedirects;
	global $wgLang, $wgContLang;

	$ns = $title->getNamespace();

	if ( $ns < 0 || in_array( $ns, $wfPolyglotExcemptNamespaces )
		|| ( $wfPolyglotExcemptTalkPages && MWNamespace::isTalk( $ns ) ) ) {
		return true;
	}

	$dbkey = $title->getDBkey();
	$force = false;

	//TODO: when user-defined language links start working (see below),
	//      we need to look at the langlinks table here.
	if ( !$title->exists() && strlen( $dbkey ) > 1 ) {
		$escContLang = preg_quote( $wgContLang->getCode(),  '!' );
		if ( preg_match( '!/$!', $dbkey ) ) {
			$force = true;
			$remove = 1;
		} elseif ( preg_match( "!/{$escContLang}$!", $dbkey ) ) {
			$force = true;
			$remove = strlen( $wgContLang->getCode() ) + 1;
		}
	}

	if ( $force ) {
		$t = Title::makeTitle( $ns, substr( $dbkey, 0, strlen( $dbkey ) - $remove ) );
	} else {
		$lang = $wgLang->getCode();
		$t = Title::makeTitle( $ns, $dbkey . '/' . $lang );
	}

	if ( !$t->exists() ) {
		return true;
	}

	if ( $wfPolyglotFollowRedirects && !$force ) {
		$page = WikiPage::factory( $t );

		if ( $page->isRedirect() ) {
			$rt = $page->getRedirectTarget();
			if ( $rt && $rt->exists() ) {
				//TODO: make "redirected from" show $source, not $title, if we followed a redirect internally.
				//     there seems to be no clean way to do that, though.
				//$source = $t;
				$t = $rt;
			}
		}
	}

	$target = $t;

	return true;
}

function wfPolyglotLinkBegin( $linker, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
	global $wfPolyglotExcemptNamespaces, $wfPolyglotExcemptTalkPages, $wgContLang;

	$ns = $target->getNamespace();

	if ( $ns < 0 
		|| in_array( $ns, $wfPolyglotExcemptNamespaces ) 
		|| ( $wfPolyglotExcemptTalkPages && MWNamespace::isTalk( $ns ) ) ) {
		return true;
	}

	$dbKey = $target->getDBkey();

	if ( !$target->exists() && strlen( $dbKey ) > 1 ) {
		$escContLang = preg_quote( $wgContLang->getCode(),  '!' );
		if ( preg_match( '!/$!', $dbKey ) ) {
			$remove = 1;
		} elseif ( preg_match( "!/{$escContLang}$!", $dbKey ) ) {
			$remove = strlen( $wgContLang->getCode() ) + 1;
		} else {
			return true;
		}
	} else {
		return true;
	}

	$t = Title::makeTitle( $ns, substr( $dbKey, 0, strlen( $dbKey ) - $remove ) );

	if ( $t->exists() ) {
		foreach( $options as $key => $val ) {
			if ( $val === 'broken' ) {
				unset( $options[$key] );
			}
		}
		$options[] = 'known';
	}

	return true;
}

function wfPolyglotGetLanguages( $title ) {
	global $wgPolyglotLanguages;
	if (!$wgPolyglotLanguages) return null;

	$n = $title->getDBkey();
	$ns = $title->getNamespace();

	$titles = array();
	$batch = new LinkBatch();

	foreach ( $wgPolyglotLanguages as $lang ) {
		$obj = Title::makeTitle( $ns, $n . '/' . $lang );
		$batch->addObj( $obj );
		$titles[] = array( $obj, $lang );
	}

	$batch->execute();
	$links = array();

	foreach( $titles as $parts ) {
		list( $t, $lang ) = $parts;
		if ( $t->exists() ) {
			$links[$lang] = $t->getFullText();
		}
	}

	return $links;
}

function wfPolyglotParserAfterTidy( &$parser, &$text ) {
	global $wgPolyglotLanguages, $wfPolyglotExcemptNamespaces, $wfPolyglotExcemptTalkPages;
	global $wgContLang;

	if ( !$wgPolyglotLanguages ) return true;
	if ( !$parser->mOptions->getInterwikiMagic() ) return true;

	$n = $parser->mTitle->getDBkey();
	$ns = $parser->mTitle->getNamespace();
	$contln = $wgContLang->getCode();

	$userlinks = $parser->mOutput->getLanguageLinks();

	$links = array();
	$pagelang = null;

	//TODO: if we followed a redirect, analyze the redirect's title too.
	//      at least if wgPolyglotFollowRedirects is true

	if ( $ns >= 0 && !in_array($ns,  $wfPolyglotExcemptNamespaces)
		&& (!$wfPolyglotExcemptTalkPages || !MWNamespace::isTalk($ns)) ) {
		$ll = wfPolyglotGetLanguages($parser->mTitle);
		if ($ll) $links = array_merge($links, $ll);

		if (preg_match('!(.+)/(\w[-\w]*\w)$!', $n, $m)) {
			$pagelang = $m[2];
			$t = Title::makeTitle($ns, $m[1]);
			if (!isset($links[$contln]) && $t->exists()) $links[$contln] = $t->getFullText() . '/';

			$ll = wfPolyglotGetLanguages($t);
			if ($ll) {
				unset($ll[$pagelang]);
				$links = array_merge($links, $ll);
			}
		}
	}

	//TODO: would be nice to handle "normal" interwiki-links here. 
	//      but we would have to hack into Title::getInterwikiLink, otherwise
	//      the links are not recognized. 
	/*
	foreach ($userlinks as $link) {
		$m = explode(':', $link, 2);
		if (sizeof($m)<2) continue;

		$links[$m[0]] = $m[1];
	}
	*/

	if ($pagelang) unset($links[$pagelang]);

	//print_r($links);

	$fakelinks = array();
	foreach ($links as $lang => $t) {
		$fakelinks[] = $lang . ':' . $t;
	}

	$parser->mOutput->setLanguageLinks($fakelinks);
	return true;
}

function wfPolyglotSkinTemplateOutputPageBeforeExec($skin, $tpl) {
	global $wgOut, $wgContLang;

	$language_urls = array();
	foreach( $wgOut->getLanguageLinks() as $l ) {
		if (preg_match('!^(\w[-\w]*\w):(.+)$!', $l, $m)) {
			$lang = $m[1];
			$l = $m[2];
		}
		else {
			continue; //NOTE: shouldn't happen
		}

		$nt = Title::newFromText( $l );
		$language_urls[] = array(
			'href' => $nt->getFullURL(),
			'text' => $wgContLang->getLanguageName( $lang ),
			'class' => 'interwiki-' . $lang,
		);
	}

	if(count($language_urls)) {
		$tpl->setRef( 'language_urls', $language_urls);
	} else {
		$tpl->set('language_urls', false);
	}

	return true;
}

