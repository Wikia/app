<?php

class UrlHelpersTest extends WikiaBaseTest {

	/**
	 * @dataProvider normalizeHostDataProvider
	 */
	public function testNormalizeHost( $environment, $host, $expected ) {
		$this->mockEnvironment( $environment );
		$url = wfNormalizeHost( $host );
		$this->assertEquals( $expected, $url );
	}

	public function normalizeHostDataProvider() {
		return [
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'http://muppet.' . static::MOCK_DEV_NAME . '.wikia-dev.us',
				'expected' => 'http://muppet.wikia.com'
			],
			[
				'env' => WIKIA_ENV_DEV,
				'url' => 'https://muppet.' . static::MOCK_DEV_NAME . '.fandom-dev.us',
				'expected' => 'https://muppet.fandom.com'
			],
		];
	}
}
