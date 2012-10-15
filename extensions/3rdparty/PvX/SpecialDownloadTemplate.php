<?php
/**
 * DownloadTemplate
 *
 * This extension is used on pvx.wikia.com in conjunction with PvXcode
 * to download the character build template to disk
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2009-05-04
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named DownloadTemplate.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
        'name' => 'DownloadTemplate',
        'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
        'description' => 'Dedicated special page for downloading build templates.'
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['DownloadTemplate'] = $dir. 'SpecialDownloadTemplate_body.php';
$wgSpecialPages['DownloadTemplate'] = 'DownloadTemplate';
