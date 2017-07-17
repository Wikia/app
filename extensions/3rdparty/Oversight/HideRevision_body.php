<?php

/**
 * Special page handler function for Special:HideRevision
 */
class HideRevisionForm extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'HideRevision', 'RevisionDelete' );
	}

	public function getRedirectQuery() {
		$revisionIds = $this->getRequest()->getIntArray( 'revision' );

		return [
			'action' => 'revisiondelete',
			'ids' => $revisionIds,
		];
	}
}

class SpecialOversight extends SpecialPage {

	function __construct(){
		parent::__construct( 'Oversight', 'oversight' );
	}

	/**
	 * Special page handler function for Special:Oversight
	 */
	function execute( $par ) {
		global $wgRequest, $wgUser, $wgRCMaxAge;

		$this->setHeaders();

		if( !$this->userCanExecute( $wgUser ) ){
			$this->displayRestrictionError();
			return;
		}

		$this->outputHeader();

		$revision = $wgRequest->getIntOrNull( 'revision' );
		if ( $wgRequest->getCheck( 'diff' ) && !is_null( $revision )) {
			$this->showDiff( $revision);
		} else if( is_null( $revision ) ) {
			$this->showList( time() - $wgRCMaxAge );
		} else {
			$this->showRevision( $revision );
		}
	}

	function showList( $from=null ) {
		global $wgOut;

		$dbr = wfGetDB( DB_SLAVE );

		$fromTime = $dbr->timestamp( $from );
		$result = $this->getRevisions( $dbr,
			array( 'hidden_on_timestamp >= ' . $dbr->addQuotes( $fromTime ) ) );

		$wgOut->addWikiText( wfMsgNoTrans( 'oversight-header' ) );
		$wgOut->addHtml( '<ul>' );
		while( $row = $dbr->fetchObject( $result ) ) {
			$wgOut->addHtml( $this->listRow( $row ) );
		}
		$wgOut->addHtml( '</ul>' );
		$dbr->freeResult( $result );
	}

	function getRevisions( $db, $condition ) {
		Hooks::run( 'Oversight::getRevisions', array(&$db, &$condition) );

		return $db->select(
			array( 'hidden', 'user' ),
			array(
				'hidden_page as page_id',
				'hidden_namespace as page_namespace',
				'hidden_title as page_title',

				'hidden_page as rev_page',
				'hidden_comment as rev_comment',
				'hidden_user as rev_user',
				'hidden_user_text as rev_user_text',
				'hidden_timestamp as rev_timestamp',
				'hidden_minor_edit as rev_minor_edit',
				'hidden_deleted as rev_deleted',
				'hidden_rev_id as rev_id',
				'hidden_text_id as rev_text_id',

				'0 as rev_len',

				'hidden_by_user',
				'hidden_on_timestamp',
				'hidden_reason',

				'user_name',

				'0 as page_is_new',
				'0 as rc_id',
				'1 as rc_patrolled',
				'0 as rc_old_len',
				'0 as rc_new_len',
				'0 as rc_params',

				'NULL AS rc_log_action',
				'0 AS rc_deleted',
				'0 AS rc_logid',
				'NULL AS rc_log_type' ),
			array_merge(
				$condition,
				array( 'hidden_by_user=user_id' ) ),
			__FUNCTION__,
			array(
				'ORDER BY' => 'hidden_on_timestamp DESC' ) );
	}

	function listRow( $row ) {
		global $wgUser, $wgLang;
		$skin = $wgUser->getSkin();
		$self = $this->getTitle();
		$userPage = Title::makeTitle( NS_USER, $row->user_name );
		$victim = Title::makeTitle( $row->page_namespace, $row->page_title );
		return "<li>(" .
			$skin->makeKnownLinkObj( $self, wfMsgHTML( 'oversight-view' ),
				'revision=' . $row->rev_id ) .
			") " .
			"(" .
			$skin->makeKnownLinkObj( $self, wfMsgHTML( 'diff' ),
				'revision=' . $row->rev_id . '&diff=1') .
			") " .
			$wgLang->timeanddate( $row->hidden_on_timestamp ) .
			" " .
			$skin->makeLinkObj( $userPage, htmlspecialchars( $userPage->getText() ) ) .
			" " .
			wfMsgHTML( 'oversight-log-hiderev', $skin->makeLinkObj( $victim ) ) .
			" " .
			$skin->commentBlock( $row->hidden_reason ) .
			"</li>\n";
	}

