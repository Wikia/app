<?php
$messages = array();
 
/* *** English *** */
$messages['en'] = array( 
	'flagpage' => 'Flag an article',
	'flagpage-desc' => "Flag article with predefined templates",
	'flagpage-templatelist' => "<!--
Edit this page to configure templates to use.
Examples:
* [[Template:Unsourced|The article does not cite any references]]
* [[Template:NPOV|The article is written in a biased way]]
* [[Template:Delete|The article should be deleted]]

-->",
	'flagpage-nopageselectedtitle' => 'No page selected',
	'flagpage-nopageselected' => 'You did not specify a page',
	'flagpage-emptylisttitle' => 'No templates configured',
	'flagpage-emptylist' => 'You need to configure your lists of templates. Edit [[{{ns:8}}:flagpage-templatelist]] to do so now.',
	'flagpage-preview' => 'Preview of the selected template:',
	'flagpage-confirmsave' => 'Please confirm your changes. ',
	'flagpage-submitbutton' => 'Save page with this template',
	'flagpage-nonexistent'=> '<span class="plainlinks">The article “$1” does not exist. Perhaps it has been [{{fullurl:Special:Log|page=$1}} moved or deleted].</span>',
	'flagpage-summary' => 'Added template [[$1]] using FlagArticle',
	'flagpage-success' => '[[$1]] has been added to the page [[$2]].',
	'flagpage-tab' => 'flag'
);

