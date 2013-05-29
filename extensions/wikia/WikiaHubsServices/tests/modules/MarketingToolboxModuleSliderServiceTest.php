<?php
class MarketingToolboxModuleSliderServiceTest extends WikiaBaseTest
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
	 * @dataProvider getSliderDataProvider
	 */
	public function testGetWikitext($structuredData, $expectedText) {

		$contLangMock = $this->getMock('stdClass', array('getNsText'));

		$contLangMock->expects($this->any())
			->method('getNsText')
			->will($this->returnValue('File'));

		$this->mockGlobalVariable('wgContLang', $contLangMock);

		$sliderModule = new MarketingToolboxModuleSliderService('en',1,1);
		$renderedText = $sliderModule->getWikitext($structuredData);


		$this->assertEquals($expectedText, $renderedText);
	}


	public function getSliderDataProvider() {
		$data1 = array(
			'slides' => array(
				array(
					'photoName' => 'photoName1',
					'shortDesc' => 's desc 1',
					'longDesc' => 'l desc 1',
					'url' => 'url 1',
					'strapline' => 'alt 1'
				),
				array(
					'photoName' => 'photoName2',
					'shortDesc' => 's desc 2',
					'longDesc' => 'l desc 2',
					'url' => 'url 2',
					'strapline' => 'alt 2'
				),
				array(
					'photoName' => 'photoName3',
					'shortDesc' => 's desc 3',
					'longDesc' => 'l desc 3',
					'url' => 'url 3',
					'strapline' => 'alt 3'
				),
				array(
					'photoName' => 'photoName4',
					'shortDesc' => 's desc 4',
					'longDesc' => 'l desc 4',
					'url' => 'url 4',
					'strapline' => 'alt 4'
				),
				array(
					'photoName' => 'photoName5',
					'shortDesc' => 's desc 5',
					'longDesc' => 'l desc 5',
					'url' => 'url 5',
					'strapline' => 'alt 5'
				),
			));
		$expectedText1 = <<<WIKI_TEXT
<gallery type="slider" orientation="mosaic">
File:photoName1|'''alt 1'''|link=url 1|linktext=l desc 1|shorttext=s desc 1
File:photoName2|'''alt 2'''|link=url 2|linktext=l desc 2|shorttext=s desc 2
File:photoName3|'''alt 3'''|link=url 3|linktext=l desc 3|shorttext=s desc 3
File:photoName4|'''alt 4'''|link=url 4|linktext=l desc 4|shorttext=s desc 4
File:photoName5|'''alt 5'''|link=url 5|linktext=l desc 5|shorttext=s desc 5
</gallery>
WIKI_TEXT;


		$data2 = array(
			'slides' => array(
				array(
					'photoName' => 'other_photo_name1',
					'shortDesc' => 'short desc 1',
					'longDesc' => 'ultra very long description here 1, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris',
					'url' => 'http://url.com/1',
					'strapline' => 'alt text 1a'
				),
				array(
					'photoName' => 'other_photo_name2',
					'shortDesc' => 'short desc 2',
					'longDesc' => 'ultra very long description here 2, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris',
					'url' => 'http://url.com/2',
					'strapline' => 'alt text 2a'
				),
				array(
					'photoName' => 'other_photo_name3',
					'shortDesc' => 'short desc 3',
					'longDesc' => 'ultra very long description here 3, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris',
					'url' => 'http://url.com/3',
					'strapline' => 'alt text 3a'
				),
				array(
					'photoName' => 'other_photo_name4',
					'shortDesc' => 'short desc 4',
					'longDesc' => 'ultra very long description here 4, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris',
					'url' => 'http://url.com/4',
					'strapline' => 'alt text 4a'
				),
				array(
					'photoName' => 'other_photo_name5',
					'shortDesc' => 'short desc 5',
					'longDesc' => 'ultra very long description here 5, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris',
					'url' => 'http://url.com/5',
					'strapline' => 'alt text 5a'
				),
			));
		$expectedText2 = <<<WIKI_TEXT
<gallery type="slider" orientation="mosaic">
File:other_photo_name1|'''alt text 1a'''|link=http://url.com/1|linktext=ultra very long description here 1, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris|shorttext=short desc 1
File:other_photo_name2|'''alt text 2a'''|link=http://url.com/2|linktext=ultra very long description here 2, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris|shorttext=short desc 2
File:other_photo_name3|'''alt text 3a'''|link=http://url.com/3|linktext=ultra very long description here 3, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris|shorttext=short desc 3
File:other_photo_name4|'''alt text 4a'''|link=http://url.com/4|linktext=ultra very long description here 4, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris|shorttext=short desc 4
File:other_photo_name5|'''alt text 5a'''|link=http://url.com/5|linktext=ultra very long description here 5, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris|shorttext=short desc 5
</gallery>
WIKI_TEXT;

		return array(
			array($data1, $expectedText1),
			array($data2, $expectedText2),
		);
	}


	/**
	 * @dataProvider getDataStructureDataProvider
	 */
	public function testGetStructuredDate($flatArray, $expectedData) {

		$sliderMock = $this->getMock(
				'MarketingToolboxModuleSliderService',
				array( 'getImageData' ),
				array('en', 1, 1)
		);

		$map = [];
		if (!empty($flatArray)) {
			for ($i = 1; $i <= 5; $i++) {
				$map[] = array(
					$flatArray['photo' . $i],
					(object) array('url' => $expectedData['slides'][$i - 1]['photoUrl'])
				);
			}
		}

		$sliderMock
			->expects($this->any())
			->method( 'getImageData' )
			->will($this->returnValueMap($map));

		$structuredData = $sliderMock->getStructuredData($flatArray);

		$this->assertEquals($expectedData, $structuredData);
	}

	public function getDataStructureDataProvider() {
		return array(
			array (
				array(
					'photo1' => 'LegoMiniFigures hero 010513.jpg',
					'strapline1' => 'strapline lego 1',
					'shortDesc1' => 'lego',
					'longDesc1' => 'lego heroes',
					'url1' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'photo2' => 'Wikia-Visualization-Main,legogalaxygameat.png',
					'strapline2' => 'strapline lego 2',
					'shortDesc2' => 'lego2',
					'longDesc2' => 'lego galaxy',
					'url2' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'photo3' => 'Wikia-Visualization-Main,swindontownfootballclub.png',
					'strapline3' => 'strapline swindon 3',
					'shortDesc3' => 'swindon',
					'longDesc3' => 'swindon town FC',
					'url3' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'photo4' => 'TheMuppets hero 100512.jpg',
					'strapline4' => 'strapline muppets 4',
					'shortDesc4' => 'muppets',
					'longDesc4' => 'muppets hero',
					'url4' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
					'photo5' => 'Wikia-Visualization-Main,dragonballupdates.png',
					'strapline5' => 'strapline dragon 5',
					'shortDesc5' => 'dragon',
					'longDesc5' => 'dragon balls',
					'url5' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics'
				),
				array(
					'slides' => array (
						array(
							'photoUrl' => 'http://test.image.path/image.png',
							'shortDesc' => 'lego',
							'longDesc' => 'lego heroes',
							'url' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
							'photoName' => 'LegoMiniFigures hero 010513.jpg',
							'strapline' => 'strapline lego 1'
						),
						array(
							'photoUrl' => 'http://test.image.path/image2.png',
							'shortDesc' => 'lego2',
							'longDesc' => 'lego galaxy',
							'url' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
							'photoName' => 'Wikia-Visualization-Main,legogalaxygameat.png',
							'strapline' => 'strapline lego 2'
						),
						array(
							'photoUrl' => 'http://test.image.path/image3.png',
							'shortDesc' => 'swindon',
							'longDesc' => 'swindon town FC',
							'url' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
							'photoName' => 'Wikia-Visualization-Main,swindontownfootballclub.png',
							'strapline' => 'strapline swindon 3'
						),
						array(
							'photoUrl' => 'http://test.image.path/image4.png',
							'shortDesc' => 'muppets',
							'longDesc' => 'muppets hero',
							'url' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
							'photoName' => 'TheMuppets hero 100512.jpg',
							'strapline' => 'strapline muppets 4'
						),
						array(
							'photoUrl' => 'http://test.image.path/image5.png',
							'shortDesc' => 'dragon',
							'longDesc' => 'dragon balls',
							'url' => 'http://www.wikia.com/Video_Games%2FVideo_Game_Olympics',
							'photoName' => 'Wikia-Visualization-Main,dragonballupdates.png',
							'strapline' => 'strapline dragon 5'
						),
					)
				)
			),
			array(
				array(),
				array()
			)
		);
	}
}
