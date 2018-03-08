<?php

class ApiWikiFactoryRemoveVariableIntegrationTest extends WikiaDatabaseTest {
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
				'action' => 'wfremovevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'reason' => 'bar',
				'token' => EDIT_TOKEN_SUFFIX
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEmpty( $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'permissiondenied', $e->getCodeString() );
			throw $e;
		}
	}

	public function testAccessDeniedForUnauthorizedUser() {
		$this->expectException( UsageException::class );

		$this->setupRequestUser( static::NON_STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		try {
			$this->doApiRequest( [
				'action' => 'wfremovevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'reason' => 'bar',
				'token' => $this->getTokenHash( static::VALID_TOKEN )
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEmpty( 'foo', $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'permissiondenied', $e->getCodeString() );
			throw $e;
		}
	}

	public function testAccessDeniedForAuthorizedUserIfTokenNotSet() {
		$this->expectException( UsageException::class );

		$this->setupRequestUser( static::STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		try {
			$this->doApiRequest( [
				'action' => 'wfremovevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'reason' => 'bar',
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEmpty( 'foo', $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'notoken', $e->getCodeString() );
			throw $e;
		}
	}

	public function testAccessDeniedForAuthorizedUserIfTokenDoesNotMatch() {
		$this->expectException( UsageException::class );

		$this->setupRequestUser( static::STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		try {
			$this->doApiRequest( [
				'action' => 'wfremovevariable',
				'variable_id' => 1,
				'wiki_id' => 1,
				'reason' => 'bar',
				'token' => 'bad token'
			] );
		} catch ( UsageException $e ) {
			$this->assertNotEmpty( 'foo', $this->getVariable( 1, 1 ) );
			$this->assertEquals( 'badtoken', $e->getCodeString() );
			throw $e;
		}
	}

	public function testAuthorizedUserCanDeleteVariable() {
		$this->setupRequestUser( static::STAFF_USER_ID )->withExpectedToken( static::VALID_TOKEN );

		$this->doApiRequest( [
			'action' => 'wfremovevariable',
			'variable_id' => 1,
			'wiki_id' => 1,
			'reason' => 'something',
			'token' => $this->getTokenHash( static::VALID_TOKEN )
		] );

		$this->assertNull( WikiFactory::getVarById( 1, 1 )->cv_value );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/api_variable.yaml' );
	}
}
