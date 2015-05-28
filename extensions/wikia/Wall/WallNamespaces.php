<?php


// TODO: maybe just move it back to setup ?
define( "NS_USER_WALL", 1200 );
define( "NS_USER_WALL_MESSAGE", 1201 );
define( "NS_USER_WALL_MESSAGE_GREETING", 1202 );

$wgExtensionNamespacesFiles['Wall'] = __DIR__ . '/Wall.namespaces.php';
wfLoadExtensionNamespaces( 'Wall', array( NS_USER_WALL, NS_USER_WALL_MESSAGE, NS_USER_WALL_MESSAGE_GREETING ) );

$wgWallNS = array( NS_USER_WALL );
$wgWallVotesNS = array();
$wgWallNotifyEveryoneNS = array();
$wgWallThreadCloseNS = array( NS_USER_WALL );
$wgWallTopicsNS = array();