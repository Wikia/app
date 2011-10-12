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
);

/** Message documentation (Message documentation)
 *
 */
$messages['qqq'] = array(
	'apigate-desc' => '{{desc}}',
);

// Merge together the messages.
// SpecialApiGate messages will take preference over ApiGate library messages.
$messages = array_merge($apiGateMessages, $messages);
