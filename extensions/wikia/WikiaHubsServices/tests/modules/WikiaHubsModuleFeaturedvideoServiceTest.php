<?php

class WikiaHubsModuleFeaturedvideoServiceTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getStructuredDataDataProvider
	 */
	public function testGetStructuredData($inputData, $expectedData, $mockedVideoData) {
		$moduleMock = $this->getMock(
			'WikiaHubsModuleFeaturedvideoService',
			array('getImageInfo', 'getEditHubModel'),
			array('en', 1, 1)
		);

		$editHubModelMock = $this->getMock('EditHubModel', array('getVideoData'));
		$editHubModelMock->expects($this->once())
			->method('getVideoData')
			->with($this->equalTo($inputData['video']))
			->will($this->returnValue($mockedVideoData));

		$mockReturnVal = new stdClass();
		$mockReturnVal->url = $expectedData['sponsoredImageUrl'];
		$mockReturnVal->title = $expectedData['sponsoredImageAlt'];

		$moduleMock->expects($this->any())
			->method('getImageInfo')
			->with($this->equalTo($inputData['sponsoredImage']))
			->will($this->returnValue($mockReturnVal));

		$moduleMock->expects($this->once())
			->method('getEditHubModel')
			->will($this->returnValue($editHubModelMock));

		$structuredData = $moduleMock->getStructuredData($inputData);

		$this->assertEquals($expectedData, $structuredData);
	}

	public function getStructuredDataDataProvider() {
		$out = array();

		$inputData = array(
			'sponsoredImage' => '252 85x15.jpg',
			'video' => 'Rabbids Land To Catch A Thief Gameplay',
			'header' => 'Rabbids land',
			'articleUrl' => 'http://www.nandytest.wikia.com/wiki/Orders',
			'description' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
		);

		$mockedVideoData = array(
			'videoThumb' => '<a href="/wiki/File:Rabbids_Land_To_Catch_A_Thief_Gameplay" class="video video-thumbnail medium video image lightbox " itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><img src="http://images.liz.wikia-dev.com/__cb20121030065354/video151/images/thumb/7/73/Rabbids_Land_To_Catch_A_Thief_Gameplay/300px-Rabbids_Land_To_Catch_A_Thief_Gameplay.jpg" data-video-key="Rabbids_Land_To_Catch_A_Thief_Gameplay" data-video-name="Rabbids Land To Catch A Thief Gameplay" width="300" height="169" alt itemprop="thumbnail"><span class="duration" itemprop="duration">01:39</span><span class="play-circle"></span><meta itemprop="duration" content="PT01M39S"></a>',
			'videoTimestamp' => '20130225120020',
			'videoTime' => '2 days ago',
			'duration' => '101',
			'title' => 'Rabbids Land To Catch A Thief Gameplay',
			'fileUrl' => 'http://wikiaglobal.damian.wikia-dev.com/wiki/File:Rabbids_Land_To_Catch_A_Thief_Gameplay',
			'thumbUrl' => 'http://images.damian.wikia-dev.com/__cb20130225120022/wikiaglobal/images/thumb/7/73/Rabbids_Land_To_Catch_A_Thief_Gameplay/300px-Rabbids_Land_To_Catch_A_Thief_Gameplay.jpg'
		);

		$expectedData = array(
			'header' => 'Rabbids land',
			'description' => 'Just a simple description. Visit <a href="nandytest.wikia.com/">nAndy wiki</a> to order some food!',
			'articleUrl' => 'http://www.nandytest.wikia.com/wiki/Orders',
			'sponsoredImageUrl' => 'http://example.com/OtherFakeFileName.png',
			'sponsoredImageAlt' => 'OtherFakeFileNameAlt.png',
			'video' => array(
				'thumbMarkup' => $mockedVideoData['videoThumb'],
				'duration' => $mockedVideoData['duration'],
				'title' => $mockedVideoData['title'],
				'fileUrl' => $mockedVideoData['fileUrl'],
				'thumbUrl' => $mockedVideoData['thumbUrl']
			)
		);

		$out[] = array($inputData, $expectedData, $mockedVideoData);

		$inputData = array(
			'sponsoredImage' => null,
			'video' => 'video video',
			'header' => 'Header',
			'articleUrl' => 'http://example.wikia.com/TestUrl',
			'description' => '',
		);

		$mockedVideoData = array(
			'videoThumb' => 'thumb markup here',
			'videoTimestamp' => '20130225120666',
			'videoTime' => '666 days ago',
			'duration' => '666',
			'title' => 'video video title',
			'fileUrl' => 'http://example.wikia.com/wiki/testFileUrl',
			'thumbUrl' => 'http://example.wikia.com/wiki/testThumbUrl'
		);

		$expectedData = array(
			'header' => 'Header',
			'description' => '',
			'articleUrl' => 'http://example.wikia.com/TestUrl',
			'sponsoredImageUrl' => null,
			'sponsoredImageAlt' => null,
			'video' => array(
				'thumbMarkup' => $mockedVideoData['videoThumb'],
				'duration' => $mockedVideoData['duration'],
				'title' => $mockedVideoData['title'],
				'fileUrl' => $mockedVideoData['fileUrl'],
				'thumbUrl' => $mockedVideoData['thumbUrl']
			)
		);

		$out[] = array($inputData, $expectedData, $mockedVideoData);

		return $out;
	}
}
