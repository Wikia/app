<?php

declare( strict_types=1 );

namespace Wikia\Purger;

use PHPUnit\Framework\TestCase;

class ThumblrSurrogateKeyTest extends TestCase {

	/**
	 * @dataProvider urlProvider
	 * @param string $url
	 * @param string $valueBeforeHashing
	 * @param string $expectedValue
	 */
	public function testShould( string $url, string $valueBeforeHashing, string $expectedValue ) {
		$key = ThumblrSurrogateKey::fromUrl( $url );
		$this->assertEquals( $key->valueBeforeHashing(), $valueBeforeHashing );
		$this->assertEquals( $key->value(), $expectedValue );
	}

	public function urlProvider() {
		yield [
			'https://vignette.wikia.nocookie.net/cardfight/images/d/dc/Gentle_Persuasion.jpg/revision/latest?cb=20150827145148',
			'cardfight/images/d/dc/Gentle_Persuasion.jpg',
			'96e8837897d149ceef19c7381ff5170501ba03eb',
		];
		yield [
			'https://vignette.wikia.nocookie.net/bindingofisaac/images/0/0e/Community-header-background/revision/latest/zoom-crop/width/472/height/115?cb=2019615&path-prefix=ru',
			'bindingofisaac/ru/images/0/0e/Community-header-background',
			'5721958a6276ea928748f754a5f8b67e454a277c',
		];
		yield [
			'https://vignette.wikia.nocookie.net/starwars/images/a/a9/Aargau.jpg/revision/20110116012411',
			'starwars/images/archive/a/a9/20110116012411!Aargau.jpg',
			'47158eb1aeaa6c5b8e65481f863494735ff5b7b0',
		];
		yield [
			'https://vignette.wikia.nocookie.net/pablotestwiki/images/7/78/Dog1.jpeg/revision/latest?cb=20200131114431',
			'pablotestwiki/images/7/78/Dog1.jpeg',
			'1f80603cd81b520a87f380f0bc4780b35bd9f4f7',
		];
	}
}
