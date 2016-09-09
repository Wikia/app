<?php

class DesignSystemSharedLinksTest extends WikiaBaseTest {

	/**
	 * @dataProvider getHrefDataProvider
	 *
	 * @param $lang language code to fetch
	 * @param $hrefs hrefs definition in different languages
	 * @param $expectedResult
	 */
	public function testGetHref( $lang, $hrefs, $expectedResult ) {
		DesignSystemSharedLinks::getInstance()->setHrefs( $hrefs );

		$result = DesignSystemSharedLinks::getInstance()->getHref( 'create-new-wiki', $lang );

		$this->assertEquals( $result, $expectedResult );
	}

	public function getHrefDataProvider() {
		return [
			[
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
		];
	}
}
