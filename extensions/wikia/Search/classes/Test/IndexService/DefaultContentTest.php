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
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::getPageContentFromParseResponse
	 */
	public function testGetPagContentFromParseResponse() {
		$service = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', array( 'getService', 'prepValuesFromHtml' ) );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', array( 'getGlobal' ) );
		$html = '<div>this is my html &amp; stuff</div>';
		$response = [ 'parse' => [ 'text' => [ '*' => $html ] ] ];
		$get = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'getPageContentFromParseResponse' );
		$get->setAccessible( true );
		$service
		    ->expects( $this->any() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'AppStripsHtml' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				[ 'html' => '<div>this is my html & stuff</div>' ],
				$get->invoke( $service, $response )
		);
		$service
		    ->expects( $this->any() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'AppStripsHtml' )
		    ->will   ( $this->returnValue( true ) )
		;
		$prepped = [ 'html' => 'this is my html & stuff' ];
		$service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'prepValuesFromHtml' )
		    ->will   ( $this->returnValue( $prepped ) )
		;
		$this->assertEquals(
				$prepped,
				$get->invoke( $service, $response )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::getCategoriesFromParseResponse
	 */
	public function testGetCategoriesFromParseResponse() {
		$service = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', array( 'field' ) );
		$get = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'getCategoriesFromParseResponse' );
		$get->setAccessible( true );
		$response = [ 'parse' => [ 'categories' => [ [ '*' => 'this_is_an_example' ], [ '*' => 'here_is_another' ] ] ] ];
		$service
		    ->expects( $this->once() )
		    ->method ( 'field' )
		    ->with   ( 'categories' )
		    ->will   ( $this->returnValue( 'categories_mv_en' ) )
		;
		$this->assertEquals(
				[ 'categories_mv_en' => [ 'this is an example', 'here is another' ] ],
				$get->invoke( $service, $response )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::getHeadingsFromParseResponse
	 */
	public function testGetHeadingsFromParseResponse() {
		$service = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', array( 'field' ) );
		$get = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'getHeadingsFromParseResponse' );
		$get->setAccessible( true );
		$response = [ 'parse' => [ 'sections' => [ [ 'line' => 'first' ], [ 'line' => 'second' ] ] ] ];
		$service
		    ->expects( $this->once() )
		    ->method ( 'field' )
		    ->with   ( 'headings' )
		    ->will   ( $this->returnValue( 'headings_mv_en' ) )
		;
		$this->assertEquals(
				[ 'headings_mv_en' => [ 'first', 'second' ] ],
				$get->invoke( $service, $response )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::prepValuesFromHtml
	 */
	public function testPrepValuesFromHtml() {
		$service = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', array( 'field' ) );
		$prep = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'prepValuesFromHtml' );
		$prep->setAccessible( true );
		$service
		    ->expects( $this->once() )
		    ->method ( 'field' )
		    ->with   ( 'html' )
		    ->will   ( $this->returnValue( 'html_en' ) )
		;
		$html = <<<ENDIT
This is a very long example so we can do some counts and stuff.
We're no strangers to love
You know the rules and so do I
A full commitment's what I'm thinking of
You wouldn't get this from any other guy
I just wanna tell you how I'm feeling
Gotta make you understand
Never gonna give you up
Never gonna let you down
Never gonna run around and desert you
Never gonna make you cry
Never gonna say goodbye
Never gonna tell a lie and hurt you
We've known each other for so long
Your heart's been aching but
You're too shy to say it
Inside we both know what's been going on
We know the game and we're gonna play it
And if you ask me how I'm feeling
Don't tell me you're too blind to see
Never gonna give you up
Never gonna let you down
Never gonna run around and desert you
Never gonna make you cry
Never gonna say goodbye
Never gonna tell a lie and hurt you
ENDIT;
		
		$result = $prep->invoke( $service, $html );
		$this->assertEquals(
				preg_replace( '/\s+/', ' ', $html ) . ' ',
				$result['html_en']
		);
		$this->assertGreaterThanOrEqual(
				str_word_count( $result['nolang_txt'] ), 
				$result['words']
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::removeGarbageFromDom
	 */
	public function testRemoveGarbageFromDom() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$dom = $this->getMockBuilder( 'simple_html_dom' )
		            ->disableOriginalConstructor()
		            ->setMethods( array( 'find' ) )
		            ->getMock();
		$node = $this->getMockBuilder( 'simple_html_dom_node' )
		             ->disableOriginalConstructor()
		             ->setMethods( null )
		             ->getMock();
		$node->outertext = '<div class="foo">bar</div>';
		$this->assertNotEmpty( $node->outertext );
		$garbage = new ReflectionProperty( 'Wikia\Search\IndexService\DefaultContent', 'garbageSelectors' );
		$garbage->setAccessible( true );
		$garbage->setValue( $service, array( 'div.foo' ) );
		$remove = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'removeGarbageFromDom' );
		$remove->setAccessible( true );
		$dom
		    ->expects( $this->once() )
		    ->method ( 'find' )
		    ->with   ( 'div.foo' )
		    ->will   ( $this->returnValue( array( $node ) ) )
		;
		$remove->invoke( $service, $dom );
		$this->assertEquals(
				' ',
				$node->outertext
		);
	}
}