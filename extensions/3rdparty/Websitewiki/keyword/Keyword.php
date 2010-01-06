<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) 
{
        echo <<<EOT
  ... Not installed ...
EOT;
        exit( 1 );
}

$wgAutoloadClasses['Keyword'] = dirname(__FILE__) . '/Keyword.body.php';
$wgSpecialPages['Keyword'] = 'Keyword';
// $wgHooks['LoadAllMessages'][] = 'Keyword::loadMessages';

$wgExtensionFunctions[] = 'ex_keywordsetup';

function ex_keywordsetup() 
{
  global $wgMessageCache;
  $wgMessageCache->addMessage('keyword', 'Keyword');
}


?>
