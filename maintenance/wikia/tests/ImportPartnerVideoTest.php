<?php
require_once dirname(__FILE__) . '/../../../extensions/wikia/WikiaVideo/PartnerVideoHelper.php';

class ImportPartnerVideoTest extends PHPUnit_Framework_TestCase {
	
	
	/**
	 * @dataProvider invalidFileContents
	 */
    	public function testImportFromScreenplayInvalidFile($invalidFileContents) {
            	$mock = $this->getMock('PartnerVideoHelper', array('createVideoPageForPartnerVideo'));
            	$mock->expects($this->never())
                    	->method('createVideoPageForPartnerVideo');
            	$result = $mock->importFromScreenplay($invalidFileContents);
		$this->assertEquals(0, $result);
	}

	public function invalidFileContents() {
		return array(
			array(null),
			array(''),
			array('<xml></xml>'),
			array('<xml></invalidclose>')
);
	}	
	
	/**
	 * @dataProvider validFileContents
	 */
	public function testImportFromScreenplayValidFile($testXmlFile, $expectedResult) {
		
		// test case: one title, one clip
		$screenplayXml = file_get_contents(dirname(__FILE__) . '/' . $testXmlFile);
		$mock = $this->getMock('PartnerVideoHelper', array('createVideoPageForPartnerVideo'));
		$mock->expects($this->once())
			->method('createVideoPageForPartnerVideo')
			->with($this->anything(), $this->equalTo($expectedResult), $this->anything())
			->will($this->returnValue(1));
		$mock->importFromScreenplay($screenplayXml);
	}
	
	public function validFileContents() {
		return array(
			array('screenplay1.xml',
				array(
					'titleName' => 'Harry Potter & The Sorcerer\'s Stone',
					'year' => '2001',
					'eclipId' => 'e15402',
					'trailerType' => 'Home Video',
					'trailerVersion' => 'Trailer',
					'description' => 'Trailer',
					'lrgJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=382&vendorid=1893&type=.jpg',
					'medJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=267&vendorid=1893&type=.jpg',
					'stdBitrateCode' => '455',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=455&vendorid=1893&type=.mp4'		    
				)
			),
			array('screenplay2.xml',
				array(
					'titleName' => 'Harry Potter And The Order Of The Phoenix',
					'year' => '2007',
					'eclipId' => 'e32473',
					'trailerType' => 'Open-ended',
					'trailerVersion' => 'Trailer',
					'description' => '',
					'lrgJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e32473&bitrateid=382&vendorid=1893&type=.jpg',
					'medJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e32473&bitrateid=267&vendorid=1893&type=.jpg',
					'stdBitrateCode' => '461',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e32473&bitrateid=461&vendorid=1893&type=.mp4',
				        'hdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e32473&bitrateid=449&vendorid=1893&type=.mp4'
				)
			),
			array('screenplay3.xml',
				array(
					'titleName' => 'Harry Potter And The Deathly Hallows: Part 1',
					'year' => '2010',
					'eclipId' => 'e69304',
					'trailerType' => 'Open-ended',
					'trailerVersion' => 'Trailer',
					'description' => 'Trailer for part 1 of the final Harry Potter book',
					'lrgJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e69304&bitrateid=382&vendorid=1893&type=.jpg',
					'medJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e69304&bitrateid=267&vendorid=1893&type=.jpg',
					'stdBitrateCode' => '461',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e69304&bitrateid=461&vendorid=1893&type=.mp4',
				        'hdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e69304&bitrateid=449&vendorid=1893&type=.mp4'
				)
			),
			array('screenplay4.xml',
				array(
					'titleName' => 'Harry Potter and the Half-Blood Prince',
					'year' => '2009',
					'eclipId' => 'e54291',
					'trailerType' => 'Open-ended',
					'trailerVersion' => 'Extra (Clip)',
					'description' => 'Interview: Bonnie Wright "On her friendship with Harry"',
					'lrgJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e54291&bitrateid=382&vendorid=1893&type=.jpg',
					'medJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e54291&bitrateid=267&vendorid=1893&type=.jpg',
					'stdBitrateCode' => '461',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e54291&bitrateid=461&vendorid=1893&type=.mp4'
				)
			)
		);
	}
		
	protected function setUp() {
		$this->appBackup = F::app();
}

	protected function tearDown() {
		F::reset('VideoPage');
	}

	public function testCreatingVideoPage() {
		global $debug;
		$debug = false;

		$title = $this->getMock('Title', array('exists'));
		$title->expects($this->once())
			->method('exists')
			->will($this->returnValue(true));

		$helper = $this->getMock('PartnerVideoHelper', array('makeTitleSafe'));
		$helper->expects($this->once())
			->method('makeTitleSafe')
			->will($this->returnValue($title));					
		

		$data = array(
		    'titleName' => 'Harry Potter & The Sorcerer\'s Stone',
		    'year' => '2001',
		    'eclipId' => 'e15402',
		    'trailerType' => 'Home Video',
		    'trailerVersion' => 'Trailer',
		    'description' => 'Trailer',
		    'lrgJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=382&vendorid=1893&type=.jpg',
		    'medJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=267&vendorid=1893&type=.jpg',
		    'stdBitrateCode' => '455',
		    'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=455&vendorid=1893&type=.mp4'
		    
		);
		
		$result = $helper->createVideoPageForPartnerVideo(VideoPage::V_SCREENPLAY, $data, $msg);

		$this->assertEquals(0, $result);
		
		
		$title = $this->getMock('Title', array('exists'));
		$title->expects($this->once())
			->method('exists')
			->will($this->returnValue(false));

		$helper = $this->getMock('PartnerVideoHelper', array('makeTitleSafe'));
		$helper->expects($this->once())
			->method('makeTitleSafe')
			->will($this->returnValue($title));					
		
		$videoMock = $this->getMock('VideoPage', array('loadFromPars', 'setName', 'save'), array(&$title));
		$videoMock->expects($this->atLeastOnce())
			       ->method('loadFromPars');
		$videoMock->expects($this->atLeastOnce())
			       ->method('setName');
		$videoMock->expects($this->atLeastOnce())
			       ->method('save');		
		F::setInstance('VideoPage', $videoMock);

		$data = array(
		    'titleName' => 'Harry Potter & The Sorcerer\'s Stone',
		    'year' => '2001',
		    'eclipId' => 'e15402',
		    'trailerType' => 'Home Video',
		    'trailerVersion' => 'Trailer',
		    'description' => 'Trailer',
		    'lrgJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=382&vendorid=1893&type=.jpg',
		    'medJpegUrl' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=267&vendorid=1893&type=.jpg',
		    'stdBitrateCode' => '455',
		    'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=455&vendorid=1893&type=.mp4'
		    
		);
		
		$result = $helper->createVideoPageForPartnerVideo(VideoPage::V_SCREENPLAY, $data, $msg);

		$this->assertEquals(1, $result);
		
	}	
}
