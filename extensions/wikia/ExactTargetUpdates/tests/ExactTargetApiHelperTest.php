<?php


class ExactTargetApiTest extends WikiaBaseTest {

	private $helper;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();

		$this->helper = new \Wikia\ExactTarget\ExactTargetApiHelper();
	}


	public function testWrapRetrieveRequest() {
		$request = $this->helper->wrapRetrieveRequest( [
			'ObjectType' => 'sometype',
			'Properties' => [ 'a' => 1 ],
			]);
		$this->assertNotNull( $request );
	}

}
