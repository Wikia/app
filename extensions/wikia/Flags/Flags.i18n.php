<?php
/**
 * Flags message file
 */

$messages = [];

/**
 * English (en)
 */
$messages['en'] = [
	'flags-description' => 'Flags are per article information for reader or editors that describe the content or action required',
	'flags-special-title' => 'Manage Flags',
	'flags-special-header-text' => 'Built on top of the notice templates you already know and use, Flags allow for more powerful article organization, management, and labeling than ever before. Visit [[Help:Flags]] to learn more.',
	'flags-special-zero-state' => 'This community doesn\'t have any flags set up. [[Help:Flags|Learn more about flags]].',
	'flags-special-list-header-name' => 'Flag name',
	'flags-special-list-header-template' => 'Template name',
	'flags-special-list-header-group' => 'Flag group',
	'flags-special-list-header-target' => 'Target',
	'flags-special-list-header-parameters' => 'Parameters',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|See Wikia Flags in action!]]',
	'flags-edit-flags-button-text' => 'Edit flags',
	'flags-edit-form-more-info' => 'More info >',
	'flags-edit-modal-cancel-button-text' => 'Cancel',
	'flags-edit-modal-close-button-text' => 'Close',
	'flags-edit-modal-done-button-text' => 'Done',
	'flags-edit-modal-no-flags-on-community' => 'This community doesn\'t have any flags set up. [[Help:Flags|Learn more about flags]] or [[Special:Flags|define the flags for this community]].',
	'flags-edit-modal-title' => 'Flags',
	'flags-edit-modal-exception' => "Unfortunately, we are not able to display this due to the following error:\n\n\n\n$1\n\n\n\nThis error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Wikia support team if you continue to see this issue.",
	'flags-edit-modal-post-exception' => "Unfortunately, we are not able to complete the process due to the following error:\n\n\n\n$1\n\n\n\nThis error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Wikia support team if you continue to see this issue.",
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Disambiguation',
	'flags-groups-canon' => 'Canon',
	'flags-groups-stub' => 'Stub',
	'flags-groups-delete' => 'Delete',
	'flags-groups-improvements' => 'Improvements',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Other',
	'flags-groups-navigation' => 'Navigation',
	'flags-target-readers' => 'Readers',
	'flags-target-contributors' => 'Contributors',

	'flags-notification-templates-extraction' => 'The following templates: \'\'$1\'\' were recognized as [[Special:Flags|Flags]] and automatically converted. To see the change visit [[Special:RecentChanges]] or [[Special:Log]].',
	'flags-edit-intro-notification' => 'This template is associated with a Flag. Manage Flags at [[Special:Flags]].',

	'flags-log-name' => 'Flags log',
	'logentry-flags-flag-added' => '$1 added flag \'$4\' to page $3',
	'logentry-flags-flag-removed' => '$1 removed flag \'$4\' from page $3',
	'logentry-flags-flag-parameter-added' => '$1 added value \'$7\' for parameter \'$5\' of flag \'$4\' on page $3',
	'logentry-flags-flag-parameter-modified' => '$1 modified parameter \'$5\' of flag \'$4\' on page $3 from \'$6\' to \'$7\'',
	'logentry-flags-flag-parameter-removed' => '$1 removed value \'$6\' for parameter \'$5\' of flag \'$4\' on page $3',
];

/**
 * Message documentation
 */
