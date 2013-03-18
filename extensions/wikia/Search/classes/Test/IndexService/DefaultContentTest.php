<?php
/**
 * Class definition for Wikia\Search\Test\IndexService\DefaultContentTest
 */
namespace Wikia\Search\Test\IndexService;
use Wikia\Search\Test\BaseTest, Wikia\Search\IndexService\DefaultContent, ReflectionMethod, ReflectionProperty;
/**
 * Tests the Default Content service, which is pretty thorny
 * @author relwell
 */
class DefaultContentTest extends BaseTest
{
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::Field
	 */
	public function testField() {
		$dynamicField = \Wikia\Search\Utilities::field( 'html' );
		$mockService = $this->getMock( 'Wikia\Search\MediaWikiService', array( 'getGlobal' ) );
		$utils = $this->getMock( 'Wikia\Search\Utilities', array( 'field' ) );
		$this->proxyClass( 'Wikia\Search\MediaWikiService', $mockService );
		$this->proxyClass( 'Wikia\Search\Utilities', $utils );
		$this->mockApp();
		$dc = new DefaultContent();
		$field = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'field' );
		$field->setAccessible( true );
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'AppStripsHtml' )
		    ->will   ( $this->returnValue( true ) )
		;
		$utils
		    ->staticExpects( $this->once() )
		    ->method       ( 'field' )
		    ->with         ( 'html' )
		    ->will         ( $this->returnValue( $dynamicField ) )
		;
		$this->assertEquals(
				$dynamicField,
				$field->invoke( $dc, 'html' )
		);
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'AppStripsHtml' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				'html',
				$field->invoke( $dc, 'html' )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::execute
	 */
	public function testExecute() {
		$methods = [ 'getService', 'field', 'getPageContentFromParseResponse', 'getCategoriesFromParseResponse', 'getHeadingsFromParseResponse' ];
		$service = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', $methods, array() );
		$mwMethods = [
				'getParseResponseFrompageId', 'getTitleStringFromPageId', 'getUrlFromPageId',
				'getNamespaceFromPageId', 'getHostName', 'getSimpleLanguageCode', 'getGlobal',
				'isPageIdContent', 'isPageIdMainPage', 'getCanonicalPageIdFromPageId', 'getWikiId'
				];
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', $mwMethods );
		$html = 'this is my html';
		$parseResponse = [ 'parse' => [ 'text' => [ '*' => $html ], 'images' => [ 'this.jpg', 'that.gif' ] ] ];
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getParseResponseFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $parseResponse ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( "my title" ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 321 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ('getUrlFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'http://foo.wikia.com/wiki/Foo' ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getNamespaceFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getHostName' )
		    ->will   ( $this->returnValue( 'foo.wikia.com' ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getSimpleLanguageCode' )
		    ->will   ( $this->returnValue( 'en' ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Sitename' )
		    ->will   ( $this->returnValue( "My Wiki" ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'isPageIdContent' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( true ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'isPageIdMainPage' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( false ) )
		;
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'field' )
		    ->with   ( 'title' )
		    ->will   ( $this->returnValue( 'title_en' ) )
		;
		$service
		    ->expects( $this->at( 2 ) )
		    ->method ( 'field' )
		    ->with   ( 'wikititle' )
		    ->will   ( $this->returnValue( 'wikititle_en' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getPageContentFromParseResponse' )
		    ->with   ( $parseResponse )
		    ->will   ( $this->returnValue( [ 'html_en' => $html ] ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getCategoriesFromParseResponse' )
		    ->with   ( $parseResponse )
		    ->will   ( $this->returnValue( [ 'categories_mv_en' => [ 'yup' ] ] ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getHeadingsFromParseResponse' )
		    ->with   ( $parseResponse )
		    ->will   ( $this->returnValue( [ 'headings_mv_en' => [ 'heading' ] ] ) )
		;
		$cpid = new \ReflectionProperty( 'Wikia\Search\IndexService\AbstractService', 'currentPageId' );
		$cpid->setAccessible( true );
		$cpid->setValue( $service, 123 );
		$result = $service->execute();
		$expectedResult = [
				'html_en' => 'this is my html',
				'categories_mv_en' => [ 'yup' ],
				'headings_mv_en' => [ 'heading' ],
				'wid' => 321,
				'pageid' => 123,
				'title_en' => 'my title',
				'titleStrict' => 'my title',
				'url' => 'http://foo.wikia.com/wiki/Foo',
				'ns' => 0,
				'host' => 'foo.wikia.com',
				'lang' => 'en',
				'wikititle_en' => 'My Wiki',
				'page_images' => 2,
				'iscontent' => 'true',
				'is_main_page' => 'false'
				];
		$this->assertEquals(
				$expectedResult,
				$result
		);
		
	}
	
}