<?php

class ForumController extends WallBaseController {
	private $isThreadLevel = false;
	protected $sortingType = 'index';

	public function __construct() {
		parent::__construct();
	}

	public function init() {
		$this->response->addAsset('extensions/wikia/Forum/css/Forum.scss');
	}
	
	public function setIsForum() {
		$this->response->setJsVar('wgIsForum', true);
		$this->wg->IsForum = true;
	}

	public function board() {
		parent::index();
		$this->setIsForum();
		F::build('JSMessages')->enqueuePackage('Wall', JSMessages::EXTERNAL);
 
		$this->response->addAsset('forum_js');
		$this->response->addAsset('extensions/wikia/Forum/css/ForumBoard.scss');
		$this->response->addAsset('extensions/wikia/Forum/css/MessageTopic.scss');
		$this->addMiniEditorAssets();

		if($this->wall->getTitle()->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD) {
			$board = F::build( 'ForumBoard', array( 0 ), 'newFromId' );

			if(empty($board)) {
				$this->forward('Forum', 'boardError');
				return true;
			}
		
			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads($this->wall->getRelatedPageId()) );
			$this->response->setVal( 'isTopicPage', true );
		} else {
			$boardId = $this->wall->getId();
			$board = F::build( 'ForumBoard', array( $boardId ), 'newFromId' );
			
			
			if(empty($board)) {
				$this->forward('Forum', 'boardError');
				return true;
			}
			
			$this->response->setVal( 'activeThreads', $board->getTotalActiveThreads() );
			$this->response->setVal( 'isTopicPage', false );			
		}
		
