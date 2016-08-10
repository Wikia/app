<?php

class JSMessagesTest extends WikiaBaseTest {
	const TEST_PACKAGE = 'test';
	const TEST2_PACKAGE = 'test2';

	const MESSAGES = [
		'a-message' => 'foo',
		'a-different-message' => 'bar',
		'a-set-of-wildcard-messages-like-this' => 'test',
		'a-set-of-wildcard-messages-like-that' => 'testing',
		'an-unrelated-message' => 'more testing',
	];

	public function setUp() {
		$this->setupFile = __DIR__ . '/../JSMessages_setup.php';

		parent::setUp();

		$languageMock = $this->getMock( Language::class, [ 'getCode', 'getAllMessageKeys' ] );
		$languageMock->expects( $this->any() )
			->method( 'getCode' )
			->willReturn( 'en' );

		$languageMock->expects( $this->any() )
			->method( 'getAllMessageKeys' )
			->willReturn( [
				'messages' => array_keys( static::MESSAGES )
			] );

		$this->mockGlobalVariable( 'wgLang', $languageMock );
		$this->mockClass( Language::class, $languageMock, 'factory' );

		// Clear any packages set or queued by extensions in setup files, and delete message keys from in-object cache
		JSMessages::flushData();
	}

	/**
	 * @dataProvider registeringResourceLoaderModuleDataProvider
	 * @covers JSMessages::registerPackage
	 * @covers JSMessages::onResourceLoaderRegisterModule
	 * @param array $packageMessages Array of message keys this package will contain
	 * @param array $expectedMessage Array of message keys the generated ResourceLoader module is expected to contain
	 */
	public function testRegisteringResourceLoaderModule( $packageMessages, $expectedMessage ) {
		$resourceLoader = new ResourceLoader();

		JSMessages::registerPackage( static::TEST_PACKAGE, $packageMessages );
		JSMessages::onResourceLoaderRegisterModules( $resourceLoader );

		/** @var ResourceLoaderFileModule $module */
		$module = $resourceLoader->getModule( JSMessages::RL_MODULE_PREFIX . static::TEST_PACKAGE );
		$this->assertInstanceOf( ResourceLoaderFileModule::class, $module );

		$messages = $module->getMessages();
		$this->assertEquals( $expectedMessage, $messages );
	}

	/**
	 * @dataProvider addingModulesToOutputDataProvider
	 * @covers JSMessages::onBeforePageDisplay
	 * @covers JSMessages::enqueuePackage
	 * @param array $packages array of packages
	 * Each package is an array containing the package name and array of its message keys
	 * @param array $toEnqueue array of package names to be added to output
	 * @param array $shouldBeAdded array of ResourceLoader module names that are expected to be present in the output
	 */
	public function testAddingModulesToOutput( $packages, $toEnqueue, $shouldBeAdded ) {
		$context = new RequestContext();
		$out = $context->getOutput();
		$resourceLoader = $out->getResourceLoader();

		foreach ( $packages as $package ) {
			JSMessages::registerPackage( $package[0] /* name */, $package[1] /* messages */ );
		}

		foreach ( $toEnqueue as $package ) {
			JSMessages::enqueuePackage( $package );
		}

		JSMessages::onResourceLoaderRegisterModules( $resourceLoader );
		JSMessages::onBeforePageDisplay( $out, new SkinTemplate() );

		$modules = $out->getModules();
		$this->assertEquals( $shouldBeAdded, $modules );
	}

	/**
	 * @dataProvider gettingPackageMessagesDataProvider
	 * @covers JSMessages::getPackages
	 * @param array $packages array of packages
	 * Each package is an array containing the package name and array of its message keys
	 * @param array $expectedContents expected key/value array of the message names and their contents
	 */
	public function testGettingPackageMessages( $packages, $expectedContents ) {
		foreach ( static::MESSAGES as $messageName => $contents ) {
			$this->mockMessage( $messageName, $contents );
		}

		$packageNames = [];
		foreach ( $packages as $package ) {
			JSMessages::registerPackage( $package[0] /* name */, $package[1] /* messages */ );
			$packageNames[] = $package[0];
		}

		$resourceLoader = $this->app->wg->Out->getResourceLoader();
		JSMessages::onResourceLoaderRegisterModules( $resourceLoader );

		$packageContents = JSMessages::getPackages( $packageNames );
		$this->assertEquals( $expectedContents, $packageContents );
	}

	public function registeringResourceLoaderModuleDataProvider() {
		return [
			[
				[
					'a-message',
					'a-different-message',
				],
				[
					'a-message',
					'a-different-message',
				],
			],
			[
				[
					'a-message',
					'a-different-message',
					'a-set-of-wildcard-messages-*',
				],
				[
					'a-message',
					'a-different-message',
					'a-set-of-wildcard-messages-like-this',
					'a-set-of-wildcard-messages-like-that',
				],
			],
		];
	}

	public function addingModulesToOutputDataProvider() {
		return [
			[
				[
					[ 'testPackage', [ 'a-message' ] ],
					[ 'anotherPackage', [ 'a-message' ] ],
				],
				[ 'testPackage' ],
				[ 'mediawiki.jqueryMsg', JSMessages::RL_MODULE_PREFIX . 'testPackage' ],
			],
		];
	}

	public function gettingPackageMessagesDataProvider() {
		return [
			[
				[ [ 'singlePackage', [ 'a-message' ] ] ],
				[
					'a-message' => static::MESSAGES['a-message'],
				],
			],
			[
				[ [ 'wildcardPackage', [ 'a-set-of-wildcard-messages-*' ] ] ],
				[
					'a-set-of-wildcard-messages-like-this' => static::MESSAGES['a-set-of-wildcard-messages-like-this'],
					'a-set-of-wildcard-messages-like-that' => static::MESSAGES['a-set-of-wildcard-messages-like-that'],
				],
			],
			[
				[ [ 'otherSinglePackage', [ 'a-message' ] ], [ 'otherWildcardPackage', [ 'a-set-of-wildcard-messages-*' ] ] ],
				[
					'a-message' => static::MESSAGES['a-message'],
					'a-set-of-wildcard-messages-like-this' => static::MESSAGES['a-set-of-wildcard-messages-like-this'],
					'a-set-of-wildcard-messages-like-that' => static::MESSAGES['a-set-of-wildcard-messages-like-that'],
				],
			],
		];
	}
}
