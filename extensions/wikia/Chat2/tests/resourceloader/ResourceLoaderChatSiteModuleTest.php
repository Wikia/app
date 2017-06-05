<?php

use PHPUnit\Framework\TestCase;

class ResourceLoaderChatSiteModuleTest extends TestCase {
	/** @var ResourceLoaderContext|PHPUnit_Framework_MockObject_MockObject $resourceLoaderContextMock */
	private $resourceLoaderContextMock;

	/** @var ResourceLoaderChatSiteModule $resourceLoaderChatSiteModule */
	private $resourceLoaderChatSiteModule;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../resourceloader/ResourceLoaderChatSiteModule.php';

		$this->resourceLoaderContextMock = $this->createMock( ResourceLoaderContext::class );
		$this->resourceLoaderChatSiteModule = new ResourceLoaderChatSiteModule();
	}

	/**
	 * Test that the correct set of pages are included as site JS/CSS in the Chat module.
	 */
	public function testGetPagesReturnsCorrectPages() {
		$getPages = new ReflectionMethod( ResourceLoaderChatSiteModule::class, 'getPages' );
		$getPages->setAccessible( true );

		$pages = $getPages->invoke(
			$this->resourceLoaderChatSiteModule,
			$this->resourceLoaderContextMock
		);

		$this->assertCount( 2, $pages );

		$this->assertThat( $pages, $this->logicalAnd(
			$this->arrayHasKey( 'MediaWiki:Chat.js' ),
			$this->arrayHasKey( 'MediaWiki:Chat.css' )
		) );

		$this->assertArrayHasKey( 'type', $pages['MediaWiki:Chat.js'] );
		$this->assertArrayHasKey( 'type', $pages['MediaWiki:Chat.css'] );

		$this->assertEquals( 'script', $pages['MediaWiki:Chat.js']['type'] );
		$this->assertEquals( 'style', $pages['MediaWiki:Chat.css']['type'] );
	}
}
