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
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component_input.mustache',
			],
			[ 
				'templateType' => 'anchor', 
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component_anchor.mustache',
			],
			[ 
				'templateType' => 'button', 
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component_button.mustache',
			],
			[ 
				'templateType' => 'big button', 
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component_big_button.mustache',
			],
			[
				'templateType' => 'AWESOME BuTtOn',
				'templatePath' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component',
				'expected' => '/resources/wikia/ui_compontens/sample_component/tempaltes/sample_component_awesome_button.mustache',
			],
		];
	}
}