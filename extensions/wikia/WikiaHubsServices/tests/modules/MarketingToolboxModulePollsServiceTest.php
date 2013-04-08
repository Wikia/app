<?php
class MarketingToolboxModulePollsServiceTest extends WikiaBaseTest
{
	private $visualizationData = array (
		'de' => array(
			'wikiId' => 111264,
			'wikiTitle' => 'Wikia Deutschland',
			'url' => 'http://de.wikia.com/',
			'db' => 'dehauptseite',
			'lang' => 'de'
		),
		'fr' => array(
			'wikiId' => 208826,
			'wikiTitle' => 'Wikia',
			'url' => 'http://fr.wikia.com/',
			'db' => 'fraccueil',
			'lang' => 'fr'
		),
		'es' => array(
			'wikiId' => 583437,
			'wikiTitle' => 'Wiki Esglobal',
			'url' => 'http://es.wikia.com/',
			'db' => 'esesglobal',
			'lang' => 'es'
		),
		'en' => array(
			'wikiId' => 80433,
			'wikiTitle' => 'Wikia',
			'url' => 'http://www.wikia.com/',
			'db' => 'wikiaglobal',
			'lang' => 'en'
		),
	);

	private $hubsV2Pages = array(
		'en' => array (
			2 => 'Video_Games',
			3 => 'Entertainment',
			9 => 'Lifestyle',
		),
		'de' => array (
			2 => 'Videospiele',
			3 => 'Entertainment',
		),
		'fr' => array (
			2 => 'Mode_de_vie',
			3 => 'Jeux_vidéo',
			9 => 'Divertissement',
		),
		'es' => array (
			2 => 'Videojuegos',
			3 => 'Entretenimiento',
			9 => 'Lista_de_Wikis',
		),
	);

	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getPollsDataProvider
	 */
	public function testGetWikitext($pollsData, $expectedData) {
		$pollsModule = new MarketingToolboxModulePollsService('en',1,1);
		$renderedData = $pollsModule->getWikitext($pollsData);
		$this->assertEquals($expectedData,$renderedData,'wikitext');
	}

	/**
	 * @dataProvider getDataStructureDataProvider
	 */
	public function testGetStructureData($flatArray, $expectedData) {
		$pollsModuleMock = $this->getMock(
			'MarketingToolboxModulePollsService',
			array('getHubUrl'),
			array('en', 1, 2)
		);

		$pollsModuleMock
			->expects($this->any())
			->method('getHubUrl')
			->will($this->returnValue('http://www.wikia.com/Video_Games'));

		$this->mockApp();

		$structuredData = $pollsModuleMock->getStructuredData($flatArray);

		$this->assertEquals($expectedData, $structuredData);
	}

	public function getPollsDataProvider() {
		return array(
			array(
				array(
					'pollsQuestion' => 'Question',
					'pollsOptions' => array(
						'option 1',
						'option 2',
						'option 3',
						'option 4'
					)
				),
				"<poll>\nQuestion\noption 1\noption 2\noption 3\noption 4\n</poll>"
			),
			array(
				array(
					'pollsQuestion' => 'Poll Question 22',
					'pollsOptions' => array(
						'optional value',
						'value',
						'option',
						'option last'
					)
				),
				"<poll>\nPoll Question 22\noptional value\nvalue\noption\noption last\n</poll>"
			)
		);
	}

