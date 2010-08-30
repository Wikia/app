<?php
/**
 * Share Feature extension
 *
 * Extension allows users/anons to share a link to the page with popular sites
 * This extension uses its own form to present sites
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
	'name' => 'Share Feature',
	'author' => 'Bartek Łapiński',
	'version' => '1.10',
	'descriptionmsg' => 'sharefeature-desc',
);

$dir = dirname(__FILE__).'/';

$wgShareFeatureSites = array(
	array(
		'name' 	=>	'Reddit',
		'id' 	=>	0,
		'url' 	=>	'http://www.reddit.com/submit?url=$1&title=$2'
	),
	array(
		'name'	=>	'Facebook',
		'id'	=>	1,
		'url' 	=>	'http://www.facebook.com/sharer.php?u=$1?t=$2'
	),
	array(
		'name'	=>	'Twitter',
		'id'	=>	2,
		'url'	=>	'http://twitter.com/home?status=$1' . htmlspecialchars(' ') . '$2'
	), // message and url goes into the one parameter here for Twitter...
	array(
		'name'	=>	'Digg',
		'id'	=>	3,
		'url'	=>	'http://digg.com/submit?url=$1&title=$2'
	),
	array(
		'name'	=>	'Stumbleupon',
		'id'	=>	4,
		'url'	=>	'http://www.stumbleupon.com/submit?url=$1&title=$2'
	),
	array(
		'name'	=>	'Technorati',
		'id'	=>	5,
		'url'	=>	'http://www.technorati.com/faves/?add=$1'
	),
	array(
		'name'	=>	'Slashdot',
		'id'	=>	6,
		'url'	=>	'http://slashdot.org/bookmark.pl?url=$1&title=$2'
	),
	array(
		'name'	=>	'MySpace',
		'id'	=>	7,
		'url'	=>	'http://www.myspace.com/Modules/PostTo/Pages/?l=3&u=$1&t=$2'
	),
);

$wgExtensionFunctions[] = 'wfShareFeatureInit';
$wgExtensionMessagesFiles['ShareFeature'] = dirname(__FILE__) . '/ShareFeature.i18n.php';
$wgHooks['SkinTemplateContentActions'][] = 'wfShareFeatureSkinTemplateContentActions';


// substitute the parameters in url and title for different sites
function wfShareFeatureMakeUrl( $site, $target, $title ) {
	$url = str_replace( '$1', $target, $site );
	$url = str_replace( '$2', $title, $url );

	return $url;
}

// return the correct queue of sites depending on number of clicks
function wfShareFeatureSortSites( $sites, $target, $title ) {
	global $wgUser, $wgShareFeatureSites, $wgExternalStatsDB;

	$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB );

	$res = $dbr->select(
		'share_feature',
		'sf_provider_id',
		array( 'sf_user_id' => $wgUser->getId() ),
		__METHOD__,
		array( 'ORDER BY' => 'sf_clickcount DESC' )
	);

	$sites = array();
	$found = array();
	$title = rawurlencode( $title );
	$target = str_replace( " ", "_", $target );

	// get all the sites we have data for
	while($row = $dbr->fetchObject($res)) {
		$site = $wgShareFeatureSites[$row->sf_provider_id];
		$sites[] = array(
			'name' 	=>	$site['name'],
			'id'	=>	$site['id'],
			'url' 	=>	wfShareFeatureMakeUrl( $site['url'], $target, $title )
		);
		$found[] = $site['name'];
	}

	// and other ones, that weren't clicked for this user
	foreach( $wgShareFeatureSites as $sf_site ) {
		if( !in_array( $sf_site['name'], $found ) ) {
			$sites[] = array(
				'name'	=>	$sf_site['name'],
				'id'	=>	$sf_site['id'],
				'url'	=>	wfShareFeatureMakeUrl( $sf_site['url'], $target, $title )
			);
		}
	}

	return $sites;
}

// display the links for the feature in the page controls bar
function wfShareFeatureSkinTemplateContentActions( &$content_actions ) {
	global $wgTitle, $wgUser, $wgEnableBlogArticles;

	// do not display for not existing pages,
	// do not display for other skins than Monaco or Answers
	if( ( $wgTitle->isContentPage() ||
		( !empty( $wgEnableBlogArticles ) && $wgTitle->getNamespace() == NS_BLOG_ARTICLE && $wgTitle->isSubpage() ) )
		&& $wgTitle->exists()
		&& ( ( get_class($wgUser->getSkin()) == 'SkinOasis' ) || ( get_class($wgUser->getSkin()) == 'SkinMonaco' ) || ( get_class($wgUser->getSkin()) == 'SkinAnswers' ) ) ) {
		$content_actions['share_feature'] = array(
			'class' => 'disabled',
			'text' => wfMsg('sf-link'),
			'icon' => 'share',
			'href' => '#',
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

// update stats for all kinds of users (logged in and anon)
// anon is represented as a user with id 0, as in MW
function wfShareFeatureAjaxUpdateStats( ) {
	global $wgUser, $wgExternalStatsDB, $wgRequest;

	$id = $wgUser->getId();
	$provider = $wgRequest->getVal( 'provider', false );

	if ( ( !wfReadOnly() ) && ( $provider !== false ) ) {
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalStatsDB );

		// MW insert wrapper doesn't handle that syntax
		// it is used in about 2 extensions in all MW code...
		$query = 'INSERT INTO `share_feature`
			  ( sf_user_id, sf_provider_id, sf_clickcount ) VALUES( ' . $id  . ', ' . $provider . ', 1 )
			  ON DUPLICATE KEY UPDATE sf_clickcount = sf_clickcount + 1;
			 ';

		$res = $dbw->query( $query, __METHOD__ );

		$dbw->commit();
	}
	// todo number of rows affected

	$response = new AjaxResponse( "ok" );
	$response->setContentType('text/plain; charset=utf-8');
	return $response;
}

// return dialog for the extension
function wfShareFeatureAjaxGetDialog() {
	global $wgTitle, $wgCityId, $wgShareFeatureSites, $wgServer, $wgArticlePath, $wgRequest;

	$footer = $wgRequest->getVal( 'footer' );
	$title = htmlspecialchars( $wgTitle->getText() );
	$wiki = $wgTitle->getFullUrl();

	$tpl = new EasyTemplate( dirname( __FILE__ )."/templates/" );
	$tpl->set_vars( array(
		'title' => $title,
		'wiki' 	=> $wiki,
		'footer' => $footer,
		'sites'	=> wfShareFeatureSortSites( $wgShareFeatureSites, $wiki, $title ),
	));

	$text = $tpl->execute('dialog');
	$response = new AjaxResponse( $text );
	//$response->setCacheDuration( 60 * 2 );
	$response->setContentType('text/plain; charset=utf-8');

	return $response;
}
