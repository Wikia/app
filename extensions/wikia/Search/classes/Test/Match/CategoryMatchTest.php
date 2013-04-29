<?php

/**
 * Class definition for Wikia\Search\Test\Match\CategoryMatchTest
 */
require_once 'PHPUnit/Framework.php';
require_once 'Wikia/Search/Match/Category.php';
require_once 'Wikia/Search/MediaWikiService.php';
require_once 'Wikia/Search/Match/AbstractMatch.php';
require_once 'Wikia/Search/Result.php';

class CategoryMatchTest extends PHPUnit_Framework_TestCase {
         /*
	 * @covers Wikia\Search\Match\AbstractMatch::__construct
	 * @covers Wikia\Search\Match\AbstractMatch::getId
	 */
    
	public function testAbstractConstruct() {
                $service = new MediaWikiService;
            
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\AbstractMatch' )
		                  ->setConstructorArgs( array( 123, $service ) )
		                  ->getMockForAbstractClass();
		
                $this->assertAttributeEquals(
				123, 
				'id', 
				$mockMatch
		);
		$this->assertAttributeEquals(
				$service, 
				'service', 
				$mockMatch
		);
		$this->assertEquals(
				123,
				$mockMatch->getId()
		);
	}
	
	/**
	 * @covers Wikia\Search\Match\AbstractMatch::getResult
        */
	public function testAbstractGetResult() {
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\AbstractMatch' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'createResult' ) )
		                  ->getMockForAbstractClass();
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Result' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'createResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$this->assertEquals(
				$mockResult,
				$mockMatch->getResult()
		);
	}


         /**
	 * @covers Wikia\Search\Match\Category::createResult
	 */
	public function testCategoryMatchCreateResult() {
		$serviceMethods = array(
				        'getTitleStringFromPageId', 'getNamespaceFromPageId',
				        'getCanonicalPageIdFromPageId'
				);
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( $serviceMethods )
		                      ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Category' )
		                  ->setConstructorArgs( array( 123, $mockService ) )
		                  ->setMethods( null )
		                  ->getMock();
		
		$title = 'My title';
		$canonicalPageId = 456;
                $fieldsArray = array(
				'id' => $canonicalPageId,
				'title'=> $title,
				'isCategoryMatch' => true,
				'ns' => 16
				);
                
                $mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $canonicalPageId ) )
		;
                $mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $title ) )
		;
                $mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 16 ) )
		;
		
		$result = $mockMatch->createResult();
		$this->assertInstanceOf(
				'Wikia\Search\Result',
				$result
		);
		$this->assertEquals(
				$title,
				$result->getTitle()
		);
		
		$this->assertEquals(
				123,
				$result['id']
		);
		$this->assertTrue(
				$result['isCategoryMatch']
		);
		
	}
}