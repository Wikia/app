<?php
/**
* Internationalisation file for the UserSignup extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'usersignup-page-title' => 'Join Wikia',
	'usersignup-page-captcha-label' => 'Blurry Word',

	'usersignup-error-username-length' => "Oops, your username can't be more than {{PLURAL:$1|one character|$1 characters}}.",
	'usersignup-error-invalid-user' => 'Invalid user. Please login first.',
	'usersignup-error-invalid-email' => 'Please enter a valid e-mail address.',
	'usersignup-error-symbols-in-username' => 'Oops, your username can only contain letters and numbers.',
	'usersignup-error-empty-email' => 'Oops, please fill in your e-mail address.',
	'usersignup-error-empty-username' => 'Oops, please fill in the username field.',
	'usersignup-error-already-confirmed' => "You've already confirmed this e-mail address.",
	'usersignup-error-throttled-email' => "Oops, you've requested too many confirmation emails be sent to you today. Try again in a little while.",
	'usersignup-error-too-many-changes' => "You've reached the maximum limit for email changes today. Please try again later.",
	'usersignup-error-password-length' => "Oops, your password is too long. Please choose a password that's 50 characters or less.",
	'usersignup-error-confirmed-user' => 'Looks like you\'ve already confirmed your e-mail address for $1!  Check our your [$2 user profile].', // why is this an external link? should be internal, use interwiki if needed

	// Facebook sign-up
	'usersignup-facebook-heading' => 'Finish Signing Up',
	'usersignup-facebook-create-account' => 'Create account',
	'usersignup-facebook-email-tooltip' => 'If you would like to use a different e-mail address you can change it later in your Preferences.',
	'usersignup-facebook-have-an-account-heading' => 'Already have an account?',
	'usersignup-facebook-have-an-account' => 'Connect your existing Wikia username with Facebook instead.',
	'usersignup-facebook-proxy-email' => 'Anonymous Facebook email',

	// user preferences
	'usersignup-user-pref-emailconfirmlink' => 'Request a new confirmation email',
	'usersignup-user-pref-confirmemail_send' => 'Resend my confirmation email',
	'usersignup-user-pref-emailauthenticated' => 'Thanks! Your email was confirmed on $2 at $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Check your email and click the confirmation link to finish changing your email to: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Oh, no! Your email is unconfirmed. Email features will not work until you confirm your e-mail address.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Almost there! We\'ve sent a new confirmation email to $1. Check your email and click on the link to finish confirming your e-mail address.',
	'usersignup-user-pref-noemailprefs' => 'Looks like we do not have an e-mail address for you. Please enter an e-mail address above.',

	// Special:ConfirmEmail
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Oh, no! Your email is unconfirmed. We\'ve sent you an email, click the confirmation link there to confirm.',
	'usersignup-user-pref-confirmemail_noemail' => 'Looks like we do not have an e-mail address for you. Go to [[Special:Preferences|user preferences]] to enter one.',

	// confirm email
	'usersignup-confirm-page-title' => 'Confirm your email',
	'usersignup-confirm-email-resend-email' => "Send me another confirmation email",
	'usersignup-confirm-email-change-email-content' => "I want to use a different e-mail address.",
	'usersignup-confirm-email-change-email' => 'Change my e-mail address',
	'usersignup-confirm-email-new-email-label' => 'New email',
	'usersignup-confirm-email-update' => 'Update',
	'usersignup-confirm-email-tooltip' => 'Did you enter an e-mail address that you can\'t confirm, or do you want to use a different e-mail address? Don\'t worry, use the link below to change your e-mail address and get a new confirmation email.',
	'usersignup-resend-email-heading-success' => 'New email sent',
	'usersignup-resend-email-heading-failure' => 'Email not re-sent',
	'usersignup-confirm-page-heading-confirmed-user' => 'Congrats!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'You\'re already confirmed',

	// confirmation email
	'usersignup-confirmation-heading' => 'Almost there',
	'usersignup-confirmation-heading-email-resent' => 'New email sent',
	'usersignup-confirmation-subheading' => 'Check your email',
	'usersignup-confirmation-email-sent' => "We sent an email to '''$1'''.

Click the confirmation link in your email to finish creating your account.",  // intentional line break
	'usersignup-confirmation-email_subject' => 'Almost there! Confirm your Wikia account',
	'usersignup-confirmation-email-greeting' => 'Hi $USERNAME,',
	'usersignup-confirmation-email-content' => 'You\'re one step away from creating your account on Wikia! Click the link below to confirm your e-mail address and get started.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'The Wikia Team',
	'usersignup-confirmation-email_body' => 'Hi $2,

You\'re one step away from creating your account on Wikia! Click the link below to confirm your e-mail address and get started.

$3

The Wikia Team


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-confirmation-email_body-html' => '',

	// reconfirmation email
	'usersignup-reconfirmation-email-sent' => "Your e-mail address has been changed to $1. We've sent you a new confirmation email. Please confirm the new e-mail address.",
	'usersignup-reconfirmation-email_subject' => 'Confirm your e-mail address change on Wikia',
	'usersignup-reconfirmation-email-greeting' => 'Hi $USERNAME',
	'usersignup-reconfirmation-email-content' => 'Please click the link below to confirm your change of e-mail address on Wikia.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

You\'ll continue to recieve email at your old e-mail address until you confirm this one.',
	'usersignup-reconfirmation-email-signature' => 'The Wikia Team',
	'usersignup-reconfirmation-email_body' => 'Hi $2,

Please click the link below to confirm your change of e-mail address on Wikia.

$3

You\'ll continue to recieve email at your old e-mail address until you confirm this one.

The Wikia Team


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-reconfirmation-email_body-HTML' => '',

	// welcome email
	'usersignup-welcome-email-subject' => 'Welcome to Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hi $USERNAME',
	'usersignup-welcome-email-heading' => 'We\'re happy to welcome you to Wikia and {{SITENAME}}! Here are some things you can do to get started.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edit your profile.',
	'usersignup-welcome-email-edit-profile-content' => 'Add a profile photo and a few quick facts about yourself on your {{SITENAME}} profile.',
	'usersignup-welcome-email-edit-profile-button' => 'Go to profile',
	'usersignup-welcome-email-learn-basic-heading' => 'Learn the basics.',
	'usersignup-welcome-email-learn-basic-content' => 'Get a quick tutorial on the basics of Wikia: how to edit a page, your user profile, change your preferences, and more.',
	'usersignup-welcome-email-learn-basic-button' => 'Check it out',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explore more wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'There are thousands of wikis on Wikia, find more wikis that interest you by heading to one of our hubs: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Video Games</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Entertainment</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Lifestyle</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Go to wikia.com',
	'usersignup-welcome-email-content' => 'Want more information? Find advice, answers, and the Wikia community at <a style="color:#2C85D5;" href="http://community.wikia.com">Community Central</a>. Happy editing!',
	'usersignup-welcome-email-signature' => 'The Wikia Team',
	'usersignup-welcome-email-body' => 'Hi $USERNAME,

We\'re happy to welcome you to Wikia and {{SITENAME}}! Here are some things you can do to get started.

Edit your profile.

Add a profile photo and a few quick facts about yourself on your {{SITENAME}} profile.

Go to $EDITPROFILEURL

Learn the basics.

Get a quick tutorial on the basics of Wikia: how to edit a page, your user profile, change your preferences, and more.

Check it out ($LEARNBASICURL)

Explore more wikis.

There are thousands of wikis on Wikia, find more wikis that interest you by heading to one of our hubs: Video Games (http://www.wikia.com/Video_Games), Entertainment (http://www.wikia.com/Entertainment), or Lifestyle (http://www.wikia.com/Lifestyle).

Go to $EXPLOREWIKISURL

Want more information? Find advice, answers, and the Wikia community at Community Central (http://www.community.wikia.com). Happy editing!

The Wikia Team


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',

	// Signup main form
	'usersignup-heading' => 'Join Wikia Today',
	'usersignup-heading-byemail' => 'Create an account for someone else',
	'usersignup-marketing-wikia' => 'Start collaborating with millions of people from around the world who come together to share what they know and love.',
	'usersignup-marketing-login' => 'Already a user? [[Special:UserLogin|Log in]]',
	'usersignup-marketing-benefits' => 'Be a part of something huge',
	'usersignup-marketing-community-heading' => 'Collaborate',
	'usersignup-marketing-community' => 'Discover and explore subjects ranging from video games to movies and tv. Meet people with similar interests and passions.',
	'usersignup-marketing-global-heading' => 'Create',
	'usersignup-marketing-global' => 'Start a wiki. Start small, grow big, with the help of others.',
	'usersignup-marketing-creativity-heading' => 'Be original',
	'usersignup-marketing-creativity' => 'Use Wikia to express your creativity with polls and top 10 lists, photo and video galleries, apps and more.',
	'usersignup-createaccount-byemail' => 'Create an account for someone else',

	// Signup form validation
	'usersignup-error-captcha' => "The word you entered didn't match the word in the box, try again!",

	// account creation email
	'usersignup-account-creation-heading' => 'Success!',
	'usersignup-account-creation-subheading' => 'We\'ve sent an email to $1',
	'usersignup-account-creation-email-sent' => 'You\'ve started the account creation process for $2. We\'ve sent them an email at $1 with a temporary password and a confirmation link.


$2 will need to click on the link in the email we sent them to confirm their account and change their temporary password to finish creating their account.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Create more accounts] on {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'An account has been created for you on Wikia!',
	'usersignup-account-creation-email-greeting' => 'Hello,',
	'usersignup-account-creation-email-content' => 'An account has been created for you on {{SITENAME}}. To access your account and change your temporary password click the link below and log in with username "$USERNAME" and password "$NEWPASSWORD".

Please log in at <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

If you did not want this account to be created you can simply ignore this email or contact our Community Support team with any questions.',
	'usersignup-account-creation-email-signature' => 'The Wikia Team',
	'usersignup-account-creation-email-body' => 'Hello,

An account has been created for you on {{SITENAME}}. To access your account and change your temporary password click the link below and log in with username "$2" and password "$3".

Please log in at {{fullurl:{{ns:special}}:UserLogin}}

If you did not want this account to be created you can simply ignore this email or contact our Community Support team with any questions.

The Wikia Team


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-account-creation-email-body-HTML' => '',

	// confirmation reminder email
	'usersignup-confirmation-reminder-email_subject' => "Don't be a stranger…",
	'usersignup-confirmation-reminder-email-greeting' => 'Hi $USERNAME',
	'usersignup-confirmation-reminder-email-content' => 'It\'s been a few days, but it looks like you haven\'t finished creating your account on Wikia yet. It\'s easy. Just click the confirmation link below:
<br/><br/>
<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>
<br/><br/>
If you don\'t confirm within 23 days your username, $USERNAME, will become available again, so don\'t wait!',
	'usersignup-confirmation-reminder-email-signature' => 'The Wikia Team',
	'usersignup-confirmation-reminder-email_body' => 'Hi $2,

It\'s been a few days, but it looks like you haven\'t finished creating your account on Wikia yet. It\'s easy. Just click the confirmation link below:

$3

If you don\'t confirm within 23 days your username, $2, will become available again, so don\'t wait!

The Wikia Team


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-confirmation-reminder-email_body-HTML' => '',
	'usersignup-facebook-problem' => 'There was a problem communicating with Facebook. Please try again later.',
);


$messages['qqq'] = array(
	'usersignup-page-title' => 'Page title for Special:UserSignup',
	'usersignup-page-captcha-label' => 'Label for captcha on signup form',

	'usersignup-error-username-length' => "Error message stating that username is too long and over $1 amount of characters.",
	'usersignup-error-invalid-user' => 'Generic error message when the user has been invalidated in the session for security reasons.',
	'usersignup-error-invalid-email' => 'Error message stating that e-mail address is invalid.',
	'usersignup-error-symbols-in-username' => 'Error message stating that username cannot contain weird symbols.',
	'usersignup-error-empty-email' => 'Error message stating that e-mail address is required.',
	'usersignup-error-empty-username' => 'Error message stating that user name field is required.',
	'usersignup-error-already-confirmed' => "Error message stating that the user has already been confirmed.",
	'usersignup-error-throttled-email' => "Error message stating that too many email has been sent.",
	'usersignup-error-too-many-changes' => "Error message stating that e-mail address has been changed too many times today.",
	'usersignup-error-password-length' => "Error message stating that password is over 50 characters and is too long.",
	'usersignup-error-confirmed-user' => 'Validation message stating that user has been confirmed already for $1 e-mail address.  $2 is link to user preference page.',

	// Facebook sign-up
	'usersignup-facebook-heading' => 'Heading on Facebook signup modal when signing up via Facebook Connect',
	'usersignup-facebook-create-account' => 'Sub heading on Facebook signup modal.',
	'usersignup-facebook-email-tooltip' => 'A hint to the user saying you can changed the email later in preferences.',
	'usersignup-facebook-have-an-account-heading' => 'Heading to suggest logging in instead.',
	'usersignup-facebook-have-an-account' => 'Suggestion to connect existing account with FB.',
	'usersignup-facebook-proxy-email' => 'Masking label if user decides to use proxy email from FB instead of real one.  This masked label will be displayed instead of the very long FB proxy e-mail address.',

	// user preferences
	'usersignup-user-pref-emailconfirmlink' => 'Action link to confirm an email on Special:Preference',
	'usersignup-user-pref-confirmemail_send' => 'Action link to re-send confirmation email',
	'usersignup-user-pref-emailauthenticated' => 'Label stating email was already confirmed.  $2 is date (April 16, 2011), $3 is time of day (01:47).  Assume $2, and $3 is already internationalized.',
	'usersignup-user-pref-emailnotauthenticated' => 'Alert to check email and to confirm email.  $1 is the e-mail address email is sent to.',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Alert that user cannot perform this action when user has not confirmed email.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Validation message telling user that email has been sent to $1. $1 is e-mail address.',
	'usersignup-user-pref-noemailprefs' => 'Alert that user email does not exist.  Instructs user to enter an e-mail address.',

	// Special:ConfirmEmail
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Alert that user\'s email is unconfirmed, and the email has already been sent.',
	'usersignup-user-pref-confirmemail_noemail' => 'Alert that email has not been entered.  Instructs and links user to Special:Preferences.',

	// confirm email page
	'usersignup-confirm-page-title' => 'Confirm page title.  This page is displayed after initially submitting the account information from Special:UserSignup.',
	'usersignup-confirm-email-resend-email' => "Action link to resend email.",
	'usersignup-confirm-email-change-email-content' => "Change email heading.",
	'usersignup-confirm-email-change-email' => 'Action link to open a dialog to change email.',
	'usersignup-confirm-email-new-email-label' => 'Label for email input.',
	'usersignup-confirm-email-update' => 'Button to submit e-mail address update form.',
	'usersignup-confirm-email-tooltip' => 'Tooltip letting user know they can change their email.  Tooltip is on the same line as usersignup-confirm-email-change-email-content',
	'usersignup-resend-email-heading-success' => 'Validation message telling the user the email has been re-sent.',
	'usersignup-resend-email-heading-failure' => 'Error message telling the user email has not been re-sent',
	'usersignup-confirm-page-heading-confirmed-user' => 'Congratulatory message when user has confirm email on confirmation page.',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Alert that user has been confirmed already.',

	// confirmation email
	'usersignup-confirmation-heading' => 'Confirm page heading.',
	'usersignup-confirmation-heading-email-resent' => 'Confirm page heading when email has been re-sent.',
	'usersignup-confirmation-subheading' => 'Confirm page sub heading.',
	'usersignup-confirmation-email-sent' => "Confirm page action validation stating email has been sent to $1 e-mail address.  Bold $1, and leave a purposeful line break between line 1 and line 2.",
	'usersignup-confirmation-email_subject' => 'Confirmation email subject',
	'usersignup-confirmation-email-greeting' => 'Confirmation email template greeting.',
	'usersignup-confirmation-email-content' => 'Confirmation email template body content.  $CONFIRMURL is full url to goto confirm email, and is displayed as-is.',
	'usersignup-confirmation-email-signature' => 'Confirmation email template footer signature.',
	'usersignup-confirmation-email_body' => 'Text only version of the confirmation email.  Contains the same content as the templated version.  $2 is username, $3 is confirmation url.',
	'usersignup-confirmation-email_body-html' => 'Standalone HTML version of confirmation email.  Contains the same content as the templated version.  $1 is username, $2 is confirmation url.',

	// reconfirmation email
	'usersignup-reconfirmation-email-sent' => "Message telling user that the e-mail address has been changed to $1.",
	'usersignup-reconfirmation-email_subject' => 'Subject of Confirmation email stating email has changed',
	'usersignup-reconfirmation-email-greeting' => 'Greeting of Confirmation email stating email has changed.',
	'usersignup-reconfirmation-email-content' => 'Body of Confirmation email stating email has changed.  $CONFIRMURL is url to confirm the email change, and is displayed and linked as-is.',
	'usersignup-reconfirmation-email-signature' => 'Signature of confirmation email stating email has changed.',
	'usersignup-reconfirmation-email_body' => 'Text-only version of Confirmation email stating email has changed.  $2 is username, $3 is confirmation url.',
	'usersignup-reconfirmation-email_body-HTML' => 'Standalone HTML email version of confirmation email stating email has changed.  $1 is username, $2 is confirmation link.',

	// welcome email
	'usersignup-welcome-email-subject' => 'Welcome email subject.  $USERNAME is magic word for user name.',
	'usersignup-welcome-email-greeting' => 'Welcome email greeting.  $USERNAME is magic word for user name.',
	'usersignup-welcome-email-heading' => 'Welcome email heading.  SITENAME is MediaWiki magic word for wiki name.',
	'usersignup-welcome-email-edit-profile-heading' => 'Welcome email first section heading.',
	'usersignup-welcome-email-edit-profile-content' => 'Welcome email first section body.  SITENAME is MediaWiki magic word.',
	'usersignup-welcome-email-edit-profile-button' => 'Welcome email first section button label.  Links to preferences in the template, so no linking required from messaging.',
	'usersignup-welcome-email-learn-basic-heading' => 'Welcome email second section heading.',
	'usersignup-welcome-email-learn-basic-content' => 'Welcome email second section body.',
	'usersignup-welcome-email-learn-basic-button' => 'Welcome email second section button label.  Do not be concerned with linking.',
	'usersignup-welcome-email-explore-wiki-heading' => 'Welcome email third section heading.',
	'usersignup-welcome-email-explore-wiki-content' => 'Welcome email third section body.  There are links to category pages on hubs.  Those links can be omitted if there are no hub pages for the language.',
	'usersignup-welcome-email-explore-wiki-button' => 'Welcome email third section button.',
	'usersignup-welcome-email-content' => 'Welcome email user help content.  Leave blank of the language does not have a helper or community wiki in that language, or leave the link to english community wiki as-is.',
	'usersignup-welcome-email-signature' => 'Welcome email signature.',
	'usersignup-welcome-email-body' => 'Text-only version of Welcome email.  $USERNAME, $EDITPROFILEURL, $LEARNBASICURL, $EXPLOREWIKISURL should be left as-is.',

	// Signup main form
	'usersignup-heading' => 'Page heading for Special:UserSignup',
	'usersignup-heading-byemail' => 'Page heading for Special:UserSignup?byemail=1 to create account for others.',
	'usersignup-marketing-wikia' => 'Marketing message on the left side of Special:UserSignup',
	'usersignup-marketing-login' => 'Encouragement to login if account exists on the left side of Special:UserSignup.  Link to Special:UserLogin using wikitext.',
	'usersignup-marketing-benefits' => 'Heading for right side of Special:UserSignup',
	'usersignup-marketing-community-heading' => 'Subsection heading on right side of Special:UserSignup',
	'usersignup-marketing-community' => 'Marketing blurb on right side of Special:UserSignup',
	'usersignup-marketing-global-heading' => 'Second subsection heading on right side of Special:UserSignup',
	'usersignup-marketing-global' => 'Second marketing blurb on right side of Special:UserSignup.',
	'usersignup-marketing-creativity-heading' => 'Third subsection heading on right side of Special:UserSignup',
	'usersignup-marketing-creativity' => 'Third marketing blurb on right side of Special:UserSignup.',
	'usersignup-createaccount-byemail' => 'Button label on signup form for Special:UserSignup?byemail=1 to create account for others.',

	// Signup form validation
	'usersignup-error-captcha' => "Error message for captcha failure.",

	// account creation by email
	'usersignup-account-creation-heading' => 'Page heading for confirm page when byemail=1 is used.',
	'usersignup-account-creation-subheading' => 'Page subheading for confirm page when byemail=1 is used.  $1 is e-mail address.',
	'usersignup-account-creation-email-sent' => 'Page content for confirm page when byemail=1 is used.  $2 is the user name that the account has been created for.  $1 is e-mail address sent to.',
	'usersignup-account-creation-email-subject' => 'Confirmation email subject for people receiving the account when byemail=1 is used.',
	'usersignup-account-creation-email-greeting' => 'Confirmation email greeting for people receiving the account when byemail=1 is used.',
	'usersignup-account-creation-email-content' => 'Confirmation email body for people receiving the account when byemail=1 is used.  $USERNAME is user name, $NEWPASSWORD is new password for the user to use.',
	'usersignup-account-creation-email-signature' => 'Confirmation email signature for people receiving the account when byemail=1 is used.',
	'usersignup-account-creation-email-body' => 'Text-only version of confirmation email for people receiving the account when byemail=1 is used.  $2 is username, $3 is the new password.',
	'usersignup-account-creation-email-body-HTML' => 'Standalone HTML version of confirmation email for people receiving the account when byemail=1 is used.  $2 is username, $3 is the new password.',

	// confirmation reminder email
	'usersignup-confirmation-reminder-email_subject' => "Confirmation email subject that is sent 7 days after user has started the signup process without confirming.",
	'usersignup-confirmation-reminder-email-greeting' => 'Confirmation email greeting that is sent 7 days after user has started the signup process without confirming.  $USERNAME is user name.',
	'usersignup-confirmation-reminder-email-content' => 'Confirmation email body that is sent 7 days after user has started the signup process without confirming.  $CONFIRMURL is confirmation url, and should be displayed and linked as-is.  $USERNAME is user name.',
	'usersignup-confirmation-reminder-email-signature' => 'Confirmation email signature that is sent 7 days after user has started the signup process without confirming.',
	'usersignup-confirmation-reminder-email_body' => 'Text-only version of confirmation email that is sent 7 days after user has started the signup process without confirming.  $1 is username, $2 is confirmation url.',
	'usersignup-confirmation-reminder-email_body-HTML' => 'Stand-alone HTML version of confirmation email that is sent 7 days after user has started the signup process without confirming.  $1 is username, $2 is confirmation url.',

);

/** Spanish (español)
 * @author VegaDark
 */
