<?php

$messages = array();

$messages['en'] = array(
	'userrollback-desc' => 'Allows staff to quickly revert all edits by specified user on all wikis',
	'userrollback-specialpage-title' => 'Rollback edits in bulk',
	'userrollback-form-intro' => 'Special page allows to quickly revert multiple edits by specified users from all affected wikis.',
	'userrollback-form-users' => 'User names',
	'userrollback-form-time' => 'Starting time point',
	'userrollback-form-time-hint' => 'Provide date and time in the following format: <i>2008-04-20 10:00:00</i>',
	'userrollback-form-priority' => 'Priority',
	'userrollback-form-priority-normal' => 'Normal priority',
	'userrollback-form-priority-high' => 'High priority',
	'userrollback-form-submit' => 'Submit',
	'userrollback-form-confirmation' => 'Clicking "{{int:userrollback-form-confirm}}" will enqueue the background process.<br />Are these information correct?',
	'userrollback-form-user-id' => 'user id: $1',
	'userrollback-form-confirm' => 'Confirm',
	'userrollback-form-back' => 'Back',
	'userrollback-user-not-found' => 'User "$1" was not found.',
	'userrollback-no-user-specified' => 'At least one user must be provided.',
	'userrollback-invalid-time' => 'Invalid time provided.',
	'userrollback-task-added' => 'Background task has been added to revert edits by these users. Further information can be found in TaskManager log.',
	'userrollback-task-add-error' => 'These was an error in adding the background task to fulfill the request.',
);
