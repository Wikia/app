<?php

class ExactTargetRequestBuilderTest extends WikiaBaseTest {
	public function setUp() {
		require_once __DIR__ . '/../../helpers/RequestBuilderTestsHelper.class.php';
		$this->setupFile = __DIR__ . '/../../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	public function testWrongTypeProvided() {
		$this->setExpectedException( 'Wikia\Util\AssertionException', 'Not supported request type' );
		new \Wikia\ExactTarget\Builders\DeleteRequestBuilder();
	}
}
