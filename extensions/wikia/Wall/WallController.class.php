<?php

/**
 * A class which represents a user wall. A Wall is a replacement for the main part of the User_talk page.
 * A Wall consists of "Bricks" which are each a single topic/thread/conversation.
 * In typical use, a Wall will only load a subset of Bricks because there will be a TON of bricks as time goes on.
 */
class WallController extends ArticleCommentsModule {
	private $helper;
	protected $allowedNamespaces = array();
	
	public function __construct() {
		$this->app = F::App();
		$this->allowedNamespaces = $this->app->getLocalRegistry()->get('UserProfileNamespaces');
	}
	
	public function init() {
		$this->helper = F::build('WallHelper', array());
	}

	public function index() {
		F::build('JSMessages')->enqueuePackage('Wall', JSMessages::EXTERNAL); 
		
		$this->response->addAsset('extensions/wikia/Wall/js/Wall.js');
		$this->response->addAsset('extensions/wikia/Wall/css/Wall.scss');
		$this->response->addAsset('skins/common/jquery/jquery.autoresize.js');
		
		$title = $this->request->getVal('title', $this->app->wg->Title);

		$page = $this->request->getVal('page', 1);
		
		$wallMessagesPerPage = 20;
		if(!empty($this->app->wg->wgWallMessagesPerPage)){
			$wallMessagesPerPage = $this->app->wg->wgWallMessagesPerPage;
		};

		$filterid = $this->request->getVal('filterid', null);
		$this->getCommentsData($title, $page, $wallMessagesPerPage, $filterid);
		
		if( !empty($filterid) ) {
			$this->response->setVal('showNewMessage', false);
			$this->response->setVal('condenseMessage', false);
			
			if( count($this->commentListRaw) > 0 ) {
				$wn = F::build('WallNotifications', array());
				foreach($this->commentListRaw as $key => $val ){
					$all = $wn->markRead( $this->wg->User->getId(), $this->wg->CityId, $key );
					break;
				}
			}
			
			$this->response->setVal('renderUserTalkArchiveAnchor', false);
		} else {
			$this->response->setVal('showNewMessage', true);
			$this->response->setVal('condenseMessage', true);
			$this->response->setVal('renderUserTalkArchiveAnchor', true);
		}	
		
		$this->response->setVal('title', $title);
		$this->response->setVal('totalItems', $this->countComments);
		
		$this->response->setVal('itemsPerPage', $wallMessagesPerPage); 
		//TODO: use request insted of wg
		$this->response->setVal('showPager', ($this->countComments > $wallMessagesPerPage) );
		
		$this->response->setVal('currentPage', $page ); 
	}

