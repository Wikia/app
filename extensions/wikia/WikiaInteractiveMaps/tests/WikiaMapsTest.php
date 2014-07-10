<?php
require_once( $IP . '/extensions/wikia/WikiaInteractiveMaps/models/WikiaMaps.class.php' );

class WikiaMapsTest extends WikiaBaseTest {

	/**
	 * @dataProvider getHttpRequestOptionsDataProvider
	 */
	public function testGetHttpRequestOptions( $description, $configMock, $postDataMock, $expected ) {
		$wikiaMaps = new WikiaMaps( $configMock );
		$this->assertEquals( $expected, $wikiaMaps->getHttpRequestOptions( $postDataMock ), $description );
	}

	public function getHttpRequestOptionsDataProvider() {
		return [
			[
				'desc' => 'No config provided (PHP Notice)',
				'config' => [],
				'postData' => [],
				'expected' => [
					'headers' => [
						'Authorization' => ''
					],
					'returnInstance' => true,
				],
			],
			[
				'desc' => 'Config provided',
				'config' => [
					'token' => 'abc123',
				],
				'postData' => [],
				'expected' => [
					'headers' => [
						'Authorization' => 'abc123'
					],
					'returnInstance' => true,
				],
			],
			[
				'desc' => 'config and postData provided',
				'config' => [
					'token' => 'abc123',
				],
				'postData' => [
					'param' => 'value'
				],
				'expected' => [
					'headers' => [
						'Authorization' => 'abc123'
					],
					'postData' => '{"param":"value"}',
					'returnInstance' => true,
				],
			],
			[
				'desc' => 'do not use proxy',
				'config' => [
					'token' => 'abc123',
					'proxy' => false,
				],
				'postData' => [],
				'expected' => [
					'headers' => [
						'Authorization' => 'abc123'
					],
					'returnInstance' => true,
					'noProxy' => true
				],
			],
			[
				'desc' => 'proxy set to true - do not add noProxy',
				'config' => [
					'token' => 'abc123',
					'proxy' => true,
				],
				'postData' => [],
				'expected' => [
					'headers' => [
						'Authorization' => 'abc123'
					],
					'returnInstance' => true
				],
			],
		];
	}

}