<?php

/**
 * Reflect API for getting and posting summary bullets and responses.
 *
 * Note, many of the methods for handling Responses are almost near
 * duplicates of those handling Bullets.
 */
class ApiReflectAction extends ApiBase {

	public function execute() {
		$params = $this->extractRequestParams();

		if ( empty( $params['reflectaction'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'action' ) );
		}

		$allowedAllActions = array();
		$action = $params['reflectaction'];

		// Find the appropriate module
		$actions = $this->getActions();

		$method = $actions[$action];
		call_user_func_array( array( $this, $method ), array( $params ) );
	}

	/**
	* Gets all the bullets and responses relevant for the given LQT threads.
	*
	* The params listed below are the items posted in $params.
	* @param $comments JSON encoded list of comment ids.
	* @return assoc array of commentIDs=>array(bullets = {bullet attributes, responses})
	*/
	public function actionGetData( $params ) {
		$dbr = wfGetDB( DB_SLAVE );

		$data = array();

		global $wgUser, $wgReflectStudy;
		$user = $wgUser->getName();

		$comments = json_decode( str_replace( '\\', '', $_GET['comments'] ) );

		foreach ( $comments as $commentID ) {
			$bullets = array();
			$curBullets = $dbr->select(
					$table = 'reflect_bullet_current',
					$vars = array( 'bl_id', 'bl_rev_id' ),
					$conds = 'comment_id = ' . $commentID );

			foreach ( $curBullets as $curBullet ) {
				// TODO: is it possible to make fewer DB calls?
				$sel = array( 'bl_id as id', 'bl_timestamp as ts',
						'bl_user as u', 'bl_text as txt' );

				// TODO: create a Bullet model class for abstracting this away
				$bullet = $dbr->selectRow(
						$table = 'reflect_bullet_revision',
						$vars = $sel,
						$conds = 'bl_rev_id = ' . $curBullet->bl_rev_id );
				$bullet->rev = $curBullet->bl_rev_id;

				$bullet->highlights = array();
				$highlights = $dbr->select(
						$table = 'reflect_highlight',
						$vars = 'hl_element as eid',
						$conds = 'bl_rev_id = ' . $curBullet->bl_rev_id );

				// no fetchall?
				foreach ( $highlights as $highlight ) {
				 $bullet->highlights[] = $highlight;
				}

				$curResponses = $dbr->select(
						$table = 'reflect_response_current',
						$vars = array( 'rsp_id', 'rsp_rev_id' ),
						$conds = 'bl_id = ' . $bullet->id );

				$responses = array();
				foreach ( $curResponses as $curResponse ) {
					$response = $dbr->selectRow(
						$table = 'reflect_response_revision',
						$vars = array( 'rsp_id as id', 'rsp_timestamp as ts',
								'rsp_user as u', 'rsp_text as txt', 'rsp_signal as sig' ),
						$conds = 'rsp_rev_id = ' . $curResponse->rsp_rev_id );
					$response->rev = $curResponse->rsp_rev_id;
					$responses[$response->id] = $response;
				}
				$bullet->responses = $responses;
				$bullets[$bullet->id] = $bullet;
			}
			$data[$commentID] = $bullets;
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $data );
	}

	/**
	* Deletes a response by removing it from the current responses table.
	* A record of the response is still kept in the response revisions table.
	*
	* The params listed below are the items posted in $params.
	* @param $response_id
	* @return db's return from delete
	*/
	private function deleteResponse( $params ) {
		$dbw = wfGetDB( DB_MASTER );

		$responseID = $params['response_id'];
		$data = $dbw->delete(
			$table = 'reflect_response_current',
			$conds = array( 'rsp_id = ' . $responseID ) );

		$this->getResult()->addValue( null, $this->getModuleName(), $data );
	}

	/**
	* Deletes a bullet by removing it from the current bullets table.
	* A record of the bullet is still kept in the bullet revisions table.
	*
	* The params listed below are the items posted in $params.
	* @param $bullet_id
	* @return db's return from delete
	*/
	private function deleteBullet( $params ) {
		$dbw = wfGetDB( DB_MASTER );

		$bulletID = $params['bullet_id'];
		$data = $dbw->delete(
			$table = 'reflect_bullet_current',
			$conds = array( 'bl_id = ' . $bulletID ) );
		$this->getResult()->addValue( null, $this->getModuleName(), $data );
	}

