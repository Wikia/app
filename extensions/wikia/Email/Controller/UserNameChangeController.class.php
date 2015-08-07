<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Check;

class UserNameChangeController extends EmailController {

	const LAYOUT_CSS = 'userNameLayout.css';

	protected $oldUserName;
	protected $newUserName;

	public function initEmail() {
		$this->oldUserName = $this->request->getVal( 'oldUserName' );
		$this->newUserName = $this->request->getVal( 'newUserName' );

		$this->assertValidParams();
	}

	/**
	 * Validate the parameters passed in to the request
	 *
	 * @throws Check
	 */
	private function assertValidParams() {
		if ( empty( $this->oldUserName ) ) {
			throw new Check( "Missing parameter `oldUserName` is required" );
		}
		if ( empty( $this->oldUserName ) ) {
			throw new Check( "Missing parameter `newUserName` is required" );
		}
	}

	/**
	 * @template userNameLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'summary' => $this->getMessage( 'emailext-usernamechange-summary' )->text(),
			'userNameMessage' => $this->getMessage( 'emailext-usernamechange-changed',
				$this->oldUserName, $this->newUserName )->text(),
			'contentFooterMessages' => [
				$this->getMessage( 'emailext-usernamechange-closing' )->text(),
				$this->getMessage( 'emailext-usernamechange-signature' )->text()
			],
			'hasContentFooterMessages' => true
		] );
	}

	protected function getSubject() {
		return $this->getMessage( 'emailext-usernamechange-subject' )->text();
	}

	protected static function getEmailSpecificFormFields() {
		$form = [
			'inputs' => [
				[
					'type' => 'text',
					'name' => 'oldUserName',
					'label' => "Old username",
					'tooltip' => "User's old name"
				],
				[
					'type' => 'text',
					'name' => 'newUserName',
					'label' => "New username",
					'tooltip' => "User's new name"
				],
			]
		];

		return $form;
	}
}
