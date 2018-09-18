<?php

use PHPUnit\Framework\TestCase;

class UsePrimaryDomainInUrlTest extends TestCase
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
		$model = $this->createPartialMock(DesignSystemGlobalNavigationModelV2::class, ['getDomainForCityId', 'getDevDomain']);
		$model->expects($this->atMost(1))->method('getDomainForCityId')->with($cityId)->willReturn($server);
		$model->expects($this->atMost(1))->method('getDevDomain')->willReturn($devDomain);

		$result = $model->usePrimaryDomainInUrl( $url, $cityId );

		$this->assertEquals( $expectedResult, $result );
	}

	public function getUrlProvider() {
		return [
			[
				'https://muppet.wikia.com',						// server
				'',												// devDomain
				'https://www.wikia.com/signin',					// url
				null,											// cityId
				'https://www.wikia.com/signin'					// expectedResult

			],
			[
				'https://muppet.fandom.com',					// server
				'',												// devDomain
				'https://www.wikia.com/signin',					// url
				null,											// cityId
				'https://www.fandom.com/signin'					// expectedResult

			],
			[
				'https://muppet.wladek.wikia-dev.pl',			// server
				'wladek.wikia-dev.pl',							// devDomain
				'https://www.wikia.com/signin',					// url
				null,											// cityId
				'https://www.wladek.wikia-dev.pl/signin'		// expectedResult

			],
			[
				'https://muppet.wladek.fandom-dev.pl',			// server
				'wladek.fandom-dev.pl',							// devDomain
				'https://www.wikia.com/signin',					// url
				null,											// cityId
				'https://www.wladek.fandom-dev.pl/signin'		// expectedResult

			],
			[
				'https://muppet.wladek.wikia-dev.us',			// server
				'wladek.wikia-dev.us',							// devDomain
				'https://www.wikia.com/signin',					// url
				null,											// cityId
				'https://www.wladek.wikia-dev.us/signin'		// expectedResult

			],
			[
				'https://muppet.wladek.fandom-dev.us',			// server
				'wladek.fandom-dev.us',							// devDomain
				'https://www.wikia.com/signin',					// url
				null,											// cityId
				'https://www.wladek.fandom-dev.us/signin'		// expectedResult

			],
		];
	}
}
