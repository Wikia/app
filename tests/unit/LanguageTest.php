<?php
class LanguageTest extends WikiaBaseTest {

	/**
	 * @dataProvider shortenNumberDecoratorDataProvider
	 * @group UsingDB
	 */
	public function testShortenNumberDecorator( $number, $expectedDecorated, $expectedRounded ) {
		$this->mockMessage( 'number-shortening-billions', '$1B' );
		$this->mockMessage( 'number-shortening-millions', '$1M' );
		$this->mockMessage( 'number-shortening', '$1K' );

		$lang = new Language();

		$result = $lang->shortenNumberDecorator( $number );
		$this->assertEquals( $expectedDecorated, $result->decorated );
		$this->assertEquals( $expectedRounded, $result->rounded );
	}

	public function shortenNumberDecoratorDataProvider() {
		return [
			[ 1234, '1.2K', 1200 ],
			[ 56000, '56K', 56000 ],
			[ 56710, '56.7K', 56700 ],
			[ 56756, '56.8K', 56800 ],
			[ 56900, '56.9K', 56900 ],
			[ 56990, '57K', 57000 ],
			[ 123456789, '123.5M', 123500000 ],
		];
	}
}
