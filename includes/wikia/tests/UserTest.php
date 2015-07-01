<?php
class UserTest extends WikiaBaseTest {

	/** @dataProvider localOptionNameProvider */
	public function testCreateLocalOptionName($input, $expected) {
		$result = call_user_func_array('User::localToGlobalPropertyName', $input);
		$this->assertEquals($expected, $result, sprintf("failed with input: [%s]", implode(", ", $input)));
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
