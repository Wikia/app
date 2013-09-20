<?php
/**
 * Class definition for Wikia\Search\Test\HooksTest
 */
namespace Wikia\Search\Test;
use Wikia\Search\Hooks;
/**
 * Tests hooks related to Wikia\Search
 */
class HooksTest extends BaseTest {
	
	/**
	 * @covers Wikia\Search\Hooks
	 */
	public function testOnWikiaMobileAssetsPackages() {

		$hooks		= new Hooks;

		$mockTitle	= $this->getMock( 'Title', array( 'isSpecial' ) );
		$jsStatic		= array();
		$jsExtension	= array();
		$cssPkg		= array();

		$mockTitle
			->expects	( $this->at( 0 ) )
			->method	( 'isSpecial' )
			->with		( 'Search' )
			->will		( $this->returnValue( false ) )
		;
		$mockTitle
			->expects	( $this->at( 1 ) )
			->method	( 'isSpecial' )
			->with		( 'Search' )
			->will		( $this->returnValue( true ) )
		;

		$this->mockGlobalVariable( 'wgTitle', $mockTitle );
		$this->assertTrue(
				$hooks->onWikiaMobileAssetsPackages( $jsStatic, $jsExtension, $cssPkg ),
				'As a hook, Wikia\Search\Hooks::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertEmpty(
		        $jsBody,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl not append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array if the title is not special search.'
		);
		$this->assertEmpty(
		        $cssPkg,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages should not append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array  if the title is not special search.'
		);
		$this->assertTrue(
		        $hooks->onWikiaMobileAssetsPackages( $jsHead, $jsBody, $cssPkg ),
		        'As a hook, Wikia\Search\Hooks::onWikiaMobileAssetsPackages must return true.'
		);
		$this->assertContains(
				'wikiasearch_js_wikiamobile',
				$jsBody,
				'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_js_wikiamobile" to the jsBodyPackages array.'
		);
		$this->assertContains(
		        'wikiasearch_scss_wikiamobile',
		        $cssPkg,
		        'Wikia\Search\Hooks::onWikiaMobileAssetsPackages shoudl append the value "wikiasearch_scss_wikiamobile" to the jsBodyPackages array.'
		);
	}
	
