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

[{{fullurl:PAGENAME}}?action=purge Click here to refresh the preview above]',
];

/**
 * Documentation (qqq)
 */
$messages['qqq'] = [
	'templatedraft-description' => '{{desc}}',
	'templatedraft-subpage' => 'A name that should be used for subpages of templates that contain a draft content.',
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
