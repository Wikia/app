<?php
/**
 * Internationalisation file for ConfirmAccount extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	# Request account page
	'requestaccount'            => 'Request account',
	'requestaccount-text'       => '\'\'\'Complete and submit the following form to request a user account\'\'\'.

Make sure that you first read the [[{{MediaWiki:Requestaccount-page}}|Terms of Service]] before requesting an account.

Once the account is approved, you will be e-mailed a notification message and the account will be usable at [[Special:UserLogin|login]].',
	'requestaccount-footer'     => '', # only translate this message to other languages if you have to change it
	'requestaccount-page'       => '{{ns:project}}:Terms of Service',
	'requestaccount-dup'        => '\'\'\'Note: You already are logged in with a registered account.\'\'\'',
	'requestaccount-leg-user'   => 'User account',
	'requestaccount-leg-areas'  => 'Main areas of interest',
	'requestaccount-leg-person' => 'Personal information',
	'requestaccount-leg-other'  => 'Other information',
	'requestaccount-leg-tos'    => 'Terms of Service',
	'requestaccount-acc-text'   => 'Your e-mail address will be sent a confirmation message once this request is submitted.
Please respond by clicking on the confirmation link provided by the e-mail.
Also, your password will be e-mailed to you when your account is created.',
	'requestaccount-areas' => '', # Do not translate this message to other languages
	'requestaccount-areas-text' => 'Select the topic areas below in which you have formal expertise or would like to do the most work in.',
	'requestaccount-ext-text'   => 'The following information is kept private and will only be used for this request.
You may want to list contacts such a phone number to aid in identify confirmation.',
	'requestaccount-bio-text'   => "Your biography will be set as the default content for your userpage.
Try to include any credentials.
Make sure you are comfortable publishing such information.
Your name can be changed via [[Special:Preferences|your preferences]].",
	'requestaccount-real'       => 'Real name:',
	'requestaccount-same'       => '(same as real name)',
	'requestaccount-email'      => 'E-mail address:',
	'requestaccount-reqtype'    => 'Position:',
	'requestaccount-level-0'    => 'author',
	'requestaccount-level-1'    => 'editor',
	'requestaccount-info'       => '(?)',
	'requestaccount-bio'        => 'Personal biography:',
	'requestaccount-attach'     => 'Resume or CV (optional):',
	'requestaccount-notes'      => 'Additional notes:',
	'requestaccount-urls'       => 'List of websites, if any (separate with newlines):',
	'requestaccount-agree'      => 'You must certify that your real name is correct and that you agree to our Terms of Service.',
	'requestaccount-inuse'      => 'Username is already in use in a pending account request.',
	'requestaccount-tooshort'   => 'Your biography must be at least $1 {{PLURAL:$1|word|words}} long.',
	'requestaccount-emaildup'   => 'Another pending account request uses the same e-mail address.',
	'requestaccount-exts'       => 'Attachment file type is disallowed.',
	'requestaccount-resub'      => 'Your CV/resume file must be re-selected for security reasons.
Leave the field blank if you no longer want to include one.',
	'requestaccount-tos'        => 'I have read and agree to abide by the [[{{MediaWiki:Requestaccount-page}}|Terms of Service]] of {{SITENAME}}.
The name I have specified under "Real name" is in fact my own real name.',
	'requestaccount-submit'     => 'Request account',
	'requestaccount-sent'       => 'Your account request has successfully been sent and is now pending review.
	A confirmation email has been sent to your e-mail address.',

	'request-account-econf'     => 'Your e-mail address has been confirmed and will be listed as such in your account request.',
	'requestaccount-email-subj' => '{{SITENAME}} e-mail address confirmation',
	'requestaccount-email-body' => 'Someone, probably you from IP address $1, has requested an account "$2" with this e-mail address on {{SITENAME}}.

To confirm that this account really does belong to you on {{SITENAME}}, open this link in your browser:

$3

If the account is created, only you will be e-mailed the password.
If this is *not* you, don\'t follow the link.
This confirmation code will expire at $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} account request',
	'requestaccount-email-body-admin' => '"$1" has requested an account and is waiting for confirmation.
The e-mail address has been confirmed. You can confirm the request here "$2".',

	'acct_request_throttle_hit' => "Sorry, you have already requested {{PLURAL:$1|1 account|$1 accounts}}.
You cannot make any more requests.",

	# Add to Special:Login
	'requestaccount-loginnotice' => 'To obtain a user account, you must \'\'\'[[Special:RequestAccount|request one]]\'\'\'.',

	# Site message for admins
	'confirmaccount-newrequests' => '\'\'\'$1\'\'\' open e-mail-confirmed [[Special:ConfirmAccounts|account {{PLURAL:$1|request|requests}}]] pending',

	# Confirm account page
	'confirmaccounts'         => 'Confirm account requests',
	'confirmedit-desc'        => 'Gives bureaucrats the ability to confirm account requests',
	'confirmaccount-maintext' => '\'\'\'This page is used to confirm pending account requests at \'\'{{SITENAME}}\'\'\'\'\'.

Each account request queue consists of three subqueues.
One for open request, one for those that have been put on hold by other administrators pending further information, and another for recently rejected requests.

When responding to a request, carefully review it and, if needed, confirm the information contain therein.
Your actions will be privately logged.
You are also expected to review any activity that takes place here aside from what you do yourself.',
	'confirmaccount-list'     => 'Below is a list of account requests awaiting approval.
Once a request is either approved or rejected it will removed from this list.',
	'confirmaccount-list2'    => 'Below is a list recently rejected account requests which may automatically be deleted once several days old.
They can still be approved into accounts, though you may want to first consult the rejecting administrator before doing so.',
	'confirmaccount-list3'    => 'Below is a list expired account requests which may automatically be deleted once several days old.
They can still be approved into accounts.',
	'confirmaccount-text'     => 'This is a pending request for a user account at \'\'\'{{SITENAME}}\'\'\'.

Carefully review the below information.
If you are approving this request, use the position dropdown to set the account status of the user.
Edits made to the application biography will not affect any permanent credential storage.
Note that you can choose to create the account under a different username.
Use this only to avoid  collisions with other names.

If you simply leave this page without confirming or denying this request, it will remain pending.',
	'confirmaccount-none-o'   => 'There are currently no open pending account requests in this list.',
	'confirmaccount-none-h'   => 'There are currently no held pending account requests in this list.',
	'confirmaccount-none-r'   => 'There are currently no recently rejected account requests in this list.',
	'confirmaccount-none-e'   => 'There are currently no expired account requests in this list.',
	'confirmaccount-real-q'   => 'Name',
	'confirmaccount-email-q'  => 'E-mail',
	'confirmaccount-bio-q'    => 'Biography',
	'confirmaccount-showopen' => 'open requests',
	'confirmaccount-showrej'  => 'rejected requests',
	'confirmaccount-showheld' => 'held requests',
	'confirmaccount-showexp'  => 'expired requests',
	'confirmaccount-review'   => 'Review',
	'confirmaccount-types'    => 'Select an account confirmation queue from below:',
	'confirmaccount-all'      => '(show all queues)',
	'confirmaccount-type'     => 'Queue:',
	'confirmaccount-type-0'   => 'prospective authors',
	'confirmaccount-type-1'   => 'prospective editors',
	'confirmaccount-q-open'   => 'open requests',
	'confirmaccount-q-held'   => 'held requests',
	'confirmaccount-q-rej'    => 'recently rejected requests',
	'confirmaccount-q-stale'  => 'expired requests',

	'confirmaccount-badid'    => 'There is no pending request corresponding to the given ID.
It may have already been handled.',
	'confirmaccount-leg-user'  => 'User account',
	'confirmaccount-leg-areas' => 'Main areas of interest',
	'confirmaccount-leg-person' => 'Personal information',
	'confirmaccount-leg-other'  => 'Other information',
	'confirmaccount-name'     => 'Username',
	'confirmaccount-real'     => 'Name:',
	'confirmaccount-email'    => 'E-mail:',
	'confirmaccount-reqtype'  => 'Position:',
	'confirmaccount-pos-0'    => 'author',
	'confirmaccount-pos-1'    => 'editor',
	'confirmaccount-bio'      => 'Biography:',
	'confirmaccount-attach'   => 'Resume/CV:',
	'confirmaccount-notes'    => 'Additional notes:',
	'confirmaccount-urls'     => 'List of websites:',
	'confirmaccount-none-p'   => '(not provided)',
	'confirmaccount-confirm'  => 'Use the options below to accept, deny, or hold this request:',
	'confirmaccount-econf'    => '(confirmed)',
	'confirmaccount-reject'   => '(rejected by [[User:$1|$1]] on $2)',
	'confirmaccount-rational' => 'Rationale given to applicant:',
	'confirmaccount-noreason' => '(none)',
	'confirmaccount-autorej'  => '(this request has automatically been discarded due to inactivity)',
	'confirmaccount-held'     => '(marked "on hold" by [[User:$1|$1]] on $2)',
	'confirmaccount-create'   => 'Accept (create account)',
	'confirmaccount-deny'     => 'Reject (delist)',
	'confirmaccount-hold'     => 'Hold',
	'confirmaccount-spam'     => 'Spam (do not send e-mail)',
	'confirmaccount-reason'   => 'Comment (will be included in e-mail):',
	'confirmaccount-ip'       => 'IP address:',
	'confirmaccount-legend'   => 'Confirm/reject this account',
	'confirmaccount-submit'   => 'Confirm',
	'confirmaccount-needreason' => 'You must provide a reason in the comment box below.',
	'confirmaccount-canthold' => 'This request is already either on hold or deleted.',
	'confirmaccount-acc'     => 'Account request confirmed successfully;
	created new user account [[User:$1|$1]].',
	'confirmaccount-rej'     => 'Account request rejected successfully.',
	'confirmaccount-viewing' => '(currently being viewed by [[User:$1|$1]])',
	'confirmaccount-summary' => 'Creating user page with biography of new user.',
	'confirmaccount-welc'    => "'''Welcome to ''{{SITENAME}}''!'''
We hope you will contribute much and well.
You will probably want to read the [[{{MediaWiki:Helppage}}|help pages]].
Again, welcome and have fun!",
	'confirmaccount-wsum'    => 'Welcome!',
	'confirmaccount-email-subj' => '{{SITENAME}} account request',
	'confirmaccount-email-body' => 'Your request for an account has been approved on {{SITENAME}}.

Account name: $1

Password: $2

For security reasons you will need to change your password on first login.
To login, please go to {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Your request for an account has been approved on {{SITENAME}}.

Account name: $1

Password: $2

$3

For security reasons you will need to change your password on first login.
To login, please go to {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Sorry, your request for an account "$1" has been rejected on {{SITENAME}}.

There are several ways this can happen.
You may not have filled out the form correctly, did not provide adequate length in your responses, or otherwise failed to meet some policy criteria.
There may be contact lists on site that you can use if you want to know more about user account policy.',
	'confirmaccount-email-body4' => 'Sorry, your request for an account "$1" has been rejected on {{SITENAME}}.

$2

There may be contact lists on site that you can use if you want to know more about user account policy.',
	'confirmaccount-email-body5' => 'Before your request for an account "$1" can be accepted on {{SITENAME}} you must first provide some additional information.

$2

There may be contact lists on site that you can use if you want to know more about user account policy.',

	'usercredentials'        => 'User credentials',
	'usercredentials-leg'    => 'Lookup confirmed credentials for a user',
	'usercredentials-user'   => 'Username:',
	'usercredentials-text'   => 'Below are the validated credentials of the selected user account.',
	'usercredentials-leg-user' => 'User account',
	'usercredentials-leg-areas' => 'Main areas of interest',
	'usercredentials-leg-person' => 'Personal information',
	'usercredentials-leg-other' => 'Other information',
	'usercredentials-email'  => 'E-mail:',
	'usercredentials-real'   => 'Real name:',
	'usercredentials-bio'    => 'Biography:',
	'usercredentials-attach' => 'Resume/CV:',
	'usercredentials-notes'  => 'Additional notes:',
	'usercredentials-urls'   => 'List of websites:',
	'usercredentials-ip'     => 'Original IP address:',
	'usercredentials-member' => 'Rights:',
	'usercredentials-badid'  => 'No credentials found for this user.
Check that the name is spelled correctly.',

	'right-confirmaccount' => 'View the [[Special:ConfirmAccounts|queue with requested accounts]]',
	'right-requestips' => 'View requester\'s IP addresses while processing requested accounts',
	'right-lookupcredentials' => 'View [[Special:UserCredentials|user credentials]]',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Lejonel
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'requestaccount' => '{{Identical|Request account}}',
	'requestaccount-leg-user' => '{{Identical|User account}}',
	'requestaccount-leg-areas' => '{{Identical|Main areas of interest}}',
	'requestaccount-leg-person' => '{{Identical|Personal information}}',
	'requestaccount-leg-other' => '{{Identical|Other information}}',
	'requestaccount-real' => '{{Identical|Real name}}',
	'requestaccount-email' => '{{Identical|E-mail address}}',
	'requestaccount-reqtype' => '{{Identical|Position}}',
	'requestaccount-level-0' => '{{Identical|Author}}',
	'requestaccount-level-1' => '{{Identical|Editor}}',
	'requestaccount-notes' => '{{Identical|Additional notes}}',
	'requestaccount-submit' => '{{Identical|Request account}}',
	'requestaccount-email-body' => 'This text is sent in an e-mail.
* $1 is an IP address
* $2 is a requested user name (no GENDER support)
* $3 is a URL
* $4 is a date/time
* $5 is a date
* $6 is a time',
	'requestaccount-email-subj-admin' => '{{Identical|SITENAME account request}}',
	'requestaccount-email-body-admin' => 'This message is the email body text send to a site admin whenever someone has requested a new account.
* $1: is a username
* $2 is a URL',
	'confirmedit-desc' => 'Short description of this extension, shown on [[Special:Version]]. Do not translate or change links.',
	'confirmaccount-real-q' => '{{Identical|Name}}',
	'confirmaccount-email-q' => '{{Identical|E-mail}}',
	'confirmaccount-bio-q' => '{{Identical|Biography}}',
	'confirmaccount-showopen' => '{{Identical|Open requests}}',
	'confirmaccount-showheld' => '{{Identical|Held requests}}',
	'confirmaccount-showexp' => '{{Identical|Expired requests}}',
	'confirmaccount-review' => '{{Identical|Review}}',
	'confirmaccount-type' => '{{Identical|Queue}}',
	'confirmaccount-q-open' => '{{Identical|Open requests}}',
	'confirmaccount-q-held' => '{{Identical|Held requests}}',
	'confirmaccount-q-stale' => 'Used in [[Special:ConfirmAccounts|ConfirmAccounts]] extension.

{{Identical|Expired requests}}',
	'confirmaccount-leg-user' => '{{Identical|User account}}',
	'confirmaccount-leg-areas' => '{{Identical|Main areas of interest}}',
	'confirmaccount-leg-person' => '{{Identical|Personal information}}',
	'confirmaccount-leg-other' => '{{Identical|Other information}}',
	'confirmaccount-name' => '{{Identical|Username}}',
	'confirmaccount-real' => '{{Identical|Name}}',
	'confirmaccount-email' => '{{Identical|E-mail}}',
	'confirmaccount-reqtype' => '{{Identical|Position}}',
	'confirmaccount-pos-0' => '{{Identical|Author}}',
	'confirmaccount-pos-1' => '{{Identical|Editor}}',
	'confirmaccount-bio' => '{{Identical|Biography}}',
	'confirmaccount-attach' => '{{Identical|Resume/CV}}',
	'confirmaccount-notes' => '{{Identical|Additional notes}}',
	'confirmaccount-urls' => '{{Identical|List of websites}}',
	'confirmaccount-none-p' => '{{Identical|Notprovided}}',
	'confirmaccount-reject' => 'Parameters:
*$1 user name
*$2 date/time
*$3 date
*$4 time',
	'confirmaccount-noreason' => '{{Identical|None}}',
	'confirmaccount-held' => 'Parameters:
*$1 user name
*$2 date/time
*$3 date
*$4 time',
	'confirmaccount-ip' => '{{Identical|IP Address}}',
	'confirmaccount-submit' => '{{Identical|Confirm}}',
	'confirmaccount-welc' => 'In ConfirmAccount extension. A welcome message that is automatically placed on the talk pages of new users.',
	'confirmaccount-wsum' => 'In the ConfirmAccount extension. This is an edit summary used when a welcome message is automatically placed on the talk pages for new accounts.',
	'confirmaccount-email-subj' => '{{Identical|SITENAME account request}}',
	'confirmaccount-email-body' => '{{Identical|Your request for an account ...}}',
	'confirmaccount-email-body2' => '{{Identical|Your request for an account ...}}',
	'confirmaccount-email-body3' => 'This message is sent as an email to users when their account request has been denied by an bureaucrat.

*Parameter $1 is the requested account name',
	'confirmaccount-email-body4' => 'This message is sent as an email to users when their account request has been denied by an bureaucrat.

*Parameter $1 is the requested account name
*Parameter $2 is a comment written by the bureaucrat',
	'usercredentials-user' => '{{Identical|Username}}',
	'usercredentials-leg-user' => '{{Identical|User account}}',
	'usercredentials-leg-areas' => '{{Identical|Main areas of interest}}',
	'usercredentials-leg-person' => '{{Identical|Personal information}}',
	'usercredentials-leg-other' => '{{Identical|Other information}}',
	'usercredentials-email' => '{{Identical|E-mail}}',
	'usercredentials-real' => '{{Identical|Real name}}',
	'usercredentials-bio' => '{{Identical|Biography}}',
	'usercredentials-attach' => '{{Identical|Resume/CV}}',
	'usercredentials-notes' => '{{Identical|Additional notes}}',
	'usercredentials-urls' => '{{Identical|List of websites}}',
	'right-confirmaccount' => '{{doc-right|confirmaccount}}',
	'right-requestips' => '{{doc-right|requestips}}',
	'right-lookupcredentials' => '{{doc-right|lookupcredentials}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'confirmaccount-name' => 'Asa',
	'usercredentials-user' => 'Asa:',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'confirmaccount-email-q' => 'Meli hila',
	'confirmaccount-name' => 'Matahigoa he tagata',
	'confirmaccount-email' => 'Meli hila:',
	'usercredentials-user' => 'Matahigoa he tagata:',
	'usercredentials-email' => 'Meli hila:',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'requestaccount' => 'Versoek gebruikersrekening',
	'requestaccount-leg-areas' => 'Gebiede van belangstelling',
	'requestaccount-leg-person' => 'Persoonlike inligting',
	'requestaccount-leg-other' => 'Ander inligting',
	'requestaccount-real' => 'Regte naam:',
	'requestaccount-email' => 'E-posadres:',
	'requestaccount-reqtype' => 'Posisie:',
	'requestaccount-level-0' => 'outeur',
	'requestaccount-level-1' => 'redakteur',
	'requestaccount-notes' => 'Addisionele notas:',
	'requestaccount-submit' => 'Versoek gebruikersrekening',
	'requestaccount-email-subj-admin' => '{{SITENAME}} gebruikersversoeke',
	'confirmaccount-real-q' => 'Naam',
	'confirmaccount-email-q' => 'E-pos',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showopen' => 'oop versoeke',
	'confirmaccount-showheld' => 'afgehandelde versoeke',
	'confirmaccount-showexp' => 'vervalle versoeke',
	'confirmaccount-q-open' => 'oop versoeke',
	'confirmaccount-q-held' => 'afgehandelde versoeke',
	'confirmaccount-q-stale' => 'vervalle versoeke',
	'confirmaccount-leg-areas' => 'Gebiede van belangstelling',
	'confirmaccount-leg-person' => 'Persoonlike inligting',
	'confirmaccount-leg-other' => 'Ander inligting',
	'confirmaccount-name' => 'Gebruikersnaam',
	'confirmaccount-real' => 'Naam:',
	'confirmaccount-email' => 'E-pos:',
	'confirmaccount-reqtype' => 'Posisie:',
	'confirmaccount-pos-0' => 'outeur',
	'confirmaccount-pos-1' => 'redakteur',
	'confirmaccount-bio' => 'Biografie:',
	'confirmaccount-attach' => 'Resumé/CV (inligting oor u):',
	'confirmaccount-notes' => 'Addisionele notas:',
	'confirmaccount-urls' => 'Lys van webruimtes:',
	'confirmaccount-none-p' => '(nie verskaf nie)',
	'confirmaccount-noreason' => '(geen)',
	'confirmaccount-ip' => 'IP-adres:',
	'confirmaccount-submit' => 'Bevestig',
	'confirmaccount-email-subj' => '{{SITENAME}} gebruikersversoek',
	'usercredentials-user' => 'Gebruikersnaam:',
	'usercredentials-leg-areas' => 'Gebiede van belangstelling',
	'usercredentials-leg-person' => 'Persoonlike inligting',
	'usercredentials-leg-other' => 'Ander inligting',
	'usercredentials-email' => 'E-pos:',
	'usercredentials-real' => 'Regte naam:',
	'usercredentials-bio' => 'Biografie:',
	'usercredentials-attach' => 'Resumé/CV:',
	'usercredentials-notes' => 'Addisionele notas:',
	'usercredentials-urls' => 'Lys van webruimtes:',
	'usercredentials-ip' => 'Oorspronklike IP adres:',
	'usercredentials-member' => 'Regte:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'requestaccount-email' => 'የኢ-ሜል አድራሻ:',
	'confirmaccount-real-q' => 'ስም',
	'confirmaccount-email-q' => 'ኢ-ሜል',
	'confirmaccount-real' => 'ስም:',
	'confirmaccount-email' => 'ኢ-ሜል:',
	'usercredentials-email' => 'ኢ-ሜል:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'requestaccount-level-1' => 'editor',
	'confirmaccount-real' => 'Nombre:',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-submit' => 'Confirmar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = array(
	'requestaccount' => 'طلب حساب',
	'requestaccount-text' => "'''أكمل وابعث الاستمارة التالية لطلب حساب'''.

تأكد أولا من قراءة [[{{MediaWiki:Requestaccount-page}}|شروط الخدمة]] قبل طلب حساب.

	متى تمت الموافقة على الحساب، سيتم إرسال رسالة إخطار إليك والحساب سيصبح قابلا للاستخدام في
[[Special:UserLogin|تسجيل الدخول]].",
	'requestaccount-page' => '{{ns:project}}:شروط الخدمة',
	'requestaccount-dup' => "'''ملاحظة: أنت مسجل الدخول بالفعل بحساب مسجل.'''",
	'requestaccount-leg-user' => 'حساب المستخدم',
	'requestaccount-leg-areas' => 'الاهتمامات الرئيسية',
	'requestaccount-leg-person' => 'المعلومات الشخصية',
	'requestaccount-leg-other' => 'معلومات أخرى',
	'requestaccount-leg-tos' => 'شروط الخدمة',
	'requestaccount-acc-text' => 'سيتم إرسال رسالة تأكيد إلى عنوان بريدك الإلكتروني متى تم بعث هذا الطلب.
من فضلك استجب عن طريق الضغط على وصلة التأكيد المعطاة في البريد الإلكتروني.
أيضا، كلمة السر الخاصة بك سيتم إرسالها إليك عبر البريد الإلكتروني عندما يتم إنشاء حسابك.',
	'requestaccount-areas-text' => 'اختر المواضيع بالأسفل التي لديك فيها خبرة رسمية أو التي تود أن تعمل فيها.',
	'requestaccount-ext-text' => 'المعلومات التالية سرية وسيتم استخدامها فقط لهذا الطلب.
ربما تريد أن تكتب معلومات الاتصال كرقم تليفون للمساعدة في تأكيد الهوية.',
	'requestaccount-bio-text' => 'سيرتك الشخصية ستعرض كالمحتوى الافتراضي لصفحة المستخدم الخاصة بك.
حاول تضمين أية شهادات.
تأكد من ارتياحك لنشر هذه المعلومات.
اسمك يمكن تغييره من خلال [[Special:Preferences|تفضيلاتك]].',
	'requestaccount-real' => 'الاسم الحقيقي:',
	'requestaccount-same' => '(مثل الاسم الحقيقي)',
	'requestaccount-email' => 'عنوان البريد الإلكتروني:',
	'requestaccount-reqtype' => 'الموضع:',
	'requestaccount-level-0' => 'مؤلف',
	'requestaccount-level-1' => 'محرر',
	'requestaccount-info' => '(؟)',
	'requestaccount-bio' => 'السيرة الشخصية:',
	'requestaccount-attach' => 'استكمال أو السيرة الذاتية (اختياري):',
	'requestaccount-notes' => 'ملاحظات إضافية:',
	'requestaccount-urls' => 'قائمة مواقع الوب، إن وجدت (افصل بسطور جديدة):',
	'requestaccount-agree' => 'يجب أن تشهد أن اسمك الحقيقي صحيح وأنك توافق على شروط خدمتنا.',
	'requestaccount-inuse' => 'اسم المستخدم مستعمل بالفعل في طلب حساب قيد الانتظار',
	'requestaccount-tooshort' => 'يجب أن يكون طول سيرتك على الأقل {{PLURAL:$1||كلمة واحدة|كلمتين|$1 كلمات|$1 كلمة}}.',
	'requestaccount-emaildup' => 'طلب حساب آخر قيد الانتظار يستخدم نفس عنوان البريد الإلكتروني.',
	'requestaccount-exts' => 'نوع الملف المرفق غير مسموح به.',
	'requestaccount-resub' => 'ملف سيرتك الذاتية/استكمالك يجب أن يتم إعادة اختياره لأسباب أمنية.
اترك الحقل فارغا لو كنت لم تعد تريد إضافة واحد.',
	'requestaccount-tos' => 'لقد قرأت وأوافق على الالتزام [[{{MediaWiki:Requestaccount-page}}|بشروط خدمة]] {{SITENAME}}.
الاسم الذي حددته تحت "الاسم الحقيقي" هو في الواقع اسمي الحقيقي.',
	'requestaccount-submit' => 'طلب حساب',
	'requestaccount-sent' => 'طلبك للحساب تم إرساله بنجاح وهو بانتظار المراجعة الآن.
بريد إلكتروني للتأكيد تم إرساله إلى عنوان بريدك الإلكتروني.',
	'request-account-econf' => 'عنوان بريدك الإلكتروني تم تأكيده وسيتم عرضه كما هو في طلب حسابك.',
	'requestaccount-email-subj' => '{{SITENAME}} تأكيد عنوان البريد الإلكتروني من',
	'requestaccount-email-body' => 'شخص ما، على الأرجح أنت من عنوان الأيبي $1، طلب حساب "$2" بعنوان البريد الإلكتروني هذا على {{SITENAME}}.

لتأكيد أن هذا الحساب ينتمي إليك فعلا على {{SITENAME}}، افتح هذه الوصلة في متصفحك:

$3

لو أن الحساب تم إنشاؤه، فقط أنت سيتم إرسال كلمة السر إليه.
لو أن هذا *ليس* أنت، لا تتبع الوصلة.
كود التأكيد سينتهي في $4.',
	'requestaccount-email-subj-admin' => 'طلب حساب {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" طلب حسابا وينتظر التأكيد.
عنوان البريد الإلكتروني تم تأكيده. يمكنك تأكيد الطلب هنا "$2".',
	'acct_request_throttle_hit' => 'عذرا، لقد طلبت بالفعل {{PLURAL:$1||حسابًا واحدًا|حسابين|$1 حسابات|$1 حسابًا|$1 حساب}}.
لا يمكنك إنشاء المزيد من الطلبات.',
	'requestaccount-loginnotice' => "للحصول على حساب، يجب عليك '''[[Special:RequestAccount|أن تطلب حسابًا]]'''.",
	'confirmaccount-newrequests' => "{{PLURAL:$1|يوجد|يوجد}} حاليا '''$1'''
{{PLURAL:$1|[[Special:ConfirmAccounts|طلب حساب]]|[[Special:ConfirmAccounts|طلب حساب]]}} مفتوح قيد الانتظار.",
	'confirmaccounts' => 'تأكيد طلبات الحسابات',
	'confirmedit-desc' => 'يعطي البيروقراطيين القدرة على تأكيد طلبات الحساب',
	'confirmaccount-maintext' => "'''هذه الصفحة تستخدم لتأكيد طلبات الحساب قيد الانتظار في ''{{SITENAME}}'''''.

كل طابور طلب حساب يتكون من ثلاثة طوابير فرعية، واحد للطلبات المفتوحة، واحد لتلك التي تم وضعها قيد الانتظار بواسطة الإداريين الآخرين بانتظار المزيد من المعلومات، وآخر للطلبات المرفوضة حديثا.

عند الرد على طلب، راجعه بحرص، عند الحاجة، تأكد من المعلومات الموجودة فيه.
أفعالك ستسجل بسرية.
أنت أيضا يتوقع منك أن تراجع أي نشاط يحدث هنا بخلاف ما تفعله بنفسك.",
	'confirmaccount-list' => 'بالأسفل قائمة بطلبات الحسابات قيد الانتظار.
متى تمت الموافقة على أو رفض طلب ما فستتم إزالته من هذه القائمة.',
	'confirmaccount-list2' => 'بالأسفل قائمة بطلبات الحسابات المرفوضة حديثا والتي ربما يتم حذفها تلقائيا عندما يكون عمرها عدة أيام.
مازال بالإمكان الموافقة عليهم كحسابات، ولكنك ربما ترغب في استشارة الإداري الرافض
قبل فعل هذا.',
	'confirmaccount-list3' => 'بالأسفل قائمة بطلبات الحسابات المنتهية التي يمكن حذفها تلقائيا متى أصبح عمرها عدة أيام.
مازال من الممكن الموافقة عليهم كحسابات.',
	'confirmaccount-text' => "هذا طلب حساب قيد الانتظار في '''{{SITENAME}}'''.

راجع بحرص المعلومات بالأسفل.
لو كنت توافق على هذا الطلب، استخدم قائمة الموضع لضبط حالة الحساب للمستخدم.
التعديلات للسيرة الشخصية للمتقدم لن تؤثر على أي مخزن للمؤهلات الدائمة.
لاحظ أنه يمكنك اختيار إنشاء الحساب باسم مستخدم آخر.
استخدم هذا فقط لتجنب الاصطدامات مع الأسماء الأخرى.

لو تركت ببساطة هذه الصفحة بدون تأكيد أو رفض الحساب، سيبقى قيد الانتظار.",
	'confirmaccount-none-o' => 'لا توجد حاليا طلبات حساب قيد الانتظار مفتوحة في هذه القائمة.',
	'confirmaccount-none-h' => 'لا توجد حاليا طلبات حساب قيد الانتظار محجوزة في هذه القائمة.',
	'confirmaccount-none-r' => 'لا توجد حاليا طلبات حساب مرفوضة حديثا في هذه القائمة.',
	'confirmaccount-none-e' => 'لا توجد حاليا أي طلبات حسابات منتهية في هذه القائمة.',
	'confirmaccount-real-q' => 'الاسم',
	'confirmaccount-email-q' => 'البريد الإلكتروني',
	'confirmaccount-bio-q' => 'السيرة الشخصية',
	'confirmaccount-showopen' => 'طلبات مفتوحة',
	'confirmaccount-showrej' => 'طلبات مرفوضة',
	'confirmaccount-showheld' => 'عرض قائمة الحسابات قيد الانتظار',
	'confirmaccount-showexp' => 'طلبات مدتها انتهت',
	'confirmaccount-review' => 'مراجعة',
	'confirmaccount-types' => 'اختر طابور تأكيد حساب من الأسفل:',
	'confirmaccount-all' => '(عرض كل الطوابير)',
	'confirmaccount-type' => 'الطابور:',
	'confirmaccount-type-0' => 'مؤلفون سابقون',
	'confirmaccount-type-1' => 'محررون سابقون',
	'confirmaccount-q-open' => 'طلبات مفتوحة',
	'confirmaccount-q-held' => 'طلبات قيد الانتظار',
	'confirmaccount-q-rej' => 'طلبات مرفوضة حديثا',
	'confirmaccount-q-stale' => 'طلبات منتهية',
	'confirmaccount-badid' => 'لا يوجد طلب قيد الانتظار يوافق الرقم المعطى.
ربما يكون قد تمت معالجته.',
	'confirmaccount-leg-user' => 'حساب المستخدم',
	'confirmaccount-leg-areas' => 'الاهتمامات الرئيسية',
	'confirmaccount-leg-person' => 'المعلومات الشخصية',
	'confirmaccount-leg-other' => 'معلومات أخرى',
	'confirmaccount-name' => 'اسم المستخدم',
	'confirmaccount-real' => 'الاسم:',
	'confirmaccount-email' => 'البريد الإلكتروني:',
	'confirmaccount-reqtype' => 'الموضع:',
	'confirmaccount-pos-0' => 'مؤلف',
	'confirmaccount-pos-1' => 'محرر',
	'confirmaccount-bio' => 'السيرة الشخصية:',
	'confirmaccount-attach' => 'الاستكمال/السيرة الذاتية:',
	'confirmaccount-notes' => 'ملاحظات إضافية:',
	'confirmaccount-urls' => 'قائمة مواقع الوب:',
	'confirmaccount-none-p' => '(غير موفرة)',
	'confirmaccount-confirm' => 'استخدم الخيارات بالأسفل لقبول، رفض، أو تأجيل هذا الطلب.',
	'confirmaccount-econf' => '(تم تأكيده)',
	'confirmaccount-reject' => '(تم رفضه بواسطته [[User:$1|$1]] في $2)',
	'confirmaccount-rational' => 'السبب المعطى للمتقدم:',
	'confirmaccount-noreason' => '(لا شيء)',
	'confirmaccount-autorej' => '(الطلب تم إلغاؤه آليا بسبب عدم النشاط)',
	'confirmaccount-held' => '(تم التعليم "قيد الانتظار" بواسطة [[User:$1|$1]] في $2)',
	'confirmaccount-create' => 'اقبل (أنشئ الحساب)',
	'confirmaccount-deny' => 'ارفض (أزل من القائمة)',
	'confirmaccount-hold' => 'أجّل',
	'confirmaccount-spam' => 'سبام (لا ترسل البريد الإلكتروني)',
	'confirmaccount-reason' => 'تعليق (سيضم في البريد الإلكتروني):',
	'confirmaccount-ip' => 'عنوان الأيبي:',
	'confirmaccount-legend' => 'أكّد/ارفض هذا الحساب',
	'confirmaccount-submit' => 'أكّد',
	'confirmaccount-needreason' => 'يجب أن تحدد سببا في صندوق التعليق بالأسفل.',
	'confirmaccount-canthold' => 'هذا الطلب بالفعل إما قيد الانتظار أو محذوف.',
	'confirmaccount-acc' => 'طلب الحساب تم تأكيده بنجاح؛
أنشأ حسابا جديدا [[User:$1|$1]].',
	'confirmaccount-rej' => 'طلب الحساب تم رفضه بنجاح.',
	'confirmaccount-viewing' => '(حاليا يتم مراجعته بواسطة [[User:$1|$1]])',
	'confirmaccount-summary' => 'إنشاء صفحة المستخدم مع سيرة المستخدم الجديد.',
	'confirmaccount-welc' => "'''مرحبا إلى ''{{SITENAME}}''!'''
نأمل أن تساهم كثيرا وجيدا.
على الأرجح ستريد قراءة [[{{MediaWiki:Helppage}}|البداية]].
مجددا، مرحبا واستمتع!",
	'confirmaccount-wsum' => 'مرحبا!',
	'confirmaccount-email-subj' => '{{SITENAME}} طلب حساب',
	'confirmaccount-email-body' => 'طلبك لحساب تمت الموافقة عليه في {{SITENAME}}.

اسم الحساب: $1

كلمة السر: $2

لمتطلبات السرية ستضطر إلى تغيير كلمة السر الخاصة بك عند أول دخول. للدخول، من فضلك اذهب إلى
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'طلبك لحساب تمت الموافقة عليه في {{SITENAME}}.

اسم الحساب: $1

كلمة السر: $2

$3

لمتطلبات السرية ستضطر إلى تغيير كلمة السر الخاصة بك عند أول دخول. للدخول، من فضلك اذهب إلى
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'عذرا، طلبك لحساب "$1" تم رفضه في {{SITENAME}}.

هناك عدة طرق لحدوث هذا.
ربما تكون لم تملأ الاستمارة بشكل صحيح، أو لم توفر الطول اللازم في ردودك، أو فشلت في موافاة بعد بنود السياسة.
ربما تكون هناك قوائم اتصال على الموقع يمكنك استخدامها لو كنت تريد معرفة المزيد حول سياسة حساب المستخدم.',
	'confirmaccount-email-body4' => 'عذرا، طلبك لحساب "$1" تم رفضه في {{SITENAME}}.

$2

ربما تكون هناك قوائم اتصال على الموقع يمكنك استخدامها لو كنت تريد معرفة المزيد حول سياسة حساب المستخدم.',
	'confirmaccount-email-body5' => 'قبل أن يتم قبول طلبك للحساب "$1" في {{SITENAME}} يجب أن توفر أولا بعض المعلومات الإضافية.

$2

ربما تكون هناك قوائم اتصال في الموقع يمكنك استخدامها لو أردت أن تعرف المزيد حول سياسة حساب المستخدم.',
	'usercredentials' => 'مؤهلات المستخدم',
	'usercredentials-leg' => 'ابحث عن المؤهلات المؤكدة لمستخدم',
	'usercredentials-user' => 'اسم المستخدم:',
	'usercredentials-text' => 'بالأسفل المؤهلات المؤكدة لحساب المستخدم المختار.',
	'usercredentials-leg-user' => 'حساب المستخدم',
	'usercredentials-leg-areas' => 'الاهتمامات الرئيسية',
	'usercredentials-leg-person' => 'المعلومات الشخصية',
	'usercredentials-leg-other' => 'معلومات أخرى',
	'usercredentials-email' => 'البريد الإلكتروني:',
	'usercredentials-real' => 'الاسم الحقيقي:',
	'usercredentials-bio' => 'السيرة الشخصية:',
	'usercredentials-attach' => 'استكمال/سيرة شخصية:',
	'usercredentials-notes' => 'ملاحظات إضافية:',
	'usercredentials-urls' => 'قائمة مواقع الويب:',
	'usercredentials-ip' => 'عنوان الأيبي الأصلي:',
	'usercredentials-member' => 'الصلاحيات:',
	'usercredentials-badid' => 'لا مؤهلات تم العثور عليها لهذا المستخدم.
تأكد من أن الاسم مكتوب بطريقة صحيحة.',
	'right-confirmaccount' => 'عرض [[Special:ConfirmAccounts|طابور الحسابات المطلوبة]]',
	'right-requestips' => 'عرض عنوان آيبي الطالب أثناء العمل على الحسابات المطلوبة',
	'right-lookupcredentials' => 'رؤية [[Special:UserCredentials|شهادات المستخدم]]',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'requestaccount-leg-user' => 'ܚܘܫܒܢܐ ܕܡܦܠܚܢܐ',
	'requestaccount-leg-person' => 'ܝܕ̈ܥܬܐ ܦܪ̈ܨܘܦܝܬܐ',
	'requestaccount-leg-other' => 'ܝܕ̈ܥܬܐ ܐܚܪ̈ܢܝܬܐ',
	'requestaccount-leg-tos' => 'ܫܪ̈ܛܐ ܕܬܫܡܫܬܐ',
	'requestaccount-real' => 'ܫܡܐ ܫܪܝܪܐ:',
	'requestaccount-same' => '(ܐܝܟ ܫܡܐ ܫܪܝܪܐ)',
	'requestaccount-level-0' => 'ܣܝܘܡܐ',
	'requestaccount-level-1' => 'ܫܚܠܦܢܐ',
	'confirmaccount-real-q' => 'ܫܡܐ',
	'confirmaccount-review' => 'ܬܢܝ',
	'confirmaccount-wsum' => 'ܒܫܝܢܐ!',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'requestaccount' => 'طلب حساب',
	'requestaccount-text' => "'''أكمل وابعث الاستمارة التالية لطلب حساب'''.

تأكد أولا من قراءة [[{{MediaWiki:Requestaccount-page}}|شروط الخدمة]] قبل طلب حساب.

	متى تمت الموافقة على الحساب، سيتم إرسال رسالة إخطار إليك والحساب سيصبح قابلا للاستخدام فى
[[Special:UserLogin|تسجيل الدخول]].",
	'requestaccount-page' => '{{ns:project}}:شروط الخدمة',
	'requestaccount-dup' => "'''ملاحظة: أنت مسجل الدخول بالفعل بحساب مسجل.'''",
	'requestaccount-leg-user' => 'حساب المستخدم',
	'requestaccount-leg-areas' => 'الاهتمامات الرئيسية',
	'requestaccount-leg-person' => 'المعلومات الشخصية',
	'requestaccount-leg-other' => 'معلومات أخرى',
	'requestaccount-leg-tos' => 'شروط الخدمة',
	'requestaccount-acc-text' => 'سيتم إرسال رسالة تأكيد إلى عنوان بريدك الإلكترونى متى تم بعث هذا الطلب.
من فضلك استجب عن طريق الضغط على وصلة التأكيد المعطاة فى البريد الإلكترونى.
أيضا، كلمة السر الخاصة بك سيتم إرسالها إليك عبر البريد الإلكترونى عندما يتم إنشاء حسابك.',
	'requestaccount-areas-text' => 'اختر المواضيع بالأسفل التى لديك فيها خبرة رسمية أو التى تود أن تعمل فيها.',
	'requestaccount-ext-text' => 'المعلومات التالية سرية وسيتم استخدامها فقط لهذا الطلب.
ربما تريد أن تكتب معلومات الاتصال كرقم تليفون للمساعدة فى تأكيد الهوية.',
	'requestaccount-bio-text' => 'سيرتك الشخصية ستعرض كالمحتوى الافتراضى لصفحة المستخدم الخاصة بك.
حاول تضمين أية شهادات.
تأكد من ارتياحك لنشر هذه المعلومات.
اسمك يمكن تغييره من خلال [[Special:Preferences|تفضيلاتك]].',
	'requestaccount-real' => 'الاسم الحقيقي:',
	'requestaccount-same' => '(مثل الاسم الحقيقي)',
	'requestaccount-email' => 'عنوان البريد الإلكتروني:',
	'requestaccount-reqtype' => 'الموضع:',
	'requestaccount-level-0' => 'مؤلف',
	'requestaccount-level-1' => 'محرر',
	'requestaccount-info' => '(؟)',
	'requestaccount-bio' => 'السيرة الشخصية:',
	'requestaccount-attach' => 'استكمال أو السيرة الذاتية (اختياري):',
	'requestaccount-notes' => 'ملاحظات إضافية:',
	'requestaccount-urls' => 'قائمة مواقع الويب، إن وجدت (افصل بسطور جديدة):',
	'requestaccount-agree' => 'يجب أن تشهد أن اسمك الحقيقى صحيح وأنك توافق على شروط خدمتنا.',
	'requestaccount-inuse' => 'اسم المستخدم مستعمل بالفعل فى طلب حساب قيد الانتظار',
	'requestaccount-tooshort' => 'يجب أن يكون طول سيرتك على الأقل {{PLURAL:$1||كلمة واحدة|كلمتين|$1 كلمات|$1 كلمة}}.',
	'requestaccount-emaildup' => 'طلب حساب آخر قيد الانتظار يستخدم نفس عنوان البريد الإلكترونى.',
	'requestaccount-exts' => 'نوع الملف المرفق غير مسموح به.',
	'requestaccount-resub' => 'ملف سيرتك الذاتية/استكمالك يجب أن يتم إعادة اختياره لأسباب أمنية.
اترك الحقل فارغا لو كنت لم تعد تريد إضافة واحد.',
	'requestaccount-tos' => 'لقد قرأت وأوافق على الالتزام [[{{MediaWiki:Requestaccount-page}}|بشروط خدمة]] {{SITENAME}}.
الاسم الذي حددته تحت "الاسم الحقيقي" هو في الواقع اسمي الحقيقي.',
	'requestaccount-submit' => 'طلب حساب',
	'requestaccount-sent' => 'طلبك للحساب تم إرساله بنجاح وهو بانتظار المراجعة الآن.
بريد إلكترونى للتأكيد تم إرساله إلى عنوان بريدك الإلكترونى.',
	'request-account-econf' => 'عنوان بريدك الإلكترونى تم تأكيده وسيتم عرضه كما هو فى طلب حسابك.',
	'requestaccount-email-subj' => '{{SITENAME}} تأكيد عنوان البريد الإلكترونى من',
	'requestaccount-email-body' => 'شخص ما، على الأرجح أنت من عنوان الأيبى $1، طلب حساب "$2" بعنوان البريد الإلكترونى هذا على {{SITENAME}}.

لتأكيد أن هذا الحساب ينتمى إليك فعلا على {{SITENAME}}، افتح هذه الوصلة فى متصفحك:

$3

لو أن الحساب تم إنشاؤه، فقط أنت سيتم إرسال كلمة السر إليه.
لو أن هذا *ليس* أنت، لا تتبع الوصلة.
كود التأكيد سينتهى فى $4.',
	'requestaccount-email-subj-admin' => 'طلب حساب {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" طلب حسابا وينتظر التأكيد.
عنوان البريد الإلكترونى تم تأكيده. يمكنك تأكيد الطلب هنا "$2".',
	'acct_request_throttle_hit' => 'عذرا، لقد طلبت بالفعل {{PLURAL:$1|1 حساب|$1 حساب}}.
لا يمكنك عمل المزيد من الطلبات.',
	'requestaccount-loginnotice' => "للحصول على حساب، يجب عليك '''[[Special:RequestAccount|طلب واحد]]'''.",
	'confirmaccount-newrequests' => "{{PLURAL:$1|يوجد|يوجد}} حاليا '''$1'''
{{PLURAL:$1|[[Special:ConfirmAccounts|طلب حساب]]|[[Special:ConfirmAccounts|طلب حساب]]}} مفتوح قيد الانتظار.",
	'confirmaccounts' => 'تأكيد طلبات الحسابات',
	'confirmedit-desc' => 'يعطى البيروقراطيين القدرة على تأكيد طلبات الحساب',
	'confirmaccount-maintext' => "'''هذه الصفحة تستخدم لتأكيد طلبات الحساب قيد الانتظار فى ''{{SITENAME}}'''''.

كل طابور طلب حساب يتكون من ثلاثة طوابير فرعية، واحد للطلبات المفتوحة، واحد لتلك التى تم وضعها قيد الانتظار بواسطة الإداريين الآخرين بانتظار المزيد من المعلومات، وآخر للطلبات المرفوضة حديثا.

عند الرد على طلب، راجعه بحرص، عند الحاجة، تأكد من المعلومات الموجودة فيه.
أفعالك ستسجل بسرية.
أنت أيضا يتوقع منك أن تراجع أى نشاط يحدث هنا بخلاف ما تفعله بنفسك.",
	'confirmaccount-list' => 'بالأسفل قائمة بطلبات الحسابات قيد الانتظار.
متى تمت الموافقة على أو رفض طلب ما فستتم إزالته من هذه القائمة.',
	'confirmaccount-list2' => 'بالأسفل قائمة بطلبات الحسابات المرفوضة حديثا والتى ربما يتم حذفها تلقائيا عندما يكون عمرها عدة أيام.
مازال بالإمكان الموافقة عليهم كحسابات، ولكنك ربما ترغب فى استشارة الإدارى الرافض
قبل فعل هذا.',
	'confirmaccount-list3' => 'بالأسفل قائمة بطلبات الحسابات المنتهية التى يمكن حذفها تلقائيا متى أصبح عمرها عدة أيام.
مازال من الممكن الموافقة عليهم كحسابات.',
	'confirmaccount-text' => "هذا طلب حساب قيد الانتظار فى '''{{SITENAME}}'''.

راجع بحرص المعلومات بالأسفل.
لو كنت توافق على هذا الطلب، استخدم قائمة الموضع لضبط حالة الحساب للمستخدم.
التعديلات للسيرة الشخصية للمتقدم لن تؤثر على أى مخزن للمؤهلات الدائمة.
لاحظ أنه يمكنك اختيار إنشاء الحساب باسم مستخدم آخر.
استخدم هذا فقط لتجنب الاصطدامات مع الأسماء الأخرى.

لو تركت ببساطة هذه الصفحة بدون تأكيد أو رفض الحساب، سيبقى قيد الانتظار.",
	'confirmaccount-none-o' => 'لا توجد حاليا طلبات حساب قيد الانتظار مفتوحة فى هذه القائمة.',
	'confirmaccount-none-h' => 'لا توجد حاليا طلبات حساب قيد الانتظار محجوزة فى هذه القائمة.',
	'confirmaccount-none-r' => 'لا توجد حاليا طلبات حساب مرفوضة حديثا فى هذه القائمة.',
	'confirmaccount-none-e' => 'لا توجد حاليا أى طلبات حسابات منتهية فى هذه القائمة.',
	'confirmaccount-real-q' => 'الاسم',
	'confirmaccount-email-q' => 'البريد الإلكتروني',
	'confirmaccount-bio-q' => 'السيرة الشخصية',
	'confirmaccount-showopen' => 'طلبات مفتوحة',
	'confirmaccount-showrej' => 'طلبات مرفوضة',
	'confirmaccount-showheld' => 'عرض قائمة الحسابات قيد الانتظار',
	'confirmaccount-showexp' => 'طلبات مدتها انتهت',
	'confirmaccount-review' => 'مراجعة',
	'confirmaccount-types' => 'اختر طابور تأكيد حساب من الأسفل:',
	'confirmaccount-all' => '(عرض كل الطوابير)',
	'confirmaccount-type' => 'الطابور:',
	'confirmaccount-type-0' => 'مؤلفون سابقون',
	'confirmaccount-type-1' => 'محررون سابقون',
	'confirmaccount-q-open' => 'طلبات مفتوحة',
	'confirmaccount-q-held' => 'طلبات قيد الانتظار',
	'confirmaccount-q-rej' => 'طلبات مرفوضة حديثا',
	'confirmaccount-q-stale' => 'طلبات منتهية',
	'confirmaccount-badid' => 'لا يوجد طلب قيد الانتظار يوافق الرقم المعطى.
ربما يكون قد تمت معالجته.',
	'confirmaccount-leg-user' => 'حساب المستخدم',
	'confirmaccount-leg-areas' => 'الاهتمامات الرئيسية',
	'confirmaccount-leg-person' => 'المعلومات الشخصية',
	'confirmaccount-leg-other' => 'معلومات أخرى',
	'confirmaccount-name' => 'اسم المستخدم',
	'confirmaccount-real' => 'الاسم:',
	'confirmaccount-email' => 'البريد الإلكتروني:',
	'confirmaccount-reqtype' => 'الموضع:',
	'confirmaccount-pos-0' => 'مؤلف',
	'confirmaccount-pos-1' => 'محرر',
	'confirmaccount-bio' => 'السيرة الشخصية:',
	'confirmaccount-attach' => 'الاستكمال/السيرة الذاتية:',
	'confirmaccount-notes' => 'ملاحظات إضافية:',
	'confirmaccount-urls' => 'قائمة مواقع الويب:',
	'confirmaccount-none-p' => '(غير موفرة)',
	'confirmaccount-confirm' => 'استخدم الخيارات بالأسفل لقبول، رفض، أو تأجيل هذا الطلب.',
	'confirmaccount-econf' => '(تم تأكيده)',
	'confirmaccount-reject' => '(تم رفضه بواسطته [[User:$1|$1]] فى $2)',
	'confirmaccount-rational' => 'السبب المعطى للمتقدم:',
	'confirmaccount-noreason' => '(لا شيء)',
	'confirmaccount-autorej' => '(الطلب تم إلغاؤه آليا بسبب عدم النشاط)',
	'confirmaccount-held' => '(تم التعليم "قيد الانتظار" بواسطة [[User:$1|$1]] فى $2)',
	'confirmaccount-create' => 'قبول (إنشاء الحساب)',
	'confirmaccount-deny' => 'رفض (إزالة من القائمة)',
	'confirmaccount-hold' => 'تأجيل',
	'confirmaccount-spam' => 'سبام (لا ترسل البريد الإلكتروني)',
	'confirmaccount-reason' => 'تعليق (سيضم فى البريد الإلكتروني):',
	'confirmaccount-ip' => 'عنوان الأيبي:',
	'confirmaccount-submit' => 'تأكيد',
	'confirmaccount-needreason' => 'يجب أن تحدد سببا فى صندوق التعليق بالأسفل.',
	'confirmaccount-canthold' => 'هذا الطلب بالفعل إما قيد الانتظار أو محذوف.',
	'confirmaccount-acc' => 'طلب الحساب تم تأكيده بنجاح؛
أنشأ حسابا جديدا [[User:$1|$1]].',
	'confirmaccount-rej' => 'طلب الحساب تم رفضه بنجاح.',
	'confirmaccount-viewing' => '(حاليا يتم مراجعته بواسطة [[User:$1|$1]])',
	'confirmaccount-summary' => 'إنشاء صفحة المستخدم مع سيرة المستخدم الجديد.',
	'confirmaccount-welc' => "'''مرحبا إلى ''{{SITENAME}}''!'''
نأمل أن تساهم كثيرا وجيدا.
على الأرجح ستريد قراءة [[{{MediaWiki:Helppage}}|البداية]].
مجددا، مرحبا واستمتع!",
	'confirmaccount-wsum' => 'مرحبا!',
	'confirmaccount-email-subj' => '{{SITENAME}} طلب حساب',
	'confirmaccount-email-body' => 'طلبك لحساب تمت الموافقة عليه فى {{SITENAME}}.

اسم الحساب: $1

كلمة السر: $2

لمتطلبات السرية ستضطر إلى تغيير كلمة السر الخاصة بك عند أول دخول. للدخول، من فضلك اذهب إلى
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'طلبك لحساب تمت الموافقة عليه فى {{SITENAME}}.

اسم الحساب: $1

كلمة السر: $2

$3

لمتطلبات السرية ستضطر إلى تغيير كلمة السر الخاصة بك عند أول دخول. للدخول، من فضلك اذهب إلى
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'عذرا، طلبك لحساب "$1" تم رفضه فى {{SITENAME}}.

هناك عدة طرق لحدوث هذا.
ربما تكون لم تملأ الاستمارة بشكل صحيح، أو لم توفر الطول اللازم فى ردودك، أو فشلت فى موافاة بعد بنود السياسة.
ربما تكون هناك قوائم اتصال على الموقع يمكنك استخدامها لو كنت تريد معرفة المزيد حول سياسة حساب المستخدم.',
	'confirmaccount-email-body4' => 'عذرا، طلبك لحساب "$1" تم رفضه فى {{SITENAME}}.

$2

ربما تكون هناك قوائم اتصال على الموقع يمكنك استخدامها لو كنت تريد معرفة المزيد حول سياسة حساب المستخدم.',
	'confirmaccount-email-body5' => 'قبل أن يتم قبول طلبك للحساب "$1" فى {{SITENAME}} يجب أن توفر أولا بعض المعلومات الإضافية.

$2

ربما تكون هناك قوائم اتصال فى الموقع يمكنك استخدامها لو أردت أن تعرف المزيد حول سياسة حساب المستخدم.',
	'usercredentials' => 'مؤهلات المستخدم',
	'usercredentials-leg' => 'ابحث عن المؤهلات المؤكدة لمستخدم',
	'usercredentials-user' => 'اسم المستخدم:',
	'usercredentials-text' => 'بالأسفل المؤهلات المؤكدة لحساب المستخدم المختار.',
	'usercredentials-leg-user' => 'حساب المستخدم',
	'usercredentials-leg-areas' => 'الاهتمامات الرئيسية',
	'usercredentials-leg-person' => 'المعلومات الشخصية',
	'usercredentials-leg-other' => 'معلومات أخرى',
	'usercredentials-email' => 'البريد الإلكتروني:',
	'usercredentials-real' => 'الاسم الحقيقي:',
	'usercredentials-bio' => 'السيرة الشخصية:',
	'usercredentials-attach' => 'استكمال/سيرة شخصية:',
	'usercredentials-notes' => 'ملاحظات إضافية:',
	'usercredentials-urls' => 'قائمة مواقع الويب:',
	'usercredentials-ip' => 'عنوان الأيبى الأصلي:',
	'usercredentials-member' => 'الصلاحيات:',
	'usercredentials-badid' => 'لا مؤهلات تم العثور عليها لهذا المستخدم.
تأكد من أن الاسم مكتوب بطريقة صحيحة.',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'requestaccount-real' => 'Totoong pangaran:',
	'requestaccount-same' => '(pareho sa  totoong pangaran)',
	'confirmaccount-real' => 'Pangaran',
	'confirmaccount-submit' => 'Kompermaron',
	'confirmaccount-wsum' => 'Dagos!',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'requestaccount' => 'Запыт на стварэньне рахунку',
	'requestaccount-text' => "'''Запоўніце і адпраўце наступную форму, каб запрасіць рахунак удзельніка'''.

Калі ласка, прачытайце [[{{MediaWiki:Requestaccount-page}}|Умовы прадстаўленьня паслугаў]] перад запытам рахунку.

Пасьля стварэньня рахунку, Вам будзе дасланы ліст па электроннай пошце з паведамленьнем і Вы зможаце [[Special:UserLogin|ўвайсьці ў сыстэму]].",
	'requestaccount-page' => '{{ns:project}}:Умовы прадстаўленьня паслугаў',
	'requestaccount-dup' => "'''Заўвага: Вы ўжо ўвайшлі ў сыстэму з зарэгістраваным рахункам.'''",
	'requestaccount-leg-user' => 'Рахунак удзельніка',
	'requestaccount-leg-areas' => 'Асноўныя вобласьці інтарэсаў',
	'requestaccount-leg-person' => 'Асабістыя зьвесткі',
	'requestaccount-leg-other' => 'Іншая інфармацыя',
	'requestaccount-leg-tos' => 'Умовы прадстаўленьня паслугаў',
	'requestaccount-acc-text' => 'Пасьля адпраўкі запыту на Ваш адрас электроннай пошты будзе дасланы ліст з пацьверджаньнем.
Калі ласка, націсьніце на спасылку з пацьверджаньнем ў лісьце. 
Пароль будзе дасланы Вам па электроннай пошце, калі будзе створаны Ваш рахунак.',
	'requestaccount-areas-text' => 'Выберыце вобласьці інтарэсаў, у якіх Вы кампэтэнтны альбо на якімі Вы зьбіраецеся працаваць у найбольшай ступені.',
	'requestaccount-ext-text' => 'Наступная інфармацыя будзе прыватнай і будзе выкарыстана толькі для апрацоўкі гэтага запыту.
Вы можаце падаць спосабы кантактаў, напрыклад, нумар тэлефона, каб пацьвердзіць ідэнтычнасьць.',
	'requestaccount-bio-text' => 'Вашая біяграфія будзе па змоўчваньні разьмешчаная на Вашай старонцы ўдзельніка.
Паспрабуйце уключыць якую-небудзь інфармацыю аб вашай адукацыі.
Упэўніцеся, што Вы ня супраць апублікаваньня падобнай інфармацыі.
Вашае імя можа быць зьменена праз [[Special:Preferences|Вашыя ўстаноўкі]].',
	'requestaccount-real' => 'Сапраўднае імя:',
	'requestaccount-same' => '(такое ж як і сапраўднае імя)',
	'requestaccount-email' => 'Адрас электроннай пошты:',
	'requestaccount-reqtype' => 'Пасада:',
	'requestaccount-level-0' => 'аўтар',
	'requestaccount-level-1' => 'рэдактар',
	'requestaccount-bio' => 'Асабістая біяграфія:',
	'requestaccount-attach' => 'Рэзюмэ (неабавязковае):',
	'requestaccount-notes' => 'Дадатковая інфармацыя:',
	'requestaccount-urls' => 'Сьпіс сайтаў, калі ёсьць (кожны ў асобным радку):',
	'requestaccount-agree' => 'Вы павінны пацьвердзіць, што Вашае сапраўднае імя пазначана слушна і што Вы згодны з нашымі ўмовамі прадстаўленьня паслугаў.',
	'requestaccount-inuse' => 'Імя ўдзельніка ўжо ўказанае ў адным з запытаў на стварэньне рахунка.',
	'requestaccount-tooshort' => 'Ваша біяграфія павінна ўтрымліваць ня меней за $1 {{PLURAL:$1|слова|словы|словаў}}.',
	'requestaccount-emaildup' => 'У іншым неапрацаваным запыце на стварэньне рахунку пададзены такі ж самы адрас электроннай пошты.',
	'requestaccount-exts' => 'Тып файла забаронены для далучэньняў.',
	'requestaccount-resub' => 'У мэтах бясьпекі Ваш файл рэзюмэ павінен быць заменены.
Пакіньце поле пустым, калі Вы не жадаеце дадаваць рэзюмэ.',
	'requestaccount-tos' => 'Я прачытаў і згодны з [[{{MediaWiki:Requestaccount-page}}|умовамі прадстаўленьня паслугаў]] {{GRAMMAR:родны|{{SITENAME}}}}.
Імя, якое я пазначыў у полі «Сапраўднае імя» сапраўды зьяўляецца маім сапраўдным іменем.',
	'requestaccount-submit' => 'Запытаць стварэньне рахунку',
	'requestaccount-sent' => 'Ваш запыт на стварэньне рахунку быў пасьпяхова дасланы і цяпер чакае апрацоўкі.
Электронны ліст з пацьверджаньнем быў дасланы на Ваш адрас электроннай пошты.',
	'request-account-econf' => 'Ваш адрас электроннай пошты быў пацьверджаны і будзе пазначаны ў Вашым запыце на стварэньне рахунку.',
	'requestaccount-email-subj' => 'Пацьверджаньне адрасу электроннай пошты {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'requestaccount-email-body' => 'Нехта, верагодна Вы, з IP-адрасу $1, запытаў стварэньне рахунку «$2» у {{GRAMMAR:месны|{{SITENAME}}}} з гэтым адрасам электроннай пошты.

Каб пацьвердзіць, што гэты рахунак у {{GRAMMAR:месны|{{SITENAME}}}} сапраўды належыць Вам, адкрыйце гэтую спасылку ў Вашым браўзэры:

$3

Калі рахунак будзе створаны, пароль будзе дасланы толькі Вам.
Калі гэта *не* Вы, не адкрывайце спасылку.
Гэты код пацьверджаньня будзе дзейнічаць да $4.',
	'requestaccount-email-subj-admin' => 'Запыт на стварэньне рахунку ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'requestaccount-email-body-admin' => '«$1» запытаў стварэньне рахунку і чакае пацьверджаньня.
Адрас электроннай пошты быў пацьверджаны. Вы можаце пацьвердзіць запыт тут «$2».',
	'acct_request_throttle_hit' => 'Прабачце, але Вы ўжо запыталі стварэньне рахунку $1 {{PLURAL:$1|раз|разы|разоў}}.
Вы больш ня можаце рабіць новыя запыты.',
	'requestaccount-loginnotice' => "Каб атрымаць рахунак, Вам неабходна '''[[Special:RequestAccount|падаць запыт]]'''.",
	'confirmaccount-newrequests' => "Чакаецца апрацоўка '''$1'''
[[Special:ConfirmAccounts|{{PLURAL:$1|запыту на стварэньне рахунку|запытаў на стварэньне рахунку|запытаў на стварэньне рахунку}}]].",
	'confirmaccounts' => 'Пацьвердзіць запыт на стварэньне рахунку',
	'confirmedit-desc' => 'Дае бюракратам магчымасьць пацьвярджаць запыты на стварэньне рахункаў',
	'confirmaccount-maintext' => "'''Гэта старонка выкарыстоўваецца для пацьверджаньня запытаў на стварэньне рахункаў у ''{{GRAMMAR:родны|{{SITENAME}}}}'''''.

Кожны чарга запытаў на стварэньне рахункаў складаецца з трох частак.
Адна для неапрацаваных запытаў, адна для запытаў, якія адкладзеныя адміністратарамі да атрыманьня дадатковай інфармацыі, і яшчэ адна для нядаўна адхіленых запытаў.

Пасьля адказу на запыт, уважліва праглядзіце яго, калі неабходна, пацьвердзіце утрымліваемую інфармацыю.
Вашыя дзеяньні будуць запісаны ў журнал.
Чакаецца, што Ваша праца па прагляду і пацьверджаньню запытаў будзе весьціся незалежна ад таго, чым Вы займаецеся.",
	'confirmaccount-list' => 'Ніжэй пададзены сьпіс запытаў, якія чакаюць зацьверджаньня.
Пасьля зацьверджаньня альбо адхіленьня, запыт будзе выдалены з гэтага сьпісу.',
	'confirmaccount-list2' => 'Ніжэй пададзены сьпіс нядаўна адхіленых запытаў на стварэньне рахункаў, якія будуць аўтаматычна выдаленыя праз некалькі дзён. 
Вы ўсё яшчэ можаце зацьвердзіць запыты, але спачатку гэта неабходна абмеркаваць з адміністратарамі, якія іх адхілілі.',
	'confirmaccount-list3' => 'Ніжэй пададзены сьпіс састарэлых запытаў на стварэньне рахункаў, якія могуць быць аўтаматычна выдаленыя праз некалькі дзён..
Гэтыя запыты ўсё яшчэ могуць быць зацьверджанымі.',
	'confirmaccount-text' => "Гэта запыт на стварэньне рахунку ў '''{{GRAMMAR:родны|{{SITENAME}}}}'''.

Уважліва праглядзіце інфармацыю ніжэй.
Калі Вы жадаеце зацьвердзіць гэты запыт, зьмяніце статус запыту праз выпадаючы сьпіс.
Рэдагаваньні зробленыя ў біяграфіі не паўплываюць на пасьведчаньне ўдзельніка ў сыстэмным сховішчы.
Заўважце, што Вы можаце стварыць рахунак зь іншай назвай.
Карыстайцеся гэтай магчымасьцю толькі для таго, каб пазьбегнуць канфліктаў зь іншымі назвамі рахункаў.

Калі Вы проста пакінеце гэту старонку не зацьвердзіўшы і не адхіліўшы запыт, то ён застанецца ў стане чаканьня.",
	'confirmaccount-none-o' => 'У цяперашні час няма неапрацаваных запытаў ў гэтым сьпісе.',
	'confirmaccount-none-h' => 'У цяперашні час няма адкладзеных запытаў ў гэтым сьпісе.',
	'confirmaccount-none-r' => 'У цяперашні час няма нядаўна адхіленых запытаў ў гэтым сьпісе.',
	'confirmaccount-none-e' => 'У цяперашні час няма састарэлых запытаў ў гэтым сьпісе.',
	'confirmaccount-real-q' => 'Імя',
	'confirmaccount-email-q' => 'Адрас электроннай пошты',
	'confirmaccount-bio-q' => 'Біяграфія',
	'confirmaccount-showopen' => 'адкрытыя запыты',
	'confirmaccount-showrej' => 'адхіленыя запыты',
	'confirmaccount-showheld' => 'адкладзеныя запыты',
	'confirmaccount-showexp' => 'састарэлыя запыты',
	'confirmaccount-review' => 'Праглядзець',
	'confirmaccount-types' => 'Выберыце чаргу пацьверджаньня запытаў са сьпісу ніжэй:',
	'confirmaccount-all' => '(паказаць усе чэргі)',
	'confirmaccount-type' => 'Чарга:',
	'confirmaccount-type-0' => 'патэнцыяльныя аўтары',
	'confirmaccount-type-1' => 'патэнцыяльныя рэдактары',
	'confirmaccount-q-open' => 'адкрытыя запыты',
	'confirmaccount-q-held' => 'адкладзеныя запыты',
	'confirmaccount-q-rej' => 'нядаўна адхіленыя запыты',
	'confirmaccount-q-stale' => 'састарэлыя запыты',
	'confirmaccount-badid' => 'Няма запытаў на стварэньне рахунка з пададзеным ідэнтыфікатарам.
Верагодна ён ужо апрацаваны.',
	'confirmaccount-leg-user' => 'Рахунак удзельніка',
	'confirmaccount-leg-areas' => 'Галоўныя вобласьці інтарэсаў',
	'confirmaccount-leg-person' => 'Асабістыя зьвесткі',
	'confirmaccount-leg-other' => 'Іншая інфармацыя',
	'confirmaccount-name' => 'Імя ўдзельніка',
	'confirmaccount-real' => 'Імя:',
	'confirmaccount-email' => 'Адрас электроннай пошты:',
	'confirmaccount-reqtype' => 'Пасада:',
	'confirmaccount-pos-0' => 'аўтар',
	'confirmaccount-pos-1' => 'рэдактар',
	'confirmaccount-bio' => 'Біяграфія:',
	'confirmaccount-attach' => 'Рэзюмэ:',
	'confirmaccount-notes' => 'Дадатковая інфармацыя:',
	'confirmaccount-urls' => 'Сьпіс сайтаў:',
	'confirmaccount-none-p' => '(не пададзена)',
	'confirmaccount-confirm' => 'Выкарыстоўвайце ўстаноўкі ніжэй для зацьверджаньня, адхіленьня ці адкладаньня запыту:',
	'confirmaccount-econf' => '(пацьверджаны)',
	'confirmaccount-reject' => '(адхілены [[User:$1|$1]] $2)',
	'confirmaccount-rational' => 'Абгрунтаваньне пададзенае падаўшаму запыт:',
	'confirmaccount-noreason' => '(няма)',
	'confirmaccount-autorej' => '(гэты запыт быў аўтаматычна адхілены з-за неактыўнасьці)',
	'confirmaccount-held' => '(адкладзены [[User:$1|$1]] $2)',
	'confirmaccount-create' => 'Зацьвердзіць (стварыць рахунак)',
	'confirmaccount-deny' => 'Адхіліць (выдаліць са сьпісу)',
	'confirmaccount-hold' => 'Адкласьці',
	'confirmaccount-spam' => 'Спам (не дасылаць лісты па электроннай пошце)',
	'confirmaccount-reason' => 'Камэнтар (будзе ўключаны ў электронны ліст):',
	'confirmaccount-ip' => 'IP-адрас:',
	'confirmaccount-legend' => 'Пацьвердзіць/адмовіцца ад гэтага рахунку',
	'confirmaccount-submit' => 'Пацьвердзіць',
	'confirmaccount-needreason' => 'Вы павінны падаць прычыну ў полі камэнтару.',
	'confirmaccount-canthold' => 'Гэты запыт ужо адкладзены альбо выдалены.',
	'confirmaccount-acc' => 'Запыт на стварэньне рахунку пасьпяхова пацьверджаны;
створаны рахунак [[User:$1|$1]].',
	'confirmaccount-rej' => 'Запыт на стварэньне рахунку быў пасьпяхова адхілены.',
	'confirmaccount-viewing' => '(зараз праглядаецца [[User:$1|$1]])',
	'confirmaccount-summary' => 'Стварэньне старонкі ўдзельніка з біяграфіяй новага ўдзельніка.',
	'confirmaccount-welc' => "'''Вітаем у ''{{GRAMMAR:месны|{{SITENAME}}}}''!'''
Мы спадзяёмся, што Вы прыміце актыўны ўдзел у працы праекта.
Верагодна, Вам будзе цікава прачытаць [[{{MediaWiki:Helppage}}|старонкі дапамогі]].
Яшчэ раз вітаем Вас, і жадаем прыемнай працы!",
	'confirmaccount-wsum' => 'Вітаем!',
	'confirmaccount-email-subj' => 'Запыт на стварэньне рахунку ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'confirmaccount-email-body' => 'Ваш запыт на стварэньне рахунку ў {{GRAMMAR:месны|{{SITENAME}}}} быў зацьверджаны.

Назва рахунку: $1

Пароль: $2

У мэтах бясьпекі, Вам неабходна зьмяніць пароль пасьля першага ўваходу ў сыстэму.
Увайсьці ў сыстэму можна на старонцы {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Ваш запыт на стварэньне рахунку ў {{GRAMMAR:месны|{{SITENAME}}}} быў зацьверджаны.

Назва рахунку: $1

Пароль: $2

$3

У мэтах бясьпекі, Вам неабходна зьмяніць пароль пасьля першага ўваходу ў сыстэму.
Увайсьці ў сыстэму можна на старонцы {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Прабачце, але Ваш запыт на стварэньне рахунку «$1» у {{GRAMMAR:месны|{{SITENAME}}}} быў адхілены.

Гэта магло адбыцца па некалькіх прычынах.
Верагодна, Вы не запоўнілі форму карэктна, Вашыя адказы на пытаньні былі ня поўныя альбо не задавальняльнымі з пункту гледжаньня правілаў.
У {{GRAMMAR:месны|{{SITENAME}}}} можа быць сьпіс кантактаў, якія Вы можаце выкарыстоўваць, каб атрымаць дадатковую інфармацыю пра правілы, якія тычацца рахункаў удзельнікаў.',
	'confirmaccount-email-body4' => 'Прабачце, але Ваш запыт на стварэньне рахунку «$1» у {{GRAMMAR:месны|{{SITENAME}}}} быў адхілены.

$2

У {{GRAMMAR:месны|{{SITENAME}}}} можа быць сьпіс кантактаў, якія Вы можаце выкарыстоўваць, каб атрымаць дадатковую інфармацыю пра правілы, якія тычацца рахункаў удзельнікаў.',
	'confirmaccount-email-body5' => 'Перад тым, як Ваш запыт на стварэньне рахунку «$1» у {{GRAMMAR:месны|{{SITENAME}}}} будзе зацьверджаны, Вам неабходна падаць дадатковую інфармацыю.

$2

У {{GRAMMAR:месны|{{SITENAME}}}} можа быць сьпіс кантактаў, якія Вы можаце выкарыстоўваць, каб атрымаць дадатковую інфармацыю пра правілы, якія тычацца рахункаў удзельнікаў.',
	'usercredentials' => 'Пасьведчаньні ўдзельніка',
	'usercredentials-leg' => 'Пошук пацьверджаных пасьведчаньняў удзельніка',
	'usercredentials-user' => 'Імя ўдзельніка:',
	'usercredentials-text' => 'Ніжэй пададзеныя пацьверджаныя пасьведчаньні выбранага рахунку ўдзельніка.',
	'usercredentials-leg-user' => 'Рахунак удзельніка',
	'usercredentials-leg-areas' => 'Асноўныя вобласьці інтарэсаў',
	'usercredentials-leg-person' => 'Асабістыя зьвесткі',
	'usercredentials-leg-other' => 'Іншая інфармацыя',
	'usercredentials-email' => 'Адрас электроннай пошты:',
	'usercredentials-real' => 'Сапраўднае імя:',
	'usercredentials-bio' => 'Біяграфія:',
	'usercredentials-attach' => 'Рэзюмэ:',
	'usercredentials-notes' => 'Дадатковая інфармацыя:',
	'usercredentials-urls' => 'Сьпіс сайтаў:',
	'usercredentials-ip' => 'Арыгінальны ІР-адрас:',
	'usercredentials-member' => 'Правы:',
	'usercredentials-badid' => 'Пасьведчаньні гэтага ўдзельніка ня знойдзеныя.
Праверце, ці правільна напісана імя ўдзельніка.',
	'right-confirmaccount' => 'прагляд [[Special:ConfirmAccounts|запытаў на стварэньне рахункаў]]',
	'right-requestips' => 'прагляд IP-адрасоў з якіх паступалі запыты на стварэньне рахункаў',
	'right-lookupcredentials' => 'прагляд [[Special:UserCredentials|пасьведчаньняў ўдзельнікаў]]',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'requestaccount' => 'Заявка за сметка',
	'requestaccount-text' => "'''За заявяване на потребителска сметка е необходимо да се попълни и изпрати следният формуляр'''.

Преди да бъде направена заявка е необходимо да се уверите, че сте прочели страницата [[{{MediaWiki:Requestaccount-page}}|Условия за ползване]].

След като сметката бъде одобрена, ще получите оповестяващо съобщение на посочената електронна поща, че сметката може да бъде използвана за влизане чрез [[Special:UserLogin]].",
	'requestaccount-page' => '{{ns:project}}:Условия за ползване',
	'requestaccount-dup' => "'''Забележка: Вече сте влезли с регистрирана потребителска сметка.'''",
	'requestaccount-leg-user' => 'Потребителска сметка',
	'requestaccount-leg-areas' => 'Основни интереси',
	'requestaccount-leg-person' => 'Лична информация',
	'requestaccount-leg-other' => 'Друга информация',
	'requestaccount-leg-tos' => 'Условия за ползване',
	'requestaccount-acc-text' => 'След като заявката бъде обработена, на посочения адрес за електронна поща ще бъде изпратено съобщение за потвърждние. Необходимо е да се последва включената в него препратка. След създаване на потребителската сметка, на същия адрес ще бъде изпратена и временна парола за влизане.',
	'requestaccount-areas-text' => 'Сред тематичните области по-долу изберете тези, в които имате компетенции или желание да допринасяте най-много.',
	'requestaccount-ext-text' => 'Следната информация се счита за поверителна и не се публикува; тя ще бъде използвана само за тази заявка.
Препоръчително е да посочите контакти, напр. телефонен номер или друга информация, която ще помогне удостоверяване на самоличността.',
	'requestaccount-bio-text' => 'Въведената биография ще бъде съхранена като основно съдържание на потребителската ви страница.
Желателно е да включите препоръки.
Уверете се, че публикуването на такава информация не ви притеснява.
Можете да промените името си по-късно чрез [[Special:Preferences]].',
	'requestaccount-real' => 'Име и фамилия:',
	'requestaccount-same' => '(съвпада с името)',
	'requestaccount-email' => 'Електронна поща:',
	'requestaccount-reqtype' => 'Позиция:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'редактор',
	'requestaccount-bio' => 'Лична биография:',
	'requestaccount-attach' => 'Резюме или автобиография (по избор):',
	'requestaccount-notes' => 'Допълнителни бележки:',
	'requestaccount-urls' => 'Списък от уебсайтове (ако има такива, по един на ред):',
	'requestaccount-agree' => 'Моля, потвърдете, че истинското ви име е изписано правилно и сте съгласни с Условията за ползване.',
	'requestaccount-inuse' => 'За това потребителско име вече чака заявка за създаване на сметка.',
	'requestaccount-tooshort' => 'Необходимо е биографията да съдържа поне $1 думи.',
	'requestaccount-emaildup' => 'Посоченият адрес за електронна поща е използвам при друга изчакваща заявка за потребителска сметка.',
	'requestaccount-exts' => 'Не е разрешено прикачането на файлове с този формат.',
	'requestaccount-resub' => 'От съображения за сигурност е необходимо да изберете повторно своето CV/резюме.
Ако полето бъде оставено празно, в заявката ви няма да бъде включено резюме.',
	'requestaccount-tos' => 'Декларирам, че прочетох и се съгласявам с [[{{MediaWiki:Requestaccount-page}}|Условията за ползване]] на {{SITENAME}}.
Името, което попълних във формуляра, е моето истинско име и фамилия.',
	'requestaccount-submit' => 'Изпращане на заявката',
	'requestaccount-sent' => 'Вашата заявка за потребителска сметка е изпратена успешно и чака да бъде разгледана.
На вашия адрес за е-поща беше изпратено писмо за потвърждение.',
	'request-account-econf' => 'Адресът на електронната ви поща беше потвърден и ще бъде отбелязан като такъв в заявката ви за потребителска сметка.',
	'requestaccount-email-subj' => '{{SITENAME}}: Потвърждение на адрес за е-поща',
	'requestaccount-email-body' => 'Някой, вероятно вие, от IP-адрес $1, е изпратил заявка за потребителска сметка „$2“ в {{SITENAME}}, като е посочил този адрес за електронна поща.

За да потвърдите, че сметката в {{SITENAME}} и настоящият пощенски адрес са ваши, заредете долната препратка в браузъра си:

$3

Ако заявката ви бъде одобрена и сметката - създадена, ще получите парола по електронна поща. Ако заявката е била направена от някой друг, не следвайте тази препратка. Кодът за потвърждение ще загуби валидност след $4.',
	'requestaccount-email-subj-admin' => 'Заявка за сметка в {{SITENAME}}',
	'requestaccount-email-body-admin' => '„$1“ отправи заявка за създаване на потребителска сметка, която очаква потвърждение.
Посоченият адрес за електронна поща беше потвърден. Можете да потвърдите заявката тук „$2“.',
	'acct_request_throttle_hit' => 'Вече сте направили {{PLURAL:$1|една заявка за потребителска сметка|$1 заявки за потребителски сметки}}. Не можете да правите повече заявки.',
	'requestaccount-loginnotice' => "За да получите потребителска сметка, необходимо е да '''[[Special:RequestAccount|изпратите заявка]]'''.",
	'confirmaccounts' => 'Одобряване на заявките за потребителски сметки',
	'confirmedit-desc' => 'Предоставя на бюрократите възможността да потвърждават заявките за регистрация на потребителски сметки.',
	'confirmaccount-list' => 'Следва списък от заявките за потребителски сметки, които очакват одобрение.
Одобрените сметки ще бъдат създадени и премахнати от списъка. Отхвърлените сметки просто ще бъдат премахнати.',
	'confirmaccount-list2' => 'Следва списък от наскоро отхвърлените заявки за сметки, които могат да бъдат автоматично изтрити след изтичане на няколко дни от отказа. Заявка от този списък все още може да бъде одобрена, но е желателно преди това да се посъветвате с администратора, който я е отхвърлил.',
	'confirmaccount-list3' => 'По-долу е посочен списък с изтекли заявки за сметки, които могат автоматично да бъдат изтрити след няколко дни.
Те все още могат да се потвърдят и да се създадат сметки.',
	'confirmaccount-none-o' => 'В момента списъкът не съдържа отворени изчакващи заявки за сметки.',
	'confirmaccount-none-h' => 'В момента списъкът не съдържа задържани изчакващи заявки за сметки.',
	'confirmaccount-none-r' => 'Понастоящем в списъка няма наскоро отхвърлени заявки за сметки.',
	'confirmaccount-none-e' => 'В момента списъкът не съдържа изтекли заявки за сметки.',
	'confirmaccount-real-q' => 'Име',
	'confirmaccount-email-q' => 'Електронна поща',
	'confirmaccount-bio-q' => 'Биография',
	'confirmaccount-showopen' => 'отворени заявки',
	'confirmaccount-showrej' => 'отказани заявки',
	'confirmaccount-showheld' => 'Преглед на списъка със задържани сметки',
	'confirmaccount-showexp' => 'изтекли заявки',
	'confirmaccount-review' => 'Преглеждане',
	'confirmaccount-all' => '(показване на всички опашки)',
	'confirmaccount-type' => 'Избрана опашка:',
	'confirmaccount-type-0' => 'перспективни автори',
	'confirmaccount-type-1' => 'перспективни редактори',
	'confirmaccount-q-open' => 'отворени заявки',
	'confirmaccount-q-held' => 'задържани заявки',
	'confirmaccount-q-rej' => 'наскоро отхвърлени заявки',
	'confirmaccount-q-stale' => 'изтекли заявки',
	'confirmaccount-badid' => 'Няма чакаща заявка, съотвестваща на предоставения номер.
Възможно е вече да е била обработена.',
	'confirmaccount-leg-user' => 'Потребителска сметка',
	'confirmaccount-leg-areas' => 'Основни интереси',
	'confirmaccount-leg-person' => 'Лична информация',
	'confirmaccount-leg-other' => 'Друга информация',
	'confirmaccount-name' => 'Потребителско име',
	'confirmaccount-real' => 'Име:',
	'confirmaccount-email' => 'Електронна поща:',
	'confirmaccount-reqtype' => 'Позиция:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-pos-1' => 'редактор',
	'confirmaccount-bio' => 'Биография:',
	'confirmaccount-attach' => 'Резюме/Автобиография:',
	'confirmaccount-notes' => 'Допълнителни бележки:',
	'confirmaccount-urls' => 'Списък с уебсайтове:',
	'confirmaccount-confirm' => 'Изберете да одобрите, отхвърлите или задържите тази заявка:',
	'confirmaccount-reject' => '(отказана от [[Потребител:$1|$1]] на $2)',
	'confirmaccount-rational' => 'Обосновка към кандидата:',
	'confirmaccount-noreason' => '(няма)',
	'confirmaccount-autorej' => '(тази заявка автоматично беше отхвърлена заради неактивност)',
	'confirmaccount-held' => '(отбелязана "за изчакване" от [[Потребител:$1|$1]] на $2)',
	'confirmaccount-create' => 'Приемане (създаване на сметката)',
	'confirmaccount-deny' => 'Отказване (премахване от списъка)',
	'confirmaccount-hold' => 'Задържане',
	'confirmaccount-spam' => 'Спам (без изпращане на писмо)',
	'confirmaccount-reason' => 'Коментар (ще бъде включен в електронното писмо):',
	'confirmaccount-ip' => 'IP адрес:',
	'confirmaccount-submit' => 'Потвърждаване',
	'confirmaccount-needreason' => 'Необходимо е да се посочи причина в полето по-долу.',
	'confirmaccount-canthold' => 'Тази заявка вече е била задържана или изтрита.',
	'confirmaccount-acc' => 'Заявката за потребителска сметка е одобрена, създадена е новата сметка [[User:$1|$1]].',
	'confirmaccount-rej' => 'Заявката за потребителска сметка е отхвърлена.',
	'confirmaccount-viewing' => '(в момента се преглежда от [[User:$1|$1]])',
	'confirmaccount-summary' => 'Създаване на потребителска страница с биографията на новия потребител.',
	'confirmaccount-welc' => "'''Добре дошли в ''{{SITENAME}}''!'''
Надяваме се, че ще допринасяте много и качествено.
Вероятно бихте искали да прочетете [[{{MediaWiki:Helppage}}|помощните страници]].
Още веднъж добре дошли и приятни забавления!",
	'confirmaccount-wsum' => 'Здравейте!',
	'confirmaccount-email-subj' => 'Заявка за сметка в {{SITENAME}}',
	'confirmaccount-email-body' => 'Вашата заявка за потребителска сметка на {{SITENAME}} е одобрена.

Потребителско име: $1

Парола: $2

От съображения за сигурност, при първото си влизане в системата трябва да промените паролата си. За влизане в системата, използвайте {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Заявката за създаване на потребителска сметка в {{SITENAME}} беше одобрена.

Потребителско име: $1

Парола: $2

$3

От съображения за сигурност е препоръчително паролата да бъде сменена след първото влизане. За влизане използвайте следната препратка - {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Заявката за създаване на потребителска сметка „$1“ в {{SITENAME}} беше отказана.

Съществуват няколко възможни причини за това. Възможно е формулярът да не е бил попълнен коректно, полетата да не съдържат изчерпателна информация или въведените данни да са в конфликт с някое от правилата и политиката на сайта. На сайта има повече информация за политиката за създаване на потребителски сметки.',
	'confirmaccount-email-body4' => 'Заявката за създаване на потребителска сметка „$1“ в {{SITENAME}} не беше одобрена.

$2

На сайта може да бъде намерена повече информация за политиката за създаване на потребителски сметки.',
	'confirmaccount-email-body5' => 'Преди заявката за създаване на потребителска сметка "$1" в {{SITENAME}} да бъде приета е необходимо да се предостави още допълнителна информация.

$2

На сайта може да бъде намерена повече информация за политиката за създаване на потребителски сметки.',
	'usercredentials' => 'Препоръки за потребители',
	'usercredentials-leg' => 'Преглед на потвърдените препоръки за потребител',
	'usercredentials-user' => 'Потребителско име:',
	'usercredentials-text' => 'По-долу са показани потвърдените препоръки за избраната потребителска сметка.',
	'usercredentials-leg-user' => 'Потребителска сметка',
	'usercredentials-leg-areas' => 'Основни интереси',
	'usercredentials-leg-person' => 'Лична информация',
	'usercredentials-leg-other' => 'Друга информация',
	'usercredentials-email' => 'Електронна поща:',
	'usercredentials-real' => 'Име и фамилия:',
	'usercredentials-bio' => 'Биография:',
	'usercredentials-attach' => 'Резюме/Автобиография:',
	'usercredentials-notes' => 'Допълнителни бележки:',
	'usercredentials-urls' => 'Списък от уебсайтове:',
	'usercredentials-ip' => 'Оригинален IP адрес:',
	'usercredentials-member' => 'Права:',
	'usercredentials-badid' => 'Не са открити препоръки за този потребител. Проверете дали името е изписано правилно.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'requestaccount' => 'অ্যাকাউন্ট অনুরোধ',
	'requestaccount-leg-user' => 'ব্যবহারকারী অ্যাকাউন্ট',
	'requestaccount-leg-areas' => 'আগ্রহের মূল ক্ষেত্র',
	'requestaccount-leg-person' => 'ব্যক্তিগত তথ্য',
	'requestaccount-leg-other' => 'অন্যান্য তথ্য',
	'requestaccount-real' => 'প্রকৃত নাম:',
	'requestaccount-same' => '(প্রকৃত নামের মত)',
	'requestaccount-email' => 'ইমেইল ঠিকানা:',
	'requestaccount-reqtype' => 'পদ:',
	'requestaccount-level-0' => 'লেখক',
	'requestaccount-level-1' => 'সম্পাদক',
	'requestaccount-bio' => 'ব্যক্তিগত জীবনী:',
	'requestaccount-attach' => 'রেজুমে বা সিভি (আবশ্যকীয় নয়):',
	'requestaccount-notes' => 'অতিরিক্ত মন্তব্য:',
	'requestaccount-urls' => 'ওয়েবসাইটের তালিকা, যদি থাকে (নতুন লাইন দিয়ে পৃথক করুন):',
	'requestaccount-agree' => 'আপনি যে প্রকৃত নাম ব্যবহার করেছেন এবং আমাদের সেবার শর্তের সাথে একমত হয়েছেন, তা নিশ্চিত করতে হবে।',
	'requestaccount-inuse' => 'এই ব্যবহারকারী নামটি ইতিমধ্যেই একটি অপেক্ষারত অ্যাকাউন্ট অনুরোধে ব্যবহৃত হচ্ছে।',
	'requestaccount-tooshort' => 'আপনার জীবনী কমপক্ষে $1 {{PLURAL:$1|শব্দ|শব্দ}} দীর্ঘ হতে হবে।',
	'requestaccount-emaildup' => 'আরেকটি অপেক্ষারত অ্যাকাউন্ট অনুরোধে একই ইমেইল ঠিকানা ব্যবহার করা হয়েছে।',
	'requestaccount-exts' => 'সংযুক্ত ফাইলের ধরন অনুমোদিত নয়।',
	'requestaccount-submit' => 'অ্যাকাউন্ট অনুরোধ করুন',
	'requestaccount-email-subj-admin' => '{{SITENAME}}-এ অ্যাকাউন্ট অনুরোধ',
	'confirmaccounts' => 'অ্যাকাউন্ট অনুরোধ নিশ্চিত',
	'confirmaccount-real-q' => 'নাম',
	'confirmaccount-email-q' => 'ইমেইল',
	'confirmaccount-bio-q' => 'জীবনী',
	'confirmaccount-showopen' => 'অনুরোধ খোলা',
	'confirmaccount-showrej' => 'অনুরোধ পরিত্যক্ত হয়েছে',
	'confirmaccount-showexp' => 'অনুরোধ মেয়াদোত্তীর্ণ হয়ে গেছে',
	'confirmaccount-all' => '(সারিতে সব দেখাও)',
	'confirmaccount-name' => 'ব্যবহারকারী নাম',
	'confirmaccount-real' => 'নাম:',
	'confirmaccount-email' => 'ইমেইল:',
	'confirmaccount-reqtype' => 'পদ:',
	'confirmaccount-pos-0' => 'লেখক',
	'confirmaccount-pos-1' => 'সম্পাদক',
	'confirmaccount-bio' => 'জীবনী:',
	'confirmaccount-attach' => 'রেজুমে/সিভি:',
	'confirmaccount-notes' => 'অতিরিক্ত মন্তব্য:',
	'confirmaccount-urls' => 'ওয়েবসাইটের তালিকা:',
	'confirmaccount-none-p' => '(দেয়া হয়নি)',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'requestaccount' => 'Goulenn ur gont implijer',
	'requestaccount-page' => '{{ns:project}}: Amplegadoù implijout',
	'requestaccount-dup' => "'''Notenn : Kevreet oc'h dija gant ur gont marilhet.'''",
	'requestaccount-leg-user' => 'Kont implijer',
	'requestaccount-leg-areas' => 'Diduadennoù pennañ',
	'requestaccount-leg-person' => 'Titouroù hiniennel',
	'requestaccount-leg-other' => 'Titouroù all',
	'requestaccount-leg-tos' => 'Divizoù servij',
	'requestaccount-real' => 'Anv gwir :',
	'requestaccount-same' => '(heñvel ou zh ar gwir anv)',
	'requestaccount-email' => "Chomlec'h postel :",
	'requestaccount-reqtype' => "Lec'hiadur :",
	'requestaccount-level-0' => 'aozer',
	'requestaccount-level-1' => 'skridaozer',
	'requestaccount-bio' => 'Buhezskrid personel :',
	'requestaccount-attach' => 'CV (diret) :',
	'requestaccount-notes' => 'Notennoù ouzhpenn :',
	'requestaccount-urls' => "Roll lec'hiennoù web, dispartiet gant lammoù-linenn :",
	'requestaccount-inuse' => "Implijet eo an anv implijer en ur goulenn kont n'eo ket bet respontet c'hoazh.",
	'requestaccount-tooshort' => 'Ho puhezskrid a rank bezañ ennañ $1 {{PLURAL:$1|ger|ger}} da nebeutañ.',
	'requestaccount-exts' => "Ar seurt restr stag n'eo ket aotreet.",
	'requestaccount-submit' => 'Goulenn ur gont implijer',
	'request-account-econf' => "Kadarnaet eo bet ho chomlec'h postel ha meneget e vo evel m'emañ en ho koulenn kont.",
	'requestaccount-email-subj' => "Gwiriekadur chomlec'h ar postel evit {{SITENAME}}",
	'requestaccount-email-subj-admin' => 'Goulenn kont evit {{SITENAME}}',
	'requestaccount-email-body-admin' => "« $1 » en deus goulennet ur gont ha zo o c'hortoz ar c'hadarnadur.

Kadarnaet eo bet ar chomlec'h postel. Gallout a rit kadarnaat ar goulenn amañ « $2 ».",
	'acct_request_throttle_hit' => "Digarez, met goulennet hoc'h eus {{PLURAL:$1|1 gont|$1 kont}} dija.
Ne c'hallit ket ober goulennoù all.",
	'requestaccount-loginnotice' => "Evit kaout ur gont implijer e rankit '''[[Special:RequestAccount|goulenn unan]]'''.",
	'confirmaccounts' => 'Goulenn gwiriañ kontoù',
	'confirmaccount-real-q' => 'Anv',
	'confirmaccount-email-q' => 'Postel',
	'confirmaccount-bio-q' => 'Levrlennadur',
	'confirmaccount-showopen' => 'rekedoù digor',
	'confirmaccount-showrej' => 'rekedoù distaolet',
	'confirmaccount-showheld' => "goulennoù dalc'het",
	'confirmaccount-showexp' => 'Rekedoù tremenet',
	'confirmaccount-review' => 'Adwelet',
	'confirmaccount-all' => '(Gwelet an holl listennoù gortoz)',
	'confirmaccount-type' => 'Listenn gortoz :',
	'confirmaccount-q-open' => 'rekedoù digor',
	'confirmaccount-q-held' => "goulennoù dalc'het",
	'confirmaccount-q-rej' => 'goulennoù distaolet nevez zo',
	'confirmaccount-q-stale' => 'Rekedoù tremenet',
	'confirmaccount-leg-user' => 'Kont implijer',
	'confirmaccount-leg-areas' => 'Diduadennoù pennañ',
	'confirmaccount-leg-person' => 'Titouroù personel',
	'confirmaccount-leg-other' => 'Titouroù all',
	'confirmaccount-name' => 'Anv implijer',
	'confirmaccount-real' => 'Anv :',
	'confirmaccount-email' => 'Postel :',
	'confirmaccount-reqtype' => "Lec'hiadur :",
	'confirmaccount-pos-0' => 'aozer',
	'confirmaccount-pos-1' => 'skridaozer',
	'confirmaccount-bio' => 'Buhezskrid :',
	'confirmaccount-attach' => 'CV :',
	'confirmaccount-notes' => 'Notennoù ouzhpenn :',
	'confirmaccount-urls' => "Roll lec'hiennoù web :",
	'confirmaccount-none-p' => "(n'eo ket pourchaset)",
	'confirmaccount-confirm' => "Implijit ar boutonioù amañ dindan da zegemer, nach pe zerc'hel ar goulenn-mañ :",
	'confirmaccount-econf' => '(kadarnaet)',
	'confirmaccount-reject' => "(distaolet gant [[User:$1|$1]] d'an $2)",
	'confirmaccount-noreason' => '(hini ebet)',
	'confirmaccount-autorej' => "(distaolet eo bet ar goulenn-mañ ent emgefre abalamour d'an dioberiantiz)",
	'confirmaccount-held' => '(merket "miret" gant [[User:$1|$1]] war $2)',
	'confirmaccount-create' => 'Asantiñ (krouiñ ar gont)',
	'confirmaccount-deny' => 'Disteurel (lemel eus ar roll)',
	'confirmaccount-hold' => 'Mirout',
	'confirmaccount-spam' => 'Strob (na gasit ket a bostel)',
	'confirmaccount-reason' => 'Evezhiadenn (ebarzhiet e vo er postel) :',
	'confirmaccount-ip' => "Chomlec'h IP :",
	'confirmaccount-submit' => 'Kadarnaat',
	'confirmaccount-needreason' => "Ret eo deoc'h pourchas un abeg er voest amañ dindan.",
	'confirmaccount-acc' => 'Kardarnaet eo bet ar goulenn kont ;
krouet eo bet ar gont implijer nevez [[User:$1|$1]].',
	'confirmaccount-rej' => 'Distaolet eo bet ar goulenn kont.',
	'confirmaccount-viewing' => '(gwelet gant [[User:$1|$1]] evit bremañ)',
	'confirmaccount-summary' => 'Krouadenn ar bajenn implijer  gant e vuhezskrid.',
	'confirmaccount-wsum' => 'Degemer mat !',
	'confirmaccount-email-subj' => 'Goulenn ur gont war {{SITENAME}}',
	'confirmaccount-email-body' => "Ho koulenn kont zo bet aprouet e {{SITENAME}}.

Anv ar gont : $1

Ger-tremen : $2

Abalamour d'ar surentez e tleot cheñch ho ker-tremen pa gevreot evit ar wech kentañ.
Evit kevreañ, kit da {{fullurl:Special:UserLogin}}, mar plij.",
	'confirmaccount-email-body2' => "Ho koulenn kont zo bet aprouet e {{SITENAME}}.

Anv ar gont : $1

Ger-tremen : $2

$3

Abalamour d'ar surentez e tleot cheñch ho ker-tremen ar wech kentañ ma kevreot.
Evit kevreañ, kit da {{fullurl:Special:UserLogin}}, mar plij.",
	'usercredentials' => 'Daveennoù an implijer',
	'usercredentials-user' => 'Anv implijer :',
	'usercredentials-text' => 'Amañ emañ daveennoù gwiriekaet kont an implijer diuzet.',
	'usercredentials-leg-user' => 'Kont implijer',
	'usercredentials-leg-areas' => 'Diduadenn pennañ :',
	'usercredentials-leg-person' => 'Titouroù hiniennel',
	'usercredentials-leg-other' => 'Titouroù all',
	'usercredentials-email' => 'Postel :',
	'usercredentials-real' => 'Gwir anv :',
	'usercredentials-bio' => 'Buhezskrid :',
	'usercredentials-attach' => 'CV :',
	'usercredentials-notes' => 'Notennoù ouzhpenn :',
	'usercredentials-urls' => "Listenn al lec'hiennoù internet :",
	'usercredentials-ip' => "Chomlec'h IP orin :",
	'usercredentials-member' => 'Gwirioù :',
	'usercredentials-badid' => "N'eus ket bet kavet daveennoù evit an implijer-mañ.
Gwiriit ha skrivet-mat eo an anv.",
	'right-confirmaccount' => "Gwelet [[Special:ConfirmAccounts|lostad ar c'hontoù goulennet]]",
	'right-lookupcredentials' => 'Gwelet [[Special:UserCredentials|daveennoù an implijerien]]',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'requestaccount' => 'Zahtjev za račun',
	'requestaccount-page' => '{{ns:project}}:Uslovi korištenja',
	'requestaccount-dup' => "'''Napomena: Već ste prijavljeni sa registrovanim računom.'''",
	'requestaccount-leg-user' => 'Korisnički račun',
	'requestaccount-leg-areas' => 'Glavna područja interesa',
	'requestaccount-leg-person' => 'Lične informacije',
	'requestaccount-leg-other' => 'Ostale informacije',
	'requestaccount-leg-tos' => 'Uslovi usluge',
	'requestaccount-real' => 'Pravo ime:',
	'requestaccount-same' => '(isto kao i pravo ime)',
	'requestaccount-email' => 'E-mail adresa:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'uređivač',
	'requestaccount-bio' => 'Lična biografija:',
	'requestaccount-attach' => 'Biografija (opcionalno):',
	'requestaccount-notes' => 'Dodatne napomene:',
	'requestaccount-urls' => 'Spisak web stranica, ako ih ima (odvojiti sa novim redovima):',
	'requestaccount-agree' => 'Morate potvrditi da je ovo Vaše pravo ime i da prihvatate naša Pravila usluga.',
	'requestaccount-inuse' => 'Korisničko ime je već u upotrebi u zahtjevu za račun.',
	'requestaccount-tooshort' => 'Vaša biografija mora biti duga najmanje $1 {{PLURAL:$1|riječ|riječi}}.',
	'requestaccount-exts' => 'Vrsta datoteke u privitku nije dopuštena.',
	'requestaccount-submit' => 'Zahtjevaj račun',
	'requestaccount-sent' => 'Vaš zahtjev za račun je uspješno poslan i sada očekuje provjeru.
Mail za potvrdu je poslan na Vašu e-mail adresu.',
	'request-account-econf' => 'Vaša e-mail adresa je potvrđena i bit će prikazana kako je navedeno u Vašem zahjevu za račun.',
	'requestaccount-email-subj' => '{{SITENAME}} e-mail adresa potvrde',
	'requestaccount-email-subj-admin' => 'Zahtjev za račun na {{SITENAME}}',
	'acct_request_throttle_hit' => 'Žao nam je, već ste zahtjevali otvaranje {{PLURAL:$1|1 računa|$1 računa}}.
Ne možete podnositi više zahtjeva.',
	'requestaccount-loginnotice' => "Da biste korisnički račun, morate '''[[Special:RequestAccount|zahtijevati jedan]]'''.",
	'confirmaccounts' => 'Potvrdi zahtjeve za račun',
	'confirmedit-desc' => 'Daje mogućnost birokratima da potvrde zahtjeve za računima',
	'confirmaccount-list' => 'Ispod je spisak zahtjeva za računima koji čekaju na odobravanje.
Jednom podnesen zahtjev koji se odobri ili odbije će se ukloniti sa ovog spiska.',
	'confirmaccount-none-o' => 'Trenutno nema otvorenih zahtjeva na račun na čekanju na ovom spisku.',
	'confirmaccount-real-q' => 'Ime',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografija',
	'confirmaccount-showopen' => 'otvoreni zahtjevi',
	'confirmaccount-showrej' => 'odbijeni zahtjevi',
	'confirmaccount-showexp' => 'zahtijevi istekli',
	'confirmaccount-all' => '(pokaži sve na čekanju)',
	'confirmaccount-type' => 'Red:',
	'confirmaccount-leg-user' => 'Korisnički račun',
	'confirmaccount-leg-areas' => 'Glavne oblasti interesovanja',
	'confirmaccount-leg-person' => 'Lični podaci',
	'confirmaccount-leg-other' => 'Ostale informacije',
	'confirmaccount-name' => 'Korisničko ime',
	'confirmaccount-real' => 'Ime:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Pozicija:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'uređivač',
	'confirmaccount-bio' => 'Biografija:',
	'confirmaccount-attach' => 'Biografija:',
	'confirmaccount-notes' => 'Dodatne bilješke:',
	'confirmaccount-urls' => 'Spisak web sajtova:',
	'confirmaccount-none-p' => '(nije navedeno)',
	'confirmaccount-econf' => '(potvrđen)',
	'confirmaccount-noreason' => '(ništa)',
	'confirmaccount-create' => 'Prihvati (napravi račun)',
	'confirmaccount-deny' => 'Odbij (skini sa spiska)',
	'confirmaccount-reason' => 'Komentar (bit će uključen u e-mail):',
	'confirmaccount-ip' => 'IP adresa:',
	'confirmaccount-submit' => 'Potvrdi',
	'confirmaccount-summary' => 'Pravljenje korisničke stranice sa biografijom novog korisnika.',
	'confirmaccount-wsum' => 'Dobrodošli!',
	'confirmaccount-email-subj' => 'Zahtjev za račun na {{SITENAME}}',
	'confirmaccount-email-body2' => 'Vaš zahtjev za račun na {{SITENAME}} je odobren.

Naziv računa: $1

Šifra: $2

$3

Iz sigurnosnih razloga potrebno je da promijenite šifru pri prvoj prijavi.
Da bi ste se prijaviti, molimo idite na {{fullurl:Special:UserLogin}}.',
	'usercredentials-user' => 'Korisničko ime:',
	'usercredentials-leg-user' => 'Korisnički račun',
	'usercredentials-leg-person' => 'Lične informacije',
	'usercredentials-leg-other' => 'Ostale informacije',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Pravo ime:',
	'usercredentials-bio' => 'Biografija:',
	'usercredentials-attach' => 'Biografija:',
	'usercredentials-member' => 'Prava:',
);

/** Catalan (Català)
 * @author Loupeter
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'requestaccount' => 'Sol·licita un compte',
	'requestaccount-leg-user' => "Compte de l'usuari",
	'requestaccount-leg-person' => 'Informació personal',
	'requestaccount-leg-other' => 'Altres informacions',
	'requestaccount-real' => 'Nom real:',
	'requestaccount-same' => '(el mateix que el nom real)',
	'requestaccount-email' => 'Adreça de correu electrònic:',
	'requestaccount-reqtype' => 'Posició:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografia personal:',
	'requestaccount-notes' => 'Notes addicionals:',
	'confirmaccount-real-q' => 'Nom',
	'confirmaccount-email-q' => 'Correu electrònic',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-type' => 'Coa:',
	'confirmaccount-leg-user' => "Compte d'usuari",
	'confirmaccount-leg-areas' => "Àrees d'interès principals",
	'confirmaccount-leg-person' => 'Informació personal',
	'confirmaccount-leg-other' => 'Altres informacions',
	'confirmaccount-name' => "Nom d'usuari",
	'confirmaccount-real' => 'Nom:',
	'confirmaccount-email' => 'Correu electrònic:',
	'confirmaccount-reqtype' => 'Posició:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografia:',
	'confirmaccount-notes' => 'Notes addicionals:',
	'confirmaccount-urls' => 'Llista de llocs web:',
	'confirmaccount-none-p' => '(no proporcionat)',
	'confirmaccount-econf' => '(confirmat)',
	'confirmaccount-noreason' => '(cap)',
	'confirmaccount-ip' => 'Adreça IP:',
	'confirmaccount-submit' => 'Confirma',
	'confirmaccount-wsum' => 'Benvinguts!',
	'usercredentials-leg-person' => 'Informació personal',
	'usercredentials-leg-other' => 'Altres informacions',
	'usercredentials-email' => 'Correu electrònic:',
	'usercredentials-real' => 'Nom real:',
	'usercredentials-bio' => 'Biografia:',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'requestaccount' => 'Vyžádat účet',
	'requestaccount-page' => '{{ns:project}}:Podmínky použití',
	'requestaccount-dup' => "'''Poznámka: Už jste přihlášen jako registrovaný uživatel.'''",
	'requestaccount-leg-user' => 'Uživatelský účet',
	'requestaccount-leg-areas' => 'Hlavní oblasti zájmu',
	'requestaccount-leg-person' => 'Osobní informace',
	'requestaccount-leg-other' => 'Další informace',
	'requestaccount-acc-text' => 'Na Vaši e-mailovou adresu bude po odeslání žádosti zaslána potvrzující zpráva. Prosím, reagujte na ni kliknutím na odkaz v ní. Poté Vám bude zasláno Vaše heslo.',
	'requestaccount-areas-text' => 'Níže zvolte tématické oblasti, ve kterých jste formálně expertem nebo by jste v nich rádi vykonávali vaši práci.',
	'requestaccount-bio-text' => 'Vaše bibliografie bude prvotním obsahem vaši uživatelské stránky. Pokuste se uvést všechny reference. Zvažte, zda jste ochotni zveřejnit tyto informace. Jméno si můžete změnit ve [[Special:Preferences|svém nastavení]].',
	'requestaccount-real' => 'Skutečné jméno:',
	'requestaccount-same' => '(stejné jako skutečné jméno)',
	'requestaccount-email' => 'E-mailová adresa:',
	'requestaccount-reqtype' => 'Pozice:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Osobní biografie:',
	'requestaccount-attach' => 'Resumé nebo CV (nepovinné):',
	'requestaccount-notes' => 'Další poznámky:',
	'requestaccount-urls' => 'Seznam webových stránek, pokud nějaké jsou (jedna na každý řádek):',
	'requestaccount-agree' => 'Musíte potvrdit, že vaše skutečné jméno je správné a že souhlasíte s našimi Podmínkami použití.',
	'requestaccount-inuse' => 'Uživatelské jméno už bylo vyžádané v probíhající žádosti o účet.',
	'requestaccount-tooshort' => 'Délka vaší biografie musí být alespoň $1 {{PLURAL:$1|slovo|slova|slov}}.',
	'requestaccount-emaildup' => 'Jiný účet čekající na schválení používá stejnou e-mailovou adresu.',
	'requestaccount-exts' => 'Tento typ přílohy není povolen.',
	'requestaccount-resub' => 'Váš soubor s CV/resumé je potřeba z bezpečnostních důvodů znovu vybrat. Nechejte pole prázdné, pokud jste se rozhodli žádný nepřiložit.',
	'requestaccount-tos' => 'Přečetl jsem a souhlasím, že budu dodržovat [[{{MediaWiki:Requestaccount-page}}|Podmínky používání služby]] {{GRAMMAR:genitiv|{{SITENAME}}}}. Jméno, které jsem uvedl jako „Skutečné jméno“ je opravdu moje občanské jméno.',
	'requestaccount-submit' => 'Požádat o účet',
	'requestaccount-sent' => 'Vaše žádost o účet byla úspěšně odeslána a nyní se čeká na její zkontrolování.',
	'request-account-econf' => 'Vaše e-mailová adresa byla potvrzena a v tomto tvaru se uvede ve vaší žádosti o účet.',
	'requestaccount-email-subj' => '{{SITENAME}}: Potvrzení e-mailové adresy',
	'requestaccount-email-body' => 'Někdo, pravděpodobně Vy z IP adresy $1, si na {{GRAMMAR:lokál|{{SITENAME}}}} zaregistroval účet s názvem „$2“ a s touto e-mailovou adresou.

Pro potvrzení, že tento účet skutečně patří Vám a pro aktivování e-mailových funkcí na {{GRAMMAR:lokál|{{SITENAME}}}}, klikněte na tento odkaz:

$3

Pokud jste to *nebyli* Vy, neklikejte na odkaz. Tento potvrzovací kód vyprší $4.',
	'confirmaccounts' => 'Potvrdit žádosti o účet',
	'confirmedit-desc' => 'Dává byrokratům možnost potvrzovat žádosti o účet',
	'confirmaccount-real-q' => 'Jméno',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showheld' => 'Zobrazit seznam účtů čekajících na schválení',
	'confirmaccount-review' => 'Schválit/Odmítnout',
	'confirmaccount-all' => '(zobrazit všechny fronty)',
	'confirmaccount-type' => 'Zvolená fronta:',
	'confirmaccount-type-0' => 'budoucí autoři',
	'confirmaccount-type-1' => 'budoucí editoři',
	'confirmaccount-q-open' => 'otevřené žádosti',
	'confirmaccount-q-held' => 'pozastavené žádosti',
	'confirmaccount-q-rej' => 'nedávno zamítnuté žádosti',
	'confirmaccount-leg-user' => 'Uživatelský účet',
	'confirmaccount-leg-areas' => 'Hlavní oblasti zájmu',
	'confirmaccount-leg-person' => 'Osobní informace',
	'confirmaccount-leg-other' => 'Další informace',
	'confirmaccount-name' => 'Uživatelské jméno',
	'confirmaccount-real' => 'Jméno:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Pozice:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografie:',
	'confirmaccount-notes' => 'Další poznámky:',
	'confirmaccount-urls' => 'Seznam webových stránek:',
	'confirmaccount-none-p' => '(neposkytnuté)',
	'confirmaccount-confirm' => 'Tlačítky níže můžete přijmout nebo odmítnout tuto žádost.',
	'confirmaccount-econf' => '(potvrzený)',
	'confirmaccount-reject' => '(zamítnul [[User:$1|$1]] $2)',
	'confirmaccount-rational' => 'Zdůvodnění pro uchazeče:',
	'confirmaccount-noreason' => '(žádné)',
	'confirmaccount-held' => '(uživatel [[User:$1|$1]] $2 označil jako „pozastavené“)',
	'confirmaccount-create' => 'Přijmout (vytvořit účet)',
	'confirmaccount-deny' => 'Odmítnout (odstranit žádost)',
	'confirmaccount-hold' => 'Pozastavit',
	'confirmaccount-spam' => 'Spam (neposílat e-mail)',
	'confirmaccount-reason' => 'Komentář (bude součástí e-mailu):',
	'confirmaccount-ip' => 'IP adresa:',
	'confirmaccount-submit' => 'Potvrdit',
	'confirmaccount-wsum' => 'Vítejte!',
	'usercredentials' => 'Osobní údaje uživatele',
	'usercredentials-user' => 'Uživatelské jméno:',
	'usercredentials-leg-user' => 'Uživatelský účet',
	'usercredentials-leg-areas' => 'Hlavní oblasti zájmu',
	'usercredentials-leg-person' => 'Osobní informace',
	'usercredentials-leg-other' => 'Další informace',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Skutečné jméno:',
	'usercredentials-bio' => 'Biografie:',
	'usercredentials-notes' => 'Další poznámky:',
	'usercredentials-urls' => 'Seznam webových stránek:',
	'usercredentials-ip' => 'Původní IP adresa:',
	'usercredentials-member' => 'Práva:',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'requestaccount-real' => 'и́стиньно и́мѧ :',
	'requestaccount-level-0' => 'творь́ць',
	'confirmaccount-pos-0' => 'творь́ць',
	'usercredentials-user' => 'по́льꙃєватєлꙗ и́мѧ :',
	'usercredentials-real' => 'и́стиньно и́мѧ :',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'requestaccount-real' => 'Virkeligt navn:',
	'confirmaccount-real-q' => 'Navn',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name' => 'Brugernavn',
	'confirmaccount-real' => 'Navn:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-noreason' => '(ingen)',
	'confirmaccount-ip' => 'IP-adresse:',
	'confirmaccount-submit' => 'Bekræft',
	'confirmaccount-wsum' => 'Velkommen!',
	'usercredentials-user' => 'Brugernavn:',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Virkeligt navn:',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Leithian
 * @author MF-Warburg
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking
 * @author Revolus
 * @author Rrosenfeld
 * @author Umherirrender
 */
$messages['de'] = array(
	'requestaccount' => 'Benutzerkonto beantragen',
	'requestaccount-text' => "'''Fülle das folgende Formular aus und schick es ab, um ein Benutzerkonto zu beantragen'''. 

Bitte lies zunächst die [[{{MediaWiki:Requestaccount-page}}|Nutzungsbedingungen]], bevor du ein Benutzerkonto beantragst.

Sobald das Konto bestätigt wurde, wirst du per E-Mail benachrichtigt und du kannst dich [[Special:UserLogin|anmelden]].",
	'requestaccount-page' => '{{ns:project}}:Nutzungsbedingungen',
	'requestaccount-dup' => "'''Achtung: Du bist bereits mit einem registrierten Benutzerkonto angemeldet.'''",
	'requestaccount-leg-user' => 'Benutzerkonto',
	'requestaccount-leg-areas' => 'Hauptinteressensgebiete',
	'requestaccount-leg-person' => 'Persönliche Informationen',
	'requestaccount-leg-other' => 'Weitere Informationen',
	'requestaccount-leg-tos' => 'Benutzungsbedingungen',
	'requestaccount-acc-text' => 'An deine E-Mail-Adresse wird nach dem Absenden dieses Formulars eine Bestätigungsmail geschickt.
Bitte reagiere darauf, indem du auf den in dieser Mail enthaltenen Bestätigungs-Link klickst.
Sobald dein Konto angelegt wurde, wird dir dein Passwort per E-Mail zugeschickt.',
	'requestaccount-areas-text' => 'Wähle die Themengebiete aus, in denen du das meiste Fachwissen hast oder wo du am meisten involviert sein wirst.',
	'requestaccount-ext-text' => 'Die folgenden Informationen werden vertraulich behandelt und ausschließlich für diesen Antrag verwendet.
Du kannst Kontakt-Angaben wie eine Telefonnummer machen, um die Bearbeitung deines Antrags zu vereinfachen.',
	'requestaccount-bio-text' => 'Deine Biographie wird als initialer Inhalt deiner Benutzerseite gespeichert.
Versuche alle nötigen Empfehlungen zu erwähnen, aber stelle sicher, dass du die Informationen auch wirklich veröffentlichen möchtest.
Du kannst deinen Namen in [[Special:Preferences|deinen Einstellungen]] ändern.',
	'requestaccount-real' => 'Realname:',
	'requestaccount-same' => '(wie der Realname)',
	'requestaccount-email' => 'E-Mail-Adresse:',
	'requestaccount-reqtype' => 'Position:',
	'requestaccount-level-0' => 'Autor',
	'requestaccount-level-1' => 'Bearbeiter',
	'requestaccount-bio' => 'Persönliche Biographie:',
	'requestaccount-attach' => 'Lebenslauf (optional):',
	'requestaccount-notes' => 'Zusätzliche Angaben:',
	'requestaccount-urls' => 'Liste von Webseiten (durch Zeilenumbrüche getrennt):',
	'requestaccount-agree' => 'Du musst bestätigen, dass Dein Realname korrekt ist und du die Benutzerbedingungen akzeptierst.',
	'requestaccount-inuse' => 'Der Benutzername ist bereits in einem anderen Benutzerantrag in Verwendung.',
	'requestaccount-tooshort' => 'Deine Biographie muss mindestens {{PLURAL:$1|1 Wort|$1 Wörter}} lang sein.',
	'requestaccount-emaildup' => 'Ein weiterer noch nicht erledigter Antrag benutzt die gleiche E-Mail-Adresse.',
	'requestaccount-exts' => 'Der Dateityp des Anhangs ist nicht erlaubt.',
	'requestaccount-resub' => 'Die Datei mit deinem Lebenslauf muss aus Sicherheitsgründen neu ausgewählt werden.
Lasse das Feld leer, wenn du keinen Lebenslauf mehr anfügen möchtest.',
	'requestaccount-tos' => 'Ich habe die [[{{MediaWiki:Requestaccount-page}}|Benutzungsbedingungen]] von {{SITENAME}} gelesen und akzeptiere sie.
Ich bestätige, dass der Name, den ich unter „Realname“ angegeben habe, mein wirklicher Name ist.',
	'requestaccount-submit' => 'Benutzerkonto beantragen',
	'requestaccount-sent' => 'Dein Antrag wurde erfolgreich verschickt und muss nun noch überprüft werden.
Eine Bestätigungs-E-Mail wurde an deine E-Mail-Adresse gesendet.',
	'request-account-econf' => 'Deine E-Mail-Adresse wurde bestätigt und wird nun als solche in deinem Antrag auf ein Benutzerkonto geführt.',
	'requestaccount-email-subj' => '{{SITENAME}} E-Mail-Adressen Prüfung',
	'requestaccount-email-body' => 'Jemand, mit der IP Adresse $1, möglicherweise du, hat bei {{SITENAME}} das Benutzerkonto „$2“ mit deiner E-Mail-Adresse beantragt.

Um zu bestätigen, dass wirklich du dieses Konto bei {{SITENAME}} beantragt hast, öffne bitte folgenden Link in deinem Browser:

$3

Wenn das Benutzerkonto erstellt wurde, bekommst du eine weitere E-Mail mit dem Passwort.

Wenn du das Benutzerkonto *nicht* beantragt hast, öffne den Link bitte nicht!

Dieser Bestätigungscode wird am $5 um $6 Uhr ungültig.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} Benutzerkontenantrag',
	'requestaccount-email-body-admin' => '„$1“ hat ein Benutzerkonto beantragt und wartet auf Bestätigung.
Die E-Mail-Adresse wurde bestätigt. Du kannst den Antrag hier bestätigen: „$2“.',
	'acct_request_throttle_hit' => 'Du hast bereits {{PLURAL:$1|1 Benutzerkonto|$1 Benutzerkonten}} beantragt, du kannst momentan keine weiteren beantragen.',
	'requestaccount-loginnotice' => "Um ein neues Benutzerkonto zu erhalten, musst du es '''[[Special:RequestAccount|beantragen]]'''.",
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|offener, E-Mail bestätigter Benutzerkontenantrag wartet]]|[[Special:ConfirmAccounts|offene, E-Mail bestätigte Benutzerkontenanträge warten]]}} auf Bearbeitung.",
	'confirmaccounts' => 'Benutzerkonto-Anträge bestätigen',
	'confirmedit-desc' => 'Gibt Bürokraten die Möglichkeit, Benutzerkontenanträge zu bestätigen',
	'confirmaccount-maintext' => "'''Diese Seite dient dazu, wartende Benutzerkontenanträge für ''{{SITENAME}}'' zu bearbeiten.'''

Jede Benutzerkonten-Antragsqueue besteht aus drei Unterqueues. Eine für offene Anfrage, eine für Anträge im „abwarten“-Status und eine für kürzlich abgelehnte Anfragen.

Wenn du auf einen Antrag antwortest, überprüfe die Informationen sorgfältig und bestätige die enthaltenen Informationen.
Deine Aktionen werden nichtöffentlich protokolliert. Es wird auch von dir erwartet, die Aktionen anderer zu überprüfen.",
	'confirmaccount-list' => 'Unten findest du eine Liste von noch zu bearbeitenden Benutzerkonto-Anträgen.
Sobald ein Antrag bestätigt oder zurückgewiesen wurde, wird er aus der Liste entfernt.',
	'confirmaccount-list2' => 'Unten ist eine Liste kürzlich zurückgewiesener Anträge, die automatisch gelöscht werden, sobald sie einige Tage alt sind. Sie können noch genehmigt werden, allerdings solltest du zuerst den ablehnenden Administrator kontaktieren.',
	'confirmaccount-list3' => 'Unten ist eine Liste kürzlich zurückgewiesener Anträge, die automatisch gelöscht werden, sobald sie einige Tage alt sind. Sie können noch genehmigt werden.',
	'confirmaccount-text' => "Dies ist ein Antrag auf ein Benutzerkonto bei '''{{SITENAME}}'''.

Prüfe alle unten stehenden Informationen gründlich und bestätige die Informationen wenn möglich.
Bitte beachte, dass du den Zugang bei Bedarf unter einem anderen Benutzernamen anlegen kannst.
Du solltest dies nur nutzen, um Kollisionen mit anderen Namen zu vermeiden.

Wenn du diese Seite verlässt, ohne das Konto zu bestätigen oder abzulehnen, wird der Antrag offen stehen bleiben.",
	'confirmaccount-none-o' => 'Momentan gibt es keine offenen Benutzeranträge auf dieser Liste.',
	'confirmaccount-none-h' => 'Momentan gibt es keine Anträge im „abwarten“-Status auf dieser Liste.',
	'confirmaccount-none-r' => 'Momentan gibt es keine kürzlich abgelehnten Benutzeranträge auf dieser Liste.',
	'confirmaccount-none-e' => 'Momentan gibt es keine abgelaufenen Benutzeranträge auf dieser Liste.',
	'confirmaccount-real-q' => 'Name',
	'confirmaccount-email-q' => 'E-Mail',
	'confirmaccount-bio-q' => 'Biographie',
	'confirmaccount-showopen' => 'offene Anträge',
	'confirmaccount-showrej' => 'zurückgewiesene Anträge',
	'confirmaccount-showheld' => 'Anträge im „abwarten“-Status',
	'confirmaccount-showexp' => 'abgelaufene Anträge',
	'confirmaccount-review' => 'Bestätigen/Ablehnen',
	'confirmaccount-types' => 'Wähle eine Benutzerkontenbestätigungswarteschlange aus den unten stehenden aus:',
	'confirmaccount-all' => '(zeige alle Warteschlangen)',
	'confirmaccount-type' => 'Warteschlange:',
	'confirmaccount-type-0' => 'zukünftige Autoren',
	'confirmaccount-type-1' => 'zukünftige Bearbeiter',
	'confirmaccount-q-open' => 'offene Anträge',
	'confirmaccount-q-held' => 'wartende Anträge',
	'confirmaccount-q-rej' => 'kürzlich abgelehnte Anträge',
	'confirmaccount-q-stale' => 'abgelaufene Anträge',
	'confirmaccount-badid' => 'Momentan gibt es keinen Benutzerantrag zur angegebenen ID. Möglicherweise wurde er bereits bearbeitet.',
	'confirmaccount-leg-user' => 'Benutzerkonto',
	'confirmaccount-leg-areas' => 'Hauptinteressensgebiete',
	'confirmaccount-leg-person' => 'Persönliche Informationen',
	'confirmaccount-leg-other' => 'Weitere Informationen',
	'confirmaccount-name' => 'Benutzername',
	'confirmaccount-real' => 'Name:',
	'confirmaccount-email' => 'E-Mail:',
	'confirmaccount-reqtype' => 'Position:',
	'confirmaccount-pos-0' => 'Autor',
	'confirmaccount-pos-1' => 'Bearbeiter',
	'confirmaccount-bio' => 'Biographie:',
	'confirmaccount-attach' => 'Lebenslauf:',
	'confirmaccount-notes' => 'Zusätzliche Hinweise:',
	'confirmaccount-urls' => 'Liste der Webseiten:',
	'confirmaccount-none-p' => '(Nichts angegeben)',
	'confirmaccount-confirm' => 'Benutze die folgende Auswahl, um den Antrag zu akzeptieren, abzulehnen oder noch zu warten.',
	'confirmaccount-econf' => '(bestätigt)',
	'confirmaccount-reject' => '(abgelehnt durch [[User:$1|$1]] am $2)',
	'confirmaccount-rational' => 'Begründung für den Antragssteller:',
	'confirmaccount-noreason' => '(nichts)',
	'confirmaccount-autorej' => '(dieser Antrag wurde automatisch wegen Inaktivität gestrichen)',
	'confirmaccount-held' => '(markiert als „abwarten“ durch [[User:$1|$1]] am $3 um $4 Uhr)',
	'confirmaccount-create' => 'Bestätigen (Konto anlegen)',
	'confirmaccount-deny' => 'Ablehnen (Antrag löschen)',
	'confirmaccount-hold' => 'Markiert als „abwarten“',
	'confirmaccount-spam' => 'Spam (keine E-Mail verschicken)',
	'confirmaccount-reason' => 'Begründung (wird in die E-Mail an den Antragsteller eingefügt):',
	'confirmaccount-ip' => 'IP-Addresse:',
	'confirmaccount-legend' => 'Bestätigen/Ablehnen des Antrags',
	'confirmaccount-submit' => 'Abschicken',
	'confirmaccount-needreason' => 'Du musst eine Begründung eingeben.',
	'confirmaccount-canthold' => 'Dieser Antrag wurde bereits als „abwarten“ markiert oder gelöscht.',
	'confirmaccount-acc' => 'Benutzerantrag erfolgreich bestätigt; Benutzer [[User:$1|$1]] wurde angelegt.',
	'confirmaccount-rej' => 'Benutzerantrag wurde abgelehnt.',
	'confirmaccount-viewing' => '(wird aktuell angeschaut durch [[User:$1|$1]])',
	'confirmaccount-summary' => 'Erzeuge Benutzerseite mit der Biographie des neuen Benutzers.',
	'confirmaccount-welc' => "'''Willkommen bei ''{{SITENAME}}''!'''
Wir hoffen, dass du viele gute Informationen beisteuerst.
Möglicherweise möchtest Du zunächst die [[{{MediaWiki:Helppage}}|Ersten Schritte]] lesen.
Nochmal: Willkommen und hab' Spaß!",
	'confirmaccount-wsum' => 'Willkommen!',
	'confirmaccount-email-subj' => '{{SITENAME}} Antrag auf Benutzerkonto',
	'confirmaccount-email-body' => 'Dein Antrag auf ein Benutzerkonto bei {{SITENAME}} wurde bestätigt.

Benutzername: $1

Passwort: $2

Aus Sicherheitsgründen solltest du dein Passwort unbedingt beim ersten Anmelden ändern.
Um dich anzumelden besuche bitte die Seite {{fullurl:{{#special:UserLogin}}}}.',
	'confirmaccount-email-body2' => 'Dein Antrag auf ein Benutzerkonto bei {{SITENAME}} wurde bestätigt.

Benutzername: $1

Passwort: $2

$3

Aus Sicherheitsgründen solltest du dein Passwort unbedingt beim ersten Anmelden ändern.
Um dich anzumelden besuche bitte die Seite {{fullurl:{{#special:UserLogin}}}}.',
	'confirmaccount-email-body3' => 'Leider wurde dein Antrag auf ein Benutzerkonto „$1“ 
bei {{SITENAME}} abgelehnt.

Dies kann viele Gründe haben. Möglicherweise hast du das Antragsformular
nicht richtig ausgefüllt, hast nicht genügend Angaben gemacht oder hast
die Anforderungen auf andere Weise nicht erfüllt.

Möglicherweise gibt es auf der Seite Kontaktadressen, an die du dich wenden
kannst, wenn du mehr über die Anforderungen wissen möchtest.',
	'confirmaccount-email-body4' => 'Leider wurde dein Antrag auf ein Benutzerkonto „$1“ 
bei {{SITENAME}} abgelehnt.

$2

Möglicherweise gibt es auf der Seite Kontaktadressen, an die du dich wenden
kannst, wenn du mehr über die Anforderungen wissen möchtest.',
	'confirmaccount-email-body5' => 'Bevor deine Anfrage für das Benutzerkonto „$1“ von {{SITENAME}} akzeptiert werden kann, musst du zusätzliche Informationen übermitteln.

$2

Möglicherweise gibt es auf der Seite Kontaktadressen, an die du dich wenden kannst, wenn du mehr über die Anforderungen wissen möchtest.',
	'usercredentials' => 'Benutzer-Berechtigungsnachweis',
	'usercredentials-leg' => 'Bestätigte Benutzer-Berechtigungsnachweise nachsehen',
	'usercredentials-user' => 'Benutzername:',
	'usercredentials-text' => 'Es folgen die bestätigten Benutzer-Berechtigungsnachweise für das gewählte Benutzerkonto.',
	'usercredentials-leg-user' => 'Benutzerkonto',
	'usercredentials-leg-areas' => 'Haupt-Interessensgebiete',
	'usercredentials-leg-person' => 'Persönliche Informationen',
	'usercredentials-leg-other' => 'Weitere Informationen',
	'usercredentials-email' => 'E-Mail:',
	'usercredentials-real' => 'Echter Name:',
	'usercredentials-bio' => 'Biographie:',
	'usercredentials-attach' => 'Lebenslauf:',
	'usercredentials-notes' => 'Zusätzliche Bemerkungen:',
	'usercredentials-urls' => 'Liste der Webseiten:',
	'usercredentials-ip' => 'Originale IP-Adresse:',
	'usercredentials-member' => 'Rechte:',
	'usercredentials-badid' => 'Es wurden keinen Berechtigungsnachweis für diesen Benutzer gefunden. Bitte die Schreibweise prüfen.',
	'right-confirmaccount' => 'Die [[Special:ConfirmAccounts|Warteschlange der angefragten Benutzerkonten]] sehen',
	'right-requestips' => 'Die IP-Adresse des Anfragers für ein Benutzerkonto sehen',
	'right-lookupcredentials' => '[[Special:UserCredentials|Benutzerempfehlungsschreiben]] sehen',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'requestaccount-text' => "'''Füllen Sie das folgende Formular aus und schicken Sie es ab, um ein Benutzerkonto zu beantragen'''.  

Bitte lesen Sie zunächst die [[{{MediaWiki:Requestaccount-page}}|Nutzungsbedingungen]], bevor Sie ein Benutzerkonto beantragen.

Sobald das Konto bestätigt wurde, werden Sie per E-Mail benachrichtigt und Sie können sich [[Special:UserLogin|anmelden]].",
	'requestaccount-dup' => "'''Achtung: Sie sind bereits mit einem registrierten Benutzerkonto angemeldet.'''",
	'requestaccount-acc-text' => 'An Ihre E-Mail-Adresse wird nach dem Absenden dieses Formulars eine Bestätigungsmail geschickt.
Bitte reagieren Sie darauf, indem Sie auf den in dieser Mail enthaltenen Bestätigungslink klicken.
Sobald Ihr Konto angelegt wurde, wird Ihnen Ihr Passwort per E-Mail zugeschickt.',
	'requestaccount-areas-text' => 'Wählen Sie die Themengebiete aus, in denen Sie das meiste Fachwissen haben oder wo Sie am meisten involviert sein werden.',
	'requestaccount-ext-text' => 'Die folgenden Informationen werden vertraulich behandelt und ausschließlich für diesen Antrag verwendet.
Sie können Kontaktangaben wie eine Telefonnummer machen, um die Bearbeitung Ihres Antrags zu vereinfachen.',
	'requestaccount-bio-text' => 'Ihre Biographie wird als initialer Inhalt Ihrer Benutzerseite gespeichert.
Versuchen Sie alle nötigen Empfehlungen zu erwähnen, aber stellen Sie sicher, dass Sie die Informationen auch wirklich veröffentlichen möchten.
Sie können Ihren Namen in [[Special:Preferences|Ihren Einstellungen]] ändern.',
	'requestaccount-agree' => 'Sie müssen bestätigen, dass Ihr Realname korrekt ist und Sie die Benutzungsbedingungen akzeptieren.',
	'requestaccount-tooshort' => 'Ihre Biographie muss mindestens {{PLURAL:$1|1 Wort|$1 Wörter}} lang sein.',
	'requestaccount-resub' => 'Die Datei mit Ihrem Lebenslauf muss aus Sicherheitsgründen neu ausgewählt werden.
Lassen Sie das Feld leer, wenn Sie keinen Lebenslauf mehr anfügen möchten.',
	'requestaccount-sent' => 'Ihr Antrag wurde erfolgreich verschickt und muss nun noch überprüft werden.
Eine Bestätigungs-E-Mail wurde an Ihre E-Mail-Adresse gesendet.',
	'request-account-econf' => 'Ihre E-Mail-Adresse wurde bestätigt und wird nun als solche in Ihrem Antrag auf ein Benutzerkonto geführt.',
	'requestaccount-email-body' => 'Jemand, mit der IP Adresse $1, möglicherweise Sie, haben bei {{SITENAME}} das Benutzerkonto „$2“ mit Ihrer E-Mail-Adresse beantragt.

Um zu bestätigen, dass wirklich Sie dieses Konto bei {{SITENAME}} beantragt haben, öffnen Sie bitte folgenden Link in Ihrem Browser:

$3

Wenn das Benutzerkonto erstellt wurde, bekommen Sie eine weitere E-Mail mit dem Passwort.

Wenn Sie das Benutzerkonto *nicht* beantragt haben, öffnen Sie den Link bitte nicht!

Dieser Bestätigungscode wird am $5 um $6 Uhr ungültig.',
	'requestaccount-email-body-admin' => '„$1“ hat ein Benutzerkonto beantragt und wartet auf Bestätigung.
Die E-Mail-Adresse wurde bestätigt. Sie können den Antrag hier bestätigen: „$2“.',
	'acct_request_throttle_hit' => 'Sie haben bereits {{PLURAL:$1|1 Benutzerkonto|$1 Benutzerkonten}} beantragt, Sie können momentan keine weiteren beantragen.',
	'requestaccount-loginnotice' => "Um ein neues Benutzerkonto zu erhalten, müssen Sie es '''[[Special:RequestAccount|beantragen]]'''.",
	'confirmaccount-maintext' => "'''Diese Seite dient dazu, wartende Benutzerkontenanträge für ''{{SITENAME}}'' zu bearbeiten.'''

Jede Benutzerkonten-Antragsqueue besteht aus drei Unterqueues. Eine für offene Anfrage, eine für Anträge im „abwarten“-Status und eine für kürzlich abgelehnte Anfragen.

Wenn Sie auf einen Antrag antworten, überprüfen Sie die Informationen sorgfältig und bestätigen Sie die enthaltenen Informationen.
Ihre Aktionen werden nichtöffentlich protokolliert. Es wird auch von Ihnen erwartet, die Aktionen anderer zu überprüfen.",
	'confirmaccount-list2' => 'Unten ist eine Liste kürzlich zurückgewiesener Anträge, die automatisch gelöscht werden, sobald sie einige Tage alt sind. Sie können noch genehmigt werden, allerdings sollten Sie zuerst den ablehnenden Administrator kontaktieren.',
	'confirmaccount-text' => "Dies ist ein Antrag auf ein Benutzerkonto bei '''{{SITENAME}}'''.

Prüfen Sie alle unten stehenden Informationen gründlich und bestätigen Sie die Informationen wenn möglich.
Bitte beachten Sie, dass Sie den Zugang bei Bedarf unter einem anderen Benutzernamen anlegen kannst.
Sie sollten dies nur nutzen, um Kollisionen mit anderen Namen zu vermeiden.

Wenn Sie diese Seite verlassen, ohne das Konto zu bestätigen oder abzulehnen, wird der Antrag offen stehen bleiben.",
	'confirmaccount-confirm' => 'Benutzen Sie die folgende Auswahl, um den Antrag zu akzeptieren, abzulehnen oder noch zu warten.',
	'confirmaccount-needreason' => 'Sie müssen eine Begründung eingeben.',
	'confirmaccount-welc' => "'''Willkommen bei ''{{SITENAME}}''!'''
Wir hoffen, dass Sie viele gute Informationen beisteuern.
Möglicherweise möchten Sie zunächst die [[{{MediaWiki:Helppage}}|Ersten Schritte]] lesen.
Nochmal: Willkommen und haben Sie Spaß!",
	'confirmaccount-email-body' => 'Ihr Antrag auf ein Benutzerkonto bei {{SITENAME}} wurde bestätigt.

Benutzername: $1

Passwort: $2

Aus Sicherheitsgründen sollten Sie Ihr Passwort unbedingt beim ersten Anmelden ändern.
Um sich anzumelden besuchen Sie bitte die Seite {{fullurl:{{#special:UserLogin}}}}.',
	'confirmaccount-email-body2' => 'Ihr Antrag auf ein Benutzerkonto bei {{SITENAME}} wurde bestätigt.

Benutzername: $1

Passwort: $2

$3

Aus Sicherheitsgründen sollten Sie Ihr Passwort unbedingt beim ersten Anmelden ändern.
Um sich anzumelden besuchen Sie bitte die Seite {{fullurl:{{#special:UserLogin}}}}.',
	'confirmaccount-email-body3' => 'Leider wurde Ihr Antrag auf ein Benutzerkonto „$1“  
bei {{SITENAME}} abgelehnt.

Dies kann viele Gründe haben. Möglicherweise haben Sie das Antragsformular
nicht richtig ausgefüllt, haben nicht genügend Angaben gemacht oder haben die Anforderungen auf andere Weise nicht erfüllt.

Möglicherweise gibt es auf der Seite Kontaktadressen, an die Sie sich wenden
können, wenn Sie mehr über die Anforderungen wissen möchten.',
	'confirmaccount-email-body4' => 'Leider wurde Ihr Antrag auf ein Benutzerkonto „$1“  
bei {{SITENAME}} abgelehnt.

$2

Möglicherweise gibt es auf der Seite Kontaktadressen, an die Sie sich wenden
können, wenn Sie mehr über die Anforderungen wissen möchten.',
	'confirmaccount-email-body5' => 'Bevor Ihre Anfrage für das Benutzerkonto „$1“ von {{SITENAME}} akzeptiert werden kann, müssen Sie zusätzliche Informationen übermitteln.

$2

Möglicherweise gibt es auf der Seite Kontaktadressen, an die Sie sich wenden können, wenn Sie mehr über die Anforderungen wissen möchten.',
);

/** Zazaki (Zazaki)
 * @author Belekvor
 */
$messages['diq'] = array(
	'confirmaccount-noreason' => '(çino)',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'requestaccount' => 'Póžedanje na konto stajiś',
	'requestaccount-text' => "'''Wupołń a wótpósćel slědujucy formular, aby stajił póžedanje na wužywarske konto'''.

Pśecytaj pšosym nejpjerwjej [[{{MediaWiki:Requestaccount-page}}|wužywańske wuměnjenja]], pjerwjej až stajijoš póžedanje na konto.

Gaž konto jo schwalone, dostanjoš e-mailku a konto dajo se za [[Special:UserLogin|pśizjawjenje]] wužywaś.",
	'requestaccount-page' => '{{ns:project}}:Wužywańske wuměnjenja',
	'requestaccount-dup' => "'''Glědaj: Sy se južo pśizjawił ze zregistrěrowanym kontom.'''",
	'requestaccount-leg-user' => 'Wužywarske konto',
	'requestaccount-leg-areas' => 'Głowne zajmowe póla',
	'requestaccount-leg-person' => 'Wósobinske informacije',
	'requestaccount-leg-other' => 'Druge informacije',
	'requestaccount-leg-tos' => 'Wužywańske wuměnjenja',
	'requestaccount-acc-text' => 'Na twóju e-mailowu adresu pósćele se wobkšuśeńska powěsć, gaž toś to póžedanje jo wótpósłane.
Pšosym wótegroń pśez kliknjenje na wobkšuśeński wótkaz w e-mailce.
Gaž twójo konto jo załožone, gronidło pśipósćeła se śi pśez e-mail.',
	'requestaccount-areas-text' => 'Wubjeŕ temowe póla, w kótarychž maš neejlěpše wěcywuznaśe abo za to ty by rady nejwěcej źěło cyniś.',
	'requestaccount-ext-text' => 'Ze slědujucymi informacijami wobchadaju dowěrliwje a budu se jano za toś to póžedanje.
Móžoš kontaktowe pódaśa ako telefonowy numer cyniś, aby pomagał pśi wobkšuśenju identity.',
	'requestaccount-bio-text' => 'Twója biografija nastajijo se ako standardne wopśimjeśe za twój wužywarski bok.
Wopytaj referency zapśěgnuś, ale wobmysli, lěc coš take informacije wózjawiś.
Twójo mě dajo se pśez [[Special:Preferences|swóje nastajenja]] změniś.',
	'requestaccount-real' => 'Napšawdne mě:',
	'requestaccount-same' => '(kaž napšawdne mě)',
	'requestaccount-email' => 'E-mailowa adresa:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'awtor',
	'requestaccount-level-1' => 'wobźěłaŕ',
	'requestaccount-bio' => 'Wósobinska biografija:',
	'requestaccount-attach' => 'Žywjenjoběg (opcionalny):',
	'requestaccount-notes' => 'Pśidatne pódaśa:',
	'requestaccount-urls' => 'Lisćina websedłow, jolic take su (kuždy zapisk na swójskej smužce):',
	'requestaccount-agree' => 'Musyš wobkšuśiś, až twójo napšawdne mě jo korektne a až sy wobjadny z wužywańskimi wuměnjenjami.',
	'requestaccount-inuse' => 'Wužywarske mě wužywa se južo w njedocynjonem póžedanju na konto.',
	'requestaccount-tooshort' => 'Twója biografija musy nanejmjenjej $1 {{PLURAL:$1|słowo|słowje|słowa|słowow}} dłujko byś.',
	'requestaccount-emaildup' => 'Dalšne njedocynjone póžedanje na konto wužywa samsku e-mailowu adresu.',
	'requestaccount-exts' => 'Datajowy typ dodanka njejo dowólony.',
	'requestaccount-resub' => 'Dataja z twójim žywjenjoběgom musy se z wěstotnych pśicynow znowego wubraś.
Wóstaj pólo prozne, jolic njocoš wěcej ju zapśěgnuś.',
	'requestaccount-tos' => 'Som pśecytał [[{{MediaWiki:Requestaccount-page}}|wužywańske wuměnjenja]] {{GRAMMAR:genitiw|{{SITENAME}}}} a lubim se jich źaržaś.
Mě, kótarež som pód "napšawdne mě" pódał, jo napšawdu mójo napšawdne mě.',
	'requestaccount-submit' => 'Póžedanje na konto stajiś',
	'requestaccount-sent' => 'Twójo póžedanje na konto jo se wuspěšnje wótpósłało a caka něnto na pśeglědanje. Wobkšuśeńska e-mail jo se pósłała na twóju e-mailowu adresu.',
	'request-account-econf' => 'Twója e-mailowa adresa jo se wobkšuśiła a nalicyjo ako taka w twójim póžedanju na konto.',
	'requestaccount-email-subj' => '{{SITENAME}} wobkšuśenje e-mailoweje adrese',
	'requestaccount-email-body' => 'Něchten, nejskerjej ty z IP-adrese $1, jo stajił póžedanje na konto "$2" z toś teju e-mailoweju adresu na {{GRAMMAR:lokatiw|{{SITENAME}}}}.

Aby wobkšuśił, až toś to konto napšawdu śi słuša na {{GRAMMAR:lokatiw|{{SITENAME}}}}, wócyń toś ten wótkaz w swójom wobglědowaku:

$3

Jolic konto jo załožone, dostanjoš jano ty gronidło pśez e-mail.
Jolic konto śi *nje*słuša, njewócyń ten wótkaz.
Toś ten wobkšuśeński kod pśepadnjo $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} póžedanje na konto',
	'requestaccount-email-body-admin' => '"$1" jo stajił pózedanje na konto a caka na wobkšuśenje.
E-mailowa adresa jo se wobkšuśiła. Móžoš póžedanje how wobkšuśiś: "$2".',
	'acct_request_throttle_hit' => 'Wódaj, sy južo pominał {{PLURAL:$1|jadno konto|$1 konśe|$1 konta|$1 kontow}}.
Njamóžeš dalšne póžedanja stajiś.',
	'requestaccount-loginnotice' => "Aby dostał wužywarske konto, musyš '''[[Special:RequestAccount|póžedanje na nje stajiś]]'''.",
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|pśez e-mail wobkšuśone póžedanje na konto jo njedocynjone|pśez e-mail wobkšuśonej póžedani na konśe stej njedocynjonej|pśez e-mail wobkšuśone póžedanja na konta su njedocynjone|pśez e-mail wobkšuśonych póžedanjow na konta jo njedocynjone}}",
	'confirmaccounts' => 'Póžedanja na konta wobkšuśiś',
	'confirmedit-desc' => 'Dawa běrokratam móžnosć póžedanja na konta wobkšuśiś',
	'confirmaccount-maintext' => "'''Toś ten bok wužywa se, aby se wobkšuśili njedocynjone póžedanja na konta za ''{{GRAMMAR:akuzatiw|{{SITENAME}}}}'''''.

Kuždy cakański rěd póžedanjow na konta wobstoj z tśich cakańskich pódrědow.
Jaden za njedocynjone póžedanje, jaden za te, kótarež su se zaźaržali wót drugich administratorow bźez dalšnych informacijow a jaden za njedawno wótpokazane póžedanja.

Gaž wótegranjaś na póžedanje, pśeglědaj jo kradosćiwje a, jolic trěbne, wobkšuś informacije, kótarež wopśimujo.
Twóje akcije budu se priwatnje protokolěrowaś.
Wót tebje se teke wótcakujo, až pśeglědujoš aktiwnosć, kótaraž how se wótměwa, mimo togo, kótarež sam cyniš.",
	'confirmaccount-list' => 'Dołojce jo lisćina póžedanjow na konto, kótarež cakaja na schwalenje.
Gaž póžedanje jo pak schwalone pak wótpokazane,  buźo se z toś teje lisćiny wótwónoźowaś.',
	'confirmaccount-list2' => 'Dołojce jo lisćina njedawno wótpokazanych póžedanjow na konta, kótarež se awtomatiski lašuju, gaž su někotare dny stare.
Jo hyšći móžno, aby se wone pśetwórili do schwalonych kontow, ale ty měł se nejpjerwjej z njewótpokazujucym administratorom do zwiska stajiś, pjerwjej až to cyniš.',
	'confirmaccount-list3' => 'Dołojce jo lisćina pśepadnjonych póžedanja na konta, kótarež se awtomatiski lašuju, gaž su někotare dny stare. Daju se hyšći do schwalonych kontow pśetwóriś.',
	'confirmaccount-text' => "To jo wisece póžedanje na wužywarske konto na '''{{GRAMMAR:lokatiw|{{SITENAME}}}}'''.

Pśeglědaj pšosym slědujuce informacije kšadosćiwje.
Jolic pśizwólujoš tos to póžedanje, wužyj padajucy menij, aby nastajił kontowy status wužywarja.
Změny pśewjeźone na biografiji njebudu wobwliwowaś wobstawne składowanje podaśow. Źiwaj na to, až móžoš konto pód drugim wužywarskim mjenim załožyś.
Wužyj to jano, aby se wobinuł kolizije z drugimi mjenjami.

Jolic jadnorje wóstajijoš toś ten bok bźez wobkšuśenja abo wótpokazanja toś togo póžedanja, wóstajijo docynjone.",
	'confirmaccount-none-o' => 'Tuchylu njejsu njedocynjone póžedanja na konta w toś tej lisćinje.',
	'confirmaccount-none-h' => 'Tuchylu njejsu zaźaržane póžedanja na konta w tos´tej lisćinje.',
	'confirmaccount-none-r' => 'Njejsu tuchylu njedawno wótpokazane póžedanja na konta w toś tej lisćinje.',
	'confirmaccount-none-e' => 'Tuchylu njejsu pśepadnjone póžedanja na konta w toś tej lisćinje.',
	'confirmaccount-real-q' => 'Mě',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografija',
	'confirmaccount-showopen' => 'njedocynjone póžedanja',
	'confirmaccount-showrej' => 'wótpokazane póžedanja',
	'confirmaccount-showheld' => 'Zaźaržane póžedanja',
	'confirmaccount-showexp' => 'pśepadnjone póžedanja',
	'confirmaccount-review' => 'Pśeglědaś',
	'confirmaccount-types' => 'Wubjeŕ cakajucy rěd kontowego wobkšuśenja ze slědujucych:',
	'confirmaccount-all' => '(wše cakajuce rědy pokazaś)',
	'confirmaccount-type' => 'Cakajucy rěd:',
	'confirmaccount-type-0' => 'pśichodne awtory',
	'confirmaccount-type-1' => 'pśichodne wobźěłarje',
	'confirmaccount-q-open' => 'njedocynjone póžedanja',
	'confirmaccount-q-held' => 'zaźaržane póžedanja',
	'confirmaccount-q-rej' => 'njedawno wótpokazane póžedanja',
	'confirmaccount-q-stale' => 'pśepadnjone póžedanja',
	'confirmaccount-badid' => 'Njejo žedne njedocynjone póžedanje za pódany ID.
Snaź jo južo docynjone.',
	'confirmaccount-leg-user' => 'Wužywarske konto',
	'confirmaccount-leg-areas' => 'Głowne zajmowe póla',
	'confirmaccount-leg-person' => 'Wósobinske informacije',
	'confirmaccount-leg-other' => 'Druge informacije',
	'confirmaccount-name' => 'Wužywarske mě',
	'confirmaccount-real' => 'Mě:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Pozicija:',
	'confirmaccount-pos-0' => 'awtor',
	'confirmaccount-pos-1' => 'wobźěłaŕ',
	'confirmaccount-bio' => 'Biografija:',
	'confirmaccount-attach' => 'Žywjenjoběg:',
	'confirmaccount-notes' => 'Pśidatne pódaśa:',
	'confirmaccount-urls' => 'Lisćina websedłow:',
	'confirmaccount-none-p' => '(njepódany)',
	'confirmaccount-confirm' => 'Wužyj slědujuce opcije, aby akceptěrował, wótpokazał abo zaźaržał toś to póžedanje:',
	'confirmaccount-econf' => '(wobkšuśony)',
	'confirmaccount-reject' => '(wótpokazane wót wužywarja [[User:$1|$1]] na $2)',
	'confirmaccount-rational' => 'Wobtwarźenje za póžedarja:',
	'confirmaccount-noreason' => '(žedna)',
	'confirmaccount-autorej' => '(toś to póžedanje jo se awtomatiski zachyśiło njeaktiwnosći dla)',
	'confirmaccount-held' => '(wót wužywarja [[User:$1|$1]] na $2 ako "zaźaržane" markěrowane)',
	'confirmaccount-create' => 'Akceptěrowaś (konto załožyś)',
	'confirmaccount-deny' => 'Wótpokazaś (z lisćiny wótpóraś)',
	'confirmaccount-hold' => 'Zaźaržaś',
	'confirmaccount-spam' => 'Spam (žednu e-mailku pósłaś)',
	'confirmaccount-reason' => 'Komentar (zapśěgnjo se do e-mailki):',
	'confirmaccount-ip' => 'IP-adresa:',
	'confirmaccount-legend' => 'Toś to konto wobkšuśiś/wótpokazaś',
	'confirmaccount-submit' => 'Wobkšuśiś',
	'confirmaccount-needreason' => 'Musyš pśicynu w slědujucem komentarowem kašćiku pódaś.',
	'confirmaccount-canthold' => 'Toś to póžedanje jo se pak zaźaržało pak wulašowało.',
	'confirmaccount-acc' => 'Póžedanje na konto wuspěšnje wobkšuśone;
jo se załožyło nowe konto za wužywarja [[User:$1|$1]].',
	'confirmaccount-rej' => 'Póžedanje na konto wuspěšnje wótpokazane.',
	'confirmaccount-viewing' => '(woglědujo se tuchylu wót wužywarja [[User:$1|$1]])',
	'confirmaccount-summary' => 'Napóranje wužywarskego boka z biografiju nowego wužywarja.',
	'confirmaccount-welc' => "'''Witaj do ''{{GRAMMAR:genitiw|{{SITENAME}}}}''!'''
Naźejamy se, až librujoš wjele dobrych pśinoskow.
Nejskerjej coš [[{{MediaWiki:Helppage}}|boki pomocy]] cytaś.
Hyšći raz: Witaj a wjele wjasela!",
	'confirmaccount-wsum' => 'Witaj!',
	'confirmaccount-email-subj' => '{{SITENAME}} póžedanje na konto',
	'confirmaccount-email-body' => 'Twójo póžedanje na konto jo se na {{GRAMMAR:lokatiw|{{SITENAME}}}} schwaliło.

Mě konta: $1

Gronidło: $2


Z wěstotnych pśicynow musyš swójo gronidło pśi prědnem pśizjawjenju změniś.
Aby se pśizjawił, źi pšosym k {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Twójo póžedanje na konto jo se na {{GRAMMAR:lokatiw|{{SITENAME}}}} schwaliło.

Mě konta: $1

Gronidło: $2

$3

Z wěstotnych pśicynow musyš swójo gronidło pśi prědnem pśizjawjenju změniś.
Aby se pśizjawił, źi pšosym k {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Wódaj, twójo póžedanje na konto "$1" jo se wótpokazało na {{GRAMMAR:lokatiw|{{SITENAME}}}}.

Za to su někotare pśicyny móžno.
Snaź njejsy pšawje wupołnił formular, njejsy doźaržał pominanu dłujkosć we wótegronach abo howac pśekśiwił zasady wužywarskich konto.
Snaź su kontaktowe lisćiny na sedle, kótarež móžoš wužywaś, jolic coš wěcej wo zasadach wužywarskich konto wěźeś.',
	'confirmaccount-email-body4' => 'Wódaj, twójo póžedanje na konto "$1" jo se wótpokazało na {{GRAMMAR:lokatiw|{{SITENAME}}}}.

$2

Snaź su kontaktowe lisćiny na sedle, kótarež móžoš wužywaś, jolic coš wěcej wó zasadach wužywarskich kontow wěźeś.',
	'confirmaccount-email-body5' => 'Pjerwjej až twójo póžedanje na konto "$1" dajo se na {{GRAMMAR:lokatiw|{{SITENAME}}}} akceptěrowaś, musyš nejpjerwjej někotare pśidatne informacije pódaś.

$2

Snaź su kontaktowe lisćiny na sedle, kótarež móžoš wužywaś, jolic coš wěcej wó zasadach wužywarskich kontow wěźeś.',
	'usercredentials' => 'Wósobinske pódaśa wužywarja',
	'usercredentials-leg' => 'Pytanje jo wósobinske pódaśa wužywarja wobkšuśiło',
	'usercredentials-user' => 'Wužywarske mě:',
	'usercredentials-text' => 'Dołojce su wobkšuśone wósobinske pódaśa wubranego wužywarskego konta.',
	'usercredentials-leg-user' => 'Wužywarske konto',
	'usercredentials-leg-areas' => 'Głowne zajmowe wobcerki',
	'usercredentials-leg-person' => 'Wósobinske informacije',
	'usercredentials-leg-other' => 'Druge informacije',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Napšawdne mě:',
	'usercredentials-bio' => 'Biografija:',
	'usercredentials-attach' => 'Žywjenjoběg:',
	'usercredentials-notes' => 'Pśidatne pśipiski:',
	'usercredentials-urls' => 'Lisćina websedłow',
	'usercredentials-ip' => 'Originalna IP-adresa:',
	'usercredentials-member' => 'Pšawa:',
	'usercredentials-badid' => 'Za toś togo wužywarja njebuchu žedne wósobinske pódaśa namakane. Pśekontrolěruj, lěc te mě jo pšawje napisane.',
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Cakański rěd z pominanymi kontami]] se woglědaś',
	'right-requestips' => 'IP-adrese póžadarja se woglědaś, mjaztym až se pominane konta pśeźěłuju',
	'right-lookupcredentials' => '[[Special:UserCredentials|Wužywarske wopšawnjeńki]] se woglědaś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'confirmaccount-wsum' => 'Woezɔ loo!',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'requestaccount' => 'Αίτηση λογαριασμού',
	'requestaccount-page' => '{{ns:project}}:Όροι Χρήσης',
	'requestaccount-leg-user' => 'Λογαριασμός χρήστη',
	'requestaccount-leg-areas' => 'Κύρια πεδία ενδιαφέροντος',
	'requestaccount-leg-person' => 'Προσωπικές πληροφορίες',
	'requestaccount-leg-other' => 'Άλλες πληροφορίες',
	'requestaccount-leg-tos' => 'Όροι Χρήσης',
	'requestaccount-real' => 'Πραγματικό όνομα:',
	'requestaccount-same' => '(το ίδιο με το πραγματικό όνομα)',
	'requestaccount-email' => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου:',
	'requestaccount-reqtype' => 'Θέση:',
	'requestaccount-level-0' => 'δημιουργός',
	'requestaccount-level-1' => 'συντάκτης',
	'requestaccount-bio' => 'Προσωπική βιογραφία:',
	'requestaccount-attach' => 'Βιογραφικό (προαιρετικό):',
	'requestaccount-notes' => 'Συμπληρωματικές σημειώσεις:',
	'requestaccount-submit' => 'Αίτηση λογαριασμού',
	'requestaccount-email-subj-admin' => 'Αίτηση λογαριασμού στο {{SITENAME}}',
	'confirmaccounts' => 'Επιβεβαίωση αιτήσεων λογαριασμών',
	'confirmaccount-real-q' => 'Όνομα',
	'confirmaccount-email-q' => 'Ηλεκτρονικό Ταχυδρομείο:',
	'confirmaccount-bio-q' => 'Βιογραφία',
	'confirmaccount-showopen' => 'άνοιγμα αιτήσεων',
	'confirmaccount-showrej' => 'αιτήσεις που έχουν απορριφθεί',
	'confirmaccount-showheld' => 'αιτήσεις που έχουν κρατηθεί',
	'confirmaccount-showexp' => 'αιτήσεις που έχουν λήξει',
	'confirmaccount-review' => 'Επιθεώρηση',
	'confirmaccount-all' => '(προβολή όλων των ουρών)',
	'confirmaccount-type' => 'Ουρά:',
	'confirmaccount-type-0' => 'πιθανοί δημιουργοί',
	'confirmaccount-type-1' => 'πιθανοί συντάκτες',
	'confirmaccount-q-open' => 'ανοικτές αιτήσεις',
	'confirmaccount-q-held' => 'κράτησε αιτήσεις',
	'confirmaccount-q-rej' => 'πρόσφατα απορριμένες προτάσεις',
	'confirmaccount-q-stale' => 'ληγμένες αιτήσεις',
	'confirmaccount-leg-user' => 'Λογαριασμός χρήστη',
	'confirmaccount-leg-areas' => 'Κύρια πεδία ενδιαφέροντος',
	'confirmaccount-leg-person' => 'Προσωπικές πληροφορίες',
	'confirmaccount-leg-other' => 'Άλλες πληροφορίες',
	'confirmaccount-name' => 'Όνομα χρήστη',
	'confirmaccount-real' => 'Όνομα:',
	'confirmaccount-email' => 'Ηλεκτρονικό Ταχυδρομείο:',
	'confirmaccount-reqtype' => 'Θέση:',
	'confirmaccount-pos-0' => 'συγγραφέας',
	'confirmaccount-pos-1' => 'επεξεργαστής',
	'confirmaccount-bio' => 'Βιογραφία:',
	'confirmaccount-attach' => 'Βιογραφικό:',
	'confirmaccount-notes' => 'Συμπληρωματικές σημειώσεις:',
	'confirmaccount-urls' => 'Λίστα των ιστοσελίδων:',
	'confirmaccount-none-p' => '(δεν παρέχεται)',
	'confirmaccount-econf' => '(επιβεβαιωμένοι)',
	'confirmaccount-noreason' => '(κανένα)',
	'confirmaccount-create' => 'Αποδοχή (Δημιουργία λογαριασμού)',
	'confirmaccount-deny' => 'Απόρριψη (αφαίρεση από τη λίστα)',
	'confirmaccount-hold' => 'Κράτημα',
	'confirmaccount-spam' => 'Σπαμ (να μην αποσταλέι μέιλ)',
	'confirmaccount-reason' => 'Σχόλιο (θα συμπεριληφθεί στο μέιλ)',
	'confirmaccount-ip' => 'διεύθυνση ΙΡ:',
	'confirmaccount-submit' => 'Επιβεβαίωση',
	'confirmaccount-wsum' => 'Καλός ήρθατε!',
	'confirmaccount-email-subj' => 'Ζήτηση λογαριασμού στο {{SITENAME}}',
	'confirmaccount-email-body' => 'Το αίτημα σας για δημιουργία λογαριασμού έχει εγκριθεί στο {{SITENAME}}.

Όνομα λογαριασμού: $1

Κωδικός πρόσβασης: $2

Για λόγους ασφαλείας θα πρέπει να αλλάξετε τον κωδικό πρόσβασης κατά την πρώτη σύνδεση.
Για να συνδεθείτε, παρακαλούμε πηγαίνετε στο {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Το αίτημα σας για δημιουργία λογαριασμού έχει εγκριθεί στο {{SITENAME}}.

Όνομα λογαριασμού: $1

Κωδικός πρόσβασης: $2

$3

Για λόγους ασφαλείας θα πρέπει να αλλάξετε τον κωδικό πρόσβασης κατά την πρώτη σύνδεση.
Για να συνδεθείτε, παρακαλούμε πηγαίνετε στο {{fullurl:Special:UserLogin}}.',
	'usercredentials' => 'Διαπιστευτήρια χρήστη',
	'usercredentials-user' => 'Όνομα χρήστη:',
	'usercredentials-leg-user' => 'Λογαριασμός χρήστη',
	'usercredentials-leg-areas' => 'Κύρια πεδία ενδιαφέροντος',
	'usercredentials-leg-person' => 'Προσωπικές πληροφορίες',
	'usercredentials-leg-other' => 'Άλλες πληροφορίες',
	'usercredentials-email' => 'Ηλεκτρονικό ταχυδρομείο:',
	'usercredentials-real' => 'Πραγματικό όνομα:',
	'usercredentials-bio' => 'Βιογραφία:',
	'usercredentials-attach' => 'Βιογραφικό:',
	'usercredentials-notes' => 'Συμπληρωματικές σημειώσεις:',
	'usercredentials-urls' => 'Λίστα ιστοσελίδων:',
	'usercredentials-ip' => 'Αρχική διεύθυνση IP:',
	'usercredentials-member' => 'Δικαιώματα:',
);

/** Esperanto (Esperanto)
 * @author Amikeco
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'requestaccount' => 'Peti konton',
	'requestaccount-page' => '{{ns:project}}:Regularo de Servo',
	'requestaccount-dup' => "'''Notu: Vi jam ensalutis kun registrita konto.'''",
	'requestaccount-leg-user' => 'Konto de uzanto',
	'requestaccount-leg-areas' => 'Ĉefaj fakoj de intereso',
	'requestaccount-leg-person' => 'Persona informo',
	'requestaccount-leg-other' => 'Alia informo',
	'requestaccount-real' => 'Reala nomo:',
	'requestaccount-same' => '(sama kiel reala nomo)',
	'requestaccount-email' => 'Retpoŝta adreso:',
	'requestaccount-reqtype' => 'Pozicio:',
	'requestaccount-level-0' => 'aŭtoro',
	'requestaccount-level-1' => 'Redaktanto',
	'requestaccount-bio' => 'Persona biografio:',
	'requestaccount-attach' => 'Karierresumo (nedeviga):',
	'requestaccount-notes' => 'Pluaj notoj:',
	'requestaccount-tooshort' => 'Via biografio devas havi almenaŭ $1 {{PLURAL:$1|vorton|vortojn}}.',
	'requestaccount-emaildup' => 'Alia peto por kontrolenda konto uzas la saman retadreson.',
	'requestaccount-exts' => 'Dosiertipo de aldonaĵo estas malpermesita.',
	'requestaccount-submit' => 'Peti konton',
	'requestaccount-sent' => 'Via konta peto estas sukcese sendita kaj nun bezonas kontrolon.
Konfirma retpoŝto estas sendita al via retpoŝtadreso.',
	'request-account-econf' => 'Via retadreso estis konfirmita kaj estos listigita tiel en via konta peto.',
	'requestaccount-email-subj' => '{{SITENAME}} retpoŝta konfirmo',
	'requestaccount-email-body' => 'Iu, verŝajne vi de IP-adreso $1, petis konton "$2" kun ĉi tiu retadreso ĉe {{SITENAME}}.

Konfirmi ke ĉi tiu konto ja apartenas al vi ĉe {{SITENAME}}, malfermu ĉi tiun ligilon en via retumilo:

$3

Se la konto estas kreita, nur al vi estos retpoŝtita la pasvorto.
Se ĉi tio ne devenas al vi, ne sekvu la ligilon.
Ĉi tiu konfirmado findatiĝis je $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} peto por konto',
	'acct_request_throttle_hit' => 'Bedaŭrinde, vi jam petis {{PLURAL:$1|1 konton|$1 kontojn}}.
Vi ne povas peti pluajn petojn.',
	'requestaccount-loginnotice' => "Akiri uzanto-konton, vi devas '''[[Special:RequestAccount|peti ĝin]]'''.",
	'confirmaccounts' => 'Konfirmi petojn por kontoj',
	'confirmedit-desc' => 'Donas al burokratoj la ebleco konfirmi kontajn petojn',
	'confirmaccount-real-q' => 'Nomo',
	'confirmaccount-email-q' => 'Retadreso',
	'confirmaccount-bio-q' => 'Biografio',
	'confirmaccount-showopen' => 'malfermaj petoj',
	'confirmaccount-showrej' => 'malakceptitaj petoj',
	'confirmaccount-showexp' => 'preteraj petoj',
	'confirmaccount-review' => 'Kontrolu',
	'confirmaccount-all' => '(montri ĉiujn atendovicojn)',
	'confirmaccount-type' => 'Atendovico:',
	'confirmaccount-type-0' => 'eventualaj aŭtoroj',
	'confirmaccount-type-1' => 'eventualaj redaktantoj',
	'confirmaccount-q-open' => 'malfermaj petoj',
	'confirmaccount-q-stale' => 'eksdatiĝintaj petoj',
	'confirmaccount-leg-user' => 'Konto de uzanto',
	'confirmaccount-leg-areas' => 'Ĉefaj fakoj de intereso',
	'confirmaccount-leg-person' => 'Persona informo',
	'confirmaccount-leg-other' => 'Alia informo',
	'confirmaccount-name' => 'Salutnomo',
	'confirmaccount-real' => 'Nomo:',
	'confirmaccount-email' => 'Retadreso:',
	'confirmaccount-reqtype' => 'Pozicio:',
	'confirmaccount-pos-0' => 'aŭtoro',
	'confirmaccount-pos-1' => 'redaktanto',
	'confirmaccount-bio' => 'Biografio:',
	'confirmaccount-attach' => 'Karierresumo:',
	'confirmaccount-notes' => 'Pluaj notoj:',
	'confirmaccount-urls' => 'Listo de retejoj:',
	'confirmaccount-none-p' => '(ne provizita)',
	'confirmaccount-econf' => '(konfirmita)',
	'confirmaccount-reject' => '(malkonfirmita de [[User:$1|$1]] je $2)',
	'confirmaccount-noreason' => '(nenio)',
	'confirmaccount-create' => 'Akceptu (kreu konton)',
	'confirmaccount-deny' => 'Malaprobi (ekslistigi)',
	'confirmaccount-spam' => 'Spamo (ne sendu retpoŝton)',
	'confirmaccount-reason' => 'Komento (estos inkluzivita en retpoŝto):',
	'confirmaccount-ip' => 'IP-adreso',
	'confirmaccount-submit' => 'Konfirmi',
	'confirmaccount-needreason' => 'Vi devas enigi kialon en la suba komentskatolo.',
	'confirmaccount-viewing' => '(nune okulumis uzanto [[User:$1|$1]])',
	'confirmaccount-summary' => 'Kreante uzanto-paĝon kun biografio de nova uzanto.',
	'confirmaccount-welc' => "'''Bonvenon al ''{{SITENAME}}''!''' Ni esperas ke vi kontribuos multe kaj bone.
Vi verŝajne volos legi la [[{{MediaWiki:Helppage}}|helpo-paĝoj]]. Denove, bonvenon kaj amuziĝu!",
	'confirmaccount-wsum' => 'Bonvenon!',
	'confirmaccount-email-subj' => 'peto de konto ĉe {{SITENAME}}',
	'confirmaccount-email-body' => 'Via peto por konto estis aprobita ĉe {{SITENAME}}.

Nomo de konto: $1

Pasvorto: $2

Por sekurecaj kialoj vi devas ŝanĝi vian pasvorton dum unua ensaluto. Por ensaluti, bonvolu iri al {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Via peto por konto estis aprobita ĉe {{SITENAME}}.

Nomo de konto: $1

Pasvorto: $2

$3

Por sekurecaj kialoj vi devas ŝanĝi vian pasvorton dum unua ensaluto. Por ensaluti, bonvolu iri al {{fullurl:Special:UserLogin}}.',
	'usercredentials-user' => 'Salutnomo:',
	'usercredentials-leg-user' => 'Konto de uzanto',
	'usercredentials-leg-areas' => 'Ĉefaj fakoj de intereso',
	'usercredentials-leg-person' => 'Persona informo',
	'usercredentials-leg-other' => 'Alia informo',
	'usercredentials-email' => 'Retadreso:',
	'usercredentials-real' => 'Reala nomo:',
	'usercredentials-bio' => 'Biografio:',
	'usercredentials-attach' => 'Karierresumo:',
	'usercredentials-notes' => 'Plua informo:',
	'usercredentials-urls' => 'Listo de retejoj:',
	'usercredentials-ip' => 'Originala IP-adreso:',
	'usercredentials-member' => 'Rajtoj:',
);

/** Spanish (Español)
 * @author BicScope
 * @author Crazymadlover
 * @author Imre
 * @author Lin linao
 * @author Locos epraix
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'requestaccount' => 'Cuenta solicitada',
	'requestaccount-text' => "'''Completa y envía el siguiente formulario para solicitar una cuenta de usuario'''.

Antes de solicitar una cuenta, asegúrate de haber leído los [[{{MediaWiki:Requestaccount-page}}|términos del servicio]].

Una vez que la cuenta sea aprobada, se te enviará una notificación a través de correo electrónico y la cuenta se podrá usar [[Special:UserLogin|iniciando sesión]].",
	'requestaccount-page' => '{{ns:project}}:Términos de Servicio',
	'requestaccount-dup' => "'''Nota: Ya has iniciado sesión en una cuenta registrada.'''",
	'requestaccount-leg-user' => 'Cuenta de usuario',
	'requestaccount-leg-areas' => 'Áreas de interés principales',
	'requestaccount-leg-person' => 'Información personal',
	'requestaccount-leg-other' => 'Otra información',
	'requestaccount-leg-tos' => 'Términos de Servicio',
	'requestaccount-acc-text' => 'Te será enviada un mensaje de confirmación a tu dirección de e-m@il una vez que hayas hecho tu solicitud.
Por favor responda dando clik en el enlace de confirmación que le fué enviado a su e-m@il.
Tu contraseña será enviada cuando tu cuenta sea creada.',
	'requestaccount-areas-text' => 'Seleccione las áreas en las que tiene experiencia formal o que le interesa colaborar.',
	'requestaccount-ext-text' => 'La siguiente información se mantiene privada y sólo será usada para esta solicitud.
Usted puede desear enlistar contactos como un número telefónico para ayudar en la confirmación de la identidad.',
	'requestaccount-bio-text' => 'Tu biografía será configurado como el contenido por defecto de tu página de usuario.
Trate de incluir alguna credencial.
Asegúrese de estar conforme con la publicación de tal información.
Tu nombre puede ser cambiado a través de [[Special:Preferences|Tus preferencias]].',
	'requestaccount-real' => 'Nombre real:',
	'requestaccount-same' => '[Tu nombre real]',
	'requestaccount-email' => 'Dirección de correo electrónico:',
	'requestaccount-reqtype' => 'Posición:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografía personal:',
	'requestaccount-attach' => 'Campo (Opcional):',
	'requestaccount-notes' => 'Notas adicionales:',
	'requestaccount-urls' => 'Lista de sitios web [sepáralos por renglones]',
	'requestaccount-agree' => 'Tienes que certificar que tu nombre real es correcto y que estás de acuerdo con nuestros términos de servicio.',
	'requestaccount-inuse' => 'El nombre de usuario ya está en uso en una solicitud de cuenta pendiente.',
	'requestaccount-tooshort' => 'Tu biografía debe ser de al menos $1 {{PLURAL:$1|palabra|palabras}} de largo.',
	'requestaccount-emaildup' => 'Alguna otra solicitud de cuenta pendiente usa la misma dirección de correo electrónico.',
	'requestaccount-exts' => 'Tipo de archivo adjunto no está permitido.',
	'requestaccount-resub' => 'Por motivos de seguridad, debes seleccionar de nuevo el archivo de tu CV.
Deja el campo en blanco si ya no deseas incluirlo.',
	'requestaccount-submit' => 'Solicitar cuenta',
	'requestaccount-sent' => 'Tu solicitud de cuenta ha sido exitosamente enviado y está ahora en una revisión pendiente.
Un correo electrónico de confirmación ha sido enviado a tu dirección de correo electrónico.',
	'request-account-econf' => 'Tu correo electrónico ha sido onfirmado y será listado como tal en tu solicitud de cuenta.',
	'requestaccount-email-subj' => '{{SITENAME}} confirmación de dirección de correo electrónico',
	'requestaccount-email-body' => 'Alguien, probablemente tú con la dirección de IP $1, ha solicitado una cuenta "$2" con esta dirección de correo electrónico en {{SITENAME}}.

Abre el siguiente vínculo en tu navegador para confirmar que realmente esta es tu cuenta en {{SITENAME}}:

$3

Si se crea la cuenta, se te enviará la contraseña sólo a ti.
Si esta *no* es tu cuenta, no abras el vínculo.
Este código de confirmación caducará el $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} solicitud de cuenta',
	'requestaccount-email-body-admin' => '"$1" ha solicitado una cuenta y está esperando por su confirmación.
La dirección de correo electrónico ha sido confirmada. Puedes confirmar la solicitud aquí "$2".',
	'acct_request_throttle_hit' => 'Perdón, ya has solicitado {{PLURAL:$1|1 cuenta|$1 cuentas}}.
No puedes hacer ninguna otra solicitud.',
	'requestaccount-loginnotice' => "Para obtener una cuenta de usuario, debes '''[[Special:RequestAccount|solicitar una]]'''.",
	'confirmaccounts' => 'Confirmar solicitudes de cuenta',
	'confirmedit-desc' => 'Da a los burócratas la habilidad de confirmar solicitudes de cuenta',
	'confirmaccount-list' => 'Debajo hay una lista de solicitudes de cuenta esperando aprobación.
una vez que una solicitud es tanto aprovada como rechazada se removerá de esta lista.',
	'confirmaccount-text' => "Esta es una solicitud en espera de una cuenta de usuario en'''{{SITENAME}}'''.

Lee con atención la siguiente información.
Si decides aprobar esta solicitud, utiliza el menú desplegable de posición para establecer el estado de la cuenta del usuario.
Las ediciones hechas a la biografía de la aplicación no afectarán ningún almacenamiento de credenciales permanente.
También puedes elegir crear la cuenta con un nombre de usuario diferente.
Debes elegir esta opción sólo para evitar conflictos (coincidencias) con otros nombres.

Si dejas esta solicitud sin confirmar o rechazar, quedará en espera.",
	'confirmaccount-none-o' => 'Actualmente no hay solicitudes de cuenta en espera abiertas en este listado.',
	'confirmaccount-none-h' => 'Actualmente no hay solicitudes de cuenta en espera pendientes en este listado.',
	'confirmaccount-none-r' => 'Actualmente no hay solicitudes de cuenta en espera rechazadas recientemente en este listado.',
	'confirmaccount-none-e' => 'Actualmente no hay solicitudes de cuenta en espera expiradas en este listado.',
	'confirmaccount-real-q' => 'Nombre',
	'confirmaccount-email-q' => 'Correo electrónico',
	'confirmaccount-bio-q' => 'Biografía',
	'confirmaccount-showopen' => 'solicitudes abiertas',
	'confirmaccount-showrej' => 'solicitudes rechazadas',
	'confirmaccount-showexp' => 'solicitudes expiradas',
	'confirmaccount-review' => 'Revisar',
	'confirmaccount-types' => 'Seleccione una cola de confirmación de cuenta de abajo:',
	'confirmaccount-all' => '(mostrar todas las colas)',
	'confirmaccount-type' => 'Cola:',
	'confirmaccount-type-0' => 'autores futuros',
	'confirmaccount-type-1' => 'editores futuros',
	'confirmaccount-q-open' => 'solicitudes abiertas',
	'confirmaccount-q-rej' => 'solicitudes recientemente rechazadas',
	'confirmaccount-q-stale' => 'solicitudes expiradas',
	'confirmaccount-leg-user' => 'Cuenta de usuario',
	'confirmaccount-leg-areas' => 'Principales áreas de interés',
	'confirmaccount-leg-person' => 'Información personal',
	'confirmaccount-leg-other' => 'Otra información',
	'confirmaccount-name' => 'Nombre de usuario',
	'confirmaccount-real' => 'Nombre:',
	'confirmaccount-email' => 'Correo electrónico:',
	'confirmaccount-reqtype' => 'Posición:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografía:',
	'confirmaccount-attach' => 'Solicitud/Currículum:',
	'confirmaccount-notes' => 'Notas adicionales:',
	'confirmaccount-urls' => 'Lista de sitios web:',
	'confirmaccount-none-p' => '(no proveído)',
	'confirmaccount-econf' => '(confirmado)',
	'confirmaccount-reject' => '(rechazado por [[User:$1|$1]] en $2)',
	'confirmaccount-noreason' => '(ninguna)',
	'confirmaccount-held' => '(marcado "en suspenso" por [[User:$1|$1]] de $2)',
	'confirmaccount-create' => 'Aceptar (crear cuenta)',
	'confirmaccount-deny' => 'Rechazar (eliminar de lista)',
	'confirmaccount-hold' => 'Mantener',
	'confirmaccount-spam' => 'Spam (no enviar correo electrónico)',
	'confirmaccount-reason' => 'Comentario (será incluido en el correo eectrónico):',
	'confirmaccount-ip' => 'Dirección IP:',
	'confirmaccount-submit' => 'Confirmar',
	'confirmaccount-acc' => 'Solicitud de cuenta confirmada exitosamente;
creada nueva cuenta de usuario [[User:$1|$1]].',
	'confirmaccount-rej' => 'Solicitud de cuenta rechazada exitosamente.',
	'confirmaccount-viewing' => '(actualmente siendo visto por [[User:$1|$1]])',
	'confirmaccount-summary' => 'Creando página de usuario con biografía del nuevo usuario.',
	'confirmaccount-welc' => "'''Bienvenido a ''{{SITENAME}}''!'''
Esperamos que contribuyas mucho y bien.
Probablemente desearás leer las [[{{MediaWiki:Helppage}}|páginas de ayuda]].
Nuevamente, bienvenido y diviértete!",
	'confirmaccount-wsum' => 'Bienvenido!',
	'confirmaccount-email-subj' => '{{SITENAME}} solicitud de cuenta',
	'confirmaccount-email-body' => 'Tu solicitud para una cuenta ha sido aprobada en {{SITENAME}}.

Nombre de cuenta: $1

Contraseña: $2

Por razones de seguridad necesitarás cambiar tu contraseña en la primera sesión. Para iniciar sesión, por favor vaya a {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Tu solicitud para una cuenta ha sido aprobada en {{SITENAME}}.

Nombre de cuenta: $1

Contraseña: $2

$3

Por razones de seguridad necesitarás cambiar tu contraseña en la primera sesión. Para iniciar sesión, por favor vaya a {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Disculpa, tu solicitud para una cuenta "$1" ha sido rechazada en {{SITENAME}}.

Hay muchas razones para que esto ocurra.
Puedes no haber llenado el formulario correctamente, no proveíste una longitud adecuada en tus respuestas, o de lo contrario no has cumplido con algunos criterios de la política.
Puede haber listas de contacto en este sitio que puedas usar si deseas conocer más acerca de la política de cuenta de usuario.',
	'confirmaccount-email-body4' => 'Disculpa, tu solicitud para una cuenta "$1" ha sido rechazada en {{SITENAME}}.

$2

Puede haber listas de contacto en este sitio que puedas usar si deseas conocer más acerca de la política de cuenta de usuario.',
	'confirmaccount-email-body5' => 'Antes que tu solicitud para una cuenta "$1" pueda ser aceptada en {{SITENAME}} debes primero proveer alguna información adicional.

$2

Puede haber listas de contacto en este sitio que puedes usar si deseas conocer más acerca de la política de cuenta de usuario.',
	'usercredentials' => 'Credenciales de usuario',
	'usercredentials-user' => 'Nombre de usuario:',
	'usercredentials-leg-user' => 'Cuenta de usuario',
	'usercredentials-leg-areas' => 'Principales áreas de interés',
	'usercredentials-leg-person' => 'Información personal',
	'usercredentials-leg-other' => 'Otra información',
	'usercredentials-email' => 'Correo electrónico:',
	'usercredentials-real' => 'Nombre real:',
	'usercredentials-bio' => 'Biografía:',
	'usercredentials-attach' => 'Solicitud/Currículum:',
	'usercredentials-notes' => 'Notas adicionales:',
	'usercredentials-urls' => 'Lista de sitios web:',
	'usercredentials-ip' => 'Dirección IP original:',
	'usercredentials-member' => 'Derechos:',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'requestaccount-leg-user' => 'Kasutajakonto',
	'requestaccount-leg-areas' => 'Põhilised huvivaldkonnad',
	'requestaccount-leg-person' => 'Personaalne informatsioon',
	'requestaccount-leg-other' => 'Muu informatsioon',
	'requestaccount-real' => 'Tegelik nimi:',
	'requestaccount-same' => '(sama mis tegelik nimi)',
	'requestaccount-email' => 'E-posti aadress:',
	'requestaccount-reqtype' => 'Positsioon:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'toimetaja',
	'requestaccount-info' => '(?)',
	'requestaccount-bio' => 'Personaalne biograafia:',
	'requestaccount-attach' => 'Resümee või CV (valikuline):',
	'requestaccount-notes' => 'Lisainfo:',
	'confirmaccount-real-q' => 'Nimi',
	'confirmaccount-email-q' => 'E-post',
	'confirmaccount-bio-q' => 'Biograafia',
	'confirmaccount-leg-person' => 'Personaalne informatsioon',
	'confirmaccount-leg-other' => 'Muu informatsioon',
	'confirmaccount-name' => 'Kasutajanimi',
	'confirmaccount-real' => 'Nimi:',
	'confirmaccount-email' => 'E-post:',
	'confirmaccount-reqtype' => 'Positsioon:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'toimetaja',
	'confirmaccount-bio' => 'Biograafia:',
	'confirmaccount-attach' => 'Resümee/CV:',
	'confirmaccount-notes' => 'Lisainfo:',
	'confirmaccount-econf' => '(kinnitatud)',
	'confirmaccount-noreason' => '(ei midagi)',
	'confirmaccount-ip' => 'IP-aadress:',
	'confirmaccount-submit' => 'Kinnita',
	'confirmaccount-wsum' => 'Tere tulemast!',
	'usercredentials-user' => 'Kasutajanimi:',
	'usercredentials-leg-user' => 'Kasutajakonto',
	'usercredentials-leg-areas' => 'Peamised huvialad',
	'usercredentials-leg-person' => 'Personaalne informatsioon',
	'usercredentials-leg-other' => 'Muu informatsioon',
	'usercredentials-email' => 'E-post:',
	'usercredentials-real' => 'Tegelik nimi:',
	'usercredentials-bio' => 'Biograafia:',
	'usercredentials-attach' => 'Resümee/CV:',
	'usercredentials-notes' => 'Lisainfo:',
	'usercredentials-ip' => 'Originaalne IP-aadress:',
	'usercredentials-member' => 'Õigused:',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'requestaccount-leg-user' => 'Erabiltzaile kontua',
	'requestaccount-leg-person' => 'Norberaren informazioa',
	'requestaccount-leg-other' => 'Bestelako informazioa',
	'requestaccount-real' => 'Benetako izena:',
	'requestaccount-email' => 'Email helbidea:',
	'requestaccount-level-0' => 'egilea',
	'requestaccount-bio' => 'Norberaren biografia:',
	'requestaccount-attach' => 'Curriculuma (hautazkoa):',
	'confirmaccount-real-q' => 'Izena',
	'confirmaccount-email-q' => 'Emaila',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'irekitako eskariak',
	'confirmaccount-showrej' => 'gaitzestutako eskariak',
	'confirmaccount-showexp' => 'iraungitako eskariak',
	'confirmaccount-leg-person' => 'Norberaren informazioa',
	'confirmaccount-leg-other' => 'Bestelako informazioa',
	'confirmaccount-name' => 'Erabiltzaile izena',
	'confirmaccount-real' => 'Izena:',
	'confirmaccount-email' => 'Emaila:',
	'confirmaccount-pos-0' => 'egilea',
	'confirmaccount-bio' => 'Biografia:',
	'confirmaccount-attach' => 'Curriculuma:',
	'confirmaccount-urls' => 'Webgune zerrenda:',
	'confirmaccount-create' => 'Onartu (kontua sortu)',
	'confirmaccount-ip' => 'IP helbidea:',
	'confirmaccount-submit' => 'Baieztatu',
	'confirmaccount-wsum' => 'Ongi etorri!',
	'usercredentials-user' => 'Erabiltzaile izena:',
	'usercredentials-leg-person' => 'Norberaren informazioa',
	'usercredentials-email' => 'Emaila:',
	'usercredentials-real' => 'Benetako izena:',
	'usercredentials-bio' => 'Biografia:',
	'usercredentials-attach' => 'Curriculuma:',
	'usercredentials-urls' => 'Webgune zerrenda:',
	'usercredentials-ip' => 'Jatorrizko IP helbidea:',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'requestaccount-real' => 'Nombri verdaeru:',
	'confirmaccount-name' => 'Nombri d´usuáriu',
	'confirmaccount-real' => 'Nombri',
	'confirmaccount-wsum' => 'Bienviniu!',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Mobe
 * @author Nike
 * @author Str4nd
 * @author Taleman
 * @author Varusmies
 */
$messages['fi'] = array(
	'requestaccount' => 'Pyydä käyttäjätunnusta',
	'requestaccount-text' => "'''Pyydä käyttäjätunnusta täyttämällä ja lähettämällä alla oleva lomake'''.

Muista ennen käyttäjätunnuksen pyytämistä lukea [[{{MediaWiki:Requestaccount-page}}|käyttöehdot]].

Saat sähköpostilla ilmoituksen, kun tunnus on hyväksytty ja sillä voi [[Special:UserLogin|kirjautua sisään]].",
	'requestaccount-page' => '{{ns:project}}:Käyttöehdot',
	'requestaccount-dup' => "'''Huomio: Olet jo kirjautuneena rekisteröidyllä käyttäjätunnuksella.'''",
	'requestaccount-leg-user' => 'Käyttäjätunnus',
	'requestaccount-leg-areas' => 'Tärkeimmät kiinnostuksen kohteet',
	'requestaccount-leg-person' => 'Henkilötiedot',
	'requestaccount-leg-other' => 'Muut tiedot',
	'requestaccount-leg-tos' => 'Käyttöehdot',
	'requestaccount-acc-text' => 'Lähetettyäsi pyynnön saat sähköpostitse vahvistuksen. Sinun pitää napsauttaa sähköpostissa olevaa kuittauslinkkiä. Myöskin salasanasi lähetetään sinulle, kun tunnus luodaan.',
	'requestaccount-areas-text' => 'Valitse alta alueet, joissa olet asiantuntija tai joiden parissa haluaisit enimmäkseen työskennellä.',
	'requestaccount-ext-text' => 'Seuraavat tiedot pidetään luottamuksellisina ja niitä käytetään vain tämän pyynnön käsittelyssä.
Haluat ehkä antaa tunnistamista helpottavia yhteystietoja, puhelinnumeron esimerkiksi.',
	'requestaccount-bio-text' => 'Kuvauksestasi tulee käyttäjäsivusi oletussisältö.
Kirjoita omiin tietoihisi erikoisosaamisistasi ja pätevyyksistäsi. Muista, että nämä tiedot julkaistaan.
Voit muuttaa nimeäsi [[Special:Preferences|asetussivulla]].',
	'requestaccount-real' => 'Oikea nimi:',
	'requestaccount-same' => '(sama kuin oikea nimi)',
	'requestaccount-email' => 'Sähköpostiosoite:',
	'requestaccount-reqtype' => 'Asema:',
	'requestaccount-level-0' => 'kirjoittaja',
	'requestaccount-level-1' => 'ylläpitäjä',
	'requestaccount-bio' => 'Kuvaus itsestäsi:',
	'requestaccount-attach' => 'Ansioluettelo tai CV (vapaaehtoinen):',
	'requestaccount-notes' => 'Lisähuomautukset:',
	'requestaccount-urls' => 'Webbisivujen luettelo, jos on (yksi per rivi):',
	'requestaccount-agree' => 'Vahvista, etä antamasi oikea nimesi on oikea ja että hyväksyt käyttöehdot.',
	'requestaccount-inuse' => 'Käyttäjätunnusta on jo pyydetty toisessa käsiteltävänä olevassa käyttäjätunnuspyynnössä.',
	'requestaccount-tooshort' => 'Kuvauksesi pituuden on oltava vähintään $1 {{PLURAL:$1|sana|sanaa}}.',
	'requestaccount-emaildup' => 'Samaa sähköpostiosoitetta on käytetty toisessa parhailaan käsiteltävänä olevassa käyttäjätunnuspyynnössä.',
	'requestaccount-exts' => 'Liitetiedosto ei ole sallittua tyyppiä.',
	'requestaccount-resub' => 'Tietoturvasyistä antamasi ansioluettelo/CV-tiedosto on valittava uudestaan.
Jätä kenttä tyhjäksi, jos et enää halua liittää tiedostoa.',
	'requestaccount-tos' => "Olen lukenut ja hyväksyn {{GRAMMAR:genitive|{{SITENAME}}}} [[{{MediaWiki:Requestaccount-page}}|käyttöehdot]].
Kohdasssa ''Oikea nimi'' olen antanut oman virallisen nimeni.",
	'requestaccount-submit' => 'Pyydä käyttäjätunnusta',
	'requestaccount-sent' => 'Käyttäjätunnuspyyntösi on lähetetty onnistuneesti ja odottaa nyt käsittelyä.
Vahvistusviesti on lähetetty sähköpostiosoitteeseesi.',
	'request-account-econf' => 'Sähköpostiosoitteesi on tarkistettu ja merkitään tarkistetuksi käyttäjätunnuspyyntöösi.',
	'requestaccount-email-subj' => '{{SITENAME}}: sähköpostiosoitteen tarkistus',
	'requestaccount-email-body' => 'Joku, luultavasti sinä itse IP-osoitteesta $1, on pyytänyt käyttäjätunnusta "$2" sivustoon {{SITENAME}} ja käyttänyt tätä sähköpostiosoitetta.

Vahvista, että tämä käyttäjätunnus sivustolle {{SITENAME}} kuuluu sinulle avaamalla tämä osoite selaimessasi:

$3

Jos käyttäjätunnus luodaan, salasana lähetetään vain sinulle. Jos et ole pyytänyt käyttäjätunnusa, *älä* avaa osoitetta.
Tämän vahvistuskoodi vanhenee $4.',
	'requestaccount-email-subj-admin' => 'Sivuston {{SITENAME}} käyttäjätunnuspyyntö',
	'requestaccount-email-body-admin' => '”$1” on pyytänyt käyttäjätunnusta ja odottaa vahvistusta.
Sähköpostiosoite on tarkistettu. Myönnä käyttäjätunnus tästä: $2.',
	'acct_request_throttle_hit' => 'Valitettavasti et voi tehdä enempää pyyntöjä, koska olet jo pyytänyt {{PLURAL:$1|yhden käyttäjätunnuksen|$1 käyttäjätunnusta}}.',
	'requestaccount-loginnotice' => "Saadaksesi käyttäjätunnuksen on tehtävä '''[[Special:RequestAccount|käyttäjätunnuspyyntö]]'''.",
	'confirmaccount-newrequests' => "Nyt on '''$1''' {{PLURAL:$1|avoin|avointa}} {{PLURAL:$1|[[Special:ConfirmAccounts|pyyntö]]|[[Special:ConfirmAccounts|pyyntöä]]}} käsiteltävänä.",
	'confirmaccounts' => 'Myönnä käyttäjätunnuksia.',
	'confirmedit-desc' => 'Byrokraatit saavat oikeuden myöntää käyttäjätunnuksia.',
	'confirmaccount-maintext' => "'''Tällä sivulla myönnetään käyttäjätunnuksia sivustolle \"{{SITENAME}}\"'''.

Jokaisessa pyyntöjonossa on kolme alijonoa, käsittelemättömille pyynnöille,
muiden byrokraattien lisätietoja odottamaan pysäyttämille pyynnöille ja
kolmas hiljattain hylätyille pyynnöille.

Tarkista pyyntö huolellisesti ennen vastaamista ja vahvista pyynnön tiedot tarvittaessa.
Toimenpiteesi kirjoitetaan yksityiseen lokiin. Tarkoitus on valvoa kaikkia täällä tehtäviä
toimia omien puuhiesi lisäksi.",
	'confirmaccount-list' => 'Alla on luettelo hyväksymistä odottavista pyynnöistä.
Hyväksytyt käyttäjätunnukset luodaan ja poistetaan luettelosta. Hylätyt pyynnöt vain poistetaan luettelosta.',
	'confirmaccount-list2' => 'Alla on luettelo hiljattain hylätyistä pyynnöistä jotka voidaan poistaa automaattisesti, kun ne ovat useiden päivien ikäisiä.
Ne voidaan vieläkin hyväksyä käyttäjätunnuksiksi, mutta neuvottelethan ensin hylkäyksen tehneen ylläpitäjän kanssa.',
	'confirmaccount-list3' => 'Alla on luettelo vanhentuneista tunnuspyynnöistä, jotka poistetaan automaattisesti muutaman päivän kuluttua.
Nämä voidaan vielä hyväksyä tunnuksiksi.',
	'confirmaccount-text' => "Tämä on käsittelyä odottava käyttäjätunnuspyyntö sivustolle '''{{SITENAME}}'''.

Tarkista alla olevat tiedot huolellisesti. Jos olet hyväksymässä tätä pyyntöä, aseta käyttäjän asema pudotusvalikosta.
Pyytäjän omien tietojen muokkaaminen ei vaikuta pysyviin pätevyystietoihin. Huomaa voivasi muuttaa luotavan käyttäjätunnuksen. Käytä tätä vain nimiyhteentörmäysten välttämiseen.

Jos jätät tämän sivun vahvistamatta tai hylkäämättä pyyntöä, se jää odottamaan käsittelyä.",
	'confirmaccount-none-o' => 'Tässä luettelossa ei ole nyt yhtään käsiteltävänä olevaa pyyntöä.',
	'confirmaccount-none-h' => 'Tässä luettelossa ei ole nyt yhtään pysäytettyä käsiteltävänä olevaa pyyntöä.',
	'confirmaccount-none-r' => 'Täss luettelossa ei ole nyt yhtään äskettäin hylättyä pyyntöä.',
	'confirmaccount-none-e' => 'Tällä hetkellä listalla ei ole yhtään vanhentunutta tunnuspyyntöä.',
	'confirmaccount-real-q' => 'Nimi',
	'confirmaccount-email-q' => 'Sähköposti',
	'confirmaccount-bio-q' => 'Omat tiedot',
	'confirmaccount-showopen' => 'avoimet pyynnöt',
	'confirmaccount-showrej' => 'hylätyt pyynnöt',
	'confirmaccount-showheld' => 'Katso luettelo käsiteltävänä olevista pyynnöistä',
	'confirmaccount-showexp' => 'pyyntö vanhentunut',
	'confirmaccount-review' => 'Tarkista',
	'confirmaccount-types' => 'Valitse vahvistettavien pyyntöjen jono alla olevista:',
	'confirmaccount-all' => '(näytä kaikki jonot)',
	'confirmaccount-type' => 'Valittu jono:',
	'confirmaccount-type-0' => 'kirjoittajaehdokkaat',
	'confirmaccount-type-1' => 'toimittajaehdokkaat',
	'confirmaccount-q-open' => 'avoimet pyynnöt',
	'confirmaccount-q-held' => 'pysäytetyt pyynnöt',
	'confirmaccount-q-rej' => 'äskettäin hylätyt pyynnöt',
	'confirmaccount-q-stale' => 'vanhuneet pyynnöt',
	'confirmaccount-badid' => 'Annettua tunnistetta vastavaa käsiteltävänä olevaa pyyntöä ei ole.
Se voi olla jo käsitelty.',
	'confirmaccount-leg-user' => 'Käyttäjätunnus',
	'confirmaccount-leg-areas' => 'Tärkeimmät kiinnostuksen kohteet',
	'confirmaccount-leg-person' => 'Henkilötiedot',
	'confirmaccount-leg-other' => 'Muut tiedot',
	'confirmaccount-name' => 'Käyttäjätunnus',
	'confirmaccount-real' => 'Nimi:',
	'confirmaccount-email' => 'Sähköpostiosoite:',
	'confirmaccount-reqtype' => 'Asema:',
	'confirmaccount-pos-0' => 'kirjoittaja',
	'confirmaccount-pos-1' => 'toimittaja',
	'confirmaccount-bio' => 'Omat tiedot:',
	'confirmaccount-attach' => 'Ansioluettelo/CV:',
	'confirmaccount-notes' => 'Lisätietoja:',
	'confirmaccount-urls' => 'Luettelo webbisivuista:',
	'confirmaccount-none-p' => '(ei annettu)',
	'confirmaccount-confirm' => 'Hyväksy, hylkää tai pysäytä tämä pyyntö alla olevilla valinnoilla:',
	'confirmaccount-econf' => '(tarkistettu)',
	'confirmaccount-reject' => '(hylätty, hylkääjänä [[User:$1|$1]] osoitteesta $2)',
	'confirmaccount-rational' => 'Hakijalle kerrotut perustelut:',
	'confirmaccount-noreason' => '(ei mitään)',
	'confirmaccount-autorej' => '(tämä pyyntö on automaattisesti hylätty käyttämättömyyden vuoksi)',
	'confirmaccount-held' => '("pysäytetty", pysäyttäjänä [[User:$1|$1]] osoitteessa $2)',
	'confirmaccount-create' => 'Hyväksy (luo käyttäjätunnus)',
	'confirmaccount-deny' => 'Hylkää (poista jonosta)',
	'confirmaccount-hold' => 'Pysäytä',
	'confirmaccount-spam' => 'Roskaa (sähköpostia ei lähetetä)',
	'confirmaccount-reason' => 'Huomautus (liitetään sähköpostiin):',
	'confirmaccount-ip' => 'IP-osoite:',
	'confirmaccount-legend' => 'Vahvista/hylkää tämä tili',
	'confirmaccount-submit' => 'Vahvista',
	'confirmaccount-needreason' => 'Alla olevaan huomautuslaatikkoon on kirjoitettava perustelu.',
	'confirmaccount-canthold' => 'Tämä pyyntöf on jo joko pysäytetty tai poistettu.',
	'confirmaccount-acc' => 'Pyynnön vahvistaminen onnistui.
Käyttäjätunnus [[User:$1|$1]] luotiin.',
	'confirmaccount-rej' => 'Pyynnön hylkääminen onnistui.',
	'confirmaccount-viewing' => '(juuri nyt katseltavana käyttäjällä [[User:$1|$1]])',
	'confirmaccount-summary' => 'Luodaan uuden käyttäjän tiedot sisältävä käyttäjäsivu.',
	'confirmaccount-welc' => "'''Tervetuloa ''{{SITENAME}}''-sivustolle!''' Toivomme runsasta ja laadukasta kirjoittelua.
Haluat varmaan lukea [[{{MediaWiki:Helppage}}|ohjesivut]]. Vielä kerran tervetuloa ja pidä hauskaa!",
	'confirmaccount-wsum' => 'Tervetuloa!',
	'confirmaccount-email-subj' => 'Käyttäjätunnuspyyntö sivustolle {{SITENAME}}',
	'confirmaccount-email-body' => 'Pyytämäsi käyttäjätunnus sivulle {{SITENAME}} on hyväksytty.

Käyttäjätunnus: $1

Salasana: $2

Salasana on vaihdettava ensimmäisellä sisäänkirjautumiskerralla tietoturvasyistä. Kirjaudu sisään sivulla {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Pyytämäsi käyttäjätunnus sivulle {{SITENAME}} on hyväksytty.

Käyttäjätunnus: $1

Salasana: $2

$3

Salasana on vaihdettava ensimmäisellä sisäänkirjautumiskerralla tietoturvasyistä. Kirjaudu sisään sivulla {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Valitettavasti pyyntösi käyttäjätunnuksesta "$1" sivulle {{SITENAME}} on hylätty.

Hylkäämisen mahdollisia syitä on useita.
Lomaketta ei ehkä ole täytetty oikein, kuvaus ei ollut tarpeeksi pitkä tai joku muu toimintaperiaatteen ehdoista jäi täyttämättä.
Jos haluat tietää enemmän toimintaperiaatteista käyttäjätunnusten myöntämiseen saattaa sivuilla olla luettelo yhteystiedoista.',
	'confirmaccount-email-body4' => 'Valitettavasti pyyntösi käyttäjätunnuksesta "$1" sivulle {{SITENAME}} on hylätty.

$2

Jos haluat tietää enemmän toimintaperiaatteista käyttäjätunnusten myöntämiseen saattaa sivuilla olla luettelo yhteystiedoista.',
	'confirmaccount-email-body5' => 'Ennenkuin pyytämäsi käyttäjätunnus "$1" sivulle {{SITENAME}} voidaan hyväksyä tarvitaan lisätietoja.

$2

Jos haluat tietää enemmän toimintaperiaatteista käyttäjätunnuksesta myöntämiseen saattaa sivuilla olla luettelo yhteystiedoista.',
	'usercredentials' => 'Käyttäjän valtuudet',
	'usercredentials-leg' => 'Etsi käyttäjän vahvistetut valtuudet',
	'usercredentials-user' => 'Käyttäjätunnus',
	'usercredentials-text' => 'Valitun käyttäjätunnuksen vahvistetut valtuudet ovat alla.',
	'usercredentials-leg-user' => 'Käyttäjätunnus',
	'usercredentials-leg-areas' => 'Tärkeimmät kiinnostuksen kohteet',
	'usercredentials-leg-person' => 'Henkilötiedot',
	'usercredentials-leg-other' => 'Muut tiedot',
	'usercredentials-email' => 'Sähköposti:',
	'usercredentials-real' => 'Oikea nimi:',
	'usercredentials-bio' => 'Omat tiedot',
	'usercredentials-attach' => 'Ansioluettelo/CV:',
	'usercredentials-notes' => 'Lisähuomautukset:',
	'usercredentials-urls' => 'Webbisivujen luettelo:',
	'usercredentials-ip' => 'Käyttäjän IP-osoite:',
	'usercredentials-member' => 'Oikeudet:',
	'usercredentials-badid' => 'Tämän käyttäjän valtuutuksia ei löytynyt. Tarkista nimen oikeinkirjoitus.',
	'right-confirmaccount' => 'Nähdä [[Special:ConfirmAccounts|listan pyydetyistä tunnuksista]]',
	'right-requestips' => 'Nähdä hakijan IP-osoitteet käyttäjätilejä käsiteltäessä',
	'right-lookupcredentials' => 'Nähdä [[Special:UserCredentials|käyttäjän luotettavuustiedot]]',
);

/** French (Français)
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Louperivois
 * @author Meithal
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 * @author Zetud
 */
$messages['fr'] = array(
	'requestaccount' => 'Demande de compte utilisateur',
	'requestaccount-text' => "'''Remplissez et envoyez le formulaire ci-dessous pour demander un compte d’utilisateur'''. 
	
Assurez-vous d'avoir lu [[{{MediaWiki:Requestaccount-page}}|les conditions d’utilisation]] avant de faire votre demande de compte.
	
Une fois que le compte est accepté, vous recevrez un courriel de notification et votre compte pourra être utilisé sur [[Special:UserLogin|la page de connexion]].",
	'requestaccount-page' => "{{ns:project}}:Conditions d'utilisation",
	'requestaccount-dup' => "'''Note : Vous êtes déjà sur une session avec un compte enregistré.'''",
	'requestaccount-leg-user' => 'Compte utilisateur',
	'requestaccount-leg-areas' => "Centres d'intérêts principaux",
	'requestaccount-leg-person' => 'Informations personnelles',
	'requestaccount-leg-other' => 'Autres informations',
	'requestaccount-leg-tos' => "Conditions d'utilisation",
	'requestaccount-acc-text' => 'Un message de confirmation sera envoyé à votre adresse électronique une fois que la demande aura été envoyée. Dans le courrier reçu, cliquez sur le lien correspondant à la confirmation de votre demande. Aussi, un mot de passe sera envoyé par courriel quand votre compte sera créé.',
	'requestaccount-areas-text' => 'Choisissez les domaines dans lesquels vous avez une expertise démontrée, ou dans lesquels vous êtes enclin à contribuer le plus.',
	'requestaccount-ext-text' => 'L’information suivante reste privée et ne pourra être utilisée que pour cette requête. 
	Vous avez la possibilité de lister des contacts tels qu’un numéro de téléphone pour obtenir une assistance pour confirmer votre identité.',
	'requestaccount-bio-text' => 'Votre biographie sera mise par défaut sur votre page utilisateur. Essayez d’y mettre vos recommandations. Assurez-vous que vous pouvez diffuser sans crainte les informations. Votre nom peut être changé en utilisant [[Special:Preferences]].',
	'requestaccount-real' => 'Nom réel :',
	'requestaccount-same' => '(nom figurant dans votre état civil)',
	'requestaccount-email' => 'Adresse électronique :',
	'requestaccount-reqtype' => 'Situation :',
	'requestaccount-level-0' => 'auteur',
	'requestaccount-level-1' => 'contributeur',
	'requestaccount-bio' => 'Biographie personnelle :',
	'requestaccount-attach' => 'CV (facultatif) :',
	'requestaccount-notes' => 'Notes supplémentaires :',
	'requestaccount-urls' => "Liste des sites Web. S'il y en a plusieurs, séparez-les par un saut de ligne :",
	'requestaccount-agree' => 'Vous devez certifier que votre nom réel est correct et que vous acceptez les conditions d’utilisation.',
	'requestaccount-inuse' => 'Le nom d’utilisateur est déjà utilisé dans une requête en cours d’approbation.',
	'requestaccount-tooshort' => 'Votre biographie doit avoir au moins $1 mot{{PLURAL:$1||s}}.',
	'requestaccount-emaildup' => 'Une autre demande en cours utilise la même adresse électronique.',
	'requestaccount-exts' => 'Le type du fichier joint n’est pas permis.',
	'requestaccount-resub' => 'Veuillez sélectionner à nouveau votre curriculum vitæ pour des raisons de sécurité. Si vous ne souhaitez plus inclure celui-ci, laissez ce champ vierge.',
	'requestaccount-tos' => 'J’ai lu et j’accepte les [[{{MediaWiki:Requestaccount-page}}|conditions d’utilisation]] de {{SITENAME}}.',
	'requestaccount-submit' => 'Demande de compte utilisateur',
	'requestaccount-sent' => 'Votre demande de compte utilisateur a été envoyée avec succès et a été mise dans la liste d’attente d’approbation.
Un courriel de confirmation a été envoyé à votre adresse de courriel.',
	'request-account-econf' => 'Votre adresse courriel a été confirmée et sera listée telle quelle dans votre demande de compte.',
	'requestaccount-email-subj' => "Confirmation de l'adresse de courriel pour {{SITENAME}}",
	'requestaccount-email-body' => 'Quelqu’un, probablement vous, a formulé, depuis l’adresse IP $1, une demande de compte utilisateur « $2 » avec cette adresse courriel sur {{SITENAME}}.

Pour confirmer que ce compte vous appartient réellement sur {{SITENAME}}, vous êtes prié{{GENDER:||e|(e)}} d’ouvrir ce lien dans votre navigateur :

$3

Votre mot de passe vous sera envoyé uniquement si votre compte est créé.
Si tel n’était pas le cas, n’utilisez pas ce lien.
Ce code de confirmation expirera le $4.',
	'requestaccount-email-subj-admin' => 'Demande de compte sur {{SITENAME}}',
	'requestaccount-email-body-admin' => "« $1 » a demandé un compte et se trouve en attente de confirmation.

L'adresse courriel a été confirmée. Vous pouvez approuver la demande ici « $2 ».",
	'acct_request_throttle_hit' => 'Désolé, vous avez déjà demandé $1 compte{{PLURAL:$1||s}}.
Vous ne pouvez plus faire de demande.',
	'requestaccount-loginnotice' => "Pour obtenir un compte utilisateur, vous devez en faire '''[[Special:RequestAccount|la demande]]'''.",
	'confirmaccount-newrequests' => "Il y a actuellement '''$1''' [[Special:ConfirmAccounts|demande{{PLURAL:$1||s}} de compte]] en cours.",
	'confirmaccounts' => 'Demande de confirmation de comptes',
	'confirmedit-desc' => 'Donne aux bureaucrates la possibilité de confirmer les demandes de comptes d’utilisateurs',
	'confirmaccount-maintext' => "'''Cette page est utilisée pour confirmer les demandes de compte utilisateur sur ''{{SITENAME}}'''''.

Chaque demande de compte utilisateur consiste en trois sous-listes : une pour les demandes non traitées, une pour les comptes réservés dans l'attente de plus amples informations, et une dernière pour les comptes récemment rejetés.

Lors de la réponse à une demande, vérifiez-la attentivement et, le cas échéant, confirmez les informations qui y sont mentionnées. Vos actions seront inscrites séparément dans un journal. Vous devez aussi vérifier l'activité sur {{SITENAME}} en plus de la vôtre.",
	'confirmaccount-list' => 'Voici, ci-dessous, la liste des comptes en attente d’approbation. Les comptes acceptés seront créés et retirés de cette liste. Les comptes rejetés seront supprimés de cette même liste.',
	'confirmaccount-list2' => 'Voici la liste des comptes récemment rejetés lesquels seront supprimés automatiquement après quelques jours. Ils peuvent encore être approuvés, aussi vous pouvez consulter les rejets avant de le faire.',
	'confirmaccount-list3' => 'Ci-dessous se trouve une liste de comptes expirés qui pourraient être automatiquement supprimés après quelques jours. Ils peuvent encore être approuvés.',
	'confirmaccount-text' => "Voici une demande en cours pour un compte utilisateur sur '''{{SITENAME}}'''.

Vérifiez soigneusement toutes les informations ci-dessous. Si vous approuvez cette demande, sélectionnez la situation à donner à l'utilisateur. Les changements apportés aux biographies de l'application n'affecteront pas les références permanentes déjà stockées.

Notez que vous pouvez choisir de créer un compte sous un autre nom. Faites ceci uniquement pour éviter des conflits avec d’autres.

Si vous quittez cette page sans confirmer ou rejeter cette demande, elle restera en attente.",
	'confirmaccount-none-o' => "Il n'y a actuellement aucune demande de compte utilisateur en cours dans cette liste.",
	'confirmaccount-none-h' => "Il n'y a actuellement aucune réservation de compte utilisateur en cours dans cette liste.",
	'confirmaccount-none-r' => "Il n'y a actuellement aucun rejet récent de demande de compte utilisateur dans cette liste.",
	'confirmaccount-none-e' => "Il n'y a actuellement aucune requête de compte expirée dans la liste.",
	'confirmaccount-real-q' => 'Nom',
	'confirmaccount-email-q' => 'Courriel',
	'confirmaccount-bio-q' => 'Biographie',
	'confirmaccount-showopen' => 'Requêtes ouvertes',
	'confirmaccount-showrej' => 'Requêtes rejetées',
	'confirmaccount-showheld' => 'Voir la liste des comptes réservés en cours de traitement',
	'confirmaccount-showexp' => 'Requêtes expirées',
	'confirmaccount-review' => 'Approbation/Rejet',
	'confirmaccount-types' => "Sélectionnez un compte dans la liste d'attente ci-dessous :",
	'confirmaccount-all' => "(Voir toutes les listes d'attente)",
	'confirmaccount-type' => "Liste d'attente sélectionnée :",
	'confirmaccount-type-0' => 'auteurs éventuels',
	'confirmaccount-type-1' => 'contributeurs éventuels',
	'confirmaccount-q-open' => 'demandes faites',
	'confirmaccount-q-held' => 'demandes mises en attente',
	'confirmaccount-q-rej' => 'demandes rejetées récemment',
	'confirmaccount-q-stale' => 'Requêtes expirées',
	'confirmaccount-badid' => 'Il n’y a aucune demande en cours correspondant à l’ID indiqué. Il est possible qu‘il ait subi une maintenance.',
	'confirmaccount-leg-user' => 'Compte utilisateur',
	'confirmaccount-leg-areas' => "Centres d'intérêts principaux",
	'confirmaccount-leg-person' => 'Informations personnelles',
	'confirmaccount-leg-other' => 'Autres informations',
	'confirmaccount-name' => 'Nom d’utilisateur',
	'confirmaccount-real' => 'Nom :',
	'confirmaccount-email' => 'Courriel :',
	'confirmaccount-reqtype' => 'Situation :',
	'confirmaccount-pos-0' => 'auteur',
	'confirmaccount-pos-1' => 'contributeur',
	'confirmaccount-bio' => 'Biographie :',
	'confirmaccount-attach' => 'CV :',
	'confirmaccount-notes' => 'Notes supplémentaires :',
	'confirmaccount-urls' => 'Liste des sites web :',
	'confirmaccount-none-p' => '(non pourvu)',
	'confirmaccount-confirm' => 'Utilisez les boutons ci-dessous pour accepter ou rejeter la demande.',
	'confirmaccount-econf' => '(confirmé)',
	'confirmaccount-reject' => '(rejeté par [[User:$1|$1]] le $2)',
	'confirmaccount-rational' => 'Motif donné au candidat',
	'confirmaccount-noreason' => '(néant)',
	'confirmaccount-autorej' => '(Cette requête a été abandonnée automatiquement pour cause d’inactivité)',
	'confirmaccount-held' => 'Marqué « réservé » par [[User:$1|$1]] sur $2',
	'confirmaccount-create' => 'Approbation (crée le compte)',
	'confirmaccount-deny' => 'Rejet (supprime le compte)',
	'confirmaccount-hold' => 'Réservé',
	'confirmaccount-spam' => 'Pourriel (n’envoyez pas de courriel)',
	'confirmaccount-reason' => 'Commentaire (figurera dans le courriel) :',
	'confirmaccount-ip' => 'Adresse IP',
	'confirmaccount-legend' => 'Confirmer ce compte',
	'confirmaccount-submit' => 'Confirmation',
	'confirmaccount-needreason' => 'Vous devez indiquer un motif dans le cadre ci-après.',
	'confirmaccount-canthold' => 'Cette requête est déjà, soit prise en compte, soit supprimée.',
	'confirmaccount-acc' => 'La demande de compte a été confirmée avec succès ; création du nouvel utilisateur [[User:$1]].',
	'confirmaccount-rej' => 'La demande a été rejetée avec succès.',
	'confirmaccount-viewing' => "(actuellement en train d'être visionné par [[User:$1|$1]])",
	'confirmaccount-summary' => 'Création de la page utilisateur avec sa biographie.',
	'confirmaccount-welc' => "'''Bienvenue sur ''{{SITENAME}}'' !''' Nous espérons que vous contribuerez en quantité et en qualité. Vous désirerez, peut-être, lire [[{{MediaWiki:Helppage}}|les pages d'aide]]. Bienvenue encore et bonne contribution !
<nowiki>~~~~</nowiki>",
	'confirmaccount-wsum' => 'Bienvenue !',
	'confirmaccount-email-subj' => 'Demande de compte sur {{SITENAME}}',
	'confirmaccount-email-body' => 'Votre demande de compte a été acceptée sur {{SITENAME}}.

Nom du compte utilisateur : $1

Mot de passe : $2

Pour des raisons de sécurité, vous devrez changer votre mot de passe lors de votre première connexion. Pour vous connecter, allez sur
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Votre demande de compte utilisateur a été acceptée sur {{SITENAME}}.

Nom du compte utilisateur : $1

Mot de passe: $2

$3

Pour des raisons de sécurité, vous devrez changer votre mot de passe lors de votre première connexion. Pour vous connecter, allez sur 
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Désolé, votre demande de compte utilisateur « $1 » a été rejetée sur {{SITENAME}}.

Plusieurs raisons peuvent expliquer ce cas de figure. Il est possible que vous ayez mal rempli le formulaire, ou que vous n’ayez pas indiqué suffisamment d’informations dans vos réponses. Il est encore possible que vous ne remplissiez pas les critères d’éligibilité pour obtenir votre compte. Il est possible d’être sur la liste des contacts si vous désirez mieux connaître les conditions requises.',
	'confirmaccount-email-body4' => "Désolé, votre demande de compte utilisateur « $1 » a été rejetée sur {{SITENAME}}.

$2

Il peut y avoir des listes de contacts sur le site que vous pourrez consulter pour en savoir plus à propos des règles d'inscription.",
	'confirmaccount-email-body5' => 'Avant que votre requête pour le compte « $1 » ne puisse être acceptée sur {{SITENAME}}, vous devez fournir quelques informations supplémentaires.

$2

Ceci permet d’être sur la liste des contacts du site, si vous désirez en savoir plus sur les règles concernant les comptes.',
	'usercredentials' => "Références de l'utilisateur",
	'usercredentials-leg' => "Vérification confirmée des références d'un utilisateur.",
	'usercredentials-user' => "Nom d'utilisateur :",
	'usercredentials-text' => 'Ci-dessous figurent les justificatifs validés pour le compte utilisateur sélectionné.',
	'usercredentials-leg-user' => 'Compte utilisateur',
	'usercredentials-leg-areas' => "Centres d'intérêts principaux",
	'usercredentials-leg-person' => 'Informations personnelles',
	'usercredentials-leg-other' => 'Autres informations',
	'usercredentials-email' => 'Courriel :',
	'usercredentials-real' => 'Nom réel :',
	'usercredentials-bio' => 'Biographie :',
	'usercredentials-attach' => 'CV :',
	'usercredentials-notes' => 'Notes supplémentaires :',
	'usercredentials-urls' => 'Liste des sites internet :',
	'usercredentials-ip' => 'Adresse IP initiale :',
	'usercredentials-member' => 'Droits :',
	'usercredentials-badid' => 'Aucune référence trouvée pour cet utilisateur. Véfifiez que le nom soit bien rédigé.',
	'right-confirmaccount' => 'Voir la [[Special:ConfirmAccounts|file des demandes de compte]]',
	'right-requestips' => 'Voir les adresses IP des demandeurs lors du traitement des demandes de nouveau comptes',
	'right-lookupcredentials' => 'Voir les [[Special:UserCredentials|références des utilisateurs]]',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'requestaccount' => 'Demanda de compto utilisator',
	'requestaccount-text' => "'''Rempléd et pués mandâd lo formulèro ce-desot por demandar un compto utilisator.'''

Assurâd-vos que vos éd ja liesu les [[{{MediaWiki:Requestaccount-page}}|condicions d’usâjo]] devant que fâre voutra demanda de compto utilisator.

Setout que lo compto est accèptâ, vos recevréd un mèssâjo de notificacion et pués voutron compto utilisator porrat étre utilisâ sur la [[Special:UserLogin|pâge de branchement]].",
	'requestaccount-page' => '{{ns:project}}:Condicions d’usâjo',
	'requestaccount-dup' => "'''Nota : vos éte ja sur una sèance avouéc un compto utilisator encartâ.'''",
	'requestaccount-leg-user' => 'Compto utilisator',
	'requestaccount-leg-areas' => 'Centros d’entèrèts principâls',
	'requestaccount-leg-person' => 'Enformacions a sè',
	'requestaccount-leg-other' => 'Ôtres enformacions',
	'requestaccount-leg-tos' => 'Condicions d’usâjo',
	'requestaccount-acc-text' => 'Un mèssâjo de confirmacion serat mandâ a voutra adrèce èlèctronica setout que la demanda arat étâ mandâ.
Dens lo mèssâjo reçu, clicâd sur lo lim que corrèspond a la confirmacion de voutra demanda.
Et pués, un mot de pâssa serat mandâ per mèssageria èlèctronica quand voutron compto utilisator serat fêt.',
	'requestaccount-areas-text' => 'Chouèsésséd los domênos que vos avéd una èxpèrtisa dèmontrâ, ou ben que vos éte encllin a contribuar lo ples.',
	'requestaccount-ext-text' => 'Ceta enformacion réste privâ et porrat étre utilisâ ren que por ceta demanda.
Vos avéd la possibilitât de listar des contactes coment un numerô de tèlèfono por avêr una assistance por confirmar voutra identitât.',
	'requestaccount-bio-text' => 'Voutra biografia serat betâ per dèfôt sur voutra pâge utilisator.
Tâchiéd d’y betar voutres recomandacions.
Assurâd-vos que vos pouede difusar sen crenta les enformacions.
Voutron nom pôt étre changiê en utilisent voutres [[Special:Preferences|prèferences]].',
	'requestaccount-real' => 'Veré nom :',
	'requestaccount-same' => '(nom que figure dens voutron ètat civilo)',
	'requestaccount-email' => 'Adrèce èlèctronica :',
	'requestaccount-reqtype' => 'Situacion :',
	'requestaccount-level-0' => 'ôtor',
	'requestaccount-level-1' => 'contributor',
	'requestaccount-bio' => 'Biografia a sè :',
	'requestaccount-attach' => 'CV (u chouèx) :',
	'requestaccount-notes' => 'Notes de ples :',
	'requestaccount-urls' => 'Lista des setos vouèbe. S’y en at un mouél, sèparâd-los per un sôt de legne :',
	'requestaccount-agree' => 'Vos dête cèrtifiar que voutron veré nom est justo et pués que vos accèptâd les condicions d’usâjo.',
	'requestaccount-inuse' => 'Lo nom d’utilisator est ja utilisâ dens una demanda de compto utilisator qu’est aprés étre aprovâ.',
	'requestaccount-tooshort' => 'Voutra biografia dêt avêr u muens $1 mot{{PLURAL:$1||s}}.',
	'requestaccount-emaildup' => 'Una ôtra demanda qu’est aprés étre confirmâ utilise la méma adrèce èlèctronica.',
	'requestaccount-exts' => 'Lo tipo du fichiér juent est pas pèrmês.',
	'requestaccount-resub' => 'Volyéd tornar chouèsir voutron fichiér de CV por des rêsons de sècuritât.
Se vos souhètâd pas més encllure ceti, lèssiéd lo champ vouedo.',
	'requestaccount-tos' => 'J’é liesu et pués j’accèpto les [[{{MediaWiki:Requestaccount-page}}|condicions d’usâjo]] de {{SITENAME}}.
Lo nom que j’é buchiê dens lo champ « Veré nom » est franc mon prôpro nom.',
	'requestaccount-submit' => 'Demanda de compto utilisator',
	'requestaccount-sent' => 'Voutra demanda de compto utilisator at étâ mandâ avouéc reusséta et pués at étâ betâ dens la lista d’atenta d’aprobacion.',
	'request-account-econf' => 'Voutra adrèce èlèctronica at étâ confirmâ et serat listâ d’ense dens voutra demanda de compto utilisator.',
	'requestaccount-email-subj' => 'Confirmacion de l’adrèce èlèctronica por {{SITENAME}}',
	'requestaccount-email-body' => 'Quârqu’un, probâblament vos, at fêt, dês l’adrèce IP $1, una demanda de compto utilisator « $2 » avouéc ceta adrèce èlèctronica sur lo seto {{SITENAME}}.

Por confirmar que cél compto est franc a vos dessus {{SITENAME}}, vos éte preyê d’uvrir ceti lim dens voutron navigator :

$3

Voutron mot de pâssa vos serat mandâ ren que se voutron compto utilisator est fêt.
S’o ére *pas* lo câs, utilisâd pas cél lim.
Ceti code de confirmacion èxpirerat lo $4.',
	'requestaccount-email-subj-admin' => 'Demanda de compto utilisator dessus {{SITENAME}}',
	'requestaccount-email-body-admin' => '« $1 » at demandâ un compto utilisator et sè trove en atenta de confirmacion.
L’adrèce èlèctronica at étâ confirmâ. Vos pouede aprovar la demanda ique « $2 ».',
	'acct_request_throttle_hit' => 'Dèsolâ, vos éd ja demandâ $1 compto{{PLURAL:$1||s}} utilisator.
Vos pouede pas més fâre de demanda.',
	'requestaccount-loginnotice' => "Por avêr un compto utilisator, vos dête nen fâre la '''[[Special:RequestAccount|demanda]]'''.",
	'confirmaccount-newrequests' => "Ora, y at '''$1''' [[Special:ConfirmAccounts|demand{{PLURAL:$1|a|es}} de compto utilisator]] qu{{PLURAL:$1|’est|e sont}} aprés étre confirmâ{{PLURAL:$1||s}}.",
	'confirmaccounts' => 'Confirmar les demandes de comptos utilisator',
	'confirmedit-desc' => 'Balye ux grata-papiérs la possibilitât de confirmar les demandes de comptos utilisator.',
	'confirmaccount-list' => 'Vê-que, ce-desot, la lista des comptos en atenta d’aprobacion. Los comptos accèptâs seront crèâs et reteriês de ceta lista. Los comptos refusâs seront suprimâs de ceta méma lista.',
	'confirmaccount-none-o' => 'Ora, y at gins de demanda de compto utilisator qu’est aprés étre confirmâ dens ceta lista.',
	'confirmaccount-none-h' => 'Ora, y at gins de resèrvacion de compto utilisator qu’est aprés étre confirmâ dens ceta lista.',
	'confirmaccount-none-r' => 'Ora, y at gins de novél refus de demanda de compto utilisator dens ceta lista.',
	'confirmaccount-none-e' => 'Ora, y at gins de demanda de compto utilisator èxpirâ dens ceta lista.',
	'confirmaccount-real-q' => 'Nom',
	'confirmaccount-email-q' => 'Adrèce èlèctronica',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'Demandes uvèrtes',
	'confirmaccount-showrej' => 'Demandes refusâs',
	'confirmaccount-showheld' => 'Demandes resèrvâs',
	'confirmaccount-showexp' => 'Demandes èxpirâs',
	'confirmaccount-review' => 'Aprobacion/Refus',
	'confirmaccount-name' => 'Nom d’utilisator',
	'confirmaccount-real' => 'Nom :',
	'confirmaccount-email' => 'Mèl. :',
	'confirmaccount-bio' => 'Biografia :',
	'confirmaccount-attach' => 'CV/Rèsumâ :',
	'confirmaccount-notes' => 'Notes suplèmentères :',
	'confirmaccount-urls' => 'Lista des setos vouèbe :',
	'confirmaccount-none-p' => '(pas montâ)',
	'confirmaccount-econf' => '(confirmâ)',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'requestaccount-level-0' => 'auteur',
	'requestaccount-level-1' => 'redakteur',
	'confirmaccount-real-q' => 'Namme',
	'confirmaccount-name' => 'Meidoggernamme',
	'confirmaccount-real' => 'Namme:',
	'confirmaccount-pos-0' => 'auteur',
	'confirmaccount-pos-1' => 'redakteur',
	'confirmaccount-noreason' => '(gjin)',
	'usercredentials-user' => 'Meidoggernamme:',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'confirmaccount-needreason' => 'Tá ort fáth a chur síos sa bhosca tráchta faoi bhun.',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'requestaccount' => 'Solicitar unha conta',
	'requestaccount-text' => "'''Complete e envíe o seguinte formulario para solicitar unha conta de usuario.'''

Asegúrese de ter lido primeiro as [[{{MediaWiki:Requestaccount-page}}|Condicións de servizo]] antes de solicitar unha conta.

Unha vez que se aprobe a conta, recibirá unha mensaxe de notificación por correo electrónico e poderá usar a conta en [[Special:UserLogin]].",
	'requestaccount-page' => '{{ns:project}}:Condicións de Servizo',
	'requestaccount-dup' => "'''Nota: Xa está no sistema cunha conta rexistrada.'''",
	'requestaccount-leg-user' => 'Conta de usuario',
	'requestaccount-leg-areas' => 'Principais áreas de interese',
	'requestaccount-leg-person' => 'Información persoal',
	'requestaccount-leg-other' => 'Outra información',
	'requestaccount-leg-tos' => 'Termos do servizo',
	'requestaccount-acc-text' => 'Enviaráselle unha mensaxe de confirmación ao seu enderezo de correo electrónico unha vez enviada esta solicitude. Responda premendo
	na ligazón de confirmación que lle aparecerá no correo electrónico. Así mesmo, enviaráselle o seu contrasinal cando se cree a conta.',
	'requestaccount-areas-text' => 'Seleccione embaixo as áreas dos temas dos que é máis experto ou nos que lle gustaría traballar máis.',
	'requestaccount-ext-text' => 'A información seguinte mantense como reservada e só se usará para esta solicitude.
	Pode querer listar contactos, como un número de teléfono, para axudar a identificar a confirmación.',
	'requestaccount-bio-text' => 'A súa biografía aparecerá como contido predefinido da súa páxina de usuario.
Tente incluír credenciais.
Asegúrese de non ter problema coa publicación desa información.
O seu nome pódese cambiar [[Special:Preferences|nas súas preferencias]].',
	'requestaccount-real' => 'Nome real:',
	'requestaccount-same' => '(o mesmo que o nome real)',
	'requestaccount-email' => 'Enderezo de correo electrónico:',
	'requestaccount-reqtype' => 'Posición:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografía persoal:',
	'requestaccount-attach' => 'Curriculum Vitae (opcional):',
	'requestaccount-notes' => 'Notas adicionais:',
	'requestaccount-urls' => 'Lista de sitios web, de habelos, (separados cun parágrafo novo):',
	'requestaccount-agree' => 'Debe certificar que o seu nome real é correcto e que está de acordo coas nosas Condicións de Servizo.',
	'requestaccount-inuse' => 'Este nome de usuario xa se usou nunha solicitude de conta aínda pendente.',
	'requestaccount-tooshort' => 'A súa biografía debe ter un mínimo {{PLURAL:$1|dunha palabra|de $1 palabras}}.',
	'requestaccount-emaildup' => 'Outra solicitude pendente de conta usa o mesmo enderezo de correo electrónico.',
	'requestaccount-exts' => 'Non se permite este tipo de ficheiro como anexo.',
	'requestaccount-resub' => 'Ten que volver seleccionar o ficheiro do seu curriculum vitae por razóns de seguranza.
Deixe o campo en branco se non o quere incluír máis.',
	'requestaccount-tos' => 'Lin e estou de acordo en respectar as [[{{MediaWiki:Requestaccount-page}}|Condicións de Servizo]] de {{SITENAME}}. 
	O nome especificado como "Nome real" é, efectivamente, o meu propio nome real.',
	'requestaccount-submit' => 'Solicitar unha conta',
	'requestaccount-sent' => 'A súa solicitude de conta foi enviada correctamente e agora está á espera de revisión.
Envióuselle un correo electrónico de confirmación ao seu enderezo de correo electrónico.',
	'request-account-econf' => 'Confirmouse o seu enderezo de correo electrónico e listarase como tal na súa
	solicitude de conta.',
	'requestaccount-email-subj' => 'Confirmación de enderezo de correo electrónico de {{SITENAME}}',
	'requestaccount-email-body' => 'Alguén, probabelmente vostede desde o enderezo IP $1, solicitou unha
conta "$2" con este enderezo de correo electrónico en {{SITENAME}}.

Para confirmar que esta conta lle pertence a vostede en {{SITENAME}}, abra esta ligazón no seu navegador:

$3

Se se crea a conta, só vostede recibirá o contrasinal. Se *non* se trata de vostede, non siga a ligazón.
Este código de confirmación caducará o $4.',
	'requestaccount-email-subj-admin' => 'solicitude de conta en {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" solicitou unha conta e está pendente de confirmación.
O enderezo de correo electrónico foi confirmado. Pode confirmar a solicitude aquí "$2".',
	'acct_request_throttle_hit' => 'Sentímolo, xa solicitou {{PLURAL:$1|unha conta|$1 contas}}.
Non pode facer máis solicitudes.',
	'requestaccount-loginnotice' => "Para obter unha conta de usuario ten que '''[[Special:RequestAccount|solicitar unha]]'''.",
	'confirmaccount-newrequests' => "Hai {{PLURAL:$1}} actualmente '''$1''' aberto 
 {{PLURAL:$1|[[Special:ConfirmAccounts|solicitude de conta]]|[[Special:ConfirmAccounts|solicitudes de contas]]}} pendente.",
	'confirmaccounts' => 'Confirmar solicitudes de contas',
	'confirmedit-desc' => 'Dar aos burócratas a capacidade para confirmar as solicitudes de contas',
	'confirmaccount-maintext' => "'''Esta páxina é usada para confirmar as súas solicitudes de conta pendentes en ''{{SITENAME}}''.'''

Cada cola de solicitudes de conta consiste en tres subcuestións, unha para abrila, outra para aquelas que fosen postas por outros administradores en espera de máis información e unha última para as solicitudes rexeitadas recentemente. 

Ao respostar unha solicitude revísea con coidado e, se é necesario, confirme a información alí contida.  
As súas accións serán rexistradas de maneira privada.
Agárdase tamén que revise calquera actividade que teña lugar aquí á parte das súas propias.",
	'confirmaccount-list' => 'Abaixo aparece unha lista de contas pendentes de aprobación.
	As contas aprobadas crearanse e eliminaranse desta lista. As contas rexeitadas simplemente eliminaranse desta lista.',
	'confirmaccount-list2' => 'Abaixo aparece unha lista con solicitudes de contas rexeitadas recentemente que poden eliminarse automaticamente
	unha vez que teñan varios días. Poden aínda ser aceptadas como contas, aínda que pode ser mellor que consulte primeiro
	co administrador que as rexeitou antes de facelo.',
	'confirmaccount-list3' => 'Embaixo hai unha lista coas solicitudes de contas que caducaron e que poden ser borradas automaticamente unha vez que teñan uns días.
Aínda poden ser aprobadas como contas.',
	'confirmaccount-text' => "Esta é unha solicitude pendente dunha conta de usuario en '''{{SITENAME}}'''.

Examine coidadosamente a información de embaixo. Se está de acordo con esta solicitude, seleccione no despregable a posición para fixar o status da conta do usuario.
As edicións feitas na biografía da solicitude non afectarán a calquera almacenamento de credenciais permanente. Observe que pode escoller, se quere, crear unha conta cun nome de usuario diferente.
Use isto só para evitar conflitos con outros nomes.

Se simplemente deixa esta páxina sen confirmar ou rexeitar esta solicitude, quedará como pendente.",
	'confirmaccount-none-o' => 'Neste momento non hai peticións de contas pendentes nesta lista.',
	'confirmaccount-none-h' => 'Actualmente non hai solicitudes pendentes a ter en conta nesta lista.',
	'confirmaccount-none-r' => 'Actualmente non hai contas rexeitas recentemente nesta lista.',
	'confirmaccount-none-e' => 'Actualmente non hai solicitudes de contas caducadas nesta lista.',
	'confirmaccount-real-q' => 'Nome',
	'confirmaccount-email-q' => 'Correo electrónico',
	'confirmaccount-bio-q' => 'Biografía',
	'confirmaccount-showopen' => 'solicitudes en curso',
	'confirmaccount-showrej' => 'solicitudes rexeitadas',
	'confirmaccount-showheld' => 'Ver as contas pendentes de ter en conta na lista',
	'confirmaccount-showexp' => 'solicitudes que expiraron',
	'confirmaccount-review' => 'Revisar',
	'confirmaccount-types' => 'Seleccione unha cola de confirmación de contas de embaixo:',
	'confirmaccount-all' => '(mostrar todas as colas)',
	'confirmaccount-type' => 'Cola seleccionada:',
	'confirmaccount-type-0' => 'autores potenciais',
	'confirmaccount-type-1' => 'editores potenciais',
	'confirmaccount-q-open' => 'solicitudes abertas',
	'confirmaccount-q-held' => 'solicitudes suspendidas',
	'confirmaccount-q-rej' => 'solicitudes recentemente rexeitadas',
	'confirmaccount-q-stale' => 'solicitudes expiradas',
	'confirmaccount-badid' => 'Non existe unha solicitude pendente que corresponda co ID fornecido. Pode que xa fose examinada.',
	'confirmaccount-leg-user' => 'Conta de usuario',
	'confirmaccount-leg-areas' => 'Principais áreas de interese',
	'confirmaccount-leg-person' => 'Información persoal',
	'confirmaccount-leg-other' => 'Outra información',
	'confirmaccount-name' => 'Nome de usuario',
	'confirmaccount-real' => 'Nome:',
	'confirmaccount-email' => 'Correo electrónico:',
	'confirmaccount-reqtype' => 'Posición:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografía:',
	'confirmaccount-attach' => 'Curriculum Vitae:',
	'confirmaccount-notes' => 'Notas adicionais:',
	'confirmaccount-urls' => 'Lista de sitios web:',
	'confirmaccount-none-p' => '(non fornecido)',
	'confirmaccount-confirm' => 'Use os botóns de embaixo para aceptar, rexeitar ou deixar en suspenso esta solicitude:',
	'confirmaccount-econf' => '(confirmada)',
	'confirmaccount-reject' => '(rexeitada por [[User:$1|$1]] en $2)',
	'confirmaccount-rational' => 'Explicación dada ao solicitante:',
	'confirmaccount-noreason' => '(ningún)',
	'confirmaccount-autorej' => '(esta solicitude foi descartada automaticamente debido á inactividade)',
	'confirmaccount-held' => '(marcada "en suspenso" por [[User:$1|$1]] en $2)',
	'confirmaccount-create' => 'Aceptar (crear a conta)',
	'confirmaccount-deny' => 'Rexeitar (eliminar da lista)',
	'confirmaccount-hold' => 'Suspender',
	'confirmaccount-spam' => 'Spam (non enviar correo electrónico)',
	'confirmaccount-reason' => 'Comentario (incluirase na mensaxe de correo electrónico):',
	'confirmaccount-ip' => 'Enderezo IP:',
	'confirmaccount-legend' => 'Confirmar ou rexeitar esta conta',
	'confirmaccount-submit' => 'Confirmar',
	'confirmaccount-needreason' => 'Debe incluír un motivo na caixa de comentarios de embaixo.',
	'confirmaccount-canthold' => 'Esta solicitude está en espera ou foi borrada.',
	'confirmaccount-acc' => 'Confirmouse sen problemas a solicitude de conta;
creouse a nova conta de usuario "[[User:$1|$1]]".',
	'confirmaccount-rej' => 'Rexeitouse sen problemas a solicitude de conta.',
	'confirmaccount-viewing' => '(actualmente sendo visto por [[User:$1|$1]])',
	'confirmaccount-summary' => 'A crear a páxina de usuario coa biografía do novo usuario.',
	'confirmaccount-welc' => "'''Reciba a benvida a ''{{SITENAME}}''!''' Esperamos que contribúa moito e ben.
Quizais queira ler as [[{{MediaWiki:Helppage}}|páxinas de axuda]]. De novo, reciba a nosa benvida e divírtase!",
	'confirmaccount-wsum' => 'Reciba a nosa benvida!',
	'confirmaccount-email-subj' => 'solicitude de conta en {{SITENAME}}',
	'confirmaccount-email-body' => 'Aprobouse a súa solicitude de conta en {{SITENAME}}.

Nome da conta: $1

Contrasinal: $2

Por razóns de seguranza terá que mudar o contrasinal a primeira vez que se rexistre. Para rexistrarse,
vaia a {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Aprobouse a súa solicitude de conta en {{SITENAME}}.

Nome da conta: $1

Contrasinal: $2

$3

Por razóns de seguranza terá que mudar o contrasinal a primeira vez que se rexistre. Para rexistrarse,
vaia a {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Sentímolo, pero a súa solicitude de conta $1 foi rexeitada en {{SITENAME}}.

Isto pode deberse a varias causas. Pode que non enchese o formulario correctamente, non respondese na extensión
adecuada ou non cumprise con algún outro criterio. Pode que existan listas de contacto no sitio que poida
usar se quere saber máis acerca da política de contas de usuario.',
	'confirmaccount-email-body4' => 'Sentímolo, pero a súa solicitude de conta "$1" foi rexeitada en {{SITENAME}}.

$2

Poden existir listas de contacto no sitio que pode usar se quere saber máis acerca da política de contas de usuario.',
	'confirmaccount-email-body5' => 'Antes de que se poida aceptar a súa solicitude dunha conta para "$1" en {{SITENAME}}
	ten que fornecer algunha información adicional.

$2

Poden existir listas de contacto no sitio que poida usar se quere saber máis acerca da nosa política de contas de usuario.',
	'usercredentials' => 'Credenciais do usuario',
	'usercredentials-leg' => 'Verificar os credenciais confirmados dun usuario',
	'usercredentials-user' => 'Nome do usuario:',
	'usercredentials-text' => 'Embaixo están os credenciais validos das contas de usuario seleccionadas.',
	'usercredentials-leg-user' => 'Conta de usuario',
	'usercredentials-leg-areas' => 'Principais áreas de interese',
	'usercredentials-leg-person' => 'Información persoal',
	'usercredentials-leg-other' => 'Outra información:',
	'usercredentials-email' => 'Correo electrónico:',
	'usercredentials-real' => 'Nome real:',
	'usercredentials-bio' => 'Biografía:',
	'usercredentials-attach' => 'Currículo/CV:',
	'usercredentials-notes' => 'Notas adicionais:',
	'usercredentials-urls' => 'Lista de sitios web:',
	'usercredentials-ip' => 'Enderezo IP orixinal:',
	'usercredentials-member' => 'Dereitos:',
	'usercredentials-badid' => 'Non se atoparon credenciais para este usuario. Comprobe que o nome estea escrito correctamente.',
	'right-confirmaccount' => 'Ver a [[Special:ConfirmAccounts|cola coas solicitudes de contas]]',
	'right-requestips' => 'Ver os enderezos IP que solicitan contas',
	'right-lookupcredentials' => 'Ver os [[Special:UserCredentials|credenciais de usuario]]',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'requestaccount-leg-user' => 'Λογισμός χρωμένου',
	'requestaccount-real' => 'ἀληθὲς ὄνομα:',
	'requestaccount-email' => 'Ἡλεκτρονικὴ διεύθυνσις:',
	'requestaccount-reqtype' => 'Θέσις:',
	'requestaccount-level-0' => 'δημιουργός',
	'requestaccount-level-1' => 'μεταγραφεύς',
	'requestaccount-attach' => 'Βιογραφικόν (προαιρετικόν):',
	'confirmaccount-real-q' => 'Ὄνομα',
	'confirmaccount-email-q' => 'Ἠλεκτρονικαὶ ἐπιστολαί',
	'confirmaccount-bio-q' => 'Βιογραφία',
	'confirmaccount-review' => 'Ἐπισκόπησις',
	'confirmaccount-type' => 'Οὐρά:',
	'confirmaccount-leg-user' => 'Λογισμὸς χρωμένου',
	'confirmaccount-leg-other' => 'Ἑτέρα πύστις',
	'confirmaccount-name' => 'Ὄνομα χρωμένου',
	'confirmaccount-real' => 'Ὄνομα:',
	'confirmaccount-email' => 'Ἠλεκτρονικαὶ ἐπιστολαί:',
	'confirmaccount-reqtype' => 'Θέσις:',
	'confirmaccount-pos-0' => 'δημιουργός',
	'confirmaccount-pos-1' => 'μεταγραφεύς',
	'confirmaccount-bio' => 'Βιογραφία:',
	'confirmaccount-attach' => 'Βιογραφικόν:',
	'confirmaccount-noreason' => '(οὐδεμία)',
	'confirmaccount-ip' => 'Διεύθυνσις IP:',
	'confirmaccount-submit' => 'Κυροῦν',
	'confirmaccount-wsum' => 'Ὡς εὖ παρέστης!',
	'usercredentials' => 'Διαπιστευτήρια χρωμένου',
	'usercredentials-user' => 'Ὄνομα χρωμένου:',
	'usercredentials-email' => 'Ἠλεκτρονικαὶ ἐπιστολαί:',
	'usercredentials-real' => 'ἀληθὲς ὄνομα:',
	'usercredentials-bio' => 'Βιογραφία:',
	'usercredentials-attach' => 'Βιογραφικὸν σημείωμα:',
	'usercredentials-urls' => 'Καταλογὴ ἱστοτόπων:',
	'usercredentials-member' => 'Δικαιώματα:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'requestaccount' => 'E Aatrag stelle uf e Benutzerkonto',
	'requestaccount-text' => "'''Fill des Formular uus un schick s ab go ne Aatrag stelle uf e Benutzerkonto'''.  

Bitte liis zerscht d [[{{MediaWiki:Requestaccount-page}}|Nutzigbedingige]], voreb Du ne Aatrag stellsch uf e Benutzerkonto.

Sobald s Konto bstätigt woren isch, chunnsch e Nochricht per E-Mail iber un chasch Di [[Special:UserLogin|aamälde]].",
	'requestaccount-page' => '{{ns:project}}:Nutzigsbedingige',
	'requestaccount-dup' => "'''Obacht: Du bisch scho mit eme regischtrierte Benutzerkonto aagmäldet.'''",
	'requestaccount-leg-user' => 'Benutzerkonto',
	'requestaccount-leg-areas' => 'Hauptinterässe',
	'requestaccount-leg-person' => 'Persenligi Informatione',
	'requestaccount-leg-other' => 'Meh Informatione',
	'requestaccount-leg-tos' => 'Benutzigsbedingige',
	'requestaccount-acc-text' => 'An Dyyni E-Mail-Adräss wird noch em Abschicke vu däm Formular e Bstätigungsmail gschickt.
Bitte reagier druf, indäm Du uf s Bstätigungs-Gleich drucksch, wu s in däre Mail het.
Sobald Dyy Konto aagleit woren isch, wird Dir Dyy Passwort per E-Mail zuegschickt.',
	'requestaccount-areas-text' => 'Wehl d Themene uus, wu Du s meischt Fachwisse din hesch oder wu Du am meischte witt dra schaffe.',
	'requestaccount-ext-text' => 'Die Informatione wäre vertraulig behandlet un uusschließlig fir dää Aatrag bruucht.
Du chasch Kontakt-Aagabe mache, wie z B. e Telifonnummere, go d Bearbeitig vu Dyynem Aatrag z vereifache.',
	'requestaccount-bio-text' => 'Dyy Biografii wird as initiale Inhalt vu Dyynere Benutzersyte gspycheret.
Versuech alli netigen Empfählige z nänne, aber stell sicher, ass Du d Informationen au wirkli witt vereffentlige.
Du chasch Dyy Namen in [[Special:Preferences|Dyynen Yystelligen]] ändere.',
	'requestaccount-real' => 'Realname:',
	'requestaccount-same' => '(wie dr Realname)',
	'requestaccount-email' => 'E-Mail-Adräss:',
	'requestaccount-reqtype' => 'Position:',
	'requestaccount-level-0' => 'Autor',
	'requestaccount-level-1' => 'Bearbeiter',
	'requestaccount-bio' => 'Persenligi Biografii:',
	'requestaccount-attach' => 'Läbenslauf (optional):',
	'requestaccount-notes' => 'Zuesätzligi Aagabe:',
	'requestaccount-urls' => 'Lischt vu Netzsyte (dur Zyylenumbrich trännt):',
	'requestaccount-agree' => 'Du muesch bstätigen, ass Dyy Realname korräkt isch un Du d Benutzerbedingige akzeptiersch.',
	'requestaccount-inuse' => 'Dr Benutzername wird scho in eme andere Benutzeraatrag bruucht.',
	'requestaccount-tooshort' => 'Dyy Biografii sott zmindescht {{PLURAL:$1|1 Wort|$1 Werter}} lang syy.',
	'requestaccount-emaildup' => 'E wytere nonig erledigte Aatrag bruucht di nämlig E-Mail-Adräss.',
	'requestaccount-exts' => 'Dr Dateityp vum Aahang isch nit erlaubt.',
	'requestaccount-resub' => 'D Datei mit Dyynem Läbenslauf muess us Sicherheitsgrind nej uusgwehlt wäre.
Loss s Fäld läär, wänn Du kei Läbenslauf meh witt aafiege.',
	'requestaccount-tos' => 'Ich haa d [[{{MediaWiki:Requestaccount-page}}|Benutzigsbedingige]] vu {{SITENAME}} gläsen und akzeptier si.
Ich bstätige, ass dr Name, wun i unter „Realname“ aagee haa, myy wirklige Namen isch.',
	'requestaccount-submit' => 'Aatrag stelle uf e Benutzerkonto',
	'requestaccount-sent' => 'Dyy Aatrag isch erfolgryych verschickt wore un muess jetz no iberprieft wäre.
E Bstetigungs-Mail isch an Dyy E-Mail-Adräss gschickt wore.',
	'request-account-econf' => 'Dyy E-Mail-Adräss isch bstätigt woren un wird jetz as sonigi in Dyynem Benutzerkonte-Aatrag gfiert.',
	'requestaccount-email-subj' => '{{SITENAME}} E-Mail-Adrässe-Priefig',
	'requestaccount-email-body' => 'Eber mit dr IP Adräss $1, villicht Du, het bi {{SITENAME}} mit Dyynere E-Mail-Adräss e Aatrag uf s Benutzerkonto „$2“ gstellt.

Go bstätigen, ass wirkli Du ne Aatrag uf des Konto bi {{SITENAME}} gstellt hesch, mach bitte in Dyynem Browser des Gleich uf:

$3

Wänn s Benutzerkonto aagleit woren isch, chunnsch no ne E-Mail mit em Passwort iber.

Wänn Du *kei* Aatrag gstellt hesch uf s Benutzerkonto, mach des Gleich bitte nit uf!

Dää Bstätigungscode isch ab em $4 nimmi giltig.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} Benutzerkontenaatrag',
	'requestaccount-email-body-admin' => '„$1“ het e Aatrag uf e Benutzerkonto gstellt un wartet uf e Bstätigung.
D E-Mail-Adräss isch bstätigt wore. Du chasch dr Aatrag do bstätige: „$2“.',
	'acct_request_throttle_hit' => 'Du hesch scho ne Aatrag uf {{PLURAL:$1|1 Benutzerkonto|$1 Benutzerkonte}} gstellt, Du chasch zur Zyt fir keini meh ne Aatrag stelle.',
	'requestaccount-loginnotice' => "Go ne nej Benutzerkonto iberchu muesch e '''[[Special:RequestAccount|Aatrag stelle]]'''.",
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|ufige, E-Mail bstätigte Benutzerkontenaatrag wartet]]|[[Special:ConfirmAccounts|ufigi, E-Mail bstätigti Benutzerkontenaaträg warten]]}} uf Bearbeitig.",
	'confirmaccounts' => 'Benutzerkonto-Aaträg bstätige',
	'confirmedit-desc' => 'Git Bürokrate d Megligkeit, Benutzerkontenaaträg z bstätige',
	'confirmaccount-maintext' => "'''Die Syte dient dezue, hängigi Benutzerkontenaaträg fir ''{{SITENAME}}'' z bearbeite.'''

Jedi Benutzerkonte-Aatragswarteschlang bstoht us drej Unterwarteschlange. Eini fir ufigi Aafroge, eini fir Aaträg im „abwarte“-Status un eini Aafroge, wu letschti abglähnt wore sin.

Wänn Du uf e Aatrag Antwort gisch, iberprief d Informatione sorgfältig un bstätig d Informatione, wu s din het.
Dyy Aktione wäre niteffentlig protokolliert. S wird au vu Dir erwartet, ass Du Aktionen vu dr Andre iberpriefsch.",
	'confirmaccount-list' => 'Unte findsch e Lischt vu Benutzerkontenaaträg, wu no mien bearbeitet wäre.
Wänn en Aatrag bstätigt oder zrugggwise woren isch, wird er us dr Lischt usegnuu.',
	'confirmaccount-list2' => 'Unten isch e Lischt Aaträg, wu letschti zrugggwise wore sin. Si wäre automatisch glescht, wänn si ne paar Täg alt sin. Si chenne no gnähmigt wäre, Du sottsch aber zerscht sdr Ammann kontaktiere, wu dr Aatrag abglähnt het.',
	'confirmaccount-list3' => 'Unten isch e Lischt vu letschti zrugggwisene Aaträg, wu automatisch glescht wäre, wänn si e paar Täg alt sin. si chenne no gnähmigt wäre.',
	'confirmaccount-text' => "Des isch en Aatrag uf e Benutzerkonto bi '''{{SITENAME}}'''.

Prief alli Informatione, wu unte stehn, grindlig un bstätig d Informatione wänn s goht.
Bitte gib Acht, ass Du dr Zuegang bi Bedarf unter eme andere Benutzername chasch aalege.
Du sottsch des nume nutze go Kollisione mit andere Namen vermyyde.

Wänn Du die Syte verlossesch, ohni s Konto z bstätigen oder abzlähne, wird dr Aatrag ufe blyybe.",
	'confirmaccount-none-o' => 'Zur Zyt git s kei uffigi Benutzeraaträg uf däre Lischt.',
	'confirmaccount-none-h' => 'Zur Zyt git s kei Benutzeraaträg uf däre Lischt, wu im „abwarte“-Status sin.',
	'confirmaccount-none-r' => 'Zur Zyt git s kei letschti abglähnte Benutzeraaträg uf däre Lischt.',
	'confirmaccount-none-e' => 'Zur Zyt git s kei abgloffeni Benutzeraaträg uf däre Lischt.',
	'confirmaccount-real-q' => 'Name',
	'confirmaccount-email-q' => 'E-Mail',
	'confirmaccount-bio-q' => 'Biografii',
	'confirmaccount-showopen' => 'uffigi Aaträg',
	'confirmaccount-showrej' => 'zrugggwiseni Aaträg',
	'confirmaccount-showheld' => 'Aaträg im „abwarte“-Status',
	'confirmaccount-showexp' => 'abglofeni Aaträg',
	'confirmaccount-review' => 'Bstätige/Ablähne',
	'confirmaccount-types' => 'Wehl e Benutzerkontenbstätigungswarteschlang us däne do unten uus:',
	'confirmaccount-all' => '(alli Warteschlange zeige)',
	'confirmaccount-type' => 'Warteschlang:',
	'confirmaccount-type-0' => 'zuechimpftigi Autore',
	'confirmaccount-type-1' => 'zuechimpftigi Bearbeiter',
	'confirmaccount-q-open' => 'uffigi Aaträg',
	'confirmaccount-q-held' => 'Aaträg im „abwarte”-Status',
	'confirmaccount-q-rej' => 'letschti abglähnti Aaträg',
	'confirmaccount-q-stale' => 'abglofeni Aaträg',
	'confirmaccount-badid' => 'Zur Zyt git s kei Benutzeraatrag zue dr ID, wu Du aagee hesch, Villicht isch isch er scho bearbeitet.',
	'confirmaccount-leg-user' => 'Benutzerkonto',
	'confirmaccount-leg-areas' => 'Hauptinträsse',
	'confirmaccount-leg-person' => 'Persenligi Informatione',
	'confirmaccount-leg-other' => 'Wyteri Informatione',
	'confirmaccount-name' => 'Benutzername',
	'confirmaccount-real' => 'Name:',
	'confirmaccount-email' => 'E-Mail:',
	'confirmaccount-reqtype' => 'Position:',
	'confirmaccount-pos-0' => 'Autor',
	'confirmaccount-pos-1' => 'Bearbeiter',
	'confirmaccount-bio' => 'Biografii:',
	'confirmaccount-attach' => 'Läbenslauf:',
	'confirmaccount-notes' => 'Zuesätzligi Hiawyys:',
	'confirmaccount-urls' => 'Lischt vu dr Netzsyte:',
	'confirmaccount-none-p' => '(nit aagee)',
	'confirmaccount-confirm' => 'Nimm die Uuswahl go dr Aatrag akzeptieren, abzlähnen oder no z warte.',
	'confirmaccount-econf' => '(bstätigt)',
	'confirmaccount-reject' => '(abglähnt dur [[User:$1|$1]] am $2)',
	'confirmaccount-rational' => 'Begrindig fir dr Aatragssteller:',
	'confirmaccount-noreason' => '(nyt)',
	'confirmaccount-autorej' => '(dää Aatrag isch automatisch wägen Inaktivität gstriche wore)',
	'confirmaccount-held' => '(markiert as „abwarte“ dur [[User:$1|$1]] am $2)',
	'confirmaccount-create' => 'Bstätige (Konto aalege)',
	'confirmaccount-deny' => 'Ablähne (Aatrag lesche)',
	'confirmaccount-hold' => 'Abwarte',
	'confirmaccount-spam' => 'Spam (kei E-Mail verschicke)',
	'confirmaccount-reason' => 'Begrindig (wird in d Mail an dr Aatragsteller dryygsetzt):',
	'confirmaccount-ip' => 'IP-Addräss:',
	'confirmaccount-legend' => 'Die Aafrog bstetige oder zruckwyyse',
	'confirmaccount-submit' => 'Abschicke',
	'confirmaccount-needreason' => 'Du muesch im Chäschtli unten e Begrindig aagee.',
	'confirmaccount-canthold' => 'Dää Aatrag isch scho as „abwarte“ markiert oder glescht wore.',
	'confirmaccount-acc' => 'Benutzeraatrag erfolgryych bstätigt; Benutzer [[User:$1|$1]] isch aagleit wore.',
	'confirmaccount-rej' => 'Benutzeraatrag isch abglähnt wore.',
	'confirmaccount-viewing' => '(wird aktuäll aagluegt vu [[User:$1|$1]])',
	'confirmaccount-summary' => 'Legt e Benutzersyte mit dr Biografii vum neje Benutzer aa.',
	'confirmaccount-welc' => "'''Willchu bi ''{{SITENAME}}''!'''
Mir hoffen, ass Du viil gueti Informatione byytraisch.
Villicht mechtsch zerscht di [[{{MediaWiki:Helppage}}|Erschte Schritt]] läse.
Nomol: Willchu un viil Freid!",
	'confirmaccount-wsum' => 'Willchu!',
	'confirmaccount-email-subj' => '{{SITENAME}} Aatrag uf Benutzerkonto',
	'confirmaccount-email-body' => 'Dyy Aatrag uf e Benutzerkonto bi {{SITENAME}} isch bstätigt wore.

Benutzername: $1

Passwort: $2

Us Sicherheitsgrind sottsch Dyy Passwort uubedingt bim erschten Aamälde ändere. Go Di aamälde gohsch uf d Syte
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2' => 'Dyy Aatrag uf e Benutzerkonto bi {{SITENAME}} isch bstätigt wore.

Benutzername: $1

Passwort: $2

$3

Us Sicherheitsgrind sottsch Dyy Passwort uubedingt bim erschten Aamälde ändere. Go Di aamälde gohsch uf d Syte
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3' => 'Excusez, Dyy Aatrag uf e „$1“  bi {{SITENAME}} isch abglähnt wore.

Des cha viil Grind haa. Villicht hesch s Aatragsformular nit richtig uusgfillt, villicht hesch nit gnue Aagabe gmacht oder villicht hesch d Aaforderige in e andere Art un Wyys nit erfillt.

Villicht git s uf dr Syte Kontaktadrässe, wu Du Di metsch hiiwände, wänn Du meh witt wisse iber d Aaforderige.',
	'confirmaccount-email-body4' => 'Excusez, Dyy Aatrag uf e „$1“  bi {{SITENAME}} isch abglähnt wore.

$2

Villicht git s uf dr Syte Kontaktadrässe, wu Du Di metsch hiiwände, wänn Du meh witt wisse iber d Aaforderige.',
	'confirmaccount-email-body5' => 'Voreb Dyy Aafrog fir s Benutzerkonto „$1“ uf {{SITENAME}} cha akzeptiert wäre, muesch no zuesätzligi Informationen aagee.

$2

Villicht git s uf dr Syte Kontaktadrässe, wu Du Di metsch hiiwände, wänn Du meh witt wisse iber d Aaforderige.',
	'usercredentials' => 'Benutzer-Berächtigungsnochwyys',
	'usercredentials-leg' => 'Bstätigti Benutzer-Berächtigungsnochwyys noluege',
	'usercredentials-user' => 'Benutzername:',
	'usercredentials-text' => 'Du unte sin di bstätigte Benutzer-Berächtigungsnochwyys fir s gwehlt Benutzerkonto.',
	'usercredentials-leg-user' => 'Benutzerkonto',
	'usercredentials-leg-areas' => 'Hauptinträssi',
	'usercredentials-leg-person' => 'Persenligi Informatione',
	'usercredentials-leg-other' => 'Wyteri Informationen',
	'usercredentials-email' => 'E-Mail:',
	'usercredentials-real' => 'Ächte Name:',
	'usercredentials-bio' => 'Biografii:',
	'usercredentials-attach' => 'Läbenslauf:',
	'usercredentials-notes' => 'Zuesätzligi Bemerkige:',
	'usercredentials-urls' => 'Lischt vu Netzsyte:',
	'usercredentials-ip' => 'Original IP-Adräss:',
	'usercredentials-member' => 'Rächt:',
	'usercredentials-badid' => 'S sin kei Berächtigungsnochwyys fir dää Benutzer gfunde wore. Bitte d Schryybwyys priefe.',
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Lischt mit beaatraite Benutzerkonte]] aaluege',
	'right-requestips' => 'D IP-Adräss vum Aatragsteller aaluege, derwylscht dr Aatrag bearbeitet wird',
	'right-lookupcredentials' => '[[Special:UserCredentials|Zyygnis vum Benutzer]] aaluege',
);

/** Gujarati (ગુજરાતી)
 * @author Aksi great
 * @author Ashok modhvadia
 * @author Dineshjk
 * @author Dsvyas
 */
$messages['gu'] = array(
	'requestaccount-real' => 'સાચુ નામ:',
	'requestaccount-level-0' => 'લેખક',
	'requestaccount-level-1' => 'સંપાદક',
	'requestaccount-notes' => 'વિશેષ નોંધ',
	'requestaccount-exts' => 'જોડાયેલ ફાઇલનો પ્રકાર અમાન્ય છે.',
	'confirmaccount-name' => 'સભ્ય નામ:',
	'confirmaccount-summary' => 'નવા સભ્યનાં જીવન વુત્તાંત વાળું સભ્યનું પાનું બનાવી રહ્યા છો',
	'confirmaccount-wsum' => 'સુસ્વાગતમ્',
	'usercredentials-user' => 'સભ્ય નામ:',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'requestaccount-leg-user' => 'Coontys yn ymmydeyr',
	'requestaccount-leg-person' => 'Oayllys persoonagh',
	'requestaccount-leg-other' => 'Oayllys elley',
	'requestaccount-real' => 'Feer-ennym:',
	'requestaccount-email' => 'Enmys post-L:',
	'requestaccount-level-0' => 'ughtar',
	'requestaccount-level-1' => 'reagheyder',
	'requestaccount-bio' => 'Beashnys persoonagh:',
	'requestaccount-notes' => 'Noteyn elley:',
	'confirmaccount-real-q' => 'Ennym',
	'confirmaccount-email-q' => 'Post-L',
	'confirmaccount-bio-q' => 'Beashnys',
	'confirmaccount-all' => '(taishbyney dagh ooilley amman)',
	'confirmaccount-type' => 'Famman:',
	'confirmaccount-leg-user' => 'Coontys ymmydeyr',
	'confirmaccount-leg-person' => 'Oayllys persoonagh',
	'confirmaccount-leg-other' => 'Oayllys elley',
	'confirmaccount-name' => "Dt'ennym ymmydeyr",
	'confirmaccount-real' => 'Ennym:',
	'confirmaccount-email' => 'Post-L:',
	'confirmaccount-pos-0' => 'ughtar',
	'confirmaccount-pos-1' => 'reagheyder',
	'confirmaccount-bio' => 'Beashnys:',
	'confirmaccount-urls' => 'Rolley ynnydyn-eggey:',
	'confirmaccount-ip' => 'Enmys IP:',
	'confirmaccount-wsum' => 'Failt ort!',
	'usercredentials-user' => "Dt'ennym ymmydeyr:",
	'usercredentials-leg-user' => 'Coontys ymmydeyr',
	'usercredentials-leg-person' => 'Oayllys persoonagh',
	'usercredentials-leg-other' => 'Oayllys elley',
	'usercredentials-email' => 'Post-L:',
	'usercredentials-real' => 'Feer-ennym:',
	'usercredentials-bio' => 'Beashnys:',
	'usercredentials-urls' => 'Rolley ynnydyn-eggey:',
	'usercredentials-ip' => 'Enmys IP bunneydagh:',
	'usercredentials-member' => 'Kiartyn:',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'confirmaccount-name' => 'Yung-fu-miàng',
	'usercredentials-user' => 'Yung-fu-miàng:',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'requestaccount-level-1' => 'luna',
	'confirmaccount-real-q' => 'Inoa',
	'confirmaccount-real' => 'Inoa:',
	'confirmaccount-pos-1' => 'luna',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author StuB
 * @author YaronSh
 */
$messages['he'] = array(
	'requestaccount' => 'בקשת חשבון',
	'requestaccount-text' => "מלאו והשלימו את הטופס הבא כדי לבקש חשבון המשתמש'''.

לפני שאתם מבקשים חשבון, אנא ודאו כי קראתם קודם את [[{{MediaWiki:Requestaccount-page}}|תנאי השירות]].

כשהחשבון יאושר, תישלח אליכם הודעה בדואר האלקטרוני ותוכלו [[Special:UserLogin|להיכנס אליו]].",
	'requestaccount-page' => '{{ns:project}}:תנאי השירות',
	'requestaccount-dup' => "'''הערה: אתם כבר מחוברים עם חשבון רשום.'''",
	'requestaccount-leg-user' => 'חשבון משתמש',
	'requestaccount-leg-areas' => 'תחומי עניין עיקריים',
	'requestaccount-leg-person' => 'מידע אישי',
	'requestaccount-leg-other' => 'מידע אחר',
	'requestaccount-leg-tos' => 'תנאי השירות',
	'requestaccount-acc-text' => 'לכתובת הדוא"ל שלכם תישלח הודעת אישור לאחר שהבקשה תתקבל.
אנא הגיבו על ידי לחיצה על הקישור לאישור המסופק בהודעת הדוא"ל.
כמו כן, הסיסמה שלכם תישלח אליכם בעת יצירת חשבונכם.',
	'requestaccount-ext-text' => 'המידע הבא נשמר בפרטיות וישמש עבור בקשה זו בלבד.
יתכן שתרצו לציין פרטי קשר כגון מספר טלפון כדי לסייע באימות זהותכם.',
	'requestaccount-real' => 'שם אמיתי:',
	'requestaccount-same' => '(כמו השם האמיתי)',
	'requestaccount-email' => 'כתובת הדוא"ל:',
	'requestaccount-reqtype' => 'משרה:',
	'requestaccount-level-0' => 'מחבר',
	'requestaccount-level-1' => 'עורך',
	'requestaccount-bio' => 'ביוגרפיה אישית:',
	'requestaccount-attach' => 'קורות חיים (אופציונאלי):',
	'requestaccount-notes' => 'הערות נוספות:',
	'requestaccount-urls' => 'רשימה של אתרים, אם יש כאלה (הפרידו באמצעות שורות חדשות):',
	'requestaccount-agree' => 'עליכם לאמת כי השם שציינתם הוא שמכם האמיתי ושהוא נכון ושאתם מסכימים לתנאי השימוש שלנו.',
	'requestaccount-inuse' => 'שם המשתמש כבר נמצא בשימוש בבקשת חשבון ממתינה.',
	'requestaccount-tooshort' => 'על הביוגרפיה שלכם להכיל לפחות {{PLURAL:$1|מילה אחת|$1 מילים}}.',
	'requestaccount-exts' => 'סוג הקובץ המצורף אינו מורשה.',
	'requestaccount-email-subj' => 'אימות כתובת דוא"ל עבור {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'בקשת חשבון באתר {{SITENAME}}',
	'requestaccount-loginnotice' => "כדי לקבל חשבון משתמש, עליכם '''[[Special:RequestAccount|לבקש אחד כזה]]'''.",
	'confirmaccounts' => 'אישור בקשות חשבון',
	'confirmedit-desc' => 'הענקת היכולת לביורוקרטים לאשר בקשות לחשבונות',
	'confirmaccount-list' => 'להלן מופיעה רשימת חשבונות הממתינים לאישור.
לאחר דחייה או אישור של אחת הבקשות היא תוסר מרשימה זו.',
	'confirmaccount-real-q' => 'שם',
	'confirmaccount-email-q' => 'דוא"ל',
	'confirmaccount-bio-q' => 'ביוגרפיה',
	'confirmaccount-showopen' => 'בקשות פתוחות',
	'confirmaccount-showrej' => 'בקשות שנדחו',
	'confirmaccount-showheld' => 'בקשות שעוכבו',
	'confirmaccount-showexp' => 'בקשות שפג תוקפן',
	'confirmaccount-review' => 'סקירה',
	'confirmaccount-all' => '(הצגת כל התורים)',
	'confirmaccount-type' => 'תור:',
	'confirmaccount-q-open' => 'בקשות פתוחות',
	'confirmaccount-q-held' => 'בקשות שעוכבו',
	'confirmaccount-q-rej' => 'בקשות שנדחו לאחרונה',
	'confirmaccount-q-stale' => 'בקשות שפג תוקפן',
	'confirmaccount-badid' => "אין בקשות ממתינות העונות למס' הנתון.
יתכן שהבקשה כבר טופלה.",
	'confirmaccount-leg-user' => 'חשבון משתמש',
	'confirmaccount-leg-areas' => 'תחומי עניין עיקריים',
	'confirmaccount-leg-person' => 'מידע אישי',
	'confirmaccount-leg-other' => 'מידע אחר',
	'confirmaccount-name' => 'שם משתמש',
	'confirmaccount-real' => 'שם:',
	'confirmaccount-email' => 'דוא"ל:',
	'confirmaccount-reqtype' => 'משרה:',
	'confirmaccount-pos-0' => 'מחבר',
	'confirmaccount-pos-1' => 'עורך',
	'confirmaccount-bio' => 'ביוגרפיה:',
	'confirmaccount-attach' => 'קורות חיים:',
	'confirmaccount-notes' => 'הערות נוספות:',
	'confirmaccount-urls' => 'רשימת אתרים:',
	'confirmaccount-none-p' => '(לא צוין)',
	'confirmaccount-confirm' => 'השתמשו באפשרויות שלהלן כדי לקבל, לדחות או לעכב בקשה זו:',
	'confirmaccount-econf' => '(מאושרת)',
	'confirmaccount-reject' => '(נדחתה על ידי [[User:$1|$1]] ב־$2)',
	'confirmaccount-noreason' => '(ללא)',
	'confirmaccount-held' => '(סומנה להמתנה על ידי [User:$1|$1]] ב־$2)',
	'confirmaccount-create' => 'אישור (יצירת חשבון)',
	'confirmaccount-deny' => 'דחייה (מחיקת הבקשה)',
	'confirmaccount-hold' => 'עיכוב',
	'confirmaccount-spam' => 'זבל (ללא שליחת הודעה בדוא"ל)',
	'confirmaccount-reason' => 'הערה (תיכלל בהודעת הדוא"ל):',
	'confirmaccount-ip' => 'כתובת IP:',
	'confirmaccount-submit' => 'אישור',
	'confirmaccount-needreason' => 'יש לספק סיבה בתיבת התגובה למטה.',
	'confirmaccount-canthold' => 'בקשה זו כבר נמצאת בהמתנה או מחוקה.',
	'confirmaccount-acc' => 'בקשת החשבון אושרה בהצלחה; נוצר חשבון משתמש חדש בשם [[User:$1|$1]].',
	'confirmaccount-rej' => 'בקשת החשבון נדחתה בהצלחה.',
	'confirmaccount-viewing' => '(הבקשה נצפית כרגע בידי [[User:$1|$1]])',
	'confirmaccount-summary' => 'יצירת דף משתמש עם ביוגרפיה של משתמש חדש',
	'confirmaccount-wsum' => 'ברוכים הבאים!',
	'confirmaccount-email-subj' => 'בקשת חשבון באתר {{SITENAME}}',
	'confirmaccount-email-body' => 'בקשתך לקבלת חשבון אושרה באתר {{SITENAME}}.

שם החשבון: $1

סיסמה: $2

מטעמי אבטחה עליכם לשנות את סיסמתכם עם כניסתכם הראשונה.
כדי להכנס, אנא עברו לכתובת {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'בקשתכם לקבלת חשבון באתר {{SITENAME}} אושרה.

שם החשבון: $1

סיסמה: $2

$3

מטעמי אבטחה תזדקקו לשנות את סיסמתכם עם הכניסה הראשונה.
כדי להתחבר אנא גשו לכתובת {{fullurl:Special:UserLogin}}.',
	'usercredentials' => 'פרטי זיהוי המשתמש',
	'usercredentials-leg' => 'פרטי זיהוי המשתמש שאושרו בתהליך האיתור',
	'usercredentials-user' => 'שם המשתמש:',
	'usercredentials-text' => 'להלן פרטי הזיהוי המאומתים של חשבון המשתמש הנבחר.',
	'usercredentials-leg-user' => 'חשבון משתמש',
	'usercredentials-leg-areas' => 'תחומי עניין עיקריים',
	'usercredentials-leg-person' => 'נתונים אישיים',
	'usercredentials-leg-other' => 'נתונים שונים',
	'usercredentials-email' => 'דוא"ל:',
	'usercredentials-real' => 'שם אמיתי:',
	'usercredentials-bio' => 'ביוגרפיה:',
	'usercredentials-attach' => 'קורות חיים:',
	'usercredentials-notes' => 'הערות נוספות:',
	'usercredentials-urls' => 'רשימת אתרים:',
	'usercredentials-ip' => 'כתובת ה־IP המקורית:',
	'usercredentials-member' => 'הרשאות:',
	'usercredentials-badid' => 'לא נמצאו פרטי זיהוי עבור משתמש זה.
אנא ודאו שהשם מאוית כראוי.',
	'right-confirmaccount' => 'צפייה ב[[Special:ConfirmAccounts|תור עם החשבונות הדרושים]]',
	'right-lookupcredentials' => 'צפייה ב[[Special:UserCredentials|הרשאות המשתמש]]',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Kiranmayee
 * @author आलोक
 */
$messages['hi'] = array(
	'requestaccount' => 'खाता मंगायें',
	'requestaccount-page' => '{{ns:project}}:शर्तें और नियम',
	'requestaccount-dup' => "'''सूचना: आपने पहले से पंजीकृत खाते से लॉग इन किया हुआ हैं।'''",
	'requestaccount-leg-user' => 'सदस्य खाता',
	'requestaccount-leg-areas' => 'मुख्य पसंद',
	'requestaccount-leg-person' => 'वैयक्तिक ज़ानकारी',
	'requestaccount-leg-other' => 'अन्य ज़ानकारी',
	'requestaccount-areas-text' => 'नीचे दिये हुए विषयोंसे आपके पसंदके तथा आप जिसमें माहिर हैं ऐसे विषय चुनें।',
	'requestaccount-real' => 'असली नाम:',
	'requestaccount-same' => '(असली नाम ही हैं)',
	'requestaccount-email' => 'इ-मेल एड्रेस:',
	'requestaccount-reqtype' => 'पोज़िशन:',
	'requestaccount-level-0' => 'लेखक',
	'requestaccount-level-1' => 'संपादक',
	'requestaccount-bio' => 'वैयक्तिक चरित्र:',
	'requestaccount-attach' => 'रिज़्यूम या सीव्ही (वैकल्पिक):',
	'requestaccount-notes' => 'अधिक ज़ानकारी:',
	'requestaccount-urls' => 'वेबसाईट्स की सूची, अगर हैं तो (एक लाईनमें एक):',
	'requestaccount-agree' => 'आपने दिया हुआ खुद का असली नाम सहीं हैं और आपको शर्ते और नियम मान्य हैं ऐसा सर्टिफाई करें।',
	'requestaccount-inuse' => 'आपने दिया हुआ सदस्यनाम पहले ही किसीने पूछा हैं।',
	'requestaccount-tooshort' => 'आपके वैयक्तिक चरित्र में कमसे कम $1 {{PLURAL:$1|शब्द|शब्द}} होना जरूरी हैं।',
	'requestaccount-emaildup' => 'एक अन्य पूरी न हुई माँगमें यह इ-मेल एड्रेस दिया हुआ हैं।',
	'requestaccount-exts' => 'संलग्न प्रकार की संचिका की अनुमति नहीं है।',
	'requestaccount-submit' => 'खाता मंगायें',
	'requestaccount-sent' => 'आपकी खाता खोलने की माँग पंजिकृत हो गई हैं और अब इसे फिरसे परखने के लिये रखा गया हैं।',
	'request-account-econf' => 'आपका इ-मेल एड्रेस प्रमाणित हो गया है और इसे अब आपकी खाता खोलेने की माँग में दर्ज कर दिया गया हैं।',
	'requestaccount-email-subj' => '{{SITENAME}} इमेल एड्रेस प्रमाणिकरण',
	'requestaccount-email-subj-admin' => '{{SITENAME}} खाता खोलने की माँग',
	'requestaccount-loginnotice' => "सदस्य खाता पाने के लिये आप अपनी '''[[Special:RequestAccount|माँग पंजिकृत करें]]'''।",
	'confirmaccounts' => 'खाते की माँग निश्चित करें',
	'confirmedit-desc' => 'ब्युरोक्रैट्स को खाते की माँग निश्चित करने की सुविधा देती हैं',
	'confirmaccount-none-o' => 'इस सूचीमें अभी एक भी प्रलंबित खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-none-h' => 'इस सूचीमें अभी एक भी प्रलंबित रखी हुई खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-none-r' => 'इस सूचीमें अभी एक भी रिजेक्ट की हुई खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-none-e' => 'इस सूचीमें अभी एक भी समाप्त हुई खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-real-q' => 'नाम',
	'confirmaccount-email-q' => 'इ-मेल',
	'confirmaccount-bio-q' => 'चरित्र',
	'confirmaccount-showopen' => 'प्रलंबित माँगे',
	'confirmaccount-showrej' => 'रिजेक्ट की हुई माँगे',
	'confirmaccount-showheld' => 'प्रलंबित रखी हुई माँगे',
	'confirmaccount-showexp' => 'समाप्त हुई माँगे',
	'confirmaccount-review' => 'अवलोकन',
	'confirmaccount-types' => 'नीचे से एक खाता निश्चिती कतार चुनें:',
	'confirmaccount-all' => '(सभी कतारें दर्शायें)',
	'confirmaccount-type' => 'कतार:',
	'confirmaccount-type-0' => 'प्रोस्पेक्टिव लेखक',
	'confirmaccount-type-1' => 'प्रोस्पेक्टिव संपादक',
	'confirmaccount-q-open' => 'प्रलंबित माँगे',
	'confirmaccount-q-held' => 'प्रलंबित रखी हुई माँगे',
	'confirmaccount-q-rej' => 'हाल में अस्वीकृत माँगे',
	'confirmaccount-q-stale' => 'समाप्त हुई माँगे',
	'confirmaccount-badid' => 'दिये हुए ID से मिलनेवाली माँग मिली नहीं।
शायद वह पहले से देखी गई हो।',
	'confirmaccount-leg-user' => 'सदस्य खाता',
	'confirmaccount-leg-areas' => 'मुख्य पसंद',
	'confirmaccount-leg-person' => 'वैयक्तिक ज़ानकारी',
	'confirmaccount-leg-other' => 'अन्य ज़ानकारी',
	'confirmaccount-name' => 'सदस्यनाम',
	'confirmaccount-real' => 'नाम:',
	'confirmaccount-email' => 'इ-मेल:',
	'confirmaccount-reqtype' => 'स्थिती:',
	'confirmaccount-pos-0' => 'लेखक',
	'confirmaccount-pos-1' => 'संपादक',
	'confirmaccount-bio' => 'चरित्र:',
	'confirmaccount-attach' => 'रिज्यूम/सीव्ही:',
	'confirmaccount-notes' => 'अधिक ज़ानकारी:',
	'confirmaccount-urls' => 'वेबसाईट्स की सूची:',
	'confirmaccount-none-p' => '(दिया नहीं हैं)',
	'confirmaccount-confirm' => 'यह माँग स्वीकारने, प्रलंबित रखने या अस्वीकृत करने के लिये नीचे दिये ओप्शन चुनें:',
	'confirmaccount-econf' => '(निश्चित किया हुआ)',
	'confirmaccount-reject' => '([[User:$1|$1]] ने $2 पर अस्वीकृत की)',
	'confirmaccount-rational' => 'एप्लिकेंट को दिया हुआ कारण:',
	'confirmaccount-noreason' => '(बिल्कुल नहीं)',
	'confirmaccount-autorej' => '(यह माँग अकार्यक्षमता के चलते अपनेआप अस्वीकृत कर दी गई हैं)',
	'confirmaccount-held' => '([[User:$1|$1]] ने $2 पर "प्रलंबित रखी हुई" है)',
	'confirmaccount-create' => 'स्वीकृती (खाता खोलें)',
	'confirmaccount-deny' => 'अस्वीकृती (सूची से हटा दें)',
	'confirmaccount-hold' => 'प्रलंबित रख्खें',
	'confirmaccount-spam' => 'स्पॅम (इ-मेल ना भेजें)',
	'confirmaccount-reason' => 'टिप्पणी (इ-मेलमें मिलाया जायेगा):',
	'confirmaccount-ip' => 'आइपी एड्रेस:',
	'confirmaccount-submit' => 'निश्चित करें',
	'confirmaccount-needreason' => 'आपको नीचे दिये हुए टिप्पणी बक्सेमें टिप्पणी देना बंधनकारक हैं।',
	'confirmaccount-canthold' => 'यह माँग पहले से ही प्रलंबित रखी या अस्वीकृत की गई हैं।',
	'confirmaccount-acc' => 'खाते की माँग पूरी हो गई, [[User:$1|$1]] यह नया खाता खोल दिया गया हैं।',
	'confirmaccount-rej' => 'खाते की माँग अस्वीकृत कर दी गई हैं।',
	'confirmaccount-viewing' => '([[User:$1|$1]] ने ध्यान रखा हैं)',
	'confirmaccount-summary' => 'नये सदस्य के चरित्र के अनुसार सदस्य पृष्ठ बना रहें हैं।',
	'confirmaccount-wsum' => 'सुस्वागतम्‌!',
	'confirmaccount-email-subj' => '{{SITENAME}} खाता माँग',
	'usercredentials' => 'सदस्य के क्रेडेन्शियल्स',
	'usercredentials-leg' => 'सदस्यके प्रमाणित किये हुए क्रेडेन्शियल्स देखें',
	'usercredentials-user' => 'सदस्यनाम:',
	'usercredentials-text' => 'नीचे चुने हुए सदस्य खाते के प्रमाणित किये हुए क्रेडेन्शियल्स दिये हुए हैं।',
	'usercredentials-leg-user' => 'सदस्य खाता',
	'usercredentials-leg-areas' => 'पसंद के मुख्य एरिया',
	'usercredentials-leg-person' => 'वैयक्तिक ज़ानकारी',
	'usercredentials-leg-other' => 'अन्य ज़ानकारी',
	'usercredentials-email' => 'इ-मेल:',
	'usercredentials-real' => 'असली नाम:',
	'usercredentials-bio' => 'चरित्र:',
	'usercredentials-attach' => 'रिज़्यूम/सीवी:',
	'usercredentials-notes' => 'अधिक ज़ानकारी:',
	'usercredentials-urls' => 'वेबसाईट्स की सूची:',
	'usercredentials-ip' => 'मूल आईपी एड्रेस:',
	'usercredentials-member' => 'अधिकार:',
	'usercredentials-badid' => 'इस सदस्य के क्रेडेन्शियल्स मिले नहीं।
सदस्यनाम सही हैं इसकी जाँच करें।',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name' => 'Ngalan sang Manog-gamit',
	'confirmaccount-email' => 'E-mail:',
	'usercredentials-user' => 'Ngalan sang Manog-gamit:',
	'usercredentials-email' => 'E-mail:',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'requestaccount' => 'Zatraži suradnički račun',
	'requestaccount-text' => "'''Ispunite sljedeći formular i pošaljite ga da biste zatražili suradnički račun'''.

Pročitajte [[{{MediaWiki:Requestaccount-page}}|Uvjete uporabe]] prije traženja suradničkog računa.

Kad vam račun bude odobren, dobit ćete e-mail potvrdu i moći ćete se [[Special:UserLogin|prijaviti]].",
	'requestaccount-page' => '{{ns:project}}:Uvjeti korištenja',
	'requestaccount-dup' => "'''Već ste prijavljeni!'''",
	'requestaccount-leg-user' => 'Suradnički račun',
	'requestaccount-leg-areas' => 'Glavni interesi',
	'requestaccount-leg-person' => 'Osobni podaci',
	'requestaccount-leg-other' => 'Ostali podaci',
	'requestaccount-leg-tos' => 'Uvjeti usluge',
	'requestaccount-acc-text' => "Dobiti ćete poruku elektroničkom poštom (''e-mail'') kao potvrdu da ste zatražili suradnički račun.
Molimo odgovorite na tu poruku tako što ćete kliknuti na poveznicu (''link'') u toj poruci.
Kad vam račun bude odobren/otvoren, lozinku ćete dobiti elektroničkom poštom.",
	'requestaccount-areas-text' => 'Odaberite ispod teme u kojima imate formalno iskustvo ili biste najviše željeli raditi.',
	'requestaccount-ext-text' => 'Sljedeći podaci nisu dostupni drugima, rabe se samo u ovom upitu.
Možda želite navesti broj telefona (mobitela) kao pomoć za potvrđivanje vašeg identiteta.',
	'requestaccount-bio-text' => 'Vaša biografija će biti postavljena kao glavni sadržaj za vašu suradničku stranicu.
Pokušajte napisati nešto o sebi.
Budite sigurni da pišete informacije koje su vama prihvatljive.
Vaše pravo ime možete promijeniti putem [[Special:Preferences|postavki]].',
	'requestaccount-real' => 'Pravo ime:',
	'requestaccount-same' => '(bit će isto kao i pravo ime)',
	'requestaccount-email' => "Adresa e-pošte (vaš ''e-mail''):",
	'requestaccount-reqtype' => 'Mjesto:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'uređivač',
	'requestaccount-bio' => 'Osobna biografija:',
	'requestaccount-attach' => 'Rezime ili CV (po želji):',
	'requestaccount-notes' => 'Dodatne bilješke:',
	'requestaccount-urls' => 'Popis web stranica, ako ih ima (odvojite ih redom):',
	'requestaccount-agree' => 'Morate potvrditi da je vaše pravo ime točno i da pristajete na naše Uvjete korištenja.',
	'requestaccount-inuse' => 'Suradničko ime je već u upotrebi u otvorenom zahtjevu.',
	'requestaccount-tooshort' => 'Vaš životopis mora biti dug najmanje $1 {{PLURAL:$1|riječ|riječi}}.',
	'requestaccount-emaildup' => 'Drugi otvoreni zahtjev ima istu e-mail adresu.',
	'requestaccount-exts' => 'Vrsta datoteke u privitku nije dopuštena.',
	'requestaccount-resub' => 'Vaš CV/rezime mora biti opet odabran iz sigurnosnih razloga. Ostavite polje praznim ako ga ne želite uključiti.',
	'requestaccount-tos' => 'Pročitao sam i slažem se s [[{{MediaWiki:Requestaccount-page}}|Uvjetima uporabe]] internetskih stranica {{SITENAME}}.
Ime koje sam napisao kao "Pravo ime" je moje pravo ime (nije nadimak/alias).',
	'requestaccount-submit' => 'Zatraži račun',
	'requestaccount-sent' => 'Vaš zahtjev je uspješno poslan i sada čeka potvrdu.',
	'request-account-econf' => 'Vaša e-mail adresa je potvrđena i bit će tako označena u vašem zahtjevu.',
	'requestaccount-email-subj' => '{{SITENAME}} potvrda e-mail adrese',
	'requestaccount-email-body' => 'Netko, vjerojatno s vaše IP adrese $1, je zatražio račun "$2" s ovom e-mail adresom na {{SITENAME}}.

Kako biste potvrdili da ovaj račun zaista pripada vama na {{SITENAME}}, otvorite ovaj link u svom pretraživaču:

$3

Ako se račun otvori, samo vama će biti poslana lozinka.
Ako ovo *niste* vi, nemojte otvarati link.
Ovaj potvrdni kod će isteći $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} zahtjev suradničkog računa',
	'requestaccount-email-body-admin' => '"$1" je zatražio suradnički račun i čeka potvrdu.
E-mail adresa je potvrđena. Možete potvrditi zahtjev ovdje "$2".',
	'acct_request_throttle_hit' => 'Žao nam je, već ste zatražili {{PLURAL:$1|1 suradnički račun|$1 suradničke račune}}. Ne možete postaviti nove zahtjeve.',
	'requestaccount-loginnotice' => "Da bi dobili suradnički račun, trebate ga '''[[Special:RequestAccount|zatražiti]]'''.",
	'confirmaccount-newrequests' => "u tijeku '''$1''' e-mailom {{PLURAL:$1|potvrđen [[Special:ConfirmAccounts|zahtjev za računom]]|potvrđenih [[Special:ConfirmAccounts|zahtjeva za računom]]}}",
	'confirmaccounts' => 'Potvrdi zahtjeve za suradničkim računom',
	'confirmedit-desc' => 'Daje birokratima pravo potvrditi zahtjeve za suradničkim računom',
	'confirmaccount-none-o' => 'Trenutačno nema otvorenih zahtjeva na ovom popisu.',
	'confirmaccount-none-h' => 'Nema zahtjeva u popisu čekanja.',
	'confirmaccount-none-r' => 'Nema nedavno odbijenih zahtjeva na popisu.',
	'confirmaccount-none-e' => 'Trenutačno nema isteklih zahtjeva na ovom popisu.',
	'confirmaccount-real-q' => 'Ime',
	'confirmaccount-email-q' => 'E-pošta (e-mail)',
	'confirmaccount-bio-q' => 'Biografija',
	'confirmaccount-showopen' => 'otvorenih zahtjeva',
	'confirmaccount-showrej' => 'odbijenih zahtjeva',
	'confirmaccount-showheld' => 'Vidi popis zahtjeva na čekanju',
	'confirmaccount-showexp' => 'zastarjelih zahtjeva',
	'confirmaccount-review' => 'Potvrdi/odbij',
	'confirmaccount-types' => 'Odaberite red potvrđivanja računa:',
	'confirmaccount-all' => '(prikaži sve redove)',
	'confirmaccount-type' => 'Red:',
	'confirmaccount-q-open' => 'neodgovoreni zahtjevi',
	'confirmaccount-q-held' => 'zahtjevi na čekanju',
	'confirmaccount-q-rej' => 'nedavno odbijeni zahtjevi',
	'confirmaccount-q-stale' => 'istekli zahtjevi',
	'confirmaccount-badid' => 'Nema zahtjeva koji ima dani ID. Najvjerojatnije je zahtjev već obrađen.',
	'confirmaccount-leg-user' => 'Suradnički račun',
	'confirmaccount-leg-areas' => 'Glavne grane interesa',
	'confirmaccount-leg-person' => 'Osobne informacije',
	'confirmaccount-leg-other' => 'Ostale informacije',
	'confirmaccount-name' => 'Suradničko ime',
	'confirmaccount-real' => 'Ime:',
	'confirmaccount-email' => "E-pošta (''e-mail''):",
	'confirmaccount-reqtype' => 'Mjesto:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'urednik',
	'confirmaccount-bio' => 'Biografija:',
	'confirmaccount-attach' => 'Biografija/CV:',
	'confirmaccount-notes' => 'Dodatne bilješke:',
	'confirmaccount-urls' => 'Popis web stranica:',
	'confirmaccount-none-p' => '(nije naveden)',
	'confirmaccount-confirm' => 'Koristite opcije ispod za potvrditi, odbiti ili staviti na čekanje ovaj zahtjev.',
	'confirmaccount-econf' => '(potvrđen)',
	'confirmaccount-reject' => '(zahtjev odbio [[User:$1|$1]] dana $2)',
	'confirmaccount-noreason' => '(ništa)',
	'confirmaccount-autorej' => '(ovaj zahtjev je automatski odbačen zbog neaktivnosti)',
	'confirmaccount-held' => '(označio "na čekanju" suradnik [[User:$1|$1]], $2)',
	'confirmaccount-create' => 'Prihvati zahtjev (otvori suradnički račun)',
	'confirmaccount-deny' => 'Odbij (i skini s popisa)',
	'confirmaccount-hold' => 'Zadrži',
	'confirmaccount-spam' => 'Spam (ne šalji e-mail)',
	'confirmaccount-reason' => 'Komentar (uključen u e-mail):',
	'confirmaccount-ip' => 'IP adresa:',
	'confirmaccount-submit' => 'Potvrdi',
	'confirmaccount-needreason' => 'Morate dati razlog u okviru ispod.',
	'confirmaccount-canthold' => 'Ovaj zahtjev je već ili na čekanju ili obrisan.',
	'confirmaccount-acc' => 'Suradnički račun je uspješno potvrđen; otvoren je novi suradnički račun [[User:$1|$1]].',
	'confirmaccount-summary' => 'Stvaranje suradničke stranice sa životopisom novog suradnika.',
	'confirmaccount-wsum' => 'Dobrodošli!',
	'confirmaccount-email-subj' => '{{SITENAME}} zahtjev suradničkog računa',
	'usercredentials-user' => 'Suradničko ime:',
	'usercredentials-leg-user' => 'Suradnički račun',
	'usercredentials-leg-person' => 'Osobni podaci',
	'usercredentials-leg-other' => 'Ostali podaci',
	'usercredentials-email' => "E-pošta (''e-mail''):",
	'usercredentials-real' => 'Pravo ime:',
	'usercredentials-bio' => 'Biografija:',
	'usercredentials-attach' => 'Rezime/CV:',
	'usercredentials-notes' => 'Dodatne bilješke:',
	'usercredentials-urls' => 'Popis internetskih stranica:',
	'usercredentials-ip' => 'Izvorna IP adresa:',
	'usercredentials-member' => 'Prava:',
	'usercredentials-badid' => 'Za danog suradnika nisu nađeni podaci.
Provjerite je li ime točno napisano.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'requestaccount' => 'Wužiwarske konto sej žadać',
	'requestaccount-text' => "'''Wupjelń slědowacy formular a wotesćel jón, zo by wužiwarske konto požadał'''. 

Prošu přečitaj najprjedy [[{{MediaWiki:Requestaccount-page}}|wužiwanske wuměnjenja]], prjedy hač požadaš wužiwarske konto.

Tak ruče kaž konto je so potwjerdźiło, dóstanješ powěsć přez e-mejlku a móžeš [[Special:UserLogin|Konto wutworić abo so přizjewić]].",
	'requestaccount-page' => '{{ns:project}}:Wužiwanske wuměnjenja',
	'requestaccount-dup' => "'''Kedźbu: Sy hižo ze zregistrowanym wužiwarskim kontom přizjewjeny.'''",
	'requestaccount-leg-user' => 'Wužiwarske konto',
	'requestaccount-leg-areas' => 'Hłowne zajimowe wobwody',
	'requestaccount-leg-person' => 'Wosobinske informacije',
	'requestaccount-leg-other' => 'Druhe informacije',
	'requestaccount-leg-tos' => 'Wužiwanske wuměnjenja',
	'requestaccount-acc-text' => 'K twojej e-mejlowej adresy budźe so po wotesłanju tutoho formulara wobkrućenska mejlka słać. Prošu wotmołw na to přez kliknjenje na wobkrućenski wotkaz, kotryž mejlka wobsahuje. Tak ruče kaž twoje konto je wutworjene, so ći twoje hesło připósćele.',
	'requestaccount-areas-text' => 'Wubjer slědowace temowe wobwody, w kotrychž maš wěcywustojnosć abo chceš najwjace dźěła činić.',
	'requestaccount-ext-text' => 'Ze slědowacymi informacijemi so dowěrliwje wobchadźa a jenož za tute požadne wužiwa. Móžeš kontaktowe informacije, kaž na př. telefonowe čisło, podać, zo by wobdźěłowanje swojeho požadanja zjednorił.',
	'requestaccount-bio-text' => 'Twoja biografija budźe so jako standardny wobsah twojeje wužiwarskeje strony składować.
Spytaj referency zapřijimać.
Zawěsć, zo chceš te informacije woprawdźe wozjewić.
Móžeš swoje wužiwarske mjeno pod [[Special:Preferences|Nastajenja]] změnić.',
	'requestaccount-real' => 'Woprawdźite mjeno:',
	'requestaccount-same' => '(kaž woprawdźite mjeno)',
	'requestaccount-email' => 'E-mejlowa adresa:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'awtor',
	'requestaccount-level-1' => 'Wobdźěłowar',
	'requestaccount-bio' => 'Wosobinska biografija:',
	'requestaccount-attach' => 'Žiwjenjoběh',
	'requestaccount-notes' => 'Přidatne podaća:',
	'requestaccount-urls' => 'Lisćina webowych sydłow (přez linkowe łamanja wotdźělene)',
	'requestaccount-agree' => 'Dyrbiš potwjerdźić, zo twoje woprawdźite mjeno je korektne a wužiwarske wuměnjenja akceptuješ.',
	'requestaccount-inuse' => 'Wužiwarske mjeno so hižo w druhim kontowym požadanju wužiwa.',
	'requestaccount-tooshort' => 'Twoja biografija dyrbi znajmjeńša $1 {{PLURAL:$1|słowo|słowje|słowa|słowow}} dołho być.',
	'requestaccount-emaildup' => 'Druhe předležace kontowe požadanje samsnu e-mejlowu adresu wužiwa.',
	'requestaccount-exts' => 'Datajowy typ přiwěška je njedowoleny.',
	'requestaccount-resub' => 'Twoja žiwjenjoběhowa dataja dyrbi so z přičinow wěstoty znowa wubrać. Wostaj polo prózdne, jeli hižo nochceš tajku zapřijimać.',
	'requestaccount-tos' => 'Sym wužiwarske wuměnjenja strony {{SITENAME}} přečitał a budu do nich dźeržeć.',
	'requestaccount-submit' => 'Wužiwarske konto sej žadać',
	'requestaccount-sent' => 'Twoje kontowe požadanje bu wuspěšnje wotpósłane a dyrbi so nětko přepruwować. Wobrućenska e-mejl bu na twoju e-mejlowu adresu pósłana.',
	'request-account-econf' => 'Twoja e-mejlowa adresa bu wobkrućena a budźe so w twojim kontowym požadanju nalistować.',
	'requestaccount-email-subj' => '{{SITENAME}} Pruwowanje e-mejloweje adresy',
	'requestaccount-email-body' => 'Něštó z IP-adresu $1, snano ty, je pola {{SITENAME}} wužiwarske konto "$2" z twojej e-mejlowej adresu požadał.

Zo by wobkrućił, zo woprawdźe ty sy tute konto pola {{SITENAME}} požadał, wočiń prošu slědowacy wotkaz we swojim wobhladowaku:

$3

Hdyž je so wužiwarske konto wutworiło, dóstanješ dalšu mejlku z hesłom.

Jeli *njej*sy wužiwarske konto požadał, njewočiń prošu tutón wotkaz!

Tutón wobkrućenski kod budźe w $4 płaciwy.',
	'requestaccount-email-subj-admin' => 'Požadanje konta za {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" je konto požadał a čaka na potwjerdźenje. E-mejlowa adresa bu potwjerdźena. Móžeš požadanje tu "$2" potwjerdźić.',
	'acct_request_throttle_hit' => 'Wodaj, sy hižo $1 {{PLURAL:$1|1 konto|$1 konće|$1 konta|$1 kontow}} požadał. Njemóžeš žane dalše konta požadać.',
	'requestaccount-loginnotice' => "Zo by wužiwarske konto dóstał, dyrbiš wo nje '''[[Special:RequestAccount|prosyć]]'''.",
	'confirmaccount-newrequests' => "{{PLURAL:$1|Čaka|Čakatej|Čakaja|Čaka}} tuchwilu '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|kontowe požadanje]]|[[Special:ConfirmAccounts|kontowej požadani]]|[[Special:ConfirmAccounts|kontowe požadanja]]|[[Special:ConfirmAccountskontowych požadanjow]]}}.",
	'confirmaccounts' => 'Kontowe požadanja potwjerdźić',
	'confirmedit-desc' => 'Dawa běrokratam móžnosć kontowe požadanja potwjerdźić',
	'confirmaccount-maintext' => "'''Tuta strona wužiwa so, zo by njesčinjene kontowe požadanja na ''{{SITENAME}}'' potwjerdźiło'''.

Kóžde čakanski rynk kontowych požadanjow wobsteji z třoch čakanskich podrynkow, jedyn za wotewrjene požadanje, jedyn za te, kotrež buchu wot administratorow falowacych informacijow dla do čakanskeje sekle stajili a třeći za tuchwilu wotpokazane požadanja.

Wotmołwjejo na požadanje, pruwuj je starosćiwje a, jeli trjeba, potwjerdź w nim wobsahowane informacije.
Twoje akcije so protokuluja. Wot tebje so wočakuje, zo by aktiwnosć pruwował, kotraž tu wotměwa, wothladajo to, štož sam činiš.",
	'confirmaccount-list' => 'Deleka je lisćina wužiwarskich požadanjow, kotrež čakaja na přizwolenje. Potwjerdźene konta budu so wutworjeć a z lisćiny wotstronjeć. Wotpokazane konta so prosće z lisćiny šmórnu.',
	'confirmaccount-list2' => 'Deleka je lisćina tuchwilu wotpokazanych kontowych požadanjow, kotrež hodźa so awtomatisce po někotrych dnjach šmórnyć. Móža so hišće za konta přizwolić, byrnjež ty najprjedy administratora konsultował, kiž je wotpokaza, prjedy hač činiš to.',
	'confirmaccount-list3' => 'Deleka je lisćina spadnjenych kontowych požadanjow, kotrež hodźa so po wjacorych dnjach awtomatisće wušmórnyć. Hodźa so hišće jako konta potwjerdźić.',
	'confirmaccount-text' => "To je njerozsudźene požadanje za wužiwarskim kontom pola '''{{SITENAME}}'''. Pruwuj wšě deleka stejace informacije dokładnje a potwjerdź je. Prošu wobkedźbuj, zo móžeš konto, jeli trjeba, pod druhim wužiwarskim mjenom wutworić. Wužij to jenož, zo by kolizije z druhimi mjenami wobešoł.

Jeli tutu stronu prosće wopušćeš, bjeztoho zo by konto potwjerdźił abo wotpokazał, budźe požadanje njerozsudźene wostać.",
	'confirmaccount-none-o' => 'Tuchwilu žane wotewrjene kontowe požadanja w tutej lisćinje njejsu.',
	'confirmaccount-none-h' => 'Tuchwilu žane kontowe požadanja w tutej lisćinje w čakanskej sekli njejsu.',
	'confirmaccount-none-r' => 'Tuchwilu žane runje wotpokazane kontowe požadanja w tutej lisćinje njejsu.',
	'confirmaccount-none-e' => 'Tuchwilu žane spadnjene kontowe požadanja w tutej lisćinje njejsu.',
	'confirmaccount-real-q' => 'Mjeno',
	'confirmaccount-email-q' => 'E-mejl',
	'confirmaccount-bio-q' => 'Biografija',
	'confirmaccount-showopen' => 'njesčinjene požadanja',
	'confirmaccount-showrej' => 'wotpokazane požadanja',
	'confirmaccount-showheld' => 'Zadźeržane požadanja',
	'confirmaccount-showexp' => 'spadnjene požadanja',
	'confirmaccount-review' => 'Dowolić/Wotpokazać',
	'confirmaccount-types' => 'Wubjer rynk za kontowe potwjerdźenje:',
	'confirmaccount-all' => '(pokazaj wšě rynki)',
	'confirmaccount-type' => 'Čakacy rynk:',
	'confirmaccount-type-0' => 'přichodni awtorojo',
	'confirmaccount-type-1' => 'přichodne editory',
	'confirmaccount-q-open' => 'njesčinjene požadanja',
	'confirmaccount-q-held' => 'čakace požadanja',
	'confirmaccount-q-rej' => 'tuchwilu wotpokazane požadanja',
	'confirmaccount-q-stale' => 'Spadnjene požadanja',
	'confirmaccount-badid' => 'Tuchwilu požadane k podatemu ID. Snano bu hižo sčinjene.',
	'confirmaccount-leg-user' => 'Wužiwarske konto',
	'confirmaccount-leg-areas' => 'Hłowne zajimowe wobwody',
	'confirmaccount-leg-person' => 'Wosobinske informacije',
	'confirmaccount-leg-other' => 'Druhe informacije',
	'confirmaccount-name' => 'Wužiwarske mjeno',
	'confirmaccount-real' => 'Mjeno',
	'confirmaccount-email' => 'E-mejl',
	'confirmaccount-reqtype' => 'Pozicija:',
	'confirmaccount-pos-0' => 'awtor',
	'confirmaccount-pos-1' => 'Wobdźěłowar',
	'confirmaccount-bio' => 'Biografija',
	'confirmaccount-attach' => 'Žiwjenjoběh:',
	'confirmaccount-notes' => 'Přidatne přispomnjenki:',
	'confirmaccount-urls' => 'Lisćina webowych sydłow:',
	'confirmaccount-none-p' => '(njepodaty)',
	'confirmaccount-confirm' => 'Wužij tłóčatka deleka, zo by požadanje akceptował abo wotpokazał.',
	'confirmaccount-econf' => '(potwjerdźene)',
	'confirmaccount-reject' => '(wot [[Wužiwar:$1|$1]] na $2 wotpokazany)',
	'confirmaccount-rational' => 'Rozjasnjenje požadarjej:',
	'confirmaccount-noreason' => '(žane)',
	'confirmaccount-autorej' => '(tute požadanje bu inaktiwnosće dla awtomatisce zaćisnjene)',
	'confirmaccount-held' => '(wot [[User:$1|$1]] on $2 jako "čakacy" markěrowany)',
	'confirmaccount-create' => 'Akceptować (Konto wutworić)',
	'confirmaccount-deny' => 'Wotpokazać (Požadanje wotstronić)',
	'confirmaccount-hold' => 'Čakać dać',
	'confirmaccount-spam' => 'Spam (njesćel mejlku)',
	'confirmaccount-reason' => 'Komentar (budźe so do mejlki k próstwarjej zasunyć):',
	'confirmaccount-ip' => 'IP-adresa',
	'confirmaccount-legend' => 'Tute konto wobkrućić/wotpokazać',
	'confirmaccount-submit' => 'Potwjerdźić',
	'confirmaccount-needreason' => 'Dyrbiš deleka w komentarowym polu přičinu podać.',
	'confirmaccount-canthold' => 'Tute požadanje je pak hižo čakanskej sekli pak wušmórnjene.',
	'confirmaccount-acc' => 'Požadanje za kontom bu wuspěšnje wobkrućene; konto za wužiwarja [[User:$1|$1]] bu wutworjene.',
	'confirmaccount-rej' => 'Požadanje za kontom bu wotpokazane.',
	'confirmaccount-viewing' => '(wobhladuje so runje wot [[User:$1|$1]])',
	'confirmaccount-summary' => 'Wutworja so wužiwarska strona z biografiju noweho wužiwarja.',
	'confirmaccount-welc' => "'''Witaj do ''{{SITENAME}}''!'''
Nadźijemy so, zo dodaš wjele dobrych přinoškow.
Snano chceš najprjedy [[Pomoc:Prěnje kroki|Prěnje kroki]] čitać.
Hišće raz: Witaj a wjele wjesela!",
	'confirmaccount-wsum' => 'Witaj!',
	'confirmaccount-email-subj' => '{{SITENAME}} Požadanje za wužiwarskim kontom',
	'confirmaccount-email-body' => 'Twoje požadanje za wužiwarskim kontom bu na {{SITENAME}} schwalene.

Wužiwarske mjeno: $1

Hesło: $2

Z přičinow wěstoty, měł ty swoje hesło při prěnim přizjewjenju na kóždy pad změnić. Zo by přizjewił, dźi přosu na stronu {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2' => 'Twoje požadanje za wužiwarskim kontom pola {{SITENAME}} bu schwalene.

Wužiwarske mjeno: $1

Hesło: $2

$3

Z přičinow wěstoty měł ty swoje hesło při prěnim přizjewjenu nak kóďy pad změnić. Zo by přizjewil, dźi prošu na stronu {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3' => 'Bohužel bu twoje požadanje za wužiwarskim kontom "$1" pola {{SITENAME}} wotpokazane.

To móže wjele přičinow měć. Snano njejsy formular korektnje wupjelnił, njejsy dosć podaćow činił abo njejsy druhe kriterije spjelnił.

Snano je na stronje kontaktowe adresy, na kotrež móžeš so wobroćić, jeli chceš wjace wo žadanjach wědźeć.',
	'confirmaccount-email-body4' => 'Bohužel bu twoje požadanje za wužiwarskim kontom "$1" na {{SITENAME}} wotpokazane.

$2

Snano su na sydle kontaktowe adresy, na kotrež so móžeš wobroćeć, jeli chceš wjace wo žadanjach wužiwarskich kontow wědźeć.',
	'confirmaccount-email-body5' => 'Prjedy hač konto "$1" požadaš, kotrež hodźi so na {{SITENAME}} akceptować, dyrbiš najprjedy někotre přidatne informacije podać.

$2

Snano su kontaktowe lisćiny na sydle, kotrež móžeš wužiwać, jeli chceš wjace wo prawidłach za wužiwarske konta wědźeć.',
	'usercredentials' => 'Wužiwarske daty',
	'usercredentials-leg' => 'Pytanje potwjerdźi daty za wužiwarja',
	'usercredentials-user' => 'Wužiwarske mjeno',
	'usercredentials-text' => 'Deleka su přepruwowane daty wubraneho wužiwarskeho konta.',
	'usercredentials-leg-user' => 'Wužiwarske konto',
	'usercredentials-leg-areas' => 'Hłowne zajimowe wobwody',
	'usercredentials-leg-person' => 'Wosobinske informacije',
	'usercredentials-leg-other' => 'Druhe informacije',
	'usercredentials-email' => 'E-mejl:',
	'usercredentials-real' => 'Woprawdźite mjeno:',
	'usercredentials-bio' => 'Biografija:',
	'usercredentials-attach' => 'Žiwjenjoběh:',
	'usercredentials-notes' => 'Přidatne přispomnjenki:',
	'usercredentials-urls' => 'Lisćina websydłow:',
	'usercredentials-ip' => 'Originalna IP-adresa:',
	'usercredentials-member' => 'Prawa:',
	'usercredentials-badid' => 'Žane daty za tutoho wužiwarja namakane. Kontroluj, hač mjeno je prawje napisane.',
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Čakanski rynk z požadanymi kontami]] sej wobhladać',
	'right-requestips' => 'IP-adresy požadarja sej wobhladać, mjeztym zo so požadane konta předźěłuja',
	'right-lookupcredentials' => '[[Special:UserCredentials|Wužiwarske woprawnjenki]] sej wobhladać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Tgr
 */
$messages['hu'] = array(
	'requestaccount' => 'Felhasználói fiók kérése',
	'requestaccount-text' => "'''Az alábbi űrlap kitöltésével kérhetsz felhasználói fiókot'''.

Mindenek előtt olvasd el a [[{{MediaWiki:Requestaccount-page}}|használat feltételeit]].

Ha a felhasználói fiókodat elfogadjuk, értesítve leszel e-mailben, ezután beléphetsz vele a [[Special:UserLogin|bejelentkezés]] lapon.",
	'requestaccount-page' => '{{ns:project}}:Használati feltételek',
	'requestaccount-dup' => "'''Megjegyzés: már be vagy jelentkezve egy regisztrált felhasználói fiókkal.'''",
	'requestaccount-leg-user' => 'Felhasználói fiók',
	'requestaccount-leg-areas' => 'Érdeklődési területek',
	'requestaccount-leg-person' => 'Személyes információ',
	'requestaccount-leg-other' => 'További információ',
	'requestaccount-leg-tos' => 'Használati feltételek',
	'requestaccount-acc-text' => 'Miután elküldted a kérelmet, egy e-mail üzenetet küldünk a címedre. Kattints a benne található
megerősítő linkre. Miután felhasználói fiókod elkészült, jelszavadat is elküldjük.',
	'requestaccount-areas-text' => 'Válaszd ki azokat a témaköröket, amelyek területén szaktudással rendelkezel vagy dolgozni szeretnél főként.',
	'requestaccount-ext-text' => 'A következő információ titkos marad, és csak a kérelem során lesz használva.
Megadhatsz kapcsolati adatokat, pl. telefonszámot, hogy segíts a személyazonosságod megerősítésében.',
	'requestaccount-bio-text' => 'Az életrajzod lesz a felhasználói lapod alapértelmezett tartalma.
Próbálj meg bizonyítványokat is belefoglalni.
Győződj meg arról, hogy tényleg közzé szeretnéd-e tenni ezeket az információkat.
A nevedet megváltoztathatod a „[[Special:Preferences|beállításaim]]” lapon.',
	'requestaccount-real' => 'Valódi név:',
	'requestaccount-same' => '(ugyanaz, mint a valódi név)',
	'requestaccount-email' => 'E-mail cím:',
	'requestaccount-reqtype' => 'Pozíció:',
	'requestaccount-level-0' => 'szerző',
	'requestaccount-level-1' => 'szerkesztő',
	'requestaccount-bio' => 'Személyes életrajz:',
	'requestaccount-attach' => 'CV (nem kötelező)',
	'requestaccount-notes' => 'További megjegyzések:',
	'requestaccount-urls' => 'Weboldalak listája, ha van (külön sorba írd őket):',
	'requestaccount-agree' => 'Igazolnod kell, hogy neved valódi és elfogadod a használati feltételeket.',
	'requestaccount-inuse' => 'A felhasználói nevet már használták egy elfogadásra váró kérelemnél.',
	'requestaccount-tooshort' => 'Az életrajzodnak minimum {{PLURAL:$1|egy|$1}} szót kell tartalmaznia.',
	'requestaccount-emaildup' => 'Egy másik kérelemnél már megadták ugyanezt az e-mail címet.',
	'requestaccount-exts' => 'A csatolt fájl típusa nem engedélyezett.',
	'requestaccount-resub' => 'A CV-fájlodat újra ki kell választani biztonsági okok miatt. Hagyd a mezőt üresen,
ha már nem akarod mellékelni.',
	'requestaccount-tos' => 'Elolvastam és elfogadom a(z) {{SITENAME}} [[{{MediaWiki:Requestaccount-page}}|használati feltételeit]].
A „Valódi név” mezőben megadott név az én valódi nevem.',
	'requestaccount-submit' => 'Felhasználói fiók kérése',
	'requestaccount-sent' => 'A kérelmed sikeresen el lett küldve, és most elfogadásra vár.
Küldtünk egy megerősítő levelet az e-mail címedre.',
	'request-account-econf' => 'Az e-mail címed meg lett erősítve, és meg fog jelenni a kérelmedben.',
	'requestaccount-email-subj' => '{{SITENAME}} e-mail cím megerősítés',
	'requestaccount-email-body' => 'Valaki, valószínűleg te, a $1 IP-címről kérte a "$2" nevű
felhasználói fiókot a(z) {{SITENAME}} wikin.

Annak érdekében, hogy megerősítsd, ez az azonosító valóban hozzád tartozik, nyisd meg az alábbi linket a böngésződben:

$3


Ha a fiók elkészült, akkor elküldjük a jelszavadat. Ha ez *nem* te vagy, ne kattints a linkre.
Ennek a megerősítésre szánt kódnak a felhasználhatósági ideje lejár: $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} felhasználói fiók kérelem',
	'requestaccount-email-body-admin' => '"$1" regisztrációja jóváhagyásra vár.
Az e-mail cím ellenőrzése sikeres volt. Itt hagyhatod jóvá a kérést: "$2".',
	'acct_request_throttle_hit' => 'Sajnáljuk, de már kértél {{PLURAL:$1|egy|$1}} felhasználói fiókot.
Nem igényelhetsz újabbakat.',
	'requestaccount-loginnotice' => "Ha felhasználói fiókot szeretnél, akkor '''[[Special:RequestAccount|kérned kell egyet]]'''.",
	'confirmaccount-newrequests' => "Jelenleg '''$1''' [[Special:ConfirmAccounts|felhasználói fiók-kérelem]] vár megerősítésre.",
	'confirmaccounts' => 'Felhasználói fiók-kérelem megerősítése',
	'confirmedit-desc' => 'Lehetővé teszi a bürokraták számára a felhasználói fiók kérelmek megerősítését.',
	'confirmaccount-maintext' => "'''Ezen a lapon lehet megerősíteni a felhasználói fiókokra vonatkozó kérelmeket'''.

A várósor három részre oszlik: egy az új kérelmeket, egy azokat a kérelmeket, melyekhez további adatok szükségesek és egy a visszautasított kérelmeket tartalmazza.

Mikor egy kérelemre válaszolsz, gondosan nézd át, és ha szükséges, erősítsd meg a benne található információkat.
Az általad végzett műveleteket titokban naplózzuk.",
	'confirmaccount-list' => 'Itt található az elfogadásra váró kérések listája.
Az elfogadott fiókok el lesznek készítve, és törlődnek a listáról. A visszautasított kérések egyszerűen törlődnek.',
	'confirmaccount-list2' => 'Itt találhatóak a nem rég visszautasított kérelmek, melyek automatikusan törlődnek néhány nap után. Még mindig el lehet őket fogadni, de beszélj a visszautasító adminisztrátorral a művelet végrehajtása előtt.',
	'confirmaccount-list3' => 'Alább a lejárt felhasználói fiók kérelmek listája látható, amelyek pár nap után automatikusan törölhetőek; azonban még el lehet fogadni őket.',
	'confirmaccount-text' => 'Ez egy elfogadásra váró felhasználói fiók-kérelem.

Gondosan nézd át az információkat. Ha el szeretnéd fogadni, a pozíció legördülő listában állítsd be a felhasználói
fiók állapotát. Az életrajzban végzett szerkesztések nem módosítják a tárolt bizonyítványokat. A felhasználói fiókot
más néven is elkészítheted. Ezt csak akkor használd, ha más nevekkel való ütközéseket szeretnéd kiküszöbölni.

Ha üresen hagyod az oldalt, a kérelem elfogadása vagy visszautasítása nélkül, akkor továbbra is elfogadásra fog várni.',
	'confirmaccount-none-o' => 'Jelenleg nincs elfogadásra váró kérelem a listában.',
	'confirmaccount-none-h' => 'Jelenleg nincs visszatartott kérelem a listában.',
	'confirmaccount-none-r' => 'Jelenleg nincs visszautasított kérelem a listában.',
	'confirmaccount-none-e' => 'Jelenleg nincs lejárt fiók-kérelem a listában.',
	'confirmaccount-real-q' => 'Név',
	'confirmaccount-email-q' => 'E-mail cím',
	'confirmaccount-bio-q' => 'Életrajz',
	'confirmaccount-showopen' => 'elfogadásra váró kérelmek',
	'confirmaccount-showrej' => 'visszautasított kérelmek',
	'confirmaccount-showheld' => 'Visszatartott fiókok listájának megtekintése',
	'confirmaccount-showexp' => 'lejárt kérelmek',
	'confirmaccount-review' => 'Áttekintés',
	'confirmaccount-types' => 'Válassz egy várólistát az alábbiak közül:',
	'confirmaccount-all' => '(összes várólista megtekintése)',
	'confirmaccount-type' => 'Kiválasztott várólista:',
	'confirmaccount-type-0' => 'leendő szerzők',
	'confirmaccount-type-1' => 'leendő szerkesztő',
	'confirmaccount-q-open' => 'elfogadásra váró kérelmek',
	'confirmaccount-q-held' => 'visszatartott kérelmek',
	'confirmaccount-q-rej' => 'visszautasított kérelmek',
	'confirmaccount-q-stale' => 'lejárt kérelmek',
	'confirmaccount-badid' => 'Nincs elfogadásra váró kérelem a megadott azonosítóval. Valószínűleg már el lett intézve.',
	'confirmaccount-leg-user' => 'Felhasználói fiók',
	'confirmaccount-leg-areas' => 'Érdeklődési területek',
	'confirmaccount-leg-person' => 'Személyes információ',
	'confirmaccount-leg-other' => 'További információ',
	'confirmaccount-name' => 'Felhasználói név',
	'confirmaccount-real' => 'Név:',
	'confirmaccount-email' => 'E-mail cím:',
	'confirmaccount-reqtype' => 'Pozíció:',
	'confirmaccount-pos-0' => 'szerző',
	'confirmaccount-pos-1' => 'szerkesztő',
	'confirmaccount-bio' => 'Életrajz:',
	'confirmaccount-attach' => 'CV:',
	'confirmaccount-notes' => 'További megjegyzések:',
	'confirmaccount-urls' => 'Weboldalak listája:',
	'confirmaccount-none-p' => '(nincs megadva)',
	'confirmaccount-confirm' => 'A lenti beállításokkal elfogadhatod, visszautasíthatod vagy visszatarthatod a kérelmet:',
	'confirmaccount-econf' => '(megerősítve)',
	'confirmaccount-reject' => '(visszautasította [[User:$1|$1]] $2-kor)',
	'confirmaccount-rational' => 'A jelentkezőnek adott magyarázat:',
	'confirmaccount-noreason' => '(nincs)',
	'confirmaccount-autorej' => '(ezt a kérelmet automatikusan elvetettük inaktivitás miatt)',
	'confirmaccount-held' => '(visszatartotta [[User:$1|$1]] $2-kor)',
	'confirmaccount-create' => 'Elfogadás (fiók elkészítése)',
	'confirmaccount-deny' => 'Visszautasítás (törlés a listáról)',
	'confirmaccount-hold' => 'Visszatartás',
	'confirmaccount-spam' => 'Spam (ne küldjön e-mailt)',
	'confirmaccount-reason' => 'Megjegyzés (az e-mailhez lesz csatolva):',
	'confirmaccount-ip' => 'IP-cím:',
	'confirmaccount-submit' => 'Megerősítés',
	'confirmaccount-needreason' => 'Meg kell adnod az okot a megjegyzés mezőben.',
	'confirmaccount-canthold' => 'A kérelmet már visszatartották vagy törölték.',
	'confirmaccount-acc' => 'A kérelem sikeresen meg lett erősítve; az új felhasználói fiók [[User:$1|$1]] néven lett elkészítve.',
	'confirmaccount-rej' => 'A kérelem sikeresen visszautasítva.',
	'confirmaccount-viewing' => '(jelenleg [[User:$1|$1]] nézi)',
	'confirmaccount-summary' => 'Felhasználói lap elkészítése az új felhasználó életrajzával.',
	'confirmaccount-welc' => "'''Üdvözlet a(z) ''{{SITENAME}}'' wikin!''' Reméljük, hogy sokat fogsz szerkeszteni.
Elolvashatod a [[{{MediaWiki:Helppage}}|segítséglapokat]] is. Üdvözlet mégegyszer, és érezd jól magadat!",
	'confirmaccount-wsum' => 'Üdvözlet!',
	'confirmaccount-email-subj' => '{{SITENAME}} felhasználói fiók-kérelem',
	'confirmaccount-email-body' => 'A felhasználói fiók-kérelmedet elfogadtuk a(z) {{SITENAME}} wikin.

Felhasználói név: $1

Jelszó: $2

Biztonsági okok miatt meg kell változtatnod a jelszavadat az első bejelentkezésed során. A bejelentkezéshez menj a
{{fullurl:Special:UserLogin}} lapra.',
	'confirmaccount-email-body2' => 'A felhasználói fiók-kérelmedet elfogadtuk a(z) {{SITENAME}} wikin.

Felhasználói név: $1

Jelszó: $2

$3

Biztonsági okok miatt meg kell változtatnod a jelszavadat az első bejelentkezésed során. A bejelentkezéshez menj a
{{fullurl:Special:UserLogin}} lapra.',
	'confirmaccount-email-body3' => 'Sajnálattal közöljük, hogy a regisztrációdat („$1”) elutasították a(z) {{SITENAME}} wikin.

Számos oka lehet a dolognak. Lehet, hogy nem töltötted ki helyesen az űrlapot, nem adtál meg elég információt, vagy más irányelv miatt utasítottak vissza.  Ha több információt szeretnél megtudni a felhasználói fiókokkal kapcsolatos irányelvekről, az oldalon megtalálhatod a kapcsolattartási listát.',
	'confirmaccount-email-body4' => 'Sajnálattal közöljük, hogy a regisztrációdat („$1” néven) elutasították a(z) {{SITENAME}} wikin.

$2

Ha több információt szeretnél megtudni a felhasználói fiókokkal kapcsolatos irányelvekről, az oldalon megtalálhatod a kapcsolattartási listát.',
	'confirmaccount-email-body5' => 'Ahhoz, hogy elfogadjuk "$1" felhasználói fiók-kérelmedet a(z) {{SITENAME}} wikin,
néhány további információt kell megadnod.

$2

Ha több információt szeretnél megtudni a felhasználói fiókokkal kapcsolatos irányelvekről, az oldalon megtalálhatod a kapcsolattartási listát.',
	'usercredentials' => 'Személyi adatok',
	'usercredentials-leg' => 'Megerősített felhasználói adatok kikeresése',
	'usercredentials-user' => 'Felhasználói név:',
	'usercredentials-text' => 'Itt találhatóak a felhasználói fiókhoz tartozó, megerősített adatok.',
	'usercredentials-leg-user' => 'Felhasználói fiók',
	'usercredentials-leg-areas' => 'Érdeklődési területek',
	'usercredentials-leg-person' => 'Személyes információ',
	'usercredentials-leg-other' => 'További információ:',
	'usercredentials-email' => 'E-mail cím:',
	'usercredentials-real' => 'Valódi név:',
	'usercredentials-bio' => 'Életrajz:',
	'usercredentials-attach' => 'CV:',
	'usercredentials-notes' => 'További megjegyzések:',
	'usercredentials-urls' => 'Weboldalak listája:',
	'usercredentials-ip' => 'Valódi IP-cím:',
	'usercredentials-member' => 'Jogok:',
	'usercredentials-badid' => 'A felhasználó nem rendelkezik személyes adatokkal. Ellenőrizd, hogy helyesen adtad-e meg a nevét.',
	'right-confirmaccount' => '[[Special:ConfirmAccounts|kért felhasználói fiókok várakozási sorának]] megtekintése',
	'right-requestips' => 'az igénylők IP-címeinek megtekintése a kért fiókok feldolgozása közben',
	'right-lookupcredentials' => '[[Special:UserCredentials|felhasználói azonosító információk]] megjelenítése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'requestaccount' => 'Requestar conto',
	'requestaccount-text' => "'''Completa e submitte le sequente formulario pro requestar un conto de usator.'''

Assecura te que tu primo lege le [[{{MediaWiki:Requestaccount-page}}|conditiones de servicio]] ante que tu requesta un conto.

Quando le conto ha essite approbate, tu recipera in e-mail un message de notification e le conto essera usabile pro [[Special:UserLogin|aperir un session]].",
	'requestaccount-page' => '{{ns:project}}:Conditiones de servicio',
	'requestaccount-dup' => "'''Nota: Tu es ja in un session aperte con un conto registrate.'''",
	'requestaccount-leg-user' => 'Conto de usator',
	'requestaccount-leg-areas' => 'Areas de interesse principal',
	'requestaccount-leg-person' => 'Informationes personal',
	'requestaccount-leg-other' => 'Altere informationes',
	'requestaccount-leg-tos' => 'Conditiones de servicio',
	'requestaccount-acc-text' => 'Tu recipera in e-mail un message de confirmation quando tu submitte iste requesta.
Per favor responde per cliccar super le ligamine de confirmation presente in le e-mail.
Tu recipera etiam tu contrasigno in e-mail al creation de tu conto.',
	'requestaccount-areas-text' => 'Selige in basso le areas thematic in le quales tu ha expertise formal o al quales tu volerea laborar le plus.',
	'requestaccount-ext-text' => 'Le sequente information resta private e essera usate solmente pro iste requesta.
Tu ha le possibilitate de listar contactos como un numero de telephono pro adjutar in le confirmation de tu identitate.',
	'requestaccount-bio-text' => 'Tu biographia essera le contento predefinite pro tu pagina de usator.
Essaya includer omne litteras de credentia.
Assecura te que tu sia confortabile con le publication de tal informationes.
Tu nomine pote esser cambiate in [[Special:Preferences|tu preferentias]].',
	'requestaccount-real' => 'Nomine real:',
	'requestaccount-same' => '(equal al nomine real)',
	'requestaccount-email' => 'Adresse de e-mail:',
	'requestaccount-reqtype' => 'Position:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'contributor',
	'requestaccount-bio' => 'Biographia personal:',
	'requestaccount-attach' => 'Résumé o CV (optional):',
	'requestaccount-notes' => 'Notas additional:',
	'requestaccount-urls' => 'Lista de sitos web, si alcun (un per linea):',
	'requestaccount-agree' => 'Tu debe certificar que tu nomine real es correcte e que tu accepta nostre Conditiones de Servicio.',
	'requestaccount-inuse' => 'Le nomine de usator es ja in uso in un requesta de conto pendente.',
	'requestaccount-tooshort' => 'Tu biographia debe haber al minus $1 {{PLURAL:$1|parola|parolas}} de longor.',
	'requestaccount-emaildup' => 'Un altere requesta pendente de conto usa le mesme adresse de e-mail.',
	'requestaccount-exts' => 'Iste typo de file non es permittite in attachamentos.',
	'requestaccount-resub' => 'Tu debe reseliger tu file CV/résumé pro motivos de securitate.
Lassa le campo vacue si tu non vole plus includer un.',
	'requestaccount-tos' => 'Io ha legite e consenti a acceptar le [[{{MediaWiki:Requestaccount-page}}|Conditiones de Servicio]] of {{SITENAME}}.
Le nomine que io ha specificate sub "Nomine real" es de facto mi proprie nomine real.',
	'requestaccount-submit' => 'Requesta de conto',
	'requestaccount-sent' => 'Tu requesta de conto ha essite inviate con successo e nunc attende revision.
Un message de confirmation ha essite inviate a tu adresse de e-mail.',
	'request-account-econf' => 'Tu adresse de e-mail ha essite confirmate e essera listate como tal in tu requesta de conto.',
	'requestaccount-email-subj' => 'Confirmation de adresse e-mail pro {{SITENAME}}',
	'requestaccount-email-body' => 'Un persona, probabilemente tu, desde le adresse IP $1, ha requestate un conto "$2" con iste adresse de e-mail in {{SITENAME}}.

Pro confirmar que iste conto realmente pertine a te in {{SITENAME}}, visita iste ligamine in tu navigator del web:

$3

Si le conto es create, solmente tu recipera le contrasigno in e-mail.
Si *non* es tu qui faceva iste requesta, non visita le ligamine.
Iste codice de confirmation expirara le $4.',
	'requestaccount-email-subj-admin' => 'Requesta de conto in {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" ha requestate un conto e attende confirmation.
Le adresse de e-mail ha essite confirmate. Tu pote confirmar le requesta hic: "$2".',
	'acct_request_throttle_hit' => 'Pardono, tu ha ja create {{PLURAL:$1|1 conto|$1 contos}}.
Tu non pote facer plus requestas.',
	'requestaccount-loginnotice' => "Pro obtener un conto de usator, tu debe '''[[Special:RequestAccount|requestar un]]'''.",
	'confirmaccount-newrequests' => "Es pendente '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|requesta de conto]]|[[Special:ConfirmAccounts|requestas de conto]]}} aperte e confirmate via e-mail",
	'confirmaccounts' => 'Confirmar requestas de conto',
	'confirmedit-desc' => 'Concede al bureaucrates le capacitate de confirmar le requestas de conto',
	'confirmaccount-maintext' => "'''Iste pagina es usate pro confirmar le requestas de conto pendente a ''{{SITENAME}}'''''.

Cata cauda de requestas de conto consiste de tres subcaudas.
Un pro requestas aperte, un pro requestas suspendite per administratores pendente ulterior informationes, e un tertie pro requestas recentemente rejectate.

Quando tu responde a un requesta, revide lo con caution e, si necessari, confirma le informationes continite in illo.
Tu actiones essera registrate privatemente.
In addition, es expectate que tu revide omne activitate que occurre hic, ultra tu proprie actiones.",
	'confirmaccount-list' => 'Infra es un lista de requestas de conto attendente approbation.
Quando un requesta es approbate o rejectate, illo se retirara de iste lista.',
	'confirmaccount-list2' => 'Infra es un lista de requestas de conto recentemente rejectate le quales pote esser automaticamente delite post alcun dies.
Illos pote ancora esser approbate como contos, sed es recommendate que tu consulta le administrator qui rejectava le requesta in question, ante que tu face isto.',
	'confirmaccount-list3' => 'Infra es un lista de requestas de conto expirate le quales pote esser automaticamente delite post alcun dies. Illos pote ancora esser approbate como contos.',
	'confirmaccount-text' => "Isto es un requesta pendente pro un conto de usator a '''{{SITENAME}}'''.

Revide con caution le sequente informationes.
Si tu approba iste requesta, defini con le menu Position le stato del conto de iste usator.
Le modificationes facite in le biographia del candidatura non afficera le referentias ja immagazinate.
Nota que tu pote optar pro crear le conto sub un altere nomine de usator.
Solmente face isto pro evitar le collision con altere nomines.

Si tu simplemente abandona iste pagina sin confirmar o rejectar iste requesta, illo restara pendente.",
	'confirmaccount-none-o' => 'Al momento il non ha requestas de conto pendente in iste lista.',
	'confirmaccount-none-h' => 'Al momento il non ha requestas de conto suspendite in iste lista.',
	'confirmaccount-none-r' => 'Al momento il non ha requestas de conto recentemente rejectate in iste lista.',
	'confirmaccount-none-e' => 'Al momento il non ha requestas de conto expirate in iste lista.',
	'confirmaccount-real-q' => 'Nomine',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biographia',
	'confirmaccount-showopen' => 'requestas aperte',
	'confirmaccount-showrej' => 'requestas rejectate',
	'confirmaccount-showheld' => 'requestas suspendite',
	'confirmaccount-showexp' => 'requestas expirate',
	'confirmaccount-review' => 'Revider',
	'confirmaccount-types' => 'Selige un cauda de confirmation de contos infra:',
	'confirmaccount-all' => '(revelar tote le caudas)',
	'confirmaccount-type' => 'Cauda:',
	'confirmaccount-type-0' => 'autores eventual',
	'confirmaccount-type-1' => 'contributores eventual',
	'confirmaccount-q-open' => 'requestas aperte',
	'confirmaccount-q-held' => 'requestas suspendite',
	'confirmaccount-q-rej' => 'requestas recentemente rejectate',
	'confirmaccount-q-stale' => 'requestas expirate',
	'confirmaccount-badid' => 'Non existe un requesta pendente correspondente al ID specificate.
Illo pote ja haber essite tractate.',
	'confirmaccount-leg-user' => 'Conto de usator',
	'confirmaccount-leg-areas' => 'Areas de interesse principal',
	'confirmaccount-leg-person' => 'Informationes personal',
	'confirmaccount-leg-other' => 'Altere informationes',
	'confirmaccount-name' => 'Nomine de usator',
	'confirmaccount-real' => 'Nomine:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Position:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'contributor',
	'confirmaccount-bio' => 'Biographia:',
	'confirmaccount-attach' => 'Résumé/CV:',
	'confirmaccount-notes' => 'Notas additional:',
	'confirmaccount-urls' => 'Lista de sitos web:',
	'confirmaccount-none-p' => '(non fornite)',
	'confirmaccount-confirm' => 'Usa le optiones infra pro acceptar, refusar, o suspender iste requesta:',
	'confirmaccount-econf' => '(confirmate)',
	'confirmaccount-reject' => '(rejectate per [[User:$1|$1]] le $2)',
	'confirmaccount-rational' => 'Motivo date al candidato:',
	'confirmaccount-noreason' => '(nulle)',
	'confirmaccount-autorej' => '(iste requesta ha essite automaticamente abandonate a causa de inactivitate)',
	'confirmaccount-held' => '(marcate como "suspendite" per [[User:$1|$1]] le $2)',
	'confirmaccount-create' => 'Acceptar (crear conto)',
	'confirmaccount-deny' => 'Rejectar (retirar del lista)',
	'confirmaccount-hold' => 'Suspender',
	'confirmaccount-spam' => 'Spam (non inviar e-mail)',
	'confirmaccount-reason' => 'Commento (essera includite in e-mail):',
	'confirmaccount-ip' => 'Adresse IP:',
	'confirmaccount-legend' => 'Confirmar/rejectar iste conto',
	'confirmaccount-submit' => 'Confirmar',
	'confirmaccount-needreason' => 'Tu debe fornir un motivo in le quadro de commento infra.',
	'confirmaccount-canthold' => 'Iste requesta ha ja essite suspendite o delite.',
	'confirmaccount-acc' => 'Le requesta de conto ha essite confirmate con successo;
creava nove conto de usator [[User:$1|$1]].',
	'confirmaccount-rej' => 'Le requesta de conto ha essite rejectate con successo.',
	'confirmaccount-viewing' => '(a iste momento in revision per [[User:$1|$1]])',
	'confirmaccount-summary' => 'Crea pagina de usator con biographia del nove usator.',
	'confirmaccount-welc' => "'''Benvenite a ''{{SITENAME}}''!'''
Nos spera que tu contribuera multo e ben.
Tu volera probabilemente leger le [[{{MediaWiki:Helppage}}|paginas de adjuta]].
Benvenite ancora, e diverte te!",
	'confirmaccount-wsum' => 'Benvenite!',
	'confirmaccount-email-subj' => 'Requesta de conto in {{SITENAME}}',
	'confirmaccount-email-body' => 'Tu requesta de un conto in {{SITENAME}} ha essite approbate.

Nomine del conto: $1

Contrasigno: $2

Pro motivos de securitate, tu debera cambiar tu contrasigno al prime apertura de session.
Pro aperir un session, per favor visita {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Tu requesta de un conto in {{SITENAME}} ha essite approbate.

Nomine del conto: $1

Contrasigno: $2

$3

Pro motivos de securitate, tu debera cambiar tu contrasigno al prime apertura de session.
Pro aperir un session, per favor visita {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Pardono, tu requesta de un conto "$1" in {{SITENAME}} ha essite rejectate.

Existe plure modos in que isto pote evenir.
Es possibile que tu non completava le formulario correctemente, non dava responsas de longor adequate, o alteremente non te conformava a alcun criterio de politica.
Il pote haber listas de contacto in le sito que tu pote usar si tu vole saper plus a proposito del politica de creation de contos.',
	'confirmaccount-email-body4' => 'Pardono, tu requesta de un conto "$1" in {{SITENAME}} ha essite rejectate.

$2

Il pote haber listas de contacto in le sito que tu pote usar si tu vole saper plus a proposito del politica de creation de contos.',
	'confirmaccount-email-body5' => 'Ante que tu requesta de un conto "$1" in {{SITENAME}} pote esser acceptate, tu debe primo fornir alcun informationes additional.

$2

Il pote haber listas de contacto in le sito que tu pote usar si tu vole saper plus a proposito del politica de creation de contos.',
	'usercredentials' => 'Referentias del usator',
	'usercredentials-leg' => 'Cercar referentias confirmate pro un usator',
	'usercredentials-user' => 'Nomine de usator:',
	'usercredentials-text' => 'Infra es le referentias validate del conto de usator seligite.',
	'usercredentials-leg-user' => 'Conto de usator',
	'usercredentials-leg-areas' => 'Areas de interesse principal',
	'usercredentials-leg-person' => 'Informationes personal',
	'usercredentials-leg-other' => 'Altere informationes',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Nomine real:',
	'usercredentials-bio' => 'Biographia:',
	'usercredentials-attach' => 'Résumé/CV:',
	'usercredentials-notes' => 'Notas additional:',
	'usercredentials-urls' => 'Lista de sitos web:',
	'usercredentials-ip' => 'Adresse IP original:',
	'usercredentials-member' => 'Derectos:',
	'usercredentials-badid' => 'Nulle referentias trovate pro iste usator.
Verifica que le nomine sia orthographiate correctemente.',
	'right-confirmaccount' => 'Vider le [[Special:ConfirmAccounts|cauda con requestas de conto]]',
	'right-requestips' => 'Vider le adresses IP del requestatores durante le tractamento de requestas de conto',
	'right-lookupcredentials' => 'Vider le [[Special:UserCredentials|credentiales de usatores]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'requestaccount' => 'Permintaan akun',
	'requestaccount-text' => "'''Lengkapi dan kirim formulir berikut untuk mengajukan sebuah akun pengguna'''.

Pastikan Anda telah membaca [[{{MediaWiki:Requestaccount-page}}|kebijakan akun]] sebelum mengajukan permintaan.

Bila akun yang Anda ajukan telah disetujui, sebuah surel notifikasi akan dikirimkan kepada Anda dan akun tersebut dapat digunakan untuk [[Special:UserLogin|masuk log]] di situs ini.",
	'requestaccount-page' => '{{ns:project}}:Kebijakan akun pengguna',
	'requestaccount-dup' => "'''Catatan: Anda sudah masuk log dengan sebuah akun terdaftar.'''",
	'requestaccount-leg-user' => 'Akun pengguna',
	'requestaccount-leg-areas' => 'Bidang utama yang diminati',
	'requestaccount-leg-person' => 'Informasi pribadi',
	'requestaccount-leg-other' => 'Informasi lain',
	'requestaccount-leg-tos' => 'Syarat Layanan',
	'requestaccount-acc-text' => 'Kami akan mengirimkan sebuah pesan konfirmasi ke alamat surel Anda segera setelah permintaan ini dikirimkan.
Klik pada pranala dalam surel tersebut untuk konfirmasi.
Kata sandi Anda juga akan dikirimkan melalui surel setelah akun Anda disetujui dan dibuat.',
	'requestaccount-areas-text' => 'Pilih topik-topik yang merupakan keahlian formal Anda atau merupakan area yang akan paling banyak Anda sentuh.',
	'requestaccount-ext-text' => 'Informasi berikut ini akan diperlakukan secara rahasia dan hanya akan digunakan sehubungan dengan permintaan ini.
Anda dapat menuliskan daftar kontak seperti nomor telepon Anda untuk mempermudah dalam mengkonfirmasikan identitas Anda.',
	'requestaccount-bio-text' => 'Biografi Anda akan ditampilkan sebagai konten default untuk halaman pengguna Anda.
Anda dapat memasukkan beberapa hal pribadi.
Pastikan Anda merasa nyaman untuk mempublikasikan informasi-informasi tersebut.
Nama Anda dapat diubah melalui [[Special:Preferences|preferensi Anda]].',
	'requestaccount-real' => 'Nama asli:',
	'requestaccount-same' => '(sama dengan nama asli)',
	'requestaccount-email' => 'Alamat surel:',
	'requestaccount-reqtype' => 'Posisi:',
	'requestaccount-level-0' => 'penulis',
	'requestaccount-level-1' => 'penyunting',
	'requestaccount-bio' => 'Biografi pribadi:',
	'requestaccount-attach' => 'Resume atau CV (opsional):',
	'requestaccount-notes' => 'Catatan tambahan:',
	'requestaccount-urls' => 'Daftar situs web, jika ada (pisahkan dengan baris baru):',
	'requestaccount-agree' => 'Anda harus menyatakan bahwa nama asli Anda adalah benar dan bahwa Anda setuju dengan Syarat Layanan kami.',
	'requestaccount-inuse' => 'Nama pengguna ini sudah digunakan dalam salah satu antrean permintaan akun.',
	'requestaccount-tooshort' => 'Biografi Anda harus memiliki panjang minimal $1 {{PLURAL:$1|kata|kata}}.',
	'requestaccount-emaildup' => 'Sebuah antrean permintaan lain menggunakan alamat surel yang sama.',
	'requestaccount-exts' => 'Jenis lampiran berkas tidak diizinkan.',
	'requestaccount-resub' => 'Resume/CV Anda harus dipilih kembali atas alasan keamanan.
Tinggalkan kotak ini kosong jika Anda sudah tidak ingin untuk memasukkannya.',
	'requestaccount-tos' => 'Saya telah membaca dan menyetujui [[{{MediaWiki:Requestaccount-page}}|Syarat Layanan]] {{SITENAME}}.
Nama yang saya tuliskan dalam "Nama asli" adalah benar-benar nama asli saya sendiri.',
	'requestaccount-submit' => 'Permintaan akun',
	'requestaccount-sent' => 'Permintaan akun Anda telah berhasil dikirimkan dan sekarang sedang dalam antrean untuk ditinjau.
Sebuah surat konfirmasi telah dikirimkan ke alamat surel Anda.',
	'request-account-econf' => 'Alamat surel Anda telah dikonfirmasikan dan akan ditampilkan sebagaimana dalam permintaan akun Anda.',
	'requestaccount-email-subj' => 'Konfirmasi alamat surel {{SITENAME}}',
	'requestaccount-email-body' => 'Seseorang, mungkin Anda, dari alamat IP $1, telah mendaftarkan permintaan akun "$2" dengan alamat surel ini di {{SITENAME}}.

Untuk mengkonfirmasikan bahwa akun ini benar dimiliki oleh Anda di {{SITENAME}}, ikuti pranala berikut pada penjelajah web Anda:

$3

Setelah akun ini dibuat, hanya Anda yang akan dikirim kata sandinya melalui surel.
Jika Anda merasa *tidak pernah* mendaftar, jangan ikuti pranala di atas.
Kode konfirmasi ini akan kadaluwarsa pada $4.',
	'requestaccount-email-subj-admin' => 'Permintaan akun {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" telah mengajukan permintaan pembuatan akun dan sedang menunggu konfirmasi.
Surel ini telah dikonfirmasi. Anda dapat memberikan konfirmasi atas permintaan tersebut di sini "$2".',
	'acct_request_throttle_hit' => 'Anda telah meminta {{PLURAL:$1|1 akun|$1 akun}}.
Anda tidak dapat lagi melakukan permintaan.',
	'requestaccount-loginnotice' => "Untuk mendapatkan sebuah akun pengguna, Anda harus '''[[Special:RequestAccount|mengajukannya]]'''.",
	'confirmaccount-newrequests' => "Terdapat '''$1''' antrean [[Special:ConfirmAccounts|{{PLURAL:$1|permintaan|permintaan}} akun]] yang surelnya telah dikonfirmasi.",
	'confirmaccounts' => 'Konfirmasi permintaan akun',
	'confirmedit-desc' => 'Memberikan fungsi teknis tambahan bagi birokrat untuk mengkonfirmasikan permintaan akun',
	'confirmaccount-maintext' => "'''Halaman ini digunakan untuk mengkonfirmasikan permintaan akun di ''{{SITENAME}}'''''.

Setiap antrean permintaan akun memiliki tiga sub-antrean.
Satu untuk permintaan yang belum ditinjau, satu untuk akun yang ditunda oleh pengurus lain karena menunggu informasi tambahan, dan terakhir untuk permintaan yang baru ditolak.

Jika Anda hendak meresponi sebuah permintaan, tinjau dengan hati-hati, dan jika diperlukan, konfirmasikan informasi yang disertakan.
Tindakan Anda akan dimasukkan ke dalam log privat.
Anda juga perlu meninjau aktivitas apa pun yang dilakukan di sini di samping yang Anda lakukan sendiri.",
	'confirmaccount-list' => 'Berikut adalah daftar permintaan akun yang menunggu persetujuan.
Jika disetujui ataupun ditolak, permintaan tersebut akan dikeluarkan dari daftar ini.',
	'confirmaccount-list2' => 'Berikut adalah daftar permintaan akun yang baru ditolak dan akan dihapus secara otomatis setelah beberapa hari.
Permintaan ini masih dapat disetujui untuk dijadikan akun, tetapi Anda mungkin perlu mendiskusikan terlebih dahulu dengan pengurus yang menolak permintaan tersebut sebelumnya.',
	'confirmaccount-list3' => 'Berikut adalah daftar permintaan akun yang telah kadaluwarsa dan akan dihapuskan dalam beberapa hari.
Permintaan ini masih dapat disetujui untuk dijadikan akun.',
	'confirmaccount-text' => "Ini adalah antrean permintaan untuk membuat akun di '''{{SITENAME}}'''.

Tinjau informasi berikut dengan seksama.
Jika Anda menyetujui permintaan ini, gunakan daftar dropdown untuk mengeset status akun pengguna tersebut.
Suntingan terhadap biografi pendaftar tidak akan mempengaruhi data kepercayaan yang disimpan permanen.
Perlu dicatat bahwa Anda dapat memilih untuk membuat akun dengan nama akun yang berbeda.
Lakukan ini untuk menghindari kekeliruan dengan nama lain.

Jika Anda tidak menyetujui atau menolak permintaan ini, maka permintaan ini akan tetap berada dalam status antrean.",
	'confirmaccount-none-o' => 'Tidak ada antrean permintaan akun dalam daftar ini.',
	'confirmaccount-none-h' => 'Tidak ada antrean permintaan akun yang ditunda dalam daftar ini.',
	'confirmaccount-none-r' => 'Tidak ada permintaan akun yang baru ditolak di daftar ini.',
	'confirmaccount-none-e' => 'Tidak ada permintaan akun yang kadaluwarsa dalam daftar ini.',
	'confirmaccount-real-q' => 'Nama',
	'confirmaccount-email-q' => 'Surel',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'permintaan dalam antrean',
	'confirmaccount-showrej' => 'permintaan ditolak',
	'confirmaccount-showheld' => 'permintaan ditunda',
	'confirmaccount-showexp' => 'permintaan kadaluwarsa',
	'confirmaccount-review' => 'Tinjau',
	'confirmaccount-types' => 'Pilih antrean konfirmasi akun di bawah ini:',
	'confirmaccount-all' => '(tampilkan semua antrean)',
	'confirmaccount-type' => 'Antrean:',
	'confirmaccount-type-0' => 'penulis prospektif',
	'confirmaccount-type-1' => 'penyunting prospektif',
	'confirmaccount-q-open' => 'permintaan dalam antrean',
	'confirmaccount-q-held' => 'permintaan ditunda',
	'confirmaccount-q-rej' => 'permintaan ditolak',
	'confirmaccount-q-stale' => 'permintaan kadaluwarsa',
	'confirmaccount-badid' => 'Tidak ada permintaan dalam antrean yang terkait dengan ID tersebut.
Mungkin permintaan tersebut telah ditangani.',
	'confirmaccount-leg-user' => 'Akun pengguna',
	'confirmaccount-leg-areas' => 'Bidang utama yang diminati',
	'confirmaccount-leg-person' => 'Informasi pribadi',
	'confirmaccount-leg-other' => 'Informasi lain',
	'confirmaccount-name' => 'Nama pengguna',
	'confirmaccount-real' => 'Nama:',
	'confirmaccount-email' => 'Surel:',
	'confirmaccount-reqtype' => 'Posisi:',
	'confirmaccount-pos-0' => 'penulis',
	'confirmaccount-pos-1' => 'penyunting',
	'confirmaccount-bio' => 'Biografi:',
	'confirmaccount-attach' => 'Resume/CV:',
	'confirmaccount-notes' => 'Catatan tambahan:',
	'confirmaccount-urls' => 'Daftar situs web:',
	'confirmaccount-none-p' => '(tidak diberikan)',
	'confirmaccount-confirm' => 'Gunakan opsi berikut untuk menyetujui, menolak, atau menunda permintaan ini:',
	'confirmaccount-econf' => '(telah dikonfirmasi)',
	'confirmaccount-reject' => '(ditolah oleh [[User:$1|$1]] pada $2)',
	'confirmaccount-rational' => 'Alasan yang diberikan kepada pendaftar:',
	'confirmaccount-noreason' => '(tidak ada)',
	'confirmaccount-autorej' => '(permintaan ini telah dihapus secara otomatis karena ketidakaktifan)',
	'confirmaccount-held' => '(ditandai "ditunda" oleh [[User:$1|$1]] pada $2)',
	'confirmaccount-create' => 'Setuju (buat akun)',
	'confirmaccount-deny' => 'Tolak',
	'confirmaccount-hold' => 'Tunda',
	'confirmaccount-spam' => 'Spam (jangan kirim surel)',
	'confirmaccount-reason' => 'Komentar (akan dimasukkan dalam surel):',
	'confirmaccount-ip' => 'Alamat IP:',
	'confirmaccount-submit' => 'Konfirmasi',
	'confirmaccount-needreason' => 'Anda harus memberikan sebuah alasan dalam kotak komentar berikut.',
	'confirmaccount-canthold' => 'Permintaan ini telah ditunda atau dihapuskan.',
	'confirmaccount-acc' => 'Permintaan akun berhasil dikonfirmasikan;
akun pengguna baru [[User:$1|$1]] telah dibuat.',
	'confirmaccount-rej' => 'Permintaan akun berhasil ditolak.',
	'confirmaccount-viewing' => '(saat ini sedang ditinjau oleh [[User:$1|$1]])',
	'confirmaccount-summary' => 'Membuat halaman pengguna dengan biografi pengguna baru.',
	'confirmaccount-welc' => "'''Selamat datang di ''{{SITENAME}}''!'''
Semoga Anda memberikan kontribusi yang banyak dan berkualitas.
Anda mungkin ingin membaca [[{{MediaWiki:Helppage}}|halaman bantuan]].
Sekali lagi, selamat datang!",
	'confirmaccount-wsum' => 'Selamat datang!',
	'confirmaccount-email-subj' => 'Permintaan akun {{SITENAME}}',
	'confirmaccount-email-body' => 'Permintaan akun Anda telah disetujui di {{SITENAME}}.

Nama akun: $1

Kata sandi: $2

Untuk alasan keamanan Anda harus mengubah kata sandi Anda pada saat masuk log pertama kali.
Untuk masuk log, silakan tuju {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2' => 'Permintaan akun Anda telah disetujui di {{SITENAME}}.

Nama akun: $1

Kata sandi: $2

$3

Untuk alasan keamanan Anda harus mengubah kata sandi Anda pada saat masuk log pertama kali.
Untuk masuk log, silakan tuju {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3' => 'Maaf, permintaan Anda untuk akun "$1" telah ditolak oleh {{SITENAME}}.

Ada beberapa kemungkinan ini bisa terjadi. 
Anda mungkin tidak mengisi formulir dengan benar, tidak memberikan cukup keterangan dalam jawaban Anda, atau gagal memenuhi beberapa kriteria kebijakan. 
Mungkin ada daftar kontak di situs yang dapat Anda gunakan jika Anda ingin tahu lebih banyak tentang kebijakan akun pengguna.',
	'confirmaccount-email-body4' => 'Maaf, permintaan anda untuk akun "$1" telah ditolak oleh {{SITENAME}}.

$2

Mungkin ada daftar kontak di situs yang dapat Anda gunakan jika Anda ingin tahu lebih banyak tentang kebijakan account pengguna.',
	'confirmaccount-email-body5' => 'Sebelum permintaan anda untuk akun "$1"  dapat diterima oleh {{SITENAME}} anda harus mengisi beberapa informasi tambahan.

$2

Mungkin ada daftar kontak di situs yang dapat Anda gunakan jika Anda ingin tahu lebih banyak tentang kebijakan account pengguna.',
	'usercredentials' => 'Kredensial pengguna',
	'usercredentials-leg' => 'Lihat konfirmasi Kredensial untuk pengguna',
	'usercredentials-user' => 'Nama pengguna:',
	'usercredentials-text' => 'Berikut adalah Kredensial yang sah untuk akun pengguna terpilih.',
	'usercredentials-leg-user' => 'Akun pengguna',
	'usercredentials-leg-areas' => 'Bidang utama yang diminati',
	'usercredentials-leg-person' => 'Informasi pribadi',
	'usercredentials-leg-other' => 'Informasi lain',
	'usercredentials-email' => 'Surel:',
	'usercredentials-real' => 'Nama asli:',
	'usercredentials-bio' => 'Biografi:',
	'usercredentials-attach' => 'Resume/CV:',
	'usercredentials-notes' => 'Catatan tambahan:',
	'usercredentials-urls' => 'Daftar situs web:',
	'usercredentials-ip' => 'Alamat IP asal:',
	'usercredentials-member' => 'Hak:',
	'usercredentials-badid' => 'Tidak ditemukan Kredensial untuk pengguna ini,
Periksa! apakah nama dieja dengan benar.',
	'right-confirmaccount' => 'Lihat [[Special:ConfirmAccounts|antrean peminta akun]]',
	'right-requestips' => 'Lihat Alamat IP pemohon selama proses permohonan akun',
	'right-lookupcredentials' => 'Lihat [[Special:UserCredentials|pengguna  Kredensial]]',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'confirmaccount-real' => 'Nomo:',
	'confirmaccount-ip' => 'IP-adreso:',
	'confirmaccount-wsum' => 'Bonveno!',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'requestaccount' => 'Sækja um aðgang',
	'requestaccount-leg-user' => 'Aðgangur notanda',
	'requestaccount-leg-areas' => 'Aðal áhugamál',
	'requestaccount-leg-person' => 'Persónulegar upplýsingar',
	'requestaccount-leg-other' => 'Aðrar upplýsingar',
	'requestaccount-real' => 'Raunverulegt nafn:',
	'requestaccount-same' => '(eins og raunverulega nafnið)',
	'requestaccount-email' => 'Netfang:',
	'requestaccount-reqtype' => 'Staða:',
	'requestaccount-level-0' => 'höfundur',
	'requestaccount-level-1' => 'ritstjóri',
	'requestaccount-bio' => 'Sjálfsævisaga:',
	'requestaccount-attach' => 'Ferilskrá (valfrjálst):',
	'requestaccount-notes' => 'Viðbótarskýring:',
	'requestaccount-urls' => 'Listi yfir vefsíður, ef einhverjar (aðskildu með línum):',
	'requestaccount-tooshort' => 'Sjálfsævisagan þín þarf að vera að minnsta kosti $1 orð á lengd.',
	'confirmaccount-real-q' => 'Nafn',
	'confirmaccount-email-q' => 'Netfang',
	'confirmaccount-bio-q' => 'Sjálfsævisaga',
	'confirmaccount-leg-user' => 'Aðgangur notanda',
	'confirmaccount-leg-areas' => 'Aðal áhugamál',
	'confirmaccount-leg-person' => 'Persónulegar upplýsingar',
	'confirmaccount-leg-other' => 'Aðrar upplýsingar',
	'confirmaccount-name' => 'Notandanafn',
	'confirmaccount-real' => 'Nafn:',
	'confirmaccount-email' => 'Netfang:',
	'confirmaccount-reqtype' => 'Staða:',
	'confirmaccount-pos-0' => 'höfundur',
	'confirmaccount-pos-1' => 'ritstjóri',
	'confirmaccount-bio' => 'Sjálfsævisaga:',
	'confirmaccount-attach' => 'Ferilskrá:',
	'confirmaccount-notes' => 'Viðbótarskýring:',
	'confirmaccount-urls' => 'Listi yfir vefsíður:',
	'confirmaccount-none-p' => '(ekki fáanlegt)',
	'confirmaccount-confirm' => 'Notaðu valmöguleikana hér að neðan til að samþykkja, neita eða setja beiðni í bið:',
	'confirmaccount-econf' => '(staðfest)',
	'confirmaccount-noreason' => '(engin)',
	'confirmaccount-create' => 'Samþykkja (búa til aðgang)',
	'confirmaccount-hold' => 'Bíða',
	'confirmaccount-ip' => 'Vistfang:',
	'confirmaccount-submit' => 'Staðfesta',
	'confirmaccount-wsum' => 'Velkomin!',
	'usercredentials-user' => 'Notandanafn:',
	'usercredentials-leg-user' => 'Aðgangur notanda',
	'usercredentials-leg-areas' => 'Aðal áhugamál',
	'usercredentials-leg-person' => 'Persónulegar upplýsingar',
	'usercredentials-leg-other' => 'Aðrar upplýsingar',
	'usercredentials-email' => 'Netfang:',
	'usercredentials-real' => 'Raunverulegt nafn:',
	'usercredentials-bio' => 'Sjálfsævisaga:',
	'usercredentials-attach' => 'Ferilskrá:',
	'usercredentials-notes' => 'Viðbótarskýring:',
	'usercredentials-urls' => 'Listi yfir vefsíður:',
	'usercredentials-ip' => 'Upprunalegt vistfang:',
	'usercredentials-member' => 'Réttindi:',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
 * @author Stefano-c
 */
$messages['it'] = array(
	'requestaccount' => 'Richiesta account',
	'requestaccount-text' => "'''Completa e invia il seguente modulo per richiedere un account utente'''.

Assicurarsi di aver prima letto i [[{{MediaWiki:Requestaccount-page}}|Termini del Servizio]] prima di richiedere un account.

Quando l'account sarà stato approvato, ti verrà inviato via e-mail un messaggio di notifica e l'account sarà utilizzabile al [[Special:UserLogin|login]].",
	'requestaccount-page' => '{{ns:project}}:Termini del Servizio',
	'requestaccount-dup' => "'''Nota: hai già effettuato l'accesso con un account registrato.'''",
	'requestaccount-leg-user' => 'Account utente',
	'requestaccount-leg-areas' => "Principali aree d'interesse",
	'requestaccount-leg-person' => 'Informazioni personali',
	'requestaccount-leg-other' => 'Altre informazioni',
	'requestaccount-leg-tos' => 'Termini del Servizio',
	'requestaccount-acc-text' => "Al tuo indirizzo e-mail verrà inviato un messaggio di conferma quando questa richiesta sarà inviata.
Per favore rispondi facendo clic sul link di conferma fornito nell'e-mail.
Inoltre la tua password sarà inviata via e-mail quando il tuo account sarà stato creato.",
	'requestaccount-areas-text' => 'Selezionare le aree di seguito in cui si hanno competenze formali o in cui si vorrebbe fare la maggior parte del lavoro.',
	'requestaccount-ext-text' => "Le seguenti informazioni saranno tenute private e saranno usate solo per questa richiesta.
Potresti voler inserire dei contatti come un numero di telefono per aiutare l'identificazione.",
	'requestaccount-bio-text' => 'La tua biografia sarà impostata come contenuto predefinito per la tua pagina utente.
Cerca di inserire tutte le credenziali.
Assicurati di voler pubblicare tali informazioni.
Il tuo nome può essere modificato tramite le [[Special:Preferences|tue preferenze]].',
	'requestaccount-real' => 'Vero nome:',
	'requestaccount-same' => '(uguale al vero nome)',
	'requestaccount-email' => 'Indirizzo e-mail:',
	'requestaccount-reqtype' => 'Posizione:',
	'requestaccount-level-0' => 'autore',
	'requestaccount-level-1' => 'editore',
	'requestaccount-bio' => 'Biografia personale:',
	'requestaccount-attach' => 'Curriculum (opzionale):',
	'requestaccount-notes' => 'Ulteriori note:',
	'requestaccount-urls' => 'Elenco dei siti web, se ce ne sono (uno per riga):',
	'requestaccount-agree' => 'Devi certificare che il tuo vero nome sia corretto e che accetti i nostri Termini di Servizio.',
	'requestaccount-inuse' => "Il nome utente è già in uso in un'altra richiesta in attesa.",
	'requestaccount-tooshort' => 'La biografia deve essere di almeno $1 {{PLURAL:$1|parola|parole}}.',
	'requestaccount-emaildup' => "Un'altra richiesta in attesa utilizza lo stesso indirizzo e-mail.",
	'requestaccount-exts' => 'Tipo di file allegato non permesso.',
	'requestaccount-resub' => 'Il file del tuo curriculum deve essere ri-selezionato per motivi di sicurezza.
Lascia il campo vuoto se non desideri più includerne uno.',
	'requestaccount-tos' => 'Ho letto e accetto di rispettare i [[{{MediaWiki:Requestaccount-page}}|Termini del Servizio]] di {{SITENAME}}.
Il nome che ho specificato come "Vero nome" è infatti il mio vero nome.',
	'requestaccount-submit' => 'Richiesta account',
	'requestaccount-sent' => 'La tua richiesta account è stata inviata con successo ed è ora in attesa di verifica.
Una email di conferma è stata inviata al tuo indirizzo e-mail.',
	'request-account-econf' => 'Il tuo indirizzo e-mail è stato confermato e sarà elencato come tale nella tua richiesta account.',
	'requestaccount-email-subj' => '{{SITENAME}} conferma indirizzo e-mail',
	'requestaccount-email-body' => 'Qualcuno, probabilmente tu, dall\'indirizzo IP $1, ha chiesto un account "$2" con questo indirizzo e-mail su {{SITENAME}}.

Per confermare che questo account ti appartiene veramente su {{SITENAME}}, apri questo link nel tuo browser:

$3

Se l\'account viene creato, la password sarà inviata via e-mail solo a te.
Se *non* sei stato tu, non seguire il link.
Questo codice di conferma scadrà il $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} richiesta account',
	'requestaccount-email-body-admin' => '"$1" ha chiesto un account ed è in attesa di conferma.
L\'indirizzo e-mail è stato confermato. È possibile confermare la richiesta qui "$2".',
	'acct_request_throttle_hit' => 'Spiacente, hai già chiesto {{PLURAL:$1|1 account|$1 account}}.
Non puoi effettuare ulteriori richieste.',
	'requestaccount-loginnotice' => "Per ottenere un account utente, è necessario '''[[Special:RequestAccount|richiederne uno]]'''.",
	'confirmaccount-newrequests' => "'''$1''' e-mail {{PLURAL:$1|[[Special:ConfirmAccounts|confermata richiesta account aperta]]|[[Special:ConfirmAccounts|confermate richieste account aperte]]}} in attesa",
	'confirmaccounts' => 'Richieste conferma account',
	'confirmedit-desc' => 'Dà ai burocrati la possibilità di confermare le richieste di account',
	'confirmaccount-maintext' => "'''Questa pagina è usata per confermare le richieste di account in attesa su ''{{SITENAME}}'''''.

Ogni coda di richieste account è composta da tre sotto-code.
Una per le richieste aperte, una per quelle che sono state messe in attesa da parte di altri amministratori in attesa di ulteriori informazioni, e un'altra per le richieste respinte di recente.

Quando si risponde ad una richiesta, verificarla attentamente e, se necessario, confermare le informazioni in essa contenute.
Le tue azioni saranno privatamente registrate.
Puoi anche verificare tutte le attività che si svolgono qui oltre a quelle svolte da te.",
	'confirmaccount-list' => 'Di seguito è riportato un elenco di richieste di account in attesa di approvazione.
Quando una richiesta è stata approvata o respinta sarà rimossa da questa lista.',
	'confirmaccount-list2' => "Di seguito è riportato un elenco di richieste respinte di recente che saranno automaticamente eliminate quando saranno vecchie di qualche giorno.
Possono ancora essere approvate come account, anche se può essere utile prima consultare l'amministratore che l'ha rifiutata.",
	'confirmaccount-list3' => 'Di seguito è riportato un elenco delle richieste di account scadute che saranno eliminate automaticamente quando saranno vecchie di qualche giorno.
Possono ancora essere approvate in account.',
	'confirmaccount-text' => "Questa è una richiesta in attesa per un account utente su '''{{SITENAME}}'''.

Controlla attentamente le seguenti informazioni.
Se si approva la richiesta, utilizzare la scelta posizione per impostare lo status dell'account utente.
Le modifiche alla biografia non avranno effetto permanente sulle credenziali memorizzate.
Nota che puoi scegliere di creare l'account con un nome utente diverso.
Usalo solo per evitare conflitti con altri nomi.

Se si lascia semplicemente questa pagina senza confermare o negare questa richiesta, essa rimarrà in attesa.",
	'confirmaccount-none-o' => 'Attualmente non ci sono richieste di account in attesa.',
	'confirmaccount-none-h' => 'Attualmente non ci sono richieste di account tenute in attesa.',
	'confirmaccount-none-r' => 'Attualmente non ci sono richieste di account respinte di recente.',
	'confirmaccount-none-e' => 'Attualmente non ci sono richieste di account scadute.',
	'confirmaccount-real-q' => 'Nome',
	'confirmaccount-email-q' => 'Indirizzo e-mail',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'richieste aperte',
	'confirmaccount-showrej' => 'richieste respinte',
	'confirmaccount-showheld' => 'richieste fermate',
	'confirmaccount-showexp' => 'richieste scadute',
	'confirmaccount-review' => 'Verifica',
	'confirmaccount-types' => 'Seleziona una coda di conferma account da sotto:',
	'confirmaccount-all' => '(mostra tutte le code)',
	'confirmaccount-type' => 'Coda:',
	'confirmaccount-type-0' => 'potenziali autori',
	'confirmaccount-type-1' => 'potenziali editori',
	'confirmaccount-q-open' => 'richieste aperte',
	'confirmaccount-q-held' => 'richieste fermate',
	'confirmaccount-q-rej' => 'richieste respinte recentemente',
	'confirmaccount-q-stale' => 'richieste scadute',
	'confirmaccount-badid' => "Non ci sono richieste in attesa corrispondenti all'ID dato.
Potrebbe essere già stato trattato.",
	'confirmaccount-leg-user' => 'Account utente',
	'confirmaccount-leg-areas' => "Principali aree d'interesse",
	'confirmaccount-leg-person' => 'Informazioni personali',
	'confirmaccount-leg-other' => 'Altre informazioni',
	'confirmaccount-name' => 'Nome utente',
	'confirmaccount-real' => 'Nome:',
	'confirmaccount-email' => 'Indirizzo e-mail:',
	'confirmaccount-reqtype' => 'Posizione:',
	'confirmaccount-pos-0' => 'autore',
	'confirmaccount-pos-1' => 'editore',
	'confirmaccount-bio' => 'Biografia:',
	'confirmaccount-attach' => 'Curriculum:',
	'confirmaccount-notes' => 'Ulteriori note:',
	'confirmaccount-urls' => 'Elenco dei siti web:',
	'confirmaccount-none-p' => '(non fornito)',
	'confirmaccount-confirm' => 'Utilizza le seguenti opzioni per accettare, rifiutare, o fermare questa richiesta:',
	'confirmaccount-econf' => '(confermato)',
	'confirmaccount-reject' => '(respinta da [[User:$1|$1]] il $2)',
	'confirmaccount-rational' => 'Motivazione data al richiedente:',
	'confirmaccount-noreason' => '(nessuno)',
	'confirmaccount-autorej' => "(questa richiesta è stata eliminata automaticamente a causa dell'inattività)",
	'confirmaccount-held' => '(segnato come "fermato" da [[User:$1|$1]] il $2)',
	'confirmaccount-create' => 'Accetta (crea account)',
	'confirmaccount-deny' => 'Rifiuta (rimuovi dalla lista)',
	'confirmaccount-hold' => 'Ferma',
	'confirmaccount-spam' => 'Spam (non inviare e-mail)',
	'confirmaccount-reason' => "Commento (sarà incluso nell'e-mail):",
	'confirmaccount-ip' => 'Indirizzo IP:',
	'confirmaccount-submit' => 'Conferma',
	'confirmaccount-needreason' => 'Devi fornire una motivazione nella casella del commento sottostante.',
	'confirmaccount-canthold' => 'Questa richiesta è già stata fermata o eliminata.',
	'confirmaccount-acc' => 'Richiesta account confermata con successo;
creato nuovo account utente [[User:$1|$1]].',
	'confirmaccount-rej' => 'Richiesta account respinta con successo.',
	'confirmaccount-viewing' => '(attualmente in osservazione da [[User:$1|$1]])',
	'confirmaccount-summary' => 'Creazione della pagina utente con la biografia del nuovo utente.',
	'confirmaccount-welc' => "'''Benvenuto su ''{{SITENAME}}''!'''
Ci auguriamo che contribuirai molto e bene.
Probabilmente desideri leggere le [[{{MediaWiki:Helppage}}|pagine di aiuto]].
Ancora benvenuto e buon divertimento!",
	'confirmaccount-wsum' => 'Benvenuto!',
	'confirmaccount-email-subj' => '{{SITENAME}} richiesta account',
	'confirmaccount-email-body' => 'La tua richiesta di un account è stata approvata su {{SITENAME}}.

Nome account: $1

Password: $2

Per motivi di sicurezza dovrai cambiare la password di accesso al primo login.
Per effettuare il login, per favore vai su {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'La tua richiesta di un account è stata approvata su {{SITENAME}}.

Nome account: $1

Password: $2

$3

Per motivi di sicurezza dovrai cambiare la password di accesso al primo login.
Per effettuare il login, per favore vai su {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Spiacente, la tua richiesta di un account "$1" è stata respinta su {{SITENAME}}.

Ci sono diversi motivi per cui questo possa essere accaduto.
Potresti non aver compilato il modulo correttamente, non aver fornito risposte di lunghezza adeguata, o altrimenti non aver rispettato qualche criterio.
Possono esserci elenchi di contatti sul sito che si possono usare se si desidera saperne di più riguardo alla politica degli account utente.',
	'confirmaccount-email-body4' => 'Spiacente, la tua richiesta di un account "$1" è stata respinta su {{SITENAME}}.

$2

Possono esserci elenchi di contatti sul sito che si possono usare se si desidera saperne di più riguardo alla politica degli account utente.',
	'confirmaccount-email-body5' => 'Prima che la tua richiesta di un account "$1" possa essere accettata su {{SITENAME}} è innanzitutto necessario fornire alcune informazioni supplementari.

$2

Possono esserci elenchi di contatti sul sito che si possono usare se si desidera saperne di più riguardo alla politica degli account utente.',
	'usercredentials' => 'Credenziali utente',
	'usercredentials-leg' => 'Cerca credenziali confermate per un utente',
	'usercredentials-user' => 'Nome utente:',
	'usercredentials-text' => "Qui di seguito vengono mostrate le credenziali convalidate dell'account utente selezionato.",
	'usercredentials-leg-user' => 'Account utente',
	'usercredentials-leg-areas' => "Principali aree d'interesse",
	'usercredentials-leg-person' => 'Informazioni personali',
	'usercredentials-leg-other' => 'Altre informazioni',
	'usercredentials-email' => 'Indirizzo e-mail:',
	'usercredentials-real' => 'Vero nome:',
	'usercredentials-bio' => 'Biografia:',
	'usercredentials-attach' => 'Curriculum:',
	'usercredentials-notes' => 'Ulteriori note:',
	'usercredentials-urls' => 'Elenco dei siti web:',
	'usercredentials-ip' => 'Indirizzo IP originale:',
	'usercredentials-member' => 'Diritti:',
	'usercredentials-badid' => 'Nessuna credenziale trovata per questo utente.
Controlla che il nome sia scritto correttamente.',
	'right-confirmaccount' => 'Visualizza la [[Special:ConfirmAccounts|coda gli account richiesti]]',
	'right-requestips' => 'Visualizza gli indirizzi IP del richiedente mentre processa gli account richiesti',
	'right-lookupcredentials' => 'Visualizza [[Special:UserCredentials|credenziali utente]]',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'requestaccount' => 'アカウント登録申請',
	'requestaccount-text' => "'''利用者アカウントを申請する方は、以下の項目を記入の上、送信してください'''  

アカウント申請を行う前に、[[{{MediaWiki:Requestaccount-page}}|サービス利用条件]]をご一読下さい。

アカウントが承認されると、通知メッセージがあなたの電子メールアドレスへ送信され、承認されたアカウントを使って[[Special:UserLogin|ログイン]]できるようになります。",
	'requestaccount-page' => '{{ns:project}}:サービス利用条件',
	'requestaccount-dup' => "'''注: あなたは既に登録済みアカウントでログインしています。'''",
	'requestaccount-leg-user' => '利用者アカウント',
	'requestaccount-leg-areas' => '関心のある分野',
	'requestaccount-leg-person' => '自己紹介',
	'requestaccount-leg-other' => 'その他',
	'requestaccount-leg-tos' => '利用規約',
	'requestaccount-acc-text' => '申請を行うと、確認メッセージがあなたの電子メールアドレスへ送信されます。その電子メールにある確認のためのリンクをクリックすると申請が承認されます。また、アカウントが作成された際には、電子メールでパスワードが送られます。',
	'requestaccount-areas-text' => 'あなたが見識をお持ちの分野、または主に活動したい分野を選択してください。',
	'requestaccount-ext-text' => '以下の個人情報は公開されず、この申請処理にのみ利用されます。
電話番号をはじめとする連絡先は、あなたが本人確認の補助を目的として記入いただけます。',
	'requestaccount-bio-text' => 'あなたの自己紹介は利用者ページの初期設定として登録されます。あなたの身分を証明する内容の記入は歓迎されますが、このような個人情報の提供があなた自身にとって望ましいことであるかまず検討してください。あなたの利用者名の表示は [[Special:Preferences|{{int:preferences}}]] から変更できます。',
	'requestaccount-real' => '本名:',
	'requestaccount-same' => '(本名での登録に限定されます)',
	'requestaccount-email' => '電子メールアドレス:',
	'requestaccount-reqtype' => 'サイトでの役割:',
	'requestaccount-level-0' => '著者',
	'requestaccount-level-1' => '編集者',
	'requestaccount-bio' => '自己紹介:',
	'requestaccount-attach' => '研究概要(レジュメ)や略歴(CV) (任意回答):',
	'requestaccount-notes' => '特記事項:',
	'requestaccount-urls' => 'ウェブサイト一覧 (任意回答、改行で区切ります):',
	'requestaccount-agree' => '本名が正しいこと、および、サービス利用規約に同意したことを宣誓していただく必要があります。',
	'requestaccount-inuse' => 'この利用者名は、承認待ちのアカウントにて既に申請済みです。',
	'requestaccount-tooshort' => "自己紹介は、最低限 $1個以上の単語で構成される必要があります。''(訳注：この機能は日本語版ではうまく動作しないかもしれません。あなたが管理者であるならば、この制約の使用に慎重であってください。あなたが一般利用者である場合、このサイトの管理者と相談してください。)''",
	'requestaccount-emaildup' => '承認待ちのアカウントと同一の電子メールアドレスが指定されました。',
	'requestaccount-exts' => 'この添付ファイルのタイプは許可されていません。',
	'requestaccount-resub' => 'セキュリティ上の理由により、研究概要/略歴のファイルを再指定する必要があります。
これらの公開を既に望んでいない場合、回答項目を空欄に戻してください。',
	'requestaccount-tos' => '私は {{SITENAME}} の [[{{MediaWiki:Requestaccount-page}}|サービス利用規約]] を既に熟読しており、これに同意し、遵守します。
私が"本名"欄に記入した名前は、自分の本名であることに間違いありません。',
	'requestaccount-submit' => 'アカウント申請',
	'requestaccount-sent' => 'あなたのアカウント申請は正常に送信され、現在承認を待っています。確認メールがあなたの電子メールアドレスに送信されました。',
	'request-account-econf' => 'あなたの電子メールアドレスは確認されました。アカウント申請にもそのように表示されます。',
	'requestaccount-email-subj' => '{{SITENAME}} 電子メールアドレスの確認',
	'requestaccount-email-body' => 'IPアドレス $1 を使用するどなたか(おそらくあなた)が、この電子メールアドレスを用いて {{SITENAME}} のアカウント "$2" の作成を申請しました。

この {{SITENAME}}　のアカウント作成が本当にあなたによる申請であると証明するには、以下のリンク先をブラウザから開いてください:

$3

アカウントが作成されると、パスワードが電子メールで送信されます。もしも、この申請があなたによるもの「ではない」場合、このリンクはクリックしないでください。
この承認手続きは $4 で期限切れとなります。',
	'requestaccount-email-subj-admin' => '{{SITENAME}} のアカウント申請',
	'requestaccount-email-body-admin' => '"$1" によるアカウント申請が承認待ちになっています。
申請電子メールアドレスは本人確認済みです。この申請への承認は、"$2"　から行うことができます。',
	'acct_request_throttle_hit' => '申し訳ありません、あなたは既に$1{{PLURAL:$1|アカウント}}を申請済みです。これ以上の申請はできません。',
	'requestaccount-loginnotice' => "利用者アカウントの取得は、'''[[Special:RequestAccount|アカウント登録申請]]'''から行ってください。",
	'confirmaccount-newrequests' => "現在、'''$1個'''のメール認証済み{{PLURAL:$1|[[Special:ConfirmAccounts|アカウント申請]]}}が承認待ちになっています。",
	'confirmaccounts' => 'アカウント登録申請の承認',
	'confirmedit-desc' => '{{int:group-bureaucrat}}にアカウント申請への承認機能を提供する',
	'confirmaccount-maintext' => "'''ここは、''{{SITENAME}}'' 上で承認待ちとなっているアカウント登録申請を処理するためのページです。'''

各アカウント申請が保管されている待ち行列は、3種類あります。1つは申請を受理するためのもの、1つは他の管理者が継続審議を意見し保留となっているもの、もう一つは最近棄却された申請です。

申請要求に応える際は、それを注意深く検討してください。必要であれば、申請に含まれている情報を確認してください。
作業内容は非公開のログに残されます。また、あなたが検討のためにここで行う活動は、個人的なものとならないことが望まれます。",
	'confirmaccount-list' => '以下は、承認待ちアカウントの一覧です。
承認されたアカウントは作成され、この一覧から削除されます。棄却されたアカウントは単にこの一覧から削除されます。',
	'confirmaccount-list2' => '以下は、最近申請が棄却されたアカウントの一覧で、これらは数日経過すると自動的に削除されます。
これらのアカウントを承認することはまだ可能ですが、まずは棄却した管理者と相談することをお勧めします。',
	'confirmaccount-list3' => '以下は、期限切れしたアカウント申請の一覧で、これらは数日経過すると自動的に削除されます。これらのアカウントを承認することはまだ可能です。',
	'confirmaccount-text' => "これは、'''{{SITENAME}}''' において承認待ちとなっている利用者アカウントです。

下記の利用者情報を慎重に検討してください。この申請を承認する場合、ドロップダウンリストを操作して利用者のアカウント状態を設定してください。
申請された自己紹介文に重篤な個人情報などが記載されている場合、編集により取り除くことが可能です。ただし、これは一般公開向けのもので、利用者信頼情報の内部保存データには影響を与えません。
申請されたものとは別の利用者名でアカウントを作成することも可能です。
これは、他の利用者と名前が競合する際にのみ行われるべきでしょう。

承認処理を行わず単にページ移動をした場合、または承認しなかった場合、この申請は承認待ちのままとなります。",
	'confirmaccount-none-o' => '現在、申請が受理されていないアカウントはありません。',
	'confirmaccount-none-h' => '現在、申請が承認保留となっているアカウントはありません。',
	'confirmaccount-none-r' => '最近に申請が棄却されたアカウントはありません。',
	'confirmaccount-none-e' => '現在この一覧には期限切れのアカウント申請はありません。',
	'confirmaccount-real-q' => '本名',
	'confirmaccount-email-q' => '電子メールアドレス',
	'confirmaccount-bio-q' => '自己紹介',
	'confirmaccount-showopen' => '未確定の申請',
	'confirmaccount-showrej' => '却下済み申請',
	'confirmaccount-showheld' => '承認保留アカウントの一覧を見る',
	'confirmaccount-showexp' => '期限切れ申請',
	'confirmaccount-review' => '承認検討',
	'confirmaccount-types' => 'アカウント承認待ち行列を選択してください:',
	'confirmaccount-all' => '(全ての待ち行列)',
	'confirmaccount-type' => '選択された待ち行列:',
	'confirmaccount-type-0' => '著者を希望',
	'confirmaccount-type-1' => '編集者を希望',
	'confirmaccount-q-open' => '申請受理',
	'confirmaccount-q-held' => '承認保留',
	'confirmaccount-q-rej' => '最近の申請棄却',
	'confirmaccount-q-stale' => '期限切れ申請',
	'confirmaccount-badid' => '指定されたIDに該当する承認待ちの申請はありません。
おそらく既に処理済みです。',
	'confirmaccount-leg-user' => '利用者アカウント',
	'confirmaccount-leg-areas' => '関心のある分野',
	'confirmaccount-leg-person' => '個人情報',
	'confirmaccount-leg-other' => 'その他',
	'confirmaccount-name' => '利用者名',
	'confirmaccount-real' => '本名:',
	'confirmaccount-email' => '電子メールアドレス:',
	'confirmaccount-reqtype' => 'サイトでの役割:',
	'confirmaccount-pos-0' => '著者',
	'confirmaccount-pos-1' => '編集者',
	'confirmaccount-bio' => '自己紹介:',
	'confirmaccount-attach' => '研究概要(レジュメ)や略歴(CV):',
	'confirmaccount-notes' => '特記事項:',
	'confirmaccount-urls' => 'ウェブサイト一覧:',
	'confirmaccount-none-p' => '(記述なし)',
	'confirmaccount-confirm' => 'この申請に対する承認、棄却、保留判断を以下から選択:',
	'confirmaccount-econf' => '(確認済)',
	'confirmaccount-reject' => '($2、[[User:$1|$1]]によって棄却)',
	'confirmaccount-rational' => '申請者に対して下された判断:',
	'confirmaccount-noreason' => '(記述なし)',
	'confirmaccount-autorej' => '(この申請は活動停止のため自動的に廃棄されました)',
	'confirmaccount-held' => '($2、[[User:$1|$1]]が"保留"の判断)',
	'confirmaccount-create' => '承認(アカウント作成)',
	'confirmaccount-deny' => '棄却(一覧から削除)',
	'confirmaccount-hold' => '保留',
	'confirmaccount-spam' => 'スパム(電子メールは送信しません)',
	'confirmaccount-reason' => '判断理由(電子メールに記載されます):',
	'confirmaccount-ip' => 'IPアドレス:',
	'confirmaccount-submit' => '判断確定',
	'confirmaccount-needreason' => '判断理由を以下に記載する必要があります。',
	'confirmaccount-canthold' => 'この申請は既に保留済みか、削除済みです。',
	'confirmaccount-acc' => 'アカウント申請の承認に成功しました。作成された新しいアカウントは [[User:$1|$1]] です。',
	'confirmaccount-rej' => 'アカウント申請は棄却されました。',
	'confirmaccount-viewing' => '(この申請は、現在[[User:$1|$1]]が受理しています)',
	'confirmaccount-summary' => '申請された自己紹介を用いた新規利用者ページ作成',
	'confirmaccount-welc' => "'''ようこそ''{{SITENAME}}''へ！''' 多くの寄稿を心よりお待ち申し上げます。
サイトでの活動に関しては、[[{{MediaWiki:Helppage}}|ヘルプページ]]をご覧ください。それでは、{{SITENAME}}で楽しいひと時を！",
	'confirmaccount-wsum' => 'ようこそ！',
	'confirmaccount-email-subj' => '{{SITENAME}} のアカウント申請',
	'confirmaccount-email-body' => 'あなたによる {{SITENAME}} でのアカウント申請は、承認されました。

　利用者名: $1

パスワード: $2

セキュリティ上の理由により、初回ログイン時に上記パスワードを変更する必要があります。
{{fullurl:Special:UserLogin}} よりログインしてください。',
	'confirmaccount-email-body2' => 'あなたによる {{SITENAME}} でのアカウント申請は、承認されました。

　利用者名: $1

パスワード: $2

$3

セキュリティ上の理由により、初回ログイン時に上記パスワードを変更する必要があります。
{{fullurl:Special:UserLogin}} よりログインしてください。',
	'confirmaccount-email-body3' => '申し訳ありません、{{SITENAME}} におけるアカウント "$1" の申請は、棄却されました。

これにはいくつかの理由が考えられます。
申請フォームの必要事項が正しく記載されていない、あなたに関することが充分に記載されていないといった、利用者信頼情報にまつわる方針に基づいた判断です。
利用者アカウント承認方針に関する詳細は、サイト連絡先までお尋ねください。',
	'confirmaccount-email-body4' => '申し訳ありません、{{SITENAME}} におけるアカウント "$1" の申請は、棄却されました。

$2

利用者アカウント承認方針に関する詳細は、サイト連絡先までお尋ねください。',
	'confirmaccount-email-body5' => '{{SITENAME}} におけるアカウント "$1" の申請承認には、以下の追加情報が必要です。

$2

利用者アカウント承認方針に関する詳細は、サイト連絡先までお尋ねください。',
	'usercredentials' => '利用者信頼情報',
	'usercredentials-leg' => '利用者信頼情報の閲覧',
	'usercredentials-user' => '利用者名:',
	'usercredentials-text' => '指定されたアカウント利用者の信頼情報は以下のとおりです。',
	'usercredentials-leg-user' => '利用者アカウント',
	'usercredentials-leg-areas' => '関心のある分野',
	'usercredentials-leg-person' => '個人情報',
	'usercredentials-leg-other' => 'その他',
	'usercredentials-email' => '電子メールアドレス:',
	'usercredentials-real' => '本名:',
	'usercredentials-bio' => '自己紹介:',
	'usercredentials-attach' => '研究概要(レジュメ)や略歴(CV):',
	'usercredentials-notes' => '特記事項:',
	'usercredentials-urls' => 'ウェブサイト一覧:',
	'usercredentials-ip' => '申請時IPアドレス:',
	'usercredentials-member' => '権限:',
	'usercredentials-badid' => '利用者信頼情報が見つかりません。利用者名が正しく指定されているか確認してください。',
	'right-confirmaccount' => '[[Special:ConfirmAccounts|アカウント申請キュー]]を見る',
	'right-requestips' => 'アカウント申請の処理中に申請者のIPアドレスを見る',
	'right-lookupcredentials' => '[[Special:UserCredentials|利用者信頼情報]]を見る',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'requestaccount' => 'Nyuwun rékening (akun)',
	'requestaccount-dup' => "'''Pènget: Panjenengan wis log mlebu mawa rékening sing kadaftar.'''",
	'requestaccount-leg-user' => 'Rékening (akun) panganggo',
	'requestaccount-leg-person' => 'Informasi pribadi',
	'requestaccount-leg-other' => 'Informasi liya',
	'requestaccount-real' => 'Jeneng asli:',
	'requestaccount-same' => '(padha karo jeneng asli)',
	'requestaccount-email' => 'Alamat e-mail:',
	'requestaccount-reqtype' => 'Posisi:',
	'requestaccount-level-0' => 'pangripta',
	'requestaccount-level-1' => 'panyunting',
	'requestaccount-bio' => 'Babad slira pribadi:',
	'requestaccount-attach' => 'Riwayat urip utawa CV (opsional):',
	'requestaccount-notes' => 'Cathetan tambahan:',
	'requestaccount-urls' => 'Daftar situs-situs wèb, yèn ana (pisahen mawa garis-garis anyar):',
	'requestaccount-agree' => "Panjenengan kudu mastèkaké yèn jeneng asli panjenengan iku bener lan panjenengan sarujuk karo Sarat Paladènan (''Terms of Service'') kita.",
	'requestaccount-inuse' => "Jeneng panganggo iki wis dienggo lan saiki lagi ing tahap ''pending'' panyuwunan rékening.",
	'requestaccount-tooshort' => 'Babad salira panjenengan minimal dawané kudu ngandhut $1 {{PLURAL:$1|tembung|tembung}}.',
	'requestaccount-emaildup' => "Sawijining panyuwunan rékening (akun) liyané sing lagi ''pending'' nganggo alamat e-mail sing padha",
	'requestaccount-exts' => "Jenis berkas lampiran (''attachment'') ora diparengaké.",
	'requestaccount-resub' => 'Berkas CV/riwayat urip panjenengan kudu dipilih manèh amerga alesan kaslamatan.
Lirwakna lapangan iki kosong yèn panjenengan ora kepéngin manèh nglebokaké CV.',
	'requestaccount-tos' => "Aku wis maca lan sarujuk nuruti [[{{MediaWiki:Requestaccount-page}}|Sarat Paladènan (''Terms of Service'')]]-é {{SITENAME}}.
Jeneng sing tak-wènèhaké minangka \"Jeneng asli\" iku pancèn jenengku dhéwé.",
	'requestaccount-submit' => 'Nyuwun rékening (akun)',
	'requestaccount-sent' => 'Panyuwunan akun panjenengan wis kasil dikirim lan saiki lagi dipriksa.
Sawijining layang konfirmasi wis dikirim menyang alamat layang-e panjenengan.',
	'request-account-econf' => 'Alamat e-mail panjenengan wis dikonfirmasi lan bakal didokok ing daftar kaya ing panyuwunan rékening panjenengan.',
	'requestaccount-email-subj' => 'Konfirmasi alamat e-mail {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'Panyuwunan rékening ing {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" wis nyuwun rékening lan saiki nunggu konfirmasi.
Alamat e-mailé wis dikonfirmasi. Panjenengan bisa konfirmasi panyuwunan iki ing "$2".',
	'acct_request_throttle_hit' => 'Nuwun sèwu, panjenengan wis nyuwun {{PLURAL:$1|1 akun|$1 akun}}.
Panjenengan ora bisa nyuwun rékening anyar manèh.',
	'requestaccount-loginnotice' => "Supaya bisa olèh rékening panganggo, panjenengan kudu '''[[Special:RequestAccount|nyuwun iku]]'''.",
	'confirmaccounts' => 'Konfirmasi panyuwunan rékening (akun)',
	'confirmedit-desc' => 'Mènèhi para birokrat kabisan kanggo konfirmasi panyuwunan rékening',
	'confirmaccount-real-q' => 'Jeneng',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'panyuwunan sing isih kabuka',
	'confirmaccount-showrej' => 'panyuwunan sing ditolak',
	'confirmaccount-showexp' => 'panyuwunan-panyuwunan kadaluwarsa',
	'confirmaccount-types' => 'Pilih sawijining antrian konfirmasi rékening saka ngisor iki:',
	'confirmaccount-all' => '(tuduhna kabèh antrian)',
	'confirmaccount-type' => 'Antrian:',
	'confirmaccount-q-open' => 'panyuwunan sing isih kabuka',
	'confirmaccount-q-rej' => 'panyuwunan sing lagi waé ditolak',
	'confirmaccount-q-stale' => 'panyuwunan-panyuwunan kadaluwarsa',
	'confirmaccount-leg-user' => 'Rékening panganggo',
	'confirmaccount-leg-person' => 'Informasi pribadi',
	'confirmaccount-leg-other' => 'Informasi liya',
	'confirmaccount-name' => 'Jeneng panganggo',
	'confirmaccount-real' => 'Jeneng:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Posisi:',
	'confirmaccount-pos-0' => 'pangripta',
	'confirmaccount-pos-1' => 'panyunting',
	'confirmaccount-bio' => 'Biografi:',
	'confirmaccount-attach' => 'Babad slira/CV:',
	'confirmaccount-notes' => 'Cathetan tambahan:',
	'confirmaccount-urls' => 'Daftar situs-situs wèb:',
	'confirmaccount-none-p' => '(ora diwènèhaké)',
	'confirmaccount-econf' => '(dikonfirmasi)',
	'confirmaccount-noreason' => '(ora ana)',
	'confirmaccount-spam' => 'Spam (aja ngirim e-mail)',
	'confirmaccount-reason' => 'Komentar (bakal disertakaké sajroning e-mail):',
	'confirmaccount-ip' => 'Alamat IP:',
	'confirmaccount-submit' => 'Konfirmasi',
	'confirmaccount-viewing' => '(saiki lagi dideleng déning [[User:$1|$1]])',
	'confirmaccount-summary' => 'Nggawé kaca pangganggo karo biografiné panganggo anyar.',
	'confirmaccount-wsum' => 'Sugeng rawuh!',
	'confirmaccount-email-subj' => 'Panyuwunan rékening ing {{SITENAME}}',
	'usercredentials-user' => 'Jeneng panganggo:',
	'usercredentials-leg-user' => 'Rékening panganggo',
	'usercredentials-leg-person' => 'Informasi pribadi',
	'usercredentials-leg-other' => 'Informasi liya',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Jeneng asli:',
	'usercredentials-bio' => 'Biografi:',
	'usercredentials-attach' => 'Babad slira/CV:',
	'usercredentials-notes' => 'Cathetan tambahan:',
	'usercredentials-urls' => 'Daftar situs-situs wèb:',
	'usercredentials-ip' => 'Alamat IP asli:',
	'usercredentials-member' => 'Hak-hak:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'requestaccount' => 'សំណើសុំគណនី',
	'requestaccount-page' => '{{ns:project}}:លក្ខខណ្ឌ ប្រើប្រាស់សេវា',
	'requestaccount-dup' => "'''សម្គាល់: លោកអ្នកត្រូវបានឡុកអ៊ីនចូលរួចហើយ ជាមួយនឹងគណនីដែលបានចុះឈ្មោះ។'''",
	'requestaccount-leg-user' => 'គណនីអ្នកប្រើប្រាស់',
	'requestaccount-leg-person' => 'ព័ត៌មានផ្ទាល់ខ្លួន',
	'requestaccount-leg-other' => 'ព័ត៌មាន ដទៃទៀត',
	'requestaccount-leg-tos' => 'លក្ខខណ្ឌ​នៃ​សេវាកម្ម​',
	'requestaccount-real' => 'ឈ្មោះពិត៖',
	'requestaccount-same' => '(ដូចឈ្មោះពិត)',
	'requestaccount-email' => 'អាសយដ្ឋានអ៊ីមែល៖',
	'requestaccount-reqtype' => 'តួនាទី៖',
	'requestaccount-level-0' => 'អ្នកនិពន្ធ៖',
	'requestaccount-level-1' => 'ឧបករណ៍កែប្រែ',
	'requestaccount-bio' => 'ជីវប្រវត្តិផ្ទាល់ខ្លួន៖',
	'requestaccount-attach' => 'ប្រវត្តិរូប (ស្រេចចិត្ត)​៖',
	'requestaccount-notes' => 'សម្គាល់បន្ថែម៖',
	'requestaccount-agree' => 'អ្នកត្រូវតែ បញ្ជាក់ថា ឈ្មោះពិត របស់អ្នក ត្រឹមត្រូវ និងថា អ្នកព្រមព្រៀង ចំពោះ លក្ខណ្ឌ ប្រើប្រាស់សេវា ។',
	'requestaccount-tooshort' => 'ជីវប្រវត្តិរបស់អ្នកត្រូវតែមានយ៉ាងតិច $1 {{PLURAL:$1|ពាក្យ|ពាក្យ}} ។',
	'requestaccount-submit' => 'សំណើសុំគណនី',
	'requestaccount-email-subj' => 'ការបញ្ជាក់ទទួលស្គាល់ អាសយដ្ឋានអ៊ីមែល {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'សំណើសុំគណនីរបស់{{SITENAME}}',
	'acct_request_throttle_hit' => 'សូមអភ័យទោស។ អ្នកបានស្នើសុំ {{PLURAL:$1|១ គណនី|$1 គណនី}} រួចហើយ។

អ្នកមិនអាចធ្វើការស្នើសុំទៀតបានទេ។',
	'requestaccount-loginnotice' => "ដើម្បីទទួលបានគណនីអ្នកប្រើប្រាស់ អ្នកត្រូវតែ'''[[Special:RequestAccount|ស្នើសុំគណនី]]'''។",
	'confirmaccounts' => 'បញ្ជាក់ទទួលស្គាល់ សំណើគណនី',
	'confirmaccount-list' => 'ខាងក្រោមនេះជាបញ្ជីរាយនាមគណនីដែលកំពុងរង់ចាំការអនុម័ត។ ពេលដែលសំនើត្រូវបានយល់ស្របឬបដិសេធ វានឹងត្រូវដកចេញពីបញ្ជីនេះ។',
	'confirmaccount-real-q' => 'ឈ្មោះ',
	'confirmaccount-email-q' => 'អ៊ីមែល',
	'confirmaccount-bio-q' => 'ជីវប្រវត្តិ',
	'confirmaccount-showrej' => 'ការស្នើសុំត្រូវបានបដិសេធ',
	'confirmaccount-showexp' => 'ការស្នើសុំផុតកំណត់ហើយ',
	'confirmaccount-review' => 'មើលឡើងវិញ',
	'confirmaccount-all' => '(បង្ហាញ គ្រប់ ជួររង់ចាំ)',
	'confirmaccount-type' => 'ជួររង់ចាំ ត្រូវបានជ្រើសយក ៖',
	'confirmaccount-leg-user' => 'គណនីអ្នកប្រើប្រាស់',
	'confirmaccount-leg-person' => 'ព័ត៌មានផ្ទាល់ខ្លួន',
	'confirmaccount-leg-other' => 'ព័ត៌មាន​ដទៃ',
	'confirmaccount-name' => 'ឈ្មោះអ្នកប្រើប្រាស់',
	'confirmaccount-real' => 'ឈ្មោះ​៖',
	'confirmaccount-email' => 'អ៊ីមែល​៖',
	'confirmaccount-reqtype' => 'មុខងារ:',
	'confirmaccount-pos-0' => 'អ្នកនិពន្ធ',
	'confirmaccount-pos-1' => 'ឧបករណ៍កែប្រែ',
	'confirmaccount-bio' => 'ជីវប្រវត្តិ​៖',
	'confirmaccount-attach' => 'ប្រវត្តិរូប​៖',
	'confirmaccount-notes' => 'កំណត់សម្គាល់បន្ថែម៖',
	'confirmaccount-urls' => 'បញ្ជីគេហទំព័រ៖',
	'confirmaccount-none-p' => '(មិនត្រូវបាន​ផ្តល់)',
	'confirmaccount-econf' => '(បានបញ្ជាក់ទទួលស្គាល់)',
	'confirmaccount-noreason' => '(ទទេ)',
	'confirmaccount-create' => 'ព្រមទទួល (បង្កើត​គណនី)',
	'confirmaccount-reason' => 'យោបល់(នឹងត្រូវបានបញ្ចូលទៅក្នុងអ៊ីមែល)៖',
	'confirmaccount-ip' => 'អាសយដ្ឋាន IP៖',
	'confirmaccount-submit' => 'បញ្ជាក់ទទួលស្គាល់',
	'confirmaccount-needreason' => 'អ្នក​ត្រូវ​ផ្តល់​ហេតុផល ក្នុង​ប្រអប់វិចារ​ខាងក្រោម​​។',
	'confirmaccount-acc' => 'សំណើគណនី​ត្រូវ​បាន​អះអាង​ដោយជោគជ័យ,

បាន​បង្កើត​គណនី​អ្នកប្រើប្រាស់​ថ្មី​ហើយ [[User:$1|$1]]​។',
	'confirmaccount-rej' => 'សំណើសុំគណនីបានបដិសេធរួចជាស្រេចហើយ។',
	'confirmaccount-summary' => 'បង្កើត​ទំព័រ​អ្នកប្រើប្រាស់​ជាមួយ​ប្រវត្តិរូប​នៃ​អ្នកប្រើប្រាស់​ថ្មី​។',
	'confirmaccount-wsum' => 'សូមស្វាគមន៍!',
	'confirmaccount-email-subj' => 'សំណើសុំគណនី {{SITENAME}}',
	'confirmaccount-email-body' => 'សំណើសុំគណនីរបស់អ្នកនៅលើ{{SITENAME}}ត្រូវបានទទួលយកហើយ។


ឈ្មោះគណនី: $1


ពាក្យសំងាត់: $2


ដើម្បីសុវត្ថិភាព អ្នកនឹងត្រូវការជាចាំបាច់ប្តូរពាក្យសំងាត់របស់អ្នកនៅពេលឡុកអ៊ីកលើកដំបូង។

ឡុកអ៊ីន សូមទៅកាន់ {{fullurl:Special:UserLogin}} ។',
	'confirmaccount-email-body2' => 'សំណើសុំគណនីរបស់អ្នកនៅលើ{{SITENAME}}ត្រូវបានទទួលយកហើយ។

ឈ្មោះគណនី: $1

ពាក្យសំងាត់: $2

$3

ដើម្បីសុវត្ថិភាពអ្នកនឹងត្រូវការជាចាំបាច់ប្តូរពាក្យសំងាត់របស់អ្នកនៅពេលឡុកអ៊ីកលើកដំបូង។

ឡុកអ៊ីន សូមទៅកាន់{{fullurl:Special:UserLogin}} ។',
	'usercredentials-user' => 'ឈ្មោះអ្នកប្រើប្រាស់៖',
	'usercredentials-leg-user' => 'គណនីអ្នកប្រើប្រាស់',
	'usercredentials-leg-person' => 'ព័ត៌មាន​ផ្ទាល់ខ្លួន',
	'usercredentials-leg-other' => 'ព័ត៌មានផ្សេងៗទៀត',
	'usercredentials-email' => 'អ៊ីមែល​៖',
	'usercredentials-real' => 'ឈ្មោះពិត​៖',
	'usercredentials-bio' => 'ជីវប្រវត្តិ​៖',
	'usercredentials-attach' => 'ប្រវត្តិរូប​៖',
	'usercredentials-notes' => 'ចំណាំ​បន្ថែម​៖',
	'usercredentials-urls' => 'បញ្ជី​នៃ​បណ្ដាញវិប​៖',
	'usercredentials-ip' => 'អាសយដ្ឋាន IP ដើមដំបូង ៖',
	'usercredentials-member' => 'សិទ្ធិ​៖',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'requestaccount-level-0' => 'ಕರ್ತೃ',
	'confirmaccount-real-q' => 'ಹೆಸರು',
	'confirmaccount-email-q' => 'ಇ-ಅಂಚೆ',
	'confirmaccount-real' => 'ಹೆಸರು:',
	'confirmaccount-email' => 'ಇ-ಅಂಚೆ:',
	'confirmaccount-pos-0' => 'ಕರ್ತೃ',
	'usercredentials-email' => 'ಇ-ಅಂಚೆ:',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'requestaccount' => '계정 요청',
	'requestaccount-dup' => "'''참고: 당신은 이미 등록된 계정으로 로그인되어 있습니다.'''",
	'requestaccount-leg-areas' => '주요 관심 분야',
	'requestaccount-leg-other' => '다른 정보',
	'requestaccount-leg-tos' => '이용 약관',
	'requestaccount-real' => '실명:',
	'requestaccount-same' => '(실명과 같음)',
	'requestaccount-email' => '이메일 주소:',
	'requestaccount-submit' => '계정 요청',
	'requestaccount-email-body' => '$1 IP 주소를 사용하는 사용자가 이 이메일 주소로 {{SITENAME}}에 "$2" 계정 생성을 요청하였습니다.

{{SITENAME}}의 이 계정이 당신이 요청한 것이라면, 당신의 브라우저로 아래의 링크를 열어주세요:

$3

계정이 생성되면, 암호는 당신의 이메일로 전송될 것입니다.
만약 당신의 것이 아니라면 위의 링크를 열지 마세요.
이 확인 코드는 $4에 만료될 것입니다.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} 계정 생성 요청',
	'confirmaccount-email-q' => '이메일',
	'confirmaccount-showopen' => '진행 중인 요청',
	'confirmaccount-showrej' => '거부된 요청',
	'confirmaccount-showheld' => '보류된 요청',
	'confirmaccount-showexp' => '만료된 요청',
	'confirmaccount-all' => '(모든 큐 보기)',
	'confirmaccount-q-open' => '진행 중인 요청',
	'confirmaccount-q-held' => '보류된 요청',
	'confirmaccount-q-rej' => '최근에 거부된 요청',
	'confirmaccount-reject' => '($2에 [[User:$1|$1]]에 의해 거부됨)',
	'confirmaccount-noreason' => '(없음)',
	'confirmaccount-create' => '승인 (계정 생성)',
	'confirmaccount-deny' => '거부 (목록에서 제거)',
	'confirmaccount-hold' => '보류',
	'confirmaccount-spam' => '스팸 (이메일을 보내지 않습니다)',
	'confirmaccount-reason' => '이유 (이메일에 포함될 것입니다):',
	'confirmaccount-ip' => 'IP 주소:',
	'confirmaccount-submit' => '확인',
	'confirmaccount-wsum' => '환영합니다!',
	'confirmaccount-email-body' => '{{SITENAME}}에서 당신의 계정 생성 요청이 승인되었습니다.

계정 이름: $1

비밀번호: $2

보안상의 이유로 인해 첫 로그인 이후 비밀번호를 바꾸어야 합니다.
로그인하시려면 {{fullurl:Special:UserLogin}} 을 이용해주십시오.',
	'confirmaccount-email-body2' => '{{SITENAME}}에서 당신의 계정 생성 요청이 승인되었습니다.

계정 이름: $1

비밀번호: $2

$3

보안상의 이유로 인해 첫 로그인 이후 비밀번호를 바꾸어야 합니다.
로그인하시려면 {{fullurl:Special:UserLogin}} 을 이용해주십시오.',
	'usercredentials-email' => '이메일:',
	'usercredentials-real' => '실명:',
	'usercredentials-member' => '권한:',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-email' => 'E-mail:',
	'usercredentials-email' => 'E-mail:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'requestaccount' => 'Noh em Zojang als Metmaacher frore',
	'requestaccount-text' => "'''Donn dat Formblatt unge ußfölle un afschecke, öm noh enem Zohjang als Metmaacher ze froore.'''

Donn op jede Fall eets de Sigg [[{{MediaWiki:Requestaccount-page}}|{{int:requestaccount-leg-tos}}]] lesse, ih dat De hee Ding Aanfrooch shtälls.

Sobald De ene Zohjang kräje häß, kriß De en <i lang=\"en\">e-mail</i> jescheck, un Do kanns Desch hee [[Special:UserLogin|enlogge]].",
	'requestaccount-page' => '{{ns:project}}:{{int:requestaccount-leg-tos}}',
	'requestaccount-dup' => "'''Opjepaß: Do bes ald enjelogg met enem zohjelohße Metmaacher-Name.'''",
	'requestaccount-leg-user' => 'Aanmeldung als ene Metmaacher',
	'requestaccount-leg-areas' => 'Enträße en de Houpsaach',
	'requestaccount-leg-person' => 'Päsönlesche Enfomazjuhne',
	'requestaccount-leg-other' => 'Ander Ennfomazjuhne',
	'requestaccount-leg-tos' => 'Bedengunge för et Metmaache',
	'requestaccount-acc-text' => 'En <i lang="en">e-mail</i> met en Beschtätejung jeiht aan Ding <i lang="en">e-mail</i>-Addräß, wann Ding Aanfrooch enjereisch es. Donn op dä Lengk för et Beschtäätejje klecke, dä en dä <i lang="en">e-mail</i> dren es. Wann Dinge Zohjang enjerescht es, kriß De norr_em <i lang="en">e-mail</i> jescheck met enem Passwoot dren, woh De Desch dann heh met enlogge kanns.',
	'requestaccount-areas-text' => 'Donn he dronger ußsöke en wat De et miehßte Fachwesse häß un Desch et bäß ußkänns, udder woh De et miihtß em Wikki beidraare wells.',
	'requestaccount-ext-text' => 'Di Daate hee dronger blieve unger uns. Se wääde allein doför jebruch, övver Ding Aanfrooch noh enem Zohjang ze äntscheide. He kanns De Saache, wi en Telefonnummer, aanjevve, di methellfe künne, ze prööfe, wä De bes, un dat ding Aanjabe reschtesch sin.',
	'requestaccount-bio-text' => 'Dä Täx övver Ding Levve weed för der Aanfang op Ding Metmaachersigg jeschtallt. Donn alles aanjevve, wat De ze beede häs, ävver bes och sescher, dat de Desh joot föhls domet, dat öffentlesch ze maache. Dinge Name kann De övver [[Special:Preferences|Ding Enshtellunge]] ändere.',
	'requestaccount-real' => 'Dinge richtije Name:',
	'requestaccount-same' => '(dä sellve wi dä reschtijje Name)',
	'requestaccount-email' => '<i lang="en">e-mail</i> Addreß',
	'requestaccount-reqtype' => 'Posizjuhn:',
	'requestaccount-level-0' => 'Schriiver',
	'requestaccount-level-1' => 'Änderer',
	'requestaccount-bio' => 'Et Levve beß jäz:',
	'requestaccount-attach' => 'Dinge Levvensverlouf, kanns De ävver fott lohße:',
	'requestaccount-notes' => 'Söns noch jet:',
	'requestaccount-urls' => 'Wann De Websigge häs, jiv en Leß aan, jede ein op en eije Reih för sesch:',
	'requestaccount-agree' => 'Do moß beshtäätejje, dat Dinge Name reschtesch es, un dat De uns „{{int:requestaccount-leg-tos}}“ aan_nemmps.',
	'requestaccount-inuse' => 'Dä Metmaacher-Name es ald en ene andere Aanfrooch jewönsch, ävver noch nit zohjedeilt.',
	'requestaccount-tooshort' => 'Dä Täx övver Ding Levve sullt winnischßdens {{PLURAL:$1|ei Woot|$1 Wööt|kei Wööt}} lang sin.',
	'requestaccount-emaildup' => 'En ander Aanfrooch noh enem Zohjang als Metmaacher hät de sellve <i lang="en">e-mail</i>-Addräß.',
	'requestaccount-exts' => 'Di Zoot Datei-Aanhang es nit zohjelohße.',
	'requestaccount-resub' => 'Dinge Levvensverlouf moß norr_ens neu ußjewählt wäde, zor Sescherheit. Lohß dat Feld leddisch, wann De_n_nit mieh wigger dobei han wells.',
	'requestaccount-tos' => 'Esch han jelesse, wat op dä Sigg „[[{{MediaWiki:Requestaccount-page}}|{{int:requestaccount-leg-tos}}]]“ övver de {{SITENAME}} shteiht, Un esch versescheren, dat wad esch unger „reschtijje Name“ aanjejovve hann, wörklesch minge reschtijje Name es.',
	'requestaccount-submit' => 'Noh enem Zojang als ene Metmaacher frore',
	'requestaccount-sent' => 'Ding Aanfrooch es jäz op der Wääsch jebraat, un waadt drop, dat sesch Eine dröm kömmert.
För se ze beschtäätejje, es en <i lang="en">e-mail</i> aan Ding aanjejovve Adräß ongerwähß.',
	'request-account-econf' => 'Ding <i lang="en">e-mail</i>-Addräß es beschtätesch un dat shteiht jetß och esu en Dinge Aanfrooch noh enem Zohjang als Metmaacher dren.',
	'requestaccount-email-subj' => 'De {{SITENAME}} ier <i lang="en">e-mail</i>-Addräß Beschtätejung',
	'requestaccount-email-body' => 'Daach,

künnt sin, Do woohß et sellver, jedenfalls hät eine vun dä IP-Address
$1 en Aanfrooch noh enem Zohjang op de {{SITENAME}}
als Metmaacher met däm Name „$2“ jeschtallt.

Jetz wulle mer vun Dier en Beschtäätejung, dat dat all ääsch es,
un dat De dat och sellver wohß, un esu ene Zohjang han wells.
Zom Beschtäätejje, jangk met Dingem Web-Brauser op dä Lengk:

$3

Wann Dinge Zohjang dann ennjerescht wood, kriß Do allein dat
Passwoot doför zohjescheck.

Wann dat alles Kappes es, un De wells jaa nit op de {{SITENAME}}
metmaache, dann donn jaa nix. Aam $5 öm $6 Uhr verfällt dä Lengk
bovve automattesch un vun janz allein.

Ene schööne Jrooß vun de {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'Aanfrooch för Metmaacher op dä {{SITENAME}} ze wääde.',
	'requestaccount-email-body-admin' => '{{GENDER:$1|Dä|Dat|Dä Metmaacher|Dat|De}} „$1“ well ene Zohjang han un es am waade, dä ze krijje. De aanjejovve <i lang="en">e-mail</i>-Addräß es beschtätesch. Do kanns dämm dä Zohjang jevve op dä Sigg: $2',
	'acct_request_throttle_hit' => 'Deihd uns leid, Do häs {{PLURAL:$1|ald|ald $1 Mohl|jaanit}} noh enem Zohjang jefrooch. Do kanns nit noch mieh Aanfroore enreische.',
	'requestaccount-loginnotice' => "Öm ene Zohjang ze krijje, donn '''[[Special:RequestAccount|noh einem froore]]'''.",
	'confirmaccount-newrequests' => "'''\$1''' unjedonn [[Special:ConfirmAccounts|{{PLURAL:\$1|Aanfrooch|Aanfroore|Aanfroore}}]] met beschtääteschte <i lang=\"en\">e-mail</i>-Addräß {{PLURAL:\$1|es|sin|sin}} am waade.",
	'confirmaccounts' => 'Aanfroore noh Metmaacher beschtähtejje',
	'confirmedit-desc' => 'Määt et müjjelesch, dat {{int:group-bureaucrat}} de neu Aanmeldunge beshtätejje.',
	'confirmaccount-maintext' => "'''Die Sigg hee es för unjedonn Aanfroore noh Zohjäng als Metmaacher vun de {{SITENAME}} ze beärbeide.'''

Jede Schlang met Aanfroore es ongerdeijlt en drei eije Schlange met dä Zoote: Unjedonn — Zeröckjeschtallt weil mer noch op Antwoote am waade sin — un köözlesch eets afjelehnt.

Wann De en Aanfrooch opnemms, dann loor jenou do dorsch, un wann nüdesch, fengk Beschtätejunge för dat, wat doh aanjejovve es. Wat de määß, dat weed faßjehallde, ävver bliev onger uns. Mer äwaade och vun Der, dat de en Ouch drop häs, wat Andere hee donn.",
	'confirmaccount-list' => 'Hee dronger es en Leß met Aanfroore, di aanjenumme wääde welle.
Wann ene Aanfrooch aanjenumme udder affjelehnt es, kütt se eruß uß dä Leß.',
	'confirmaccount-list2' => 'Hee dronger es en Leß met afjelehnte Aanfroore, di automattesch uß dä Leß eruß kumme, wann se en paa Dääsch alt sin.
Se künne emmer noch aanjenumme wähde, ävver et es wall en joode Idee, eets ens met däm Wiki-Köbes ze kalle, dä se afjelehnt hät.',
	'confirmaccount-list3' => 'Hee dronger es en Leß met ußjeloufe Aanfroore, di automattesch uß dä Leß eruß kumme, wann se en paa Dääsch alt sin.
Se künne ävver emmer noch aanjenumme wähde.',
	'confirmaccount-text' => "Dat es en Aanfrooch noh enem Zohjang als Metmaacher op de '''{{SITENAME}}'''.

Donn Der de Enfommazjuhne onge jenou dorschlesse.
Wann De dä Metmaacher aannemmps, nemm de Enstellung „Posizjuhn“ öm däm Metmaacher singe Shtattus enzeshtelle. Änderunge aan dä Date övver et Levve en dä Aanfrooch donn nit beeinfluße, wat op Duur övver dä Metmaacher faßjehallde weed. Do kanns dä Metmaacher unger enem andere Name aanlääje lohße. Domet kanns De dubbelte Name verhendere.

Wann de Vun dä Sigg hee fott jeihß, oohne se afzelehne udder beshtähtejje, bliet di Aanfrooch shtonn un waadt wigger.",
	'confirmaccount-none-o' => 'Em Momang senn_er kei unjedonn Aanfroore noh Zohjäng för Metmaacher en de Leß.',
	'confirmaccount-none-h' => 'Em Momang senn_er kei zerökjeshtallte Aanfroore noh Zohjäng för Metmaacher en de Leß.',
	'confirmaccount-none-r' => 'Em Momang senn_er kei köözlesch affjelehnte Aanfroore noh Zohjäng för Metmaacher en de Leß.',
	'confirmaccount-none-e' => 'Em Momang senn_er kei ußjeloufe Aanfroore noh Zohjäng för Metmaacher en de Leß.',
	'confirmaccount-real-q' => 'Name',
	'confirmaccount-email-q' => '<i lang="en">e-mail</i>',
	'confirmaccount-bio-q' => 'Et Levve beß jäz',
	'confirmaccount-showopen' => 'unjedonn Aanfroore',
	'confirmaccount-showrej' => 'affjelehnte Aanfroore',
	'confirmaccount-showheld' => 'zerökjeshtallte Aanfroore',
	'confirmaccount-showexp' => 'ußjeloufe Aanfroore',
	'confirmaccount-review' => 'Beärbeejde',
	'confirmaccount-types' => 'Donn ein Schlang för de Beshtätejung för neu Metmaacher hee dronger ußsöhke:',
	'confirmaccount-all' => '(alle Schlange aanzeije)',
	'confirmaccount-type' => 'Schlang:',
	'confirmaccount-type-0' => 'müjjelesche Schriiver',
	'confirmaccount-type-1' => 'müjjelesche Änderer',
	'confirmaccount-q-open' => 'Aanfrore am waade',
	'confirmaccount-q-held' => 'zerökjestallte un opjeschovve Aanfore',
	'confirmaccount-q-rej' => 'köözlesch afjeleente Aanfrore',
	'confirmaccount-q-stale' => 'afjeloufe Aanfrore',
	'confirmaccount-badid' => 'Mer han kein Aanfrooch met dä Kännong en de Schlang. Müjjelesch, dat se ald dorsch es.',
	'confirmaccount-leg-user' => 'Däm Metmaacher sing Aanmeldung',
	'confirmaccount-leg-areas' => 'Enträße en de Houpsaach',
	'confirmaccount-leg-person' => 'Päsönlesche Enfomazjuhne',
	'confirmaccount-leg-other' => 'Ander Ennfomazjuhne',
	'confirmaccount-name' => 'Metmaacher Name',
	'confirmaccount-real' => 'Name:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Posizjuhn:',
	'confirmaccount-pos-0' => 'Schriever',
	'confirmaccount-pos-1' => 'Beärbeider',
	'confirmaccount-bio' => 'Et Lääve beß jäz:',
	'confirmaccount-attach' => 'Levvensverlouf:',
	'confirmaccount-notes' => 'Söns noch jet:',
	'confirmaccount-urls' => 'Leß met Webßaits:',
	'confirmaccount-none-p' => '(nix aanjejovve)',
	'confirmaccount-confirm' => 'Donn met dä Ußwahl hee noh entscheide, dä Aandraach aanzenämme, affzelänne, udder noch jet ze waade.',
	'confirmaccount-econf' => '(beshtähtish)',
	'confirmaccount-reject' => '(aam $3 öm $4 Uhr {{GENDER:$1|fum|fum|fum Metmaacher|fum|fun de}} [[User:$1|$1]] affjeleent)',
	'confirmaccount-rational' => 'Jif ene Jrond för dä Aandraachshteller:',
	'confirmaccount-noreason' => '(nix)',
	'confirmaccount-autorej' => '(di Aanfrooch wood automattesch fottjeschmeße, weil zoh lang Keine jet draan jedonn hät)',
	'confirmaccount-held' => '(aam $3 öm $4 Uhr {{GENDER:$1|fum|fum|fum Metmaacher|fum|fun dä}} [[User:$1|$1]] op „waade“ jesatz)',
	'confirmaccount-create' => 'Aannämme, un dä Metmaacher aanlääje',
	'confirmaccount-deny' => 'Aflehne, un uß dä Leß nämme',
	'confirmaccount-hold' => 'Zeröckställe',
	'confirmaccount-spam' => 'SPAM (don kei <i lang="en">e-mail</i> eruß schecke)',
	'confirmaccount-reason' => 'Kommentaa för en de <i lang="en">e-mail</i> met eren ze donn, die dä Aanfroorer kritt:',
	'confirmaccount-ip' => 'IP-Address:',
	'confirmaccount-submit' => 'Beshtähtejje',
	'confirmaccount-needreason' => 'Do moß ene Jrond en däm Feld unge endraare.',
	'confirmaccount-canthold' => 'Di Aanfrooch es entweder zerökjeshtallt udder fottjeschmeße.',
	'confirmaccount-acc' => 'Di Aanfrooch es aajenumme, un beshtätesch, dä Metmaacher [[User:$1|$1]] wood aanjelaat.',
	'confirmaccount-rej' => 'Di Aanfrooch noh enem Zojang wood afjelehnt.',
	'confirmaccount-viewing' => '(Weet em Momang {{GENDER:$1|vum|vum|vum Metmaacher|vum|vun dä}} [[User:$1|$1]] aanjeloert)',
	'confirmaccount-summary' => 'Ben en Metmaachersigg met dä Levvensdaate vun dämneue Metmaacher am aanlääje.',
	'confirmaccount-welc' => "'''Wellkumme op de ''{{SITENAME}}''!'''
Mer hoffe, Do deihs joot un vill beidraare.
Künnt sin, Do wells de [[{{MediaWiki:Helppage}}|Sigge met Hülp]] lesse.
Norr_ens, wellkumme, un vill Shpaß hee!",
	'confirmaccount-wsum' => 'Wellkumme!',
	'confirmaccount-email-subj' => 'Ding Aanfrooch noh enem Zohjang op de {{SITENAME}}',
	'confirmaccount-email-body' => 'Op Ding Aanfrooch noh enem Zohjang op de {{SITENAME}} es de Antwoot:
Hurra, jetz kanns de erin.

Dinge Name als Metmaacher es „$1“

Ding Passwoot es „$2“

Zor Sescherheit moß De Ding Passwoot ändere, wann De et eehzte Mohl enloggs.
Zom Enlogge, jangk noh {{fullurl:Special:UserLogin}}',
	'confirmaccount-email-body2' => 'Op Ding Aanfrooch häß De enen Zohjang op de {{SITENAME}} krääje.

Dinge Name als Metmaacher es „$1“

Ding Passwoot es „$2“

$3

Zor Sescherheit moß De Ding Passwoot ändere, wann De et eehzte Mohl enloggs.
Zom Enlogge, jangk noh {{fullurl:Special:UserLogin}}',
	'confirmaccount-email-body3' => 'Ding Aanfrooch noh enem Zohjang op de {{SITENAME}}
als Metmaacher met däm Name „$1“ es afjelehnt.

Doh kann et etlijje Jrönd för jevve. De künnts dat Fommulaa verkeht ußjeföllt han,
Ding Antwoote wohre nit jenooch, udder De häs jet jemaat, wat för dat Wikki nit paß.
Wann en Leß met Kuntakte em Wikki es, kanns De doh drövver versöhke, wigger ze kumme,
wann De doch noch erin wells, udder jet ze saare udder ze froore häs.',
	'confirmaccount-email-body4' => 'Ding Aanfrooch noh enem Zohjang als Metmaacher op de {{SITENAME}}
met däm Name „$1“ es afjelehnt woode.

$2

Wann en Leß met Kuntakte em Wikki es, kanns De doh drövver versöhke,
wigger ze kumme, wannv De doch noch erin wells, udder jet ze saare
udder ze froore häs.',
	'confirmaccount-email-body5' => 'Iih dat Ding Aanfrooch noh enem Zohjang als Metmaacher
met däm Name „$1“
op de {{SITENAME}}
aanjenumme wääde kann, do moß De noch jet nohlääje.

$2

Wann en Leß met Kuntakte em Wiki es, kanns De doh drövver
versöhke, wigger ze kumme, wann De noch Froore häs.',
	'usercredentials' => 'De Nohwiise för ene Metmaacher',
	'usercredentials-leg' => 'De beshtäteschte Nohwiise för ene Metmaacher nohloore',
	'usercredentials-user' => 'Metmaacher Name:',
	'usercredentials-text' => 'Hee kumme de nohjeprööfte Date un Eijeschaffte vun däm ußjesohte Metmaacher.',
	'usercredentials-leg-user' => 'Däm Metmaacher sing Aanmeldung',
	'usercredentials-leg-areas' => 'Enträße en de Houpsaach',
	'usercredentials-leg-person' => 'Päsönlesche Enfomazjuhne',
	'usercredentials-leg-other' => 'Ander Ennfomazjuhne',
	'usercredentials-email' => '<i lang="en">e-mail</i>:',
	'usercredentials-real' => 'Dä richtije Name:',
	'usercredentials-bio' => 'Et Levve beß jäz:',
	'usercredentials-attach' => 'Levvensverlouf:',
	'usercredentials-notes' => 'Söns es noch ze saare:',
	'usercredentials-urls' => 'Leß met Webßaits:',
	'usercredentials-ip' => 'De ojinaal <code lang="en">IP-</code>Addräß:',
	'usercredentials-member' => 'Rääschte:',
	'usercredentials-badid' => 'Mer han kein Aanjabe för dä Metmaacher jefonge.
Loor ens, ov dä Name reschtesch jetipp es.',
	'right-confirmaccount' => 'De [[Special:ConfirmAccounts|Schlang met de aanjefroochte Zohjäng]] beloore',
	'right-requestips' => 'De jewönschte Neu_Metmaacher ier <code lang="en">IP-</code>Addräß aanloore beim Aanfroore beärbeede',
	'right-lookupcredentials' => 'De [[Special:UserCredentials|Nohwiise]] för Metmaacher aanloore',
);

/** Cornish (Kernowek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'requestaccount-email' => 'Trigva e-bost:',
	'confirmaccount-email-q' => 'E-bost',
	'confirmaccount-name' => 'Hanow-usyer',
	'confirmaccount-email' => 'E-bost:',
	'confirmaccount-wsum' => 'Dynnargh!',
	'usercredentials-user' => 'Hanow-usyer:',
	'usercredentials-email' => 'E-bost:',
);

/** Latin (Latina)
 * @author Omnipaedista
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'requestaccount-leg-user' => 'Ratio usoris',
	'requestaccount-real' => 'Nomen verum:',
	'requestaccount-same' => '(aequus ad nomine vero)',
	'requestaccount-email' => 'Inscriptio electronica:',
	'requestaccount-reqtype' => 'Positio:',
	'requestaccount-level-0' => 'auctor',
	'requestaccount-level-1' => 'recensor',
	'requestaccount-notes' => 'Notae addititiae:',
	'confirmaccount-real-q' => 'Nomen',
	'confirmaccount-email-q' => 'Litterae electronicae',
	'confirmaccount-bio-q' => 'Biographia',
	'confirmaccount-review' => 'Praevidere',
	'confirmaccount-leg-user' => 'Ratio usoris:',
	'confirmaccount-name' => 'Nomen usoris',
	'confirmaccount-real' => 'Nomen',
	'confirmaccount-email' => 'Litterae electronicae:',
	'confirmaccount-reqtype' => 'Positio:',
	'confirmaccount-pos-0' => 'auctor',
	'confirmaccount-pos-1' => 'recensor',
	'confirmaccount-bio' => 'Biographia:',
	'confirmaccount-attach' => 'Curriculum vitae:',
	'confirmaccount-noreason' => '(nulla)',
	'confirmaccount-ip' => 'Locus IP:',
	'confirmaccount-wsum' => 'Salve!',
	'usercredentials-user' => 'Nomen usoris:',
	'usercredentials-leg-user' => 'Ratio usoris:',
	'usercredentials-email' => 'Litterae electronicae:',
	'usercredentials-real' => 'Nomen verum:',
	'usercredentials-bio' => 'Biographia:',
	'usercredentials-attach' => 'Curriculum vitae:',
	'usercredentials-notes' => 'Notae addititiae:',
	'usercredentials-ip' => 'Locus IP originalis:',
	'usercredentials-member' => 'Potestates:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'requestaccount' => 'Benotzerkont ufroen',
	'requestaccount-text' => "'''Fëllt dëse Formulaire aus a schéckt e fort fir e Benotzerkont unzefroen'''.

Passt op datt Dir d'éischt d'[[{{MediaWiki:Requestaccount-page}}|Conditioune vun der Notzung]] gelies hutt éier Dir e Benotzerkont ufrot.

Wann Äre Benotzekont ugeholl as, kritt Dir eng Informatioun per E-Mail an Dir kënnt Äre Benotzerkont  [[Special:UserLogin|benotzen]].",
	'requestaccount-page' => '{{ns:project}}:Notzungsbedingungen',
	'requestaccount-dup' => "'''Opgepasst: Dir sidd scho matt engem registréierte Benotzerkont ugemellt.'''",
	'requestaccount-leg-user' => 'Benotzerkont',
	'requestaccount-leg-areas' => 'Haaptinteressen',
	'requestaccount-leg-person' => 'Perséinlech Informatiounen',
	'requestaccount-leg-other' => 'Aner Informatiounen',
	'requestaccount-leg-tos' => 'Conditioune vun der Notzung',
	'requestaccount-acc-text' => 'Esoubal wéi Dir dës Ufro geschéckt hutt kritt Dir e Confirmatiouns-Message op Är E-Mailadress.
Äntwert w.e.g. duerch klicken op de Confirmatiouns-Link deen an däer Mail drasteet.
Och Ärt Passwuert gëtt Iech gemailt esoubal wéi Äre Benotzerkonnt ugeluecht ginn ass.',
	'requestaccount-areas-text' => 'Wielt déi Sujeten aus an denen Dir formaalt Fachwëssen huet oder an deem Dir am léifste schaffe wëllt.',
	'requestaccount-ext-text' => "Dës Informatioune gi vertraulech behandelt a gi just fir dës Ufro benotzt.
Dir kënnt Kontaktinformatiounen wéi eng Telefonsnummer uginn fir d'Identitéitskonfirmatioun ze vereinfachen.",
	'requestaccount-bio-text' => 'Är Biographie gëtt als initiale Contenu vun denger Benotzersäit gespäichert.
Versicht all néideg Recommandatiounnen unzeginn.
Vergewëssert iech, ob Dir déi Informatiounen och wierklech verëffentleche wëllt.
Ären Numm kann op [[Special:Preferences|meng Astellunge]] geännert ginn.',
	'requestaccount-real' => 'Richtegen Numm:',
	'requestaccount-same' => "(d'selwecht wéi de richtegen Numm)",
	'requestaccount-email' => 'E-mail-Adress:',
	'requestaccount-reqtype' => 'Positioun:',
	'requestaccount-level-0' => 'Auteur',
	'requestaccount-level-1' => 'Editeur',
	'requestaccount-bio' => 'Peréinlech Biographie:',
	'requestaccount-attach' => 'Liewenslaf oder CV (optional):',
	'requestaccount-notes' => 'Zousätzlech Bemierkungen:',
	'requestaccount-urls' => 'Lëscht vu Websäiten (all Säit an enger neier Zeil)',
	'requestaccount-agree' => "Dir musst confirméieren datt är E-Mailadress richteg ass and datt dir mat den Allgemenge Konditiounen d'Accord sitt.",
	'requestaccount-inuse' => 'De Benotzernumm ass scho bei enger anerer Benotzerufro a Gebrauch.',
	'requestaccount-tooshort' => 'Är Biographie muss mindestens $1 {{PLURAL:$1|Wuert|Wierder}} hunn.',
	'requestaccount-emaildup' => 'En anere Benotzerkont deen ugefrot gouf benotzt déi selwecht E-Mailadress.',
	'requestaccount-exts' => "De Fichierstyp vum ''Attachment'' ass net erlaabt.",
	'requestaccount-resub' => "De Fichier mat ärem CV muss aus Sécherheetsgrënn nachemol nei erausgesicht ginn.
Loosst d'Feld eidel wann Dir elo keen CV abanne wëllt.",
	'requestaccount-tos' => 'Ech hunn d\'[[{{MediaWiki:Requestaccount-page}}|Benotzungsbedingunge]] vu(n) {{SITENAME}} gelies an akzeptzéieren se.
Den Numm den ech bäi "Richtegen Numm" uginn hunn, ass mäin eegene richtegen Numm.',
	'requestaccount-submit' => 'Benotzerkont ufroen',
	'requestaccount-sent' => 'Är Ufro fir e Benotzerkont gouf fortgeschéckt a muss elo nach akzeptéiert ginn.
Eng Konfirmatiounsmail gouf op Är E-mailadress geschéckt.',
	'request-account-econf' => 'Är E-Mailadress gouf confirméiert a gëtt elo als E-Mailadress an är Ufro fir e Benotzerkont integréiert.',
	'requestaccount-email-subj' => '{{SITENAME}} Konfirmatioun vun der E-Mail-Adress',
	'requestaccount-email-body' => 'Een, wahrscheinlech Dir vun der IP-Adress $1, huet e Benotzerkont "$2" mat dëser E-Mailadress op {{SITENAME}} ugefrot.

Fir ze confirméieren datt dëse Benotzerkont op {{SITENAME}} Iech wierklech gehéiert, klickt w.e.g. op dëse Link an Ärem Browser:

$3

Wann De Benotzerkont ugeluecht ass, kritt Dir eleng d\'Passwuert per E-Mail geschéckt.
Wann Dir et *net" sidd, da klickt net op de Link.
Dës Confirmatioun ass just valabel bis $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} Ufro fir ee Benotzerkont',
	'requestaccount-email-body-admin' => '"$1" huet e Benotzerkont ugefrot a waart op eng Confirmatioun.
D\'E-mailadresse ass confirméiert. Dir kënnt déi Ufro hei "$2" confirméieren.',
	'acct_request_throttle_hit' => 'Pardon, Dir hutt schonns {{PLURAL:$1|1Benotzerkont|$1 Benotzerkonten}} ugefrot.
Dir kënnt elo keng weider Ufroe méi maachen.',
	'requestaccount-loginnotice' => "Fir e Benotzerkont ze kréien, musst Dir '''[[Special:RequestAccount|een ufroen]]'''.",
	'confirmaccount-newrequests' => "'''$1''' open, per E-Mail confirméiert, [[Special:ConfirmAccounts|account {{PLURAL:$1|Ufro|Ufroen}}]] déi drop {{PLURAL:$1|waart|waarden}} beäntwert ze ginn.",
	'confirmaccounts' => 'Ufroe vu Benotzerkonte confirméieren',
	'confirmedit-desc' => "Gëtt Bürokraten d'Méiglechkeet fir Ufroe vu Benotzerkonten ze confirméieren",
	'confirmaccount-list' => "Hei ass d'Lëscht vun den Ufroe fir e Benotzerkont déi nach autoriséiert musse ginn.
Wann eng Ufro entweder autoriséiert oder refuséiert ass gëtt se vun der Lëscht erofgeholl.",
	'confirmaccount-list2' => 'Hei ënnendrënner ass eng Lëscht vun de Benotzerkontenufroen déi voru kuerzem ofgelehnt goufen an déi esoubal wéi se e puer Deeg al sinn automatesch geläscht kënne ginn.
Se kënnen nach ëmmer als Benotzerkonten approuvéiert ginn, eventuell kënnt Dir den Administrateur den Ufro ofgelehnt huet consultéieren ier Dir dat maacht.',
	'confirmaccount-list3' => 'Hei ënnendrënner ass eng Lëscht vun ofgelafenen Ufroe fir Benotzerkonten déi bannert e puer Deeg automatesch geläscht ginn.
Si kënnen nach als Benotzerkonten akzeptéiert ginn.',
	'confirmaccount-none-o' => 'Et gëtt elo an dëser Lëscht keng oppen Ufroe fir Benotzerkonten.',
	'confirmaccount-none-h' => 'Et gëtt elo an dëser Lëscht keng Ufroe fir Benotzerkonten déi am Suspens sinn.',
	'confirmaccount-none-r' => 'Et gëtt elo keng rezent refüséiert Ufroe fir Benotzerkonten op dëser Lëscht.',
	'confirmaccount-none-e' => 'Et sinn elo keng ofgelafen Ufroe fir Benotzerkonten an dëser Lëscht.',
	'confirmaccount-real-q' => 'Numm',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biographie',
	'confirmaccount-showopen' => 'Ufroen déi nach opstinn',
	'confirmaccount-showrej' => 'Refuséiert Ufroen',
	'confirmaccount-showheld' => "Ufroen déi 'en-cours' sinn",
	'confirmaccount-showexp' => 'ofgelafen Ufroen',
	'confirmaccount-review' => 'Konfirméieren/Refüséieren',
	'confirmaccount-types' => 'Sicht eng Waardelëscht vun de Benotzerkonteconfirmatiounen hei ënnendrënner eraus:',
	'confirmaccount-all' => '(all Queue weisen)',
	'confirmaccount-type' => 'Queue:',
	'confirmaccount-type-0' => 'eventuell Auteuren',
	'confirmaccount-type-1' => 'eventuell Auteuren',
	'confirmaccount-q-open' => 'Ufroen déi nach opstinn',
	'confirmaccount-q-held' => "Ufroen déi 'en-cours' sinn",
	'confirmaccount-q-rej' => 'rezent refuséiert Ufroen',
	'confirmaccount-q-stale' => 'ofgelafen Ufroen',
	'confirmaccount-badid' => 'Et gëtt keng oppe Benotzerufro mat der ID déi dir uginn hutt.
Se gouf eventuell scho behandelt.',
	'confirmaccount-leg-user' => 'Benotzerkont',
	'confirmaccount-leg-areas' => 'Haaptinteressen',
	'confirmaccount-leg-person' => 'Perséinlech Informatiounen',
	'confirmaccount-leg-other' => 'Aner Informatioun',
	'confirmaccount-name' => 'Benotzernumm',
	'confirmaccount-real' => 'Numm:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Positioun:',
	'confirmaccount-pos-0' => 'Auteur',
	'confirmaccount-pos-1' => 'Editeur',
	'confirmaccount-bio' => 'Biographie:',
	'confirmaccount-attach' => 'Liewenslaf:',
	'confirmaccount-notes' => 'Zousätzlech Bemierkungen:',
	'confirmaccount-urls' => 'Lëscht vu Websäiten:',
	'confirmaccount-none-p' => '(net uginn)',
	'confirmaccount-confirm' => "Benotzt d'Optiounen ënnendrënner fir dës Ufro unzehuelen, ze refuséien oder op 'en-cours' ze setzen:",
	'confirmaccount-econf' => '(confirméiert)',
	'confirmaccount-reject' => '(refuséiert vum [[User:$1|$1]] de(n) $2)',
	'confirmaccount-rational' => 'Ursaach fir deen deen ugefrot huet:',
	'confirmaccount-noreason' => '(keen)',
	'confirmaccount-autorej' => '(dës Ufro gouf automatesch wéint Inaktivitéit klasséiert)',
	'confirmaccount-held' => '(als "amgaang" vum [[User:$1|Benotzer $1]] den $2 markéiert)',
	'confirmaccount-create' => 'Unhuelen (Benotzerkont opmaachen)',
	'confirmaccount-deny' => 'Refuséieren (Benotzerkont gëtt geläscht)',
	'confirmaccount-hold' => 'Ofwaarden',
	'confirmaccount-spam' => 'Spam (E-Mail net schécken)',
	'confirmaccount-reason' => "Bemierkung (gëtt an d'E-Mail derbäigesat):",
	'confirmaccount-ip' => 'IP-Adress:',
	'confirmaccount-legend' => 'Dëse Kont confirméieren/refüséieren',
	'confirmaccount-submit' => 'Confirméieren',
	'confirmaccount-needreason' => 'Dir musst e Grond an der Kescht ënnendrënner uginn.',
	'confirmaccount-canthold' => "Dës Ufro ass schonn entweder 'en-cours' oder geläscht.",
	'confirmaccount-acc' => 'Benotzerkont-Ufro gouf confirméiert;
de Benotzerkont [[User:$1|$1]] gouf ugeluecht.',
	'confirmaccount-rej' => "D'Ufro fir ee Benotzerkont gouf refuséiert.",
	'confirmaccount-viewing' => '(gëtt elo gekuckt vum [[User:$1|$1]])',
	'confirmaccount-summary' => "D'Benotzersäit mat der Biographie vum neie Benotzer gëtt elo gemaach.",
	'confirmaccount-welc' => "'''Wëllkomm op ''{{SITENAME}}''!'''
Dir wëllt wahrscheinlech d'[[{{MediaWiki:Helppage}}|Hellëfsäite]] liesen.
Nachemol, wëllkom a vill Spaass!",
	'confirmaccount-wsum' => 'Wëllkomm!',
	'confirmaccount-email-subj' => '{{SITENAME}} Ufro fir ee Benotzerkont',
	'confirmaccount-email-body' => 'Är Ufro fir e Benotzerkont op {{SITENAME}} gouf ugeholl.

Numm vum Benotzerkont: $1

Passwuert: $2

Aus Sécherheetsgrënn musst Dir Ärt Passwuert ännere wann Dir Iech déi éischt Kéier aloggt.
Fir Iech anzelogge gitt w.e.g. op {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Är Ufro fir e Benotzerkont op {{SITENAME}} gouf ugeholl.

Numm vum Benotzerkont: $1

Passwuert: $2

$3

Aus Sécherheetsgrënn musst Dir Ärt Passwuert ännere wann Dir Iech déi éischt Kéier aloggt.
Fir Iech anzelogge gitt w.e.g. op {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Pardon, Är Ufro fir e Benotzerkont "$1" op {{SITENAME}} gouf refuséiert.

Dëst ka verschidden Ursaachen hunn.
Et ka sinn datt dir de Formulaire net richteg ausgefëllt hutt, net genuch an Ären Äntwerten uginn hutt, oder op eng aner Manéier d\'Critère vun de Benotzerrichtinnen net erfëllt hutt.
EVentuell gëtt et Kontaklëschten um Site déi Dir benotze kënnt fir méi iwwer d\'Benotzerrichtlinnen gewuer ze ginn.',
	'confirmaccount-email-body4' => 'Pardon, Är Ufro fir e Benotzerkont "$1" gouf op {{SITENAME}} ofgelehnt.

$2

Eventuell fannt Dir eng Kontaktlëscht déi dir benotze kënnt wann dir méi iwwert d\'Benotzerrichtlinne wësse wëllt.',
	'confirmaccount-email-body5' => 'Éier Är Ufro fir e Benotzerkont "$1" kann op {{SITENAME}} ugeholl musst Dir d\'éischt epuer zousätzech Informatiounen uginn.

$2

Méiglecherweis gëtt et Kontaktlëschten op dem Site déi Dir benotze kënnt wann Dir méi iwwert d\'richlinnen vun de Benotzerkonte wësse wëllt.',
	'usercredentials' => 'Referenzen déi de Benotzer uginn huet:',
	'usercredentials-leg' => 'Confirméiert Referenze vun engem Benotzer nokucken',
	'usercredentials-user' => 'Benotzernumm:',
	'usercredentials-text' => 'Hei ënnedrënner stinn déi confirméiert Benotzer-Berechtigungsnoweiser fir de gewielte Benotzerkont.',
	'usercredentials-leg-user' => 'Benotzerkont',
	'usercredentials-leg-areas' => 'Haaptinteressen',
	'usercredentials-leg-person' => 'Perséinlech Informatiounen',
	'usercredentials-leg-other' => 'Aner Informatiounen',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Richtegen Numm:',
	'usercredentials-bio' => 'Biographie:',
	'usercredentials-attach' => 'Liewenslaf:',
	'usercredentials-notes' => 'Zousätzlech Bemierkungen:',
	'usercredentials-urls' => 'Lëscht vun Internetsiten:',
	'usercredentials-ip' => 'Original IP-Adress:',
	'usercredentials-member' => 'Rechter:',
	'usercredentials-badid' => 'Et goufe keng Rechter fir dëse Benotzer fonnt.
Kuckt w.e.g. no op den Numm richteg geschriwwen ass.',
	'right-confirmaccount' => "D'[[Special:ConfirmAccounts|Queue mat den ugefrote Benotzerkonte]] kucken",
	'right-requestips' => "D'IP-Adress vun däer d'Ufro koum uweise wann d'Ufro fir e Benotzerkont verschafft gëtt",
	'right-lookupcredentials' => '[[Special:UserCredentials|Referenze vun de Benotzer]] kucken',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Pahles
 */
$messages['li'] = array(
	'requestaccount' => 'Gebroekersaccount aanvraoge',
	'requestaccount-text' => "'''Vul 't ongerstaand formeleer in en sjik 't op om 'n gebroekersaccount aan te vraoge'''.  

Zörg deveur dats doe iers de [[{{MediaWiki:Requestaccount-page}}|veurwaarde]] laes ierdets doe 'n gebroekersaccount aanvraogs.

Es diene aanvraog is goodgekäörd, kriegs doe 'ne e-mail en daonao kans doe diech [[Special:UserLogin|aanmelje]].",
	'requestaccount-page' => '{{ns:project}}:Veurwaerde',
	'requestaccount-dup' => "'''Lèt op: doe bis al aangemeld mit 'ne geregistreerde gebroekersnaam.'''",
	'requestaccount-leg-user' => 'Gebroeker',
	'requestaccount-leg-areas' => 'Interessegebede',
	'requestaccount-leg-person' => 'Persuunlike infermasie',
	'requestaccount-leg-other' => 'Euverige infermasie',
	'requestaccount-leg-tos' => 'Gebroeksveurwaerde',
	'requestaccount-acc-text' => "Doe kriegs 'n e-mailbevestiging es dien verzeuk is óntvange.
Reageer dao-op door te klikke op de verwiezing die in de e-mail sjteit.
Doe kriegs 'n wachwoord es dien gebroekersaccount is aangemaak.",
	'requestaccount-areas-text' => "Selecteer hiejonger de óngerwerpe woemits doe ervaring höbs of woevans doe 't mieste wirk wils verrichte.",
	'requestaccount-ext-text' => "De volgende infermasie weurt vertroewelik behanjeld en weurt allein gebroek veur dit verzeuk.  
Doe kans kontakgegaevens zoewie 'n tillefoonnómmer opgaeve om te helpe bie 't vastsjtèlle van dien identiteit.",
	'requestaccount-bio-text' => "Dien biografie weurt opgenóme in dien gebroekerspagina.
Perbeer dien belangriekste gegaeves op te numme.
Zörg deveur dats doe achter 't publicere van dergelike infermatse sjteis.
Doe kans diene naam aanpasse via dien [[Special:Preferences|veurkaöre]].",
	'requestaccount-real' => 'Diene echte naam:',
	'requestaccount-same' => '(geliek aan diene echte naam)',
	'requestaccount-email' => 'E-mailadres:',
	'requestaccount-reqtype' => 'Positie',
	'requestaccount-level-0' => 'auteur',
	'requestaccount-level-1' => 'redacteur',
	'requestaccount-bio' => 'Persuunlike biografie:',
	'requestaccount-attach' => 'CV (optioneel):',
	'requestaccount-notes' => 'Opmerkinge:',
	'requestaccount-urls' => "Lies van websites, es van toepassing (jeder site op 'ne aafzunjerlike regel):",
	'requestaccount-submit' => 'Gebroekersnaam aanvraoge',
	'requestaccount-email-subj-admin' => '{{SITENAME}} gebroekersaanvraoge',
	'confirmaccount-real-q' => 'Naam',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showopen' => 'ope aanvraoge',
	'confirmaccount-showrej' => 'verworpe aanvraoge',
	'confirmaccount-showheld' => 'aangehauwe aanvraoge',
	'confirmaccount-showexp' => 'vervalle aanvraoge',
	'confirmaccount-review' => 'toegelaote/aafgeweze',
	'confirmaccount-types' => "Selecteer 'n lies mit gebroekersverzeuke:",
	'confirmaccount-all' => '(alle lieste weergaeve)',
	'confirmaccount-type' => 'Lies:',
	'confirmaccount-type-0' => 'toekómstige outäörs',
	'confirmaccount-type-1' => 'toekómstige riddektäöre',
	'confirmaccount-q-open' => 'ope aanvraoge',
	'confirmaccount-q-held' => 'aangehauwe aanvraoge',
	'confirmaccount-q-rej' => 'recènt aafgeweze aanvraoge',
	'confirmaccount-q-stale' => 'vervalle aanvraoge',
	'confirmaccount-leg-user' => 'Gebroekersaccount',
	'confirmaccount-leg-areas' => 'Interessegebede',
	'confirmaccount-leg-person' => 'Persuunlike infermasie',
	'confirmaccount-leg-other' => 'Euverige infermasie',
	'confirmaccount-name' => 'Gebroekersnaam',
	'confirmaccount-real' => 'Naam:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Pezisie:',
	'confirmaccount-pos-0' => 'outäör',
	'confirmaccount-pos-1' => 'riddektäör',
	'confirmaccount-bio' => 'Biografie:',
	'confirmaccount-attach' => 'CV:',
	'confirmaccount-notes' => 'Opmirkinge:',
	'confirmaccount-urls' => 'Lies mit websites:',
	'confirmaccount-none-p' => '(neet opgegaeve)',
	'confirmaccount-econf' => '(gekónfermeerd)',
	'confirmaccount-reject' => '(aafgeweze door [[User:$1|$1]] op $2)',
	'confirmaccount-rational' => 'Aan de aanvraoger opgegaeve raej:',
	'confirmaccount-noreason' => '(gein)',
	'confirmaccount-autorej' => '(deze aanvraog is otomatisch aafgebroke waeges inactiviteit)',
	'confirmaccount-held' => '("aangehauwe" door [[User:$1|$1]] op $2)',
	'confirmaccount-create' => 'Toelaote (gebroeker aanmake)',
	'confirmaccount-deny' => 'Aafwieze (ewegsjaffe)',
	'confirmaccount-hold' => 'Aanhauwe',
	'confirmaccount-spam' => 'Spam (geine e-mail sjikke)',
	'confirmaccount-reason' => 'Opmirking (weurt toegeveug aan de e-mail)',
	'confirmaccount-ip' => 'IP-adres:',
	'confirmaccount-submit' => 'Kónfermere',
	'usercredentials' => 'Rifferenties van gebroeker',
	'usercredentials-leg' => 'Betrach gekónfermeerde rifferenties veur gebroeker',
	'usercredentials-user' => 'Gebroekersnaam:',
	'usercredentials-text' => 'Euverzich van de gekónfermeerde rifferenties veur de geselecteerde gebroeker:',
	'usercredentials-leg-user' => 'Gebroekersaccount',
	'usercredentials-leg-areas' => 'Interessegebede',
	'usercredentials-leg-person' => 'Persuunlike infermasie',
	'usercredentials-leg-other' => 'Euverige infermasie',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Echte naam:',
	'usercredentials-bio' => 'Biografie:',
	'usercredentials-attach' => 'CV:',
	'usercredentials-notes' => 'Euverige opmirkinge:',
	'usercredentials-urls' => 'Lies van websites:',
	'usercredentials-ip' => 'Oersjprunkelik IP-adres:',
	'usercredentials-member' => 'Rechte:',
);

/** Lithuanian (Lietuvių)
 * @author Homo
 * @author Tomasdd
 */
$messages['lt'] = array(
	'requestaccount-leg-user' => 'Naudotojo paskyra',
	'requestaccount-leg-person' => 'Asmeninė informacija',
	'requestaccount-leg-other' => 'Kita informacija',
	'confirmaccount-real-q' => 'Vardas',
	'confirmaccount-real' => 'Vardas:',
	'confirmaccount-ip' => 'IP adresas:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'confirmaccount-email-q' => 'Электрон почто',
	'confirmaccount-name' => 'Пайдаланышын лӱмжӧ',
	'confirmaccount-email' => 'Электрон почто:',
	'usercredentials-user' => 'Пайдаланышын лӱмжӧ:',
	'usercredentials-email' => 'Электрон почто:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'requestaccount' => 'Пријава за сметка',
	'requestaccount-text' => "''Пополнете го и поднесете го следниов образец за да побарате корисничка сметка'''.

Најпрвин прочитајте ги [[{{MediaWiki:Requestaccount-page}}|Условите на користење]] пред да побарате сметка.

Штом ќе ви биде одобрена сметката, ќе ви биде испратено известување по е-пошта и тогаш ќе можете да [[Special:UserLogin|се најавите]] и да ја користите.",
	'requestaccount-page' => '{{ns:project}}:Услови на употреба',
	'requestaccount-dup' => "'''Белешка: Веќе се најавени со регистрирана сметка.'''",
	'requestaccount-leg-user' => 'Корисничка сметка',
	'requestaccount-leg-areas' => 'Главно се интересира за',
	'requestaccount-leg-person' => 'Лични информации',
	'requestaccount-leg-other' => 'Други информации',
	'requestaccount-leg-tos' => 'Услови на употреба',
	'requestaccount-acc-text' => 'Откога ќе го поднесете бараето, ќе добиете потврдна порака по е-пошта.
Одговорете со тоа што ќе кликнете на потврдната врска во пораката.
Со создавање на сметката ќе ви биде испратена и вашата лозинка.',
	'requestaccount-areas-text' => 'Подолу изберете ги тематските области во кои сте стручни, или на кои би сакале највеќе да работите.',
	'requestaccount-ext-text' => 'Следните информации се држат во приватност и ќе се користат само на ваше барање.
Препорачуваме да наведете контакти како телефонски број за полесно потврдување на идентитетот.',
	'requestaccount-bio-text' => 'Вашата биографија по основно ќе биде поставена како содржина на вашата корисничка страница.
По можност вклучете и препораки.
Уверете се дека немате против објавување на вакви информации.
Името можете да си го промените преку [[Special:Preferences|вашите нагодувања]].',
	'requestaccount-real' => 'Вистинско име:',
	'requestaccount-same' => '(исто како вистинско име)',
	'requestaccount-email' => 'Е-поштенска адреса:',
	'requestaccount-reqtype' => 'Позиција:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'уредувач',
	'requestaccount-bio' => 'Лична биографија:',
	'requestaccount-attach' => 'Резиме или CV (не е задолжително):',
	'requestaccount-notes' => 'Други забелешки:',
	'requestaccount-urls' => 'Листа на веб-страници, ако ги има (се пишуваат во посебен ред):',
	'requestaccount-agree' => 'Морате да потврдите дека вашето вистинско име е точно и дека се согласувате со нашите Услови на употреба.',
	'requestaccount-inuse' => 'Тоа корисничко име е веќе искористено во друга пријава и чека одобрение.',
	'requestaccount-tooshort' => 'Вашата биографија мора да содржи најмалку $1 {{PLURAL:$1|збор|зборови}}.',
	'requestaccount-emaildup' => 'Истата адреса ја користи друга пријава на сметка во исчекување.',
	'requestaccount-exts' => 'Прикачувањето на податотеки од тој формат не е дозволено.',
	'requestaccount-resub' => 'Податотеката со вашето CV/резиме мора да се преизбере од безбедносни причини.
Оставете го полето празно ако повеќе не сакате да поставите разиме.',
	'requestaccount-tos' => 'Ги прочитав, и се согласувам да ги почитувам [[{{MediaWiki:Requestaccount-page}}|Условите на користење]] на {{SITENAME}}.
Името кое го назначив како „Вистинско име“ е навистина моето име и презиме.',
	'requestaccount-submit' => 'Барање за сметка',
	'requestaccount-sent' => 'Вашето барање за сметка е успешно испратено и чека решение.
Ви испративме потврдна порака по е-пошта.',
	'request-account-econf' => 'Вашата е-поштенска адреса е потврдена и ќе биде наведена како таква во вашето барање за сметка.',
	'requestaccount-email-subj' => '{{SITENAME}}: потврдување на е-пошта',
	'requestaccount-email-body' => 'Некој, веројатно вие од IP адресата $1, побарал сметка „$2“ со оваа е-поштенска адреса на {{SITENAME}}.

За да потврдите дека оваа сметка навистина ви припаѓа вам на {{SITENAME}}, отворете ја врскава во прелистувачот:

$3

Ако сметката е создадена, само вие ќе ја добиете лозинката по е-пошта.
Доколку ова *не* сте вие, не одете на врската.
Овој потврден код истекува во $4.',
	'requestaccount-email-subj-admin' => 'Барање за сметка на {{SITENAME}}',
	'requestaccount-email-body-admin' => '„$1“ побара сметка и чека потврда.
Е-поштенската адреса е потврдена. Можете да го потврдите барањето тука „$2“.',
	'acct_request_throttle_hit' => 'Жалам, но веќе имате побарано {{PLURAL:$1|1 сметка|$1 сметки}}.
Не можете да поставувате повеќе барања.',
	'requestaccount-loginnotice' => "За да добиете корисничка сметка, морате да '''[[Special:RequestAccount|поднесете барање]]'''.",
	'confirmaccount-newrequests' => "'''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|отворено барање за сметка|отворени барања за сметка}}]] во исчекување со потврдена е-пошта",
	'confirmaccounts' => 'Потврдување на барања за сметки',
	'confirmedit-desc' => 'Им овозможува на бирократите да потврдуваат барања за сметка',
	'confirmaccount-maintext' => "'''Оваа страница служи за потврдување на барања за сметки на „{{SITENAME}}'''.

Секојa редica на барања за сметки се состои од три подредици.
Една за отворено барање, една за оние ставени на чекање од други администратори заради потреба од повеќе информации, и трета за неодамна одбиени барања.

Кога одговарате на барање, прегледајте го и оценете го внимателно, и по потреба, проверете ги наведените информациите.
Вашите постапки ќе бидат приватно заведени.
Од вас се очекува и да ги прегледувате сите дејствија што се случуваат овде покрај она што го правите вие самите.",
	'confirmaccount-list' => 'Подолу е наведена листа на барања за сметка во исчекување на одобрение.
Штом ќе се одобри или одбие едно барање, истото ќе биде отстрането од листата.',
	'confirmaccount-list2' => 'Подолу е наведена листа на неодамна одбиени барања за сметка, кои може автоматски да бидат избришани по неколку дена.
Тие сепак можат да се одобрат и да се создадат сметки, иако пред ова да го направите, препорачуваме прво да го консултирате администраторот кој го одбил барањето.',
	'confirmaccount-list3' => 'Подолу е наведена листа на истечени барања за сметка кои може да се избришат автоматски за неколку дена.
Тие сепак можат да се потврдат и да се создадат сметки.',
	'confirmaccount-text' => "Ова е барање за корисничка сметка на '''{{SITENAME}}''' во исчекување.

Внимателно прегледајте ги информациите подолу.
Ако решивте да го одобрите барањето, поставете го статусот на корисникот од паѓачкиот список.
Измените во биографијата нема да влијаат врз постојаните складирани акредитиви.
Можете да ја создадете сметката со поинакво корисничко име.
Ова користете го само кога некое име се коси со некое друго постоечко име.

Ако ја напуштите страницава без да го одобрите или одбиете барањето, тоа ќе си остане во исчекување.",
	'confirmaccount-none-o' => 'Моментално на листата нема отворени барања за сметка во исчекување.',
	'confirmaccount-none-h' => 'Моментално на листата нема задржани барања за сметка во исчекување.',
	'confirmaccount-none-r' => 'Моментално нема неодамна одбиени барања за сметка на листата.',
	'confirmaccount-none-e' => 'Моментално нема истечени барања за сметки на листата.',
	'confirmaccount-real-q' => 'Име',
	'confirmaccount-email-q' => 'Е-пошта',
	'confirmaccount-bio-q' => 'Биографија',
	'confirmaccount-showopen' => 'отворени барања',
	'confirmaccount-showrej' => 'одбиени барања',
	'confirmaccount-showheld' => 'задржани барања',
	'confirmaccount-showexp' => 'истечени барања',
	'confirmaccount-review' => 'Прегледај',
	'confirmaccount-types' => 'Одберете редица на чекање за потврда на сметка подолу:',
	'confirmaccount-all' => '(покажи ги сите редици)',
	'confirmaccount-type' => 'Редица:',
	'confirmaccount-type-0' => 'идни автори',
	'confirmaccount-type-1' => 'идни уредници',
	'confirmaccount-q-open' => 'отворени барања',
	'confirmaccount-q-held' => 'задржани барања',
	'confirmaccount-q-rej' => 'неодамна одбиени барања',
	'confirmaccount-q-stale' => 'истечени барања',
	'confirmaccount-badid' => 'Не постои барање во исчекување кое соодветствува на наведениот ид. број.
Можно е барањето веќе да е обработено.',
	'confirmaccount-leg-user' => 'Корисничка сметка',
	'confirmaccount-leg-areas' => 'Главни полиња на интерес',
	'confirmaccount-leg-person' => 'Персонални информации',
	'confirmaccount-leg-other' => 'Други информации',
	'confirmaccount-name' => 'Корисничко име',
	'confirmaccount-real' => 'Име:',
	'confirmaccount-email' => 'Е-пошта:',
	'confirmaccount-reqtype' => 'Позиција:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-pos-1' => 'уредувач',
	'confirmaccount-bio' => 'Биографија:',
	'confirmaccount-attach' => 'Резиме/CV:',
	'confirmaccount-notes' => 'Дополнителни белешки:',
	'confirmaccount-urls' => 'Листа на веб места:',
	'confirmaccount-none-p' => '(не е наведено)',
	'confirmaccount-confirm' => 'Користете ги нагодувањата подолу за да го прифатите, одбиете или задржите ова барање:',
	'confirmaccount-econf' => '(потврдено)',
	'confirmaccount-reject' => '(одбиено од [[User:$1|$1]] на $2)',
	'confirmaccount-rational' => 'Објаснение за барателот:',
	'confirmaccount-noreason' => '(нема)',
	'confirmaccount-autorej' => '(ова барање е автоматски отфрлено поради неактивност)',
	'confirmaccount-held' => '(обележано како „на чекање“ од [[User:$1|$1]] на $2)',
	'confirmaccount-create' => 'Прифати (создај сметка)',
	'confirmaccount-deny' => 'Одбиј (отстрани од листата)',
	'confirmaccount-hold' => 'На чекање',
	'confirmaccount-spam' => 'Спам (не го испраќајте писмото)',
	'confirmaccount-reason' => 'Коментар (ќе биде вклучен во е-поштата):',
	'confirmaccount-ip' => 'IP адреса:',
	'confirmaccount-legend' => 'Прифати/одбиј ја оваа корисничка сметка',
	'confirmaccount-submit' => 'Потврди',
	'confirmaccount-needreason' => 'Морате да наведете причина во полето за коментар подолу.',
	'confirmaccount-canthold' => 'Ова барање е веќе во задршка или е избришано.',
	'confirmaccount-acc' => 'Барањето за сметка е успешно потврдено;
создадена е нова сметка [[User:$1|$1]].',
	'confirmaccount-rej' => 'Барањето за сметка е успешно одбиено.',
	'confirmaccount-viewing' => '(во моментов ја гледа корисникот [[User:$1|$1]])',
	'confirmaccount-summary' => 'Создавање на корисничка страница со биографија на новиот корисник.',
	'confirmaccount-welc' => "'''Добредојдовте на ''{{SITENAME}}''!'''
Се надеваме дека ќе придонесувате многу и квалитетно.
Препорачуваме да ги прочитате [[{{MediaWiki:Helppage}}|страниците за помош]].
Уште еднаш, добредојдовте и пријатен провод!",
	'confirmaccount-wsum' => 'Добредојдовте!',
	'confirmaccount-email-subj' => 'Барање за сметка на {{SITENAME}}',
	'confirmaccount-email-body' => 'Вашето барање за сметка на {{SITENAME}} е одобрено.

Корисничко име: $1

Лозинка: $2

Од безбедносни причини ќе треба да си ја смените лозинката при првото најавување.
Најавете се на {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Вашето барање за сметка на {{SITENAME}} е одобрено.

Назив на сметката: $1

Лозинка: $2

$3

Од безбедносни причини треба да си ја промените лозинката при првото најавување.
За да се најавите, одете на {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Жалиме, но вашето барање за сметка „$1“ на {{SITENAME}} е одбиено.

Ова може да се должи на неколку причини.
Може да несте го пополниле образецот правилно, одговорите ви биле прекратки, или пак не задоволувате некој друг критериум.
На страницата може да има контактни листи кои можете да ги користите ако сакате да дознаете повеќе за правилата за сметки.',
	'confirmaccount-email-body4' => 'Жалиме, но вашето барање за сметка „$1“ на {{SITENAME}} беше одбиено.

$2

На страницата може да има контактни листи кои можете да ги користите ако сакате да дознаете повеќе за правилата за сметки.',
	'confirmaccount-email-body5' => 'Пред да можеме да го прифатиме вашето барање за сметка „$1“ на {{SITENAME}} морате да ни дадете извесни дополнителни иформации.

$2

На страницата може да има контактни листи кои можете да ги користите ако сакате да дознаете повеќе за правилата за сметки.',
	'usercredentials' => 'Препораки за корисник',
	'usercredentials-leg' => 'Проверете ги потврдените препораки за некој корисник',
	'usercredentials-user' => 'Корисничко име:',
	'usercredentials-text' => 'Подолу се прикажани потврдените препораки за избраната корисничка сметка.',
	'usercredentials-leg-user' => 'Корисничка сметка',
	'usercredentials-leg-areas' => 'Главни полиња на интерес',
	'usercredentials-leg-person' => 'Лични информации',
	'usercredentials-leg-other' => 'Други информации',
	'usercredentials-email' => 'Е-пошта:',
	'usercredentials-real' => 'Вистинско име:',
	'usercredentials-bio' => 'Биографија:',
	'usercredentials-attach' => 'Резиме/CV:',
	'usercredentials-notes' => 'Дополнителни забелешки:',
	'usercredentials-urls' => 'Листа на веб-страници:',
	'usercredentials-ip' => 'Изворна IP-адреса',
	'usercredentials-member' => 'Права:',
	'usercredentials-badid' => 'Нема пронајдено препораки за овој корисник.
Проверете дали името е правилно напишано.',
	'right-confirmaccount' => 'Погледајте ја [[Special:ConfirmAccounts|редицата со барани сметки]]',
	'right-requestips' => 'Погледајте ги IP-адресите на барателот додека обработувате барани сметки',
	'right-lookupcredentials' => 'Погледајте ги [[Special:UserCredentials|препораките за корисникот]]',
);

/** Malayalam (മലയാളം)
 * @author Jacob.jose
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'requestaccount' => 'അംഗത്വത്തിനായി അഭ്യര്‍ത്ഥിക്കുക',
	'requestaccount-page' => '{{ns:project}}:സേവനത്തിന്റെ നിബന്ധനകള്‍',
	'requestaccount-dup' => "'''കുറിപ്പ്: താങ്കള്‍ ഒരു രെജിസ്റ്റേര്‍ഡ് അംഗത്വം ഉപയോഗിച്ച് ഇതിനകം ലോഗിന്‍ ചെയ്തിട്ടുണ്ട്.'''",
	'requestaccount-leg-user' => 'ഉപയോക്തൃഅംഗത്വം',
	'requestaccount-leg-areas' => 'താല്പര്യമുള്ള പ്രധാന മേഖലകള്‍',
	'requestaccount-leg-person' => 'വ്യക്തിഗത വിവരങ്ങള്‍',
	'requestaccount-leg-other' => 'മറ്റ് വിവരങ്ങള്‍',
	'requestaccount-acc-text' => 'ഈ അഭ്യര്‍ത്ഥന സമര്‍പ്പിക്കപ്പെട്ടതിനു ശേഷം താങ്കളുടെ ഇമെയില്‍ വിലാസത്തിലേക്ക് ഒരു സ്ഥിരീകരണമെയില്‍ അയക്കുന്നതായിരിക്കും. പ്രസ്തുത ഇമെയിലിലുള്ള സ്ഥിരീകരണലിങ്കില്‍ ഞെക്കി പ്രതികരിക്കുക. അംഗത്വം സൃഷ്ടിക്കപ്പെട്ടതിനു ശേഷം താങ്കളുടെ രഹസ്യവാക്കും ഇമെയിലില്‍ അയക്കുന്നതായിരിക്കും.',
	'requestaccount-real' => 'യഥാര്‍ത്ഥ പേര്:',
	'requestaccount-same' => '(യഥാര്‍ത്ഥ പേരുതന്നെ)',
	'requestaccount-email' => 'ഇമെയില്‍ വിലാസം:',
	'requestaccount-reqtype' => 'സ്ഥാനം:',
	'requestaccount-level-0' => 'ലേഖകന്‍',
	'requestaccount-level-1' => 'എഡിറ്റര്‍',
	'requestaccount-bio' => 'വ്യക്തിഗത വിവരങ്ങള്‍:',
	'requestaccount-attach' => 'റെസ്യൂം അല്ലെങ്കില്‍ സിവി (ഓപ്ഷണല്‍):',
	'requestaccount-notes' => 'കൂടുതല്‍ കുറിപ്പുകള്‍:',
	'requestaccount-urls' => 'വെബ്ബ്സൈറ്റുകളുടെ പട്ടിക (ഓരോന്നും വെവ്വേറെ വരിയില്‍ കൊടുക്കുക):',
	'requestaccount-agree' => 'താങ്കളുടെ പേരു യഥാര്‍ത്ഥമാണെന്നും, താങ്കള്‍ ഞങ്ങളുടെ നയങ്ങളും പരിപാടികളും അംഗീകരിക്കുന്നു എന്നും പ്രതിജ്ഞ ചെയ്യണം.',
	'requestaccount-inuse' => 'സ്ഥിരീകരണം കാത്തിരിക്കുന്ന അഭ്യര്‍ത്ഥനകളില്‍ ഒന്ന് ഇതേ ഉപയോക്തൃനാമം ഉപയോഗിക്കുന്നുണ്ട്.',
	'requestaccount-tooshort' => 'താങ്കളുടെ ആത്മകഥയില്‍ കുറഞ്ഞത് $1 വാക്കുകള്‍ വേണം.',
	'requestaccount-emaildup' => 'സ്ഥിരീകരണം കാത്തിരിക്കുന്ന അഭ്യര്‍ത്ഥനകളില്‍ ഒന്ന് ഇതേ ഇമെയില്‍ വിലാസം ഉപയോഗിക്കുന്നുണ്ട്.',
	'requestaccount-exts' => 'അറ്റാച്ച് ചെയ്ത പ്രമാണ തരം അനുവദനീയമല്ല.',
	'requestaccount-submit' => 'അംഗത്വത്തിനായി അഭ്യര്‍ത്ഥിക്കുക',
	'requestaccount-email-subj' => '{{SITENAME}} സം‌രംഭത്തിലെ ഇമെയില്‍ വിലാസ സ്ഥിരീകരണം',
	'requestaccount-email-subj-admin' => '{{SITENAME}} സം‌രംഭത്തില്‍ അംഗത്വം സൃഷ്ടിക്കാനുള്ള അഭ്യര്‍ത്ഥന',
	'requestaccount-email-body-admin' => '"$1" ന്റെ അംഗത്വത്തിനായുള്ള അപേക്ഷ സ്ഥിരീകരണത്തിനായി കാത്തിരിക്കുന്നു. ഇമെയില്‍ വിലാസം ഇതിനകം സ്ഥിരീകരിക്കപ്പെട്ടിരിക്കുന്നു. ഈ അപേക്ഷ താങ്കള്‍ക്ക് ഇവിടെ "$2" സ്ഥിരീകരിക്കാവുന്നതാണ്‌.',
	'acct_request_throttle_hit' => 'ക്ഷമിക്കുക, താങ്കള്‍ ഇതിനകം  {{PLURAL:$1|അംഗത്വത്തിനായി|$1 അംഗത്വങ്ങള്‍ക്കായി]] അഭ്യര്‍ത്ഥിച്ചു കഴിഞ്ഞു. ഇനി കൂടുതല്‍ അഭ്യര്‍ത്ഥന നടത്തുന്നതു അനുവദനീയമല്ല.',
	'requestaccount-loginnotice' => "ഉപയോക്തൃ അംഗത്വം ലഭിക്കുന്നതിനായി താങ്കള്‍ '''[[Special:RequestAccount|ഉപയോക്തൃഅംഗത്വത്തിനായി അഭ്യര്‍ത്ഥിക്കണം]]'''.",
	'confirmaccount-newrequests' => "ഇമെയില്‍ വിലാസം സ്ഥിരീകരിക്കപ്പെട്ട '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|അംഗത്വത്തിനായുള്ള അഭ്യര്‍ത്ഥന]]|[[Special:ConfirmAccounts|അംഗത്വത്തിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍]]}} പെന്‍‌ഡിംങ്ങാണ്‌.",
	'confirmaccounts' => 'അംഗത്വ അഭ്യര്‍ത്ഥനകള്‍ സ്ഥിരീകരിക്കുക',
	'confirmedit-desc' => 'ബ്യൂറോക്രാറ്റുകള്‍ക്ക് ഉപയോക്തൃ അംഗത്വത്തിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍ സ്ഥിരീകരിക്കുവാന്‍ അവസരം നല്‍കുന്നു.',
	'confirmaccount-list' => 'അംഗത്വത്തിനായി അഭ്യര്‍ത്ഥിച്ച് അതിന്റെ സ്ഥിരീകരണത്തിനായി കാത്തിരിക്കുന്നവരുടെ പട്ടികയാണ്‌ താഴെ.
ഒരു അഭ്യര്‍ത്ഥന സ്ഥിരീകരിക്കുകയോ നിരാകരിക്കുകയോ ചെയ്താല്‍ അത് ഈ പട്ടികയില്‍ നിന്നു ഒഴിവാക്കുന്നതാണ്‌.',
	'confirmaccount-list2' => 'അംഗത്വത്തിനായുള്ള അഭ്യര്‍ത്ഥനകളില്‍ അടുത്ത കാലത്ത് നിരാകരിക്കപ്പെട്ട അഭ്യര്‍ത്ഥനകളുടെ പട്ടികയാണു താഴെ. ഈ പട്ടികയ്ക്കു ചില ദിവസങ്ങളില്‍ കൂടുതല്‍ പഴക്കമായാല്‍ അതു യാന്ത്രികമായി ഒഴിവാക്കപ്പെടും.
താങ്കള്‍ക്കു താല്പര്യമെങ്കില്‍ ഈ അഭ്യര്‍ത്ഥനകള്‍ സ്ഥിരീകരിക്കാവുന്നതാണ്‌.പക്ഷെ അങ്ങനെ ചെയ്യുന്നതിനു മുന്‍പ് അഭ്യര്‍ത്ഥന നിരാകരിച്ച അഡ്‌മിനിസ്റ്റ്രേറ്ററുമായി ബന്ധപ്പെടുന്നതു നന്നായിരിക്കും.',
	'confirmaccount-none-o' => 'ഈ പട്ടികയില്‍ നിലവില്‍ അംഗത്വത്തിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല',
	'confirmaccount-none-h' => 'ഈ പട്ടികയില്‍ നിലവില്‍ അംഗത്വത്തിനായുള്ള അഭ്യര്‍ത്ഥനകളില്‍ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്ന അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല',
	'confirmaccount-none-r' => 'നിലവില്‍ ഈ പട്ടികയില്‍ നിരസിച്ച അംഗത്വത്തിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല.',
	'confirmaccount-none-e' => 'ഈ പട്ടികയില്‍ നിലവില്‍ അംഗത്വത്തിനായുള്ള കാലഹരണപ്പെട്ട അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല.',
	'confirmaccount-real-q' => 'പേര്‌',
	'confirmaccount-email-q' => 'ഇമെയില്‍',
	'confirmaccount-bio-q' => 'ആത്മകഥ',
	'confirmaccount-showopen' => 'തുറന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-showrej' => 'നിരസിച്ച അപേക്ഷകള്‍',
	'confirmaccount-showheld' => 'തടഞ്ഞുവെക്കപ്പെട്ട അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-showexp' => 'കാലാവധി തീര്‍ന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-review' => 'സം‌ശോധനം',
	'confirmaccount-type-0' => 'ലേഖകരാവാന്‍ സാദ്ധ്യതയുള്ളവര്‍',
	'confirmaccount-type-1' => 'എഡിറ്റര്‍മാരാവാന്‍ സാദ്ധ്യതയുള്ളവര്‍',
	'confirmaccount-q-open' => 'തുറന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-q-held' => 'തടഞ്ഞുവെക്കപ്പെട്ട അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-q-rej' => 'അടുത്ത സമയത്ത് നിരസിച്ച അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-q-stale' => 'കാലാവധി തീര്‍ന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-leg-user' => 'ഉപയോക്തൃഅംഗത്വം',
	'confirmaccount-leg-areas' => 'താല്പര്യമുള്ള പ്രധാന മേഖലകള്‍',
	'confirmaccount-leg-person' => 'വ്യക്തിഗത വിവരങ്ങള്‍',
	'confirmaccount-leg-other' => 'മറ്റ് വിവരങ്ങള്‍',
	'confirmaccount-name' => 'ഉപയോക്തൃനാമം',
	'confirmaccount-real' => 'പേര്‌:',
	'confirmaccount-email' => 'ഇമെയില്‍:',
	'confirmaccount-reqtype' => 'സ്ഥാനം:',
	'confirmaccount-pos-0' => 'ലേഖകന്‍',
	'confirmaccount-pos-1' => 'എഡിറ്റര്‍',
	'confirmaccount-bio' => 'ആത്മകഥ:',
	'confirmaccount-attach' => 'റെസ്യൂം/സിവി:',
	'confirmaccount-notes' => 'കൂടുതല്‍ കുറിപ്പുകള്‍:',
	'confirmaccount-urls' => 'വെബ്ബ്സൈറ്റുകളുടെ പട്ടിക:',
	'confirmaccount-none-p' => '(ഒന്നും നല്‍കിയിട്ടില്ല)',
	'confirmaccount-confirm' => 'താഴെയുള്ള ഓപ്ഷന്‍സ് ഉപയോഗിച്ച് ഈ അഭ്യര്‍ത്ഥന സ്വീകരിക്കുകയോ, നിരസിക്കുകയോ, തടഞ്ഞുവെക്കുകയോ ചെയ്യുക:',
	'confirmaccount-econf' => '(സ്ഥിരീകരിച്ചിരിക്കുന്നു)',
	'confirmaccount-reject' => '([[User:$1|$1]] എന്ന ഉപയോക്താവിനാല്‍ $2നു ഇതു നിരസിക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-noreason' => '(ഒന്നുമില്ല)',
	'confirmaccount-autorej' => '(പ്രവര്‍ത്തനരാഹിത്യം മൂലം ഈ അഭ്യര്‍ത്ഥന യാന്ത്രികമായി നിരസിക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-held' => '([[User:$1|$1]] എന്ന ഉപയോക്താവിനാല്‍ $2നു ഈ അപേക്ഷ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-create' => 'സ്വീകരിക്കുക (അംഗത്വം സൃഷ്ടിക്കുക)',
	'confirmaccount-deny' => 'നിരാകരിക്കുക (പട്ടികയില്‍ നിന്നു ഒഴിവാക്കുക)',
	'confirmaccount-hold' => 'തടഞ്ഞുവെക്കുക',
	'confirmaccount-spam' => 'സ്പാം (ഇമെയില്‍ അയക്കരുത്)',
	'confirmaccount-reason' => 'അഭിപ്രായന്‍ (ഇമെയിലില്‍ ഉള്‍പ്പെടുത്തുന്നതാണ്‌):',
	'confirmaccount-ip' => 'ഐ.പി. വിലാസം:',
	'confirmaccount-submit' => 'സ്ഥിരീകരിക്കുക',
	'confirmaccount-needreason' => 'താഴെയുള്ള കമെന്റ് പെട്ടിയില്‍ ഒരു കാരണം നിര്‍ബന്ധമായും രേഖപ്പെടുത്തണം.',
	'confirmaccount-canthold' => 'ഈ അഭ്യര്‍ത്ഥന ഒന്നുകില്‍ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്നു അല്ലെങ്കില്‍ മായ്ക്കപ്പെട്ടിരിക്കുന്നു.',
	'confirmaccount-acc' => 'അംഗത്വം ഉണ്ടാക്കാനുള്ള അഭ്യര്‍ത്ഥന വിജയകരമായി സ്ഥിരീകരിച്ചിരിക്കുന്നു; പുതിയ ഉപയോക്തൃഅംഗത്വം സൃഷ്ടിച്ചിരിക്കുന്നു [[User:$1|$1]].',
	'confirmaccount-rej' => 'അംഗത്വം ഉണ്ടാക്കാനുള്ള അഭ്യര്‍ത്ഥന വിജയകരമായി നിരാകരിച്ചിരിക്കുന്നു.',
	'confirmaccount-viewing' => '(നിലവില്‍ [[User:$1|$1]] എന്ന ഉപയോക്താവ് വീക്ഷിക്കുന്നു)',
	'confirmaccount-summary' => 'പുതിയ ഉപയോക്താവിന്റെ വ്യക്തിഗത വിവരങ്ങളും വെച്ച് ഉപയോക്തൃതാള്‍ നിര്‍മ്മിച്ചുകൊണ്ടിരിക്കുന്നു.',
	'confirmaccount-welc' => "'''{{SITENAME}} സം‌രംഭത്തിലേക്ക് സ്വാഗതം'''.  താങ്കള്‍ ഇവിടെ നല്ല സംഭാവനകള്‍ ചെയ്യുമെന്നു പ്രതീക്ഷിക്കട്ടെ. താങ്കള്‍ക്ക് [[{{MediaWiki:Helppage}}|സഹായ താളുകള്‍]] വായിക്കുന്നതു ഗുണം ചെയ്തേക്കാം. ഒരിക്കല്‍ കൂടി സ്വാഗതം ചെയ്യുകയും ഇവിടം ആസ്വദിക്കുമെന്നു കരുതുകയും ചെയ്യുന്നു.",
	'confirmaccount-wsum' => 'സ്വാഗതം!',
	'confirmaccount-email-subj' => '{{SITENAME}} സം‌രംഭത്തില്‍ അംഗത്വം സൃഷ്ടിക്കാനുള്ള അഭ്യര്‍ത്ഥന',
	'usercredentials-user' => 'ഉപയോക്തൃനാമം:',
	'usercredentials-leg-user' => 'ഉപയോക്തൃഅംഗത്വം',
	'usercredentials-leg-areas' => 'താല്പര്യമുള്ള പ്രധാന മേഖലകള്‍',
	'usercredentials-leg-person' => 'വ്യക്തിഗത വിവരങ്ങള്‍',
	'usercredentials-leg-other' => 'മറ്റ് വിവരങ്ങള്‍',
	'usercredentials-email' => 'ഇമെയില്‍',
	'usercredentials-real' => 'യഥാര്‍ത്ഥ പേര്‌:',
	'usercredentials-bio' => 'ആത്മകഥ:',
	'usercredentials-attach' => 'റെസ്യൂം/സിവി:',
	'usercredentials-notes' => 'കൂടുതല്‍ കുറിപ്പുകള്‍:',
	'usercredentials-urls' => 'വെബ്ബ് സൈറ്റുകളുടെ പട്ടിക:',
	'usercredentials-ip' => 'യഥാര്‍ത്ഥ IP വിലാസം:',
	'usercredentials-member' => 'അവകാശങ്ങള്‍',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'requestaccount' => 'खाते मागवा',
	'requestaccount-text' => "'''खाते तयार करण्यासाठी खालील अर्ज भरून पाठवा'''.

अर्ज पाठविण्यापूर्वी तुम्ही [[{{MediaWiki:Requestaccount-page}}|अटी व नियम]] वाचलेले असल्याची खात्री करा.

एकदा का खाते तयार झाले की तुम्हाला तसा इमेल संदेश येईल व तुम्ही [[Special:UserLogin]] मध्ये प्रवेश करू शकाल.",
	'requestaccount-page' => '{{ns:project}}:अटी व नियम',
	'requestaccount-dup' => "'''सूचना: तुम्ही अगोदरच नोंदीकृत खात्यामधून प्रवेश केलेला आहे.'''",
	'requestaccount-leg-user' => 'सदस्य खाते',
	'requestaccount-leg-areas' => 'मुख्य पसंती',
	'requestaccount-leg-person' => 'वैयक्तिक माहिती',
	'requestaccount-leg-other' => 'इतर माहिती',
	'requestaccount-acc-text' => 'ही मागणी पूर्ण झाल्यावर तुमच्या इमेल पत्त्यावर एक संदेश येईल. कृपया त्या संदेशात दिलेल्या दुव्यावर टिचकी मारुन सदस्य खात्याची खात्री करा. खाते तयार झाल्यावर परवलीचा शब्द तुमच्या इमेल वर पाठविला जाईल.',
	'requestaccount-areas-text' => 'खालील क्षेत्रांपैकी तुमच्या पसंतीचे तसेच तुम्ही जाणकार असलेले विषय निवडा.',
	'requestaccount-ext-text' => 'खालील माहिती ही गोपनीय असेल व फक्त या मागणी करताच वापरली जाईल.
तुम्ही ओळख पटविण्यासाठी एखादा संपर्क क्रमांक देऊ शकता.',
	'requestaccount-bio-text' => 'तुमची वैयक्तिक माहिती तुमच्या सदस्य पानावर दिसेल.
काही विशेष उल्लेखनीय कामगिरी असल्यास ती वाढविण्याचा प्रयत्न करा.
तसेच ही माहिती प्रकाशित करण्यास तुमची हरकत नाही हे तपासून पहा.
तुमचे नाव तुम्ही [[Special:Preferences]] मध्ये बदलू शकता.',
	'requestaccount-real' => 'खरे नाव:',
	'requestaccount-same' => '(खर्‍या नावा प्रमाणेच)',
	'requestaccount-email' => 'इमेल पत्ता:',
	'requestaccount-reqtype' => 'हुद्दा:',
	'requestaccount-level-0' => 'लेखक',
	'requestaccount-level-1' => 'संपादक',
	'requestaccount-bio' => 'वैयक्तिक माहिती:',
	'requestaccount-attach' => 'रिज्यूम किंवा सीव्ही (CV) (वैकल्पिक):',
	'requestaccount-notes' => 'अधिक माहिती:',
	'requestaccount-urls' => 'संकेतस्थळांची यादी (एका ओळीत एक):',
	'requestaccount-agree' => 'तुम्ही दिलेले स्वत:चे खरे नाव हे बरोबर असल्याचे नमूद करा तसेच तुम्हाला अटी व नियम मान्य आहेत असे नमूद करा.',
	'requestaccount-inuse' => 'तुम्ही दिलेले सदस्यनाव या आधीच कुणीतरी खाते उघडण्यासाठी मागितलेले आहे.',
	'requestaccount-tooshort' => 'तुमच्या वैयक्तिक माहिती मध्ये कमीतकमी $1 शब्द असणे आवश्यक आहे.',
	'requestaccount-emaildup' => 'तुम्ही दिलेला इमेल पत्ता दुसर्‍या एका पूर्ण न झालेल्या मागणीमध्ये नोंदलेला आहे.',
	'requestaccount-exts' => 'जोडण्याच्या संचिकेचा प्रकार वापरायला परवानगी नाही.',
	'requestaccount-resub' => 'तुमच्या रिज्यूमची संचिका सुरक्षेच्या कारणास्तव पुन्हा निवडणे आवश्यक आहे.
जर तुम्ही चढवू इच्छित नसाल तर तो रकाना रिकामा ठेवा.',
	'requestaccount-tos' => 'मी {{SITENAME}} वरचे [[{{MediaWiki:Requestaccount-page}}|नियम व अटी]] वाचलेले असून त्यांना बांधील राहण्याचे वचन देतो.
तसेच मी दिलेले "खरे नाव" हे माझेच खरे नाव आहे.',
	'requestaccount-submit' => 'खाते मागवा',
	'requestaccount-sent' => 'तुमची खात्याची मागणी नोंदलेली आहे व पुनर्तपासणीसाठी गेलेली आहे.',
	'request-account-econf' => 'तुमचा इमेल पत्ता तपासलेला आहे व तो तुमच्या खात्याच्या मागणीमध्ये नोंदला जाईल.',
	'requestaccount-email-subj' => '{{SITENAME}} इमेल पत्ता तपासणी',
	'requestaccount-email-body' => 'कुणीतरी, बहुतेक तुम्ही, $1 या आयपी अंकपत्त्यावरून, {{SITENAME}} वर "$2" हे खाते उघडण्याची मागणी ह्या इमेल पत्त्यावर नोंदविलेली आहे.

{{SITENAME}} वरील हे खाते तुमचेच असल्याची खात्री करण्यासाठी कृपया खालील दुव्यावर टिचकी मारा:

$3

जर तुमचे खाते तयार झाले, तर तुम्हाला परवलीचा शब्द इमेलमार्फत पाठविण्यात येईल. जर ही मागणी तुम्ही दिलेली *नसेल*, तर दुव्यावर टिचकी मारू नका.
हा खात्री कोड $4 नंतर रद्द होईल.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} खाते मागणी',
	'requestaccount-email-body-admin' => '"$1" ने एक खात्याची मागणी नोंदविलेली आहे व ती तुमच्या सहमतीची वाट पाहत आहे.
इमेल पत्ता तपासलेला आहे. तुम्ही तुमची सहमती "$2" इथे नोंदवू शकता.',
	'acct_request_throttle_hit' => 'माफ करा, तुम्ही अगोदरच $1 खात्यांची मागणी नोंदविलेली आहे. तुम्ही अजून मागण्या नोंदवू शकत नाही.',
	'requestaccount-loginnotice' => "सदस्य खाते मिळविण्यासाठी तुम्ही तुमची '''[[Special:RequestAccount|मागणी नोंदवा]]'''.",
	'confirmaccount-newrequests' => "'''$1''' इमेल पत्ता तपासलेला आहे {{PLURAL:$1|[[Special:ConfirmAccounts|खात्याची मागणी]]|[[Special:ConfirmAccounts|खात्यांची मागणी]]}} शिल्लक",
	'confirmaccounts' => 'खाते मागणीला सहमती द्या',
	'confirmedit-desc' => 'अधिकार्‍यांना (bureaucrats) खाते मागणी पूर्ण करण्याचे अधिकार देते',
	'confirmaccount-maintext' => "'''''{{SITENAME}}'' वरील प्रलंबित खाते मागण्या पूर्ण करण्यासाठी हे पान वापरले जाते'''.

प्रत्येक खाते मागणी तीन विभांगांत दिलेली आहे, एक प्रलंबित मागणी साठी, एक ज्याला इतर प्रबंधकांनी प्रलंबित ठेवलेले आहे व तिसरा ज्या मागण्या अलीकडील काळात नाकारलेल्या आहेत.

एखाद्या मागणीला सहमती देताना, काळजीपूर्वक तपासा तसेच दिलेली माहिती पूर्ण असल्याची खात्री करा.
तुमच्या क्रिया गोपनीयरित्या नोंदल्या जातील. तुम्ही करत असलेल्या क्रियांबरोबरच इतरांनी केलेल्या क्रिया तपासून पहा.",
	'confirmaccount-list' => 'खाली प्रलंबित खाते मागण्यांची यादी आहे. एखादी मागणी स्वीकारण्यात अथवा नाकारण्यात आल्यानंतर ती या यादीतून वगळली जाईल.',
	'confirmaccount-list2' => 'खाली अलीकडील काळात नाकारण्यात आलेल्या मागण्यांची यादी आहे. ही यादी काही ठराविक दिवसांनंतर रिकामी केली जाईल. तुम्ही पूर्वी नाकारलेल्या मागण्या खाते नोंदणीकरता स्वीकारू शकता. पण असे करण्यापूर्वी नाकारलेल्या प्रबंधकांशी संपर्क साधा.',
	'confirmaccount-list3' => 'खाली आपोआप रद्द झालेल्या खाते मागण्यांची यादी आहे. काही ठराविक दिवसांनंतर त्या मागण्या या यादीतून वगळल्या जातील. तुम्ही या मागण्या पूर्ण करू शकता.',
	'confirmaccount-text' => "'''{{SITENAME}}''' वरील ही एक प्रलंबित खाते मागणी आहे.

खालील माहिती काळजीपूर्वक तपासा. जर तुम्ही ही मागणी स्वीकारणार असाल, तर स्थिती च्या पुढे या सदस्याची स्थिती निवडा.
अर्जातील माहिती मध्ये केलेले बदल कायमस्वरूपी जतन केले जाणार नाहीत. तुम्ही हे खाते दुसर्‍या नावाने सुद्धा उघडू शकता याची नोंद घ्या.
हे फक्त इतर सदस्यनावांशी साम्य असलेल्या बाबतीतच वापरावे.

तुम्ही जर ही मागणी स्वीकारली अथवा नाकारली नाहीत, तर ती प्रलंबित ठेवली जाईल.",
	'confirmaccount-none-o' => 'या यादीत सध्या एकही प्रलंबित खाते मागणी नाही.',
	'confirmaccount-none-h' => 'या यादीत सध्या एकही प्रलंबित ठेवलेली खाते मागणी नाही.',
	'confirmaccount-none-r' => 'या यादीत सध्या एकही नाकारण्यात आलेली खाते मागणी नाही.',
	'confirmaccount-none-e' => 'या यादीत सध्या एकही रद्द झालेली खाते मागणी नाही.',
	'confirmaccount-real-q' => 'नाव',
	'confirmaccount-email-q' => 'विपत्र',
	'confirmaccount-bio-q' => 'चरित्र',
	'confirmaccount-showopen' => 'प्रलंबित मागण्या',
	'confirmaccount-showrej' => 'नाकारलेल्या मागण्या',
	'confirmaccount-showheld' => 'प्रलंबित ठेवलेल्या मागण्या',
	'confirmaccount-showexp' => 'रद्द झालेल्या मागण्या',
	'confirmaccount-review' => 'समीक्षण',
	'confirmaccount-types' => 'खालील पैकी एक खाते सहमती रांग निवडा:',
	'confirmaccount-all' => '(सर्व रांगा दाखवा)',
	'confirmaccount-type' => 'रांग:',
	'confirmaccount-type-0' => 'इच्छुक लेखक',
	'confirmaccount-type-1' => 'इच्छुक संपादक',
	'confirmaccount-q-open' => 'प्रलंबित मागण्या',
	'confirmaccount-q-held' => 'प्रलंबित ठेवलेल्या मागण्या',
	'confirmaccount-q-rej' => 'अलीकडील काळात नाकारलेल्या मागण्या',
	'confirmaccount-q-stale' => 'रद्द झालेल्या मागण्या',
	'confirmaccount-badid' => 'दिलेल्या क्रमांकाशी जुळणारी प्रलंबित मागणी सापडली नाही.
ती आधीच तपासली गेलेली असू शकते.',
	'confirmaccount-leg-user' => 'सदस्य खाते',
	'confirmaccount-leg-areas' => 'पसंतीची मुख्य क्षेत्रे',
	'confirmaccount-leg-person' => 'वैयक्तिक माहिती',
	'confirmaccount-leg-other' => 'इतर माहिती',
	'confirmaccount-name' => 'सदस्यनाव',
	'confirmaccount-real' => 'नाव:',
	'confirmaccount-email' => 'इमेल:',
	'confirmaccount-reqtype' => 'स्थिती:',
	'confirmaccount-pos-0' => 'लेखक',
	'confirmaccount-pos-1' => 'संपादक',
	'confirmaccount-bio' => 'चरित्र:',
	'confirmaccount-attach' => 'रिज्यूम/सीव्ही:',
	'confirmaccount-notes' => 'अधिक माहिती:',
	'confirmaccount-urls' => 'संकेतस्थळांची यादी:',
	'confirmaccount-none-p' => '(दिलेले नाही)',
	'confirmaccount-confirm' => 'ही मागणी स्वीकारण्यासाठी, प्रलंबित ठेवण्यासाठी किंवा नाकारण्यासाठी खालील रकाने निवडा:',
	'confirmaccount-econf' => '(खात्री केलेले)',
	'confirmaccount-reject' => '([[User:$1|$1]] ने $2 वर नाकारली)',
	'confirmaccount-rational' => 'अर्जदाराला दिलेले कारण (rationale):',
	'confirmaccount-noreason' => '(काहीही नाही)',
	'confirmaccount-autorej' => '(ही मागणी अकार्यक्षमतेमुळे आपोआप नाकारण्यात आलेली आहे)',
	'confirmaccount-held' => '([[User:$1|$1]] ने $2 वर "प्रलंबित ठेवलेली" आहे)',
	'confirmaccount-create' => 'मान्य करा (खाते तयार करा)',
	'confirmaccount-deny' => 'नाकारा (यादीतून काढून टाका)',
	'confirmaccount-hold' => 'प्रलंबित ठेवा',
	'confirmaccount-spam' => 'स्पॅम (इमेल पाठवू नका)',
	'confirmaccount-reason' => 'शेरा (इमेल मध्ये लिहिला जाईल):',
	'confirmaccount-ip' => 'अंक पत्ता:',
	'confirmaccount-submit' => 'खात्री करा',
	'confirmaccount-needreason' => 'तुम्ही खालील शेरा पेटीमध्ये कारण देणे आवश्यक आहे.',
	'confirmaccount-canthold' => 'ही मागणी अगोदरच प्रलंबित ठेवलेली किंवा नाकारलेली आहे.',
	'confirmaccount-acc' => 'खाते मागणी यशस्वीरित्या पूर्ण; [[User:$1|$1]] हे नवीन खाते तयार केले.',
	'confirmaccount-rej' => 'खाते मागणी यशस्वीरित्या नाकारण्यात आलेली आहे.',
	'confirmaccount-viewing' => '([[User:$1|$1]] ने पहारा दिलेला आहे)',
	'confirmaccount-summary' => 'नवीन सदस्याच्या माहितीप्रमाणे सदस्य पान तयार करीत आहे.',
	'confirmaccount-welc' => "'''''{{SITENAME}}'' वर आपले स्वागत आहे!''' आम्ही आशा करतो की आपण इथे योगदान द्याल.
तुम्ही कदाचित [[{{MediaWiki:Helppage}}|साहाय्य पाने]] वाचू इच्छित असाल. पुन्हा एकदा, स्वागत!",
	'confirmaccount-wsum' => 'सुस्वागतम्‌!',
	'confirmaccount-email-subj' => '{{SITENAME}} खाते मागणी',
	'confirmaccount-email-body' => '{{SITENAME}} वर दिलेली तुमची खाते मागणी स्वीकारण्यात आलेली आहे.

खाते नाव: $1

परवलीचा शब्द: $2

सुरक्षेच्या कारणास्तव पहिल्यांदा प्रवेश केल्यानंतर तुमचा परवलीचा शब्द बदलणे आवश्यक आहे. प्रवेश करण्यासाठी, कृपया {{fullurl:Special:UserLogin}} इथे जा.',
	'confirmaccount-email-body2' => '{{SITENAME}} वरची तुमची "$1" खाते मागणी स्वीकारण्यात आलेली आहे.

खाते नाव: $1

परवलीचा शब्द: $2

$3

सुरक्षेच्या कारणास्तव पहिल्यांदा प्रवेश केल्यावर तुम्हाला परवलीचा शब्द बदलावा लागेल. प्रवेश करण्यासाठी {{fullurl:Special:UserLogin}} इथे जा.',
	'confirmaccount-email-body3' => 'माफ करा, {{SITENAME}} वरची तुमची "$1" खाते मागणी नाकारण्यात आलेली आहे.

याची अनेक कारणे असू शकतात.
तुम्ही अर्ज चुकीचा भरला असू शकतो, किंवा योग्य लांबीची उत्तरे दिली नसतील, किंवा काही विशिष्ट माहिती मध्ये कमतरता असेल
संकेतस्थळावर संपर्क यादी असू शकते जी वापरून तुम्ही या बद्दल अधिक माहिती मिळवू शकाल.',
	'confirmaccount-email-body4' => 'माफ करा, {{SITENAME}} वरची तुमची "$1" खाते मागणी नाकारण्यात आलेली आहे.

$2

संकेतस्थळावर संपर्क यादी असू शकते जी वापरून तुम्ही या बद्दल अधिक माहिती मिळवू शकाल.',
	'confirmaccount-email-body5' => '{{SITENAME}} वरची तुमची "$1" खाते मागणी स्वीकारण्यापूर्वी तुम्ही अधिक माहिती देणे गरजेचे आहे.

$2

संकेतस्थळावर संपर्क यादी असू शकते जी वापरून तुम्ही या बद्दल अधिक माहिती मिळवू शकाल.',
	'usercredentials' => 'सदस्याची शिफारसपत्रे',
	'usercredentials-leg' => 'सदस्याची प्रमाणित केलेली शिफारसपत्रे पहा',
	'usercredentials-user' => 'सदस्यनाव:',
	'usercredentials-text' => 'खाली निवडलेल्या सदस्याची प्रमाणित केलेली शिफारसपत्रे दिलेली आहेत.',
	'usercredentials-leg-user' => 'सदस्य खाते',
	'usercredentials-leg-areas' => 'पसंतीची मुख्य क्षेत्रे',
	'usercredentials-leg-person' => 'वैयक्तिक माहिती',
	'usercredentials-leg-other' => 'इतर माहिती',
	'usercredentials-email' => 'विपत्र:',
	'usercredentials-real' => 'खरे नाव:',
	'usercredentials-bio' => 'चरित्र:',
	'usercredentials-attach' => 'रिज्यूम/सीव्ही:',
	'usercredentials-notes' => 'अधिक माहिती:',
	'usercredentials-urls' => 'संकेतस्थळांची यादी:',
	'usercredentials-ip' => 'मूळ आयपी अंकपत्ता:',
	'usercredentials-member' => 'अधिकार:',
	'usercredentials-badid' => 'या सदस्याची शिफारसपत्रे सापडली नाहीत. सदस्य नाव बरोबर असल्याची खात्री करा.',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name' => 'Isem l-utent',
	'confirmaccount-email' => 'E-mail:',
	'usercredentials-user' => 'Isem l-utent:',
	'usercredentials-email' => 'E-mail:',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'requestaccount-level-0' => 'теицязо',
	'requestaccount-level-1' => 'витницязо-петницязо',
	'confirmaccount-real-q' => 'Лемезэ:',
	'confirmaccount-real' => 'Лемезэ:',
	'confirmaccount-pos-0' => 'теиця',
	'confirmaccount-pos-1' => 'витницязо-петницязо',
	'confirmaccount-submit' => 'Кемекстамс',
	'confirmaccount-wsum' => 'Совак, инеське!',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'requestaccount-leg-user' => 'Tlatequitiltilīlli cuentah',
	'requestaccount-real' => 'Melāhuac motōcā:',
	'requestaccount-level-0' => 'chīhualōni',
	'confirmaccount-real-q' => 'Tōcāitl',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-review' => 'Ticceppahuīz',
	'confirmaccount-name' => 'Tlatequitiltilīltōcāitl',
	'confirmaccount-real' => 'Tōcāitl:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-pos-0' => 'chīhualōni',
	'confirmaccount-noreason' => '(ahtlein)',
	'confirmaccount-ip' => 'IP:',
	'confirmaccount-wsum' => '¡Ximopanōlti!',
	'usercredentials-user' => 'Tlatequitiltilīltōcāitl:',
	'usercredentials-leg-user' => 'Tlatequitiltilīlli cuentah',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Melāhuac motōcā:',
	'usercredentials-attach' => 'Resumé/CV',
	'usercredentials-ip' => 'Achto IP:',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'requestaccount-leg-user' => 'Brukerkonto',
	'requestaccount-real' => 'Echten Naam:',
	'requestaccount-email' => 'E-Mail-Adress:',
	'requestaccount-bio' => 'Biografie:',
	'confirmaccount-real-q' => 'Naam',
	'confirmaccount-email-q' => 'E-Mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-leg-user' => 'Brukerkonto',
	'confirmaccount-name' => 'Brukernaam',
	'confirmaccount-real' => 'Naam:',
	'confirmaccount-ip' => 'IP-Adress:',
	'confirmaccount-wsum' => 'Willkamen!',
	'usercredentials-user' => 'Brukernaam:',
	'usercredentials-leg-user' => 'Brukerkonto',
	'usercredentials-email' => 'E-Mail:',
	'usercredentials-real' => 'Echten Naam:',
	'usercredentials-bio' => 'Biografie:',
	'usercredentials-member' => 'Rechten:',
);

/** Dutch (Nederlands)
 * @author Annabel
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'requestaccount' => 'Gebruiker aanvragen',
	'requestaccount-text' => "'''Vul het onderstaande formulier in en stuur het op om een gebruiker aan te vragen'''. 

Zorg ervoor dat u eerst de [[{{MediaWiki:Requestaccount-page}}|voorwaarden]] leest voordat u een gebruiker aanvraagt.

Als uw aanvraag is goedgekeurd, krijgt u een e-mail en daarna kunt u zich [[Special:UserLogin|aanmelden]].",
	'requestaccount-page' => '{{ns:project}}:Voorwaarden',
	'requestaccount-dup' => "'''Let op: u bent al aangemeld met een geregistreerde gebruikersnaam.'''",
	'requestaccount-leg-user' => 'Gebruiker',
	'requestaccount-leg-areas' => 'Interessegebieden',
	'requestaccount-leg-person' => 'Persoonlijke informatie',
	'requestaccount-leg-other' => 'Overige informatie',
	'requestaccount-leg-tos' => 'Gebruiksvoorwaarden',
	'requestaccount-acc-text' => 'U ontvangt een e-mailbevestiging als uw aanvraag is ontvangen.
Reageer daar op door te klikken op de verwijzing die in de e-mail staat.
U krijgt een wachtwoord als uw gebruiker is aangemaakt.',
	'requestaccount-areas-text' => 'Selecteer hieronder de onderwerpen waarmee u ervaring hebt of waarvan u het meeste werk wil verrichten.',
	'requestaccount-ext-text' => 'De volgende informatie wordt vertrouwelijk behandeld en wordt alleen gebruikt voor deze aanvraag.
U kunt contactgegevens zoals een telefoonummer opgeven om te helpen bij het vaststellen van uw identiteit.',
	'requestaccount-bio-text' => 'Uw biografie wordt opgenomen in uw gebruikerspagina.
Probeer uw belangrijkste gegevens op te nemen.
Zorg ervoor dat u achter het publiceren van dergelijke informatie staat.
U kunt uw naam wijzigen via uw [[Special:Preferences|voorkeuren]].',
	'requestaccount-real' => 'Uw naam:',
	'requestaccount-same' => '(gelijk aan uw naam)',
	'requestaccount-email' => 'E-mailadres:',
	'requestaccount-reqtype' => 'Positie:',
	'requestaccount-level-0' => 'auteur',
	'requestaccount-level-1' => 'redacteur',
	'requestaccount-bio' => 'Persoonlijke biografie:',
	'requestaccount-attach' => 'CV (optioneel):',
	'requestaccount-notes' => 'Opmerkingen:',
	'requestaccount-urls' => 'Lijst van websites, als van toepassing (iedere site op een aparte regel):',
	'requestaccount-agree' => 'U moet aangegeven dat uw naam juist is en dat u akkoord gaat met de Voorwaarden.',
	'requestaccount-inuse' => 'De gebruiker is al bekend in een aanvraagprocedure.',
	'requestaccount-tooshort' => 'Uw biografie moet ten minste {{PLURAL:$1|één woord|$1 woorden}} bevatten.',
	'requestaccount-emaildup' => 'Een andere openstaande gebruikersaanvraag gebruikt hetzelfde e-mailadres.',
	'requestaccount-exts' => 'Bestandstype van de bijlage is niet toegestaan.',
	'requestaccount-resub' => 'Uw CV-bestand moet opnieuw geselecteerd worden om veiligheidsredenen.
Laat het veld leeg als u geen bestand meer wilt bijvoegen.',
	'requestaccount-tos' => 'Ik heb de [[{{MediaWiki:Requestaccount-page}}|Voorwaarden]] van {{SITENAME}} gelezen en ga ermee akkoord.
De naam die ik heb opgegeven onder "Uw naam" is inderdaad mijn eigen echte naam.',
	'requestaccount-submit' => 'Gebruikersnaam aanvragen',
	'requestaccount-sent' => 'Uw gebruikersaanvraag is verstuurd en wacht om nagekeken te worden.
Er is een bevestigingse-mail naar uw e-mailadres gezonden',
	'request-account-econf' => 'Uw e-mailadres is bevestigd en wordt in uw gebruikersaanvraag opgenomen.',
	'requestaccount-email-subj' => '{{SITENAME}} bevestiging e-mailadres',
	'requestaccount-email-body' => 'Iemand, waarschijnlijk u, heeft vanaf  IP-adres $1 op {{SITENAME}} een aanvraag gedaan
voor het aanmaken van gebruiker "$2" met dit e-mailadres.

Open de onderstaande verwijzing in uw browser om te bevestigen dat deze gebruiker op {{SITENAME}} daadwerkelijk bij u hoort:

$3

Als de gebruiker is aangemaakt krijgt alleen u een e-mail met het wachtwoord. Als de aanvraag niet van u afkomstig is, volg de verwijzing dan *niet*. 
Deze bevestigingse-mail vervalt op $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} gebruikersaanvragen',
	'requestaccount-email-body-admin' => '"$1" heeft een gebruiker aangevraagd en wacht op bevestiging.
Het e-mailadres is bevestigd.
U kunt de aanvraag hier "$2" bevestigen.',
	'acct_request_throttle_hit' => 'U hebt al $1 {{PLURAL:$1|gebruikersaanvraag|gebruikersaanvragen}} gedaan.
U kunt geen nieuwe aanvragen meer uitbrengen.',
	'requestaccount-loginnotice' => "Om een gebruiker te krijgen, moet u '''[[Special:RequestAccount|een aanvraag doen]]'''.",
	'confirmaccount-newrequests' => "Er {{PLURAL:$1|staat|staan}} '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|gebruikersaanvraag|gebruikersaanvragen}}]] open.",
	'confirmaccounts' => 'Gebruikersaanvragen bevestigen',
	'confirmedit-desc' => 'Geeft bureaucraten de mogelijkheid om gebruikersaanvragen te behandelen',
	'confirmaccount-maintext' => "'''Deze pagina wordt gebruikt om openstaande gebruikersaanvragen te bevestigen op ''{{SITENAME}}'''''.

Elke lijst met gebruikersaanvragen bevat drie sublijsten: één voor openstaande aanvragen, één voor aanvragen die zijn gemarkeerd als \"in behandeling\" door andere beheerders wegens ontbrekende informatie en één voor recent geweigerde aanvragen.

Wanneer gereageerd wordt op een aanvraag, kijk die dan grondig na en bevestig indien nodig de informatie van de aanvragen. Uw handelingen worden niet publiek opgeslagen. Kijk ook de handelingen die niet van u afkomstig na.",
	'confirmaccount-list' => 'Hieronder staan de gebruikersaanvragen die op afhandeling wachten.
Als een aanvraag is goed- of afgekeurd, wordt deze uit deze lijst verwijderd.',
	'confirmaccount-list2' => 'Hieronder staan recentelijk afgewezen gebruikersaanvragen die die over een aantal dagen	automatisch worden verwijderd.
Ze kunnen nog steeds goedgekeurd worden, hoewel het verstandig is voorafgaand contact te zoeken met de beheerder die de aanvraag heeft afgewezen.',
	'confirmaccount-list3' => 'Hieronder staat een lijst met vervallen gebruikersaanvragen die mogelijk automatisch worden verwijderd als ze een aantal dagen oud zijn.
Ze kunnen nog steeds verwerkt worden.',
	'confirmaccount-text' => "Dit is een openstaand gebruikersaanvraag voor '''{{SITENAME}}'''.

Beoordeel alle onderstaande informatie zorgvuldig.
Als u een aanvraag goedkeurt, gebruik dan, als aanwezig, het dropdownmenu om de gebruikersstatus in te stellen.
Bewerkingen die u maakt aan de biografie die in de aanvraag is opgenomen hebben geen invloed op de opgeslagen identiteit.
U kunt de gebruiker onder een andere naam aanmaken.
Doe dit alleen als er mogelijk verwarring kan optreden met andere gebruikersnamen.

Als u deze pagina verlaat zonder het gebruikersaanvraag te bevestigen of af te wijzen, dan blijft het open staan.",
	'confirmaccount-none-o' => 'Er zijn geen openstaande gebruikersaanvragen.',
	'confirmaccount-none-h' => 'Er zijn geen uitgestelde gebruikersaanvragen.',
	'confirmaccount-none-r' => 'Er zijn geen recent afgewezen gebruikersaanvragen.',
	'confirmaccount-none-e' => 'Er zijn geen vervallen gebruikersaanvragen.',
	'confirmaccount-real-q' => 'Naam',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showopen' => 'open aanvragen',
	'confirmaccount-showrej' => 'afgewezen aanvragen',
	'confirmaccount-showheld' => 'aangehouden aanvragen',
	'confirmaccount-showexp' => 'vervallen aanvragen',
	'confirmaccount-review' => 'Beoordelen',
	'confirmaccount-types' => 'Selecteer een lijst met gebruikersaanvragen:',
	'confirmaccount-all' => '(alle lijsten weergeven)',
	'confirmaccount-type' => 'Lijst:',
	'confirmaccount-type-0' => 'toekomstige auteurs',
	'confirmaccount-type-1' => 'toekomstige redacteuren',
	'confirmaccount-q-open' => 'open aanvragen',
	'confirmaccount-q-held' => 'afgehandelde aanvragen',
	'confirmaccount-q-rej' => 'recent afgewezen aanvragen',
	'confirmaccount-q-stale' => 'vervallen aanvragen',
	'confirmaccount-badid' => 'Er is geen openstaande gebruikersaanvraag voor het opgegeven ID.
Wellicht is de aanvraag al afgehandeld.',
	'confirmaccount-leg-user' => 'Gebruiker',
	'confirmaccount-leg-areas' => 'Interessegebieden',
	'confirmaccount-leg-person' => 'Persoonlijke informatie',
	'confirmaccount-leg-other' => 'Overige informatie',
	'confirmaccount-name' => 'Gebruikersnaam',
	'confirmaccount-real' => 'Naam:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Positie:',
	'confirmaccount-pos-0' => 'auteur',
	'confirmaccount-pos-1' => 'redacteur',
	'confirmaccount-bio' => 'Biografie:',
	'confirmaccount-attach' => 'CV (informatie over u):',
	'confirmaccount-notes' => 'Opmerkingen:',
	'confirmaccount-urls' => 'Lijst met websites:',
	'confirmaccount-none-p' => '(niet opgegeven)',
	'confirmaccount-confirm' => 'Gebruik de onderstaande mogelijkheden om deze aanvraag goed te keuren, af te keuren of aan te houden:',
	'confirmaccount-econf' => '(bevestigd)',
	'confirmaccount-reject' => '(afgewezen door [[User:$1|$1]] op $2)',
	'confirmaccount-rational' => 'Aan de aanvrager opgegeven reden:',
	'confirmaccount-noreason' => '(geen)',
	'confirmaccount-autorej' => '(deze aanvraag is automatisch afgebroken wegens inactiviteit)',
	'confirmaccount-held' => '("aangehouden" door [[User:$1|$1]] op $2)',
	'confirmaccount-create' => 'Toelaten (gebruiker aanmaken)',
	'confirmaccount-deny' => 'Afwijzen (verwijderen)',
	'confirmaccount-hold' => 'Aanhouden',
	'confirmaccount-spam' => 'Spam (geen e-mail sturen)',
	'confirmaccount-reason' => 'Opmerking (zal worden toegevoegd aan de email):',
	'confirmaccount-ip' => 'IP-adres:',
	'confirmaccount-legend' => 'Deze aanvraag bevestigen of afkeuren',
	'confirmaccount-submit' => 'Bevestigen',
	'confirmaccount-needreason' => 'U moet een reden geven in het onderstaande veld.',
	'confirmaccount-canthold' => 'Deze aanvraag heeft al de status aangehouden of verwijderd.',
	'confirmaccount-acc' => 'Gebruikersaanvraag goedgekeurd. De gebruiker [[User:$1|$1]] is aangemaakt.',
	'confirmaccount-rej' => 'Gebruikersaanvraag afgewezen.',
	'confirmaccount-viewing' => '(op dit ogenblik bekeken door [[User:$1|$1]])',
	'confirmaccount-summary' => 'Er wordt een gebruikerspagina gemaakt met de biografie van de nieuwe gebruiker.',
	'confirmaccount-welc' => "'''Welkom bij ''{{SITENAME}}''!''' We hopen dat u veel goede bijdragen levert. 
Waarschijnlijk wilt u de [[{{MediaWiki:Helppage}}|hulppagina's]] lezen. Nogmaals, welkom en veel plezier!",
	'confirmaccount-wsum' => 'Welkom!',
	'confirmaccount-email-subj' => '{{SITENAME}} gebruikersaanvraag',
	'confirmaccount-email-body' => 'Uw gebruikersaanvraag op {{SITENAME}} is goedgekeurd.

Gebruiker: $1

Wachtwoord: $2

Om beveiligingsredenen dient u uw wachtwoord bij de eerste keer aanmelden te wijzigen. Aanmelden kan via 
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Uw gebruikersaanvraag op {{SITENAME}} is goedgekeurd.

Gebruikersnaam: $1

Wachtwoord: $2

$3

Om beveiligingsredenen dient u uw wachtwoord bij de eerste keer aanmelden te wijzigen. Aanmelden kan via 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3' => 'Uw gebruikersaanvraag voor "$1" op {{SITENAME}} is afgewezen.

Dit kan meerdere oorzaken hebben.
Mogelijk hebt u het formulier niet volledig ingevuld, waren uw antwoorden onvoldoende compleet, of hebt u om een andere reden niet voldaan aan de eisen.
Op de site staan mogelijk lijsten met contactgegevens als u meer wilt weten over het gebruikersbeleid.',
	'confirmaccount-email-body4' => 'Uw gebruikersaanvraag voor "$1" op {{SITENAME}} is afgewezen.

$2

Op de site staan mogelijk lijsten met contactgegevens als u meer wilt weten over het gebruikersbeleid.',
	'confirmaccount-email-body5' => 'Voordat uw aanvraag voor een gebruiker "$1" aanvaard kan worden op {{SITENAME}}, moet u eerst extra informatie geven.

$2

Er kunnen contacteerlijsten zijn die u kunt gebruiken als u meer wil te weten komen over het beleid ten aanzien van gebruikers.',
	'usercredentials' => 'Referenties van gebruiker',
	'usercredentials-leg' => 'Bevestigde referenties voor gebruiker',
	'usercredentials-user' => 'Gebruikersnaam:',
	'usercredentials-text' => 'Overzicht van de bevestigde referenties voor de geselecteerde gebruiker:',
	'usercredentials-leg-user' => 'Gebruiker',
	'usercredentials-leg-areas' => 'Interessegebieden',
	'usercredentials-leg-person' => 'Persoonlijke informatie',
	'usercredentials-leg-other' => 'Overige informatie',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Echte naam:',
	'usercredentials-bio' => 'Biografie:',
	'usercredentials-attach' => 'CV:',
	'usercredentials-notes' => 'Overige opmerkingen:',
	'usercredentials-urls' => 'Lijst van websites:',
	'usercredentials-ip' => 'Oorspronkelijk IP-adres:',
	'usercredentials-member' => 'Rechten:',
	'usercredentials-badid' => 'Geen referenties gevonden voor deze gebruiker.
Kijk na of de naam correct gespeld is.',
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Wachtrij met gebruikersaanvragen]] bekijken',
	'right-requestips' => 'De IP-adressen van aanvragers bekijken bij het verwerken bij het verwerken van gebruikersaanvragen',
	'right-lookupcredentials' => '[[Special:UserCredentials|gebruikersreferenties]] bekijken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'requestaccount' => 'Be om konto',
	'requestaccount-text' => "'''Fullfør og lever følgjande skjema for å be om ein brukarkonto.'''

Gjer deg viss om at du først les [[{{MediaWiki:Requestaccount-page}}|tenestevilkåra]] før du ber om ein konto.

Når kontoen vert godkjend vil du få melding på e-post og du vil kunna [[Special:UserLogin|logga inn]].",
	'requestaccount-page' => '{{ns:project}}:Tenestevilkår',
	'requestaccount-dup' => "'''Merk: Du er allereie innlogga med ein registrert brukarkonto.'''",
	'requestaccount-leg-user' => 'Brukarkonto',
	'requestaccount-leg-areas' => 'Hovudinteresser',
	'requestaccount-leg-person' => 'Personleg informasjon',
	'requestaccount-leg-other' => 'Annan informasjon',
	'requestaccount-leg-tos' => 'Tenestevilkår',
	'requestaccount-acc-text' => 'Du vil få ein e-post med stadfesting med ein gong denne føresurnaden er sendt inn. 
Svar ved å trykkja på stadfestingslekkja i e-posten. 
Passordet ditt vil òg bli sendt til deg når kontoen er oppretta.',
	'requestaccount-areas-text' => 'Vel det eller dei områda nedanfor som du har mest formell ekspertise innan eller vil jobba mest med.',
	'requestaccount-ext-text' => 'Følgjande informasjon vil bli heldt privat, og vil berre bli nytta for denne førespurnaden. Du vil kanskje lista opp kontaktinformasjon som eit telefonnummer for å hjelpa til med å stadfesta identiteten din.',
	'requestaccount-bio-text' => 'Biografien din vil verta sett som standardinnhald på brukarsida di.
Prøv å inkludera attestinformasjon, men berre om du føler deg tilpass med å frigje slik informasjon.
Namnet ditt kan verta endra gjennom [[Special:Preferences|innstillingane dine]].',
	'requestaccount-real' => 'Verkeleg namn:',
	'requestaccount-same' => '(same som verkeleg namn)',
	'requestaccount-email' => 'E-postadresse:',
	'requestaccount-reqtype' => 'Stilling:',
	'requestaccount-level-0' => 'forfattar',
	'requestaccount-level-1' => 'redaktør',
	'requestaccount-bio' => 'Personleg biografi:',
	'requestaccount-attach' => 'Resyme eller CV (valfritt):',
	'requestaccount-notes' => 'Andre merknader:',
	'requestaccount-urls' => 'Lista over nettsider, om det er nokre (skil dei frå kvarandre med lineskift):',
	'requestaccount-agree' => 'Du lyt stadfesta at det verkelege namnet ditt er rett, og at du går med på tenestevilkåra våre.',
	'requestaccount-inuse' => 'Brukarnamnet er alt i bruk i ein ventande kontoførespurnad.',
	'requestaccount-tooshort' => 'Biografien din lyt innehalda minst {{PLURAL:$1|eitt|$1}} ord.',
	'requestaccount-emaildup' => 'Ein annan ventande kontoførespurnad nyttar same e-postadressa.',
	'requestaccount-exts' => 'Filtypen på vedlegget er ikkje tillaten.',
	'requestaccount-resub' => 'CV-/resyme-fila din må verta vald på nytt grunna omsyn til tryggleik.
Lat feltet vera tomt om du ikkje lenger ynskjer å leggja ved ein.',
	'requestaccount-tos' => 'Eg har lese og vil fylgja [[{{MediaWiki:Requestaccount-page}}|tenestevilkåra]] til {{SITENAME}}. Namnet eg har gjeve under «Verkeleg namn» er det faktiske namnet mitt.',
	'requestaccount-submit' => 'Be om konto',
	'requestaccount-sent' => 'Kontoførespurnaden din er vorten sendt, og ventar no på godkjenning. Ein e-post med ei stadfesting av dette er vorten send til e-postadressa di.',
	'request-account-econf' => 'E-postadressa di er no stadfest, og dette vil verta lista i kontoførespurnaden.',
	'requestaccount-email-subj' => 'Stadfesting av E-postadressa hjå {{SITENAME}}',
	'requestaccount-email-body' => 'Nokon, sannsynlegvis deg frå IP-adressa $1, har bede om ein konto «$2» med denne e-postadressa på {{SITENAME}}.

Opna denne lekkja i nettlesaren din for å stadfesta at denne førespurnaden verkeleg kjem frå deg:

$3

Om kontoen vert oppretta vil berre du motta passordet.
Om førespurnaden *ikkje* kjem frå deg, ikkje følg lekkja.
Denne stadfestingskoden går ut $4.',
	'requestaccount-email-subj-admin' => 'Kontoførespurnad på {{SITENAME}}',
	'requestaccount-email-body-admin' => '«$1» har bede om ein konto og ventar på godkjenning. E-postadressa er stadfesta. Du kan godkjenna førespurnaden her: «$2».',
	'acct_request_throttle_hit' => 'Du har alt bede om {{PLURAL:$1|éin konto|$1 kontoar}}.
Du kan ikkje be om fleire.',
	'requestaccount-loginnotice' => "For å få ein brukarkonto må du '''[[Special:RequestAccount|be om ein]]'''.",
	'confirmaccount-newrequests' => "Det finst for tida {{PLURAL:$1|'''éin''' open [[Special:ConfirmAccounts|kontoførespurnad]]|'''$1''' opne [[Special:ConfirmAccounts|kontoførespurnader]]}}.",
	'confirmaccounts' => 'Godta kontoførespurnader',
	'confirmedit-desc' => 'Gjev byråkratar moglegheita til å godta kontoførespurnader',
	'confirmaccount-maintext' => "'''Denne sida vert nytta for å stadfesta ventande kontoførespurnader på ''{{SITENAME}}'''''.

Kvar kø av kontoførespurnader er sett saman av tre underkøar, éin for opne førespurnader, éin for førespurnader som er sette på vent av andre administratorar og éin for nyleg avviste førespurnader.

Når du reagerer på ein førespurnad, gå gjennom han og, om det er naudsynt, stadfest informasjonen som vert gjeven. Handlingane dine vil verta logga privat. Det er òg venta at du går gjennom aktiviteten som er her frå andre enn deg sjølv.",
	'confirmaccount-list' => 'Under er ei lista over kontoførespurnader som ventar på godkjenning. Godkjende eller avviste kontoar vil verta fjerna frå lista.',
	'confirmaccount-list2' => 'Nedanfor er ei lista over nyleg avviste kontoførespurnader, som vil verta sletta automatisk når dei er eit visst tal dagar gamle.
Dei kan enno verta godkjende, men du bør fyrst kontakta administratoren som avviste dei.',
	'confirmaccount-list3' => 'Nedanfor er ei lista kontoførespurnader som det har gått for lang tid med og som vil verta sletta automatisk etter ei viss tid. Dei kan do enno verta godkjende.',
	'confirmaccount-text' => "Dette er ein ventande kontoførespurnad på '''{{SITENAME}}'''.

Gå nøye gjennom informasjonen nedanfor. Om du godtek førespurnaden, nytt posisjonslista for å setja kontostatusen til brukaren. Endringar gjort i søknadsbiografien vil ikkje ha nokon effekt på lagring av krediteringsinformasjon. Merk at du kan velja å oppretta kontoen med eit anna brukarnamn, men gjer det berre for å unngå kollisjon med andre namn.

Om du forlét denne sida utan å godta eller avvisa førespurnaden, vil han halda på stoda som ventande.",
	'confirmaccount-none-o' => 'Det er for tida ingen ventande førespurnader.',
	'confirmaccount-none-h' => 'Det er for tida ingen ventande kontoførespurnader på denne lista.',
	'confirmaccount-none-r' => 'Det er for tida ingen nyleg avviste kontoførespurnader på denne lista.',
	'confirmaccount-none-e' => 'Det er for tida ingen kontoførespurnader som har gått over tida på denne lista.',
	'confirmaccount-real-q' => 'Namn',
	'confirmaccount-email-q' => 'E-post',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'opne førespurnader',
	'confirmaccount-showrej' => 'avviste førespurnader',
	'confirmaccount-showheld' => 'ventande førespurnader',
	'confirmaccount-showexp' => 'førespurnader som har gått over tida',
	'confirmaccount-review' => 'Gå gjennom',
	'confirmaccount-types' => 'Vel ein kontogodkjenningskø under:',
	'confirmaccount-all' => '(syna alle køar)',
	'confirmaccount-type' => 'Kø:',
	'confirmaccount-type-0' => 'komande forfattarar',
	'confirmaccount-type-1' => 'komande redaktørar',
	'confirmaccount-q-open' => 'opne førespurnader',
	'confirmaccount-q-held' => 'ventande førespurnader',
	'confirmaccount-q-rej' => 'nyleg avviste førespurnader',
	'confirmaccount-q-stale' => 'førespurnader som har gått over tida',
	'confirmaccount-badid' => 'Det finst ingen ventande førespurnader som passar med ID-en du gav.
Kan henda er førespurnaden alt handsama.',
	'confirmaccount-leg-user' => 'Brukarkonto',
	'confirmaccount-leg-areas' => 'Hovudinteresser',
	'confirmaccount-leg-person' => 'Personleg informasjon',
	'confirmaccount-leg-other' => 'Annan informasjon',
	'confirmaccount-name' => 'Brukarnamn',
	'confirmaccount-real' => 'Namn:',
	'confirmaccount-email' => 'E-post:',
	'confirmaccount-reqtype' => 'Stilling:',
	'confirmaccount-pos-0' => 'forfattar',
	'confirmaccount-pos-1' => 'redaktør',
	'confirmaccount-bio' => 'Biografi:',
	'confirmaccount-attach' => 'Resyme/CV:',
	'confirmaccount-notes' => 'Andre merknader:',
	'confirmaccount-urls' => 'Lista over nettstader:',
	'confirmaccount-none-p' => '(ikkje oppgjeve)',
	'confirmaccount-confirm' => 'Nytt vala under for å godta, avvisa eller setja førespurnaden på vent:',
	'confirmaccount-econf' => '(stadfest)',
	'confirmaccount-reject' => '(avvist av [[User:$1|$1]] den $2)',
	'confirmaccount-rational' => 'Grunngjeving gjeven til søkjar:',
	'confirmaccount-noreason' => '(ingen)',
	'confirmaccount-autorej' => '(førespurnaden har vorten vraka automatisk grunna inaktivitet)',
	'confirmaccount-held' => '(sett på «vent» av [[User:$1|$1]] den $2)',
	'confirmaccount-create' => 'Godta (opprett konto)',
	'confirmaccount-deny' => 'Avvis (fjern frå lista)',
	'confirmaccount-hold' => 'Set på vent',
	'confirmaccount-spam' => 'Søppel (ikkje send e-post)',
	'confirmaccount-reason' => 'Kommentar (vert inkludert i e-post):',
	'confirmaccount-ip' => 'IP-adresse:',
	'confirmaccount-submit' => 'Stadfest',
	'confirmaccount-needreason' => 'Du må gje ei grunngjeving i kommentarfeltet under.',
	'confirmaccount-canthold' => 'Denne førespurnaden er alt sletta eller sett på vent.',
	'confirmaccount-acc' => 'Kontoførespurnad godkjend; oppretta kontoen [[User:$1|$1]].',
	'confirmaccount-rej' => 'Kontoførespurnad avvist.',
	'confirmaccount-viewing' => '(vert no gått gjennom av [[User:$1|$1]])',
	'confirmaccount-summary' => 'Opprettar brukarsida med biografi for den nye brukaren.',
	'confirmaccount-welc' => "'''Velkomen til ''{{SITENAME}}''!''' Me vonar at du vil bidra mykje og bra. Du ønskjer truleg å lesa [[{{MediaWiki:Helppage}}|hjelpesidene]]. Igjen, velkomen, og mor deg!",
	'confirmaccount-wsum' => 'Velkomen!',
	'confirmaccount-email-subj' => 'Kontoførespurnad på {{SITENAME}}',
	'confirmaccount-email-body' => 'Førespurnaden din om ein konto på {{SITENAME}} har vorten godkjend.

Kontonamn: $1

Passord: $2

Av tryggingsårsaker lyt du endra passordet etter fyrste innlogging. Gå til {{fullurl:Special:UserLogin}} for å logga inn.',
	'confirmaccount-email-body2' => 'Førespurnaden din om ein konto på {{SITENAME}} har vorten godkjend.

Kontonamn: $1

Passord: $2

$3

Av tryggingsårsaker lyt du endra passordet etter fyrste innlogging. Gå til {{fullurl:Special:UserLogin}} for å logga inn.',
	'confirmaccount-email-body3' => 'Diverre har førespurnaden din om kontoen «$1» på {{SITENAME}} vorten avvist.

Det er fleire moglege grunnar til at dette har skjedd. Du har kanskje ikkje fylt inn skjemaet korrekt, har ikkje svart utfyllande nok, eller møtte på ein annan måte ikkje krav. Det kan vera kontaktlister på nettstaden som du kan nytta for å finna ut meir om retningslinene for kontoar.',
	'confirmaccount-email-body4' => 'Diverre har førespurnaden din om å få ein konto ($1) på {{SITENAME}} vorten avvist.

$2

Det kan vera kontaktlister på nettstaden som du kan nytta for å finna ut meir om retningslinenen for kontoar.',
	'confirmaccount-email-body5' => 'Før førespurnaden din om ein konto «$1» på {{SITENAME}} kan verta godkjend, lyt du oppgje meir informasjon.

$2

Det kan vera kontaktlister på nettstaden som du kan nytta for å finna ut meir om retningslinene for kontoar.',
	'usercredentials' => 'Brukarattestar',
	'usercredentials-leg' => 'Finn stadfeste attestar for ein brukar',
	'usercredentials-user' => 'Brukarnamn:',
	'usercredentials-text' => 'Under er dei stadfeste attestane til den valde brukarkontoen.',
	'usercredentials-leg-user' => 'Brukarkonto',
	'usercredentials-leg-areas' => 'Hovudinteresser',
	'usercredentials-leg-person' => 'Personleg informasjon',
	'usercredentials-leg-other' => 'Annan informasjon',
	'usercredentials-email' => 'E-post:',
	'usercredentials-real' => 'Verkeleg namn:',
	'usercredentials-bio' => 'Biografi:',
	'usercredentials-attach' => 'Resyme/CV:',
	'usercredentials-notes' => 'Andre merknader:',
	'usercredentials-urls' => 'Lista over nettstader:',
	'usercredentials-ip' => 'Opphavleg IP-adressa:',
	'usercredentials-member' => 'Rettar:',
	'usercredentials-badid' => 'Ingen attestar vart funne for brukaren.
Gjer deg viss om at namnet er stava rett.',
	'right-confirmaccount' => 'Vis [[Special:ConfirmAccounts|køen av kontosøknader]]',
	'right-requestips' => 'Vis søkjaren sine IP-adresser medan kontosøknadene er til handsaming',
	'right-lookupcredentials' => 'Vis [[Special:UserCredentials|brukarattestar]]',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'requestaccount' => 'Etterspør konto',
	'requestaccount-text' => "'''Fullfør og lever følgende skjema for å etterspørre en brukerkonto.'''

Forsikre deg om at du først leser [[{{MediaWiki:Requestaccount-page}}|tjenestevilkårene]] før du etterspør en konto.

Når kontoen godkjennes vil du få beskjed på e-post, og du vil kunne [[Special:UserLogin|logge inn]].",
	'requestaccount-page' => '{{ns:project}}:Tjenestevilkår',
	'requestaccount-dup' => "'''Merk: Du er allerede logget inn med en registrert konto.'''",
	'requestaccount-leg-user' => 'Brukerkonto',
	'requestaccount-leg-areas' => 'Hovedinteresser',
	'requestaccount-leg-person' => 'Personlig informasjon',
	'requestaccount-leg-other' => 'Annen informasjon',
	'requestaccount-leg-tos' => 'Tjenestevilkår',
	'requestaccount-acc-text' => 'Du vil få en e-post med bekreftelse med en gang denne forespørselen postes. Vennligst svar ved å klikke på bekreftelseslenka i e-posten. Passordet ditt vil også sendes til deg når kontoen opprettes.',
	'requestaccount-areas-text' => 'Velg det eller de områdene nedenfor som du har formell ekspertise i eller vil jobbe mest med.',
	'requestaccount-ext-text' => 'Følgende informasjon vil holdes privat, og vil kun brukes for denne forespørselen. Du vil kanskje liste opp kontaktinformasjon som et telefonnummer for å hjelpe til i bekreftelsesprosessen.',
	'requestaccount-bio-text' => 'Biografien din vil settes som standardinnhold på brukersiden din. Prøv å inkludere attestinformasjon, men kun om du føler deg tilpass med å frigi slik informasjon. Navnet ditt kan endres via [[Special:Preferences|innstillingene dine]].',
	'requestaccount-real' => 'Virkelig navn:',
	'requestaccount-same' => '(samme som virkelig navn)',
	'requestaccount-email' => 'E-postadresse:',
	'requestaccount-reqtype' => 'Stilling:',
	'requestaccount-level-0' => 'forfatter',
	'requestaccount-level-1' => 'redaktør',
	'requestaccount-bio' => 'Personlig biografi:',
	'requestaccount-attach' => 'Resyme eller CV (valgfri):',
	'requestaccount-notes' => 'Andre merknader:',
	'requestaccount-urls' => 'Liste over nettsider, om det er noen (skill dem fra hverandre med linjeskift):',
	'requestaccount-agree' => 'Du må bekrefte at ditt virkelige navn er korrekt og at du går med på våre tjenestevilkår.',
	'requestaccount-inuse' => 'Brukernavnet er allerede i bruk i en ventende kontoforespørsel.',
	'requestaccount-tooshort' => 'Biografien din må være minst {{PLURAL:$1|ett ord|$1 ord}} lang.',
	'requestaccount-emaildup' => 'En annen ventende kontoforespørsel bruker samme e-postadresse.',
	'requestaccount-exts' => 'Filtypen på vedlegget er ikke tillatt.',
	'requestaccount-resub' => 'CV-/resyme-filen din må velges på nytt av sikkerhetshensyn. La feltet være tomt om du ikke lenger ønsker å legge ved en.',
	'requestaccount-tos' => 'Jeg har lest og vil følge [[{{MediaWiki:Requestaccount-page}}|tjenestevilkårene]] til {{SITENAME}}. Navnet jeg har oppgitt under «Virkelig navn» er mitt faktiske navn.',
	'requestaccount-submit' => 'Etterspør konto',
	'requestaccount-sent' => 'Kontoforespørselen din har blitt sendt og venter på godkjenning.
En e-post med bekreftelse har blitt sendt til din e-postadresse.',
	'request-account-econf' => 'E-postadressen din er nå bekreftet, og vil listes slik i kontoforespørselen.',
	'requestaccount-email-subj' => 'E-postbekreftelse hos {{SITENAME}}',
	'requestaccount-email-body' => 'Noen, antageligvis deg fra IP-adressen $1, har etterspurt en konto «$2» med denne e-postadressen på {{SITENAME}}.

Åpne denne lenken i nettleseren din for å bekrefte at denne forespørselen virkelig kommer fra deg:

$3

Om kontoen blir opprettet vil kun du motta passordet. Om forespørselen *ikke* kommer fra deg, ikke følg lenken. Denne bekreftelseskoden utløper $4.',
	'requestaccount-email-subj-admin' => 'Kontoforespørsel på {{SITENAME}}',
	'requestaccount-email-body-admin' => '«$1» har etterspurt en konto og venter på godkjenning. E-postadressen er bekreftet. Du kan godkjenne forespørselen her: «$2».',
	'acct_request_throttle_hit' => 'Beklager, du har allerede etterspurt {{PLURAL:$1|én konto|$1 kontoer}}. Du kan ikke etterspørre flere.',
	'requestaccount-loginnotice' => "For å få en brukerkonto må du '''[[Special:RequestAccount|etterspørre en]]'''.",
	'confirmaccount-newrequests' => "Det er foreløpig '''$1''' {{PLURAL:$1|åpen [[Special:ConfirmAccounts|kontoforespørsel]]|åpne [[Special:ConfirmAccounts|kontoforespørsler]]}}.",
	'confirmaccounts' => 'Godkjenn kontoforespørsler',
	'confirmedit-desc' => 'Gir byråkrater muligheten til å godkjenne kontoforespørsler.',
	'confirmaccount-maintext' => "'''Denne siden brukes for å bekrefte ventende kontoforespørsel på ''{{SITENAME}}'''''.

Hver kontoforespørselkø består av tre underkøer, én for åpne forespørsler, én for forespørsler som er satt på avventing av andre administratorer, og én for nylig avvise forespørsler.

Når du reagerer på en forespørsel, gå gjennom den  og, om det er nødvendig, bekreft informasjonen som blir gitt. Handlingene dine vil logges privat. Det forventes også at du gjennomgår den aktiviteten som er her fra andre enn deg selv.",
	'confirmaccount-list' => 'Under er en liste over kontoforespørsler som venter på godkjenning. Godkjente kontoer vil opprettes og fjernes fra denne listen. Avviste kontoer vil kun slettes fra listen.',
	'confirmaccount-list2' => 'Nedenfor er en liste over nylig avviste kontoforespørsler, som vil slettes automatisk når de er et visst antall dager gamle.
De kan fortsatt godkjennes, men du burde først konferere med administratoren som avviste dem.',
	'confirmaccount-list3' => 'Nedenfor er en liste over utgåtte kontoforespørsler som vil bli slettet automatisk etter en viss tid. De kan fortsatt godkjennes.',
	'confirmaccount-text' => "Dette er en ventende kontoforespørsel på '''{{SITENAME}}'''.

Gå nøye gjennom informasjonen nedenfor. Om du godkjenner forespørselen, bruk posisjonslisten for å sette brukerens kontostatus. Redigeringer gjort i søknadsbiografien vil ikke ha noen effekt på lagring av krediteringsinformasjon. Merk at du kan velge å opprette kontoen med et annet brukernavn, men gjør det kun for å unngå kollisjon med andre navn.

Om du forlater denne siden uten å godkjenne eller avvise forespørselen, vil den beholde avventningsstatusen.",
	'confirmaccount-none-o' => 'Det er for tiden ingen ventende forespørsler.',
	'confirmaccount-none-h' => 'Det er for tiden ingen ventende kontoforespørsler på denne listen.',
	'confirmaccount-none-r' => 'Det er for tiden ingen nylig avviste kontoforespørsler på denne listen.',
	'confirmaccount-none-e' => 'Det er for tiden ingen utgåtte kontoforespørsler på denne listen.',
	'confirmaccount-real-q' => 'Navn',
	'confirmaccount-email-q' => 'E-post',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'åpne forespørsler',
	'confirmaccount-showrej' => 'avviste forespørsler',
	'confirmaccount-showheld' => 'forespørsler holdt på avventning',
	'confirmaccount-showexp' => 'utgåtte forespørsler',
	'confirmaccount-review' => 'Gå gjennom',
	'confirmaccount-types' => 'Velg en kontogodkjenningskø av de nedenstående:',
	'confirmaccount-all' => '(vis alle køer)',
	'confirmaccount-type' => 'Valgt kø:',
	'confirmaccount-type-0' => 'prospektive forfattere',
	'confirmaccount-type-1' => 'prospektive redaktører',
	'confirmaccount-q-open' => 'åpne forespørsler',
	'confirmaccount-q-held' => 'forespørsler holdt på avventning',
	'confirmaccount-q-rej' => 'nylig avviste forespørsler',
	'confirmaccount-q-stale' => 'utgåtte forespørsler',
	'confirmaccount-badid' => 'Det er ingen ventende forespørsler med den oppgitte ID-en. De kan allerede ha blitt behandlet.',
	'confirmaccount-leg-user' => 'Brukerkonto',
	'confirmaccount-leg-areas' => 'Hovedinteresse',
	'confirmaccount-leg-person' => 'Personlig informasjon',
	'confirmaccount-leg-other' => 'Annen informasjon',
	'confirmaccount-name' => 'Brukernavn',
	'confirmaccount-real' => 'Navn:',
	'confirmaccount-email' => 'E-post:',
	'confirmaccount-reqtype' => 'Stilling:',
	'confirmaccount-pos-0' => 'forfatter',
	'confirmaccount-pos-1' => 'redaktør',
	'confirmaccount-bio' => 'Biografi:',
	'confirmaccount-attach' => 'CV:',
	'confirmaccount-notes' => 'Andre merknader:',
	'confirmaccount-urls' => 'Liste over nettsteder:',
	'confirmaccount-none-p' => '(ikke oppgitt)',
	'confirmaccount-confirm' => 'Bruk valgene nedenfor for å godkjenne, avvise eller putte forespørselen på avventning:',
	'confirmaccount-econf' => '(bekreftet)',
	'confirmaccount-reject' => '(avvist av [[User:$1|$1]] på $2)',
	'confirmaccount-rational' => 'Begrunnelse gitt til søkeren:',
	'confirmaccount-noreason' => '(ingen)',
	'confirmaccount-autorej' => '(denne forespørselen har blitt kassert automatisk på grunn av inaktivitet)',
	'confirmaccount-held' => '(merket for «avventning» av [[User:$1|$1]] på $2)',
	'confirmaccount-create' => 'Godta (opprett konto)',
	'confirmaccount-deny' => 'Avvis (fjern fra listen)',
	'confirmaccount-hold' => 'Sett på avventning',
	'confirmaccount-spam' => 'Søppel (ikke send e-post)',
	'confirmaccount-reason' => 'Kommentar (blir inkludert i e-post):',
	'confirmaccount-ip' => 'IP-adresse:',
	'confirmaccount-legend' => 'Bekreft/avvis denne kontoen',
	'confirmaccount-submit' => 'Bekreft',
	'confirmaccount-needreason' => 'Du må angi en grunn i kommentarfeltet nedenfor.',
	'confirmaccount-canthold' => 'Denne forespørselen er allerede slettet eller på avventning.',
	'confirmaccount-acc' => 'Kontoforespørsel godkjent; opprettet kontoen [[User:$1|$1]].',
	'confirmaccount-rej' => 'Kontoforespørsel avvist.',
	'confirmaccount-viewing' => '(undersøkes nå av [[User:$1|$1]])',
	'confirmaccount-summary' => 'Oppretter brukerside med biografi for den nye brukeren.',
	'confirmaccount-welc' => "'''Velkommen til ''{{SITENAME}}''!''' Vi håper at du vil bidra mye og bra. Du ønsker trolig å lese [[{{MediaWiki:Helppage}}|hjelpesidene]]. Igjen, velkommen, og mor deg!",
	'confirmaccount-wsum' => 'Velkommen!',
	'confirmaccount-email-subj' => 'Kontoforespørsel på {{SITENAME}}',
	'confirmaccount-email-body' => 'Din forespørsel om en konto på {{SITENAME}} har blitt godkjent.

Kontonavn: $1

Passord: $2

Av sikkerhetsgrunner må du endre passordet etter første innlogging. Gå til {{fullurl:Special:UserLogin}} for å logge inn.',
	'confirmaccount-email-body2' => 'Din forespørsel om en konto på {{SITENAME}} har blitt godkjent.

Kontonavn: $1

Passord: $2

$3

Av sikkerhetsgrunner må du endre passordet etter første innlogging. Gå til {{fullurl:Special:UserLogin}} for å logge inn.',
	'confirmaccount-email-body3' => 'Beklager, din forespørsel om kontoen «$1» på {{SITENAME}} har blitt avvist.

Det er flere mulige grunner til at dette har skjedd. Du har muligens ikke fylt inn skjemaet korrekt, har ikke svart utfyllende nok, eller møter på en annen måte ikke kriteriene. Det kan være kontaktlister på siden som du kan bruke for å finne ut mer om kontopolitikken.',
	'confirmaccount-email-body4' => 'Beklager, din forespørsel om å få en konto ($1) på {{SITENAME}} har blitt avvist.

$2

Det kan være kontaktlister på siden som du kan bruke for å finne ut mer om kontopolitikken.',
	'confirmaccount-email-body5' => 'Før din forespørsel om en konto «$1» på {{SITENAME}} kan godkjennes, må du oppgi mer informasjon.

$2

Det kan være kontaktlister på siden som du kan bruke for å finne ut mer om kontopolitikken.',
	'usercredentials' => 'Brukerattester',
	'usercredentials-leg' => 'Finn bekreftede attester for en bruker',
	'usercredentials-user' => 'Brukernavn:',
	'usercredentials-text' => 'Nedenfor er de bekreftede attestene til den valgte brukerkontoen.',
	'usercredentials-leg-user' => 'Brukerkonto',
	'usercredentials-leg-areas' => 'Hovedinteresser',
	'usercredentials-leg-person' => 'Personlig informasjon',
	'usercredentials-leg-other' => 'Annen informasjon',
	'usercredentials-email' => 'E-post:',
	'usercredentials-real' => 'Virkelig navn:',
	'usercredentials-bio' => 'Biografi:',
	'usercredentials-attach' => 'CV:',
	'usercredentials-notes' => 'Andre merknader:',
	'usercredentials-urls' => 'Liste over nettsteder:',
	'usercredentials-ip' => 'Opprinnelig IP-adresse:',
	'usercredentials-member' => 'Rettigheter:',
	'usercredentials-badid' => 'Ingen attester funnet for denne brukeren. Sjekk at navnet er stavet riktig.',
	'right-confirmaccount' => 'Vis [[Special:ConfirmAccounts|køen av kontosøknader]]',
	'right-requestips' => 'Vis søkerenes IP-adresser mens man behandler kontosøknadene',
	'right-lookupcredentials' => 'Vis [[Special:UserCredentials|brukerattester]]',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'requestaccount-real' => 'Leina la nnete:',
	'requestaccount-email' => 'Atrese ya email:',
	'requestaccount-level-0' => 'mongwadi',
	'requestaccount-level-1' => 'morulaganyi',
	'confirmaccount-real-q' => 'Leina',
	'confirmaccount-real' => 'Leina:',
	'confirmaccount-pos-0' => 'mongwadi',
	'confirmaccount-pos-1' => 'morulaganyi',
	'usercredentials-user' => 'Liena la mošomiši:',
	'usercredentials-real' => 'Leina la nnete',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'requestaccount' => "Demanda de compte d'utilizaire",
	'requestaccount-text' => "'''Emplenatz e mandatz lo formulari çaijós per demandar un compte d’utilizaire.'''.

	Asseguratz-vos qu'avètz ja legit [[{{MediaWiki:Requestaccount-page}}|las condicions d’utilizacion]] abans de far vòstra demanda de compte.

	Un còp que lo compte es acceptat, recebretz un corrièr electronic que vos notificarà que vòstre compte poirà èsser utilizat sus
	[[Special:UserLogin]].",
	'requestaccount-page' => "{{ns:project}}:Condicions d'utilizacion",
	'requestaccount-dup' => "'''Nòta : Ja sètz sus una sesilha amb un compte enregistrat.'''",
	'requestaccount-leg-user' => "Compte d'utilizaire",
	'requestaccount-leg-areas' => "Centres d'interès principals",
	'requestaccount-leg-person' => 'Entresenhas personalas',
	'requestaccount-leg-other' => 'Autras entresenhas',
	'requestaccount-leg-tos' => 'Tèrmes del servici',
	'requestaccount-acc-text' => 'Un messatge de confirmacion serà mandat a vòstra adreça electronica una còp que la demanda serà estada mandada. Dins lo corrièr recebut, clicatz sul ligam correspondent a la confirmacion de vòstra demanda. E mai, senhal serà mandat per corrièr electronic quand vòstre compte serà creat.',
	'requestaccount-areas-text' => 'Causissètz los domenis dins los quals avètz una expertisa demostrada, o dins los quals sètz mai portat a contribuir.',
	'requestaccount-ext-text' => 'L’informacion seguenta demòra privada e poirà èsser utilizada que per aquesta requèsta. Avètz la possibilitat de far la lista dels contactes coma un numèro de telefòn per obténer una assisténcia per confirmar vòstra identitat.',
	'requestaccount-bio-text' => "Vòstra biografia serà mesa per defaut sus vòstra pagina d'utilizaire. Ensajatz d’i metre vòstras recomandacions. Asseguratz-vos que podètz difusir sens crenta las entresenhas. Vòstre nom pòt èsser cambiat en utilizant [[Special:Preferences|vòstras preferéncias]].",
	'requestaccount-real' => 'Nom vertadièr :',
	'requestaccount-same' => '(nom figurant dins vòstre estat civil)',
	'requestaccount-email' => 'Adreça electronica:',
	'requestaccount-reqtype' => 'Situacion :',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografia personala :',
	'requestaccount-attach' => 'CV/Resumit (facultatiu)',
	'requestaccount-notes' => 'Nòtas suplementàrias :',
	'requestaccount-urls' => "Lista dels sites Web. Se n'i a mai d'un, separatz-los per un saut de linha :",
	'requestaccount-agree' => "Vos cal certificar que vòstre nom vertadièr es corrècte e qu'acceptatz las condicions d’utilizacion del servici.",
	'requestaccount-inuse' => 'Lo nom d’utilizaire es ja utilizat dins una requèsta en cors d’aprobacion.',
	'requestaccount-tooshort' => 'Vòstra biografia deu aver almens $1 {{PLURAL:$1|mot|mots}}.',
	'requestaccount-emaildup' => 'Una autra demanda en cors utiliza la meteissa adreça electronica.',
	'requestaccount-exts' => 'Lo telecargament dels fiquièrs junts es pas permés.',
	'requestaccount-resub' => 'Vòstre fichièr de CV/resumit deu èsser seleccionat un còp de mai per de rasons de seguretat. Daissatz lo camp void se lo desiratz pas mai jónher.',
	'requestaccount-tos' => 'Ai legit e accèpti de respectar los [[{{MediaWiki:Requestaccount-page}}|tèrmes concernent las condicions d’utilizacion dels servicis]] de {{SITENAME}}.',
	'requestaccount-submit' => "Demanda de compte d'utilizaire.",
	'requestaccount-sent' => "Vòstra demanda de compte d'utilizaire es estada mandada amb succès e es estada mesa dins la lista d’espèra d’aprovacion.
Un corrièl de confirmacion es estat mandat a vòstra adreça de corrièl.",
	'request-account-econf' => 'Vòstra adreça de corrièr electronic es estada confirmada e serà listada tala coma es dins vòstra demanda de compte.',
	'requestaccount-email-subj' => '{{SITENAME}} confirmacion d’adreça de corrièr electronic.',
	'requestaccount-email-body' => "Qualqu’un, probablament vos, a formulat, dempuèi l’adreca IP $1, una demanda de compte d'utilizaire « $2 » amb aquesta adreça de corrièr electronic sus {{SITENAME}}.

Per confirmar qu'aqueste compte vos aparten vertadièrament sus {{SITENAME}}, sètz pregat de dobrir aqueste ligam dins vòstre navigador Web :

$3 

Vòstre senhal vos serà mandat unicament se vòstre compte es creat. Se èra pas lo cas, utilizetz pas aqueste ligam. 
Aqueste còde de confirmacion expira lo $4.",
	'requestaccount-email-subj-admin' => 'Demanda de compte sus {{SITENAME}}',
	'requestaccount-email-body-admin' => "« $1 » a demandat un compte e se tròba en espèra de confirmacion.

L'adreça de corrièr electronic es estada confirmada. Podètz, d’ara endavant, aprovar la demanda aicí « $2 ».",
	'acct_request_throttle_hit' => 'O planhèm, ja avètz demandat {{PLURAL:$1|1 compte|$1 comptes}}.
Podètz pas far mai de demanda.',
	'requestaccount-loginnotice' => "Per obténer un compte d'utilizaire, vos ne cal far '''[[Special:RequestAccount|la demanda]]'''.",
	'confirmaccount-newrequests' => "Actualament i a '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|demanda de compte]]|[[Special:ConfirmAccounts|demandas de compte]]}} en cors.",
	'confirmaccounts' => 'Demanda de confirmacion de comptes',
	'confirmedit-desc' => 'Balha als burocratas la possibilitat de confirmar las demandas de comptes d’utilizaires.',
	'confirmaccount-maintext' => "'''Aquesta pagina es utilizada per confirmar las demandas de compte d'utilizaire sus ''{{SITENAME}}'''''.

Cada demanda de compte d'utilizaire consistís en tres soslistas : una per las demandas non tractadas, una pels comptes reservats dins l'espèra d'entresenhas mai amplas, e una darrièra pels comptes regetats recentament.

Al moment de la responsa a una demanda, verificatz-la atentivament e, se fa mestèr, confirmatz las informaxions qu'i son mencionadas. Vòstras accions seràn inscrichas separadament dins un jornal. Tanben podètz esperar la verificacion de cada activitat que prendràn de plaça separadament per rapòrt a çò que faretz vos-meteis.",
	'confirmaccount-list' => "Vaquí, çaijós, la lista dels comptes en espèra d’aprobacion. Los comptes acceptats seràn creats e levats d'aquesta lista. Los comptes regetats seràn suprimits d'aquesta meteissa lista.",
	'confirmaccount-list2' => "Veire la lista dels comptes recentament regetats que seràn suprimits automaticament aprèp qualques jorns. Pòdon encara èsser aprobats, e mai podètz consultar los regets abans d'o far.",
	'confirmaccount-list3' => 'Çaijós se tròba una lista de comptes expirats que poirián èsser automaticament suprimits aprèp qualques jorns. Encara pòdon èsser aprovats.',
	'confirmaccount-text' => "Vaquí una demanda en cors per un compte d'utilizaire sus '''{{SITENAME}}'''.

Atencion, verificatz e, se fe mestièr, confirmatz totas las entresenhas çaijós. Notatz que podètz causir de crear un compte jos un autre nom. Fasètz aquò unicament per evitar de conflictes amb d’autres noms. 

Se quitatz aquesta pagina sens confirmar o regetar aquesta demanda, serà totjorn mesa en espèra.",
	'confirmaccount-none-o' => "Actualament i a pas cap de demanda de compte d'utilizaire en cors dins aquesta lista.",
	'confirmaccount-none-h' => "Actualament i a pas cap de reservacion de compte d'utilizaire en cors dins aquesta lista.",
	'confirmaccount-none-r' => "Actualament i a pas cap de regèt recent de demanda de compte d'utilizaire dins aquesta lista.",
	'confirmaccount-none-e' => 'Actualament, i a pas cap de requèsta de compte expirada dins la lista.',
	'confirmaccount-real-q' => 'Nom',
	'confirmaccount-email-q' => 'Corrièr electronic',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'Requèstas dobèrtas',
	'confirmaccount-showrej' => 'Requèstas regetadas',
	'confirmaccount-showheld' => 'Vejatz la lista dels comptes reservats en cors de tractament',
	'confirmaccount-showexp' => 'Requèstas expiradas',
	'confirmaccount-review' => 'Aprobacion/Regèt',
	'confirmaccount-types' => "Seleccionatz un compte dins la lista d'espèra çaijós :",
	'confirmaccount-all' => "(Vejatz totas las listas d'espèra)",
	'confirmaccount-type' => "Lista d'espèra seleccionada :",
	'confirmaccount-type-0' => 'autors eventuals',
	'confirmaccount-type-1' => 'editors eventuals',
	'confirmaccount-q-open' => 'demandas fachas',
	'confirmaccount-q-held' => 'demandas mesas en espèra',
	'confirmaccount-q-rej' => 'demandas regetadas recentament',
	'confirmaccount-q-stale' => 'Requèstas expiradas',
	'confirmaccount-badid' => 'I a pas cap de demanda en cors correspondent a l’ID indicat. Es possible que aja subit una mantenença.',
	'confirmaccount-leg-user' => "Compte d'utilizaire",
	'confirmaccount-leg-areas' => "Centres d'interès principals",
	'confirmaccount-leg-person' => 'Entresenhas personalas',
	'confirmaccount-leg-other' => 'Autras entresenhas',
	'confirmaccount-name' => "Nom d'utilizaire",
	'confirmaccount-real' => 'Nom',
	'confirmaccount-email' => 'Adreça de corrièr electronic :',
	'confirmaccount-reqtype' => 'Situacion :',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografia :',
	'confirmaccount-attach' => 'CV/Resumit :',
	'confirmaccount-notes' => 'Nòtas suplementàrias :',
	'confirmaccount-urls' => 'Lista dels sites web :',
	'confirmaccount-none-p' => '(pas provesit)',
	'confirmaccount-confirm' => 'Utilizatz los botons çaijós per acceptar o regetar la demanda.',
	'confirmaccount-econf' => '(confirmat)',
	'confirmaccount-reject' => '(regetat per [[User:$1|$1]] lo $2)',
	'confirmaccount-rational' => 'Motiu balhat al candidat',
	'confirmaccount-noreason' => '(nonrés)',
	'confirmaccount-autorej' => '(Aquesta requèsta es estada abandonada automaticament per causa d’abséncia d’activitat)',
	'confirmaccount-held' => 'Marcat « detengut » per [[User:$1|$1]] sus $2',
	'confirmaccount-create' => 'Aprovacion (crèa lo compte)',
	'confirmaccount-deny' => 'Regèt (suprimís lo compte)',
	'confirmaccount-hold' => 'Detengut',
	'confirmaccount-spam' => 'Spam (mandetz pas de corrièr electronic)',
	'confirmaccount-reason' => 'Comentari (figurarà dins lo corrièr electronic) :',
	'confirmaccount-ip' => 'Adreça IP :',
	'confirmaccount-legend' => 'Confirmar/regetar aqueste compte',
	'confirmaccount-submit' => 'Confirmacion',
	'confirmaccount-needreason' => 'Vos cal indicar un motiu dins lo quadre çaiaprèp.',
	'confirmaccount-canthold' => 'Aquesta requèsta es ja, siá presa en compte, siá suprimida.',
	'confirmaccount-acc' => "La demanda de compte es estada confirmada amb succès ; creacion de l'utilizaire novèl [[User:$1|$1]].",
	'confirmaccount-rej' => 'La demanda es estada regetada amb succès.',
	'confirmaccount-viewing' => '(actualament a èsser visionat per [[User:$1|$1]])',
	'confirmaccount-summary' => "Creacion de la pagina d'utilizaire amb sa biografia.",
	'confirmaccount-welc' => "'''Benvenguda sus ''{{SITENAME}}'' !'''
Esperam que contribuiretz fòrça e plan.
Desiraratz, benlèu, legir [[{{MediaWiki:Helppage}}|cossí plan amodar]].
Benvenguda encara e bona contribucions.",
	'confirmaccount-wsum' => 'Benvenguda !',
	'confirmaccount-email-subj' => '{{SITENAME}} demanda de compte',
	'confirmaccount-email-body' => "Vòstra demanda de compte es estada acceptada sus {{SITENAME}}. Nom del compte d'utilizaire : $1 Senhal : $2 Per de rasons de seguretat, vos caldrà cambiar vòstre senhal al moment de vòstra primièra connexion. Per vos connectar, anatz sus {{fullurl:Special:UserLogin}}.",
	'confirmaccount-email-body2' => "Vòstra demanda de compte d'utilizaire es estada acceptada sus {{SITENAME}}. Nom del compte d'utilizaire : $1 Senhal: $2 $3 Per de rasons de seguretat, vos caldrà cambiar vòstre senhal al moment de vòstra primièra connexion. Per vos connectar, anatz sus {{fullurl:Special:UserLogin}}.",
	'confirmaccount-email-body3' => 'O planhèm, vòstra demanda de compte d\'utilizaire "$1" es estada regetada sus {{SITENAME}}. Mantuna rason pòdon explicar aqueste cas de figura. Es possible que ajatz mal emplenat lo formulari, o que ajatz pas indicat sufisentament d’informacions dins vòstras responsas. Es encara possible que emplenetz pas los critèris d’eligibilitat per obténer vòstre compte. Es possible d’èsser sus la lista dels contactes se desiratz conéisser melhor las condicions requesas.',
	'confirmaccount-email-body4' => 'O planhèm, vòstra demanda de compte d\'utilizaire "$1" es estada regetada sus {{SITENAME}}. $2 Es possible d’èsser sus la lista dels contactes per conéisser melhor los critèris per poder s’inscriure.',
	'confirmaccount-email-body5' => 'Abans que vòstra requèsta pel compte « $1 » pòsca èsser acceptada sus {{SITENAME}}, vos cal produire qualques entresenhas suplementàrias.

$2

Aquò permet d’èsser sus la tièra dels contactes del site, se ne desiratz saber mai sus las règlas que concernisson los comptes.',
	'usercredentials' => "Referéncias de l'utilizaire",
	'usercredentials-leg' => "Verificacion confirmada de las referéncias d'un utilizaire.",
	'usercredentials-user' => "Nom d'utilizaire :",
	'usercredentials-text' => "Çaijós figuran los justificatius validats pel compte d'utilizaire seleccionat.",
	'usercredentials-leg-user' => "Compte d'utilizaire",
	'usercredentials-leg-areas' => "Centres d'interès principals",
	'usercredentials-leg-person' => 'Entresenhas personalas',
	'usercredentials-leg-other' => 'Autras entresenhas',
	'usercredentials-email' => 'Corrièr electronic :',
	'usercredentials-real' => 'Nom vertadièr :',
	'usercredentials-bio' => 'Biografia :',
	'usercredentials-attach' => 'CV/Resumit :',
	'usercredentials-notes' => 'Nòtas suplementàrias :',
	'usercredentials-urls' => 'Lista dels sites internet :',
	'usercredentials-ip' => 'Adreça IP iniciala :',
	'usercredentials-member' => 'Dreches :',
	'usercredentials-badid' => 'Cap de referéncia pas trobada per aqueste utilizaire. Verificatz que lo nom siá ben redigit.',
	'right-confirmaccount' => 'Vejatz la [[Special:ConfirmAccounts|fila de las demandas de compte]]',
	'right-requestips' => 'Vejatz las adreças IP dels demandaires al moment del tractament de las demandas de comptes novèls',
	'right-lookupcredentials' => 'Vejatz las [[Special:UserCredentials|referéncias dels utilizaires]]',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'requestaccount-level-0' => 'автор',
	'confirmaccount-email-q' => 'Эл. посты адрис',
	'confirmaccount-showexp' => 'eksdatiĝintaj petoj',
	'confirmaccount-name' => 'Архайæджы ном',
	'confirmaccount-email' => 'Эл. посты адрис:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-noreason' => '(нæй)',
	'usercredentials-email' => 'Эл. посты адрис:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'requestaccount-level-0' => 'Schreiwer',
	'confirmaccount-real-q' => 'Naame',
	'confirmaccount-name' => 'Yuuser-Naame',
	'confirmaccount-real' => 'Naame:',
	'confirmaccount-pos-0' => 'Schreiwer',
	'confirmaccount-noreason' => '(nix)',
	'usercredentials-user' => 'Yuuser-Naame:',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'confirmaccount-name' => 'Bruckernome',
	'usercredentials-user' => 'Bruckernome:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Equadus
 * @author Leinad
 * @author Maikking
 * @author Masti
 * @author McMonster
 * @author Sp5uhe
 * @author ToSter
 * @author Wpedzich
 */
$messages['pl'] = array(
	'requestaccount' => 'Wniosek o założenie konta',
	'requestaccount-text' => "'''Wypełnij i wyślij poniższy formularz jeśli chcesz mieć własne konto użytkownika'''.

Zanim jednak to zrobisz zapoznaj się z [[{{MediaWiki:Requestaccount-page}}|zasadami korzystania z konta]]

Jeśli wniosek o założenie konta zostanie zaakceptowany, otrzymasz wiadomość e‐mail i będziesz mógł [[Special:UserLogin|się zalogować]].",
	'requestaccount-page' => '{{ns:project}}:Zasady użytkowania',
	'requestaccount-dup' => "'''Uwaga: Jesteś już zalogowany na zarejestrowane konto.'''",
	'requestaccount-leg-user' => 'Konto użytkownika',
	'requestaccount-leg-areas' => 'Główne obszary zainteresowań',
	'requestaccount-leg-person' => 'Informacje osobiste',
	'requestaccount-leg-other' => 'Inne informacje',
	'requestaccount-leg-tos' => 'Warunki użytkowania serwisu',
	'requestaccount-acc-text' => 'Na Twój adres e‐mail zostanie wysłana wiadomość potwierdzająca złożenie wniosku o założenie konta.
Kliknij na link zawarty w tej wiadomości.
Hasło do konta zostanie przesłane poprzez e‐mail, gdy konto zostanie już utworzone.',
	'requestaccount-areas-text' => 'Określ tematy i obszary dla których posiadasz formalne przygotowanie lub takie nad którymi planujesz najwięcej pracować.',
	'requestaccount-ext-text' => 'Następujące informacje nie będą udostępniane. Zostaną użyte tylko na potrzeby tego wniosku o założenie konta użytkownika.
Możesz wyświetlić kontakty np. numer telefonu, by łatwiej zdecydować o zatwierdzeniu lub odrzuceniu wniosku.',
	'requestaccount-bio-text' => 'Biografia zostanie wstawiona jako domyślna zawartość Twojej strony użytkownika.
Załącz informacje o kwalifikacjach i referencje, oczywiście pod warunkiem, że opublikowanie tych informacji nie stanowi dla Ciebie problemu.
Imię i nazwisko będziesz mógł poprawić w [[Special:Preferences|preferencjach]].',
	'requestaccount-real' => 'Imię i nazwisko:',
	'requestaccount-same' => '(prawdziwe imię i nazwisko)',
	'requestaccount-email' => 'Adres e‐mail:',
	'requestaccount-reqtype' => 'Stanowisko:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'redaktor',
	'requestaccount-bio' => 'Osobista biografia:',
	'requestaccount-attach' => 'Życiorys (opcjonalne):',
	'requestaccount-notes' => 'Dodatkowe informacje:',
	'requestaccount-urls' => 'Lista adresów stron internetowych, jeśli posiadasz (każdy w osobnym wierszu):',
	'requestaccount-agree' => 'Musisz potwierdzić, że wpisane imię i nazwisko są poprawne oraz, że zgadzasz się na warunki korzystania z {{GRAMMAR:D.lp|{{SITENAME}}}}.',
	'requestaccount-inuse' => 'Nazwa użytkownika jest zajęta przez oczekujący wniosek o założenie konta.',
	'requestaccount-tooshort' => 'Biografia musi mieć co najmniej $1 {{PLURAL:$1|słowo|słowa|słów}}.',
	'requestaccount-emaildup' => 'W innym oczekującym wniosku o założenie konta użytkownika wpisano taki sam adres e‐mail.',
	'requestaccount-exts' => 'Niedozwolony typ załącznika.',
	'requestaccount-resub' => 'Plik z Twoim życiorysem musi zostać ponownie wybrany ze względów bezpieczeństwa.
Pozostaw pole niewypełnione jeśli nie chcesz więcej go załączać.',
	'requestaccount-tos' => 'Przeczytałem i wyrażam bez zastrzeżeń zgodę na [[{{MediaWiki:Requestaccount-page}}|warunki korzystania]] z {{GRAMMAR:D.lp|{{SITENAME}}}}.
Oświadczam, że wpisane przez ze mnie imię i nazwisko są faktycznie moimi.',
	'requestaccount-submit' => 'Składam wniosek',
	'requestaccount-sent' => 'Twój wniosek o założenie konta został wysłany i oczekuje na rozpatrzenie.
Wiadomość z prośbą o potwierdzenie została przesłana na adres Twojej poczty elektronicznej.',
	'request-account-econf' => 'Adres e‐mail został potwierdzony i będzie wyświetlany tak, jak określono we wniosku o założenie konta.',
	'requestaccount-email-subj' => 'Potwierdzenie adresu e‐mail w {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'requestaccount-email-body' => 'Ktoś (zakładamy, że Ty), z komputera o adresie IP $1, złożył w {{GRAMMAR:MS.pl|{{SITENAME}}}} wniosek o założenie konta użytkownika „$2”, podając przy tym niniejszy adres e‐mail.

Jeśli to Ty zakładasz konto w {{GRAMMAR:MS.pl|{{SITENAME}}}}, potwierdź to otwierając w swojej przeglądarce poniższy link:

$3

Jeśli konto zostanie utworzone, zostanie wysłane do Ciebie na ten adres e‐mail hasło.
Jeśli to nie Ty zakładałeś konto, *nie klikaj* w powyższy link.
Kod potwierdzający zawarty w powyższym linku straci ważność $4.',
	'requestaccount-email-subj-admin' => 'Wniosek o założenie konta użytkownika w {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'requestaccount-email-body-admin' => '„$1” złożył wniosek o założenie konta użytkownika i oczekuje na zatwierdzenie.
Adres e‐mail został potwierdzony. Możesz zatwierdzić wniosek tutaj „$2”.',
	'acct_request_throttle_hit' => 'Złożyłeś już {{PLURAL:$1|1 wniosek|$1 wnioski|$1 wniosków}} o założenie konta użytkownika.
Nie możesz złożyć więcej wniosków.',
	'requestaccount-loginnotice' => "By uzyskać konto użytkownika musisz '''[[Special:RequestAccount|złożyć wniosek]]'''.",
	'confirmaccount-newrequests' => "{{PLURAL:$1|Jest '''$1''' [[Special:ConfirmAccounts|oczekujący wniosek]]|Są '''$1''' [[Special:ConfirmAccounts|oczekujące wnioski]]|Jest '''$1''' [[Special:ConfirmAccounts|oczekujących wniosków]]}}, z potwierdzonym adresem e‐mail",
	'confirmaccounts' => 'Potwierdź wniosek o założenie konta użytkownika',
	'confirmedit-desc' => 'Pozwala biurokratom akceptować wnioski o założenie konta użytkownika',
	'confirmaccount-maintext' => "'''Na tej stronie można potwierdzać wnioski o utworzenie konta w ''{{GRAMMAR:D.lp|{{SITENAME}}}}'''''.

Każda kolejka wniosków składa się z trzech kolejek podrzędnych: kolejka otwartych zapytań, kolejka zapytań, których realizacja została wstrzymana przez administratorów do czasu uzyskania przez nich większej ilości informacji, kolejka niedawno odrzuconych wniosków.

Odpowiadając na wniosek przyjrzyj mu się dokładnie, a jeśli jest to konieczne, potwierdź zawarte w nim informacje.
Twoje działania są zapisywane z poszanowaniem prywatności.
Oprócz podejmowania samodzielnych działań, przyjrzyj się też działaniom innych administratorów.",
	'confirmaccount-list' => 'Poniżej znajduje się lista oczekujących wniosków o założenie konta.
Po zaakceptowaniu lub odrzuceniu, wniosek zostanie usunięty z niniejszej listy.',
	'confirmaccount-list2' => 'Poniżej znajduje się lista niedawno odrzuconych wniosków o założenie konta. Mogą one zostać automatycznie usunięte po kilku lub kilkunastu dniach.
Wnioski można nadal zrealizować, lecz zalecane jest wcześniejsze nawiązanie kontaktu z administratorem, który je odrzucił.',
	'confirmaccount-list3' => 'Poniżej znajduje się lista przeterminowanych wniosków o utworzenie konta. Wnioski są usuwane po kilku lub kilkunastu dniach.
Wnioski z tej listy nadal można zrealizować.',
	'confirmaccount-text' => "Poniżej znajduje się, oczekujący na rozpatrzenie, wniosek o konto w '''{{GRAMMAR:D.lp|{{SITENAME}}}}'''.

Przejrzyj zawarte w nim informacje. Jeśli zdecydujesz się wniosek przyjąć, zmień status konta na poniższej liście rozwijalnej.
Edycje wykonane w biografii osoby ubiegającej się o konto nie wpłyną na przechowywane w systemie referencje. Możesz utworzyć konto o innej nazwie, niż wybrana przez wnioskodawcę. Należy z tej możliwości korzystać tylko wtedy, gdy jest to konieczne z uwagi na konflikt z nazwą innego użytkownika.

Wniosek, którego nie potwierdzisz lub nie odrzucisz na tej stronie, pozostanie w stanie oczekiwania.",
	'confirmaccount-none-o' => 'Brak na liście otwartych wniosków o założenie konta użytkownika.',
	'confirmaccount-none-h' => 'Brak na liście wstrzymanych wniosków o założenie konta użytkownika.',
	'confirmaccount-none-r' => 'Brak na liście niedawno odrzuconych wniosków o założenie konta użytkownika.',
	'confirmaccount-none-e' => 'Brak na liście przeterminowanych wniosków o założenie konta użytkownika.',
	'confirmaccount-real-q' => 'Imię i nazwisko',
	'confirmaccount-email-q' => 'Adres e‐mail',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'otwarte wnioski o założenie konta',
	'confirmaccount-showrej' => 'odrzucone wnioski o założenie konta',
	'confirmaccount-showheld' => 'wstrzymane wnioski o założenie konta',
	'confirmaccount-showexp' => 'przeterminowane wnioski o założenie konta',
	'confirmaccount-review' => 'Przejrzyj',
	'confirmaccount-types' => 'Wybierz kolejkę z poniższej listy',
	'confirmaccount-all' => '(pokaż wszystkie kolejki)',
	'confirmaccount-type' => 'Kolejka:',
	'confirmaccount-type-0' => 'potencjalni autorzy',
	'confirmaccount-type-1' => 'potencjalni edytorzy',
	'confirmaccount-q-open' => 'otwarte wnioski o założenie konta',
	'confirmaccount-q-held' => 'wstrzymane wnioski o założenie konta',
	'confirmaccount-q-rej' => 'ostatnio odrzucone wnioski',
	'confirmaccount-q-stale' => 'przeterminowane wnioski o założenie konta',
	'confirmaccount-badid' => 'Z podanym identyfikatorem nie jest związany żaden wniosek o założenie konta.
Być może został on już obsłużony.',
	'confirmaccount-leg-user' => 'Konto użytkownika',
	'confirmaccount-leg-areas' => 'Główne zainteresowania',
	'confirmaccount-leg-person' => 'Dane osobowe',
	'confirmaccount-leg-other' => 'Inne informacje',
	'confirmaccount-name' => 'Nazwa użytkownika',
	'confirmaccount-real' => 'Imię i nazwisko',
	'confirmaccount-email' => 'Adres e‐mail',
	'confirmaccount-reqtype' => 'Stanowisko:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'redaktor',
	'confirmaccount-bio' => 'Biografia:',
	'confirmaccount-attach' => 'Życiorys:',
	'confirmaccount-notes' => 'Dodatkowe informacje:',
	'confirmaccount-urls' => 'Wykaz witryn:',
	'confirmaccount-none-p' => '(nie podano)',
	'confirmaccount-confirm' => 'Korzystając z poniższych opcji przyjmij, odrzuć lub wstrzymaj wniosek',
	'confirmaccount-econf' => '(potwierdzono)',
	'confirmaccount-reject' => '(odrzucone przez użytkownika [[User:$1|$1]], z powodu $2)',
	'confirmaccount-rational' => 'Uzasadnienie przesłane do wnioskodawcy:',
	'confirmaccount-noreason' => '(brak)',
	'confirmaccount-autorej' => '(wniosek został automatycznie odrzucony ze względu na brak aktywności)',
	'confirmaccount-held' => '(oznaczone jako „wstrzymane” przez użytkownika [[User:$1|$1]], z powodu $2)',
	'confirmaccount-create' => 'Zaakceptuj (utwórz konto)',
	'confirmaccount-deny' => 'Odrzuć (usuń z listy)',
	'confirmaccount-hold' => 'Wstrzymaj',
	'confirmaccount-spam' => 'Spam (nie wysyłaj wiadomości e‐mail)',
	'confirmaccount-reason' => 'Komentarz (zostanie dopisany do wiadomości e‐mail):',
	'confirmaccount-ip' => 'Adres IP:',
	'confirmaccount-submit' => 'Potwierdź',
	'confirmaccount-needreason' => 'Musisz podać uzasadnienie w polu poniżej.',
	'confirmaccount-canthold' => 'Ten wniosek został już wstrzymany lub usunięty.',
	'confirmaccount-acc' => 'Potwierdzono wniosek o założenie konta; utworzono konto dla użytkownika [[User:$1|$1]].',
	'confirmaccount-rej' => 'Odrzucono wniosek o utworzenie konta.',
	'confirmaccount-viewing' => '(aktualnie przeglądany przez użytkownika [[User:$1|$1]])',
	'confirmaccount-summary' => 'Tworzę stronę biografii nowego użytkownika.',
	'confirmaccount-welc' => "'''Witaj w ''{{GRAMMAR:N.lp|{{SITENAME}}}}''!''' Mamy nadzieję, że włączysz się aktywnie w tworzenie {{GRAMMAR:D.lp|{{SITENAME}}}}.
Zacznij od zapoznania się ze [[{{MediaWiki:Helppage}}|stronami pomocy]]. Jeszcze raz witamy i życzymy przyjemnej pracy!",
	'confirmaccount-wsum' => 'Witaj!',
	'confirmaccount-email-subj' => 'Wniosek o założenie konta użytkownika w {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'confirmaccount-email-body' => 'Złożony przez Ciebie w {{GRAMMAR:N.lp|{{SITENAME}}}} wniosek został zaakceptowany.

Nazwa użytkownika: $1

Hasło: $2

Z uwagi na bezpieczeństwo użytkowania, przy pierwszym logowaniu zostaniesz poproszony o zmianę hasła.
Zaloguj się na stronie {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Twoja prośba o konto została przyjęta na {{SITENAME}}.

Nazwa: $1

Hasło: $2

$3

Z powodów bezpieczeństwa będziesz musiał zmienić hasło przy pierwszym logowaniu.
By się zalogować przejdź do {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Niestety złożony przez Ciebie w {{GRAMMAR:MS.lp|{{SITENAME}}}} wniosek o założenie konta „$1” został odrzucony.

Możliwe przyczyny odrzucenia wniosku to:
nie wypełniłeś prawidłowo wszystkich pól wniosku, nie udzieliłeś odpowiednio obszernej odpowiedzi, lub w inny sposób nie wypełniłeś wniosku zgodne z przyjętymi kryteriami.
W serwisie na pewno odnajdziesz informacje, które pozwolą Ci dowiedzieć się więcej o zasadach zatwierdzania nowych kont użytkownika.',
	'confirmaccount-email-body4' => 'Przepraszamy, Twoja prośba o konto „$1” została odrzucona na {{GRAMMAR:MS.lp|{{SITENAME}}}}.

$2

Na stronie mogą znajdować się listy kontaktowe, których możesz użyć aby dowiedzieć się więcej na temat polityki kont.',
	'confirmaccount-email-body5' => 'Przed zatwierdzeniem złożonego przez Ciebie wniosku o konto „$1” w {{GRAMMAR:MS.lp|{{SITENAME}}}} musisz podać następujące informacje dodatkowe:

$2

Jeśli chcesz dowiedzieć się więcej o zasadach tworzenia kont w serwisie, poszukaj informacji na jego stronach.',
	'usercredentials' => 'Uprawnienia użytkownika',
	'usercredentials-leg' => 'Podejrzyj zatwierdzone informacje uwierzytelniające dotyczące użytkownika',
	'usercredentials-user' => 'Nazwa użytkownika:',
	'usercredentials-text' => 'Poniżej znajdują się zatwierdzone informacje uwierzytelniające na temat wybranego użytkownika.',
	'usercredentials-leg-user' => 'Konto użytkownika',
	'usercredentials-leg-areas' => 'Główne obszary zainteresowań',
	'usercredentials-leg-person' => 'Informacje osobiste',
	'usercredentials-leg-other' => 'Inne informacje',
	'usercredentials-email' => 'Adres e‐mail',
	'usercredentials-real' => 'Imię i nazwisko:',
	'usercredentials-bio' => 'Biografia:',
	'usercredentials-attach' => 'Życiorys:',
	'usercredentials-notes' => 'Dodatkowe informacje:',
	'usercredentials-urls' => 'Wykaz witryn:',
	'usercredentials-ip' => 'Oryginalny adres IP:',
	'usercredentials-member' => 'Prawa:',
	'usercredentials-badid' => 'Nie znaleziono informacji uwierzytelniających na temat tego użytkownika.
Sprawdź, czy prawidłowo wpisałeś nazwę konta.',
	'right-confirmaccount' => 'Przeglądanie [[Special:ConfirmAccounts|kolejki z wnioskami o założenie konta]]',
	'right-requestips' => 'Widoczność adresów IP podczas przetwarzania wniosków o założenie konta',
	'right-lookupcredentials' => 'Przeglądanie [[Special:UserCredentials|referencji użytkowników]]',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'requestaccount' => 'Ciamé un cont',
	'requestaccount-text' => "'''Ch'a completa e ch'a manda sta domanda-sì për ciamé ch'a-j deurbo sò cont utent'''. 

Per piasì, ch'a varda d'avèj present le [[{{MediaWiki:Requestaccount-page}}|Condission ëd servissi]], anans che deurb-se un cont. 

Na vira che 'l cont a sia aprovà, a l'arseivrà na notìfica për pòsta eletrònica e sò cont a sarà bon da dovré a l'adrëssa [[Special:UserLogin|intré ant ël sistema]].",
	'requestaccount-page' => '{{ns:project}}:Condission ëd Servissi',
	'requestaccount-dup' => "'''Ch'a ten-a present: al moment a l'é già andrinta al sistema ën dovrand un cont registrà.'''",
	'requestaccount-leg-user' => 'Cont utent',
	'requestaccount-leg-areas' => "Àree d'anteresse prinsipaj",
	'requestaccount-leg-person' => 'Anformassion përsonaj',
	'requestaccount-leg-other' => 'Àutre anformassion',
	'requestaccount-leg-tos' => 'Condission ëd Servissi',
	'requestaccount-acc-text' => "A soa adrëssa ëd pòsta eletrònica a-i rivërà un messagi, na vira che sta domanda a la sia mandà. Per piasì, ch'a n'arsponda ën dand-ie un colp col rat ansima a l'aniura ch'a treuva ant ël messagi. Ëdcò soa ciav a sarà recapità për pòsta eletrònica, na vira che sò cont a sia creà.",
	'requestaccount-areas-text' => "Selession-a j'argoment sota dont it l'has esperiensa formal o at piasrìa travajeje ansima.",
	'requestaccount-ext-text' => "St'anformassion-sì as ten privà e as dòvra mach për sta question-sì. S'a veul a peul buté dij contat coma un nùmer ëd telèfono për giuté a identifichesse sensa dubi.",
	'requestaccount-bio-text' => "Soa biografìa a sarà buta coma contnù base për soa pàgina utent. 
S'a peul, ch'a buta soe credensiaj, cole ch'a sio. 
Ch'a varda mach però dë buté dj'anformassion ch'a-j da gnun fastudi publiché. 
An tute le manere, a peul sempe cambiesse 'd nòm ën dovrand l'adrëssa [[Special:Preferences|Ij mè gust]].",
	'requestaccount-real' => 'Nòm vèir:',
	'requestaccount-same' => '(istess che sò nòm vèir)',
	'requestaccount-email' => 'Adrëssa ëd pòsta eletrònica:',
	'requestaccount-reqtype' => 'Posission:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografìa personal:',
	'requestaccount-attach' => 'Curriculum vitae (opsional):',
	'requestaccount-notes' => 'Nòte adissionaj:',
	'requestaccount-urls' => "Lista ëd sit ant sla Ragnà, s'a-i n'a-i é (buté un për riga):",
	'requestaccount-agree' => "A venta ch'a sertìfica che sò nòm vèir a l'é giust e ch'a l'é d'acòrdi con nòstre Condission ëd Servissi.",
	'requestaccount-inuse' => "Stë stranòm-sì a l'é già dovrà ant na domanda ch'a la speta d'esse aprovà.",
	'requestaccount-tooshort' => "Soa biografìa a l'ha dë esse longa almanch $1 {{PLURAL:$1|paròla|paròle}}.",
	'requestaccount-emaildup' => "N'àutra arcesta ëd cont an cors a deuvra la midema adrëssa ëd pòsta eletrònica.",
	'requestaccount-exts' => "Sta sòrt d'archivi as peul pa tachesse.",
	'requestaccount-resub' => "Për na question ëd sigurëssa a venta torna ch'a selession-a l'archivi ëd sò Curriculum Vitae. Ch'a lassa pura ël camp veujd s'a veul pì nen butelo.",
	'requestaccount-tos' => "I l'hai lesù le [[{{MediaWiki:Requestaccount-page}}|Condission ëd Servissi]] ëd {{SITENAME}} e i son d'acòrdi d'osserveje. Ël nòm ch'i l'hai butà sot a \"Nòm vèir\" a l'é mè nòm da bon.",
	'requestaccount-submit' => 'Fé domanda për ël cont',
	'requestaccount-sent' => "Soa domanda dë deurb-se un cont a l'é stàita arseivùa e a la speta d'esse aprovà.
Un mëssagi ëd conferma a l'é stàit mandà a soa adrëssa ëd pòsta eletrònica",
	'request-account-econf' => "Soa adrëssa ëd pòsta eletrònica a l'é staita confermà e a la sarà listà coma bon-a an soa domanda dë deurbe 'l cont.",
	'requestaccount-email-subj' => "Arcesta ëd conferma d'adrëssa ëd pòsta eletrònica da {{SITENAME}}",
	'requestaccount-email-body' => "Cheidun, ch'a l'é belfé ch'a sia chiel/chila, da 'nt l'adrëssa IP \$1 a l'ha ciamà dë deurbe un cont antestà a \"\$2\" ansima a {{SITENAME}} e a l'ha lassà st'adrëssa ëd pòsta eletrònica-sì. Për confermé che ës cont ansima a {{SITENAME}} a sarìa sò da bon, për piasì ch'a deurba ant sò navigator st'anliura-sì: \$3

Quand ël cont a vnirà creà, soa la ciav a sarà mandà mach a st'adrëssa-sì. Se për cas a fussa PA stait chiel/chila a fé la domanda, a basta ch'a n'arsponda nen d'autut. Ës còdes ëd conferma-sì a scad dël \$4.",
	'requestaccount-email-subj-admin' => 'arcesta ëd cont ëd {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" a l\'ha ciamà un cont e a speta la conferma.
L\'adrëssa ëd pòsta eletrònica a l\'é stàita confermà. A peul confermé l\'arcesta ambelessì "$2".',
	'acct_request_throttle_hit' => "A l'ha gia ciamà {{PLURAL:$1|1 cont|$1 cont}}. 
Për darmagi ant ës moment-sì i podoma nen aceté dj'àotre domande da chiel/chila.",
	'requestaccount-loginnotice' => "Për deurb-se un sò cont utent, a venta '''[[Special:RequestAccount|ch<nowiki>'</nowiki>a në ciama un]]'''.",
	'confirmaccount-newrequests' => "Al moment a-i é '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|arcesta duverta an cors|arceste duverte an cors}} ëd cont]]",
	'confirmaccounts' => 'Conferma dle domande ëd cont neuv da deurbe',
	'confirmedit-desc' => "A dà ai mangiapapé l'abilità ëd confermé j'arceste ëd cont",
	'confirmaccount-maintext' => "'''Sta pàgina-sì a l'é dovrà për confermé j'arceste an cors ëd cont a ''{{SITENAME}}'''''.

Minca coa d'arceste ëd cont a consist ëd tre sotcoe.
Un-a për arceste doverte, un-a për cole ch'a son ëstàite butà an sospèis da àutri aministrator spetand d'àutre anformassion, e n'àutra për j'arceste arfudà ultimament.

Quand ch'a rispond a n'arcesta, ch'a la considera con atension e, s'a-i é dabzògn, ch'a conferma j'anformassion contnùe andrinta.
Soe assion a saran registrà an privà.
A dovrìa ëdcò revisioné minca atività ch'a ven fàita ambelessì an dzorpì ëd lòn ch'a fa chiel-midem.",
	'confirmaccount-list' => "Ambelessì sota a-i é na lista ëd domanda ch'a speto d'esse aprovà. Ij cont aprovà a saran creà e peuj gavà via da 'n sta lista. Ij cont arfudà a saran mach dëscancelà da 'nt la lista.",
	'confirmaccount-list2' => "Ambelessì sota a-i é na lista ëd coint ch'a son stait arfudà ant j'ùltim temp, e ch'a l'é belfé ch'a ven-o scancelà n'aotomàtich na vira ch'a sia passa-ie chèich dì dal giudissi negativ. Ën vorend as peulo anco' sempe aprovesse bele che adess, ma miraco un a veul sente l'aministrator ch'a l'ha arfudaje, anans che fé che fé.",
	'confirmaccount-list3' => "Sota a-i é na lista d'arceste ëd cont scadù ch'a peulo esse scancelà automaticament na vira veje vàire di.
A peulo esse ancó aprovà com cont.",
	'confirmaccount-text' => "Costa-sì a l'é n'arcesta an cors për un cont utent a '''{{SITENAME}}'''.

Ch'a contròla con atension j'anformassion sì-sota.
S'a apreuva st'arcesta-sì, ch'a deuvra la selession ëd posission për amposté lë stat dël cont ëd l'utent.
Modìfiche fàite a la biografìa dl'arcesta a l'avran pa efet an sla memorisassion dle credensiaj përmanente.
Ch'a armarca che a peul serne ëd creé ël cont sota un nòm utent diferent.
Ch'a deuvra sòn mach për evité colision con d'àutri nòm.

S'a lassrà sta pàgina-sì sensa confirmé o scancelé st'arcesta, a restrà an cors.",
	'confirmaccount-none-o' => 'A-i é al moment gnun-e arceste ëd cont an cors an costa lista-sì.',
	'confirmaccount-none-h' => 'A-i é al moment gnun-e arceste ëd cont an cors prenotà an sta lista-sì.',
	'confirmaccount-none-r' => 'A-i é al moment gnun-e arceste arfudà ëd recent ëd cont an sta lista-sì.',
	'confirmaccount-none-e' => 'A-i é al moment gnun-e arceste ëd cont scadùe an sta lista-sì.',
	'confirmaccount-real-q' => 'Nòm',
	'confirmaccount-email-q' => 'Adrëssa ëd pòsta eletrònica',
	'confirmaccount-bio-q' => 'Biografìa',
	'confirmaccount-showopen' => 'arceste duverte',
	'confirmaccount-showrej' => 'arceste arfudà',
	'confirmaccount-showheld' => 'arceste tnùe fërme',
	'confirmaccount-showexp' => 'arceste scadùe',
	'confirmaccount-review' => 'Aprové/Arfudé',
	'confirmaccount-types' => 'Selession-a na coa ëd conferma ëd cont da sota:',
	'confirmaccount-all' => '(mostra tute le coe)',
	'confirmaccount-type' => 'Coa:',
	'confirmaccount-type-0' => 'autor potensiaj',
	'confirmaccount-type-1' => 'editor potensiaj',
	'confirmaccount-q-open' => 'arceste duverte',
	'confirmaccount-q-held' => 'arceste tnùe fërme',
	'confirmaccount-q-rej' => 'arceste arfudà ultimament',
	'confirmaccount-q-stale' => 'arceste scadùe',
	'confirmaccount-badid' => "A-i é gnun-a domanda duvèrta ch'a-j corisponda a l'identificativ ch'a l'ha butà. A peul esse ch'a la sia già staita tratà da cheidun d'àotr.",
	'confirmaccount-leg-user' => 'Cont utent',
	'confirmaccount-leg-areas' => "Àree d'anteresse prinsipaj",
	'confirmaccount-leg-person' => 'Anformassion përsonaj',
	'confirmaccount-leg-other' => 'Àutre anformassion',
	'confirmaccount-name' => 'Stranòm',
	'confirmaccount-real' => 'Nòm:',
	'confirmaccount-email' => 'Adrëssa ëd pòsta eletrònica:',
	'confirmaccount-reqtype' => 'Posission:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografìa:',
	'confirmaccount-attach' => 'Curriculum Vitae:',
	'confirmaccount-notes' => 'Nòte adissionaj:',
	'confirmaccount-urls' => 'Lista ëd sit ant sla Ragnà:',
	'confirmaccount-none-p' => '(pa dàit)',
	'confirmaccount-confirm' => "Ch'a dòvra j'opsion ambelessì sota për aprové, arfudé ò lassé an coa la domanda:",
	'confirmaccount-econf' => '(confermà)',
	'confirmaccount-reject' => '(arfudà da [[User:$1|$1]] dël $2)',
	'confirmaccount-rational' => 'Rason dàita al candidà:',
	'confirmaccount-noreason' => '(gnun)',
	'confirmaccount-autorej' => "(st'arcesta-sì a l'é stàita automaticament scartà a motiv d'inatività)",
	'confirmaccount-held' => '(marcà "an coa" da [[User:$1|$1]] dël $2)',
	'confirmaccount-create' => "Aceté (deurbe 'l cont)",
	'confirmaccount-deny' => "Arfudé (e gavé da 'nt la lista)",
	'confirmaccount-hold' => 'Lassé an coa',
	'confirmaccount-spam' => 'Rumenta ëd reclam (mand-je nen pòsta)',
	'confirmaccount-reason' => 'Coment (a-i resta andrinta al messagi postal):',
	'confirmaccount-ip' => 'Adrëssa IP:',
	'confirmaccount-legend' => 'Conferma/arfuda sto cont-sì',
	'confirmaccount-submit' => 'Confermé',
	'confirmaccount-needreason' => 'A venta specifiché na rason ant ël quàder ëd coment ambelessì sota.',
	'confirmaccount-canthold' => "St'arcesta-sì a l'é già o an considerassion o scancelà.",
	'confirmaccount-acc' => "Conferma dla domanda andaita a bonfin; a l'é dorbusse ël cont utent [[User:$1|$1]].",
	'confirmaccount-rej' => 'Arfud dla domanda andait a bonfin.',
	'confirmaccount-viewing' => "(al moment a l'é vist da [[User:$1|$1]])",
	'confirmaccount-summary' => "I soma antramentr ch'i foma na neuva pàgina utent con la biografìa dl'utent neuv.",
	'confirmaccount-welc' => "''Bin ëvnù/a  an ''{{SITENAME}}''!''' I speroma d'arsèive sò contribut e deje bon servissi. Miraco a peul ess-je d'agiut lese la session [[{{MediaWiki:Helppage}}|Amprende a travajé da zero]]. N'àotra vira, bin ëvnù/a e tante bele còse!",
	'confirmaccount-wsum' => 'Bin ëvnù/a!',
	'confirmaccount-email-subj' => 'Domanda dë deurbe un cont neuv ansima a {{SITENAME}}',
	'confirmaccount-email-body' => "Soa domanda dë deurbe un cont neuv ansima a {{SITENAME}} a l'é staita aprovà. Stranòm: $1 Ciav: $2

Për na question ëd sigurëssa a fa da manca che un as cambia soa ciav la prima vira ch'a rintra ant ël sistema. Për rintré, për piasì ch'a vada a l'adrëssa {{fullurl:Special:UserLogin}}.",
	'confirmaccount-email-body2' => "Soa domanda dë deurbe un cont neuv ansima a {{SITENAME}} a l'é staita aprovà. Stranòm: $1 Ciav: $2 $3

Për na question ëd sigurëssa un a venta ch'as cambia soa ciav la prima vira ch'a rintra ant ël sistema. Për rintré, për piasì ch'a vada a l'adrëssa {{fullurl:Special:UserLogin}}.",
	'confirmaccount-email-body3' => "Për darmagi soa domanda dë deurbe un cont ciamà \"\$1\" ansima a {{SITENAME}} a l'é staita bocià. A-i son vàire rason përchè sossì a peula esse rivà. A peul esse ch'a l'abia pa compilà giust la domanda, che soe arspòste a sio staite tròp curte, ò pura che an chèich àotra manera a l'abia falì da rintré ant ël criteri d'aprovassion. A peul esse che ant sël sit a sio specificà dle liste postaj ch'a peul dovré për ciamé pì d'anformassion ansima ai criteri d'aprovassion dovrà.",
	'confirmaccount-email-body4' => 'Për darmagi soa domanda dë deurbe un cont ciamà "$1" ansima a {{SITENAME}} a l\'é staita bocià. $2 A peul esse che ant sël sit a sio specificà dle liste postaj ch\'a peul dovré për ciamé pì d\'anformassion ansima ai criteri d\'aprovassion dovrà.',
	'confirmaccount-email-body5' => 'Anans che soa domanda dë deurbe un cont ciamà "$1" ansima a {{SITENAME}} a peula esse acetà, a dovrìa lassene dj\'anformassion adissionaj. $2 A peul esse che ant sël sit a sio specificà dle liste postaj ch\'a peul dovré për ciamé pì d\'anformassion ansima ai criteri d\'aprovassion dovrà.',
	'usercredentials' => 'Credensiaj utent.',
	'usercredentials-leg' => "Verìfica credensiaj confermà për n'utent",
	'usercredentials-user' => 'Nòm utent:',
	'usercredentials-text' => 'Sota a-i son le credensiaj validà dël cont utent selessionà.',
	'usercredentials-leg-user' => 'Cont utent.',
	'usercredentials-leg-areas' => "Àree d'anteresse prinsipaj",
	'usercredentials-leg-person' => 'Anformassion përsonaj',
	'usercredentials-leg-other' => 'Àutre anformassion',
	'usercredentials-email' => 'Pòsta eletrònica:',
	'usercredentials-real' => 'Nòm ver:',
	'usercredentials-bio' => 'Biografìa:',
	'usercredentials-attach' => 'Resumé:',
	'usercredentials-notes' => 'Nòte adissionaj:',
	'usercredentials-urls' => "Lista ëd sit an sl'aragnà:",
	'usercredentials-ip' => 'Adrëssa IP original:',
	'usercredentials-member' => 'Drit:',
	'usercredentials-badid' => "Gnun-e credensiaj trovà për st'utent-sì.
Ch'a contròla che ël nòm a sia scrivù da bin.",
	'right-confirmaccount' => 'Vardé la [[Special:ConfirmAccounts|coa con ij cont ciamà]]',
	'right-requestips' => "Vardé j'adrësse IP dël ciamant durant ël tratament dij cont ciamà",
	'right-lookupcredentials' => 'Visualisa [[Special:UserCredentials|credensiaj utent]]',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'requestaccount-leg-person' => 'ځاني مالومات',
	'requestaccount-leg-other' => 'نور مالومات',
	'requestaccount-real' => 'اصلي نوم:',
	'requestaccount-email' => 'برېښليک پته:',
	'requestaccount-level-0' => 'ليکوال',
	'requestaccount-bio' => 'شخصي ژوندليک:',
	'requestaccount-tooshort' => 'پکار ده چې ستاسو ژوندليک لږ تر لږه $1 لفظه اوږد وي.',
	'confirmaccount-real-q' => 'نوم',
	'confirmaccount-email-q' => 'برېښلیک',
	'confirmaccount-bio-q' => 'ژوندليک',
	'confirmaccount-showrej' => 'رټل شوې غوښتنې',
	'confirmaccount-review' => 'مخکتنه',
	'confirmaccount-leg-person' => 'ځاني مالومات',
	'confirmaccount-leg-other' => 'نور مالومات',
	'confirmaccount-name' => 'کارن-نوم',
	'confirmaccount-real' => 'نوم:',
	'confirmaccount-email' => 'برېښليک:',
	'confirmaccount-pos-0' => 'ليکوال',
	'confirmaccount-bio' => 'ژوندليک:',
	'confirmaccount-urls' => 'د وېبځايونو لړليک:',
	'confirmaccount-noreason' => '(هېڅ)',
	'confirmaccount-ip' => 'IP پته:',
	'confirmaccount-wsum' => 'ښه راغلاست!',
	'confirmaccount-email-body' => 'په {{SITENAME}} باندې د يوه کارن-حساب لپاره غوښتنه مو ومنل شوه .

د کارن-حساب نوم: $1

پټنوم: $2

د تحفظ د سببونو لپاره تاسو ته پکار ده چې د وروسته له دې چې د لومړي ځل لپاره غونډال ته ننوتلی نو مهرباني وکړی خپل پټنوم بدل کړی. د دې لپاره چې غونډال ته ننوځی، مهرباني وکړی {{fullurl:Special:UserLogin}} ولاړ شی.',
	'confirmaccount-email-body2' => 'په {{SITENAME}} باندې د يوه کارن-حساب لپاره غوښتنه مو ومنل شوه .

د کارن-حساب نوم: $1

پټنوم: $2

$3

د تحفظ د سببونو لپاره تاسو ته پکار ده چې د وروسته له دې چې د لومړي ځل لپاره غونډال ته ننوتلی نو مهرباني وکړی خپل پټنوم بدل کړی. د دې لپاره چې غونډال ته ننوځی، مهرباني وکړی {{fullurl:Special:UserLogin}} ولاړ شی.',
	'usercredentials-user' => 'کارن-نوم:',
	'usercredentials-leg-person' => 'ځاني مالومات',
	'usercredentials-leg-other' => 'نور مالومات',
	'usercredentials-email' => 'برېښليک:',
	'usercredentials-real' => 'اصلي نوم:',
	'usercredentials-bio' => 'ژوندليک:',
	'usercredentials-urls' => 'د وېبځايونو لړليک:',
	'usercredentials-member' => 'رښتې:',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'requestaccount' => 'Pedir conta',
	'requestaccount-text' => "'''Complete e submeta o seguinte formulário para pedir uma conta de utilizador'''.

Certifique-se de que lê primeiro os [[{{MediaWiki:Requestaccount-page}}|Termos de Serviço]] antes de pedir uma conta.

Assim que a conta for aprovada, ser-lhe-á enviada uma mensagem de notificação por correio electrónico e poderá [[Special:UserLogin|autenticar-se]].",
	'requestaccount-page' => '{{ns:project}}:Termos de Serviço',
	'requestaccount-dup' => "'''Nota: Já está autenticado com uma conta registada.'''",
	'requestaccount-leg-user' => 'Conta de utilizador',
	'requestaccount-leg-areas' => 'Principais áreas de interesse',
	'requestaccount-leg-person' => 'Informação pessoal',
	'requestaccount-leg-other' => 'Outras informações',
	'requestaccount-leg-tos' => 'Termos de Serviço',
	'requestaccount-acc-text' => 'Será enviada uma mensagem de confirmação para o seu endereço de correio electrónico assim que este pedido for submetido. Por favor, responda clicando na ligação de confirmação enviada na mensagem. A sua palavra-chave também será enviada por correio electrónico assim que a conta tenha sido criada.',
	'requestaccount-areas-text' => 'Seleccione abaixo as áreas em que possui experiência formal ou em que mais gostaria de trabalhar.',
	'requestaccount-ext-text' => 'A seguinte informação será mantida privada e só será usada para este pedido.
Talvez possa listar contactos, tais como o número de telefone, para ajudar na confirmação da identificação.',
	'requestaccount-bio-text' => 'Por omissão, a sua biografia será usada como conteúdo da sua página de utilizador.
Tente incluir algumas credenciais.
Assegure-se de que concorda com a publicação desta informação.
O seu nome pode ser alterado nas [[Special:Preferences|suas preferências]].',
	'requestaccount-real' => 'Nome real:',
	'requestaccount-same' => '(igual ao nome real)',
	'requestaccount-email' => 'Endereço de correio electrónico:',
	'requestaccount-reqtype' => 'Posição:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografia pessoal:',
	'requestaccount-attach' => 'Currículo (opcional):',
	'requestaccount-notes' => 'Notas adicionais:',
	'requestaccount-urls' => 'Lista de sítios na internet, se algum (um por linha):',
	'requestaccount-agree' => 'Deverá certificar-se que o seu nome real está correcto e que concorda com os nossos Termos de Serviço.',
	'requestaccount-inuse' => 'O nome de utilizador já está em uso num pedido de conta pendente.',
	'requestaccount-tooshort' => 'A sua biografia tem que ter pelo menos $1 {{PLURAL:$1|palavra|palavras}}.',
	'requestaccount-emaildup' => 'Um outro pedido de conta pendente usa o mesmo correio electrónico.',
	'requestaccount-exts' => 'O tipo de ficheiro do anexo não é permitido.',
	'requestaccount-resub' => 'O seu Currículo deve ser seleccionado novamente por razões de segurança. Deixe o campo em branco se já não desejar incluí-lo.',
	'requestaccount-tos' => 'Li e concordo reger-me pelos [[{{MediaWiki:Requestaccount-page}}|Termos de Serviço]] da {{SITENAME}}.
O nome que introduzi em "Nome real" é de facto o meu nome real.',
	'requestaccount-submit' => 'Pedir conta',
	'requestaccount-sent' => 'O seu pedido de conta foi enviado com sucesso e está agora pendente para aprovação.
Uma mensagem de confirmação foi enviada para o seu correio electrónico.',
	'request-account-econf' => 'O seu correio electrónico foi confirmado e será listado como tal no seu pedido de conta.',
	'requestaccount-email-subj' => 'Confirmação de endereço electrónico para a {{SITENAME}}',
	'requestaccount-email-body' => 'Alguém, provavelmente você a partir do endereço IP $1, pediu uma conta "$2" com este endereço de correio electrónico na {{SITENAME}}.

Para confirmar que esta conta realmente lhe pertence na {{SITENAME}}, siga esta ligação no seu navegador:

$3

Se a conta for criada, a palavra-chave só lhe será enviada a si. Se este pedido *não* foi feito por si, não siga a ligação.
Este código de confirmação expirará a $4.',
	'requestaccount-email-subj-admin' => 'Pedido de conta na {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" pediu uma conta e aguarda confirmação.
O endereço electrónico foi confirmado. Pode confirmar o pedido aqui "$2".',
	'acct_request_throttle_hit' => 'Desculpe, mas já pediu {{PLURAL:$1|uma conta|$1 contas}}.
Não pode fazer mais pedidos.',
	'requestaccount-loginnotice' => "Para obter uma conta de utilizador, deverá '''[[Special:RequestAccount|pedi-la]]'''.",
	'confirmaccount-newrequests' => "Há actualmente {{PLURAL:$1|'''um''' [[Special:ConfirmAccounts|pedido de conta]] em aberto, confirmado|'''$1''' [[Special:ConfirmAccounts|pedidos de conta]] em aberto, confirmados}} por correio electrónico, {{PLURAL:$1|pendente|pendentes}}.",
	'confirmaccounts' => 'Confirmar pedidos de conta',
	'confirmedit-desc' => 'Possibilita que utilizadores burocratas confirmem pedidos de conta',
	'confirmaccount-maintext' => "'''Esta página é usada para confirmar pedidos de conta pendentes na ''{{SITENAME}}'''''.

Cada fila de pedidos de conta consiste em três sub-filas, uma para pedidos em aberto, outra para pedidos colocados em espera por outros administradores à espera de mais informação e outra para pedidos recentemente rejeitados.

Quando responder a um pedido, reveja-o cuidadosamente e, se necessário, confirme a informação nele contida.
As suas acções será registadas em privado. Também é esperado que reveja qualquer actividade que  ocorra aqui para além das suas próprias acções.",
	'confirmaccount-list' => 'Abaixo encontra-se uma lista de pedidos de conta à espera de aprovação.
Contas aprovadas serão criadas e removidas desta lista. Contas rejeitadas serão simplesmente eliminadas desta lista.',
	'confirmaccount-list2' => 'Abaixo encontra-se uma lista de pedidos de conta recentemente rejeitados que serão automaticamente eliminados após alguns dias.
Estes podem ainda ser aprovados para novas contas, mas deverá verificar primeiro com o administrador que rejeitou o pedido antes de o aprovar.',
	'confirmaccount-list3' => 'Abaixo encontra-se uma lista de pedidos de conta expirados que poderão ser automaticamente apagados após alguns dias. Estes ainda podem ser aprovados e convertidos em novas contas.',
	'confirmaccount-text' => "Este é um pedido pendente para uma conta de utilizador na '''{{SITENAME}}'''.

Reveja cuidadosamente a informação abaixo.
Se está a aprovar este pedido, use a caixa de selecção de posição para estabelecer o estado da conta do utilizador.
Edições feitas à biografia da candidatura não afectarão nenhum armazenamento de credenciais permanente. Note que pode optar por criar a conta com um nome de utilizador diferente.
Use esta opção apenas para evitar colisões com outros nomes.

Se abandonar simplesmente esta página sem confirmar ou rejeitar este pedido, ele continuará pendente.",
	'confirmaccount-none-o' => 'Não há neste momento pedidos de conta pendentes em aberto nesta lista.',
	'confirmaccount-none-h' => 'Não há neste momento pedidos de conta pendentes em espera nesta lista.',
	'confirmaccount-none-r' => 'Não há neste momento pedidos de conta recentemente rejeitados nesta lista.',
	'confirmaccount-none-e' => 'Não há neste momento pedidos de conta expirados nesta lista.',
	'confirmaccount-real-q' => 'Nome',
	'confirmaccount-email-q' => 'Correio electrónico',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'pedidos em curso',
	'confirmaccount-showrej' => 'pedidos rejeitados',
	'confirmaccount-showheld' => 'Ver lista de pedidos de conta pendentes em espera',
	'confirmaccount-showexp' => 'pedidos expirados',
	'confirmaccount-review' => 'Aprovar/Rejeitar',
	'confirmaccount-types' => 'Seleccione uma fila de confirmação de contas abaixo:',
	'confirmaccount-all' => '(mostrar todas as filas)',
	'confirmaccount-type' => 'Fila seleccionada:',
	'confirmaccount-type-0' => 'autores expectáveis',
	'confirmaccount-type-1' => 'editores expectáveis',
	'confirmaccount-q-open' => 'pedidos em aberto',
	'confirmaccount-q-held' => 'pedidos em espera',
	'confirmaccount-q-rej' => 'pedidos recentemente rejeitados',
	'confirmaccount-q-stale' => 'pedidos expirados',
	'confirmaccount-badid' => 'Não existe nenhum pedido pendente correspondente ao identificador fornecido. Pode já ter sido processado.',
	'confirmaccount-leg-user' => 'Conta de utilizador',
	'confirmaccount-leg-areas' => 'Principais áreas de interesse',
	'confirmaccount-leg-person' => 'Informação pessoal',
	'confirmaccount-leg-other' => 'Outras informações',
	'confirmaccount-name' => 'Nome de utilizador',
	'confirmaccount-real' => 'Nome:',
	'confirmaccount-email' => 'Correio electrónico:',
	'confirmaccount-reqtype' => 'Posição:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografia:',
	'confirmaccount-attach' => 'Currículo:',
	'confirmaccount-notes' => 'Notas adicionais:',
	'confirmaccount-urls' => 'Lista de sítios na internet:',
	'confirmaccount-none-p' => '(não fornecido)',
	'confirmaccount-confirm' => 'Use as opções abaixo para aceitar, rejeitar, ou colocar em espera este pedido:',
	'confirmaccount-econf' => '(confirmado)',
	'confirmaccount-reject' => '(rejeitado por [[User:$1|$1]] em $2)',
	'confirmaccount-rational' => 'Explicação dada ao requerente:',
	'confirmaccount-noreason' => '(nenhum)',
	'confirmaccount-autorej' => '(este pedido foi automaticamente descartado devido a inactividade)',
	'confirmaccount-held' => '(marcado como "em espera" por [[User:$1|$1]] em $2)',
	'confirmaccount-create' => 'Aceitar (criar conta)',
	'confirmaccount-deny' => 'Rejeitar (retirar da lista)',
	'confirmaccount-hold' => 'Colocar em espera',
	'confirmaccount-spam' => "''Spam'' (não enviar correio electrónico)",
	'confirmaccount-reason' => 'Comentário (será incluído no correio electrónico):',
	'confirmaccount-ip' => 'Endereço IP:',
	'confirmaccount-legend' => 'Confirmar ou rejeitar esta conta',
	'confirmaccount-submit' => 'Confirmar',
	'confirmaccount-needreason' => 'Deverá fornecer um motivo na caixa de comentário abaixo.',
	'confirmaccount-canthold' => 'Este pedido já está em espera ou apagado.',
	'confirmaccount-acc' => 'Pedido de conta confirmado com sucesso; criada nova conta de utilizador [[User:$1|$1]].',
	'confirmaccount-rej' => 'Pedido de conta rejeitado com sucesso.',
	'confirmaccount-viewing' => '(a ser visto neste momento por [[User:$1|$1]])',
	'confirmaccount-summary' => 'Criar página de utilizador com biografia de novo utilizador.',
	'confirmaccount-welc' => "'''Bem-vindo à ''{{SITENAME}}''!''' Esperamos que contribua muito e bem.
Provavelmente quererá ler as [[{{MediaWiki:Helppage}}|páginas de ajuda]]. Mais uma vez, seja bem-vindo e divirta-se!",
	'confirmaccount-wsum' => 'Bem-vindo!',
	'confirmaccount-email-subj' => 'Pedido de conta na {{SITENAME}}',
	'confirmaccount-email-body' => 'O seu pedido de conta foi aprovado na {{SITENAME}}.

Nome da conta: $1

Palavra-chave: $2

Por questões de segurança, deverá mudar a sua palavra-chave após a primeira entrada. Para entrar, por favor vá a {{fullurl:{{ns:special}}:Userlogin}}.',
	'confirmaccount-email-body2' => 'O seu pedido de conta foi aprovado na {{SITENAME}}.

Nome da conta: $1

Palavra-chave: $2

$3

Por questões de segurança, deverá mudar a sua palavra-chave após a primeira entrada. Para entrar, por favor vá a {{fullurl:{{ns:special}}:Userlogin}}.',
	'confirmaccount-email-body3' => 'Desculpe, o seu pedido para a conta "$1" foi rejeitado na {{SITENAME}}.

Há várias formas de isto acontecer. Poderá não ter preenchido o formulário correctamente, não ter fornecido respostas de tamanho adequado, ou de outra forma não ter cumprido algumas normas e critérios. Podem existir listas de contactos no sítio que poderá usar se deseja saber mais sobre a política de contas de utilizador.',
	'confirmaccount-email-body4' => 'Desculpe, o seu pedido para a conta "$1" foi rejeitado na {{SITENAME}}.

$2

Podem haver listas de contactos no sítio que poderá usar se deseja saber mais sobre a política de contas de utilizador.',
	'confirmaccount-email-body5' => 'Antes que o seu pedido para a conta "$1" seja aceite na {{SITENAME}}, deverá fornecer alguma informação adicional.

$2

Podem haver listas de contactos no sítio que poderá usar se deseja saber mais sobre a política de contas de utilizador.',
	'usercredentials' => 'Credenciais do utilizador',
	'usercredentials-leg' => 'Procurar credenciais confirmadas para um utilizador',
	'usercredentials-user' => 'Nome de utilizador:',
	'usercredentials-text' => 'Abaixo estão as credenciais validadas da conta de utilizador seleccionada.',
	'usercredentials-leg-user' => 'Conta de utilizador',
	'usercredentials-leg-areas' => 'Principais áreas de interesse',
	'usercredentials-leg-person' => 'Informação pessoal',
	'usercredentials-leg-other' => 'Outras informações',
	'usercredentials-email' => 'Correio electrónico:',
	'usercredentials-real' => 'Nome real:',
	'usercredentials-bio' => 'Biografia:',
	'usercredentials-attach' => 'Currículo:',
	'usercredentials-notes' => 'Notas adicionais:',
	'usercredentials-urls' => 'Lista de sítios na internet:',
	'usercredentials-ip' => 'Endereço IP original:',
	'usercredentials-member' => 'Privilégios:',
	'usercredentials-badid' => 'Não foram encontradas credenciais para este utilizador. Verifique se o nome está correctamente escrito.',
	'right-confirmaccount' => 'Ver a [[Special:ConfirmAccounts|fila de contas pedidas]]',
	'right-requestips' => 'Ver os endereços IP do requerente ao processar contas pedidas',
	'right-lookupcredentials' => 'Ver [[Special:UserCredentials|credenciais de utilizador]]',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Heldergeovane
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'requestaccount' => 'Requisitar conta',
	'requestaccount-text' => "'''Complete e submeta o seguinte formulário para pedir uma conta de utilizador'''.

Certifique-se de que leu primeiro os [[{{MediaWiki:Requestaccount-page}}|Termos de Serviço]] antes de pedir uma conta.

Assim que a conta for aprovada, será enviada a você por email uma mensagem de notificação e a conta estará pronta para usar na [[Special:UserLogin|autenticação]].",
	'requestaccount-page' => '{{ns:project}}:Termos de Serviço',
	'requestaccount-dup' => "'''Nota: Você já está autenticado com uma conta registrada.'''",
	'requestaccount-leg-user' => 'Conta de utilizador',
	'requestaccount-leg-areas' => 'Principais áreas de interesse',
	'requestaccount-leg-person' => 'Informação pessoal',
	'requestaccount-leg-other' => 'Outras informações',
	'requestaccount-leg-tos' => 'Termos do Serviço',
	'requestaccount-acc-text' => 'Será enviada um mensagem de confirmação para o seu endereço de email assim que este pedido for submetido. Por favor, responda clicando na ligação de confirmação fornecida no email. A sua palavra-chave também lhe será enviada por email assim que a sua conta estiver criada.',
	'requestaccount-areas-text' => 'Selecione abaixo as áreas em que possui experiência formal ou em que gostaria de trabalhar mais.',
	'requestaccount-ext-text' => 'A seguinte informação é mantida privada e só será usada para este pedido.
Poderá querer listar contatos tal como o número de telefone para ajudar na confirmação da identificação.',
	'requestaccount-bio-text' => 'A sua biografia será usada como conteúdo padrão da sua página de utilizador.
Tente incluir algumas credenciais.
Assegure-se de que se encontra confortável em publicar tal informação.
O seu nome pode ser alterado nas [[Special:Preferences|suas preferências]].',
	'requestaccount-real' => 'Nome real:',
	'requestaccount-same' => '(igual ao nome real)',
	'requestaccount-email' => 'Endereço de e-mail:',
	'requestaccount-reqtype' => 'Posição:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografia pessoal:',
	'requestaccount-attach' => 'Curriculum Vitae (opcional):',
	'requestaccount-notes' => 'Notas adicionais:',
	'requestaccount-urls' => 'Lista de sítios web, se houver algum (separados por mudança de linha):',
	'requestaccount-agree' => 'Deverá certificar-se que o seu nome real está correto e que concorda com os nossos Termos de Serviço.',
	'requestaccount-inuse' => 'O nome de utilizador já está em uso num pedido de conta pendente.',
	'requestaccount-tooshort' => 'A sua biografia tem que ter pelo menos $1 {{PLURAL:$1|palavra|palavras}}.',
	'requestaccount-emaildup' => 'Um outro pedido de conta pendente usa o mesmo endereço de email.',
	'requestaccount-exts' => 'O tipo de arquivo do anexo não é permitido.',
	'requestaccount-resub' => 'O seu Curriculum Vitae deve ser selecionado novamente por razões de segurança. Deixe o campo em branco se já não desejar incluí-lo.',
	'requestaccount-tos' => 'Li e concordo reger-me pelos [[{{MediaWiki:Requestaccount-page}}|Termos de Serviço]] de {{SITENAME}}.
O nome que especifiquei em "Nome real" é de fato o meu nome real.',
	'requestaccount-submit' => 'Requisitar conta',
	'requestaccount-sent' => 'O seu pedido de conta foi enviado com sucesso e está agora com a confirmação pendente.
Um e-mail de confirmação foi enviado para seu endereço de e-mail.',
	'request-account-econf' => 'O seu endereço de email foi confirmado e será listado como tal no seu pedido de conta.',
	'requestaccount-email-subj' => 'Confirmação de endereço de email para {{SITENAME}}',
	'requestaccount-email-body' => 'Alguém, provavelmente você a partir do endereço IP $1, requisitou uma conta "$2" com este endereço de email em {{SITENAME}}.

Para confirmar que esta conta realmente lhe pertence em {{SITENAME}}, abra esta ligação no seu navegador:

$3

Se a conta for criada, apenas a você será enviada a palavra-chave. Se esta pessoa *não* for você, não siga a ligação.
Este código de confirmação expirará em $4.',
	'requestaccount-email-subj-admin' => 'Requisição de conta em {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" requisitou uma conta e aguarda confirmação.
O endereço de email foi confirmado. Você pode confirmar a requisição aqui "$2".',
	'acct_request_throttle_hit' => 'Desculpe, mas você já requisitou {{PLURAL:$1|1 conta|$1 contas}}.
Não pode fazer mais pedidos.',
	'requestaccount-loginnotice' => "Para obter uma conta de utilizador, deverá '''[[Special:RequestAccount|requisitá-la]]'''.",
	'confirmaccount-newrequests' => "Há atualmente '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|requisições de conta]] aberto pendente|[[Special:ConfirmAccounts|requisições de conta]] abertos pendentes}}.",
	'confirmaccounts' => 'Confirmar requisições de conta',
	'confirmedit-desc' => 'Possibilita aos burocratas confirmar requisições de conta',
	'confirmaccount-maintext' => "'''Esta página é usada para confirmar requisições de conta pendentes em ''{{SITENAME}}'''''.

Cada fila de requisições de conta consiste em três sub-filas, uma para requisições em aberto, outras para aquelas que foram colocados em espera por outros administradores à espera de mais informação, e outra para requisições recentemente rejeitadas.

Quando responder a uma requisição, reveja-o cuidadosamente e, se necessário, confirme a informação nela contida.
As suas ações serão registadas privadamente. Também é esperado que você reveja qualquer atividade que ocorra aqui além das suas próprias ações.",
	'confirmaccount-list' => 'Abaixo encontra-se uma lista de requisições de conta à espera de aprovação.
Contas aprovadas serão criadas e removidas desta lista. Contas rejeitadas serão simplesmente eliminadas desta lista.',
	'confirmaccount-list2' => 'Abaixo encontra-se uma lista de requisições de conta recentemente rejeitadas que serão automaticamente eliminadas após alguns dias.
Estas podem ainda ser aprovadas para novas contas, mas deverá verificar primeiro com o administrador que rejeitou a requisição antes de a aprovar.',
	'confirmaccount-list3' => 'Abaixo encontra-se uma lista de requisições de conta expiradas que poderão ser automaticamente apagadas após alguns dias. Estas ainda podem ser aprovadas e convertidas em novas contas.',
	'confirmaccount-text' => "Isto é uma requisição pendente para uma conta de utilizador em '''{{SITENAME}}'''.

Reveja cuidadosamente a informação abaixo. Se está aprovando esta requisição, use a caixa de seleção de posição para estabelecer o estado da conta do utilizador.
Edições feitas à biografia da candidatura não afetarão nenhum armazenamento de credenciais permanente. Note que pode optar por criar a conta com um nome de utilizador diferente.
Use esta possibilidade apenas para evitar colisões com outros nomes.

Se simplesmente abandonar esta página sem confirmar ou rejeitar esta requisição, ela continuará pendente.",
	'confirmaccount-none-o' => 'Atualmente não existem requisições de conta pendentes em aberto nesta lista.',
	'confirmaccount-none-h' => 'Atualmente não existem requisições de conta pendentes em espera nesta lista.',
	'confirmaccount-none-r' => 'Atualmente não existem requisições de conta recentemente rejeitadas nesta lista.',
	'confirmaccount-none-e' => 'Não há neste momento requisições de conta expiradas nesta lista.',
	'confirmaccount-real-q' => 'Nome',
	'confirmaccount-email-q' => 'Email',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'requisições em aberto',
	'confirmaccount-showrej' => 'requisições rejeitadas',
	'confirmaccount-showheld' => 'ver lista de requisições de conta em espera',
	'confirmaccount-showexp' => 'requisições expiradas',
	'confirmaccount-review' => 'Aprovar/Rejeitar',
	'confirmaccount-types' => 'Selecione uma fila de confirmação de contas abaixo:',
	'confirmaccount-all' => '(mostrar todas as filas)',
	'confirmaccount-type' => 'Fila selecionada:',
	'confirmaccount-type-0' => 'prováveis autores',
	'confirmaccount-type-1' => 'prováveis editores',
	'confirmaccount-q-open' => 'requisições em aberto',
	'confirmaccount-q-held' => 'requisições em espera',
	'confirmaccount-q-rej' => 'requisições recentemente rejeitadas',
	'confirmaccount-q-stale' => 'requisições expiradas',
	'confirmaccount-badid' => 'Não existe nenhuma requisição pendente correspondente ao identificador fornecido. Ela pode já ter sido tratada.',
	'confirmaccount-leg-user' => 'Conta de utilizador',
	'confirmaccount-leg-areas' => 'Principais áreas de interesse',
	'confirmaccount-leg-person' => 'Informação pessoal',
	'confirmaccount-leg-other' => 'Outras informações',
	'confirmaccount-name' => 'Nome de utilizador',
	'confirmaccount-real' => 'Nome:',
	'confirmaccount-email' => 'Email:',
	'confirmaccount-reqtype' => 'Posição:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografia:',
	'confirmaccount-attach' => 'Curriculum Vitae:',
	'confirmaccount-notes' => 'Notas adicionais:',
	'confirmaccount-urls' => 'Lista de sítios web:',
	'confirmaccount-none-p' => '(não fornecido)',
	'confirmaccount-confirm' => 'Use as opções abaixo para aceitar, rejeitar, ou colocar em espera esta requisição:',
	'confirmaccount-econf' => '(confirmado)',
	'confirmaccount-reject' => '(rejeitado por [[User:$1|$1]] em $2)',
	'confirmaccount-rational' => 'Explicação dada ao requerente:',
	'confirmaccount-noreason' => '(nenhum)',
	'confirmaccount-autorej' => '(esta requisição foi automaticamente descartada devido a inatividade)',
	'confirmaccount-held' => '(marcado como "em espera" por [[User:$1|$1]] em $2)',
	'confirmaccount-create' => 'Aceitar (criar conta)',
	'confirmaccount-deny' => 'Rejeitar (retirar da lista)',
	'confirmaccount-hold' => 'Colocar em espera',
	'confirmaccount-spam' => 'Spam (não enviar email)',
	'confirmaccount-reason' => 'Comentário (será incluído no email):',
	'confirmaccount-ip' => 'Endereço IP:',
	'confirmaccount-submit' => 'Confirmar',
	'confirmaccount-needreason' => 'Deverá fornecer um motivo na caixa de comentário abaixo.',
	'confirmaccount-canthold' => 'Esta requisição já está em espera ou apagada.',
	'confirmaccount-acc' => 'Requisição de conta confirmada com sucesso; criada nova conta de utilizador [[User:$1|$1]].',
	'confirmaccount-rej' => 'Requisiçãode conta rejeitada com sucesso.',
	'confirmaccount-viewing' => '(atualmente sendo visualizada por [[User:$1|$1]])',
	'confirmaccount-summary' => 'Criar página de utilizador com biografia de novo utilizador.',
	'confirmaccount-welc' => "'''Bem-vindo a ''{{SITENAME}}''!''' Esperamos que contribua muito e bem.
Provavelmente desejará ler as [[{{MediaWiki:Helppage}}|páginas de ajuda]]. Mais uma vez, seja bem-vindo e divirta-se!",
	'confirmaccount-wsum' => 'Bem-vindo!',
	'confirmaccount-email-subj' => 'Requisição de conta em {{SITENAME}}',
	'confirmaccount-email-body' => 'A sua requisição de conta foi aprovada em {{SITENAME}}.

Nome da conta: $1

Palavra-chave: $2

Por questões de segurança, deverá mudar a sua palavra-chave após a primeira autenticação. Para entrar, por favor vá até {{fullurl:{{ns:special}}:Userlogin}}.',
	'confirmaccount-email-body2' => 'A sua requisição de conta foi aprovada em {{SITENAME}}.

Nome da conta: $1

Palavra-chave: $2

$3

Por questões de segurança, deverá mudar a sua palavra-chave após a primeira autenticação. Para entrar, por favor vá até {{fullurl:{{ns:special}}:Userlogin}}.',
	'confirmaccount-email-body3' => 'Desculpe, a sua requisição para a conta "$1" foi rejeitada em {{SITENAME}}.

Há várias formas para isto acontecer. Você pode não ter preenchido o formulário corretamente, não ter fornecido respostas de tamanho adequado, ou de outra forma ter falhado em alguns dos critérios da política. Poderá haver listas de contatos no sítio que poderá usar se desejar saber mais sobre a política de contas de utilizador.',
	'confirmaccount-email-body4' => 'Desculpe, a sua requisição para a conta "$1" foi rejeitada em {{SITENAME}}.

$2

Poderá haver listas de contatos no sítio que poderá usar se desejar saber mais sobre a política de contas de utilizador.',
	'confirmaccount-email-body5' => 'Antes que a sua requisição para a conta "$1" seja aceita em {{SITENAME}}, deverá fornecer alguma informação adicional.

$2

Podem haver listas de contatos no sítio que poderá usar se desejar saber mais sobre a política de contas de utilizador.',
	'usercredentials' => 'Credenciais do utilizador',
	'usercredentials-leg' => 'Procurar credenciais confirmadas para um utilizador',
	'usercredentials-user' => 'Nome de utilizador:',
	'usercredentials-text' => 'Abaixo estão as credenciais validadas da conta de utilizador selecionada.',
	'usercredentials-leg-user' => 'Conta de utilizador',
	'usercredentials-leg-areas' => 'Principais áreas de interesse',
	'usercredentials-leg-person' => 'Informação pessoal',
	'usercredentials-leg-other' => 'Outras informações',
	'usercredentials-email' => 'Email:',
	'usercredentials-real' => 'Nome real:',
	'usercredentials-bio' => 'Biografia:',
	'usercredentials-attach' => 'Curriculum Vitae:',
	'usercredentials-notes' => 'Notas adicionais:',
	'usercredentials-urls' => 'Lista de sítios web:',
	'usercredentials-ip' => 'Endereço IP original:',
	'usercredentials-member' => 'Privilégios:',
	'usercredentials-badid' => 'Não foram encontradas credenciais para este utilizador. Verifique se o nome está escrito corretamente.',
	'right-confirmaccount' => 'Visualizar a [[Special:ConfirmAccounts|fila com contas requisitadas]]',
	'right-requestips' => 'Visualizar os endereços de IP durante o processamento das contas pedidas.',
	'right-lookupcredentials' => 'Visualizar [[Special:UserCredentials|credenciais de usuário]]',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'requestaccount-real' => 'Ism n dṣṣaḥ :',
	'usercredentials-real' => 'Ism n dṣṣaḥ :',
);

/** Rhaeto-Romance (Rumantsch) */
$messages['rm'] = array(
	'confirmaccount-real-q' => 'Num',
	'confirmaccount-name' => "Num d'utilisader",
	'confirmaccount-real' => 'Num:',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'requestaccount' => 'Solicitare deschidere cont',
	'requestaccount-text' => "'''Completează şi aplică următorul formular pentru a cere deschiderea unui cont de utilizator'''.

Asigură-te că ai citit [[{{MediaWiki:Requestaccount-page}}|Termenii]] înainte de a cere deschiderea unui cont.

După ce contul va fi aprobat, vei fi anunţat printr-un mesaj trimis prin e-mail, iar contul va putea fi accesat apelând [[Special:UserLogin|autentificare]].",
	'requestaccount-page' => '{{ns:project}}:Termeni',
	'requestaccount-leg-user' => 'Cont de utilizator',
	'requestaccount-leg-areas' => 'Arii principale de interes',
	'requestaccount-leg-person' => 'Informaţii personale',
	'requestaccount-leg-other' => 'Alte informaţii',
	'requestaccount-bio-text' => 'Biografia ta va fi introdusă automat în pagina ta de utilizator.
Încearcă să incluzi referiri la diplome care să ateste cunoştinţele tale.
Asigură-te că publicarea acestora nu-ţi aduce prejudicii.
Numele tău poate fi schimbat din [[Special:Preferences|preferinţele tale]].',
	'requestaccount-real' => 'Nume real:',
	'requestaccount-same' => '(acelaşi cu numele real)',
	'requestaccount-email' => 'Adresă e-mail:',
	'requestaccount-reqtype' => 'Poziţie:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-bio' => 'Biografie personală:',
	'requestaccount-attach' => 'CV (opţional):',
	'requestaccount-notes' => 'Note adiţionale:',
	'requestaccount-agree' => 'Trebuie să certifici că numele tău real este corect introdus şi că accepţi Termenii Serviciului.',
	'requestaccount-inuse' => 'Numele de utilizator este deja folosit într-o cerere de deschidere de cont în aşteptare.',
	'requestaccount-tooshort' => 'Biografia ta trebuie să conţină cel puţin $1 {{PLURAL:$1|cuvânt|cuvinte}}.',
	'requestaccount-tos' => 'Am citit şi accept să respect [[{{MediaWiki:Requestaccount-page}}|Termenii]] sitului {{SITENAME}}.
Numele pe care l-am introdus în câmpul "Nume real" este numele meu real.',
	'requestaccount-submit' => 'Solicitare deschidere cont',
	'request-account-econf' => 'Adresa ta de e-mail a fost confirmată şi va fi listată în cererea de deschidere de cont.',
	'requestaccount-email-subj' => '{{SITENAME}} confirmare adresă e-mail',
	'requestaccount-email-body' => 'Cineva, probabil tu de la adresa IP $1, a cerut deschiderea unui cont "$2" cu această adresă de e-mail în {{SITENAME}}.

Pentru a confirma că într-adevăr adresa întrodusă în {{SITENAME}} îţi aparţine, deschide legătura următoare în programul tău de navigare pe internet:

$3

Dacă acest cont a fost creat, doar ţie îţi va fi trimisă parola.
Dacă acest mesaj nu-ţi este destinat, nu deschide legătura.
Codul de confirmare expiră în $4.',
	'requestaccount-email-body-admin' => '"$1" a cerut deschiderea unui cont şi aşteaptă confirmarea.
Adresa de e-mail a fost confirmată. Poţi confirma cererea aici "$2".',
	'confirmaccount-real-q' => 'Nume',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showopen' => 'cereri deschise',
	'confirmaccount-showrej' => 'cereri respinse',
	'confirmaccount-showexp' => 'cereri expirate',
	'confirmaccount-q-open' => 'cereri deschise',
	'confirmaccount-q-rej' => 'cereri respinse recent',
	'confirmaccount-q-stale' => 'cereri expirate',
	'confirmaccount-leg-user' => 'Cont de utilizator',
	'confirmaccount-leg-areas' => 'Arii principale de interes',
	'confirmaccount-leg-person' => 'Informaţii personale',
	'confirmaccount-leg-other' => 'Alte informaţii',
	'confirmaccount-name' => 'Nume de utilizator',
	'confirmaccount-real' => 'Nume:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Poziţie:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-bio' => 'Biografie:',
	'confirmaccount-attach' => 'CV:',
	'confirmaccount-notes' => 'Note adiţionale:',
	'confirmaccount-urls' => 'Listă de situri web:',
	'confirmaccount-econf' => '(confirmat)',
	'confirmaccount-rational' => 'Motiv oferit aplicantului:',
	'confirmaccount-create' => 'Acceptare (crează cont)',
	'confirmaccount-deny' => 'Respinge (delist)',
	'confirmaccount-hold' => 'Reţine',
	'confirmaccount-spam' => 'Spam (nu trimite e-mail)',
	'confirmaccount-reason' => 'Comentariu (va fi inclus în e-mail):',
	'confirmaccount-ip' => 'Adresă IP:',
	'confirmaccount-submit' => 'Confirmă',
	'confirmaccount-wsum' => 'Bun venit!',
	'usercredentials-user' => 'Nume de utilizator:',
	'usercredentials-leg-user' => 'Cont de utilizator',
	'usercredentials-leg-areas' => 'Arii principale de interes',
	'usercredentials-leg-person' => 'Informaţii personale',
	'usercredentials-leg-other' => 'Alte informaţii',
	'usercredentials-email' => 'E-mail:',
	'usercredentials-real' => 'Nume real:',
	'usercredentials-bio' => 'Biografie:',
	'usercredentials-attach' => 'CV:',
	'usercredentials-notes' => 'Note adiţionale:',
	'usercredentials-urls' => 'Listă de situri web:',
	'usercredentials-ip' => 'Adresă IP originală:',
	'usercredentials-member' => 'Drepturi:',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'confirmaccount-leg-user' => "Cunde de l'utende",
	'confirmaccount-leg-areas' => 'Prengepàle aree de inderesse',
	'confirmaccount-leg-person' => "'Mbormaziune personele",
	'confirmaccount-leg-other' => "Otre 'mbormaziune",
	'confirmaccount-name' => "Nome de l'utende",
	'confirmaccount-real' => 'Nome:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Posizione:',
	'confirmaccount-pos-0' => 'autore',
	'confirmaccount-pos-1' => 'cangiatore',
	'confirmaccount-bio' => 'Biografije:',
	'confirmaccount-attach' => 'Riepileghe/CV:',
	'confirmaccount-notes' => 'Note aggiundive:',
	'confirmaccount-urls' => 'Liste de le site web:',
	'confirmaccount-none-p' => "(non g'è previste)",
	'confirmaccount-confirm' => "Ause l'opzione de sotte pe accettà, scettà o tine sta richieste:",
	'confirmaccount-econf' => '(confermete)',
	'confirmaccount-reject' => '(scettete da [[User:$1|$1]] sus a $2)',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Kaganer
 * @author Kv75
 * @author Lockal
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'requestaccount' => 'Запрос учётной записи',
	'requestaccount-text' => "'''Заполните и отправьте следующую форму запроса учётной записи.'''

Перед подачей запроса, пожалуйста, прочитайте [[{{MediaWiki:Requestaccount-page}}|Условия предоставления услуг]].

После того, как учётная запись будет одобрена, вам придёт уведомление по электронной почте и учётную запись можно будет
[[Special:UserLogin|использовать для авторизации]].",
	'requestaccount-page' => '{{ns:project}}:Условия предоставления услуг',
	'requestaccount-dup' => "'''Примечание: вы уже представились системе с зарегистрированной учётной записи.'''",
	'requestaccount-leg-user' => 'Учётная запись',
	'requestaccount-leg-areas' => 'Основные области интересов',
	'requestaccount-leg-person' => 'Личные сведения',
	'requestaccount-leg-other' => 'Прочая информация',
	'requestaccount-leg-tos' => 'Правила использования',
	'requestaccount-acc-text' => 'После отправки заявки на ваш адрес будет отправлено письмо с запросом подтверждения. Пожалуйста, нажмите на ссылку в письме, чтобы дать подтверждение. Пароль будет отправлен вам по почте, когда ваша учётная запись будет создана.',
	'requestaccount-areas-text' => 'Выберите области, в которых вы компетентны или в которых собираетесь работать в наибольшей степени.',
	'requestaccount-ext-text' => 'Следующая информация будет сохранена в секрете и будет использована только для обработки данного запроса.
	Вы можете перечислить способы связи, например, номер телефона, чтобы помочь в подтверждении идентичности.',
	'requestaccount-bio-text' => 'Ваша биография будет по умолчанию помещена на вашу личную страницу.
Попробуйте включить какие-либо удостоверения личности.
Убедитесь, что вы не против публикации этой информации.
Ваше имя может быть изменено с помощью [[Special:Preferences|ваших персональных настроек]].',
	'requestaccount-real' => 'Настоящее имя:',
	'requestaccount-same' => '(такая же как и настоящее имя)',
	'requestaccount-email' => 'Электронная почта:',
	'requestaccount-reqtype' => 'Должность:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'редактор',
	'requestaccount-bio' => 'Личная биография:',
	'requestaccount-attach' => 'Резюме (необязательно):',
	'requestaccount-notes' => 'Дополнительные замечания:',
	'requestaccount-urls' => 'Список веб-сайтов, если есть (по одному на каждой строчке):',
	'requestaccount-agree' => 'Вы должны подтвердить, что ваше настоящее имя указано правильно и вы согласны с нашими Условиями предоставления услуг.',
	'requestaccount-inuse' => 'Имя участника уже указано в одном из запросов на учётную запись.',
	'requestaccount-tooshort' => 'Ваша биография должна содержать не менее $1 {{PLURAL:$1|слова|слов|слов}}.',
	'requestaccount-emaildup' => 'В другом необработанном запросе на получение учётной записи указан такой же адрес электронной почты.',
	'requestaccount-exts' => 'Присоединение данного типа файлов запрещено.',
	'requestaccount-resub' => 'В целях безопасности, ваш файл с резюме должен быть заменён. Оставьте поле пустым,
	если вы не желаете отправлять резюме.',
	'requestaccount-tos' => 'Я прочитал и соглашаюсь следовать [[{{MediaWiki:Requestaccount-page}}|Условиям предоставления услуг]] проекта {{SITENAME}}.
Имя, которое я указал в поле «Настоящее имя», действительно является моим настоящим именем.',
	'requestaccount-submit' => 'Запросить учётную запись',
	'requestaccount-sent' => 'Ваш запрос на получение учётной записи был успешно отправлен и теперь ожидает обработки.
На ваш адрес было отправлено письмо с уведомлением.',
	'request-account-econf' => 'Ваш адрес электронной почты был подтверждён и будет указан в вашем запросе учётной записи.',
	'requestaccount-email-subj' => '{{SITENAME}}: подтверждение по эл. почте',
	'requestaccount-email-body' => 'Кто-то (вероятно, вы) с IP-адреса $1 запросил на сайте {{SITENAME}},
учётную запись «$2» и указал данный адрес электронной почты.

Чтобы подтвердить, что это учётная запись на сервере {{SITENAME}} действительно принадлежит вам,
откройте следующую ссылку в браузере:

$3

После создания учётной записи, только вам может быть отправлен пароль.
Если к вам данное сообщение *не* относится — не переходите по ссылке.

Этот код активации прекратит действие $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}}: запрос учётной записи',
	'requestaccount-email-body-admin' => '«$1» запросил создание учётной записи и ожидает подтверждения.
Адрес электронной почты был подтверждён. Вы можете подтвердить заявку здесь «$2».',
	'acct_request_throttle_hit' => 'Извините, но вы уже запросили $1 {{PLURAL:$1|учётную запись|учётные записи|учётных записей}}.
Больше делать запросов вы не можете.',
	'requestaccount-loginnotice' => 'Чтобы получить учётную запись, вы должны её [[Special:RequestAccount|запросить]].',
	'confirmaccount-newrequests' => "Ожидается обработка '''$1'''
{{PLURAL:$1|[[Special:ConfirmAccounts|запроса на учётную запись]]|[[Special:ConfirmAccounts|запросов на учётные записи]]|[[Special:ConfirmAccounts|запросов на учётные записи]]}}.",
	'confirmaccounts' => 'Подтверждение запросов учётных записей',
	'confirmedit-desc' => 'Даёт бюрократам возможность подтверждать запросы на учётные записи',
	'confirmaccount-maintext' => "'''Эта страница используется для подтверждения заявок на учётные записи проекта «{{SITENAME}}»'''.

Каждая очередь заявок состоит из трёх частей: открытые заявки; заявки отложенные администраторами до получения дополнительной информации; недавно отклонённые заявки.

Открыв заявку, внимательно просмотрите её, при необходимости, проверьте содержащуюся в ней информацию. Ваши действия будет записаты в журнал. Ожидается, что ваша работа по просмотру и подтверждению заявок будет независима от того, чем вы занимаетесь.",
	'confirmaccount-list' => 'Ниже приведён список запросов на учётные записи, ожидающие утверждения. После подтверждения заявки, создаётся новая учётная запись, а заявка удаляется из этого списка. Отклонённые заявки просто удаляются из списка.',
	'confirmaccount-list2' => 'Ниже представлен список недавно отклонённых заявок на учётные записи, через некоторое время заявки автоматически из него удаляются. Вы всё-таки можете утвердить заявку из этого списка, но, вероятно, это требует обсуждения с администратором, отклонившем заявку.',
	'confirmaccount-list3' => 'Ниже приведён список устаревших запросов на учётные записи, которые могут быть удалены через несколько дней. Запрашиваемые учётные записи всё ещё могут быть утверждены.',
	'confirmaccount-text' => "Это запрос на получение учётной записи в проекте '''«{{SITENAME}}»'''.

Внимательно рассмотрите представленную ниже информацию. Если вы решили подтвердить запрос, укажите положение учётной записи с помощью выпадающего списка. Изменения, внесённые в биографию не отразятся в постоянном хранилище удостоверений личности. Заметьте, что вы можете создать учётную запись под другим именем пользователя. Используйте эту возможность только для предотвращения столкновения с другими именами.

Если вы просто покинете эту страницу, не утвердив и не отклонив запрос, то запрос останется открытым.",
	'confirmaccount-none-o' => 'В настоящее время необработанные запросы учётных записей отсутствуют.',
	'confirmaccount-none-h' => 'В настоящее время отсутствуют отложенные запросы учётных записей.',
	'confirmaccount-none-r' => 'В настоящее время список недавно отклонённых запросов пуст.',
	'confirmaccount-none-e' => 'В настоящее время нет устаревших запросов учётных записей в этом списке.',
	'confirmaccount-real-q' => 'Имя',
	'confirmaccount-email-q' => 'Эл. адрес',
	'confirmaccount-bio-q' => 'Биография',
	'confirmaccount-showopen' => 'открытые запросы',
	'confirmaccount-showrej' => 'отклонённые запросы',
	'confirmaccount-showheld' => 'Просмотр списка отложенных запросов',
	'confirmaccount-showexp' => 'устаревшие запросы',
	'confirmaccount-review' => 'Просмотреть',
	'confirmaccount-types' => 'Выберете очередь подтверждения запросов из предложенных ниже:',
	'confirmaccount-all' => '(показать все очереди)',
	'confirmaccount-type' => 'Выбранная очередь:',
	'confirmaccount-type-0' => 'будущие авторы',
	'confirmaccount-type-1' => 'будущие редакторы',
	'confirmaccount-q-open' => 'открытые запросы',
	'confirmaccount-q-held' => 'отложенные запросы',
	'confirmaccount-q-rej' => 'недавно отклонённые запросы',
	'confirmaccount-q-stale' => 'устаревшие запросы',
	'confirmaccount-badid' => 'Отсутствует отложенный запрос, соответствующий указанному идентификатору. Вероятно, он уже обработан.',
	'confirmaccount-leg-user' => 'Учётная запись',
	'confirmaccount-leg-areas' => 'Основные области интересов',
	'confirmaccount-leg-person' => 'Личные сведения',
	'confirmaccount-leg-other' => 'Прочая информация',
	'confirmaccount-name' => 'Имя участника',
	'confirmaccount-real' => 'Имя:',
	'confirmaccount-email' => 'Эл. адрес:',
	'confirmaccount-reqtype' => 'Должность:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-pos-1' => 'редактор',
	'confirmaccount-bio' => 'Биография:',
	'confirmaccount-attach' => 'Резюме:',
	'confirmaccount-notes' => 'Дополнительные замечания:',
	'confirmaccount-urls' => 'Список веб-сайтов:',
	'confirmaccount-none-p' => '(не указано)',
	'confirmaccount-confirm' => 'Используйте настройки для принятия, отклонения или откладывания запроса:',
	'confirmaccount-econf' => '(подтверждён)',
	'confirmaccount-reject' => '(отклонил [[User:$1|$1]] $2)',
	'confirmaccount-rational' => 'Обоснование, даваемое заявителю:',
	'confirmaccount-noreason' => '(нет)',
	'confirmaccount-autorej' => '(этот запрос был автоматически отвергнут из-за неактивности)',
	'confirmaccount-held' => '(отложил [[User:$1|$1]] $2)',
	'confirmaccount-create' => 'Утвердить (создать учётную запись)',
	'confirmaccount-deny' => 'Отклонить (убрать из списка)',
	'confirmaccount-hold' => 'Отложить',
	'confirmaccount-spam' => 'Спам (не будет отправлено письмо)',
	'confirmaccount-reason' => 'Комментарий (будет включён в письмо):',
	'confirmaccount-ip' => 'IP-адрес:',
	'confirmaccount-legend' => 'Подтвердить/отклонить эту учётную запись',
	'confirmaccount-submit' => 'Подтвердить',
	'confirmaccount-needreason' => 'Вы должны указать причину в поле комментария.',
	'confirmaccount-canthold' => 'Этот запрос уже удалён или отложен.',
	'confirmaccount-acc' => 'Запрос на учётную запись успешно обработан, создана новая учётная запись [[User:$1|$1]].',
	'confirmaccount-rej' => 'Запрос на учётную запись был отклонён.',
	'confirmaccount-viewing' => '(сейчас просматривается участником [[User:$1|$1]])',
	'confirmaccount-summary' => 'Создание страницы участника с биографией нового участника',
	'confirmaccount-welc' => "'''Добро пожаловать в ''{{SITENAME}}''!''' Мы надеемся на ваше плодотворное участие.
Возможно, вам будет интересно ознакомиться со [[{{MediaWiki:Helppage}}|справочными страницами]]. Ещё раз добро пожаловать, приятного времяпрепровождения.",
	'confirmaccount-wsum' => 'Добро пожаловать!',
	'confirmaccount-email-subj' => 'Запрос учётной записи в {{SITENAME}}',
	'confirmaccount-email-body' => 'Ваш запрос на создание учётной записи в {{SITENAME}} был утверждён.

Название учётной записи: $1

Пароль: $2

По соображениям безопасности, после первого входа в систему вам нужно будет изменить пароль. Представиться системе можно на странице
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Ваш запрос на создание учётной записи в {{SITENAME}} был утверждён.

Название учётной записи: $1

Пароль: $2

$3

По соображениям безопасности, после первого входа в систему вам нужно будет изменить пароль. Представиться системе можно на странице
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Извините, ваш запрос на создание учётной записи «$1» на сайте {{SITENAME}} был отклонён.

Это могло произойти по различным причинам. Возможно, вы неверно заполнили поля формы, ваши ответы были недостаточно полными
или не удовлетворительными с точки зрения правил проекта. На сайте могут быть списки контактов, которыми вы можете воспользоваться,
чтобы получить более подробную информацию о правилах, касающихся учётных записей участников.',
	'confirmaccount-email-body4' => 'Извините, ваш запрос на создание учётной записи «$1» на сайте {{SITENAME}} был отклонён.

$2

На сайте могут быть списки контактов, которыми вы можете воспользоваться,
чтобы получить более подробную информацию о правилах, касающихся учётных записей участников.',
	'confirmaccount-email-body5' => 'Чтобы ваш запрос на создание учётной записи «$1» на сайте {{SITENAME}} был утверждён, вам следует
предоставить дополнительную информацию.

$2

На сайте могут быть списки контактов, которыми вы можете воспользоваться,
чтобы получить более подробную информацию о правилах, касающихся учётных записей участников.',
	'usercredentials' => 'Удостоверяющая информация об участнике',
	'usercredentials-leg' => 'Поиск подтверждённой удостоверяющей информации об участнике',
	'usercredentials-user' => 'Имя участника:',
	'usercredentials-text' => 'Ниже показана проверенная удостоверяющая информация о выбранной учётной записи участника.',
	'usercredentials-leg-user' => 'Учётная запись',
	'usercredentials-leg-areas' => 'Основные области интересов',
	'usercredentials-leg-person' => 'Личные сведения',
	'usercredentials-leg-other' => 'Прочая информация',
	'usercredentials-email' => 'Эл. почта:',
	'usercredentials-real' => 'Настоящее имя:',
	'usercredentials-bio' => 'Биография:',
	'usercredentials-attach' => 'Резюме:',
	'usercredentials-notes' => 'Дополнительные замечания:',
	'usercredentials-urls' => 'Список веб-сайтов:',
	'usercredentials-ip' => 'IP-адрес:',
	'usercredentials-member' => 'Права:',
	'usercredentials-badid' => 'Не найдена удостоверяющая информация об участнике. Проверьте правильность написания имени.',
	'right-confirmaccount' => 'просмотр [[Special:ConfirmAccounts|запросов на создание учётных записей]]',
	'right-requestips' => 'Просмотр IP-адресов авторов запросов на создание учётных записей',
	'right-lookupcredentials' => 'просмотр [[Special:UserCredentials|удостоверяющей информации об участниках]]',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'requestaccount' => 'Vyžiadať účet',
	'requestaccount-text' => "'''Vyplnením a odoslaním nasledovného formulára vyžiadate používateľský účet'''.

Uistite sa, že ste si pred vyžiadaním účtu najskôr prečítali [[{{MediaWiki:Requestaccount-page}}|Podmienky použitia]].

Keď bude účet schválený, príde vám emailom oznámenie a bude možné prihlásiť sa na [[Special:UserLogin]].",
	'requestaccount-page' => '{{ns:project}}:Podmienky použitia',
	'requestaccount-dup' => "'''Pozn.: Už ste prihlásený ako zaregistrovaný používateľ.'''",
	'requestaccount-leg-user' => 'Používateľský účet',
	'requestaccount-leg-areas' => 'Hlavné oblasti záujmu',
	'requestaccount-leg-person' => 'Osobné informácie',
	'requestaccount-leg-other' => 'Ďalšie informácie',
	'requestaccount-leg-tos' => 'Podmienky používania',
	'requestaccount-acc-text' => 'Na vašu emailovú adresu bude po odoslaní žiadosti zaslaná potvrdzujúca správa. Prosím, reagujte na ňu kliknutím na odkaz v nej. Potom ako bude váš účet vytvorený, dostanete emailom heslo k nemu.',
	'requestaccount-areas-text' => 'Nižšie zvoľte tematické oblasti v ktorých ste formálne expertom alebo by ste v nich radi vykonávali väčšinu práce.',
	'requestaccount-ext-text' => 'Nasledovné informácie budú držané v tajnosti a použijú sa iba na účel tejto žiadosti. Možno budete chcieť uviesť kontakty ako telefónne číslo, ktoré môžu pomôcť pri potvrdení.',
	'requestaccount-bio-text' => 'Vaša biografia bude prvotným obsahom vašej používateľskej stránky.
Pokúste sa uviesť všetky referencie.
Zvážte, či ste ochotní zverejniť tieto informácie.
Vaše meno je možné zmeniť vo vašich [[Special:Preferences|nastaveniach]].',
	'requestaccount-real' => 'Skutočné meno:',
	'requestaccount-same' => '(rovnaké ako skutočné meno)',
	'requestaccount-email' => 'Emailová adresa:',
	'requestaccount-reqtype' => 'Pozícia:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'redaktor',
	'requestaccount-bio' => 'Osobná biografia:',
	'requestaccount-attach' => 'Resumé alebo CV (nepovinné):',
	'requestaccount-notes' => 'Ďalšie poznámky:',
	'requestaccount-urls' => 'Zoznam webstránok, ak nejaké sú (jednu na každý riadok):',
	'requestaccount-agree' => 'Musíte osvedčiť, že vaše skutočné meno je správne a že súhlasíte s našimi Podmienkami použitia.',
	'requestaccount-inuse' => 'Používateľské meno už bolo vyžiadané v prebiehajúcej žiadosti o účet.',
	'requestaccount-tooshort' => 'Vaša biografia musí mať aspoň $1 {{PLURAL:$1|slovo|slová|slov}}.',
	'requestaccount-emaildup' => 'Iný účet čakajúci na schválenie používa rovnakú emailovú adresu.',
	'requestaccount-exts' => 'Tento typ prílohy nie je povolený.',
	'requestaccount-resub' => 'Váš súbor s CV/resumé je potrebné z bezpečnostných dôvodov znova vybrať. nechajte pole prázdne
	ak ste sa rozhodli žiadny nepriložiť.',
	'requestaccount-tos' => 'Prečítal som a súhlasím, že budem dodržiavať [[{{MediaWiki:Requestaccount-page}}|Podmienky používania služby]] {{GRAMMAR:genitív|{{SITENAME}}}}. Meno, ktoré som uviedol ako „Skutočné meno“ je naozaj moje občianske meno.',
	'requestaccount-submit' => 'Požiadať o účet',
	'requestaccount-sent' => 'Vaša žiadosť o účet bola úspešne odoslaná a teraz sa čaká na jej kontrolu.
Na vašu emailovú adresu vám bola odoslaná potvrdzujúca správa.',
	'request-account-econf' => 'Vaša emailová adresa bola potvrdená a v takomto tvare sa uvedie vo vašej žiadosti o účet.',
	'requestaccount-email-subj' => 'potvrdenie e-mailovej adresy pre {{GRAMMAR:akuzatív|{{SITENAME}}}}',
	'requestaccount-email-body' => 'Niekto, pravdepodobne vy z IP adresy $1, zaregistroval účet
"$2" s touto e-mailovou adresou na {{GRAMMAR:lokál|{{SITENAME}}}}.

Pre potvrdenie, že tento účet skutočne patrí vám a pre aktivovanie
e-mailových funkcií na {{GRAMMAR:lokál|{{SITENAME}}}}, otvorte tento odkaz vo vašom prehliadači:

$3

Ak ste to *neboli* vy, neotvárajte odkaz. Tento potvrdzovací kód
vyprší o $4.',
	'requestaccount-email-subj-admin' => 'Žiadosť o účet vo {{GRAMMAR:lokál|{{SITENAME}}}}',
	'requestaccount-email-body-admin' => '„$1“ požiadal o účet a čaká na potvrdenie.
Emailová adresa bola potvrdená. Požiadavku môžete potvrdiť tu: „$2“.',
	'acct_request_throttle_hit' => 'Prepáčte, už ste požiadali o vytvorenie {{PLURAL:$1|$1 účtu|$1 účtov}}.
Nemôžete odoslať viac žiadostí.',
	'requestaccount-loginnotice' => "Aby ste dostali používateľský účet, musíte '''[[Special:RequestAccount|oň požiadať]]'''.",
	'confirmaccount-newrequests' => "Momentálne {{PLURAL:$1|je jedna otvorená|sú '''$1''' otvorené|je '''$1''' otvorených}} 
[[Special:ConfirmAccounts|{{PLURAL:$1|žiadosť o účet|žiadosti o účet|žiadostí o účet}}]].",
	'confirmaccounts' => 'Potvrdiť žiadosti o účet',
	'confirmedit-desc' => 'Dáva byroktatom schopnosť potvrdzovať žiadosti o účet',
	'confirmaccount-maintext' => "'''Táto stránka sa používa na potvrdzovanie nevybavencýh žiadostí o účet na ''{{GRAMMAR:lokál|{{SITENAME}}}}''''''.

Každý front žiadostí o účet pozostáva z troch podfront -- jednej pre otvorené požiadavky, druhej pre tie, ktoré boli pozdržané sptávcami kvôli chýbajúcim informáciám a tretej pre nedávno zamietnuté žiadosti.

Keď odpovedáte na žiadosť, pozorne si ju prečítajte a ak je to potrebné, overte obsiahnuté 
informácie.
O vašej činnosti sa povedie neverejný záznam. Tiež sa od vás očakáva, že budete kontrolovať činnosti, ktoré tu robia iní okrem vás.",
	'confirmaccount-list' => 'Nižšie je zoznam žiadostí o účet, ktoré čakajú na schválenie. Schválené účty budú vytvorené a odstránené z tohoto zoznamu. Odmietnuté účty budú jednoducho odstránené z tohoto zoznamu.',
	'confirmaccount-list2' => 'Nižšie je zoznam nedávno odmietnutých žiadostí o účet, ktoré môžu byť automaticky odstránené po niekoľkých dňoch. Ešte stále ich môžete schváliť a vytvoriť z nich platné účty, hoci by ste sa mali predtým, než tak učiníte, poradiť so správcom, ktorý ich odmietol.',
	'confirmaccount-list3' => 'Toto je zoznam žiadostí o účet, ktorých platnosť vypršala a je ich možné po niekoľkých dňoch automaticky zmazať. Ešte stále je možné ich schváliť.',
	'confirmaccount-text' => "Toto je žiadosť o používateľský účet na '''{{GRAMMAR:lokál|{{SITENAME}}}}'''.

Pozorne skontrolujte všetky dolu uvedené informácie. Ak schvaľute túto žiadosť, nastavte status používateľa z roletovej ponuky. Úpravy vykonané v biografii neovplyvnia akékoľvek trvalé uložisko údajov. Máte tiež možnosť vytvoriť účet pod odlišným používateľským menom. To však používajte iba na odstránenie konfliktov s inými menami.

Ak jednoducho opustíte túto stránku bez toho, aby ste ju schválili alebo odmietli, zostane v štádiu spracovania.",
	'confirmaccount-none-o' => 'Momentálne nie sú v tomto zozname žiadne čakajúce žiadosti na vytvorenie účtu.',
	'confirmaccount-none-h' => 'Momentálne nie sú v tomto zozname žiadne pozastavené žiadosti na vytvorenie účtu.',
	'confirmaccount-none-r' => 'Momentálne nie sú v tomto zozname žiadne zamietnuté žiadosti na vytvorenie účtu.',
	'confirmaccount-none-e' => 'Momentálne neexistujú žiadne žiadosti o účet s vypršanou platnosťou.',
	'confirmaccount-real-q' => 'Meno',
	'confirmaccount-email-q' => 'Email',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'otvorené žiadosti',
	'confirmaccount-showrej' => 'odmietnuté žiadosti',
	'confirmaccount-showheld' => 'Zobraziť zoznam účtov čakajúcich na schválenie',
	'confirmaccount-showexp' => 'expirované žiadosti',
	'confirmaccount-review' => 'Schváliť/odmietnuť',
	'confirmaccount-types' => 'Dolu zvoľte front potvrdení účtov:',
	'confirmaccount-all' => '(zobraziť všetky fronty)',
	'confirmaccount-type' => 'Zvolený front:',
	'confirmaccount-type-0' => 'budúci autori',
	'confirmaccount-type-1' => 'budúci redaktori',
	'confirmaccount-q-open' => 'otvorené žiadosti',
	'confirmaccount-q-held' => 'pozastavené žiadosti',
	'confirmaccount-q-rej' => 'nedávno zamietnuté žiadosti',
	'confirmaccount-q-stale' => 'expirované žiadosti',
	'confirmaccount-badid' => 'Neexistuje žiadna nespracovaná žiadosť o účet zodpovedajúca zadanému ID. Je možné, že už bola spracovaná.',
	'confirmaccount-leg-user' => 'Používateľský účet',
	'confirmaccount-leg-areas' => 'Hlavné oblasti záujmu',
	'confirmaccount-leg-person' => 'Osobné informácie',
	'confirmaccount-leg-other' => 'Ďalšie informácie',
	'confirmaccount-name' => 'Používateľské meno',
	'confirmaccount-real' => 'Meno:',
	'confirmaccount-email' => 'Email:',
	'confirmaccount-reqtype' => 'Pozícia:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'redaktor',
	'confirmaccount-bio' => 'Biografia:',
	'confirmaccount-attach' => 'Resumé/CV:',
	'confirmaccount-notes' => 'Ďalšie poznámky:',
	'confirmaccount-urls' => 'Zoznam webstránok:',
	'confirmaccount-none-p' => '(neposkytnuté)',
	'confirmaccount-confirm' => 'Tlačidlami nižšie môžete prijať alebo odmietnuť túto žiadosť.',
	'confirmaccount-econf' => '(potvrdený)',
	'confirmaccount-reject' => '(odmietol [[User:$1|$1]] $2)',
	'confirmaccount-rational' => 'Zdôvodnenie pre uchádzača:',
	'confirmaccount-noreason' => '(žiadne)',
	'confirmaccount-autorej' => '(táto požiadavka bola automaticky zrušená z dôvodu neaktivity)',
	'confirmaccount-held' => '(používateľ [[User:$1|$1]] $2 označenil ako „pozastavené“)',
	'confirmaccount-create' => 'Prijať (vytvoriť účet)',
	'confirmaccount-deny' => 'Odmietnuť (odstrániť žiadosť)',
	'confirmaccount-hold' => 'Pozastaviť',
	'confirmaccount-spam' => 'Spam (neposielať email)',
	'confirmaccount-reason' => 'Komentár (bude súčasťou emailu email):',
	'confirmaccount-ip' => 'IP adresa:',
	'confirmaccount-legend' => 'Potvrdiť/zamietnuť tento účet',
	'confirmaccount-submit' => 'Potvrdiť',
	'confirmaccount-needreason' => 'Do komentára dolu musíte napísať dôvod.',
	'confirmaccount-canthold' => 'Táto žiadosť je už buď pozdržaná alebo zmazaná.',
	'confirmaccount-acc' => 'Žiadosť o účet bola úspešne potvrdená; bol vytvorený nový používateľský účet [[User:$1|$1]].',
	'confirmaccount-rej' => 'Žiadosť o účet bola úspešne odmietnutá.',
	'confirmaccount-viewing' => '(momentálne sa na ňu pozerá [[User:$1|$1]])',
	'confirmaccount-summary' => 'Vytvára sa používateľská stránka s biografiou nového používateľa.',
	'confirmaccount-welc' => "'''Vitajte v ''{{GRAMMAR:lokál|{{SITENAME}}}}''!''' Dúfame, že budete prispievať vo veľkom množstve a kvalitne. Pravdepodobne si budete chcieť prečítať [[{{MediaWiki:Helppage}}|Začíname]]. Tak ešte raz vitajte a bavte sa!",
	'confirmaccount-wsum' => 'Vitajte!',
	'confirmaccount-email-subj' => 'žiadosť o účet {{GRAMMAR:genitív|{{SITENAME}}}}',
	'confirmaccount-email-body' => 'Vaša žiadosť o účet na {{GRAMMAR:lokál|{{SITENAME}}}} bola schválená. Názov účtu: $1 Heslo: $2 Z bezpečnostných dôvodov si budete musieť pri prvom prihlásení svoje heslo zmeniť. Teraz sa môžete prihlásiť na {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Vaša žiadosť o účet na {{GRAMMAR:lokál|{{SITENAME}}}} bola schválená. Názov účtu: $1 Heslo: $2 $3 Z bezpečnostných dôvodov si budete musieť pri prvom prihlásení svoje heslo zmeniť. Teraz sa môžete prihlásiť na {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Je nám ľúto, ale vaša žiadosť o účet „$1“ na {{GRAMMAR:lokál|{{SITENAME}}}} bola zamietnutá. Je niekoľko dôvodov, prečo sa to mohlo stať. Buď ste nevyplnili formulár správne, neposkytli ste požadovanú dĺžku vašich odpovedí alebo inak ste nesplnili kritériá. Ak sa chcete dozvedieť viac o politike tvorby účtov, na tejto stránke môžete nájsť kontakty.',
	'confirmaccount-email-body4' => 'Je nám ľúto, ale vaša žiadosť o účet „$1“ na {{GRAMMAR:lokál|{{SITENAME}}}} bola zamietnutá.

$2

Ak sa chcete dozvedieť viac o politike tvorby účtov, na tejto stránke môžete nájsť kontakty.',
	'confirmaccount-email-body5' => 'Predtým, než bude možné vašu žiadosť o účet „$1“ na {{GRAMMAR:lokál|{{SITENAME}}}} možné prijať 
	musíte poskytnúť ďalšie informácie.

$2

Na stránke môže byť uvedený zoznam kontaktov, ktorý môžete použiť ak sa chcete dozvedieť viac o politike používateľských účtov.',
	'usercredentials' => 'Osobné údaje používateľa',
	'usercredentials-leg' => 'Vyhľadať potvrdené osobné údaje používateľa',
	'usercredentials-user' => 'Používateľské meno:',
	'usercredentials-text' => 'Dolu sú overené osobné údaje zvoleného používateľského účtu.',
	'usercredentials-leg-user' => 'Používateľský účet',
	'usercredentials-leg-areas' => 'Hlavné oblasti záujmu',
	'usercredentials-leg-person' => 'Osobné informácie',
	'usercredentials-leg-other' => 'Ďalšie informácie',
	'usercredentials-email' => 'Email:',
	'usercredentials-real' => 'Skutočné meno:',
	'usercredentials-bio' => 'Biografia:',
	'usercredentials-attach' => 'Resumé/CV:',
	'usercredentials-notes' => 'Ďalšie poznámky:',
	'usercredentials-urls' => 'Zoznam webstránok:',
	'usercredentials-ip' => 'Pôvodná IP adresa:',
	'usercredentials-member' => 'Práva:',
	'usercredentials-badid' => 'Žiadne osobné informácie tohto používateľa neboli nájdené. Skontrolujte, či ste správne napísali meno.',
	'right-confirmaccount' => 'Zobraziť [[Special:ConfirmAccounts|front žiadostí o účet]]',
	'right-requestips' => 'Zobraziť IP adresu žiadateľa pri spracovaní žiadostí o účet',
	'right-lookupcredentials' => 'Zobraziť [[Special:UserCredentials|údaje používateľa]]',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'requestaccount-leg-user' => 'Кориснички налог',
	'requestaccount-leg-areas' => 'Главне сфере интересовања',
	'requestaccount-leg-person' => 'Личне информације',
	'requestaccount-leg-other' => 'Друге информације',
	'requestaccount-leg-tos' => 'Услови коришћења',
	'requestaccount-real' => 'Право име:',
	'requestaccount-same' => '(истоветно правом имену)',
	'requestaccount-email' => 'Е-пошта:',
	'requestaccount-reqtype' => 'Позиција:',
	'requestaccount-level-0' => 'аутор',
	'requestaccount-level-1' => 'едитор',
	'requestaccount-bio' => 'Лична биографија:',
	'requestaccount-attach' => 'Резиме или CV (необавезно):',
	'requestaccount-notes' => 'Додатне напомене:',
	'requestaccount-urls' => 'Списак вебсајтова, ако их има (одвојени новим линијама):',
	'requestaccount-agree' => 'Морате да потврдите да сте добро унели своје право име и да се сложите са условима коришћења.',
	'requestaccount-inuse' => 'Корисничко име је већ у употреби и чека на одобрење.',
	'requestaccount-tooshort' => 'Ваша биографија мора да садржи најмање $1 речи.',
	'requestaccount-emaildup' => 'Други налог, који чека одобрење, већ користи ову имејл адресу.',
	'requestaccount-sent' => 'Ваш захтев за налогом је успешно послат и чека на преглед.
Електронска порука за потврду је послата на Вашу адресу Ваше електронске поште.',
	'request-account-econf' => 'Ваша имејл адреса је била потврђена и биће приказана као таква у Вашем захтеву за налогом.',
	'confirmaccount-none-o' => 'Тренутно нема нерешених захтева у овом списку.',
	'confirmaccount-none-h' => 'Тренутно нема стопираних захтева у овом списку.',
	'confirmaccount-none-r' => 'Тренутно нема скоро одбачених захтева у овом списку.',
	'confirmaccount-none-e' => 'Тренутно нема застарелих захтева у овом списку.',
	'confirmaccount-real-q' => 'Име',
	'confirmaccount-email-q' => 'Мејл',
	'confirmaccount-bio-q' => 'Биографија',
	'confirmaccount-showopen' => 'нерешени захтеви',
	'confirmaccount-showrej' => 'одбачени захтеви',
	'confirmaccount-showheld' => 'стопирани захтеви',
	'confirmaccount-showexp' => 'застарели захтеви',
	'confirmaccount-all' => '(покажи све редове)',
	'confirmaccount-type' => 'Ред:',
	'confirmaccount-type-0' => 'проспективни аутори',
	'confirmaccount-q-open' => 'нерешени захтеви',
	'confirmaccount-q-held' => 'стопирани захтеви',
	'confirmaccount-q-rej' => 'скоро одбачени захтеви',
	'confirmaccount-q-stale' => 'застарели захтеви',
	'confirmaccount-badid' => 'Нема нерешеног захтева који одговара датом ID.
Можда је већ био решен.',
	'confirmaccount-leg-user' => 'Кориснички налог',
	'confirmaccount-leg-areas' => 'Главне интересне сфере',
	'confirmaccount-leg-person' => 'Личне информације',
	'confirmaccount-leg-other' => 'Друге информације',
	'confirmaccount-name' => 'Корисничко име',
	'confirmaccount-real' => 'Име:',
	'confirmaccount-email' => 'Мејл:',
	'confirmaccount-reqtype' => 'Позиција:',
	'confirmaccount-pos-0' => 'аутор',
	'confirmaccount-pos-1' => 'едитор',
	'confirmaccount-bio' => 'Биографија:',
	'confirmaccount-attach' => 'Резиме/CV:',
	'confirmaccount-notes' => 'Додатне напомене:',
	'confirmaccount-urls' => 'Списак вебсајтова:',
	'confirmaccount-none-p' => '(није приложено)',
	'confirmaccount-confirm' => 'Користите опције испод да прихватите, одбаците или стопирате овај захтев:',
	'confirmaccount-econf' => '(потврђено)',
	'confirmaccount-reject' => '(одбацио [[User:$1|$1]] на $2)',
	'confirmaccount-rational' => 'Образложење дато кандидату:',
	'confirmaccount-noreason' => '(нема)',
	'confirmaccount-autorej' => '(овај захтев је био аутоматски одбачен због неактивности)',
	'confirmaccount-held' => '(означено као "стопирано" од [[User:$1|$1]] на $2)',
	'confirmaccount-create' => 'Прихвати (направи налог)',
	'confirmaccount-deny' => 'Одбаци (скини са списка)',
	'confirmaccount-hold' => 'Стопирај',
	'confirmaccount-reason' => 'Коментар (биће укључен у имејл):',
	'confirmaccount-ip' => 'IP адреса:',
	'confirmaccount-submit' => 'Потврди',
	'confirmaccount-needreason' => 'Морате навести разлог у кутијици за коментаре испод.',
	'confirmaccount-canthold' => 'Овај захтев је већ стопиран или обрисан.',
	'confirmaccount-acc' => 'Захтев за налогом успешно прихваћен:
направљен је нови кориснички налог [[User:$1|$1]].',
	'confirmaccount-rej' => 'Захтев за налогом успешно одбачен.',
	'confirmaccount-viewing' => '(тренутно прегледа [[User:$1|$1]])',
	'confirmaccount-summary' => 'Прављење корисничке стране са биографијом новог корисника.',
	'confirmaccount-wsum' => 'Добро дошли!',
	'usercredentials-user' => 'Корисничко име:',
	'usercredentials-leg-user' => 'Кориснички налог',
	'usercredentials-leg-areas' => 'Главне сфере интересовања',
	'usercredentials-leg-person' => 'Личне информације',
	'usercredentials-leg-other' => 'Друге информације',
	'usercredentials-email' => 'Мејл:',
	'usercredentials-real' => 'Право име:',
	'usercredentials-bio' => 'Биографија:',
	'usercredentials-attach' => 'Резиме/CV:',
	'usercredentials-notes' => 'Додатне напомене:',
	'usercredentials-urls' => 'Списак вебсајтова:',
	'usercredentials-ip' => 'Оригинална IP адреса:',
	'usercredentials-member' => 'Права:',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 * @author Михајло Анђелковић
 */
$messages['sr-el'] = array(
	'requestaccount-leg-user' => 'Korisnički nalog',
	'requestaccount-leg-areas' => 'Glavne sfere interesovanja',
	'requestaccount-leg-person' => 'Lične informacije',
	'requestaccount-leg-other' => 'Druge informacije',
	'requestaccount-leg-tos' => 'Uslovi korišćenja',
	'requestaccount-real' => 'Pravo ime:',
	'requestaccount-same' => '(istovetno pravom imenu)',
	'requestaccount-email' => 'E-pošta:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Lična biografija:',
	'requestaccount-attach' => 'Rezime ili CV (neobavezno):',
	'requestaccount-notes' => 'Dodatne napomene:',
	'requestaccount-urls' => 'Spisak vebsajtova, ako ih ima (odvojeni novim linijama):',
	'requestaccount-agree' => 'Morate da potvrdite da ste dobro uneli svoje pravo ime i da se složite sa uslovima korišćenja.',
	'requestaccount-inuse' => 'Korisničko ime je već u upotrebi i čeka na odobrenje.',
	'requestaccount-emaildup' => 'Drugi nalog, koji čeka odobrenje, već koristi ovu imejl adresu.',
	'requestaccount-sent' => 'Vaš zahtev za nalogom je uspešno poslat i čeka na pregled.
Elektronska poruka za potvrdu je poslata na Vašu adresu Vaše elektronske pošte.',
	'request-account-econf' => 'Vaša imejl adresa je bila potvrđena i biće prikazana kao takva u Vašem zahtevu za nalogom.',
	'confirmaccount-none-o' => 'Trenutno nema nerešenih zahteva u ovom spisku.',
	'confirmaccount-none-h' => 'Trenutno nema stopiranih zahteva u ovom spisku.',
	'confirmaccount-none-r' => 'Trenutno nema skoro odbačenih zahteva u ovom spisku.',
	'confirmaccount-none-e' => 'Trenutno nema zastarelih zahteva u ovom spisku.',
	'confirmaccount-real-q' => 'Ime',
	'confirmaccount-email-q' => 'Mejl',
	'confirmaccount-bio-q' => 'Biografija',
	'confirmaccount-showopen' => 'nerešeni zahtevi',
	'confirmaccount-showrej' => 'odbačeni zahtevi',
	'confirmaccount-showheld' => 'stopirani zahtevi',
	'confirmaccount-showexp' => 'zastareli zahtevi',
	'confirmaccount-all' => '(pokaži sve redove)',
	'confirmaccount-type' => 'Red:',
	'confirmaccount-type-0' => 'prospektivni autori',
	'confirmaccount-q-open' => 'nerešeni zahtevi',
	'confirmaccount-q-held' => 'stopirani zahtevi',
	'confirmaccount-q-rej' => 'skoro odbačeni zahtevi',
	'confirmaccount-q-stale' => 'zastareli zahtevi',
	'confirmaccount-badid' => 'Nema nerešenog zahteva koji odgovara datom ID.
Možda je već bio rešen.',
	'confirmaccount-leg-user' => 'Korisnički nalog',
	'confirmaccount-leg-areas' => 'Glavne interesne sfere',
	'confirmaccount-leg-person' => 'Lične informacije',
	'confirmaccount-leg-other' => 'Druge informacije',
	'confirmaccount-name' => 'Korisničko ime',
	'confirmaccount-real' => 'Ime:',
	'confirmaccount-email' => 'Mejl:',
	'confirmaccount-reqtype' => 'Pozicija:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografija:',
	'confirmaccount-attach' => 'Rezime/CV:',
	'confirmaccount-notes' => 'Dodatne napomene:',
	'confirmaccount-urls' => 'Spisak vebsajtova:',
	'confirmaccount-none-p' => '(nije priloženo)',
	'confirmaccount-confirm' => 'Koristite opcije ispod da prihvatite, odbacite ili stopirate ovaj zahtev:',
	'confirmaccount-econf' => '(potvrđeno)',
	'confirmaccount-reject' => '(odbacio [[User:$1|$1]] na $2)',
	'confirmaccount-rational' => 'Obrazloženje dato kandidatu:',
	'confirmaccount-noreason' => '(nema)',
	'confirmaccount-autorej' => '(ovaj zahtev je bio automatski odbačen zbog neaktivnosti)',
	'confirmaccount-held' => '(označeno kao "stopirano" od [[User:$1|$1]] na $2)',
	'confirmaccount-create' => 'Prihvati (napravi nalog)',
	'confirmaccount-deny' => 'Odbaci (skini sa spiska)',
	'confirmaccount-hold' => 'Stopiraj',
	'confirmaccount-reason' => 'Komentar (biće uključen u imejl):',
	'confirmaccount-ip' => 'IP adresa:',
	'confirmaccount-submit' => 'Potvrdi',
	'confirmaccount-needreason' => 'Morate navesti razlog u kutijici za komentare ispod.',
	'confirmaccount-canthold' => 'Ovaj zahtev je već stopiran ili obrisan.',
	'confirmaccount-acc' => 'Zahtev za nalogom uspešno prihvaćen:
napravljen je novi korisnički nalog [[User:$1|$1]].',
	'confirmaccount-rej' => 'Zahtev za nalogom uspešno odbačen.',
	'confirmaccount-viewing' => '(trenutno pregleda [[User:$1|$1]])',
	'confirmaccount-summary' => 'Pravljenje korisničke strane sa biografijom novog korisnika.',
	'confirmaccount-wsum' => 'Dobro došli!',
	'usercredentials-user' => 'Korisničko ime:',
	'usercredentials-leg-user' => 'Korisnički nalog',
	'usercredentials-leg-areas' => 'Glavne sfere interesovanja',
	'usercredentials-leg-person' => 'Lične informacije',
	'usercredentials-leg-other' => 'Druge informacije',
	'usercredentials-email' => 'Mejl:',
	'usercredentials-real' => 'Pravo ime:',
	'usercredentials-bio' => 'Biografija:',
	'usercredentials-attach' => 'Rezime/CV:',
	'usercredentials-notes' => 'Dodatne napomene:',
	'usercredentials-urls' => 'Spisak vebsajtova:',
	'usercredentials-ip' => 'Originalna IP adresa:',
	'usercredentials-member' => 'Prava:',
);

/** Swati (SiSwati)
 * @author Jatrobat
 */
$messages['ss'] = array(
	'confirmaccount-real-q' => 'Ligama',
	'confirmaccount-real' => 'Ligama:',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'requestaccount' => 'Benutserkonto fräigje',
	'requestaccount-text' => "'''Fäl dät foulgjende Formular uut un ferseend dät, uum n Benutserkonto tou fräigjen'''.

	Läs eerste do [[{{MediaWiki:Requestaccount-page}}|Nutsengsbedingengen]] eer du n Benutserkonto fräigest.

	Sobolde dät Konto bestäätiged wuude, krichst du per E-Mail Bescheed un du koast die [[{{ns:special}}:Userlogin|anmäldje]].",
	'requestaccount-page' => '{{ns:project}}:Nutsengsbedingengen',
	'requestaccount-dup' => "'''Oachtenge: Du bäst al mäd n registrierd Benutserkonto ienlogged.'''",
	'requestaccount-leg-user' => 'Benutserkonto',
	'requestaccount-leg-areas' => 'Haudinteressensgebiete',
	'requestaccount-leg-person' => 'Persöönelke Informatione',
	'requestaccount-leg-other' => 'Uur Informatione',
	'requestaccount-acc-text' => 'An dien E-Mail-Adresse wäd ätter dät Ouseenden fon dit Formular ne Bestäätigengsmail soand.
Reagier deerap, wan du ap ju in ju Mail äntheeldene Bestäätigengsferbiendenge klikst.
Sobolde n dien Konto anlaid wuude,
wäd die dien Paaswoud per E-Mail tousoand.',
	'requestaccount-areas-text' => 'Wääl do Themengebiete uut, in do du dät maaste Fäkwieten hääst of wier du ap maaste involvierd weese schääst.',
	'requestaccount-ext-text' => 'Do foulgjende Informatione wäide fertjouelk behanneld un bloot foar dissen Andraach
ferwoand. Dd koast Kontakt-Angoawen as ne Telefonnummer moakje, uum ju Beoarbaidenge fon din Andraach eenfacher tou moakjen.',
	'requestaccount-bio-text' => 'Dien Biographie wäd as initioale Inhoold fon dien Benutsersiede spiekerd. Fersäik aal do nöödige Referenzen tou ärwäänen, man staal sicher, dät du do Informatione wuddelk eepentelk bekoand moakje moatest. Du koast din Noome unner „[[{{ns:special}}:preferences|Ienstaalengen]]“ annerje.',
	'requestaccount-real' => 'Realname:',
	'requestaccount-same' => '(as die Realname)',
	'requestaccount-email' => 'E-Mail-Adresse:',
	'requestaccount-reqtype' => 'Position:',
	'requestaccount-level-0' => 'Autor',
	'requestaccount-level-1' => 'Beoarbaider',
	'requestaccount-bio' => 'Persöönelke Biographie:',
	'requestaccount-attach' => 'Lieuwensloop (optional):',
	'requestaccount-notes' => 'Bietoukuumende Angoawen:',
	'requestaccount-urls' => 'Lieste fon Websieden (truch Riegenuumbreeke tränd):',
	'requestaccount-agree' => 'Du moast bestäätigje, dät din Realname so gjucht is un du do Benutserbedingengen akzeptierst.',
	'requestaccount-inuse' => 'Die Benutsernoome is al in n uur Benutserandraach in Ferweendenge.',
	'requestaccount-tooshort' => 'Dien Biographie schuul mindestens $1 Woude loang weese.',
	'requestaccount-emaildup' => 'N wiederen noch nit ouhonnelden Andraach benutset ju glieke E-Mail-Adresse.',
	'requestaccount-exts' => 'Die Doatäityp fon dän Anhong is nit ferlööwed.',
	'requestaccount-resub' => 'Ju Doatäi mäd din Lieuwensloop mout uut Sicherhaidsgruunden näi uutwääld wäide.
Läit dät Fäild loos, wan du naan Lieuwensloop moor anföigje moatest.',
	'requestaccount-tos' => 'Iek hääbe do [[{{MediaWiki:Requestaccount-page}}|Benutsengsbedingengen]] fon {{SITENAME}} leesen un akzeptierje do.
Iek bestäätigje, dät die Noome, dän iek unner „Realname“ ounroat hääbe, min wuddelke Noome is.',
	'requestaccount-submit' => 'Fräigje uum n Benutserkonto',
	'requestaccount-sent' => 'Dien Andraach wuude mäd Ärfoulch fersoand un mout nu noch wröiged wäide.',
	'request-account-econf' => 'Dien E-Mail-Adresse wuude bestäätiged un wäd nu as sodoane in dien  Account-Froage fierd.',
	'requestaccount-email-subj' => '{{SITENAME}} E-Mail-Adressen Wröich',
	'requestaccount-email-body' => 'Wäl mäd ju IP-Adresse $1, muugelkerwiese du, häd bie {{SITENAME}} uum dät Benutserkonto "$2" mäd dien E-Mail Adresse fräiged.

Uum tou bestäätigjen, dät wuddelk du uum dit Konto bie {{SITENAME}} fräiged hääst, eepenje foulgjende Ferbiendenge in din Browser:

$3

Wan dät Benutserkonto moaked wuude, krichst du ne E-Mail mäd dät Paaswoud.

Wan du *nit* uum dät Benutserkonto fräiged hääst, eepenje ju Ferbiendenge nit!

Disse Bestäätigengscode wäd uum $4 uungultich.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} Benutserkontenandraach',
	'acct_request_throttle_hit' => 'Du hääst al {{PLURAL:$1|1 Benutzerkonto|$1 Benutzerkonten}} fräiged, du koast apstuuns neen wiedere fräigje.',
	'requestaccount-loginnotice' => "Uum n näi Benutserkonto tou kriegen, moast du
der uum '''[[{{ns:special}}:RequestAccount|fräigje]]'''.",
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|eepenen, E-Mail bestäätigden Benutserkontenandraach täift]]|[[Special:ConfirmAccounts|eepene, E-Mail bestäätigde Benutserkontenandraage täiwe]]}} ap Beoarbaidenge.",
	'confirmaccounts' => 'Benutserkonto-Froagen bestäätigje',
	'confirmedit-desc' => 'Rakt Bürokrate ju Muugelkhaid, Benutserkontenandraage tou bestäätigjen',
	'confirmaccount-maintext' => "'''Disse Siede tjoont deertou, täiwende Benutserkontenandraage foar ''{{SITENAME}}''''' tou beoarbaidjen.

Älke Benutserkonten-Andraachsqueue bestoant uut tjo Unnerqueues. Een foar eepene Anfroage, een foar Andraage in dän „outäiwe“-Stoatus un een foar knu ouliende Anfroagen.

Wan du ap n Andraach oantwoudest, wröich dan do Informatione suurgfooldich un bestäätigje do änthooldene Informatione.
Dien Aktione wäide nit-eepentelk protokollierd. Der wäd uk fon die ferwachted, do Aktione fon uurswäkke tou wröigjen.",
	'confirmaccount-list' => 'Hier unner finst du ne Lieste fon noch tou beoarbaidjene Benutserkonto-Froagen.
Bestäätigede Konten wäide anlaid un uut ju Lieste wächhoald. Ouliende Konten wäide eenfach uut ju Lieste läsked.',
	'confirmaccount-list2' => 'Unner is ne Lieste fon knu touräächwiesde Andraage, do automatisk läsked wäide, so gau do eenige Deege oold sunt. Do konnen noch geneemigd wäide, man in älke Fal schuust du eerste dän oulienenden Administrator kontaktierje.',
	'confirmaccount-list3' => 'Unner is ne Lieste knu touräächwiesde Andraage, do automatisk läsked wäide, so gau do eenige Deege oold sunt. Do konnen noch geneemigd wäide.',
	'confirmaccount-text' => "Dit is n Andraach ap n Benutserkonto bie '''{{SITENAME}}'''. Wröigje aal hier unner stoundene Informatione gruundelk un bestäätigje do Informatione wan muugelk. Beoachtje, dät du dän Tougong bie Bedarf unner
n uur Benutsernoome anlääse koast. Du schuust dät bloot nutsje, uum Kollisione mäd uur Noomen tou fermieden.

Wan du disse Siede ferlätst, sunner dät Konto tou bestäätigjen of outoulienen, dan blift die Andraach eepen stounde.",
	'confirmaccount-none-o' => 'Apstuuns rakt et neen eepene Benutserandraage ap disse Lieste.',
	'confirmaccount-none-h' => 'Apstuuns rakt et neen Andraage in dän „outäiwe“-Stoatus ap disse Lieste.',
	'confirmaccount-none-r' => 'Apstuuns rakt et neen knu ouliende Benutserandraage ap disse Lieste.',
	'confirmaccount-none-e' => 'Apstuuns rakt et neen ouronnene Benutserandraage ap disse Lieste.',
	'confirmaccount-real-q' => 'Noome',
	'confirmaccount-email-q' => 'E-Mail',
	'confirmaccount-bio-q' => 'Biographie',
	'confirmaccount-showopen' => 'eepene Andraage',
	'confirmaccount-showrej' => 'touräächwiesde Andraage',
	'confirmaccount-showheld' => 'Lieste fon do Andraage ap „outäiwe“-Stoatus anwiese',
	'confirmaccount-showexp' => 'ouronnene Andraage',
	'confirmaccount-review' => 'Bestäätigje/Ouliene',
	'confirmaccount-types' => 'Wääl ne Benutserbestäätigengstäiweslange uut do unner stoundenen uut:',
	'confirmaccount-all' => '(wies aal Täiweslangen)',
	'confirmaccount-type' => 'Täiweslange:',
	'confirmaccount-type-0' => 'toukumstige Autore',
	'confirmaccount-type-1' => 'toukumstige Beoarbaidere',
	'confirmaccount-q-open' => 'eepene Andraage',
	'confirmaccount-q-held' => 'täiwende Andraage',
	'confirmaccount-q-rej' => 'knu ouliende Andraage',
	'confirmaccount-q-stale' => 'ouronnene Andraage',
	'confirmaccount-badid' => 'Apstuuns rakt et neen Benutserandraach tou ju anroate ID. Muugelkerwiese wuude hie al beoarbaided.',
	'confirmaccount-leg-user' => 'Benutserkonto',
	'confirmaccount-leg-areas' => 'Haudinteressengebiete',
	'confirmaccount-leg-person' => 'Persöönelke Informatione',
	'confirmaccount-leg-other' => 'Wiedere Informatione',
	'confirmaccount-name' => 'Benutsernoome',
	'confirmaccount-real' => 'Noome:',
	'confirmaccount-email' => 'E-Mail:',
	'confirmaccount-reqtype' => 'Position:',
	'confirmaccount-pos-0' => 'Autor',
	'confirmaccount-pos-1' => 'Beoarbaider',
	'confirmaccount-bio' => 'Biographie:',
	'confirmaccount-attach' => 'Lieuwensloop:',
	'confirmaccount-notes' => 'Waiwiesengen bietou:',
	'confirmaccount-urls' => 'Lieste fon do Websieden:',
	'confirmaccount-none-p' => '(Niks ounroat)',
	'confirmaccount-confirm' => 'Benutsje ju foulgjende Uutwoal, uum dän Andraach tou akzeptierjen, outoulienen of noch tou täiwen.',
	'confirmaccount-econf' => '(bestäätiged)',
	'confirmaccount-reject' => '(ouliend truch [[User:$1|$1]] ap n $2)',
	'confirmaccount-rational' => 'Begruundenge foar dän Andraachstaaler',
	'confirmaccount-noreason' => '(niks)',
	'confirmaccount-autorej' => '(dissen Andraach wuud automatisk weegen Inaktivität strieken)',
	'confirmaccount-held' => '(markierd as „outäiwe“ truch [[User:$1|$1]] ap n $2)',
	'confirmaccount-create' => 'Bestäätigje (Konto anlääse)',
	'confirmaccount-deny' => 'Ouliene (Andraach läskje)',
	'confirmaccount-hold' => 'Markierd as „outäiwe“',
	'confirmaccount-spam' => 'Spam (neen E-Mail ferseende)',
	'confirmaccount-reason' => 'Begruundenge (wäd in ju Mail an dän Andraachstaaler ienföiged):',
	'confirmaccount-ip' => 'IP-Addresse:',
	'confirmaccount-submit' => 'Ouseende',
	'confirmaccount-needreason' => 'Du moast ne Begruundenge ounreeke.',
	'confirmaccount-canthold' => 'Disse Froage wuude al as „outäiwe“ markierd of läsked.',
	'confirmaccount-acc' => 'Benutserandraach mäd Ärfoulch bestäätiged; Benutser [[User:$1|$1]] wuude anlaid.',
	'confirmaccount-rej' => 'Benutserandraach wuude ouliend.',
	'confirmaccount-viewing' => '(wäd apstuuns bekieked truch [[User:$1|$1]])',
	'confirmaccount-summary' => 'Moak Benutsersiede mäd ju Biographie fon dän näie Benutser.',
	'confirmaccount-welc' => "'''Wäilkuumen bie ''{{SITENAME}}''!''' Wie hoopje, dät du fuul goude Informatione biedrächst.
	Muugelkerwiese moatest du eerste do [[{{MediaWiki:Helppage}}|Eerste Stappe]] leese. Nochmoal: Wäilkuumen un hääb Spoas!~",
	'confirmaccount-wsum' => 'Wäilkuumen!',
	'confirmaccount-email-subj' => '{{SITENAME}} Froage uum n Benutserkonto',
	'confirmaccount-email-body' => 'Dien Froage uum n Benutserkonto bie {{SITENAME}} wuude bestäätiged.

Benutsernoome: $1

Paaswoud: $2

Uut Sicherhaidsgruunden schuust du dien Paaswoud uunbedingd bie dät eerste
Ienlogjen annerje. Uum die ientoulogjen gungst du ap ju Siede
{{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Dien Froage uum n Benutserkonto bie {{SITENAME}} wuude bestäätiged.

Benutsernoome: $1

Paaswoud: $2

$3

Uut Sicherhaidsgruunden schuust du dien Paaswoud uunbedingd bie dät eerste Ienlogjen annerje. Uum die ientoulogjen gungst du ap ju Siede {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Spietelk wuude dien Froage uum n Benutserkonto „$1“
bie {{SITENAME}} ouliend.

Dit kon fuul Gruunde hääbe. Muugelkerwiese hääst du dät Froageformular
nit gjucht uutfäld, hääst nit genöigjend Angoawen moaked of hääst
do Anfoarderengen ap uur Wiese nit uutfierd.',
	'confirmaccount-email-body4' => 'Spietelk wuude dien Froage uum n Benutserkonto „$1“
bie {{SITENAME}} ouliend.

$2

Muugelkerwiese rakt dät ap ju Siede Kontaktadressen, an do du die weende
koast, wan du moor uut do Anfoarderengen wiete moatest.',
	'confirmaccount-email-body5' => 'Eer dien Anfroage foar dät Benutserkonto „$1“ fon {{SITENAME}} akzeptierd wäide kon,
       moast du bietoukuumende Informatione touseende.

$2

Muugelkerwiese rakt et ap ju Siede Kontaktadressen, an do du die weende
koast, wan du moor uur do Anfoarderengen wiete moatest.

Bevor deine Anfrage für das Benutzerkonto „$1“ von {{SITENAME}} akzeptiert werden kann,
       musst du zusätzliche Informationen übermitteln.',
	'usercredentials' => 'Benutser-Begjuchtigengsätterwies',
	'usercredentials-leg' => 'Bestäätigede Benutser-Begjuchtigengsätterwiese ätterkiekje',
	'usercredentials-user' => 'Benutsernoome:',
	'usercredentials-text' => 'Hier foulgje do bestäätigede Benutser-Begjuchtigengsätterwiese foar dät wäälde Benutserkonto.',
	'usercredentials-leg-user' => 'Benutserkonto',
	'usercredentials-leg-areas' => 'Haud-Interessensgebiete',
	'usercredentials-leg-person' => 'Persöönelke Informatione',
	'usercredentials-leg-other' => 'Uur Informatione',
	'usercredentials-email' => 'E-Mail:',
	'usercredentials-real' => 'Ächten Noome',
	'usercredentials-bio' => 'Biographie:',
	'usercredentials-notes' => 'Bemäärkengen bietou:',
	'usercredentials-urls' => 'Lieste fon do Websieden:',
	'usercredentials-ip' => 'Originoale IP-Adresse:',
	'usercredentials-member' => 'Gjuchte:',
	'usercredentials-badid' => 'Der wuuden neen Begjuchtigengsätterwiese foar dissen Benutser fuunen. Wröich ju Schrieuwwiese.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'requestaccount' => 'Ménta rekening',
	'requestaccount-dup' => "'''CATETAN: Anjeun geus asup log migunakeun rekening nu geus kadaptar.'''",
	'requestaccount-leg-user' => 'Rekening pamaké',
	'requestaccount-leg-areas' => 'Widang pangaresep/minat',
	'requestaccount-leg-person' => 'Émbaran pribadi',
	'requestaccount-leg-other' => 'Émbaran lianna',
	'requestaccount-real' => 'Ngaran asli:',
	'requestaccount-same' => '(sarua jeung ngaran asli)',
	'requestaccount-email' => "Alamat surélék (''e-mail''):",
	'requestaccount-reqtype' => 'Posisi:',
	'requestaccount-level-0' => 'pangarang',
	'requestaccount-level-1' => 'éditor',
	'requestaccount-bio' => 'Biografi pribadi:',
	'requestaccount-attach' => 'Résumeu atawa CV (teu wajib):',
	'requestaccount-notes' => 'Catetan panambih:',
	'requestaccount-urls' => 'Béréndélan ramatloka, mun aya (pisahkeun ku baris anyar):',
	'requestaccount-tooshort' => 'Biografi anjeun sahanteuna kudu ngandung $1 kecap.',
	'requestaccount-exts' => 'Jenis lampiran nu dimuatkeun dipahing.',
	'requestaccount-submit' => 'Pénta rekening',
	'requestaccount-sent' => 'Paménta rekening anjeun anggeus dikirim sarta rék dipariksa heula.',
	'request-account-econf' => 'Alamat surélék anjeun geus dikonfirmasi sarta bakal ditambahkeun kana paménta rekening anjeun.',
	'requestaccount-email-subj' => 'Konfirmasi alamat surélék {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'Paménta rekening {{SITENAME}}',
	'requestaccount-loginnotice' => "Pikeun miboga rekening pamaké, anjeun kudu '''[[Special:RequestAccount|daptar heula]]'''.",
	'confirmaccounts' => 'Konfirmasi pamundut rekening',
	'confirmedit-desc' => 'Leler birokrat kawenangan ngonfirmasi paménta rekening.',
	'confirmaccount-real-q' => 'Ngaran',
	'confirmaccount-email-q' => 'Surélék',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'keur dipénta',
	'confirmaccount-showrej' => 'paménta nu ditolak',
	'confirmaccount-showheld' => 'paménta ngagantung',
	'confirmaccount-showexp' => 'paménta kadaluwarsa',
	'confirmaccount-types' => 'Pilih antrian konfirmasi rekening di handap:',
	'confirmaccount-all' => '(témbongkeun sakabéh antrian)',
	'confirmaccount-type' => 'Antrian:',
	'confirmaccount-leg-user' => 'Rekening pamaké',
	'confirmaccount-leg-areas' => 'Widang karesep/minat',
	'confirmaccount-leg-person' => 'Émbaran pribadi',
	'confirmaccount-leg-other' => 'Émbaran lianna',
	'confirmaccount-name' => 'Landihan',
	'confirmaccount-real' => 'Ngaran:',
	'confirmaccount-email' => 'Surélék:',
	'confirmaccount-reqtype' => 'Posisi:',
	'confirmaccount-pos-0' => 'pangarang',
	'confirmaccount-pos-1' => 'éditor',
	'confirmaccount-bio' => 'Biografi:',
	'confirmaccount-attach' => 'Résumeu/CV:',
	'confirmaccount-notes' => 'Catetan panambih:',
	'confirmaccount-urls' => 'Béréndélan ramatloka:',
	'confirmaccount-none-p' => '(teu disadiakeun)',
	'confirmaccount-confirm' => 'Pilih di handap pikeun nampa, nolak, atawa ngagantung ieu paménta:',
	'confirmaccount-econf' => '(geus dikonfirmasi)',
	'confirmaccount-reject' => '(ditolak ku [[User:$1|$1]] jam $2)',
	'confirmaccount-autorej' => '(paménta ieu sacara otomatis dipiceun kusabab teu aktif)',
	'confirmaccount-held' => '("keur ditahan" ku [[User:$1|$1]] jam $2)',
	'confirmaccount-create' => 'Tampa (jieun rekening)',
	'confirmaccount-hold' => 'Tahan',
	'confirmaccount-spam' => 'Spam (ulah kirim surélék)',
	'confirmaccount-reason' => 'Pamanggih (bakal dimuat dina surélék):',
	'confirmaccount-ip' => 'Alamat IP:',
	'confirmaccount-submit' => 'Konfirmasi',
	'confirmaccount-needreason' => 'Anjeun kudu méré alesan dina kotak pamanggih di handap.',
	'confirmaccount-canthold' => 'Ieu paménta keur digantung atawa geus dihapus.',
	'confirmaccount-acc' => 'Paménta rekening geus dikonfirmasi; rekening anyar geus dijieun pikeun [[User:$1|$1]].',
	'confirmaccount-wsum' => 'Wilujeng sumping!',
	'usercredentials-user' => 'Ngaran pamaké:',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Fluff
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 */
$messages['sv'] = array(
	'requestaccount' => 'Ansök om konto',
	'requestaccount-text' => "'''Fyll i och skicka följande formulär för att ansöka om ett konto.'''

Se till att du har läst [[{{MediaWiki:Requestaccount-page}}|användningsvillkoren]] innan du frågar efter ett konto.

När din ansökan har godkänts, så kommer ett e-postmeddelande skickas till dig och du kan [[Special:UserLogin|logga in]] på ditt konto.",
	'requestaccount-page' => '{{ns:project}}:Användningsvillkor',
	'requestaccount-dup' => "'''Notera: Du är redan inloggad med ett registrerat konto.'''",
	'requestaccount-leg-user' => 'Användarkonto',
	'requestaccount-leg-areas' => 'Intresseområden',
	'requestaccount-leg-person' => 'Personlig information',
	'requestaccount-leg-other' => 'Annan information',
	'requestaccount-leg-tos' => 'Användarvillkor',
	'requestaccount-acc-text' => 'När du skickar in den här ansökningen så kommer ett bekräftelsemeddelande skickas till din e-postadress. Svara på det meddelandet genom att klicka på bekräftelselänken i e-brevet. Till din e-postadress kommer även ditt lösenord skickas när ditt konto har skapats.',
	'requestaccount-areas-text' => 'Välj här de ämnesområden som du har expertkunskap om eller som du kommer att arbeta mest med.',
	'requestaccount-ext-text' => 'Följande information kommer hållas hemlig och bara användas för denna ansökan.
Om du vill kan du här ange kontaktinformation, t.ex. telefonnummer, för att lättare bekräfta din identitet.',
	'requestaccount-bio-text' => 'Din biografi kommer användas som standardinnehåll på din användarsida.
Försök att ange dina meriter och referenser.
Men se till att du inte besväras av att publicera sådan information.
Ditt namn kan du ändra i [[Special:Preferences|dina inställningar]].',
	'requestaccount-real' => 'Riktigt namn:',
	'requestaccount-same' => '(samma som ditt riktiga namn)',
	'requestaccount-email' => 'E-postadress:',
	'requestaccount-reqtype' => 'Ställning:',
	'requestaccount-level-0' => 'författare',
	'requestaccount-level-1' => 'redaktör',
	'requestaccount-bio' => 'Personlig biografi:',
	'requestaccount-attach' => 'Meritförteckning/CV (frivilligt):',
	'requestaccount-notes' => 'Andra anmärkningar',
	'requestaccount-urls' => 'Lista över webbplatser (skriv en per rad om det är flera):',
	'requestaccount-agree' => 'Du måste bekräfta att ditt namn är riktigt och att du accepterar våra användningsvillkor.',
	'requestaccount-inuse' => 'Användarnamnet används redan i en kontoansökan som väntar på att godkännas.',
	'requestaccount-tooshort' => 'Din biografi måste innehålla minst  {{PLURAL:$1|ett ord|$1 ord}}.',
	'requestaccount-emaildup' => 'Samma e-postadress används i en annan kontoansökan som väntar på att godkännas.',
	'requestaccount-exts' => 'Den bifogade filen har en otillåten filtyp.',
	'requestaccount-resub' => 'Av säkerhetsskäl måste du välja filen med din meritförteckning/CV igen.
Lämna fältet tomt om du inte längre vill bifoga någon fil.',
	'requestaccount-tos' => 'Jag har läst och lovar att följa [[{{MediaWiki:Requestaccount-page}}|användningsvillkoren]] på {{SITENAME}}.
Namnet som jag angivit som "Riktigt namn" är verkligen mitt egna riktiga namn.',
	'requestaccount-submit' => 'Ansök om konto',
	'requestaccount-sent' => 'Din kontoansökan har nu skickats och väntar på att godkännas.
Du har fått en bekräftelse tll din e-post adress.',
	'request-account-econf' => 'Din e-postadress har bekräftats. Det kommer att anges i din kontoansökan.',
	'requestaccount-email-subj' => 'Bekräftelse av e-postadress på {{SITENAME}}',
	'requestaccount-email-body' => 'Någon, förmodligen du från IP-adressen $1, har ansökt om kontot "$2" med den här e-postadressen på {{SITENAME}}.

För att bekräfta att det är du som ansökt om detta konto på {{SITENAME}} så måste du öppna följande länk i din webbläsare:

$3

Om kontot skapas så kommer lösenordet skickas via e-post endast till dig. Om det *inte* är du som gjort ansökan, följ då inte länken.
Den här bekräftelsekoden slutar gälla den $4.',
	'requestaccount-email-subj-admin' => 'Ansökan om konto på {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" har ansökt om ett konto och väntar på att godkännas.
E-postadressen har bekräftats. Du kan godkänna ansökan på
$2',
	'acct_request_throttle_hit' => 'Du har redan ansökt om {{PLURAL:$1|1 konto|$1 konton}}.
Du kan inte göra fler ansökningar.',
	'requestaccount-loginnotice' => "För att få ett användarkonto måste du '''[[Special:RequestAccount|ansöka om det]]'''.",
	'confirmaccount-newrequests' => "Just nu väntar '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|kontoansökning|kontoansökningar}}]] med bekräftad e-postadress på att behandlas.",
	'confirmaccounts' => 'Behandla kontoansökningar',
	'confirmedit-desc' => 'Gör att nya användare måste ansöka om ett konto och bekräftas av byråkrater',
	'confirmaccount-maintext' => "'''Den här sidan används för att verifiera kontoansökningar på ''{{SITENAME}}'''''.

Varje ansökningskö består av tre delköer, en för obehandlade ansökningar, en för ansökningar som avvaktar ytterligare information, och en för ansökningar som nyligen avslagits.

Granska noggrant ansökningar du svarar på, och verifiera informationen om det behövs.
De åtgärder du utför här skrivs in i en privat logg. Du förväntas även kontrollera hur andra användare hanterar ansökningar.",
	'confirmaccount-list' => 'Härunder finns en lista över kontoansökningar som väntar på att godkännas. När en ansökning godkänns eller avslås så tas den bort från den här listan.',
	'confirmaccount-list2' => 'Härunder finns en lista över kontoansökningar som nyligen avslagits. De kan komma att raderas automatiskt efter ett visst antal dagar.
Du kan fortfarande godkänna ansökningarna, men i så fall bör du först diskutera det med den administratör som avslog ansökningen.',
	'confirmaccount-list3' => 'Härunder finns en lista över utgångna kontoansökningar som automatiskt kan komma att tas bort om några dagar. Tills dess kan ansökningarna fortfarande godkännas.',
	'confirmaccount-text' => "Det här är en ansökan om ett konto på '''{{SITENAME}}'''.

Granska informationen härunder noggrant. Om du godkänner ansökningen så kan du använda ställningslistan för att välja kontostatus för den nya användaren.

Redigeringar av den ansökandes biografi kommer inte påverka vad som sparas permanent för användarens referenser. Observera att du kan välja att skapa kontot under ett annat användarnamn, men gör det bara för att undvika kollisioner med andra namn.

Om du lämnar den här sidan utan att godkänna eller avslå ansökan, så kommer ansökan att finnas kvar i sin nuvarande kö.",
	'confirmaccount-none-o' => 'För närvarande finns inga obehandlade kontoansökningar.',
	'confirmaccount-none-h' => 'För närvarande finns inga avvaktande kontoansökningar.',
	'confirmaccount-none-r' => 'Inga kontoansökningar har avslagits nyligen.',
	'confirmaccount-none-e' => 'För närvarande finns inga utgångna kontoansökningar.',
	'confirmaccount-real-q' => 'Namn',
	'confirmaccount-email-q' => 'E-post',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'obehandlade ansökningar',
	'confirmaccount-showrej' => 'avslagna ansökningar',
	'confirmaccount-showheld' => 'avvaktande ansökningar',
	'confirmaccount-showexp' => 'utgångna ansökningar',
	'confirmaccount-review' => 'Granska',
	'confirmaccount-types' => 'Välj någon av ansökningslistorna härunder:',
	'confirmaccount-all' => '(visa alla köer)',
	'confirmaccount-type' => 'Kö:',
	'confirmaccount-type-0' => 'ansökande författare',
	'confirmaccount-type-1' => 'ansökande redaktörer',
	'confirmaccount-q-open' => 'obehandlade ansökningar',
	'confirmaccount-q-held' => 'avvaktande ansökningar',
	'confirmaccount-q-rej' => 'nyligen avslagna ansökningar',
	'confirmaccount-q-stale' => 'utgångna ansökningar',
	'confirmaccount-badid' => 'Det finns ingen ansökan med det ID som angavs.
Ansökan kanske redan har behandlats.',
	'confirmaccount-leg-user' => 'Användarkonto',
	'confirmaccount-leg-areas' => 'Intresseområden',
	'confirmaccount-leg-person' => 'Personlig information',
	'confirmaccount-leg-other' => 'Annan information',
	'confirmaccount-name' => 'Användarnamn',
	'confirmaccount-real' => 'Namn:',
	'confirmaccount-email' => 'E-post:',
	'confirmaccount-reqtype' => 'Ställning:',
	'confirmaccount-pos-0' => 'författare',
	'confirmaccount-pos-1' => 'redaktör',
	'confirmaccount-bio' => 'Biografi:',
	'confirmaccount-attach' => 'Meritförteckning/CV:',
	'confirmaccount-notes' => 'Andra anmärkningar:',
	'confirmaccount-urls' => 'Lista över webbplatser:',
	'confirmaccount-none-p' => '(bifogades ej)',
	'confirmaccount-confirm' => 'Välj något av alternativen nedan för att godkänna, avslå, eller avvakta med ansökan:',
	'confirmaccount-econf' => '(bekräftad)',
	'confirmaccount-reject' => '(avslogs av [[User:$1|$1]] den $2)',
	'confirmaccount-rational' => 'Motivering som gavs till den sökande:',
	'confirmaccount-noreason' => '(ingen)',
	'confirmaccount-autorej' => '(den här ansökningen har kasserats automatiskt på grund av inaktvitet)',
	'confirmaccount-held' => '(markerad som "avvaktande" av [[User:$1|$1]] den $2)',
	'confirmaccount-create' => 'Godkänn (skapa konto)',
	'confirmaccount-deny' => 'Avslå (stryk från listan)',
	'confirmaccount-hold' => 'Avvakta',
	'confirmaccount-spam' => 'Spam (sänd inte e-post)',
	'confirmaccount-reason' => 'Kommentar (skickas som e-post):',
	'confirmaccount-ip' => 'IP-adress:',
	'confirmaccount-legend' => 'Bekräfta/avvisa detta konto',
	'confirmaccount-submit' => 'Bekräfta',
	'confirmaccount-needreason' => 'Du måste skriva en motivering i kommentarrutan nedan.',
	'confirmaccount-canthold' => 'Ansökningen är antingen redan avvaktande eller har avslagits.',
	'confirmaccount-acc' => 'Kontoansökningen har godkänts och användarkontot [[User:$1|$1]] har skapats.',
	'confirmaccount-rej' => 'Ansökningen har avslagits.',
	'confirmaccount-viewing' => '(granskas just nu av [[User:$1|$1]])',
	'confirmaccount-summary' => 'Skapar användarsida med biografi för en ny användare.',
	'confirmaccount-welc' => "'''Välkommen till ''{{SITENAME}}''!''' Vi hoppas att du kommer skriva många bra bidrag.
Du kommer formodligen ha nytta av att läsa [[{{MediaWiki:Helppage}}|hjälpsidorna]]. Vi önskar igen välkommen och ha kul!",
	'confirmaccount-wsum' => 'Välkommen!',
	'confirmaccount-email-subj' => 'Ansökan om konto på {{SITENAME}}',
	'confirmaccount-email-body' => 'Din ansökan om ett konto på {{SITENAME}} har godkänts.

Användarnamn: $1

Lösenord: $2

Av säkerhetsskäl måste du byta lösenord första gången du loggar in. För att logga in, gå till {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Din ansökan om ett konto på {{SITENAME}} har godkänts.

Användarnamn: $1

Lösenord: $2

$3

Av säkerhetsskäl måste du byta lösenord första gången du loggar in. För att logga in, gå till {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Tyvärr har din ansökan om kontot "$1" på {{SITENAME}} avslagits.

Det kan finnas flera orsaker till det.
Det är möjligt att du inte fyllde i formuläret på rätt sätt, att du inte gav tillräckligt utförliga svar, eller att du på något annat sätt inte uppfyller villkoren för att få ett användarkonto.
Det kan finnas kontaktinformation på webbplatsen som du kan använda om du vill få mer information om reglerna för användarkonton.',
	'confirmaccount-email-body4' => 'Tyvärr har din ansökan om kontot "$1" på {{SITENAME}} avslagits.

$2

Det kan finnas kontaktinformation på webbplatsen som du kan använda om du vill få mer information om reglerna för användarkonton.',
	'confirmaccount-email-body5' => 'Innan din ansökan om kontot "$1" på {{SITENAME}} kan godkännas så måste du lämna ytterligare information.

$2

Det kan finnas kontaktinformation på webbplatsen som du kan använda om du vill få mer information om reglerna för användarkonton.',
	'usercredentials' => 'Referenser för användare',
	'usercredentials-leg' => 'Se bekräftade referenser för en användare',
	'usercredentials-user' => 'Användarnamn:',
	'usercredentials-text' => 'Härunder visas de bekräftade referenserna för det valda användarkontot.',
	'usercredentials-leg-user' => 'Användarkonto',
	'usercredentials-leg-areas' => 'Intresseområden',
	'usercredentials-leg-person' => 'Personlig information',
	'usercredentials-leg-other' => 'Annan information',
	'usercredentials-email' => 'E-post:',
	'usercredentials-real' => 'Riktigt namn:',
	'usercredentials-bio' => 'Biografi:',
	'usercredentials-attach' => 'Meritförteckning/CV:',
	'usercredentials-notes' => 'Andra anmärkningar:',
	'usercredentials-urls' => 'Lista över webbplatser:',
	'usercredentials-ip' => 'Ursprunglig IP-adress:',
	'usercredentials-member' => 'Rättigheter:',
	'usercredentials-badid' => 'Hittade inga referenser för denna användare. Kontrollera att namnet är rättstavat.',
	'right-confirmaccount' => 'Visa [[Special:ConfirmAccounts|kön av kontoansökningar]]',
	'right-requestips' => 'Visa sökandens IP-adress vid behandling av kontoansökningar',
	'right-lookupcredentials' => 'Visa [[Special:UserCredentials|användaruppgifter]]',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'confirmaccount-real-q' => 'Mjano',
	'confirmaccount-real' => 'Mjano:',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'confirmaccount-name' => 'பயனர் பெயர்',
	'usercredentials-user' => 'பயனர் பெயர்:',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'requestaccount' => 'ఖాతాను అభ్యర్ధించండి',
	'requestaccount-text' => "'''వాడుకరి ఖాతా కోసం కింది ఫారమును నింపి పంపించండి'''.

ఖాతా కావాలని అడిగే ముందు [[{{MediaWiki:Requestaccount-page}}|సేవా నియమాలను]] తప్పక చదవండి.

ఖాతాను అనుమతించాక, ఆ సంగతి తెలుపుతూ మీకో ఈమెయిలు వస్తుంది. ఖాతా వివరాలను [[Special:UserLogin]] వద్ద వాడుకోవచ్చు.",
	'requestaccount-page' => '{{ns:project}}:సేవా నియమాలు',
	'requestaccount-dup' => "'''గమనిక: మీరు ఈసరికే నమోదైన ఖాతాతో లోనికి ప్రవేశించారు.'''",
	'requestaccount-leg-user' => 'వాడుకరి ఖాతా',
	'requestaccount-leg-areas' => 'ప్రధాన ఆసక్తులు',
	'requestaccount-leg-person' => 'వ్యక్తిగత సమాచారం',
	'requestaccount-leg-other' => 'ఇతర సమాచారం',
	'requestaccount-leg-tos' => 'సేవా నియమాలు',
	'requestaccount-acc-text' => 'మీరీ అభ్యర్ధన పంపించగానే మీ ఈమెయిలుకో ధృవీకరణ సందేశం వస్తుంది. దానిలో ఉన్న షృవీకరణ లింకును నొక్కండి. మీ ఖాతా తయారు కాగానే మీ సంకేతపదాన్ని కూడా పంపిస్తాం.',
	'requestaccount-areas-text' => 'కింది విషయాల లోంచి మీకు ప్రవేశం ఉన్న వాటిని లేదా మీరు పనిచేయదలచిన వాటిని ఎంచుకోండి.',
	'requestaccount-ext-text' => 'కింది సమాచారాన్ని గోప్యంగా ఉంచుతాం, ఈ అభ్యర్ధన కోసం మాత్రమే వాడుతాం.
మిమ్మల్ని గుర్తించటంలో సాయపడే ఫోను నంబరు వంటి పరిచయ వివరాలను ఇవ్వవచ్చు.',
	'requestaccount-bio-text' => 'మీ వ్యక్తిగత వివరాలే మీ వాడుకరిపేజీకి డిఫాల్టు కంటెంటుగా ఉంటుంది.
ఇంకా ఏమైనా చేర్చాలంటే చేర్చండి.
మీకు ఇబ్బంది లేని సమాచారాన్ని మాత్రమే ప్రచురించండి.
[[Special:Preferences|మీ అభిరుచులు]] కు వెళ్ళి మీ పేరును మార్చుకోవచ్చు.',
	'requestaccount-real' => 'అసలు పేరు:',
	'requestaccount-same' => '(వాస్తవిక పేరు ఏదో అదే)',
	'requestaccount-email' => 'ఈమెయిలు చిరునామా:',
	'requestaccount-reqtype' => 'స్థానము:',
	'requestaccount-level-0' => 'రచయిత',
	'requestaccount-level-1' => 'సంపాదకులు',
	'requestaccount-bio' => 'వ్యక్తిగత జీవితచరిత్ర:',
	'requestaccount-attach' => 'రెజ్యూమె లేదా CV (మీ ఇష్టం):',
	'requestaccount-notes' => 'అదనపు గమనికలు:',
	'requestaccount-urls' => 'వెబ్&zwnj;సైట్ల జాబితా, ఉంటే గనక (లైనుకి ఒకటి చొప్పున):',
	'requestaccount-agree' => 'మీ నిజమైన పేరు సరియేనని మరియు మా సేవా నియమాలని మీరు అంగీకరిస్తున్నారని దృవపరచాలి.',
	'requestaccount-inuse' => 'వాడుకరిపేరు ఈసరికే వేచివున్న ఖాతా అభ్యర్థనలలో ఉంది.',
	'requestaccount-tooshort' => 'మీ బయోగ్రఫీ తప్పనిసరిగా కనీసం $1 {{PLURAL:$1|పదం |పదాల}} పొడవు ఉండాలి.',
	'requestaccount-emaildup' => 'మరో వేచివున్న ఖాతా అభ్యర్థన ఇదే ఈ-మెయిల్ చిరునామాని వాడుతుంది.',
	'requestaccount-exts' => 'జోడించిన ఫైలు రకానికి అనుమతి లేదు.',
	'requestaccount-resub' => 'భద్రతా కారణాల రీత్యా మీ CV/రెజ్యూమె ఫైలును తిరిగి ఎంచుకోవాలి.
అసలు దేన్నీ పెట్టదలచకపోతే ఈ ఫీల్డును ఖాళీగా వదిలెయ్యండి.',
	'requestaccount-tos' => '{{SITENAME}} యొక్క [[{{MediaWiki:Requestaccount-page}}|సేవా నియమాలను]] చదివాను. వాటికి బద్ధుడనై/బద్ధురాలనై ఉంటాను.
"అసలు పేరు" కింద నేను ఇచ్చిన పేరు నిజంగానే నా అసలు పేరు.',
	'requestaccount-submit' => 'ఖాతాని అభ్యర్థించండి',
	'requestaccount-sent' => 'ఈ ఖాతా అభ్యర్థనని విజయవంతంగా పంపించాం. అది సమీక్షకై వేచివుంది.',
	'request-account-econf' => 'మీ ఈ-మెయిల్ చిరునామా నిర్థారితమయ్యింది మరియు మీ ఖాతా అభ్యర్థనలో అలానే నమోదవుతుంది.',
	'requestaccount-email-subj' => '{{SITENAME}} ఈ-మెయిల్ చిరునామా నిర్ధారణ',
	'requestaccount-email-body' => '{{SITENAME}} లో $1 ఐపీ అడ్రసు నుండి ఎవరో, బహుశా మీరే, ఈ ఈమెయిలు అడ్రసుతో "$2" ఖాతా కావాలని అభ్యర్ధించారు.

{{SITENAME}} లోని ఈ ఖాతా నిజంగానే మీదేనని నిర్ధారించేందుకు, ఈ లింకును మీ బ్రౌజరులో తెరవండి:

$3

ఖాతా సృష్టించబడితే, మీకు మాత్రమే సంకేతపదం ఈ-మెయిలులో వస్తుంది.
ఖాతా అభ్యర్థించినది మీరు *కాకపోతే*, ఆ లింకును నొక్కకండి.
ఈ నిర్థారణ సంకేతం $4 నాడు కాలం చెల్లుతుంది.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} ఖాతా అభ్యర్థన',
	'requestaccount-email-body-admin' => '"$1" ఓ ఖాతా కావాలని అడిగి నిర్ధారణ కోసం చూస్తున్నారు.
ఈ-మెయిలు అడ్రసు నిర్ధారణైంది. మీ అభ్యర్ధనను "$2" వద్ద నిర్ధారించవచ్చు.',
	'acct_request_throttle_hit' => 'క్షమించండి, మీరిప్పటికే {{PLURAL:$1|1 ఖాతాను|$1 ఖాతాలను}} అభ్యర్ధించారు. ఇంకా ఎక్కవ అభ్యర్థనలు చెయ్యలేరు.',
	'requestaccount-loginnotice' => "ఖాతా పొందడానికి, మీరు తప్పనిసరిగా '''[[Special:RequestAccount|అభ్యర్థించాలి]]'''.",
	'confirmaccount-newrequests' => "ప్రస్తుతం '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|ఖాతా అభ్యర్థన]]|[[Special:ConfirmAccounts|ఖాతా అభ్యర్థనలు]]}} వేచి{{PLURAL:$1|వుంది|వున్నాయి}}.",
	'confirmaccounts' => 'ఖాతా అభ్యర్థనలను నిర్ధారించండి',
	'confirmedit-desc' => 'అధికారులకు ఖాతా అభ్యర్థనలను నిర్ధారించే వీలుకల్పిస్తుంది',
	'confirmaccount-none-o' => 'ప్రస్తుతం ఈ జాబితాలో పెండింగులో ఉన్న తెరచి ఉన్న అభ్యర్ధనలేమీ లేవు.',
	'confirmaccount-none-h' => 'ప్రస్తుతం ఈ జాబితాలో అట్టేపెట్టిన పెండింగు అభ్యర్ధనలేమీ లేవు.',
	'confirmaccount-none-r' => 'ప్రస్తుతం ఈ జాబితాలో ఇటీవల తిరస్కరించిన ఖాతా అభ్యర్థనలు ఏమీలేవు.',
	'confirmaccount-none-e' => 'ప్రస్తుతం ఈ జాబితాలో మురిగిపోయిన ఖాతాల అభ్యర్ధనలేమీ లేవు.',
	'confirmaccount-real-q' => 'పేరు',
	'confirmaccount-email-q' => 'ఈ-మెయిల్',
	'confirmaccount-bio-q' => 'బయోగ్రఫీ',
	'confirmaccount-showopen' => 'తెరచి ఉన్న అభ్యర్ధనలు',
	'confirmaccount-showrej' => 'తిరస్కరించిన అభ్యర్ధనలు',
	'confirmaccount-showheld' => 'అట్టేపెట్టిన ఉన్న అభ్యర్ధనలు',
	'confirmaccount-showexp' => 'కాలంచెల్లిన అభ్యర్థనలు',
	'confirmaccount-review' => 'సమీక్ష',
	'confirmaccount-types' => 'కిందివాటిలోంచి ఒక ఖాతా నిర్ధారణ క్యూను ఎంచుకోండి:',
	'confirmaccount-all' => '(క్యూలన్నిటినీ చూపించు)',
	'confirmaccount-type' => 'క్యూ:',
	'confirmaccount-type-0' => 'కాబోయే రచయితలు',
	'confirmaccount-type-1' => 'కాబోయే సంపాదకులు',
	'confirmaccount-q-open' => 'తెరచి ఉన్న అభ్యర్ధనలు',
	'confirmaccount-q-held' => 'అట్టేపెట్టిన అభ్యర్ధనలు',
	'confirmaccount-q-rej' => 'ఇటీవల తిరస్కరించిన అభ్యర్థనలు',
	'confirmaccount-q-stale' => 'మురిగిపోయిన అభ్యర్ధనలు',
	'confirmaccount-badid' => 'ఇచ్చిన IDకి సరిపోలిన పెండింగు అభ్యర్ధనలేమీ లేవు.
దాన్ని ఇప్పటికే పరిశీలించి ఉండవచ్చు.',
	'confirmaccount-leg-user' => 'వాడుకరి ఖాతా',
	'confirmaccount-leg-areas' => 'ప్రధాన ఆసక్తులు',
	'confirmaccount-leg-person' => 'వ్యక్తిగత సమాచారం',
	'confirmaccount-leg-other' => 'ఇతర సమాచారం',
	'confirmaccount-name' => 'వాడుకరి పేరు',
	'confirmaccount-real' => 'పేరు:',
	'confirmaccount-email' => 'ఈ-మెయిల్:',
	'confirmaccount-reqtype' => 'స్థానం:',
	'confirmaccount-pos-0' => 'రచయిత',
	'confirmaccount-pos-1' => 'రచయిత',
	'confirmaccount-bio' => 'బయోగ్రఫీ:',
	'confirmaccount-attach' => 'రెస్యూమె/సీవీ:',
	'confirmaccount-notes' => 'అదనపు గమనికలు:',
	'confirmaccount-urls' => 'వెబ్ సైట్ల జాబితా:',
	'confirmaccount-none-p' => '(ఇవ్వలేదు)',
	'confirmaccount-confirm' => 'ఈ అభ్యర్థనను అంగీకరించడానికి, తిరస్కరించడానికి, లేదా ఆపివుంచడానికి ఈ క్రింది ఎంపికలు వాడండి:',
	'confirmaccount-econf' => '(ధృవీకరించబడినది)',
	'confirmaccount-reject' => '($2 నాడు [[User:$1|$1]] తిరస్కరించారు)',
	'confirmaccount-rational' => 'అభ్యర్థికి తెలుపాల్సిన కారణం:',
	'confirmaccount-noreason' => '(ఏమీలేదు)',
	'confirmaccount-held' => '($2 నాడు [[User:$1|$1]] "ఆపివుంచు" అని గుర్తించారు)',
	'confirmaccount-create' => 'అంగీకరించు (ఖాతా సృష్టించు)',
	'confirmaccount-deny' => 'తిరస్కరించు (జాబితానుండి తీసివేయి)',
	'confirmaccount-hold' => 'ఆపివుంచు',
	'confirmaccount-reason' => 'వ్యాఖ్య (ఈ-మెయిల్&zwnj;లో చేర్చుతాం):',
	'confirmaccount-ip' => 'ఐపీ చిరునామా:',
	'confirmaccount-submit' => 'నిర్ధారించు',
	'confirmaccount-needreason' => 'క్రిందనిచ్చిన వ్యాఖ్య పెట్టెలో తప్పనిసరిగా ఓ కారణం ఇవ్వాలి',
	'confirmaccount-canthold' => 'ఈ అభ్యర్థనని ఈపాటికే ఆపివుంచారు లేదా తొలగించారు.',
	'confirmaccount-acc' => 'ఖాతా అభ్యర్థనని విజయవంతంగా నిర్థారించారు; [[User:$1|$1]] అనే కొత్త వాడుకరి ఖాతాని సృష్టించాం.',
	'confirmaccount-rej' => 'ఖాతా కోసం చేసిన అభ్యర్ధన తిరస్కరించబడినది',
	'confirmaccount-viewing' => '(ప్రస్తుతం [[User:$1|$1]] చూస్తున్నారు)',
	'confirmaccount-summary' => 'కొత్త వాడుకరి యొక్క బయోగ్రఫీతో వాడుకరి పేజీ సృష్టిస్తున్నాం',
	'confirmaccount-wsum' => 'స్వాగతం!',
	'confirmaccount-email-subj' => '{{SITENAME}} ఖాతా అభ్యర్థన',
	'confirmaccount-email-body' => '{{SITENAME}}లో ఖాతా కొరకు మీ అభ్యర్థనని సమ్మతించాము.

ఖాతా పేరు: $1

సంకేతపదం: $2

భద్రతా కారణాల వల్ల మీ మొదటి ప్రవేశంలో మీ సంకేతపదాన్ని మార్చుకోవాలి. ప్రవేశించడానికి, {{fullurl:Special:UserLogin}}కి వెళ్ళండి.',
	'confirmaccount-email-body2' => '{{SITENAME}}లో ఖాతా కొరకు మీ అభ్యర్థనని సమ్మతించాము.

ఖాతా పేరు: $1

సంకేతపదం: $2

$3

భద్రతా కారణాల వల్ల మీ మొదటి ప్రవేశంలో మీ సంకేతపదాన్ని మార్చుకోవాలి. ప్రవేశించడానికి, {{fullurl:Special:UserLogin}}కి వెళ్ళండి.',
	'confirmaccount-email-body4' => 'క్షమించండి, {{SITENAME}}లో "$1" అనే ఖాతా కొరకు మీ అభ్యర్థనని తిరస్కరించారు.

$2

వాడుకరి ఖాతా విధానం గురించి మీరు మరింత తెలుసుకోవాలనుంటే పైటులో సంప్రదింపు చిరునామాని వాడవచ్చు.',
	'confirmaccount-email-body5' => '{{SITENAME}}లో "$1" అనే ఖాతా కొరకు మీ అభ్యర్థనని అంగీకరించాలంటే మీరు తప్పనిసరిగా మరింత అదనపు సమాచారం ఇవ్వాలి.

$2

వాడుకరి ఖాతా విధానం గురించి మీరు మరింత తెలుసుకోవాలనుకుంటే పైటులో సంప్రదింపు చిరునామాని వాడవచ్చు.',
	'usercredentials' => 'వాడుకరి తాఖీదులు',
	'usercredentials-user' => 'వాడుకరి పేరు:',
	'usercredentials-leg-user' => 'వాడుకరి ఖాతా',
	'usercredentials-leg-areas' => 'ప్రధాన ఆసక్తులు',
	'usercredentials-leg-person' => 'వ్యక్తిగత సమాచారం',
	'usercredentials-leg-other' => 'ఇతర సమాచారం',
	'usercredentials-email' => 'ఈ-మెయిల్:',
	'usercredentials-real' => 'నిజమైన పేరు:',
	'usercredentials-bio' => 'బయోగ్రఫీ:',
	'usercredentials-attach' => 'రెస్యూమె/సీవీ:',
	'usercredentials-notes' => 'అదనపు గమనికలు:',
	'usercredentials-urls' => 'వెబ్&zwnj;సైట్ల జాబితా:',
	'usercredentials-ip' => 'అసలు IP చిరునామా:',
	'usercredentials-member' => 'హక్కులు:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'requestaccount-email' => 'Diresaun korreiu eletróniku:',
	'requestaccount-level-0' => 'autór',
	'confirmaccount-real-q' => 'Naran',
	'confirmaccount-email-q' => 'Korreiu eletróniku',
	'confirmaccount-real' => 'Naran:',
	'confirmaccount-email' => 'Korreiu eletróniku:',
	'confirmaccount-pos-0' => 'autór',
	'confirmaccount-ip' => 'Diresaun IP:',
	'usercredentials-email' => 'Korreiu eletróniku:',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'requestaccount' => 'Дархости ҳисоб',
	'requestaccount-text' => "'''Форми зеринро барои дархости ҳисоби корбарӣ пур карда ирсол кунед'''.

Мутмани бошед, ки шумо аввал [[{{MediaWiki:Requestaccount-page}}|Шартҳои Хидматро]] қабл аз дахости ҳисоб хондаед.

Дар ҳоли тасдиқ шудани ҳисоб, паёми огоҳсозӣ тариқи почтаи электронӣ ба шумо фиристода хоҳад шуд ва ҳисоби шумо дар [[Special:UserLogin]] қобили истифода хоҳад шуд.",
	'requestaccount-page' => '{{ns:project}}:Шартҳои Хидмат',
	'requestaccount-dup' => "'''Эзоҳ: Шумо аллакай бо ҳисоби сабтшуда вуруд кардаед.'''",
	'requestaccount-leg-user' => 'Ҳисоби корбар',
	'requestaccount-leg-person' => 'Иттилооти шахсӣ',
	'requestaccount-leg-other' => 'Иттилооти дигар',
	'requestaccount-acc-text' => 'Ба нишонаи почтаи электронии шумо паёми тасдиқи дар ҳоли фиристодани ин дархост фиристода хоҳад шуд.
Лутфан бо клик кардани пайванди тасдиқии тариқи почтаи электронӣ фиристода шуда посух диҳед.
Гузарвожа низ дар ҳолати эҷод шудани ҳисоби шумо ба нишонаи почтаи электронӣ фиристода хоҳад шуд.',
	'requestaccount-bio-text' => 'Зиндагиномаи шумо дар саҳифаи корбариатон ҳамчун мӯҳтавои пешфарз ҷой дода хоҳад шуд.
Барои қарор додани ягон ихтиёроти худ кӯшиш кунед.
Мутмаин бошед, ки шумо барои мунташир кардани ин намуд иттилоот роҳатӣ ҳастед.
Номи шумо метавонад тариқи [[Special:Preferences]] тағйир дода шавад.',
	'requestaccount-real' => 'Номи аслӣ:',
	'requestaccount-same' => '(монанди номи аслӣ)',
	'requestaccount-email' => 'Нишонаи почтаи электронӣ:',
	'requestaccount-reqtype' => 'Вазифа:',
	'requestaccount-level-0' => 'муаллиф',
	'requestaccount-level-1' => 'вироишгар',
	'requestaccount-bio' => 'Зиндагиномаи шахсӣ:',
	'requestaccount-notes' => 'Эзоҳоти иловагӣ:',
	'requestaccount-urls' => 'Феҳристи сомонаҳо, агар зиёд бошад (бо сатрҳои ҷадид ҷудо кунед):',
	'requestaccount-agree' => 'Шумо бояд тасдиқ кунед ки номи аслии шумо дуруст аст ва шумо бо Шартҳои Хидмати мо розӣ ҳастед.',
	'requestaccount-inuse' => 'Номи корбарӣ аллакай дар истифодаи дархости ҳисоби дар тайбуда аст.',
	'requestaccount-tooshort' => 'Зиндагиномаи шумо бояд ҳадди ақал $1 дароз бошад.',
	'requestaccount-emaildup' => 'Дигар дархости ҳисоби дар тайбуда ҳамин нишонии почтаи электрониро истифода мебарад.',
	'requestaccount-exts' => 'Навъи замимавии парванда норавост.',
	'requestaccount-tos' => 'Ман [[{{MediaWiki:Requestaccount-page}}|Шартҳои Хидмати]] дар {{SITENAME}} бударо хондам ва бо онҳо вафодор ҳастам.
Номи мушаххаскардаи ман зери "Номи Аслӣ" дар ҳақиқат номи аслии худи ман аст.',
	'requestaccount-submit' => 'Дархости ҳисоб',
	'requestaccount-sent' => 'Дархост шумо бо муваффақият фиристода шуд ва ҳамакнун дар тайи баррасӣ аст.',
	'request-account-econf' => 'Нишонаи почтаи электронии шумо тасдиқ шуд ва ҳамин тавр дар дархости ҳисоби шумо феҳрист хоҳад шуд.',
	'requestaccount-email-subj' => '{{SITENAME}} тасдиқи нишонаи почтаи электронӣ',
	'requestaccount-email-body' => 'Шахсе, эҳтимолан шумо аз нишонаи IP $1, ҳисоби "$2" бо нишонаи почтаи электронӣ дар {{SITENAME}} дархост кард.

Барои тасдиқ, ки ин ҳисоб дар ҳақиқат ба шумо дар {{SITENAME}} таалуқ дорад, ин пайвандро дар мурургаратон боз кунед:

$3

Агар ҳисоб эҷод шуда бошад, танҳо ба шумо калимаи убур тариқи почтаи электронӣ фиристода хоҳад шуд.
Агар ин шумо *нест*, пайвандро дунбол накунед.
Ин коди тасдиқ дар $4 ба хотима хоҳад расид.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} дархости ҳисоб',
	'requestaccount-email-body-admin' => '"$1" ҳисоберо дархост кард ва мунтазири тасдиқи он мебошад.
Нишонаи почтаи электронӣ тасдиқ шуд. Шумо дархостро метавонед инҷо "$2" тасдиқ кунед.',
	'acct_request_throttle_hit' => 'Бубахшед, шумо аллакай $1 ҳисобҳо дархост кардед.
Шумо наметавонед аз ин зиёд дархост кунед.',
	'requestaccount-loginnotice' => "Барои дастрас кардани ҳисоби корбарӣ, шумо бояд '''[[Special:RequestAccount|дархост]]''' кунед.",
	'confirmaccounts' => 'Дархостҳои ҳисобҳоро тасдиқ кунед',
	'confirmaccount-list' => 'Дар зер феҳристи дархостҳои ҳисобҳои мунтазири тасдиқ оварда шудааст.
Дар ҳолати тасдиқ кардан ва ё рад кардани дархост, он аз ин феҳрист пок кардан хоҳад шуд.',
	'confirmaccount-real-q' => 'Ном',
	'confirmaccount-email-q' => 'Почтаи электронӣ',
	'confirmaccount-bio-q' => 'Зиндагинома',
	'confirmaccount-showopen' => 'дархостҳои кушод',
	'confirmaccount-showrej' => 'дархостҳои радшуда',
	'confirmaccount-review' => 'Пешнамоиш',
	'confirmaccount-q-open' => 'дархостҳои кушод',
	'confirmaccount-leg-user' => 'Ҳисоби корбарӣ',
	'confirmaccount-leg-person' => 'Иттилооти шахсӣ',
	'confirmaccount-leg-other' => 'Иттилооти дигар',
	'confirmaccount-name' => 'Номи корбарӣ',
	'confirmaccount-real' => 'Ном:',
	'confirmaccount-email' => 'Почтаи электронӣ:',
	'confirmaccount-reqtype' => 'Вазифа:',
	'confirmaccount-pos-0' => 'муаллиф',
	'confirmaccount-pos-1' => 'вироишгар',
	'confirmaccount-bio' => 'Зиндагинома:',
	'confirmaccount-notes' => 'Эзоҳоти иловагӣ:',
	'confirmaccount-urls' => 'Феҳристи сомонаҳо:',
	'confirmaccount-none-p' => '(пешниҳод нашудааст)',
	'confirmaccount-econf' => '(таъйидшуда)',
	'confirmaccount-noreason' => '(ҳеҷ)',
	'confirmaccount-create' => 'Қабул (эҷоди ҳисоб)',
	'confirmaccount-deny' => 'Рад (аз феҳрист гирифтан)',
	'confirmaccount-hold' => 'Нигоҳ доштан',
	'confirmaccount-spam' => 'Ҳаразнома (почтаи электронӣ нафиристед)',
	'confirmaccount-reason' => 'Тавзеҳ (дар паёми электронӣ илова хоҳад шуд):',
	'confirmaccount-ip' => 'Нишонаи IP:',
	'confirmaccount-submit' => 'Таъйид',
	'confirmaccount-needreason' => 'Шумо бояд далел дар ҷаъбаи тавзеҳ дар зер пешкаш намоед.',
	'confirmaccount-canthold' => 'Ин дархост аллакай ё нигоҳ дошта шудааст ё ҳазф шудааст.',
	'confirmaccount-acc' => 'Дархости ҳисоб бо муваффақият тасдиқ карда шуд; ҳисоби корбарии ҷадидӣ [[User:$1|$1]] эҷод шуд.',
	'confirmaccount-rej' => 'Дархости ҳисоб бо муваффақият рад карда шуд.',
	'confirmaccount-viewing' => '(ҳоло дар ҳоли дидан аст тавассути [[User:$1|$1]])',
	'confirmaccount-summary' => 'Дар ҳоли эҷоди саҳифаи корбарӣ бо зиндагиномаи корбари ҷадид.',
	'confirmaccount-welc' => "'''Хуш омадед ба ''{{SITENAME}}''!''' Мо умедворем, ки шумо бисёр ва хуб ҳиссагузорӣ хоҳед кард.
Шумо эҳтимолан мехоҳед [[{{MediaWiki:Helppage}}|саҳифаҳои роҳнаморо]] бихонед. Бори дигар, хуш омадед ва шод бошед!",
	'confirmaccount-wsum' => 'Хуш омадед!',
	'confirmaccount-email-subj' => '{{SITENAME}} дархости корбар',
	'confirmaccount-email-body' => 'Дархости шумо барои ҳисобе дар {{SITENAME}} тасдиқ шуд.

Номи ҳисоб: $1

Гузарвожа: $2

Аз сабабҳои амниятӣ, шумо бояд дар вурудшваии аввалин гузарвожаи худро тағйир диҳед.
Барои вуруд шудан, лутфан равед ба {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Дархости шумо барои ҳисобе дар {{SITENAME}} тасдиқ шуд.

Номи ҳисоб: $1

Гузарвожа: $2

$3

Аз сабабҳои амниятӣ, шумо бояд дар вурудшваии аввалин гузарвожаи худро тағйир диҳед.
Барои вуруд шудан, лутфан равед ба {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Бубахшед, дархости шумо барои ҳисоби "$1" дар {{SITENAME}} рад шуд.

Чанд сабабҳое ҳастанд ки боиси рад шудан мешаванд.
Шумо шояд формро дуруст пур накардаед, посухи шумо аз рӯи талабот тӯлонӣ набуд, ё ба меъёри талаботи сиёсати ҷавобгӯ набуд.
Дар сомона феҳристи тамос мумкин оварда шуда бошад, ки тариқи он шумо метавонед маълумоти бештар оиди сиёсати ҳисоби корбарӣ дастрас намоед.',
	'confirmaccount-email-body4' => 'Бубахшед, дархости шумо барои ҳисоби "$1" дар {{SITENAME}} рад шуд.

$2

Дар сомона феҳристи тамос мумкин оварда шуда бошад, ки тариқи он шумо метавонед маълумоти бештар оиди сиёсати ҳисоби корбарӣ дастрас намоед.',
	'confirmaccount-email-body5' => 'Қабл аз қабул кардани дархости шумо барои ҳисоби "$1" дар {{SITENAME}} шумо бояд аввал чанд иттилооти иловагиро пешкаш кунед.

$2

Дар сомона феҳристи тамос мумкин оварда шуда бошад, ки тариқи он шумо метавонед маълумоти бештар оиди сиёсати ҳисоби корбарӣ дастрас намоед.',
	'usercredentials' => 'Ихтиёроти корбар',
	'usercredentials-user' => 'Номи корбарӣ:',
	'usercredentials-leg-user' => 'Ҳисоби корбарӣ',
	'usercredentials-leg-person' => 'Иттилооти шахсӣ',
	'usercredentials-leg-other' => 'Иттилооти дигар',
	'usercredentials-email' => 'Почтаи электронӣ:',
	'usercredentials-real' => 'Номи аслӣ:',
	'usercredentials-bio' => 'Зиндагинома:',
	'usercredentials-notes' => 'Эзоҳоти иловагӣ:',
	'usercredentials-urls' => 'Феҳристи сомонаҳо:',
	'usercredentials-ip' => 'Нишонаи IP-и аслӣ:',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'requestaccount' => 'Darxosti hisob',
	'requestaccount-page' => '{{ns:project}}:Şarthoi Xidmat',
	'requestaccount-dup' => "'''Ezoh: Şumo allakaj bo hisobi sabtşuda vurud kardaed.'''",
	'requestaccount-leg-user' => 'Hisobi korbar',
	'requestaccount-leg-person' => 'Ittilooti şaxsī',
	'requestaccount-leg-other' => 'Ittilooti digar',
	'requestaccount-acc-text' => 'Ba nişonai poctai elektroniji şumo pajomi tasdiqi dar holi firistodani in darxost firistoda xohad şud.
Lutfan bo klik kardani pajvandi tasdiqiji tariqi poctai elektronī firistoda şuda posux dihed.
Guzarvoƶa niz dar holati eçod şudani hisobi şumo ba nişonai poctai elektronī firistoda xohad şud.',
	'requestaccount-real' => 'Nomi aslī:',
	'requestaccount-same' => '(monandi nomi aslī)',
	'requestaccount-email' => 'Nişonai poctai elektronī:',
	'requestaccount-reqtype' => 'Vazifa:',
	'requestaccount-level-0' => 'muallif',
	'requestaccount-level-1' => 'viroişgar',
	'requestaccount-bio' => 'Zindaginomai şaxsī:',
	'requestaccount-notes' => 'Ezohoti ilovagī:',
	'requestaccount-urls' => 'Fehristi somonaho, agar zijod boşad (bo satrhoi çadid çudo kuned):',
	'requestaccount-agree' => 'Şumo bojad tasdiq kuned ki nomi asliji şumo durust ast va şumo bo Şarthoi Xidmati mo rozī hasted.',
	'requestaccount-inuse' => 'Nomi korbarī allakaj dar istifodai darxosti hisobi dar tajbuda ast.',
	'requestaccount-emaildup' => 'Digar darxosti hisobi dar tajbuda hamin nişoniji poctai elektroniro istifoda mebarad.',
	'requestaccount-exts' => "Nav'i zamimaviji parvanda noravost.",
	'requestaccount-tos' => 'Man [[{{MediaWiki:Requestaccount-page}}|Şarthoi Xidmati]] dar {{SITENAME}} budaro xondam va bo onho vafodor hastam.
Nomi muşaxxaskardai man zeri "Nomi Aslī" dar haqiqat nomi asliji xudi man ast.',
	'requestaccount-submit' => 'Darxosti hisob',
	'request-account-econf' => 'Nişonai poctai elektroniji şumo tasdiq şud va hamin tavr dar darxosti hisobi şumo fehrist xohad şud.',
	'requestaccount-email-subj' => '{{SITENAME}} tasdiqi nişonai poctai elektronī',
	'requestaccount-email-body' => 'Şaxse, ehtimolan şumo az nişonai IP $1, hisobi "$2" bo nişonai poctai elektronī dar {{SITENAME}} darxost kard.

Baroi tasdiq, ki in hisob dar haqiqat ba şumo dar {{SITENAME}} taaluq dorad, in pajvandro dar mururgaraton boz kuned:

$3

Agar hisob eçod şuda boşad, tanho ba şumo kalimai ubur tariqi poctai elektronī firistoda xohad şud.
Agar in şumo *nest*, pajvandro dunbol nakuned.
In kodi tasdiq dar $4 ba xotima xohad rasid.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} darxosti hisob',
	'requestaccount-email-body-admin' => '"$1" hisobero darxost kard va muntaziri tasdiqi on meboşad.
Nişonai poctai elektronī tasdiq şud. Şumo darxostro metavoned inço "$2" tasdiq kuned.',
	'requestaccount-loginnotice' => "Baroi dastras kardani hisobi korbarī, şumo bojad '''[[Special:RequestAccount|darxost]]''' kuned.",
	'confirmaccounts' => 'Darxosthoi hisobhoro tasdiq kuned',
	'confirmaccount-list' => 'Dar zer fehristi darxosthoi hisobhoi muntaziri tasdiq ovarda şudaast.
Dar holati tasdiq kardan va jo rad kardani darxost, on az in fehrist pok kardan xohad şud.',
	'confirmaccount-real-q' => 'Nom',
	'confirmaccount-email-q' => 'Poctai elektronī',
	'confirmaccount-bio-q' => 'Zindaginoma',
	'confirmaccount-showopen' => 'darxosthoi kuşod',
	'confirmaccount-showrej' => 'darxosthoi radşuda',
	'confirmaccount-review' => 'Peşnamoiş',
	'confirmaccount-q-open' => 'darxosthoi kuşod',
	'confirmaccount-leg-user' => 'Hisobi korbarī',
	'confirmaccount-leg-person' => 'Ittilooti şaxsī',
	'confirmaccount-leg-other' => 'Ittilooti digar',
	'confirmaccount-name' => 'Nomi korbarī',
	'confirmaccount-real' => 'Nom:',
	'confirmaccount-email' => 'Poctai elektronī:',
	'confirmaccount-reqtype' => 'Vazifa:',
	'confirmaccount-pos-0' => 'muallif',
	'confirmaccount-pos-1' => 'viroişgar',
	'confirmaccount-bio' => 'Zindaginoma:',
	'confirmaccount-notes' => 'Ezohoti ilovagī:',
	'confirmaccount-urls' => 'Fehristi somonaho:',
	'confirmaccount-none-p' => '(peşnihod naşudaast)',
	'confirmaccount-econf' => "(ta'jidşuda)",
	'confirmaccount-noreason' => '(heç)',
	'confirmaccount-create' => 'Qabul (eçodi hisob)',
	'confirmaccount-deny' => 'Rad (az fehrist giriftan)',
	'confirmaccount-hold' => 'Nigoh doştan',
	'confirmaccount-spam' => 'Haraznoma (poctai elektronī nafiristed)',
	'confirmaccount-reason' => 'Tavzeh (dar pajomi elektronī ilova xohad şud):',
	'confirmaccount-ip' => 'Nişonai IP:',
	'confirmaccount-submit' => "Ta'jid",
	'confirmaccount-needreason' => "Şumo bojad dalel dar ça'bai tavzeh dar zer peşkaş namoed.",
	'confirmaccount-canthold' => 'In darxost allakaj jo nigoh doşta şudaast jo hazf şudaast.',
	'confirmaccount-acc' => 'Darxosti hisob bo muvaffaqijat tasdiq karda şud; hisobi korbariji çadidī [[User:$1|$1]] eçod şud.',
	'confirmaccount-rej' => 'Darxosti hisob bo muvaffaqijat rad karda şud.',
	'confirmaccount-viewing' => '(holo dar holi didan ast tavassuti [[User:$1|$1]])',
	'confirmaccount-summary' => 'Dar holi eçodi sahifai korbarī bo zindaginomai korbari çadid.',
	'confirmaccount-welc' => "'''Xuş omaded ba ''{{SITENAME}}''!''' Mo umedvorem, ki şumo bisjor va xub hissaguzorī xohed kard.
Şumo ehtimolan mexohed [[{{MediaWiki:Helppage}}|sahifahoi rohnamoro]] bixoned. Bori digar, xuş omaded va şod boşed!",
	'confirmaccount-wsum' => 'Xuş omaded!',
	'confirmaccount-email-subj' => '{{SITENAME}} darxosti korbar',
	'confirmaccount-email-body' => 'Darxosti şumo baroi hisobe dar {{SITENAME}} tasdiq şud.

Nomi hisob: $1

Guzarvoƶa: $2

Az sababhoi amnijatī, şumo bojad dar vurudşvaiji avvalin guzarvoƶai xudro taƣjir dihed.
Baroi vurud şudan, lutfan raved ba {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Darxosti şumo baroi hisobe dar {{SITENAME}} tasdiq şud.

Nomi hisob: $1

Guzarvoƶa: $2

$3

Az sababhoi amnijatī, şumo bojad dar vurudşvaiji avvalin guzarvoƶai xudro taƣjir dihed.
Baroi vurud şudan, lutfan raved ba {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Bubaxşed, darxosti şumo baroi hisobi "$1" dar {{SITENAME}} rad şud.

Cand sababhoe hastand ki boisi rad şudan meşavand.
Şumo şojad formro durust pur nakardaed, posuxi şumo az rūi talabot tūlonī nabud, jo ba me\'jori talaboti sijosati çavobgū nabud.
Dar somona fehristi tamos mumkin ovarda şuda boşad, ki tariqi on şumo metavoned ma\'lumoti beştar oidi sijosati hisobi korbarī dastras namoed.',
	'confirmaccount-email-body4' => 'Bubaxşed, darxosti şumo baroi hisobi "$1" dar {{SITENAME}} rad şud.

$2

Dar somona fehristi tamos mumkin ovarda şuda boşad, ki tariqi on şumo metavoned ma\'lumoti beştar oidi sijosati hisobi korbarī dastras namoed.',
	'confirmaccount-email-body5' => 'Qabl az qabul kardani darxosti şumo baroi hisobi "$1" dar {{SITENAME}} şumo bojad avval cand ittilooti ilovagiro peşkaş kuned.

$2

Dar somona fehristi tamos mumkin ovarda şuda boşad, ki tariqi on şumo metavoned ma\'lumoti beştar oidi sijosati hisobi korbarī dastras namoed.',
	'usercredentials' => 'Ixtijoroti korbar',
	'usercredentials-user' => 'Nomi korbarī:',
	'usercredentials-leg-user' => 'Hisobi korbarī',
	'usercredentials-leg-person' => 'Ittilooti şaxsī',
	'usercredentials-leg-other' => 'Ittilooti digar',
	'usercredentials-email' => 'Poctai elektronī:',
	'usercredentials-real' => 'Nomi aslī:',
	'usercredentials-bio' => 'Zindaginoma:',
	'usercredentials-notes' => 'Ezohoti ilovagī:',
	'usercredentials-urls' => 'Fehristi somonaho:',
	'usercredentials-ip' => 'Nişonai IP-i aslī:',
);

/** Thai (ไทย)
 * @author Ans
 * @author Harley Hartwell
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'requestaccount' => 'ขอบัญชีผู้ใช้',
	'requestaccount-text' => "'''กรอกรายละเอียดทั้งหมดและกดส่ง เพื่อขอบัญชีผู้ใช้'''

กรุณาตรวจสอบให้แน่ใจว่าคุณได้อ่าน[[{{MediaWiki:Requestaccount-page}}|ข้อตกลงการใช้งาน]]ก่อนที่จะทำการขอบัญชีผู้ใช้

เมื่อบัญชีผู้ใช้ถูกสร้างแล้ว คุณจะได้รับข้อความทางอีเมล และสามารถใช้บัญชีได้เมื่่อ[[Special:UserLogin|ล็อกอิน]]",
	'requestaccount-page' => '{{ns:project}}:ข้อตกลงการใช้งาน',
	'requestaccount-dup' => "'''หมายเหตุ: คุณได้ล็อกอินด้วยบัญชีที่ลงทะเบียนแล้ว'''",
	'requestaccount-leg-user' => 'บัญชีผู้ใช้',
	'requestaccount-leg-areas' => 'หัวข้อที่สนใจ',
	'requestaccount-leg-person' => 'ข้อมูลส่วนตัว',
	'requestaccount-leg-other' => 'ข้อมูลอื่น ๆ',
	'requestaccount-leg-tos' => 'ข้อตกลงการใช้งาน',
	'requestaccount-acc-text' => 'เมื่อส่งคำขอบัญชีผู้ใช้ใหม่ จะมีข้อความยืนยันส่งไปทางอีเมลของคุณ
กรุณาืยืนยันโดยการคลิกบนลิงก์ยืนยัน ที่ได้ระบุไว้ในอีเมล
เมื่อบัญชีของคุณถูกสร้างแล้ว คุณจะได้รับรหัสผ่าน ผ่านทางอีเมล',
	'requestaccount-areas-text' => 'เลืิอกทักษะด้านล่างที่คุณมีความชำนาญ หรือมีความประสงค์จะทำงานในด้านนี้มากที่สุด',
	'requestaccount-ext-text' => 'ข้อมูลดังกล่่าวนี้ จะถูกเก็บเป็นความลับ และจะถูกใช้สำหรับคำขอนี้เท่านั้น
คุณอาจต้องการใส่รายละเอียดในการติดต่อ เช่น หมายเลขโทรศัพท์ เพื่อช่วยในการยืนยันตัว',
	'requestaccount-bio-text' => 'ระบบจะแสดงชีวประวัติของคุณในหน้าผู้ใช้ของคุณอัตโนมัติ
คุณยังสามารถใส่การรับรองของคุณเองได้ด้วย
แต่ต้องแน่ใจว่าคุณยินดีที่จะแสดงข้อมูลเหล่านั้นอย่างเปิดเผย
คุณสามารถเปลี่ยนชื่อของคุณโดยเปลี่ยน[[Special:Preferences|การตั้งค่าของคุณ]]',
	'requestaccount-real' => 'ชื่อจริง:',
	'requestaccount-same' => '(เหมือนกับชื่อจริง)',
	'requestaccount-email' => 'อีเมล:',
	'requestaccount-reqtype' => 'ตำแหน่ง:',
	'requestaccount-level-1' => 'ผู้แก้ไข',
	'requestaccount-bio' => 'ประวัติส่วนตัว:',
	'requestaccount-attach' => 'เรซูเม หรือ อัตชีวประวัติ (ไม่จำเป็นต้องใส่):',
	'requestaccount-notes' => 'รายละเอียดเพิ่มเติม:',
	'requestaccount-urls' => 'รายชื่อเว็บไซต์ ถ้ามี (แบ่งโดยการขึ้นบรรทัดใหม่):',
	'requestaccount-agree' => 'คุณต้องยืนยันว่าชื่อจริงของคุณนั้นถูกต้อง และคุณเห็นด้วยกับข้อตกลงการใช้งานของเรา',
	'requestaccount-inuse' => 'ชื่อผู้ใช้นี้กำลังถูกใช้ในการยื่นขอบัญชีผู้ใช้ใหม่้',
	'requestaccount-tooshort' => 'ชีวประวัติของคุณต้องมีความยาวอย่างน้อย $1 คำ',
	'requestaccount-emaildup' => 'มีคำขอบัญชีผู้ใช้อื่นใช้ที่อยู่อีเมลเดียวกัน',
	'requestaccount-exts' => 'ไม่อนุญาตประเภทของไฟล์ที่แนบมา',
	'requestaccount-resub' => 'คุณต้องเลือกไฟล์เรซูเม/ประวัติการทำงานของคุณใหม่ เนื่องจากเหตุผลด้านความปลอดภัย
ทิ้งช่องนี้ให้ว่างถ้าคุณต้องการยกเลิก',
	'requestaccount-tos' => 'ข้าพเจ้าได้อ่านและยินดีปฏิบัติตาม[[{{MediaWiki:Requestaccount-page}}|ข้อตกลงการใช้งาน]] ของ {{SITENAME}}
ชื่อที่ข้าพเจ้าได้กรอกในช่อง "ชื่อจริง" นั้น เป็นความจริง',
	'requestaccount-submit' => 'ขอบัญชีผู้ใช้',
	'requestaccount-sent' => 'คำขอบัญชีผู้ใช้ของคุณได้ถูกส่งไปแล้ว และกำลังอยู่ในกระบวนการพิจารณา อีเมลยืนยันได้ถูกส่งไปยังอีเมลแอดเดรสของคุณแล้ว',
	'request-account-econf' => 'คุณได้ยืนยันอีเมลของคุณแล้ว และข้อมูลนี้จะถูกรวมอยู่ในคำขอบัญชีผู้ใช้',
	'requestaccount-email-subj' => 'การยืนยันทางอีเมลของ {{SITENAME}}',
	'requestaccount-email-body' => 'มีบุคคลใดบุคคลหนึ่ง ซึ่งเป็นไปได้ว่ามาจากไอพีแอดเดรสของคุณ $1 ได้ขอบัญชีผู้ใช้ "$2" และใช้อีเมลนี้ บนเว็บไซต์ {{SITENAME}}

เพื่อที่จะืยืนยันว่าบัญชีผู้ใช้นี้เป็นของคุณบนเว็บไซต์ {{SITENAME}} กรุณาเปิดลิงก์นี้

$3

ถ้าบัญชีผู้ใช้นี้ถูกสร้างขึ้น ทางเว็บไซต์จะอีเมลรหัสผ่านไปให้คุณเท่านั้น
ุ้ถ้าหากบัญชีนี้ *มิใช่* คุณ กรุณาอย่าเปิดลิงก์นี้
รหัสการยืนยันนี้จะหมดอายุภายใน $4',
	'requestaccount-email-subj-admin' => 'การขอบัญชีผู้ใช้บนเว็บไซต์ {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" ได้ขอบัญชีผู้ใช้ใหม่ และกำลังรอการยืนยัน
มีการยืนยันทางอีเมลเรียบร้อยแล้ว คุณสามารถยืนยันคำขอได้ที่นี่ "$2"',
	'acct_request_throttle_hit' => 'ขออภัย คุณได้ขอบัญชีผู้ใช้ {{PLURAL:$1|1 บัญชี|$1 บัญชี}}
คุณไม่สามารถขอบัญชีเพิ่มเติมอีกได้',
	'requestaccount-loginnotice' => "เพื่อที่จะได้มาซึ่งบัญชีผู้ใช้ใหม่ คุณต้อง'''[[Special:RequestAccount|ทำการขอบัญชีผู้ใช้]]'''",
	'confirmaccounts' => 'ยืนยันคำขอบัญชีผู้ใช้',
	'confirmedit-desc' => 'อนุญาตให้ผู้ดูแลสิทธิ์แต่งตั้งยืนยันคำขอบัญชีผู้ใช้',
	'confirmaccount-list' => 'ด้านล่างนี้คือรายการของคำขอบัญชีผู้ใช้ซึ่งรอการอนุมัติ
เมื่อคำขอถูกอนุมัติหรือถูกปฏิเสธ คำขอนั้น ๆ ก็จะถูกนำออกจากรายการ',
	'confirmaccount-list2' => 'ด้านล่างนี้เป็นรายการคำขอบัญชีที่ถูกปฏิเสธใหม่ ซึ่งอาจจะถูกนำออกเมื่อแสดงมาหลายวัน
คุณยังสามารถอนุมัติคำขอเหล่านี้ได้ แต่ควรปรึกษากับผู้ดูแลสิทธิ์แต่งตั้งที่ปฏิเสธก่อนที่จะอนุมัติ',
	'confirmaccount-list3' => 'ด้านล่างนี้คือรายการของคำขอที่หมดอายุความ ซึ่งจะำถูกนำออกเมื่อแสดงมาหลายวัน
คุณยังสามารถอนุมัติคำขอเหล่านี้ได้',
	'confirmaccount-text' => 'นี่คือคำขอบัญชีผู้ใช้ใหม่ จากเว็บไซต์ {{SITENAME}}

กรุณาตรวจสอบข้อมูลข้างล่างอย่างละเอียด
หากคุณกำลังอนุมัติคำขอนี้ กรุณาตั้งสถานะของบัญชีผู้ใช้โดยใช้เมนู
การแก้ไขชีวประวัติ จะไม่ส่งผลกระทบต่อข้อมูลการรับรองถาวร
คุณสามารถเลือกสร้างบัญชีภายใต้ชื่อที่แตกต่างออกไปจากคำขอได้
กรุณาทำเช่นนี้เฉพาะเมื่อต้องการป้องกันความสับสนกับชื่อบัญชีอื่น ๆ ที่คล้ายคลึงกัน

หากคุณปิดหน้านี้โดยที่ไม่ได้อนุมัติหรือปฏิเสธคำขอนี้ คำขอนี้จะมีสถานะกำลังรอดั่งเดิม',
	'confirmaccount-none-r' => 'ขณะนี้ ยังไม่มีคำขอบัญชีที่ถูกปฏิเสธใหม่ในรายการนี้',
	'confirmaccount-none-e' => 'ขณะนี้ ยังไม่มีคำขอบัญชีที่หมดอายุความใหม่ในรายการนี้',
	'confirmaccount-real-q' => 'ชื่อ',
	'confirmaccount-email-q' => 'อีเมล',
	'confirmaccount-bio-q' => 'ชีวประวัติ',
	'confirmaccount-showrej' => 'คำขอที่ถูกปฏิเสธ',
	'confirmaccount-showheld' => 'คำขอที่ถูกพักไว้',
	'confirmaccount-showexp' => 'คำขอที่หมดอายุความ',
	'confirmaccount-review' => 'ตรวจสอบ',
	'confirmaccount-types' => 'เลือกคิวการยืนยันบัญชีผู้ใช้จากด้านล่าง:',
	'confirmaccount-all' => '(แสดงคิวทั้งหมด)',
	'confirmaccount-type' => 'คิว:',
	'confirmaccount-type-1' => 'ผู้แก้ไขที่คาดหวัง',
	'confirmaccount-q-held' => 'คำขอที่ถูกพักไว้',
	'confirmaccount-q-rej' => 'คำขอที่ถูกปฏิเสธใหม่',
	'confirmaccount-q-stale' => 'คำขอที่หมดอายุความ',
	'confirmaccount-leg-user' => 'บัญชีผู้ใช้',
	'confirmaccount-leg-areas' => 'หัวข้อที่สนใจ',
	'confirmaccount-leg-person' => 'ข้อมูลส่วนตัว',
	'confirmaccount-leg-other' => 'ข้อมูลอื่น ๆ',
	'confirmaccount-name' => 'ชื่อผู้ใช้',
	'confirmaccount-real' => 'ชื่อ:',
	'confirmaccount-email' => 'อีเมล:',
	'confirmaccount-reqtype' => 'ตำแหน่ง:',
	'confirmaccount-pos-1' => 'ผู้แก้ไข',
	'confirmaccount-bio' => 'ชีวประวัติ:',
	'confirmaccount-attach' => 'เรซูเม/ประวัติการงาน:',
	'confirmaccount-notes' => 'รายละเอียดเพิ่มเติม:',
	'confirmaccount-urls' => 'รายชื่อเว็บไซต์:',
	'confirmaccount-none-p' => '(มิได้ระบุ)',
	'confirmaccount-econf' => '(ถูกยืนยัน)',
	'confirmaccount-reject' => '(ถูกปฏิเสธโดย [[User:$1|$1]] บน $2)',
	'confirmaccount-noreason' => '(ไม่มี)',
	'confirmaccount-autorej' => '(คำขอนี้ถูกลบทิ้งอัตโนมัติเนื่องจากไม่มีกิจกรรมใด ๆ เกิดขึ้น)',
	'confirmaccount-held' => '(ทำเครื่องหมายว่า "ถูกพักไว้" โดย [[User:$1|$1]] บน $2)',
	'confirmaccount-create' => 'ยอมรับ (สร้างบัญชี)',
	'confirmaccount-deny' => 'ปฏิเสธ (นำออกจากรายการ)',
	'confirmaccount-hold' => 'พักไว้',
	'confirmaccount-spam' => 'สแปม (ไม่ส่งอีเมล)',
	'confirmaccount-reason' => 'ความเห็น (จะถูกรวมอยู่ในอีเมล):',
	'confirmaccount-ip' => 'หมายเลขไอพี:',
	'confirmaccount-submit' => 'ยืนยัน',
	'confirmaccount-needreason' => 'คุณต้องระบุึเหตุผลในกล่องแสดงความคิดเห็นด้านล่าง',
	'confirmaccount-canthold' => 'คำขอนี้ถูกพักไว้หรือถูกลบ',
	'confirmaccount-acc' => 'คำขอบัญชีถูกยืนยันเรียบร้อยแล้ว
ระบบจะสร้างบัญชีผู้ใช้ใหม่ [[User:$1|$1]]',
	'confirmaccount-rej' => 'คำขอบัญชีถูกปฏิเสธเรียบร้อยแล้ว',
	'confirmaccount-viewing' => '([[User:$1|$1]] กำลังดูหน้านี้ิอยู่)',
	'confirmaccount-summary' => 'สร้างหน้าผู้ใช้โดยใส่ชีวประวัติของผู้ใช้ใหม่ลงไปด้วย',
	'confirmaccount-welc' => "'''ยินดีต้อนรับสู่ ''{{SITENAME}}''!'''
เราหวังว่าคุณจะเขียนบทความต่าง ๆ อย่างมากมายและมีคุณภาพ
คุณอาจจะต้องการอ่าน[[{{MediaWiki:Helppage}}|หน้าช่วยเหลือ]]ต่าง ๆ ด้วย
ขอให้มีความสุขและยินดีต้อนรับอีกคร้ัง!",
	'confirmaccount-wsum' => 'ยินดีต้อนรับ!',
	'confirmaccount-email-subj' => 'การขอบัญชีผู้ใช้บนเว็บไซต์ {{SITENAME}}',
	'confirmaccount-email-body' => 'คำขอบัญชีผู้ใช้ของคุณถูกอนุมัติแล้วบน {{SITENAME}}

ชื่อบัญชี: $1

รหัสผ่าน: $2

เพื่อเหตุผลด้านความปลอดภัย คุณจำเป็นต้องเปลี่ยนรหัสผ่านของคุณครั้งแรกเมื่อคุณล็อกอิน
สำหรับการล็อกอิน กรุณาไปที่ {{fullurl:Special:UserLogin}}',
	'confirmaccount-email-body2' => 'คำขอบัญชีผู้ใช้ของคุณถูกอนุมัติแล้วบน {{SITENAME}}

ชื่อบัญชี: $1

รหัสผ่าน: $2

$3

เพื่อเหตุผลด้านความปลอดภัย คุณจำเป็นต้องเปลี่ยนรหัสผ่านของคุณครั้งแรกเมื่อคุณล็อกอิน
สำหรับการล็อกอิน กรุณาไปที่ {{fullurl:Special:UserLogin}}',
	'confirmaccount-email-body3' => 'ขออภัย คำขอบัญชีผู้ใช้ "$1" ได้ิถูกปฏิเสธบน {{SITENAME}}

อาจจะมีหลายเหตุผลที่คุณถูกปฏิเสธ:
คุณอาจจะไม่ได้กรอกฟอร์มอย่างถูกต้อง เขียนข้อความตอบรับสั้นเกินไป หรือไม่ผ่านเกณฑ์ูการตัดสินจากผู้ดูแลระบบ
อย่างไรก็ดี อาจจะมีรายชื่อบุคคลที่คุณสามารถติดต่อได้ บนเว็บไซต์ หาุกคุณมีความประสงค์ที่จะทราบเกี่ยวกับนโยบายทางด้านบัญชีผู้ใช้',
	'confirmaccount-email-body4' => 'ขออภัย คำขอบัญชีผู้ใช้ "$1" ได้ิถูกปฏิเสธบน {{SITENAME}}

$2

อย่างไรก็ดี อาจจะมีรายชื่อบุคคลที่คุณสามารถติดต่อได้ บนเว็บไซต์ หาุกคุณมีความประสงค์ที่จะทราบเกี่ยวกับนโยบายทางด้านบัญชีผู้ใช้',
	'confirmaccount-email-body5' => 'ก่อนที่คำขอบัญชีผู้ใช้ "$1" ของคุณ จะสามารถอนุมัติได้บน {{SITENAME}} คุณต้องกรอกข้อมูลเพิ่มเติม

$2

อย่างไรก็ดี อาจจะมีรายชื่อบุคคลที่คุณสามารถติดต่อได้ บนเว็บไซต์ หาุกคุณมีความประสงค์ที่จะทราบเกี่ยวกับนโยบายทางด้านบัญชีผู้ใช้',
	'usercredentials' => 'การรับรองของผู้ใช้',
	'usercredentials-leg' => 'ดูการรับรองที่ถูกยืนยันของผู้ใช้',
	'usercredentials-user' => 'ชื่อผู้ใช้:',
	'usercredentials-leg-user' => 'บัญชีผู้ใช้',
	'usercredentials-leg-areas' => 'หัวข้อที่สนใจ',
	'usercredentials-leg-person' => 'ข้อมูลส่วนตัว',
	'usercredentials-leg-other' => 'ข้อมูลอื่น ๆ',
	'usercredentials-email' => 'อีเมล:',
	'usercredentials-real' => 'ชื่อจริง',
	'usercredentials-bio' => 'ชีวประวัติ:',
	'usercredentials-attach' => 'เรซูเม/ประวัติการงาน:',
	'usercredentials-notes' => 'รายละเอียดเพิ่มเติม:',
	'usercredentials-urls' => 'รายชื่อเว็บไซต์:',
	'usercredentials-ip' => 'ไอพีแอดเดรสดั้งเิดิม:',
	'usercredentials-member' => 'สิทธิ:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'confirmaccount-real-q' => 'At',
	'confirmaccount-name' => 'Ulanyjy ady',
	'confirmaccount-real' => 'At:',
	'usercredentials-user' => 'Ulanyjy ady:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'requestaccount' => 'Hilingin ang akawnt',
	'requestaccount-text' => "'''Punuan at ipasa ang sumusunod na pormularyo upang humiling ng isang akawnt ng tagagamit'''.

Tiyaking nabasa mo na muna ang [[{{MediaWiki:Requestaccount-page}}|Mga Patakaran ng Paglilingkod]] bago humiling ng isang kuwenta.

Kapag napahintulutan na ang akawnt, padadalhan ka ng isang mensahe ng pagbibigay-alam sa pamamagitan ng isang e-liham at magagamit na ang kuwenta sa [[Special:UserLogin|paglagda]].",
	'requestaccount-page' => '{{ns:project}}:Mga Patakaran ng Paglilingkod',
	'requestaccount-dup' => "'''Paunawa: Nakalagda ka na at may isang ipinatalang akawnt.'''",
	'requestaccount-leg-user' => 'Akawnt ng tagagamit',
	'requestaccount-leg-areas' => 'Mga pangunahing bagay-bagay na kinawiwilihan',
	'requestaccount-leg-person' => 'Kabatirang pansarili',
	'requestaccount-leg-other' => 'Iba pang kabatiran',
	'requestaccount-leg-tos' => 'Mga Patakaran ng Paglilingkod',
	'requestaccount-acc-text' => 'Ang iyong adres ng e-liham ay padadalhan ng isang mensahe ng pagtitiyak kapag naipasa na ang kahilingang ito. Tumugon po lamang sa pamamagitan ng pagpindot sa kawing ng pagtitiyak na ibinigay ng e-liham. Gayundin, ipadadala rin sa pamamagitan ng isang e-liham ang iyong hudyat kapag nalikha na ang akawnt mo.',
	'requestaccount-areas-text' => 'Piliin ang mga pook ng paksang nasa ibaba kung saan mayroon kang pormal na kadalubhasaan o nais na pag-ukulan ng karamihan sa mga gawain mo.',
	'requestaccount-ext-text' => 'Pinananatiling pansarili ang sumusunod na kabatiran at gagamitin lamang para sa kahilingang ito.
Maaaring naisin mong magtala ng mga kabatirang pangpakikipag-ugnayang katulad ng bilang ng telepono upang makatulong sa pagtitiyak ng pagkakakilanlan.',
	'requestaccount-bio-text' => 'Itatalaga ang talambuhay mo bilang likas na nakatakdang nilalaman para sa iyong pahina ng tagagamit.
Subuking isama ang anumang mga katibayan ng katangian.
Tiyaking maginhawa para sa iyo at hindi ka nagaalinglangang ilathala ng ganyang kabatiran.
Maaari mong baguhin ang pangalan mo sa pamamagitan ng [[Special:Preferences|iyong mga kagustuhan]].',
	'requestaccount-real' => 'Totoong pangalan:',
	'requestaccount-same' => '(katulad ng totoong pangalan)',
	'requestaccount-email' => 'Adres ng e-liham:',
	'requestaccount-reqtype' => 'Katungkulan:',
	'requestaccount-level-0' => 'may-akda',
	'requestaccount-level-1' => 'patnugot',
	'requestaccount-bio' => 'Pansariling talambuhay:',
	'requestaccount-attach' => 'Buod ng mga karanasan sa hanapbuhay (maaaring wala nito):',
	'requestaccount-notes' => 'Karagdagang mga tala:',
	'requestaccount-urls' => 'Talaan ng mga websayt, kung mayroon (ihiwalay na may bagong mga guhit):',
	'requestaccount-agree' => 'Dapat mong patunayan na tama ang tunay mong pangalan at pumapayag ka sa aming Mga Patakaran ng Paglilingkod.',
	'requestaccount-inuse' => 'Ginagamit na ang pangalan ng tagagamit sa isang naghihintay na paghiling ng akawt.',
	'requestaccount-tooshort' => 'Ang talambuhay mo ay dapat na may kahit na $1 mga salita ang haba.',
	'requestaccount-emaildup' => 'Isang naghihintay na kahilingan ng akawnt ang gumagamit ng katulad na adres ng e-liham.',
	'requestaccount-exts' => 'Hindi pinapayagan ang uri ng nakalakip na talaksan',
	'requestaccount-resub' => 'Dapat na muling piliin ang iyong talaan ng karanasan sa hanapbuhay para sa mga kadahilanang pangkaligtasan.
Iwanang walang laman ang hanay kung hindi mo na ninanais magsama ng isa.',
	'requestaccount-tos' => 'Nabasa ko na at sumasang-ayong susundin ang [[{{MediaWiki:Requestaccount-page}}|Mga Patakaran ng Paglilingkod]] ng {{SITENAME}}.
Sa katunayan, ang pangalang tinukoy ko sa ilalim ng "Totoong pangalan" ay ang talagang sarili kong totoong pangalan.',
	'requestaccount-submit' => 'Hilingin ang akawnt',
	'requestaccount-sent' => 'Matagumpay nang naipadala ang iyong paghiling ng akawnt at naghihintay na ngayon ng pagsusuri.',
	'request-account-econf' => 'Natiyak na ang iyong adres ng e-liham at itatala bilang ganyan sa loob ng paghiling mo ng akawnt.',
	'requestaccount-email-subj' => 'Pagtitiyak ng {{SITENAME}} sa adres ng e-liham',
	'requestaccount-email-body' => 'May isa, marahil ikaw na nagmula sa adres ng IP na $1, ang humiling ng isang kuwentang "$2" na may ganitong adres ng e-liham sa {{SITENAME}}.

Upang patotohanan na talagang ikaw ang may-ari ng akawnt na itong nasa {{SITENAME}}, buksan ang kawing na ito sa iyong pantingin-tingin (\'\'browser\'\'):

$3

Kapag nalikha na ang akawnt, sa iyo lamang ipapadala ang hudyat sa pamamagitan ng e-liham.
Kung *hindi* ikaw ito, huwag sundan ang kawing.
Mawawalan ng bisa ang kodigo ng pagpapatotoong ito sa $4.',
	'requestaccount-email-subj-admin' => 'Paghiling ng akawnt sa {{SITENAME}}',
	'requestaccount-email-body-admin' => 'Humiling si "$1" ng isang akawnt at naghihintay ng pagtitiyak.
Natiyak na ang adres ng e-liham. Matitiyak mo ang kahilingan mula dito "$2".',
	'acct_request_throttle_hit' => 'Paumanhin, nakahiling ka na ng {{PLURAL:$1|1 akawnt|$1 mga akawnt}}.',
	'requestaccount-loginnotice' => "Upang makatanggap ng isang akawnt ng tagagamit, dapat kang '''[[Special:RequestAccount|humiling ng isa]]'''.",
	'confirmaccount-newrequests' => "'''$1''' naghihintay na bukas pang {{PLURAL:$1|[[Special:ConfirmAccounts|account request]]|[[Special:ConfirmAccounts|mga paghiling ng akawnt]]}} na natiyak na ng e-liham",
	'confirmaccounts' => 'Tiyakin ang mga paghiling ng akawnt',
	'confirmedit-desc' => 'Nagbibigay sa mga burokrato ng kakayahang tiyakin ang mga paghiling ng akawnt',
	'confirmaccount-maintext' => "'''Ginagamit ang pahinang ito upang tiyakin ang naghihintay na mga paghiling ng akawnt sa ''{{SITENAME}}'''''.

Ang bawat isang pila ng kahilingan ng kuwenta ay binubuo ng tatlong kabahaging mga pila.
Isa para sa bukas na paghiling, isa para sa mga ibininbin ng ibang mga tagapangasiwa habang naghihintay pa ng karagdagang kabatiran, at isang para sa mga kahilingang tinanggihan kamakailan lamang.

Kapag tumutugon sa isang paghiling, suriin itong may pag-iingat at, kung kinakailangan, tiyakin ang kabatirang nakapaloob dito.

Itatala bilang pribado ang iyong mga galaw.
Inaasahan din na susuriin mo ang anumang kaganapang mangyayari rito bukod pa sa kung ano ang mga gagawin mo.",
	'confirmaccount-list' => 'Nasa ibaba ang isang talaan ng mga paghiling ng akawnt na naghihintay ng pahintulot.
Tatanggalin na mula sa talaang ito ang isang kahilingang pinayagan na o tinanggihan.',
	'confirmaccount-list2' => 'Nasa ibaba ang isang talaan ng mga paghiling ng akawnt na tinanggihan kamakailan lamang, na maaaring kusang mabura kapag nagtagal na ng ilang mga araw.
Maaari pa rin silang payagan upang maging mga akawnt, bagaman maaaring naisin mong sumangguni muna sa tumangging tagapangasiwa bago gawin iyan.',
	'confirmaccount-list3' => 'Nasa iba ang isang talaan ng lipas nang mga paghiling ng akawnt na maaaring kusang mabura kapag nagtagal na ng ilang mga araw. Maaari pa rin silang mapayagan upang maging mga akawnt.',
	'confirmaccount-text' => "Isa itong naghihintay na kahilingan para sa isang akawnt ng tagagamit sa '''{{SITENAME}}'''.

Maingat na suriin ang kabatirang nasa ibaba.
Kung papahintulutan mo ang paghiling na ito, gamitin ang posisyon ng pambagsak-pababa upang maitakda ang kalagayan ng akawnt ng tagagamit.
Ang mga pagbabagong ginawa sa talambuhay na nasa kahilingan ay hindi makakaapekto sa anumang pampamalagiang pagtatago ng katibayan ng katangian.
Gamitin lamang ito upang maiwasan ang pakikipagbungguan sa iba pang mga pangalan.

Kapag payak na hinayaan mo lamang ang pahinang ito na hindi tinitiyak o tinatanggihan ang kahilingang ito, mananatili itong naghihintay.",
	'confirmaccount-none-o' => 'Kasalukuyang walang bukas na naghihintay na mga paghiling ng akawnt sa loob ng talaang ito.',
	'confirmaccount-none-h' => 'Kasalukuyang walang bukas na nakabinbing naghihintay na mga paghiling ng akawnt sa loob ng talaang ito.',
	'confirmaccount-none-r' => 'Kasalukuyang walang mga paghiling ng akawnt na tinanggihan kamakailan lamang sa loob ng talaang ito.',
	'confirmaccount-none-e' => 'Kasalukuyang walang lipas na mga paghiling ng akawnt sa loob ng talaang ito.',
	'confirmaccount-real-q' => 'Pangalan',
	'confirmaccount-email-q' => 'E-liham',
	'confirmaccount-bio-q' => 'Talambuhay',
	'confirmaccount-showopen' => 'bukas na mga paghiling',
	'confirmaccount-showrej' => 'tinanggihang mga paghiling',
	'confirmaccount-showheld' => 'nakabinbing mga paghiling',
	'confirmaccount-showexp' => 'lipas na mga paghiling',
	'confirmaccount-review' => 'Suriin',
	'confirmaccount-types' => 'Pumili ng isang nakapilang pagpapatotoo ng akawnt mula sa ibaba:',
	'confirmaccount-all' => '(ipakita ang lahat ng mga nakapila)',
	'confirmaccount-type' => 'Pila:',
	'confirmaccount-type-0' => 'inaasahang magiging mga may-akda',
	'confirmaccount-type-1' => 'inaasahang magiging mga patnugot',
	'confirmaccount-q-open' => 'bukas na mga paghiling',
	'confirmaccount-q-held' => 'nakabinbing mga paghiling',
	'confirmaccount-q-rej' => 'kamakailang tinatanggihang mga paghiling',
	'confirmaccount-q-stale' => 'lipas na mga paghiling',
	'confirmaccount-badid' => 'Walang nakabinbing kahilingan na umuugma sa ibinigay na ID.
Maaaring naisagawa na ito.',
	'confirmaccount-leg-user' => 'Akawnt ng tagagamit',
	'confirmaccount-leg-areas' => 'Mga pangunahing bagay-bagay na kinawiwilihan',
	'confirmaccount-leg-person' => 'Pansariling kabatiran',
	'confirmaccount-leg-other' => 'Iba pang kabatiran',
	'confirmaccount-name' => 'Pangalan ng tagagamit',
	'confirmaccount-real' => 'Pangalan:',
	'confirmaccount-email' => 'E-liham:',
	'confirmaccount-reqtype' => 'Katungkulan:',
	'confirmaccount-pos-0' => 'may-akda',
	'confirmaccount-pos-1' => 'patnugot',
	'confirmaccount-bio' => 'Talambuhay:',
	'confirmaccount-attach' => 'Talaan ng karanasan sa hanapbuhay',
	'confirmaccount-notes' => 'Karagdagang mga tala:',
	'confirmaccount-urls' => 'Talaan ng mga websayt:',
	'confirmaccount-none-p' => '(hindi ibinigay)',
	'confirmaccount-confirm' => 'Gamitin ang mga pagpipiliang nasa ibaba upang tanggapin, tanggihan, o ibinbin ang kahilingang ito:',
	'confirmaccount-econf' => '(natiyak na)',
	'confirmaccount-reject' => '(tinanggihan ni [[User:$1|$1]] noong $2)',
	'confirmaccount-rational' => 'Batayang katwiran na ibinigay sa humihiling:',
	'confirmaccount-noreason' => '(wala)',
	'confirmaccount-autorej' => '(kusang iwinaksi na ang kahilingang ito dahil sa kawalan ng galaw)',
	'confirmaccount-held' => '(tinatakang "nakaantabay" ni [[User:$1|$1]] noong $2)',
	'confirmaccount-create' => 'Tanggapin (likhain ang akawnt)',
	'confirmaccount-deny' => 'Tanggihan (alisin sa talaan)',
	'confirmaccount-hold' => 'Ibinbin',
	'confirmaccount-spam' => 'Manlulusob (huwag ipadala ang e-liham)',
	'confirmaccount-reason' => 'Puna (isasama sa e-liham):',
	'confirmaccount-ip' => 'Adres ng IP:',
	'confirmaccount-submit' => 'Tiyakin',
	'confirmaccount-needreason' => 'Dapat kang magbigay ng isang dahilan sa loob ng kahon ng kumentong nasa ibaba.',
	'confirmaccount-canthold' => 'Ang kahilingang ito ay maaaring nakabinbin pa o nabura na.',
	'confirmaccount-acc' => 'Matagumpay na natiyak ang kahilingan;
nalikha na ang bagong akawnt ng tagagamit [[User:$1|$1]].',
	'confirmaccount-rej' => 'Matagumpay na natanggihan ang paghiling ng akawnt.',
	'confirmaccount-viewing' => '(kasalukuyang tinitingnan ni [[User:$1|$1]])',
	'confirmaccount-summary' => 'Nililikha ang pahina ng tagagamit na may talambuhay ng bagong tagagamit.',
	'confirmaccount-welc' => "'''Maligayang pagdating sa ''{{SITENAME}}''!'''
Umaasa kaming mag-aambag ka ng marami at kapakipakinabang.
Marahil ay nanaisin mong basahin ang [[{{MediaWiki:Helppage}}|mga pahinang pantulong]].
Muli, maligayang pagdating at nawa'y malibang ka!",
	'confirmaccount-wsum' => 'Maligayang pagdating!',
	'confirmaccount-email-subj' => 'Paghiling ng akawnt sa {{SITENAME}}',
	'confirmaccount-email-body' => 'Ang kahilingan mong magkaroon ng isang akawnt ay pinayagan na sa {{SITENAME}}.

Pangalan ng akawnt: $1

Hudyat: $2

Dahil sa mga kadahilanang pangkaligtasan, kailangan mong baguhin ang iyong hudyat sa una mong paglagda papasok.
Upang makalagda, pakipuntahan ang {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Ang kahilingan mong magkaroon ng isang akawnt ay pinayagan na sa {{SITENAME}}.

Pangalan ng akawnt: $1

Hudyat: $2

$3

Dahil sa mga kadahilanang pangkaligtasan, kailangan mong baguhin ang iyong hudyat sa una mong paglagda papasok.
Upang makalagda, pakipuntahan ang {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Paumanhin, tinanggihan ang kahilingan mong magkaroon ng isang akawnt na "$1" sa {{SITENAME}}.

May ilang mga paraan kung paano ito nangyari.
Maaaring hindi mo napunuan ng tama ang pormularyo, hindi ka nagbigay ng sapat na haba ng iyong mga tugon, o nabigo kaya sa pag-abot sa ilang mga pamantayan ng patakaran.
Maaaring may mga talaan ng kabatiran ng pakikipag-ugnayang nasa sayt na magagamit mo kung nais mong makaalam ng mas marami pa hinggil sa patakaran ng akawnt ng tagagamit.',
	'confirmaccount-email-body4' => 'Paumanhin, tinanggihan ang kahilingan mong magkaroon ng isang akawnt na "$1" sa {{SITENAME}}.

$2

Maaaring may mga talaan ng kabatiran ng pakikipag-ugnayang nasa sayt na magagamit mo kung nais mong makaalam ng mas marami pa hinggil sa patakaran ng akawnt ng tagagamit.',
	'confirmaccount-email-body5' => 'Bago tanggapin ang kahilingan mong magkaroon ng isang akawnt na "$1" sa {{SITENAME}}, dapat kang magbigay muna ng ilan pang karagdagang kabatiran.

$2

Maaaring may mga talaan ng kabatiran ng pakikipag-ugnayang nasa sayt na magagamit mo kung nais mong makaalam ng mas marami pa hinggil sa patakaran ng akawnt ng tagagamit.',
	'usercredentials' => 'Mga katibayan ng katangian ng tagagamit',
	'usercredentials-leg' => 'Natiyak ng paghahanap ang mga katibayan ng katangian para sa isang tagagamit',
	'usercredentials-user' => 'Pangalan ng tagagamit:',
	'usercredentials-text' => 'Nasa ibaba ang napatotohanang mga katibayan ng katangian ng napiling akawnt ng tagagamit.',
	'usercredentials-leg-user' => 'Akawnt ng tagagamit',
	'usercredentials-leg-areas' => 'Mga pangunahing bagay-bagay na kinawiwilihan',
	'usercredentials-leg-person' => 'Pansariling kabatiran',
	'usercredentials-leg-other' => 'Iba pang kabatiran',
	'usercredentials-email' => 'E-liham:',
	'usercredentials-real' => 'Totoong pangalan:',
	'usercredentials-bio' => 'Talambuhay:',
	'usercredentials-attach' => 'Talaan ng karanasan sa hanapbuhay:',
	'usercredentials-notes' => 'Karagdagang mga tala:',
	'usercredentials-urls' => 'Talaan ng mga websayt:',
	'usercredentials-ip' => 'Orihinal na adres ng IP:',
	'usercredentials-member' => 'Mga karapatan:',
	'usercredentials-badid' => 'Walang natagpuang mga katibaya ng katangian para sa tagagamit na ito.
Suriin kung ibinaybay ng tama ang pangalan.',
);

/** Turkish (Türkçe)
 * @author Homonihilis
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'requestaccount' => 'Hesap iste',
	'requestaccount-text' => "'''Kullanıcı hesabı istemek için aşağıdaki formu doldurun ve gönderin'''.

Hesap istemeden önce ilk olarak [[{{MediaWiki:Requestaccount-page}}|Hizmet Koşullarını]] okuduğunuzdan emin olun.

Hesap onaylandığında size bir bildirim e-postası gönderilecek ve hesabınız [[Special:UserLogin|oturum açma]] sonucunda kullanılabilir olacak.",
	'requestaccount-page' => '{{ns:project}}:Hizmet Koşulları',
	'requestaccount-dup' => "'''Not: Halihazırda kayıtlı bir hesap ile oturum açmış durumdasınız.'''",
	'requestaccount-leg-user' => 'Kullanıcı hesabı',
	'requestaccount-leg-areas' => 'Ana ilgi alanları',
	'requestaccount-leg-person' => 'Personel bilgileri',
	'requestaccount-leg-other' => 'Diğer bilgiler',
	'requestaccount-leg-tos' => 'Hizmet Koşulları',
	'requestaccount-acc-text' => 'Bu istek gönderildiğinde e-posta adresinize bir onay mesajı gönderilecektir.
Lütfen e-postada verilen onay bağlantısına tıklayarak cevap verin.
Ayrıca hesabınız oluşturulduğunda parolanız da size e-posta ile gönderilecektir.',
	'requestaccount-areas-text' => 'Resmi uzmanlığa sahip olduğunuz veya çalışmak istediğiniz alanları aşağıdan seçin.',
	'requestaccount-ext-text' => 'Aşağıdaki bilgiler gizli tutulmaktadır ve sadece bu istek için kullanılacaktır.
Kimlik doğrulamada yardımcı olması için telefon numarası gibi irtibat bilgilerini eklemek isteyebilirsiniz.',
	'requestaccount-bio-text' => 'Biyografiniz, kullanıcı sayfanız için varsayılan içerik olarak ayarlanacak.
Referans da dahil etmeye çalışın.
Bu bilgileri yayımlama konusunda herhangi bir çekinceniz olmadığından emin olun.
Kullanıcı adınız [[Special:Preferences|tercihleriniz]] aracılığıyla değiştirilebilmektedir.',
	'requestaccount-real' => 'Gerçek isminiz:',
	'requestaccount-same' => '(gerçek isim ile aynı)',
	'requestaccount-email' => 'E-posta adresi:',
	'requestaccount-reqtype' => 'Konum:',
	'requestaccount-level-0' => 'yazar',
	'requestaccount-level-1' => 'editör',
	'requestaccount-bio' => 'Kişisel biyografi:',
	'requestaccount-attach' => 'Özgeçmiş veya CV (isteğe bağlı):',
	'requestaccount-notes' => 'Ek notlar:',
	'requestaccount-urls' => 'Varsa web sitelerin listesi (yeni satırlarla ayrılmış):',
	'requestaccount-agree' => 'Gerçek isminizin doğru olduğunu ve Hizmet Koşullarımızı kabul ettiğinizi belgelemeniz gerekmektedir.',
	'requestaccount-inuse' => 'Kullanıcı, halihazırda beklemede olan bir hesap isteğinde kullanımda.',
	'requestaccount-tooshort' => 'Biyografiniz en az $1 kelime uzunluğunda olmalı.',
	'requestaccount-emaildup' => 'Bekleyen bir diğer hesap isteği de aynı e-posta adresini kullanıyor.',
	'requestaccount-exts' => 'Ek dosya türüne izin verilmiyor.',
	'requestaccount-resub' => 'CV/Özgeçmiş dosyanız güvenlik nedenleriyle tekrar seçilmek durumunda.
Eklemek istemiyorsanız alanı boş bırakın.',
	'requestaccount-tos' => '{{SITENAME}} [[{{MediaWiki:Requestaccount-page}}|Hizmet Koşullarını]] okudum ve uymayı kabul ediyorum.
"Gerçek isim" bölümüne girmiş olduğum isim gerçek ismimdir.',
	'requestaccount-submit' => 'Hesap iste',
	'requestaccount-sent' => 'Hesap isteğiniz başarıyla gönderildi ve şu anda inceleme bekliyor.',
	'request-account-econf' => 'E-posta adresiniz doğrulandı ve hesap isteğinde bu şekilde listelenecek',
	'requestaccount-email-subj' => '{{SITENAME}} e-posta adresi doğrulaması',
	'requestaccount-email-body' => '$1 IP adresini kullanan biri (muhtemelen siz), {{SITENAME}} üzerinde bu e-posta adresiyle "$2" hesabını talep etti.

Bu hesabın {{SITENAME}} üzerinde gerçekten de size ait olduğunu onaylamak için, bu bağlantıyı tarayıcınızda açın:

$3

Hesap oluşturulmuşsa sadece size e-posta ile parola gönderilecektir.
Bu siz *değilseniz*, bağlantıyı açmayın.
Bu onay kodu, $4 tarihinde geçerliliğini yitirecektir.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} hesap isteği',
	'requestaccount-email-body-admin' => '"$1" bir hesap isteğinde bulundu ve onay bekliyor.
E-posta adresi doğrulandı. İsteği şuradan onaylayabilirsiniz: "$2".',
	'acct_request_throttle_hit' => 'Üzgünüz, daha önce {{PLURAL:$1|1 hesap|$1 hesap}} isteğinde bulunmuşsunuz.
Daha fazla istekte bulunamazsınız.',
	'requestaccount-loginnotice' => "Bir kullanıcı hesabı almak için, '''[[Special:RequestAccount|istekte bulunmanız]]''' gerekmektedir.",
	'confirmaccount-newrequests' => "'''$1''' açık e-postası doğrulanmış [[Special:ConfirmAccounts|hesap {{PLURAL:$1|istek|istek}}]] beklemede",
	'confirmaccounts' => 'Hesap isteklerini onayla',
	'confirmedit-desc' => 'Bürokratlara hesap isteklerini onaylama imkanı vermektedir',
	'confirmaccount-maintext' => "'''Bu sayfa ''{{SITENAME}}'' üzerindeki beklemede olan hesap isteklerini onaylamak için kullanılmaktadır'''.

Tüm hesap istek grupları, üç alt gruptan oluşmaktadır.
Biri açık istekler, biri ek bilgi beklendiği için diğer hizmetliler tarafından askıya alınmış olanlar, üçüncüsü de yakın zamanda reddedilmiş istekler içindir.

Bir isteğe cevap verirken dikkatli bir şekilde inceleyin ve gerekirse verilen bilgileri onaylayın. İşlemleriniz gizli kayıt altında tutulacaktır.
Ayrıca kendinizin dışındaki her türlü işlemi de incelemeniz beklenmektedir.",
	'confirmaccount-list' => 'Aşağıda onay bekleyen isteklerin bir listesi bulunmaktadır.
Bir istek onaylandığında ya da reddedildiğinde bu listeden çıkarılmaktadır.',
	'confirmaccount-list2' => 'Aşağıda birkaç gün geçtikten sonra otomatik olarak silinebilecek olan yakın zamanda reddedilmiş hesap isteklerinin bir listesi yer almaktadır.
Halen onaylanmaları mümkündür, ancak bunu yapmadan önce ret işlemini gerçekleştiren hizmetliye danışmanız yararlı olabilir.',
	'confirmaccount-list3' => 'Aşağıda birkaç gün geçince otomatik olarak silinebilecek süresi dolmuş hesap isteklerinin bir listesi bulunmaktadır.
Onaylanmaları halen mümkündür.',
	'confirmaccount-text' => "Bu, '''{{SITENAME}} üzerinde beklemede olan bir kullanıcı hesabı isteğidir.

Aşağıdaki bilgileri dikkatli bir biçimde inceleyin.
Bu isteği onaylıyorsanız, kullanıcı hesap durumunu ayarlamak için konum hızlı menüsünü kullanın.
Uygulama biyografisinde yapılan değişiklikler, kalıcı referans saklama durumunu etkilemeyecektir.
Hesabı farklı bir kullanıcı adı altında açmayı tercih edebileceğinizi unutmayın.
Bunu sadece diğer kullanıcı adları ile çakışma halinde kullanın.

Bu sayfadan isteği onaylamadan ya da reddetmeden çıkmanız halinde, istek beklemede kalacaktır.",
	'confirmaccount-none-o' => 'Şu anda bu listede beklemede olan açık hesap isteği bulunmuyor.',
	'confirmaccount-none-h' => 'Şu anda bu listede askıda olan açık hesap isteği bulunmuyor.',
	'confirmaccount-none-r' => 'Şu anda bu listede yakın zamanda reddedilmiş hesap isteği bulunmuyor.',
	'confirmaccount-none-e' => 'Şu anda bu listede süresi dolmuş hesap isteği bulunmuyor.',
	'confirmaccount-real-q' => 'İsim',
	'confirmaccount-email-q' => 'E-posta',
	'confirmaccount-bio-q' => 'Biyografi',
	'confirmaccount-showopen' => 'açık istekler',
	'confirmaccount-showrej' => 'reddedilen istekler',
	'confirmaccount-showheld' => 'askıda olan istekler',
	'confirmaccount-showexp' => 'süresi dolan istekler',
	'confirmaccount-review' => 'İncele',
	'confirmaccount-types' => 'Aşağıdan bir hesap oluşturma grubu seçin:',
	'confirmaccount-all' => '(tüm grupları göster)',
	'confirmaccount-type' => 'Grup:',
	'confirmaccount-type-0' => 'gelecekteki yazarlar',
	'confirmaccount-type-1' => 'gelecekteki editörler',
	'confirmaccount-q-open' => 'açık istekler',
	'confirmaccount-q-held' => 'askıda olan istekler',
	'confirmaccount-q-rej' => 'yakın zamanda reddedilmiş istekler',
	'confirmaccount-q-stale' => 'süresi dolmuş istekler',
	'confirmaccount-badid' => 'Verilen kimliğe karşılık gelen ve beklemede olan bir istek bulunmuyor.
İşlemi tamamlanmış olabilir.',
	'confirmaccount-leg-user' => 'Kullanıcı hesabı',
	'confirmaccount-leg-areas' => 'Ana ilgi alanları',
	'confirmaccount-leg-person' => 'Kişisel bilgiler',
	'confirmaccount-leg-other' => 'Diğer bilgiler',
	'confirmaccount-name' => 'Kullanıcı adı',
	'confirmaccount-real' => 'Adı:',
	'confirmaccount-email' => 'E-posta:',
	'confirmaccount-reqtype' => 'Konum:',
	'confirmaccount-pos-0' => 'yazar',
	'confirmaccount-pos-1' => 'editör',
	'confirmaccount-bio' => 'Biyografi:',
	'confirmaccount-attach' => 'Özgeçmiş/CV:',
	'confirmaccount-notes' => 'Ek notlar:',
	'confirmaccount-urls' => 'Web sitelerin listesi:',
	'confirmaccount-none-p' => '(girilmemiş)',
	'confirmaccount-confirm' => 'Bu isteği kabul etmek, reddetmek ya da askıya almak için aşağıdaki seçenekleri kullanın:',
	'confirmaccount-econf' => '(onaylandı)',
	'confirmaccount-reject' => '($2 tarihinde [[User:$1|$1]] tarafından reddedildi)',
	'confirmaccount-rational' => 'Başvuran kişiye sunulan gerekçe:',
	'confirmaccount-noreason' => '(hiçbiri)',
	'confirmaccount-autorej' => '(bu istek, etkin olmama nedeniyle otomatik olarak iptal edildi)',
	'confirmaccount-held' => '($2 tarihinde [[User:$1|$1]] tarafından "askıda" olarak işaretlendi)',
	'confirmaccount-create' => 'Kabul et (hesabı oluştur)',
	'confirmaccount-deny' => 'Reddet (listeden çıkar)',
	'confirmaccount-hold' => 'Askıya al',
	'confirmaccount-spam' => 'Reklam (e-posta gönderme)',
	'confirmaccount-reason' => 'Yorum (e-postaya dahil edilecek):',
	'confirmaccount-ip' => 'IP adresi:',
	'confirmaccount-legend' => 'Bu hesabı onayla/reddet',
	'confirmaccount-submit' => 'Onayla',
	'confirmaccount-needreason' => 'Aşağıdaki yorum kutusuna bir gerekçe girmelisiniz.',
	'confirmaccount-canthold' => 'Bu istek ya askıda ya da silinmiş.',
	'confirmaccount-acc' => 'Hesap isteği başarıyla doğrulandı;
yeni kullanıcı hesabı [[User:$1|$1]] oluşturuldu.',
	'confirmaccount-rej' => 'Hesap isteği başarıyla reddedildi.',
	'confirmaccount-viewing' => '(şu an [[User:$1|$1]] tarafından inceleniyor)',
	'confirmaccount-summary' => 'Yeni kullanıcının biyografisi ile kullanıcı sayfası oluşturuluyor.',
	'confirmaccount-welc' => "'''''{{SITENAME}}'' projesine hoş geldiniz!'''
Uzun sürede çok katkı yapmanızı umarız.
Muhtemelen [[{{MediaWiki:Helppage}}|yardım sayfalarını]] okumak isteyeceksiniz.
Tekrar hoş geldiniz, iyi eğlenceler!",
	'confirmaccount-wsum' => 'Hoşgeldiniz!',
	'confirmaccount-email-subj' => '{{SITENAME}} hesap isteği',
	'confirmaccount-email-body' => '{{SITENAME}} üzerindeki hesap isteğiniz onaylandı.

Hesap adı: $1

Parola: $2

Güvenlik nedeniyleriyle ilk oturum açışınızda parolanızı değiştirmeniz gerekecek.
Oturum açmak için, lütfen {{fullurl:Special:UserLogin}} sayfasını ziyaret edin.',
	'confirmaccount-email-body2' => '{{SITENAME}} üzerindeki hesap isteğiniz onaylandı.

Hesap adı: $1

Parola: $2

$3

Güvenlik nedeniyle ilk oturum açışınızda parolanızı değiştirmeniz gerekecek.
Oturum açmak için lütfen {{fullurl:Special:UserLogin}} sayfasını ziyaret edin.',
	'confirmaccount-email-body3' => 'Üzgünüz, "$1" hesabı için {{SITENAME}} üzerindeki isteğiniz reddedildi.

Bunun gerçekleşmesinin birkaç nedeni bulunmaktadır.
Formu doğru şekilde doldurmamış, cevaplarınızda yeterli uzunluğa ulaşmamış ya da bazı politika kriterlerini karşılayamamış olabilirsiniz.
Sitede, kullanıcı hesap politikamız hakkında daha fazla bilgi almak istemeniz halinde kullanabileceğiz irtibat listeleri bulunabilir.',
	'confirmaccount-email-body4' => 'Üzgünüz, "$1" hesabı için {{SITENAME}} üzerindeki isetğiniz reddedildi.

$2

Kullanıcı hesap politikamız hakkında daha fazla bilgi almak isterseniz kullanabileceğiz sitede irtibat listeleri bulunabilir.',
	'confirmaccount-email-body5' => '"$1" hesabı için {{SITENAME}} üzerindeki isteğinizin kabul edilmesinden önce bazı ek bilgileri sağlamanız gerekmektedir.

$2

Sitede, kullanıcı hesap politikamız hakkında daha fazla bilgi almak istemeniz halinde kullanabileceğiniz irtibat listeleri bulunabilir.',
	'usercredentials' => 'Kullanıcı referansları',
	'usercredentials-leg' => 'Bir kullanıcının onaylanmış referanslarını incele',
	'usercredentials-user' => 'Kullanıcı adı:',
	'usercredentials-text' => 'Aşağıda seçilen kullanıcı hesabı için doğrulanmış referanslar yer almaktadır.',
	'usercredentials-leg-user' => 'Kullanıcı hesabı',
	'usercredentials-leg-areas' => 'Ana ilgi alanları',
	'usercredentials-leg-person' => 'Kişisel bilgiler',
	'usercredentials-leg-other' => 'Diğer bilgiler',
	'usercredentials-email' => 'E-posta:',
	'usercredentials-real' => 'Gerçek isminiz:',
	'usercredentials-bio' => 'Biyografi:',
	'usercredentials-attach' => 'Özgeçmiş/CV:',
	'usercredentials-notes' => 'Ek notlar:',
	'usercredentials-urls' => 'Web sitelerin listesi',
	'usercredentials-ip' => 'Orijinal IP adresi:',
	'usercredentials-member' => 'Haklar:',
	'usercredentials-badid' => 'Bu kullanıcı için referans bulunamadı.
İsmin doğru yazıldığından emin olun.',
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Hesap istekleri grubunu]] görür',
	'right-requestips' => 'İstenen hesaplarla ilgili işlem yaparken istek sahibinin IP adresini görür',
	'right-lookupcredentials' => '[[Special:UserCredentials|Kullanıcı referanslarını]] görür',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'confirmaccount-email-q' => 'ئېلخەت',
	'confirmaccount-name' => 'ئىشلەتكۇچى ئىسمى',
	'confirmaccount-email' => 'ئېلخەت:',
	'usercredentials-user' => 'ئىشلەتكۇچى ئىسمى:',
	'usercredentials-email' => 'ئېلخەت:',
);

/** Uighur (Latin) (Uyghurche‎ / ئۇيغۇرچە (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'confirmaccount-email-q' => 'Élxet',
	'confirmaccount-name' => 'Ishletkuchi ismi',
	'confirmaccount-email' => 'Élxet:',
	'usercredentials-user' => 'Ishletkuchi ismi:',
	'usercredentials-email' => 'Élxet:',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'requestaccount' => 'Запит облікового запису',
	'requestaccount-text' => "'''Заповніть та відправте наступну форму запиту облікового запису'''.

Будь ласка, спершу прочитайте [[{{MediaWiki:Requestaccount-page}}|Умови надання послуг]].

Після того, як обліковий запис буде підтверджено, вас буде повідомлено про це електронною поштою і ви зможете [[Special:UserLogin|ввійти до системи]].",
	'requestaccount-page' => '{{ns:project}}:Умови надання послуг',
	'requestaccount-dup' => "'''Примітка: Ви вже ввійшли в систему із зареєстрованого облікового запису.'''",
	'requestaccount-leg-user' => 'Обліковий запис',
	'requestaccount-leg-areas' => 'Головні області зацікавлень',
	'requestaccount-email' => 'Адреса електронної пошти:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'редактор',
	'confirmaccount-email-q' => 'Електронна пошта',
	'confirmaccount-name' => "Ім'я користувача",
	'confirmaccount-real' => "Ім'я:",
	'confirmaccount-email' => 'Електронна адреса:',
	'confirmaccount-reqtype' => 'Посада:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-submit' => 'Підтвердити',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'confirmedit-desc' => 'Permete ai burocrati de confermar le richieste de account',
);

/** Veps (Vepsan kel')
 * @author Triple-ADHD-AS
 */
$messages['vep'] = array(
	'confirmaccount-real-q' => 'Nimi',
	'confirmaccount-real' => 'Nimi:',
	'confirmaccount-ip' => 'IP-adres:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'requestaccount' => 'Xin tài khoản',
	'requestaccount-page' => '{{ns:project}}:Điều kiện dịch vụ',
	'requestaccount-leg-user' => 'Tài khoản',
	'requestaccount-leg-person' => 'Thông tin cá nhân',
	'requestaccount-leg-other' => 'Thông tin khác',
	'requestaccount-level-0' => 'tác giả',
	'requestaccount-level-1' => 'người sửa đổi',
	'requestaccount-notes' => 'Chi tiết:',
	'requestaccount-submit' => 'Xin tài khoản',
	'confirmaccount-bio-q' => 'Tiểu sử',
	'confirmaccount-review' => 'Duyệt',
	'confirmaccount-leg-user' => 'Tài khoản',
	'confirmaccount-leg-person' => 'Thông tin cá nhân',
	'confirmaccount-leg-other' => 'Thông tin khác',
	'confirmaccount-name' => 'Tên người dùng',
	'confirmaccount-pos-0' => 'tác giả',
	'confirmaccount-pos-1' => 'người sửa trang',
	'confirmaccount-bio' => 'Tiểu sử:',
	'confirmaccount-notes' => 'Chi tiết:',
	'confirmaccount-noreason' => '(không có)',
	'usercredentials-user' => 'Tên người dùng:',
	'usercredentials-leg-user' => 'Tài khoản',
	'usercredentials-leg-person' => 'Thông tin cá nhân',
	'usercredentials-leg-other' => 'Thông tin khác',
	'usercredentials-bio' => 'Tiểu sử:',
	'usercredentials-notes' => 'Chi tiết:',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'requestaccount' => 'Begön kali',
	'requestaccount-dup' => "'''Demolös: Ya enunädol oli me kal peregistaröl.'''",
	'requestaccount-leg-user' => 'Gebanakal',
	'requestaccount-leg-person' => 'Nüns pösodik',
	'requestaccount-leg-other' => 'Nüns votik',
	'requestaccount-real' => 'Nem jenöfik:',
	'requestaccount-same' => '(nem ot äs nem jenöfik)',
	'requestaccount-email' => 'Ladet leäktronik:',
	'requestaccount-reqtype' => 'Staned:',
	'requestaccount-level-0' => 'lautan',
	'requestaccount-bio' => 'Lifajenäd pösodik:',
	'requestaccount-notes' => 'Noets pluik:',
	'requestaccount-tooshort' => 'Lifajenäd olik muton labön {{PLURAL:$1|vodi|vodis}} pu $1.',
	'requestaccount-submit' => 'Begön kali',
	'confirmaccounts' => 'Fümedön kalibegis',
	'confirmaccount-real-q' => 'Nem',
	'confirmaccount-email-q' => 'Ladet leäktronik',
	'confirmaccount-bio-q' => 'Lifajenäd',
	'confirmaccount-leg-user' => 'Gebanakal',
	'confirmaccount-leg-person' => 'Nüns pösodik',
	'confirmaccount-leg-other' => 'Nüns votik',
	'confirmaccount-name' => 'Gebananem',
	'confirmaccount-real' => 'Nem:',
	'confirmaccount-email' => 'Ladet leäktronik:',
	'confirmaccount-reqtype' => 'Staned:',
	'confirmaccount-pos-0' => 'lautan',
	'confirmaccount-bio' => 'Lifajenäd:',
	'confirmaccount-notes' => 'Noets pluik:',
	'confirmaccount-econf' => '(pefümedon)',
	'confirmaccount-noreason' => '(nonik)',
	'confirmaccount-reason' => 'Küpet (obinon in pened leäktronik):',
	'confirmaccount-ip' => 'Ladet-IP:',
	'confirmaccount-submit' => 'Fümedön',
	'confirmaccount-wsum' => 'Benokömö!',
	'confirmaccount-email-subj' => 'Beg kala ela {{SITENAME}}',
	'usercredentials-user' => 'Gebananem:',
	'usercredentials-leg-user' => 'Gebanakal',
	'usercredentials-leg-person' => 'Nüns pösodik',
	'usercredentials-leg-other' => 'Nüns votik',
	'usercredentials-email' => 'Ladet leäktronik:',
	'usercredentials-real' => 'Nem jenöfik:',
	'usercredentials-bio' => 'Lifajenäd:',
	'usercredentials-ip' => 'Ladet-IP rigik:',
	'usercredentials-member' => 'Gitäts:',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'confirmaccount-real-q' => 'נאמען',
	'confirmaccount-name' => 'באַניצער נאָמען',
	'confirmaccount-real' => 'נאָמען:',
	'usercredentials-user' => 'באַניצער נאָמען:',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'requestaccount' => '請求戶口',
	'requestaccount-text' => "'''完成並遞交下面嘅表格去請求一個用戶戶口'''。

	請確認你響請求一個戶口之前，先讀過[[{{MediaWiki:Requestaccount-page}}|服務細則]]。

	一旦個戶口批准咗，你將會收到一個電郵通知訊息，噉個戶口就可以響[[Special:Userlogin]]度用。",
	'requestaccount-dup' => "'''留意: 你已經登入咗做一個已經註冊咗嘅戶口。'''",
	'requestaccount-acc-text' => '當完成請求時，一封確認訊息會發到你嘅電郵地址。
	請響封電郵度撳個確認連結去回應佢。同時，當你個戶口開咗之後，你戶口個密碼將會電郵畀你。',
	'requestaccount-ext-text' => '下面嘅資料會保密，而且只係會用響呢次請求度。
	你可能需要列示聯絡資料，好似電話號碼等去幫手證明你嘅確認。',
	'requestaccount-bio-text' => '你嘅傳記將會設定做響你用戶頁度嘅預設內容。試吓包含任何嘅憑據。
	而且你係肯定你係可以發佈呢啲資料。你嘅名可以透過[[Special:Preferences]]改到。',
	'requestaccount-real' => '真名:',
	'requestaccount-same' => '(同真名一樣)',
	'requestaccount-email' => '電郵地址:',
	'requestaccount-bio' => '個人傳記:',
	'requestaccount-notes' => '附加註解:',
	'requestaccount-urls' => '網站一覽，如有者 (用新行分開):',
	'requestaccount-agree' => '你一定要證明到你個真名係啱嘅，而且你同意我哋嘅服務細則。',
	'requestaccount-inuse' => '個用戶名已經用來請求緊個戶口。',
	'requestaccount-tooshort' => '你嘅傳記一定要最少有$1個字長。',
	'requestaccount-tos' => '我已經讀咗同埋同意持續遵守{{SITENAME}}嘅服務細則。',
	'requestaccount-submit' => '請求戶口',
	'requestaccount-sent' => '你個戶口請求已經成功發出，現正等候複審。',
	'request-account-econf' => '你嘅電郵地址已經確認，將會響你嘅戶口請求度列示。',
	'requestaccount-email-subj' => '{{SITENAME}}電郵地址確認',
	'requestaccount-email-body' => '有人，可能係你，由IP地址$1，響{{SITENAME}}度用呢個電郵地址請求一個叫做"$2"嘅戶口。

去確認呢個戶口真係屬於響{{SITENAME}}上面嘅你，就響你嘅瀏覽器度開呢個連結:

$3

如果個戶口開咗，只有你先至會收到個電郵密碼。如果呢個戶口*唔係*你嘅話，唔好撳個連結。
呢個確認碼將會響$4過期。',
	'acct_request_throttle_hit' => '對唔住，你已經請求咗$1個戶口。你唔可以請求更多個戶口。',
	'requestaccount-loginnotice' => "要拎一個用戶戶口，你一定要'''[[Special:RequestAccount|請求一個]]'''。",
	'confirmaccounts' => '確認戶口請求',
	'confirmaccount-list' => '下面係等緊批准嘅用戶請求一覽。
	已經批准嘅戶口將會建立同埋響呢個表度拎走。拒絕咗嘅用戶將會就噉響呢個表度拎走。',
	'confirmaccount-list2' => '下面係一個先前拒絕過嘅戶口請求，可能會響幾日之後刪除。
	佢哋仍舊可以批准去開一個戶口，但係響你做之前請問吓拒絕嘅管理員先。',
	'confirmaccount-text' => "呢個係響'''{{SITENAME}}'''度等候請求戶口嘅一版。
	請小心去睇過，有需要嘅話，就要確認埋佢下面全部嘅資料。
	要留意嘅係你可以用另一個用戶名去開一個戶口。只係同其他嘅名有衝突嗰陣先至去做。

	如果你無確認或者拒絕呢個請求，就噉留低呢版嘅話，佢就會維持等候狀態。",
	'confirmaccount-review' => '批准/拒絕',
	'confirmaccount-badid' => '提供嘅ID係無未決定嘅請求。佢可能已經被處理咗。',
	'confirmaccount-name' => '用戶名',
	'confirmaccount-real' => '名',
	'confirmaccount-email' => '電郵',
	'confirmaccount-bio' => '傳記',
	'confirmaccount-urls' => '網站一覽:',
	'confirmaccount-confirm' => '用下面嘅掣去批准或拒絕呢個請求。',
	'confirmaccount-econf' => '(已批准)',
	'confirmaccount-reject' => '(響$2被[[User:$1|$1]]拒絕)',
	'confirmaccount-create' => '接受 (開戶口)',
	'confirmaccount-deny' => '拒絕 (反列示)',
	'confirmaccount-reason' => '註解 (會用響封電郵度):',
	'confirmaccount-submit' => '確認',
	'confirmaccount-acc' => '戶口請求已經成功噉確認；開咗一個新嘅用戶戶口[[User:$1]]。',
	'confirmaccount-rej' => '戶口請求已經成功噉拒絕。',
	'confirmaccount-summary' => '開緊一個新用戶擁有傳記嘅用戶頁。',
	'confirmaccount-welc' => "'''歡迎來到''{{SITENAME}}''！'''我哋希望你會作出更多更好的貢獻。
	你可能會去睇吓[[{{MediaWiki:Helppage}}|開始]]。再一次歡迎你！
	[[User:FuzzyBot|FuzzyBot]] 11:50, 3 September 2008 (UTC)",
	'confirmaccount-wsum' => '歡迎！',
	'confirmaccount-email-subj' => '{{SITENAME}}戶口請求',
	'confirmaccount-email-body' => '你請求嘅戶口已經響{{SITENAME}}度批准咗。

戶口名: $1

密碼: $2

為咗安全性嘅原故，你需要響第一次登入嗰陣去改個密碼。要登入，請去{{fullurl:Special:Userlogin}}。',
	'confirmaccount-email-body2' => '你請求嘅戶口已經響{{SITENAME}}度批准咗。

戶口名: $1

密碼: $2

$3

為咗安全性嘅原故，你需要響第一次登入嗰陣去改個密碼。要登入，請去{{fullurl:Special:Userlogin}}。',
	'confirmaccount-email-body3' => '對唔住，你響{{SITENAME}}請求嘅戶口"$1"已經拒絕咗。

當中可能會有好多個原因，令到你嘅請求被拒絕。你可能無正確噉填好晒個表格，可能響你嘅回應度無足夠嘅長度，又可能未能符合到一啲政策嘅條件。響呢個網站度提供咗聯絡人一覽，你可以用去知道更多用戶戶口政策嘅資料。',
	'confirmaccount-email-body4' => '對唔住，你響{{SITENAME}}請求嘅戶口"$1"已經拒絕咗。

$2

響呢個網站度提供咗聯絡人一覽，你可以用去知道更多用戶戶口政策嘅資料。',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'requestaccount' => '请求账户',
	'requestaccount-text' => "'''完成并递交以下的表格去请求一个用户账户'''。

	请确认您在请求一个账户之前，先读过[[{{MediaWiki:Requestaccount-page}}|服务细则]]。

	一旦该账户获得批准，您将会收到一个电邮通知信息，该账户就可以在[[Special:Userlogin]]中使用。",
	'requestaccount-dup' => "'''注意: 您已经登入成一个已注册的账户。'''",
	'requestaccount-acc-text' => '当完成请求时，一封确认信息会发到您的电邮地址。
	请在该封电邮中点击确认连结去反应它。同时，当您的账户被创建后，您账户的个密码将会电邮给您。',
	'requestaccount-ext-text' => '以下的资料将会保密，而且只是会用在这次请求中。
	您可能需要列示联络资料，像电话号码等去帮助证明您的确认。',
	'requestaccount-bio-text' => '您传记将会设置成在您用户页中的预设内容。尝试包含任何的凭据。
	而且你是肯定您是可以发布这些资料。您的名字可以通过[[Special:Preferences]]更改。',
	'requestaccount-real' => '真实名字:',
	'requestaccount-same' => '（同真实名字）',
	'requestaccount-email' => '电邮地址:',
	'requestaccount-bio' => '个人传记:',
	'requestaccount-notes' => '附加注解:',
	'requestaccount-urls' => '网站列表，如有者 （以新行分开）:',
	'requestaccount-agree' => '您一定要证明到您的真实名字是正确的，而且您同意我们的服务细则。',
	'requestaccount-inuse' => '该用户名已经用来请求账户。',
	'requestaccount-tooshort' => '您的传记必须最少有$1个字的长度。',
	'requestaccount-tos' => '我已经阅读以及同意持续遵守{{SITENAME}}的服务细则。',
	'requestaccount-submit' => '请求账户',
	'requestaccount-sent' => '您的账户请求已经成功发出，现正等候复审。',
	'request-account-econf' => '您的电邮地址已经确认，将会在您的账户口请求中列示。',
	'requestaccount-email-subj' => '{{SITENAME}}电邮地址确认',
	'requestaccount-email-body' => '有人，可能是您，由IP地址$1，在{{SITENAME}}中用这个电邮地址请求一个名叫"$2"的账户。

要确认这个户口真的属于在{{SITENAME}}上面?您，就在您的浏览器中度开启这个连结:

$3

如果该账户已经创建，只有您才会收到该电邮密码。如果这个账户*不是*属于您的话，不要点击这个连结。
呢个确认码将会响$4过期。',
	'acct_request_throttle_hit' => '抱歉，您已经请求了$1个户口。您不可以请求更多个账户。',
	'requestaccount-loginnotice' => "要取得个用户账户，您一定要'''[[Special:RequestAccount|请求一个]]'''。",
	'confirmaccounts' => '确认户口请求',
	'confirmaccount-list' => '以下是正在等候批准的用户请求列表。
	已经批准的账户将会创建以及在这个列表中移除。已拒绝的用户将只会在这个表中移除。',
	'confirmaccount-list2' => '以下是一个先前拒绝过的帐口请求，可能会在数日后删除。
	它们仍旧可以批准创建一个账户，但是在您作之前请先问拒绝该账户的管理员。',
	'confirmaccount-text' => "这个是在'''{{SITENAME}}'''中等候请求账户的页面。
	请小心阅读，有需要的话，就要同时确认它下面的全部资料。
	要留意的是您可以用另一个用户名字去创建一个账户。只有其他的名字有冲突时才需要去作。

	如果你无确认或者拒绝这个请求，只留下这页面的话，它便会维持等候状态。",
	'confirmaccount-review' => '批准/拒绝',
	'confirmaccount-badid' => '提供的ID是没有未决定的请求。它可能已经被处理。',
	'confirmaccount-name' => '用户名字',
	'confirmaccount-real' => '名字',
	'confirmaccount-email' => '电邮',
	'confirmaccount-bio' => '传记',
	'confirmaccount-urls' => '网站列表:',
	'confirmaccount-confirm' => '用以下的按钮去批准或拒绝这个请求。',
	'confirmaccount-econf' => '（已批准）',
	'confirmaccount-reject' => '（于$2被[[User:$1|$1]]拒绝）',
	'confirmaccount-create' => '接受 （创建账户）',
	'confirmaccount-deny' => '拒绝 （反列示）',
	'confirmaccount-reason' => '注解 （在电邮中使用）:',
	'confirmaccount-submit' => '确认',
	'confirmaccount-acc' => '账户请求已经成功确认；已经创建一个新的用户帐号[[User:$1]]。',
	'confirmaccount-rej' => '账户请求已经成功拒绝。',
	'confirmaccount-summary' => '正在创建一个新用户拥有传记的用户页面。',
	'confirmaccount-welc' => "'''欢迎来到''{{SITENAME}}''！'''我们希望您会作出更多更好的贡献。
	您可能会去参看[[{{MediaWiki:Helppage}}|开始]]。再一次欢迎你！
	[[User:FuzzyBot|FuzzyBot]] 11:50, 3 September 2008 （UTC）",
	'confirmaccount-wsum' => '欢迎！',
	'confirmaccount-email-subj' => '{{SITENAME}}账户请求',
	'confirmaccount-email-body' => '您请求的账户已经在{{SITENAME}}中批准。

账户名称: $1

密码: $2

为了安全性的原故，您需要在一次登入时更改密码。要登入，请前往{{fullurl:Special:Userlogin}}。',
	'confirmaccount-email-body2' => '您请求的账户已经在{{SITENAME}}中批准。

账户名称: $1

密码: $2

$3

为了安全性的原故，您需要在一次登入时更改密码。要登入，请前往{{fullurl:Special:Userlogin}}。',
	'confirmaccount-email-body3' => '抱歉，你在{{SITENAME}}请求的账户"$1"已经遭到拒绝。

当中可能会有很多原因，会令到您?请求被拒绝。您可能没有正确地填上整个表格，可能在您的反应中没有足够的长度，又可能未能符合到一些政策的条件。在这个网站中度提供了联络人列表，您可以用去知道更多用户账户方针的资料。',
	'confirmaccount-email-body4' => '抱歉，你在{{SITENAME}}请求的账户"$1"已经遭到拒绝。

$2

在这个网站中度提供了联络人列表，您可以用去知道更多用户账户方针的资料。',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'requestaccount' => '請求帳戶',
	'requestaccount-text' => "'''完成並遞交以下的表格去請求一個用戶帳戶'''。

	請確認您在請求一個帳戶之前，先讀過[[{{MediaWiki:Requestaccount-page}}|服務細則]]。

	一旦該帳戶獲得批准，您將會收到一個電郵通知訊息，該帳戶就可以在[[Special:Userlogin]]中使用。",
	'requestaccount-dup' => "'''注意: 您已經登入成一個已註冊的帳戶。'''",
	'requestaccount-acc-text' => '當完成請求時，一封確認訊息會發到您的電郵地址。
	請在該封電郵中點擊確認連結去回應它。同時，當您的帳戶被創建後，您帳戶的個密碼將會電郵給您。',
	'requestaccount-ext-text' => '以下的資料將會保密，而且只是會用在這次請求中。
	您可能需要列示聯絡資料，像電話號碼等去幫助證明您的確認。',
	'requestaccount-bio-text' => '您傳記將會設定成在您用戶頁中的預設內容。嘗試包含任何的憑據。
	而且你是肯定您是可以發佈這些資料。您的名字可以透過[[Special:Preferences]]更改。',
	'requestaccount-real' => '真實名字:',
	'requestaccount-same' => '（同真實名字）',
	'requestaccount-email' => '電郵地址:',
	'requestaccount-bio' => '個人傳記:',
	'requestaccount-notes' => '附加註解:',
	'requestaccount-urls' => '網站列表，如有者 （以新行分開）:',
	'requestaccount-agree' => '您一定要證明到您的真實名字是正確的，而且您同意我們的服務細則。',
	'requestaccount-inuse' => '該用戶名已經用來請求帳戶。',
	'requestaccount-tooshort' => '您的傳記必須最少有$1個字的長度。',
	'requestaccount-tos' => '我已經閱讀以及同意持續遵守{{SITENAME}}的服務細則。',
	'requestaccount-submit' => '請求帳戶',
	'requestaccount-sent' => '您的帳戶請求已經成功發出，現正等候複審。',
	'request-account-econf' => '您的電郵地址已經確認，將會在您的帳戶口請求中列示。',
	'requestaccount-email-subj' => '{{SITENAME}}電郵地址確認',
	'requestaccount-email-body' => '有人，可能是您，由IP地址$1，在{{SITENAME}}中用這個電郵地址請求一個名叫"$2"的帳戶。

要確認這個戶口真的屬於在{{SITENAME}}上面嘅您，就在您的瀏覽器中度開啟這個連結:

$3

如果該帳戶已經創建，只有您才會收到該電郵密碼。如果這個帳戶*不是*屬於您的話，不要點擊這個連結。
呢個確認碼將會響$4過期。',
	'acct_request_throttle_hit' => '抱歉，您已經請求了$1個戶口。您不可以請求更多個帳戶。',
	'requestaccount-loginnotice' => "要取得個用戶帳戶，您一定要'''[[Special:RequestAccount|請求一個]]'''。",
	'confirmaccounts' => '確認戶口請求',
	'confirmaccount-list' => '以下是正在等候批准的用戶請求列表。
	已經批准的帳戶將會創建以及在這個列表中移除。已拒絕的用戶將只會在這個表中移除。',
	'confirmaccount-list2' => '以下是一個先前拒絕過的帳口請求，可能會在數日後刪除。
	它們仍舊可以批准創建一個帳戶，但是在您作之前請先問拒絕該帳戶的管理員。',
	'confirmaccount-text' => "這個是在'''{{SITENAME}}'''中等候請求帳戶的頁面。
	請小心閱讀，有需要的話，就要同時確認它下面的全部資料。
	要留意的是您可以用另一個用戶名字去創建一個帳戶。只有其他的名字有衝突時才需要去作。

	如果你無確認或者拒絕這個請求，只留下這頁面的話，它便會維持等候狀態。",
	'confirmaccount-review' => '批准/拒絕',
	'confirmaccount-badid' => '提供的ID是沒有未決定的請求。它可能已經被處理。',
	'confirmaccount-name' => '用戶名字',
	'confirmaccount-real' => '名字',
	'confirmaccount-email' => '電郵',
	'confirmaccount-bio' => '傳記',
	'confirmaccount-urls' => '網站列表:',
	'confirmaccount-confirm' => '用以下的按鈕去批准或拒絕這個請求。',
	'confirmaccount-econf' => '（已批准）',
	'confirmaccount-reject' => '（於$2被[[User:$1|$1]]拒絕）',
	'confirmaccount-create' => '接受 （創建帳戶）',
	'confirmaccount-deny' => '拒絕 （反列示）',
	'confirmaccount-reason' => '註解 （在電郵中使用）:',
	'confirmaccount-submit' => '確認',
	'confirmaccount-acc' => '帳戶請求已經成功確認；已經創建一個新的用戶帳號[[User:$1]]。',
	'confirmaccount-rej' => '帳戶請求已經成功拒絕。',
	'confirmaccount-summary' => '正在創建一個新用戶擁有傳記的用戶頁面。',
	'confirmaccount-welc' => "'''歡迎來到''{{SITENAME}}''！'''我們希望您會作出更多更好嘅貢獻。
	您可能會去參看[[{{MediaWiki:Helppage}}|開始]]。再一次歡迎你！
	[[User:FuzzyBot|FuzzyBot]] 11:50, 3 September 2008 （UTC）",
	'confirmaccount-wsum' => '歡迎！',
	'confirmaccount-email-subj' => '{{SITENAME}}帳戶請求',
	'confirmaccount-email-body' => '您請求的帳戶已經在{{SITENAME}}中批准。

帳戶名稱: $1

密碼: $2

為了安全性的原故，您需要在一次登入時更改密碼。要登入，請前往{{fullurl:Special:Userlogin}}。',
	'confirmaccount-email-body2' => '您請求的帳戶已經在{{SITENAME}}中批准。

帳戶名稱: $1

密碼: $2

$3

為了安全性的原故，您需要在一次登入時更改密碼。要登入，請前往{{fullurl:Special:Userlogin}}。',
	'confirmaccount-email-body3' => '抱歉，你在{{SITENAME}}請求的帳戶"$1"已經遭到拒絕。

當中可能會有很多原因，會令到您嘅請求被拒絕。您可能沒有正確地填上整個表格，可能在您的回應中沒有足夠的長度，又可能未能符合到一些政策的條件。在這個網站中度提供了聯絡人列表，您可以用去知道更多用戶帳戶方針的資料。',
	'confirmaccount-email-body4' => '抱歉，你在{{SITENAME}}請求的帳戶"$1"已經遭到拒絕。

$2

在這個網站中度提供了聯絡人列表，您可以用去知道更多用戶帳戶方針的資料。',
);

