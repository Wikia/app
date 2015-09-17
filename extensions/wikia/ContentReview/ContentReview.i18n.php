<?php

$messages = [];

/**
 * English (en)
 */
$messages['en'] = [
	'content-review-desc' => 'This extension creates a process by which community JavaScript is manually reviewed before it goes live for visitors.',
	'content-review-module-title' => 'Custom JavaScript status',

	'content-review-module-header-latest' => 'Latest revision:',
	'content-review-module-header-last' => 'Last reviewed revision:',
	'content-review-module-header-live' => 'Live revision:',

	'content-review-module-status-none' => 'None',
	'content-review-module-status-unsubmitted' => 'needs to be submitted',
	'content-review-module-status-live' => 'is live!',
	'content-review-module-status-awaiting' => 'is awaiting review',
	'content-review-module-status-approved' => 'was approved',
	'content-review-module-status-rejected' => 'was rejected',

	'content-review-rejection-reason-link' => 'Why?',

	'content-review-module-help' => '[[Help:CSS and JS customization|Help]]',
	'content-review-module-help-article' => 'Help:CSS and JS customization',
	'content-review-module-help-text' => 'Help',

	'content-review-module-submit' => 'Submit for review',
	'content-review-module-submit-success' => 'The changes have been successfully submitted for a review.',
	'content-review-module-submit-exception' => 'Unfortunately, we could not submit the changes for a review due to the following error: $1.',
	'content-review-module-submit-error' => 'Unfortunately, we could not submit the changes for a review.',

	'content-review-module-test-mode-enable' => 'Enter test mode',
	'content-review-module-test-mode-disable' => 'Exit test mode',
	'content-review-test-mode-error' => 'Something went wrong. Please try again later.',
	'content-review-test-mode-enabled' => 'You are currently using unreviewed versions of custom JavaScript files. ',

	'action-content-review' => 'Content Review',

	'content-review-restore-summary' => 'Reverting page to revision $1',

	'content-review-status-unreviewed' => 'Unreviewed',
	'content-review-status-in-review' => 'In review',
	'content-review-status-approved' => 'Approved',
	'content-review-status-rejected' => 'Rejected',
	'content-review-status-live' => 'Live',

	'content-review-rejection-explanation' => '==Submitted script change rejected==
The recently submitted change to this JS script was rejected by the Wikia review process. Please make sure you meet the [[Help:JavaScript review process|Custom JavaScript guidelines]].',

	'content-review-status-link-text' => 'Review status',
];

/**
 * Documentation (qqq)
 */
$messages['qqq'] = [
	'content-review-desc' => '{{desc}}',
	'content-review-module-title' => 'Title of a the right rail module with information on a page status.',

	'content-review-module-header-latest' => 'Header of a section of the right rail module with information on the latest revision submitted for a review.',
	'content-review-module-header-last' => 'Header of a section of the right rail module with information on the last reviewed revision.',
	'content-review-module-header-live' => 'Header of a section of the right rail module with information on the revision that is currently live and served to users.',

	'content-review-module-status-none' => 'Message shown as a revision\'s status when there is no information on it.',
	'content-review-module-status-unsubmitted' => 'Message shown as a revision\'s status when the latest made revision has not yet been sent for a review.',
	'content-review-module-status-live' => 'Message shown as a revision\'s status when it is currently live and served to users.',
	'content-review-module-status-awaiting' => 'Message shown as a revision\'s status when a revision is waiting for a review.',
	'content-review-module-status-approved' => 'Message shown as a revision\'s status if a revision was approved.',
	'content-review-module-status-rejected' => 'Message shown as a revision\'s status if a revision was rejected',

	'content-review-rejection-reason-link' => 'Text of a link that leads a users to a Talk page with an explanation on why their code was rejected.',

	'content-review-module-help' => 'A link to a Help page explaining how the review system works.',
	'content-review-module-help-article' => 'Article name to a Help page explaining how the review system works.',
	'content-review-module-help-text' => 'Text shown on a link a Help page explaining how the review system works.',

	'content-review-module-submit' => 'A text of a button that sends a given page for a review.',
	'content-review-module-submit-success' => 'A message shown to a user in a Banner Notification if a page has been added to review.',
	'content-review-module-submit-exception' => 'A message shown to a user in a Banner Notification if a known error happened. $1 is the error message.',
	'content-review-module-submit-error' => 'A message shown to a user in a Banner Notification if an unknown error happened.',

	'content-review-module-test-mode-enable' => 'A text of a button which clicked enables user to test unreviewed changes made in JavaScript articles.',
	'content-review-module-test-mode-disable' => 'A text of a link that disables serving unreviewed JavaScript to a user. Shown in a Banner Notification and right module.',
	'content-review-test-mode-error' => 'A message shown if there was a problem with enabling the test mode to a user.',
	'content-review-test-mode-enabled' => 'A message shown in Banner Notification with an information that a user is curently being served unreviewed JavaScript pages.',

	'action-content-review' => 'Title for permissions',

	'content-review-restore-summary' => 'A default, prefilled summary for an action of restoring a revision of a page. $1 is the ID number of the revision.',

	'content-review-status-unreviewed' => 'A name of a status of a revision that has not yet been reviewed.',
	'content-review-status-in-review' => 'A name of a status of a revision that is being reviewed.',
	'content-review-status-approved' => 'A name of a status of a revision that has been approved.',
	'content-review-status-rejected' => 'A name of a status of a revision that has been rejected.',
	'content-review-status-live' => 'A name of a status of a revision that is currently live',

	'content-review-rejection-explanation' => 'Standard explanation response when script changes were rejected. This text is a prefill to script talk page when reviewer is redirected there to provide feedback on rejection.',

	'content-review-status-link-text' => 'Text on entrypoint link to show content review module with review status info and submit for review buttons',
];
