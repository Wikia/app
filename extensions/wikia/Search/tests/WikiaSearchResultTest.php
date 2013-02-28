<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultTest extends WikiaSearchBaseTest {

	protected $defaultFields = array(
			'wid'	=>	123
	);

	/**
	 * @covers Wikia\Search\Result::getCityId
	 */
	public function testGetCityId() {

		$result = F::build( 'Wikia\Search\Result', array( $this->defaultFields ) );

		$this->assertEquals(
				$this->defaultFields['wid'],
				$result->getCityId(),
				'Wikia\Search\Result::getCityId should return the value for the "wid" field as passed during construction.'
		);
	}

	/**
	 * @covers Wikia\Search\Result::getText
	 * @covers Wikia\Search\Result::setText
	 */
	public function testTextFieldMethods() {

		$result = F::build( 'Wikia\Search\Result', array( $this->defaultFields ) );

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
	 * @covers Wikia\Search\Result::getTitle
	 * @covers Wikia\Search\Result::setTitle
	 */
	public function testTitleFieldMethods() {

		global $wgLanguageCode;
		$wgLanguageCode = 'fr';

		$fieldsCopy = $this->defaultFields;
		unset($fieldsCopy['title']);
		unset($fieldsCopy[Wikia\Search\Utilities::field('title')]);

		$result = F::build( 'Wikia\Search\Result', array( $fieldsCopy ) );

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
		$result[Wikia\Search\Utilities::field('title')]	= $languageTitle;

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

		unset( $result[Wikia\Search\Utilities::field( 'title' )] );
		unset( $result['title'] );
		$result[Wikia\Search\Utilities::field( 'title', 'en' )] = $languageTitle;

		$this->assertEquals(
		        $languageTitle,
		        $result->getTitle(),
		        'A result should return the english language title field during getTitle() if it exists, but the non-english field doesn\'t (video support).'
		);

	}

	/**
	 * @covers Wikia\Search\Result::getUrl
	 * @covers Wikia\Search\Result::setUrl
	 * @covers Wikia\Search\Result::getTextUrl
	 */
	public function testUrlMethods() {

		$result		= F::build( 'Wikia\Search\Result', array( $this->defaultFields ) );
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
	 * @covers Wikia\Search\Result::setVar
	 * @covers Wikia\Search\Result::getVar
	 * @covers Wikia\Search\Result::getVars
	 */
	public function testVarMethods() {

		$result		= F::build( 'Wikia\Search\Result', array( $this->defaultFields ) );

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

		$result		= F::build( 'Wikia\Search\Result', array( $this->defaultFields ) );
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
	}

	/**
	 * @covers Wikia\Search\Result::toArray
	 */
	public function testToArray() {
		$result = F::build( 'Wikia\Search\Result', array( $this->defaultFields ) );
		$array  = $result->toArray( array( 'wid' ) );
		$this->assertArrayHasKey(
				'wid',
				$array
		);
		$this->assertEquals(
				123,
				$array['wid']
		);
	}

	/**
	 * @covers Wikia\Search\Result::replaceUnusualEscapes
	 * @covers Wikia\Search\Result::replaceUnusualEscapesCallback
	 */
	public function testReplaceUnusualEscapes() {
		$this->assertEquals(
				'%5Bfoo+bar%25_%3F!',
				Wikia\Search\Result::replaceUnusualEscapes( urlencode( '[foo bar%_?!' ) )
		);

		$this->assertEquals(
				'100%25+Completion',
				Wikia\Search\Result::replaceUnusualEscapes( urlencode( '100% Completion' ) )
		);

	}
	

	/**
	 * @covers Wikia\Search\Result::getVideoViews
	 * @todo
	public function testGetVideoViewsNotVideo() {
		$result = $this->getMockBuilder( 'Wikia\Search\Result' )
						->setMethods( array( 'getTitleObject', 'offsetGet' ) )
						->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockFileHelper = $this->getMockBuilder( 'WikiaFileHelper' )
		                        ->disableOriginalConstructor()
		                       ->setMethods( array( 'isFileTypeVideo' ) )
		                       ->getMock();
		
		$result
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleObject' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockFileHelper
		    ->staticExpects( $this->at( 0 ) )
		    ->method       ( 'isFileTypeVideo' )
		    ->with         ( $mockTitle )
		    ->will         ( $this->returnValue( false ) )
		;
		
		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );
		$this->mockApp();
		
		$this->assertEmpty(
				$result->getVideoViews(),
				'Wikia\Search\Result::getVideoViews() should return an empty string if the file result is an not a video file'
		);
	}*/
	
    /**
	 * @covers Wikia\Search\Result::getVideoViews
	 *@todo
	public function testGetVideoViewsVideo() {
		$result = $this->getMockBuilder( 'Wikia\Search\Result' )
						->setMethods( array( 'getTitleObject', 'offsetGet' ) )
						->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->setMethods( array( 'getDBKey' ) )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockFileHelper = $this->getMockBuilder( 'WikiaFileHelper' )
		                        ->disableOriginalConstructor()
		                       ->setMethods( array( 'isFileTypeVideo' ) )
		                       ->getMock();
		
		$mockMqs = $this->getMockBuilder( 'MediaQueryService' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getTotalVideoViewsByTitle' ) )
		                ->getMock();
		
		$result
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitleObject' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockFileHelper
		    ->staticExpects( $this->at( 0 ) )
		    ->method       ( 'isFileTypeVideo' )
		    ->with         ( $mockTitle )
		    ->will         ( $this->returnValue( true ) )
		;
		$mockTitle
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getDBKey' )
		    ->will   ( $this->returnValue( 'dbKey' ) )
		;
		$mockMqs
		    ->staticExpects( $this->at( 0 ) )
		    ->method       ( 'getTotalVideoViewsByTitle' )
		    ->with         ( 'dbKey' )
		    ->will         ( $this->returnValue( 25 ) )
		;
		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );
		$this->mockClass( 'MediaQueryService', $mockMqs );
		$this->mockApp();
		
		// @todo mock up the translation part
		$this->assertEquals(
				'25 views',
				$result->getVideoViews(),
				'Wikia\Search\Result::getVideoViews() should return a translated string containing the value of the video views'
		);
	}*/
}
