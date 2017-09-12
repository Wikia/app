<?php

class FilePageControllerTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../FilePage.setup.php';
		parent::setUp();
	}

	/**
	 * SUS-1531: Test access restrictions for FilePageController Nirvana controller
	 */
	public function testFilePageControllerAccess() {
		$res = $this->app->sendExternalRequest( FilePageController::class, 'fileList' );
		$this->assertNull( $res->getCode(), 'FilePageController::fileList must be externally accessible' );

		$internalMethods = [ 'fileUsage', 'videoCaption' ];
		foreach ( $internalMethods as $methodName ) {
			$res = $this->app->sendExternalRequest( FilePageController::class, $methodName );
			$this->assertEquals( WikiaResponse::RESPONSE_CODE_FORBIDDEN, $res->getCode(), "FilePageController::$methodName must not be externally accessible" );
		}
	}
}
