<?php
/**
 * TopLists extension message file
 */

$messages = array();

$messages['en'] = array(
	//info
	'toplists-desc' => 'Top lists',

	//rights
	'right-toplists-create-edit-list' => 'Create and edit Top lists articles',

	//special pages
	'createtoplist' => 'Create a new list',
	'edittoplist' => 'Edit list',

	//errors
	'toplists-error-invalid-title' => 'The supplied text is not valid',
	'toplists-error-invalid-picture' => 'The selected picture is not valid',
	'toplists-error-title-exists' => 'This article already exists, you can go to <a href="$2" target="_blank">$1</a> or supply a different name',
	'toplists-error-title-spam' => 'The supplied text contains some words recognized as spam',
	'toplists-error-article-blocked' => 'You are not allowed to create an article with this name, sorry',
	'toplists-error-article-not-exists' => '"$1" does not exist, do you want to <a href="$2" target="_blank">create it</a>?',
	'toplists-error-picture-not-exists' => '"$1" does not exist, do you want to <a href="$2" target="_blank">upload it</a>?',
	'toplists-error-duplicated-entry' => 'You can\'t use the same name more than once',
	'toplists-error-empty-item-name' => 'The name of an existing item can\'t be empty',
	'toplists-item-cannot-delete' => 'Deletion of this item failed',

	//editor
	'toplists-editor-title-label' => 'List name',
	'toplists-editor-title-placeholder' => 'Enter a name for the list',
	'toplists-editor-related-article-label' => 'Related article',
	'toplists-editor-related-article-optional-label' => 'optional',
	'toplists-editor-related-article-placeholder' => 'Enter an existing article page name',
	'toplists-editor-image-browser-tooltip' => 'Add a picture',
	'toplists-editor-remove-item-tooltip' => 'Remove item',
	'toplists-editor-drag-item-tooltip' => 'Drag to change order',
	'toplists-editor-add-item-label' => 'Add a new item',
	'toplists-editor-add-item-tooltip' => 'Add a new item to the list',
	'toplists-create-button' => 'Create list',
	'toplists-update-button' => 'Save list',
	'toplists-cancel-button' => 'Cancel',
	'toplits-image-browser-no-picture-selected' => 'No picture selected',
	'toplits-image-browser-clear-picture' => 'Clear picture',
	'toplits-image-browser-selected-picture' => 'Currently selected: $1',

	//article edit summaries
	'toplists-list-creation-summary' => 'Creating a list',
	'toplists-list-update-summary' => 'Updating a list',
	'toplists-item-creation-summary' => 'Creating a list item',
	'toplists-item-update-summary' => 'Updating a list item',
	'toplists-item-remove-summary' => 'Item removed from list',

	//list view
	'toplists-list-votes-num' => '$1 votes',
	'toplists-list-created-by' => 'By $1',
	'toplists-list-vote-up' => 'Vote Up'

);

$messages['qqq'] = array(
	'toplits-image-browser-selected-picture' => '$1 is the title of the image article'
);