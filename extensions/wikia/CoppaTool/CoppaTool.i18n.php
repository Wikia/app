<?php
/**
 * Internationalisation for CoppaTool extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Daniel Grunwell (grunny)
 */
$messages['en'] = array(
	'coppatool' => 'COPPA Tool',
	'coppatool-desc' => 'A tool for dealing with COPPA reports',
	'right-coppatool' => 'Handle COPPA reports',
	'action-coppatool' => 'deal with COPPA reports',
	'coppatool-nosuchuser' => 'Account "$1" does not exist!',
	'coppatool-label-username' => 'Username:',
	'coppatool-submit' => 'Get user',
	'coppatool-disable' => 'Disable user account',
	'coppatool-reason' => 'COPPA',
	'coppatool-form-header' => 'COPPA actions',
	'coppatool-delete-user-pages' => 'Delete user pages',
	'coppatool-delete-user-pages-reason' => '[[wikia:Terms of Use|Terms of Use]]',
	'coppatool-delete-user-pages-success' => 'Task created with ID #$1 to delete user pages.',
	'coppatool-blank-user-profile' => 'Blank user profiles',
	'coppatool-staticimagereview' => 'Review uploads by this user',
	'coppatool-rename-ip' => 'Overwrite IP address in edits and logs to 0.0.0.0',
	'coppatool-rename-ip-success' => 'Task created with ID #$1. Check the Staff Log for the status of the rename process.',
	'coppatool-phalanx-ip' => 'Phalanx block IP address',
	'coppatool-permissionerror' => 'You do not have permission to perform this action.',
	'coppatool-posterror' => 'Request must be posted.',
	'coppatool-tokenerror' => 'Invalid token provided.',
	'coppatool-invalid-ip' => 'Invalid IP address provided.',
	'coppatool-invalid-user' => 'Invalid user provided.',
	'coppatool-see-list-of-blocks' => 'See the list of blocks here',	
	'coppatool-warning-phalanx-block' => 'Phrase "$1" is globally blocked by Phalanx. $2.',
	'coppatool-info-started' => '$1 started to rename: $2 to $3 (logs: $4).
Reason: "$5".',
	'coppatool-info-finished' => '$1 completed rename: $2 to $3 (logs: $4).
Reason: "$5".',
	'coppatool-info-failed' => '$1 FAILED rename: $2 to $3 (logs: $4).
Reason: "$5".',
	'coppatool-info-wiki-finished' => '$1 renamed $2 to $3 on $4.
Reason: "$5".',
	'coppatool-info-wiki-finished-problems' => '$1 renamed $2 to $3 on $4 with errors.
Reason: "$5".',
	'coppatool-error-invalid-ip' => 'Invalid IP addresses provided.',
	'coppatool-warn-table-missing' => 'Table "<nowiki>$2</nowiki>" does not exist in database "<nowiki>$1</nowiki>."',
);

/**
 * @author Daniel Grunwell (grunny)
 */
$messages['qqq'] = array(
	'quicktools' => 'Extension name',
	'coppatool-desc' => '{{desc}}',
	'right-coppatool' => '{{doc-right|coppatool}}',
	'action-coppatool' => '{{doc-action|coppatool}}',
	'coppatool-nosuchuser' => 'Error message when a non-existent username is entered. $1 is the username that was entered.',
	'coppatool-label-username' => 'Label for username input field.',
	'coppatool-submit' => 'Text of form submit button.',
	'coppatool-disable' => 'Button text for option to disable user account. $1 is the user available for GENDER support.',
	'coppatool-reason' => 'Reason provided when taking actions. No need to translate.',
	'coppatool-form-header' => 'Header of form to take actions on user account',
	'coppatool-delete-user-pages' => 'Button text for option to delete user pages',
	'coppatool-delete-user-pages-reason' => 'Reason for the deletion logs when deleting user pages.',
	'coppatool-delete-user-pages-success' => 'Success message displayed when a deletion task has successfully been created. $1 is the task ID.',
	'coppatool-blank-user-profile' => 'Button text for option to blank user profiles',
	'coppatool-staticimagereview' => 'Button text for option to review uploads (Wiki images, Discussions images, avatars, etc.,) uploads by the given user',
	'coppatool-rename-ip' => 'Button text for option to rename IP address',
	'coppatool-rename-ip-success' => 'Success message displayed when a IP rename task has successfully been created. $1 is the task ID.',
	'coppatool-phalanx-ip' => 'Button text for option to globally block IP address',
	'coppatool-permissionerror' => 'Permission error returned by the API when user does not have permission to perform COPPA tool actions.',
	'coppatool-posterror' => "Error message returned by the API when request wasn't posted.",
	'coppatool-tokenerror' => 'Error message returned by the API when an invalid user token was provided.',
	'coppatool-invalid-ip' => 'Error message returned by the API when an invalid IP address provided.',
	'coppatool-invalid-user' => "Error message returned by API call when a user that doesn't exist is provided",
);
