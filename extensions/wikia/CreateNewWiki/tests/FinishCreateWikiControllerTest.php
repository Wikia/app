<?php

class FinishCreateWikiControllerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../CreateNewWiki_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider editSiteDescriptionTemplateDataProvider
	 *
	 * @param $description
	 * @param $templateExists
	 * @param $shouldEdit
	 */
	public function testEditSiteDescriptionTemplate( $description, $templateExists, $shouldEdit ) {
		$titleMock = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'getArticleID', 'exists' ] )
			->getMock();

		$titleMock->expects( $this->any() )
			->method( 'getArticleID' )
			->willReturn( 1 );

		$titleMock->expects( $this->any() )
			->method( 'exists' )
			->willReturn( $templateExists );

		$this->getStaticMethodMock( 'Title', 'newFromText' )
			->expects( $this->any() )
			->method( 'newFromText' )
			->will( $this->returnValue( $titleMock ) );

		$articleMock = $this->getMockBuilder( 'Article' )
			->disableOriginalConstructor()
			->setMethods( [ 'doEdit' ] )
			->getMock();

		if ( $shouldEdit ) {
			$articleMock->expects( $this->once() )
				->method( 'doEdit' )
				->with( $this->equalTo( $description ) );
		} else {
			$articleMock->expects( $this->never() )
				->method( 'doEdit' );
		}

		$this->getStaticMethodMock( 'Article', 'newFromID' )
			->expects( $this->any() )
			->method( 'newFromID' )
			->will( $this->returnValue( $articleMock ) );

		$controller = new FinishCreateWikiController();
		$controller->params['wikiDescription'] = $description;
		
		$method = new ReflectionMethod( 'FinishCreateWikiController', 'editSiteDescriptionTemplate' );
		$method->setAccessible( true );
		$method->invoke( $controller );
	}

	public function editSiteDescriptionTemplateDataProvider() {
		return [
			[
				'description' => 'This is description of my new wiki',
				'templateExists' => true,
				'shouldEdit' => true,
			],
			[
				'description' => null,
				'templateExists' => true,
				'shouldEdit' => false
			],
			[
				'description' => 'This is description of my new wiki',
				'templateExists' => false,
				'shouldEdit' => false
			]
		];
	}
}
