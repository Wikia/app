<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchQueryServiceSelectVideoTest extends WikiaSearchBaseTest {
	
	public function testConfigureQueryFields() {
		$mockInterface = $this->getMockBuilder( 'Wikia\Search\MediaWikiInterface' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getLanguageCode' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'addQueryFields' ) );
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig, 'interface' => $mockInterface ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Video' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$videoQueryFields = array(
				Wikia\Search\Utilities::field( 'title', 'en' )           => 5, 
				Wikia\Search\Utilities::field( 'html', 'en' )            => 1.5, 
				Wikia\Search\Utilities::field( 'redirect_titles', 'en' ) => 4
		);
		$mockInterface
		    ->expects( $this->once() )
		    ->method ( 'getLanguageCode' )
		    ->will   ( $this->returnValue( 'fr' ) )
	    ;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'addQueryFields' )
		    ->with   ( $videoQueryFields )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Video', 'configureQueryFields' );
		$method->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Video::getQueryClausesString
	 */
	public function testGetQueryClausesString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getCityId', 'getNamespaces' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Video' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getCityId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Video', 'getQueryClausesString' );
		$method->setAccessible( true );
		$this->assertEquals(
				'((wid:123) AND (ns:6))',
				$method->invoke( $mockSelect )
		);
	}
	
	
}