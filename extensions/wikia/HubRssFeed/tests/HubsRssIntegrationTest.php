<?php

/**
 * @group Integration
 */

class HubsRssIntegrationTest extends WikiaBaseTest {

	/**
	 * Hubs rss links
	 */
	private $rssUrls  = [
		'Gaming' 	=> 'http://www.wikia.com/rss/Gaming',
		'Entertainment' => 'http://www.wikia.com/rss/Entertainment',
		'Lifestyle' 	=> 'http://www.wikia.com/rss/Lifestyle'
	];

	/*private $rssUrls  = [
		'Gaming' 	=> 'http://wikia.szumo.wikia-dev.com/rss/Gaming',
		//'Entertainment' => 'http://www.wikia.com/rss/Entertainment',
		//'Lifestyle' 	=> 'http://www.wikia.com/rss/Lifestyle'
	];*/

	/**
	 * Check if hubs rss contain data in proper structure
	 *
	 * @dataProvider hubsRssLinksDataProvider
	 */
	public function testHubsRssLinks( $hub, $rssStr ) {
		$this->assertNotEquals($rssStr, FALSE, "Cannot read RSS file from $hub hub");

		$rss = new SimpleXMLElement($rssStr, LIBXML_NOCDATA);

		$channelCount = $rss->channel->count();
		$this->assertGreaterThan(0, $channelCount);

		$this->verifyRssDescription( $rss->channel, $hub );

		$itemCount = $rss->channel->item->count();
		$this->assertGreaterThan(0, $itemCount);

		$this->verifyRssItem( $rss->channel->item[0], $hub );
	}

	/**
	 * Check rss description data
	 */
	private function verifyRssDescription( $channel, $hub ) {
		$this->assertNotEmpty( $channel->title->__toString(), $hub . ' RSS description title is empty' );
		$this->assertNotEmpty( $channel->description->__toString(),  $hub . ' RSS description description is empty' );
		if (isset($channel->link->attributes()->href)) {
			$this->assertNotEmpty( $channel->link->attributes()->href->__toString(),  $hub . ' RSS description link is empty' );
		} else {
			$this->assertNotEmpty( $channel->link->__toString(),  $hub . ' RSS description link is empty' );
		}
		$this->assertNotEmpty( $channel->language->__toString(),  $hub . ' RSS description language is empty' );
		$this->assertNotEmpty( $channel->lastBuildDate->__toString(),  $hub . ' RSS description lastBuildDate is empty' );
	}

	/**
	 * Check rss hub data
	 */
	private function verifyRssItem( $item, $hub ) {
		$this->assertNotEmpty( $item->title->__toString(),  $hub . ' RSS item title is empty' );
		$this->assertNotEmpty( $item->description->__toString(),  $hub . ' RSS item description is empty' );
		$this->assertNotEmpty( $item->link->__toString(),  $hub . ' RSS item link is empty' );
		$this->assertNotEmpty( $item->guid->__toString(),  $hub . ' RSS item guid is empty' );
		$this->assertNotEmpty( $item->pubDate->__toString(),  $hub . ' RSS item pubDate is empty' );
	}

	public function hubsRssLinksDataProvider() {
		$data = [];

		foreach( $this->rssUrls as $hub => $rssUrl ) {
			$rssStr =  file_get_contents( $rssUrl );
			$hubData = [
				$hub,
				$rssStr
			];
			$data[] = $hubData;
		}

		return $data;
	}
}
