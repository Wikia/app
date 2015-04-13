<?php

class MercuryApiHelperTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/MercuryApi/MercuryApi.setup.php";
		parent::setUp();
	}

	/**
	 * Test isTitleStringValid
	 *
	 * @covers MercuryApiHelper::isTitleStringValid
	 * @dataProvider isTitleStringValidDataProvider
	 */
	public function testIsTitleStringValid( $desc, $title, $expected ) {
		$this->assertEquals($expected, MercuryApiHelper::isTitleStringValid( $title ),  $desc );
	}

	public function isTitleStringValidDataProvider() {
		return [
			[
				'$desc' => 'Test if a simple standard article title is valid',
				'$title' => 'Morrowind',
				'$expected' => true
			],
			[
				'$desc' => 'Test if a standard article title with spaces is valid',
				'$title' => 'The Elder Scrolls III: Morrowind',
				'$expected' => true
			],
			[
				'$desc' => 'Test if a standard article title with spaces converted to underscores is valid',
				'$title' => 'The_Elder_Scrolls_III:_Morrowind',
				'$expected' => true
			],
			[
				'$desc' => 'Test if an unusual article title consisting only of a zero is valid',
				'$title' => '0',
				'$expected' => true
			],
			[
				'$desc' => 'Test if an empty article title is invalid',
				'$title' => '',
				'$expected' => false
			],
			[
				'$desc' => 'Test if an article title consisting only of whitespace characters is invalid',
				'$title' => ' 	 	 	',
				'$expected' => false
			],
			[
				'$desc' => 'Test if an article title that has NULL value is invalid',
				'$title' => null,
				'$expected' => false
			]
		];
	}
}
