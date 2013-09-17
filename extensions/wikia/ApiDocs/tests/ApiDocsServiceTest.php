<?php

namespace Wikia\ApiDocs\Services;


class ApiDocsServiceTest extends \WikiaBaseTest {

	public function testGetDocList() {
		$swaggerMock = $this->getMockBuilder( '\Swagger\Swagger' )
			->disableOriginalConstructor()->getMock();

		$swaggerMock->expects( $this->once() )
			->method( "getDefaultApiVersion" )
			->will( $this->returnValue("vfoo") );

		$swaggerMock->expects( $this->once() )
			->method( "getDefaultSwaggerVersion" )
			->will( $this->returnValue("sversion") );

		$swaggerMock->expects( $this->once() )
			->method( "getRegistry" )
			->will( $this->returnValue("sversion") );

		$apiDocsService = new ApiDocsService( $swaggerMock, function($foo) { return "path_for_$foo"; } );
		$apiDocsService->getDocList();
	}
}
