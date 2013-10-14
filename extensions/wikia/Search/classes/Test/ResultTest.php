<?php
/**
 * Class definition for Wikia\Search\Test\ResultTest
 */
namespace Wikia\Search\Test;
use Wikia\Search\Result, \ReflectionProperty, \ReflectionMethod, Wikia\Search\Utilities;
/**
 * Tests functionality related to Wikia\Search\Result
 */
class ResultTest extends BaseTest {

	protected $defaultFields = array(
			'wid'	=>	123
	);

	/**
	 * @covers Wikia\Search\Result::getCityId
	 * @covers Wikia\Search\Result::__construct
	 */
	public function testGetCityId() {

		$result = new Result( $this->defaultFields );

		$this->assertEquals(
				$this->defaultFields['wid'],
				$result->getCityId(),
				'Wikia\Search\Result::getCityId should return the value for the "wid" field as passed during construction.'
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\MediaWikiService', 
				'service',
				$result
		);
	}

	/**
	 * @covers Wikia\Search\Result::getText
	 * @covers Wikia\Search\Result::setText
	 */
	public function testTextFieldMethods() {

		$result = new Result( $this->defaultFields );

		$this->assertEquals(
				'',
				$result->getText(),
				'An uninitialized text field should return an empty string'
		);

		$textFieldValue = '...Testing "one" two &amp; three...';

		$this->assertEquals(
				$result,
				$result->setText( $textFieldValue ),
				'Wikia\Search\Result::setText should provide a fluent interface.'
		);

		$method = new ReflectionMethod( 'Wikia\Search\Result', 'fixSnippeting' );
		$method->setAccessible( true );
		$this->assertEquals(
				$method->invoke( $result, $textFieldValue, true ),
				$result->getText(),
				'The text field should be stored after being filtered through Wikia\Search\Result::fixSnippeting.'
		);
	}
	
	/**
	 * @covers Wikia\Search\Result::getText
	 */
	public function testGetTextWithWordLimit() {
		$text = "we're no strangers to love. you know the rules and so do i.";
		$newfields = [ "text" => $text ];
		$result = new Result( array_merge( $this->defaultFields, $newfields ) );
		$this->assertEquals(
				"we're no strangers to love&hellip;",
				$result->getText( 'text', 5 )
		);
		$this->assertEquals(
				$text,
				$result->getText( 'text' )
		);
	}

	/**
	 * @covers Wikia\Search\Result::getTitle
	 * @covers Wikia\Search\Result::setTitle
	 */
	public function testTitleFieldMethods() {

		global $wgLanguageCode;
		$wgLanguageCode = 'fr';

		$fieldsCopy = $this->defaultFields;
		unset($fieldsCopy['title']);
		unset($fieldsCopy[Utilities::field('title')]);

		$result = new Result( $fieldsCopy );

		$this->assertEquals(
				'',
				$result->getTitle(),
				'A result with no title or language title field should return an empty string during getTitle().'
		);

		$title				= 'Foo';
		$result['title']	= $title;

		$this->assertEquals(
				$title,
				$result->getTitle(),
				'A result with no language title field should return a normal title field during getTitle() if it exists.'
		);

		$languageTitle							= 'LangFoo';
		$result[Utilities::field('title')]	= $languageTitle;

		$this->assertEquals(
		        $languageTitle,
		        $result->getTitle(),
		        'A result should return the language title field during getTitle() if it exists.'
		);

		$languageTitleWithJunk = '.../**$#(FooEnglish...</span>&hellip;';
		$this->assertEquals(
				$result,
				$result->setTitle( $languageTitleWithJunk ),
				'Wikia\Search\Result::setTitle should provide a fluent interface'
		);

		$method = new ReflectionMethod( 'Wikia\Search\Result', 'fixSnippeting' );
		$method->setAccessible( true );
		$this->assertEquals(
				$method->invoke( $result, $languageTitleWithJunk ),
				$result->getTitle(),
				'A title set with Wikia\Search\Result::setTitle() should be filtered with Wikia\Search\Utilities::fixSnippeting before storage.'
		);

		unset( $result[Utilities::field( 'title' )] );
		unset( $result['title'] );
		$result[Utilities::field( 'title', 'en' )] = $languageTitle;

		global $wgLanguageCode;
		$oldCode = $wgLanguageCode;
		$wgLanguageCode = 'fr';
		$result = new Result( array( 'title_en' => $languageTitle ) );
		$this->assertEquals(
		        $languageTitle,
		        $result->getTitle(),
		        'A result should return the english language title field during getTitle() if it exists, but the non-english field doesn\'t (video support).'
		);
		$wgLanguageCode = $oldCode;

	}

