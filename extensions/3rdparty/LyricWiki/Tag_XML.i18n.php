<?php

$messages = Array();
$messages['en'] = Array(
	'xml-feedfailed' => "Unable to fetch RSS feed.  Verify that your feed URL is correct. If this problem persists, please contact [[User_talk:Sean Colombo|Sean Colombo]]",
	'xml-emptyresult' => "The RSS feed returned an empty result.  Please check to make sure the source of the feed allows their feed to be fetched using 'curl'.",
	'xml-nocurl' => "'''ERROR! curl_init does not exist.  Please ensure that php-curl module is installed on the server.'''",
	'xml-pathnotfound' => "ERROR! Path not found: \$1<br/>",
	'xml-parseerror' => "Error parsing XML Feed: \$1",
	);

?>