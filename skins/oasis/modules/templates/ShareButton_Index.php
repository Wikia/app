<?php

// render "Share" button
echo wfRenderModule('MenuButton', 'Index', array(
	'action' => array(
		'text' => wfMsg('oasis-share'),
		'html' => '<span class="share-dot"></span><span class="share-pixel"></span>',
		'href' => ''
	),
	'name' => 'shareButton',
	'class' => 'share-button secondary'
));
