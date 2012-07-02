<?php

/**
 * Donation Interface
 *
 *  To install the DontaionInterface extension, put the following line in LocalSettings.php:
 *	require_once( "\$IP/extensions/DonationInterface/donationinterface.php" );
 *
 */


# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the DontaionInterface extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/DonationInterface/donationinterface.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Donation Interface',
	'author' => array( 'Katie Horn', 'Ryan Kaldari' , 'Arthur Richards', 'Jeremy Postlethwaite' ),
	'version' => '2.0.0',
	'descriptionmsg' => 'donationinterface-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:DonationInterface',
);

$donationinterface_dir = dirname( __FILE__ ) . '/';

/**
 * Figure out what we've got enabled.
 */

$optionalParts = array( //define as fail closed. This variable will be unset before we leave this file.
	'Extras' => false, //this one gets set in the next loop, so don't bother.
	'CustomFilters' => false, //Also gets set in the next loop.
	'Stomp' => false,
	'ConversionLog' => false, //this is definitely an Extra
	'Minfraud' => false, //this is definitely an Extra
	'Recaptcha' => false, //extra
	'PayflowPro' => false,
	'GlobalCollect' => false,
	'ReferrerFilter' => false, //extra
	'SourceFilter' => false, //extra
	'FunctionsFilter' => false, //extra
	'Minfraud_as_filter' => false, //extra

);

foreach ($optionalParts as $subextension => $enabled){
	$globalname = 'wgDonationInterfaceEnable' . $subextension;
	global $$globalname;
	if ( isset( $$globalname ) && $$globalname === true ) {
		$optionalParts[$subextension] = true;
		//this is getting annoying.
		if ( $subextension === 'ReferrerFilter' ||
			$subextension === 'SourceFilter' ||
			$subextension === 'FunctionsFilter' ||
			$subextension === 'Minfraud_as_filter' ||
			$subextension === 'ConversionLog' ||
			$subextension === 'Minfraud' ||
			$subextension === 'Recaptcha' ) {

			//we have extras
			$optionalParts['Extras'] = true;

			if ( $subextension === 'ReferrerFilter' ||
				$subextension === 'SourceFilter' ||
				$subextension === 'FunctionsFilter' ||
				$subextension === 'Minfraud_as_filter' ){

				//and at least one of them is a custom filter.
				$optionalParts['CustomFilters'] = true;
				$wgDonationInterfaceEnableCustomFilters = true; //override this for specific gateways to disable
			}
		}

	}
}


/**
 * CLASSES
 */
$wgAutoloadClasses['DonationData'] = $donationinterface_dir . 'gateway_common/DonationData.php';
$wgAutoloadClasses['GatewayAdapter'] = $donationinterface_dir . 'gateway_common/gateway.adapter.php';
$wgAutoloadClasses['GatewayForm'] = $donationinterface_dir . 'gateway_common/GatewayForm.php';
$wgAutoloadClasses['DataValidator'] = $donationinterface_dir . 'gateway_common/DataValidator.php';

//load all possible form classes
$wgAutoloadClasses['Gateway_Form'] = $donationinterface_dir . 'gateway_forms/Form.php';
$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumn'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumn.php';
$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumnLetter'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumnLetter.php';
$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumnLetter3'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumnLetter3.php';
$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumnLetterCA'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumnLetterCA.php';
$wgAutoloadClasses['Gateway_Form_RapidHtml'] = $donationinterface_dir . 'gateway_forms/RapidHtml.php';

