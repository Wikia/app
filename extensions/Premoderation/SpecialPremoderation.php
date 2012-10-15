<?php
class SpecialPremoderation extends SpecialPage {
	protected $mParams = false;
	protected $mPosted = false;
	protected $mRequest = array();
	protected $mSummary = '';
	public $mAllowedStatus = array( 'new', 'approved', 'declined' );
	
	function __construct() {
		global $wgRequest;
		parent::__construct( 'Premoderation', 'premoderation' );
		
		if( $wgRequest->wasPosted() ) {			
			$this->mPosted = true;
			$this->mRequest = $wgRequest->getValues();		
		}
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut;
		
		if( !$wgUser->isAllowed( 'premoderation' ) ) {
			$this->displayRestrictionError();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		
		$params = array_values( explode( '/', $subpage ) );
		$action = array_shift( &$params );
		
		if( $action == '' ) {
			$action = 'list';
		} elseif( isset( $params ) ) {
			$this->mParams = Premoderation::formatParams( $params );
		}
		
		switch( $action ) {
			case 'list':
				$this->showList();
				break;
				
			case 'status':
				( $this->mPosted ) ? $this->performChanges() : $this->statusInterface();
				break;
				
			default:
				$wgOut->setPageTitle( wfMsg( 'premoderation-manager-invalidaction' ) );
				$wgOut->addWikiMsg( 'premoderation-invalidaction' );
		}
	}
	
	protected function showList() {
		global $wgOut, $wgArticlePath;
		
		$wgOut->setPageTitle( wfMsg( 'premoderation-manager-mainpage' ) );
		$wgOut->addWikiMsg( 'premoderation-list-intro' );
		
		$dbr = wfGetDB( DB_SLAVE );
		$params = $this->mParams;
		$conds = 'pmq_status <> "approved"';
		if( isset( $params['offset'] ) ) {
			$conds .= ' AND pmq_timestamp < ' . $dbr->addQuotes( $params['offset'] );
		}
		
		$res = $dbr->select(
			'pm_queue',
			array(
				'pmq_id', 'pmq_page_ns', 'pmq_page_title', 'pmq_user', 'pmq_user_text',
				'pmq_timestamp', 'pmq_minor', 'pmq_summary', 'pmq_len', 'pmq_status',
				'pmq_updated', 'pmq_updated_user_text'
			),
			$conds,
			__METHOD__,
			array( 'ORDER BY' => 'pmq_timestamp DESC', 'LIMIT' => 101 )
		);
		
		$result = array();
		for( $a = 0; $a < 101; $a++ ) {
			$row = $dbr->fetchRow( $res );
			if( $a == 100 ) {
				$offset = $row['pmq_timestamp'];
				break;
			}
			if( !$row ) {
				break;
			}
			$status = $row['pmq_status'];
			$result[$status][] = $row;
		}
		
		if( isset( $offset ) ) {
			$wgOut->addHtml( Linker::link( $this->getTitle( "list/offset/$offset" ),
				wfMsgHtml( 'premoderation-next' ) ) );
		}
		
		if( isset( $result['new'] ) ) {
			$msg = wfMsg( 'premoderation-list-new-h2' );
			$wgOut->addWikiText( '<h2>' . $msg . '</h2>' );
			
			$output = $this->getListTableHeader( 'new' );
			foreach( $result['new'] as $row ) {
				$output .= $this->formatListTableRow( $row );
			}
			$output .= Xml::closeElement( 'table' );
			
			$wgOut->addHTML( $output );
		}
		
		if( isset( $result['declined'] ) ) {
			$msg = wfMsg( 'premoderation-list-declined-h2' );
			$wgOut->addWikiText( '<h2>' . $msg . '</h2>' );
			
			$output = $this->getListTableHeader( 'declined' );
			foreach( $result['declined'] as $row ) {
				$output .= $this->formatListTableRow( $row );
			}
			$output .= Xml::closeElement( 'table' );
			
			$wgOut->addHTML( $output );
		}		
	}
	
	protected function getListTableHeader( $type ) {
		return Xml::openElement( 'table', array( 'id' => 'prem-table-' . $type,
			'class' => 'wikitable', 'style' => 'width: 90%' ) ) .
			'<tr><th>' . wfMsg( 'premoderation-table-list-time' ) . '</th>' .
			'<th>' . wfMsg( 'premoderation-table-list-user' ) . '</th>' .
			'<th colspan="2">' . wfMsg( 'premoderation-table-list-title' ) . '</th>' .
			'<th>' . wfMsg( 'premoderation-table-list-summary' ) . '</th>' .
			'<th>' . wfMsg( 'premoderation-table-list-status' ) . '</th><tr>';
	}
	
	protected function formatListTableRow( $row ) {
		global $wgLang;
		
		return '<tr><td>' . $wgLang->timeanddate( $row['pmq_timestamp'] ) . '</td>' .
			'<td>' . Linker::userLink( $row['pmq_user'], $row['pmq_user_text'] ) . '</td>' .
			'<td>' . Linker::link( Title::newFromText( $row['pmq_page_title'], $row['pmq_page_ns'] ) ) .
			'</td><td>' . ( $row['pmq_minor'] == 0 ? '' : ' ' . wfMsg( 'minoreditletter' ) ) . '</td>' .
			'<td>' . $row['pmq_summary'] . '</td><td>' .
			Linker::link( $this->getTitle( "status/id/" . $row['pmq_id'] ),
			wfMessage( 'premoderation-status-' . $row['pmq_status'] . 
			( $row['pmq_updated_user_text'] ? '-changed' : '-added' ),
			array( $row['pmq_updated_user_text'] ) ) ) . '</td></tr>';
	}
	
	protected function statusInterface() {
		global $wgOut, $wgUser, $wgPremoderationStrict;
		
		$params = $this->mParams;
		if( !isset( $params['id'] ) ) {
			$wgOut->setPageTitle( wfMsg( 'premoderation-manager-invalidaction' ) );
			$wgOut->addWikiMsg( 'premoderation-invalidaction' );
			return;		
		}
		
		$id = intval( $params['id'] );
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'pm_queue',
			'*',
			"pmq_id = '$id'",
			__METHOD__,
			array( 'LIMIT' => 1 )
		);
		$row = $dbr->fetchRow( $res );
		if( !$row ) {
			$wgOut->setPageTitle( wfMsg( 'premoderation-manager-invalidaction' ) );
			$wgOut->addWikiMsg( 'premoderation-notexists-id' );
			return;
		}
		
		$wgOut->setPageTitle( wfMsg( 'premoderation-manager-status' ) );
		$wgOut->addWikiMsg( 'premoderation-status-intro' );
		
		$wgOut->addHTML( '<h2>' . wfMsg( 'premoderation-status-info' ) . '</h2>' .
			$this->getListTableHeader( 'status' ) . $this->formatListTableRow( $row ) .
			Xml::closeElement( 'table' ) );
		
		if( $wgUser->isAllowed( 'premoderation-viewip' ) ) {
			$wgOut->addWikiMsg( 'premoderation-private-ip', $row['pmq_ip'] );
		}
		
		$rev = Revision::newFromID( $row['pmq_page_last_id'] );
		$diff = new DifferenceEngine();
		$diff->showDiffStyle();
		$formattedDiff = $diff->generateDiffBody(
			isset( $rev ) ? $rev->getText() : '', $row['pmq_text']
		);
		
		$wgOut->addHTML( '<h2>' . wfMsg( 'premoderation-diff-h2' ) . '</h2>' .
			"<table class='mw-abusefilter-diff-multiline'><col class='diff-marker' />" .
			"<col class='diff-content' /><col class='diff-marker' /><col class='diff-content' />" .
			"<tbody>" . $formattedDiff . "</tbody></table>" );
		
		if( $row['pmq_status'] == 'approved' ) {
			return;
		}
		
		$externalConflicts = $this->checkExternalConflicts( $row['pmq_page_last_id'],
			$row['pmq_page_ns'], $row['pmq_page_title'] );
		if( $externalConflicts ) {
			$wgOut->addHTML( '<h2>' . wfMsg( 'premoderation-external-conflicts-h2' ) . '</h2>' );
			if( $wgPremoderationStrict ) {
				$wgOut->addWikiMsg( 'premoderation-error-externals' );
				return;			
			}
			$wgOut->addWikiMsg( 'premoderation-external-edits' );
		}
		
		$this->checkInternalConflicts( $dbr, $id, $row['pmq_page_ns'], $row['pmq_page_title'] );
		
		$final = Xml::fieldset( wfMsg( 'premoderation-status-fieldset' ) ) .
			Xml::openElement( 'form', array( 'id' => 'prem-status-form', 'method' => 'post' ) ) .
			$this->getStatusForm( $row['pmq_status'] ) .
			'<input type="hidden" name="id" value="' . $id . '" />' .
			Xml::closeElement( 'form' ) . Xml::closeElement( 'fieldset' );
			
		$wgOut->addHTML( $final );
	}
	
