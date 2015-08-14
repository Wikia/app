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

	'content-review-module-inreview-title' => 'A version of this page is waiting for a review',
	'content-review-module-inreview-description' => 'For security reasons every change made in the MediaWiki namespace has to be reviewed by a Wikia\'s staff member. This page is waiting for a review. Use the button if you want to update the version submitted for a review.',
	'content-review-module-inreview-submit' => 'Update the unreviewed changes',

	'content-review-module-submit-success-insert' => 'The changes have been submitted submitted to review.',
	'content-review-module-submit-success-update' => 'The previous unreviewed revision has been successfully updated with the changes.',
	'content-review-module-submit-success-exception' => 'Unfortunately, we could not submit the changes to review due to the following error: $1.',
	'content-review-module-submit-success-error' => 'Unfortunately, we could not submit the changes to review.',
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

	'content-review-module-submit-success-insert' => 'A message shown to a user in a Banner Notification if a page has been added to review.',
	'content-review-module-submit-success-update' => 'A message shown to a user in a Banner Notification if a page had an unreviewed version submitted and it got updated.',
	'content-review-module-submit-success-exception' => 'A message shown to a user in a Banner Notification if a known error happened. $1 is the error message.',
	'content-review-module-submit-success-error' => 'A message shown to a user in a Banner Notification if an unknown error happened.',
];
