<?php

/**
 * Special:SecurePoll subpage for showing the details of a given vote to an administrator.
 */
class SecurePoll_DetailsPage extends SecurePoll_Page {
	/**
	 * Execute the subpage.
	 * @param $params array Array of subpage parameters.
	 */
	function execute( $params ) {
		global $wgOut, $wgUser, $wgLang;

		if ( !count( $params ) ) {
			$wgOut->addWikiMsg( 'securepoll-too-few-params' );
			return;
		}
		
		$this->voteId = intval( $params[0] );

		$db = $this->context->getDB();
		$row = $db->selectRow( 
			array( 'securepoll_votes', 'securepoll_elections', 'securepoll_voters' ),
			'*',
			array(
				'vote_id' => $this->voteId,
				'vote_election=el_entity',
				'vote_voter=voter_id',
			),
			__METHOD__
		);
		if ( !$row ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-vote', $this->voteId );
			return;
		}

		$this->election = $this->context->newElectionFromRow( $row );
		$this->initLanguage( $wgUser, $this->election );

		$this->parent->setSubtitle( array( 
			$this->parent->getTitle( 'list/' . $this->election->getId() ), 
			wfMsg( 'securepoll-list-title', $this->election->getMessage( 'title' ) ) ) );

		if ( !$this->election->isAdmin( $wgUser ) ) {
			$wgOut->addWikiMsg( 'securepoll-need-admin' );
			return;
		}
		# Show vote properties
		$wgOut->setPageTitle( wfMsg( 
			'securepoll-details-title', $this->voteId ) );

		$wgOut->addHTML(
			'<table class="TablePager">' .
			$this->detailEntry( 'securepoll-header-id', $row->vote_id ) .
			$this->detailEntry( 'securepoll-header-timestamp', $row->vote_timestamp ) .
			$this->detailEntry( 'securepoll-header-voter-name', $row->voter_name ) .
			$this->detailEntry( 'securepoll-header-voter-type', $row->voter_type ) .
			$this->detailEntry( 'securepoll-header-voter-domain', $row->voter_domain ) .
			$this->detailEntry( 'securepoll-header-url', $row->voter_url ) .
			$this->detailEntry( 'securepoll-header-ip', IP::formatHex( $row->vote_ip ) ) .
			$this->detailEntry( 'securepoll-header-xff', $row->vote_xff ) .
			$this->detailEntry( 'securepoll-header-ua', $row->vote_ua ) .
			$this->detailEntry( 'securepoll-header-token-match', $row->vote_token_match ) .
			'</table>'
		);

		# Show voter properties
		$wgOut->addHTML( '<h2>' . wfMsgHTML( 'securepoll-voter-properties' ) . "</h2>\n" );
		$wgOut->addHTML( '<table class="TablePager">' );
		$props = SecurePoll_Voter::decodeProperties( $row->voter_properties );
		foreach ( $props as $name => $value ) {
			if ( is_array( $value ) ) {
				$value = implode( ', ', $value );
			}
			$wgOut->addHTML( 
				'<td class="securepoll-detail-header">' .
				htmlspecialchars( $name ) . "</td>\n" .
				'<td>' . htmlspecialchars( $value ) . "</td></tr>\n"
			);
		}
		$wgOut->addHTML( '</table>' );

		# Show cookie dups
		$cmTable = $db->tableName( 'securepoll_cookie_match' );
		$voterId = intval( $row->voter_id );
		$sql = "(SELECT cm_voter_2 as voter, cm_timestamp FROM $cmTable WHERE cm_voter_1=$voterId)" .
			" UNION " . 
			"(SELECT cm_voter_1 as voter, cm_timestamp FROM $cmTable WHERE cm_voter_2=$voterId)";
		$res = $db->query( $sql, __METHOD__ );
		if ( $res->numRows() ) {
			$wgOut->addHTML( '<h2>' . wfMsgHTML( 'securepoll-cookie-dup-list' ) . '</h2>' );
			$wgOut->addHTML( '<table class="TablePager">' );
			foreach ( $res as $row ) {
				$voter = $this->context->getVoter( $row->voter );
				$wgOut->addHTML(
					'<tr>' .
					'<td>' . htmlspecialchars( $wgLang->timeanddate( $row->cm_timestamp ) ) . '</td>' . 
					'<td>' . 
					Xml::element( 
						'a', 
						array( 'href' => $voter->getUrl() ), 
						$voter->getName() . '@' . $voter->getDomain()
					) .
					'</td></tr>'
				);
			}
			$wgOut->addHTML( '</table>' );
		}		

		# Show strike log
		$wgOut->addHTML( '<h2>' . wfMsgHTML( 'securepoll-strike-log' ) . "</h2>\n" );
		$pager = new SecurePoll_StrikePager( $this, $this->voteId );
		$wgOut->addHTML(
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}

	/**
	 * Get a table row with a given header message and value
	 * @param $header string
	 * @param $value string
	 * @return string
	 */
	function detailEntry( $header, $value ) {
		return "<tr>\n" .
			"<td class=\"securepoll-detail-header\">" .	wfMsgHTML( $header ) . "</td>\n" .
			'<td>' . htmlspecialchars( $value ) . "</td></tr>\n";
	}

	/**
	 * Get a Title object for the current subpage.
	 * @return Title
	 */
	function getTitle() {
		return $this->parent->getTitle( 'details/' . $this->voteId );
	}
}

/**
 * Pager for the strike log. See TablePager documentation.
 */
class SecurePoll_StrikePager extends TablePager {
	var $detailsPage, $voteId;

	function __construct( $detailsPage, $voteId ) {
		$this->detailsPage = $detailsPage;
		$this->voteId = $voteId;
		parent::__construct();
	}

	function getQueryInfo() {
		return array(
			'tables' => array( 'user', 'securepoll_strike' ),
			'fields' => '*',
			'conds' => array(
				'st_vote' => $this->voteId,
				'st_user=user_id',
			),
			'options' => array()
		);
	}

	function formatValue( $name, $value ) {
		global $wgUser, $wgLang;
		$skin = $wgUser->getSkin();
		switch ( $name ) {
		case 'st_user':
			return $skin->userLink( $value, $this->mCurrentRow->user_name );
		case 'st_timestamp':
			return $wgLang->timeanddate( $value );
		default:
			return htmlspecialchars( $value );
		}
	}

	function getDefaultSort() {
		return 'st_timestamp';
	}

	function getFieldNames() {
		return array(
			'st_timestamp' => wfMsgHtml( 'securepoll-header-timestamp' ),
			'st_user' => wfMsgHtml( 'securepoll-header-admin' ),
			'st_action' => wfMsgHtml( 'securepoll-header-action' ),
			'st_reason' => wfMsgHtml( 'securepoll-header-reason' ),
		);
	}

	function getTitle() {
		return $this->detailsPage->getTitle();
	}

	function isFieldSortable( $name ) {
		return $name == 'st_timestamp';
	}
}
