<?php

class WikiaApiControllerTest extends \WikiaBaseTest {

	/**
	 * @covers WikiaApiController::setResponseData
	 * @dataProvider setResponse_Provider
	 */
	public function testSetResponseData( $data, $fields, $expected, $refValue, $serveImages, $cacheValid = 0 ) {
		$mock = $this->getMockBuilder( 'WikiaApiController' )
			->disableOriginalConstructor()
			->setMethods( [ 'serveImages', 'getRequest', 'getResponse' ] )
			->getMock();
		$mock->expects( $this->any() )
			->method( 'serveImages' )
			->will( $this->returnValue( $serveImages ) );

		$mockResponse = $this->getMockBuilder( 'StdClass' )
			->setMethods( [ 'setData', 'setCacheValidity' ] )
			->getMock();

		$mockResponse->expects( $this->once() )
			->method( 'setData' )
			->with( $expected );

		if ( $cacheValid > 0 ) {
			$mockResponse->expects( $this->once() )
				->method( 'setCacheValidity' )
				->with( $cacheValid );
		}

		$mockResponse->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( null ) );

		$mockRequest = $this->getMockBuilder( 'StdClass' )
			->setMethods( [ 'getVal' ] )
			->getMock();

		if ( $refValue ) {
			$mockRequest->expects( $this->any() )
				->method( 'getVal' )
				->with( WikiaApiController::REF_URL_ARGUMENT )
				->will( $this->returnValue( $refValue ) );
		} else {
			$mockRequest->expects( $this->any() )
				->method( 'getVal' )
				->with( WikiaApiController::REF_URL_ARGUMENT )
				->will( $this->returnValue( null ) );
		}

		$mockRequest->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( null ) );

		$mock->expects( $this->any() )
			->method( 'getResponse' )
			->will( $this->returnValue( $mockResponse ) );

		$mock->expects( $this->any() )
			->method( 'getRequest' )
			->will( $this->returnValue( $mockRequest ) );

		$method = new ReflectionMethod( $mock, 'setResponseData' );
		$method->setAccessible( true );

		$method->invoke( $mock, $data, $fields, $cacheValid );
	}

	public function setResponse_Provider() {
		return [
			[
				[ "items" => [ [ 'title' => 't0', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't0', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				null,
				true,
				12334
			],
			[
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				null,
				true
			],
			[
				[ "items" => [ [ 'title' => 't2', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't2', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				null,
				true
			],
			//now call it like ....?ref=noideawhat
			[
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't1', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				'noideawhat',
				true
			],
			[
				[ "items" => [ [ 'title' => 't3', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't3', 'url' => 'http://a2.a?ref=noideawhat', 'img' => 'www.img2.a/a.png?ref=noideawhat' ] ] ],
				'noideawhat',
				true
			],
			[
				[ "items" => [ [ 'title' => 't4', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png?par=val' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't4', 'url' => 'http://a2.a?ref=noideawhat', 'img' => 'www.img2.a/a.png?par=val&ref=noideawhat' ] ] ],
				'noideawhat',
				true
			],
			[
				[ "items" => [ [ 'title' => 't5', 'url' => [ 'http://a2.a' ], 'img' => 'www.img2.a/a.png?par=val' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't5', 'url' => [ 'http://a2.a?ref=noideawhat' ], 'img' => 'www.img2.a/a.png?par=val&ref=noideawhat' ] ] ],
				'noideawhat',
				true
			],
			//now call it like ....?ref=noideawhat AND disable images
			[
				[ "items" => [ [ 'title' => 't6', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				[ ],
				[ "items" => [ [ 'title' => 't6', 'url' => 'http://a1.a', 'img' => 'www.img1.a/a.png' ] ] ],
				'noideawhat',
				false
			],
			[
				[ "items" => [ [ 'title' => 't8', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't8', 'url' => 'http://a2.a?ref=noideawhat', 'img' => null ] ] ],
				'noideawhat',
				false
			],
			[
				[ "items" => [ [ 'title' => 't9', 'url' => 'http://a2.a', 'img' => 'www.img2.a/a.png?par=val' ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't9', 'url' => 'http://a2.a?ref=noideawhat', 'img' => null ] ] ],
				'noideawhat',
				false
			],
			[
				[ "items" => [ [ 'title' => 't10', 'url' => 'http://a2.a', 'img' => [ 'www.img2.a/a.png?par=val' ] ] ] ],
				[ 'imgFields' => 'img', 'urlFields' => [ 'img', 'url' ] ],
				[ "items" => [ [ 'title' => 't10', 'url' => 'http://a2.a?ref=noideawhat', 'img' => [ ] ] ] ],
				'noideawhat',
				false
			],
		];
	}

}