	function showRevision( $revision ) {
		global $wgOut;

		$dbr = wfGetDB( DB_SLAVE );
		$result = $this->getRevisions( $dbr, array( 'hidden_rev_id' => $revision ) );

		while( $row = $dbr->fetchObject( $result ) ) {
			$info = $this->listRow( $row );
			$list = $this->revisionInfo( $row );
			$rev = new Revision( $row );
			$text = $rev->getText();
			$wgOut->addHtml(
				"<ul>" .
				$info .
				"</ul>\n" .
				$list );
			if ( $text === false ) {
				$wgOut->addWikiText(wfMsg('hiderevision-error-missing'));
			} else {
				$wgOut->addHtml(
					"<div>" .
					Xml::openElement( 'textarea',
						array(
							'cols' => 80,
							'rows' => 25,
							'wrap' => 'virtual',
							'readonly' => 'readonly' ) ) .
					htmlspecialchars( $text ) .
					Xml::closeElement( 'textarea' ) .
					"</div>" );
			}
		}
		$dbr->freeResult( $result );
	}

	function revisionInfo( $row ) {
		global $wgUser;
		$changes = ChangesList::newFromContext( RequestContext::getMain() );
		$out = $changes->beginRecentChangesList();
		$rc = RecentChange::newFromCurRow( $row );
		$rc->counter = 0; // ???
		$out .= $changes->recentChangesLine( $rc );
		$out .= $changes->endRecentChangesList();
		return $out;
	}

	function showDiff( $revision ){
		global $wgOut;

		$dbr = wfGetDB( DB_SLAVE );
		$result = $this->getRevisions( $dbr, array( 'hidden_rev_id' => $revision ) );

		while( $row = $dbr->fetchObject( $result ) ) {
			$info = $this->listRow( $row );
			$list = $this->revisionInfo( $row );
			$rev = new Revision( $row );
			$rev->setTitle( Title::makeTitle( $row->page_namespace, $row->page_title ) );
			$prevId = $rev->getTitle()->getPreviousRevisionID( $row->rev_id );
			if ( $prevId ) {
				$prev = Revision::newFromTitle( $rev->getTitle(), $prevId );
				$otext = strval( $prev->getText());
			} else {
				$wgOut->addHtml(
				"<ul>" .
				$info .
				"</ul>\n" .
				$list );
				$wgOut->addWikiText( wfMsgNoTrans( 'oversight-nodiff' ) );
				return;
			}
			$ntext = strval( $rev->getText());

			$diffEngine = new DifferenceEngine();
			$diffEngine->showDiffStyle();
			$wgOut->addHtml(
				"<ul>" .
				$info .
				"</ul>\n" .
				$list .
				"<p><strong>" .
				wfMsgHTML('oversight-difference') .
				"</strong>" .
				"</p>" .
				"<div>" .
				"<table border='0' width='98%' cellpadding='0' cellspacing='4' class='diff'>" .
				"<col class='diff-marker' />" .
				"<col class='diff-content' />" .
				"<col class='diff-marker' />" .
				"<col class='diff-content' />" .
				"<tr>" .
					"<td colspan='2' width='50%' align='center' class='diff-otitle'>" . wfMsgHTML('oversight-prev') . " (#$prevId)" . "</td>" .
					"<td colspan='2' width='50%' align='center' class='diff-ntitle'>" . wfMsgHTML('oversight-hidden') . "</td>" .
				"</tr>" .
				$diffEngine->generateDiffBody( $otext, $ntext ) .
				"</table>" .
				"</div>\n" );
		}
		$dbr->freeResult( $result );
	}
}
