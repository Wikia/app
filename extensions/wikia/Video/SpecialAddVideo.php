<?php

if (!defined('MEDIAWIKI')) {
        echo "This is MediaWiki extension named SpecialAddVideo.\n";
        exit(1) ;
}

//Define permissions
$wgAvailableRights[] = 'AddVideo';
$wgGroupPermissions['*']['AddVideo'] = false;
$wgGroupPermissions['user']['AddVideo'] = true;

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialAddVideo_body.php', 'AddVideo', 'AddVideo');
