<?php
use PHPUnit\Framework\TestCase;

class ComponentTest extends TestCase {
	
	protected function setUp() {
		parent::setUp();
		global $IP;
		include_once $IP . '/includes/wikia/ui/Component.class.php';
	}

	/**
	 * @covers \Wikia\UI\Component::getTemplatePath
	 * @dataProvider getTemplatePathDataProvider
	 * 
	 * @param string $templateType
	 * @param string $expected
	 */
	public function testGetTemplatePath( $templateType, $expected ) {
		$component = new \Wikia\UI\Component();

		$component->setBaseTemplatePath( __DIR__ . '/fixtures/sample_component' );
		$component->setType( $templateType );
		
		$this->assertEquals( __DIR__ . "/$expected", $component->getTemplatePath() );
	}
	
	public function getTemplatePathDataProvider() {
		return [
			[ 
				'templateType' => 'input',
				'expected' => 'fixtures/sample_component_input.mustache',
			],
			[ 
				'templateType' => 'anchor',
				'expected' => 'fixtures/sample_component_anchor.mustache',
			],
			[ 
				'templateType' => 'button',
				'expected' => 'fixtures/sample_component_button.mustache',
			],
			[ 
				'templateType' => 'big button',
				'expected' => 'fixtures/sample_component_big_button.mustache',
			],
			[
				'templateType' => 'AWESOME BuTtOn',
				'expected' => 'fixtures/sample_component_awesome_button.mustache',
			],
		];
	}

	/**
	 * @dataProvider testValidateTemplateVarsDataProvider
	 */
	public function validateTemplateVars( $tplVarsCfg, $tplValues, $componentType, $expectedException ) {
		// test private method
		$validateTemplateVarsMethod = new ReflectionMethod( '\Wikia\UI\Component', 'validateTemplateVars' );
		$validateTemplateVarsMethod->setAccessible( true );

		$UIComponentMock = $this->getMockBuilder( \Wikia\UI\Component::class )
			->setMethods( ['getTemplateVarsConfig', 'getVarsValues', 'getType'] )
			->getMock();

		$UIComponentMock->expects( $this->once() )
			->method( 'getTemplateVarsConfig' )
			->will( $this->returnValue( $tplVarsCfg ) );

		$UIComponentMock->expects( $this->once() )
			->method( 'getVarsValues' )
			->will( $this->returnValue( $tplValues ) );

		$UIComponentMock->expects( $this->once() )
			->method( 'getType' )
			->will( $this->returnValue( $componentType ) );
		
		if( !is_null( $expectedException ) ) {
			$this->expectException( $expectedException );
		}
		
		$validateTemplateVarsMethod->invoke( $UIComponentMock );
	}
	
	public function validateTemplateVarsDataProvider() {
		return [
			[
				'tplVarsCfg' => [
					'input' => [
						'required' => [ 'name', 'class', 'value' ],
						'optional' => [ 'label' ],
					],
					'link' => [
						'required' => [ 'href', 'class', 'value' ],
						'optional' => [ 'label' ],
					]
				],
				'tplValues' => [ 'name' => 'sample-component-name', 'class' => 'sample-component-class', 'value' => 'Sample component value' ],
				'componentType' => 'input',
				'expectedException' => null,
			],
			[
				'tplVarsCfg' => [
					'input' => [
						'required' => [ 'name', 'class', 'value' ],
						'optional' => [ 'label' ],
					],
					'link' => [
						'required' => [ 'href', 'class', 'value' ],
						'optional' => [ 'label' ],
					]
				],
				'tplValues' => [ 'class' => 'sample-component-class', 'value' => 'Sample component value' ],
				'componentType' => 'link',
				'expectedException' => '\Wikia\UI\DataException',
			]
		];
	}
}
