<?php

/**
 * Set of unit tests for wfReplaceImageServer function
 *
 * @author macbre
 */
class ReplaceImageServerTest extends WikiaBaseTest {

	const DEFAULT_CB = 123456789;

	public function setUp() {
		parent::setUp();

		$this->mockGlobalVariable('wgCdnStylePath', sprintf('http://slot1.images.wikia.nocookie.net/__cb%s/common', self::DEFAULT_CB));
		$this->mockGlobalVariable('wgAkamaiGlobalVersion', 0);
		$this->mockGlobalVariable('wgAkamaiLocalVersion', 0);
	}

	/**
	 * @dataProvider testForProductionDataProvider
	 */
	public function testForProduction($url, $timestamp, $expected) {
		$this->mockGlobalVariable('wgDevBoxImageServerOverride', false);

		$this->assertEquals( $expected, wfReplaceImageServer( $url, $timestamp ), 'URL returned by wfReplaceImageServer should match expected one' );
	}

	public function testForProductionDataProvider() {
		return [
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/0/06/Gzik.jpg',
				'timestamp' => '20111213221641',
				'expected' => 'http://images3.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/0/06/Gzik.jpg',
			],
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
				'timestamp' => '20110917091718',
				'expected' => 'http://images1.wikia.nocookie.net/__cb20110917091718/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
			],
			// no timestamp provided, use cache buster value from wgCdnStylePath (i.e. wgStyleVersion)
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
				'timestamp' => false,
				'expected' => 'http://images1.wikia.nocookie.net/__cb' . self::DEFAULT_CB . '/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
			],
			// ogg files should be served from images.wikia.com domain
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/a/aa/File.ogg',
				'timestamp' => '20110917091718',
				'expected' => 'http://images.wikia.com/poznan/pl/images/a/aa/File.ogg',
			],
		];
	}

	/**
	 * @dataProvider devboxDataProvider
	 */
	public function testForDevbox($url, $timestamp, $expected) {
		$this->mockGlobalVariable('wgDevBoxImageServerOverride', 'images.hakarl.wikia-dev.com');

		$this->assertEquals( $expected, wfReplaceImageServer( $url, $timestamp ), 'URL returned by wfReplaceImageServer should match expected one' );
	}

	public function devboxDataProvider() {
		return [
			// cachebuster should be added on devboxes as well
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/0/06/Gzik.jpg',
				'timestamp' => '20111213221641',
				'expected' => 'http://images.hakarl.wikia-dev.com/__cb20111213221641/poznan/pl/images/0/06/Gzik.jpg',
			],
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
				'timestamp' => '20110917091718',
				'expected' => 'http://images.hakarl.wikia-dev.com/__cb20110917091718/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
			],
			// no timestamp provided, use cache buster value from wgCdnStylePath (i.e. wgStyleVersion)
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
				'timestamp' => false,
				'expected' => 'http://images.hakarl.wikia-dev.com/__cb' . self::DEFAULT_CB . '/poznan/pl/images/5/57/Ratusz_uj%C4%99cie_od_do%C5%82u.jpg',
			],
			// ogg files should be served from devbox images domain
			[
				'url' => 'http://images.wikia.com/poznan/pl/images/a/aa/File.ogg',
				'timestamp' => '20110917091718',
				'expected' => 'http://images.hakarl.wikia-dev.com/poznan/pl/images/a/aa/File.ogg',
			],
		];
	}
}
