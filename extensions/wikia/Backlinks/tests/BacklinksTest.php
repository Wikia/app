<?php

class BacklinksTest extends WikiaBaseTest
{

	public function setUp()
	{
		parent::setUp();
		$dir = dirname(__FILE__ ).'/..';
		$app = F::app();
		$app->registerClass("Backlinks", "$dir/Backlinks.class.php");
		$app->registerClass("UpdateBacklinksJob", "$dir/job/UpdateBacklinksJob.class.php");

	}

	/**
	 * @covers Backlinks::onLinkEnd
	 */
	public function testOnLinkEndMalformedData()
	{
		$mockBacklinks = $this->getMockBuilder( 'Backlinks' )
								->setMethods( array( 'foo' ) ) // doesn't work without it 
								->getMock();
		
		$mockArticle = $this->getMockBuilder( 'Article' )
							->disableOriginalConstructor()
							->setMethods( array( 'getId' ) )
							->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
						  ->disableOriginalConstructor()
						  ->setMethods( array( 'getArticleId' ) )
						  ->getMock();
		
		$mockSkin = $this->getMockBuilder( 'SkinOasis' )
						->disableOriginalConstructor()
						->getMock();
		
		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getArticleId' )
			->will   ( $this->returnValue( 0 ) )
		;
		$mockArticle
			->expects( $this->never() )
			->method ( 'getId' )
		;
		
		$wg = (object) array( 'Article' => $mockArticle );
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		$wgRefl->setValue( $mockBacklinks, $wg );

		
		$mockOptions = array();
		$mockText = 'foo';
		$mockAttribs = array();
		$mockRet = false;
		$this->assertTrue(
				$mockBacklinks->onLinkEnd( $mockSkin, $mockTitle, $mockOptions, $mockText, $mockAttribs, $mockRet ),
				"Backlinks::onLinkEnd should always return true"
		);
	}
	
	/**
	 * @covers Backlinks::onLinkEnd
	 */
	public function testOnLinkEndUninitializedBacklinksRows()
	{
		$mockBacklinks = $this->getMockBuilder( 'Backlinks' )
								->setMethods( array( 'foo' ) ) // doesn't work without it 
								->getMock();
		
		$mockArticle = $this->getMockBuilder( 'Article' )
							->disableOriginalConstructor()
							->setMethods( array( 'getId' ) )
							->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
						  ->disableOriginalConstructor()
						  ->setMethods( array( 'getArticleId' ) )
						  ->getMock();
		
		$mockSkin = $this->getMockBuilder( 'SkinOasis' )
						->disableOriginalConstructor()
						->getMock();
		
		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getArticleId' )
			->will   ( $this->returnValue( 123 ) )
		;
		$mockArticle
			->expects( $this->at( 0 ) )
			->method ( 'getId' )
			->will   ( $this->returnValue( 234 ) )
		;
		
		$wg = (object) array( 'Article' => $mockArticle, 'CityID' => 456 );
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		$wgRefl->setValue( $mockBacklinks, $wg );

		
		$mockOptions = array();
		$mockText = 'foo';
		$mockAttribs = array();
		$mockRet = false;
		$this->assertTrue(
				$mockBacklinks->onLinkEnd( $mockSkin, $mockTitle, $mockOptions, $mockText, $mockAttribs, $mockRet ),
				"Backlinks::onLinkEnd should always return true"
		);
		
		$backlinkRows = new ReflectionProperty( 'Backlinks', 'backlinkRows' );
		$backlinkRows->setAccessible( true );
		$this->assertArrayHasKey(
				'456_123',
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should initialize a key for the target article solr doc ID' 
		);
		$this->assertContains(
				array( $mockText => array( '456_234' => 1 ) ),
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should initialize a value of an array keying text to its source IDs and counts, '
				.' keyed by target ID, provided that key has not been initialized'
		);
	}
	
	/**
	 * @covers Backlinks::onLinkEnd
	 */
	public function testOnLinkEndUninitializedTargetText()
	{
		$mockBacklinks = $this->getMockBuilder( 'Backlinks' )
								->setMethods( array( 'foo' ) ) // doesn't work without it 
								->getMock();
		
		$mockArticle = $this->getMockBuilder( 'Article' )
							->disableOriginalConstructor()
							->setMethods( array( 'getId' ) )
							->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
						  ->disableOriginalConstructor()
						  ->setMethods( array( 'getArticleId' ) )
						  ->getMock();
		
		$mockSkin = $this->getMockBuilder( 'SkinOasis' )
						->disableOriginalConstructor()
						->getMock();
		
		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getArticleId' )
			->will   ( $this->returnValue( 123 ) )
		;
		$mockArticle
			->expects( $this->at( 0 ) )
			->method ( 'getId' )
			->will   ( $this->returnValue( 234 ) )
		;
		
		$wg = (object) array( 'Article' => $mockArticle, 'CityID' => 456 );
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		$wgRefl->setValue( $mockBacklinks, $wg );

		
		$mockOptions = array();
		$oldmockText = 'foo';
		$mockText = 'bar';
		$mockAttribs = array();
		$mockRet = false;
		$this->assertTrue(
				$mockBacklinks->onLinkEnd( $mockSkin, $mockTitle, $mockOptions, $mockText, $mockAttribs, $mockRet ),
				"Backlinks::onLinkEnd should always return true"
		);
		
		$backlinkRows = new ReflectionProperty( 'Backlinks', 'backlinkRows' );
		$backlinkRows->setAccessible( true );
		$this->assertArrayHasKey(
				'456_123',
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should initialize a key for the target article solr doc ID' 
		);
		$this->assertContains(
				array( $oldmockText => array( '456_234' => 1 ), $mockText => array( '456_234' => 1 ) ),
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should add a text key with the source ID keying a count if the target has been initialized'
		);
	}
	
