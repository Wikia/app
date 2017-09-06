--TEST--
Mail2: Test for bug #9137, take 2
--FILE--
<?php

require_once dirname(__FILE__) . '/../Mail2/RFC822.php';
require_once 'PEAR.php';
$rfc = new Mail2_RFC822();
$addresses = array(
    array('raw' => '"John Doe" <test@example.com>'),
    array('raw' => '"John Doe' . chr(92) . '" <test@example.com>'),
    array('raw' => '"John Doe' . chr(92) . chr(92) . '" <test@example.com>'),
    array('raw' => '"John Doe' . chr(92) . chr(92) . chr(92) . '" <test@example.com>'),
    array('raw' => '"John Doe' . chr(92) . chr(92) . chr(92) . chr(92) . '" <test@example.com>'),
    array('raw' => '"John Doe <test@example.com>'),
);

for ($i = 0; $i < count($addresses); $i++) {
    // construct the address
    $address = $addresses[$i]['raw'];
    try {
        $parsedAddresses = $rfc->parseAddressList($address);
        echo $address." :: Parsed\n";
    } catch (Mail2_Exception $e) {
        echo $address." :: Failed to validate\n";
    }
}

--EXPECT--
"John Doe" <test@example.com> :: Parsed
"John Doe\" <test@example.com> :: Failed to validate
"John Doe\\" <test@example.com> :: Parsed
"John Doe\\\" <test@example.com> :: Failed to validate
"John Doe\\\\" <test@example.com> :: Parsed
"John Doe <test@example.com> :: Failed to validate
