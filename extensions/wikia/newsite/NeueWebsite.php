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

$wgAutoloadClasses['NeueWebsite'] = dirname(__FILE__) . '/NeueWebsite.body.php';
$wgSpecialPages['NeueWebsite'] = 'NeueWebsite';
// $wgHooks['LoadAllMessages'][] = 'NeueWebsite::loadMessages';

$wgExtensionFunctions[] = 'newsitesetup';

function newsitesetup() 
{
  global $wgMessageCache;
  $wgMessageCache->addMessage('neuewebsite', 'Neue Website');
}


?>
