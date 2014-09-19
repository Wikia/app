<?php
require_once dirname(__FILE__) . '/../tests/ScavengerHuntTest.php';

/**
 * @group Broken
 */
class ScavengerHuntGetFoundIndexesTest extends ScavengerHuntTest {

	public function conditions(){

		return array(
			array( false, array( 0 => self::WRONG_ARTICLE_NAME ), array( self::MOCK_TEXT ), array() ),
			array( false, array( 0 => self::MOCK_TEXT ), array( self::MOCK_TEXT ), array() ),
			array( true, array( 0 => self::MOCK_TEXT, 1 => self::WRONG_ARTICLE_NAME ), array( self::MOCK_TEXT ), array( 0 ) ),
			array( true, array( 0 => self::MOCK_TEXT, 1 => self::WRONG_ARTICLE_NAME ), array( self::WRONG_ARTICLE_NAME ), array( 1 ) ),
			array( true, array( 0 => self::MOCK_TEXT, 1 => self::WRONG_ARTICLE_NAME ), array( self::MOCK_TEXT, self::WRONG_ARTICLE_NAME ), array( 0, 1 ) ),
			array( true, array( 0 => self::MOCK_TEXT ), array( self::WRONG_ARTICLE_NAME ), array() ),
			array( true, array( 0 => self::MOCK_TEXT ), array(), array() ),
			array( true, array(), array( self::MOCK_TEXT ), array() ),
			array( true, array(), array(), array() ),
			array( true, array( 0 => self::MOCK_TEXT, 1 => self::WRONG_ARTICLE_NAME ), array( self::WRONG_ARTICLE_NAME ), array(), true ),
		);
	}
	
	/**
	 * @dataProvider conditions
	 */

	public function testGetFoundIndexes( $gameExists, $articlesList, $foundList, $expectedResult, $brokenCache = false ) {
		
		// mocking game object
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

		// mocking scavenger hunt and passing game to the hunt
		$scavengerHunt = $this->getMock( 'ScavengerHunt', array( 'getDataFromCache' ) );
		$scavengerHunt->setGame( $gameExists ? $game : null );

		$cachedIdentifiers = array();
		foreach( $foundList as $art ) {
			$cachedIdentifiers[] = ScavengerHunt::makeIdentifier( self::LANDING_WIKI_ID, $art );
		}

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

		// mocking user
		$mockedUser = $this->getMock( 'User', array('isAnon') );
		$mockedUser
			->expects( $this->any() )
			->method( 'isAnon' )
			->will(  $this->returnValue( self::MOCK_USER_NAME ) );

		$this->mockClass( 'User', $mockedUser );

		// setting cookie values
		$_COOKIE[ $scavengerHunt->getHuntIdKey() ] = ( $gameExists ) ? self::MOCK_GAME_ID : 0;

		// test and assertions
		$result = $scavengerHunt->getFoundIndexes();
		
		$this->assertEquals( $expectedResult, $result );
	}
}