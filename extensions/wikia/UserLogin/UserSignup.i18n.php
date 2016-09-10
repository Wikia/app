<?php
/**
* Internationalisation file for the UserSignup extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'usersignup-page-title' => 'Join Fandom',
	'usersignup-page-title-wikiamobile' => 'Create account',
	'usersignup-page-captcha-label' => 'Challenge',
	'usersignup-error-username-length' => "Oops, your username can't be more than {{PLURAL:$1|one character|$1 characters}}.",
	'usersignup-error-invalid-user' => 'Invalid user. Please login first.',
	'usersignup-error-invalid-email' => 'Please enter a valid email address.',
	'usersignup-error-symbols-in-username' => 'Oops, your username can only contain letters and numbers.',
	'usersignup-error-empty-email' => 'Oops, please fill in your email address.',
	'usersignup-error-empty-username' => 'Oops, please fill in the username field.',
	'usersignup-error-already-confirmed' => "You've already confirmed this email address.",
	'usersignup-error-throttled-email' => "Oops, you've requested too many confirmation emails be sent to you today. Try again in a little while.",
	'usersignup-error-too-many-changes' => "You've reached the maximum limit for email changes today. Please try again later.",
	'usersignup-error-password-length' => "Oops, your password is too long. Please choose a password that's 50 characters or less.",
	'usersignup-error-confirmed-user' => "Looks like you've already confirmed your email address for $1!  Check out your [$2 user profile].",
	'usersignup-facebook-heading' => 'Finish Signing Up',
	'usersignup-facebook-create-account' => 'Create account',
	'usersignup-facebook-email-tooltip' => "If you'd like to use a different email address you can change it later in your Preferences.",
	'usersignup-facebook-have-an-account-heading' => 'Already have an account?',
	'usersignup-facebook-have-an-account' => 'Connect your existing Fandom username with Facebook instead.',
	'usersignup-facebook-proxy-email' => 'Anonymous Facebook email',
	'usersignup-user-pref-emailconfirmlink' => 'Request a new confirmation email',
	'usersignup-user-pref-confirmemail_send' => 'Resend my confirmation email',
	'usersignup-user-pref-emailauthenticated' => 'Thanks! Your email was confirmed on $2 at $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Check your email and click the confirmation link to finish changing your email to: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => "Oh, no! Your email is unconfirmed. Email features won't work until you confirm your email address.",
	'usersignup-user-pref-reconfirmation-email-sent' => "Almost there! We've sent a new confirmation email to $1. Check your email and click on the link to finish confirming your email address.",
	'usersignup-user-pref-noemailprefs' => "Looks like we don't have an email address for you. Please enter an email address above.",
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => "Oh, no! Your email is unconfirmed. We've sent you an email, click the confirmation link there to confirm.",
	'usersignup-user-pref-confirmemail_noemail' => "Looks like we don't have an email address for you. Go to [[Special:Preferences|user preferences]] to enter one.",
	'usersignup-confirm-page-title' => 'Confirm your email',
	'usersignup-confirm-page-title-wikiamobile' => 'Check your email',
	'usersignup-confirm-email-resend-email' => 'Send me another confirmation email',
	'usersignup-confirm-email-change-email-content' => 'I want to use a different email address.',
	'usersignup-confirm-email-change-email' => 'Change my email address',
	'usersignup-confirm-email-new-email-label' => 'New email',
	'usersignup-confirm-email-update' => 'Update',
	'usersignup-confirm-email-tooltip' => "Did you enter an email address that you can't confirm, or do you want to use a different email address? Don't worry, use the link below to change your email address and get a new confirmation email.",
	'usersignup-resend-email-heading-success' => 'New email sent',
	'usersignup-resend-email-heading-failure' => 'Email not re-sent',
	'usersignup-confirm-page-heading-confirmed-user' => 'Congrats!',
	'usersignup-confirm-page-subheading-confirmed-user' => "You're already confirmed",
	'usersignup-confirmation-heading' => 'Almost there',
	'usersignup-confirmation-heading-wikiamobile' => 'Check your email',
	'usersignup-confirmation-heading-email-resent' => 'New email sent',
	'usersignup-confirmation-subheading' => 'Check your email',
	'usersignup-confirmation-email-sent' => "We sent an email to '''$1'''.

Click the confirmation link in your email to finish creating your account.",
	'usersignup-confirmation-email-sent-wikiamobile' => "We sent an email to '''$1'''.

Click the confirmation link in your email to finish creating your account. Thanks!",
	'usersignup-reconfirmation-email-sent' => "Your email address has been changed to $1. We've sent you a new confirmation email. Please confirm the new email address.",
	'usersignup-welcome-email-subject' => 'Welcome to Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hi $USERNAME',
	'usersignup-welcome-email-heading' => "We're happy to welcome you to Wikia and {{SITENAME}}! Here are some things you can do to get started.",
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
	'usersignup-heading' => 'Join Fandom Today',
	'usersignup-heading-byemail' => 'Create an account for someone else',
	'usersignup-marketing-wikia' => 'Start collaborating with millions of people from around the world who come together to share what they know and love.',
	'usersignup-marketing-login' => 'Already a user? [[Special:UserLogin|Log in]]',
	'usersignup-marketing-benefits' => 'Be a part of something huge',
	'usersignup-marketing-community-heading' => 'Collaborate',
	'usersignup-marketing-community' => 'Discover and explore subjects ranging from video games to movies and tv. Meet people with similar interests and passions.',
	'usersignup-marketing-global-heading' => 'Create',
	'usersignup-marketing-global' => 'Start a wiki. Start small, grow big, with the help of others.',
	'usersignup-marketing-creativity-heading' => 'Be original',
	'usersignup-marketing-creativity' => 'Use Fandom to express your creativity with photos, video galleries, apps and discussions.',
	'usersignup-createaccount-byemail' => 'Create an account for someone else',
	'usersignup-error-captcha' => 'The challenge answer failed, please try again!',
	'usersignup-account-creation-heading' => 'Success!',
	'usersignup-account-creation-subheading' => "We've sent an email to $1",
	'usersignup-account-creation-email-sent' => "You've started the account creation process for $2. We've sent them an email at $1 with a temporary password and a confirmation link.


$2 will need to click on the link in the email we sent them to confirm their account and change their temporary password to finish creating their account.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Create more accounts] on {{SITENAME}}",
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
	'usersignup-facebook-problem' => 'There was a problem communicating with Facebook. Please try again later.',
	'usersignup-facebook-signup-header' => 'Creating a new account?',
	'usersignup-facebook-login-header' => 'Already have an account?',
);

/** Message documentation (Message documentation)
 * @author McDutchie
 * @author Robby
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = array(
	'usersignup-page-title' => 'Page title for Special:UserSignup',
	'usersignup-page-title-wikiamobile' => 'Page title for Special:UserSignup on Mobile skin',
	'usersignup-page-captcha-label' => 'Label for captcha on signup form',
	'usersignup-error-username-length' => 'Error message stating that username is too long and over $1 amount of characters.',
	'usersignup-error-invalid-user' => 'Generic error message when the user has been invalidated in the session for security reasons.',
	'usersignup-error-invalid-email' => 'Error message stating that e-mail address is invalid.',
	'usersignup-error-symbols-in-username' => 'Error message stating that username cannot contain weird symbols.',
	'usersignup-error-empty-email' => 'Error message stating that e-mail address is required.',
	'usersignup-error-empty-username' => 'Error message stating that user name field is required.',
	'usersignup-error-already-confirmed' => 'Error message stating that the user has already been confirmed.',
	'usersignup-error-throttled-email' => 'Error message stating that too many email has been sent.',
	'usersignup-error-too-many-changes' => 'Error message stating that e-mail address has been changed too many times today.',
	'usersignup-error-password-length' => 'Error message stating that password is over 50 characters and is too long.',
	'usersignup-error-confirmed-user' => "Validation message stating that user has been confirmed. Parameters:
* $1 is an e-mail address;
* $2 is a link to user's preference page.",
	'usersignup-facebook-heading' => 'Heading on Facebook signup modal when signing up via Facebook Connect',
	'usersignup-facebook-create-account' => 'Sub heading on Facebook signup modal.
{{Identical|Create account}}',
	'usersignup-facebook-email-tooltip' => 'A hint to the user saying you can changed the email later in preferences.',
	'usersignup-facebook-have-an-account-heading' => 'Heading to suggest logging in instead.',
	'usersignup-facebook-have-an-account' => 'Suggestion to connect existing account with FB.',
	'usersignup-facebook-proxy-email' => 'Masking label if user decides to use proxy email from FB instead of real one.  This masked label will be displayed instead of the very long FB proxy e-mail address.',
	'usersignup-user-pref-emailconfirmlink' => 'Action link to confirm an email on Special:Preference',
	'usersignup-user-pref-confirmemail_send' => 'Action link to re-send confirmation email',
	'usersignup-user-pref-emailauthenticated' => 'Label stating email was already confirmed.  $2 is date (April 16, 2011), $3 is time of day (01:47).  Assume $2, and $3 is already internationalized.',
	'usersignup-user-pref-emailnotauthenticated' => 'Alert to check email and to confirm email.  Parameters:
* $1 is the e-mail address the email was sent to.',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Alert that user cannot perform this action when user has not confirmed email.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Validation message telling user that email has been sent to $1. $1 is e-mail address.',
	'usersignup-user-pref-noemailprefs' => 'Alert that user email does not exist.  Instructs user to enter an e-mail address.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => "Alert that user's email is unconfirmed, and the email has already been sent.",
	'usersignup-user-pref-confirmemail_noemail' => 'Alert that email has not been entered.  Instructs and links user to Special:Preferences.',
	'usersignup-confirm-page-title' => 'Confirm page title.  This page is displayed after initially submitting the account information from Special:UserSignup.',
	'usersignup-confirm-page-title-wikiamobile' => 'Page title for Special:UserSignup on mobile skin',
	'usersignup-confirm-email-resend-email' => 'Action link to resend email.',
	'usersignup-confirm-email-change-email-content' => 'Change email heading.',
	'usersignup-confirm-email-change-email' => 'Action link to open a dialog to change email.',
	'usersignup-confirm-email-new-email-label' => 'Label for email input.',
	'usersignup-confirm-email-update' => 'Button to submit email address update form.
{{Identical|Update}}',
	'usersignup-confirm-email-tooltip' => '{{doc-singularthey}}
Tooltip letting user know they can change their email.  Tooltip is on the same line as {{msg-w|usersignup-confirm-email-change-email-content}}',
	'usersignup-resend-email-heading-success' => 'Validation message telling the user the email has been re-sent.',
	'usersignup-resend-email-heading-failure' => 'Error message telling the user email has not been re-sent',
	'usersignup-confirm-page-heading-confirmed-user' => 'Congratulatory message when user has confirm email on confirmation page.',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Alert that user has been confirmed already.',
	'usersignup-confirmation-heading' => 'Confirm page heading.',
	'usersignup-confirmation-heading-email-resent' => 'Confirm page heading when email has been re-sent.',
	'usersignup-confirmation-subheading' => 'Confirm page sub heading.',
	'usersignup-confirmation-email-sent' => 'Confirm page action validation stating email has been sent to $1 e-mail address.  Bold $1, and leave a purposeful line break between line 1 and line 2.',
	'usersignup-confirmation-email-sent-wikiamobile' => 'Confirm page action validation stating email has been sent to $1 e-mail address on mobile skin.',
	'usersignup-reconfirmation-email-sent' => 'Message telling user that the e-mail address has been changed to $1.',
	'usersignup-welcome-email-subject' => 'Welcome email subject.  $USERNAME is magic word for user name.',
	'usersignup-welcome-email-greeting' => 'Welcome email greeting.  $USERNAME is magic word for user name.',
	'usersignup-welcome-email-heading' => 'Welcome email heading.  SITENAME is MediaWiki magic word for wiki name.',
	'usersignup-welcome-email-edit-profile-heading' => 'Welcome email first section heading.',
	'usersignup-welcome-email-edit-profile-content' => 'Welcome email first section body.  SITENAME is MediaWiki magic word.',
	'usersignup-welcome-email-edit-profile-button' => 'Welcome email first section button label.  Links to preferences in the template, so no linking required from messaging.',
	'usersignup-welcome-email-learn-basic-heading' => 'Welcome email second section heading.',
	'usersignup-welcome-email-learn-basic-content' => 'Welcome email second section body.',
	'usersignup-welcome-email-learn-basic-button' => 'Welcome email second section button label.  Do not be concerned with linking.
{{Identical|Check it out}}',
	'usersignup-welcome-email-explore-wiki-heading' => 'Welcome email third section heading.',
	'usersignup-welcome-email-explore-wiki-content' => 'Welcome email third section body.  There are links to category pages on hubs.  Those links can be omitted if there are no hub pages for the language.',
	'usersignup-welcome-email-explore-wiki-button' => 'Welcome email third section button.',
	'usersignup-welcome-email-content' => 'Welcome email user help content.  Leave blank of the language does not have a helper or community wiki in that language, or leave the link to english community wiki as-is.',
	'usersignup-welcome-email-signature' => 'Welcome email signature.',
	'usersignup-welcome-email-body' => 'Text-only version of Welcome email.  $USERNAME, $EDITPROFILEURL, $LEARNBASICURL, $EXPLOREWIKISURL should be left as-is.',
	'usersignup-heading' => 'Page heading for Special:UserSignup',
	'usersignup-heading-byemail' => 'Page heading for Special:UserSignup?byemail=1 to create account for others.',
	'usersignup-marketing-wikia' => 'Marketing message on the left side of Special:UserSignup',
	'usersignup-marketing-login' => 'Encouragement to login if account exists on the left side of Special:UserSignup.  Link to Special:UserLogin using wikitext.',
	'usersignup-marketing-benefits' => 'Heading for right side of Special:UserSignup',
	'usersignup-marketing-community-heading' => 'Subsection heading on right side of Special:UserSignup',
	'usersignup-marketing-community' => 'Marketing blurb on right side of Special:UserSignup',
	'usersignup-marketing-global-heading' => 'Second subsection heading on right side of Special:UserSignup.
{{Identical|Create}}',
	'usersignup-marketing-global' => 'Second marketing blurb on right side of Special:UserSignup.',
	'usersignup-marketing-creativity-heading' => 'Third subsection heading on right side of Special:UserSignup',
	'usersignup-marketing-creativity' => 'Third marketing blurb on right side of Special:UserSignup.',
	'usersignup-createaccount-byemail' => 'Button label on signup form for Special:UserSignup?byemail=1 to create account for others.',
	'usersignup-error-captcha' => 'Error message for captcha failure.',
	'usersignup-account-creation-heading' => 'Page heading for confirm page when byemail=1 is used.
{{Identical|Success}}',
	'usersignup-account-creation-subheading' => 'Page subheading for confirm page when byemail=1 is used. Parameters:
* $1 is an e-mail address.',
	'usersignup-account-creation-email-sent' => '{{doc-singularthey}}
Page content for confirm page when byemail=1 is used.  Parameters:
* $1 is e-mail address sent to,
* $2 is the user name that the account has been created for.',
	'usersignup-account-creation-email-subject' => 'Confirmation email subject for people receiving the account when byemail=1 is used.',
	'usersignup-account-creation-email-greeting' => 'Confirmation email greeting for people receiving the account when byemail=1 is used.
{{Identical|Hello}}',
	'usersignup-account-creation-email-content' => 'Confirmation email body for people receiving the account when byemail=1 is used.  $USERNAME is user name, $NEWPASSWORD is new password for the user to use.',
	'usersignup-account-creation-email-signature' => 'Confirmation email signature for people receiving the account when byemail=1 is used.',
	'usersignup-account-creation-email-body' => 'Text-only version of confirmation email for people receiving the account when byemail=1 is used.  $2 is username, $3 is the new password.',
	'usersignup-account-creation-email-body-HTML' => 'Standalone HTML version of confirmation email for people receiving the account when byemail=1 is used.  $2 is username, $3 is the new password.',
	'usersignup-facebook-signup-header' => 'Question asking user if they want to create a new account after having connected with facebook.',
	'usersignup-facebook-login-header' => 'Question asking user if they want to connect an existing wikia account with their facebook account.',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 * @author Kuwaity26
 */
$messages['ar'] = array(
	'usersignup-page-title' => 'سجل في ويكيا',
	'usersignup-page-title-wikiamobile' => 'أنشئ حسابًا',
	'usersignup-page-captcha-label' => 'كلمة ضبابية', # Fuzzy
	'usersignup-error-username-length' => 'عفوا، اسم المستخدم الخاص بك لا يمكن أن يتكون من أكثر من {{PLURAL:$1|حرف واحد|$1 حرف}}.',
	'usersignup-error-invalid-user' => 'مستخدم غير صحيح. الرجاء تسجيل الدخول أولاً.',
	'usersignup-error-invalid-email' => 'الرجاء إدخال عنوان بريد إلكتروني صحيح.',
	'usersignup-error-symbols-in-username' => 'عفوا، يجب أن يتضمن اسم المستخدم الخاص بك فقط الأحرف والأرقام.',
	'usersignup-error-empty-email' => 'عفوا، يرجى ملء خانة عنوان البريد الإلكتروني الخاص بك.',
	'usersignup-error-empty-username' => 'عفوا، يرجى ملء خانة اسم المستخدم.',
	'usersignup-error-already-confirmed' => 'لقد أكدت لك بالفعل عنوان البريد الإلكتروني هذا.',
	'usersignup-error-throttled-email' => 'عفوا، لقد طلبت إرسال العديد من رسائل التأكيد الإلكترونية اليوم. حاول مرة أخرى بعد فترة قصيرة.',
	'usersignup-error-too-many-changes' => 'لقد وصلت إلى الحد الأقصى لتغيير البريد الإلكتروني اليوم. الرجاء المحاولة مرة أخرى لاحقاً.',
	'usersignup-error-password-length' => 'عفوا، كلمة المرور طويلة جداً. الرجاء اختيار كلمة مرور تحوي 50 حرفاً أو أقل.',
	'usersignup-error-confirmed-user' => 'يبدو بأنك قد أكدت بالفعل عنوان البريد الإلكتروني الخاص بك ل $1 !  قم بزيارة [$2 صفحتك الخاصة].', # Fuzzy
	'usersignup-facebook-heading' => 'إنهاء التسجيل',
	'usersignup-facebook-create-account' => 'أنشئ حسابا',
	'usersignup-facebook-email-tooltip' => 'إذا كنت ترغب في استخدام عنوان بريد إلكتروني مختلف يمكنك تغييره لاحقاً في التفضيلات الخاصة بك.',
	'usersignup-facebook-have-an-account-heading' => 'لديك حساب؟',
	'usersignup-facebook-have-an-account' => 'اربط حساب ويكيا الخاص بك مع الفيسبوك عوض ذلك',
	'usersignup-facebook-proxy-email' => 'بريد فيسبوك إلكتروني مجهول',
	'usersignup-user-pref-emailconfirmlink' => 'طلب جديد لتأكيد البريد الإلكتروني',
	'usersignup-user-pref-confirmemail_send' => 'إعادة إرسال رسالة تأكيد لبريدي الإلكتروني',
	'usersignup-user-pref-emailauthenticated' => 'شكرا! تم تأكيد بريدك الإلكتروني في $2 على الساعة $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'تحقق من البريد الإلكتروني الخاص بك وانقر فوق رابط التأكيد للانتهاء من تغيير البريد الإلكتروني الخاص بك إلى: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'أوه، لا! عنوان البريد الإلكتروني الخاص بك غير مؤكد. لن تعمل ميزات البريد الإلكتروني حتى تقوم بتأكيد عنوان البريد الإلكتروني الخاص بك.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'سوف تنتهي تقريبا! لقد أرسلنا رسالة تأكيد البريد إلكتروني جديدة إلى $1 . قم بالتحقق من البريد الإلكتروني الخاص بك وانقر فوق الرابط للانتهاء من تأكيد عنوان البريد الإلكتروني الخاص بك.',
	'usersignup-user-pref-noemailprefs' => 'يبدو أنه ليس لدينا عنوان بريد إلكتروني عنك. الرجاء إدخال عنوان البريد إلكتروني المذكور أعلاه.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'أوه، لا! عنوان البريد الإلكتروني الخاص بك غير مؤكد. لقد أرسلنا لك رسالة إلكترونية، انقر فوق الرابط هناك للتأكيد.',
	'usersignup-user-pref-confirmemail_noemail' => 'يبدو أنه ليس لدينا عنوان بريد إلكتروني عنك. لإدخال البريد قم بزيارة  [[Special:Preferences|صفحة تفضيلاتك]].',
	'usersignup-confirm-page-title' => 'تأكيد بريدك الإلكتروني',
	'usersignup-confirm-page-title-wikiamobile' => 'تحقق من بريدك الإلكتروني',
	'usersignup-confirm-email-resend-email' => 'أرسل لي رسالة تأكيد أخرى للبريد الإلكتروني',
	'usersignup-confirm-email-change-email-content' => 'أريد أن استخدم عنوان بريد إلكتروني مختلف.',
	'usersignup-confirm-email-change-email' => 'تغيير عنوان البريد الإلكتروني الخاص بي',
	'usersignup-confirm-email-new-email-label' => 'البريد الإلكتروني الجديد',
	'usersignup-confirm-email-update' => 'تحديث',
	'usersignup-confirm-email-tooltip' => 'هل قمت بإدخال عنوان بريد إلكتروني ولا يمكنك تأكيده، أم تريد استخدام عنوان بريد الكتروني مختلف؟ لا تقلق، استخدم الرابط في الأسفل لتغيير عنوان بريدك الإلكتروني و الحصول على رسالة تأكيد جديدة.',
	'usersignup-resend-email-heading-success' => 'تم إرسال بريد إلكتروني جديد',
	'usersignup-resend-email-heading-failure' => 'لم يتم إرسال البريد',
	'usersignup-confirm-page-heading-confirmed-user' => 'مبروك!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'بريدك مأكد بالفعل',
	'usersignup-confirmation-heading' => 'يتم التأكيد',
	'usersignup-confirmation-heading-wikiamobile' => 'تحقق من بريدك الإلكتروني',
	'usersignup-confirmation-heading-email-resent' => 'تم إرسال بريد إلكتروني جديد',
	'usersignup-confirmation-subheading' => 'التحقق من البريد الإلكتروني الخاص بك',
	'usersignup-confirmation-email-sent' => "لقد أرسلنا رسالة بالبريد الإلكتروني إلى '''$1'''.

انقر فوق رابط التأكيد في بريدك الإلكتروني للانتهاء من إنشاء حسابك.",
	'usersignup-confirmation-email-sent-wikiamobile' => "لقد أرسلنا رسالة إلكترونية إلى '''$1'''.

اضغط على رابط التأكيد في بريدك الإلكتروني للانتهاء من إنشاء حسابك. شكرًا!",
	'usersignup-reconfirmation-email-sent' => 'تم تغيير عنوان بريدك الإلكتروني إلى  $1 . لقد أرسلنا لك رسالة تأكيد جديدة بالبريد إلكتروني. يرجى تأكيد عنوان البريد الإلكتروني الجديد.',
	'usersignup-welcome-email-subject' => 'مرحبا بك في ويكيا يا $USERNAME!',
	'usersignup-welcome-email-greeting' => 'مرحبا يا $USERNAME',
	'usersignup-welcome-email-heading' => 'نحن سعداء بالترحيب بك في ويكيا و {{SITENAME}}! إليك بعض الأشياء التي يمكنك القيام بها للبدأ.',
	'usersignup-welcome-email-edit-profile-heading' => 'تعديل صفحتك الشخصية',
	'usersignup-welcome-email-edit-profile-content' => 'إضافة صور شخصية وبضع المعلومات الصغيرة عن نفسك في صفحتك الشخصية في {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'انتقل إلى الصفحة الشخصية',
	'usersignup-welcome-email-learn-basic-heading' => 'تعلم الأساسيات.',
	'usersignup-welcome-email-learn-basic-content' => 'أحصل على تعليم سريع حول أساسيات ويكيا: كيفية تحرير صفحة، صفحتك الشخصية، تغيير تفضيلاتك، و المزيد.',
	'usersignup-welcome-email-learn-basic-button' => 'التحقق من ذلك',
	'usersignup-welcome-email-explore-wiki-heading' => 'اكتشاف المزيد من الويكيات',
	'usersignup-welcome-email-explore-wiki-content' => 'هناك الآلاف من الويكيات في ويكيا، إبحث عن أكثر الويكيات التي تهمك بالتوجه إلى إحدى محاورنا:  <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">ألعاب الفيديو</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">الترفيه</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">أساليب الحياة</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'اذهب إلى wikia.com',
	'usersignup-welcome-email-content' => 'تريد المزيد من المعلومات؟ إبحث عن نصائح، أجوبة في مجتمع ويكيا في <a style="color:#2C85D5;" href="http://community.wikia.com">مركز المجتمع</a>. تحريرا سعيدا!',
	'usersignup-welcome-email-signature' => 'فريق ويكيا',
	'usersignup-heading' => 'إنضم لويكيا الآن',
	'usersignup-heading-byemail' => 'إنشاء حساب لشخص آخر',
	'usersignup-marketing-wikia' => 'تعاون مع الملايين من الأشخاص الذين يأتون من جميع أنحاء العالم لتقاسم معرفتهم و محبتهم.',
	'usersignup-marketing-login' => 'أنت مستخدم بالفعل؟ [[Special:UserLogin|قم بتسجيل الدخول]]',
	'usersignup-marketing-benefits' => 'كن جزءا من شيء ضخم',
	'usersignup-marketing-community-heading' => 'تعاون',
	'usersignup-marketing-community' => 'إكتشاف موضوعات تتدرج من ألعاب الفيديو إلى الأفلام و التلفاز. تعرف على أشخاص يشاركونك في الهوايات.',
	'usersignup-marketing-global-heading' => 'أنشئ',
	'usersignup-marketing-global' => 'أنشئ ويكي، إبدأ صغيرا، وانموا كبيرا، بمساعدة الآخرين.',
	'usersignup-marketing-creativity-heading' => 'كن أصليا',
	'usersignup-marketing-creativity' => 'استخدم ويكيا لتعبر عن إبداعك عبر التصويتات و قوائم أفضل 10، الصور و شرائط الفيديو، التطبيقات والمزيد.',
	'usersignup-createaccount-byemail' => 'إنشاء حساب لشخص آخر',
	'usersignup-error-captcha' => 'لم تطابق الكلمة التي قمت بإدخالها بالكلمة في المربع، حاول مرة أخرى!', # Fuzzy
	'usersignup-account-creation-heading' => 'نجاح!',
	'usersignup-account-creation-subheading' => 'لقد أرسلنا رسالة بالبريد إلكتروني إلى $1',
	'usersignup-account-creation-email-subject' => 'تم إنشاء حساب لك في ويكيا!',
	'usersignup-account-creation-email-greeting' => 'أهلاّ بك',
	'usersignup-account-creation-email-signature' => 'فريق ويكيا',
	'usersignup-facebook-problem' => 'هناك مشكلة في الاتصال مع فيسبوك. الرجاء المحاولة مرة أخرى لاحقاً.',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'usersignup-welcome-email-greeting' => 'Salam $USERNAME',
	'usersignup-marketing-global-heading' => 'Yarat',
	'usersignup-account-creation-email-greeting' => 'Salam,',
);

/** South Azerbaijani (تۆرکجه)
 * @author Arjanizary
 */
$messages['azb'] = array(
	'usersignup-welcome-email-greeting' => 'سلام $USERNAME,',
	'usersignup-marketing-global-heading' => 'یارات',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
);

/** Bengali (বাংলা)
 * @author Aftabuzzaman
 */
