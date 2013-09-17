<?php

namespace Wikia\ApiDocs\Services;


class ApiDocsServiceTest extends \WikiaBaseTest {
	protected function setUp() {
		global $IP;
		$this->setupFile = "{$IP}/extensions/wikia/ApiDocs/ApiDocs.setup.php";

		parent::setUp();
	}

	public function testGetDocList() {
		$swaggerMock = $this->getMockBuilder( '\Swagger\Swagger' )
			->disableOriginalConstructor()->getMock();

		$swaggerMock->expects( $this->once() )
			->method( "getDefaultApiVersion" )
			->will( $this->returnValue("bar_version") );

		$swaggerMock->expects( $this->once() )
			->method( "getDefaultSwaggerVersion" )
			->will( $this->returnValue("foo_version") );

		$api = new \StdClass();
		$api->description = "bar";
		$resource = new \StdClass();
		$resource->resourcePath = "baz";
		$resource->apis = [ $api ];

		$swaggerMock->expects( $this->once() )
			->method( "getRegistry" )
			->will( $this->returnValue([ $resource ]) );

		$apiDocsService = new ApiDocsService( $swaggerMock, function($foo) { return "path_for_$foo"; } );
		$result = $apiDocsService->getDocList();

		$this->assertEquals( "bar_version", $result["apiVersion"] );
		$this->assertEquals( "foo_version", $result["swaggerVersion"] );
		$this->assertEquals( 1 , sizeof( $result["apis"] ) );
		$this->assertEquals( "bar" , $result["apis"][0]["description"] );
		$this->assertEquals( "baz" , $result["apis"][0]["readableName"] );
		$this->assertEquals( "path_for_baz" , $result["apis"][0]["path"] );
	}

	public function testGetDoc() {
		$swaggerMock = $this->getMockBuilder( '\Swagger\Swagger' )
			->disableOriginalConstructor()->getMock();

		$swaggerMock->expects( $this->once() )
			->method( "getResource" )
			->with( "foo", false, false )
			->will( $this->returnValue( [ "basePath" => "foo" ] ) );

		$apiDocsService = new ApiDocsService( $swaggerMock, function($foo) {  } );

		$result = $apiDocsService->getDoc( "foo" );

		$this->assertEquals( [ "basePath" => "foo" ], $result );
	}
}
