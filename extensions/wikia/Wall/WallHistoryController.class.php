<?php

class WallHistoryController extends WallController {
	private $isThreadLevel = false;

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		JSMessages::enqueuePackage( 'Wall', JSMessages::EXTERNAL );
		$title = $this->getContext()->getTitle();

		$this->isThreadLevel = $this->request->getVal( 'threadLevelHistory', false );

		$path = [ ];

		if ( $this->isThreadLevel ) {
			$threadId = intval( $title->getDBkey() );
			$title = Title::newFromId( $threadId );
		}

		$this->historyPreExecute();
		$page = $this->request->getVal( 'page', 1 );
		$page = ( ( $page = intval( $page ) ) === 0 ) ? 1 : $page;

		$this->response->setVal( 'sortingOptions', $this->getSortingOptions() );
		$this->response->setVal( 'sortingSelected', $this->getSortingSelectedText() );
		$this->response->setVal( 'wallHistoryMsg', $this->getHistoryMessagesArray() );
		$this->response->setVal( 'currentPage', $page );
		$this->response->setVal( 'isThreadLevelHistory', $this->isThreadLevel );


		if ( !( $title instanceof Title ) ||
			( $this->isThreadLevel &&
				!in_array( MWNamespace::getSubject( $title->getNamespace() ), $this->wg->WallNS ) )
		) {
			// paranoia -- why the message is not in DB
			$this->response->setVal( 'wallmessageNotFound', true );
			return;
		}

		if ( $this->isThreadLevel ) {
			$wallMessage = new WallMessage( $title );
			$wallMessage->load();

			$perPage = 50;
			$wallHistory = new WallHistory();
			$wallHistory->setPage( $page, $perPage );
			$count = $wallHistory->getCount( null, $threadId );
			$sort = $this->getSortingSelected();
			$history = $wallHistory->get( null, $sort, $threadId );
			$this->response->setVal( 'wallHistory', $this->getFormatedHistoryData( $history, $threadId ) );

			$path[] = [
				'title' => $wallMessage->getMetatitle(),
				'url' => $wallMessage->getMessagePageUrl()
			];

			$wallUrl = $wallMessage->getArticleTitle()->getFullUrl();
			$wallOwnerName = $wallMessage->getArticleTitle()->getText();

			$this->response->setVal( 'wallHistoryUrl', $wallMessage->getMessagePageUrl( true ) . '?action=history&sort=' . $sort );
		} else {
			$perPage = 100;
			$wallHistory = ( new WallHistory );
			$wallHistory->setPage( $page, $perPage );
			$sort = $this->getSortingSelected();
			if ( $title->exists() ) {
				$count = $wallHistory->getCount( $title->getArticleId(), null, false );
				$history = $wallHistory->get( $title->getArticleId(), $sort, null, false );
			} else {
				$count = 0;
				$history = [ ];
			}

			$wallUrl = $title->getFullUrl();
			$wallOwnerName = $title->getText();

			$this->response->setVal( 'wallHistory', $this->getFormatedHistoryData( $history ) );
			$this->response->setVal( 'wallHistoryUrl', $title->getFullURL( [ 'action' => 'history', 'sort' => $sort ] ) );
		}

		$path = array_merge( [ [
			'title' => wfMessage( 'wall-message-elseswall', [ $wallOwnerName ] )->escaped(),
			'url' => $wallUrl
		] ], $path );

		$this->response->setVal( 'wallOwnerName', $wallOwnerName );

		if ( $this->isThreadLevel ) {
			$this->response->setVal( 'pageTitle', wfMessage( 'wall-thread-history-title' )->escaped() );
			wfRunHooks( 'WallHistoryThreadHeader', [ $title, $wallMessage, &$path, &$this->response, &$this->request ] );
		} else {
			$this->response->setVal( 'pageTitle', wfMessage( 'wall-history-title' )->escaped() );
			wfRunHooks( 'WallHistoryHeader', [ $title, &$path, &$this->response, &$this->request ] );
		}

