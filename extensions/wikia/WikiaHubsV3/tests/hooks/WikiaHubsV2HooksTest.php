<?php
class WikiaHubsV2HooksTest extends WikiaBaseTest
{
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		include_once __DIR__ . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR
			. 'hooks' . DIRECTORY_SEPARATOR
			. 'WikiaHubsV2Hooks.php';
		//$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsV2.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getTimestampFromSplitDbKeyDataProvider
	 */
	public function testGetTimestampFromSplitDbKey($urlDbKey, $expectedTimestamp) {

		$class = new ReflectionClass('WikiaHubsV2Hooks');
		$method = $class->getMethod('getTimestampFromSplitDbKey');
		$method->setAccessible(true);

		$hook = new WikiaHubsV2Hooks();
		$timestamp = $method->invoke($hook, explode('/', $urlDbKey));

		$this->assertEquals($expectedTimestamp, $timestamp);
	}

	public function getTimestampFromSplitDbKeyDataProvider() {
		return array(
			array('Video_Games/05-11-2012', 1352073600),
			array('Video_Games/01-01-2013', 1356998400),
			array('Video_Games/18.12.2013', 1387324800),
			array('Video_Games/2013-02-03', 1359849600),
			array('Video_Games/2013/07/01', 1372636800),
			array('Entertainment/2013/07/01', 1372636800),
			array('Video_Games/2013/13/01', false),
			array('Video_Games/07-13-2012', false),
			array('Video_Games/13-05-1969', -20131200),
		);
	}
}