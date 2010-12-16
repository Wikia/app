<?php
/**
 * LanguageSelector extension - language selector on every page, also for visitors
 *
 * Features:
 *  * Automatic detection of the language to use for anonymous visitors
 *  * Ads selector for preferred language to every page (also works for anons)
 *
 * This can be combined with Polyglot and MultiLang to provide more internationalization support.
 *
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
	'path'           => __FILE__,
	'name'           => 'Language Selector',
	'author'         => 'Daniel Kinzler',
	'url'            => 'http://mediawiki.org/wiki/Extension:LanguageSelector',
	'description'    => 'language selector on every page, also for visitors',
	'descriptionmsg' => 'languageselector-desc',
);

define( 'LANGUAGE_SELECTOR_USE_CONTENT_LANG',    0 ); #no detection
define( 'LANGUAGE_SELECTOR_PREFER_CONTENT_LANG', 1 ); #use content language if accepted by the client
define( 'LANGUAGE_SELECTOR_PREFER_CLIENT_LANG',  2 ); #use language most preferred by the client

/**
* Language detection mode for anonymous visitors.
* Possible values:
* * LANGUAGE_SELECTOR_USE_CONTENT_LANG - use the $wgLanguageCode setting (default content language)
* * LANGUAGE_SELECTOR_PREFER_CONTENT_LANG - use the $wgLanguageCode setting, if accepted by the client
* * LANGUAGE_SELECTOR_PREFER_CLIENT_LANG - use the client's preferred language, if in $wgLanguageSelectorLanguages
*/
$wgLanguageSelectorDetectLanguage = LANGUAGE_SELECTOR_PREFER_CLIENT_LANG;

/**
* Languages to offer in the language selector. Per default, this includes all languages MediaWiki knows
* about by virtue of $wgLanguageNames. A shorter list may be more usable, though.
* If the Polyglot extension is installed, $wgPolyglotLanguages is used as fallback.
*/
$wgLanguageSelectorLanguages = null;

/**
* Determine if language codes are shown in the selector, in addition to names;
*/
$wgLanguageSelectorShowCode = false;

/**
 * Show all languages defined, not only those with a language file (Language::getLanguageNames( <true/false> ))
 */
$wgLanguageSelectorShowAll = false;

define( 'LANGUAGE_SELECTOR_MANUAL',    0 ); #don't place anywhere
define( 'LANGUAGE_SELECTOR_AT_TOP_OF_TEXT', 1 ); #put at the top of page content
define( 'LANGUAGE_SELECTOR_IN_TOOLBOX',  2 ); #put into toolbox
define( 'LANGUAGE_SELECTOR_AS_PORTLET', 3 ); #as portlet
define( 'LANGUAGE_SELECTOR_INTO_SITENOTICE', 11 ); #put after sitenotice text
define( 'LANGUAGE_SELECTOR_INTO_TITLE', 12 ); #put after title text
define( 'LANGUAGE_SELECTOR_INTO_SUBTITLE', 13 ); #put after subtitle text
define( 'LANGUAGE_SELECTOR_INTO_CATLINKS', 14 ); #put after catlinks text

$wgLanguageSelectorLocation = LANGUAGE_SELECTOR_AT_TOP_OF_TEXT;

///// hook it up /////////////////////////////////////////////////////
$wgHooks['AddNewAccount'][] = 'wfLanguageSelectorAddNewAccount';
$wgHooks['BeforePageDisplay'][] = 'wfLanguageSelectorBeforePageDisplay';
$wgHooks['GetCacheVaryCookies'][] = 'wfLanguageSelectorGetCacheVaryCookies';

$wgExtensionFunctions[] = 'wfLanguageSelectorExtension';

$wgLanguageSelectorRequestedLanguage = null;


$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LanguageSelector'] = $dir . 'LanguageSelector.i18n.php';
$wgJSAutoloadClasses['LanguageSelector'] = 'extensions/LanguageSelector/LanguageSelector.js';

