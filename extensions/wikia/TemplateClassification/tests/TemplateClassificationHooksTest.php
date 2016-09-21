<?php

/**
 * Unit tests for TC Hooks
 */

class TemplateClassificationHooksTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../TemplateClassification.setup.php';
		parent::setUp();
	}

	public function testQueryPageBeforeRecacheWrongPage() {
		$queryPageMock = $this->getMock( 'UnusedtemplatesPage', [ 'getName' ] );
		$queryPageMock
			->expects( $this->once() )
			->method( 'getName' )
			->willReturn( 'invalid special page name' );

		$hooksMock = $this->getHooksMockForUnusedTemplates();
		$hooksMock->expects( $this->never() )->method( 'getUnusedTemplatesHandler' );

		$resultsMock = $this->getMock( 'ResultWrapper' );

		$dbMock = $this->getDatabaseMock();

		$hooksMock->onQueryPageUseResultsBeforeRecache( $queryPageMock, $dbMock, $resultsMock );
	}

	public function testQueryPageBeforeRecacheNoResults() {
		$queryPage = new UnusedtemplatesPage();

		$handlerMock = $this->getUnusedTemplatesHandlerMock();
		$handlerMock->expects( $this->once() )
			->method( 'markAllAsUsed' );

		$hooksMock = $this->getHooksMockForUnusedTemplates();
		$hooksMock
			->expects( $this->once() )
			->method( 'getUnusedTemplatesHandler' )
			->willReturn( $handlerMock );

		$results = false;

		$dbMock = $this->getDatabaseMock();

		$hooksMock->onQueryPageUseResultsBeforeRecache( $queryPage, $dbMock, $results );
	}

	public function testQueryPageBeforeRecacheGoodResults() {
		$queryPage = new UnusedtemplatesPage();

		$handlerMock = $this->getUnusedTemplatesHandlerMock();
		$handlerMock->expects( $this->once() )
			->method( 'markAsUnusedFromResults' );

		$hooksMock = $this->getHooksMockForUnusedTemplates();
		$hooksMock
			->expects( $this->once() )
			->method( 'getUnusedTemplatesHandler' )
			->willReturn( $handlerMock );

		$results = $this->getMock( 'ResultWrapper' );

		$dbMock = $this->getDatabaseMock();

		$hooksMock->onQueryPageUseResultsBeforeRecache( $queryPage, $dbMock, $results );
	}

	/**
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function getHooksMockForUnusedTemplates() {
		return $this->getMock( 'Wikia\TemplateClassification\Hooks', [
			'getUnusedTemplatesHandler',
		] );
	}

	/**
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function getUnusedTemplatesHandlerMock() {
		return $this->getMock( 'Wikia\TemplateClassification\UnusedTemplates\Handler', [
			'markAsUnusedFromResults',
			'markAllAsUsed',
		] );
	}
}
