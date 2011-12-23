<?php
$messages = array();

$messages['en'] = array(
	'wikia-rss-desc' => 'Enhanced 3rd party RSS extension. Loads RSS data asynchronously via AJAX requests and displays a RSS feed on a wiki page',
	
	'wikia-rss-error-parse' => 'A parse error occured. Check if data you provided to <rss> tag is valid.',
	'wikia-rss-error-ajax-loading' => 'An error occured while fetching RSS data. Try again or change your <rss> tag data.',
	'wikia-rss-error-invalid-options' => 'Invalid options set. Make sure you pass at least valid url to the RSS source, please.',
	'wikia-rss-empty' => 'No feeds found on: $1',
	'wikia-rss-error' => 'An error occured during fetching feeds from: $1. Error: $2',
	
	'wikia-rss-placeholder-loading' => 'Loading RSS data...',
	'wikia-rss-date-format' => 'm/d/Y',
);

$messages['qqq'] = array(
	'wikia-rss-empty' => '$1 is a rss url given in parser tag',
	'wikia-rss-error' => '$1 is a rss url given in parser tag, $2 is an error description',
);