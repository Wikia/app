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
	'closemyaccount-intro-text' => "We are sorry {{GENDER:$2|you}} want to disable your account. Wikia has many wikis on all sorts of subjects and we'd love for you to stick around and find the one that's right for you. If you are having a local problem with your wiki, please don't hesitate to contact your [[Special:ListUsers/sysop|local admins]] for help and advice.

If you have decided you definitely want to disable your account please be aware:
* Wikia does not have the ability to fully remove accounts, but we can disable them. This will ensure the account is locked and can't be used.
* This process is NOT reversible after $1 {{PLURAL:$1|day has|days have}} passed, and you will have to create a new account if you wish to rejoin Wikia.
* This process will not remove your contributions from a given Wikia community, as these contributions belong to the community as a whole.

If you need any more information on what an account disable actually does, you can visit our [[Help:Close_my_account|help page on disabling your account]]. If you are sure you want to close your account, please click the button below.

Please note you will have $1 {{PLURAL:$1|day|days}} after making this request to reactivate your account by logging in and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.",
	'closemyaccount-unconfirmed-email' => 'Warning: You do not have a confirmed email address associated with this account. You will not be able to reactivate your account within the waiting period without one. Please consider setting an email address in [[Special:Preferences|your preferences]] before proceeding.',
	'closemyaccount-logged-in-as' => 'You are logged in as {{GENDER:$1|$1}}. [[Special:UserLogout|Not you?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Your}} email is set to $1. [[Special:Preferences|Do you wish to change it?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|I}} have read the [[Help:Close_my_account|help page on closing your account]] and confirm that I want to disable my Wikia account.',
	'closemyaccount-button-text' => 'Close my account',
	'closemyaccount-reactivate-button-text' => 'Reactivate my account',
	'closemyaccount-reactivate-page-title' => 'Reactivate my account',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|You}} have previously requested that we close your account. You still have $1 {{PLURAL:$1|day|days}} left until your account is closed. If you still wish to close your account, simply go back to browsing Wikia. However, if you would like to reactivate your account, please click the button below and follow the instructions in the email.

Would you like to reactivate your account?',
	'closemyaccount-reactivate-requested' => 'An email has been sent to the address you had set for your account. Please click the link in the email to reactivate your account.',
	'closemyaccount-reactivate-error-id' => 'Please login to your account first to request reactivation.',
	'closemyaccount-reactivate-error-logged-in' => 'Please login to an account that is scheduled to be closed first to request reactivation.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|You}} have previously requested that we close your account. If you would like to reactivate your account, please go to the [[Special:CloseMyAccount/reactivate|account reactivation page]] and follow the instructions you will see.',
	'closemyaccount-reactivate-error-email' => 'No email was set for this account prior to requesting closure so it cannot be reactivated. Please [[Special:Contact|contact Wikia]] if you have any questions.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Account is not scheduled for closure.',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|You}} appear to have used a confirmation code that has expired. Please check your email for a newer code you may have requested, or try requesting a new code by [[Special:UserLogin|logging in]] to the account you want to reactivate and following the instructions.',
	'closemyaccount-reactivate-error-empty-code' => 'A confirmation code needed to reactivate your account has not been provided. If you have requested your account be reactivated, please click the link in the email sent to you. Otherwise, [[Special:UserLogin|login]] to the account you want to reactivate in order to request a confirmation code.',
	'closemyaccount-reactivate-error-disabled' => 'This account has already been disabled. Please [[Special:Contact|contact Wikia]] if you have any questions.',
	'closemyaccount-reactivate-error-failed' => 'An error occurred while attempting to reactivate this account. Please try again or [[Special:Contact|contact Wikia]] if the issue persists.',
	'closemyaccount-scheduled' => 'Your account has been successfully scheduled to be closed.

