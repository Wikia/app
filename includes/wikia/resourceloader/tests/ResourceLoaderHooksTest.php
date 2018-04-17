<?php

use PHPUnit\Framework\TestCase;

class ResourceLoaderHooksTest extends TestCase {
	use MockGlobalVariableTrait;

	public function testCommonSourceIsSameAsLocalForDevEnv() {
		$this->mockGlobalVariable( 'wgCdnRootUrl', 'https://www.example.com' );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_DEV );

		$resourceLoader = new ResourceLoader();
		$sources = $resourceLoader->getSources();

		$this->assertEquals( $sources['local'], $sources['common'] );
		$this->assertNotEquals( 'https://www.example.com/__load/-/', $sources['local']['loadScript'] );
		$this->assertNotEquals( 'https://www.example.com/__load/-/', $sources['common']['loadScript'] );
	}

	/**
	 * @dataProvider provideNonDevEnv
	 *
	 * @param string $env
	 */
	public function testCommonSourceUsesSharedDomainForNonDevEnv( string $env ) {
		$this->mockGlobalVariable( 'wgCdnRootUrl', 'https://www.example.com' );
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $env );

		$resourceLoader = new ResourceLoader();
		$sources = $resourceLoader->getSources();

		$this->assertNotEquals( 'https://www.example.com/__load/-/', $sources['local']['loadScript'] );
		$this->assertEquals( 'https://www.example.com/__load/-/', $sources['common']['loadScript'] );
		$this->assertEquals( $sources['local']['apiScript'], $sources['common']['apiScript'] );
	}

	protected function tearDown() {
		parent::tearDown();
		$this->unsetGlobals();
	}

	public function provideNonDevEnv() {
		yield [ WIKIA_ENV_PROD ];
		yield [ WIKIA_ENV_PREVIEW ];
		yield [ WIKIA_ENV_SANDBOX ];
	}
}
