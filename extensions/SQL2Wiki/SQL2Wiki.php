<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension put the following line in LocalSettings.php:
require_once( "\$IP/extensions/SQL2Wiki/SQL2Wiki.php" );
EOT;
        exit( 1 );
}
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'SQL2Wiki',
	'author' => 'freakolowsky [Jure Kajzer] original version by Patrick Müller',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SQL2Wiki',
	'descriptionmsg' => 'sql2wiki-desc',
	'version' => '1.0.0',
);

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'SQL2Wiki',
	'author' => 'Jure Kajzer',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SQL2Wiki',
	'descriptionmsg' => 'sql2wiki-special',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SQL2Wiki'] = $dir . 'SQL2Wiki.i18n.php';

$wgAutoloadClasses['SQL2Wiki'] = $dir . 'SQL2Wiki.body.php';
$wgHooks['ParserFirstCallInit'][] = 'SQL2Wiki::initTags';

$wgAutoloadClasses['SpecialSQL2Wiki'] = $dir . 'SpecialSQL2Wiki.php';
$wgSpecialPages['SQL2Wiki'] = 'SpecialSQL2Wiki';


// list of database contact data
$wgExSql2WikiDatabases = array();
