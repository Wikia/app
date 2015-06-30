<?php
class UserTest extends WikiaBaseTest {

	/** @dataProvider localOptionNameProvider */
	public function testCreateLocalOptionName($input, $expected) {
		$result = call_user_func_array('User::createLocalOptionName', $input);
		$this->assertEquals($expected, $result, sprintf("failed with input: [%s, %d, %s]", $option, $cityId, $sep));
	}

	function localOptionNameProvider() {
		global $wgCityId;
		return array(
			array(
				array("foo"), "foo-{$wgCityId}",
			),
			array(
				array("foo", 1), "foo-1",
			),
			array(
				array("foo", 1, "_"), "foo_1",
			)
		);
	}
}
