<?php
require_once( $IP . '/extensions/wikia/WikiaMaps/models/WikiaMaps.class.php' );

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
				'desc' => 'No config provided',
				'config' => [],
				'postData' => [],
				'expected' => [
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
					'httpProxy' => false,
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
					'httpProxy' => true,
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

	/**
	 * @dataProvider shouldHideAttributionDataProvider
	 */
	public function testShouldHideAttribution( $description, $wgCityId, $mapCityId, $expected ) {
		$wikiaMaps = new WikiaMaps( [] );
		$this->mockGlobalVariable( 'wgCityId', $wgCityId );
		$this->assertEquals( $expected, $wikiaMaps->shouldHideAttribution( $mapCityId ), $description );
	}

	public function shouldHideAttributionDataProvider() {
		return [
			[
				'the same ids - SHOULD hide',
				123,
				123,
				true
			],
			[
				'different ids - SHOULD NOT hide',
				123,
				124,
				false
			],
			[
				'id passed as a string passed but the same - SHOULD hide',
				'124',
				124,
				true
			],
			[
				'id passed as a string passed and it\'s different the same - SHOULD NOT hide',
				'125',
				124,
				false
			],
		];
	}

}
