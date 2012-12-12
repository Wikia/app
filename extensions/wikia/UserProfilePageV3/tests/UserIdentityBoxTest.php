<?php

class UserIdentityBoxTest extends WikiaBaseTest {
	const TOP_WIKI_LIMIT = 5;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../UserProfilePage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider checkIfDisplayZeroStatesDataProvider
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function testCheckIfDisplayZeroStates($data, $expectedResult) {
		$userIdentityBox = new UserIdentityBox(F::app(), $this->getMock('User'), self::TOP_WIKI_LIMIT);

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

}
