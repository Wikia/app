<?php
/**
 * HelperPanel
 *
 * A helper panel extension for MediaWiki
 * Displays a panel providing information for users depending on action and login state
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia.com>
 * @date 2007-11-27
 * @copyright Copyright (C) 2007 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/HelperPanel/HelperPanel.php");
 */

if(!defined( 'MEDIAWIKI' ) ) {
	echo "This is an extension to the MediaWiki package and cannot be run standalone.\n";
	exit( -1 );
}

# Internationlization file
require_once( 'HelperPanel.i18n.php' );

$wgExtensionCredits['other'][] = array(
	'name' => 'HelperPanel',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'This extension displays a panel providing information for users depending on action and login state.'
);

$wgExtensionFunctions[] = 'HelperPanelInit';
$wgHooks['HTMLBeforeWidgets'][] = 'HelperPanelShow';

/**
 * Function determines if panel should be visible on current page or not
 * @return bool visibility
 */
function displayPanel() {
	global $wgOut, $wgTitle, $wgRequest;

	$action = $wgRequest->getVal('action');
	$namespace = $wgTitle->getNamespace();

	# Don't display helper panel for editing MediaWiki messages (it's not regular article)
	if($namespace == NS_MEDIAWIKI) {
		return false;
	}

	# Display helper panel for action edit and submit
	if($action == 'edit' || $action == 'submit') {
		return true;
	}

	# Display helper panel for SpecialPage with name 'Createpage'
	if($namespace == NS_SPECIAL && $wgTitle->getDBkey() == 'Createpage') {
		return true;
	}

	return false;
}

/**
 * Function initiates the extension
 */
function HelperPanelInit() {
	global $wgMessageCache, $wgHelperPanelWikiMessages, $wgAjaxExportList;
	#--- Add messages
	foreach( $wgHelperPanelWikiMessages as $key => $value )
		$wgMessageCache->addMessages( $wgHelperPanelWikiMessages[$key], $key );

	$wgAjaxExportList[] = 'setHelperPanelState';
}

/**
 * Function displays the panel
 */
function HelperPanelShow() {
	if (displayPanel()) {	//check if we want to display panel
		global $wgUser, $wgRequest, $wgOut, $wgParser, $wgTitle;

		$namespace = $wgTitle->getNamespace();

		$artTitle				= 'helperPanel';				//any action, logged in or not
		$artTitleLogged			= 'helperPanelLogged';			//when user is logged in
		$artTitleCreate			= 'helperPanelCreate';			//when action is create
		$artTitleCreateLogged	= 'helperPanelCreateLogged';	//when action is create and user is logged in

		//get states
		$pageTitle = $wgTitle->getDBkey();
		$isLoggedIn = $wgUser->isLoggedIn();

		$actionArray = array();
		array_push($actionArray, $artTitle);

		if ($isLoggedIn) {
			array_push($actionArray, $artTitleLogged);
		}
		if ($namespace == NS_SPECIAL && $pageTitle == 'Createpage') {
			array_push($actionArray, $artTitleCreate);
		}
		if ($namespace == NS_SPECIAL && $pageTitle == 'Createpage' && $isLoggedIn) {
			array_push($actionArray, $artTitleCreateLogged);
		}

		//try to load the message (article in MediaWiki namespace)
		$artLoaded = false;
		while(!$artLoaded && count($actionArray))
		{
			$title = array_pop($actionArray);
			$content = wfMsg($title);
			if (!wfEmptyMsg($title, $content)) {
				$output = $wgOut->parse($content);
				$artLoaded = true;
			}
		}
		if ($artLoaded && $output != '') {
			$HelperPanelState = $wgUser->getOption('HelperPanelState');

			//HTML snippets
			$HelperPanelHTMLbegin = '
			<div id="sidebar_buttons" class="articleBar" style="background-position: right top; padding-right: 8px">
				<a href="#" id="sidebar_button_helper"' . ($HelperPanelState == 'helper' ? ' class="selected"' : '') . '>' . wfMsg('helperPanel_help') . '</a>
				<a href="#" id="sidebar_button_widgets"' . ($HelperPanelState == 'widgets' ? ' class="selected"' : '') . '>' . wfMsg('helperPanel_widgets') . '</a>
			</div>
			<div id="sidebar_helper" style="clear: both">
				<ul class="widgets widgets_vertical" style="min-height: 1px">
					<li class="widget">';
			$HelperPanelHTMLend = '
					</li>
				</ul>
			</div>';

			//CSS snippets
			$HelperPanelCSSnoScript = '
			<noscript>
				<style type="text/css">
					#sidebar_buttons {display: none}
					#sidebar_widgets {display: block ! important}
					#sidebar_helper {display: block ! important}
				</style>
			</noscript>';
			$HelperPanelCSS = "#sidebar_buttons a {float: right}\n";

			switch ($HelperPanelState) {
				case 'helper':
				default:
					$HelperPanelCSS .= "\t\t\t\t#sidebar_widgets {display: none}";
					break;
				case 'widgets':
					$HelperPanelCSS .= "\t\t\t\t#sidebar_helper {display: none}";
					break;
			}
			$HelperPanelCSSnormal = "
			<style type=\"text/css\">
				$HelperPanelCSS
			</style>";

			//add CSS
			echo $HelperPanelCSSnormal;
			echo $HelperPanelCSSnoScript;

			//add content
			$HelperPanelHTMLcontent = "\n<div id=\"HelperPanel\">\n$output\n</div>\n";
			echo $HelperPanelHTMLbegin . $HelperPanelHTMLcontent . $HelperPanelHTMLend;
		}
	}
	return true;
}

/**
 * Function store the state of HelperPanel sent by AJAX when user change the state
 */
function setHelperPanelState($state) {
	global $wgUser;
	if (!$wgUser->isLoggedIn()) {
		return 'Not logged';	//returned strings are not used - there're just for info purpose
	}
	$wgUser->setOption('HelperPanelState', $state);
	$wgUser->saveSettings();
	return 'OK';
}
?>