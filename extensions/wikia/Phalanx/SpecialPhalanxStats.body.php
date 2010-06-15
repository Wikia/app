<?php

class PhalanxStats extends UnlistedSpecialPage {
	function __construct( ) {
		parent::__construct( 'PhalanxStats', 'phalanx' );
	}

	function execute( $par ) {
		global $wgOut, $wgLang;

		if ( empty( $par ) ) {
			return true;
		}

		$block = array();
		$block = Phalanx::getFromId( intval($par) );

		if ( empty( $block ) ) {
			// give some message
			return true;
		}

		// process block data for display
		$block['author_id'] = User::newFromId( $block['author_id'] )->getName();
		$block['timestamp'] = $wgLang->timeanddate( $block['timestamp'] );
		$block['expire'] = $wgLang->timeanddate( $block['expire'] );
		$block['exact'] = $block['exact'] ? 'Yes' : 'No';
		$block['regex'] = $block['exact'] ? 'Yes' : 'No';
		$block['case'] = $block['case'] ? 'Yes' : 'No';
		$block['type'] = implode( ', ', Phalanx::getTypeNames( $block['type'] ) );

		//TODO: add i18n
		$headers = array(
			'Block ID',
			'Added by',
			'Text',
			'Type',
			'Created on',
			'Expires on',
			'Exact',
			'Regex',
			'Case',
			'Reason',
			'Language',
		);

		$html = '';

		$html .=  Xml::buildTable( array( $block ), array(), $headers );

		$pager = new PhalanxStatsPager( $par );

		$html .= $pager->getNavigationBar();
		$html .= $pager->getBody();
		$html .= $pager->getNavigationBar();
	
		$wgOut->addHTML( $html );
	}
}

class PhalanxStatsPager extends ReverseChronologicalPager {
	public function __construct( $id ) {
		global $wgExternalSharedDB;

		parent::__construct();
		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$this->mBlockId = (int) $id;
	}

	function getQueryInfo() {
		$query['tables'] = 'phalanx_stats';
		$query['fields'] = '*';
		$query['conds'] = array(
			'ps_blocker_id' => $this->mBlockId,
		);

		return $query;
	}

	function getIndexField() {
		return 'ps_timestamp';
	}

	function getStartBody() {
		return '<ul>';
	}

	function getEndBody() {
		return '</ul>';
	}

	function formatRow( $row ) {
		global $wgLang;

		$html = '<li>';
		$html .= implode( Phalanx::getTypeNames( $row->ps_blocker_type ) ); 
		$html .= ' blocked user ' . User::newFromId( $row->ps_blocked_user )->getName();
		$html .= ' on ' . $wgLang->timeanddate( $row->ps_timestamp );
		$html .= ' at wiki ' . $row->ps_wiki_id;
		$html .= '</li>';

		return $html;
	}
}
