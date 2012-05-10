<?php

// render "Contribute" menu
echo wfRenderModule('MenuButton', 'Index', array(
	'action' => array(
		'text' => wfMsg('oasis-button-contribute-tooltip'),
	),
	'class' => 'contribute secondary',
	'image' => MenuButtonController::CONTRIBUTE_ICON,
	'dropdown' => $dropdownItems,
));
