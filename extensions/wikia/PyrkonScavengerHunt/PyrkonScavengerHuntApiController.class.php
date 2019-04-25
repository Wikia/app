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
			'text' => 'What\'s the name of The Red Witch from the Game of Thrones?',
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
				'the crones',
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
			],
		],
		[
			'text' => 'What is Zeffliffl?',
			'wikiId' => '147',
			'answers' => [
				'species',
				'aliens',
				'alien',
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
			'text' => 'Theon Greyjoy was tortured and forced into servitude by Ramsay Snow. By what pet name did Ramsey call Theon?',
			'wikiId' => '130814',
			'answers' => [
				'reek',
			],
		],
		[
			'text' => 'Iron Man: J.A.R.V.I.S is an artificially intelligent system, tasked with running business for Stark Industries as well as security for Tony Stark\'s Mansion and Stark Tower. What is it named after?',
			'wikiId' => '130814',
			'answers' => [
				'edwin jarvis',
				'butler',
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
			],
		],
		[
			'text' => 'Which publisher published the Battlestar Galactica comics series?',
			'wikiId' => '694',
			'answers' => [
				'marvel',
			],
		],
		[
			'text' => 'God of War: Which snake like monster from Norse mythology appeared in God of War?',
			'wikiId' => '2935',
			'answers' => [
				'jörmungandr',
				'world serpent',
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
		[
			'text' => 'Who\'s bodyguard was Cassandra Cain trained to be?',
			'wikiId' => '3166',
			'answers' => [
				'ra\'s al ghul',
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
