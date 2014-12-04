<?php
/**
 * Controller class for QuickTools actions
 *
 * @author grunny
 */
class QuickToolsController extends WikiaController  {

	/**
	 * Method to generate QuickTools modal
	 */
	public function quickToolsModal() {
		$this->setVal( 'username', $this->request->getVal( 'username' ) );
		$this->setVal( 'blocklength', '3 days' );
		if ( in_array( 'bot', $this->wg->User->getGroups() ) ) {
			$this->setVal( 'botflag', 'remove' );
		} else {
			$this->setVal( 'botflag', 'add' );
		}
	}

	/**
	 * Block the target user account
	 */
	public function blockUser() {
		wfProfileIn( __METHOD__ );
		if ( !$this->wg->User->isAllowed( 'quicktools' ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( 'quicktools-permissionerror' )->plain() );
			wfProfileOut( __METHOD__ );
			return true;
		}
		$target = $this->request->getVal( 'target' );
		$blockLength = $this->request->getVal( 'length' );
		$summary = $this->request->getVal( 'summary' );

		$data = array(
			'Target' => $target,
			'Reason' => array(
				is_null( $summary ) ? '' : $summary,
				'other',
				is_null( $summary ) ? '' : $summary
			),
			'Expiry' => $blockLength,
			'HardBlock' => true,
			'CreateAccount' => true,
			'AutoBlock' => true,
			'DisableEmail' => true,
			'DisableUTEdit' => false,
			'AlreadyBlocked' => true,
			'Watch' => false,
			'Confirm' => true,
		);

		$retval = SpecialBlock::processForm( $data, $this->getContext() );
		if ( $retval !== true ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( $retval )->escaped() );
			wfProfileOut( __METHOD__ );
			return true;
		}
		$this->response->setVal( 'success', true );
		$this->response->setVal( 'message', wfMessage( 'quicktools-success-block', $target )->escaped() );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Revert and/or delete all the target user's edits on a wiki
	 */
	public function revertAll() {
		wfProfileIn( __METHOD__ );
		if ( !$this->wg->User->isAllowed( 'quicktools' ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( 'quicktools-permissionerror' )->plain() );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$target = $this->request->getVal( 'target' );
		$time = $this->request->getVal( 'time' );
		$summary = $this->request->getVal( 'summary' );
		$rollback = $this->request->getBool( 'dorollback' );
		$delete = $this->request->getBool( 'dodeletes' );
		$markBot = $this->request->getBool( 'markbot' );

		if ( !$time ) {
			$time = '';
		} else {
			$time = wfTimestamp( TS_UNIX, $time );
			if ( !$time ) {
				$this->response->setVal( 'success', false );
				$this->response->setVal( 'error', wfMessage( 'quicktools-invalidtime' )->plain() );
				wfProfileOut( __METHOD__ );
				return true;
			}

			$time = wfTimestamp( TS_MW, $time );
		}

		$titles = $this->getRollbackTitles( $target, $time );

		if( empty( $titles ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( 'quicktools-notitles' )->plain() );
			wfProfileOut( __METHOD__ );
			return true;
		}

		foreach ( $titles as $title ) {
			$status = $this->rollbackTitle( $title, $target, $time, $summary, $rollback, $delete, $markBot );
		}
		$this->response->setVal( 'success', true );
		$successMessage = 'quicktools-success' . ( $rollback ? '-rollback' : '' ) . ( $delete ? '-delete' : '' );
		$this->response->setVal( 'message', wfMessage( $successMessage, $target )->escaped() );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Get all pages that should be rolled back for a given user
	 *
	 * @param $user String a name to check against rev_user_text
	 * @param $time String Timestamp to revert since
	 * @return Array of page titles to revert
	 */
	private function getRollbackTitles( $user, $time ) {
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_SLAVE );
		$titles = array();
		$where = array(
			'page_latest = rev_id',
			'rev_user_text' => $user,
		);
		if ( $time !== '' ) {
			$time = $dbr->addQuotes( $time );
			$where[] = "rev_timestamp >= {$time}";
		}
		$results = $dbr->select(
			array( 'page', 'revision' ),
			array( 'page_namespace', 'page_title' ),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'page_namespace, page_title',
				'LIMIT' => 500,
			)
		);
		while ( $row = $dbr->fetchObject( $results ) ) {
			$titles[] = Title::makeTitle( $row->page_namespace, $row->page_title );
		}

		wfProfileOut( __METHOD__ );
		return $titles;
	}

	/**
	 * Rollback edits and/or delete page creations by user
	 *
	 * @param $title String The page name to perform reverts on
	 * @param $user String Username of user to revert
	 * @param $time String Timestamp to revert edits since
	 * @param $summary String Edit summary to give for reverts and deleted
	 * @param $rollback Boolean Whether or not to perform rollbacks (default: true)
	 * @param $delete Boolean Whether or not to perform deletions (default: true)
	 * @param $markBot Boolean Whether or not to mark rollbacks as bot edits through
	 *        the bot=1 URL parameter (default: false)
	 * @return true on success, false on failure
	 */
	private function rollbackTitle(
		$title, $user, $time, $summary, $rollback = true, $delete = true, $markBot = false
	) {
		wfProfileIn( __METHOD__ );
		// build article object and find article id
		$article = new Article( $title );
		$pageId = $article->getID();

		// check if article exists
		if ( $pageId <= 0 ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		// fetch revisions from this article
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'revision',
			array( 'rev_id', 'rev_user_text', 'rev_timestamp' ),
			array(
				'rev_page' => $pageId,
			),
			__METHOD__,
			array(
				'ORDER BY' => 'rev_id DESC',
			)
		);

		// find the newest edit done by other user
		$revertRevId = false;
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->rev_user_text !== $user || ( $time !== '' && $row->rev_timestamp < $time ) ) {
				$revertRevId = $row->rev_id;
				break;
			}
		}
		$dbr->freeResult( $res );

		if ( $revertRevId && $rollback ) { // found an edit by other user - reverting
			$rev = Revision::newFromId( $revertRevId );
			$text = $rev->getRawText();
			$flags = EDIT_UPDATE|EDIT_MINOR;
			if ( $this->wg->User->isAllowed( 'bot' ) || $markBot ) {
				$flags |= EDIT_FORCE_BOT;
			}
			$status = $article->doEdit( $text, $summary, $flags );
			if ( $status->isOK() ) {
				wfProfileOut( __METHOD__ );
				return true;
			} else {
				wfProfileOut( __METHOD__ );
				return false;
			}
		} elseif ( !$revertRevId && $delete ) { // no edits by other users - deleting page
			$title = $article->getTitle();
			$file = $title->getNamespace() == NS_FILE ? wfLocalFile( $title ) : false;
			if ( $file ) {
				$oldimage = null; // Must be passed by reference
				$status = FileDeleteForm::doDelete( $title, $file, $oldimage, $summary, false )->isOK();
			} else {
				$status = $article->doDeleteArticle( $summary );
			}
			if ( $status ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		wfProfileOut( __METHOD__ );
		return false;
	}
}
