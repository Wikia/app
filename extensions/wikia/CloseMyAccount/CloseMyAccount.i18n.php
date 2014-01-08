<?php
/**
 * Internationalisation for CloseMyAccount extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Daniel Grunwell (grunny)
 */
$messages['en'] = array(
	'closemyaccount' => 'Close My Account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => "We are sorry you want to disable your account. Wikia has many wikis on all sorts of subjects and we'd love for you to stick around and find the one that's right for you. If you are having a local problem with your wiki, please don't hesitate to contact your [[Special:ListUsers/sysop|local admins]] for help and advice.

If you have decided you definitely want to disable your account please be aware that Wikia does not have the ability to fully remove accounts, but we can disable them. This will ensure the account is locked and can't be used. This process is NOT reversible, and you will have to create a new account if you wish to rejoin Wikia. However, this process will not remove your contributions from a given wiki as these contributions belong to the community as a whole.

If you need any more information on what an account disable actually does, you can visit our [[Help:Close_my_account|help page on disabling your account]]. If you are sure you want to close your account, please click the button below.

Please note you will have $1 {{PLURAL:$1|day|days}} after making this request to reactivate your account by logging in and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.",
	'closemyaccount-unconfirmed-email' => 'Warning: You do not have a confirmed email address associated with this account. You will not be able to reactivate your account within the waiting period without one. Please consider setting an email address in [[Special:Preferences|your preferences]] before proceeding.',
	'closemyaccount-button-text' => 'Close my account',
	'closemyaccount-reactivate-button-text' => 'Reactivate my account',
	'closemyaccount-reactivate-page-title' => 'Reactivate my account',
	'closemyaccount-reactivate-intro' => 'You have previously requested that we close your account. You still have $1 {{PLURAL:$1|day|days}} left until your account is closed. If you still wish to close your account, simply go back to browsing Wikia. However, if you would like to reactivate your account, please click the button below and follow the instructions in the email.

Would you like to reactivate your account?',
	'closemyaccount-reactivate-requested' => 'An email has been sent to the address you had set for your account. Please click the link in the email to reactivate your account.',
	'closemyaccount-reactivate-error-id' => 'Please login to your account first to request reactivation.',
	'closemyaccount-reactivate-error-email' => 'No email was set for this account prior to requesting closure so it cannot be reactivated. Please [[Special:Contact|contact Wikia]] if you have any questions.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Account is not scheduled for closure.',
	'closemyaccount-reactivate-error-disabled' => 'This account has already been disabled. Please [[Special:Contact|contact Wikia]] if you have any questions.',
	'closemyaccount-reactivate-error-failed' => 'An error occurred while attempting to reactivate this account. Please try again or [[Special:Contact|contact Wikia]] if the issue persists.',
	'closemyaccount-scheduled' => 'Your account has been successfully scheduled to be closed.

Please note you will have $1 {{PLURAL:$1|day|days}} from now to reactivate your account by logging in and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.',
	'closemyaccount-scheduled-failed' => 'An error occurred while attempting to schedule this account to be closed. Please [[Special:CloseMyAccount|try again]] or [[Special:Contact|contact Wikia]] if the issue persists.',

	/** Email **/
	'closemyaccount-reactivation-email_subject' => 'Account Reactivation',
	'closemyaccount-reactivation-email_body' => 'Hi $2,

You\'re one step away from reactivating your account on Wikia! Click the link below to confirm you were the one who requested this and get started.

$3

The Wikia Team


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com',
	'closemyaccount-reactivation-email-greeting' => 'Hi $USERNAME,',
	'closemyaccount-reactivation-email-content' => 'You\'re one step away from reactivating your account on Wikia! Click the link below to confirm you were the one who requested this and get started.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'closemyaccount-reactivation-email-signature' => 'The Wikia Team',
);

/**
 * @author Daniel Grunwell (grunny)
 */
$messages['qqq'] = array(
	'closemyaccount' => 'Special page name',
	'closemyaccount-desc' => '{{desc}}',
	'closemyaccount-intro-text' => 'Text displayed at the top of the Close My Account form.',
	'closemyaccount-unconfirmed-email' => 'Warning message displayed when a user attempts to close their account when they do not have a confirmed email set on their account.',
	'closemyaccount-button-text' => 'Text of the submit button to close your account',
	'closemyaccount-reactivate-button-text' => 'Text of the submit button to reactivate your account',
	'closemyaccount-reactivate-page-title' => 'Special page name of the reactivate account form.',
	'closemyaccount-reactivate-intro' => 'Text displayed at the top of the Reactivate My Account form. $1 is the number of days the user has left to reactivate their account.',
	'closemyaccount-reactivate-requested' => 'Confirmation text displayed when a user has successfully requested their account be reactivated.',
	'closemyaccount-reactivate-error-id' => 'Error message displayed when trying to access the reactivate form without a valid ID.',
	'closemyaccount-reactivate-error-email' => 'Error message displayed when the user attempts to reactivate an account that does not have a confirmed email address.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Error message displayed when the user attempts to reactivate an account that is not scheduled for closure.',
	'closemyaccount-reactivate-error-disabled' => 'Error message displayed when the user attempts to reactivate an account that has already been closed.',
	'closemyaccount-reactivate-error-failed' => 'Error message displayed when reactivation of an account has failed.',
	'closemyaccount-scheduled' => 'Success message displayed when the user has successfully requested their account is closed. $1 is the number of days the user has left to reactivate their account.',
	'closemyaccount-scheduled-failed' => 'Error message displayed when a request to close an account has failed.',
	'closemyaccount-reactivation-email_subject' => 'Reactivation email subject.',
	'closemyaccount-reactivation-email_body' => 'Plain text reactivation email body. $2 is the username, $3 is the confirmation url.',
	'closemyaccount-reactivation-email-greeting' => 'Greeting in the HTML version of the reactivation email. $USERNAME is replaced with the user name of the account that was requested to be reactivated.',
	'closemyaccount-reactivation-email-content' => 'The content of the HTML version of the reactivation email. $CONFIRMURL is replaced with the URL to confirm they are the one who requested that the account is reactivated.',
	'closemyaccount-reactivation-email-signature' => 'Signature at the bottom of the HTML version of the reactivation email.',
);