		$this->response->setVal( 'path', $path );
		$this->response->setVal( 'totalItems', $count );
		$this->response->setVal( 'itemsPerPage', $perPage );
		$this->response->setVal( 'showPager', ( $count > $perPage ) );
	}

	public function threadHistory() {
		// this method is only to load other template
		// all template variables and logic can be found
		// in method above -- WallHistoryController::index()
	}

	private function historyPreExecute() {
		$this->response->addAsset( 'wall_history_js' );
		$this->response->addAsset( 'extensions/wikia/Wall/css/WallHistory.scss' );

		// VOLDEV-36: separate monobook styling
		if ( $this->app->checkSkin( 'monobook' ) ) {
			$this->response->addAsset( 'extensions/wikia/Wall/css/monobook/WallHistoryMonobook.scss' );
		}

		$output = $this->getContext()->getOutput();
		if ( $this->isThreadLevel ) {
			$output->setPageTitle( wfMessage( 'wall-thread-history-title' )->text() );
			$this->wg->SuppressPageHeader = true;
		} else {
			$output->setPageTitle( wfMessage( 'wall-history-title' )->text() );
		}

		$output->setPageTitleActionText( wfMessage( 'history_short' )->text() );
		$output->setArticleFlag( false );
		$output->setArticleRelated( true );
		$output->setRobotPolicy( 'noindex,nofollow' );
		$output->setSyndicated( true );
		$output->setFeedAppendQuery( 'action=history' );

		$this->sortingType = 'history';
	}

	private function getHistoryMessagesArray() {
		if ( $this->isThreadLevel ) {
			return [
				'thread-' . WH_NEW => 'wall-thread-history-thread-created',
				'reply-' . WH_NEW => 'wall-thread-history-reply-created',
				'thread-' . WH_REMOVE => 'wall-thread-history-thread-removed',
				'reply-' . WH_REMOVE => 'wall-thread-history-reply-removed',
				'thread-' . WH_RESTORE => 'wall-thread-history-thread-restored',
				'reply-' . WH_RESTORE => 'wall-thread-history-reply-restored',
				'thread-' . WH_DELETE => 'wall-thread-history-thread-deleted',
				'reply-' . WH_DELETE => 'wall-thread-history-reply-deleted',
				'thread-' . WH_EDIT => 'wall-thread-history-thread-edited',
				'reply-' . WH_EDIT => 'wall-thread-history-reply-edited',
				'thread-' . WH_ARCHIVE => 'wall-thread-history-thread-closed',
				'thread-' . WH_REOPEN => 'wall-thread-history-thread-reopened',
			];
		} else {
			return [
				WH_NEW => 'wall-history-thread-created',
				WH_REMOVE => 'wall-history-thread-removed',
				WH_RESTORE => 'wall-history-thread-restored',
				WH_DELETE => 'wall-history-thread-admin-deleted',
			];
		}
	}

	private function getFormatedHistoryData( $history, $threadId = 0 ) {
		// VOLDEV-39: Store whether Wall is enabled
		$ns = $this->wg->EnableWallExt ? NS_USER_WALL : NS_USER_TALK;

		foreach ( $history as $key => $value ) {
			$type = intval( $value['action'] );

			if ( !$this->isThreadLevel && !in_array( $type, [ WH_NEW, WH_REMOVE, WH_RESTORE, WH_DELETE ] ) ) {
				unset( $history[$key] );
				continue;
			}

			/** @var Title $title */
			$title = $value['title'];
			$wm = new WallMessage( $title );
			/** @var User $user */
			$user = $value['user'];
			$username = $user->getName();

			$userTalk = Title::newFromText( $username, $ns );
			$url = $userTalk->getFullUrl();

			if ( $user->isAnon() ) {
				$history[$key]['displayname'] = Linker::linkKnown( $userTalk, wfMessage( 'oasis-anon-user' )->escaped() );
				$history[$key]['displayname'] .= ' ' . Linker::linkKnown(
						$userTalk,
						Html::element( 'small', [ ], $username ),
						[ 'class' => 'username' ]
					);
			} else {
				$history[$key]['displayname'] = Linker::linkKnown( $userTalk, $username );
			}

			$history[$key]['authorurl'] = $url;
			$history[$key]['username'] = $user->getName();
			$history[$key]['userpage'] = $url;
			$history[$key]['type'] = $type;
			$history[$key]['usertimeago'] = $this->getContext()->getLanguage()->timeanddate( $value['event_mw'] );
			$history[$key]['reason'] = $value['reason'];
			$history[$key]['actions'] = [ ];

			if ( $this->isThreadLevel ) {
				$history[$key]['isreply'] = $isReply = $value['is_reply'];
				$history[$key]['prefix'] = ( $isReply === '1' ) ? 'reply-' : 'thread-';

				if ( intval( $value['page_id'] ) === $threadId ) {
					// if the entry is about change in top message
					// hardcode the order number to 1
					$history[$key]['msgid'] = 1;
				} else {
					$history[$key]['msgid'] = $wm->getOrderId();
				}

				$wm->load();
				$messagePageUrl = $wm->getMessagePageUrl();
				$history[$key]['msgurl'] = $messagePageUrl;

				$msgUser = $wm->getUser();
				$msgPage = Title::newFromText( $msgUser->getName(), $ns );
				if ( empty( $msgPage ) ) {
					// SOC-586, SOC-578 : There is an edge case where $msgUser->getName can be empty
					// because of a rev_deleted flag on the revision loaded by ArticleComment via the
					// WallMessage $wm->load() above.  ArticleComment overwrites the User objects mName
					// usertext with the first revision's usertext to preserve the thread author but in
					// rare occasions this revision can have its user hidden via a DELETED_USER flag.
					$history[$key]['msguserurl'] = '';
					$history[$key]['msgusername'] = '';
				} else {
					$history[$key]['msguserurl'] = $msgPage->getFullUrl();
					$history[$key]['msgusername'] = $msgUser->getName();
				}

				if ( $type == WH_EDIT ) {
					$rev = Revision::newFromTitle( $title );
					// mech: fixing 20617 - revision_id is available only for new entries
					$query = [
						'diff' => 'prev',
						'oldid' => ( $history[$key]['revision_id'] ) ? $history[$key]['revision_id'] : $title->getLatestRevID(),
					];

					$history[$key]['actions'][] = [
						'href' => $rev->getTitle()->getLocalUrl( $query ),
						'msg' => wfMessage( 'diff' )->text(),
					];
				}
			} else {
				$msgUrl = $wm->getMessagePageUrl( true );
				$history[$key]['msgurl'] = $msgUrl;
				$history[$key]['historyLink'] = Xml::element( 'a', [ 'href' => $msgUrl . '?action=history' ], wfMessage( 'wall-history-action-thread-history' )->text() );
			}

			if ( ( $type == WH_REMOVE && !$wm->isAdminDelete() ) || ( $type == WH_DELETE && $wm->isAdminDelete() ) ) {
				if ( $wm->canRestore( $this->getContext()->getUser(), false ) ) {
					if ( $this->isThreadLevel ) {
						$restoreActionMsg = ( $isReply === '1' ) ? wfMessage( 'wall-history-action-restore-reply' )->text() : wfMessage( 'wall-history-action-restore-thread' )->text();
					} else {
						$restoreActionMsg = wfMessage( 'wall-history-action-restore' )->text();
					}

					$history[$key]['actions'][] = [
						'class' => 'message-restore', // TODO: ?
						'data-id' => $value['page_id'],
						'data-mode' => 'restore' . ( $wm->canFastRestore( $this->getContext()->getUser(), false ) ? '-fast' : '' ),
						'href' => '#',
						'msg' => $restoreActionMsg
					];
				}
			}

			$userid = $user->getId();
			if ( $user->isAnon() ) WallRailController::addAnon( $userid, $user );
			else WallRailController::addUser( $userid, $user );
		}

		return $history;
	}

}