// All these form classes are available, but not enabled by default. 
// If you want them enabled, copy the desired lines into your LocalSettings.php, and uncomment. 
//$wgAutoloadClasses['Gateway_Form_OneStepTwoColumn'] = $donationinterface_dir . 'gateway_forms/OneStepTwoColumn.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnPayPal'] = $donationinterface_dir . 'gateway_forms/TwoColumnPayPal.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnLetter'] = $donationinterface_dir . 'gateway_forms/TwoColumnLetter.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnLetter2'] = $donationinterface_dir . 'gateway_forms/TwoColumnLetter2.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnLetter3'] = $donationinterface_dir . 'gateway_forms/TwoColumnLetter3.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnLetter4'] = $donationinterface_dir . 'gateway_forms/TwoColumnLetter4.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnLetter5'] = $donationinterface_dir . 'gateway_forms/TwoColumnLetter5.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnLetter6'] = $donationinterface_dir . 'gateway_forms/TwoColumnLetter6.php';
//$wgAutoloadClasses['Gateway_Form_TwoColumnLetter7'] = $donationinterface_dir . 'gateway_forms/TwoColumnLetter7.php';
//$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumnLetterCA'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumnLetterCA.php';
//$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumnLetter2'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumnLetter2.php';
//$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumnPremium'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumnPremium.php';
//$wgAutoloadClasses['Gateway_Form_TwoStepTwoColumnPremiumUS'] = $donationinterface_dir . 'gateway_forms/TwoStepTwoColumnPremiumUS.php';
//$wgAutoloadClasses['Gateway_Form_SingleColumn'] = $donationinterface_dir . 'gateway_forms/SingleColumn.php';

//GlobalCollect gateway classes
if ( $optionalParts['GlobalCollect'] === true ){
	$wgAutoloadClasses['GlobalCollectGateway'] = $donationinterface_dir . 'globalcollect_gateway/globalcollect_gateway.body.php';
	$wgAutoloadClasses['GlobalCollectGatewayResult'] = $donationinterface_dir . 'globalcollect_gateway/globalcollect_resultswitcher.body.php';
	$wgAutoloadClasses['GlobalCollectAdapter'] = $donationinterface_dir . 'globalcollect_gateway/globalcollect.adapter.php';
}

//PayflowPro gateway classes
if ( $optionalParts['PayflowPro'] === true ){
	$wgAutoloadClasses['PayflowProGateway'] = $donationinterface_dir . 'payflowpro_gateway/payflowpro_gateway.body.php';
	$wgAutoloadClasses['PayflowProAdapter'] = $donationinterface_dir . 'payflowpro_gateway/payflowpro.adapter.php';
}

//Stomp classes
if ($optionalParts['Stomp'] === true){
	$wgAutoloadClasses['activemq_stomp'] = $donationinterface_dir . 'activemq_stomp/activemq_stomp.php'; # Tell MediaWiki to load the extension body.
}

//Extras classes - required for ANY optional class that is considered an "extra".
if ($optionalParts['Extras'] === true){
	$wgAutoloadClasses['Gateway_Extras'] = $donationinterface_dir . "extras/extras.body.php";
}

//Custom Filters classes
if ($optionalParts['CustomFilters'] === true){
	$wgAutoloadClasses['Gateway_Extras_CustomFilters'] = $donationinterface_dir . "extras/custom_filters/custom_filters.body.php";
}

//Conversion Log classes
if ($optionalParts['ConversionLog'] === true){
	$wgAutoloadClasses['Gateway_Extras_ConversionLog'] = $donationinterface_dir . "extras/conversion_log/conversion_log.body.php";
}

//Minfraud classes
if ( $optionalParts['Minfraud'] === true || $optionalParts['Minfraud_as_filter'] === true ){
	$wgAutoloadClasses['Gateway_Extras_MinFraud'] = $donationinterface_dir . "extras/minfraud/minfraud.body.php";
}

//Minfraud as Filter classes
if ( $optionalParts['Minfraud_as_filter'] === true ){
	$wgAutoloadClasses['Gateway_Extras_CustomFilters_MinFraud'] = $donationinterface_dir . "extras/custom_filters/filters/minfraud/minfraud.body.php";
}

//Referrer Filter classes
if ( $optionalParts['ReferrerFilter'] === true ){
	$wgAutoloadClasses['Gateway_Extras_CustomFilters_Referrer'] = $donationinterface_dir . "extras/custom_filters/filters/referrer/referrer.body.php";
}

