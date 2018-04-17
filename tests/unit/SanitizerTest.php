<?php

use PHPUnit\Framework\TestCase;

class SanitizerTest extends TestCase {
	/**
	 * @dataProvider provideValidContentEditableValues
	 * @param $value
	 */
	public function testContentEditableValid( $value ) {
		$attributes = Sanitizer::validateAttributes( [ 'contenteditable' => $value ], [ 'contenteditable' ] );

		$this->assertArrayHasKey( 'contenteditable', $attributes );
		$this->assertEquals( $value, $attributes['contenteditable'] );
	}

	public function provideValidContentEditableValues(): Generator {
		yield [ 'true' ];
		yield [ 'false' ];
	}

	/**
	 * @dataProvider provideBadContentEditableValues
	 * @param $value
	 */
	public function testContentEditableInvalid( $value ) {
		$attributes = Sanitizer::validateAttributes( [ 'contenteditable' => $value ], [ 'contenteditable' ] );

		$this->assertArrayNotHasKey( 'contenteditable', $attributes );
	}

	public function provideBadContentEditableValues(): Generator {
		yield [ 'TRUE' ];
		yield [ 'FALSE' ];
		yield [ false ];
		yield [ true ];
		yield [ 0 ];
		yield [ 'karamba' ];
	}
}
