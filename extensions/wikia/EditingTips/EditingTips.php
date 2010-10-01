<?php
/*
 * Author: Inez Korczynski
 */

$wgExtensionCredits['other'][] = array(
    'name' => 'EditingTips',
    'author' => array('Christian Williams', 'Inez Korczyński', 'Bartek Łapiński'),
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
	global $wgTitle, $wgParser, $wgOut, $wgEditingTipsContent, $wgWysiwygEdit;

	// macbre: don't show editing tips when editing using wysiwyg
	if (!empty($wgWysiwygEdit)) {
		return array();
	}

	if(!empty($wgEditingTipsContent)) {
		return $wgEditingTipsContent;
	} else {
		$tips = array();
		$text = wfMsg('EditingTips')."\n__NOTOC__\n__NOEDITSECTION__";
		$html = '<html>'.$wgOut->parse($text).'</html>';
		$doc = new DOMDocument("1.0", "ISO-8859-1");
		wfSuppressWarnings();
		$doc->loadHTML($html);
		wfRestoreWarnings();
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

function isWidescreenEnabled() {
	global $wgUser, $wgCookiePrefix;
	if($wgUser->isLoggedIn()) {
		$isWidescreen = $wgUser->getOption('widescreeneditingtips') ? true : false;
	} else {
		$isWidescreen = isset($_COOKIE[$wgCookiePrefix.'etw']);
	}
	return $isWidescreen;
}

function wfEditingTipsAddBodyClass($classes) {
	if ( isWidescreenEnabled() ) {
		$classes .= ' editingWide editingTips';
	}
	return true;
}

$wgHooks['EditPage::showEditForm:initial2'][] = 'AddEditingToggles';
function AddEditingToggles($o) {
	global $wgUser, $wgOut, $wgHooks, $editingTips;
	if( (get_class($wgUser->getSkin()) == 'SkinMonaco' || get_class($wgUser->getSkin()) == 'SkinOasis' || get_class($wgUser->getSkin()) == 'SkinAnswers') && $wgUser->getOption('enablerichtext') == false) {

		wfLoadExtensionMessages('EditingTips');
		$wgHooks['EditPage::showEditForm:fields'][] = 'AddEditingTips';
		$wgHooks['SkinGetPageClasses'][] = 'wfEditingTipsAddBodyClass';
		if (isset ($o->ImageSeparator)) {
			$sep = $o->ImageSeparator ;
			$marg = 'margin-left:5px;' ;
		} else {
			$sep = '' ;
			$marg = 'clear: both;' ;
			$o->ImageSeparator = ' - ' ;
		}
		$wgOut->addHtml('<div id="editingTipsToggleDiv" style="margin-top:20px; '. $marg . '">');


		if (Wikia::isOasis()) {
			$wgOut->addHtml($sep . '<a href="#" id="toggleEditingTips">'. (isEditingTipsEnabled() ? wfMsg ('editingtips_hide') : wfMsg ('editingtips_show') ).'</a>');
		}
		else {
			if (count(getEditingTips()) > 0) {
				$wgOut->addHtml($sep . '<a href="#" id="toggleEditingTips">'. (isEditingTipsEnabled() ? wfMsg ('editingtips_hide') : wfMsg ('editingtips_show') ).'</a> - ');
			}
		}

		/** don't show widescreen tips for Oasis **/
		if (Wikia::isOasis()) {
			$wgOut->addHtml('</div>');
		}
		else {
			$wgOut->addHtml('<a href="" id="toggleWideScreen">' . (isWidescreenEnabled() ? wfMsg('editingtips_exit_widescreen') : wfMsg ('editingtips_enter_widescreen')) .'</a></div>');
		}

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
	global $wgOut, $wgUser, $wgStylePath, $wgStyleVersion, $wgExtensionsPath ;

	/** Oasis skin detection **/
	if (!Wikia::isOasis()) {
		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/EditingTips/accordion-menu-v2.css?'.$wgStyleVersion.'" />');
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/EditingTips/accordion-menu-v2.js?'.$wgStyleVersion.'"></script>');
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/EditingTips/EditingTips.js?'.$wgStyleVersion.'"></script>');
	}
	else {
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/EditingTips/accordion-menu-oasis.js?'.$wgStyleVersion.'"></script>');
	}

	/** no YUI for Oasis, we use jQuery **/
	$script = "";
	if (Wikia::isOasis()) {
		/** delecration of language for accordion-menu-oasis.js **/
		$script = sprintf("
			var editingtips_show = '%s';
			var editingtips_hide = '%s';
			", wfMsg('editingtips_show'),wfMsg('editingtips_hide') );

		if ( count(getEditingTips()) > 0) {

			/** preset for the textarea and the elements **/
			if ( isEditingTipsEnabled() ) {
				$style = '
					<style type="text/css">

						#editform textarea {
							width: 714px;
							height: 350px !important;
							margin-bottom: 20px;
						}

						#mw-summary, #toolbar, #editform textarea, #editingTipsToggleDiv  {
							margin-left: 257px;
						}
					</style>
				';

				$wgOut->addHtml($style);
			}
		}
	}
	else {
		$script = '

				var showDone = false;
	'.(((count(getEditingTips()) > 0) && isEditingTipsEnabled()) ? 'YAHOO.util.Dom.addClass(document.body, "editingTips");AccordionMenu.openDtById("firstTip");var showDone = true;' : 'var showDone = false;').'
		var editingTipsShowMsg = "' . wfMsg ('editingtips_show')  . '" ;
		var editingTipsHideMsg = "' . wfMsg ('editingtips_hide')  . '" ;
		var editingTipsEnterMsg = "' . wfMsg ('editingtips_enter_widescreen')  . '" ;
		var editingTipsExitMsg = "' . wfMsg ('editingtips_exit_widescreen')  . '" ;';

	}

	$editor_visibility = (isEditingTipsEnabled() ) ? 'block' : 'none';

	$html = sprintf('<dl id="editingTips" class="accordion-menu widget reset" style="display: %s"><dt class="color1" style="cursor:text"><div class="widgetToolbox"><div class="close" id="editingTips_close"><span></span></div></div>Editing Tips</dt>',$editor_visibility);
	$first = true;
	foreach(getEditingTips() as $tid => $tip) {
		$html .= '<dt '.($first ? 'id="firstTip" ' : 'id="editingTip-'.$tid.'"').'class="a-m-t">'.$tip['title'].'</dt><dd class="a-m-d"><div class="bd">'.$tip['body'].'</div></dd>';
		$first = false;
	}
	$html .= '</dl>';

	$script = sprintf('<script type="text/javascript">%s</script>', $script);
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
		setcookie( $wgCookiePrefix.'etw', ($wgRequest->getVal('screen') == 'true') ? true : null, $exp, $wgCookiePath, $wgCookieDomain, $wgCookieSecure );
	}
	return new AjaxResponse(array());
}