	/**
	 * @covers Backlinks::onLinkEnd
	 */
	public function testOnLinkEndUninitializedSourceId()
	{
		$mockBacklinks = $this->getMockBuilder( 'Backlinks' )
								->setMethods( array( 'foo' ) ) // doesn't work without it 
								->getMock();
		
		$mockArticle = $this->getMockBuilder( 'Article' )
							->disableOriginalConstructor()
							->setMethods( array( 'getId' ) )
							->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
						  ->disableOriginalConstructor()
						  ->setMethods( array( 'getArticleId' ) )
						  ->getMock();
		
		$mockSkin = $this->getMockBuilder( 'SkinOasis' )
						->disableOriginalConstructor()
						->getMock();
		
		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getArticleId' )
			->will   ( $this->returnValue( 123 ) )
		;
		$mockArticle
			->expects( $this->at( 0 ) )
			->method ( 'getId' )
			->will   ( $this->returnValue( 789 ) )
		;
		
		$wg = (object) array( 'Article' => $mockArticle, 'CityID' => 456 );
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		$wgRefl->setValue( $mockBacklinks, $wg );

		
		$mockOptions = array();
		$oldmockText = 'foo';
		$mockText = 'bar';
		$mockAttribs = array();
		$mockRet = false;
		$this->assertTrue(
				$mockBacklinks->onLinkEnd( $mockSkin, $mockTitle, $mockOptions, $mockText, $mockAttribs, $mockRet ),
				"Backlinks::onLinkEnd should always return true"
		);
		
		$backlinkRows = new ReflectionProperty( 'Backlinks', 'backlinkRows' );
		$backlinkRows->setAccessible( true );
		$this->assertArrayHasKey(
				'456_123',
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should initialize a key for the target article solr doc ID' 
		);
		$this->assertContains(
				array( $oldmockText => array( '456_234' => 1 ), $mockText => array( '456_234' => 1, '456_789' => 1 ) ),
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should add a source key for text if that text key has already been initialized'
		);
	}
	
	/**
	 * @covers Backlinks::onLinkEnd
	 */
	public function testOnLinkEndFullyInitialized()
	{
		$mockBacklinks = $this->getMockBuilder( 'Backlinks' )
								->setMethods( array( 'foo' ) ) // doesn't work without it 
								->getMock();
		
		$mockArticle = $this->getMockBuilder( 'Article' )
							->disableOriginalConstructor()
							->setMethods( array( 'getId' ) )
							->getMock();
		
		$mockTitle = $this->getMockBuilder( 'Title' )
						  ->disableOriginalConstructor()
						  ->setMethods( array( 'getArticleId' ) )
						  ->getMock();
		
		$mockSkin = $this->getMockBuilder( 'SkinOasis' )
						->disableOriginalConstructor()
						->getMock();
		
		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getArticleId' )
			->will   ( $this->returnValue( 123 ) )
		;
		$mockArticle
			->expects( $this->at( 0 ) )
			->method ( 'getId' )
			->will   ( $this->returnValue( 789 ) )
		;
		
		$wg = (object) array( 'Article' => $mockArticle, 'CityID' => 456 );
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		$wgRefl->setValue( $mockBacklinks, $wg );

		
		$mockOptions = array();
		$oldmockText = 'foo';
		$mockText = 'bar';
		$mockAttribs = array();
		$mockRet = false;
		$this->assertTrue(
				$mockBacklinks->onLinkEnd( $mockSkin, $mockTitle, $mockOptions, $mockText, $mockAttribs, $mockRet ),
				"Backlinks::onLinkEnd should always return true"
		);
		
		$backlinkRows = new ReflectionProperty( 'Backlinks', 'backlinkRows' );
		$backlinkRows->setAccessible( true );
		$this->assertArrayHasKey(
				'456_123',
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should initialize a key for the target article solr doc ID' 
		);
		$this->assertContains(
				array( $oldmockText => array( '456_234' => 1 ), $mockText => array( '456_234' => 1, '456_789' => 2 ) ),
				$backlinkRows->getValue( $mockBacklinks ),
				'Backlinks::onLinkEnd should increment the count if target, source, and text have all been initialized'
		);
	}
}