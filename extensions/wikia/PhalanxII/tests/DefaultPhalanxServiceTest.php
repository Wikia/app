<?php

use PHPUnit\Framework\TestCase;

class DefaultPhalanxServiceTest extends TestCase {
	const REGEX = 'test regex';

	/** @var PhalanxHttpClient|PHPUnit_Framework_MockObject_MockObject $phalanxHttpClientMock */
	private $phalanxHttpClientMock;

	/** @var PhalanxMatchParams $phalanxParams */
	private $phalanxParams;

	/** @var DefaultPhalanxService $defaultPhalanxService */
	private $defaultPhalanxService;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Phalanx_setup.php';

		$this->phalanxParams = new PhalanxMatchParams();

		$this->phalanxHttpClientMock = $this->createMock( PhalanxHttpClient::class );
		$this->defaultPhalanxService =
			new DefaultPhalanxService( $this->phalanxHttpClientMock );
	}

	public function testThrowsExceptionWhenMatchRequestFails() {
		$this->expectException( PhalanxServiceException::class );

		$this->phalanxHttpClientMock->expects( $this->any() )
			->method( 'matchRequest' )
			->with( $this->phalanxParams )
			->willReturn( false );

		$this->defaultPhalanxService->doMatch( $this->phalanxParams );
	}

	public function testNoBlocksFound() {
		$this->phalanxHttpClientMock->expects( $this->any() )
			->method( 'matchRequest' )
			->with( $this->phalanxParams )
			->willReturn( '[]' );

		$phalanxBlocks = $this->defaultPhalanxService->doMatch( $this->phalanxParams );

		$this->assertEmpty( $phalanxBlocks );
	}

	public function testWhenBlocksFoundTheyAreParsedCorrectly() {
		$jsonFixture = file_get_contents( __DIR__ . '/fixtures/phalanx-blocks-response.json' );
		$jsonArray = json_decode( $jsonFixture, true );

		$this->phalanxHttpClientMock->expects( $this->any() )
			->method( 'matchRequest' )
			->with( $this->phalanxParams )
			->willReturn( $jsonFixture );

		$phalanxBlocks = $this->defaultPhalanxService->doMatch( $this->phalanxParams );

		$expectedPhalanxBlocks = array_map( [ PhalanxBlockInfo::class, 'newFromJsonObject' ], $jsonArray );
		$this->assertEquals( $expectedPhalanxBlocks, $phalanxBlocks );
	}

	public function testThrowsExceptionWhenValidateRequestFails() {
		$this->expectException( PhalanxServiceException::class );

		$this->phalanxHttpClientMock->expects( $this->any() )
			->method( 'regexValidationRequest' )
			->with( static::REGEX )
			->willReturn( false );

		$this->defaultPhalanxService->doRegexValidation( static::REGEX );
	}

	public function testThrowsExceptionWhenRegexIsNotValid() {
		$this->expectException( RegexValidationException::class );

		$this->phalanxHttpClientMock->expects( $this->any() )
			->method( 'regexValidationRequest' )
			->with( static::REGEX )
			->willReturn( 'error' );

		$this->defaultPhalanxService->doRegexValidation( static::REGEX );
	}

	public function testReturnsTrueWhenRegexIsValid() {
		$this->phalanxHttpClientMock->expects( $this->any() )
			->method( 'regexValidationRequest' )
			->with( static::REGEX )
			->willReturn( DefaultPhalanxService::REGEX_VALID_RESPONSE );

		$this->assertTrue( $this->defaultPhalanxService->doRegexValidation( static::REGEX ) );
	}
}
