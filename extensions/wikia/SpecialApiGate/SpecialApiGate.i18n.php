<?php
/**
 * Internationalisation file for Special:ApiGate extension.
 *
 * @addtogroup Extensions
 */

// Include the messages from the ApiGate library (they're compatible with MediaWiki).
global $IP;
include "$IP/lib/ApiGate/i18n/ApiGate_i18n.strings.php";
$apiGateMessages = $messages; // cache to merge together later (SpecialApiGate messages will take preference over ApiGate library messages).

$messages = array();

$messages['en'] = array(
	'apigate' => 'API Gate',
	'apigate-desc' => 'API Gate is an Open Source API Key Management system that is being used to manage access to the Wikia API.',
	'apigate-nologin' => 'Please Login',
	'apigate-nologintext' => 'In order to get an API key, you must login to a Wikia account.  After login, you will be able to track the API keys for all of your applications in one place - the API Control Panel.',
	'apigate-login-button' => 'Log in',
	'apigate-register-success' => "Registration successful!<br><br/>Your new API key is '<big><strong>$1</strong></big>'<br/><br/>You can see the key at any time by coming back to [[Special:ApiGate]] (there is a link in the User menu on the top-right of the page).",
	'apigate-register-success-return' => "Return to the [[Special:ApiGate|API Gate landing page]] to see your new dashboard.",
	'apigate-userlink' => "API Control Panel",
	
);

/** Message documentation (Message documentation)
 *
 */
$messages['qqq'] = array(
	'apigate-desc' => '{{desc}}',
	'apigate-userlink' => 'The text that will appear in the dropdown menu of userlinks on the top-right of the page in the Oasis skin (Wikia).',
);

// Merge together the messages.
// SpecialApiGate messages will take preference over ApiGate library messages.
foreach($apiGateMessages as $langCode => $langMessages){
	if( isset($messages[$langCode]) ){
		$messages[$langCode] = array_merge($langMessages, $messages[$langCode]);
	} else {
		$messages[$langCode] = $langMessages;
	}
}
