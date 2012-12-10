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
		
		$mockOut = $this->getMockbuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'addMeta', 'addLink' ) )
						->getMock();
		
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();
		
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		
		$mockOut
			->expects( $this->never() )
			->method ( 'addMeta' )
		;
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
		
		$mockOut = $this->getMockbuilder( 'OutputPage' )
						->disableOriginalConstructor()
						->setMethods( array( 'addMeta', 'addLink' ) )
						->getMock();
		
		$mockHelper = $this->helperMocker->setMethods( array( 'foo' ) ) // fake method required to run real methods
										->getMock();
		
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		
		$wg = (object) array( 'SEOGoogleSiteVerification' => 'foobar', 'SEOGooglePlusLink' => 'bazqux' );
		
		$wgRefl->setValue( $mockHelper, $wg ); 
		
		$mockOut
			->expects( $this->at( 0 ) )
			->method ( 'addMeta' )
			->with   ( 'google-site-verification', $wg->SEOGoogleSiteVerification )
		;
		$mockOut
			->expects( $this->at( 1 ) )
			->method ( 'addLink' )
			->with   ( array( 'href' => $wg->SEOGooglePlusLink, 'rel' => 'publisher' ) )
		;
		$this->assertTrue(
				$mockHelper->onBeforePageDisplay( $mockOut ),
				'SEOTweaksHooksHelper::onBeforePageDisplay should always return true'
		);
	}
	
	/**
	 * @covers SEOTweaksHooksHelper::onArticleBeforeTitle
	 */
	public function testOnArticleBeforeTitleValid() {
		
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
		$mockOut
			->expects( $this->never() )
			->method ( 'setStatusCode' ) 
		;
		
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		
		$wg = (object) array( 'Out' => $mockOut );
		
		$wgRefl->setValue( $mockHelper, $wg );
		
		$this->assertTrue(
				$mockHelper->onArticleFromTitle( $mockTitle, $mockArticle ),
				'SEOTweaksHooksHelper::onArticleBeforeTitleValid should always return true'
		);
	}
	
	/**
	 * @covers SEOTweaksHooksHelper::onArticleBeforeTitle
	 */
	public function testOnArticleBeforeTitleNotValid() {
		
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
			->will   ( $this->returnValue( false ) )
		;
		$mockTitle
			->expects( $this->at( 1 ) )
			->method ( 'isDeleted' )
			->will   ( $this->returnValue( true ) )
		;
		$mockOut
			->expects( $this->at( 0 ) )
			->method ( 'setStatusCode' )
			->with   ( SEOTweaksHooksHelper::DELETED_PAGES_STATUS_CODE ) 
		;
		
		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		
		$wg = (object) array( 'Out' => $mockOut );
		
		$wgRefl->setValue( $mockHelper, $wg );
		
		$this->assertTrue(
				$mockHelper->onArticleFromTitle( $mockTitle, $mockArticle ),
				'SEOTweaksHooksHelper::onArticleBeforeTitleValid should always return true'
		);
	}
	
	/**
	 * @covers SEOTweaksHooksHelper::onImagePageAfterImageLinks
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
		
		$wfRefl = new ReflectionProperty( 'WikiaObject', 'wf' );
		$wfRefl->setAccessible( true );
		$wfRefl->setValue( $mockHelper, $mockWrapper );
		
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
		$mockWrapper
			->expects( $this->at( 0 ) )
			->method ( 'Msg' )
			->with   ( 'seotweaks-image' )
			->will   ( $this->returnValue( 'A' ) )
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

		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		$wg = (object) array( 'Out' => $mockOut );
		$wgRefl->setValue( $mockHelper, $wg );
		
		
		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );
		$this->mockApp();
		
		$this->assertTrue(
				$mockHelper->onImagePageAfterImageLinks( $mockImagePage, '' ),
				'SEOTweaksHooksHelper::onImagePageAfterImageLinks should always return true'
		);
	}
	
	/**
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
		
		$wfRefl = new ReflectionProperty( 'WikiaObject', 'wf' );
		$wfRefl->setAccessible( true );
		$wfRefl->setValue( $mockHelper, $mockWrapper );
		
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
		$mockWrapper
			->expects( $this->at( 0 ) )
			->method ( 'Msg' )
			->with   ( 'seotweaks-video' )
			->will   ( $this->returnValue( 'A' ) )
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

		$wgRefl = new ReflectionProperty( 'WikiaObject', 'wg' );
		$wgRefl->setAccessible( true );
		$wg = (object) array( 'Out' => $mockOut );
		$wgRefl->setValue( $mockHelper, $wg );
		
		
		$this->mockClass( 'WikiaFileHelper', $mockFileHelper );
		$this->mockApp();
		
		$this->assertTrue(
				$mockHelper->onImagePageAfterImageLinks( $mockImagePage, '' ),
				'SEOTweaksHooksHelper::onImagePageAfterImageLinks should always return true'
		);
	}
	
}