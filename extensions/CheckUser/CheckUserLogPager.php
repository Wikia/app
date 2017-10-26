<?php

class CheckUserLogPager extends ReverseChronologicalPager {
	private $searchConds, $specialPage;

	/** @var array map of user IDs to user names */
	private $userNames = [];

	function __construct( $specialPage, $searchConds, $y, $m ) {
		parent::__construct();

		$this->getDateCond( $y, $m );
		$this->searchConds = $searchConds ? $searchConds : array();
		$this->specialPage = $specialPage;
	}

	function formatRow( $row ) {
		global $wgLang;

		$skin = $this->getSkin();

		if ( $row->cul_reason === '' ) {
			$comment = '';
		} else {
			$comment = $skin->commentBlock( $row->cul_reason );
		}

		if ( isset( $this->userNames[$row->cul_user] ) ) {
			$user = $skin->userLink( $row->cul_user, $this->userNames[$row->cul_user] );
		}

		// SUS-3115: When getting user's IPs, or user's edits in CU, the target is an user and is// logged as such
		if ( ( $row->cul_type == 'userips' || $row->cul_type == 'useredits' ) &&
			 isset( $this->userNames[$row->cul_target_id] )
		) {
			$target = $skin->userLink( $row->cul_target_id, $this->userNames[$row->cul_target_id] );
			$target .= $skin->userToolLinks( $row->cul_target_id, $this->userNames[$row->cul_target_id] );
		} else {
			$target = $row->cul_target_text;
		}

		return '<li>' .
			$wgLang->timeanddate( wfTimestamp( TS_MW, $row->cul_timestamp ), true ) .
			wfMsg( 'comma-separator' ) .
			wfMsg(
				'checkuser-log-' . $row->cul_type,
				$user,
				$target
			) .
			$comment .
			'</li>';
	}

	/**
	 * SUS-3115: Load user names for user IDs contained in the result set
	 * @param ResultWrapper $result
	 */
	protected function preprocessResults( $result ) {
		$userIds = [];

		foreach ( $result as $row ) {
			if ( $row->cul_user > 0 ) {
				$userIds[] = $row->cul_user;
			}

			if ( $row->cul_target_id > 0 ) {
				$userIds[] = $row->cul_target_id;
			}
		}

		$result->rewind();
		
		$this->userNames = User::whoAre( $userIds );
	}

	function getStartBody() {
		if ( $this->getNumRows() ) {
			return '<ul>';
		} else {
			return '';
		}
	}

	function getEndBody() {
		if ( $this->getNumRows() ) {
			return '</ul>';
		} else {
			return '';
		}
	}

	function getEmptyBody() {
		return '<p>' . wfMsgHtml( 'checkuser-empty' ) . '</p>';
	}

	function getQueryInfo() {
		return [
			'tables' => [ 'cu_log' ],
			'fields' => $this->selectFields(),
			'conds' => $this->searchConds,
		];
	}

	function getIndexField() {
		return 'cul_timestamp';
	}

	function selectFields() {
		return array(
			'cul_id', 'cul_timestamp', 'cul_user', 'cul_reason', 'cul_type',
			'cul_target_id', 'cul_target_text', 'user_name'
		);
	}
}
