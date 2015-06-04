<?php

namespace Email\Controller;

use \Email\EmailController;
use \Email;

class WeeklyDigestController extends EmailController {

	const LAYOUT_CSS = 'weeklyDigest.css';

	protected $digestData;

	protected function getSubject() {
		return wfMessage( 'emailext-weeklydigest-subject' )->escaped();
	}

	protected function getSummary() {
		return wfMessage( 'emailext-weeklydigest-summary' )->escaped();
	}

	public function initEmail() {
		$this->digestData = $this->request->getVal( 'digestData' );
	}

	/**
	 * @template weeklyDigest
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'digestData' => $this->digestData,
		] );
	}
}