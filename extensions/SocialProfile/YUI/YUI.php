<?php
$wgExtensionFunctions[] = "wfYUI";

$wgExtensionCredits['other'][] = array(
        'name' => 'Yahoo! User Interface Library',
        'author' => 'Yahoo! Inc.',
        'url' => 'http://www.mediawiki.org/wiki/Extension:SocialProfile',
        'description' => 'A set of utilities and controls, written in JavaScript',
	'descriptionmsg' => 'yui-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['YUI'] = $dir . 'yui.i18n.php';

function wfYUI() {
	global $wgOut, $wgScriptPath, $wgStyleVersion;
	$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgScriptPath}/extensions/SocialProfile/YUI/yui.js?{$wgStyleVersion}\"></script>\n");
}
