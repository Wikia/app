<?php
/**
 * Internationalisation file for the WikiaDotCom extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'managewikiahome' => 'Manage Wikia Home',
	'manage-wikia-home-wrong-rights' => "You are probably logged-out or you don't have permissions to use this special page.",

	'manage-wikia-home-wikis-in-slots-heading' => 'Slots setup',
	'manage-wikia-home-wikis-in-slots-total' => 'Total amount of slots: ',
	'manage-wikia-home-visualization-wikis' => 'Corporate wikis with visualization: ',
	'manage-wikia-home-wikis-in-slots-change-reason' => 'Wikia Home Page Staff Tool change',

	'manage-wikia-home-wikis-in-slots-success' => 'Numbers slots has been changed.',

	'manage-wikia-home-verticals-proportions' => 'Number of wikis for each vertical in WV',
	'manage-wikia-home-hot-new-numbers' => 'Number of hot/new wikis in WV',

	'manage-wikia-home-slot-type-hot-wikis' => 'Number of Hot wikis',
	'manage-wikia-home-slot-type-new-wikis' => 'Number of New wikis',

	'manage-wikia-home-error-invalid-total-no-of-slots' => "Invalid slots amount in total ($1). Please make sure sum of each hub's slots equals total amount of slots ($2).",
	'manage-wikia-home-error-exceeded-total-no-of-slots' => "Invalid slots amount for new and hot wikis. Please make sure neither hot nor new slots exceed total amount of slots ($1).",
	'manage-wikia-home-error-negative-slots-number-not-allowed' => 'Negative number of slots is not allowed',
	'manage-wikia-home-error-wikifactory-failure' => "Something wrong happened during saving the variables all of them wasn't saved or they were saved partly. Try again.",

	'manage-wikia-home-change-button' => 'Change',

	'manage-wikia-home-wikis-in-visualization-heading' => 'List of wikis in visualization',
	'manage-wikia-home-wiki-name-filter' => 'Start typing wiki name and the list will get shorter:',

	'manage-wikia-home-wiki-list-id' => 'Id',
	'manage-wikia-home-wiki-list-vertical' => 'Vertical',
	'manage-wikia-home-wiki-list-headline' => 'Headline',
	'manage-wikia-home-wiki-list-blocked' => 'Blocked',
	'manage-wikia-home-wiki-list-promoted' => 'Promoted',
	'manage-wikia-home-wiki-list-blocked-no' => 'No',
	'manage-wikia-home-wiki-list-blocked-yes' => 'Yes',

	'manage-wikia-home-modal-title' => 'Change wiki status',
	'manage-wikia-home-modal-content-blocked' => 'Do you want to include this wiki in the wiki visualization?',
	'manage-wikia-home-modal-content-unblocked' => 'Do you want to exclude this wiki from appearing in the wiki visualization?',
	'manage-wikia-home-modal-content-promoted' => 'Do you want to promote this wiki in the wiki visualization?',
	'manage-wikia-home-modal-content-demoted' => 'Do you want to demote this wiki in the wiki visualization?',
	'manage-wikia-home-modal-button-no' => 'No',
	'manage-wikia-home-modal-button-yes' => 'Yes',
);

$messages['de'] = array(
);

$messages['qqq'] = array(
	'manage-wikia-home-special-title' => 'Title of Wikia Home Staff Tool special page',
	'manage-wikia-home-wrong-rights' => "A message displayed to a user if he doesn't have rights to use this special page",

	'manage-wikia-home-error-invalid-total-no-of-slots' => "An error which is displayed when set numbers in total doesn't equal required number of all slots; first parameter is the sum of entered numbers and second one is the required number",

	'manage-wikia-home-wikis-in-visualization-heading' => "A heading above table with wikis' data",
	'manage-wikia-home-wiki-name-filter' => 'Text above filtering input text describing what the input text is for',

	'manage-wikia-home-wiki-list-id' => 'WikiList table header Id column name',
	'manage-wikia-home-wiki-list-vertical' => 'WikiList table header Vertical column name',
	'manage-wikia-home-wiki-list-headline' => 'WikiList table header Headline column name',
	'manage-wikia-home-wiki-list-blocked' => 'WikiList table header Blocked column name',
	'manage-wikia-home-wiki-list-promoted' => 'WikiList table header Promoted column name',
	'manage-wikia-home-wiki-list-blocked-no' => '\'No\' in column Blocked on table',
	'manage-wikia-home-wiki-list-blocked-yes' => '\'Yes\' in column Blocked on table',

	'manage-wikia-home-modal-title' => 'blocking/unblocking/promoting/demoting modal title',
	'manage-wikia-home-modal-content-blocked' => 'change wiki status question (when wiki is blocked)',
	'manage-wikia-home-modal-content-unblocked' => 'change wiki status question (when wiki is unblocked)',
	'manage-wikia-home-modal-content-promoted' => 'change wiki status question (when wiki is promoted)',
	'manage-wikia-home-modal-content-demoted' => 'change wiki status question (when wiki is demoted)',
	'manage-wikia-home-modal-button-no' => '\'No\' button on blocking/unblocking modal',
	'manage-wikia-home-modal-button-yes' => '\'Yes\' button on blocking/unblocking modal',
);