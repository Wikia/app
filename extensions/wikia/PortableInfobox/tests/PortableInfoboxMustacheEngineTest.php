<?php
use PHPUnit\Framework\TestCase;
use Wikia\PortableInfobox\Helpers\PortableInfoboxMustacheEngine;

class PortableInfoboxMustacheEngineTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../services/Helpers/PortableInfoboxMustacheEngine.php';
	}

	/**
	 * @covers PortableInfoboxMustacheEngine::isSupportedType
	 * @dataProvider isTypeSupportedInTemplatesDataProvider
	 */
	public function testIsTypeSupportedInTemplates( $type, $result, $description ) {
		$this->assertEquals(
			$result,
			PortableInfoboxMustacheEngine::isSupportedType( $type ),
			$description
		);
	}

	public function isTypeSupportedInTemplatesDataProvider() {
		return [
			[
				'type' => 'title',
				'result' => true,
				'description' => 'valid data type'
			],
			[
				'type' => 'invalidTestType',
				'result' => false,
				'description' => 'invalid data type'
			]
		];
	}


}
