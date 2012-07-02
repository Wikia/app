<?php

/**
 * SecurePoll subpage to show a list of votes for a given election.
 * Provides an administrator interface for striking fraudulent votes.
 */
class SecurePoll_ListPage extends SecurePoll_Page {
	var $election;

	/**
	 * Execute the subpage.
	 * @param $params array Array of subpage parameters.
	 */
	function execute( $params ) {
		global $wgOut, $wgUser, $wgStylePath;

		if ( !count( $params ) ) {
			$wgOut->addWikiMsg( 'securepoll-too-few-params' );
			return;
		}
		
		$electionId = intval( $params[0] );
		$this->election = $this->context->getElection( $electionId );
		if ( !$this->election ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-election', $electionId );
			return;
		}
		$this->initLanguage( $wgUser, $this->election );

		$wgOut->setPageTitle( wfMsg( 
			'securepoll-list-title', $this->election->getMessage( 'title' ) ) );

		$pager = new SecurePoll_ListPager( $this );
		$wgOut->addHTML( 
			$pager->getLimitForm() . 
			$pager->getNavigationBar() . 
			$pager->getBody() . 
			$pager->getNavigationBar()
		);
		if ( $this->election->isAdmin( $wgUser ) ) {
			$msgStrike = wfMsgHtml( 'securepoll-strike-button' );
			$msgUnstrike = wfMsgHtml( 'securepoll-unstrike-button' );
			$msgCancel = wfMsgHtml( 'securepoll-strike-cancel' );
			$msgReason = wfMsgHtml( 'securepoll-strike-reason' );
			$encAction = htmlspecialchars( $this->getTitle()->getLocalUrl() );
			$encSpinner = htmlspecialchars( "$wgStylePath/common/images/spinner.gif" );
			$script = Skin::makeVariablesScript( array(
				'securepoll_strike_button' => wfMsg( 'securepoll-strike-button' ),
				'securepoll_unstrike_button' => wfMsg( 'securepoll-unstrike-button' )
			) );

			$wgOut->addHTML( <<<EOT
$script
<div class="securepoll-popup" id="securepoll-popup">
<form id="securepoll-strike-form" action="$encAction" method="post" onsubmit="securepoll_strike('submit');return false;">
<input type="hidden" id="securepoll-vote-id" name="vote_id" value=""/>
<input type="hidden" id="securepoll-action" name="action" value=""/>
<label for="securepoll-strike-reason">{$msgReason}</label>
<input type="text" size="45" id="securepoll-strike-reason"/>
<p>
<input class="securepoll-confirm-button" type="button" value="$msgCancel" 
	onclick="securepoll_strike('cancel');"/>
<input class="securepoll-confirm-button" id="securepoll-strike-button" 
	type="button" value="$msgStrike" onclick="securepoll_strike('strike');" />
<input class="securepoll-confirm-button" id="securepoll-unstrike-button" 
	type="button" value="$msgUnstrike" onclick="securepoll_strike('unstrike');" />
</p>
</form>
<div id="securepoll-strike-result"></div>
<div id="securepoll-strike-spinner"><img src="$encSpinner"/></div>
</div>
EOT
			);
		}
	}

	/**
	 * The entry point for XHR invocation of strike/unstrike.
	 * @param $action string The action, either "strike" or "unstrike"
	 * @param $id integer The vote ID
	 * @param $reason string The reason for the action, specified by the admin
	 * @return JSON object describing the result. Fields are:
	 *    status:  "good" for success, "bad" for failure
	 *    message: The HTML error message
	 */
	static function ajaxStrike( $action, $id, $reason ) {
		$page = new SecurePoll_BasePage;
		$context = $page->sp_context;
		$db = $context->getDB();
		$table = $db->tableName( 'securepoll_elections' );
		$row = $db->selectRow( 
			array( 'securepoll_votes', 'securepoll_elections' ),
			"$table.*", 
			array( 'vote_id' => $id, 'vote_election=el_entity' ), 
			__METHOD__
		);
		if ( !$row ) {
			return Xml::encodeJsVar( (object)array(
				'status' => 'bad',
				'message' => wfMsgHtml( 'securepoll-strike-nonexistent' )
			) );
		}
		$page = new SecurePoll_BasePage;
		$subpage = new self( $page );
		$subpage->election = $context->newElectionFromRow( $row );
		$status = $subpage->strike( $action, $id, $reason );
		if ( $status->isGood() ) {
			return Xml::encodeJsVar( (object)array( 'status' => 'good' ) );
		} else {
			global $wgOut;
			return Xml::encodeJsVar( (object)array(
				'status' => 'bad',
				'message' => $wgOut->parse( $status->getWikiText( 'securepoll-strike-error' ) )
			) );
		}
	}

