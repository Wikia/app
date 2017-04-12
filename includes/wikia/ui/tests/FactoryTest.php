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
			'components' => [ 'Other component' ]
		]
	];

	protected function setUp() {
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

		$this->assertStringEndsWith( '/resources/wikia/ui_components/component/component_config.json', $fullPath );
	}

	/**
	 * @dataProvider getSampleComponentConfigJSON
	 */
	public function testLoadingComponentsFromString( $json, $expected ) {
		// test private method
		$loadFromJSONMethod = new ReflectionMethod( 'Wikia\UI\Factory', 'loadFromJSON' );
		$loadFromJSONMethod->setAccessible( true );

		$component = $loadFromJSONMethod->invoke( $this->instance, $json );
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
	 * @dataProvider addAssetDataProvider
	 */
	public function testAddAsset($asset, $type) {
		// test private method
		$addAssetMethod = new ReflectionMethod( 'Wikia\UI\Factory', 'addAsset' );
		$addAssetMethod->setAccessible( true );

		$wgOutMock = $this->getMock( 'stdclass', ['addStyle', 'addScript'] );

		switch ( $type ) {
			case 'scss':
			case 'css':
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
		$addAssetMethod->invoke( $this->instance, $asset );
	}

	public function addAssetDataProvider() {
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
		$UIComponentMock = $this->getMock('Wikia\UI\Component', [ 'setTemplateVarsConfig', 'addAsset', 'setComponentDependencies' ]);
		$UIComponentMock->expects( $this->once() )->method( 'setTemplateVarsConfig' );
		$UIComponentMock->expects( $this->never() )->method( 'addAsset' );
		$UIComponentMock->expects( $this->once() )->method( 'setComponentDependencies' )->with( [ 'Other component' ]);
		
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
		
		/** @var $UIFactoryMock \Wikia\UI\Factory */
		$component = $UIFactoryMock->init( 'component' );

		// make sure the dependencies are not in the assets
		$this->assertEquals( [ 'js' => [], 'css' => [] ], $component->getAssets());
	}

	public function testLoadComponentTemplateContent() {
		$path = '/tmp/sample/path/component';

		$UIFactoryMock = $this->getMock( 'Wikia\UI\Factory', [
			'loadFileContent',
			'__wakeup'
		], [], '', false );
		$UIFactoryMock->expects( $this->once() )->method( 'loadFileContent' )->with( $path );

		$componentMock = $this->getMock( 'Wikia\UI\Component', [ 'setType', 'getTemplatePath' ]);
		$componentMock->expects( $this->once() )->method( 'setType' )->with( 'subtype' );
		$componentMock->expects( $this->once() )->method( 'getTemplatePath' )->will( $this->returnValue( $path ) );

		// make sure we don't use memcache during the call
		$wgMemcMock = $this->getMock( 'stdclass', ['get', 'set'] );
		$wgMemcMock->expects( $this->any() )->method( 'get' )->will( $this->returnValue( null ) );
		$this->mockGlobalVariable('wgMemc', $wgMemcMock);

		$UIFactoryMock->loadComponentTemplateContent( $componentMock, 'subtype' );
	}

	public function testGetComponentAssetsUrls() {
		$componentMock = $this->getMock( 'Wikia\UI\Component', [ 'getAssets' ] );
		$componentMock->expects( $this->once() )->method( 'getAssets' )->will( $this->returnValue(
            [ 'js' => [ '1.js', '2.js' ], 'css' => [ '3.css', '4.css' ] ]
        ) );

        $UIFactoryMock = $this->getMock( 'Wikia\UI\Factory', [
            'getAssetsURL',
            '__wakeup'
        ], [], '', false );

        $UIFactoryMock->expects( $this->any() )->method( 'getAssetsURL' )
			->will( $this->returnValueMap( [
		        [ '1.js', [ [ 'url1' ], \Wikia\UI\Factory::ASSET_TYPE_JS ] ],
		        [ '2.js', [ [ 'url2' ], \Wikia\UI\Factory::ASSET_TYPE_JS ] ],
		        [ '3.css', [ [ 'url3' ], \Wikia\UI\Factory::ASSET_TYPE_CSS ] ],
		        [ '4.css', [ [ 'url4' ], \Wikia\UI\Factory::ASSET_TYPE_CSS ] ],
	        ] ) );

        /** @var $UIFactoryMock \Wikia\UI\Factory */
        $this->assertEquals( [ 'js' => [ 'url1', 'url2' ], 'css' => [ 'url3', 'url4' ] ], $UIFactoryMock->getComponentAssetsUrls( $componentMock ) );
	}

	public function testLoadSingleDependency() {
		$c1ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c1ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ 'c2' ] ) );

		$c2ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c2ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [] ) );

		$UIFactoryMock = $this->getMock( 'Wikia\UI\Factory', [ 'initComponent', '__wakeup' ], [], '', false );
		$UIFactoryMock->expects( $this->exactly( 2 ) )->method( 'initComponent' )->will( $this->returnValueMap( [
			[ 'c1', [], $c1ComponentMock ],
			[ 'c2', [], $c2ComponentMock ]
		] ) );


		$dep = [];
		$res = $UIFactoryMock->init( [ 'c1' ], false, $dep );

		$this->assertEquals( $c1ComponentMock, $res );
		$this->assertEquals( [ 'c2' => $c2ComponentMock ], $dep );
	}

	public function testLoadDependencyJustOnce() {
		$c1ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c1ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ 'c4' ] ) );

		$c2ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c2ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ 'c3' ] ) );

		$c3ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c3ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ 'c4' ] ) );

		$c4ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c4ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ ] ) );

		$UIFactoryMock = $this->getMock( 'Wikia\UI\Factory', [ 'initComponent', '__wakeup' ], [], '', false );
		$UIFactoryMock->expects( $this->exactly( 4 ) )->method( 'initComponent' )->will( $this->returnValueMap( [
			[ 'c1', [], $c1ComponentMock ],
			[ 'c2', [], $c2ComponentMock ],
			[ 'c3', [], $c3ComponentMock ],
			[ 'c4', [], $c4ComponentMock ]
		] ) );

		$dep = [];
		$res = $UIFactoryMock->init( [ 'c1', 'c2', 'c4' ], false, $dep );

		$this->assertEquals( [ $c1ComponentMock, $c2ComponentMock, $c4ComponentMock ], $res );
		$this->assertEquals( [ 'c3' => $c3ComponentMock, 'c4' => $c4ComponentMock ], $dep );


	}

	public function testCircularDependencies() {
		$c1ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c1ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ 'c2' ] ) );

		$c2ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c2ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ 'c3' ] ) );

		$c3ComponentMock = $this->getMock( 'Wikia\UI\Component', [ 'getComponentDependencies' ] );
		$c3ComponentMock->expects( $this->any() )->method( 'getComponentDependencies' )->will( $this->returnValue( [ 'c1' ] ) );

		$UIFactoryMock = $this->getMock( 'Wikia\UI\Factory', [ 'initComponent', '__wakeup' ], [], '', false );
		$UIFactoryMock->expects( $this->exactly( 3 ) )->method( 'initComponent' )->will( $this->returnValueMap( [
			[ 'c1', [], $c1ComponentMock ],
			[ 'c2', [], $c2ComponentMock ],
			[ 'c3', [], $c3ComponentMock ]
		] ) );

		$dep = [];
		$res = $UIFactoryMock->init( [ 'c1' ], false, $dep );
		$this->assertEquals( $c1ComponentMock, $res );
		$this->assertEquals( [ 'c1' => $c1ComponentMock, 'c2' => $c2ComponentMock, 'c3' => $c3ComponentMock ], $dep );
	}

}
