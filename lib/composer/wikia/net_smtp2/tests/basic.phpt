--TEST--
Net_SMTP2: Basic Functionality
--SKIPIF--
<?php if (!@include('config.php')) die("skip\n");
--FILE--
<?php

require_once 'Net/SMTP2.php';
require_once 'config.php';

if (! ($smtp = new Net_SMTP(TEST_HOSTNAME, TEST_PORT, TEST_LOCALHOST))) {
	die("Unable to instantiate Net_SMTP object\n");
}

try {
    $e = $smtp->connect();
} catch (Exception $e) {
	die($e->getMessage() . "\n");
}

if (PEAR::isError($e = $smtp->auth(TEST_AUTH_USER, TEST_AUTH_PASS))) {
    die("Authentication failure\n");
}

try {
    $smtp->mailFrom(TEST_FROM);
} catch (Exception $e) {
	die('Unable to set sender to <' . TEST_FROM . ">\n");
}

try {
    $smtp->rcptTo(TEST_TO);
} catch (Exception $e) {	die('Unable to add recipient <' . TEST_TO . '>: ' .
		$e->getMessage() . "\n");
}

try {
    $smtp->data(TEST_SUBJECT . "\r\n" . TEST_BODY);
} catch (Exception $e) {
	die("Unable to send data\n");
}

$smtp->disconnect();

echo 'Success!';

--EXPECT--
Success!
