<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) 
{
        echo <<<EOT
  ... Not installed ...
EOT;
        exit( 1 );
}

$wgAutoloadClasses['Bewertungen'] = dirname(__FILE__) . '/Bewertungen.body.php';
$wgSpecialPages['Bewertungen'] = 'Bewertungen';
// $wgHooks['LoadAllMessages'][] = 'Bewertungen::loadMessages';

$wgExtensionFunctions[] = 'ratingsetup';

function ratingsetup() 
{
  global $wgMessageCache;
    $wgMessageCache->addMessage('bewertungen', 'Bewertungen');
}


?>
