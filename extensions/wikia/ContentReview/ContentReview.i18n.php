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

	'content-review-special-title' => 'Content Review',
	'action-content-review' => 'Content Review',
	'content-review-special-list-header-wiki-name' => 'Wiki name',
	'content-review-special-list-header-page-name' => 'Page name',
	'content-review-special-list-header-revision-id' => 'Revision id',
	'content-review-special-list-header-submit-user' => 'Submit user',
	'content-review-special-list-header-status' => 'Status',
	'content-review-special-list-header-submit-time' => 'Submit time',
	'content-review-special-list-header-reviewer' => 'Reviewer',
	'content-review-special-list-header-review-start' => 'Review start',
	'content-review-special-list-header-review-end' => 'Review end',
	'content-review-special-list-header-actions' => 'Actions',

	'content-review-special-start-review' => 'Start review',
	'content-review-special-continue-review' => 'Continue review',
	'content-review-special-review-started' => 'You have started a review process.',
	'content-review-special-review-open' => 'Please complete a review process for a previous revision first.',
	'content-review-special-error' => 'Unfortunately, an error happened.',
	'content-review-special-show-revision' => 'Show revision',
	'content-review-special-restore' => 'Restore',
	'content-review-special-guidelines' => 'Before reviewing a piece of a code, please ensure that you are familiar with the [[w:c:dev:Help:JavaScript review guidelines|Help:JavaScript review guidelines]].',

	'content-review-diff-approve' => 'Approve',
	'content-review-diff-reject' => 'Reject',
	'content-review-diff-approve-confirmation' => 'Reviewed code has been approved. Go back to [[w:c:dev:Special:ContentReview|Special:ContentReview]]',
	'content-review-diff-reject-confirmation' => 'Reviewed code has been rejected. [$1 Provide feedback] or go back to [[w:c:dev:Special:ContentReview|Special:ContentReview]]',
	'content-review-diff-page-error' => 'Something went wrong. Please try again later.',
	'content-review-diff-already-done' => 'You are trying to make changes to the revision that isn\'t in review anymore.',

	'content-review-diff-toolbar-title' => 'Revision review',
	'content-review-diff-toolbar-talkpage' => 'Talk page',
	'content-review-diff-toolbar-guidelines' => 'Reviewer guidelines',
	'content-review-diff-toolbar-guidelines-url' => 'http://dev.wikia.com/wiki/Help:JavaScript_review_guidelines',

	'content-review-status-unreviewed' => 'Unreviewed',
	'content-review-status-in-review' => 'In review',
	'content-review-status-approved' => 'Approved',
	'content-review-status-rejected' => 'Rejected',
	'content-review-status-live' => 'Live',

	'content-review-feedback-link-text' => 'Provide feedback',
	'content-review-rejection-explanation' => '==Submitted script change rejected==
The recently submitted change to this JS script was rejected by the Wikia review process. Please make sure you meet the [[Help:JavaScript review process|Custom JavaScript guidelines]].',

	'content-review-status-link-text' => 'Review status',
	'content-review-edit-page-checkbox-label' => 'Automatically approve the changes',
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
	'content-review-module-status-approved' => 'Message shown as a revision\'s status if ',
	'content-review-module-status-rejected' => 'was rejected',

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

	'content-review-special-title' => 'Title for special page',
	'action-content-review' => 'Title for permissions',
	'content-review-special-list-header-wiki-name' => 'A column name for a Wiki name',
	'content-review-special-list-header-page-name' => 'A column name for a Page name',
	'content-review-special-list-header-revision-id' => 'A column name for a Revision id',
	'content-review-special-list-header-submit-user' => 'A column name for a Submit user',
	'content-review-special-list-header-status' => 'A column name for a Status',
	'content-review-special-list-header-submit-time' => 'A column name for a Submit time',
	'content-review-special-list-header-reviewer' => 'A column name for a Reviewer name',
	'content-review-special-list-header-review-start' => 'A column name for a Review start',
	'content-review-special-list-header-review-end' => 'A column name for a Review end',
	'content-review-special-list-header-actions' => 'A column name for Actions',

	'content-review-special-start-review' => 'Text on button to start review',
	'content-review-special-continue-review' => 'Text on button to continue review',
	'content-review-special-review-started' => 'A message shown when user starts new review process.',
	'content-review-special-review-open' => 'A message shown when another review for the page is in progress and ask user to complete that first.',
	'content-review-special-error' => 'Information that some error occurs.',
	'content-review-special-show-revision' => 'Text on button to show revision',
	'content-review-special-restore' => 'Text on button to restore revision',
	'content-review-special-guidelines' => 'A message shown on the ContentReview special page with an information about the reviewing guidelines being available and required to aware of when performing a review.',

	'content-review-diff-approve' => 'A text of a button which clicked approves a given revision.',
	'content-review-diff-reject' => 'A text of a button which clicked rejects a given revision.',
	'content-review-diff-approve-confirmation' => 'A message shown in a Banner Notification after a click on the approve button if everything went well.',
	'content-review-diff-reject-confirmation' => 'A message shown in a Banner Notification after click reject button if everything went well.',
	'content-review-diff-page-error' => 'A message shown in a Banner Notification when something go wrong on diff page.',

	'content-review-diff-toolbar-title' => 'A title of a toolbar that enables a reviewer to approve or reject a revision.',
	'content-review-diff-toolbar-talkpage' => 'A text of a link to a talk page of a page that is being reviewed.',
	'content-review-diff-toolbar-guidelines' => 'A text of a link to a page with guidelines for reviewers.',
	'content-review-diff-toolbar-guidelines-url' => 'A URL of a page with guidelines for reviewers.',

	'content-review-feedback-link-text' => 'Text on a link for providing feedback on script change being reviewed',
	'content-review-rejection-explanation' => 'Standard explanation response when script changes were rejected. This text is a prefill to script talk page when reviewer is redirected there to provide feedback on rejection.',

	'content-review-status-unreviewed' => 'A name of a status of a revision that has not yet been reviewed.',
	'content-review-status-in-review' => 'A name of a status of a revision that is being reviewed.',
	'content-review-status-approved' => 'A name of a status of a revision that has been approved.',
	'content-review-status-rejected' => 'A name of a status of a revision that has been rejected.',
	'content-review-status-live' => 'A name of a status of a revision that is currently live',

	'content-review-status-link-text' => 'Text on entrypoint link to show content review module with review status info and submit for review buttons',
	'content-review-edit-page-checkbox-label' => 'A label for a checkbox that if checked causes changes made by an authorized user to be automatically approved.',
];
