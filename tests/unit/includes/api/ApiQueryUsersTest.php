<?php

class ApiQueryUsersTest extends WikiaDatabaseTest {
	/** @var ApiMain $apiMain */
	private $apiMain;

	protected function setUp() {
		parent::setUp();

		$this->markTestIncomplete( 'Work in progress' );

		$title = Title::makeTitle( NS_MAIN, 'API' );
		$context = RequestContext::newExtraneousContext( $title );

		$this->apiMain = new ApiMain( $context, false );
	}

	public function testQueryForUserById() {}

	public function testQueryForUserByName() {}

	public function testQueryForUserByIdAndName() {}

	public function testQueryOnlyForUserIdZeroIsNotValid() {}

	protected function getDataSet() {
		return null;
	}
}
