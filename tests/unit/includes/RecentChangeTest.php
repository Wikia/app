<?php

use PHPUnit\Framework\TestCase;

class RecentChangeTest extends TestCase {
	/** @var stdClass $row */
	private $row;

	/** @var RecentChange $recentChange */
	private $recentChange;

	protected function setUp() {
		parent::setUp();
		$this->recentChange = new RecentChange();
	}

	public function testRecentChangeProvidesFallbackForEmptyIp() {
		$this->assertEquals( NON_ROUTABLE_IPV4, $this->recentChange->getUserIp() );
		$this->assertEquals( NON_ROUTABLE_IPV4, RecentChange::extractUserIpFromRow( $this->row ) );
	}

	/**
	 * @dataProvider provideIpAddresses
	 * @param string $binaryIp
	 * @param string $expectedIp
	 */
	public function testRecentChangeDecodesBinaryIp( string $binaryIp, string $expectedIp ) {
		$this->recentChange->mAttribs['rc_ip_bin'] = $binaryIp;
		$this->row->rc_ip_bin = $binaryIp;

		$this->assertEquals( $expectedIp, $this->recentChange->getUserIp() );
		$this->assertEquals( $expectedIp, RecentChange::extractUserIpFromRow( $this->row ) );
	}

	public function provideIpAddresses(): Generator {
		$ipAddresses = [
			'8.8.8.8',
			'122.161.0.13',
			'2602:306:8006:43A0:6582:52A4:CAF3:4028',
			'2604:6000:E840:F100:9C9F:2BF9:E23C:1F37'
		];

		foreach ( $ipAddresses as $ipAddress ) {
			yield [ inet_pton( $ipAddress ), $ipAddress ];
		}
	}
}
