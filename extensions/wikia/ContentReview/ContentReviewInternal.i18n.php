<?php

$messages = [];

/**
 * English (en)
 */
$messages['en'] = [
	'content-review-special-title' => 'Content Review',
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
	'content-review-special-guidelines' => 'Before reviewing a piece of a code, please ensure that you are familiar with the [[w:c:dev:Help:JavaScript review guidelines|Help:JavaScript review guidelines]].

        To view an archive of completed reviews for a single community click on its name in the Wiki Name column.',
	'content-review-special-archive-back-link' => '< Back to Special:ContentReview',

	'content-review-diff-approve' => 'Approve',
	'content-review-diff-reject' => 'Reject',
	'content-review-diff-escalate' => 'Escalate!',
	'content-review-diff-revision-escalated' => '(escalated)',
	'content-review-diff-approve-confirmation' => 'Reviewed code has been approved. Go back to [[w:c:dev:Special:ContentReview|Special:ContentReview]]',
	'content-review-diff-reject-confirmation' => 'Reviewed code has been rejected. [$1 Provide feedback] or go back to [[w:c:dev:Special:ContentReview|Special:ContentReview]]',
	'content-review-diff-escalate-confirmation' => 'The review has been escalated and developers were notified. You can monitor the #js-review-tool Slack channel.',
	'content-review-diff-page-error' => 'Something went wrong. Please try again later.',
	'content-review-diff-already-done' => 'You are trying to make changes to the revision that isn\'t in review anymore.',

	'content-review-diff-toolbar-title' => 'Revision review',
	'content-review-diff-toolbar-talkpage' => 'Talk page',
	'content-review-diff-toolbar-guidelines' => 'Reviewer guidelines',
	'content-review-diff-toolbar-guidelines-url' => 'http://dev.wikia.com/wiki/Help:JavaScript_review_guidelines',
	'content-review-diff-hidden' => 'Since no revision of this page has been approved yet, the diff is hidden. Please review the changes based on the latest revision state below.',

	'content-review-feedback-link-text' => 'Provide feedback',
	'content-review-edit-page-checkbox-label' => 'Automatically approve the changes',
];

/**
 * Documentation (qqq)
 */
$messages['qqq'] = [
	'content-review-special-title' => 'Title for special page',
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
	'content-review-special-archive-back-link' => 'A text of a link back to Special:ContentReview that is displayed on an archive subpage.',

	'content-review-diff-approve' => 'A text of a button which clicked approves a given revision.',
	'content-review-diff-reject' => 'A text of a button which clicked rejects a given revision.',
	'content-review-diff-approve-confirmation' => 'A message shown in a Banner Notification after a click on the approve button if everything went well.',
	'content-review-diff-reject-confirmation' => 'A message shown in a Banner Notification after click reject button if everything went well.',
	'content-review-diff-page-error' => 'A message shown in a Banner Notification when something go wrong on diff page.',
	'content-review-diff-already-done' => 'A message shown to reviewers if they try to review an already reviewed revision.',
	'content-review-diff-escalate' => 'The text of the button to escalate a given revision for further review.',
	'content-review-diff-revision-escalated' => 'Text that shown when a given revision has been escalated.',
	'content-review-diff-escalate-confirmation' => 'The message shown in a Banner Notification after clicking the escalate button if everything went well.',

	'content-review-diff-toolbar-title' => 'A title of a toolbar that enables a reviewer to approve or reject a revision.',
	'content-review-diff-toolbar-talkpage' => 'A text of a link to a talk page of a page that is being reviewed.',
	'content-review-diff-toolbar-guidelines' => 'A text of a link to a page with guidelines for reviewers.',
	'content-review-diff-toolbar-guidelines-url' => 'A URL of a page with guidelines for reviewers.',
	'content-review-diff-hidden' => 'A message shown to a reviewer if he is reviewing a page that does not have an initial revision. In this case the regular diff view is hidden and replaced by this message to focus them on an actual content that they review.',

	'content-review-feedback-link-text' => 'Text on a link for providing feedback on script change being reviewed',

	'content-review-edit-page-checkbox-label' => 'A label for a checkbox that if checked causes changes made by an authorized user to be automatically approved.',
];