	public function messageDeleted() {
		$parts = explode('/', $this->app->wg->Title->getText());
		$parent_title = F::build('Title', array($parts[0], NS_USER_WALL), 'newFromText' );
		$user = F::build('User',array($parts[0]),'newFromName');
		$user_displayname = $user->getRealName();
		if(empty($user_displayname)) $user_displayname = $user->getName();
		
		$this->response->setVal( 'wallOwner', $user_displayname);	
		$this->response->setVal( 'wallUrl', $parent_title->getFullUrl() );
	}	
	/**
	 * @brief Passes $userTalkArchiveContent to the template and renders the template
	 * 
	 * @desc Renders old User_talk:[username] page in new place, using Wall_renderOldUserTalkPage.php template
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderOldUserTalkPage() {
		$wallUrl = $this->request->getVal('wallUrl');
		
		$this->userTalkArchiveContent = $this->getUserTalkContent();
		
		if( $this->userTalkArchiveContent === false && !empty($wallUrl) ) {
		//the subpages did not exist before
			$this->app->wg->Out->redirect($wallUrl, 301);
		}
	}
	
	/**
	 * @brief Passes $userTalkArchiveContent to the template and renders the template
	 * 
	 * @desc Renders old User_talk:[username]/[subpage] page in new place, using Wall_renderOldUserTalkSubpage.php template
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderOldUserTalkSubpage() {
		$subpageName = $this->request->getVal('subpage', null);
		$wallUrl = $this->request->getVal('wallUrl');
		
		$this->content = $this->getUserTalkContent($subpageName);
		
		if( $this->content === false && !empty($wallUrl) ) {
		//the subpages did not exist before
			$this->app->wg->Out->redirect($wallUrl, 301);
		}
	}
	
	/**
	 * @brief Passes $renderUserTalkArchiveAnchor to the template and renders the template
	 * 
	 * @desc Renders an anchor to "User talk archive" page
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function renderUserTalkArchiveAnchor() {
		$renderUserTalkArchiveAnchor = $this->request->getVal('renderUserTalkArchiveAnchor', false);
		
		$title = $this->request->getVal('title');
		$content = $this->getUserTalkContent();
		if( !empty($content) && $renderUserTalkArchiveAnchor !== false ) {
			$this->renderUserTalkArchiveAnchor = true;
			$this->userTalkArchivePageUrl = (empty($title) ? $this->wg->Title->getFullUrl():$title->getFullUrl()).'/'.$this->helper->getArchiveSubPageText();
		}
	}
	
	public function newMessage() {
		$wall_username = $this->helper->getUser()->getRealName();
		if( empty( $wall_username) ) $wall_username = $this->helper->getUser()->getName();
		
		$username = $this->wg->User->getName();
		$this->response->setVal('username', $username);
		$this->response->setVal('wall_username', $wall_username);
		
		$this->checkAndSetAnonsEditing();
	}
	
	public function loadMore() {	
		$this->response->setVal('repliesNumber', $this->request->getVal('repliesNumber'));
	}
	
	public function message() {
		wfProfileIn( __METHOD__ );
		$comment = $this->request->getVal('comment');
		
		$wallMessage = F::build('WallMessage', array($comment), 'newFromArticleComment' );
	
		$this->response->setVal('hide',  false);
		
		$data = $wallMessage->getData($this->wg->User);

		$this->response->setVal('title', $this->getVal('title'));
		
		if( !$this->getVal('isreply') ) {
			$this->response->setVal('feedtitle', htmlspecialchars($wallMessage->getMetaTitle()) );
			$this->response->setVal('body', $data['text'] );
			$this->response->setVal('isreply', false ); 
			
			$wallMaxReplies = 4;
			if(!empty($this->app->wg->wgWallMaxReplies)){
				$wallMaxReplies = $this->app->wg->wgWallMaxReplies;
			};
			
			$replies = $this->getVal('replies');
			$repliesCount = count($replies);
			$this->response->setVal('repliesNumber', $repliesCount); 
			$this->response->setVal('showRepliesNumber', $repliesCount);
			$this->response->setVal('showLoadMore', false );
			
			if($this->request->getVal('condense', true) && $repliesCount > $wallMaxReplies) {
				$this->response->setVal('showRepliesNumber', $wallMaxReplies - 2 );	
				$this->response->setVal('showLoadMore', true );
			}
			$this->response->setVal('isWatched', $wallMessage->isWatched($this->wg->User) || $this->request->getVal('new', false));
			$this->response->setVal('replies', $replies ); 
		} else {
			$showFrom = $this->request->getVal('repliesNumber') - $this->request->getVal('showRepliesNumber');
			if( $showFrom > $this->request->getVal('current') ){
				$this->response->setVal('hide',  true);
			}
			
			$this->response->setVal('body', $data['text'] );
			$this->response->setVal('isreply', true );
			$this->response->setVal('replies', false );
		}
		
		$author_user = User::newFromName($data['author']->getName());
		
		$name     = $data['author']->getName();
		// even tho $data['author'] is a User object already
		// it's a cached object, and we need to make sure that we are
		// using newest RealName
		// cache invalidation in this case would require too many queries
		if($author_user)
			$realname = $author_user->getRealName();
		else
			$realname = '';
		
		$this->response->setVal( 'id', (empty($data['id']) ? '':$data['id'] ));
		$this->response->setVal( 'username', $name );
		//$this->response->setVal( 'sig', $data['sig'] );
		$this->response->setVal( 'realname', $realname );
		$this->response->setVal( 'rawtimestamp', $data['rawtimestamp'] );
		$this->response->setVal( 'iso_timestamp',  wfTimestamp(TS_ISO_8601, $data['rawmwtimestamp'] ));
		
		$this->response->setVal( 'fullpageurl', $this->helper->getMessagePageUrl($comment) );
		$this->response->setVal( 'wgBlankImgUrl', $this->wg->BlankImgUrl );
		$this->response->setVal( 'canEdit', $wallMessage->canEdit($this->wg->User) );
		$this->response->setVal( 'canDelete',$wallMessage->canDelete($this->wg->User) );
		
		if($this->wg->User->getId() > 0 && !$wallMessage->isWallOwner($this->wg->User)) {
			$this->response->setVal( 'showFallowButton', true );
		} else {
			$this->response->setVal( 'showFallowButton', false );
		}
		
		$displayname  = $realname;
		$displayname2 = $name;
		
		if( empty($displayname) ) {
			$displayname = $name;
			$displayname2 = '';
		}

		$this->response->setVal( 'displayname',  $displayname );
		$this->response->setVal( 'displayname2', $displayname2 );
		
		wfProfileOut( __METHOD__ );
	}
	
	public function reply() {
		$this->response->setVal('username', $this->wg->User->getName() );
		
		$this->checkAndSetAnonsEditing();
	}
	
	public function brickHeader() {
		$this->response->setVal( 'wallUrl', '#');
		$this->response->setVal( 'wallName', '');
		$this->response->setVal( 'messageTitle', '');

		$title = F::build('Title', array($this->request->getVal('id')), 'newFromId' );
		
		if(!empty($title)) {
			$wallMessage = F::build('WallMessage', array($title), 'newFromTitle' );
			
			$wallMessageParent = $wallMessage->getTopParentObj();
			if(!empty($wallMessageParent)) {
				$wallMessage = $wallMessageParent;
			}
			
			$wallMessage->load();
			
			if( $wallMessage->getWallOwner()->getId() == $this->wg->User->getId() ) {
				$this->response->setVal( 'wallName', wfMsg('wall-message-mywall') );
			} else {
				$this->response->setVal( 'wallName', wfMsg('wall-message-elseswall', $wallMessage->getWallOwner()->getName()));
			}
			
			$this->response->setVal( 'wallUrl', $wallMessage->getWallUrl() );
		}
		$this->response->setVal( 'messageTitle', $wallMessage->getMetaTitle() );
	}
	
	/**
	 * @brief Checks if $wgDisableAnonymousEditing is not empty and and if user is logged-in
	 * 
	 * @desc If $wgDisableAnonymousEditing is not empty and user is not logged-in it sets two vars and passes it to the templates
	 */
	protected function checkAndSetAnonsEditing() {
		if( !empty($this->app->wg->DisableAnonymousEditing) && !$this->app->wg->User->isLoggedIn() ) {
			$this->response->setVal('loginToEditProtectedPage', true);
			$this->response->setVal('ajaxLoginUrl', $this->app->wg->Title->getLocalUrl());
		} else {
			$this->response->setVal('loginToEditProtectedPage', false);
		}
	}
	
	/**
	 * @brief Gets and returns user's talk page's content
	 * 
	 * @param string $subpageName a title of user talk subpage
	 * 
	 * @return Title
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getUserTalkContent($subpageName = '') {
		if( !empty($subpageName) ) {
			$pageTitle = $this->helper->getTitle(NS_USER_TALK, $subpageName);
		} else {
			$pageTitle = $this->helper->getTitle(NS_USER_TALK);
		}
		$article = F::build('Article', array($pageTitle));
		$articleId = $article->getId();
		
		if( empty($articleId) ) {
			return false;
		} else {
			return $this->app->wg->Parser->parse($article->getContent(), $pageTitle, new ParserOptions($this->wg->User))->getText();
		}
	}
} // end class Wall
