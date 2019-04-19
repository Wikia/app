<?php

class PyrkonScavengerHuntApiController extends WikiaApiController {
	protected $cors;

	const QUESTIONS = [
		[
			'text' => 'Who asked this question?',
			'url' => 'https://xkxd02.bkowalczyk.fandom-dev.pl',
			'wikiId' => '1575417',
			'answers' => [
				'Bart',
				'Bartłomiej Kowalczyk',
			],
		],
		[
			'text' => 'Who asked this other question?',
			'url' => 'https://starwars.bkowalczyk.fandom-dev.pl',
			'wikiId' => '147',
			'answers' => [
				'Yoda',
				'Yoda Yodowski',
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

		if ( $wgCityId === $question['wikiId']) {
			$this->setResponseData( $question );
		}
	}

	public function getQuestionUrl() {
		$index = $this->getRequest()->getVal( 'index', 0 );

		if ($index >= sizeof(self::QUESTIONS)) {
			$this->setResponseData( ['is-over' => true] );
		} else {
			$this->setResponseData( ['url' => self::QUESTIONS[$index]['url']] );
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