	/**
	* Adds a new bullet or modifies an existing bullet.
	*
	* The params listed below are the items posted in $params.
	* @param $comment_id
	* @param $bullet_id If set to valid bullet_id, signals a modification
	* @param $text The bullet text
	* @param $highlights Array of sentence ids that the bullet refers to
	*
	* @return assoc array with $insert_id as the bullet id and $rev_id as the new rev id
	*/
	private function addBullet( $params ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbr = wfGetDB( DB_SLAVE );

		global $wgUser;

		$user = $wgUser->getName();
		$commentID = $params['comment_id'];

		$bulletText = $params['text'];
		if ( $bulletText == '' ) {
			return '';
		}

		$modify = isset( $params['bullet_id'] );

		if ( $modify ) {
			$bulletID = $params['bullet_id'];
		} else {
			/*
			* w/o lock, the following could lead to a race condition
			* TODO: should $wgAntiLockFlags be used here?
			*/
			$dbw->begin();		// start transaction
			$res = $dbr->query(
				'SELECT MAX(bl_id)+1 AS next_bullet_id FROM ' .
					$dbr->tableName( 'reflect_bullet_revision' )
			);
			$bulletID = $res->fetchRow();
			$bulletID = $bulletID['next_bullet_id'];
			if ( !$bulletID ) {
				$bulletID = 0;
			}
		}

		$dbw->insert( $table = 'reflect_bullet_revision', array(
					'comment_id' => $commentID,
					'bl_id' => $bulletID,
					'bl_user' => $user,
					'bl_text' => $params['text']
		) );

		$bulletRev = $dbw->insertId();

		if ( !$modify ) {
			$dbw->commit(); // end transaction
		}

		if ( isset( $params['highlights'] ) ) {
			$highlights = json_decode( str_replace( '\\', '',
					$params['highlights'] ) );
			$highlightsToInsert = array();

			foreach ( $highlights as $value ) {
				$highlightsToInsert[] = array(
						'bl_id' => $bulletID,
						'bl_rev_id' => $bulletRev,
						'hl_element' => $value->eid,
				);
			}

			$dbw->insert( "reflect_highlight",  $highlightsToInsert );
		}

		if ( $modify ) {
			/* shouldn't lead to race condition as long as
			* only bullet authors can update the bullet (DEFAULT) */
			$dbw->update( $table = 'reflect_bullet_current',
						$values = array( 'bl_rev_id' => $bulletRev ),
						$conds =  array( 'bl_id = ' . $bulletID ) );
		} else {
			$dbw->insert( $table = 'reflect_bullet_current', array(
				'bl_rev_id' => $bulletRev,
				'comment_id' => $commentID,
				'bl_id' => $bulletID,
			));
		}

		/* send email notification to commenter that someone bulleted their point
		*
		* TODO: consider possibility of someone submitting harmless bullet,
		* getting it approved, then modifying it maliciously. By not sending
		* notification on modification (as below), the commenter is opened to risk.
		*/
		global $wgReflectEnotif;
		if ($wgReflectEnotif && !$modify) {
			$threadObj = Threads::withId( $commentID );
			$to = $threadObj->author();
			$catalystUser = $wgUser;
			$this->sendMail( $threadObj, $to, $catalystUser,
					'reflect-bulleted', array( $params['text'] ), array() );
		}
		return array( "insert_id" => $bulletID, "rev_id" => $bulletRev, "u" => $user );
	}


