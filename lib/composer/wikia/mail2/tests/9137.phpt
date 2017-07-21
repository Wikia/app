--TEST--
Mail2: Test for bug #9137
--FILE--
<?php

require_once dirname(__FILE__) . '/../Mail2/RFC822.php';
require_once 'PEAR.php';

$addresses = array(
    array('name' => 'John Doe', 'email' => 'test@example.com'),
    array('name' => 'John Doe\\', 'email' => 'test@example.com'),
    array('name' => 'John "Doe', 'email' => 'test@example.com'),
    array('name' => 'John "Doe\\', 'email' => 'test@example.com'),
);
$rfc = new Mail2_RFC822();
for ($i = 0; $i < count($addresses); $i++) {
    // construct the address
    $address = "\"" . addslashes($addresses[$i]['name']) . "\" ".
        "<".$addresses[$i]['email'].">";

    $parsedAddresses = $rfc->parseAddressList($address);
    echo $address." :: Parsed\n";
}

--EXPECT--
"John Doe" <test@example.com> :: Parsed
"John Doe\\" <test@example.com> :: Parsed
"John \"Doe" <test@example.com> :: Parsed
"John \"Doe\\" <test@example.com> :: Parsed
