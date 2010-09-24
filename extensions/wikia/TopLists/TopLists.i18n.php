<?php
/**
 * TopLists extension message file
 */

$messages = array();

$messages['en'] = array(
	//info
	'toplists-desc' => 'Top 10 lists',

	//rights
	'right-toplists-create-edit-list' => 'Create and edit Top 10 list pages',
	'right-toplists-create-item' => 'Create and add items to a Top 10 list page',

	//special pages
	'createtoplist' => 'Create a new Top 10 list',
	'edittoplist' => 'Edit Top 10 list',

	//errors
	'toplists-error-invalid-title' => 'The supplied text is not valid.',
	'toplists-error-invalid-picture' => 'The selected picture is not valid.',
	'toplists-error-title-exists' => 'This page already exists. You can go to <a href="$2" target="_blank">$1</a> or supply a different name.',
	'toplists-error-title-spam' => 'The supplied text contains some words recognized as spam.',
	'toplists-error-article-blocked' => 'You are not allowed to create a page with this name. Sorry.',
	'toplists-error-article-not-exists' => '"$1" does not exist. Do you want to <a href="$2" target="_blank">create it</a>?',
	'toplists-error-picture-not-exists' => '"$1" does not exist. Do you want to <a href="$2" target="_blank">upload it</a>?',
	'toplists-error-duplicated-entry' => 'You can\'t use the same name more than once.',
	'toplists-error-empty-item-name' => 'The name of an existing item can\'t be empty.',
	'toplists-item-cannot-delete' => 'Deletion of this item failed.',
	'toplists-error-image-already-exists' => 'An image with the same name already exists.',
	'toplists-error-add-item-anon' => 'Anonymous users are not allowed to add items to lists. Please <a class="ajaxLogin" id="login" href="$1">Log in</a> or <a class="ajaxLogin" id="signup" href="$2">register a new account</a>.',
	'toplists-error-add-item-permission' => 'Permission error: Your account has not been granted the right to create new items.',
	'toplists-error-add-item-list-not-exists' => 'The "$1" Top 10 list does not exist.',
	'toplists-error-backslash-not-allowed' => 'The "/" character is not allowed in the title of a Top 10 list.',

	//editor
	'toplists-editor-title-label' => 'List name',
	'toplists-editor-title-placeholder' => 'Enter a name for the list',
	'toplists-editor-related-article-label' => 'Related page',
	'toplists-editor-related-article-optional-label' => 'optional',
	'toplists-editor-related-article-placeholder' => 'Enter an existing page name',
	'toplists-editor-image-browser-tooltip' => 'Add a picture',
	'toplists-editor-remove-item-tooltip' => 'Remove item',
	'toplists-editor-drag-item-tooltip' => 'Drag to change order',
	'toplists-editor-add-item-label' => 'Add a new item',
	'toplists-editor-add-item-tooltip' => 'Add a new item to the list',
	'toplists-create-button' => 'Create list',
	'toplists-update-button' => 'Save list',
	'toplists-cancel-button' => 'Cancel',
	'toplists-items-removed' => '$1 {{PLURAL:$1|item|items}} removed',
	'toplists-items-created' => '$1 {{PLURAL:$1|item|items}} created',
	'toplists-items-updated' => '$1 {{PLURAL:$1|item|items}} updated',
	'toplists-items-nochange' => 'No items changed',

	//image browser/selector
	'toplits-image-browser-no-picture-selected' => 'No picture selected',
	'toplits-image-browser-clear-picture' => 'Clear picture',
	'toplits-image-browser-selected-picture' => 'Currently selected: $1',
	'toplists-image-browser-upload-btn' => 'Choose',
	'toplists-image-browser-upload-label' => 'Upload your own',

	//article edit summaries
	'toplists-list-creation-summary' => 'Creating a list, $1',
	'toplists-list-update-summary' => 'Updating a list, $1',
	'toplists-item-creation-summary' => 'Creating a list item',
	'toplists-item-update-summary' => 'Updating a list item',
	'toplists-item-remove-summary' => 'Item removed from list',
	'toplists-item-restored' => 'Item restored',

	//list view
	'toplists-list-related-to' => 'Related to:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br/>vote|$1<br/>votes}}',
	'toplists-list-created-by' => 'by [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Vote Up',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|vote|votes}} in $2',
	'toplists-list-add-item-label' => 'Add item',
	'toplists-list-add-item-name-label' => 'Keep the list going...',
	'toplists-list-item-voted' => 'Voted',

	//createpage dialog
	'toplists-createpage-dialog-label' => 'Top 10 list',

	//watchlist emails
	'toplists-email-subject' => 'A Top 10 list has been changed',
	'toplists-email-body' => "The Top 10 list page $1 that you're watching has been changed.\n\n $2",

	//time
	'toplists-seconds' => '$1 {{PLURAL:$1|second|seconds}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minute|minutes}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hour|hours}}',
	'toplists-days' => '$1 {{PLURAL:$1|day|days}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|week|weeks}}',

	//FB connect article vote message
	'toplists-msg-fb-OnRateArticle-link' => '$ARTICLENAME',
	'toplists-msg-fb-OnRateArticle-short' =>  'has voted on a Top 10 list on $WIKINAME!',
	'toplists-msg-fb-OnRateArticle' => '$TEXT'
);

$messages['qqq'] = array(
	'toplits-image-browser-selected-picture' => '$1 is the title of the image page.'
);
