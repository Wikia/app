<?php
$messages = [];

$messages[ 'en' ] = [
	'portable-infobox-desc' => 'Create portable infoboxes which can be rendered using clean semantic HTML markup on
	any skin / platform using using easy to understand powerful XML-like markup',
	'portable-infobox-unimplemented-infobox-tag' => 'Unimplemented infobox tag: <$1>',
	'portable-infobox-xml-parse-error-info' => 'There is a problem with parsing the infobox',
	'portable-infobox-xml-parse-error' => 'Incorrect XML markup. Please validate your XML',
	'portable-infobox-xml-parse-error-document-end' => 'Extra content at the end of the document',
	'portable-infobox-xml-parse-error-undeclared-entity' => 'Undeclared entity (for example: &nbsp;)',
	'portable-infobox-xml-parse-error-attribute-not-started' => 'Attribute value should be inside quotation marks',
	'portable-infobox-xml-parse-error-attribute-without-value' => 'Tag attribute needs to have value',
	'portable-infobox-xml-parse-error-space-required' => 'Attributes construct error',
	'portable-infobox-xml-parse-error-name-required' => 'Error parsing attribute name',
	'portable-infobox-xml-parse-error-gt-required' => "Tag definition is not properly terminated",
	'portable-infobox-xml-parse-error-tag-name-mismatch' => 'Opening and ending tag mismatch',
	'portable-infobox-xml-parse-error-tag-not-finished' => 'Premature end of tag',
	'portable-infobox-xml-parse-error-infobox-tag-attribute-unsupported' => 'Attribute "$1" is not supported in
	<infobox> tag',

	// Infobox Builder UI
	'portable-infobox-builder-publish-button' => 'Publish',
	'portable-infobox-builder-title' => 'Infobox Builder',
	'portable-infobox-builder-edit-element-options-placeholder' => 'options placeholder',

	// Infobox builder edit params
	'portable-infobox-builder-edit-summary' => 'InfoboxBuilder',

	// Infobox builder preview elements text placeholders
	'portable-infobox-builder-infobox-title-element-placeholder' => 'I\'m the Infobox Title',
	'portable-infobox-builder-infobox-data-label-element-placeholder' => 'I\'m a Label',
	'portable-infobox-builder-infobox-data-value-element-placeholder' => 'I\'m a Value',

	// Infobox builder entry point modal
	'portable-infobox-builder-entry-point-modal-title' => 'Do you want to create an infobox?',
	'portable-infobox-builder-entry-point-modal-message' => 'Perhaps you are creating a new infobox template? Try out
	our new Infobox builder UI tool.',
	'portable-infobox-builder-entry-point-modal-ok-button' => 'Ok',
	'portable-infobox-builder-entry-point-modal-cancel-button' => 'Cancel',
];

$messages[ 'qqq' ] = [
	'portable-infobox-desc' => 'Portable Infobox extension description',
	'portable-infobox-unimplemented-infobox-tag' => 'Error message for using unimplemented infobox tag; $1 is the tag name without pointy braces',
	'portable-infobox-xml-parse-error-info' => 'General message for parsing problem',
	'portable-infobox-xml-parse-error' => 'Error message for providing incorrect XML markup',
	'portable-infobox-xml-parse-error-document-end' => 'XML Error: extra content at the end',
	'portable-infobox-xml-parse-error-undeclared-entity' => 'XML Error: undeclared entity (for example: &nbsp;). This typically comes from HTML.',
	'portable-infobox-xml-parse-error-attribute-not-started' => 'XML Error: ending tag without start tag',
	'portable-infobox-xml-parse-error-attribute-without-value' => 'XML Error: tag attribute was provided without value',
	'portable-infobox-xml-parse-error-space-required' => 'XML Error: issue with parsing tag attributes',
	'portable-infobox-xml-parse-error-name-required' => 'XML Error: error parsing name attribute',
	'portable-infobox-xml-parse-error-gt-required' => 'XML Error: could not find end of tag definition (for example: <data><label </data>',
	'portable-infobox-xml-parse-error-tag-name-mismatch' => 'XML Error: Opening and ending tag mismatch (for example: <data></label>)',
	'portable-infobox-xml-parse-error-tag-not-finished' => 'XML Error: premature end of tag',
	'portable-infobox-xml-parse-error-infobox-tag-attribute-unsupported' => 'Unsupported attribute used inside
	<infobox> tag. $1 param contains attribute name.',

	// Infobox Builder UI
	'portable-infobox-builder-publish-button' => 'Button for publishing infobox created using portable infobox
	builder UI tool',
	'portable-infobox-builder-title' => 'Title for Infobox Builder UI tool',
	'portable-infobox-builder-edit-element-options-placeholder' => 'Placeholder text shown in infobox element edit
	options panel displayed when no element is selected for editing',

	// Infobox builder edit params
	'portable-infobox-builder-edit-summary' => 'Edit summary for infobox template edit indication that this infobox
	template was created by Infobox Builder UI tool',

	// Infobox builder preview elements text placeholders
	'portable-infobox-builder-infobox-title-element-placeholder' => 'Placeholder text for infobox live preview title
	element',
	'portable-infobox-builder-infobox-data-label-element-placeholder' => 'Placeholder text for infobox live preview
	label element',
	'portable-infobox-builder-infobox-data-value-element-placeholder' => 'Placeholder text for infobox live preview
	data value element',

	// Infobox builder entry point modal
	'portable-infobox-builder-entry-point-modal-title' => 'Title for portable infobox builder entry point modal on
	edit page with a question: Do you want to create infobox?',
	'portable-infobox-builder-entry-point-modal-message' => 'Message in portable infobox builder asking if user wants
	 to create an infobox and if she / he would like to use new Infobox Builder UI tool.',
	'portable-infobox-builder-entry-point-modal-ok-button' => 'Ok button',
	'portable-infobox-builder-entry-point-modal-cancel-button' => 'Cancel button',
];
