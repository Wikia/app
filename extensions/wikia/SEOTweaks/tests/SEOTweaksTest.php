<?php

class SEOTweaksTest extends WikiaBaseTest {

	/** @var PHPUnit_Framework_MockObject_MockBuilder $helperMocker */
	private $helperMocker;

	protected function setUp() {
		parent::setUp();
        $this->setupFile =  dirname(__FILE__) . '/../SEOTweaks.setup.php';
		$this->helperMocker = $this->getMockBuilder( 'SEOTweaksHooksHelper' )
									->disableOriginalConstructor();

	}

	/**
	 * @covers SEOTweaksHooksHelper::onArticleViewHeader
	 */
	public function testOnArticleViewHeaderTitleExists()
	{
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
		                                 ->getMock();

		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'exists' ) )
		                  ->getMock();

		$outputDone = false;
		$pcache = false;

		$mockArticle
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->at( 0 ) )
		    ->method ( 'exists' )
		    ->will   ( $this->returnValue( true ) )
		;

		$this->assertTrue(
				$mockHelper->onArticleViewHeader( $mockArticle, $outputDone, $pcache),
				'SEOTweaksHooksHelper::onArticleViewHeader should always return true'
		);
		$this->assertFalse(
				$outputDone,
				'$outputDone should not be set to true by SEOTweaksHooksHelper::onArticleViewHeader unless we redirect'
		);
	}

    /**
	 * @covers SEOTweaksHooksHelper::onArticleViewHeader
	 */
	public function testOnArticleViewHeaderTitleExistsNonShareReferrer()
	{
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
		                                 ->getMock();

		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'exists' ) )
		                  ->getMock();

		$outputDone = false;
		$pcache = false;

		$mockArticle
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->at( 0 ) )
		    ->method ( 'exists' )
		    ->will   ( $this->returnValue( false ) )
		;

		$this->assertTrue(
				$mockHelper->onArticleViewHeader( $mockArticle, $outputDone, $pcache),
				'SEOTweaksHooksHelper::onArticleViewHeader should always return true'
		);
		$this->assertFalse(
				$outputDone,
				'$outputDone should not be set to true by SEOTweaksHooksHelper::onArticleViewHeader unless we redirect'
		);
	}

	/**
     * @group Slow
     * @slowExecutionTime 0.03886 ms
	 * @covers SEOTweaksHooksHelper::onArticleViewHeader
	 */
    public function testOnArticleViewHeaderTitleNotExistsNoResults()
	{
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
		                                 ->getMock();

		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'exists', 'getDBKey', 'isContentPage', 'getNamespace' ) )
		                  ->getMock();

		$mockDb = $this->getMockBuilder( "DatabaseMysqli" )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'query', 'fetchObject', 'buildLike', 'anyString' ) )
		               ->getMock();

		$mockResultWrapper = $this->getMockBuilder( 'ResultWrapper' )
		                          ->disableOriginalConstructor()
		                          ->getMock();

		$outputDone = false;
		$pcache = false;

		$dbKey = "Wanted";
		$_SERVER['HTTP_REFERER'] = 'http://www.facebook.com';

		$mockArticle
		    ->expects( $this->once() )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
			->expects( $this->once() )
			->method ( 'exists' )
			->will   ( $this->returnValue( false ) )
		;
		$mockTitle
			->expects( $this->once() )
			->method ( 'isContentPage' )
			->will   ( $this->returnValue( true ) )
		;
		$mockTitle
			->expects( $this->once() )
			->method ( 'getNamespace' )
			->will   ( $this->returnValue( 66 ) )
		;
		$mockTitle
			->expects( $this->once() )
			->method ( 'getDBKey' )
			->will   ( $this->returnValue( $dbKey ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'anyString' )
		    ->will   ( $this->returnValue( '%' ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'buildLike' )
		    ->with   ( $dbKey, '%' )
		    ->will   ( $this->returnValue( "LIKE '{$dbKey}%'" ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'query' )
		    ->with   ( "SELECT page_title FROM page WHERE page_title LIKE '{$dbKey}%' AND page_namespace = 66 LIMIT 1" )
		    ->will   ( $this->returnValue( $mockResultWrapper ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'fetchObject' )
		    ->will   ( $this->returnValue( null ) )
		;

		$this->mockGlobalFunction('wfGetDB', $mockDb);

		$this->assertTrue(
				$mockHelper->onArticleViewHeader( $mockArticle, $outputDone, $pcache),
				'SEOTweaksHooksHelper::onArticleViewHeader should always return true'
		);
		$this->assertFalse(
				$outputDone,
				'$outputDone should not be set to true by SEOTweaksHooksHelper::onArticleViewHeader unless we redirect'
		);
	}

	/**
     * @group Slow
     * @slowExecutionTime 0.09149 ms
	 * @covers SEOTweaksHooksHelper::onArticleViewHeader
	 */
    public function testOnArticleViewHeaderTitleNotExistsWithResults()
	{
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
		                                 ->getMock();

		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'getTitle' ) )
		                    ->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'exists', 'getDBKey', 'getFullUrl', 'isContentPage', 'getNamespace' ) )
		                  ->getMock();

		$mockDb = $this->getMockBuilder( "DatabaseMysqli" )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'query', 'fetchObject', 'buildLike', 'anyString' ) )
		               ->getMock();

		$mockResultWrapper = $this->getMockBuilder( 'ResultWrapper' )
		                          ->disableOriginalConstructor()
		                          ->getMock();

		$mockOut = $this->getMockBuilder( 'OutputPage' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'redirect' ) )
		                ->getMock();

		$outputDone = false;
		$pcache = false;

		$dbKey = "Wanted";
		$_SERVER['HTTP_REFERER'] = 'http://www.facebook.com';
		$resultObject = (object) array( 'page_title' => "Wanted!" );
		$fullUrl = 'http://foo.wikia.com/wiki/Wanted!';

		$mockArticle
		    ->expects( $this->once() )
		    ->method ( 'getTitle' )
		    ->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'exists' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockTitle
			->expects( $this->once() )
			->method ( 'getDBKey' )
			->will   ( $this->returnValue( $dbKey ) )
		;
		$mockTitle
			->expects( $this->once() )
			->method ( 'getNamespace' )
			->will   ( $this->returnValue( 66 ) )
		;
		$mockTitle
			->expects( $this->once() )
			->method ( 'isContentPage' )
			->will   ( $this->returnValue( true ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'anyString' )
		    ->will   ( $this->returnValue( '%' ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'buildLike' )
		    ->with   ( $dbKey, '%' )
		    ->will   ( $this->returnValue( "LIKE '{$dbKey}%'" ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'query' )
		    ->with   ( "SELECT page_title FROM page WHERE page_title LIKE '{$dbKey}%' AND page_namespace = 66 LIMIT 1" )
		    ->will   ( $this->returnValue( $mockResultWrapper ) )
		;
		$mockDb
		    ->expects( $this->once() )
		    ->method ( 'fetchObject' )
		    ->will   ( $this->returnValue( $resultObject ) )
		;
		$mockTitle
		    ->expects( $this->once() )
		    ->method ( 'getFullUrl' )
		    ->will   ( $this->returnValue( $fullUrl ) )
		;
		$mockOut
		    ->expects( $this->once() )
		    ->method ( 'redirect' )
		    ->with   ( $fullUrl )
		;

		$this->mockClass( 'Title', $mockTitle );
		$this->mockClass( 'Title', $mockTitle, 'newFromText' );
		$this->mockGlobalFunction('wfGetDB',$mockDb);
		$this->mockGlobalVariable('wgOut',$mockOut);

		$this->assertTrue(
				$mockHelper->onArticleViewHeader( $mockArticle, $outputDone, $pcache),
				'SEOTweaksHooksHelper::onArticleViewHeader should always return true'
		);
		$this->assertTrue(
				$outputDone,
				'$outputDone should be set to true by SEOTweaksHooksHelper::onArticleViewHeader if we redirect'
		);
	}

	/**
	 * @param string $url
	 * @param string $expected
	 * @param string $message
	 *
	 * @param $primaryDomain
	 * @param $cityId
	 * @dataProvider onLinkerMakeExternalLinkDataProvider
	 */
	public function testOnLinkerMakeExternalLink( $url, $expected, $primaryDomain, $cityId, $message ) {

		$dummyString = '';
		$dummyBool = false;
		$dummyArray = [];

		$this->mockStaticMethod( 'WikiFactory', 'DomainToID', $cityId );
		$this->mockStaticMethod( 'WikiFactory', 'cityIDtoUrl', $primaryDomain );

		$res = $url;
		$this->assertTrue(SEOTweaksHooksHelper::onLinkerMakeExternalLink( $res, $dummyString, $dummyBool, $dummyArray
		), 'Should always return true' );
		$this->assertEquals( $expected, $res, $message );
	}

	public function onLinkerMakeExternalLinkDataProvider() {
		yield [
			'http://muppet.wikia.com',
			'http://muppet.fandom.com',
			'http://muppet.fandom.com',
			1,
			'Should handle domain change'
		];
		yield [
			'https://wikipedia.org',
			'https://wikipedia.org',
			null,
			null,
			'Should leave truly external links alone'
		];
		yield [
			'http://de.starwars.wikia.com',
			'http://starwars.fandom.com/de',
			'http://starwars.fandom.com/de',
			1,
			'Should append language path in case original request uses language prefix'
		];
		yield [
			'http://de.starwars.wikia.com/path_to/article',
			'http://starwars.fandom.com/de/path_to/article',
			'http://starwars.fandom.com/de',
			1,
			'Should preserve article path when handling language path'
		];
		yield [
			'http://starwars.wikia.com/en',
			'http://starwars.fandom.com',
			'http://starwars.fandom.com',
			1,
			'Should remove language path for english alias'
		];
		yield [
			'http://starwars.wikia.com/en/path_to/article',
			'http://starwars.fandom.com/path_to/article',
			'http://starwars.fandom.com',
			1,
			'Should preserve article path when removing redundant language path'
		];
	}
}
