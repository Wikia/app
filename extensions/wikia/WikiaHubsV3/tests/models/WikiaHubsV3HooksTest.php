<?php
class WikiaHubsV3HooksTest extends WikiaBaseTest
{
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		include_once __DIR__ . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR
			. 'models' . DIRECTORY_SEPARATOR
			. 'WikiaHubsV3HooksModel.class.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getTimestampFromSplitDbKeyDataProvider
	 */
	public function testGetTimestampFromSplitDbKey($urlDbKey, $expectedTimestamp) {
		$hook = new WikiaHubsV3HooksModel();
		$timestamp = $hook->getTimestampFromSplitDbKey(explode('/', $urlDbKey));

		$this->assertEquals($expectedTimestamp, $timestamp);
	}

	public function getTimestampFromSplitDbKeyDataProvider() {
		return array(
			array('Video_Games/05-11-2012', 1352073600),
			array('Video_Games/05_11_2012', 1352073600),
			array('Video_Games/01-01-2013', 1356998400),
			array('Video_Games/18.12.2013', 1387324800),
			array('Video_Games/2013-02-03', 1359849600),
			array('Video_Games/2013_02_03', 1359849600),
			array('Video_Games/2013/07/01', 1372636800),
			array('Entertainment/2013/07/01', 1372636800),
			array('Video_Games/2013/13/01', false),
			array('Video_Games/07-13-2012', false),
			array('Video_Games/13-05-1969', -20131200),
			array('Video_Games/01-January-2013', 1356998400),
			array('Video_Games/01-Jan-2013', 1356998400),
			array('Video_Games/01_Jan_2013', 1356998400),
			array('Video_Games/01_January_2013', 1356998400),
		);
	}
}