function wfLanguageSelectorSetHook() {
	global $wgParser;
	$wgParser->setHook( 'languageselector', 'wfLanguageSelectorTag' );
	return true;
}

function wfLanguageSelectorExtension() {
	wfLoadExtensionMessages( 'LanguageSelector' );
	global $wgLanguageSelectorLanguages, $wgLanguageSelectorDetectLanguage, $wgLanguageSelectorRequestedLanguage, $wgLanguageSelectorLocation, $wgLanguageSelectorShowAll;
	global $wgUser, $wgLang, $wgRequest, $wgCookiePrefix, $wgCookiePath, $wgOut, $wgJsMimeType, $wgHooks;

	$wgHooks['ParserFirstCallInit'][] = 'wfLanguageSelectorSetHook';

	if ( $wgLanguageSelectorLanguages === null ) {
		$wgLanguageSelectorLanguages = @$GLOBALS['wgPolyglotLanguages'];
	}

	if ( $wgLanguageSelectorLanguages === null ) {
		$wgLanguageSelectorLanguages = array_keys( Language::getLanguageNames( !$wgLanguageSelectorShowAll ) );
		sort( $wgLanguageSelectorLanguages );
	}

	$setlang = $wgRequest->getVal( 'setlang' );
	if ( $setlang && !in_array( $setlang, $wgLanguageSelectorLanguages ) )
		$setlang = null; //ignore invalid

	if ( $setlang ) {
		setcookie( $wgCookiePrefix . 'LanguageSelectorLanguage', $setlang, 0, $wgCookiePath );
		$wgLanguageSelectorRequestedLanguage = $setlang;
	} else {
		$wgLanguageSelectorRequestedLanguage = @$_COOKIE[$wgCookiePrefix.'LanguageSelectorLanguage'];
	}

	if ( $setlang && !$wgUser->isAnon() ) {
		if ( $setlang != $wgUser->getOption( 'language' ) ) {
			$wgUser->setOption( 'language', $wgLanguageSelectorRequestedLanguage );
			$wgUser->saveSettings();
			// Reset $wgLang so that user's language is immediately changed
			$wgLang = new StubUserLang;
		}
	}

	if ( !$wgRequest->getVal( 'uselang' ) && $wgUser->isAnon() ) {

		//NOTE: we need this for anons, so squids don't get confused.
		//      but something is still wrong with caching...
		header( 'Vary: Cookie', false ); //hrm, this is pretty BAD.
		header( 'Vary: Accept-Language', false );

		if ( $wgLanguageSelectorRequestedLanguage || $wgLanguageSelectorDetectLanguage != LANGUAGE_SELECTOR_USE_CONTENT_LANG ) {

			if ( !class_exists( 'StubAutoLang' ) ) {
				class StubAutoLang extends StubObject {
					function __construct() {
						parent::__construct( 'wgLang' );
					}
				
					function __call( $name, $args ) {
						return $this->_call( $name, $args );
					}
				
					//partially copied from StubObject.php. There should be a better way...
					function _newObject() {
						global $wgContLanguageCode, $wgContLang, $wgLanguageSelectorDetectLanguage, $wgLanguageSelectorRequestedLanguage;

						$code = $wgLanguageSelectorRequestedLanguage;
						if (!$code) $code = wfLanguageSelectorDetectLanguage( $wgLanguageSelectorDetectLanguage );

						if( $code == $wgContLanguageCode ) {
							return $wgContLang;
						} else {
							$obj = Language::factory( $code );
							return $obj;
						}
					}
				}
			}
	
			$wgLang = new StubAutoLang;
		}
	}

	if ( $wgLanguageSelectorLocation != LANGUAGE_SELECTOR_MANUAL && $wgLanguageSelectorLocation != LANGUAGE_SELECTOR_AT_TOP_OF_TEXT ) {
		switch ( $wgLanguageSelectorLocation ) {
			case LANGUAGE_SELECTOR_IN_TOOLBOX:
				$wgHooks['SkinTemplateToolboxEnd'][] = 'wfLanguageSelectorSkinHook';
				break;
			default:
				$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'wfLanguageSelectorSkinTemplateOutputPageBeforeExec';
				break;
		}
	}

}

