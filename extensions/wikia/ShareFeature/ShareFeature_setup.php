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
		'Reddit' => 'http://www.reddit.com/submit?url=http://$1&title=$2',
		'Facebook' => 'http://www.facebook.com/sharer.php?u=http://$1?t=$2',
		'Twitter' => 'http://twitter.com/home?status=$1', // message and url goes into the parameter
		'Digg' => 'http://digg.com/submit?url=$1&title=$2',
		'Stumbleupon' => 'http://www.stumbleupon.com/submit?url=http://$1&title=$2',
		'Technorati' => 'http://www.technorati.com/faves/?add=http://$1',
		'Slashdot' => 'http://slashdot.org/bookmark.pl?url=http://$1&title=$2',
		'MySpace' => 'http://www.myspace.com/Modules/PostTo/Pages/?l=3&u=http://$1&t=$2',				
		);


$wgExtensionFunctions[] = 'wfShareFeatureInit';
$wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__) . '/ShareFeature.i18n.php';
$wgHooks['SkinTemplateContentActions'][] = 'wfShareFeatureSkinTemplateContentActions';


function wfShareFeatureMakeUrl( $site, $target, $title ) {
	global $wgShareFeatureSites;

	$url = str_replace( '$1', $target, $wgShareFeatureSites[$site] );
	$url = str_replace( '$2', $title, $url );
	
	return $url;
}

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


