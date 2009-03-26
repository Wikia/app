<?php

/**
 * @package MediaWiki
 * @subpackage RequestWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 0.1
 *
 * AJAX functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

function axACWRequestCheckWikiName() {
	global $wgRequest, $wgDBname, $wgContLang, $wgOut;
	wfLoadExtensionMessages( "AutoCreateWiki" );
	
	$sName = $wgRequest->getVal('name');
	$sResponse = AutoCreateWiki::checkWikiNameIsCorrect($sName);

	$isError = ( !empty($sResponse) ) ? true : false;
	$aResponse = array( 'div-body' => $sResponse, 'div-name' => 'wiki-name-error', 'div-error' => $isError );
	
	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}

function axACWRequestCheckName() {
	global $wgRequest, $wgDBname, $wgContLang, $wgOut;
	wfLoadExtensionMessages( "AutoCreateWiki" );
	
	$sName = $wgRequest->getVal('name');
	$sLang = $wgRequest->getVal('lang');

	$isError = false;
	$sResponse = AutoCreateWiki::checkDomainIsCorrect($sName, $sLang);
	if ( empty($sResponse) ) {
		$aDomains = AutoCreateWiki::getDomainsLikeOrExact($sName, $sLang);
		if ( !empty($aDomains) && is_array($aDomains) ) {
			$sResponse = wfMsg('autocreatewiki-similar-wikis');
			$sLike = $sExact = "";
			#--- exact first
			if ( !empty($aDomains['exact']) && is_array($aDomains['exact']) ) {
				foreach ( $aDomains['exact'] as $domain ) {
					$sExact .= "<li><a href=\"http://{$domain->city_domain}/\" target=\"_blank\">{$domain->city_domain}</a></li>";
				}
				if (!empty($sExact)) {
					$sResponse .= "<ul id='wiki-result-list-exact'>{$sExact}</ul>";
				}
			}
			#--- similar next
			if ( !empty($aDomains['like']) && is_array($aDomains['like']) ) {
				foreach ( $aDomains['like'] as $domain ) {
					$sLike .= "<li><a href=\"http://{$domain->city_domain}/\" target=\"_blank\">{$domain->city_domain}</a></li>";
				}
				if (!empty($sLike)) {
					$sResponse .= "<ul id='wiki-result-list-like'>{$sLike}</ul>";
				}
			}
		}
	} else {
		$isError = true;
	}
	
	$aResponse = array( 'div-body' => $sResponse, 'div-name' => 'wiki-domain-error', 'div-error' => $isError );
	
	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}

function axACWRequestCheckAccount() {
	global $wgRequest, $wgDBname, $wgContLang, $wgOut;
	wfLoadExtensionMessages( "AutoCreateWiki" );

	$sName = $wgRequest->getVal('name');
	$sLang = $wgRequest->getVal('lang');
	$sValue = $wgRequest->getVal('value');
	$sPass = $wgRequest->getVal('pass');
	
	$isError = false;
	$sResponse = "";
	$errDiv = 'wiki-username-error' ;
	switch ($sName) {
		case "username" : {
			$sResponse = AutoCreateWiki::checkUsernameIsCorrect($sValue);
			break;
		}
		case "email" : {
			$sResponse = AutoCreateWiki::checkEmailIsCorrect($sValue);
			break;
		}
		case "password" : {
			$sUsername = $wgRequest->getVal('username');
			$sResponse = AutoCreateWiki::checkPasswordIsCorrect($sUsername, $sValue);
			break;
		}
		case "retype-password" : {
			$sResponse = AutoCreateWiki::checkRetypePasswordIsCorrect($sPass, $sValue);
			break;
		}
	}
	$errDiv = "wiki-{$sName}-error";
	
	$isError = (!empty($sResponse)) ? true : false;
	$aResponse = array( 'div-body' => $sResponse, 'div-name' => $errDiv, 'div-error' => $isError );
	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}

function axACWRequestCheckBirthday() {
	global $wgRequest, $wgDBname, $wgContLang, $wgOut;
	wfLoadExtensionMessages( "AutoCreateWiki" );

	$sYear = $wgRequest->getVal('year');
	$sMonth = $wgRequest->getVal('month');
	$sDay = $wgRequest->getVal('day');
	
	$errDiv = "wiki-birthday-error";
	$sResponse = AutoCreateWiki::checkBirthdayIsCorrect($sYear, $sMonth, $sDay);

	$isError = (!empty($sResponse)) ? true : false;
	$aResponse = array( 'div-body' => $sResponse, 'div-name' => $errDiv, 'div-error' => $isError );
	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}

function axACWRequestCheckLog() {
	global $wgUser;
	wfLoadExtensionMessages( "AutoCreateWiki" );
	
	$sInfo = "";
	if ( !empty($_SESSION) && isset($_SESSION['awcName']) ) {
		$sInfo = AutoCreateWiki::logMemcKey (
			"get", 
			array(
				'awcName' => $_SESSION['awcName'], 
				'awcDomain' => $_SESSION['awcDomain'], 
				'awcCategory' => $_SESSION['awcCategory'], 
				'awcLanguage' => $_SESSION['awcLanguage']
			)
		);
	}

	if ( isset ($sInfo) ) {
		$aResponse = $sInfo;
	} else {
		$aResponse = array( 'type' => '', 'info' => wfMsg('autocreatewiki-stepdefault') );
	}

	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($aResponse);
	} else {
		return json_encode($aResponse);
	}
}
