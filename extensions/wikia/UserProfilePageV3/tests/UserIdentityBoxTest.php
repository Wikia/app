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
		$userIdentityBox = new UserIdentityBox( $this->getMock('User') );

		$this->assertEquals($expectedResult, $userIdentityBox->checkIfDisplayZeroStates($data));
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
		$userMock = $this->getMock( 'User' );

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
			[ $userMock ],
			'',
			false
		);
		$userIdentityBoxMock->expects( $this->once() )
			->method( 'getFavoriteWikisModel' )
			->will( $this->returnValue( $favoriteWikisModelMock ) );

		/** @var UserIdentityBox $userIdentityBoxMock */
		$userIdentityBoxMock->getTopWikis();
	}

	/**
	 * @dataProvider testSaveUserData_spamFilterProvider
	 */
	public function testSaveUserData_spamFilter($userData) {
		$userMock =  $this->getMock( 'User', [ 'setOption' ] );
		$userIdentityBoxMock = $this->getMock(
			'UserIdentityBox',
			[ 'doSpamCheck', 'hasUserEditedMastheadBefore' ],
			[ $userMock ],
			'',
			false
		);

		$userIdentityBoxMock->expects( $this->any() )
			->method( 'hasUserEditedMastheadBefore' )
			->will( $this->returnValue(true) );

		$userData = new StdClass();
		foreach ($userData as $property => $config) {
			$userData->$property = $config['value'];

			if ($property == 'name') {
				$userIdentityBoxMock->expects( $this->once() )
					->method( 'doSpamCheck' )
					// the `name` property uses a static method on `User` to
					// inflate a user object to perform the spam check against;
					// static methods on different classes cannot be mocked.
					// FIXME Correctly mock this in a consistent way so that
					// `name` can be tested specifically
					->will( $this->returnValue(!$config['spam']) );

				$userMock->expects( $this->once() )
					->method( 'setRealName' )
					->with($config['option']['value']);
			} else {
				$userIdentityBoxMock->expects( $this->once() )
					->method( 'doSpamCheck' )
					->with( $config['value'] )
					->will( $this->returnValue(!$config['spam']) );

				$userMock->expects( $this->once() )
					->method( 'setOption' )
					->with( $config['option']['property'], $config['option']['value'] );
			}
		}

		$userIdentityBoxMock->saveUserData($userData);
	}

	public function testSaveUserData_spamFilterProvider() {
		return array(
			array(
				array(
					'name' => array(
						'value' => 'short enough',
						'spam' => false,
						'option' => array(
							'property' => 'name',
							'value' => 'short enough',
						),
					),
				),
			),
			array(
				array(
					'name' => array(
						'value' => 'this is just way too long, and should be truncated to 40 characters',
						'spam' => false,
						'option' => array(
							'property' => 'name',
							'value' => '',
						),
					),
				),
			),
			array(
				array(
					'name' => array(
						'value' => 'spammy names should default to nothing',
						'spam' => true,
						'option' => array(
							'property' => 'name',
							'value' => '',
						),
					),
				),
			),
			array(
				// base case using a property with no additional filtering
				array(
					'twitter' => array(
						'value' => 'twitterhandle',
						'spam' => false,
						'option' => array(
							'property' => 'twitter',
							'value' => 'twitterhandle',
						),
					),
				),
			),
			array(
				// base case using a property with no additional filtering
				array(
					'twitter' => array(
						'value' => 'twitterhandle',
						'spam' => true,
						'option' => array(
							'property' => 'twitter',
							'value' => '',
						),
					),
				),
			),
		);
	}
}
