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
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array( 
	'name' => 'Polyglot', 
	'author' => 'Daniel Kinzler', 
	'url' => 'http://mediawiki.org/wiki/Extension:Polyglot',
	'description' => 'support for content in multiple languages in a single mediawiki.',
);

/**
* Set languages with polyglot support; applies to negotiation of interface language, 
* and to lookups for loclaized pages.
* Set this to a small set of languages that are likely to be used on your site to
* improve performance. Leave NULL to allow all languages known to MediaWiki via
* $wgLanguageNames.
* If the LanguageSelector extension is installed, $wgLanguageSelectorLanguages is used
* as a fallback.
*/
$wgPolyglotLanguages = NULL;

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
$wgHooks['ArticleFromTitle'][] = 'wfPolyglotArticleFromTitle';
$wgHooks['ParserAfterTidy'][] = 'wfPolyglotParserAfterTidy';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'wfPolyglotSkinTemplateOutputPageBeforeExec';

$wgExtensionFunctions[] = "wfPolyglotExtension";

function wfPolyglotExtension() {
	global $wgPolyglotLanguages;

	if ( $wgPolyglotLanguages === NULL ) {
		$wgPolyglotLanguages = @$GLOBALS['wgLanguageSelectorLanguages'];
	}
	
	if ( $wgPolyglotLanguages === NULL ) {
		$wgPolyglotLanguages = array_keys( $GLOBALS['wgLanguageNames'] );
	}
}

function wfPolyglotArticleFromTitle( &$title, &$article ) {
	global $wfPolyglotExcemptNamespaces, $wfPolyglotExcemptTalkPages, $wfPolyglotFollowRedirects;
	global $wgLang, $wgTitle, $wgRequest;

	if ($wgRequest->getVal( 'redirect' ) == 'no') {
		return true;
	}

	$ns = $title->getNamespace();

	if ( $ns < 0 
		|| in_array($ns,  $wfPolyglotExcemptNamespaces) 
		|| ($wfPolyglotExcemptTalkPages && Namespace::isTalk($ns)) ) {
		return true;
	}

	$n = $title->getDBkey();
	$nofollow = false;

	//TODO: when user-defined language links start working (see below),
	//      we need to look at the langlinks table here.

	if (!$title->exists() && strlen($n)>1 && preg_match('!/$!', $n)) {
		$t = Title::makeTitle($ns, substr($n, 0, strlen($n)-1));
		$nofollow = true;
	}
	else {
		$lang = $wgLang->getCode();
		$t = Title::makeTitle($ns, $n . '/' . $lang);
	}

	if (!$t->exists()) {
		return true;
	}

	if ($wfPolyglotFollowRedirects && !$nofollow) {
		$a = new Article($t);
		$a->loadPageData();

		if ($a->mIsRedirect) {
			$rt = $a->followRedirect();
			if ($rt && $rt->exists()) {
				//TODO: make "redirected from" show $source, not $title, if we followed a redirect internally.
				//     there seems to be no clean way to do that, though.
				//$source = $t;
				$t = $rt;
			}
		}
	}

	if (!class_exists('PolyglotRedirect')) {
		class PolyglotRedirect extends Article {
			var $mTarget;
		
			function __construct( $source, $target ) {
				Article::__construct($source);
				$this->mTarget = $target;
				$this->mIsRedirect = true;
			}
		
			function followRedirect() {
				return $this->mTarget;
			}

			function loadPageData( $data = 'fromdb' ) {
				Article::loadPageData( $data );
				$this->mIsRedirect = true;
			}
		}
	}
	
	//print $t->getFullText();

	$article = new PolyglotRedirect( $title, $t ); //trigger redirect to lovcalized page
	
	return true;
}

function wfPolyglotGetLanguages( $title ) {
	global $wgPolyglotLanguages;
	if (!$wgPolyglotLanguages) return NULL;

	$n = $title->getDBkey();
	$ns = $title->getNamespace();

	$links = array();

	foreach ($wgPolyglotLanguages as $lang) {
		$t = Title::makeTitle($ns, $n . '/' . $lang);
		if ($t->exists()) $links[$lang] = $t->getFullText();
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
	$pagelang = NULL;

	//TODO: if we followed a redirect, analyze the redirect's title too.
	//      at least if wgPolyglotFollowRedirects is true

	if ( $ns >= 0 && !in_array($ns,  $wfPolyglotExcemptNamespaces)
		&& (!$wfPolyglotExcemptTalkPages || !Namespace::isTalk($ns)) ) {
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

