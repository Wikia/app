<?php

class LightboxControllerTest extends WikiaBaseTest {

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

		$userMock = $this->getMock( 'stdClass', [ 'isAnon', 'isAllowed', 'isItemLoaded', 'getOption', 'getStubThreshold' ] );
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
		$userMock->expects( $this->any() )
			->method( 'getStubThreshold' )
			->will( $this->returnValue( 0 ) );
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
		$format = 'json';

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

}