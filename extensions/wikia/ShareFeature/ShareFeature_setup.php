<?php
/*
 * @author Bartek Łapiński 
 */

if(!defined('MEDIAWIKI')) {
        exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'ShareFeature',
        'author' => 'Bartek Łapiński',
        'version' => '0.12',
);

$dir = dirname(__FILE__).'/';

$wgExtensionFunctions[] = 'ShareFeature_init';
$wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__) . '/ShareFeature.i18n.php';
$wgHooks['MonacoAfterArticleLinks'][] = 'SFMonacoAfterArticleLinks';

// display the links for the feature in the page controls bar
function SFMonacoAfterArticleLinks() {
	echo "<li id=\"control_share_feature\"><a href=\"#\">" . wfMsg('sf-link') . "</a></li>";
	return true;
}

function ShareFeature_init() {
        global $wgAutoloadClasses, $wgExtensionMessagesFiles;
        $wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__).'/ShareFeature.i18n.php';
        wfLoadExtensionMessages('ShareFeature');
}

