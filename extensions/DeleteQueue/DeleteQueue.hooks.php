<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class DeleteQueueHooks {
	public static function onSkinTemplateTabs( $st, &$actions ) {
		global $wgRequest, $wgUser;

		if ( !$st->mTitle ) {
			global $wgTitle;
			$st->mTitle = $wgTitle;
		}

		if ( !$st->mTitle->exists() ) {
			return true;
		}

		// Get status
		$dqi = DeleteQueueItem::newFromArticle( $st->mTitle->getArticleId() );
		$queue = $dqi->getQueue();

		$action = $wgRequest->getText( 'action' );

		$selected = false;

		wfLoadExtensionMessages( 'DeleteQueue' );

		if ( $queue == '' ) {
			$actions['deletequeue'] = array(
				'text' => wfMsg( 'deletequeue-action' ),
 				'href' => $st->mTitle->getLocalUrl( 'action=deletequeue' )
 			);
		} else {
			$actions['deletequeue'] = array(
				'text' => wfMsg( 'deletequeue-action-queued' ),
				'href' => SpecialPage::getTitleFor(
							'DeleteQueue',
							"case/" . $dqi->getCaseID() )->getLocalURL()
				);
		}

		return true;
	}

	public static function onUnknownAction( $action, $article ) {
		if ( $action == 'deletequeue' ) {
			wfLoadExtensionMessages( 'DeleteQueue' );
			global $wgOut;

			$wgOut->setPageTitle( wfMsg( 'deletequeue-action-title',
										$article->mTitle->getPrefixedText() ) );
			
			$dqi = DeleteQueueItem::newFromArticle( $article );
			
			if ( $dqi->getQueue() == '' )
				$wgOut->addWikiMsg( 'deletequeue-action-text' );
			else {
				self::onArticleViewHeader( $article );
				$wgOut->addWikiMsg( 'deletequeue-action-text-queued' );
			}
			return false;
		}

		return true;
	}

	public static function onArticleViewHeader( &$article ) {
		wfLoadExtensionMessages( 'DeleteQueue' );

		global $wgOut, $wgLang;

		if ( $article->mTitle->getNamespace() == NS_DELETION ) {
			$dqi = DeleteQueueItem::newFromDiscussion( $article );

			if ( !$dqi->isQueued() ) {
				break;
			}

			$wgOut->addWikiMsg( 'deletequeue-deletediscuss-discussionpage', $dqi->getArticle()->mTitle->getPrefixedText(), count( $dqi->getEndorsements() ), count( $dqi->getObjections() ) );
		}

		$dqi = DeleteQueueItem::newFromArticle( $article );

		if ( !( $queue = $dqi->getQueue() ) ) {
			return true;
		}

		$options = array( "deletequeue-page-$queue" );
		$options[] = $dqi->getReason();
		$expiry = wfTimestamp( TS_UNIX, $dqi->getExpiry() );
		$options[] = $wgLang->timeanddate( $expiry );
		$options[] = $wgLang->date( $expiry );
		$options[] = $wgLang->time( $expiry );
		if ( $queue == 'deletediscuss' ) {
			$options[] = $dqi->getDiscussionPage()->mTitle->getPrefixedText();
		}
		call_user_func_array( array( $wgOut, 'addWikiMsg' ), $options );

		return true;
	}
}