//Source Filter classes
if ( $optionalParts['SourceFilter'] === true ){
	$wgAutoloadClasses['Gateway_Extras_CustomFilters_Source'] = $donationinterface_dir . "extras/custom_filters/filters/source/source.body.php";
}

//Functions Filter classes
if ( $optionalParts['FunctionsFilter'] === true ){
	$wgAutoloadClasses['Gateway_Extras_CustomFilters_Functions'] = $donationinterface_dir . "extras/custom_filters/filters/functions/functions.body.php";
}

//Recaptcha classes
if ( $optionalParts['Recaptcha'] === true ){
	$wgAutoloadClasses['Gateway_Extras_ReCaptcha'] = $donationinterface_dir . "extras/recaptcha/recaptcha.body.php";
}


/**
 * GLOBALS
 */

/**
 * Global form dir and RapidHTML whitelist
 */
$wgDonationInterfaceHtmlFormDir = dirname( __FILE__ ) . "/gateway_forms/rapidhtml/html";
//ffname is the $key from now on.
$wgDonationInterfaceAllowedHtmlForms = array(
	'globalcollect_test' => $wgDonationInterfaceHtmlFormDir . "/globalcollect_test.html",
	'globalcollect_test_2' => $wgDonationInterfaceHtmlFormDir . "/globalcollect_test_2.html",
);

$wgDonationInterfaceTest = false;

/**
 * The URL to redirect a transaction to PayPal
 * This should probably point to ContributionTracking.
 */
$wgDonationInterfacePaypalURL = '';
$wgDonationInterfaceRetrySeconds = 5;

//all of the following variables make sense to override directly,
//or change "DonationInterface" to the gateway's id to override just for that gateway.
//for instance: To override $wgDonationInterfaceUseSyslog just for GlobalCollect, add
// $wgGlobalCollectGatewayUseSyslog = true
// to LocalSettings.
//

$wgDonationInterfaceDisplayDebug = false;
$wgDonationInterfaceUseSyslog = false;
$wgDonationInterfaceSaveCommStats = false;

$wgDonationInterfaceCSSVersion = 1;
$wgDonationInterfaceTimeout = 5;
$wgDonationInterfaceDefaultForm = 'TwoStepTwoColumnLetter';

/**
 * A string or array of strings for making tokens more secure
 *
 * Please set this!  If you do not, tokens are easy to get around, which can
 * potentially leave you and your users vulnerable to CSRF or other forms of
 * attack.
 */
$wgDonationInterfaceSalt = $wgSecretKey;

/**
 * A string that can contain wikitext to display at the head of the credit card form
 *
 * This string gets run like so: $wg->addHtml( $wg->Parse( $wgpayflowGatewayHeader ))
 * You can use '@language' as a placeholder token to extract the user's language.
 *
 */
$wgDonationInterfaceHeader = NULL;

/**
 * A string containing full URL for Javascript-disabled credit card form redirect
 */
$wgDonationInterfaceNoScriptRedirect = null;

/**
 * Proxy settings
 *
 * If you need to use an HTTP proxy for outgoing traffic,
 * set wgPayflowProGatewayUseHTTPProxy=TRUE and set $wgPayflowProGatewayHTTPProxy
 * to the proxy desination.
 *  eg:
 *  $wgPayflowProGatewayUseHTTPProxy=TRUE;
 *  $wgPayflowProGatewayHTTPProxy='192.168.1.1:3128'
 */
$wgDonationInterfaceUseHTTPProxy = FALSE;
$wgDonationInterfaceHTTPProxy = '';

/**
 * Set the max-age value for Squid
 *
 * If you have Squid enabled for caching, use this variable to configure
 * the s-max-age for cached requests.
 * @var int Time in seconds
 */
$wgDonationInterfaceSMaxAge = 6000;

/**
 * Configure price ceiling and floor for valid contribution amount.  Values
 * should be in USD.
 */
$wgDonationInterfacePriceFloor = '1.00';
$wgDonationInterfacePriceCeiling = '10000.00';

/**
 * Default Thank You and Fail pages for all of donationinterface - language will be calc'd and appended at runtime.
 */
