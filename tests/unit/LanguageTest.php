<?php
class LanguageTest extends WikiaBaseTest {

	/**
	 * @dataProvider shortenNumberDecoratorDataProvider
	 * @group UsingDB
	 */
	public function testShortenNumberDecorator($number,$expected) {
		$this->mockMessage( 'number-shortening-billions', '$1B' );
		$this->mockMessage( 'number-shortening-millions', '$1M' );
		$this->mockMessage( 'number-shortening', '$1K' );

		$lang = new Language();

		$result = $lang->shortenNumberDecorator( $number );
		$this->assertEquals( $expected, $result );
	}

	public function shortenNumberDecoratorDataProvider() {
		return [
			[ 1234,'1.2K' ],
			[ 56000,'56K' ],
			[ 56710,'56.7K' ],
			[ 56756,'56.8K' ],
			[ 56900,'56.9K' ],
			[ 56990,'57K' ],
			[ 123456789,'123.5M' ],
		];
	}
}
