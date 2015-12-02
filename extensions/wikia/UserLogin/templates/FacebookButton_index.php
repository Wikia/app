<?php
	echo F::app()->renderView( 'MenuButton', 'Index', array(
		'name' => 'facebook',
		'action' => array(
			'text' => $text,
			'href' => '#',
			'accesskey' => false,
		),
		'class' => trim( "wikia-button-facebook {$class}" ),
		'image' => MenuButtonController::FACEBOOK_ICON,
		'tooltip' => $tooltip,
		'tabindex' => $tabindex,
	) );