	/**
	* Adds a new response or modifies an existing response.
	*
	* The params listed below are the items posted in $params.
	* @param $comment_id
	* @param $bullet_id The bullet to which this response addresses
	* @param $bullet_rev The current revision of the above referenced bullet
	* @param $response_id If set to valid bullet_id, signals a modification
	* @param $text The bullet text
	* @param $signal The accuracy rating for the respective bullet
	*
	* @return assoc array with $insert_id as the bullet id and $rev_id as the new rev id
	*/
	function addResponse( $params ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbr = wfGetDB( DB_SLAVE );

		global $wgUser;
		$user = $wgUser->getName();

		$bulletID = $params['bullet_id'];
		$commentID = $params['comment_id'];

		$responseText = $params['text'];
		if ( $responseText == '' ){
			return '';
		}

		$signal = (int)$params['signal'];

		$modify = isset( $params['response_id'] );
		if ( $modify ) {
			$responseID = $params['response_id'];
		} else {
			/*
			* w/o lock, the following could lead to a race condition
			* TODO: should $wgAntiLockFlags be used here?
			*/
			$dbw->begin();		// start transaction

			$res = $dbr->query(
				'select MAX(rsp_id)+1 as next_rsp_id from ' .
					$dbr->tableName( 'reflect_response_revision' )
			);
			$responseID = $res->fetchRow();
			$responseID = $responseID['next_rsp_id'];
			if ( !$responseID ) {
				$responseID = 0;
			}
		}

		$dbw->insert( $table = 'reflect_response_revision', array(
			'rsp_id' => $responseID,
			'bl_id' => $bulletID,
			'rsp_user' => $user,
			'rsp_text' => $responseText,
			'rsp_signal' => $signal
		));
		$responseRev = $dbw->insertId();

		if (!$modify){
			$dbw->commit();	// end transaction
		}

		if ( $modify ) {
			/* shouldn't lead to race condition as long as
			* only commenters can update their responses (DEFAULT) */
			$dbw->update( $table = 'reflect_response_current',
						$values = array( 'rsp_rev_id' => $responseRev ),
						$conds = array( 'rsp_id =' . $responseID ) );
		} else {
			$dbw->insert( $table = 'reflect_response_current', array(
				'rsp_rev_id' => $responseRev,
				'rsp_id' => $responseID,
				'bl_id' => $bulletID,
			));
		}

		$bullet = $dbr->selectRow(
						$table = 'reflect_bullet_revision',
						$vars = array( 'bl_user as user', 'bl_text as text' ),
						$conds = 'bl_rev_id = ' . $params['bullet_rev'] );

		/* send email notification to bullet author that someone
		* rated the accuracy of their bullet */
		global $wgReflectEnotif;
		if ($wgReflectEnotif && !$modify) {
			$threadObj = Threads::withId( $commentID );
			$to = User::newFromName( $bullet->user );
			$catalystUser = $threadObj->author();
			$this->sendMail( $threadObj, $to, $catalystUser, 'reflect-responded',
					array( $responseText, $bullet->text ), array() );
		}
		return array( "insert_id" => $responseID, "rev_id" => $responseRev,
				"u" => $user, "sig" => $signal );
	}

	/**
	* Sends a Reflect email in response to a new bullet or response.
	*
	* @param $threadObj A reference to the relevant LQT Thread
	* @param $to A User object to whom the email will be sent
	* @param $catalystUser A User object who triggered this series of events
	* @param $msgType The name of the message type to be used in accessing localized msg
	* @param $bodyParams Additional parameters to be used in the sprintf of the body text
	* @param $subjectParams Additional parameters to be used in the sprintf of the subject text
	*
	*/
	private function sendMail( $threadObj, $to, $catalystUser,
			$msgType, $bodyParams, $subjectParams )
	{
		global $wgPasswordSender, $wgLanguageCode;

		// TODO: create Reflect mailing preferences for individuals & respect them
		if ( !$to ) {
			return;
		}

		$from = new MailAddress( $wgPasswordSender, 'WikiAdmin' );
		$permaLink = LqtView::linkInContextURL( $threadObj );
		$params = array( $to->getName(), $catalystUser->getName(),
			$threadObj->subjectWithoutIncrement(), $permaLink, );
		$bodyParams = array_merge( $params, $bodyParams );
		$subjectParams = array_merge( $params, $subjectParams );
		$msg = wfMsgReal( $msgType, $bodyParams, true, $wgLanguageCode, true );
		$subject = wfMsgReal( $msgType . '-subject', $subjectParams,
			true, $wgLanguageCode, true );

		UserMailer::send( new MailAddress( $to ), $from, $subject, $msg );
	}

	/**
	* Handles the bullet posts. Calls appropriate private helper functions
	* for deletes and adds. Makes sure user has permission to perform requested
	* actions.
	*
	* The params listed below are the items posted in $params.
	* @param $delete True if post is delete. Default is add.
	*
	* @return The response from the respective helper function
	*/
	public function actionPostBullet( $params ) {
		if ( isset( $params['delete'] ) && $params['delete'] == 'true' ) {
			$verb = 'delete';
		} else {
			$verb = 'add';
		}

		if ( !$this->hasPermission( $verb, 'bullet', $params ) ) {
			return;
		}

		if ( $verb == 'delete' ) {
			$resp = $this->deleteBullet( $params );
		} else {
			$resp = $this->addBullet( $params );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $resp );
	}

	/**
	* Handles the response posts. Calls appropriate private helper functions
	* for deletes and adds. Makes sure user has permission to perform requested
	* actions.
	*
	* The params listed below are the items posted in $params.
	* @param $delete True if post is delete. Default is add.
	*
	* @return The response from the respective helper function
	*/
	public function actionPostResponse( $params ) {
		if ( isset( $params['delete'] ) && $params['delete'] == 'true' ) {
			$verb = 'delete';
		} else {
			$verb = 'add';
		}

		if ( !$this->hasPermission( $verb, 'response', $params ) ) {
			return;
		}

		if ( $verb == 'delete' ) {
			$resp = $this->deleteResponse( $params );
		} else {
			$resp = $this->addResponse( $params );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $resp );
	}

