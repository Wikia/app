<?php 

// namespaces
define( "NS_WIKIA_FORUM_BOARD", 2000 );
define( "NS_WIKIA_FORUM_BOARD_THREAD", 2001 );
$wgExtensionNamespacesFiles['Forum'] = __DIR__ . '/Forum.namespaces.php';
wfLoadExtensionNamespaces( 'Forum', array( NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_BOARD_THREAD ) );

//add this namespace to list of wall namespaces

$wgWallNS[] = NS_WIKIA_FORUM_BOARD;