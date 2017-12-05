<?php

use PHPUnit\Framework\TestCase;

class RCDatabaseLogEntryTest extends TestCase {
	public function testLogEntryProvidesFallbackForAnonUserWhenIpIsMissing() {
		$row = [
			'rc_logid' => 123,
			'rc_user' => 0
		];

		$databaseLogEntry = RCDatabaseLogEntry::newFromRow( $row );

		$this->assertInstanceOf( RCDatabaseLogEntry::class, $databaseLogEntry );
		$this->assertEquals( NON_ROUTABLE_IPV4, $databaseLogEntry->getPerformer()->getName() );
	}

	/**
	 * @dataProvider provideIpAddresses
	 * @param string $binaryIp
	 * @param string $expectedIp
	 */
	public function testLogEntryCorrectlyDecodesIpForAnonUser( string $binaryIp, string $expectedIp ) {
		$row = [
			'rc_logid' => 123,
			'rc_user' => 0,
			'rc_ip_bin' => $binaryIp
		];

		$databaseLogEntry = RCDatabaseLogEntry::newFromRow( $row );

		$this->assertInstanceOf( RCDatabaseLogEntry::class, $databaseLogEntry );
		$this->assertEquals( $expectedIp, $databaseLogEntry->getPerformer()->getName() );
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
