<?php

class ForumController extends WallBaseController {
	protected $sortingType = 'index';
	const BOARD_PER_PAGE = 25;

	public function __construct() {
		parent::__construct();
	}

	public function init() {
		/**
		 * Include Forum.scss only if
		 * the method is called in a Forum context
		 */
		if ( ForumHelper::isForum() ) {
			$this->response->addAsset( 'extensions/wikia/Forum/css/Forum.scss' );
		}
	}

	public function board() {
		// VOLDEV-95: Use correct title from request
		/** @var Title $title */
		$title = $this->request->getVal( 'title' );
		$ns = $title->getNamespace();

		if ( $ns == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$topicTitle = $this->getTopicTitle();
			if ( empty( $topicTitle ) || !$topicTitle->exists() ) {
				$this->redirectToIndex();
				return false;
			}
		}

		parent::index( self::BOARD_PER_PAGE );

		$this->addAssets();
		$this->response->setVal( 'description', '' );
		/** @var Wall $wall */
		$wall = $this->response->getVal( 'wall' );

		if ( $ns == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$board = new ForumBoard();

			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads( $wall->getRelatedPageId() ) );
			$this->response->setVal( 'isTopicPage', true );

			$this->app->wg->Out->setPageTitle( wfMessage( 'forum-board-topic-title', $this->wg->title->getBaseText() )->plain() );
		} else {
			$boardId = $wall->getId();
			/** @var ForumBoard $board */
			$board = ForumBoard::newFromId( $boardId );

			if ( empty( $board ) ) {
				$this->redirectToIndex();
				return false;
			}

			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads() );
			$this->response->setVal( 'isTopicPage', false );

			$this->response->setVal( 'description', $board->getDescription() );

