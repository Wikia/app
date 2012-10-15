<?php
/**
 * @file
 * @ingroup Extensions
 * @author Maciej Brencz <macbre(at)-spam-wikia.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

class PagerWhosOnline extends IndexPager {
	function __construct() {
		parent::__construct();
		$this->mLimit = $this->mDefaultLimit;
	}

	function getQueryInfo() {
		global $wgWhosOnlineShowAnons;

		return array(
			'tables'  => array( 'online' ),
			'fields'  => array( 'username' ),
			'options' => array( 'ORDER BY' => 'timestamp DESC' ),
			'conds'   => $wgWhosOnlineShowAnons
					? array()
					: array( 'userid != 0' )
		);
	}

	// use classical LIMIT/OFFSET instead of sorting by table key
	function reallyDoQuery( $offset, $limit, $descending ) {
		$info = $this->getQueryInfo();
		$tables = $info['tables'];
		$fields = $info['fields'];
		$conds = isset( $info['conds'] ) ? $info['conds'] : array();
		$options = isset( $info['options'] ) ? $info['options'] : array();

		$options['LIMIT']  = intval( $limit );
		$options['OFFSET'] = intval( $offset );

		$res = $this->mDb->select( $tables, $fields, $conds, __METHOD__, $options );

		return new ResultWrapper( $this->mDb, $res );
	}

	function getIndexField() {
		return 'username'; // dummy
	}

	function formatRow( $row ) {
		$userPageLink = Title::makeTitle( NS_USER, $row->username )->getFullURL();

		return '<li><a href="' . htmlspecialchars( $userPageLink ) . '">' .
			htmlspecialchars( $row->username ) . '</a></li>';
	}

	// extra methods
	function countUsersOnline() {
		wfProfileIn( __METHOD__ );

		$row = $this->mDb->selectRow(
			'online',
			'COUNT(*) AS cnt',
			'userid != 0',
			__METHOD__
		);
		$users = (int) $row->cnt;

		wfProfileOut( __METHOD__ );

		return $users;
	}

	function getNavigationBar() {
		global $wgContLang;

		return wfViewPrevNext(
			$this->mOffset,
			$this->mLimit,
			$wgContLang->specialpage( 'WhosOnline' ),
			'',
			$this->countUsersOnline() < ( $this->mLimit + $this->mOffset ) // show next link
		);
	}
}

class SpecialWhosOnline extends IncludableSpecialPage {
	public function __construct() {
		parent::__construct( 'WhosOnline' );
	}

	// get list of logged-in users being online
	protected function getAnonsOnline() {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );

		$row = $dbr->selectRow(
			'online',
			'COUNT(*) AS cnt',
			'userid = 0',
			__METHOD__
		);
		$guests = (int) $row->cnt;

		wfProfileOut( __METHOD__ );

		return $guests;
	}

	public function execute( $para ) {
		global $wgOut, $wgDBname;

		$db = wfGetDB( DB_MASTER );
		$db->selectDB( $wgDBname );
		$old = gmdate( 'YmdHis', time() - 3600 );
		$db->delete( 'online', array( 'timestamp < "' . $old . '"' ), __METHOD__ );

		$this->setHeaders();

		$pager = new PagerWhosOnline();

		$showNavigation = !$this->including();
		if ( $para ) {
			$bits = preg_split( '/\s*,\s*/', trim( $para ) );
			foreach ( $bits as $bit ) {
				if ( $bit == 'shownav' ) {
					$showNavigation = true;
				}
				if ( is_numeric( $bit ) ) {
					$pager->mLimit = $bit;
				}

				$m = array();
				if ( preg_match( '/^limit=(\d+)$/', $bit, $m ) ) {
					$pager->mLimit = intval( $m[1] );
				}
			}
		}

		$body = $pager->getBody();

		if ( $showNavigation ) {
			$wgOut->addHTML( $pager->getNavigationBar() );
		}

		$wgOut->addHTML( '<ul>' . $body . '</ul>' );
	}
}
