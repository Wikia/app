<?php

/**
 * Share Feature extension
 *
 * Extension allows users/anons to share a link to the page with popular sites
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * 
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
	$function = '';
	echo "<li id=\"control_share_feature\"><a href=\"#\" onclick=\"" . $function . "\">" . wfMsg('sf-link') . "</a></li>";
	return true;
}

// initialize the extension
function ShareFeature_init() {
        global $wgExtensionMessagesFiles;
        $wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__).'/ShareFeature.i18n.php';
        wfLoadExtensionMessages('ShareFeature');
}

