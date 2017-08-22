--TEST--
Mail2: Bug #20281
--SKIPIF--
print 'skip'; // WIP
--FILE--
<?php
/*
require_once 'Mail2.php';

$params = array('debug' => true);

$mailer = Mail2::factory('smtp', $params);

$hdrs = array(
    'From'    => 'me@example.com',
    'Subject' => 'Test message'
);

$mailer->send('"First.Last" <First.Last@example.com>', $hdrs, "ticks: works");

$mailer->send('First.Last <First.Last@example.com>', $hdrs, "not ticks: does not work");
*/
print "WIP";
--EXPECT--
WIP