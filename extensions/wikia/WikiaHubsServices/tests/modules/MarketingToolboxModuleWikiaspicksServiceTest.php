<?php
class MarketingToolboxModuleWikiasPicksServiceTest extends WikiaBaseTest
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
	 * @dataProvider getStructuredDataProvider
	 */
	public function testGetStructuredData($data, $expectedData) {

		$moduleMock = $this->getMock(
			'MarketingToolboxModuleWikiaspicksService',
			array('getImageInfo'),
			array('en', 1, 1)
		);

		$atIndex = 0;

		if (!empty($data['sponsoredImage'])) {
			$mockReturnVal = new stdClass();
			$mockReturnVal->url = $expectedData['sponsoredImageUrl'];
			$mockReturnVal->title = $expectedData['sponsoredImageAlt'];

			$moduleMock->expects($this->at($atIndex++))
				->method('getImageInfo')
				->with($this->equalTo($data['sponsoredImage']))
				->will($this->returnValue($mockReturnVal));
		}

		if (!empty($data['fileName'])) {
			$mockReturnVal = new stdClass();
			$mockReturnVal->url = $expectedData['imageUrl'];
			$mockReturnVal->title = $expectedData['imageAlt'];

			$moduleMock->expects($this->at($atIndex++))
				->method('getImageInfo')
				->with($this->equalTo($data['fileName']))
				->will($this->returnValue($mockReturnVal));
		}

		$renderedData = $moduleMock->getStructuredData($data);
		$this->assertEquals($expectedData, $renderedData);
	}

	public function getStructuredDataProvider() {
		return array(
			array(
				array(
					'moduleTitle' => 'fake title',
					'text' => 'fake text'
				),
				array(
					'title' => 'fake title',
					'text' => 'fake text',
					'imageUrl' => null,
					'imageAlt' => null,
					'imageLink' => null,
					'sponsoredImageUrl' => null,
					'sponsoredImageAlt' => null,
					'photoName' => null
				)
			),
			array(
				array(
					'moduleTitle' => 'fake title',
					'text' => 'fake text',
					'fileName' => 'FakeFileName.png',
					'imageLink' => 'http://www.wikia.com',
				),
				array(
					'title' => 'fake title',
					'text' => 'fake text',
					'imageUrl' => 'http://example.com/FakeFileName.png',
					'imageAlt' => 'FakeFileNameAlt.png',
					'imageLink' => 'http://www.wikia.com',
					'sponsoredImageUrl' => null,
					'sponsoredImageAlt' => null,
					'photoName' => 'FakeFileName.png'
				)
			),
			array(
				array(
					'moduleTitle' => 'fake title',
					'text' => 'fake text',
					'sponsoredImage' => 'OtherFakeFileName.png'
				),
				array(
					'title' => 'fake title',
					'text' => 'fake text',
					'imageUrl' => null,
					'imageAlt'  => null,
					'imageLink' => null,
					'sponsoredImageUrl' => 'http://example.com/OtherFakeFileName.png',
					'sponsoredImageAlt' => 'OtherFakeFileNameAlt.png',
					'photoName' => null
				)
			),
			array(
				array(
					'moduleTitle' => 'fake title',
					'text' => 'fake text',
					'sponsoredImage' => 'OtherFakeFileName.png',
					'fileName' => 'FakeFileName.png',
					'imageLink' => 'http://www.wikia.com',
				),
				array(
					'title' => 'fake title',
					'text' => 'fake text',
					'imageUrl' => 'http://example.com/FakeFileName.png',
					'imageAlt' => 'FakeFileNameAlt.png',
					'imageLink' => 'http://www.wikia.com',
					'sponsoredImageUrl' => 'http://example.com/OtherFakeFileName.png',
					'sponsoredImageAlt' => 'OtherFakeFileNameAlt.png',
					'photoName' => 'FakeFileName.png'
				)
			),
		);
	}
}
