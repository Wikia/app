<?php

/**
 * RandomWiki
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-10-14
 * @copyright Copyright (C) 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named RandomWiki.\n";
	exit(1) ;
}

class RandomWiki extends SpecialPage {

	function RandomWiki() {
                SpecialPage::SpecialPage('RandomWiki', 'editaccount');
        }
          
	function execute() {
		global $wgOut, $wgSharedDB;

		$dbr = wfGetDB( DB_SLAVE );
		$dbr->selectDB( $wgSharedDB );

		$res = $dbr->select( 'city_list', array( 'city_url' ), array( 'city_public' => 1 ) );

		$totalWikis = $dbr->numRows( $res );

		$randomNum = mt_rand( 0, $totalWikis - 1 );

		$dbr->dataSeek( $res, $randomNum );

		$targetWiki = $dbr->fetchObject( $res );

		$wgOut->redirect( $targetWiki->city_url );
	}

}
