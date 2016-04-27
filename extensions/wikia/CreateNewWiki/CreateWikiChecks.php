<?php

/**
 * @package MediaWiki
 * @subpackage RequestWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 0.1
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class CreateWikiChecks {

	const STAFF_LIST = "staffsigs";
    const BAD_WORDS_MSG = 'creation_blacklist';

	/**
	 * isDomainExists
	 *
	 * check in city_domains if we have such wikia in city_domains
	 *
	 * @param string $name: domain name
	 * @param string $language default null - choosen language
	 * @param mixed  $type type of domain, default false = wikia.com
	 *
	 * @return integer - 0 or 1
	 */
	public static function domainExists( $name, $language = null, $type = false ) {
		global $wgExternalSharedDB;

		$sDomain = Wikia::fixDomainName( $name, $language, $type );
		Wikia::log( __METHOD__, "domain", "{$sDomain} name={$name}, language={$language}, type={$type}" );


		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$oRow = $dbr->selectRow(
			"city_domains",
			array( "city_id" ),
			array( "city_domain" => $sDomain ),
			__METHOD__
		);

		if ( !isset($oRow->city_id) ) {
			$oRow = $dbr->selectRow(
				"city_domains",
				array( "city_id" ),
				array( "city_domain" => sprintf( "%s.%s", "www", $sDomain ) ),
				__METHOD__
			);
		}

		$result = !empty( $oRow->city_id ) ? true : false;

		return $result;
	}

	/*
	 * check form fields
	 */
	public static function checkWikiNameIsCorrect($sValue, $sLang = '') {
		global $wgUser, $wgLegalTitleChars;

		wfProfileIn(__METHOD__);
		$sResponse = "";
		if ($sValue == "") {
			$sResponse = wfMsg('autocreatewiki-empty-wikiname');
		} elseif (preg_match('/[^' . $wgLegalTitleChars . ']/i', $sValue)) {
			$sResponse = wfMsg('autocreatewiki-invalid-wikiname');
		} elseif ( !in_array('staff', $wgUser->getGroups()) && (self::checkBadWords($sValue, "name", true) === false) ) {
			$sResponse = wfMsg('autocreatewiki-violate-policy');
		} elseif ( self::isNameInNamespaces($sValue, $sLang) ) {
			$sResponse = wfMsg('autocreatewiki-violate-policy');
		}
		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkDomainIsCorrect($sName, $sLang, $type = false ) {
		wfProfileIn(__METHOD__);
		$sResponse = "";

		$sNameLength = strlen($sName);
		$app = F::app();

		if ( $sNameLength === 0 ) {
			#-- empty field
			$sResponse = wfMsg('autocreatewiki-empty-field');
		} elseif ( $sNameLength < 3 ) {
			#-- too short
			$sResponse = wfMsg('autocreatewiki-name-too-short');
		} elseif ( $sNameLength > 50 ) {
			#-- too short
			$sResponse = wfMsg('autocreatewiki-name-too-long');
		} elseif (preg_match('/[^a-z0-9-]/i', $sName) ||
			$sName[0] == '-' || $sName[$sNameLength - 1] == '-') {
			#-- invalid name
			$sResponse = wfMsg('autocreatewiki-bad-name');
		} elseif ( in_array( $sName, array_keys(static::getLanguageNames())) ) {
			#-- invalid name
			$sResponse = wfMsg('autocreatewiki-violate-policy');
		} elseif ( !in_array('staff', $app->wg->user->getGroups()) && (static::checkBadWords($sName, "domain") === false) ) {
			#-- invalid name (bad words)
			$sResponse = wfMsg('autocreatewiki-violate-policy');
		} else {
			$iExists = static::checkDomainExists($sName, $sLang, $type);
			if (!empty($iExists)) {
				#--- domain exists
				$sResponse = wfMsg('autocreatewiki-name-taken', ( !is_null($sLang) && ($sLang != 'en') ) ? sprintf("%s.%s", $sLang, $sName) : $sName );
			}
		}

		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function getLanguageNames() {
		return Language::getLanguageNames();
	}

	public static function checkDomainExists($sName, $sLang, $type) {
		return CreateWikiChecks::domainExists($sName, $sLang, $type);
	}

	/**
	 * get staff member signature for given lang code
	 */
	public static function getStaffUserByLang( $langCode ) {
		wfProfileIn( __METHOD__ );

		$staffSigs = wfMsgForContent( self::STAFF_LIST );
		$oUser = false;
		if ( !empty( $staffSigs ) ) {
			$lines = explode("\n", $staffSigs);

			foreach ( $lines as $line ) {
				if ( strpos($line, '* ') === 0 ) {
					$sectLangCode = trim($line, '* ');
					continue;
				}
				if ( (strpos($line, '* ') == 1) && ($langCode == $sectLangCode) ) {
					$sUser = trim($line, '** ');
				    $oUser = User::newFromName( $sUser );
					$oUser->load();
					break;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $oUser;
	}

	/**
	 * get or set value from memcache
	 */
	public static function logMemcKey ($action, $aParams, $aInfo = array()) {
		global $wgUser, $wgMemc;
		wfProfileIn(__METHOD__);
		$sName = str_replace(" ", "_", $aParams['awcName']);
		$sDomain = str_replace(" ", "_", $aParams['awcDomain']);
		$key = wfMemcKey( 'awcProcessLog', $wgUser->getId(), $sName, $sDomain, $aParams['awcCategory'], $aParams['awcLanguage']);
		if ($action == 'set') {
			$wgMemc->set( $key, $aInfo, 4*60);
		} else {
			$key = $wgMemc->get( $key );
		}
		wfProfileOut(__METHOD__);
		return $key;
	}

	/**
	 * check "bad" words by TextRegex extension
	 */
	public static function checkBadWords($sText, $where, $split = false) {
		wfProfileIn(__METHOD__);

		if( !wfRunHooks( 'CreateWikiChecks::checkBadWords', array( $sText, $where, $split ) ) ) {
			wfProfileOut(__METHOD__);
			return false;
		}

		// TODO: temporary check for Phalanx (don't perform additional filtering when enabled)
		global $wgEnablePhalanxExt;
		if (!empty($wgEnablePhalanxExt)) {
			wfProfileOut(__METHOD__);
			return true;
		}
		// TextRegexCore is disabled by default now.  If phalanx is disabled, this will fail
		if (!class_exists('TextRegexCore')) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$allowed = true;
		$oRegexCore = new TextRegexCore( "creation", 0 );
		if ($oRegexCore instanceof TextRegexCore) {
			$newText = preg_replace("/[^a-z0-9]/i", "", $sText);
			#--
			if ($split == true) {
				$aWordsInText = preg_split("/[\s,]+/", $newText);
			} else {
				$aWordsInText = array($newText);
			}
			$allowed = $oRegexCore->isAllowedText($aWordsInText, wfMsg('autocreatewiki-regex-error-comment', $where, $sText));
		}
		#---
		wfProfileOut(__METHOD__);
		return $allowed;
	}

	/**
	 * check name of Wiki is one of NS name
	 */
	public static function isNameInNamespaces($sText, $lang = "") {
		global $wgContLang, $wgLang;
		$res = false;

		$cNamespaces = $wgContLang->getNamespaces();
		$lNamespaces = $wgLang->getNamespaces();
		if ( !empty($cNamespaces) ) {
			if ( preg_match('/^((' . implode(")|(", array_values($cNamespaces)) . '))(\s*)\:/i', $sText) ) {
				$res = true;
			}
		}

		if ( !empty($lNamespaces) && ($res == false) ) {
			if ( preg_match('/^((' . implode(")|(", array_values($lNamespaces)) . '))(\s*)\:/i', $sText) ) {
				$res = true;
			}
		}

		if ( !empty($lang) && !in_array($lang, array($wgContLang->getCode(), $wgLang->getCode())) && ($res == false) ) {
			$wikiLang = Language::factory($lang);
			$lNamespaces = $wikiLang->getNamespaces();
			if ( preg_match('/^((' . implode(")|(", array_values($lNamespaces)) . '))(\s*)\:/i', $sText) ) {
				$res = true;
			}
		}

		return $res;
	}
}
