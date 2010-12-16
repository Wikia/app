<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die;
}

class DeleteQueueViewVote extends DeleteQueueView {
	function show( $params ) {
		$article_id = $params[1];
		$article = Article::newFromId( $article_id );
		$this->process( $article );
	}

	/**
	 * Process the 'delvote' action.
	 * @param Article $article The article to endorse/object to deletion of.
	 */
	public function process( $article ) {
		global $wgRequest, $wgOut, $wgUser;

		$errs =
			$article->mTitle->getUserPermissionsErrors( 'deletequeue-vote', $wgUser );
		if ( count( $errs ) > 0 ) {
			$wgOut->showPermissionsErrorPage( $errs );
			return;
		}

		$dqi = DeleteQueueItem::newFromArticle( $article );

		$wgOut->setPageTitle( wfMsg( 'deletequeue-vote-title', $article->mTitle->getPrefixedText() ) );

		// Load form data
		$token = $wgRequest->getVal( 'wpEditToken' );
		$action = $wgRequest->getVal( 'wpVote' );
		$comments = $wgRequest->getText( 'wpComments' );

		if ( $wgUser->matchEditToken( $token ) &&
			in_array( $action, array( 'endorse', 'object' ) ) ) {

			$dqi->addVote( $action, $comments );

			if ( $action == 'object' && $dqi->getQueue( ) == 'prod' ) {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->begin();

				$dqi->setQueue( 'deletediscuss', $dqi->getReason() );

				$lp = new LogPage( 'delete' );
				$lp->addEntry( 'requeue',
						$article->mTitle,
						$comments,
						array(
							wfMsgForContent( 'deletequeue-queue-prod' ),
							wfMsgForContent( "deletequeue-queue-deletediscuss" )
						)
					);

				$dbw->commit();

				$wgOut->addWikiMsg( 'deletequeue-vote-requeued',
					wfMsgNoTrans( 'deletequeue-queue-deletediscuss'  ) );
			} else {
				$wgOut->addWikiMsg( "deletequeue-vote-success-$action" );
			}
			return;
		}

		$wgOut->addWikiMsg( 'deletequeue-vote-text',
			$article->mTitle->getPrefixedText(), $dqi->getReason() );

		// Add main form.
		$fields = array();

		$options = Xml::tags( 'p', null,
			Xml::radioLabel(
				wfMsg( 'deletequeue-vote-endorse' ),
				'wpVote',
				'endorse',
				'mw-deletequeue-vote-endorse'
			)
		);

		$options .= Xml::tags( 'p', null,
			Xml::radioLabel(
				wfMsg( 'deletequeue-vote-object' ),
				'wpVote',
				'object',
				'mw-deletequeue-vote-object'
			)
		);

		$fields['deletequeue-vote-action'] = $options;
		$fields['deletequeue-vote-reason'] = Xml::input( 'wpComments', 45, $comments );

		$article_id = $article->getId();
		$title = $this->getTitle( "vote/$article_id" );

		$form = Xml::buildForm( $fields, 'deletequeue-vote-submit' ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::hidden( 'title', $title->getPrefixedText() );

		$form = Xml::tags( 'form',
			array(
				'action' => $title->getLocalURL(),
				'method' => 'POST'
			),
			$form
		);

		$form = Xml::fieldset( wfMsg( 'deletequeue-vote-legend' ), $form );

		$wgOut->addHTML( $form );
	}
}
