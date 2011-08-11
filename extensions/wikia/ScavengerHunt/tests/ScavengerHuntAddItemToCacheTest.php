<?php
require_once dirname(__FILE__) . '/../ScavengerHunt_setup.php';
require_once dirname(__FILE__) . '/../tests/ScavengerHuntTest.php';
wfLoadAllExtensions();

class ScavengerHuntAddItemToCacheTest extends ScavengerHuntTest {

	public function conditions(){

		return array(
			array( false, array( ), array( self::MOCK_TEXT ), false ),
			array( false, array( self::WRONG_ARTICLE_NAME ), array( self::MOCK_TEXT ), false ),
			array( true, array( self::WRONG_ARTICLE_NAME ), array( self::MOCK_TEXT ), true ),
			array( true, array( self::MOCK_TEXT ), array( self::WRONG_ARTICLE_NAME ), true ),
			array( true, array( self::MOCK_TEXT ), array(), true ),
			array( true, array( self::MOCK_TEXT ), array( self::MOCK_TEXT, self::WRONG_ARTICLE_NAME ), true ),
			array( false, array( self::MOCK_TEXT, self::MOCK_TEXT ), array(), false )
		);
	}
	
	/**
	 * @dataProvider conditions
	 */

	public function testAddItemToCache( $articleExist, $articlesList, $cachedList, $expectedResult ) {
		
		$scavengerHunt = $this->getMock('ScavengerHunt', array( 'getDataFromCache' ) );
		$game = $this->getFakeGame();
		$scavengerHunt->setGame( $articleExist ? $game : null );

		$articlesIdentifiers = array();
		foreach( $articlesList as $art ) {
			$articlesIdentifiers[] = $game->makeIdentifier( self::LANDING_WIKI_ID, $art );
		}

		$cachedIdentifiers = array();
		foreach( $cachedList as $art ) {
			$cachedIdentifiers[] = $game->makeIdentifier( self::LANDING_WIKI_ID, $art );
		}

		$scavengerHunt->saveDataToCache( $cachedIdentifiers );

		$mockedGame = $this->getMock( 'ScavengerHuntGame', array('getArticleIdentifier'), array( $this->app ) );
		$mockedGame
			->expects( $this->any() )
			->method( 'getArticleIdentifier' )
			->will(  $this->returnValue( $articlesIdentifiers ) );

		$mockedUser = $this->getMock( 'User', array('isAnon') );
		$mockedUser
			->expects( $this->any() )
			->method( 'isAnon' )
			->will(  $this->returnValue( self::MOCK_USER_NAME ) );

		$this->mockClass( 'User', $mockedUser );

		$_COOKIE[ $scavengerHunt->getHuntIdKey() ] = ( $articleExist ) ? self::MOCK_GAME_ID : 0;

		$result = $scavengerHunt->addItemToCache( self::MOCK_TEXT, self::LANDING_WIKI_ID );
		$scavengerHunt->resetCache();
		$this->assertEquals( empty( $result ), empty( $expectedResult ) );
	}
}