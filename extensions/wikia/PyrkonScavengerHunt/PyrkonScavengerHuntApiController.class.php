<?php

class PyrkonScavengerHuntApiController extends WikiaApiController {
	protected $cors;

	protected $questions = [
		[
			'text' => 'Who asked this question?',
			'url' => 'https://harrypotter.fandom.com',
			'answers' => [
				'Bart',
				'Bartłomiej Kowalczyk',
			],
		],
		[
			'text' => 'Who asked this other question?',
			'url' => 'https://starwars.fandom.com',
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

	public function getQuestion($index = 0) {
		$this->setResponseData( $questions[$index] );
	}

	public function validateAnswer($index, $answer) {
		$question = $questions[$index];

		if ( !empty( $question ) && array_search( $normalizedAnswer, $question['answers'] ) > -1 ) {
			$data = [
				'next-url' => $questions[$index + 1]['url']
			];
		} else {
			$this->setResponseData( ['is-correct' => false] );
		}
	}
}
