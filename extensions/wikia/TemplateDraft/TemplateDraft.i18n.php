<?php
/**
 * TemplateDraft message file
 */

$messages = [];

/**
 * English (en)
 */
$messages['en'] = [
	'templatedraft-description' => 'TemplateDraft extension',
	'templatedraft-subpage' => 'Draft',
	'templatedraft-editintro' => "Here you go! We've generated a draft version of your infobox with our new markup. We'll save it as a sub-page so you can review it and make any needed changes. You may want to [[Help:PortableInfoboxes|view the help page on Infobox markup]] or [$1 view parent template wikitext].",
	/**
	 * Notifications
	 */
	'templatedraft-approval-summary' => 'Replaced with updated version from draft template',
	/**
	 * Right rail module
	 */
	'templatedraft-module-title-create' => 'Migrate this infobox',
	'templatedraft-module-subtitle-create' => 'This template does not use the new [[Help:PortableInfoboxes|infobox markup]].',
	'templatedraft-module-content-create' => 'We can generate a draft version of the markup from your existing infobox and save it as a sub-page so you can review it and make any needed changes.',
	'templatedraft-module-button-create' => 'Generate draft markup',
	'templatedraft-module-button-title-create' => 'Open a new tab with a pre-filled edit form',
	'templatedraft-module-closelink-create' => 'This is not an infobox',
	'templatedraft-module-title-approve' => 'Move this draft template',
	'templatedraft-module-content-approve' => 'Happy with this draft and want to promote it to the live template?',
	'templatedraft-module-button-approve' => 'Approve this draft',

	'templatedraft-preview-n-docs' => '== Usage & preview ==
Type in this:

<pre>
$1
</pre>

to see this:

$2

[{{fullurl:PAGENAME}}?action=purge Click here to refresh the preview above]',
];

/**
 * Documentation (qqq)
 */
$messages['qqq'] = [
	'templatedraft-description' => '{{desc}}',
	'templatedraft-subpage' => 'A name that should be used for subpages of templates that contain a draft content.',
	/**
	 * Notifications
	 */
	'templatedraft-approval-summary' => 'Text used as edit summary when code is automatically replacing template with content from draft template on user approval',
	/**
	 * Right rail module
	 */
	'templatedraft-module-title-create' => 'A title of the TemplateDraft module for creating draft that appears in the right rail on Template pages.',
	'templatedraft-module-subtitle-create' => 'A title of the TemplateDraft module for creating draft that appears in the right rail on Template pages.',
	'templatedraft-module-content-create' => 'A content of the TemplateDraft module for creating draft that appears in the right rail on Template pages.',
	'templatedraft-module-button-create' => 'A button shown in a right rail module for creating draft that gets user to a subpage with a draft of a template.',
	'templatedraft-module-button-title-create' => 'Title of the "Generate draft markup" button. It should tell users what will happen when they click it.',
	'templatedraft-module-closelink-create' => 'A link that closes the right rail module if it is not on a template page with an infobox in it.',
	'templatedraft-module-title-approve' => 'A title of the TemplateDraft module for approving draft that appears in the right rail on Template pages.',
	'templatedraft-module-content-approve' => 'A content of the TemplateDraft module for approving draft that appears in the right rail on Template pages.',
	'templatedraft-module-button-approve' => 'A button shown in a right rail module for approving draft that moves draft text to parent template and gets user to this parent template',
	'templatedraft-preview-n-docs' => 'Used when generating documentation for a converted draft of a template',
];
