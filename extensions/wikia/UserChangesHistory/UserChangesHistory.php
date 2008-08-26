<?php

/**
 * Register when & where user is logged in
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
 */

$wgHooks[ "UserLoginComplete" ][ ] = array( "UserChangesHistory::LoginHistoryHook", 1 /* UserChangesHistory::LOGIN_FORM */ );
#$wgHooks[ "UserLoadFromSession" ][ ] = array( "UserChangesHistory::LoginHistoryInsert", 0 /* UserChangesHistory::LOGIN_AUTO */ );
$wgHooks[ "SavePreferences" ][ ] = array( "UserChangesHistory::SavePreferencesHook" );

/**
 * load file with class
 */
$wgAutoloadClasses[ "UserChangesHistory" ] =  dirname(__FILE__) . "/UserChangesHistory.class.php";
