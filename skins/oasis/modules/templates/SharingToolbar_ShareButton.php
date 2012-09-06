<?php

// render "Share" button
echo F::app()->renderView('MenuButton', 'Index', array(
	'action' => array(
		'text' => wfMsg('oasis-share'),
		'html' => '<span class="share-dot"></span><span class="share-pixel"></span>',
		'href' => '#',
		'name' => 'shareButton',
		'accesskey' => false
	),
	'name' => 'shareButton',
	'class' => 'share-button secondary'
));