	public function getDataStructureDataProvider() {
		return array(
			array(
				array(
					'pollsTitle' => 'Post Title',
					'pollsQuestion' => 'Question',
					'pollsOption1' => 'option 1',
					'pollsOption2' => 'option 2',
					'pollsOption3' => 'option 3',
					'pollsOption4' => 'option 4'
				),
				array(
					'headline' => 'Post Title',
					'pollsQuestion' => 'Question',
					'hubUrl' => 'http://www.wikia.com/Video_Games',
					'pollsOptions' => array(
						'option 1',
						'option 2',
						'option 3',
						'option 4'
					)
				)
			),
			array(
				array(
					'pollsTitle' => 'Post Title Example',
					'pollsQuestion' => 'Question Test',
					'pollsOption1' => 'optional value',
					'pollsOption2' => 'value',
					'pollsOption3' => 'option',
					'pollsOption4' => 'option last'
				),
				array(
					'headline' => 'Post Title Example',
					'pollsQuestion' => 'Question Test',
					'hubUrl' => 'http://www.wikia.com/Video_Games',
					'pollsOptions' => array(
						'optional value',
						'value',
						'option',
						'option last'
					)
				)
			),
			array(
				array(
					'pollsTitle' => 'Post Title Example',
					'pollsQuestion' => 'Question Test',
					'pollsOption1' => 'option 1',
					'pollsOption2' => 'option 2',
					'pollsOption5' => 'option 5',
					'pollsOption8' => 'option 8',
					'pollsOption10' => 'option 10'
				),
				array(
					'headline' => 'Post Title Example',
					'pollsQuestion' => 'Question Test',
					'hubUrl' => 'http://www.wikia.com/Video_Games',
					'pollsOptions' => array(
						'option 1',
						'option 2',
						'option 5',
						'option 8',
						'option 10'
					)
				)
			),
			array(
				array(
					'pollsTitle' => '',
					'pollsQuestion' => 'Question Test',
					'pollsOption1' => 'optional value',
					'pollsOption2' => 'value',
					'pollsOption3' => 'option',
					'pollsOption4' => 'option last'
				),
				array()
			)
		);
	}

	/**
	 * @dataProvider getHubUrlDataProvider
	 */
	public function testGetHubUrl($expectedUrl, $langCode, $verticalId, $wikiaHubsV2Pages) {
		$pollsModuleMock = $this->getMock(
			'MarketingToolboxModulePollsService',
			array('getVisualizationData'),
			array($langCode, 1, $verticalId)
		);

		$pollsModuleMock
			->expects($this->once())
			->method('getVisualizationData')
			->will($this->returnValue($this->visualizationData));

		$this->mockGlobalVariable('wgWikiaHubsV2Pages', $wikiaHubsV2Pages);
		$this->mockApp();

		$this->assertEquals($expectedUrl, $pollsModuleMock->getHubUrl());
	}

	public function getHubUrlDataProvider() {
		return array(
			array('http://www.wikia.com/Video_Games', 'en', 2, $this->hubsV2Pages['en']),
			array('http://www.wikia.com/Entertainment', 'en', 3, $this->hubsV2Pages['en']),
			array('http://www.wikia.com/Lifestyle', 'en', 9, $this->hubsV2Pages['en']),

			array('http://de.wikia.com/Videospiele', 'de', 2, $this->hubsV2Pages['de']),
			array('http://de.wikia.com/Entertainment', 'de', 3, $this->hubsV2Pages['de']),

			array('http://fr.wikia.com/Mode_de_vie', 'fr', 2, $this->hubsV2Pages['fr']),
			array('http://fr.wikia.com/Jeux_vidéo', 'fr', 3, $this->hubsV2Pages['fr']),
			array('http://fr.wikia.com/Divertissement', 'fr', 9, $this->hubsV2Pages['fr']),

			array('http://es.wikia.com/Videojuegos', 'es', 2, $this->hubsV2Pages['es']),
			array('http://es.wikia.com/Entretenimiento', 'es', 3, $this->hubsV2Pages['es']),
			array('http://es.wikia.com/Lista_de_Wikis', 'es', 9, $this->hubsV2Pages['es']),
		);
	}

	public function testGetHubUrlForWrongLang() {
		$pollsModuleMock = $this->getMock(
			'MarketingToolboxModulePollsService',
			array('getVisualizationData'),
			array('xxx', 1, 9)
		);

		$pollsModuleMock
			->expects($this->once())
			->method('getVisualizationData')
			->will($this->returnValue($this->visualizationData));

		$this->setExpectedException('Exception');
		$pollsModuleMock->getHubUrl();
	}

	public function testGetHubUrlForWrongVertical() {
		$pollsModuleMock = $this->getMock(
			'MarketingToolboxModulePollsService',
			array('getVisualizationData'),
			array('en', 1, 666)
		);

		$pollsModuleMock
			->expects($this->once())
			->method('getVisualizationData')
			->will($this->returnValue($this->visualizationData));

		$this->mockGlobalVariable('wgWikiaHubsV2Pages', $this->hubsV2Pages['en']);
		$this->mockApp();

		$this->setExpectedException('Exception');
		$pollsModuleMock->getHubUrl();
	}
}
