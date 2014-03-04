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
		$redirectService = new RedirectService();
		$redirectService->setRedirects($redirects);

		$redirects = $redirectService->getRedirects();

		$this->assertEquals($redirects, $expected);
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
		return array(
			array(
				array(
					'Old title' => 'New title',
					'Other old Title' => 'Other new Title',
					'Wiki/Title' => 'http://muppet.wikia.com'
				),
				'type',
				array(
					'old title' => 'New title',
					'other old title' => 'Other new Title',
					'wiki/title' => 'http://muppet.wikia.com'
				)
			),
			array(
				array(
					'WAM' => array(
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					),
					'HubsV2' => array(
						'Video Games' => 'http://videogames.wikia.com'
					)
				),
				'WAM',
				array(
					'wampagetitle' => 'WAM',
					'wam wikis' => 'WAM wikias'
				)
			),
			array(
				array(),
				'Wam',
				array()
			),
			array(
				array(
					'WAM' => array(
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					),
					'HubsV2' => array(
						'Video Games' => 'http://videogames.wikia.com'
					)
				),
				'hubsV2',
				array(
					'video games' => 'http://videogames.wikia.com'
				)
			),
			array(
				array(
					'WAM' => array(
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					),
					'HubsV2' => array(
						'Video Games' => 'http://videogames.wikia.com'
					)
				),
				'wikia',
				array(
					'wam' => array(
						'wampagetitle' => 'WAM',
						'wam wikis' => 'WAM wikias'
					),
					'hubsv2' => array(
						'video games' => 'http://videogames.wikia.com'
					)
				)
			),
		);
	}

	/**
	 * @dataProvider getRedirectURLDataProvider
	 */
	public function testGetRedirectURL($redirects, $title, $expected) {
		$wgTitleMock = $this->getMock('Title', array('getText'));
		$titleMock = $this->getMock('Title', array('getLocalURL'));

		$redirectMock = $this->getMock('RedirectService', array('getTitleFromText'));
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

		$redirectMock->expects($this->any())
			->method('getRedirects')
			->will($this->returnValue($redirects));

		$this->mockGlobalVariable('wgTitle', $wgTitleMock);

		$redirectURL = $this->getReflectionMethod('getRedirectURL');
		$url = $redirectURL->invoke($redirectMock);

		$this->assertEquals($url, $expected);
	}

	public function getRedirectURLDataProvider() {
		return array(
			array(
				array(
					'Old title' => 'New title',
					'Other old Title' => 'Other new Title',
					'Wiki/Title' => 'http://muppet.wikia.com'
				),
				'Wiki/Title',
				'http://muppet.wikia.com'
			),
			array(
				array(
					'Old title' => 'New title',
					'Other old Title' => 'Other new Title',
					'Wiki/Title' => 'http://muppet.wikia.com'
				),
				'other old Title',
				self::MOCKED_DOMAIN . 'Other_new_Title'
			),
			array(
				array(
					'Old title' => 'New title',
					'Other old Title' => 'Other new Title',
					'Wiki/Title' => 'http://muppet.wikia.com'
				),
				'not existing Title',
				null
			)
		);
	}

	private function getFakeUrlFromTitle($title) {
		return self::MOCKED_DOMAIN . str_replace(' ', '_', $title);
	}

	/**
	 * @dataProvider getRedirectsDataProvider
	 */
	public function testPrepareRedirects($redirects, $expected) {
		$redirectService = new RedirectService();
		$redirectService->setRedirects($redirects);

		$prepare = $this->getReflectionMethod( 'prepareRedirects' );

		$preparedRedirects = $prepare->invoke($redirectService);

		$this->assertEquals($preparedRedirects, $expected);
	}

	public function getRedirectsDataProvider() {
		return array(
			array(
				array(
					'Old title' => 'New title',
					'Other old Title' => 'Other new Title',
					'Wiki/Title' => 'http://muppet.wikia.com'
				),
				array(
					'old title' => 'New title',
					'other old title' => 'Other new Title',
					'wiki/title' => 'http://muppet.wikia.com'
				)
			),
			array(
				array(
					'WAM' => array(
						'WamPageTitle' => 'WAM',
						'WAM wikis' => 'WAM wikias'
					),
					'HubsV2' => array(
						'Video Games' => 'http://videogames.wikia.com'
					)
				),
				array(
					'wam' => array(
						'wampagetitle' => 'WAM',
						'wam wikis' => 'WAM wikias'
					),
					'hubsv2' => array(
						'video games' => 'http://videogames.wikia.com'
					)
				)
			),
			array(
				array(),
				array()
			)
		);
	}
}
