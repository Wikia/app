<?php

class GlobalHeaderControllerTest extends WikiaBaseTest
{
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.01834 ms
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
		
		$menuNodesRefl = new ReflectionProperty( 'GlobalHeaderController', 'menuNodes' );
		$menuNodesRefl->setAccessible( true );
		$menuNodes = $menuNodesRefl->getValue( $controller );
		
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'centralUrl', 'http://www.wikia.com/Wikia' )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setVal' )
			->with		( 'createWikiUrl', 'http://www.wikia.com/Special:CreateNewWiki' )
		;
		$mockResponse
			->expects	( $this->at( 2 ) )
			->method	( 'setVal' )
			->with		( 'menuNodes', $menuNodes )
		;
		$mockResponse
			->expects	( $this->at( 3 ) )
			->method	( 'setVal' )
			->with		( 'menuNodesHash', $menuNodes[0]['hash'] )
		;
		$mockResponse
			->expects	( $this->at( 4 ) )
			->method	( 'setVal' )
			->with		( 'topNavMenuItems', $menuNodes[0]['children'] )
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
	 * @group Slow
	 * @slowExecutionTime 0.01162 ms
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
		
		$menuNodesRefl = new ReflectionProperty( 'GlobalHeaderController', 'menuNodes' );
		$menuNodesRefl->setAccessible( true );
		$menuNodes = $menuNodesRefl->getValue( $controller );
		
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'centralUrl', "http://wikia.fr" )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setVal' )
			->with		( 'createWikiUrl', 'http://www.wikia.com/Special:CreateNewWiki?uselang=fr' )
		;
		$mockResponse
			->expects	( $this->at( 2 ) )
			->method	( 'setVal' )
			->with		( 'menuNodes', $menuNodes )
		;
		$mockResponse
			->expects	( $this->at( 3 ) )
			->method	( 'setVal' )
			->with		( 'menuNodesHash', $menuNodes[0]['hash'] )
		;
		$mockResponse
			->expects	( $this->at( 4 ) )
			->method	( 'setVal' )
			->with		( 'topNavMenuItems', $menuNodes[0]['children'] )
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
	
	/**
	 * @group UsingDB
	 * @covers GlobalHeaderController::index
	 */
	public function testIndexAlternateLink() {
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
		
		$menuNodesRefl = new ReflectionProperty( 'GlobalHeaderController', 'menuNodes' );
		$menuNodesRefl->setAccessible( true );
		$menuNodes = $menuNodesRefl->getValue( $controller );
		
		$mockResponse
			->expects	( $this->at( 0 ) )
			->method	( 'setVal' )
			->with		( 'centralUrl', 'http://www.wikia.com/Wikia' )
		;
		$mockResponse
			->expects	( $this->at( 1 ) )
			->method	( 'setVal' )
			->with		( 'createWikiUrl', 'http://www.wikia.com/Special:CreateNewWiki' )
		;
		$mockResponse
			->expects	( $this->at( 2 ) )
			->method	( 'setVal' )
			->with		( 'menuNodes', $menuNodes )
		;
		$mockResponse
			->expects	( $this->at( 3 ) )
			->method	( 'setVal' )
			->with		( 'menuNodesHash', $menuNodes[0]['hash'] )
		;
		$mockResponse
			->expects	( $this->at( 4 ) )
			->method	( 'setVal' )
			->with		( 'topNavMenuItems', $menuNodes[0]['children'] )
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
			->with		( 'altMessage', '-alt' )
		;
		$mockResponse
			->expects	( $this->at( 8 ) )
			->method	( 'setVal' )
			->with		( 'displayHeader', false )
		;
		
		$resp = new ReflectionProperty( 'GlobalHeaderController', 'response' );
		$resp->setAccessible( true );
		$resp->setValue( $controller, $mockResponse );
		
		$wg = new ReflectionProperty( 'GlobalHeaderController', 'wg' );
		$wg->setAccessible( true );
		$wg->setValue( $controller, (object) array( 'CityId' => 381, 'Lang' => $mockLang, 'HideNavigationHeaders' => true ) );
		
		$this->mockGlobalVariable( 'wgLang', $mockLang );
		
		$controller->index();
	}
	
		
}
