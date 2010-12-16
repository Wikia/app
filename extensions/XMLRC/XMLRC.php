<?php

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "XMLRC extension";
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'author' => array( 'Daniel Kinzler' ),
	'name' => 'XMLRC',
	'url' => 'http://www.mediawiki.org/wiki/Extension:XMLRC',
	'description' => 'Sends notifications about changes as XML, via UDP, Jabber or other means',
	'descriptionmsg'=> 'xmlrc-desc',	
);

# Internationalisation file
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['XMLRC'] = $dir . 'XMLRC.i18n.php';
#$wgExtensionAliasesFiles['XMLRC'] = $dir . 'XMLRC.alias.php';

$wgXMLRCTransport = array(
  'class' => 'XMLRC_File',
  'file' => '/tmp/rc.xml',
);

/*
$wgXMLRCTransport = array(
  'class' => 'XMLRC_XMPP',
  'channel' => 'recentchanges',
  'nickname' => $wgSitename,
  'host' => 'localhost',
  'port' => 5347,
  'user' => 'mediawiki',
  'server' => 'localhost',
  'resource' => 'recentchanges',
  'password' => 'yourpassword',
  'include_path' => './xmpphp',
);
*/

/*
$wgXMLRCTransport = array(
  'class' => 'XMLRC_UDP',
  'address' => 'localhost',
  'port' => 12345,
);
*/

$wgAutoloadClasses[ 'XMLRC' ] = "$dir/XMLRC.class.php";
$wgAutoloadClasses[ 'XMLRC_Transport' ] = "$dir/XMLRC.class.php";
$wgAutoloadClasses[ 'XMLRC_XMPP' ] = "$dir/XMLRC_XMPP.class.php";
$wgAutoloadClasses[ 'XMLRC_UDP' ] = "$dir/XMLRC_UDP.class.php";
$wgAutoloadClasses[ 'XMLRC_File' ] = "$dir/XMLRC_File.class.php";

$wgHooks['RecentChange_save'][] = 'XMLRC::RecentChange_save';
