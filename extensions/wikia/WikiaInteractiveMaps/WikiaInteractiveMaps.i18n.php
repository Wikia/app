<?php

$messages = [];

$messages[ 'en' ] = [
	'wikia-interactive-maps-title' => 'Interactive Maps',
	'wikia-interactive-maps-create-a-map' => 'Create a Map',
	'wikia-interactive-maps-no-maps' => 'No maps found. Create new map now.',

	'wikia-interactive-maps-parser-tag-error-no-require-parameters' => "Wikia Interactive Maps error occurred: no parameters passed to the tag. The only required parameter is map-id parameter. Make sure it's set, please.",
	'wikia-interactive-maps-parser-tag-error-invalid-map-id' => "Wikia Interactive Maps error occurred: invalid map id. Please make sure your map-id parameter is an integer number.",
	'wikia-interactive-maps-parser-tag-error-invalid-latitude' => "Wikia Interactive Maps error occurred: invalid lat. Please make sure your latitude parameter is a number or remove it to set it to default value.",
	'wikia-interactive-maps-parser-tag-error-invalid-longitude' => "Wikia Interactive Maps error occurred: invalid lon. Please make sure your longitude parameter is a number or remove it to set it to default value.",
	'wikia-interactive-maps-parser-tag-error-invalid-zoom' => "Wikia Interactive Maps error occurred: invalid zoom. Please make sure your zoom parameter is an integer number higher or equal 0 or remove it to set it to default value.",
	'wikia-interactive-maps-parser-tag-error-invalid-width' => "Wikia Interactive Maps error occurred: invalid width. Please make sure your width parameter is an integer number higher than 0 or remove it to set it to default value.",
	'wikia-interactive-maps-parser-tag-error-invalid-height' => "Wikia Interactive Maps error occurred: invalid height. Please make sure your height parameter is an integer number higher than 0 or remove it to set it to default value.",

	'wikia-interactive-maps-map-placeholder-error' => 'Unexpected error has occurred. Please contact us if it happens again.',

	'wikia-interactive-maps-map-status-done' => 'Ready to use',
	'wikia-interactive-maps-map-status-processing' => 'Processing...',
];

$messages[ 'qqq' ] = [
	'wikia-interactive-maps-title' => 'Interactive maps special page title',
	'wikia-interactive-maps-create-a-map' => 'Label for create new map button',
	'wikia-interactive-maps-no-maps' => 'Shown when there are no maps created for this wiki',

	'wikia-interactive-maps-parser-tag-error-no-require-parameters' => 'Interactive maps error after try of parsing wikitext tag; one of the required parameters is not set',
	'wikia-interactive-maps-parser-tag-error-invalid-map-id' => 'Interactive maps error after try of parsing wikitext tag; the map-id is not passed or is not a valid number',
	'wikia-interactive-maps-parser-tag-error-invalid-latitude' => 'Interactive maps error after try of parsing wikitext tag; an invalid latitude value has been passed',
	'wikia-interactive-maps-parser-tag-error-invalid-longitude' => 'Interactive maps error after try of parsing wikitext tag; an invalid longitude has been passed',
	'wikia-interactive-maps-parser-tag-error-invalid-zoom' => 'Interactive maps error after try of parsing wikitext tag; an invalid zoom has been passed',
	'wikia-interactive-maps-parser-tag-error-invalid-width' => 'Interactive maps error after try of parsing wikitext tag; an invalid width has been passed',
	'wikia-interactive-maps-parser-tag-error-invalid-height' => 'Interactive maps error after try of parsing wikitext tag; an invalid height has been passed',

	'wikia-interactive-maps-map-placeholder-error' => 'Interactive maps unexpected error which could happen during some rare situations such as file system dead',
];
