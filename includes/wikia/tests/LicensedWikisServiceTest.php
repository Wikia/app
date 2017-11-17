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

	public function testIsCommercialUseAllowedForThisWiki() {

		$licensedWikisService = $this->getMock('LicensedWikisService', ['getCommercialUseNotAllowedWikis']);
		$this->mockGlobalVariable('wgCityId', 159);

		$licensedWikisService->expects( $this->once() )
			->method('getCommercialUseNotAllowedWikis')
			->will( $this->returnValue( [ 159 => [	"id"=>159,
					"url"=>"foo-url",
					"host"=>"foo-host",
					"db"=>"foo-db" ] ] )
			);

		$this->assertEquals( false, $licensedWikisService->isCommercialUseAllowedForThisWiki() );
	}

	public function wfDataProvider() {
		return [
			[ 159, "http://foo-url.com/", "foo title", "foodbname", "foo-url.com" ],
			[ 180, "http://foo-url.com", "foo title2", "foodbd", "foo-url.com" ],
		];
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.02678 ms
	 * @dataProvider wfDataProvider
	 */
	public function testGetWikisWithVar( $wikiId, $url, $wikiTitle, $dbName, $host) {

		$licensedWikisService = $this->getMock('LicensedWikisService', ['getCommercialUseNotAllowedWikis']);

		$this->mockStaticMethod( 'WikiFactory', 'getListOfWikisWithVar', array( $wikiId =>
																				array( 'u'=> $url,
																						"t" => $wikiTitle,
																						"d" => $dbName ) ) );
		$class = new ReflectionClass('LicensedWikisService');
		$method = $class->getMethod('getWikisWithVar');
		$method->setAccessible(true);
		$result = $method->invoke( $licensedWikisService );

		$this->assertEquals( $wikiId, $result[ $wikiId ]['id'] );
		$this->assertEquals( $host, $result[ $wikiId ]['host'] );
		$this->assertEquals( $url, $result[ $wikiId ]['url'] );
		$this->assertEquals( $dbName, $result[ $wikiId ]['db'] );
		$this->assertNotEquals( $wikiId, $result[ $wikiId ]['id']*2 );
	}

}
