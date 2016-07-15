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

		JSMessages::enqueuePackage( 'Wall', JSMessages::EXTERNAL );
		$this->response->addAsset( 'forum_js' );
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumBoard.scss' );
		$this->response->addAsset( 'extensions/wikia/Wall/css/MessageTopic.scss' );

		// VOLDEV-36: separate monobook styling
		if ( $this->app->checkSkin( 'monobook' ) ) {
			$this->response->addAsset( 'extensions/wikia/Forum/css/monobook/ForumMonobook.scss' );
			$this->response->addAsset( 'extensions/wikia/Forum/css/monobook/ForumBoardMonobook.scss' );
		}

		$this->addMiniEditorAssets();

		$this->description = '';

		if ( $ns == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$board = ForumBoard::getEmpty();

			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads( $this->wall->getRelatedPageId() ) );
			$this->response->setVal( 'isTopicPage', true );

			$this->app->wg->Out->setPageTitle( wfMessage( 'forum-board-topic-title', $this->wg->title->getBaseText() )->plain() );
		} else {
			$boardId = $this->wall->getId();
			/** @var ForumBoard $board */
			$board = ForumBoard::newFromId( $boardId );

			if ( empty( $board ) ) {
				$this->redirectToIndex();
				return false;
			}

			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads() );
			$this->response->setVal( 'isTopicPage', false );

			$this->description = $board->getDescription();

			$this->app->wg->Out->setPageTitle( wfMessage( 'forum-board-title', $this->wg->title->getBaseText() )->plain() );
		}

		$this->response->setVal( 'boardNamespace', NS_WIKIA_FORUM_BOARD );

		// TODO: keep the varnish cache and do purging on post
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );

		$this->app->wg->SuppressPageHeader = true;
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
		parent::newMessage();
		$this->isTopicPage = $this->getVal( 'isTopicPage', false );
		if ( $this->isTopicPage ) {
			$forum = new Forum();

			$list = $forum->getBoardList();

			$this->destinationBoards = [ [ 'value' => '', 'content' => wfMessage( 'forum-board-destination-empty' )->escaped() ] ];

			foreach ( $list as $value ) {
				$this->destinationBoards[] = [ 'value' => htmlspecialchars( $value['name'] ), 'content' => htmlspecialchars( $value['name'] ) ];
			}
		}
	}

	public function boardThread() {
		wfProfileIn( __METHOD__ );

		$wallMessage = $this->getWallMessage();
		if ( !( $wallMessage instanceof WallMessage ) ) {
			wfProfileOut( __METHOD__ );
			$this->forward( __CLASS__, 'message_error' );
			return true;
		}

		$this->response->setVal( 'id', $wallMessage->getId() );
		$this->response->setVal( 'feedtitle', htmlspecialchars( $wallMessage->getMetaTitle() ) );
		$this->response->setVal( 'isWatched', $wallMessage->isWatched( $this->wg->User ) || $this->request->getVal( 'new', false ) );
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

		if ( $lastReply->getUser()->getId() == 0 ) {// anynymous contributor
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

	public function breadCrumbs() {
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
	}

	public function header() {
		$forum = new Forum();
		$this->response->setVal( 'threads', $forum->getTotalThreads() );
		$this->response->setVal( 'activeThreads', $forum->getTotalActiveThreads() );

		$title = $this->wg->Title;
		$pageHeading = wfMessage( 'forum-specialpage-heading' )->escaped();
		$pageDescription = '';
		$this->showStats = true;
		$nameSpace = $title->getNamespace();
		if ( $nameSpace === NS_WIKIA_FORUM_BOARD ) {
			$this->showStats = false;
			$pageHeading = wfMessage( 'forum-board-title', $title->getText() )->escaped();
			$board = ForumBoard::newFromTitle( $title );
			$pageDescription = $board->getDescription();
		} else if ( $nameSpace === NS_USER_WALL_MESSAGE ) {
			$this->showStats = false;
			$messageKey = $title->getText();
			$message = WallMessage::newFromId( $messageKey );
			if ( !empty( $message ) ) {
				$message->load();
				$pageHeading = $message->getMetaTitle();
			}
		}

		$this->pageHeading = $pageHeading;
		$this->pageDescription = $pageDescription;
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

	protected function addMiniEditorAssets() {
		if ( $this->wg->EnableMiniEditorExtForWall && $this->app->checkSkin( 'oasis' ) ) {
			$this->sendRequest( 'MiniEditor', 'loadAssets',
				[ 'additionalAssets' => [ 'forum_mini_editor_js', 'extensions/wikia/MiniEditor/css/Wall/Wall.scss' ] ]
			);
		}
	}

	// get sorting options
	protected function getSortingOptionsText() {
		switch( $this->sortingType ) {
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
		$wallHistory = new WallHistory( $this->app->wg->CityId );
		$out = $wallHistory->getLastPosts( NS_WIKIA_FORUM_BOARD );
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
				if ( $title->getArticleId() == $val['comment_id'] ) {
					continue;
				}

				$msg = WallMessage::newFromId( $val['comment_id'] );
				if ( !empty( $msg ) ) {
					$msg->load();

					$message = [ 'message' => $msg ];

					if ( !empty( $val['last_child'] ) ) {
						$childMsg = WallMessage::newFromId( $val['last_child'] );

						if ( !empty( $childMsg ) ) {
							$childMsg->load();
							$message['reply'] = $childMsg;
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

	public function messageTopic() {
		// stub function
	}

	/**
	 * render html for old forum info
	 */

	public function oldForumInfo() {
		// TODO: include some css build some urls
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumOld.scss' );

		$forumTitle = SpecialPage::getTitleFor( 'Forum' );
		$this->forumUrl = $forumTitle->getLocalUrl();
		return true;
	}

}
