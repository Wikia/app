<?php
# (C) 2008 Steren Giannini
# Licensed under the GNU GPLv2 (or later).

$IP = realpath( dirname( __FILE__ ) . "/../.." );
require_once( "$IP/maintenance/commandLine.inc" );

global $smwgIP;
require_once( $smwgIP . '/includes/SMW_Factbox.php' );

require_once( dirname( __FILE__ ) . '/SemanticTasks.classes.php' );

// Let's send reminders
if ( empty($wgServerNamePath) )
{
    print( "ST check for reminders $wgServerNamePath not set." );
    return 1;
}

SemanticTasksMailer::remindAssignees( $wgServerNamePath );

print( "ST check for reminders\n" );