	/**
	 * @covers Wikia\Search\Hooks::onArticleDeleteComplete
	 */
	public function testOnArticleDeleteComplete() {
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->getMock();
		$mockUser = $this->getMockBuilder( 'User' )
		                 ->disableOriginalConstructor()
		                 ->getMock();
		$mockHooks = $this->getMock( 'Wikia\Search\Hooks', null );
		$mockIndexer = $this->getMock( 'Wikia\Search\Indexer', array( 'deleteArticle' ) );
		$mockIndexer
		    ->expects( $this->once() )
		    ->method ( 'deleteArticle' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$this->assertTrue(
				$mockHooks->onArticleDeleteComplete( $mockArticle, $mockUser, 'why not', 123 )
		);
	}
	
	/**
	 * @covers Wikia\Search\Hooks::onArticleSaveComplete
	 */
	public function testOnArticleSaveComplete() {
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->getMock();
		$mockUser = $this->getMockBuilder( 'User' )
		                 ->disableOriginalConstructor()
		                 ->getMock();
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getArticleID' ) )
		                  ->getMock();
		$mockRev = $this->getMockBuilder( 'Revision' )
		                ->disableOriginalConstructor()
		                ->getMock();
		$mockHooks = $this->getMock( 'Wikia\Search\Hooks', null );
		$mockIndexer = $this->getMock( 'Wikia\Search\Indexer', array( 'reindexBatch' ) );
		$mockArticle
		    ->expects( $this->once() )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getArticleID' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockIndexer
		    ->expects( $this->once() )
		    ->method ( 'reindexBatch' )
		    ->with   ( array( 123 ) )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$whatevs = array();
		$whatevs2 = 0;
		$this->assertTrue(
				$mockHooks->onArticleSaveComplete( $mockArticle, $mockUser, 'why not', 'yup', 0, 0, 'foo', $whatevs, $mockRev, $whatevs2, $whatevs2 )
		);
	}
	
	/**
	 * @covers Wikia\Search\Hooks::onArticleUndelete
	 */
	public function testOnArticleUndelete() {
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getArticleID' ) )
		                  ->getMock();
		$mockHooks = $this->getMock( 'Wikia\Search\Hooks', null );
		$mockIndexer = $this->getMock( 'Wikia\Search\Indexer', array( 'reindexBatch' ) );
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getArticleID' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockIndexer
		    ->expects( $this->once() )
		    ->method ( 'reindexBatch' )
		    ->with   ( array( 123 ) )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$whatevs = array();
		$whatevs2 = 0;
		$this->assertTrue(
				$mockHooks->onArticleUndelete( $mockTitle, 0 )
		);
	}
	
	/**
	 * @covers Wikia\Search\Hooks::onWikiFactoryPublicStatusChange
	 */
	public function testOnWikiFactoryPublicStatusChange() {
		$mockIndexer = $this->getMock( 'Wikia\Search\Indexer', array( 'reindexWiki', 'deleteWikiDocs' ) );
		$hooks = new \Wikia\Search\Hooks;
		$mockIndexer
		    ->expects( $this->at( 0 ) )
		    ->method ( 'deleteWikiDocs' )
		    ->will   ( $this->returnValue( true ) )
		;
		$status = 0;
		$wid = 123;
		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$this->assertTrue(
				$hooks->onWikiFactoryPublicStatusChange( $status, $wid, 'why not' )
		);
		$mockIndexer
		    ->expects( $this->at( 0 ) )
		    ->method ( 'reindexWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$status = 1;
		$this->mockClass( 'Wikia\Search\Indexer', $mockIndexer );
		$this->assertTrue(
				$hooks->onWikiFactoryPublicStatusChange( $status, $wid, 'why not' )
		);
	}
	
	/**
	 * @covers Wikia\Search\Hooks::onGetPreferences
	 */
	public function testonGetPreferences() {
		$badKeys = array(
			'searchlimit',
			'contextlines',
			'contextchars',
			'disablesuggest',
			'searcheverything',
			'searchnamespaces',
		);
		$prefs = array_flip( $badKeys );
		$mockUser = $this->getMock( 'User' );
		$hooks = new \Wikia\Search\Hooks;
		$hooks->onGetPreferences( $mockUser, $prefs );
		foreach ( $badKeys as $key ) {
			$this->assertArrayNotHasKey( $key , $prefs );
		}
		$this->assertArrayHasKey( 'enableGoSearch', $prefs );
		$this->assertArrayHasKey( 'searchAllNamespaces', $prefs );
	}
	
	/**
	 * @covers Wikia\Search\Hooks::onLinkEnd
	 * @covers Wikia\Search\Hooks::popLinks
	 */
	public function testOnLinkEndAndPopLinks() {
		$mockService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getWikiId', 'getCanonicalPageIdFromPageId' ] );
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( [ 'getArticleId' ] )
		                  ->getMock();
		
		$mockSkin = $this->getMockBuilder( 'Skin' )
		                 ->disableOriginalConstructor()
		                 ->getMock();
		
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getArticleId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 456 ) )
		;
		$mockService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$options = [];
		$text = 'foo';
		$attribs = [];
		$ret = false;
		$expected = '123_456 | foo';
		$this->mockClass( 'Wikia\Search\MediaWikiService', $mockService );
		$this->assertTrue(
				\Wikia\Search\Hooks::onLinkEnd( $mockSkin, $mockTitle, $options, $text, $attribs, $ret )
		);
		$this->assertAttributeContains(
				$expected,
				'outboundLinks',
				'Wikia\Search\Hooks'
		);
		$this->assertEquals(
				[ $expected ],
				\Wikia\Search\Hooks::popLinks()
		);
		$this->assertAttributeEmpty(
				'outboundLinks',
				'Wikia\Search\Hooks'
		);
	}
}