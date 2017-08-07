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
     * @group Slow
     * @group Broken
     * @slowExecutionTime 0.16133 ms
     * Test if the thumbnail gets generated for article
     */
    public function testArticleImageGeneration() {
        $memkey = 'sght_memkey';
        $thumbUrl = 'http://www.wikia.com/wiki/fake.jpg';

        $mock_cache = $this->getMock('stdClass', array('get', 'set'));
        $mock_cache->expects($this->once())
            ->method('get')
            ->with($this->equalTo($memkey))
            ->will($this->returnValue(null));
        $mock_cache->expects($this->once())
            ->method('set')
            ->with($this->equalTo($memkey),$this->equalTo($thumbUrl));

        $fileMock = $this->getMock('File', array(), array(), '', FALSE);
        $mockedFileTitle = $this->getMock( 'Title' );

        $this->mockGlobalVariable('wgMemc', $mock_cache, 0);

        $mockFindFile = $this->getGlobalFunctionMock( 'wfFindFile' );

        $mockFindFile
            ->expects( $this->once() )
            ->method( 'wfFindFile' )
            ->with( $this->equalTo( $mockedFileTitle ) )
            ->will( $this->returnValue( $fileMock ) );

        $mockedTitle = $this->getMock('Title');

        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'getFirstArticleImage' )
            ->expects($this->once())
            ->method('getFirstArticleImage')
            ->with($this->equalTo( $mockedTitle ) )
            ->will( $this->returnValue( $mockedFileTitle ) );

        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'getThumbFromFile' )
            ->expects($this->once())
            ->method('getThumbFromFile')
            ->with($this->equalTo( $fileMock ) )
            ->will( $this->returnValue( $thumbUrl ) );

        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'makeOpenGraphKey' )
            ->expects( $this->any() )
            ->method('makeOpenGraphKey')
            ->will( $this->returnValue($memkey) );

        $mocked = $this->getMock('SEOTweaksHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeOpenGraphKey') );

        $meta = array('foo'=>'bar');
        $mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
        $this->assertEquals(array('foo'=>'bar', 'og:image' => $thumbUrl), $meta);
    }

    /**
     * @group Slow
     * @group Broken
     * @slowExecutionTime 0.14801 ms
     * Test if the thumbnail gets generated for article from file namespace
     */
    public function testFileImageGeneration() {
        $memkey = 'sght_memkey2';
        $thumbUrl = 'http://www.wikia.com/wiki/fake2.jpg';

        $mock_cache = $this->getMock('stdClass', array('get', 'set'));
        $mock_cache->expects($this->once())
            ->method('get')
            ->with($this->equalTo($memkey))
            ->will($this->returnValue(null));
        $mock_cache->expects($this->once())
            ->method('set')
            ->with($this->equalTo($memkey),$this->equalTo($thumbUrl));

        $fileMock = $this->getMock('File', array(), array(), '', FALSE);
        $mockedTitle = $this->getMock('Title', array('getNamespace') );
        $mockedTitle->expects($this->any())
            ->method('getNamespace')
            ->will($this->returnValue(NS_FILE));

        $this->mockGlobalVariable('wgMemc', $mock_cache, 0);
        $this->getGlobalFunctionMock( 'wfFindFile' )
            ->expects( $this->exactly( 1 ) )
            ->method( 'wfFindFile' )
            ->with( $mockedTitle )
            ->will( $this->returnValue( $fileMock ) );

        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'getFirstArticleImage' )
            ->expects($this->never())
            ->method('getFirstArticleImage');
        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'getThumbFromFile' )
            ->expects($this->once())
            ->method('getThumbFromFile')
            ->with($this->equalTo( $fileMock ) )
            ->will( $this->returnValue( $thumbUrl ) );
        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'makeOpenGraphKey' )
            ->expects( $this->any() )
            ->method('makeOpenGraphKey')
            ->will( $this->returnValue($memkey) );

        $mocked = $this->getMock('SEOTweaksHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeOpenGraphKey') );

        $meta = array('foo'=>'bar');
        $mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
        $this->assertEquals(array('foo'=>'bar', 'og:image' => $thumbUrl), $meta);
    }

    /**
     * @group Slow
     * @group Broken
     * @slowExecutionTime 0.10808 ms
     * Test if we don't try to generate thumbnail for user pages (bugid 98881)
     */
    public function testUserNS() {
        $mock_cache = $this->getMock('stdClass', array('get', 'set'));
        $mock_cache->expects($this->never())
            ->method('get');
        $mock_cache->expects($this->never())
            ->method('set');

        $this->mockGlobalVariable('wgMemc', $mock_cache, 0);

        $mockedTitle = $this->getMock('Title', array('getNamespace') );
        $mockedTitle->expects($this->any())
            ->method('getNamespace')
            ->will($this->returnValue(NS_USER));

        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'makeOpenGraphKey' )
            ->expects($this->any())
            ->method('makeOpenGraphKey')
            ->will($this->returnValue('bar'));
        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'getFirstArticleImage' )
            ->expects($this->never())
            ->method('getFirstArticleImage');
        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'getThumbFromFile' )
            ->expects($this->never())
            ->method('getThumbFromFile');
        $meta = array('foo'=>'bar');

        $mocked = $this->getMock('SEOTweaksHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeOpenGraphKey') );

        $mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
        $this->assertEquals(array('foo'=>'bar'), $meta);
    }
    /**
     * @group Slow
     * @group Broken
     * @slowExecutionTime 0.0735 ms
     * As tests above cover all the generation cases, we right now use the cached value to check the
     * behaviour in remaining scenarios
     * @dataProvider getCacheDataProvider
     */
    public function testCache($memcacheValue, $meta, $expected, $desciption) {
        $memkey = 'sght_memkey2';

        $mock_cache = $this->getMock('stdClass', array('get', 'set'));
        $mock_cache->expects($this->once())
            ->method('get')
            ->with($this->equalTo($memkey))
            ->will($this->returnValue($memcacheValue));
        $mock_cache->expects($this->never())
            ->method('set');

        $this->mockGlobalVariable('wgMemc', $mock_cache, 0);

        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'makeOpenGraphKey' )
            ->expects( $this->any() )
            ->method('makeOpenGraphKey')
            ->will( $this->returnValue($memkey) );
        $this->getStaticMethodMock( 'SEOTweaksHooksHelper', 'getThumbFromFile' )
            ->expects($this->never())
            ->method('getThumbFromFile');

        $mocked = $this->getMock('SEOTweaksHooksHelper', array('getThumbFromFile', 'getFirstArticleImage', 'makeOpenGraphKey') );

        $mockedTitle = $this->getMock('Title');
        $mocked->onOpenGraphMetaHeaders($meta, $mockedTitle);
        $this->assertEquals($expected, $meta, $desciption);

    }

    public function getCacheDataProvider() {
        return array(
            array('http://www.wikia.com/wiki/fake3.jpg', array('foo'=>'bar'), array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/fake3.jpg'),
                'cached value'
            ),
            array('http://www.wikia.com/wiki/fake3.jpg', array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/to_override.jpg'), array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/fake3.jpg'),
                'cache overrides input value'
            ),
            array('', array('foo'=>'bar'), array('foo'=>'bar'),
                'if no thumbnail was generated, don\'t create the entry for \'og:image\''
            ),
            array('', array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/dont_override.jpg'), array('foo'=>'bar', 'og:image' => 'http://www.wikia.com/wiki/dont_override.jpg'),
                'if no thumbnail was generated, don\'t override the input value'
            ),
        );
    }

    /**
	 * @covers SEOTweaksHooksHelper::onImagePageAfterImageLinks
	 * @group Broken
	 */
	public function testOnImagePageAfterImageLinksEmpties() {

		/** @var ImagePage|PHPUnit_Framework_MockObject_MockObject $mockImagePage */
		$mockImagePage = $this->createMock( ImagePage::class );
		$mockOut = $this->createMock( OutputPage::class );

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

		$mockOut
			->expects( $this->never() )
			->method ( 'setPageTitle' )
		;

		$this->assertTrue(
				SEOTweaksHooksHelper::onImagePageAfterImageLinks( $mockImagePage, '' ),
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

}
