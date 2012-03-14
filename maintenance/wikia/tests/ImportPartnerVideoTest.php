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
			array('screenplay2.xml',
				array(
					'titleName' => 'Harry Potter And The Order Of The Phoenix',
					'year' => '2007',
				        'duration' => '133',
					'eclipId' => 'e32473',
				        'jpegBitrateCode' => '382',
					'trailerType' => 'Open-ended',
					'trailerVersion' => 'Trailer',
					'description' => '',
					'stdBitrateCode' => '461',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e32473&bitrateid=461&vendorid=1893&type=.mp4',
				        'hdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e32473&bitrateid=449&vendorid=1893&type=.mp4'
				)
			),
			array('screenplay3.xml',
				array(
					'titleName' => 'Harry Potter And The Deathly Hallows: Part 1',
					'year' => '2010',
				        'duration' => '135',
					'eclipId' => 'e69304',
				        'jpegBitrateCode' => '382',
					'trailerType' => 'Open-ended',
					'trailerVersion' => 'Trailer',
					'description' => 'Trailer for part 1 of the final Harry Potter book',
					'stdBitrateCode' => '461',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e69304&bitrateid=461&vendorid=1893&type=.mp4',
				        'hdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e69304&bitrateid=449&vendorid=1893&type=.mp4'
				)
			),
			array('screenplay4.xml',
				array(
					'titleName' => 'Harry Potter and the Half-Blood Prince',
					'year' => '2009',
				        'duration' => '34',
					'eclipId' => 'e54291',
				        'jpegBitrateCode' => '382',
					'trailerType' => 'Open-ended',
					'trailerVersion' => 'Extra (Clip)',
					'description' => 'Interview: Bonnie Wright "On her friendship with Harry"',
					'stdBitrateCode' => '461',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e54291&bitrateid=461&vendorid=1893&type=.mp4'
				)
			)
		);
	}
	
	public function validFileBlacklistedContents() {
		return array(
			array('screenplay1.xml',
				array(
					'titleName' => 'Harry Potter & The Sorcerer\'s Stone',
					'year' => '2001',
					'duration' => '33',
					'eclipId' => 'e15402',
				        'jpegBitrateCode' => '382',
					'trailerType' => 'Home Video',
					'trailerVersion' => 'Trailer',
					'description' => 'Trailer',
					'stdBitrateCode' => '455',
					'stdMp4Url' => 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=e15402&bitrateid=455&vendorid=1893&type=.mp4'		    
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
	
	/**
	 * Ensures that downloading zipped feed file from screenplay and unzipping it
	 * works correctly - return unzipped file contents
	 *
	 * @group Infrastructure
	 */
	public function ttestDownloadingScreenplayFeed() {
		$feedContents = PartnerVideoHelper::downloadScreenplayFeed();
		
		$this->assertGreaterThan(strlen($feedContents));

		$doc = new DOMDocument( '1.0', 'UTF-8' );
		$doc->loadXML( $feedContents );

		$titles = $doc->getElementsByTagName('Title');
		$this->assertGreaterThan(count($titles->length));
	}	

	/**
	 * @group Infrastructure
	 */
	public function testImportingFromMovieClips() {
    		$mock = $this->getMock('PartnerVideoHelper', array('createVideoPageForPartnerVideo'));
		$mock->expects($this->atLeastOnce())
   		 ->method('createVideoPageForPartnerVideo')
   		 ->with($this->equalTo(VideoPage::V_MOVIECLIPS), $this->anything(), $this->anything())
   		 ->will($this->returnValue(1));
		$result = $mock->importFromMovieClips('BEpY');
		$this->assertGreaterThan(0, $result);

		$mock = $this->getMock('PartnerVideoHelper', array('createVideoPageForPartnerVideo'));
		$mock->expects($this->never())
   		 ->method('createVideoPageForPartnerVideo')
		 ->will($this->returnValue(0));
		$result = $mock->importFromMovieClips(-1);
		$this->assertEquals(0, $result);	
	}	
	
	public function testMovieClips() {
		$expectedParsingResult = array(
			'clipTitle' => 'Teaser #1',
			'description' => 'Blacksmith Will Turner (Orlando Bloom) teams up with eccentric pirate &#8220;Captain&#8221; Jack Sparrow (Johnny Depp) to save his love&#44; the governor&#8217;s daughter&#44; from Jack&#8217;s former pirate allies&#44; who are now undead.',
			'duration' => '69',
			'freebaseMid' => '/m/01vksx',
			'mcId' => 'MJZLR',
			'thumbnail' => 'http://cdn5.movieclips.com/disney/p/pirates-of-the-caribbean-the-curse-of-the-black-pearl-2003/0388395_28845_MC_Tx304.jpg',
			'titleName' => 'Pirates of the Caribbean: The Curse of the Black Pearl',
			'year' => '2003'
		);

		$mock = $this->getMock('PartnerVideoHelper', array('createVideoPageForPartnerVideo', 'getUrlContent'));

		$mock->expects($this->once())
   		 ->method('createVideoPageForPartnerVideo')
   		 ->with($this->equalTo(VideoPage::V_MOVIECLIPS), $this->equalTo($expectedParsingResult), $this->anything())
   		 ->will($this->returnValue(1));

		$testFeed = file_get_contents(dirname(__FILE__) . '/' . 'movieclips1.xml');
		$mock->expects($this->once())
   		 ->method('getUrlContent')
		 ->will($this->returnValue($testFeed));

		$result = $mock->importFromMovieClips('pxbK');

		$this->assertEquals(1, $result);
	}	
}
