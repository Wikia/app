<?php
/**
 * Internationalisation file for the EditHub extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'action-edithub' => 'Edit Hub',
	'edit-hub-title' => 'Edit Hub',
	'edit-hub-date-title' => 'Date',

	'edit-hub-tooltip-current-date' => 'Current date',
	'edit-hub-tooltip-published' => 'Published',
	'edit-hub-tooltip-in-progress' => 'Not published',
	'edit-hub-tooltip-calendar-placeholder' => 'Please, wait for calendar.',

	'edit-hub-header-dashboard' => 'Dashboard',
	'edit-hub-header-right-last-saved' => 'Last saved:',
	'edit-hub-header-right-by' => 'by:',

	'edit-hub-footer-button-publish' => 'Publish',
	'edit-hub-edithub-save-button' => 'Save',
	'edit-hub-edithub-clearall-button' => 'Clear all',
	'edit-hub-edithub-removeall-button' => 'Remove all',
	'edit-hub-edithub-remove' => 'Remove',

	'edit-hub-edithub-clearall-confirmation' => 'Are you sure you want to clear the entire $1 module?',
	'edit-hub-edithub-clear-confirmation' => 'Are you sure you want to clear this section?',
	'edit-hub-edithub-clear-sponsored-image' => 'Are you sure you want to remove sponsored image?',

	'edit-hub-module-save-error' => 'There was an error while saving, please check what you entered',
	'edit-hub-module-save-ok' => '$1 module saved successfully!',

	'edit-hub-module-publish-error-read-only' => "We're in read-only mode at this moment. The hub page cannot be published. Please, try again later.",
	'edit-hub-module-publish-error-modules-not-saved' => 'There are unsaved modules. Please check their content, save them and try publish hub page again.',
	'edit-hub-module-publish-error-db-error' => 'A database error occured. The hub pages has not been published.',
	'edit-hub-module-publish-success' => 'Hub page published for $1',
);

$messages['qqq'] = array(
	'action-edithub' => 'Edit Hub Special Page Name',
	'edit-hub-title' => 'Edit Hub Special Page title',
	'edit-hub-date-title' => 'Special Edit Hub - Header displayed in section where date is chosen',

	'edit-hub-tooltip-current-date' => 'Special Edit Hub - Label for Current date in calendar. Current date is visible as marked current day in monthly calendar.',
	'edit-hub-tooltip-published' => 'Special Edit Hub - Label for Published date in calendar. Published date is date on which new content (all modules are edited and saved) is displayed on hub page.',
	'edit-hub-tooltip-in-progress' => 'Special Edit Hub - Label for date on which new content will be publish, but work on editing its modules is still in progress.',
	'edit-hub-tooltip-calendar-placeholder' => 'Special Edit Hub - Calendar placeholder - displayed while browser is waiting for server response',

	'edit-hub-header-dashboard' => 'Special Edit Hub - Header displayed on dashboard with calendar.',
	'edit-hub-header-right-last-saved' => 'Special Edit Hub - label for date on which hubs modules were last saved',
	'edit-hub-header-right-by' => 'Special Edit Hub - label for last saved by field',

	'edit-hub-footer-button-publish' => 'Special Edit Hub - text on publish button. Hit on this button will publish new data for selected date.',
	'edit-hub-edithub-save-button' => 'Special Edit Hub - text on save button. Hit on this button will save data in current module.',
	'edit-hub-edithub-clearall-button' => 'Special Edit Hub - text on clear all button. Hit on this button will clear all fields in current module.',
	'edit-hub-edithub-removeall-button' => 'Special Edit Hub - text on remove all button. Hit on this button will remove all sections in current module.',
	'edit-hub-edithub-remove' => 'Special Edit Hub - text on remove button. Hit on this button will remove selected section in current module.',

	'edit-hub-edithub-clearall-confirmation' => 'Confirmation message after click on clear all button. User is about to clear data in entire module. 1st parameter is module name.',
	'edit-hub-edithub-clear-confirmation' => 'Confirmation message after click on clear button. User is about to clear data in selected section of module.',
	'edit-hub-edithub-clear-sponsored-image' => 'Confirmation message after click on clear button for sponsored image section.',

	'edit-hub-module-save-error' => 'General error message while saving data. This message should point user to more specific messages near fields that returned validation errors.',
	'edit-hub-module-save-ok' => 'Message after successful save data in module. 1st param is module name.',

	'edit-hub-module-publish-error-read-only' => 'Error message while in read only mode. Should inform user that hub cannot be published right now and to try again later.',
	'edit-hub-module-publish-error-modules-not-saved' => 'Error message after publish attempt with not all modules saved for selected day.',
	'edit-hub-module-publish-error-db-error' => 'Error message after try to publish hub. Problems with Database.',
	'edit-hub-module-publish-success' => 'Message after successful publishing hub. 1st param is date on which hub was published.',
);
