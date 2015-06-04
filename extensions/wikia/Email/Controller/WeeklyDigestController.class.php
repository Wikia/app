<?php

namespace Email\Controller;

use \Email\EmailController;

class WeeklyDigestController extends EmailController {

	const LAYOUT_CSS = 'weeklyDigest.css';

	protected $digestData;

	protected function getSubject() {
		return "foo";
	}

	protected function getSummary() {
		return "Since you're last visist, Wikia Community members have made improvements to pages that you follow.";
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
			'digestData' => $this->getDigestData(),
			'hasContentFooterMessages' => true,
			'contentFooterMessages' => [
				'Thanks for your participation on Wikia!',
				'- Wikia Community Support'
			]
		] );
	}

	private function getDigestData() {
		$foo = new \GlobalWatchlistBot();
		return $foo->sendDigestToUser( 5654073 );
	}
}