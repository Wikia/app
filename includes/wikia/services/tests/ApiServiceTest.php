<?php


class ApiAccessServiceTest extends \WikiaBaseTest {

	public function testCall() {

		$mockResults = array("key", "value");
		$apiMock = $this->mockClassWithMethods("ApiMain", array ('execute' => null, 'getResultData' => $mockResults));

		$result = ApiService::call(array());
		$this->assertEquals($result, $mockResults);
	}

	public function testForeignCall() {

		# used by private method ApiService::getHostByDbName
		$this->mockStaticMethod("WikiFactory", 'DBtoID', "1");
		$this->mockStaticMethod("WikiFactory", 'getVarValueByName', "foo.wikia.com");

		$fakeJson = '{"a": "b"}'; // some non-null json formatted data
		$httpMock = $this->mockStaticMethod("Http", 'get', $fakeJson);

		$result = ApiService::foreignCall("foo", array());
		$this->assertEquals($result, json_decode($fakeJson, true));
	}

	public function testLoginAsUser() {

		# 2 methods and 1 var used by private method ApiService::getHostByDbName, not directly mockable
		$this->mockStaticMethod("WikiFactory", 'DBtoID', "1");
		$this->mockStaticMethod("WikiFactory", 'getVarValueByName', "foo.wikia.com");
		#turn off special case url building inside getHostByDbName
		$this->mockGlobalVariable("wgDevelEnvironment", false);

		# user data doesn't matter, just make sure loginAsJson is called and the data is passed along to Http::get
		$fakeUserData = array("curlOptions" => "COOKIE_STUFF");
		$this->mockStaticMethod("ApiService", "loginAsUser", $fakeUserData );

		$fakeJson = '{"a": "b"}'; // any non-null json formatted data
		$fakeUrl = "foo.wikia.com/wikia.php?format=json";  // with our fake data, this is the fake url the code builds
		$mockHttp = $this->getStaticMethodMock( 'Http', 'get' );
		$mockHttp->expects( $this->once() )
				->method('get')
				->with($fakeUrl, 'default', $fakeUserData )
				->will($this->returnValue($fakeJson));

		// test that calling with setUser==true calls loginAsUser and passes the returned data to Http::get as $options
		$result = ApiService::foreignCall("foo", array(), "wikia.php", true);
		$this->assertEquals($result, json_decode($fakeJson, true));
	}
 }