//$wgDonationInterfaceThankYouPage = 'https://wikimediafoundation.org/wiki/Thank_You';
$wgDonationInterfaceThankYouPage = 'Donate-thanks';
$wgDonationInterfaceFailPage = 'Donate-error'; 


//GlobalCollect gateway globals
if ( $optionalParts['GlobalCollect'] === true ){
	$wgGlobalCollectGatewayURL = 'https://ps.gcsip.nl/wdl/wdl';
	$wgGlobalCollectGatewayTestingURL = 'https://'; // GlobalCollect testing URL

	$wgGlobalCollectGatewayMerchantID = ''; // GlobalCollect ID

	$wgGlobalCollectGatewayHtmlFormDir = $donationinterface_dir . 'globalcollect_gateway/forms/html';
	//this really should be redefined in LocalSettings.
	$wgGlobalCollectGatewayAllowedHtmlForms = $wgDonationInterfaceAllowedHtmlForms;
	$wgGlobalCollectGatewayAllowedHtmlForms['lightbox1'] = $wgGlobalCollectGatewayHtmlFormDir .'/lightbox1.html';
	
	$wgGlobalCollectGatewayCvvMap = array(
		'M' => true, //CVV check performed and valid value.
		'N' => false, //CVV checked and no match.
		'P' => true, //CVV check not performed, not requested
		'S' => false, //Card holder claims no CVV-code on card, issuer states CVV-code should be on card. 
		'U' => true, //? //Issuer not certified for CVV2.
		'Y' => false, //Server provider did not respond.
		'0' => true, //No service available.
	);
	
	$wgGlobalCollectGatewayAvsMap = array(
		'A' => 50, //Address (Street) matches, Zip does not.
		'B' => 50, //Street address match for international transactions. Postal code not verified due to incompatible formats.
		'C' => 50, //Street address and postal code not verified for international transaction due to incompatible formats.
		'D' => 0, //Street address and postal codes match for international transaction.
		'E' => 100, //AVS Error.
		'F' => 0, //Address does match and five digit ZIP code does match (UK only).
		'G' => 50, //Address information is unavailable; international transaction; non-AVS participant. 
		'I' => 50, //Address information not verified for international transaction.
		'M' => 0, //Street address and postal codes match for international transaction.
		'N' => 100, //No Match on Address (Street) or Zip.
		'P' => 50, //Postal codes match for international transaction. Street address not verified due to incompatible formats.
		'R' => 100, //Retry, System unavailable or Timed out.
		'S' => 50, //Service not supported by issuer.
		'U' => 50, //Address information is unavailable.
		'W' => 50, //9 digit Zip matches, Address (Street) does not.
		'X' => 0, //Exact AVS Match.
		'Y' => 0, //Address (Street) and 5 digit Zip match.
		'Z' => 50, //5 digit Zip matches, Address (Street) does not.
		'0' => 50, //No service available.
	);	
	
}

//PayflowPro gateway globals
if ( $optionalParts['PayflowPro'] === true ){
	$wgPayflowProGatewayURL = 'https://payflowpro.paypal.com';
	$wgPayflowProGatewayTestingURL = 'https://pilot-payflowpro.paypal.com'; // Payflow testing URL

	$wgPayflowProGatewayPartnerID = ''; // PayPal or original authorized reseller
	$wgPayflowProGatewayVendorID = ''; // paypal merchant login ID
	$wgPayflowProGatewayUserID = ''; // if one or more users are set up, authorized user ID, else same as VENDOR
	$wgPayflowProGatewayPassword = ''; // merchant login password

	$wgPayflowProGatewayHtmlFormDir = $donationinterface_dir . 'payflowpro_gateway/forms/html';
	//this really should be redefined in LocalSettings.
	$wgPayflowProGatewayAllowedHtmlForms = $wgDonationInterfaceAllowedHtmlForms;
	$wgPayflowProGatewayAllowedHtmlForms['lightbox1'] = $wgPayflowProGatewayHtmlFormDir .'/lightbox1.html';
	
	//defaults to not doing the new fail page redirect. 
	$wgPayflowProGatewayFailPage = false;
}

