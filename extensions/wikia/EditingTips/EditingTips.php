<?php
/*
 * Author: Inez Korczynski
 */

$wgExtensionCredits['other'][] = array(
    'name' => 'EditingTips',
    'author' => 'Christian Williams, Inez Korczyński, Bartek Łapiński',
);

$wgExtensionMessagesFiles['EditingTips'] = dirname(__FILE__).'/'.'EditingTips.i18n.php';

function getTextOfDomElement($element) {
	$newDom = new DOMDocument("1.0", "ISO-8859-1");
	$newDom->appendChild($newDom->importNode($element,1));
	$xml = $newDom->saveXML();
	$xmlArray = split("\n", $xml);
	array_shift($xmlArray);
	return join("\n", $xmlArray);
}

function getEditingTips() {
	global $wgTitle, $wgParser, $wgOut, $wgEditingTipsContent;
	if(!empty($wgEditingTipsContent)) {
		return $wgEditingTipsContent;
	} else {
		$tips = array();
		$text = wfMsg('EditingTips')."\n__NOTOC__\n__NOEDITSECTION__";
		$html = '<html>'.$wgOut->parse($text).'</html>';
		$doc = new DOMDocument("1.0", "ISO-8859-1");
		$doc->loadHTML($html);
		$xpath = new DOMXPath($doc);
		$elements = $xpath->query("/html/body/*");
		$j = $i = $lastAi = $lastHi = 0;
		foreach ($elements as $element) {
			if($element->tagName == 'a') {
				$lastA = $element;
				$lastAi = $i;
			} else if($element->tagName == 'h1') {
				$lastH = $element;
				$lastHi = $i;
				if($lastHi == $lastAi+1) {
					$j++;
					$nodes = $element->getElementsByTagName('span');
					$subelement = $nodes->item(0);
					if(is_object($subelement)) {
						$tips[$j]['title'] = getTextOfDomElement($subelement);
					}
					$tips[$j]['body'] = '';
				} else {
					if(isset($lastA)) {
						$tips[$j]['body'] .= getTextOfDomElement($lastA);
					}
				}
			} else {
				if( isset( $tips[$j]['body'] ) ) {
					$tips[$j]['body'] .= getTextOfDomElement($element);
				}
			}
			$i++;
		}
		$wgEditingTipsContent = $tips;
		return $tips;
	}
}

$wgHooks['UserToggles'][] = 'wfEditingTipsToggle';
$wgHooks['getEditingPreferencesTab'][] = 'wfEditingTipsToggle';
$wgHooks['ExtendJSGlobalVars'][] = 'wfEditingTipsSetupVars';

function wfEditingTipsToggle($toggles, $default_array = false) {
	wfLoadExtensionMessages('EditingTips');
	if(is_array($default_array)) {
		$default_array[] = 'disableeditingtips';
		$default_array[] = 'widescreeneditingtips';		
	} else {
		$toggles[] = 'disableeditingtips';
		$toggles[] = 'widescreeneditingtips';
	}
	return true;
}


function isEditingTipsEnabled() {
	global $wgUser, $wgCookiePrefix;
	if($wgUser->isLoggedIn()) {
		return $wgUser->getOption('disableeditingtips') != true;
	} else {
		return isset($_COOKIE[$wgCookiePrefix.'et']) ? false : true;
	}
}

function wfEditingTipsSetupVars($vars) {
	global $wgUser, $wgCookiePrefix;
	if($wgUser->isLoggedIn()) {
		$vars['et_widescreen'] = $wgUser->getOption('widescreeneditingtips');
	} else {
		$vars['et_widescreen'] = isset($_COOKIE[$wgCookiePrefix.'etw']) ? 0 : 1;
	}
	return true;
}

