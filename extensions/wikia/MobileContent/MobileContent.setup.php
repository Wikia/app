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

$app = F::build( 'App' );

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

$app->registerHook( 'ParserFirstCallInit', 'MobileContentParser', 'onParserFirstCallInit' );

// allow for override in DefaultSettings
if ( empty( $wgMobileSkins ) ) $wgMobileSkins = array(  'wikiphone', 'wikiaapp' );

function efOnMobileDisplay( $contents, $attributes, $parser ) {
	$app = F::build('App');
	$skin = $app->getGlobal( 'wgUser' )->getSkin();
	$wgMobileSkins = $app->getGlobal( 'wgMobileSkins' );

	if ( in_array( $skin->getSkinName(), $wgMobileSkins ) ) {
		return $contents;
	} else {
		return '';
	}
}

function efOnMobileHide( $contents, $attributes, $parser ) {
        $app = F::build('App');
        $skin = $app->getGlobal( 'wgUser' )->getSkin();
        $wgMobileSkins = $app->getGlobal( 'wgMobileSkins' );

	if ( in_array( $skin->getSkinName(), $wgMobileSkins ) ) {
		return '';
	} else {
		return $contents;
	}
}
