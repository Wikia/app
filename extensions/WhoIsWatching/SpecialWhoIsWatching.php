<?php

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the skin file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/WhoIsWatching/SpecialWhoIsWatching.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
    'version'     => '0.6',
    'name'        => 'WhoIsWatching',
    'author'      => 'Paul Grinberg, Siebrand Mazeland',
    'email'       => 'gri6507 at yahoo dot com',
    'url'         => 'http://www.mediawiki.org/wiki/Extension:WhoIsWatching',
    'description' => 'Provides a listing of usernames watching a wiki page'
);

$wgAutoloadClasses['WhoIsWatching'] = dirname(__FILE__) . '/SpecialWhoIsWatching_body.php';
$wgSpecialPages['WhoIsWatching'] = 'WhoIsWatching';
$wgHooks['LoadAllMessages'][] = 'WhoIsWatching::loadMessages';
$wgHooks['LanguageGetSpecialPageAliases'][] = 'whoiswatching';

# Set the following to either 'UserName' or 'RealName' to display the list of watching users as such.
$whoiswatching_nametype = 'RealName';

# Set the following to either True or False to optionally allow users to add others to watch a particular page
$whoiswatching_allowaddingpeople = true;

function whoiswatching(&$specialPageArray, $code) {
  # The localized title of the special page is among the messages of the extension:
  WhoIsWatching::loadMessages();
  $text = wfMsg('whoiswatching');

  # Convert from title in text form to DBKey and put it into the alias array:
  $title = Title::newFromText($text);
  $specialPageArray['WhoIsWatching'][] = $title->getDBkey();

  return true;
}