$messages['bn'] = array(
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'usersignup-page-title' => 'Kemer perzh e Wikia',
	'usersignup-page-captcha-label' => 'Ger dispisaet', # Fuzzy
	'usersignup-error-username-length' => "Oc'ho, ne c'hall ket bezañ ouzhpenn {{PLURAL:$1|un arouezenn|$1 arouezenn}} en hoc'h anv implijer.",
	'usersignup-error-invalid-user' => 'Implijer direizh. Kevreit da gentañ, mar plij.',
	'usersignup-error-invalid-email' => "Ebarzhit ur chomlec'h postel reizh, mar plij.",
	'usersignup-error-empty-email' => "Pop, lakait ho chomlec'h postel, mar plij.",
	'usersignup-error-already-confirmed' => "Kadarnaet ho peus ar chomlec'h postel-mañ dija.",
	'usersignup-error-password-length' => "Pop, re hir eo ho ker-tremen. Dibabit ur ger-tremen gant 50 arouezenn d'ar muiañ, mar plij.",
	'usersignup-facebook-heading' => 'Echu eo an enskrivadur',
	'usersignup-facebook-create-account' => 'Krouiñ ur gont',
	'usersignup-facebook-email-tooltip' => "Ma fell deoc'h implijout ur chomlec'h postel all e c'hallit cheñch anezhañ diwezhatoc'h en ho Penndibaboù.",
	'usersignup-facebook-have-an-account-heading' => "Ur gont hoc'h eus dija ?",
	'usersignup-facebook-proxy-email' => 'Postel dianv Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Goulenn ur postel kadarnaat nevez',
	'usersignup-user-pref-confirmemail_send' => 'Adkas ma fostel kadarnaat',
	'usersignup-user-pref-emailauthenticated' => "Trugarez deoc'h ! Kadarnaet eo bet ho postel d'an $2 da $3.",
	'usersignup-user-pref-noemailprefs' => "War a seblant n'hon eus chomlec'h postel ebet evidoc'h. Lakait ur chomlec'h postel amañ a-us, mar plij.",
	'usersignup-confirm-page-title' => "Kadarnait ho chomlec'h postel",
	'usersignup-confirm-email-resend-email' => 'Kas din ur postel kadarnaat all',
	'usersignup-confirm-email-change-email-content' => "Fellout a ra din implijout ur chomlec'h postel disheñvel.",
	'usersignup-confirm-email-change-email' => "Cheñch ma chomlec'h postel",
	'usersignup-confirm-email-new-email-label' => 'Postel nevez',
	'usersignup-confirm-email-update' => 'Hizivaat',
	'usersignup-resend-email-heading-success' => 'Kaset ez eus bet ur postel nevez',
	'usersignup-resend-email-heading-failure' => "N'eo ket bet adkaset ar postel",
	'usersignup-confirm-page-heading-confirmed-user' => "Gourc'hemennoù",
	'usersignup-confirm-page-subheading-confirmed-user' => "Kadarnaet hoc'h dija",
	'usersignup-confirmation-heading' => 'Tost echu',
	'usersignup-confirmation-heading-email-resent' => 'Kaset ez eus bet ur postel nevez',
	'usersignup-confirmation-subheading' => 'Gwiriekait ho posteloù',
	'usersignup-confirmation-email-sent' => 'Kaset hon eus ur postel da "$1".

Klikit war al liamm kadarnaat en ho postel evit echuiñ da grouiñ ho kont.',
	'usersignup-reconfirmation-email-sent' => "Cheñchet eo bet ho chomlec'h postel e $1. Kaset hon eus ur postel kadarnaat all deoc'h. Kadarnait ar chomlec'h postel nevez, mar plij.",
	'usersignup-welcome-email-subject' => 'Deuet-mat oc\'h e Wikia, $USERNAME !',
	'usersignup-welcome-email-greeting' => 'Ac\'hanta $USERNAME',
	'usersignup-welcome-email-edit-profile-heading' => 'Aozañ ho profil.',
	'usersignup-welcome-email-edit-profile-button' => "Mont d'ar profil",
	'usersignup-welcome-email-learn-basic-heading' => 'Deskiñ an diazezoù.',
	'usersignup-welcome-email-learn-basic-button' => 'Gwiriekaat',
	'usersignup-welcome-email-explore-wiki-heading' => "Dizoloiñ muioc'h a wikioù.",
	'usersignup-welcome-email-explore-wiki-button' => 'Mont da wikia.com',
	'usersignup-welcome-email-signature' => 'Skipailh Wikia',
	'usersignup-heading-byemail' => 'Krouiñ ur gont evit unan bennak all',
	'usersignup-marketing-login' => "Un implijer oc'h dija ? [[Special:UserLogin|Kevreañ]]",
	'usersignup-marketing-community-heading' => 'Kenlabourit',
	'usersignup-marketing-global-heading' => 'Krouiñ',
	'usersignup-createaccount-byemail' => 'Krouiñ ur gont evit unan bennak all',
	'usersignup-account-creation-heading' => 'Berzh !',
	'usersignup-account-creation-subheading' => 'Kaset hon eus ur postel da $1',
	'usersignup-account-creation-email-subject' => "Krouet ez eus bet ur gont evidoc'h war Wikia !",
	'usersignup-account-creation-email-greeting' => 'Demat,',
	'usersignup-account-creation-email-signature' => 'Skipailh Wikia',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Marcmpujol
 * @author Toniher
 * @author Unapersona
 */
$messages['ca'] = array(
	'usersignup-page-title' => 'Uneix-te a Wikia',
	'usersignup-page-title-wikiamobile' => 'Crear compte',
	'usersignup-page-captcha-label' => 'Paraula borrosa', # Fuzzy
	'usersignup-error-username-length' => 'Vaja, el teu nom no pot ser més de {{PLURAL:$1|un caràcter |$1 caràcters}}.',
	'usersignup-error-invalid-user' => "L'usuari no és vàlid. Si us plau identifique't primer.",
	'usersignup-error-invalid-email' => 'Si us plau, introdueix una adreça electrònica vàlida.',
	'usersignup-error-symbols-in-username' => "Vaja, el teu nom d'usuari només pot contenir lletres i números.",
	'usersignup-error-empty-email' => 'Vaja, si us plau, escriu la teva adreça electrònica.',
	'usersignup-error-empty-username' => "Vaja, si us plau, emplena el camp de nom d'usuari.",
	'usersignup-error-already-confirmed' => 'Ja has confirmat aquesta adreça electrònica.',
	'usersignup-error-throttled-email' => 'Vaja, avui has sol·licitat masses missatges de confirmació. Intenta aquest cop en poc temps.',
	'usersignup-error-too-many-changes' => "Has arribat al límit màxim d'avui per canviar l'adreça electrònica. Si us plau, prova-ho més tard.",
	'usersignup-error-password-length' => 'La teva contrasenya és massa llarga. Escull una contrasenya de 50 caràcters o menys.',
	'usersignup-error-confirmed-user' => "Sembla que ja has confirmat l'adreça electrònica per a $1! Comprova el teu [$2 perfil d'usuari].", # Fuzzy
	'usersignup-facebook-heading' => "Acaba d'inscriure't",
	'usersignup-facebook-create-account' => 'Crear un compte',
	'usersignup-facebook-email-tooltip' => 'Si vols utilitzar una altra adreça electrònica, es pot canviar més tard en les teves preferències.',
	'usersignup-facebook-have-an-account-heading' => 'Ja tens un compte?',
	'usersignup-facebook-have-an-account' => "Connectar el teu nom d'usuari existent de Wikia amb el Facebook.",
	'usersignup-facebook-proxy-email' => 'Adreça electrònica anònim de Facebook',
	'usersignup-user-pref-emailconfirmlink' => "Sol·licita una nova confirmació d'adreça electrònica",
	'usersignup-user-pref-confirmemail_send' => 'Tornar a enviar la confirmació de la meva adreça electrònica',
	'usersignup-user-pref-emailauthenticated' => 'Gràcies! La teva adreça electrònica va ser confirmada en $2 a les $3.',
	'usersignup-user-pref-emailnotauthenticated' => "Comprova el teu correu electrònic i fes clic a l'enllaç de confirmació per acabar de canviar la teva adreça electrònica a:$1",
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Oh, no! La teva adreça electrònica no està confirmada. Les funcionalitats del correu electrònic no funcionaran fins que no confirmis la teva adreça electrònica.',
	'usersignup-user-pref-reconfirmation-email-sent' => "Ja gairebé! Hem enviat una nova confirmació a l'adreça $1. Comprova la teva adreça electrònica i fes clic a l'enllaç per acabar de confirmar la teva adreça de correu electrònic.",
	'usersignup-user-pref-noemailprefs' => 'Sembla que no tenim una adreça de correu electrònic per tu. Si us plau, introdueix una adreça de correu electrònic a dalt.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => "Oh, no! La teva adreça electrònica no està confirmada. Hem enviat un correu electrònic, fes clic a l'enllaç de confirmació per confirmar.",
	'usersignup-user-pref-confirmemail_noemail' => 'Sembla que no tenim una adreça de correu electrònic per tu. Vés a [[Special:Preferences| preferències]] per introduir-hi una.',
	'usersignup-confirm-page-title' => 'Confirma la teva adreça electrònica',
	'usersignup-confirm-page-title-wikiamobile' => 'Comprovar correu electrònic',
	'usersignup-confirm-email-resend-email' => "Enviar-me una altra confirmació d'adreça electrònica",
	'usersignup-confirm-email-change-email-content' => 'Vull utilitzar una adreça electrònica diferent.',
	'usersignup-confirm-email-change-email' => 'Canviar la meva adreça electrònica',
	'usersignup-confirm-email-new-email-label' => 'Nou correu electrònic',
	'usersignup-confirm-email-update' => 'Actualitza',
	'usersignup-confirm-email-tooltip' => "Has escrit una adreça electrònica que no pots confirmar o vols utilitzar una adreça diferent? No et preocupis, utilitza l'enllaç de sota per canviar la teva adreça electrònica i rebre una confirmació nova.",
	'usersignup-resend-email-heading-success' => 'Nou correu electrònic enviat',
	'usersignup-resend-email-heading-failure' => 'Correo electrònic no reenviat',
	'usersignup-confirm-page-heading-confirmed-user' => 'Felicitats!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Ja estàs confirmat',
	'usersignup-confirmation-heading' => 'Ja gairebé!',
	'usersignup-confirmation-heading-wikiamobile' => 'Comprova el teu correu electrònic',
	'usersignup-confirmation-heading-email-resent' => 'Nou correu electrònic enviat',
	'usersignup-confirmation-subheading' => 'Comprova el teu correu electrònic',
	'usersignup-confirmation-email-sent' => "Hem enviat un correu electrònic a '''$1'''.

Fes clic en l'enllaç de confirmació en la teva adreça per a acabar de crear el teu compte.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Hem enviat un correu electrònic a '''$1'''.

Fes clic en l'enllaç de confirmació en la teva adreça per a acabar de crear el teu compte. Gràcies!",
	'usersignup-reconfirmation-email-sent' => 'La teva adreça electrònica ha estat canviada a $1. Hem enviat un nou missatge de confirmació. Si us plau, confirma la nova adreça de correu electrònic.',
	'usersignup-reconfirmation-email-content' => 'Si us plau, fes clic en el enllaç de sota per confirmar el canvi d\'adreça electrònica en Wikia.
<br /><br />
<a style="color:#2C85D5;" href="$CONFIRMURL">$CONFIRMURL</a>
<br /><br />
Seguiràs rebent missatges en la teva adreça electrònica vella fins que confirmis aquest altre.',
	'usersignup-reconfirmation-email_body' => "Hola $2,

Si us plau, fes clic en l'enllaç de sota per confirmar el canvi d'adreça electrònica en Wikia.

$3

Seguiràs rebent missatges en la teva adreça electrònica vella fins que confirmis aquesta altre.

L'Equip de Wikia


___________________________________________

Para ver las noticias más recientes en Wikia, visita http://es.wikia.com
¿Quieres controlar los mensajes que recibes?? Ve a: {{fullurl:{{ns:special}}:Preferencias}}",
	'usersignup-welcome-email-subject' => 'Benvingut a Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hola $USERNAME',
	'usersignup-welcome-email-heading' => 'Estem encantats de donar-te la benvinguda a Wikia i a {{SITENAME}}! Aquí hi ha algunes coses que pots fer per començar.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edita el teu perfil.',
	'usersignup-welcome-email-edit-profile-content' => 'Afegeix una imatge de perfil i altres coses més sobre tu en el teu perfil de {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Anar al teu perfil',
	'usersignup-welcome-email-learn-basic-heading' => 'Aprèn els conceptes bàsics.',
	'usersignup-welcome-email-learn-basic-content' => "Aconsegueix un tutorial ràpid sobre els conceptes bàsics de Wikia; com editar una pàgina, el teu perfil d'usuari, canviar les teves preferències i molt més.",
	'usersignup-welcome-email-learn-basic-button' => "Fes-li un cop d'ull!",
	'usersignup-welcome-email-explore-wiki-heading' => 'Explora més wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'Hi ha milers de viquis a Wikia, trobeu-ne més que us interessin a algun dels nostres centres: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Videojocs</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Entreteniment</a>, o <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Estil de vida</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Anar a ca.wikia.com',
	'usersignup-welcome-email-content' => 'Vols més informació? Troba consells i respostes en la comunitat de Wikia <a style="color:#2C85D5;" href="http://ca.wikia.com">Wikia en Català</a>.',
	'usersignup-welcome-email-signature' => "L'Equip de Wikia",
	'usersignup-welcome-email-body' => 'Hola $USERNAME,

Et donem la benvinguda a Wikia i a {{SITENAME}}! Aquí tens algunes coses que pots fer per començar.

Edita el teu perfil.

Afegeix una foto al perfil i una petita descripció sobre tu mateix al teu perfil de {{SITENAME}}.

Vés a $EDITPROFILEURL

Aprèn els conceptes bàsics.

Visita un breu tutorial sobre els conceptes bàsics de Wikia: com editar una pàgina, el teu perfil d\'usuari, canviar les teves preferències, i més.

Comprova-ho ($LEARNBASICURL)

Explora més viquis.

Hi ha milers de viquis a Wikia, troba les que et poden interessar a algun dels nostres centres: Videojocs (http://www.wikia.com/Video_Games), Entreteniment (http://www.wikia.com/Entertainment), o Estil de vida (http://www.wikia.com/Lifestyle).

Vés a $EXPLOREWIKISURL

Necessites més informació? Troba consells, respostes i la comunitat Wikia a la Central de la Comunitat (http://www.community.wikia.com). Que t\'ho passis bè editant!

L\'equip de Wikia


___________________________________________

Per veure les últimes actualitzacions a Wikia, visita http://community.wikia.com
Vols controlar quins correus electrònics vols rebre? Vés a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Uneix-te avui a Wikia',
	'usersignup-heading-byemail' => 'Crear un compte per algú altre',
	'usersignup-marketing-wikia' => 'Comença a col·laborar amb milions de persones de tot el mon qui es reuneixen per compartir el que coneixen i estimen.',
	'usersignup-marketing-login' => 'Ja ets un usuari? [[Special:UserLogin|Inicia sessió]]',
	'usersignup-marketing-benefits' => 'Sigues part de quelcom enorme',
	'usersignup-marketing-community-heading' => 'Col·labora',
	'usersignup-marketing-community' => 'Descobreix i explora temes que van des de videojocs fins pel·lícules i televisió. Coneix gent amb interessos i passions similars.',
	'usersignup-marketing-global-heading' => 'Crear',
	'usersignup-marketing-global' => "Comença un wiki. Comença amb poc i creix amb l'ajuda d'altres.",
	'usersignup-marketing-creativity-heading' => 'Sigues original',
	'usersignup-marketing-creativity' => "Fes servir Wikia per expressar la teva creativitat amb enquestes i llistes, galeries d'imatges i vídeos, aplicacions i més.",
	'usersignup-createaccount-byemail' => 'Crea un compte per algú altre',
	'usersignup-error-captcha' => 'La paraula que has ingressat no coincideix amb la paraula en la caixa, intenta-ho de nou!', # Fuzzy
	'usersignup-account-creation-heading' => 'Llest!',
	'usersignup-account-creation-subheading' => 'Hem enviat un correu electrònic a $1',
	'usersignup-account-creation-email-sent' => "Has començat el procés de creació d'un compte per $2. Hem enviat un correu a $1 amb una contrasenya temporal i l'enllaç de confirmació.

$2 tindrà que fer clic en l'enllaç del correu que li vam enviar per confirmar el seu compte i canviar la contrasenya temporal per acabar de crear el compte.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Crear més comptes] en {{SITENAME}}",
	'usersignup-account-creation-email-subject' => "S'ha creat un compte per tu en Wikia!",
	'usersignup-account-creation-email-greeting' => 'Hola,',
	'usersignup-account-creation-email-content' => 'S\'ha creat un compte per tu en {{SITENAME}}. Per accedir al vostre compte i canviar la contrasenya temporal fes clic en l\'enllaç de sota i inicia sessió amb el nom d\'usuari "$USERNAME" i la contrasenya "$NEWPASSWORD".

Si us plau, inicia sessió en <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl: {{ns:special}}: UserLogin}}</a>

Si no volies crear aquest compte simplement ignora aquest correu o contacta amb el nostre Equip de Suport de la Comunitat amb qualsevol pregunta.',
	'usersignup-account-creation-email-signature' => "L'Equip de Wikia",
	'usersignup-account-creation-email-body' => 'Hola,

S\'ha creat un compte per tu en {{SITENAME}}. Per accedir al teu compte i canviar la contrasenya temporal fes clic en l\'enllaç de sota i inicia sessió amb el nom d\'usuari "$2" i la contrasenya "$3".

Si us plau, inicia sesió en {{fullurl:{{ns:special}}:UserLogin}}

Si no volies crear aquest compte simplement ignora aquest correu o contacta amb el nuestre Equipo de Suport de la Comunitat amb qualsevol pregunta.

L\'Equip de Wikia


___________________________________________
Per veure les noticies més recents en Wikia, visita http://ca.wikia.com
¿Vols controlar els missatges que reps? Vés a: {{fullurl:{{ns:special}}:Preferències}}',
	'usersignup-facebook-problem' => 'Hi ha hagut un problema de comunicació amb Facebook. Si us plau, torna-ho a provar altre cop més tard.',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'usersignup-confirm-email-update' => 'Карлаяккха',
	'usersignup-resend-email-heading-success' => 'Керла хаам дӀабахийтина',
	'usersignup-welcome-email-learn-basic-button' => 'Дехьа гӀо',
);

/** Czech (čeština)
 * @author Chmee2
 * @author Macinosak
 * @author Mormegil
 * @author Vks
 */
$messages['cs'] = array(
	'usersignup-page-title' => 'Připojte sedo Wikie',
	'usersignup-page-captcha-label' => 'Rozmazané slovo', # Fuzzy
	'usersignup-error-username-length' => 'Pozor, vaše uživatelské jméno nemůže být delší než {{PLURAL:$1|jeden znak|$1 znaky|$1 znaků}}.',
	'usersignup-error-invalid-user' => 'Neplatný uživatel. Nejprve se prosím přihlašte.',
	'usersignup-error-invalid-email' => 'Zadejte prosím platnou e-mailovou adresu.',
	'usersignup-error-symbols-in-username' => 'Pozor, vaše uživatelské jméno může obsahovat pouze písmena a číslice.',
	'usersignup-error-empty-email' => 'Vyplňte prosím vaši e-mailovou adresu.',
	'usersignup-error-empty-username' => 'Ups, vyplňte prosím políčko s uživatelským jménem.',
	'usersignup-error-already-confirmed' => 'Už jste potvrdil tuto e-mailovou adresu.',
	'usersignup-error-throttled-email' => 'Pozor, už jste dnes žádal o příliš mnoho potvrzujících e-mailů. Opakujte akci za chvíli.',
	'usersignup-error-too-many-changes' => 'Dosáhl jste dnes maximálního počtu změn e-mailu. Zkuste to prosím později.',
	'usersignup-error-password-length' => 'Pozor, vaše heslo je příliš dlouhé. Zvolte heslo, které má 50 znaků nebo méně.',
	'usersignup-error-confirmed-user' => 'Zdá se, že už jste e-mailovou adresu pro $1 potvrdili! Zkontrolujte svůj [$2 uživatelský profil].', # Fuzzy
	'usersignup-facebook-heading' => 'Dokončení přihlášení',
	'usersignup-facebook-create-account' => 'Vytvořit účet',
	'usersignup-facebook-email-tooltip' => 'Pokud chcete použít jinou e-mailovou adresu, můžete ji změnit později ve vašem nastavení.',
	'usersignup-facebook-have-an-account-heading' => 'Máte již účet?',
	'usersignup-facebook-have-an-account' => 'Místo toho připojte stávající uživatelské jméno Wikia s Facebookem.',
	'usersignup-facebook-proxy-email' => 'Anonymní e-mail Facebooku',
	'usersignup-user-pref-emailconfirmlink' => 'Požádat o nový potvrzující e-mail',
	'usersignup-user-pref-confirmemail_send' => 'Znovu odeslat mé potvrzení e-mailu',
	'usersignup-user-pref-emailauthenticated' => 'Díky! Váš email byl potvrzen $2  v  $3 .',
	'usersignup-user-pref-emailnotauthenticated' => 'Zkontrolujte svůj e-mail a klikněte na potvrzující odkaz k dokončení změny vašeho e-mailu na: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Ale ne! Váš e-mail není potvrzen. E-mailové funkce nebudou fungovat, dokud nepotvrdíte vaši e-mailovou adresu.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Už to bude! Poslali jsme nový potvrzující e-mail na $1. Zkontrolujte svůj e-mail a klikněte na odkaz k dokončení potvrzení vaši e-mailové adresy.',
	'usersignup-confirm-page-title' => 'Potvrzení e-mailu',
	'usersignup-confirm-email-resend-email' => 'Pošlete mi další potvrzovací e-mail',
	'usersignup-confirm-email-change-email-content' => 'Chci použít jinou e-mailovou adresu.',
	'usersignup-confirm-email-change-email' => 'Změňit mou e-mailovou adresu',
	'usersignup-confirm-email-new-email-label' => 'Nový e-mail',
	'usersignup-confirm-email-update' => 'Aktualizovat',
	'usersignup-resend-email-heading-success' => 'Nový e-mail odeslán',
	'usersignup-resend-email-heading-failure' => 'Email nebyl znovu přeposlán.',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gratulujeme!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Vaše e-mailová adresa je už ověřená',
	'usersignup-confirmation-heading' => 'Už to bude!',
	'usersignup-confirmation-heading-email-resent' => 'Nový e-mail odeslán',
	'usersignup-confirmation-subheading' => 'Zkontrolujte si e-maily',
	'usersignup-reconfirmation-email-sent' => 'Vaše e-mailová adresa byla změněna na  $1. Poslali jsme vám nový email k potvrzení. Prosím, potvrďte novou e-mailovou adresu.',
	'usersignup-welcome-email-subject' => 'Vítejte na Wikii, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Ahoj $USERNAME',
	'usersignup-welcome-email-edit-profile-heading' => 'Upravte svůj profil.',
	'usersignup-welcome-email-edit-profile-button' => 'Jít do profilu',
	'usersignup-welcome-email-learn-basic-heading' => 'Naučte se základy.',
	'usersignup-welcome-email-explore-wiki-button' => 'Přejít na wikia.com',
	'usersignup-heading' => 'Připojte se dnes k Wikii',
	'usersignup-heading-byemail' => 'Vytvořit účet pro někoho jiného',
	'usersignup-marketing-benefits' => 'Staňte se součástí něčeho velkého',
	'usersignup-marketing-community-heading' => 'Spolupráce',
	'usersignup-marketing-global-heading' => 'Vytvořit',
	'usersignup-marketing-creativity-heading' => 'Buď originální',
	'usersignup-createaccount-byemail' => 'Vytvořit účet pro někoho jiného',
	'usersignup-account-creation-heading' => 'Úspěch!',
	'usersignup-account-creation-subheading' => 'Email poslán uživateli $1',
	'usersignup-account-creation-email-subject' => 'Účet pro vaši Wikii byl vytvořen!',
	'usersignup-account-creation-email-greeting' => 'Ahoj,',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Thefartydoctor
 */
$messages['cy'] = array(
	'usersignup-page-captcha-label' => 'Gair Aneglur', # Fuzzy
	'usersignup-facebook-create-account' => 'Creu cyfrif',
	'usersignup-confirm-page-heading-confirmed-user' => 'Llongyfarchion!',
	'usersignup-welcome-email-subject' => 'Croeso i Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Helo $USERNAME',
	'usersignup-welcome-email-signature' => 'Y Tîm Wikia',
	'usersignup-account-creation-email-greeting' => 'Helo,',
	'usersignup-account-creation-email-signature' => 'Y Tîm Wikia',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author PtM
 */
$messages['de'] = array(
	'usersignup-page-title' => 'Mach mit bei Wikia',
	'usersignup-page-title-wikiamobile' => 'Benutzerkonto erstellen',
	'usersignup-page-captcha-label' => 'Herausforderung',
	'usersignup-error-username-length' => 'Der Benutzername darf nicht länger als {{PLURAL:$1|ein Zeichen|$1 Zeichen}} sein.',
	'usersignup-error-invalid-user' => 'Ungültiger Benutzer. Bitte zuerst anmelden.',
	'usersignup-error-invalid-email' => 'Bitte eine gültige E-Mail-Adresse angeben.',
	'usersignup-error-symbols-in-username' => 'Der Benutzername darf nur Buchstaben und Ziffern enthalten.',
	'usersignup-error-empty-email' => 'Bitte gib eine E-Mail-Adresse ein.',
	'usersignup-error-empty-username' => 'Kein Benutzername angegeben.',
	'usersignup-error-already-confirmed' => 'Diese E-Mail-Adresse ist bereits bestätigt.',
	'usersignup-error-throttled-email' => 'Es wurden zuviele Bestätigungs-E-Mails am selben Tag angefordert, bitte später noch einmal probieren.',
	'usersignup-error-too-many-changes' => 'Für heute wurde das Maximum an Änderungen der Mail-Adresse erreicht, bitte später noch einmal probieren.',
	'usersignup-error-password-length' => 'Das Passwort darf nicht länger als 50 Zeichen sein.',
	'usersignup-error-confirmed-user' => 'Scheinbar ist die E-Mail-Adresse als $1 bereits bestätigt! Bitte in den [$2 Einstellungen] nachsehen.',
	'usersignup-facebook-heading' => 'Anmeldung abschließen',
	'usersignup-facebook-create-account' => 'Benutzerkonto anlegen',
	'usersignup-facebook-email-tooltip' => 'Die E-Mail-Adresse kann später auch noch in den Einstellungen zu einer anderen Adresse geändert werden.',
	'usersignup-facebook-have-an-account-heading' => 'Konto vorhanden?',
	'usersignup-facebook-have-an-account' => 'Verknüpfe dein Wikia-Benutzerkonto stattdessen mit Facebook.',
	'usersignup-facebook-proxy-email' => 'Anonyme Facebook E-Mail',
	'usersignup-user-pref-emailconfirmlink' => 'Neue Bestätigungs-Mail anfordern',
	'usersignup-user-pref-confirmemail_send' => 'Bestätigungs-E-Mail erneut senden',
	'usersignup-user-pref-emailauthenticated' => 'Danke! Die E-Mail wurde am $2 um $3 bestätigt.',
	'usersignup-user-pref-emailnotauthenticated' => 'Überprüfe deine E-Mails und klicke auf den Bestätigungslink, um auf folgende Mailadresse zu wechseln: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Achtung, deine E-Mail-Adresse ist nicht bestätigt. Mail-Dienste werden nicht funktionieren, bis dies nachgeholt wird.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Beinahe fertig! Es wurde eine neue Bestätigungsmail an $1 versandt. Prüfe deine E-Mails und klicke den Link, um deine Adresse zu bestätigen.',
	'usersignup-user-pref-noemailprefs' => 'Offenbar haben wir deine E-Mail-Adresse nicht. Bitte gib oben eine ein.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Deine Mail-Adresse ist nicht bestätigt. Du solltest eine E-Mail mit Bestätigungslink zum Draufklicken erhalten haben.',
	'usersignup-user-pref-confirmemail_noemail' => 'Offenbar haben wir deine E-Mail-Adresse nicht. Bitte gib in deinen [[Special:Preferences|Nutzereinstellungen]] eine ein.',
	'usersignup-confirm-page-title' => 'E-Mail-Adresse bestätigen',
	'usersignup-confirm-page-title-wikiamobile' => 'Überprüfe deine E-Mails',
	'usersignup-confirm-email-resend-email' => 'Bitte eine neue Bestätigungsmail senden',
	'usersignup-confirm-email-change-email-content' => 'Ich möchte eine andere E-mail-Adresse verwenden.',
	'usersignup-confirm-email-change-email' => 'E-Mail-Adresse ändern',
	'usersignup-confirm-email-new-email-label' => 'Neue E-Mail',
	'usersignup-confirm-email-update' => 'Aktualisieren',
	'usersignup-confirm-email-tooltip' => 'Kannst du die von dir angegebene Mail-Adresse nicht bestätigen, oder willst du einfach eine andere Adresse benutzen? Kein Problem, nutze den untenstehenden Link und ändere deine Mail-Adresse, sodass du eine neue Bestätigungsmail erhältst.',
	'usersignup-resend-email-heading-success' => 'Neue E-Mail versandt',
	'usersignup-resend-email-heading-failure' => 'E-Mail nicht erneut versandt',
	'usersignup-confirm-page-heading-confirmed-user' => 'Glückwunsch!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Bereits bestätigt',
	'usersignup-confirmation-heading' => 'Beinahe fertig',
	'usersignup-confirmation-heading-wikiamobile' => 'Überprüfe deine E-Mails',
	'usersignup-confirmation-heading-email-resent' => 'Neue E-Mail versandt',
	'usersignup-confirmation-subheading' => 'E-Mails nachsehen',
	'usersignup-confirmation-email-sent' => "Wir haben eine Mail an '''$1''' versandt.

Klicke den Bestätigungslink in deiner E-Mail, um das Anlegen des Benutzerkontos abzuschließen.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Wir haben eine E-Mail an '''$1''' versandt.

Klicke auf den Bestätigungslink in deiner E-Mail, um die Erstellung deines Benutzerkontos abzuschließen. Danke!",
	'usersignup-reconfirmation-email-sent' => 'Deine E-Mail-Adresse wurde zu $1 geändert. Wir haben eine neue Bestätigungsmail versandt. Bitte bestätige die neue Mail-Adresse.',
	'usersignup-welcome-email-subject' => 'Willkommen bei Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hallo $USERNAME',
	'usersignup-welcome-email-heading' => 'Wir freuen uns, dich bei Wikia und {{SITENAME}} willkommen zu heißen! Hier nun eine paar Dinge, mit denen du loslegen kannst.',
	'usersignup-welcome-email-edit-profile-heading' => 'Bearbeite dein Profil.',
	'usersignup-welcome-email-edit-profile-content' => 'Füge deinem Profil auf {{SITENAME}} ein Profilbild und eine paar kurze Fakten über dich hinzu.',
	'usersignup-welcome-email-edit-profile-button' => 'Zum Profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Grundlagen erlernen.',
	'usersignup-welcome-email-learn-basic-content' => 'Erhalte ein kurze Einführung in die Basics von Wikia: Seiten bearbeiten, dein Nutzerprofil, deine Einstellungsmöglichkeiten, und mehr.',
	'usersignup-welcome-email-learn-basic-button' => 'Anschauen',
	'usersignup-welcome-email-explore-wiki-heading' => 'Weitere Wikias entdecken.',
	'usersignup-welcome-email-explore-wiki-content' => 'Es gibt tausende von Wikias bei Wikia, du kannst interessante Wikias in unseren Hubs finden: <a style="color:#2C85D5;" href="http://de.wikia.com/Videospiele">Videospiele</a>, <a style="color:#2C85D5;" href="http://de.wikia.com/Entertainment">Entertainment</a>, oder <a style="color:#2C85D5;" href="http://de.wikia.com/Lifestyle">Lifestyle</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Besuche de.wikia.com',
	'usersignup-welcome-email-content' => 'Willst du mehr erfahren? Finde Tips, Antworten und die Wikia-Community im <a style="color:#2C85D5;" href="http://de.community.wikia.com">Community-Wiki</a>. Frohes Schreiben!',
	'usersignup-welcome-email-signature' => 'Das Wikia-Team',
	'usersignup-welcome-email-body' => 'Hallo $USERNAME,

Wir freuen uns, dich bei Wikia und {{SITENAME}} willkommen zu heißen! Hier nun eine paar Dinge, mit denen du loslegen kannst.

Bearbeite dein Profil.

Füge deinem Profil auf {{SITENAME}} ein Profilbild und eine paar kurze Fakten über dich hinzu.

Zu $EDITPROFILEURL

Grundlagen erlernen.

Erhalte ein kurze Einführung in die Basics von Wikia: Seiten bearbeiten, dein Nutzerprofil, deine Einstellungsmöglichkeiten, und mehr.

Schaus dir an ($LEARNBASICURL)

Weitere Wikias entdecken.

Es gibt tausende von Wikis bei Wikia, du kannst interessante Wikis in unseren Hubs finden: Videospiele (http://de.wikia.com/Videospiele), Entertainment (http://de.wikia.com/Entertainment) oder Lifestyle (http://de.wikia.com/Lifestyle).

Besuche $EXPLOREWIKISURL

Willst du mehr erfahren? Finde Tips, Antworten und die Wikia-Community im Community-Wiki (http://de.community.wikia.com). Frohes Schreiben!

Das Wikia-Team


Um dich zu Wikia auf dem aktuellen Stand zu halten, besuche http://de.community.wikia.com
Steuere, welche E-Mails du von uns erhalten willst, auf {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Wikia noch heute beitreten',
	'usersignup-heading-byemail' => 'Ein Konto für jemand anderen erstellen',
	'usersignup-marketing-wikia' => 'Beginne die Zusammenarbeit mit Tausenden von Menschen aus aller Welt, die sich zusammentun um zu teilen, was sie kennen und lieben.',
	'usersignup-marketing-login' => 'Konto vorhanden? [[Special:UserLogin|Melde dich an]]',
	'usersignup-marketing-benefits' => 'Sei Teil von etwas Großem',
	'usersignup-marketing-community-heading' => 'Wirke mit',
	'usersignup-marketing-community' => 'Entdecke Themen von Videospielen hin zu Film und Fernsehen. Lerne Menschen mit gleichen Interessen und Leidenschaften kennen.',
	'usersignup-marketing-global-heading' => 'Erstellen',
	'usersignup-marketing-global' => 'Starte ein Wiki. Beginne klein und wachse mit der Hilfe Anderer.',
	'usersignup-marketing-creativity-heading' => 'Sei originell',
	'usersignup-marketing-creativity' => 'Nutze Wikia und bringe deine Kreativität über Umfragen und Top-10-Listen, Foto- und Video-Galerien, Apps und mehr zum Ausdruck',
	'usersignup-createaccount-byemail' => 'Ein Konto für jemand anderen erstellen',
	'usersignup-error-captcha' => 'Die Herausforderungsantwort ist fehlgeschlagen, bitte erneut versuchen!',
	'usersignup-account-creation-heading' => 'Erfolg!',
	'usersignup-account-creation-subheading' => 'Wir haben eine E-Mail an $1 geschickt.',
	'usersignup-account-creation-email-sent' => 'Du hast die Erstellung eines Benutzerkontos für $2 eingeleitet. Wir haben eine Mail an $1 mit einem temporären Passwort und einem Bestätigungslink versandt.


$2 muss den Link in unserer Mail klicken, um das Benutzerkonto zu bestätigen und das temporäre Passwort ändern, um die Kontoerstellung abzuschließen.

[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Erstelle weitere Konten] auf {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Für dich wurde auf Wikia ein Benutzerkonto angelegt!',
	'usersignup-account-creation-email-greeting' => 'Hallo,',
	'usersignup-account-creation-email-content' => 'Auf {{SITENAME}} ist für dich ein Benutzerkonto erstellt worden. Zum Zugriff darauf und dem Ändern des temporären Passworts klicke auf den unteren Link und melde dich mit den Namen "$USERNAME" und dem Passwort "$NEWPASSWORD" an.

Zum Anmelden bitte auf <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a> klicken

Falls du die Anlage dieses Kontos nicht gewünscht hast, kannst du diese Mail einfach ignorieren oder bei Fragen unseren Community-Support kontaktieren.',
	'usersignup-account-creation-email-signature' => 'Das Wikia-Team',
	'usersignup-account-creation-email-body' => 'Hallo,

Auf {{SITENAME}} ist für dich ein Benutzerkonto erstellt worden. Zum Zugriff darauf und dem Ändern des temporären Passworts klicke auf den unteren Link und melde dich mit den Namen "$2" und dem Passwort "$3" an.

Zum Anmelden bitte {{fullurl:{{ns:special}}:UserLogin}} aufsuchen

Falls du die Anlage dieses Kontos nicht gewünscht hast, kannst du diese Mail einfach ignorieren oder bei Fragen unseren Community-Support kontaktieren.

Das Wikia-Team


___________________________________________

Um dich zu Wikia auf dem aktuellen Stand zu halten, besuche http://de.community.wikia.com
Steuere, welche E-Mails du von uns erhalten willst, auf {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Es gab ein Problem bei der Kommunikation mit Facebook. Bitte versuche es später noch einmal.',
	'usersignup-facebook-signup-header' => 'Ein neues Benutzerkonto erstellen?',
	'usersignup-facebook-login-header' => 'Hast du bereits ein Benutzerkonto?',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Gorizon
 * @author Mirzali
 */
$messages['diq'] = array(
	'usersignup-page-title' => 'Dekew Wikia',
	'usersignup-confirm-page-title' => 'Epostay xo araşt kerê',
	'usersignup-confirm-email-new-email-label' => 'Epostaya newi',
	'usersignup-confirm-email-update' => 'Rocane ke',
	'usersignup-confirm-page-heading-confirmed-user' => 'Tebrik keme!',
	'usersignup-welcome-email-greeting' => 'Merheba $USERNAME,',
	'usersignup-welcome-email-edit-profile-heading' => 'Profilê xo bıvurne',
	'usersignup-welcome-email-edit-profile-button' => 'Şo ri profil',
	'usersignup-welcome-email-explore-wiki-button' => 'Şo wikia.com',
	'usersignup-welcome-email-signature' => 'Taxıma Wikia',
	'usersignup-heading' => 'Ewro Wikiya kewe',
	'usersignup-marketing-community-heading' => 'Piyakarkerdış',
	'usersignup-marketing-global-heading' => 'Vıraze',
	'usersignup-marketing-creativity-heading' => 'Oricinal be',
	'usersignup-account-creation-email-greeting' => 'Merheba,',
	'usersignup-account-creation-email-signature' => 'Taxıma Wikia',
);

/** Spanish (español)
 * @author Fitoschido
 * @author Macofe
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'usersignup-page-title' => 'Únete a Wikia',
	'usersignup-page-title-wikiamobile' => 'Crear una cuenta',
	'usersignup-page-captcha-label' => 'Reto',
	'usersignup-error-username-length' => '¡Arg! Tu nombre de usuario no puede ser más de {{PLURAL:$1|un caracter|$1 caracteres}}.',
	'usersignup-error-invalid-user' => 'El usuario no es válido. Inicia sesión primero.',
	'usersignup-error-invalid-email' => 'Por favor escribe una dirección de correo electrónico válida.',
	'usersignup-error-symbols-in-username' => '¡Vaya! Tu nombre de usuario sólo puede contener letras y números.',
	'usersignup-error-empty-email' => '¡Ups! Por favor escribe tu dirección de correo electrónico.',
	'usersignup-error-empty-username' => 'Esto... por favor rellena el campo de nombre de usuario.',
	'usersignup-error-already-confirmed' => 'Ya has confirmado este correo electrónico.',
	'usersignup-error-throttled-email' => '¿Qué ha pasado? Has solicitado demasiados mensajes de confirmación por hoy. Inténtalo de nuevo más tarde.',
	'usersignup-error-too-many-changes' => 'Has alcanzado el límite máximo de hoy para cambiar el correo electrónico. Por favor, inténtalo de nuevo más tarde.',
	'usersignup-error-password-length' => 'Eso fue un poco exagerado. Tu contraseña es demasiado larga. Elige una contraseña de 50 caracteres o menos.',
	'usersignup-error-confirmed-user' => '¡Parece que ya has confirmado tu dirección de correo electrónico para $1! Revisa tu [$2 perfil de usuario].',
	'usersignup-facebook-heading' => 'Termina de registrarte',
	'usersignup-facebook-create-account' => 'Crear una cuenta',
	'usersignup-facebook-email-tooltip' => 'Si deseas utilizar un correo electrónico diferente, puedes cambiarlo después en tus preferencias.',
	'usersignup-facebook-have-an-account-heading' => '¿Ya tienes una cuenta?',
	'usersignup-facebook-have-an-account' => 'Vincula tu cuenta de usuario en Wikia con Facebook.',
	'usersignup-facebook-proxy-email' => 'Correo electrónico anónimo de Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Solicitar un nuevo correo electrónico de confirmación',
	'usersignup-user-pref-confirmemail_send' => 'Reenviar mi correo electrónico de confirmación',
	'usersignup-user-pref-emailauthenticated' => '¡Gracias! Tu correo electrónico fue confirmado el $2 a las $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Revisa tu correo electrónico y haz clic en el enlace de confirmación para terminar de cambiar tu correo a: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => '¡Oh, no! Tu correo electrónico no está confirmado. Las funcionalidades del correo electrónico no funcionarán hasta que confirmes tu dirección.',
	'usersignup-user-pref-reconfirmation-email-sent' => '¡Ya casi está! Hemos enviado una nueva confirmación al correo $1. Revisa tu correo electrónico y haz clic en el enlace para terminar de confirmar tu correo electrónico.',
	'usersignup-user-pref-noemailprefs' => 'Parece que no tenemos una dirección de correo electrónico para ti. Por favor escribe una dirección de correo electrónico arriba.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => '¡Horror! Tu dirección de correo electrónico no está confirmada. Te hemos enviado un correo electrónico, haz clic en el enlace de confirmación para confirmarla.',
	'usersignup-user-pref-confirmemail_noemail' => 'Parece que no tenemos una dirección de correo electrónico para ti. Ve a tus [[Special:Preferences|preferencias]] para introducir uno.',
	'usersignup-confirm-page-title' => 'Confirma tu dirección de correo electrónico',
	'usersignup-confirm-page-title-wikiamobile' => 'Comprueba tu correo electrónico',
	'usersignup-confirm-email-resend-email' => 'Envíame otro email de confirmación',
	'usersignup-confirm-email-change-email-content' => 'Quiero usar una dirección de correo electrónico diferente.',
	'usersignup-confirm-email-change-email' => 'Cambiar mi dirección de correo electrónico',
	'usersignup-confirm-email-new-email-label' => 'Nuevo correo electrónico',
	'usersignup-confirm-email-update' => 'Actualizar',
	'usersignup-confirm-email-tooltip' => '¿Introdujiste una dirección de correo electrónico que no puedes confirmar, o quieres usar una dirección de correo electrónico diferente? Que no cunda el pánico, usa el enlace de abajo para cambiar tu dirección de email y obtener un nuevo email de confirmación.',
	'usersignup-resend-email-heading-success' => 'Nuevo correo electrónico enviado',
	'usersignup-resend-email-heading-failure' => 'Correo electrónico no reenviado',
	'usersignup-confirm-page-heading-confirmed-user' => '¡Felicidades!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'La cuenta ya está confirmada',
	'usersignup-confirmation-heading' => 'Casi está hecho',
	'usersignup-confirmation-heading-wikiamobile' => 'Revisa tu correo electrónico',
	'usersignup-confirmation-heading-email-resent' => 'Enviado nuevo correo electrónico',
	'usersignup-confirmation-subheading' => 'Revisa tu correo electrónico',
	'usersignup-confirmation-email-sent' => "Enviamos un correo electrónico a '''$1'''.

Haz clic en el enlace de confirmación en el correo electrónico para terminar el proceso de creación de tu cuenta.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Enviamos un correo electrónico a '''$1'''.

Haz clic en el enlace de confirmación en el correo electrónico para terminar el proceso de creación de tu cuenta. ¡Gracias!",
	'usersignup-reconfirmation-email-sent' => 'Tu correo electrónico ha sido cambiado a $1. Hemos enviado un nuevo mensaje de confirmación. Por favor confirma la nueva dirección de correo electrónico.',
	'usersignup-welcome-email-subject' => '¡Bienvenido a Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hola $USERNAME',
	'usersignup-welcome-email-heading' => '¡Estamos encantados de darte la bienvenida a Wikia y a {{SITENAME}}! Aquí hay algunas cosas que puedes hacer para comenzar.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edita tu perfil.',
	'usersignup-welcome-email-edit-profile-content' => 'Añade una imagen de perfil y otras cosas más sobre ti en tu perfil de {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Ir al perfil',
	'usersignup-welcome-email-learn-basic-heading' => 'Aprende los conceptos básicos.',
	'usersignup-welcome-email-learn-basic-content' => 'Obtén un tutorial rápido sobre los conceptos básicos de Wikia; cómo editar una página, tu perfil de usuario, cambiar tus preferencias y mucho más.',
	'usersignup-welcome-email-learn-basic-button' => '¡Échale un vistazo!',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explora más wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'Hay miles de wikias en Wikia, encuentra más comunidades que te interesen revisando nuestras categorías: <a style="color:#2C85D5;" href="http://es.wikia.com/Videojuegos">Videojuegos</a>, <a style="color:#2C85D5;" href="http://es.wikia.com/Entretenimiento">Entretenimiento</a>, o <a style="color:#2C85D5;" href="http://es.wikia.com/Estilo_de_vida">Estilo de vida</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Ir a es.wikia.com',
	'usersignup-welcome-email-content' => '¿Quieres más información? Encuentra consejos, respuestas y a la comunidad de Wikia en <a style="color:#2C85D5;" href="http://comunidad.wikia.com">Comunidad Central</a>. ¡Diviértete editando!',
	'usersignup-welcome-email-signature' => 'El equipo de Wikia',
	'usersignup-welcome-email-body' => 'Hola $USERNAME,

¡Estamos felices de darte la bienvenida a Wikia y a {{SITENAME}}! Aquí hay algunas cosas que puedes hacer para comenzar.

Edita tu perfil.

Añade una imagen de perfil y otras cosas sobre ti en tu perfil de {{SITENAME}}.

Ve a $EDITPROFILEURL

Aprende conceptos básicos.

Hazte con los consejos básicos de Wikia: cómo editar una página, tu perfil de usuario, cambiar tus preferencias y mucho más.

Échale un vistazo a ($LEARNBASICURL)

Explora más wikias.

Hay miles de comunidades en Wikia, encuentra más wikias que te interesen revisando nuestras categorías: Videojuegos (http://es.wikia.com/Videojuegos), Entretenimiento (http://es.wikia.com/Entretenimiento), o Estilo de vida (http://es.wikia.com/Estilo_de_vida).

Ir a $EXPLOREWIKISURL

¿Quieres más información? Encuentra consejos y respuestas en la comunidad central de Wikia (http://www.comunidad.wikia.com). ¡Diviértete editando!

El Equipo de Wikia


___________________________________________

Para ver las noticias más recientes en Wikia, visita http://comunidad.wikia.com
¿Quieres controlar los mensajes que recibes?? Ve a: {{fullurl:{{ns:special}}:Preferencias}}',
	'usersignup-heading' => 'Únete hoy a Wikia',
	'usersignup-heading-byemail' => 'Crear una cuenta para alguien más',
	'usersignup-marketing-wikia' => 'Comienza a colaborar con millones de personas de todo el mundo, quienes se reúnen para compartir lo que conocen y aman.',
	'usersignup-marketing-login' => '¿Ya eres un usuario? [[Special:UserLogin|Inicia sesión]]',
	'usersignup-marketing-benefits' => 'Sé parte de algo grande',
	'usersignup-marketing-community-heading' => 'Colabora',
	'usersignup-marketing-community' => 'Descubre y explora temas que van desde videojuegos hasta películas y televisión. Conoce gente con intereses y pasiones similares.',
	'usersignup-marketing-global-heading' => 'Crea',
	'usersignup-marketing-global' => 'Comienza una wikia. Comienza con poco y crece con la ayuda de otros.',
	'usersignup-marketing-creativity-heading' => 'Sé original',
	'usersignup-marketing-creativity' => 'Usa Wikia para expresar tu creatividad con encuestas y listas, galerías de imágenes y vídeos, aplicaciones y más.',
	'usersignup-createaccount-byemail' => 'Crear una cuenta para alguien más',
	'usersignup-error-captcha' => 'La respuesta del reto ha fallado, ¡por favor inténtalo de nuevo!',
	'usersignup-account-creation-heading' => '¡Conseguido!',
	'usersignup-account-creation-subheading' => 'Hemos enviado un correo electrónico a $1',
	'usersignup-account-creation-email-sent' => 'Has comenzado el proceso de creación de una cuenta de usuario con el nombre $2. Hemos enviado un correo electrónico a $1 con una contraseña temporal y un enlace de confirmación.

El nuevo usuario, $2, necesitará hacer clic en el enlace del correo electrónico que le hemos enviado para confirmar su cuenta y cambiar su contraseña temporal para finalizar la creación de su cuenta.

[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Crear más cuentas] en {{SITENAME}}',
	'usersignup-account-creation-email-subject' => '¡Ha sido creada una cuenta de usuario para ti en Wikia!',
	'usersignup-account-creation-email-greeting' => 'Hola,',
	'usersignup-account-creation-email-content' => 'Has creado una nueva cuenta de usuario en {{SITENAME}}. Para acceder a tu cuenta y cambiar tu contraseña temporal, haz clic en el enlace de abajo e identifícate con tu nombre de usuario "$USERNAME" y la contraseña "$NEWPASSWORD".

Por favor, identifícate en <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Si no querías que esta cuenta fuese creada, puedes simplemente ignorar este correo electrónico o contactar con nuestro equipo de Soporte Comunitario y preguntarles.',
	'usersignup-account-creation-email-signature' => 'El equipo de Wikia',
	'usersignup-account-creation-email-body' => 'Hola,

Has creado una nueva cuenta de usuario en {{SITENAME}}. Para acceder a tu cuenta y cambiar tu contraseña temporal, haz clic en el enlace de abajo e identifícate con tu el nombre de usuario "$2" y la contraseña "$3".

Por favor, identifícate en {{fullurl:{{ns:special}}:UserLogin}}

Si no querías que esta cuenta fuese creada, puedes simplemente ignorar este correo electrónico o contactar con nuestro equipo de Soporte Comunitario y preguntarles.

El equipo de Wikia


___________________________________________

Para revisar qué es lo último que ha sucedido en Wikia, visita http://comunidad.wikia.com/
¿Quieres controlar qué correos electrónicos vas a recibir? Ve a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Hubo un problema de comunicación con Facebook. Inténtalo de nuevo más tarde.',
	'usersignup-facebook-signup-header' => '¿Creando una nueva cuenta?',
	'usersignup-facebook-login-header' => '¿Ya tienes una cuenta?',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Mjbmr
 * @author Movyn
 * @author Reza1615
 */
$messages['fa'] = array(
	'usersignup-page-title-wikiamobile' => 'ایجاد حساب کاربری',
	'usersignup-error-invalid-email' => 'لطفاً یک آدرس ایمیل معتبر وارد کنید.',
	'usersignup-facebook-create-account' => 'ایجاد حساب کاربری',
	'usersignup-user-pref-emailnotauthenticated' => 'ایمیل خود را چک کنید و برای تایید ایمیل خود و پایان تغییرات روی لینک تایید کلیک کنید. ایمیل: $1',
	'usersignup-confirm-email-change-email' => 'تغییر آدرس ایمیل من',
	'usersignup-confirm-email-update' => 'به روز رسانی',
	'usersignup-welcome-email-edit-profile-heading' => 'ویرایش مشخصات شما.',
	'usersignup-welcome-email-signature' => 'تیم ویکیا',
	'usersignup-marketing-community-heading' => 'همکاری',
	'usersignup-marketing-global-heading' => 'ایجاد',
	'usersignup-account-creation-email-greeting' => 'سلام،',
	'usersignup-account-creation-email-signature' => 'تیم ویکیا',
);

/** Finnish (suomi)
 * @author Lukkipoika
 * @author Nike
 * @author Ville96
 */
$messages['fi'] = array(
	'usersignup-page-title' => 'Liity Wikiaan',
	'usersignup-page-title-wikiamobile' => 'Luo käyttäjätili',
	'usersignup-page-captcha-label' => 'Testi',
	'usersignup-error-username-length' => 'Oho! Käyttäjänimessäsi ei voi olla enempää kuin {{PLURAL:$1|one character|$1 characters}}.',
	'usersignup-error-invalid-user' => 'Virheellinen käyttäjä. Kirjaudu ensin sisään.',
	'usersignup-error-invalid-email' => 'Kirjoita sopiva sähköpostiosoite.',
	'usersignup-error-symbols-in-username' => 'Oho, käyttäjänimi voi sisältää vain kirjaimia ja numeroita.',
	'usersignup-error-empty-email' => 'Oho! Lisää sähköpostiosoitteesi.',
	'usersignup-error-empty-username' => 'Oho! Lisää kenttään käyttäjänimesi.',
	'usersignup-error-already-confirmed' => 'Olet jo vahvistanut tämän sähköpostiosoitteen.',
	'usersignup-error-throttled-email' => 'Oho! Olet pyytänyt liikaa lähetettäväksi sähköpostin vahvistusviestejä Yritä uudelleen hetken päästä.',
	'usersignup-error-too-many-changes' => 'Olet jo tehnyt maksimimäärän sähköpostimuutoksia tänään. Yritä myöhemmin uudelleen.',
	'usersignup-error-password-length' => 'Oho! Salasanasi on liian pitkä. Valitse salasana, jossa on 50 merkkiä tai vähemmän.',
	'usersignup-error-confirmed-user' => "Looks like you've already confirmed your email address for $1!  Check out your [$2 user profile].", # Fuzzy
	'usersignup-facebook-heading' => 'Viimeistele rekisteröityminen',
	'usersignup-facebook-create-account' => 'Luo käyttäjätili',
	'usersignup-facebook-email-tooltip' => 'Jos haluat käyttää toista sähköpostiosoitetta voit muuttaa myöhemmin henkilökohtaisissa asetuksissasi.',
	'usersignup-facebook-have-an-account-heading' => 'Onko sinulla jo käyttäjätili?',
	'usersignup-facebook-have-an-account' => 'Yhdistä jo olemassa oleva Wikia-käyttäjänimesi mieluummin Facebookiin.',
	'usersignup-facebook-proxy-email' => 'Tuntematon Facebook-sähköpostiosoite',
	'usersignup-user-pref-emailconfirmlink' => 'Pyydä uutta sähköpostin vahvistusviestiä',
	'usersignup-user-pref-confirmemail_send' => 'Lähetä uusi sähköpostin vahvistusviesti',
	'usersignup-user-pref-emailauthenticated' => 'Kiitos! Sähköpostisi vahvistettiin $2 kello $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Tarkista sähköpostisi ja vahvista sähköpostiosoitteen vaihto napsautamalla osoitteeseen $1 lähetetyssä sähköpostissa olevaa vahvituslinkkiä.',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Voi ei! Sähköpostiosoitettasi ei ole vahvistettu. Sähköpostin ominaisuudet eivät toimi, ennen kuin vahvistat sähköpostiosoitteesi.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Melkein valmis! Olemme lähettänyt uuden vahvistusviestin osoitteeseen $1. Tarkista sähköpostisi ja klikkaa linkkiä viimeistelläksesi sähköpostiosoitteesi vahvistaminen.',
	'usersignup-user-pref-noemailprefs' => 'Näyttää siltä, että meillä ei ole sähköpostiosoitettasi. Kirjoita säshköpostiosoitteesi yläpuolelle.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Voi ei! Sähköpostiosoitettasi ei ole vahvistettu. Olemme lähettäneet sinulle sähköpostiin. Klikkaa vahvistuslinkkiä vahvistaaksesi osoite.',
	'usersignup-user-pref-confirmemail_noemail' => 'Näyttää siltä, että meillä ei ole sähköpostiosoitettasi. Siirry [[Toiminnot:Asetukset|käyttäjäasetuksiin]] kirjoittaaksesi se.', # Fuzzy
	'usersignup-confirm-page-title' => 'Vahvista sähköpostiosoitteesi',
	'usersignup-confirm-page-title-wikiamobile' => 'Tarkista sähköpostiosoitteesi',
	'usersignup-confirm-email-resend-email' => 'Lähetä minulle toinen sähköpostiosoitteen vahvistusviesti',
	'usersignup-confirm-email-change-email-content' => 'Haluan käyttää toista sähköpostiosoitetta.',
	'usersignup-confirm-email-change-email' => 'Muuta sähköpostiosoitteeni',
	'usersignup-confirm-email-new-email-label' => 'Uusi sähköpostiosoite',
	'usersignup-confirm-email-update' => 'Päivitä',
	'usersignup-confirm-email-tooltip' => 'Syötitkö sähköpostiosoitteen, jota et voi vahvistaa, vai haluatko käyttää eri osoitetta? Älä huoli, käytä alla olevaa linkkiä muuttaaksesi sähköpostiosoitteesi ja saadaksesi uusi vahvistusviesti.',
	'usersignup-resend-email-heading-success' => 'Uusi sähköpostiviesti lähetetty',
	'usersignup-resend-email-heading-failure' => 'Sähköpostiviestiä ei lähetetty uudelleen',
	'usersignup-confirm-page-heading-confirmed-user' => 'Onnittelut!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Olet jo vahvistanut',
	'usersignup-confirmation-heading' => 'Melkein valmis',
	'usersignup-confirmation-heading-wikiamobile' => 'Tarkista sähköpostisi',
	'usersignup-confirmation-heading-email-resent' => 'Uusi sähköpostiviesti lähetetty',
	'usersignup-confirmation-subheading' => 'Tarkista sähköpostiosoitteesi',
	'usersignup-confirmation-email-sent' => "Olemme lähettäneet sinulle sähköpostia osoitteeseen '''$1'''.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Olemme lähettäneet sinulle sähköpostia osoitteeseen '''$1'''.

Klikkaa sähköpostiviestissäsi olevaa vahvistuslinkkiä viimeistelläksesi kyttäjätilisi luominen. Kiitos!",
	'usersignup-reconfirmation-email-sent' => 'Sähköpostiosoitteeksesi on muutettu $1. Olemme lähettäneet sinulle uuden vahvistusviestin. Vahvista uusi sähköpostiosoitteesi.',
	'usersignup-welcome-email-subject' => 'Tervetuloa Wikiaan, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hei $USERNAME',
	'usersignup-welcome-email-heading' => 'Meillä on ilo toivottaa sinut tervetulleeksi Wikiaan sekä {{SITENAME}}-sivustolle! Tässä muutamia asioita, joita voit tehdä päästäksesi alkuun.',
	'usersignup-welcome-email-edit-profile-heading' => 'Muokkaa profiiliasi.',
	'usersignup-welcome-email-edit-profile-content' => 'Lisää profiilikuva ja muutamia asioita itsestäsi {{SITENAME}}-profiiliisi.',
	'usersignup-welcome-email-edit-profile-button' => 'Siirry profiiliin',
	'usersignup-welcome-email-learn-basic-heading' => 'Opettele perusasiat.',
	'usersignup-welcome-email-learn-basic-content' => 'Katso nopeasti pieni opetussivu Wikian perusasioista: kuinka muokata sivua, käyttäjäprofiiliasi, muuttaa asetuksiasi, ja muuta.',
	'usersignup-welcome-email-learn-basic-button' => 'Tarkista',
	'usersignup-welcome-email-explore-wiki-heading' => 'Tutki lisää wikejä.',
	'usersignup-welcome-email-explore-wiki-content' => 'Wikiassa on tuhansia wikejä, etsi lisää kinnostavia wikejä menemällä yhteen keskuksistamme: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Videopelit</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Viihde</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Elämäntavat</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Siirry wikia.comiin',
	'usersignup-welcome-email-content' => 'Haluatko lisätietoa? Etsi neuvoja, vastauksia sekä Wikia-yhteisö <a style="color:#2C85D5;" href="http://yhteiso.wikia.com">Yhteisöwikistä</a>. Iloisia muokkauksia!',
	'usersignup-welcome-email-signature' => 'Wikia-tiimi',
	'usersignup-welcome-email-body' => 'Hei $USERNAME,

Meillä on ilo toivottaa sinut tervetulleeksi Wikiaan sekä {{SITENAME}}-sivustolle! Tässä muutamia asioita, joita voit tehdä päästäksesi alkuun.

Muokkaa profiiliasi.

Lisää profiilikuva ja muutamia asioita itsestäsi {{SITENAME}}-profiiliisi.

Mene $EDITPROFILEURL

Opettele perusteet.

Katso nopeasti pieni opetussivu Wikian perusasioista: kuinka muokata sivua, käyttäjäprofiiliasi, muuttaa asetuksiasi, ja muuta.

Katso se itse ($LEARNBASICURL)

Tutki lisää wikejä.

Wikiassa on tuhansia wikejä, etsi lisää kinnostavia wikejä menemällä yhteen keskuksistamme: Videopelit (http://www.wikia.com/Video_Games), Viihde (http://www.wikia.com/Entertainment), tai Elämäntavat (http://www.wikia.com/Lifestyle).

Mene $EXPLOREWIKISURL

Haluatko lisätietoa? Etsi neuvoja, vastauksia sekä Wikia-yhteisö Yhteisöwikistä (http://www.community.wikia.com). Iloisia muokkauksia!

Wikia-tiimi


___________________________________________

Tarkistaaksesi Wikian viimeismmät tapahtumat, vieraile sivulla http://yhteiso.wikia.com
Haluatko hallita saamiasi sähköposteja? Mene: {{fullurl:{{ns:special}}:Asetukset}}',
	'usersignup-heading' => 'Liity Wikiaan tänään',
	'usersignup-heading-byemail' => 'Luo käyttäjätilli jollekulle toiselle',
	'usersignup-marketing-wikia' => 'Aloita avustaminen miljoonien ympäri maailmaa tulevien ihmisten kanssa, jotka kokoontuvat jakamaan tietonsa sekä rakkautensa siihen.',
	'usersignup-marketing-login' => 'Oletko jo käyttäjä? [[Toiminnot:Kirjaudu_sisään|Kirjaudu sisään]]', # Fuzzy
	'usersignup-marketing-benefits' => 'Ole osa jotain suurta',
	'usersignup-marketing-community-heading' => 'Avusta',
	'usersignup-marketing-community' => 'Löydä ja tutki aiheita videopeleistä elokuviin ja televisio-ohjelmiin. Tapaa uusia ihmisiä samanlaisten kiinnostusten ja intohimojen kera.',
	'usersignup-marketing-global-heading' => 'Luo',
	'usersignup-marketing-global' => 'Perusta wiki. Iloita pienellä, ja kasvata isoksi muiden avulla.',
	'usersignup-marketing-creativity-heading' => 'Ole alkuperäinen',
	'usersignup-marketing-creativity' => 'Käytä Wikiaa ilmaistaksesi luovuutesi kyselyillä ja Top 10 -listoilla, kuva- ja videogallerioilla, sovelluksilla ja muilla tavoilla.',
	'usersignup-createaccount-byemail' => 'Luo käyttäjätilli jollekulle toiselle',
	'usersignup-error-captcha' => 'Testiin vastaaminen epäonnistui, yritä uudelleen!', # Fuzzy
	'usersignup-account-creation-heading' => 'Onnistui!',
	'usersignup-account-creation-subheading' => 'Lähetimme sinulle sähköpostin osoitteeseen $1',
	'usersignup-account-creation-email-sent' => 'Olet alkanut luoda käyttäjätiliä nimellä $2. Olemme lähettäneet sinulle sähköpostina osoitteeseen $1 tilapäisen salasanan ja vahvistuslinkin.

Käyttäjän $2 tarvitsee klikata saamassaan sähköpostiviestissä olevaa linkkiä vahvistaakseen tilinsä ja muuttaakseen tilapäisen salansanansa viimeistelläkseen tilinsä luomisen.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Luo lisää tilejä] sivustolle {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Sinulle on luotu käyttäjätili Wikiaan!',
	'usersignup-account-creation-email-greeting' => 'Tervehdys,',
	'usersignup-account-creation-email-content' => 'Sinulle on luotu käyttäjätili sivustolle {{SITENAME}}. Päästäksesi käsiksi tiliisi ja muuttaaksesi tilapäisen salasanasi, klikkaa alla olevaa linkkiä ja kirjaudu käyttäjänimellä "$USERNAME" sekä salasanalla "$NEWPASSWORD".

Kirjaudu sisään sivun <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a> kautta

Jos et halua, että tämä käyttäjätili luodaan, unohda tämä sähköposti ja ota yhteyttä yhteisötiimiin ja kysy mitä tahansa.',
	'usersignup-account-creation-email-signature' => 'Wikia-tiimi',
	'usersignup-account-creation-email-body' => 'Hei,

Sinulle on luotu käyttäjätili sivustolle {{SITENAME}}. Päästäksesi käsiksi tiliisi ja muuttaaksesi tilapäisen salasanasi, klikkaa alla olevaa linkkiä ja kirjaudu käyttäjänimellä "$2" sekä salasanalla "$3".

Kirjaudu sisään {{fullurl:{{ns:special}}:UserLogin}}

Jos et halua, että tämä käyttäjätili luodaan, unohda tämä sähköposti ja ota yhteyttä yhteisötiimiin ja kysy mitä tahansa.

Wikia-tiimi


___________________________________________

Tarkistaaksesi Wikian viimeismmät tapahtumat, vieraile sivulla http://yhteiso.wikia.com
Haluatko hallita saamiasi sähköposteja? Mene: {{fullurl:{{ns:special}}:Asetukset}}',
	'usersignup-facebook-problem' => 'Yhteyden saamisessa Facebookiin oli ongelma. Yritä myöhemmin uudelleen.',
	'usersignup-facebook-signup-header' => 'Luotko uuden käyttäjätilin?',
	'usersignup-facebook-login-header' => 'Onko sinulla jo käyttäjätili?',
);

/** French (français)
 * @author Boniface
 * @author Gomoko
 * @author McDutchie
 * @author Windes
 * @author Wyz
 * @author Zetud
 */
$messages['fr'] = array(
	'usersignup-page-title' => 'Rejoindre Wikia',
	'usersignup-page-title-wikiamobile' => 'Créer un compte',
	'usersignup-page-captcha-label' => 'Défi',
	'usersignup-error-username-length' => "Oups, votre nom d'utilisateur ne doit pas dépasser {{PLURAL:$1|un caractère|$1 caractères}}",
	'usersignup-error-invalid-user' => "Utilisateur non valide. Veuillez d'abord vous connecter.",
	'usersignup-error-invalid-email' => 'Veuillez saisir une adresse courriel valide.',
	'usersignup-error-symbols-in-username' => "Oups, votre nom d'utilisateur ne peut contenir que des lettres et des chiffres.",
	'usersignup-error-empty-email' => 'Oups, veuillez indiquer votre adresse courriel.',
	'usersignup-error-empty-username' => "Oups, veuillez remplir le champ « nom d'utilisateur ».",
	'usersignup-error-already-confirmed' => 'Vous avez déjà confirmé cette adresse courriel.',
	'usersignup-error-throttled-email' => "Oups, vous avez demandé à recevoir des courriels de confirmation trop de fois aujourd'hui. Veuillez réessayer dans quelque temps.",
	'usersignup-error-too-many-changes' => "Vous avez atteint la limite maximale de modifications de courriel aujourd'hui. Veuillez réessayer plus tard.",
	'usersignup-error-password-length' => 'Oups, votre mot de passe est trop long. Veuillez choisir un mot de passe de 50 caractères ou moins.',
	'usersignup-error-confirmed-user' => 'Il semble que vous ayez déjà confirmé votre adresse courriel pour $1 ! Vérifiez votre [$2 profil utilisateur].',
	'usersignup-facebook-heading' => 'Terminer la création de compte',
	'usersignup-facebook-create-account' => 'Créer un compte',
	'usersignup-facebook-email-tooltip' => 'Si vous souhaitez utiliser une autre adresse courriel, vous pouvez la modifier plus tard dans vos préférences.',
	'usersignup-facebook-have-an-account-heading' => 'Vous avez déjà un compte ?',
	'usersignup-facebook-have-an-account' => "Connectez plutôt votre nom d'utilisateur Wikia existant avec Facebook.",
	'usersignup-facebook-proxy-email' => 'Courriel anonyme Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Demander un nouveau courriel de confirmation',
	'usersignup-user-pref-confirmemail_send' => 'Renvoyer le courriel de confirmation',
	'usersignup-user-pref-emailauthenticated' => 'Merci ! Votre adresse courriel a été confirmée le $2 à $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Vérifiez votre compte de messagerie et cliquez sur le lien de confirmation pour terminer le changement de votre adresse courriel à : $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => "Oh non ! Votre adresse courriel n'est pas confirmée. Les fonctionnalités de courriel ne fonctionneront pas tant que que nous vous n'aurez pas confirmé votre adresse courriel.",
	'usersignup-user-pref-reconfirmation-email-sent' => 'Vous y êtes presque ! Un nouveau courriel de confirmation a été envoyé à $1. Vérifiez votre compte de messagerie et cliquez sur le lien pour terminer la confirmation de votre adresse courriel.',
	'usersignup-user-pref-noemailprefs' => "Il semblerait que nous n'ayons pas d'adresse courriel pour vous. Veuillez saisir une adresse courriel ci-dessus.",
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => "Oh non ! Votre adresse courriel n'est pas confirmée. Nous vous avons envoyé un courriel, cliquez sur le lien de confirmation qui s'y trouve pour la confirmer.",
	'usersignup-user-pref-confirmemail_noemail' => "Il semblerait que nous n'ayons pas d'adresse courriel pour vous. Allez dans vos [[Special:Preferences|préférences utilisateur]] pour en saisir une.",
	'usersignup-confirm-page-title' => 'Confirmer votre adresse courriel',
	'usersignup-confirm-page-title-wikiamobile' => 'Vérifier votre adresse courriel',
	'usersignup-confirm-email-resend-email' => "M'envoyer un autre courriel de confirmation",
	'usersignup-confirm-email-change-email-content' => 'Je veux utiliser une autre adresse courriel.',
	'usersignup-confirm-email-change-email' => 'Modifier mon adresse courriel',
	'usersignup-confirm-email-new-email-label' => 'Nouveau courriel',
	'usersignup-confirm-email-update' => 'Mettre à jour',
	'usersignup-confirm-email-tooltip' => 'Vous avez saisi une adresse courriel que vous ne pouvez pas confirmer ou vous souhaitez utiliser une autre adresse courriel ? Ne vous inquiétez pas, utilisez le lien ci-dessous pour modifier votre adresse courriel et recevoir un nouveau courriel de confirmation.',
	'usersignup-resend-email-heading-success' => 'Nouveau courriel envoyé',
	'usersignup-resend-email-heading-failure' => 'Courriel non renvoyé',
	'usersignup-confirm-page-heading-confirmed-user' => 'Félicitations !',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Vous êtes déjà confirmé',
	'usersignup-confirmation-heading' => 'Vous y êtes presque',
	'usersignup-confirmation-heading-wikiamobile' => 'Vérifier votre adresse courriel',
	'usersignup-confirmation-heading-email-resent' => 'Nouveau courriel envoyé',
	'usersignup-confirmation-subheading' => 'Vérifier votre adresse courriel',
	'usersignup-confirmation-email-sent' => "Nous avons envoyé un courriel à '''$1'''.

Cliquez sur le lien de confirmation dans le courriel pour terminer la création de votre compte.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Nous avons envoyé un courriel à '''$1'''.

Cliquez sur le lien de confirmation dans le courriel pour terminer la création de votre compte. Merci !",
	'usersignup-reconfirmation-email-sent' => 'Votre adresse courriel a été modifiée en $1. Nous vous avons envoyé un nouveau courriel de confirmation. Veuillez confirmer la nouvelle adresse courriel.',
	'usersignup-welcome-email-subject' => 'Bienvenue sur Wikia, $USERNAME !',
	'usersignup-welcome-email-greeting' => 'Bonjour $USERNAME',
	'usersignup-welcome-email-heading' => 'Nous sommes heureux de vous accueillir sur Wikia et {{SITENAME}} ! Voici certaines choses que vous pouvez faire pour commencer.',
	'usersignup-welcome-email-edit-profile-heading' => 'Modifier votre profil.',
	'usersignup-welcome-email-edit-profile-content' => 'Ajoutez une photo de profil et quelques informations sommaires sur vous sur votre profil sur {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Aller au profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Apprendre les bases.',
	'usersignup-welcome-email-learn-basic-content' => 'Consultez un tutoriel rapide sur les bases de Wikia : comment modifier une page, votre profil utilisateur, vos préférences et plus encore.',
	'usersignup-welcome-email-learn-basic-button' => 'Voir',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explorer plus de wikias.',
	'usersignup-welcome-email-explore-wiki-content' => 'Il y a des milliers de wikias, trouvez en plus qui vous intéressent en parcourant les portails : <a style="color:#2C85D5;" href="http://fr.wikia.com/Jeux_vid%C3%A9o">Jeux vidéo</a>, <a style="color:#2C85D5;" href="http://fr.wikia.com/Divertissement">Divertissement</a>, ou <a style="color:#2C85D5;" href="http://fr.wikia.com/Mode_de_vie">Mode de vie</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Aller à wikia.com',
	'usersignup-welcome-email-content' => 'Vous souhaitez plus d\'informations ? Trouvez des conseils, des réponses et la communauté Wikia sur le <a style="color:#2C85D5;" href="http://communaute.wikia.com">Centre des communautés</a>. Bonnes modifications !',
	'usersignup-welcome-email-signature' => "L'équipe Wikia",
	'usersignup-welcome-email-body' => 'Bonjour $USERNAME,

Nous sommes heureux de vous accueillir sur Wikia et {{SITENAME}} ! Voici certaines choses que vous pouvez faire pour commencer.

Modifier votre profil.

Ajoutez une photo de profil et quelques informations sommaires sur vous sur votre profil sur {{SITENAME}}.

Aller à $EDITPROFILEURL

Apprendre les bases.

Consultez un tutoriel rapide sur les bases de Wikia : comment modifier une page, votre profil utilisateur, vos préférences et plus encore.

Voir ($LEARNBASICURL)

Explorez plus de wikias.

Il y a des milliers de wikias, trouvez en plus qui vous intéressent en parcourant les portails : Jeux vidéo (http://fr.wikia.com/Jeux_vid%C3%A9o), Divertissement (http://fr.wikia.com/Divertissement) ou Mode de vie (http://fr.wikia.com/Mode_de_vie).

Aller à $EXPLOREWIKISURL

Vous souhaitez plus d\'informations ? Trouvez des conseils, des réponses et la communauté Wikia sur le Centre des communautés (http://communaute.wikia.com). Bonnes modifications !

L\'équipe Wikia


___________________________________________

* Pour voir les derniers évènements sur Wikia, visitez http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Rejoindre Wikia maintenant',
	'usersignup-heading-byemail' => "Créer un compte pour quelqu'un d'autre",
	'usersignup-marketing-wikia' => "Commencez à participer avec des millions de personnes du monde entier qui se rassemblent pour partager ce qu'elles savent et aiment.",
	'usersignup-marketing-login' => 'Déjà utilisateur ? [[Special:UserLogin|Vous connecter]]',
	'usersignup-marketing-benefits' => "Faites partie de quelque chose d'énorme",
	'usersignup-marketing-community-heading' => 'Participez',
	'usersignup-marketing-community' => 'Découvrez et explorez des sujets qui vont des jeux vidéo aux films et à la télévision. Rencontrez des gens qui partagent les mêmes intérêts et passions que vous.',
	'usersignup-marketing-global-heading' => 'Créez',
	'usersignup-marketing-global' => "Commencez un wikia. Commencez petit, devenez grand, avec l'aide des autres.",
	'usersignup-marketing-creativity-heading' => 'Soyez original',
	'usersignup-marketing-creativity' => "Utilisez Wikia pour exprimer votre créativité avec des sondages, des listes de top 10, des galeries d'image et de vidéo, des applications et plus.",
	'usersignup-createaccount-byemail' => "Créer un compte pour quelqu'un d'autre",
	'usersignup-error-captcha' => 'La réponse au défi est incorrecte, veuillez réessayer !',
	'usersignup-account-creation-heading' => 'Réussite !',
	'usersignup-account-creation-subheading' => 'Un courriel a été envoyé à $1',
	'usersignup-account-creation-email-sent' => "Vous avez commencé le processus de création pour $2. Nous lui avons envoyé un courriel à l'adresse $1 avec un mot de passe temporaire et un lien de confirmation.

$2 devra cliquer sur le lien dans le courriel que nous lui avons envoyé pour confirmer son compte et modifier son mot de passe temporaire pour terminer la création de son compte.

[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Créer plus de comptes] sur {{SITENAME}}",
	'usersignup-account-creation-email-subject' => 'Un compte a été créé pour vous sur Wikia !',
	'usersignup-account-creation-email-greeting' => 'Bonjour,',
	'usersignup-account-creation-email-content' => 'Un compte a été créé pour vous sur {{SITENAME}}. Pour accéder à votre compte et modifier votre mot de passe temporaire, cliquez sur le lien ci-dessous et connectez-vous avec le nom d\'utilisateur « $USERNAME » et le mot de passe « $NEWPASSWORD ».

Veuillez vous connecter sur <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Si vous ne souhaitez pas que ce compte soit créé, vous pouvez ignorer ce courriel ou contactez l\'équipe d\'assistance à la communauté si vous avez des questions.',
	'usersignup-account-creation-email-signature' => "L'équipe Wikia",
	'usersignup-account-creation-email-body' => "Bonjour,

Un compte a été créé pour vous sur {{SITENAME}}. Pour accéder à votre compte et modifier votre mot de passe temporaire, cliquez sur le lien ci-dessous et connectez-vous avec le nom d'utilisateur « $2 » et le mot de passe « $3 ».

Veuillez vous connecter sur {{fullurl:{{ns:special}}:UserLogin}}

Si vous ne souhaitez pas que ce compte soit créé, vous pouvez ignorer ce courriel ou contactez l'équipe d'assistance à la communauté si vous avez des questions.

L'équipe Wikia


___________________________________________

* Pour voir les derniers évènements sur Wikia, visitez http://communaute.wikia.com
* Vous souhaitez contrôler les courriels que vous recevez ? Rendez-vous sur : {{fullurl:{{ns:special}}:Preferences}}",
	'usersignup-facebook-problem' => 'Une erreur est survenue en communiquant avec Facebook. Veuillez réessayer plus tard.',
	'usersignup-facebook-signup-header' => 'Vous créez un nouveau compte ?',
	'usersignup-facebook-login-header' => 'Vous avez déjà un compte ?',
);

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = array(
	'usersignup-marketing-global-heading' => 'Oanmeitsje',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'usersignup-page-title' => 'Unirse a Wikia',
	'usersignup-page-captcha-label' => 'Palabra borrosa', # Fuzzy
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
	'usersignup-error-confirmed-user' => 'Semella que xa confirmou o enderezo de correo electrónico $1! Comprobe o seu [$2 perfil de usuario].', # Fuzzy
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
	'usersignup-reconfirmation-email-sent' => 'O seu enderezo de correo electrónico cambiouse a $1. Enviámoslle un novo correo de confirmación. Confirme o novo enderezo.',
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
	'usersignup-error-captcha' => 'A palabra que escribiu non coincide co texto da caixa. Inténteo de novo!', # Fuzzy
	'usersignup-account-creation-heading' => 'Todo correcto!',
	'usersignup-account-creation-subheading' => 'Enviamos un correo electrónico a $1',
	'usersignup-account-creation-email-sent' => 'Vostede comezou o proceso de creación dunha conta para $2. Enviamos un correo ao enderezo $1 cun contrasinal temporal e unha ligazón de confirmación.


$2 terá que premer na ligazón do correo que lle enviamos para confirmar a súa conta e cambiar o seu contrasinal temporal para rematar a creación da conta.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Crear máis contas] en {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Creouse unha conta para vostede en Wikia!',
	'usersignup-account-creation-email-greeting' => 'Boas:',
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
	'usersignup-facebook-problem' => 'Houbo un problema ao comunicar co Facebook. Inténteo de novo máis tarde.',
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'usersignup-page-title' => 'Csatlakozz a Wikiához',
	'usersignup-page-captcha-label' => 'Elmosott szó', # Fuzzy
	'usersignup-error-username-length' => 'Hoppá! A felhasználóneved nem lehet hosszabb {{PLURAL:$1|egy|$1}} karakternél.',
	'usersignup-error-invalid-user' => 'A felhasználó érvénytelen. Jelentkezz be először.',
	'usersignup-error-invalid-email' => 'Kérlek, érvényes e-mail címet adj meg',
	'usersignup-error-symbols-in-username' => 'Hoppá! A felhasználóneved csak számokat és betűket tartalmazhat.',
	'usersignup-error-empty-email' => 'Hoppá! Kérlek, adj meg e-mail címet.',
	'usersignup-error-empty-username' => 'Hoppá! Kérlek, töltsd ki a "Felhasználónév" mezőt.',
	'usersignup-error-already-confirmed' => 'Már megerősítetted ezt az e-mail címet.',
	'usersignup-error-throttled-email' => 'Hoppá! Túl sok megerősítő e-mail küldését kérted ma. Próbáld újra egy kis idő múlva.',
	'usersignup-error-too-many-changes' => 'Ma elérted az e-mail címek változtatására megengedett felső határértéket. Kérlek, próbáld újra később.',
	'usersignup-error-password-length' => 'Hoppá! A jelszavad túl hosszú. Kérlek, 50, vagy kevesebb karakterből álló jelszót válassz.',
	'usersignup-error-confirmed-user' => 'Úgy tűnik, már megerősítetted a(z) e-mail címedet "$1"-ként! Ellenőrizd a [$2 felhasználói profilodat].', # Fuzzy
	'usersignup-facebook-heading' => 'Feliratkozás befejezése',
	'usersignup-facebook-create-account' => 'Fiók létrehozása',
	'usersignup-facebook-email-tooltip' => 'Amennyiben más e-mail címet szeretnél használni, később is megváltoztathatod a beállításaidban.',
	'usersignup-facebook-have-an-account-heading' => 'Már van fiókod?',
	'usersignup-facebook-have-an-account' => 'vagy kösd össze létező Wikia felhasználóneved a Facebookal',
	'usersignup-facebook-proxy-email' => 'Névtelen Facebook e-mail',
	'usersignup-user-pref-emailconfirmlink' => 'Új megerősítő e-mail kérése',
	'usersignup-user-pref-confirmemail_send' => 'Megerősítő e-mail újraküldése',
	'usersignup-user-pref-emailauthenticated' => 'Köszönjük! Az e-mail címedet $2-án, $3-kor lett megerősítve',
	'usersignup-user-pref-emailnotauthenticated' => 'Ellenőrizd az e-mailjeidet és kattints a megerősítő hivatkozásra, hogy átváltoztasd az e-mailedet "$1"-re',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Jaj, ne! Nincs megerősítve az e-mail címed. Az e-mailes szolgáltatások nem fognak működni az e-mail cím megerősítéséig.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Majdnem készen vagyunk! Küldtünk egy új megerősítő e-mailt az $1 címre. Ellenőrizd az e-mailjeidet és kattints a hivatkozásra, hogy befejezd e-mail címed megerősítését.',
	'usersignup-user-pref-noemailprefs' => 'Úgy tűnik, nem ismerjük az e-mail címed. Kérlek, írd be a fenti mezőbe.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Jaj, ne! Nincs megerősítve az e-mail címed. Küldtünk neked egy e-mailt; kattints a benne lévő megerősítő hivatkozásra ennek elvégzéséhez.',
	'usersignup-user-pref-confirmemail_noemail' => 'Úgy tűnik, nem ismerjük az e-mail címed. Adj meg egyet [[Special:Preferences|a felhasználói beállításaidban]].',
	'usersignup-confirm-page-title' => 'E-mail cím megerősítése',
	'usersignup-confirm-email-resend-email' => 'Új megerősítő e-mail küldése',
	'usersignup-confirm-email-change-email-content' => 'Másik e-mail címet szeretnék használni.',
	'usersignup-confirm-email-change-email' => 'E-mail cím megváltoztatása',
	'usersignup-confirm-email-new-email-label' => 'Új e-mail',
	'usersignup-confirm-email-update' => 'Frissítés',
	'usersignup-confirm-email-tooltip' => 'Nem megerősíthető e-mail címet írtál be, vagy másik e-mail címet szeretnél használni? Ne aggódj: használd a lenti hivatkozást az e-mail címed megváltoztatásához és új megerősítő e-mail kéréséhez.',
	'usersignup-resend-email-heading-success' => 'Az új e-mailt elküldtük.',
	'usersignup-resend-email-heading-failure' => 'Az új e-mailt nem küldtük el.',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gratulálunk!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Már megerősítetted',
	'usersignup-confirmation-heading' => 'Majdnem kész!',
	'usersignup-confirmation-heading-email-resent' => 'Az új e-mailt elküldtük.',
	'usersignup-confirmation-subheading' => 'Ellenőrizd az e-mail fiókod.',
	'usersignup-confirmation-email-sent' => "Küldtünk egy e-mailt a(z) '''$1'' címre'.

Kattints az e-mailben található megerősítő hivatkozásra a felhasználói fiókod létrehozásának befejezéséhez.",
	'usersignup-reconfirmation-email-sent' => 'Az e-mail címedet átváltoztattuk az alábbira: $1. Küldtünk neked egy új megerősítő e-mailt; kérlek, erősítsd meg az új e-mail címed.',
	'usersignup-welcome-email-subject' => 'Üdvözlünk a Wikián, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Szia, $USERNAME!',
	'usersignup-welcome-email-heading' => 'Örömmel üdvözlünk a Wikián és a {{SITENAME}} wikin! Itt van néhány dolog, amelyet kezdésként tehetsz:',
	'usersignup-welcome-email-edit-profile-heading' => 'Szerkeszd a profilodat.',
	'usersignup-welcome-email-edit-profile-content' => 'Tölts fel egy profilképet és adj meg némi alapvető információt magadról a profilodon a {{SITENAME}} wikin.',
	'usersignup-welcome-email-edit-profile-button' => 'Ugrás a profilra',
	'usersignup-welcome-email-learn-basic-heading' => 'Sajátítsd el az alapokat.',
	'usersignup-welcome-email-learn-basic-content' => 'Olvass el egy gyors bevezetőt a Wikia alapjaiba: az oldalak és a profilod szerkesztésébe, a beállításaid megváltoztatásába és még sok másba.',
	'usersignup-welcome-email-learn-basic-button' => 'Elolvasás',
	'usersignup-welcome-email-explore-wiki-heading' => 'Fedezz fel további wikiket.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'usersignup-page-title' => 'Adherer a Wikia',
	'usersignup-page-captcha-label' => 'Parola brumose', # Fuzzy
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
	'usersignup-error-confirmed-user' => 'Il pare que tu ha jam confirmate tu adresse de e-mail pro $1! Reguarda tu [$2 profilo de usator].', # Fuzzy
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
	'usersignup-reconfirmation-email-sent' => 'Tu adresse de e-mail ha essite cambiate a $1. Nos te ha inviate un nove message de confirmation. Per favor confirma le nove adresse de e-mail.',
	'usersignup-welcome-email-subject' => 'Benvenite a Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Salute $USERNAME,',
	'usersignup-welcome-email-heading' => 'Nos es felice de dar te le benvenita a Wikia e {{SITENAME}}! Ecce alcun cosas que tu pote facer pro comenciar.',
	'usersignup-welcome-email-edit-profile-heading' => 'Modifica tu profilo.',
	'usersignup-welcome-email-edit-profile-content' => 'Adde un photo de profilo e alcun curte informationes sur te in tu profilo de {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Va al profilo',
	'usersignup-welcome-email-learn-basic-heading' => 'Apprender le bases.',
	'usersignup-welcome-email-learn-basic-content' => 'Lege un breve tutorial sur le bases de Wikia: como modificar un pagina, tu profilo de usator, cambiar tu preferentias, e plus.',
	'usersignup-welcome-email-learn-basic-button' => 'Monstra me lo!',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explora altere wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'Il ha milles de wikis in Wikia! Cerca le wikis de tu interesse per medio de nostre centros de activitate: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Jocos video</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Intertenimento</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Stilo de vita</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Va a wikia.com',
	'usersignup-welcome-email-content' => 'Vole plus information? Trova consilios, responsas, e le communitate de Wikia in le <a style="color:#2C85D5;" href="http://community.wikia.com">Centro del communitate</a>. Bon modification!',
	'usersignup-welcome-email-signature' => 'Le equipa de Wikia',
	'usersignup-welcome-email-body' => 'Salute $USERNAME,

Benvenite a Wikia e a {{SITENAME}}! Ecce alcun cosas que tu pote facer pro comenciar.

Modifica tu profilo.

Adde un photo e alcun curte informationes a proposito e te a tu profilo de {{SITENAME}}.

Va a $EDITPROFILEURL

Apprende le conceptos de base.

Obtene un curte tutorial sur le conceptos de base de Wikia: como modificar un pagina, tu profilo de usator, modificar tu preferentias, e plus.

Jecta un oculo a: $LEARNBASICURL

Explora plus wikis.

Il ha milles de wikis in Wikia. Trova altere wikis que te interessa a un de nostre centros de activitate: Jocos video (http://www.wikia.com/Video_Games), Intertenimento (http://www.wikia.com/Entertainment), o Stilo de vita (http://www.wikia.com/Lifestyle).

Va a $EXPLOREWIKISURL

Tu vole plus information? Responsas, e le communitate de Wikia se trova al Centro del Communitate (http://www.community.wikia.com). Bon modification!

Le equipa de Wikia


___________________________________________

Pro tener te al currente con le ultime eventos in Wikia, visita http://community.wikia.com
Vole seliger le e-mail que tu recipe? Va a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Uni te hodie a Wikia',
	'usersignup-heading-byemail' => 'Crear un conto pro qualcuno altere',
	'usersignup-marketing-wikia' => 'Comencia a collaborar con milliones de personas de tote le mundo qui se reuni pro divider lo que illes sape e ama.',
	'usersignup-marketing-login' => 'Tu es jam usator? [[Special:UserLogin|Aperi session]]',
	'usersignup-marketing-benefits' => 'Sia parte de qualcosa enorme',
	'usersignup-marketing-community-heading' => 'Collabora',
	'usersignup-marketing-community' => 'Discoperi e explora themas variante de jocos video a filmes e TV. Cognosce personas con similar interesses e passiones.',
	'usersignup-marketing-global-heading' => 'Crea',
	'usersignup-marketing-global' => 'Aperi un proprie wiki. Comencia micre, e cresce con le adjuta de alteres.',
	'usersignup-marketing-creativity-heading' => 'Sia original',
	'usersignup-marketing-creativity' => 'Usa Wikia pro exprimer tu creativitate con sondages e listas Top 10, galerias de photos e videos, applicationes e plus.',
	'usersignup-createaccount-byemail' => 'Crear un conto pro qualcuno altere',
	'usersignup-error-captcha' => 'Le parola que tu scribeva non corresponde al parola in le quadro. Essaya de novo.', # Fuzzy
	'usersignup-account-creation-heading' => 'Successo!',
	'usersignup-account-creation-subheading' => 'Nos ha inviate un e-mail a $1',
	'usersignup-account-creation-email-sent' => 'Tu ha comenciate le processo de creation de conto pro $2. Nos ha inviate un e-mail a $1 con un contrasigno temporari e un ligamine de confirmation.


$2 debe cliccar sur le ligamine in le message que nos ha inviate pro confirmar su conto e cambiar su contrasigno temporari pro finir le creation de su conto.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Crear altere contos] in {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Un conto ha essite create pro te in Wikia!',
	'usersignup-account-creation-email-greeting' => 'Salute,',
	'usersignup-account-creation-email-content' => 'Un conto ha essite create pro te in {{SITENAME}}. Pro acceder a tu conto e cambiar tu contrasigno temporari, clicca sur le ligamine sequente e aperi session con le nomine de usator "$USERNAME" e le contrasigno "$NEWPASSWORD".

Per favor aperi session a <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Si tu non vole que iste conto sia create, tu pote simplemente ignorar iste message o contactar nostre equipa de Supporto Communitari si tu ha questiones.',
	'usersignup-account-creation-email-signature' => 'Le equipa de Wikia',
	'usersignup-account-creation-email-body' => 'Salute,

Un conto ha essite create pro te in {{SITENAME}}. Pro acceder a tu conto e cambiar tu contrasigno temporari, clicca sur le ligamine sequente e aperi session con le nomine de usator "$2" e le contrasigno "$3".

Per favor aperi session a {{fullurl:{{ns:special}}:UserLogin}}

Si tu non vole que iste conto sia create, tu pote simplemente ignorar iste message o contactar nostre equipa de Supporto Communitari si tu ha questiones.

Le equipa de Wikia


___________________________________________

Pro tener te al currente con le eventos actual in Wikia, visita http://community.wikia.com
Vole seliger le e-mail que tu recipe? Va a: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Occurreva un problema de communication con Facebook. Per favor reproba plus tarde.',
);

/** Italian (italiano)
 * @author Lexaeus 94
 * @author Minerva Titani
 */
$messages['it'] = array(
	'usersignup-page-title' => 'Iscriviti a Wikia',
	'usersignup-page-title-wikiamobile' => 'Crea account',
	'usersignup-page-captcha-label' => 'Sfida',
	'usersignup-error-username-length' => 'Oops, il tuo nome utente non può avere più di {{PLURAL:$1|un carattere|$1 caratteri}}.',
	'usersignup-error-invalid-user' => 'Utente non valido. Effettua prima il login.',
	'usersignup-error-invalid-email' => 'Per favore, inserisci un indirizzo email valido.',
	'usersignup-error-symbols-in-username' => 'Oops, il tuo nome utente può contenere solo lettere e numeri.',
	'usersignup-error-empty-email' => 'Oops, per favore inserisci il tuo indirizzo email.',
	'usersignup-error-empty-username' => 'Oops, per favore inserisci il tuo nome utente.',
	'usersignup-error-already-confirmed' => 'Hai già confermato questo indirizzo email.',
	'usersignup-error-throttled-email' => "Oops, hai richiesto l'invio di troppe email di conferma oggi. Riprova ancora tra un po'.",
	'usersignup-error-too-many-changes' => 'Hai raggiunto il limite massimo per cambi di email oggi. Per favore, riprova più tardi.',
	'usersignup-error-password-length' => 'Oops, la tua password è troppo lunga. Per favore, scegli una password che sia al massimo di 50 caratteri.',
	'usersignup-error-confirmed-user' => 'Sembra che tu abbia già confermato il tuo indirizzo email per $1! Controlla il tuo [$2 profilo utente].', # Fuzzy
	'usersignup-facebook-heading' => "Concludi l'iscrizione",
	'usersignup-facebook-create-account' => 'Crea account',
	'usersignup-facebook-email-tooltip' => 'Se preferisci usare un indirizzo email differente, puoi cambiarlo in seguito nelle tue preferenze.',
	'usersignup-facebook-have-an-account-heading' => 'Hai già un account?',
	'usersignup-facebook-have-an-account' => 'Collega il tuo nome utente di Wikia esistente con Facebook invece.',
	'usersignup-facebook-proxy-email' => 'Email di Facebook anonima',
	'usersignup-user-pref-emailconfirmlink' => 'Richiedi una nuova email di conferma',
	'usersignup-user-pref-confirmemail_send' => 'Invia nuovamente la mia email di conferma',
	'usersignup-user-pref-emailauthenticated' => 'Grazie! La tua email è stata confermata il $2 alle $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Controlla la tua email e clicca il link di conferma per finire di cambiare la tua mail a: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => "Oh, no! La tua email non è confermata. Le funzioni per l'email non funzioneranno finché non confermi la tua email.",
	'usersignup-user-pref-reconfirmation-email-sent' => 'Ci siamo quasi! Abbiamo inviato una nuova email di conferma a $1. Controlla la tua email e clicca sul link per finire di confermare il tuo indirizzo email.',
	'usersignup-user-pref-noemailprefs' => 'Sembra che non abbiamo un indirizzo email per te. Per favore, inseriscine uno qui sopra.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Oh, no! La tua email non è cofermata. Ti abbiamo inviato una email, clicca sul link presente per confermare.',
	'usersignup-user-pref-confirmemail_noemail' => 'Sembra che non abbiamo un indirizzo email per te. Vai nelle tue [[Special:Preferences|preferenze]] per inserirne uno.',
	'usersignup-confirm-page-title' => 'Conferma la tua email',
	'usersignup-confirm-page-title-wikiamobile' => 'Controlla la tua email',
	'usersignup-confirm-email-resend-email' => "Mandami un'altra email di conferma",
	'usersignup-confirm-email-change-email-content' => 'Voglio usare un indirizzo email diverso.',
	'usersignup-confirm-email-change-email' => 'Cambia il mio indirizzo email',
	'usersignup-confirm-email-new-email-label' => 'Nuova email',
	'usersignup-confirm-email-update' => 'Aggiorna',
	'usersignup-confirm-email-tooltip' => 'Hai inserito un indirizzo email che non puoi confermare o vuoi usarne uno diverso? Non ti preoccupare, usa il link qui sotto per cambiare il tuo indirizzo email e ricevi una nuova email di conferma.',
	'usersignup-resend-email-heading-success' => 'Nuova email inviata',
	'usersignup-resend-email-heading-failure' => 'Email non inviata nuovamente',
	'usersignup-confirm-page-heading-confirmed-user' => 'Complimenti!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Sei già confermato',
	'usersignup-confirmation-heading' => 'Ci siamo quasi',
	'usersignup-confirmation-heading-wikiamobile' => 'Controlla la tua email',
	'usersignup-confirmation-heading-email-resent' => 'Nuova email inviata',
	'usersignup-confirmation-subheading' => 'Controlla la tua email',
	'usersignup-confirmation-email-sent' => 'Abbiamo inviato una email a "$1".

Clicca sul link di conferma nella tua email per concludere la creazione del tuo account.',
	'usersignup-confirmation-email-sent-wikiamobile' => 'Abbiamo inviato una email a "$1".

Clicca sul link di conferma nella tua email per concludere la creazione del tuo account. Grazie!',
	'usersignup-reconfirmation-email-sent' => 'Il tuo indirizzo email è stato cambiato in $1. Ti abbiamo inviato una nuova email di conferma. Per favore, conferma il nuovo indirizzo email.',
	'usersignup-welcome-email-subject' => 'Benvenuto su Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Ciao $USERNAME',
	'usersignup-welcome-email-heading' => 'Siamo felici di darti il benvenuto su Wikia e {{SITENAME}}! Ecco alcune cose ce puoi fare per iniziare.',
	'usersignup-welcome-email-edit-profile-heading' => 'Modifica il tuo profilo.',
	'usersignup-welcome-email-edit-profile-content' => "Aggiungi un'immagine del profilo e alcune semplici informazioni su di te nel tuo profilo su {{SITENAME}}.",
	'usersignup-welcome-email-edit-profile-button' => 'Vai al profilo',
	'usersignup-welcome-email-learn-basic-heading' => 'Impara le basi.',
	'usersignup-welcome-email-learn-basic-content' => 'Fai un tutorial rapido sulle basi di Wikia: come modificare una pagina, il tuo profilo utente, cambiare le tue preferenze e molto altro.',
	'usersignup-welcome-email-learn-basic-button' => "Dacci un'occhiata",
	'usersignup-welcome-email-explore-wiki-heading' => 'Esplora più wiki.',
	'usersignup-welcome-email-explore-wiki-content' => 'Ci sono migliaia di wiki su Wikia, trovane di più interessanti per te andando su uno dei nostri hub: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Videogiochi</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Intrattenimento</a> o <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Stili di vita</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Vai su wikia.com',
	'usersignup-welcome-email-content' => 'Vuoi maggiori informazioni? Trova consigli, risposte e la community di Wikia su la <a style="color:#2C85D5;" href="http://it.community.wikia.com">Wiki della Community</a>. Happy editing!',
	'usersignup-welcome-email-signature' => 'Il team di Wikia',
	'usersignup-welcome-email-body' => 'Ciao $USERNAME,

Siamo felici di darti il benvenuto su Wikia e {{SITENAME}}! Ecco alcune cose ce puoi fare per iniziare.

Modifica il tuo profilo.

Aggiungi un\'immagine del profilo e alcune semplici informazioni su di te nel tuo profilo su {{SITENAME}}.

Vai su $EDITPROFILEURL

Impara le basi.

Fai un tutorial rapido sulle basi di Wikia: come modificare una pagina, il tuo profilo utente, cambiare le tue preferenze e molto altro.

Dacci un\'occhiata ($LEARNBASICURL)

Esplora più wiki.

Ci sono migliaia di wiki su Wikia, trovane di più interessanti per te andando su uno dei nostri hub: Videogiochi (http://www.wikia.com/Video_Games), Intrattenimento (http://www.wikia.com/Entertainment) o Stili di vita (http://www.wikia.com/Lifestyle).

Vai su $EXPLOREWIKISURL

Vuoi maggiori informazioni? Trova consigli, risposte e la community di Wikia su la Wiki della Community (http://it.community.wikia.com). Happy editing!

Il team di Wikia


___________________________________________

Per controllare le ultime novità su Wikia, vai su http://it.community.wikia.com
Vuoi controllare le email che ricevi? Vai su: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Unisciti adesso a Wikia',
	'usersignup-heading-byemail' => 'Crea un account per qualcun altro',
	'usersignup-marketing-wikia' => 'Inizia a collaborare con milioni di persone da tutto il mondo che si ritrovano per condividere ciò che conoscono ed amano.',
	'usersignup-marketing-login' => 'Già un utente? [[Special:UserLogin|Accedi]]',
	'usersignup-marketing-benefits' => 'Sii parte di qualcosa di grande',
	'usersignup-marketing-community-heading' => 'Collabora',
	'usersignup-marketing-community' => 'Scopri ed esplora argomenti che vanno da videogiochi a film e televisione. Incontra persone con interessi e passioni simili.',
	'usersignup-marketing-global-heading' => 'Crea',
	'usersignup-marketing-global' => "Crea una wiki. Inizia in piccolo, diventa grande con l'aiuto degli altri.",
	'usersignup-marketing-creativity-heading' => 'Sii originale',
	'usersignup-marketing-creativity' => 'Usa Wikia per esprimere la tua creatività con sondaggi e liste top 10, immagini e gallerie video, app e molto altro.',
	'usersignup-createaccount-byemail' => 'Crea un account per qualcun altro',
	'usersignup-error-captcha' => 'La risposta alla sfida è scorretta, riprova!', # Fuzzy
	'usersignup-account-creation-heading' => 'Successo!',
	'usersignup-account-creation-subheading' => 'Abbiamo inviato una email a $1',
	'usersignup-account-creation-email-sent' => "Hai avviato la creazione di un account per $2. Gli abbiamo inviato una email a $1 con una password temporanea e un link di conferma.


$2 deve cliccare sul link presente nella email che gli abbiamo inviato per convalidare il suo account e cambiare la password temporanea completando la creazione dell'account.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Crea altri account] su {{SITENAME}}",
	'usersignup-account-creation-email-subject' => 'Un account è stato create per te su Wikia!',
	'usersignup-account-creation-email-greeting' => 'Ciao,',
	'usersignup-account-creation-email-content' => 'Un account è stato creato per te su {{SITENAME}}. Per accedere al tuo account e cambiare la tua password temporanea clicca sul link qui sotto e accedi con il nome utente "$USERNAME" e la password "$NEWPASSWORD".

Per favore, accedi a <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Se non vuoi che questo account venga creato puoi semplicemente ignorare questa email o contattare il nostro team di supporto per qualunque domanda.',
	'usersignup-account-creation-email-signature' => 'Il team di Wikia',
	'usersignup-account-creation-email-body' => 'Ciao,

Un account è stato creato per te su {{SITENAME}}. Per accedere al tuo account e cambiare la tua password temporanea clicca sul link qui sotto e accedi con il nome utente "$2" e la password "$3".

Per favore, accedi a {{fullurl:{{ns:special}}:UserLogin}}

Se non vuoi che questo account venga creato puoi semplicemente ignorare questa email o contattare il nostro team di supporto per qualunque domanda.

Il team di Wikia


___________________________________________

Per controllare le ultime novità su Wikia, vai su http://it.community.wikia.com
Vuoi controllare le email che ricevi? Vai su: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => "C'è stato un problema di comunicazione con Facebook. Per favore, riprova più tardi.",
	'usersignup-facebook-signup-header' => 'Stai creando un nuovo account?',
	'usersignup-facebook-login-header' => 'Hai già un account?',
);

/** Japanese (日本語)
 * @author Shirayuki
 * @author Tommy6
 */
$messages['ja'] = array(
	'usersignup-page-title' => 'Wikiaに参加しよう',
	'usersignup-page-title-wikiamobile' => 'アカウントを作成',
	'usersignup-page-captcha-label' => '画像認証',
	'usersignup-error-username-length' => 'ユーザー名は $1 文字以下にしてください。',
	'usersignup-error-invalid-user' => '有効でないユーザーです。まずはログインしてください。',
	'usersignup-error-invalid-email' => 'メールアドレスを入力してください。',
	'usersignup-error-symbols-in-username' => 'ユーザー名に含むことができるのは文字と数字のみです。',
	'usersignup-error-empty-email' => 'メールアドレスを入力してください。',
	'usersignup-error-empty-username' => 'ユーザー名を入力してください。',
	'usersignup-error-already-confirmed' => 'このメールアドレスは認証済みです。',
	'usersignup-error-throttled-email' => '本日、認証メールのリクエストを何度もいただいているようです。しばらくしてからもう一度お試しください。',
	'usersignup-error-too-many-changes' => 'メールアドレスの変更可能回数が本日の上限に達しました。しばらくしてからもう一度お試しください。',
	'usersignup-error-password-length' => 'パスワードが長すぎるようです。50文字以下のパスワードをご指定ください。',
	'usersignup-error-confirmed-user' => '$1 のメールアドレスは既に認証済みのようです。[$2 ユーザー プロフィール] をご確認ください。',
	'usersignup-facebook-heading' => '登録を完了してください',
	'usersignup-facebook-create-account' => 'アカウントを作成',
	'usersignup-facebook-email-tooltip' => '別のメールアドレスの使用をご希望の場合には、個人設定で変更することができます。',
	'usersignup-facebook-have-an-account-heading' => '既にアカウントをお持ちの方はログインしてください。',
	'usersignup-facebook-have-an-account' => '既存のWikiaのユーザー名とFacebookをコネクトすることもできます。',
	'usersignup-facebook-proxy-email' => '匿名Facebookメール',
	'usersignup-user-pref-emailconfirmlink' => '新しい認証メールをリクエストする',
	'usersignup-user-pref-confirmemail_send' => '認証メールを再送信する',
	'usersignup-user-pref-emailauthenticated' => 'このメールアドレスは$2、$3に認証されました。ありがとうございます。',
	'usersignup-user-pref-emailnotauthenticated' => 'メールを確認し、認証用リンクをクリックしてメールアドレスの $1 への変更を完了してください。',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'メールアドレスの認証が完了していません。メール機能はメールアドレスの認証が完了するまでご利用いただくことができません。',
	'usersignup-user-pref-reconfirmation-email-sent' => 'もうすぐ完了します。$1 に新しい認証メールを送信しました。メールを確認し、リンクをクリックしてメールアドレスの認証を完了してください。',
	'usersignup-user-pref-noemailprefs' => 'メールアドレスが指定されていないようです。メールアドレスを入力してください。',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'メールアドレスの認証が完了していません。Wikiaからメールを送信しましたので、そのメール内の認証用リンクをクリックして認証を行ってください。',
	'usersignup-user-pref-confirmemail_noemail' => 'メールアドレスが指定されていないようです。[[Special:Preferences|個人設定]] にアクセスして入力してください。',
	'usersignup-confirm-page-title' => 'メールアドレスの認証',
	'usersignup-confirm-page-title-wikiamobile' => 'メールを確認してください',
	'usersignup-confirm-email-resend-email' => 'もう一度メールを送る',
	'usersignup-confirm-email-change-email-content' => '別のメールアドレスでアカウントを作成したい場合',
	'usersignup-confirm-email-change-email' => 'メールアドレスを変更する',
	'usersignup-confirm-email-new-email-label' => '新しいメールアドレス',
	'usersignup-confirm-email-update' => '更新',
	'usersignup-confirm-email-tooltip' => '認証できないメールアドレスを入力してしまった場合、または別のメールアドレスを使用したい場合は、下のリンクからメールアドレスを変更して新しい認証メールを受信することができます。',
	'usersignup-resend-email-heading-success' => '新しい認証メールを送信しました',
	'usersignup-resend-email-heading-failure' => '認証メールを再送信できませんでした',
	'usersignup-confirm-page-heading-confirmed-user' => '認証が完了しました。',
	'usersignup-confirm-page-subheading-confirmed-user' => '認証は既に完了しています',
	'usersignup-confirmation-heading' => '最後のステップ',
	'usersignup-confirmation-heading-wikiamobile' => 'メールを確認してください',
	'usersignup-confirmation-heading-email-resent' => '新しい認証メールを送信しました',
	'usersignup-confirmation-subheading' => 'メールを確認してください',
	'usersignup-confirmation-email-sent' => "'''$1''' にアカウント認証用メールをお送りしました。

メール本文内のリンクをクリックすることで、アカウントの作成が完了します。",
	'usersignup-confirmation-email-sent-wikiamobile' => "'''$1''' にメールを送信しました。

メール内の認証用リンクをクリックしてアカウントの作成を完了してください。どうもありがとうございます。",
	'usersignup-reconfirmation-email-sent' => 'メールアドレスを $1 に変更しました。新しい認証メールを送信しましたので、新しいメールアドレスの認証を行ってください。',
	'usersignup-welcome-email-subject' => '$USERNAME さん、Wikiaへようこそ！',
	'usersignup-welcome-email-greeting' => '$USERNAME さん',
	'usersignup-welcome-email-heading' => 'この度は、Wikiaと {{SITENAME}} にご登録いただき、ありがとうございます。ご利用を開始いただくにあたり、Wikiaでできることをこちらにいくつかご紹介します。',
	'usersignup-welcome-email-edit-profile-heading' => 'プロフィールを編集しよう。',
	'usersignup-welcome-email-edit-profile-content' => '{{SITENAME}} のプロフィールページにプロフィール写真や簡単な自己紹介を追加してみましょう。',
	'usersignup-welcome-email-edit-profile-button' => 'プロフィールにアクセス',
	'usersignup-welcome-email-learn-basic-heading' => '基本について知ろう。',
	'usersignup-welcome-email-learn-basic-content' => 'Wikiaについての基本（ページやユーザープロフィールの編集方法、設定の変更方法など）をご紹介するチュートリアルをご用意しています。ぜひ利用ください。',
	'usersignup-welcome-email-learn-basic-button' => 'チェックする',
	'usersignup-welcome-email-explore-wiki-heading' => '色々なWikiaコミュニティを見てみよう。',
	'usersignup-welcome-email-explore-wiki-content' => 'Wikiaには何千ものコミュニティがあります。<a style="color:#2C85D5;" href="http://ja.videogameshub.wikia.com/">ゲーム</a>、<a style="color:#2C85D5;" href="http://ja.entertainmenthub.wikia.com/">エンターテイメント</a>、<a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">ライフスタイル</a>のハブから、他にもおもしろそうなWikiaコミュニティを探してみましょう。',
	'usersignup-welcome-email-explore-wiki-button' => 'wikia.com にアクセス',
	'usersignup-welcome-email-content' => '詳しくは、<a style="color:#2C85D5;" href="http://community.wikia.com">コミュニティ セントラル</a>にてアドバイス、回答、いろいろなWikiaコミュニティをご覧ください。それではどうぞ編集をお楽しみください。',
	'usersignup-welcome-email-signature' => 'Wikiaチーム',
	'usersignup-welcome-email-body' => '$USERNAME さん

この度は、Wikiaと {{SITENAME}} にご登録いただき、ありがとうございます。ご利用を開始いただくにあたり、Wikiaでできることをこちらにいくつかご紹介します。

プロフィールを編集しよう。

{{SITENAME}} プロフィールにプロフィール写真や簡単な自己紹介を追加しましょう。

$EDITPROFILEURL にアクセス

基本について知ろう。

Wikiaについての基本情報（ページやユーザー プロフィールの編集方法、設定の変更方法など）をご紹介するチュートリアルをご用意しています。ぜひ利用ください。

チェックする（$LEARNBASICURL）

色々なWikiaコミュニティを見てみよう。

Wikiaには何千ものコミュニティがあります。<a style="color:#2C85D5;" href="http://ja.videogameshub.wikia.com/">ゲーム</a>、<a style="color:#2C85D5;" href="http://ja.entertainmenthub.wikia.com/">エンターテイメント</a>、<a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">ライフスタイル</a>のハブから、他にもおもしろそうなウィキを探してみましょう。

$EXPLOREWIKISURL にアクセス

詳しくは、コミュニティ セントラル（http://www.community.wikia.com）にてアドバイス、回答、いろいろなWikiaコミュニティをご覧ください。それではどうぞ編集をお楽しみください。

Wikia チーム


___________________________________________

Wikiaの最新情報については http://community.wikia.com をご覧ください
メール通知に関する設定は {{fullurl:{{ns:special}}:個人設定}} のページで行っていただけます',
	'usersignup-heading' => 'Wikiaに参加しよう',
	'usersignup-heading-byemail' => '他のユーザーのためにアカウントを作成する',
	'usersignup-marketing-wikia' => ' ',
	'usersignup-marketing-login' => '既にアカウントをお持ちの方はログインしてください。 [[Special:UserLogin|ログイン]]',
	'usersignup-marketing-benefits' => ' ',
	'usersignup-marketing-community-heading' => ' ',
	'usersignup-marketing-community' => ' ',
	'usersignup-marketing-global-heading' => ' ',
	'usersignup-marketing-global' => ' ',
	'usersignup-marketing-creativity-heading' => ' ',
	'usersignup-marketing-creativity' => ' ',
	'usersignup-createaccount-byemail' => '他のユーザーのためにアカウントを作成する',
	'usersignup-error-captcha' => '回答が違っています。もう一度お試しください。',
	'usersignup-account-creation-heading' => '認証が完了しました。',
	'usersignup-account-creation-subheading' => '$1 にメールを送信しました',
	'usersignup-account-creation-email-sent' => '$2 さんのアカウント作成手続きを開始しました。$1 に一時パスワードと認証用リンクを記載したメールを送信しました。


$2 さんには、Wikiaから送信したメールに記載のリンクをクリックしてアカウントの認証を行い、一時パスワードを変更してアカウントの作成を完了していただく必要があります。


{{SITENAME}} で [{{fullurl:{{ns:special}}:UserSignup|byemail=1}} 他のアカウントを作成]',
	'usersignup-account-creation-email-subject' => 'Wikiaであなたのアカウントが作成されました。',
	'usersignup-account-creation-email-greeting' => 'こんにちは。',
	'usersignup-account-creation-email-content' => '{{SITENAME}} であなたのアカウントが作成されました。アカウントにアクセスして一時パスワードを変更するには、下のリンクをクリックしてユーザー名「$USERNAME」とパスワード「$NEWPASSWORD」でログインしてください。

<a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:ユーザーログイン}}</a> からログインしてください。

このアカウントの作成を取り消したい場合は、このメールを無視していただいて構いません。また、その他ご不明な点がございましたら、コミュニティサポートチームにお問い合わせください。',
	'usersignup-account-creation-email-signature' => 'Wikiaチーム',
	'usersignup-account-creation-email-body' => 'こんにちは。

{{SITENAME}} であなたのアカウントが作成されました。アカウントにアクセスして一時パスワードを変更するには、下のリンクをクリックしてユーザー名「$2」とパスワード「$3」でログインしてください。

{{fullurl:{{ns:special}}:ユーザーログイン}} からログインしてください

このアカウントの作成を取り消したい場合は、このメールを無視していただいて構いません。また、その他ご不明な点がございましたら、コミュニティサポートチームにお問い合わせください。

Wikia チーム


___________________________________________

Wikiaの最新情報については http://community.wikia.com をご覧ください
メール通知に関する設定は {{fullurl:{{ns:special}}:個人設定}} のページで行っていただけます',
	'usersignup-facebook-problem' => 'Facebookとの通信中にエラーが発生しました。しばらくしてからもう一度お試しください。',
	'usersignup-facebook-signup-header' => '新しいアカウントを作成しますか？',
	'usersignup-facebook-login-header' => '既にアカウントをお持ちの方はログインしてください。',
	'usersignup-account-creation-email-body-HTML' => '',
);

/** Georgian (ქართული)
 * @author MIKHEIL
 */
$messages['ka'] = array(
	'usersignup-facebook-signup-header' => 'გსურთ შექმნათ ახალი ანგარიში?',
	'usersignup-facebook-login-header' => 'უკვე რეგისტრირებული ხართ?',
);

/** Korean (한국어)
 * @author Gusdud25
 * @author Miri-Nae
 */
$messages['ko'] = array(
	'usersignup-page-title' => '위키아 가입하기',
	'usersignup-page-title-wikiamobile' => '계정 만들기',
	'usersignup-page-captcha-label' => '질문',
	'usersignup-error-username-length' => '이런! 사용자 이름은 {{PLURAL:$1|한 글자|$1자}}를 넘을 수 없습니다.',
	'usersignup-error-invalid-user' => '잘못된 사용자입니다. 먼저 로그인을 해주세요.',
	'usersignup-error-invalid-email' => '유효한 이메일 주소를 입력해 주세요.',
	'usersignup-error-symbols-in-username' => '이런! 사용자 이름에는 알파벳과 숫자만 사용할 수 있습니다.',
	'usersignup-error-empty-email' => '이런! 이메일 주소를 입력해 주세요.',
	'usersignup-error-empty-username' => '이런! 사용자 이름을 입력해 주세요.',
	'usersignup-error-already-confirmed' => '이 이메일 주소는 이미 인증되었습니다.',
	'usersignup-error-throttled-email' => '이런! 귀하는 오늘 하루 동안 너무 많은 인증 이메일을 요청했습니다. 나중에 다시 시도해 주세요.',
	'usersignup-error-too-many-changes' => '귀하는 오늘 하루 동안 너무 많이 이메일 주소를 변경했습니다. 나중에 다시 시도해 주세요.',
	'usersignup-error-password-length' => '이런! 비밀번호가 너무 깁니다. 비밀번호는 50자 이하로 설정해 주세요.',
	'usersignup-error-confirmed-user' => '$1 이메일 주소는 이미 인증되었습니다! [$2 사용자 프로필]을 확인해 보세요.', # Fuzzy
	'usersignup-facebook-heading' => '가입 완료',
	'usersignup-facebook-create-account' => '계정 만들기',
	'usersignup-facebook-email-tooltip' => '다른 이메일 주소를 사용하고 싶을 땐 이후에 환경 설정에서 변경할 수 있습니다.',
	'usersignup-facebook-have-an-account-heading' => '이미 계정을 가지고 계신가요?',
	'usersignup-facebook-have-an-account' => '귀하의 위키아 사용자명과 페이스북 계정을 연동해 보세요.',
	'usersignup-facebook-proxy-email' => '익명 페이스북 이메일',
	'usersignup-user-pref-emailconfirmlink' => '새 인증 이메일 요청',
	'usersignup-user-pref-confirmemail_send' => '인증 이메일 재발송',
	'usersignup-user-pref-emailauthenticated' => '감사합니다! 귀하의 이메일은 $2 $3에 인증되었습니다.',
	'usersignup-user-pref-emailnotauthenticated' => '이메일 변경을 완료하려면 귀하에게 발송된 이메일에서 인증 링크를 클릭하세요: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => '이런! 귀하의 이메일은 인증되지 않았습니다. 이메일 주소를 인증하기 전까진 이메일 기능을 사용할 수 없습니다.',
	'usersignup-user-pref-reconfirmation-email-sent' => '거의 다 됐어요! $1 주소로 새 인증 이메일을 보냈습니다. 이메일 인증을 완료하려면 귀하에게 발송된 이메일에서 인증 링크를 클릭하세요.',
	'usersignup-user-pref-noemailprefs' => '귀하의 이메일 주소에 대한 정보를 찾을 수 없습니다. 위의 입력란에 이메일 주소를 적어 주세요.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => '이런! 귀하의 이메일은 아직 인증되지 않았습니다. 이메일을 전송했으니 해당 이메일에서 인증 링크를 눌러 인증을 완료해 주세요.',
	'usersignup-user-pref-confirmemail_noemail' => '귀하의 이메일 주소에 대한 정보를 찾을 수 없습니다. [[Special:Preferences|환경 설정]]에서 이메일 주소를 적어 주세요.',
	'usersignup-confirm-page-title' => '이메일 주소 인증하기',
	'usersignup-confirm-page-title-wikiamobile' => '이메일 주소 확인',
	'usersignup-confirm-email-resend-email' => '인증 이메일 재전송',
	'usersignup-confirm-email-change-email-content' => '다른 이메일 주소를 사용하고 싶어요.',
	'usersignup-confirm-email-change-email' => '이메일 주소 변경',
	'usersignup-confirm-email-new-email-label' => '새 이메일',
	'usersignup-confirm-email-update' => '갱신',
	'usersignup-confirm-email-tooltip' => '인증할 수 없는 이메일 주소를 입력했거나 그 외의 이유로 다른 이메일 주소를 사용하고 싶으신가요? 그렇다면 걱정하지 마세요. 아래의 링크를 통해 이메일 주소를 변경하고 새 인증 이메일을 받을 수 있습니다.',
	'usersignup-resend-email-heading-success' => '새 이메일이 전송되었습니다',
	'usersignup-resend-email-heading-failure' => '이메일을 전송하는 데 실패했습니다',
	'usersignup-confirm-page-heading-confirmed-user' => '축하드립니다!',
	'usersignup-confirm-page-subheading-confirmed-user' => '이미 이메일을 인증했습니다',
	'usersignup-confirmation-heading' => '거의 다 됐어요',
	'usersignup-confirmation-heading-wikiamobile' => '이메일 주소 확인',
	'usersignup-confirmation-heading-email-resent' => '새 이메일이 전송되었습니다',
	'usersignup-confirmation-subheading' => '이메일 주소 확인',
	'usersignup-confirmation-email-sent' => "'''$1'''로 이메일을 전송했습니다.

해당 이메일에서 인증 링크를 눌러 계정 생성을 완료하세요.",
	'usersignup-confirmation-email-sent-wikiamobile' => "'''$1'''로 이메일을 전송했습니다.

해당 이메일에서 인증 링크를 눌러 계정 생성을 완료하세요. 감사합니다!",
	'usersignup-reconfirmation-email-sent' => '귀하의 이메일 주소가 $1로 변경되었습니다. 새 인증 이메일을 전송했으니 해당 이메일을 인증해 주세요.',
	'usersignup-welcome-email-subject' => '위키아에 오신 것을 환영합니다, $USERNAME 님!',
	'usersignup-welcome-email-greeting' => '안녕하세요, $USERNAME 님.',
	'usersignup-welcome-email-heading' => '귀하를 위키아와 {{SITENAME}}에 맞이하게 되어서 정말 기쁩니다! 아래 내용을 참고해서 위키아 활동을 본격적으로 시작해 보세요.',
	'usersignup-welcome-email-edit-profile-heading' => '프로필 편집하기',
	'usersignup-welcome-email-edit-profile-content' => '{{SITENAME}}에서 귀하의 프로필에 프로필 사진을 추가하고 간단한 정보를 적어 넣어 보세요.',
	'usersignup-welcome-email-edit-profile-button' => '프로필 바로 가기',
	'usersignup-welcome-email-learn-basic-heading' => '기초 사항 배우기',
	'usersignup-welcome-email-learn-basic-content' => '어떻게 문서를 편집하는지, 어떻게 설정을 변경하는지 등 위키아에서 활동하기 위한 기초적인 정보들을 배워 보세요.',
	'usersignup-welcome-email-learn-basic-button' => '확인하기',
	'usersignup-welcome-email-explore-wiki-heading' => '더 많은 위키 찾아보기',
	'usersignup-welcome-email-explore-wiki-content' => '위키아에는 수많은 위키가 존재합니다. 허브에서 귀하의 관심을 끄는 위키를 찾아 보세요: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">게임</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">엔터테인먼트</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">생활</a>',
	'usersignup-welcome-email-explore-wiki-button' => 'Wikia.com 방문하기',
	'usersignup-welcome-email-content' => '더 많은 정보를 원하시나요? 조언을 얻고, 질문을 하고, 다른 사용자들과 소통하려면 <a style="color:#2C85D5;" href="http://ko.community.wikia.com">위키아 중앙 커뮤니티</a>를 방문해 보세요. 즐거운 위키아 생활 되세요!',
	'usersignup-welcome-email-signature' => '위키아 팀',
	'usersignup-welcome-email-body' => '안녕하세요, $USERNAME 님.

귀하를 위키아와 {{SITENAME}}에 맞이하게 되어서 정말 기쁩니다! 아래 내용을 참고해서 위키아 활동을 본격적으로 시작해 보세요.

프로필 편집하기

{{SITENAME}}에서 귀하의 프로필에 프로필 사진을 추가하고 간단한 정보를 적어 넣어 보세요.

$EDITPROFILEURL 바로 가기

기초 사항 배우기

어떻게 문서를 편집하는지, 어떻게 설정을 변경하는지 등 위키아에서 활동하기 위한 기초적인 사항들을 배워 보세요.

확인하기 ($LEARNBASICURL)

더 많은 위키 찾아보기

위키아에는 수많은 위키가 존재합니다. 허브에서 귀하의 관심을 끄는 위키를 찾아 보세요: 게임 (http://www.wikia.com/Video_Games), 엔터테인먼트 (http://www.wikia.com/Entertainment), 생활 (http://www.wikia.com/Lifestyle)

$EXPLOREWIKISURL 방문하기

더 많은 정보를 원하시나요? 조언을 얻고, 질문을 하고, 다른 사용자들과 소통하려면 위키아 중앙 커뮤니티(http://ko.community.wikia.com)를 방문해 보세요. 즐거운 위키아 생활 되세요!

위키아 팀


___________________________________________

위키아의 최근 소식을 찾아보시려면 이곳을 방문해 주세요: http://ko.community.wikia.com
받을 이메일 종류를 선택하고 싶으시다면 이곳을 방문해 주세요: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => '위키아에 참여해 보세요',
	'usersignup-heading-byemail' => '다른 사람을 위해 계정 만들기',
	'usersignup-marketing-wikia' => '자신의 관심사를 공유하고자 모여든 전세계의 수많은 사람들과 함께 협업을 시작해 보세요.',
	'usersignup-marketing-login' => '계정이 이미 있다면 [[Special:UserLogin|로그인]]하세요.',
	'usersignup-marketing-benefits' => '거대한 공동체의 일부가 되어 주세요',
	'usersignup-marketing-community-heading' => '협업하기',
	'usersignup-marketing-community' => '비디오 게임에서부터 영화, TV에 이르기까지 다양한 주제들을 발견하고 탐색해 보세요. 비슷한 관심사와 열정을 가진 사람들을 만나보세요.',
	'usersignup-marketing-global-heading' => '창조하기',
	'usersignup-marketing-global' => '새 위키를 시작하세요. 작은 것부터 시작해서 다른 이들과 힘을 모아 크게 성장하세요.',
	'usersignup-marketing-creativity-heading' => '독창성 발휘하기',
	'usersignup-marketing-creativity' => '위키아의 다양한 추가 기능인 설문조사, 상위 10 목록, 그림과 동영상 갤러리 등을 이용하여 창의성을 발휘해 보세요.',
	'usersignup-createaccount-byemail' => '다른 사람을 위해 계정 만들기',
	'usersignup-error-captcha' => '답변이 올바르지 않습니다. 다시 시도해 주세요!',
	'usersignup-account-creation-heading' => '성공!',
	'usersignup-account-creation-subheading' => '$1로 이메일을 전송했습니다.',
	'usersignup-account-creation-email-sent' => '귀하는 $2 사용자를 위한 계정 생성 과정을 시작하셨습니다. $1로 임시 비밀번호와 인증 링크를 전송했습니다.


계정 생성을 완료하기 위해선 $2 사용자가 해당 이메일에서 인증 링크를 눌러 이메일을 인증하고 임시 비밀번호를 변경해야 합니다.


{{SITENAME}}에 [{{fullurl:{{ns:special}}:UserSignup|byemail=1}} 더 많은 계정 만들기]',
	'usersignup-account-creation-email-subject' => '귀하를 위한 위키아 계정이 생성되었습니다!',
	'usersignup-account-creation-email-greeting' => '안녕하세요,',
	'usersignup-account-creation-email-content' => '귀하를 위해 {{SITENAME}}에 귀하의 계정이 생성되었습니다. 귀하의 계정으로 접속해서 임시 비밀번호를 변경하시려면 먼저 아래의 인증 링크를 눌러 이메일을 인증하고, 사용자 이름 "$USERNAME"과 비밀번호 "$NEWPASSWORD"로 위키아에 로그인해 주세요.

로그인은 <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>에서 하실 수 있습니다.

계정을 만들고 싶지 않으시다면 그냥 이 이메일을 무시하시거나 위키아 지원 팀에 문의를 넣어 주세요.',
	'usersignup-account-creation-email-signature' => '위키아 팀',
	'usersignup-account-creation-email-body' => '안녕하세요,

귀하를 위해 {{SITENAME}}에 귀하의 계정이 생성되었습니다. 귀하의 계정으로 접속해서 임시 비밀번호를 변경하시려면 먼저 아래의 인증 링크를 눌러 이메일을 인증하고, 사용자 이름 "$2"과 비밀번호 "$3"로 위키아에 로그인해 주세요.

로그인은 {{fullurl:{{ns:special}}:UserLogin}}에서 하실 수 있습니다.

계정을 만들고 싶지 않으시다면 그냥 이 이메일을 무시하시거나 위키아 지원 팀에 문의를 넣어 주세요.

위키아 팀


___________________________________________

위키아의 최근 소식을 찾아보시려면 이곳을 방문해 주세요: http://ko.community.wikia.com
받을 이메일 종류를 선택하고 싶으시다면 이곳을 방문해 주세요: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => '페이스북과 통신하던 중 문제가 발생했습니다. 나중에 다시 시도해 주세요.',
	'usersignup-facebook-signup-header' => '새 계정을 생성하시겠어요?',
	'usersignup-facebook-login-header' => '이미 계정을 가지고 계신가요?',
);

/** Karachay-Balkar (къарачай-малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'usersignup-facebook-create-account' => 'Аккаунт къурау',
	'usersignup-confirm-email-update' => 'Джангырт',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Bikarhêner
 */
$messages['ku-latn'] = array(
	'usersignup-account-creation-email-greeting' => 'Silav,',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'usersignup-page-captcha-label' => 'Erausfuerderung',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'usersignup-page-title' => 'Придружете ни се на Викија',
	'usersignup-page-title-wikiamobile' => 'Направи сметка',
	'usersignup-page-captcha-label' => 'Заматен збор', # Fuzzy
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
	'usersignup-error-confirmed-user' => 'Изгледа веќе ја имате потврдено вашата е-пошта за $1! Проверете си го [$2 корисничкиот профил].', # Fuzzy
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
	'usersignup-confirm-page-title-wikiamobile' => 'Проверете си ја е-поштата',
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
	'usersignup-confirmation-heading-wikiamobile' => 'Проверете си ја е-поштата',
	'usersignup-confirmation-heading-email-resent' => 'Новата порака е испратена',
	'usersignup-confirmation-subheading' => 'Проверете си ја е-поштата',
	'usersignup-confirmation-email-sent' => "Ви испративме порака на '''$1'''.

Стиснете на потврдната врска во пораката за да го довршите создавањето на сметката.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Ви испративме порака на '''$1'''.

Стиснете на потврдната врска во пораката за да го довршите создавањето на сметката. Ви благодариме!",
	'usersignup-reconfirmation-email-sent' => 'Вашата е-пошта е сменета на $1. Ви испративме нова потврдна порака. Потврдете ја вашата е-пошта.',
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
	'usersignup-error-captcha' => 'Внесениот збор не одговара на оној во полето. Обидете се потворно!', # Fuzzy
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
	'usersignup-facebook-problem' => 'Се појави проблем при општењето со Facebook. Обидете се подоцна.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'usersignup-page-title' => 'Sertai Wikia',
	'usersignup-page-title-wikiamobile' => 'Buka akaun',
	'usersignup-page-captcha-label' => 'Cabaran',
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
	'usersignup-error-confirmed-user' => 'Nampaknya anda sudah sahkan alamat e-mel anda untuk $1!  Lihat [$2 profil pengguna] anda.',
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
	'usersignup-confirm-page-title-wikiamobile' => 'Semak e-mel anda',
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
	'usersignup-confirmation-heading-wikiamobile' => 'Semak e-mel anda',
	'usersignup-confirmation-heading-email-resent' => 'E-mel baru dihantar',
	'usersignup-confirmation-subheading' => 'Semak e-mel anda',
	'usersignup-confirmation-email-sent' => "Kami telah menghantar e-mel kepada '''$1'''.

Klik pautan pengesahan dalam e-mel anda untuk menyiapkan pembukaan akaun anda.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Kami telah mengirim e-mel ke '''$1'''.

Klik pautan pengesahan pada e-mel anda untuk melengkapkan pembukaan akaun anda. Terima kasih.",
	'usersignup-reconfirmation-email-sent' => 'Alamat e-mel anda telah ditukar kepada $1. Kami telah menghantar e-mel pengesahan yang baru kepada anda. Sila sahkan alamat e-mel baru ini.',
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
	'usersignup-error-captcha' => 'Cabaran tersalah jawab, sila cuba lagi!',
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
	'usersignup-facebook-problem' => 'Timbulnya masalah ketika berhubung dengan Facebook. Sila cuba lagi nanti.',
	'usersignup-facebook-signup-header' => 'Nak buka akaun baru?',
	'usersignup-facebook-login-header' => 'Sudah ada akaun?',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'usersignup-page-title' => 'Bli med i Wikia',
	'usersignup-page-captcha-label' => 'Uklart ord', # Fuzzy
	'usersignup-error-username-length' => 'Ops, brukernavnet ditt kan ikke bestå av mer enn {{PLURAL:$1|ett tegn|$1 tegn}}.',
	'usersignup-error-invalid-user' => 'Ugyldig bruker. Vennligst logg inn først.',
	'usersignup-error-invalid-email' => 'Vennligst oppgi en gyldig e-postadresse.',
	'usersignup-error-symbols-in-username' => 'Ops, brukernavnet ditt kan bare bestå av bokstaver og tall.',
	'usersignup-error-empty-email' => 'Ops, vennligst skriv inn e-postadressen din.',
	'usersignup-error-empty-username' => 'Ops, vennligst fyll ut brukernavnsfeltet.',
	'usersignup-error-already-confirmed' => 'Du har allerede bekreftet denne e-postadressen.',
	'usersignup-error-throttled-email' => 'Ops, du har bedt om å få tilsendt for mange bekreftelses-e-poster  i dag. Prøv igjen om en liten stund.',
	'usersignup-error-too-many-changes' => 'Du har nådd den øvre grensen for e-postendringer i dag. Vennligst prøv igjen senere.',
	'usersignup-error-password-length' => 'Ops, passordet ditt er for langt. Vennligst velg et passord som består av 50 tegn eller mindre.',
	'usersignup-error-confirmed-user' => 'Det ser ut til at du allerede har bekreftet e-postadressen din for $1! Sjekk ut [$2 brukerprofilen din].', # Fuzzy
	'usersignup-facebook-heading' => 'Fullfør registrering',
	'usersignup-facebook-create-account' => 'Opprett konto',
	'usersignup-facebook-email-tooltip' => 'Hvis du vil bruke en annen e-postadresse kan du endre den senere i innstillingene dine.',
	'usersignup-facebook-have-an-account-heading' => 'Har du allerede en konto?',
	'usersignup-facebook-have-an-account' => 'Koble sammen det eksisterende Wikia-brukernavnet ditt med Facebook istedenfor.',
	'usersignup-facebook-proxy-email' => 'Anonym facebook-e-post',
	'usersignup-user-pref-emailconfirmlink' => 'Be om en ny bekreftelses-e-post',
	'usersignup-user-pref-confirmemail_send' => 'Send bekreftelses-e-posten min igjen',
	'usersignup-user-pref-emailauthenticated' => 'Takk! E-posten din ble bekreftet den $2 kl. $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Sjekk e-posten din og trykk på bekreftelseslenken for å fullføre endringen av e-post til: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Åh, nei! E-posten din er ubekreftet. E-postfunksjoner vil ikke fungere før du har bekreftet e-postadressen din.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Nesten ferdig! Vi har sendt deg en ny bekreftelses-e-post til $1. Sjekk e-posten din og trykk på lenken for å fullføre bekreftelsen av din nye e-postadresse.',
	'usersignup-user-pref-noemailprefs' => 'Det ser ut til at vi ikke har noen e-postadresse for deg. Vennligst oppgi en e-postadresse over.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Åh, nei! E-posten din er ubekreftet. Vi har sendt deg en e-post, trykk på bekreftelseslenken der for å bekrefte.',
	'usersignup-user-pref-confirmemail_noemail' => 'Det ser ut til at vi ikke har en e-postadresse for deg. Gå til [[Special:Preferences|brukerinnstillinger]] for å oppgi en.',
	'usersignup-confirm-page-title' => 'Bekreft e-posten din',
	'usersignup-confirm-email-resend-email' => 'Send meg en ny bekreftelses-e-post',
	'usersignup-confirm-email-change-email-content' => 'Jeg vil bruke en annen e-postadresse.',
	'usersignup-confirm-email-change-email' => 'Endre e-postadressen min',
	'usersignup-confirm-email-new-email-label' => 'Ny e-post',
	'usersignup-confirm-email-update' => 'Oppdater',
	'usersignup-confirm-email-tooltip' => 'Oppga du en e-postadresse du ikke kan bekrefte, eller vil bruke en annen e-postadresse? Ikke bekymre deg, bruk lenken under for å endre e-postadresse din og få en ny bekreftelses-e-post.',
	'usersignup-resend-email-heading-success' => 'Ny e-post sendt',
	'usersignup-resend-email-heading-failure' => 'E-post ikke sendt på nytt',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gratulerer!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Du er allerede bekreftet',
	'usersignup-confirmation-heading' => 'Nesten ferdig',
	'usersignup-confirmation-heading-email-resent' => 'Ny e-post sendt',
	'usersignup-confirmation-subheading' => 'Sjekk e-posten din',
	'usersignup-confirmation-email-sent' => "Vi sendte en e-post til '''$1'''.

Trykk på bekreftelseslenken i e-posten din for å fullføre opprettelsen av kontoen.",
	'usersignup-reconfirmation-email-sent' => 'E-postadressen din har blitt endret til $1. Vi har sendt deg en ny bekreftelses-e-post. Vennligst bekreft den nye e-postadressen.',
	'usersignup-welcome-email-subject' => 'Velkommen til Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hei $USERNAME',
	'usersignup-welcome-email-heading' => 'Det er med glede vi ønsker deg velkommen til Wikia og {{SITENAME}}! Her er noen ting du kan gjøre for å komme i gang.',
	'usersignup-welcome-email-edit-profile-heading' => 'Redigere profilen din.',
	'usersignup-welcome-email-edit-profile-content' => 'Legg til et profilbilde og noen kjappe fakta om deg selv på {{SITENAME}}-profilen din.',
	'usersignup-welcome-email-edit-profile-button' => 'Gå til profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Lære det grunnleggende.',
	'usersignup-welcome-email-learn-basic-content' => 'Få en kort opplæring innen det mest grunnleggende du finner hos Wikia: hvordan redigere en side, brukerprofilen din, endring av innstillingene dine, og mer til.',
	'usersignup-welcome-email-learn-basic-button' => 'Sjekk det ut',
	'usersignup-welcome-email-explore-wiki-heading' => 'Utforske flere wikier.',
	'usersignup-welcome-email-explore-wiki-content' => 'Det er tusenvis av wikier hos Wikia, finn flere wikier som interesserer deg ved å besøke en av hubbene våre: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Videospill</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">underholdning</a>, eller <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">livsstil</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Gå til wikia.com',
	'usersignup-welcome-email-content' => 'Vil du ha mer informasjon? Finn råd, svar, og Wikia-fellesskapet hos <a style="color:#2C85D5;" href="http://community.wikia.com">fellesskapssentralen</a>. Lykke til med redigeringen!',
	'usersignup-welcome-email-signature' => 'Wikia-teamet',
	'usersignup-welcome-email-body' => 'Hei $USERNAME,

Det er med glede vi ønsker deg velkommen til Wikia og {{SITENAME}}! Her er noen ting du kan gjøre for å komme i gang.

Redigere profilen din.

Legg til et profilbilde og noen kjappe fakta om deg selv på {{SITENAME}}-profilen din.

Gå til $EDITPROFILEURL

Lære det grunnleggende.

Få en kort opplæring innen det mest grunnleggende du finner hos Wikia: hvordan redigere en side, brukerprofilen din, endring av innstillingene dine, og mer til.

Sjekk det ut ($LEARNBASICURL)

Utforske flere wikier.

Det er tusenvis av wikier hos Wikia, finn flere wikier som interesserer deg ved å besøke en av hubbene våre: Videospill (http://www.wikia.com/Video_Games), underholdning (http://www.wikia.com/Entertainment), eller livsstil (http://www.wikia.com/Lifestyle).

Gå til $EXPLOREWIKISURL

Vil du ha mer informasjon? Finn råd, svar, og Wikia-fellesskapet hos fellesskapssentralen (http://www.community.wikia.com). Lykke til med redigeringen!

Wikia-teamet


___________________________________________

For å sjekke ut de siste hendelsene på Wikia, besøk http://community.wikia.com
Vil du kontrollere hva slags e-post du får? Gå til: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Registrer deg hos Wikia idag',
	'usersignup-heading-byemail' => 'Opprett en konto for noen andre',
	'usersignup-marketing-wikia' => 'Samarbeid med millioner av mennesker fra hele verden som samles for å dele det de liker best.',
	'usersignup-marketing-login' => 'Allerede en bruker? [[Special:UserLogin|Logg inn]]',
	'usersignup-marketing-benefits' => 'Bli en del av noe stort',
	'usersignup-marketing-community-heading' => 'Samarbeid',
	'usersignup-marketing-community' => 'Oppdag og utforsk emner innen alt fra videospill til film og TV. Møt mennesker med samme interesse og lidenskap.',
	'usersignup-marketing-global-heading' => 'Opprett',
	'usersignup-marketing-global' => 'Opprett en wiki. Begynn i det små, voks større med andres hjelp.',
	'usersignup-marketing-creativity-heading' => 'Vær original',
	'usersignup-marketing-creativity' => 'Bruk Wikia til å uttrykke kreativiteten din med avstemninger og topp 10-lister, bilde- og videogallerier, apper og mer.',
	'usersignup-createaccount-byemail' => 'Opprett en konto for noen andre',
	'usersignup-error-captcha' => 'Ordet du oppga samsvarer ikke med ordet i boksen, prøv igjen!', # Fuzzy
	'usersignup-account-creation-heading' => 'Vellykket!',
	'usersignup-account-creation-subheading' => 'Vi har sendt en e-post til $1',
	'usersignup-account-creation-email-sent' => 'Du har startet kontoopprettelsesprosessen for $2. Vi har sendt vedkommende en e-post til $1 med et midlertidig passord og en bekreftelseslenke.

$2 vil måtte trykke på lenken i e-posten vi sendte for å bekrefte kontoen og endre det midlertidige passordet for å fullføre opprettelsen av kontoen.

[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Opprett flere kontoer] på {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'En konto har blitt opprettet for deg hos Wikia!',
	'usersignup-account-creation-email-greeting' => 'Hallo,',
	'usersignup-account-creation-email-content' => '!En konto har blitt opprettet for deg på {{SITENAME}}. For å benytte deg av kontoen din og endre det midlertidige passordet ditt, trykk på lenken under og logg inn med brukernavnet «$USERNAME» og passordet «$NEWPASSWORD».

Vennligst logg inn på <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Hvis du ikke ville at denne kontoen skulle bli opprettet kan du simpelthen ignorere denne e-posten eller kontakte fellesskapssupporten vår med spørsmål.',
	'usersignup-account-creation-email-signature' => 'Wikia-teamet',
	'usersignup-account-creation-email-body' => 'Hallo,

En konto har blitt opprettet for deg på {{SITENAME}}. For å benytte deg av kontoen din og endre det midlertidige passordet ditt, trykk på lenken under og logg inn med brukernavnet «$2» og passordet «$3».

Vennligst logg inn på {{fullurl:{{ns:special}}:UserLogin}}

Hvis du ikke ville at denne kontoen skulle bli opprettet kan du simpelthen ignorere denne e-posten eller kontakte fellesskapssupporten vår med spørsmål.

Wikia-teamet


___________________________________________

For å sjekke ut de siste hendelsene på Wikia, besøk http://community.wikia.com
Vil du kontrollere hva slags e-post du får? Gå til: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Kunne ikke kommunisere med Facebook. Vennligst forsøk igjen senere.',
);

/** Nepali (नेपाली)
 * @author Nirjal stha
 */
$messages['ne'] = array(
	'usersignup-page-captcha-label' => 'चुनौति',
	'usersignup-error-captcha' => 'चुनौति उत्तर गलत भयो, पुन प्रयास गर्नुहोला !',
);

/** Dutch (Nederlands)
 * @author AvatarTeam
 * @author HanV
 * @author Robin0van0der0vliet
 * @author SPQRobin
 * @author Siebrand
 * @author Southparkfan
 * @author Trijnstel
 */
$messages['nl'] = array(
	'usersignup-page-title' => 'Word lid van Wikia',
	'usersignup-page-title-wikiamobile' => 'Registreren',
	'usersignup-page-captcha-label' => 'Wazig woord', # Fuzzy
	'usersignup-error-username-length' => 'Uw gebruikersnaam mag niet meer dan {{PLURAL:$1|één teken|$1 tekens}} lang zijn.',
	'usersignup-error-invalid-user' => 'Ongeldige gebruiker. Meld u eerst aan.',
	'usersignup-error-invalid-email' => 'Geef een geldig e-mailadres op.',
	'usersignup-error-symbols-in-username' => 'Uw gebruikersnaam mag alleen maar letters en cijfers bevatten.',
	'usersignup-error-empty-email' => 'Geef een e-mailadres op.',
	'usersignup-error-empty-username' => 'Geef een gebruikersnaam op.',
	'usersignup-error-already-confirmed' => 'U hebt dit e-mailadres al bevestigd.',
	'usersignup-error-throttled-email' => 'U hebt vandaag te vaak een bevestiging aangevraagd. Wacht even voor u het opnieuw doet.',
	'usersignup-error-too-many-changes' => 'U mag uw e-mailadres vandaag niet meer wijzigen. Probeer het later opnieuw.',
	'usersignup-error-password-length' => 'Uw wachtwoord is te lang. Kies een wachtwoord dat uit minder dan 50 tekens bestaat.',
	'usersignup-error-confirmed-user' => 'Het lijkt erop dat u al een bevestigd e-mailadres hebt voor $1. Controleer uw [$2 gebruikersprofiel].', # Fuzzy
	'usersignup-facebook-heading' => 'Registratie afronden',
	'usersignup-facebook-create-account' => 'Registreren',
	'usersignup-facebook-email-tooltip' => 'Als u een ander e-mailadres wilt gebruiken, kunt u dat later in uw voorkeuren wijzigen.',
	'usersignup-facebook-have-an-account-heading' => 'Hebt u al een account?',
	'usersignup-facebook-have-an-account' => 'Uw huidige Wikigebruiker met Facebook koppelen.',
	'usersignup-facebook-proxy-email' => 'Anonieme e-mailadres van Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Nieuwe bevestiging laten e-mailen',
	'usersignup-user-pref-confirmemail_send' => 'Mijn bevestiging opnieuw verzenden',
	'usersignup-user-pref-emailauthenticated' => 'Bedankt. Uw e-mailadres is bevestigd op $2 om $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Controleer uw e-mail en klik op de koppeling voor bevestiging om uw e-mailadres te wijzigen naar $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Uw e-mailadres is nog niet bevestigd. E-mailfuncties werken niet totdat u uw e-mailadres hebt bevestigd.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'U bent bijna klaar. Er is een bevesigingse-mail verzonden naar $1. Controleer uw e-mail en klik op op de koppeling voor bevestiging om uw e-mailadres te bevestigen.',
	'usersignup-user-pref-noemailprefs' => 'Het lijkt erop dat we geen e-mailadres van u hebben. Voer hierboven een e-mailadres in.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Uw e-mailadres is nog niet bevestigd. Er is een e-mail naar u verzonden. Klik op de koppeling in die e-mail om uw e-mailadres te bevestigen.',
	'usersignup-user-pref-confirmemail_noemail' => 'U hebt nog geen e-mailadres opgegeven. Ga naar [[Special:Preferences|uw voorkeuren]] om een e-mailadres in te stellen.',
	'usersignup-confirm-page-title' => 'Uw e-mailadres bevestigen',
	'usersignup-confirm-page-title-wikiamobile' => 'Controleer uw e-mail',
	'usersignup-confirm-email-resend-email' => 'Stuur me per e-mail nog een bevestiging',
	'usersignup-confirm-email-change-email-content' => 'Ik wil een ander e-mailadres gebruiken.',
	'usersignup-confirm-email-change-email' => 'Mijn e-mailadres wijzigen',
	'usersignup-confirm-email-new-email-label' => 'Nieuw e-mailadres',
	'usersignup-confirm-email-update' => 'Bijwerken',
	'usersignup-confirm-email-tooltip' => 'Hebt u een e-mailadres opgegeven dat u niet kunt bevestigen of wilt u een ander e-mailadres gebruiken? Gebruik dan de koppeling hieronder om uw e-mailadres te wijzigen, u ontvangt een nieuwe bevestiging per e-mail.',
	'usersignup-resend-email-heading-success' => 'Nieuwe e-mail verzonden',
	'usersignup-resend-email-heading-failure' => 'De e-mail is niet opnieuw verzonden',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gefeliciteerd!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Uw e-mailadres is al bevestigd',
	'usersignup-confirmation-heading' => 'U bent bijna klaar',
	'usersignup-confirmation-heading-wikiamobile' => 'Controleer uw e-mail',
	'usersignup-confirmation-heading-email-resent' => 'Nieuwe e-mail verzonden',
	'usersignup-confirmation-subheading' => 'Controleer uw e-mail',
	'usersignup-confirmation-email-sent' => "Er is een e-mail verzonden naar '''$1'''.

Klik op de koppeling in die e-mail om het aanmaken van uw gebruiker af te ronden.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Er is een e-mail verzonden naar '''$1'''.

Klik op de koppeling in die e-mail om het aanmaken van uw gebruiker af te ronden. Bedankt!",
	'usersignup-reconfirmation-email-sent' => 'Uw e-mailadres is gewijzigd naar $1. We hebben u een nieuwe bevestigings-e-mail verzonden. Bevestig nu het nieuwe e-mailadres.',
	'usersignup-welcome-email-subject' => 'Welkom bij Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hallo $USERNAME,',
	'usersignup-welcome-email-heading' => 'We zijn blij dat u naar Wikia en {{SITENAME}} bent gekomen. Hier zijn enkele dingen die u kunt doen om aan de slag te gaan.',
	'usersignup-welcome-email-edit-profile-heading' => 'Uw profiel bewerken.',
	'usersignup-welcome-email-edit-profile-content' => 'Voeg een profielfoto en een paar snelle feiten over uzelf toe aan uw profiel van {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Naar profiel',
	'usersignup-welcome-email-learn-basic-heading' => 'Leer de basis.',
	'usersignup-welcome-email-learn-basic-content' => 'Volg een korte cursus over de basisprincipes van Wikia: hoe u een pagina kunt bewerken, uw gebruikersprofiel bewerken, uw voorkeuren wijzigen en meer.',
	'usersignup-welcome-email-learn-basic-button' => 'Ga kijken!',
	'usersignup-welcome-email-explore-wiki-heading' => "Meer wiki's ontdekken.",
	'usersignup-welcome-email-explore-wiki-content' => 'Er zijn duizenden wiki\'s bij Wikia. U kunt wiki\'s vinden die bij uw interesses passen door naar een van onze hubs te gaan: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Videogames</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Amusement</a> of <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Lifestyle</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Ga naar wikia.com',
	'usersignup-welcome-email-content' => 'Wilt u meer informatie? U kunt antwoorden en advies krijgen van de Wikiagemeenschap op <a style="color:#2C85D5;" href="http://community.wikia.com">Community Central</a>. Veel plezier!',
	'usersignup-welcome-email-signature' => 'Het Wikia-team',
	'usersignup-welcome-email-body' => 'Hallo $USERNAME,

Welkom bij Wikia en {{SITENAME}}! Hier zijn enkele dingen die u kunt doen om aan de slag te gaan.

Bewerk uw profiel.

Voeg een profielfoto en een paar snelle feiten over uzelf toe aan uw profiel van {{SITENAME}}.

Ga naar $EDITPROFILEURL

Leer de basisvaardigheden.

Volg een korte cursus over de basisprincipes van Wikia: hoe u een pagina kunt bewerken, uw gebruikersprofiel bewerken, uw voorkeuren wijzigen en meer.

Ga hiervoor naar ($LEARNBASICURL)

Vind interessante wiki\'s.

U kunt wiki\'s vinden die bij uw interesses passen door naar een van onze hubs te gaan: Videogames (http://www.wikia.com/Video_Games ), Amusement (http://www.wikia.com/Entertainment ) of Lifestyle (http://www.wikia.com/Lifestyle ).

Ga naar $EXPLOREWIKISURL

Wilt u meer informatie? U kunt antwoorden en advies krijgen van de Wikiagemeenschap op Community Central (http://www.community.wikia.com ). Veel plezier!

Het Wikia-team

___________________________________________

Ga naar http://community.wikia.com voor het laatste nieuws over Wikia.
Wilt u bepalen welke e-mails u ontvangt? Ga dan naar {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Word vandaag lid van Wikia',
	'usersignup-heading-byemail' => 'Maak een gebruiker aan voor iemand anders',
	'usersignup-marketing-wikia' => 'Begin met samenwerken met miljoenen mensen van over de hele wereld die samenkomen om te delen wat ze weten en waar ze passie voor hebben.',
	'usersignup-marketing-login' => 'Hebt u al een account?[[Special:UserLogin|Meld u aan]]',
	'usersignup-marketing-benefits' => 'Doe mee aan iets groots',
	'usersignup-marketing-community-heading' => 'Samenwerken',
	'usersignup-marketing-community' => 'Ontdek en verken onderwerpen van videogames tot films en televisie. Ontmoet mensen met gelijke interesses en passies.',
	'usersignup-marketing-global-heading' => 'Aanmaken',
	'usersignup-marketing-global' => 'Begin een wiki. Begin klein en groei groot, samen met anderen.',
	'usersignup-marketing-creativity-heading' => 'Wees origineel',
	'usersignup-marketing-creativity' => "Gebruik Wikia om uw creativiteit uit te drukken met peilingen, top-10 lijsten, galerijen met foto's en video, apps en meer.",
	'usersignup-createaccount-byemail' => 'Maak een gebruiker aan voor iemand anders',
	'usersignup-error-captcha' => 'Het woord dat u hebt opgegeven komt niet overeen met het woord in het venster. Probeer het opnieuw.', # Fuzzy
	'usersignup-account-creation-heading' => 'Afgerond',
	'usersignup-account-creation-subheading' => 'Er is een e-mail verzonden naar $1.',
	'usersignup-account-creation-email-sent' => 'U bent begonnen met het aanmaken van de gebruiker $2. We hebben een e-mail gezonden naar $1 met een tijdelijk wachtwoord en een bevestigingscode.


$2 moet op de koppeling in de e-mail die we gezonden hebben klikken om de gebruiker te bevestigen en het tijdelijke wachtwoord wijzigen. Hierna is het aanmaken van de gebruiker afgerond.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Meer gebruikers aanmaken] op {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Er is voor u een gebruiker aangemaakt op Wikia!',
	'usersignup-account-creation-email-greeting' => 'Hallo,',
	'usersignup-account-creation-email-content' => 'Er is een gebruiker voor u aangemaakt op {{SITENAME}}. Om toegang te krijgen tot uw gebruiker moet u via de onderstaande koppeling uw tijdelijke wachtwoord wijzigen en aanmelden met de gebruikersnaam "$USERNAME" en wachtwoord "$NEWPASSWORD".

Meld u aan bij <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>.

Als u niet wilt dat deze gebruiker wordt aangemaakt, negeer deze e-mail dan, of neem contact op met ons team voor Community Support als u vragen hebt.',
	'usersignup-account-creation-email-signature' => 'Het Wikia-team',
	'usersignup-account-creation-email-body' => 'Hallo,

Er is een gebruiker voor u aangemaakt op {{SITENAME}}. Om toegang te krijgen tot uw gebruiker moet u via de onderstaande koppeling uw tijdelijke wachtwoord wijzigen en aanmelden met de gebruikersnaam "$2" en wachtwoord "$3".

Meld u aan bij {{fullurl:{{ns:special}}:UserLogin}}.

Als u niet wilt dat deze gebruiker wordt aangemaakt, negeer deze e-mail dan, of neem contact op met ons team voor Community Support als u vragen hebt.

Het Wikia-team

___________________________________________

Ga naar http://community.wikia.com voor het laatste nieuws over Wikia.
Wilt u bepalen welke e-mails u ontvangt? Ga dan naar {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Er is een probleem opgetreden in de communicatie met Facebook. Probeer het later opnieuw.',
	'usersignup-facebook-signup-header' => 'Nieuwe gebruiker registreren?',
	'usersignup-facebook-login-header' => 'Hebt u al een gebruiker?',
);

/** Norwegian Nynorsk (norsk nynorsk)
 * @author Gaute
 */
$messages['nn'] = array(
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'usersignup-confirm-email-update' => 'Mesa a jorn',
	'usersignup-confirm-page-heading-confirmed-user' => 'Felicitacions!',
	'usersignup-confirmation-heading' => 'I sèm gaireben',
	'usersignup-welcome-email-greeting' => 'Bonjorn $USERNAME,',
	'usersignup-welcome-email-explore-wiki-content' => 'I a de milierats de wikis sus Wikia; trobatz mai de wikis que vos interèssa en vos dirigissent cap a un de nòstres centres: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Jòcs vidèo</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Divertiment</a>, o <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Mòde de vida</a>.',
	'usersignup-welcome-email-signature' => '— L’equipa Wikia',
	'usersignup-welcome-email-body' => "Bonjorn \$USERNAME,

Sèm uroses de vos aculhir sus Wikia e {{SITENAME}}! Aquí qualques unas de las causas que podètz far per començar.

Modificar vòstre perfil.

Apondre una fòto al perfil e qualques faches somaris sus vos-meteis sus vòstre perfil dins {{SITENAME}}.

Anar sus \$EDITPROFILEURL

Aprene las basas.

Legir un tutorial rapid sus las basas de Wikia: cossí modificar una pagina, vòstre perfil d'utilizaire, cambiar vòstras preferéncias, etc.

Agachatz (\$LEARNBASICURL)

Explorar d'autres wikis.

I a de milierats de wikis sus Wikia; trobatz d'autres wikis que vos interèssan en anant sus un de nòstres gropaments : Jòcs vidèo (http://www.wikia.com/Video_Games), Lésers (http://www.wikia.com/Entertainment), o Estil de vida (http://www.wikia.com/Lifestyle).

Anar a \$EXPLOREWIKISURL

Volètz mai d'informacion ? Trobatz de conselhs, de responsas, e la comunautat Wikia al Centre de la Comunautat (http://www.community.wikia.com). Bonas modificacions !

L'equipa Wikia


___________________________________________

Per veire las darrièras nòvas sus Wikia, anatz sus http://community.wikia.com
Volètz verificar quins corrièrs electronics recebètz ? Anatz sus {{fullurl:{{ns:special}}:Preferences}}",
	'usersignup-marketing-community-heading' => 'Collaborar',
	'usersignup-marketing-community' => "Descobrissètz e exploratz de subjèctes que van dels jòcs vidèo als filmes e a la television. Rencontratz de monde amb de passions e d'interèsses semblables.",
	'usersignup-marketing-global-heading' => 'Crear',
	'usersignup-marketing-global' => "Aviatz un wiki. Començatz pichon, puèi grandissètz, amb l'ajuda dels autres.",
	'usersignup-marketing-creativity-heading' => 'Èsser original',
	'usersignup-account-creation-heading' => 'Capitat !',
	'usersignup-account-creation-email-greeting' => 'Bonjorn,',
	'usersignup-account-creation-email-signature' => '— L’equipa Wikia',
);

/** Polish (polski)
 * @author Matik7
 * @author Pio387
 * @author Sovq
 * @author Vengir
 */
$messages['pl'] = array(
	'usersignup-page-title' => 'Dołącz do Wikii',
	'usersignup-page-title-wikiamobile' => 'Załóż nowe konto',
	'usersignup-page-captcha-label' => 'Wyzwanie',
	'usersignup-error-username-length' => 'Twoja nazwa użytkownika nie może mieć więcej niż {{PLURAL:$1|jeden znak|$1 znaki|$1 znaków}}.',
	'usersignup-error-invalid-user' => 'Niewłaściwy użytkownik. Zaloguj się.',
	'usersignup-error-invalid-email' => 'Podaj prawidłowy adres e-mail.',
	'usersignup-error-symbols-in-username' => 'Twoja nazwa użytkownika może zawierać jedynie litery i cyfry.',
	'usersignup-error-empty-email' => 'Podaj adres e-mail.',
	'usersignup-error-empty-username' => 'Podaj nazwę użytkownika.',
	'usersignup-error-already-confirmed' => 'Już potwierdzono ten adres e-mail.',
	'usersignup-error-throttled-email' => 'Zażądano dzisiaj zbyt wielu wiadomości potwierdzających e-mail. Spróbuj ponownie później.',
	'usersignup-error-too-many-changes' => 'Osiągnięto limit żądań zmiany e-maila. Spróbuj ponownie później.',
	'usersignup-error-password-length' => 'Twoje hasło jest zbyt długie. Wybierz hasło, które ma mniej niż 51 znaków.',
	'usersignup-error-confirmed-user' => 'Wygląda na to, że już potwierdzono adres e-mail $1. Sprawdź swój [$2 profil użytkownika].', # Fuzzy
	'usersignup-facebook-heading' => 'Zakończenie rejestracji',
	'usersignup-facebook-create-account' => 'Załóż nowe konto',
	'usersignup-facebook-email-tooltip' => 'Jeśli chcesz zmienić swój adres e-mail, możesz to zrobić później w swoich preferencjach.',
	'usersignup-facebook-have-an-account-heading' => 'Masz już konto?',
	'usersignup-facebook-have-an-account' => 'Rozważ połączenie istniejącego konta z Facebookiem, zamiast tworzyć nowe.',
	'usersignup-facebook-proxy-email' => 'Anonimowy e-mail z Facebooka',
	'usersignup-user-pref-emailconfirmlink' => 'Zażądaj nowego e-maila potwierdzającego adres',
	'usersignup-user-pref-confirmemail_send' => 'Ponownie wyślij e-mail potwierdzający adres',
	'usersignup-user-pref-emailauthenticated' => 'Dzięki! Twój e-mail został potwierdzony w dniu $2 o $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Sprawdź swoją pocztę i kliknij na link potwierdzający, aby zakończyć zmianę adresu e-mail na $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Twój adres e-mail nie jest potwierdzony. Funkcje związane z e-mailem nie będą działać do czasu potwierdzenia.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Wysłano nowy e-mail potwierdzający na adres $1. Sprawdź swoją skrzynkę e-mailową i kliknij na link, aby zakończyć potwierdzanie adresu e-mail.',
	'usersignup-user-pref-noemailprefs' => 'Wygląda na to, że nie podano adresu e-mail. Wprowadź go w polu powyżej.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Twój adres e-mail nie został potwierdzony. Wysłaliśmy Ci wiadomość, kliknij na link w niej, aby go potwierdzić.',
	'usersignup-user-pref-confirmemail_noemail' => 'Wygląda na to, że nie podano adresu e-mail. Przejdź do [[Special:Preferences#mw-prefsection-emailv2|preferencji]], aby go wprowadzić.', # Fuzzy
	'usersignup-confirm-page-title' => 'Potwierdź swój e-mail',
	'usersignup-confirm-page-title-wikiamobile' => 'Sprawdź swoją pocztę',
	'usersignup-confirm-email-resend-email' => 'Wyślij mi kolejny e-mail z potwierdzeniem',
	'usersignup-confirm-email-change-email-content' => 'Chcę używać innego adresu e-mail.',
	'usersignup-confirm-email-change-email' => 'Zmień mój adres e-mail',
	'usersignup-confirm-email-new-email-label' => 'Nowy adres e-mail',
	'usersignup-confirm-email-update' => 'Zaktualizuj',
	'usersignup-confirm-email-tooltip' => 'Wprowadziłeś adres e-mail, którego nie jesteś w stanie potwierdzić lub po prostu chcesz zmienić adres na nowy? Nie ma problemu, użyj poniższego linku, aby zmienić swój adres i otrzymać nowy e-mail z potwierdzeniem.',
	'usersignup-resend-email-heading-success' => 'Wysłano nową wiadomość',
	'usersignup-resend-email-heading-failure' => 'Nie wysłano nowej wiadomości',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gratulacje!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Twój adres e-mail już został potwierdzony',
	'usersignup-confirmation-heading' => 'Prawie ukończono',
	'usersignup-confirmation-heading-wikiamobile' => 'Sprawdź swoją pocztę',
	'usersignup-confirmation-heading-email-resent' => 'Wysłano nową wiadomość',
	'usersignup-confirmation-subheading' => 'Sprawdź swoją pocztę',
	'usersignup-confirmation-email-sent' => "Wysłaliśmy e-mail na '''$1'''.

Kliknij na link potwierdzający we wiadomości, aby zakończyć tworzenie konta.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Wysłaliśmy e-mail na '''$1'''.

Kliknij na link potwierdzający we wiadomości, aby zakończyć tworzenie konta. Dzięki!",
	'usersignup-reconfirmation-email-sent' => 'Twój adres e-mail został zmieniony na $1. Wysłaliśmy nową wiadomość z potwierdzeniem.',
	'usersignup-welcome-email-subject' => 'Witaj na Wikii, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hej $USERNAME,',
	'usersignup-welcome-email-heading' => 'Jesteśmy szczęśliwi mogąc przywitać Cię na Wikii i na {{SITENAME}}! Oto kilka spraw na dobry początek.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edytuj swój profil.',
	'usersignup-welcome-email-edit-profile-content' => 'Dodaj obraz i kilka informacji o sobie na swoim profilu na {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Przejdź do profilu',
	'usersignup-welcome-email-learn-basic-heading' => 'Zapoznaj się z podstawami.',
	'usersignup-welcome-email-learn-basic-content' => 'Zapoznaj się z podstawami edytowania na Wikii: jak edytować strony, własny profil, zmienić swoje ustawienia i więcej.',
	'usersignup-welcome-email-learn-basic-button' => 'Sprawdź go',
	'usersignup-welcome-email-explore-wiki-heading' => 'Odwiedź inne wiki.',
	'usersignup-welcome-email-explore-wiki-content' => 'Na Wikii istnieje tysiące wiki, dowiedz się o nich więcej, odwiedzając jeden z portali: <a style="color:#2C85D5;" href="http://gryhub.wikia.com/">Gry</a>, <a style="color:#2C85D5;" href="http://rozrywkahub.wikia.com/">Rozrywka</a> lub <a style="color:#2C85D5;" href="http://pl.lifestylehub.wikia.com/">Lifestyle</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Odwiedź wikia.com',
	'usersignup-welcome-email-content' => 'Szukasz więcej informacji? Znajdziesz odpowiedzi, porady i społeczność Wikii w <a style="color:#2C85D5;" href="http://spolecznosc.wikia.com/">Centrum Społeczności</a>. Przyjemnego edytowania!',
	'usersignup-welcome-email-signature' => 'Zespół Wikii',
	'usersignup-welcome-email-body' => 'Hej $USERNAME,

Jesteśmy szczęśliwi mogąc przywitać Cię na Wikii i na {{SITENAME}}! Oto kilka spraw na dobry początek.

Edytuj swój profil.

Dodaj obraz i kilka informacji o sobie na swoim profilu na {{SITENAME}}.

Przejdź do $EDITPROFILEURL

Zapoznaj się z podstawami.

Zapoznaj się z podstawami edytowania na Wikii: jak edytować strony, własny profil, zmienić swoje ustawienia i więcej.

Sprawdź $LEARNBASICURL

Odwiedź inne wiki.

Na Wikii istnieje tysiące wiki, dowiedz się o nich więcej, odwiedzając jeden z portali: Gry (http://gryhub.wikia.com/), Rozrywka (http://rozrywkahub.wikia.com/) lub Lifestyle (http://pl.lifestyle.wikia.com/).

Odwiedź $EXPLOREWIKISURL

Szukasz więcej informacji? Znajdziesz odpowiedzi, porady i społeczność Wikii w Centrum Społeczności (http://spolecznosc.wikia.com/). Przyjemnego edytowania!

Zespół Wikii


___________________________________________

Aby dowiedzieć się co nowego na Wikii, odwiedź http://spolecznosc.wikia.com/
Chcesz zmienić ustawienia przysyłanych wiadomości? Przejdź tutaj: {{fullurl:{{#special:preferences}}}}',
	'usersignup-heading' => 'Dołącz do Wikii już dziś',
	'usersignup-heading-byemail' => 'Załóż konto dla kogoś innego',
	'usersignup-marketing-wikia' => 'Zacznij współpracę z milionami ludzi na całym świecie, którzy spotykają się aby dzielić się wiedzą o tym, co kochają.',
	'usersignup-marketing-login' => 'Już jesteś użytkownikiem? [[Special:UserLogin|Zaloguj się]]',
	'usersignup-marketing-benefits' => 'Stań się częścią czegoś wielkiego',
	'usersignup-marketing-community-heading' => 'Współpracuj',
	'usersignup-marketing-community' => 'Odkrywaj i zgłębiaj tematy od gier komputerowych do telewizji i filmu. Poznawaj ludzi o podobnych zainteresowaniach i pasjach.',
	'usersignup-marketing-global-heading' => 'Twórz',
	'usersignup-marketing-global' => 'Utwórz wiki. Zacznij od podstaw i zbuduj coś wielkiego, z pomocą innych.',
	'usersignup-marketing-creativity-heading' => 'Bądź oryginalny',
	'usersignup-marketing-creativity' => 'Użyj Wikii aby wyrazić swoją kreatywność poprzez ankiety, rankingi, galerie obrazów i filmów, aplikacje i więcej.',
	'usersignup-createaccount-byemail' => 'Załóż konto dla kogoś innego',
	'usersignup-error-captcha' => 'Odpowiedź jest nieprawidłowa, spróbuj ponownie!',
	'usersignup-account-creation-heading' => 'Sukces!',
	'usersignup-account-creation-subheading' => 'Wysłaliśmy e-mail na $1',
	'usersignup-account-creation-email-sent' => 'Rozpoczęto proces tworzenia konta dla użytkownika $2. Wysłaliśmy wiadomość na adres $1 z tymczasowym hasłem i linkiem potwierdzającym.

$2 będzie musiał(-a) kliknąć na ten link aby potwierdzić adres i zmienić tymczasowe hasło w celu ukończenia tworzenie konta. [{{fullurl:{{#special:UserSignup}}|byemail=1}} Utwórz więcej kont] na {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Ktoś utworzył dla Ciebie konto na Wikii!',
	'usersignup-account-creation-email-greeting' => 'Witaj,',
	'usersignup-account-creation-email-content' => 'Na {{SITENAME}} zostało dla Ciebie utworzone konto. Aby uzyskać do niego dostęp i zmienić tymczasowe hasło, użyj poniższego linku i zaloguj się korzystając z nazwy użytkownika „$USERNAME” i hasła „$NEWPASSWORD”.

Zaloguj się korzystając z: <a style="color:#2C85D5;" href="{{fullurl:{{#special:UserLogin}}}}">{{fullurl:{{#special:UserLogin}}}}</a>

Jeśli nie chcesz, aby to konto zostało utworzone, zignoruj tę wiadomość albo skontaktuj się z nami jeśli masz pytania.',
	'usersignup-account-creation-email-signature' => 'Zespół Wikii',
	'usersignup-account-creation-email-body' => 'Witaj,

Na {{SITENAME}} zostało dla Ciebie utworzone konto. Aby uzyskać do niego dostęp i zmienić tymczasowe hasło, użyj poniższego linku i zaloguj się korzystając z nazwy użytkownika „$2” i hasła „$3”.

Zaloguj się korzystając z: {{fullurl:{{#special:UserLogin}}}}

Jeśli nie chcesz, aby to konto zostało utworzone, zignoruj tę wiadomość albo skontaktuj się z nami jeśli masz pytania.

Zespół Wikii


___________________________________________

Aby dowiedzieć się co nowego na Wikii, odwiedź http://spolecznosc.wikia.com/
Chcesz zmienić ustawienia przysyłanych wiadomości? Przejdź tutaj: {{fullurl:{{#special:preferences}}}}',
	'usersignup-facebook-problem' => 'Wystąpił problem podczas łączenia z Facebookiem. Spróbuj później.',
	'usersignup-facebook-signup-header' => 'Tworzysz nowe konto?',
	'usersignup-facebook-login-header' => 'Masz już konto?',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'usersignup-page-title' => 'Intra an Wikia',
	'usersignup-page-captcha-label' => 'Paròla tërbola', # Fuzzy
	'usersignup-error-username-length' => 'Atension, sò stanòm a peul pa esse pi longh che {{PLURAL:$1|un caràter|$1 caràter}}.',
	'usersignup-error-invalid-user' => "Utent pa bon. Për piasì, ch'a intra prima ant ël sistema.",
	'usersignup-error-invalid-email' => "Për piasì anseriss n'adrëssa ëd pòsta eletrònica bon-a.",
	'usersignup-error-symbols-in-username' => 'Atension, sò stranòm a peul mach conten-e litre e gifre.',
	'usersignup-error-empty-email' => "Atension, për piasì ch'a buta soa adrëssa ëd pòsta eletrònica.",
	'usersignup-error-empty-username' => "Atension, për piasì ch'a compila ël camp ëd lë stranòm.",
	'usersignup-error-already-confirmed' => "A l'ha già confirmà st'adrëssa ëd pòsta eletrònica.",
	'usersignup-error-throttled-email' => "Atension, a l'ha ciamà ëd mandeje tròpi mëssagi ëd confirma ancheuj. Ch'a preuva torna da-sì un pòch.",
	'usersignup-error-too-many-changes' => "A l'é rivà al lìmit màssim ëd cambi ëd pòsta eletrònica ancheuj. Për piasì, ch'a preuva torna pi tard.",
	'usersignup-error-password-length' => "Contacc, toa ciav a l'é tròp longa. Për piasì sern na ciav ch'a sia 50 caràter o men.",
	'usersignup-error-confirmed-user' => "A smijërìa che chiel a l'abia già confirmà soa adrëssa ëd pòsta eletrònica për $1! Ch'a contròla sò [$2 profil utent].", # Fuzzy
	'usersignup-facebook-heading' => 'Finiss ëd Registrete',
	'usersignup-facebook-create-account' => 'Creé un cont',
	'usersignup-facebook-email-tooltip' => "S'a veul dovré n'adrëssa ëd pòsta eletrònica diferenta a peul modifichela pi tard ant ij sò Gust.",
	'usersignup-facebook-have-an-account-heading' => 'Ha-lo già un cont?',
	'usersignup-facebook-have-an-account' => "Ch'a lija pitòst sò stranòm ëd Wikia già esistent con Facebook.",
	'usersignup-facebook-proxy-email' => 'Mëssagi anònim ëd Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Ciamé na neuva pòsta eletrònica ëd conferma',
	'usersignup-user-pref-confirmemail_send' => 'Mandé torna mia pòsta eletrònica ëd conferma',
	'usersignup-user-pref-emailauthenticated' => "Mersì! Soa adrëssa ëd pòste eletrònica a l'é stàita confermà ël $2 a $3.",
	'usersignup-user-pref-emailnotauthenticated' => "Ch'a contròla soa pòsta eletrònica e ch'a sgnaca la liura ëd conferma për finì ëd cangé soa adrëssa a: $1",
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => "Oh, nò! Soa adrëssa ëd pòsta eletrònica a l'é pa confermà. Le fonsionalità ëd pòsta eletrònica a marcëran pa fin che a conferma nen soa adrëssa ëd pòsta eletrònica.",
	'usersignup-user-pref-reconfirmation-email-sent' => "Tòst al bon! I l'oma mandaje un neuv mëssagi ëd conferma a $1. Ch'a contròla soa pòsta eletrònica e ch'a sgnaca an sla liura për livré ëd confermé soa adrëssa ëd pòsta eletrònica.",
	'usersignup-user-pref-noemailprefs' => "A smijërìa ch'i l'oma pa n'adrëssa ëd pòsta eletrònica për chiel. Për piasì, ch'a buta n'adrëssa ëd pòsta eletrònica sì-dzora.",
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => "Oh, nò! Soa adrëssa ëd pòsta eletrònica a l'é pa confermà. I l'oma mandaje un mëssagi, ch'a sgnaca an sla liura ëd conferma ambelelà për confermé.",
	'usersignup-user-pref-confirmemail_noemail' => "A smijërìa ch'i l'oma pa n'adrëssa ëd pòsta eletrònica për chiel. Ch'a vada ant ij [[Special:Preferences|sò gust]] për butene un-a.",
	'usersignup-confirm-page-title' => "Ch'a conferma soa adrëssa ëd pòsta eletrònica",
	'usersignup-confirm-email-resend-email' => "Mandeme n'àutr mëssagi ëd conferma",
	'usersignup-confirm-email-change-email-content' => "I veuj dovré n'adrëssa ëd pòsta eletrònica diferenta.",
	'usersignup-confirm-email-change-email' => 'Cangé mia adrëssa ëd pòsta eletrònica',
	'usersignup-confirm-email-new-email-label' => 'Neuva pòsta eletrònica',
	'usersignup-confirm-email-update' => 'Agiorna',
	'usersignup-confirm-email-tooltip' => "Ha-lo butà n'adrëssa ëd pòsta eletrònica ch'a peule pa confermé, o a veul dovré n'adrëssa ëd pòsta eletrònica diferenta? Ch'as sagrin-a nen, ch'a deuvra la liura sì-sota për modifiché soa adrëssa ëd pòsta eletrònica e avèj un neuv mëssagi ëd conferma.",
	'usersignup-resend-email-heading-success' => 'Neuv mëssagi mandà',
	'usersignup-resend-email-heading-failure' => 'Mëssagi nen mandà torna',
	'usersignup-confirm-page-heading-confirmed-user' => 'Congratulassion!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'It ses già confermà',
	'usersignup-confirmation-heading' => 'Almanch sì',
	'usersignup-confirmation-heading-email-resent' => 'Mëssagi neuv mandà',
	'usersignup-confirmation-subheading' => "Ch'a contròla soa pòsta eletrònica",
	'usersignup-confirmation-email-sent' => "I l'oma mandà un mëssagi a '''$1'''.

Ch'a sgnaca an sla liura ëd conferma an soa pòsta eletrònica për livré la creassion ëd sò cont.",
	'usersignup-reconfirmation-email-sent' => "Soa adrëssa eletrònica a l'é stàita modificà a $1. I l'oma mandaje un neuv mëssagi ëd conferma. Për piasì, ch'a conferma la neuva adrëssa ëd pòsta eletrònica.",
	'usersignup-welcome-email-subject' => 'Bin ëvnù dzor Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Cerea $USERNAME',
	'usersignup-welcome-email-heading' => 'I soma content ëd deje ël bin-ëvnù su Wikia e {{SITENAME}}! Valà dle ròbe che a peul fé për ancaminé.',
	'usersignup-welcome-email-edit-profile-heading' => 'Modìfica tò profil.',
	'usersignup-welcome-email-edit-profile-content' => "Ch'a gionta na fòto për sò profil e chèiche cite anformassion su chiel dzora sò profil su {{SITENAME}}.",
	'usersignup-welcome-email-edit-profile-button' => 'Và al profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Ampara le bas.',
	'usersignup-welcome-email-learn-basic-content' => "Oten-e un cors ësvicc an sle base ëd Wikia: com modifiché na pàgina, sò profil utent, nodifiché ij sò gust e d'àutr.",
	'usersignup-welcome-email-learn-basic-button' => 'Contròla',
	'usersignup-welcome-email-explore-wiki-heading' => "Ch'a esplora pi 'd wiki.",
	'usersignup-welcome-email-explore-wiki-content' => 'A-i son milen-e ëd wiki dzor Wikia, ch\'a treuva d\'àutre wiki ch\'a j\'anteresso an andasendie da un dij nòstri sénter: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Videogieugh</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Divertiment</a>, o <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Stil ëd vita</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Và a wikia.com',
	'usersignup-welcome-email-content' => 'Veul-lo pi d\'anformassion? Ch\'a treuva dij consèj, dle rispòste, e la comunità ëd Wikia al <a style="color:#2C85D5;" href="http://community.wikia.com">sènter dla comunità</a>. Bon travaj!',
	'usersignup-welcome-email-signature' => "L'echip ëd Wikia",
	'usersignup-welcome-email-body' => "Cerea \$USERNAME,

I soma content ëd deje ël bin-ëvnù su Wikia e {{SITENAME}}! Belessì a-i son dle còse ch'a peul fé për ancaminé.

Modifiché sò profil.

Gionté na fòto al profil a chèiche cite anformassion a propòsit ëd chiel dzora sò profil ëd {{SITENAME}}.

Andé a \$EDITPROFILEURL

Amprende le base.

Lese un cors lest dzora le base ëd Wikia: com modifiché na pàgina, sò profil utent, cangé ij sò gust e d'àutr.

Dé n'ociada a (\$LEARNBASICURL)

Esploré d'àutre wiki.

A-i son milen-e ëd wiki dzor Wikia, ch'a treuva d'àutre wiki ch'a j'anteresso andasend a un dij nòstri sénter: Videogieugh (http://www.wikia.com/Video_Games), Divertiment (http://www.wikia.com/Entertainment), o Stil ëd Vita(http://www.wikia.com/Lifestyle).

Andé a \$EXPLOREWIKISURL

Veul-lo pi d'anformassion? Ch'a treuva dij consèj, dle rispòste, e la comunità Wikia al sènter dla Comunità (http://www.community.wikia.com). Bon travaj!

L'Echip Wikia


___________________________________________

Për controlé j'ùltime neuve dzor Wikia, vìsita http://community.wikia.com
It veus-to controlé che email it arseive? Và a: {{fullurl:{{ns:special}}:Preferences}}",
	'usersignup-heading' => "Ch'as gionza a Wikia Ancheuj",
	'usersignup-heading-byemail' => "Creé un cont për quaidun d'àutr",
	'usersignup-marketing-wikia' => "Ch'a ancamin-a a colaboré con dij milion ëd përson-e da tut ël mond ch'as radun-o për partagé lòn ch'a san e a-j pias.",
	'usersignup-marketing-login' => "Già utent? [[Special:UserLogin|Ch'a intra ant ël sistema]]",
	'usersignup-marketing-benefits' => 'Fé part ëd quaicòs dë stragròss',
	'usersignup-marketing-community-heading' => 'Colàbora',
	'usersignup-marketing-community' => "Ch'a dëscheurva e ch'a esplora dij soget ch'a van dai videogieugh ai film e a la television. Ch'a rancontra dle përson-e con dj'anteresse e passion ch'a smijo ai sò.",
	'usersignup-marketing-global-heading' => 'Crea',
	'usersignup-marketing-global' => "Ch'a ancamin-a na wiki. Ch'a ancamin-a dossman, peui ch'a la fasa chërse, con l'agiut ëd j'àutri.",
	'usersignup-marketing-creativity-heading' => 'Esse original',
	'usersignup-marketing-creativity' => "Ch'a deuvra Wikia për esprime soa creatività con dij sondagi e dle liste dij prim 10, dle galarìe ëd fòto e filmà, dj'aplicassion e d'àutr ancor.",
	'usersignup-createaccount-byemail' => "Creé un cont për quaidun d'àutr",
	'usersignup-error-captcha' => "la paròla ch'it l'has anserì a corispond pa la paròla ant la casela, preuva torna!", # Fuzzy
	'usersignup-account-creation-heading' => 'Da bin!',
	'usersignup-account-creation-subheading' => "I l'oma mandà un mëssagi a $1",
	'usersignup-account-creation-email-sent' => "A l'ha ancaminà ël process ëd creassion dël cont për $2. I l'oma mandà un mëssagi a $1 con na ciav temporania e na liura ëd conferma.


$2 a dovrà sgnaché dzora la liura ant ël mëssagi ch'i l'oma mandaje për confermé sò cont e cangé soa ciav temporania për livré ëd creé sò cont.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Creé pi 'd cont] dzor {{SITENAME}}",
	'usersignup-account-creation-email-subject' => "Un cont a l'é stàit creà për ti dzor Wikia!",
	'usersignup-account-creation-email-greeting' => 'Cerea,',
	'usersignup-account-creation-email-content' => 'Un cont a l\'é stàit creà për chiel dzor {{SITENAME}}. Për acede a sò cont e cangé soa ciav temporania ch\'a sgnaca an sla liura sì-sota e ch\'a intra ant ël sistema con lë stranòm utent «$USERNAME» e la ciav «$NEWPASSWORD».

Për piasì, ch\'a intra ant ël sistema a <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

S\'a veul pa che ës cont a sia creà a peule bele mach ignoré ës mëssagi o contaté nòstra echip d\'agiut për qualsëssìa chestion.',
	'usersignup-account-creation-email-signature' => "L'Echip ëd Wikia",
	'usersignup-account-creation-email-body' => "Cerea,

Un cont a l'é stàit creà për chiel dzor {{SITENAME}}. Për acede a sò cont e cangé soa ciav temporania ch'a sgnaca an sla liura sì-sota e ch'a intra ant ël sistema con lë stranòm «$2» e la ciav «$3».

Për piasì, ch'a intra ant ël sistema a {{fullurl:{{ns:special}}:UserLogin}}

S'a veul pa che 's cont a sia creà a peul bele mach ignoré ës mëssagi o contaté nòstra echip d'agiut për qualsëssìa chestion.

L'Echip Wikia


___________________________________________

Për controlé le neuve dzora Wikia, ch'a vìsita http://community.wikia.com
Veul-lo controlé che mëssagi a arsèiv? Andé su: {{fullurl:{{ns:special}}:Preferences}}",
	'usersignup-facebook-problem' => "A-i é staje un problema ëd comunicassion con Facebook. Për piasì, ch'a preuva torna pi tard.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'usersignup-page-title' => 'ويکيا سره يوځای شی',
	'usersignup-page-captcha-label' => 'ننگول',
	'usersignup-facebook-create-account' => 'گڼون جوړول',
	'usersignup-confirm-email-change-email' => 'زما برېښليک پته بدله کړه',
	'usersignup-confirm-email-new-email-label' => 'نوی برېښليک',
	'usersignup-confirm-email-update' => 'اوسمهالول',
	'usersignup-resend-email-heading-success' => 'نوی برېښليک ولېږل شو',
	'usersignup-confirm-page-heading-confirmed-user' => 'بختور مو شه!',
	'usersignup-confirmation-heading-email-resent' => 'نوی برېښليک ولېږل شو',
	'usersignup-confirmation-subheading' => 'خپل برېښليک وگورۍ',
	'usersignup-welcome-email-explore-wiki-content' => 'په ويکيا کې په زرگونو ويکي گانې شته، نورې هغه ويکي گانې چې تاسې يې لېواله ياست، زموږ زېرمتون ته په ورتللو سره موندلی شی: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">ويډيويي لوبې</a>، <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">تفريحي</a>، يا <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">ژوندتوگه</a>.',
	'usersignup-welcome-email-signature' => 'د ويکيا ډله',
	'usersignup-heading' => 'ويکيا سره همدا نن يوځای شۍ',
	'usersignup-marketing-global-heading' => 'جوړول',
);

/** Portuguese (português)
 * @author Josep Maria 15.
 * @author Luckas
 * @author SandroHc
 * @author Vitorvicentevalente
 */
$messages['pt'] = array(
	'usersignup-page-title' => 'Junte-se à Wikia',
	'usersignup-page-title-wikiamobile' => 'Criar uma conta',
	'usersignup-page-captcha-label' => 'Captcha',
	'usersignup-error-username-length' => 'Opa, o seu nome de usuário não pode ter mais do que {{PLURAL:$1|um caracter|$1 caracteres}}.',
	'usersignup-error-invalid-user' => 'Usuário inválido. Faça o login primeiro.',
	'usersignup-error-invalid-email' => 'Por favor, insira um endereço de email válido.',
	'usersignup-error-symbols-in-username' => 'Opa, o seu nome de usuário pode conter apenas letras e números.',
	'usersignup-error-empty-email' => 'Opa, por favor, preencha seu endereço de e-mail.',
	'usersignup-error-empty-username' => 'Opa, por favor preencha o campo nome de usuário.',
	'usersignup-error-already-confirmed' => 'Você já confirmou este endereço de e-mail.',
	'usersignup-error-throttled-email' => 'Opa, você solicitou muitos e-mails de confirmação hoje. Tente novamente daqui a pouco.',
	'usersignup-error-too-many-changes' => 'Você atingiu o limite máximo para alterações de e-mail hoje. Por favor, tente novamente mais tarde.',
	'usersignup-error-password-length' => 'Oops, sua senha é muito longa. Por favor, escolha uma senha de 50 caracteres ou menos.',
	'usersignup-error-confirmed-user' => 'Parece que você já confirmou seu endereço de e-mail para $1!  Verifique o seu [perfil de usuário $2].', # Fuzzy
	'usersignup-facebook-heading' => 'Termine de se inscrever',
	'usersignup-facebook-create-account' => 'Criar conta',
	'usersignup-facebook-email-tooltip' => 'Se você gostaria de usar um endereço de e-mail diferente você pode alterar isso mais tarde em suas preferências.',
	'usersignup-facebook-have-an-account-heading' => 'Já tem uma conta?',
	'usersignup-facebook-have-an-account' => 'Conecte o seu nome de usuário da Wikia com o Facebook.',
	'usersignup-facebook-proxy-email' => 'Email do Facebook anônimo',
	'usersignup-user-pref-emailconfirmlink' => 'Envie-me um novo e-mail de confirmação',
	'usersignup-user-pref-confirmemail_send' => 'Envie-me um novo e-mail de confirmação',
	'usersignup-user-pref-emailauthenticated' => 'Obrigado! Seu e-mail foi confirmado em $2 às $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Verifique o seu e-mail e clique no link de confirmação para terminar de mudar o seu e-mail para: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Ah, não! Seu e-mail ainda não foi confirmado. As funções de email não funcionarão até que você confirme o seu endereço de e-mail.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Quase lá! Nós mandamos um novo email de confirmação para $1. Verifique o seu email e clique no link para terminar de confirmar o seu endereço de email.',
	'usersignup-user-pref-noemailprefs' => 'Parece que não temos um endereço de e-mail para você. Por favor, insira um endereço de e-mail acima.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Ah, não! O seu e-mail ainda não confirmado. Nós já lhe enviamos um e-mail, clique no link de confirmação lá para confirmar.',
	'usersignup-user-pref-confirmemail_noemail' => 'Parece que não temos um endereço de e-mail para você. Vá para [[Especial: Preferências|Preferências]] para adicionar um.', # Fuzzy
	'usersignup-confirm-page-title' => 'Confirme o seu email',
	'usersignup-confirm-page-title-wikiamobile' => 'Verifique o seu e-mail',
	'usersignup-confirm-email-resend-email' => 'Envie-me um novo e-mail de confirmação',
	'usersignup-confirm-email-change-email-content' => 'Eu quero usar um e-mail diferente.',
	'usersignup-confirm-email-change-email' => 'Altere o meu endereço de e-mail',
	'usersignup-confirm-email-new-email-label' => 'Novo e-mail',
	'usersignup-confirm-email-update' => 'Atualize',
	'usersignup-confirm-email-tooltip' => 'Você adicionou um endereço de email que você não pode confirmar, ou você quer usar um endereço de email diferente? Não se preocupe, use o link abaixo para mudar o seu endereço de email e receber um novo email de confirmação.',
	'usersignup-resend-email-heading-success' => 'Novo e-mail enviado',
	'usersignup-resend-email-heading-failure' => 'E-mail não foi reenviado',
	'usersignup-confirm-page-heading-confirmed-user' => 'Parabéns!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Você já está confirmado',
	'usersignup-confirmation-heading' => 'Quase lá',
	'usersignup-confirmation-heading-wikiamobile' => 'Verifique o seu e-mail',
	'usersignup-confirmation-heading-email-resent' => 'Novo e-mail enviado',
	'usersignup-confirmation-subheading' => 'Verifique o seu e-mail',
	'usersignup-confirmation-email-sent' => "Nós enviamos um e-mail para '''$1'''.

Clique no link de confirmação no seu e-mail para concluir a criação de sua conta.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Nós enviamos um e-mail para '''$1'''.

Clique no link de confirmação no seu e-mail para concluir a criação de sua conta. Obrigado!",
	'usersignup-reconfirmation-email-sent' => 'O seu endereço de e-mail foi alterado para $1. Enviamos-lhe um novo e-mail de confirmação. Por favor, confirme o novo endereço de e-mail.',
	'usersignup-welcome-email-subject' => 'Bem-vindo à Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Olá $USERNAME',
	'usersignup-welcome-email-heading' => 'Estamos felizes em recebê-lo na Wikia e na {{SITENAME}}! Aqui estão algumas coisas que você pode fazer para começar.',
	'usersignup-welcome-email-edit-profile-heading' => 'Edite seu perfil.',
	'usersignup-welcome-email-edit-profile-content' => 'Adicione uma foto de perfil e alguns fatos sobre você no seu perfil {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Vá para o perfil',
	'usersignup-welcome-email-learn-basic-heading' => 'Aprenda o básico.',
	'usersignup-welcome-email-learn-basic-content' => 'Veja um tutorial rápido sobre os princípios básicos da Wikia: como editar uma página, seu perfil de usuário, alterar suas preferências e mais.',
	'usersignup-welcome-email-learn-basic-button' => 'Confira',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explore mais wikias.',
	'usersignup-welcome-email-explore-wiki-content' => 'Há milhares de comunidades na Wikia, encontre algumas que the interessam visitando os nossos portais: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Video Games</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Entretenimento</a>, ou <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Estilo de Vida</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Ir para pt.wikia.com',
	'usersignup-welcome-email-content' => 'Quer mais informações? Encontre respostas, conselhos e a comunidade Wikia na <a style="color:#2C85D5;" href="http://comunidade.wikia.com"> Central da Comunidade</a>. Boas contribuições!',
	'usersignup-welcome-email-signature' => 'A equipe da Wikia',
	'usersignup-welcome-email-body' => 'Olá $USERNAME,

Nós estamos felizes em recebê-lo na Wikia e na {{SITENAME}}! Aqui estão algumas coisas que você pode fazer para começar.

Edite o seu perfil.

Adicione uma foto e alguns fatos sobre você no seu perfil na {{SITENAME}}.

Vá para $EDITPROFILEURL

Aprenda o básico.

Veja um tutorial rápido sobre o básico na Wikia: como editar uma página, o seu perfil de usuário, mude as suas preferências, e mais.

Confira ($LEARNBASICURL)

Explore mais comunidades.

Há várias comunidades na Wikia, encontre algumas que lhe interessam visitando um dos nossos portais: Video Games (http://www.wikia.com/Video_Games), Entretenimento (http://www.wikia.com/Entertainment), ou Estilo de Vida (http://www.wikia.com/Lifestyle).

Vá para $EXPLOREWIKISURL

Quer mais informações? Encontre conselhos, respostas e a comunidade da Wikia na Central da Comunidade (http://www.comunidade.wikia.com). Boas contribuições!

A equipe da Wikia

___________________________________________

Para conferir os últimos acontecimentos na Wikia, visite http://comunidade.wikia.com
Quer controlar quais emails você recebe? Vá para: {{fullurl:{{ns:special}}:Preferências}}',
	'usersignup-heading' => 'Junte-se à Wikia hoje',
	'usersignup-heading-byemail' => 'Crie uma conta para outra pessoa',
	'usersignup-marketing-wikia' => 'Comece a colaborar com milhões de pessoas ao redor do mundo que se reúnem para compartilhar o que conhecem e amam.',
	'usersignup-marketing-login' => 'Já é um usuário? [[Especial: UserLogin|Entrar]]', # Fuzzy
	'usersignup-marketing-benefits' => 'Seja parte de algo grande',
	'usersignup-marketing-community-heading' => 'Colabore',
	'usersignup-marketing-community' => 'Descubra e explore temas que vão desde vídeo games a filmes e televisão. Conheça pessoas com interesses e paixões semelhantes.',
	'usersignup-marketing-global-heading' => 'Crie',
	'usersignup-marketing-global' => 'Comece uma wiki. Comece aos poucos e cresça bastante com a ajuda dos outros.',
	'usersignup-marketing-creativity-heading' => 'Seja original',
	'usersignup-marketing-creativity' => 'Use a Wikia para expressar sua criatividade com as pesquisas e listas top 10, galerias de foto e vídeo, aplicativos e mais.',
	'usersignup-createaccount-byemail' => 'Crie uma conta para outra pessoa',
	'usersignup-error-captcha' => 'A resposta do captcha falhou, por favor, tente novamente!',
	'usersignup-account-creation-heading' => 'Sucesso!',
	'usersignup-account-creation-subheading' => 'Enviamos um e-mail para $1',
	'usersignup-account-creation-email-sent' => 'Você começou o processo de criação de conta para $2. Nós enviamos um e-mail para $1 com uma senha temporária e um link de confirmação.

$2 precisará clicar no link no e-mail que nós enviamos para confirmar sua conta e alterar sua senha temporária para terminar de criar sua conta.


[{{fullurl: {{ns:special}}: UserSignup|byemail=1}} Criar mais contas] em {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Uma conta foi criada para você na Wikia!',
	'usersignup-account-creation-email-greeting' => 'Olá,',
	'usersignup-account-creation-email-content' => 'Uma conta foi criada para você na {{SITENAME}}. Para acessar sua conta e alterar sua senha temporária, clique no link abaixo e inicie a sessão com o nome de usuário "$USERNAME" e senha "$NEWPASSWORD".

Efetue o login no <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}"> {{fullurl: {{ns:special}}: UserLogin}}</a>

Se você não quiser que esta conta seja criada, simplesmente ignore este e-mail ou entre em contato com nossa equipe de suporte da Comunidade se você tiver alguma pergunta.',
	'usersignup-account-creation-email-signature' => 'A equipe da Wikia',
	'usersignup-account-creation-email-body' => 'OIá,

Uma conta foi criada para você na {{SITENAME}}. Para acessar sua conta e alterar sua senha temporária, clique no link abaixo e inicie a sessão com o nome de usuário "$2" e senha "$3".

Por favor, efetue o login no {{fullurl:{{ns:special}}:UserLogin}}

Se você não quiser que esta conta seja criada, simplesmente ignore este e-mail ou entre em contato com nossa equipe de suporte da Comunidade se você tiver alguma pergunta.

A equipe da Wikia


___________________________________________

Para conferir os últimos acontecimentos na Wikia, visite http://comunidade.wikia.com
Quer controlar quais emails você recebe? Vá para: {{fullurl:{{ns:special}}:Preferências}}',
	'usersignup-facebook-problem' => 'Houve um problema na comunicação com o Facebook. Por favor, tente novamente mais tarde.',
	'usersignup-facebook-signup-header' => 'Criando uma conta nova?',
	'usersignup-facebook-login-header' => 'Já tem uma conta?',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Caio1478
 * @author Guilhermemau
 * @author Jefersonmoraes
 * @author Luckas
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'usersignup-page-title' => 'Junte-se à comunidade Wikia',
	'usersignup-page-title-wikiamobile' => 'Criar uma conta',
	'usersignup-page-captcha-label' => 'Palavra Obscura', # Fuzzy
	'usersignup-error-invalid-user' => 'Usuário inválido. Por favor, autentique-se primeiro.',
	'usersignup-error-invalid-email' => 'Por favor, insira um endereço de e-mail válido.',
	'usersignup-error-symbols-in-username' => 'Ops, seu nome de usuário pode conter apenas letras e números.',
	'usersignup-error-empty-email' => 'Opa, por favor preencha o seu endereço de e-mail.',
	'usersignup-error-empty-username' => 'Opa, por favor preencha o campo nome de usuário.',
	'usersignup-error-already-confirmed' => 'Você já confirmou este endereço de e-mail.',
	'usersignup-facebook-heading' => 'Concluir o Registro',
	'usersignup-facebook-create-account' => 'Criar conta',
	'usersignup-facebook-have-an-account-heading' => 'Já tem uma conta?',
	'usersignup-facebook-have-an-account' => 'Conecte o seu nome de usuário Wikia existente com Facebook ao invés.',
	'usersignup-facebook-proxy-email' => 'Endereço de e-mail anônimo do Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Solicitar um novo e-mail de confirmação',
	'usersignup-user-pref-confirmemail_send' => 'Reenviar o meu e-mail de confirmação',
	'usersignup-user-pref-emailauthenticated' => 'Obrigado! Seu e-mail foi confirmado às $2 e $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Verifique se o seu e-mail e clique no link de confirmação para concluir a alteração do seu e-mail: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Ah, não! Seu e-mail não está confirmado. As funcionalidades do e-mail não irão funcionar até que você confirme o seu endereço de e-mail.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Quase lá! Enviamos um novo e-mail de confirmação para $1. Verifique o seu e-mail e clique no link para concluir a confirmação.',
	'usersignup-user-pref-noemailprefs' => 'Parece que não temos um endereço de e-mail para você. Por favor insira acima um endereço de e-mail.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Ah, não! Seu e-mail não está confirmado. Enviamos um e-mail, clique no link de confirmação para confirmar.',
	'usersignup-user-pref-confirmemail_noemail' => 'Parece que não temos um endereço de e-mail para você. Vá para [[Special:Preferences|preferências]] para inserir um.',
	'usersignup-confirm-page-title' => 'Confirme seu e-mail',
	'usersignup-confirm-page-title-wikiamobile' => 'Verifique seu e-mail',
	'usersignup-confirm-email-resend-email' => 'Envie-me outro e-mail de confirmação',
	'usersignup-confirm-email-change-email-content' => 'Eu quero usar um endereço de e-mail diferente.',
	'usersignup-confirm-email-change-email' => 'Alterar o meu endereço de e-mail',
	'usersignup-confirm-email-new-email-label' => 'Novo e-mail',
	'usersignup-confirm-email-update' => 'Atualizar',
	'usersignup-confirm-email-tooltip' => 'Você digitou um endereço de e-mail que não pode confirmar, ou quer usar um endereço de e-mail diferente? Não se preocupe, use o link abaixo para alterar seu endereço de e-mail e receber um novo e-mail de confirmação.',
	'usersignup-resend-email-heading-success' => 'Novo e-mail enviado',
	'usersignup-resend-email-heading-failure' => 'E-mail não re-enviado',
	'usersignup-confirm-page-heading-confirmed-user' => 'Parabéns!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Você já está confirmado',
	'usersignup-confirmation-heading' => 'Quase lá',
	'usersignup-confirmation-heading-wikiamobile' => 'Verifique seu e-mail',
	'usersignup-confirmation-heading-email-resent' => 'Novo e-mail enviado',
	'usersignup-confirmation-subheading' => 'Verifique seu e-mail',
	'usersignup-welcome-email-subject' => 'Bem-vindo à Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Olá $USERNAME,',
	'usersignup-welcome-email-heading' => 'Estamos felizes em recebê-lo na Wikia e {{SITENAME}}! Aqui estão algumas coisas que você pode fazer para começar.',
	'usersignup-welcome-email-edit-profile-heading' => 'Editar seu perfil.',
	'usersignup-welcome-email-edit-profile-button' => 'Ir para o perfil',
	'usersignup-welcome-email-learn-basic-heading' => 'Aprenda o básico.',
	'usersignup-welcome-email-learn-basic-content' => 'Obtenha um rápido tutorial sobre as noções básicas da Wikia: como editar uma página, seu perfil de usuário, alterar as suas preferências, e muito mais.',
	'usersignup-welcome-email-learn-basic-button' => 'Confira',
	'usersignup-welcome-email-explore-wiki-heading' => 'Explorar mais wikias.',
	'usersignup-welcome-email-explore-wiki-content' => 'Existem milhares de wikias na Wikia, encontre mais wikias que lhe interessam indo para um de nossos hubs: <a style="color:#2C85D5;" href="http://pt.videogameshub.wikia.com/wiki/Wiki_Videogameshub">Vídeo Games</a>, <a style="color:#2C85D5;" href="http://pt.entretenimento.wikia.com/wiki/Wiki_Entretenimento">Entretenimento</a>, or <a style="color:#2C85D5;" href="http://pt.estilodevida.wikia.com/wiki/Wiki_Estilo_de_Vida">Estilo de Vida</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Ir para pt-br.wikia.com',
	'usersignup-welcome-email-content' => 'Quer mais informações? Encontre conselhos e respostas da comunidade Wikia em <a style="color:#2C85D5;" href="http://comunidade.wikia.com">Central da Comunidade Wikia</a>. Divirta-se com as edições!',
	'usersignup-welcome-email-signature' => 'A Equipe da Wikia',
	'usersignup-heading' => 'Junte-se à Wikia Hoje',
	'usersignup-heading-byemail' => 'Criar uma conta para outra pessoa',
	'usersignup-marketing-wikia' => 'Comece a colaborar com milhões de pessoas de todo o mundo que se reúnem para compartilhar o que sabem e amam.',
	'usersignup-marketing-login' => 'Já é um usuário? [[Special:UserLogin|Login]]',
	'usersignup-marketing-benefits' => 'Seja parte de algo grande',
	'usersignup-marketing-community-heading' => 'Colabore',
	'usersignup-marketing-community' => 'Descubra e explore assuntos que vão desde jogos eletrônicos para filmes e TV. Conheça pessoas com interesses e paixões semelhantes.',
	'usersignup-marketing-global-heading' => 'Crie',
	'usersignup-marketing-global' => 'Comece uma wikia. Comece com pequeno, e cresça grande com a ajuda de outros.',
	'usersignup-marketing-creativity-heading' => 'Seja original',
	'usersignup-marketing-creativity' => 'Use a Wikia para expressar sua criatividade com as pesquisas e listas de top 10, fotos e galerias de vídeo, aplicações e muito mais.',
	'usersignup-createaccount-byemail' => 'Crie uma conta para outra pessoa',
	'usersignup-error-captcha' => 'A palavra que você digitou não corresponde a palavra na caixa, tente novamente!', # Fuzzy
	'usersignup-account-creation-heading' => 'Sucesso!',
	'usersignup-account-creation-subheading' => 'Enviamos um e-mail para $1',
	'usersignup-account-creation-email-subject' => 'Uma conta foi criada para você na Wikia!',
	'usersignup-account-creation-email-greeting' => 'Olá,',
	'usersignup-account-creation-email-signature' => 'A Equipe da Wikia',
	'usersignup-facebook-problem' => 'Houve um problema de comunicação com o Facebook. Por favor, tente novamente mais tarde.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'usersignup-page-title' => 'Join Uicchia',
	'usersignup-page-captcha-label' => 'Sfide',
	'usersignup-error-username-length' => "Pizze, 'u nome utende tune non ge pò essere cchiù de {{PLURAL:$1|'nu carattere|$1 carattere}}.",
	'usersignup-error-invalid-user' => 'Utende invalide. Pe piacere tràse apprime.',
	'usersignup-confirm-email-new-email-label' => 'Mail nove',
	'usersignup-confirm-email-update' => 'Aggiorne',
	'usersignup-confirm-page-heading-confirmed-user' => 'Comblimende!',
	'usersignup-confirmation-heading-email-resent' => 'Email nove mannate',
	'usersignup-confirmation-subheading' => "Condrolle l'email toje",
	'usersignup-welcome-email-greeting' => 'Cià $USERNAME',
	'usersignup-marketing-community-heading' => 'Collabbore',
	'usersignup-marketing-global-heading' => 'Ccreje',
	'usersignup-account-creation-email-greeting' => 'Cià,',
);

/** Russian (русский)
 * @author DCamer
 * @author Kuzura
 * @author Okras
 * @author Tourorist
 */
$messages['ru'] = array(
	'usersignup-page-title' => 'Присоединиться к Викия',
	'usersignup-page-title-wikiamobile' => 'Создать учётную запись',
	'usersignup-page-captcha-label' => 'Captcha',
	'usersignup-error-username-length' => 'Имя участника не может содержать больше {{PLURAL:$1|одного символа|$1 символов}}.',
	'usersignup-error-invalid-user' => 'Некорректное имя участника. Пожалуйста, войдите ещё раз.',
	'usersignup-error-invalid-email' => 'Пожалуйста, укажите действительный адрес электронной почты.',
	'usersignup-error-symbols-in-username' => 'Имя участника может содержать только буквы и цифры.',
	'usersignup-error-empty-email' => 'Пожалуйста, укажите адрес электронной почты.',
	'usersignup-error-empty-username' => 'Пожалуйста, укажите имя участника.',
	'usersignup-error-already-confirmed' => 'Вы уже подтвердили этот адрес электронной почты.',
	'usersignup-error-throttled-email' => 'Вы оставили слишком много запросов о подтверждении адресов электронной почты. Повторите попытку через некоторое время.',
	'usersignup-error-too-many-changes' => 'Вы изменили адрес электронной почты максимальное число раз за сегодня. Пожалуйста, повторите попытку позже.',
	'usersignup-error-password-length' => 'Указанный вами пароль слишком длинный. Пожалуйста, выберите пароль, который содержит менее 50 символов.',
	'usersignup-error-confirmed-user' => 'Похоже, вы уже подтвердили адрес электронной почты: $1.  Проверьте ваши [$2 личные настройки].', # Fuzzy
	'usersignup-facebook-heading' => 'Завершить регистрацию',
	'usersignup-facebook-create-account' => 'Создать учётную запись',
	'usersignup-facebook-email-tooltip' => 'Если вы хотите использовать другой адрес электронной почты, вы сможете изменить его позже в личных настройках.',
	'usersignup-facebook-have-an-account-heading' => 'Уже есть учётная запись?',
	'usersignup-facebook-have-an-account' => 'Подключить уже существующую учётную запись Викия к Facebook.',
	'usersignup-facebook-proxy-email' => 'Использовать адрес эл. почты от Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Запросить новое подтверждение электронной почты',
	'usersignup-user-pref-confirmemail_send' => 'Отправить подтверждение электронной почты',
	'usersignup-user-pref-emailauthenticated' => 'Спасибо! Ваш адрес электронной почты был подтверждён $2 в $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Проверьте свою электронную почту и нажмите на ссылку подтверждения, чтобы завершить изменение адреса электронной почты $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Ваша электронная почта не подтверждена. Функции, связанные с ней, не будут работать до тех пор, пока вы не подтвердите адрес электронной почты.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Мы отправили новое подтверждение на адрес электронной почты $1. Проверьте её и нажмите на ссылку, чтобы подтвердить адрес электронной почты.',
	'usersignup-user-pref-noemailprefs' => 'Похоже, вы не указали адрес электронной почты. Пожалуйста, введите адрес электронной почты выше.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Ваш адрес электронной почты не подтверждён. Мы отправили вам по электронной почте ссылку, нажав на которую, вы подтвердите его.',
	'usersignup-user-pref-confirmemail_noemail' => 'Похоже, вы не указали адрес электронной почты. Перейдите на страницу [[Special:Preferences|личных настроек]], чтобы указать его.',
	'usersignup-confirm-page-title' => 'Подтвердить адрес электронной почты',
	'usersignup-confirm-page-title-wikiamobile' => 'Проверьте вашу электронную почту',
	'usersignup-confirm-email-resend-email' => 'Прислать новую ссылку для подтверждения электронной почты',
	'usersignup-confirm-email-change-email-content' => 'Я хочу использовать другой адрес электронной почты.',
	'usersignup-confirm-email-change-email' => 'Изменить мой адрес электронной почты',
	'usersignup-confirm-email-new-email-label' => 'Новый адрес электронной почты',
	'usersignup-confirm-email-update' => 'Обновить',
	'usersignup-confirm-email-tooltip' => 'Вы указали адрес электронной почты, который не можете подтвердить, или вы хотите использовать другой адрес электронной почты? Не волнуйтесь, используйте ссылку ниже, чтобы изменить его и получить новое подтверждение по электронной почте.',
	'usersignup-resend-email-heading-success' => 'Письмо отправлено',
	'usersignup-resend-email-heading-failure' => 'Письмо не отправлено',
	'usersignup-confirm-page-heading-confirmed-user' => 'Поздравляем!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Уже подтверждено',
	'usersignup-confirmation-heading' => 'Почти готово',
	'usersignup-confirmation-heading-wikiamobile' => 'Проверьте вашу электронную почту',
	'usersignup-confirmation-heading-email-resent' => 'Письмо отправлено',
	'usersignup-confirmation-subheading' => 'Проверьте вашу электронную почту',
	'usersignup-confirmation-email-sent' => "Мы отправили письмо на адрес: '''$1'''.

Нажмите на ссылку подтверждения в письме для завершения создания учётной записи.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Мы отправили письмо на адрес: '''$1'''.

Нажмите на ссылку подтверждения в письме для завершения создания учётной записи. Спасибо!",
	'usersignup-reconfirmation-email-sent' => 'Вы изменили адрес электронной почты на: $1. Мы отправили вам новое письмо со ссылкой на подтверждение. Пожалуйста, подтвердите новый адрес электронной почты.',
	'usersignup-welcome-email-subject' => 'Добро пожаловать на Викия, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Привет, $USERNAME,',
	'usersignup-welcome-email-heading' => 'Мы рады приветствовать вас на Викия и {{SITENAME}}! Вот некоторые вещи, которые помогут вам начать.',
	'usersignup-welcome-email-edit-profile-heading' => 'Отредактируйте свою личную страницу.',
	'usersignup-welcome-email-edit-profile-content' => 'Добавьте изображение и несколько фактов о себе на личную страничку на {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Перейти на личную страничку',
	'usersignup-welcome-email-learn-basic-heading' => 'Узнайте основы.',
	'usersignup-welcome-email-learn-basic-content' => 'Прочитайте краткое руководство о Викия: как редактировать страницу, как добавить аватар, как изменить некоторые настройки и другое.',
	'usersignup-welcome-email-learn-basic-button' => 'Проверьте',
	'usersignup-welcome-email-explore-wiki-heading' => 'Исследуйте другие википроекты.',
	'usersignup-welcome-email-explore-wiki-content' => 'Викия содержит тысячи википроектов! Чтобы найти то, что интересно именно вам, посетите страницы порталов: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Видеоигры</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Кино, сериалы, анимация</a> или <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Увлечения</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Перейти на wikia.com',
	'usersignup-welcome-email-content' => 'Нужно больше информации? Найти советы и ответы на вопросы можно у других участников на <a style="color:#2C85D5;" href="http://ru.community.wikia.com">Вики Сообщества</a>. Счастливого редактирования!',
	'usersignup-welcome-email-signature' => 'Команда Викия',
	'usersignup-welcome-email-body' => 'Привет, $USERNAME,

Мы рады приветствовать вас на Викия и {{SITENAME}}! Вот некоторые вещи, которые помогут вам начать.

Отредактируйте свою личную страницу.

Добавьте изображение и несколько фактов о себе на личную страничку на {{SITENAME}}.

Перейти на $EDITPROFILEURL

Узнайте основы.

Прочитайте краткое руководство о Викия: как редактировать страницу, как добавить аватар, как изменить некоторые настройки и другое.

Проверьте ($LEARNBASICURL)

Исследуйте другие википроекты.

Викия содержит тысячи википроектов! Чтобы найти то, что интересно именно вам, посетите страницы порталов: Видеоигры (http://www.wikia.com/Video_Games), Кино, сериалы, анимация (http://www.wikia.com/Entertainment) или Увлечения (http://www.wikia.com/Lifestyle).

Перейти к $EXPLOREWIKISURL

Нужно больше информации? Найти советы и ответы на вопросы можно у других участников на Вики Сообщества (http://www.ru.community.wikia.com). Счастливого редактирования!

Команда Викия


___________________________________________

Чтобы узнать свежие новости Викия, посетите http://community.wikia.com
Хотите отписаться от этой рассылки? Перейдите на страницу {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Присоединяйтесь к Викия сегодня',
	'usersignup-heading-byemail' => 'Создать учётную запись для другого человека',
	'usersignup-marketing-wikia' => 'Начните сотрудничество с миллионами людей со всего мира, которые собрались вместе, чтобы поделиться тем, что они знают и любят.',
	'usersignup-marketing-login' => 'Уже есть учётная запись? [[Special:UserLogin|Войти]]',
	'usersignup-marketing-benefits' => 'Станьте частью чего-то огромного',
	'usersignup-marketing-community-heading' => 'Сотрудничайте',
	'usersignup-marketing-community' => 'Открывайте и исследуйте различные темы – от видеоигр до кино и телевидения. Встречайте людей с такими же интересами и увлечениями.',
	'usersignup-marketing-global-heading' => 'Создавайте',
	'usersignup-marketing-global' => 'Создайте вики. Начните с малого и вырастите нечто большое с помощью других участников.',
	'usersignup-marketing-creativity-heading' => 'Будьте креативны',
	'usersignup-marketing-creativity' => 'Используйте Викия, чтобы выразить свои идеи с помощью опросов и рейтинговых списков, фото и видео галерей, приложений и многих других вещей.',
	'usersignup-createaccount-byemail' => 'Создать учётную запись для другого человека',
	'usersignup-error-captcha' => 'Вызвать Captcha не удалось, попробуйте ещё раз.',
	'usersignup-account-creation-heading' => 'Отлично!',
	'usersignup-account-creation-subheading' => 'Мы отправили электронное письмо на: $1',
	'usersignup-account-creation-email-sent' => '$2, вы начали процесс создания учётной записи Викия. Мы отправили вам электронное письмо на $1 с временным паролем и ссылкой на подтверждение учётной записи.


Для завершения создания учётной записи вам необходимо нажать на ссылку в письме, чтобы подтвердить учётную запись и изменить временный пароль на ваши личный пароль.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Создать ещё один аккаунт] на {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Вы создали учётную запись Викия!',
	'usersignup-account-creation-email-greeting' => 'Привет,',
	'usersignup-account-creation-email-content' => 'Вы создали учётную запись Викия на {{SITENAME}}. Чтобы получить доступ к учётной записи и изменить временный пароль, нажмите на ссылку ниже, укажите своё имя участника - "$USERNAME" и пароль - "$NEWPASSWORD".

Перейти на <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Если вы не запрашивали создание этой учётной записи, просто проигнорируйте это письме или свяжитесь со службой поддержки.',
	'usersignup-account-creation-email-signature' => 'Команда Викия',
	'usersignup-account-creation-email-body' => 'Привет,

Вы создали учётную запись Викия на {{SITENAME}}. Чтобы получить доступ к учётной записи и изменить временный пароль, нажмите на ссылку ниже, укажите своё имя участника - "$2" и пароль - "$3".

Перейти на {{fullurl:{{ns:special}}:UserLogin}}

Если вы не запрашивали создание этой учётной записи, просто проигнорируйте это письме или свяжитесь со службой поддержки.

Команда Викия


___________________________________________

Чтобы узнать свежие новости Викия, посетите http://community.wikia.com
Хотите отписаться от этой рассылки? Перейдите на страницу {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Есть проблема с соединением с Facebook. Пожалуйста, повторите попытку позже.',
	'usersignup-facebook-signup-header' => 'Создать новую учётную запись?',
	'usersignup-facebook-login-header' => 'Уже есть учётная запись?',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'usersignup-page-title' => 'Gå med i Wikia',
	'usersignup-page-title-wikiamobile' => 'Skapa konto',
	'usersignup-page-captcha-label' => 'Utmaning',
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
	'usersignup-facebook-proxy-email' => 'Anonym Facebook-e-post',
	'usersignup-user-pref-emailconfirmlink' => 'Begär en ny e-postbekräftelse',
	'usersignup-user-pref-confirmemail_send' => 'Skicka min e-postbekräftelse igen',
	'usersignup-user-pref-emailauthenticated' => 'Tack! Din e-postadress bekräftades den $2 kl $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Kontrollera din e-post och klicka på bekräftelselänken för att slutföra din e-poständring till: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Ånej! Din e-post är obekräftad. E-postfunktioner kommer inte fungera tills du har bekräftat din e-postadress.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Nästan klar! Vi har skickat en ny e-postbekräftelse till $1. Kontrollera din e-post och klicka på länken för att slutföra bekräftelsen av din e-postadress.',
	'usersignup-user-pref-noemailprefs' => 'Det ser ut som vi inte har en e-postadress för dig. Var god ange en e-postadress ovan.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Ånej! Din e-postadress är obekräftad. Vi har skickat ett e-postmeddelande till dig. Klicka på bekräftelselänken för att bekräfta.',
	'usersignup-user-pref-confirmemail_noemail' => 'Det ser ut som vi inte har en e-postadress för dig. Gå till [[Special:Preferences|användarinställningar]] för att ange ett.',
	'usersignup-confirm-page-title' => 'Bekräfta din e-postadress',
	'usersignup-confirm-page-title-wikiamobile' => 'Kontrollera din e-postadress',
	'usersignup-confirm-email-resend-email' => 'Skicka mig en till e-postbekräftelse',
	'usersignup-confirm-email-change-email-content' => 'Jag vill använda en annan e-postadress.',
	'usersignup-confirm-email-change-email' => 'Ändra min e-postadress',
	'usersignup-confirm-email-new-email-label' => 'Ny e-post',
	'usersignup-confirm-email-update' => 'Uppdatera',
	'usersignup-confirm-email-tooltip' => 'Angav du en e-postadress som du inte kan bekräfta, eller vill du använda en annan e-postadress? Oroa dig inte, använd länken nedan för att ändra din e-postadress och få en ny e-postbekräftelse.',
	'usersignup-resend-email-heading-success' => 'Ny e-post skickad',
	'usersignup-resend-email-heading-failure' => 'E-post skickades inte igen',
	'usersignup-confirm-page-heading-confirmed-user' => 'Gratulerar!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Du är redan bekräftat',
	'usersignup-confirmation-heading' => 'Nästan klar',
	'usersignup-confirmation-heading-wikiamobile' => 'Kontrollera din e-postadress',
	'usersignup-confirmation-heading-email-resent' => 'Ny e-post skickad',
	'usersignup-confirmation-subheading' => 'Kontrollera din e-post',
	'usersignup-confirmation-email-sent' => "Vi har skickat ett e-postmeddelande till '''$1'''.

Klicka på bekräftelselänken i din e-post för att slutföra skapandet av ditt konto.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Vi har skickat ett e-postmeddelande till '''$1'''.

Klicka på bekräftelselänken i din e-postmeddelande för att slutföra skapandet av ditt konto. Tack!",
	'usersignup-reconfirmation-email-sent' => 'Din e-postadress har ändrats till $1. Vi har skickat en ny e-postbekräftelse. Var god bekräfta den nya e-postadressen.',
	'usersignup-welcome-email-subject' => 'Välkommen till Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hej $USERNAME',
	'usersignup-welcome-email-heading' => 'Vi är glada att välkomna dig till Wikia och {{SITENAME}}! Här är några saker du kan göra för att komma igång.',
	'usersignup-welcome-email-edit-profile-heading' => 'Redigera din profil.',
	'usersignup-welcome-email-edit-profile-content' => 'Lägg till ett profilfoto och lite snabb fakta om dig själv på din profil på {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Gå till profil',
	'usersignup-welcome-email-learn-basic-heading' => 'Lär dig grunderna.',
	'usersignup-welcome-email-learn-basic-content' => 'Få en snabb genomgång om grunderna i Wikia: hur man redigerar en sida, din användarprofil, ändra dina inställningar och mer.',
	'usersignup-welcome-email-learn-basic-button' => 'Spana in det',
	'usersignup-welcome-email-explore-wiki-heading' => 'Utforska fler wikis.',
	'usersignup-welcome-email-explore-wiki-content' => 'Det finns tusentals wikis på Wikia, hitta mer wikis som du är intresserad av genom att gå till en av våra hubbar: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Videospel</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Underhållning</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Livsstil</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Gå till wikia.com',
	'usersignup-welcome-email-content' => 'Vill ha mer information? Hitta råd, svar och Wikia-gemenskapen på <a style="color:#2C85D5;" href="http://community.wikia.com">Community Central</a>. Ha det så kul med redigeringen!',
	'usersignup-welcome-email-signature' => 'Wikia-teamet',
	'usersignup-welcome-email-body' => 'Hej $USERNAME,

Vi är glada att välkomna dig till Wikia och {{SITENAME}}! Här är några saker du kan göra för att komma igång.

Redigera din profil.

	Lägg till ett profilfoto och lite snabb fakta om dig själv på din profil på {{SITENAME}}.

Gå till $EDITPROFILEURL

Lär dig grunderna.

Få en snabb genomgång om grunderna i Wikia: hur man redigerar en sida, din användarprofil, ändra dina inställningar och mer.

Spana in det på ($LEARNBASICURL)

Utforska fler wikis.

Det finns tusentals wikis på Wikia, hitta mer wikis som du är intresserad av genom att gå till en av våra hubbar: Videospel (http://www.wikia.com/Video_Games), Underhållning (http://www.wikia.com/Entertainment), or Livsstil (http://www.wikia.com/Lifestyle).

Gå till $EXPLOREWIKISURL

Vill ha mer information? Hitta råd, svar och Wikia-gemenskapen på Community Central (http://www.community.wikia.com). Ha det så kul med redigeringen!

Wikia-teamet


___________________________________________

För att kolla in de senaste händelserna på Wikia, besök http://community.wikia.com
Vill du kontrollera vilka e-postmeddelanden du får? Gå till: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Registrera dig på Wikia idag',
	'usersignup-heading-byemail' => 'Skapa ett konto för någon annan',
	'usersignup-marketing-wikia' => 'Börja samarbeta med miljontals människor från hela världen som har träffas för att dela vad de känner till och älskar.',
	'usersignup-marketing-login' => 'Redan en användare? [[Special:UserLogin|Logga in]]',
	'usersignup-marketing-benefits' => 'Bli en del av någonting stort',
	'usersignup-marketing-community-heading' => 'Samarbeta',
	'usersignup-marketing-community' => 'Upptäck och utforska frågor alltifrån videospel till film och TV. Träffa människor med liknande intressen och passioner.',
	'usersignup-marketing-global-heading' => 'Skapa',
	'usersignup-marketing-global' => 'Starta en wiki. Starta litet, väx stort, med hjälp av andra.',
	'usersignup-marketing-creativity-heading' => 'Var originell',
	'usersignup-marketing-creativity' => 'Använd Wikia för att uttrycka din kreativitet med omröstningar och Topp 10-listor, foto- och videogallerier, applikationer och mer.',
	'usersignup-createaccount-byemail' => 'Skapa ett konto för någon annan',
	'usersignup-error-captcha' => 'Felaktigt svar på utmaningen, försök igen!',
	'usersignup-account-creation-heading' => 'Åtgärden genomfördes!',
	'usersignup-account-creation-subheading' => 'Vi har skickat ett e-postmeddelande till $1',
	'usersignup-account-creation-email-sent' => 'Du har börjat på att skapa ett konto för $2. Vi har skickat ett e-postmeddelande till $1 med ett tillfälligt lösenord och en bekräftelselänk.


$2 kommer att behöva klicka på länken i e-postmeddelandet vi skickade för att bekräfta sitt konto och ändra sitt tillfälliga lösenord för att slutföra skapandet av sitt konton.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Skapa fler konton] på {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Ett konto har skapats för dig på Wikia!',
	'usersignup-account-creation-email-greeting' => 'Hallå,',
	'usersignup-account-creation-email-content' => 'Ett konto har skapats för dig på {{SITENAME}}. För att komma åt ditt konto och ändra ditt tillfälliga lösenord, klicka på länken nedan och logga in med användarnamnet "$USERNAME" och lösenordet "$NEWPASSWORD".

Var god logga in på <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Om du inte vill använda det här kontot ska skapas kan du helt enkelt ignorera detta e-postmeddelande eller kontakta vårt Gemenskapssupportsteam med några frågor.',
	'usersignup-account-creation-email-signature' => 'Wikia-teamet',
	'usersignup-account-creation-email-body' => 'Hallå,

Ett konto har skapats för dig på {{SITENAME}}. För att komma åt ditt konto och ändra din tillfälliga lösenord klickar du på länken nedan och loggar in med användarnamnet "$2" och lösenordet "$3".

Var god logga in på {{fullurl:{{ns:special}}:UserLogin}}

Om du inte vill använda det här kontot ska skapas kan du helt enkelt ignorera detta e-postmeddelande eller kontakta vårt gemenskapssupportsteam med några frågor.

Wikia-teamet


___________________________________________

För att kolla in de senaste händelserna på Wikia, besök http://community.wikia.com
Vill du kontrollera vilka e-postmeddelanden du får? Gå till: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Det gick inte att kommunicera med Facebook. Försök igen senare.',
	'usersignup-facebook-signup-header' => 'Skapa ett nytt konto?',
	'usersignup-facebook-login-header' => 'Har redan ett konto?',
);

/** Thai (ไทย)
 * @author Saipetch
 */
$messages['th'] = array(
	'usersignup-facebook-create-account' => 'สร้างบัญชีผู้ใช้',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'usersignup-page-title' => 'Sumali sa Wikia',
	'usersignup-page-captcha-label' => 'Malabong Salita', # Fuzzy
	'usersignup-error-username-length' => 'Naku, ang pangalan mo ng tagagamit ay hindi maaaring maging masa marami kaysa sa {{PLURAL:$1|isang panitik|$1 mga panitik}}.',
	'usersignup-error-invalid-user' => 'Hindi katanggap-tanggap na tagagamit. Paki lumagda muna.',
	'usersignup-error-invalid-email' => 'Paki magpasok ng isang katanggap-tanggap na tirahan ng e-liham.',
	'usersignup-error-symbols-in-username' => 'Naku, ang iyong pangalan ng tagagamit ay makapaglalaman lamang ng mga titik at mga bilang.',
	'usersignup-error-empty-email' => 'Naku, paki ipuno ang iyong tirahan ng e-liham.',
	'usersignup-error-empty-username' => 'Naku, paki punuan ang hanay ng pangalan ng tagagamit.',
	'usersignup-error-already-confirmed' => 'Natiyak mo na ang tirahang ito ng e-liham.',
	'usersignup-error-throttled-email' => 'Naku, humiling ka ng napakaraming mga e-liham ng pagtitiyak na ipapadala sa iyo ngayong araw na ito. Subukan ulit pagkaraan ng ilang saglit.',
	'usersignup-error-too-many-changes' => 'Umabot ka na sa pinaka mataas na hangganan para sa mga pagbabago ng e-liham ngayong araw na ito. Paki subukan ulit mamaya.',
	'usersignup-error-password-length' => 'Naku, napakahaba ng hudyat mo. Paki pumili ng isang hudyat na 50 ang mga panitik o mas mababa.',
	'usersignup-error-confirmed-user' => 'Mukhang natiyak mo na ang tirahan mo ng e-liham para sa $1!  Tingnan ang iyong [$2 balangkas ng katangian ng tagagamit].', # Fuzzy
	'usersignup-facebook-heading' => 'Tapusin na ang Pagpaparehistro',
	'usersignup-facebook-create-account' => 'Lumikha ng akawnt',
	'usersignup-facebook-email-tooltip' => 'Kung nais mong gumamit ng isang naiibang tirahan ng e-liham, mababago mo ito mamaya sa loob ng iyong mga Kanaisan.',
	'usersignup-facebook-have-an-account-heading' => 'Mayroon na bang akawnt?',
	'usersignup-facebook-have-an-account' => 'Sa halip ay ikabit ang iyong umiiral na pangalang pangtagagamit ng Wikia sa Facebook.',
	'usersignup-facebook-proxy-email' => 'Hindi nagpapakilalang e-liham ng Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Humiling ng isang bagong e-liham ng paniniyak',
	'usersignup-user-pref-confirmemail_send' => 'Ipadala uli ang aking e-liham ng pagtitiyak',
	'usersignup-user-pref-emailauthenticated' => 'Salamat! Natiyak na ang iyong e-liham noong $2 sa ganap na $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Tingnan ang iyong e-liham at pindutin ang kawing na pangtiyak upang matapos na ang pagbabago mo ng e-liham sa: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => "Naku po! Hindi natiyak ang iyong e-liham. Hindi aandar ang mga tampok ng e-liham hangga't hindi mo pa natitiyak ang iyong tirahan ng e-liham.",
	'usersignup-user-pref-reconfirmation-email-sent' => 'Halos marating na! Nagpadala kami ng isang bagong e-liham na pangtiyak na papunta sa $1. Tingnan ang iyong e-liham at lagitikin ang kawing upang matapos na ang pagtitiyak ng tirahan mo e-liham.',
	'usersignup-user-pref-noemailprefs' => 'Mukhang wala kaming tirahan ng e-liham para sa iyo. Paki magpasok ng isang tirahan ng e-liham sa itaas.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Naku po! Hindi natiyak ang e-liham mo. Pinadalhan ka namin ng isang e-liham, pindutin ang kawing na pangtiyak doon upang matiyak.',
	'usersignup-user-pref-confirmemail_noemail' => 'Mukhang wala kaming isang tirahan ng e-liham para sa iyo. Pumunta sa [[Special:Preferences|mga nais ng tagagamit]] upang makapagpasok ng isa.',
	'usersignup-confirm-page-title' => 'Tiyakin ang e-liham mo',
	'usersignup-confirm-email-resend-email' => 'Padalhan ulit ako ng e-liham ng pagtitiyak',
	'usersignup-confirm-email-change-email-content' => 'Nais kong gumamit ng isang naiibang tirahan ng elektronikong liham.',
	'usersignup-confirm-email-change-email' => 'Baguhin ang aking tirahan ng elektronikong liham',
	'usersignup-confirm-email-new-email-label' => 'Bagong e-liham',
	'usersignup-confirm-email-update' => 'Isapanahon',
	'usersignup-confirm-email-tooltip' => 'Nagpasok ka ba ng isang tirahan ng e-liham na hindi mo mapatototohanan, o nais mong gumamit ng isang ibang tirahan ng e-liham? Huwag mag-alala, gamitin ang kawing sa ibaba upang baguhin ang iyong tirahan ng e-liham at kumuha ng isang bagong e-liham na pangpagpapatotoo.',
	'usersignup-resend-email-heading-success' => 'Naipadala na ang bagong e-liham',
	'usersignup-resend-email-heading-failure' => 'Hindi muling naipadala ang e-liham',
	'usersignup-confirm-page-heading-confirmed-user' => 'Maligayang bati!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Natiyak ka na',
	'usersignup-confirmation-heading' => 'Kaunti na lang',
	'usersignup-confirmation-heading-email-resent' => 'Naipadala na ang bagong e-liham',
	'usersignup-confirmation-subheading' => 'Tingnan ang iyong e-liham',
	'usersignup-confirmation-email-sent' => "Nagpadala kami ng isang elektronikong liham kay '''$1'''.

Pindutin ang kawing ng pagpapatotoo sa loob ng iyong e-liham upang tapusin na ang paglikha ng iyong akawnt.",
	'usersignup-reconfirmation-email-sent' => 'Ang tirahan ng e-liham mo ay binago upang maging $1. Ipinadala namin sa iyo ang isang bagong e-liham ng pagtitiyak. Paki tiyakin ang bagong tirahan ng e-liham.',
	'usersignup-welcome-email-subject' => 'Maligayang pagdating sa Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Kumusta $USERNAME',
	'usersignup-welcome-email-heading' => 'Masaya ka naming tinatanggap nang mabuti sa Wikia at sa {{SITENAME}}! Narito ang ilang mga bagay na magagawa mo upang makapagsimula na.',
	'usersignup-welcome-email-edit-profile-heading' => 'Baguhin ang iyong balangkas ng katangian.',
	'usersignup-welcome-email-edit-profile-content' => 'Magdagdag ng isang litrato sa balangkas ng katangian at isang mangilan-ngilang madaliang mga katotohanan patungkol sa sarili mo sa iyong balangkas ng katangian sa {{SITENAME}} .',
	'usersignup-welcome-email-edit-profile-button' => 'Magpunta sa balangkas ng katangian',
	'usersignup-welcome-email-learn-basic-heading' => 'Alamin ang mga saligan.',
	'usersignup-welcome-email-learn-basic-content' => 'Kumuha ng mabilisang pampagkatuto hinggil sa mga saligan ng Wikia: kung paano magbago ng isang pahina, ng iyong balangkas ng katangian ng tagagamit, baguhiin ang iyong mga kanaisan, at marami pa.',
	'usersignup-welcome-email-learn-basic-button' => 'Tingnan at suriin ito',
	'usersignup-welcome-email-explore-wiki-heading' => 'Gumalugad ng marami pang mga wiki.',
	'usersignup-welcome-email-explore-wiki-content' => 'Mayroong libu-libong mga wiki sa Wikia, maghanap ng marami pang mga wiki na makakahumalingan mo sa pamamagitan ng pagpunta sa isa sa aming mga lunduyan: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Mga Larong Bidyo</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Pag-aaliw</a>, o <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Gawi sa Pamumuhay</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Pumunta sa wikia.com',
	'usersignup-welcome-email-content' => 'Nais ang marami pang kabatiran? Hanapin ang payo, mga sagot, at ang pamayanan ng Wikia roon sa a style="color:#2C85D5;" href="http://community.wikia.com">Lunduyan ng Pamayanan</a>. Maligayang pamamatnugot!',
	'usersignup-welcome-email-signature' => 'Ang Pangkat ng Wikia',
	'usersignup-welcome-email-body' => 'Kumusta $USERNAME,

Maligaya at mabuti ang aming pagtanggap sa iyo sa Wikia at sa {{SITENAME}}! Narito ang ilang mga bagay na magagawa mo upang makapagsimula na.

Baguhin ang iyong balangkas ng katangian.

Magdagdag ng isang litrato sa balangkas ng katangian at isang mangilan-ngilang mga katotohan na patungkol sa sarili mo sa iyong balangkas ng katangian ng {{SITENAME}}.

Magpunta sa $EDITPROFILEURL

Alamin ang mga saligan.

Kumuha ng mabilisang pampatuto hinggil sa mga saligan ng Wikia: paano magbago ng isang pahina, ang iyong balangkas-katangian ng tagagamit, ang pagbago sa mga kanaisan mo, at marami pa.

Tingnan at suriin ito ($LEARNBASICURL)

Gumalugad ng marami pang mga wiki.

Mayroong libu-libong mga wiki sa Wikia, maghanap ng marami pang mga wiki na makakawilihan mo sa pamamagitan ng pagpunta sa aming mga lunduyan: Mga Larong Bidyo (http://www.wikia.com/Video_Games), Paglilibang (http://www.wikia.com/Entertainment), o Estilo ng Pamumuhay (http://www.wikia.com/Lifestyle).

Pumunta sa $EXPLOREWIKISURL

Nais ang marami pang kabatiran? Hanapin ang payo, mga sagot, at ang pamayanan ng Wikia doon sa Lunduyan ng Pamayanan (http://www.community.wikia.com).
Maligayang pamamatnugot!

Ang Pangkat ng Wikia


___________________________________________

Upang masuri ang pinaka huling mga kaganapan sa Wikia, dalawin ang http://community.wikia.com
Nais tabanan kung anong mga e-liham ang tatanggapin mo? Magpunta sa: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Sumali na Ngayon sa Wikia',
	'usersignup-heading-byemail' => 'Lumikha ng isang akawnt para sa ibang tao',
	'usersignup-marketing-wikia' => 'Magsimulang makipagtulungan sa milyun-milyong mga tao magmula sa buong mundo na nagsama-sama upang ibahagi ang kanilang nalalaman at naiibigan.',
	'usersignup-marketing-login' => 'Isa nang tagagamit? [[Special:UserLogin|Lumagda]]',
	'usersignup-marketing-benefits' => 'Maging isang bahagi ng isang napakalaking bagay',
	'usersignup-marketing-community-heading' => 'Makipagtulungan',
	'usersignup-marketing-community' => 'Tumuklas at gumalugad ng mga paksang sumasaklaw mula sa mga larong bidyo hanggang sa mga pelikula at telebisyon. Makatagpo ng mga tao na may kahalintulad na mga kinagigiliwan at mga naiibigan.',
	'usersignup-marketing-global-heading' => 'Likhain',
	'usersignup-marketing-global' => 'Magsimula ng isang wiki. Magsimula sa maliit, umunlad nang malaki, na may pagtulong ng iba.',
	'usersignup-marketing-creativity-heading' => 'Maging orihinal',
	'usersignup-marketing-creativity' => 'Gamitin ang Wikia upang ipahayag ang iyong pagkamalikhain sa pamamagitan ng mga botohan at mga listahan ng pangunahing 10, mga litrato at mga galeriya ng bidyo, mga aplikasyon at marami pa.',
	'usersignup-createaccount-byemail' => 'Lumikha ng isang akawnt para sa ibang tao',
	'usersignup-error-captcha' => 'Ang ipinasok mong salita ay hindi tumugma sa salitang nasa loob ng kahon, subukan uli!', # Fuzzy
	'usersignup-account-creation-heading' => 'Tagumpay!',
	'usersignup-account-creation-subheading' => 'Nagpadala kami ng isang e-liham kay $1',
	'usersignup-account-creation-email-sent' => 'Sinimulan mo na ang proseso ng paglikha ng akawnt para kay $2. Pinadalhan namin sila ng isang e-liham doon sa $1 na mayroong isang pansamantalang hudyat at isang kawing ng pagtitiyak.

Kakailanganin ni $2 na lagitikin ang kawing sa loob ng e-liham na ipinadala namin sa kanila upang matiyak ang akawnt nila at baguhin ang kanilang pansamantalang hudyat upang matapos ang paglikha ng kanilang akawnt.

[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Lumikha ng marami pang mga akawnt] sa {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Isang akawnt ang nilikha para sa iyo doon sa Wikia!',
	'usersignup-account-creation-email-greeting' => 'Kumusta,',
	'usersignup-account-creation-email-content' => 'Isang akawnt ang nalikha para sa iyo roon sa {{SITENAME}}. Upang mapuntahan ang akawnt mo at baguhin ang iyong pansamantalang hudyat, pindutin ang kawing na nasa ibaba at lumagdang papasok sa pamamagitan ng pangalan ng tagagamit na "$USERNAME" at hudyat na "$NEWPASSWORD".

Paki lumagdang papasok doon sa <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Kung hindi ninais na likhain ang akawnt na ito, huwag mo na lamang pansinin ang e-liham na ito o makipag-ugnayan sa aming pangkat ng Suporta ng Pamayanan sa pamamagitan ng anumang mga pagtatanong.',
	'usersignup-account-creation-email-signature' => 'Ang Pangkat ng Wikia',
	'usersignup-account-creation-email-body' => 'Kumusta,

Isang akawnt ang nilikha para sa iyo roon sa {{SITENAME}}. Upang mapuntahan ang akawnt mo at baguhin ang iyong pansamantalang hudyat, pindutin ang kawing na nasa ibaba at lumagdang papasok sa pamamagitan ng pangalan ng tagagamit na "$2" at hudyat na "$3".

Paki lumagda roon sa {{fullurl:{{ns:special}}:UserLogin}}

Kung hindi mo ninais na malikha ang akawnt na ito, huwag na lang pansinin ang e-liham na ito o makipag-ugnayan sa pangkat ng Suporta ng Pamayanan sa pamamagitan ng anumang mga katanungan.

Ang Pangkat ng Wikia


___________________________________________

Upang matingnan ang pinaka huling mga kaganapan sa Wikia, dumalaw sa http://community.wikia.com
Gusto mong kontrolin kung anong mga e-liham ang tatanggapin mo? Pumunta sa: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => 'Nagkaroon ng isang suliranin sa pakikipag-ugnayan sa Facebook. Paki subukan ulit mamaya.',
);

/** Turkish (Türkçe)
 * @author Erdemaslancan
 * @author Incelemeelemani
 * @author Ömer Berkay
 */
$messages['tr'] = array(
	'usersignup-page-captcha-label' => 'İtiraz',
	'usersignup-welcome-email-explore-wiki-content' => 'Wikia\'da binlerce wiki bulunmaktadır, ilgilendiğiniz konu hakkında daha fazla wikiye ulaşmak için merkezi başlıkları kullanın: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Video Oyunları</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Eğlence</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Yaşam tarzı</a>.',
	'usersignup-marketing-creativity-heading' => 'Orijinal olmak',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'usersignup-page-captcha-label' => 'Blurry Word', # Fuzzy
	'usersignup-error-invalid-email' => 'Зинһар, дөрес электрон почта адресын кертегез.',
	'usersignup-facebook-create-account' => 'Хисап язмасы төзү',
	'usersignup-facebook-have-an-account-heading' => 'Сез инде теркәлдегезме?',
	'usersignup-confirm-email-change-email' => 'Электрон почта адресын үзгәртү',
	'usersignup-confirm-email-update' => 'Яңарту',
	'usersignup-welcome-email-signature' => 'Викия берләшмәсе',
	'usersignup-marketing-global-heading' => 'Төзегез',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Mykola Swarnyk
 * @author Ua2004
 * @author Wildream
 * @author Капитан Джон Шепард
 */
$messages['uk'] = array(
	'usersignup-page-title' => 'Приєднатися до Wikia',
	'usersignup-page-title-wikiamobile' => 'Створити обліковий запис',
	'usersignup-page-captcha-label' => 'Blurry Word', # Fuzzy
	'usersignup-error-username-length' => "На жаль, ім'я участника не може бути довшим за {{PLURAL:$1|один символ|$1 символів}",
	'usersignup-error-invalid-user' => "Недопустиме ім'я користувача. Будь ласка, спробуйте ще раз!",
	'usersignup-error-invalid-email' => 'Будь ласка введіть справжню e-mail адресу.',
	'usersignup-error-symbols-in-username' => "На жаль, ім'я користувача може містити лише букви і цифри.",
	'usersignup-error-empty-email' => 'Будь ласка, введіть вашу адресу електронної пошти.',
	'usersignup-error-empty-username' => 'Будь ласка, заповніть поле для імені користувача.',
	'usersignup-error-already-confirmed' => 'Ви вже підтвердили цю адресу електронної пошти.',
	'usersignup-error-throttled-email' => 'Вам було відправлено занадто багато листів з підтвердженням. Будь ласка, спробуйте ще раз, але трохи пізніше.',
	'usersignup-error-too-many-changes' => 'Досягнуто максимальної межі для спроб зміни електронної пошти на сьогодні. Будь ласка, повторіть спробу пізніше.',
	'usersignup-error-password-length' => 'На жаль, ваш пароль занадто довгий. Будь ласка, виберіть пароль, який складається з 50 символів або менше.',
	'usersignup-error-confirmed-user' => 'Схоже, що ви вже підтвердили свою електронну адресу для $1! Будь ласка, перевірте ваш [$2 профіль користувача].', # Fuzzy
	'usersignup-facebook-heading' => 'Завершити реестрацію.',
	'usersignup-facebook-create-account' => 'Створити обліковий запис',
	'usersignup-facebook-email-tooltip' => 'Якщо ви захочете використовувати іншу електронну адресу, ви зможете змінити її в налаштуваннях пізніше.',
	'usersignup-facebook-have-an-account-heading' => 'Ви вже зареєстровані?',
	'usersignup-facebook-have-an-account' => "Підключіть уже існуюче ім'я користувача до мережі Facebook",
	'usersignup-facebook-proxy-email' => 'Анонімна електронна пошта Facebook',
	'usersignup-user-pref-emailconfirmlink' => 'Надіслати запит про новий лист підтвердження електронної пошти',
	'usersignup-user-pref-confirmemail_send' => 'Надіслати мені підтвердження електронної пошти',
	'usersignup-user-pref-emailauthenticated' => 'Дякуємо! Ваша адреса електронної пошти була підтверджена $2 в $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Перевірте вашу адресу електронної пошти і натисніть на посилання, щоб підтвердити зміну своєї електронної пошти на $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => 'Адресу Вашої електронної пошти не було підтверджено. Функції електронної пошти не будуть працювати, доки ви не підтвердите її.',
	'usersignup-user-pref-reconfirmation-email-sent' => 'Ми надіслали вам листа з підтвердженням на $1. Перевірте свою електронну пошту і натисніть на посилання, щоб закінчити підтверждення вашої електронної пошти.',
	'usersignup-user-pref-noemailprefs' => 'Схоже, у нас немає вашої адреси електронної пошти. Будь ласка, введіть вашу адресу електронної пошти вище.',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => 'Вашу адресу електронної пошти не було підтверджено. Ми вже надіслали вам повідомлення, в якому треба натиснути на посилання для підтвердження.',
	'usersignup-user-pref-confirmemail_noemail' => 'Схоже, у нас немає адреси електронної пошти для вас. Перейдіть на сторінку [[Special:Preferences|ваших налаштувань]] щоб підтвердити її.',
	'usersignup-confirm-page-title' => 'Підтвердити вашу адресу електронної пошти',
	'usersignup-confirm-page-title-wikiamobile' => 'Перевірте вашу електронну пошту',
	'usersignup-confirm-email-resend-email' => 'Надіслати мені ще один лист з підтвердженням електронною поштою',
	'usersignup-confirm-email-change-email-content' => 'Я хочу використовувати іншу адресу електронної пошти.',
	'usersignup-confirm-email-change-email' => 'Змінити мою адресу електронної пошти',
	'usersignup-confirm-email-new-email-label' => 'Новий email',
	'usersignup-confirm-email-update' => 'Оновити',
	'usersignup-confirm-email-tooltip' => 'Вы ввели адресу електронної пошти, яку не можете підтвердити, або хочете використовувати іншу електронну адресу? Не хвилюйтеся, натисніть на посилання нижче, щоб змінити свою адресу електронної пошти і отримати нове підтвердження.',
	'usersignup-resend-email-heading-success' => 'Нове повідомлення надіслано.',
	'usersignup-resend-email-heading-failure' => 'Повторне повідомлення не надіслано.',
	'usersignup-confirm-page-heading-confirmed-user' => 'Вітаємо!',
	'usersignup-confirm-page-subheading-confirmed-user' => 'Ви вже підтвердили',
	'usersignup-confirmation-heading' => 'Майже готово',
	'usersignup-confirmation-heading-wikiamobile' => 'Перевірте вашу електронну пошту',
	'usersignup-confirmation-heading-email-resent' => 'Нове повідомлення надіслано.',
	'usersignup-confirmation-subheading' => 'Перевірте вашу електронну пошту',
	'usersignup-confirmation-email-sent' => "Ми направили листа до '''$1'''.
Натисніть на посилання для підтвердження вашої електронної пошти, щоб завершити створення облікового запису.",
	'usersignup-confirmation-email-sent-wikiamobile' => "Ми надіслали електронного листа на '''$1'''.

Натисніть посилання в листі, щоб підтвердити вашу електронну адресу та завершити створення облікового запису. Дякуємо!",
	'usersignup-reconfirmation-email-sent' => 'Вашу адресу електронної пошти було змінено на $1. Ми відправили вам нового листа з підтвердженням електронною поштою. Будь ласка, підтвердіть нову адресу електронної пошти.',
	'usersignup-welcome-email-subject' => 'Ласкаво просимо на Вікію, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Привіт, $USERNAME!',
	'usersignup-welcome-email-heading' => "Ми раді вітати вас на Вікія та {{ім'я сайту}}! Ось декілька речей, які ви можете зробити, щоб почати роботу.",
	'usersignup-welcome-email-edit-profile-heading' => 'Заповніть ваш профіль.',
	'usersignup-welcome-email-edit-profile-content' => 'Додайте фото та кілька слів про себе у своєму профілі на {{SITENAME}}.',
	'usersignup-welcome-email-edit-profile-button' => 'Перейти до профілю',
	'usersignup-welcome-email-learn-basic-heading' => 'Ознайомтеся з основами.',
	'usersignup-welcome-email-learn-basic-content' => 'Перегляньте швидкий підручник з основ Вікія: як редагувати сторінки, ваш профіль користувача, змінювати особисті налаштування тощо.',
	'usersignup-welcome-email-learn-basic-button' => 'Перейти',
	'usersignup-welcome-email-explore-wiki-heading' => 'Перегляньте інші вікі.',
	'usersignup-welcome-email-explore-wiki-content' => 'На Вікія знаходяться тисячі вікій, знайдіть інші вікії, які, можливо, зацікавлять вас: <a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">Відеоігри</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">Кіно і Серіали</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">Стиль життя</a>.',
	'usersignup-welcome-email-explore-wiki-button' => 'Перейти до wikia.com',
	'usersignup-welcome-email-content' => 'Хочете отримати більше інформації? Знайдіть консультації, відповіді та спільноту Вікія у <a style="color:#2C85D5;" href="http://community.wikia.com">Центрі спільноти</a>. Приємного редагування!',
	'usersignup-welcome-email-signature' => 'Команда Вікія',
	'usersignup-welcome-email-body' => 'Привіт, $USERNAME

Ми раді вітати вас на Вікія та на {{SITENAME}}! Ось декілька порад, які допоможуть вам почати.

Відредагуйте свій профіль.

Додайте у свій профіль на {{SITENAME}} зображення і декілька фактів про себе.

Перейти до $EDITPROFILEURL

Вивчіть основи.

Перегляньте основи роботи з Вікія: як редагувати сторінки, ваш профіль користувача, змінювати особисті налаштування тощо.

Перейти к ($LEARNBASICURL)

Досліджуйте інші вікії.

На Вікія знаходяться тисячі вікій, знайдіть інші вікії, які, можливо, зацікавлять вас: Відеоігри (http://www.wikia.com/Video_Games), Кіно і серіали (http://www.wikia.com/Entertainment) або Захоплення (http://www.wikia.com/Lifestyle).

Перейти до $EXPLOREWIKISURL

Потрібна додаткова інформація? На Центральній Вікі (http://www.community.wikia.com) можна знайти поради, відповіді на питання та інших учасників спільноти Вікія. Щасливого редагування!

Команда Вікія


___________________________________________

Щоб перевірити останні події на Вікія, відвідайте http://community.wikia.com
Не бажаєте отримувати листів від Вікія? Це можна змінити тут: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => 'Приєднатися до Вікія сьогодні',
	'usersignup-heading-byemail' => 'Створити обліковий запис для когось іншого',
	'usersignup-marketing-wikia' => 'Почніть співпрацю з мільйонам людей з усього світу, які зібралися разом, щоб робити те, що вони знають і люблять.',
	'usersignup-marketing-login' => 'Вже користувач? [[Special:UserLogin|Ввійти]]',
	'usersignup-marketing-benefits' => 'Будьте частиною чогось величезного',
	'usersignup-marketing-community-heading' => 'Співпрацюйте',
	'usersignup-marketing-community' => 'Відкрийте для себе і вивчайте різні теми, починаючи від відео-ігор, кіно і телебачення. Зустрічайте людей зі схожими інтересами і пристрастями.',
	'usersignup-marketing-global-heading' => 'Створити',
	'usersignup-marketing-global' => 'Розпочніть вікі. Починайте з малого, виплекайте велике за допомогою інших людей.',
	'usersignup-marketing-creativity-heading' => 'Будьте оригінальним',
	'usersignup-marketing-creativity' => 'Використовуйте Wikia, щоб висловити свій творчий потенціал за допомогою опитувань і рейтингових списків, фото та відео галерей, програми та багато іншого.',
	'usersignup-createaccount-byemail' => 'Створити обліковий запис для когось іншого',
	'usersignup-error-captcha' => 'Введене вами слово не збігається з словом у вікно, спробуйте ще раз!', # Fuzzy
	'usersignup-account-creation-heading' => 'Успіх!',
	'usersignup-account-creation-subheading' => 'Ми відправили лист на $1',
	'usersignup-account-creation-email-sent' => 'Ви почали процес створення облікового запису $2. Ми відправили вам лист на $1 з тимчасовим паролем та посиланням для підтвердження.


$2, вам потрібно натиснути на посилання у цьому листі, щоб підтвердити свій обліковий запис та змінити тимчавий пароль на інший для завершення створення облікового запису.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Створити інший обліковий запис] на {{SITENAME}}',
	'usersignup-account-creation-email-subject' => 'Обліковий запис створено для вас на Вікія!',
	'usersignup-account-creation-email-greeting' => 'Привіт,',
	'usersignup-account-creation-email-content' => 'Обліковий запис на {{SITENAME}} створений. Для доступу до облікового запису та зміни тимчасового паролю, натисніть на посилання нижче і введіть своє ім\'я користувача "$USERNAME" і пароль "$NEWPASSWORD".

Будь ласка, перейдіть до <a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

Якщо ви не хочете, щоб цей обліковий запис був створений, то ви можете знехтувати цим повідомленням або зв\'язатися з нашою командою підтримки спільноти з будь-якого питання.',
	'usersignup-account-creation-email-signature' => 'Команда Вікія',
	'usersignup-account-creation-email-body' => 'Привіт,

Обліковий запис на {{SITENAME}} створено. Для доступу до облікового запису та зміни тимчасового паролю натисніть на посилання нижче і введіть своє ім\'я учасника "$2" та пароль "$3".

Будь ласка, перейдіть до {{fullurl:{{ns:special}}:UserLogin}}

Якщо ви не хочете, щоб цей обліковий запис було створено, ви можете знехтувати цим повідомленням або зв\'язатися з нашою командою підтримки спільноти з будь-якого питання.

Команда Вікія


___________________________________________

Для перевірки останніх подій на Вікія відвідайте http://community.wikia.com
Хочете налаштувати отримання розсилки листів? Перейдіть на {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => "Сталася помилка з'єднання з Facebook. Будь ласка, спробуйте ще раз пізніше.",
	'usersignup-facebook-signup-header' => 'Створити новий обліковий запис?',
	'usersignup-facebook-login-header' => 'Ви вже зареєстровані?',
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author KhangND
 * @author Rémy Lee
 */
$messages['vi'] = array(
	'usersignup-page-title' => 'Join Fandom',
	'usersignup-page-title-wikiamobile' => 'Create account',
	'usersignup-page-captcha-label' => 'Challenge',
	'usersignup-error-username-length' => "Oops, your username can't be more than {{PLURAL:$1|one character|$1 characters}}.",
	'usersignup-error-invalid-user' => 'Invalid user. Please login first.',
	'usersignup-error-invalid-email' => 'Please enter a valid email address.',
	'usersignup-error-symbols-in-username' => 'Oops, your username can only contain letters and numbers.',
	'usersignup-error-empty-email' => 'Oops, please fill in your email address.',
	'usersignup-error-empty-username' => 'Oops, please fill in the username field.',
	'usersignup-error-already-confirmed' => "You've already confirmed this email address.",
	'usersignup-error-throttled-email' => "Oops, you've requested too many confirmation emails be sent to you today. Try again in a little while.",
	'usersignup-error-too-many-changes' => "You've reached the maximum limit for email changes today. Please try again later.",
	'usersignup-error-password-length' => "Oops, your password is too long. Please choose a password that's 50 characters or less.",
	'usersignup-error-confirmed-user' => "Looks like you've already confirmed your email address for $1!  Check out your [$2 user profile].",
	'usersignup-facebook-heading' => 'Finish Signing Up',
	'usersignup-facebook-create-account' => 'Create account',
	'usersignup-facebook-email-tooltip' => "If you'd like to use a different email address you can change it later in your Preferences.",
	'usersignup-facebook-have-an-account-heading' => 'Already have an account?',
	'usersignup-facebook-have-an-account' => 'Connect your existing Fandom username with Facebook instead.',
	'usersignup-facebook-proxy-email' => 'Anonymous Facebook email',
	'usersignup-user-pref-emailconfirmlink' => 'Request a new confirmation email',
	'usersignup-user-pref-confirmemail_send' => 'Resend my confirmation email',
	'usersignup-user-pref-emailauthenticated' => 'Thanks! Your email was confirmed on $2 at $3.',
	'usersignup-user-pref-emailnotauthenticated' => 'Check your email and click the confirmation link to finish changing your email to: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => "Oh, no! Your email is unconfirmed. Email features won't work until you confirm your email address.",
	'usersignup-user-pref-reconfirmation-email-sent' => "Almost there! We've sent a new confirmation email to $1. Check your email and click on the link to finish confirming your email address.",
	'usersignup-user-pref-noemailprefs' => "Looks like we don't have an email address for you. Please enter an email address above.",
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => "Oh, no! Your email is unconfirmed. We've sent you an email, click the confirmation link there to confirm.",
	'usersignup-user-pref-confirmemail_noemail' => "Looks like we don't have an email address for you. Go to [[Special:Preferences|user preferences]] to enter one.",
	'usersignup-confirm-page-title' => 'Confirm your email',
	'usersignup-confirm-page-title-wikiamobile' => 'Check your email',
	'usersignup-confirm-email-resend-email' => 'Send me another confirmation email',
	'usersignup-confirm-email-change-email-content' => 'I want to use a different email address.',
	'usersignup-confirm-email-change-email' => 'Change my email address',
	'usersignup-confirm-email-new-email-label' => 'New email',
	'usersignup-confirm-email-update' => 'Update',
	'usersignup-confirm-email-tooltip' => "Did you enter an email address that you can't confirm, or do you want to use a different email address? Don't worry, use the link below to change your email address and get a new confirmation email.",
	'usersignup-resend-email-heading-success' => 'New email sent',
	'usersignup-resend-email-heading-failure' => 'Email not re-sent',
	'usersignup-confirm-page-heading-confirmed-user' => 'Congrats!',
	'usersignup-confirm-page-subheading-confirmed-user' => "You're already confirmed",
	'usersignup-confirmation-heading' => 'Almost there',
	'usersignup-confirmation-heading-wikiamobile' => 'Check your email',
	'usersignup-confirmation-heading-email-resent' => 'New email sent',
	'usersignup-confirmation-subheading' => 'Check your email',
	'usersignup-confirmation-email-sent' => "We sent an email to '''$1'''.

Click the confirmation link in your email to finish creating your account.",
	'usersignup-confirmation-email-sent-wikiamobile' => "We sent an email to '''$1'''.

Click the confirmation link in your email to finish creating your account. Thanks!",
	'usersignup-reconfirmation-email-sent' => "Your email address has been changed to $1. We've sent you a new confirmation email. Please confirm the new email address.",
	'usersignup-welcome-email-subject' => 'Welcome to Wikia, $USERNAME!',
	'usersignup-welcome-email-greeting' => 'Hi $USERNAME',
	'usersignup-welcome-email-heading' => "We're happy to welcome you to Wikia and {{SITENAME}}! Here are some things you can do to get started.",
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
	'usersignup-heading' => 'Join Fandom Today',
	'usersignup-heading-byemail' => 'Create an account for someone else',
	'usersignup-marketing-wikia' => 'Start collaborating with millions of people from around the world who come together to share what they know and love.',
	'usersignup-marketing-login' => 'Already a user? [[Special:UserLogin|Log in]]',
	'usersignup-marketing-benefits' => 'Be a part of something huge',
	'usersignup-marketing-community-heading' => 'Collaborate',
	'usersignup-marketing-community' => 'Discover and explore subjects ranging from video games to movies and tv. Meet people with similar interests and passions.',
	'usersignup-marketing-global-heading' => 'Create',
	'usersignup-marketing-global' => 'Start a wiki. Start small, grow big, with the help of others.',
	'usersignup-marketing-creativity-heading' => 'Be original',
	'usersignup-marketing-creativity' => 'Use Fandom to express your creativity with photos, video galleries, apps and discussions.',
	'usersignup-createaccount-byemail' => 'Create an account for someone else',
	'usersignup-error-captcha' => 'Đáp án trả lời thất bại, vui lòng thử lại!',
	'usersignup-account-creation-heading' => 'Success!',
	'usersignup-account-creation-subheading' => "We've sent an email to $1",
	'usersignup-account-creation-email-sent' => "You've started the account creation process for $2. We've sent them an email at $1 with a temporary password and a confirmation link.


$2 will need to click on the link in the email we sent them to confirm their account and change their temporary password to finish creating their account.


[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} Create more accounts] on {{SITENAME}}",
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
	'usersignup-facebook-problem' => 'There was a problem communicating with Facebook. Please try again later.',
	'usersignup-facebook-signup-header' => 'Creating a new account?',
	'usersignup-facebook-login-header' => 'Already have an account?',
);

/** Walloon (walon)
 * @author Lucyin
 */
$messages['wa'] = array(
	'usersignup-page-title-wikiamobile' => '
Ahiver on novea conte',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Liuxinyu970226
 * @author Sam Wang
 * @author Yfdyh000
 * @author 凡人丶
 */
$messages['zh-hans'] = array(
	'usersignup-page-title' => '加入Wikia',
	'usersignup-page-title-wikiamobile' => '创建帐户',
	'usersignup-page-captcha-label' => '挑战',
	'usersignup-error-username-length' => '很抱歉，您的用户名不能超过 {{PLURAL:$1|1个字符|$1个字符}}.',
	'usersignup-error-invalid-user' => '无效用户。请尝试登录。',
	'usersignup-error-invalid-email' => '请输入一个有效的电子邮件地址。',
	'usersignup-error-symbols-in-username' => '很抱歉，您的用户名只能包含文字和数字。',
	'usersignup-error-empty-email' => '很抱歉，请填写您的电子邮件地址。',
	'usersignup-error-empty-username' => '很抱歉，请填写用户名。',
	'usersignup-error-already-confirmed' => '你已经确认过此电子邮件地址。',
	'usersignup-error-throttled-email' => '很抱歉，你今天申请发送了过多的确认电子邮件。请稍等片刻重新尝试。',
	'usersignup-error-too-many-changes' => '您今天已经达到电子邮件更改的次数限制。请稍后再试。',
	'usersignup-error-password-length' => '很抱歉，您的密码太长。请选择50个字符以内的密码。',
	'usersignup-error-confirmed-user' => '您似乎已经确认了$1为电子邮件地址！请查看您的[$2 个人帐户]。',
	'usersignup-facebook-heading' => '完成注册',
	'usersignup-facebook-create-account' => '创建帐户',
	'usersignup-facebook-email-tooltip' => '如果您想要使用一个不同的电子邮件地址，可以稍后在个人设置中进行更改。',
	'usersignup-facebook-have-an-account-heading' => '已经有一个帐户了？',
	'usersignup-facebook-have-an-account' => '将您现有的Wikia帐户和Facebook进行连接。',
	'usersignup-facebook-proxy-email' => '匿名的Facebook电子邮件',
	'usersignup-user-pref-emailconfirmlink' => '要求发送新的电子邮件进行确认',
	'usersignup-user-pref-confirmemail_send' => '重新发送电子邮件进行确认',
	'usersignup-user-pref-emailauthenticated' => '谢谢！您的电子邮件于$2 $3进行确认。',
	'usersignup-user-pref-emailnotauthenticated' => '检查您的电子邮件并点击链接以确认完成您的电子邮件更改至: $1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => '很抱歉！您的电子邮件还未经确认。电子邮件功能在您确认之前不可用。',
	'usersignup-user-pref-reconfirmation-email-sent' => '我们已经发送了一封新的确认电子邮件至$1。请登录您的邮箱并点击链接完成电子邮件地址的确认。',
	'usersignup-user-pref-noemailprefs' => '我们似乎并没有您的邮件地址。请在上方输入您的邮件地址。',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => '很抱歉！您的电子邮件未经确认。请查看您的电子邮箱，点击相关链接进行确认。',
	'usersignup-user-pref-confirmemail_noemail' => '我们似乎并没有您的电子邮件地址。请访问[[Special:Preferences|用户设定]]输入一个电子邮箱。',
	'usersignup-confirm-page-title' => '确认您的电子邮件地址',
	'usersignup-confirm-page-title-wikiamobile' => '请检查您的电子邮件',
	'usersignup-confirm-email-resend-email' => '重新发送电子邮件进行确认',
	'usersignup-confirm-email-change-email-content' => '我想使用一个不同的电子邮件地址。',
	'usersignup-confirm-email-change-email' => '更改我的电子邮件地址',
	'usersignup-confirm-email-new-email-label' => '新的电子邮件',
	'usersignup-confirm-email-update' => '更新',
	'usersignup-confirm-email-tooltip' => '您输入了某个无法确认的邮件地址，或者想要使用另一个不同的电子邮件地址？不用担心，使用下面的链接来更换您的电子邮箱以获得新的确认电子邮件。',
	'usersignup-resend-email-heading-success' => '新的电子邮件已经发送',
	'usersignup-resend-email-heading-failure' => '电子邮件没有被重新发送',
	'usersignup-confirm-page-heading-confirmed-user' => '恭喜！',
	'usersignup-confirm-page-subheading-confirmed-user' => '您已经确认',
	'usersignup-confirmation-heading' => '马上就好',
	'usersignup-confirmation-heading-wikiamobile' => '查看您的电子邮箱',
	'usersignup-confirmation-heading-email-resent' => '新的电子邮件已经发送',
	'usersignup-confirmation-subheading' => '请检查您的电子邮件',
	'usersignup-confirmation-email-sent' => "我们已经发送电子邮件至''$1''。

请点击您的电子邮箱中的链接地址进行确认，完成帐户注册。",
	'usersignup-confirmation-email-sent-wikiamobile' => "我们已经发送电子邮件至''$1''。

请点击您的电子邮箱中的链接地址进行确认，完成帐户注册。谢谢。",
	'usersignup-reconfirmation-email-sent' => '您的邮件地址已经变更为$1。我们已经发送给您一封确认邮件。请登录您的邮箱点击链接进行确认。',
	'usersignup-welcome-email-subject' => '欢迎来到Wikia，$USERNAME！',
	'usersignup-welcome-email-greeting' => '您好$USERNAME',
	'usersignup-welcome-email-heading' => '我们很高兴您加入Wikia{{SITENAME}}社区！在开始之前，请查看以下相关信息。',
	'usersignup-welcome-email-edit-profile-heading' => '编辑您的个人档案',
	'usersignup-welcome-email-edit-profile-content' => '添加用户照片，并在{{SITENAME}}社区上创建您的个人档案',
	'usersignup-welcome-email-edit-profile-button' => '访问您的个人档案',
	'usersignup-welcome-email-learn-basic-heading' => '从基础开始。',
	'usersignup-welcome-email-learn-basic-content' => '开始学习如何使用Wikia：编辑文章页，个人档案设置，个人设定，等等。',
	'usersignup-welcome-email-learn-basic-button' => '看一下',
	'usersignup-welcome-email-explore-wiki-heading' => '浏览更多维基社区。',
	'usersignup-welcome-email-explore-wiki-content' => '在Wikia上有成千上万的主题社区，您可以通过登录各大主题中心访问更多的维基社区：<a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">游戏</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">娱乐</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">生活方式</a>.',
	'usersignup-welcome-email-explore-wiki-button' => '访问wikia.com',
	'usersignup-welcome-email-content' => '希望了解更多信息？访问<a style="color:#2C85D5;" href="http://zh.community.wikia.com">中文社区中心</a>查找更多建议，帮助，编辑课程，以及维基社区！',
	'usersignup-welcome-email-signature' => 'Wikia团队',
	'usersignup-welcome-email-body' => '您好$USERNAME,

我们很高兴您加入Wikia{{SITENAME}}社区！您现在可以开始做一些准备工作啦。

编辑您的帐户主页。

添加用户照片，并在{{SITENAME}}社区上创建您的个人档案。

访问$EDITPROFILEURL

从基础开始。

学习如何使用Wikia：编辑文章页，个人档案设置，个人设定，等等。

点击($LEARNBASICURL)

查看更多维基社区。

在Wikia上有成千上万的主题社区，您可以通过登录各大主题中心访问更多的维基社区：游戏(http://www.wikia.com/Video_Games), 娱乐(http://www.wikia.com/Entertainment), 或者生活方式(http://www.wikia.com/Lifestyle)。

访问$EXPLOREWIKISURL

希望了解更多信息？访问中文社区中心(http://zh.community.wikia.com)查找更多建议，帮助，编辑课程，以及维基社区！

Wikia团队

___________________________________________
想了解Wikia最近发生了什么？请访问http://zh.community.wikia.com
点击以下链接操作邮件获取方式: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => '加入Wikia',
	'usersignup-heading-byemail' => '为其他人创建帐户',
	'usersignup-marketing-wikia' => '开始和全球成千上万的在线用户共同分享所知所感。',
	'usersignup-marketing-login' => '已经是Wikia的用户？ [[Special:UserLogin|登录]]',
	'usersignup-marketing-benefits' => '赶快加入我们的社区吧',
	'usersignup-marketing-community-heading' => '合作',
	'usersignup-marketing-community' => '查看和发现更多的视频游戏、电影以及电视剧维基社区，和具有共同兴趣爱好的人成为朋友！',
	'usersignup-marketing-global-heading' => '创建',
	'usersignup-marketing-global' => '开始一个维基。从基础开始，通过所有人共同努力不断成长。',
	'usersignup-marketing-creativity-heading' => '原创性',
	'usersignup-marketing-creativity' => '使用Wikia的投票，视频图片册，手机应用以及其他功能来实现你的创意。',
	'usersignup-createaccount-byemail' => '为其他人创建帐户',
	'usersignup-error-captcha' => '答案输入错误，请重新尝试！',
	'usersignup-account-creation-heading' => '操作成功！',
	'usersignup-account-creation-subheading' => '我们已经发送邮件到$1',
	'usersignup-account-creation-email-sent' => '您正在创建帐户$2。我们已经将临时密码发送到电子邮件$1。

$2需要点击相关链接完成帐户注册，并且需要更改临时密码。

在{{SITENAME}}上[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} 创建更多帐户]',
	'usersignup-account-creation-email-subject' => '您的帐户已经在Wikia上创建！',
	'usersignup-account-creation-email-greeting' => '您好，',
	'usersignup-account-creation-email-content' => '您已经在{{SITENAME}}社区上创建了帐户。点击以下链接进入到您的帐户并且更改临时密码。您的帐户名为"$USERNAME"，密码为"$NEWPASSWORD"。

登录帐户请点击<a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}</a>

如果您不想创建这个帐户，请忽略这封邮件或者联系我们的社区支持部门团队。',
	'usersignup-account-creation-email-signature' => 'Wikia团队',
	'usersignup-account-creation-email-body' => '您好，

您已经在{{SITENAME}}社区上创建了帐户。点击以下链接进入到您的帐户并且更改临时密码。您的帐户名为"$2"，密码为"$3"。

点击{{fullurl:{{ns:special}}:UserLogin}}进行帐户登录。

如果您不想创建这个帐户，请忽略这封邮件或者联系我们的社区支持部门团队。

Wikia团队
___________________________________________

想了解Wikia最近发生了什么？请访问http://zh.community.wikia.com
点击以下链接操作邮件获取方式: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => '链接Facebook出现问题。请稍后再试。',
	'usersignup-facebook-signup-header' => '创建帐户',
	'usersignup-facebook-login-header' => '已经拥有一个帐户了？',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Cwlin0416
 * @author Ffaarr
 * @author LNDDYL
 * @author Simon Shek
 */
$messages['zh-hant'] = array(
	'usersignup-page-title' => '加入 Wikia',
	'usersignup-page-captcha-label' => '模糊單詞', # Fuzzy
	'usersignup-error-username-length' => '哎呀，您的使用者名稱不能超過 {{PLURAL:$1|一個字符| $1 字元}}。',
	'usersignup-error-invalid-user' => '無效使用者，請先登入。',
	'usersignup-error-invalid-email' => '請輸入有效的電子郵件地址。',
	'usersignup-error-symbols-in-username' => '哎呀，您的使用者名稱只能包含字母與數字。',
	'usersignup-error-empty-email' => '哎呀，請填寫您的電子郵件地址。',
	'usersignup-error-empty-username' => '哎呀，請填寫使用者名稱。',
	'usersignup-error-already-confirmed' => '你已經確認該電子郵件地址。',
	'usersignup-confirm-email-new-email-label' => '新電子郵件',
	'usersignup-confirm-email-update' => '更新',
	'usersignup-resend-email-heading-failure' => '電子郵件未重新傳送',
	'usersignup-confirm-page-heading-confirmed-user' => '恭喜 ！',
	'usersignup-confirmation-heading' => '快完成了。',
	'usersignup-confirmation-heading-email-resent' => '新電子郵件已傳送',
	'usersignup-confirmation-subheading' => '請檢查您的電子郵件',
	'usersignup-marketing-global-heading' => '建立',
);

/** Chinese (Taiwan) (中文（台灣）‎)
 */
$messages['zh-tw'] = array(
	'usersignup-page-title' => '加入Wikia',
	'usersignup-page-title-wikiamobile' => '創建帳戶',
	'usersignup-page-captcha-label' => '問題',
	'usersignup-error-username-length' => '很抱歉，您的用戶名不能超過 {{PLURAL:$1|1個字符|$1個字符}}.',
	'usersignup-error-invalid-user' => '無效的用戶。請先登入。',
	'usersignup-error-invalid-email' => '請輸入一個有效的電子信箱。',
	'usersignup-error-symbols-in-username' => '很抱歉，您的用戶名只能包含文字和數字。',
	'usersignup-error-empty-email' => '抱歉，請填寫您的電子信箱。',
	'usersignup-error-empty-username' => '抱歉，請填寫用戶名稱。',
	'usersignup-error-already-confirmed' => '您已經認證過此電子信箱。',
	'usersignup-error-throttled-email' => '很抱歉，你今天申請發送了過多次的認證電子郵件。请稍後再重新嘗試。',
	'usersignup-error-too-many-changes' => '您今天已經達到電子郵件更改的次數上限。請稍後再試。',
	'usersignup-error-password-length' => '很抱歉，您的密碼太長。請選擇50個字符以内的密碼。',
	'usersignup-error-confirmed-user' => '您似乎已經認證了電子郵件地址為$1！ 請查看您的[$2 個人帳戶]。',
	'usersignup-facebook-heading' => '完成註冊',
	'usersignup-facebook-create-account' => '創建帳戶',
	'usersignup-facebook-email-tooltip' => '如果您想要使用另一個電子郵件地址，可以稍後在您的用戶設定中進行更改。',
	'usersignup-facebook-have-an-account-heading' => '已經有一個帳戶了？',
	'usersignup-facebook-have-an-account' => '選擇將您已有的Wikia帳戶與Facebook進行連結',
	'usersignup-facebook-proxy-email' => '匿名的Facebook電子信箱地址',
	'usersignup-user-pref-emailconfirmlink' => '申請新的電子信箱認證',
	'usersignup-user-pref-confirmemail_send' => '重新發送我的電子信箱認證',
	'usersignup-user-pref-emailauthenticated' => '謝謝！您的電子信箱於$2 $3進行認證。',
	'usersignup-user-pref-emailnotauthenticated' => '檢查電子郵件並點擊確認連結來完成將電子信箱更改至：$1',
	'usersignup-user-pref-unconfirmed-emailnotauthenticated' => '很抱歉！您的電子信箱還未經過認證。在認證之前不能使用電子郵件功能。',
	'usersignup-user-pref-reconfirmation-email-sent' => '快完成了！我們已發送了一封新的認證電子郵件到 $1。檢查您的郵箱並點擊連結以完成電子郵箱的認證。',
	'usersignup-user-pref-noemailprefs' => '我們似乎並沒有您的電子郵件地址。請在上面輸入您的郵件地址。',
	'usersignup-confirm-email-unconfirmed-emailnotauthenticated' => '很抱歉！您的電子信箱未經認證。我們已寄出認證信，請查看並點擊連結已完成認證。',
	'usersignup-user-pref-confirmemail_noemail' => '我們似乎沒有您的電子郵件地址，請進入 [[Special:Preferences|用戶設定]]輸入一個電子信箱。',
	'usersignup-confirm-page-title' => '認證您的電子信箱',
	'usersignup-confirm-page-title-wikiamobile' => '請檢查您的電子郵件',
	'usersignup-confirm-email-resend-email' => '重新發送認證電子郵件',
	'usersignup-confirm-email-change-email-content' => '我想使用另一個電子郵件地址。',
	'usersignup-confirm-email-change-email' => '更改我的電子郵件地址',
	'usersignup-confirm-email-new-email-label' => '新的電子郵件',
	'usersignup-confirm-email-update' => '更新',
	'usersignup-confirm-email-tooltip' => '您輸入了某個無法認證的電子信箱，或是想要用另一個電子信箱嗎？別擔心，使用以下的連結更改你的電子信箱，並獲得新的認證信件。',
	'usersignup-resend-email-heading-success' => '新的電子郵件已寄出',
	'usersignup-resend-email-heading-failure' => '電子郵件尚未重新寄出',
	'usersignup-confirm-page-heading-confirmed-user' => '恭喜！',
	'usersignup-confirm-page-subheading-confirmed-user' => '您已經完成認證',
	'usersignup-confirmation-heading' => '快好了',
	'usersignup-confirmation-heading-wikiamobile' => '查看您的電子信箱',
	'usersignup-confirmation-heading-email-resent' => '新的電子郵件已寄出',
	'usersignup-confirmation-subheading' => '請檢查您的電子郵件',
	'usersignup-confirmation-email-sent' => "我們已發送電子郵件至''$1''。

請點擊郵件中的連結進行認證，以完成帳戶註冊。",
	'usersignup-confirmation-email-sent-wikiamobile' => "我們已發送電子郵件至''$1''。

請點擊郵件中的連結進行認證，以完成帳戶註冊。謝謝！",
	'usersignup-reconfirmation-email-sent' => '您的郵件地址已經變更為$1。我們已發送一封認證信給您。請認證這個新的電子信箱。',
	'usersignup-welcome-email-subject' => '歡迎來到Wikia，$USERNAME！',
	'usersignup-welcome-email-greeting' => '您好$USERNAME',
	'usersignup-welcome-email-heading' => '我們很高興您加入Wikia{{SITENAME}}社區！您可以從以下幾點開始。',
	'usersignup-welcome-email-edit-profile-heading' => '編輯您的檔案。',
	'usersignup-welcome-email-edit-profile-content' => '添加用戶照片，並在{{SITENAME}}中創建您的個人檔案。',
	'usersignup-welcome-email-edit-profile-button' => '進入您的個人檔案',
	'usersignup-welcome-email-learn-basic-heading' => '學習基本事項。',
	'usersignup-welcome-email-learn-basic-content' => '初步開始學習使用Wikia：編輯頁面、編輯個人檔案、更改個人設定等。',
	'usersignup-welcome-email-learn-basic-button' => '查看一下',
	'usersignup-welcome-email-explore-wiki-heading' => '瀏覽更多Wiki社區',
	'usersignup-welcome-email-explore-wiki-content' => '在Wikia上有成千上萬的社區，您可以通過進入主題中心訪問更多的維基社區：<a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">遊戲</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">娛樂</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">生活</a>.',
	'usersignup-welcome-email-explore-wiki-button' => '進入wikia.com',
	'usersignup-welcome-email-content' => '希望了解更多訊息？訪問<a style="color:#2C85D5;" href="http://zh.community.wikia.com">中文社區中心</a>查找更多建議，幫助，以及編輯課程！',
	'usersignup-welcome-email-signature' => 'Wikia團隊',
	'usersignup-welcome-email-body' => '您好$USERNAME,

我們很高興您加入Wikia{{SITENAME}}社區！建議您可以先從以下幾點開始。

編輯您的用戶檔案。

添加用戶照片，並創建在{{SITENAME}}的用戶檔案。

訪問$EDITPROFILEURL

學習基礎。

學習如何使用Wikia：編輯文章頁，編輯個人檔案，用戶個人設定等。

查看一下($LEARNBASICURL)

瀏覽更多維基社區。

在Wikia上有成千上萬的社區，您可以通過進入主題中心訪問更多的維基社區：<a style="color:#2C85D5;" href="http://www.wikia.com/Video_Games">遊戲</a>, <a style="color:#2C85D5;" href="http://www.wikia.com/Entertainment">娛樂</a>, or <a style="color:#2C85D5;" href="http://www.wikia.com/Lifestyle">生活</a>.

訪問$EXPLOREWIKISURL

希望了解更多訊息？訪問<a style="color:#2C85D5;" href="http://zh.community.wikia.com">中文社區中心</a>查找更多建議，幫助，以及編輯課程！

Wikia團隊

___________________________________________
想了解Wikia最近發生了什麼嗎？請訪問http://zh.community.wikia.com
點擊以下連結設定收取通知郵件方式: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-heading' => '立即加入Wikia',
	'usersignup-heading-byemail' => '幫其他人創建帳戶',
	'usersignup-marketing-wikia' => '開始和全球成千上萬的線上用戶共同分享知識和興趣。',
	'usersignup-marketing-login' => '已經是Wikia的用戶？ [[Special:UserLogin|登錄]]',
	'usersignup-marketing-benefits' => '加入我們的社區吧！',
	'usersignup-marketing-community-heading' => '合作',
	'usersignup-marketing-community' => '查看和發現更多的電子遊戲、電影、電視劇等維基社區，並結交具有共同興趣愛好的人！',
	'usersignup-marketing-global-heading' => '創建',
	'usersignup-marketing-global' => '創建一個Wiki。從簡單開始，透過大家共同努力而成長。',
	'usersignup-marketing-creativity-heading' => '原創性',
	'usersignup-marketing-creativity' => '使用Wikia中的投票、排行列表、圖片、影片冊、app等功能來表達你的創意。',
	'usersignup-createaccount-byemail' => '幫其他人創建帳戶',
	'usersignup-error-captcha' => '答案錯誤，請重新嘗試！',
	'usersignup-account-creation-heading' => '操作成功！',
	'usersignup-account-creation-subheading' => '我們已經發送郵件到$1',
	'usersignup-account-creation-email-sent' => '您正在創建帳戶$2。我們已經將臨時密碼和認證連結送到電子信箱$1。

需點擊認證連結以完成$2的帳戶註冊，並更改臨時密碼。

在{{SITENAME}}上[{{fullurl:{{ns:special}}:UserSignup|byemail=1}} 創建更多帳戶]',
	'usersignup-account-creation-email-subject' => '您已經在Wikia上創建了帳戶！',
	'usersignup-account-creation-email-greeting' => '您好，',
	'usersignup-account-creation-email-content' => '您已經在{{SITENAME}}社區上創建了帳戶。點擊以下連結進入您的帳戶並更改臨時密碼。您的帳戶名稱是"$USERNAME"，密碼是"$NEWPASSWORD"。

請點擊<a style="color:#2C85D5;" href="{{fullurl:{{ns:special}}:UserLogin}}">{{fullurl:{{ns:special}}:UserLogin}}登入</a>

如果您不想創建這個帳戶，請忽略這封郵件或者聯繫我們的社區支持部門團隊解決任何疑問。',
	'usersignup-account-creation-email-signature' => 'Wikia團隊',
	'usersignup-account-creation-email-body' => '您好，

您已經在{{SITENAME}}上創建了帳戶。點擊以下連結進入您的帳戶並更改臨時密碼。您的帳戶名為"$2"，密碼為"$3"。

點擊{{fullurl:{{ns:special}}:UserLogin}}登入。

如果您不想創建這個帳戶，請忽略這封郵件或者聯繫我們的社區支持部門團隊解決任何疑問。

Wikia團隊
___________________________________________

想了解Wikia最近有什麼新消息嗎？請訪問http://zh.community.wikia.com
點擊以下連結設定電子郵件收取方式: {{fullurl:{{ns:special}}:Preferences}}',
	'usersignup-facebook-problem' => '連接Facebook出現問題。請稍後再試。',
	'usersignup-facebook-signup-header' => '要創建新的帳戶嗎？',
	'usersignup-facebook-login-header' => '已經擁有一個帳戶了嗎？',
);
