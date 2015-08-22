<?php

namespace Email\Controller;

use \Email\EmailController;
use Email\Tracking\TrackingCategories;

class WeeklyDigestController extends EmailController {

	const LAYOUT_CSS = 'weeklyDigest.css';

	const TRACKING_CATEGORY = TrackingCategories::WEEKLY_DIGEST;

	protected $digestData;

	protected function getSubject() {
		return $this->getMessage( 'emailext-weeklydigest-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-weeklydigest-summary' )->text();
	}

	public function initEmail() {
		$digestData = $this->request->getVal( 'digestData' );
		$this->digestData = $this->decodeDigestData( $digestData );
	}

	/**
	 * If the request to send the Weekly Digest is coming from Special:SendEmail,
	 * digestData will be a json string. Otherwise, it'll be an array. Make sure
	 * to json_decode digestData if it is a json string.
	 *
	 * @param $digestData
	 * @return mixed
	 */
	private function decodeDigestData( $digestData ) {
		if ( gettype( $digestData ) == 'string' ) {
			return json_decode( $digestData, $asArray = true );
		}

		return $digestData;
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

	public static function getEmailSpecificFormFields() {
		return  [
			"inputs" => [
				[
					'type' => 'text',
					'name' => 'digestData',
					'label' => 'Digest Data',
					'tooltip' => 'The Weekly Digest data is tricky to represent in a form. A default value has been provided. You can submit as is.',
					'value' => self::getDefaultDigestData()
				],
			]
		];
	}

	/**
	 * The Weekly Digest is tricky to provide form fields for since it takes a variable number
	 * of wikis and pages. Provide some default values for Special:SendEmail
	 *
	 * @return string
	 */
	public static function getDefaultDigestData() {
		$formField = [
			[
				'wikiaName' => 'Wikizilla',
				'pages' => [
					[
						'pageUrl' => 'http://godzilla.wikia.com/wiki/Gamora?s=dgdiff&diff=187022&oldid=prev',
						'pageName' => 'Gamora'
					],
					[
						'pageUrl' => 'http://godzilla.wikia.com/wiki/Yog?s=dgdiff&diff=141640&oldid=prev',
						'pageName' => 'Yog'
					],
				]
			],
			[
				'wikiaName' => 'The One Wiki to Rule Them All',
				'pages' => [
					[
						'pageUrl' => 'http://lotr.wikia.com/wiki/Gandalf?s=dgdiff&diff=171000&oldid=prev',
						'pageName' => 'Gandalf'
					],
					[
						'pageUrl' => 'http://lotr.wikia.com/wiki/Lungorthin?s=dgdiff&diff=171053&oldid=prev',
						'pageName' => 'Lungorthin'
					],
				]
			],
			[
				'wikiaName' => 'Puzzle & Dragons Wiki',
				'pages' => [
					[
						'pageUrl' => 'http://zh.pad.wikia.com/wiki/Template:Monster/CNNameByID?s=dgdiff&diff=477743&oldid=prev',
						'pageName' => 'Template:Monster/CNNameByID'
					]
				]
			],
		];

		return htmlentities( json_encode( $formField ), ENT_QUOTES );
	}
}
