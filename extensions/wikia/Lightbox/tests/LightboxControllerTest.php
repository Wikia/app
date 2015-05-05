<?php

class LightboxControllerTest extends WikiaBaseTest {

	public function testGetThumbImages_empty() {
		$request = $this->getMockBuilder( 'WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'getVal', 'getInt' ] )
			->getMock();
		$request->expects( $this->at( 0 ) )
			->method( 'getInt' )
			->with( 'count', $this->anything() )
			->will( $this->returnValue( 20 ) );
		$request->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( 'to', $this->anything() )
			->will( $this->returnValue( 0 ) ); // Empty timestamp
		$request->expects( $this->at( 2 ) )
			->method( 'getVal' )
			->with( 'inclusive', $this->anything() )
			->will( $this->returnValue( '' ) );

		$lightboxController = new \LightboxController();
		$lightboxController->setRequest( $request );
		$response = new \WikiaResponse( \WikiaResponse::FORMAT_HTML );
		$lightboxController->setResponse( $response );
		$lightboxController->getThumbImages();

		// Inspect response object
		$this->assertEquals( [], $lightboxController->getResponse()->getVal( 'thumbs' ) );
		$this->assertEquals( 0, $lightboxController->getResponse()->getVal( 'to' ) );
	}

	public function testGetThumbImages_exclude() {
		$time = time();
		$count = 5;
		$images = [
			'image 1',
			'image 2',
			'image 3',
		];
		$thumbs = [
			'thumb 1',
			'thumb 2',
			'thumb 3',
		];
		$imageList = [
			'images' => $images,
		    'minTimestamp' => $time - 10000,
		];
		$request = $this->getMockBuilder( 'WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'getVal', 'getInt' ] )
			->getMock();
		$request->expects( $this->at( 0 ) )
			->method( 'getInt' )
			->with( 'count', $this->anything() )
			->will( $this->returnValue( $count ) );
		$request->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( 'to', $this->anything() )
			->will( $this->returnValue( $time ) );
		$request->expects( $this->at( 2 ) )
			->method( 'getVal' )
			->with( 'inclusive', $this->anything() )
			->will( $this->returnValue( '' ) ); // Exclude latest photos

		$lightboxHelper = $this->getMockBuilder( 'LightboxHelper' )
			->disableOriginalConstructor()
			->setMethods( ['getImageList', 'getLatestPhotos'] )
			->getMock();
		$lightboxHelper->expects( $this->once() )
			->method( 'getImageList' )
			->with( $count, $time )
			->will( $this->returnValue( $imageList ) );

		$lightboxMock = $this->getMockBuilder( 'LightboxController' )
			->setMethods( ['mediaTableToThumbs', 'getLightboxHelper'] )
			->getMock();
		$lightboxMock->expects( $this->once() )
			->method( 'mediaTableToThumbs' )
			->with( $imageList['images'] )
			->will( $this->returnValue( $thumbs ) );
		$lightboxMock->expects( $this->once() )
			->method( 'getLightboxHelper' )
			->will( $this->returnValue( $lightboxHelper ) );

		$lightboxMock->setRequest( $request );
		$response = new \WikiaResponse( \WikiaResponse::FORMAT_HTML );
		$lightboxMock->setResponse( $response );
		$lightboxMock->getThumbImages();

		// Inspect response object
		$this->assertEquals( $thumbs, $lightboxMock->getResponse()->getVal( 'thumbs' ) );
		$this->assertEquals( $imageList['minTimestamp'], $lightboxMock->getResponse()->getVal( 'to' ) );
	}

	public function testGetThumbImages() {
		$time = time();
		$count = 5;
		$images = [
			'image 1',
			'image 2',
			'image 3',
		];
		$thumbs = [
			'thumb 1',
			'thumb 2',
			'thumb 3',
		];
		$latestPhotos = [
			'photo abc',
			'photo xyz',
		];
		$imageList = [
			'images' => $images,
		    'minTimestamp' => $time - 10000,
		];
		$request = $this->getMockBuilder( 'WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'getVal', 'getInt' ] )
			->getMock();
		$request->expects( $this->at( 0 ) )
			->method( 'getInt' )
			->with( 'count', $this->anything() )
			->will( $this->returnValue( $count ) );
		$request->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( 'to', $this->anything() )
			->will( $this->returnValue( $time ) );
		$request->expects( $this->at( 2 ) )
			->method( 'getVal' )
			->with( 'inclusive', $this->anything() )
			->will( $this->returnValue( 'true' ) ); // Inclusive

		$lightboxHelper = $this->getMockBuilder( 'LightboxHelper' )
			->disableOriginalConstructor()
			->setMethods( ['getImageList', 'getLatestPhotos'] )
			->getMock();
		$lightboxHelper->expects( $this->once() )
			->method( 'getImageList' )
			->with( $count, $time )
			->will( $this->returnValue( $imageList ) );
		$lightboxHelper->expects( $this->once() )
			->method( 'getLatestPhotos' )
			->will( $this->returnValue( $latestPhotos ) );

		$lightboxMock = $this->getMockBuilder( 'LightboxController' )
			->setMethods( ['mediaTableToThumbs', 'getLightboxHelper'] )
			->getMock();
		$lightboxMock->expects( $this->once() )
			->method( 'mediaTableToThumbs' )
			->with( array_merge( $latestPhotos, $imageList['images'] ) )
			->will( $this->returnValue( $thumbs ) );
		$lightboxMock->expects( $this->once() )
			->method( 'getLightboxHelper' )
			->will( $this->returnValue( $lightboxHelper ) );

		$lightboxMock->setRequest( $request );
		$response = new \WikiaResponse( \WikiaResponse::FORMAT_HTML );
		$lightboxMock->setResponse( $response );
		$lightboxMock->getThumbImages();

		// Inspect response object
		$this->assertEquals( $thumbs, $lightboxMock->getResponse()->getVal( 'thumbs' ) );
		$this->assertEquals( $imageList['minTimestamp'], $lightboxMock->getResponse()->getVal( 'to' ) );
	}

	public function testGetMediaDetail_titleNotFound() {
		$fileTitle = ''; // Empty title!
		$request = $this->getMockBuilder( 'WikiaRequest' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getVal' ] )
		                ->getMock();
		$request->expects( $this->at( 0 ) )
		        ->method( 'getVal' )
		        ->with( 'fileTitle', '' )
		        ->will( $this->returnValue( $fileTitle ) );
		$request->expects( $this->at( 1 ) )
		        ->method( 'getVal' )
		        ->with( 'isInline', false )
		        ->will( $this->returnValue( false ) );

		$userMock = $this->getMock( 'stdClass', [ 'isItemLoaded' ] );
		$userMock->expects( $this->any() )
		         ->method( 'isItemLoaded' )
		         ->with( $this->anything() )
		         ->will( $this->returnValue( false ) );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$lightboxController = new \LightboxController();
		$lightboxController->setRequest( $request );
		$this->assertNull( $lightboxController->getMediaDetail() );
	}

	public function testGetMediaDetail_read() {
		$fileTitle = __METHOD__ . time();
		$request = $this->getMockBuilder( 'WikiaRequest' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getVal' ] )
		                ->getMock();
		$request->expects( $this->at( 0 ) )
		        ->method( 'getVal' )
		        ->with( 'fileTitle', '' )
		        ->will( $this->returnValue( $fileTitle ) );
		$request->expects( $this->at( 1 ) )
		        ->method( 'getVal' )
		        ->with( 'isInline', false )
		        ->will( $this->returnValue( false ) );

		$userMock = $this->getMock( 'stdClass', [ 'isAllowed', 'isItemLoaded' ] );
		$userMock->expects( $this->once() )
		         ->method( 'isAllowed' )
		         ->with( 'read' )
		         ->will( $this->returnValue( false ) ); // isAllowed == false
		$userMock->expects( $this->any() )
		         ->method( 'isItemLoaded' )
		         ->with( $this->anything() )
		         ->will( $this->returnValue( false ) );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$lightboxController = new \LightboxController();
		$lightboxController->setRequest( $request );
		$this->assertNull( $lightboxController->getMediaDetail() );
	}

	public function testGetMediaDetail() {

		$fileTitle = __METHOD__ . time();
		$request = $this->getMockBuilder( 'WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'getVal' ] )
			->getMock();
		$request->expects( $this->at( 0 ) )
			->method( 'getVal' )
			->with( 'fileTitle', '' )
			->will( $this->returnValue( $fileTitle ) );
		$request->expects( $this->at( 1 ) )
			->method( 'getVal' )
			->with( 'isInline', false )
			->will( $this->returnValue( false ) );
		$request->expects( $this->at( 2 ) )
			->method( 'getVal' )
			->with( 'width', $this->anything() )
			->will( $this->returnValue( \LightboxController::CONTEXT_DEFAULT_WIDTH ) );
		$request->expects( $this->at( 3 ) )
			->method( 'getVal' )
			->with( 'height', $this->anything() )
			->will( $this->returnValue( \LightboxController::CONTEXT_DEFAULT_HEIGHT ) );
		$request->expects( $this->at( 4 ) )
			->method( 'getVal' )
			->with( 'width', $this->anything() )
			->will( $this->returnValue( \LightboxController::CONTEXT_DEFAULT_WIDTH ) );

		$userMock = $this->getMock( 'stdClass', [ 'isAnon', 'isAllowed', 'isItemLoaded', 'getOption' ] );
		$userMock->expects( $this->any() )
		     ->method( 'isAnon' )
		     ->will( $this->returnValue( false ) );
		$userMock->expects( $this->once() )
			->method( 'isAllowed' )
			->with( 'read' )
			->will( $this->returnValue( true ) );
		$userMock->expects( $this->any() )
			->method( 'isItemLoaded' )
			->with( $this->anything() )
			->will( $this->returnValue( false ) );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$width = LightboxController::CONTEXT_DEFAULT_WIDTH;
		$height = LightboxController::CONTEXT_DEFAULT_HEIGHT;
		$isInline = false;
		$config = [
			'imageMaxWidth'  => 1000,
			'contextWidth'   => $width,
			'contextHeight'  => $height,
			'userAvatarWidth'=> 16,
			'isInline'       => $isInline,
		];

		$title = \Title::newFromText( $fileTitle, NS_FILE );
		$data = \WikiaFileHelper::getMediaDetail( $title, $config );
		$articles = $data['articles'];
		list( $smallerArticleList, $articleListIsSmaller ) = \WikiaFileHelper::truncateArticleList( $articles, LightboxController::POSTED_IN_ARTICLES );

		$mediaType = $data['mediaType'];
		$videoEmbedCode = $data['videoEmbedCode'];
		$playerAsset = $data['playerAsset'];
		$imageUrl = $data['imageUrl'];
		$fileUrl = $data['fileUrl'];
		$rawImageUrl = $data['rawImageUrl'];
		$userThumbUrl = $data['userThumbUrl'];
		$userName = $data['userName'];
		$userPageUrl = $data['userPageUrl'];
		$isPostedIn = !empty( $smallerArticleList ); // Bool to tell mustache to print "posted in" section
		$providerName = $data['providerName'];
		$exists = $data['exists'];
		$isAdded = $data['isAdded'];
		$extraHeight = $data['extraHeight'];
		$format = \WikiaResponse::FORMAT_JSON;

		global $wgLang;
		$views = wfMessage( 'lightbox-video-views', $wgLang->formatNum( $data['videoViews'] ) )->parse();

		$mediaDetail = [
			'mediaType'         => $mediaType,
			'videoEmbedCode'    => $videoEmbedCode,
			'playerAsset'       => $playerAsset,
			'imageUrl'          => $imageUrl,
			'fileUrl'           => $fileUrl,
			'rawImageUrl'       => $rawImageUrl,
			'userThumbUrl'      => $userThumbUrl,
			'userName'          => $userName,
			'userPageUrl'       => $userPageUrl,
			'articles'          => $articles,
			'providerName'      => $providerName,
			'views'             => $views,
			'exists'            => $exists,
			'isAdded'           => $isAdded,
			'extraHeight'       => $extraHeight,
			'title'             => $title->getDBkey(),
			'fileTitle'         => $title->getText(),
			'isPostedIn'        => $isPostedIn,
			'smallerArticleList'=> $smallerArticleList,
			'articleListIsSmaller' => $articleListIsSmaller,
		];

		$lightboxController = new \LightboxController();
		$lightboxController->setRequest( $request );
		$response = new \WikiaResponse( $format );
		$lightboxController->setResponse( $response );
		$lightboxController->getMediaDetail();

		// Inspect response object
		foreach ( $mediaDetail as $key => $value ) {
			$this->assertEquals( $value, $lightboxController->getResponse()->getVal( $key ), "mismatch on $key" );
		}
		$this->assertEquals( $format, $lightboxController->getResponse()->getFormat() );
	}

	public function testGetShareCodes_fileNotFound() {
		$fileTitle = ''; // Empty file title
		$request = $this->getMockBuilder( 'WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'getVal' ] )
			->getMock();
		$request->expects( $this->once() )
			->method( 'getVal' )
			->with( 'fileTitle', $this->anything() )
			->will( $this->returnValue( $fileTitle ) );

		$shareUrl = '';
		$articleUrl = '';
		$fileUrl = '';
		$thumbUrl = '';
		$networks = [];
		$responseArray = [
			'shareUrl' => $shareUrl,
			'articleUrl' => $articleUrl,
			'fileUrl' => $fileUrl,
			'networks' => $networks,
			'fileTitle' => $fileTitle,
			'imageUrl' => $thumbUrl,
		];

		$format = \WikiaResponse::FORMAT_HTML;
		$lightboxController = new \LightboxController();
		$lightboxController->setRequest( $request );
		$response = new \WikiaResponse( $format );
		$lightboxController->setResponse( $response );
		$lightboxController->getShareCodes();

		// Inspect response object
		foreach ( $responseArray as $key => $value ) {
			$this->assertEquals( $value, $lightboxController->getResponse()->getVal( $key ), "mismatch on $key" );
		}
	}

}
