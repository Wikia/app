<?php
class MarketingToolboxModulePollsServiceTest extends WikiaBaseTest
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
	public function testRenderPolls($pollsData, $expectedData) {
		$mtmps = new MarketingToolboxModulePollsService('en',1,1);
		$renderedData = $mtmps->renderPolls($pollsData);
		$this->assertEquals($expectedData,$renderedData,'wikitext equal');
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
}