$messages['es'] = array(
	'usersignup-page-title' => 'Únete a Wikia',
	'usersignup-page-captcha-label' => 'Palabra borrosa',
	'usersignup-error-username-length' => 'Vaya, tu nombre no puede ser más de {{PLURAL:$1|un caracter|$1 caracteres}}.',
	'usersignup-error-invalid-user' => 'Usuario inválido. Por favor identifícate primero.',
	'usersignup-error-invalid-email' => 'Por favor escribe una dirección de correo electrónico válida.',
	'usersignup-error-symbols-in-username' => 'Vaya, tu nombre de usuario sólo puede contener letras y números.',
	'usersignup-error-empty-email' => 'Vaya, por favor escribe tu dirección de correo electrónico.',
	'usersignup-error-empty-username' => 'Vaya, por favor rellena el campo de nombre de usuario.',
	'usersignup-error-already-confirmed' => 'Ya has confirmado este correo electrónico.',
	'usersignup-error-throttled-email' => 'Vaya, has solicitado demasiados mensajes de confirmación hoy. Intenta otra vez en poco tiempo.',
	'usersignup-error-too-many-changes' => 'Has alcanzado el límite máximo de hoy para cambiar el correo electrónico. Por favor, inténtalo más tarde.',
	'usersignup-error-password-length' => 'Tu contraseña es demasiado larga. Elige una contraseña de 50 caracteres o menos.',
	'usersignup-error-confirmed-user' => '¡Parece que ya has confirmado tu correo electrónico para $1! Revisa tu [$2 perfil de usuario].',
	'usersignup-facebook-heading' => 'Termina de registrarte',
	'usersignup-facebook-create-account' => 'Crear una cuenta',
	'usersignup-facebook-email-tooltip' => 'Si deseas utilizar un correo electrónico diferente, puedes cambiarlo después en tus preferencias.',
	'usersignup-facebook-have-an-account-heading' => '¿Ya tienes una cuenta?',
	'usersignup-facebook-have-an-account' => 'Conecta tu nombre de usuario existente en Wikia con Facebook.',
	'usersignup-facebook-proxy-email' => 'Correo electrónico anónimo de Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Solicita una nueva confirmación de correo electrónico',
	'usersignup-user-pref-confirmemail_send' => 'Reenviar mi confirmación de correo electrónico',
	'usersignup-user-pref-emailauthenticated' => '¡Gracias! Tu correo electrónico fue confirmado en $2 a las $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Revisa tu correo electrónico y haz clic en el enlace de confirmación para terminar de cambiar tu correo a: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => '¡Oh, no! Tu correo electrónico no está confirmado. Las funcionalidades del correo electrónico no funcionarán hasta que confirmes tu dirección.',
	'usersignup-user-pref-reconfirmation-email-sent' => '¡Ya casi! Hemos enviado una nueva confirmación al correo $1. Revisa tu correo electrónico y haz clic en el enlace para terminar de confirmar tu correo electrónico.',
	'usersignup-user-pref-noemailprefs' => 'Parece que no tenemos una dirección de correo electrónico para ti. Por favor escribe una dirección de correo electrónico arriba.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => '¡Oh, no! Tu correo electrónico no está confirmado. Hemos enviado un correo electrónico, haz clic en el enlace de confirmación para confirmar.',
	'usersignup-user-pref-confirmemail_noemail' => 'Parece que no tenemos una dirección de correo electrónico para ti. Ve a tus [[Special:Preferences|preferencias]] para ingresar uno.',
	'usersignup-confirm-page-title' => 'Confirma tu correo electrónico',
	'usersignup-confirm-email-resend-email' => 'Enviarme otra confirmación de correo electrónico',
	'usersignup-confirm-email-change-email-content' => 'Quiero usar una dirección de correo electrónico diferente.',
	'usersignup-confirm-email-change-email' => 'Cambiar mi correo electrónico',
	'usersignup-confirm-email-new-email-label' => 'Nuevo correo electrónico',
	'usersignup-confirm-email-update' => 'Actualizar',
	'usersignup-confirm-email-tooltip' => '¿Escribiste un correo electrónico que no puedes confirmar o quieres usar un correo diferente? No te preocupes, usa el enlace de abajo para cambiar tu correo electrónico y recibir una confirmación nueva.',
	'usersignup-resend-email-heading-success' => 'Nuevo correo electrónico enviado',
	'usersignup-resend-email-heading-failure' => 'Correo electrónico no reenviado',
	'usersignup-confirm-page-heading-confirmed-user' => '¡Felicitaciones!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Ya estás confirmado',
	'usersignup-confirmation-heading' => '¡Ya casi!',
	'usersignup-confirmation-heading-email-resent' => 'Nuevo correo electrónico enviado',
	'usersignup-confirmation-subheading' => 'Revisa tu correo electrónico',
	'usersignup-confirmation-email-sent' => "Hemos enviado un correo electrónico a '''$1'''.

Haz clic en el enlace de confirmación en tu correo para terminar de crear tu cuenta.",
	'usersignup-confirmation-email_subject' => '¡Ya casi! Confirma tu cuenta de Wikia',
	'usersignup-confirmation-email-greeting' => 'Hola $USERNAME,',
	'usersignup-confirmation-email-content' => '¡Estás a un paso de crear tu cuenta en Wikia! Haz clic en el enlace de abajo para confirmar tu correo electrónico y comenzar a editar.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'El Equipo de Wikia',
	'usersignup-confirmation-email_body' => 'Hola $2,

¡Estás a un paso de crear tu cuenta en Wikia! Haz clic en el enlace de abajo para confirmar tu correo electrónico y comenzar a editar.

$3

El Equipo de Wikia


___________________________________________

Para consultar las últimas noticias de Wikia, visita http://es.wikia.com
¿Quieres controlar los correos que recibes? Ve a: {{fullurl:{{ns:special}}:Preferencias}}',
	'usersignup-reconfirmation-email-sent' => 'Tu correo electrónico ha sido cambiado a $1. Hemos enviado un nuevo mensaje de confirmación. Por favor confirma la nueva dirección de correo electrónico.',
	'usersignup-reconfirmation-email_subject' => 'Confirma el cambio de correo electrónico en Wikia',
	'usersignup-reconfirmation-email-greeting' => 'Hola $USERNAME',
	'usersignup-reconfirmation-email-content' => 'Por favor haz clic en el enlace de abajo para confirmar el cambio de correo electrónico en Wikia.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Seguirás recibiendo mensajes a tu correo electrónico viejo hasta que confirmes este otro.',
	'usersignup-reconfirmation-email-signature' => 'El Equipo de Wikia',
	'usersignup-reconfirmation-email_body' => 'Hola $2,

Por favor haz clic en el enlace de abajo para confirmar el cambio de correo electrónico en Wikia.

$3

Seguirás recibiendo mensajes en tu correo electrónico viejo hasta que confirmes este otro.

El Equipo de Wikia


___________________________________________

Para ver las noticias más recientes en Wikia, visita http://es.wikia.com
¿Quieres controlar los mensajes que recibes?? Ve a: {{fullurl:{{ns:special}}:Preferencias}}',
	'usersignup-welcome-email-subject' => '¡Bienvenido a Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hola $USERNAME',
	'usersignup-welcome-email-heading' => '¡Estamos encantados de darte la bienvenida a Wikia y a {{SITENAME}}! Aquí hay algunas cosas que puedes hacer para comenzar.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edita tu perfil.',
	'usersignup-welcome-email-edit-profile-content' => 'Añade una imagen de perfil y otras cosas más sobre ti en tu perfil de {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Ir a tu perfil',
	'usersignup-welcome-email-learn-basic-heading' => 'Aprende los conceptos básicos.',
	'usersignup-welcome-email-learn-basic-content' => 'Obtén un tutorial rápido sobre los conceptos básicos de Wikia; cómo editar una página, tu perfil de usuario, cambiar tus preferencias y mucho más.',
	'usersignup-welcome-email-learn-basic-button' => '¡Échale un vistazo!',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explora más wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'Hay miles de wikis en Wikia, encuentra más wikis que te interesen revisando nuestras categorías: <a style="color:#2C85D5;" href="http://es.wikia.com/wiki/Juegos">Video Juegos</a>, <a style="color:#2C85D5;" href="http://es.wikia.com/wiki/Entretenimiento">Entretenimiento</a>, o <a style="color:#2C85D5;" href="http://es.wikia.com/wiki/Estilo_de_vida">Estilo de vida</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Ir a es.wikia.com',
	'usersignup-welcome-email-content' => '¿Quieres más información? Encuentra consejos y respuestas en la comunidad de Wikia <a style="color:#2C85D5;" href="http://es.wikia.com">Wikia en Español</a>.',
	'usersignup-welcome-email-signature' => 'El Equipo de Wikia',
	'usersignup-welcome-email-body' => 'Hola $USERNAME,

¡Estamos felices en darte la bienvenida a Wikia y a {{SITENAME}}! Aquí hay algunas cosas que puedes hacer para comenzar.

Edita tu perfil.

Añade una imagen de perfil y otras cosas sobre ti en tu perfil de {{SITENAME}}.

Ve a $EDITPROFILEURL

Aprende conceptos básicos.

Obtén un tutorial rápido sobre los conceptos básicos de Wikia; cómo editar una página, tu perfil de usuario, cambiar tus preferencias y mucho más.

Échale un vistazo ($LEARNBASICURL)

Explora más wikis.

Hay miles de wikis en Wikia, encuentra más wikis que te interesen revisando nuestras categorías: <a style="color:#2C85D5;" href="http://es.wikia.com/wiki/Juegos">Video Juegos</a>, <a style="color:#2C85D5;" href="http://es.wikia.com/wiki/Entretenimiento">Entretenimiento</a>, o <a style="color:#2C85D5;" href="http://es.wikia.com/wiki/Estilo_de_vida">Estilo de vida</a>.

Ir a $EXPLOREWIKISURL

¿Quieres más información? Encuentra consejos y respuestas en la comunidad de Wikia <a style="color:#2C85D5;" href="http://es.wikia.com">Wikia en Español</a>.

El Equipo de Wikia


___________________________________________

Para ver las noticias más recientes en Wikia, visita http://es.wikia.com
¿Quieres controlar los mensajes que recibes?? Ve a: {{fullurl:{{ns:special}}:Preferencias}}',
	'usersignup-heading' => 'Únete hoy a Wikia',
	'usersignup-heading-byemail' => 'Crear una cuenta para alguien más',
	'usersignup-marketing-wikia' => 'Comienza a colaborar con millones de personas de todo el mundo quienes se reúnen para compartir lo que conocen y aman.',
	'usersignup-marketing-login' => '¿Ya eres un usuario? [[Special:UserLogin|Inicia sesión]]',
	'usersignup-marketing-benefits' => 'Sé parte de algo enorme',
	'usersignup-marketing-community-heading' => 'Colabora',
	'usersignup-marketing-community' => 'Descubre y explora temas que van desde videojuegos hasta películas y televisión. Conoce gente con intereses y pasiones similares.',
	'usersignup-marketing-global-heading' => 'Crear',
	'usersignup-marketing-global' => 'Comienza un wiki. Comienza con poco y crece con la ayuda de otros.',
	'usersignup-marketing-creativity-heading' => 'Sé original',
	'usersignup-marketing-creativity' => 'Usa Wikia para expresar tu creatividad con encuestas y listas, galerías de imágenes y vídeos, aplicaciones y más.',
	'usersignup-createaccount-byemail' => 'Crea una cuenta para alguien más',
	'usersignup-error-captcha' => 'La palabra que ingresaste no concordó con la palabra en la caja, ¡inténtalo de nuevo!',
	'usersignup-account-creation-heading' => '¡Listo!',
	'usersignup-account-creation-subheading' => 'Hemos enviado un correo electrónico a $1',
	'usersignup-account-creation-email-sent' => 'Has comenzado el proceso de creación de cuenta para $2. Hemos enviado un correo a $1 con una contraseña temporal y el enlace de confirmación.

$2 tendrá que hacer clic en el enlace del correo que le enviamos para confirmar su cuenta y cambiar la contraseña temporal para terminar de crear la cuenta.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Crear más cuentas] en {{SITENAME}}',
	'usersignup-account-creation-email-subject' => '¡Se ha creado una cuenta para ti en Wikia!',
	'usersignup-account-creation-email-greeting' => 'Hola,',
	'usersignup-account-creation-email-content' => 'Se ha creado una cuenta para ti en {{SITENAME}}. Para acceder a tu cuenta y cambiar la contraseña temporal haz clic en el enlace de abajo e identifícate con el nombre de usuario "$USERNAME" y la contraseña "$NEWPASSWORD".

