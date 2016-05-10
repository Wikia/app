<?php

class SEOTweaksTest extends WikiaBaseTest
{

	public function setUp() {
		parent::setUp();
		$this->helperMocker = $this->getMockBuilder( 'SEOTweaksHooksHelper' )
									->disableOriginalConstructor();

	}

	/**
	 * @covers SEOTweaksHooksHelper::onBeforePageDisplay
	 */
	public function testOnBeforePageDisplayWithoutGoogleVals() {

		$this->mockGlobalVariable('wgSEOGooglePlusLink', null);

		$mockOut = $this->getMockbuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'addLink' ) )
						->getMock();

		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );

		$mockOut
			->expects( $this->never() )
			->method ( 'addLink' )
		;

		// first, with neither setting -- nothing should happen
		$this->assertTrue(
				$mockHelper->onBeforePageDisplay( $mockOut ),
				'SEOTweaksHooksHelper::onBeforePageDisplay should always return true'
		);
	}

	/**
	 * @covers SEOTweaksHooksHelper::onBeforePageDisplay
	 */
	public function testOnBeforePageDisplayWithGoogleVals() {

		$this->mockGlobalVariable('wgSEOGooglePlusLink', 'bazqux');

		$mockOut = $this->getMockbuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'addLink' ) )
						->getMock();

		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );

		$mockOut
			->expects( $this->once() )
			->method ( 'addLink' )
			->with   ( array( 'href' => 'bazqux', 'rel' => 'publisher' ) )
		;
		$this->assertTrue(
				$mockHelper->onBeforePageDisplay( $mockOut ),
				'SEOTweaksHooksHelper::onBeforePageDisplay should always return true'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.01246 ms
	 * @covers SEOTweaksHooksHelper::onAfterInitialize
	 */
	public function testOnAfterInitializeValid() {

		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
						->disableOriginalConstructor()
						->setMethods( array( 'exists', 'isDeleted' ) )
						->getMock();

		$mockArticle = $this->getMockBuilder( 'Article' )
							->disableOriginalConstructor()
							->getMock();

		$mockOut = $this->getMockbuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'setStatusCode' ) )
						->getMock();

		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'exists' )
			->will   ( $this->returnValue( true ) )
		;
		$mockTitle
			->expects( $this->never() )
			->method ( 'isDeleted' )
		;
		$mockTitle
			->expects( $this->never() )
			->method ( 'getNamespace' )
		;
		$mockOut
			->expects( $this->never() )
			->method ( 'setStatusCode' )
		;

		$this->assertTrue(
				$mockHelper->onAfterInitialize( $mockTitle, $mockArticle, $mockOut ),
				'SEOTweaksHooksHelper::onAfterInitialize should always return true'
		);
	}

	/**
	 * @covers SEOTweaksHooksHelper::onAfterInitialize
	 */
	public function testOnAfterInitializeNotValid() {

		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
						->disableOriginalConstructor()
						->setMethods( array( 'exists', 'isDeleted', 'getNamespace' ) )
						->getMock();

		$mockArticle = $this->getMockBuilder( 'Article' )
							->disableOriginalConstructor()
							->getMock();

		$mockOut = $this->getMockbuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'setStatusCode' ) )
						->getMock();

		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'exists' )
			->will   ( $this->returnValue( false ) )
		;
		$mockTitle
			->expects( $this->at( 1 ) )
			->method ( 'isDeleted' )
			->will   ( $this->returnValue( true ) )
		;
		$mockTitle
			->expects( $this->at( 2 ) )
			->method ( 'getNamespace' )
			->will   ( $this->returnValue( NS_MAIN ) )
		;
		$mockOut
			->expects( $this->at( 0 ) )
			->method ( 'setStatusCode' )
			->with   ( SEOTweaksHooksHelper::DELETED_PAGES_STATUS_CODE )
		;

		$this->assertTrue(
				$mockHelper->onAfterInitialize( $mockTitle, $mockArticle, $mockOut ),
				'SEOTweaksHooksHelper::onAfterInitialize should always return true'
		);
	}

	/**
	 * @covers SEOTweaksHooksHelper::onImagePageAfterImageLinks
	 * @group Broken
	 */
	public function testOnImagePageAfterImageLinksEmpties() {

		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$mockImagePage = $this->getMockBuilder( 'ImagePage' )
							->disableOriginalConstructor()
							->setMethods( array( 'getDisplayedFile', 'getTitle' ) )
							->getMock();

		$mockFileHelper = $this->getMockBuilder( 'WikiaFileHelper' )
								->disableOriginalConstructor()
								->setMethods( array( 'isFileTypeVideo' ) )
								->getMock();

		$mockOut = $this->getMockBuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'setPageTitle' ) )
						->getMock();

		$mockWrapper = $this->getMockBuilder( 'WikiaFunctionWrapper' )
							->disableOriginalConstructor()
							->setMethods( array( 'Msg' ) )
							->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
							->disableOriginalConstructor()
							->setMethods( array( 'getBaseText' ) )
							->getMock();

		$mockFile = $this->getMockBuilder( 'File' )
							->disableOriginalConstructor()
							->setMethods( array( 'getHandler' ) )
							->getMock();


		$wfRefl = new ReflectionProperty( 'WikiaObject', 'wf' );
		$wfRefl->setAccessible( true );
		$wfRefl->setValue( $mockHelper, $mockWrapper );

		$mockImagePage
			->expects( $this->at( 0 ) )
			->method ( 'getDisplayedFile' )
			->will   ( $this->returnValue( null ) )
		;
		$mockImagePage
			->expects( $this->at( 1 ) )
			->method ( 'getTitle' )
			->will   ( $this->returnValue( null ) )
		;

		$mockFileHelper
			->staticExpects( $this->never() )
			->method       ( 'isFileTypeVideo' )
		;
		$mockOut
			->expects( $this->never() )
			->method ( 'setPageTitle' )
		;

		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );

		$this->assertTrue(
				$mockHelper->onImagePageAfterImageLinks( $mockImagePage, '' ),
				'SEOTweaksHooksHelper::onImagePageAfterImageLinks should always return true'
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.04518 ms
	 * @covers SEOTweaksHooksHelper::onImagePageAfterImageLinks
	 */
	public function testOnImagePageAfterImageLinksImage() {

		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$mockImagePage = $this->getMockBuilder( 'ImagePage' )
							->disableOriginalConstructor()
							->setMethods( array( 'getDisplayedFile', 'getTitle' ) )
							->getMock();

		$mockFileHelper = $this->getMockBuilder( 'WikiaFileHelper' )
								->disableOriginalConstructor()
								->setMethods( array( 'isFileTypeVideo' ) )
								->getMock();

		$mockOut = $this->getMockBuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'setPageTitle' ) )
						->getMock();

		$mockWrapper = $this->getMockBuilder( 'WikiaFunctionWrapper' )
							->disableOriginalConstructor()
							->setMethods( array( 'Msg' ) )
							->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
							->disableOriginalConstructor()
							->setMethods( array( 'getBaseText' ) )
							->getMock();

		$mockFile = $this->getMockBuilder( 'LocalFile' )
							->disableOriginalConstructor()
							->setMethods( array( 'getHandler' ) )
							->getMock();

		$mockHandler = $this->getMockBuilder( 'JpegHandler' )
							->disableOriginalConstructor()
							->getMock();

		$mockImagePage
			->expects( $this->at( 0 ) )
			->method ( 'getDisplayedFile' )
			->will   ( $this->returnValue( $mockFile ) )
		;
		$mockImagePage
			->expects( $this->at( 1 ) )
			->method ( 'getTitle' )
			->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockFileHelper
			->staticExpects( $this->once() )
			->method       ( 'isFileTypeVideo' )
			->will         ( $this->returnValue( false ) )
		;
		$mockFile
			->expects( $this->at( 0 ) )
			->method ( 'getHandler' )
			->will   ( $this->returnValue( $mockHandler ) )
		;
		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getBaseText' )
			->will   ( $this->returnValue( 'B' ) )
		;
		$mockOut
			->expects( $this->at( 0 ) )
			->method ( 'setPageTitle' )
			->with   ( 'A - B' )
		;

		$this->getGlobalFunctionMock( 'wfMsg' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMsg' )
			->will( $this->returnValue( 'A' ) );

		$this->mockGlobalVariable('wgOut',$mockOut);
		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );

		$this->assertTrue(
				$mockHelper->onImagePageAfterImageLinks( $mockImagePage, '' ),
				'SEOTweaksHooksHelper::onImagePageAfterImageLinks should always return true'
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.03643 ms
	 * @covers SEOTweaksHooksHelper::onImagePageAfterImageLinks
	 */
	public function testOnImagePageAfterImageLinksVideo() {

		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$mockImagePage = $this->getMockBuilder( 'ImagePage' )
							->disableOriginalConstructor()
							->setMethods( array( 'getDisplayedFile', 'getTitle' ) )
							->getMock();

		$mockFileHelper = $this->getMockBuilder( 'WikiaFileHelper' )
								->disableOriginalConstructor()
								->setMethods( array( 'isFileTypeVideo' ) )
								->getMock();

		$mockOut = $this->getMockBuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'setPageTitle' ) )
						->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
							->disableOriginalConstructor()
							->setMethods( array( 'getBaseText' ) )
							->getMock();

		$mockFile = $this->getMockBuilder( 'LocalFile' )
							->disableOriginalConstructor()
							->setMethods( array( 'getHandler' ) )
							->getMock();

		$mockHandler = $this->getMockBuilder( 'JpegHandler' )
							->disableOriginalConstructor()
							->getMock();

		$mockImagePage
			->expects( $this->at( 0 ) )
			->method ( 'getDisplayedFile' )
			->will   ( $this->returnValue( $mockFile ) )
		;
		$mockImagePage
			->expects( $this->at( 1 ) )
			->method ( 'getTitle' )
			->will   ( $this->returnValue( $mockTitle ) )
		;
		$mockFileHelper
			->staticExpects( $this->once() )
			->method       ( 'isFileTypeVideo' )
			->will         ( $this->returnValue( true ) )
		;
		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getBaseText' )
			->will   ( $this->returnValue( 'B' ) )
		;
		$mockOut
			->expects( $this->at( 0 ) )
			->method ( 'setPageTitle' )
			->with   ( 'A - B' )
		;

		$this->getGlobalFunctionMock( 'wfMsg' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMsg' )
			->will( $this->returnValue( 'A' ) );

		$this->mockGlobalVariable('wgOut',$mockOut);
		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );

		$this->assertTrue(
				$mockHelper->onImagePageAfterImageLinks( $mockImagePage, '' ),
				'SEOTweaksHooksHelper::onImagePageAfterImageLinks should always return true'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.02121 ms
	 * If the file already has alt text, do nothing
	 * @covers SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions
	 */
	public function testBeforeParserMakeImageLinkObjOptionsAltIsset() {
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
							->disableOriginalConstructor()
							->setMethods( array( 'getNamespace' ) )
							->getMock();

		$mockParser = $this->getMockBuilder( 'Parser' )
							->disableOriginalConstructor()
							->getMock();

		$parts = array( 'alt=This is my alt text' );
		$descQuery = false;
		$time = time();
		$options = array();
		$descQuery = false;
		$params = array();

		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getNamespace' )
			->will   ( $this->returnValue( NS_FILE ) )
		;

		$this->assertTrue(
				$mockHelper->onBeforeParserMakeImageLinkObjOptions( $mockParser, $mockTitle, $parts, $params, $time, $descQuery, $options ),
				'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions should always return true'
		);
		$this->assertEquals(
				1,
				count( $parts ),
				'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions should not add alt text if the option has already been set'
		);
		$this->assertContains(
				"alt=This is my alt text",
				$parts,
				'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions should not change the alt text if the option has already been set'
		);
	}

	/**
	 * If the file already has alt text, do nothing
	 * @covers SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions
	 */
	public function testOnBeforeParserMakeImageLinkObjOptionsNoAlt() {
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();

		$mockTitle = $this->getMockBuilder( 'Title' )
							->disableOriginalConstructor()
							->setMethods( array( 'getNamespace', 'getText' ) )
							->getMock();

		$mockParser = $this->getMockBuilder( 'Parser' )
							->disableOriginalConstructor()
							->getMock();

		$parts = array();
		$descQuery = false;
		$time = time();
		$options = array();
		$params = array();

		$mockTitle
			->expects( $this->at( 0 ) )
			->method ( 'getNamespace' )
			->will   ( $this->returnValue( NS_FILE ) )
		;
		$mockTitle
			->expects( $this->at( 1 ) )
			->method ( 'getText' )
			->will   ( $this->returnValue( 'James Bond - Dr. No.JPG' ) )
		;
		$this->assertTrue(
				$mockHelper->onBeforeParserMakeImageLinkObjOptions( $mockParser, $mockTitle, $parts, $params, $time, $descQuery, $options ),
				'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions should always return true'
		);
		$this->assertContains(
				"alt=James Bond - Dr. No",
				$parts,
				'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions should add an alt tag stripping out the file extension if no alt tag has been set'
		);
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

		$mockWrapper = $this->getMockBuilder( 'WikiaFunctionWrapper' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'GetDB' ) )
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
		$mockWrapper
		    ->expects( $this->never() )
		    ->method ( 'getDB' )
		;

		$reflWf = new ReflectionProperty( 'WikiaObject', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockHelper, $mockWrapper );

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

		$mockWrapper = $this->getMockBuilder( 'WikiaFunctionWrapper' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'GetDB' ) )
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
		$mockWrapper
		    ->expects( $this->never() )
		    ->method ( 'getDB' )
		;

		$reflWf = new ReflectionProperty( 'WikiaObject', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockHelper, $mockWrapper );

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
		/*
		$mockWrapper
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getDB' )
		    ->will   ( $this->returnValue( $mockDb ) )
		;
		*/
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

		/*
		$reflWf = new ReflectionProperty( 'WikiaObject', 'wf' );
		$reflWf->setAccessible( true );
		$reflWf->setValue( $mockHelper, $mockWrapper );
		*/

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

}
