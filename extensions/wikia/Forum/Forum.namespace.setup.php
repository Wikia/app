<?php

// namespaces
define( "NS_WIKIA_FORUM_BOARD", 2000 );
define( "NS_WIKIA_FORUM_BOARD_THREAD", 2001 );
define( "NS_WIKIA_FORUM_TOPIC_BOARD", 2002 );

$wgExtensionNamespacesFiles['Forum'] = __DIR__ . '/Forum.namespaces.php';

if ( !empty( $wgEnableForumExt ) ) {
	wfLoadExtensionNamespaces( 'Forum',
	array(
		NS_WIKIA_FORUM_BOARD,
		NS_WIKIA_FORUM_BOARD_THREAD,
		NS_WIKIA_FORUM_TOPIC_BOARD
	) );
}


$wgWallNS[] = NS_WIKIA_FORUM_BOARD;
$wgWallNotifyEveryoneNS[] = NS_WIKIA_FORUM_BOARD;
$wgWallVotesNS[] = NS_WIKIA_FORUM_BOARD;
$wgWallThreadCloseNS[] = NS_WIKIA_FORUM_BOARD;
$wgWallTopicsNS[] = NS_WIKIA_FORUM_BOARD;
