<?php

class ForumController extends WallBaseController {
	protected $sortingType = 'index';
	const BOARD_PER_PAGE = 25;

	public function __construct() {
		parent::__construct();
	}

	public function init() {
		$this->response->addAsset( 'extensions/wikia/Forum/css/Forum.scss' );
	}

	public function board() {
		$ns = $this->wg->Title->getNamespace();

		if ( $ns == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$topicTitle = $this->getTopicTitle();
			if ( empty($topicTitle) || !$topicTitle->exists() ) {
				if(!$topicTitle->exists()) {
					$this->redirectToIndex();
					return false;
				}
			}
		}

		parent::index(self::BOARD_PER_PAGE);

		JSMessages::enqueuePackage( 'Wall', JSMessages::EXTERNAL );
		$this->response->addAsset( 'forum_js' );
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumBoard.scss' );
		$this->response->addAsset( 'extensions/wikia/Wall/css/MessageTopic.scss' );

		$this->addMiniEditorAssets();

		$this->description = '';

		if ( $ns == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$board = ForumBoard::getEmpty();

			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads( $this->wall->getRelatedPageId() ) );
			$this->response->setVal( 'isTopicPage', true );

			$this->app->wg->Out->setPageTitle( wfMsg( 'forum-board-topic-title', $this->wg->title->getBaseText() ) );
		} else {
			$boardId = $this->wall->getId();
			$board = ForumBoard::newFromId( $boardId );

			if ( empty( $board ) ) {
				$this->redirectToIndex();
				return false;
			}

			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads() );
			$this->response->setVal( 'isTopicPage', false );

			$this->description = $board->getDescription();

