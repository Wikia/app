<?php

/**
* CustomTabs plugin for the GroupPermissionsManager extension
* This requires the GroupPermissionsManager extension to function
* Licensed under the GPL
*/

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'Custom Tabs',
	'author'         => 'Ryan Schmidt',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:GroupPermissionsManager',
	'version'        => '1.1',
	'description'    => 'Allows for the content actions (tabs) to be customized',
	'descriptionmsg' => 'grouppermissions-desc3',
);

$wgHooks['SkinTemplateContentActions'][] = 'efGPManagerCustomTabs';
$wgHooks['SkinTemplateTabs'][] = 'efGPManagerGetSkin';
$wgHooks['SkinTemplateBuildContentActionUrlsAfterSpecialPage'][] = 'efGPManagerGetSkin';

$egSkinObj = '';

function efGPManagerCustomTabs(&$ca) {
	//loop protection
	if(defined('IN_GPM')) {
		return true;
	}
	global $wgUser, $wgGPManagerShowEditTab;
	loadGPMessages();
	$dt = array();
	$dto = array();
	foreach($ca as $tab => $stuff) {
		$dto[$tab] = array( $tab, $stuff ); //clone it (kinda)
		unset($ca[$tab]);
	}
	foreach($dto as $tab => $stuff) {
		//reformat main keys, this does NOT affect the tabs themselves at all
		if(preg_match('/^nstab-/', $tab)) {
			$dt['article'] = $dto[$tab];
			continue;
		}
		switch($tab) {
			case 'viewsource':
				$dt['edit'] = $dto[$tab];
				break;
			case 'unprotect':
				$dt['protect'] = $dto[$tab];
				break;
			case 'undelete':
				$dt['delete'] = $dto[$tab];
				break;
			case 'unwatch':
				$dt['watch'] = $dto[$tab];
				break;
			default:
				$dt[$tab] = $dto[$tab];
				break;
		}
	}
	if(!$wgUser->isAllowed('read')) {
		//don't show anything if they can't read the wiki
		//don't re-run the hooks, either
		return true;
	}
	$tabs = explode("\n", wfMsgForContent('content_actions'));
	//format of url | text | permission (optional)
	foreach($tabs as $c) {
		if($c != '' && strpos($c, '*') === 0) {
			//special case handling for our "magic words"
			$c = trim(trim($c, '*'));
			$s = false;
			switch($c) {
				case wfMsg('grouppermissions-ca-article'):
					if(array_key_exists('article', $dt))
						$ca[$dt['article'][0]] = $dt['article'][1];
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-discussion'):
					if(array_key_exists('talk', $dt))
						$ca[$dt['talk'][0]] = $dt['talk'][1];
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-edit'):
					if(array_key_exists('edit', $dt) && ($wgUser->isAllowed($dt['edit'][0]) || $wgGPManagerShowEditTab)) {
						$ca[$dt['edit'][0]] = $dt['edit'][1];
					}
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-newsection'):
					if(array_key_exists('addsection', $dt)) {
						$ca[$dt['addsection'][0]] = $dt['addsection'][1];
					}
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-history'):
					if(array_key_exists('history', $dt) && $wgUser->isAllowed('history')) {
						$ca[$dt['history'][0]] = $dt['history'][1];
					}
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-move'):
					if(array_key_exists('move', $dt))
						$ca[$dt['move'][0]] = $dt['move'][1];
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-watch'):
					if(array_key_exists('watch', $dt))
						$ca[$dt['watch'][0]] = $dt['watch'][1];
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-protect'):
					if(array_key_exists('protect', $dt))
						$ca[$dt['protect'][0]] = $dt['protect'][1];
					$s = true;
					break;
				case wfMsg('grouppermissions-ca-delete'):
					if(array_key_exists('delete', $dt))
						$ca[$dt['delete'][0]] = $dt['delete'][1];
					$s = true;
					break;
			}
			if($s)
				continue;
			$nt = explode('|', $c);
			foreach($nt as &$val)
				$val = trim($val);
			$href = wfMsgForContent($nt[0]);
			$text = wfMsgForContent($nt[1]);
			$perm = array_key_exists(2, $nt) ? $nt[2] : 'read';
			if(!$wgUser->isAllowed($perm))
				continue;
			if(wfEmptyMsg($nt[0], $href))
				$href = $nt[0];
			if(wfEmptyMsg($nt[1], $text))
				$text = $nt[1];
			$ca[$nt[0]] = array( 'class' => false, 'text' => $text, 'href' => $href );
		}
	}
	//just in case this gets loaded late and wipes out any other extensions that mess with the content actions, run them again
	define('IN_GPM', true); //this prevents this from being run more than once per pageload (which is a good thing, considering we're recursively calling the hook again)
	global $egSkinObj;
	if($egSkinObj instanceOf SkinTemplate && $egSkinObj->iscontent) {
		wfRunHooks('SkinTemplateTabs', array(&$egSkinObj, &$ca));
	} elseif($egSkinObj instanceOf SkinTemplate) {
		wfRunHooks('SkinTemplateBuildContentActionUrlsAfterSpecialPage', array(&$egSkinObj, &$ca));
	}
	$res = wfRunHooks('SkinTemplateContentActions', array(&$ca));
	return $res; //if one of the extensions returned false, then we return false
}

function efGPManagerGetSkin(&$skin, $ca) {
	global $egSkinObj;
	$egSkinObj = $skin;
	return true;
}