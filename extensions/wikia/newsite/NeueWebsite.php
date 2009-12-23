<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) 
{
        echo <<<EOT
  ... Not installed ...
EOT;
        exit( 1 );
}

include('neue_website.php');

$dir = dirname(__FILE__);

$wgAutoloadClasses['NeueWebsite'] = $dir . '/NeueWebsite.body.php';
$wgSpecialPages['NeueWebsite'] = 'NeueWebsite';
$wgExtensionMessagesFiles['Newsite'] = $dir . '/NeueWebsite.i18n.php';
