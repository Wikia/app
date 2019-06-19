<?php
namespace Wikia\Gateway;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UserAttributeGatewayTest extends TestCase {

	/** @var array $requestLog */
	private $requestLog;

	protected function setUp() {
		parent::setUp();
		$this->requestLog = [];
	}

	public function testShouldReturnAllAttributesOnSuccessForMultipleUsers() {
		$gateway = $this->createGateway(
			new Response( 200, [], file_get_contents( __DIR__ . '/fixtures/uas_multiple_success.json' ) )
		);

		$usersWithAttributes = $gateway->getAllAttributesForMultipleUsers( [ 5, 10 ] );

		$this->assertEquals( 'Béla király', $usersWithAttributes['users'][10]['nickname'] );

		$this->assertCount( 1, $this->requestLog, 'Expected to send a single request' );

		foreach ( $this->requestLog as $info ) {
			/** @var RequestInterface $request */
			$request = $info['request'];

			$this->assertEquals( '/user/bulk', $request->getUri()->getPath() );
			$this->assertEquals( 'id=5&id=10', $request->getUri()->getQuery() );
		}
	}

	public function testShouldReturnEmptyInfoOnClientError() {
		$gateway = $this->createGateway(
			new Response( 400, [], file_get_contents( __DIR__ . '/fixtures/uas_multiple_bad_request.json' ) )
		);

		$usersWithAttributes = $gateway->getAllAttributesForMultipleUsers( [ 5, 10 ] );

		$this->assertEmpty( $usersWithAttributes );
	}

	public function testShouldReturnEmptyInfoOnServerError() {
		$gateway = $this->createGateway(
			new Response( 500, [], file_get_contents( __DIR__ . '/fixtures/uas_multiple_server_error.json' ) )
		);

		$usersWithAttributes = $gateway->getAllAttributesForMultipleUsers( [ 5, 10 ] );

		$this->assertEmpty( $usersWithAttributes );
	}

	private function createGateway( ResponseInterface $response ): UserAttributeGateway {
		$history = Middleware::history( $this->requestLog );

		$handler = new MockHandler( [ $response ] );
		$stack = HandlerStack::create( $handler );
		$stack->push( $history );

		$client =  new Client( [ 'handler' => $stack ] );

		return new UserAttributeGateway( 'http://user-attribute', $client );
	}
}
