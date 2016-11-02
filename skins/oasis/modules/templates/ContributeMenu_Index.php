<?php

// TODO remove after XW-2226 is done
echo F::app()->renderView('MenuButton', 'Index', array(
	'action' => array(
		'text' => 'Add Content',
	),
	'class' => 'contribute add-new-page-experiment-element',
	'image' => MenuButtonController::CONTRIBUTE_ICON,
	'dropdown' => $dropdownItems,
));
// TODO remove end

// render "Contribute" menu
echo F::app()->renderView('MenuButton', 'Index', array(
	'action' => array(
		'text' => wfMsg('oasis-button-contribute-tooltip'),
	),
	'class' => 'contribute secondary',
	'image' => MenuButtonController::CONTRIBUTE_ICON,
	'dropdown' => $dropdownItems,
));
