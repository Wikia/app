<?php

class PyrkonScavengerHuntApiController extends WikiaApiController {
	protected $cors;

	const QUESTIONS = [
		[
			'text' => 'What\'s the name of The Red Witch from the Game of Thrones?',
			'wikiId' => '130814',
			'answers' => [
				'melisandre',
			],
		],
		[
			'text' => 'Name one sorceresses able to polymorph from The Witcher.',
			'wikiId' => '3443',
			'answers' => [
				'philippa eilhart',
				'the crones',
				'crones',
				'brewes',
				'weavess',
				'whispess',
				'melitele',
			],
		],
		[
			'text' => 'What\'s the John A. Zoidberg\'s profession?',
			'wikiId' => '534',
			'answers' => [
				'doctor',
				'heptagonist',
			],
		],
		[
			'text' => 'What is Dr. Stephen Strange\'s medical specialization?',
			'wikiId' => '177996',
			'answers' => [
				'neurosurgeon',
				'neurosurgery',
				'surgeon',
				'surgery',
			],
		],
		[
			'text' => 'What is Zeffliffl?',
			'wikiId' => '147',
			'answers' => [
				'species',
				'aliens',
				'alien',
				'specie',
			],
		],
		[
			'text' => 'What is the middle name of Lisa Simpson?',
			'wikiId' => '673',
			'answers' => [
				'marie',
			],
		],
		[
			'text' => 'How many incarnations of doctors there were in Doctor Who?',
			'wikiId' => '125',
			'answers' => [
				'13',
				'thirteen',
			],
		],
		[
			'text' => 'Which actress or actor does hunger games and game of thrones have in common?',
			'wikiId' => '35171',
			'answers' => [
				'natalie dormer',
                'natali dormer',
                'dormer',
                'dormer natalie',
			],
		],
		[
			'text' => 'Which publisher published the Battlestar Galactica comic series?',
			'wikiId' => '694',
			'answers' => [
				'marvel',
			],
		],
		[
			'text' => 'Dragon Ball: What is Goku\'s syan name?',
			'wikiId' => '530',
			'answers' => [
				'kakarot',
				'kakarotto',
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
