<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
This file is not meant to be run by itself, but only as a part of MediaWiki
EOT;
        exit( 1 );
}
 
$dir = dirname(__FILE__) . '/';

//Moderation page
$wgAutoloadClasses['SpecialAdminAds'] = $dir . 'SpecialAdminAds_body.php'; 
$wgAutoloadClasses['Advertisement'] = "$IP/extensions/wikia/SpecialSponsorPage/Advertisements.php";
$wgSpecialPages['AdminAds'] = 'SpecialAdminAds';