	protected function checkExternalConflicts( $lastId, $ns, $page ) {
		global $wgOut;
		
		$title = Title::newFromText( $page, $ns );
		return $title->getLatestRevID() > $lastId;
	}
	
	protected function checkInternalConflicts( $db, $id, $ns, $page ) {
		global $wgOut;
		
		$res = $db->select(
			'pm_queue',
			'*',
			array(
				'pmq_page_ns' => $ns,
				'pmq_page_title' => $page,
				"pmq_id <> $id",
				'pmq_status <> "approved"'
			),
			__METHOD__,
			array( 'ORDER BY' => 'pmq_timestamp DESC', 'LIMIT' => 20 )
		);
		
		$test = $db->fetchRow( $res );
		if( $test ) {
			$output = '<h2>' . wfMsg( 'premoderation-internal-conflicts-h2' ) . '</h2>' .
				wfMsg( 'premoderation-internal-conflicts-intro' ) . $this->getListTableHeader( 'int-conflicts' ) .
				$this->formatListTableRow( $test );
			
			while( $row = $db->fetchRow( $res ) ) {
				$output .= $this->formatListTableRow( $row );
			}
			$output .= Xml::closeElement( 'table' );
			
			$wgOut->addHTML( $output );
		}
	}
	
	protected function getStatusForm( $status ) {
		$statusList = ( $status == 'new' ) ? array( 'approved', 'declined' ) :
			array( 'new', 'approved' );
		
		$options = '';
		foreach( $statusList as $item ) {
			$options .= Xml::option( wfMsg("premoderation-status-$item"), $item );
		}
		
		return "<table><tr><td><span style='white-space: nowrap'>" . Xml::tags( 'select',
			array( 'id' => 'prem-status-selector', 'name' => 'statusselector' ), $options ) .
			'</span></td></tr><tr><td>' . wfMsg( 'summary' ) . ' ' .
			Xml::input( 'summary', 90, '', array( 'id' => 'prem-summary' ) ) . '</td></tr><tr>' .
			'<td>' . Xml::submitButton( wfMsg( 'htmlform-submit' ), array( 'id' => 'prem-submit' ) ) .
			'</td></tr></table>';
	}
	
