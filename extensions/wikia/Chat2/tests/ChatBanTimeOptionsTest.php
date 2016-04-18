<?php

class ChatBanTimeOptionsTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../Chat_setup.php';
		parent::setUp();
	}


	/**
	 * @dataProvider testGetDataProvider
	 */
	public function testGet( $textSource, $expected ) {
		$messageMock = $this->getMockBuilder( 'Message' )
			->disableOriginalConstructor()
			->getMock();

		$messageMock->expects( $this->once() )
			->method( 'inContentLanguage' )
			->willReturn( $messageMock );

		$messageMock->expects( ( $this->once() ) )
			->method( 'text' )
			->willReturn( $textSource );

		$this->mockGlobalFunction( 'wfMessage', $messageMock );

		$this->assertEquals( $expected, ChatBanTimeOptions::newDefault()->get() );
	}

	public function testGetDataProvider() {
		return [
			'simple - 2 minutes' => [
				'2 minutes:2 minutes',
				[ '2 minutes' => 120 ],
			],
			'infinite' => [
				'infinite:infinite',
				[ 'infinite' => 31536000000 ]
			],
			'all plurals' => [
				'10 seconds:10 seconds,10 minutes:10 minutes,10 hours:10 hours,10 days:10 days,10 weeks:10 weeks,' .
				'10 months:10 months,10 years:10 years',
				[
					'10 seconds' => 10,
					'10 minutes' => 600,
					'10 hours' => 36000,
					'10 days' => 864000,
					'10 weeks' => 6048000,
					'10 months' => 25920000,
					'10 years' => 315360000,

				]
			],
			'all singulars' => [
				'10 second:10 second,10 minute:10 minute,10 hour:10 hour,10 day:10 day,10 week:10 week,' .
				'10 month:10 month,10 year:10 year',
				[
					'10 second' => 10,
					'10 minute' => 600,
					'10 hour' => 36000,
					'10 day' => 864000,
					'10 week' => 6048000,
					'10 month' => 25920000,
					'10 year' => 315360000,
				]
			],
			'different label' => [
				'some text:20 minutes',
				[ 'some text' => 1200 ]
			],
			'trailing whitespaces are ignored' => [
				"\tasd\n:  1  \t\n minute\n",
				[ 'asd' => 60 ]
			],
			'not in order' => [
				'A:1 hour,B:1 minute',
				[ 'A' => 3600, 'B' => 60 ]
			],
		];
	}
}
