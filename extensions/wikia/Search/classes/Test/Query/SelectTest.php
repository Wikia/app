<?php
/**
 * Class definition for Wikia\Search\Test\Query\Select
 */
namespace Wikia\Search\Test\Query;
use Wikia\Search\Query\Select as Query, Wikia\Search\MediaWikiService, Wikia\Search\Test\BaseTest, ReflectionMethod, ReflectionProperty;

class SelectTest extends BaseTest
{
	/**
	 * @covers Wikia\Search\Query\Select::__construct
	 */
	public function testConstruct()
	{
		$query = new Query( 'foo' );
		$this->assertAttributeEquals(
				'foo',
				'rawQuery',
				$query
		);
	}
	
	/**
	 * @covers Wikia\Search\Query\Select::getSanitizedQuery
	 */
	public function testGetSanitizedQuery()
	{
		$sanitizer = $this->getMock( 'Sanitizer', array( 'StripAllTags' ) );
		$this->mockClass( 'Sanitizer', $sanitizer );
		$rawQuery = "crime &amp; <b>punishment</b>";
		$expected = "crime & punishment";
		$query = new Query( $rawQuery );
		$this->assertAttributeEmpty(
				'sanitizedQuery',
				$query
		);
		$sanitizer
		    ->staticExpects( $this->once() )
		    ->method       ( 'StripAllTags' )
		    ->with         ( $rawQuery )
		    ->will         ( $this->returnValue( "crime &amp; punishment" ) )
		;
		$this->assertEquals(
				$expected,
				$query->getSanitizedQuery()
		);
		$this->assertAttributeEquals(
				$expected,
				'sanitizedQuery',
				$query
		);
	}
	
	/**
	 * @covers Wikia\Search\Query\Select::getQueryForHtml
	 */
	public function testGetQueryForHtml() {
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSanitizedQuery' ], [ 'foo' ] );
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( "crime & punishment" ) )
		;
		$this->assertEquals(
				"crime &amp; punishment",
				$mockQuery->getQueryForHtml()
		);
	}
	
	/**
	 * @covers Wikia\Search\Query\Select::hasTerms
	 */
	public function testHasTerms() {
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSanitizedQuery' ], [ 'foo' ] );
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( ' ' ) )
		;
		$this->assertFalse(
				$mockQuery->hasTerms()
		);
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'drive slow, homie' ) )
		;
		$this->assertTrue(
				$mockQuery->hasTerms()
		);
	}
	
	/**
	 * @covers Wikia\Search\Query\Select::getService
	 */
	public function testGetService() {
		$query = new Query( 'foo' );
		$method = new ReflectionMethod( 'Wikia\Search\Query\Select', 'getService' );
		$method->setAccessible( true );
		$this->assertInstanceOf(
				'Wikia\Search\MediaWikiService',
				$method->invoke( $query )
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\MediaWikiService',
				'service',
				$query
		);
	}
	
	/**
	 * @covers Wikia\Search\Query\Select::initializeNamespaceData
	 * @covers Wikia\Search\Query\Select::getNamespacePrefix
	 * @covers Wikia\Search\Query\Select::getNamespaceId
	 */
	public function testNamespaceLogic() {
		$query = new Query( 'ThisIsNotANamespace:Bar' );
		$this->assertNull(
				$query->getNamespaceId()
		);
		$this->assertNull(
				$query->getNamespacePrefix()
		);
		$query = new Query( 'Category:Things That Are Namespaces' );
		$this->assertEquals(
				NS_CATEGORY,
				$query->getNamespaceId()
		);
		$this->assertEquals(
				'Category',
				$query->getNamespacePrefix()
		);
	}
	
	/**
	 * @covers Wikia\Search\Query\Select::getNamespacePrefix
	 */
	public function testGetNamespacePrefix() {
		$query = $this->getMockBuilder( 'Wikia\Search\Query\Select' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'initializeNamespaceData' ] )
		              ->getMock();
		
		$query
		    ->expects( $this->once() )
		    ->method ( 'initializeNamespaceData' )
		;
		
		$attr = new ReflectionProperty( $query, 'namespacePrefix' );
		$attr->setAccessible( true );
		$attr->setValue( $query, 'foo' );
		
		$this->assertAttributeEmpty(
				'namespaceChecked',
				$query
		);
		$this->assertEquals(
				'foo',
				$query->getNamespacePrefix()
		);
		$nsattr = new ReflectionProperty( $query, 'namespaceChecked' );
		$nsattr->setAccessible( true );
		$nsattr->setValue( $query,true );
		$this->assertEquals(
				'foo',
				$query->getNamespacePrefix()
		); 
	}
	
	/**
	 * @covers Wikia\Search\Query\Select::getSolrQuery
	 */
	public function testGetSolrQuery() {
		$query = new Query( "Category:Shortcuts" );
		$this->assertEquals(
				"Shortcuts",
				$query->getSolrQuery()
		);
		$query = new Query( "123foo" );
		$this->assertEquals(
				"123 foo",
				$query->getSolrQuery()
		);
		$query = new Query( '"foo:bar&&baz"' );
		$this->assertEquals(
				'\"foo\:bar\&&baz\"',
				$query->getSolrQuery()
		);
	}
	
	public function testGetSolrQueryWithWordLimit() {
		$query = <<<YEEZY
Uh:my mind move like a Tron bike
Uh, pop a wheelie on the Zeitgeist
Uh, I'm finna start a new movement
YEEZY;
		$q = new Query( $query );
		$this->assertEquals(
				'Uh\:my mind move like a Tron bike Uh, pop a',
				$q->getSolrQuery( 10 )
		);

		$sQuery = 'test';
		$q = new Query( $sQuery );
		$this->assertEquals(
			$sQuery,
			$q->getSolrQuery( 10 )
		);
	}
}