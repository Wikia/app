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
	public function testLoadingComponentsFromString( $stringJSON ) {
		// test private method
		$method = new ReflectionMethod( 'UIFactory', 'loadComponentConfigFromString' );
		$method->setAccessible( true );

		$component = $method->invoke( $this->instance, $stringJSON );
	}

	public function getSampleComponentConfigJSON() {
		return [
			// empty, sample JSON
			[
				'json' => '{ "name":"Sample", "desc": "Sample component", "templateValues": { "required": [], "optional": [] }, "dependencies": { "js": [], "css": [] } }'
			]
		];
	}
}
