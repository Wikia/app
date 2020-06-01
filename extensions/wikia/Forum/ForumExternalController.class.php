<?php

class ForumExternalController extends WallExternalController {

	public function getCommentsPage() {
		// workaround to prevent index data expose
		$title = Title::newFromText( $this->request->getVal( 'pagetitle' ), $this->request->getVal( 'pagenamespace' ) );
		$this->response->setVal( 'html', $this->app->renderView( 'ForumController', 'board', [ 'title' => $title, 'page' => $this->request->getVal( 'page', 1 ) ] ) );
	}

	private function checkAdminAccess() {
		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			return 'accessdenied';
		}
		return '';
	}

	public function policies() {
		$this->body = wfMessage( 'forum-policies-and-faq' )->parse();
	}

	/**
	 * Change order of the boards
	 *
	 * @request boardId1 - id of the board
	 * @request boardId2 - id of 2nd board
	 * @request status - [ok|error]
	 */

	public function swapOrder() {
		try {
			// SUS-4042: Validate edit token
			$this->checkWriteRequest();
		} catch ( BadRequestException $e ) {
			$this->setTokenMismatchError();
			return false;
		}

		if ( $this->wg->HideForumForms ) {
			//read-only mode edit protection
			return false;
		}

		$boardId1 = $this->getVal( 'boardId1', 0 );
		$boardId2 = $this->getVal( 'boardId2', 0 );

		$this->status = self::checkAdminAccess();
		if ( !empty( $this->status ) ) {
			return;
		}

		$forum = new Forum();
		$forum->swapBoards( $boardId1, $boardId2 );
	}

	/**
	 * Create new board ajax call
	 * @request boardTitle - title of the board
	 * @request boardDescription - description of the board (optional)
	 * @response status - [ok|error|accessdenied]
	 * @response errorfield - optional error field.  nullable
	 * @response errormsg - optional error message. �nullable
	 */

	public function createNewBoard() {
		$this->status = self::checkAdminAccess();
		if ( !empty( $this->status ) ) {
			return;
		}

		if ( $this->wg->HideForumForms ) {
			//read-only mode edit protection
			return;
		}

		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return;
		}

		$boardTitle = $this->getVal( 'boardTitle', '' );
		$boardDescription = $this->getVal( 'boardDescription', '' );

		$valid = $this->validateBoardData( $boardTitle, $boardDescription );
		if ( !$valid ) {
			return true;
		}

		$newTitle = Title::newFromText( $boardTitle, NS_WIKIA_FORUM_BOARD );
		if ( $newTitle->exists() ) {
			$this->status = 'error';
			$this->errormsg = wfMessage( 'forum-board-title-validation-exists' )->escaped();
			return true;
		}

		$forum = new Forum();
		$creation = $forum->createBoard( $boardTitle, $boardDescription );

		if ( false === $creation ) {
			$this->status = 'error';
			$this->errormsg = wfMessage( 'forum-board-title-validation-invalid' )->escaped();
		} else {
			$this->status = 'ok';
			$this->errorfield = '';
			$this->errormsg = '';
		}
	}

	/**
	 * Edits existing board
	 * @request boardId - unique id of the board
	 * @request boardTitle - new title of the board (optional), nullable
	 * @request boardDescription - description of the board (optional), nullable
	 * @response status - [ok|error|accessdenied]
	 * @response errorfield - optional error field.  nullable
	 * @response errormsg - optional error message. �nullable
	 */
	public function editBoard() {
		$this->status = self::checkAdminAccess();

		if ( !empty( $this->status ) ) {
			return;
		}

		if ( $this->wg->HideForumForms ) {
			//read-only mode edit protection
			return;
		}

		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return;
		}

		$boardId = $this->getVal( 'boardId', '' );
		$boardTitle = $this->getVal( 'boardTitle', '' );
		$boardDescription = $this->getVal( 'boardDescription', '' );

		if ( empty( $boardId ) ) {
			$this->status = 'error';
			$this->errormsg = wfMessage( 'forum-board-id-validation-missing' )->escaped();
			return true;
		}

		$board = ForumBoard::newFromId( $boardId );
		if ( empty( $board ) ) {
			$this->status = 'error';
			$this->errormsg = wfMessage( 'forum-board-id-validation-missing' )->escaped();
			return true;
		}

		$valid = $this->validateBoardData( $boardTitle, $boardDescription );
		if ( !$valid ) {
			return true;
		}

		$newTitle = Title::newFromText( $boardTitle, NS_WIKIA_FORUM_BOARD );
		if ( $newTitle->getArticleId() > 0 && $newTitle->getText() != $board->getTitle()->getText() && $newTitle->getArticleId() != $board->getTitle()->getArticleId() ) {
			$this->status = 'error';
			$this->errormsg = wfMessage( 'forum-board-title-validation-exists' )->escaped();
			return true;
		}

		$forum = new Forum();
		if ( $forum->getBoardCount() == Forum::BOARD_MAX_NUMBER ) {
			$this->status = 'error';
			$this->errormsg = wfMessage( 'forum-board-validation-count', Forum::BOARD_MAX_NUMBER )->escaped();
			return true;
		}

		$forum->editBoard( $board, $boardTitle, $boardDescription );

		$this->status = 'ok';
		$this->errorfield = '';
		$this->errormsg = '';

	}

	/**
	 * Remove and merge board
	 * @request boardId - board to remove
	 * @request boardTitle - board Title for validation
	 * @request destinationBoardId - board to merge existing threads to
	 * @response status - [ok|error|accessdenied]
	 * @response errorfield - optional error field.  nullable
	 * @response errormsg - optional error message. �nullable
	 */
	public function removeBoard() {
		$this->status = self::checkAdminAccess();
		if ( !empty( $this->status ) ) {
			return;
		}

		if ( $this->wg->HideForumForms ) {
			//read-only mode edit protection
			return;
		}

		try {
			$this->checkWriteRequest();
		} catch ( \BadRequestException $bre ) {
			$this->setTokenMismatchError();
			return;
		}

		$boardId = $this->getVal( 'boardId', '' );
		$boardTitle = $this->getVal( 'boardTitle', '' );
		$destinationBoardId = $this->getVal( 'destinationBoardId', '' );

		if ( $destinationBoardId == '' ) {
			$this->status = 'error';
			$this->errormsg = '';
			$this->errorfield = 'destinationBoardId';
			return true;
		}

		/**
		 * @var ForumBoard $board
		 * @var ForumBoard $destinationBoard
		 */
		$board = ForumBoard::newFromId( $boardId );
		$destinationBoard = ForumBoard::newFromId( $destinationBoardId );

		if ( !$board || !$destinationBoard ) {
			$this->status = 'error';
			$this->errormsg = '';
			return true;
		}

		if ( $boardTitle != $board->getTitle()->getText() ) {
			$this->status = 'error';
			$this->errorfield = 'boardTitle';
			$this->errormsg = '';
			return true;
		}

		$board->moveAllThread( $destinationBoard );

		$board->clearCacheBoardInfo();
		$destinationBoard->clearCacheBoardInfo();

		$forum = new Forum();
		$forum->deleteBoard( $board );

		$this->status = 'ok';
		$this->errorfield = '';
		$this->errormsg = '';
	}

	private function validateBoardData( $boardTitle, $boardDescription ) {
		$this->status = 'error';
		$this->errorfield = '';
		$this->errormsg = '';

		// Trim spaces (CONN-167)
		$boardTitle = WikiaSanitizer::unicodeTrim( $boardTitle );
		$boardDescription = WikiaSanitizer::unicodeTrim( $boardDescription );

		// Reject illegal characters.
		$rxTc = Title::getTitleInvalidRegex();
		if ( preg_match( $rxTc, $boardTitle ) || is_null( Title::newFromText( $boardTitle ) ) ) {
			$this->errorfield = 'boardTitle';
			$this->errormsg = wfMessage( 'forum-board-title-validation-invalid' )->escaped();
			return false;
		}

		$forum = new Forum();
		if ( $forum->validateLength( $boardTitle, 'title' ) !== Forum::LEN_OK ) {
			$this->errorfield = 'boardTitle';
			$this->errormsg = wfMessage( 'forum-board-title-validation-length' )->escaped();
			return false;
		}

		if ( $forum->validateLength( $boardDescription, 'desc' ) !== Forum::LEN_OK ) {
			$this->errorfield = 'boardDescription';
			$this->errormsg = wfMessage( 'forum-board-description-validation-length' )->escaped();
			return false;
		}

		return true;
	}

	protected function replyToMessageBuildResponse( $context, $reply ) {
		$context->response->setVal( 'message', $this->app->renderView( 'ForumController', 'threadReply', [ 'comment' => $reply, 'isreply' => true ] ) );
	}
}
