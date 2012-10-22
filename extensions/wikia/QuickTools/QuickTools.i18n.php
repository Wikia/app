<?php
/**
 * Internationalisation for QuickTools extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Daniel Grunwell (grunny)
 */
$messages['en'] = array(
	'quicktools' => 'QuickTools',
	'quicktools-contrib-link' => 'Quick Tools',
	'quicktools-invalidtime' => 'Invalid time provided',
	'quicktools-notitles' => 'No titles to revert',
	'quicktools-success' => 'Successfully reverted edits by $1.',
	'quicktools-success-rollback' => 'Successfully reverted edits by $1.',
	'quicktools-success-delete' => 'Successfully deleted page creations by $1.',
	'quicktools-success-rollback-delete' => 'Successfully reverted and deleted edits and page creations by $1.',
	'quicktools-permissionerror' => 'You do not have the appropriate permissions to use Quick Tools.',
	'quicktools-modal-title' => 'Quick Tools &mdash; $1',
	'quicktools-rollback-all' => 'Rollback all',
	'quicktools-delete-all' => 'Delete all',
	'quicktools-revert-all' => 'Rollback and delete',
	'quicktools-block' => 'Block',
	'quicktools-block-and-revert' => 'All of the above',
	'quicktools-label-reason' => 'Reason:',
	'quicktools-label-default-reason' => 'Spam',
	'quicktools-label-time' => 'Perform actions on edits since:',
	'quicktools-label-block-length' => 'Block length:',
	'quicktools-success-block' => 'Successfully blocked $1.',
	'quicktools-bot-reason' => 'Cleanup',
	'quicktools-botflag-add' => 'Bot me',
	'quicktools-botflag-remove' => 'Unbot me',

	/* Create user page */
	'quicktools-createuserpage-link' => 'Create user page',
	'quicktools-createuserpage-reason' => 'Creating user page',
	'quicktools-createuserpage-success' => 'Successfully created page!',
	'quicktools-createuserpage-exists' => 'User page already exists!',
	'quicktools-createuserpage-error' => 'Creating page failed!',

	/* Quick Adopt */
	'quicktools-adopt-contrib-link' => 'Quick Adopt',
	'quicktools-adopt-reason' => 'Adopting Wiki',
	'quicktools-adopt-success' => 'User rights change succeeded!',
	'quicktools-adopt-error' => 'User rights change failed!',
);

/**
 * @author Daniel Grunwell (grunny)
 */
$messages['qqq'] = array(
	'quicktools' => 'Extension name',
	'quicktools-contrib-link' => 'Link name on Special:Contributions.',
	'quicktools-invalidtime' => 'Error message displayed when an invalid time is provided.',
	'quicktools-notitles' => 'Error message displayed when there are no titles to revert for the user',
	'quicktools-success' => 'Success message when the tool completes reverting the user.',
	'quicktools-success-rollback' => 'Success message when the tool completes reverting the user.',
	'quicktools-success-delete' => 'Success message when the tool completes deleting the user\'s page creations.',
	'quicktools-success-rollback-delete' => 'Success message when the tool completes reverting and deleting the user\'s edits and page creations.',
	'quicktools-permissionerror' => 'Permissions error returned by script when user does not have the appropriate rights.',
	'quicktools-modal-title' => 'The popup menu title. $1 is the user name.',
	'quicktools-rollback-all' => 'Label for button to rollback all user edits.',
	'quicktools-delete-all' => 'Label for button to delete all user page creations.',
	'quicktools-revert-all' => 'Label for button to rollback and delete all user edits and page creations.',
	'quicktools-block' => 'Label for button to block user.',
	'quicktools-block-and-revert' => 'Label for button to rollback and delete all user edits and page creations as well as block user all at once.',
	'quicktools-label-reason' => 'Label for the reason field which will be used as the revert and deletion summary.',
	'quicktools-label-default-reason' => 'Default reason for reverting and deleting.',
	'quicktools-label-time' => 'Label for timestamp to revert back to.',
	'quicktools-label-block-length' => 'Label for block expiration time.',
	'quicktools-success-block' => 'Success message when the tool successfully blocks a user. $1 is the name of the user who was blocked.',
	'quicktools-bot-reason' => 'Reason for adding bot flag',
	'quicktools-botflag-add' => 'Label for button to add bot flag',
	'quicktools-botflag-remove' => 'Label for button to remove bot flag',
	'quicktools-createuserpage-link' => 'Link in the account navigation menu to create user page.',
	'quicktools-createuserpage-reason' => 'Edit summary used when creating user page',
	'quicktools-createuserpage-success' => 'Success message displayed when user page was successfully created',
	'quicktools-createuserpage-exists' => 'Message displayed when the user page already exists',
	'quicktools-createuserpage-error' => 'Error message shown when creating user page failed',
	'quicktools-adopt-contrib-link' => 'Link name on Special:Contributions for approving adoption request for user',
	'quicktools-adopt-reason' => 'Summary used in the rights change when approving adoption request for user',
	'quicktools-adopt-success' => 'Success message displayed when user rights change was successful',
	'quicktools-adopt-error' => 'Error message displayed when user rights change failed',
);