Please note you will have $1 {{PLURAL:$1|day|days}} from now to reactivate your account by [[Special:UserLogin|logging in]] and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.',
	'closemyaccount-scheduled-failed' => 'An error occurred while attempting to schedule this account to be closed. Please [[Special:CloseMyAccount|try again]] or [[Special:Contact|contact Wikia]] if the issue persists.',

	/** Email **/
	'closemyaccount-reactivation-email_subject' => 'Wikia account reactivation',
	'closemyaccount-reactivation-email_body' => 'Hi $2,

You\'re one step away from reactivating your account on Wikia! Click the link below to confirm you were the one who requested this and get started.

$3

The Wikia Team


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com',
	'closemyaccount-reactivation-email_body-HTML' => '', # do not translate or duplicate this message to other languages
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
	'closemyaccount-intro-text' => 'Text displayed at the top of the Close My Account form.
* $1 is the number of days before the account is permanently closed
* $2 is the username',
	'closemyaccount-unconfirmed-email' => 'Warning message displayed when a user attempts to close their account when they do not have a confirmed email set on their account.',
	'closemyaccount-logged-in-as' => "Message on close account form informing the user which account they are logged in as to make sure they aren't closing the wrong account.
* $1 is the username",
	'closemyaccount-current-email' => 'Message on close account form informing the user which email is set for the account they are logged in as to make sure they have access to it.
* $1 is the email address
* $2 is the username',
	'closemyaccount-confirm' => 'Label for a checkbox above submit button on the account closure form.
* $1 is the username',
	'closemyaccount-button-text' => 'Text of the submit button to close your account',
	'closemyaccount-reactivate-button-text' => 'Text of the submit button to reactivate your account',
	'closemyaccount-reactivate-page-title' => 'Special page name of the reactivate account form.',
	'closemyaccount-reactivate-intro' => 'Text displayed at the top of the Reactivate My Account form.
* $1 is the number of days the user has left to reactivate their account
* $2 is the username',
	'closemyaccount-reactivate-requested' => 'Confirmation text displayed when a user has successfully requested their account be reactivated.',
	'closemyaccount-reactivate-error-id' => 'Error message displayed when trying to access the reactivate form without a valid ID.',
	'closemyaccount-reactivate-error-logged-in' => 'Error message displayed when trying to access the reactivate form while logged in to an active account.',
	'closemyaccount-reactivate-error-fbconnect' => 'Error message displayed when users try to login to an account that has requested closure via Facebook Connect.
* $1 is the username',
	'closemyaccount-reactivate-error-email' => 'Error message displayed when the user attempts to reactivate an account that does not have a confirmed email address.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Error message displayed when the user attempts to reactivate an account that is not scheduled for closure.',
	'closemyaccount-reactivate-error-invalid-code' => 'Error message displayed when a user attempted to reactivate their account with an invalid or expired code.
* $1 is the username provided by the user',
	'closemyaccount-reactivate-error-empty-code' => 'Error message displayed when a user tries to reactivate their account without a confirmation code.',
	'closemyaccount-reactivate-error-disabled' => 'Error message displayed when the user attempts to reactivate an account that has already been closed.',
	'closemyaccount-reactivate-error-failed' => 'Error message displayed when reactivation of an account has failed.',
	'closemyaccount-scheduled' => 'Success message displayed when the user has successfully requested their account is closed. $1 is the number of days the user has left to reactivate their account.',
	'closemyaccount-scheduled-failed' => 'Error message displayed when a request to close an account has failed.',
	'closemyaccount-reactivation-email_subject' => 'Reactivation email subject.',
	'closemyaccount-reactivation-email_body' => 'Plain text reactivation email body. $2 is the username, $3 is the confirmation url.',
	'closemyaccount-reactivation-email_body-HTML' => '{{notranslate}}',
	'closemyaccount-reactivation-email-greeting' => 'Greeting in the HTML version of the reactivation email. $USERNAME is replaced with the user name of the account that was requested to be reactivated.',
	'closemyaccount-reactivation-email-content' => 'The content of the HTML version of the reactivation email. $CONFIRMURL is replaced with the URL to confirm they are the one who requested that the account is reactivated.',
	'closemyaccount-reactivation-email-signature' => 'Signature at the bottom of the HTML version of the reactivation email.',
);
