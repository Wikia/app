<?php

$messages = array();

$messages['en'] = array(
	'phalanx' => 'Phalanx - Integrated Spam Defense Mechanism',
	'phalanx-type-content' => 'article content',
	'phalanx-type-summary' => 'article summary',
	'phalanx-type-title' => 'article title',
	'phalanx-type-user' => 'user',
	'phalanx-type-answers-question' => 'question title',
	'phalanx-type-answers-words' => 'recent questions',
	'phalanx-type-wiki-creation' => 'wiki creation',
	'phalanx-add-block' => 'Apply Block',
	'phalanx-edit-block' => 'Save Block',
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
	'phalanx-expire-durations' => '1 hour,2 hours,4 hours,6 hours,1 day,3 days,1 week,2 weeks,1 month,3 months,6 months,1 year,infinite',
	'phalanx-format-text' => 'plain text',
	'phalanx-format-regex' => 'regex',
	'phalanx-format-case' => 'case sensitive',
	'phalanx-format-exact' => 'exact',
	'phalanx-or' => ' or ',
	'phalanx-tab-main' => 'Manage Filters',
	'phalanx-tab-secondary' => 'Test Filters',
	'phalanx-reason-ip' => 'This IP address is prevented from editing due to vandalism or other disruption by you or by someone who shares your IP address. If you believe this is in error, please $1',
	'phalanx-reason-name' => 'This username is prevented from editing due to vandalism or other disruption. If you believe this is in error, please $1',
	'phalanx-reason-regex' => 'This username is prevented from editing due to vandalism or other disruption by a user with a similar name. Please create an alternate user name or $1 about the problem.',
	'phalanx-block-success' => 'The block was successfully added',
	'phalanx-modify-success' => 'The block was successfully updated',
	'phalanx-block-failure' => 'There was an error during adding the block',
	'phalanx-modify-success' => 'The block was successfully modified',
	'phalanx-modify-failure' => 'There was an error modifying the block',
	'phalanx-modify-warning' => 'YOU ARE EDITING BLOCK ID #$1. HITTING APPLY WILL SAVE YOUR CHANGES',
	'phalanx-test-description' => 'Test provided text against current blocks.',
	'phalanx-test-submit' => 'Test',
	'phalanx-content-spam-summary' => "The text was found in the page's summary.",
	'phalanx-display-regex' => '(regex)',
	'phalanx-display-text' => '(plain text)',
	'phalanx-display-case' => '(case-sensitive)',
	'phalanx-display-blocked' => ' blocked by: ',
	'phalanx-display-reason' => ' reason: ',
	'phalanx-display-on' => 'on ',
	'phalanx-link-unblock' => 'unblock',
	'phalanx-link-modify' => 'modify',
	'phalanx-link-stats' => 'stats',
	'phalanx-reset-form' => 'Reset Form',

	'phalanx-legend-input' => 'Create or Modify Filter',
	'phalanx-legend-listing' => 'Currently applied filters',
	'phalanx-unblock-message' => 'Block ID #$1 was successfully removed',

	'phalanx-help-type-content' => 'This filter prevents an edit from being saved, if its content matches any of the blacklisted phrases.',
	'phalanx-help-type-summary' => 'This filter prevents an edit from being saved, if the summary given matches any of the blacklisted phrases.',
	'phalanx-help-type-title' => 'This filter prevents a page from being created, if its title matches any of the blacklisted phrases.
	 
	 It does not prevent a pre-existing page from being edited.',
	'phalanx-help-type-user' => 'This filter blocks a user (exactly the same as a local MediaWiki block), if the name or IP matches one of the blacklisted names or IPs.',
	'phalanx-help-type-wiki-creation' => 'This filter prevents a wiki from being created, if its name or URL matches any blacklisted phrase.',
	'phalanx-help-type-answers-question' => 'This filter blocks a question (page) from being created, if its title matches any of the blacklisted phrases. 
	 
	 Note: only works on Answers-type wikis',
	'phalanx-help-type-answers-words' => 'This filter prevents questions (pages) from being displayed in a number of outputs (widgets, lists, tag-generated listings). It does not prevent those articles from being created.
	
	Note: works only on Answers-type wiks',

	'phalanx-user-block-reason-ip' => 'This IP address is prevented from editing due to vandalism or other disruption by you or by someone who shares your IP address. If you believe this is in error, please [[Special:Contact|contact Wikia]]',
	'phalanx-user-block-reason-exact' => 'This username is prevented from editing due to vandalism or other disruption. If you believe this is in error, please [[Special:Contact|contact Wikia]]',
	'phalanx-user-block-reason-similar' => 'This username is prevented from editing due to vandalism or other disruption by a user with a similar name. Please create an alternate user name or [[Special:Contact|contact Wikia]] about the problem.',

	'phalanx-title-move-summary' => 'The reason you entered contained a blocked phrase.',

	'phalanx-stats-row' => '<b>$4</b> filter type <b>$1</b> blocked user <b>$2</b> on <a href="$3">$3</a>',
	'phalanx-stats-block-notfound' => 'block id not found',
);