Por favor inicia sesión en <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Si no querías crear esta cuenta simplemente ignora este correo o contacta con nuestro Equipo Comunitario con cualquier pregunta.',
	'usersignup-account-creation-email-signature' => 'El Equipo de Wikia',
	'usersignup-account-creation-email-body' => 'Hola,

Se ha creado una cuenta para ti en {{SITENAME}}. Para acceder a tu cuenta y cambiar la contraseña temporal haz clic en el enlace de abajo e identifícate con el nombre de usuario "$2" y la contraseña "$3".

Por favor inicia sesión en {{fullurl:{{ns:special}}:UserLogin}}

Si no querías crear esta cuenta simplemente ignora este correo o contacta con nuestro Equipo Comunitario con cualquier pregunta.

El Equipo de Wikia


___________________________________________
Para ver las noticias más recientes en Wikia, visita http://es.wikia.com
¿Quieres controlar los mensajes que recibes?? Ve a: {{fullurl:{{ns:special}}:Preferencias}}',
	'usersignup-confirmation-reminder-email_subject' => 'No seas un desconocido...',
	'usersignup-confirmation-reminder-email-greeting' => 'Hola $USERNAME',
	'usersignup-confirmation-reminder-email-content' => 'Han paso algunos días pero parece que no has terminado de crear tu cuenta en Wikia. Es fácil. Solo haz clic en el enlace de confirmación de abajo:
<br /><br />
<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>
<br /><br />
Si no confirmas tu cuenta en 23 días, $USERNAME estará disponible de nuevo, ¡así que no esperes!',
	'usersignup-confirmation-reminder-email-signature' => 'El Equipo de Wikia',
	'usersignup-confirmation-reminder-email_body' => 'Hola $2,

Han paso algunos días pero parece que no has terminado de crear tu cuenta en Wikia. Es fácil. Solo haz clic en el enlace de confirmación de abajo:

$3

Si no confirmas tu cuenta en 23 días, $USERNAME estará disponible de nuevo, ¡así que no esperes!

El Equipo de Wikia


___________________________________________

Para ver las noticias más recientes en Wikia, visita http://es.wikia.com
¿Quieres controlar los mensajes que recibes?? Ve a: {{fullurl:{{ns:special}}:Preferencias}}',
	'usersignup-facebook-problem' => 'Hubo un problema de comunicación con Facebook. Por favor, inténtalo más tarde.',
);

/** French (français)
 * @author Gomoko
 * @author Wyz
 */
