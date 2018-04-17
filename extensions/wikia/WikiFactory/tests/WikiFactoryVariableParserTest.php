<?php

use PHPUnit\Framework\TestCase;

class WikiFactoryVariableParserTest extends TestCase {

	private function newWikiFactoryVariableParser( string $varType ): WikiFactoryVariableParser {
		return new WikiFactoryVariableParser( $varType );
	}

	/**
	 * @dataProvider provideValidValues
	 *
	 * @param string $varType
	 * @param $value
	 * @param $expectedOutput
	 *
	 * @throws WikiFactoryVariableParseException
	 */
	public function testValueValid( string $varType, $value, $expectedOutput ) {
		$this->assertEquals(
			$expectedOutput,
			$this->newWikiFactoryVariableParser( $varType )->transformValue( $value )
		);
	}

	public function provideValidValues() {
		yield [ 'integer', 5, 5 ];
		yield [ 'integer', '56', 56 ];
		yield [ 'boolean', 1, true ];
		yield [ 'boolean', 0, false ];
		yield [ 'array', [ 'an array' ], [ 'an array' ] ];
		yield [ 'array', [ 'a' => 'hashmap' ], [ 'a' => 'hashmap' ] ];
		yield [ 'array', [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ], [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ] ];
		yield [ 'struct', [ 'an array' ] , [ 'an array' ] ];
		yield [ 'struct', [ 'a' => 'hashmap' ], [ 'a' => 'hashmap' ] ];
		yield [ 'struct', [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ], [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ] ];
		yield [ 'hash', [ 'an array' ], [ 'an array' ] ];
		yield [ 'hash', [ 'a' => 'hashmap' ], [ 'a' => 'hashmap' ] ];
		yield [ 'hash', [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ], [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ] ];
		yield [ 'array', '["an array"]', [ 'an array' ] ];
		yield [ 'array', '{"a":"hashmap"}', [ 'a' => 'hashmap' ] ];
		yield [ 'array', '{"a":{"nested":{"structure": ["items"]}}}', [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ] ];
		yield [ 'struct', '["an array"]', [ 'an array' ] ];
		yield [ 'struct', '{"a":"hashmap"}', [ 'a' => 'hashmap' ] ];
		yield [ 'struct', '{"a":{"nested":{"structure": ["items"]}}}', [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ] ];
		yield [ 'hash', '["an array"]', [ 'an array' ] ];
		yield [ 'hash', '{"a":"hashmap"}', [ 'a' => 'hashmap' ] ];
		yield [ 'hash', '{"a":{"nested":{"structure": ["items"]}}}', [ 'a' => [ 'nested' => [ 'structure' => [ 'items'] ] ] ] ];
	}

	/**
	 * @dataProvider provideNotValidValues
	 *
	 * @param string $varType
	 * @param $value
	 * @param string $expectedErrorMessage
	 *
	 * @throws WikiFactoryVariableParseException
	 */
	public function testExceptionWhenValueNotValid( string $varType, $value, string $expectedErrorMessage ) {
		$this->expectException( WikiFactoryVariableParseException::class );
		$this->expectExceptionMessage( $expectedErrorMessage );

		$this->newWikiFactoryVariableParser( $varType )->transformValue( $value );
	}

	public function provideNotValidValues() {
		yield [ 'integer', 'yak yak', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_INTEGER ];
		yield [ 'integer', '["an array"]', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_INTEGER ];
		yield [ 'integer', '{"a": "hashmap"}', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_INTEGER ];
		yield [ 'boolean', 'karamba', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 'boolean', 5, WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 'boolean', 'karamba', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 'boolean', '["an array"]', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 'boolean', '{"a":"hashmap"}', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 'array', 5, WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'array', 'test', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'array', null, WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'struct', 5, WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'struct', 'test', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'struct', null, WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'hash', 5, WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'hash', 'test', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 'hash', null, WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
	}
}
