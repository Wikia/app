<?php

use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use PHPUnit\Framework\TestCase;

/**
 * @group Integration
 */
class DefaultPhalanxServiceIntegrationTest extends TestCase {
	use HttpIntegrationTest;

	const REGEX = 'test';

	/** @var PhalanxMatchParams $phalanxParams */
	private $phalanxParams;

	/** @var DefaultPhalanxService $defaultPhalanxService */
	private $defaultPhalanxService;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Phalanx_setup.php';

		$this->phalanxParams = new PhalanxMatchParams();
		$this->defaultPhalanxService = new DefaultPhalanxService( $this->getMockUrlProvider() );
	}

	public function testThrowsExceptionWhenMatchRequestFails() {
		$this->expectException( PhalanxServiceException::class );

		$exp = Phiremock::on( A::postRequest()
			->andUrl( Is::equalTo( "/match" ) ) )
			->thenRespond( 500, '' );

		$this->getMockServer()->createExpectation( $exp );

		$this->defaultPhalanxService->doMatch( $this->phalanxParams );
	}

	public function testNoBlocksFound() {
		$exp = Phiremock::on( A::postRequest()
			->andUrl( Is::equalTo( "/match" ) ) )
			->thenRespond( 200, '[]' );

		$this->getMockServer()->createExpectation( $exp );

		$phalanxBlocks = $this->defaultPhalanxService->doMatch( $this->phalanxParams );

		$this->assertEmpty( $phalanxBlocks );
	}

	public function testWhenBlocksFoundTheyAreParsedCorrectly() {
		$jsonFixture = file_get_contents( __DIR__ . '/fixtures/phalanx-blocks-response.json' );

		$exp = Phiremock::on( A::postRequest()
			->andUrl( Is::equalTo( "/match" ) ) )
			->thenRespond( 200, $jsonFixture );

		$this->getMockServer()->createExpectation( $exp );

		$phalanxBlocks = $this->defaultPhalanxService->doMatch( $this->phalanxParams );

		$expectedPhalanxBlocks = array_map( [ PhalanxBlockInfo::class, 'newFromJsonObject' ], json_decode( $jsonFixture, true ) );
		$this->assertEquals( $expectedPhalanxBlocks, $phalanxBlocks );
	}

	public function testThrowsExceptionWhenValidateRequestFails() {
		$this->expectException( PhalanxServiceException::class );

		$exp = Phiremock::on( A::postRequest()
			->andUrl( Is::equalTo( "/validate" ) )
			->andBody( Is::containing( static::REGEX ) ) )
			->thenRespond( 500, '' );

		$this->getMockServer()->createExpectation( $exp );

		$this->defaultPhalanxService->doRegexValidation( static::REGEX );
	}

	public function testThrowsExceptionWhenRegexIsNotValid() {
		$this->expectException( RegexValidationException::class );

		$exp = Phiremock::on( A::postRequest()
			->andUrl( Is::equalTo( "/validate" ) )
			->andBody( Is::containing( static::REGEX ) ) )
			->thenRespond( 200, 'error' );

		$this->getMockServer()->createExpectation( $exp );

		$this->defaultPhalanxService->doRegexValidation( static::REGEX );
	}

	public function testReturnsTrueWhenRegexIsValid() {
		$exp = Phiremock::on( A::postRequest()
			->andUrl( Is::equalTo( "/validate" ) )
			->andBody( Is::containing( static::REGEX ) ) )
			->thenRespond( 200, 'ok' );

		$this->getMockServer()->createExpectation( $exp );

		$this->assertTrue( $this->defaultPhalanxService->doRegexValidation( static::REGEX ) );
	}

	protected function tearDown() {
		parent::tearDown();

		$this->getMockServer()->clearExpectations();
	}
}
