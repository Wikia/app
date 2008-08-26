<?php

dl("php_wikidiff.so");
$f1 = implode("\n", file("t1.txt"));
$f2 = implode("\n", file("t2.txt"));

# performance test
for ($i = 0; $i < 100; ++$i) {
	$v = wikidiff_do_diff($f1, $f2, 2);
}

