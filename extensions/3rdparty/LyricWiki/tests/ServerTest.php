<?php

global $SHUT_DOWN_API;
$SHUT_DOWN_API = true;
require_once( "{$IP}/extensions/3rdparty/LyricWiki/server.php" );

class ServerTest extends WikiaBaseTest
{
	/**
	 * @covers lw_getSearchResults
	 */
	public function test_lw_getSearchResults() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setNamespaces', 'setQuery', 'setLimit' ] )
		                   ->getMock();
		
		$mockFactory = $this->getMock( 'Wikia\Search\QueryService\Factory', [ 'getFromConfig' ] );
		
		$mockSearch = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'search' ] )
		                   ->getMock();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		
		$query = 'foo';
		$limit = 20;
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setNamespaces' )
		    ->with   ( [ NS_MAIN ] )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( $query )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setLimit' )
		    ->with   ( $limit )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockFactory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
		    ->expects( $this->once() )
		    ->method ( 'search' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		
		// @todo handle the transformation from result set to array of titles
		
		$this->mockClass( 'Wikia\Search\Config', $mockConfig );
		$this->mockClass( 'Wikia\Search\QueryService\Factory', $mockFactory );

		$this->assertTrue(
				is_array( lw_getSearchResults( $query, $limit ) )
		);
	}
	
	/**
	 * @covers lw_getTitle
	 */
	public function test_lw_getTitle(){
		$this->assertTrue(lw_getTitle("the who:baba o'riley") == "The_Who:Baba_O'Riley");
		$this->assertTrue(lw_getTitle("the who:i'm cool") == "The_Who:I'm_Cool");
		$this->assertTrue(lw_getTitle("the who:don't") == "The_Who:Don't");
		$this->assertTrue(lw_getTitle("the who:cant skip apostrophes") == "The_Who:Can't_Skip_Apostrophes");
	}
	
	/**
	 * @covers lw_fmtArtist
	 */
	public function test_lw_fmtArtist(){
		$this->assertTrue(lw_fmtArtist("normal name") == "Normal_Name");
		$this->assertTrue(lw_fmtArtist("with (parens)") == "With_(Parens)");
	}

	/**
	 * @covers lw_fmtSong
	 */
	public function test_lw_fmtSong(){
		$this->assertTrue(lw_fmtSong("Cake:guitar%20man") == "Cake:Guitar_Man");
		$this->assertTrue(lw_fmtSong("Cake:guitar (man)") == "Cake:Guitar_(Man)");
	}
}
