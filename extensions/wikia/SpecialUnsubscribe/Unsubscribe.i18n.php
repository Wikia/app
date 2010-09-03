<?php
/**
 * Internationalisation file for Unsubscribe extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author 
 */
$messages['en'] = array(
	'unsubscribe' => 'Unsubscribe',

	'unsubscribe-badaccess' => 'Sorry, this page cannot be used in this manor. Please follow the link from your email.',
	'unsubscribe-badtoken' => 'Sorry, there was a problem with the security token.',
	'unsubscribe-bademail' => 'Sorry, there was a problem with the email.',

	#user info list
	'unsubscribe-already' => 'Already unsubscribed', 

	#confirm form
	'unsubscribe-confirm-legend' => 'Confirm unsubscribe',
	'unsubscribe-confirm-text' => 'Unsubscribe all accounts tied to <tt>$1</tt>?',
	'unsubscribe-confirm-button' => 'Yes, I\'m sure',
	
	#working page
	'unsubscribe-working' => 'Unsubscribing {{PLURAL:$1|account|accounts}} for $2',
	'unsubscribe-working-problem' => 'problem loading user info for: $1',
	'unsubscribe-working-done' => 'Complete',
	
);
