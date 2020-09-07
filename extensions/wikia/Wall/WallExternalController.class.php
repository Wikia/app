<?php
use \Wikia\Interfaces\IRequest;

/**
 * A class which represents a user wall. A Wall is a replacement for the main part of the User_talk page.
 * A Wall consists of "Bricks" which are each a single topic/thread/conversation.
 * In typical use, a Wall will only load a subset of Bricks because there will be a TON of bricks as time goes on.
 */

class WallExternalController extends WikiaController {
	use \Wikia\Logger\Loggable;

	/**
	 * @var $helper WallHelper
	 */
	protected $helper;

	public function init() {
		global $wgIsValidWallTransaction;

		$this->helper = new WallHelper();

		// SUS-1554: Mark this transaction as a valid one for editing or creating Wall/Forum content
		$wgIsValidWallTransaction = true;
	}
	/*
	 *
	 * Use for external testing of mail template
	 *  http://www.communitycarenc.org/elements/media/images/under-construction.jpg ;)
	 */
	public function mail() {

	}

	/**
	 * Move thread (TODO: Should this be in Forums?)
	 */
	public function moveModal() {

		$id = $this->getVal( 'id' );
		$wm = WallMessage::newFromId( $id );

		if ( empty( $wm ) ) {
			return true;
		}

		/** @var $mainWall WallMessage */
		$mainWall = $wm->getWall();

		if ( !$this->wg->User->isAllowed( 'wallmessagemove' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		$forum = new Forum();

		$boardTitles = $forum->getBoardTitles();

		$this->destinationBoards = [
			[
				'value' => '',
				'content' => wfMessage( 'forum-board-destination-empty' )->escaped()
			]
		];

		foreach ( $boardTitles as $title ) {
			$value = $title->getArticleID();
			if ( $mainWall->getId() !== $value ) {
				$wall = Wall::newFromTitle( $title );
				$this->destinationBoards[$value] = [
					'value' => $value,
					'content' => htmlspecialchars( $wall->getTitle()->getText() )
				];
			}
		}
	}

	/**
	 * Moves thread
	 * @request destinationBoardId - id of destination board
	 * @request rootMessageId - thread id
	 */
	public function moveThread() {
		try {
			// SUS-664: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		// permission check needed here
		if ( !$this->wg->User->isAllowed( 'wallmessagemove' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		$this->status = 'error';

		$destinationId = $this->getVal( 'destinationBoardId', '' );
		$threadId = $this->getVal( 'rootMessageId', '' );

		if ( empty( $destinationId ) ) {
			$this->errormsg = wfMsg( 'wall-action-move-validation-select-wall' );
			return true;
		}

		$threadTitle = Title::newFromID( $threadId );

		// SUS-1777: Only allow moving Forum threads
		if ( empty( $threadTitle ) || $threadTitle->inNamespace( NS_USER_WALL_MESSAGE ) ) {
			$this->errormsg = 'unknown';
			return false;
		}

		$wall = Wall::newFromId( $destinationId );

		$thread = WallThread::newFromId( $threadId );
		$thread->move( $wall, $this->wg->User );

		$this->status = 'ok';
	}

	public function votersModal() {
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId( $this->request->getVal( 'id' ) );

		if ( !empty( $mw ) ) {
			$this->response->setVal(
				'list',
				$this->app->renderView(
					'WallExternalController',
					'votersListItems',
					[ 'from' => 0, 'mw' => $mw, 'id' => $this->request->getVal( 'id' ) ]
				)
			);

			$this->response->setVal( 'count', $mw->getVoteCount() );
		} else {
			$this->response->setCode( 404 );
			$this->skipRendering();
		}
	}

	public function votersListItems() {
		// TODO: implement load more button

		/**
		 * @var $mw WallMessage
		 */
		$mw = $this->request->getVal( 'mw' );
		if ( empty( $mw ) ) {
			$mw =  WallMessage::newFromId( $this->request->getVal( 'id' ) );
		}

		$from = (int) $this->request->getVal( 'from', 0 );

		$list = $mw->getVotersList( $from, 1000 );

		if ( count( $list ) == 26 ) {
			$this->response->setVal( 'hasmore', true );
		} else {
			$this->response->setVal( 'hasmore', false );
		}

		$out = [ ];
		for ( $i = 0; $i < min( count( $list ), 24 ); $i++ ) {
			$user = User::newFromId( $list[$i] );
			if ( !empty( $user ) ) {
				$out[] = [
					'profilepage' =>  $user->getUserPage()->getFullURL(),
					'name' => $user->getName(),
					'avatar' => AvatarService::getAvatarUrl( $user->getName(), 50 )
				];
			}
		}

		$this->response->setVal( 'hasmore', false );
		$this->response->setVal( 'last', $from );
		$this->response->setVal( 'list', $out );
	}

	public function switchWatch() {
		try {
			// SUS-664: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		$this->response->setVal( 'status', false );
		$isWatched = $this->request->getVal( 'isWatched' );
		/**
		 * @var $title Title
		 * @var $wallMessage WallMessage
		 */
		$title = Title::newFromID( $this->request->getVal( 'commentId' ) );

		if ( empty( $title ) ) {
			$this->response->setCode( 404 );
		} else {
			$wallMessage = WallMessage::newFromTitle( $title );

			if ( $this->wg->User->getId() > 0 && !$wallMessage->isWallOwner( $this->wg->User ) ) {
				if ( $isWatched ) {
					$wallMessage->removeWatch( $this->wg->User );
				} else {
					$wallMessage->addWatch( $this->wg->User );
				}

				$this->response->setVal( 'status', true );
			}
		}
	}

	/**
	 * Main entry point for starting a new Wall or Forum thread
	 * @requestParam string[] relatedTopics
	 * @requestParam string token MediaWiki edit token
	 * @requestParam string messagetitle Title of new thread
	 * @requestParam string body Message body
	 * @requestParam int pagenamespace 1200 for Message Wall, 2000 for Forum threads
	 * @requestParam string pagetitle title of parent page (Message Wall or Forum Board)
	 *
	 * @responseParam bool status
	 * @responseParam string message rendered message HTML
	 */
	public function postNewMessage() {
		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return;
		}

		$relatedTopics = $this->request->getVal( 'relatedTopics', [ ] );

		$this->response->setVal( 'status', true );

		/**
		 * BugId:68629 XSS vulnerable. We DO NOT want to have
		 * any HTML here. Hence the strip_tags call.
		 */
		$titleMeta = static::sanitizeMetaTitle( $this->request->getVal( 'messagetitle' ) );

		$body = $this->getConvertedContent( $this->request->getVal( 'body' ) );

		/** @var $helper WallHelper */
		$helper = new WallHelper();

		if ( empty( $titleMeta ) ) {
			$titleMeta = $helper->getDefaultTitle();
		}

		$ns = $this->request->getInt( 'pagenamespace' );

		// SUS-1387: Namespace parameter must be valid Wall or Forum namespace
		if ( empty( $body ) || !WallHelper::isWallNamespace( $ns ) ) {
			$this->response->setVal( 'status', false );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$title = Title::newFromText( $this->request->getVal( 'pagetitle' ), $ns );

		try {
			$wallMessage = ( new WallMessageBuilder() )
					->setMessageTitle( $titleMeta )
					->setMessageText( $body )
					->setMessageAuthor( $this->getContext()->getUser() )
					->setRelatedTopics( $relatedTopics )
					->setParentPageTitle( $title )
					->build();
		} catch ( WallBuilderException $builderException ) {
			\Wikia\Logger\WikiaLogger::instance()->error( $builderException->getMessage(), $builderException->getContext() );
			$this->response->setVal( 'status', false );
			$this->response->setVal( 'reason', 'other' );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
			return;
		} catch ( InappropriateContentException $exception) {
			$this->response->setVal( 'status', false );
			$this->response->setVal( 'reason', 'badcontent' );
			$this->response->setVal( 'blockInfo', wfMessage('spamprotectionmatch')->numParams( $exception->getContext()['block'] )->parse() );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$wallMessage->load( true );
		$this->response->setVal( 'message', $this->app->renderView( 'WallController', 'message', [ 'new' => true, 'comment' => $wallMessage ] ) );
	}

	public function deleteMessage() {
		try {
			// SUS-664: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		$mode = $this->request->getVal( 'mode' );
		$result = false;

		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId( $this->request->getVal( 'msgid' ) );
		if ( empty( $mw ) ) {
			$this->response->setVal( 'status', false );
			return true;
		}

		$formassoc = $this->processModalForm( $this->request );

		$reason = isset( $formassoc['reason'] ) ? $formassoc['reason'] : '';
		$notify = isset( $formassoc['notify-admin'] ) ? true : false;

		if ( empty( $reason ) && !$mode == 'rev' ) {
			$this->response->setVal( 'status', false );
			return true;
		}

		/**
		 * As documented in Wall.js:557
		 *
		 * work as delete (mode: rev),
		 * admin delete (mode:admin),
		 * remove (mode: remove),
		 * restore (mode: restore)
		 *
		 * Mode name is kept as data-mode attribute in HTML templates
		 */
		switch( $mode ) {
			case 'rev':
				// removes Wall's page table entry via ArticleComment::doDeleteComment)
				if ( $mw->canDelete( $this->wg->User ) ) {
					$result = $mw->delete( wfMessage( 'wall-delete-reason' )->inContentLanguage()->escaped(), true );

					// we just want to set status field in JSON response
					$this->response->setVal( 'status', $result );
					return true;
				} else {
					$this->response->setVal( 'error', wfMessage( 'wall-message-no-permission' )->escaped() );
				}
			break;

			case 'admin':
				// marks a comment with WPP_WALL_ADMINDELETE entry in page_wikia_props and deleted = 1 in comments_index table
				if ( $mw->canAdminDelete( $this->wg->User ) ) {
					$result = $mw->adminDelete( $this->wg->User, $reason, $notify );
				} else {
					$this->response->setVal( 'error', wfMessage( 'wall-message-no-permission' )->escaped() );
				}
			break;

			case 'fastadmin':
				// same as above, but does not require reason to be provided
				// marks a comment with WPP_WALL_ADMINDELETE entry in page_wikia_props
				if ( $mw->canFastAdminDelete( $this->wg->User ) ) {
					$result = $mw->adminDelete( $this->wg->User );
				} else {
					$this->response->setVal( 'error', wfMessage( 'wall-message-no-permission' )->escaped() );
				}
			break;

			case 'remove':
				// marks a comment with WPP_WALL_REMOVE entry in page_wikia_props and removed = 1 in comments_index table
				if ( !$mw->canModerate( $this->wg->User ) ) {
					$mw->load(); // must do this to allow checking for wall owner/message author - data not loaded otherwise
				}

				if ( $mw->canRemove( $this->wg->User ) ) {
					$result = $mw->remove( $this->wg->User, $reason, $notify );
				} else {
					$this->response->setVal( 'error', wfMessage( 'wall-message-no-permission' )->escaped() );
				}
			break;

			default:
				throw new BadRequestException( __METHOD__ . ' - unknown mode provided: ' . $mode );
		}

		$this->response->setVal( 'status', $result );

		if ( $result === true ) {
			$this->response->setVal('html', $this->app->renderView('WallController', 'messageRemoved', ['showundo' => true, 'comment' => $mw]));
			$mw->invalidateCache();
		}

		return true;
	}

	public function changeThreadStatus() {
		try {
			// SUS-664: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		$result = false;
		$newState = $this->request->getVal( 'newState', false );
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId( $this->request->getVal( 'msgid' ) );

		if ( empty( $mw ) || empty( $newState ) ) {
			$this->response->setVal( 'status', false );
			return true;
		}

		$formassoc = $this->processModalForm( $this->request );
		$reason = isset( $formassoc['reason'] ) ? $formassoc['reason'] : '';

		switch( $newState ) {
			case 'close':
				if ( $mw->canArchive( $this->wg->User ) ) {
					$result = $mw->archive( $this->wg->User, $reason );
					$mw->invalidateCache();
				}
				break;
			case 'open':
				if ( $mw->canReopen( $this->wg->User ) ) {
					$result = $mw->reopen( $this->wg->User );
					$mw->invalidateCache();
				}
				break;
			default:
				break;
		}

		$this->response->setVal( 'status', $result );
	}

	/**
	 * @param IRequest $request
	 * @return array
	 */
	protected function processModalForm( IRequest $request ) {
		/**
		 * @var $formdata array
		 */
		$formdata = $request->getVal( 'formdata' );

		$formassoc = [ ];
		if ( !empty( $formdata ) ) {
			foreach ( $formdata as $value ) {
				$formassoc[ $value['name'] ] = $value['value'];
			}
		}
		return $formassoc;
	}

	public function undoAction() {
		try {
			// SUS-4042: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		/**
		 * @var $mw WallMessage
		 */
		$mw = WallMessage::newFromId( $this->request->getVal( 'msgid' ) );
		if ( empty( $mw ) ) {
			$this->response->setVal( 'status', false );
			return true;
		}

		if ( !$mw->canModerate( $this->wg->User ) ) {
			$mw->load();
		}

		if ( $mw->isAdminDelete() && $mw->isRemove() && $mw->canRestore( $this->wg->User ) ) {
			$mw->undoAdminDelete( $this->wg->User );
			$this->response->setVal( 'status', true );
			return true;
		}

		if (
			( $mw->isRemove() && $mw->canRestore( $this->wg->User ) ) ||
			( $mw->isAdminDelete() || !$mw->isRemove() && $mw->canRestore( $this->wg->User ) )

		) {
			$mw->restore( $this->wg->User );
			$mw->invalidateCache();
			$this->response->setVal( 'status', true );
			return true;
		}
	}

	public function restoreMessage() {
		try {
			// SUS-4042: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId( $this->request->getVal( 'msgid' ) );
		if ( empty( $mw ) ) {
			$this->response->setVal( 'status', false );
			return true;
		}

		if ( !$mw->canModerate( $this->wg->User ) ) {
			$mw->load();
		}
		if ( $mw->canRestore( $this->wg->User ) ) {
			$formassoc = $this->processModalForm( $this->request );

			$reason = isset( $formassoc['reason'] ) ? $formassoc['reason'] : '';

			if ( empty( $reason ) && !$mw->canFastRestore( $this->wg->User ) ) {
				$this->response->setVal( 'status', false );
				return true;
			}

			$mw->restore( $this->wg->User, $reason );
			$mw->invalidateCache();

			$this->response->setVal( 'buttons', $this->app->renderView( 'WallController', 'messageButtons', [ 'comment' => $mw ] ) );
			$this->response->setVal( 'status', true );
		}
	}

	public function vote() {
		try {
			// SUS-4042: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		$id = $this->request->getVal( 'id' );
		$dir  = $this->request->getVal( 'dir' );

		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId( $id );

		if ( !empty( $mw ) ) {
			if ( $dir == 1 ) {
				$this->response->setVal( 'count', $mw->vote( $this->wg->User ) );
			}

			if ( $dir == -1 ) {
				$this->response->setVal( 'count', $mw->removeVote( $this->wg->User ) );
			}
		}

	}

	public function editMessage() {
		// TODO: remove call to ac !!!
		$msgid = $this->request->getVal( 'msgid' );
		/** @var $mw WallMessage */
		$mw =  WallMessage::newFromId( $msgid );

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return;
		}

		if ( empty( $mw ) ) {
			// most likely scenario - can't create AC, because message was already
			// deleted before we tried to edit it
			// client(javascript) should reload user's page

			$this->response->setVal( 'status', false );
			$this->response->setVal( 'forcereload', true );
			return;
		}

		$text = $mw->getRawText();

		// WallMessage getRawText returns wikitext
		// so convert it to richtext only if needed as
		// RTE::HtmlToWikitext will fail if wikitext is passed as content
		// (BugId: 32591)
		$convertToFormat = $this->request->getVal( 'convertToFormat', '' );
		if ( $convertToFormat == 'richtext' ) {
			$text = $this->getConvertedContent( $text );
		}

		$this->response->setVal( 'htmlorwikitext', $text );
		$this->response->setVal( 'status', true );
	}

	public function editMessageSave() {
		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return;
		}

		/** @var $helper WallHelper */
		$helper = new WallHelper();

		$msgid = $this->request->getVal( 'msgid' );

		// XSS vulnerable (MAIN-1412)
		$newtitle = static::sanitizeMetaTitle( $this->request->getVal( 'newtitle' ) );

		$newbody = $this->getConvertedContent( $this->request->getVal( 'newbody' ) );

		if ( empty( $newtitle ) ) {
			$newtitle = $helper->getDefaultTitle();
		}

		$title = Title::newFromID( $msgid );

		if ( empty( $title ) ) {
			$this->response->setVal( 'status', false ) ;
			$this->response->setVal( 'msgTitle', wfMessage( ' wall-delete-error-title' )->escaped() );
			$this->response->setVal( 'msgContent', wfMessage( 'wall-deleted-msg-text' )->escaped() );
			return;
		}
		/** @var $wallMessage WallMessage */
		$wallMessage = WallMessage::newFromTitle( $title );

		$wallMessage->load();

		$wallMessage->setMetaTitle( $newtitle );

		try {
			$text = ( new WallEditBuilder() )
					->setMessage( $wallMessage )
					->setMessageText( $newbody )
					->setEditor( $this->getContext()->getUser() )
					->build();
		} catch ( WallBuilderException $builderException ) {
			$this->error( $builderException->getMessage(), $builderException->getContext() );
			$this->response->setVal( 'status', false );
			$this->response->setVal( 'reason', 'other' );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
			return;
		} catch ( InappropriateContentException $exception ) {
			$this->response->setVal( 'status', false );
			$this->response->setVal( 'reason', 'badcontent' );
			$this->response->setVal( 'blockInfo', wfMessage('spamprotectionmatch')->numParams( $exception->getContext()['block'] )->parse() );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$this->response->setVal( 'isotime', wfTimestamp( TS_ISO_8601 ) );
		$this->response->setVal( 'fulltime', $this->wg->Lang->timeanddate( wfTimestamp( TS_MW ) ) );

		$this->response->setVal( 'username', $this->wg->User->getName() );

		$editorUrl = $this->wg->User->getUserPage()->getFullURL();

		$this->response->setVal( 'userUrl', $editorUrl );

		$query = [
			'diff' => 'prev',
			'oldid' => $wallMessage->getTitle()->getLatestRevID( Title::GAID_FOR_UPDATE ),
		];

		$this->response->setVal( 'historyUrl', $wallMessage->getTitle()->getFullURL( $query ) );
		$this->response->setVal( 'status', true );
		$this->response->setVal( 'msgTitle', Xml::element( 'a', [ 'href' => $wallMessage->getMessagePageUrl() ], $newtitle ) );
		$this->response->setVal( 'body', $text );
	}

	public function replyToMessage() {
		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return;
		}

		$this->response->setVal( 'status', true );

		$parentId = $this->request->getVal( 'parent' );
		$parentTitle = Title::newFromID( $parentId );
		$debugParentDB = 'from slave';   // tracing bug 95249

		if ( empty( $parentTitle ) ) {
			// try again from master
			$parentTitle = Title::newFromID( $parentId, Title::GAID_FOR_UPDATE );
			$debugParentDB = 'from master';
		}

		if ( empty( $parentTitle ) ) {
			$this->response->setVal( 'status', false );
			return;
		}

		$this->debug( 'Wall::replyToMessage called', [
			'parentTitle' => $parentTitle->getFullURL(),
			'parentId' => $parentId,
			'parentDb' => $debugParentDB,
		] );

		/** @var $wallMessage WallMessage */
		$wallMessage = WallMessage::newFromTitle( $parentTitle );
		$body = $this->getConvertedContent( $this->request->getVal( 'body' ) );

		try {
			$reply = ( new WallMessageBuilder() )
					->setMessageAuthor( $this->getContext()->getUser() )
					->setMessageText( $body )
					->setParentMessage( $wallMessage )
					->setParentPageTitle( $wallMessage->getArticleTitle() )
					->build();
		} catch ( WallBuilderException $builderException ) {
			$this->error( $builderException->getMessage(), $builderException->getContext() );
			$this->response->setVal( 'status', false );
			$this->response->setVal( 'reason', 'other' );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
			return;
		} catch ( InappropriateContentException $exception ) {
			$this->response->setVal( 'status', false );
			$this->response->setVal( 'reason', 'badcontent' );
			$this->response->setVal( 'blockInfo', wfMessage('spamprotectionmatch')->numParams( $exception->getContext()['block'] )->parse() );
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_FORBIDDEN );
			return;
		}

		$quotedFrom = $this->request->getVal( 'quotedFrom' );

		if ( !empty( $quotedFrom ) ) {
			$reply->setQuoteOf( $quotedFrom );
		}

		$this->replyToMessageBuildResponse( $this, $reply );

		// after successfully posting a reply
		// remove notification for this thread (if user is following it)

		if ( $this->wg->User->isLoggedIn() ) {
			$wn = new WallNotifications();
			$wn->markRead(
				$this->wg->User->getId(),
				$this->wg->CityId,
				$this->request->getVal( 'parent' ) );
		}
	}

	public function preview() {

		$body = $this->getConvertedContent( $this->request->getVal( 'body', '' ) );
		$service = new EditPageService( $this->wg->Title );

		$out = $service->getPreview( $body );

		$metatitle = $this->request->getVal( 'metatitle', '' );

		if ( !empty( $metatitle ) ) {
			$metatitle = '<div class="msg-title"><span>' . htmlspecialchars( $metatitle ) . '</span></div>';
		}

		$this->response->setVal( 'body', $metatitle . $out[0] );
	}

	protected function replyToMessageBuildResponse( $context, $reply ) {
		$context->response->setVal( 'message', $this->app->renderView( 'WallController', 'message', [ 'comment' => $reply, 'isreply' => true ] ) );
	}

	/**
	 * Handles converting wikitext to richtext and vice versa.
	 *
	 * @param string $text - the text to convert
	 * @return string - the converted text
	 */
	private function getConvertedContent( $content = '' ) {
		if ( $this->wg->EnableMiniEditorExtForWall && !empty( $content ) ) {
			$convertToFormat = $this->request->getVal( 'convertToFormat', '' );

			if ( !empty( $convertToFormat ) ) {
				$content = MiniEditorHelper::convertContent( $content, $convertToFormat, $this->response );
			}
		}

		return $content;
	}


	public function getCommentsPage() {
		// workaround to prevent index data expose
		$title = Title::newFromText( $this->request->getVal( 'pagetitle' ), $this->request->getVal( 'pagenamespace' ) );
		$this->response->setVal( 'html', $this->app->renderView( 'WallController', 'index', [ 'title' => $title, 'page' => $this->request->getVal( 'page', 1 ) ] ) );
	}

	/**
	 * Returns formatted quote wiki text given message id
	 * @param string $messageId - numeric id
	 * @param string $convertToFormat - 'wikitext' or 'richtext'.  'wikitext' if unspecified
	 * @return string markup - formatted markup (escaped)
	 * @return string status - success/failure
	 */
	public function getFormattedQuoteText() {
		$messageId = $this->request->getVal( 'messageId', '' );
		$markup = '';
		$status = 'failure';

		/**
		 * @var $mw WallMessage
		 */
		$mw = WallMessage::newFromId( $messageId );
		if ( !empty( $mw ) ) {
			$mw->load();

			$username = $mw->getUser()->getName();

			$convertToFormat = $this->request->getVal( 'convertToFormat', '' );

			if ( $convertToFormat == 'wikitext' ) {
				$markup = '<div class="quote">'
					. "\n" . wfMessage( 'wall-quote-author', $username )
						->inContentLanguage()->escaped()
					. "\n" . $mw->getRawText() . "\n</div>\n";
			} else {
				$markup = $this->getConvertedContent( '<div class="quote">'
					. wfMessage( 'wall-quote-author', $username )
						->inContentLanguage()->escaped()
					. "<br>" . $mw->getRawText() . "\n</div>\n" );
			}

			$status = 'success';
		}

		$this->response->setVal( 'markup', $markup );
		$this->response->setVal( 'status', $status );
	}

	/**
	 * Updates topics list to given message id.  It will completely override.
	 * @param string $messageId - numeric id
	 * @param array $relatedTopics - list of topics (article names)
	 * @return string status - success/failure
	 */
	public function updateTopics() {
		try {
			// SUS-664: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( self::shouldBlockAccessForForum() ) {
			//forum read-only mode edit protection
			return false;
		}

		$messageId = $this->request->getVal( 'msgid', '' );
		$relatedTopics = $this->request->getVal( 'relatedTopics', [ ] );
			// place holder data, replace this with magic
		$status = 'success';
		$topics = [ ];

		if ( !is_array( $relatedTopics ) ) {
			$relatedTopics = [ ];
		}

		// cut more then 4
		$relatedTopics = array_slice( $relatedTopics , 0, 4 );

		// save
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId( $messageId );

		if ( !empty( $mw ) ) {
			$mw->load();
			$mw->setRelatedTopics( $this->wg->User, $relatedTopics );
		}

		foreach ( $relatedTopics as $topic ) {
			$topicTitle = Title::newFromURL( $topic );
			$topics[] = [ 'topic' => $topic, 'url' => WallHelper::getTopicPageURL( $topicTitle ) ];	// I have no idea what the url will be, just a placeholder for now
		}
		// end place holder

		$this->response->setVal( 'status', $status );
		$this->response->setVal( 'topics', $topics );
	}

	/**
	 * Set proper error data if the user is not allowed to perform an action
	 */
	protected function displayRestrictionError() {
		$this->response->setData( [
			'status' => 'error',
			'errormsg' => wfMessage( 'wall-message-no-permission' )->escaped()
		] );
	}

	/**
	 * Sanitize the meta-title of a Wall thread and make it conform to length constraints
	 * @param $title
	 * @return bool|string
	 */
	protected static function sanitizeMetaTitle( $title ) {
		return substr( trim( strip_tags( $title ) ), 0, 200 );
	}

	private function shouldBlockAccessForForum() {
		return $this->wg->HideForumForms && ForumHelper::isForum();
	}
}
