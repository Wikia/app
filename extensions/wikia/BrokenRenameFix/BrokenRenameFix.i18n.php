<?php
/**
 * Flags message file
 */

$messages = [];

/**
 * English (en)
 */
$messages['en'] = [
	'brf-desc' => 'The extension provides a simple interface for re-running local rename jobs after an uncompleted rename process. Simply by providing an old name, a new name and a user ID number you can move remaining revisions on all communities the user has contributed at.',
	'brf-title' => 'Broken Rename Fix',
	'brf-label-user-id' => 'ID number:',
	'brf-label-old-name' => 'Old username:',
	'brf-label-new-name' => 'New username:',
	'brf-label-submit' => 'Re-run local renames',
	'brf-error-invalid-request' => 'It seems that the form was incorrectly submited. Please, try again.',
	'brf-error-empty-fields' => 'Please, fill all fields of the form.',
	'brf-error-invalid-user' => 'User ID does not match the new user name.',
	'brf-success' => 'The script is running! When it finishes, the logs will be available here: $1',
];

/**
 * Documentation (qqq)
 */
$messages['qqq'] = [
	'brf-desc' => '{{desc}}',
	'brf-title' => 'The name of the special page.',
	'brf-label-user-id' => 'Label for a field with an ID number.',
	'brf-label-old-name' => 'Label for a field with an Old username.',
	'brf-label-new-name' => 'Label for a field with a New username.',
	'brf-label-submit' => 'Text of a button that re-runs the rename scripts.',
	'brf-error-invalid-request' => 'A notice shown if the form was sent in an incorrect way.',
	'brf-error-empty-fields' => 'A notice shown if any of the form\'s fields is empty.',
	'brf-error-invalid-user' => 'A notice shown if a provided ID of a user is invalid.',
	'brf-success' => 'A notice shown if the script is successfully run. $1 is the link to the logs page.',
];
