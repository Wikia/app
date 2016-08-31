<?php
/**
* Internationalisation file for the UserLogin extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'userlogin-desc' => 'UserLogin extension',
	'userlogin-login-heading' => 'Log in',
	'userlogin-forgot-password' => 'Forgot your password?',
	'userlogin-forgot-password-button' => 'Continue',
	'userlogin-forgot-password-go-to-login' => 'Have your password already? [[Special:UserLogin|Log in]]',
	'userlogin-remembermypassword' => 'Stay logged in',
	'userlogin-error-noname' => 'Oops, please fill in the username field.',
	'userlogin-error-sessionfailure' => 'Your log in session has timed out. Please log in again.',
	'userlogin-error-nosuchuser' => "Hm, we don't recognize this name. Don't forget usernames are case sensitive.",
	'userlogin-error-wrongpassword' => 'Oops, wrong password. Make sure caps lock is off and try again.',
	'userlogin-error-wrongpasswordempty' => 'Oops, please fill in the password field.',
	'userlogin-error-resetpass_announce' => 'Looks like you used a temporary password. Pick a new password here to continue logging in.',
	'userlogin-error-login-throttled' => "You've tried to log in with the wrong password too many times. Wait a while before trying again.",
	'userlogin-error-login-userblocked' => "Your username has been blocked and can't be used to log in.",
	'userlogin-error-edit-account-closed-flag' => 'Your account has been disabled by Fandom.',
	'userlogin-error-cantcreateaccount-text' => 'Your IP address is not allowed to create new accounts.',
	'userlogin-error-userexists' => 'Someone already has this username. Try a different one!',
	'userlogin-error-invalidemailaddress' => 'Please enter a valid email address.',
	'userlogin-error-wrongcredentials' => 'This username and password combination is not correct. Please try again.',
	'userlogin-error-invalidfacebook' => 'There was a problem detecting your Facebook account; please login to Facebook and try again.',
	'userlogin-error-fbconnect' => 'There was a problem connecting your Fandom account to Facebook.',
	'userlogin-get-account' => "Don't have an account? <a href=\"$1\" tabindex=\"$2\">Sign up</a>",
	'userlogin-account-admin-error' => 'Oops! Something went wrong. Please contact [[Special:Contact|Wikia]] for support.',
	'userlogin-error-invalid-username' => 'Invalid username',
	'userlogin-error-userlogin-unable-info' => "Sorry, we're not able to register your account at this time.",
	'userlogin-error-user-not-allowed' => 'This username is not allowed.',
	'userlogin-error-captcha-createaccount-fail' => "The word you entered didn't match the word in the box, try again!",
	'userlogin-error-userlogin-bad-birthday' => 'Oops, please fill out month, day, and year.',
	'userlogin-error-externaldberror' => 'Sorry! Our site is currently having an issue, please try again later.',
	'userlogin-error-noemailtitle' => 'Please enter a valid email address.',
	'userlogin-error-acct_creation_throttle_hit' => 'Sorry, this IP address has created too many accounts today. Please try again later.',
	'userlogin-opt-in-label' => 'Email me about Wikia news and events',
	'userlogin-error-resetpass_forbidden' => 'Passwords cannot be changed',
	'userlogin-error-blocked-mailpassword' => 'You can\'t request a new password because this IP address is blocked by Fandom.',
	'userlogin-error-throttled-mailpassword' => 'We\'ve already sent a password reminder to this account in the last {{PLURAL:$1|hour|$1 hours}}. Please check your email.',
	'userlogin-error-mail-error' => 'Oops, there was a problem sending your email. Please [[Special:Contact/general|contact us]].',
	'userlogin-password-email-sent' => "We've sent a new password to the email address for $1.",
	'userlogin-error-unconfirmed-user' => 'Sorry, you have not confirmed your email. Please confirm your email first.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Confirmation reminder email already sent.',
	'userlogin-password-page-title' => 'Change your password',
	'userlogin-oldpassword' => 'Old password',
	'userlogin-newpassword' => 'New password',
	'userlogin-retypenew' => 'Retype new password',
	'userlogin-password-email-subject' => 'Forgotten password request',
	'userlogin-password-email-greeting' => 'Hi $USERNAME,',
	'userlogin-password-email-content' => 'Please use this temporary password to log in to Wikia: "$NEWPASSWORD"
<br /><br />
If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.
<br /><br />
Questions or concerns? Feel free to <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">contact us</a>.',
	'userlogin-password-email-signature' => 'Wikia Community Support',
	'userlogin-password-email-body' => 'Hi $2,

Please use this temporary password to log in to Wikia: "$3"

If you didn\'t request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.

Questions or concerns? Feel free to contact us: http://community.wikia.com/wiki/Special:Contact/account-issue

Wikia Community Support


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-password-email-body-HTML' => '',
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
	'userlogin-provider-or' => 'Or',
	'userlogin-provider-tooltip-facebook' => 'Click the button to log in with Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Click the button to sign up with Facebook',
	'userlogin-facebook-show-preferences' => 'Show Facebook feed preferences',
	'userlogin-facebook-hide-preferences' => 'Hide Facebook feed preferences',
	'userlogin-loginreqlink' => 'log in',
	'userlogin-changepassword-needlogin' => 'You need to $1 to change your password.',
	'wikiamobile-sendpassword-label' => 'Send new password',
	'wikiamobile-facebook-connect-fail' => 'Sorry, your Facebook account is not currently linked with a Fandom account.',
	'userlogin-logged-in-title' => 'Welcome to {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => "You're logged in. Head over to the [[$1|homepage]] to see the latest or check out your [[$2|profile]].",
);

/** Message documentation (Message documentation)
 * @author Liuxinyu970226
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = array(
	'userlogin-desc' => '{{desc}}',
	'userlogin-login-heading' => 'Login page heading.
{{Identical|Log in}}',
	'userlogin-forgot-password' => 'Link that asks if you forgot your password.
{{Identical|Forgot your password}}',
	'userlogin-forgot-password-button' => 'Text on button on forgot your password form.
{{Identical|Continue}}',
	'userlogin-forgot-password-go-to-login' => 'Text with link to Special:UserLogin page',
	'userlogin-remembermypassword' => 'Label for staying logged in checkbox',
	'userlogin-error-noname' => 'Error message upon login attempt stating the name field is blank.',
	'userlogin-error-sessionfailure' => 'Error message upon login attempt stating session has timed out.',
	'userlogin-error-nosuchuser' => 'Error message upon login attempt stating there is no such user. Reminds of caps lock.',
	'userlogin-error-wrongpassword' => 'Error message upon login attempt stating the password is incorrect. Reminds of caps lock.',
	'userlogin-error-wrongpasswordempty' => 'Error message upon login attempt stating password field is blank.',
	'userlogin-error-resetpass_announce' => 'Error message upon login attempt stating that this password is a temp password, and the user needs to set a new password.',
	'userlogin-error-login-throttled' => 'Error message upon login attempt stating user has failed too many logins for the time period.',
	'userlogin-error-login-userblocked' => 'Error message upon login attempt stating user has been blocked.',
	'userlogin-error-edit-account-closed-flag' => 'Error message upon login attempt stating the account has been closed.',
	'userlogin-error-cantcreateaccount-text' => "Error message upon login attempt stating that the user's IP address has been throttled because of login failures.",
	'userlogin-error-userexists' => 'Error message upon signup attempt stating user name already exists.',
	'userlogin-error-invalidemailaddress' => 'Error message upon signup attempt stating e-mail address is invalid.',
	'userlogin-error-wrongcredentials' => 'Error message upon login attempt with invalid credentials.',
	'userlogin-error-invalidfacebook' => 'Error message upon Facebook connect attempt with invalid Facebook session. Reminds to retry.',
	'userlogin-error-fbconnect' => 'Error message upon Facebook connect attempt when Facebook connection fails.',
	'userlogin-get-account' => 'Marketing blurb asking to sign up with wikitext internal link to usersignup page. Parameters:
* $1 - the URL address to usersignup page. Please append userlang as appropriate.
* $2 - the tabindex of this link tag.
{{Identical|Do not have an account}}',
	'userlogin-error-invalid-username' => 'Error message upon signup attempt stating username is badly formatted, or invalid.
{{Identical|Invalid username}}',
	'userlogin-error-userlogin-unable-info' => 'Error message upon signup attempt stating account cannot be create currently.',
	'userlogin-error-user-not-allowed' => 'Error message upon signup attempt stating username is unacceptable.',
	'userlogin-error-captcha-createaccount-fail' => 'Error message upon signup attempt stating CAPTCHA has failed or not entered correctly.',
	'userlogin-error-userlogin-bad-birthday' => 'Error message upon signup attempt stating all fields for birthday is required: Year, Month, Day.',
	'userlogin-error-externaldberror' => 'Error message upon signup attempt stating there was a technical issue at Wikia.',
	'userlogin-error-noemailtitle' => 'Error message upon signup attempt stating user should enter a valid e-mail address.',
	'userlogin-error-acct_creation_throttle_hit' => 'Error message upon signup attempt stating that too many accounts have been created from the same IP.',
	'userlogin-opt-in-label' => 'Label for checkbox to opt in to marketing email',
	'userlogin-error-resetpass_forbidden' => 'Error message stating password cannot be changed.',
	'userlogin-error-blocked-mailpassword' => 'Error message stating password cannot be changed because IP has been restricted.',
	'userlogin-error-throttled-mailpassword' => 'Error message stating email has already been sent $1 hours ago and asks user to check email. Parameters:
* $1 is numerical hour.',
	'userlogin-error-mail-error' => 'Error message stating there was an error sending the email. Link to Contact us page in wikitext.',
	'userlogin-password-email-sent' => 'Validation message stating that email has been to the user. Parameters:
* $1 contains the user name in plain text',
	'userlogin-error-unconfirmed-user' => 'Error message stating that user needs to be confirmed first.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Error message stating that confirmation email was already sent. This message is only used by maintenance scripts.',
	'userlogin-password-page-title' => 'Heading for change password page.
{{Identical|Change password}}',
	'userlogin-oldpassword' => 'Label for old password field.
{{Identical|Old password}}',
	'userlogin-newpassword' => 'Label for new password field.
{{Identical|New password}}',
	'userlogin-retypenew' => 'Label for retype password field',
	'userlogin-password-email-subject' => 'Subject line for Forgot password email',
	'userlogin-password-email-greeting' => 'Email body heading. $USERNAME is a special wikia magic word, so re-use it without changing. This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-content' => 'Email body. $NEWPASSWORD is wikia magic word. This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-signature' => 'Wikia Email signature at the bottom of the email. This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-body' => 'This is a text-only version email that combines the contents userlogin-password-email-greeting, userlogin-password-email-content, and userlogin-password-email-signature. This does NOT contain HTML. Parameters:
* $2 is username in greeting,
* $3 is the temporary password value. Content-wise, it is exactly the same as templated html version, but this is a complete stand-alone.',
	'userlogin-email-footer-line1' => 'Footer line 1 in the standard Wikia email template.',
	'userlogin-email-footer-line2' => 'Footer line 2 in the standard Wikia email template.',
	'userlogin-email-footer-line3' => 'Footer line 3 in the standard Wikia email template. The links are space (&nbsp) separated pointing to social networks. Leave this blank if social network is unknown.',
	'userlogin-provider-or' => 'Word shown between login form and FB connect button.
{{Identical|Or}}',
	'userlogin-provider-tooltip-facebook' => 'Tooltip when hovering over facebook connect button in login page or context.',
	'userlogin-provider-tooltip-facebook-signup' => 'Tooltip when hovering over facebook connect button in signup page or context.',
	'userlogin-facebook-show-preferences' => 'Action anchor text to show facebook feed preference section of the UI when near facebook signup completion.',
	'userlogin-facebook-hide-preferences' => 'Action anchor text to hide facebook feed preference section of the UI when near facebook signup completion.',
	'userlogin-loginreqlink' => 'login link',
	'userlogin-changepassword-needlogin' => 'Parameters:
* $1 is an action link using the message {{msg-wikia|userlogin-loginreqlink}}.',
	'wikiamobile-sendpassword-label' => 'Label for the button used to request a new password for recovery',
	'wikiamobile-facebook-connect-fail' => "Shown when a user tries to log in via FBConnect but there's no matching account in our DB, please keep the message as short as possible as the space at disposal is really limited",
	'userlogin-logged-in-title' => 'Header (title) for user login or signup page when user is already logged in',
	'userlogin-logged-in-message' => 'Message body for user login or signup page when user is already logged in',
);

/** Aragonese (aragonés)
 * @author Willtron
 */
