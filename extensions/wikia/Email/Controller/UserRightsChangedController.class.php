<?php

namespace Email\Controller;

use Email\Check;
use \Email\EmailController;

class UserRightsChangedController extends EmailController {

	private $details;
	private $changedUser;

	public function initEmail() {
		$this->details = $this->getVal( 'summary' );
		$this->changedUser = $this->getVal( 'pageTitle' );
		$this->assertValidParams();
	}

	private function assertValidParams() {
		if ( empty( $this->changedUser ) ) {
			throw new Check( "'pageTitle' parameter must not be empty" );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSubject(),
			'details' => $this->getDetails(),
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'buttonText' => $this->getMessage( 'emailext-user-rights-changed-button-text' )->text(),
			'buttonLink' => $this->getButtonLink()
		] );
	}

	protected function getSubject() {
		if ( $this->isTargetUserChangedUser() ) {
			return $this->getMessage( 'emailext-user-rights-changed-subject' )->text();
		}
		return $this->getMessage( 'emailext-user-rights-changed-subject-follower', $this->changedUser )->text();
	}

	private function getDetails() {
		if ( empty( $this->details ) ) {
			return $this->getMessage( 'emailext-watchedpage-no-summary' )->text();
		}
		return $this->details;
	}

	/**
	 * Return if the target user (the person receiving the email) is the same user
	 * who had their rights changed.
	 *
	 * @return bool
	 */
	private function isTargetUserChangedUser() {
		return $this->targetUser->getName() == $this->changedUser;
	}

	private function getButtonLink() {
		$urlParams = [
			"type" => "rights",
			"page" => $this->changedUser
		];
		return \SpecialPage::getTitleFor( 'Log' )->getFullURL( $urlParams );
	}

	public static function getEmailSpecificFormFields() {
		return  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'summary',
					'value' => "Added user to the bureaucrat group",
					'label' => 'Summary of Changes',
					'tooltip' => "Summary of the changes to the user's rights, eg, 'Added user to bureaucrat group'",
				],
				[
					'type' => 'text',
					'name' => 'pageTitle',
					'value' => \F::app()->wg->User->getName(),
					'label' => 'User whose rights were changed',
					'tooltip' => 'User whose rights were changed',
				],
			]
		];
	}
}