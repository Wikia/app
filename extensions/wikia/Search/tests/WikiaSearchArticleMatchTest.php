<?php 

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchArticleMatchTest extends WikiaSearchBaseTest {
	
	/**
	 * @covers WikiaSearchArticleMatch::__construct
	 * @covers WikiaSearchArticleMatch::hasRedirect
	 * @covers WikiaSearchArticleMatch::getArticle
	 * @covers WikiaSearchArticleMatch::getRedirect
	 * @covers WikiaSearchArticleMatch::getOriginalArticle
	 */
	public function testArticleMatchCanonical() {
		
		$mockTitle		= $this->getMock( 'Title' );
		$mockArticle	= $this->getMock( 'Article', array( 'isRedirect', 'getRedirectTarget' ), array( $mockTitle ) );
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'isRedirect' )
			->will		( $this->returnValue( false ) )
		;
		
		$articleMatch = F::build( 'WikiaSearchArticleMatch', array( $mockArticle ) );
		
		$this->assertInstanceOf(
				'Article',
				$articleMatch->getArticle(),
				'WikiaSearchArticleMatch should return the original article, canonical or not, when calling getArticle().'
		);
		
		$this->assertEquals(
				false,
				$articleMatch->hasRedirect(),
				'WikiaSearchArticleMatch::hasRedirect should return false if it does not have a redirect.'
		);
		
		$this->assertNull(
				$articleMatch->getRedirect(),
				'WikiaSearchArticleMatch::getRedirect should return null if the article passed during construction was canonical.'
		);
		
		$this->assertEquals(
				$articleMatch->getCanonicalArticle(),
				$articleMatch->getArticle(),
				'A canonical article as the constructor param should be returned as both canonical and main article in WikiaSearchArticleMatch.'
		);
		
	}
	
	/**
	 * @covers WikiaSearchArticleMatch::__construct
	 * @covers WikiaSearchArticleMatch::hasRedirect
	 * @covers WikiaSearchArticleMatch::getArticle
	 * @covers WikiaSearchArticleMatch::getRedirect
	 * @covers WikiaSearchArticleMatch::getOriginalArticle
	 */
	public function testArticleMatchRedirect() {
		$mockTitle		= $this->getMock( 'Title' );
		$mockArticle	= $this->getMock( 'Article', array( 'isRedirect', 'getRedirectTarget' ), array( $mockTitle ) );
		$mockRedirect	= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$this->mockClass( 'Article', $mockRedirect );
		
		$mockArticle
			->expects	( $this->any() )
			->method	( 'isRedirect' )
			->will		( $this->returnValue( true ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'getRedirectTarget' )
			->will		( $this->returnValue( $mockTitle ) )
		;
		
		$articleMatch = F::build( 'WikiaSearchArticleMatch', array( $mockArticle ) );
		
		$this->assertInstanceOf(
		        'Article',
		        $articleMatch->getCanonicalArticle(),
		        'WikiaSearchArticleMatch should return an article when calling getCanonicalArticle().'
		);
		
		$this->assertInstanceOf(
				'Article',
				$articleMatch->getArticle(),
				'WikiaSearchArticleMatch should return the original article when calling getArticle().' 
		);
		
		$this->assertEquals(
				true,
				$articleMatch->hasRedirect(),
				'WikiaSearchArticleMatch::hasRedirect should true if the article passed during construction was a redirect.' 
		);
		
		$this->assertInstanceOf(
				'Article',
				$articleMatch->getRedirect(),
				'WikiaSearchArticleMatch::getRedirect should return an article if the article match had a redirect.'
		);
		
		$this->assertNotEquals(
				$articleMatch->getArticle(),
				$articleMatch->getCanonicalArticle(),
				'A non-canonical original article match should default to the redirect when calling getCanonicalArticle.'
		);
		
		$this->assertEquals(
				$articleMatch->getRedirect(), 
				$articleMatch->getCanonicalArticle(),
				'A non-canonical original article match should default to the redirect when calling getCanonicalArticle.'
		);
		
		
	}
	
}