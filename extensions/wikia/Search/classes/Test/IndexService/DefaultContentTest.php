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
		$this->mockClass( 'Wikia\Search\MediaWikiService', $mockService );
		$this->mockClass( 'Wikia\Search\Utilities', $utils );
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
		$methods = [ 'getService', 'field', 'getPageContentFromParseResponse', 'getCategoriesFromParseResponse', 'getHeadingsFromParseResponse', 'getOutboundLinks', 'pushNolangTxt', 'getNolangTxt' ];
		$service = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', $methods, array() );
		$mwMethods = [
				'getParseResponseFrompageId', 'getTitleStringFromPageId', 'getUrlFromPageId',
				'getNamespaceFromPageId', 'getHostName', 'getSimpleLanguageCode', 'getGlobal', 'setGlobal',
				'isPageIdContent', 'isPageIdMainPage', 'getCanonicalPageIdFromPageId', 'getWikiId', 'registerHook'
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
		    ->method ( 'registerHook' )
		    ->with   ( 'LinkEnd', 'Wikia\Search\Hooks', 'onLinkEnd' )
		;
		$mwService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'BacklinksEnabled' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Sitename' )
		    ->will   ( $this->returnValue( "My Wiki" ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'setGlobal' )
		    ->with   ( 'EnableParserCache', false )
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
		    ->method ( 'pushNoLangTxt' )
		    ->with   ( "my title" )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->at( 2 ) )
		    ->method ( 'pushNoLangTxt' )
		    ->with   ( "my title" )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->at( 3 ) )
		    ->method ( 'field' )
		    ->with   ( 'title' )
		    ->will   ( $this->returnValue( 'title_en' ) )
		;
		$service
		    ->expects( $this->at( 4 ) )
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
		$service
		    ->expects( $this->once() )
		    ->method ( 'getOutboundLinks' )
		    ->will   ( $this->returnValue( [ 'outbound_links_txt' => [ '123_321|hey', '123_456|ho' ] ] ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getNolangTxt' )
		    ->will   ( $this->returnValue( [ 'nolang_txt' => [ 'foo' ] ] ) )
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
				'is_main_page' => 'false',
				'outbound_links_txt' => [ '123_321|hey', '123_456|ho' ],
				'nolang_txt' => [ 'foo' ]
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
	 * @covers Wikia\Search\IndexService\DefaultContent::getOutboundLinks
	 */
	public function testGetOutboundLinks() {
		$mockMwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal' ] );
		$mockHooks = $this->getStaticMethodMock( 'Wikia\Search\Hooks', 'popLinks' );
		$mockService = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                    ->setMethods( [ 'getService', 'getCurrentDocumentId' ] )
		                    ->disableOriginalConstructor()
		                    ->getMock();
		$docId = '123_321';
		$anotherPage = '123_456 | another page';
		$samePage = '123_321 | edit';
		$backlinks = [ $samePage, $anotherPage ];
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mockMwService ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getCurrentDocumentId' )
		    ->will   ( $this->returnValue( $docId ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'BacklinksEnabled' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockHooks
		    ->expects( $this->once() )
		    ->method ( 'popLinks' )
		    ->will   ( $this->returnValue( $backlinks ) )
		;
		$get = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'getOutboundLinks' );
		$get->setAccessible( true );
		$this->assertEquals(
				[ 'outbound_links_txt' => [ $anotherPage ] ],
				$get->invoke( $mockService )
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
		$service = $this->getMock( 'Wikia\Search\IndexService\DefaultContent', array( 'field', 'pushNolangTxt' ) );
		$prep = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'prepValuesFromHtml' );
		$prep->setAccessible( true );
		$service
		    ->expects( $this->once() )
		    ->method ( 'field' )
		    ->with   ( 'html' )
		    ->will   ( $this->returnValue( 'html_en' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'pushNoLangTxt' )
		    ->withAnyParameters()
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
		$garbage->setValue( $service, [ 'div.foo' ] );
		$remove = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'removeGarbageFromDom' );
		$remove->setAccessible( true );
		$dom
		    ->expects( $this->once() )
		    ->method ( 'find' )
		    ->with   ( 'div.foo' )
		    ->will   ( $this->returnValue( [ $node ] ) )
		;
		$remove->invoke( $service, $dom );
		$this->assertEquals(
				' ',
				$node->outertext
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::extractAsidesFromDom
	 */
	public function testExtractAsidesFromDom() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$dom = $this->getMockBuilder( 'simple_html_dom' )
		            ->disableOriginalConstructor()
		            ->setMethods( [ 'find', 'load', 'save' ] )
		            ->getMock();
		$node = $this->getMockBuilder( 'simple_html_dom_node' )
		             ->disableOriginalConstructor()
		             ->setMethods( [ '__get', '__set' ] )
		             ->getMock();
		$garbage = new ReflectionProperty( 'Wikia\Search\IndexService\DefaultContent', 'asideSelectors' );
		$garbage->setAccessible( true );
		$garbage->setValue( $service, [ 'table' ] );
		$remove = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'extractAsidesFromDom' );
		$remove->setAccessible( true );
		$dom
		    ->expects( $this->at( 0 ) )
		    ->method ( 'find' )
		    ->with   ( 'table' )
		    ->will   ( $this->returnValue( array( $node ) ) )
		;
		$node
		    ->expects( $this->at( 0 ) )
		    ->method ( '__get' )
		    ->with   ( 'plaintext' )
		    ->will   ( $this->returnValue( 'crap' ) )
		;
		$node
		    ->expects( $this->at( 1 ) )
		    ->method ( '__set' )
		    ->with   ( 'outertext', ' ' )
		;
		$dom
		    ->expects( $this->at( 1 ) )
		    ->method ( 'save' )
		    ->will   ( $this->returnValue( '<div>other stuff</div>' ) )
		;
		$dom
		    ->expects( $this->at( 2 ) )
		    ->method ( 'load' )
		    ->with   ( '<div>other stuff</div>' )
		;
		$this->assertEquals(
				'crap',
				$remove->invoke( $service, $dom )
		);
	}
	

	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::getParagraphsFromDom
	 */
	public function testGetParagraphsFromDom() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$dom = $this->getMockBuilder( 'simple_html_dom' )
		            ->disableOriginalConstructor()
		            ->setMethods( [ 'find' ] )
		            ->getMock();
		$node = $this->getMockBuilder( 'simple_html_dom_node' )
		             ->disableOriginalConstructor()
		             ->setMethods( [ '__get' ] )
		             ->getMock();
		$remove = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'getParagraphsFromDom' );
		$remove->setAccessible( true );
		$dom
		    ->expects( $this->at( 0 ) )
		    ->method ( 'find' )
		    ->with   ( 'p' )
		    ->will   ( $this->returnValue( array( $node ) ) )
		;
		$node
		    ->expects( $this->at( 0 ) )
		    ->method ( '__get' )
		    ->with   ( 'plaintext' )
		    ->will   ( $this->returnValue( 'graph' ) )
		;
		$this->assertEquals(
				array( 'graph' ),
				$remove->invoke( $service, $dom )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::getPlaintextFromDom
	 */
	public function testGetPlaintextFromDom() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'extractAsidesFromDom' ] )
		                ->getMock();
		$dom = $this->getMockBuilder( 'simple_html_dom' )
		            ->disableOriginalConstructor()
		            ->setMethods( [ '__get' ] )
		            ->getMock();
		$get = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'getPlaintextFromDom' );
		$get->setAccessible( true );
		$service
		    ->expects( $this->once() )
		    ->method ( 'extractAsidesFromDom' )
		    ->with   ( $dom )
		    ->will   ( $this->returnValue( 'this is my table' ) )
		;
		$dom
		    ->expects( $this->once() )
		    ->method ( '__get' )
		    ->with   ( 'plaintext' )
		    ->will   ( $this->returnValue( "dom <b>without</b>\n tables" ) )
		;
		$this->assertEquals(
				'dom without tables this is my table',
				$get->invoke( $service, $dom )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::extractInfoBoxes
	 */
	public function testExtractInfoBoxes() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'removeGarbageFromDom' ] )
		                ->getMock();
		$dom = $this->getMockBuilder( 'simple_html_dom' )
		            ->disableOriginalConstructor()
		            ->setMethods( [ 'find'  ] )
		            ->getMock();
		$dom2 = $this->getMockBuilder( 'simple_html_dom' )
		            ->disableOriginalConstructor()
		            ->setMethods( [ 'find', 'save', 'load'  ] )
		            ->getMock();
		$node = $this->getMockBuilder( 'simple_html_dom_node' )
		             ->disableOriginalConstructor()
		             ->setMethods( [ '__get', 'find', 'outertext' ] )
		             ->getMock();
		$result = array();
		$extract = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'extractInfoboxes' );
		$extract->setAccessible( true );
		$dom
		    ->expects( $this->at( 0 ) )
		    ->method ( 'find' )
		    ->with   ( 'table.infobox' )
		    ->will   ( $this->returnValue( array( $node ) ) )
		;
		$node
		    ->expects( $this->at( 0 ) ) 
		    ->method ( 'outertext' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'removeGarbageFromDom' )
		    ->with   ( $dom2 ) // commented out due to wikia mock proxy
		;
		$dom2
		    ->expects( $this->at( 0 ) )
		    ->method ( 'save' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$dom2
		    ->expects( $this->at( 1 ) )
		    ->method ( 'load' )
		    ->with   ( 'foo' )
		;
		$dom2
		    ->expects( $this->at( 2 ) )
		    ->method ( 'find' )
		    ->with   ( 'tr' )
		    ->will   ( $this->returnValue( array( $node ) ) )
		;
		$node
		    ->expects( $this->at( 1 ) )
		    ->method ( 'find' )
		    ->with   ( 'td' )
		    ->will   ( $this->returnValue( array( $node, $node ) ) )
		;
		$node
		    ->expects( $this->at( 2 ) )
		    ->method ( '__get' )
		    ->with   ( 'plaintext' )
		    ->will   ( $this->returnValue( "here   is my \n key" ) )
		;
		$node
		    ->expects( $this->at( 3 ) )
		    ->method ( '__get' )
		    ->with   ( 'plaintext' )
		    ->will   ( $this->returnValue( 'value' ) )
		;
		$this->mockClass( 'simple_html_dom', $dom2 );
		$this->assertEquals(
				[ 'infoboxes_txt' => [ 'infobox_1 | here is my key | value' ] ],
				$extract->invoke( $service, $dom, $result )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::pushNolangTxt
	 * @covers Wikia\Search\IndexService\DefaultContent::getNolangTxt
	 */
	public function testPushAndGetNolangTxt() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$push = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'pushNolangTxt' );
		$push->setAccessible( true );
		$get = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'getNolangTxt' );
		$get->setAccessible( true );
		$this->assertAttributeEquals(
				[],
				'nolang_txt',
				$service
		);
		$this->assertEquals(
				$service,
				$push->invoke( $service, 'foo' )
		);
		$this->assertAttributeEquals(
				['foo'],
				'nolang_txt',
				$service
		);
		$this->assertEquals(
				[ 'nolang_txt' => [ 'foo' ] ],
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::reinitialize
	 */
	public function testReinitialize() {
		$service = $this->getMockBuilder( 'Wikia\Search\IndexService\DefaultContent' )
		                ->disableOriginalConstructor()
		                ->setMethods( null )
		                ->getMock();
		$nolang = new ReflectionProperty( $service, 'nolang_txt' );
		$nolang->setAccessible( true );
		$nolang->setValue( $service, [ 1, 2, 3, 4, 5 ] );
		$reinitialize = new ReflectionMethod( $service, 'reinitialize' );
		$reinitialize->setAccessible( true );
		$this->assertEquals(
				$service,
				$reinitialize->invoke( $service )
		);
		$this->assertAttributeEmpty(
				'nolang_txt',
				$service
		);
	}
}