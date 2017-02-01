<?php

$formData = [
	'action' => $wg->Title->getLocalURL(),
	'method' => 'post',
	'inputs' => [[
		'type' => 'text',
		'name' => 'target',
		'label' => wfMessage( 'username' ) ->escaped(),
		'value' => $targetName ?? ''
	]],
	'submits' => [[
		'value' => wfMessage( 'lookupbyemail-submit' )->escaped()
	]]
];

echo $app->renderView( WikiaStyleGuideFormController::class, 'index', [ 'form' => $formData ] );
