<?php

use PHPUnit\Framework\TestCase;

class ResourceLoaderChatUserModuleTest extends TestCase {
	/** @var ResourceLoaderContext|PHPUnit_Framework_MockObject_MockObject $resourceLoaderContextMock */
	private $resourceLoaderContextMock;

	/** @var ResourceLoaderChatUserModule $resourceLoaderChatUserModule */
	private $resourceLoaderChatUserModule;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../../resourceloader/ResourceLoaderChatSiteModule.php';

		$this->resourceLoaderContextMock = $this->createMock( ResourceLoaderContext::class );
		$this->resourceLoaderChatUserModule = new ResourceLoaderChatUserModule();
	}

	/**
	 * Test that the scope of this module is limited
	 */
	public function testIsLimitedOrigin() {
		$this->assertEquals(
			ResourceLoaderModule::ORIGIN_USER_INDIVIDUAL,
			$this->resourceLoaderChatUserModule->getOrigin()
		);
	}

	/**
	 * Test that no user JS is generated for anon users.
	 */
	public function testGetPagesReturnsNoPagesForAnonUser() {
		$this->resourceLoaderContextMock->expects( $this->any() )
			->method( 'getUser' )
			->willReturn( null );

		$getPages = new ReflectionMethod( ResourceLoaderChatUserModule::class, 'getPages' );
		$getPages->setAccessible( true );

		$pages = $getPages->invoke(
			$this->resourceLoaderChatUserModule,
			$this->resourceLoaderContextMock
		);
		
		$this->assertEmpty( $pages );
	}

	/**
	 * Test that the correct set of pages are included as user JS/CSS in the Chat module.
	 *
	 * @dataProvider provideUserNames
	 * @param string $userName
	 */
	public function testGetPagesReturnsCorrectPagesForLoggedInUser( string $userName ) {
		$expectedUserName = str_replace( ' ', '_', $userName );

		$this->resourceLoaderContextMock->expects( $this->any() )
			->method( 'getUser' )
			->willReturn( $userName );

		$getPages = new ReflectionMethod( ResourceLoaderChatUserModule::class, 'getPages' );
		$getPages->setAccessible( true );

		$pages = $getPages->invoke(
			$this->resourceLoaderChatUserModule,
			$this->resourceLoaderContextMock
		);

		$this->assertCount( 2, $pages );

		$this->assertThat( $pages, $this->logicalAnd(
			$this->arrayHasKey( "User:$expectedUserName/chat.js" ),
			$this->arrayHasKey( "User:$expectedUserName/chat.css" )
		) );

		$this->assertArrayHasKey( 'type', $pages["User:$expectedUserName/chat.js"] );
		$this->assertArrayHasKey( 'type', $pages["User:$expectedUserName/chat.css"] );

		$this->assertEquals( 'script', $pages["User:$expectedUserName/chat.js"]['type'] );
		$this->assertEquals( 'style', $pages["User:$expectedUserName/chat.css"]['type'] );
	}

	public function provideUserNames() {
		return [
			[ 'Stachu Jones' ],
			[ 'Władysław I' ],
			[ '昭和天皇' ],
		];
	}
}
