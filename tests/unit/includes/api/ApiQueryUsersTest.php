<?php

/**
 * @group Integration
 */
class ApiQueryUsersTest extends WikiaDatabaseTest {
	const TEST_USER_ONE_ID = 174;
	const TEST_USER_ONE_NAME = 'KossuthLajos';

	const TEST_USER_TWO_ID = 192;
	const TEST_USER_TWO_NAME = 'FerencJozsef';

	/** @var RequestContext $context  */
	private $context;

	/** @var ApiMain $apiMain */
	private $apiMain;

	protected function setUp() {
		parent::setUp();

		$title = Title::makeTitle( NS_MAIN, 'API' );
		$this->context = RequestContext::newExtraneousContext( $title );

		$this->apiMain = new ApiMain( $this->context, false );
	}

	public function testQueryForUserById() {
		$singleQueryResult = $this->doApiRequest( [
			'action' => 'query',
			'list' => 'users',
			'usids' => static::TEST_USER_ONE_ID
		] );

		$this->assertCount( 1, $singleQueryResult );
		$this->assertEquals(
			static::TEST_USER_ONE_NAME,
			$singleQueryResult['query']['users'][0]['name'] );
		$this->assertEquals(
			static::TEST_USER_ONE_ID,
			$singleQueryResult['query']['users'][0]['userid'] );

		$multiQueryResult = $this->doApiRequest( [
			'action' => 'query',
			'list' => 'users',
			'usids' => static::TEST_USER_ONE_ID . '|' . static::TEST_USER_TWO_ID
		] );

		$this->assertCount( 2, $multiQueryResult['query']['users'] );
	}

	public function testQueryForUserByName() {
		$singleQueryResult = $this->doApiRequest( [
			'action' => 'query',
			'list' => 'users',
			'ususers' => static::TEST_USER_ONE_NAME
		] );

		$this->assertCount( 1, $singleQueryResult );
		$this->assertEquals(
			static::TEST_USER_ONE_NAME,
			$singleQueryResult['query']['users'][0]['name'] );
		$this->assertEquals(
			static::TEST_USER_ONE_ID,
			$singleQueryResult['query']['users'][0]['userid'] );

		$multiQueryResult = $this->doApiRequest( [
			'action' => 'query',
			'list' => 'users',
			'ususers' => static::TEST_USER_ONE_NAME . '|' . static::TEST_USER_TWO_NAME
		] );

		$this->assertCount( 2, $multiQueryResult['query']['users'] );
	}

	public function testQueryForInvalidNameUserIdZeroIsNotValid() {
		$this->expectException( UsageException::class );
		$this->expectExceptionMessage( ApiQueryUsers::INVALID_PARAMS_ERR );

		$this->doApiRequest( [
			'action' => 'query',
			'list' => 'users',
			'usids' => 0,
			'ususers' => ''
		] );
	}

	private function doApiRequest( array $requestParams ): array {
		$request = new FauxRequest( $requestParams );

		$this->context->setRequest( $request );

		$this->apiMain->getResult()->reset();
		$this->apiMain->execute();

		return $this->apiMain->getResult()->getResultData();
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/../../../fixtures/ApiQueryUsersTest.yaml' );
	}
}
