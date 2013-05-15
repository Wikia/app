<?php
require_once( "{$IP}/extensions/wikia/GameGuides/GameGuides_setup.php" );

class GameGuidesModelTest extends WikiaBaseTest
{
	/**
	 * @covers GameGuidesModel::getResultSet
	 */
	public function testGetResultSet()
	{
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setNamespaces', 'setQuery', 'setLimit' ] )
		                   ->getMock();
		
		$mockFactory = $this->getMock( 'Wikia\Search\QueryService\Factory', [ 'getFromConfig' ] );
		
		$mockSearch = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'search' ] )
		                   ->getMock();;
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		
		$mockGGModel = $this->getMockBuilder( 'GameGuidesModel' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( null )
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
		
		$this->proxyClass( 'Wikia\Search\Config', $mockConfig );
		$this->proxyClass( 'Wikia\Search\QueryService\Factory', $mockFactory );
		$this->mockApp();
		
		$this->assertInstanceOf(
				'Wikia\Search\ResultSet\Base',
				$mockGGModel->getResultSet( $query, $limit )
		);
	}
	
}