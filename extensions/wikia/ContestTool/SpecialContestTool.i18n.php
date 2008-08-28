<?php

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named ContestTool.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'cntool-page-title-editor'		=> 'ContestTool :: Editor',
		'cntool-page-title-preview'	=> 'ContestTool :: Preview',
		'cntool-page-title-select'	=> 'ContestTool',
		'cntool-label-select'		=> 'Type in a valid page title',
		'cntool-button-preview'		=> 'Preview',
		'cntool-button-save'		=> 'Save',
		'cntool-label-content'		=> 'Modify article content below:',
		'cntool-label-preview'		=> 'Preview:',
		'cntool-label-caveat'		=> 'Caveat',
		'cntool-caveat'			=> "This extension should not be used lightly.\n\nKeep in mind that the results are not logged anywhere and are not readily reversible at this time without Tech help (this is being worked on)."
	)
);
?>
