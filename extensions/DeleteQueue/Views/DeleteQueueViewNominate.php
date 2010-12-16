<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die;
}

class DeleteQueueViewNominate extends DeleteQueueView {
	function show( $params ) {
		global $wgOut;

		// Just parse the details out.
		list( $action, $article_id, $queue ) = $params;

		$article = Article::newFromId( $article_id );
		$this->process( $article, $queue );
	}

	/**
	 * Entry point for "nomination" forms.
	 * @param $article The article object to nominate.
	 * @param $queue The queue to nominate to.
	 */
	public function process( $article, $queue ) {
		global $wgOut, $wgScript, $wgUser, $wgRequest;

		// Check permissions
		$editErrors =
			$article->mTitle->getUserPermissionsErrors( 'edit', $wgUser );
		$nomErrors =
			$article->mTitle->getUserPermissionsErrors( "{$queue}-nominate", $wgUser );

		if ( count( array_merge( $editErrors, $nomErrors ) ) ) {
			// Permissions errors.
			if ( count( $editErrors ) ) {
				$editError = $wgOut->formatPermissionsErrorMessage( $editErrors, 'edit' );
				$nomErrors[] = array( 'deletequeue-permissions-noedit', $editError );
			}

			$wgOut->showPermissionsErrorPage( $nomErrors, "{$queue}-nominate" );
			if ( isset( $editError ) ) {
				$wgOut->addHTML( $editError );
			}
			return;
		}

		$form = $this->buildForm( $article, $queue );

		if ( $form ) {
			$wgOut->addHTML( $form );
		}
	}

	/**
	 * Generate a "deletion nomination" form.
	 * @param $article Article object to nominate.
	 */
	public function buildForm( $article, $queue ) {
		global $wgOut, $wgScript, $wgUser, $wgRequest;

		// Check for submission
		if ( $this->trySubmit( $article, $queue ) ) {
			return;
		}

		$wgOut->setPageTitle( wfMsg( "deletequeue-$queue-title",
			$article->mTitle->getPrefixedText() ) );
		$wgOut->addWikiMsg( "deletequeue-$queue-text",
			$article->mTitle->getPrefixedText() );

		// Build deletion form.
		$fields = array();
		$fields['deletequeue-delnom-reason'] =
			Xml::listDropDown(
				'wpReason',
				DeleteQueueInterface::getReasonList( $queue ),
				wfMsg( "deletequeue-delnom-otherreason" )
			);

		$fields['deletequeue-delnom-extra'] = Xml::input( 'wpExtra', 45 );

		$article_id = $article->getId();
		$title = $this->getTitle( "nominate/$article_id/$queue" );

		$form = Xml::buildForm( $fields, "deletequeue-delnom-submit" );
		$form .= Xml::hidden( 'title', $title->getPrefixedText() );
		$form .= Xml::hidden( 'queue', $queue );
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		$form = Xml::tags(
			'form',
			array(
				'action' => $title->getLocalUrl(),
				'method' => 'POST'
			),
			$form
		);

		$wgOut->addHTML( $form );
	}

	/**
	 * Attempt to submit the propose deletion form.
	 * @param $article Article object.
	 * @param $action The action (speedynom, prod, etc)
	 * @return Boolean Whether or not the submission was successful.
	*/
	public function trySubmit( $article, $queue ) {
		global $wgUser, $wgOut, $wgRequest;

		$token = $wgRequest->getText( 'wpEditToken' );

		if ( !$wgUser->matchEditToken( $token ) ) {
			return false;
		}

		// Import form data.
		$reason1 = $wgRequest->getText( 'wpReason' );
		$reason2 = $wgRequest->getText( 'wpExtra' );

		$reason = DeleteQueueInterface::formatReason( $reason1, $reason2 );

		// Allow hooks to terminate
		$error = '';
		if ( !wfRunHooks( 'AbortDeleteQueueNominate', array( $wgUser, $article, $queue, $reason, &$error ) ) ) {
			$wgOut->addWikitext( $error );
			return false;
		}

		// Transaction
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		// Set in database.
		$dqi = DeleteQueueItem::newFromArticle( $article );

		if ( $dqi->getQueue() ) {
			$dbw->rollback();
			$wgOut->addWikiMsg( 'deletequeue-nom-alreadyqueued' );
			return false;
		}

		$dqi->setQueue( $queue, $reason );
		$dqi->addRole( 'nominator' );

		$log = new LogPage( 'delete' );
		$log->addEntry( "nominate", $article->mTitle, $reason, wfMsgNoTrans( 'deletequeue-queue-' . $queue ) );

		$dbw->commit();

		$wgOut->redirect( $article->mTitle->getLocalUrl() );

		return true;
	}
}