	/**
	 * @covers Wikia\Search\Result::getUrl
	 * @covers Wikia\Search\Result::setUrl
	 * @covers Wikia\Search\Result::getTextUrl
	 */
	public function testUrlMethods() {

		$result		= new Result( $this->defaultFields );
		$urlNormal	= 'http://www.willcaltrainsucktoday.com/Fake:Will_Caltrain_Suck_Today?';
		$urlEncoded	= 'http://www.willcaltrainsucktoday.com/Fake:Will_Caltrain_Suck_Today' . urlencode('?');

		$this->assertEquals(
				'',
				$result->getUrl(),
				'Wikia\Search\Result::getUrl should return an empty string if the url field has not been set.'
		);
		$this->assertEquals(
				$result,
				$result->setUrl( $urlEncoded ),
				'Wikia\Search\Result::setUrl should provide a fluent interface.'
		);
		$this->assertEquals(
				$urlNormal,
				$result->getTextUrl(),
				'Wikia\Search\Result::getTextUrl() should provide a user-readable version of the URL.'
		);
		$this->assertEquals(
				$urlEncoded,
				$result->getUrl(),
				'Wikia\Search\Result::getUrl should return exactly what was stored in Wikia\Search\Result::setUrl'
		);
	}
	/**
	 * @covers Wikia\Search\Result::getHub
	 */ 
	
	public function testGetHub() {
		$result	= new Result( $this->defaultFields );
		$hubs = [ 'Gaming' => 'Video Games', 'Entertainment' => 'Entertainment', 'Lifestyle' => 'Lifestyle' ];
		foreach ($hubs as $key => $value) {
			$result->setField("hub_s", $key);
			$this->assertEquals($result->getHub(),  $value);
		}
	}

	/**
	 * @covers Wikia\Search\Result::setVar
	 * @covers Wikia\Search\Result::getVar
	 * @covers Wikia\Search\Result::getVars
	 */
	public function testVarMethods() {

		$result		= new Result( $this->defaultFields );

		$this->assertEquals(
				$this->defaultFields,
				$result->getVars(),
				'Wikia\Search\Result::getVars should return the protected $_fields array.'
		);
		$this->assertEquals(
				$this->defaultFields['wid'],
				$result->getVar( 'wid' ),
				'Wikia\Search\Result::getVar should return any values already set in the result fields.'
		);
		$this->assertNull(
				$result->getVar( 'NonExistentField' ),
				'Querying for nonexistent fields without a second parameter passed should return null in Wikia\Search\Result::getVar.'
		);
		$this->assertEquals(
				'TestDefault',
				$result->getVar( 'NonExistentField', 'TestDefault' ),
				'Wikia\Search\Result::getVar should accommodate a flexible default value as the second parameter.'
		);
		$this->assertEquals(
				$result,
				$result->setVar( 'foo', 'bar' ),
				'Wikia\Search\Result::setVar should provide a fluent interface.'
		);
		$this->assertEquals(
				$result['foo'],
				$result->getVar( 'foo' ),
				'Wikia\Search\Result::setVar should store a value as a field, accessible by array methods or getVar().'
		);
	}

