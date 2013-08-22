<?php

class GlobalHeaderControllerTest extends WikiaBaseTest
{

	/**
	 * @covers GlobalHeaderController::index
	 */
	public function testIndex() {
		$controller = $this->getMockBuilder( 'GlobalHeaderController' )
			->disableOriginalConstructor()
			->setMethods( array( 'isGameStarLogoEnabled' ) )
			->getMock();

		$mockResponse = $this->getMockBuilder( 'WikiaResponse' )
			->disableOriginalConstructor()
			->setMethods( array( 'setVal', 'addAsset' ) )
			->getMock();

		$mockLang = $this->getMockBuilder( 'Language' )
			->disableOriginalConstructor()
			->setMethods( array( 'getCode' ) )
			->getMock();

		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'getCode' )
			->will		( $this->returnValue( 'en' ) )
		;

		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'centralUrl', 'http://www.wikia.com/Wikia' )
		;
		$controller
			->expects	( $this->once() )
			->method	( 'isGameStarLogoEnabled' )
			->will		( $this->returnValue( true ) )
		;
		$mockResponse
			->expects	( $this->at( 5 ) )
			->method	( 'setVal' )
			->with		( 'isGameStarLogoEnabled', true )
		;
		$mockResponse
			->expects	( $this->at( 6 ) )
			->method	( 'addAsset' )
			->with		( 'skins/oasis/css/modules/GameStarLogo.scss' )
		;
		$mockResponse
			->expects	( $this->at( 7 ) )
			->method	( 'setVal' )
			->with		( 'altMessage', '' )
		;
		$mockResponse
			->expects	( $this->at( 8 ) )
			->method	( 'setVal' )
			->with		( 'displayHeader', true )
		;

		$resp = new ReflectionProperty( 'GlobalHeaderController', 'response' );
		$resp->setAccessible( true );
		$resp->setValue( $controller, $mockResponse );

		$wg = new ReflectionProperty( 'GlobalHeaderController', 'wg' );
		$wg->setAccessible( true );
		$wg->setValue( $controller, (object) array( 'CityId' => 380, 'Lang' => $mockLang, 'HideNavigationHeaders' => false ) );

		$this->mockGlobalVariable( 'wgLang', $mockLang );

		$controller->index();
	}

	/**
	 * @covers GlobalHeaderController::index
	 */
	public function testIndexForeignLang() {
		$controller = $this->getMockBuilder( 'GlobalHeaderController' )
			->disableOriginalConstructor()
			->setMethods( array( 'isGameStarLogoEnabled' ) )
			->getMock();

		$mockResponse = $this->getMockBuilder( 'WikiaResponse' )
			->disableOriginalConstructor()
			->setMethods( array( 'setVal', 'addAsset' ) )
			->getMock();

		$mockLang = $this->getMockBuilder( 'Language' )
			->disableOriginalConstructor()
			->setMethods( array( 'getCode' ) )
			->getMock();

		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'getCode' )
			->will		( $this->returnValue( 'fr' ) )
		;

		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'centralUrl', "http://wikia.fr" )
		;
		$controller
			->expects	( $this->once() )
			->method	( 'isGameStarLogoEnabled' )
			->will		( $this->returnValue( true ) )
		;
		$mockResponse
			->expects	( $this->at( 5 ) )
			->method	( 'setVal' )
			->with		( 'isGameStarLogoEnabled', true )
		;
		$mockResponse
			->expects	( $this->at( 6 ) )
			->method	( 'addAsset' )
			->with		( 'skins/oasis/css/modules/GameStarLogo.scss' )
		;
		$mockResponse
			->expects	( $this->at( 7 ) )
			->method	( 'setVal' )
			->with		( 'altMessage', '' )
		;

		$resp = new ReflectionProperty( 'GlobalHeaderController', 'response' );
		$resp->setAccessible( true );
		$resp->setValue( $controller, $mockResponse );

		$wg = new ReflectionProperty( 'GlobalHeaderController', 'wg' );
		$wg->setAccessible( true );
		$wg->setValue( $controller, (object) array( 'CityId' => 380, 'Lang' => $mockLang, 'LangToCentralMap' => array( 'fr' => "http://wikia.fr" ), 'HideNavigationHeaders' => false ) );

		$this->mockGlobalVariable( 'wgLang', $mockLang );

		$controller->index();
	}
}
