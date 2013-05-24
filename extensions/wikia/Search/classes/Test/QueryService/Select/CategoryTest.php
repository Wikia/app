<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\CategoryTest
 */
namespace Wikia\Search\QueryService\Test\Select;
use Wikia, ReflectionProperty, ReflectionMethod, Wikia\Search\Test\BaseTest, Wikia\CategoryGalleries\services\CategoryService;


/**
 * Tests category  search functionality
 */
class CategoryTest extends BaseTest { 
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Category::extractMatch
	 */
	public function testExtractMatch() {
		
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getCategoryMatchForTermAndNamespaces' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getQuery', 'setCategoryMatch', 'getMatch' ) )
		                   ->getMock();
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'service' => $mockService, 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Category' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Category' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
	    ;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'term' ) )
		;
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getCategoryMatchForTermAndNamespaces' )
		    ->with   ( 'term', array( NS_CATEGORY ) )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setCategoryMatch' )
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
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Category::registerComponents
	 */
	public function testRegisterComponents() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$selectMethods = array( 
				'registerQueryParams', 'registerFilterQueries', 'configureQueryFields'
				);
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Category' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( $selectMethods )
		                   ->getMock();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'configureQueryFields' )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerQueryParams' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerFilterQueries' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Category', 'registerComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Category::registerFilterQueryForMatch
	 */
	public function testRegisterFilterQueryForMatch() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'hasCategoryMatch', 'getCategoryMatch', 'setFilterQuery' ) );
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Category' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getResult' ) )
		                  ->getMock();
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Result' )
		                   ->setMethods( array( 'getVar' ) )
		                   ->getMock();
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Category' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'hasCategoryMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getCategoryMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getVar' )
		    ->with   ( 'id' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setFilterQuery' )
		    ->with   ( Wikia\Search\Utilities::valueForField( 'id', 123, array( 'negate' => true ) ), 'cat' )
		;
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Category', 'registerFilterQueryForMatch' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Category::configureQueryFields 
	 */
	public function testConfigureQueryFields() {
                $mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'setQueryField' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Category' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
                
                $mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setQueryField' )
                    ->with ('categories',7)
                    ->will ( $this->returnValue( $mockConfig ) )
		;
                
		$get = new ReflectionProperty( 'Wikia\Search\QueryService\Select\Category', 'config' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$get->getValue( $mockSelect )
		);
	}
        
        public function testgetFilterQueryString() {
               $mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getCategoryMatch' ) );
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Category' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getResult' ) )
		                  ->getMock();
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Result' )
		                   ->setMethods( array( 'getVar' ) )
		                   ->getMock();
                
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Category' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array() )
		                   ->getMock();
            
                
                $mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getCategoryMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getVar' )
		    ->with   ( 'id' )
		    ->will   ( $this->returnValue( 123 ) )
		;
            
                $get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Category', 'getFilterQueryString' );
		$get->setAccessible( true );
		$this->assertEquals(
                                array(Wikia\Search\Utilities::valueForField( 'pageid', $mockResult )),
				$get->invoke( $mockSelect )
		);
                	
	
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Category::getQueryFieldsString 
	 */
	public function testGetQueryFieldsString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQueryFieldsToBoosts' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Category' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array() )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsToBoosts' )
		    ->will   ( $this->returnValue( array( 'categories' => 25 ) ) )
		;
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Category', 'getQueryFieldsString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'categories^125',
				$get->invoke( $mockSelect )
		);
	}
	
}