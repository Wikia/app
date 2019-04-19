<?php

class PyrkonScavengerHuntApiController extends WikiaApiController {
	protected $cors;

	const QUESTIONS = [
		[
			'text' => 'Which Muppets character is known for his catchphrase "Wocka wocka wocka!"?',
			'wikiId' => '831',
			'answers' => [
				'fozzie',
				'fozzie bear'
			],
		],
		[
			'text' => 'What’s the name of The Red Witch from Games of Thrones?',
			'wikiId' => '130814',
			'answers' => [
				'melisandre',
			],
		],
		[
			'text' => 'Name one sorceresses able to polymorph from Witcher.',
			'wikiId' => '3443',
			'answers' => [
				'philippa eilhart',
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
