<?php

require 'Net/SMTP2.php';

$host = 'mail.example.com';
$from = 'user@example.com';
$rcpt = array('recipient1@example.com', 'recipient2@example.com');
$subj = "Subject: Test Message\n";
$body = "Body Line 1\nBody Line 2";

/* Create a new Net_SMTP2 object. */
if (! ($smtp = new Net_SMTP2($host))) {
    die("Unable to instantiate Net_SMTP2 object\n");
}

/* Connect to the SMTP server. */
try {
    $smtp->connect();
} catch (PEAR_Exception $e) {
    die($e->getMessage() . "\n");
}
$smtp->auth('username','password');
/* Send the 'MAIL FROM:' SMTP command. */
try {
    $smtp->mailFrom($from);
} catch (PEAR_Exception $e) {
    die("Unable to set sender to <$from>\n");
}

/* Address the message to each of the recipients. */
try {
    foreach ($rcpt as $to) {
        $smtp->rcptTo($to);
    }
} catch (PEAR_Exception $e) {
    die("Unable to add recipient <$to>: " . $e->getMessage() . "\n");
}

/* Set the body of the message. */
try {
    $smtp->data($subj . "\r\n" . $body);
} catch (PEAR_Exception $e) {
    die("Unable to send data\n");
}

/* Disconnect from the SMTP server. */
$smtp->disconnect();
