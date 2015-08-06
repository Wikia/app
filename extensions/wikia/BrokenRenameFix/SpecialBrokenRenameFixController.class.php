<?php

class SpecialBrokenRenameFixController extends WikiaSpecialPageController {

	const BRF_FORM_SUBMIT = 'submit';

	private
		$notices = [],
		$userId,
		$oldName,
		$newName;

	function __construct() {
		parent::__construct( 'BrokenRenameFix', 'renameuser', true );
	}

	public function index() {
		Wikia::addAssetsToOutput( 'special_broken_rename_fix' );

		$this->wg->Out->setPageTitle( wfMessage( 'brf-title' )->escaped() );

		$this->setMessages();
		$this->setFormData();

		if ( $this->getPar() === self::BRF_FORM_SUBMIT ) {
			$this->submit();
		}

		if ( !empty( $this->notices ) ) {
			$this->formNotices = implode( "\n", $this->notices );
		}
	}

	private function submit() {
		if ( $this->validateForm() ) {
			/**
			 * Prevent sending the data again on refresh.
			 */
			unset( $_POST );


			$task = new BrokenRenameFixTask();
			$task->call( 'rerunRenameScript', $this->userId, $this->oldName, $this->newName );
			$task->prioritize();
			$task->queue();

			$this->addNotice( wfMessage( 'brf-success' )->escaped() . $this->getTasksLink(), 'success' );
		} else {
			$this->prefillFormValues();
		}
	}

	private function validateForm() {
		$status = true;

		$editToken = $this->request->getVal( 'brf-form-token' );
		if ( !$this->request->wasPosted() || !$this->wg->User->matchEditToken( $editToken ) ) {
			$this->addNotice( wfMessage( 'brf-error-invalid-request' )->escaped() );
			$status = false;
		}

		$this->userId = $this->request->getVal( 'brf-form-user-id' );
		$this->oldName = $this->request->getVal( 'brf-form-old-name' );
		$this->newName = $this->request->getVal( 'brf-form-new-name' );

		if ( empty( $this->userId ) || empty( $this->oldName ) || empty( $this->newName ) ) {
			$this->addNotice( wfMessage( 'brf-error-empty-fields' )->escaped() );
			$status = false;
		}

		$usernameFromId = User::newFromId( $this->userId )->getName();
		if ( $usernameFromId !== $this->oldName && $usernameFromId !== $this->newName ) {
			$this->addNotice( wfMessage( 'brf-error-invalid-user' )->escaped() );
			$status = false;
		}

		return $status;
	}

	private function prefillFormValues() {
		$this->userIdValue = $this->userId;
		$this->oldNameValue = $this->oldName;
		$this->newNameValue = $this->newName;
	}

	private function setFormData() {
		$this->editToken = $this->wg->User->getEditToken();
		$this->actionUrl = $this->specialPage->getTitle()->getLocalURL( [
			self::PAR => self::BRF_FORM_SUBMIT
		] );
	}

	private function setMessages() {
		$this->description = wfMessage( 'brf-desc' )->escaped();
		$this->userIdLabel = wfMessage( 'brf-label-user-id' )->escaped();
		$this->oldNameLabel = wfMessage( 'brf-label-old-name' )->escaped();
		$this->newNameLabel = wfMessage( 'brf-label-new-name' )->escaped();
		$this->submitText = wfMessage( 'brf-label-submit' )->escaped();
	}

	private function addNotice( $text, $type = 'error' ) {
		$this->notices[] = Html::rawElement( 'p',
			[
				'class' => sprintf( 'brf-form-notice-%s', $type ),
			],
			$text
		);
	}

	private function getTasksLink() {
		$url = sprintf( '%s/tasks?limit=100&type=%s.%s',
			$this->wg->FlowerUrl, 'BrokenRenameFixTask', 'rerunRenameScript' );

		return Html::rawElement( 'a', [ 'href' => $url, 'target' => '_blank' ],
			wfMessage( 'brf-success-link-text' )->escaped() );
	}
}