function wfLanguageSelectorBeforePageDisplay( &$out ) {
	global $wgJsMimeType, $wgLanguageSelectorLocation;

	if ( method_exists( $out, 'addScriptClass' ) ) {
		$out->addScriptClass( 'LanguageSelector' );
	} else {
		$out->addScript( "<script type=\"$wgJsMimeType\">" .
			file_get_contents( dirname( __FILE__ ) . '/LanguageSelector.js' ) .
			'</script>'
		);
	}

	if ( $wgLanguageSelectorLocation == LANGUAGE_SELECTOR_AT_TOP_OF_TEXT ) {
		$html = wfLanguageSelectorHTML();
		$out->mBodytext = $html . $out->mBodytext;
	}
	return true;
}

function wfLanguageSelectorGetCacheVaryCookies( &$cookies ) {
	global $wgCookiePrefix;

	$cookies[] = $wgCookiePrefix.'LanguageSelectorLanguage';

	return true;
}

function wfLanguageSelectorSkinHook( &$out ) {
	$html = wfLanguageSelectorHTML();
	print $html;
	return true;
}

function wfLanguageSelectorTag($input, $args) {
	$style = @$args['style'];
	$class = @$args['class'];
	$selectorstyle = @$args['selectorstyle'];
	$buttonstyle = @$args['buttonstyle'];
	$showcode = @$args['showcode'];

	if ($style) $style = htmlspecialchars($style);
	if ($class) $class = htmlspecialchars($class);
	if ($selectorstyle) $selectorstyle = htmlspecialchars($selectorstyle);
	if ($buttonstyle) $buttonstyle = htmlspecialchars($buttonstyle);

	if ($showcode) {
	    $showcode = strtolower($showcode);
	    if ($showcode == "true" || $showcode == "yes" || $showcode == "on") $showcode = true;
	    else if ($showcode == "false" || $showcode == "no" || $showcode == "off") $showcode = false;
	    else $showcode = null;
	} else $showcode = null;

	return wfLanguageSelectorHTML( $style, $class, $selectorstyle, $buttonstyle, $showcode );
}

function wfLanguageSelectorSkinTemplateOutputPageBeforeExec( &$skin, &$tpl ) {
	global $wgLanguageSelectorLocation, $wgLanguageSelectorLanguages;
	global $wgLang, $wgContLang, $wgTitle;

	if ($wgLanguageSelectorLocation == LANGUAGE_SELECTOR_AS_PORTLET) {
		$code = $wgLang->getCode();
		$lines = array();
		foreach ($wgLanguageSelectorLanguages as $ln) {
			$lines[] = array(
				$href = $wgTitle->getFullURL( 'setlang=' . $ln ),
				'text' => $wgContLang->getLanguageName($ln),
				'href' => $href,
				'id' => 'n-languageselector',
				'active' => ($ln == $code),
			);
		}
		
		$tpl->data['sidebar']['languageselector'] = $lines;
		return true;
	}

	$key = null;

	switch($wgLanguageSelectorLocation) {
		case LANGUAGE_SELECTOR_INTO_SITENOTICE: $key = 'sitenotice'; break;
		case LANGUAGE_SELECTOR_INTO_TITLE: $key = 'title'; break;
		case LANGUAGE_SELECTOR_INTO_SUBTITLE: $key = 'subtitle'; break;
		case LANGUAGE_SELECTOR_INTO_CATLINKS: $key = 'catlinks'; break;
	}
	
	if ($key) {
		$html = wfLanguageSelectorHTML();
		$tpl->set( $key, $tpl->data[ $key ] . $html );
	}

	return true;
}

