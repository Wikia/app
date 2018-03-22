<?php

class DesignSystemSharedLinksTest extends WikiaBaseTest {

	/**
	 * @dataProvider getHrefDataProvider
	 *
	 * @param $lang language code to fetch
	 * @param $hrefs hrefs definition in different languages
	 * @param $expectedResult
	 */
	public function testGetHref( $environment, $lang, $hrefs, $expectedResult ) {
		$this->mockEnvironment( $environment );

		DesignSystemSharedLinks::getInstance()->setHrefs( $hrefs );

		$result = DesignSystemSharedLinks::getInstance()->getHref( 'create-new-wiki', $lang );

		$this->assertEquals( $expectedResult, $result );
	}

	public function getHrefDataProvider() {
		return [
			[
				WIKIA_ENV_PROD,
				'pl',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => 'http://www.example.com'
					],
					'pl' => [
						'create-new-wiki' => 'http://www.wikia.pl'
					],
				],
				'http://www.wikia.pl'
			],
			[
				WIKIA_ENV_PROD,
				'pl',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => 'http://www.example.com'
					],
					'pl' => [ ],
				],
				'http://www.example.com'
			],
			[
				WIKIA_ENV_PROD,
				'pl',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => null
					],
					'pl' => [ ],
				],
				null
			],
			[
				WIKIA_ENV_PROD,
				'en',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => null
					],
					'pl' => [ ],
				],
				'http://www.wikia.com'
			],
			[
				WIKIA_ENV_PROD,
				'pt',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => null
					],
					'pt-br' => [
						'create-new-wiki' => 'http://pt-br.wikia.com'
					],
				],
				'http://pt-br.wikia.com'
			],
			[
				WIKIA_ENV_PROD,
				'pt',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => null
					],
					'pt-br' => [ ],
				],
				null
			],
			[
				WIKIA_ENV_PROD,
				'pt',
				[
					'en' => [
						'create-new-wiki' => 'http://www.wikia.com'
					],
					'default' => [
						'create-new-wiki' => null
					],
				],
				null
			],
			[
				WIKIA_ENV_PREVIEW,
				'en',
				[
					'en' => [
						'create-new-wiki' => 'http://fallout.wikia.com/wiki/test'
					]
				],
				'http://fallout.preview.wikia.com/wiki/test'
			],
			[
				WIKIA_ENV_STAGING,
				'en',
				[
					'en' => [
						'create-new-wiki' => 'http://fallout.wikia.com/wiki/test'
					]
				],
				'http://fallout.wikia-staging.com/wiki/test'
			],
			[
				WIKIA_ENV_DEV,
				'en',
				[
					'en' => [
						'create-new-wiki' => 'http://fallout.wikia.com/wiki/test'
					]
				],
				'http://fallout.' . static::MOCK_DEV_NAME . '.wikia-dev.us/wiki/test'
			],
		];
	}
}
