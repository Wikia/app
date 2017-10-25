--TEST--
Mail2: Test for bug #13659
--FILE--
<?php

//require_once dirname(__FILE__) . '/../Mail2/RFC822.php';
require_once 'Mail2/RFC822.php';
require_once 'PEAR.php';
$rfc = new Mail2_RFC822();

$address = '"Test Student" <test@mydomain.com> (test)';
$result = $rfc->parseAddressList($address, 'anydomain.com', TRUE); 


print $result[0]->personal . "\n";
print $result[0]->mailbox. "\n";
print $result[0]->host. "\n";
print $result[0]->comment[0] . "\n";
?>
--EXPECT--
"Test Student"
test
mydomain.com
test