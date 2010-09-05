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
	'unsubscribe-desc' => 'Provides a [[Special:Unsubscribe|single e-mail unsubscribe]] point',
	'unsubscribe' => 'Unsubscribe',

	'unsubscribe-badaccess' => 'Sorry, this page cannot be used in this manor.
Please follow the link from your e-mail.',
	'unsubscribe-badtoken' => 'Sorry, there was a problem with the security token.
Please try again.',
	'unsubscribe-bademail' => 'Sorry, there was a problem with the e-mail address.
Please try again.',

	# user info list
	'unsubscribe-already' => 'Already unsubscribed',

	# confirm form
	'unsubscribe-confirm-legend' => 'Confirm unsubscribe',
	'unsubscribe-confirm-text' => 'Unsubscribe all accounts using the e-mail address <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Yes, I\'m sure',

	# working page
	'unsubscribe-working' => 'Unsubscribing {{PLURAL:$1|account|$1 accounts}} for $2',
	'unsubscribe-working-problem' => '* Problem loading user info for: $1',
	'unsubscribe-working-done' => 'The e-mail address has been unsubscribed.',
);

$messages['qqq'] = array(
	'unsubscribe-desc' => '{{desc}}',
	'unsubscribe' => 'Special page description on [[Special:SpecialPages]] and special page title.',
	'unsubscribe-confirm-text' => 'Parameters:
* $1 is an e-mail address.',
	'unsubscribe-working' => 'Parameters:
* $1 is the number of users for which the given e-mail address is used.
* $1 is an e-mail address.',
	'unsubscribe-working-problem' => 'This is an error message. The "*" character is wiki markup for a list. Parameters:
* $1 is a username.',
);
