<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */

class HubRssServiceTest extends WikiaBaseTest {

	public function setUp()
	{
		$dir = dirname( __FILE__ ) . '/../';
		require_once $dir . '../WikiFactory/Hubs/WikiFactoryHub.php';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';
		parent::setUp();
	}

	public function testDataToXml() {
		$service = new HubRssFeedService('en','http://www.google.pl');

		$prop = new ReflectionProperty($service,'descriptions');
		$prop->setAccessible(true);
		$val = $prop->getValue($service);

		reset($val);

		$hub = key($val);
		$date1 =  strtotime('2010-01-01');
		$date2 = strtotime('2011-01-01');

		$inputData= [
			['title' =>'title1', 'img'=>'img1',	'timestamp'=>$date1, 'description'=>'description1' ],//2010-01-01
			['title' =>'title2', 'img'=>'img2',	'timestamp'=>$date2, 'description'=>'description2' ] //2011-01-01
		];

		$xml = $service->dataToXml($inputData, $hub);
		//$xml = simplexml_load_string($xml);
		//var_dump($xml);
		$doc = new DOMDocument;
		$doc->loadXML($xml);

		$this->assertInstanceOf('DOMDocument',$doc);

		$buildDateItems = $doc->getElementsByTagName('lastBuildDate');
		$buildDate = $buildDateItems->item(0);

		$this->assertEquals($date2,strtotime($buildDate->textContent));

		$rss = $doc->firstChild;

		$this->assertEquals('rss',$rss->nodeName);



	}


}
