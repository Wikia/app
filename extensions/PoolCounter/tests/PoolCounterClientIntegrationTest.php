<?php

use PHPUnit\Framework\TestCase;

/**
 * @group Integration
 * @requires extension pcntl
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PoolCounterClientIntegrationTest extends TestCase {

	use MockGlobalVariableTrait;

	/** @var int $pid */
	private $pid;

	protected function setUp() {
		parent::setUp();
		$this->mockGlobalVariable( 'wgPoolCountClientConf', [ 'servers' => [ 'localhost:7531' ] ] );
	}

	/**
	 * @dataProvider serverStatusProvider
	 * @param string $poolCounterResponse
	 * @param int $expectedClientResult
	 */
	public function testShouldCorrectlyMapServerStatus( string $poolCounterResponse, int $expectedClientResult ) {
		$this->pid = $this->createServer( [ $poolCounterResponse ] );

		$client = $this->createClient();
		$status = $client->acquireForAnyone();

		$this->assertStatusOk( $expectedClientResult, $status );
	}

	public function serverStatusProvider() {
		yield 'server status: locked' => [ 'LOCKED', PoolCounter::LOCKED ];
		yield 'server status: lock held' => [ 'LOCK_HELD', PoolCounter::LOCK_HELD ];
		yield 'server status: done' => [ 'DONE', PoolCounter::DONE ];
		yield 'server status: not locked' => [ 'NOT_LOCKED', PoolCounter::NOT_LOCKED ];
		yield 'server status: queue full' => [ 'QUEUE_FULL', PoolCounter::QUEUE_FULL ];
		yield 'server status: timeout' => [ 'TIMEOUT', PoolCounter::TIMEOUT ];
	}

	public function testShouldSetErrorStatusIfServerReturnsError() {
		$this->pid = $this->createServer( [ 'ERROR WAIT_FOR_RESPONSE' ] );

		$client = $this->createClient();
		$status = $client->acquireForAnyone();

		$this->assertStatusError( 'poolcounter-remote-error', $status );
	}

	public function testCannotAcquireNewLockWhenAlreadyHoldingOne() {
		$this->pid = $this->createServer( [ 'LOCKED', 'LOCKED' ] );

		$client = $this->createClient();
		$status = $client->acquireForAnyone();

		$this->assertStatusOk( PoolCounter::LOCKED, $status );

		$status = $client->acquireForMe();

		$this->assertStatusError( 'poolcounter-usage-error', $status );
	}

	public function testCanAcquireNewLockAfterAcquiringAndReleasingOne() {
		$this->pid = $this->createServer( [ 'LOCKED', 'RELEASED', 'LOCKED' ] );

		$client = $this->createClient();
		$status = $client->acquireForAnyone();

		$this->assertStatusOk( PoolCounter::LOCKED, $status );

		$status = $client->release();

		$this->assertStatusOk( PoolCounter::RELEASED, $status );

		$status = $client->acquireForMe();

		$this->assertStatusOk( PoolCounter::LOCKED, $status );
	}

	private function assertStatusOk( int $expectedStatusValue, Status $status ) {
		$this->assertTrue( $status->isOK(), 'Status should be OK' );
		$this->assertEquals( $expectedStatusValue, $status->value, "Status value should be set to: $expectedStatusValue" );
	}

	private function assertStatusError( string $expectedErrorMessage, Status $status ) {
		$this->assertFalse( $status->isOK(), 'Status should not be OK' );
		$this->assertTrue( $status->hasMessage( $expectedErrorMessage ), "Status should have error message: '$expectedErrorMessage''" );
	}

	private function createServer( array $responses ): int {
		$pid = pcntl_fork();

		if ( $pid === 0 ) {
			$socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );

			socket_set_option( $socket, SOL_SOCKET, SO_REUSEADDR, 1 );
			socket_bind( $socket, 'localhost', 7531 );
			socket_listen( $socket );

			while ( true ) {
				$connection = socket_accept( $socket );

				if ( !$connection ) {
					continue;
				}

				do {
					$command = socket_read( $connection, 1024 );
					if ( $command ) {
						$poolCounterResponse = array_shift( $responses ) ?? 'ERROR BAD_COMMAND';
						socket_send( $connection, "$poolCounterResponse\n", strlen( $poolCounterResponse ) + 1, MSG_EOF );
					} else {
						socket_close( $connection );
						break;
					}
				} while ( true );
			}
		} else {
			return $pid;
		}
	}

	private function createClient(): PoolCounter {
		return new PoolCounter_Client( [ 'workers' => 2, 'maxqueue' => 4, 'timeout' => 1 ], null, 'test' );
	}

	protected function tearDown() {
		parent::tearDown();
		posix_kill( $this->pid, SIGTERM );
	}
}
