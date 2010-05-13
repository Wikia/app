<?php

// Set up the new special page
$wgAutoloadClasses['BadgeImage'] = dirname( __FILE__ ) . '/badgeImage.body.php';
$wgSpecialPages['BadgeImage'] = 'BadgeImage';
