<?php

/**
 * Payflow Pro account information
 * Payflow individual account information must be defined in the LocalSettings.php file
 */
function payflowUser() {
	// User account information from LocalSettings.php
	global $wgPayflowProPartnerID,
			$wgPayflowProVendorID,
			$wgPayflowProUserID,
			$wgPayflowProPassword,
			$wgPayflowProURL,
			$wgPayflowProTestingURL;

	$payflow_data = array(
		'partner' => $wgPayflowProPartnerID, // PayPal or original authorized reseller
		'vendor' => $wgPayflowProVendorID, // paypal merchant login ID
		'user' => $wgPayflowProUserID, // if one or more users are set up, authorized user ID, else same as VENDOR
		'password' => $wgPayflowProPassword, // merchant login password
		'paypalurl' => $wgPayflowProURL,
		'testingurl' => $wgPayflowProTestingURL, // Payflow testing URL
		'trxtype' => 'S', // transaction type - all donations are a sale
		'tender' => 'C', // credit card - all transactions in this case are credit cards
		'verbosity' => 'MEDIUM', // level of detail in Payflow response
		'user_ip' => $_SERVER['REMOTE_ADDR'], // current user's IP address
		'order_id' => date( 'ymdH' ) . rand( 1000, 9999 ), // Generate random order number
	);

	return $payflow_data;
}
