<?php
$dropdown = array(array(
	"id" => "wpDiff",
	"accesskey" => wfMessage('accesskey-diff')->escaped(),
	"text" => wfMessage('showdiff')->escaped()
));
?>
<?= F::app()->renderView('MenuButton',
	'Index',
	array(
		'action' => array(
			'text' => wfMessage('savearticle')->escaped(),
			'class' => 'codepage-publish-button',
			'id' => 'wpSave',
		),
		'name' => 'submit',
		'class' => 'primary',
		'dropdown' => $dropdown
	)
) ?>
