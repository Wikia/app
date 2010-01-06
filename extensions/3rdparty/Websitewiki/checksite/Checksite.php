<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) 
{
        echo <<<EOT
  ... Not installed ...
EOT;
        exit( 1 );
}

$wgAutoloadClasses['Checksite'] = dirname(__FILE__) . '/Checksite.body.php';
$wgSpecialPages['Checksite'] = 'Checksite';
// $wgHooks['LoadAllMessages'][] = 'NeueWebsite::loadMessages';

$wgExtensionFunctions[] = 'checksitesetup';

function checksitesetup() 
{
  global $wgMessageCache;
  $wgMessageCache->addMessage('checksite', 'Website überprüfen');
}


?>
