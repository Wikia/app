<?php
/**
 * MobileContent
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2011-07-14
 * @copyright Copyright © 2011 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 3.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named MobileContent.\n";
        exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );

$app->wg->append(
        'wgExtensionCredits',
        array(
        	'name' => 'MobileContent',
		'version' => '1.0',
		'author' => array(
			"[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
			'Federico',
		),
	),
	'parserhook'
);

$wgHooks['ParserFirstCallInit'][] = 'MobileContentParser::onParserFirstCallInit';

/**
 * services
 */
$wgAutoloadClasses['MobileContentParser'] = "{$dir}/MobileContentParser.class.php";

// allow for override in DefaultSettings
if ( empty( $app->wg->mobileSkins ) ) $app->wg->mobileSkins = array( 'wikiphone', 'wikiamobile' );
