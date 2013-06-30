<?php

class UIFactoryTest extends WikiaBaseTest {

	private $instance = null;

	public function setUp() {
		parent::setUp();

		global $IP;

		include_once $IP . '/includes/wikia/ui/UIFactory.class.php';

		$this->instance = UIFactory::getInstance();
	}

	public function testInitalizationAndSingleton() {
		$instanceB = UIFactory::getInstance();

		$this->assertEquals( $this->instance, $instanceB );
	}

	public function testGettingFileFullPath() {
		// test private method
		$method = new ReflectionMethod( 'UIFactory', 'getComponentConfigFileFullPath' );
		$method->setAccessible( true );

		$fullPath = $method->invoke( $this->instance, 'component' );

		$this->assertEquals( $fullPath, '/usr/wikia/source/wiki/resources/wikia/ui_components/component/component_config.json' );
	}

	/**
	 * @dataProvider getSampleComponentConfigJSON
	 */
	public function testLoadingComponentsFromString( $json, $expected ) {
		// test private method
		$loadComponentConfigFromStringMethod = new ReflectionMethod( 'UIFactory', 'loadComponentConfigFromString' );
		$loadComponentConfigFromStringMethod->setAccessible( true );

		$component = $loadComponentConfigFromStringMethod->invoke( $this->instance, $json );
		$this->assertEquals( $expected, $component );
	}

	public function getSampleComponentConfigJSON() {
		return [
			// empty, sample JSON
			[
				'json' => '{ "name":"Sample", "desc": "Sample component", "templateValues": { "required": [], "optional": [] }, "dependencies": { "js": [], "css": [] } }',
				'expected' => [
					'name' => 'Sample',
					'desc' => 'Sample component',
					'templateValues' => [ 'required' => [], 'optional' => [] ],
					'dependencies' => [ 'js' => [], 'css' => [] ],
					'id' => 'sample',
				]
			]
		];
	}
}