$wgHooks['EditPage::showEditForm:initial2'][] = 'AddEditingToggles';
function AddEditingToggles($o) {
	global $wgUser, $wgOut, $wgHooks, $editingTips;
	if(get_class($wgUser->getSkin()) == 'SkinMonaco') {
		wfLoadExtensionMessages('EditingTips');
		$wgHooks['EditPage::showEditForm:fields'][] = 'AddEditingTips';
                if (isset ($o->ImageSeparator)) {
                        $sep = $o->ImageSeparator ;
			$marg = 'margin-left:5px;' ;
                } else {
                        $sep = '' ;
			$marg = 'clear: both;' ;
                        $o->ImageSeparator = ' - ' ;
                }
		$wgOut->addHtml('<div id="editingTipsToggleDiv" style="float: left; margin-top:20px; '. $marg . '">');

		if(count(getEditingTips()) > 0) {
			$wgOut->addHtml($sep . '<a href="" id="toggleEditingTips">'. (isEditingTipsEnabled() ? wfMsg ('editingtips_hide') : wfMsg ('editingtips_show') ).'</a> - ');
		}
		$wgOut->addHtml('<a href="" id="toggleWideScreen">' . wfMsg ('editingtips_enter_widescreen') .'</a></div>');		
		$wgOut->addHtml('
                        <noscript>
                                <style type="text/css">
                                        #editingTipsToggleDiv {display: none}
                                </style>
                        </noscript>
		') ;
	}
	return true;
}

function AddEditingTips($o) {
	global $wgOut, $wgStylePath, $wgStyleVersion, $wgExtensionsPath ;
	$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgStylePath.'/monaco/css/accordion-menu-v2.css?'.$wgStyleVersion.'" />');
	$wgOut->addScript('<script type="text/javascript" src="'.$wgStylePath.'/monaco/js/accordion-menu-v2.js?'.$wgStyleVersion.'"></script>');
	$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/EditingTips/EditingTips.js?'.$wgStyleVersion.'"></script>');

	$script = '
<script type="text/javascript">
'.(((count(getEditingTips()) > 0) && isEditingTipsEnabled()) ? 'YAHOO.util.Dom.addClass(document.body, "editingTips");AccordionMenu.openDtById("firstTip");var showDone = true;' : 'var showDone = false;').'
	var editingTipsShowMsg = "' . wfMsg ('editingtips_show')  . '" ;
	var editingTipsHideMsg = "' . wfMsg ('editingtips_hide')  . '" ;
	var editingTipsEnterMsg = "' . wfMsg ('editingtips_enter_widescreen')  . '" ;
	var editingTipsExitMsg = "' . wfMsg ('editingtips_exit_widescreen')  . '" ;

</script>';

	$html = '<dl id="editingTips" class="accordion-menu widget reset" style="display: none"><dt class="color1" style="cursor:text"><div class="widgetToolbox"><div class="close" id="editingTips_close"><span></span></div></div>Editing Tips</dt>';
	$first = true;
	foreach(getEditingTips() as $tid => $tip) {
		$html .= '<dt '.($first ? 'id="firstTip" ' : 'id="editingTip-'.$tid.'"').'class="a-m-t">'.$tip['title'].'</dt><dd class="a-m-d"><div class="bd">'.$tip['body'].'</div></dd>';
		$first = false;
	}
	$html .= '</dl>';
	$wgOut->addHtml($html.$script);
	return true;
}

$wgAjaxExportList[] = 'SaveEditingTipsState';
function SaveEditingTipsState() {
	global $wgRequest, $wgUser;
	if($wgUser->isLoggedIn()) {
		$wgUser->setOption('disableeditingtips', ($wgRequest->getVal('open') != 'true'));
		$wgUser->setOption('widescreeneditingtips', ($wgRequest->getVal('screen') == 'true'));
		$wgUser->SaveSettings();
		$dbw = wfGetDB( DB_MASTER );
		$dbw->commit();
	} else {
		global $wgCookieExpiration, $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgCookiePrefix;
		$exp = time() + $wgCookieExpiration;
		setcookie( $wgCookiePrefix.'et', ($wgRequest->getVal('open') != 'true') ? true : null, $exp, $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
		setcookie( $wgCookiePrefix.'etw', ($wgRequest->getVal('screen') != 'true') ? true : null, $exp, $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
	}
	return new AjaxResponse(array());
}
