--TEST--
Mail2: Bug Validate quoted string
--FILE--
<?php
require_once 'Mail2/RFC822.php';
$address_string = '"Joe Doe \(from Somewhere\)" <doe@example.com>, postmaster@example.com, root';
// $address_string = "Joe Doe from Somewhere <doe@example.com>, postmaster@example.com, root";
echo $address_string . "\n";
$rfc = new Mail2_RFC822();
$address_array = $rfc->parseAddressList($address_string, "example.com");
if (!is_array($address_array) || count($address_array) < 1) {
    die("something is wrong\n");
}

foreach ($address_array as $val) {
    echo "mailbox : " . $val->mailbox . "\n";
    echo "host    : " . $val->host . "\n";
    echo "personal: " . $val->personal . "\n";
}
print_r($address_array);
--EXPECT--
"Joe Doe \(from Somewhere\)" <doe@example.com>, postmaster@example.com, root
mailbox : doe
host    : example.com
personal: "Joe Doe \(from Somewhere\)"
mailbox : postmaster
host    : example.com
personal: 
mailbox : root
host    : example.com
personal: 
Array
(
    [0] => stdClass Object
        (
            [personal] => "Joe Doe \(from Somewhere\)"
            [comment] => Array
                (
                )

            [mailbox] => doe
            [host] => example.com
        )

    [1] => stdClass Object
        (
            [personal] => 
            [comment] => Array
                (
                )

            [mailbox] => postmaster
            [host] => example.com
        )

    [2] => stdClass Object
        (
            [personal] => 
            [comment] => Array
                (
                )

            [mailbox] => root
            [host] => example.com
        )

)