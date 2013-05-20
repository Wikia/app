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
	'manage-wikia-home-wikis-in-slots-total' => 'Total amount of slots: $1',
	'manage-wikia-home-visualization-wikis' => 'Corporate wikis with visualization:',

	'manage-wikia-home-wikis-in-slots-success' => 'Numbers slots has been changed.',
	'manage-wikia-home-collections-success' => 'Collections has been saved.',

	'manage-wikia-home-verticals-proportions' => 'Number of wikis per vertical',

	'manage-wikia-home-error-invalid-total-no-of-slots' => "Invalid slots amount in total ($1). Please make sure sum of each hub's slots equals total amount of slots ($2).",
	'manage-wikia-home-error-negative-slots-number-not-allowed' => 'Negative number of slots is not allowed',
	'manage-wikia-home-error-wikifactory-failure' => 'Something went wrong during saving the variables. Please try again.',
	'manage-wikia-home-collections-validation-error' => 'There was an error while saving, please check what you entered.',

	'manage-wikia-home-change-button' => 'Change',

	'manage-wikia-home-wikis-in-visualization-heading' => 'List of wikis in visualization',
	'manage-wikia-home-wiki-name-filter' => 'Start typing wiki name and the list will get shorter:',
	'manage-wikia-home-wiki-filter' => 'Filter',
	'manage-wikia-home-wiki-filter-reset' => 'Clear',

	'manage-wikia-home-wiki-vertical-gaming' => 'Gaming',
	'manage-wikia-home-wiki-vertical-entertainment' => 'Entertainment',
	'manage-wikia-home-wiki-vertical-lifestyle' => 'Lifestyle',

	'manage-wikia-home-wiki-list-id' => 'Id',
	'manage-wikia-home-wiki-list-vertical' => 'Vertical',
	'manage-wikia-home-wiki-list-headline' => 'Wiki name',
	'manage-wikia-home-wiki-list-blocked' => 'Blocked',
	'manage-wikia-home-wiki-list-promoted' => 'Promoted',
	'manage-wikia-home-wiki-list-official' => 'Official',
	'manage-wikia-home-wiki-list-collection' => 'Collections',
	'manage-wikia-home-wiki-list-blocked-no' => 'No',
	'manage-wikia-home-wiki-list-blocked-yes' => 'Yes',
	'manage-wikia-home-wiki-list-promoted-no' => 'No',
	'manage-wikia-home-wiki-list-promoted-yes' => 'Yes',
	'manage-wikia-home-wiki-list-official-no' => 'No',
	'manage-wikia-home-wiki-list-official-yes' => 'Yes',
	'manage-wikia-home-wiki-list-disabled-collection' => 'Disabled collection',
	'manage-wikia-home-wiki-list-all-collections' => 'All collections',
	'manage-wikia-home-wiki-list-all-verticals' => 'All verticals',
	'manage-wikia-home-modal-title' => 'Change wiki status',
	'manage-wikia-home-modal-title-collection' => 'Edit wiki in collection',

	'manage-wikia-home-modal-content-add-blocked' => 'Do you want to exclude this wiki from appearing in the wiki visualization?',
	'manage-wikia-home-modal-content-remove-blocked' => 'Do you want to include this wiki in the wiki visualization?',
	'manage-wikia-home-modal-content-add-promoted' => 'Do you want to promote this wiki in the wiki visualization?',
	'manage-wikia-home-modal-content-remove-promoted' => 'Do you want to demote this wiki in the wiki visualization?',
	'manage-wikia-home-modal-content-add-official' => 'Do you want to add official sign for this wiki in the wiki visualization?',
	'manage-wikia-home-modal-content-remove-official' => 'Do you want to remove official sign for this wiki in the wiki visualization?',
	'manage-wikia-home-modal-content-add-collection' => 'Do you want to add this wiki to collection?',
	'manage-wikia-home-modal-content-remove-collection' => 'Do you want to remove this wiki from collection?',
	'manage-wikia-home-modal-content-add-blocked-wiki-warning' => 'You cannot add blocked wiki to collection',
	'manage-wikia-home-modal-content-blocked-wiki-in-collection-warning' => 'This wiki shouldn\'t be in collection because it is blocked. It will be removed from collection',
	'manage-wikia-home-modal-content-blocked-wiki-title' => 'This wiki is blocked',
	'manage-wikia-home-modal-content-removed-blocked-in-collection' => 'This wiki is in collection. You cannot change it\'s "blocked" status.',
	'manage-wikia-home-modal-too-many-wikis-in-collection' => 'You can not add more wikis to this collection.',
	'manage-wikia-home-modal-button-no' => 'No',
	'manage-wikia-home-modal-button-yes' => 'Yes',
	'manage-wikia-home-modal-button-okay' => 'Okay',

	'manage-wikia-home-collections-setup-header' => 'Collections setup',
	'manage-wikia-home-collections-setup-save-button' => 'Save',

	'manage-wikia-home-collections-enabled-field-label' => 'Enabled',
	'manage-wikia-home-collections-name-field-label' => 'Collection name',
	'manage-wikia-home-collections-sponsor-url-field-label' => 'Sponsor URL',
	'manage-wikia-home-collections-sponsor-hero-image-field-label' => 'Hero image',
	'manage-wikia-home-collections-sponsor-image-field-label' => 'Sponsor image',
	'manage-wikia-home-collections-wikis-in-collection' => 'Wikis: $1/$2',
	'manage-wikia-home-collections-invalid-wikis-number' => 'This collection will not be visible on corporate main page until there are $1 wikis assigned to it.',

	'manage-wikia-home-collection-hero-image-tooltip' => 'This image should be $1px × $2px',
	'manage-wikia-home-collection-sponsor-image-tooltip' => 'This image should be $1px × $2px',
	'manage-wikia-home-collection-add-file-button' => 'Add a photo'
);

