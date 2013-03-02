<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchQueryServiceSelectOnWikiTest extends WikiaSearchBaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::extractMatch
	 */
	public function testExtractMatch() {
		
		$mockInterface = $this->getMockBuilder( 'Wikia\Search\MediaWikiInterface' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getArticleMatchForTermAndNamespaces' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getOriginalQuery', 'getNamespaces', 'setArticleMatch', 'getMatch' ) )
		                   ->getMock();
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'interface' => $mockInterface, 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getOriginalQuery' )
		    ->will   ( $this->returnValue( 'term' ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( array( 0, 14 ) ) )
		;
		$mockInterface
		    ->expects( $this->once() )
		    ->method ( 'getArticleMatchForTermAndNamespaces' )
		    ->with   ( 'term', array( 0, 14 ) )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setArticleMatch' )
		    ->with   ( $mockMatch )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$this->assertEquals(
				$mockMatch,
				$mockSelect->extractMatch()
		);
	}
	
}