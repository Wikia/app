<?php

/**
 * Class WikiaMobileServiceTest
 * Test if corresponding function handles each specific part of skin
 */
class WikiaMobileServiceTest extends WikiaBaseTest {

	/**
	 * @var $wikiaMobileService WikiaMobileService
	 */
	private $wikiaMobileService;

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../WikiaMobile.setup.php';

		$this->wikiaMobileService = new WikiaMobileService();
		parent::setUp();
	}

	public function testPublicApi()
	{
		$this->assertTrue( method_exists( $this->wikiaMobileService, 'init' ) );
		$this->assertTrue( method_exists( $this->wikiaMobileService, 'index' ) );
	}

	public function testInit()
	{
		$this->wikiaMobileService->init();

		$this->assertAttributeEquals( RequestContext::getMain()->getSkin(), 'skin', $this->wikiaMobileService );
		$this->assertAttributeEquals( $this->app->getSkinTemplateObj(), 'templateObject', $this->wikiaMobileService );
		$this->assertAttributeEquals( AssetsManager::getInstance(), 'assetsManager', $this->wikiaMobileService );
	}
}