<?php
/**
* Internationalisation file for the UserLogin extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	// login
	'userlogin-login-heading' => 'Log in',
	'userlogin-forgot-password' => 'Forgot your password?',
	'userlogin-remembermypassword' => 'Stay logged in',
	'userlogin-error-noname' => 'Oops, please fill in the username field.',
	'userlogin-error-sessionfailure' => 'Your log in session has timed out. Please log in again.',
	'userlogin-error-nosuchuser' => "Hm, we don't recognize this name. Don't forget usernames are case sensitive.",
	'userlogin-error-wrongpassword' => 'Oops, wrong password. Make sure caps lock is off and try again.',
	'userlogin-error-wrongpasswordempty' => 'Oops, please fill in the password field.',
	'userlogin-error-resetpass_announce' => 'Looks like you used a temporary password. Pick a new password here to continue logging in.',
	'userlogin-error-login-throttled' => "You've tried to log in with the wrong password too many times. Wait a while before trying again.",
	'userlogin-error-login-userblocked' => "Your username has been blocked and can't be used to log in.",
	'userlogin-error-edit-account-closed-flag' => 'Your account has been disabled by Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Your IP address is not allowed to create new accounts.',
	'userlogin-error-userexists' => 'Someone already has this username. Try a different one!',
	'userlogin-error-invalidemailaddress' => 'Please enter a valid email address.',
	'userlogin-get-account' => 'Don\'t have an account?  [[Special:UserSignup|Sign up]]',

	// signup
	'userlogin-error-invalid-username' => 'Invalid username',
	'userlogin-error-userlogin-unable-info' => 'Sorry, we\'re not able to register your account at this time.',
	'userlogin-error-user-not-allowed' => 'This username is not allowed.',
	'userlogin-error-captcha-createaccount-fail' => 'The word you entered didn\'t match the word in the box, try again!',
	'userlogin-error-userlogin-bad-birthday' => 'Oops, please fill out month, day, and year.',
	'userlogin-error-externaldberror' => 'Sorry! Our site is currently having an issue, please try again later.',
	'userlogin-error-noemailtitle' => 'Please enter a valid email address.',
	'userlogin-error-acct_creation_throttle_hit' => 'Sorry, this IP address has created too many accounts today. Please try again later.',

	// mail password
	'userlogin-error-resetpass_forbidden' => 'Passwords cannot be changed',
	'userlogin-error-blocked-mailpassword' => "You can't request a new pssword because this IP address is blocked by Wikia.",
	'userlogin-error-throttled-mailpassword' => "We've already sent a password reminder to this account in the last {{PLURAL:$1|hour|$1 hours}}. Please check your email.",
	'userlogin-error-mail-error' => 'Oops, there was a problem sending your email. Please [[Special:Contact/general|contact us]].',
	'userlogin-password-email-sent' => "We've sent a new password to the email address for $1.",
	'userlogin-error-unconfirmed-user' => 'Sorry, you have not confirmed your email. Please confirm your email first.',

	// change password page
	'userlogin-password-page-title' => 'Change your password',
	'userlogin-oldpassword' => 'Old password',
	'userlogin-newpassword' => 'New password',
	'userlogin-retypenew' => 'Retype new password',
	

	// password email
	'userlogin-password-email-subject' => 'Forgotten password request',
	'userlogin-password-email-greeting' => 'Hi $USERNAME,',
	'userlogin-password-email-content' => 'Please use this temporary password to log in to Wikia: "$NEWPASSWORD"
<br/><br/>
If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.
<br/><br/>
Questions or concerns? Feel free to contact us.',
	'userlogin-password-email-signature' => 'Wikia Community Support',
	'userlogin-password-email-body' => 'Hi $2,

Please use this temporary password to log in to Wikia: "$3"

If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.

Questions or concerns? Feel free to contact us.

Wikia Community Support


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-password-email-body-HTML' => 'Hi $2,

Please use this temporary password to log in to Wikia: "$3"

If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.

Questions or concerns? Feel free to contact us.

Wikia Community Support


___________________________________________

To check out the latest happenings on Wikia, visit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>
Want to control which emails you receive? Go to your <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferences</a>',

	// general email
	'userlogin-email-footer-line1' => 'To check out the latest happenings on Wikia, visit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Want to control which emails you receive? Go to your <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferences</a>',
	'userlogin-email-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',

	// 3rd party login providers
	'userlogin-provider-or' => 'Or',
	'userlogin-provider-tooltip-facebook' => 'Click the button to log in with Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Click the button to sign up with Facebook',

	'userlogin-facebook-show-preferences' => 'Show Facebook feed preferences',
	'userlogin-facebook-hide-preferences' => 'Hide Facebook feed preferences',

	'userlogin-changepassword-needlogin' => 'You need to $1 to change your password.',
);

$messages['qqq'] = array(
	'userlogin-provider-or' => 'Word shown between login form and FB connect button',
);
