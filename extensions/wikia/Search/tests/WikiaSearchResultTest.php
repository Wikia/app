<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultTest extends WikiaSearchBaseTest {

	protected $defaultFields = array(
			'wid'	=>	123
	);

	/**
	 * @covers WikiaSearchResult::getCityId
	 */
	public function testGetCityId() {

		$result = F::build( 'WikiaSearchResult', array( $this->defaultFields ) );

		$this->assertEquals(
				$this->defaultFields['wid'],
				$result->getCityId(),
				'WikiaSearchResult::getCityId should return the value for the "wid" field as passed during construction.'
		);
	}

	/**
	 * @covers WikiaSearchResult::getText
	 * @covers WikiaSearchResult::setText
	 */
	public function testTextFieldMethods() {

		$result = F::build( 'WikiaSearchResult', array( $this->defaultFields ) );

		$this->assertEquals(
				'',
				$result->getText(),
				'An uninitialized text field should return an empty string'
		);

		$textFieldValue = '...Testing "one" two &amp; three...';

		$this->assertEquals(
				$result,
				$result->setText( $textFieldValue ),
				'WikiaSearchResult::setText should provide a fluent interface.'
		);

		$method = new ReflectionMethod( 'WikiaSearchResult', 'fixSnippeting' );
		$method->setAccessible( true );
		$this->assertEquals(
				$method->invoke( $result, $textFieldValue, true ),
				$result->getText(),
				'The text field should be stored after being filtered through WikiaSearchResult::fixSnippeting.'
		);
	}

	/**
	 * @covers WikiaSearchResult::getTitle
	 * @covers WikiaSearchResult::setTitle
	 */
	public function testTitleFieldMethods() {

		global $wgLanguageCode;
		$wgLanguageCode = 'fr';

		$fieldsCopy = $this->defaultFields;
		unset($fieldsCopy['title']);
		unset($fieldsCopy[WikiaSearch::field('title')]);

		$result = F::build( 'WikiaSearchResult', array( $fieldsCopy ) );

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
		$result[WikiaSearch::field('title')]	= $languageTitle;

		$this->assertEquals(
		        $languageTitle,
		        $result->getTitle(),
		        'A result should return the language title field during getTitle() if it exists.'
		);

		$languageTitleWithJunk = '.../**$#(FooEnglish...</span>&hellip;';
		$this->assertEquals(
				$result,
				$result->setTitle( $languageTitleWithJunk ),
				'WikiaSearchResult::setTitle should provide a fluent interface'
		);

		$method = new ReflectionMethod( 'WikiaSearchResult', 'fixSnippeting' );
		$method->setAccessible( true );
		$this->assertEquals(
				$method->invoke( $result, $languageTitleWithJunk ),
				$result->getTitle(),
				'A title set with WikiaSearch::setTitle() should be filtered with WikiaSearch::fixSnippeting before storage.'
		);

		unset( $result[WikiaSearch::field( 'title' )] );
		unset( $result['title'] );
		$result[WikiaSearch::field( 'title', 'en' )] = $languageTitle;

		$this->assertEquals(
		        $languageTitle,
		        $result->getTitle(),
		        'A result should return the english language title field during getTitle() if it exists, but the non-english field doesn\'t (video support).'
		);

	}

	/**
	 * @covers WikiaSearchResult::getUrl
	 * @covers WikiaSearchResult::setUrl
	 * @covers WikiaSearchResult::getTextUrl
	 */
	public function testUrlMethods() {

		$result		= F::build( 'WikiaSearchResult', array( $this->defaultFields ) );
		$urlNormal	= 'http://www.willcaltrainsucktoday.com/Fake:Will_Caltrain_Suck_Today?';
		$urlEncoded	= 'http://www.willcaltrainsucktoday.com/Fake:Will_Caltrain_Suck_Today' . urlencode('?');

		$this->assertEquals(
				'',
				$result->getUrl(),
				'WikiaSearchResult::getUrl should return an empty string if the url field has not been set.'
		);
		$this->assertEquals(
				$result,
				$result->setUrl( $urlEncoded ),
				'WikiaSearchResult::setUrl should provide a fluent interface.'
		);
		$this->assertEquals(
				$urlNormal,
				$result->getTextUrl(),
				'WikiaSearchResult::getTextUrl() should provide a user-readable version of the URL.'
		);
		$this->assertEquals(
				$urlEncoded,
				$result->getUrl(),
				'WikiaSearchResult::getUrl should return exactly what was stored in WikiaSearchResult::setUrl'
		);
	}

	/**
	 * @covers WikiaSearchResult::setVar
	 * @covers WikiaSearchResult::getVar
	 * @covers WikiaSearchResult::getVars
	 */
	public function testVarMethods() {

		$result		= F::build( 'WikiaSearchResult', array( $this->defaultFields ) );

		$this->assertEquals(
				$this->defaultFields,
				$result->getVars(),
				'WikiaSearchResult::getVars should return the protected $_fields array.'
		);
		$this->assertEquals(
				$this->defaultFields['wid'],
				$result->getVar( 'wid' ),
				'WikiaSearchResult::getVar should return any values already set in the result fields.'
		);
		$this->assertNull(
				$result->getVar( 'NonExistentField' ),
				'Querying for nonexistent fields without a second parameter passed should return null in WikiaSearchResult::getVar.'
		);
		$this->assertEquals(
				'TestDefault',
				$result->getVar( 'NonExistentField', 'TestDefault' ),
				'WikiaSearchResult::getVar should accommodate a flexible default value as the second parameter.'
		);
		$this->assertEquals(
				$result,
				$result->setVar( 'foo', 'bar' ),
				'WikiaSearchResult::setVar should provide a fluent interface.'
		);
		$this->assertEquals(
				$result['foo'],
				$result->getVar( 'foo' ),
				'WikiaSearchResult::setVar should store a value as a field, accessible by array methods or getVar().'
		);
	}

	/**
	 * @covers WikiaSearchResult::fixSnippeting
	 */
	public function testFixSnippeting() {

		$result		= F::build( 'WikiaSearchResult', array( $this->defaultFields ) );
		$method		= new ReflectionMethod( 'WikiaSearchResult', 'fixSnippeting' );
		$method->setAccessible( true );

		$text = '�foo';
		$this->assertEquals(
				'foo',
				$method->invoke( $result, $text ),
				'WikiaSearchResult::fixSnippeting should remove bytecode junk.'
		);

		$text = 'foo &hellip;';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo&hellip;';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo...';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo ...';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should remove string-final ellipses.'
		);
		$text = 'foo..';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should remove multiple string-final periods.'
		);
		$text = 'foo                     ';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should remove string-final whitespace.'
		);
		$text = "foo</span>'s";
		$this->assertEquals(
		        "foo's</span>",
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should fix searchmatch spans that orphan apostrophes.'
		);
		$text = '!,?. foo';
		$this->assertEquals(
		        'foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should remove string-initial punctuation.'
		);
		$text = 'span class="searchmatch"> foo';
		$this->assertEquals(
		        '<span class="searchmatch"> foo',
		        $method->invoke( $result, $text ),
		        'WikiaSearchResult::fixSnippeting should repair broken string-initial span tags.'
		);
		$text = 'foo</span>!!!!';
		$this->assertEquals(
		        'foo</span>&hellip;',
		        $method->invoke( $result, $text, true ),
		        'WikiaSearchResult::fixSnippeting should append an ellipses to the end of a string if second parameter passed as true. Broken span tags should be repaired, as well.'
		);
	}

	/**
	 * @covers WikiaSearchResult::getTitleObject
	 */
	public function testGetTitleObject() {
		$result		= F::build( 'WikiaSearchResult', array( $this->defaultFields ) );
		$titleMock	= $this->getMock( 'Title', array( 'MakeTitle' ) );

		$this->assertNull(
				$result->getTitleObject(),
				'A result object without a title value should return null when calling getTitleObject.'
		);

		$result['title']	= 'Foo';
		$result['ns']		= 0;

		$titleMock
			->expects	( $this->any() )
			->method	( 'MakeTitle' )
			->will		( $this->returnValue( $titleMock ) )
		;

		$this->mockClass( 'Title', $titleMock );
		$this->mockApp();

		$this->assertEquals(
				$titleMock,
				$result->getTitleObject(),
				'WikiaSearchResult::getTitleObject() should return a title object based on namespace and title field values.'
		);
	}

	/**
	 * @covers WikiaSearchResult::getThumbnail
	 * Looks like this is a victim of MediaWiki's habit of declaring multiple classes in a single file?
	 */
	public function testGetThumbnail() {
		$result		= F::build( 'WikiaSearchResult', array( $this->defaultFields ) );
		$titleMock	= $this->getMock( 'Title' );
		$mockImage	= $this->getMockBuilder( 'File' )
							->disableOriginalConstructor()
							->setMethods( array( 'transform' ) )
							->getMock();
		$mockThumb	= $this->getMockBuilder( 'ThumbnailImage' )
							->disableOriginalConstructor()
							->getMock();
		$mockMTO	= $this->getMockBuilder( 'MediaTransformOutput' )
							->disableOriginalConstructor();

		$result['title']	= 'File:Foo.jpg';
		$result['ns']		= NS_FILE;

		$mockImage
			->expects	( $this->any() )
			->method	( 'transform' )
			->will		( $this->returnValue( $mockThumb ) )
		;

		$this->mockGlobalFunction( 'findFile', $mockImage, 1, array( $this->equalTo($titleMock) ) );
		$this->mockClass( 'Title', $titleMock );
		$this->mockClass( 'MediaTransformOutput', $mockMTO );
		$this->mockClass( 'File', $mockImage );
		$this->mockClass( 'ThumbnailImage', $mockThumb);
		$this->mockApp();

		$this->assertInstanceOf(
				'ThumbnailImage',
				$result->getThumbnail(),
				'The result of WikiaSearch::getThumbnail should be an instance of MediaTransformOutput if the thumbnail exists.'
		);
	}

	/**
	 * @covers WikiaSearchResult::toArray
	 */
	public function testToArray() {
		$result = F::build( 'WikiaSearchResult', array( $this->defaultFields ) );
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
	 * @covers WikiaSearchResult::replaceUnusualEscapes
	 * @covers WikiaSearchResult::replaceUnusualEscapesCallback
	 */
	public function testReplaceUnusualEscapes() {
		$this->assertEquals(
				'%5Bfoo+bar%25_%3F!',
				WikiaSearchResult::replaceUnusualEscapes( urlencode( '[foo bar%_?!' ) )
		);

		$this->assertEquals(
				'100%25+Completion',
				WikiaSearchResult::replaceUnusualEscapes( urlencode( '100% Completion' ) )
		);

	}
	
	/**
	 * bugid: 69027
	 * @covers WikiaSearchResult::getTitleObject
	 */
	public function testGetTitleObjectForEmptyButNonNullTitles() {
		
		$result = $this->getMockBuilder( 'WikiaSearchResult' )
						->setMethods( array( 'getTitle' ) )
						->getMock();
		
		$result
			->expects	( $this->at( 0 ) )
			->method	( 'getTitle' )
			->will		( $this->returnValue( '' ) ) // this is not a valid title
		;
		
		$titleObjectPlaceholder = (object) array( 'foo' => 'bar' );
		
		$titleObject = new ReflectionProperty( 'WikiaSearchResult', 'titleObject' );
		$titleObject->setAccessible( true );
		$titleObject->setValue( $result, $titleObjectPlaceholder );
		
		$this->assertEquals(
				$titleObjectPlaceholder,
				$result->getTitleObject(),
				'WikiaSearchResult::getTitleObject should return whatever value is presently set in the titleObject property if there is no title string available from WikiaSearchResult::getTitle'
		);
		
		$titleObject->setValue( $result, null );
		
		$mockTitle = $this->getMockBuilder( 'Title' )
							->disableOriginalConstructor()
							->getMock();
		
		$result
			->expects	( $this->at( 0 ) )
			->method	( 'getTitle' )
			->will		( $this->returnValue( '0' ) ) // this is a valid title, but empty() returns true
		;
		
		$this->proxyClass( 'Title', $mockTitle, 'MakeTitle' );
		$this->mockApp();
		
		$this->assertEquals(
				$mockTitle,
				$result->getTitleObject(),
				'WikiaSearchResult::getTitleObject should set the titleObject property if a title string can be found and a title object instantiated'
		);
		
	}

	/**
	 * @covers WikiaSearchResult::getVideoViews
	 */
	public function testGetVideoViewsNotVideo() {
		$result = $this->getMockBuilder( 'WikiaSearchResult' )
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
				'WikiaSearchResult::getVideoViews() should return an empty string if the file result is an not a video file'
		);
	}
	
    /**
	 * @covers WikiaSearchResult::getVideoViews
	 */
	public function testGetVideoViewsVideo() {
		$result = $this->getMockBuilder( 'WikiaSearchResult' )
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
				'WikiaSearchResult::getVideoViews() should return a translated string containing the value of the video views'
		);
	}
}
