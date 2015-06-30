<?php

namespace Email\Controller;

use \Email\EmailController;
use Email\Tracking\TrackingCategories;

class UserRightsChangedController extends EmailController {

	const LAYOUT_CSS = 'weeklyDigest.css';

	const TRACKING_CATEGORY = TrackingCategories::WEEKLY_DIGEST;

	protected $summary;

	protected function getSubject() {
		return $this->getMessage( 'emailext-weeklydigest-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-weeklydigest-summary' )->text();
	}

	public function initEmail() {
		$this->summary = $this->getVal( 'summary' );
	}

	/**
	 * @template avatarLayout
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'digestData' => $this->digestData,
		] );
	}

	public static function getEmailSpecificFormFields() {
		return  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'digestData',
					'label' => 'Digest Data',
					'tooltip' => 'The Weekly Digest data is tricky to represent in a form. A default value has been provided. You can submit as is.',
				],
			]
		];
	}
}
