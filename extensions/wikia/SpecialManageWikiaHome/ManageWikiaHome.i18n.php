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

	'manage-wikia-home-wikis-in-slots-success' => 'Numbers slots has been changed.',
	'manage-wikia-home-collections-success' => 'Collections has been saved.',

	'manage-wikia-home-verticals-proportions' => 'Number of wikis for each vertical in WV',

	'manage-wikia-home-error-invalid-total-no-of-slots' => "Invalid slots amount in total ($1). Please make sure sum of each hub's slots equals total amount of slots ($2).",
	'manage-wikia-home-error-negative-slots-number-not-allowed' => 'Negative number of slots is not allowed',
	'manage-wikia-home-error-wikifactory-failure' => "Something wrong happened during saving the variables all of them wasn't saved or they were saved partly. Try again.",
	'manage-wikia-home-collections-failure' => 'There was an error while saving, please check what you entered.',

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

	'manage-wikia-home-collections-setup-header' => 'Collections setup',
	'manage-wikia-home-collections-setup-save-button' => 'Save',

	'manage-wikia-home-collections-enabled-field-label' => 'Enabled',
	'manage-wikia-home-collections-name-field-label' => 'Collection name',
	'manage-wikia-home-collections-sponsor-url-field-label' => 'Sponsors url',
	'manage-wikia-home-collections-sponsor-hero-image-field-label' => 'Hero image',
	'manage-wikia-home-collections-sponsor-image-field-label' => 'Sponsor image',

	'manage-wikia-home-collection-hero-image-tooltip' => 'This image should be 1010px x 650px',
	'manage-wikia-home-collection-sponsor-image-tooltip' => 'This image should be 330px x 210px',
	'manage-wikia-home-collection-add-file-button' => 'Add a photo'
);

$messages['qqq'] = array(
	'managewikiahome' => 'Page title visible as browser window\'s title; Content of <title /> tag in HTML',
	'manage-wikia-home-wrong-rights' => "A message displayed to a user if he doesn't have rights to use this special page",

	'manage-wikia-home-wikis-in-slots-heading' => 'Header above slots configuration',
	'manage-wikia-home-wikis-in-slots-total' => 'A label next to total slots number',
	'manage-wikia-home-visualization-wikis' => 'A label next to selectbox with a list of wikis where visualization is enabled (corporate wikis)',

	'manage-wikia-home-wikis-in-slots-success' => 'Success information after successful change in slots configuration',
	'manage-wikia-home-collections-success' => 'Success information after successful change in collections configuration',

	'manage-wikia-home-verticals-proportions' => 'Header above slots configuration\'s input fields',

	'manage-wikia-home-error-invalid-total-no-of-slots' => "An error which is displayed when set numbers in total doesn't equal required number of all slots; first parameter is the sum of entered numbers and second one is the required number",
	'manage-wikia-home-error-negative-slots-number-not-allowed' => "An error which is displayed when any of set numbers is negative",
	'manage-wikia-home-error-wikifactory-failure' => 'An error which is displayed when an WikiFactory error occur',
	'manage-wikia-home-collections-failure' => 'An error message which is displayed when an error occurs while saving changes in collections configuration',
	
	'manage-wikia-home-change-button' => 'A label on a submitting form button; the form is to change visualization slots\' configuration',
	
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

	'manage-wikia-home-collections-setup-header' => 'A header above collections\' configuration',
	'manage-wikia-home-collections-setup-save-button' => 'A label on the submit button; clicking this button saves changes in collections\' configuration',

	'manage-wikia-home-collections-enabled-field-label' => 'A label before checkbox; the checkbox is to indicate status of a collection (enabled/disabled)',
	'manage-wikia-home-collections-name-field-label' => 'A label next to a collection\'s name field; in this field you put a collection\'s name',
	'manage-wikia-home-collections-sponsor-url-field-label' => 'A label next to collection\'s sponsor URL field; in the field you put the sponsor URL address',
	'manage-wikia-home-collections-sponsor-hero-image-field-label' => 'A label next to collection\'s hero image field; in the field you put an image name',
	'manage-wikia-home-collections-sponsor-image-field-label' => 'A label next to collection\'s sponsor image field; in the field you put an image name',

	'manage-wikia-home-collection-hero-image-tooltip' => 'Image size information under the hero image field',
	'manage-wikia-home-collection-sponsor-image-tooltip' => 'Image size information under the sponsor image field',
	
	'manage-wikia-home-collection-add-file-button' => 'A label on buttons which are supposed to open image uploader',
);