	/**
	 * @covers Wikia\Search\Result::fixSnippeting
	 */
	public function testFixSnippeting() {

		$result		= new Result( $this->defaultFields );
		$method		= new ReflectionMethod( 'Wikia\Search\Result', 'fixSnippeting' );
		$method->setAccessible( true );

		$text = '�foo';
		$this->assertEquals(
				'foo',
				$method->invoke( $result, $text ),
				'Wikia\Search\Result::fixSnippeting should remove bytecode junk.'
		);

		$text = 'foo &hellip;';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo&hellip;';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo...';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo ...';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo..';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should remove multiple string-final periods.'
		);
		$text = 'foo                     ';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should remove string-final whitespace.'
		);
		$text = "foo</span>'s";
		$this->assertEquals(
		        "foo's</span>",
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should fix searchmatch spans that orphan apostrophes.'
		);
		$text = '!,?. foo';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should remove string-initial punctuation.'
		);
		$text = 'span class="searchmatch"> foo';
		$this->assertEquals(
		        '<span class="searchmatch"> foo',
		        $method->invoke( $result, $text ),
		        'Wikia\Search\Result::fixSnippeting should repair broken string-initial span tags.'
		);
		$text = 'foo</span>!!!!';
		$this->assertEquals(
		        'foo</span>&hellip;',
		        $method->invoke( $result, $text, true ),
		        'Wikia\Search\Result::fixSnippeting should append an ellipses to the end of a string if second parameter passed as true. Broken span tags should be repaired, as well.'
		);
		$text = '<span class="searchmatch">foo</span></div>';
		$this->assertEquals(
				'<span class="searchmatch">foo</span>',
				$method->invoke( $result, $text ),
				'Wikia\Search\Result::fixSnippeting should strip all tags except spans.'
		);
	}

	/**
	 * @covers Wikia\Search\Result::toArray
	 */
	public function testToArray() {
		$fields = $this->defaultFields;
		$fields['foo'] = 'bar';
		$result = new Result( $fields );
		$array  = $result->toArray( array( 'wid', 'foo' => 'roseanne' ) );
		$this->assertArrayHasKey(
				'wid',
				$array
		);
		$this->assertEquals(
				123,
				$array['wid']
		);
		$this->assertEquals(
				'bar',
				$array['roseanne']
		);
	}

	/**
	 * @covers Wikia\Search\Result::replaceUnusualEscapes
	 * @covers Wikia\Search\Result::replaceUnusualEscapesCallback
	 */
	public function testReplaceUnusualEscapes() {
		$this->assertEquals(
				'%5Bfoo+bar%25_%3F!',
				Result::replaceUnusualEscapes( urlencode( '[foo bar%_?!' ) )
		);

		$this->assertEquals(
				'100%25+Completion',
				Result::replaceUnusualEscapes( urlencode( '100% Completion' ) )
		);

	}

	/**
	 * @covers Wikia\Search\Result::getVideoViews
	 */
	public function testGetVideoViews() {
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Result' )
		                   ->setConstructorArgs( array( array( 'pageid' => 123 ) ) )
		                   ->setMethods( null )
		                   ->getMock();
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getFormattedVideoViewsForPageId' ) )
		                      ->getMock();
		
		$reflService = new ReflectionProperty( 'Wikia\Search\Result', 'service' );
		$reflService->setAccessible( true );
		$reflService->setValue( $mockResult, $mockService );
		
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFormattedVideoViewsForPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( "50 views" ) )
		;
		$this->assertEquals(
				"50 views",
				$mockResult->getVideoViews()
		);
	}
	
	/**
	 * @covers Wikia\Search\Result::getVideoViews
	 */
	public function testGetVideoViewsException() {
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Result' )
		                   ->setConstructorArgs( array( array( 'pageid' => 123 ) ) )
		                   ->setMethods( null )
		                   ->getMock();
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getFormattedVideoViewsForPageId' ) )
		                      ->getMock();
		$mockException = $this->getMockBuilder( '\Exception' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		
		$reflService = new ReflectionProperty( 'Wikia\Search\Result', 'service' );
		$reflService->setAccessible( true );
		$reflService->setValue( $mockResult, $mockService );
		
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFormattedVideoViewsForPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->throwException( $mockException ) )
		;
		$this->assertEquals(
				0,
				$mockResult->getVideoViews()
		);
	}
	
	/**
	 * @covers Wikia\Search\Result::offsetGet
	 */
	public function testOffsetGetTitle() {
		$result = $this->getMock( 'Wikia\\Search\\Result', [ 'getTitle' ] );
		$result
		    ->expects( $this->any() )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( 'my title' ) )
		;
		$this->assertEquals(
				'my title',
				$result['title']
		);
		$this->assertEquals(
				'my title',
				$result['title_en']
		);
	}
	
	/**
	 * @covers Wikia\Search\Result::offsetGet
	 */
	public function testOffsetGetText() {
		$result = $this->getMock( 'Wikia\\Search\\Result', [ 'getText' ] );
		$result
		    ->expects( $this->any() )
		    ->method ( 'getText' )
		    ->will   ( $this->returnValue( 'my text' ) )
		;
		$this->assertEquals(
				'my text',
				$result['text']
		);
		$this->assertEquals(
				'my text',
				$result['text_en']
		);
	}
	
	/**
	 * @covers Wikia\Search\Result::offsetGet
	 */
	public function testoffsetGetVideoViews() {
		$result = $this->getMock( 'Wikia\\Search\\Result', [ 'getVideoViews' ] );
		$result
		    ->expects( $this->any() )
		    ->method ( 'getVideoViews' )
		    ->will   ( $this->returnValue( '1,000' ) )
		;
		$this->assertEquals(
				'1,000',
				$result['videoViews']
		);
	}
	
	/**
	 * @covers Wikia\Search\Result::offsetGet
	 */
	public function testOffsetGetDefaultLanguageField() {
		$result = new Result( [ 'html_en' => 'html', 'wam' => 100 ] );
		$this->assertEquals(
				100,
				$result['wam']
		);
		$this->assertEquals(
				'html',
				$result['html']
		);
	}
	
	/**
	 * @covers Wikia\Search\Result::offsetGet
	 */
	public function testOffsetGetDynamicNonLanguageField() {
		$result = new Result( [ 'infoboxes_txt' => [ 'foo bar' ] ] );
		$this->assertEquals(
				[ 'foo bar' ],
				$result['infoboxes_txt']
		);
	}
	
	
}
