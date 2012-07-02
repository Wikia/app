<?php

class CheckUserLogPager extends ReverseChronologicalPager {
	var $searchConds, $specialPage, $y, $m;

	function __construct( $specialPage, $searchConds, $y, $m ) {
		parent::__construct();
		/*
		$this->messages = array_map( 'wfMsg',
			array( 'comma-separator', 'checkuser-log-userips', 'checkuser-log-ipedits', 'checkuser-log-ipusers',
			'checkuser-log-ipedits-xff', 'checkuser-log-ipusers-xff' ) );*/

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

		$user = $skin->userLink( $row->cul_user, $row->user_name );

		if ( $row->cul_type == 'userips' || $row->cul_type == 'useredits' ) {
			$target = $skin->userLink( $row->cul_target_id, $row->cul_target_text ) .
				$skin->userToolLinks( $row->cul_target_id, $row->cul_target_text );
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
		$this->searchConds[] = 'user_id = cul_user';
		return array(
			'tables' => array( 'cu_log', 'user' ),
			'fields' => $this->selectFields(),
			'conds'  => $this->searchConds
		);
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
