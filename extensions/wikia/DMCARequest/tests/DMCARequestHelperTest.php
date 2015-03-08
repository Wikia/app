<?php

namespace DMCARequest\Test;

use DMCARequest\DMCARequestHelper;

class DMCARequestHelperTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../DMCARequest.setup.php';
		parent::setUp();
	}

	public function testSetNoticeData() {
		$helper = new DMCARequestHelper();

		$initialData = [
			'type' => 1,
			'email' => 'example@example.com',
		];

		$helper->setNoticeData( $initialData );

		$amendedData = [
			'email' => 'example+two@example.com',
			'name' => 'Reporter',
		];

		$helper->setNoticeData( $amendedData );

		$expectedResult = [
			'type' => 1,
			'email' => 'example+two@example.com',
			'name' => 'Reporter',
		];

		$this->assertEquals( $expectedResult, $helper->getNoticeData() );
	}
}
