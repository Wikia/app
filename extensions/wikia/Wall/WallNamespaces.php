<?php

define( "NS_USER_WALL", 1200 );
define( "NS_USER_WALL_MESSAGE", 1201 );
define( "NS_USER_WALL_MESSAGE_GREETING", 1202 );

$wgExtraNamespaces[ NS_USER_WALL ] = "Message_Wall";

$wgExtraNamespaces[ NS_USER_WALL_MESSAGE ] = "Thread";
$wgExtraNamespaces[ NS_USER_WALL_MESSAGE_GREETING ] = "Message_Wall_Greeting";

