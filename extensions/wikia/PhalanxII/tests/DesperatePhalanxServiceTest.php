<?php

use PHPUnit\Framework\TestCase;

class DesperatePhalanxServiceTest extends TestCase {
	const REGEX = 'test regex';

	/** @var PhalanxService|PHPUnit_Framework_MockObject_MockObject $phalanxServiceMock */
	private $phalanxServiceMock;

	/** @var PhalanxMatchParams $phalanxParams */
	private $phalanxParams;

	/** @var DesperatePhalanxService $desperatePhalanxService */
	private $desperatePhalanxService;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../Phalanx_setup.php';

		$this->phalanxServiceMock = $this->getMockForAbstractClass( PhalanxService::class );
		$this->phalanxParams = new PhalanxMatchParams();

		$this->desperatePhalanxService = new DesperatePhalanxService( $this->phalanxServiceMock );
	}

	public function testWillRetryMatchGivenTimesIfRequestsFailBeforeThrowingException() {
		$this->expectException( PhalanxServiceException::class );

		$this->phalanxServiceMock->expects( $this->exactly( DesperatePhalanxService::RETRY_COUNT ) )
			->method( 'doMatch' )
			->with( $this->phalanxParams )
			->willThrowException( new PhalanxServiceException() );

		$this->desperatePhalanxService->doMatch( $this->phalanxParams );
	}

	public function testStopsRetryingWhenMatchRequestSucceeds() {
		$this->phalanxServiceMock->expects( $this->at( 0 ) )
			->method( 'doMatch' )
			->with( $this->phalanxParams )
			->willThrowException( new PhalanxServiceException() );

		$this->phalanxServiceMock->expects( $this->at( 1 ) )
			->method( 'doMatch' )
			->with( $this->phalanxParams )
			->willReturn( [ new PhalanxBlockInfo() ] );

		$this->assertCount( 1, $this->desperatePhalanxService->doMatch( $this->phalanxParams ) );
	}


	public function testWillRetryRegexValidationGivenTimesIfRequestsFailBeforeThrowingException() {
		$this->expectException( PhalanxServiceException::class );

		$this->phalanxServiceMock->expects( $this->exactly( DesperatePhalanxService::RETRY_COUNT ) )
			->method( 'doRegexValidation' )
			->with( static::REGEX )
			->willThrowException( new PhalanxServiceException() );

		$this->desperatePhalanxService->doRegexValidation( static::REGEX );
	}

	public function testStopsRetryingWhenRegexValidationRequestSucceeds() {
		$this->phalanxServiceMock->expects( $this->at( 0 ) )
			->method( 'doRegexValidation' )
			->with( static::REGEX  )
			->willThrowException( new PhalanxServiceException() );

		$this->phalanxServiceMock->expects( $this->at( 1 ) )
			->method( 'doRegexValidation' )
			->with( static::REGEX  )
			->willReturn( true );

		$this->assertTrue( $this->desperatePhalanxService->doRegexValidation( static::REGEX ) );
	}

	public function testStopsRetryingWhenRegexValidationRequestCompletesWithValidationFailure() {
		$this->expectException( RegexValidationException::class );

		$this->phalanxServiceMock->expects( $this->at( 0 ) )
			->method( 'doRegexValidation' )
			->with( static::REGEX  )
			->willThrowException( new PhalanxServiceException() );

		$this->phalanxServiceMock->expects( $this->at( 1 ) )
			->method( 'doRegexValidation' )
			->with( static::REGEX  )
			->willThrowException( new RegexValidationException() );

		$this->desperatePhalanxService->doRegexValidation( static::REGEX );
	}
}
