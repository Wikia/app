<?php

/**
 * Custom filter using minFraud
 *
 * Essentially acts as a wrapper for the minFraud extra and runs minFraud
 * queries via custom filter paradigm.  This allows us to capture the
 * riskScore from minfraud and adjust it with our own custom filters and
 * risk score modifications.
 *
 * This inherits minFraud settings form the main minFraud extension.  To make
 * transactions run through minFraud outside of custom filters, set
 * $wgDonationInterfaceEnableMinfraud = TRUE
 *
 * To install:
 *   require_once( "$IP/extensions/DonationInterface/extras/custom_filters/filters/minfraud.php" );
 */
$wgExtensionCredits['gateway_extras_customfilters_minfraud'][] = array(
	'name' => 'minfraud custom filter',
	'author' => 'Arthur Richards',
	'url' => '',
	'description' => 'This extension uses the MaxMind minFraud service as a validator for the gateway via custom filters.'
);

/**
 * Set minFraud to NOT run in standalone mode.
 *
 * If minFraud is set to run in standalone mode, it will not be run
 * through custom filters.  If you do not know what you're doing
 * or otherwise have this set up incorrectly, you may have unexpected
 * results.  If you want minFraud to run OUTSIDE of custom filters,
 * you will want to make sure you know whether minFraud queries are
 * happening before or after custom filters, defined by the order of
 * your require statements in LocalSettings.
 *
 *  To install the DontaionInterface extension, put the following line in LocalSettings.php:
 *	require_once( "\$IP/extensions/DonationInterface/donationinterface.php" );
 *  
 * TODO: Outline required globals to include this bad boy! 
 * 
 */

function efCustomFiltersMinFraudSetup() {
	global $wgDonationInterfaceEnableMinfraud, $wgHooks;
	if ( !$wgDonationInterfaceEnableMinfraud )
		$wgHooks['GatewayCustomFilter'][] = array( "Gateway_Extras_CustomFilters_MinFraud::onFilter" );
}