	protected function performChanges() {
		global $wgOut;
		
		$data = $this->mRequest;
		
		$newstatus = $data['statusselector'];
		$id = intval( $data['id'] );
		$this->mSummary = isset( $data['summary'] ) ? $data['summary'] : '';
		
		if( !in_array( $newstatus, $this->mAllowedStatus ) || !$id ) {
			$wgOut->setPageTitle( wfMsg( 'premoderation-manager-invalidaction' ) );
			$wgOut->addWikiMsg( 'premoderation-bad-request' );
			return;
		}
		
		if( $newstatus == 'approved' ) {
			$ok = $this->approveRevision( $id );
			$s = $this->changeStatus( $id, $newstatus );
			
			if( $ok && $s ) {
				$wgOut->setPageTitle( wfMsg( 'premoderation-success' ) );
				$wgOut->addWikiMsg( 'premoderation-success-approved' );
			}
		} else {
			$ok = $this->changeStatus( $id, $newstatus );
			
			if( $ok && $this->addLogEntry( 'status', array( $id, $newstatus ) ) ) {
				$wgOut->setPageTitle( wfMsg( 'premoderation-success' ) );
				$wgOut->addWikiMsg( 'premoderation-success-changed-text' );
			}
		}
	}
	
	protected function changeStatus( $id, $status ) {
		global $wgUser;
		
		$dbw = wfGetDB( DB_MASTER );
		$query = array(
			'pmq_status' => $status,
			'pmq_updated' => $dbw->timestamp( wfTimestampNow() ),
			'pmq_updated_user' => $wgUser->getID(),
			'pmq_updated_user_text' => $wgUser->getName()
		);
		$ok = $dbw->update( 'pm_queue', $query, array( 'pmq_id' => $id ), __METHOD__ );
		
		return $ok;
	}
	
