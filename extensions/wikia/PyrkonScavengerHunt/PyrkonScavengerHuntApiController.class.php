<?php

class PyrkonScavengerHuntApiController extends WikiaApiController {
	protected $cors;

	const QUESTIONS = [
		[
			'text' => 'Who asked this question?',
			'url' => 'https://harrypotter.bkowalczyk.wikia-dev.pl',
			'wikiId' => '509',
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

	public function validateAnswer($index, $answer) {
		$this->setResponseData( ['validated' => true] );
	}
}
