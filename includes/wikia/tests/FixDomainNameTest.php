<?php
/**
 * @group FixDomainName
 */
class FixDomainNameTest extends WikiaBaseTest {

	/**
	 * @dataProvider fixDomainNameDataProvider
	 */
	public function testFixDomainName( $env, $name, $language, $expected ) {
		$this->mockEnvironment($env);
		$this->assertEquals( $expected, Wikia::fixDomainName( $name, $language ) );
	}

	public function fixDomainNameDataProvider() {
		return [
			[
				'env' => WIKIA_ENV_PROD,
				'name' => 'foo',
				'language' => 'en',
				'execpted' => 'foo.wikia.com'
			],
			[
				'env' => WIKIA_ENV_PROD,
				'name' => 'foo',
				'language' => 'pl',
				'execpted' => 'pl.foo.wikia.com'
			],
			# staging
			[
				'env' => WIKIA_ENV_STAGING,
				'name' => 'foo',
				'language' => 'en',
				'execpted' => 'foo.wikia-staging.com'
			],
			[
				'env' => WIKIA_ENV_STAGING,
				'name' => 'foo',
				'language' => 'pl',
				'execpted' => 'pl.foo.wikia-staging.com'
			],
			# lowercasing
			[
				'env' => WIKIA_ENV_PROD,
				'name' => 'FooBar',
				'language' => 'en',
				'execpted' => 'foobar.wikia.com'
			],
			# if there's a not, do not make any changes
			[
				'env' => WIKIA_ENV_PROD,
				'name' => 'foo-bar.wikia.com',
				'language' => 'en',
				'execpted' => 'foo-bar.wikia.com'
			],
		];
	}
}
