<?php
/**
 * Internationalisation file for Unsubscribe extension.
 *
 * @file
 * @ingroup Extensions
 */

#messages = array();

/** English
 * @author 
 */
$messages['en'] = array(
	'unsubscribe' => 'Unsubscribe',

	'unsubscribe-badaccess' => 'Sorry, this page cannot be used directly. Please follow the link from your email.',
	'unsubscribe-badtoken' => 'Sorry, there was a problem with the security token.',
	'unsubscribe-bademail' => 'Sorry, there was a problem with the email.',
	'unsubscribe-badtime' => 'Sorry, the link has expired. Please use a link that is less then 7 days old.',

	#user info list
	'unsubscribe-nousers' => 'No users found with that email.',
	#'unsubscribe-already' => 'Already unsubscribed', 
	'unsubscribe-noconfusers' => 'No confirmed users found with that email.',

	#confirm form
	'unsubscribe-confirm-legend' => 'Confirm',
	'unsubscribe-confirm-text' => 'Unsubscribe all accounts with <code>$1</code>?',
	'unsubscribe-confirm-button' => "Yes, I'm sure",
	
	#working page
	'unsubscribe-working' => 'Unsubscribing $1 {{PLURAL:$1|account|accounts}} for $2',
	'unsubscribe-working-problem' => 'problem loading user info for: $1',
	'unsubscribe-working-done' => 'Complete.',
	
);
