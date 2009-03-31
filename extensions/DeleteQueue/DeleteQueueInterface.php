<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class DeleteQueueInterface {

	/**
	 * Entry point for "nomination" forms.
	 * @param $article The article object to nominate.
	 * @param $queue The queue to nominate to.
	 */
	public static function processNominationAction( $article, $queue ) {
		global $wgOut,$wgScript,$wgUser,$wgRequest;

		// Check permissions
		$editErrors = $article->mTitle->getUserPermissionsErrors( 'edit', $wgUser );
		$nomErrors = $article->mTitle->getUserPermissionsErrors( "{$queue}-nominate", $wgUser );

		if (count(array_merge($editErrors,$nomErrors))) {
			// Permissions errors.
			if (count($editErrors)) {
				// This is a really bad way to do this.
				$editError = $wgOut->formatPermissionsErrorMessage( $editErrors, 'edit' );
				$nomErrors[] = array( 'deletequeue-permissions-noedit', $editError );
			}

			$wgOut->showPermissionsErrorPage( $nomErrors, "{$queue}-nominate" );
			if (isset($editError)) {
				$wgOut->addHTML( $editError );
			}
			return;
		}

		$form = self::nominationForm( $article, $queue );

		if ($form) {
			$wgOut->addHTML( $form );
			$article->showLogExtract( $wgOut );
		}
	}

	/**
	 * Generate a "deletion nomination" form.
	 * @param $article Article object to nominate.
	 */
	public static function nominationForm( $article, $queue ) {
		global $wgOut,$wgScript,$wgUser,$wgRequest;

		// Check for submission
		if ( self::nominationSubmit( $article, $queue ) ) {
			return;
		}

		$wgOut->setPageTitle( wfMsg( "deletequeue-$queue-title", $article->mTitle->getPrefixedText() ) );
		$wgOut->addWikiMsg( "deletequeue-$queue-text", $article->mTitle->getPrefixedText() );

		// Build deletion form.
		$fields = array();
		$fields['deletequeue-delnom-reason'] = Xml::listDropDown( 'wpReason', self::getReasonList( $queue ), wfMsg("deletequeue-delnom-otherreason") );
		$fields['deletequeue-delnom-extra'] = Xml::input( 'wpExtra', 45 );

		$form = Xml::buildForm( $fields, "deletequeue-delnom-submit" );
		$form .= Xml::hidden( 'title', $article->mTitle->getPrefixedText() );
		$form .= Xml::hidden( 'action', "delnom" );
		$form .= Xml::hidden( 'queue', $queue );
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		$form = Xml::tags( 'form', array( 'action' => $article->mTitle->getLocalUrl(), 'method' => 'POST' ), $form );

		$wgOut->addHTML( $form );
		$article->showLogExtract( $wgOut );
	}

	/**
	 * Attempt to submit the propose deletion form.
	 * @param $article Article object.
	 * @param $action The action (speedynom, prod, etc)
	 * @return Boolean Whether or not the submission was successful.
	*/
	public static function nominationSubmit( $article, $queue ) {
		global $wgUser,$wgOut,$wgRequest;

		$token = $wgRequest->getText( 'wpEditToken' );

		if (!$wgUser->matchEditToken( $token )) {
			return false;
		}

		// Import form data.
		$reason1 = $wgRequest->getText( 'wpReason' );
		$reason2 = $wgRequest->getText( 'wpExtra' );

		$reason = self::formatReason( $reason1, $reason2 );
		
		// Allow hooks to terminate
		$error = '';
		if (!wfRunHooks( 'AbortDeleteQueueNominate', array($wgUser, $article, $queue, $reason, &$error) ) ) {
			$wgOut->addWikitext( $error );
			return false;
		}

		// Transaction
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		
		// Set in database.
		$dqi = DeleteQueueItem::newFromArticle( $article );
		
		if ($dqi->getQueue()) {
			$dbw->rollback();
			$wgOut->addWikiMsg( 'deletequeue-nom-alreadyqueued' );
			return false;
		}
		
		$dqi->setQueue( $queue, $reason );
		$dqi->addRole( 'nominator' );

		$log = new LogPage( 'delete' );
		$log->addEntry( "nominate", $article->mTitle, $reason, wfMsgNoTrans( 'deletequeue-queue-'.$queue) );

		$dbw->commit();

		$wgOut->redirect( $article->mTitle->getLocalUrl() );

		return true;
	}

	public static function formatReason( $reason1, $reason2 ) {
		if ($reason1 && $reason2 && $reason1 != 'other') {
			return "$reason1: $reason2";
		} elseif ($reason2) {
			return $reason2;
		} elseif ($reason1) {
			return $reason1;
		} else {
			return false;
		}
	}

	/**
	 * Get a list of reasons for deletion nomination.
	 * @param $queue The queue to nominate to.
	 * @return A string formatted for Xml::listDropDown.
	 */
	public static function getReasonList( $queue ) {
		$list = wfMsgForContent( "deletequeue-$queue-reasons" );

		// Does a specific list exist?
		if ($list && $list != '-') {
			return $list;
		}

		// Use the generic list
		$list = wfMsgForContent( "deletequeue-generic-reasons" );
		return $list;
	}

	/**
	 * Process the 'delvote' action.
	 * @param Article $article The article to endorse/object to deletion of.
	 */
	public static function processVoteAction( $article ) {
		global $wgRequest,$wgOut,$wgUser,$wgTitle;

		if ( count( $errs = $article->mTitle->getUserPermissionsErrors( 'deletequeue-vote', $wgUser ) ) > 0 ) {
			$wgOut->showPermissionsErrorPage( $errs );
			return;
		}

		$dqi = DeleteQueueItem::newFromArticle( $article );

		$wgOut->setPageTitle( wfMsg( 'deletequeue-vote-title', $article->mTitle->getPrefixedText() ) );

		// Load form data
		$token = $wgRequest->getVal( 'wpEditToken' );
		$action = $wgRequest->getVal( 'wpVote' );
		$comments = $wgRequest->getText( 'wpComments' );

		if ( $wgUser->matchEditToken( $token ) && in_array( $action, array( 'endorse', 'object' ) ) ) {
			$dqi->addVote( $action, $comments );

			if ($action == 'object' && $dqi->getQueue( ) == 'prod') {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->begin();

				$dqi->setQueue( 'deletediscuss', $dqi->getReason() );

				$lp = new LogPage( 'delete' );
				$lp->addEntry( 'requeue', $article->mTitle, $comments, array(wfMsgForContent('deletequeue-queue-prod'), wfMsgForContent( "deletequeue-queue-deletediscuss" )) );

				$dbw->commit();

				$wgOut->addWikiMsg( 'deletequeue-vote-requeued', wfMsgNoTrans( 'deletequeue-queue-deletediscuss'  ) );
			} else {
				$wgOut->addWikiMsg( "deletequeue-vote-success-$action" );
			}
			return;
		}

		$wgOut->addWikiMsg( 'deletequeue-vote-text', $article->mTitle->getPrefixedText(), $dqi->getReason() );

		// Add main form.
		$fields = array();

		$options = Xml::tags( 'p', null, Xml::radioLabel( wfMsg( 'deletequeue-vote-endorse' ), 'wpVote', 'endorse', 'mw-deletequeue-vote-endorse' ) );
		$options .= Xml::tags( 'p', null, Xml::radioLabel( wfMsg( 'deletequeue-vote-object' ), 'wpVote', 'object', 'mw-deletequeue-vote-object' ) );
		$fields['deletequeue-vote-action'] = $options;

		$fields['deletequeue-vote-reason'] = Xml::input( 'wpComments', 45, $comments );

		$form = Xml::buildForm( $fields, 'deletequeue-vote-submit' ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::hidden( 'title', $article->mTitle->getPrefixedText() ) .
			Xml::hidden( 'action', 'delvote' );

		$form = Xml::tags( 'form', array( 'action' => $article->mTitle->getFullURL('action=delvote'), 'method' => 'POST' ), $form );
		$form = Xml::fieldset( wfMsg( 'deletequeue-vote-legend' ), $form );

		$wgOut->addHTML( $form );
	}

	/**
	 * Show current votes.
	 * @param $article Article object to show votes for.
	 */
	public static function showVotes( $article ) {
		global $wgOut,$wgUser,$wgRequest,$wgLang;

		$sk = $wgUser->getSkin();
		$article_name = $article->mTitle->getPrefixedText();

		$wgOut->addWikiMsg( 'deletequeue-showvotes-text', $article_name );
		$wgOut->setPageTitle( wfMsg('deletequeue-showvotes', $article_name) );

		$restrict_type = $wgRequest->getText( 'votetype' );

		if ($restrict_type == 'none') $restrict_type = '';

		if ($restrict_type) {
			$wgOut->setSubTitle( wfMsg( "deletequeue-showvotes-showingonly-$restrict_type" ) );
		}

		// Add "view only X" links
		$restrictableActions = array( 'none', 'endorse', 'object' );
		$restrictions = Xml::openElement( 'ul' );
		foreach( $restrictableActions as $raction ) {
			$text = wfMsgExt( "deletequeue-showvotes-restrict-$raction", array( 'parseinline' ) );
			$link = $sk->makeKnownLinkObj( $article->mTitle, $text, "action=delviewvotes&votetype=$raction" );
			$restrictions .= "\n<li>$link</li>";
		}
		$restrictions .= Xml::closeElement( 'ul' );

		$wgOut->addHTML( $restrictions );

		// Sort votes by user.
		$dqi = DeleteQueueItem::newFromArticle( $article );
		$votes = $dqi->getVotes();

		$votesByUser = array();

		foreach( $votes as $vote ) {
			$user = $vote['user'];

			if ($restrict_type && $restrict_type != $vote['type'])
				continue;

			if ( !isset( $votesByUser[$user] ) ) {
				$votesByUser[$user] = array();
			}

			$votesByUser[$user][] = $vote;
		}

		// Link batch.
		$lb = new LinkBatch();
		foreach( array_keys($votes) as $user ) {
			$lb->add( NS_USER, $user );
			$lb->add( NS_USER_TALK, $user );
		}

		$voteDisplay = array();

		if ( count($votesByUser) == 0 ) {
			$suffix = $restrict_type ? "-$restrict_type" : '';
			$wgOut->addWikiMsg( "deletequeue-showvotes-none$suffix" );
		}

		// Display
		foreach( $votesByUser as $user => $votes ) {
			$id = User::idFromName($user);
			$user = $sk->userLink( $id, $user ) . '&nbsp;' .
				$sk->userToolLinks( $id, $user );

			$userVotes = array();

			foreach( $votes as $vote ) {
				$type = $vote['type'];
				$comment = $sk->commentBlock( $vote['comment'] );
				$timestamp = $wgLang->timeanddate( $vote['timestamp'] );
				$thisvote = wfMsgExt( "deletequeue-showvotes-vote-$type", array( 'parseinline', 'replaceafter' ), $timestamp, $comment );

				if ($vote['current'] == 0)
					$thisvote = Xml::tags( 's', null, $thisvote );

				$userVotes[] = Xml::tags( 'li', array( 'class' => "mw-deletequeue-vote-$type" ), $thisvote );
			}

			$uv = $user . Xml::tags( 'ul', null, implode( "\n", $userVotes ) );
			$voteDisplay[] = Xml::tags( 'li', null, $uv );
		}

		$wgOut->addHTML( Xml::tags( 'ol', null, implode( "\n", $voteDisplay ) ) );
	}
}
