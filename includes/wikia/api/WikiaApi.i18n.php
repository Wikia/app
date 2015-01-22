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
	'link-suggest-extension-not-available' => 'Link Suggest extension not available',
	'related-pages-extension-not-available' => 'Related Pages extension not available',
	'media-license-dropdown-html' => 'Get media license dropdown HTML.',
	'default-selected-value' => 'The default (selected) value',
	'value-for-attr' => 'The value for the "$1" attribute',
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
	'link-suggest-extension-not-available' => '404 Http error message in Search suggestion API: informs that Link Suggest extension is not available',
	'related-pages-extension-not-available' => '404 Http error message in Search suggestion API: informs that Related Pages extension is not available',
	'media-license-dropdown-html' => 'Message from API Licenses endpoint: about getting media license dropdown HTML.',
	'default-selected-value' => 'Message from API Licenses endpoint: about default (selected) value',
	'value-for-attr' => 'Message from API Licenses endpoint: about the value for the given attribute. $1 - name of attribute',
);
