<?php

class HubServiceTest extends WikiaBaseTest {

	/**
	 * @dataProvider getVerticalNameForComscoreDataProvider
	 * @param integer $verticalIdMock
	 * @param string $expectedVerticalName
	 */
	public function testGetVerticalNameForComscore(
		$verticalIdMock,
		$expectedVerticalName
	) {

		$wikiFactoryHubMock = $this->getMock( 'WikiFactoryHub', [ 'getVerticalId' ] );

		$this->mockStaticMethod( 'WikiFactoryHub', 'getInstance', $wikiFactoryHubMock );

		$wikiFactoryHubMock->expects( $this->any() )
			->method( 'getVerticalId' )
			->will( $this->returnValue( $verticalIdMock ) );

		$this->assertEquals( $expectedVerticalName, HubService::getVerticalNameForComscore( 1 ) );
	}

	public function getVerticalNameForComscoreDataProvider() {
		return [

			// special business rules for vertical->comscore mapping
			'comscore mapping — vertical: lifestyle' =>
				[ WikiFactoryHub::VERTICAL_ID_LIFESTYLE, 'lifestyle' ],
			'comscore mapping — vertical: other' =>
				[ WikiFactoryHub::VERTICAL_ID_OTHER, 'lifestyle' ],

		];
	}
}
