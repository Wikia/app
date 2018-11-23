<?php

use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use PHPUnit\Framework\TestCase;

/**
 * @group Integration
 */
class ExternalStoreDBFetchBlobHookIntegrationTest extends TestCase {

	use MockGlobalVariableTrait;
	use HttpIntegrationTest;

	protected function setUp() {
		parent::setUp();

		$mockApiURL = "http://{$this->getMockServerHost()}:{$this->getMockServerPort()}/";
		$this->mockGlobalVariable( "wgFetchBlobApiURL", $mockApiURL );
		$this->mockGlobalVariable( 'wgDefaultExternalStore', [] );
	}

	public function testApiCall() {
		$result = false;
		$expectedHash = "9b641ed905873173824b200886bb8552";

		$theRequest = A::getRequest()->andUrl( Is::equalTo( '/?action=fetchblob&store=blobs&id=34&token=test&format=json') );
		$theResponse = json_encode( [ 'fetchblob' => [ 'blob' => 'abd', 'hash' => $expectedHash ] ] );

		$this->getMockServer()->createExpectation( Phiremock::on( $theRequest )->thenRespond( 200, $theResponse ) );

		ExternalStoreDBFetchBlobHook( "blobs", 34, null, $result );
		$resultHash = md5( $result );

		$this->assertEquals( $expectedHash, $resultHash );
	}
}
