<?php

class PyrkonScavengerHuntApiController extends WikiaApiController {
	protected $cors;

	const QUESTIONS = [
		[
			'text' => 'What\s the last name of Krzysztof D?',
			'wikiId' => '1575417',
			'answers' => [
				'Derek',
			],
		],
		[
			'text' => 'On what planet did Yoda train Luke?',
			'wikiId' => '147',
			'answers' => [
				'Dagobah',
			],
		],
	];

	public function __construct() {
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->allowWhitelistedOrigins();
		$this->cors->setAllowCredentials( true );
	}

	public function getQuestion() {
		global $wgCityId;

		$index = $this->getRequest()->getVal( 'index', 0 );
		$question = self::QUESTIONS[$index];
		$url = WikiFactory::cityIDtoUrl( $question['wikiId'] );
		$response = [
			'text' => $question['text'],
			'url' => $url
		];

		if ( $wgCityId === $question['wikiId']) {
			$this->setResponseData( $question );
		}
	}

	public function getQuestionUrl() {
		$index = $this->getRequest()->getVal( 'index', 0 );

		if ($index >= sizeof(self::QUESTIONS)) {
			$this->setResponseData( ['is-over' => true] );
		} else {
			$this->setResponseData( [
				'url' => WikiFactory::cityIDtoUrl(
					self::QUESTIONS[$index]['wikiId']
				)]
			);
		}
	}

	public function validateAnswer() {
		$index = $this->getRequest()->getVal( 'index', 0 );
		$answer = $this->getRequest()->getVal( 'answer', 0 );
		$question = self::QUESTIONS[$index];
		$normalizedAnswer = htmlspecialchars($answer);

		if (array_search($normalizedAnswer, $question['answers']) > -1) {
			$this->setResponseData( ['is-valid' => true] );
		} else {
			$this->setResponseData( ['is-valid' => false] );
		}
	}
}
