<?php
/**
 * Wikia Search (v2) Extension (Powered by IndexTank)
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */


$app = F::app();
$dir = dirname(__FILE__) . '/';


/**
 * classes
 */
$app->registerClass('WikiaSearch', $dir . 'WikiaSearch.class.php');
$app->registerClass('WikiaSearchClient', $dir . 'WikiaSearchClient.class.php');
$app->registerClass('WikiaSearchController', $dir . 'WikiaSearchController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('WikiaSearch', 'WikiaSearchController');

/**
 * IndexTank setup
 */
require_once( $dir . 'flaptor-indextank-php/indextank.php');
$app->registerClass('IndexTankClient', $dir . 'IndexTankClient.class.php');

/**
 * DI setup
 */
F::addClassConstructor( 'IndexTankClient',
	array(
	 'apiUrl' => ( !empty( $wgWikiaSearchIndexTankApiUrl ) ? $wgWikiaSearchIndexTankApiUrl : false ),
	 'httpProxy' => ( !empty( $wgHTTPProxy ) ? $wgHTTPProxy : false )
	));
F::addClassConstructor( 'WikiaSearch', array( 'client' => F::build('IndexTankClient') ) );


$wgExtensionCredits['other'][] = array(
	'name'        => 'Wikia Search V2',
	'version'     => '2.0.1',
	'author'      => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
	'descriptionmsg' => 'wikia-search-desc',
);
