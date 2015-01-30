<?php
$dropdown = array(array(
	"id" => "wpDiff",
	"accesskey" => wfMsg('accesskey-diff'),
	"text" => wfMsg('showdiff')
));
?>
<?= F::app()->renderView('MenuButton',
	'Index',
	array(
		'action' => array(
			'text' => wfMessage('special-css-publish-button'),
			'class' => 'codepage-publish-button',
			'id' => 'wpSave',
		),
		'name' => 'submit',
		'class' => 'primary',
		'dropdown' => $dropdown
	)
) ?>
