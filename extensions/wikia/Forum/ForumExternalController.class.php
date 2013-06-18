<?php

class ForumExternalController extends WallExternalController {
	public function __construct() {
		$this->app = F::app();
	}

	public function getCommentsPage() {
		//workaround to prevent index data expose
		$title = Title::newFromText( $this->request->getVal( 'pagetitle' ), $this->request->getVal( 'pagenamespace' ) );
		$this->response->setVal( 'html', $this->app->renderView( 'ForumController', 'board', array( 'title' => $title, 'page' => $this->request->getVal( 'page', 1 ) ) ) );
	}

	private function checkAdminAccess() {
		if ( !$this->wg->User->isAllowed( 'forumadmin' ) ) {
			return 'accessdenied';
		}
		return '';
	}

	public function policies() {		
		$this->body = wfMsgExt( 'forum-policies-and-faq', array( 'parseinline' ));
	}

	/**
	 * Change order of the boards
	 *
	 * @request boardId1 - id of the board
	 * @request boardId2 - id of 2nd board
	 * @request status - [ok|error]
	 */

	public function swapOrder() {
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

		$boardTitle = $this->getVal( 'boardTitle', '' );
		$boardDescription = $this->getVal( 'boardDescription', '' );

		$valid = $this->validateBoardData( $boardTitle, $boardDescription );
		if ( !$valid ) {
			return true;
		}

		$newTitle = Title::newFromText( $boardTitle, NS_WIKIA_FORUM_BOARD );

		if ( $newTitle->exists() ) {
			$this->status = 'error';
			$this->errormsg = wfMsg( 'forum-board-title-validation-exists' );
			return true;
		}

		$forum = new Forum();
		$forum->createBoard( $boardTitle, $boardDescription );

		$this->status = 'ok';
		$this->errorfield = '';
		$this->errormsg = '';
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

		$boardId = $this->getVal( 'boardId', '' );
		$boardTitle = $this->getVal( 'boardTitle', '' );
		$boardDescription = $this->getVal( 'boardDescription', '' );

		if ( empty( $boardId ) ) {
			$this->status = 'error';
			$this->errormsg = wfMsg( 'forum-board-id-validation-missing' );
			return true;
		}

		$board = ForumBoard::newFromId( $boardId );
		if ( empty( $board ) ) {
			$this->status = 'error';
			$this->errormsg = wfMsg( 'forum-board-id-validation-missing' );
			return true;
		}

		$valid = $this->validateBoardData( $boardTitle, $boardDescription );
		if ( !$valid ) {
			return true;
		}

		$newTitle = Title::newFromText( $boardTitle, NS_WIKIA_FORUM_BOARD );
		if ( $newTitle->getArticleId() > 0 && $newTitle->getText() != $board->getTitle()->getText() && $newTitle->getArticleId() != $board->getTitle()->getArticleId() ) {
			$this->status = 'error';
			$this->errormsg = wfMsg( 'forum-board-title-validation-exists' );
			return true;
		}

		$forum = new Forum();
		if ( $forum->getBoardCount() == Forum::BOARD_MAX_NUMBER ) {
			$this->status = 'error';
			$this->errormsg = wfMsg( 'forum-board-validation-count', Forum::BOARD_MAX_NUMBER );
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

		$boardId = $this->getVal( 'boardId', '' );
		$boardTitle = $this->getVal( 'boardTitle', '' );
		$destinationBoardId = $this->getVal( 'destinationBoardId', '' );

		if ( $destinationBoardId == '' ) {
			$this->status = 'error';
			$this->errormsg = '';
			$this->errorfield = 'destinationBoardId';
			return true;
		}

		$board = ForumBoard::newFromId( $boardId );
		$destinationBoard = ForumBoard::newFromId( $destinationBoardId );

		if ( empty( $boardId ) || empty( $destinationBoardId ) ) {
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

		// Reject illegal characters.
		$rxTc = Title::getTitleInvalidRegex();
		if ( preg_match( $rxTc, $boardTitle ) ) {
			$this->errorfield = 'boardTitle';
			$this->errormsg = wfMsg( 'forum-board-title-validation-invalid' );
			return false;
		}

		$titleLength = strlen( $boardTitle );
		if ( $titleLength > 40 || $titleLength < 4 ) {
			$this->errorfield = 'boardTitle';
			$this->errormsg = wfMsg( 'forum-board-title-validation-length' );
			return false;
		}

		$descriptionLength = strlen( $boardDescription );

		if ( $descriptionLength > 255 || $descriptionLength < 4 ) {
			$this->errorfield = 'boardDescription';
			$this->errormsg = wfMsg( 'forum-board-description-validation-length' );
			return false;
		}

		return true;
	}

	protected function replyToMessageBuildResponse( $context, $reply ) {
		$context->response->setVal( 'message', $this->app->renderView( 'ForumController', 'threadReply', array( 'comment' => $reply, 'isreply' => true ) ) );
	}

}
