<?php
/**
 * Special page to go to a random page in your test wiki
 * (or a specific wiki if it is defined through &testwiki=Wx/xx)
 *
 * @file
 * @ingroup SpecialPage
 * @author Robin Pepermans (SPQRobin)
 */

class SpecialRandomByTest extends RandomPage {
	public function __construct() {
		global $wgUser, $wgRequest, $wmincPref, $wmincProjectSite;
		$target = $wgRequest->getVal( 'testwiki' );
		$target = IncubatorTest::analyzePrefix( $target );
		$project = isset( $target['project'] ) ? $target['project'] : '';
		$lang = isset( $target['lang'] ) ? $target['lang'] : '';
		if( IncubatorTest::isContentProject() || ( $project && $lang ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$this->extra[] = 'page_title' .
				$dbr->buildLike( IncubatorTest::displayPrefix( $project, $lang ) . '/', $dbr->anyString() );
		} elseif( $wgUser->getOption($wmincPref . '-project') == $wmincProjectSite['short'] ) {
			# project or help namespace
			$this->extra['page_namespace'] = array( 4, 12 );
		}
		parent::__construct( 'RandomByTest' );
	}
}
