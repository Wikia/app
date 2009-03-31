<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class DeleteQueueReviewForm {

	function __construct( $article ) {
		$this->mArticle = $article;
	}

	/**
	 * Attempt submission of the "Review Speedy" form.
	 * @param $article Article object being reviewed
	 */
	public function submit( ) {
		global $wgUser,$wgOut,$wgRequest;

		$article = $this->mArticle;

		$token = $wgRequest->getText( 'wpEditToken' );

		if (!$wgUser->matchEditToken( $token )) {
			return false;
		}

		// Process the action
		$action = $wgRequest->getVal( 'wpSpeedyAction' );
		$processed = true;
		$dqi = DeleteQueueItem::newFromArticle( $article );

		$lp = new LogPage( 'delete' );
		$reason = $wgRequest->getText( 'wpReason' );

		// Check the action against the list
		list($enabledActions) = $this->availableActions();
		if (!in_array($action,$enabledActions)) {
			return wfMsg( 'deletequeue-review-actiondenied' );
		}

		$queue = $dqi->getQueue( );

		// Transaction
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		switch ($action) {
			case 'delete':
				$article->doDelete( $dqi->getQueue() );
				$processed = true;
				break;
			case 'change':
				list($reason1,$reason2) = array($wgRequest->getText( 'wpSpeedyNewReason' ), $wgRequest->getText( 'wpSpeedyNewExtra' ) );
				$reason = DeleteQueueInterface::formatReason( $reason1, $reason2 );
				$article->doDelete( $reason );
				$processed = true;
				break;
			case 'dequeue':
				$lp->addEntry( 'dequeue', $article->mTitle, $reason, $queue );
				$processed = true;
				break;
			case 'requeue':
				$newQueue = $wgRequest->getVal( 'wpSpeedyRequeue' );

				$lp->addEntry( 'requeue', $article->mTitle, $reason, array(wfMsgForContent("deletequeue-queue-$queue"), wfMsgForContent( "deletequeue-queue-{$newQueue}" )) );

				list($reason1,$reason2) = array($wgRequest->getText( 'wpSpeedyNewReason' ), $wgRequest->getText( 'wpSpeedyNewExtra' ) );
				$newReason = DeleteQueueInterface::formatReason( $reason1, $reason2 );

				$dqi->setQueue( $newQueue, $reason );
				$processed = false;
				break;
			default:
				// Invalid action
				$dbw->commit();
				return wfMsg( 'deletequeue-review-badaction' );;
		}

		if ($processed) {
			// Delete from the DB
			$dqi->deQueue( );
			
			// Redirect to the page
			$wgOut->redirect( $article->mTitle->getLocalURL() );

			// Commit transaction
			$dbw->commit();

			return true;
		}

		$dbw->commit();

		return true;
	}

	/**
	 * Process the "Review Speedy" action
	 * @param $article Article object being reviewed
	 */
	public function form( ) {
		global $wgOut,$wgScript,$wgUser,$wgRequest;

		$article = $this->mArticle;
		$dqi = DeleteQueueItem::newFromArticle( $article );
		$queue = $dqi->getQueue();

		if (!$queue) {
			// Idiot...
			$wgOut->addWikiMsg( 'deletequeue-notqueued' );
			return;
		}

		// Check permissions
		$editErrors = $article->mTitle->getUserPermissionsErrors( 'edit', $wgUser );
		$nomErrors = $article->mTitle->getUserPermissionsErrors( "$queue-review", $wgUser );

		if (count(array_merge($editErrors,$nomErrors))) {
			// Permissions errors.
			if (count($editErrors)) {
				$editError = $wgOut->formatPermissionsErrorMessage( $editErrors, 'edit' );
				$nomErrors[] = array( 'deletequeue-permissions-noedit', $editError );
			}

			$wgOut->showPermissionsErrorPage( $nomErrors, "$queue-review" );
			return;
		}

		list ($enabledActions, $disabledActions) = $this->availableActions();

		$haveRequeueOption = false;

		$shownActions = array_merge( array_keys( $disabledActions ), $enabledActions );

		foreach( $shownActions as $val ) {
			if (strpos($val,'requeue') == 0) {
				$haveRequeueOption = true;
			}
		}

		if (($error = $this->submit( $article )) === true) {
			return;
		}

		$wgOut->setPageTitle( wfMsg( "deletequeue-review$queue-title", $article->mTitle->getPrefixedText() ) );

		$discussionPage = ($queue == 'deletediscuss') ? $dqi->getDiscussionPage()->mTitle->getPrefixedText() : null;

		$wgOut->addWikiMsg( "deletequeue-review$queue-text", $article->mTitle->getPrefixedText(), $discussionPage );

		// Cautions if there's an objection
		if (count($dqi->mVotesObject)>0) {
			$wgOut->addWikiMsg( "deletequeue-review-objections", count($dqi->mVotesObject) );
		}

		if ($error) {
			$wgOut->addHTML( '<p>'.$error.'</p>' );
		}

		// Details of nomination
		$wgOut->addHTML( Xml::openElement( 'fieldset' ) . Xml::element( 'legend', array(), wfMsg( 'deletequeue-review-original' ) ) );
		$wgOut->addWikitext( $dqi->getReason() );
		$wgOut->addHTML( Xml::closeElement( 'fieldset' ) );

		$output = '';

		// Give the user options
		$option_selection = '';

		//// Action radio buttons
		// Accept the nomination as-is
		$accept = Xml::radioLabel( wfMsg( 'deletequeue-review-delete' ), 'wpSpeedyAction', 'delete', 'mw-review-accept' );
		$option_selection .= $this->getActionOrError( 'delete', $accept, null, Xml::tags( 'li', array(), '$1' ) );

		// Accept nomination, but with a different reasoning.
		$change_option = Xml::radioLabel( wfMsg( 'deletequeue-review-change' ), 'wpSpeedyAction', 'change', 'mw-review-change' );
		$change_fields = array();
		$change_fields['deletequeue-review-newreason'] = Xml::listDropDown( 'wpSpeedyNewReason', DeleteQueueInterface::getReasonList( $queue ), wfMsg('deletequeue-delnom-otherreason') );
		$change_fields['deletequeue-review-newextra'] = Xml::input( 'wpSpeedyNewExtra', 45, '' );
		$change_option .= Xml::buildForm( $change_fields );
		$option_selection .= $this->getActionOrError( 'delete', $change_option, wfMsgExt('deletequeue-review-change', array('parse') ), Xml::tags( 'li', array(), '$1' ) );

		// Reject nomination, queue into a different deletion queue.
		if ($haveRequeueOption) {
			$requeue_option = Xml::radioLabel( wfMsg( 'deletequeue-review-requeue' ), 'wpSpeedyAction', 'requeue', 'mw-review-requeue' );
			$new_queues = array('prod', 'deletediscuss');
			$requeue_queues = '';
			foreach( $new_queues as $option ) {
				$this_queue = Xml::radioLabel( wfMsg( "deletequeue-queue-$option" ), 'wpSpeedyRequeue', $option, "mw-review-requeue-$option" );
				$disabledMsg = wfMsgExt( "deletequeue-requeuedisabled", array( 'parseinline' ), array( wfMsgNoTrans( "deletequeue-queue-$option" ) ) );

				$requeue_queues .= $this->getActionOrError( "requeue-$option", $this_queue, $disabledMsg, Xml::tags( 'li', array(), '$1' ) );
			}
			$requeue_option .= Xml::tags( 'ul', array(), $requeue_queues );

			$requeue_fields = array();
			$requeue_fields['deletequeue-review-newreason'] = Xml::listDropDown( 'wpSpeedyNewReason', DeleteQueueInterface::getReasonList( 'generic' ), wfMsg("deletequeue-delnom-otherreason") );
			$requeue_fields['deletequeue-review-newextra'] = Xml::input( 'wpSpeedyNewExtra', 45, '' );
			$requeue_option .= Xml::buildForm( $requeue_fields );

			$option_selection .= Xml::tags( 'li', array(), $requeue_option );
		}

		// Reject nomination outright.
		$dq = Xml::radioLabel( wfMsg( 'deletequeue-review-dequeue' ), 'wpSpeedyAction', 'dequeue', 'mw-review-dequeue' );
		$option_selection .= $this->getActionOrError( 'dequeue', $dq, null, Xml::tags( 'li', array(), '$1' ) );

		//// Convert to a list.
		$option_selection = Xml::tags( 'ul', array(), $option_selection );

		$option_selection = Xml::fieldset( wfMsg( 'deletequeue-review-action' ), $option_selection );

		$output .= $option_selection;

		// Reason etc.
		$fields = array( 'deletequeue-review-reason' => Xml::input( 'wpReason', 45, null ) );

		$output .= Xml::buildForm( $fields, 'deletequeue-review-submit' );

		// Form stuff
		$output .= Xml::hidden( 'title', $article->mTitle->getPrefixedText() );
		$output .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		$output .= Xml::hidden( 'action', 'delreview' );
		$output = Xml::tags( 'form', array( 'action' => $article->mTitle->getLocalURL(), 'method' => 'POST' ), $output );

		$wgOut->addHTML( $output );

		$article->showLogExtract( $wgOut );
	}

	/** Returns the action given in enabledText, a 'disabled' message, or nothing, depending on the status of the action. */
	public function getActionOrError($action, $enabledText, $disabledMsg = null, $wrapper = null) {
		list ($enabled,$disabled) = $this->availableActions();

		if (!$disabledMsg) {
			$disabledMsg = wfMsgExt("deletequeue-review-$action", array('parse'));
		}

		$data = '';

		if (in_array($action,$enabled)) {
			$data = $enabledText;
		} elseif ( in_array( $action, array_keys( $disabled ) ) ) {
			$msg = $disabled[$action];
			$msg .= "\n";
			$msg .= $disabledMsg;
			$data = $msg;
		} else {
		}

		if ($wrapper && $data) {
			$data = wfMsgReplaceArgs( $wrapper, array($data) );
		}

		return $data;
	}

	/**
	 * Determines which queues can be sent to in review.
	 * @return Array First element is a simple list of ENABLED queues,
	 	second is a list, key is queue name, value is a message explaining why
	 	(already passed through wfMsg). Queues in neither are not displayed.
	 */
	public function availableActions( $user = null ) {
		$article = $this->mArticle;
		$dqi = DeleteQueueItem::newFromArticle( $article );
		$queue = $dqi->getQueue( );

		if ($user === null) {
			global $wgUser;
			$user = $wgUser;
		}

		$enabled = array();
		$disabled = array();

		$userRoles = $dqi->getUserRoles( $user );
		$descriptiveRoles = array_map( array( 'DeleteQueueItem', 'getRoleDescription' ), $userRoles );
		$descriptiveRolesText = implode( ", ", $descriptiveRoles );

		$enabled[] = 'endorse';
		$enabled[] = 'object';

		// Speedy deletion
		if ($queue == 'speedy') {
			// All are unlocked if user is authed.
			$enabled = array( 'delete', 'requeue-prod', 'requeue-deletediscuss', 'dequeue' );
		} elseif ($queue == 'prod') {
			// Escalation by anybody
			$enabled[] = 'requeue-deletediscuss';
			$enabled[] = 'dequeue';

			$expiry = $dqi->getExpiry();
			$hasExpired = (time() > $expiry) ? true : false;

			// Handling of 'delete'
			if (!$hasExpired) { // Hasn't expired yet, don't let them delete it.
				$disabled['delete'] = wfMsgExt( 'deletequeue-actiondisabled-notexpired', array( 'parseinline' ) );
			} elseif (count($userRoles)) {
				// Tell them they're involved.
				$disabled['delete'] = wfMsgExt( 'deletequeue-actiondisabled-involved', array( 'parseinline' ), array( $descriptiveRolesText ) );
			} else {
				// An uninvolved admin wants to delete an expired proposed deletion. Kill it.
				$enabled[] = 'delete';
			}
		} elseif ($queue == 'deletediscuss') {

			$expiry = $dqi->getExpiry();
			$hasExpired = (time() > $expiry) ? true : false;

			if (!$hasExpired) { // Hasn't expired yet, don't let them delete it.
				$disabled['delete'] = wfMsgExt( 'deletequeue-actiondisabled-notexpired', array( 'parseinline' ) );
			} elseif (count($userRoles)) {
				// Tell them they're involved.
				$disabled['delete'] = wfMsgExt( 'deletequeue-actiondisabled-involved', array( 'parseinline' ), array( $descriptiveRolesText ) );
			} else {
				// An uninvolved admin wants to delete an expired proposed deletion. Kill it.
				$enabled[] = 'delete';
			}

			$enabled[] = 'dequeue';
		}

		return array( $enabled, $disabled );
	}
}
