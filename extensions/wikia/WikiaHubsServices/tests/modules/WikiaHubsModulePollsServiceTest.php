<?php
class WikiaHubsModulePollsServiceTest extends WikiaBaseTest
{
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
		$pollsModule = new WikiaHubsModulePollsService( 123456 );
		$renderedData = $pollsModule->getWikitext($pollsData);
		$this->assertEquals($expectedData,$renderedData,'wikitext');
	}

	/**
	 * @dataProvider getDataStructureDataProvider
	 */
	public function testGetStructureData($flatArray, $expectedData) {

		$pollsModuleMock = $this->getMock(
			'WikiaHubsModulePollsService',
			array('getHubUrl'),
			array('en', 1, 2)
		);

		$pollsModuleMock
			->expects($this->any())
			->method('getHubUrl')
			->will($this->returnValue('http://www.wikia.com/Video_Games'));

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
}
