<?php

require_once 'extras.php';

$wgHooks['EditFilter'][] = 'stopBlanking';
$wgAvailableRights[] = 'allowedtoblank';
$wgGroupPermissions['sysop']['allowedtoblank'] = true;
$wgExtensionMessagesFiles["PreventBlanking"] = "$LW/Hook_PreventBlanking.i18n.php";

function stopBlanking($editor, $text, $section, &$error )
{
	GLOBAL $wgUser;
	if(( trim($text) == "" ) && (!$wgUser->isAllowed( 'allowedtoblank' )))
	{
		$error = "<p class='error'>".wfMsg("error_blanking")."</p>";
	};

	return true;
}
