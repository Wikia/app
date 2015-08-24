<?php

$messages = [];

/**
 * English (en)
 */
$messages['en'] = [
	'content-review-desc' => 'After a major exploit of customizable JavaScript we can no longer allow for unreviewed code to be executed on wikia\'s pages. This extension is the control room for code reviewing.',

	'content-review-module-unreviewed-title' => 'This page has unreviewed changes',
	'content-review-module-unreviewed-description' => 'For security reasons every change made in the MediaWiki namespace has to be reviewed by a Wikia\'s staff member. For development you can use the unreviewed version, however it is not going to be served to other users that are not in the development mode.',
	'content-review-module-unreviewed-submit' => 'Submit page for a review',
	'content-review-module-enable-test-mode' => 'Enable Test Mode',
	'content-review-module-disable-test-mode' => 'Disable Test Mode',

	'content-review-module-inreview-title' => 'A version of this page is waiting for a review',
	'content-review-module-inreview-description' => 'For security reasons every change made in the MediaWiki namespace has to be reviewed by a Wikia\'s staff member. This page is waiting for a review. Use the button if you want to update the version submitted for a review.',
	'content-review-module-inreview-submit' => 'Update the unreviewed changes',

	'content-review-module-current-title' => 'The current version of this page is waiting for a review',
	'content-review-module-current-description' => 'For security reasons every change made in the MediaWiki namespace has to be reviewed by a Wikia\'s staff member. The current version page is waiting for a review.',

	'content-review-test-mode-disable' => 'Disable Test Mode',
	'content-review-test-mode-error' => 'Something went wrong. Please try again later.',
	'content-review-test-mode-enabled' => 'You are now in test mode.',

	'content-review-module-submit-success-unreviewed' => 'The changes have been successfully submitted for a review.',
	'content-review-module-submit-success-inreview' => 'The previous unreviewed revision has been successfully updated with the changes.',
	'content-review-module-submit-exception' => 'Unfortunately, we could not submit the changes for a review due to the following error: $1.',
	'content-review-module-submit-error' => 'Unfortunately, we could not submit the changes for a review.',

	'content-review-wrong-rights' => 'Sorry, you do not have access!',

	'contentreview' => 'Content Review',
	'content-review-special-list-header-wiki-name' => 'Wiki name',
	'content-review-special-list-header-page-name' => 'Page name',
	'content-review-special-list-header-revision-id' => 'Revision id',
	'content-review-special-list-header-submit-user' => 'Submit user',
	'content-review-special-list-header-status' => 'Status',
	'content-review-special-list-header-submit-time' => 'Submit time',
	'content-review-special-list-header-reviewer' => 'Reviewer id',
	'content-review-special-list-header-review-start' => 'Review start',
	'content-review-special-list-header-actions' => 'Actions',
	'content-review-icons-actions-diff' => 'Start review',

	'content-review-diff-approve' => 'Approve',
	'content-review-diff-reject' => 'Reject',
	'content-review-diff-approve-confirmation' => 'Reviewed code has been approved.',
	'content-review-diff-reject-confirmation' => 'Reviewed code has been rejected.',
	'content-review-diff-page-error' => 'Something went wrong. Please try again later.',

	'content-review-status-unreviewed' => 'Unreviewed',
	'content-review-status-in-review' => 'In review',
	'content-review-status-approved' => 'Approved',
	'content-review-status-rejected' => 'Rejected,',
];

/**
 * Documentation (qqq)
 */
$messages['qqq'] = [
	'content-review-desc' => '{{desc}}',

	'content-review-module-unreviewed-title' => 'Title of a the right rail module with a button to submit a page to review.',
	'content-review-module-unreviewed-description' => 'The content of the right rail module explaining that the current version of a page has not been reviewed.',
	'content-review-module-unreviewed-submit' => 'Text of a button that sends a page to review.',

	'content-review-module-inreview-title' => 'Title of a the right rail module with a button to update a version of a page already sent for a review.',
	'content-review-module-inreview-description' => 'The content of the right rail module explaining that a page is awaiting a review and that a user can update the submitted code with the current changes.',
	'content-review-module-inreview-submit' => 'Text of a button that updates the version submitted for a review.',

	'content-review-module-current-title' => 'Title of a the right rail module on a page already sent for a review with the current version.',
	'content-review-module-current-description' => 'The content of the right rail module explaining that the current version of a page is awaiting for a review.',

	'content-review-module-submit-success-insert' => 'A message shown to a user in a Banner Notification if a page has been added to review.',
	'content-review-module-submit-success-update' => 'A message shown to a user in a Banner Notification if a page had an unreviewed version submitted and it got updated.',
	'content-review-module-submit-success-exception' => 'A message shown to a user in a Banner Notification if a known error happened. $1 is the error message.',
	'content-review-module-submit-success-error' => 'A message shown to a user in a Banner Notification if an unknown error happened.',

	'content-review-wrong-rights' => 'A message shown when user do not have rights',

	'content-review-special-title' => 'Content Review',
	'content-review-special-list-header-wiki-name' => 'A column name for a Wiki name',
	'content-review-special-list-header-page-name' => 'A column name for a Page name',
	'content-review-special-list-header-revision-id' => 'A column name for a Revision id',
	'content-review-special-list-header-submit-user' => 'A column name for a Submit user',
	'content-review-special-list-header-status' => 'A column name for a Status',
	'content-review-special-list-header-submit-time' => 'A column name for a Submit time',
	'content-review-special-list-header-reviewer' => 'A column name for a Reviewer id',
	'content-review-special-list-header-review-start' => 'A column name for a Review start',
	'content-review-special-list-header-actions' => 'A column name for Actions',
	'content-review-icons-actions-diff' => 'Button text start review',

	'content-review-diff-approve-confirmation' => 'A message shown after click approve button.',
	'content-review-diff-reject-confirmation' => 'A message shown after click reject button.',
	'content-review-diff-page-error' => 'A message shown when something go wrong on diff page.',

	'content-review-status-unreviewed' => 'Status Unreviewed',
	'content-review-status-in-review' => 'Status In review',
	'content-review-status-approved' => 'Status Approved',
	'content-review-status-rejected' => 'Status Rejected,'
];
