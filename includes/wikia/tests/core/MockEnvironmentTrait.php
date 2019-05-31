<?php

trait MockEnvironmentTrait {

	protected function mockPreviewEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PREVIEW );
		$this->mockGlobalVariable( 'wgEnvironmentDomainMappings', [
			'preview.wikia.com' => 'wikia.com',
			'preview.fandom.com' => 'fandom.com',
			'preview.wikia.org' => 'wikia.org',
		] );
	}

	protected function mockVerifyEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_VERIFY );
		$this->mockGlobalVariable( 'wgEnvironmentDomainMappings', [
			'verify.wikia.com' => 'wikia.com',
			'verify.fandom.com' => 'fandom.com',
			'verify.wikia.org' => 'wikia.org',
		] );
	}

	protected function mockSandboxEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_SANDBOX );
		$this->mockGlobalVariable( 'wgEnvironmentDomainMappings', [
			'sandbox-s1.wikia.com' => 'wikia.com',
			'sandbox-s1.fandom.com' => 'fandom.com',
			'sandbox-s1.wikia.org' => 'wikia.org',
		] );
	}

	protected function mockProdEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironment', false );
		$this->mockGlobalVariable( 'wgWikiaBaseDomain', 'wikia.com' );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );
	}

	protected function mockDevEnv() {
		$this->mockGlobalVariable( 'wgDevelEnvironmentName', self::MOCK_DEV_NAME );
		$this->mockGlobalVariable( 'wgDevDomain', self::MOCK_DEV_NAME . '.wikia-dev.us' );
		$this->mockGlobalVariable( 'wgEnvironmentDomainMappings', [
			self::MOCK_DEV_NAME . '.wikia-dev.us' => 'wikia.com',
			self::MOCK_DEV_NAME . '.fandom-dev.us' => 'fandom.com',
		] );
	}

	protected function mockEnvironment( $environment ) {
		switch ( $environment ) {
			case WIKIA_ENV_PROD:
				$this->mockProdEnv();
				break;
			case WIKIA_ENV_PREVIEW:
				$this->mockPreviewEnv();
				break;
			case WIKIA_ENV_VERIFY:
				$this->mockVerifyEnv();
				break;
			case WIKIA_ENV_SANDBOX:
				$this->mockSandboxEnv();
				break;
			case WIKIA_ENV_DEV:
				$this->mockDevEnv();
				break;
		}
	}
}
