<?php

	class WikiaForceBaseDomainTest extends WikiaBaseTest {
		/**
		 * @dataProvider getUrlProvider
		 *
		 * @param $url string source url
		 * @param $targetServer string target wiki url
		 * @param $env string source enironment to mock
		 * @param $expectedResult string
		 * @throws Exception
		 */
		public function testGetHref( $url, $targetServer, $env, $expectedResult ) {
			$this->mockEnvironment( $env );

			$result = wfForceBaseDomain( $url, $targetServer );

			$this->unsetGlobals();
			$this->assertEquals( $expectedResult, $result );
		}

		public function getUrlProvider() {
			return [
				[
					'https://www.wikia.com/signin',
					'https://muppet.wikia.com',
					WIKIA_ENV_PROD,
					'https://www.wikia.com/signin'
				],
				[
					'https://www.fandom.com/signin',
					'https://muppet.fandom.com',
					WIKIA_ENV_PROD,
					'https://www.fandom.com/signin'
				],
				[
					'https://www.wikia.com/signin',
					'https://muppet.wikia.org',
					WIKIA_ENV_PROD,
					'https://www.wikia.org/signin'
				],
				[
					'https://www.fandom.com/signin',
					'https://muppet.wikia.org',
					WIKIA_ENV_PROD,
					'https://www.wikia.org/signin'
				],
				[
					'https://www.mockdevname.wikia-dev.pl/signin',
					'https://muppet.mockdevname.wikia-dev.us',
					WIKIA_ENV_DEV,
					'https://www.mockdevname.wikia-dev.pl/signin'
				],
				[
					'https://www.mockdevname.wikia-dev.us/signin',
					'https://muppet.mockdevname.fandom-dev.us',
					WIKIA_ENV_DEV,
					'https://www.mockdevname.fandom-dev.us/signin'
				],
				[
					'https://www.mockdevname.wikia-dev.us/signin',
					'https://muppet.mockdevname.wikia-dev.us',
					WIKIA_ENV_DEV,
					'https://www.mockdevname.wikia-dev.us/signin'
				],
				[
					'https://www.mockdevname.fandom-dev.us/signin',
					'https://muppet.mockdevname.wikia-dev.us',
					WIKIA_ENV_DEV,
					'https://www.mockdevname.wikia-dev.us/signin'
				],
				[
					'https://www.mockdevname.fandom-dev.us/signin',
					'https://muppet.mockdevname.fandom-dev.us',
					WIKIA_ENV_DEV,
					'https://www.mockdevname.fandom-dev.us/signin'
				],
			];
		}
}
