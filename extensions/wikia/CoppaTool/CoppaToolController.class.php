<?php

class CoppaToolController extends WikiaController {

	public function disableUserAccount() {
		wfProfileIn( __METHOD__ );
		if ( !$this->checkRequest() ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$user = $this->request->getVal( 'user' );

		if ( empty( $user ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			wfProfileOut( __METHOD__ );
			return;
		}

		$userObj = User::newFromName( $user );

		if ( !( $userObj instanceof User ) || $userObj->getId() === 0 ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			wfProfileOut( __METHOD__ );
			return;
		}

		$errorMessage = null;
		$errorMessage2 = null;
		$res = EditAccount::closeAccount( $userObj, wfMessage( 'coppatool-reason' )->plain(), $errorMessage, $errorMessage2, /*$keepEmail = */false );
		if ( $res === false ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', $errorMessage );
		} else {
			$this->response->setVal( 'success', true );
			if ( !is_null( $errorMessage2 ) ) {
				$this->response->setVal( 'errorMsg', $errorMessage2 );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function resetUserProfile() {
		wfProfileIn( __METHOD__ );
		if ( !$this->checkRequest() ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		$user = $this->request->getVal( 'user' );
		if ( empty( $user ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			wfProfileOut( __METHOD__ );
			return;
		}

		$userObj = User::newFromName( $user );

		if ( !( $userObj instanceof User ) || $userObj->getId() === 0 ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			wfProfileOut( __METHOD__ );
			return;
		}
		$userIdentityBox = new UserIdentityBox( $userObj );

		$userIdentityBox->resetUserProfile();

		$this->response->setVal( 'success', true );

		wfProfileOut( __METHOD__ );
	}

	public function deleteUserPages() {
		wfProfileIn( __METHOD__ );
		if ( !$this->checkRequest() ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		$user = $this->request->getVal( 'user' );
		if ( empty( $user ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			wfProfileOut( __METHOD__ );
			return;
		}

		$userObj = User::newFromName( $user );

		if ( !( $userObj instanceof User ) || $userObj->getId() === 0 ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			wfProfileOut( __METHOD__ );
			return;
		}

		$taskParams = [
			'mode' => 'you',
			'page' => 'User:' . $userObj->getName(),
			'wikis' => '',
			'range' => 'all',
			'reason' => wfMessage( 'coppatool-delete-user-pages-reason' )->plain(),
			'lang' => '',
			'cat' => 0,
			'selwikia' => 0,
			'edittoken' => $this->wg->User->getEditToken(),
			'user' => $this->wg->User->getName(),
			'admin' => $this->wg->User->getName(),
			'suppress' => true,
		];

		$task = new \Wikia\Tasks\Tasks\MultiTask();
		$task->call('delete', $taskParams);
		$batchDeleteTaskId = $task->queue();

		$this->response->setVal( 'success', true );
		$this->response->setVal( 'resultMsg', wfMessage( 'coppatool-delete-user-pages-success', $batchDeleteTaskId )->plain() );

		wfProfileOut( __METHOD__ );
	}

	public function renameIPAddress() {
		wfProfileIn( __METHOD__ );
		if ( !$this->checkRequest() ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$ipAddr = $this->request->getVal( 'user' );

		if ( !IP::isIPAddress( $ipAddr ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-ip' )->plain() );
			wfProfileOut( __METHOD__ );
			return;
		}

		$ipAddr = IP::sanitizeIP( $ipAddr );
		$newIpAddr = '0.0.0.0';

		$wikiIDs = UserRenameToolHelper::lookupIPActivity( $ipAddr );

		$taskParams = [
			'requestor_id' => $this->wg->User->getID(),
			'requestor_name' => $this->wg->User->getName(),
			'rename_user_id' => 0,
			'rename_old_name' => $ipAddr,
			'rename_new_name' => $newIpAddr,
			'rename_ip' => true,
			'notify_renamed' => false,
			'reason' => wfMessage( 'coppatool-reason' )->plain(),
		];
		$task = ( new UserRenameToolTask() )
			->setPriority( \Wikia\Tasks\Queues\PriorityQueue::NAME );
		$task->call('renameUser', $wikiIDs, $taskParams);
		$taskID = $task->queue();

		$this->response->setVal( 'success', true );
		$this->response->setVal( 'resultMsg', wfMessage( 'coppatool-rename-ip-success', $taskID )->plain() );

		wfProfileOut( __METHOD__ );
	}

	private function checkRequest() {
		if ( !$this->wg->User->isAllowed( 'coppatool' ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-permissionerror' )->plain() );
			return false;
		}
		if ( !$this->request->wasPosted() ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-posterror' )->plain() );
			return false;
		}
		$token = $this->getVal( 'token', null );
		if ( $token === null || !$this->wg->User->matchEditToken( $token ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-tokenerror' )->plain() );
			return false;
		}
		return true;
	}
}
