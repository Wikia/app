<?php

/**
 * @group Integration
 */
class ApiWikiFactorySaveVariableIntegrationTest extends WikiaDatabaseTest {
	use ApiIntegrationTestTrait;

	const VALID_TOKEN = 'some token';
	const STAFF_USER_ID = 3896;
	const NON_STAFF_USER_ID = 9425;

	private function getVariable( int $varId, int $wikiId ) {
		$var = WikiFactory::getVarById( $varId, $wikiId );

		return unserialize( $var->cv_value, [ 'allowed_classes' => false ] );
	}

	public function testAccessDeniedForUnauthenticatedUser() {
		$this->expectException( UsageException::class );

		// make sure we're really considered to be an anonymous user
		session_abort();

		try {
			$this->doApiRequest( [
				'action' => 'wfsavevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'variable_value' => 'foo',
				'reason' => 'bar',
				'token' => EDIT_TOKEN_SUFFIX
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEquals( 'foo', $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'permissiondenied', $e->getCodeString() );
			throw $e;
		}
	}

	public function testAccessDeniedForUnauthorizedUser() {
		$this->expectException( UsageException::class );

		$this->setupRequestUser( static::NON_STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		try {
			$this->doApiRequest( [
				'action' => 'wfsavevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'variable_value' => 'foo',
				'reason' => 'bar',
				'token' => $this->getTokenHash( static::VALID_TOKEN )
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEquals( 'foo', $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'permissiondenied', $e->getCodeString() );
			throw $e;
		}
	}

	public function testAccessDeniedForAuthorizedUserIfTokenNotSet() {
		$this->expectException( UsageException::class );

		$this->setupRequestUser( static::STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		try {
			$this->doApiRequest( [
				'action' => 'wfsavevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'variable_value' => 'foo',
				'reason' => 'bar',
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEquals( 'foo', $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'notoken', $e->getCodeString() );
			throw $e;
		}
	}

	public function testAccessDeniedForAuthorizedUserIfTokenDoesNotMatch() {
		$this->expectException( UsageException::class );

		$this->setupRequestUser( static::STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		try {
			$this->doApiRequest( [
				'action' => 'wfsavevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'variable_value' => 'foo',
				'reason' => 'bar',
				'token' => 'bad token'
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEquals( 'foo', $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'badtoken', $e->getCodeString() );
			throw $e;
		}
	}

	/**
	 * @dataProvider provideValidVariables
	 *
	 * @param $varId
	 * @param $wikiId
	 * @param $value
	 * @param $reason
	 * @param $expected
	 */
	public function testAuthorizedUserCanSaveValidVariable( $varId, $wikiId, $value, $reason, $expected ) {
		$this->setupRequestUser( static::STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		$this->doApiRequest( [
			'action' => 'wfsavevariable',
			'variable_id' => $varId,
			'wiki_id' => $wikiId,
			'variable_value' => $value,
			'reason' => $reason,
			'token' => $this->getTokenHash( static::VALID_TOKEN )
		] );

		$this->assertEquals( $expected, $this->getVariable( $varId, $wikiId ) );
	}

	public function provideValidVariables() {
		yield [ 1, 1, 'foo', 'test set', 'foo' ];
		yield [ 2, 2, 0, 'test set', false ];
		yield [ 2, 2, 1, null, true ];
		yield [ 2, 2, '0', 'test set', false ];
		yield [ 2, 2, '1', null, true ];
		yield [ 3, 3, 15, 'test set', 15 ];
		yield [ 3, 3, '160', 'test set', 160 ];
		yield [ 4, 4, '["an array"]', 'test set', [ 'an array' ] ];
		yield [ 4, 4, '{"a":"hashmap"}', 'test set', [ 'a' => 'hashmap' ] ];
		yield [ 4, 4, '{"some":{"nested":"value"}}', null, [ 'some' => [ 'nested' => 'value' ] ] ];
	}

	/**
	 * @dataProvider provideNotValidVariables
	 *
	 * @param $varId
	 * @param $wikiId
	 * @param $value
	 * @param $reason
	 * @param $expected
	 *
	 * @throws UsageException
	 */
	public function testAuthorizedUserCannotSaveNotValidVariable( $varId, $wikiId, $value, $reason, $expected ) {
		$this->expectException( UsageException::class );
		$this->expectExceptionCode( 400 );
		$this->expectExceptionMessage( $expected );

		$this->setupRequestUser( static::STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		try {
			$this->doApiRequest( [
				'action' => 'wfsavevariable',
				'variable_id' => $varId,
				'wiki_id' => $wikiId,
				'variable_value' => $value,
				'reason' => $reason,
				'token' => $this->getTokenHash( static::VALID_TOKEN )
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEquals( $value, $this->getVariable( $varId, $wikiId ) );
			$this->assertEquals( 'invalid_value', $e->getCodeString() );
			throw $e;
		}
	}

	public function provideNotValidVariables() {
		yield [ 2, 2, 'karamba', 'test set', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 2, 2, 5, 'test set', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 2, 2, 5, '{"a":"b"}', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN ];
		yield [ 3, 3, 'yak', 'test set', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_INTEGER ];
		yield [ 3, 3, '["something"]', 'test set', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_INTEGER ];
		yield [ 4, 4, 'foo', 'test set', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
		yield [ 4, 4, 12, 'test set', WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/api_variable.yaml' );
	}
}
