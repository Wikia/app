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

	// facebook sign-up
	'usersignup-facebook-heading' => 'Finish Signing Up',
	'usersignup-facebook-create-account' => 'Create account',
	'usersignup-facebook-email-tooltip' => 'If you would like to use a different e-mail address you can change it later in your Preferences.',
	'usersignup-facebook-have-an-account-heading' => 'Already have an account?',
	'usersignup-facebook-have-an-account' => 'Connect your existing Wikia username with Facebook instead.',
	'usersignup-facebook-proxy-email' => 'Anonymous facebook email',

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
<br/><br/>
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
<br/><br/>
<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>
<br/><br/>
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
<br/><br/>
Please log in at <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>
<br/><br/>
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

	// facebook sign-up
	'usersignup-facebook-heading' => 'Heading on Facebook signup modal when signing up via facebook connect',
	'usersignup-facebook-create-account' => 'Sub heading on facebook signup modal.',
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