//Stomp globals
if ($optionalParts['Stomp'] === true){
	$wgStompServer = "";
	//$wgStompQueueName = ""; //only set this with an actual value. Default is unset.
	//$wgPendingStompQueueName = ""; //only set this with an actual value. Default is unset.
	//$wgLimboStompQueueName = ""; //only set this with an actual value. Default is unset.
	//$wgCCLimboStompQueueName = ""; //only set this with an actual value. Default is unset.
}

//Extras globals - required for ANY optional class that is considered an "extra".
if ($optionalParts['Extras'] === true){
	$wgDonationInterfaceExtrasLog = '';
}

//Custom Filters globals
if ( $optionalParts['CustomFilters'] === true ){
	//Define the action to take for a given $risk_score
	$wgDonationInterfaceCustomFiltersActionRanges = array(
		'process' => array( 0, 100 ),
		'review' => array( -1, -1 ),
		'challenge' => array( -1, -1 ),
		'reject' => array( -1, -1 ),
	);

	/**
	 * A value for tracking the 'riskiness' of a transaction
	 *
	 * The action to take based on a transaction's riskScore is determined by
	 * $action_ranges.  This is built assuming a range of possible risk scores
	 * as 0-100, although you can probably bend this as needed.
	 */
	$wgDonationInterfaceCustomFiltersRiskScore = 0;
}

//Minfraud globals
if ( $optionalParts['Minfraud'] === true || $optionalParts['Minfraud_as_filter'] === true ){
	/**
	 * Your minFraud license key.
	 */
	$wgMinFraudLicenseKey = '';

	/**
	 * Set the risk score ranges that will cause a particular 'action'
	 *
	 * The keys to the array are the 'actions' to be taken (eg 'process').
	 * The value for one of these keys is an array representing the lower
	 * and upper bounds for that action.  For instance,
	 *   $wgMinFraudActionRagnes = array(
	 * 		'process' => array( 0, 100)
	 * 		...
	 * 	);
	 * means that any transaction with a risk score greather than or equal
	 * to 0 and less than or equal to 100 will be given the 'process' action.
	 *
	 * These are evauluated on a >= or <= basis.  Please refer to minFraud
	 * documentation for a thorough explanation of the 'riskScore'.
	 */
	$wgDonationInterfaceMinFraudActionRanges = array(
		'process' => array( 0, 100 ),
		'review' => array( -1, -1 ),
		'challenge' => array( -1, -1 ),
		'reject' => array( -1, -1 )
	);

	// Timeout in seconds for communicating with MaxMind
	$wgMinFraudTimeout = 2;

	/**
	 * Define whether or not to run minFraud in stand alone mode
	 *
	 * If this is set to run in standalone, these scripts will be
	 * accessed directly via the "GatewayValidate" hook.
	 * You may not want to run this in standalone mode if you prefer
	 * to use this in conjunction with Custom Filters.  This has the
	 * advantage of sharing minFraud info with other filters.
	 */
	$wgMinFraudStandalone = TRUE;

}

//Minfraud as Filter globals
if ( $optionalParts['Minfraud_as_filter'] === true ){
	$wgMinFraudStandalone = FALSE;
}

//Referrer Filter globals
if ( $optionalParts['ReferrerFilter'] === true ){
	$wgDonationInterfaceCustomFiltersRefRules = array( );
}

//Source Filter globals
if ( $optionalParts['SourceFilter'] === true ){
	$wgDonationInterfaceCustomFiltersSrcRules = array( );
}

//Functions Filter globals
if ( $optionalParts['FunctionsFilter'] === true ){
	$wgDonationInterfaceCustomFiltersFunctions = array( );
}

