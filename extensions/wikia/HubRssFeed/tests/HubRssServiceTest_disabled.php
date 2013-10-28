<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */

class HubRssServiceTest extends WikiaBaseTest {

	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		require_once $dir . '../WikiFactory/Hubs/WikiFactoryHub.php';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';
		parent::setUp();
	}

	/**
	 * @covers  HubRssFeedService::dataToXml
	 */
	public function testDataToXml() {

		$service = new HubRssFeedService('xx', 'yy');

		$prop = new ReflectionProperty($service, 'descriptions');
		$prop->setAccessible( true );
		$val = $prop->getValue( $service );

		reset( $val );

		$hub = key( $val );
		$date1 = strtotime( '2010-01-01' );
		$date2 = strtotime( '2011-01-01' );

		$inputData = [
			['title' => 'title1', 'img' => ['url' => 'img1', 'width' => 111, 'height' => 222], 'timestamp' => $date1, 'description' => 'description1'], //2010-01-01
			['title' => 'title2', 'img' => ['url' => 'img1', 'width' => 333, 'height' => 444], 'timestamp' => $date2, 'description' => 'description2'] //2011-01-01
		];

		$xml = $service->dataToXml( $inputData, $hub );

		$doc = new DOMDocument;

		$doc->loadXML( $xml );

		$this->assertInstanceOf( 'DOMDocument', $doc );

		$rss = $doc->firstChild;

		$this->assertEquals( 'rss', $rss->nodeName );

		$xpath = new DOMXpath($doc);

		/* checking for channel node */
		$this->assertEquals( 1, $xpath->query( '//rss/channel' )->length );

		$this->assertEquals( 1, $xpath->query( '//rss/channel/title[string-length() > 0]' )->length );

		$this->assertEquals( 1, $xpath->query( '//rss/channel/description[string-length() > 0]' )->length );

		$this->assertEquals( 1, $xpath->query( '//rss/channel/language[.="xx"]' )->length );

		$this->assertEquals( 1, $xpath->query( '//rss/channel/link[.="yy"]' )->length );

		/*checking for date*/
		$pubDate = date( HubRssFeedService::DATE_FORMAT, max( $date1, $date2 ) );

		$res = $xpath->query( '//rss/channel/lastBuildDate[.="' . $pubDate . '"]' );
		$this->assertEquals( 1, $res->length );

		/* checking for items */
		$items = $xpath->query( '//rss/channel/item' );
		$this->assertEquals( 2, $items->length );

		foreach ( $inputData as $key => $data ) {
			$item = $items->item( $key );

			$this->assertEquals( 1, $xpath->query( 'title[.="' . $data[ 'title' ] . '"]', $item )->length );
			$this->assertEquals( 1, $xpath->query( 'pubDate[.="' . date( HubRssFeedService::DATE_FORMAT, $data[ 'timestamp' ] ) . '"]', $item )->length );
			$this->assertEquals( 1, $xpath->query( 'dc:creator[.="Wikia"]', $item )->length );
			$this->assertEquals( 1, $xpath->query( 'description[.="' . $data[ 'description' ] . '"]', $item )->length );
			$imgList = $xpath->query( 'media:content', $item );
			$this->assertEquals( 1, $imgList->length );
			$img = $imgList->item( 0 );
			$this->assertEquals( 'image/jpeg', $img->attributes->getNamedItem( 'type' )->nodeValue );
			$this->assertEquals( $data[ 'img' ][ 'url' ], $img->attributes->getNamedItem( 'url' )->nodeValue );
			$this->assertEquals( $data[ 'img' ][ 'width' ], $img->attributes->getNamedItem( 'width' )->nodeValue );
			$this->assertEquals( $data[ 'img' ][ 'height' ], $img->attributes->getNamedItem( 'height' )->nodeValue );


		}

	}


}