$messages['fr'] = array(
	'usersignup-page-title' => 'Rejoindre Wikia',
	'usersignup-page-captcha-label' => 'Mot flou',
	'usersignup-error-username-length' => "Oups, votre nom d'utilisateur ne peut pas dépasser {{PLURAL:$1|un caractère|$1 caractères}}.",
	'usersignup-error-invalid-user' => "Utilisateur non valide. Veuillez d'abord vous connecter.",
	'usersignup-error-invalid-email' => 'Veuillez entrer une adresse de courriel valide.',
	'usersignup-error-symbols-in-username' => "Oups, votre nom d'utilisateur ne peut contenir que des lettres et des chiffres.",
	'usersignup-error-empty-email' => 'Oups, veuillez remplir votre adresse de courriel.',
	'usersignup-error-empty-username' => "Oups, veuillez remplir le champ nom d'utilisateur.",
	'usersignup-error-already-confirmed' => 'Vous avez déjà confirmé cette adresse de courriel.',
	'usersignup-error-throttled-email' => 'Oups, vous avez demandé trop de fois aujourd’hui à ce que des courriels de confirmation vous soient envoyés. Veuillez réessayer un peu plus tard.',
	'usersignup-error-too-many-changes' => "Vous avez atteint la limite maximale pour les changements de courriel aujourd'hui. Veuillez réessayer plus tard.",
	'usersignup-error-password-length' => 'Oups, votre mot de passe est trop long. Veuillez choisir un mot de passe de 50 caractères ou moins.',
	'usersignup-error-confirmed-user' => 'Il semblerait que vous ayez déjà confirmé votre adresse de courriel pour  $1 ! Vérifiez votre [$2 profil utilisateur].',
	'usersignup-facebook-heading' => "Finir de s'inscrire",
	'usersignup-facebook-create-account' => 'Créer un compte',
	'usersignup-facebook-email-tooltip' => 'Si vous voulez utiliser une adresse courriel différente, vous pourrez la modifier plus tard dans vos préférences.',
	'usersignup-facebook-have-an-account-heading' => 'Vous avez déjà un compte?',
	'usersignup-facebook-have-an-account' => "Connectez plutôt votre nom d'utilisateur existant de Wikia avec Facebook.",
	'usersignup-facebook-proxy-email' => 'Courriel anonyme Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Demander un nouveau courriel de confirmation',
	'usersignup-user-pref-confirmemail_send' => 'Renvoyer mon courriel de confirmation',
	'usersignup-user-pref-emailauthenticated' => 'Merci! Votre adresse de courriel a été confirmée le $2 à $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Vérifiez votre courriel et cliquez sur le lien de confirmation pour terminer le changement votre adresse de courriel à: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => "Oh, non! Votre adresse de courriel est non confirmée. Les fonctionnalités de courriel ne fonctionneront pas jusqu'à ce que vous confirmiez votre adresse de courriel.",
	'usersignup-user-pref-reconfirmation-email-sent' => 'Presque! Nous avons envoyé un nouveau courriel de confirmation à $1. Vérifiez votre courriel et cliquez sur le lien pour terminer la confirmation de votre adresse de courriel.',
	'usersignup-user-pref-noemailprefs' => "Il semblerait que nous n'avons pas d'adresse de courriel pour vous. Veuillez entrer une adresse de courriel ci-dessus.",
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Oh, non! Votre adresse de courriel est non confirmée. Nous vous avez envoyé un courriel, cliquez sur le lien de confirmation ici pour la confirmer.',
	'usersignup-user-pref-confirmemail_noemail' => "Il semblerait que nous n'avons pas d'adresse de courriel pour vous. Allez sur les [[Special:Preferences|préférences utilisateur]] pour en entrer un.",
	'usersignup-confirm-page-title' => 'Confirmez votre adresse de courriel',
	'usersignup-confirm-email-resend-email' => "M'envoyer un autre courriel de confirmation",
	'usersignup-confirm-email-change-email-content' => 'Je veux utiliser une autre adresse de messagerie.',
	'usersignup-confirm-email-change-email' => 'Changer mon adresse de courriel',
	'usersignup-confirm-email-new-email-label' => 'Nouveau courriel',
	'usersignup-confirm-email-update' => 'Mise à jour',
	'usersignup-confirm-email-tooltip' => 'Avez-vous saisi une adresse de courriel que vous ne pouvez pas confirmer, ou voulez-vous utiliser une autre adresse de courriel? Ne vous inquiétez pas, utilisez le lien ci-dessous pour modifier votre adresse de courriel et obtenir un nouveau courriel de confirmation.',
	'usersignup-resend-email-heading-success' => 'Nouveau courriel envoyé',
	'usersignup-resend-email-heading-failure' => 'Courriel non réenvoyé',
	'usersignup-confirm-page-heading-confirmed-user' => 'Félicitations!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Vous êtes déjà confirmé',
	'usersignup-confirmation-heading' => 'Presque arrivé',
	'usersignup-confirmation-heading-email-resent' => 'Nouveau courriel envoyé',
	'usersignup-confirmation-subheading' => 'Vérifiez votre courriel',
	'usersignup-confirmation-email-sent' => "Nous avons envoyé un courriel à '''$1'''.

Cliquez sur le lien de confirmation dans votre courriel pour terminer la création de votre compte.",
	'usersignup-confirmation-email_subject' => 'Presque! Confirmez votre compte Wikia',
	'usersignup-confirmation-email-greeting' => 'Bonjour $USERNAME,',
	'usersignup-confirmation-email-content' => 'Vous êtes à la dernière étape de la création de votre compte sur Wikia! Cliquez sur le lien ci-dessous pour confirmer votre adresse de courriel et démarrer.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => "L'équipe Wikia",
	'usersignup-confirmation-email_body' => "Bonjour $2,

Vous êtes à la dernière étape de la création de votre compte sur Wikia! Cliquez sur le lien ci-dessous pour confirmer votre adresse de courriel et démarrer.

$3

L'équipe Wikia


___________________________________________

Pour obtenir les derniers événements sur Wikia, allez à http://community.wikia.com
Vous voulez contrôler quels courriels vous recevez? Allez à: {{fullurl:{{ns:special}}:Preferences}}",
	'usersignup-reconfirmation-email-sent' => 'Votre adresse électronique a été modifiée en $1. Nous vous avons envoyé un nouveau courriel de confirmation. Veuillez confirmer la nouvelle adresse de courriel.',
	'usersignup-reconfirmation-email_subject' => "Confirmer votre changement d'adresse de courriel sur Wikia",
	'usersignup-reconfirmation-email-greeting' => 'Bonjour $USERNAME',
	'usersignup-reconfirmation-email-content' => 'Veuillez cliquer sur le lien ci-dessous pour confirmer votre changement d\'adresse de courriel sur Wikia.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Vous continuerez à recevoir des courriels à votre ancienne adresse tant que vous n\'aurez pas validé celle-ci.',
	'usersignup-reconfirmation-email-signature' => "L'équipe Wikia",
	'usersignup-reconfirmation-email_body' => "Bonjour $2,

Veuillez cliquer sur le lien ci-dessous pour confirmer votre changement d'adresse électronique sur Wikia.

$3

Vous continuerez à recevoir les courriels à votre ancienne adresse tant que vous n'aurez pas confirmé celle-ci.

L'équipe Wikia


___________________________________________

Pour obtenir les derniers événements sur Wikia, visitez http://community.wikia.com
Vous voulez contrôler quels courriels vous recevez? Allez à:: {{fullurl:{{ns:special}}:Preferences}}",
	'usersignup-welcome-email-subject' => 'Bienvenue sur Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Bonjour $USERNAME',
	'usersignup-welcome-email-heading' => 'Nous sommes heureux de vous accueillir sur Wikia et {{SITENAME}}! Voici certaines choses que vous pouvez faire pour commencer.',
	'usersignup-welcome-email-edit-profile-heading' => 'Modifier votre profil.',
	'usersignup-welcome-email-edit-profile-content' => 'Ajouter une photo profil et quelques faits marquants sur vous-même sur votre profil de {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Aller au profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Apprendre les bases.',
	'usersignup-welcome-email-learn-basic-content' => "Obtenir un tutoriel rapide sur les bases de Wikia : comment modifier une page, votre profil utilisateur, modifier vos préférences, et d'autres choses.",
	'usersignup-welcome-email-learn-basic-button' => 'Vérifier',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explorez davantage de wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'Il y a des milliers de wikis sur Wikia; trouvez davantage de wikis qui vous intéressent en vous dirigeant vers un de nos centres: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Jeux vidéo</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Divertissement</a>, ou <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Mode de vie</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Aller à wikia.com',
	'usersignup-welcome-email-content' => 'Vous voulez plus d\'informations? Trouvez des conseils, des réponses, et la communauté de Wikia sur le <a style="color:#2C85D5;" href="http://community.wikia.com">centre communautaire</a>. Bonnes modifications!',
	'usersignup-welcome-email-signature' => "L'équipe Wikia",
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'usersignup-page-title' => 'Unirse a Wikia',
	'usersignup-page-captcha-label' => 'Palabra borrosa',
	'usersignup-error-username-length' => 'Vaites! O seu nome de usuario non pode {{PLURAL:$1|ser máis dun carácter|sobrepasar os $1 caracteres}}.',
	'usersignup-error-invalid-user' => 'Usuario non válido. Acceda ao sistema primeiro.',
	'usersignup-error-invalid-email' => 'Por favor, escriba un enderezo de correo electrónico válido.',
	'usersignup-error-symbols-in-username' => 'Vaites! O seu nome de usuario unicamente pode conter letras e números.',
	'usersignup-error-empty-email' => 'Vaites! Cómpre encher o campo do enderezo de correo electrónico.',
	'usersignup-error-empty-username' => 'Vaites! Cómpre encher o campo do nome de usuario.',
	'usersignup-error-already-confirmed' => 'Xa confirmou este enderezo de correo electrónico.',
	'usersignup-error-throttled-email' => 'Vaites! Solicitou o envío de demasiados correos electrónicos de confirmación no día de hoxe. Inténteo de novo máis tarde.',
	'usersignup-error-too-many-changes' => 'Alcanzou o límite de cambios de correo electrónico no día de hoxe. Inténteo de novo máis tarde.',
	'usersignup-error-password-length' => 'Vaites! O contrasinal é longo de máis. Escolla un contrasinal de menos de 50 caracteres.',
	'usersignup-error-confirmed-user' => 'Semella que xa confirmou o enderezo de correo electrónico $1! Comprobe o seu [$2 perfil de usuario].',
	'usersignup-facebook-heading' => 'Rematar o rexistro',
	'usersignup-facebook-create-account' => 'Crear unha conta',
	'usersignup-facebook-email-tooltip' => 'Se quere usar un enderezo de correo electrónico diferente, pode cambialo máis tarde nas súas preferencias.',
	'usersignup-facebook-have-an-account-heading' => 'Xa ten unha conta?',
	'usersignup-facebook-have-an-account' => 'Conectar o seu nome de usuario de Wikia co Facebook.',
	'usersignup-facebook-proxy-email' => 'Correo electrónico anónimo do Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Solicitar un novo correo de confirmación',
	'usersignup-user-pref-confirmemail_send' => 'Reenviar o meu correo de confirmación',
	'usersignup-user-pref-emailauthenticated' => 'Grazas! O seu correo foi confirmado o $2 ás $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Comprobe o seu correo electrónico e prema na ligazón de confirmación para rematar o cambio de enderezo a: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Oh, non! O seu correo electrónico non está confirmado. As características do correo non funcionarán ata que confirme o enderezo.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Xa case está! Enviamos un novo correo de confirmación a $1. Comprobe o seu correo electrónico e prema na ligazón para rematar a confirmación do enderezo.',
	'usersignup-user-pref-noemailprefs' => 'Semella que non temos o seu enderezo de correo electrónico. Insira un enderezo enriba.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Oh, non! O seu correo electrónico non está confirmado. Enviámoslle un correo electrónico, prema na ligazón de confirmación para confirmar o enderezo.',
	'usersignup-user-pref-confirmemail_noemail' => 'Semella que non temos o seu enderezo de correo electrónico. Vaia ás [[Special:Preferences|preferencias de usuario]] para inserir un.',
	'usersignup-confirm-page-title' => 'Confirme o seu enderezo de correo electrónico',
	'usersignup-confirm-email-resend-email' => 'Enviádeme outro correo de confirmación',
	'usersignup-confirm-email-change-email-content' => 'Quero usar un enderezo de correo electrónico diferente.',
	'usersignup-confirm-email-change-email' => 'Cambiar o meu enderezo de correo electrónico',
	'usersignup-confirm-email-new-email-label' => 'Novo correo electrónico',
	'usersignup-confirm-email-update' => 'Actualizar',
	'usersignup-confirm-email-tooltip' => 'Inseriu un enderezo de correo electrónico que non pode confirmar? Quere usar un enderezo de correo electrónico diferente? Non se preocupe, utilice a ligazón inferior para cambiar o seu enderezo de correo electrónico e obter unha nova mensaxe de confirmación.',
	'usersignup-resend-email-heading-success' => 'Enviouse o novo correo',
	'usersignup-resend-email-heading-failure' => 'Non se reenviou o correo',
	'usersignup-confirm-page-heading-confirmed-user' => 'Parabéns!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Xa está confirmado',
	'usersignup-confirmation-heading' => 'Xa case está',
	'usersignup-confirmation-heading-email-resent' => 'Enviouse o novo correo',
	'usersignup-confirmation-subheading' => 'Comprobe o seu correo',
	'usersignup-confirmation-email-sent' => "Enviamos un correo a '''$1'''.

Prema na ligazón de confirmación do seu correo para rematar a creación da súa conta.",
	'usersignup-confirmation-email_subject' => 'Xa case está! Confirme a súa conta de Wikia',
	'usersignup-confirmation-email-greeting' => 'Boas, $USERNAME:',
	'usersignup-confirmation-email-content' => 'Está a un paso de crear a súa conta en Wikia! Prema na ligazón inferior para confirmar o seu enderezo de correo electrónico.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'O equipo de Wikia',
	'usersignup-confirmation-email_body' => 'Boas, $2:

Está a un paso de crear a súa conta en Wikia! Prema na ligazón inferior para confirmar o seu enderezo de correo electrónico.

$3

O equipo de Wikia


___________________________________________

Para botar unha ollada aos últimos acontecementos en Wikia, visite http://community.wikia.com
Quere controlar os correos electrónicos que recibe? Vaia a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-reconfirmation-email-sent' => 'O seu enderezo de correo electrónico cambiouse a $1. Enviámoslle un novo correo de confirmación. Confirme o novo enderezo.',
	'usersignup-reconfirmation-email_subject' => 'Confirme o cambio no enderezo de correo electrónico en Wikia',
	'usersignup-reconfirmation-email-greeting' => 'Boas, $USERNAME:',
	'usersignup-reconfirmation-email-content' => 'Prema na ligazón inferior para confirmar o cambio no enderezo de correo electrónico en Wikia.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Seguirá recibindo correos no enderezo vello ata que confirme este.',
	'usersignup-reconfirmation-email-signature' => 'O equipo de Wikia',
	'usersignup-reconfirmation-email_body' => 'Boas, $2:

Prema na ligazón inferior para confirmar o cambio no enderezo de correo electrónico en Wikia.

$3

Seguirá recibindo correos no enderezo vello ata que confirme este.

O equipo de Wikia


___________________________________________

Para botar unha ollada aos últimos acontecementos en Wikia, visite http://community.wikia.com
Quere controlar os correos electrónicos que recibe? Vaia a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-welcome-email-subject' => 'Dámoslle a benvida a Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Boas, $USERNAME:',
	'usersignup-welcome-email-heading' => 'Estamos encantados de darlle a benvida a Wikia e a {{SITENAME}}! Aquí hai algunhas cousas que pode facer para comezar.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edite o seu perfil.',
	'usersignup-welcome-email-edit-profile-content' => 'Engada unha foto de perfil e algunhas cousas sobre vostede no seu perfil en {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Vaia ao perfil',
	'usersignup-welcome-email-learn-basic-heading' => 'Aprenda o básico.',
	'usersignup-welcome-email-learn-basic-content' => 'Lea unha breve guía cos coñecementos básicos sobre Wikia: como editar unha páxina ou o seu perfil de usuario, como cambiar as preferencias e outras cousas.',
	'usersignup-welcome-email-learn-basic-button' => 'Bótelle unha ollada',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explore máis wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'Hai milleiros de wikis en Wikia. Atope máis wikis do seu interese visitando os nosos centros de actividades: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">videoxogos</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">lecer</a> ou <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">estilo de vida</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Vaia a wikia.com',
	'usersignup-welcome-email-content' => 'Quere obter máis información? Atope consellos, respostas e á comunidade de Wikia na <a style="color:#2C85D5;" href="http://community.wikia.com">central da comunidade</a>. Páseo ben editando!',
	'usersignup-welcome-email-signature' => 'O equipo de Wikia',
	'usersignup-welcome-email-body' => 'Boas, $USERNAME:

Estamos encantados de darlle a benvida a Wikia e a {{SITENAME}}! Aquí hai algunhas cousas que pode facer para comezar.

Edite o seu perfil.

Engada unha foto de perfil e algunhas cousas sobre vostede no seu perfil en {{SITENAME}}.

Vaia a $EDITPROFILEURL

Aprenda o básico.

Lea unha breve guía cos coñecementos básicos sobre Wikia: como editar unha páxina ou o seu perfil de usuario, como cambiar as preferencias e outras cousas.

Bótelle unha ollada ($LEARNBASICURL)

Explore máis wikis.

Hai milleiros de wikis en Wikia. Atope máis wikis do seu interese visitando un dos nosos centros de actividades: videoxogos (http://www.wikia.com/Video_Games), lecer (http://www.wikia.com/Entertainment) ou estilo de vida (http://www.wikia.com/Lifestyle).

Vaia a $EXPLOREWIKISURL

Quere obter máis información? Atope consellos, respostas e á comunidade de Wikia na central da comunidade (http://www.community.wikia.com). Páseo ben editando!

O equipo de Wikia


___________________________________________

Para botar unha ollada aos últimos acontecementos en Wikia, visite http://community.wikia.com
Quere controlar os correos electrónicos que recibe? Vaia a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Únase hoxe a Wikia',
	'usersignup-heading-byemail' => 'Cree unha conta para outra persoa',
	'usersignup-marketing-wikia' => 'Comece a colaborar con millóns de persoas de todo o mundo, unidos para compartir coñecementos sobre aquilo que saben e que lles gusta.',
	'usersignup-marketing-login' => 'Xa é usuario? [[Special:UserLogin|Acceda ao sistema]]',
	'usersignup-marketing-benefits' => 'Forme parte de algo grande',
	'usersignup-marketing-community-heading' => 'Colabore',
	'usersignup-marketing-community' => 'Descubra e explore temas, desde videoxogos ata películas e televisión. Coñeza xente con intereses e paixóns similares.',
	'usersignup-marketing-global-heading' => 'Cree',
	'usersignup-marketing-global' => 'Comece un wiki. Ao primeiro será pequeno, pero irá medrando coa axuda doutras persoas.',
	'usersignup-marketing-creativity-heading' => 'Sexa orixinal',
	'usersignup-marketing-creativity' => 'Utilice Wikia para expresar a súa creatividade con enquisas e listas dos 10 mellores, galerías de fotos e vídeos, aplicacións e máis cousas.',
	'usersignup-createaccount-byemail' => 'Cree unha conta para outra persoa',
	'usersignup-error-captcha' => 'A palabra que escribiu non coincide co texto da caixa. Inténteo de novo!',
	'usersignup-account-creation-heading' => 'Todo correcto!',
	'usersignup-account-creation-subheading' => 'Enviamos un correo electrónico a $1',
	'usersignup-account-creation-email-sent' => 'Vostede comezou o proceso de creación dunha conta para $2. Enviamos un correo ao enderezo $1 cun contrasinal temporal e unha ligazón de confirmación.


$2 terá que premer na ligazón do correo que lle enviamos para confirmar a súa conta e cambiar o seu contrasinal temporal para rematar a creación da conta.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Crear máis contas] en {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Creouse unha conta para vostede en Wikia!',
	'usersignup-account-creation-email-greeting' => 'Ola:',
	'usersignup-account-creation-email-content' => 'Alguén creou unha conta para vostede en {{SITENAME}}. Para acceder á conta e cambiar o seu contrasinal temporal, prema na ligazón inferior e acceda ao sistema co nome de usuario "$USERNAME" e o contrasinal "$NEWPASSWORD".

Acceda ao sistema en <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Se non quere crear esta conta, pode ignorar esta mensaxe ou poñerse en contacto co equipo de soporte da comunidade para formular algunha pregunta.',
	'usersignup-account-creation-email-signature' => 'O equipo de Wikia',
	'usersignup-account-creation-email-body' => 'Ola:

Alguén creou unha conta para vostede en {{SITENAME}}. Para acceder á conta e cambiar o seu contrasinal temporal, prema na ligazón inferior e acceda ao sistema co nome de usuario "$2" e o contrasinal "$3".

Acceda ao sistema en {{fullurl:{{ns:special}}:UserLogin}}

Se non quere crear esta conta, pode ignorar esta mensaxe ou poñerse en contacto co equipo de soporte da comunidade para formular algunha pregunta.

O equipo de Wikia


___________________________________________

Para botar unha ollada aos últimos acontecementos en Wikia, visite http://community.wikia.com
Quere controlar os correos electrónicos que recibe? Vaia a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-confirmation-reminder-email_subject' => 'Non se convirta nun estraño…',
	'usersignup-confirmation-reminder-email-greeting' => 'Boas, $USERNAME:',
	'usersignup-confirmation-reminder-email-content' => 'Pasaron varios días, pero semella que aínda non completou o proceso de creación da súa conta de Wikia. É doado. Simplemente ten que premer na seguinte ligazón de confirmación:
<br /><br />
<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>
<br /><br />
Se non completa a confirmación antes de 23 días, o nome de usuario $USERNAME estará dispoñible novamente. Non espere máis!',
	'usersignup-confirmation-reminder-email-signature' => 'O equipo de Wikia',
	'usersignup-confirmation-reminder-email_body' => 'Boas, $2:

Pasaron varios días, pero semella que aínda non completou o proceso de creación da súa conta de Wikia. É doado. Simplemente ten que premer na seguinte ligazón de confirmación:

$3

Se non completa a confirmación antes de 23 días, o nome de usuario $2 estará dispoñible novamente. Non espere máis!

O equipo de Wikia


___________________________________________

Para botar unha ollada aos últimos acontecementos en Wikia, visite http://community.wikia.com
Quere controlar os correos electrónicos que recibe? Vaia a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Houbo un problema ao comunicar co Facebook. Inténteo de novo máis tarde.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'usersignup-page-title' => 'Adherer a Wikia',
	'usersignup-page-captcha-label' => 'Parola brumose',
	'usersignup-error-username-length' => 'Le nomine de usator non pote esser plus longe que {{PLURAL:$1|un character|$1 characteres}}.',
	'usersignup-error-invalid-user' => 'Usator non valide. Per favor aperi session primo.',
	'usersignup-error-invalid-email' => 'Per favor entra un adresse de e-mail valide.',
	'usersignup-error-symbols-in-username' => 'Le nomine de usator pote solmente litteras e numeros.',
	'usersignup-error-empty-email' => 'Per favor specifica tu adresse de e-mail.',
	'usersignup-error-empty-username' => 'Per favor specifica le nomine de usator.',
	'usersignup-error-already-confirmed' => 'Tu ha jam confirmate iste adresse de e-mail.',
	'usersignup-error-throttled-email' => 'Tu ha requestate troppo de e-mails de confirmation hodie. Reproba un poco plus tarde.',
	'usersignup-error-too-many-changes' => 'Tu ha attingite le limite de cambios de adresse de e-mail pro hodie. Per favor reproba plus tarde.',
	'usersignup-error-password-length' => 'Iste contrasigno es troppo longe. Per favor elige un contrasigno que ha 50 characteres o minus.',
	'usersignup-error-confirmed-user' => 'Il pare que tu ha jam confirmate tu adresse de e-mail pro $1! Reguarda tu [$2 profilo de usator].',
	'usersignup-facebook-heading' => 'Finir le inscription',
	'usersignup-facebook-create-account' => 'Crear conto',
	'usersignup-facebook-email-tooltip' => 'Si tu vole usar un altere adresse de e-mail, tu pote cambiar lo plus tarde in le Preferentias.',
	'usersignup-facebook-have-an-account-heading' => 'Tu jam ha un conto?',
	'usersignup-facebook-have-an-account' => 'Alternativemente, connecte tu nomine de usator existente de Wikia con Facebook.',
	'usersignup-facebook-proxy-email' => 'E-mail anonyme de Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Requestar un nove e-mail de confirmation',
	'usersignup-user-pref-confirmemail_send' => 'Reinviar mi e-mail de confirmation',
	'usersignup-user-pref-emailauthenticated' => 'Gratias! Tu adresse de e-mail ha essite confirmate le $2 a $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Recipe tu e-mail e clicca sur le ligamine de confirmation pro finir le cambio de tu adresse de e-mail a: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Oh, no! Tu adresse de e-mail non es confirmate. Le functionalitate de e-mail non pote esser usate usque tu confirma tu adresse de e-mail.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Quasi finite! Nos ha inviate un nove e-mail de confirmation a $1. Recipe tu e-mail e clicca sur le ligamine pro finir le confirmation de tu adresse de e-mail.',
	'usersignup-user-pref-noemailprefs' => 'Il pare que nos non ha un adresse de e-mail pro te. Per favor specifica un adresse de e-mail hic supra.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Oh, no! Tu adresse de e-mail non es confirmate. Nos te ha inviate un e-mail; clicca le ligamine de confirmation in illo pro confirmar le adresse.',
	'usersignup-user-pref-confirmemail_noemail' => 'Il pare que nos non ha un adresse de e-mail de te. Va al [[Special:Preferences|preferentias de usator]] pro specificar un.',
	'usersignup-confirm-page-title' => 'Confirmation del adresse de e-mail',
	'usersignup-confirm-email-resend-email' => 'Inviar me un altere message de confirmation',
	'usersignup-confirm-email-change-email-content' => 'Io vole usar un altere adresse de e-mail.',
	'usersignup-confirm-email-change-email' => 'Cambiar mi adresse de e-mail',
	'usersignup-confirm-email-new-email-label' => 'Nove e-mail',
	'usersignup-confirm-email-update' => 'Actualisar',
	'usersignup-confirm-email-tooltip' => 'Specificava tu un adresse de e-mail que tu non pote confirmar, o vole tu usar un altere adresse de e-mail? Nulle problema, usa le ligamine hic infra pro cambiar tu adresse de e-mail e reciper un nove message de confirmation.',
	'usersignup-resend-email-heading-success' => 'Nove e-mail inviate',
	'usersignup-resend-email-heading-failure' => 'E-mail non reinviate',
	'usersignup-confirm-page-heading-confirmed-user' => 'Felicitationes!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Tu es jam confirmate',
	'usersignup-confirmation-heading' => 'Quasi finite',
	'usersignup-confirmation-heading-email-resent' => 'Nove e-mail inviate',
	'usersignup-confirmation-subheading' => 'Recipe tu e-mail',
	'usersignup-confirmation-email-sent' => "Nos ha inviate un e-mail a '''$1'''.

Clicca sur le ligamine de confirmation in iste message pro finir le creation de tu conto.",
	'usersignup-confirmation-email_subject' => 'Quasi finite! Confirma tu conto de Wikia',
	'usersignup-confirmation-email-greeting' => 'Salute $USERNAME,',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'usersignup-page-title' => 'Придружете ни се на Викија',
	'usersignup-page-captcha-label' => 'Заматен збор',
	'usersignup-error-username-length' => 'Корисничкото име не може да содржи повеќе од {{PLURAL:$1|еден знак|$1 знаци}}.',
	'usersignup-error-invalid-user' => 'Неважечки корисник. Прво најавете се.',
	'usersignup-error-invalid-email' => 'Внесете важечка е-пошта.',
	'usersignup-error-symbols-in-username' => 'Корисничкото име може да содржи само букви и бројки.',
	'usersignup-error-empty-email' => 'Пополнете го полето за е-пошта.',
	'usersignup-error-empty-username' => 'Пополнете го полето за корисничко име.',
	'usersignup-error-already-confirmed' => 'Оваа е-пошта е веќе потврдена.',
	'usersignup-error-throttled-email' => 'Побаравте премногу потврдни пораки на е-пошта за денес. Обидете се пак за некое време.',
	'usersignup-error-too-many-changes' => 'Го надминавте бројот на менувања на е-пошта за денес. Обидете се пак по некое време.',
	'usersignup-error-password-length' => 'Лозинката ви е предолга. Не треба да има повеќе од 50 знаци.',
	'usersignup-error-confirmed-user' => 'Изгледа веќе ја имате потврдено вашата е-пошта за $1! Проверете си го [$2 корисничкиот профил].',
	'usersignup-facebook-heading' => 'Завршница на регистрацијата',
	'usersignup-facebook-create-account' => 'Направи сметка',
	'usersignup-facebook-email-tooltip' => 'Ако сакате да користите друга е-пошта, измената можете да ја направите подоцна во вашите Нагодувања.',
	'usersignup-facebook-have-an-account-heading' => 'Веќе имате сметка?',
	'usersignup-facebook-have-an-account' => 'Тогаш поврзете го постоечкото корисничко име на Викија со Facebook.',
	'usersignup-facebook-proxy-email' => 'Анонимна е-пошта од Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Побарај нова потврдна порака',
	'usersignup-user-pref-confirmemail_send' => 'Испрати потврдна порака пак',
	'usersignup-user-pref-emailauthenticated' => 'Благодариме! Вашата е-пошта е потврдена на $2 во $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Проверете си ја е-поштата и стиснете на потврдната врска во пораката. Така ќе ја смените во новата е-пошта: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Ох, не! Вашата е-пошта е непотврдена. Можностите поврзани со е-пошта нема да работат додека не ја потврдите.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Речиси е готово! Ви испративме нова потврдна порака на $1. Проверете си ја е-поштата и стиснете на врската за да го довршите потврдувањето.',
	'usersignup-user-pref-noemailprefs' => 'Немаме ваша е-пошта. Внесете ја погоре.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Ох, не! Вашата е-пошта е непотврдена. Ви испративме порака со потврдна врска. Стиснете на неа за да ја потврдите адресата.',
	'usersignup-user-pref-confirmemail_noemail' => 'Немаме ваша е-пошта. Внесете ја во вашите [[Special:Preferences|кориснички нагодувања]].',
	'usersignup-confirm-page-title' => 'Потврда на е-пошта',
	'usersignup-confirm-email-resend-email' => 'Испрати ми уште една потврдна порака',
	'usersignup-confirm-email-change-email-content' => 'Сакам да користам друга е-пошта.',
	'usersignup-confirm-email-change-email' => 'Смени е-пошта',
	'usersignup-confirm-email-new-email-label' => 'Нова е-пошта',
	'usersignup-confirm-email-update' => 'Поднови',
	'usersignup-confirm-email-tooltip' => 'Дали внесовте е-пошта што не можете да ја потврдите, или сакате да користите друга? Не грижете се, стиснете на долунаведената врска за да ја смените е-поштата и да добиете нова потврдна порака.',
	'usersignup-resend-email-heading-success' => 'Новата порака е испратена',
	'usersignup-resend-email-heading-failure' => 'Пораката не е препратена',
	'usersignup-confirm-page-heading-confirmed-user' => 'Честитаме!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Веќе сте потврдени',
	'usersignup-confirmation-heading' => 'Речиси е готово',
	'usersignup-confirmation-heading-email-resent' => 'Новата порака е испратена',
	'usersignup-confirmation-subheading' => 'Проверете ги ја е-поштата',
	'usersignup-confirmation-email-sent' => "Ви испративме порака на '''$1'''.

Стиснете на потврдната врска во пораката за да го довршите создавањето на сметката.",
	'usersignup-confirmation-email_subject' => 'Речиси е готово! Потврдете ја сметката',
	'usersignup-confirmation-email-greeting' => 'Здраво $USERNAME,',
	'usersignup-confirmation-email-content' => 'Ова е последниот чекор за да направите своја сметка на Викија! Стиснете на долунаведената врска за да ја потврдите е-поштата  да и започнете.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'Екипата на Викија',
	'usersignup-confirmation-email_body' => 'Здраво $2,

Ова е последниот чекор за да направите своја сметка на Викија! Стиснете на долунаведената врска за да ја потврдите е-поштата и започнете.

$3

Екипата на Викија


___________________________________________

Најновите збиднувања на Викија ќе ги најдете на http://community.wikia.com
Сакате да изберете што да добивате по е-пошта? Одете на: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-reconfirmation-email-sent' => 'Вашата е-пошта е сменета на $1. Ви испративме нова потврдна порака. Потврдете ја вашата е-пошта.',
	'usersignup-reconfirmation-email_subject' => 'Потврдете ја измената на е-поштата на Викија',
	'usersignup-reconfirmation-email-greeting' => 'Здраво $USERNAME',
	'usersignup-reconfirmation-email-content' => 'Стиснете на долунаведената врска за да ја потврдите измената на вашата е-пошта на Викија.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Пораките ќе ви пристигаат на старата адреса сè додека не ја потврдите новата.',
	'usersignup-reconfirmation-email-signature' => 'Екипата на Викија',
	'usersignup-reconfirmation-email_body' => 'Hi $2,

Стиснете на долунаведената врска за да си ја смените е-поштата на Викија.

$3

Пораките ќе ви пристигаат на старата адреса сè додека не ја потврдите новата.

Екипата на Викија


___________________________________________

Најновите збиднувања на Викија ќе ги најдете на http://community.wikia.com
Сакате да изберете што да добивате по е-пошта? Одете на: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-welcome-email-subject' => 'Добредојде на Викија, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Здраво $USERNAME',
	'usersignup-welcome-email-heading' => 'Ви посакуваме срдечно добредојде на Викија и {{SITENAME}}! Еве како да почнете.',
	'usersignup-welcome-email-edit-profile-heading' => 'Уредете го вашиот профил',
	'usersignup-welcome-email-edit-profile-content' => 'На профилот на {{SITENAME}} ставете ваша слика и накратко напишете нешто за вас.',
	'usersignup-welcome-email-edit-profile-button' => 'Оди на профилот',
	'usersignup-welcome-email-learn-basic-heading' => 'Научете ги основите.',
	'usersignup-welcome-email-learn-basic-content' => 'Погледајте ги надгледните напатствија за основите на Викија: како се уредува страница, корисничкиот профил, измена на поставките и друго.',
	'usersignup-welcome-email-learn-basic-button' => 'Погледајте го',
	'usersignup-welcome-email-explore-wiki-heading' => 'Истражете уште викија.',
	'usersignup-welcome-email-explore-wiki-content' => 'На Викија имаме илјадници викија. Пронајдете уште викија што би ве интересирале на едно од нашите собиралишта: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Видеоигри</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Забава</a> или <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Животен стил</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Оди на wikia.com',
	'usersignup-welcome-email-content' => 'Сакате повеќе информации? Совети, одговори и други учесници ќе најдете во <a style="color:#2C85D5;" href="http://community.wikia.com">Центарот на заедницата</a>. Среќно уредување!',
	'usersignup-welcome-email-signature' => 'Екипата на Викија',
	'usersignup-welcome-email-body' => 'Здраво $USERNAME,

Ви посакуваме срдечно добредојде на Викија и {{SITENAME}}! Еве како да почнете.

Уредете го вашиот профил.

На профилот на {{SITENAME}} ставете ваша слика и накратко напишете нешто за вас.

Одете на $EDITPROFILEURL

Научете ги основите.

Погледајте ги надгледните напатствија за основите на Викија: како се уредува страница, корисничкиот профил, измена на поставките и друго.

Погледајте ги на ($LEARNBASICURL)

Истражете повеќе викија.

На Викија имаме илјадници викија. Пронајдете ги оние што ве интересираат на едно од нашите собиралишта: Видеоигри (http://www.wikia.com/Video_Games), Забава (http://www.wikia.com/Entertainment) или Животен стил (http://www.wikia.com/Lifestyle).

Одете на $EXPLOREWIKISURL

Сакате повеќе информации? Совети, одговори и други учесници ќе најдете во Центарот на заедницата  (http://www.community.wikia.com). Среќно уредување!

Екипата на Викија


___________________________________________

Најновите збиднувања на Викија ќе ги најдете на http://community.wikia.com
Сакате да изберете што да добивате по е-пошта? Одете на: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Приклучете се на Викија денес',
	'usersignup-heading-byemail' => 'Направете сметка некому',
	'usersignup-marketing-wikia' => 'Почнете да соработувате со милиони луѓе од целиот свет кои заеднички го споделуваат она што го знаат и сакаат.',
	'usersignup-marketing-login' => 'Веќе сте корисник? [[Special:UserLogin|Најавете се]]',
	'usersignup-marketing-benefits' => 'Бидете дел од нешто огромно',
	'usersignup-marketing-community-heading' => 'Соработка',
	'usersignup-marketing-community' => 'Откривајте и истражувајте разни тематики: од видеоигри до филмови и ТВ. Запознајте други луѓе со слични интереси и страсти.',
	'usersignup-marketing-global-heading' => 'Создај',
	'usersignup-marketing-global' => 'Започнете ново вики. Почнете со малку, па развијте го во нешто големо со помош од другите.',
	'usersignup-marketing-creativity-heading' => 'Бидете оригинални',
	'usersignup-marketing-creativity' => 'Користете ја Викија за да ја изразите вашата креативност со анкети и списоци на 10 предводници, галерии од слики и видеа, програмчиња и многу друго.',
	'usersignup-createaccount-byemail' => 'Направете сметка некому',
	'usersignup-error-captcha' => 'Внесениот збор не одговара на оној во полето. Обидете се потворно!',
	'usersignup-account-creation-heading' => 'Успеа!',
	'usersignup-account-creation-subheading' => 'Испративме порака на $1',
	'usersignup-account-creation-email-sent' => 'Ја започнавте постапката за создавање на сметката на $2. На $1 на корисникот му испративме порака со привремена лозинка и потврдна врска.


Во потврдната порака, корисникот $2 ќе треба да стисне на врската за да ја потврди е-поштата и да ја смени неговата привремена лозинка за да го доврши создавањето на сметката.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Направете уште сметки] на {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'На Викија правиме сметка во ваше име!',
	'usersignup-account-creation-email-greeting' => 'Здраво,',
	'usersignup-account-creation-email-content' => 'На {{SITENAME}} е направена сметка во ваше име. За да дојдете до неа и да ја смените привремената лозинка, стиснете на долунаведената врска и најавете се со корисничкото име „$USERNAME“ и лозинката „$NEWPASSWORD“.

Најавете се на <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Ако не ја сакате сметката, едноставно занемарете ја поракава. Ако имате прашања, обратете се кај екипата Поддршка на заедницата.',
	'usersignup-account-creation-email-signature' => 'Екипата на Викија',
	'usersignup-account-creation-email-body' => 'Здраво,

На {{SITENAME}} е направена е сметка во ваше име. За да дојдете до сметката и да ја смените привремената лозинка, стиснете на долунаведената врска и најавете се со корисничкото име „$2“ и лозинката „$3“.

Најавете се на {{fullurl:{{ns:special}}:UserLogin}}

Ако не ја сакате сметката, едноставно занемарете ја поракава. Ако имате прашања, обратете се кај екипата Поддршка на заедницата.

Екипата на Викија


___________________________________________

Најновите збиднувања на Викија ќе ги најдете на http://community.wikia.com
Сакате да изберете што да добивате по е-пошта? Одете на: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-confirmation-reminder-email_subject' => 'Не се отуѓувајте…',
	'usersignup-confirmation-reminder-email-greeting' => 'Здраво $USERNAME',
	'usersignup-confirmation-reminder-email-content' => 'Има неколку дена како почнавте да правите сметка на Викија, но не ја довршивте. Лесно е. Едноставно стиснете на долунаведената потврдна врска:
<br/><br/>
<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>
<br/><br/>
Доколку не го потврдите во рок од 23 дена, вашето корисничко име, $USERNAME ќе биде достапно за други! Затоа, не чекајте да ви го земат!',
	'usersignup-confirmation-reminder-email-signature' => 'Екипата на Викија',
	'usersignup-confirmation-reminder-email_body' => 'Здраво $2,

Има неколку дена како почнавте да правите сметка на Викија, но не ја довршивте. Лесно е. Едноставно стиснете на долунаведената потврдна врска:

$3

Доколку не го потврдите во рок од 23 дена, вашето корисничко име ($2) ќе биде достапно за други! Затоа, не чекајте да ви го земат!

Екипата на Викија


___________________________________________

Најновите збиднувања на Викија ќе ги најдете на http://community.wikia.com
Сакате да изберете што да добивате по е-пошта? Одете на: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Се појави проблем при општењето со Facebook. Обидете се подоцна.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'usersignup-page-title' => 'Sertai Wikia',
	'usersignup-page-captcha-label' => 'Kata Kabur',
	'usersignup-error-username-length' => 'Maaf, nama pengguna anda tidak boleh melebihi {{PLURAL:$1|satu aksara|$1 aksara}}.',
	'usersignup-error-invalid-user' => 'Pengguna tidak sah. Sila log masuk terlebih dahulu.',
	'usersignup-error-invalid-email' => 'Sila berikan alamat e-mel yang sah.',
	'usersignup-error-symbols-in-username' => 'Maaf, nama pengguna anda hanya boleh mengandungi huruf dan angka.',
	'usersignup-error-empty-email' => 'Sila isikan alamat e-mel anda.',
	'usersignup-error-empty-username' => 'Sila isi ruangan nama pengguna.',
	'usersignup-error-already-confirmed' => 'Anda sudah mengesahkan alamat e-mel ini.',
	'usersignup-error-throttled-email' => 'Maaf, anda telah memohon terlalu banyak e-mel pengesahan untuk dihantar kepada anda hari ini. Sila cuba lagi selepas seketika.',
	'usersignup-error-too-many-changes' => 'Anda telah mencapai had maksimum untuk perubahan e-mel hari ini. Sila cuba lagi kemudian.',
	'usersignup-error-password-length' => 'Maaf, kata laluan anda terlalu panjang. Sila pilih kata laluan yang tidak lebih daripada 50 aksara.',
	'usersignup-error-confirmed-user' => 'Nampaknya anda sudah mengesahkan alamat e-mel anda untuk $1! Sila semak [$2 profil pengguna] anda.',
	'usersignup-facebook-heading' => 'Selesaikan Pendaftaran',
	'usersignup-facebook-create-account' => 'Buka akaun',
	'usersignup-facebook-email-tooltip' => 'Jika anda ingin menggunakan alamat e-mel yang berbeza, anda boleh menukarnya pada bila-bila masa dalam Keutamaan anda.',
	'usersignup-facebook-have-an-account-heading' => 'Sudah ada akaun?',
	'usersignup-facebook-have-an-account' => 'Sambungkan nama pengguna Wikia anda yang sedia ada dengan Facebook pula.',
	'usersignup-facebook-proxy-email' => 'E-mel Facebook awanama',
	'usersignup-user-pref-emailconfirmlink' => 'Pohon e-mel pengesahan yang baru',
	'usersignup-user-pref-confirmemail_send' => 'Hantar semula e-mel pengesahan',
	'usersignup-user-pref-emailauthenticated' => 'Terima kasih! E-mel anda telah disahkan pada $2, $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Semak e-mel anda dan klik pautan pengesahan untuk menyiapkan penukaran e-mel anda kepada: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Maaf! E-mel anda belum disahkan. Ciri-ciri e-mel tidak akan berfungsi selagi anda tidak mengesahkan alamat e-mel anda.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Hampir siap! Kami telah menghantar e-mel pengesahan baru ke $1. Semak e-mel anda dan klik pautannya untuk menyiapkan pengesahan alamat e-mel anda.',
	'usersignup-user-pref-noemailprefs' => 'Nampaknya kami tidak tahu alamat e-mel anda. Sila taipkan alamat e-mel di atas.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Maaf! E-mel anda belum disahkan. Kami telah menghantar e-mel kepada anda; klik pautan pengesahan di dalamnya untuk membuat pengesahan.',
	'usersignup-user-pref-confirmemail_noemail' => 'Nampaknya kami tidak tahu alamat e-mel anda. Pergi ke [[Special:Preferences|keutamaan pengguna]] untuk menyatakan alamat e-mel anda.',
	'usersignup-confirm-page-title' => 'Sahkan alamat e-mel anda',
	'usersignup-confirm-email-resend-email' => 'Hantarkan saya satu lagi e-mel pengesahan',
	'usersignup-confirm-email-change-email-content' => 'Saya hendak menggunakan alamat e-mel yang lain.',
	'usersignup-confirm-email-change-email' => 'Tukar alamat e-mel saya',
	'usersignup-confirm-email-new-email-label' => 'E-mel baru',
	'usersignup-confirm-email-update' => 'Kemas kini',
	'usersignup-confirm-email-tooltip' => 'Adakah anda memberikan alamat e-mel yang tidak boleh anda sahkan, ataupun adakah anda mahu menggunakan alamat e-mel yang lain? Jangan risau, gunakan pautan berikut untuk menukar alamat e-mel anda dan menerima e-mel pengesahan yang baru.',
	'usersignup-resend-email-heading-success' => 'E-mel baru dihantar',
	'usersignup-resend-email-heading-failure' => 'E-mel baru tidak dihantar',
	'usersignup-confirm-page-heading-confirmed-user' => 'Syabas!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Anda telah pun disahkan',
	'usersignup-confirmation-heading' => 'Hampir siap',
	'usersignup-confirmation-heading-email-resent' => 'E-mel baru dihantar',
	'usersignup-confirmation-subheading' => 'Semak e-mel anda',
	'usersignup-confirmation-email-sent' => "Kami telah menghantar e-mel kepada '''$1'''.

Klik pautan pengesahan dalam e-mel anda untuk menyiapkan pembukaan akaun anda.",
	'usersignup-confirmation-email_subject' => 'Hampir siap! Sahkan akaun Wikia anda',
	'usersignup-confirmation-email-greeting' => '$USERNAME,',
	'usersignup-confirmation-email-content' => 'Hanya tinggal selangkah lagi untuk anda membuka akaun di Wikia! Klik pautan di bawah untuk mengesahkan alamat e-mel anda dan mulakan.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'Pasukan Wikia',
	'usersignup-confirmation-email_body' => '$2,

Hanya tinggal selangkah lagi untuk anda membuka akaun di Wikia! Klik pautan di bawah untuk mengesahkan alamat e-mel anda dan mulakan.

$3

Pasukan Wikia


___________________________________________

Untuk mengikuti perkembangan terkini di Wikia, layari http://community.wikia.com
Ingin mengawal e-mel yang anda terima? Pergi ke: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-reconfirmation-email-sent' => 'Alamat e-mel anda telah ditukar kepada $1. Kami telah menghantar e-mel pengesahan yang baru kepada anda. Sila sahkan alamat e-mel baru ini.',
	'usersignup-reconfirmation-email_subject' => 'Sahkan penukaran alamat e-mel anda di Wikia',
	'usersignup-reconfirmation-email-greeting' => '$USERNAME,',
	'usersignup-reconfirmation-email-content' => 'Sila klik pautan berikut untuk mengesahkan penukaran alamat e-mel anda di Wikia.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Anda akan masih menerima e-mel di alamat e-mel lama anda sehingga anda mengesahkan yang ini.',
	'usersignup-reconfirmation-email-signature' => 'Pasukan Wikia',
	'usersignup-reconfirmation-email_body' => '$2,

Sila klik pautan berikut untuk mengesahkan penukaran alamat e-mel anda di Wikia.

$3

Anda akan masih menerima e-mel di alamat e-mel lama anda sehingga anda mengesahkan yang ini.

Pasukan Wikia


___________________________________________

Untuk mengikuti perkembangan terkini di Wikia, layari http://community.wikia.com
Ingin mengawal e-mel yang anda terima? Pergi ke: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-welcome-email-subject' => 'Selamat datang ke Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => '$USERNAME,',
	'usersignup-welcome-email-heading' => 'Dengan sukacitanya kami menyambut kedatangan anda ke Wikia dan {{SITENAME}}! Berikut ialah beberapa perkara yang boleh anda lakukan sebagai permulaan.',
	'usersignup-welcome-email-edit-profile-heading' => 'Sunting profil anda.',
	'usersignup-welcome-email-edit-profile-content' => 'Letakkan gambar profil dan ceritakan serba sedikit tentang anda pada profil anda di {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Pergi ke profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Pelajari asas-asas Wikia.',
	'usersignup-welcome-email-learn-basic-content' => 'Ikuti tutorial segera untuk mempelajari asas-asas Wikia: bagaimana untuk menyunting halaman, profil pengguna anda, tukar keutamaan anda, dsb.',
	'usersignup-welcome-email-learn-basic-button' => 'Jom!',
	'usersignup-welcome-email-explore-wiki-heading' => 'Terokai wiki-wiki lain.',
	'usersignup-welcome-email-explore-wiki-content' => 'Di Wikia terdapat beribu-ribu wiki, carilah wiki-wiki lain yang menarik minat anda dengan menuju ke salah satu hab kami: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Permainan Video</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Hiburan</a>, atau <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Gaya Hidup</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Pergi ke wikia.com',
	'usersignup-welcome-email-content' => 'Inginkan maklumat lanjut? Temui nasihat, jawapan, dan komuniti Wikia di <a style="color:#2C85D5;" href="http://community.wikia.com">Community Central</a>. Selamat menyunting!',
	'usersignup-welcome-email-signature' => 'Pasukan Wikia',
	'usersignup-welcome-email-body' => '$USERNAME,

Dengan sukacitanya kami menyambut kedatangan anda ke Wikia dan {{SITENAME}}! Berikut ialah beberapa perkara yang boleh anda lakukan sebagai permulaan.

Sunting profil anda.

Letakkan gambar profil dan ceritakan serba sedikit tentang anda pada profil anda di {{SITENAME}}.

Pergi $EDITPROFILEURL

Pelajari asas-asas Wikia.

Ikuti tutorial segera untuk mempelajari asas-asas Wikia: bagaimana untuk menyunting halaman, profil pengguna anda, tukar keutamaan anda, dsb.

Jom! ($LEARNBASICURL)

Explore more wikis.

Di Wikia terdapat beribu-ribu wiki, carilah wiki-wiki lain yang menarik minat anda dengan menuju ke salah satu hab kami: Permainan Video (http://www.wikia.com/Video_Games), Hiburan (http://www.wikia.com/Entertainment), atau Gaya Hidup (http://www.wikia.com/Lifestyle).

Pergi ke $EXPLOREWIKISURL

Inginkan maklumat lanjut? Temui nasihat, jawapan, dan komuniti Wikia di Community Central (http://www.community.wikia.com). Selamat menyunting!

Pasukan Wikia


___________________________________________

Untuk mengikuti perkembangan terkini di Wikia, layari http://community.wikia.com
Ingin mengawal e-mel yang anda terima? Pergi ke: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Sertai Wikia Sekarang',
	'usersignup-heading-byemail' => 'Buka akaun untuk rakan anda',
	'usersignup-marketing-wikia' => 'Mari bekerjasama dengan jutaan orang dari seluruh dunia yang bersatu-padu untuk berkongsi minat mereka.',
	'usersignup-marketing-login' => 'Sudah mendaftar? [[Special:UserLogin|Log masuk]]',
	'usersignup-marketing-benefits' => 'Sertailah kami',
	'usersignup-marketing-community-heading' => 'Bekerjasama',
	'usersignup-marketing-community' => 'Temui dan terokai bermacam-macam maklumat menarik, baik permainan video, filem mahupun TV. Berkenalan dengan ramai orang yang sama minatnya dengan anda.',
	'usersignup-marketing-global-heading' => 'Cipta',
	'usersignup-marketing-global' => 'Tubuhkan sebuah wiki. Sedikit demi sedikit, lama-kelamaan jadi bukit, ihsan daripada bantuan orang ramai.',
	'usersignup-marketing-creativity-heading' => 'Tonjolkan diri',
	'usersignup-marketing-creativity' => 'Manfaatkan Wikia untuk meluahkan daya kreatif anda dengan carta undian dan senarai 10 teratas, galeri gambar dan video, aplikasi dan banyak lagi.',
	'usersignup-createaccount-byemail' => 'Buka akaun untuk rakan anda',
	'usersignup-error-captcha' => 'Perkataan yang anda taipkan tidak sepadan dengan perkataan dalam petak. Sila cuba lagi!',
	'usersignup-account-creation-heading' => 'Berjaya!',
	'usersignup-account-creation-subheading' => 'Kami telah menghantar e-mel kepada $1',
	'usersignup-account-creation-email-sent' => 'Anda telah memulakan proses pembukaan akaun untuk $2. Kami telah menghantar e-mel kepadanya di $1 dengan kata laluan sementara serta pautan pengesahan.


$2 akan dikehendaki mengklik pautan dalam e-mel yang kami hantar itu untuk mengesahkan akaun mereka serta menukar kata laluan sementara mereka untuk menyiapkan pembukaan akaun mereka.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Buka lagi akaun] di {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Akaun telah dibuka untuk anda di Wikia!',
	'usersignup-account-creation-email-greeting' => 'Selamat sejahtera,',
	'usersignup-account-creation-email-content' => 'Satu akaun telah dibuka khas untuk anda di {{SITENAME}}. Untuk mengakses akaun anda dan menukar kata laluan sementara anda, sila klik pautan di bawah dan log masuk dengan nama pengguna "$USERNAME" dan kata laluan "$NEWPASSWORD".

Sila log masuk di <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Jika anda tidak mengingini pembukaan akaun ini, anda boleh mengabaikan e-mel ini begitu sahaja atau menghubungi pasukan Bantuan Komuniti kami jika ada sebarang pertanyaan.',
	'usersignup-account-creation-email-signature' => 'Pasukan Wikia',
	'usersignup-account-creation-email-body' => 'Selamat sejahtera,

Satu akaun telah dibuka khas untuk anda di {{SITENAME}}. Untuk mengakses akaun anda dan menukar kata laluan sementara anda, sila klik pautan di bawah dan log masuk dengan nama pengguna "$2" dan kata laluan "$3".

Sila log masuk di {{fullurl:{{ns:special}}:UserLogin}}

Jika anda tidak mengingini pembukaan akaun ini, anda boleh mengabaikan e-mel ini begitu sahaja atau menghubungi pasukan Bantuan Komuniti kami jika ada sebarang pertanyaan.

Pasukan Wikia


___________________________________________

Untuk mengikuti perkembangan terkini di Wikia, layari http://community.wikia.com
Ingin mengawal e-mel yang anda terima? Pergi ke: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-confirmation-reminder-email_subject' => 'Janganlah menyepi…',
	'usersignup-confirmation-reminder-email-greeting' => '$USERNAME,',
	'usersignup-confirmation-reminder-email-content' => '!Sudah beberapa hari berlalu, tetapi nampaknya anda belum menghabiskan pembukaan akaun anda di Wikia. Senang sahaja. Anda cuma perlu klik pautan pengesahan yang berikut:
<br /><br />
<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>
<br /><br />
Jika anda tidak membuat pengesahan dalam 23 hari, maka nama pengguna anda, $USERNAME, akan dibuka kepada orang lain semula, jadi jangan tunggu lagi!',
	'usersignup-confirmation-reminder-email-signature' => 'Pasukan Wikia',
	'usersignup-confirmation-reminder-email_body' => '$2,

Sudah beberapa hari berlalu, tetapi nampaknya anda belum menghabiskan pembukaan akaun anda di Wikia. Senang sahaja. Anda cuma perlu klik pautan pengesahan yang berikut:

$3

Jika anda tidak membuat pengesahan dalam 23 hari, maka nama pengguna anda, $USERNAME, akan dibuka kepada orang lain semula, jadi jangan tunggu lagi!

Pasukan Wikia


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Timbulnya masalah ketika berhubung dengan Facebook. Sila cuba lagi nanti.',
);

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'usersignup-welcome-email-explore-wiki-button' => 'Gå til wikia.com',
	'usersignup-marketing-creativity-heading' => 'Vær original',
	'usersignup-account-creation-email-greeting' => 'Hallo,',
	'usersignup-account-creation-email-signature' => 'Wikia-teamet',
	'usersignup-confirmation-reminder-email-signature' => 'Wikia-teamet',
);

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author Siebrand
 */
$messages['nl'] = array(
	'usersignup-page-captcha-label' => 'Wazig woord',
	'usersignup-error-username-length' => 'Uw gebruikersnaam mag niet meer dan {{PLURAL:$1|één teken|$1 tekens}} lang zijn.',
	'usersignup-error-empty-username' => 'Oeps, vul het gebruikersnaam veld in.',
	'usersignup-facebook-create-account' => 'Gebruiker aanmaken',
	'usersignup-facebook-have-an-account-heading' => 'Heeft u al een account?',
	'usersignup-facebook-proxy-email' => 'Anonieme Facebook e-mail',
	'usersignup-user-pref-emailauthenticated' => 'Bedankt! Uw e-mailadres werd bevestigd op $2 om $3.',
	'usersignup-user-pref-noemailprefs' => 'Het lijkt erop dat we geen e-mailadres van u hebben. Voer hierboven een e-mailadres in.',
	'usersignup-confirm-page-title' => 'Uw e-mailadres bevestigen',
	'usersignup-confirm-email-new-email-label' => 'Nieuwe e-mail',
	'usersignup-confirm-email-update' => 'Aanpassen',
	'usersignup-resend-email-heading-success' => 'Nieuwe e-mail verzonden',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gefeliciteerd!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'U bent reeds bevestigd',
	'usersignup-confirmation-heading-email-resent' => 'Nieuwe e-mail verzonden',
	'usersignup-confirmation-subheading' => 'Controleer uw e-mail',
	'usersignup-confirmation-email-greeting' => 'Hallo $USERNAME,',
	'usersignup-confirmation-email-signature' => 'Het Wikia-team',
	'usersignup-reconfirmation-email_subject' => 'Bevestig uw e-mailadres verandering op Wikia',
	'usersignup-reconfirmation-email-greeting' => 'Hallo $USERNAME,',
	'usersignup-reconfirmation-email-signature' => 'Het Wikia-team',
	'usersignup-welcome-email-subject' => 'Welkom bij Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hallo $USERNAME,',
	'usersignup-welcome-email-edit-profile-heading' => 'Uw profiel bewerken.',
	'usersignup-welcome-email-edit-profile-button' => 'Ga naar profiel',
	'usersignup-welcome-email-learn-basic-heading' => 'Leer de basis.',
	'usersignup-welcome-email-learn-basic-button' => 'Ga kijken!',
	'usersignup-welcome-email-explore-wiki-heading' => "Verken meer wiki's.",
	'usersignup-welcome-email-explore-wiki-button' => 'Ga naar wikia.com',
	'usersignup-welcome-email-signature' => 'Het Wikia-team',
	'usersignup-account-creation-heading' => 'Succes!',
	'usersignup-account-creation-email-greeting' => 'Hallo,',
	'usersignup-account-creation-email-signature' => 'Het Wikia-team',
	'usersignup-confirmation-reminder-email_subject' => 'Wees geen vreemdeling...',
	'usersignup-confirmation-reminder-email-greeting' => 'Hallo $USERNAME',
);

/** Polish (polski)
 * @author Sovq
 */
$messages['pl'] = array(
	'usersignup-page-title' => 'Dołącz do Wikii',
	'usersignup-page-captcha-label' => 'Zamazany tekst',
	'usersignup-error-username-length' => 'Twoja nazwa użytkownika nie może mieć więcej niż {{PLURAL:$1|jeden znak|$1 znaki|$1 znaków}}.',
	'usersignup-error-invalid-user' => 'Niewłaściwy użytkownik. Zaloguj się.',
	'usersignup-error-invalid-email' => 'Wprowadź prawidłowy adres e-mail.',
	'usersignup-error-symbols-in-username' => 'Twoja nazwa użytkownika może zawierać jedynie litery i cyfry.',
	'usersignup-error-empty-email' => 'Wprowadź adres e-mail.',
	'usersignup-error-empty-username' => 'Wypełnij pole nazwy użytkownika.',
	'usersignup-error-already-confirmed' => 'Już potwierdzono ten adres e-mail.',
	'usersignup-error-throttled-email' => 'Zażądano dzisiaj zbyt wielu wiadomości potwierdzających e-mail. Spróbuj ponownie później.',
	'usersignup-error-too-many-changes' => 'Osiągnięto limit żądań zmiany e-maila. Spróbuj później.',
	'usersignup-error-password-length' => 'Twoje hasło jest zbyt długie. Wybierz hasło, które ma mniej niż 51 znaków.',
	'usersignup-error-confirmed-user' => 'Wygląda na to, że już potwierdzono adres e-mail $1. Sprawdź swój [$2 profil użytkownika].',
	'usersignup-facebook-heading' => 'Zakończ rejestrację',
	'usersignup-facebook-create-account' => 'Utwórz konto',
	'usersignup-facebook-email-tooltip' => 'Jeśli chcesz zmienić swój adres e-mail, możesz to zrobić później w swoich preferencjach.',
	'usersignup-facebook-have-an-account-heading' => 'Masz już konto?',
	'usersignup-facebook-have-an-account' => 'Połącz swoje istniejące konto na Wikii z Facebookiem.',
	'usersignup-facebook-proxy-email' => 'Anonimowy e-mail z Facebooka.',
	'usersignup-user-pref-emailconfirmlink' => 'Zażądaj nowego e-maila potwierdzającego adres.',
	'usersignup-user-pref-confirmemail_send' => 'Ponownie wyślij e-mail potwierdzający adres',
	'usersignup-user-pref-emailauthenticated' => 'Dziękujemy! Twój e-mail został potwierdzony w dniu $2 o $3 .',
	'usersignup-user-pref-emailnotauthenticated' => 'Sprawdź swoją skrzynkę e-mailową i kliknij na link potwierdzający aby zakończyć zmianę adresu e-mail na: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Twój adres e-mail nie jest potwierdzony. Funkcję związane z e-mailem nie będą działać do czasu potwierdzenia.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Wysłano nowy e-mail potwierdzający na adres $1. Sprawdź swoją skrzynkę e-mailową i kliknij na link aby zakończyć potwierdzanie adresu e-mail.',
	'usersignup-user-pref-noemailprefs' => 'Wygląda na to, że nie podano adresu e-mail. Proszę wprowadź go w polu powyżej.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Twój adres e-mail nie został potwierdzony. Wysłaliśmy Ci wiadomość, kliknij na link w niej aby potwierdzić e-mail.',
	'usersignup-user-pref-confirmemail_noemail' => 'Wygląda na to, że nie podano adresu e-mail. Przejdź do [[Special:Preferences|preferencji]] aby go wprowadzić.',
	'usersignup-confirm-page-title' => 'Potwierdzić adres e-mail',
	'usersignup-confirm-email-resend-email' => 'Wyślij kolejną wiadomość potwierdzającą adres e-mail.',
	'usersignup-confirm-email-change-email-content' => 'Chcę używać innego adresu e-mail.',
	'usersignup-confirm-email-change-email' => 'Zmień mój adres e‐mail',
	'usersignup-confirm-email-new-email-label' => 'Nowy adres e-mail',
	'usersignup-confirm-email-update' => 'Aktualizuj',
	'usersignup-confirm-email-tooltip' => 'Wprowadziłeś adres e-mail, którego nie jesteś w stanie potwierdzić lub po prostu chcesz zmienić adres na nowy? Nie ma problemu, użyj poniższego linku aby zmienić swój adres i otrzymać nowy kod potwierdzający.',
	'usersignup-resend-email-heading-success' => 'Wysłano nową wiadomość',
	'usersignup-resend-email-heading-failure' => 'Nie wysłano nowej wiadomości',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gratulacje!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Twój adres e-mail już został potwierdzony.',
	'usersignup-confirmation-heading' => 'Prawie ukończono',
	'usersignup-confirmation-heading-email-resent' => 'Wysłano nową wiadomość',
	'usersignup-confirmation-subheading' => 'Sprawdź swoją skrzynkę e-mailową',
	'usersignup-confirmation-email-sent' => "Wysłano wiadomość na adres '''$1'''.

Kliknij na link potwierdzający w niej aby ukończyć tworzenie konta.",
	'usersignup-confirmation-email_subject' => 'Potwierdź swoje konto na Wikii',
	'usersignup-confirmation-email-greeting' => 'Witaj $USERNAME,',
	'usersignup-confirmation-email-content' => 'Jesteś o krok od utworzenia konta na Wikii! Kliknij poniższy link aby potwierdzić swój adres e-mail i rozpocząć edytowanie!

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'Zespół Wikii',
	'usersignup-confirmation-email_body' => 'Witaj $2,

Jesteś o krok od utworzenia konta na Wikii! Kliknij poniższy link aby potwierdzić swój adres e-mail i rozpocząć edytowanie!

$3

Zespół Wikii


___________________________________________

Aby zapoznać się z nowościami, odwiedź http://spolecznosc.wikia.com
Chcesz zmienić ustawienia otrzymywanych powiadomień? Zajrzyj tutaj: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-reconfirmation-email-sent' => 'Twój adres e-mail został zmieniony na $1. Wysłaliśmy nową wiadomość z potwierdzeniem. Prosimy o potwierdzenie nowego adresu.',
	'usersignup-reconfirmation-email_subject' => 'Potwierdź zmianę adresu e-mail na Wikii',
	'usersignup-reconfirmation-email-greeting' => 'Witaj $USERNAME,',
	'usersignup-reconfirmation-email-content' => 'Kliknij na poniższy link aby potwierdzić zmianę adresu e-mail na Wikii.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Do czasu potwierdzenia nowego adresu, wszystkie powiadomienia będą przychodzić na stary adres.',
	'usersignup-reconfirmation-email-signature' => 'Zespół Wikii',
	'usersignup-reconfirmation-email_body' => 'Witaj $2,

Kliknij na poniższy link aby potwierdzić zmianę adresu e-mail na Wikii.

$3

Do czasu potwierdzenia nowego adresu, wszystkie powiadomienia będą przychodzić na stary adres.

Zespół Wikii


___________________________________________

Aby zapoznać się z nowościami, odwiedź http://spolecznosc.wikia.com
Chcesz zmienić ustawienia otrzymywanych powiadomień? Zajrzyj tutaj: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-welcome-email-subject' => 'Witaj na Wikii, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Witaj $USERNAME',
	'usersignup-welcome-email-heading' => 'Jesteśmy szczęśliwi mogąc przywitać Cię na Wikii i na {{SITENAME}}! Oto kilka spraw na dobry początek.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edytuj swój profil.',
	'usersignup-welcome-email-edit-profile-content' => 'Dodaj obraz i kilka informacji o sobie na swoim profilu na {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Przejdź do profilu',
	'usersignup-welcome-email-learn-basic-heading' => 'Zapoznaj się z podstawami.',
	'usersignup-welcome-email-learn-basic-content' => 'Zapoznaj się z podstawami edytowania na Wikii: jak edytować strony, własny profil, zmienić swoje ustawienia i więcej.',
	'usersignup-welcome-email-learn-basic-button' => 'Sprawdź!',
	'usersignup-welcome-email-explore-wiki-heading' => 'Odwiedź inne wiki.',
	'usersignup-welcome-email-explore-wiki-content' => 'Na Wikii istnieje tysiące wiki, dowiedz się o nich więcej, odwiedzając jeden z portali: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Gry</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Rozrywka</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Lifestyle</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Odwiedź wikia.com',
	'usersignup-welcome-email-content' => 'Szukasz więcej informacji? Znajdziesz odpowiedzi, porady i społeczność Wikii na <a style="color:#2C85D5;" href="http://spolecznosc.wikia.com">Wiki Społeczności</a>. Przyjemnego edytowania!',
	'usersignup-welcome-email-signature' => 'Zespół Wikii',
	'usersignup-welcome-email-body' => 'Witaj $USERNAME,

Jesteśmy szczęśliwi mogąc przywitać Cię na Wikii i na {{SITENAME}}! Oto kilka spraw na dobry początek.

Edytuj swój profil.

Dodaj obraz i kilka informacji o sobie na swoim profilu na {{SITENAME}}.

Przejdź do $EDITPROFILEURL

Zapoznaj się z podstawami.

Zapoznaj się z podstawami edytowania na Wikii: jak edytować strony, własny profil, zmienić swoje ustawienia i więcej.

Sprawdź $LEARNBASICURL

Odwiedź inne wiki.

Na Wikii istnieje tysiące wiki, dowiedz się o nich więcej, odwiedzając jeden z portali: Gry (http://www.wikia.com/Video_Games), Rozrywka (http://www.wikia.com/Entertainment), i Lifestyle (http://www.wikia.com/Lifestyle).

Odwiedź $EXPLOREWIKISURL

Szukasz więcej informacji? Znajdziesz odpowiedzi, porady i społeczność Wikii na Wiki Społeczności (http://spolecznosc.wikia.com). Przyjemnego edytowania!

Zespół Wikii


___________________________________________

Aby zapoznać się z nowościami, odwiedź http://spolecznosc.wikia.com
Chcesz zmienić ustawienia otrzymywanych powiadomień? Zajrzyj tutaj: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Dołącz do Wikii',
	'usersignup-heading-byemail' => 'Utwórz konto dla kogoś innego',
	'usersignup-marketing-wikia' => 'Zacznij współpracę z milionami ludzi na całym świecie, którzy spotykają się aby dzielić się wiedzą o tym, co kochają.',
	'usersignup-marketing-login' => 'Już jesteś użytkownikiem? [[Special:UserLogin|Zaloguj się]]',
	'usersignup-marketing-benefits' => 'Stań się częścią czegoś wielkiego',
	'usersignup-marketing-community-heading' => 'Współpracuj',
	'usersignup-marketing-community' => 'Odkrywaj i zgłębiaj tematy od gier komputerowych do telewizji i filmu. Poznawaj ludzi o podobnych zainteresowaniach i pasjach.',
	'usersignup-marketing-global-heading' => 'Twórz',
	'usersignup-marketing-global' => 'Utwórz wiki. Zacznij od podstaw i zbuduj coś wielkiego, z pomocą innych.',
	'usersignup-marketing-creativity-heading' => 'Bądź oryginalny',
	'usersignup-marketing-creativity' => 'Użyj Wikii aby wyrazić swoją kreatywność w ankietach, rankingach, galeriach obrazów i filmów, aplikacji i więcej.',
	'usersignup-createaccount-byemail' => 'Utwórz konto dla kogoś innego',
	'usersignup-error-captcha' => 'Wprowadzone słowo nie zgadza się ze słowem z obrazka, spróbuj ponownie!',
	'usersignup-account-creation-heading' => 'Gotowe!',
	'usersignup-account-creation-subheading' => 'Wysłano e-mail do $1',
	'usersignup-account-creation-email-sent' => 'Rozpoczęto proces tworzenia konta dla użytkownika $2. Wysłano wiadomość na adres $1 z tymczasowym hasłem i linkiem potwierdzającym.

$2 będzie musiał(a) kliknąć na ten link aby potwierdzić adres i zmienić tymczasowe hasło w celu  ukończenia tworzenie konta.

[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Utwórz więcej kont] na {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Konto na Wikii zostało utworzone dla Ciebie',
	'usersignup-account-creation-email-greeting' => 'Witaj,',
	'usersignup-account-creation-email-content' => 'Na {{SITENAME}} zostało dla Ciebie utworzone konto. Aby uzyskać do niego dostęp i zmienić tymczasowe hasło, użyj poniższego linku i zaloguj się korzystając z nazwy użytkownika "$USERNAME" i hasła "$NEWPASSWORD".

Zaloguj się korzystając z <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Jeśli nie chcesz aby to konto zostało utworzone, zignoruj tę wiadomość albo skontaktuj się z nami jeśli masz pytania.',
	'usersignup-account-creation-email-signature' => 'Zespół Wikii',
	'usersignup-account-creation-email-body' => 'Witaj,

Na {{SITENAME}} zostało dla Ciebie utworzone konto. Aby uzyskać do niego dostęp i zmienić tymczasowe hasło, użyj poniższego linku i zaloguj się korzystając z nazwy użytkownika "$2" i hasła "$3".

Zaloguj się korzystając z {{fullurl:{{ns:special}}:UserLogin}}

Jeśli nie chcesz aby to konto zostało utworzone, zignoruj tę wiadomość albo skontaktuj się z nami jeśli masz pytania.

Zespół Wikii


___________________________________________

Aby zapoznać się z nowościami, odwiedź http://spolecznosc.wikia.com
Chcesz zmienić ustawienia otrzymywanych powiadomień? Zajrzyj tutaj: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-confirmation-reminder-email_subject' => 'Nie bądź anonimowy…',
	'usersignup-confirmation-reminder-email-greeting' => 'Witaj $USERNAME',
	'usersignup-confirmation-reminder-email-content' => 'Minęło kilka dni, jednak tworzenie Twojego konta na Wikii nie zostało ukończone. To proste. Kliknij poniższy link potwierdzający:

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Jeśli w ciągu 23 dni nie potwierdzisz swojego konta, nazwa $USERNAME ponownie stanie się dostępna, więc nie zwlekaj!',
	'usersignup-confirmation-reminder-email-signature' => 'Zespół Wikii',
	'usersignup-confirmation-reminder-email_body' => 'Witaj $2,

Minęło kilka dni, jednak tworzenie Twojego konta na Wikii nie zostało ukończone. To proste. Kliknij poniższy link potwierdzający:

$3

Jeśli w ciągu 23 dni nie potwierdzisz swojego konta, nazwa $USERNAME ponownie stanie się dostępna, więc nie zwlekaj!

Zespół Wikii


___________________________________________

Aby zapoznać się z nowościami, odwiedź http://spolecznosc.wikia.com
Chcesz zmienić ustawienia otrzymywanych powiadomień? Zajrzyj tutaj: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Wystąpił problem podczas łączenia z Facebookiem. Spróbuj póżniej.',
);

/** Russian (русский)
 * @author Kuzura
 */
$messages['ru'] = array(
	'usersignup-page-title' => 'Присоединиться к Викия',
	'usersignup-error-username-length' => 'К сожалению, имя участника не может быть больше {{PLURAL:$1|одного символа|$1 символов}}.',
	'usersignup-error-invalid-user' => 'Недопустимое имя. Пожалуйста войдите снова.',
	'usersignup-error-invalid-email' => 'Пожалуйста, введите действительный адрес электронной почты.',
	'usersignup-error-symbols-in-username' => 'Имя участника может содержать только буквы и цифры.',
	'usersignup-error-empty-email' => 'Пожалуйста, добавьте ваш адрес электронной почты.',
	'usersignup-error-empty-username' => 'Пожалуйста, заполните строку имя участника.',
	'usersignup-error-already-confirmed' => 'Вы уже подтвердили этот адрес электронной почты.',
	'usersignup-error-throttled-email' => 'Слишком много писем с подтверждением было отправлено вам сегодня. Повторите попытку через некоторое время.',
	'usersignup-error-too-many-changes' => 'Вы достигли максимума для изменения электронной почты сегодня. Пожалуйста, повторите попытку позже.',
	'usersignup-error-password-length' => 'К сожалению ваш пароль слишком длинный. Пожалуйста, выберите пароль, который содержит меньше 50 символов.',
	'usersignup-error-confirmed-user' => 'Выглядит так, как вы уже подтвердили свой адрес электронной почты для $1! Проверьте ваш [$2 профиль участника].',
	'usersignup-facebook-heading' => 'Окончание регистрации',
	'usersignup-facebook-create-account' => 'Создать учётную запись',
	'usersignup-facebook-email-tooltip' => 'Если вы хотите использовать другой адрес электронной почты, вы можете изменить его позже в настройках.',
	'usersignup-facebook-have-an-account-heading' => 'Уже есть учётная запись?',
	'usersignup-facebook-have-an-account' => 'Подключите существующее имя участника Викия к Facebook.',
	'usersignup-facebook-proxy-email' => 'Анонимная электронная почта Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Запросить новое письмо с подтверждением email',
	'usersignup-user-pref-confirmemail_send' => 'Отправить мне подтверждение email',
	'usersignup-user-pref-emailauthenticated' => 'Спасибо! Ваш адрес электронной почты был подтверждён $2 в $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Проверьте адрес электронной почты и нажмите на ссылку для подтверждения изменения вашего адреса электронной почты на $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Адрес вашей электронной почты не подтверждён. Функции электронной почты не будут работать до тех пор, пока вы не подтвердите свой адрес электронной почты.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Мы направили вам новое письмо с подтверждением $1. Проверьте адрес электронной почты и нажмите на ссылку, чтобы подтвердить ваш адрес электронной почты.',
	'usersignup-user-pref-noemailprefs' => 'Похоже, у нас нет адреса вашей электронной почты. Пожалуйста, введите адрес вашей электронной почты выше.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Адрес вашей электронной почты не подтверждён. Мы отправили вам письмо, в котором вам надо нажать на ссылку, чтобы подтвердить свой email.',
	'usersignup-user-pref-confirmemail_noemail' => 'Похоже, у нас нет адреса вашей электронной почты. Перейдите в [[Special:Preferences|личные настройки]], чтобы добавить его.',
	'usersignup-confirm-page-title' => 'Подтвердите адрес своей электронной почты',
	'usersignup-confirm-email-resend-email' => 'Пришлите мне ещё одно подтверждение email',
	'usersignup-confirm-email-change-email-content' => 'Я хочу использовать другой адрес электронной почты.',
	'usersignup-confirm-email-change-email' => 'Изменить адрес электронной почты',
	'usersignup-confirm-email-new-email-label' => 'Новый email',
	'usersignup-confirm-email-update' => 'Обновить',
	'usersignup-confirm-email-tooltip' => 'Вы вводите адрес электронной почты, который вы не сможете подтвердить, или потом вы захотите использовать другой адрес электронной почты? Не волнуйтесь, используйте следующую ссылку, чтобы изменить адрес электронной почты и получить новое письмо с подтверждением.',
	'usersignup-resend-email-heading-success' => 'Новое письмо отправлено',
	'usersignup-resend-email-heading-failure' => 'Повторное письмо не отправлено',
	'usersignup-confirm-page-heading-confirmed-user' => 'Поздравляем!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Вы уже подтвердили',
	'usersignup-confirmation-heading' => 'Почти готово',
	'usersignup-confirmation-heading-email-resent' => 'Новое письмо отправлено',
	'usersignup-confirmation-subheading' => 'Проверьте свою электронную почту',
	'usersignup-confirmation-email-sent' => "Мы направили письмо на адрес '''$1'''.

Нажмите на ссылку подтверждения в письме, чтобы завершить создание учётной записи.",
	'usersignup-confirmation-email_subject' => 'Почти готово! Подтвердите вашу учётную запись Викия',
	'usersignup-confirmation-email-greeting' => 'Привет, $USERNAME',
	'usersignup-confirmation-email-content' => 'Ты в одном шаге от создания учётной записи на Викия! Нажми на ссылку ниже, чтобы подтвердить свой адрес электронной почты и начать.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'Команда Викия',
	'usersignup-confirmation-email_body' => 'Привет, $2

Ты в одном шаге от создания учётной записи на Викия! Нажми на ссылку ниже, чтобы подтвердить свой адрес электронной почты и начать.

$3

Команда Викия


___________________________________________

Чтобы проверить последние события на Викия, посетите http://community.wikia.com
Хотите настроить email рассылку? Перейдите к {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-reconfirmation-email-sent' => 'Адрес вашей электронной почты был изменён на $1. Мы отправили вам новое подтверждение email. Пожалуйста, подтвердите новый адрес электронной почты.',
	'usersignup-reconfirmation-email_subject' => 'Подтвердить изменение адреса электронной почты на Викия',
	'usersignup-reconfirmation-email-greeting' => 'Привет, $USERNAME',
	'usersignup-reconfirmation-email-content' => 'Пожалуйста, нажмите на ссылку ниже для подтверждения изменения адреса электронной почты на Викия.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Вы будете продолжать получать почту на ваш старый адрес электронной почты, пока не подтвердите новый адрес.',
	'usersignup-reconfirmation-email-signature' => 'Команда Викия',
	'usersignup-reconfirmation-email_body' => 'Привет, $2

Пожалуйста, нажмите на ссылку ниже для подтверждения изменения адреса электронной почты на Викия.

$3

Вы будете продолжать получать почту на ваш старый адрес электронной почты, пока не подтвердите новый адрес.

Команда Викия


___________________________________________

Чтобы проверить последние события на Викия, посетите http://community.wikia.com
Хотите настроить email рассылку? Перейдите к {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-welcome-email-subject' => 'Добро пожаловать на Викия, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Привет, $USERNAME',
	'usersignup-welcome-email-heading' => 'Мы рады приветствовать вас на Викия и {{SITENAME}}! Вот некоторые вещи, которые вы можете сделать, чтобы начать работу.',
	'usersignup-welcome-email-edit-profile-heading' => 'Отредактируйте свой профайл.',
	'usersignup-welcome-email-edit-profile-content' => 'Добавьте в свой профайл на {{SITENAME}} картинку и несколько фактов о себе.',
	'usersignup-welcome-email-edit-profile-button' => 'Перейти к профайлу',
	'usersignup-welcome-email-learn-basic-heading' => 'Изучите основы.',
	'usersignup-welcome-email-learn-basic-content' => 'Посмотрите краткое руководств по Викия: как редактировать страницы, профайл участника, изменить личные настройки и другое.',
	'usersignup-welcome-email-learn-basic-button' => 'Перейти к',
	'usersignup-welcome-email-explore-wiki-heading' => 'Исследуйте другие викии.',
	'usersignup-welcome-email-explore-wiki-content' => 'На Викия находятся тысячи викий, найдите другие викии, которые,возможно, заинтересуют вас: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Видеоигры</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Кино и Сериалы</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Увлечения</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Перейти к wikia.com',
	'usersignup-welcome-email-content' => 'Нужна дополнительная информация? На <a style="color:#2C85D5;" href="http://community.wikia.com">Центральной Вики</a> можно найти советы, ответы на вопросы и других участников сообщества Викия. Счастливого редактирования!',
	'usersignup-welcome-email-signature' => 'Команда Викия',
	'usersignup-welcome-email-body' => 'Привет, $USERNAME

Мы рады приветствовать тебя на Викия и на {{SITENAME}}! Вот несколько советов, которые помогут тебе начать.

Отредактируйте свой профайл.

Добавьте в свой профайл на {{SITENAME}} картинку и несколько фактов о себе.

Перейти к $EDITPROFILEURL

Изучите основы.

Посмотрите краткое руководство по Викия: как редактировать страницы, профайл участника, изменить личные настройки и другое.

Перейти к ($LEARNBASICURL)

Исследуйте другие викии.

На Викия находятся тысячи викий, найдите другие викии, которые,возможно, заинтересуют вас: Видеоигры (http://www.wikia.com/Video_Games), Кино и сериалы (http://www.wikia.com/Entertainment) или Увлечения (http://www.wikia.com/Lifestyle).

Перейти к $EXPLOREWIKISURL

Нужна дополнительная информация? На Центральной Вики (http://www.community.wikia.com) можно найти советы, ответы на вопросы и других участников сообщества Викия. Счастливого редактирования!

Команда Викия


___________________________________________

Чтобы проверить последние события на Викия, посетите http://community.wikia.com
Хотите настроить email рассылку? Перейдите к {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Присоединитесь к Викия сегодня',
	'usersignup-heading-byemail' => 'Создайте учётную запись для кого-то ещё',
	'usersignup-marketing-wikia' => 'Начните сотрудничество с миллионами людей со всего мира, которые собрались вместе, чтобы поделиться тем, что они знают и любят.',
	'usersignup-marketing-login' => 'Уже есть учётная запись? [[Special:UserLogin|Войти]]',
	'usersignup-marketing-benefits' => 'Станьте частью чего-то огромного',
	'usersignup-marketing-community-heading' => 'Сотрудничайте',
	'usersignup-marketing-community' => 'Открывайте и исследуйте различные темы – от видеоигр до кино и телевидения. Встречайте людей с такими же интересами и увлечениями.',
	'usersignup-marketing-global-heading' => 'Создавайте',
	'usersignup-marketing-global' => 'Начните вики. Начните с малого и вырастите нечто большое с помощью других участников.',
	'usersignup-marketing-creativity-heading' => 'Будьте креативны',
	'usersignup-marketing-creativity' => 'Используйте Викия, чтобы выразить свои идеи с помощью с опросов и рейтинговых списков, фото и видео галерей, приложений и многих других вещей.',
	'usersignup-createaccount-byemail' => 'Создать учётную запись для кого-то ещё',
	'usersignup-error-captcha' => 'Слово, которое вы ввели, не соответствует слову в окошке. Попробуйте ещё раз!',
	'usersignup-account-creation-heading' => 'Отлично!',
	'usersignup-account-creation-subheading' => 'Мы отправили письмо на $1',
	'usersignup-account-creation-email-sent' => 'Вы начали процесс создания учётной записи $2. Мы отправили вам письмо на $1 с временным паролем и ссылкой для подтверждения.


$2, вам нужно будет нажать на ссылку в этом письме, чтобы подтвердить свою учётную запись и изменить временный пароль на другой, чтобы завершить создание учётной записи.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Создать другую учётную запись] на {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Учётная запись на Викия создана!',
	'usersignup-account-creation-email-greeting' => 'Привет,',
	'usersignup-account-creation-email-content' => 'Учётная запись на {{SITENAME}} создана. Для доступа к учётной записи и смены временного пароля, нажмите на ссылку ниже и введите своё имя участника "$USERNAME" и пароль "$NEWPASSWORD".

Пожалуйста, перейдите к <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Если вы не хотите, чтобы эта учётная запись была создана, вы можете проигнорировать это сообщение или связаться с нашей командой поддержки сообщества по любому вопросу.',
	'usersignup-account-creation-email-signature' => 'Команда Викия',
	'usersignup-account-creation-email-body' => 'Привет,

Учётная запись на {{SITENAME}} создана. Для доступа к учётной записи и смены временного пароля, нажмите на ссылку ниже и введите своё имя участника "$2" и пароль "$3".

Пожалуйста, перейдите к {{fullurl:{{ns:special}}:UserLogin}}

Если вы не хотите, чтобы эта учётная запись была создана, вы можете проигнорировать это сообщение или связаться с нашей командой поддержки сообщества по любому вопросу.

Команда Викия


___________________________________________

Чтобы проверить последние события на Викия, посетите http://community.wikia.com
Хотите настроить email рассылку? Перейдите к {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-confirmation-reminder-email_subject' => 'Не будьте чужим...',
	'usersignup-confirmation-reminder-email-greeting' => 'Привет, $USERNAME',
	'usersignup-confirmation-reminder-email-content' => 'Уже прошло несколько дней, а вы ещё не завершили создание учётной записи на Викия. Это легко. Просто нажмите на ссылку подтверждения ниже:

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>

Если вы не сделайте этого в течение 23 дней, $USERNAME, то это имя участника станет доступно другим пользователям. Торопитесь!',
	'usersignup-confirmation-reminder-email-signature' => 'Команда Викия',
	'usersignup-confirmation-reminder-email_body' => 'Привет, $2

Уже прошло несколько дней, а вы ещё не завершили создание учётной записи на Викия. Это легко. Просто нажмите на ссылку подтверждения ниже:

$3

Если вы не сделайте этого в течение 23 дней, $2, то это имя участника станет доступно другим пользователям. Торопитесь!

Команда Викия


___________________________________________

Чтобы проверить последние события на Викия, посетите http://community.wikia.com
Хотите настроить email рассылку? Перейдите к {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Есть проблема со связью с Facebook. Пожалуйста, попробуйте ещё раз позже.',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'usersignup-page-title' => 'Gå med i Wikia',
	'usersignup-page-captcha-label' => 'Suddigt ord',
	'usersignup-error-username-length' => 'Hoppsan, ditt användarnamn kan inte vara mer än {{PLURAL:$1|ett tecken|$1 tecken}}.',
	'usersignup-error-invalid-user' => 'Ogiltig användare. Var god logga in först.',
	'usersignup-error-invalid-email' => 'Var god ange en giltig e-postadress.',
	'usersignup-error-symbols-in-username' => 'Hoppsan, ditt användarnamn kan endast innehålla bokstäver och siffror.',
	'usersignup-error-empty-email' => 'Hoppsan, var god fyll i din e-postadress.',
	'usersignup-error-empty-username' => 'Hoppsan, var god fyll i användarnamnsfältet.',
	'usersignup-error-already-confirmed' => 'Du har redan bekräftat denna e-postadress.',
	'usersignup-error-throttled-email' => 'Hoppsan, du har begärt för många e-postbekräftelser att skickas till dig idag. Försök igen om en liten stund.',
	'usersignup-error-too-many-changes' => 'Du har nått den maximala gränsen för e-poständringar idag. Var god försök igen senare.',
	'usersignup-error-password-length' => 'Hoppsan, ditt lösenord är för långt. Var god välj ett lösenord som är 50 tecken eller mindre.',
	'usersignup-error-confirmed-user' => 'Det ser ut som du redan har bekräftat din e-postadress för $1! Kontrollera din [$2 användarprofil].',
	'usersignup-facebook-heading' => 'Slutför registrering',
	'usersignup-facebook-create-account' => 'Skapa konto',
	'usersignup-facebook-email-tooltip' => 'Om du vill använda en annan e-postadress kan du ändra den senare i dina inställningar.',
	'usersignup-facebook-have-an-account-heading' => 'Har du redan ett konto?',
	'usersignup-facebook-have-an-account' => 'Anslut ditt existerande Wikia-användarnamn med Facebook istället.',
	'usersignup-user-pref-emailconfirmlink' => 'Begär en ny e-postbekräftelse',
	'usersignup-user-pref-confirmemail_send' => 'Skicka min e-postbekräftelse igen',
	'usersignup-user-pref-emailauthenticated' => 'Tack! Din e-postadress bekräftades den $2 kl $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Kontrollera din e-post och klicka på bekräftelselänken för att slutföra din e-poständring till: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Ånej! Din e-post är obekräftad. E-postfunktioner kommer inte fungera tills du har bekräftat din e-postadress.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Nästan klar! Vi har skickat en ny e-postbekräftelse till $1. Kontrollera din e-post och klicka på länken för att slutföra bekräftelsen av din e-postadress.',
	'usersignup-confirm-page-title' => 'Bekräfta din e-postadress',
	'usersignup-confirm-email-resend-email' => 'Skicka mig en till e-postbekräftelse',
	'usersignup-confirm-email-change-email-content' => 'Jag vill använda en annan e-postadress.',
	'usersignup-confirm-email-change-email' => 'Ändra min e-postadress',
	'usersignup-confirm-email-new-email-label' => 'Ny e-post',
	'usersignup-confirm-email-update' => 'Uppdatera',
	'usersignup-resend-email-heading-success' => 'Ny e-post skickad',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gratulerar!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Du är redan bekräftat',
	'usersignup-confirmation-heading' => 'Nästan klar',
	'usersignup-confirmation-heading-email-resent' => 'Ny e-post skickad',
	'usersignup-confirmation-subheading' => 'Kontrollera din e-post',
	'usersignup-confirmation-email-sent' => "Vi har skickat ett e-postmeddelande till '''$1'''.

Klicka på bekräftelselänken i din e-post för att slutföra skapandet av ditt konto.",
	'usersignup-confirmation-email_subject' => 'Nästan klar! Bekräfta ditt Wikia-konto',
	'usersignup-confirmation-email-greeting' => 'Hej $USERNAME,',
	'usersignup-confirmation-email-content' => 'Du är ett steg bort från att skapa ditt konto på Wikia! Klicka på länken nedan för att bekräfta din e-postadress och komma igång.

<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>',
	'usersignup-confirmation-email-signature' => 'Wikia-teamet',
	'usersignup-confirmation-email_body' => 'Hej $2,

Du är ett steg bort från att skapa ditt konto på Wikia! Klicka på länken nedan för att bekräfta din e-postadress och komma igång.

$3

Wikia-teamet


___________________________________________

För att kolla in de senaste händelserna på Wikia, besök http://community.wikia.com
Vill du kontrollera vilka e-postmeddelanden du får? Gå till: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-reconfirmation-email-greeting' => 'Hej $USERNAME',
	'usersignup-reconfirmation-email-signature' => 'Wikia-teamet',
	'usersignup-welcome-email-subject' => 'Välkommen till Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hej $USERNAME',
	'usersignup-welcome-email-edit-profile-heading' => 'Redigera din profil.',
	'usersignup-welcome-email-edit-profile-button' => 'Gå till profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Lär dig grunderna.',
	'usersignup-welcome-email-learn-basic-button' => 'Spana in det',
	'usersignup-welcome-email-explore-wiki-heading' => 'Utforska fler wikis.',
	'usersignup-welcome-email-explore-wiki-button' => 'Gå till wikia.com',
	'usersignup-welcome-email-signature' => 'Wikia-teamet',
	'usersignup-heading' => 'Registrera dig på Wikia idag',
	'usersignup-heading-byemail' => 'Skapa ett konto för någon annan',
	'usersignup-marketing-login' => 'Redan en användare? [[Special:UserLogin|Logga in]]',
	'usersignup-marketing-benefits' => 'Bli en del av någonting stort',
	'usersignup-marketing-community-heading' => 'Samarbeta',
	'usersignup-marketing-global-heading' => 'Skapa',
	'usersignup-marketing-global' => 'Starta en wiki. Starta litet, väx stort, med hjälp av andra.',
	'usersignup-marketing-creativity-heading' => 'Var originell',
	'usersignup-createaccount-byemail' => 'Skapa ett konto för någon annan',
	'usersignup-account-creation-heading' => 'Succé!',
	'usersignup-account-creation-subheading' => 'Vi har skickat ett e-postmeddelande till $1',
	'usersignup-account-creation-email-subject' => 'Ett konto har skapats för dig på Wikia!',
	'usersignup-account-creation-email-greeting' => 'Hallå,',
	'usersignup-account-creation-email-content' => 'Ett konto har skapats för dig på {{SITENAME}}. För att komma åt ditt konto och ändra din tillfälliga lösenord, klicka på länken nedan och logga in med användarnamnet "$USERNAME" och lösenordet "$NEWPASSWORD".

Var god logga in på <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Om du inte vill använda det här kontot ska skapas kan du helt enkelt ignorera detta e-postmeddelande eller kontakta vår Gemenskapssupportsteam med några frågor.',
	'usersignup-account-creation-email-signature' => 'Wikia-teamet',
	'usersignup-confirmation-reminder-email_subject' => 'Var inte en främling...',
	'usersignup-confirmation-reminder-email-greeting' => 'Hej $USERNAME',
	'usersignup-confirmation-reminder-email-signature' => 'Wikia-teamet',
	'usersignup-facebook-problem' => 'Det gick inte att kommunicera med Facebook. Försök igen senare.',
);
