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
        'version' => '0.35',
);

$dir = dirname(__FILE__).'/';

$wgShareFeatureSites = array(
		'Reddit',
		'Facebook',
		'Twitter',
		'Digg',
		'Stumbleupon',
		'Technorati',
		'Slashdot',
		'MySpace',				
		);

$wgExtensionFunctions[] = 'wfShareFeatureInit';
$wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__) . '/ShareFeature.i18n.php';
$wgHooks['SkinTemplateContentActions'][] = 'wfShareFeatureSkinTemplateContentActions';

function wfShareFeatureSortSites( &$sites ) {
	global $wgUser;
	// there will be a different procedure for anons,
	// and a different one for logged-in users	
	if( $wgUser->isLoggedIn() ) {



	} else {


	}
		
	return $sites;
}

// display the links for the feature in the page controls bar
function wfShareFeatureSkinTemplateContentActions( &$content_actions ) {
	global $wgTitle;
	if( $wgTitle->isContentPage() ) {
		$content_actions['share_feature'] = array(
				'class' => '',
				'text' => wfMsg('sf-link'),
				'href' => '#' ,
				);
	}
	return true;
}

// initialize the extension
function wfShareFeatureInit() {
        global $wgExtensionMessagesFiles, $wgAjaxExportList;
        $wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__).'/ShareFeature.i18n.php';
        wfLoadExtensionMessages('ShareFeature');

	$wgAjaxExportList[] = 'wfShareFeatureAjaxGetDialog';
}

function wfShareFeatureAjaxGetDialog() {	
	global $wgTitle, $wgCityId, $wgShareFeatureSites;
		
	$tpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
	$tpl->set_vars( array(
		'title' => $wgTitle,
		'wiki' 	=> $wgCityId,
		'sites'	=> wfShareFeatureSortSites( $wgShareFeatureSites ),
	));
	
	$text = $tpl->execute('dialog');
	$response = new AjaxResponse( $text );
	$response->setContentType('text/plain; charset=utf-8');

	return $response;
}


