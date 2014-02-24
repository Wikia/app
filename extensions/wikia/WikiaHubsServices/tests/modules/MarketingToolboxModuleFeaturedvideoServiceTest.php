<?php

class MarketingToolboxModuleFeaturedvideoServiceTest extends WikiaBaseTest {
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
			'MarketingToolboxModuleFeaturedvideoService',
			array('getImageInfo', 'getToolboxModel'),
			array('en', 1, 1)
		);

		$toolboxModelMock = $this->getMock('MarketingToolboxModel', array('getVideoData'));
		$toolboxModelMock->expects($this->once())
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
			->method('getToolboxModel')
			->will($this->returnValue($toolboxModelMock));

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
			'videoThumb' => '<a href="/wiki/File:Rabbids_Land_To_Catch_A_Thief_Gameplay" class="video-thumbnail lightbox video" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject"><div class="timer" itemprop="duration">01:41</div><div class="Wikia-video-play-button" style="line-height:168px;width:300px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" /></div><img alt="" src="http://images.damian.wikia-dev.com/__cb20130225120022/wikiaglobal/images/thumb/7/73/Rabbids_Land_To_Catch_A_Thief_Gameplay/300px-Rabbids_Land_To_Catch_A_Thief_Gameplay.jpg" width="300" height="168" data-video="Rabbids Land To Catch A Thief Gameplay" itemprop="thumbnail" class="Wikia-video-thumb" /><span class="info-overlay" style="width: 300px;"><span class="info-overlay-title" style="max-width:240px;" itemprop="name">Rabbids Land To Catch A Thief Gameplay</span><meta itemprop="duration" content="PT01M41S"><span class="info-overlay-duration" itemprop="duration">(01:41)</span><br /><span class="info-overlay-views">0 views</span><meta itemprop="interactionCount" content="UserPlays:0" /></span></a>',
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
