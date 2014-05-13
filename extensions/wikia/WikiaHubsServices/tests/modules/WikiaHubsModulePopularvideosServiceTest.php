<?php

class WikiaHubsPopularvideosServiceTest extends WikiaBaseTest
{

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getDataStructureDataProvider
	 */
	public function testGetDataStructureDataProvider($inputData, $videoData, $thumbSize, $expectedData) {
		$popularVideosMock = $this->getMock( 'WikiaHubsModulePopularvideosService', array( 'getToolboxModel', 'getModuleModel'), array('en',1,1) );
		$toolboxModelMock = $this->getMock( 'EditHubModel', array( 'getVideoData' ) );
		$popularVideoModelMock = $this->getMock( 'WikiaHubsPopularvideosModel', array( 'getVideoThumbSize' ) );

		$map = [];
		if(!empty($inputData['video'])) {
			foreach($inputData['video'] as $k => $video) {
				$map[] = array( $video, $thumbSize, $videoData[$k] );
			}
		}

		$popularVideoModelMock
			->expects( $this->any() )
			->method( 'getVideoThumbSize')
			->will( $this->returnValue($thumbSize) );

		$toolboxModelMock
			->expects( $this->any() )
			->method( 'getVideoData' )
			->will( $this->returnValueMap($map) );

		$popularVideosMock
			->expects( $this->any() )
			->method( 'getToolboxModel' )
			->will( $this->returnValue( $toolboxModelMock ) );

		$popularVideosMock
			->expects( $this->any() )
			->method( 'getModuleModel' )
			->will( $this->returnValue( $popularVideoModelMock ) );


		$structuredData = $popularVideosMock->getStructuredData($inputData);

		$this->assertEquals($expectedData, $structuredData);
	}

	public function getDataStructureDataProvider() {
		return array(
			array(
				array(
					'header' => 'bond',
					'videoUrl' => array(
						'https://www.youtube.com/watch?v=Ii1tc493bZM',
						'http://muppet.patrick.wikia-dev.com/wiki/File:Skyfall_Video_Interviews'
					),
					'video' => array(
						'James Bond 007 Movie Theme Music',
						'Skyfall Video Interviews'
					)
				),
				array(
					array(
						'title' => 'James Bond 007 Movie Theme Music',
						'fileUrl' => 'http://wikiaglobal.wikia-dev.com/wiki/File:James_Bond_007_Movie_Theme_Music',
						'duration' => '104',
						'thumbUrl' => 'http://images.lukaszk.wikia-dev.com/wikiaglobal/images/thumb/8/89/James_Bond_007_Movie_Theme_Music/160px-James_Bond_007_Movie_Theme_Music.jpg',
						'videoThumb' => '<a href="/wiki/File:James_Bond_007_Movie_Theme_Music"><img src="http://wikiaglobal.wikia-dev.com/wiki/File:James_Bond_007_Movie_Theme_Music" /></a>',
						'videoTimestamp' => '20130227114454',
						'videoTime' => '10 minute ago'
					),
					array(
						'title' => 'Skyfall Video Interviews',
						'fileUrl' => 'http://wikiaglobal.wikia-dev.com/wiki/File:Skyfall_Video_Interviews',
						'duration' => 324,
						'thumbUrl' => 'http://images.lukaszk.wikia-dev.com/__cb20121025002453/video151/images/thumb/c/c4/Skyfall_Video_Interviews/160px-Skyfall_Video_Interviews.jpg',
						'videoThumb' => '<a href="/wiki/File:Skyfall_Video_Interviews"><img src="http://wikiaglobal.wikia-dev.com/wiki/File:Skyfall_Video_Interviews" /></a>',
						'videoTimestamp' => '20121025002451',
						'videoTime' => 'October 25, 2012'
					)
				),
				160,
				array(
					'header' => 'bond',
					'videos' => array(
						array(
							'title' => 'James Bond 007 Movie Theme Music',
							'fileUrl' => 'http://wikiaglobal.wikia-dev.com/wiki/File:James_Bond_007_Movie_Theme_Music',
							'duration' => '104',
							'thumbUrl' => 'http://images.lukaszk.wikia-dev.com/wikiaglobal/images/thumb/8/89/James_Bond_007_Movie_Theme_Music/160px-James_Bond_007_Movie_Theme_Music.jpg',
							'thumbMarkup' => '<a href="/wiki/File:James_Bond_007_Movie_Theme_Music"><img src="http://wikiaglobal.wikia-dev.com/wiki/File:James_Bond_007_Movie_Theme_Music" /></a>',
							'wikiUrl' => 'https://www.youtube.com/watch?v=Ii1tc493bZM'
						),
						array(
							'title' => 'Skyfall Video Interviews',
							'fileUrl' => 'http://wikiaglobal.wikia-dev.com/wiki/File:Skyfall_Video_Interviews',
							'duration' => 324,
							'thumbUrl' => 'http://images.lukaszk.wikia-dev.com/__cb20121025002453/video151/images/thumb/c/c4/Skyfall_Video_Interviews/160px-Skyfall_Video_Interviews.jpg',
							'thumbMarkup' => '<a href="/wiki/File:Skyfall_Video_Interviews"><img src="http://wikiaglobal.wikia-dev.com/wiki/File:Skyfall_Video_Interviews" /></a>',
							'wikiUrl' => 'http://muppet.patrick.wikia-dev.com/wiki/File:Skyfall_Video_Interviews'
						)
					)
				)
			)
		);
	}
}