			$this->app->wg->Out->setPageTitle( wfMessage( 'forum-board-title', $this->wg->title->getBaseText() )->plain() );
		}

		$this->response->setVal( 'boardNamespace', NS_WIKIA_FORUM_BOARD );

		// TODO: keep the varnish cache and do purging on post
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
	}

	protected function redirectToIndex() {
		$title = Title::newFromText( 'Forum', NS_SPECIAL );
		$this->wg->Out->redirect( $title->getFullURL() . '?showWarning=1' );
	}

	protected function getTopicTitle() {
		/** @var Title $title */
		$title = $this->request->getVal( 'title' );
		$topicTitle = Title::newFromText( $title->getText() );
		return $topicTitle;
	}

	/**
	 * @param Title $title
	 * @return null|Wall
	 */
	public function getWallForIndexPage( $title ) {
		if ( $title->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$topicTitle = $this->getTopicTitle();
			if ( !empty( $topicTitle ) ) {
				$wall = Wall::newFromRelatedPages( $title, $topicTitle->getArticleId() );
				$this->response->setVal( 'topicText', $topicTitle->getPrefixedText() );
				$wall->disableCache();
			} else {
				$wall = Wall::newFromTitle( $title );
			}
		} else {
			$wall = Wall::newFromTitle( $title );
		}

		return $wall;
	}

	public function boardNewThread() {

		if ( $this->wg->HideForumForms ) {
			//skip rendering
			return false;
		}

		parent::newMessage();
		$isTopicPage = $this->getVal( 'isTopicPage', false );
		$this->response->setVal( 'isTopicPage', $isTopicPage );

		if ( $isTopicPage ) {
			$forum = new Forum();

			$list = $forum->getBoardList();

			$destinationBoards = [
				[
					'value' => '',
					'content' => wfMessage( 'forum-board-destination-empty' )->escaped()
				]
			];

			foreach ( $list as $value ) {
				$destinationBoards[] = [
					'value' => htmlspecialchars( $value[ 'name' ] ),
					'content' => htmlspecialchars( $value[ 'name' ] )
				];
			}

			$this->response->setVal( 'destinationBoards', $destinationBoards );
		}

		$this->response->setVal( 'showMiniEditor', $this->wg->EnableMiniEditorExt );
	}

	public function boardThread() {
		wfProfileIn( __METHOD__ );

		$wallMessage = $this->getWallMessage();
		if ( !( $wallMessage instanceof WallMessage ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$this->response->setVal( 'id', $wallMessage->getId() );
		$this->response->setVal( 'feedtitle', htmlspecialchars( $wallMessage->getMetaTitle() ) );
		$isWatched = $wallMessage->isWatched( $this->wg->User ) || $this->request->getVal( 'new', false );
		$this->response->setVal( 'isWatched', $isWatched );
		$this->response->setVal( 'showFollowing', !$this->wg->HideForumForms );
		$this->response->setVal( 'fullpageurl', $wallMessage->getMessagePageUrl() );
		$this->response->setVal( 'kudosNumber', $wallMessage->getVoteCount() );

		$replies = $this->getVal( 'replies', [ ] );
		$repliesCount = count( $replies ) + 1;
		$this->response->setVal( 'repliesNumber', $repliesCount );

		$thread = WallThread::newFromId( $wallMessage->getId() );

		$lastReply = $thread->getLastMessage();
		if ( $lastReply === null ) {
			$lastReply = $wallMessage;
		}

		// even though $data['author'] is a User object already
		// it's a cached object, and we need to make sure that we are
		// using newest RealName
		// cache invalidation in this case would require too many queries
		$authorUser = User::newFromName( $lastReply->getUser()->getName() );
		if ( $authorUser ) {
			$name = $authorUser->getName();
		} else {
			$name = $lastReply->getUser()->getName();
		}

		if ( $lastReply->getUser()->isAnon() ) {
			$displayname = wfMessage( 'oasis-anon-user' )->escaped();
			$displayname2 = $lastReply->getUser()->getName();
			$url = Skin::makeSpecialUrl( 'Contributions' ) . '/' . $lastReply->getUser()->getName();
		} else {
			$displayname = $name;
			$displayname2 = '';
			$url = Title::newFromText( $name, $this->wg->EnableWallExt ? NS_USER_WALL : NS_USER_TALK )->getFullUrl();
		}

		$this->response->setVal( 'username', $name );
		$this->response->setVal( 'displayname', $displayname );
		$this->response->setVal( 'displayname2', $displayname2 );
		$this->response->setVal( 'user_author_url', $url );
		$this->response->setVal( 'iso_timestamp', $lastReply->getCreatTime( TS_ISO_8601 ) );
		$this->response->setVal( 'fmt_timestamp', $this->wg->Lang->timeanddate( $lastReply->getCreatTime( TS_MW ) ) );

		wfProfileOut( __METHOD__ );
	}

	public function brickHeader() {
		if ( $this->app->wg->Title->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$indexPage = Title::newFromText( 'Forum', NS_SPECIAL );
			$path = [ ];
			$path[] = [ 'title' => wfMessage( 'forum-forum-title' )->escaped(), 'url' => $indexPage->getFullUrl() ];

			$path[] = [ 'title' => wfMessage( 'forum-board-topics' )->escaped() ];

			$topicTitle = Title::newFromURL( $this->app->wg->Title->getText() );

			if ( !empty( $topicTitle ) ) {
				$path[] = [ 'title' => $topicTitle->getPrefixedText() ];
			}

			$this->response->setVal( 'path', $path );
		} else {
			parent::brickHeader();
		}

		$this->getResponse()
			->getView()
			->setTemplatePath( 'extensions/wikia/Wall/templates/Wall_brickHeader.php' );
	}

	public function threadMessage() {
		parent::message();
	}

	public function threadNewReply() {
		parent::reply();
	}

	public function threadReply() {
		parent::message();
	}

	public function threadMessageButtons() {
		parent::messageButtons();
	}

	// get sorting options
	protected function getSortingOptionsText() {
		switch ( $this->sortingType ) {
			case 'history' :
				// keys of sorting array are names of DOM elements' classes
				// which are needed to click tracking
				// if you change those keys here, do so in Wall.js file, please
				$options = [
					'nf' => wfMessage( 'wall-history-sorting-newest-first' )->escaped(),
					'of' => wfMessage( 'wall-history-sorting-oldest-first' )->escaped(),
				];
				break;
			case 'index' :
			default :
				$options = [
					'nr' => wfMessage( 'forum-sorting-option-newest-replies' )->escaped(),
					// 'pt' => wfMessage('forum-sorting-option-popular-threads')->escaped(),
					'mr' => wfMessage( 'forum-sorting-option-most-replies' )->escaped(),
					'nt' => wfMessage( 'forum-sorting-option-newest-threads' )->escaped(),
					'ot' => wfMessage( 'forum-sorting-option-oldest-threads' )->escaped(),
				];
				break;
		}

		return $options;
	}

	protected function getSortingSelected() {
		$selected = $this->wg->request->getVal( 'sort' );

		if ( empty( $selected ) ) {
			$selected = $this->app->wg->User->getGlobalPreference( 'forum_sort_' . $this->sortingType );
		} else {
			$selectedDB = $this->app->wg->User->getGlobalPreference( 'forum_sort_' . $this->sortingType );

			if ( $selectedDB != $selected ) {
				$this->app->wg->User->setGlobalPreference( 'forum_sort_' . $this->sortingType, $selected );
				$this->app->wg->User->saveSettings();
			}
		}

		if ( empty( $selected ) || !array_key_exists( $selected, $this->getSortingOptionsText() ) ) {
			$selected = ( $this->sortingType === 'history' ) ? 'of' : 'nr';
		}

		return $selected;
	}

	public function forumActivityModule() {
		$baseForumActivityService = new DatabaseForumActivityService();
		$forumActivityService = new CachedForumActivityService( $baseForumActivityService, $this->wg->Memc );

		$out = $forumActivityService->getRecentlyUpdatedThreads();

		$this->response->setVal( 'posts', $out );
	}

	public function forumRelatedThreads() {
		$title = Title::newFromId( $this->app->wg->Title->getText() );
		$this->response->setVal( 'showModule', false );
		if ( !empty( $title ) && $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD ) {

			$rp = new WallRelatedPages();
			$out = $rp->getMessageRelatetMessageIds( [ $title->getArticleId() ] );
			$messages = [ ];
			$count = 0;
			foreach ( $out as $key => $val ) {
				if ( $title->getArticleId() == $val[ 'comment_id' ] ) {
					continue;
				}

				$msg = WallMessage::newFromId( $val[ 'comment_id' ] );
				if ( !empty( $msg ) ) {
					$msg->load();

					$message = [ 'message' => $msg ];

					if ( !empty( $val[ 'last_child' ] ) ) {
						$childMsg = WallMessage::newFromId( $val[ 'last_child' ] );

						if ( !empty( $childMsg ) ) {
							$childMsg->load();
							$message[ 'reply' ] = $childMsg;
						}
					}

					$messages[] = $message;
					$count++;
					if ( $count == 5 ) {
						break;
					}
				}
			}

			$this->response->setVal( 'showModule', !empty( $messages ) );
			$this->response->setVal( 'messages', $messages );
		}
	}

	private function addAssets() {
		JSMessages::enqueuePackage( 'Wall', JSMessages::EXTERNAL );
		$this->response->addAsset( 'forum_js' );
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumBoard.scss' );
		$this->response->addAsset( 'extensions/wikia/Wall/css/MessageTopic.scss' );

		if ( $this->wg->EnableMiniEditorExtForWall ) {
			$this->sendRequest( 'MiniEditor', 'loadAssets',
				[ 'additionalAssets' => [ 'forum_mini_editor_js', 'extensions/wikia/MiniEditor/css/Wall/Wall.scss' ] ]
			);
		}
	}
}
