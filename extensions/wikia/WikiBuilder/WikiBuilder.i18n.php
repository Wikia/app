<?php
global $wgSitename;

$messages = array();

$messages['en'] = array(
	'owb-headline' => 'Hi, '.$wgSitename,
	'owb-button-skip' => 'Skip',
	'owb-button-save-intro' => 'Save Intro',
	'owb-button-save-theme' => 'Save Theme',
	'owb-button-done' => 'Done',
	'owb-step1' => 'Step 1',
	'owb-step1-label' => "What's it about?",
	'owb-step1-label-formatted' => "What's<br> it about?",
	'owb-step1-instruction' => "Write a brief intro for your home page.  Make it snappy and fun to get others excited about contributing to your project.",
	'owb-step1-sample' => 'Sample Wiki Home Page',
	'owb-step2' => 'Step 2',
	'owb-step2-label' => 'Choose a theme',
	'owb-step2-label-formatted' => 'Choose<br>a theme',
	'owb-step2-instruction1' => "It's easy to make your wiki look unique.  Just choose a theme that fits your project.",
	'owb-step2-instruction2' => 'You can change your theme or design your own any time.',
	'owb-step2-gallery' => 'Theme Gallery',
	'owb-step3' => 'Step 3',
	'owb-step3-label' => 'Start some pages',
	'owb-step3-label-formatted' => 'Start<br>some pages',
	'owb-step3-instruction' => 'To start your wiki, you need to add some pages.  You can add more whenever you like.',
	'owb-step3-your-pages' => 'Your Page Names',
	'owb-step3-examples1-title' => 'Sample: Monster Movies Page Names',
	'owb-step3-examples1' => "<li>Frankenstein's Monster</li><li>The Wolfman</li><li>The Howling</li><li>The Mummy</li><li>House of Wax</li><li>Swamp Thing</li>",
	'owb-step3-examples2-title' => 'Sample: Board Games Page Names',
	'owb-step3-examples2' => "<li>Monopoly</li><li>Risk</li><li>Scrabble</li><li>Trivial Pursuit</li><li>Pictionary</li><li>Taboo</li>",
	'owb-status-saving' => "Saving",
	"owb-unable-to-edit-description" => "The description is uneditable with Wiki Builder",
	"owb-readonly-try-again" => "The Wiki is currently in readonly mode. Please try again in a few moments",
	"owb-error-saving-articles" => "Error Saving Pages",
	"owb-new-pages-text" => "[[File:Placeholder|right|300px]]
Write the first paragraph of your article here.

==Section heading==

Write the first section of your article here. Remember to include links to other pages on the wiki.

==Section heading==

Write the second section of your article here. Don't forget to add a category, to help people find the article.",
);

global $OWBmessages;
$OWBmessages = $messages;