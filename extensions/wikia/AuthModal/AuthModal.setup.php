<?php

$wgAutoloadClasses['AuthModalHooks'] = dirname( __FILE__ ) . '/' . 'AuthModalHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'AuthModalHooks::onBeforePageDisplay';