$messages['qqq'] = [
	'flags-description' => '{{desc}}',
	'flags-special-title' => 'A title of the Flags special page (Flags HQ).',
	'flags-special-header-text' => 'A brief description of what Flags are and where a user can find more information about them.',
	'flags-special-zero-state' => 'A message shown to a user if the given wikia has no types of flags defined.',
	'flags-special-list-header-name' => 'A column name for a Flag name.',
	'flags-special-list-header-template' => 'A column name for an associated Template name.',
	'flags-special-list-header-group' => 'A column name for a Flag group.',
	'flags-special-list-header-target' => 'A column name for a Flag targeting (who should we display the flag to - everybody or only contributors).',
	'flags-special-list-header-parameters' => 'A column name for a Flag parameters.',
	'flags-edit-flags-button-text' => 'Text on button that opens edit flags modal; button contains flag icon; button is displayed near generated flags',
	'flags-edit-form-more-info' => 'A link that is displayed next to a checkbox in the edit form of Flags. It links to a template used by the flag that it is next to.',
	'flags-edit-modal-cancel-button-text' => 'Text on the button that closes flags edit modal and ignores changes.',
	'flags-edit-modal-close-button-text' => 'Text on the button that closes flags edit modal.',
	'flags-edit-modal-done-button-text' => 'Text on the button that submits changes done to flags.',
	'flags-edit-modal-no-flags-on-community' => 'Message on modal appearing when there are no flags types defined on the wiki.',
	'flags-edit-modal-title' => 'Title of the form for editing flags displayed on headline of modal containing the form.',
	'flags-edit-modal-exception' => 'A message shown in the modal instead of an edit form if an error makes it impossible to display it. $1 is a text of the error.',
	'flags-edit-modal-post-exception' => 'A message shown in a banner notification if posting of edit forms fails due to an error. $1 is a text of the error.',
	'flags-groups-spoiler' => 'A name of a Spoiler group of flags',
	'flags-groups-disambig' => 'A name of a Disambiguation group of flags',
	'flags-groups-canon' => 'A name of a Canon group of flags',
	'flags-groups-stub' => 'A name of a Stub group of flags',
	'flags-groups-delete' => 'A name of a Delete group of flags',
	'flags-groups-improvements' => 'A name of a Improvements group of flags',
	'flags-groups-status' => 'A name of a Status group of flags',
	'flags-groups-other' => 'A name of a Other group of flags',
	'flags-groups-navigation' => 'A name of Navigation group of flags',
	'flags-target-readers' => 'Target for displaying flags - Readers',
	'flags-target-contributors' => 'Target for displaying flags - Contributors',
	
	'flags-notification-templates-extraction' => 'A message shown as a banner notification when a user inserts a template mapped as a Flag. It notifies them that these templates were removed from the content and converted into Flags.',
	'flags-edit-intro-notification' => 'A message shown as a banner notification or intro when a user edits or views template mapped as a Flag',

	'flags-log-name' => 'Name of log type displayed on Special:Log',
	/* Messages like logentry-* are autogenerated by \LogFormatter::getMessageKey */
	'logentry-flags-flag-added' => 'Message used for generating log entry on Special:Log with info about added flag
		$1 info about user that added a flag passed as a generated link to user page
		$2 plain user name of user that added a flag
		$3 link to modified page
		$4 name of flag added',
	'logentry-flags-flag-removed' => 'Same as logentry-flags-flag-added message but concerns removal'
];

/**
 * Polish (pl)
 */
$messages['pl'] = [
	'flags-description' => 'Flagi to informacje o artykule dla czytających lub edytorów, które opisują treść artykułu lib wymaganą akcję',
	'flags-edit-flags-button-text' => 'Edytuj flagi',
	'flags-edit-form-more-info' => 'Więcej informacji >',
	'flags-edit-modal-cancel-button-text' => 'Anuluj',
	'flags-edit-modal-close-button-text' => 'Zamknij',
	'flags-edit-modal-done-button-text' => 'Gotowe',
	'flags-edit-modal-no-flags-on-community' => 'Ta społeczność nie ma zdefiniowanych żadnych flag. [[Help:Flags|Dowiedz się więcej o flagach]] or [[Special:Flags|zdefiniuj flagi dla tej społeczności]].',
	'flags-edit-modal-title' => 'Flagi',
	'flags-log-name' => 'Rejestr flag',
	'logentry-flags-flag-added' => '$1 {{GENDER:$2|dodał|dodała}} flagę \'$4\' do strony $3',
	'logentry-flags-flag-removed' => '$1 {{GENDER:$2|usunął|usunęła}} flagę \'$4\' ze strony $3'
];