//Recaptcha globals
if ( $optionalParts['Recaptcha'] === true ){
	/**
	 * Public and Private reCaptcha keys
	 *
	 * These can be obtained at:
	 *   http://www.google.com/recaptcha/whyrecaptcha
	 */
	$wgDonationInterfaceRecaptchaPublicKey = '';
	$wgDonationInterfaceRecaptchaPrivateKey = '';

	// Timeout (in seconds) for communicating with reCatpcha
	$wgDonationInterfaceRecaptchaTimeout = 2;

	/**
	 * HTTP Proxy settings
	 */
	$wgDonationInterfaceRecaptchaUseHTTPProxy = false;
	$wgDonationInterfaceRecaptchaHTTPProxy = false;

	/**
	 * Use SSL to communicate with reCaptcha
	 */
	$wgDonationInterfaceRecaptchaUseSSL = 1;

	/**
	 * The # of times to retry communicating with reCaptcha if communication fails
	 * @var int
	 */
	$wgDonationInterfaceRecaptchaComsRetryLimit = 3;
}

/**
 * SPECIAL PAGES
 */

//GlobalCollect gateway special pages
if ( $optionalParts['GlobalCollect'] === true ){
	$wgSpecialPages['GlobalCollectGateway'] = 'GlobalCollectGateway';
	$wgSpecialPages['GlobalCollectGatewayResult'] = 'GlobalCollectGatewayResult';
}
//PayflowPro gateway special pages
if ( $optionalParts['PayflowPro'] === true ){
	$wgSpecialPages['PayflowProGateway'] = 'PayflowProGateway';
}


/**
 * HOOKS
 */

//Unit tests
$wgHooks['UnitTestsList'][] = 'efDonationInterfaceUnitTests';

//Stomp hooks
if ($optionalParts['Stomp'] === true){
	$wgHooks['ParserFirstCallInit'][] = 'efStompSetup';
	$wgHooks['gwStomp'][] = 'sendSTOMP';
	$wgHooks['gwPendingStomp'][] = 'sendPendingSTOMP';
	$wgHooks['gwLimboStomp'][] = 'sendLimboSTOMP';
}

//Custom Filters hooks
if ($optionalParts['CustomFilters'] === true){
	$wgHooks["GatewayValidate"][] = array( 'Gateway_Extras_CustomFilters::onValidate' );
}

//Referrer Filter hooks
if ( $optionalParts['ReferrerFilter'] === true ){
	$wgHooks["GatewayCustomFilter"][] = array( 'Gateway_Extras_CustomFilters_Referrer::onFilter' );
}

//Source Filter hooks
if ( $optionalParts['SourceFilter'] === true ){
	$wgHooks["GatewayCustomFilter"][] = array( 'Gateway_Extras_CustomFilters_Source::onFilter' );
} 

//Functions Filter hooks
if ( $optionalParts['FunctionsFilter'] === true ){
	$wgHooks["GatewayCustomFilter"][] = array( 'Gateway_Extras_CustomFilters_Functions::onFilter' );
} 

//Conversion Log hooks
if ($optionalParts['ConversionLog'] === true){
	// Sets the 'conversion log' as logger for post-processing
	$wgHooks["GatewayPostProcess"][] = array( "Gateway_Extras_ConversionLog::onPostProcess" );
}

//Recaptcha hooks
if ($optionalParts['Recaptcha'] === true){
	// Set reCpatcha as plugin for 'challenge' action
	$wgHooks["GatewayChallenge"][] = array( "Gateway_Extras_ReCaptcha::onChallenge" );
}

/**
 * APIS
 */
// enable the API
$wgAPIModules['donate'] = 'DonationApi';
$wgAutoloadClasses['DonationApi'] = $donationinterface_dir . 'gateway_common/donation.api.php';

//Payflowpro API
if ( $optionalParts['PayflowPro'] === true ){
	$wgAPIModules['pfp'] = 'ApiPayflowProGateway';
	$wgAutoloadClasses['ApiPayflowProGateway'] = $donationinterface_dir . 'payflowpro_gateway/api_payflowpro_gateway.php';
}


/**
 * ADDITIONAL MAGICAL GLOBALS
 */

