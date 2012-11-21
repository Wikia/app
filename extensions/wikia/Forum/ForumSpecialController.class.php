<?php
/**
 * Forum Special Page
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ForumSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Forum', '', false );
	}

	public function init() {
		if( $this->app->checkSkin( 'monobook' ) ) {
			$this->response->addAsset( 'extensions/wikia/WikiaStyleGuide/js/Form.js' );
			$this->response->addAsset( 'resources/wikia/modules/querystring.js' );
		}
	
		$this->response->addAsset( 'extensions/wikia/Forum/css/Forum.scss' );
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumSpecial.scss' );
		$this->response->setJsVar( 'wgIsForum', true );
		$this->wg->IsForum = true;
	}

	public function index() {
		$this->wf->profileIn( __METHOD__ );
		
		$policies = Title::newFromText( 'forum-policies-and-faq', NS_MEDIAWIKI);
		$this->response->setJsVar( 'wgCanEditPolicies', $this->wg->User->isAllowed('forumadmin'));
		$this->response->setJsVar( 'wgPoliciesRev', $policies->getLatestRevID()  );
		$this->response->setJsVar( 'wgPoliciesEditURL', $policies->getFullUrl( 'action=edit' )  );
		
		//getLatestRevID
		
		F::build('JSMessages')->enqueuePackage('Forum', JSMessages::EXTERNAL);
		$this->response->addAsset( 'extensions/wikia/Forum/js/Forum.js' );

		if ( $this->request->getVal( 'showWarning', 0 ) == 1 ) {
			NotificationsController::addConfirmation( wfMsg( 'forum-board-no-board-worning' ), NotificationsController::CONFIRMATION_WARN );
		}

		$action = $this->getVal( 'action', '' );

		if ( 'editmode' == $action ) {
			$this->forward( 'ForumSpecial', 'editMode' );
		}

		$this->wg->Out->setPageTitle( $this->wf->msg( 'forum-forum-title', $this->wg->Sitename ) );

		$action = $this->getVal( 'action', '' );

		$this->blurb = $this->wf->MsgExt( 'forum-specialpage-blurb', 'parse' );
		$this->blurbHeading = $this->wf->Msg( 'forum-specialpage-blurb-heading' );
		$this->lastPostByMsg = $this->wf->Msg( 'forum-specialpage-board-lastpostby' );
		$this->canEdit = $this->wg->User->isAllowed( 'forumadmin' );
		$this->editUrl = $this->wg->Title->getFullUrl( 'action=editmode' );

		$forum = F::build( 'Forum' );

		if ( $forum->createDefaultBoard() ) {
			$this->boards = $forum->getBoardList( DB_MASTER, NS_WIKIA_FORUM_BOARD );
		} else {
			$this->boards = $forum->getBoardList( DB_SLAVE, NS_WIKIA_FORUM_BOARD );
		}

		if ( $forum->haveOldForums() ) {
			$this->showOldForumLink = true;
			$this->oldForumLink = Title::newFromText( 'Index', NS_FORUM )->getFullUrl();
		} else {
			$this->showOldForumLink = false;
		}

		//TODO: keep the varnish cache and do purging on post
		$this->response->setCacheValidity( 0, 0 );

		$this->wf->profileOut( __METHOD__ );
	}

	public function editMode() {
		$this->wf->profileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		// set assets
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumBoardEdit.scss' );
		$this->response->addAsset( 'extensions/wikia/Forum/js/ForumBoardEdit.js' );

		$this->boards = F::build( 'Forum' )->getBoardList();

		$this->wf->profileOut( __METHOD__ );
	}

	public function createNewBoardModal() {
		$this->wf->profileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		$this->wf->profileOut( __METHOD__ );
	}

	public function editBoardModal() {
		$this->wf->profileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		$this->boardId = $this->getVal( 'boardId', -1 );

		$board = ForumBoard::newFromId( $this->boardId );

		/* backend magic here */

		$this->boardTitle = $board->getTitle()->getText();
		$this->boardDescription = $board->getDescription(false);

		$this->wf->profileOut( __METHOD__ );
	}

	public function removeBoardModal() {
		$this->wf->profileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		$this->boardId = $this->getVal( 'boardId', -1 );

		$board = ForumBoard::newFromId( $this->boardId );

		// mock data
		$this->boardTitle = $board->getTitle()->getText();

		$forum = new Forum();

		$list = $forum->getBoardList();

		$this->destinationBoards = array( array( 'value' => '', 'content' => wfMsg( 'forum-board-destination-empty' ) ) );

		foreach ( $list as $value ) {
			if ( $this->boardId != $value['id'] ) {
				$this->destinationBoards[] = array( 'value' => $value['id'], 'content' => htmlspecialchars( $value['name'] ) );
			}
		}

		$this->wf->profileOut( __METHOD__ );
	}

}