	protected function approveRevision( $id ) {
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->fetchRow(
			$dbw->select( 'pm_queue', '*', "pmq_id = '$id'", __METHOD__ )
		);
		
		$title = Title::newFromText( $res['pmq_page_title'], $res['pmq_page_ns'] );
		$user = User::newFromName( $res['pmq_user_text'] );
		
		$row = array(
			'page' => 0,
			'user' => $user->getID(),
			'user_text' => $user->getName(),
			'minor_edit' => $res['pmq_minor'],
			'timestamp' => $res['pmq_timestamp'],
			'comment' => $res['pmq_summary'],
			'text' => $res['pmq_text']
		);
		
		$rev = new Revision( $row );
		$revId = $rev->insertOn( $dbw );
		
		$conflict = $this->checkExternalConflicts( $res['pmq_page_last_id'],
			$res['pmq_page_ns'], $res['pmq_page_title'] );
		if( !$conflict ) {
			$wikipage = WikiPage::factory( $title );
			
			if( $res['pmq_page_last_id'] == 0 ) {
				$pageId = $wikipage->insertOn( $dbw );
				$cond = array( 'page_id' => $pageId );
				$actionType = 'create';
				
				$dbw->update(
					'revision',
					array( 'rev_page' => $pageId ),
					array( 'rev_id' => $revId ),
					__METHOD__
				);
			} else {
				$wikipage->updateRevisionOn( $dbw, $rev );
				$cond = array( 'page_latest' => $res['pmq_page_last_id'] );
				$actionType = 'update';
				
				$dbw->update(
					'revision',
					array(
						'rev_page' => $title->getArticleID(),
						'rev_parent_id' => $title->getLatestRevID()
					),
					array( 'rev_id' => $revId ), __METHOD__
				);
			}
			
			$dbw->update(
				'page',
				array( 'page_latest' => $revId, 'page_len' => $rev->getSize() ),
				$cond,
				__METHOD__
			);
		} else {
			$actionType = 'updateold';
			
			$latestRevId = intval( $title->getLatestRevID() );
			$res = $dbw->fetchRow(
				$dbw->select( 'revision', 'rev_parent_id', "rev_id = '$latestRevId'", __METHOD__ )
			);
			
			$dbw->update(
				'revision',
				array( 
					'rev_page' => $title->getArticleID(),
					'rev_parent_id' => $res['rev_parent_id']
				),
				array( 'rev_id' => $revId ),
				__METHOD__
			);
			$dbw->update(
				'revision',
				array( 'rev_parent_id' => $revId ),
				array( 'rev_id' => $latestRevId ),
				__METHOD__
			);
		}
		
		$dbw->commit();
		$ok = $this->addLogEntry( $actionType, array( $title->getDBkey(), $revId ), 'public' );
		
		return $revId && $ok;
	}
	
	protected function addLogEntry( $type, $params = array(), $visible = 'private' ) {
		$log = new LogPage( 'prem-' . $visible );
		
		$self = $this->getTitle();
		$ok = $log->addEntry( $type, $self, $this->mSummary, $params );
		
		return $ok;
	}
}