// Resource modules
$wgResourceTemplate = array(
	'localBasePath' => $donationinterface_dir . 'modules',
	'remoteExtPath' => 'DonationInterface/modules',
);
$wgResourceModules['iframe.liberator'] = array(
	'scripts' => 'iframe.liberator.js',
	'position' => 'top'
	) + $wgResourceTemplate;
$wgResourceModules['donationInterface.skinOverride'] = array(
	'styles' => 'skinOverride.css',
	'position' => 'top'
	) + $wgResourceTemplate;

// load any rapidhtml related resources
require_once( $donationinterface_dir . 'gateway_forms/rapidhtml/RapidHtmlResources.php' );


$wgResourceTemplate = array(
	'localBasePath' => $donationinterface_dir . 'gateway_forms',
	'remoteExtPath' => 'DonationInterface/gateway_forms',
);

$wgResourceModules[ 'ext.donationInterface.errorMessages' ] = array(
	'messages' => array(
		'donate_interface-noscript-msg',
		'donate_interface-noscript-redirect-msg',
		'donate_interface-error-msg-general',
		'donate_interface-error-msg-js',
		'donate_interface-error-msg-validation',
		'donate_interface-error-msg-invalid-amount',
		'donate_interface-error-msg-email',
		'donate_interface-error-msg-card-num',
		'donate_interface-error-msg-amex',
		'donate_interface-error-msg-mc',
		'donate_interface-error-msg-visa',
		'donate_interface-error-msg-discover',
		'donate_interface-error-msg-amount',
		'donate_interface-error-msg-emailAdd',
		'donate_interface-error-msg-fname',
		'donate_interface-error-msg-lname',
		'donate_interface-error-msg-street',
		'donate_interface-error-msg-city',
		'donate_interface-error-msg-state',
		'donate_interface-error-msg-zip',
		'donate_interface-error-msg-postal',
		'donate_interface-error-msg-country',
		'donate_interface-error-msg-card_type',
		'donate_interface-error-msg-card_num',
		'donate_interface-error-msg-expiration',
		'donate_interface-error-msg-cvv',
		'donate_interface-error-msg-captcha',
		'donate_interface-error-msg-captcha-please',
		'donate_interface-error-msg-cookies',
		'donate_interface-smallamount-error',
		'donate_interface-donor-fname',
		'donate_interface-donor-lname',
		'donate_interface-donor-street',
		'donate_interface-donor-city',
		'donate_interface-donor-state',
		'donate_interface-donor-zip',
		'donate_interface-donor-postal',
		'donate_interface-donor-country',
		'donate_interface-donor-emailAdd',
		'donate_interface-state-province',
		'donate_interface-cvv-explain',
	)
);

// minimum amounts for all currencies
$wgResourceModules[ 'di.form.core.minimums' ] = array(
	'scripts' => 'validate.currencyMinimums.js',
	'localBasePath' => $donationinterface_dir . 'modules',
	'remoteExtPath' => 'DonationInterface/modules'
);

// form validation resource
$wgResourceModules[ 'di.form.core.validate' ] = array(
	'scripts' => 'validate_input.js',
	'dependencies' => array( 'pfp.form.core.pfp_css', 'di.form.core.minimums', 'ext.donationInterface.errorMessages' ),
	'localBasePath' => $donationinterface_dir . 'modules',
	'remoteExtPath' => 'DonationInterface/modules'
);

// form placeholders
//TODO: Move this somewhere gateway-agnostic.
$wgResourceModules[ 'pfp.form.core.placeholders' ] = array(
	'scripts' => 'form_placeholders.js',
	'dependencies' => 'di.form.core.validate',
	'messages' => array(
		'donate_interface-donor-fname',
		'donate_interface-donor-lname',
		'donate_interface-donor-street',
		'donate_interface-donor-city',
		'donate_interface-donor-state',
		'donate_interface-donor-postal',
		'donate_interface-donor-country',
		'donate_interface-donor-address',
	),
	'localBasePath' => $donationinterface_dir . 'payflowpro_gateway',
	'remoteExtPath' => 'DonationInterface/payflowpro_gateway',
);

