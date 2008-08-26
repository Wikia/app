<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MyExtension/MyExtension.php" );
EOT;
        exit( 1 );
}

$wgAutoloadClasses['MyExtension'] = dirname(__FILE__) . '/MyExtension_body.php';
$wgSpecialPages['MyExtension'] = 'MyExtension';
$wgHooks['LoadAllMessages'][] = 'MyExtension::loadMessages';


