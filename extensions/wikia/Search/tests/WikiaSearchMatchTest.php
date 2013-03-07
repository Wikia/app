<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchMatchTest extends WikiaSearchBaseTest {

	/**
	 * @covers Wikia\Search\Match\AbstractMatch::__construct
	 * @covers Wikia\Search\Match\AbstractMatch::getId
	 */
	public function testAbstractConstruct() {
		$interface = Wikia\Search\MediaWikiInterface::getInstance();
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\AbstractMatch' )
		                  ->setConstructorArgs( array( 123, $interface ) )
		                  ->getMockForAbstractClass();
		
		$this->assertAttributeEquals(
				123, 
				'id', 
				$mockMatch
		);
		$this->assertAttributeEquals(
				$interface, 
				'interface', 
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
		$mockInterface = $this->getMockBuilder( 'Wikia\Search\MediaWikiInterface' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getCanonicalPageIdFromPageId' ) )
		                      ->getMock();
		
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                   ->setConstructorArgs( array( 123, $mockInterface ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockInterface
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 456 ) )
		;
		$this->assertTrue(
				$mockResult->hasRedirect()
		);
		$mockInterface
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
		$interfaceMethods = array( 
				'getWikiId', 'getTitleStringFromPageId', 'getUrlFromPageid', 'getNamespaceFromPageId',
				'getCanonicalPageIdFromPageId', 'getFirstRevisionTimestampForPageId','getLastRevisionTimestampForPageId',
				'getSnippetForPageId', 'getNonCanonicalTitleStringFromPageId', 'getNonCanonicalUrlFromPageId'
				);
		
		$mockInterface = $this->getMockBuilder( 'Wikia\Search\MediaWikiInterface' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( $interfaceMethods )
		                      ->getMock();
		
		$pageId = 123;
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                   ->setConstructorArgs( array( $pageId, $mockInterface ) )
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
		$snippet = "This be my snippet";
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
		
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( $wid ) )
		;
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $canonicalPageId ) )
		;
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $titleString ) )
		;
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getUrlFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $url ) )
		;
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getFirstRevisionTimestampForPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $created ) )
		;
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getLastRevisionTimestampForPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $touched ) )
		;
		$mockInterface
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
		$mockInterface
		    ->expects( $this->atLeastOnce() )
		    ->method ( 'getNonCanonicalTitleStringFromPageId' )
		    ->with   ( $pageId )
		    ->will   ( $this->returnValue( $nonCanonicalTitle ) )
		;
		$mockInterface
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
				$snippet."&hellip;",
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
		$interfaceMethods = array(
				'getGlobalForWiki', 'getMainPageUrlForWikiId', 'getDescriptionTextForWikiId',
				'getStatsInfoForWikiId', 'getVisualizationInfoForWikiId', 'getHubForWikiId' 
				);
		$mockInterface = $this->getMockBuilder( 'Wikia\Search\MediaWikiInterface' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( $interfaceMethods )
		                      ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->setConstructorArgs( array( 123, $mockInterface ) )
		                  ->setMethods( null )
		                  ->getMock();
		
		$title = 'My title';
		$url = 'http://foo.wikia.com/wiki/';
		$text = 'this is a wiki about foo';
		$desc = 'this is a better description';
		$visualization = array( 'description' => $desc );
		$stats = array( 'users_count' => 100 );
		$hub = 'Entertainment';
		$mockInterface
		    ->expects( $this->once() )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgSitename', 123 )
		    ->will   ( $this->returnValue( $title ) ) 
		;
		$mockInterface
		   ->expects( $this->once() )
		   ->method ( 'getMainPageUrlForWikiId' )
		   ->with   ( 123 )
		   ->will   ( $this->returnValue( $url ) )
		;
		$mockInterface
		   ->expects( $this->once() )
		   ->method ( 'getDescriptionTextForWikiId' )
		   ->with   ( 123 )
		   ->will   ( $this->returnValue( $text ) )
		;
		$mockInterface
		   ->expects( $this->once() )
		   ->method ( 'getHubForWikiId' )
		   ->with   ( 123 )
		   ->will   ( $this->returnValue( $hub ) )
		;
		$mockInterface
		   ->expects( $this->once() )
		   ->method ( 'getVisualizationInfoForWikiId' )
		   ->with   ( 123 )
		   ->will   ( $this->returnValue( $visualization ) )
		;
		$mockInterface
		   ->expects( $this->once() )
		   ->method ( 'getStatsInfoForWikiId' )
		   ->with   ( 123 )
		   ->will   ( $this->returnValue( $stats ) )
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
				$desc."&hellip;",
				$result->getText()
		);
		$this->assertEquals(
				123,
				$result['wid']
		);
		$this->assertTrue(
				$result['isWikiMatch']
		);
		$this->assertEquals(
				$url,
				$result['url']
		);
	}
}