	/**
	 * The strike/unstrike backend.
	 * @todo provide a non-AJAX frontend for this.
	 * @param $action string strike or unstrike
	 * @param $voteId integer The vote ID
	 * @param $reason string The reason
	 */
	function strike( $action, $voteId, $reason ) {
		global $wgUser;
		$dbw = $this->context->getDB();
		if ( !$this->election->isAdmin( $wgUser ) ) {
			return Status::newFatal( 'securepoll-need-admin' );
		}
		if ( $action != 'strike' ) {
			$action = 'unstrike';
		}
		$dbw->begin();

		// Add it to the strike log
		$strikeId = $dbw->nextSequenceValue( 'securepoll_strike_st_id' );
		$dbw->insert( 'securepoll_strike', 
			array(
				'st_id' => $strikeId,
				'st_vote' => $voteId,
				'st_timestamp' => wfTimestampNow( TS_DB ),
				'st_action' => $action,
				'st_reason' => $reason,
				'st_user' => $wgUser->getId()
			), 
			__METHOD__ 
		);
		$strikeId = $dbw->insertId();

		// Update the status cache
		$dbw->update( 'securepoll_votes', 
			array( 'vote_struck' => intval( $action == 'strike' ) ), 
			array( 'vote_id' => $voteId ), 
			__METHOD__ 
		);
		$dbw->commit();
		return Status::newGood();
	}

	/**
	 * @return Title object
	 */
	function getTitle() {
		return $this->parent->getTitle( 'list/' . $this->election->getId() );
	}
}

/**
 * A TablePager for showing a list of votes in a given election. 
 * Shows much more information, and a strike/unstrike interface, if the user
 * is an admin.
 */
class SecurePoll_ListPager extends TablePager {
	var $listPage, $isAdmin, $election;

	static $publicFields = array(
		'vote_timestamp',
		'vote_voter_name',
		'vote_voter_domain',
	);

	static $adminFields = array(
		'details',
		'strike',
		'vote_timestamp',
		'vote_voter_name',
		'vote_voter_domain',
		'vote_ip',
		'vote_xff',
		'vote_ua',
		'vote_token_match',
		'vote_cookie_dup',
	);
	
	function __construct( $listPage ) {
		global $wgUser;
		$this->listPage = $listPage;
		$this->election = $listPage->election;
		$this->isAdmin = $this->election->isAdmin( $wgUser );
		parent::__construct();
	}

	function getQueryInfo() {
		return array(
			'tables' => 'securepoll_votes',
			'fields' => '*',
			'conds' => array( 
				'vote_election' => $this->listPage->election->getId()
			),
			'options' => array()
		);
	}

	function isFieldSortable( $field ) {
		return in_array( $field, array( 
			'vote_voter_name', 'vote_voter_domain', 'vote_timestamp', 'vote_ip' 
		) );
	}

	function formatValue( $name, $value ) {
		global $wgLang, $wgScriptPath;
		$critical = Xml::element( 'img', array( 
			'src' => "$wgScriptPath/extensions/SecurePoll/resources/critical-32.png" ) 
		);
		$voter = SecurePoll_Voter::newFromId( 
			$this->listPage->context, 
			$this->mCurrentRow->vote_voter
		);

		switch ( $name ) {
		case 'vote_timestamp':
			return $wgLang->timeanddate( $value );
		case 'vote_ip':
			return IP::formatHex( $value );
		case 'vote_cookie_dup':
			$value = !$value;
			// fall through
		case 'vote_token_match':
			if ( $value ) {
				return '';
			} else {
				return $critical;
			}
		case 'details':
			$voteId = intval( $this->mCurrentRow->vote_id );
			$title = $this->listPage->parent->getTitle( "details/$voteId" );
			return Xml::element( 'a', 
				array( 'href' => $title->getLocalUrl() ),
				wfMsg( 'securepoll-details-link' )
			);
			break;
		case 'strike':
			$voteId = intval( $this->mCurrentRow->vote_id );
			if ( $this->mCurrentRow->vote_struck ) {
				$label = wfMsg( 'securepoll-unstrike-button' );
				$action = "'unstrike'";
			} else {
				$label = wfMsg( 'securepoll-strike-button' );
				$action = "'strike'";
			}
			$id = 'securepoll-popup-' . $voteId;
			return Xml::element( 'input', 
				array( 
					'type' => 'button', 
					'id' => $id, 
					'value' => $label,
					'onclick' => "securepoll_strike_popup(event, $action, $voteId)"
				) );
		case 'vote_voter_name':
			$msg = $voter->isRemote()
				? 'securepoll-voter-name-remote'
				: 'securepoll-voter-name-local';
			return wfMsgExt(
				$msg,
				'parseinline',
				array( $value )
			);
		default:
			return htmlspecialchars( $value );
		}
	}

	function getDefaultSort() {
		return 'vote_timestamp';
	}

	function getFieldNames() {
		$names = array();
		if ( $this->isAdmin ) {
			$fields = self::$adminFields;
		} else {
			$fields = self::$publicFields;
		}
		foreach ( $fields as $field ) {
			$names[$field] = wfMsg( 'securepoll-header-' . strtr( $field, 
				array( 'vote_' => '', '_' => '-' ) ) );
		}
		return $names;
	}

	function getRowClass( $row ) {
		$classes = array();
		if ( !$row->vote_current ) {
			$classes[] = 'securepoll-old-vote';
		}
		if ( $row->vote_struck ) {
			$classes[] = 'securepoll-struck-vote';
		}
		return implode( ' ', $classes );
	}

	function getTitle() {
		return $this->listPage->getTitle();
	}
}
