<?php

class UseWikiBaseDomainInUrlTest extends WikiaBaseTest
{
	/**
	 * @dataProvider getUrlProvider
	 *
	 * @param $server
	 * @param $devDomain
	 * @param $url string source url
	 * @param $cityId mixed Wiki Id
	 * @param $expectedResult string
	 */
	public function testGetHref( $server, $devDomain, $url, $cityId, $expectedResult ) {
		$model = new DesignSystemGlobalNavigationModelV2(DesignSystemGlobalFooterModel::PRODUCT_WIKIS, 1 );
		$this->mockGlobalVariable('wgServer', $server);
		$this->mockGlobalVariable( 'wgDevDomain', $devDomain );

		$result = $model->useWikiBaseDomainInUrl( $url, $cityId );

		$this->unsetGlobals();
		$this->assertEquals( $expectedResult, $result );
	}

	public function getUrlProvider() {
		return [
			[
				'https://muppet.wikia.com',
				'',
				'https://www.wikia.com/signin',
				null,
				'https://www.wikia.com/signin'

			],
			[
				'https://muppet.fandom.com',
				'',
				'https://www.wikia.com/signin',
				null,
				'https://www.fandom.com/signin'

			],
			[
				'https://muppet.wladek.wikia-dev.pl',
				'wladek.wikia-dev.pl',
				'https://www.wikia.com/signin',
				null,
				'https://www.wladek.wikia-dev.pl/signin'

			],
			[
				'https://muppet.wladek.fandom-dev.pl',
				'wladek.fandom-dev.pl',
				'https://www.wikia.com/signin',
				null,
				'https://www.wladek.fandom-dev.pl/signin'

			],
			[
				'https://muppet.wladek.wikia-dev.us',
				'wladek.wikia-dev.us',
				'https://www.wikia.com/signin',
				null,
				'https://www.wladek.wikia-dev.us/signin'

			],
			[
				'https://muppet.wladek.fandom-dev.us',
				'wladek.fandom-dev.us',
				'https://www.wikia.com/signin',
				null,
				'https://www.wladek.fandom-dev.us/signin'

			],
		];
	}
}
