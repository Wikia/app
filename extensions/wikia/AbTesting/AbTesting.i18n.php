<?php
/**
 * Internationalisation file for AbTesting extension.
 *
 * @addtogroup Extensions
 */

$messages = [];

$messages['en'] = [
	'abtesting' => 'A/B Testing',
	'abtesting-desc' => 'The A/B Testing extension is used by Wikia to test what effects different features or settings have on actual users.',
	'abtesting-currently-used-ga-slots' => 'List of currently used GA slots: $1',
	'abtesting-currently-used-ga-slots-tooltip' => 'This list will be updated ONLY when page is refreshed.',
	'abtesting-future-used-ga-slots' => 'List of used GA slots in the future: $1',
	'abtesting-future-used-ga-slots-tooltip' => 'This list will be updated ONLY when page is refreshed.',
	'abtesting-checkbox-show-past-experiments' => 'Show past experiments',

	'abtesting-heading-id' => 'ID',
	'abtesting-heading-name' => 'Name',
	'abtesting-heading-description' => 'Description',

	'abtesting-heading-start-time' => 'Start Time (UTC)',
	'abtesting-heading-end-time' => 'End Time (UTC)',
	'abtesting-heading-ga-slot' => 'GA Slot',
	'abtesting-heading-flag-ga_tracking' => 'GA',
	'abtesting-heading-flag-dw_tracking' => 'DW',
	'abtesting-heading-flag-forced_ga_tracking_on_load' => 'GA onload',
	'abtesting-heading-flag-limit_to_special_wikis' => 'SpecialWikis',
	'abtesting-heading-long-flag-ga_tracking' => 'GA tracking',
	'abtesting-heading-long-flag-dw_tracking' => 'DW tracking',
	'abtesting-heading-long-flag-forced_ga_tracking_on_load' => 'Force GA track on window.onload',
	'abtesting-heading-long-flag-limit_to_special_wikis' => 'Limit to SpecialWikis',
	'abtesting-heading-group' => 'Group',
	'abtesting-heading-control-group' => 'Control Group',
	'abtesting-heading-ranges' => 'Ranges (0-99)',
	'abtesting-heading-treatment-groups' => 'Treatment Groups',

	'abtesting-create-experiment' => 'Create New Experiment',
	'abtesting-add-experiment-title' => 'Add Experiment',
	'abtesting-edit-experiment-title' => 'Edit Experiment',
	'abtesting-add-treatment-group' => 'Add Treatment Group',

	'abtesting-edit-button' => 'Edit',
	'abtesting-save-button' => 'Save',

	'abtesting-flag-set-short' => 'YES',

	'abtesting-ranges-info' => '(0-99)',
	'action-abtestpanel' => 'configure A/B tests',
	'right-abtestpanel' => 'Allows access to Special:AbTesting',
];


/**
 * qqq - Documentation for the messages.
 */
$messages['qqq'] = [
	'abtesting' => 'Page title',
	'abtesting-desc' => 'Description of the A/B Testing extension',
	'abtesting-currently-used-ga-slots' => 'Label for currently used GA slots',
	'abtesting-future-used-ga-slots' => 'Label for used GA slots in the future',

	'abtesting-heading-id' => 'Label for the ID field',
	'abtesting-heading-name' => 'Label for the Name field',
	'abtesting-heading-description' => 'Label for the Description field',

	'abtesting-heading-start-time' => 'Label for the experiment start time',
	'abtesting-heading-end-time' => 'Label for the experiement end time',
	'abtesting-heading-ga-slot' => 'Label for the GA Slot field',
	'abtesting-heading-group' => 'Group',
	'abtesting-heading-control-group' => 'Label for the control group pulldown',
	'abtesting-heading-ranges' => 'Ranges (0-99)',
	'abtesting-heading-treatment-groups' => 'Heading for the Treatment Groups section',

	'abtesting-create-experiment' => 'Button for creating a new experiment',
	'abtesting-add-experiment-title' => 'Add Experiment',
	'abtesting-edit-experiment-title' => 'Edit Experiment',
	'abtesting-add-treatment-group' => 'Button for adding a new treatment group',

	'abtesting-edit-button' => 'Edit button',
	'abtesting-save-button' => 'Save button',
];
