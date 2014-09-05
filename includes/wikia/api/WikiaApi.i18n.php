<?php

$messages = array();

$messages['en'] = array(
	'invalid-parameter-basearticleid' => "Value of parameter baseArticleId ($1) corresponds to non-existent article",
	'out-of-range' => "The value of '$1' is out of range ($2, $3)",
	'parameter-is-required' => "Parameter '$1' is required",
	'parameter-is-invalid' => "Parameter '$1' is invalid",
	'parameter-exceeds-limit' => "Parameter '$1' exceeds limit of $2",
	'not-found' => "Not found",
	'invalid-data' => "Invalid data",
);

/**
 * Messages documentation
 */
$messages['qqq'] = array(
	'invalid-parameter-basearticleid' => 'Used in API, which finds trending articles for given article. $1 - id of article, for which we want to find trending articles',
	'out-of-range' => "Error message, which specifies, that some value is out of range. $1 - given value. $2 - minimal possible value. $3 - maximal possible value",
	'parameter-is-required' => "Error message, which specifies that some parameter is required. $1 - name of parameter",
	'parameter-is-invalid' => "Error message, which specifies that some parameter is invalid. $1 - name of parameter",
	'parameter-exceeds-limit' => "Error message, which specifies that some parameter exceeds limit. $1 - name of parameter. $2 - limit value",
	'not-found' => "Http error message (404 http error): Not found",
	'invalid-data' => "Http error message (555 http error): Invalid data",
);
