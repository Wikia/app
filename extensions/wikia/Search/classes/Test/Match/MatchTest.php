<?php
/**
 * Class definition for Wikia\Search\Test\Match\MatchTest
 */
namespace Wikia\Search\Test\Match;
use Wikia\Search\Test\BaseTest, ReflectionProperty, ReflectionMethod, Wikia\Search\MediaWikiService;
/**
 * Tests Wikia\Search\Match classes
 */
class MatchTest extends BaseTest {

	/**
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
	 * @covers Wikia\Search\Match\Article::hasRedirect
	 */
	public function testArticleMatchHasRedirect() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getCanonicalPageIdFromPageId' ) )
		                      ->getMock();
		
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                   ->setConstructorArgs( array( 123, $mockService ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 456 ) )
		;
		$this->assertTrue(
				$mockResult->hasRedirect()
		);
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$this->assertFalse(
				$mockResult->hasRedirect()
		);
	}
	
	/**
	 * @covers Wikia\Search\Match\Article::createResult
	 */
	public function testCreateResultArticle() {
		$serviceMethods = array( 
				'getWikiId', 'getTitleStringFromPageId', 'getUrlFromPageid', 'getNamespaceFromPageId',
				'getCanonicalPageIdFromPageId', 'getFirstRevisionTimestampForPageId','getLastRevisionTimestampForPageId',
				'getSnippetForPageId', 'getNonCanonicalTitleStringFromPageId', 'getNonCanonicalUrlFromPageId'
				);
		
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( $serviceMethods )
		                      ->getMock();
		
		$pageId = 123;
		$highlight = 'long span class';

		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                   ->setConstructorArgs( array( $pageId, $mockService,$highlight ) )
		                   ->setMethods( array( 'hasRedirect' ) )
		                   ->getMock();
		
		
		$wid = 321;
		$canonicalPageId = 456;
		$titleString = 'my title';
		$nonCanonicalTitle = 'my other title';
		$url = 'http://foo.wikia.com/wiki/Turducken';
		$nonCanonicalUrl = 'http://foo.wikia.com/wiki/Turduckens';
		$created = '30 days ago';
		$touched = 'now';
		$snippet = "This be my long snippet";

		$highlighted = 'This be my <span class="searchmatch">long</span> snippet&hellip;';

		$fieldsArray = array(
				'id' => sprintf( '%s_%s', $wid, $canonicalPageId ),
				'pageid' => $pageId,
				'wid' => $wid,
				'title'=> $titleString,
				'url' => $url,
				'score' => 'PTT',
				'isArticleMatch' => true,
				'ns' => 0,
				'created' => $created,
				'touched' => $touched
				);

		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( $wid ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $canonicalPageId ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $titleString ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getUrlFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $url ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getFirstRevisionTimestampForPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $created ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getLastRevisionTimestampForPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $touched ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getSnippetForPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $snippet ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'hasRedirect' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getNonCanonicalTitleStringFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $nonCanonicalTitle ) )
		;
		$mockService
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getNonCanonicalUrlFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $nonCanonicalUrl ) )
		;
		$result = $mockMatch->createResult();
		$this->assertInstanceOf(
				'Wikia\Search\Result',
				$result
		);
		$this->assertEquals(
				$highlighted,
				$result->getText()
		);
		$this->assertEquals(
				$nonCanonicalTitle,
				$result->getVar( 'redirectTitle' )
		);
		$this->assertEquals(
				$nonCanonicalUrl,
				$result->getVar( 'redirectUrl' )
		);
	}
	
	/**
	 * @covers Wikia\Search\Match\Wiki::createResult
	 */
	public function testWikiMatchCreateResult() {
		$serviceMethods = array( 'getResult', 'setCrossWiki', 'setWikiId' );
		$mockService = $this->getMockBuilder( 'SolrDocumentService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( $serviceMethods )
		                      ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'getId' ] )
		                  ->getMock();
		
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Result' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'offsetSet' ] )
		                   ->getMock();
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'setCrossWiki' )
		    ->with   ( true )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'setWikiId' )
		    ->with   ( 123 )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'offsetSet' )
		    ->with   ( 'exactWikiMatch', true )
		;
		
		$this->proxyClass( 'SolrDocumentService', $mockService );
		$this->mockApp();
		$this->assertEquals(
				$mockResult,
				$mockMatch->createResult()
		);
		
	}
}