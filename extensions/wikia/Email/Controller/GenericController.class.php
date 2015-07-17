<?php

namespace Email\Controller;

use Email\Check;
use Email\EmailController;

class GenericController extends EmailController {
	/** @var  \MailAddress */
	protected $toAddress;

	protected $subject;
	protected $salutation;
	protected $body;
	protected $category;

	public function initEmail() {
		$toString = $this->request->getVal( 'toAddress', '' );
		if ( !empty( $toString ) ) {
			$this->toAddress = new \MailAddress( $toString );
		}

		// Default to the stock email salutation
		$this->salutation = $this->request->getVal( 'salutation', $this->getSalutation() );
		$this->category = $this->request->getVal( 'category', self::getControllerShortName() );

		$this->subject = $this->request->getVal( 'subject' );
		$this->body = $this->request->getVal( 'body' );

		$this->assertValidParams();
	}

	protected function assertValidParams() {
		if ( empty( $this->subject ) ) {
			throw new Check( "Required parameter 'subject' not given." );
		}

		if ( empty( $this->body ) ) {
			throw new Check( "Required parameter 'body' not given." );
		}

		if ( empty( $this->salutation ) ) {
			throw new Check( "Salutation can not be empty." );
		}

		if ( empty( $this->category ) ) {
			throw new Check( "Category can not be empty." );
		}
	}

	public function getSendGridCategory() {
		return $this->category;
	}

	protected function getToAddress() {
		return empty( $this->toAddress ) ? parent::getToAddress() : $this->toAddress;
	}

	/**
	 * Make sure we use the address passed to us in the footers, etc.
	 *
	 * @return string
	 */
	protected function getTargetUserEmail() {
		return $this->getToAddress()->address;
	}

	/**
	 * @template genericLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->salutation,
			'body' => $this->body,
		] );
	}

	public function getSubject() {
		return $this->subject;
	}

	protected static function getEmailSpecificFormFields() {
		$formFields =  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'toAddress',
					'label' => 'Recipient Address',
					'tooltip' => 'The email address to send this content',
					'value' => \F::app()->wg->User->getEmail(),
				],
				[
					'type' => 'text',
					'name' => 'category',
					'label' => 'SendGrid Category',
					'tooltip' => 'Used to categorize the email sent',
					'value' => self::getControllerShortName(),
				],
				[
					'type' => 'text',
					'name' => 'subject',
					'label' => 'Email Subject',
					'tooltip' => 'Subject to use for email the email'
				],
				[
					'type' => 'text',
					'name' => 'salutation',
					'label' => 'Salutation',
					'tooltip' => 'How to address the user, e.g. "Hello,"'
				],
				[
					'type' => 'text',
					'name' => 'body',
					'label' => 'Body',
					'tooltip' => 'The body text of the email'
				],
			]
		];

		return $formFields;
	}
}
