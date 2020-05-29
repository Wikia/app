<?php

use Wikia\Rabbit\ConnectionBase;

class CoppaToolController extends WikiaController {

	public function disableUserAccount() {
		if ( !$this->checkRequest() ) {
			return;
		}

		$user = $this->request->getVal( 'user' );

		if ( empty( $user ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			return;
		}

		$userObj = User::newFromName( $user );

		if ( !( $userObj instanceof User ) || $userObj->getId() === 0 ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			return;
		}

		$errorMessage = null;
		$errorMessage2 = null;
		$res = EditAccount::closeAccount( $userObj, wfMessage( 'coppatool-reason' )->plain(), $errorMessage, $errorMessage2, /*$keepEmail = */false );
		if ( $res === false ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', $errorMessage );
			return;
		} else {
			$this->response->setVal( 'success', true );
			if ( !is_null( $errorMessage2 ) ) {
				$this->response->setVal( 'errorMsg', $errorMessage2 );
			}
		}

		try {
			$this->removeEmailChangeLog( $userObj );
			$this->removeFounderEmail( $userObj );
		} catch(Exception $ex) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg',$ex->getMessage() );
			return;
		}
	}

	public function resetUserProfile() {
		if ( !$this->checkRequest() ) {
			return;
		}
		$user = $this->request->getVal( 'user' );
		if ( empty( $user ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			return;
		}

		$userObj = User::newFromName( $user );

		if ( !( $userObj instanceof User ) || $userObj->getId() === 0 ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			return;
		}
		$userIdentityBox = new UserIdentityBox( $userObj );

		$userIdentityBox->resetUserProfile();

		$this->response->setVal( 'success', true );
	}

	public function deleteUserPages() {
		if ( !$this->checkRequest() ) {
			return;
		}
		$user = $this->request->getVal( 'user' );
		if ( empty( $user ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
			return;
		}

		$userObj = User::newFromName( $user );

		if ( !( $userObj instanceof User ) || $userObj->getId() === 0 ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-user' )->plain() );
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
	}

	public function renameIPAddress() {
		if ( !$this->checkRequest() ) {
			return;
		}

		$ipAddr = $this->request->getVal( 'user' );

		if ( !IP::isIPAddress( $ipAddr ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'errorMsg', wfMessage( 'coppatool-invalid-ip' )->plain() );
			return;
		}

		$ipAddr = IP::sanitizeIP( $ipAddr );

		$wikiIDs = RenameIPHelper::lookupIPActivity( $ipAddr );

		$taskParams = [
			'requestor_id' => $this->wg->User->getID(),
			'requestor_name' => $this->wg->User->getName(),
			'rename_user_id' => 0,
			'old_ip' => $ipAddr,
			'new_ip' => NON_ROUTABLE_IPV6,
			'reason' => wfMessage( 'coppatool-reason' )->plain(),
		];
		$task = ( new RenameIPTask() )
			->setQueue( \Wikia\Tasks\Queues\PriorityQueue::NAME );
		$task->call('renameIP', $wikiIDs, $taskParams);
		$taskID = $task->queue();

		// Notify any interested services via Rabbit message
		$publisher = new ConnectionBase( [
			'vhost' => '/',
			'exchange' => 'amq.topic',
		] );
		$publisher->publish( 'coppa-anonymize', [ 'targetAddress' => $ipAddr ] );

		$this->response->setVal( 'success', true );
		$this->response->setVal( 'resultMsg', wfMessage( 'coppatool-rename-ip-success', $taskID )->plain() );
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

	/**
	 * Removes entries for a given user from "Log of email changes"
	 *
	 * @see https://community.wikia.com/wiki/Special:EditAccount/log
	 * @see CORE-86
	 *
	 * @param User $user
	 * @throws Exception
	 */
	private function removeEmailChangeLog( User $user) {
		global $wgExternalSharedDB;
		$dbMaster = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		$dbMaster->delete( 'user_email_log', [ 'user_id' => $user->getId() ], __METHOD__ );
		$dbMaster->commit( __METHOD__ );
	}

	private function removeFounderEmail( User $user ) {
		global $wgExternalSharedDB;
		$dbMaster = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		$dbMaster->update(
			'city_list',
			[
				'city_founding_email' => null,
				'city_founding_ip_bin' => null,
			],
			[
				'city_founding_user' => $user->getId(),
			],
			__METHOD__
		);
		$dbMaster->commit( __METHOD__ );
	}
}
