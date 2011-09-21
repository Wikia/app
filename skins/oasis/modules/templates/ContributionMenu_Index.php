<?php

// render "Contribute" menu
echo wfRenderModule('MenuButton', 'Index', array(
	'action' => array(
		'text' => wfMsg('oasis-button-contribute-tooltip'),
	),
	'class' => 'secondary contribute',
	'image' => MenuButtonModule::CONTRIBUTE_ICON,
	'dropdown' => $dropdownItems,
	'contribute' => true
));
