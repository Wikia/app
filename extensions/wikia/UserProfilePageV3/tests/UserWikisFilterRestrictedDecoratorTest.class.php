<?php
class UserWikisFilterRestrictedDecoratorTest extends WikiaBaseTest {

	private $restrictedWikis = [ 717284, 123 ];

	/**
	 * @dataProvider getFilteredDataProvider
	 */
	public function testGetFiltered( $message, $userWikisFilterMockedData, $expected ) {
		$userWikisFilterMock = $this->getMock( 'UserWikisFilter', [ 'getFiltered' ] );
		$userWikisFilterMock->expects( $this->once() )
			->method( 'getFiltered' )
			->will( $this->returnValue( $userWikisFilterMockedData ) );

		$userWikisFilterRestrictedDecoratorMock = $this->getMock(
			'UserWikisFilterRestrictedDecorator',
			[ 'getRestrictedWikis' ],
			[ $userWikisFilterMock ]
		);
		$userWikisFilterRestrictedDecoratorMock->expects( $this->once() )
			->method( 'getRestrictedWikis' )
			->will( $this->returnValue( $this->restrictedWikis ) );

		/** @var UserWikisFilterRestrictedDecorator $userWikisFilterRestrictedDecoratorMock */
		$this->assertEquals( $expected, $userWikisFilterRestrictedDecoratorMock->getFiltered(), $message );
	}

	/**
	 * @return array
	 */
	public function getFilteredDataProvider() {
		return [
			[
				'no wikis data',
				[],
				[],
			],
			[
				'no restricted wikis in data',
				[ [ 'id' => 831 ], [ 'id' => 177 ], [ 'id' => 12309754 ] ],
				[ [ 'id' => 831 ], [ 'id' => 177 ], [ 'id' => 12309754 ] ],
			],
			[
				'one restricted wiki is being removed from result data',
				[ [ 'id' => 831 ], [ 'id' => 177 ], [ 'id' => 12309754 ], [ 'id' => 717284 ] ],
				[ [ 'id' => 831 ], [ 'id' => 177 ], [ 'id' => 12309754 ] ],
			],
			[
				"two restricted wikis are being removed from result data (one's id is a string)",
				[ [ 'id' => 831 ], [ 'id' => 177 ], [ 'id' => 12309754 ], [ 'id' => 717284 ], [ 'id' => '123' ] ],
				[ [ 'id' => 831 ], [ 'id' => 177 ], [ 'id' => 12309754 ] ],
			],
		];
	}

}
