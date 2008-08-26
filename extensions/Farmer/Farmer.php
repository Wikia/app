<?php
/**
 * This file contains classes and functions for MediaWiki farmer, a tool to help
 * manage a MediaWiki farm
 *
 * @author Gregory Szorc <gregory.szorc@gmail.com>
 * @licence GNU General Public Licence 2.0 or later
 *
 * @todo Extension management on per-wiki basis
 * @todo Upload prefix
 * @todo Use MediaWiki messages
 *
 */

$root = dirname(__FILE__);

require_once $root . '/MediaWikiFarmer.php';
require_once $root . '/MediaWikiFarmer_Wiki.php';
require_once $root . '/MediaWikiFarmer_Extension.php';
$wgExtensionMessagesFiles['MediaWikiFarmer'] = $root . '/Farmer.i18n.php';

$wgFarmerSettings = array(
    'configDirectory'           =>  realpath(dirname(__FILE__)) . '/configs/',
    'defaultWiki'               =>  '',
    'wikiIdentifierFunction'    =>  array('MediaWikiFarmer', '_matchByURLHostname'),
    'matchRegExp'   =>  '',
    'matchOffset'   =>  null,
    'matchServerNameSuffix'    =>   '',

    'onUnknownWiki'             =>  array('MediaWikiFarmer', '_redirectTo'),
    'redirectToURL'             =>  '',

    'dbAdminUser'               =>  'root',
    'dbAdminPassword'           =>  '',

    'newDbSourceFile'           =>  realpath(dirname(__FILE__)) . '/daughterwiki.sql',

    'dbTablePrefixSeparator'    =>  '',
    'dbTablePrefix'             =>  '',

    'defaultMessagesFunction'    =>  array('MediaWikiFarmer', '_getDefaultMessages'),

    'perWikiStorageRoot'        => '',
    'defaultSkin'               => 'monobook',
);

$wgExtensionFunctions[] = 'MediaWikiFarmer_Initialize';

/**
 * These should really go in the initialize function, but MediaWiki initializes
 * $wgUser before the extensions are initialized.  Seems like weird behavior,
 * but OK.
 */
$wgGroupPermissions['*']['farmeradmin'] = false;
$wgGroupPermissions['sysop']['farmeradmin'] = true;
$wgGroupPermissions['*']['createwiki'] = false;
$wgGroupPermissions['sysop']['createwiki'] = true;
$wgAvailableRights[] = 'farmeradmin';
$wgAvailableRights[] = 'createwiki';

function MediaWikiFarmer_Initialize()
{
	wfLoadExtensionMessages( 'MediaWikiFarmer' );
    $wgFarmer = MediaWikiFarmer::getInstance();
    $wgExtensionCredits = MediaWikiFarmer::getMWVariable('wgExtensionCredits');
    $wgMessageCache = MediaWikiFarmer::getMWVariable('wgMessageCache');

    $wgExtensionCredits['specialpage'][] = array(
        'name'=>'Farmer',
        'author'=>'Gregory Szorc <gregory.szorc@case.edu>',
        'url'=>'http://wiki.case.edu/User:Gregory.Szorc',
        'description'=>'Manage a MediaWiki farm',
	'descriptionmsg' => 'farmer-desc',
        'version'=>'0.0.3'
    );


    require_once dirname(__FILE__) . '/MediaWikiFarmer_SpecialPage.php';

    //I would use the new method, but it didn't work for me...
    SpecialPage::addPage( new SpecialFarmer );
}
