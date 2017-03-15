<?php

use PHPUnit\Framework\TestCase;

class WikiaValidatorUrlTest extends TestCase {

	/* @var $validator WikiaValidatorUrl */
	private $validator;

	protected function setUp() {
		$this->validator = new WikiaValidatorUrl();
	}

	/**
	 * @dataProvider urlsDataProvider
	 */
	public function testUrls( $string, $isUrl ) {
		$result = $this->validator->isValid( $string );
		$this->assertEquals( $isUrl, $result );
	}

	public function urlsDataProvider() {
		return [
			[ 'http://www.wikia.com', true ],
			[ 'www.wikia.com', true ],
			[ 'wikia.com', true ],
			[ 'http://www.wikia.com/?action=purge', true ],
			[ 'http://www.wikia.com/#wiki', true ],
			[ 'http://pl.callofduty.wikia.com/wiki/Call_of_Duty:_Black_Ops', true ],
			[ 'https://www.wikia.com/Wikia', true ],
			[ 'www.aol', true ], // this is ok for regexp validation
			[ 'lordoftherings.aol', true ], // this is ok for regexp validation
			[ 'lordoftherings.museum', true ], // this is theoretically an acceptable URL
			[ 'http://www.wikia.xxx', true ], // .xxx is a theoretically valid domain
			[ 'lordoftherings.info', true ],
			[ 'wikia', false ],
			[ 'http://wikia', false ],

		];
	}
}
