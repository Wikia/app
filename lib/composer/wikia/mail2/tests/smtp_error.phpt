--TEST--
Mail2: SMTP Error Reporting
--FILE--
<?php
require_once 'Mail2.php';

/* Reference a bogus SMTP server address to guarantee a connection failure. */
$params = array('host' => 'bogus.host.tld');

/* Create our SMTP-based mailer object. */
$mailer = Mail2::factory('smtp', $params);

/* Attempt to send an empty message in order to trigger an error. */
try {
    $mailer->send(array(), array(), '');
} catch (Exception $e) {
    $err = $e->getMessage();
    if (preg_match('/Name or service not known/i', $err)) {
        echo "OK";
    } else {
        print_r($e);
    }
  
}
--EXPECT--
OK