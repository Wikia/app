<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/SongOfTheDay/Special_SOTD.php" );
EOT;
        exit( 1 );
}
$wgExtensionCredits['specialpage'][] = array(
  'name' => 'SOTD',
  'version' => '0.0.5',
  'author' => '[http://lyrics.wikia.com/User:LWChris Christoph Engels]',
  'url' => 'http://lyrics.wikia.com/User:LWChris',
  'descriptionmsg' => 'sotd-desc',
);
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SOTD'] = $dir . 'Special_SOTD.body.php';
$wgSpecialPages['SOTD'] = 'SOTD';
$wgExtensionMessagesFiles['SOTD'] = $dir . 'Special_SOTD.i18n.php';