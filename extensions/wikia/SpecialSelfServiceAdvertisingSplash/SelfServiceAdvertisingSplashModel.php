<?php

class SelfServiceAdvertisingSplashModel extends WikiaObject {
	const WIKIFACTORY_EMAIL_VARIABLE_NAME = 'wgSelfServiceAdvertisingSplash_DestinationEmail';
	const DEFAULT_SUBJECT = 'New Coupon Request from Self-Service Ads';

	protected $dstEmailAddresses;
	protected $srcEmail;
	protected $emailSubject;
	protected $emailBody;
	protected $successfulSends;
	protected $failedSends;
	protected $userName;
	protected $userCompany;
	protected $userTelephone;
	protected $validationMessages;
	protected $sendResultMessage;

	public function __construct() {
		parent::__construct('SelfServiceAdvertisingSplashModel');
		$this->assignEmailAddressesFromWikiFactory();
		$this->setSubject(self::DEFAULT_SUBJECT);
	}

	public function assignEmailAddressesFromWikiFactory() {
		wfProfileIn(__METHOD__);
		$emails = WikiFactory::getVarValueByName(self::WIKIFACTORY_EMAIL_VARIABLE_NAME, $this->wg->cityId);
		if (is_array($emails)) {
			$this->setDstEmails($emails);
		}
		wfProfileOut(__METHOD__);
	}

	public function sendEmails() {
		if (!is_array($this->getDstEmails())) {
			return false;
		}

		$this->successfulSends = 0;
		$this->failedSends = 0;

		wfProfileIn(__METHOD__);
		$dstEmails = $this->getDstEmails();

		foreach ($dstEmails as $email) {
			$this->sendEmail($email);
		}
		Wikia::log(__METHOD__, ' succesful sends: ' . $this->successfulSends . ' ');
		Wikia::log(__METHOD__, ' failed sends: ' . $this->failedSends . ' ');

		wfProfileOut(__METHOD__);
		if($this->wereEmailsSentSuccessfully()) {
			$this->sendResultMessage = wfMsg('ssa-splash-message-sent');
			return true;
		} else {
			$this->sendResultMessage = wfMsg('ssa-splash-message-not-sent-please-try-again');
			return false;
		}
	}

	protected function wereEmailsSentSuccessfully() {
		return $this->failedSends == 0 && $this->successfulSends > 0;
	}

	protected function sendEmail($email) {
		if ($this->executeSendingFunction($email)) {
			$this->successfulSends++;
		} else {
			$this->failedSends++;
		}
	}

	/**
	 * @param $email MailAddress
	 * @return bool
	 */
	protected function executeSendingFunction($email) {
		wfProfileIn(__METHOD__);
		if ($this->validateData()) {
			$error = UserMailer::send($email, $this->srcEmail, $this->emailSubject, $this->emailBody);
		} else {
			$error = true;
		}
		wfProfileOut(__METHOD__);
		if (!empty($error)) {
			return false;
		} else {
			return true;
		}
	}

	public function generateEmailBody() {
		$bodyElements = array();
		$bodyElements []= 'Name:      ' . $this->userName;
		$bodyElements []= 'Email:     ' . $this->srcEmail;
		if(!empty($this->userCompany)) {
			$bodyElements []= 'Company:   ' . $this->userCompany;
		}
		if(!empty($this->userTelephone)) {
			$bodyElements []= 'Phone No.: ' . $this->userTelephone;
		}

		$this->setEmailBody(implode("\n",$bodyElements));
	}

	public function validateData() {
		$valid = true;
		$this->validationMessages = array();

		if(!$this->validateEmailAddress()) {
			$valid = false;
			$this->validationMessages ['email'] = wfMsg('ssa-splash-please-enter-your-email-address');
		}

		if (empty($this->userName)) {
			$valid = false;
			$this->validationMessages ['name'] = wfMsg('ssa-splash-please-enter-your-name');
		}

		return $valid;
	}

	public function validateEmailAddress() {
		$valid = true;
		if ($this->srcEmail instanceof MailAddress) {
			if (!User::isValidEmailAddr($this->srcEmail->toString())) {
				$valid = false;
			}
		} else {
			$valid = false;
		}
		return $valid;
	}

	public function getFormData() {
		$formData = array (
			'inputs' => array (
				array(
					'type' => 'text',
					'name' => 'name',
					'attributes' => array(
						'placeholder' => wfMsg('ssa-splash-rightbox-name'),
					),
				),
				array(
					'type' => 'text',
					'name' => 'email',
					'attributes' => array(
						'placeholder' => wfMsg('ssa-splash-rightbox-email'),
					),
				),
				array(
					'type' => 'text',
					'name' => 'company',
					'attributes' => array(
						'placeholder' => wfMsg('ssa-splash-rightbox-company'),
					),
				),
				array(
					'type' => 'text',
					'name' => 'telephone',
					'attributes' => array(
						'placeholder' => wfMsg('ssa-splash-rightbox-phone'),
					),
				),
			),
			'submits' => array(
				array(
					'value' => wfMsg('ssa-splash-rightbox-getcoupon'),
					'class' => 'big get-coupon'
				)
			),
		);
		return $formData;
	}

	/**
	 * getters and setters
	 */
	public function setSubject($subject) {
		$this->emailSubject = $subject;
	}

	public function setDstEmails($emails) {
		if (is_array($emails)) {
			$this->dstEmailAddresses = array();
			foreach ($emails as $email) {
				$this->dstEmailAddresses [] = new MailAddress($email);
			}
			return true;
		} else {
			return false;
		}

	}

	public function setSrcEmail($email) {
		$this->srcEmail = new MailAddress($email);
	}

	public function setEmailBody($body) {
		$this->emailBody = $body;
	}

	public function setUserName($userName) {
		$this->userName = $userName;
	}

	public function setUserCompany($userCompany) {
		$this->userCompany = $userCompany;
	}

	public function setUserPhone($userTelephone) {
		$this->userTelephone = $userTelephone;
	}

	public function getSubject() {
		return $this->emailSubject;
	}

	public function getDstEmails() {
		return $this->dstEmailAddresses;
	}

	public function getSrcEmail() {
		return $this->srcEmail;
	}

	public function getEmailBody() {
		return $this->emailBody;
	}

	public function getUserName() {
		return $this->userName;
	}

	public function getUserCompany() {
		return $this->userCompany;
	}

	public function getUserPhone() {
		return $this->userTelephone;
	}

	public function getValidationMessages() {
		return $this->validationMessages;
	}

	public function getSendResultMessage() {
		return $this->sendResultMessage ;
	}
}
