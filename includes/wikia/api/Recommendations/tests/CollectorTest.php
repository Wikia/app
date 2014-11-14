<?php
//use Wikia\Api\Recommendations\Collector;

class CollectorTest extends WikiaBaseTest {

	const ARTICLE_ID = 50;

	/**
	 * @dataProvider executeDataProvider
	 */
	public function testExecuteLimitDistribution( $collectorLimit, $dataProvidersSetup ) {

		$dataProviderMocks = [];
		foreach ( $dataProvidersSetup as $dataProviderSetup ) {
			$providerMock = $this->getMock( '\Wikia\Api\Recommendations\DataProviders\Video', ['get'] );
			$providerMock
				->method( 'get' )
				->with( $this->equalTo( self::ARTICLE_ID ), $this->equalTo( $dataProviderSetup['limit'] ) )
				->willReturn( $dataProviderSetup['out'] );

			$dataProviderMocks[] = $providerMock;
		}

		$collectorMock = $this->getMock( '\Wikia\Api\Recommendations\Collector', ['getDataProviders'] );

		$collectorMock
			->method( 'getDataProviders' )
			->willReturn( $dataProviderMocks );

		$result = $collectorMock->get( self::ARTICLE_ID, $collectorLimit );

		$this->assertEquals( $collectorLimit, count( $result ) );
	}

	public function executeDataProvider() {
		return [
			[
				'collectorLimit' => 10,
				'dataProvidersSetup' => [
					['limit' => 4, 'out' => array_fill( 0, 4, [] )],
					['limit' => 4, 'out' => array_fill( 0, 4, [] )],
					['limit' => 4, 'out' => array_fill( 0, 4, [] )]
				]
			],
			[
				'collectorLimit' => 10,
				'dataProvidersSetup' => [
					['limit' => 4, 'out' => array_fill( 0, 3, [] )],
					['limit' => 4, 'out' => array_fill( 0, 3, [] )],
					['limit' => 4, 'out' => array_fill( 0, 4, [] )]
				]
			],
			[
				'collectorLimit' => 9,
				'dataProvidersSetup' => [
					['limit' => 3, 'out' => array_fill( 0, 3, [] )],
					['limit' => 3, 'out' => array_fill( 0, 3, [] )],
					['limit' => 3, 'out' => array_fill( 0, 3, [] )]
				]
			],
			[
				'collectorLimit' => 9,
				'dataProvidersSetup' => [
					['limit' => 3, 'out' => array_fill( 0, 1, [] )],
					['limit' => 3, 'out' => array_fill( 0, 2, [] )],
					['limit' => 6, 'out' => array_fill( 0, 6, [] )]
				]
			],
			[
				'collectorLimit' => 9,
				'dataProvidersSetup' => [
					['limit' => 3, 'out' => []],
					['limit' => 3, 'out' => []],
					['limit' => 9, 'out' => array_fill( 0, 9, [] )]
				]
			],
			[
				'collectorLimit' => 5,
				'dataProvidersSetup' => [
					['limit' => 3, 'out' => array_fill( 0, 3, [] )],
					['limit' => 3, 'out' => array_fill( 0, 3, [] )]
				]
			],
			[
				'collectorLimit' => 12,
				'dataProvidersSetup' => [
					['limit' => 3, 'out' => array_fill( 0, 3, [] )],
					['limit' => 3, 'out' => array_fill( 0, 3, [] )],
					['limit' => 3, 'out' => array_fill( 0, 3, [] )],
					['limit' => 3, 'out' => array_fill( 0, 3, [] )]
				]
			],
			[
				'collectorLimit' => 36,
				'dataProvidersSetup' => [
					['limit' => 9, 'out' => array_fill( 0, 8, [] )],
					['limit' => 9, 'out' => array_fill( 0, 9, [] )],
					['limit' => 9, 'out' => array_fill( 0, 9, [] )],
					['limit' => 10, 'out' => array_fill( 0, 10, [] )]
				]
			],
		];
	}
}
