<?php

/**
 * @group Transaction
 */
class TransactionIsCacheableTest extends WikiaBaseTest {

	/**
	 * @dataProvider isCacheableDataProvider
	 */
	public function testIsCacheable( $header, $expected ) {
		$this->assertEquals( $expected, Transaction::isCacheable( $header ? [ 'Cache-Control: ' . $header ] : [] ) );
	}

	public function isCacheableDataProvider() {
		return [
			[
				'header' => false,
				'isCacheable' => null
			],
			[
				'header' => 's-maxage=86400, must-revalidate, max-age=0',
				'isCacheable' => true
			],
			[
				'header' => 'public, max-age=2592000',
				'isCacheable' => true
			],
			[
				'header' => 'private, must-revalidate, max-age=0',
				'isCacheable' => false
			],
		];
	}
}
