<?php
/**
 * Forum Special Page
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ForumSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Forum', '', false );
		OasisController::addBodyParameter('itemscope itemtype="http://schema.org/WebPage"');
	}

	public function init() {
		if( $this->app->checkSkin( 'monobook' ) ) {
			$this->response->addAsset( 'extensions/wikia/WikiaStyleGuide/js/Form.js' );
			$this->response->addAsset( 'resources/wikia/modules/querystring.js' );
		}

		$this->response->addAsset( 'extensions/wikia/Forum/css/Forum.scss' );
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumSpecial.scss' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$this->getContext()->getOutput()->setRobotPolicy( "index,follow" );

		$policies = Title::newFromText( 'forum-policies-and-faq', NS_MEDIAWIKI);
		$this->response->setJsVar( 'wgCanEditPolicies', $this->wg->User->isAllowed('forumadmin'));
		$this->response->setJsVar( 'wgPoliciesRev', $policies->getLatestRevID()  );
		$this->response->setJsVar( 'wgPoliciesEditURL', $policies->getFullUrl( 'action=edit' )  );

		//getLatestRevID

		JSMessages::enqueuePackage('Forum', JSMessages::EXTERNAL);
		$this->response->addAsset( 'extensions/wikia/Forum/js/Forum.js' );

		if ( $this->request->getVal( 'showWarning', 0 ) == 1 ) {
			NotificationsController::addConfirmation( wfMsg( 'forum-board-no-board-warning' ), NotificationsController::CONFIRMATION_WARN );
		}

		$action = $this->getVal( 'action', '' );

		if ( 'editmode' == $action ) {
			$this->forward( 'ForumSpecial', 'editMode' );
		}

		$this->wg->Out->setPageTitle( wfMsg( 'forum-forum-title', $this->wg->Sitename ) );

		$action = $this->getVal( 'action', '' );

		$this->blurb = wfMsgExt( 'forum-specialpage-blurb', 'parse' );
		$this->blurbHeading = wfMsg( 'forum-specialpage-blurb-heading' );
		$this->lastPostByMsg = wfMsg( 'forum-specialpage-board-lastpostby' );
		$this->canEdit = $this->wg->User->isAllowed( 'forumadmin' );
		$this->editUrl = $this->wg->Title->getFullUrl( 'action=editmode' );

		$forum = new Forum();

		if ( $forum->createDefaultBoard() ) {
			$this->boards = $forum->getBoardList( DB_MASTER );
		} else {
			$this->boards = $forum->getBoardList( DB_SLAVE );
		}

		if ( $forum->haveOldForums() ) {
			$this->showOldForumLink = true;
			$this->oldForumLink = Title::newFromText( 'Index', NS_FORUM )->getFullUrl();
		} else {
			$this->showOldForumLink = false;
		}

		//TODO: keep the varnish cache and do purging on post
		$this->response->setCacheValidity( 0, 0 );

		wfProfileOut( __METHOD__ );
	}

	public function editMode() {
		wfProfileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return false;
			// skip rendering
		}

		// set assets
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumBoardEdit.scss' );
		$this->response->addAsset( 'extensions/wikia/Forum/js/ForumBoardEdit.js' );

		$this->boards = (new Forum)->getBoardList( DB_SLAVE );

		wfProfileOut( __METHOD__ );
	}

	public function createNewBoardModal() {
		wfProfileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return false;
			// skip rendering
		}

		wfProfileOut( __METHOD__ );
	}

	public function editBoardModal() {
		wfProfileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return false;
			// skip rendering
		}

		$this->boardId = $this->getVal( 'boardId', -1 );

		$board = ForumBoard::newFromId( $this->boardId );

		/* backend magic here */

		$this->boardTitle = $board->getTitle()->getText();
		$this->boardDescription = $board->getRawDescription();

		wfProfileOut( __METHOD__ );
	}

	public function removeBoardModal() {
		wfProfileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
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

		wfProfileOut( __METHOD__ );
	}

}
