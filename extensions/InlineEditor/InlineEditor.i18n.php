<?php
/**
 * Internationalisation file for extension InlineScripts.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Jan Paul Posma
 */
$messages['en'] = array(
	'inline-editor-desc' => 'Provides an alternative editor which is easier to use',

	'inline-editor-editbox-top' => "'''Awesome, you are editing {{SITENAME}}!'''<br />You can edit the page below, by clicking on <span class=\"highlightExample\">blue elements</span> in the page.",
	'inline-editor-editbox-top-new' => "'''Cool, you are creating a new page on {{SITENAME}}!'''<br />You can start typing in the <span class=\"highlightExample\">textbox</span> below.",
	'inline-editor-editbox-changes-question' => 'Can you briefly describe the changes you are making?',
	'inline-editor-editbox-changes-example' => 'For example: "Fixed spelling mistake", "Corrected facts", "Wrote a new paragraph", etc.',
	'inline-editor-editbox-publish-notice' => "When you are done, do not forget to publish the page!",
	// 'inline-editor-editbox-publish-terms' => 'When you click "Publish", you agree to the [http://wikimediafoundation.org/wiki/Terms_of_Use Terms of Use]. This means that you agree to share your contributions under a free license.',
	'inline-editor-editbox-publish-terms' => 'When you click "{{int:inline-editor-editbox-publish-caption}}", you agree with our copyright policy.
See $1 for more information.',
	'inline-editor-editbox-publish-caption' => 'Publish',
	'inline-editor-redirect-browser' => 'The new editing interface is not supported by your browser.',
	'inline-editor-redirect-advanced' => "Editing this page is considered '''advanced''' use of {{SITENAME}}.
You can only use the '''full editor''' for this page.",
	'inline-editor-undo' => 'Undo',
	'tooltip-inline-editor-undo' => 'Undo changes',
	'accesskey-inline-editor-undo' => '[',
	'inline-editor-redo' => 'Redo',
	'tooltip-inline-editor-redo' => 'Redo changes',
	'accesskey-inline-editor-redo' => ']',
	'inline-editor-preview' => 'Preview',
	'tooltip-inline-editor-preview' => 'View your changes',
	'accesskey-inline-editor-preview' => 'p',
	'inline-editor-cancel' => 'Cancel',
	'tooltip-inline-editor-cancel' => 'Cancel editing',
	'accesskey-inline-editor-cancel' => ';',
	'inline-editor-enable-preference' => 'Enable inline editing',
	'inline-editor-advanced-preference' => 'Advanced inline editing options',
);

/** Language descriptions
 * @author Jan Paul Posma
 */
$messages['qqq'] = array(
	'inline-editor-editbox-top' => 'The "edit box" should be as small as possible. It should present the most essential information, and nothing more. It should ask for nothing more but the bare minimum. I chose to include a few basic guidelines, starting with some positive reinforcement: "Awesome, you\'re editing Wikipedia!". This invites novice users to actually edit the article. After all, what they are doing is "awesome"!',
	'inline-editor-editbox-top-new' => 'The welcoming message when creating a new page is similar, but slightly different than the usual message. First, you can use another encouraging word, in this case "Cool", and then tell the user to start typing in the textbox. The word textbox is given a blue highlight, as the textbox below also looks blue on the borders.',
	'inline-editor-editbox-changes-question' => "The line above the edit summary is chosen very carefully: \"Can you briefly describe the changes you're making?\"
Asking for \"changes you ''have'' made\" looks strange when first encountering this page. 
Asking for \"changes you ''will be'' making\" looks strange when
the changes have actually been made. Therefore, the page asks to describe
\"changes you ''are'' making\", which is a continuous process, without
defined start and end points.",
	'inline-editor-editbox-changes-example' => "The line under the textbox suggests some things you can type into it: \"For
example: 'Fixed spelling mistake', 'Corrected facts', 'Wrote a new
paragraph', etc.\" These are not just possible inputs for the textfield, but
possible ''actions'' when editing the page. The user is encouraged to look for
mistakes, and even to write a new paragraph.",
	'inline-editor-editbox-publish-notice' => 'Next to the button is a description: "When you\'re done, don\'t forget to
publish the page!". This text serves two purposes. When reading from top to
bottom, the user is reminded that somewhere there is a way of publishing.
When users haven\'t already found this button, they will now. The second
purpose is telling that anything you do is not final until the page is
published. This way the user is invited to try some things out, as it will not
be published before hitting the button.',
	'inline-editor-editbox-publish-caption' => 'Below the edit summary is the most important button on the page: the
"Publish" button. On the original edit-page, there are some problems with the
"Save" button. The first problem is the caption. "Save" can mean different
things: "Will it be visible for everyone or just saved for myself?", "Will
it be saved into some kind of database, waiting for approval?" "Publish" is
unambiguous: it will be shown to the world. On the other hand, using the word "Publish" may have legal
consequences in some countries, which should be looked into.',
	'accesskey-inline-editor-preview' => 'Please keep this the same as accesskey-preview',
);
