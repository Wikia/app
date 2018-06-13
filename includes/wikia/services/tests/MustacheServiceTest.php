<?php

/**
 * @group mustache
 */
class MustacheServiceTest extends WikiaBaseTest {

	/* @var MustacheService $service */
	private $file, $service;

	public function setUp(){
		parent::setUp();

		if ( !extension_loaded( 'mustache' ) ) {
			$this->markTestSkipped( '"mustache" PHP extension needs to be loaded!' );
		}

		$this->file = __DIR__ . '/../templates/test.mustache';
		$this->service = MustacheService::getInstance();
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
