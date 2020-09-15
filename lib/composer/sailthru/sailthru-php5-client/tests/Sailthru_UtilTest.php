<?php

class Sailthru_UtilTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->params = array(
            'item1' => 'value1',
            'item2' => 'value2',
            'item3' => array('value3', 'value4'),
            'item4' => false,
            'item5' => true
        );
    }
    
    public function testExtractParamValues() {
        $expected = array('value1', 'value2', 'value3', 'value4', 0, 1);
        $actual = array();
        Sailthru_Util::extractParamValues($this->params, $actual);
        $this->assertEquals(array_values($expected), $actual);
    }

    public function testGetSignatureString() {
        $expected_arr = array('value1', 'value2', 'value3', 'value4', 0, 1);
        $secret = "ABCXYZ";
        $expected_str = $secret;
        sort($expected_arr, SORT_STRING);
        foreach ($expected_arr as $val) {
            $expected_str .= $val;
        }
        $actual_signature_str = Sailthru_Util::getSignatureString($this->params, $secret);
        $this->assertEquals($expected_str, $actual_signature_str);
    }
}
