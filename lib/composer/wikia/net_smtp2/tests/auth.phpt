--TEST--
Net_SMTP2: SMTP Authentication
--SKIPIF--
<?php if (!@include('config.php')) die("skip\n");
--FILE--
<?php

require_once 'Net/SMTP2.php';
require_once 'config.php';

if (! ($smtp = new Net_SMTP2(TEST_HOSTNAME, TEST_PORT, TEST_LOCALHOST))) {
	die("Unable to instantiate Net_SMTP object\n");
}

try {
    $e = $smtp->connect();
} catch (Exception $e) {
	die($e->getMessage() . "\n");
}

try {
    $smtp->auth(TEST_AUTH_USER, TEST_AUTH_PASS);
} catch (Exception $e) {
	die("Authentication failure\n");
}

$smtp->disconnect();

echo 'Success!';

--EXPECT--
Success!
