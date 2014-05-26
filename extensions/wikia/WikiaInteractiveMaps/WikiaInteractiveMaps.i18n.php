<?php

$messages = [];

$messages[ 'en' ] = [
	'wikia-interactive-maps-title' => 'Interactive Maps',
	'wikia-interactive-maps-create-a-map' => 'Create a Map',
	'wikia-interactive-maps-no-maps' => 'No maps found. Create new map now.',

	'wikia-interactive-maps-parser-tag-error-no-require-parameters' => 'Wikia Interactive Maps error occurred: no parameters passed to the tag. The only required parameter is map-id parameter. Make sure it\'s set, please.',
	'wikia-interactive-maps-parser-tag-error-invalid-map-id' => 'Wikia Interactive Maps error occurred: invalid map id. Please make sure your map-id parameter is an integer number.',
	'wikia-interactive-maps-parser-tag-error-invalid-latitude' => 'Wikia Interactive Maps error occurred: invalid lat. Please make sure your latitude parameter is a number or remove it to set it to default value.',
	'wikia-interactive-maps-parser-tag-error-min-latitude' => 'Wikia Interactive Maps error occurred: invalid lat. Please make sure your latitude is higher then $min.',
	'wikia-interactive-maps-parser-tag-error-max-latitude' => 'Wikia Interactive Maps error occurred: invalid lat. Please make sure your latitude is lower then $max.',
	'wikia-interactive-maps-parser-tag-error-invalid-longitude' => 'Wikia Interactive Maps error occurred: invalid lon. Please make sure your longitude parameter is a number or remove it to set it to default value.',
	'wikia-interactive-maps-parser-tag-error-min-longitude' => 'Wikia Interactive Maps error occurred: invalid lon. Please make sure your longitude is higher then $min.',
	'wikia-interactive-maps-parser-tag-error-max-longitude' => 'Wikia Interactive Maps error occurred: invalid lon. Please make sure your longitude is lower then $max.',
	'wikia-interactive-maps-parser-tag-error-invalid-zoom' => 'Wikia Interactive Maps error occurred: invalid zoom. Please make sure your zoom parameter is an integer number or remove it to set it to default value.',
	'wikia-interactive-maps-parser-tag-error-min-zoom' => 'Wikia Interactive Maps error occurred: invalid zoom. Please make sure your zoom parameter is set to $min or higher.',
	'wikia-interactive-maps-parser-tag-error-max-zoom' => 'Wikia Interactive Maps error occurred: invalid zoom. Please make sure your zoom parameter is to $max or lower.',
	'wikia-interactive-maps-parser-tag-error-invalid-width' => 'Wikia Interactive Maps error occurred: invalid width. Please make sure your width parameter is an integer number or remove it to set it to default value.',
	'wikia-interactive-maps-parser-tag-error-min-width' => 'Wikia Interactive Maps error occurred: invalid width. Minimum supported with is $min.',
	'wikia-interactive-maps-parser-tag-error-max-width' => 'Wikia Interactive Maps error occurred: invalid width. Maximum supported with is $max.',
	'wikia-interactive-maps-parser-tag-error-invalid-height' => 'Wikia Interactive Maps error occurred: invalid height. Please make sure your height parameter is an integer number or remove it to set it to default value.',
	'wikia-interactive-maps-parser-tag-error-min-height' => 'Wikia Interactive Maps error occurred: invalid height. Minimum supported height is $min.',
	'wikia-interactive-maps-parser-tag-error-max-height' => 'Wikia Interactive Maps error occurred: invalid height. Maximum supported height is $max.',
	'wikia-interactive-maps-parser-tag-error-no-map-found' => 'Wikia Interactive Maps error occurred: Map not found.',

	'wikia-interactive-maps-map-placeholder-error' => 'Unexpected error has occurred. Please contact us if it happens again.',

	'wikia-interactive-maps-map-status-done' => 'Ready to use',
	'wikia-interactive-maps-map-status-processing' => 'Processing...',

	'wikia-interactive-maps-sort-newest-to-oldest' => 'Newest to Oldest',
	'wikia-interactive-maps-sort-alphabetical' => 'Alphabetical',
	'wikia-interactive-maps-sort-recently-updated' => 'Recently updated',

	'wikia-interactive-maps-map-not-found-error' => 'Map not found',

	'wikia-interactive-maps-create-map-header' => 'Create a Map',
	'wikia-interactive-maps-create-map-next-btn' => 'Next',
	'wikia-interactive-maps-create-map-back-btn' => 'Back',

	'wikia-interactive-maps-create-map-choose-type-geo' => 'Real Map',
	'wikia-interactive-maps-create-map-choose-type-custom' => 'Custom Map',
	'wikia-interactive-maps-create-map-title-placeholder' => 'Title',

	'wikia-interactive-maps-create-map-bad-request-error' => 'Neither of required parameters was provided',
	'wikia-interactive-maps-create-map-service-error' => 'Oops, we have issues with our maps service. If it repeats [[Special:Contact|contact us]], please.',

	'wikia-interactive-maps-image-uploads-disabled' => 'File uploads are currently disabled on your wiki. Please try again later.',
	'wikia-interactive-maps-image-uploads-error' => 'There was an error while uploading the image. If it repeats [[Special:Contact|contact us]], please.',
	'wikia-interactive-maps-image-uploads-warning' => 'There were some issues while uploading the image. If it repeats [[Special:Contact|contact us]], please.',
	'wikia-interactive-maps-image-uploads-error-file-too-large' => 'The file you tried to upload is too big. Maximum image size is $1 MB',
	'wikia-interactive-maps-image-uploads-error-empty-file' => 'The file you tried to upload is empty',
	'wikia-interactive-maps-image-uploads-error-bad-type' => 'The file you tried to upload is not an image',

	'wikia-interactive-maps-create-map-error-invalid-map-title' => 'Error: You must title the map before proceeding.',
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
	'wikia-interactive-maps-parser-tag-error-min-width' => 'Interactive maps error after try of parsing wikitext tag; value below minimum width has been passed',
	'wikia-interactive-maps-parser-tag-error-max-width' => 'Interactive maps error after try of parsing wikitext tag; value above maximum width has been passed',
	'wikia-interactive-maps-parser-tag-error-invalid-height' => 'Interactive maps error after try of parsing wikitext tag; an invalid height has been passed',
	'wikia-interactive-maps-parser-tag-error-min-height' => 'Interactive maps error after try of parsing wikitext tag; value below minimum height has been passed',
	'wikia-interactive-maps-parser-tag-error-max-height' => 'Interactive maps error after try of parsing wikitext tag; value above maximum height has been passed',
	'wikia-interactive-maps-parser-tag-error-no-map-found' => 'Interactive maps error when map of given id doesn\'t exist',

	'wikia-interactive-maps-map-placeholder-error' => 'Interactive maps unexpected error which could happen during some rare situations such as file system dead',

	'wikia-interactive-maps-sort-newest-to-oldest' => 'Ordering option shown in drop-down menu above map lists; when chosen orders map list from newest map to oldest',
	'wikia-interactive-maps-sort-alphabetical' => 'Ordering option shown in drop-down menu above map lists; when chosen orders map list in alphabetical order',
	'wikia-interactive-maps-sort-recently-updated' => 'Ordering option shown in drop-down menu above map lists; when chosen orders map list so the recently update maps are on the top',

	'wikia-interactive-maps-map-not-found-error' => 'Error message, shown when map is not found',

	'wikia-interactive-maps-create-map-header' => 'Header for create map modal',
	'wikia-interactive-maps-create-map-next-btn' => 'Next button for create map modal',
	'wikia-interactive-maps-create-map-back-btn' => 'Back button for create map modal',
	'wikia-interactive-maps-create-map-choose-type-geo' => 'Button for choosing real map type',
	'wikia-interactive-maps-create-map-choose-type-custom' => 'Button for choosing custom map type',
	'wikia-interactive-maps-create-map-title-placeholder' => 'Input placeholder for map title',

	'wikia-interactive-maps-create-map-bad-request-error' => 'An API error message not visible for the user',
	'wikia-interactive-maps-create-map-service-error' => 'An error message which appears in the creation map modal when our map service fails to create a map',

	'wikia-interactive-maps-image-uploads-disabled' => 'An error displayed to a user when files upload is disabled on a wikia',
	'wikia-interactive-maps-image-uploads-error' => 'An error displayed to a user when a file upload fails because of backend errors',
	'wikia-interactive-maps-image-uploads-warning' => 'An error displayed to a user when a file upload fails because of backend warnings',
	'wikia-interactive-maps-image-uploads-error-file-too-large' => 'An error displayed to a user when a file upload fails because of incorrect file size; the only parameter is maximum size of file in MB',
	'wikia-interactive-maps-image-uploads-error-empty-file' => 'An error displayed to a user when file is empty',
	'wikia-interactive-maps-image-uploads-error-bad-type' => 'An error displayed to a user when file has wrong format (not image)',

	'wikia-interactive-maps-create-map-error-invalid-map-title' => 'An error message displayed above map title form field when the map title is invalid.',
];

