<?php

use Wikia\Logger\WikiaLogger;

/**
 * Forum Special Page
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class ForumSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Forum', '', false );
		OasisController::addBodyParameter( 'itemscope itemtype="http://schema.org/WebPage"' );
	}

	public function init() {
		$this->response->addAsset( 'extensions/wikia/Forum/css/Forum.scss' );
		$this->response->addAsset( 'extensions/wikia/Forum/css/ForumSpecial.scss' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		$output = $this->getContext()->getOutput();

		$output->setRobotPolicy( "index,follow" );

		$policies = Title::newFromText( 'forum-policies-and-faq', NS_MEDIAWIKI );
		$this->response->setJsVar( 'wgCanEditPolicies', $this->wg->User->isAllowed( 'forumadmin' ) );
		$this->response->setJsVar( 'wgPoliciesRev', $policies->getLatestRevID()  );
		$this->response->setJsVar( 'wgPoliciesEditURL', $policies->getFullUrl( 'action=edit' )  );

		// getLatestRevID

		JSMessages::enqueuePackage( 'Forum', JSMessages::EXTERNAL );
		$this->response->addAsset( 'extensions/wikia/Forum/js/Forum.js' );

		if ( $this->request->getVal( 'showWarning', 0 ) == 1 ) {
			BannerNotificationsController::addConfirmation(
				wfMessage( 'forum-board-no-board-warning' )->escaped(),
				BannerNotificationsController::CONFIRMATION_WARN
			);
		}

		$action = $this->getVal( 'action', '' );

		if ( 'editmode' == $action && !$this->wg->HideForumForms ) {
			$this->forward( 'ForumSpecial', 'editMode' );
		}

		$output->setPageTitle( wfMessage( 'forum-forum-title' )->plain() );


		$this->response->setVal('blurb', wfMessage( 'forum-specialpage-blurb' )->parse());
		$this->response->setVal('blurbHeading', wfMessage( 'forum-specialpage-blurb-heading' )->parse());
		$this->response->setVal('lastPostByMsg', wfMessage( 'forum-specialpage-board-lastpostby' )->escaped());
		$this->response->setVal('canEdit', $this->wg->User->isAllowed( 'forumadmin' ));
		$this->response->setVal('editUrl', $this->wg->Title->getFullUrl( 'action=editmode' ));
		$this->response->setVal('showEditButton', !$this->wg->HideForumForms);

		$forum = new Forum();

		// TODO: once we're sure the forums are properly created when importing starter wiki
		// don't call createDefaultBoard anymore
		$createdDefaultBoard = $forum->createDefaultBoard();
		$this->response->setVal( 'boards', $forum->getBoardList( $createdDefaultBoard ? DB_MASTER : DB_SLAVE ) );

		$haveOldForums = $forum->haveOldForums();
		$this->response->setVal( 'showOldForumLink', $haveOldForums );
		if ( $haveOldForums ) {
			$this->response->setVal( 'oldForumLink', Title::newFromText( 'Index', NS_FORUM )->getFullUrl() );
		}

		// TODO: keep the varnish cache and do purging on post
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );

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

		$this->response->setVal('boards', ( new Forum )->getBoardList( DB_SLAVE ));

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

		$this->response->setVal( 'title', wfMessage( 'forum-admin-create-new-board-modal-heading' )->plain() );
		$this->response->setVal( 'submitLabel', wfMessage( 'forum-admin-create-new-board-label' )->plain() );

		$form = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'boardTitle',
					'isRequired' => true,
					'label' => wfMessage( 'forum-admin-create-new-board-title' )->plain(),
					'attributes' => [
						'maxlength' => '40'
					],
				],
				[
					'type' => 'text',
					'name' => 'boardDescription',
					'isRequired' => true,
					'label' => wfMessage( 'forum-admin-create-new-board-description' )->plain(),
					'attributes' => [
						'maxlength' => '255'
					],
				],
				[
					'type' => 'hidden',
					'name' => 'token',
					'value' => $this->getUser()->getEditToken(),
				],
			],
			'method' => 'post',
			'action' => '',
		];
		$this->response->setVal( 'html', $this->app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] ) );

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

		$boardId = $this->getVal( 'boardId', -1 );

		$board = ForumBoard::newFromId( $boardId );
		$boardTitle = $board->getTitle()->getText();
		$boardDescription = $board->getRawDescription();

		$this->response->setVal( 'title', wfMessage( 'forum-admin-edit-board-modal-heading', $boardTitle )->plain() );
		$this->response->setVal( 'submitLabel', wfMessage( 'save' )->plain() );

		$form = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'boardTitle',
					'value' => htmlspecialchars( $boardTitle ),
					'isRequired' => true,
					'label' => wfMessage( 'forum-admin-edit-board-title' )->plain(),
					'attributes' => [
						'maxlength' => '40'
					],
				],
				[
					'type' => 'text',
					'name' => 'boardDescription',
					'value' => htmlspecialchars( $boardDescription ),
					'isRequired' => true,
					'label' => wfMessage( 'forum-admin-edit-board-description' )->plain(),
					'attributes' => [
						'maxlength' => '255'
					],
				],
				[
					'type' => 'hidden',
					'name' => 'token',
					'value' => $this->getUser()->getEditToken(),
				],
			],
			'method' => 'post',
			'action' => '',
		];

		$this->response->setVal( 'html', $this->app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] ) );

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

		$boardId = $this->getVal( 'boardId', -1 );

		$board = ForumBoard::newFromId( $boardId );
		if ( empty( $board ) ) {
			WikiaLogger::instance()->error( 'Error reporter: failed to find board', [
				'jiraTicket' => 'SOC-590',
				'boardId' => $boardId,
				'method' => __METHOD__
			] );
			$this->response->setCode( 404 );
			return true;
		}
		$boardTitle = $board->getTitle()->getText();


		$forum = new Forum();

		$list = $forum->getBoardList();

		$destinationBoards =
			[
				[
					'value' => '',
					'content' => wfMessage( 'forum-board-destination-empty' )->escaped()
				]
			];

		foreach ( $list as $value ) {
			if ( $boardId != $value[ 'id' ] ) {
				$destinationBoards[] = [
					'value' => $value[ 'id' ],
					'content' => htmlspecialchars( $value[ 'name' ] )
				];
			}
		}

		$this->response->setVal( 'destinationBoards', $destinationBoards );

		$this->response->setVal( 'title', wfMessage( 'forum-admin-delete-and-merge-board-modal-heading', $boardTitle )->plain() );
		$this->response->setVal( 'submitLabel', wfMessage( 'forum-admin-delete-and-merge-button-label' )->plain() );

		$form = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'boardTitle',
					'isRequired' => true,
					'label' => wfMessage( 'forum-admin-delete-board-title' )->plain(),
				],
				[
					'type' => 'custom',
					'output' => wfMessage( 'forum-admin-merge-board-warning' )->plain(),
				],
				[
					'type' => 'select',
					'name' => 'destinationBoardId',
					'class' => 'destinationBoardId',
					'isRequired' => true,
					'label' => wfMessage( 'forum-admin-merge-board-destination', $boardTitle )->plain(),
					'options' => $this->destinationBoards,
				],
				[
					'type' => 'hidden',
					'name' => 'token',
					'value' => $this->getUser()->getEditToken(),
				],
			],
			'method' => 'post',
			'action' => '',
		];

		$this->response->setVal( 'html', $this->app->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] ) );

		wfProfileOut( __METHOD__ );
	}

}
