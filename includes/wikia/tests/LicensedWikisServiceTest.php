<?php
class LicensedWikisServiceTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../services/LicensedWikisService.class.php';
		parent::setUp();
	}

	public function testIsCommercialUseAllowedById() {

		$licensedWikisService = $this->getMock('LicensedWikisService', ['getCommercialUseNotAllowedWikis']);

		$licensedWikisService->expects( $this->exactly(2) )
							 ->method('getCommercialUseNotAllowedWikis')
							 ->will( $this->returnValue( [ 1 => [	"id"=>1,
																	"url"=>"foo-url",
																	"host"=>"foo-host",
																	"db"=>"foo-db" ] ] )
							 );


		$this->assertEquals( false, $licensedWikisService->isCommercialUseAllowedById( 1 ) );
		$this->assertEquals( true, $licensedWikisService->isCommercialUseAllowedById( 2 ) );
	}

	public function testIsCommercialUseAllowedByHostName() {

		$licensedWikisService = $this->getMock('LicensedWikisService', ['getCommercialUseNotAllowedWikis']);

		$licensedWikisService->expects( $this->exactly(2) )
			->method('getCommercialUseNotAllowedWikis')
			->will( $this->returnValue( [ 1 => [	"id"=>1,
													"url"=>"foo-url",
													"host"=>"foo-host",
													"db"=>"foo-db" ] ] )
			);


		$this->assertEquals( false, $licensedWikisService->isCommercialUseAllowedByHostName( "foo-host" ) );
		$this->assertEquals( true, $licensedWikisService->isCommercialUseAllowedByHostName( "bar-host" ) );
	}

}