--TEST--
Mail2_RFC822: Address Parsing
--FILE--
<?php
require_once 'Mail2/RFC822.php';

$parser = new Mail2_RFC822();

/* A simple, bare address. */
$address = 'user@example.com';
print_r($parser->parseAddressList($address, null, true, true));

/* Address groups. */
$address = 'My Group: "Richard" <richard@localhost> (A comment), ted@example.com (Ted Bloggs), Barney;';
print_r($parser->parseAddressList($address, null, true, true));

/* A valid address with spaces in the local part. */
$address = '<"Jon Parise"@php.net>';
print_r($parser->parseAddressList($address, null, true, true));

/* An invalid address with spaces in the local part. */
$address = '<Jon Parise@php.net>';
try {
    $parser->parseAddressList($address, null, true, true);
} catch (Mail2_Exception $e) {
    echo $e->getMessage() . "\n";
}

/* A valid address with an uncommon TLD. */
$address = 'jon@host.longtld';
try {
    $parser->parseAddressList($address, null, true, true);
} catch (Mail2_Exception $e) {
    echo $e->getMessage() . "\n";
}
--EXPECT--
Array
(
    [0] => stdClass Object
        (
            [personal] => 
            [comment] => Array
                (
                )

            [mailbox] => user
            [host] => example.com
        )

)
Array
(
    [0] => stdClass Object
        (
            [groupname] => My Group
            [addresses] => Array
                (
                    [0] => stdClass Object
                        (
                            [personal] => "Richard"
                            [comment] => Array
                                (
                                    [0] => A comment
                                )

                            [mailbox] => richard
                            [host] => localhost
                        )

                    [1] => stdClass Object
                        (
                            [personal] => 
                            [comment] => Array
                                (
                                    [0] => Ted Bloggs
                                )

                            [mailbox] => ted
                            [host] => example.com
                        )

                    [2] => stdClass Object
                        (
                            [personal] => 
                            [comment] => Array
                                (
                                )

                            [mailbox] => Barney
                            [host] => localhost
                        )

                )

        )

)
Array
(
    [0] => stdClass Object
        (
            [personal] => 
            [comment] => Array
                (
                )

            [mailbox] => "Jon Parise"
            [host] => php.net
        )

)
Validation failed for: <Jon Parise@php.net>
