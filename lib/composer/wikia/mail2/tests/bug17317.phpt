--TEST--
Mail2_RFC822::parseAddressList invalid periods in mail address
--FILE--
<?php
require "Mail2/RFC822.php";

$rfc = new Mail2_RFC822();

foreach (array('.name@example.com', 'name.@example.com', 'name..name@example.com') as $addr) {
  try {
    $rfc->parseAddressList($addr);
  } catch (Mail2_Exception $e) {
    echo "OK\n";

  }
}
--EXPECT--
OK
OK
OK
