<?php

class UnusedTemplatesHandlerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../TemplateClassification.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider isUsedDataProvider
	 */
	public function testIsUsed( $selectResult, $expected, $message ) {
		$dbMock = $this->getDatabaseMock([ 'selectRow' ] );
		$dbMock->expects( $this->once() )
			->method( 'selectRow' )
			->willReturn( $selectResult );

		$handlerMock = $this->getMock( 'Wikia\TemplateClassification\UnusedTemplates\Handler', [
			'getDatabaseForRead'
		] );
		$handlerMock->expects( $this->once() )
			->method( 'getDatabaseForRead' )
			->willReturn( $dbMock );

		$this->assertSame( $expected, $handlerMock->isUsed( 123 ), $message );
	}

	/**
	 * A simple test that checks if the `markAsUnusedFromResults` method will quit
	 * early and return `false` if no valid pageIds are generated from the results.
	 */
	public function testMarkAsUnusedFromResultsInvalidData() {
		$resultsMock = $this->getMock( 'ResultWrapper' );

		$dbMock = $this->getDatabaseMock([ 'begin' ] );
		$dbMock->expects( $this->never() )
			->method( 'begin' );

		$handlerMock = $this->getMock( 'Wikia\TemplateClassification\UnusedTemplates\Handler', [
			'markAllAsUsed',
			'getInsertRowsFromResults',
		] );

		$handlerMock->expects( $this->once() )
			->method( 'getInsertRowsFromResults' )
			->willReturn( [] );

		$this->assertFalse( $handlerMock->markAsUnusedFromResults( $resultsMock, $dbMock ) );
	}

	/**
	 * @return array
	 */
	public function isUsedDataProvider() {
		return [
			[
				false,
				true,
				'The selectRow method returns false (no results) so we assume the template is used.',
			],
			[
				(object)[ 'props' => 1 ],
				true,
				'The selectRow method returns an object and the `props` field value indicates the template is used',
			],
			[
				(object)[ 'props' => 0 ],
				false,
				'The selectRow method returns an object and the `props` field value indicates the template is unused',
			],
		];
	}
}
