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
        'version' => '0.45',
);

$dir = dirname(__FILE__).'/';

$wgShareFeatureSites = array(
		array( 
			'name' => 'Reddit',
			'url' => 'http://www.reddit.com/submit?url=$1&title=$2'
		),
		array( 
			'name' => 'Facebook',
			'url' => 'http://www.facebook.com/sharer.php?u=$1?t=$2'
		),
		array( 
			'name' => 'Twitter',
			'url' => 'http://twitter.com/home?status=$1'
		), // message and url goes into the parameter
		array( 
			'name' => 'Digg',
			'url' => 'http://digg.com/submit?url=$1&title=$2'
		),
		array(
			'name' => 'Stumbleupon',
			'url' => 'http://www.stumbleupon.com/submit?url=$1&title=$2'
		),
		array(
			'name' => 'Technorati',
			'url' => 'http://www.technorati.com/faves/?add=$1'
		),
		array( 
			'name' => 'Slashdot',
			'url' => 'http://slashdot.org/bookmark.pl?url=$1&title=$2'
		),
		array(
			'name' => 'MySpace',
			'url' => 'http://www.myspace.com/Modules/PostTo/Pages/?l=3&u=$1&t=$2'
		),
);


$wgExtensionFunctions[] = 'wfShareFeatureInit';
$wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__) . '/ShareFeature.i18n.php';
$wgHooks['SkinTemplateContentActions'][] = 'wfShareFeatureSkinTemplateContentActions';

function wfShareFeatureMakeUrl( $site, $target, $title ) {
	global $wgShareFeatureSites;
	$url = str_replace( '$1', $target, $site );
	$url = str_replace( '$2', $title, $url );
	
	return $url;
}

function wfShareFeatureSortSites( $sites, $target, $title ) {
	global $wgUser, $wgShareFeatureSites, $wgExternalSharedDB;
	$stored_sites = array();

	$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB );
	
	$res = $dbr->select(
			'share_feature',
			'sf_provider_id',
			array( 'sf_user_id' => $wgUser->getId() ),
			__METHOD__,
			array( 'ORDER BY' => 'sf_clickcount DESC' )
			);		

	$sites = array();
	$found = array();
	// get all the sites we have data for
        while($row = $dbr->fetchObject($res)) {		
		$site = $wgShareFeatureSites[$row->sf_provider_id];
		$sites[] = array( $site['name'], wfShareFeatureMakeUrl( $site['url'], $target, $title ) );
		$found[] = $site['name'];
        }
	// and other ones, that weren't clicked for this user
	foreach( $wgShareFeatureSites as $sf_site ) {		
		if( !in_array( $sf_site['name'], $found ) ) {
			$sites[] = array( $sf_site['name'], wfShareFeatureMakeUrl( $sf_site['url'], $target, $title )  );
		}
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
	$wgAjaxExportList[] = 'wfShareFeatureAjaxUpdateStats';
}

function wfShareFeatureAjaxUpdateStats() {
	global $wgUser;

	
}

function wfShareFeatureAjaxGetDialog() {	
	global $wgTitle, $wgCityId, $wgShareFeatureSites, $wgServer, $wgArticlePath;

	$title = htmlspecialchars( $wgTitle->getText() );	
	$wiki = $wgServer . str_replace( '$1', $title, $wgArticlePath );

	$tpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
	$tpl->set_vars( array(
		'title' => $title,
		'wiki' 	=> $wiki,
		'sites'	=> wfShareFeatureSortSites( $wgShareFeatureSites, $wiki, $title ),
	));
	
	$text = $tpl->execute('dialog');
	$response = new AjaxResponse( $text );
	$response->setCacheDuration( 60 * 2 );
	$response->setContentType('text/plain; charset=utf-8');

	return $response;
}


