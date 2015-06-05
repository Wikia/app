<?php

namespace Email\Controller;

use \Email\EmailController;

class WeeklyDigestController extends EmailController {

	const LAYOUT_CSS = 'weeklyDigest.css';

	protected $digestData;

	protected function getSubject() {
		return $this->getMessage( 'emailext-weeklydigest-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-weeklydigest-summary' )->text();
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