	/**
	* Checks whether the current user has permission to execute a given action.
	* Some of the characteristics examined include the users' level (admin,
	* registered, anon) and their ownership of the object being acted on.
	*
	* @param $verb The action.
	* @param $noun The object to be acted upon.
	* @param $params The params posted by the requester.
	*
	* @return Returns true if the user has permission, false otherwise.
	*/
	private function hasPermission( $verb, $noun, $params ) {

		$dbr = wfGetDB( DB_SLAVE );
		global $wgUser;

		$commentID = $params['comment_id'];
		$comment = $dbr->selectRow(
				$table = 'thread',
				$vars = array( 'thread_author_name as user' ),
				$conds = 'thread_id = ' . $commentID );
		$commentAuthor = $comment->user;

		$bulletID = $params['bullet_id'];
		if ( $bulletID ) {
			$bullet = $dbr->selectRow(
							$table = 'reflect_bullet_revision',
							$vars = array( 'bl_id as id', 'bl_user as user' ),
							$conds = 'bl_rev_id = ' . $params['bullet_rev'] );
			$bulletAuthor = $bullet->user;
		} else {
			$bulletAuthor = $wgUser->getName();
		}

		if ( $wgUser->isAnon() ) {
			$userLevel = -1;
		} elseif ( in_array( 'sysop', $wgUser->getGroups() ) ) {
			$userLevel = 2;
		} else {
			$userLevel = 1;
		}

		$userName = $wgUser->getName();
		if ( $noun == 'bullet' ) {
			$denied =	( // only admins and bullet authors can delete bullets
							$verb == 'delete'
							&& $bulletAuthor != $userName
							&& $userLevel < 2
						)
					||	( // commenters can't add bullets to their comment
							$verb == 'add'
							&& $commentAuthor == $userName
						) ;
		} elseif ( $noun == 'response' ) {
			$denied =	( // only admins and response authors can delete responses
							$verb == 'delete'
							&& $commentAuthor != $userName
							&& $userLevel < 2
						)
					||	( // only comment authors can add responses
						  	$verb == 'add'
							&& $commentAuthor != $userName
						) ;
		}
		return !$denied;
	}

	/**** ApiBase functions *****/

	public function getDescription() {
		return 'Enables Reflect on posts in Liquid-Threaded discussions.';
	}

	public function getActions() {
		return array(
			'get_data' => 'actionGetData',
			'post_bullet' => 'actionPostBullet',
			'post_response' => 'actionPostResponse',
			'post_survey_bullets' => 'actionPostSurveyBullets',
		);
	}

	public function getParamDescription() {
		return array(
			'reflectaction' => 'The action to take',
			'token' => 'An edit token (from ?action=query&prop=info&intoken=edit)',
			'delete' => 'Whether this post is a delete request',
			'comment_id' => 'The id of the relevant thread',
			'bullet_id' => 'For modifying existing bullets. Don\'t set if posting new bullet.',
			'response' => 'Set to true if the post is posting a response',
			'response_id' => 'For modifying existing response. Don\'t set if posting new response.',
			'text' => 'The text relevant to the action',
			'user' => 'The user who took the action. We actually ignore this and use $wgUser instead.',
			'highlights' => 'For posting a bullet. An array of element ids corresponding to the highlighted elements of the comment',
			'signal' => 'For responses. ID of response to question about whether the commenter thinks the bullet is accurate',
			'comments' => 'For initial GET request. List of ids of all the threads on the current page',
			'bullet_rev' => 'The revision of the bullet to take action on.',
			'response_rev' => 'The revision of the response to take action on.',
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'action' ),
		) );
	}

	public function getExamples() {
		return array();
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getAllowedParams() {
		return array(
			'reflectaction' => array(
				ApiBase::PARAM_TYPE => array_keys( $this->getActions() ),
			),
			'token' => null,
			'delete' => null,
			'comment_id' => null,
			'bullet_id' => null,
			'response' => null,
			'response_id' => null,
			'text' => null,
			'user' => null,
			'highlights' => array(),
			'signal' => null,
			'comments' => null,
			'bullet_rev' => null,
			'response_rev' => null,
		);
	}

	public function mustBePosted() {
		return false;
	}

	public function isWriteMode() {
		return true;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiReflectAction.php 90288 2011-06-17 16:27:45Z reedy $';
	}
}
