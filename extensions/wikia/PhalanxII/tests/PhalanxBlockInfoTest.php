<?php

use PHPUnit\Framework\TestCase;

class PhalanxBlockInfoTest extends TestCase {
	/**
	 * @dataProvider provideJsonBlockInfo
	 * @param array $jsonObject
	 */
	public function testJsonDeserialization( array $jsonObject ) {
		$phalanxBlockInfo = PhalanxBlockInfo::newFromJsonObject( $jsonObject );

		$this->assertInstanceOf( PhalanxBlockInfo::class, $phalanxBlockInfo );
		$this->assertEquals( $jsonObject['regex'], $phalanxBlockInfo->isRegex() );
		$this->assertEquals( $jsonObject['expires'], $phalanxBlockInfo->getExpires() );

		$this->assertEquals( $jsonObject['timestamp'], $phalanxBlockInfo->getTimestamp() );
		$this->assertEquals( $jsonObject['text'], $phalanxBlockInfo->getText() );

		$this->assertEquals( $jsonObject['reason'], $phalanxBlockInfo->getReason() );
		$this->assertEquals( $jsonObject['exact'], $phalanxBlockInfo->isExact() );

		$this->assertEquals( $jsonObject['caseSensitive'], $phalanxBlockInfo->isCaseSensitive() );
		$this->assertEquals( $jsonObject['id'], $phalanxBlockInfo->getId() );

		$this->assertEquals( $jsonObject['authorId'], $phalanxBlockInfo->getAuthorId() );
		$this->assertEquals( $jsonObject['type'], $phalanxBlockInfo->getType() );
	}

	public function provideJsonBlockInfo(): Generator {
		$jsonFixture = file_get_contents( __DIR__ . '/fixtures/phalanx-blocks-response.json' );

		foreach ( json_decode( $jsonFixture, true ) as $jsonObject ) {
			yield [ $jsonObject ];
		}
	}
}
