<?php


if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named CovertOps.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'cops-page-title-editor'		=> 'CovertOps :: Editor',
		'cops-page-title-preview'	=> 'CovertOps :: Preview',
		'cops-page-title-select'	=> 'CovertOps',
		'cops-label-select'		=> 'Type in a valid page title',
		'cops-button-preview'		=> 'Preview',
		'cops-button-save'		=> 'Save',
		'cops-label-content'		=> 'Modify article content below:',
		'cops-label-preview'		=> 'Preview:',
		'cops-label-caveat'		=> 'Caveat',
		'cops-caveat'			=> "This extension should not be used lightly.\n\nKeep in mind that the results are not logged anywhere and are not readily reversible at this time without Tech help (this is being worked on)."
	)
);
?>
