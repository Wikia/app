<?php
class UIComponentTest extends WikiaBaseTest {
	
	public function setUp() {
		parent::setUp();
		global $IP;
		include_once $IP . '/includes/wikia/ui/UIComponent.class.php';
	}

	/**
	 * @dataProvider testSetTemplatePathDataProvider
	 */
	public function testSetTemplatePath( $templateType, $templatePath, $expected ) {
		// test private method
		$setTemplatePathMethod = new ReflectionMethod( 'UIComponent', 'setTemplatePath' );
		$setTemplatePathMethod->setAccessible( true );
		
		$UIComponentMock = $this->getMock('UIComponent', ['getBaseTemplatePath', 'fileExists']);
		$UIComponentMock->expects( $this->once() )
			->method( 'getBaseTemplatePath' )
			->will( $this->returnValue( $templatePath ) );

		$UIComponentMock->expects( $this->once() )
			->method( 'fileExists' )
			->will( $this->returnValue( true ) );
		
		$setTemplatePathMethod->invoke( $UIComponentMock, $templateType );
		/** @var $UIComponentMock UIComponent */
		$this->assertEquals( $expected, $UIComponentMock->getTemplatePath() );
	}
	
	public function testSetTemplatePathDataProvider() {
		return [
			[ 
				'templateType' => 'input', 
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component_input.mustache',
			],
			[ 
				'templateType' => 'anchor', 
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component_anchor.mustache',
			],
			[ 
				'templateType' => 'button', 
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component_button.mustache',
			],
			[ 
				'templateType' => 'big button', 
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component_big_button.mustache',
			],
			[
				'templateType' => 'AWESOME BuTtOn',
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/templates/sample_component_awesome_button.mustache',
			],
		];
	}

	/**
	 * @dataProvider testValidateTemplateVarsDataProvider
	 */
	public function testValidateTemplateVars( $tplVarsCfg, $tplValues, $componentType, $expectedException ) {
		// test private method
		$validateTemplateVarsMethod = new ReflectionMethod( 'UIComponent', 'validateTemplateVars' );
		$validateTemplateVarsMethod->setAccessible( true );

		$UIComponentMock = $this->getMock('UIComponent', ['getTemplateVarsConfig', 'getValues', 'getType']);
		$UIComponentMock->expects( $this->once() )
			->method( 'getTemplateVarsConfig' )
			->will( $this->returnValue( $tplVarsCfg ) );

		$UIComponentMock->expects( $this->once() )
			->method( 'getValues' )
			->will( $this->returnValue( $tplValues ) );

		$UIComponentMock->expects( $this->once() )
			->method( 'getType' )
			->will( $this->returnValue( $componentType ) );
		
		if( !is_null( $expectedException ) ) {
			$this->setExpectedException( $expectedException );
		}
		
		$validateTemplateVarsMethod->invoke( $UIComponentMock );
	}
	
	public function testValidateTemplateVarsDataProvider() {
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
				'expectedException' => 'WikiaUIDataException',
			]
		];
	}
}
