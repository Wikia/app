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
	'templatedraft-module-title' => 'Migrate this infobox',
	'templatedraft-module-subtitle' => 'This template does not use the new [[Help:PortableInfoboxes|infobox markup]].',
	'templatedraft-module-content' => 'We can generate a draft version of the markup from your existing infobox and save it as a sub-page so you can review it and make any needed changes.',
	'templatedraft-module-button' => 'Generate draft markup',
	'templatedraft-module-button-title' => 'Open a new tab with a pre-filled edit form',
	'templatedraft-module-closelink' => 'This is not an infobox',

	'templatedraft-preview-n-docs' => '== Usage & preview ==
Type in this:

<pre>
$1
</pre>

to see this:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Click here to refresh the preview above]',
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
	'templatedraft-module-title' => 'A title of the TemplateDraft module that appears in the right rail on Template pages.',
	'templatedraft-module-subtitle' => 'A title of the TemplateDraft module that appears in the right rail on Template pages.',
	'templatedraft-module-content' => 'A content of the TemplateDraft module that appears in the right rail on Template pages.',
	'templatedraft-module-button' => 'A button shown in a right rail module that gets user to a subpage with a draft of a template.',
	'templatedraft-module-button-title' => 'Title of the "Generate draft markup" button. It should tell users what will happen when they click it.',
	'templatedraft-module-closelink' => 'A link that closes the right rail module if it is not on a template page with an infobox in it.',
	'templatedraft-preview-n-docs' => 'Used when generating documentation for a converted draft of a template',
];
