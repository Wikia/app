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
	'userlogin-get-account' => 'Don\'t have an account? [[Special:UserSignup|Sign up]]',

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
	'userlogin-error-blocked-mailpassword' => "You can't request a new password because this IP address is blocked by Wikia.",
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
	'userlogin-password-email-body-HTML' => '',

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

	'userlogin-loginreqlink' => 'login',
	'userlogin-changepassword-needlogin' => 'You need to $1 to change your password.',
	
	//WikiaMobile skin
	'wikiamobile-sendpassword-label' => 'Send new password',
	'wikiamobile-facebook-connect-fail' => 'Sorry, your Facebook account is not currently linked with a Wikia account.'
);

$messages['qqq'] = array(
	// login
	'userlogin-login-heading' => 'Login page heading',
	'userlogin-forgot-password' => 'Link that asks if you forgot your password.',
	'userlogin-remembermypassword' => 'Label for staying logged in checkbox',
	'userlogin-error-noname' => 'Error message upon login attempt stating the name field is blank.',
	'userlogin-error-sessionfailure' => 'Error message upon login attempt stating session has timed out.',
	'userlogin-error-nosuchuser' => "Error message upon login attempt stating there is no such user.  Reminds of caps lock.",
	'userlogin-error-wrongpassword' => 'Error message upon login attempt stating the password is incorrect.  Reminds of caps lock.',
	'userlogin-error-wrongpasswordempty' => 'Error message upon login attempt stating password field is blank.',
	'userlogin-error-resetpass_announce' => 'Error message upon login attempt stating that this password is a temp password, and the user needs to set a new password.',
	'userlogin-error-login-throttled' => "Error message upon login attempt stating user has failed too many logins for the time period.",
	'userlogin-error-login-userblocked' => "Error message upon login attempt stating user has been blocked.",
	'userlogin-error-edit-account-closed-flag' => 'Error message upon login attempt stating the account has been closed.',
	'userlogin-error-cantcreateaccount-text' => 'Error message upon login attempt stating that the user\'s IP address has been throttled because of login failures.',
	'userlogin-error-userexists' => 'Error message upon signup attempt stating user name already exists.',
	'userlogin-error-invalidemailaddress' => 'Error message upon signup attempt stating email address is invalid.',
	'userlogin-get-account' => 'Marketing blurb asking to sign up with wikitext internal link to usersignup page.  Please append userlang as appropriate.',

	// signup
	'userlogin-error-invalid-username' => 'Error message upon signup attempt stating username is badly formatted, or invalid',
	'userlogin-error-userlogin-unable-info' => 'Error message upon signup attempt stating account cannot be create currently.',
	'userlogin-error-user-not-allowed' => 'Error message upon signup attempt stating username is unacceptable.',
	'userlogin-error-captcha-createaccount-fail' => 'Error message upon signup attempt stating CAPTCHA has failed or not entered correctly.',
	'userlogin-error-userlogin-bad-birthday' => 'Error message upon signup attempt stating all fields for birthday is required: Year, Month, Day.',
	'userlogin-error-externaldberror' => 'Error message upon signup attempt stating there was a technical issue at wikia.',
	'userlogin-error-noemailtitle' => 'Error message upon signup attempt stating user should enter a valid email address.',
	'userlogin-error-acct_creation_throttle_hit' => 'Error message upon signup attempt stating that too many accounts have been created from the same IP.',

	// mail password
	'userlogin-error-resetpass_forbidden' => 'Error message stating password cannot be changed.',
	'userlogin-error-blocked-mailpassword' => "Error message stating password cannot be changed because IP has been restricted.",
	'userlogin-error-throttled-mailpassword' => "Error message stating email has already been sent $1 hours ago and asks user to check email.  $1 is numerical hour.",
	'userlogin-error-mail-error' => 'Error message stating there was an error sending the email.  Link to Contact us page in wikitext.',
	'userlogin-password-email-sent' => "Validation message stating that email has been to the user.  $1 contains the email address, such as john@wikia-inc.com",
	'userlogin-error-unconfirmed-user' => 'Error message stating that user needs to be confirmed first.',

	// change password page
	'userlogin-password-page-title' => 'Heading for change password page.',
	'userlogin-oldpassword' => 'Label for old password field',
	'userlogin-newpassword' => 'Label for new password field',
	'userlogin-retypenew' => 'Label for retype password field',
	

	// password email
	'userlogin-password-email-subject' => 'Subject line for Forgot password email',
	'userlogin-password-email-greeting' => 'Email body heading.  $USERNAME is a special wikia magic word, so re-use it without changing.  This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-content' => 'Email body.  $NEWPASSWORD is wikia magic word.  This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-signature' => 'Wikia Email signature at the bottom of the email.  This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-body' => 'This is a text-only version email that combines the contents userlogin-password-email-greeting, userlogin-password-email-content, and userlogin-password-email-signature.  This does NOT contain HTML.  $2 is username in greeting, $3 is the temporary password value.  Content-wise, it is exactly the same as templated html version, but this is a complete stand-alone.',
	'userlogin-password-email-body-HTML' => 'This is a standalone HTML version of the email.  This will not be placed onto a pre-formatted template that userlogin-password-email-greeting, userlogin-password-email-content, and userlogin-password-email-signature is placed onto.',

	// general email
	'userlogin-email-footer-line1' => 'Footer line 1 in the standard Wikia email template.',
	'userlogin-email-footer-line2' => 'Footer line 2 in the standard Wikia email template.',
	'userlogin-email-footer-line3' => 'Footer line 3 in the standard Wikia email template.  The links are space (&nbsp) separated pointing to social networks.  Leave this blank if social network is unknown.',

	// 3rd party login providers
	'userlogin-provider-or' => 'Word shown between login form and FB connect button',
	'userlogin-provider-tooltip-facebook' => 'Tooltip when hovering over facebook connect button in login page or context.',
	'userlogin-provider-tooltip-facebook-signup' => 'Tooltip when hovering over facebook connect button in signup page or context.',
	'userlogin-facebook-show-preferences' => 'Action anchor text to show facebook feed preference section of the UI when near facebook signup completion.',
	'userlogin-facebook-hide-preferences' => 'Action anchor text to hide facebook feed preference section of the UI when near facebook signup completion.',
	'userlogin-loginreqlink' => 'login link',
	'userlogin-changepassword-needlogin' => '$1 is an action link using the message userlogin-loginreqlink.',
	'wikiamobile-facebook-connect-fail' => 'Shown when a user tries to log in via FBConnect but there\'s no matching account in our DB, please keep the message as short as possible as the space at disposal is really limited',
	'wikiamobile-sendpassword-label' => 'Label for the button used to request a new password for recovery'
);
