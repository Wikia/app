<?php

class RedirectServiceTest extends WikiaBaseTest {
	const MOCKED_DOMAIN = 'http://mocked.wikia.com/';

	public function setUp() {
		include_once(realpath( dirname(__FILE__) . '/../RedirectService.class.php'));
		parent::setUp();
	}

	protected function getReflectionMethod ($name) {
		$class = new ReflectionClass('RedirectService');
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method;
	}

	/**
	 * @dataProvider getRedirectsDataProvider
	 */
	public function testGetRedirects($redirects, $expected) {
		$redirectService = new RedirectService(null);
		$redirectService->setRedirects($redirects);

		$redirects = $redirectService->getRedirects();

		$this->assertEquals($expected, $redirects);
	}

	/**
	 * @dataProvider getRedirectsForPageTypeDataProvider
	 */
	public function testGetRedirectWithPageType($redirects, $pageType, $expected) {
		$redirectService = new RedirectService($pageType);
		$redirectService->setRedirects($redirects);

		$redirects = $redirectService->getRedirects();

		$this->assertEquals($redirects, $expected);
	}

	public function getRedirectsForPageTypeDataProvider() {
		return [
			[
				[
					'Old title' => 'New title',
					'Other old Title' => 'Other new Title',
					'Wiki/Title' => 'http://muppet.wikia.com'
				],
				'type',
				[]
			],
			[
				[
					'WAM' => [
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					],
					'HubsV2' => [
						'Video Games' => 'http://videogames.wikia.com'
					]
				],
				'WAM',
				[
					'wampagetitle' => 'WAM',
					'wam wikis' => 'WAM wikias'
				]
			],
			[
				[],
				'Wam',
				[]
			],
			[
				[
					'WAM' => [
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					],
					'HubsV2' => [
						'Video Games' => 'http://videogames.wikia.com'
					]
				],
				'hubsV2',
				[
					'video games' => 'http://videogames.wikia.com'
				]
			],
			[
				[
					'WAM' => [
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					],
					'HubsV2' => [
						'Video Games' => 'http://videogames.wikia.com'
					]
				],
				'wikia',
				[]
			]
		];
	}

	/**
	 * @dataProvider getRedirectURLDataProvider
	 */
	public function testGetRedirectURL($redirects, $title, $expected) {
		$wgTitleMock = $this->getMock('Title', ['getText']);
		$titleMock = $this->getMock('Title', ['getLocalURL']);

		$redirectMock = $this->getMockBuilder('RedirectService')
			->setConstructorArgs(['test'])
			->setMethods(['getTitleFromText'])
			->getMock();

		$redirectMock->setRedirects($redirects);

		$redirects = $redirectMock->getRedirects();

		$wgTitleMock->expects($this->any())
			->method('getText')
			->will($this->returnValue($title));

		$titleLower = mb_strtolower($title);

		if ( isset( $redirects[$titleLower] ) ) {
			$titleMock->expects($this->any())
				->method('getLocalURL')
				->will($this->returnValue($this->getFakeUrlFromTitle($redirects[$titleLower])));
		}

		$redirectMock->expects($this->any())
			->method('getTitleFromText')
			->will($this->returnValue($titleMock));

		$this->mockGlobalVariable('wgTitle', $wgTitleMock);

		$redirectURL = $this->getReflectionMethod('getRedirectURL');
		$url = $redirectURL->invoke($redirectMock);

		$this->assertEquals($url, $expected);
	}

	public function getRedirectURLDataProvider() {
		return [
			[
				[
					'test' => [
						'Old title' => 'New title',
						'Other old Title' => 'Other new Title',
						'Wiki/Title' => 'http://muppet.wikia.com'
					]
				],
				'other old Title',
				self::MOCKED_DOMAIN . 'Other_new_Title'
			],
			[
				[
					'test' => [
						'Old title' => 'New title',
						'Other old Title' => 'Other new Title',
						'Wiki/Title' => 'http://muppet.wikia.com'
					]
				],
				'not existing Title',
				null
			]
		];
	}

	private function getFakeUrlFromTitle($title) {
		return self::MOCKED_DOMAIN . str_replace(' ', '_', $title);
	}

	/**
	 * @dataProvider getRedirectsDataProvider
	 */
	public function testPrepareRedirects($redirects, $expected) {
		$redirectService = new RedirectService('wam');
		$redirectService->setRedirects($redirects);

		$prepare = $this->getReflectionMethod( 'prepareRedirects' );

		$preparedRedirects = $prepare->invoke($redirectService);

		$this->assertEquals($expected, $preparedRedirects);
	}

	public function getRedirectsDataProvider() {
		return [
			[
				[
					'WAM' => [
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					],
					'HubsV2' => [
						'Video Games' => 'http://videogames.wikia.com'
					]
				],
				[
					'wam' => [
						'wampagetitle' => 'WAM',
						'wam wikis' => 'WAM wikias'
					],
					'hubsv2' => [
						'video games' => 'http://videogames.wikia.com'
					]
				]
			],
			[
				[],
				[]
			]
		];
	}
}
