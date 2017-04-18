<?php
namespace RecentChanges;

use PHPUnit\Framework\TestCase;
use BadRequestException;
use WikiaRequest;
use WikiaResponse;
use User;
use RequestContext;

class ControllerTest extends TestCase {
	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../WikiaRecentChanges.setup.php';
	}

	/**
	 * @expectedException BadRequestException
	 */
	public function testSaveFiltersValidatesEditToken() {
		$controller = new Controller();

		$controller->setRequest( new WikiaRequest( [] ) );

		$controller->saveFilters();
	}

	public function testSaveFiltersReturnsEmptySuccessResponse() {
		$params = [];
		/** @var WikiaRequest $request */
		$request = $this->getMockBuilder( WikiaRequest::class )
			->setMethods( [ 'assertValidWriteRequest' ] )
			->setConstructorArgs( [ $params ] )
			->getMock();
		/** @var User $user */
		$user = $this->createMock( User::class );
		$response = new WikiaResponse( WikiaResponse::FORMAT_HTML );
		$context = new RequestContext();
		$context->setUser( $user );

		$controller = new Controller();
		$controller->setRequest( $request );
		$controller->setContext( $context );
		$controller->setResponse( $response );
		$controller->saveFilters();

		$this->assertEmpty( $response->getBody() );
		$this->assertNull( $response->getCode() );
	}
}
