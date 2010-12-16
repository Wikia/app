--TEST--
load_txt_def extension
--SKIPIF--
<?php
if( !extension_loaded( 'load_txt_def' ) )
	print 'skip';
--FILE--
<?php
var_dump( load_txt_def( dirname( __FILE__ ) . '/sample.txt', false, array( 'array' => array( 'array3' ) ) ) );
--EXPECT--
array(2) {
  ["Scalar"]=>
  array(1) {
    ["scalar"]=>
    string(12) "scalar value"
  }
  ["Arrays"]=>
  array(5) {
    ["array"]=>
    array(2) {
      ["key1"]=>
      string(6) "value1"
      ["key2"]=>
      string(6) "value2"
    }
    ["overload"]=>
    array(1) {
      ["key1"]=>
      string(6) "value2"
    }
    ["array2"]=>
    array(2) {
      ["key1"]=>
      array(2) {
        ["sub1"]=>
        string(4) "val1"
        ["sub2"]=>
        string(4) "val2"
      }
      ["key2"]=>
      array(2) {
        ["sub3"]=>
        string(4) "val3"
        ["sub4"]=>
        string(4) "val4"
      }
    }
    ["array3"]=>
    array(2) {
      ["key3"]=>
      string(6) "value3"
      ["key4"]=>
      string(6) "value4"
    }
    ["array4"]=>
    array(1) {
      [0]=>
      array(2) {
        ["key1"]=>
        string(4) "val1"
        [0]=>
        array(2) {
          [0]=>
          string(4) "val2"
          [1]=>
          string(4) "val3"
        }
      }
    }
  }
}
