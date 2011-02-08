<?php
/*
 * As found on http://highscalability.com/product-scribe-facebooks-scalable-logging-system
	$messages = array();
	$entry = new LogEntry;
	$entry->category = "buckettest";
	$entry->message = "something very interesting happened";
	$messages []= $entry;
	$result = $conn->Log($messages);
*/

$GLOBALS['THRIFT_ROOT'] = dirname( __FILE__ );

include_once $GLOBALS['THRIFT_ROOT'] . '/scribe.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/transport/TSocket.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/transport/TFramedTransport.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/protocol/TBinaryProtocol.php';
//include_once '/usr/local/src/releases/scribe-2.0/src/gen-php/scribe.php';

$msg1['category'] = 'keyword';
$msg1['message'] = "This is some message for the category\n";
$msg2['category'] = 'keyword';
$msg2['message'] = "Some other message for the category\n";
$entry1 = new LogEntry($msg1);
$entry2 = new LogEntry($msg2);
$messages = array($entry1, $entry2);

$socket = new TSocket('localhost', 1464, true);
$transport = new TFramedTransport($socket);
$protocol = new TBinaryProtocol($transport, false, false);
$scribe_client = new scribeClient($protocol, $protocol);

$transport->open();
$scribe_client->Log($messages);
$transport->close();