			$this->app->wg->Out->setPageTitle( wfMsg( 'forum-board-title', $this->wg->title->getBaseText() ) );
		}

		$this->response->setVal( 'boardNamespace', NS_WIKIA_FORUM_BOARD );

		//TODO: keep the varnish cache and do purging on post
		$this->response->setCacheValidity( 0, 0 );

		$this->app->wg->SuppressPageHeader = true;
	}

	protected function redirectToIndex() {
		$title = Title::newFromText( 'Forum', NS_SPECIAL );
		$this->wg->Out->redirect( $title->getFullURL() . '?showWarning=1' );
	}

	protected function getTopicTitle() {
		$text = $this->wg->Title->getText();
		$topicTitle =  Title::newFromURL($text);
		return $topicTitle;
	}

	public function getWallForIndexPage($title) {
		if ( $title->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			$topicTitle = $this->getTopicTitle();
			if ( !empty( $topicTitle ) ) {
				$wall = Wall::newFromRelatedPages( $title, $topicTitle->getArticleId() );
				$this->response->setVal( 'topicText', $topicTitle->getPrefixedText() );
				$this->response->setVal( 'topicURL', $topicTitle->getFullUrl() );
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
		$this->isTopicPage = $this->getVal('isTopicPage', false);
		if($this->isTopicPage) {
			$forum = new Forum();

			$list = $forum->getBoardList();

			$this->destinationBoards = array( array( 'value' => '', 'content' => wfMsg( 'forum-board-destination-empty' ) ) );

			foreach ( $list as $value ) {
				$this->destinationBoards[] = array( 'value' => htmlspecialchars( $value['name'] ), 'content' => htmlspecialchars( $value['name'] ) );
			}
		}
	}

	public function boardThread() {
		wfProfileIn( __METHOD__ );

		$wallMessage = $this->getWallMessage();
		if ( !($wallMessage instanceof WallMessage) ) {
			wfProfileOut( __METHOD__ );
			$this->forward( __CLASS__, 'message_error' );
			return true;
		}

		$this->response->setVal( 'id', $wallMessage->getId() );
		$this->response->setVal( 'feedtitle', htmlspecialchars( $wallMessage->getMetaTitle() ) );
		$this->response->setVal( 'isWatched', $wallMessage->isWatched( $this->wg->User ) || $this->request->getVal( 'new', false ) );
		$this->response->setVal( 'fullpageurl', $wallMessage->getMessagePageUrl() );
		$this->response->setVal( 'kudosNumber', $wallMessage->getVoteCount() );

		$replies = $this->getVal( 'replies', array() );
		$repliesCount = count( $replies ) + 1;
		$this->response->setVal( 'repliesNumber', $repliesCount );

		$thread = WallThread::newFromId($wallMessage->getId());

		$lastReply = $thread->getLastMessage( $replies );
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
			$displayname = wfMsg( 'oasis-anon-user' );
			$displayname2 = $lastReply->getUser()->getName();
			$url = Skin::makeSpecialUrl( 'Contributions' ) . '/' . $lastReply->getUser()->getName();
		} else {
			$displayname = $name;
			$displayname2 = '';
			$url = Title::newFromText($name, $this->wg->EnableWallExt ? NS_USER_WALL : NS_USER_TALK )->getFullUrl();
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
			$path = array();
			$path[] = array( 'title' => wfMsg( 'forum-forum-title', $this->app->wg->sitename ), 'url' => $indexPage->getFullUrl() );

			$path[] = array( 'title' => wfMsg( 'forum-board-topics' ) );

			$topicTitle = Title::newFromURL( $this->app->wg->Title->getText() );

			if ( !empty( $topicTitle ) ) {
				$path[] = array( 'title' => $topicTitle->getPrefixedText() );
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
		$pageHeading = wfMsg( 'forum-specialpage-heading' );
		$pageDescription = '';
		$this->showStats = true;
		$nameSpace = $title->getNamespace();
		if ( $nameSpace === NS_WIKIA_FORUM_BOARD ) {
			$this->showStats = false;
			$pageHeading = wfMsg( 'forum-board-title', $title->getText() );
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
				array( 'additionalAssets' => array( 'forum_mini_editor_js', 'extensions/wikia/MiniEditor/css/Wall/Wall.scss' ) )
			);
		}
	}

	// get sorting options
	protected function getSortingOptionsText() {
		switch( $this->sortingType ) {
			case 'history' :
				//keys of sorting array are names of DOM elements' classes
				//which are needed to click tracking
				//if you change those keys here, do so in Wall.js file, please
				$options = array( 'nf' => wfMsg( 'wall-history-sorting-newest-first' ), 'of' => wfMsg( 'wall-history-sorting-oldest-first' ), );
				break;
			case 'index' :
			default :
				$options = array(
					'nr' => wfMessage( 'forum-sorting-option-newest-replies' )->text(),
					// 'pt' => wfMessage('forum-sorting-option-popular-threads')->text(),
					'mr' => wfMessage( 'forum-sorting-option-most-replies' )->text(),
					'nt' => wfMessage( 'forum-sorting-option-newest-threads' )->text(),
					'ot' => wfMessage( 'forum-sorting-option-oldest-threads' )->text(),
				);
				break;
		}

		return $options;
	}

	protected function getSortingSelected() {
		$selected = $this->wg->request->getVal( 'sort' );

		if ( empty( $selected ) ) {
			$selected = $this->app->wg->User->getOption( 'forum_sort_' . $this->sortingType );
		} else {
			$selectedDB = $this->app->wg->User->getOption( 'forum_sort_' . $this->sortingType );

			if ( $selectedDB != $selected ) {
				$this->app->wg->User->setOption( 'forum_sort_' . $this->sortingType, $selected );
				$this->app->wg->User->saveSettings();
			}
		}

		if ( empty( $selected ) || !array_key_exists( $selected, $this->getSortingOptionsText() ) ) {
			$selected = ($this->sortingType === 'history') ? 'of' : 'nr';
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
			$out = $rp->getMessageRelatetMessageIds( array( $title->getArticleId() ) );
			$messages = array();
			$count = 0;
			foreach ( $out as $key => $val ) {
				if ( $title->getArticleId() == $val['comment_id'] ) {
					continue;
				}

				$msg = WallMessage::newFromId( $val['comment_id'] );
				if ( !empty( $msg ) ) {
					$msg->load();

					$message = array( 'message' => $msg );

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
		//TODO: include some css build some urls
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumOld.scss' );

		$forumTitle = SpecialPage::getTitleFor( 'Forum' );
		$this->forumUrl = $forumTitle->getLocalUrl();
		return true;
	}

}
