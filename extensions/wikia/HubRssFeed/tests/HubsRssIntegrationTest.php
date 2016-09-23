<?php

/**
 * @group ExternalIntegration
 */

class HubsRssIntegrationTest extends WikiaBaseTest {

	/**
	 * Hubs rss links
	 */
	private $rssUrls = [
		'Games'         => 'http://www.wikia.com/rss/Games',
		'TV'            => 'http://www.wikia.com/rss/TV',
		'Entertainment' => 'http://www.wikia.com/rss/Entertainment',
		'Lifestyle'     => 'http://www.wikia.com/rss/Lifestyle'
	];

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

		$this->verifyRssItem( $rss->channel->item[0] );
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
	 * Check that all required fields exist in the RSS item
	 */
	private function verifyRssItem( $item ) {
		$this->assertContains( 'title',  $item . ' RSS item title is missing' );
		$this->assertContains( 'description',  $item . ' RSS item description is missing' );
		$this->assertContains( 'link',  $item . ' RSS item link is missing' );
		$this->assertContains( 'guid',  $item . ' RSS item guid is missing' );
		$this->assertContains( 'pubDate',  $item . ' RSS item pubDate is missing' );
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
