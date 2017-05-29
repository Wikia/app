<?php
$dir = dirname( __FILE__ ) . '/';

// Hooks
$wgAutoloadClasses[ 'CommunityHeaderHooks' ] = $dir . 'CommunityHeaderHooks.class.php';
$wgHooks[ 'BeforePageDisplay' ][] = 'CommunityHeaderHooks::onBeforePageDisplay';

// Controllers
$wgAutoloadClasses[ 'CommunityHeaderController' ] = $dir . 'CommunityHeaderController.class.php';

// Classes
$wgAutoloadClasses[ 'CommunityHeader\Sitename' ] = $dir . 'Sitename.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Wordmark' ] = $dir . 'Wordmark.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Label' ] = $dir . 'Label.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Image' ] = $dir . 'Image.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Counter' ] = $dir . 'Counter.class.php';
$wgAutoloadClasses[ 'CommunityHeader\WikiButton' ] = $dir . 'WikiButton.class.php';
$wgAutoloadClasses[ 'CommunityHeader\WikiButtons' ] = $dir . 'WikiButtons.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Link'] = $dir . 'Link.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Navigation'] = $dir . 'Navigation.class.php';
