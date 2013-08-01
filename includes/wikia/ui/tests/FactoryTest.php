<?php

class FactoryTest extends WikiaBaseTest {

	/**
	 * @var /Wikia/UI/Factory
	 */
	private $instance = null;

	/**
	 * @var array
	 */
	private $tplVarsCfg = [
		'name' => 'Component',
		'templateVars' => [
			'type1' => [
				'required' => [ 'href', 'class', 'value' ],
				'optional' => [ 'label', 'target' ],
			],
			'type2' => [
				'required' => [ 'name', 'class', 'value' ],
				'optional' => [ 'label' ],
			]
		],
		'dependencies' => [
			'js' => [],
			'css' => [],
		]
	];

	public function setUp() {
		parent::setUp();

		global $IP;

		include_once $IP . '/includes/wikia/ui/Factory.class.php';

		$this->instance = Wikia\UI\Factory::getInstance();
	}

	public function testInitalizationAndSingleton() {
		$instanceB = Wikia\UI\Factory::getInstance();

		$this->assertEquals( $this->instance, $instanceB );
	}

	public function testGettingFileFullPath() {
		// test private method
		$method = new ReflectionMethod( 'Wikia\UI\Factory', 'getComponentConfigFileFullPath' );
		$method->setAccessible( true );

		$fullPath = $method->invoke( $this->instance, 'component' );

		$this->assertEquals( $fullPath, '/usr/wikia/source/wiki/resources/wikia/ui_components/component/component_config.json' );
	}

	/**
	 * @dataProvider getSampleComponentConfigJSON
	 */
	public function testLoadingComponentsFromString( $json, $expected ) {
		// test private method
		$loadComponentConfigFromJSONMethod = new ReflectionMethod( 'Wikia\UI\Factory', 'loadComponentConfigFromJSON' );
		$loadComponentConfigFromJSONMethod->setAccessible( true );

		$component = $loadComponentConfigFromJSONMethod->invoke( $this->instance, $json );
		$this->assertEquals( $expected, $component );
	}

	public function getSampleComponentConfigJSON() {
		return [
			// empty, sample JSON
			[
				'json' => '{ "name-msg-key":"sample", "description-msg-key": "sample-component-desc", "templateVars": { "required": [], "optional": [] }, "dependencies": { "js": [], "css": [] } }',
				'expected' => [
					'name-msg-key' => 'sample',
					'description-msg-key' => 'sample-component-desc',
					'templateVars' => [ 'required' => [], 'optional' => [] ],
					'dependencies' => [ 'js' => [], 'css' => [] ],
				]
			]
		];
	}

	/**
	 * @dataProvider testAddAssetDataProvider
	 */
	public function testAddAsset($asset, $type) {
		// test private method
		$addAssetMethod = new ReflectionMethod( 'Wikia\UI\Factory', 'addAsset' );
		$addAssetMethod->setAccessible( true );

		$wgOutMock = $this->getMock( 'stdclass', ['addStyle', 'addScript'] );

		switch ( $type ) {
			case 'scss':
			case  'css':
				$wgOutMock->expects( $this->once() )
					->method( 'addStyle' );
				$wgOutMock->expects( $this->never() )
					->method( 'addScript' );
				break;
			case 'js':
				$wgOutMock->expects( $this->never() )
					->method( 'addStyle' );
				$wgOutMock->expects( $this->once() )
					->method( 'addScript' );
				break;
		}

		$this->mockGlobalVariable( 'wgOut', $wgOutMock );
		$this->mockApp();

		$addAssetMethod->invoke( $this->instance, $asset );
	}

	public function testAddAssetDataProvider() {
		return [
			[
				'assetName' => 'testAsset.css',
				'assetType' => 'css'
			],
			[
				'assetName' => 'testAsset.scss',
				'assetType' => 'scss'
			],
			[
				'assetName' => 'testAsset.js',
				'assetType' => 'js'
			]
		];
	}

	public function testInitForOneComponent() {
		$UIComponentMock = $this->getMock('Wikia\UI\Component', [ 'setTemplateVarsConfig', 'addAsset' ]);
		$UIComponentMock->expects( $this->once() )->method( 'setTemplateVarsConfig' );
		$UIComponentMock->expects( $this->never() )->method( 'addAsset' );
		
		$UIFactoryMock = $this->getMock( 'Wikia\UI\Factory', [
			'getComponentInstance', 
			'loadComponentConfig', 
			'getComponentsBaseTemplatePath', 
			'__wakeup' 
		], [], '', false );
		
		$UIFactoryMock->expects( $this->once() )->method( 'getComponentInstance' )
			->will( $this->returnValue( $UIComponentMock ) );
		
		$UIFactoryMock->expects( $this->once() )->method( 'loadComponentConfig' )
			->will( $this->returnValue( $this->tplVarsCfg ) );
		
		$UIFactoryMock->expects( $this->once() )->method( 'getComponentsBaseTemplatePath' );
		
		/** @var $UIFactoryMock Wikia\UI\Factory */
		$UIFactoryMock->init( 'component' );
	}
}