$messages['qqq'] = array(
	'managewikiahome' => 'Page title visible as browser window\'s title; Content of <title /> tag in HTML',
	'manage-wikia-home-wrong-rights' => "A message displayed to a user if he doesn't have rights to use this special page",

	'manage-wikia-home-wikis-in-slots-heading' => 'Header of slots\' configuration container; this container have input fields which we use to configure amounts of images per vertical we\'re showing in the visualization on corporate main page',
	'manage-wikia-home-wikis-in-slots-total' => 'Text describing how many slots are available to use in configuration; $1 = number; amount of slots',
	'manage-wikia-home-visualization-wikis' => 'A label next to selectbox with a list of wikis where visualization is enabled (corporate wikis)',

	'manage-wikia-home-wikis-in-slots-success' => 'Success information after successful change in slots configuration',
	'manage-wikia-home-collections-success' => 'Success information after successful change in collections configuration',

	'manage-wikia-home-verticals-proportions' => 'Header above slots configuration\'s input fields; in the form below this header we can configure how many slots are assigned to a vertical; later we fill those slots with a wiki image from a specific vertical',

	'manage-wikia-home-error-invalid-total-no-of-slots' => "An error which is displayed when set numbers in total doesn't equal required number of all slots; first parameter is the sum of entered numbers and second one is the required number",
	'manage-wikia-home-error-negative-slots-number-not-allowed' => "An error which is displayed when any of set numbers is negative",
	'manage-wikia-home-error-wikifactory-failure' => 'An error which is displayed when an WikiFactory error occurs',
	'manage-wikia-home-collections-validation-error' => 'An error message which is displayed when the data passed through collection\'s configuration form is invalid',
	
	'manage-wikia-home-change-button' => 'A label on a submitting form button; the form is to change visualization slots\' configuration',
	
	'manage-wikia-home-wikis-in-visualization-heading' => "A heading above table with wikis' data",
	'manage-wikia-home-wiki-name-filter' => 'Text above filtering input text describing what the input text is for',
	'manage-wikia-home-wiki-filter' => 'A label on a submitting form button; the form is filtering list of wikis in visualization',
	'manage-wikia-home-wiki-filter-reset' => 'A label on a reseting form button, which reset all filters',

	'manage-wikia-home-wiki-vertical-gaming' => 'Name of \'gaming\' vertical',
	'manage-wikia-home-wiki-vertical-entertainment' => 'Name of \'entertainment\' vertical',
	'manage-wikia-home-wiki-vertical-lifestyle' => 'Name of \'lifestyle\' vertical',

	'manage-wikia-home-wiki-list-id' => 'Table column header which describes column containing wiki Id',
	'manage-wikia-home-wiki-list-vertical' => 'Table column header which describes column containing wiki vertical name',
	'manage-wikia-home-wiki-list-headline' => 'Table column header which describes column containing wiki name ',
	'manage-wikia-home-wiki-list-blocked' => 'Table column header which describes column containing information if wiki is blocked',
	'manage-wikia-home-wiki-list-promoted' => 'Table column header which describes column containing information if wiki is promoted',
	'manage-wikia-home-wiki-list-official' => 'Table column header which describes column containing information if wiki is official',
	'manage-wikia-home-wiki-list-collection' => 'Table column header which describes column containing possibility to adding and removing wiki from collection',
	'manage-wikia-home-modal-too-many-wikis-in-collection' => 'Error telling about too many wikis selected for a collection',
	'manage-wikia-home-wiki-list-disabled-collection' => 'If collection is disabled, checkbox for selecting wiki in collection is not active',
	'manage-wikia-home-wiki-list-blocked-no' => '\'No\' in column Blocked on table; tells about wiki status that it\'s NOT blocked from showing in wikis visualization on corporate main pages',
	'manage-wikia-home-wiki-list-blocked-yes' => '\'Yes\' in column Blocked on table; tells about wiki status that it IS blocked from showing in wikis visualization on corporate main pages',
	'manage-wikia-home-wiki-list-promoted-no' => '\'No\' in column Promoted on table; tells about wiki status that it\'s NOT promoted in wikis visualization on corporate main pages',
	'manage-wikia-home-wiki-list-promoted-yes' => '\'Yes\' in column Promoted on table; tells about wiki status that it IS promoted in wikis visualization on corporate main pages',
	'manage-wikia-home-wiki-list-official-no' => '\'No\' in column Official on table; tells about wiki status that it\'s NOT official in wikis visualization on corporate main pages',
	'manage-wikia-home-wiki-list-official-yes' => '\'Yes\' in column Official on table; tells about wiki status that it IS official in wikis visualization on corporate main pages',
	'manage-wikia-home-wiki-list-all-collections' => 'Label on filtering select field to show all wikis (not only belonged to collections)',
	'manage-wikia-home-wiki-list-all-verticals' => 'Label on filtering select field to show wikis for all verticals',

	'manage-wikia-home-modal-title' => 'blocking/unblocking/promoting/demoting modal title',
	'manage-wikia-home-modal-title-collection' => 'add/remove wiki in collections modal title',
	'manage-wikia-home-modal-content-add-blocked' => 'change wiki status question (when wiki is blocked)',
	'manage-wikia-home-modal-content-remove-blocked' => 'change wiki status question (when wiki is unblocked)',
	'manage-wikia-home-modal-content-add-promoted' => 'change wiki status question (when wiki is promoted)',
	'manage-wikia-home-modal-content-remove-promoted' => 'change wiki status question (when wiki is demoted)',
	'manage-wikia-home-modal-content-add-official' => 'change wiki status question (when official mark is added to wiki)',
	'manage-wikia-home-modal-content-remove-official' => 'change wiki status question (when official mark is removed from wiki)',
	'manage-wikia-home-modal-content-add-collection' => 'add wiki to selected collection',
	'manage-wikia-home-modal-content-remove-collection' => 'remove wiki from selected collection',
	'manage-wikia-home-modal-content-add-blocked-wiki-warning' => 'warning information that it is impossible to add blocked wiki to collection',
	'manage-wikia-home-modal-content-blocked-wiki-in-collection-warning' => 'warning information that wiki is blocked and it is in collection, so it will be removed',
	'manage-wikia-home-modal-content-blocked-wiki-title' => 'information that wiki is blocked',
	'manage-wikia-home-modal-content-removed-blocked-in-collection' => 'warning information that it is impossible to set wiki as blocked because it is in collection.',
	'manage-wikia-home-modal-button-no' => '\'No\' button on blocking/unblocking modal',
	'manage-wikia-home-modal-button-yes' => '\'Yes\' button on blocking/unblocking modal',
	'manage-wikia-home-modal-button-okay' => '\'Okay\' button on modal, which inform that wiki can not be added to collection because is blocked',
	'manage-wikia-home-collections-wikis-in-collection' => 'It says how many wikis are in the collections; $1 = actual number of wikis assigned to a collection; $2 = maximum number of wikis per collection',
	'manage-wikia-home-collections-invalid-wikis-number' => 'Information about status of a collection; it appears only if the number of wikis assigned to a collection is invalid (it extends the maximum number of wikis per collection); $1 = maximum number of wikis per collection',

	'manage-wikia-home-collections-setup-header' => 'A header above collections\' configuration',
	'manage-wikia-home-collections-setup-save-button' => 'A label on the submit button; clicking this button saves changes in collections\' configuration',

	'manage-wikia-home-collections-enabled-field-label' => 'A label before checkbox; the checkbox is to indicate status of a collection (enabled/disabled)',
	'manage-wikia-home-collections-name-field-label' => 'A label next to a collection\'s name field; in this field you put a collection\'s name',
	'manage-wikia-home-collections-sponsor-url-field-label' => 'A label next to collection\'s sponsor URL field; in the field you put the sponsor URL address',
	'manage-wikia-home-collections-sponsor-hero-image-field-label' => 'A label next to collection\'s bigger image field (the big image covers all wikis images on corporate main page for some time then it fades out); in the field you put an image name',
	'manage-wikia-home-collections-sponsor-image-field-label' => 'A label next to collection\'s smaller image field (the smaller image covers statistic section on corporate main page for a specific wikis\' set); in the field you put an image name',

	'manage-wikia-home-collection-hero-image-tooltip' => 'Image size information under the big image field; the big image covers all wikis images on corporate main page; $1 = width of the image, $2 = its height',
	'manage-wikia-home-collection-sponsor-image-tooltip' => 'Image size information under the smaller image field; $1 = width of the image, $2 = its height',
	
	'manage-wikia-home-collection-add-file-button' => 'A label on buttons which open the image uploader',
);
