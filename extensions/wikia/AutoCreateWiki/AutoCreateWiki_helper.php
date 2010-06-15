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

class AutoCreateWiki {

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

	/**
	 * getDomainsLikeOrExact
	 *
	 * check if name is similar or the same, using sql like queries
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @param string $name: name to check
	 * @param string $language default null - choosen language
	 * @param mixed  $type type of domain, default false = wikia.com
	 *
	 * @return array with matches
	 */
	function getDomainsLikeOrExact( $name, $language = null, $type = false ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$domains = array();
		$unique = array();

		$name = self::deleteCommonPostfix($name);

		$condition = $conditionSimilar = "";

		/**
		 * don't check short names
		 */
		if ( strlen( $name ) > 3 ) {
			$names = explode(" ", $name);
			$skip = false;
			$tmp_array = array();

			if ( is_array( $names ) ) {
				foreach( $names as $n ) {
					if ( !preg_match("/^[\w\.]+$/",$n) ) continue;
					$sDomain = Wikia::fixDomainName( $n, $language, $type );
					$tmp_array['exact'][] = "city_domain = '{$sDomain}'";
					$n = strtr($n, '0123456789-', '%%%%%%%%%%%%');
					if ( empty($type) ) {
						$tmp_array['similar'][] = "city_domain like '%{$n}%'";
					} else {
						switch ( $type ) {
							case "answers" : 
								$__domains = Wikia::getAnswersDomains();
								if ( $__domains && $language && isset($__domains[$language]) ) {
									$likeName = $__domains[$language];
								} elseif ( $__domains && isset($__domains["default"]) ) {
									$likeName = $__domains["default"];
								} 
								if ( $likeName ) {
									$tmp_array['similar'][] = "city_domain like '%{$n}.{$likeName}%'";
								}
								$tmp_array['similar'][] = "city_domain like '%{$n}.{$type}%'";
								break;
							default : $tmp_array['similar'][] = "city_domain like '%{$n}.{$type}%'";
						}
					}
				}
				if( sizeof( $tmp_array ) ) {
					$condition = implode(" or ", $tmp_array['exact']);
					$conditionSimilar = implode(" or ", $tmp_array['similar']);
				} else {
					$skip = true;
				}
			} else {
				$sDomain = Wikia::fixDomainName($name, $language, $type );
				$condition = "city_domain = '{$sDomain}'";
				$conditionSimilar = ( empty( $type ) )
					? "city_domain like '%{$name}%'"
					: "city_domain like '%{$name}.{$type}%'";
			}

			$conditionLanguage = "";

			if ( $skip === false ) {
				#--- exact (but with language prefixes)
				list ($city_domains, $city_list) = array("city_domains", "city_list");

				$oRes = $dbr->select (
					array ( $city_domains, $city_list ),
					array ( "*" ),
					array (
						$condition,
						"{$city_domains}.city_id = {$city_list}.city_id"
					),
					__METHOD__,
					array( "LIMIT" => 20 )
				);

				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					if ( preg_match( "/^www\./", strtolower( $oRow->city_domain ) ) )
						continue;
					if ( $oRow->city_public == 1 ) {
						$unique[ strtolower( $oRow->city_domain ) ] = 1;
						$domains["exact"][] = $oRow;
					} else {
						$domains["closed"][] = $oRow;
					}
				}
				$dbr->freeResult($oRes);

				if ( !is_null($language) ) {
					$conditionLanguage = "city_lang = '{$language}'";
				}

				#--
				# Similar domains
				$oRes = $dbr->select(
					array ( $city_domains, $city_list ),
					array ( "*" ),
					array (
						$conditionSimilar,
						"{$city_domains}.city_id = {$city_list}.city_id",
						$conditionLanguage
					),
					__METHOD__,
					array( "LIMIT" => 20 )
				);

				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					if ( preg_match( "/^www\./", strtolower( $oRow->city_domain ) ) )
						continue;
					if ( $oRow->city_public == 1 ) {
						if ( array_key_exists( strtolower($oRow->city_domain), $unique)
							&& $unique[ strtolower($oRow->city_domain) ] == 1 )
							continue;
						$domains["like"][] = $oRow;
					}
					else {
						$domains["closed"][] = $oRow;
					}
				}
				$dbr->freeResult($oRes);
			}
		}
		return $domains;
	}

	function deleteCommonPostfix($name) {
		$commonPostfixes = array('pedia', 'wikia', 'wiki');
		$regexp = array('/(?:^|(?<!\s))(?:' . implode('|', $commonPostfixes) . ')(?:\s|$)/');
		return preg_replace($regexp, '', $name);
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
		global $wgUser;

		wfProfileIn(__METHOD__);
		$sResponse = "";

		if ( strlen($sName) === 0 ) {
			#-- empty field
			$sResponse = wfMsg('autocreatewiki-empty-field');
		} elseif ( strlen( $sName ) < 3 ) {
			#-- too short
			$sResponse = wfMsg('autocreatewiki-name-too-short');
		} elseif ( strlen( $sName ) > 50 ) {
			#-- too short
			$sResponse = wfMsg('autocreatewiki-name-too-long');
		} elseif (preg_match('/[^a-z0-9-]/i', $sName)) {
			#-- invalid name
			$sResponse = wfMsg('autocreatewiki-bad-name');
		} elseif ( in_array( $sName, array_keys( Language::getLanguageNames() )) ) {
			#-- invalid name
			$sResponse = wfMsg('autocreatewiki-violate-policy');
		} elseif ( !in_array('staff', $wgUser->getGroups()) && (self::checkBadWords($sName, "domain") === false) ) {
			#-- invalid name (bad words)
			$sResponse = wfMsg('autocreatewiki-violate-policy');
		} else {
			$iExists = AutoCreateWiki::domainExists( $sName, $sLang, $type );
			if (!empty($iExists)) {
				#--- domain exists
				$sResponse = wfMsg('autocreatewiki-name-taken', ( !is_null($sLang) && ($sLang != 'en') ) ? sprintf("%s.%s", $sLang, $sName) : $sName );
			}
		}

		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkCategoryIsCorrect($sValue) {
		wfProfileIn(__METHOD__);
		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();
		$sResponse = "";
		if ($sValue == "") {
			$sResponse = wfMsg('autocreatewiki-empty-category');
		} elseif ( !empty($aCategories) && ( !in_array( $sValue, array_keys( $aCategories ) ) ) ) {
			$sResponse = wfMsg('autocreatewiki-invalid-category');
		}
		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkLanguageIsCorrect($sValue) {
		wfProfileIn(__METHOD__);
		$aLanguages = Language::getLanguageNames();
		$sResponse = "";
		if ($sValue == "") {
			$sResponse = wfMsg('autocreatewiki-empty-language');
		} elseif ( !empty($aLanguages) && ( !in_array( $sValue, array_keys( $aLanguages ) ) ) ) {
			$sResponse = wfMsg('autocreatewiki-invalid-language');
		}
		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkUsernameIsCorrect($sValue) {
		wfProfileIn(__METHOD__);
		$sResponse = "";
		if ($sValue == "") {
			$sResponse = wfMsg('autocreatewiki-empty-username');
		} else {
			$u = User::newFromName( $sValue );
			if ( is_null($u) ) {
				$sResponse = wfMsg('autocreatewiki-invalid-username');
			} else {
				$iId = User::idFromName( $sValue );
				if ( !empty($iId) ) {
					$sResponse = wfMsg('autocreatewiki-busy-username');
				}
			}
		}
		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkEmailIsCorrect($sValue) {
		wfProfileIn(__METHOD__);

		$sResponse = "";
		if ( ( $sValue == "") || ( !User::isValidEmailAddr( $sValue ) ) )  {
			$sResponse = wfMsg( 'invalidemailaddress' );
		}

		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkPasswordIsCorrect($sUsername, $sValue) {
		global $wgMinimalPasswordLength;

		wfProfileIn(__METHOD__);
		$sResponse = "";
		if ($sUsername == "") {
			$sResponse = wfMsg('autocreatewiki-set-username');
		} else {
			if ($sValue == "") {
				$sResponse = wfMsg('autocreatewiki-empty-password');
			} else {
				$u = User::newFromName( $sUsername );
				if ( is_null( $u ) ) {
					$u = new StubUser();
				}
				if ( !$u->isValidPassword( $sValue ) ) {
					$sResponse = wfMsgExt( 'passwordtooshort', array( 'parsemag' ), $wgMinimalPasswordLength );
				}
			}
		}
		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkRetypePasswordIsCorrect($sPass, $sValue) {
		wfProfileIn(__METHOD__);
		$sResponse = "";
		if ( $sValue == "" ) {
			$sResponse = wfMsg('autocreatewiki-empty-retype-password');
		} elseif ( strcmp( $sPass, $sValue ) != 0 ) {
			$sResponse = wfMsg('autocreatewiki-invalid-retype-passwd');
		}
		wfProfileOut(__METHOD__);
		return $sResponse;
	}

	public static function checkBirthdayIsCorrect ($sYear, $sMonth, $sDay) {
		wfProfileIn(__METHOD__);
		$sResponse = "";
		if ($sYear == -1 || $sMonth == -1 || $sDay == -1) {
			$sResponse = wfMsg('autocreatewiki-invalid-birthday');
		} elseif ( empty($sYear) || empty($sMonth) || empty($sDay) ) {
			$sResponse = wfMsg('autocreatewiki-invalid-birthday');
		} else {
			$sYear = sprintf("%0d", $sYear);
			$sMonth = sprintf("%0d", $sMonth);
			$sDay = sprintf("%0d", $sDay);
			if ( preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', "{$sYear}-{$sMonth}-{$sDay}") === false ) {
				$sResponse = wfMsg('autocreatewiki-invalid-birthday');
			} else {
				$userBirthDay = strtotime($sYear . '-' . $sMonth . '-' . $sDay);
				if ($userBirthDay > strtotime('-13 years')) {
					$sResponse = wfMsg('userlogin-unable-info');
				}
			}
		}
		wfProfileOut(__METHOD__);
		return $sResponse;
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

		if( !wfRunHooks( 'AutoCreateWiki::checkBadWords', array( $sText, $where, $split ) ) ) {
			return false;
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