function wfLanguageSelectorDetectLanguage( $mode ) {
	global $wgContLang, $wgLanguageSelectorLanguages;

	$contLang = $wgContLang->getCode();

	if ( !$mode || $mode == LANGUAGE_SELECTOR_USE_CONTENT_LANG ) {
		return $contLang;
	}

	/**
	* get accepted languages from Accept-Languages
	* HTTP header.
	*/
	$accept = @$_SERVER["HTTP_ACCEPT_LANGUAGE"];

	if ( empty( $accept ) )
		return $contLang;

	$accept = explode( ',', $accept );

	/**
	* normalize accepted languages
	*/
	$languages = array();
	foreach ( $accept as $lan ) {
		@list( $value, $qpart ) = explode( ';', trim( $lan ) );
		$match = array();
		if( !isset( $qpart ) ) {
			$languages[$value] = 1.0;
		} elseif( preg_match( '/q\s*=\s*(\d*\.\d+)/', $qpart, $match ) ) {
			$languages[$value] = floatval( $match[1] );
		}
	}

	/**
	* see if the content language is accepted by the
	* client.
	*/
	if ( $mode == LANGUAGE_SELECTOR_PREFER_CONTENT_LANG && array_key_exists( $contLang, $languages ) ) {
		return $contLang;
	}

	arsort( $languages, SORT_NUMERIC );

	/**
	* look for a language that is acceptable to the client
	* and known to the wiki.
	*/
	foreach( $languages as $code => $q ) {
		/**
		* TODO: only accept languages for which an implementation exists.
		*       this is disabled, because it's slow. Note that this code is
		*       executed for every page request!
		*/
		/*
		global $IP;
		$langfile="$IP/languages/Language".str_replace('-', '_', ucfirst($code)).".php";
		if(!file_exists($langfile)) {
			continue;
		}
		*/

		if ( in_array( $code, $wgLanguageSelectorLanguages ) ) {
			return $code;
		}
	}

	return $contLang;
}

function wfLanguageSelectorAddNewAccount( $u ) {
	global $wgUser, $wgLang;

	//inherit language;
	//if $wgUser is the created user this means remembering what the user selected
	//otherwise, it would mean inheriting the language from the user creating the account.
	if ( $wgUser === $u ) {
		$u->setOption( 'language', $wgLang->getCode() );
		$u->saveSettings();
	}

	return true;
}

function wfLanguageSelectorHTML( $style = null, $class = null, $selectorstyle = null, $buttonstyle = null, $showCode = null ) {
	global $wgLanguageSelectorLanguages, $wgTitle, $wgLang, $wgContLang, $wgScript, $wgLanguageSelectorShowCode;

	if ($showCode === null) $showCode = $wgLanguageSelectorShowCode;

	static $id = 0;
	$id += 1;

	$code = $wgLang->getCode();

	$html = '';
	$html .= Xml::openElement('span', array('id' => 'languageselector-box-'.$id, 'class' => 'languageselector ' . $class, 'style' => $style ));
	$html .= Xml::openElement('form', array('name' => 'languageselector-form-'.$id, 'id' => 'languageselector-form-'.$id, 'method' => 'get', 'action' => $wgScript, 'style' => 'display:inline;'));
	$html .= Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() );
	$html .= Xml::openElement('select', array('name' => 'setlang', 'id' => 'languageselector-select-'.$id, 'style' => $selectorstyle));

	foreach ($wgLanguageSelectorLanguages as $ln) {
		$name = $wgContLang->getLanguageName($ln);
		if ($showCode) $name = wfBCP47($ln) . ' - ' . $name;

		$html .= Xml::option($name, $ln, $ln == $code);
	}

	$html .= Xml::closeElement('select');
	$html .= Xml::submitButton(wfMsg('languageselector-setlang'), array( 'id' => 'languageselector-commit-'.$id, 'style' => $buttonstyle ));
	$html .= Xml::closeElement('form');
	$html .= Xml::closeElement('span');

	return $html;
}

