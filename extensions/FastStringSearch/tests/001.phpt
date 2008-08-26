--TEST--
Basic fast string search tests
--SKIPIF--
<?php if (!extension_loaded("fss")) print "skip"; ?>
--FILE--
<?php
$fss = fss_prep_search(array('hello', 'hi'));
var_dump(fss_exec_search($fss, 'hhhhello'));
var_dump(fss_exec_search($fss, 'hellohello', 1));
var_dump(fss_exec_search($fss, 'hellohihello', 1));
var_dump(fss_exec_search($fss, 'adfjshfkjs'));

fss_free($fss);

$fss = fss_prep_search('hello');
var_dump(fss_exec_search($fss, 'hhhhello'));
var_dump(fss_exec_search($fss, 'hellohello', 1));
var_dump(fss_exec_search($fss, 'adfjshfkjs'));

var_dump(fss_exec_replace($fss, 'helloabchelloaa'));

fss_free($fss);

$fss = fss_prep_replace(array(
        'abc' => 'def',
        'ab' => 'X',
));

var_dump(fss_exec_replace($fss, 'ddabcababcaaaab'));
?>
--EXPECT--
array(2) {
  [0]=>
  int(3)
  [1]=>
  int(5)
}
array(2) {
  [0]=>
  int(5)
  [1]=>
  int(5)
}
array(2) {
  [0]=>
  int(5)
  [1]=>
  int(2)
}
bool(false)
array(2) {
  [0]=>
  int(3)
  [1]=>
  int(5)
}
array(2) {
  [0]=>
  int(5)
  [1]=>
  int(5)
}
bool(false)
string(5) "abcaa"
string(13) "dddefXdefaaaX"
