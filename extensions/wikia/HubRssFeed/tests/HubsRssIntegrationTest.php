<?php

/**
 * @group Integration
 */

class HubsRssIntegrationTest extends WikiaBaseTest {

	/**
	 * Hubs rss links
	 */
	private $rssUrls  = [
		'Gaming' 		=> 'http://www.wikia.com/rss/Gaming',
		'Entertainment' => 'http://www.wikia.com/rss/Entertainment',
		'Lifestyle' 	=> 'http://www.wikia.com/rss/Lifestyle'
	];

	/**
	 * Check if hubs rss contain data in proper structure
	 */
	public function testHubsRssLinks() {
		foreach( $this->rssUrls as $hub => $rssUrl ) {
			$rss = $this->getRssContent( $rssUrl, $hub );

			$channelCount = $rss->channel->count();
			$this->assertGreaterThan(0, $channelCount);

			if( $channelCount ) {
				$this->verifyRssDescription( $rss->channel, $hub );

				$itemCount = $rss->channel->item->count();
				$this->assertGreaterThan(0, $itemCount);

				if( $itemCount ) {
					$this->verifyRssItem( $rss->channel->item[0], $hub );
				}
			}
		}
	}

	/**
	 * Gets rss content
	 */
	private function getRssContent( $rssUrl, $hub ) {
		$rss_str = file_get_contents( $rssUrl );

		$this->assertNotEquals($rss_str, FALSE, "Cannot read RSS file from $hub hub");

		$rss = new SimpleXMLElement($rss_str, LIBXML_NOCDATA);

		return $rss;
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
}