		$this->app->wg->SuppressPageHeader = true;
		$this->app->wg->Out->setPageTitle( wfMsg('forum-board-title', $this->wg->title->getBaseText()) );
	}

	public function boardError() {
		
	}

	public function getWallForIndexPage($title) {
		if($title->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD) {
			$topicTitle = F::build('Title', array($title->getText()), 'newFromURL');
			
			if(!empty($topicTitle)) {
				$wall = F::build('Wall', array($title, $topicTitle->getArticleId()), 'newFromRelatedPages');
				$this->response->setVal( 'topicText', $topicTitle->getPrefixedText() );
				$wall->disableCache();		
			} else {
				$wall = F::build('Wall', array($title), 'newFromTitle');	
			}		
		} else {
		 	$wall = F::build('Wall', array(($title)), 'newFromTitle');
		}
		
		return $wall; 
	}
	
	public function boardNewThread() {
		parent::newMessage();
	}

	public function boardThread() {
		$this->wf->ProfileIn( __METHOD__ );
		
		$this->setIsForum();
		$wallMessage = $this->getWallMessage();
		if( !($wallMessage instanceof WallMessage) ) {
			$this->forward(__CLASS__, 'message_error');
			return true;
		}
 
		$this->response->setVal( 'id', $wallMessage->getId() );
		$this->response->setVal( 'feedtitle', htmlspecialchars($wallMessage->getMetaTitle()) );
		$this->response->setVal( 'isWatched', $wallMessage->isWatched($this->wg->User) || $this->request->getVal('new', false) );
		$this->response->setVal( 'fullpageurl', $wallMessage->getMessagePageUrl() );
		$this->response->setVal( 'kudosNumber',  $wallMessage->getVoteCount() );

		$replies = $this->getVal('replies', array());
		$repliesCount = count($replies);
		$this->response->setVal('repliesNumber', $repliesCount);

		$lastReply = $this->getLastReply($replies);
		if ($lastReply === false) {
			$lastReply = $wallMessage;
		}

		// even though $data['author'] is a User object already
		// it's a cached object, and we need to make sure that we are
		// using newest RealName
		// cache invalidation in this case would require too many queries
		$authorUser = User::newFromName( $lastReply->getUser()->getName() );
		if( $authorUser ) {
			$name = $authorUser->getName();
		} else {
			$name = $lastReply->getUser()->getName();
		}

		if ( $lastReply->getUser()->getId() == 0 ) { // anynymous contributor
			$displayname = wfMsg('oasis-anon-user');
			$displayname2 = $lastReply->getUser()->getName();
			$url = Skin::makeSpecialUrl('Contributions').'/'.$lastReply->getUser()->getName();
		} else {
			$displayname = $name;
			$displayname2 = '';
			$url = F::build( 'Title', array( $name, NS_USER_WALL ), 'newFromText' )->getFullUrl();
		}

		$this->response->setVal( 'username', $name );
		$this->response->setVal( 'displayname', $displayname );
		$this->response->setVal( 'displayname2', $displayname2 );
		$this->response->setVal( 'user_author_url', $url );
		$this->response->setVal( 'iso_timestamp', $lastReply->getCreatTime(TS_ISO_8601) );
		$this->response->setVal( 'fmt_timestamp', $this->wg->Lang->timeanddate($lastReply->getCreatTime(TS_MW)) );

		$this->wf->ProfileOut( __METHOD__ );
	}

	public function breadCrumbs() {
		if($this->app->wg->Title->getNamespace() == NS_WIKIA_FORUM_TOPIC_BOARD) {
			$indexPage = F::build('Title', array('Forum', NS_SPECIAL), 'newFromText' );
			$path = array();
			$path[] = array(
				'title' => wfMsg( 'forum-forum-title', $this->app->wg->sitename ),
				'url' => $indexPage->getFullUrl()
			);

			$path[] = array(
				'title' => wfMsg( 'forum-board-topics'  )
			);
			
			$topicTitle = F::build('Title', array($this->app->wg->Title->getText()), 'newFromURL');
			
			if(!empty($topicTitle)) {
				$path[] = array(
					'title' => $topicTitle->getPrefixedText()
				);
			}
			
			$this->response->setVal( 'path', $path );
		} else {
			parent::brickHeader();	
		}
	}

	public function header() {
		$forum = F::build( 'Forum' );
		$this->response->setVal( 'threads', $forum->getTotalThreads() );
		$this->response->setVal( 'activeThreads', $forum->getTotalActiveThreads() );
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
		if ($this->wg->EnableMiniEditorExtForWall && $this->app->checkSkin( 'oasis' )) {
			$this->sendRequest('MiniEditor', 'loadAssets', array(
				'additionalAssets' => array(
					'forum_mini_editor_js',
					'extensions/wikia/MiniEditor/css/Wall/Wall.scss'
				)
			));
		}
	}

	// get sorting options
	protected function getSortingOptionsText() {
		switch( $this->sortingType ) {
			case 'history':
				//keys of sorting array are names of DOM elements' classes
				//which are needed to click tracking
				//if you change those keys here, do so in Wall.js file, please
				$options = array(
					'nf' => $this->app->wf->Msg('wall-history-sorting-newest-first'),
					'of' => $this->app->wf->Msg('wall-history-sorting-oldest-first'),
				);
				break;
			case 'index':
			default:
				$options = array(
					'nr' => $this->app->wf->Msg('forum-sorting-option-newest-replies'),
			//		'pt' => $this->app->wf->Msg('forum-sorting-option-popular-threads'),
					'mr' => $this->app->wf->Msg('forum-sorting-option-most-replies'),
				);
				break;
		}

		return $options;
	}

	protected function getSortingSelected() {
		$selected = $this->wg->request->getVal('sort');

		if( empty($selected) ) {
			$selected = $this->app->wg->User->getOption( 'forum_sort_'.$this->sortingType );
		} else {
			$selectedDB = $this->app->wg->User->getOption( 'forum_sort_'.$this->sortingType );

			if( $selectedDB != $selected ) {
				$this->app->wg->User->setOption( 'forum_sort_'.$this->sortingType, $selected );
				$this->app->wg->User->saveSettings();
			}
		}

		if( empty($selected) || !array_key_exists($selected, $this->getSortingOptionsText()) ) {
			$selected = ( $this->sortingType === 'history' ) ? 'of' : 'nr';
		}

		return $selected;
	}

	/**
	 * get last reply object
	 * @param array $replies
	 * @return false or WallMessage
	 */
	protected function getLastReply( $replies = array() ) {
		if ( count($replies) > 0 ) {
			$last = end($replies);
			if ( $last instanceof WallMessage ) {
				$last->load();
				return $last;
			}
		}

		return false;
	}
	
	public function forumActivityModule() {
		$wallHistory = F::build('WallHistory', array($this->app->wg->CityId));
		$out = $wallHistory->getLastPosts(NS_WIKIA_FORUM_BOARD);
		$this->response->setVal( 'posts', $out );
	}
	
	public function forumParticipationModule() {
		$wallHistory = F::build('WallHistory', array($this->app->wg->CityId));
		$out = $wallHistory->getLastUsers(NS_WIKIA_FORUM_BOARD);
		
		$this->response->setVal( 'participants', $out );		
	}
	
	public function forumRelatedThreads() {
		$title = F::build( 'Title', array( $this->app->wg->Title->getText() ), 'newFromId' );
		$this->response->setVal( 'showModule', false );
		if(!empty($title) && $title->getNamespace() == NS_WIKIA_FORUM_BOARD_THREAD) {
		
			$rp = new WallRelatedPages();
			$out = $rp->getMessageRelatetMessageIds(array($title->getArticleId()));
			$messages = array();
			$count = 0;
			foreach($out as $key => $val) {				
				if($title->getArticleId() == $val['comment_id']) {
					continue;
				}
				
				$msg = WallMessage::newFromId($val['comment_id']);
				if(!empty($msg)) {
					$msg->load();
					
					$message = array(
						'message' => $msg
					);
					
					if(!empty($val['last_child'])) {
						$childMsg = WallMessage::newFromId($val['last_child']);
						
						if(!empty($childMsg)) {
							$childMsg->load();
							$message['reply'] = $childMsg;
						}
					}
					
					$messages[] = $message;
					$count++;
					if($count == 5) {
						break;
					}
				}
			}
	
			$this->response->setVal( 'showModule', !empty($messages) );	
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
		return true;
	}
}