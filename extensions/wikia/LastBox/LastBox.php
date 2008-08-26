<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Display box with 5 last visited Wikis
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Tomasz Klim <tomek@wikia.com>
 * @copyright Copyright (C) 2007 Tomasz Klim, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
LocalSettings.php:
+ require_once( "$IP/extensions/LastBox/LastBox.php" );
 *
 */

$wgLastBoxMessages = array();
$wgLastBoxMessages['en'] = array(
	'lb_title'                 => 'recently visited wikis',
);
$wgLastBoxMessages['pl'] = array(
	'lb_title'                 => 'ostatnio odwiedzone wikie',
);


$wgHooks['MonoBookTemplateTipsStart'][] = 'wfLastBox';
$wgExtensionCredits['other'][] = array(
	'name' => 'Recently visited Wikis',
	'description' => 'displays last 5 visited Wikis',
	'author' => 'Tomasz Klim'
);


function wfLastBox( $empty ) {
	global $wgMessageCache, $wgLastBoxMessages, $wgOut, $wgSitename;

	wfProfileIn( __METHOD__ );

	foreach ( $wgLastBoxMessages as $key => $value ) {
	    $wgMessageCache->addMessages( $wgLastBoxMessages[$key], $key );
	}

	// NOTE: we intentionally don't use $wgCookiePrefix below.

	$server = $_SERVER['SERVER_NAME'];
	$found = false;
	$count = 0;
	$urls = unserialize( $_COOKIE['recentlyvisited'] );

	// first, prepare the existing rank
	$ret = '<div class="portlet" id="p-tips"><h5>' . wfMsg( 'lb_title' ) . '</h5><div class="pBody"><ul>';

	for ( $index = 0; $index < 6; $index++ ) {
	    $url  = $urls[$index]['url' ];
	    $name = $urls[$index]['name'];

	    if ( $url == $server ) {
		$found = true;
	    } elseif ( $url != '' ) {
		$ret .= "<li><a href=\"http://$url\">$name</a></li>";
		$count++;
	    }
	}
	$ret .= '</ul></div>';

/*	$urls[0]['url'] = "furry.wikia.com";		$urls[0]['name'] = "Furry Wikia";
	$urls[2]['url'] = "staff.wikia.com";		$urls[2]['name'] = "Staff Wikia";
	$urls[4]['url'] = "sales.wikia.com";		$urls[4]['name'] = "Sales Wikia";
	$urls[5]['url'] = "rollins.wikia.com";		$urls[5]['name'] = "Rollins Wikia";
	$urls[1]['url'] = "starwars.wikia.com";		$urls[1]['name'] = "Wookiepedia";
	$urls[3]['url'] = "superman.wikia.com";		$urls[3]['name'] = "Superman Wikia";
	setcookie( 'recentlyvisited', serialize( $urls ), time()+3600*24*7, '/', '.wikia.com', 0 );
	print_r($urls); */

	// next, insert actual Wikia to this rank
	if ( !$found ) {
	    for ( $index = 5; $index > 0; $index-- ) {
		$urls[$index]['url' ] = $urls[$index - 1]['url' ];
		$urls[$index]['name'] = $urls[$index - 1]['name'];
	    }
	    $urls[0]['url' ] = $server;
	    $urls[0]['name'] = $wgSitename;
	    setcookie( 'recentlyvisited', serialize( $urls ), time()+3600*24*7, '/', '.wikia.com', 0 );
	}

	// lastly, output the existing rank
	if ( $count ) {  echo $ret;  }

	wfProfileOut( __METHOD__ );
	return true;
}


?>
