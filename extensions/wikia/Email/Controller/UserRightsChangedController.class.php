<?php

namespace Email\Controller;

use Email\Check;
use \Email\EmailController;

class UserRightsChangedController extends EmailController {

	private $details;

	public function initEmail() {
		$this->details = $this->getVal( 'summary' );
		$this->assertValidParams();
	}

	private function assertValidParams() {
		if ( empty( $this->details ) ) {
			throw new Check( "'summary' parameter must not be empty" );
		}
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getMessage( "emailext-user-rights-changed-subject" )->parse(),
			'details' => $this->details,
			'editorProfilePage' => $this->getCurrentProfilePage(),
			'editorUserName' => $this->getCurrentUserName(),
			'editorAvatarURL' => $this->getCurrentAvatarURL(),
			'buttonText' => $this->getMessage( 'emailext-user-rights-changed-button-text' )->text(),
			'buttonLink' => $this->getButtonLink()
		] );
	}

	protected function getSubject() {
		return $this->getMessage( "emailext-user-rights-changed-subject" )->parse();
	}


	private function getButtonLink() {
		$urlParams = [
			"type" => "rights",
			"page" => $this->targetUser->getName()
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
			]
		];
	}
}