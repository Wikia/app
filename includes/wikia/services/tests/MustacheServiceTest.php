<?php

class MustacheServiceTest extends WikiaBaseTest {

	/* @var MustacheService $service */
	private $file, $service;

	public function setUp(){
		parent::setUp();

		$this->file = __DIR__ . '/../templates/test.mustache';
		$this->service = MustacheService::getInstance();
	}

	public function testExtensionsIsLoaded() {
		$this->assertTrue( extension_loaded( 'mustache' ), '"mustache" PHP extension needs to be loaded!' );
	}

	/**
	 * @dataProvider renderDataProvider
	 */
	public function testRender( $data, $expected ) {
		$this->assertEquals( $expected, trim( $this->service->render( $this->file, $data ) ) );
	}

	public function renderDataProvider() {
		return [
			[
				[ 'check' => true ],
				"start\n\nyes"
			],
			[
				[ 'check' => false ],
				"start\n\n\nno"
			]
		];
	}
}
