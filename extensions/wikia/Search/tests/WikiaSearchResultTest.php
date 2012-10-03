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
	}
	
}