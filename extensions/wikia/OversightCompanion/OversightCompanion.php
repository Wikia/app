<?php
/**
* OversightCompanion -- adds hidden teble if needed
*
* @package MediaWiki
* @subpackage Extensions
*
* @author: Lucas 'TOR' Garczewski <tor@wikia.com>
*
* @copyright Copyright (C) 2008 Lucas 'TOR' Garczewski, Wikia, Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
*/

if (!defined('MEDIAWIKI')){
    echo ('THIS IS NOT VALID ENTRY POINT.'); exit (1);
}

$wgExtensionFunctions [] = 'efInitializeOversightCompanion';

function efInitializeOversightCompanion(){
        global $wgHooks;

        $wgHooks['Oversight::getRevisions'][] = 'efAddHiddenTable';
        $wgHooks['Oversight::insertRevision'][] = 'efAddHiddenTable';
}

function efAddHiddenTable() {
	global $wgDBname;

	$dbw =& wfGetDB ( DB_MASTER );
	
	$dbw->selectDB( $wgDBname );

	if (!$dbw->tableExists('hidden')) {
		$sourcefile = "hidden.sql"; # name of SQL file
		$path = "/../../3rdparty/Oversight/"; # path to file, relative to this extension's dir
		$dbw->sourceFile( dirname( __FILE__ ) . $path . $sourcefile );
	}

	return true;
}
