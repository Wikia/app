<?php
$dir = dirname( __FILE__ ) . '/';

// Controllers
$wgAutoloadClasses[ 'CommunityHeaderController' ] = $dir . 'CommunityHeaderController.class.php';

// Classes
$wgAutoloadClasses[ 'CommunityHeader\Wordmark' ] = $dir . 'Wordmark.class.php';
