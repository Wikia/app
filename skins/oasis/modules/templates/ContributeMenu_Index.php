<?php

// render "Contribute" menu
echo $app->renderView( 'MenuButton', 'Index', [
	'action' => [
		'text' => wfMessage( 'oasis-button-contribute-tooltip' )->text(),
	],
	'class' => 'contribute secondary',
	'image' => MenuButtonController::CONTRIBUTE_ICON,
	'dropdown' => $dropdownItems,
] );
