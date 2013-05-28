<?php
/**
 * Internationalisation file for Special:ApiGate extension.
 *
 * @addtogroup Extensions
 */

// Include the messages from the ApiGate library (they're compatible with MediaWiki).
global $IP;
include "$IP/lib/vendor/ApiGate/i18n/ApiGate_i18n.strings.php";
$apiGateMessages = $messages; // cache to merge together later (SpecialApiGate messages will take preference over ApiGate library messages).

$messages = array();

$messages['en'] = array(
	'apigate' => 'API Gate',
	'apigate-h1' => 'API Control Panel',
	'apigate-desc' => 'API Gate is an Open Source API Key Management system that is being used to manage access to the Wikia API.',
	'apigate-nologin' => 'Please Log in',
	'apigate-nologintext' => 'In order to get an API key, you must log in to a Wikia account.  After login, you will be able to track the API keys for all of your applications in one place - the API Control Panel.',
	'apigate-login-button' => 'Log in',

	'apigate-backtomain' => '&lt; Back to API Control Panel',

	'apigate-error-admins-only' => 'Sorry, only API administrators are authorized to view this data.',

	'apigate-register-success-heading' => 'Registration successful!',
	'apigate-register-success' => "Your new API key is '<big><strong>$1</strong></big>'<br/><br/>You can see the key at any time by coming back to [[Special:ApiGate]] (there is a link in the User menu on the top-right of the page).",
	'apigate-register-success-return' => "Return to the [[Special:ApiGate|API Gate landing page]] to see your new dashboard.",
	'apigate-userlink' => "API Control Panel",

	'apigate-tab-keyinfo' => "Key Info",
	'apigate-tab-keystats' => "Usage Stats",

	'apigate-chart-empty' => "We're currently working on retrieving stats for you. Please hang tight and check back later.",
	'apigate-chart-metric-requests' => "Requests",
	'apigate-chart-name-hourly' => "Requests - Hourly",
	'apigate-chart-name-daily' => "Requests - Daily",
	'apigate-chart-name-weekly' => "Requests - Weekly",
	'apigate-chart-name-monthly' => "Requests - Monthly",
	'apigate-hourly-admin-only' => "<center><em>note: Hourly chart is only displayed to API Gate admins</em></center>\n",
);

/** Message documentation (Message documentation)
 *
 */
$messages['qqq'] = array(
	'apigate-desc' => '{{desc}}',
	'apigate-backtomain' => 'Text that appears in the "breadcrumb"-like link on the top of each subpage, linking back to the main landing page.',
	'apigate-error-admins-only' => 'Displayed if someone tries to view a module which they are not allowed to view because they are not an API Gate admin. Note that since this is on a module-by-module basis, there may be multiple instances of this on a single page.',
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
