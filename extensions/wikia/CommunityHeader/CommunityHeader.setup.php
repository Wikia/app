<?php
$dir = dirname( __FILE__ ) . '/';

// Controllers
$wgAutoloadClasses[ 'CommunityHeaderController' ] = $dir . 'CommunityHeaderController.class.php';

// Classes
$wgAutoloadClasses[ 'CommunityHeader\Sitename' ] = $dir . 'Sitename.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Wordmark' ] = $dir . 'Wordmark.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Label' ] = $dir . 'Label.class.php';
$wgAutoloadClasses[ 'CommunityHeader\Image' ] = $dir . 'Image.class.php';
