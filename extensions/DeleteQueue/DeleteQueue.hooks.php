<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class DeleteQueueHooks {
	public static function onSkinTemplateTabs( $st, &$actions ) {
		global $wgTitle,$wgRequest,$wgUser;

		if (!$st->mTitle) {
			global $wgTitle;
			$st->mTitle = $wgTitle;
		}

		if (!$st->mTitle->exists()) {
			return true;
		}

		// Get status
		$dqi = DeleteQueueItem::newFromArticle( $st->mTitle->getArticleId() );
		$queue = $dqi->getQueue();

		$action = $wgRequest->getText('action');

		$selected = false;

		if (in_array( $action, array( 'delnom', 'delreview' ) ) ) {
			$selected = true;
		}

		wfLoadExtensionMessages( 'DeleteQueue' );

		if ($queue == '') {
			$actions['deletequeue'] = array(
				'text' => wfMsg('deletequeue-action'),
 				'href' => $st->mTitle->getLocalUrl( 'action=deletequeue' ),
 				'class' => $selected ? 'selected' : false,
			);
		} else {
			if ( $wgUser->isAllowed( "$queue-review" ) ) {
				$actions['delreview'] = array(
					'text' => wfMsg("deletequeue-review$queue-tab"),
					'href' => $st->mTitle->getLocalUrl( 'action=delreview' ),
					'class' => $selected ? 'selected' : false );
			}

			$actions['deletequeue'] = array(
				'text' => wfMsg('deletequeue-action-queued'),
				'href' => $st->mTitle->getLocalUrl( 'action=deletequeue' ),
				'class' => ($action == 'delvote') ? 'selected' : false );
		}

		return true;
	}

	public static function onUnknownAction( $action, $article ) {
		if ( $action == 'delnom' ) {
			wfLoadExtensionMessages( 'DeleteQueue' );
			global $wgRequest;
			$queue = $wgRequest->getVal( 'queue' );
			DeleteQueueInterface::processNominationAction( $article, $queue );

			return false;
		} elseif ( $action == 'deletequeue' ) {
			wfLoadExtensionMessages( 'DeleteQueue' );
			global $wgOut;

			$wgOut->setPageTitle( wfMsg( 'deletequeue-action-title', $article->mTitle->getPrefixedText() ) );
			
			$dqi = DeleteQueueItem::newFromArticle( $article );
			
			if ( $dqi->getQueue() == '' )
				$wgOut->addWikiMsg('deletequeue-action-text' );
			else {
				self::onArticleViewHeader( $article );
				$wgOut->addWikiMsg( 'deletequeue-action-text-queued' );
			}
			return false;
		} elseif ( $action == 'delreview' ) {
			wfLoadExtensionMessages( 'DeleteQueue' );

			$rf = new DeleteQueueReviewForm($article);
			$rf->form();

			return false;
		} elseif ($action == 'delvote') {
			wfLoadExtensionMessages( 'DeleteQueue' );

			DeleteQueueInterface::processVoteAction( $article );
			return false;
		} elseif ($action == 'delviewvotes') {
			wfLoadExtensionMessages( 'DeleteQueue' );

			DeleteQueueInterface::showVotes( $article );

			return false;
		}

		return true;
	}

	public static function onArticleViewHeader( &$article ) {
		wfLoadExtensionMessages( 'DeleteQueue' );

		global $wgOut,$wgLang;

		if ( $article->mTitle->getNamespace() == NS_DELETION ) {
			$dqi = DeleteQueueItem::newFromDiscussion( $article );

			if (!$dqi->isQueued()) {
				break;
			}

			$wgOut->addWikiMsg( 'deletequeue-deletediscuss-discussionpage', $dqi->getArticle()->mTitle->getPrefixedText(), count($dqi->getEndorsements()), count($dqi->getObjections()) );
		}

		$dqi = DeleteQueueItem::newFromArticle( $article );

		if ( !( $queue = $dqi->getQueue() ) ) {
			return true;
		}

		$options = array("deletequeue-page-$queue");
		$options[] = $dqi->getReason();
		$expiry = wfTimestamp( TS_UNIX, $dqi->getExpiry() );
		$options[] = $wgLang->timeanddate( $expiry );
		if ($queue == 'deletediscuss') {
			$options[] = $dqi->getDiscussionPage()->mTitle->getPrefixedText();
		}
		call_user_func_array( array( $wgOut, 'addWikiMsg' ), $options );

		return true;
	}
}
