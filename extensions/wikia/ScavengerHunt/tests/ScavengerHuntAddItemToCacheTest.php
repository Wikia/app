<?php
require_once dirname(__FILE__) . '/../tests/ScavengerHuntTest.php';

class ScavengerHuntAddItemToCacheTest extends ScavengerHuntTest {

	public function conditions(){

		return array(
			array( false, array( ), array( self::MOCK_TEXT ), false ),
			array( false, array( self::WRONG_ARTICLE_NAME ), array( self::MOCK_TEXT ), false ),
			array( false, array( self::MOCK_TEXT, self::MOCK_TEXT ), array(), false ),
			array( true, array( self::MOCK_TEXT ), array( self::WRONG_ARTICLE_NAME ), true ),
			array( true, array( self::MOCK_TEXT ), array(), true ),
			array( true, array( self::MOCK_TEXT ), array( self::MOCK_TEXT, self::WRONG_ARTICLE_NAME ), true ),
			array( true, array( self::WRONG_ARTICLE_NAME ), array( self::MOCK_TEXT ), false ),
			array( true, array( self::MOCK_TEXT ), array( self::MOCK_TEXT, self::WRONG_ARTICLE_NAME ), true, true )
		);
	}

	/**
	 * @dataProvider conditions
	 */

	public function testAddItemToCache( $articleExist, $articlesList, $cachedList, $expectedResult, $brokenCache = false ) {

		$this->markTestSkipped('Test is failing and causing false positives');
		// Game
		$articlesIdentifiers = array();
		foreach( $articlesList as $art ) {
			$articlesIdentifiers[] = ScavengerHunt::makeIdentifier( self::LANDING_WIKI_ID, $art );
		}

		$mockedGame = $this->getMock( 'ScavengerHuntGame', array('getArticleIdentifier'), array( $this->app ) );
		$mockedGame
			->expects( $this->any() )
			->method( 'getArticleIdentifier' )
			->will(  $this->returnValue( $articlesIdentifiers ) );

		$this->mockClass( 'ScavengerHuntGame', $mockedGame );
		$game = $this->getFakeGame();		

		// Hunt
		$scavengerHunt = $this->getMock('ScavengerHunt', array( 'getDataFromCache', 'saveDataToCache' ) );
		$scavengerHunt->setGame( $articleExist ? $game : null );
		$cachedIdentifiers = array();
		foreach( $cachedList as $art ) {
			$cachedIdentifiers[] = ScavengerHunt::makeIdentifier( self::LANDING_WIKI_ID, $art );
		}

		$scavengerHunt
			->expects($this->any())
			->method( 'saveDataToCache')
			->will($this->returnValue(true));

		$scavengerHunt
			->expects( $this->any() )
			->method( 'getDataFromCache' )
			->will(
				$this->returnValue(
					array(
						'gameId' => $scavengerHunt->getHuntId(),
						ScavengerHunt::VISITED_ART_KEY => $brokenCache ? 'broken' : $cachedIdentifiers
					)
				)
			);

		// User
		$mockedUser = $this->getMock( 'User', array('isAnon') );
		$mockedUser
			->expects( $this->any() )
			->method( 'isAnon' )
			->will(  $this->returnValue( self::MOCK_USER_NAME ) );

		$this->mockClass( 'User', $mockedUser );

		$_COOKIE[ $scavengerHunt->getHuntIdKey() ] = ( $articleExist ) ? self::MOCK_GAME_ID : 0;

		$result = $scavengerHunt->addItemToCache( self::MOCK_TEXT, self::LANDING_WIKI_ID );

		$this->assertEquals( empty( $result ), empty( $expectedResult ) );
	}
}