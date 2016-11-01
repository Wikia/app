<?php

namespace Wikia\Helios;

use DI\Container;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\Service\Helios\ClientException;
use Wikia\Service\Helios\HeliosClient;

class UserTest extends \WikiaBaseTest {

	private $webRequestMock;

	/** @var Container */
	private $container;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../Helios.setup.php';
		parent::setUp();
		$this->webRequestMock = $this->getMock( '\WebRequest', [ 'getHeader', 'getCookie' ], [ ], '', false );
		User::purgeAuthenticationCache();

		$this->container = ( new InjectorBuilder() )
			->bind( HeliosClient::class )->to( function () {
				return
					$this->getMock( 'Wikia\Service\Helios\HeliosClient',
						[ ],
						[ ],
						'',
						false );
			} )->build();

		$this->mockStaticMethod( '\Wikia\Helios\User', 'getHeliosClient', $this->container->get( HeliosClient::class ) );


	}

	public function testAuthenticateAuthenticationFailed() {
		$username = 'SomeName';
		$password = 'Password';

		$client = $this->container->get( HeliosClient::class );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( [\WikiaResponse::RESPONSE_CODE_OK, new \StdClass] );
		$this->mockClass( 'Wikia\Service\Helios\HeliosClient', $client );

		$this->assertFalse( User::authenticate( $username, $password ) );
	}

	public function testAuthenticateAuthenticationImpossible() {
		$this->setExpectedException( 'Wikia\Service\Helios\ClientException', 'test' );
		$username = 'SomeName';
		$password = 'Password';

		$client = $this->container->get( HeliosClient::class );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->will( $this->throwException( new ClientException( 'test' ) ) );
		$this->mockClass( 'Wikia\Helios\Client', $client );

		User::authenticate( $username, $password );
	}

	public function testAuthenticateAuthenticationSucceded() {
		$username = 'SomeName';
		$password = 'Password';

		$loginInfo = new \StdClass;
		$loginInfo->access_token = 'orvb9pM6wX';

		$client = $this->container->get( HeliosClient::class );
		$client->expects( $this->once() )
			->method( 'login' )
			->with( $username, $password )
			->willReturn( [\WikiaResponse::RESPONSE_CODE_OK, $loginInfo] );
		$this->mockClass( 'Wikia\Service\Helios\HeliosClient', $client );

		$this->assertTrue( User::authenticate( $username, $password ) );
	}

}
