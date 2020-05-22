<?php

class UserIdentityBoxTest extends WikiaBaseTest {
	const TOP_WIKI_LIMIT = 5;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../UserProfilePage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider doParserFilterDataProvider
	 * @group UsingDB
	 *
	 * @author Sergey Naumov
	 */
	public function testDoParserFilter($text, $expectedResult) {
		$userIdentityBox = new UserIdentityBox( new User );

		$this->assertEquals($expectedResult, $userIdentityBox->doParserFilter($text));
	}

	/**
	 * @dataProvider checkIfDisplayZeroStatesDataProvider
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function testCheckIfDisplayZeroStates($data, $expectedResult) {
		$userIdentityBox = new UserIdentityBox( new User );

		$this->assertEquals($expectedResult, $userIdentityBox->checkIfDisplayZeroStates($data));
	}

	public function testClearMastheadContents() {
		/** @var PHPUnit_Framework_MockObject_MockObject|User $userMock */
		$userMock = $this->getMockBuilder( User::class )
			->setMethods( [ 'saveSettings', 'getId' ] )
			->getMock();

		$userMock->method( 'getId' )
			->willReturn( 1 );

		$userMock->expects( $this->once() )
			->method( 'saveSettings' )
			->with();

		$userIdentityBox = new UserIdentityBox( $userMock );
		$userIdentityBox->clearMastheadContents();

		foreach ( $userIdentityBox->optionsArray as $option ) {
			if ( $option === 'gender' || $option === 'birthday' ) {
				$option = UserIdentityBox::USER_PROPERTIES_PREFIX . $option;
			}
			$this->assertEquals( null, $userMock->getGlobalAttribute( $option ), 'clearMastheadContents should reset all user profile attributes' );
		}

		$this->assertEquals( null, $userMock->getRealName(), 'clearMastheadContents should reset user\'s real name' );
	}

	/**
	 * @brief data provider for UserIdentityBoxTest::testCheckIfDisplayZeroStates()
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function checkIfDisplayZeroStatesDataProvider() {
		return array(
			//all "important" data set
			array(
				array(
					'location' => 'Poznań',
					'occupation' => 'Programmer',
					'birthday' => '1985-07-10',
					'gender' => 'Male',
					'website' => 'http://www.example.com',
					'twitter' => 'http://www.twitter.com/#/test',
					'topWikis' => array(1, 2, 3, 123, 4365)
				),
				false
			),
			//first "important" data element set
			array(
				array(
					'location' => 'Poznań',
					'occupation' => '',
					'birthday' => false,
					'gender' => null,
					'website' => '',
					'twitter' => '',
					'topWikis' => array()
				),
				false
			),
			//last "important" data element set
			array(
				array(
					'location' => '',
					'occupation' => '',
					'birthday' => false,
					'gender' => null,
					'website' => '',
					'twitter' => '',
					'topWikis' => array(12, 1325, 4568)
				),
				false
			),
			//an "important" data element set but it's not first and last
			array(
				array(
					'location' => '',
					'occupation' => '',
					'birthday' => false,
					'gender' => 'Male',
					'website' => '',
					'twitter' => '',
					'topWikis' => null
				),
				false
			),
			//no "important" data element set
			array(
				array(
					'location' => '',
					'occupation' => '',
					'birthday' => false,
					'gender' => null,
					'website' => '',
					'twitter' => '',
					'topWikis' => array()
				),
				true
			),
			//data is an empty array
			array(
				array(),
				true
			),
			//no "important" data element set and there is a not-empty-element we don't care about
			array(
				array(
					'location' => '',
					'occupation' => '',
					'birthday' => false,
					'gender' => null,
					'website' => '',
					'twitter' => '',
					'topWikis' => array(),
					'arrayElementWeDontCareAbout' => 'thisShouldBeIgnored'
				),
				true
			)
		);
	}

	/**
	 * @brief data provider for UserIdentityBoxTest::testDoParserFilter()
	 *
	 * @author Sergey Naumov
	 */
	public function doParserFilterDataProvider() {
		return array(
			array(
				'string',
				'string'
			),
			array(
				' :D',
				':D'
			),
			array(
				'*** :D ***',
				'*** :D ***'
			),
			array(
				'http://domain.com/%20',
				'http://domain.com/%20'
			),
			array(
				'[http://www.example.com link title]',
				'link title'
			)
		);
	}

	/**
	 * @desc Tests if UserIdentityBox::getTopWikis delegates pulling wikis to FavoriteWikisModel
	 */
	public function testGetTopWikis() {
		$userMock = $this->getMock( 'User', [ 'getOption', 'getId' ] );
		$userMock->method( 'getId' )
			->willReturn( 1 );

		$favoriteWikisModelMock = $this->getMock(
			'FavoriteWikisModel',
			[ 'getTopWikis' ],
			[ $userMock ]
		);
		$favoriteWikisModelMock->expects( $this->once() )
			->method( 'getTopWikis' );

		$userIdentityBoxMock = $this->getMock(
			'UserIdentityBox',
			[ 'getFavoriteWikisModel' ],
			[ $userMock ]
		);
		$userIdentityBoxMock->expects( $this->once() )
			->method( 'getFavoriteWikisModel' )
			->will( $this->returnValue( $favoriteWikisModelMock ) );

		/** @var UserIdentityBox $userIdentityBoxMock */
		$userIdentityBoxMock->getTopWikis();
	}
}
