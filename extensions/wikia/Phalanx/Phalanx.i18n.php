<?php

$messages = array();

$messages['en'] = array(
	'phalanx' => 'Phalanx - Integrated Spam Defense Mechanism',
	'phalanx-type-content' => 'page content',
	'phalanx-type-summary' => 'page summary',
	'phalanx-type-title' => 'page title',
	'phalanx-type-user' => 'user',
	'phalanx-type-answers-question-title' => 'question title',
	'phalanx-type-answers-recent-questions' => 'recent questions',
	'phalanx-type-wiki-creation' => 'wiki creation',
	'phalanx-add-block' => 'Apply block',
	'phalanx-edit-block' => 'Save block',
	'phalanx-label-filter' => 'Filter:',
	'phalanx-label-reason' => 'Reason:',
	'phalanx-label-expiry' => 'Expiry:',
	'phalanx-label-type' => 'Type:',
	'phalanx-label-lang' => 'Language:',
	'phalanx-view-type' => 'Type of block...',
	'phalanx-view-blocker' => 'Search by filter text:',
	'phalanx-view-blocks' => 'Search filters',
	'phalanx-view-id' => 'Get filter by ID:',
	'phalanx-view-id-submit' => 'Get filter',
	'phalanx-expire-durations' => '1 hour,2 hours,4 hours,6 hours,1 day,3 days,1 week,2 weeks,1 month,3 months,6 months,1 year,infinite', // FIXME: no L10n possible; see core block/protect implementations for proper solution.
	'phalanx-format-text' => 'plain text',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'case sensitive',
	'phalanx-format-exact' => 'exact',
	'phalanx-tab-main' => 'Manage Filters',
	'phalanx-tab-secondary' => 'Test Filters',

	'phalanx-block-success' => 'The block was successfully added',
	'phalanx-block-failure' => 'There was an error during adding the block',
	'phalanx-modify-success' => 'The block was successfully modified',
	'phalanx-modify-failure' => 'There was an error modifying the block',
	'phalanx-modify-warning' => 'You are editing block ID #$1.
Clicking "{{int:phalanx-add-block}}" will save your changes!',
	'phalanx-test-description' => 'Test provided text against current blocks.',
	'phalanx-test-submit' => 'Test',
	'phalanx-test-results-legend' => 'Test results',
	'phalanx-display-row-blocks' => 'blocks: $1',
	'phalanx-display-row-created' => "created by '''$1''' on $2",

	'phalanx-link-unblock' => 'unblock',
	'phalanx-link-modify' => 'modify',
	'phalanx-link-stats' => 'stats',
	'phalanx-reset-form' => 'Reset form',

	'phalanx-legend-input' => 'Create or modify filter',
	'phalanx-legend-listing' => 'Currently applied filters',
	'phalanx-unblock-message' => 'Block ID #$1 was successfully removed',

	'phalanx-help-type-content' => 'This filter prevents an edit from being saved, if its content matches any of the blacklisted phrases.',
	'phalanx-help-type-summary' => 'This filter prevents an edit from being saved, if the summary given matches any of the blacklisted phrases.',
	'phalanx-help-type-title' => 'This filter prevents a page from being created, if its title matches any of the blacklisted phrases.

	 It does not prevent a pre-existing page from being edited.',
	'phalanx-help-type-user' => 'This filter blocks a user (exactly the same as a local MediaWiki block), if the name or IP address matches one of the blacklisted names or IP addresses.',
	'phalanx-help-type-wiki-creation' => 'This filter prevents a wiki from being created, if its name or URL matches any blacklisted phrase.',
	'phalanx-help-type-answers-question-title' => 'This filter blocks a question (page) from being created, if its title matches any of the blacklisted phrases.

	 Note: only works on Answers-type wikis',
	'phalanx-help-type-answers-recent-questions' => 'This filter prevents questions (pages) from being displayed in a number of outputs (widgets, lists, tag-generated listings).
It does not prevent those pages from being created.

Note: works only on Answers-type wiks',

	'phalanx-user-block-reason-ip' => 'This IP address is prevented from editing due to vandalism or other disruption by you or by someone who shares your IP address.
If you believe this is in error, please [[Special:Contact|contact Wikia]].',
	'phalanx-user-block-reason-exact' => 'This username or IP address is prevented from editing due to vandalism or other disruption.
If you believe this is in error, please [[Special:Contact|contact Wikia]].',
	'phalanx-user-block-reason-similar' => 'This username is prevented from editing due to vandalism or other disruption by a user with a similar name.
Please create an alternate user name or [[Special:Contact|contact Wikia]] about the problem.',

	'phalanx-title-move-summary' => 'The reason you entered contained a blocked phrase.',
	'phalanx-content-spam-summary' => "The text was found in the page's summary.",

	'phalanx-stats-title' => 'Phalanx Stats',
	'phalanx-stats-block-notfound' => 'block ID not found',
	'phalanx-stats-table-id' => 'Block ID',
	'phalanx-stats-table-user' => 'Added by',
	'phalanx-stats-table-type' => 'Type',
	'phalanx-stats-table-create' => 'Created',
	'phalanx-stats-table-expire' => 'Expires',
	'phalanx-stats-table-exact' => 'Exact',
	'phalanx-stats-table-regex' => 'Regex',
	'phalanx-stats-table-case' => 'Case',
	'phalanx-stats-table-language' => 'Language',
	'phalanx-stats-table-text' => 'Text',
	'phalanx-stats-table-reason' => 'Reason',
	'phalanx-stats-row' => "at $4, filter type '''$1''' blocked '''$2''' on $3",
	'phalanx-stats-row-per-wiki' => "user '''$2''' was blocked on '''$4''' by filter ID '''$3''' ($5) (type: '''$1''')",

	'phalanx-rule-log-name' => 'Phalanx rules log',
	'phalanx-rule-log-header' => 'This is a log of changes to phalanx rules.',
	'phalanx-rule-log-add' => 'Phalanx rule added: $1',
	'phalanx-rule-log-edit' => 'Phalanx rule edited: $1',
	'phalanx-rule-log-delete' => 'Phalanx rule deleted: $1',
	'phalanx-rule-log-details' => 'Filter: "$1", type: "$2", reason: "$3"',
	
	'phalanx-stats-table-wiki-id' => 'Wiki ID',
	'phalanx-stats-table-wiki-name' => 'Wiki Name',
	'phalanx-stats-table-wiki-url' => 'Wiki Url',
	'phalanx-stats-table-wiki-last-edited' => 'Last edited',
);