// general PFP css
$wgResourceModules[ 'pfp.form.core.pfp_css' ] = array(
	'styles' => 'css/gateway.css',
	'scripts' => array(),
	'dependencies' => array(),
) + $wgResourceTemplate;

// TowStepTwoColumnLetter3
$wgResourceModules[ 'pfp.form.TwoStepTwoColumnLetter3' ] = array(
	'styles' => 'css/TwoStepTwoColumnLetter3.css',
	'dependencies' => 'di.form.core.validate',
) + $wgResourceTemplate;

// API JS
//TODO: Either move this somewhere gateway-agnostic, or move it to the pfp installer section.
$wgResourceModules[ 'pfp.form.core.api' ] = array(
	'scripts' => 'pfp_api_controller.js',
	'localBasePath' => $donationinterface_dir . 'payflowpro_gateway',
	'remoteExtPath' => 'DonationInterface/payflowpro_gateway',
);

// Logo link override
//TODO: Move this somewhere gateway-agnostic.
$wgResourceModules[ 'pfp.core.logolink_override' ] = array(
	'scripts' => 'logolink_override.js',
	'localBasePath' => $donationinterface_dir . 'payflowpro_gateway',
	'remoteExtPath' => 'DonationInterface/payflowpro_gateway',

);

// Load the interface messages that are shared across multiple gateways
$wgExtensionMessagesFiles['DonateInterface'] = $donationinterface_dir . 'gateway_common/interface.i18n.php';
$wgExtensionMessagesFiles['GatewayCountries'] = $donationinterface_dir . 'gateway_common/countries.i18n.php';
$wgExtensionMessagesFiles['GatewayUSStates'] = $donationinterface_dir . 'gateway_common/us-states.i18n.php';
$wgExtensionMessagesFiles['GatewayCAProvinces'] = $donationinterface_dir . 'gateway_common/canada-provinces.i18n.php';

//GlobalCollect gateway magical globals
//TODO: all the bits where we make the i18n make sense for multiple gateways. This is clearly less than ideal.
if ( $optionalParts['GlobalCollect'] === true ){
	$wgExtensionMessagesFiles['GlobalCollectGateway'] = $donationinterface_dir . 'globalcollect_gateway/globalcollect_gateway.i18n.php';
	$wgExtensionMessagesFiles['GlobalCollectGatewayAlias'] = $donationinterface_dir . 'globalcollect_gateway/globalcollect_gateway.alias.php';
}

//PayflowPro gateway magical globals
if ( $optionalParts['PayflowPro'] === true ){
	$wgExtensionMessagesFiles['PayflowProGateway'] = $donationinterface_dir . 'payflowpro_gateway/payflowpro_gateway.i18n.php';
	$wgExtensionMessagesFiles['PayflowProGatewayAlias'] = $donationinterface_dir . 'payflowpro_gateway/payflowpro_gateway.alias.php';
	$wgAjaxExportList[] = "fnPayflowProofofWork";
}

//Minfraud magical globals
if ( $optionalParts['Minfraud'] === true ){ //We do not want this in filter mode.
	$wgExtensionFunctions[] = 'efMinFraudSetup';
}

//Minfraud as Filter globals
if ( $optionalParts['Minfraud_as_filter'] === true ){
	$wgExtensionFunctions[] = 'efCustomFiltersMinFraudSetup';
}


/**
 * FUNCTIONS
 */

//---Stomp functions---
if ($optionalParts['Stomp'] === true){
	require_once( $donationinterface_dir . 'activemq_stomp/activemq_stomp.php'  );
}

//---Minfraud functions---
if ($optionalParts['Minfraud'] === true){
	require_once( $donationinterface_dir . 'extras/minfraud/minfraud.php'  );
}

//---Minfraud as filter functions---
if ($optionalParts['Minfraud_as_filter'] === true){
	require_once( $donationinterface_dir . 'extras/custom_filters/filters/minfraud/minfraud.php'  );
}

function efDonationInterfaceUnitTests( &$files ) {
	$files[] = dirname( __FILE__ ) . '/tests/AllTests.php';
	return true;
}

unset( $optionalParts );