$messages['an'] = array(
	'userlogin-get-account' => 'No tiene garra cuenta? <a href="$1" tabindex="$2">Rechistra-te</a>',
	'userlogin-retypenew' => 'Torne a escribir a nueva clau',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 * @author Kuwaity26
 * @author Mutarjem horr
 * @author ترجمان05
 */
$messages['ar'] = array(
	'userlogin-login-heading' => 'سجّل الدخول',
	'userlogin-forgot-password' => 'هل نسيت كلمتك للمرور؟',
	'userlogin-forgot-password-button' => 'واصل',
	'userlogin-forgot-password-go-to-login' => 'لديك كلمة مرورك فعلا؟ [[Special:UserLogin|سجل الدخول]]',
	'userlogin-remembermypassword' => 'ابق مسجل الدخول',
	'userlogin-error-noname' => 'عفوا، يرجى ملء خانة اسم المستخدم.',
	'userlogin-error-sessionfailure' => 'انتهت مهلة تسجيل الدخول الخاصة بك. الرجاء تسجيل الدخول مرة أخرى.',
	'userlogin-error-nosuchuser' => 'لا يمكننا قبول هذا الاسم. تذكر أن أسماء المستخدمين حساسة لحالة الأحرف.',
	'userlogin-error-wrongpassword' => 'عفوا، كلمة المرور خاطئة. تأكد من أن زر الحروف الكبيرة مغلق و حاول مرة ثانية.',
	'userlogin-error-wrongpasswordempty' => 'عفوا، يرجى ملء خانة كلمة المرور.',
	'userlogin-error-resetpass_announce' => 'يبدو أنك استخدمت كلمة سر مؤقتة. قم باختيار كلمة سر جديدة هنا لمواصلة تسجيل الدخول.',
	'userlogin-error-login-throttled' => 'لقد حاولت تسجيل الدخول باستخدام كلمة مرور خاطئة مرات عديدة. انتظر لبعض الوقت قبل أن تحاول مرة أخرى.',
	'userlogin-error-login-userblocked' => 'تم منع اسم المستخدم الذي أدخلته إذ لا يمكن استخدامه لتسجيل الدخول.',
	'userlogin-error-edit-account-closed-flag' => 'تم تعطيل الحساب الخاص بك من قبل ويكيا.',
	'userlogin-error-cantcreateaccount-text' => 'عنوان الآي بي الخاص بك ممنوع من إنشاء الحسابات الجديدة.',
	'userlogin-error-userexists' => 'هذا الاسم مستخدم من قبل شخص آخر. جرب إسما مختلفا!',
	'userlogin-error-invalidemailaddress' => 'الرجاء إدخال عنوان بريد إلكتروني صالح.',
	'userlogin-get-account' => 'ليس لديك حساب؟ <a href="$1" tabindex="$2">سجل الآن</a>',
	'userlogin-error-invalid-username' => 'اسم المستخدم غير صحيح',
	'userlogin-error-userlogin-unable-info' => 'عذراً، لا يمكننا تسجيل الحساب الخاص بك في هذا الوقت.',
	'userlogin-error-user-not-allowed' => 'اسم المستخدم هذا غير مسموح به.',
	'userlogin-error-captcha-createaccount-fail' => 'لم تطابق الكلمة التي قمت بإدخالها بالكلمة في المربع، حاول مرة أخرى!',
	'userlogin-error-userlogin-bad-birthday' => 'عفوا، يرجى ملء الشهر واليوم والسنة.',
	'userlogin-error-externaldberror' => 'عذراً! يواجه موقعنا حاليا مشكلة، الرجاء المحاولة مرة أخرى لاحقا.',
	'userlogin-error-noemailtitle' => 'الرجاء إدخال عنوان بريد إلكتروني صالح.',
	'userlogin-error-acct_creation_throttle_hit' => 'عذراً، عنوان IP هذا أنشئ حسابات كثيرة جداً اليوم. الرجاء المحاولة مرة أخرى لاحقاً.',
	'userlogin-error-resetpass_forbidden' => 'كلمات المرور لا يمكن تغييرها',
	'userlogin-error-blocked-mailpassword' => 'لا يمكنك طلب كلمة مرور جديدة لأن هذا عنوان IP يتم حظره بواسطة ويكيا.',
	'userlogin-error-throttled-mailpassword' => 'لقد أرسلنا فعلا تذكيرا لكلمة المرور لهذا الحساب في آخر  {{PLURAL:$1|ساعة|$1 ساعات}}. الرجاء التحقق من البريد الإلكتروني الخاص بك.',
	'userlogin-error-mail-error' => 'عفوا، كانت هناك مشكلة في إرسال البريد الإلكتروني الخاص بك. الرجاء [[Special:Contact/general|الاتصال بنا]].',
	'userlogin-password-email-sent' => 'لقد أرسلنا كلمة مرور جديدة إلى عنوان البريد الإلكتروني ل  $1 .',
	'userlogin-error-unconfirmed-user' => 'عذراً، لم تأكد البريد الإلكتروني الخاص بك. الرجاء تأكيد البريد الإلكتروني الخاص بك أولاً.',
	'userlogin-error-confirmation-reminder-already-sent' => 'تأكيد تذكير البريد الإلكتروني أرسل بالفعل.',
	'userlogin-password-page-title' => 'غير كلمة سرّك',
	'userlogin-oldpassword' => 'كلمة السر القديمة',
	'userlogin-newpassword' => 'كلمة السر الجديدة',
	'userlogin-retypenew' => 'أعد كتابة كلمة المرور الجديدة',
	'userlogin-password-email-subject' => 'طلب كلمة مرور منسية',
	'userlogin-password-email-greeting' => 'مرحباً $USERNAME,',
	'userlogin-password-email-content' => 'الرجاء استخدام كلمة السر المؤقتة هذه لتسجيل الدخول إلى ويكيا: "$NEWPASSWORD"
<br /><br />
إن لم تطلب كلمة سر جديدة، فلا تقلق! حسابك آمن ومأمون. يمكنك تجاهل هذه الرسالة ومتابعة تسجيل دخولك إلى ويكيا باستخدام كلمة السر القديمة.
<br /><br />
أسئلة أو مخاوف؟ لا تتردد في <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">الاتصال بنا</a>.',
	'userlogin-password-email-signature' => 'دعم مجتمع ويكيا',
	'userlogin-password-email-body' => 'مرحبًا $2،

الرجاء استخدام كلمة المرور المؤقتة هذه لتسجيل الدخول إلى ويكيا: " $3 "

إن لم تطلب كلمة مرور جديدة، فلا تقلق! فحسابك آمن ومأمون. يمكنك تجاهل هذه الرسالة ومتابعة تسجيل دخولك إلى ويكيا باستخدام كلمة المرور القديمة.

أسئلة أو مخاوف؟ لا تتردد في الاتصال بنا: http://community.wikia.com/wiki/Special:Contact/account-issue

مجتمع ويكيا للدعم

___________________________________________

للتحقق من آخر الأحداث في ويكيا، قم بزيارة http://community.wikia.com
تريد التحكم في رسائل البريد الإلكتروني التي تتلقها؟ اذهب إلى: {{fullurl:{{ns:special}}:تفضيلات}}',
	'userlogin-email-footer-line1' => 'للتحقق من آخر الأحداث في ويكيا، قم بزيارة <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'تريد التحكم في رسائل البريد الإلكتروني التي تتلقاها منا؟ انتقل إلى <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">التفضيلات</a> الخاصة بك.',
	'userlogin-provider-or' => 'أو',
	'userlogin-provider-tooltip-facebook' => 'انقر فوق الزر لتسجيل الدخول باستخدام فيسبوك',
	'userlogin-provider-tooltip-facebook-signup' => 'انقر فوق الزر للتسجيل باستخدام فيسبوك',
	'userlogin-facebook-show-preferences' => 'إظهار تفضيلات تغذية الفيسبوك',
	'userlogin-facebook-hide-preferences' => 'أخفاء تفضيلات تغذية الفيسبوك',
	'userlogin-loginreqlink' => 'تسجيل الدخول',
	'userlogin-changepassword-needlogin' => 'أنت بحاجة إلى $1 لكي تغيّر كلمتك للمرور.',
	'wikiamobile-sendpassword-label' => 'أرسل كلمة المرور الجديدة',
	'wikiamobile-facebook-connect-fail' => 'عذراً، حساب فيسبوك الخاص بك غير مرتبط حاليا مع حسابك في ويكيا.',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 * @author Khan27
 * @author Wertuose
 */
$messages['az'] = array(
	'userlogin-login-heading' => 'Daxil ol',
	'userlogin-forgot-password' => 'Parolunuzu unutmusunuz?',
	'userlogin-forgot-password-button' => 'Davam et',
	'userlogin-forgot-password-go-to-login' => 'Artıq şifrəniz var? [[Special:UserLogin|Daxil olun]]',
	'userlogin-remembermypassword' => 'Girişdə qal',
	'userlogin-error-noemailtitle' => 'İstifadə olunan bir e-poçt ünvanı daxil edin.',
	'userlogin-error-resetpass_forbidden' => 'Parolu dəyişmək mümkün deyil',
	'userlogin-error-unconfirmed-user' => 'Bağışlayın, siz e-poçtunuzu təsdiq etməmisiniz. Xahiş edirik ilk olaraq e-poçtu doğrulayın.',
	'userlogin-password-page-title' => 'Şifrəni dəyiş',
	'userlogin-oldpassword' => 'Köhnə şifrə',
	'userlogin-newpassword' => 'Yeni şifrə',
	'userlogin-retypenew' => 'Yeni şifrəni təkrar yazın',
	'userlogin-password-email-subject' => 'Şifrəni unutmaq sorğusu',
	'userlogin-password-email-greeting' => 'Salam $USERNAME,',
	'userlogin-provider-or' => 'Və ya',
	'userlogin-provider-tooltip-facebook' => 'Facebook ilə daxil ol butonuna basın',
	'userlogin-provider-tooltip-facebook-signup' => 'Facebook ilə qeyd ol butonuna bas',
	'wikiamobile-sendpassword-label' => 'Yeni şifrəni göndər',
);

/** South Azerbaijani (تۆرکجه)
 * @author Arjanizary
 * @author Koroğlu
 */
$messages['azb'] = array(
	'userlogin-login-heading' => 'گیریش',
	'userlogin-forgot-password' => 'رمزیزی اونوتموسوز مو؟',
	'userlogin-remembermypassword' => 'ایچری‌ده قال',
	'userlogin-error-noname' => 'اوخخخ، لوطفا ایشلدن‌آدی یئرین دولدورون',
	'userlogin-error-invalidemailaddress' => 'لوطفا بیر گئچرلی ایمیل تاپاناغین یازین.',
	'userlogin-error-invalid-username' => 'گئچرسیز ایشلدن آدی',
	'userlogin-error-user-not-allowed' => 'بو ایشلدن‌آدی قویولمور.',
	'userlogin-error-noemailtitle' => 'لوطفا بیر گئچرلی ایمیل تاپاناغین یازین.',
	'userlogin-error-resetpass_forbidden' => 'رمزلر دَییشیلمز.',
	'userlogin-password-page-title' => 'رمزی دَییشدیر',
	'userlogin-oldpassword' => 'اسکی رمز',
	'userlogin-newpassword' => 'یئنی رمز',
	'userlogin-retypenew' => 'یئنی رمزی یئنی‌دن یازین',
	'userlogin-password-email-subject' => 'اونوتولموش رمز ایستگی',
	'userlogin-password-email-greeting' => 'سلام $USERNAME,',
	'userlogin-provider-or' => 'یوخسا',
	'userlogin-loginreqlink' => 'گیریش',
	'userlogin-changepassword-needlogin' => 'رمز دَییشمه‌سینه گؤره $1 اولماغی گرک‌دیر.',
	'wikiamobile-sendpassword-label' => 'یئنی رمزی گؤندر',
);

/** Bashkir (башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'userlogin-login-heading' => 'Танылыу',
	'userlogin-forgot-password' => 'Паролегеҙҙе оноттоғоҙмо?',
	'userlogin-forgot-password-button' => 'Дауам итергә',
	'userlogin-remembermypassword' => 'Танылған килеш ҡалырға',
	'userlogin-error-noname' => 'Зинһар, исем юлын тултырығыҙ.',
	'userlogin-error-sessionfailure' => 'Һеҙҙең танылыу сессияһы ваҡыты үткән. Зиһар, ҡабаттан танылығыҙ.',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'userlogin-login-heading' => 'Maglaóg',
	'userlogin-forgot-password' => 'Nalingawán an susing tataramon?',
	'userlogin-remembermypassword' => 'Nakadagos saná',
	'userlogin-error-noname' => 'Ay, paki kaagán an liang-liang kan paragamít',
	'userlogin-error-sessionfailure' => 'Nagpaso na an saimong paglaóg. Pakí laóg giraray.',
	'userlogin-error-nosuchuser' => 'Daí nyamò midbid iníng ngaran. Giromdomón na an mga ngaran nin paragamít case sensitive.',
	'userlogin-error-wrongpassword' => 'Ay, salâ an susing tataramon. Tibaad naka-caps lock. Probaran liwát.',
	'userlogin-error-wrongpasswordempty' => 'Ay, paki kaagán an liangliang para sa susing tataramon.',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'userlogin-changepassword-needlogin' => 'Вам неабходна $1, каб зьмяніць ваш пароль.',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'userlogin-login-heading' => 'Влизане',
	'userlogin-forgot-password' => 'Забравена парола?',
	'userlogin-forgot-password-button' => 'Продължаване',
	'userlogin-error-invalid-username' => 'Невалидно потребителско име',
	'userlogin-oldpassword' => 'Стара парола',
	'userlogin-newpassword' => 'Нова парола',
	'userlogin-retypenew' => 'Нова парола (повторно)',
	'wikiamobile-sendpassword-label' => 'Изпращане на нова парола',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'userlogin-login-heading' => 'Kevreañ',
	'userlogin-forgot-password' => "Ankouaet ho ker-tremen ganeoc'h ?",
	'userlogin-forgot-password-button' => "Kenderc'hel",
	'userlogin-forgot-password-go-to-login' => 'Ho ker tremen ho peus dija ? [[Special:UserLogin|Kevreañ]]',
	'userlogin-remembermypassword' => 'Chom kevreet',
	'userlogin-error-noname' => 'Pop, leugnit ar vaezienn anv implijer, mar plij.',
	'userlogin-error-nosuchuser' => "Hem, n'anavezomp ket an anv-mañ. Na zisoñjit ket eo kizidik an anvioù implijer ouzh ar pennlizherennoù.",
	'userlogin-error-wrongpasswordempty' => 'Pop, leugnit ar vaezienn ger-tremen, mar plij.',
	'userlogin-error-login-userblocked' => "Stanket eo bet hoc'h anv implijer ha ne c'hall ket bezañ implijet da gevreañ.",
	'userlogin-error-edit-account-closed-flag' => 'Diweredekaet eo bet ho kont gant Wikia.',
	'userlogin-error-cantcreateaccount-text' => "N'eo ket aotreet ho chomlec'h IP da grouiñ kontoù nevez.",
	'userlogin-error-userexists' => 'Implijet eo an anv implijer-mañ gant unan bennak dija. Esaeit gant unan all !',
	'userlogin-error-invalidemailaddress' => "Ebarzhit ur chomlec'h postel reizh, mar plij.",
	'userlogin-get-account' => 'N\'ho peus kont ebet c\'hoazh ? <a href="$1" tabindex="$2">En em enskrivit</a>',
	'userlogin-error-invalid-username' => 'Anv implijer direizh',
	'userlogin-error-userlogin-unable-info' => "Digarezit, n'omp ket evit enrollañ ho kont evit bremañ.",
	'userlogin-error-user-not-allowed' => "An anv implijer-mañ n'eo ket aotreet.",
	'userlogin-error-captcha-createaccount-fail' => 'Ar ger ho peus ebarzhet ne glot ket gant ar ger er voest, esaeit en-dro !',
	'userlogin-error-noemailtitle' => "Ebarzhit ur chomlec'h postel reizh, mar plij.",
	'userlogin-error-resetpass_forbidden' => "
N'haller ket cheñch ar gerioù-termen",
	'userlogin-error-blocked-mailpassword' => "Ne c'hallit ket goulenn ur ger-tremen nevez abalamour m'eo stanket ar chomlec'h IP-mañ gant Wikia.",
	'userlogin-password-email-sent' => "Kaset hon eus ur ger-tremen nevez d'ar chomlec'h postel evit $1.",
	'userlogin-error-unconfirmed-user' => "Digarezit, n'ho peus ket kadanaet ho chomlec'h postel. Kadarnait ho chomlec'h postel da gentañ, mar plij.",
	'userlogin-password-page-title' => 'Cheñch ar ger-tremen',
	'userlogin-oldpassword' => 'Ger-tremen kozh',
	'userlogin-newpassword' => 'Ger-tremen nevez',
	'userlogin-retypenew' => 'Adskrivañ ar ger-tremen nevez',
	'userlogin-password-email-subject' => 'Goulenn ger-tremen ankouaet',
	'userlogin-password-email-greeting' => 'Ac\'hanta $USERNAME,',
	'userlogin-password-email-signature' => 'Skoazell ar gumuniezh Wikia',
	'userlogin-provider-or' => 'Pe',
	'userlogin-provider-tooltip-facebook' => 'Klikañ war ar bouton evit kevreañ gant Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Klikañ war ar bouton evit en em enskrivañ gant Facebook',
	'userlogin-loginreqlink' => 'kevreañ',
	'userlogin-changepassword-needlogin' => 'Rankout a rit $1 evit kemm ho ker tremen',
	'wikiamobile-sendpassword-label' => 'Kas ur ger-tremen nevez',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author BroOk
 * @author Marcmpujol
 * @author Toniher
 * @author Unapersona
 */
$messages['ca'] = array(
	'userlogin-login-heading' => 'Iniciar sessió',
	'userlogin-forgot-password' => 'Has oblidat la teva contrasenya?',
	'userlogin-forgot-password-button' => 'Continuar',
	'userlogin-forgot-password-go-to-login' => "Ja tens la teva contrasenya? [[Special:UserLogin|Identifica't]]",
	'userlogin-remembermypassword' => 'Continua connectat',
	'userlogin-error-noname' => "Si us plau, omple el camp del nom d'usuari.",
	'userlogin-error-sessionfailure' => 'El registre de la sessió ha caducat. Si us plau, inicia sessió un altre cop.',
	'userlogin-error-nosuchuser' => "No reconeixem aquest nom. No oblidis que els noms d'usuari distingeixen les majúscules de les minúscules.",
	'userlogin-error-wrongpassword' => "Vaja, contrasenya incorrecta. Assegura't que la tecla Bloq Mayús (Caps Lock) està desactivada i tornar-ho a provar.",
	'userlogin-error-wrongpasswordempty' => 'Si us plau, omple el camp de la contrasenya.',
	'userlogin-error-resetpass_announce' => 'Sembla ser que has utilitzat una contrasenya temporal. Escull aquí una nova contrasenya per continuar la sessió.',
	'userlogin-error-login-throttled' => 'Has intentat iniciar sessió amb la contrasenya incorrecta masses vegades. Espera un moment abans de tornar-ho a provar.',
	'userlogin-error-login-userblocked' => "El teu nom d'usuari ha estat bloquejat i no es pot utilitzar per iniciar sessió.",
	'userlogin-error-edit-account-closed-flag' => 'El teu compte ha estat deshabilitat per Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'La teva direcció IP no està autoritzada per a crear nous comptes.',
	'userlogin-error-userexists' => "Algú ja té aquest nom d'usuari. Tria'n un altre!",
	'userlogin-error-invalidemailaddress' => 'Si us plau, insereix una adreça de correu electrònic vàlida.',
	'userlogin-get-account' => 'No tens un compte? <a href="$1" tabindex="$2">Registra\'t</a>',
	'userlogin-error-invalid-username' => "Nom d'usuari no vàlid",
	'userlogin-error-userlogin-unable-info' => 'Ho sentim, no és possible registrar el teu compte en aquest moment.',
	'userlogin-error-user-not-allowed' => "Aquest nom d'usuari no està permès.",
	'userlogin-error-captcha-createaccount-fail' => 'La paraula que has introduït no coincideix amb la paraula del requadre. Torna-ho a provar!',
	'userlogin-error-userlogin-bad-birthday' => 'Si us plau, omple mes, dia i any.',
	'userlogin-error-externaldberror' => '¡Ho sentim! El nostre lloc actualment està tenint un problema. Intenta-ho de nou més tard.',
	'userlogin-error-noemailtitle' => 'Si us plau, insereix una adreça de correu electrònic vàlida.',
	'userlogin-error-acct_creation_throttle_hit' => 'Ho sentim, però avui aquesta adreça IP ha creat avui molts comptes. Si us plau, prova un altre cop més tard.',
	'userlogin-error-resetpass_forbidden' => 'No poden canviar-se les contrasenyes',
	'userlogin-error-blocked-mailpassword' => "No es pots sol·licitar una contrasenya nova perquè aquesta adreça d'IP està bloquejada per Wikia.",
	'userlogin-error-throttled-mailpassword' => "Ja hem enviat un recordatori de contrasenya d'aquest compte en {{PLURAL:$1|l'última hora|les $1 últimes hores}}. Si us plau, revisa el teu correu electrònic.",
	'userlogin-error-mail-error' => "Perdó, ha hagut un problema al enviar el teu correu electrònico. Si us plau, [[Special:Contact/general|contacta'ns]].",
	'userlogin-password-email-sent' => "Hem enviat una nova contrasenya a l'adreça electrònica $1.",
	'userlogin-error-unconfirmed-user' => "No has confirmat la teva adreça electrònica. Confirma primer l'adreça electrònica.",
	'userlogin-error-confirmation-reminder-already-sent' => "Ja s'havia enviat un correu electrònic de recordatori de confirmació.",
	'userlogin-password-page-title' => 'Canvia la teva contrasenya',
	'userlogin-oldpassword' => 'Antiga contrasenya',
	'userlogin-newpassword' => 'Nova contrasenya',
	'userlogin-retypenew' => 'Confirma la nova contrasenya',
	'userlogin-password-email-subject' => 'Sol·licitud de contrasenya oblidada',
	'userlogin-password-email-greeting' => 'Hola, $USERNAME.',
	'userlogin-password-email-content' => 'Utilitza aquesta contrasenya temporal per iniciar sessió en Wikia: "$NEWPASSWORD"
<br /><br />
Si no has sol·licitat una nova contrasenya, no et preocupis! El teu compte està segur. Pots ignorar aquest missatge i continuar iniciant sessió en Wikia la teva antiga contrasenya.
<br /><br />
¿Tens preguntes o inquietuds? No dubtis en posar-te en <a href="http://ca.wikia.com/wiki/Especial:Contactar/account-issue">contacte amb nosaltres</a>.',
	'userlogin-password-email-signature' => 'Equip Comunitari de Wikia',
	'userlogin-password-email-body' => 'Hola $2,

Utilitza aquesta contrasenya temporal per iniciar sessió en Wikia: "$3"

Si no has sol·licitat una nova contrasenya, no et preocupis! El teu compte està segur. Pots ignorar aquest missatge i continuar iniciant sessió en Wikia amb la teva antiga contrasenya.

¿Tens preguntes o inquietuds? No dubtis en contactar-nos: http://ca.wikia.com/wiki/Especial:Contactar/account-issue

Equip Comunitari de Wikia


___________________________________________

Per comprobar els esdeveniments més recents en Wikia, visita http://ca.wikia.com
Desitges controlar quins missatges de correu electrònic reps? Vés a: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Per comprovar les últimes novetats en Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://ca.wikia.com">ca.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Desitges controlar els correus electrònics que reps? Vés a les teves <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">preferències</a>',
	'userlogin-provider-or' => 'o',
	'userlogin-provider-tooltip-facebook' => 'Clica el botó per iniciar sessió amb Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Clica el botó per iniciar sessió amb Facebook',
	'userlogin-facebook-show-preferences' => 'Mostrar les preferències de connexió de Facebook',
	'userlogin-facebook-hide-preferences' => 'Amagar les preferències de connexió de Facebook',
	'userlogin-loginreqlink' => 'Inicia la sessió',
	'userlogin-changepassword-needlogin' => 'Necessites $1 per canviar la contrasenya.',
	'wikiamobile-sendpassword-label' => 'Enviar una contrasenya nova',
	'wikiamobile-facebook-connect-fail' => 'Ho sentim, el teu compte de Facebook no està actualment vinculat amb el teu compte de Wikia.',
	'userlogin-logged-in-title' => 'Benvingut a {{SITENAME}}, $1!',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'userlogin-error-throttled-mailpassword' => 'Оха хӀинцале хӀокху декъашхочун дӀаяздаран пароль яийтина {{PLURAL:$1| сахьт}} хьалха. Дехар до, хьай электронан почте хьажа.',
);

/** Czech (čeština)
 * @author Chmee2
 */
$messages['cs'] = array(
	'userlogin-login-heading' => 'Přihlásit se',
	'userlogin-forgot-password' => 'Zapomněli jste heslo?',
	'userlogin-remembermypassword' => 'Zůstat přihlášený',
	'userlogin-error-invalidemailaddress' => 'Zadejte prosím platnou e-mailovou adresu.',
	'userlogin-error-invalid-username' => 'Neplatné uživatelské jméno',
	'userlogin-error-userlogin-unable-info' => 'Omlouváme se, ale nyní není možné zaregistrovat váš účet.',
	'userlogin-error-user-not-allowed' => 'Toto uživatelské jméno není dovoleno.',
	'userlogin-error-noemailtitle' => 'Zadejte prosím platnou e-mailovou adresu.',
	'userlogin-error-resetpass_forbidden' => 'Hesla není možné změnit',
	'userlogin-error-unconfirmed-user' => 'Omlouváme se, ale nepotvrdil jste váš email. Prosíme, nejprve ho potvrďte.',
	'userlogin-password-page-title' => 'Změnit heslo',
	'userlogin-oldpassword' => 'Staré heslo',
	'userlogin-newpassword' => 'Nové heslo',
	'userlogin-retypenew' => 'Zadat nové heslo znovu',
	'userlogin-password-email-greeting' => 'Ahoj $USERNAME,',
	'userlogin-provider-or' => 'Nebo',
	'userlogin-provider-tooltip-facebook' => 'Klikněte pro přihlášení skrze Facebook',
	'userlogin-loginreqlink' => 'přihlásit se',
	'wikiamobile-sendpassword-label' => 'Poslat nové heslo',
);

/** Welsh (Cymraeg)
 * @author Thefartydoctor
 */
$messages['cy'] = array(
	'userlogin-login-heading' => 'Mewngofnodi',
	'userlogin-password-email-greeting' => 'Helo $USERNAME,',
	'userlogin-loginreqlink' => 'mewngofnodi',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author MtaÄ
 */
$messages['de'] = array(
	'userlogin-desc' => 'UserLogin-Erweiterung',
	'userlogin-login-heading' => 'Anmelden',
	'userlogin-forgot-password' => 'Passwort vergessen?',
	'userlogin-forgot-password-button' => 'Fortfahren',
	'userlogin-forgot-password-go-to-login' => 'Hast du bereits ein Passwort? [[Special:UserLogin|Anmelden]]',
	'userlogin-remembermypassword' => 'Eingeloggt bleiben',
	'userlogin-error-noname' => 'Bitte gib einen Benutzernamen an.',
	'userlogin-error-sessionfailure' => 'Deine Anmelde-Sitzung ist abgelaufen. Bitte melde dich erneut an.',
	'userlogin-error-nosuchuser' => 'Dieser Benutzername scheint nicht zu existieren. Beachte bei der Eingabe des Benutzernamens die Groß-/Kleinschreibung.',
	'userlogin-error-wrongpassword' => 'Falsches Passwort. Stelle sicher, dass Caps-Lock deaktiviert ist und versuche es noch einmal.',
	'userlogin-error-wrongpasswordempty' => 'Bitte gib ein Passwort an.',
	'userlogin-error-resetpass_announce' => 'Du hast ein temporäres Passwort eingegeben. Bitte gib ein neues Passwort ein, das du von nun an für dein Benutzerkonto verwenden möchtest.',
	'userlogin-error-login-throttled' => 'Du hast das Passwort zu oft falsch eingegeben. Bitte warte eine Weile und versuche es anschließend nochmal.',
	'userlogin-error-login-userblocked' => 'Dieser Benutzername wurde gesperrt und kann nicht zum Einloggen benutzt werden.',
	'userlogin-error-edit-account-closed-flag' => 'Dieses Benutzerkonto wurde von Wikia deaktiviert.',
	'userlogin-error-cantcreateaccount-text' => 'Die IP die du momentan nutzt darf keine neuen Benutzerkonten anlegen.',
	'userlogin-error-userexists' => 'Dieser Benutzername ist bereits vergeben. Gib einen anderen an!',
	'userlogin-error-invalidemailaddress' => 'Bitte gib eine gültige E-Mail-Adresse an.',
	'userlogin-error-wrongcredentials' => 'Diese Benutzerkonto-/Passwort-Kombination ist nicht richtig. Bitte erneut versuchen.',
	'userlogin-error-invalidfacebook' => 'Es gab ein Problem beim Erkennen deines Facebook-Benutzerkontos. Bitte melde dich bei Facebook an und versuche es erneut.',
	'userlogin-error-fbconnect' => 'Es gab ein Problem beim Verbinden deines Wikia-Benutzerkontos mit Facebook.',
	'userlogin-get-account' => 'Du hast noch kein Benutzerkonto? Dann <a href="$1" tabindex="$2">erstelle eines</a>.',
	'userlogin-error-invalid-username' => 'Ungültiger Benutzername',
	'userlogin-error-userlogin-unable-info' => 'Entschuldige, wir können dein Benutzerkonto zu diesem Zeitpunkt nicht registrieren.',
	'userlogin-error-user-not-allowed' => 'Dieser Benutzername ist nicht erlaubt.',
	'userlogin-error-captcha-createaccount-fail' => 'Das eingegebene Wort ist nicht identisch mit dem Wort in der Box. Versuche es noch einmal!',
	'userlogin-error-userlogin-bad-birthday' => 'Bitte gib dein Geburtsdatum an.',
	'userlogin-error-externaldberror' => 'Entschuldige! Unsere Webseite hat derzeit ein Problem. Bitte versuche es später noch einmal.',
	'userlogin-error-noemailtitle' => 'Bitte gib eine gültige E-Mail-Adresse an.',
	'userlogin-error-acct_creation_throttle_hit' => 'Diese IP-Adresse hat heute zu viele Benutzerkonten erstellt. Bitte versuche es später noch einmal.',
	'userlogin-opt-in-label' => 'Sende mir E-Mails zu Nachrichten über Wikia und Ereignissen',
	'userlogin-error-resetpass_forbidden' => 'Das Passwort kann nicht geändert werden.',
	'userlogin-error-blocked-mailpassword' => 'Du kannst kein neues Passwort beantragen, weil deine IP-Adresse von Wikia gesperrt wurde.',
	'userlogin-error-throttled-mailpassword' => 'Wir haben dir bereits ein temporäres Passwort in {{PLURAL:$1|der letzten Stunde|den letzten $1 Stunden}} zugestellt. Bitte überprüfe dein E-Mail-Postfach.',
	'userlogin-error-mail-error' => 'Wir konnten dir diese E-Mail nicht zustellen. Bitte [[Spezial:Kontakt|kontaktiere uns]].',
	'userlogin-password-email-sent' => 'Wir haben ein neues Passwort an $1 geschickt.',
	'userlogin-error-unconfirmed-user' => 'Entschuldige, du hast deine E-Mail-Adresse nicht bestätigt. Bitte bestätige deine E-Mail-Adresse zuerst.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Eine Bestätigungs-Erinnerungs-E-Mail wurde bereits versandt.',
	'userlogin-password-page-title' => 'Passwort ändern',
	'userlogin-oldpassword' => 'Altes Passwort',
	'userlogin-newpassword' => 'Neues Passwort',
	'userlogin-retypenew' => 'Passwort wiederholen',
	'userlogin-password-email-subject' => 'Anforderung eines neuen Passwortes',
	'userlogin-password-email-greeting' => 'Hallo $USERNAME,',
	'userlogin-password-email-content' => 'Gib dieses temporäre Passwort an, um dich bei Wikia anzumelden: "$NEWPASSWORD"
<br /><br />
Falls du kein neues Passwort beantragt hast, kannst du diese E-Mail ignorieren und weiterhin dein altes Passwort verwenden. Keine Sorge! Dein Benutzerkonto ist immer noch sicher.
<br /><br />
Bei Fragen oder Bedenken kannst du uns jederzeit <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">kontaktieren</a>.',
	'userlogin-password-email-signature' => 'Wikia Community Support',
	'userlogin-password-email-body' => 'Hallo $2,

gib dieses temporäre Passwort an, um dich bei Wikia anzumelden: "$3"

Falls du kein neues Passwort beantragt hast kannst du diese E-Mail ignorieren und weiterhin dein altes Passwort verwenden. Keine Sorge! Dein Benutzerkonto ist immernoch sicher.

Bei Fragen oder Bedenken kannst du uns jederzeit kontaktieren: http://community.wikia.com/wiki/Special:Contact/account-issue

Wikia Community Support

___________________________________________
Bleib auf dem Laufenden und besuche unser Community-Wiki: http://de.community.wikia.com
Möchtest du deine E-Mail-Einstellungen ändern? Besuche {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Bleib auf dem Laufenden und besuche unser Community-Wiki unter <a style="color:#2a87d5;text-decoration:none;" href="http://de.community.wikia.com">de.community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Möchtest du deine E-Mail-Einstellungen ändern? Besuche <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">deine Einstellungen</a>',
	'userlogin-provider-or' => 'oder',
	'userlogin-provider-tooltip-facebook' => 'Klicke hier, um dich mit deinem Facebook-Konto anzumelden',
	'userlogin-provider-tooltip-facebook-signup' => 'Anmelden mittels Facebook',
	'userlogin-facebook-show-preferences' => 'Zeige Facebook-Einstellungen an',
	'userlogin-facebook-hide-preferences' => 'Verstecke die Facebook-Feed-Einstellungen',
	'userlogin-loginreqlink' => 'anmelden',
	'userlogin-changepassword-needlogin' => 'Du musst dich $1, um dein Passwort zu ändern.',
	'wikiamobile-sendpassword-label' => 'Schicke neues Passwort',
	'wikiamobile-facebook-connect-fail' => 'Dein Facebook-Konto ist momentan nicht mit deinem Wikia-Benutzerkonto verbunden.',
	'userlogin-logged-in-title' => 'Willkommen bei {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => 'Du bist angemeldet. Fahre mit der Maus über die [[$1|Homepage]], um das Neueste anzusehen oder kontrolliere dein [[$2|Profil]].',
	'userlogin-account-admin-error' => 'Hoppla! Da ist was schief gelaufen. Schreibe an den [[Spezial:Kontakt|Wikia-Support]]. Wir kümmern uns drum.',
	'userlogin-password-email-body-HTML' => '',
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
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Marmase
 * @author Mirzali
 */
$messages['diq'] = array(
	'userlogin-login-heading' => 'Cı kewe',
	'userlogin-forgot-password-button' => 'Dewam ke',
	'userlogin-forgot-password-go-to-login' => 'Zaten Qeyda şıma esta? [[Special:UserLogin|Ronıştış ake]]',
	'userlogin-remembermypassword' => 'Ronıştışer tım akerde verd',
	'userlogin-get-account' => 'Hesabê şıma çıniyo? <a href="$1" tabindex="$2">Qeyd be</a>',
	'userlogin-password-page-title' => 'Parolaya xo bıvurne',
	'userlogin-oldpassword' => 'Parola verên',
	'userlogin-newpassword' => 'Parola newên',
	'userlogin-password-email-greeting' => 'Merheba Bırayo $USERNAME,',
	'userlogin-provider-or' => 'Ya na',
	'userlogin-loginreqlink' => 'Deqewtış',
	'wikiamobile-sendpassword-label' => 'Parolaya newi bırşe',
);

/** British English (British English)
 * @author Shirayuki
 */
$messages['en-gb'] = array(
	'userlogin-error-nosuchuser' => "Hm, we don't recognise this name. Don't forget usernames are case sensitive.",
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Fitoschido
 * @author Invadinado
 * @author Macofe
 * @author VegaDark
 */
$messages['es'] = array(
	'userlogin-desc' => 'Extensión UserLogin',
	'userlogin-login-heading' => 'Iniciar sesión',
	'userlogin-forgot-password' => '¿Olvidaste tu contraseña?',
	'userlogin-forgot-password-button' => 'Continuar',
	'userlogin-forgot-password-go-to-login' => '¿Ya tienes tu contraseña? [[Special:UserLogin|Identifícate]]',
	'userlogin-remembermypassword' => 'Permanece conectado',
	'userlogin-error-noname' => 'Por favor, rellena el campo de nombre de usuario.',
	'userlogin-error-sessionfailure' => 'El registro de la sesión ha caducado. Por favor, inicia sesión de nuevo.',
	'userlogin-error-nosuchuser' => 'No reconocemos este nombre. No olvides que los nombres de usuario distinguen mayúsculas de minúsculas.',
	'userlogin-error-wrongpassword' => 'La contraseña es errónea. Asegúrate de que la tecla Bloq Mayús esté desactivada y vuelve a intentarlo.',
	'userlogin-error-wrongpasswordempty' => 'Perdón, rellena el campo de la contraseña.',
	'userlogin-error-resetpass_announce' => 'Parece que utilizaste una contraseña temporal. Elige aquí una nueva contraseña para continuar la sesión.',
	'userlogin-error-login-throttled' => 'Has intentado iniciar sesión con la contraseña incorrecta demasiadas veces. Espera un rato antes de volver a intentarlo.',
	'userlogin-error-login-userblocked' => 'Tu nombre de usuario ha sido bloqueado y no puede utilizarse para iniciar sesión.',
	'userlogin-error-edit-account-closed-flag' => 'Wikia ha desactivado tu cuenta.',
	'userlogin-error-cantcreateaccount-text' => 'Tu dirección IP no está autorizada para crear cuentas nuevas.',
	'userlogin-error-userexists' => 'Alguien ya tiene este nombre de usuario. ¡Prueba uno diferente!',
	'userlogin-error-invalidemailaddress' => 'Por favor, introduce una dirección de correo electrónico válida.',
	'userlogin-error-wrongcredentials' => 'La combinación del usuario y la contraseñas no es correcta. Por favor intenta de nuevo.',
	'userlogin-error-invalidfacebook' => 'Hubo un problema al detectar tu cuenta de Facebook; por favor inicia sesión en Facebook e intenta de nuevo.',
	'userlogin-error-fbconnect' => 'Hubo un problema al conectar tu cuenta de Wikia con Facebook.',
	'userlogin-get-account' => '¿No tienes una cuenta? <a href="$1" tabindex="$2">Regístrate</a>',
	'userlogin-error-invalid-username' => 'Nombre de usuario inválido',
	'userlogin-error-userlogin-unable-info' => 'Lo sentimos, no es posible registrar tu cuenta en este momento.',
	'userlogin-error-user-not-allowed' => 'Este nombre de usuario no está permitido.',
	'userlogin-error-captcha-createaccount-fail' => 'La palabra que has introducido no coincide con la palabra del recuadro, ¡vuelve a intentarlo!',
	'userlogin-error-userlogin-bad-birthday' => 'Por favor rellena mes, día y año.',
	'userlogin-error-externaldberror' => '¡Lo sentimos! Nuestro sitio actualmente está teniendo un problema. Inténtalo de nuevo más tarde.',
	'userlogin-error-noemailtitle' => 'Por favor, introduce una dirección de correo electrónico válida.',
	'userlogin-error-acct_creation_throttle_hit' => 'Lo sentimos, pero hoy ya se han creado demasiadas cuentas desde esta dirección IP. Por favor, inténtalo más tarde.',
	'userlogin-opt-in-label' => 'Enviarme un correo electrónico acerca de noticias y actividades de Wikia',
	'userlogin-error-resetpass_forbidden' => 'No se pueden cambiar las contraseñas',
	'userlogin-error-blocked-mailpassword' => 'No puedes solicitar una nueva contraseña porque esta dirección IP está bloqueada por Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Ya hemos enviado un recordatorio de contraseña de esta cuenta en {{PLURAL:$1|la última hora|las $1 últimas horas}}. Por favor, revisa tu correo electrónico.',
	'userlogin-error-mail-error' => 'Perdón, hubo un problema al enviar tu correo electrónico. Por favor, [[Special:Contact/general|contáctanos]].',
	'userlogin-password-email-sent' => 'Hemos enviado una nueva contraseña a la dirección de correo electrónico $1.',
	'userlogin-error-unconfirmed-user' => 'No has confirmado tu dirección de correo electrónico. Confirma tu dirección de correo electrónico primero.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Ya se envió un recordatorio de confirmación al correo electrónico.',
	'userlogin-password-page-title' => 'Cambia tu contraseña',
	'userlogin-oldpassword' => 'Contraseña antigua',
	'userlogin-newpassword' => 'Nueva contraseña',
	'userlogin-retypenew' => 'Confirma la contraseña nueva',
	'userlogin-password-email-subject' => 'Solicitud de contraseña olvidada',
	'userlogin-password-email-greeting' => 'Hola, $USERNAME.',
	'userlogin-password-email-content' => 'Utiliza esta contraseña temporal para iniciar sesión en Wikia: "$NEWPASSWORD"
<br /><br />
Si no solicitaste una nueva contraseña, ¡no te preocupes! Tu cuenta está segura. Puedes ignorar este mensaje y continuar iniciando sesión en Wikia con tu antigua contraseña.
<br /><br />
¿Tienes preguntas o inquietudes? No dudes en ponerte en <a href="http://comunidad.wikia.com/wiki/Especial:Contactar/account-issue">contacto con nosotros</a>.',
	'userlogin-password-email-signature' => 'Equipo Comunitario de Wikia',
	'userlogin-password-email-body' => 'Hola $2,

Utiliza esta contraseña temporal para iniciar sesión en Wikia: "$3"

Si no solicitaste una nueva contraseña, ¡no te preocupes! Tu cuenta está segura. Puedes ignorar este mensaje y continuar iniciando sesión en Wikia con tu antigua contraseña.

¿Tienes preguntas o inquietudes? No dudes en contactarnos: http://comunidad.wikia.com/wiki/Especial:Contactar/account-issue

Equipo Comunitario de Wikia


___________________________________________

Para comprobar los acontecimientos más recientes en Wikia, visita http://comunidad.wikia.com
¿Deseas controlar qué mensajes de correo electrónico recibes? Ve a: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Para comprobar las últimas novedades en Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com">es.wikia.com</a>',
	'userlogin-email-footer-line2' => '¿Deseas controlar los correos electrónicos que recibes? Ve a tus <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">preferencias</a>',
	'userlogin-provider-or' => 'o',
	'userlogin-provider-tooltip-facebook' => 'Pulsa el botón para iniciar sesión con Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Pulsa el botón para iniciar sesión con Facebook',
	'userlogin-facebook-show-preferences' => 'Mostrar preferencias de conexión de Facebook',
	'userlogin-facebook-hide-preferences' => 'Ocultar preferencias de conexión de Facebook',
	'userlogin-loginreqlink' => 'iniciar sesión',
	'userlogin-changepassword-needlogin' => 'Necesitas $1 para cambiar la contraseña.',
	'wikiamobile-sendpassword-label' => 'Enviar una nueva contraseña',
	'wikiamobile-facebook-connect-fail' => 'Lo sentimos, pero tu cuenta en Facebook no está actualmente vinculada con una cuenta Wikia.',
	'userlogin-logged-in-title' => '¡Te damos la bienvenida a {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => 'Has iniciado sesión. Dirígete a la [[$1|portada]] para ver lo más reciente o revisa tu [[$2|perfil]].',
	'userlogin-account-admin-error' => '¡Uy! Algo salió mal. Ponte en contacto con [[Especial:Contactar|Wikia]] para recibir ayuda.',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="http://www.twitter.com/wikia_es" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia.es" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="https://www.youtube.com/channel/UCjwNzRwdDqpmELNZsJv3PSg" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://comunidad.wikia.com/wiki/Blog:Noticias_de_Wikia" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
);

/** Basque (euskara)
 * @author Subi
 */
$messages['eu'] = array(
	'userlogin-forgot-password' => 'Zure pasahitza ahaztu duzu?',
	'userlogin-forgot-password-button' => 'Jarraitu',
	'userlogin-error-resetpass_forbidden' => 'Ezin dira pasahitzak aldatu',
	'userlogin-oldpassword' => 'Pasahitz zaharra',
	'userlogin-newpassword' => 'Pasahitz berria',
);

/** Persian (فارسی)
 * @author Mjbmr
 * @author Reza1615
 */
$messages['fa'] = array(
	'userlogin-login-heading' => 'ورود به سامانه',
	'userlogin-forgot-password' => 'گذرواژه‌تان را فراموش کردید؟',
	'userlogin-forgot-password-button' => 'ادامه',
	'userlogin-error-invalidemailaddress' => 'لطفاً یک آدرس ایمیل معتبر وارد کنید.',
	'userlogin-error-invalid-username' => 'نام کاربری نادرست',
	'userlogin-error-noemailtitle' => 'لطفاً یک آدرس ایمیل معتبر وارد کنید.',
	'userlogin-error-resetpass_forbidden' => 'نمی‌توان گذرواژه‌ها را تغییر داد',
	'userlogin-password-page-title' => 'تغییر گذرواژهٔ شما',
	'userlogin-oldpassword' => 'گذرواژهٔ پیشین',
	'userlogin-newpassword' => 'گذرواژهٔ تازه',
	'userlogin-password-email-greeting' => 'سلام $USERNAME،',
	'userlogin-provider-or' => 'یا',
	'userlogin-loginreqlink' => 'به سامانه وارد شوید',
);

/** Finnish (suomi)
 * @author Elseweyr
 * @author Stryn
 * @author Ville96
 */
$messages['fi'] = array(
	'userlogin-login-heading' => 'Kirjaudu sisään',
	'userlogin-forgot-password' => 'Unohditko salasanasi?',
	'userlogin-forgot-password-button' => 'Jatka',
	'userlogin-forgot-password-go-to-login' => 'Onko sinulla jo salasana? [[Special:UserLogin|Kirjaudu sisään]]',
	'userlogin-remembermypassword' => 'Pysy kirjautuneena',
	'userlogin-error-noname' => 'Oho, täytä käyttäjätunnus-kenttä.',
	'userlogin-error-sessionfailure' => 'Sisäänkirjautumisistunto on aikakatkaistu. Kirjaudu sisään uudestaan.',
	'userlogin-error-nosuchuser' => 'Hm, emme tunnista tätä nimeä. Muista että kirjainkoolla on väliä.',
	'userlogin-error-wrongpassword' => 'Oho, väärä salasana. Varmista, että caps lock on pois päältä, ja yritä uudelleen.',
	'userlogin-error-wrongpasswordempty' => 'Oho, täytä salasana-kenttä.',
	'userlogin-error-resetpass_announce' => 'Näyttää siltä että käytit väliaikaista salasanaa. Valitse uusi salasana jatkaaksesi sisäänkirjautumista.',
	'userlogin-error-login-throttled' => 'Olet yrittänyt kirjautua sisään väärällä salasanalla liian monta kertaa. Odota hetki ennen kuin yrität uudelleen.',
	'userlogin-error-login-userblocked' => 'Käyttäjätunnuksesi on estetty eikä sitä voi käyttää sisäänkirjautumiseen.',
	'userlogin-error-edit-account-closed-flag' => 'Wikia on poistanut tilisi käytöstä.',
	'userlogin-error-cantcreateaccount-text' => 'IP-osoitteellasi ei voi luoda uusia käyttäjätilejä.',
	'userlogin-error-userexists' => 'Jollakin on jo tämä käyttäjätunnus. Kokeile toista!',
	'userlogin-error-invalidemailaddress' => 'Syötä kelvollinen sähköpostiosoite.',
	'userlogin-get-account' => 'Eikö sinulla ole tiliä? <a href="$1" tabindex="$2">Rekisteröidy</a>',
	'userlogin-error-invalid-username' => 'Virheellinen käyttäjätunnus',
	'userlogin-error-userlogin-unable-info' => 'Valitettavasti emme voi rekisteröidä tiliäsi tällä hetkellä.',
	'userlogin-error-user-not-allowed' => 'Tämä käyttäjätunnus ei ole sallittu.',
	'userlogin-error-captcha-createaccount-fail' => 'Syöttämäsi sana ei vastaa ruudussa näkyvää sanaa, yritä uudelleen!',
	'userlogin-error-userlogin-bad-birthday' => 'Oho, täytä kuukausi, päivä ja vuosi.',
	'userlogin-error-externaldberror' => 'Pahoittelut! Sivustossamme on tällä hetkellä ongelma, yritä myöhemmin uudelleen.',
	'userlogin-error-noemailtitle' => 'Syötä kelvollinen sähköpostiosoite.',
	'userlogin-error-acct_creation_throttle_hit' => 'Pahoittelut: tämä IP-osoite on tänään luonut liian monta tiliä. Yritä myöhemmin uudelleen.',
	'userlogin-error-resetpass_forbidden' => 'Salasanoja ei voi vaihtaa.',
	'userlogin-error-blocked-mailpassword' => 'Et voi pyytää uutta salasanaa, sillä Wikia on estänyt tämä IP-osoitteen.',
	'userlogin-error-throttled-mailpassword' => 'Olemme jo lähettäneet salasanavihjeen tälle tilille viimeisen {{PLURAL:$1|tunnin|$1 tunnin}} sisällä. Ole hyvä ja tarkista sähköpostisi.',
	'userlogin-error-mail-error' => 'Hups, sähköpostisi lähetyksessä ilmeni ongelma. Ole hyvä ja [[Special:Contact/general|ota meihin yhteyttä]].',
	'userlogin-password-email-sent' => 'Olemme lähettäneet uuden salasanan käyttäjän $1 sähköpostiosoitteeseen.',
	'userlogin-error-unconfirmed-user' => 'Anteeksi, mutta et ole vahvistanut sähköpostiosoitettasi. Ole hyvä ja vahvista sähköpostiosoitteesi ensin.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Muistutus sähköpostin vahvistamisesta on jo lähetetty.',
	'userlogin-password-page-title' => 'Vaihda salasanasi',
	'userlogin-oldpassword' => 'Vanha salasana',
	'userlogin-newpassword' => 'Uusi salasana',
	'userlogin-retypenew' => 'Kirjoita uusi salasana uudelleen',
	'userlogin-password-email-subject' => 'Salasanan vaihtaminen',
	'userlogin-password-email-greeting' => 'Hei $USERNAME,',
	'userlogin-password-email-content' => 'Ole hyvä ja käytä kirjautuessasi Wikiaan seuraavaa tilapäistä salasanaa: "$NEWPASSWORD"
<br /><br />
Mikäli et pyytänyt uutta salasanaa, älä huoli! Tilisi on turvassa. Sinun ei tarvitse välittää tästä sähköpostista, vaan voit jatkaa kirjautumista vanhalla salasanallasi.
<br /><br />
Kysymyksiä tai huolia? Älä epäröi <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">ottaa meihin yhteyttä</a>.',
	'userlogin-password-email-signature' => 'Wikian Tuki',
	'userlogin-password-email-body' => 'Hei $2,

Ole hyvä ja käytä kirjautuessasi Wikiaan seuraavaa tilapäistä salasanaa: "$3"

Mikäli et pyytänyt uutta salasanaa, älä huoli! Tilisi on turvassa. Sinun ei tarvitse välittää tästä sähköpostista, vaan voit jatkaa kirjautumista vanhalla salasanallasi.

Kysymyksiä tai huolia? Älä epäröi ottaa meihin yhteyttä: http://community.wikia.com/wiki/Special:Contact/account-issue

Wikian Tuki


___________________________________________

Nähdäksesi, mitä Wikiassa tapahtuu, käy sivulla http://yhteiso.wikia.com
Haluatko hallinnoida, mitä sähköpostia sinulle tulee? Siirry asetuksiisi: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Nähdäksesi mitä Wikiassa tapahtuu, käy sivulla <a style="color:#2a87d5;text-decoration:none;" href="http://yhteiso.wikia.com">yhteiso.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Haluatko hallinnoida, mitä sähköpostia sinulle tulee? Siirry <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">asetuksiisi</a>',
	'userlogin-provider-or' => 'Tai',
	'userlogin-provider-tooltip-facebook' => 'Klikkaa painiketta kirjautuaksesi Facebookin kautta',
	'userlogin-provider-tooltip-facebook-signup' => 'Klikkaa painiketta rekisteröityäksesi Facebookin kautta',
	'userlogin-facebook-show-preferences' => 'Näytä Facebook-syötteen asetukset',
	'userlogin-facebook-hide-preferences' => 'Piilota Facebook-syötteen asetukset',
	'userlogin-loginreqlink' => 'kirjaudu sisään',
	'userlogin-changepassword-needlogin' => '$1 vaihtaaksesi salasanasi.',
	'wikiamobile-sendpassword-label' => 'Lähetä uusi salasana',
	'wikiamobile-facebook-connect-fail' => 'Valitettavasti Facebook-tilisi ei ole tällä hetkellä yhdistetty mihinkään Wikia-tiliin.',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'userlogin-login-heading' => 'Rita inn',
	'userlogin-forgot-password' => 'Hevur tú gloymt títt loyniorð?',
	'userlogin-forgot-password-button' => 'Halt fram',
	'userlogin-forgot-password-go-to-login' => 'Hevur tú longu fingið títt loyviorð? [[Special:UserLogin|Rita inn]]',
	'userlogin-remembermypassword' => 'Blív verandi innritað/ur',
	'userlogin-error-noname' => 'Ups, vinarliga útfyll teigin til brúkaranavnið.',
	'userlogin-error-sessionfailure' => 'Tín innritanar sessjón er útgingin. Vinarliga rita inn aftur.',
	'userlogin-error-nosuchuser' => 'Hmm, vit kenna ikki hetta brúkaranavnið aftur. Gloym ikki, at munur er á stórum og smáum bókstavum í brúkaranøvnum.',
	'userlogin-error-wrongpassword' => 'Ups, skeivt loyniorð. Tryggjað tær, at caps lock (lásið til stórar bókstavar) er sligið frá og royn aftur.',
	'userlogin-error-wrongpasswordempty' => 'Ups, vinarliga útfyll teigin til loyniorðið.',
	'userlogin-error-resetpass_announce' => 'Tað sær út til, at tú nýtir eitt fyribils loyniorð. Vel eitt nýtt loyniorð her fyri at halda fram við innritanini.',
	'userlogin-error-login-throttled' => 'Tú hevur roynt at rita inn við skeivum loyniorði ov nógvar ferðir. Bíða eitt sindur, áðrenn tú roynir aftur.',
	'userlogin-error-login-userblocked' => 'Títt brúkaranavn er blivið sperrað og kann ikki nýtast til innritan.',
	'userlogin-error-edit-account-closed-flag' => 'Wikia hevur gjørt tína konto óvirknað.',
	'userlogin-error-cantcreateaccount-text' => 'Tín IP adressa hevur ikki loyvi til at upprætta nýggjar kontur.',
	'userlogin-error-userexists' => 'Onkur hevur longu hetta brúkaranavnið. Royn eitt annað!',
	'userlogin-error-invalidemailaddress' => 'Vinarliga skriva eina galdandi t-post adressu.',
	'userlogin-get-account' => 'Hevur tú ikki eina konto? <a href="$1" tabindex="$2">Skráset teg</a>',
	'userlogin-error-invalid-username' => 'Skeivt brúkaranavn',
	'userlogin-password-page-title' => 'Broyt títt loyniorð',
	'userlogin-oldpassword' => 'Gamalt loyniorð',
	'userlogin-newpassword' => 'Nýtt loyniorð',
	'userlogin-retypenew' => 'Skriva nýtt loyniorð umaftur',
	'userlogin-password-email-subject' => 'Gloymt loyniorð umbøn',
	'userlogin-password-email-greeting' => 'Hey $USERNAME,',
	'userlogin-provider-or' => 'Ella',
	'userlogin-provider-tooltip-facebook' => 'Trýst á knøttin fyri at rita inn við Facebook',
	'userlogin-loginreqlink' => 'rita inn',
	'wikiamobile-sendpassword-label' => 'Send nýtt loyniorð',
);

/** French (français)
 * @author Gomoko
 * @author Linedwell
 * @author Wyz
 */
$messages['fr'] = array(
	'userlogin-desc' => 'Extension UserLogin',
	'userlogin-login-heading' => 'Connexion',
	'userlogin-forgot-password' => 'Vous avez oublié votre mot de passe ?',
	'userlogin-forgot-password-button' => 'Continuer',
	'userlogin-forgot-password-go-to-login' => 'Vous avez déjà votre mot de passe ? [[Special:UserLogin|Connectez-vous]]',
	'userlogin-remembermypassword' => 'Rester connecté',
	'userlogin-error-noname' => "Oups, veuillez remplir le champ « nom d'utilisateur ».",
	'userlogin-error-sessionfailure' => 'Votre session de connexion a expiré. Veuillez vous reconnecter.',
	'userlogin-error-nosuchuser' => 'Nous ne reconnaissons pas ce nom. N’oubliez pas que les noms d’utilisateur sont sensibles à la casse.',
	'userlogin-error-wrongpassword' => 'Oups, mauvais mot de passe. Assurez-vous que les majuscules ne sont pas activées et réessayez.',
	'userlogin-error-wrongpasswordempty' => 'Oups, veuillez remplir le champ « mot de passe ».',
	'userlogin-error-resetpass_announce' => 'Il semblerait que vous ayez utilisé un mot de passe temporaire. Choisissez un nouveau mot de passe ici pour poursuivre la connexion.',
	'userlogin-error-login-throttled' => "Vous avez essayé d'ouvrir une session avec un mot de passe erroné trop de fois. Attendez un peu avant de retenter.",
	'userlogin-error-login-userblocked' => 'Votre nom d’utilisateur a été bloqué et ne peut pas être utilisé pour vous connecter.',
	'userlogin-error-edit-account-closed-flag' => 'Votre compte a été désactivé par Wikia.',
	'userlogin-error-cantcreateaccount-text' => "Votre adresse IP n'est pas autorisée à créer de nouveaux comptes.",
	'userlogin-error-userexists' => 'Ce nom d’utilisateur est déjà utilisé par quelqu’un. Essayez-en un autre !',
	'userlogin-error-invalidemailaddress' => 'Veuillez entrer une adresse e-mail valide.',
	'userlogin-error-wrongcredentials' => 'Cette combinaison nom d’utilisateur et mot de passe n’est pas correcte. Veuillez réessayer.',
	'userlogin-error-invalidfacebook' => 'Il y a eu un problème lors de la détection de votre compte Facebook ; veuillez vous connecter à Facebook et réessayer.',
	'userlogin-error-fbconnect' => 'Il y a eu un problème lors de la connexion de votre compte Wikia à Facebook.',
	'userlogin-get-account' => 'Vous n\'avez pas encore de compte? <a href="$1" tabindex="$2">Inscrivez-vous</a>',
	'userlogin-error-invalid-username' => 'Nom d’utilisateur non valide',
	'userlogin-error-userlogin-unable-info' => "Désolé, nous ne sommes pas en mesure d'enregistrer votre compte pour le moment.",
	'userlogin-error-user-not-allowed' => "Ce nom d'utilisateur n'est pas autorisé.",
	'userlogin-error-captcha-createaccount-fail' => 'Le mot que vous avez saisi ne correspond pas à celui dans le cadre, veuillez réessayer !',
	'userlogin-error-userlogin-bad-birthday' => "Oups, veuillez remplir le jour, le mois et l'année.",
	'userlogin-error-externaldberror' => 'Désolé ! Notre site rencontre actuellement un problème. Veuillez réessayer plus tard.',
	'userlogin-error-noemailtitle' => 'Veuillez entrer une adresse e-mail valide.',
	'userlogin-error-acct_creation_throttle_hit' => 'Désolé, cette adresse IP a créé trop de comptes aujourd’hui. Veuillez réessayer plus tard.',
	'userlogin-opt-in-label' => 'Recevoir les actualités et événements de Wikia par e-mail',
	'userlogin-error-resetpass_forbidden' => 'Les mots de passe ne peuvent pas être changés',
	'userlogin-error-blocked-mailpassword' => 'Vous ne pouvez pas demander un nouveau mot de passe parce que cette adresse IP est bloquée par Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Nous avons déjà envoyé un rappel de mot de passe pour ce compte durant {{PLURAL:$1|la dernière heure|les $1 dernières heures}}. Veuillez vérifier vos e-mails.',
	'userlogin-error-mail-error' => "Oups, il y a eu un problème lors de l'envoi de l'e-mail. Veuillez [[Special:Contact/general|nous contacter]].",
	'userlogin-password-email-sent' => "Nous avons envoyé un nouveau mot de passe à l'adresse e-mail de $1.",
	'userlogin-error-unconfirmed-user' => "Désolé, vous n'avez pas confirmé votre adresse e-mail. Veuillez la confirmer d'abord.",
	'userlogin-error-confirmation-reminder-already-sent' => "L'e-mail de rappel de confirmation a déjà été envoyé.",
	'userlogin-password-page-title' => 'Modifier votre mot de passe',
	'userlogin-oldpassword' => 'Ancien mot de passe',
	'userlogin-newpassword' => 'Nouveau mot de passe',
	'userlogin-retypenew' => 'Ressaisissez votre nouveau mot de passe',
	'userlogin-password-email-subject' => 'Demande de mot de passe oublié',
	'userlogin-password-email-greeting' => 'Bonjour $USERNAME,',
	'userlogin-password-email-content' => 'Veuillez utiliser ce mot de passe temporaire pour vous connecter sur Wikia : "$NEWPASSWORD"
<br /><br />
Si vous n\'avez pas demandé de nouveau mot de passe, ne vous inquiétez pas ! Votre compte est sain et sauf. Vous pouvez ignorer cet e-mail et continuer à vous connecter sur Wikia avec votre ancien mot de passe.
<br /><br />
Vous avez des questions ? N’hésitez pas à <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">nous contacter</a>.',
	'userlogin-password-email-signature' => 'Support de la communauté Wikia',
	'userlogin-password-email-body' => "Bonjour $2,

Veuillez utiliser ce mot de passe temporaire pour vous connecter à Wikia : $3

Si vous n'avez pas demandé de nouveau mot de passe, ne vous inquiétez pas ! Votre compte est sain et sauf. Vous pouvez ignorer cet e-mail et continuer à vous connecter sur Wikia avec votre ancien mot de passe.

Vous avez des questions ? N’hésitez pas à nous contacter : http://community.wikia.com/wiki/Special:Contact/account-issue

Support de la communauté Wikia


___________________________________________

Pour voir les dernières actualités de Wikia, allez sur http://communaute.wikia.com
Vous souhaitez contrôler les e-mails que vous recevez ? Allez sur : {{fullurl:{{ns:special}}:Preferences}}",
	'userlogin-email-footer-line1' => 'Pour voir les dernières actualités de Wikia, allez sur <a style="color:#2a87d5;text-decoration:none;" href="http://communaute.wikia.com">communaute.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Vous souhaitez contrôler les e-mails que vous recevez ? Allez dans vos <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">préférences</a>',
	'userlogin-provider-or' => 'Ou',
	'userlogin-provider-tooltip-facebook' => 'Cliquez sur le bouton pour vous connecter avec Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Cliquez sur le bouton pour vous connecter avec Facebook',
	'userlogin-facebook-show-preferences' => 'Afficher les préférences de flux de Facebook',
	'userlogin-facebook-hide-preferences' => 'Masquer les préférences de flux de Facebook',
	'userlogin-loginreqlink' => 'vous connecter',
	'userlogin-changepassword-needlogin' => 'Vous devez $1 pour changer votre mot de passe.',
	'wikiamobile-sendpassword-label' => 'Envoyer un nouveau mot de passe',
	'wikiamobile-facebook-connect-fail' => 'Désolé, votre compte Facebook n’est pour le moment pas relié à un compte Wikia.',
	'userlogin-logged-in-title' => 'Bienvenue sur {{SITENAME}}, $1 !',
	'userlogin-logged-in-message' => 'Vous êtes connecté. Allez sur la [[$1|page d’accueil]] pour voir les nouveautés ou vérifiez votre [[$2|profil]].',
	'userlogin-account-admin-error' => 'Oups ! Un problème est survenu. Veuillez contacter le support de [[Special:Contact|Wikia]].',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="<a href="http://twitter.com/wikia_fr" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia.fr" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/channel/UClzAEgYaMs0SyDnXS4cyefg" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://communaute.wikia.com" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
);

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = array(
	'userlogin-logged-in-title' => 'Wolkom by {{SITENAME}}, $1!',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'userlogin-login-heading' => 'Rexistro',
	'userlogin-forgot-password' => 'Esqueceu o contrasinal?',
	'userlogin-forgot-password-button' => 'Continuar',
	'userlogin-forgot-password-go-to-login' => 'Xa ten o seu contrasinal? [[Special:UserLogin|Acceda ao sistema]]',
	'userlogin-remembermypassword' => 'Permanecer conectado',
	'userlogin-error-noname' => 'Vaites! Cómpre encher o campo do nome de usuario.',
	'userlogin-error-sessionfailure' => 'A súa sesión caducou. Acceda ao sistema de novo.',
	'userlogin-error-nosuchuser' => 'Non recoñecemos ese nome. Lembre que os nomes de usuario distinguen entre maiúsculas e minúsculas.',
	'userlogin-error-wrongpassword' => 'Vaites! O contrasinal non é correcto. Asegúrese de que tecla das maiúsculas está desactivada e inténteo de novo.',
	'userlogin-error-wrongpasswordempty' => 'Vaites! Cómpre encher o campo do contrasinal.',
	'userlogin-error-resetpass_announce' => 'Semella que empregou un contrasinal temporal. Escolla un novo contrasinal aquí para continuar coa sesión.',
	'userlogin-error-login-throttled' => 'Intentou acceder ao sistema cun contrasinal incorrecto demasiadas veces. Ten que agardar un anaco antes de intentalo de novo.',
	'userlogin-error-login-userblocked' => 'O seu nome de usuario está bloqueado e non se pode empregar para acceder ao sistema.',
	'userlogin-error-edit-account-closed-flag' => 'Wikia desactivou a súa conta.',
	'userlogin-error-cantcreateaccount-text' => 'O seu enderezo IP non está autorizado a crear novas contas.',
	'userlogin-error-userexists' => 'Alguén xa ten ese nome de usuario. Probe con outro!',
	'userlogin-error-invalidemailaddress' => 'Por favor, escriba un enderezo de correo electrónico válido.',
	'userlogin-get-account' => 'Non ten unha conta? <a href="$1" tabindex="$2">Rexístrese</a>',
	'userlogin-error-invalid-username' => 'Nome de usuario non válido',
	'userlogin-error-userlogin-unable-info' => 'Sentímolo, non é posible rexistrar a súa conta nestes intres.',
	'userlogin-error-user-not-allowed' => 'Este nome de usuario non está permitido.',
	'userlogin-error-captcha-createaccount-fail' => 'A palabra que escribiu non coincide co texto da caixa. Inténteo de novo!',
	'userlogin-error-userlogin-bad-birthday' => 'Vaites! Cómpre encher o día, o mes e o ano.',
	'userlogin-error-externaldberror' => 'Sentímolo! O noso sitio está tendo problemas nestes intres. Inténteo de novo máis tarde.',
	'userlogin-error-noemailtitle' => 'Por favor, escriba un enderezo de correo electrónico válido.',
	'userlogin-error-acct_creation_throttle_hit' => 'Sentímolo, este enderezo IP creou demasiadas contas no día de hoxe. Inténteo de novo máis tarde.',
	'userlogin-error-resetpass_forbidden' => 'Non se poden mudar os contrasinais',
	'userlogin-error-blocked-mailpassword' => 'Non pode solicitar un novo contrasinal porque Wikia bloqueou este enderezo IP.',
	'userlogin-error-throttled-mailpassword' => 'Xa enviamos un recordatorio do contrasinal desta conta {{PLURAL:$1|na última hora|nas $1 últimas horas}}. Comprobe o seu correo electrónico.',
	'userlogin-error-mail-error' => 'Vaites! Houbo un problema ao enviar o correo electrónico. Por favor, [[Special:Contact/general|póñase en contacto con nós]].',
	'userlogin-password-email-sent' => 'Enviamos un novo contrasinal ao enderezo de correo electrónico $1.',
	'userlogin-error-unconfirmed-user' => 'Aínda non confirmou o seu enderezo de correo electrónico. Confirme o enderezo primeiro.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Xa se enviou o recordatorio de confirmación por correo electrónico.',
	'userlogin-password-page-title' => 'Cambiar o seu contrasinal',
	'userlogin-oldpassword' => 'Contrasinal antigo',
	'userlogin-newpassword' => 'Contrasinal novo',
	'userlogin-retypenew' => 'Insira outra vez o novo contrasinal',
	'userlogin-password-email-subject' => 'Solicitude de contrasinal esquecido',
	'userlogin-password-email-greeting' => 'Boas, $USERNAME:',
	'userlogin-password-email-content' => 'Utilice este contrasinal temporal para acceder ao sistema en Wikia: "$NEWPASSWORD"
<br /><br />
Se non solicitou un contrasinal novo, non se preocupe! A súa conta está a salvo e é segura. Pode ignorar este correo electrónico e seguir accedendo ao sistema de Wikia co seu contrasinal antigo.
<br /><br />
Ten preguntas ou preocupacións? Síntase libre de poñerse en <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">contacto con nós</a>.',
	'userlogin-password-email-signature' => 'O equipo de soporte comunitario de Wikia',
	'userlogin-password-email-body' => 'Boas, $2:

Utilice este contrasinal temporal para acceder ao sistema en Wikia: "$3"

Se non solicitou un contrasinal novo, non se preocupe! A súa conta está a salvo e é segura. Pode ignorar este correo electrónico e seguir accedendo ao sistema de Wikia co seu contrasinal antigo.

Ten preguntas ou preocupacións? Síntase libre de poñerse en contacto con nós: http://community.wikia.com/wiki/Special:Contact/account-issue

O equipo de soporte comunitario de Wikia


___________________________________________

Para botar unha ollada aos últimos acontecementos en Wikia, visite http://community.wikia.com
Quere controlar os correos electrónicos que recibe? Vaia a {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Para botar unha ollada aos últimos acontecementos en Wikia, visite <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Quere controlar os correos electrónicos que recibe? Vaia ás súas <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">preferencias</a>',
	'userlogin-provider-or' => 'Ou',
	'userlogin-provider-tooltip-facebook' => 'Prema no botón para acceder co Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Prema no botón para rexistrarse co Facebook',
	'userlogin-facebook-show-preferences' => 'Mostrar as preferencias de fonte de novas do Facebook',
	'userlogin-facebook-hide-preferences' => 'Agochar as preferencias de fonte de novas do Facebook',
	'userlogin-loginreqlink' => 'acceder ao sistema',
	'userlogin-changepassword-needlogin' => 'Cómpre $1 para cambiar o contrasinal.',
	'wikiamobile-sendpassword-label' => 'Enviar un novo contrasinal',
	'wikiamobile-facebook-connect-fail' => 'Sentímolo, a súa conta do Facebook non está ligada con ningunha de Wikia.',
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'userlogin-login-heading' => 'Bejelentkezés',
	'userlogin-forgot-password' => 'Elfelejtetted a jelszavad?',
	'userlogin-remembermypassword' => 'Maradjon bejelentkezve',
	'userlogin-error-noname' => 'Hoppá! Kérlek, töltsd ki a "Felhasználónév" mezőt.',
	'userlogin-error-sessionfailure' => 'A munkameneted túllépte az időkorlátot. Kérlek, jelentkezz be újra.',
	'userlogin-error-nosuchuser' => 'Nem ismerjük ezt a nevet. Ne feledd, a felhasználónevekben megkülönböztetjük a kis&ndash; és nagybetűket.',
	'userlogin-error-wrongpassword' => 'Hoppá! Rossz a jelszó. Ellenőrizd, hogy a Caps Lock ki van&ndash;e kapcsolva, majd próbálkozz újra.',
	'userlogin-error-wrongpasswordempty' => 'Hoppá! Kérlek, töltsd ki a "Jelszó" mezőt.',
	'userlogin-error-resetpass_announce' => 'Úgy tűnik, ideiglenes jelszót használtál. Válassz egy új jelszót, hogy bejelentkezhess.',
	'userlogin-error-login-throttled' => 'Túl sokszor próbáltál meg rossz jelszóval bejelentkezni. Várj egy kicsit, mielőtt újra próbálkoznál.',
	'userlogin-error-login-userblocked' => 'A felhasználóneved blokkolva van és nem használható bejelentkezéskor.',
	'userlogin-error-edit-account-closed-flag' => 'A felhasználói fiókodat letiltotta a Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Az IP-címed nem hozhat létre új felhasználókat.',
	'userlogin-error-userexists' => 'Ezt a felhasználónevet már használják. Próbálkozz másikkal!',
	'userlogin-error-invalidemailaddress' => 'Kérlek, érvényes e-mail címet adj meg',
	'userlogin-get-account' => 'Nincsen felhasználói fiókod? <a href="$1" tabindex="$2">Regisztrálj</a>',
	'userlogin-error-invalid-username' => 'Érvénytelen felhasználónév',
	'userlogin-error-userlogin-unable-info' => 'Sajnáljuk, de jelenleg nem regisztráltatható a felhasználói fiókod.',
	'userlogin-error-user-not-allowed' => 'Ez a felhasználónév nem engedélyezett.',
	'userlogin-error-captcha-createaccount-fail' => 'Az általad beírt szó nem egyezett meg a mező tartalmával. Próbáld újra!',
	'userlogin-error-userlogin-bad-birthday' => 'Hoppá! Kérlek, töltsd ki a "hónap," "nap" és "év" mezőket is.',
	'userlogin-error-externaldberror' => 'Sajnáljuk, de az oldalnak jelenleg problémái vannak. Kérlek, próbálkozz újra később.',
	'userlogin-error-noemailtitle' => 'Kérlek, érvényes e-mail címet adj meg.',
	'userlogin-error-acct_creation_throttle_hit' => 'Sajnáljuk, túl sok felhasználó jött létre ma erről az IP-címről. Kérlek, próbáld újra később.',
	'userlogin-error-resetpass_forbidden' => 'A jelszavak nem változtathatóak meg',
	'userlogin-error-blocked-mailpassword' => 'Nem kérhetsz új jelszót, mivel ezt az IP-címet blokkolta a Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Már küldtünk jelszóemlékeztetőt ehhez a fiókhoz az elmúlt $1 órában. Kérlek, ellenőrizd az e-mailjeidet.',
	'userlogin-error-mail-error' => 'Hoppá! Hiba történt a neked szánt e-mail elküldése közben. Kérlek, [[Special:Contact/general|lépj kapcsolatba velünk]].',
	'userlogin-password-email-sent' => 'Új jelszót küldtünk $1 e-mail címére.',
	'userlogin-error-unconfirmed-user' => 'Sajnáljuk, nem erősítetted meg az e-mail címedet. Kérlek, először erősítsd meg.',
	'userlogin-password-page-title' => 'Jelszó megváltoztatása',
	'userlogin-oldpassword' => 'Régi jelszó',
	'userlogin-newpassword' => 'Új jelszó',
	'userlogin-retypenew' => 'Új jelszó megerősítése',
	'userlogin-password-email-subject' => 'Elfelejtett jelszó',
	'userlogin-password-email-greeting' => 'Szia, $USERNAME!',
	'userlogin-password-email-content' => 'Kérlek, használd az alábbi ideiglenes jelszót a Wikiára való bejelentkezéskor: "$NEWPASSWORD"
<br /><br />
Ha nem igényeltél új jelszót, ne aggódj! A felhasználói fiókod biztonságban van. Nyugodtan figyelmen kívül hagyhatod ezt az e-mailt és továbbra is használhatod a régi jelszavad bejelentkezéskor.
<br /><br />
Kérdésed vagy problémád van? Lépj velünk kapcsolatba!',
	'userlogin-password-email-signature' => 'Wikia közösségi támogatás',
	'userlogin-password-email-body' => 'Szia, $2!

Kérlek, használd az alábbi ideiglenes jelszót a Wikiára való bejelentkezéskor: "$3"

Ha nem igényeltél új jelszót, ne aggódj! A felhasználói fiókod biztonságban van. Nyugodtan figyelmen kívül hagyhatod ezt az e-mailt és továbbra is használhatod a régi jelszavad bejelentkezéskor.

Kérdésed vagy problémád van? Lépj velünk kapcsolatba!

Wikia közösségi támogatás


___________________________________________

A Wikia legfrissebb eseményeinek megtekintésére látogass el a http://community.wikia.com oldalra.
Szeretnéd módosítani a kapott e-mailekre vonatkozó beállításaidat? Ugrás: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'A Wikia legfrissebb eseményeinek megtekintésére látogass el a <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> oldalra.',
	'userlogin-email-footer-line2' => 'Szeretnéd módosítani a kapott e-mailekre vonatkozó beállításaidat? Változtass a <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">beállításaidon</a>',
	'userlogin-provider-or' => 'vagy',
	'userlogin-provider-tooltip-facebook' => 'Kattints a gombra a Facebook használatával történő bejelentkezéshez',
	'userlogin-provider-tooltip-facebook-signup' => 'Kattints a gombra a Facebookra történő regisztrációhoz',
	'userlogin-facebook-show-preferences' => 'Facebook-hírcsatorna beállításainak megjelenítése',
	'userlogin-facebook-hide-preferences' => 'Facebook-hírcsatorna beállításainak elrejtése',
	'userlogin-loginreqlink' => 'bejelentkezés',
	'wikiamobile-sendpassword-label' => 'Új jelszó küldése',
	'wikiamobile-facebook-connect-fail' => 'Sajnos a Facebook fiókod nincs összekötve egy Wikia fiókkal sem.',
);

/** Armenian (Հայերեն)
 * @author Vadgt
 */
$messages['hy'] = array(
	'userlogin-forgot-password' => 'Մոռացե՞լ եք ձեր գաղտնաբառը',
	'userlogin-password-email-greeting' => 'Բարև $USERNAME',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'userlogin-login-heading' => 'Aperir session',
	'userlogin-forgot-password' => 'Contrasigno oblidate?',
	'userlogin-remembermypassword' => 'Session permanente',
	'userlogin-error-noname' => 'Per favor specifica le nomine de usator.',
	'userlogin-error-sessionfailure' => 'Le session ha expirate. Per favor aperi session de novo.',
	'userlogin-error-nosuchuser' => 'Iste nomine non es recognoscite. Non oblida que le nomines de usator distingue inter majusculas e minusculas.',
	'userlogin-error-wrongpassword' => 'Contrasigno incorrecte. Assecura te que le "caps lock" es inactive e reproba.',
	'userlogin-error-wrongpasswordempty' => 'Per favor specifica le contrasigno.',
	'userlogin-error-resetpass_announce' => 'Il pare que tu usava un contrasigno temporari. Elige un nove contrasigno pro continuar le session.',
	'userlogin-error-login-throttled' => 'Tu ha tentate aperir session con un contrasigno incorrecte troppo de vices. Attende un momento ante de reprobar.',
	'userlogin-error-login-userblocked' => 'Iste nomine de usator ha essite blocate e non pote esser usate pro aperir session.',
	'userlogin-error-edit-account-closed-flag' => 'Iste conto ha essite disactivate per Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Iste adresse IP non ha le permission de crear nove contos.',
	'userlogin-error-userexists' => 'Qualcuno ja possede iste nomine de usator. Tenta un altere!',
	'userlogin-error-invalidemailaddress' => 'Per favor entra un adresse de e-mail valide.',
	'userlogin-get-account' => 'Tu non ha un conto? <a href="$1" tabindex="$2">Inscribe te</a>',
	'userlogin-error-invalid-username' => 'Nomine de usator invalide',
	'userlogin-error-userlogin-unable-info' => 'Regrettabilemente, nos non pote crear tu conto pro le momento.',
	'userlogin-error-user-not-allowed' => 'Iste nomine de usator non es permittite.',
	'userlogin-error-captcha-createaccount-fail' => 'Le parola que tu scribeva non corresponde al parola in le quadro. Essaya de novo.',
	'userlogin-error-userlogin-bad-birthday' => 'Per favor specifica un mense, die e anno.',
	'userlogin-error-externaldberror' => 'Nostre sito ha actualmente un problema. Per favor reproba plus tarde.',
	'userlogin-error-noemailtitle' => 'Per favor entra un adresse de e-mail valide.',
	'userlogin-error-acct_creation_throttle_hit' => 'Iste adresse IP ha create troppo de contos hodie. Per favor reproba plus tarde.',
	'userlogin-error-resetpass_forbidden' => 'Le contrasignos non pote esser cambiate',
	'userlogin-error-blocked-mailpassword' => 'Tu non pote requestar un nove contrasigno perque iste adresse IP es blocate per Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Nos ha jam inviate un rememoration de contrasigno a iste conto in le ultime {{PLURAL:$1|hora|$1 horas}}. Per favor verifica tu e-mail.',
	'userlogin-error-mail-error' => 'Un problema occurreva durante le invio de tu e-mail. Per favor [[Special:Contact/general|contacta nos]].',
	'userlogin-password-email-sent' => 'Nos ha inviate un nove contrasigno al adresse de e-mail pro $1.',
	'userlogin-error-unconfirmed-user' => 'Tu non ha ancora confirmate tu adresse de e-mail. Per favor confirma lo primo.',
	'userlogin-password-page-title' => 'Cambiar tu contrasigno',
	'userlogin-oldpassword' => 'Ancian contrasigno',
	'userlogin-newpassword' => 'Nove contrasigno',
	'userlogin-retypenew' => 'Repete le nove contrasigno',
	'userlogin-password-email-subject' => 'Requesta de contrasigno oblidate',
	'userlogin-password-email-greeting' => 'Salute $USERNAME,',
	'userlogin-password-email-content' => 'Per favor usa iste contrasigno temporari pro aperir session in Wikia: "$NEWPASSWORD"
<br /><br />
Si tu non requestava un nove contrasigno, nulle problema! Tu conto es san e salve. Tu pote ignorar iste e-mail e continuar a aperir session in Wikia con tu ancian contrasigno.
<br /><br />
Questiones o preoccupationes? Sia libere de contactar nos.',
	'userlogin-password-email-signature' => 'Supporto communitari de Wikia',
	'userlogin-password-email-body' => 'Salute $2,

Per favor usa iste contrasigno temporari pro aperir session in Wikia: "$3"

Si tu non requestava un nove contrasigno, nulle problema! Tu conto es san e salve. Tu pote ignorar iste e-mail e continuar a aperir session in Wikia con tu ancian contrasigno.

Questiones o preoccupationes? Sia libere de contactar nos.

Le equipa de supporto communitari de Wikia


___________________________________________

Pro cognoscer le ultime evenimentos in Wikia, visita http://community.wikia.com
Vole seliger le e-mail que tu recipe? Va a: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Pro cognoscer le ultime evenimentos in Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Vole seliger le e-mails que tu recipe? Face lo in tu <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferentias</a>',
	'userlogin-provider-or' => 'O',
	'userlogin-provider-tooltip-facebook' => 'Clicca sur le button pro aperir session con Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Clicca sur le button pro inscriber te con Facebook',
	'userlogin-facebook-show-preferences' => 'Monstrar preferentias de syndication de Facebook',
	'userlogin-facebook-hide-preferences' => 'Celar preferentias de syndication de Facebook',
	'userlogin-loginreqlink' => 'aperir session',
	'userlogin-changepassword-needlogin' => 'Tu debe $1 pro cambiar tu contrasigno.',
	'wikiamobile-sendpassword-label' => 'Inviar nove contrasigno',
	'wikiamobile-facebook-connect-fail' => 'Tu conto de Facebook non es actualmente ligate con un conto de Wikia.',
);

/** Italian (italiano)
 * @author Beta16
 * @author Lexaeus 94
 * @author Minerva Titani
 */
$messages['it'] = array(
	'userlogin-login-heading' => 'Accedi',
	'userlogin-forgot-password' => 'Hai dimenticato la password?',
	'userlogin-remembermypassword' => 'Rimani connesso',
	'userlogin-error-noname' => 'Ops, per favore inserisci il tuo nome utente.',
	'userlogin-error-sessionfailure' => 'La tua sessione di connessione è scaduta. Per favore effettua di nuovo il login.',
	'userlogin-error-nosuchuser' => 'Non riconosciamo questo nome utente. Non dimenticarti che i nomi utenti distinguono tra maiuscole e minuscole.',
	'userlogin-error-wrongpassword' => 'Ops, password sbagliata. Assicurati che il blocco delle maiuscole sia disattivato e riprova.',
	'userlogin-error-wrongpasswordempty' => 'Ops, per favore inserisci la password.',
	'userlogin-error-resetpass_announce' => 'Sembra che tu abbia usato una password temporanea. Scegli qui una nuova password per continuare con il login.',
	'userlogin-error-login-throttled' => "Hai provato ad effettuare l'accesso troppe volte con una password sbagliata. Devi aspettare un po' prima di poter riprovare.",
	'userlogin-error-login-userblocked' => 'Il tuo username è stato bloccato e non può essere usato per il login.',
	'userlogin-error-edit-account-closed-flag' => 'Il tuo account è stato disattivato da Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Il tuo indirizzo IP non può creare nuovi account.',
	'userlogin-error-userexists' => 'Questo username è già utilizzato da un altro utente. Provane un altro!',
	'userlogin-error-invalidemailaddress' => 'Per favore inserisci un indirizzo email valido.',
	'userlogin-get-account' => 'Non hai un account? <a href="$1" tabindex="$2">Registrati</a>',
	'userlogin-error-invalid-username' => 'Nome utente non valido',
	'userlogin-error-userlogin-unable-info' => 'Ci dispiace, ma non è stato possibile registrare il tuo account in questo momento.',
	'userlogin-error-user-not-allowed' => 'Questo username non è permesso.',
	'userlogin-error-captcha-createaccount-fail' => 'La parola che hai inserito non corrisponde alla parola nel riquadro, prova di nuovo!',
	'userlogin-error-userlogin-bad-birthday' => 'Ops, per favore inserisci mese, giorno e anno.',
	'userlogin-error-externaldberror' => 'Ci dispiace! Il nostro sito attualmente sta avendo dei problemi. Per favore riprova più tardi.',
	'userlogin-error-noemailtitle' => 'Per favore inserisci un indirizzo email valido.',
	'userlogin-error-acct_creation_throttle_hit' => 'Ci dispiace, questo indirizzo IP ha creato troppi account oggi. Riprova più tardi.',
	'userlogin-error-resetpass_forbidden' => 'Non è possibile modificare la password.',
	'userlogin-error-blocked-mailpassword' => 'Non puoi richiedere una nuova password perché questo indirizzo IP è stato bloccato da Wikia.',
	'userlogin-error-throttled-mailpassword' => "Abbiamo già inviato un promemoria per la password a questo account {{PLURAL:$1|nell'ultima ora|nelle ultime $1 ore}}. Per favore controlla la tua email.",
	'userlogin-error-mail-error' => "Ops, c'è stato un problema nell'inviarti l'email. Per favore [[Special:Contact/general|contattaci]].",
	'userlogin-password-email-sent' => "Abbiamo inviato una nuova password all'indirizzo email di $1.",
	'userlogin-error-unconfirmed-user' => 'Ci dispiace, non hai confermato il tuo indirizzo email. Per favore, prima confermalo.',
	'userlogin-password-page-title' => 'Cambia la password',
	'userlogin-oldpassword' => 'Vecchia password',
	'userlogin-newpassword' => 'Nuova password',
	'userlogin-retypenew' => 'Ridigita la nuova password',
	'userlogin-password-email-subject' => 'Richiesta per password dimenticata',
	'userlogin-password-email-greeting' => 'Ciao $USERNAME,',
	'userlogin-password-email-content' => 'Per favore usa questa password temporanea per effettuare il login su Wikia: "$NEWPASSWORD"
<br /><br />
Se non hai richiesto una nuova password, non preoccuparti! Il tuo account è al sicuro. Puoi ignorare questa email e continuare a effettuare il login su Wikia con la tua vecchia password.
<br /><br />
Domande o dubbi? Sentiti libero di <a href="http://it.community.wikia.com/wiki/Special:Contact/account-issue">contattarci</a>.',
	'userlogin-password-email-signature' => 'Wikia Community Support',
	'userlogin-password-email-body' => 'Ciao $2,

Per favore usa questa password temporarea per effettuare il login su Wikia: "$3"

Se non hai richiesto una nuova password, non preoccuparti! Il tuo account è al sicuro. Puoi ignorare questa email e continuare a effettuare il login su Wikia con la tua vecchia password.

Domande o dubbi? Sentiti libero di contattarci: http://it.community.wikia.com/wiki/Special:Contact/account-issue

Wikia Community Support


___________________________________________

Per tenerti informato sulle novità di Wikia, visita http://it.community.wikia.com
Vuoi controllare quali email ricevi? Vai a: {{fullurl:{{ns:special}}:Preferenze}}',
	'userlogin-email-footer-line1' => 'Per tenerti informato sulle novità di Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://it.community.wikia.com">it.community.wikia.com</a>',
	'userlogin-email-footer-line2' => '
Vuoi controllare quali email ricevi? Vai alle tue <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferenze</a>',
	'userlogin-provider-or' => 'O',
	'userlogin-provider-tooltip-facebook' => 'Fare clic sul pulsante per effettuare il login con Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Fare clic sul pulsante per registrarsi con Facebook.',
	'userlogin-facebook-show-preferences' => 'Mostra le preferenze dei feed di Facebook',
	'userlogin-facebook-hide-preferences' => 'Nascondi le preferenze dei feed di Facebook.',
	'userlogin-loginreqlink' => 'Accedi',
	'userlogin-changepassword-needlogin' => '$1 per cambiare la tua password.',
	'wikiamobile-sendpassword-label' => 'Invia nuova password',
	'wikiamobile-facebook-connect-fail' => 'Siamo spiacenti, il tuo account di Facebook non è attualmente collegato ad un account di Wikia.',
	'userlogin-desc' => 'Estensione UserLogin',
	'userlogin-forgot-password-button' => 'Continua',
	'userlogin-forgot-password-go-to-login' => 'Hai già la password? [[Special:UserLogin|Accedi]]',
	'userlogin-error-wrongcredentials' => 'Questa combinazione di nome utente e password non è corretta. Riprova per favore.',
	'userlogin-error-invalidfacebook' => 'Si è verificato un problema con il rilevamento del tuo account Facebook; accedi di nuovo a Facebook e riprova per favore.',
	'userlogin-error-fbconnect' => 'Si è verificato un problema nel collegare il tuo account Wikia con Facebook.',
	'userlogin-account-admin-error' => 'Ops! Qualcosa è andato storto. Per favore, contatta [[Special:Contact|Wikia]] per ricevere assistenza.',
	'userlogin-opt-in-label' => 'Inviami email su news ed eventi di Wikia',
	'userlogin-error-confirmation-reminder-already-sent' => "Il promemoria per la conferma dell'email è già stato inviato.",
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="https://twitter.com/wikia_it" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="https://www.facebook.com/wikia.it" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="https://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://it.community.wikia.com/wiki/Blog:Blog_ufficiale_di_Wikia_Italia" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'userlogin-logged-in-title' => 'Benvenuto su {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => "Hai effettuato l'accesso. Vai sulla [[$1|pagina principale]] per vedere le ultime novità o dai un'occhiata al tuo [[$2|profilo]].",
);

/** Japanese (日本語)
 * @author Barrel0116
 * @author Los688
 * @author Tommy6
 */
$messages['ja'] = array(
	'userlogin-login-heading' => 'ログイン',
	'userlogin-forgot-password' => 'パスワードを忘れた方はこちら',
	'userlogin-forgot-password-go-to-login' => '既にパスワードをお持ちですか？（[[Special:UserLogin|ログイン]]）',
	'userlogin-remembermypassword' => 'ログイン状態を維持',
	'userlogin-error-noname' => 'ユーザー名を入力してください。',
	'userlogin-error-sessionfailure' => 'ログインセッションがタイムアウトしました。もう一度ログインしてください。',
	'userlogin-error-nosuchuser' => 'この名前のユーザーは存在しません。ユーザー名は大文字小文字を区別することにご注意ください。',
	'userlogin-error-wrongpassword' => 'パスワードを入力してください。',
	'userlogin-error-wrongpasswordempty' => 'パスワードを入力してください。',
	'userlogin-error-resetpass_announce' => '仮パスワードを使用しました。こちらに新しいパスワードを入力してログインしてください。',
	'userlogin-error-login-throttled' => '誤ったパスワードでログインを試みた回数が多すぎます。しばらく待ってから再度お試しください。',
	'userlogin-error-login-userblocked' => 'このユーザー名はブロックされておりログインに使用できません。',
	'userlogin-error-edit-account-closed-flag' => 'このアカウントはWikiaによって無効化されています。',
	'userlogin-error-cantcreateaccount-text' => 'お使いのIPアドレスからのアカウント作成は許可されていません。',
	'userlogin-error-userexists' => 'このユーザー名は既に使用されています。別のものをお試しください。',
	'userlogin-error-invalidemailaddress' => '有効なメールアドレスを入力してください。',
	'userlogin-get-account' => 'まだアカウントを取得していませんか？<a href="$1" tabindex="$2">アカウントを作成するにはこちら</a>',
	'userlogin-error-invalid-username' => '無効なユーザー名です',
	'userlogin-error-userlogin-unable-info' => '申し訳ありません。現在アカウントを登録できません。',
	'userlogin-error-user-not-allowed' => 'このユーザー名は許可されていません。',
	'userlogin-error-captcha-createaccount-fail' => '入力したワードが枠内のワードと一致しません。もう一度入力してください。',
	'userlogin-error-userlogin-bad-birthday' => '生年月日を入力してください。',
	'userlogin-error-externaldberror' => '申し訳ありません。現在サイトで問題が発生しています。しばらくしてからもう一度お試しください。',
	'userlogin-error-noemailtitle' => '有効なメールアドレスを入力してください。',
	'userlogin-error-acct_creation_throttle_hit' => 'お使いのIPアドレスからのアカウント作成が多すぎます。しばらくしてからお試しください。',
	'userlogin-opt-in-label' => 'Wikiaの最新情報やイベントに関するメールの受信を希望する',
	'userlogin-error-resetpass_forbidden' => 'パスワードを変更できません。',
	'userlogin-error-blocked-mailpassword' => 'お使いのIPアドレスがWikiaによってブロックされているため、新しいパスワードを請求できません。',
	'userlogin-error-throttled-mailpassword' => '$1時間前に既にこのアカウントのパスワード復旧に関するメールを送信しました。メールを確認してください。',
	'userlogin-error-mail-error' => 'メールの送信で問題が発生しました。[[w:ja:Forum:Index|サポート]]までご連絡ください。',
	'userlogin-password-email-sent' => '「$1」のメールアドレス宛に新しいパスワードを送信しました。',
	'userlogin-error-unconfirmed-user' => 'メールアドレスの認証が行われていません。まずはじめにメールアドレスの認証を行ってください。',
	'userlogin-error-confirmation-reminder-already-sent' => '認証のリマインダーをメールにて既に送信しました。',
	'userlogin-password-page-title' => 'パスワードを変更',
	'userlogin-oldpassword' => '古いパスワード',
	'userlogin-newpassword' => '新しいパスワード',
	'userlogin-retypenew' => '新しいパスワードを再入力',
	'userlogin-password-email-subject' => '新規パスワードのリクエスト',
	'userlogin-password-email-greeting' => '$USERNAME さん、',
	'userlogin-password-email-content' => 'Wikiaにログインするには、以下の仮パスワードを使用してください: $NEWPASSWORD<br /><br />
新しいパスワードをリクエストした覚えがない場合でも、心配しないでください。アカウントの安全性は保たれています。このメールを無視し、これまで使用していたパスワードでウィキアにログインし続けることができます。<br /><br />
質問や気になることがあれば、遠慮なくお問い合わせください。',
	'userlogin-password-email-signature' => 'Wikia コミュニティサポート',
	'userlogin-password-email-body' => '$2 さん、

Wikiaにログインするには、以下の仮パスワードを使用してください: $3

新しいパスワードをリクエストした覚えがない場合でも、心配しないでください。アカウントは安全に保たれています。このメールを無視し、これまで使用していたパスワードでWikiaにログインし続けることができます。

質問や気になることがあれば、遠慮なくお問い合わせください。

Wikiaサポートチーム
___________________________________________

Wikiaの最新情報は http://ja.wikia.com/ で確認できます。
メール通知に関する設定は {{fullurl:{{ns:special}}:Preferences}} で行えます。',
	'userlogin-email-footer-line1' => 'Wikiaの最新情報は <a style="color:#2a87d5;text-decoration:none;" href="http://ja.wikia.com/">http://ja.wikia.com/</a> で確認できます。',
	'userlogin-email-footer-line2' => 'メール通知に関する設定は<a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">個人設定</a>のページで行えます。',
	'userlogin-provider-or' => 'または',
	'userlogin-provider-tooltip-facebook' => 'Facebook を利用してログインするにはボタンをクリック',
	'userlogin-provider-tooltip-facebook-signup' => 'Facebook を利用してサインアップするにはボタンをクリック',
	'userlogin-facebook-show-preferences' => 'Facebook フィードに関する設定を表示',
	'userlogin-facebook-hide-preferences' => 'Facebook フィードに関する設定を隠す',
	'userlogin-loginreqlink' => 'ログイン',
	'userlogin-changepassword-needlogin' => 'パスワードを変更するには$1する必要があります。',
	'wikiamobile-sendpassword-label' => '新しいパスワードを送信',
	'wikiamobile-facebook-connect-fail' => 'あなたの Facebook アカウントは現在Wikiaのアカウントとリンクされていません。',
	'userlogin-error-wrongcredentials' => 'このユーザー名とパスワードの組み合わせは正しくありません。再試行してください。',
	'userlogin-error-invalidfacebook' => 'あなたの Facebook アカウントの検出に問題がありました。Facebook にログインして再試行してください。',
	'userlogin-error-fbconnect' => 'あなたのWikiaのアカウントと Facebook との接続に問題がありました。',
	'userlogin-logged-in-title' => '{{SITENAME}}へようこそ、$1さん!',
	'userlogin-logged-in-message' => 'ログイン状態です。[[$1|ホーム]]から最新情報を見つけたり、[[$2|プロフィール]]を確認してみましょう。',
	'userlogin-desc' => 'ユーザー・ログイン拡張機能',
	'userlogin-forgot-password-button' => '次へ',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="https://twitter.com/wikiajapan" style="text-decoration:none">
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
<a href="http://ja.community.wikia.com/wiki/ブログ:Wikiaスタッフブログ" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'userlogin-account-admin-error' => 'エラーが発生しました。申し訳ありませんが、[[特別:お問い合わせ|Wikiaにお問い合わせ]]ください。',
);

/** Georgian (ქართული)
 * @author DevaMK
 * @author MIKHEIL
 */
$messages['ka'] = array(
	'userlogin-forgot-password' => 'დაგავიწყდათ პაროლი?',
	'userlogin-remembermypassword' => 'დამიმახსოვრე',
	'userlogin-provider-or' => 'ან',
	'userlogin-logged-in-title' => 'კეთილი იყოს თქვენი მიობრძანება {{SITENAME}}, $1!-ში!',
);

/** Korean (한국어)
 * @author Gusdud25
 * @author Miri-Nae
 */
$messages['ko'] = array(
	'userlogin-login-heading' => '로그인',
	'userlogin-error-invalidfacebook' => '페이스북 계정에 문제가 생긴것 같아요; 페이스북에 로그인한 후 다시 시도하세요.',
	'userlogin-oldpassword' => '기존 비밀번호',
	'userlogin-newpassword' => '새 비밀번호',
	'userlogin-password-email-greeting' => '안녕하세요, $USERNAME 님.',
	'userlogin-password-email-content' => '위키아에 로그인하시려면 다음 임시 비밀번호를 사용해 주세요: "$NEWPASSWORD"
<br /><br />
임시 비밀번호를 요청한 적이 없으신가요? 그래도 걱정하지 마세요! 귀하의 계정은 여전히 안전합니다. 그냥 이 메일은 무시하고 기존의 비밀번호로 로그인하세요.
<br /><br />
질문이나 의견이 있으신가요? 언제든지 저희에게 <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">연락</a>해 주세요.',
	'userlogin-password-email-signature' => '위키아 커뮤니티 지원팀',
	'userlogin-password-email-body' => '안녕하세요 $2 님.

위키아에 로그인하시려면 다음 임시 비밀번호를 사용해 주세요: "$3"

임시 비밀번호를 요청한 적이 없으신가요? 그래도 걱정하지 마세요! 귀하의 계정은 여전히 안전합니다. 그냥 이 메일은 무시하고 기존의 비밀번호로 로그인하세요.

질문이나 의견이 있으신가요? 언제든지 저희에게 연락해 주세요: http://community.wikia.com/wiki/Special:Contact/account-issue

위키아 커뮤니티 지원팀


___________________________________________

중앙 커뮤니티에서 도움을 구하세요: http://ko.community.wikia.com
알림을 받고 싶지 않으신가요? 이곳에서 알림 설정을 변경할 수 있습니다: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line2' => '알림을 받고 싶지 않으신가요? <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">환경설정</a>에서 알림 설정을 변경할 수 있습니다',
	'userlogin-loginreqlink' => '로그인',
);

/** Karachay-Balkar (къарачай-малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'userlogin-login-heading' => 'Кириу',
	'userlogin-loginreqlink' => 'кириу',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Bikarhêner
 * @author Ghybu
 */
$messages['ku-latn'] = array(
	'userlogin-login-heading' => 'Têkeve',
	'userlogin-forgot-password' => 'Te şîfreye xwe jibîrkir?',
	'userlogin-provider-or' => 'An jî',
	'userlogin-loginreqlink' => 'têkeve',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'userlogin-login-heading' => 'Aloggen',
	'userlogin-forgot-password' => 'Hutt Dir Äert Passwuert vergiess?',
	'userlogin-forgot-password-button' => 'Viru fueren',
	'userlogin-forgot-password-go-to-login' => 'Hutt Dir schonn e Passwuert? [[Special:UserLogin|Loggt Iech an]]',
	'userlogin-remembermypassword' => 'Ageloggt bleiwen',
	'userlogin-error-wrongpassword' => "Ups, d'Passwuert ass falsch. Vergewëssert Iech datt 'Caps lock' ausgeschalt ass a probéiert nach eng Kéier.",
	'userlogin-error-login-userblocked' => 'Äre Benotzernumm gouf gespaart a kann net méi benotzt gi fir sech anzeloggen.',
	'userlogin-error-cantcreateaccount-text' => 'Mat Ärer IP-Adress däerfe keng nei Benotzerkonten ugeluecht ginn.',
	'userlogin-error-userexists' => 'Et huet schonn een dëse Benotzernumm. Probéiert een aneren!',
	'userlogin-error-invalidemailaddress' => 'Gitt w.e.g eng valabel E-Mailadress an.',
	'userlogin-error-invalid-username' => 'Ongëltege Benotzernumm',
	'userlogin-error-userlogin-unable-info' => 'Pardon, mir kënnen Äre Benotzerkont den Ament net registréieren.',
	'userlogin-error-user-not-allowed' => 'Dëse Benotzernumm ass net erlaabt.',
	'userlogin-error-captcha-createaccount-fail' => "D'Wuert dat Dir aginn hutt ass net datselwecht wéi d'Wuert an der Këscht, probéiert nach eng Kéier!",
	'userlogin-error-noemailtitle' => 'Gitt w.e.g eng valabel E-Mailadress an.',
	'userlogin-error-resetpass_forbidden' => 'Passwierder kënnen net geännert ginn',
	'userlogin-password-page-title' => 'Ännert Äert Passwuert',
	'userlogin-oldpassword' => 'Aalt Passwuert',
	'userlogin-newpassword' => 'Neit Passwuert',
	'userlogin-retypenew' => 'Neit Passwuert nach eemol antippen',
	'userlogin-password-email-greeting' => 'Salut $USERNAME,',
	'userlogin-provider-or' => 'Oder',
	'userlogin-changepassword-needlogin' => "Dir musst Iech $1 fir Äert Passwuert z'änneren.",
	'wikiamobile-sendpassword-label' => 'Neit Passwuert schécken',
	'wikiamobile-facebook-connect-fail' => 'Pardon, Äre Facebook-Benotzerkont ass elo net mat engem Wikia-Benotzerkont verbonn.',
	'userlogin-logged-in-title' => 'Wëllkomm op {{SITENAME}}, $1!',
);

/** Lithuanian (lietuvių)
 * @author Mantak111
 */
$messages['lt'] = array(
	'userlogin-login-heading' => 'Prisijunkite',
	'userlogin-forgot-password' => 'Pamiršote slaptažodį?',
	'userlogin-forgot-password-button' => 'Tęsti',
	'userlogin-forgot-password-go-to-login' => 'Jau turite savo slaptažodį? [[Special:UserLogin|Prisijunkite]]',
	'userlogin-remembermypassword' => 'Likti prisijungus',
	'userlogin-error-noname' => 'Oi, prašome užpildyti naudotojo vardo laukelyje.',
	'userlogin-error-sessionfailure' => 'Jūsų prisijungimo sesija baigėsi. Prašome prisijungti dar kartą.',
	'userlogin-error-wrongpassword' => 'Oi, neteisingas slaptažodis. Įsitikinkite, kad caps lock funkcija yra išjungta ir bandykite dar kartą.',
	'userlogin-error-wrongpasswordempty' => 'Oi, prašome užpildyti naudotojo vardo laukelyje.',
	'userlogin-error-invalid-username' => 'Negalimas naudotojo vardas',
	'userlogin-error-userlogin-unable-info' => 'Deja, mes negalime užregistruoti jūsų paskyrą šiuo metu.',
	'userlogin-error-user-not-allowed' => 'Šis naudotojo vardas yra neleidžiamas.',
	'userlogin-error-noemailtitle' => 'Prašome įvesti galiojantį el. pašto adresą.',
	'userlogin-error-resetpass_forbidden' => 'Slaptažodžiai negali būti pakeisti',
	'userlogin-password-page-title' => 'Keisti savo slaptažodį',
	'userlogin-oldpassword' => 'Senas slaptažodis',
	'userlogin-newpassword' => 'Naujas slaptažodis',
	'userlogin-retypenew' => 'Pakartokite naują slaptažodį:',
	'userlogin-password-email-subject' => 'Pamiršto slaptažodžio prašymas',
	'userlogin-password-email-greeting' => 'Sveiki $USERNAME,',
	'userlogin-provider-or' => 'Arba',
	'userlogin-provider-tooltip-facebook' => 'Spustelėkite mygtuką, norėdami prisijungti su Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Spustelėkite mygtuką, norėdami užsiregistruoti su Facebook',
	'userlogin-loginreqlink' => 'prisijungti',
	'wikiamobile-sendpassword-label' => 'Siųsti naują slaptažodį',
);

/** Literary Chinese (文言)
 * @author StephDC
 */
$messages['lzh'] = array(
	'userlogin-login-heading' => '登簿',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'userlogin-desc' => 'Додаток „КорисничкаНајава“',
	'userlogin-login-heading' => 'Најава',
	'userlogin-forgot-password' => 'Ја заборавивте лозинката?',
	'userlogin-forgot-password-button' => 'Продолжи',
	'userlogin-forgot-password-go-to-login' => 'Веќе имате лозинка? [[Special:UserLogin|Најавете се]]',
	'userlogin-remembermypassword' => 'Задржи ме најавен',
	'userlogin-error-noname' => 'Пополнете го полето за корисничко име.',
	'userlogin-error-sessionfailure' => 'Најавната седница ви истече. Најавете се повторно.',
	'userlogin-error-nosuchuser' => 'Ова име не се признава. Не заборавајте дека системот разликува мали и големи букви.',
	'userlogin-error-wrongpassword' => 'Погрешна лозинка. Проверете да не пишувате со големи букви и обидете се повторно.',
	'userlogin-error-wrongpasswordempty' => 'Пополнете го полето за лозинка.',
	'userlogin-error-resetpass_announce' => 'Изгледа употребивте привремена лозинка. Тука одберете нова, па продолжете со најавата.',
	'userlogin-error-login-throttled' => 'Премногу пати внесовте погрешна лозинка. Почекајте малку, па обидете се повторно.',
	'userlogin-error-login-userblocked' => 'Вашето корисничко име е блокирано, па затоа не можете да се најавите со него.',
	'userlogin-error-edit-account-closed-flag' => 'Сметката ви е оневозможена од Викија.',
	'userlogin-error-cantcreateaccount-text' => 'На вашата IP-адреса не ѝ е допуштено да создава нови сметки.',
	'userlogin-error-userexists' => 'Корисничкото име е зафатено. Одберете друго!',
	'userlogin-error-invalidemailaddress' => 'Внесете важечка е-пошта.',
	'userlogin-error-wrongcredentials' => 'Оваа комбинација од корисничко име и лозинка не е исправна. Обидете се повторно.',
	'userlogin-error-invalidfacebook' => 'Се јави проблем при утврдувањето на вашата сметка на Facebook. Најавете се на Facebook и обидете се повторно.',
	'userlogin-error-fbconnect' => 'Се јави проблем при поврзувањето на вашата сметка на Викија со онаа на Facebook.',
	'userlogin-get-account' => 'Немате сметка? <a href="$1" tabindex="$2">Регистрирајте се</a>',
	'userlogin-error-invalid-username' => 'Неважечко корисничко име',
	'userlogin-error-userlogin-unable-info' => 'Нажалост, во моментов не можете да се регистрирате.',
	'userlogin-error-user-not-allowed' => 'Ова корисничко име не е дозволено.',
	'userlogin-error-captcha-createaccount-fail' => 'Внесениот збор не е ист со оној во полето. Обидете се повторно!',
	'userlogin-error-userlogin-bad-birthday' => 'Пополнете месец, ден и година.',
	'userlogin-error-externaldberror' => 'Извинете! Моментално се соочуваме со проблем. Обидете се подоцна.',
	'userlogin-error-noemailtitle' => 'Внесете важечка е-пошта.',
	'userlogin-error-acct_creation_throttle_hit' => 'Извинете, но оваа IP-адреса создаде премногу сметки за денес. Обидете се подоцна.',
	'userlogin-opt-in-label' => 'Испраќај ми е-пошта за новости и настани на Викија',
	'userlogin-error-resetpass_forbidden' => 'Лозинките не може да се менуваат',
	'userlogin-error-blocked-mailpassword' => 'Не можете да побарате нова лозинка бидејќи оваа IP-адреса е блокирана од Викија.',
	'userlogin-error-throttled-mailpassword' => 'Веќе ви испративме потсетник за лозинката на оваа сметка во {{PLURAL:$1|последниов час|последниве $1 часа}}. Проверете си ја е-поштата.',
	'userlogin-error-mail-error' => 'Се појави проблем при испраќањето на пораката. Ве молиме, [[Special:Contact/general|контактирајте нè]].',
	'userlogin-password-email-sent' => 'Ви испративме нова лозинка на е-поштата назначена за $1.',
	'userlogin-error-unconfirmed-user' => 'Нажалост, ја немате потврдено вашата е-пошта. Ќе треба најпрвин да ја потврдите.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Потврдната порака е веќе испратена на е-пошта.',
	'userlogin-password-page-title' => 'Променете си ја лозинката.',
	'userlogin-oldpassword' => 'Стара лозинка',
	'userlogin-newpassword' => 'Нова лозинка',
	'userlogin-retypenew' => 'Повторете ја новата лозинка:',
	'userlogin-password-email-subject' => 'Барање за заборавена лозинка',
	'userlogin-password-email-greeting' => 'Здраво $USERNAME,',
	'userlogin-password-email-content' => 'Искористете ја оваа привремена лозинка за да се најавите на Викија: „$NEWPASSWORD“
<br /><br />
Доколку не побаравте нова лозинка, не грижете се! Сметката ви е сосем безбедна. Занемарете го ова писмо и најавувајте се со постоечката лозинка.
<br /><br />
Имате прашања или проблеми? Слободно <a href="http://community.wikia.com/wiki/Special:Contact/account-issue?uselang=mk">обратете ни се</a>.',
	'userlogin-password-email-signature' => 'Поддршка за заедницата на Викија',
	'userlogin-password-email-body' => 'Здраво $2,

Искористете ја оваа привремена лозинка за да се најавите на Викија: „$3“

Доколку не побаравте нова лозинка, не грижете се! Сметката ви е сосем безбедна. Занемарете го ова писмо и најавувајте се со постоечката лозинка.

Имате прашања или проблеми? Слободно обратете ни се: http://community.wikia.com/wiki/Special:Contact/account-issue

Поддршка за заедницата на Викија


___________________________________________

Најновите збиднувања на Викија ќе ги најдете на http://community.wikia.com
Сакате да одберете што да добивате по е-пошта? Појдете на: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'За да ги проследите најновите случувања на Викија, посетете ја страницата <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Сакате да одберете кои пораки да ги добивате? Појдете на вашите <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Нагодувања</a>',
	'userlogin-provider-or' => 'или',
	'userlogin-provider-tooltip-facebook' => 'Стиснете на копчето за да се најавите со Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Стиснете на копчето за да се регистрирате со Facebook',
	'userlogin-facebook-show-preferences' => 'Прикажи поставки за каналот на Facebook',
	'userlogin-facebook-hide-preferences' => 'Скриј поставки за каналот на Facebook',
	'userlogin-loginreqlink' => 'се најавите',
	'userlogin-changepassword-needlogin' => 'Треба да $1 за да можете да ја смените лозинката.',
	'wikiamobile-sendpassword-label' => 'Испрати нова лозинка',
	'wikiamobile-facebook-connect-fail' => 'Нажалост, сметката на Facebook не ви е поврзана со сметка на Викија.',
	'userlogin-logged-in-title' => 'Добре дојдовте на {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => 'Најавени сте. Појдете на [[$1|главната страница]] за да ги видите најновите или да го погледате вашиот [[$2|профил]].',
);

/** Marathi (मराठी)
 * @author Kaajawa
 * @author V.narsikar
 */
$messages['mr'] = array(
	'userlogin-login-heading' => 'सनोंद-प्रवेश(लॉग-ईन)',
	'userlogin-forgot-password' => 'परवलीचा शब्द विसरलात?',
	'userlogin-forgot-password-button' => 'पुढे चला',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'userlogin-desc' => 'Sambungan UserLogin',
	'userlogin-login-heading' => 'Log masuk',
	'userlogin-forgot-password' => 'Lupa kata laluan anda?',
	'userlogin-forgot-password-button' => 'Sambung',
	'userlogin-forgot-password-go-to-login' => 'Sudah dapat kata laluan? [[Special:UserLogin|Log masuk]]',
	'userlogin-remembermypassword' => 'Kekal log masuk',
	'userlogin-error-noname' => 'Maaf, sila isi ruangan nama pengguna.',
	'userlogin-error-sessionfailure' => 'Sesi log masuk anda sudah habis. Sila log masuk semula.',
	'userlogin-error-nosuchuser' => 'Kami tidak mengenali nama ini. Jangan lupa, nama pengguna adalah peka kecil besar huruf.',
	'userlogin-error-wrongpassword' => 'Maaf, kata laluan salah. Pastikan CAPS LOCK terpadam dan cuba lagi.',
	'userlogin-error-wrongpasswordempty' => 'Maaf, sila isi ruangan kata laluan.',
	'userlogin-error-resetpass_announce' => 'Rupanya anda menggunakan kata laluan sementara. Sila buat kata laluan baru di sini untuk terus log masuk.',
	'userlogin-error-login-throttled' => 'Anda telah cuba log masuk dengan kata laluan yang salah terlalu banyak kali. Sila tunggu sebentar sebelum dapat mencuba lagi.',
	'userlogin-error-login-userblocked' => 'Nama pengguna anda telah disekat dan tidak boleh digunakan untuk log masuk.',
	'userlogin-error-edit-account-closed-flag' => 'Akaun anda telah dimatikan oleh Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Alamat IP anda tidak dibenarkan untuk membuka akaun baru.',
	'userlogin-error-userexists' => 'Nama pengguna ini sudah diambil. Cuba gunakan nama yang lain!',
	'userlogin-error-invalidemailaddress' => 'Sila berikan alamat e-mel yang sah.',
	'userlogin-error-wrongcredentials' => 'Kombinasi nama pengguna dan kata laluan ini tidak tepat. Sila cuba lagi.',
	'userlogin-error-invalidfacebook' => 'Terdapat masalah ketika mengesan akaun Facebook anda; sila log masuk ke dalam Facebook dan cuba lagi.',
	'userlogin-error-fbconnect' => 'Terdapat masalah ketika menyambungkan akaun Wikia anda ke Facebook.',
	'userlogin-get-account' => 'Tiada akaun? <a href="$1" tabindex="$2">Daftarlah</a>',
	'userlogin-error-invalid-username' => 'Nama pengguna tidak sah',
	'userlogin-error-userlogin-unable-info' => 'Maaf, kami tidak dapat mendaftarkan akaun anda buat masa ini.',
	'userlogin-error-user-not-allowed' => 'Nama pengguna ini tidak dibenarkan.',
	'userlogin-error-captcha-createaccount-fail' => 'Perkataan yang anda taipkan tidak sepadan dengan perkataan dalam petak. Sila cuba lagi!',
	'userlogin-error-userlogin-bad-birthday' => 'Maaf, tolong isikan bulan, hari bulan dan tahun.',
	'userlogin-error-externaldberror' => 'Harap maaf! Tapak kami kini mengalami masalah teknikal. Sila cuba lagi nanti.',
	'userlogin-error-noemailtitle' => 'Sila berikan alamat e-mel yang sah.',
	'userlogin-error-acct_creation_throttle_hit' => 'Maaf, alamat IP ini telah membuka terlalu banyak akaun hari ini. Sila cuba lagi nanti.',
	'userlogin-opt-in-label' => 'E-melkan berita dan acara Wikia kepada saya',
	'userlogin-error-resetpass_forbidden' => 'Kata laluan tidak boleh ditukar',
	'userlogin-error-blocked-mailpassword' => 'Anda tidak boleh meminta kata laluan baru kerana alamat IP ini disekat oleh Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Kami telah menghantar peringatan kata laluan kepada akaun ini dalam {{PLURAL:$1|sejam|$1 jam}} yang lalu. Sila semak e-mel anda.',
	'userlogin-error-mail-error' => 'Maaf, timbulnya masalah ketika menghantar e-mel kepada anda.Sila [[Special:Contact/general|hubungi kami]].',
	'userlogin-password-email-sent' => 'Kami telah menghantar kata laluan baru kepada alamat e-mel $1.',
	'userlogin-error-unconfirmed-user' => 'Maaf, anda belum mengesahkan alamat e-mel anda. Sila sahkan alamat e-mel anda terlebih dahulu.',
	'userlogin-error-confirmation-reminder-already-sent' => 'E-mel peringatan pengesahan sudah dihantar.',
	'userlogin-password-page-title' => 'Tukar kata laluan anda',
	'userlogin-oldpassword' => 'Kata laluan lama',
	'userlogin-newpassword' => 'Kata laluan baru',
	'userlogin-retypenew' => 'Ulangi kata laluan baru',
	'userlogin-password-email-subject' => 'Memohon kata laluan yang terlupa',
	'userlogin-password-email-greeting' => 'Apa khabar $USERNAME,',
	'userlogin-password-email-content' => 'Sila gunakan kata laluan sementara ini untuk log masuk ke dalam Wikia: "$NEWPASSWORD"
<br /><br />
Jika anda tidak memohon kata laluan baru, usah risau! Akaun anda masih selamat dan terlindung. Anda boleh mengabaikan e-mel ini dan terus log masuk ke dalam Wikia dengan kata laluan lama anda.
<br /><br />
Jika anda mempunyai sebarang pertanyaan, sila hubungi kami tanpa rasa segan.',
	'userlogin-password-email-signature' => 'Bantuan Komuniti Wikia',
	'userlogin-password-email-body' => 'Apa khabar $2,

Sila gunakan kata laluan sementara ini untuk log masuk ke dalam Wikia: "$3"

Jika anda tidak memohon kata laluan baru, usah risau! Akaun anda masih selamat dan terlindung. Anda boleh mengabaikan e-mel ini dan terus log masuk ke dalam Wikia dengan kata laluan lama anda.

Jika anda mempunyai sebarang pertanyaan, sila hubungi kami tanpa rasa segan di: http://community.wikia.com/wiki/Special:Contact/account-issue

Bantuan Komuniti Wikia


___________________________________________

Untuk meninjau perkembangan terkini di Wikia, lawati http://community.wikia.com
Ingin mengawal e-mel yang anda terima? Pergi ke: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Untuk meninjau perkembangan terkini di Wikia, lawati <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Ingin mengawal e-mel yang anda terima? Pergi ke <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Keutamaan</a>',
	'userlogin-provider-or' => 'Atau',
	'userlogin-provider-tooltip-facebook' => 'Klik butang ini untuk log masuk dengan Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Klik butang ini untuk mendaftar diri dengan Facebook',
	'userlogin-facebook-show-preferences' => 'Tunjukkan keutamaan suapan Facebook',
	'userlogin-facebook-hide-preferences' => 'Sorokkan keutamaan suapan Facebook',
	'userlogin-loginreqlink' => 'log masuk',
	'userlogin-changepassword-needlogin' => 'Anda perlu $1 untuk menukar kata laluan baru.',
	'wikiamobile-sendpassword-label' => 'Hantar kata laluan baru',
	'wikiamobile-facebook-connect-fail' => 'Maaf, akaun Facebook anda sekarang tidak berpautan dengan sebarang akaun Wikia.',
	'userlogin-logged-in-title' => 'selamat datang ke {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => 'Anda sudah log masuk. Sila ke [[$1|halaman utama]] untuk melihat perkembangan terkini, ataupun layari [[$2|profil]] anda.',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'userlogin-login-heading' => 'Logg inn',
	'userlogin-forgot-password' => 'Glemt passordet ditt?',
	'userlogin-remembermypassword' => 'Forbli innlogget',
	'userlogin-error-noname' => 'Ops, vennligst fyll ut brukernavn-feltet.',
	'userlogin-error-sessionfailure' => 'Innloggingssesjonen din har utløpt. Vennligst logg inn igjen.',
	'userlogin-error-nosuchuser' => 'Vi gjenkjenner ikke dette navnet. Ikke glem at brukernavn skiller mellom store og små bokstaver.',
	'userlogin-error-wrongpassword' => 'Ops, galt passord. Pass på at caps lock er av og forsøk igjen.',
	'userlogin-error-wrongpasswordempty' => 'Ops, vennligst fyll ut passord-feltet.',
	'userlogin-error-resetpass_announce' => 'Det ser ut som du brukte et midlertidig passord. Velg et nytt passord her for å fortsette innloggingen.',
	'userlogin-error-login-throttled' => 'Du har forsøkt å logge inn med galt passord for mange ganger. Vent en stund før du prøver igjen.',
	'userlogin-error-login-userblocked' => 'Brukernavnet ditt har blitt blokkert og kan ikke brukes for å logge inn.',
	'userlogin-error-edit-account-closed-flag' => 'Kontoen din har blitt deaktivert av Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'IP-adressen din har ikke tillatelse til å opprette nye kontoer.',
	'userlogin-error-userexists' => 'Noen har alt tatt dette brukernavnet. Prøv et annet!',
	'userlogin-error-invalidemailaddress' => 'Vennligst oppgi en gyldig e-postadresse.',
	'userlogin-get-account' => 'Har du ikke en konto? <a href="$1" tabindex="$2">Registrer deg</a>',
	'userlogin-error-invalid-username' => 'Ugyldig brukernavn',
	'userlogin-error-userlogin-unable-info' => 'Beklager, vi kan for øyeblikket ikke registrere kontoen din.',
	'userlogin-error-user-not-allowed' => 'Dette brukernavnet er ikke tillatt.',
	'userlogin-error-captcha-createaccount-fail' => 'Ordet du oppga samsvarer ikke med ordet i boksen, prøv igjen!',
	'userlogin-error-userlogin-bad-birthday' => 'Ops, vennligst fyll ut måneden, dagen og året.',
	'userlogin-error-externaldberror' => 'Beklager! Siden vår opplever for øyeblikket et problem. Vennligst prøv igjen senere.',
	'userlogin-error-noemailtitle' => 'Vennligst oppgi en gyldig e-postadresse.',
	'userlogin-error-acct_creation_throttle_hit' => 'Beklager, denne IP-adressen har allerede opprettet for mange kontoer i dag. Vennligst prøv igjen senere.',
	'userlogin-error-resetpass_forbidden' => 'Passordene kunne ikke endres',
	'userlogin-error-blocked-mailpassword' => 'Du kan ikke be om et nytt passord fordi denne IP-adressen er blokkert av Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Vi har allerede sent en passordpåminnelse til denne kontoen i løpet av {{PLURAL:$1|den siste timen|de $1 siste timene}}. Vennligst sjekk e-posten din.',
	'userlogin-error-mail-error' => 'Ops, det oppstod et problem under sendingen av e-posten din. Vennligst [[Special:Contact/general|kontakt oss]].',
	'userlogin-password-email-sent' => 'Vi har sendt et nytt passord til e-postadressen $1.',
	'userlogin-error-unconfirmed-user' => 'Beklager, du har ikke bekreftet e-postadressen din. Vennligst bekreft e-postadressen din først.',
	'userlogin-password-page-title' => 'Endre passordet ditt',
	'userlogin-oldpassword' => 'Gammelt passord',
	'userlogin-newpassword' => 'Nytt passord',
	'userlogin-retypenew' => 'Gjenta nytt passord',
	'userlogin-password-email-subject' => 'Forespørsel om glemt passord',
	'userlogin-password-email-greeting' => 'Hei $USERNAME,',
	'userlogin-password-email-content' => 'Vennligst bruk dette midlertidige passordet for å logge inn i Wikia: «$NEWPASSWORD»
<br /><br />
Hvis du ikke har bedt om et nytt passord, ikke vær bekymret! Kontoen din er trygg og sikker. Du kan ignorere denne e-posten og fortsette å logge inn i Wikia med det gamle passordet ditt.
<br /><br />
Spørsmål eller bekymringer? Kontakt oss gjerne.',
	'userlogin-password-email-signature' => 'Wikia fellesskapssupport',
	'userlogin-password-email-body' => 'Hei $2,

Vennligst bruk dette midlertidige passordet for å logge inn i Wikia: «$3»

Hvis du ikke har bedt om et nytt passord, ikke vær bekymret! Kontoen din er trygg og sikker. Du kan ignorere denne e-posten og fortsette å logge inn i Wikia med det gamle passordet ditt.

Spørsmål eller bekymringer? Kontakt oss gjerne.

Wikia fellesskapssupport


___________________________________________
For å sjekke ut de nyeste hendelsene på Wikia, besøk http://community.wikia.com
Vil du kontrollere hva slags e-post du mottar? Gå til: <a href="{{fullurl:Special:Preferences}}">Innstillingene dine<a>',
	'userlogin-email-footer-line1' => 'For å sjekke ut de siste hendelsene på Wikia, besøk <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Vil du kontrollere hvilke e-post du mottar? Gå til <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">innstillingene dine</a>',
	'userlogin-provider-or' => 'Eller',
	'userlogin-provider-tooltip-facebook' => 'Trykk på knappen for å logge inn med Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Trykk på knappen for å registrere deg med Facebook',
	'userlogin-facebook-show-preferences' => 'Vis innstillinger for nyhetsoppdateringer fra Facebook',
	'userlogin-facebook-hide-preferences' => 'Skjul innstillinger for nyhetsoppdateringer fra Facebook',
	'userlogin-loginreqlink' => 'logg inn',
	'userlogin-changepassword-needlogin' => 'Du må $1 for å endre passordet ditt.',
	'wikiamobile-sendpassword-label' => 'Send nytt passord',
	'wikiamobile-facebook-connect-fail' => 'Beklager, Facebook-kontoen din er for øyeblikket ikke koblet til en Wikia-konto.',
);

/** Dutch (Nederlands)
 * @author HanV
 * @author Robin0van0der0vliet
 * @author Siebrand
 * @author Southparkfan
 */
$messages['nl'] = array(
	'userlogin-login-heading' => 'Aanmelden',
	'userlogin-forgot-password' => 'Wachtwoord vergeten?',
	'userlogin-forgot-password-button' => 'Doorgaan',
	'userlogin-forgot-password-go-to-login' => 'Hebt u al een wachtwoord? [[Special:UserLogin|Meld u dan aan]]',
	'userlogin-remembermypassword' => 'Aangemeld blijven',
	'userlogin-error-noname' => 'Geef een gebruikersnaam op.',
	'userlogin-error-sessionfailure' => 'Uw aanmeldsessie is verlopen. Meld u opnieuw aan.',
	'userlogin-error-nosuchuser' => 'Deze gebruikersnaam wordt niet herkend. Vergeet niet dat gebruikersnamen hoofdlettergevoelig zijn.',
	'userlogin-error-wrongpassword' => 'Het wachtwoord is onjuist. Vergeet niet dat wachtwoorden hoofdlettergevoelig zijn.',
	'userlogin-error-wrongpasswordempty' => 'Geef een wachtwoord op.',
	'userlogin-error-resetpass_announce' => 'U hebt een tijdelijk wachtwoord gebruikt. Kies een nieuw wachtwoord om door te gaan met aanmelden.',
	'userlogin-error-login-throttled' => 'U hebt te vaak een onjuist wachtwoord opgegeven. Wacht even voordat u het opnieuw probeert.',
	'userlogin-error-login-userblocked' => 'Uw gebruiker is geblokkeerd en er kan niet mee aangemeld worden.',
	'userlogin-error-edit-account-closed-flag' => 'Uw gebruiker is door Wikia buiten werking gesteld.',
	'userlogin-error-cantcreateaccount-text' => 'Via uw IP-adres mogen geen nieuwe gebruikers aangemaakt worden.',
	'userlogin-error-userexists' => 'Deze naam is al in gebruik. Kies een andere.',
	'userlogin-error-invalidemailaddress' => 'Geef een geldig e-mailadres op.',
	'userlogin-error-wrongcredentials' => 'Deze combinatie van gebruikersnaam en wachtwoord is niet correct. Probeer het opnieuw.',
	'userlogin-error-invalidfacebook' => 'Er is een probleem opgetreden tijdens het detecteren van uw Facebook-account. Meld u aan bij Facebook en probeer het opnieuw.',
	'userlogin-error-fbconnect' => 'Er is een probleem opgetreden tijdens het koppelen van uw Wikiagebruiker aan Facebook.',
	'userlogin-get-account' => 'Hebt u nog geen account? <a href="$1" tabindex="$2">Registreren</a>',
	'userlogin-error-invalid-username' => 'Ongeldige gebruikersnaam',
	'userlogin-error-userlogin-unable-info' => 'Het is helaas niet mogelijk uw gebruiker op dit moment te registreren.',
	'userlogin-error-user-not-allowed' => 'Deze gebruikersnaam is niet toegestaan.',
	'userlogin-error-captcha-createaccount-fail' => 'Het woord dat u hebt ingevoerd komt niet overeen met het woord in het vakje. Probeer het opnieuw.',
	'userlogin-error-userlogin-bad-birthday' => 'Geef een maand, dag en jaar op.',
	'userlogin-error-externaldberror' => 'Er is een probleem met onze site. Probeer het later opnieuw.',
	'userlogin-error-noemailtitle' => 'Geef een geldig e-mailadres op.',
	'userlogin-error-acct_creation_throttle_hit' => 'Via dit IP-adres zijn vandaag al te veel gebruikers aangemaakt. Probeer het later opnieuw.',
	'userlogin-opt-in-label' => 'Mij e-mailen bij nieuws en evenementen over Wikia',
	'userlogin-error-resetpass_forbidden' => 'Wachtwoorden kunnen niet gewijzigd worden',
	'userlogin-error-blocked-mailpassword' => 'U kunt geen nieuw wachtwoord opvragen omdat dit IP-adres door Wikia geblokkeerd is.',
	'userlogin-error-throttled-mailpassword' => 'We hebben in {{PLURAL:$1|het afgelopen|de afgelopen $1}} uur al een wachtwoordherinnering voor deze gebruiker verzonden. Controleer uw e-mail.',
	'userlogin-error-mail-error' => 'Het was niet mogelijk een e-mail aan u te verzenden. [[Special:Contact/general|Neem contact met ons op]].',
	'userlogin-password-email-sent' => 'Er is een nieuw wachtwoord verzonden naar het e-mailadres $1.',
	'userlogin-error-unconfirmed-user' => 'Uw e-mailadres is niet bevestigd. Bevestig eerst uw e-mailadres.',
	'userlogin-error-confirmation-reminder-already-sent' => 'De bevestiging per e-mail is al verzonden.',
	'userlogin-password-page-title' => 'Uw wachtwoord wijzigen',
	'userlogin-oldpassword' => 'Huidige wachtwoord',
	'userlogin-newpassword' => 'Nieuw wachtwoord',
	'userlogin-retypenew' => 'Herhaling nieuwe wachtwoord',
	'userlogin-password-email-subject' => 'Verzoek voor nieuw wachtwoord',
	'userlogin-password-email-greeting' => 'Hallo $USERNAME,',
	'userlogin-password-email-content' => 'Gebruik het volgende tijdelijke wachtwoord om aan te melden bij Wikia: "$NEWPASSWORD".
<br /><br />
Maak u geen zorgen als u geen nieuw wachtwoord hebt opgevraagd. Uw gebruiker is veilig. U kunt deze e-mail negeren en blijven aanmelden bij Wikia met uw oude wachtwoord.
<br /><br />
Vragen of zorgen? Neem vooral <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">contact met ons op</a>.',
	'userlogin-password-email-signature' => 'Wikia Community Support',
	'userlogin-password-email-body' => 'Hallo $2,

Gebruik het volgende tijdelijke wachtwoord om aan te melden bij Wikia: "$3".

Maak u geen zorgen als u geen nieuw wachtwoord hebt opgevraagd. Uw gebruiker is veilig. U kunt deze e-mail negeren en blijven aanmelden bij Wikia met uw oude wachtwoord.

Neem contact met ons op als u vragen of zorgen hebt: http://community.wikia.com/wiki/Special:Contact/account-issue

Wikia Gemeenschapsondersteuning

___________________________________________
Bezoek http://community.wikia.com voor het laatste nieuws over Wikia.
Om in te stellen welke e-mails u wilt ontvangen, gaat u naar {{fullurl:{{ns:special}}:Preferences}}.',
	'userlogin-email-footer-line1' => 'Ga naar <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a> om de laatste ontwikkelingen bij Wikia te volgen',
	'userlogin-email-footer-line2' => 'Wilt u bepalen welke e-mails u krijgt? Ga naar uw [{{fullurl:{{ns:special}}:Preferences}} voorkeuren]',
	'userlogin-provider-or' => 'Of',
	'userlogin-provider-tooltip-facebook' => 'Klik op de knop om aan te melden via Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Klik op de knop om te registreren via Facebook',
	'userlogin-facebook-show-preferences' => 'Feedvoorkeuren van Facebook weergeven',
	'userlogin-facebook-hide-preferences' => 'Feedvoorkeuren van Facebook verbergen',
	'userlogin-loginreqlink' => 'aanmelden',
	'userlogin-changepassword-needlogin' => 'U moet $1 om uw wachtwoord te kunnen wijzigen.',
	'wikiamobile-sendpassword-label' => 'Nieuw wachtwoord sturen',
	'wikiamobile-facebook-connect-fail' => 'Uw Facebook-account is op het moment niet gekoppeld met uw Wikia-account.',
	'userlogin-logged-in-title' => 'Welkom bij {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => 'U bent aangemeld. Ga naar de [[$1|startpagina]] om de laatste stand van zaken te bekijken of ga naar uw [[$2|profiel]].',
	'userlogin-desc' => 'UserLogin extension',
	'userlogin-account-admin-error' => 'Oops! Something went wrong. Please contact [[Special:Contact|Wikia]]. for support.',
	'userlogin-password-email-body-HTML' => '',
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
);

/** Norwegian Nynorsk (norsk nynorsk)
 * @author Gaute
 */
$messages['nn'] = array(
	'userlogin-error-invalidfacebook' => 'Det oppstod eit problem med hentinga av Facebook-kontoen din; venlegst logg inn på Facebook og prøv om att.',
	'userlogin-opt-in-label' => 'Send meg e-post med omsyn til Wikia-nyhender og hendingar',
	'userlogin-logged-in-title' => 'Velkomen til {{SITENAME}}, $1!',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'userlogin-desc' => 'Extension UserLogin',
	'userlogin-login-heading' => 'Connexion',
	'userlogin-forgot-password' => 'Avètz doblidat vòstre senhal ?',
	'userlogin-forgot-password-button' => 'Contunhar',
	'userlogin-remembermypassword' => 'Demorar connectat',
	'userlogin-get-account' => 'Avètz pas encara de compte? <a href="$1" tabindex="$2">Inscrivètz-vos</a>',
	'userlogin-error-invalid-username' => "Nom d'utilizaire invalid",
	'userlogin-password-page-title' => 'Modificar vòstre senhal',
	'userlogin-oldpassword' => 'Senhal ancian',
	'userlogin-newpassword' => 'Senhal novèl',
	'userlogin-retypenew' => 'Confirmar lo senhal novèl',
	'userlogin-password-email-greeting' => 'Bonjorn $USERNAME,',
	'userlogin-provider-or' => 'O',
	'userlogin-loginreqlink' => 'vos connectar',
	'wikiamobile-sendpassword-label' => 'Mandar un senhal novèl',
);

/** Polish (polski)
 * @author Chrumps
 * @author Matik7
 * @author Nandy
 * @author Pio387
 * @author Sovq
 * @author Vengir
 */
$messages['pl'] = array(
	'userlogin-desc' => 'Rozszerzenie UserLogin',
	'userlogin-login-heading' => 'Zaloguj się',
	'userlogin-forgot-password' => 'Nie pamiętasz hasła?',
	'userlogin-forgot-password-button' => 'Kontynuuj',
	'userlogin-forgot-password-go-to-login' => 'Pamiętasz swoje hasło? [[Special:UserLogin|Zaloguj się]]',
	'userlogin-remembermypassword' => 'Zapamiętaj mnie',
	'userlogin-error-noname' => 'Ups, proszę wypełnij pole z nazwą użytkownika.',
	'userlogin-error-sessionfailure' => 'Twoja sesja wygasła. Zaloguj się ponownie.',
	'userlogin-error-nosuchuser' => 'Nie rozpoznaliśmy tej nazwy użytkownika. Nie zapominaj, że wielkość liter w nazwie użytkownika ma znaczenie.',
	'userlogin-error-wrongpassword' => 'Ups, złe hasło. Upewnij się, czy klawisz caps lock jest wyłączony i spróbuj ponownie.',
	'userlogin-error-wrongpasswordempty' => 'Ups, proszę wypełnij hasło.',
	'userlogin-error-resetpass_announce' => 'Wygląda na to, że użyłeś tymczasowego hasła. Wpisz nowe hasło, aby kontynuować logowanie.',
	'userlogin-error-login-throttled' => 'Próbowałeś zalogować się podając złe hasło zbyt wiele razy. Poczekaj chwilę zanim spróbujesz ponownie.',
	'userlogin-error-login-userblocked' => 'Twoja nazwa użytkownika została zablokowana i nie możesz się zalogować używając jej.',
	'userlogin-error-edit-account-closed-flag' => 'Twoje konto zostało wyłączone przez Wikię.',
	'userlogin-error-cantcreateaccount-text' => 'Nie możesz zakładać nowych kont z adresu IP, którego obecnie używasz.',
	'userlogin-error-userexists' => 'Ktoś już używa takiej nazwy użytkownika. Spróbuj innej!',
	'userlogin-error-invalidemailaddress' => 'Wprowadź prawidłowy adres e-mail.',
	'userlogin-error-wrongcredentials' => 'Nieprawidłowe połączenie pseudonimu i hasła. Prosimy spróbować ponownie.',
	'userlogin-error-invalidfacebook' => 'Wystąpił problem z odnalezieniem Twojego konta na Facebooku. Zaloguj się do Facebooka i spróbuj jeszcze raz.',
	'userlogin-error-fbconnect' => 'Wystąpił problem z połączeniem Twojego konta z kontem na Facebooku.',
	'userlogin-get-account' => 'Nie masz jeszcze konta? <a href="$1" tabindex="$2">Zarejestruj się</a>',
	'userlogin-error-invalid-username' => 'Nieprawidłowa nazwa użytkownika',
	'userlogin-error-userlogin-unable-info' => 'Przykro nam. Nie jesteśmy w stanie zarejestrować Twojego konta w tym momencie.',
	'userlogin-error-user-not-allowed' => 'Ta nazwa użytkownika nie jest dozwolona.',
	'userlogin-error-captcha-createaccount-fail' => 'Słowo, które wprowadziłeś nie zgadza się ze słowem z obrazka, spróbuj ponownie!',
	'userlogin-error-userlogin-bad-birthday' => 'Ups, wypełnij miesiąc, dzień i rok.',
	'userlogin-error-externaldberror' => 'Przepraszamy! Pojawiły się problemy na naszej stronie. Prosimy spróbować ponownie później.',
	'userlogin-error-noemailtitle' => 'Wprowadź prawidłowy adres e-mail.',
	'userlogin-error-acct_creation_throttle_hit' => 'Przepraszamy, ten adres IP stworzył dzisiaj już zbyt dużo nowych kont. Prosimy spróbować ponownie później.',
	'userlogin-opt-in-label' => 'Chcę otrzymywać maile z wydarzeniami i nowościami na Wikii',
	'userlogin-error-resetpass_forbidden' => 'Hasła nie mogą zostać zmienione',
	'userlogin-error-blocked-mailpassword' => 'Nie możesz prosić o nowe hasło ponieważ Twój adres IP został zablokowany przez Wikię.',
	'userlogin-error-throttled-mailpassword' => 'Wysłaliśmy już przypomnienie z hasłem tego konta w ciągu {{PLURAL:$1|ostatniej godziny|ostatnich $1 godzin}}. Sprawdź swoją skrzynkę e-mail.',
	'userlogin-error-mail-error' => 'Ups, wystąpił problem z wysyłką Twojej wiadomości e-mail. Prosimy [[Special:Contact/general|skontaktuj się z nami]].',
	'userlogin-password-email-sent' => 'Hasło zostało wysłane na adres e-mail $1.',
	'userlogin-error-unconfirmed-user' => 'Przepraszamy, nie potwierdziłeś swojego adresu e-mail. Proszę potwierdź go najpierw.',
	'userlogin-error-confirmation-reminder-already-sent' => 'E-mail z potwierdzeniem został już wysłany.',
	'userlogin-password-page-title' => 'Zmień hasło',
	'userlogin-oldpassword' => 'Poprzednie hasło',
	'userlogin-newpassword' => 'Nowe hasło',
	'userlogin-retypenew' => 'Powtórz nowe hasło',
	'userlogin-password-email-subject' => 'Przypomnienie hasła',
	'userlogin-password-email-greeting' => 'Witaj $USERNAME,',
	'userlogin-password-email-content' => 'Użyj tego tymczasowego hasła, aby zalogować się na Wikii: „$NEWPASSWORD”
<br /><br />
Jeśli nie zgłaszałeś prośby o nowe hasło, nie martw się! Twoje konto jest bezpieczne. Możesz zignorować tą wiadomość i zalogować się przy użyciu starego hasła.
<br /><br />
Masz pytania lub wątpliwości? Daj nam znać.',
	'userlogin-password-email-signature' => 'Zespół Wikii',
	'userlogin-password-email-body' => 'Witaj $2,

Użyj tego tymczasowego hasła, aby zalogować się na Wikii: „$3”

Jeśli nie zgłaszałeś prośby o nowe hasło, nie martw się! Twoje konto jest bezpieczne. Możesz zignorować tą wiadomość i zalogować się przy użyciu starego hasła.

Masz pytania lub wątpliwości? Daj nam znać poprzez : http://community.wikia.com/wiki/Special:Contact/account-issue

Zespół Wikii


___________________________________________

Aby zapoznać się z nowościami, odwiedź http://spolecznosc.wikia.com
Chcesz zmienić ustawienia otrzymywanych powiadomień? Zajrzyj tutaj: {{fullurl:{{ns:special}}:Preferences}}.',
	'userlogin-email-footer-line1' => 'Aby zapoznać się z nowościami, odwiedź <a style="color:#2a87d5;text-decoration:none;" href="http://spolecznosc.wikia.com">spolecznosc.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Chcesz zmienić ustawienia otrzymywanych powiadomień? Zajrzyj tutaj: <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Ustawienia</a>',
	'userlogin-provider-or' => 'Lub',
	'userlogin-provider-tooltip-facebook' => 'Kliknij, aby zalogować się przez Facebooka',
	'userlogin-provider-tooltip-facebook-signup' => 'Kliknij, aby zarejestrować się używając konta na Facebooku',
	'userlogin-facebook-show-preferences' => 'Pokaż ustawienia Facebooka',
	'userlogin-facebook-hide-preferences' => 'Ukryj ustawienia Facebooka',
	'userlogin-loginreqlink' => 'Zaloguj się',
	'userlogin-changepassword-needlogin' => '$1, aby zmienić swoje hasło.',
	'wikiamobile-sendpassword-label' => 'Wyślij nowe hasło',
	'wikiamobile-facebook-connect-fail' => 'Przepraszamy, Twoje konto na Facebooku nie jest obecnie połączone z kontem na Wikii.',
	'userlogin-logged-in-title' => 'Witaj na {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => 'Zostałeś {{GENDER:|zalogowany|zalogowana}}. Przejdź do [[$1|strony głównej]] by zobaczyć nowości lub zobacz swój [[$2|profil]].',
	'userlogin-account-admin-error' => 'Ups, coś poszło nie tak. [[Special:Contact|Skontaktuj się]] z nami jeśli potrzebujesz pomocy.',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="http://www.twitter.com/wikia_pl" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="https://www.facebook.com/wikiapl" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://spolecznosc.wikia.com/wiki/Blog:Wikia_News" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'userlogin-login-heading' => 'Conession',
	'userlogin-forgot-password' => 'Dësmentià soa ciav?',
	'userlogin-remembermypassword' => 'Resté andrinta al sistema',
	'userlogin-error-noname' => "Atension, për piasì ch'a compila ël camp dlë stranòm d'utent.",
	'userlogin-error-sessionfailure' => "Soa session ëd conession a l'ha finì ël temp. Për piasì, ch'a intra torna ant ël sistema.",
	'userlogin-error-nosuchuser' => "Mah, i arconossoma pa sto nòm. Ch'a dësmentia nen che jë stranòm a son sensìbij al majùscol.",
	'userlogin-error-wrongpassword' => "Atension, ciav pa bon-a. Ch'as sigura che ël majùscol a sia dësblocà e ch'a preuva torna.",
	'userlogin-error-wrongpasswordempty' => "Atension, për piasì ch'a compila ël camp dla ciav.",
	'userlogin-error-resetpass_announce' => "A smija ch'a l'abia dovrà na ciav temporania. Ch'a selession-a na ciav neuva belessì për continué la conession.",
	'userlogin-error-login-throttled' => "A l'ha provà a intré ant ël sistema con na ciav pa bon-a tròpe vire. Ch'a speta un pòch prima ëd prové torna.",
	'userlogin-error-login-userblocked' => "Sò stranòm a l'é stàit blocà e a peul pa esse dovrà për intré ant ël sistema.",
	'userlogin-error-edit-account-closed-flag' => "Tò cont a l'é stàit disabilità da Wikia.",
	'userlogin-error-cantcreateaccount-text' => "Soa adrëssa IP a l'é nen autorisà a creé ëd cont neuv.",
	'userlogin-error-userexists' => "Quaidun a l'ha già së stranòm d'utent. Ch'a na preuva n'àutr!",
	'userlogin-error-invalidemailaddress' => "Për piasì anseriss n'adrëssa ëd pòsta eletrònica bon-a.",
	'userlogin-get-account' => 'Ha-lo pa un cont? <a href="$1" tabindex="$2">Ch\'as anscriva</a>',
	'userlogin-error-invalid-username' => 'Stranòm pa bon',
	'userlogin-error-userlogin-unable-info' => 'An dëspias, i podoma pa registré sò cont al moment.',
	'userlogin-error-user-not-allowed' => "Së stranòm d'utent a l'é pa përmëttù.",
	'userlogin-error-captcha-createaccount-fail' => "la paròla ch'it l'has anserì a corispond pa la paròla ant la casela, preuva torna!",
	'userlogin-error-userlogin-bad-birthday' => "Atension, ch'a compila ël mèis, ël di e l'ann.",
	'userlogin-error-externaldberror' => "An dëspias! Nòstr sit a l'ha al moment un problema, për piasì ch'a preuva torna pi tard.",
	'userlogin-error-noemailtitle' => "Për piasì anseriss n'adrëssa ëd pòsta eletrònica bon-a.",
	'userlogin-error-acct_creation_throttle_hit' => "An dëspias, st'adrëssa IP a l'ha creà tròpi cont ancheuj. Për piasì, ch'a preuva torna pi tard.",
	'userlogin-error-resetpass_forbidden' => 'Le ciav as peulo pa cambiesse',
	'userlogin-error-blocked-mailpassword' => "It peule pa ciamé na neuva ciav përchè st'adrëssa IP a l'é blocà da Wikia.",
	'userlogin-error-throttled-mailpassword' => "I l'oma già mandà n'arciam ëd ciav për sto cont ant {{PLURAL:$1|l'ùltima ora|j'ùltime $1 ore}}. Për piasì, ch'a contròla soa pòsta eletrònica.",
	'userlogin-error-mail-error' => "Contacc, a-i era un problema a mandé sò mëssagi. Për piasì [[Special:Contact/general|ch'an contata]].",
	'userlogin-password-email-sent' => "I l'oma mandà na neuva ciav a l'adrëssa ëd pòsta eletrònica për $1.",
	'userlogin-error-unconfirmed-user' => "An dëspias, a l'ha pa confirmà soa adrëssa ëd pòsta eletrònica. Për piasì, ch'a confirma prima soa adrëssa.",
	'userlogin-password-page-title' => 'Cangia toa ciav',
	'userlogin-oldpassword' => 'Veja ciav',
	'userlogin-newpassword' => 'Neuva ciav',
	'userlogin-retypenew' => 'Che a scriva torna la neuva ciav',
	'userlogin-password-email-subject' => 'Arcesta dla ciav dësmentià',
	'userlogin-password-email-greeting' => 'Cerea $USERNAME,',
	'userlogin-password-email-content' => "Për piasì, ch'a deuvra sta ciav temporania për intré an Wikia: \"\$NEWPASSWORD\"
<br /><br />
S'a l'ha pa ciamà na neuva ciav, ch'as sagrin-a nen! Sò cont a l'é an salute e sigur. A peul ignoré ës mëssagi e continué a intré an Wikia con soa veja ciav.
<br /><br />
Dle chestion o dij dùbit? Ch'an <a href=\"http://community.wikia.com/wiki/Special:Contact/account-issue\">contata pura</a>.",
	'userlogin-password-email-signature' => 'Agiut dla Comunità Wikia',
	'userlogin-password-email-body' => "Cerea $2,

Për piasì, ch'a deuvra costa ciav temporania për intré an Wikia: «$3»

S'a l'has pa ciamà na neuva ciav, ch'as sagrin-a nen! Sò cont a l'é an salute e sigur. A peul ignoré ës mëssagi e continué a intré an Wikia con soa veja ciav.

Dle chestion o dij dùbit? Ch'an contata pura: http://community.wikia.com/wiki/Special:Contact/account-issue

L'agiut dla Comunità Wikia


___________________________________________

Për controlé j'ùltime neuve an Wikia, ch'a vìsita http://community.wikia.com
Veul-lo controlé ij mëssagi ch'a arsèiv? Ch'a vada a: {{fullurl:{{ns:special}}:Preferences}}",
	'userlogin-email-footer-line1' => 'Për controlé j\'ùltime neuve dzor Wikia, ch\'a vìsita <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Veul-lo controlé ij mëssagi ch\'a arsèiv? Ch\'a vada ai sò <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Gust</a>',
	'userlogin-provider-or' => 'O',
	'userlogin-provider-tooltip-facebook' => "Ch'a sgnaca an sël boton për intré ant ël sistema con Facebook",
	'userlogin-provider-tooltip-facebook-signup' => 'Sgnaca ël boton për registrete con Facebook',
	'userlogin-facebook-show-preferences' => 'Smon-e ij gust ëd fluss ëd Facebook',
	'userlogin-facebook-hide-preferences' => 'Stërmé ij gust ëd fluss ëd Facebook',
	'userlogin-loginreqlink' => 'rintré ant ël sistema',
	'userlogin-changepassword-needlogin' => "It l'has dabzògn ëd $1 për cangé toa ciav.",
	'wikiamobile-sendpassword-label' => 'Mandé na ciav neuva',
	'wikiamobile-facebook-connect-fail' => "An dëspias, sò cont Facebook a l'é pa colegà al moment a un cont Wikia.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'userlogin-login-heading' => 'ننوتل',
	'userlogin-forgot-password' => 'پټنوم مو هېر شوی؟',
	'userlogin-error-invalid-username' => 'ناسم کارن-نوم',
	'userlogin-password-page-title' => 'خپل پټنوم بدلول',
	'userlogin-oldpassword' => 'زوړ پټنوم',
	'userlogin-newpassword' => 'نوی پټنوم',
	'userlogin-retypenew' => 'نوی پټنوم مو بيا وليکۍ',
	'userlogin-password-email-greeting' => 'سلامونه $USERNAME،',
	'userlogin-provider-or' => 'يا',
	'userlogin-loginreqlink' => 'ننوتل',
	'wikiamobile-sendpassword-label' => 'نوی پټنوم لېږل',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 * @author SandroHc
 * @author Vitorvicentevalente
 */
$messages['pt'] = array(
	'userlogin-login-heading' => 'Entrar',
	'userlogin-forgot-password' => 'Esqueceu sua senha?',
	'userlogin-forgot-password-button' => 'Continuar',
	'userlogin-forgot-password-go-to-login' => 'Já tem sua senha? [[Special:UserLogin|Faça login]]',
	'userlogin-remembermypassword' => 'Permanecer conectado',
	'userlogin-error-noname' => 'Ops, por favor preencha o campo de nome de usuário.',
	'userlogin-error-nosuchuser' => 'Hum, nós não reconhecemos este nome. Não se esqueça que os nomes de usuários são sensíveis a maiúsculas e minúsculas.',
	'userlogin-error-wrongpassword' => 'Opa, senha errada. Certifique-se que a tecla caps lock está desativada e tente novamente.',
	'userlogin-error-wrongpasswordempty' => 'Ops, por favor preencha o campo de senha.',
	'userlogin-error-resetpass_announce' => 'Parece que você usou uma senha temporária. Escolha uma nova senha aqui para continuar o login.',
	'userlogin-error-edit-account-closed-flag' => 'Sua conta foi desativada pela Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Seu endereço de IP não é permitido para criar novas contas.',
	'userlogin-error-userexists' => 'Alguém já tem este nome de usuário. Tente um diferente!',
	'userlogin-error-invalidemailaddress' => 'Digite um endereço de e-mail válido.',
	'userlogin-get-account' => 'Não possui uma conta? <a href="$1" tabindex="$2">Registe-se</a>',
	'userlogin-error-invalid-username' => 'Nome de usuário inválido',
	'userlogin-error-user-not-allowed' => 'Esse nome de usuário não é permitido.',
	'userlogin-error-noemailtitle' => 'Por favor, digite um endereço de e-mail válido.',
	'userlogin-error-resetpass_forbidden' => 'Senhas não podem ser alteradas',
	'userlogin-error-blocked-mailpassword' => 'Você não pode pedir uma nova senha porque este endereço de IP está bloqueado pela Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Nós já enviamos um lembrete de senha para essa conta {{PLURAL:$1|na última hora|nas últimas $1 horas}}. Por favor, verifique seu e-mail.',
	'userlogin-password-email-sent' => 'Enviamos uma nova senha para o endereço de e-mail para $1.',
	'userlogin-error-unconfirmed-user' => 'Desculpe, você não confirmou seu endereço de e-mail. Por favor, confirme seu endereço de e-mail primeiro.',
	'userlogin-error-confirmation-reminder-already-sent' => 'O e-mail de confirmação já foi enviado.',
	'userlogin-password-page-title' => 'Mude sua senha',
	'userlogin-oldpassword' => 'Senha antiga',
	'userlogin-newpassword' => 'Nova senha',
	'userlogin-retypenew' => 'Confirme a nova senha',
	'userlogin-password-email-greeting' => 'Olá $USERNAME,',
	'userlogin-password-email-signature' => 'Suporte da Comunidade Wikia',
	'userlogin-provider-or' => 'Ou',
	'userlogin-provider-tooltip-facebook' => 'Clique no botão para fazer login com o Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Clique no botão para se registrar com o Facebook',
	'userlogin-facebook-show-preferences' => 'Mostrar as preferências de conexão pelo Facebook',
	'userlogin-facebook-hide-preferences' => 'Ocultar as preferências de conexão pelo Facebook',
	'userlogin-loginreqlink' => 'entrar',
	'userlogin-changepassword-needlogin' => 'Você precisa $1 para modificar sua senha.',
	'wikiamobile-sendpassword-label' => 'Enviar nova senha',
	'wikiamobile-facebook-connect-fail' => 'Desculpe, atualmente sua conta do Facebook não esta vinculada com uma conta na Wikia.',
	'userlogin-logged-in-title' => 'Bem-vindo à {{SITENAME}}!',
	'userlogin-desc' => 'Extensão UserLogin',
	'userlogin-error-sessionfailure' => 'Sua sessão de login expirou. Por favor, faça login novamente.',
	'userlogin-error-login-throttled' => 'Você tentou entrar com a senha errada muitas vezes. Espere um pouco antes de tentar novamente.',
	'userlogin-error-login-userblocked' => 'Seu nome de usuário foi bloqueado e não pode ser usado para fazer login.',
	'userlogin-error-wrongcredentials' => 'Esta combinação de nome de usuário e senha não está correta. Por favor, tente novamente.',
	'userlogin-error-invalidfacebook' => 'Houve um problema ao detectar a sua conta do Facebook; faça login no Facebook e tente novamente.',
	'userlogin-error-fbconnect' => 'Houve um problema ao conectar a sua conta da Wikia com o Facebook.',
	'userlogin-account-admin-error' => 'Opa! Algo deu errado. Por favor, entre em contato com [[Especial:Contact|a Wikia]] para suporte.',
	'userlogin-error-userlogin-unable-info' => 'Desculpe, mas não somos capazes de registrar sua conta neste momento.',
	'userlogin-error-captcha-createaccount-fail' => 'A palavra que você digitou não corresponde a palavra na caixa, tente novamente!',
	'userlogin-error-userlogin-bad-birthday' => 'Ops, por favor preencha mês, dia e ano.',
	'userlogin-error-externaldberror' => 'Desculpe! Nosso site está tendo um problema, por favor, tente novamente mais tarde.',
	'userlogin-error-acct_creation_throttle_hit' => 'Desculpe, este endereço de IP criou muitas contas hoje. Por favor, tente novamente mais tarde.',
	'userlogin-opt-in-label' => 'Envie-me e-mails sobre eventos e notícias da Wikia',
	'userlogin-error-mail-error' => 'Ops, ocorreu um problema no envio do seu e-mail. Por favor [[Special:Contact/general|contate-nos]].',
	'userlogin-password-email-subject' => 'Solicitação de senha esquecida',
	'userlogin-password-email-content' => 'Por favor, use essa senha temporária para se conectar na Wikia: "$NEWPASSWORD"
<br /><br />
Se você não solicitou uma nova senha, não se preocupe! Sua conta está segura e protegida. Você pode ignorar este e-mail e continuar fazendo o login na Wikia com sua antiga senha.
<br /><br />
Dúvidas ou preocupações? Sinta-se livre para <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">nos contatar</a>.',
	'userlogin-password-email-body' => 'Olá $2,

Por favor, use essa senha temporária para se conectar na Wikia: "$3"

Se você não solicitou uma nova senha, não se preocupe! Sua conta está segura e protegida. Você pode ignorar este e-mail e continuar fazendo o login na Wikia com sua antiga senha.

Dúvidas ou preocupações? Sinta-se livre para nos contatar: http://community.wikia.com/wiki/Special:Contact/account-issue

Suporte da Comunidade Wikia


___________________________________________

Para ver os últimos acontecimentos na Wikia, visite http://pt.community.wikia.com
Deseja controlar quais e-mails você recebe? Vá para: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line1' => 'Para ver os últimos acontecimentos na Wikia, visite <a style="color:#2a87d5;text-decoration:none;" href="http://pt.community.wikia.com">pt.community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Deseja controlar os e-mails que você recebe? Vá para suas <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferências</a>',
	'userlogin-email-footer-line3' => '<a href="http://www.twitter.com/WikiaBR" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/WikiaBrasil" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/WikiaPT" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://comunidade.wikia.com/wiki/Blog:Notícias da Comunidade" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'userlogin-logged-in-message' => 'Você está conectado. Vá a [[$1|página principal]] para ver as novidades ou checar o seu [[$2|perfil]].',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Cainamarques
 * @author Caio1478
 * @author JM Pessanha
 * @author Jefersonmoraes
 * @author Luckas
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'userlogin-login-heading' => 'Entrar',
	'userlogin-forgot-password' => 'Esqueceu sua senha?',
	'userlogin-forgot-password-button' => 'Continuar',
	'userlogin-forgot-password-go-to-login' => 'Já tem sua senha? [[Special:UserLogin|Faça login]]',
	'userlogin-remembermypassword' => 'Permanecer conectado',
	'userlogin-error-noname' => 'Ops, por favor preencha o campo de nome de usuário.',
	'userlogin-error-sessionfailure' => 'Sua sessão de login expirou. Por favor, faça login novamente.',
	'userlogin-error-nosuchuser' => 'Hum, nós não reconhecemos este nome. Não se esqueça que os nomes de usuários são sensíveis a maiúsculas e minúsculas.',
	'userlogin-error-wrongpassword' => 'Opa, senha errada. Certifique-se que a tecla caps lock está desativada e tente novamente.',
	'userlogin-error-wrongpasswordempty' => 'Ops, por favor preencha o campo de senha.',
	'userlogin-error-resetpass_announce' => 'Parece que você usou uma senha temporária. Escolha uma nova senha aqui para continuar o login.',
	'userlogin-error-login-throttled' => 'Você tentou entrar com a senha errada muitas vezes. Espere um pouco antes de tentar novamente.',
	'userlogin-error-login-userblocked' => 'Seu nome de usuário foi bloqueado e não pode ser usado para fazer login.',
	'userlogin-error-edit-account-closed-flag' => 'Sua conta foi desativada pela Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Seu endereço de IP não é permitido para criar novas contas.',
	'userlogin-error-userexists' => 'Alguém já tem este nome de usuário. Tente um diferente!',
	'userlogin-error-invalidemailaddress' => 'Digite um endereço de e-mail válido.',
	'userlogin-get-account' => 'Não possui uma conta? <a href="$1" tabindex="$2">Registe-se</a>',
	'userlogin-error-invalid-username' => 'Nome de usuário inválido',
	'userlogin-error-userlogin-unable-info' => 'Desculpe, mas não somos capazes de registrar sua conta neste momento.',
	'userlogin-error-user-not-allowed' => 'Esse nome de usuário não é permitido.',
	'userlogin-error-captcha-createaccount-fail' => 'A palavra que você digitou não corresponde a palavra na caixa, tente novamente!',
	'userlogin-error-userlogin-bad-birthday' => 'Ops, por favor preencha mês, dia e ano.',
	'userlogin-error-externaldberror' => 'Desculpe! Nosso site está tendo um problema, por favor, tente novamente mais tarde.',
	'userlogin-error-noemailtitle' => 'Por favor, digite um endereço de e-mail válido.',
	'userlogin-error-acct_creation_throttle_hit' => 'Desculpe, este endereço de IP criou muitas contas hoje. Por favor, tente novamente mais tarde.',
	'userlogin-error-resetpass_forbidden' => 'Senhas não podem ser alteradas',
	'userlogin-error-blocked-mailpassword' => 'Você não pode pedir uma nova senha porque este endereço de IP está bloqueado pela Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Nós já enviamos um lembrete de senha para essa conta {{PLURAL:$1|na última hora|nas últimas $1 horas}}. Por favor, verifique seu e-mail.',
	'userlogin-error-mail-error' => 'Ops, ocorreu um problema no envio do seu e-mail. Por favor [[Special:Contact/general|contate-nos]].',
	'userlogin-password-email-sent' => 'Enviamos uma nova senha para o endereço de e-mail para $1.',
	'userlogin-error-unconfirmed-user' => 'Desculpe, você não confirmou seu endereço de e-mail. Por favor, confirme seu endereço de e-mail primeiro.',
	'userlogin-error-confirmation-reminder-already-sent' => 'O e-mail de confirmação já foi enviado.',
	'userlogin-password-page-title' => 'Mude sua senha',
	'userlogin-oldpassword' => 'Senha antiga',
	'userlogin-newpassword' => 'Nova senha',
	'userlogin-retypenew' => 'Confirme a nova senha',
	'userlogin-password-email-subject' => 'Solicitação de senha esquecida',
	'userlogin-password-email-greeting' => 'Olá $USERNAME,',
	'userlogin-password-email-content' => 'Por favor, use essa senha temporária para se conectar na Wikia: "$NEWPASSWORD"
<br /><br />
Se você não solicitou uma nova senha, não se preocupe! Sua conta está segura e protegida. Você pode ignorar este e-mail e continuar fazendo o login na Wikia com sua antiga senha.
<br /><br />
Dúvidas ou preocupações? Sinta-se livre para <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">nos contatar</a>.',
	'userlogin-password-email-signature' => 'Suporte da Comunidade Wikia',
	'userlogin-password-email-body' => 'Olá $2,

Por favor, use essa senha temporária para se conectar na Wikia: "$3"

Se você não solicitou uma nova senha, não se preocupe! Sua conta está segura e protegida. Você pode ignorar este e-mail e continuar fazendo o login na Wikia com sua antiga senha.

Dúvidas ou preocupações? Sinta-se livre para nos contatar: http://community.wikia.com/wiki/Special:Contact/account-issue

Suporte da Comunidade Wikia


___________________________________________

Para ver os últimos acontecimentos na Wikia, visite http://pt.community.wikia.com
Deseja controlar quais e-mails você recebe? Vá para: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Para ver os últimos acontecimentos na Wikia, visite <a style="color:#2a87d5;text-decoration:none;" href="http://pt.community.wikia.com">pt.community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Deseja controlar os e-mails que você recebe? Vá para suas <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferências</a>',
	'userlogin-provider-or' => 'Ou',
	'userlogin-provider-tooltip-facebook' => 'Clique no botão para fazer login com o Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Clique no botão para se registrar com o Facebook',
	'userlogin-facebook-show-preferences' => 'Mostrar as preferências de conexão pelo Facebook',
	'userlogin-facebook-hide-preferences' => 'Ocultar as preferências de conexão pelo Facebook',
	'userlogin-loginreqlink' => 'entrar',
	'userlogin-changepassword-needlogin' => 'Você precisa $1 para modificar sua senha.',
	'wikiamobile-sendpassword-label' => 'Enviar nova senha',
	'wikiamobile-facebook-connect-fail' => 'Desculpe, atualmente sua conta do Facebook não esta vinculada com uma conta na Wikia.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'userlogin-login-heading' => 'Tràse',
	'userlogin-forgot-password' => "T'è scurdate 'a passuord?",
	'userlogin-error-invalid-username' => "Nome de l'utende invalide",
	'userlogin-error-user-not-allowed' => "Stu nome de utende non g'è permesse.",
	'userlogin-password-page-title' => "Cange 'a passuord toje",
	'userlogin-oldpassword' => 'Vécchia passuord',
	'userlogin-newpassword' => 'Nova passuord',
	'userlogin-retypenew' => "Scrive n'otra vota 'a passuord nova",
	'userlogin-password-email-subject' => 'Richieste pa passuord scurdate',
	'userlogin-password-email-greeting' => 'Cià $USERNAME,',
	'userlogin-provider-or' => 'O',
	'userlogin-loginreqlink' => 'trase',
);

/** Russian (русский)
 * @author Kuzura
 * @author Okras
 */
$messages['ru'] = array(
	'userlogin-login-heading' => 'Войти',
	'userlogin-forgot-password' => 'Забыли пароль?',
	'userlogin-forgot-password-button' => 'Продолжить',
	'userlogin-forgot-password-go-to-login' => 'Уже есть пароль? [[Special:UserLogin|Войти]]',
	'userlogin-remembermypassword' => 'Оставаться в системе',
	'userlogin-error-noname' => 'Пожалуйста, заполните строку «Имя участника».',
	'userlogin-error-sessionfailure' => 'Превышено время ожидания. Пожалуйста, войдите снова.',
	'userlogin-error-nosuchuser' => 'Данное имя не зарегистрировано. Не забывайте, что имена участников чувствительны к регистру.',
	'userlogin-error-wrongpassword' => 'Неправильный пароль. Возможно, вам надо отключить Caps Lock и повторить попытку.',
	'userlogin-error-wrongpasswordempty' => 'Пожалуйста, заполните строку «Пароль».',
	'userlogin-error-resetpass_announce' => 'Похоже, что вы использовали временный пароль. Введите новый пароль здесь, чтобы войти в систему.',
	'userlogin-error-login-throttled' => 'Вы пытались войти в систему используя неправильный пароль слишком много раз. Подождите какое-то время перед повторной попыткой.',
	'userlogin-error-login-userblocked' => 'Ваше имя участника было заблокировано и не может быть использовано для входа в систему.',
	'userlogin-error-edit-account-closed-flag' => 'Ваш аккаунт был отключён на всей Викия.',
	'userlogin-error-cantcreateaccount-text' => 'С вашего IP-адреса запрещено создавать новые учётные записи.',
	'userlogin-error-userexists' => 'Кто-то уже зарегистрировал это имя участника. Выберите другое.',
	'userlogin-error-invalidemailaddress' => 'Пожалуйста, введите действительный адрес электронной почты.',
	'userlogin-error-wrongcredentials' => 'Неверная комбинация имени пользователя и пароля. Пожалуйста, попробуйте ещё раз.',
	'userlogin-error-invalidfacebook' => 'Возникла проблема с обнаружением вашей учётной записи Facebook. Пожалуйста, войдите в Facebook и попробуйте ещё раз.',
	'userlogin-error-fbconnect' => 'Возникла проблема при подключении вашей учётной записи Викия к Facebook.',
	'userlogin-get-account' => 'Нет учётной записи? <a href="$1" tabindex="$2">Зарегистрироваться</a>',
	'userlogin-error-invalid-username' => 'Неверное имя участника',
	'userlogin-error-userlogin-unable-info' => 'К сожалению, мы не можем зарегистрировать вашу учётную запись.',
	'userlogin-error-user-not-allowed' => 'Недопустимое имя участника.',
	'userlogin-error-captcha-createaccount-fail' => 'Слово, которое вы ввели, не соответствует слову в окошке. Попробуйте ещё раз.',
	'userlogin-error-userlogin-bad-birthday' => 'Пожалуйста, заполните месяц, день и год.',
	'userlogin-error-externaldberror' => 'В настоящее время мы испытываем технические трудности. Пожалуйста, зайдите позже.',
	'userlogin-error-noemailtitle' => 'Пожалуйста, введите действительный адрес электронной почты.',
	'userlogin-error-acct_creation_throttle_hit' => 'Сегодня с этого IP-адреса было создано слишком много аккаунтов. Пожалуйста, попробуйте зарегистрироваться позже..',
	'userlogin-opt-in-label' => 'Оповещать меня о новостях и событиях Викия',
	'userlogin-error-resetpass_forbidden' => 'Пароли нельзя изменить',
	'userlogin-error-blocked-mailpassword' => 'Вы не можете запросить новый пароль, так как Ваш IP-адрес был заблокирован.',
	'userlogin-error-throttled-mailpassword' => 'Мы уже отправили пароль для этой учётной записи {{PLURAL:$1| час|$1 часов}} назад. Пожалуйста, проверьте свою электронную почту.',
	'userlogin-error-mail-error' => 'К сожалению, возникла проблема с отправкой писем на вашу электронную почту. Пожалуйста, [[Special:Contact/general|свяжитесь с нами]].',
	'userlogin-password-email-sent' => 'Мы направили новый пароль на почту $1.',
	'userlogin-error-unconfirmed-user' => 'Извините, но вы ещё не подтвердили свой адрес электронной почты. Пожалуйста, сделайте это сейчас.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Электронное письмо с подтверждением уже отправлено.',
	'userlogin-password-page-title' => 'Изменить пароль',
	'userlogin-oldpassword' => 'Старый пароль',
	'userlogin-newpassword' => 'Новый пароль',
	'userlogin-retypenew' => 'Повторить новый пароль',
	'userlogin-password-email-subject' => 'Запросить забытый пароль',
	'userlogin-password-email-greeting' => 'Здравствуйте, $USERNAME',
	'userlogin-password-email-content' => 'Пожалуйста, используйте этот временный пароль для входа в систему: «$NEWPASSWORD»
<br /><br />
Если вы не запрашивали новый пароль, не волнуйтесь! Ваша учётная запись в безопасности и надёжно защищена. Вы можете игнорировать это сообщение и использовать старый пароль для входа на Викия.
<br /><br />
Вопросы или проблемы? <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">Свяжитесь с нами</a>.',
	'userlogin-password-email-signature' => 'Команда Викия',
	'userlogin-password-email-body' => 'Здравствуйте, $2

Пожалуйста, используйте этот временный пароль для входа в Викия: «$3»

Если вы не запрашивали новый пароль, не волнуйтесь! Ваша учётная запись в безопасности и надёжно защищена. Вы можете игнорировать это сообщение и использовать старый пароль для входа на Викия.

Вопросы или проблемы? Свяжитесь с нами: http://community.wikia.com/wiki/Special:Contact/account-issue

Команда Викия


___________________________________________

Чтобы проверить последние новости Викия, посетите http://community.wikia.com
Хотите настроить рассылки и оповещения от Викия? Перейдите в {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Чтобы узнать о последних новостях Викия, посетите <a style="color:#2a87d5;text-decoration:none;" href="http://ru.community.wikia.com">ru.community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Хотите настроить рассылки и оповещения от Викия? Перейдите в <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">личные настройки</a>',
	'userlogin-provider-or' => 'Или',
	'userlogin-provider-tooltip-facebook' => 'Нажмите на кнопку, чтобы войти в систему через Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Нажмите на кнопку, чтобы зарегистрироваться через Facebook',
	'userlogin-facebook-show-preferences' => 'Показать настройки Facebook',
	'userlogin-facebook-hide-preferences' => 'Скрыть настройки Facebook',
	'userlogin-loginreqlink' => 'войти',
	'userlogin-changepassword-needlogin' => 'Вам нужно $1, чтобы изменить свой пароль.',
	'wikiamobile-sendpassword-label' => 'Отправить новый пароль',
	'wikiamobile-facebook-connect-fail' => 'К сожалению, ваш аккаунт на Facebook в настоящее время не связан с учётной записью на Викия.',
	'userlogin-logged-in-title' => 'Добро пожаловать на сайт {{SITENAME}}, $1!',
	'userlogin-desc' => 'Расширение «UserLogin»',
	'userlogin-account-admin-error' => 'К сожалению, произошла ошибка. Пожалуйста, [[Special:Contact|свяжитесь с нами]].',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="http://ru.community.wikia.com/wiki/Блог:Все_сообщения" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia.ru" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.twitter.com/wikia_ru" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>',
	'userlogin-logged-in-message' => 'Вы вошли в систему. Зайдите на [[$1|домашнюю страницу]] за последними новостями или проверьте свой [[$2|профайл]].',
);

/** Scots (Scots)
 * @author John Reid
 */
$messages['sco'] = array(
	'userlogin-login-heading' => 'Log in',
	'userlogin-forgot-password' => 'Ferget yer passwaird?',
	'userlogin-forgot-password-button' => 'Continue',
	'userlogin-forgot-password-go-to-login' => 'Hae yer passwaird awreadie? [[Special:UserLogin|Log in]]',
	'userlogin-remembermypassword' => 'Stey loggit in',
	'userlogin-error-noname' => 'Oops, please fil in the uisername field.',
	'userlogin-error-sessionfailure' => 'Yer log in session haes timed oot. Please log in again.',
	'userlogin-error-nosuchuser' => 'Hm, we dinna recognise this name. Dinna ferget, uisernames ar case sensitive.',
	'userlogin-error-wrongpassword' => 'Oops, wrang passwaird. Mak sair that the caps lock is aff n gie it anither shot.',
	'userlogin-error-wrongpasswordempty' => 'Oops, please fil in the passwaird field.',
	'userlogin-error-resetpass_announce' => 'It luiks like ye uised ae temparie passwaird. Pick ae new passwaird here tae continue loggin in.',
	'userlogin-error-login-throttled' => "Ye'v tried tae log in wi the wrang passwaird ower monie times. Wait ae while afore giein it anither shot.",
	'userlogin-error-login-userblocked' => 'Yer uisername haes been blockit n canna be uised tae log in.',
	'userlogin-error-edit-account-closed-flag' => 'Yer accoont haes been disabled bi Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Yer IP address isna alloued tae creaut new accoonts.',
	'userlogin-error-userexists' => 'Somebodie awreadie haes this uisername. Gie anither yin ae shot!',
	'userlogin-error-invalidemailaddress' => 'Please enter ae valid e-mail address.',
	'userlogin-get-account' => 'Dinna hae aen accoont? <a href="$1" tabindex="$2">Sign up</a>',
	'userlogin-error-invalid-username' => 'Onvalid uisername',
	'userlogin-error-userlogin-unable-info' => "Sorrie, we'r no able tae register yer accoont at this time.",
	'userlogin-error-user-not-allowed' => 'This uisername isna alloued.',
	'userlogin-error-captcha-createaccount-fail' => 'The waird that ye entered didna match the waird in the kist, gie it anither shot!',
	'userlogin-error-userlogin-bad-birthday' => 'Oops, please fil oot day, month, n year.',
	'userlogin-error-externaldberror' => 'Sorrie! Oor site is haein aen issue the nou, please gie it anither later.',
	'userlogin-error-noemailtitle' => 'Please enter ae valid e-mail address.',
	'userlogin-error-acct_creation_throttle_hit' => 'Sorrie, this IP address haes creautit ower monie accoonts theday. Please gie it another shot later.',
	'userlogin-error-resetpass_forbidden' => 'Passwairds canna be chynged',
	'userlogin-error-blocked-mailpassword' => 'Ye canna speir fer ae new passwaird cause this IP address is blockit bi Wikia.',
	'userlogin-error-throttled-mailpassword' => "We'v awreadie sent ae passwaird reminder tae this accoont in the laist {{PLURAL:$1|hoor|$1 hoors}}. Please check yer e-mail.",
	'userlogin-error-mail-error' => 'Oops, thaur wis ae proablem sendin yer e-mail. Please [[Special:Contact/general|contact us]].',
	'userlogin-password-email-sent' => "We'v sent ae new passwaird tae the e-mail address fer $1.",
	'userlogin-error-unconfirmed-user' => "Sorrie, ye'v no confirmed yer e-mail. Please confirm yer e-mail first.",
	'userlogin-error-confirmation-reminder-already-sent' => 'Confirmation reminder e-mail awreadie sent.',
	'userlogin-password-page-title' => 'Chynge yer passwaird',
	'userlogin-oldpassword' => 'Auld passwaird',
	'userlogin-newpassword' => 'New passwaird',
	'userlogin-retypenew' => 'Retype new passwaird',
	'userlogin-password-email-subject' => 'Fergotten passwaird request',
	'userlogin-password-email-greeting' => 'Hallo $USERNAME,',
	'userlogin-password-email-content' => 'Please uise this temparie passwaird tae log in tae Wikia: "$NEWPASSWORD"
<br /><br />
Gif ye didna speir fer ae new passwaird, dinna fash! Yer accoont is safe n secure. Ye can ignore this e-mail n continue tae log in tae Wikia wi yer auld passwaird.
<br /><br />
Speirins or concerns? Feel free tae <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">contact us</a>.',
	'userlogin-password-email-signature' => 'Wikia Communitie Support',
	'userlogin-password-email-body' => 'Hallo $2,

Please uise this temparie passwaird tae log in tae Wikia: "$3"

Gif ye didna speir fer ae new passwaird, dinna fash! Yer accoont is safe n secure. Ye can ignore this e-mail n continue tae log in tae Wikia wi yer auld passwaird.

Speirins or concerns? Feel free tae contact us: http://community.wikia.com/wiki/Special:Contact/account-issue

Wikia Communitie Support


___________________________________________

Tae check oot the latest happenins oan Wikia, veesit http://community.wikia.com
Want tae control whit wab-mails ye receive? Gang til: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Tae check oot the maist recynt happenins oan Wikia, veesit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Want tae control whit e-mails ye receeve? Gang tae yer <a href="{{fullurl:{{ns:special}}:Preferances}}" style="color:#2a87d5;text-decoration:none;">Preferances</a>',
	'userlogin-provider-or' => 'Or',
	'userlogin-provider-tooltip-facebook' => 'Clap oan the button tae log in wi Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Clap oan the button tae sign up wi Facebook',
	'userlogin-facebook-show-preferences' => 'Shaw Facebook feed preferances',
	'userlogin-facebook-hide-preferences' => 'Skauk Facebook feed preferences',
	'userlogin-loginreqlink' => 'log in',
	'userlogin-changepassword-needlogin' => 'Ye need tae $1 tae chynge yer passwaird.',
	'wikiamobile-sendpassword-label' => 'Send new passwaird',
	'wikiamobile-facebook-connect-fail' => 'Sorrie, yer Facebook accoont is no airtit wi ae Wikia accoont richt nou.',
);

/** Serbian (српски / srpski)
 * @author Dicto23456
 */
$messages['sr'] = array(
	'userlogin-error-invalidfacebook' => 'Проблем приликом
постављања вашег налога на
Facebook. Пријавите се на
Facebооk и покушајте
поново.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Bebauautu
 * @author Milicevic01
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'userlogin-login-heading' => 'Пријава',
	'userlogin-forgot-password' => 'Заборавили сте лозинку?',
	'userlogin-remembermypassword' => 'Остави ме пријављеног/у',
	'userlogin-error-noname' => 'Попуните поље за корисничко име.',
	'userlogin-error-sessionfailure' => 'Ваша сесија је истекла. Пријавите се поново.',
	'userlogin-error-nosuchuser' => 'Корисничко име не постоји. Не заборавите да систем разликује мала и велика слова.',
	'userlogin-error-wrongpassword' => 'Погрешна лозинка. Проверите да не пишете великим словима и покушајте поново.',
	'userlogin-error-wrongpasswordempty' => 'Попуните поље за лозинку.',
	'userlogin-error-resetpass_announce' => 'Изгледа да сте искористили привремену лозинку. Овде изаберите нову, па продужите с пријавом.',
	'userlogin-error-login-throttled' => 'Превише пута сте унели погрешну лозинку. Сачекајте мало, па покушајте поново.',
	'userlogin-error-login-userblocked' => 'Ваше корисничко име је блокирано, па зато не можете да се пријавите с њим.',
	'userlogin-error-edit-account-closed-flag' => 'Викија је онемогућила ваш налог.',
	'userlogin-error-cantcreateaccount-text' => 'Вашој ИП адреси није дозвољено да прави нове налоге.',
	'userlogin-error-userexists' => 'Корисничко име је заузето. Изаберите друго.',
	'userlogin-error-invalidemailaddress' => 'Унесите исправну е-адресу.',
	'userlogin-get-account' => 'Немате налог? <a href="$1" tabindex="$2">Отворите га</a>',
	'userlogin-error-invalid-username' => 'Неисправно корисничко име',
	'userlogin-error-userlogin-unable-info' => 'Нажалост, тренутно не можете да се региструјете.',
	'userlogin-error-user-not-allowed' => 'Корисничко име није дозвољено.',
	'userlogin-error-captcha-createaccount-fail' => 'Наведена реч се не поклапа с оном у пољу. Покушајте поново.',
	'userlogin-error-userlogin-bad-birthday' => 'Попуните месец, дан и годину.',
	'userlogin-error-externaldberror' => 'Извините! Тренутно се суочавамо с проблемом. Покушајте касније.',
	'userlogin-error-noemailtitle' => 'Унесите исправну е-адресу.',
	'userlogin-error-acct_creation_throttle_hit' => 'Нажалост, ова ИП адреса је направила превише налога за данас. Покушајте касније.',
	'userlogin-error-resetpass_forbidden' => 'Лозинка не може да се мења',
	'userlogin-error-blocked-mailpassword' => 'Не можете да захтевате нову лозинку јер је ову ИП адресу блокирала Викија.',
	'userlogin-error-throttled-mailpassword' => 'Већ смо вам послали подсетник за лозинку на овај налог у {{PLURAL:$1|последњих сат времена|последња $1 сата|у последњих $1 сати}}. Проверите е-пошту.',
	'userlogin-error-mail-error' => 'Дошло је до проблема при слању поруке. Молимо вас, [[Special:Contact/general|контактирајте с нама]].',
	'userlogin-password-email-sent' => 'Нова лозинка је послата на е-адресу корисника $1.',
	'userlogin-error-unconfirmed-user' => 'Нажалост, нисте потврдили своју е-адресу. Најпре треба да је потврдите.',
	'userlogin-password-page-title' => 'Промените лозинку',
	'userlogin-oldpassword' => 'Стара лозинка',
	'userlogin-newpassword' => 'Нова лозинка',
	'userlogin-retypenew' => 'Потврда лозинке',
	'userlogin-password-email-subject' => 'Захтев за повратак лозинке',
	'userlogin-password-email-greeting' => 'Здраво, $USERNAME,',
	'userlogin-password-email-content' => 'Искористите ову привремену лозинку да бисте се пријавили на Викију: „$NEWPASSWORD“
<br /><br />
Ако нисте захтевали нову лозинку, не брините! Ваш кориснички налог је сигуран. Занемарите ову поруку и наставите да се пријављујете на Викију користећи стару лозинку.
<br /><br />
Имате питања и предлоге? Слободно контактирајте с нама.',
	'userlogin-password-email-signature' => 'Подршка за заједницу Викије',
	'userlogin-password-email-body' => 'Здраво, $2,

Искористите ову привремену лозинку да бисте се пријавили на Викију: „$3“

Ако нисте захтевали нову лозинку, не брините! Ваш кориснички налог је сигуран. Занемарите ову поруку и наставите да се пријављујете на Викију користећи стару лозинку.

Имате питања или предлога? Слободно контактирајте с нама.

Подршка за заједницу Викије


___________________________________________

Да бисте погледали најновија дешавања на Викији, посетите  http://community.wikia.com
Желите да изаберете шта желите да примате преко е-поште? Идите на {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Да бисте погледали најновија дешавања на Викији, посетите <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Желите да изаберете које поруке ћете примати? Идите на <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Подешавања</a>',
	'userlogin-provider-or' => 'или',
	'userlogin-provider-tooltip-facebook' => 'Кликните на дугме да бисте се пријавили путем Фејсбука',
	'userlogin-provider-tooltip-facebook-signup' => 'Кликните на дугме да бисте се регистровали путем Фејсбука',
	'userlogin-facebook-show-preferences' => 'Прикажи поставке довода Фејсбука',
	'userlogin-facebook-hide-preferences' => 'Сакриј поставке довода Фејсбука',
	'userlogin-loginreqlink' => 'се пријавите',
	'userlogin-changepassword-needlogin' => 'Треба да $1 да бисте променили лозинку.',
	'wikiamobile-sendpassword-label' => 'Пошаљи нову лозинку',
	'wikiamobile-facebook-connect-fail' => 'Нажалост, ваш налог на Фејсбуку није повезан с налогом на Викији.',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'userlogin-desc' => 'UserLogin-tillägget',
	'userlogin-login-heading' => 'Logga in',
	'userlogin-forgot-password' => 'Glömt ditt lösenord?',
	'userlogin-forgot-password-button' => 'Fortsätt',
	'userlogin-forgot-password-go-to-login' => 'Har du redan ditt lösenord? [[Special:UserLogin|Logga in]]',
	'userlogin-remembermypassword' => 'Förbli inloggad',
	'userlogin-error-noname' => 'Hoppsan, var god fyll i användarnamnsfältet.',
	'userlogin-error-sessionfailure' => 'Din inloggningssession har löpt ut. Var god logga in igen.',
	'userlogin-error-nosuchuser' => 'Vi känner inte igen detta namn. Glöm inte att användarnamn är skiftlägeskänsliga.',
	'userlogin-error-wrongpassword' => 'Hoppsan, fel lösenord. Se till att Caps Lock är inaktiverat och försök igen.',
	'userlogin-error-wrongpasswordempty' => 'Hoppsan, var god fyll i lösenordsfältet.',
	'userlogin-error-resetpass_announce' => 'Det ser ut som du använde ett temporärt lösenord. Välj ett nytt lösenord här för att fortsätta inloggningen.',
	'userlogin-error-login-throttled' => 'Du har försökt logga in med fel lösenord för många gånger. Vänta ett stund innan du försöker igen.',
	'userlogin-error-login-userblocked' => 'Ditt användarnamn har blockerats och kan inte användas för att logga in.',
	'userlogin-error-edit-account-closed-flag' => 'Ditt konto har inaktiverats av Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Din IP-adress har inte tillåtelse att skapa nya konton.',
	'userlogin-error-userexists' => 'Någon har redan detta användarnamn. Prova ett annat!',
	'userlogin-error-invalidemailaddress' => 'Var god ange en giltig e-postadress.',
	'userlogin-error-wrongcredentials' => 'Denna kombination av användarnamn och lösenord är inte korrekt. Var god försök igen.',
	'userlogin-error-invalidfacebook' => 'Ett problem uppstod när ditt Facebook-konto skulle hittas; logga in på Facebook och försök igen.',
	'userlogin-error-fbconnect' => 'Ett problem uppstod när ditt Wikia-konto skulle anslutas till Facebook.',
	'userlogin-get-account' => 'Har du inte ett konto? <a href="$1" tabindex="$2">Registrera dig</a>',
	'userlogin-error-invalid-username' => 'Ogiltigt användarnamn',
	'userlogin-error-userlogin-unable-info' => 'Tyvärr, vi kan inte registrera ditt konto för tillfället.',
	'userlogin-error-user-not-allowed' => 'Ditt användarnamn är inte tillåtet.',
	'userlogin-error-captcha-createaccount-fail' => 'Ordet du skrev in stämde inte överens med ordet i lådan, försök igen!',
	'userlogin-error-userlogin-bad-birthday' => 'Hoppsan, var god fyll i månad, dag och år.',
	'userlogin-error-externaldberror' => 'Tyvärr! Vår sida har för tillfället stött på ett fel. Var god försök igen senare.',
	'userlogin-error-noemailtitle' => 'Var god ange en giltig e-postadress.',
	'userlogin-error-acct_creation_throttle_hit' => 'Tyvärr, denna IP-adress har skapat för många konton idag. Var god försök igen senare.',
	'userlogin-opt-in-label' => 'Skicka e-post om nyheter och händelser på Wikia',
	'userlogin-error-resetpass_forbidden' => 'Lösenord kan inte ändras',
	'userlogin-error-blocked-mailpassword' => 'Du kan inte begära ett nytt lösenord eftersom denna IP-adress är blockerad av Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Vi har redan skickat ett lösenordspåminnelse till detta konto inom {{PLURAL:$1|den senaste timmen|de senaste $1 timmarna}}. Var god kolla din e-post.',
	'userlogin-error-mail-error' => 'Hoppsan, ett fel uppstod när det skulle skickas till din e-post. Var god [[Special:Contact/general|kontakta oss]].',
	'userlogin-password-email-sent' => 'Vi har skickat ett nytt lösenord till e-postadressen för $1.',
	'userlogin-error-unconfirmed-user' => 'Tyvärr, du har inte bekräftat din e-postadress. Var god bekräfta din e-postadress först.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Bekräftelsepåminnelse har redan skickats via e-post.',
	'userlogin-password-page-title' => 'Ändra ditt lösenord',
	'userlogin-oldpassword' => 'Gammalt lösenord',
	'userlogin-newpassword' => 'Nytt lösenord',
	'userlogin-retypenew' => 'Upprepa nytt lösenord',
	'userlogin-password-email-subject' => 'Begäran om glömt lösenord',
	'userlogin-password-email-greeting' => 'Hej $USERNAME,',
	'userlogin-password-email-content' => 'Var god använd detta temporära lösenord för att logga in på Wikia: "$NEWPASSWORD"
<br /><br />
Om du inte begärde ett nytt lösenord, oroa dig inte! Ditt konto är tryggt och säkert. Du kan ignorera detta e-postmeddelande och fortsätta logga in på Wikia med ditt gamla lösenord.
<br /><br />
Frågor eller problem? <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">Kontakta oss gärna</a>.',
	'userlogin-password-email-signature' => 'Wikia gemenskapssupport',
	'userlogin-password-email-body' => 'Hej $2,

Var god använd detta temporära lösenord för att logga in på Wikia: "$3"

Om du inte begärde ett nytt lösenord, oroa dig inte! Ditt konto är tryggt och säkert. Du kan ignorera detta e-postmeddelande och fortsätta logga in på Wikia med ditt gamla lösenord.

Frågor eller problem? Kontakta oss gärna: http://community.wikia.com/wiki/Special:Contact/account-issue

Wikia gemenskapssupport


___________________________________________

För att kolla in de senaste händelserna på Wikia, besök http://community.wikia.com
Vill du kontrollera vilka e-postmeddelanden du får? Gå till: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'För att kolla in de senaste händelserna på Wikia, besök <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Vill du kontrollera vilka e-postmeddelanden du får? Gå till dina <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">inställningar</a>',
	'userlogin-provider-or' => 'Eller',
	'userlogin-provider-tooltip-facebook' => 'Klicka på knappen Logga in med Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Klicka på knappen för att registrera dig med Facebook',
	'userlogin-facebook-show-preferences' => 'Visa inställningar för Facebook-flöde',
	'userlogin-facebook-hide-preferences' => 'Dölj inställningar för Facebook-flöde',
	'userlogin-loginreqlink' => 'logga in',
	'userlogin-changepassword-needlogin' => 'Du måste $1 för att ändra ditt lösenord.',
	'wikiamobile-sendpassword-label' => 'Skicka nytt lösenord',
	'wikiamobile-facebook-connect-fail' => 'Tyvärr, ditt Facebook-konto är för tillfället inte är länkat med ett Wikia-konto.',
	'userlogin-logged-in-title' => 'Välkommen till {{SITENAME}}, $1!',
	'userlogin-logged-in-message' => 'Du är inloggad. Gå till [[$1|huvudsidan]] för att få senaste nytt eller kolla din [[$2|profil]].',
);

/** Tamil (தமிழ்)
 * @author மதனாஹரன்
 */
$messages['ta'] = array(
	'userlogin-login-heading' => 'உள்நுழையவும்',
	'userlogin-forgot-password' => 'உங்கள் கடவுச் சொல்லை மறந்து விட்டீர்களா?',
	'userlogin-remembermypassword' => 'உள்நுழைந்து இருக்கவும்',
	'userlogin-error-noname' => 'ஓ, தயவு செய்து பயனர் பெயர்ப் புலத்தை நிரப்பவும்.',
	'userlogin-error-wrongpassword' => 'ஓ, தவறான கடவுச் சொல். மேற்றட்டுப் பூட்டு நிறுத்தப்பட்டுள்ளது என்பதை உறுதி செய்து கொண்டு மீண்டும் முயற்சிக்கவும்.',
	'userlogin-error-wrongpasswordempty' => 'ஓ, தயவு செய்து கடவுச் சொல் புலத்தை நிரப்பவும்.',
	'userlogin-error-resetpass_announce' => 'நீங்கள் ஒரு தற்காலிகக் கடவுச் சொல்லைப் பயன்படுத்தியது போல் இருக்கின்றது. புகுபதிகையைத் தொடர்வதற்கு இங்கே ஒரு புதிய கடவுச் சொல்லை எடுக்கவும்.',
	'userlogin-error-login-throttled' => 'நீங்கள் தவறான கடவுச் சொல்லுடன் உள்நுழைவதற்கு பற்பல தடவைகள் முயன்றுள்ளீர்கள். மீண்டும் முயல்வதற்கு முன் சிறிது நேரம் பொறுங்கள்.',
	'userlogin-error-login-userblocked' => 'உங்கள் பயனர் பெயர் தடை செய்யப்பட்டுள்ளதுடன் புகுபதிகைக்குப் பயன்படுத்த முடியாததுமாகும்.',
	'userlogin-error-cantcreateaccount-text' => 'புதிய கணக்குகளை உருவாக்குவதற்கு உங்கள் இணைய நெறிமுறை முகவரிக்கு ஒப்புதலில்லை.',
	'userlogin-error-userexists' => 'யாரோ இப்பயனர் பெயரை ஏற்கனவே கொண்டுள்ளார். வேறுபட்ட ஒன்றை முயலவும்!',
	'userlogin-error-invalidemailaddress' => 'தயவு செய்து செல்லுபடியாகும் மின்னஞ்சல் முகவரி ஒன்றை உள்ளிடவும்.',
	'userlogin-error-invalid-username' => 'செல்லாத பயனர் பெயர்',
	'userlogin-error-userlogin-unable-info' => 'மன்னிக்கவும், இந்நேரத்தில் உங்கள் கணக்கைப் பதிவு செய்ய எங்களால் முடியவில்லை.',
	'userlogin-error-user-not-allowed' => 'இப்பயனர் பெயருக்கு ஒப்புதலில்லை.',
	'userlogin-error-captcha-createaccount-fail' => 'நீங்கள் உள்ளிட்ட சொல் பெட்டியினுள் உள்ள சொல்லுடன் ஒத்துப் போகவில்லை, மீண்டும் முயற்சிக்கவும்!',
	'userlogin-error-userlogin-bad-birthday' => 'ஓ, தயவு செய்து திங்களையும் நாளையும் ஆண்டையும் நிரப்பவும்.',
	'userlogin-error-noemailtitle' => 'தயவு செய்து செல்லுபடியாகும் மின்னஞ்சல் முகவரி ஒன்றை உள்ளிடவும்.',
	'userlogin-error-acct_creation_throttle_hit' => 'மன்னிக்கவும். இவ்விணைய நெறிமுறை முகவரி பல கணக்குகளை இன்று உருவாக்கியுள்ளது. தயவு செய்து பிறகு மீண்டும் முயற்சிக்கவும்.',
	'userlogin-error-resetpass_forbidden' => 'கடவுச் சொற்களை மாற்ற முடியாது',
	'userlogin-error-throttled-mailpassword' => 'இக்கணக்குக்கான கடவுச் சொல் நினைவுக் குறிப்பொன்றைக் கடந்த {{PLURAL:$1|மணித்தியாலத்தில்|$1 மணித்தியாலங்களில்}} நாங்கள் ஏற்கனவே அனுப்பியுள்ளோம். தயவு செய்து உங்கள் மின்னஞ்சலைப் பாருங்கள்.',
	'userlogin-password-page-title' => 'உங்கள் கடவுச் சொல்லை மாற்றவும்',
	'userlogin-oldpassword' => 'பழைய கடவுச் சொல்',
	'userlogin-newpassword' => 'புதிய கடவுச் சொல்',
	'userlogin-retypenew' => 'புதிய கடவுச் சொல்லை மீண்டும் தட்டச்சு செய்யவும்',
	'userlogin-password-email-subject' => 'மறந்த கடவுச் சொல் வேண்டுகோள்',
	'userlogin-password-email-greeting' => 'வணக்கம் $USERNAME,',
	'userlogin-provider-or' => 'அல்லது',
	'userlogin-provider-tooltip-facebook' => 'முகநூல் மூலம் உள்நுழைவதற்கு ஆளியைச் சொடுக்கவும்',
	'userlogin-facebook-show-preferences' => 'முகநூலூட்ட விருப்பத்தேர்வுகளைக் காட்டவும்',
	'userlogin-facebook-hide-preferences' => 'முகநூலூட்ட விருப்பத்தேர்வுகளை மறைக்கவும்',
	'userlogin-loginreqlink' => 'உள்நுழையவும்',
	'wikiamobile-sendpassword-label' => 'புதிய கடவுச் சொல்லை அனுப்பவும்',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Jprmvnvijay5
 * @author Veeven
 */
$messages['te'] = array(
	'userlogin-login-heading' => 'లాగినవండి',
	'userlogin-forgot-password' => 'మీ సంకేతపదాన్ని మరచిపోయారా?',
	'userlogin-remembermypassword' => 'లోపలనే ఉండండి',
	'userlogin-error-sessionfailure' => 'మీ లాగిన్ సెషనుకు కాలం చెల్లింది. తిరిగి లాగినవండి.',
	'userlogin-error-nosuchuser' => 'ఈ పేరును మేము గుర్తించలేకపోతున్నాము. వాడుకరి పేరులో పెద్దక్షరాలు చిన్నక్షరాల పట్టింపు ఉందన్న సంగతి మరువకండి.',
	'userlogin-error-invalidemailaddress' => 'సరైన ఈమెయిలు చిరునామా ఇవ్వండి.',
	'userlogin-get-account' => 'మీకు ఖాతా లేదా? <a href=\\"$1\\" tabindex=\\"$2\\">నమోదు చేసుకోండి</a>',
	'userlogin-error-invalid-username' => 'తప్పుడు వాడుకరిపేరు',
	'userlogin-error-userlogin-unable-info' => 'ఏమనుకోవద్దండి, ఇప్పుడు మీ ఖాతాను నమోదు చేయలేకపోతున్నాము.',
	'userlogin-error-user-not-allowed' => 'ఈ వాడుకరిపేరుని అనుమతించలేము.',
	'userlogin-error-captcha-createaccount-fail' => 'మీరు ఇచ్చిన మాట, పెట్టెలో ఉన్న మాటతో సరిపోలలేదు, తిరిగి ప్రయత్నించండి.',
	'userlogin-error-acct_creation_throttle_hit' => 'ఏమనుకోవద్దండి, ఈ ఐపి చిరునామాతో చాలా ఖాతాలు కల్పించారు. మళ్ళీ తర్వాత ఎప్పుడైనా ప్రయత్నించండి.',
	'userlogin-error-resetpass_forbidden' => 'సంకేతపదాలను మార్చటం కుదరదు',
	'userlogin-error-blocked-mailpassword' => 'ఈ ఐపి చిరునామాను వికియా నిరోధించడం చేత, మీరు కొత్త సంకేతపదం కొరకు విన్నవించడం కుదరదు.',
	'userlogin-password-email-sent' => '$1 కొరకు కొత్త సంకేతపదాన్ని ఈ ఈమెయిలు చిరునామాకు పంపించాం.',
	'userlogin-password-page-title' => 'మీ సంకేతపదాన్ని మార్చుకోండి.',
	'userlogin-oldpassword' => 'పాత సంకేతపదం',
	'userlogin-newpassword' => 'కొత్త సంకేతపదం',
	'userlogin-retypenew' => 'కొత్త సంకేతపదాన్ని మళ్ళీ ఇవ్వండి',
	'userlogin-password-email-subject' => 'మరచిన సంకేతపదం విన్నపము',
	'userlogin-password-email-greeting' => 'ఏమండీ $USERNAME గారూ,',
	'userlogin-password-email-signature' => 'వికియా సాముదాయిక తోడ్పాటు',
	'userlogin-changepassword-needlogin' => 'మీ సంకేతపదాన్ని మార్చేందుకు మీరు $1.',
	'wikiamobile-sendpassword-label' => 'కొత్త సంకేతపదాన్ని పంపించు',
	'wikiamobile-facebook-connect-fail' => 'ఏమనుకోవద్దండి, మీ ఫేస్ బుక్ ఖాతా ఏ వికీ ఖాతాతోనూ ముడివడిలేదు.',
);

/** Thai (ไทย)
 * @author Horus
 * @author Saipetch
 * @author TMo3289
 * @author Taweetham
 */
$messages['th'] = array(
	'userlogin-login-heading' => 'ล็อกอิน',
	'userlogin-forgot-password' => 'ลืมรหัสผ่าน',
	'userlogin-remembermypassword' => 'คงสถานะอยู่ในระบบ',
	'userlogin-error-noname' => 'ขออภัย โปรดกรอกชื่อผู้ใช้งานของท่าน',
	'userlogin-error-sessionfailure' => 'การเข้าระบบครั้งก่อนของท่านหมดเวลาแล้ว โปรดเข้าระบบใหม่',
	'userlogin-error-nosuchuser' => 'ขออภัย ชื่อผู้ใช้นี้ไม่ได้มีในฐานข้อมูลชื่อผู้ใช้ ลองตรวจสอบตัวพิมพ์ใหญ่-เล็กอีกครั้งหนึ่ง',
	'userlogin-error-wrongpassword' => 'ขออภัย รหัสผ่านผิด โปรดตรวจสอบว่าปุ่ม caps lock ปิดแล้ว จากนั้นลองใหม่อีกครั้ง',
	'userlogin-get-account' => 'ไม่มีบัญชีใช่ไหม โปรด <a href="$1" tabindex="$2">สมัครบัญชีผู้ใช้</a>',
	'userlogin-password-page-title' => 'เปลี่ยนรหัสผ่าน',
	'userlogin-oldpassword' => 'รหัสผ่านเดิม',
	'userlogin-newpassword' => 'รหัสผ่านใหม่',
	'userlogin-retypenew' => 'พิมพ์รหัสผ่านใหม่อีกครั้ง',
	'userlogin-password-email-greeting' => 'สวัสดี $USERNAME',
	'userlogin-provider-or' => 'หรือ',
	'userlogin-loginreqlink' => 'เข้าสู่ระบบ',
	'userlogin-changepassword-needlogin' => 'ท่านต้อง $1 เพื่อที่จะเปลี่ยนรหัสผ่าน',
	'wikiamobile-sendpassword-label' => 'ส่งรหัสผ่านใหม่',
	'wikiamobile-facebook-connect-fail' => 'ขออภัยที่บัญชีเฟสบุ๊คของท่านไม่ได้เชื่อมโยงกับบัญชีวิเกีย',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'userlogin-login-heading' => 'Lumagda',
	'userlogin-forgot-password' => 'Nalimutan ang hudyat mo?',
	'userlogin-remembermypassword' => 'Manatiling nakalagda',
	'userlogin-error-noname' => 'Naku, paki punuan ang hanay ng pangalan ng tagagamit.',
	'userlogin-error-sessionfailure' => 'Naubusan na ng oras ang inilaang panahon sa paglagda mo. Paki lumagdang muli.',
	'userlogin-error-nosuchuser' => 'Hindi namin nakikilala ang pangalang ito. Huwag kalimutan na ang mga pangalan ng tagagamit ay maselan sa pagmamakinilya.',
	'userlogin-error-wrongpassword' => 'Naku, maling hudyat. Paki tiyak na nakapatay ang kandado ng malalaking mga titik at subukang muli.',
	'userlogin-error-wrongpasswordempty' => 'Naku, paki punuan ang hanay ng hudyat.',
	'userlogin-error-resetpass_announce' => 'Mukhang gumamit ka ng isang pansamantalang hudyat. Pumili ng isang bagong hudyat dito upang makapagpatuloy sa paglagda.',
	'userlogin-error-login-throttled' => 'Napaka maraming ulit kang nagtangka na lumagdang papasok. Maghintay ng ilang sandali bago sumubok muli.',
	'userlogin-error-login-userblocked' => 'Hinadlangan ang iyong pangalan ng tagagamit at hindi magagamit upang lumagdang papasok.',
	'userlogin-error-edit-account-closed-flag' => 'Hindi na pinagagana ng Wikia ang akawnt mo.',
	'userlogin-error-cantcreateaccount-text' => 'Hindi pinapayagan ang tirahan mo ng IP upang makalikha ng bagong mga akawnt.',
	'userlogin-error-userexists' => 'Mayroon nang ibang tao na may ganitong pangalan ng tagagamit. Sumubok ng isang naiiba!',
	'userlogin-error-invalidemailaddress' => 'Paki magpasok ng isang katanggap-tanggap na tirahan ng e-liham.',
	'userlogin-get-account' => 'Wala pang akawnt? <a href="$1" tabindex="$2">Magpatala</a>',
	'userlogin-error-invalid-username' => 'Hindi tanggap na pangalan ng tagagamit',
	'userlogin-error-userlogin-unable-info' => 'Paumanhin, hindi namin nagawang mairehistro ang akawnt mo sa ngayon.',
	'userlogin-error-user-not-allowed' => 'Hindi pinapahintulutan ang pangalan ng tagagamit.',
	'userlogin-error-captcha-createaccount-fail' => 'Ang ipinasok mong salita ay hindi tumugma sa salitang nasa loob ng kahon, subukan uli!',
	'userlogin-error-userlogin-bad-birthday' => 'Naku, paki punuan ang buwan, araw at taon.',
	'userlogin-error-externaldberror' => 'Paumanhin! Kasalukuyang nagkakaroon ng isang suliranin ang aming pook. Paki subukan ulit mamaya.',
	'userlogin-error-noemailtitle' => 'Paki magpasok ng isang katanggap-tanggap na tirahan ng e-liham.',
	'userlogin-error-acct_creation_throttle_hit' => 'Paumanhin, ang tirahan ng IP na ito ay lumikha ng napaka maraming mga akawnt ngayong araw na ito. Paki subukang muli mamaya.',
	'userlogin-error-resetpass_forbidden' => 'Hindi mababago ang mga hudyat',
	'userlogin-error-blocked-mailpassword' => 'Hindi ka makakahiling ng isang bagong hudyat dahil ang tirahang ito ng IP ay hinadlangan ng Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Nagpadala na kami ng isang paalala ng hudyat papunta sa akawnt na ito sa loob ng huling {{PLURAL:$1|oras|$1 mga oras}}. Paki tingnan ang iyong e-liham.',
	'userlogin-error-mail-error' => 'Naku, nagkaroon ng isang suliranin sa pagpapadala sa iyo ng e-liham. Paki [[Special:Contact/general|makipag-ugnayan sa amin]].',
	'userlogin-password-email-sent' => 'Nagpadala kami ng isang bagong hudyat papunta sa tirahan ng e-liham para kay $1.',
	'userlogin-error-unconfirmed-user' => 'Paumanhin, hindi mo tiniyak ang iyong tirahan ng e-liham. Paki tiyakin muna ang iyong tirahan ng e-liham.',
	'userlogin-password-page-title' => 'Palitan ang hudyat mo',
	'userlogin-oldpassword' => 'Lumang hudyat',
	'userlogin-newpassword' => 'Bagong hudyat',
	'userlogin-retypenew' => 'Makinilyahin ulit ang bagong hudyat',
	'userlogin-password-email-subject' => 'Kahilingan sa nakalimutang hudyat',
	'userlogin-password-email-greeting' => 'Kumusta $USERNAME,',
	'userlogin-password-email-content' => 'Paki gamitin ang pansamantalang hudyat na ito upang lumagdang papasok sa Wikia: "$NEWPASSWORD"
<br /><br />
Kung hindi ka humiling ng isang bagong hudyat, huwag mag-alala! Ang akawnt mo ay ligtas at hindi nanganganib. Maaari mong huwag pansinin ang e-liham na ito at magpatuloy sa paglagdang papasok sa Wikia sa pamamagitan ng iyong lumang hudyat.
<br /><br />
May mga itatanong at mga pag-aalala? Maging malaya na makipag-ugnayan sa amin.',
	'userlogin-password-email-signature' => 'Suporta ng Pamayanan ng Wikia',
	'userlogin-password-email-body' => 'Kumusta $2,

Paki gamitin ang pansamantalang hudyat na ito upang lumagdang papasok sa Wikia: "$3"

Kung hindi ka humiling ng isang bagong hudyat, huwag mag-alala! Ang akawnt mo ay ligtas at hindi nanganganib. Maaari mong huwag pansinin ang e-liham na ito at magpatuloy sa paglagdang papasok sa Wikia sa pamamagitan ng iyong lumang hudyat.

May mga itatanong at mga pag-aalala? Maging malaya na makipag-ugnayan sa amin.

Suporta ng Pamayanan ng Wikia


___________________________________________

Upang matingnan ang pinaka huling mga kaganapan sa Wikia, dalawin ang http://community.wikia.com
Nais mong kontrolin ang tinatanggap mong mga e-liham? Pumunta sa: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Upang matingnan ang pinaka huling mga kaganapan sa Wikia, dalawin ang <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Nais mong kontrolin ang tinatanggap mong mga e-liham? Pumunta sa iyong <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Mga nais</a>',
	'userlogin-provider-or' => 'O',
	'userlogin-provider-tooltip-facebook' => 'Lagitikin ang pindutan upang lumagdang papasok sa pamamagitan ng Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Lagitikin ang pindutan upang makapagpatala sa pamamagitan ng Facebook',
	'userlogin-facebook-show-preferences' => 'Ipakit ang mga kanaisan sa pakain ng Facebook',
	'userlogin-facebook-hide-preferences' => 'Itago ang mga kanaisan sa pakain ng Facebook',
	'userlogin-loginreqlink' => 'lumagda',
	'userlogin-changepassword-needlogin' => 'Kailangan mong $1 upang mabago ang hudyat mo.',
	'wikiamobile-sendpassword-label' => 'Ipadala ang bagong hudyat',
	'wikiamobile-facebook-connect-fail' => 'Paumanhin, ang iyong akawnt ng Facebook ay kasalukuyang hindi nakakawing sa isang akawnt ng Wikia.',
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 */
$messages['tr'] = array(
	'userlogin-login-heading' => 'Oturum aç',
	'userlogin-forgot-password' => 'Parolanızı mı unuttunuz?',
	'userlogin-forgot-password-button' => 'Devam et',
	'userlogin-forgot-password-go-to-login' => 'Zaten kayıtlı mısınız? [[Special:UserLogin|Oturum açın]]',
	'userlogin-remembermypassword' => 'Oturumumu sürekli açık tut',
	'userlogin-error-noname' => 'Lütfen kullanıcı adı alanını doldurun.',
	'userlogin-error-sessionfailure' => 'Oturumunuz zaman aşımına uğradı. Lütfen tekrar giriş yapın.',
	'userlogin-error-nosuchuser' => 'Bu kullanıcı tanınmıyor. Kullanıcı adlarının büyük, küçük harf duyarlı olduğunu unutmayın.',
	'userlogin-error-wrongpassword' => 'Hatalı şifre. Caps Lock tuşuna basmadığınızdan emin olun ve tekrar deneyin.',
	'userlogin-error-wrongpasswordempty' => 'Lütfen parola alanını doldurun.',
	'userlogin-error-resetpass_announce' => 'Geçici bir parola kullanılarak giriş yapıldı. Oturumunuz ile devam etmek için lütfen yeni bir parola oluşturun.',
	'userlogin-error-login-throttled' => 'Çok sayıda hatalı parola ile giriş yapmaya çalıştınız. Tekrar denemeden önce lütfen bir süre bekleyin.',
	'userlogin-error-login-userblocked' => 'Kullanıcı adınız bloke edildi ve artık oturum açmak için kullanılamaz.',
	'userlogin-error-edit-account-closed-flag' => 'Hesabınız Wikia tarafından devre dışı bırakıldı.',
	'userlogin-error-cantcreateaccount-text' => 'IP adresinizden yeni hesaplar oluşturmanıza izin verilmemektedir.',
	'userlogin-error-userexists' => 'Bu kullanıcı adı zaten kullanılıyor. Lütfen farklı bir tane deneyin!',
	'userlogin-error-invalidemailaddress' => 'Lütfen geçerli bir e-posta adresi girin.',
	'userlogin-get-account' => 'Hesabınız yok mu? <a href="$1" tabindex="$2">Kaydolun</a>',
	'userlogin-error-invalid-username' => 'Geçersiz kullanıcı adı',
	'userlogin-error-userlogin-unable-info' => 'Üzgünüm, şu anda hesap oluşturma mümkün gözükmüyor.',
	'userlogin-error-user-not-allowed' => 'Bu kullanıcı adına izin verilmiyor.',
	'userlogin-error-captcha-createaccount-fail' => 'Girdiğiniz kelimeler uyuşmuyor, tekrar deneyin!',
	'userlogin-error-userlogin-bad-birthday' => 'Lütfen, gün, ay ve yıl bölümlerini doldurun.',
	'userlogin-error-externaldberror' => 'Üzgünüm! Sitemiz şu anda bir sorun yaşıyor. Lütfen daha sonra tekrar deneyin.',
	'userlogin-error-noemailtitle' => 'Lütfen geçerli bir e-posta adresi girin.',
	'userlogin-error-acct_creation_throttle_hit' => 'Üzgünüm, bu IP adresinden bugün çok fazla sayıda hesap oluşturuldu. Lütfen daha sonra tekrar deneyin.',
	'userlogin-error-resetpass_forbidden' => 'Parolalar değiştirilemiyor',
	'userlogin-error-blocked-mailpassword' => 'Bu IP adresi Wikia tarafından engellendiğinden dolayı yeni bir parola isteğinde bulunamazsınız.',
	'userlogin-error-throttled-mailpassword' => 'Biz bu hesabın parolasını hatırlatacak bilgileri son {{PLURAL:$1|saat|$1 saat}} içerisinde gönderdik. Lütfen e-posta adresinizi kontrol edin.',
	'userlogin-error-mail-error' => 'E-posta gönderiminde bir hata oluştu. Lütfen bizimle [[Special:Contact/general|iletişime geçin]].',
	'userlogin-provider-or' => 'Veya',
	'userlogin-provider-tooltip-facebook' => 'Facebook ile oturum açmak için butona tıklayın',
	'userlogin-provider-tooltip-facebook-signup' => 'Facebook ile kaydolmak için butona tıklayın',
	'userlogin-loginreqlink' => 'oturum aç',
	'wikiamobile-sendpassword-label' => 'Yeni parola gönder',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'userlogin-login-heading' => 'Керү',
	'userlogin-error-invalidemailaddress' => 'Зинһар,  электрон почтагызның дөрес юлламасын кертегез',
	'userlogin-error-invalid-username' => 'Кулланучының исеме дөрес түгел',
	'userlogin-error-user-not-allowed' => 'Мондый кулланучы исеме тыела',
	'userlogin-error-noemailtitle' => 'Зинһар,  электрон почтагызның дөрес юлламасын кертегез',
	'userlogin-error-resetpass_forbidden' => 'Серсүз үзгәртелә алмый',
	'userlogin-oldpassword' => 'Иске серсүз:',
	'userlogin-newpassword' => 'Яңа серсүз',
	'userlogin-retypenew' => 'Яңа серсүзне кабатлагыз',
	'userlogin-loginreqlink' => 'керү',
);

/** Central Atlas Tamazight (ⵜⴰⵎⴰⵣⵉⵖⵜ)
 * @author Tifinaghes
 */
$messages['tzm'] = array(
	'userlogin-login-heading' => 'ⴽⵛⵎ',
	'userlogin-forgot-password' => 'ⵉⵙ ⵜⵜⵓⵜ ⵜⴰⵡⴰⵍⵜ ⵓⵙⵉⴽⵍ?',
	'userlogin-password-page-title' => 'ⴱⴷⴷⵍ ⵜⴰⵡⴰⵍⵜ ⵓⵙⵉⴽⵍ ⵉⵏⵡ',
	'userlogin-oldpassword' => 'ⵜⴰⵡⴰⵍⵜ ⵓⵙⵉⴽⵍ ⵜⴰⵣⴰⵢⴽⵓⵜ',
	'userlogin-newpassword' => 'ⵜⴰⵡⴰⵍⵜ ⵓⵙⵉⴽⵍ ⵜⴰⵎⴰⵢⵏⵓⵜ',
	'userlogin-loginreqlink' => 'ⴽⵛⵎ',
	'wikiamobile-sendpassword-label' => 'ⴰⵣⵏ ⵜⴰⵡⴰⵍⵜ ⵓⵙⵉⴽⵍ ⵜⴰⵎⴰⵢⵏⵓⵜ',
);

/** Ukrainian (українська)
 * @author A1
 * @author Andriykopanytsia
 * @author Base
 * @author Olvin
 * @author Ua2004
 * @author Капитан Джон Шепард
 */
$messages['uk'] = array(
	'userlogin-login-heading' => 'Увійти',
	'userlogin-forgot-password' => 'Забули пароль?',
	'userlogin-forgot-password-button' => 'Продовжити',
	'userlogin-forgot-password-go-to-login' => 'Вже маєте пароль?  [[Special:UserLogin|Увійти в систему]]',
	'userlogin-remembermypassword' => "Запам'ятати мене",
	'userlogin-error-noname' => "Просимо заповнити ім'я користувача",
	'userlogin-error-sessionfailure' => 'Час сеансу вичерпано. Увійдіть знову.',
	'userlogin-error-nosuchuser' => "Таке ім'я не зареєстроване. Не забувайте, імена чутливі до регістру.",
	'userlogin-error-wrongpassword' => 'Неправильний пароль! Переконайтеся, що режим caps lock вимкнено і повторіть спробу.',
	'userlogin-error-wrongpasswordempty' => 'Введіть пароль.',
	'userlogin-error-resetpass_announce' => 'Схоже, що ви використали тимчасовий пароль. Виберіть новий пароль щоб увійти до системи.',
	'userlogin-error-login-throttled' => 'Забагато спроб увійти під хибним паролем. Охолоньте, перш ніж продовжувати.',
	'userlogin-error-login-userblocked' => "Це ім'я користувача заблоковано.",
	'userlogin-error-edit-account-closed-flag' => 'Ваш обліковий запис вимкнено в усіх Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'З Вашої IP-адреси створення нових облікових записів не допускається.',
	'userlogin-error-userexists' => 'Хтось вже зареєструвався під цим іменем. Підберіть інше!',
	'userlogin-error-invalidemailaddress' => 'Введіть справжню e-mail адресу.',
	'userlogin-error-wrongcredentials' => 'Невірна комбінація імені користувача і пароля. Будь ласка, спробуйте ще раз.',
	'userlogin-error-invalidfacebook' => 'Виникла проблема заходячі у свій Facebook акаунт; будь ласка, увійдіть на Facebook і спробуйте знову.',
	'userlogin-error-fbconnect' => 'Виникла проблема при підключенні вашого облікового запису Вікії до Facebook.',
	'userlogin-get-account' => 'Немає облікового запису? <a href="$1" tabindex="$2">Зареєструйтеся</a>',
	'userlogin-error-invalid-username' => "Неправильне ім'я користувача",
	'userlogin-error-userlogin-unable-info' => 'На жаль, наразі ми не в змозі зареєструвати обліковий запис.',
	'userlogin-error-user-not-allowed' => "Таке ім'я користувача не дозволено.",
	'userlogin-error-captcha-createaccount-fail' => 'Ви ввели зовсім не те слово, яке у намальовано у вікні. Спробуйте ще раз!',
	'userlogin-error-userlogin-bad-birthday' => 'Заповніть місяць, день і рік належним чином.',
	'userlogin-error-externaldberror' => 'Вибачте! Наш сайт наразі зіштовхнувся з проблемами. Будь ласка, спробуйте знову пізніше.',
	'userlogin-error-noemailtitle' => 'Введіть справжню e-mail адресу.',
	'userlogin-error-acct_creation_throttle_hit' => 'Забагато облікових записів з однієї IP-адреси. Спробуйте пізніше.',
	'userlogin-opt-in-label' => 'Пишіть мені про новини і події Вікії',
	'userlogin-error-resetpass_forbidden' => 'Пароль не можна змінювати',
	'userlogin-error-blocked-mailpassword' => 'Новий пароль вам ніхто не дасть, бо ця IP-адреса заблокована на Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Ми вже надіслані нагадування паролю цього облікового запису {{PLURAL:$1| годину|$1 години|$1 годин}} тому. Будь ласка, перевірте свою електронну пошту.',
	'userlogin-error-mail-error' => "На жаль, сталася помилка надсилання електронної пошти. Будь ласка, [[Special:Contact/general|зв'яжіться з нами]].",
	'userlogin-password-email-sent' => 'Ми відправили новий пароль на електронну адресу для $1 .',
	'userlogin-error-unconfirmed-user' => 'На жаль, ви не підтвердили адресу електронної пошти. Будь ласка, підтвердіть це спочатку.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Підтвердження нагадування електронною поштою вже надіслано.',
	'userlogin-password-page-title' => 'Змінити ваш пароль',
	'userlogin-oldpassword' => 'Старий пароль',
	'userlogin-newpassword' => 'Новий пароль',
	'userlogin-retypenew' => 'Ще раз введіть новий пароль:',
	'userlogin-password-email-subject' => 'Відновлення паролю',
	'userlogin-password-email-greeting' => 'Здоровеньки були, $USERNAME',
	'userlogin-password-email-content' => 'Будь ласка, використовуйте цей тимчасовий пароль для входу у систему: "$NEWPASSWORD"
<br /><br />
Якщо ви не запитували новий пароль, то не турбуйтеся! Ваш обліковий запис є надійним і безпечним. Ви можете ігнорувати цей лист і продовжити вхід до Вікія під старим паролем.
<br /><br />
Питання або сумніви? Не соромтеся <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">звертатися до нас</a>.',
	'userlogin-password-email-signature' => 'Команда Wikia',
	'userlogin-password-email-body' => 'Вітаю, $2,

Будь ласка, використовуйте цей тимчасовий пароль для входу у Вікія: "$3"

Якщо ви не запитували новий пароль, то не переймайтеся! Ваш обліковий запис надійний та безпечний. Ви можете ігнорувати цей лист і продовжувати входити до Вікія зі старим паролем.

Є питання чи сумніви? Сміливо звертайтеся до нас:http://community.wikia.com/wiki/Special:Contact/account-issue

Спільнота підтримки Вікія

___________________________________________

Останні події на Wikia - http://community.wikia.com
Налаштування листів від Wikia - {{fullurl:{{ns:special}}:Параметри}}',
	'userlogin-email-footer-line1' => 'Останні події на Wikia описані на <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Щоб налаштувати сповіщення по електронній пошті, перейдіть на сторінку <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Установки</a>',
	'userlogin-provider-or' => 'Або',
	'userlogin-provider-tooltip-facebook' => 'Натисніть кнопку, щоб увійти до системи через Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Натисніть кнопку, щоб зареєструватися через Facebook',
	'userlogin-facebook-show-preferences' => 'Показати налаштування взаємодії з Facebook',
	'userlogin-facebook-hide-preferences' => 'Приховати налаштування взаємодії з Facebook',
	'userlogin-loginreqlink' => 'увійти',
	'userlogin-changepassword-needlogin' => 'Вам необхідно  $1  щоб змінити свій пароль.',
	'wikiamobile-sendpassword-label' => 'Надіслати новий пароль',
	'wikiamobile-facebook-connect-fail' => "На жаль, ваш обліковий запис на Facebook наразі не пов'язаний з обліковим записом Wikia.",
	'userlogin-logged-in-title' => 'Ласкаво просимо на сайт {{SITENAME}}, $1!',
);

/** Uzbek (oʻzbekcha/ўзбекча)
 * @author Akmalzhon
 * @author Sociologist
 */
$messages['uz'] = array(
	'userlogin-login-heading' => 'Kirish',
	'userlogin-forgot-password' => 'Maxfiy so‘zni qayta kiriting:',
	'userlogin-error-unconfirmed-user' => 'Sizning elektron pochta manzilingiz tasdiqlanmagan. Iltimos uni tasdiqlang.',
	'userlogin-password-page-title' => 'Maxfiy soʻzni oʻzgartirish',
	'userlogin-oldpassword' => "Eski mahfiy so'z:",
	'userlogin-newpassword' => "Yangi mahfiy so'z:",
	'userlogin-retypenew' => "Yangi mahfiy so'zni qayta tering:",
	'userlogin-loginreqlink' => 'Kirish',
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author Rémy Lee
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'userlogin-login-heading' => 'Đăng nhập',
	'userlogin-forgot-password' => 'Quên mật khẩu?',
	'userlogin-forgot-password-button' => 'Tiếp tục',
	'userlogin-forgot-password-go-to-login' => 'Đã lấy lại mật khẩu? [[Special:UserLogin|Đăng nhập]]',
	'userlogin-remembermypassword' => 'Giữ đăng nhập',
	'userlogin-error-noname' => 'Rất tiếc, xin vui lòng điền vào trường tên người dùng.',
	'userlogin-error-sessionfailure' => 'Thời gian đăng nhập của bạn đã hết. Xin vui lòng đăng nhập lại.',
	'userlogin-error-nosuchuser' => 'Rất tiếc, tên tài khoản bạn vừa mới đăng nhập chưa từng tồn tại, hãy thử lại hoặc bạn có thể đăng ký tài khoản này.',
	'userlogin-error-wrongpassword' => 'Rất tiếc, sai mật khẩu. Hãy chắc rằng trạng thái caps lock của bạn đang tắt và thử lại.',
	'userlogin-error-wrongpasswordempty' => 'Rất tiếc, xin vui lòng điền vào trường mật khẩu.',
	'userlogin-error-resetpass_announce' => 'Hình như bạn đã sử dụng mật khẩu tạm thời. Chọn một mật khẩu mới ở đây để tiếp tục đăng nhập.',
	'userlogin-error-login-throttled' => 'Bạn đang cố gắng đăng nhập với mật khẩu không đúng quá nhiều lần. Chờ một lát trước khi thử lại.',
	'userlogin-error-login-userblocked' => 'Tên người dùng của bạn đã bị cấm và không thể được sử dụng để đăng nhập.',
	'userlogin-error-edit-account-closed-flag' => 'Tài khoản của bạn đã bị vô hiệu hóa bởi Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Địa chỉ IP của bạn không được phép tạo tài khoản mới.',
	'userlogin-error-userexists' => 'Ai đó đã sỡ hữu tên người dùng này. Hãy thử một tên khác nhé!',
	'userlogin-error-invalidemailaddress' => 'Xin nhập một địa chỉ thư điện tử hợp lệ.',
	'userlogin-get-account' => 'Chưa có tài khoản? <a href="$1" tabindex="$2">Đăng ký</a>',
	'userlogin-error-invalid-username' => 'Tên người dùng không hợp lệ',
	'userlogin-error-userlogin-unable-info' => 'Xin lỗi, chúng tôi không thể ghi nhận tài khoản của bạn tại thời điểm này.',
	'userlogin-error-user-not-allowed' => 'Tên người dùng này không được cho phép.',
	'userlogin-error-captcha-createaccount-fail' => 'Những từ mà bạn nhập vào không khớp với từ trong hộp, thử lại!',
	'userlogin-error-userlogin-bad-birthday' => 'Rất tiếc, xin vui lòng điền ngày, tháng và năm.',
	'userlogin-error-externaldberror' => 'Xin lỗi! Trang web của chúng tôi hiện đang có vấn đề. Xin vui lòng thử lại sau.',
	'userlogin-error-noemailtitle' => 'Xin nhập một địa chỉ thư điện tử hợp lệ.',
	'userlogin-error-acct_creation_throttle_hit' => 'Xin lỗi, địa chỉ IP này đã tạo ra quá nhiều tài khoản hôm nay. Xin vui lòng thử lại sau.',
	'userlogin-error-resetpass_forbidden' => 'Mật khẩu không thể thay đổi',
	'userlogin-error-blocked-mailpassword' => 'Bạn không thể yêu cầu mật khẩu mới vì địa chỉ IP này đã bị cấm bởi Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Chúng tôi đã gửi một mật khẩu nhắc nhở cho tài khoản này trong vòng {{PLURAL:$1|1 giờ|$1 giờ}} trước. Vui lòng kiểm tra thư điện tử của bạn.',
	'userlogin-error-mail-error' => 'Rất tiếc, đã xảy ra trục trặc khi gửi thư điện tử cho bạn. Xin [[Special:Contact/general|liên hệ với chúng tôi]].',
	'userlogin-password-email-sent' => 'Chúng tôi đã gửi mật khẩu mới đến địa chỉ thư điện tử của $1.',
	'userlogin-error-unconfirmed-user' => 'Xin lỗi, bạn chưa xác nhận địa chỉ thư điện tử của mình. Xin vui lòng xác nhận địa chỉ thư điện tử trước tiên.',
	'userlogin-error-confirmation-reminder-already-sent' => 'Thư điện tử nhắc nhở xác nhận đã được gửi.',
	'userlogin-password-page-title' => 'Đổi mật khẩu',
	'userlogin-oldpassword' => 'Mật khẩu cũ',
	'userlogin-newpassword' => 'Mật khẩu mới',
	'userlogin-retypenew' => 'Gõ lại mật khẩu mới',
	'userlogin-password-email-subject' => 'Yêu cầu mật khẩu mới',
	'userlogin-password-email-greeting' => 'Chào $USERNAME,',
	'userlogin-password-email-content' => 'Xin vui lòng sử dụng mật khẩu tạm thời này để đăng nhập vào Wikia: "$NEWPASSWORD"
<br /><br />
Nếu bạn không yêu cầu mật khẩu mới, đừng lo lắng! Tài khoản của bạn vẫn an toàn và bảo mật. Bạn có thể bỏ qua email này và tiếp tục đăng nhập vào Wikia với mật khẩu hiện tại của mình.
<br /><br />
Có câu hỏi hoặc quan tâm? Vui lòng <a href="http://community.wikia.com/wiki/Special:Contact/account-issue">liên hệ</a> với chúng tôi.',
	'userlogin-password-email-signature' => 'Cộng đồng Hỗ trợ Wikia',
	'userlogin-password-email-body' => 'Chào $2,

Xin vui lòng sử dụng mật khẩu tạm thời này để đăng nhập vào Wikia: "$3"

Nếu bạn không yêu cầu mật khẩu mới, đừng lo lắng! Tài khoản của bạn vẫn an toàn và bảo mật. Bạn có thể bỏ qua email này và tiếp tục đăng nhập vào Wikia với mật khẩu hiện tại của mình.

Có câu hỏi hoặc quan tâm? Hãy liên hệ với chúng tôi.

Cộng đồng Hỗ trợ Wikia

___________________________________________

Để kiểm tra những sự kiện mới nhất trên Wikia, truy cập http://community.wikia.com
Để nhận được sự hỗ trợ cho ngôn ngữ của bạn, truy cập http://congdong.wikia.com
Muốn kiểm soát email mà bạn nhận được? Đi đến: {{fullurl:{{ns:special}}:Tùy chọn}}',
	'userlogin-email-footer-line1' => 'Để kiểm tra những sự kiện mới nhất trên Wikia, truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>
Để nhận được sự hỗ trợ cho ngôn ngữ của bạn, truy cập <a style="color:#2a87d5;text-decoration:none;" href="http://congdong.wikia.com">congdong.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Muốn kiểm soát email mà bạn nhận được? Đi đến <a href="{{fullurl:{{ns:special}}:Tùy chọn}}" style="color:#2a87d5;text-decoration:none;">Tùy chọn</a>',
	'userlogin-provider-or' => 'Hoặc',
	'userlogin-provider-tooltip-facebook' => 'Nhấp vào nút để đăng nhập cùng với Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Nhấp vào nút để đăng ký cùng với Facebook',
	'userlogin-facebook-show-preferences' => 'Hiển thị cập nhật Facebook tùy chọn',
	'userlogin-facebook-hide-preferences' => 'Ẩn cập nhật Facebook tùy chọn',
	'userlogin-loginreqlink' => 'đăng nhập',
	'userlogin-changepassword-needlogin' => 'Bạn cần phải $1 để thay đổi mật khẩu của mình.',
	'wikiamobile-sendpassword-label' => 'Gửi mật khẩu mới',
	'wikiamobile-facebook-connect-fail' => 'Xin lỗi, tài khoản Facebook của bạn hiện chưa được liên kết với tài khoản Wikia.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Bencmq
 * @author Dimension
 * @author Hzy980512
 * @author Liuxinyu970226
 * @author Sam Wang
 * @author Xiaomingyan
 * @author Yfdyh000
 * @author 乌拉跨氪
 */
$messages['zh-hans'] = array(
	'userlogin-desc' => '用户登录扩展',
	'userlogin-login-heading' => '登录',
	'userlogin-forgot-password' => '忘记密码？',
	'userlogin-forgot-password-button' => '继续',
	'userlogin-forgot-password-go-to-login' => '您已经有密码了吗？[[Special:UserLogin|登录]]',
	'userlogin-remembermypassword' => '保持登录状态',
	'userlogin-error-noname' => '请输入用户名',
	'userlogin-error-sessionfailure' => '登陆超时，请重新登录。',
	'userlogin-error-nosuchuser' => '额，我们认不出这个名字。请不要忘记用户名是区分大小写的。',
	'userlogin-error-wrongpassword' => '错误密码。请确保大小写锁定处于关闭状态并且重试。',
	'userlogin-error-wrongpasswordempty' => '请输入密码',
	'userlogin-error-resetpass_announce' => '看来您在使用临时密码。请选择新的密码以继续登录。',
	'userlogin-error-login-throttled' => '密码输入错误次数过多。请稍后再试。',
	'userlogin-error-login-userblocked' => '您的用户名已被禁止使用。',
	'userlogin-error-edit-account-closed-flag' => '您的帐户已被Wikia禁用。',
	'userlogin-error-cantcreateaccount-text' => '您的IP地址不能再次新建帐户。',
	'userlogin-error-userexists' => '该用户名已使用，请选择其他用户名。',
	'userlogin-error-invalidemailaddress' => '请输入有效的电子邮件地址。',
	'userlogin-error-wrongcredentials' => '用户名与密码的组合不正确。请重试。',
	'userlogin-error-invalidfacebook' => '检测您的Facebook帐户时出现问题；请登录Facebook然后重试。',
	'userlogin-error-fbconnect' => '连接您的Wikia帐户到Facebook时出现问题。',
	'userlogin-get-account' => '没有账户？<a href="$1" tabindex="$2">注册</a>',
	'userlogin-error-invalid-username' => '用户名无效',
	'userlogin-error-userlogin-unable-info' => '抱歉，我们不能在这时等级您的帐户。',
	'userlogin-error-user-not-allowed' => '该用户名禁用。',
	'userlogin-error-captcha-createaccount-fail' => '输入的字符不匹配，请重输！',
	'userlogin-error-userlogin-bad-birthday' => '请填写年、月、和日。',
	'userlogin-error-externaldberror' => '抱歉，目前系统出错，请稍后再试。',
	'userlogin-error-noemailtitle' => '请输入有效的邮箱地址',
	'userlogin-error-acct_creation_throttle_hit' => '抱歉，该IP地址今天新建帐户过多，请稍后再试。',
	'userlogin-opt-in-label' => '向我发送Wikia新闻和事件的邮件通知',
	'userlogin-error-resetpass_forbidden' => '无法更改密码',
	'userlogin-error-blocked-mailpassword' => '该IP地址已被Wikia限制使用。不能申请新密码。',
	'userlogin-error-throttled-mailpassword' => '密码提醒已在{{PLURAL:$1|hour|$1hour}}内发送到该帐户，请查收您的电子邮件。',
	'userlogin-error-mail-error' => '哦，关于错误的信息已发送至您的信箱，请[[Special:Contact/general|联系我们]]。',
	'userlogin-password-email-sent' => '我们已将新密码寄至该邮箱$1。',
	'userlogin-error-unconfirmed-user' => '抱歉，您的电子邮件还未得到确认。请先确认。',
	'userlogin-error-confirmation-reminder-already-sent' => '验证提醒邮件已经发送。',
	'userlogin-password-page-title' => '更改您的密码',
	'userlogin-oldpassword' => '旧密码',
	'userlogin-newpassword' => '新密码',
	'userlogin-retypenew' => '再次输入新密码',
	'userlogin-password-email-subject' => '忘记密码请求',
	'userlogin-password-email-greeting' => '嗨！$USERNAME，',
	'userlogin-password-email-content' => '请使用该临时密码登录Wikia：”$NEWPASSWORD“
<br /><br />
如果您没有申请新密码，不用担心！您的帐户十分安全可靠。您可以忽略该邮件并且继续使用旧密码登录Wikia。
<br /><br />
如果您有任何问题，请<a href="http://community.wikia.com/wiki/Special:Contact/account-issue">联系我们</a>。',
	'userlogin-password-email-signature' => 'Wikia社区支持',
	'userlogin-password-email-body' => '嗨！$2

请使用临时密码登录Wikia：“$3”

如果您没有申请新密码，不用担心！您的帐户十分安全可靠。您可以忽略该邮件并继续使用旧密码登录Wikia。

如果您有任何问题，请联系我们：http://community.wikia.com/wiki/Special:Contact/account-issue

Wikia社区支持

___________________________________________
如果您想查询Wikia最新资讯，请查看http://community.wikia.com
希望控制您接收的电子邮件么？请至{{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => '为了查看Wikia最新发生的事，请点击<a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => '想控制您地接收邮件？请查看您的<a href="{{fullurl:{{ns:specia}}:Preferences}}" style="color:#2a87d5; text-decoration:none;">属性</a>',
	'userlogin-provider-or' => '或',
	'userlogin-provider-tooltip-facebook' => '按键进入Facebook。',
	'userlogin-provider-tooltip-facebook-signup' => '按键签入Facebook。',
	'userlogin-facebook-show-preferences' => '显示Facebook属性。',
	'userlogin-facebook-hide-preferences' => '隐藏Facebook属性。',
	'userlogin-loginreqlink' => '登录',
	'userlogin-changepassword-needlogin' => '您需要$1来更改您的密码。',
	'wikiamobile-sendpassword-label' => '发送新密码',
	'wikiamobile-facebook-connect-fail' => '对不起，您的Facebook帐户现在未链接到WIkia帐户。',
	'userlogin-logged-in-title' => '欢迎来到{{SITENAME}}，$1！',
	'userlogin-logged-in-message' => '您已经登录。查看[[$1|首页]]查看最新消息，或查看您的[[$2|个人资料]]。',
	'userlogin-account-admin-error' => '哎呀！出错了。请联系[[Special:Contact|Wikia]]获取帮助。',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="https://www.facebook.com/ChineseWikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://zh.community.wikia.com/wiki/%E5%8D%9A%E5%AE%A2:%E7%A4%BE%E5%8C%BA%E4%B8%AD%E5%BF%83" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Cwlin0416
 * @author Ffaarr
 * @author LNDDYL
 * @author Liuxinyu970226
 * @author Simon Shek
 * @author StephDC
 */
$messages['zh-hant'] = array(
	'userlogin-login-heading' => '登入',
	'userlogin-forgot-password' => '忘記密碼了嗎？',
	'userlogin-forgot-password-button' => '繼續',
	'userlogin-forgot-password-go-to-login' => '已經有密碼了嗎？[[Special:UserLogin|登入]]',
	'userlogin-remembermypassword' => '保持登入狀態',
	'userlogin-error-noname' => '請填寫使用者名稱。',
	'userlogin-error-sessionfailure' => '您的登錄已超時。請重新登錄。',
	'userlogin-error-nosuchuser' => '嗯，我們找不到這個使用者名稱。別忘記使用者名稱要區分大小寫。',
	'userlogin-error-wrongpassword' => '密碼錯誤。請確認 caps lock 已關閉，然後再試。',
	'userlogin-error-wrongpasswordempty' => '請輸入密碼。',
	'userlogin-error-resetpass_announce' => '看起來您使用的是臨時密碼。選擇新的密碼繼續登錄。',
	'userlogin-error-login-throttled' => '密碼輸入錯誤次數過多，請稍後再試。',
	'userlogin-error-login-userblocked' => '您的使用者名稱已被封鎖，不能登入。',
	'userlogin-error-edit-account-closed-flag' => '您的帳戶已被 Wikia 停用。',
	'userlogin-error-cantcreateaccount-text' => '您的 IP 位址不被允許建立新的帳號。',
	'userlogin-error-userexists' => '此使用者名稱已有人使用，請嘗試其他名稱。',
	'userlogin-error-invalidemailaddress' => '請輸入有效的電子郵件地址。',
	'userlogin-get-account' => '沒有帳號？<a href="$1" tabindex="$2">創建新帳號</a>',
	'userlogin-error-invalid-username' => '無效的使用者名稱',
	'userlogin-error-userlogin-unable-info' => '抱歉，我們現在不能建立你的帳號。',
	'userlogin-error-user-not-allowed' => '此使用者名禁止使用。',
	'userlogin-error-captcha-createaccount-fail' => '輸入的字元不相合，請重新輸入！',
	'userlogin-error-userlogin-bad-birthday' => '抱歉，請填寫年、月、和日。',
	'userlogin-error-externaldberror' => '抱歉！目前系統出錯，請稍後再試。',
	'userlogin-error-noemailtitle' => '請輸入有效的電子郵件地址。',
	'userlogin-error-acct_creation_throttle_hit' => '抱歉，此 IP 位址今天已建立了太多帳戶。請稍後再試。',
	'userlogin-error-resetpass_forbidden' => '無法更改密碼',
	'userlogin-error-blocked-mailpassword' => '由於您的IP位址已經被Wikia封禁，您不可以請求新密碼。',
	'userlogin-error-throttled-mailpassword' => '我們已經在{{PLURAL:$1|1小時|$1小時}}前發送了此帳戶的密碼提示。請檢查您的電子郵件。',
	'userlogin-error-mail-error' => '哎呀，在向您寄電子郵件的時候遇到了問題。請[[Special:Contact/general|聯絡我們]]。',
	'userlogin-password-email-sent' => '我們已經向帳戶 $1 傳送了一封包含有該帳戶新密碼的電子郵件。',
	'userlogin-error-unconfirmed-user' => '抱歉，您尚未認證您的電子郵件地址。請先去認證您的電子郵件地址。',
	'userlogin-error-confirmation-reminder-already-sent' => '驗證提醒郵件已經發送',
	'userlogin-password-page-title' => '變更您的密碼',
	'userlogin-oldpassword' => '舊密碼',
	'userlogin-newpassword' => '新密碼',
	'userlogin-retypenew' => '重新輸入新密碼',
	'userlogin-password-email-subject' => '忘記密碼',
	'userlogin-password-email-greeting' => '$USERNAME：',
	'userlogin-password-email-content' => '請使用下列臨時密碼登陸Wikia："$NEWPASSWORD"
<br /><br />
如果您並未請求一個新密碼，請不要擔心。您的帳戶仍然安全可靠。您可以忽略這封電子郵件，並且繼續使用您的舊密碼登陸Wikia。
<br /><br />
仍然有問題？請隨時<a href="http://community.wikia.com/wiki/Special:Contact/account-issue">聯繫我們</a>。',
	'userlogin-password-email-signature' => 'Wikia 社區支援',
	'userlogin-password-email-body' => '$2 您好，

請使用下列臨時密碼登入Wikia："$3"

如果您並未請求一個新密碼，請不要擔心。您的帳戶仍然安全可靠。您可以忽略這封電子郵件，並且繼續使用您的舊密碼登陸Wikia。

仍然有問題？請隨時聯絡我們：http://community.wikia.com/wiki/Special:Contact/account-issue

Wikia社群支援

___________________________________________

要瞭解Wikia的最新動態，請造訪 http://community.wikia.com 。
希望調整您將會收到的電子郵件的類型嗎？請造訪：{{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => '要查看Wikia最新發生的事，請至<a style="color:#2a87d5;text-decoration:none;" href="http://zh.community.wikia.com">zh.community.wikia.com</a>',
	'userlogin-email-footer-line2' => '想選擇您要接收那些郵件？請至您的<a href="{{fullurl:{{ns:specia}}:Preferences}}" style="color:#2a87d5; text-decoration:none;">偏好設定</a>',
	'userlogin-provider-or' => '或',
	'userlogin-provider-tooltip-facebook' => '按下按鈕登錄 Facebook',
	'userlogin-provider-tooltip-facebook-signup' => '按下按鈕登入Facebook。',
	'userlogin-facebook-show-preferences' => '顯示 Facebook 選項',
	'userlogin-facebook-hide-preferences' => '隱藏 Facebook 選項',
	'userlogin-loginreqlink' => '登入',
	'userlogin-changepassword-needlogin' => '您需要$1來更改您的密碼。',
	'wikiamobile-sendpassword-label' => '發送新密碼',
	'wikiamobile-facebook-connect-fail' => '抱歉，您的 Facebook 帳戶目前未連結到 Wikia 帳戶。',
	'userlogin-desc' => '用戶登入擴展',
	'userlogin-error-wrongcredentials' => '用戶名和密碼的搭配不正確。請再試一次。',
	'userlogin-error-invalidfacebook' => '檢測您的Facebook帳戶時出現問題；請登入Facebook再重試。',
	'userlogin-error-fbconnect' => '將您的Wikia帳戶連結到Facebook時出現問題。',
	'userlogin-account-admin-error' => '抱歉！出現問題。請聯繫[[Special:Contact|Wikia]]以獲得幫助。',
	'userlogin-opt-in-label' => '向我發送Wikia新聞和事件的郵件通知',
	'userlogin-password-email-body-HTML' => '',
	'userlogin-email-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="https://www.facebook.com/ChineseWikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://zh.community.wikia.com/wiki/%E5%8D%9A%E5%AE%A2:%E7%A4%BE%E5%8C%BA%E4%B8%AD%E5%BF%83" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',
	'userlogin-logged-in-title' => '歡迎來到{{SITENAME}}，$1！',
	'userlogin-logged-in-message' => '您已經登入。進入[[$1|首頁]] 查看最新消息，或查看您的[[$2|個人資料]]。',
);

