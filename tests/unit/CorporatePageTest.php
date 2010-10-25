<?php

class CorporatePageTest extends PHPUnit_Framework_TestCase {

	function setUp(){
		global $IP;
		require_once("$IP/extensions/wikia/CorporatePage/HomePageMemAdapter.class.php");
		require_once("$IP/extensions/wikia/CorporatePage/HomePageStatisticCollector.class.php");
		require_once("$IP/extensions/wikia/CorporatePage/CorporatePageHelper.class.php");	
		$this->markTestSkipped();
	}

	function testFifoLineAndMemcClear() {
		global $wgMemc;
		$startTime = 100;
		$timeSample = 5;
		$fifoLength = 60; 
		$key = wfMemcKey( "hp_stats_test", "stat_hp_fifo_week" ); 
		$wgMemc->set( $key,array(),60);	
			
		$startTime += 1;
		$out = HomePageStatisticCollector::fifoLine(1,$timeSample,$fifoLength,$key,$startTime);
		$this->assertEquals( 1,$out);
		$startTime += 15;
		$out = HomePageStatisticCollector::fifoLine(2,$timeSample,$fifoLength,$key,$startTime);
		$this->assertEquals( 3,$out);
		$startTime += 105;
		$out = HomePageStatisticCollector::fifoLine(3,$timeSample,$fifoLength,$key,$startTime);
		$this->assertEquals( 5,$out);
		$wgMemc->delete($key);
		
		
		$title = "corporatepage-test-msg";
		$text = "";
		$key = wfMemcKey( "hp_msg_parser",  $title, 'en' ) ;
		$wgMemc->set($key,"test value",30);
		
		$this->assertEquals("test value", $wgMemc->get($key)); 
		CorporatePageHelper::clearMessageCache($title,$text);
		$this->assertNull($wgMemc->get($key));
	}

	function testParser1() {
		global $wgMessageCache;

		$test_msg = 
			'*http://test1A.wikia.com|test1A
			**http://test2A.wikia.com|test2A
			**http://test2A.wikia.com|test2AX
			*http://test1B.wikia.com|test1B
			**http://test2B.wikia.com|test2B
			**http://test2B.wikia.com|test2BX
			*http://test1C.wikia.com|test1C
			**http://test2C.wikia.com|test2C
			**http://test2CX.wikia.com|test2CX';
		
		$wgMessageCache->addMessage('corporate-page-test-paresr1' , $test_msg );
		$array = CorporatePageHelper::parseMsg('corporate-page-test-paresr1');

        $this->assertEquals('test1C', $array[2]['title']);
		$this->assertEquals('http://test1A.wikia.com', $array[0]['href'] );
		$this->assertEquals('test2C', $array[2]['sub'][0]['title'] );
		$this->assertEquals('http://test2CX.wikia.com', $array[2]['sub'][1]['href'] );

	}
	
	function testParser2() {
		global $wgMessageCache;
		$test_msg = 
			'*http://test1A.wikia.com|test1A|img1
			 *http://test2A.wikia.com|test2A|img1|no-window
			 *http://test2A.wikia.com|test2AX|img1';
		
		$wgMessageCache->addMessage('corporate-page-test-paresr1' , $test_msg );		
		$array = CorporatePageHelper::parseMsgImg('corporate-page-test-paresr1');
		
		$this->assertEquals('test2AX', $array[2]['title']);
		$this->assertEquals('no-window', $array[1]['param']);
		$this->assertEquals('http://test1A.wikia.com', $array[0]['href'] );
	}
	
	function testParser3() {
		global $wgMessageCache;
		$test_msg = 
			'*http://test1A.wikia.com|test1A|test1AX|img1|img2
			 *http://test2A.wikia.com|test2A|test2AX|img1|img2
			 *http://test3A.wikia.com|test3A|test3AX|img1|img2';
		
		$wgMessageCache->addMessage('corporate-page-test-paresr1' , $test_msg );		
		$array = CorporatePageHelper::parseMsgImg('corporate-page-test-paresr1',true);
		$this->assertEquals('test2A', $array[1]['title']);
		$this->assertEquals('http://test1A.wikia.com', $array[0]['href'] );
	}
}
