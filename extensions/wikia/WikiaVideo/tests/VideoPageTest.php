<?php
require_once dirname(__FILE__) . '/../VideoPage.php';

class WikiaVideoTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider ratioProvider
	 */
	public function testGetRatio($providerId, $expectedWidth, $expectedHeight, $mData=null) {
		$expectedRatio = $expectedWidth / $expectedHeight;
		$videoPage = new VideoPage(new Title());
		$videoPage->loadFromPars($providerId, null, $mData);
		$this->assertEquals($expectedRatio, $videoPage->getRatio());
	}

	/**
	 * @dataProvider ratioProvider
	 */
	public function testGetTextRatio($providerId, $expectedWidth, $expectedHeight, $mData=null) {
		$expectedRatio = $expectedWidth . ' x ' . $expectedHeight;
		$videoPage = new VideoPage(new Title());
		$videoPage->loadFromPars($providerId, null, $mData);
		$this->assertEquals($expectedRatio, $videoPage->getTextRatio());
	}

	public function ratioProvider() {
		return array(
			array(VideoPage::V_METACAFE, 400, 350),
			array(VideoPage::V_YOUTUBE, 640, 385),
			array(VideoPage::V_SEVENLOAD, 500, 408),
			array(VideoPage::V_GAMEVIDEOS, 500, 319),
			array(VideoPage::V_5MIN, 480, 401),
			array(VideoPage::V_VIMEO, 400, 225),
			array(VideoPage::V_MYVIDEO, 470, 406),
            array(VideoPage::V_SOUTHPARKSTUDIOS, 480, 400),
			array(VideoPage::V_BLIPTV, 480, 350),
			array(VideoPage::V_DAILYMOTION, 420, 339),
			array(VideoPage::V_VIDDLER, 437, 288),
			array(VideoPage::V_GAMETRAILERS, 480, 392),
			array(VideoPage::V_HULU, 512, 296),
			array(VideoPage::V_SCREENPLAY, 480, 360, array(VideoPage::SCREENPLAY_STANDARD_43_BITRATE_ID)),
			array(VideoPage::V_SCREENPLAY, 480, 270, array(VideoPage::SCREENPLAY_STANDARD_BITRATE_ID)),
			array(VideoPage::V_MOVIECLIPS, 560, 304)
		);
	}

	/**
	 * @dataProvider videoExistsDataProvider
	 * @group Integration
	 */
	public function testCheckIfVideoExists($providerId, $videoId, $exists) {
		$videoPage = new VideoPage(new Title());
		$videoPage->loadFromPars($providerId, $videoId, null);
		$this->assertEquals($exists, $videoPage->checkIfVideoExists());
	}

	public function videoExistsDataProvider() {
		return array(
			array(VideoPage::V_YOUTUBE, '3bb1TZ-lLzo', true),
			array(VideoPage::V_YOUTUBE, 'O42jD2QeAO8', false), // video removed
			array(VideoPage::V_YOUTUBE, 'O42jD2O8', false) // invalid id
		);
	}
}
