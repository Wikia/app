<?php
/**
 * Controller class for QuickTools actions
 *
 * @author grunny
 */
class QuickToolsController extends WikiaController  {

	/**
	 * Method to generate QuickTools modal
	 */
	public function quickToolsModal() {
		$this->setVal( 'username', $this->request->getVal( 'username' ) );
		$this->setVal( 'blocklength', '2 weeks' );
		if ( in_array( 'bot', $this->wg->User->getGroups() ) ) {
			$this->setVal( 'botflag', 'remove' );
		} else {
			$this->setVal( 'botflag', 'add' );
		}
	}

	/**
	 * Block the target user account
	 *
	 * @return boolean
	 */
	public function blockUser() {
		if ( !$this->checkRequest() ) {
			return true;
		}

		$target = $this->request->getVal( 'target' );
		$blockLength = $this->request->getVal( 'length' );
		$summary = $this->request->getVal( 'summary' );

		$data = [
			'Target' => $target,
			'Reason' => [
				is_null( $summary ) ? '' : $summary,
				'other',
				is_null( $summary ) ? '' : $summary
			],
			'Expiry' => $blockLength,
			'HardBlock' => true,
			'CreateAccount' => true,
			'AutoBlock' => true,
			'DisableEmail' => true,
			'DisableUTEdit' => false,
			'AlreadyBlocked' => true,
			'Watch' => false,
			'Confirm' => true,
		];

		$retval = SpecialBlock::processForm( $data, $this->getContext() );

		if ( $retval !== true ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( $retval )->escaped() );
			return true;
		}

		$this->response->setVal( 'success', true );
		$this->response->setVal( 'message', wfMessage( 'quicktools-success-block', $target )->escaped() );

		return true;
	}

	/**
	 * Revert and/or delete all the target user's edits on a wiki
	 *
	 * @return boolean
	 */
	public function revertAll() {
		if ( !$this->checkRequest() ) {
			return true;
		}

		$target = $this->request->getVal( 'target' );
		$time = $this->request->getVal( 'time' );
		$summary = $this->request->getVal( 'summary' );
		$rollback = $this->request->getBool( 'dorollback' );
		$delete = $this->request->getBool( 'dodeletes' );
		$markBot = $this->request->getBool( 'markbot' );

		if ( !$time ) {
			$time = '';
		} else {
			$time = wfTimestamp( TS_UNIX, $time );
			if ( !$time ) {
				$this->response->setVal( 'success', false );
				$this->response->setVal( 'error', wfMessage( 'quicktools-invalidtime' )->plain() );
				return true;
			}

			$time = wfTimestamp( TS_MW, $time );
		}

		$helper = new QuickToolsHelper();

		$titles = $helper->getRollbackTitles( $target, $time );

		if ( empty( $titles ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( 'quicktools-notitles' )->plain() );
			return true;
		}

		foreach ( $titles as $title ) {
			$status = $helper->rollbackTitle( $title, $target, $time, $summary, $rollback, $delete, $markBot );
		}
		$this->response->setVal( 'success', true );
		// Messages that can be used here:
		// * quicktools-success
		// * quicktools-success-rollback
		// * quicktools-success-delete
		// * quicktools-success-rollback-delete
		$successMessage = 'quicktools-success' . ( $rollback ? '-rollback' : '' ) . ( $delete ? '-delete' : '' );
		$this->response->setVal( 'message', wfMessage( $successMessage, $target )->escaped() );

		return true;
	}

	/**
	 * Checks if the request was valid
	 *
	 * @return boolean
	 */
	private function checkRequest() {
		if ( !$this->wg->User->isAllowed( 'quicktools' ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( 'quicktools-permissionerror' )->plain() );
			return false;
		}
		if ( !$this->request->wasPosted() ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( 'quicktools-posterror' )->plain() );
			return false;
		}
		$token = $this->getVal( 'token', null );
		if ( $token === null || !$this->wg->User->matchEditToken( $token ) ) {
			$this->response->setVal( 'success', false );
			$this->response->setVal( 'error', wfMessage( 'quicktools-tokenerror' )->plain() );
			return false;
		}
		return true;
	}
}
