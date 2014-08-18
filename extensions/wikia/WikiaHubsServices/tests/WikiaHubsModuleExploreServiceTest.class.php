<?php
include( realpath( dirname(__FILE__) . '/../WikiaHubsServices.setup.php' ) );

class WikiaHubsModuleExploreServiceTest extends PHPUnit_Framework_TestCase {
	const DEFAULT_LANG = 'en';
	const DEFAULT_SECTION = 1;
	const DEFAULT_VERTICAL = 2;
	
	protected $mockedLinksGroup = array('links', 'links', 'links');

	/**
	 * @dataProvider testGetStructuredDataDataProvider
	 */
	public function testGetStructuredData($data, $expected) {
		$mtbExploreServiceMock = $this->getMock('WikiaHubsModuleExploreService', array('getLinkGroupsFromApiResponse'), array(self::DEFAULT_LANG, self::DEFAULT_SECTION, self::DEFAULT_VERTICAL), '', false);
		$mtbExploreServiceMock->expects($this->any())
			->method('getLinkGroupsFromApiResponse')
			->will($this->returnValue($this->mockedLinksGroup));
		
		$result = $mtbExploreServiceMock->getStructuredData($data);
		$this->assertEquals($expected, $result);
	}
	
	public function testGetStructuredDataDataProvider() {
		return array(
			//no data returned from db to become structured
			array(
				'data' => array(),
				'expected' => array(),
			),
			//bogus data returned from db to become structured
			array(
				'data' => array(
					'exploreTitle' => '',
					'fileName' => 'TestFile.jpg',
					'exploreSectionHeader1' => 'Test header 1',
					'exploreLinkText1a' => 'Test link 1a',
					'exploreLinkUrl1a' => 'http://www.wikia.com',
				),
				'expected' => array(),
			),
			//valid data returned from db to become structured
			array(
				'data' => array(
					'exploreTitle' => 'Test module title',
					'fileName' => 'TestFile.jpg',
					'exploreSectionHeader1' => 'Test header 1',
					'exploreLinkText1a' => 'Test link 1a',
					'exploreLinkUrl1a' => 'http://www.wikia.com',
				),
				'expected' => array(
					'headline' => 'Test module title',
					'imagelink' => 'TestFile.jpg',
					'linkgroups' => $this->mockedLinksGroup,
				),
			),
		);
	}
	
}
