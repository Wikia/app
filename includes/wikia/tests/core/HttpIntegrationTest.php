<?php

use Mcustiel\Phiremock\Client\Phiremock;
use Wikia\Service\Gateway\StaticUrlProvider;
use Wikia\Service\Gateway\UrlProvider;

trait HttpIntegrationTest {
	/** @var Phiremock $phireMock */
	private $phireMock;

	protected final function getMockServer(): Phiremock {
		if ( $this->phireMock === null ) {
			$this->phireMock = new Phiremock( $this->getMockServerHost(), $this->getMockServerPort() );
		}

		return $this->phireMock;
	}

	protected final function getMockUrlProvider(): UrlProvider {
		return new StaticUrlProvider( $this->getMockUrl() ) ;
	}

	protected final function getMockUrl(): string {
		return "{$this->getMockServerHost()}:{$this->getMockServerPort()}";
	}

	protected final function getMockServerHost(): string {
		return getenv( 'PHIREMOCK_HOST' );
	}

	protected final function getMockServerPort(): int {
		return (int) getenv( 'PHIREMOCK_PORT' );
	}
}
