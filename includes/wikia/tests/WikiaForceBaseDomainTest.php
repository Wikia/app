<?php

	class WikiaForceBaseDomainTest extends WikiaBaseTest {
		/**
		 * @dataProvider getUrlProvider
		 *
		 * @param $server
		 * @param $wikiaDevDomain
		 * @param $fandomDevDomain
		 * @param $url string source url
		 * @param $expectedResult string
		 * @throws Exception
		 */
		public function testGetHref( $server, $wikiaDevDomain, $fandomDevDomain, $url, $expectedResult ) {
			$this->mockGlobalVariable( 'wgWikiaDevDomain', $wikiaDevDomain);
			$this->mockGlobalVariable( 'wgFandomDevDomain', $fandomDevDomain);
			$this->mockGlobalVariable( 'wgDevelEnvironment', $wikiaDevDomain !== '' );

			$result = wfForceBaseDomain( $url, $server );

			$this->unsetGlobals();
			$this->assertEquals( $expectedResult, $result );
		}

		public function getUrlProvider() {
			return [
				[
					'https://muppet.wikia.com',
					'',
					'',
					'https://www.wikia.com/signin',
					'https://www.wikia.com/signin'
				],
				[
					'https://muppet.fandom.com',
					'',
					'',
					'https://www.fandom.com/signin',
					'https://www.fandom.com/signin'
				],
				[
					'https://muppet.wladek.wikia-dev.pl',
					'wladek.wikia-dev.pl',
					'wladek.fandom-dev.pl',
					'https://www.wladek.wikia-dev.pl/signin',
					'https://www.wladek.wikia-dev.pl/signin'
				],
				[
					'https://muppet.wladek.fandom-dev.pl',
					'wladek.wikia-dev.pl',
					'wladek.fandom-dev.pl',
					'https://www.wladek.wikia-dev.pl/signin',
					'https://www.wladek.fandom-dev.pl/signin'
				],
				[
					'https://muppet.wladek.wikia-dev.us',
					'wladek.wikia-dev.us',
					'wladek.fandom-dev.us',
					'https://www.wladek.wikia-dev.us/signin',
					'https://www.wladek.wikia-dev.us/signin'
				],
				[
					'https://muppet.wladek.fandom-dev.us',
					'wladek.wikia-dev.us',
					'wladek.fandom-dev.us',
					'https://www.wladek.wikia-dev.us/signin',
					'https://www.wladek.fandom-dev.us/signin'
				],
			];
		}
}
