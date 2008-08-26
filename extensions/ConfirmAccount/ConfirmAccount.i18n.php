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

Once the account is approved, you will be e-mailed a notification message and the account will be usable at [[Special:Userlogin]].',
	'requestaccount-footer'     => '', # only translate this message to other languages if you have to change it
	'requestaccount-page'       => '{{ns:project}}:Terms of Service',
	'requestaccount-dup'        => '\'\'\'Note: You already are logged in with a registered account.\'\'\'',
	'requestaccount-leg-user'   => 'User account',
	'requestaccount-leg-areas'  => 'Main areas of interest',
	'requestaccount-leg-person' => 'Personal information',
	'requestaccount-leg-other'  => 'Other information',
	'requestaccount-acc-text'   => 'Your e-mail address will be sent a confirmation message once this request is submitted.
Please respond by clicking on the confirmation link provided by the e-mail.
Also, your password will be e-mailed to you when your account is created.',
	'requestaccount-areas-text' => 'Select the topic areas below in which you have formal expertise or would like to do the most work in.',
	'requestaccount-ext-text'   => 'The following information is kept private and will only be used for this request.
You may want to list contacts such a phone number to aid in identify confirmation.',
	'requestaccount-bio-text'   => "Your biography will be set as the default content for your userpage.
Try to include any credentials.
Make sure you are comfortable publishing such information.
Your name can be changed via [[Special:Preferences]].",
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
	'requestaccount-tooshort'   => 'Your biography must be at least be $1 words long.',
	'requestaccount-emaildup'   => 'Another pending account request uses the same e-mail address.',
	'requestaccount-exts'       => 'Attachment file type is disallowed.',
	'requestaccount-resub'      => 'Your CV/resume file must be re-selected for security reasons.
Leave the field blank if you no longer want to include one.',
	'requestaccount-tos'        => 'I have read and agree to abide by the [[{{MediaWiki:Requestaccount-page}}|Terms of Service]] of {{SITENAME}}.
The name I have specified under "Real name" is in fact my own real name.',
	'requestaccount-submit'     => 'Request account',
	'requestaccount-sent'       => 'Your account request has successfully been sent and is now pending review.',

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

	'acct_request_throttle_hit' => "Sorry, you have already requested $1 accounts.
You cannot make any more requests.",
	
	# Add to Special:Login
	'requestaccount-loginnotice' => 'To obtain a user account, you must \'\'\'[[Special:RequestAccount|request one]]\'\'\'.',
	
	# Site message for admins
	'confirmaccount-newrequests' => '\'\'\'$1\'\'\' open e-mail-confirmed {{PLURAL:$1|[[Special:ConfirmAccounts|account request]]|[[Special:ConfirmAccounts|account requests]]}} pending',
	
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
They can still be approved into accounts, though you may want to first consult the rejecting admin before doing so.',
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
	'confirmaccount-submit'   => 'Confirm',
	'confirmaccount-needreason' => 'You must provide a reason in the comment box below.',
	'confirmaccount-canthold' => 'This request is already either on hold or deleted.',
	'confirmaccount-acc'     => 'Account request confirmed successfully; created new user account [[User:$1]].',
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
To login, please go to {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2' => 'Your request for an account has been approved on {{SITENAME}}.

Account name: $1

Password: $2

$3

For security reasons you will need to change your password on first login.
To login, please go to {{fullurl:Special:Userlogin}}.',
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
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'confirmaccount-name'  => 'Asa',
	'usercredentials-user' => 'Asa:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'confirmaccount-email-q' => 'Электрон почто',
	'confirmaccount-name'    => 'Пайдаланышын лӱмжӧ',
	'confirmaccount-email'   => 'Электрон почто:',
	'usercredentials-user'   => 'Пайдаланышын лӱмжӧ:',
	'usercredentials-email'  => 'Электрон почто:',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'confirmaccount-email-q' => 'Meli hila',
	'confirmaccount-name'    => 'Matahigoa he tagata',
	'confirmaccount-email'   => 'Meli hila:',
	'usercredentials-user'   => 'Matahigoa he tagata:',
	'usercredentials-email'  => 'Meli hila:',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author SPQRobin
 * @author Naudefj
 */
$messages['af'] = array(
	'requestaccount-leg-person'  => 'Persoonlike inligting',
	'requestaccount-leg-other'   => 'Ander inligting',
	'requestaccount-real'        => 'Regte naam:',
	'requestaccount-email'       => 'E-pos adres:',
	'requestaccount-reqtype'     => 'Posisie:',
	'requestaccount-level-0'     => 'outeur',
	'requestaccount-level-1'     => 'redakteur',
	'requestaccount-notes'       => 'Addisionele notas:',
	'confirmaccount-real-q'      => 'Naam',
	'confirmaccount-email-q'     => 'E-pos',
	'confirmaccount-bio-q'       => 'Biografie',
	'confirmaccount-leg-person'  => 'Persoonlike inligting',
	'confirmaccount-leg-other'   => 'Ander inligting',
	'confirmaccount-name'        => 'Gebruikersnaam',
	'confirmaccount-real'        => 'Naam:',
	'confirmaccount-email'       => 'E-pos:',
	'confirmaccount-reqtype'     => 'Posisie:',
	'confirmaccount-pos-0'       => 'outeur',
	'confirmaccount-pos-1'       => 'redakteur',
	'confirmaccount-bio'         => 'Biografie:',
	'confirmaccount-notes'       => 'Addisionele notas:',
	'confirmaccount-urls'        => 'Lys van webruimtes:',
	'confirmaccount-noreason'    => '(geen)',
	'confirmaccount-submit'      => 'Bevestig',
	'usercredentials-user'       => 'Gebruikersnaam:',
	'usercredentials-leg-person' => 'Persoonlike inligting',
	'usercredentials-leg-other'  => 'Ander inligting',
	'usercredentials-email'      => 'E-pos:',
	'usercredentials-real'       => 'Regte naam:',
	'usercredentials-bio'        => 'Biografie:',
	'usercredentials-notes'      => 'Addisionele notas:',
	'usercredentials-urls'       => 'Lys van webruimtes:',
	'usercredentials-ip'         => 'Oorspronklike IP adres:',
	'usercredentials-member'     => 'Regte:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'requestaccount-level-1' => 'editor',
	'confirmaccount-pos-1'   => 'editor',
	'confirmaccount-submit'  => 'Confirmar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author ترجمان05
 */
$messages['ar'] = array(
	'requestaccount'                  => 'طلب حساب',
	'requestaccount-text'             => "'''أكمل وابعث الاستمارة التالية لطلب حساب'''. 
	
	تأكد أولا من قراءة [[{{MediaWiki:Requestaccount-page}}|شروط الخدمة]] قبل طلب حساب.
	
	متى تمت الموافقة على الحساب، سيتم إرسال رسالة إخطار إليك والحساب سيصبح قابلا للاستخدام في 
	[[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:شروط الخدمة',
	'requestaccount-dup'              => "'''ملاحظة: أنت مسجل الدخول بالفعل بحساب مسجل.'''",
	'requestaccount-leg-user'         => 'حساب المستخدم',
	'requestaccount-leg-areas'        => 'الاهتمامات الرئيسية',
	'requestaccount-leg-person'       => 'المعلومات الشخصية',
	'requestaccount-leg-other'        => 'معلومات أخرى',
	'requestaccount-acc-text'         => 'سيتم إرسال رسالة تأكيد إلى عنوان بريدك الإلكتروني متى تم بعث هذا الطلب. من فضلك استجب عن طريق الضغط 
	على وصلة التأكيد المعطاة في البريد الإلكتروني. أيضا، كلمة السر الخاصة بك سيتم إرسالها إليك عبر البريد الإلكتروني عندما يتم إنشاء حسابك.',
	'requestaccount-areas-text'       => 'اختر المواضيع بالأسفل التي لديك فيها خبرة رسمية أو التي تود أن تعمل فيها.',
	'requestaccount-ext-text'         => 'المعلومات التالية سرية وسيتم استخدامها فقط لهذا الطلب. 
ربما تريد أن تكتب معلومات الاتصال كرقم تليفون للمساعدة في تأكيد الهوية.',
	'requestaccount-bio-text'         => 'سيرتك الشخصية ستعرض كالمحتوى الافتراضي لصفحة المستخدم الخاصة بك. حاول تضمين 
	أية شهادات. تأكد من ارتياحك لنشر هذه المعلومات. اسمك يمكن تغييره بواسطة [[Special:Preferences]].',
	'requestaccount-real'             => 'الاسم الحقيقي:',
	'requestaccount-same'             => '(مثل الاسم الحقيقي)',
	'requestaccount-email'            => 'عنوان البريد الإلكتروني:',
	'requestaccount-reqtype'          => 'الموضع:',
	'requestaccount-level-0'          => 'مؤلف',
	'requestaccount-level-1'          => 'محرر',
	'requestaccount-info'             => '(؟)',
	'requestaccount-bio'              => 'السيرة الشخصية:',
	'requestaccount-attach'           => 'استكمال أو السيرة الذاتية (اختياري):',
	'requestaccount-notes'            => 'ملاحظات إضافية:',
	'requestaccount-urls'             => 'قائمة مواقع الويب، إن وجدت (افصل بسطور جديدة):',
	'requestaccount-agree'            => 'يجب أن تثبت أن اسمك الحقيقي صحيح و أنك توافق على شروط خدمتنا.',
	'requestaccount-inuse'            => 'اسم المستخدم مستعمل بالفعل في طلب حساب قيد الانتظار',
	'requestaccount-tooshort'         => 'سيرتك يجب أن تتكون على الأقل من $1 كلمة.',
	'requestaccount-emaildup'         => 'طلب حساب آخر قيد الانتظار يستخدم نفس عنوان البريد الإلكتروني.',
	'requestaccount-exts'             => 'نوع الملف المرفق غير مسموح به.',
	'requestaccount-resub'            => 'ملف سيرتك الذاتية/استكمالك يجب أن يتم إعادة اختياره لأسباب أمنية. اترك الحقل فارغا 
	لو كنت لم تعد تريد إضافة واحد.',
	'requestaccount-tos'              => 'لقد قرأت و أوافق على الالتزام بشروط خدمة {{SITENAME}}.',
	'requestaccount-submit'           => 'طلب حساب',
	'requestaccount-sent'             => 'طلبك للحساب تم إرساله بنجاح وهو بانتظار المراجعة الآن.',
	'request-account-econf'           => 'عنوان بريدك الإلكتروني تم تأكيده وسيتم عرضه كما هو في 
طلب حسابك.',
	'requestaccount-email-subj'       => '{{SITENAME}} تأكيد عنوان البريد الإلكتروني من',
	'requestaccount-email-body'       => 'شخص ما، على الأرجح أنت من عنوان الأيبي $1، طلب حساب "$2" بعنوان البريد الإلكتروني هذا على {{SITENAME}}.

لتأكيد أن هذا الحساب ينتمي إليك فعلا على {{SITENAME}}، افتح هذه الوصلة في متصفحك:

$3

لو أن الحساب تم إنشاؤه، فقط أنت سيتم إرسال كلمة السر إليه. لو أن هذا *ليس* أنت، لا تتبع الوصلة. 
كود التأكيد سينتهي في $4.',
	'requestaccount-email-subj-admin' => 'طلب حساب {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" طلب حسابا وينتظر التأكيد.  
عنوان البريد الإلكتروني تم تأكيده. يمكنك تأكيد الطلب هنا "$2".',
	'acct_request_throttle_hit'       => 'عذرا، لقد طلبت بالفعل $1 حساب. لا يمكنك عمل المزيد من الطلبات.',
	'requestaccount-loginnotice'      => "للحصول على حساب، يجب عليك '''[[Special:RequestAccount|طلب واحد]]'''.",
	'confirmaccount-newrequests'      => "{{PLURAL:$1|يوجد|يوجد}} حاليا '''$1'''  
{{PLURAL:$1|[[Special:ConfirmAccounts|طلب حساب]]|[[Special:ConfirmAccounts|طلب حساب]]}} مفتوح قيد الانتظار.",
	'confirmaccounts'                 => 'تأكيد طلبات الحسابات',
	'confirmedit-desc'                => 'يعطي البيروقراطيين القدرة على تأكيد طلبات الحساب',
	'confirmaccount-maintext'         => "'''هذه الصفحة تستخدم لتأكيد طلبات الحساب قيد الانتظار في ''{{SITENAME}}'''''.

كل طابور طلب حساب يتكون من ثلاثة طوابير فرعية، واحد للطلبات المفتوحة، واحد لتلك التي تم وضعها قيد الانتظار بواسطة الإداريين الآخرين بانتظار المزيد من المعلومات، وآخر للطلبات المرفوضة حديثا.

عند الرد على طلب، راجعه بحرص، عند الحاجة، تأكد من المعلومات الموجودة فيه.  
أفعالك ستسجل بسرية. أنت أيضا يتوقع منك أن تراجع أي نشاط يحدث هنا بخلاف ما تفعله بنفسك.",
	'confirmaccount-list'             => 'بالأسفل قائمة بطلبات الحسابات قيد الانتظار. 
	الحسابات التي تمت الموافقة عليها سيتم إنشاؤها وإزالتها من هذه القائمة. الحسابات المرفوضة سيتم ببساطة حذفها من هذه 
القائمة.',
	'confirmaccount-list2'            => 'بالأسفل قائمة بطلبات الحسابات المرفوضة حديثا والتي ربما يتم حذفها تلقائيا 
	عندما يكون عمرها عدة أيام. مازال بالإمكان الموافقة عليهم كحسابات، ولكنك ربما ترغب في استشارة الإداري الرافض 
قبل فعل هذا.',
	'confirmaccount-list3'            => 'بالأسفل قائمة بطلبات الحسابات المنتهية التي يمكن حذفها تلقائيا متى أصبح عمرها عدة أيام.
مازال من الممكن الموافقة عليهم كحسابات.',
	'confirmaccount-text'             => "هذا طلب حساب قيد الانتظار في '''{{SITENAME}}'''. 
	 راجع بحرص المعلومات بالأسفل. لو كنت توافق على هذا الطلب، استخدم قائمة الموضع لضبط حالة الحساب للمستخدم. التعديلات للسيرة الشخصية للمتقدم لن تؤثر على أي مخزن للمؤهلات الدائمة. لاحظ أنه يمكنك اختيار إنشاء الحساب باسم مستخدم آخر 
	. استخدم هذا فقط لتجنب	الاصطدامات مع الأسماء الأخرى.
	
لو تركت ببساطة هذه الصفحة بدون تأكيد أو رفض الحساب، سيبقى قيد الانتظار.",
	'confirmaccount-none-o'           => 'لا توجد حاليا طلبات حساب قيد الانتظار مفتوحة في هذه القائمة.',
	'confirmaccount-none-h'           => 'لا توجد حاليا طلبات حساب قيد الانتظار محجوزة في هذه القائمة.',
	'confirmaccount-none-r'           => 'لا توجد حاليا طلبات حساب مرفوضة حديثا في هذه القائمة.',
	'confirmaccount-none-e'           => 'لا توجد حاليا أي طلبات حسابات منتهية في هذه القائمة.',
	'confirmaccount-real-q'           => 'الاسم',
	'confirmaccount-email-q'          => 'البريد الإلكتروني',
	'confirmaccount-bio-q'            => 'السيرة الشخصية',
	'confirmaccount-showopen'         => 'طلبات مفتوحة',
	'confirmaccount-showrej'          => 'طلبات مرفوضة',
	'confirmaccount-showheld'         => 'عرض قائمة الحسابات قيد الانتظار',
	'confirmaccount-showexp'          => 'طلبات مدتها انتهت',
	'confirmaccount-review'           => 'قبول/رفض',
	'confirmaccount-types'            => 'اختر طابور تأكيد حساب من الأسفل:',
	'confirmaccount-all'              => '(عرض كل الطوابير)',
	'confirmaccount-type'             => 'الطابور المختار:',
	'confirmaccount-type-0'           => 'مؤلفون سابقون',
	'confirmaccount-type-1'           => 'محررون سابقون',
	'confirmaccount-q-open'           => 'طلبات مفتوحة',
	'confirmaccount-q-held'           => 'طلبات قيد الانتظار',
	'confirmaccount-q-rej'            => 'طلبات مرفوضة حديثا',
	'confirmaccount-q-stale'          => 'طلبات منتهية',
	'confirmaccount-badid'            => 'لا يوجد طلب قيد الانتظار يوافق الرقم المعطى. ربما يكون قد تمت معالجته.',
	'confirmaccount-leg-user'         => 'حساب المستخدم',
	'confirmaccount-leg-areas'        => 'الاهتمامات الرئيسية',
	'confirmaccount-leg-person'       => 'المعلومات الشخصية',
	'confirmaccount-leg-other'        => 'معلومات أخرى',
	'confirmaccount-name'             => 'اسم المستخدم',
	'confirmaccount-real'             => 'الاسم:',
	'confirmaccount-email'            => 'البريد الإلكتروني:',
	'confirmaccount-reqtype'          => 'الموضع:',
	'confirmaccount-pos-0'            => 'مؤلف',
	'confirmaccount-pos-1'            => 'محرر',
	'confirmaccount-bio'              => 'السيرة الشخصية:',
	'confirmaccount-attach'           => 'الاستكمال/السيرة الذاتية:',
	'confirmaccount-notes'            => 'ملاحظات إضافية:',
	'confirmaccount-urls'             => 'قائمة مواقع الويب:',
	'confirmaccount-none-p'           => '(غير متوفرة)',
	'confirmaccount-confirm'          => 'استخدم الأزرار بالأسفل لقبول هذا الطلب أو رفضه.',
	'confirmaccount-econf'            => '(تم تأكيده)',
	'confirmaccount-reject'           => '(تم رفضه بواسطته [[User:$1|$1]] في $2)',
	'confirmaccount-rational'         => 'السبب المعطى للمتقدم:',
	'confirmaccount-noreason'         => '(لا شيء)',
	'confirmaccount-autorej'          => '(ألغي هذا الطلّب آليا بسبب الخمول)',
	'confirmaccount-held'             => '(تم التعليم "قيد الانتظار" بواسطة [[User:$1|$1]] في $2)',
	'confirmaccount-create'           => 'قبول (إنشاب الحساب)',
	'confirmaccount-deny'             => 'رفض (إزالة من القائمة)',
	'confirmaccount-hold'             => 'انتظر',
	'confirmaccount-spam'             => 'سبام (لا ترسل البريد الإلكتروني)',
	'confirmaccount-reason'           => 'تعليق (سيضم في البريد الإلكتروني):',
	'confirmaccount-ip'               => 'عنوان الأيبي:',
	'confirmaccount-submit'           => 'تأكيد',
	'confirmaccount-needreason'       => 'يجب أن تحدد سببا في صندوق التعليق بالأسفل.',
	'confirmaccount-canthold'         => 'هذا الطلب بالفعل إما قيد الانتظار أو محذوف.',
	'confirmaccount-acc'              => 'طلب الحساب تم تأكيده بنجاح؛ أنشأ حسابا جديدا [[User:$1]].',
	'confirmaccount-rej'              => 'طلب الحساب تم رفضه بنجاح.',
	'confirmaccount-viewing'          => '(حاليا يتم مراجعته بواسطة [[User:$1|$1]])',
	'confirmaccount-summary'          => 'إنشاء صفحة المستخدم مع سيرة المستخدم الجديد.',
	'confirmaccount-welc'             => "'''مرحبا إلى ''{{SITENAME}}''!''' نأمل أن تساهم كثيرا وجيدا. 
	على الأرجح ستريد قراءة [[{{MediaWiki:Helppage}}|البداية]]. مجددا، مرحبا واستمتع!",
	'confirmaccount-wsum'             => 'مرحبا!',
	'confirmaccount-email-subj'       => '{{SITENAME}} طلب حساب',
	'confirmaccount-email-body'       => 'طلبك لحساب تمت الموافقة عليه في {{SITENAME}}.

اسم الحساب: $1

كلمة السر: $2

لمتطلبات السرية ستضطر إلى تغيير كلمة السر الخاصة بك عند أول دخول. للدخول، من فضلك اذهب إلى 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'طلبك لحساب تمت الموافقة عليه في {{SITENAME}}.

اسم الحساب: $1

كلمة السر: $2

$3

لمتطلبات السرية ستضطر إلى تغيير كلمة السر الخاصة بك عند أول دخول. للدخول، من فضلك اذهب إلى 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'عذرا, طلبك لحساب "$1" تم رفضه في {{SITENAME}}.

هناك عدة طرق لحدوث هذا. ربما تكون لم تملأ الاستمارة بشكل صحيح، أو لم توفر الطول اللازم في ردودك، أو فشلت في موافاة بعد بنود السياسة. ربما تكون هناك قوائم اتصال على الموقع يمكنك استخدامها لو كنت تريد معرفة المزيد حول سياسة حساب المستخدم.',
	'confirmaccount-email-body4'      => 'عذرا، طلبك لحساب "$1" تم رفضه في {{SITENAME}}.

$2

ربما تكون هناك قوائم اتصال على الموقع يمكنك استخدامها لو كنت تريد معرفة المزيد حول سياسة حساب المستخدم.',
	'confirmaccount-email-body5'      => 'قبل أن يتم قبول طلبك للحساب "$1" في {{SITENAME}} 
	يجب أن توفر أولا بعض المعلومات الإضافية.

$2

ربما تكون هناك قوائم اتصال في الموقع يمكنك استخدامها لو أردت أن تعرف المزيد حول سياسة حساب المستخدم.',
	'usercredentials'                 => 'مؤهلات المستخدم',
	'usercredentials-leg'             => 'ابحث عن المؤهلات المؤكدة لمستخدم',
	'usercredentials-user'            => 'اسم المستخدم:',
	'usercredentials-text'            => 'بالأسفل المؤهلات المؤكدة لحساب المستخدم المختار.',
	'usercredentials-leg-user'        => 'حساب المستخدم',
	'usercredentials-leg-areas'       => 'الاهتمامات الرئيسية',
	'usercredentials-leg-person'      => 'المعلومات الشخصية',
	'usercredentials-leg-other'       => 'معلومات أخرى',
	'usercredentials-email'           => 'البريد الإلكتروني:',
	'usercredentials-real'            => 'الاسم الحقيقي:',
	'usercredentials-bio'             => 'السيرة الشخصية:',
	'usercredentials-attach'          => 'استكمال/سيرة شخصية:',
	'usercredentials-notes'           => 'ملاحظات إضافية:',
	'usercredentials-urls'            => 'قائمة مواقع الويب:',
	'usercredentials-ip'              => 'عنوان الأيبي الأصلي:',
	'usercredentials-member'          => 'الصلاحيات:',
	'usercredentials-badid'           => 'لا مؤهلات تم العثور عليها لهذا المستخدم. تأكد من أن الاسم مكتوب بطريقة صحيحة.',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'requestaccount-real'   => 'Totoong pangaran:',
	'requestaccount-same'   => '(pareho sa  totoong pangaran)',
	'confirmaccount-real'   => 'Pangaran',
	'confirmaccount-submit' => 'Kompermaron',
	'confirmaccount-wsum'   => 'Dagos!',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'requestaccount'                  => 'Заявка за сметка',
	'requestaccount-text'             => "'''За заявяване на потребителска сметка е необходимо да се попълни и изпрати следният формуляр'''.

Преди да бъде направена заявка е необходимо да се уверите, че сте прочели страницата [[{{MediaWiki:Requestaccount-page}}|Условия за ползване]].

След като сметката бъде одобрена, ще получите оповестяващо съобщение на посочената електронна поща, че сметката може да бъде използвана за влизане чрез [[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:Условия за ползване',
	'requestaccount-dup'              => "'''Забележка: Вече сте влезли с регистрирана потребителска сметка.'''",
	'requestaccount-leg-user'         => 'Потребителска сметка',
	'requestaccount-leg-areas'        => 'Основни интереси',
	'requestaccount-leg-person'       => 'Лична информация',
	'requestaccount-leg-other'        => 'Друга информация',
	'requestaccount-acc-text'         => 'След като заявката бъде обработена, на посочения адрес за електронна поща ще бъде изпратено съобщение за потвърждние. Необходимо е да се последва включената в него препратка. След създаване на потребителската сметка, на същия адрес ще бъде изпратена и временна парола за влизане.',
	'requestaccount-areas-text'       => 'Сред тематичните области по-долу изберете тези, в които имате компетенции или желание да допринасяте най-много.',
	'requestaccount-ext-text'         => 'Следната информация се счита за поверителна и не се публикува; тя ще бъде използвана само за тази заявка.
Препоръчително е да посочите контакти, напр. телефонен номер или друга информация, която ще помогне удостоверяване на самоличността.',
	'requestaccount-bio-text'         => 'Въведената биография ще бъде съхранена като основно съдържание на потребителската ви страница.
Желателно е да включите препоръки.
Уверете се, че публикуването на такава информация не ви притеснява.
Можете да промените името си по-късно чрез [[Special:Preferences]].',
	'requestaccount-real'             => 'Име и фамилия:',
	'requestaccount-same'             => '(съвпада с името)',
	'requestaccount-email'            => 'Електронна поща:',
	'requestaccount-reqtype'          => 'Позиция:',
	'requestaccount-level-0'          => 'автор',
	'requestaccount-level-1'          => 'редактор',
	'requestaccount-bio'              => 'Лична биография:',
	'requestaccount-attach'           => 'Резюме или автобиография (по избор):',
	'requestaccount-notes'            => 'Допълнителни бележки:',
	'requestaccount-urls'             => 'Списък от уебсайтове (ако има такива, по един на ред):',
	'requestaccount-agree'            => 'Моля, потвърдете, че истинското ви име е изписано правилно и сте съгласни с Условията за ползване.',
	'requestaccount-inuse'            => 'За това потребителско име вече чака заявка за създаване на сметка.',
	'requestaccount-tooshort'         => 'Необходимо е биографията да съдържа поне $1 думи.',
	'requestaccount-emaildup'         => 'Посоченият адрес за електронна поща е използвам при друга изчакваща заявка за потребителска сметка.',
	'requestaccount-exts'             => 'Не е разрешено прикачането на файлове с този формат.',
	'requestaccount-tos'              => 'Декларирам, че прочетох и се съгласявам с [[{{MediaWiki:Requestaccount-page}}|Условията за ползване]] на {{SITENAME}}.
Името, което попълних във формуляра, е моето истинско име и фамилия.',
	'requestaccount-submit'           => 'Изпращане на заявката',
	'requestaccount-sent'             => 'Вашата заявка за потребителска сметка е изпратена успешно и чака да бъде разгледана.',
	'request-account-econf'           => 'Адресът на електронната ви поща беше потвърден и ще бъде отбелязан като такъв в заявката ви за потребителска сметка.',
	'requestaccount-email-subj'       => '{{SITENAME}}: Потвърждение на адрес за е-поща',
	'requestaccount-email-body'       => 'Някой, вероятно вие, от IP-адрес $1, е изпратил заявка за потребителска сметка „$2“ в {{SITENAME}}, като е посочил този адрес за електронна поща.

За да потвърдите, че сметката в {{SITENAME}} и настоящият пощенски адрес са ваши, заредете долната препратка в браузъра си:

$3

Ако заявката ви бъде одобрена и сметката - създадена, ще получите парола по електронна поща. Ако заявката е била направена от някой друг, не следвайте тази препратка. Кодът за потвърждение ще загуби валидност след $4.',
	'requestaccount-email-subj-admin' => 'Заявка за сметка в {{SITENAME}}',
	'requestaccount-email-body-admin' => '„$1“ отправи заявка за създаване на потребителска сметка, която очаква потвърждение.
Посоченият адрес за електронна поща беше потвърден. Можете да потвърдите заявката тук „$2“.',
	'acct_request_throttle_hit'       => 'Вече сте направили $1 заявки за потребителски сметки. Не можете да правите повече заявки.',
	'requestaccount-loginnotice'      => "За да получите потребителска сметка, необходимо е да '''[[Special:RequestAccount|изпратите заявка]]'''.",
	'confirmaccounts'                 => 'Одобряване на заявките за потребителски сметки',
	'confirmedit-desc'                => 'Предоставя на бюрократите възможността да потвърждават заявките за регистрация на потребителски сметки.',
	'confirmaccount-list'             => 'Следва списък от заявките за потребителски сметки, които очакват одобрение.
Одобрените сметки ще бъдат създадени и премахнати от списъка. Отхвърлените сметки просто ще бъдат премахнати.',
	'confirmaccount-list2'            => 'Следва списък от наскоро отхвърлените заявки за сметки, които могат да бъдат автоматично изтрити след изтичане на няколко дни от отказа. Заявка от този списък все още може да бъде одобрена, но е желателно преди това да се посъветвате с администратора, който я е отхвърлил.',
	'confirmaccount-none-o'           => 'В момента списъкът не съдържа отворени изчакващи заявки за сметки.',
	'confirmaccount-none-h'           => 'В момента списъкът не съдържа задържани изчакващи заявки за сметки.',
	'confirmaccount-none-r'           => 'Понастоящем в списъка няма наскоро отхвърлени заявки за сметки.',
	'confirmaccount-none-e'           => 'В момента списъкът не съдържа изтекли заявки за сметки.',
	'confirmaccount-real-q'           => 'Име',
	'confirmaccount-email-q'          => 'Електронна поща',
	'confirmaccount-bio-q'            => 'Биография',
	'confirmaccount-showopen'         => 'отворени заявки',
	'confirmaccount-showrej'          => 'отказани заявки',
	'confirmaccount-showheld'         => 'Преглед на списъка със задържани сметки',
	'confirmaccount-showexp'          => 'изтекли заявки',
	'confirmaccount-review'           => 'Преглеждане',
	'confirmaccount-all'              => '(показване на всички опашки)',
	'confirmaccount-type'             => 'Избрана опашка:',
	'confirmaccount-type-0'           => 'перспективни автори',
	'confirmaccount-type-1'           => 'перспективни редактори',
	'confirmaccount-q-open'           => 'отворени заявки',
	'confirmaccount-q-held'           => 'задържани заявки',
	'confirmaccount-q-rej'            => 'наскоро отхвърлени заявки',
	'confirmaccount-q-stale'          => 'изтекли заявки',
	'confirmaccount-badid'            => 'Няма чакаща заявка, съотвестваща на предоставения номер.
Възможно е вече да е била обработена.',
	'confirmaccount-leg-user'         => 'Потребителска сметка',
	'confirmaccount-leg-areas'        => 'Основни интереси',
	'confirmaccount-leg-person'       => 'Лична информация',
	'confirmaccount-leg-other'        => 'Друга информация',
	'confirmaccount-name'             => 'Потребителско име',
	'confirmaccount-real'             => 'Име:',
	'confirmaccount-email'            => 'Електронна поща:',
	'confirmaccount-reqtype'          => 'Позиция:',
	'confirmaccount-pos-0'            => 'автор',
	'confirmaccount-pos-1'            => 'редактор',
	'confirmaccount-bio'              => 'Биография:',
	'confirmaccount-attach'           => 'Резюме/Автобиография:',
	'confirmaccount-notes'            => 'Допълнителни бележки:',
	'confirmaccount-urls'             => 'Списък с уебсайтове:',
	'confirmaccount-confirm'          => 'Изберете да одобрите, отхвърлите или задържите тази заявка:',
	'confirmaccount-reject'           => '(отказана от [[Потребител:$1|$1]] на $2)',
	'confirmaccount-rational'         => 'Обосновка към кандидата:',
	'confirmaccount-noreason'         => '(няма)',
	'confirmaccount-autorej'          => '(тази заявка автоматично беше отхвърлена заради неактивност)',
	'confirmaccount-held'             => '(отбелязана "за изчакване" от [[Потребител:$1|$1]] на $2)',
	'confirmaccount-create'           => 'Приемане (създаване на сметката)',
	'confirmaccount-deny'             => 'Отказване (премахване от списъка)',
	'confirmaccount-hold'             => 'Задържане',
	'confirmaccount-spam'             => 'Спам (без изпращане на писмо)',
	'confirmaccount-reason'           => 'Коментар (ще бъде включен в електронното писмо):',
	'confirmaccount-ip'               => 'IP адрес:',
	'confirmaccount-submit'           => 'Потвърждаване',
	'confirmaccount-needreason'       => 'Необходимо е да се посочи причина в полето по-долу.',
	'confirmaccount-canthold'         => 'Тази заявка вече е била задържана или изтрита.',
	'confirmaccount-acc'              => 'Заявката за потребителска сметка е одобрена, създадена е новата сметка [[User:$1]].',
	'confirmaccount-rej'              => 'Заявката за потребителска сметка е отхвърлена.',
	'confirmaccount-viewing'          => '(в момента се преглежда от [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Създаване на потребителска страница с биографията на новия потребител.',
	'confirmaccount-wsum'             => 'Здравейте!',
	'confirmaccount-email-subj'       => 'Заявка за сметка в {{SITENAME}}',
	'confirmaccount-email-body'       => 'Вашата заявка за потребителска сметка на {{SITENAME}} е одобрена.

Потребителско име: $1

Парола: $2

От съображения за сигурност, при първото си влизане в системата трябва да промените паролата си. За влизане в системата, използвайте {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Заявката за създаване на потребителска сметка в {{SITENAME}} беше одобрена.

Потребителско име: $1

Парола: $2

$3

От съображения за сигурност е препоръчително паролата да бъде сменена след първото влизане. За влизане използвайте следната препратка - {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Заявката за създаване на потребителска сметка „$1“ в {{SITENAME}} беше отказана.

Съществуват няколко възможни причини за това. Възможно е формулярът да не е бил попълнен коректно, полетата да не съдържат изчерпателна информация или въведените данни да са в конфликт с някое от правилата и политиката на сайта. На сайта има повече информация за политиката за създаване на потребителски сметки.',
	'confirmaccount-email-body4'      => 'Заявката за създаване на потребителска сметка „$1“ в {{SITENAME}} не беше одобрена.

$2

На сайта може да бъде намерена повече информация за политиката за създаване на потребителски сметки.',
	'confirmaccount-email-body5'      => 'Преди заявката за създаване на потребителска сметка "$1" в {{SITENAME}} да бъде приета е необходимо да се предостави още допълнителна информация.

$2

На сайта може да бъде намерена повече информация за политиката за създаване на потребителски сметки.',
	'usercredentials'                 => 'Препоръки за потребители',
	'usercredentials-leg'             => 'Преглед на потвърдените препоръки за потребител',
	'usercredentials-user'            => 'Потребителско име:',
	'usercredentials-leg-user'        => 'Потребителска сметка',
	'usercredentials-leg-areas'       => 'Основни интереси',
	'usercredentials-leg-person'      => 'Лична информация',
	'usercredentials-leg-other'       => 'Друга информация',
	'usercredentials-email'           => 'Електронна поща:',
	'usercredentials-real'            => 'Име и фамилия:',
	'usercredentials-bio'             => 'Биография:',
	'usercredentials-attach'          => 'Резюме/Автобиография:',
	'usercredentials-notes'           => 'Допълнителни бележки:',
	'usercredentials-urls'            => 'Списък от уебсайтове:',
	'usercredentials-ip'              => 'Оригинален IP адрес:',
	'usercredentials-member'          => 'Права:',
	'usercredentials-badid'           => 'Не са открити препоръки за този потребител. Проверете дали името е изписано правилно.',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'requestaccount-real'             => 'প্রকৃত নাম:',
	'requestaccount-same'             => '(প্রকৃত নামের মত)',
	'requestaccount-email'            => 'ইমেইল ঠিকানা:',
	'requestaccount-reqtype'          => 'পদ:',
	'requestaccount-level-0'          => 'লেখক',
	'requestaccount-level-1'          => 'সম্পাদক',
	'requestaccount-bio'              => 'ব্যক্তিগত জীবনী:',
	'requestaccount-attach'           => 'রেজুমে বা সিভি (আবশ্যকীয় নয়):',
	'requestaccount-notes'            => 'অতিরিক্ত মন্তব্য:',
	'requestaccount-urls'             => 'ওয়েবসাইটের তালিকা, যদি থাকে (নতুন লাইন দিয়ে পৃথক করুন):',
	'requestaccount-agree'            => 'আপনি যে প্রকৃত নাম ব্যবহার করেছেন এবং আমাদের সেবার শর্তের সাথে একমত হয়েছেন, তা নিশ্চিত করতে হবে।',
	'requestaccount-inuse'            => 'এই ব্যবহারকারী নামটি ইতিমধ্যেই একটি অপেক্ষারত অ্যাকাউন্ট অনুরোধে ব্যবহৃত হচ্ছে।',
	'requestaccount-tooshort'         => 'আপনার জীবনী কমপক্ষে $1 শব্দ দীর্ঘ হতে হবে।',
	'requestaccount-emaildup'         => 'আরেকটি অপেক্ষারত অ্যাকাউন্ট অনুরোধে একই ইমেইল ঠিকানা ব্যবহার করা হয়েছে।',
	'requestaccount-exts'             => 'সংযুক্ত ফাইলের ধরন অনুমোদিত নয়।',
	'requestaccount-submit'           => 'অ্যাকাউন্ট অনুরোধ করুন',
	'requestaccount-email-subj-admin' => '{{SITENAME}}-এ অ্যাকাউন্ট অনুরোধ',
	'confirmaccount-real-q'           => 'নাম',
	'confirmaccount-email-q'          => 'ইমেইল',
	'confirmaccount-bio-q'            => 'জীবনী',
	'confirmaccount-name'             => 'ব্যবহারকারী নাম',
	'confirmaccount-real'             => 'নাম:',
	'confirmaccount-email'            => 'ইমেইল:',
	'confirmaccount-reqtype'          => 'পদ:',
	'confirmaccount-pos-0'            => 'লেখক',
	'confirmaccount-pos-1'            => 'সম্পাদক',
	'confirmaccount-bio'              => 'জীবনী:',
	'confirmaccount-attach'           => 'রেজুমে/সিভি:',
	'confirmaccount-notes'            => 'অতিরিক্ত মন্তব্য:',
	'confirmaccount-urls'             => 'ওয়েবসাইটের তালিকা:',
	'confirmaccount-none-p'           => '(দেয়া হয়নি)',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'requestaccount-email'   => "Chomlec'h postel :",
	'requestaccount-level-0' => 'aozer',
	'requestaccount-level-1' => 'skridaozer',
	'confirmaccount-real-q'  => 'Anv',
	'confirmaccount-email-q' => 'Postel',
	'confirmaccount-bio-q'   => 'Levrlennadur',
	'confirmaccount-name'    => 'Anv implijer',
	'confirmaccount-real'    => 'Anv :',
	'confirmaccount-email'   => 'Postel :',
	'confirmaccount-pos-1'   => 'skridaozer',
	'confirmaccount-wsum'    => 'Degemer mat !',
	'usercredentials-email'  => 'Postel :',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'confirmaccount-noreason' => '(cap)',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Siebrand
 */
$messages['cs'] = array(
	'requestaccount'             => 'Vyžádat účet',
	'requestaccount-page'        => '{{ns:project}}:Podmínky použití',
	'requestaccount-dup'         => "'''Poznámka: Už jste přihlášen jako registrovaný uživatel.'''",
	'requestaccount-leg-user'    => 'Uživatelský účet',
	'requestaccount-leg-areas'   => 'Hlavní oblasti zájmu',
	'requestaccount-leg-person'  => 'Osobní informace',
	'requestaccount-leg-other'   => 'Další informace',
	'requestaccount-acc-text'    => 'Na Vaši e-mailovou adresu bude po odeslání žádosti zaslána potvrzující zpráva. Prosím, reagujte na ni kliknutím na odkaz v ní. Poté Vám bude zasláno Vaše heslo.',
	'requestaccount-areas-text'  => 'Níže zvolte tématické oblasti, ve kterých jste formálně expertem nebo by jste v nich rádi vykonávali vaši práci.',
	'requestaccount-bio-text'    => 'Vaše bibliografie bude prvotním obsahem vaši uživatelské stránky. Pokuste se uvést všechny reference. Zvažte, zda jste ochotni zveřejnit tyto informace. Vaše jméno je možné změnit pomocí [[Special:Preferences]].',
	'requestaccount-real'        => 'Skutečné jméno:',
	'requestaccount-same'        => '(stejné jako skutečné jméno)',
	'requestaccount-email'       => 'E-mailová adresa:',
	'requestaccount-reqtype'     => 'Pozice:',
	'requestaccount-level-0'     => 'autor',
	'requestaccount-level-1'     => 'editor',
	'requestaccount-bio'         => 'Osobní biografie:',
	'requestaccount-attach'      => 'Resumé nebo CV (nepovinné):',
	'requestaccount-notes'       => 'Další poznámky:',
	'requestaccount-urls'        => 'Seznam webových stránek, pokud nějaké jsou (jedna na každý řádek):',
	'requestaccount-agree'       => 'Musíte potvrdit, že vaše skutečné jméno je správné a že souhlasíte s našimi Podmínkami použití.',
	'requestaccount-inuse'       => 'Uživatelské jméno už bylo vyžádané v probíhající žádosti o účet.',
	'requestaccount-tooshort'    => 'Vaše bibliografie musí mít alespoň $1 {{PLURAL:$1|slovo|slova|slov}}.',
	'requestaccount-emaildup'    => 'Jiný účet čekající na schválení používá stejnou e-mailovou adresu.',
	'requestaccount-exts'        => 'Tento typ přílohy není povolen.',
	'requestaccount-resub'       => 'Váš soubor s CV/resumé je potřeba z bezpečnostních důvodů znovu vybrat. Nechejte pole prázdné, pokud jste se rozhodli žádný nepřiložit.',
	'requestaccount-tos'         => 'Přečetl jsem a souhlasím, že budu dodržovat [[{{MediaWiki:Requestaccount-page}}|Podmínky používání služby]] {{GRAMMAR:genitiv|{{SITENAME}}}}. Jméno, které jsem uvedl jako „Skutečné jméno“ je opravdu moje občanské jméno.',
	'requestaccount-submit'      => 'Požádat o účet',
	'requestaccount-sent'        => 'Vaše žádost o účet byla úspěšně odeslána a nyní se čeká na její zkontrolování.',
	'request-account-econf'      => 'Vaše e-mailová adresa byla potvrzena a v tomto tvaru se uvede ve vaší žádosti o účet.',
	'requestaccount-email-subj'  => '{{SITENAME}}: Potvrzení e-mailové adresy',
	'requestaccount-email-body'  => 'Někdo, pravděpodobně Vy z IP adresy $1, si na {{GRAMMAR:lokál|{{SITENAME}}}} zaregistroval účet s názvem „$2“ a s touto e-mailovou adresou.

Pro potvrzení, že tento účet skutečně patří Vám a pro aktivování e-mailových funkcí na {{GRAMMAR:lokál|{{SITENAME}}}}, klikněte na tento odkaz:

$3

Pokud jste to *nebyli* Vy, neklikejte na odkaz. Tento potvrzovací kód vyprší $4.',
	'confirmaccounts'            => 'Potvrdit žádosti o účet',
	'confirmedit-desc'           => 'Dává byrokratům možnost potvrzovat žádosti o účet',
	'confirmaccount-real-q'      => 'Jméno',
	'confirmaccount-email-q'     => 'E-mail',
	'confirmaccount-bio-q'       => 'Biografie',
	'confirmaccount-showheld'    => 'Zobrazit seznam účtů čekajících na schválení',
	'confirmaccount-review'      => 'Schválit/Odmítnout',
	'confirmaccount-all'         => '(zobrazit všechny fronty)',
	'confirmaccount-type'        => 'Zvolená fronta:',
	'confirmaccount-type-0'      => 'budoucí autoři',
	'confirmaccount-type-1'      => 'budoucí editoři',
	'confirmaccount-q-open'      => 'otevřené žádosti',
	'confirmaccount-q-held'      => 'pozastavené žádosti',
	'confirmaccount-q-rej'       => 'nedávno zamítnuté žádosti',
	'confirmaccount-leg-user'    => 'Uživatelský účet',
	'confirmaccount-leg-areas'   => 'Hlavní oblasti zájmu',
	'confirmaccount-leg-person'  => 'Osobní informace',
	'confirmaccount-leg-other'   => 'Další informace',
	'confirmaccount-name'        => 'Uživatelské jméno',
	'confirmaccount-real'        => 'Jméno:',
	'confirmaccount-email'       => 'E-mail:',
	'confirmaccount-reqtype'     => 'Pozice:',
	'confirmaccount-pos-0'       => 'autor',
	'confirmaccount-pos-1'       => 'editor',
	'confirmaccount-bio'         => 'Biografie:',
	'confirmaccount-notes'       => 'Další poznámky:',
	'confirmaccount-urls'        => 'Seznam webových stránek:',
	'confirmaccount-none-p'      => '(neposkytnuté)',
	'confirmaccount-confirm'     => 'Tlačítky níže můžete přijmout nebo odmítnout tuto žádost.',
	'confirmaccount-econf'       => '(potvrzený)',
	'confirmaccount-reject'      => '(zamítnul [[User:$1|$1]] $2)',
	'confirmaccount-rational'    => 'Zdůvodnění pro uchazeče:',
	'confirmaccount-noreason'    => '(žádné)',
	'confirmaccount-held'        => '(uživatel [[User:$1|$1]] $2 označil jako „pozastavené“)',
	'confirmaccount-create'      => 'Přijmout (vytvořit účet)',
	'confirmaccount-deny'        => 'Odmítnout (odstranit žádost)',
	'confirmaccount-hold'        => 'Pozastavit',
	'confirmaccount-spam'        => 'Spam (neposílat e-mail)',
	'confirmaccount-reason'      => 'Komentář (bude součástí e-mailu):',
	'confirmaccount-ip'          => 'IP adresa:',
	'confirmaccount-submit'      => 'Potvrdit',
	'confirmaccount-wsum'        => 'Vítejte!',
	'usercredentials'            => 'Osobní údaje uživatele',
	'usercredentials-user'       => 'Uživatelské jméno:',
	'usercredentials-leg-user'   => 'Uživatelský účet',
	'usercredentials-leg-areas'  => 'Hlavní oblasti zájmu',
	'usercredentials-leg-person' => 'Osobní informace',
	'usercredentials-leg-other'  => 'Další informace',
	'usercredentials-email'      => 'E-mail:',
	'usercredentials-real'       => 'Skutečné jméno:',
	'usercredentials-bio'        => 'Biografie:',
	'usercredentials-notes'      => 'Další poznámky:',
	'usercredentials-urls'       => 'Seznam webových stránek:',
	'usercredentials-ip'         => 'Původní IP adresa:',
	'usercredentials-member'     => 'Práva:',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'requestaccount-level-0' => 'творь́ць',
	'confirmaccount-pos-0'   => 'творь́ць',
	'usercredentials-user'   => 'по́льꙃєватєлꙗ и́мѧ :',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 * @author M.M.S.
 */
$messages['da'] = array(
	'requestaccount-real'     => 'Virkeligt navn:',
	'confirmaccount-real-q'   => 'Navn',
	'confirmaccount-email-q'  => 'E-mail',
	'confirmaccount-name'     => 'Brugernavn',
	'confirmaccount-real'     => 'Navn:',
	'confirmaccount-email'    => 'E-mail:',
	'confirmaccount-noreason' => '(ingen)',
	'confirmaccount-ip'       => 'IP-adresse:',
	'confirmaccount-submit'   => 'Bekræft',
	'confirmaccount-wsum'     => 'Velkommen!',
	'usercredentials-user'    => 'Brugernavn:',
	'usercredentials-email'   => 'E-mail:',
	'usercredentials-real'    => 'Virkeligt navn:',
);

/** German (Deutsch)
 * @author Rrosenfeld
 * @author MF-Warburg
 * @author Raimond Spekking
 * @author Siebrand
 */
$messages['de'] = array(
	'requestaccount'                  => 'Benutzerkonto beantragen',
	'requestaccount-text'             => "'''Fülle das folgende Formular aus und schick es ab, um ein Benutzerkonto zu beantragen'''. 

Bitte lies zunächst die [[{{MediaWiki:Requestaccount-page}}|Nutzungsbedingungen]], bevor du ein Benutzerkonto beantragst.

Sobald das Konto bestätigt wurde, wirst du per E-Mail benachrichtigt und du kannst dich unter „[[Special:Userlogin|Anmelden]]“ einloggen.",
	'requestaccount-page'             => '{{ns:project}}:Nutzungsbedingungen',
	'requestaccount-dup'              => "'''Achtung: Du bist bereits mit einem registrierten Benutzerkonto eingeloggt.'''",
	'requestaccount-leg-user'         => 'Benutzerkonto',
	'requestaccount-leg-areas'        => 'Hauptinteressensgebiete',
	'requestaccount-leg-person'       => 'Persönliche Informationen',
	'requestaccount-leg-other'        => 'Weitere Informationen',
	'requestaccount-acc-text'         => 'An deine E-Mail-Adresse wird nach dem Absenden dieses Formulars eine Bestätigungsmail geschickt. 
	Bitte reagiere darauf, indem du auf den in dieser Mail enthaltenen Bestätigungs-Link klickst. Sobald dein Konto angelegt wurde,
	wird dir dein Passwort per E-Mail zugeschickt.',
	'requestaccount-areas-text'       => 'Wähle die Themengebiete aus, in denen du das meiste Fachwissen hast oder wo du am meisten involviert sein wirst.',
	'requestaccount-ext-text'         => 'Die folgenden Informationen werden vertraulich behandelt und ausschließlich für diesen Antrag
	verwendet. Du kannst Kontakt-Angaben wie eine Telefonnummer machen, um die Bearbeitung deines Antrags zu vereinfachen.',
	'requestaccount-bio-text'         => 'Deine Biographie wird als initialer Inhalt deiner Benutzerseite gespeichert.
Versuche alle nötigen Empfehlungen zu erwähnen, aber stelle sicher, dass du die Informationen auch wirklich veröffentlichen möchtest.
Du kannst deinen Namen unter „[[Special:Preferences|Einstellungen]]“ ändern.',
	'requestaccount-real'             => 'Realname:',
	'requestaccount-same'             => '(wie der Realname)',
	'requestaccount-email'            => 'E-Mail-Adresse:',
	'requestaccount-reqtype'          => 'Position:',
	'requestaccount-level-0'          => 'Autor',
	'requestaccount-level-1'          => 'Bearbeiter',
	'requestaccount-bio'              => 'Persönliche Biographie:',
	'requestaccount-attach'           => 'Lebenslauf (optional):',
	'requestaccount-notes'            => 'Zusätzliche Angaben:',
	'requestaccount-urls'             => 'Liste von Webseiten (durch Zeilenumbrüche getrennt):',
	'requestaccount-agree'            => 'Du musst bestätigen, dass Dein Realname korrekt ist und du die Benutzerbedingungen akzeptierst.',
	'requestaccount-inuse'            => 'Der Benutzername ist bereits in einem anderen Benutzerantrag in Verwendung.',
	'requestaccount-tooshort'         => 'Deine Biographie sollte mindestens $1 Worte lang sein.',
	'requestaccount-emaildup'         => 'Ein weiterer noch nicht erledigter Antrag benutzt die gleiche E-Mail-Adresse.',
	'requestaccount-exts'             => 'Der Dateityp des Anhangs ist nicht erlaubt.',
	'requestaccount-resub'            => 'Die Datei mit deinem Lebenslauf muss aus Sicherheitsgründen neu ausgewählt werden.
	Lasse das Feld leer, wenn du keinen Lebenslauf mehr anfügen möchtest.',
	'requestaccount-tos'              => 'Ich habe die [[{{MediaWiki:Requestaccount-page}}|Benutzungsbedingungen]] von {{SITENAME}} gelesen und akzeptiere sie.
	Ich bestätige, dass der Name, den ich unter „Realname“ angegeben habe, mein wirklicher Name ist.',
	'requestaccount-submit'           => 'Benutzerkonto beantragen',
	'requestaccount-sent'             => 'Dein Antrag wurde erfolgreich verschickt und muss nun noch überprüft werden.',
	'request-account-econf'           => 'Deine E-Mail-Adresse wurde bestätigt und wird nun als solche in Deinem Account-Antrag geführt.',
	'requestaccount-email-subj'       => '{{SITENAME}} E-Mail-Adressen Prüfung',
	'requestaccount-email-body'       => 'Jemand, mit der IP Adresse $1, möglicherweise du, hat bei {{SITENAME}} 
das Benutzerkonto "$2" mit deiner E-Mail-Adresse beantragt.

Um zu bestätigen, dass wirklich du dieses Konto bei {{SITENAME}}
beantragt hast, öffne bitte folgenden Link in deinem Browser:

$3

Wenn das Benutzerkonto erstellt wurde, bekommst du eine weitere E-Mail
mit dem Passwort.

Wenn du das Benutzerkonto *nicht* beantragt hast, öffne den Link bitte nicht!

Dieser Bestätigungscode wird um $4 ungültig.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} Benutzerkontenantrag',
	'requestaccount-email-body-admin' => '"$1" hat ein Benutzerkonto beantragt und wartet auf Bestätigung.
Die E-Mail-Adresse wurde bestätigt. Du kannst den Antrag hier bestätigen: "$2".',
	'acct_request_throttle_hit'       => 'Du hast bereits $1 Benutzerkonten beantragt, du kannst momentan keine weiteren beantragen.',
	'requestaccount-loginnotice'      => "Um ein neues Benutzerkonto zu erhalten, musst du es '''[[Special:RequestAccount|beantragen]]'''.",
	'confirmaccount-newrequests'      => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|offener, E-Mail bestätigter Benutzerkontenantrag]]|[[Special:ConfirmAccounts|offene, E-Mail bestätigte Benutzerkontenanträge]]}} warten auf Bearbeitung.",
	'confirmaccounts'                 => 'Benutzerkonto-Anträge bestätigen',
	'confirmedit-desc'                => 'Gibt Bürokraten die Möglichkeit, Benutzerkontenanträge zu bestätigen',
	'confirmaccount-maintext'         => "'''Diese Seite dient dazu, wartende Benutzerkontenanträge für ''{{SITENAME}}''''' zu bearbeiten.

	Jede Benutzerkonten-Antragsqueue besteht aus drei Unterqueues. Eine für offene Anfrage, eine für Anträge im „abwarten“-Status und eine für kürzlich abgelehnte Anfragen.

	Wenn du auf einen Antrag antwortest, überprüfe die Informationen sorgfältig und bestätige die enthaltenen Informationen.
	Deine Aktionen werden nichtöffentlich protokolloert. Es wird auch von dir erwartet, die Aktionen anderer zu überprüfen.",
	'confirmaccount-list'             => 'Unten findest du eine Liste von noch zu bearbeitenden Benutzerkonto-Anträgen.
	Sobald ein Antrag bestätigt oder zurückgewiesen wurde, wird er aus der Liste entfernt.',
	'confirmaccount-list2'            => 'Unten ist eine Liste kürzlich zurückgewiesener Anträge, die automatisch gelöscht werden, sobald sie einige Tage alt sind. Sie können noch genehmigt werden, allerdings solltest du zuerst den ablehnenden Administrator kontaktieren.',
	'confirmaccount-list3'            => 'Unten ist eine Liste kürzlich zurückgewiesener Anträge, die automatisch gelöscht werden, sobald sie einige Tage alt sind. Sie können noch genehmigt werden.',
	'confirmaccount-text'             => "Dies ist ein Antrag auf ein Benutzerkonto bei '''{{SITENAME}}'''. Prüfe alle unten
	stehenden Informationen gründlich und bestätige die Informationen wenn möglich. Bitte beachte, dass du den Zugang bei Bedarf unter
	einem anderen Benutzernamen anlegen kannst. Du solltest dies nur nutzen, um Kollisionen mit anderen Namen zu vermeiden.

	Wenn du diese Seite verlässt, ohne das Konto zu bestätigen oder abzulehnen, wird der Antrag offen stehen bleiben.",
	'confirmaccount-none-o'           => 'Momentan gibt es keine offenen Benutzeranträge auf dieser Liste.',
	'confirmaccount-none-h'           => 'Momentan gibt es keine Anträge im „abwarten“-Status auf dieser Liste.',
	'confirmaccount-none-r'           => 'Momentan gibt es keine kürzlich abgelehnten Benutzeranträge auf dieser Liste.',
	'confirmaccount-none-e'           => 'Momentan gibt es keine abgelaufenen Benutzeranträge auf dieser Liste.',
	'confirmaccount-email-q'          => 'E-Mail',
	'confirmaccount-bio-q'            => 'Biographie',
	'confirmaccount-showopen'         => 'offene Anträge',
	'confirmaccount-showrej'          => 'zurückgewiesene Anträge',
	'confirmaccount-showheld'         => 'Anträge im „abwarten“-Status',
	'confirmaccount-showexp'          => 'abgelaufene Anträge',
	'confirmaccount-review'           => 'Bestätigen/Ablehnen',
	'confirmaccount-types'            => 'Wähle eine Benutzerkontenbestätigungswarteschlange aus den unten stehenden aus:',
	'confirmaccount-all'              => '(zeige alle Warteschlangen)',
	'confirmaccount-type'             => 'Warteschlange:',
	'confirmaccount-type-0'           => 'zukünftige Autoren',
	'confirmaccount-type-1'           => 'zukünftige Bearbeiter',
	'confirmaccount-q-open'           => 'offene Anträge',
	'confirmaccount-q-held'           => 'wartende Anträge',
	'confirmaccount-q-rej'            => 'kürzlich abgelehnte Anträge',
	'confirmaccount-q-stale'          => 'abgelaufene Anträge',
	'confirmaccount-badid'            => 'Momentan gibt es keinen Benutzerantrag zur angegebenen ID. Möglicherweise wurde er bereits bearbeitet.',
	'confirmaccount-leg-user'         => 'Benutzerkonto',
	'confirmaccount-leg-areas'        => 'Hauptinteressensgebiete',
	'confirmaccount-leg-person'       => 'Persönliche Informationen',
	'confirmaccount-leg-other'        => 'Weitere Informationen',
	'confirmaccount-name'             => 'Benutzername',
	'confirmaccount-email'            => 'E-Mail:',
	'confirmaccount-reqtype'          => 'Position:',
	'confirmaccount-pos-0'            => 'Autor',
	'confirmaccount-pos-1'            => 'Bearbeiter',
	'confirmaccount-bio'              => 'Biographie:',
	'confirmaccount-attach'           => 'Lebenslauf:',
	'confirmaccount-notes'            => 'Zusätzliche Hinweise:',
	'confirmaccount-urls'             => 'Liste der Webseiten:',
	'confirmaccount-none-p'           => '(Nichts angegeben)',
	'confirmaccount-confirm'          => 'Benutze die folgende Auswahl, um den Antrag zu akzeptieren, abzulehnen oder noch zu warten.',
	'confirmaccount-econf'            => '(bestätigt)',
	'confirmaccount-reject'           => '(abgelehnt durch [[User:$1|$1]] am $2)',
	'confirmaccount-rational'         => 'Begründung für den Antragssteller:',
	'confirmaccount-noreason'         => '(nichts)',
	'confirmaccount-autorej'          => '(dieser Antrag wurde automatisch wegen Inaktivität gestrichen)',
	'confirmaccount-held'             => '(markiert als „abwarten“ durch [[User:$1|$1]] am $2)',
	'confirmaccount-create'           => 'Bestätigen (Konto anlegen)',
	'confirmaccount-deny'             => 'Ablehnen (Antrag löschen)',
	'confirmaccount-hold'             => 'Markiert als „abwarten“',
	'confirmaccount-spam'             => 'Spam (keine E-Mail verschicken)',
	'confirmaccount-reason'           => 'Begründung (wird in die Mail an den Antragsteller eingefügt):',
	'confirmaccount-ip'               => 'IP-Addresse:',
	'confirmaccount-submit'           => 'Abschicken',
	'confirmaccount-needreason'       => 'Du musst eine Begründung eingeben.',
	'confirmaccount-canthold'         => 'Dieser Antrag wurde bereits als „abwarten“ markiert oder gelöscht.',
	'confirmaccount-acc'              => 'Benutzerantrag erfolgreich bestätigt; Benutzer [[User:$1]] wurde angelegt.',
	'confirmaccount-rej'              => 'Benutzerantrag wurde abgelehnt.',
	'confirmaccount-viewing'          => '(wird aktuell angeschaut durch [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Erzeuge Benutzerseite mit der Biographie des neuen Benutzers.',
	'confirmaccount-welc'             => "'''Willkommen bei ''{{SITENAME}}''!''' Wir hoffen, dass du viele gute Informationen beisteuerst.
	Möglicherweise möchtest Du zunächst die [[{{MediaWiki:Helppage}}|Ersten Schritte]] lesen. Nochmal: Willkommen und hab' Spaß!~",
	'confirmaccount-wsum'             => 'Willkommen!',
	'confirmaccount-email-subj'       => '{{SITENAME}} Antrag auf Benutzerkonto',
	'confirmaccount-email-body'       => 'Dein Antrag auf ein Benutzerkonto bei {{SITENAME}} wurde bestätigt.

Benutzername: $1

Passwort: $2

Aus Sicherheitsgründen solltest du dein Passwort unbedingt beim ersten
Einloggen ändern. Um dich einzuloggen gehst du auf die Seite
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Dein Antrag auf ein Benutzerkonto bei {{SITENAME}} wurde bestätigt.

Benutzername: $1

Passwort: $2

$3

Aus Sicherheitsgründen solltest du Dein Passwort unbedingt beim ersten
Einloggen ändern. Um dich einzuloggen gehst du auf die Seite
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Leider wurde dein Antrag auf ein Benutzerkonto „$1“ 
bei {{SITENAME}} abgelehnt.

Dies kann viele Gründe haben. Möglicherweise hast du das Antragsformular
nicht richtig ausgefüllt, hast nicht genügend Angaben gemacht oder hast
die Anforderungen auf andere Weise nicht erfüllt.

Möglicherweise gibt es auf der Seite Kontaktadressen, an die du dich wenden
kannst, wenn du mehr über die Anforderungen wissen möchtest.',
	'confirmaccount-email-body4'      => 'Leider wurde dein Antrag auf ein Benutzerkonto „$1“ 
bei {{SITENAME}} abgelehnt.

$2

Möglicherweise gibt es auf der Seite Kontaktadressen, an die du dich wenden
kannst, wenn du mehr über die Anforderungen wissen möchtest.',
	'confirmaccount-email-body5'      => 'Bevor deine Anfrage für das Benutzerkonto „$1“ von {{SITENAME}} akzeptiert werden kann, 
       musst du zusätzliche Informationen übermitteln.

$2

Möglicherweise gibt es auf der Seite Kontaktadressen, an die du dich wenden
kannst, wenn du mehr über die Anforderungen wissen möchtest.',
	'usercredentials'                 => 'Benutzer-Berechtigungsnachweis',
	'usercredentials-leg'             => 'Bestätigte Benutzer-Berechtigungsnachweise nachsehen',
	'usercredentials-user'            => 'Benutzername:',
	'usercredentials-text'            => 'Es folgen die bestätigten Benutzer-Berechtigungsnachweise für das gewählte Benutzerkonto.',
	'usercredentials-leg-user'        => 'Benutzerkonto',
	'usercredentials-leg-areas'       => 'Haupt-Interessensgebietet',
	'usercredentials-leg-person'      => 'Persönliche Informationen',
	'usercredentials-leg-other'       => 'Weitere Informationen',
	'usercredentials-email'           => 'E-Mail:',
	'usercredentials-real'            => 'Echter Name:',
	'usercredentials-bio'             => 'Biographie:',
	'usercredentials-notes'           => 'Zusätzliche Bemerkungen:',
	'usercredentials-urls'            => 'Liste der Webseiten:',
	'usercredentials-ip'              => 'Originale IP-Adresse:',
	'usercredentials-member'          => 'Rechte:',
	'usercredentials-badid'           => 'Es wurden keinen Berechtigungsnachweis für diesen Benutzer gefunden. Bitte die Schreibweise prüfen.',
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
	'usercredentials'            => 'Wósobinske pódaśa wužywarja',
	'usercredentials-leg'        => 'Pytanje jo wósobinske pódaśa wužywarja wobkšuśiło',
	'usercredentials-user'       => 'Wužywarske mě:',
	'usercredentials-text'       => 'Dołojce su wobkšuśone wósobinske pódaśa wubranego wužywarskego konta.',
	'usercredentials-leg-user'   => 'Wužywarske konto',
	'usercredentials-leg-areas'  => 'Głowne zajmowe wobcerki',
	'usercredentials-leg-person' => 'Wósobinske informacije',
	'usercredentials-leg-other'  => 'Druge informacije',
	'usercredentials-email'      => 'E-mail:',
	'usercredentials-real'       => 'Napšawdne mě:',
	'usercredentials-bio'        => 'Biografija:',
	'usercredentials-attach'     => 'Žywjenjoběg:',
	'usercredentials-notes'      => 'Pśidatne pśipiski:',
	'usercredentials-urls'       => 'Lisćina websedłow',
	'usercredentials-ip'         => 'Originalna IP-adresa:',
	'usercredentials-member'     => 'Pšawa:',
	'usercredentials-badid'      => 'Za toś togo wužywarja njebuchu žedne wósobinske pódaśa namakane. Pśekontrolěruj, lěc te mě jo pšawje napisane.',
);

/** Ewe (Eʋegbe)
 * @author M.M.S.
 */
$messages['ee'] = array(
	'confirmaccount-wsum' => 'Woezɔ loo!',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'requestaccount-leg-user'    => 'Λογαριασμός χρήστη',
	'requestaccount-leg-person'  => 'Προσωπικές πληροφορίες',
	'requestaccount-leg-other'   => 'Άλλες πληροφορίες',
	'requestaccount-real'        => 'Πραγματικό όνομα:',
	'requestaccount-email'       => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου:',
	'requestaccount-reqtype'     => 'Θέση:',
	'requestaccount-bio'         => 'Προσωπική βιογραφία:',
	'confirmaccount-real-q'      => 'Όνομα',
	'confirmaccount-email-q'     => 'Ηλεκτρονικό Ταχυδρομείο:',
	'confirmaccount-bio-q'       => 'Βιογραφία',
	'confirmaccount-leg-person'  => 'Προσωπικές πληροφορίες',
	'confirmaccount-leg-other'   => 'Άλλες πληροφορίες',
	'confirmaccount-name'        => 'Όνομα χρήστη',
	'confirmaccount-real'        => 'Όνομα:',
	'confirmaccount-email'       => 'Ηλεκτρονικό Ταχυδρομείο:',
	'confirmaccount-reqtype'     => 'Θέση:',
	'confirmaccount-bio'         => 'Βιογραφία:',
	'confirmaccount-urls'        => 'Λίστα των ιστοσελίδων:',
	'confirmaccount-create'      => 'Αποδοχή (Δημιουργία λογαριασμού)',
	'confirmaccount-ip'          => 'διεύθυνση ΙΡ:',
	'confirmaccount-wsum'        => 'Καλός ήρθατε!',
	'usercredentials-user'       => 'Όνομα χρήστη:',
	'usercredentials-leg-person' => 'Προσωπικές πληροφορίες',
	'usercredentials-leg-other'  => 'Άλλες πληροφορίες',
	'usercredentials-email'      => 'Ηλεκτρονικό ταχυδρομείο:',
	'usercredentials-bio'        => 'Βιογραφία:',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 * @author Amikeco
 */
$messages['eo'] = array(
	'requestaccount'                  => 'Peti konton',
	'requestaccount-dup'              => "'''Notu: Vi jam ensalutis kun registrita konto.'''",
	'requestaccount-leg-user'         => 'Konto de uzanto',
	'requestaccount-leg-areas'        => 'Ĉefaj fakoj de intereso',
	'requestaccount-leg-person'       => 'Persona informo',
	'requestaccount-leg-other'        => 'Alia informo',
	'requestaccount-real'             => 'Reala nomo:',
	'requestaccount-same'             => '(sama kiel reala nomo)',
	'requestaccount-email'            => 'Retpoŝta adreso:',
	'requestaccount-level-0'          => 'aŭtoro',
	'requestaccount-level-1'          => 'Redaktanto',
	'requestaccount-bio'              => 'Persona biografio:',
	'requestaccount-attach'           => 'Karierresumo (nedeviga):',
	'requestaccount-notes'            => 'Pluaj notoj:',
	'requestaccount-tooshort'         => 'Via biografio estu almenaŭ $1 vortoj.',
	'requestaccount-emaildup'         => 'Alia peto por kontrolenda konto uzas la saman retadreson.',
	'requestaccount-exts'             => 'Dosiertipo de aldonaĵo estas malpermesita.',
	'requestaccount-submit'           => 'Peti konton',
	'requestaccount-sent'             => 'Via konta peto estis sukcese sendita kaj nun bezonas kontroladon.',
	'request-account-econf'           => 'Via retadreso estis konfirmita kaj estos listigita tiel en via konta peto.',
	'requestaccount-email-subj'       => '{{SITENAME}} retpoŝta konfirmo',
	'requestaccount-email-body'       => 'Iu, verŝajne vi de IP-adreso $1, petis konton "$2" kun ĉi tiu retadreso ĉe {{SITENAME}}.

Konfirmi ke ĉi tiu konto ja apartenas al vi ĉe {{SITENAME}}, malfermu ĉi tiun ligilon en via retumilo:

$3

Se la konto estas kreita, nur al vi estos retpoŝtita la pasvorto.
Se ĉi tio ne devenas al vi, ne sekvu la ligilon.
Ĉi tiu konfirmado findatiĝis je $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} peto por konto',
	'requestaccount-loginnotice'      => "Akiri uzanto-konton, vi devas '''[[Special:RequestAccount|peti ĝin]]'''.",
	'confirmaccounts'                 => 'Konfirmi petojn por kontoj',
	'confirmedit-desc'                => 'Donas al burokratoj la ebleco konfirmi kontajn petojn',
	'confirmaccount-real-q'           => 'Nomo',
	'confirmaccount-email-q'          => 'Retadreso',
	'confirmaccount-bio-q'            => 'Biografio',
	'confirmaccount-showopen'         => 'malfermaj petoj',
	'confirmaccount-showrej'          => 'malakceptitaj petoj',
	'confirmaccount-showexp'          => 'preteraj petoj',
	'confirmaccount-review'           => 'Kontrolu',
	'confirmaccount-all'              => '(montru ĉiujn atendovicojn)',
	'confirmaccount-type'             => 'Atendovico:',
	'confirmaccount-type-0'           => 'eventualaj aŭtoroj',
	'confirmaccount-type-1'           => 'eventualaj redaktantoj',
	'confirmaccount-q-open'           => 'malfermaj petoj',
	'confirmaccount-q-stale'          => 'eksdatiĝintaj petoj',
	'confirmaccount-leg-user'         => 'Konto de uzanto',
	'confirmaccount-leg-areas'        => 'Ĉefaj fakoj de intereso',
	'confirmaccount-leg-person'       => 'Persona informo',
	'confirmaccount-leg-other'        => 'Alia informo',
	'confirmaccount-name'             => 'Salutnomo',
	'confirmaccount-real'             => 'Nomo:',
	'confirmaccount-email'            => 'Retadreso:',
	'confirmaccount-pos-0'            => 'aŭtoro',
	'confirmaccount-pos-1'            => 'redaktanto',
	'confirmaccount-bio'              => 'Biografio:',
	'confirmaccount-attach'           => 'Karierresumo:',
	'confirmaccount-notes'            => 'Pluaj notoj:',
	'confirmaccount-urls'             => 'Listo de retejoj:',
	'confirmaccount-none-p'           => '(ne provizita)',
	'confirmaccount-econf'            => '(konfirmita)',
	'confirmaccount-reject'           => '(malkonfirmita de [[User:$1|$1]] je $2)',
	'confirmaccount-noreason'         => '(nenio)',
	'confirmaccount-create'           => 'Akceptu (kreu konton)',
	'confirmaccount-spam'             => 'Spamo (ne sendu retpoŝton)',
	'confirmaccount-reason'           => 'Komento (estos inkluzivita en retpoŝto):',
	'confirmaccount-ip'               => 'IP-adreso',
	'confirmaccount-submit'           => 'Konfirmi',
	'confirmaccount-needreason'       => 'Vi devas enigi kialon en la suba komentskatolo.',
	'confirmaccount-viewing'          => '(nune okulumis uzanto [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Kreante uzanto-paĝon kun biografio de nova uzanto.',
	'confirmaccount-welc'             => "'''Bonvenon al ''{{SITENAME}}''!''' Ni esperas ke vi kontribuos multe kaj bone.
Vi verŝajne volos legi la [[{{MediaWiki:Helppage}}|helpo-paĝoj]]. Denove, bonvenon kaj amuziĝu!",
	'confirmaccount-wsum'             => 'Bonvenon!',
	'confirmaccount-email-subj'       => 'peto de konto ĉe {{SITENAME}}',
	'confirmaccount-email-body'       => 'Via peto por konto estis aprobita ĉe {{SITENAME}}.

Nomo de konto: $1

Pasvorto: $2

Por sekurecaj kialoj vi devas ŝanĝi vian pasvorton dum unua ensaluto. Por ensaluti, bonvolu iri al {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Via peto por konto estis aprobita ĉe {{SITENAME}}.

Nomo de konto: $1

Pasvorto: $2

$3

Por sekurecaj kialoj vi devas ŝanĝi vian pasvorton dum unua ensaluto. Por ensaluti, bonvolu iri al {{fullurl:Special:Userlogin}}.',
	'usercredentials-user'            => 'Salutnomo:',
	'usercredentials-leg-user'        => 'Konto de uzanto',
	'usercredentials-leg-areas'       => 'Ĉefaj fakoj de intereso',
	'usercredentials-leg-person'      => 'Persona informo',
	'usercredentials-leg-other'       => 'Alia informo',
	'usercredentials-email'           => 'Retadreso:',
	'usercredentials-real'            => 'Reala nomo:',
	'usercredentials-bio'             => 'Biografio:',
	'usercredentials-attach'          => 'Karierresumo:',
	'usercredentials-notes'           => 'Plua informo:',
	'usercredentials-urls'            => 'Listo de retejoj:',
	'usercredentials-ip'              => 'Originala IP-adreso:',
	'usercredentials-member'          => 'Rajtoj:',
);

/** Spanish (Español)
 * @author Lin linao
 */
$messages['es'] = array(
	'requestaccount-text' => "'''Completa y envía el siguiente formulario para solicitar una cuenta de usuario'''.  

Antes de solicitar una cuenta, asegúrate de haber leído los [[{{MediaWiki:Requestaccount-page}}|Términos del servicio]].

Una vez que la cuenta sea aprobada, se te enviará una notificación a través de correo electrónico y la cuenta se podrá usar entrando a [[Especial:Entrar]].",
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
 * @author Taleman
 * @author Nike
 * @author Cimon Avaro
 */
$messages['fi'] = array(
	'requestaccount'                  => 'Pyydä käyttäjätunnusta',
	'requestaccount-text'             => "'''Pyydä käyttäjätunnusta täyttämällä ja lähettämällä alla oleva lomake'''.

Muista ennen käyttäjätunnuksen pyytämistä lukea [[{{MediaWiki:Requestaccount-page}}|käyttöehdot]].

Saat sähköpostilla ilmoituksen, kun tunnus on hyväksytty ja sillä voi [[Special:Userlogin|kirjautua sisään]].",
	'requestaccount-page'             => '{{ns:project}}:Käyttöehdot',
	'requestaccount-dup'              => "'''Huomio: Olet jo kirjautuneena rekisteröidyllä käyttäjätunnuksella.'''",
	'requestaccount-leg-user'         => 'Käyttäjätunnus',
	'requestaccount-leg-areas'        => 'Tärkeimmät kiinnostuksen kohteet',
	'requestaccount-leg-person'       => 'Henkilötiedot',
	'requestaccount-leg-other'        => 'Muut tiedot',
	'requestaccount-acc-text'         => 'Lähetettyäsi pyynnön saat sähköpostitse vahvistuksen. Sinun pitää napsauttaa sähköpostissa olevaa kuittauslinkkiä. Myöskin salasanasi lähetetään sinulle, kun tunnus luodaan.',
	'requestaccount-areas-text'       => 'Valitse alta alueet, joissa olet asiantuntija tai joiden parissa haluaisit enimmäkseen työskennellä.',
	'requestaccount-ext-text'         => 'Seuraavat tiedot pidetään luottamuksellisina ja niitä käytetään vain tämän pyynnön käsittelyssä.
Haluat ehkä antaa tunnistamista helpottavia yhteystietoja, puhelinnumeron esimerkiksi.',
	'requestaccount-bio-text'         => 'Kuvauksestasi tulee käyttäjäsivusi oletussisältö.
Kirjoita omiin tietoihisi erikoisosaamisistasi ja pätevyyksistäsi. Muista, että nämä tiedot julkaistaan.
Voit muuttaa nimeäsi [[Special:Preferences|asetussivulla]].',
	'requestaccount-real'             => 'Oikea nimi:',
	'requestaccount-same'             => '(sama kuin oikea nimi)',
	'requestaccount-email'            => 'Sähköpostiosoite:',
	'requestaccount-reqtype'          => 'Asema:',
	'requestaccount-level-0'          => 'kirjoittaja',
	'requestaccount-level-1'          => 'ylläpitäjä',
	'requestaccount-bio'              => 'Kuvaus itsestäsi:',
	'requestaccount-attach'           => 'Ansioluettelo tai CV (vapaaehtoinen):',
	'requestaccount-notes'            => 'Lisähuomautukset:',
	'requestaccount-urls'             => 'Webbisivujen luettelo, jos on (yksi per rivi):',
	'requestaccount-agree'            => 'Vahvista, etä antamasi oikea nimesi on oikea ja että hyväksyt käyttöehdot.',
	'requestaccount-inuse'            => 'Käyttäjätunnusta on jo pyydetty toisessa käsiteltävänä olevassa käyttäjätunnuspyynnössä.',
	'requestaccount-tooshort'         => 'Kuvauksesi pituuden on oltava vähintään $1 sanaa.',
	'requestaccount-emaildup'         => 'Samaa sähköpostiosoitetta on käytetty toisessa parhailaan käsiteltävänä olevassa käyttäjätunnuspyynnössä.',
	'requestaccount-exts'             => 'Liitetiedosto ei ole sallittua tyyppiä.',
	'requestaccount-resub'            => 'Tietoturvasyistä antamasi ansioluettelo/CV-tiedosto on valittava uudestaan.
Jätä kenttä tyhjäksi, jos et enää halua liittää tiedostoa.',
	'requestaccount-tos'              => "Olen lukenut ja hyväksyn {{GRAMMAR:genitive|{{SITENAME}}}} [[{{MediaWiki:Requestaccount-page}}|käyttöehdot]].
Kohdasssa ''Oikea nimi'' olen antanut oman virallisen nimeni.",
	'requestaccount-submit'           => 'Pyydä käyttäjätunnusta',
	'requestaccount-sent'             => 'Käyttäjätunnuspyyntösi on lähetetty onnistuneesti ja odottaa nyt käsittelyä.',
	'request-account-econf'           => 'Sähköpostiosoitteesi on tarkistettu ja merkitään tarkistetuksi käyttäjätunnuspyyntöösi.',
	'requestaccount-email-subj'       => '{{SITENAME}}: sähköpostiosoitteen tarkistus',
	'requestaccount-email-body'       => 'Joku, luultavasti sinä itse IP-osoitteesta $1, on pyytänyt käyttäjätunnusta "$2" sivustoon {{SITENAME}} ja käyttänyt tätä sähköpostiosoitetta.

Vahvista, että tämä käyttäjätunnus sivustolle {{SITENAME}} kuuluu sinulle avaamalla tämä osoite selaimessasi:

$3

Jos käyttäjätunnus luodaan, salasana lähetetään vain sinulle. Jos et ole pyytänyt käyttäjätunnusa, *älä* avaa osoitetta.
Tämän vahvistuskoodi vanhenee $4.',
	'requestaccount-email-subj-admin' => 'Sivuston {{SITENAME}} käyttäjätunnuspyyntö',
	'requestaccount-email-body-admin' => '"$1" on pyytänyt käyttäjätunnusta ja odottaa vahvistusta.
Sähköpostiosoite on tarkistettu. Käyttäjätunnus myönnetään napsauttamalla tästä "$2".',
	'acct_request_throttle_hit'       => 'Valitettavasti et voi tehdä enempää pyyntöjä, koska olet jo pyytänyt $1 käyttäjätunnusta.',
	'requestaccount-loginnotice'      => "Saadaksesi käyttäjätunnuksen on tehtävä '''[[Special:RequestAccount|käyttäjätunnuspyyntö]]'''.",
	'confirmaccount-newrequests'      => "Nyt on '''$1''' {{PLURAL:$1|avoin|avointa}} {{PLURAL:$1|[[Special:ConfirmAccounts|pyyntö]]|[[Special:ConfirmAccounts|pyyntöä]]}} käsiteltävänä.",
	'confirmaccounts'                 => 'Myönnä käyttäjätunnuksia.',
	'confirmedit-desc'                => 'Byrokraatit saavat oikeuden myöntää käyttäjätunnuksia.',
	'confirmaccount-maintext'         => "'''Tällä sivulla myönnetään käyttäjätunnuksia sivustolle \"{{SITENAME}}\"'''.

Jokaisessa pyyntöjonossa on kolme alijonoa, käsittelemättömille pyynnöille,
muiden byrokraattien lisätietoja odottamaan pysäyttämille pyynnöille ja
kolmas hiljattain hylätyille pyynnöille.

Tarkista pyyntö huolellisesti ennen vastaamista ja vahvista pyynnön tiedot tarvittaessa.
Toimenpiteesi kirjoitetaan yksityiseen lokiin. Tarkoitus on valvoa kaikkia täällä tehtäviä 
toimia omien puuhiesi lisäksi.",
	'confirmaccount-list'             => 'Alla on luettelo hyväksymistä odottavista pyynnöistä.
Hyväksytyt käyttäjätunnukset luodaan ja poistetaan luettelosta. Hylätyt pyynnöt vain poistetaan luettelosta.',
	'confirmaccount-list2'            => 'Alla on luettelo hiljattain hylätyistä pyynnöistä jotka voidaan poistaa automaattisesti, kun ne ovat useiden päivien ikäisiä.
Ne voidaan vieläkin hyväksyä käyttäjätunnuksiksi, mutta neuvottelethan ensin hylkäyksen tehneen ylläpitäjän kanssa.',
	'confirmaccount-text'             => "Tämä on käsittelyä odottava käyttäjätunnuspyyntö sivustolle '''{{SITENAME}}'''.

Tarkista alla olevat tiedot huolellisesti. Jos olet hyväksymässä tätä pyyntöä, aseta käyttäjän asema pudotusvalikosta.
Pyytäjän omien tietojen muokkaaminen ei vaikuta pysyviin pätevyystietoihin. Huomaa voivasi muuttaa luotavan käyttäjätunnuksen. Käytä tätä vain nimiyhteentörmäysten välttämiseen.

Jos jätät tämän sivun vahvistamatta tai hylkäämättä pyyntöä, se jää odottamaan käsittelyä.",
	'confirmaccount-none-o'           => 'Tässä luettelossa ei ole nyt yhtään käsiteltävänä olevaa pyyntöä.',
	'confirmaccount-none-h'           => 'Tässä luettelossa ei ole nyt yhtään pysäytettyä käsiteltävänä olevaa pyyntöä.',
	'confirmaccount-none-r'           => 'Täss luettelossa ei ole nyt yhtään äskettäin hylättyä pyyntöä.',
	'confirmaccount-real-q'           => 'Nimi',
	'confirmaccount-email-q'          => 'Sähköposti',
	'confirmaccount-bio-q'            => 'Omat tiedot',
	'confirmaccount-showheld'         => 'Katso luettelo käsiteltävänä olevista pyynnöistä',
	'confirmaccount-review'           => 'Tarkista',
	'confirmaccount-types'            => 'Valitse vahvistettavien pyyntöjen jono alla olevista:',
	'confirmaccount-all'              => '(näytä kaikki jonot)',
	'confirmaccount-type'             => 'Valittu jono:',
	'confirmaccount-type-0'           => 'kirjoittajaehdokkaat',
	'confirmaccount-type-1'           => 'toimittajaehdokkaat',
	'confirmaccount-q-open'           => 'avoimet pyynnöt',
	'confirmaccount-q-held'           => 'pysäytetyt pyynnöt',
	'confirmaccount-q-rej'            => 'äskettäin hylätyt pyynnöt',
	'confirmaccount-badid'            => 'Annettua tunnistetta vastavaa käsiteltävänä olevaa pyyntöä ei ole.
Se voi olla jo käsitelty.',
	'confirmaccount-leg-user'         => 'Käyttäjätunnus',
	'confirmaccount-leg-areas'        => 'Tärkeimmät kiinnostuksen kohteet',
	'confirmaccount-leg-person'       => 'Henkilötiedot',
	'confirmaccount-leg-other'        => 'Muut tiedot',
	'confirmaccount-name'             => 'Käyttäjätunnus',
	'confirmaccount-real'             => 'Nimi:',
	'confirmaccount-email'            => 'Sähköpostiosoite:',
	'confirmaccount-reqtype'          => 'Asema:',
	'confirmaccount-pos-0'            => 'kirjoittaja',
	'confirmaccount-pos-1'            => 'toimittaja',
	'confirmaccount-bio'              => 'Omat tiedot:',
	'confirmaccount-attach'           => 'Ansioluettelo/CV:',
	'confirmaccount-notes'            => 'Lisätietoja:',
	'confirmaccount-urls'             => 'Luettelo webbisivuista:',
	'confirmaccount-none-p'           => '(ei annettu)',
	'confirmaccount-confirm'          => 'Hyväksy, hylkää tai pysäytä tämä pyyntö alla olevilla valinnoilla:',
	'confirmaccount-econf'            => '(tarkistettu)',
	'confirmaccount-reject'           => '(hylätty, hylkääjänä [[User:$1|$1]] osoitteesta $2)',
	'confirmaccount-rational'         => 'Hakijalle kerrotut perustelut:',
	'confirmaccount-noreason'         => '(ei mitään)',
	'confirmaccount-held'             => '("pysäytetty", pysäyttäjänä [[User:$1|$1]] osoitteessa $2)',
	'confirmaccount-create'           => 'Hyväksy (luo käyttäjätunnus)',
	'confirmaccount-deny'             => 'Hylkää (poista jonosta)',
	'confirmaccount-hold'             => 'Pysäytä',
	'confirmaccount-spam'             => 'Roskaa (sähköpostia ei lähetetä)',
	'confirmaccount-reason'           => 'Huomautus (liitetään sähköpostiin):',
	'confirmaccount-ip'               => 'IP-osoite:',
	'confirmaccount-submit'           => 'Vahvista',
	'confirmaccount-needreason'       => 'Alla olevaan huomautuslaatikkoon on kirjoitettava perustelu.',
	'confirmaccount-canthold'         => 'Tämä pyyntöf on jo joko pysäytetty tai poistettu.',
	'confirmaccount-acc'              => 'Pyynnön vahvistaminen onnistui; luotu uusi käyttäjätunnus [[User:$1]].',
	'confirmaccount-rej'              => 'Pyynnön hylkääminen onnistui.',
	'confirmaccount-viewing'          => '(juuri nyt katseltavana käyttäjällä [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Luodaan uuden käyttäjän tiedost sisältävä käyttäjäsivu.',
	'confirmaccount-welc'             => "'''Tervetuloa ''{{SITENAME}}''-sivustolle!''' Toivomme runsasta ja laadukasta kirjoittelua.
Haluat varmaan lukea [[{{MediaWiki:Helppage}}|ohjesivut]]. Vielä kerran tervetuloa ja pidä hauskaa!",
	'confirmaccount-wsum'             => 'Tervetuloa!',
	'confirmaccount-email-subj'       => 'Käyttäjätunnuspyyntö sivustolle {{SITENAME}}',
	'confirmaccount-email-body'       => 'Pyytämäsi käyttäjätunnus sivulle {{SITENAME}} on hyväksytty.

Käyttäjätunnus: $1

Salasana: $2

Salasana on vaihdettava ensimmäisellä sisäänkirjautumiskerralla tietoturvasyistä. Kirjaudu sisään sivulla {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Pyytämäsi käyttäjätunnus sivulle {{SITENAME}} on hyväksytty.

Käyttäjätunnus: $1

Salasana: $2

$3

Salasana on vaihdettava ensimmäisellä sisäänkirjautumiskerralla tietoturvasyistä. Kirjaudu sisään sivulla {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Valitettavasti pyyntösi käyttäjätunnuksesta "$1" sivulle {{SITENAME}} on hylätty.

Hylkäämisen mahdollisia syitä on useita.
Lomaketta ei ehkä ole täytetty oikein, kuvaus ei ollut tarpeeksi pitkä tai joku muu toimintaperiaatteen ehdoista jäi täyttämättä.
Jos haluat tietää enemmän toimintaperiaatteista käyttäjätunnusten myöntämiseen saattaa sivuilla olla luettelo yhteystiedoista.',
	'confirmaccount-email-body4'      => 'Valitettavasti pyyntösi käyttäjätunnuksesta "$1" sivulle {{SITENAME}} on hylätty.

$2

Jos haluat tietää enemmän toimintaperiaatteista käyttäjätunnusten myöntämiseen saattaa sivuilla olla luettelo yhteystiedoista.',
	'confirmaccount-email-body5'      => 'Ennenkuin pyytämäsi käyttäjätunnus "$1" sivulle {{SITENAME}} voidaan hyväksyä tarvitaan lisätietoja.

$2

Jos haluat tietää enemmän toimintaperiaatteista käyttäjätunnuksesta myöntämiseen saattaa sivuilla olla luettelo yhteystiedoista.',
	'usercredentials'                 => 'Käyttäjän valtuudet',
	'usercredentials-leg'             => 'Etsi käyttäjän vahvistetut valtuudet',
	'usercredentials-user'            => 'Käyttäjätunnus',
	'usercredentials-text'            => 'Valitun käyttäjätunnuksen vahvistetut valtuudet ovat alla.',
	'usercredentials-leg-user'        => 'Käyttäjätunnus',
	'usercredentials-leg-areas'       => 'Tärkeimmät kiinnostuksen kohteet',
	'usercredentials-leg-person'      => 'Henkilötiedot',
	'usercredentials-leg-other'       => 'Muut tiedot',
	'usercredentials-email'           => 'Sähköposti:',
	'usercredentials-real'            => 'Oikea nimi:',
	'usercredentials-bio'             => 'Omat tiedot',
	'usercredentials-attach'          => 'Ansioluettelo/CV:',
	'usercredentials-notes'           => 'Lisähuomautukset:',
	'usercredentials-urls'            => 'Webbisivujen luettelo:',
	'usercredentials-ip'              => 'Käyttäjän IP-osoite:',
	'usercredentials-member'          => 'Oikeudet:',
	'usercredentials-badid'           => 'Tämän käyttäjän valtuutuksia ei löytynyt. Tarkista nimen oikeinkirjoitus.',
);

/** French (Français)
 * @author Grondin
 * @author Dereckson
 * @author Sherbrooke
 * @author Urhixidur
 * @author Meithal
 * @author SPQRobin
 * @author Louperivois
 */
$messages['fr'] = array(
	'requestaccount'                  => 'Demande de compte utilisateur',
	'requestaccount-text'             => "'''Remplissez et envoyez le formulaire ci-dessous pour demander un compte d’utilisateur.'''. 
	
	Assurez-vous que vous ayez déjà lu [[{{MediaWiki:Requestaccount-page}}|les conditions d’utilisation]] avant de faire votre demande de compte.
	
	Une fois que le compte est accepté, vous recevrez un courrier électronique vous notifiant que votre compte pourra être utilisé sur
	[[Special:Userlogin]].",
	'requestaccount-page'             => "{{ns:project}}:Conditions d'utilisation",
	'requestaccount-dup'              => "'''Note : Vous êtes déjà sur une session avec un compte enregistré.'''",
	'requestaccount-leg-user'         => 'Compte utilisateur',
	'requestaccount-leg-areas'        => "Centres d'intérêts principaux",
	'requestaccount-leg-person'       => 'Informations personnelles',
	'requestaccount-leg-other'        => 'Autres informations',
	'requestaccount-acc-text'         => 'Un message de confirmation sera envoyé à votre adresse électronique une fois que la demande aura été envoyée. Dans le courrier reçu, cliquez sur le lien correspondant à la confirmation de votre demande. Aussi, un mot de passe sera envoyé par courriel quand votre compte sera créé.',
	'requestaccount-areas-text'       => 'Choisissez les domaines dans lesquels vous avez une expertise démontrée, ou dans lesquels vous êtes enclin à contribuer le plus.',
	'requestaccount-ext-text'         => 'L’information suivante reste privée et ne pourra être utilisée que pour cette requête. 
	Vous avez la possibilité de lister des contacts tels qu’un numéro de téléphone pour obtenir une assistance pour confirmer votre identité.',
	'requestaccount-bio-text'         => 'Votre biographie sera mise par défaut sur votre page utilisateur. Essayez d’y mettre vos recommandations. Assurez-vous que vous pouvez diffuser sans crainte les informations. Votre nom peut être changé en utilisant [[Special:Preferences]].',
	'requestaccount-real'             => 'Nom réel :',
	'requestaccount-same'             => '(nom figurant dans votre état civil)',
	'requestaccount-email'            => 'Adresse électronique :',
	'requestaccount-reqtype'          => 'Situation :',
	'requestaccount-level-0'          => 'auteur',
	'requestaccount-level-1'          => 'éditeur',
	'requestaccount-bio'              => 'Biographie personnelle :',
	'requestaccount-attach'           => 'CV/Résumé (facultatif)',
	'requestaccount-notes'            => 'Notes supplémentaires :',
	'requestaccount-urls'             => "Liste des sites Web. S'il y en a plusieurs, séparez-les par un saut de ligne :",
	'requestaccount-agree'            => 'Vous devez certifier que votre nom réel est correct et que vous acceptez les conditions d’utilisations du service.',
	'requestaccount-inuse'            => 'Le nom d’utilisateur est déjà utilisé dans une requête en cours d’approbation.',
	'requestaccount-tooshort'         => 'Votre biographie doit avoir au moins {{PLURAL:$1|$1 mot|$1 mots}}.',
	'requestaccount-emaildup'         => 'Une autre demande en cours utilise la même adresse électronique.',
	'requestaccount-exts'             => 'Le téléchargement des fichiers joints n’est pas permis.',
	'requestaccount-resub'            => 'Veuillez sélectionner à nouveau votre curriculum vitæ pour des raisons de sécurité. Si vous ne souhaitez plus inclure celui-ci, laissez ce champ vierge.',
	'requestaccount-tos'              => 'J’ai lu et j’accepte de respecter les [[{{MediaWiki:Requestaccount-page}}|termes concernant les conditions d’utilisation des services]] de {{SITENAME}}.',
	'requestaccount-submit'           => 'Demande de compte utilisateur.',
	'requestaccount-sent'             => 'Votre demande de compte utilisateur a été envoyée avec succès et a été mise dans la liste d’attente d’approbation.',
	'request-account-econf'           => 'Votre adresse courriel a été confirmée et sera listée telle quelle dans votre demande de compte.',
	'requestaccount-email-subj'       => '{{SITENAME}} confirmation d’adresse courriel.',
	'requestaccount-email-body'       => 'Quelqu’un, vous probablement, a formulé, depuis l’adresse IP $1, une demande de compte utilisateur « $2 » avec cette adresse courriel sur {{SITENAME}}.

Pour confirmer que ce compte vous appartient réelement sur {{SITENAME}}, vous êtes prié d’ouvrir ce lien dans votre navigateur Web :

$3

Votre mot de passe vous sera envoyé uniquement si votre compte est créé. Si tel n’était pas le cas, n’utilisez pas ce lien.
Ce code de confirmation expire le $4.',
	'requestaccount-email-subj-admin' => 'Demande de compte sur {{SITENAME}}',
	'requestaccount-email-body-admin' => "« $1 » a demandé un compte et se trouve en attente de confirmation.

L'adresse courriel a été confirmée. Vous pouvez approuver la demande ici « $2 ».",
	'acct_request_throttle_hit'       => 'Désolé, vous avec demandé $1 comptes. Vous ne pouvez plus faire de demande.',
	'requestaccount-loginnotice'      => "Pour obtenir un compte utilisateur, vous devez en faire '''[[Special:RequestAccount|la demande]]'''.",
	'confirmaccount-newrequests'      => "Il y a actuellement '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|demande de compte]]|[[Special:ConfirmAccounts|demandes de compte]]}} en cours.",
	'confirmaccounts'                 => 'Demande de confirmation de comptes',
	'confirmedit-desc'                => 'Donne aux bureaucrates la possibilité de confirmer les demandes de comptes d’utilisateurs',
	'confirmaccount-maintext'         => "'''Cette page est utilisée pour confirmer les demandes de compte utilisateur sur ''{{SITENAME}}'''''.

Chaque demande de compte utilisateur consiste en trois sous-listes : une pour les demandes non traitées, une pour les comptes réservés dans l'attente de plus amples informations, et une dernière pour les comptes récemment rejetés.

Lors de la réponse à une demande, vérifiez-la attentivement et, le cas échéant, confirmez les informations qui y sont mentionnées. Vos actions seront inscrites séparément dans un journal. Vous devez aussi vérifier l'activité sur {{SITENAME}} en plus de la vôtre.",
	'confirmaccount-list'             => 'Voici, ci-dessous, la liste des comptes en attente d’approbation. Les comptes acceptés seront créés et retirés de cette liste. Les comptes rejetés seront supprimés de cette même liste.',
	'confirmaccount-list2'            => 'Voir la liste des comptes récemment rejetés lesquels seront supprimés automatiquement après quelques jours. Ils peuvent encore être approuvés, aussi vous pouvez consulter les rejets avant de le faire.',
	'confirmaccount-list3'            => 'Ci-dessous se trouve une liste de comptes expirés qui pourraient être automatiquement supprimés après quelques jours. Ils peuvent encore être approuvés.',
	'confirmaccount-text'             => "Voici une demande en cours pour un compte utilisateur sur '''{{SITENAME}}'''.

Vérifiez soigneusement toutes les informations ci-dessous. Si vous approuvez cette demande, sélectionnez la situation à donner à l'utilisateur. Les changements apportés aux biographies de l'application n'affecteront pas les références permanentes déjà stockées.

Notez que vous pouvez choisir de créer un compte sous un autre nom. Faites ceci uniquement pour éviter des conflits avec d’autres.

Si vous quittez cette page sans confirmer ou rejeter cette demande, elle restera en attente.",
	'confirmaccount-none-o'           => "Il n'y a actuellement aucune demande de compte utilisateur en cours dans cette liste.",
	'confirmaccount-none-h'           => "Il n'y a actuellement aucune réservation de compte utilisateur en cours dans cette liste.",
	'confirmaccount-none-r'           => "Il n'y a actuellement aucun rejet récent de demande de compte utilisateur dans cette liste.",
	'confirmaccount-none-e'           => "Il n'y a actuellement aucune requête de compte expirée dans la liste.",
	'confirmaccount-real-q'           => 'Nom',
	'confirmaccount-email-q'          => 'Courriel',
	'confirmaccount-bio-q'            => 'Biographie',
	'confirmaccount-showopen'         => 'Requêtes ouvertes',
	'confirmaccount-showrej'          => 'Requêtes rejetées',
	'confirmaccount-showheld'         => 'Voir la liste des comptes réservés en cours de traitement',
	'confirmaccount-showexp'          => 'Requêtes expirées',
	'confirmaccount-review'           => 'Approbation/Rejet',
	'confirmaccount-types'            => "Sélectionnez un compte dans la liste d'attente ci-dessous :",
	'confirmaccount-all'              => "(Voir toutes les listes d'attente)",
	'confirmaccount-type'             => "Liste d'attente sélectionnée :",
	'confirmaccount-type-0'           => 'auteurs éventuels',
	'confirmaccount-type-1'           => 'éditeurs éventuels',
	'confirmaccount-q-open'           => 'demandes faites',
	'confirmaccount-q-held'           => 'demandes mises en attente',
	'confirmaccount-q-rej'            => 'demandes rejetées récemment',
	'confirmaccount-q-stale'          => 'Requêtes expirées',
	'confirmaccount-badid'            => 'Il n’y a aucune demande en cours correspondant à l’ID indiqué. Il est possible qu‘il ait subi une maintenance.',
	'confirmaccount-leg-user'         => 'Compte utilisateur',
	'confirmaccount-leg-areas'        => "Centres d'intérêts principaux",
	'confirmaccount-leg-person'       => 'Informations personnelles',
	'confirmaccount-leg-other'        => 'Autres informations',
	'confirmaccount-name'             => 'Nom d’utilisateur',
	'confirmaccount-real'             => 'Nom :',
	'confirmaccount-email'            => 'Courriel :',
	'confirmaccount-reqtype'          => 'Situation :',
	'confirmaccount-pos-0'            => 'auteur',
	'confirmaccount-pos-1'            => 'éditeur',
	'confirmaccount-bio'              => 'Biographie :',
	'confirmaccount-attach'           => 'CV/Résumé :',
	'confirmaccount-notes'            => 'Notes supplémentaires :',
	'confirmaccount-urls'             => 'Liste des sites web :',
	'confirmaccount-none-p'           => '(non pourvu)',
	'confirmaccount-confirm'          => 'Utilisez les boutons ci-dessous pour accepter ou rejeter la demande.',
	'confirmaccount-econf'            => '(confirmé)',
	'confirmaccount-reject'           => '(rejeté par [[User:$1|$1]] le $2)',
	'confirmaccount-rational'         => 'Motif donné au candidat',
	'confirmaccount-noreason'         => '(néant)',
	'confirmaccount-autorej'          => '(Cette requête a été abandonnée automatiquement pour cause d’absence d’activité)',
	'confirmaccount-held'             => 'Marqué « réservé » par [[User:$1|$1]] sur $2',
	'confirmaccount-create'           => 'Approbation (crée le compte)',
	'confirmaccount-deny'             => 'Rejet (supprime le compte)',
	'confirmaccount-hold'             => 'Réservé',
	'confirmaccount-spam'             => 'Pourriel (n’envoyez pas de courriel)',
	'confirmaccount-reason'           => 'Commentaire (figurera dans le courriel) :',
	'confirmaccount-ip'               => 'Adresse IP',
	'confirmaccount-submit'           => 'Confirmation',
	'confirmaccount-needreason'       => 'Vous devez indiquer un motif dans le cadre ci-après.',
	'confirmaccount-canthold'         => 'Cette requête est déjà, soit prise en compte, soit supprimée.',
	'confirmaccount-acc'              => 'La demande de compte a été confirmée avec succès ; création du nouvel utilisateur [[User:$1]].',
	'confirmaccount-rej'              => 'La demande a été rejetée avec succès.',
	'confirmaccount-viewing'          => "(actuellement en train d'être visionné par [[User:$1|$1]])",
	'confirmaccount-summary'          => 'Création de la page utilisateur avec sa biographie.',
	'confirmaccount-welc'             => "'''Bienvenue sur ''{{SITENAME}}'' !''' Nous espérons que vous contribuerez beaucoup et bien. Vous désirerez, peut-être, lire [[{{MediaWiki:Helppage}}|comment bien débuter]]. Bienvenue encore et bonne contribution.
<nowiki>~~~~</nowiki>",
	'confirmaccount-wsum'             => 'Bienvenue !',
	'confirmaccount-email-subj'       => '{{SITENAME}} demande de compte',
	'confirmaccount-email-body'       => 'Votre demande de compte a été acceptée sur {{SITENAME}}.

Nom du compte utilisateur : $1

Mot de passe : $2

Pour des raisons de sécurité, vous devrez changer votre mot de passe lors de votre première connexion. Pour vous connecter, allez sur
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Votre demande de compte utilisateur a été acceptée sur {{SITENAME}}.

Nom du compte utilisateur : $1

Mot de passe: $2

$3

Pour des raisons de sécurité, vous devrez changer votre mot de passe lors de votre première connexion. Pour vous connecter, allez sur 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Désolé, votre demande de compte utilisateur « $1 » a été rejetée sur {{SITENAME}}.

Plusieurs raisons peuvent expliquer ce cas de figure. Il est possible que vous ayez mal rempli le formulaire, ou que vous n’ayez pas indiqué suffisamment d’informations dans vos réponses. Il est encore possible que vous ne remplissiez pas les critères d’éligibilité pour obtenir votre compte. Il est possible d’être sur la liste des contacts si vous désirez mieux connaître les conditions requises.',
	'confirmaccount-email-body4'      => 'Désolé, votre demande de compte utilisateur « $1 » a été rejetée sur {{SITENAME}}.

$2

Il est possible d’être sur la liste des contacts afin de mieux connaître les critères pour pouvoir s’inscrire.',
	'confirmaccount-email-body5'      => 'Avant que votre requête pour le compte « $1 » ne puisse être acceptée sur {{SITENAME}}, vous devez produire quelques informations suplémentaires.

$2

Ceci permet d’être sur la liste des contacts du site, si vous désirez en savoir plus sur les règles concernant les comptes.',
	'usercredentials'                 => "Références de l'utilisateur",
	'usercredentials-leg'             => "Vérification confirmée des références d'un utilisateur.",
	'usercredentials-user'            => "Nom d'utilisateur :",
	'usercredentials-text'            => 'Ci-dessous figurent les justificatifs validés pour le compte utilisateur sélectionné.',
	'usercredentials-leg-user'        => 'Compte utilisateur',
	'usercredentials-leg-areas'       => "Centres d'intérêts principaux",
	'usercredentials-leg-person'      => 'Informations personnelles',
	'usercredentials-leg-other'       => 'Autres informations',
	'usercredentials-email'           => 'Courriel :',
	'usercredentials-real'            => 'Nom réel :',
	'usercredentials-bio'             => 'Biographie :',
	'usercredentials-attach'          => 'CV/Résumé :',
	'usercredentials-notes'           => 'Notes supplémentaires :',
	'usercredentials-urls'            => 'Liste des sites internet :',
	'usercredentials-ip'              => 'Adresse IP initiale :',
	'usercredentials-member'          => 'Droits :',
	'usercredentials-badid'           => 'Aucune référence trouvée pour cet utilisateur. Véfifiez que le nom soit bien rédigé.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 * @author SPQRobin
 */
$messages['frp'] = array(
	'requestaccount'             => 'Demanda de compto utilisator',
	'requestaccount-text'        => "'''Rempléd et emmandâd lo formulèro ce-desot por demandar un compto utilisator.'''
	
	Assurâd-vos que vos éd ja liesu les [[{{MediaWiki:Requestaccount-page}}|condicions d’usâjo]] devant que fâre voutra demanda de compto.
	
	Un côp que lo compto est accèptâ, vos recevréd un mèl vos notifient que voutron compto porrat étre utilisâ dessus
	[[Special:Userlogin]].",
	'requestaccount-page'        => '{{ns:project}}:Condicions d’usâjo',
	'requestaccount-dup'         => "'''Nota : vos éte ja sur una sèssion avouéc un compto enregistrâ.'''",
	'requestaccount-acc-text'    => 'Un mèssâjo de confirmacion serat emmandâ a voutra adrèce èlèctronica un côp que la demanda arat étâ emmandâ. Dens lo mèl reçu, clicâd sur lo lim corrèspondent a la confirmacion de voutra demanda. Et pués, un mot de pâssa serat emmandâ per mèl quand voutron compto serat crèâ.',
	'requestaccount-ext-text'    => 'L’enformacion siuventa réste privâ et porrat étre utilisâ ren que por ceta requéta. 
	Vos avéd la possibilitât de listar des contactes tâl qu’un numerô de tèlèfone por obtegnir una assistance por confirmar voutra identitât.',
	'requestaccount-bio-text'    => 'Voutra biografia serat betâ per dèfôt sur voutra pâge utilisator. Tâchiéd d’y betar voutres recomandacions. Assurâd-vos que vos pouede difusar sen crenta les enformacions. Voutron nom pôt étre changiê en utilisent [[Special:Preferences]].',
	'requestaccount-real'        => 'Veré nom :',
	'requestaccount-same'        => '(nom figurent dens voutron ètat civilo)',
	'requestaccount-email'       => 'Adrèce èlèctronica :',
	'requestaccount-bio'         => 'Biografia a sè :',
	'requestaccount-attach'      => 'CV/Rèsumâ (u chouèx) :',
	'requestaccount-notes'       => 'Notes suplèmentères :',
	'requestaccount-urls'        => 'Lista des setos Malyâjo. S’y at plusiors, sèparâd-los per un sôt de legne :',
	'requestaccount-agree'       => 'Vos dête cèrtifiar que voutron veré nom est corrèct et que vos accèptâd les condicions d’usâjo du sèrviço.',
	'requestaccount-inuse'       => 'Lo nom d’utilisator est ja utilisâ dens una requéta en cors d’aprobacion.',
	'requestaccount-tooshort'    => 'Voutra biografia dêt avêr u muens {{PLURAL:$1|$1 mot|$1 mots}}.',
	'requestaccount-exts'        => 'Lo tèlèchargement des fichiérs juents est pas pèrmês.',
	'requestaccount-resub'       => 'Voutron fichiér de CV/rèsumâ dêt étre sèlèccionâ un côp de ples por des rêsons de sècuritât. Lèssiéd lo champ vouedo se vos dèsirâd pas més l’apondre.',
	'requestaccount-tos'         => 'J/y’é liesu et j/y’accèpto de rèspèctar los tèrmos regardent les [[{{MediaWiki:Requestaccount-page}}|condicions d’usâjo]] des sèrviços de {{SITENAME}}. 
	Lo nom que j/y’é endicâ dens lo champ « Veré nom » est verément mon nom pèrsonèl.',
	'requestaccount-submit'      => 'Demanda de compto utilisator.',
	'requestaccount-sent'        => 'Voutra demanda de compto utilisator at étâ emmandâ avouéc reusséta et at étâ betâ dens la lista d’atenta d’aprobacion.',
	'request-account-econf'      => 'Voutra adrèce de mèl at étâ confirmâ et serat listâ tâla qu’el est dens voutra demanda de compto.',
	'requestaccount-email-subj'  => '{{SITENAME}} confirmacion d’adrèce de mèl.',
	'requestaccount-email-body'  => 'Quârqu’un, probâblament vos, at formulâ, dês l’adrèce IP $1, una demanda de compto utilisator « $2 » dessus {{SITENAME}} avouéc ceta adrèce de mèl.

Por confirmar que cél compto dessus {{SITENAME}} est verément a vos, vos éte preyê d’uvrir ceti lim dens voutron navigator Malyâjo :

$3

Voutron mot de pâssa vos serat emmandâ solament se voutron compto est crèâ. Se tâl ére *pas* lo câs, utilisâd pas ceti lim. 
Ceti code de confirmacion èxpire lo $4.',
	'acct_request_throttle_hit'  => 'Dèsolâ, vos éd ja demandâ $1 comptos. Vos pouede pas més nen fâre la demanda.',
	'requestaccount-loginnotice' => "Por obtegnir un compto utilisator, vos dête nen fâre la '''[[Special:RequestAccount|demanda]]'''.",
	'confirmaccounts'            => 'Demanda de confirmacion de comptos',
	'confirmaccount-list'        => 'Vê-que, ce-desot, la lista des comptos en atenta d’aprobacion. Los comptos accèptâs seront crèâs et reteriês de ceta lista. Los comptos refusâs seront suprimâs de ceta méma lista.',
	'confirmaccount-real-q'      => 'Nom',
	'confirmaccount-email-q'     => 'Mèl',
	'confirmaccount-bio-q'       => 'Biografia',
	'confirmaccount-review'      => 'Aprobacion/Refus',
	'confirmaccount-name'        => 'Nom d’utilisator',
	'confirmaccount-real'        => 'Nom :',
	'confirmaccount-email'       => 'Mèl :',
	'confirmaccount-bio'         => 'Biografia :',
	'confirmaccount-attach'      => 'CV/Rèsumâ :',
	'confirmaccount-notes'       => 'Notes suplèmentères :',
	'confirmaccount-urls'        => 'Lista des setos Malyâjo :',
	'confirmaccount-none-p'      => '(pas porvu)',
	'confirmaccount-econf'       => '(confirmâ)',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'confirmaccount-real-q' => 'Namme',
	'confirmaccount-real'   => 'Namme:',
);

/** Galician (Galego)
 * @author Xosé
 * @author Alma
 * @author Toliño
 * @author SPQRobin
 */
$messages['gl'] = array(
	'requestaccount'                  => 'Solicitar unha conta',
	'requestaccount-text'             => "'''Complete e envíe o formulario seguinte para solicitar unha conta de usuario'''.

	Asegúrese de ter lido primeiro as [[{{MediaWiki:Requestaccount-page}}|Condicións de Servizo]] antes de solicitar unha conta.

	Unha vez que se aprobe a conta recibirá unha mensaxe de notificación por correo electrónico e poderá usar a conta en
	[[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:Condicións de Servizo',
	'requestaccount-dup'              => "'''Nota: Xa está no sistema cunha conta rexistrada.'''",
	'requestaccount-leg-user'         => 'Conta de usuario',
	'requestaccount-leg-areas'        => 'Principais áreas de interese',
	'requestaccount-leg-person'       => 'Información persoal',
	'requestaccount-leg-other'        => 'Outra información',
	'requestaccount-acc-text'         => 'Enviaráselle unha mensaxe de confirmación ao seu enderezo de correo electrónico unha vez enviada esta solicitude. Responda premendo
	na ligazón de confirmación que lle aparecerá no correo electrónico. Así mesmo, enviaráselle o seu contrasinal cando se cree a conta.',
	'requestaccount-areas-text'       => 'Seleccione embaixo as áreas dos temas dos que é máis experto ou nos que lle gustaría traballar máis.',
	'requestaccount-ext-text'         => 'A información seguinte mantense como reservada e só se usará para esta solicitude.
	Pode querer listar contactos, como un número de teléfono, para axudar a identificar a confirmación.',
	'requestaccount-bio-text'         => 'A súa biografía aparecerá como contido predefinido da súa páxina de usuario. Tente incluír
	credenciais. Asegúrese de non ter problema coa publicación desa información. O seu nome pódese cambiar mediante [[Special:Preferences]].',
	'requestaccount-real'             => 'Nome real:',
	'requestaccount-same'             => '(o mesmo que o nome real)',
	'requestaccount-email'            => 'Enderezo de correo electrónico:',
	'requestaccount-reqtype'          => 'Posición:',
	'requestaccount-level-0'          => 'autor',
	'requestaccount-level-1'          => 'editor',
	'requestaccount-bio'              => 'Biografía persoal:',
	'requestaccount-attach'           => 'Curriculum Vitae (opcional):',
	'requestaccount-notes'            => 'Notas adicionais:',
	'requestaccount-urls'             => 'Listaxe de sitios web, de habelos, (separados cun parágrafo novo):',
	'requestaccount-agree'            => 'Debe certificar que o seu nome real é correcto e que está de acordo coas nosas Condicións de Servizo.',
	'requestaccount-inuse'            => 'Este nome de usuario xa se usou nunha solicitude de conta aínda pendente.',
	'requestaccount-tooshort'         => 'A súa biografía debe ter un mínimo de $1 palabras.',
	'requestaccount-emaildup'         => 'Outra solicitude pendente de conta usa o mesmo enderezo de correo electrónico.',
	'requestaccount-exts'             => 'Non se permite este tipo de ficheiro como anexo.',
	'requestaccount-resub'            => 'Ten que volver seleccionar o ficheiro do seu curriculum vitae por razóns de seguranza.
Deixe o campo en branco se non o quere incluír máis.',
	'requestaccount-tos'              => 'Lin e estou de acordo en respectar as [[{{MediaWiki:Requestaccount-page}}|Condicións de Servizo]] de {{SITENAME}}. 
	O nome especificado como "Nome real" é, efectivamente, o meu propio nome real.',
	'requestaccount-submit'           => 'Solicitar unha conta',
	'requestaccount-sent'             => 'Enviouse sen problemas a súa solicitude de conta e agora está pendente de exame.',
	'request-account-econf'           => 'Confirmouse o seu enderezo de correo electrónico e listarase como tal na súa
	solicitude de conta.',
	'requestaccount-email-subj'       => 'Confirmación de enderezo de correo electrónico de {{SITENAME}}',
	'requestaccount-email-body'       => 'Alguén, probabelmente vostede desde o enderezo IP $1, solicitou unha
conta "$2" con este enderezo de correo electrónico en {{SITENAME}}.

Para confirmar que esta conta lle pertence a vostede en {{SITENAME}}, abra esta ligazón no seu navegador:

$3

Se se crea a conta, só vostede recibirá o contrasinal. Se *non* se trata de vostede, non siga a ligazón.
Este código de confirmación caducará o $4.',
	'requestaccount-email-subj-admin' => 'solicitude de conta en {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" solicitou unha conta e está pendente de confirmación.
O enderezo de correo electrónico foi confirmado. Pode confirmar a solicitude aquí "$2".',
	'acct_request_throttle_hit'       => 'Sentímolo, xa solicitou $1 contas. Non pode facer máis solicitudes.',
	'requestaccount-loginnotice'      => "Para obter unha conta de usuario ten que '''[[Special:RequestAccount|solicitar unha]]'''.",
	'confirmaccount-newrequests'      => "Hai {{PLURAL:$1}} actualmente '''$1''' aberto 
 {{PLURAL:$1|[[Special:ConfirmAccounts|solicitude de conta]]|[[Special:ConfirmAccounts|solicitudes de contas]]}} pendente.",
	'confirmaccounts'                 => 'Confirmar solicitudes de contas',
	'confirmedit-desc'                => 'Dar aos burócratas a capacidade para confirmar as solicitudes de contas',
	'confirmaccount-maintext'         => "'''Esta páxina é usada para confirmar as súas solicitudes de conta pendentes en ''{{SITENAME}}''.'''

Cada cola de solicitudes de conta consiste en tres subcuestións, unha para abrila, outra para aquelas que fosen postas por outros administradores en espera de máis información e unha última para as solicitudes rexeitadas recentemente. 

Ao respostar unha solicitude revísea con coidado e, se é necesario, confirme a información alí contida.  
As súas accións serán rexistradas de maneira privada.
Agárdase tamén que revise calquera actividade que teña lugar aquí á parte das súas propias.",
	'confirmaccount-list'             => 'Abaixo aparece unha listaxe de contas pendentes de aprobación.
	As contas aprobadas crearanse e eliminaranse desta listaxe. As contas rexeitadas simplemente eliminaranse desta listaxe.',
	'confirmaccount-list2'            => 'Abaixo aparece unha listaxe con solicitudes de contas rexeitadas recentemente que poden eliminarse automaticamente
	unha vez que teñan varios días. Poden aínda ser aceptadas como contas, aínda que pode ser mellor que consulte primeiro
	co administrador que as rexeitou antes de facelo.',
	'confirmaccount-list3'            => 'Embaixo hai unha lista coas solicitudes de contas que caducaron e que poden ser borradas automaticamente unha vez que teñan uns días.
Aínda poden ser aprobadas como contas.',
	'confirmaccount-text'             => "Esta é unha solicitude pendente dunha conta de usuario en '''{{SITENAME}}'''.

Examine coidadosamente a información de embaixo. Se está de acordo con esta solicitude, seleccione no despregable a posición para fixar o status da conta do usuario.
As edicións feitas na biografía da solicitude non afectarán a calquera almacenamento de credenciais permanente. Observe que pode escoller, se quere, crear unha conta cun nome de usuario diferente.
Use isto só para evitar conflitos con outros nomes.

Se simplemente deixa esta páxina sen confirmar ou rexeitar esta solicitude, quedará como pendente.",
	'confirmaccount-none-o'           => 'Neste momento non hai peticións de contas pendentes nesta listaxe.',
	'confirmaccount-none-h'           => 'Actualmente non hai solicitudes pendentes a ter en conta nesta listaxe.',
	'confirmaccount-none-r'           => 'Actualmente non hai contas rexeitas recentemente nesta listaxe.',
	'confirmaccount-none-e'           => 'Actualmente non hai solicitudes de contas caducadas nesta listaxe.',
	'confirmaccount-real-q'           => 'Nome',
	'confirmaccount-email-q'          => 'Correo electrónico',
	'confirmaccount-bio-q'            => 'Biografía',
	'confirmaccount-showopen'         => 'solicitudes en curso',
	'confirmaccount-showrej'          => 'solicitudes rexeitadas',
	'confirmaccount-showheld'         => 'Ver as contas pendentes de ter en conta na listaxe',
	'confirmaccount-showexp'          => 'solicitudes que expiraron',
	'confirmaccount-review'           => 'Revisar',
	'confirmaccount-types'            => 'Seleccione unha cola de confirmación de contas de embaixo:',
	'confirmaccount-all'              => '(mostrar todas as colas)',
	'confirmaccount-type'             => 'Cola seleccionada:',
	'confirmaccount-type-0'           => 'autores potenciais',
	'confirmaccount-type-1'           => 'editores potenciais',
	'confirmaccount-q-open'           => 'solicitudes abertas',
	'confirmaccount-q-held'           => 'solicitudes suspendidas',
	'confirmaccount-q-rej'            => 'solicitudes recentemente rexeitadas',
	'confirmaccount-q-stale'          => 'solicitudes expiradas',
	'confirmaccount-badid'            => 'Non existe unha solicitude pendente que corresponda co ID fornecido. Pode que xa fose examinada.',
	'confirmaccount-leg-user'         => 'Conta de usuario',
	'confirmaccount-leg-areas'        => 'Principais áreas de interese',
	'confirmaccount-leg-person'       => 'Información persoal',
	'confirmaccount-leg-other'        => 'Outra información',
	'confirmaccount-name'             => 'Nome de usuario',
	'confirmaccount-real'             => 'Nome:',
	'confirmaccount-email'            => 'Correo electrónico:',
	'confirmaccount-reqtype'          => 'Posición:',
	'confirmaccount-pos-0'            => 'autor',
	'confirmaccount-pos-1'            => 'editor',
	'confirmaccount-bio'              => 'Biografía:',
	'confirmaccount-attach'           => 'Curriculum Vitae:',
	'confirmaccount-notes'            => 'Notas adicionais:',
	'confirmaccount-urls'             => 'Listaxe de sitios web:',
	'confirmaccount-none-p'           => '(non fornecido)',
	'confirmaccount-confirm'          => 'Use os botóns de embaixo para aceptar, rexeitar ou deixar en suspenso esta solicitude:',
	'confirmaccount-econf'            => '(confirmada)',
	'confirmaccount-reject'           => '(rexeitada por [[User:$1|$1]] en $2)',
	'confirmaccount-rational'         => 'Explicación dada ao solicitante:',
	'confirmaccount-noreason'         => '(ningún)',
	'confirmaccount-autorej'          => '(esta solicitude foi descartada automaticamente debido á inactividade)',
	'confirmaccount-held'             => '(marcada "en suspenso" por [[User:$1|$1]] en $2)',
	'confirmaccount-create'           => 'Aceptar (crear a conta)',
	'confirmaccount-deny'             => 'Rexeitar (eliminar da listaxe)',
	'confirmaccount-hold'             => 'Suspender',
	'confirmaccount-spam'             => 'Spam (non enviar correo electrónico)',
	'confirmaccount-reason'           => 'Comentario (incluirase na mensaxe de correo electrónico):',
	'confirmaccount-ip'               => 'Enderezo IP:',
	'confirmaccount-submit'           => 'Confirmar',
	'confirmaccount-needreason'       => 'Debe incluír un motivo na caixa de comentarios de embaixo.',
	'confirmaccount-canthold'         => 'Esta solicitude está en espera ou foi borrada.',
	'confirmaccount-acc'              => 'Confirmouse sen problemas a solicitude de conta; creouse a nova conta de usuario [[User:$1]].',
	'confirmaccount-rej'              => 'Rexeitouse sen problemas a solicitude de conta.',
	'confirmaccount-viewing'          => '(actualmente sendo visto por [[User:$1|$1]])',
	'confirmaccount-summary'          => 'A crear a páxina de usuario coa biografía do novo usuario.',
	'confirmaccount-welc'             => "'''Reciba a benvida a ''{{SITENAME}}''!''' Esperamos que contribúa moito e ben.
Quizais queira ler as [[{{MediaWiki:Helppage}}|páxinas de axuda]]. De novo, reciba a nosa benvida e divírtase!",
	'confirmaccount-wsum'             => 'Reciba a nosa benvida!',
	'confirmaccount-email-subj'       => 'solicitude de conta en {{SITENAME}}',
	'confirmaccount-email-body'       => 'Aprobouse a súa solicitude de conta en {{SITENAME}}.

Nome da conta: $1

Contrasinal: $2

Por razóns de seguranza terá que mudar o contrasinal a primeira vez que se rexistre. Para rexistrarse,
vaia a {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Aprobouse a súa solicitude de conta en {{SITENAME}}.

Nome da conta: $1

Contrasinal: $2

$3

Por razóns de seguranza terá que mudar o contrasinal a primeira vez que se rexistre. Para rexistrarse,
vaia a {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Sentímolo, pero a súa solicitude de conta $1 foi rexeitada en {{SITENAME}}.

Isto pode deberse a varias causas. Pode que non enchese o formulario correctamente, non respondese na extensión
adecuada ou non cumprise con algún outro criterio. Pode que existan listaxes de contacto no sitio que poida
usar se quere saber máis acerca da política de contas de usuario.',
	'confirmaccount-email-body4'      => 'Sentímolo, pero a súa solicitude de conta "$1" foi rexeitada en {{SITENAME}}.

$2

Poden existir listaxes de contacto no sitio que pode usar se quere saber máis acerca da política de contas de usuario.',
	'confirmaccount-email-body5'      => 'Antes de que se poida aceptar a súa solicitude dunha conta para "$1" en {{SITENAME}}
	ten que fornecer algunha información adicional.

$2

Poden existir listaxes de contacto no sitio que poida usar se quere saber máis acerca da nosa política de contas de usuario.',
	'usercredentials'                 => 'Credenciais do usuario',
	'usercredentials-leg'             => 'Verificar os credenciais confirmados dun usuario',
	'usercredentials-user'            => 'Nome do usuario:',
	'usercredentials-text'            => 'Embaixo están os credenciais validos das contas de usuario seleccionadas.',
	'usercredentials-leg-user'        => 'Conta de usuario',
	'usercredentials-leg-areas'       => 'Principais áreas de interese',
	'usercredentials-leg-person'      => 'Información persoal',
	'usercredentials-leg-other'       => 'Outra información:',
	'usercredentials-email'           => 'Correo electrónico:',
	'usercredentials-real'            => 'Nome real:',
	'usercredentials-bio'             => 'Biografía:',
	'usercredentials-attach'          => 'Currículo/CV:',
	'usercredentials-notes'           => 'Notas adicionais:',
	'usercredentials-urls'            => 'Listaxe de sitios web:',
	'usercredentials-ip'              => 'Enderezo IP orixinal:',
	'usercredentials-member'          => 'Dereitos:',
	'usercredentials-badid'           => 'Non se atoparon credenciais para este usuario. Comprobe que o nome estea escrito correctamente.',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author Aksi great
 */
$messages['gu'] = array(
	'requestaccount-real'    => 'સાચુ નામ:',
	'confirmaccount-summary' => 'નવા સભ્યનાં જીવન વુત્તાંત વાળું સભ્યનું પાનું બનાવી રહ્યા છો',
	'confirmaccount-wsum'    => 'સુસ્વાગતમ્',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'requestaccount-leg-user'    => 'Coontys yn ymmydeyr',
	'requestaccount-leg-person'  => 'Oayllys persoonagh',
	'requestaccount-leg-other'   => 'Oayllys elley',
	'requestaccount-real'        => 'Feer-ennym:',
	'requestaccount-email'       => 'Enmys post-L:',
	'requestaccount-level-0'     => 'ughtar',
	'requestaccount-level-1'     => 'reagheyder',
	'requestaccount-bio'         => 'Beashnys persoonagh:',
	'requestaccount-notes'       => 'Noteyn tooilley:',
	'confirmaccount-real-q'      => 'Ennym',
	'confirmaccount-email-q'     => 'Post-L',
	'confirmaccount-bio-q'       => 'Beashnys',
	'confirmaccount-all'         => '(dagh ooilley amman y haishbyney)',
	'confirmaccount-type'        => 'Famman:',
	'confirmaccount-leg-user'    => 'Coontys ymmydeyr',
	'confirmaccount-leg-person'  => 'Oayllys persoonagh',
	'confirmaccount-leg-other'   => 'Oayllys elley',
	'confirmaccount-name'        => "Dt'ennym ymmydeyr",
	'confirmaccount-real'        => 'Ennym:',
	'confirmaccount-email'       => 'Post-L:',
	'confirmaccount-pos-0'       => 'ughtar',
	'confirmaccount-pos-1'       => 'reagheyder',
	'confirmaccount-bio'         => 'Beashnys:',
	'confirmaccount-urls'        => 'Rolley ynnydyn-eggey:',
	'confirmaccount-ip'          => 'Enmys IP:',
	'confirmaccount-wsum'        => 'Failt ort!',
	'usercredentials-user'       => "Dt'ennym ymmydeyr:",
	'usercredentials-leg-user'   => 'Coontys ymmydeyr',
	'usercredentials-leg-person' => 'Oayllys persoonagh',
	'usercredentials-leg-other'  => 'Oayllys elley',
	'usercredentials-email'      => 'Post-L:',
	'usercredentials-real'       => 'Feer-ennym:',
	'usercredentials-bio'        => 'Beashnys:',
	'usercredentials-urls'       => 'Rolley ynnydyn-eggey:',
	'usercredentials-ip'         => 'Enmys IP bunneydagh:',
	'usercredentials-member'     => 'Kiartyn:',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'requestaccount-level-1' => 'luna',
	'confirmaccount-real-q'  => 'Inoa',
	'confirmaccount-real'    => 'Inoa:',
	'confirmaccount-pos-1'   => 'luna',
);

/** Hebrew (עברית)
 * @author StuB
 * @author Rotemliss
 * @author Siebrand
 */
$messages['he'] = array(
	'requestaccount'            => 'בקשת חשבון',
	'requestaccount-text'       => "'''מלאו והשלימו את הטופס הבא כדי לבקש חשבון המשתמש'''.

לפני שאתם מבקשים חשבון, אנא ודאו כי קראתם קודם את [[{{MediaWiki:Requestaccount-page}}|תנאי השירות]].

כשהחשבון יאושר, תישלח אליכם הודעה בדואר האלקטרוני ותוכלו להפעיל את החשבון באמצעות [[Special:Userlogin]].",
	'requestaccount-dup'        => "'''הערה: אתם כבר מחוברים עם חשבון רשום.'''",
	'confirmaccount-submit'     => 'אישור',
	'confirmaccount-needreason' => 'יש לספק סיבה בתיבת התגובה למטה.',
	'confirmaccount-canthold'   => 'בקשה זו כבר נמצאת בהמתנה או מחוקה.',
	'confirmaccount-acc'        => 'בקשת החשבון אושרה בהצלחה; נוצר חשבון משתמש חדש [[User:$1]].',
	'confirmaccount-rej'        => 'בקשת החשבון נדחתה בהצלחה.',
	'confirmaccount-viewing'    => '(הבקשה נצפית כרגע בידי [[User:$1|$1]])',
	'confirmaccount-summary'    => 'יצירת דף משתמש עם ביוגרפיה של משתמש חדש',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'requestaccount'                  => 'खाता मंगायें',
	'requestaccount-page'             => '{{ns:project}}:शर्तें और नियम',
	'requestaccount-dup'              => "'''सूचना: आपने पहले से पंजीकृत खाते से लॉग इन किया हुआ हैं।'''",
	'requestaccount-leg-user'         => 'सदस्य खाता',
	'requestaccount-leg-areas'        => 'मुख्य पसंद',
	'requestaccount-leg-person'       => 'वैयक्तिक ज़ानकारी',
	'requestaccount-leg-other'        => 'अन्य ज़ानकारी',
	'requestaccount-areas-text'       => 'नीचे दिये हुए विषयोंसे आपके पसंदके तथा आप जिसमें माहिर हैं ऐसे विषय चुनें।',
	'requestaccount-real'             => 'असली नाम:',
	'requestaccount-same'             => '(असली नाम ही हैं)',
	'requestaccount-email'            => 'इ-मेल एड्रेस:',
	'requestaccount-reqtype'          => 'पोज़िशन:',
	'requestaccount-level-0'          => 'लेखक',
	'requestaccount-level-1'          => 'संपादक',
	'requestaccount-bio'              => 'वैयक्तिक चरित्र:',
	'requestaccount-attach'           => 'रिज़्यूम या सीव्ही (वैकल्पिक):',
	'requestaccount-notes'            => 'अधिक ज़ानकारी:',
	'requestaccount-urls'             => 'वेबसाईट्स की सूची, अगर हैं तो (एक लाईनमें एक):',
	'requestaccount-agree'            => 'आपने दिया हुआ खुद का असली नाम सहीं हैं और आपको शर्ते और नियम मान्य हैं ऐसा सर्टिफाई करें।',
	'requestaccount-inuse'            => 'आपने दिया हुआ सदस्यनाम पहले ही किसीने पूछा हैं।',
	'requestaccount-tooshort'         => 'आपके वैयक्तिक चरित्र में कमसे कम $1 शब्द होना जरूरी हैं।',
	'requestaccount-emaildup'         => 'एक अन्य पूरी न हुई माँगमें यह इ-मेल एड्रेस दिया हुआ हैं।',
	'requestaccount-exts'             => 'जोडे हुए फ़ाइल का प्रकार अवैध हैं।',
	'requestaccount-submit'           => 'खाता मंगायें',
	'requestaccount-sent'             => 'आपकी खाता खोलने की माँग पंजिकृत हो गई हैं और अब इसे फिरसे परखने के लिये रखा गया हैं।',
	'request-account-econf'           => 'आपका इ-मेल एड्रेस प्रमाणित हो गया है और इसे अब आपकी खाता खोलेने की माँग में दर्ज कर दिया गया हैं।',
	'requestaccount-email-subj'       => '{{SITENAME}} इमेल एड्रेस प्रमाणिकरण',
	'requestaccount-email-subj-admin' => '{{SITENAME}} खाता खोलने की माँग',
	'requestaccount-loginnotice'      => "सदस्य खाता पाने के लिये आप अपनी '''[[Special:RequestAccount|माँग पंजिकृत करें]]'''।",
	'confirmaccounts'                 => 'खाते की माँग निश्चित करें',
	'confirmedit-desc'                => 'ब्युरोक्रैट्स को खाते की माँग निश्चित करने की सुविधा देती हैं',
	'confirmaccount-none-o'           => 'इस सूचीमें अभी एक भी प्रलंबित खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-none-h'           => 'इस सूचीमें अभी एक भी प्रलंबित रखी हुई खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-none-r'           => 'इस सूचीमें अभी एक भी रिजेक्ट की हुई खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-none-e'           => 'इस सूचीमें अभी एक भी समाप्त हुई खाता खोलने की माँग नहीं हैं।',
	'confirmaccount-real-q'           => 'नाम',
	'confirmaccount-email-q'          => 'इ-मेल',
	'confirmaccount-bio-q'            => 'चरित्र',
	'confirmaccount-showopen'         => 'प्रलंबित माँगे',
	'confirmaccount-showrej'          => 'रिजेक्ट की हुई माँगे',
	'confirmaccount-showheld'         => 'प्रलंबित रखी हुई माँगे',
	'confirmaccount-showexp'          => 'समाप्त हुई माँगे',
	'confirmaccount-review'           => 'अवलोकन',
	'confirmaccount-types'            => 'नीचे से एक खाता निश्चिती कतार चुनें:',
	'confirmaccount-all'              => '(सभी कतारें दर्शायें)',
	'confirmaccount-type'             => 'कतार:',
	'confirmaccount-type-0'           => 'प्रोस्पेक्टिव लेखक',
	'confirmaccount-type-1'           => 'प्रोस्पेक्टिव संपादक',
	'confirmaccount-q-open'           => 'प्रलंबित माँगे',
	'confirmaccount-q-held'           => 'प्रलंबित रखी हुई माँगे',
	'confirmaccount-q-rej'            => 'हाल में अस्वीकृत माँगे',
	'confirmaccount-q-stale'          => 'समाप्त हुई माँगे',
	'confirmaccount-badid'            => 'दिये हुए ID से मिलनेवाली माँग मिली नहीं।
शायद वह पहले से देखी गई हो।',
	'confirmaccount-leg-user'         => 'सदस्य खाता',
	'confirmaccount-leg-areas'        => 'मुख्य पसंद',
	'confirmaccount-leg-person'       => 'वैयक्तिक ज़ानकारी',
	'confirmaccount-leg-other'        => 'अन्य ज़ानकारी',
	'confirmaccount-name'             => 'सदस्यनाम',
	'confirmaccount-real'             => 'नाम:',
	'confirmaccount-email'            => 'इ-मेल:',
	'confirmaccount-reqtype'          => 'स्थिती:',
	'confirmaccount-pos-0'            => 'लेखक',
	'confirmaccount-pos-1'            => 'संपादक',
	'confirmaccount-bio'              => 'चरित्र:',
	'confirmaccount-attach'           => 'रिज्यूम/सीव्ही:',
	'confirmaccount-notes'            => 'अधिक ज़ानकारी:',
	'confirmaccount-urls'             => 'वेबसाईट्स की सूची:',
	'confirmaccount-none-p'           => '(दिया नहीं हैं)',
	'confirmaccount-confirm'          => 'यह माँग स्वीकारने, प्रलंबित रखने या अस्वीकृत करने के लिये नीचे दिये ओप्शन चुनें:',
	'confirmaccount-econf'            => '(निश्चित किया हुआ)',
	'confirmaccount-reject'           => '([[User:$1|$1]] ने $2 पर अस्वीकृत की)',
	'confirmaccount-rational'         => 'एप्लिकेंट को दिया हुआ कारण:',
	'confirmaccount-noreason'         => '(बिल्कुल नहीं)',
	'confirmaccount-autorej'          => '(यह माँग अकार्यक्षमता के चलते अपनेआप अस्वीकृत कर दी गई हैं)',
	'confirmaccount-held'             => '([[User:$1|$1]] ने $2 पर "प्रलंबित रखी हुई" है)',
	'confirmaccount-create'           => 'स्वीकृती (खाता खोलें)',
	'confirmaccount-deny'             => 'अस्वीकृती (सूची से हटा दें)',
	'confirmaccount-hold'             => 'प्रलंबित रख्खें',
	'confirmaccount-spam'             => 'स्पॅम (इ-मेल ना भेजें)',
	'confirmaccount-reason'           => 'टिप्पणी (इ-मेलमें मिलाया जायेगा):',
	'confirmaccount-ip'               => 'आइपी एड्रेस:',
	'confirmaccount-submit'           => 'निश्चित करें',
	'confirmaccount-needreason'       => 'आपको नीचे दिये हुए टिप्पणी बक्सेमें टिप्पणी देना बंधनकारक हैं।',
	'confirmaccount-canthold'         => 'यह माँग पहले से ही प्रलंबित रखी या अस्वीकृत की गई हैं।',
	'confirmaccount-acc'              => 'खाते की माँग पूरी हो गई, [[User:$1]] यह नया खाता खोल दिया गया हैं।',
	'confirmaccount-rej'              => 'खाते की माँग अस्वीकृत कर दी गई हैं।',
	'confirmaccount-viewing'          => '([[User:$1|$1]] ने ध्यान रखा हैं)',
	'confirmaccount-summary'          => 'नये सदस्य के चरित्र के अनुसार सदस्य पृष्ठ बना रहें हैं।',
	'confirmaccount-wsum'             => 'सुस्वागतम्‌!',
	'confirmaccount-email-subj'       => '{{SITENAME}} खाता माँग',
	'usercredentials'                 => 'सदस्य के क्रेडेन्शियल्स',
	'usercredentials-leg'             => 'सदस्यके प्रमाणित किये हुए क्रेडेन्शियल्स देखें',
	'usercredentials-user'            => 'सदस्यनाम:',
	'usercredentials-text'            => 'नीचे चुने हुए सदस्य खाते के प्रमाणित किये हुए क्रेडेन्शियल्स दिये हुए हैं।',
	'usercredentials-leg-user'        => 'सदस्य खाता',
	'usercredentials-leg-areas'       => 'पसंद के मुख्य एरिया',
	'usercredentials-leg-person'      => 'वैयक्तिक ज़ानकारी',
	'usercredentials-leg-other'       => 'अन्य ज़ानकारी',
	'usercredentials-email'           => 'इ-मेल:',
	'usercredentials-real'            => 'असली नाम:',
	'usercredentials-bio'             => 'चरित्र:',
	'usercredentials-attach'          => 'रिज़्यूम/सीवी:',
	'usercredentials-notes'           => 'अधिक ज़ानकारी:',
	'usercredentials-urls'            => 'वेबसाईट्स की सूची:',
	'usercredentials-ip'              => 'मूल आईपी एड्रेस:',
	'usercredentials-member'          => 'अधिकार:',
	'usercredentials-badid'           => 'इस सदस्य के क्रेडेन्शियल्स मिले नहीं।
सदस्यनाम सही हैं इसकी जाँच करें।',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name'    => 'Ngalan sang Manog-gamit',
	'confirmaccount-email'   => 'E-mail:',
	'usercredentials-user'   => 'Ngalan sang Manog-gamit:',
	'usercredentials-email'  => 'E-mail:',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 * @author Dalibor Bosits
 * @author Dnik
 */
$messages['hr'] = array(
	'requestaccount'                  => 'Zatraži suradnički račun',
	'requestaccount-text'             => "'''Ispunite sljedeći formular i pošaljite ga da bi zatražili suradnički račun'''.

Pročitajte [[{{MediaWiki:Requestaccount-page}}|Uvjete uporabe]] prije traženja suradničkog računa.

Kad vam račun bude odobren, dobit ćete e-mail potvrdu i moći ćete se [[Special:Userlogin|prijaviti]].",
	'requestaccount-page'             => '{{ns:project}}:Uvjeti korištenja',
	'requestaccount-dup'              => "'''Već ste prijavljeni!'''",
	'requestaccount-leg-user'         => 'Suradnički račun',
	'requestaccount-leg-areas'        => 'Glavni interesi',
	'requestaccount-leg-person'       => 'Osobni podaci',
	'requestaccount-leg-other'        => 'Ostali podaci',
	'requestaccount-acc-text'         => "Dobiti ćete poruku elektroničkom poštom (''e-mail'') kao potvrdu da ste zatražili suradnički račun.
Molimo odgovorite na tu poruku tako što ćete kliknuti na poveznicu (''link'') u toj poruci.
Kad vam račun bude odobren/otvoren, lozinku ćete dobiti elektroničkom poštom.",
	'requestaccount-ext-text'         => 'Sljedeći podaci nisu dostupni drugima, rabe se samo u ovom upitu. 
Možda želite navesti broj telefona (mobitela) kao pomoć za potvrđivanje vašeg identiteta.',
	'requestaccount-bio-text'         => 'Vaša biografija će biti postavljena na vašu suradničku stranicu. 
Pokušajte napisati nešto o sebi. 
Ne pišite osjetljive informacije. 
Ime je moguće promijeniti putem [[Special:Preferences|postavki]].',
	'requestaccount-real'             => 'Pravo ime:',
	'requestaccount-same'             => '(bit će isto kao i pravo ime)',
	'requestaccount-email'            => "Adresa e-pošte (vaš ''e-mail''):",
	'requestaccount-reqtype'          => 'Mjesto:',
	'requestaccount-bio'              => 'Osobna biografija:',
	'requestaccount-notes'            => 'Dodatne bilješke:',
	'requestaccount-urls'             => 'Popis web stranica, ako ih ima (odvojite ih redom):',
	'requestaccount-agree'            => 'Morate potvrditi da je vaše pravo ime točno i da pristajete na naše Uvjete korištenja.',
	'requestaccount-inuse'            => 'Suradničko ime je već u upotrebi u otvorenom zahtjevu.',
	'requestaccount-tooshort'         => 'Biografija mora biti od najmanje $1 riječi.',
	'requestaccount-emaildup'         => 'Drugi otvoreni zahtjev ima istu e-mail adresu.',
	'requestaccount-exts'             => 'Vrsta datoteke u privitku nije dopuštena.',
	'requestaccount-resub'            => 'Vaš CV/rezime mora biti opet odabran iz sigurnosnih razloga. Ostavite polje praznim ako ga ne želite uključiti.',
	'requestaccount-tos'              => 'Pročitao sam i slažem se s [[{{MediaWiki:Requestaccount-page}}|Uvjetima uporabe]] internetskih stranica {{SITENAME}}.
Ime koje sam napisao kao "Pravo ime" je moje pravo ime (nije nadimak/alias).',
	'requestaccount-submit'           => 'Zatraži račun',
	'requestaccount-sent'             => 'Vaš zahtjev je uspješno poslan i sada čeka potvrdu.',
	'request-account-econf'           => 'Vaša e-mail adresa je potvrđena i bit će tako označena u vašem zahtjevu.',
	'requestaccount-email-subj'       => '{{SITENAME}} potvrda e-mail adrese',
	'requestaccount-email-body'       => 'Netko, vjerojatno s vaše IP adrese $1, je zatražio račun "$2" s ovom e-mail adresom na {{SITENAME}}.

Kako biste potvrdili da ovaj račun zaista pripada vama na {{SITENAME}}, otvorite ovaj link u svom pretraživaču:

$3

Ako se račun otvori, samo vama će biti poslana lozinka.
Ako ovo *niste* vi, nemojte otvarati link.
Ovaj potvrdni kod će isteći $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} zahtjev suradničkog računa',
	'requestaccount-email-body-admin' => '"$1" je zatražio suradnički račun i čeka potvrdu.
E-mail adresa je potvrđena. Možete potvrditi zahtjev ovdje "$2".',
	'acct_request_throttle_hit'       => 'Žao nam je, već ste zatražili suradnički račun $1. Ne možete zatražiti nove.',
	'requestaccount-loginnotice'      => "Da bi dobili suradnički račun, trebate ga '''[[Special:RequestAccount|zatražiti]]'''.",
	'confirmaccounts'                 => 'Potvrdi zahtjeve za suradničkim računom',
	'confirmedit-desc'                => 'Daje birokratima pravo potvrditi zahtjeve za suradničkim računom',
	'confirmaccount-none-o'           => 'Trenutačno nema otvorenih zahtjeva na ovom popisu.',
	'confirmaccount-none-h'           => 'Nema zahtjeva u popisu čekanja.',
	'confirmaccount-none-r'           => 'Nema nedavno odbijenih zahtjeva na popisu.',
	'confirmaccount-none-e'           => 'Trenutačno nema isteklih zahtjeva na ovom popisu.',
	'confirmaccount-real-q'           => 'Ime',
	'confirmaccount-email-q'          => 'E-pošta (e-mail)',
	'confirmaccount-bio-q'            => 'Biografija',
	'confirmaccount-showopen'         => 'otvorenih zahtjeva',
	'confirmaccount-showrej'          => 'odbijenih zahtjeva',
	'confirmaccount-showheld'         => 'Vidi popis zahtjeva na čekanju',
	'confirmaccount-showexp'          => 'zastarjelih zahtjeva',
	'confirmaccount-review'           => 'Potvrdi/odbij',
	'confirmaccount-types'            => 'Odaberite red potvrđivanja računa:',
	'confirmaccount-all'              => '(prikaži sve redove)',
	'confirmaccount-type'             => 'Red:',
	'confirmaccount-q-open'           => 'neodgovoreni zahtjevi',
	'confirmaccount-q-held'           => 'zahtjevi na čekanju',
	'confirmaccount-q-rej'            => 'nedavno odbijeni zahtjevi',
	'confirmaccount-q-stale'          => 'istekli zahtjevi',
	'confirmaccount-badid'            => 'Nema zahtjeva koji ima dani ID. Najvjerojatnije je zahtjev već obrađen.',
	'confirmaccount-leg-user'         => 'Suradnički račun',
	'confirmaccount-leg-areas'        => 'Glavne grane interesa',
	'confirmaccount-leg-person'       => 'Osobne informacije',
	'confirmaccount-leg-other'        => 'Ostale informacije',
	'confirmaccount-name'             => 'Suradničko ime',
	'confirmaccount-real'             => 'Ime:',
	'confirmaccount-email'            => "E-pošta (''e-mail''):",
	'confirmaccount-reqtype'          => 'Mjesto:',
	'confirmaccount-pos-0'            => 'autor',
	'confirmaccount-pos-1'            => 'urednik',
	'confirmaccount-bio'              => 'Biografija:',
	'confirmaccount-attach'           => 'Biografija/CV:',
	'confirmaccount-notes'            => 'Dodatne bilješke:',
	'confirmaccount-urls'             => 'Popis web stranica:',
	'confirmaccount-none-p'           => '(nije naveden)',
	'confirmaccount-confirm'          => 'Koristite opcije ispod za potvrditi, odbiti ili staviti na čekanje ovaj zahtjev.',
	'confirmaccount-econf'            => '(potvrđen)',
	'confirmaccount-reject'           => '(zahtjev odbio [[User:$1|$1]] dana $2)',
	'confirmaccount-noreason'         => '(ništa)',
	'confirmaccount-autorej'          => '(ovaj zahtjev je automatski odbačen zbog neaktivnosti)',
	'confirmaccount-held'             => '(označio "na čekanju" suradnik [[User:$1|$1]], $2)',
	'confirmaccount-create'           => 'Prihvati zahtjev (otvori suradnički račun)',
	'confirmaccount-deny'             => 'Odbij (i skini s popisa)',
	'confirmaccount-hold'             => 'Zadrži',
	'confirmaccount-spam'             => 'Spam (ne šalji e-mail)',
	'confirmaccount-reason'           => 'Komentar (uključen u e-mail):',
	'confirmaccount-ip'               => 'IP adresa:',
	'confirmaccount-submit'           => 'Potvrdi',
	'confirmaccount-needreason'       => 'Morate dati razlog u okviru ispod.',
	'confirmaccount-canthold'         => 'Ovaj zahtjev je već ili na čekanju ili obrisan.',
	'confirmaccount-acc'              => 'Suradnički račun je uspješno potvrđen; otvoren je novi suradnički račun [[User:$1]].',
	'confirmaccount-summary'          => 'Stvaranje suradničke stranice sa životopisom novog suradnika.',
	'confirmaccount-wsum'             => 'Dobrodošli!',
	'confirmaccount-email-subj'       => '{{SITENAME}} zahtjev suradničkog računa',
	'usercredentials-user'            => 'Suradničko ime:',
	'usercredentials-leg-user'        => 'Suradnički račun',
	'usercredentials-leg-person'      => 'Osobni podaci',
	'usercredentials-leg-other'       => 'Ostali podaci',
	'usercredentials-email'           => "E-pošta (''e-mail''):",
	'usercredentials-real'            => 'Pravo ime:',
	'usercredentials-bio'             => 'Biografija:',
	'usercredentials-attach'          => 'Rezime/CV:',
	'usercredentials-notes'           => 'Dodatne bilješke:',
	'usercredentials-urls'            => 'Popis internetskih stranica:',
	'usercredentials-ip'              => 'Izvorna IP adresa:',
	'usercredentials-member'          => 'Prava:',
	'usercredentials-badid'           => 'Za danog suradnika nisu nađeni podaci.
Provjerite je li ime točno napisano.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 * @author Siebrand
 */
$messages['hsb'] = array(
	'requestaccount'                  => 'Wužiwarske konto sej žadać',
	'requestaccount-text'             => "'''Wupjelń slědowacy formular a wotesćel jón, zo by wužiwarske konto požadał'''. 

Prošu přečitaj najprjedy [[{{MediaWiki:Requestaccount-page}}|wužiwanske wuměnjenja]], prjedy hač požadaš wužiwarske konto.

Tak ruče kaž konto je so potwjerdźiło, dóstaš powěsć přez mejlku a móžeš so pod \"[[Special:Userlogin|Konto wutworić abo so přizjewić]]\" přizjewić.",
	'requestaccount-page'             => '{{ns:project}}:Wužiwanske wuměnjenja',
	'requestaccount-dup'              => "'''Kedźbu: Sy hižo ze zregistrowanym wužiwarskim kontom přizjewjeny.'''",
	'requestaccount-leg-user'         => 'Wužiwarske konto',
	'requestaccount-leg-areas'        => 'Hłowne zajimowe wobwody',
	'requestaccount-leg-person'       => 'Wosobinske informacije',
	'requestaccount-leg-other'        => 'Druhe informacije',
	'requestaccount-acc-text'         => 'K twojej e-mejlowej adresy budźe so po wotesłanju tutoho formulara wobkrućenska mejlka słać. Prošu wotmołw na to přez kliknjenje na wobkrućenski wotkaz, kotryž mejlka wobsahuje. Tak ruče kaž twoje konto je wutworjene, so ći twoje hesło připósćele.',
	'requestaccount-areas-text'       => 'Wubjer slědowace temowe wobwody, w kotrychž maš wěcywustojnosć abo chceš najwjace dźěła činić.',
	'requestaccount-ext-text'         => 'Ze slědowacymi informacijemi so dowěrliwje wobchadźa a jenož za tute požadne wužiwa. Móžeš kontaktowe informacije, kaž na př. telefonowe čisło, podać, zo by wobdźěłowanje swojeho požadanja zjednorił.',
	'requestaccount-bio-text'         => 'Twoja biografija so jako spočatny wobsah twojeje wužiwarskeje strony składuje.
Spytaj wšě trěbne doporučenja naspomnić, ale zawěsć, zo chceš te informacije woprawdźe wozjewić.
Móžeš swoje wužiwarske mjeno pod "[[Special:Preferences|Nastajenja]]" změnić.',
	'requestaccount-real'             => 'Woprawdźite mjeno:',
	'requestaccount-same'             => '(kaž woprawdźite mjeno)',
	'requestaccount-email'            => 'E-mejlowa adresa:',
	'requestaccount-reqtype'          => 'Pozicija:',
	'requestaccount-level-0'          => 'awtor',
	'requestaccount-level-1'          => 'Wobdźěłowar',
	'requestaccount-bio'              => 'Wosobinska biografija:',
	'requestaccount-attach'           => 'Žiwjenjoběh',
	'requestaccount-notes'            => 'Přidatne podaća:',
	'requestaccount-urls'             => 'Lisćina webowych sydłow (přez linkowe łamanja wotdźělene)',
	'requestaccount-agree'            => 'Dyrbiš potwjerdźić, zo twoje woprawdźite mjeno je korektne a wužiwarske wuměnjenja akceptuješ.',
	'requestaccount-inuse'            => 'Wužiwarske mjeno so hižo w druhim kontowym požadanju wužiwa.',
	'requestaccount-tooshort'         => 'Twoja biografija dyrbi znajmjeńša $1 słowow dołho być.',
	'requestaccount-emaildup'         => 'Druhe předležace kontowe požadanje samsnu e-mejlowu adresu wužiwa.',
	'requestaccount-exts'             => 'Datajowy typ přiwěška je njedowoleny.',
	'requestaccount-resub'            => 'Twoja žiwjenjoběhowa dataja dyrbi so z přičinow wěstoty znowa wubrać. Wostaj polo prózdne, jeli hižo nochceš tajku zapřijimać.',
	'requestaccount-tos'              => 'Sym wužiwarske wuměnjenja strony {{SITENAME}} přečitał a budu do nich dźeržeć.',
	'requestaccount-submit'           => 'Wužiwarske konto sej žadać',
	'requestaccount-sent'             => 'Twoje kontowe požadanje  bu wuspěšnje wotpósłane a dyrbi so nětko přepruwować.',
	'request-account-econf'           => 'Twoja e-mejlowa adresa bu wobkrućena a budźe so w twojim kontowym požadanju nalistować.',
	'requestaccount-email-subj'       => '{{SITENAME}} Pruwowanje e-mejloweje adresy',
	'requestaccount-email-body'       => 'Něštó z IP-adresu $1, snano ty, je pola {{SITENAME}} wužiwarske konto "$2" z twojej e-mejlowej adresu požadał.

Zo by wobkrućił, zo woprawdźe ty sy tute konto pola {{SITENAME}} požadał, wočiń prošu slědowacy wotkaz we swojim wobhladowaku:

$3

Hdyž je so wužiwarske konto wutworiło, dóstanješ dalšu mejlku z hesłom.

Jeli *njej*sy wužiwarske konto požadał, njewočiń prošu tutón wotkaz!

Tutón wobkrućenski kod budźe w $4 płaciwy.',
	'requestaccount-email-subj-admin' => 'Požadanje konta za {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" je konto požadał a čaka na potwjerdźenje. E-mejlowa adresa bu potwjerdźena. Móžeš požadanje tu "$2" potwjerdźić.',
	'acct_request_throttle_hit'       => 'Sy hižo $1 wužiwarskich kontow požadał, njemóžeš sej we wokomiku dalše konta žadać.',
	'requestaccount-loginnotice'      => "Zo by wužiwarske konto dóstał, dyrbiš wo nje '''[[Special:RequestAccount|prosyć]]'''.",
	'confirmaccount-newrequests'      => "{{PLURAL:$1|Čaka|Čakatej|Čakaja|Čaka}} tuchwilu '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|kontowe požadanje]]|[[Special:ConfirmAccounts|kontowej požadani]]|[[Special:ConfirmAccounts|kontowe požadanja]]|[[Special:ConfirmAccountskontowych požadanjow]]}}.",
	'confirmaccounts'                 => 'Kontowe požadanja potwjerdźić',
	'confirmedit-desc'                => 'Dawa běrokratam móžnosć kontowe požadanja potwjerdźić',
	'confirmaccount-maintext'         => "'''Tuta strona wužiwa so, zo by njesčinjene kontowe požadanja na ''{{SITENAME}}'' potwjerdźiło'''.

Kóžde čakanski rynk kontowych požadanjow wobsteji z třoch čakanskich podrynkow, jedyn za wotewrjene požadanje, jedyn za te, kotrež buchu wot administratorow falowacych informacijow dla do čakanskeje sekle stajili a třeći za tuchwilu wotpokazane požadanja.

Wotmołwjejo na požadanje, pruwuj je starosćiwje a, jeli trjeba, potwjerdź w nim wobsahowane informacije.
Twoje akcije so protokuluja. Wot tebje so wočakuje, zo by aktiwnosć pruwował, kotraž tu wotměwa, wothladajo to, štož sam činiš.",
	'confirmaccount-list'             => 'Deleka je lisćina wužiwarskich požadanjow, kotrež čakaja na přizwolenje. Potwjerdźene konta budu so wutworjeć a z lisćiny wotstronjeć. Wotpokazane konta so prosće z lisćiny šmórnu.',
	'confirmaccount-list2'            => 'Deleka je lisćina tuchwilu wotpokazanych kontowych požadanjow, kotrež hodźa so awtomatisce po někotrych dnjach šmórnyć. Móža so hišće za konta přizwolić, byrnjež ty najprjedy administratora konsultował, kiž je wotpokaza, prjedy hač činiš to.',
	'confirmaccount-list3'            => 'Deleka je lisćina spadnjenych kontowych požadanjow, kotrež hodźa so po wjacorych dnjach awtomatisće wušmórnyć. Hodźa so hišće jako konta potwjerdźić.',
	'confirmaccount-text'             => "To je njerozsudźene požadanje za wužiwarskim kontom pola '''{{SITENAME}}'''. Pruwuj wšě deleka stejace informacije dokładnje a potwjerdź je. Prošu wobkedźbuj, zo móžeš konto, jeli trjeba, pod druhim wužiwarskim mjenom wutworić. Wužij to jenož, zo by kolizije z druhimi mjenami wobešoł.

Jeli tutu stronu prosće wopušćeš, bjeztoho zo by konto potwjerdźił abo wotpokazał, budźe požadanje njerozsudźene wostać.",
	'confirmaccount-none-o'           => 'Tuchwilu žane wotewrjene kontowe požadanja w tutej lisćinje njejsu.',
	'confirmaccount-none-h'           => 'Tuchwilu žane kontowe požadanja w tutej lisćinje w čakanskej sekli njejsu.',
	'confirmaccount-none-r'           => 'Tuchwilu žane runje wotpokazane kontowe požadanja w tutej lisćinje njejsu.',
	'confirmaccount-none-e'           => 'Tuchwilu žane spadnjene kontowe požadanja w tutej lisćinje njejsu.',
	'confirmaccount-real-q'           => 'Mjeno',
	'confirmaccount-email-q'          => 'E-mejl',
	'confirmaccount-bio-q'            => 'Biografija',
	'confirmaccount-showopen'         => 'njesčinjene požadanja',
	'confirmaccount-showrej'          => 'wotpokazane požadanja',
	'confirmaccount-showheld'         => 'Lisćina wotewrjenych kontow pokazać',
	'confirmaccount-showexp'          => 'spadnjene požadanja',
	'confirmaccount-review'           => 'Dowolić/Wotpokazać',
	'confirmaccount-types'            => 'Wubjer rynk za kontowe potwjerdźenje:',
	'confirmaccount-all'              => '(pokazaj wšě rynki)',
	'confirmaccount-type'             => 'Wubrany čakanski rynk:',
	'confirmaccount-type-0'           => 'přichodni awtorojo',
	'confirmaccount-type-1'           => 'přichodne editory',
	'confirmaccount-q-open'           => 'njesčinjene požadanja',
	'confirmaccount-q-held'           => 'čakace požadanja',
	'confirmaccount-q-rej'            => 'tuchwilu wotpokazane požadanja',
	'confirmaccount-q-stale'          => 'Spadnjene požadanja',
	'confirmaccount-badid'            => 'Tuchwilu požadane k podatemu ID. Snano bu hižo sčinjene.',
	'confirmaccount-leg-user'         => 'Wužiwarske konto',
	'confirmaccount-leg-areas'        => 'Hłowne zajimowe wobwody',
	'confirmaccount-leg-person'       => 'Wosobinske informacije',
	'confirmaccount-leg-other'        => 'Druhe informacije',
	'confirmaccount-name'             => 'Wužiwarske mjeno',
	'confirmaccount-real'             => 'Mjeno',
	'confirmaccount-email'            => 'E-mejl',
	'confirmaccount-reqtype'          => 'Pozicija:',
	'confirmaccount-pos-0'            => 'awtor',
	'confirmaccount-pos-1'            => 'Wobdźěłowar',
	'confirmaccount-bio'              => 'Biografija',
	'confirmaccount-attach'           => 'Žiwjenjoběh:',
	'confirmaccount-notes'            => 'Přidatne přispomnjenki:',
	'confirmaccount-urls'             => 'Lisćina webowych sydłow:',
	'confirmaccount-none-p'           => '(njepodaty)',
	'confirmaccount-confirm'          => 'Wužij tłóčatka deleka, zo by požadanje akceptował abo wotpokazał.',
	'confirmaccount-econf'            => '(potwjerdźene)',
	'confirmaccount-reject'           => '(wot [[Wužiwar:$1|$1]] na $2 wotpokazany)',
	'confirmaccount-rational'         => 'Rozjasnjenje požadarjej:',
	'confirmaccount-noreason'         => '(žane)',
	'confirmaccount-autorej'          => '(tute požadanje bu inaktiwnosće dla awtomatisce zaćisnjene)',
	'confirmaccount-held'             => '(wot [[User:$1|$1]] on $2 jako "čakacy" markěrowany)',
	'confirmaccount-create'           => 'Akceptować (Konto wutworić)',
	'confirmaccount-deny'             => 'Wotpokazać (Požadanje wotstronić)',
	'confirmaccount-hold'             => 'Čakać dać',
	'confirmaccount-spam'             => 'Spam (njesćel mejlku)',
	'confirmaccount-reason'           => 'Komentar (budźe so do mejlki k próstwarjej zasunyć):',
	'confirmaccount-ip'               => 'IP-adresa',
	'confirmaccount-submit'           => 'Potwjerdźić',
	'confirmaccount-needreason'       => 'Dyrbiš deleka w komentarowym polu přičinu podać.',
	'confirmaccount-canthold'         => 'Tute požadanje je pak hižo čakanskej sekli pak wušmórnjene.',
	'confirmaccount-acc'              => 'Požadanje za kontom bu wuspěšnje wobkrućene; konto za wužiwarja [[User:$1]] bu wutworjene.',
	'confirmaccount-rej'              => 'Požadanje za kontom bu wotpokazane.',
	'confirmaccount-viewing'          => '(wobhladuje so runje wot [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Wutworja so wužiwarska strona z biografiju noweho wužiwarja.',
	'confirmaccount-welc'             => "'''Witaj do ''{{SITENAME}}''!'''
Nadźijemy so, zo dodaš wjele dobrych přinoškow.
Snano chceš najprjedy [[Pomoc:Prěnje kroki|Prěnje kroki]] čitać.
Hišće raz: Witaj a wjele wjesela!",
	'confirmaccount-wsum'             => 'Witaj!',
	'confirmaccount-email-subj'       => '{{SITENAME}} Požadanje za wužiwarskim kontom',
	'confirmaccount-email-body'       => 'Twoje požadanje za wužiwarskim kontom bu na {{SITENAME}} schwalene.

Wužiwarske mjeno: $1

Hesło: $2

Z přičinow wěstoty, měł ty swoje hesło při prěnim přizjewjenju na kóždy pad změnić. Zo by přizjewił, dźi přosu na stronu {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Twoje požadanje za wužiwarskim kontom pola {{SITENAME}} bu schwalene.

Wužiwarske mjeno: $1

Hesło: $2

$3

Z přičinow wěstoty měł ty swoje hesło při prěnim přizjewjenu nak kóďy pad změnić. Zo by přizjewil, dźi prošu na stronu {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Bohužel bu twoje požadanje za wužiwarskim kontom "$1" pola {{SITENAME}} wotpokazane.

To móže wjele přičinow měć. Snano njejsy formular korektnje wupjelnił, njejsy dosć podaćow činił abo njejsy druhe kriterije spjelnił.

Snano je na stronje kontaktowe adresy, na kotrež móžeš so wobroćić, jeli chceš wjace wo žadanjach wědźeć.',
	'confirmaccount-email-body4'      => 'Bohužel bu twoje požadanje za wužiwarskim kontom "$1" na {{SITENAME}} wotpokazane.

$2

Snano su na sydle kontaktowe adresy, na kotrež so móžeš wobroćeć, jeli chceš wjace wo žadanjach wužiwarskich kontow wědźeć.',
	'confirmaccount-email-body5'      => 'Prjedy hač konto "$1" požadaš, kotrež hodźi so na {{SITENAME}} akceptować, dyrbiš najprjedy někotre přidatne informacije podać.

$2

Snano su kontaktowe lisćiny na sydle, kotrež móžeš wužiwać, jeli chceš wjace wo prawidłach za wužiwarske konta wědźeć.',
	'usercredentials'                 => 'Wužiwarske daty',
	'usercredentials-leg'             => 'Pytanje potwjerdźi daty za wužiwarja',
	'usercredentials-user'            => 'Wužiwarske mjeno',
	'usercredentials-text'            => 'Deleka su přepruwowane daty wubraneho wužiwarskeho konta.',
	'usercredentials-leg-user'        => 'Wužiwarske konto',
	'usercredentials-leg-areas'       => 'Hłowne zajimowe wobwody',
	'usercredentials-leg-person'      => 'Wosobinske informacije',
	'usercredentials-leg-other'       => 'Druhe informacije',
	'usercredentials-email'           => 'E-mejl:',
	'usercredentials-real'            => 'Woprawdźite mjeno:',
	'usercredentials-bio'             => 'Biografija:',
	'usercredentials-attach'          => 'Žiwjenjoběh:',
	'usercredentials-notes'           => 'Přidatne přispomnjenki:',
	'usercredentials-urls'            => 'Lisćina websydłow:',
	'usercredentials-ip'              => 'Originalna IP-adresa:',
	'usercredentials-member'          => 'Prawa:',
	'usercredentials-badid'           => 'Žane daty za tutoho wužiwarja namakane. Kontroluj, hač mjeno je prawje napisane.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dorgan
 * @author Tgr
 */
$messages['hu'] = array(
	'requestaccount'                  => 'Felhasználói fiók kérése',
	'requestaccount-text'             => "'''Az alábbi űrlap kitöltésével kérhetsz felhasználói fiókot'''.  

Mindenek előtt olvasd el a [[{{MediaWiki:Requestaccount-page}}|használat feltételeit]].

Ha a felhasználói fiókodat elfogadjuk, értesítve leszel e-mailben, ezután beléphetsz vele a [[Special:Userlogin|bejelentkezés]] lapon.",
	'requestaccount-page'             => '{{ns:project}}:Használati feltételek',
	'requestaccount-dup'              => "'''Megjegyzés: már be vagy jelentkezve egy regisztrált felhasználói fiókkal.'''",
	'requestaccount-leg-user'         => 'Felhasználói fiók',
	'requestaccount-leg-areas'        => 'Érdeklődési területek',
	'requestaccount-leg-person'       => 'Személyes információ',
	'requestaccount-leg-other'        => 'További információ',
	'requestaccount-acc-text'         => 'Miután elküldted a kérelmet, egy e-mail üzenetet küldünk a címedre. Kattints a benne található
megerősítő linkre. Miután felhasználói fiókod elkészült, jelszavadat is elküldjük.',
	'requestaccount-areas-text'       => 'Válaszd ki azokat a témaköröket, amelyek területén szaktudással rendelkezel vagy dolgozni szeretnél főként.',
	'requestaccount-ext-text'         => 'A következő információ titkos marad, és csak a kérelem során lesz használva.
Megadhatsz kapcsolati adatokat, pl. telefonszámot, hogy segíts a személyazonosságod megerősítésében.',
	'requestaccount-bio-text'         => 'Az életrajzod lesz a felhasználói lapod alapértelmezett tartalma. Próbálj meg a bizonyítványokat is belefoglalni. Győződj meg arról, hogy tényleg közzé szeretnéd-e tenni ezeket az információkat. A nevedet megváltoztathatod a [[Special:Preferences|beállításaim]] lapon.',
	'requestaccount-real'             => 'Valódi név:',
	'requestaccount-same'             => '(ugyanaz, mint a valódi név)',
	'requestaccount-email'            => 'E-mail cím:',
	'requestaccount-reqtype'          => 'Pozíció:',
	'requestaccount-level-0'          => 'szerző',
	'requestaccount-level-1'          => 'szerkesztő',
	'requestaccount-bio'              => 'Személyes életrajz:',
	'requestaccount-attach'           => 'CV (nem kötelező)',
	'requestaccount-notes'            => 'További megjegyzések:',
	'requestaccount-urls'             => 'Weboldalak listája, ha van (külön sorba írd őket):',
	'requestaccount-agree'            => 'Igazolnod kell, hogy neved valódi és elfogadod a használati feltételeket.',
	'requestaccount-inuse'            => 'A felhasználói nevet már használták egy elfogadásra váró kérelemnél.',
	'requestaccount-tooshort'         => 'Az életrajzodnak minimum $1 szót kell tartalmaznia.',
	'requestaccount-emaildup'         => 'Egy másik kérelemnél már megadták ugyanezt az e-mail címet.',
	'requestaccount-exts'             => 'A csatolt fájl típusa nem engedélyezett.',
	'requestaccount-resub'            => 'A CV-fájlodat újra ki kell választani biztonsági okok miatt. Hagyd a mezőt üresen,
ha már nem akarod mellékelni.',
	'requestaccount-tos'              => 'Elolvastam és elfogadom a(z) {{SITENAME}} [[{{MediaWiki:Requestaccount-page}}|használati feltételeit]].  
A „Valódi név” mezőben megadott név az én valódi nevem.',
	'requestaccount-submit'           => 'Felhasználói fiók kérése',
	'requestaccount-sent'             => 'A kérelmed sikeresen el lett küldve, és most elfogadásra vár.',
	'request-account-econf'           => 'Az e-mail címed meg lett erősítve, és meg fog jelenni a kérelmedben.',
	'requestaccount-email-subj'       => '{{SITENAME}} e-mail cím megerősítés',
	'requestaccount-email-body'       => 'Valaki, valószínűleg te, a $1 IP-címről kérte a "$2" nevű
felhasználói fiókot a(z) {{SITENAME}} wikin. 

Annak érdekében, hogy megerősítsd, ez az azonosító valóban hozzád tartozik, nyisd meg az alábbi linket a böngésződben:

$3


Ha a fiók elkészült, akkor elküldjük a jelszavadat. Ha ez *nem* te vagy, ne kattints a linkre.
Ennek a megerősítésre szánt kódnak a felhasználhatósági ideje lejár: $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} felhasználói fiók kérelem',
	'requestaccount-email-body-admin' => '"$1" regisztrációja jóváhagyásra vár.
Az e-mail cím ellenőrzése sikeres volt. Itt hagyhatod jóvá a kérést: "$2".',
	'acct_request_throttle_hit'       => 'Sajnáljuk, de már $1 felhasználói fiókot kértél, így nem igényelhetsz újabbakat.',
	'requestaccount-loginnotice'      => "Ha felhasználói fiókot szeretnél, akkor '''[[Special:RequestAccount|kérned kell egyet]]'''.",
	'confirmaccount-newrequests'      => "Jelenleg '''$1''' [[Special:ConfirmAccounts|felhasználói fiók-kérelem]] vár megerősítésre.",
	'confirmaccounts'                 => 'Felhasználói fiók-kérelem megerősítése',
	'confirmaccount-maintext'         => "'''Ezen a lapon lehet megerősíteni a felhasználói fiókokra vonatkozó kérelmeket'''.

A várósor három részre oszlik: egy az új kérelmeket, egy azokat a kérelmeket, melyekhez további adatok szükségesek és egy a visszautasított kérelmeket tartalmazza.

Mikor egy kérelemre válaszolsz, gondosan nézd át, és ha szükséges, erősítsd meg a benne található információkat.
Az általad végzett műveleteket titokban naplózzuk.",
	'confirmaccount-list'             => 'Itt található az elfogadásra váró kérések listája.
Az elfogadott fiókok el lesznek készítve, és törlődnek a listáról. A visszautasított kérések egyszerűen törlődnek.',
	'confirmaccount-list2'            => 'Itt találhatóak a nem rég visszautasított kérelmek, melyek automatikusan törlődnek néhány nap után. Még mindig el lehet őket fogadni, de beszélj a visszautasító adminisztrátorral a művelet végrehajtása előtt.',
	'confirmaccount-text'             => 'Ez egy elfogadásra váró felhasználói fiók-kérelem.

Gondosan nézd át az információkat. Ha el szeretnéd fogadni, a pozíció legördülő listában állítsd be a felhasználói
fiók állapotát. Az életrajzban végzett szerkesztések nem módosítják a tárolt bizonyítványokat. A felhasználói fiókot
más néven is elkészítheted. Ezt csak akkor használd, ha más nevekkel való ütközéseket szeretnéd kiküszöbölni.

Ha üresen hagyod az oldalt, a kérelem elfogadása vagy visszautasítása nélkül, akkor továbbra is elfogadásra fog várni.',
	'confirmaccount-none-o'           => 'Jelenleg nincs elfogadásra váró kérelem a listában.',
	'confirmaccount-none-h'           => 'Jelenleg nincs visszatartott kérelem a listában.',
	'confirmaccount-none-r'           => 'Jelenleg nincs visszautasított kérelem a listában.',
	'confirmaccount-real-q'           => 'Név',
	'confirmaccount-email-q'          => 'E-mail cím',
	'confirmaccount-bio-q'            => 'Életrajz',
	'confirmaccount-showheld'         => 'Visszatartott fiókok listájának megtekintése',
	'confirmaccount-review'           => 'Áttekintés',
	'confirmaccount-types'            => 'Válassz egy várólistát az alábbiak közül:',
	'confirmaccount-all'              => '(összes várólista megtekintése)',
	'confirmaccount-type'             => 'Kiválasztott várólista:',
	'confirmaccount-type-0'           => 'leendő szerzők',
	'confirmaccount-type-1'           => 'leendő szerkesztő',
	'confirmaccount-q-open'           => 'elfogadásra váró kérelmek',
	'confirmaccount-q-held'           => 'visszatartott kérelmek',
	'confirmaccount-q-rej'            => 'visszautasított kérelmek',
	'confirmaccount-badid'            => 'Nincs elfogadásra váró kérelem a megadott azonosítóval. Valószínűleg már el lett intézve.',
	'confirmaccount-leg-user'         => 'Felhasználói fiók',
	'confirmaccount-leg-areas'        => 'Érdeklődési területek',
	'confirmaccount-leg-person'       => 'Személyes információ',
	'confirmaccount-leg-other'        => 'További információ',
	'confirmaccount-name'             => 'Felhasználói név',
	'confirmaccount-real'             => 'Név:',
	'confirmaccount-email'            => 'E-mail cím:',
	'confirmaccount-reqtype'          => 'Pozíció:',
	'confirmaccount-pos-0'            => 'szerző',
	'confirmaccount-pos-1'            => 'szerkesztő',
	'confirmaccount-bio'              => 'Életrajz:',
	'confirmaccount-attach'           => 'CV:',
	'confirmaccount-notes'            => 'További megjegyzések:',
	'confirmaccount-urls'             => 'Weboldalak listája:',
	'confirmaccount-none-p'           => '(nincs megadva)',
	'confirmaccount-confirm'          => 'A lenti beállításokkal elfogadhatod, visszautasíthatod vagy visszatarthatod a kérelmet:',
	'confirmaccount-econf'            => '(megerősítve)',
	'confirmaccount-reject'           => '(visszautasította [[User:$1|$1]] $2-kor)',
	'confirmaccount-rational'         => 'A jelentkezőnek adott magyarázat:',
	'confirmaccount-noreason'         => '(nincs)',
	'confirmaccount-held'             => '(visszatartotta [[User:$1|$1]] $2-kor)',
	'confirmaccount-create'           => 'Elfogadás (fiók elkészítése)',
	'confirmaccount-deny'             => 'Visszautasítás (törlés a listáról)',
	'confirmaccount-hold'             => 'Visszatartás',
	'confirmaccount-spam'             => 'Spam (ne küldjön e-mailt)',
	'confirmaccount-reason'           => 'Megjegyzés (az e-mailhez lesz csatolva):',
	'confirmaccount-ip'               => 'IP-cím:',
	'confirmaccount-submit'           => 'Megerősítés',
	'confirmaccount-needreason'       => 'Meg kell adnod az okot a megjegyzés mezőben.',
	'confirmaccount-canthold'         => 'A kérelmet már visszatartották vagy törölték.',
	'confirmaccount-acc'              => 'A kérelem sikeresen meg lett erősítve; [[User:$1]] felhasználói fiók elkészítve.',
	'confirmaccount-rej'              => 'A kérelem sikeresen visszautasítva.',
	'confirmaccount-viewing'          => '(jelenleg [[User:$1|$1]] nézi)',
	'confirmaccount-summary'          => 'Felhasználói lap elkészítése az új felhasználó életrajzával.',
	'confirmaccount-welc'             => "'''Üdvözlet a(z) ''{{SITENAME}}'' wikin!''' Reméljük, hogy sokat fogsz szerkeszteni.
Elolvashatod a [[{{MediaWiki:Helppage}}|segítséglapokat]] is. Üdvözlet mégegyszer, és érezd jól magadat!",
	'confirmaccount-wsum'             => 'Üdvözlet!',
	'confirmaccount-email-subj'       => '{{SITENAME}} felhasználói fiók-kérelem',
	'confirmaccount-email-body'       => 'A felhasználói fiók-kérelmedet elfogadtuk a(z) {{SITENAME}} wikin.

Felhasználói név: $1

Jelszó: $2

Biztonsági okok miatt meg kell változtatnod a jelszavadat az első bejelentkezésed során. A bejelentkezéshez menj a
{{fullurl:Special:Userlogin}} lapra.',
	'confirmaccount-email-body2'      => 'A felhasználói fiók-kérelmedet elfogadtuk a(z) {{SITENAME}} wikin.

Felhasználói név: $1

Jelszó: $2

$3

Biztonsági okok miatt meg kell változtatnod a jelszavadat az első bejelentkezésed során. A bejelentkezéshez menj a
{{fullurl:Special:Userlogin}} lapra.',
	'confirmaccount-email-body3'      => 'Sajnálattal közöljük, hogy a regisztrációdat („$1”) elutasították a(z) {{SITENAME}} wikin.

Számos oka lehet a dolognak. Lehet, hogy nem töltötted ki helyesen az űrlapot, nem adtál meg elég információt, vagy más irányelv miatt utasítottak vissza.  Ha több információt szeretnél megtudni a felhasználói fiókokkal kapcsolatos irányelvekről, az oldalon megtalálhatod a kapcsolattartási listát.',
	'confirmaccount-email-body4'      => 'Sajnálattal közöljük, hogy a regisztrációdat („$1” néven) elutasították a(z) {{SITENAME}} wikin.

$2

Ha több információt szeretnél megtudni a felhasználói fiókokkal kapcsolatos irányelvekről, az oldalon megtalálhatod a kapcsolattartási listát.',
	'confirmaccount-email-body5'      => 'Ahhoz, hogy elfogadjuk "$1" felhasználói fiók-kérelmedet a(z) {{SITENAME}} wikin,
néhány további információt kell megadnod.

$2

Ha több információt szeretnél megtudni a felhasználói fiókokkal kapcsolatos irányelvekről, az oldalon megtalálhatod a kapcsolattartási listát.',
	'usercredentials'                 => 'Személyi adatok',
	'usercredentials-leg'             => 'Megerősített felhasználói adatok kikeresése',
	'usercredentials-user'            => 'Felhasználói név:',
	'usercredentials-text'            => 'Itt találhatóak a felhasználói fiókhoz tartozó, megerősített adatok.',
	'usercredentials-leg-user'        => 'Felhasználói fiók',
	'usercredentials-leg-areas'       => 'Érdeklődési területek',
	'usercredentials-leg-person'      => 'Személyes információ',
	'usercredentials-leg-other'       => 'További információ:',
	'usercredentials-email'           => 'E-mail cím:',
	'usercredentials-real'            => 'Valódi név:',
	'usercredentials-bio'             => 'Életrajz:',
	'usercredentials-attach'          => 'CV:',
	'usercredentials-notes'           => 'További megjegyzések:',
	'usercredentials-urls'            => 'Weboldalak listája:',
	'usercredentials-ip'              => 'Valódi IP-cím:',
	'usercredentials-member'          => 'Jogok:',
	'usercredentials-badid'           => 'A felhasználó nem rendelkezik személyes adatokkal. Ellenőrizd, hogy helyesen adtad-e meg a nevét.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'requestaccount-level-0' => 'autor',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name'    => 'Nomine de usator',
	'confirmaccount-email'   => 'E-mail:',
	'confirmaccount-pos-0'   => 'autor',
	'usercredentials-user'   => 'Nomine de usator:',
	'usercredentials-email'  => 'E-mail:',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 * @author Irwangatot
 */
$messages['id'] = array(
	'requestaccount-level-1'  => 'penyunting',
	'confirmaccount-real-q'   => 'Nama',
	'confirmaccount-name'     => 'Nama pengguna',
	'confirmaccount-real'     => 'Nama:',
	'confirmaccount-pos-1'    => 'penyunting',
	'confirmaccount-noreason' => '(tidak ada)',
	'usercredentials-user'    => 'Nama pengguna:',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'confirmaccount-wsum' => 'Bonveno!',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'requestaccount'             => 'Sækja um aðgang',
	'requestaccount-leg-user'    => 'Aðgangur notanda',
	'requestaccount-leg-areas'   => 'Aðal áhugamál',
	'requestaccount-leg-person'  => 'Persónulegar upplýsingar',
	'requestaccount-leg-other'   => 'Aðrar upplýsingar',
	'requestaccount-real'        => 'Raunverulegt nafn:',
	'requestaccount-same'        => '(eins og raunverulega nafnið)',
	'requestaccount-email'       => 'Netfang:',
	'requestaccount-reqtype'     => 'Staða:',
	'requestaccount-level-0'     => 'höfundur',
	'requestaccount-level-1'     => 'ritstjóri',
	'requestaccount-bio'         => 'Sjálfsævisaga:',
	'requestaccount-attach'      => 'Ferilskrá (valfrjálst):',
	'requestaccount-notes'       => 'Viðbótarskýring:',
	'requestaccount-urls'        => 'Listi yfir vefsíður, ef einhverjar (aðskildu með línum):',
	'requestaccount-tooshort'    => 'Sjálfsævisagan þín þarf að vera að minnsta kosti $1 orð á lengd.',
	'confirmaccount-real-q'      => 'Nafn',
	'confirmaccount-email-q'     => 'Netfang',
	'confirmaccount-bio-q'       => 'Sjálfsævisaga',
	'confirmaccount-leg-user'    => 'Aðgangur notanda',
	'confirmaccount-leg-areas'   => 'Aðal áhugamál',
	'confirmaccount-leg-person'  => 'Persónulegar upplýsingar',
	'confirmaccount-leg-other'   => 'Aðrar upplýsingar',
	'confirmaccount-name'        => 'Notandanafn',
	'confirmaccount-real'        => 'Nafn:',
	'confirmaccount-email'       => 'Netfang:',
	'confirmaccount-reqtype'     => 'Staða:',
	'confirmaccount-pos-0'       => 'höfundur',
	'confirmaccount-pos-1'       => 'ritstjóri',
	'confirmaccount-bio'         => 'Sjálfsævisaga:',
	'confirmaccount-attach'      => 'Ferilskrá:',
	'confirmaccount-notes'       => 'Viðbótarskýring:',
	'confirmaccount-urls'        => 'Listi yfir vefsíður:',
	'confirmaccount-none-p'      => '(ekki fáanlegt)',
	'confirmaccount-confirm'     => 'Notaðu valmöguleikana hér að neðan til að samþykkja, neita eða setja beiðni í bið:',
	'confirmaccount-econf'       => '(staðfest)',
	'confirmaccount-noreason'    => '(engin)',
	'confirmaccount-create'      => 'Samþykkja (búa til aðgang)',
	'confirmaccount-hold'        => 'Bíða',
	'confirmaccount-ip'          => 'Vistfang:',
	'confirmaccount-submit'      => 'Staðfesta',
	'confirmaccount-wsum'        => 'Velkomin!',
	'usercredentials-user'       => 'Notandanafn:',
	'usercredentials-leg-user'   => 'Aðgangur notanda',
	'usercredentials-leg-areas'  => 'Aðal áhugamál',
	'usercredentials-leg-person' => 'Persónulegar upplýsingar',
	'usercredentials-leg-other'  => 'Aðrar upplýsingar',
	'usercredentials-email'      => 'Netfang:',
	'usercredentials-real'       => 'Raunverulegt nafn:',
	'usercredentials-bio'        => 'Sjálfsævisaga:',
	'usercredentials-attach'     => 'Ferilskrá:',
	'usercredentials-notes'      => 'Viðbótarskýring:',
	'usercredentials-urls'       => 'Listi yfir vefsíður:',
	'usercredentials-ip'         => 'Upprunalegt vistfang:',
	'usercredentials-member'     => 'Réttindi:',
);

/** Italian (Italiano)
 * @author Pietrodn
 * @author Darth Kule
 */
$messages['it'] = array(
	'confirmaccount-name'  => 'Nome utente',
	'confirmaccount-ip'    => 'Indirizzo IP:',
	'usercredentials-user' => 'Nome utente:',
);

/** Japanese (日本語)
 * @author JtFuruhata
 * @author Siebrand
 */
$messages['ja'] = array(
	'requestaccount'                  => 'アカウント登録申請',
	'requestaccount-text'             => "'''利用者アカウントを申請する方は、以下の項目を記入の上、送信してください'''  

アカウント申請を行う前に、[[{{MediaWiki:Requestaccount-page}}|サービス利用条件]]をご一読下さい。

申請が承認されると、通知メッセージと[[Special:Userlogin|ログイン]]のためのアカウントが、あなたの電子メールアドレスへ送信されます。",
	'requestaccount-page'             => '{{ns:project}}:サービス利用条件',
	'requestaccount-dup'              => "'''注: あなたは既に登録済みアカウントでログインしています。'''",
	'requestaccount-leg-user'         => '利用者アカウント',
	'requestaccount-leg-areas'        => '関心のある分野',
	'requestaccount-leg-person'       => '自己紹介',
	'requestaccount-leg-other'        => 'その他',
	'requestaccount-acc-text'         => '申請を行うと、確認メッセージがあなたの電子メールアドレスへ送信されます。その電子メールにある確認のためのリンクをクリックすると申請が承認されます。また、アカウントが作成された際には、電子メールでパスワードが送られます。',
	'requestaccount-areas-text'       => 'あなたが見識をお持ちの分野、または主に活動したい分野を選択してください。',
	'requestaccount-ext-text'         => '以下の個人情報は公開されず、この申請処理にのみ利用されます。
電話番号をはじめとする連絡先は、あなたが本人確認の補助を目的として記入いただけます。',
	'requestaccount-bio-text'         => 'あなたの自己紹介は利用者ページの初期内容として登録されます。
他の利用者から信頼が得られるよう心掛けてください。
それは、あなたが気持ちよく投稿するために重要です。
あなたの名前は [[Special:Preferences|{{int:preferences}}]] から変更できます。',
	'requestaccount-real'             => '本名:',
	'requestaccount-same'             => '（本名での登録に限定されます）',
	'requestaccount-email'            => '電子メールアドレス:',
	'requestaccount-reqtype'          => 'サイトでの役割:',
	'requestaccount-level-0'          => '著者',
	'requestaccount-level-1'          => '編集者',
	'requestaccount-bio'              => '自己紹介',
	'requestaccount-attach'           => '研究概要（レジュメ）や略歴（CV）　（任意回答）',
	'requestaccount-notes'            => '特記事項',
	'requestaccount-urls'             => 'ウェブサイトのリスト（任意回答、改行で区切ります）:',
	'requestaccount-agree'            => '本名が正しいこと、および、サービス利用規約に同意したことを宣誓していただく必要があります。',
	'requestaccount-inuse'            => 'この利用者名は、承認待ちのアカウントにて既に申請済みです。',
	'requestaccount-tooshort'         => "自己紹介は、最低限 $1 以上の単語で構成される必要があります。''（訳注：この機能は日本語版ではうまく動作しないかもしれません。あなたが管理者であるならば、この制約の使用に慎重であってください。あなたが一般利用者である場合、このサイトの管理者と相談してください。）''",
	'requestaccount-emaildup'         => '承認待ちのアカウントと同一の電子メールアドレスが指定されました。',
	'requestaccount-exts'             => 'この添付ファイルのタイプは許可されていません。',
	'requestaccount-resub'            => 'セキュリティ上の理由により、研究概要/略歴のファイルを再指定する必要があります。
これらの公開を既に望んでいない場合、回答項目を空欄に戻してください。',
	'requestaccount-tos'              => '私は {{SITENAME}} の [[{{MediaWiki:Requestaccount-page}}|サービス利用規約]] を既に熟読しており、これに同意し、遵守します。
私が"本名"欄に記入した名前は、自分の本名であることに間違いありません。',
	'requestaccount-submit'           => 'アカウント申請',
	'requestaccount-sent'             => 'アカウント申請は正常に送信され、承認待ち状態になりました。',
	'request-account-econf'           => 'あなたの電子メールアドレスは、承認リストに登録されました。アカウント申請などに利用できます。',
	'requestaccount-email-subj'       => '{{SITENAME}} 電子メールアドレスの確認',
	'requestaccount-email-body'       => 'IPアドレス $1 を使用するどなたか（おそらくあなた）が、この電子メールアドレスを用いて {{SITENAME}} のアカウント "$2" の作成を申請しました。

この {{SITENAME}}　のアカウント作成が本当にあなたによる申請であると証明するには、以下のリンク先をブラウザから開いてください:

$3

アカウントが作成されると、パスワードが電子メールで送信されます。もしも、この申請があなたによるもの「ではない」場合、このリンクはクリックしないでください。
この承認手続きは $4 で期限切れとなります。',
	'requestaccount-email-subj-admin' => '{{SITENAME}} のアカウント申請',
	'requestaccount-email-body-admin' => '"$1" によるアカウント申請が承認待ちになっています。
申請電子メールアドレスは本人確認済みです。この申請への承認は、"$2"　から行うことができます。',
	'acct_request_throttle_hit'       => '申し訳ありません、あなたは既に $1 というアカウントを申請済みです。これ以上の申請はできません。',
	'requestaccount-loginnotice'      => "利用者アカウントの取得は、'''[[Special:RequestAccount|アカウント登録申請]]'''から行ってください。",
	'confirmaccount-newrequests'      => "{{PLURAL:$1|現在|現在}}、'''$1個'''の{{PLURAL:$1|[[{{ns:special}}:ConfirmAccounts|アカウント申請]]|[[{{ns:special}}:ConfirmAccounts|アカウント申請]]}}が承認待ちになっています。",
	'confirmaccounts'                 => 'アカウント登録申請の承認',
	'confirmedit-desc'                => '{{int:group-bureaucrat}}にアカウント申請への承認機能を提供する',
	'confirmaccount-maintext'         => "'''ここは、''{{SITENAME}}'' 上で承認待ちとなっているアカウント登録申請を処理するためのページです。'''

各アカウント申請が保管されている待ち行列は、3種類あります。1つは申請を受理するためのもの、1つは他の管理者が継続審議を意見し保留となっているもの、もう一つは最近棄却された申請です。

申請要求に応える際は、それを注意深く検討してください。必要であれば、申請に含まれている情報を確認してください。
作業内容は非公開のログに残されます。また、あなたが検討のためにここで行う活動は、個人的なものとならないことが望まれます。",
	'confirmaccount-list'             => '以下は、承認待ちアカウントの一覧です。
承認されたアカウントは作成され、この一覧から削除されます。棄却されたアカウントは単にこの一覧から削除されます。',
	'confirmaccount-list2'            => '以下は、最近申請が棄却されたアカウントの一覧で、これらは数日経過すると自動的に削除されます。
これらのアカウントを承認することはまだ可能ですが、まずは棄却した管理者と相談することをお勧めします。',
	'confirmaccount-text'             => "これは、'''{{SITENAME}}''' において承認待ちとなっている利用者アカウントです。

下記の利用者情報を慎重に検討してください。この申請を承認する場合、ドロップダウンリストを操作して利用者のアカウント状態を設定してください。
申請された自己紹介文に重篤な個人情報などが記載されている場合、編集により取り除くことが可能です。ただし、これは一般公開向けのもので、利用者信頼情報の内部保存データには影響を与えません。
申請されたものとは別の利用者名でアカウントを作成することも可能です。
これは、他の利用者と名前が競合する際にのみ行われるべきでしょう。

承認処理を行わず単にページ移動をした場合、または承認しなかった場合、この申請は承認待ちのままとなります。",
	'confirmaccount-none-o'           => '現在、申請が受理されていないアカウントはありません。',
	'confirmaccount-none-h'           => '現在、申請が承認保留となっているアカウントはありません。',
	'confirmaccount-none-r'           => '最近に申請が棄却されたアカウントはありません。',
	'confirmaccount-real-q'           => '本名',
	'confirmaccount-email-q'          => '電子メールアドレス',
	'confirmaccount-bio-q'            => '自己紹介',
	'confirmaccount-showheld'         => '承認保留アカウントの一覧を見る',
	'confirmaccount-review'           => '承認検討',
	'confirmaccount-types'            => 'アカウント承認待ち行列を選択してください:',
	'confirmaccount-all'              => '（全ての待ち行列）',
	'confirmaccount-type'             => '選択された待ち行列:',
	'confirmaccount-type-0'           => '著者を希望',
	'confirmaccount-type-1'           => '編集者を希望',
	'confirmaccount-q-open'           => '申請受理',
	'confirmaccount-q-held'           => '承認保留',
	'confirmaccount-q-rej'            => '最近の申請棄却',
	'confirmaccount-badid'            => '指定されたIDに該当する承認待ちの申請はありません。
おそらく既に処理済みです。',
	'confirmaccount-leg-user'         => '利用者アカウント',
	'confirmaccount-leg-areas'        => '関心のある分野',
	'confirmaccount-leg-person'       => '個人情報',
	'confirmaccount-leg-other'        => 'その他',
	'confirmaccount-name'             => '利用者名',
	'confirmaccount-real'             => '本名:',
	'confirmaccount-email'            => '電子メールアドレス:',
	'confirmaccount-reqtype'          => 'サイトでの役割:',
	'confirmaccount-pos-0'            => '著者',
	'confirmaccount-pos-1'            => '編集者',
	'confirmaccount-bio'              => '自己紹介:',
	'confirmaccount-attach'           => '研究概要（レジュメ）や略歴（CV）:',
	'confirmaccount-notes'            => '特記事項:',
	'confirmaccount-urls'             => 'ウェブサイトのリスト:',
	'confirmaccount-none-p'           => '（記述なし）',
	'confirmaccount-confirm'          => 'この申請に対する承認、棄却、保留判断を以下から選択:',
	'confirmaccount-econf'            => '（確認済）',
	'confirmaccount-reject'           => '（$2、[[User:$1|$1]]によって棄却）',
	'confirmaccount-rational'         => '申請者に対して下された判断:',
	'confirmaccount-noreason'         => '（記述なし）',
	'confirmaccount-held'             => '（$2、[[User:$1|$1]]が"保留"の判断）',
	'confirmaccount-create'           => '承認（アカウント作成）',
	'confirmaccount-deny'             => '棄却（リストから削除）',
	'confirmaccount-hold'             => '保留',
	'confirmaccount-spam'             => 'スパム（電子メールは送信しません）',
	'confirmaccount-reason'           => '判断理由（電子メールに記載されます）:',
	'confirmaccount-ip'               => 'IPアドレス:',
	'confirmaccount-submit'           => '判断確定',
	'confirmaccount-needreason'       => '判断理由を以下に記載する必要があります。',
	'confirmaccount-canthold'         => 'この申請は既に保留済みか、削除済みです。',
	'confirmaccount-acc'              => 'アカウント申請の承認に成功しました。作成された新しいアカウントは [[User:$1]] です。',
	'confirmaccount-rej'              => 'アカウント申請は棄却されました。',
	'confirmaccount-viewing'          => '（この申請は、現在[[User:$1|$1]]が受理しています）',
	'confirmaccount-summary'          => '申請された自己紹介を用いた新規利用者ページ作成',
	'confirmaccount-welc'             => "'''ようこそ''{{SITENAME}}''へ！''' 多くの寄稿を心よりお待ち申し上げます。
サイトでの活動に関しては、[[{{MediaWiki:Helppage}}|ヘルプページ]]をご覧ください。それでは、{{SITENAME}}で楽しいひと時を！",
	'confirmaccount-wsum'             => 'ようこそ！',
	'confirmaccount-email-subj'       => '{{SITENAME}} のアカウント申請',
	'confirmaccount-email-body'       => 'あなたによる {{SITENAME}} でのアカウント申請は、承認されました。

　利用者名: $1

パスワード: $2

セキュリティ上の理由により、初回ログイン時に上記パスワードを変更する必要があります。
{{fullurl:Special:Userlogin}} よりログインしてください。',
	'confirmaccount-email-body2'      => 'あなたによる {{SITENAME}} でのアカウント申請は、承認されました。

　利用者名: $1

パスワード: $2

$3

セキュリティ上の理由により、初回ログイン時に上記パスワードを変更する必要があります。
{{fullurl:Special:Userlogin}} よりログインしてください。',
	'confirmaccount-email-body3'      => '申し訳ありません、{{SITENAME}} におけるアカウント "$1" の申請は、棄却されました。

これにはいくつかの理由が考えられます。
申請フォームの必要事項が正しく記載されていない、あなたに関することが充分に記載されていないといった、利用者信頼情報にまつわる方針に基づいた判断です。
利用者アカウント承認方針に関する詳細は、サイト連絡先までお尋ねください。',
	'confirmaccount-email-body4'      => '申し訳ありません、{{SITENAME}} におけるアカウント "$1" の申請は、棄却されました。

$2

利用者アカウント承認方針に関する詳細は、サイト連絡先までお尋ねください。',
	'confirmaccount-email-body5'      => '{{SITENAME}} におけるアカウント "$1" の申請承認には、以下の追加情報が必要です。

$2

利用者アカウント承認方針に関する詳細は、サイト連絡先までお尋ねください。',
	'usercredentials'                 => '利用者信頼情報',
	'usercredentials-leg'             => '利用者信頼情報の閲覧',
	'usercredentials-user'            => '利用者名:',
	'usercredentials-text'            => '指定されたアカウント利用者の信頼情報は以下のとおりです。',
	'usercredentials-leg-user'        => '利用者アカウント',
	'usercredentials-leg-areas'       => '関心のある分野',
	'usercredentials-leg-person'      => '個人情報',
	'usercredentials-leg-other'       => 'その他',
	'usercredentials-email'           => '電子メールアドレス:',
	'usercredentials-real'            => '本名:',
	'usercredentials-bio'             => '自己紹介:',
	'usercredentials-attach'          => '研究概要（レジュメ）や略歴（CV）:',
	'usercredentials-notes'           => '特記事項:',
	'usercredentials-urls'            => 'ウェブサイトのリスト:',
	'usercredentials-ip'              => '申請時IPアドレス:',
	'usercredentials-member'          => '権限:',
	'usercredentials-badid'           => '利用者信頼情報が見つかりません。利用者名が正しく指定されているか確認してください。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'requestaccount'                  => 'Nyuwun rékening (akun)',
	'requestaccount-dup'              => "'''Pènget: Panjenengan wis log mlebu mawa rékening sing kadaftar.'''",
	'requestaccount-leg-user'         => 'Rékening (akun) panganggo',
	'requestaccount-leg-person'       => 'Informasi pribadi',
	'requestaccount-leg-other'        => 'Informasi liya',
	'requestaccount-real'             => 'Jeneng asli:',
	'requestaccount-same'             => '(padha karo jeneng asli)',
	'requestaccount-email'            => 'Alamat e-mail:',
	'requestaccount-reqtype'          => 'Posisi:',
	'requestaccount-level-0'          => 'pangripta',
	'requestaccount-level-1'          => 'panyunting',
	'requestaccount-bio'              => 'Babad slira pribadi:',
	'requestaccount-attach'           => 'Riwayat urip utawa CV (opsional):',
	'requestaccount-notes'            => 'Cathetan tambahan:',
	'requestaccount-urls'             => 'Daftar situs-situs wèb, yèn ana (pisahen mawa garis-garis anyar):',
	'requestaccount-agree'            => "Panjenengan kudu mastèkaké yèn jeneng asli panjenengan iku bener lan panjenengan sarujuk karo Sarat Paladènan (''Terms of Service'') kita.",
	'requestaccount-inuse'            => "Jeneng panganggo iki wis dienggo lan saiki lagi ing tahap ''pending'' panyuwunan rékening.",
	'requestaccount-tooshort'         => 'Babad slira panjenengan minimal dawané kudu ngandhut $1 tembung-tembung.',
	'requestaccount-emaildup'         => "Sawijining panyuwunan rékening (akun) liyané sing lagi ''pending'' nganggo alamat e-mail sing padha",
	'requestaccount-exts'             => "Jenis berkas lampiran (''attachment'') ora diparengaké.",
	'requestaccount-resub'            => 'Berkas CV/riwayat urip panjenengan kudu dipilih manèh amerga alesan kaslamatan.
Lirwakna lapangan iki kosong yèn panjenengan ora kepéngin manèh nglebokaké CV.',
	'requestaccount-tos'              => "Aku wis maca lan sarujuk nuruti [[{{MediaWiki:Requestaccount-page}}|Sarat Paladènan (''Terms of Service'')]]-é {{SITENAME}}.
Jeneng sing tak-wènèhaké minangka \"Jeneng asli\" iku pancèn jenengku dhéwé.",
	'requestaccount-submit'           => 'Nyuwun rékening (akun)',
	'requestaccount-sent'             => "Panyuwunan rékening panjenengan bisa kasil dikirim lan saiki lagi di-''review''.",
	'request-account-econf'           => 'Alamat e-mail panjenengan wis dikonfirmasi lan bakal didokok ing daftar kaya ing panyuwunan rékening panjenengan.',
	'requestaccount-email-subj'       => 'Konfirmasi alamat e-mail {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'Panyuwunan rékening ing {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" wis nyuwun rékening lan saiki nunggu konfirmasi.
Alamat e-mailé wis dikonfirmasi. Panjenengan bisa konfirmasi panyuwunan iki ing "$2".',
	'acct_request_throttle_hit'       => 'Nuwun sèwu, panjenengan wis nyuwun $1 rékening-rékening.
Panjenengan ora bisa nyuwun rékening anyar manèh.',
	'requestaccount-loginnotice'      => "Supaya bisa olèh rékening panganggo, panjenengan kudu '''[[Special:RequestAccount|nyuwun iku]]'''.",
	'confirmaccounts'                 => 'Konfirmasi panyuwunan rékening (akun)',
	'confirmedit-desc'                => 'Mènèhi para birokrat kabisan kanggo konfirmasi panyuwunan rékening',
	'confirmaccount-real-q'           => 'Jeneng',
	'confirmaccount-email-q'          => 'E-mail',
	'confirmaccount-bio-q'            => 'Biografi',
	'confirmaccount-showopen'         => 'panyuwunan sing isih kabuka',
	'confirmaccount-showrej'          => 'panyuwunan sing ditolak',
	'confirmaccount-showexp'          => 'panyuwunan-panyuwunan kadaluwarsa',
	'confirmaccount-types'            => 'Pilih sawijining antrian konfirmasi rékening saka ngisor iki:',
	'confirmaccount-all'              => '(tuduhna kabèh antrian)',
	'confirmaccount-type'             => 'Antrian:',
	'confirmaccount-q-open'           => 'panyuwunan sing isih kabuka',
	'confirmaccount-q-rej'            => 'panyuwunan sing lagi waé ditolak',
	'confirmaccount-q-stale'          => 'panyuwunan-panyuwunan kadaluwarsa',
	'confirmaccount-leg-user'         => 'Rékening panganggo',
	'confirmaccount-leg-person'       => 'Informasi pribadi',
	'confirmaccount-leg-other'        => 'Informasi liya',
	'confirmaccount-name'             => 'Jeneng panganggo',
	'confirmaccount-real'             => 'Jeneng:',
	'confirmaccount-email'            => 'E-mail:',
	'confirmaccount-reqtype'          => 'Posisi:',
	'confirmaccount-pos-0'            => 'pangripta',
	'confirmaccount-pos-1'            => 'panyunting',
	'confirmaccount-bio'              => 'Biografi:',
	'confirmaccount-attach'           => 'Babad slira/CV:',
	'confirmaccount-notes'            => 'Cathetan tambahan:',
	'confirmaccount-urls'             => 'Daftar situs-situs wèb:',
	'confirmaccount-none-p'           => '(ora diwènèhaké)',
	'confirmaccount-econf'            => '(dikonfirmasi)',
	'confirmaccount-noreason'         => '(ora ana)',
	'confirmaccount-spam'             => 'Spam (aja ngirim e-mail)',
	'confirmaccount-reason'           => 'Komentar (bakal disertakaké sajroning e-mail):',
	'confirmaccount-ip'               => 'Alamat IP:',
	'confirmaccount-submit'           => 'Konfirmasi',
	'confirmaccount-viewing'          => '(saiki lagi dideleng déning [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Nggawé kaca pangganggo karo biografiné panganggo anyar.',
	'confirmaccount-wsum'             => 'Sugeng rawuh!',
	'confirmaccount-email-subj'       => 'Panyuwunan rékening ing {{SITENAME}}',
	'usercredentials-user'            => 'Jeneng panganggo:',
	'usercredentials-leg-user'        => 'Rékening panganggo',
	'usercredentials-leg-person'      => 'Informasi pribadi',
	'usercredentials-leg-other'       => 'Informasi liya',
	'usercredentials-email'           => 'E-mail:',
	'usercredentials-real'            => 'Jeneng asli:',
	'usercredentials-bio'             => 'Biografi:',
	'usercredentials-attach'          => 'Babad slira/CV:',
	'usercredentials-notes'           => 'Cathetan tambahan:',
	'usercredentials-urls'            => 'Daftar situs-situs wèb:',
	'usercredentials-ip'              => 'Alamat IP asli:',
	'usercredentials-member'          => 'Hak-hak:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'requestaccount'                  => 'សំណើសុំគណនី',
	'requestaccount-page'             => '{{ns:project}}:លក្ខណ្ឌ ប្រើប្រាស់សេវា',
	'requestaccount-dup'              => "'''សំគាល់: លោកអ្នកត្រូវបានឡុកអ៊ីនចូលរួចហើយ ជាមួយនឹងគណនីដែលបានចុះឈ្មោះ។'''",
	'requestaccount-leg-user'         => 'គណនីអ្នកប្រើប្រាស់',
	'requestaccount-leg-person'       => 'ពត៌មានផ្ទាល់ខ្លួន',
	'requestaccount-leg-other'        => 'ពត៌មាន ដទៃទៀត',
	'requestaccount-real'             => 'ឈ្មោះពិត៖',
	'requestaccount-same'             => '(ដូចឈ្មោះពិត)',
	'requestaccount-email'            => 'អាសយដ្ឋានអ៊ីមែល៖',
	'requestaccount-reqtype'          => 'តួនាទី៖',
	'requestaccount-level-0'          => 'អ្នកនិពន្ធ៖',
	'requestaccount-level-1'          => 'ឧបករណ៍កែប្រែ',
	'requestaccount-bio'              => 'ជីវប្រវត្តិផ្ទាល់ខ្លួន៖',
	'requestaccount-attach'           => 'ប្រវត្តិរូប (ជំរើស) ៖',
	'requestaccount-notes'            => 'សំគាល់បន្ថែម៖',
	'requestaccount-agree'            => 'អ្នកត្រូវតែ បញ្ជាក់ថា ឈ្មោះពិត របស់អ្នក ត្រឹមត្រូវ និងថា អ្នកព្រមព្រៀង ចំពោះ លក្ខណ្ឌ ប្រើប្រាស់សេវា ។',
	'requestaccount-tooshort'         => 'ជីវប្រវត្តិ របស់អ្នក ត្រូវតែ វែង យ៉ាងតិច $1 ពាក្យ ។',
	'requestaccount-submit'           => 'សំណើសុំគណនី',
	'requestaccount-email-subj'       => 'ការបញ្ជាក់ទទួលស្គាល់ អាស័យដ្ឋានអ៊ីមែវល៍ {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'សំនើសុំគណនីរបស់{{SITENAME}}',
	'acct_request_throttle_hit'       => 'សូមអភ័យទោស។ អ្នកបានស្នើសុំគណនី $1 រួចហើយ។ អ្នកមិនអាចធ្វើការស្នើសុំទៀតបានទេ។',
	'requestaccount-loginnotice'      => "ដើម្បីទទួលបានគណនីអ្នកប្រើប្រាស់ អ្នកត្រូវតែ'''[[Special:RequestAccount|ស្នើសុំគណនី]]'''។",
	'confirmaccounts'                 => 'បញ្ជាក់ទទួលស្គាល់ សំណើគណនី',
	'confirmaccount-list'             => 'ខាងក្រោមនេះជាបញ្ជីរាយនាមគណនីដែលកំពុងរង់ចាំការអនុម័ត។ ពេលដែលសំនើត្រូវបានយល់ស្របឬបដិសេធ វានឹងត្រូវដកចេញពីបញ្ជីនេះ។',
	'confirmaccount-real-q'           => 'ឈ្មោះ',
	'confirmaccount-email-q'          => 'អ៊ីមែល',
	'confirmaccount-bio-q'            => 'ជីវប្រវត្តិ',
	'confirmaccount-showrej'          => 'ការស្នើសុំត្រូវបានបដិសេធ',
	'confirmaccount-showexp'          => 'ការស្នើសុំផុតកំណត់ហើយ',
	'confirmaccount-review'           => 'មើលឡើងវិញ',
	'confirmaccount-all'              => '(បង្ហាញ គ្រប់ ជួររង់ចាំ)',
	'confirmaccount-type'             => 'ជួររង់ចាំ ត្រូវបានជ្រើសយក ៖',
	'confirmaccount-leg-user'         => 'គណនីអ្នកប្រើប្រាស់',
	'confirmaccount-leg-person'       => 'ពត៌មានផ្ទាល់ខ្លួន',
	'confirmaccount-leg-other'        => 'ពត៌មាន ដទៃ',
	'confirmaccount-name'             => 'ឈ្មោះអ្នកប្រើប្រាស់',
	'confirmaccount-real'             => 'ឈ្មោះ ៖',
	'confirmaccount-email'            => 'អ៊ីមែល៖',
	'confirmaccount-pos-0'            => 'អ្នកនិពន្ធ',
	'confirmaccount-pos-1'            => 'ឧបករកែប្រែ',
	'confirmaccount-bio'              => 'ជីវប្រវត្តិ ៖',
	'confirmaccount-attach'           => 'ប្រវត្តិរូប ៖',
	'confirmaccount-urls'             => 'បញ្ជីគេហទំព័រ៖',
	'confirmaccount-none-p'           => '(មិនត្រូវបាន ផ្តល់)',
	'confirmaccount-econf'            => '(បានបញ្ជាក់ទទួលស្គាល់)',
	'confirmaccount-noreason'         => '(ទទេ)',
	'confirmaccount-create'           => 'ព្រមទទួល (បង្កើត គណនី)',
	'confirmaccount-reason'           => 'យោបល់(នឹងត្រូវបានបញ្ចូលទៅក្នុងអ៊ីមែល)៖',
	'confirmaccount-ip'               => 'អាសយដ្ឋានIP៖',
	'confirmaccount-submit'           => 'បញ្ជាក់ទទួលស្គាល់',
	'confirmaccount-needreason'       => 'អ្នកត្រូវផ្តល់ ហេតុផល ក្នុងប្រអប់វិចារ ខាងក្រោម​។',
	'confirmaccount-rej'              => 'សំណើសុំគណនីបានបដិសេធរួចជាស្រេចហើយ។',
	'confirmaccount-wsum'             => 'សូមស្វាគមន៍!',
	'confirmaccount-email-subj'       => 'សំនើសុំគណនី {{SITENAME}}',
	'confirmaccount-email-body'       => 'សំនើសុំគណនីរបស់អ្នកនៅលើ{{SITENAME}}ត្រូវបានទទួលយកហើយ។


ឈ្មោះគណនី: $1


ពាក្យសំងាត់: $2


ដើម្បីសុវត្ថិភាព អ្នកនឹងត្រូវការជាចាំបាច់ប្តូរពាក្យសំងាត់របស់អ្នកនៅពេលឡុកអ៊ីកលើកដំបូង។

ឡុកអ៊ីន សូមទៅកាន់ {{fullurl:Special:Userlogin}} ។',
	'confirmaccount-email-body2'      => 'សំនើសុំគណនីរបស់អ្នកនៅលើ{{SITENAME}}ត្រូវបានទទួលយកហើយ។

ឈ្មោះគណនី: $1

ពាក្យសំងាត់: $2

$3

ដើម្បីសុវត្ថិភាពអ្នកនឹងត្រូវការជាចាំបាច់ប្តូរពាក្យសំងាត់របស់អ្នកនៅពេលឡុកអ៊ីកលើកដំបូង។

ឡុកអ៊ីន សូមទៅកាន់{{fullurl:Special:Userlogin}} ។',
	'usercredentials-user'            => 'ឈ្មោះអ្នកប្រើប្រាស់៖',
	'usercredentials-leg-user'        => 'គណនីអ្នកប្រើប្រាស់',
	'usercredentials-leg-person'      => 'ពត៌មាន ផ្ទាល់ខ្លួន',
	'usercredentials-leg-other'       => 'ពត៌មានផ្សេងៗទៀត',
	'usercredentials-email'           => 'អ៊ីមែល៖',
	'usercredentials-real'            => 'ឈ្មោះពិត ៖',
	'usercredentials-bio'             => 'ជីវប្រវត្តិ ៖',
	'usercredentials-attach'          => 'ប្រវត្តិរូប ៖',
	'usercredentials-notes'           => 'ចំណាំ បន្ថែម ៖',
	'usercredentials-urls'            => 'បញ្ជី នៃ វ៉ែបសៃថ៍ ៖',
	'usercredentials-ip'              => 'អាស័យដ្ឋាន IP ដើមដំបូង ៖',
	'usercredentials-member'          => 'សិទ្ធិ ៖',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-email'   => 'E-mail:',
	'usercredentials-email'  => 'E-mail:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'requestaccount-real'   => 'Dinge richtije Name:',
	'confirmaccount-real-q' => 'Name',
	'confirmaccount-name'   => 'Metmaacher Name',
	'confirmaccount-real'   => 'Name:',
	'usercredentials-user'  => 'Metmaacher Name:',
	'usercredentials-real'  => 'Dä richtije Name:',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'requestaccount-real' => 'Nomen verum:',
	'requestaccount-same' => '(aequus ad nomine vero)',
	'confirmaccount-name' => 'Nomen usoris',
	'confirmaccount-real' => 'Nomen',
	'confirmaccount-wsum' => 'Salve!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'requestaccount'                  => 'Benotzerkont ufroën',
	'requestaccount-text'             => "'''Fëllt dëse Formulaire aus a schéckt e fort fir e Benotzerkont unzefroen'''.

Passt op datt dir d'éischt d'[[{{MediaWiki:Requestaccount-page}}|Conditioune vun der Notzung]] geliest hutt éier Dir e Benotzerkont ufrot.

Wann äre Benotzekont ugeholl as, kritt Dir eng Informatioun per E-Mail an Dir kënnt äre Benotzerkont op [[Special:Userlogin]] benotzen.",
	'requestaccount-page'             => '{{ns:project}}:Notzungsbedingungen',
	'requestaccount-dup'              => "'''Opgepasst: Dir sidd scho matt engem registréierte Benotzerkont ugemellt.'''",
	'requestaccount-leg-user'         => 'Benotzerkont',
	'requestaccount-leg-areas'        => 'Haaptinteressen',
	'requestaccount-leg-person'       => 'Perséinlech Informatiounen',
	'requestaccount-leg-other'        => 'Aner Informatiounen',
	'requestaccount-bio-text'         => 'Är Biographie gëtt als initiale Contenu vun denger Benotzersäit gespäichert. Versicht all néideg Recommandatiounnen unzeginn, awer vergewëssert iech, ob Dir déi Informatiounen och wierklech verëffentleche wëllt. Äre Numm kann op [[Special:Preferences|meng Astellunge]] geännert ginn.',
	'requestaccount-real'             => 'Richtege Numm:',
	'requestaccount-same'             => "(d'selwescht wéi de richtege Numm)",
	'requestaccount-email'            => 'E-mail-Adress:',
	'requestaccount-reqtype'          => 'Positioun:',
	'requestaccount-level-0'          => 'Auteur',
	'requestaccount-level-1'          => 'Editeur',
	'requestaccount-bio'              => 'Peréinlech Biographie:',
	'requestaccount-attach'           => 'Liewenslaf oder CV (optional):',
	'requestaccount-notes'            => 'Zousätzlech Bemierkungen:',
	'requestaccount-urls'             => 'Lëscht vu Websäiten (all Säit an enger neier Zeil)',
	'requestaccount-agree'            => "Dir musst confirméieren datt är E-Mailadress richteg ass and datt dir mat den Allgemenge Konditiounen d'Accord sitt.",
	'requestaccount-inuse'            => 'De Benotzernumm ass scho bäi enger anere Benotzerufro a Gebrauch.',
	'requestaccount-tooshort'         => 'Är Biographie muss mindestens $1 Wierder hunn.',
	'requestaccount-exts'             => "De Fichierstyp vum ''Attachment'' ass net erlaabt.",
	'requestaccount-submit'           => 'Benotzerkont ufroën',
	'requestaccount-sent'             => 'Är Ufro fir e Benotzerkont gouf fortgeschéckt a muss elo nach akzeptéiert ginn.',
	'requestaccount-email-subj'       => '{{SITENAME}} Konfirmatioun vun der E-Mail-Adress',
	'requestaccount-email-subj-admin' => '{{SITENAME}} Ufro fir ee Benotzerkont',
	'acct_request_throttle_hit'       => 'Pardon, Dir hutt schonns $1 Benotzerkonten ugefrot. Dir kënnt elo keng Ufroe méi maachen.',
	'requestaccount-loginnotice'      => "Fir e Benitzerkont ze kréiene, musst Dir '''[[Special:RequestAccount|een ufroen]]'''.",
	'confirmedit-desc'                => "Gëtt Bürokraten d'Méiglechkeeten fir Ufroe vu Benotzerkonten ze confirméieren",
	'confirmaccount-real-q'           => 'Numm',
	'confirmaccount-email-q'          => 'E-mail',
	'confirmaccount-bio-q'            => 'Biographie',
	'confirmaccount-showopen'         => 'Ufroen déi nach opstinn',
	'confirmaccount-showrej'          => 'Refuséiert Ufroen',
	'confirmaccount-showexp'          => 'ofgelafen Ufroen',
	'confirmaccount-review'           => 'Konfirméieren/Refüséieren',
	'confirmaccount-q-open'           => 'Ufroen déi nach opstinn',
	'confirmaccount-q-stale'          => 'ofgelafen Ufroen',
	'confirmaccount-leg-user'         => 'Benotzerkont',
	'confirmaccount-leg-areas'        => 'Haaptinteressen',
	'confirmaccount-leg-person'       => 'Perséinlech Informatiounen',
	'confirmaccount-leg-other'        => 'Aner Informatioun',
	'confirmaccount-name'             => 'Benotzernumm',
	'confirmaccount-real'             => 'Numm:',
	'confirmaccount-email'            => 'E-mail:',
	'confirmaccount-reqtype'          => 'Positioun:',
	'confirmaccount-pos-0'            => 'Auteur',
	'confirmaccount-pos-1'            => 'Editeur',
	'confirmaccount-bio'              => 'Biographie:',
	'confirmaccount-attach'           => 'Liewenslaf:',
	'confirmaccount-notes'            => 'Zousätzlech Bemierkungen:',
	'confirmaccount-urls'             => 'Lëscht vu Websäiten:',
	'confirmaccount-econf'            => '(confirméiert)',
	'confirmaccount-reject'           => '(refuséiert vum [[User:$1|$1]] de(n) $2)',
	'confirmaccount-noreason'         => '(keen)',
	'confirmaccount-spam'             => 'Spam (E-Mail net schécken)',
	'confirmaccount-reason'           => "Bemierkung (gëtt an d'E-Mail derbäigesat):",
	'confirmaccount-ip'               => 'IP-Adress:',
	'confirmaccount-submit'           => 'Confirméieren',
	'confirmaccount-rej'              => "D'Ufro fir ee Benotzerkont gouf refüséiert.",
	'confirmaccount-viewing'          => '(gëtt elo gekuckt vum [[User:$1|$1]])',
	'confirmaccount-summary'          => "D'Benotzersäit mat der Biographie vum neie Benotzer gëtt elo gemaach.",
	'confirmaccount-wsum'             => 'Wëllkomm!',
	'confirmaccount-email-subj'       => '{{SITENAME}} Ufro fir ee Benotzerkont',
	'usercredentials'                 => 'Referenzen déi de Benotzer uginn huet:',
	'usercredentials-user'            => 'Benotzernumm:',
	'usercredentials-leg-user'        => 'Benotzerkont',
	'usercredentials-leg-areas'       => 'Haaptinteressen',
	'usercredentials-leg-person'      => 'Perséinlech Informatiounen',
	'usercredentials-leg-other'       => 'Aner Informatiounen',
	'usercredentials-email'           => 'E-mail:',
	'usercredentials-real'            => 'Richtege Numm:',
	'usercredentials-bio'             => 'Biographie:',
	'usercredentials-attach'          => 'Liewenslaf:',
	'usercredentials-notes'           => 'Zousätzlech Bemierkungen:',
	'usercredentials-urls'            => 'Lëscht vun Internetsiten:',
	'usercredentials-ip'              => 'Original IP-Adress:',
	'usercredentials-member'          => 'Rechter:',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'confirmaccount-real-q' => 'Vardas',
	'confirmaccount-real'   => 'Vardas:',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 * @author Jacob.jose
 */
$messages['ml'] = array(
	'requestaccount'                  => 'അക്കൗണ്ടിനായി അഭ്യര്‍ത്ഥിക്കുക',
	'requestaccount-page'             => '{{ns:project}}:സേവനത്തിന്റെ നിബന്ധനകള്‍',
	'requestaccount-dup'              => "'''കുറിപ്പ്: നിങ്ങള്‍ ഒരു രെജിസ്റ്റേര്‍ഡ് അക്കൗണ്ട് ഉപയോഗിച്ച് ഇതിനകം ലോഗിന്‍ ചെയ്തിട്ടുണ്ട്.'''",
	'requestaccount-leg-user'         => 'ഉപയോക്തൃഅക്കൗണ്ട്',
	'requestaccount-leg-areas'        => 'താല്പര്യമുള്ള പ്രധാന മേഖലകള്‍',
	'requestaccount-leg-person'       => 'വ്യക്തിഗത വിവരങ്ങള്‍',
	'requestaccount-leg-other'        => 'മറ്റ് വിവരങ്ങള്‍',
	'requestaccount-acc-text'         => 'ഈ അഭ്യര്‍ത്ഥന സമര്‍പ്പിക്കപ്പെട്ടതിനു ശേഷം നിങ്ങളുടെ ഇമെയില്‍ വിലാസത്തിലേക്ക് ഒരു സ്ഥിരീകരണമെയില്‍ അയക്കുന്നതായിരിക്കും. പ്രസ്തുത ഇമെയിലിലുള്ള സ്ഥിരീകരണലിങ്കില്‍ ഞെക്കി പ്രതികരിക്കുക. അക്കൗണ്ട് സൃഷ്ടിക്കപ്പെട്ടതിനു ശേഷം നിങ്ങളുടെ രഹസ്യവാക്കും ഇമെയിലില്‍ അയക്കുന്നതായിരിക്കും.',
	'requestaccount-real'             => 'യഥാര്‍ത്ഥ പേര്:',
	'requestaccount-same'             => '(യഥാര്‍ത്ഥ പേരുതന്നെ)',
	'requestaccount-email'            => 'ഇ-മെയില്‍ വിലാസം:',
	'requestaccount-reqtype'          => 'സ്ഥാനം:',
	'requestaccount-level-0'          => 'ലേഖകന്‍',
	'requestaccount-level-1'          => 'എഡിറ്റര്‍',
	'requestaccount-bio'              => 'വ്യക്തിഗത വിവരങ്ങള്‍:',
	'requestaccount-attach'           => 'റെസ്യൂം അല്ലെങ്കില്‍ സിവി (ഓപ്ഷണല്‍):',
	'requestaccount-notes'            => 'കൂടുതല്‍ കുറിപ്പുകള്‍:',
	'requestaccount-urls'             => 'വെബ്ബ്സൈറ്റുകളുടെ പട്ടിക (ഓരോന്നും വെവ്വേറെ വരിയില്‍ കൊടുക്കുക):',
	'requestaccount-agree'            => 'താങ്കളുടെ പേരു യഥാര്‍ത്ഥമാണെന്നും, താങ്കള്‍ ഞങ്ങളുടെ നയങ്ങളും പരിപാടികളും അംഗീകരിക്കുന്നു എന്നും പ്രതിജ്ഞ ചെയ്യണം.',
	'requestaccount-inuse'            => 'സ്ഥിരീകരണം കാത്തിരിക്കുന്ന അഭ്യര്‍ത്ഥനകളില്‍ ഒന്ന് ഇതേ ഉപയോക്തൃനാമം ഉപയോഗിക്കുന്നുണ്ട്.',
	'requestaccount-tooshort'         => 'താങ്കളുടെ ആത്മകഥയില്‍ കുറഞ്ഞത് $1 വാക്കുകള്‍ വേണം.',
	'requestaccount-emaildup'         => 'സ്ഥിരീകരണം കാത്തിരിക്കുന്ന അഭ്യര്‍ത്ഥനകളില്‍ ഒന്ന് ഇതേ ഇമെയില്‍ വിലാസം ഉപയോഗിക്കുന്നുണ്ട്.',
	'requestaccount-exts'             => 'അറ്റാച്ച് ചെയ്ത ഫയല്‍ തരം അനുവദനീയമല്ല.',
	'requestaccount-submit'           => 'അക്കൗണ്ടിനായി അഭ്യര്‍ത്ഥിക്കുക',
	'requestaccount-email-subj'       => '{{SITENAME}} സം‌രംഭത്തിലെ ഇമെയില്‍ വിലാസ സ്ഥിരീകരണം',
	'requestaccount-email-subj-admin' => '{{SITENAME}} സം‌രംഭത്തില്‍ അക്കൗണ്ട് സൃഷ്ടിക്കാനുള്ള അഭ്യര്‍ത്ഥന',
	'requestaccount-email-body-admin' => '"$1" ന്റെ അക്കൗണ്ടിനായുള്ള അപേക്ഷ സ്ഥിരീകരണത്തിനായി കാത്തിരിക്കുന്നു. ഇമെയില്‍ വിലാസം ഇതിനകം സ്ഥിരീകരിക്കപ്പെട്ടിരിക്കുന്നു. ഈ അപേക്ഷ താങ്കള്‍ക്ക് ഇവിടെ "$2" സ്ഥിരീകരിക്കാവുന്നതാണ്‌.',
	'acct_request_throttle_hit'       => 'ക്ഷമിക്കുക, താങ്കള്‍ ഇതിനകം  $1  അക്കൗണ്ടുകള്‍ക്കായി അഭ്യര്‍ത്ഥിച്ചു കഴിഞ്ഞു. ഇനി കൂടുതല്‍ അഭ്യര്‍ത്ഥന നടത്തുന്നതു അനുവദനീയമല്ല.',
	'requestaccount-loginnotice'      => "ഉപയോക്തൃ അക്കൗണ്ട് ലഭിക്കുന്നതിനായി താങ്കള്‍ '''[[Special:RequestAccount|ഉപയോക്തൃഅക്കൗണ്ടിനായി അഭ്യര്‍ത്ഥിക്കണം]]'''.",
	'confirmaccount-newrequests'      => "ഇമെയില്‍ വിലാസം സ്ഥിരീകരിക്കപ്പെട്ട '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥന]]|[[Special:ConfirmAccounts|അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍]]}} പെന്‍‌ഡിംങ്ങാണ്‌.",
	'confirmaccounts'                 => 'അക്കൗണ്ട് അഭ്യര്‍ത്ഥനകള്‍ സ്ഥിരീകരിക്കുക',
	'confirmedit-desc'                => 'ബ്യൂറോക്രാറ്റുകള്‍ക്ക് ഉപയോക്തൃ അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍ സ്ഥിരീകരിക്കുവാന്‍ അവസരം നല്‍കുന്നു.',
	'confirmaccount-list'             => 'അക്കൗണ്ടിനായി അഭ്യര്‍ത്ഥിച്ച് അതിന്റെ സ്ഥിരീകരണത്തിനായി കാത്തിരിക്കുന്നവരുടെ പട്ടികയാണ്‌ താഴെ.
ഒരു അഭ്യര്‍ത്ഥന സ്ഥിരീകരിക്കുകയോ നിരാകരിക്കുകയോ ചെയ്താല്‍ അത് ഈ പട്ടികയില്‍ നിന്നു ഒഴിവാക്കുന്നതാണ്‌.',
	'confirmaccount-list2'            => 'അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥനകളില്‍ അടുത്ത കാലത്ത് നിരാകരിക്കപ്പെട്ട അഭ്യര്‍ത്ഥനകളുടെ പട്ടികയാണു താഴെ. ഈ പട്ടികയ്ക്കു ചില ദിവസങ്ങളില്‍ കൂടുതല്‍ പഴക്കമായാല്‍ അതു യാന്ത്രികമായി ഒഴിവാക്കപ്പെടും.
താങ്കള്‍ക്കു താല്പര്യമെങ്കില്‍ ഈ അഭ്യര്‍ത്ഥനകള്‍ സ്ഥിരീകരിക്കാവുന്നതാണ്‌.പക്ഷെ അങ്ങനെ ചെയ്യുന്നതിനു മുന്‍പ് അഭ്യര്‍ത്ഥന നിരാകരിച്ച അഡ്‌മിനിസ്റ്റ്രേറ്ററുമായി ബന്ധപ്പെടുന്നതു നന്നായിരിക്കും.',
	'confirmaccount-none-o'           => 'ഈ പട്ടികയില്‍ നിലവില്‍ അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല',
	'confirmaccount-none-h'           => 'ഈ പട്ടികയില്‍ നിലവില്‍ അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥനകളില്‍ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്ന അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല',
	'confirmaccount-none-r'           => 'നിലവില്‍ ഈ പട്ടികയില്‍ നിരസിച്ച അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല.',
	'confirmaccount-none-e'           => 'ഈ പട്ടികയില്‍ നിലവില്‍ കാലഹരണപ്പെട്ട അക്കൗണ്ടിനായുള്ള അഭ്യര്‍ത്ഥനകള്‍ ഒന്നുമില്ല.',
	'confirmaccount-real-q'           => 'പേര്‌',
	'confirmaccount-email-q'          => 'ഇ-മെയില്‍',
	'confirmaccount-bio-q'            => 'ആത്മകഥ',
	'confirmaccount-showopen'         => 'തുറന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-showrej'          => 'നിരസിച്ച അപേക്ഷകള്‍',
	'confirmaccount-showheld'         => 'തടഞ്ഞുവെക്കപ്പെട്ട അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-showexp'          => 'കാലാവധി തീര്‍ന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-review'           => 'സം‌ശോധനം',
	'confirmaccount-type-0'           => 'ലേഖകരാവാന്‍ സാദ്ധ്യതയുള്ളവര്‍',
	'confirmaccount-type-1'           => 'എഡിറ്റര്‍മാരാവാന്‍ സാദ്ധ്യതയുള്ളവര്‍',
	'confirmaccount-q-open'           => 'തുറന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-q-held'           => 'തടഞ്ഞുവെക്കപ്പെട്ട അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-q-rej'            => 'അടുത്ത സമയത്ത് നിരസിച്ച അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-q-stale'          => 'കാലാവധി തീര്‍ന്ന അഭ്യര്‍ത്ഥനകള്‍',
	'confirmaccount-leg-user'         => 'ഉപയോക്തൃഅക്കൗണ്ട്',
	'confirmaccount-leg-areas'        => 'താല്പര്യമുള്ള പ്രധാന മേഖലകള്‍',
	'confirmaccount-leg-person'       => 'വ്യക്തിഗത വിവരങ്ങള്‍',
	'confirmaccount-leg-other'        => 'മറ്റ് വിവരങ്ങള്‍',
	'confirmaccount-name'             => 'ഉപയോക്തൃനാമം',
	'confirmaccount-real'             => 'പേര്‌:',
	'confirmaccount-email'            => 'ഇമെയില്‍:',
	'confirmaccount-reqtype'          => 'സ്ഥാനം:',
	'confirmaccount-pos-0'            => 'ലേഖകന്‍',
	'confirmaccount-pos-1'            => 'എഡിറ്റര്‍',
	'confirmaccount-bio'              => 'ആത്മകഥ:',
	'confirmaccount-attach'           => 'റെസ്യൂം/സിവി:',
	'confirmaccount-notes'            => 'കൂടുതല്‍ കുറിപ്പുകള്‍:',
	'confirmaccount-urls'             => 'വെബ്ബ്സൈറ്റുകളുടെ പട്ടിക:',
	'confirmaccount-none-p'           => '(ഒന്നും നല്‍കിയിട്ടില്ല)',
	'confirmaccount-confirm'          => 'താഴെയുള്ള ഓപ്ഷന്‍സ് ഉപയോഗിച്ച് ഈ അഭ്യര്‍ത്ഥന സ്വീകരിക്കുകയോ, നിരസിക്കുകയോ, തടഞ്ഞുവെക്കുകയോ ചെയ്യുക:',
	'confirmaccount-econf'            => '(സ്ഥിരീകരിച്ചിരിക്കുന്നു)',
	'confirmaccount-reject'           => '([[User:$1|$1]] എന്ന ഉപയോക്താവിനാല്‍ $2നു ഇതു നിരസിക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-noreason'         => '(ഒന്നുമില്ല)',
	'confirmaccount-autorej'          => '(പ്രവര്‍ത്തനരാഹിത്യം മൂലം ഈ അഭ്യര്‍ത്ഥന യാന്ത്രികമായി നിരസിക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-held'             => '([[User:$1|$1]] എന്ന ഉപയോക്താവിനാല്‍ $2നു ഈ അപേക്ഷ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-create'           => 'സ്വീകരിക്കുക (അക്കൗണ്ട് സൃഷ്ടിക്കുക)',
	'confirmaccount-deny'             => 'നിരാകരിക്കുക (പട്ടികയില്‍ നിന്നു ഒഴിവാക്കുക)',
	'confirmaccount-hold'             => 'തടഞ്ഞുവെക്കുക',
	'confirmaccount-spam'             => 'സ്പാം (ഇമെയില്‍ അയക്കരുത്)',
	'confirmaccount-reason'           => 'അഭിപ്രായന്‍ (ഇമെയിലില്‍ ഉള്‍പ്പെടുത്തുന്നതാണ്‌):',
	'confirmaccount-ip'               => 'ഐപി വിലാസം:',
	'confirmaccount-submit'           => 'സ്ഥിരീകരിക്കുക',
	'confirmaccount-needreason'       => 'താഴെയുള്ള കമെന്റ് പെട്ടിയില്‍ ഒരു കാരണം നിര്‍ബന്ധമായും രേഖപ്പെടുത്തണം.',
	'confirmaccount-canthold'         => 'ഈ അഭ്യര്‍ത്ഥന ഒന്നുകില്‍ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്നു അല്ലെങ്കില്‍ മായ്ക്കപ്പെട്ടിരിക്കുന്നു.',
	'confirmaccount-acc'              => 'അക്കൗണ്ട് ഉണ്ടാക്കാനുള്ള അഭ്യര്‍ത്ഥന വിജയകരമായി സ്ഥിരീകരിച്ചിരിക്കുന്നു; പുതിയ ഉപയോക്തൃഅക്കൗണ്ട് സൃഷ്ടിച്ചിരിക്കുന്നു [[User:$1]].',
	'confirmaccount-rej'              => 'അക്കൗണ്ട് ഉണ്ടാക്കാനുള്ള അഭ്യര്‍ത്ഥന വിജയകരമായി നിരാകരിച്ചിരിക്കുന്നു.',
	'confirmaccount-viewing'          => '(നിലവില്‍ [[User:$1|$1]] എന്ന ഉപയോക്താവ് വീക്ഷിക്കുന്നു)',
	'confirmaccount-summary'          => 'പുതിയ ഉപയോക്താവിന്റെ വ്യക്തിഗത വിവരങ്ങളും വെച്ച് ഉപയോക്തൃതാള്‍ നിര്‍മ്മിച്ചുകൊണ്ടിരിക്കുന്നു.',
	'confirmaccount-welc'             => "'''{{SITENAME}} സം‌രംഭത്തിലേക്ക് സ്വാഗതം'''.  താങ്കള്‍ ഇവിടെ നല്ല സംഭാവനകള്‍ ചെയ്യുമെന്നു പ്രതീക്ഷിക്കട്ടെ. താങ്കള്‍ക്ക് [[{{MediaWiki:Helppage}}|സഹായ താളുകള്‍]] വായിക്കുന്നതു ഗുണം ചെയ്തേക്കാം. ഒരിക്കല്‍ കൂടി സ്വാഗതം ചെയ്യുകയും ഇവിടം ആസ്വദിക്കുമെന്നു കരുതുകയും ചെയ്യുന്നു.",
	'confirmaccount-wsum'             => 'സ്വാഗതം!',
	'confirmaccount-email-subj'       => '{{SITENAME}} സം‌രംഭത്തില്‍ അക്കൗണ്ട് സൃഷ്ടിക്കാനുള്ള അഭ്യര്‍ത്ഥന',
	'usercredentials-user'            => 'ഉപയോക്തൃനാമം:',
	'usercredentials-leg-user'        => 'ഉപയോക്തൃഅക്കൗണ്ട്',
	'usercredentials-leg-areas'       => 'താല്പര്യമുള്ള പ്രധാന മേഖലകള്‍',
	'usercredentials-leg-person'      => 'വ്യക്തിഗത വിവരങ്ങള്‍',
	'usercredentials-leg-other'       => 'മറ്റ് വിവരങ്ങള്‍',
	'usercredentials-email'           => 'ഇമെയില്‍',
	'usercredentials-real'            => 'യഥാര്‍ത്ഥ പേര്‌:',
	'usercredentials-bio'             => 'ആത്മകഥ:',
	'usercredentials-attach'          => 'റെസ്യൂം/സിവി:',
	'usercredentials-notes'           => 'കൂടുതല്‍ കുറിപ്പുകള്‍:',
	'usercredentials-urls'            => 'വെബ്ബ് സൈറ്റുകളുടെ പട്ടിക:',
	'usercredentials-ip'              => 'യഥാര്‍ത്ഥ IP വിലാസം:',
	'usercredentials-member'          => 'അവകാശങ്ങള്‍',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'requestaccount'                  => 'खाते मागवा',
	'requestaccount-text'             => "'''खाते तयार करण्यासाठी खालील अर्ज भरून पाठवा'''.

अर्ज पाठविण्यापूर्वी तुम्ही [[{{MediaWiki:Requestaccount-page}}|अटी व नियम]] वाचलेले असल्याची खात्री करा.

एकदा का खाते तयार झाले की तुम्हाला तसा इमेल संदेश येईल व तुम्ही [[Special:Userlogin]] मध्ये प्रवेश करू शकाल.",
	'requestaccount-page'             => '{{ns:project}}:अटी व नियम',
	'requestaccount-dup'              => "'''सूचना: तुम्ही अगोदरच नोंदीकृत खात्यामधून प्रवेश केलेला आहे.'''",
	'requestaccount-leg-user'         => 'सदस्य खाते',
	'requestaccount-leg-areas'        => 'मुख्य पसंती',
	'requestaccount-leg-person'       => 'वैयक्तिक माहिती',
	'requestaccount-leg-other'        => 'इतर माहिती',
	'requestaccount-acc-text'         => 'ही मागणी पूर्ण झाल्यावर तुमच्या इमेल पत्त्यावर एक संदेश येईल. कृपया त्या संदेशात दिलेल्या दुव्यावर टिचकी मारुन सदस्य खात्याची खात्री करा. खाते तयार झाल्यावर परवलीचा शब्द तुमच्या इमेल वर पाठविला जाईल.',
	'requestaccount-areas-text'       => 'खालील क्षेत्रांपैकी तुमच्या पसंतीचे तसेच तुम्ही जाणकार असलेले विषय निवडा.',
	'requestaccount-ext-text'         => 'खालील माहिती ही गोपनीय असेल व फक्त या मागणी करताच वापरली जाईल.
तुम्ही ओळख पटविण्यासाठी एखादा संपर्क क्रमांक देऊ शकता.',
	'requestaccount-bio-text'         => 'तुमची वैयक्तिक माहिती तुमच्या सदस्य पानावर दिसेल.
काही विशेष उल्लेखनीय कामगिरी असल्यास ती वाढविण्याचा प्रयत्न करा.
तसेच ही माहिती प्रकाशित करण्यास तुमची हरकत नाही हे तपासून पहा.
तुमचे नाव तुम्ही [[Special:Preferences]] मध्ये बदलू शकता.',
	'requestaccount-real'             => 'खरे नाव:',
	'requestaccount-same'             => '(खर्‍या नावा प्रमाणेच)',
	'requestaccount-email'            => 'इमेल पत्ता:',
	'requestaccount-reqtype'          => 'हुद्दा:',
	'requestaccount-level-0'          => 'लेखक',
	'requestaccount-level-1'          => 'संपादक',
	'requestaccount-bio'              => 'वैयक्तिक माहिती:',
	'requestaccount-attach'           => 'रिज्यूम किंवा सीव्ही (CV) (वैकल्पिक):',
	'requestaccount-notes'            => 'अधिक माहिती:',
	'requestaccount-urls'             => 'संकेतस्थळांची यादी (एका ओळीत एक):',
	'requestaccount-agree'            => 'तुम्ही दिलेले स्वत:चे खरे नाव हे बरोबर असल्याचे नमूद करा तसेच तुम्हाला अटी व नियम मान्य आहेत असे नमूद करा.',
	'requestaccount-inuse'            => 'तुम्ही दिलेले सदस्यनाव या आधीच कुणीतरी खाते उघडण्यासाठी मागितलेले आहे.',
	'requestaccount-tooshort'         => 'तुमच्या वैयक्तिक माहिती मध्ये कमीतकमी $1 शब्द असणे आवश्यक आहे.',
	'requestaccount-emaildup'         => 'तुम्ही दिलेला इमेल पत्ता दुसर्‍या एका पूर्ण न झालेल्या मागणीमध्ये नोंदलेला आहे.',
	'requestaccount-exts'             => 'जोडण्याच्या संचिकेचा प्रकार वापरायला परवानगी नाही.',
	'requestaccount-resub'            => 'तुमच्या रिज्यूमची संचिका सुरक्षेच्या कारणास्तव पुन्हा निवडणे आवश्यक आहे.
जर तुम्ही चढवू इच्छित नसाल तर तो रकाना रिकामा ठेवा.',
	'requestaccount-tos'              => 'मी {{SITENAME}} वरचे [[{{MediaWiki:Requestaccount-page}}|नियम व अटी]] वाचलेले असून त्यांना बांधील राहण्याचे वचन देतो.
तसेच मी दिलेले "खरे नाव" हे माझेच खरे नाव आहे.',
	'requestaccount-submit'           => 'खाते मागवा',
	'requestaccount-sent'             => 'तुमची खात्याची मागणी नोंदलेली आहे व पुनर्तपासणीसाठी गेलेली आहे.',
	'request-account-econf'           => 'तुमचा इमेल पत्ता तपासलेला आहे व तो तुमच्या खात्याच्या मागणीमध्ये नोंदला जाईल.',
	'requestaccount-email-subj'       => '{{SITENAME}} इमेल पत्ता तपासणी',
	'requestaccount-email-body'       => 'कुणीतरी, बहुतेक तुम्ही, $1 या आयपी अंकपत्त्यावरून, {{SITENAME}} वर "$2" हे खाते उघडण्याची मागणी ह्या इमेल पत्त्यावर नोंदविलेली आहे.

{{SITENAME}} वरील हे खाते तुमचेच असल्याची खात्री करण्यासाठी कृपया खालील दुव्यावर टिचकी मारा:

$3

जर तुमचे खाते तयार झाले, तर तुम्हाला परवलीचा शब्द इमेलमार्फत पाठविण्यात येईल. जर ही मागणी तुम्ही दिलेली *नसेल*, तर दुव्यावर टिचकी मारू नका.
हा खात्री कोड $4 नंतर रद्द होईल.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} खाते मागणी',
	'requestaccount-email-body-admin' => '"$1" ने एक खात्याची मागणी नोंदविलेली आहे व ती तुमच्या सहमतीची वाट पाहत आहे.
इमेल पत्ता तपासलेला आहे. तुम्ही तुमची सहमती "$2" इथे नोंदवू शकता.',
	'acct_request_throttle_hit'       => 'माफ करा, तुम्ही अगोदरच $1 खात्यांची मागणी नोंदविलेली आहे. तुम्ही अजून मागण्या नोंदवू शकत नाही.',
	'requestaccount-loginnotice'      => "सदस्य खाते मिळविण्यासाठी तुम्ही तुमची '''[[Special:RequestAccount|मागणी नोंदवा]]'''.",
	'confirmaccount-newrequests'      => "'''$1''' इमेल पत्ता तपासलेला आहे {{PLURAL:$1|[[Special:ConfirmAccounts|खात्याची मागणी]]|[[Special:ConfirmAccounts|खात्यांची मागणी]]}} शिल्लक",
	'confirmaccounts'                 => 'खाते मागणीला सहमती द्या',
	'confirmedit-desc'                => 'अधिकार्‍यांना (bureaucrats) खाते मागणी पूर्ण करण्याचे अधिकार देते',
	'confirmaccount-maintext'         => "'''''{{SITENAME}}'' वरील प्रलंबित खाते मागण्या पूर्ण करण्यासाठी हे पान वापरले जाते'''.

प्रत्येक खाते मागणी तीन विभांगांत दिलेली आहे, एक प्रलंबित मागणी साठी, एक ज्याला इतर प्रबंधकांनी प्रलंबित ठेवलेले आहे व तिसरा ज्या मागण्या अलीकडील काळात नाकारलेल्या आहेत. 

एखाद्या मागणीला सहमती देताना, काळजीपूर्वक तपासा तसेच दिलेली माहिती पूर्ण असल्याची खात्री करा.  
तुमच्या क्रिया गोपनीयरित्या नोंदल्या जातील. तुम्ही करत असलेल्या क्रियांबरोबरच इतरांनी केलेल्या क्रिया तपासून पहा.",
	'confirmaccount-list'             => 'खाली प्रलंबित खाते मागण्यांची यादी आहे. एखादी मागणी स्वीकारण्यात अथवा नाकारण्यात आल्यानंतर ती या यादीतून वगळली जाईल.',
	'confirmaccount-list2'            => 'खाली अलीकडील काळात नाकारण्यात आलेल्या मागण्यांची यादी आहे. ही यादी काही ठराविक दिवसांनंतर रिकामी केली जाईल. तुम्ही पूर्वी नाकारलेल्या मागण्या खाते नोंदणीकरता स्वीकारू शकता. पण असे करण्यापूर्वी नाकारलेल्या प्रबंधकांशी संपर्क साधा.',
	'confirmaccount-list3'            => 'खाली आपोआप रद्द झालेल्या खाते मागण्यांची यादी आहे. काही ठराविक दिवसांनंतर त्या मागण्या या यादीतून वगळल्या जातील. तुम्ही या मागण्या पूर्ण करू शकता.',
	'confirmaccount-text'             => "'''{{SITENAME}}''' वरील ही एक प्रलंबित खाते मागणी आहे.

खालील माहिती काळजीपूर्वक तपासा. जर तुम्ही ही मागणी स्वीकारणार असाल, तर स्थिती च्या पुढे या सदस्याची स्थिती निवडा.
अर्जातील माहिती मध्ये केलेले बदल कायमस्वरूपी जतन केले जाणार नाहीत. तुम्ही हे खाते दुसर्‍या नावाने सुद्धा उघडू शकता याची नोंद घ्या.
हे फक्त इतर सदस्यनावांशी साम्य असलेल्या बाबतीतच वापरावे.

तुम्ही जर ही मागणी स्वीकारली अथवा नाकारली नाहीत, तर ती प्रलंबित ठेवली जाईल.",
	'confirmaccount-none-o'           => 'या यादीत सध्या एकही प्रलंबित खाते मागणी नाही.',
	'confirmaccount-none-h'           => 'या यादीत सध्या एकही प्रलंबित ठेवलेली खाते मागणी नाही.',
	'confirmaccount-none-r'           => 'या यादीत सध्या एकही नाकारण्यात आलेली खाते मागणी नाही.',
	'confirmaccount-none-e'           => 'या यादीत सध्या एकही रद्द झालेली खाते मागणी नाही.',
	'confirmaccount-real-q'           => 'नाव',
	'confirmaccount-email-q'          => 'विपत्र',
	'confirmaccount-bio-q'            => 'चरित्र',
	'confirmaccount-showopen'         => 'प्रलंबित मागण्या',
	'confirmaccount-showrej'          => 'नाकारलेल्या मागण्या',
	'confirmaccount-showheld'         => 'प्रलंबित ठेवलेल्या मागण्या',
	'confirmaccount-showexp'          => 'रद्द झालेल्या मागण्या',
	'confirmaccount-review'           => 'समीक्षण',
	'confirmaccount-types'            => 'खालील पैकी एक खाते सहमती रांग निवडा:',
	'confirmaccount-all'              => '(सर्व रांगा दाखवा)',
	'confirmaccount-type'             => 'रांग:',
	'confirmaccount-type-0'           => 'इच्छुक लेखक',
	'confirmaccount-type-1'           => 'इच्छुक संपादक',
	'confirmaccount-q-open'           => 'प्रलंबित मागण्या',
	'confirmaccount-q-held'           => 'प्रलंबित ठेवलेल्या मागण्या',
	'confirmaccount-q-rej'            => 'अलीकडील काळात नाकारलेल्या मागण्या',
	'confirmaccount-q-stale'          => 'रद्द झालेल्या मागण्या',
	'confirmaccount-badid'            => 'दिलेल्या क्रमांकाशी जुळणारी प्रलंबित मागणी सापडली नाही.
ती आधीच तपासली गेलेली असू शकते.',
	'confirmaccount-leg-user'         => 'सदस्य खाते',
	'confirmaccount-leg-areas'        => 'पसंतीची मुख्य क्षेत्रे',
	'confirmaccount-leg-person'       => 'वैयक्तिक माहिती',
	'confirmaccount-leg-other'        => 'इतर माहिती',
	'confirmaccount-name'             => 'सदस्यनाव',
	'confirmaccount-real'             => 'नाव:',
	'confirmaccount-email'            => 'इमेल:',
	'confirmaccount-reqtype'          => 'स्थिती:',
	'confirmaccount-pos-0'            => 'लेखक',
	'confirmaccount-pos-1'            => 'संपादक',
	'confirmaccount-bio'              => 'चरित्र:',
	'confirmaccount-attach'           => 'रिज्यूम/सीव्ही:',
	'confirmaccount-notes'            => 'अधिक माहिती:',
	'confirmaccount-urls'             => 'संकेतस्थळांची यादी:',
	'confirmaccount-none-p'           => '(दिलेले नाही)',
	'confirmaccount-confirm'          => 'ही मागणी स्वीकारण्यासाठी, प्रलंबित ठेवण्यासाठी किंवा नाकारण्यासाठी खालील रकाने निवडा:',
	'confirmaccount-econf'            => '(खात्री केलेले)',
	'confirmaccount-reject'           => '([[User:$1|$1]] ने $2 वर नाकारली)',
	'confirmaccount-rational'         => 'अर्जदाराला दिलेले कारण (rationale):',
	'confirmaccount-noreason'         => '(काहीही नाही)',
	'confirmaccount-autorej'          => '(ही मागणी अकार्यक्षमतेमुळे आपोआप नाकारण्यात आलेली आहे)',
	'confirmaccount-held'             => '([[User:$1|$1]] ने $2 वर "प्रलंबित ठेवलेली" आहे)',
	'confirmaccount-create'           => 'मान्य करा (खाते तयार करा)',
	'confirmaccount-deny'             => 'नाकारा (यादीतून काढून टाका)',
	'confirmaccount-hold'             => 'प्रलंबित ठेवा',
	'confirmaccount-spam'             => 'स्पॅम (इमेल पाठवू नका)',
	'confirmaccount-reason'           => 'शेरा (इमेल मध्ये लिहिला जाईल):',
	'confirmaccount-ip'               => 'अंक पत्ता:',
	'confirmaccount-submit'           => 'खात्री करा',
	'confirmaccount-needreason'       => 'तुम्ही खालील शेरा पेटीमध्ये कारण देणे आवश्यक आहे.',
	'confirmaccount-canthold'         => 'ही मागणी अगोदरच प्रलंबित ठेवलेली किंवा नाकारलेली आहे.',
	'confirmaccount-acc'              => 'खाते मागणी यशस्वीरित्या पूर्ण; [[User:$1]] हे नवीन खाते तयार केले.',
	'confirmaccount-rej'              => 'खाते मागणी यशस्वीरित्या नाकारण्यात आलेली आहे.',
	'confirmaccount-viewing'          => '([[User:$1|$1]] ने पहारा दिलेला आहे)',
	'confirmaccount-summary'          => 'नवीन सदस्याच्या माहितीप्रमाणे सदस्य पान तयार करीत आहे.',
	'confirmaccount-welc'             => "'''''{{SITENAME}}'' वर आपले स्वागत आहे!''' आम्ही आशा करतो की आपण इथे योगदान द्याल.
तुम्ही कदाचित [[{{MediaWiki:Helppage}}|साहाय्य पाने]] वाचू इच्छित असाल. पुन्हा एकदा, स्वागत!",
	'confirmaccount-wsum'             => 'सुस्वागतम्‌!',
	'confirmaccount-email-subj'       => '{{SITENAME}} खाते मागणी',
	'confirmaccount-email-body'       => '{{SITENAME}} वर दिलेली तुमची खाते मागणी स्वीकारण्यात आलेली आहे.

खाते नाव: $1

परवलीचा शब्द: $2

सुरक्षेच्या कारणास्तव पहिल्यांदा प्रवेश केल्यानंतर तुमचा परवलीचा शब्द बदलणे आवश्यक आहे. प्रवेश करण्यासाठी, कृपया {{fullurl:Special:Userlogin}} इथे जा.',
	'confirmaccount-email-body2'      => '{{SITENAME}} वरची तुमची "$1" खाते मागणी स्वीकारण्यात आलेली आहे.

खाते नाव: $1

परवलीचा शब्द: $2

$3

सुरक्षेच्या कारणास्तव पहिल्यांदा प्रवेश केल्यावर तुम्हाला परवलीचा शब्द बदलावा लागेल. प्रवेश करण्यासाठी {{fullurl:Special:Userlogin}} इथे जा.',
	'confirmaccount-email-body3'      => 'माफ करा, {{SITENAME}} वरची तुमची "$1" खाते मागणी नाकारण्यात आलेली आहे.

याची अनेक कारणे असू शकतात.
तुम्ही अर्ज चुकीचा भरला असू शकतो, किंवा योग्य लांबीची उत्तरे दिली नसतील, किंवा काही विशिष्ट माहिती मध्ये कमतरता असेल
संकेतस्थळावर संपर्क यादी असू शकते जी वापरून तुम्ही या बद्दल अधिक माहिती मिळवू शकाल.',
	'confirmaccount-email-body4'      => 'माफ करा, {{SITENAME}} वरची तुमची "$1" खाते मागणी नाकारण्यात आलेली आहे.

$2

संकेतस्थळावर संपर्क यादी असू शकते जी वापरून तुम्ही या बद्दल अधिक माहिती मिळवू शकाल.',
	'confirmaccount-email-body5'      => '{{SITENAME}} वरची तुमची "$1" खाते मागणी स्वीकारण्यापूर्वी तुम्ही अधिक माहिती देणे गरजेचे आहे.

$2

संकेतस्थळावर संपर्क यादी असू शकते जी वापरून तुम्ही या बद्दल अधिक माहिती मिळवू शकाल.',
	'usercredentials'                 => 'सदस्याची शिफारसपत्रे',
	'usercredentials-leg'             => 'सदस्याची प्रमाणित केलेली शिफारसपत्रे पहा',
	'usercredentials-user'            => 'सदस्यनाव:',
	'usercredentials-text'            => 'खाली निवडलेल्या सदस्याची प्रमाणित केलेली शिफारसपत्रे दिलेली आहेत.',
	'usercredentials-leg-user'        => 'सदस्य खाते',
	'usercredentials-leg-areas'       => 'पसंतीची मुख्य क्षेत्रे',
	'usercredentials-leg-person'      => 'वैयक्तिक माहिती',
	'usercredentials-leg-other'       => 'इतर माहिती',
	'usercredentials-email'           => 'विपत्र:',
	'usercredentials-real'            => 'खरे नाव:',
	'usercredentials-bio'             => 'चरित्र:',
	'usercredentials-attach'          => 'रिज्यूम/सीव्ही:',
	'usercredentials-notes'           => 'अधिक माहिती:',
	'usercredentials-urls'            => 'संकेतस्थळांची यादी:',
	'usercredentials-ip'              => 'मूळ आयपी अंकपत्ता:',
	'usercredentials-member'          => 'अधिकार:',
	'usercredentials-badid'           => 'या सदस्याची शिफारसपत्रे सापडली नाहीत. सदस्य नाव बरोबर असल्याची खात्री करा.',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'requestaccount-real'    => 'Melāhuac motōcā:',
	'confirmaccount-real-q'  => 'Tōcāitl',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-review'  => 'Ticceppahuīz',
	'confirmaccount-name'    => 'Tlatēquitiltilīltōcāitl',
	'confirmaccount-real'    => 'Tōcāitl:',
	'confirmaccount-email'   => 'E-mail:',
	'usercredentials-user'   => 'Tlatēquitiltilīltōcāitl:',
	'usercredentials-email'  => 'E-mail:',
	'usercredentials-real'   => 'Melāhuac motōcā:',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'requestaccount-leg-user'  => 'Brukerkonto',
	'requestaccount-real'      => 'Echten Naam:',
	'requestaccount-email'     => 'E-Mail-Adress:',
	'requestaccount-bio'       => 'Biografie:',
	'confirmaccount-real-q'    => 'Naam',
	'confirmaccount-email-q'   => 'E-Mail',
	'confirmaccount-bio-q'     => 'Biografie',
	'confirmaccount-leg-user'  => 'Brukerkonto',
	'confirmaccount-name'      => 'Brukernaam',
	'confirmaccount-real'      => 'Naam:',
	'confirmaccount-ip'        => 'IP-Adress:',
	'confirmaccount-wsum'      => 'Willkamen!',
	'usercredentials-user'     => 'Brukernaam:',
	'usercredentials-leg-user' => 'Brukerkonto',
	'usercredentials-email'    => 'E-Mail:',
	'usercredentials-real'     => 'Echten Naam:',
	'usercredentials-bio'      => 'Biografie:',
	'usercredentials-member'   => 'Rechten:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Annabel
 * @author SPQRobin
 */
$messages['nl'] = array(
	'requestaccount'                  => 'Gebruiker aanvragen',
	'requestaccount-text'             => "'''Vul het onderstaande formulier in en stuur het op om een gebruiker aan te vragen'''. 

Zorg ervoor dat u eerst de [[{{MediaWiki:Requestaccount-page}}|voorwaarden]] leest voordat u een gebruiker aanvraagt.

Als uw aanvraag is goedgekeurd, krijgt u een e-mail en daarna kunt u aanmelden via [[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:Voorwaarden',
	'requestaccount-dup'              => "'''Let op: u bent al aangemeld met een geregistreerde gebruikersnaam.'''",
	'requestaccount-leg-user'         => 'Gebruiker',
	'requestaccount-leg-areas'        => 'Interessegebieden',
	'requestaccount-leg-person'       => 'Persoonlijke informatie',
	'requestaccount-leg-other'        => 'Overige informatie',
	'requestaccount-acc-text'         => 'U ontvangt een e-mailbevestiging als uw verzoek is ontvangen.
Reageer daar alstublieft op door te klikken op de bevestigingslink die in de e-mail staat.
U krijgt een wachtwoord als uw gebruiker is aangemaakt.',
	'requestaccount-areas-text'       => 'Selecteer hieronder de onderwerpen waarmee u ervaring hebt of waarvan u het meeste werk wil verrichten.',
	'requestaccount-ext-text'         => 'De volgende informatie wordt vertrouwelijk behandeld en wordt alleen gebruikt voor dit verzoek. 
	U kunt contactgegevens zoals een telefoonummer opgeven om te helpen bij het vaststellen van uw identiteit.',
	'requestaccount-bio-text'         => 'Uw biografie wordt opgenomen in uw gebruikerspagina.
Probeer uw belangrijkste gegevens op te nemen.
Zorg ervoor dat u achter het publiceren van dergelijke informatie staat.
U kunt uw naam wijzigen via uw [[Special:Preferences|voorkeuren]].',
	'requestaccount-real'             => 'Uw naam:',
	'requestaccount-same'             => '(gelijk aan uw naam)',
	'requestaccount-email'            => 'E-mailadres:',
	'requestaccount-reqtype'          => 'Positie:',
	'requestaccount-level-0'          => 'auteur',
	'requestaccount-level-1'          => 'redacteur',
	'requestaccount-bio'              => 'Persoonlijke biografie:',
	'requestaccount-attach'           => 'CV (optioneel):',
	'requestaccount-notes'            => 'Opmerkingen:',
	'requestaccount-urls'             => 'Lijst van websites, als van toepassing (iedere site op een aparte regel):',
	'requestaccount-agree'            => 'U moet aangegeven dat uw naam juist is en dat u akkoord gaat met de Voorwaarden.',
	'requestaccount-inuse'            => 'De gebruiker is al bekend in een aanvraagprocedure.',
	'requestaccount-tooshort'         => 'Uw biografie moet ten minste $1 woorden bevatten.',
	'requestaccount-emaildup'         => 'Een ander openstaand gebruikersverzoek gebruikt hetzelfde e-mailadres.',
	'requestaccount-exts'             => 'Bestandstype van de bijlage is niet toegestaan.',
	'requestaccount-resub'            => 'Uw CV-bestand moet opnieuw geselecteerd worden om veiligheidsredenen.
Laat het veld leeg als u geen bestand meer wilt bijvoegen.',
	'requestaccount-tos'              => 'Ik heb de [[{{MediaWiki:Requestaccount-page}}|Voorwaarden]] van {{SITENAME}} gelezen en ga ermee akkoord.
De naam die ik heb opgegeven onder "Uw naam" is inderdaad mijn eigen echte naam.',
	'requestaccount-submit'           => 'Gebruikersnaam aanvragen',
	'requestaccount-sent'             => 'Uw gebruikersaanvraag is verstuurd en wacht om nagekeken te worden.',
	'request-account-econf'           => 'Uw e-mailadres is bevestigd en wordt in uw gebruikersaanvraag opgenomen.',
	'requestaccount-email-subj'       => '{{SITENAME}} bevestiging e-mailadres',
	'requestaccount-email-body'       => 'Iemand, waarschijnlijk u, heeft vanaf  IP-adres $1 op {{SITENAME}} een verzoek gedaan
voor het aanmaken van gebruiker "$2" met dit e-mailadres.

Open de onderstaande link in uw browser om te bevestigen dat deze gebruiker op {{SITENAME}} daadwerkelijk bij u hoort:

$3

Als de gebruiker is aangemaakt krijgt alleen u een e-mail met het wachtwoord. Als de aanvraag niet van u afkomstig is, volg de link dan *niet*. 
Deze bevestigingse-mail verloopt op $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} gebruikersverzoeken',
	'requestaccount-email-body-admin' => '"$1" heeft een gebruiker aangevraagd en wacht op bevestiging.
Het e-mailadres is bevestigd.
U kunt het verzoek hier "$2" bevestigen.',
	'acct_request_throttle_hit'       => 'Sorry, maar u hebt al $1 gebruikersverzoeken gedaan. U kunt geen nieuwe verzoeken meer uitbrengen.',
	'requestaccount-loginnotice'      => "Om een gebruiker te krijgen, moet u '''[[Special:RequestAccount|een verzoek doen]]'''.",
	'confirmaccount-newrequests'      => "Op dit moment {{PLURAL:$1|staat|staan}} er '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|gebruikersverzoek|gebruikersverzoeken}}]] open.",
	'confirmaccounts'                 => 'Gebruikersverzoeken bevestigen',
	'confirmedit-desc'                => 'Geeft bureaucraten de mogelijkheid om gebruikersverzoeken te behandelen',
	'confirmaccount-maintext'         => "'''Deze pagina wordt gebruikt om openstaande gebruikersverzoeken te bevestigen op ''{{SITENAME}}'''''.

Elke lijst met gebruikersverzoeken bevat drie sublijsten: één voor openstaande verzoeken, één voor verzoeken die zijn gemarkeerd als \"in behandeling\" door andere beheerders wegens ontbrekende informatie en één voor recent geweigerde verzoeken.

Wanneer gereageerd wordt op een verzoek, kijk het dan grondig na en bevestig indien nodig de informatie van het verzoek. Uw handelingen worden niet publiek opgeslagen. U wordt verzocht om ook de handelingen die niet van u afkomstig zijn na te kijken.",
	'confirmaccount-list'             => 'Hieronder staan de gebruikersverzoeken die op afhandeling wachten.
Als een verzoek is goed- of afgekeurd, wordt het uit deze lijst verwijderd.',
	'confirmaccount-list2'            => 'Hieronder staan recentelijk afgewezen gebruikersverzoeken die die over een aantal dagen	automatisch worden verwijderd.
Ze kunnen nog steeds goedgekeurd worden, hoewel het verstandig is voorafgaand contact te zoeken met de beheerder die het verzoek heeft afgewezen.',
	'confirmaccount-list3'            => 'Hieronder staat een lijst met verlopen gebruikersaanvragen die mogelijk automatisch worden verwijderd als ze een aantal dagen oud zijn.
Ze kunnen nog steeds verwerkt worden.',
	'confirmaccount-text'             => "Dit is een openstaand gebruikersverzoek voor '''{{SITENAME}}'''.

Beoordeel alle onderstaande informatie alstublieft zorgvuldig.
Als u een verzoek goedkeurt, gebruik dan het dropdownmenu om de gebruikersstatus in te stellen.
Bewerkingen die u maakt aan de biografie die in het verzoek is opgenomen hebben geen invloed op de opgeslagen identiteit.
U kunt de gebruiker onder een andere naam aanmaken.
Doe dit alleen als er mogelijk verwarring kan optreden met andere gebruikersnamen.
	
Als u deze pagina verlaat zonder het gebruikersverzoek te bevestigen of af te wijzen, dan blijft het open staan.",
	'confirmaccount-none-o'           => 'Er zijn momenteel geen openstaande gebruikersaanvragen in deze lijst.',
	'confirmaccount-none-h'           => 'Er zijn momenteel geen uitgestelde gebruikersaanvragen in deze lijst.',
	'confirmaccount-none-r'           => 'Er zijn momenteel geen recent afgewezen gebruikersaanvragen in deze lijst.',
	'confirmaccount-none-e'           => 'Er zijn momenteel geen verlopen gebruikersaanvragen in deze lijst.',
	'confirmaccount-real-q'           => 'Naam',
	'confirmaccount-email-q'          => 'E-mail',
	'confirmaccount-bio-q'            => 'Biografie',
	'confirmaccount-showopen'         => 'open aanvragen',
	'confirmaccount-showrej'          => 'verworpen aanvragen',
	'confirmaccount-showheld'         => 'aangehouden verzoeken',
	'confirmaccount-showexp'          => 'verlopen aanvragen',
	'confirmaccount-review'           => 'toegelaten/afgewezen',
	'confirmaccount-types'            => 'Selecteer een lijst met gebruikersverzoeken:',
	'confirmaccount-all'              => '(alle lijsten weergeven)',
	'confirmaccount-type'             => 'Lijst:',
	'confirmaccount-type-0'           => 'toekomstige auteurs',
	'confirmaccount-type-1'           => 'toekomstige redacteuren',
	'confirmaccount-q-open'           => 'open verzoeken',
	'confirmaccount-q-held'           => 'afgehandelde verzoeken',
	'confirmaccount-q-rej'            => 'recent afgewezen verzoeken',
	'confirmaccount-q-stale'          => 'verlopen resultaten',
	'confirmaccount-badid'            => 'Er is geen openstaand gebruikersverzoek voor het opgegeven ID.
Wellicht is het al afgehandeld.',
	'confirmaccount-leg-user'         => 'Gebruiker',
	'confirmaccount-leg-areas'        => 'Interessegebieden',
	'confirmaccount-leg-person'       => 'Persoonlijke informatie',
	'confirmaccount-leg-other'        => 'Overige informatie',
	'confirmaccount-name'             => 'Gebruikersnaam',
	'confirmaccount-real'             => 'Naam:',
	'confirmaccount-email'            => 'E-mail:',
	'confirmaccount-reqtype'          => 'Positie:',
	'confirmaccount-pos-0'            => 'auteur',
	'confirmaccount-pos-1'            => 'redacteur',
	'confirmaccount-bio'              => 'Biografie:',
	'confirmaccount-attach'           => 'CV (informatie over u):',
	'confirmaccount-notes'            => 'Opmerkingen:',
	'confirmaccount-urls'             => 'Lijst met websites:',
	'confirmaccount-none-p'           => '(niet opgegeven)',
	'confirmaccount-confirm'          => 'Gebruik de onderstaande opties om dit verzoek goed te keuren, af te keuren of aan te houden:',
	'confirmaccount-econf'            => '(bevestigd)',
	'confirmaccount-reject'           => '(afgewezen door [[User:$1|$1]] op $2)',
	'confirmaccount-rational'         => 'Aan de aanvrager opgegeven reden:',
	'confirmaccount-noreason'         => '(geen)',
	'confirmaccount-autorej'          => '(dit verzoek is automatisch afgebroken wegens inactiviteit)',
	'confirmaccount-held'             => '("aangehouden" door [[User:$1|$1]] op $2)',
	'confirmaccount-create'           => 'Toelaten (gebruiker aanmaken)',
	'confirmaccount-deny'             => 'Afwijzen (verwijderen)',
	'confirmaccount-hold'             => 'Aanhouden',
	'confirmaccount-spam'             => 'Spam (geen e-mail sturen)',
	'confirmaccount-reason'           => 'Opmerking (zal worden toegevoegd aan de email):',
	'confirmaccount-ip'               => 'IP-adres:',
	'confirmaccount-submit'           => 'Bevestigen',
	'confirmaccount-needreason'       => 'U moet een reden geven in het onderstaande veld.',
	'confirmaccount-canthold'         => 'Dit verzoek heeft al de status aangehouden of verwijderd.',
	'confirmaccount-acc'              => 'Gebruikersverzoek goedgekeurd. De gebruiker [[User:$1]] is aangemaakt.',
	'confirmaccount-rej'              => 'Gebruikersverzoek afgewezen.',
	'confirmaccount-viewing'          => '(op dit ogenblik bekeken door [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Er wordt een gebruikerspagina gemaakt met de biografie van de nieuwe gebruiker.',
	'confirmaccount-welc'             => "'''Welkom bij ''{{SITENAME}}''!''' We hopen dat u veel goede bijdragen levert. 
Waarschijnlijk wilt u de [[{{MediaWiki:Helppage}}|hulppagina's]] lezen. Nogmaals, welkom en veel plezier!",
	'confirmaccount-wsum'             => 'Welkom!',
	'confirmaccount-email-subj'       => '{{SITENAME}} gebruikersverzoek',
	'confirmaccount-email-body'       => 'Uw gebruikersverzoek op {{SITENAME}} is goedgekeurd.

Gebruiker: $1

Wachtwoord: $2

Om beveiligingsredenen dient u uw wachtwoord bij de eerste keer aanmelden te wijzigen. Aanmelden kan via 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Uw gebruikersverzoek op {{SITENAME}} is goedekeurd.

Gebruikersnaam: $1

Wachtwoord: $2

$3

Om beveiligingsredenen dient u uw wachtwoord bij de eerste keer aanmelden te wijzigen. Aanmelden kan via 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Sorry, uw gebruikersverzoek voor "$1" op {{SITENAME}} is afgewezen.

Dit kan meerdere oorzaken hebben.
Mogelijk hebt u het formulier niet volledig ingevuld, waren uw antwoorden onvoldoende compleet, of hebt u om een andere reden niet voldaan aan de eisen.
Op de site staan mogelijk lijsten met contactgegevens als u meer wilt weten over het gebruikersbeleid.',
	'confirmaccount-email-body4'      => 'Sorry, uw gebruikersverzoek voor "$1" op {{SITENAME}} is afgewezen.

$2

Op de site staan mogelijk lijsten met contactgegevens als u meer wilt weten over het gebruikersbeleid.',
	'confirmaccount-email-body5'      => 'Voordat uw aanvraag voor een gebruiker "$1" aanvaard kan worden op {{SITENAME}}, moet u eerst extra informatie geven.

$2

Er kunnen contacteerlijsten zijn die u kunt gebruiken als u meer wil te weten komen over het beleid ten aanzien van gebruikers.',
	'usercredentials'                 => 'Referenties van gebruiker',
	'usercredentials-leg'             => 'Bevestigde referenties voor gebruiker',
	'usercredentials-user'            => 'Gebruikersnaam:',
	'usercredentials-text'            => 'Overzicht van de bevestigde referenties voor de geselecteerde gebruiker:',
	'usercredentials-leg-user'        => 'Gebruiker',
	'usercredentials-leg-areas'       => 'Interessegebieden',
	'usercredentials-leg-person'      => 'Persoonlijke informatie',
	'usercredentials-leg-other'       => 'Overige informatie',
	'usercredentials-email'           => 'E-mail:',
	'usercredentials-real'            => 'Echte naam:',
	'usercredentials-bio'             => 'Biografie:',
	'usercredentials-attach'          => 'CV:',
	'usercredentials-notes'           => 'Overige opmerkingen:',
	'usercredentials-urls'            => 'Lijst van websites:',
	'usercredentials-ip'              => 'Oorspronkelijk IP-adres:',
	'usercredentials-member'          => 'Rechten:',
	'usercredentials-badid'           => 'Geen referenties gevonden voor deze gebruiker.
Kijk na of de naam correct gespeld is.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'requestaccount-real'     => 'Verkeleg namn:',
	'confirmaccount-real-q'   => 'Namn',
	'confirmaccount-email-q'  => 'E-post',
	'confirmaccount-name'     => 'Brukarnamn',
	'confirmaccount-real'     => 'Namn:',
	'confirmaccount-email'    => 'E-post:',
	'confirmaccount-noreason' => '(ingen)',
	'confirmaccount-ip'       => 'IP-adresse:',
	'confirmaccount-submit'   => 'Stadfest',
	'usercredentials-user'    => 'Brukarnamn:',
	'usercredentials-email'   => 'E-post:',
	'usercredentials-real'    => 'Verkeleg namn:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Siebrand
 */
$messages['no'] = array(
	'requestaccount'                  => 'Etterspør konto',
	'requestaccount-text'             => "'''Fullfør og lever følgende skjema for å etterspørre en brukerkonto.'''

Forsikre deg om at du først leser [[{{MediaWiki:Requestaccount-page}}|tjenestevilkårene]] før du etterspør en konto.

Når kontoen godkjennes vil du få beskjed på e-post, og du vil kunne logge inn via [[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:Tjenestevilkår',
	'requestaccount-dup'              => "'''Merk: Du er allerede logget inn med en registrert konto.'''",
	'requestaccount-leg-user'         => 'Brukerkonto',
	'requestaccount-leg-areas'        => 'Hovedinteresser',
	'requestaccount-leg-person'       => 'Personlig informasjon',
	'requestaccount-leg-other'        => 'Annen informasjon',
	'requestaccount-acc-text'         => 'Du vil få en e-post med bekreftelse med en gang denne forespørselen postes. Vennligst svar ved å klikke på bekreftelseslenka i e-posten. Passordet ditt vil også sendes til deg når kontoen opprettes.',
	'requestaccount-areas-text'       => 'Velg det eller de områdene nedenfor som du har formell ekspertise i eller vil jobbe mest med.',
	'requestaccount-ext-text'         => 'Følgende informasjon vil holdes privat, og vil kun brukes for denne forespørselen. Du vil kanskje liste opp kontaktinformasjon som et telefonnummer for å hjelpe til i bekreftelsesprosessen.',
	'requestaccount-bio-text'         => 'Biografien din vil settes som standardinnhold på brukersiden din. Prøv å inkludere attestinformasjon, men kun om du føler deg tilpass med å frigi slik informasjon. Navnet ditt kan endres via [[Special:Preferences|innstillingene]].',
	'requestaccount-real'             => 'Virkelig navn:',
	'requestaccount-same'             => '(samme som virkelig navn)',
	'requestaccount-email'            => 'E-postadresse:',
	'requestaccount-reqtype'          => 'Stilling:',
	'requestaccount-level-0'          => 'forfatter',
	'requestaccount-level-1'          => 'redaktør',
	'requestaccount-bio'              => 'Personlig biografi:',
	'requestaccount-attach'           => 'Resyme eller CV (valgfri):',
	'requestaccount-notes'            => 'Andre merknader:',
	'requestaccount-urls'             => 'Liste over nettsider, om det er noen (skill dem fra hverandre med linjeskift):',
	'requestaccount-agree'            => 'Du må bekrefte at ditt virkelige navn er korrekt og at du går med på våre tjenestevilkår.',
	'requestaccount-inuse'            => 'Brukernavnet er allerede i bruk i en ventende kontoforespørsel.',
	'requestaccount-tooshort'         => 'Biografien din må være minst $1 ord lang.',
	'requestaccount-emaildup'         => 'En annen ventende kontoforespørsel bruker samme e-postadresse.',
	'requestaccount-exts'             => 'Filtypen på vedlegget er ikke tillatt.',
	'requestaccount-resub'            => 'CV-/resyme-filen din må velges på nytt av sikkerhetshensyn. La feltet være tomt om du ikke lenger ønsker å legge ved en.',
	'requestaccount-tos'              => 'Jeg har lest og vil følge [[{{MediaWiki:Requestaccount-page}}|tjenestevilkårene]] til {{SITENAME}}. Navnet jeg har oppgitt under «Virkelig navn» er mitt faktiske navn.',
	'requestaccount-submit'           => 'Etterspør konto',
	'requestaccount-sent'             => 'Kontoforespørselen din har blitt sendt, og venter på godkjenning.',
	'request-account-econf'           => 'E-postadressen din er nå bekreftet, og vil listes slik i kontoforespørselen.',
	'requestaccount-email-subj'       => 'E-postbekreftelse hos {{SITENAME}}',
	'requestaccount-email-body'       => 'Noen, antageligvis deg fra IP-adressen $1, har etterspurt en konto «$2» med denne e-postadressen på {{SITENAME}}.

Åpne denne lenken i nettleseren din for å bekrefte at denne forespørselen virkelig kommer fra deg:

$3

Om kontoen blir opprettet vil kun du motta passordet. Om forespørselen *ikke* kommer fra deg, ikke følg lenken. Denne bekreftelseskoden utløper $4.',
	'requestaccount-email-subj-admin' => 'Kontoforespørsel på {{SITENAME}}',
	'requestaccount-email-body-admin' => '«$1» har etterspurt en konto og venter på godkjenning. E-postadressen er bekreftet. Du kan godkjenne forespørselen her: «$2».',
	'acct_request_throttle_hit'       => 'Beklager, du har allerede etterspurt $1 kontoer. Du kan ikke etterspørre flere.',
	'requestaccount-loginnotice'      => "For å få en brukerkonto må du '''[[Special:RequestAccount|etterspørre en]]'''.",
	'confirmaccount-newrequests'      => "Det er foreløpig '''$1''' {{PLURAL:$1|åpen [[Special:ConfirmAccounts|kontoforespørsel]]|åpne [[Special:ConfirmAccounts|kontoforespørsler]]}}.",
	'confirmaccounts'                 => 'Godkjenn kontoforespørsler',
	'confirmedit-desc'                => 'Gir byråkrater muligheten til å godkjenne kontoforespørsler.',
	'confirmaccount-maintext'         => "'''Denne siden brukes for å bekrefte ventende kontoforespørsel på ''{{SITENAME}}'''''.

Hver kontoforespørselkø består av tre underkøer, én for åpne forespørsler, én for forespørsler som er satt på avventing av andre administratorer, og én for nylig avvise forespørsler.

Når du reagerer på en forespørsel, gå gjennom den  og, om det er nødvendig, bekreft informasjonen som blir gitt. Handlingene dine vil logges privat. Det forventes også at du gjennomgår den aktiviteten som er her fra andre enn deg selv.",
	'confirmaccount-list'             => 'Under er en liste over kontoforespørsler som venter på godkjenning. Godkjente kontoer vil opprettes og fjernes fra denne listen. Avviste kontoer vil kun slettes fra listen.',
	'confirmaccount-list2'            => 'Nedenfor er en liste over nylig avviste kontoforespørsler, som vil slettes automatisk når de er et visst antall dager gamle.
De kan fortsatt godkjennes, men du burde først konferere med administratoren som avviste dem.',
	'confirmaccount-list3'            => 'Nedenfor er en liste over utgåtte kontoforespørsler som vil bli slettet automatisk etter en viss tid. De kan fortsatt godkjennes.',
	'confirmaccount-text'             => "Dette er en ventende kontoforespørsel på '''{{SITENAME}}'''.

Gå nøye gjennom informasjonen nedenfor. Om du godkjenner forespørselen, bruk posisjonslisten for å sette brukerens kontostatus. Redigeringer gjort i søknadsbiografien vil ikke ha noen effekt på lagring av krediteringsinformasjon. Merk at du kan velge å opprette kontoen med et annet brukernavn, men gjør det kun for å unngå kollisjon med andre navn.

Om du forlater denne siden uten å godkjenne eller avvise forespørselen, vil den beholde avventningsstatusen.",
	'confirmaccount-none-o'           => 'Det er for tiden ingen ventende forespørsler.',
	'confirmaccount-none-h'           => 'Det er for tiden ingen ventende kontoforespørsler på denne listen.',
	'confirmaccount-none-r'           => 'Det er for tiden ingen nylig avviste kontoforespørsler på denne listen.',
	'confirmaccount-none-e'           => 'Det er for tiden ingen utgåtte kontoforespørsler på denne listen.',
	'confirmaccount-real-q'           => 'Navn',
	'confirmaccount-email-q'          => 'E-post',
	'confirmaccount-bio-q'            => 'Biografi',
	'confirmaccount-showopen'         => 'åpne forespørsler',
	'confirmaccount-showrej'          => 'avviste forespørsler',
	'confirmaccount-showheld'         => 'forespørsler holdt på avventning',
	'confirmaccount-showexp'          => 'utgåtte forespørsler',
	'confirmaccount-review'           => 'Gå gjennom',
	'confirmaccount-types'            => 'Velg en kontogodkjenningskø av de nedenstående:',
	'confirmaccount-all'              => '(vis alle køer)',
	'confirmaccount-type'             => 'Valgt kø:',
	'confirmaccount-type-0'           => 'prospektive forfattere',
	'confirmaccount-type-1'           => 'prospektive redaktører',
	'confirmaccount-q-open'           => 'åpne forespørsler',
	'confirmaccount-q-held'           => 'forespørsler holdt på avventning',
	'confirmaccount-q-rej'            => 'nylig avviste forespørsler',
	'confirmaccount-q-stale'          => 'utgåtte forespørsler',
	'confirmaccount-badid'            => 'Det er ingen ventende forespørsler med den oppgitte ID-en. De kan allerede ha blitt behandlet.',
	'confirmaccount-leg-user'         => 'Brukerkonto',
	'confirmaccount-leg-areas'        => 'Hovedinteresse',
	'confirmaccount-leg-person'       => 'Personlig informasjon',
	'confirmaccount-leg-other'        => 'Annen informasjon',
	'confirmaccount-name'             => 'Brukernavn',
	'confirmaccount-real'             => 'Navn:',
	'confirmaccount-email'            => 'E-post:',
	'confirmaccount-reqtype'          => 'Stilling:',
	'confirmaccount-pos-0'            => 'forfatter',
	'confirmaccount-pos-1'            => 'redaktør',
	'confirmaccount-bio'              => 'Biografi:',
	'confirmaccount-attach'           => 'CV:',
	'confirmaccount-notes'            => 'Andre merknader:',
	'confirmaccount-urls'             => 'Liste over nettsteder:',
	'confirmaccount-none-p'           => '(ikke oppgitt)',
	'confirmaccount-confirm'          => 'Bruk valgene nedenfor for å godkjenne, avvise eller putte forespørselen på avventning:',
	'confirmaccount-econf'            => '(bekreftet)',
	'confirmaccount-reject'           => '(avvist av [[User:$1|$1]] på $2)',
	'confirmaccount-rational'         => 'Begrunnelse gitt til søkeren:',
	'confirmaccount-noreason'         => '(ingen)',
	'confirmaccount-autorej'          => '(denne forespørselen har blitt kassert automatisk på grunn av inaktivitet)',
	'confirmaccount-held'             => '(merket for «avventning» av [[User:$1|$1]] på $2)',
	'confirmaccount-create'           => 'Godta (opprett konto)',
	'confirmaccount-deny'             => 'Avvis (fjern fra listen)',
	'confirmaccount-hold'             => 'Sett på avventning',
	'confirmaccount-spam'             => 'Søppel (ikke send e-post)',
	'confirmaccount-reason'           => 'Kommentar (blir inkludert i e-post):',
	'confirmaccount-ip'               => 'IP-adresse:',
	'confirmaccount-submit'           => 'Bekreft',
	'confirmaccount-needreason'       => 'Du må angi en grunn i kommentarfeltet nedenfor.',
	'confirmaccount-canthold'         => 'Denne forespørselen er allerede slettet eller på avventning.',
	'confirmaccount-acc'              => 'Kontoforespørsel godkjent; opprettet kontoen [[User:$1|$1]].',
	'confirmaccount-rej'              => 'Kontoforespørsel avvist.',
	'confirmaccount-viewing'          => '(undersøkes nå av [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Oppretter brukerside med biografi for den nye brukeren.',
	'confirmaccount-welc'             => "'''Velkommen til ''{{SITENAME}}''!''' Vi håper at du vil bidra mye og bra. Du ønsker trolig å lese [[{{MediaWiki:Helppage}}|hjelpesidene]]. Igjen, velkommen, og mor deg!",
	'confirmaccount-wsum'             => 'Velkommen!',
	'confirmaccount-email-subj'       => 'Kontoforespørsel på {{SITENAME}}',
	'confirmaccount-email-body'       => 'Din forespørsel om en konto på {{SITENAME}} har blitt godkjent.

Kontonavn: $1

Passord: $2

Av sikkerhetsgrunner må du endre passordet etter første innlogging. Gå til {{fullurl:Special:Userlogin}} for å logge inn.',
	'confirmaccount-email-body2'      => 'Din forespørsel om en konto på {{SITENAME}} har blitt godkjent.

Kontonavn: $1

Passord: $2

$3

Av sikkerhetsgrunner må du endre passordet etter første innlogging. Gå til {{fullurl:Special:Userlogin}} for å logge inn.',
	'confirmaccount-email-body3'      => 'Beklager, din forespørsel om kontoen «$1» på {{SITENAME}} har blitt avvist.

Det er flere mulige grunner til at dette har skjedd. Du har muligens ikke fylt inn skjemaet korrekt, har ikke svart utfyllende nok, eller møter på en annen måte ikke kriteriene. Det kan være kontaktlister på siden som du kan bruke for å finne ut mer om kontopolitikken.',
	'confirmaccount-email-body4'      => 'Beklager, din forespørsel om å få en konto ($1) på {{SITENAME}} har blitt avvist.

$2

Det kan være kontaktlister på siden som du kan bruke for å finne ut mer om kontopolitikken.',
	'confirmaccount-email-body5'      => 'Før din forespørsel om en konto «$1» på {{SITENAME}} kan godkjennes, må du oppgi mer informasjon.

$2

Det kan være kontaktlister på siden som du kan bruke for å finne ut mer om kontopolitikken.',
	'usercredentials'                 => 'Brukerattester',
	'usercredentials-leg'             => 'Finn bekreftede attester for en bruker',
	'usercredentials-user'            => 'Brukernavn:',
	'usercredentials-text'            => 'Nedenfor er de bekreftede attestene til de valgte brukerkontoene.',
	'usercredentials-leg-user'        => 'Brukerkonto',
	'usercredentials-leg-areas'       => 'Hovedinteresser',
	'usercredentials-leg-person'      => 'Personlig informasjon',
	'usercredentials-leg-other'       => 'Annen informasjon',
	'usercredentials-email'           => 'E-post:',
	'usercredentials-real'            => 'Virkelig navn:',
	'usercredentials-bio'             => 'Biografi:',
	'usercredentials-attach'          => 'CV:',
	'usercredentials-notes'           => 'Andre merknader:',
	'usercredentials-urls'            => 'Liste over nettsteder:',
	'usercredentials-ip'              => 'Opprinnelig IP-adresse:',
	'usercredentials-member'          => 'Rettigheter:',
	'usercredentials-badid'           => 'Ingen attester funnet for denne brukeren. Sjekk at navnet er stavet riktig.',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'requestaccount-real'    => 'Leina la nnete:',
	'requestaccount-email'   => 'Atrese ya email:',
	'requestaccount-level-0' => 'mongwadi',
	'requestaccount-level-1' => 'morulaganyi',
	'confirmaccount-real-q'  => 'Leina',
	'confirmaccount-real'    => 'Leina:',
	'confirmaccount-pos-0'   => 'mongwadi',
	'confirmaccount-pos-1'   => 'morulaganyi',
	'usercredentials-user'   => 'Liena la mošomiši:',
	'usercredentials-real'   => 'Leina la nnete',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author SPQRobin
 * @author Siebrand
 */
$messages['oc'] = array(
	'requestaccount'                  => "Demanda de compte d'utilizaire",
	'requestaccount-text'             => "'''Emplenatz e mandatz lo formulari çaijós per demandar un compte d’utilizaire.'''. Asseguratz-vos qu'avètz ja legit [[{{MediaWiki:Requestaccount-page}}|las condicions d’utilizacion]] abans de far vòstra demanda de compte. Un còp que lo compte es acceptat, recebretz un corrièr electronic que vos notificarà que vòstre compte poirà èsser utilizat sus [[Special:Userlogin]].",
	'requestaccount-page'             => "{{ns:project}}:Condicions d'utilizacion",
	'requestaccount-dup'              => "'''Nòta : Ja sètz sus una sesilha amb un compte enregistrat.'''",
	'requestaccount-leg-user'         => "Compte d'utilizaire",
	'requestaccount-leg-areas'        => "Centres d'interès principals",
	'requestaccount-leg-person'       => 'Entresenhas personalas',
	'requestaccount-leg-other'        => 'Autras entresenhas',
	'requestaccount-acc-text'         => 'Un messatge de confirmacion serà mandat a vòstra adreça electronica una còp que la demanda serà estada mandada. Dins lo corrièr recebut, clicatz sul ligam correspondent a la confirmacion de vòstra demanda. E mai, senhal serà mandat per corrièr electronic quand vòstre compte serà creat.',
	'requestaccount-areas-text'       => 'Causissètz los domenis dins losquals avètz una expertisa demostrada, o dins lasqualas sètz mai portat a contribuir.',
	'requestaccount-ext-text'         => 'L’informacion seguenta demòra privada e poirà èsser utilizada que per aquesta requèsta. Avètz la possibilitat de far la lista dels contactes coma un numèro de telèfon per obténer una assistància per confirmar vòstra identitat.',
	'requestaccount-bio-text'         => "Vòstra biografia serà mesa per defaut sus vòstra pagina d'utilizaire. Ensajatz d’i metre vòstras recomandacions. Asseguratz-vos que podètz difusir sens crenta las entresenhas. Vòstre nom pòt èsser cambiat en utilizant [[Special:Preferences]].",
	'requestaccount-real'             => 'Nom vertadièr :',
	'requestaccount-same'             => '(nom figurant dins vòstre estat civil)',
	'requestaccount-email'            => 'Adreça electronica:',
	'requestaccount-reqtype'          => 'Situacion :',
	'requestaccount-level-0'          => 'autor',
	'requestaccount-level-1'          => 'editor',
	'requestaccount-bio'              => 'Biografia personala :',
	'requestaccount-attach'           => 'CV/Resumit (facultatiu)',
	'requestaccount-notes'            => 'Nòtas suplementàrias :',
	'requestaccount-urls'             => "Lista dels sits Web. Se n'i a mantun, separatz-los per un saut de linha :",
	'requestaccount-agree'            => "Vos cal certificar que vòstre nom vertadièr es corrècte e qu'acceptatz las condicions d’utilizacion del servici.",
	'requestaccount-inuse'            => 'Lo nom d’utilizaire es ja utilizat dins una requèsta en cors d’aprobacion.',
	'requestaccount-tooshort'         => 'Vòstra biografia deu aver almens {{PLURAL:$1|$1 mot|$1 mots}}.',
	'requestaccount-emaildup'         => 'Una autra demanda en cors utiliza la meteissa adreça electronica.',
	'requestaccount-exts'             => 'Lo telecargament dels fiquièrs junts es pas permés.',
	'requestaccount-resub'            => 'Vòstre fiquièr de CV/resumit deu èsser seleccionat un còp de mai per de rasons de seguretat. Daissatz lo camp void se desiratz pas mai lo jonher.',
	'requestaccount-tos'              => 'Ai legit e accèpti de respectar los [[{{MediaWiki:Requestaccount-page}}|tèrmes concernent las condicions d’utilizacion dels servicis]] de {{SITENAME}}.',
	'requestaccount-submit'           => "Demanda de compte d'utilizaire.",
	'requestaccount-sent'             => "Vòstra demanda de compte d'utilizaire es estada mandada amb succès e es estada mesa dins la lista d’espèra d’aprobacion.",
	'request-account-econf'           => 'Vòstra adreça de corrièr electronic es estada confirmada e serà listada tala coma es dins vòstra demanda de compte.',
	'requestaccount-email-subj'       => '{{SITENAME}} confirmacion d’adreça de corrièr electronic.',
	'requestaccount-email-body'       => "Qualqu’un, probablament vos, a formulat, dempuèi l’adreca IP $1, una demanda de compte d'utilizaire « $2 » amb aquesta adreça de corrièr electronic sus {{SITENAME}}.

Per confirmar qu'aqueste compte vos aparten vertadièrament sus {{SITENAME}}, sètz pregat de dobrir aqueste ligam dins vòstre navigador Web :

$3 

Vòstre senhal vos serà mandat unicament se vòstre compte es creat. Se èra pas lo cas, utilizetz pas aqueste ligam. 
Aqueste còde de confirmacion expira lo $4.",
	'requestaccount-email-subj-admin' => 'Demanda de compte sus {{SITENAME}}',
	'requestaccount-email-body-admin' => "« $1 » a demandat un compte e se tròba en espèra de confirmacion.

L'adreça de corrièr electronic es estada confirmada. Podètz, d’ara endavant, aprobar la demanda aicí « $2 ».",
	'acct_request_throttle_hit'       => 'O planhèm, ja avètz demandat $1 comptes. Podètz pas far mai de demanda.',
	'requestaccount-loginnotice'      => "Per obténer un compte d'utilizaire, vos ne cal far '''[[Special:RequestAccount|la demanda]]'''.",
	'confirmaccount-newrequests'      => "Actualament i a '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|demanda de compte]]|[[Special:ConfirmAccounts|demandas de compte]]}} en cors.",
	'confirmaccounts'                 => 'Demanda de confirmacion de comptes',
	'confirmedit-desc'                => 'Balha als burocratas la possibilitat de confirmar las demandas de comptes d’utilizaires.',
	'confirmaccount-maintext'         => "'''Aquesta pagina es utilizada per confirmar las demandas de compte d'utilizaire sus ''{{SITENAME}}'''''.

Cada demanda de compte d'utilizaire consistís en tres soslistas : una per las demandas non tractadas, una pels comptes reservats dins l'espèra d'entresenhas mai amplas, e una darrièra pels comptes regetats recentament.

Al moment de la responsa a una demanda, verificatz-la atentivament e, se fa mestèr, confirmatz las informaxions qu'i son mencionadas. Vòstras accions seràn inscrichas separadament dins un jornal. Tanben podètz esperar la verificacion de cada activitat que prendràn de plaça separadament per rapòrt a çò que faretz vos-meteis.",
	'confirmaccount-list'             => "Vaquí, çaijós, la lista dels comptes en espèra d’aprobacion. Los comptes acceptats seràn creats e levats d'aquesta lista. Los comptes regetats seràn suprimits d'aquesta meteissa lista.",
	'confirmaccount-list2'            => "Veire la lista dels comptes recentament regetats losquals seràn suprimits automaticament aprèp qualques jorns. Pòdon encara èsser aprobats, e mai podètz consultar los regets abans d'o far.",
	'confirmaccount-list3'            => 'Çaijós se tròba una lista de comptes expirats que poirián èsser automaticament suprimits aprèp qualques jorns. Encara pòdon èsser aprovats.',
	'confirmaccount-text'             => "Vaquí una demanda en cors per un compte d'utilizaire sus '''{{SITENAME}}'''.

Atencion, verificatz e, se fe mestièr, confirmatz totas las entresenhas çaijós. Notatz que podètz causir de crear un compte jos un autre nom. Fasètz aquò unicament per evitar de conflictes amb d’autres noms. 

Se quitatz aquesta pagina sens confirmar o regetar aquesta demanda, serà totjorn mesa en espèra.",
	'confirmaccount-none-o'           => "Actualament i a pas cap de demanda de compte d'utilizaire en cors dins aquesta lista.",
	'confirmaccount-none-h'           => "Actualament i a pas cap de reservacion de compte d'utilizaire en cors dins aquesta lista.",
	'confirmaccount-none-r'           => "Actualament i a pas cap de regèt recent de demanda de compte d'utilizaire dins aquesta lista.",
	'confirmaccount-none-e'           => 'Actualament, i a pas cap de requèsta de compte expirada dins la lista.',
	'confirmaccount-real-q'           => 'Nom',
	'confirmaccount-email-q'          => 'Corrièr electronic',
	'confirmaccount-bio-q'            => 'Biografia',
	'confirmaccount-showopen'         => 'Requèstas dobèrtas',
	'confirmaccount-showrej'          => 'Requèstas regetadas',
	'confirmaccount-showheld'         => 'Vejatz la lista dels comptes reservats en cors de tractament',
	'confirmaccount-showexp'          => 'Requèstas expiradas',
	'confirmaccount-review'           => 'Aprobacion/Regèt',
	'confirmaccount-types'            => "Seleccionatz un compte dins la lista d'espèra çaijós :",
	'confirmaccount-all'              => "(Vejatz totas las listas d'espèra)",
	'confirmaccount-type'             => "Lista d'espèra seleccionada :",
	'confirmaccount-type-0'           => 'autors eventuals',
	'confirmaccount-type-1'           => 'editors eventuals',
	'confirmaccount-q-open'           => 'demandas fachas',
	'confirmaccount-q-held'           => 'demandas mesas en espèra',
	'confirmaccount-q-rej'            => 'demandas regetadas recentament',
	'confirmaccount-q-stale'          => 'Requèstas expiradas',
	'confirmaccount-badid'            => 'I a pas cap de demanda en cors correspondent a l’ID indicat. Es possible que aja subit una mantenença.',
	'confirmaccount-leg-user'         => "Compte d'utilizaire",
	'confirmaccount-leg-areas'        => "Centres d'interès principals",
	'confirmaccount-leg-person'       => 'Entresenhas personalas',
	'confirmaccount-leg-other'        => 'Autras entresenhas',
	'confirmaccount-name'             => "Nom d'utilizaire",
	'confirmaccount-real'             => 'Nom',
	'confirmaccount-email'            => 'Adreça de corrièr electronic :',
	'confirmaccount-reqtype'          => 'Situacion :',
	'confirmaccount-pos-0'            => 'autor',
	'confirmaccount-pos-1'            => 'editor',
	'confirmaccount-bio'              => 'Biografia :',
	'confirmaccount-attach'           => 'CV/Resumit :',
	'confirmaccount-notes'            => 'Nòtas suplementàrias :',
	'confirmaccount-urls'             => 'Lista dels sits web :',
	'confirmaccount-none-p'           => '(pas provesit)',
	'confirmaccount-confirm'          => 'Utilizatz los botons çaijós per acceptar o regetar la demanda.',
	'confirmaccount-econf'            => '(confirmat)',
	'confirmaccount-reject'           => '(regetat per [[User:$1|$1]] lo $2)',
	'confirmaccount-rational'         => 'Motiu balhat al candidat',
	'confirmaccount-noreason'         => '(nonrés)',
	'confirmaccount-autorej'          => '(Aquesta requèsta es estada abandonada automaticament per causa d’abséncia d’activitat)',
	'confirmaccount-held'             => 'Marcat « detengut » per [[User:$1|$1]] sus $2',
	'confirmaccount-create'           => 'Aprobacion (crea lo compte)',
	'confirmaccount-deny'             => 'Regèt (suprimís lo compte)',
	'confirmaccount-hold'             => 'Detengut',
	'confirmaccount-spam'             => 'Spam (mandetz pas de corrièr electronic)',
	'confirmaccount-reason'           => 'Comentari (figurarà dins lo corrièr electronic) :',
	'confirmaccount-ip'               => 'Adreça IP :',
	'confirmaccount-submit'           => 'Confirmacion',
	'confirmaccount-needreason'       => 'Vos cal indicar un motiu dins lo quadre çaiaprèp.',
	'confirmaccount-canthold'         => 'Aquesta requèsta es ja, siá presa en compte, siá suprimida.',
	'confirmaccount-acc'              => "La demanda de compte es estada confirmada amb succès ; creacion de l'utilizaire novèl [[User:$1]].",
	'confirmaccount-rej'              => 'La demanda es estada regetada amb succès.',
	'confirmaccount-viewing'          => '(actualament a èsser visionat per [[User:$1|$1]])',
	'confirmaccount-summary'          => "Creacion de la pagina d'utilizaire amb sa biografia.",
	'confirmaccount-welc'             => "'''Benvenguda sus ''{{SITENAME}}'' !'''
Esperam que contribuiretz fòrça e plan.
Desiraratz, benlèu, legir [[{{MediaWiki:Helppage}}|cossí plan amodar]].
Benvenguda encara e bona contribucions.",
	'confirmaccount-wsum'             => 'Benvenguda !',
	'confirmaccount-email-subj'       => '{{SITENAME}} demanda de compte',
	'confirmaccount-email-body'       => "Vòstra demanda de compte es estada acceptada sus {{SITENAME}}. Nom del compte d'utilizaire : $1 Senhal : $2 Per de rasons de seguretat, deuretz cambiar vòstre senhal al moment de vòstra primièra connexion. Per vos connectar, anatz sus {{fullurl:Special:Userlogin}}.",
	'confirmaccount-email-body2'      => "Vòstra demanda de compte d'utilizaire es estada acceptada sus {{SITENAME}}. Nom del compte d'utilizaire : $1 Senhal: $2 $3 Per de rasons de seguretat, deuretz cambiar vòstre senhal al moment de vòstra primièra connexion. Per vos connectar, anatz sus {{fullurl:Special:Userlogin}}.",
	'confirmaccount-email-body3'      => 'O planhèm, vòstra demanda de compte d\'utilizaire "$1" es estada regetada sus {{SITENAME}}. Mantuna rason pòdon explicar aqueste cas de figura. Es possible que ajatz mal emplenat lo formulari, o que ajatz pas indicat sufisentament d’informacions dins vòstras responsas. Es encara possible que emplenetz pas los critèris d’eligibilitat per obténer vòstre compte. Es possible d’èsser sus la lista dels contactes se desiratz conéisser melhor las condicions requesas.',
	'confirmaccount-email-body4'      => 'O planhèm, vòstra demanda de compte d\'utilizaire "$1" es estada regetada sus {{SITENAME}}. $2 Es possible d’èsser sus la lista dels contactes per conéisser melhor los critèris per poder s’inscriure.',
	'confirmaccount-email-body5'      => 'Abans que vòstra requèsta pel compte « $1 » pòsca èsser acceptada sus {{SITENAME}}, vos cal produire qualques entresenhas suplementàrias.

$2

Aquò permetís d’èsser sus la tièraa dels contactes del sit, se desiratz ne saber mai sus las règlas que concernisson los comptes.',
	'usercredentials'                 => "Referéncias de l'utilizaire",
	'usercredentials-leg'             => "Verificacion confirmada de las referéncias d'un utilizaire.",
	'usercredentials-user'            => "Nom d'utilizaire :",
	'usercredentials-text'            => "Çaijós figuran los justificatius validats pel compte d'utilizaire seleccionat.",
	'usercredentials-leg-user'        => "Compte d'utilizaire",
	'usercredentials-leg-areas'       => "Centres d'interès principals",
	'usercredentials-leg-person'      => 'Entresenhas personalas',
	'usercredentials-leg-other'       => 'Autras entresenhas',
	'usercredentials-email'           => 'Corrièr electronic :',
	'usercredentials-real'            => 'Nom vertadièr :',
	'usercredentials-bio'             => 'Biografia :',
	'usercredentials-attach'          => 'CV/Resumit :',
	'usercredentials-notes'           => 'Nòtas suplementàrias :',
	'usercredentials-urls'            => 'Lista dels sits internet :',
	'usercredentials-ip'              => 'Adreça IP iniciala :',
	'usercredentials-member'          => 'Dreches :',
	'usercredentials-badid'           => 'Cap de referéncia pas trobada per aqueste utilizaire. Verificatz que lo nom siá ben redigit.',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'requestaccount-level-0' => 'автор',
	'confirmaccount-email-q' => 'Эл. посты адрис',
	'confirmaccount-showexp' => 'eksdatiĝintaj petoj',
	'confirmaccount-name'    => 'Архайæджы ном',
	'confirmaccount-email'   => 'Эл. посты адрис:',
	'confirmaccount-pos-0'   => 'автор',
	'usercredentials-email'  => 'Эл. посты адрис:',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Wpedzich
 * @author McMonster
 * @author Equadus
 * @author Masti
 * @author Derbeth
 */
$messages['pl'] = array(
	'requestaccount'                  => 'Wniosek o założenie konta',
	'requestaccount-text'             => "'''Wypełnij i wyślij poniższy formularz jeśli chcesz mieć własne konto użytkownika'''.

Zanim jednak to zrobisz zapoznaj się z [[{{MediaWiki:Requestaccount-page}}|zasadami korzystania]] z {{GRAMMAR:D.lp|{{SITENAME}}}}.

Jeśli wniosek o założenie konta zostanie zaakceptowany, otrzymasz wiadomość e-mail i będziesz mógł [[Special:Userlogin|się zalogować]].",
	'requestaccount-page'             => '{{ns:project}}:Zasady użytkowania',
	'requestaccount-dup'              => "'''Uwaga: Jesteś już zalogowany na zarejestrowane konto.'''",
	'requestaccount-leg-user'         => 'Konto użytkownika',
	'requestaccount-leg-areas'        => 'Główne obszary zainteresowań',
	'requestaccount-leg-person'       => 'Informacje osobiste',
	'requestaccount-leg-other'        => 'Inne informacje',
	'requestaccount-acc-text'         => 'Na Twój adres e-mail zostanie wysłana wiadomość potwierdzająca złożenie wniosku o założenie konta.
Kliknij na link zawarty w tej wiadomości.
Hasło do konta zostanie przesłane poprzez e-mail, gdy konto zostanie już utworzone.',
	'requestaccount-areas-text'       => 'Określ tematy i obszary dla których posiadasz formalne przygotowanie lub takie nad którymi planujesz najwięcej pracować.',
	'requestaccount-ext-text'         => 'Następujące informacje nie będą udostępniane. Zostaną użyte tylko na potrzeby tego wniosku o założenie konta użytkownika.
Możesz wyświetlić kontakty np. numer telefonu, by łatwiej zdecydować o zatwierdzeniu lub odrzuceniu wniosku.',
	'requestaccount-bio-text'         => 'Twoja biografia zostanie wstawiona jako domyślna zawartość Twojej strony użytkownika.
Załącz informacje o kwalifikacjach i referencje, oczywiście pod warunkiem, że nie opublikowanie tych informacji nie stawi dla Ciebie problemu.
Ustawione obecnie imię i nazwisko możesz zmienić w [[Special:Preferences|preferencjach]].',
	'requestaccount-real'             => 'Imię i nazwisko:',
	'requestaccount-same'             => '(prawdziwe imię i nazwisko)',
	'requestaccount-email'            => 'Adres e-mail:',
	'requestaccount-reqtype'          => 'Stanowisko:',
	'requestaccount-level-0'          => 'autor',
	'requestaccount-level-1'          => 'redaktor',
	'requestaccount-bio'              => 'Osobista biografia:',
	'requestaccount-attach'           => 'Życiorys (opcjonalne):',
	'requestaccount-notes'            => 'Dodatkowe informacje:',
	'requestaccount-urls'             => 'Lista adresów stron internetowych, jeśli posiadasz (każdy w osobnym wierszu):',
	'requestaccount-agree'            => 'Musisz potwierdzić, że wpisane imię i nazwisko są poprawne oraz, że zgadzasz się na warunki korzystania z {{GRAMMAR:D.lp|{{SITENAME}}}}.',
	'requestaccount-inuse'            => 'Nazwa użytkownika jest zajęta przez oczekujący wniosek o założenie konta.',
	'requestaccount-tooshort'         => 'Biografia musi mieć co najmniej {{PLURAL:$1|1 słowo|$1 słowa|$1 słów}}.',
	'requestaccount-emaildup'         => 'W innym oczekującym wniosku o założenie konta użytkownika wpisano taki sam adres e-mail.',
	'requestaccount-exts'             => 'Niedozwolony typ załącznika.',
	'requestaccount-resub'            => 'Plik z Twoim życiorysem musi zostać ponownie wybrany ze względów bezpieczeństwa.
Pozostaw pole niewypełnione jeśli nie chcesz więcej go załączać.',
	'requestaccount-tos'              => 'Przeczytałem i wyrażam bez zastrzeżeń zgodę na [[{{MediaWiki:Requestaccount-page}}|warunki korzystania]] z {{GRAMMAR:D.lp|{{SITENAME}}}}.
Oświadczam, że wpisane przez ze mnie imię i nazwisko są faktycznie moimi.',
	'requestaccount-submit'           => 'Składam wniosek',
	'requestaccount-sent'             => 'Twój wniosek o założenie konta został wysłany i oczekuje na rozpatrzenie.',
	'request-account-econf'           => 'Adres e-mail został potwierdzony i będzie wyświetlany tak, jak określono we wniosku o założenie konta.',
	'requestaccount-email-subj'       => 'Potwierdzenie adresu e-mail w {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'requestaccount-email-body'       => 'Ktoś (zakładamy, że Ty), z komputera o adresie IP $1, złożył w {{GRAMMAR:MS.pl|{{SITENAME}}}} wniosek o założenie konta użytkownika „$2”, podając przy tym niniejszy adres e-mail.

Jeśli to Ty zakładasz konto w {{GRAMMAR:MS.pl|{{SITENAME}}}}, potwierdź to otwierając w swojej przeglądarce poniższy link:

$3

Jeśli konto zostanie utworzone, zostanie wysłane do Ciebie na ten adres e-mail hasło.
Jeśli to nie Ty zakładałeś konto, *nie klikaj* w powyższy link.
Kod potwierdzający zawarty w powyższym linku straci ważność $4.',
	'requestaccount-email-subj-admin' => 'Wniosek o założenie konta użytkownika w {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'requestaccount-email-body-admin' => '„$1” złożył wniosek o założenie konta użytkownika i oczekuje na zatwierdzenie.
Adres e-mail został potwierdzony. Możesz zatwierdzić wniosek tutaj „$2”.',
	'acct_request_throttle_hit'       => 'Złożyłeś już {{PLURAL:$1|wniosek|$2 wnioski|$2 wniosków}} o założenie konta użytkownika.
Nie możesz złożyć więcej wniosków.',
	'requestaccount-loginnotice'      => "By uzyskać konto użytkownika musisz '''[[Special:RequestAccount|złożyć wniosek]]'''.",
	'confirmaccount-newrequests'      => "{{PLURAL:$1|Jest '''$1''' [[Special:ConfirmAccounts|oczekujący wniosek]]|Są '''$1''' [[Special:ConfirmAccounts|oczekujące wnioski]]|Jest '''$1''' [[Special:ConfirmAccounts|oczekujących wniosków]]}}, z potwierdzonym adresem e-mail",
	'confirmaccounts'                 => 'Potwierdź wniosek o założenie konta użytkownika',
	'confirmedit-desc'                => 'Pozwala biurokratom akceptować wnioski o założenie konta użytkownika',
	'confirmaccount-maintext'         => "'''Na tej stronie można potwierdzać wnioski o utworzenie konta w ''{{GRAMMAR:D.lp|{{SITENAME}}}}'''''.

Każda kolejka wniosków składa się z trzech kolejek podrzędnych: kolejka otwartych zapytań, kolejka zapytań, których realizacja została wstrzymana przez administratorów do czasu uzyskania przez nich większej ilości informacji, kolejka niedawno odrzuconych wniosków.

Odpowiadając na wniosek przyjrzyj mu się dokładnie, a jeśli jest to konieczne, potwierdź zawarte w nim informacje.
Twoje działania są zapisywane z poszanowaniem prywatności.
Oprócz podejmowania samodzielnych działań, przyjrzyj się też działaniom innych administratorów.",
	'confirmaccount-list'             => 'Poniżej znajduje się lista oczekujących wniosków o założenie konta.
Po zaakceptowaniu lub odrzuceniu, wniosek zostanie usunięty z niniejszej listy.',
	'confirmaccount-list2'            => 'Poniżej znajduje się lista niedawno odrzuconych wniosków o założenie konta. Mogą one zostać automatycznie usunięte po kilku lub kilkunastu dniach.
Wnioski można nadal zrealizować, lecz zalecane jest wcześniejsze nawiązanie kontaktu z administratorem, który je odrzucił.',
	'confirmaccount-list3'            => 'Poniżej znajduje się lista przeterminowanych wniosków o utworzenie konta. Wnioski są usuwane po kilku lub kilkunastu dniach.
Wnioski z tej listy nadal można zrealizować.',
	'confirmaccount-text'             => "Poniżej znajduje się, oczekujący na rozpatrzenie, wniosek o konto w '''{{GRAMMAR:D.lp|{{SITENAME}}}}'''.

Przejrzyj zawarte w nim informacje. Jeśli zdecydujesz się wniosek przyjąć, zmień status konta na poniższej liście rozwijalnej.
Edycje wykonane w biografii osoby ubiegającej się o konto nie wpłyną na przechowywane w systemie referencje. Możesz utworzyć konto o innej nazwie, niż wybrana przez wnioskodawcę. Należy z tej możliwości korzystać tylko wtedy, gdy jest to konieczne z uwagi na konflikt z nazwą innego użytkownika.

Wniosek, którego nie potwierdzisz lub nie odrzucisz na tej stronie, pozostanie w stanie oczekiwania.",
	'confirmaccount-none-o'           => 'Brak na liście otwartych wniosków o założenie konta użytkownika.',
	'confirmaccount-none-h'           => 'Brak na liście wstrzymanych wniosków o założenie konta użytkownika.',
	'confirmaccount-none-r'           => 'Brak na liście niedawno odrzuconych wniosków o założenie konta użytkownika.',
	'confirmaccount-none-e'           => 'Brak na liście przeterminowanych wniosków o założenie konta użytkownika.',
	'confirmaccount-real-q'           => 'Imię i nazwisko',
	'confirmaccount-email-q'          => 'Adres e-mail',
	'confirmaccount-bio-q'            => 'Biografia',
	'confirmaccount-showopen'         => 'otwarte wnioski o założenie konta',
	'confirmaccount-showrej'          => 'odrzucone wnioski o założenie konta',
	'confirmaccount-showheld'         => 'wstrzymane wnioski o założenie konta',
	'confirmaccount-showexp'          => 'przeterminowane wnioski o założenie konta',
	'confirmaccount-review'           => 'Przejrzyj',
	'confirmaccount-types'            => 'Wybierz kolejkę z poniższej listy',
	'confirmaccount-all'              => '(pokaż wszystkie kolejki)',
	'confirmaccount-type'             => 'Kolejka:',
	'confirmaccount-type-0'           => 'potencjalni autorzy',
	'confirmaccount-type-1'           => 'potencjalni edytorzy',
	'confirmaccount-q-open'           => 'otwarte wnioski o założenie konta',
	'confirmaccount-q-held'           => 'wstrzymane wnioski o założenie konta',
	'confirmaccount-q-rej'            => 'ostatnio odrzucone wnioski',
	'confirmaccount-q-stale'          => 'przeterminowane wnioski o założenie konta',
	'confirmaccount-badid'            => 'Z podanym identyfikatorem nie jest związany żaden wniosek o założenie konta.
Być może został on już obsłużony.',
	'confirmaccount-leg-user'         => 'Konto użytkownika',
	'confirmaccount-leg-areas'        => 'Główne zainteresowania',
	'confirmaccount-leg-person'       => 'Dane osobowe',
	'confirmaccount-leg-other'        => 'Inne informacje',
	'confirmaccount-name'             => 'Nazwa użytkownika',
	'confirmaccount-real'             => 'Imię i nazwisko',
	'confirmaccount-email'            => 'Adres e-mail',
	'confirmaccount-reqtype'          => 'Stanowisko:',
	'confirmaccount-pos-0'            => 'autor',
	'confirmaccount-pos-1'            => 'redaktor',
	'confirmaccount-bio'              => 'Biografia:',
	'confirmaccount-attach'           => 'Życiorys:',
	'confirmaccount-notes'            => 'Dodatkowe informacje:',
	'confirmaccount-urls'             => 'Wykaz witryn:',
	'confirmaccount-none-p'           => '(nie podano)',
	'confirmaccount-confirm'          => 'Korzystając z poniższych opcji przyjmij, odrzuć lub wstrzymaj wniosek',
	'confirmaccount-econf'            => '(potwierdzono)',
	'confirmaccount-reject'           => '(odrzucone przez użytkownika [[User:$1|$1]], z powodu $2)',
	'confirmaccount-rational'         => 'Uzasadnienie przesłane do wnioskodawcy:',
	'confirmaccount-noreason'         => '(brak)',
	'confirmaccount-autorej'          => '(wniosek został automatycznie odrzucony ze względu na brak aktywności)',
	'confirmaccount-held'             => '(oznaczone jako „wstrzymane” przez użytkownika [[User:$1|$1]], z powodu $2)',
	'confirmaccount-create'           => 'Zaakceptuj (utwórz konto)',
	'confirmaccount-deny'             => 'Odrzuć (usuń z listy)',
	'confirmaccount-hold'             => 'Wstrzymaj',
	'confirmaccount-spam'             => 'Spam (nie wysyłaj wiadomości e-mail)',
	'confirmaccount-reason'           => 'Komentarz (zostanie dopisany do wiadomości e-mail):',
	'confirmaccount-ip'               => 'Adres IP:',
	'confirmaccount-submit'           => 'Potwierdź',
	'confirmaccount-needreason'       => 'Musisz podać uzasadnienie w polu poniżej.',
	'confirmaccount-canthold'         => 'Ten wniosek został już wstrzymany lub usunięty.',
	'confirmaccount-acc'              => 'Potwierdzono wniosek o założenie konta; utworzono konto dla użytkownika [[User:$1|$1]].',
	'confirmaccount-rej'              => 'Odrzucono wniosek o utworzenie konta.',
	'confirmaccount-viewing'          => '(aktualnie przeglądany przez użytkownika [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Tworzę stronę biografii nowego użytkownika.',
	'confirmaccount-welc'             => "'''Witaj w ''{{GRAMMAR:N.lp|{{SITENAME}}}}''!''' Mamy nadzieję, że włączysz się aktywnie w tworzenie {{GRAMMAR:D.lp|{{SITENAME}}}}.
Zacznij od zapoznania się ze [[{{MediaWiki:Helppage}}|stronami pomocy]]. Jeszcze raz witamy i życzymy przyjemnej pracy!",
	'confirmaccount-wsum'             => 'Witaj!',
	'confirmaccount-email-subj'       => 'Wniosek o założenie konta użytkownika w {{GRAMMAR:MS.lp|{{SITENAME}}}}',
	'confirmaccount-email-body'       => 'Złożony przez Ciebie w {{GRAMMAR:N.lp|{{SITENAME}}}} wniosek został zaakceptowany.

Nazwa użytkownika: $1

Hasło: $2

Z uwagi na bezpieczeństwo użytkowania, przy pierwszym logowaniu zostaniesz poproszony o zmianę hasła.
Zaloguj się na stronie {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Twoja prośba o konto została przyjęta na {{SITENAME}}.

Nazwa: $1

Hasło: $2

$3

Z powodów bezpieczeństwa będziesz musiał zmienić hasło przy pierwszym logowaniu.
By się zalogować przejdź do {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Niestety złożony przez Ciebie w {{GRAMMAR:MS.lp|{{SITENAME}}}} wniosek o założenie konta „$1” został odrzucony.

Możliwe przyczyny odrzucenia wniosku to:
nie wypełniłeś prawidłowo wszystkich pól wniosku, nie udzieliłeś odpowiednio obszernej odpowiedzi, lub w inny sposób nie wypełniłeś wniosku zgodne z przyjętymi kryteriami.
W serwisie na pewno odnajdziesz informacje, które pozwolą Ci dowiedzieć się więcej o zasadach zatwierdzania nowych kont użytkownika.',
	'confirmaccount-email-body4'      => 'Przepraszamy, Twoja prośba o konto "$1" została odrzucona na {{SITENAME}}.

$2

Na stronie mogą znajdować się listy kontaktowe, których możesz użyć aby dowiedzieć się więcej na temat polityki kont.',
	'confirmaccount-email-body5'      => 'Przed zatwierdzeniem złożonego przez Ciebie wniosku o konto „$1” w {{GRAMMAR:MS.lp|{{SITENAME}}}} musisz podać następujące informacje dodatkowe:

$2

Jeśli chcesz dowiedzieć się więcej o zasadach tworzenia kont w serwisie, poszukaj informacji na jego stronach.',
	'usercredentials'                 => 'Uprawnienia użytkownika',
	'usercredentials-leg'             => 'Podejrzyj zatwierdzone informacje uwierzytelniające dotyczące użytkownika',
	'usercredentials-user'            => 'Nazwa użytkownika:',
	'usercredentials-text'            => 'Poniżej znajdują się zatwierdzone informacje uwierzytelniające na temat wybranego użytkownika.',
	'usercredentials-leg-user'        => 'Konto użytkownika',
	'usercredentials-leg-areas'       => 'Główne obszary zainteresowań',
	'usercredentials-leg-person'      => 'Informacje osobiste',
	'usercredentials-leg-other'       => 'Inne informacje',
	'usercredentials-email'           => 'Adres e-mail',
	'usercredentials-real'            => 'Imię i nazwisko:',
	'usercredentials-bio'             => 'Biografia:',
	'usercredentials-attach'          => 'Życiorys:',
	'usercredentials-notes'           => 'Dodatkowe informacje:',
	'usercredentials-urls'            => 'Wykaz witryn:',
	'usercredentials-ip'              => 'Oryginalny adres IP:',
	'usercredentials-member'          => 'Prawa:',
	'usercredentials-badid'           => 'Nie znaleziono informacji uwierzytelniających na temat tego użytkownika.
Sprawdź, czy prawidłowo wpisałeś nazwę konta.',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author SPQRobin
 */
$messages['pms'] = array(
	'requestaccount'             => 'Ciamé un cont',
	'requestaccount-text'        => "'''Ch'a completa e ch'a manda sta domanda-sì për ciamé ch'a-j deurbo sò cont utent'''. Per piasì, ch'a varda d'avej present le [[{{MediaWiki:Requestaccount-page}}|Condission ëd servissi]], anans che deurb-se un cont. Na vira che 'l cont a sia aprovà, a l'arseivrà na notìfica për pòsta eletrònica e sò cont a sarà bon da dovré a l'adrëssa [Special:Userlogin]].",
	'requestaccount-dup'         => "'''Ch'a ten-a present: al moment a l'é già andrinta al sistema ën dovrand un cont registrà.'''",
	'requestaccount-acc-text'    => "A soa adrëssa ëd pòsta eletrònica a-i rivërà un messagi, na vira che sta domanda a la sia mandà. Per piasì, ch'a n'arsponda ën dand-ie un colp col rat ansima a l'aniura ch'a treuva ant ël messagi. Ëdcò soa ciav a sarà recapità për pòsta eletrònica, na vira che sò cont a sia creà.",
	'requestaccount-ext-text'    => "St'anformassion-sì as ten privà e as dòvra mach për sta question-sì. S'a veul a peul buté dij contat coma un nùmer ëd telèfono për giuté a identifichesse sensa dubi.",
	'requestaccount-bio-text'    => "Soa biografìa a sarà buta coma contnù base për soa pàgine utent. S'a peul, ch'a buta soe credensiaj, cole ch'a sio. Ch'a varda mach però dë buté dj'anformassion ch'a-j da gnun fastudi publiché. An tute le manere, a peul sempe cambiesse 'd nòm ën dovrand l'adrëssa [[Special:Preferences]].",
	'requestaccount-real'        => 'Nòm vèir:',
	'requestaccount-same'        => '(istess che sò nòm vèir)',
	'requestaccount-email'       => 'Adrëssa ëd pòsta eletrònica:',
	'requestaccount-bio'         => 'Biografìa personal:',
	'requestaccount-attach'      => 'Curriculum vitae (opsional):',
	'requestaccount-notes'       => 'Nòte adissionaj:',
	'requestaccount-urls'        => "Lista ëd sit ant sla Ragnà, s'a-i n'a-i é (buté un për riga):",
	'requestaccount-agree'       => "A venta ch'a sertìfica che sò nòm vèir a l'é giust e ch'a l'é d'acòrdi con nòstre Condission ëd Servissi.",
	'requestaccount-inuse'       => "Stë stranòm-sì a l'é già dovrà ant na domanda ch'a la speta d'esse aprovà.",
	'requestaccount-tooshort'    => "Soa biografìa a l'ha dë esse longa almanch $1 paròle.",
	'requestaccount-exts'        => "Sta sòrt d'archivi as peul pa tachesse.",
	'requestaccount-resub'       => "Për na question ëd sigurëssa a venta torna ch'a selession-a l'archivi ëd sò Curriculum Vitae. Ch'a lassa pura ël camp veujd s'a veul pì nen butelo.",
	'requestaccount-tos'         => "I l'hai lesù le [[{{MediaWiki:Requestaccount-page}}|Condission ëd Servissi]] ëd {{SITENAME}} e i son d'acòrdi d'osserveje. Ël nòm ch'i l'hai butà sot a \"Nòm vèir\" a l'é mè nòm da bon.",
	'requestaccount-submit'      => 'Fé domanda për ël cont',
	'requestaccount-sent'        => "Soa domanda dë deurb-se un cont a l'é staita arseivùa e a la speta d'esse aprovà.",
	'request-account-econf'      => "Soa adrëssa ëd pòsta eletrònica a l'é staita confermà e a la sarà listà coma bon-a an soa domanda dë deurbe 'l cont.",
	'requestaccount-email-subj'  => "Arcesta ëd conferma d'adrëssa ëd pòsta eletrònica da {{SITENAME}}",
	'requestaccount-email-body'  => "Cheidun, ch'a l'é belfé ch'a sia chiel/chila, da 'nt l'adrëssa IP \$1 a l'ha ciamà dë deurbe un cont antestà a \"\$2\" ansima a {{SITENAME}} e a l'ha lassà st'adrëssa ëd pòsta eletrònica-sì. Për confermé che ës cont ansima a {{SITENAME}} a sarìa sò da bon, për piasì ch'a deurba ant sò navigator st'anliura-sì: \$3 

Quand ël cont a vnirà creà, soa la ciav a sarà mandà mach a st'adrëssa-sì. Se për cas a fussa PA stait chiel/chila a fé la domanda, a basta ch'a n'arsponda nen d'autut. Ës còdes ëd conferma-sì a scad dël \$4.",
	'acct_request_throttle_hit'  => "A l'ha gia ciamà $1 cont. Për darmagi ant ës moment-sì i podoma nen aceté dj'àotre domande da chiel/chila.",
	'requestaccount-loginnotice' => "Për deurb-se un sò cont utent, a venta '''[[Special:RequestAccount|ch<nowiki>'</nowiki>a në ciama un]]'''.",
	'confirmaccounts'            => 'Conferma dle domande ëd cont neuv da deurbe',
	'confirmaccount-list'        => "Ambelessì sota a-i é na lista ëd domanda ch'a speto d'esse aprovà. Ij cont aprovà a saran creà e peuj gavà via da 'n sta lista. Ij cont arfudà a saran mach dëscancelà da 'nt la lista.",
	'confirmaccount-list2'       => "Ambelessì sota a-i é na lista ëd coint ch'a son stait arfudà ant j'ùltim temp, e ch'a l'é belfé ch'a ven-o scancelà n'aotomàtich na vira ch'a sia passa-ie chèich dì dal giudissi negativ. Ën vorend as peulo anco' sempe aprovesse bele che adess, ma miraco un a veul sente l'aministrator ch'a l'ha arfudaje, anans che fé che fé.",
	'confirmaccount-text'        => "A-i é na domanda duvèrta për deurbe un cont utent a '''{{SITENAME}}'''. Për piasì, ch'a varda lòn ch'a lé e se a fa da manca ch'a conferma j'anformassion ambelessì sota. Ch'a ten-a present ch'a peul decide dë creé ël cont con në stranòm diferent da col ciamà, se col-lì a fussa già dovrà da cheidun d'àotr. S'a va via da sta pàgina-sì sensa pijé ëd decision a-i riva gnente, la domanda a la resta duvèrta.",
	'confirmaccount-real-q'      => 'Nòm',
	'confirmaccount-email-q'     => 'Adrëssa ëd pòsta eletrònica',
	'confirmaccount-bio-q'       => 'Biografìa',
	'confirmaccount-review'      => 'Aprové/Arfudé',
	'confirmaccount-badid'       => "A-i é gnun-a domanda duvèrta ch'a-j corisponda a l'identificativ ch'a l'ha butà. A peul esse ch'a la sia già staita tratà da cheidun d'àotr.",
	'confirmaccount-name'        => 'Stranòm',
	'confirmaccount-real'        => 'Nòm:',
	'confirmaccount-email'       => 'Adrëssa ëd pòsta eletrònica:',
	'confirmaccount-bio'         => 'Biografìa:',
	'confirmaccount-attach'      => 'Curriculum Vitae:',
	'confirmaccount-notes'       => 'Nòte adissionaj:',
	'confirmaccount-urls'        => 'Lista ëd sit ant sla Ragnà:',
	'confirmaccount-confirm'     => "Ch'a dòvra j'opsion ambelessì sota për aprové, arfudé ò lassé an coa la domanda:",
	'confirmaccount-econf'       => '(confermà)',
	'confirmaccount-reject'      => '(arfudà da [[User:$1|$1]] dël $2)',
	'confirmaccount-held'        => '(marcà "an coa" da [[User:$1|$1]] dël $2)',
	'confirmaccount-create'      => "Aceté (deurbe 'l cont)",
	'confirmaccount-deny'        => "Arfudé (e gavé da 'nt la lista)",
	'confirmaccount-hold'        => 'Lassé an coa',
	'confirmaccount-spam'        => 'Rumenta ëd reclam (mand-je nen pòsta)',
	'confirmaccount-reason'      => 'Coment (a-i resta andrinta al messagi postal):',
	'confirmaccount-ip'          => 'Adrëssa IP:',
	'confirmaccount-submit'      => 'Confermé',
	'confirmaccount-needreason'  => 'A venta specifiché na rason ant ël quàder ëd coment ambelessì sota.',
	'confirmaccount-acc'         => "Conferma dla domanda andaita a bonfin; a l'é dorbusse ël cont utent [[User:$1]].",
	'confirmaccount-rej'         => 'Arfud dla domanda andait a bonfin.',
	'confirmaccount-summary'     => "I soma antramentr ch'i foma na neuva pàgina utent con la biografìa dl'utent neuv.",
	'confirmaccount-welc'        => "''Bin ëvnù/a  an ''{{SITENAME}}''!''' I speroma d'arsèive sò contribut e deje bon servissi. Miraco a peul ess-je d'agiut lese la session [[{{MediaWiki:Helppage}}|Amprende a travajé da zero]]. N'àotra vira, bin ëvnù/a e tante bele còse!",
	'confirmaccount-wsum'        => 'Bin ëvnù/a!',
	'confirmaccount-email-subj'  => 'Domanda dë deurbe un cont neuv ansima a {{SITENAME}}',
	'confirmaccount-email-body'  => "Soa domanda dë deurbe un cont neuv ansima a {{SITENAME}} a l'é staita aprovà. Stranòm: $1 Ciav: $2 

Për na question ëd sigurëssa a fa da manca che un as cambia soa ciav la prima vira ch'a rintra ant ël sistema. Për rintré, për piasì ch'a vada a l'adrëssa {{fullurl:Special:Userlogin}}.",
	'confirmaccount-email-body2' => "Soa domanda dë deurbe un cont neuv ansima a {{SITENAME}} a l'é staita aprovà. Stranòm: $1 Ciav: $2 $3 

Për na question ëd sigurëssa un a venta ch'as cambia soa ciav la prima vira ch'a rintra ant ël sistema. Për rintré, për piasì ch'a vada a l'adrëssa {{fullurl:Special:Userlogin}}.",
	'confirmaccount-email-body3' => "Për darmagi soa domanda dë deurbe un cont ciamà \"\$1\" ansima a {{SITENAME}} a l'é staita bocià. A-i son vàire rason përchè sossì a peula esse rivà. A peul esse ch'a l'abia pa compilà giust la domanda, che soe arspòste a sio staite tròp curte, ò pura che an chèich àotra manera a l'abia falì da rintré ant ël criteri d'aprovassion. A peul esse che ant sël sit a sio specificà dle liste postaj ch'a peul dovré për ciamé pì d'anformassion ansima ai criteri d'aprovassion dovrà.",
	'confirmaccount-email-body4' => 'Për darmagi soa domanda dë deurbe un cont ciamà "$1" ansima a Betawiki a l\'é staita bocià. $2 A peul esse che ant sël sit a sio specificà dle liste postaj ch\'a peul dovré për ciamé pì d\'anformassion ansima ai criteri d\'aprovassion dovrà.',
	'confirmaccount-email-body5' => 'Anans che soa domanda dë deurbe un cont ciamà "$1" ansima a {{SITENAME}} a peula esse acetà, a dovrìa lassene dj\'anformassion adissionaj. $2 A peul esse che ant sël sit a sio specificà dle liste postaj ch\'a peul dovré për ciamé pì d\'anformassion ansima ai criteri d\'aprovassion dovrà.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'requestaccount-leg-person'  => 'ځاني مالومات',
	'requestaccount-leg-other'   => 'نور مالومات',
	'requestaccount-real'        => 'اصلي نوم:',
	'requestaccount-email'       => 'برېښليک پته:',
	'requestaccount-level-0'     => 'ليکوال',
	'requestaccount-bio'         => 'شخصي ژوندليک:',
	'requestaccount-tooshort'    => 'پکار ده چې ستاسو ژوندليک لږ تر لږه $1 لفظه اوږد وي.',
	'confirmaccount-real-q'      => 'نوم',
	'confirmaccount-email-q'     => 'برېښلیک',
	'confirmaccount-bio-q'       => 'ژوندليک',
	'confirmaccount-showrej'     => 'رټل شوې غوښتنې',
	'confirmaccount-review'      => 'مخکتنه',
	'confirmaccount-leg-person'  => 'ځاني مالومات',
	'confirmaccount-leg-other'   => 'نور مالومات',
	'confirmaccount-name'        => 'کارن-نوم',
	'confirmaccount-real'        => 'نوم:',
	'confirmaccount-email'       => 'برېښليک:',
	'confirmaccount-pos-0'       => 'ليکوال',
	'confirmaccount-bio'         => 'ژوندليک:',
	'confirmaccount-urls'        => 'د وېبځايونو لړليک:',
	'confirmaccount-noreason'    => '(هېڅ)',
	'confirmaccount-ip'          => 'IP پته:',
	'confirmaccount-wsum'        => 'ښه راغلاست!',
	'confirmaccount-email-body'  => 'په {{SITENAME}} باندې د يوه کارن-حساب لپاره غوښتنه مو ومنل شوه .

د کارن-حساب نوم: $1

پټنوم: $2

د تحفظ د سببونو لپاره تاسو ته پکار ده چې د وروسته له دې چې د لومړي ځل لپاره غونډال ته ننوتلی نو مهرباني وکړی خپل پټنوم بدل کړی. د دې لپاره چې غونډال ته ننوځی، مهرباني وکړی {{fullurl:Special:Userlogin}} ولاړ شی.',
	'confirmaccount-email-body2' => 'په {{SITENAME}} باندې د يوه کارن-حساب لپاره غوښتنه مو ومنل شوه .

د کارن-حساب نوم: $1

پټنوم: $2

$3

د تحفظ د سببونو لپاره تاسو ته پکار ده چې د وروسته له دې چې د لومړي ځل لپاره غونډال ته ننوتلی نو مهرباني وکړی خپل پټنوم بدل کړی. د دې لپاره چې غونډال ته ننوځی، مهرباني وکړی {{fullurl:Special:Userlogin}} ولاړ شی.',
	'usercredentials-user'       => 'کارن-نوم:',
	'usercredentials-leg-person' => 'ځاني مالومات',
	'usercredentials-leg-other'  => 'نور مالومات',
	'usercredentials-email'      => 'برېښليک:',
	'usercredentials-real'       => 'اصلي نوم:',
	'usercredentials-bio'        => 'ژوندليک:',
	'usercredentials-urls'       => 'د وېبځايونو لړليک:',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Lijealso
 * @author Siebrand
 */
$messages['pt'] = array(
	'requestaccount'                  => 'Requerer conta',
	'requestaccount-text'             => "'''Complete e submeta o seguinte formulário para pedir uma conta de utilizador'''.  

Certifique-se de que lê primeiro os [[{{MediaWiki:Requestaccount-page}}|Termos de Serviço]] antes de pedir uma conta.

Assim que a conta for aprovada, ser-lhe-á enviada por email uma mensagem de notificação e a conta estará pronta a usar em [[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:Termos de Serviço',
	'requestaccount-dup'              => "'''Nota: Você já está logado com uma conta registada.'''",
	'requestaccount-leg-user'         => 'Conta de utilizador',
	'requestaccount-leg-areas'        => 'Principais áreas de interesse',
	'requestaccount-leg-person'       => 'Informação pessoal',
	'requestaccount-leg-other'        => 'Outras informações',
	'requestaccount-acc-text'         => 'Será enviada um mensagem de confirmação para o seu endereço de email assim que este pedido for submetido. Por favor, responda clicando na ligação de confirmação fornecida no email. A sua palavra-chave também lhe será enviada por email assim que a sua conta estiver criada.',
	'requestaccount-areas-text'       => 'Seleccione em baixo as áreas em que possui experiência formal ou em que gostaria de trabalhar mais.',
	'requestaccount-ext-text'         => 'A seguinte informação é mantida privada e só será usada para este pedido.
Poderá querer listar contactos tal como o número de telefone para ajudar na confirmação da identificação.',
	'requestaccount-bio-text'         => 'A sua biografia será usada como conteúdo por defeito da sua página de utilizador.
Tente incluir algumas credenciais.
Assegure-se de que se encontra confortável em publicar tal informação.
O seu nome pode ser alterado em [[Special:Preferences]].',
	'requestaccount-real'             => 'Nome real:',
	'requestaccount-same'             => '(igual ao nome real)',
	'requestaccount-email'            => 'Endereço de email:',
	'requestaccount-reqtype'          => 'Posição:',
	'requestaccount-level-0'          => 'autor',
	'requestaccount-level-1'          => 'editor',
	'requestaccount-bio'              => 'Biografia pessoal:',
	'requestaccount-attach'           => 'Curriculum Vitae (opcional):',
	'requestaccount-notes'            => 'Notas adicionais:',
	'requestaccount-urls'             => 'Lista de sítios web, se algum (separados por mudança de linha):',
	'requestaccount-agree'            => 'Deverá certificar-se que o seu nome real está correcto e que concorda com os nossos Termos de Serviço.',
	'requestaccount-inuse'            => 'O nome de utilizador já está em uso num pedido de conta pendente.',
	'requestaccount-tooshort'         => 'A sua biografia tem que ter pelo menos $1 palavras.',
	'requestaccount-emaildup'         => 'Um outro pedido de conta pendente usa o mesmo endereço de email.',
	'requestaccount-exts'             => 'O tipo de ficheiro do anexo não é permitido.',
	'requestaccount-resub'            => 'O seu Curriculum Vitae deve ser seleccionado novamente por razões de segurança. Deixe o campo em branco se já não desejar incluí-lo.',
	'requestaccount-tos'              => 'Li e concordo reger-me pelos [[{{MediaWiki:Requestaccount-page}}|Termos de Serviço]] de {{SITENAME}}.
O nome que especifiquei em "Nome real" é de facto o meu nome real.',
	'requestaccount-submit'           => 'Requerer conta',
	'requestaccount-sent'             => 'O seu pedido de conta foi enviado com sucesso e está agora pendente para confirmação.',
	'request-account-econf'           => 'O seu endereço de email foi confirmado e será listado como tal no seu pedido de conta.',
	'requestaccount-email-subj'       => 'Confirmação de endereço de email para {{SITENAME}}',
	'requestaccount-email-body'       => 'Alguém, provavelmente vocês a partir do endereço IP $1, requisitou uma conta "$2" com este endereço de email em {{SITENAME}}.

Para confirmar que esta conta realmente lhe pertence em {{SITENAME}}, abra esta ligação no seu "browser":

$3

Se a conta for criada, apenas lhe será enviada a palavra-chave a si. Se esta pessoa *não* for você, não siga a ligação.
Este código de confirmação expirará em $4.',
	'requestaccount-email-subj-admin' => 'Pedido de conta em {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" pediu uma conta e aguarda confirmação.
O endereço de email foi confirmado. Você pode confirmar o pedido aqui "$2".',
	'acct_request_throttle_hit'       => 'Desculpe, mas já pediu $1 contas. Não pode fazer mais pedidos.',
	'requestaccount-loginnotice'      => "Para obter uma conta de utilizador, deverá '''[[Special:RequestAccount|pedi-la]]'''.",
	'confirmaccount-newrequests'      => "Há actualmente '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|pedido de conta]] aberto pendente|[[Special:ConfirmAccounts|pedidos de conta]] abertos pendentes}}.",
	'confirmaccounts'                 => 'Confirmar requerimentos de conta',
	'confirmedit-desc'                => 'Possibilita aos burocratas confirmar pedidos de conta',
	'confirmaccount-maintext'         => "'''Esta página é usada para confirmar pedidos de conta pendentes em ''{{SITENAME}}'''''.

Cada fila de pedidos de conta consiste em três sub-filas, uma para pedidos em aberto, outras para aqueles que foram colocados em espera por outros administradores à espera de mais informação, e outra para pedidos recentemente rejeitados.

Quando responder a um pedido, reveja-o cuidadosamente e, se necessário, confirme a informação nele contida.  
As suas acções será registadas privadamente. Também é esperado que vocês reveja qualquer actividade que  ocorra aqui para além das suas próprias acções.",
	'confirmaccount-list'             => 'Abaixo encontra-se uma lista de pedidos de conta à espera de aprovação.
Contas aprovadas serão criadas e removidas desta lista. Contas rejeitadas serão simplesmente eliminadas desta lista.',
	'confirmaccount-list2'            => 'Abaixo encontra-se uma lista de pedidos de conta recentemente rejeitados que serão automaticamente eliminados após alguns dias.
Estes podem ainda ser aprovados para novas contas, mas deverá verificar primeiro com o administrador que rejeitou o pedido antes de o aprovar.',
	'confirmaccount-list3'            => 'Abaixo encontra-se uma lista de pedidos de conta expirados que poderão ser automaticamente apagados após alguns dias. Estes ainda podem ser aprovados e convertidos em novas contas.',
	'confirmaccount-text'             => "Isto é um pedido pendente para uma conta de utilizador em '''{{SITENAME}}'''.  

Reveja cuidadosamente a informação abaixo. Se está a aprovar este pedido, use a caixa de selecção de posição para esetabelecer o estado da conta do utilizador.
Edições feitas à biografia da candidatura não afectarão nenhum armazenamento de credenciais permanente. Note que pode optar por criar a conta com um nome de utilizador diferente.
Use esta possibilidade apenas para evitar colisões com outros nomes.

Se simplesmente abandonar esta página sem confirmar ou rejeitar este pedido, ele continuará pendente.",
	'confirmaccount-none-o'           => 'Actualmente não existem pedidos de conta pendentes em aberto nesta lista.',
	'confirmaccount-none-h'           => 'Actualmente não existem pedidos de conta pendentes em espera nesta lista.',
	'confirmaccount-none-r'           => 'Actualmente não existem pedidos de conta recentemente rejeitados nesta lista.',
	'confirmaccount-none-e'           => 'Não há neste momento pedidos de conta expirados nesta lista.',
	'confirmaccount-real-q'           => 'Nome',
	'confirmaccount-email-q'          => 'Email',
	'confirmaccount-bio-q'            => 'Biografia',
	'confirmaccount-showopen'         => 'pedidos em curso',
	'confirmaccount-showrej'          => 'pedidos rejeitados',
	'confirmaccount-showheld'         => 'Ver lista de pedidos de conta pendentes em espera',
	'confirmaccount-showexp'          => 'pedidos expirados',
	'confirmaccount-review'           => 'Aprovar/Rejeitar',
	'confirmaccount-types'            => 'Seleccione uma fila de confirmação de contas abaixo:',
	'confirmaccount-all'              => '(mostrar todas as filas)',
	'confirmaccount-type'             => 'Fila seleccionada:',
	'confirmaccount-type-0'           => 'autores expectáveis',
	'confirmaccount-type-1'           => 'editores expectáveis',
	'confirmaccount-q-open'           => 'pedidos em aberto',
	'confirmaccount-q-held'           => 'pedidos em espera',
	'confirmaccount-q-rej'            => 'pedidos recentemente rejeitados',
	'confirmaccount-q-stale'          => 'pedidos expirados',
	'confirmaccount-badid'            => 'Não existe nenhum pedido pendente correspondente ao identificador fornecido. Aquele pode já ter sido tratado.',
	'confirmaccount-leg-user'         => 'Conta de utilizador',
	'confirmaccount-leg-areas'        => 'Principais áreas de interesse',
	'confirmaccount-leg-person'       => 'Informação pessoal',
	'confirmaccount-leg-other'        => 'Outras informações',
	'confirmaccount-name'             => 'Nome de utilizador',
	'confirmaccount-real'             => 'Nome:',
	'confirmaccount-email'            => 'Email:',
	'confirmaccount-reqtype'          => 'Posição:',
	'confirmaccount-pos-0'            => 'autor',
	'confirmaccount-pos-1'            => 'editor',
	'confirmaccount-bio'              => 'Biografia:',
	'confirmaccount-attach'           => 'Curriculum Vitae:',
	'confirmaccount-notes'            => 'Notas adicionais:',
	'confirmaccount-urls'             => 'Lista de sítios web:',
	'confirmaccount-none-p'           => '(não fornecido)',
	'confirmaccount-confirm'          => 'Use as opções abaixo para aceitar, rejeitar, ou colocar em espera este pedido:',
	'confirmaccount-econf'            => '(confirmado)',
	'confirmaccount-reject'           => '(rejeitado por [[User:$1|$1]] em $2)',
	'confirmaccount-rational'         => 'Explicação dada ao requerente:',
	'confirmaccount-noreason'         => '(nenhum)',
	'confirmaccount-autorej'          => '(este pedido foi automaticamente descartado devido a inactividade)',
	'confirmaccount-held'             => '(marcado como "em espera" por [[User:$1|$1]] em $2)',
	'confirmaccount-create'           => 'Aceitar (criar conta)',
	'confirmaccount-deny'             => 'Rejeitar (retirar da lista)',
	'confirmaccount-hold'             => 'Colocar em espera',
	'confirmaccount-spam'             => 'Spam (não enviar email)',
	'confirmaccount-reason'           => 'Comentário (será incluído no email):',
	'confirmaccount-ip'               => 'Endereço IP:',
	'confirmaccount-submit'           => 'Confirmar',
	'confirmaccount-needreason'       => 'Deverá fornecer um motivo na caixa de comentário abaixo.',
	'confirmaccount-canthold'         => 'Este pedido já está em espera ou apagado.',
	'confirmaccount-acc'              => 'Pedido de conta confirmado com sucesso; criada nova conta de utilizador [[User:$1]].',
	'confirmaccount-rej'              => 'Pedido de conta rejeitado com sucesso.',
	'confirmaccount-viewing'          => '(actualmente a ser visualizada por [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Criar página de utilizador com biografia de novo utilizador.',
	'confirmaccount-welc'             => "'''Bem-vindo a ''{{SITENAME}}''!''' Esperamos que contribua muito e bem.
Provavelmente desejará ler as [[{{MediaWiki:Helppage}}|páginas de ajuda]]. Mais uma vez, seja bem-vindo e divirta-se!",
	'confirmaccount-wsum'             => 'Bem-vindo!',
	'confirmaccount-email-subj'       => 'Pedido de conta em {{SITENAME}}',
	'confirmaccount-email-body'       => 'O seu pedido de conta foi aprovado em {{SITENAME}}.

Nome da conta: $1

Palavra-chave: $2

Por questões de segurança, deverá mudar a sua palavra-chave após a primeira entrada. Para entrar, por favor vá até {{fullurl:{{ns:special}}:Userlogin}}.',
	'confirmaccount-email-body2'      => 'O seu pedido de conta foi aprovado em {{SITENAME}}.

Nome da conta: $1

Palavra-chave: $2

$3

Por questões de segurança, deverá mudar a sua palavra-chave após a primeira entrada. Para entrar, por favor vá até {{fullurl:{{ns:special}}:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Desculpe, o seu pedido para a conta "$1" foi rejeitado em {{SITENAME}}.

Há várias formas para isto acontecer. Você poderá não ter preenchido o formulário correctamente, não ter fornecido respostas de tamanho adequado, ou de outra forma ter falhado em alguns dos critérios da política. Poderá haver listas de contactos no sítio que poderá usar se desejar saber mais sobre a política de contas de utilizador.',
	'confirmaccount-email-body4'      => 'Desculpe, o seu pedido para a conta "$1" foi rejeitado em {{SITENAME}}.

$2

Poderá haver listas de contactos no sítio que poderá usar se desejar saber mais sobre a política de contas de utilizador.',
	'confirmaccount-email-body5'      => 'Antes que o seu pedido para a conta "$1" seja aceite em {{SITENAME}}, deverá fornecer alguma informação adicional.

$2

Poderá haver listas de contactos no sítio que poderá usar se desejar saber mais sobre a política de contas de utilizador.',
	'usercredentials'                 => 'Credenciais do utilizador',
	'usercredentials-leg'             => 'Procurar credenciais confirmadas para um utilizador',
	'usercredentials-user'            => 'Nome de utilizador:',
	'usercredentials-text'            => 'Abaixo estão as credenciais validadas da conta de utilizador seleccionada.',
	'usercredentials-leg-user'        => 'Conta de utilizador',
	'usercredentials-leg-areas'       => 'Principais áreas de interesse',
	'usercredentials-leg-person'      => 'Informação pessoal',
	'usercredentials-leg-other'       => 'Outras informações',
	'usercredentials-email'           => 'Email:',
	'usercredentials-real'            => 'Nome real:',
	'usercredentials-bio'             => 'Biografia:',
	'usercredentials-attach'          => 'Curriculum Vitae:',
	'usercredentials-notes'           => 'Notas adicionais:',
	'usercredentials-urls'            => 'Lista de sítios web:',
	'usercredentials-ip'              => 'Endereço IP original:',
	'usercredentials-member'          => 'Privilégios:',
	'usercredentials-badid'           => 'Não foram encontradas credenciais para este utilizador. Verifique se o nome está correctamente escrito.',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'requestaccount-real'  => 'Ism n dṣṣaḥ :',
	'usercredentials-real' => 'Ism n dṣṣaḥ :',
);

/** Rhaeto-Romance (Rumantsch)
 * @author SPQRobin
 */
$messages['rm'] = array(
	'confirmaccount-real-q' => 'Num',
	'confirmaccount-name'   => "Num d'utilisader",
	'confirmaccount-real'   => 'Num:',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'requestaccount-leg-user'    => 'Cont de utilizator',
	'requestaccount-leg-areas'   => 'Arii principale de interes',
	'requestaccount-leg-person'  => 'Informaţii personale',
	'requestaccount-leg-other'   => 'Alte informaţii',
	'requestaccount-real'        => 'Nume real:',
	'requestaccount-email'       => 'Adresă e-mail:',
	'requestaccount-reqtype'     => 'Poziţie:',
	'requestaccount-level-0'     => 'autor',
	'requestaccount-bio'         => 'Biografie personală:',
	'requestaccount-attach'      => 'CV (opţional):',
	'confirmaccount-real-q'      => 'Nume',
	'confirmaccount-email-q'     => 'E-mail',
	'confirmaccount-bio-q'       => 'Biografie',
	'confirmaccount-showopen'    => 'cereri deschise',
	'confirmaccount-showrej'     => 'cereri respinse',
	'confirmaccount-showexp'     => 'cereri expirate',
	'confirmaccount-q-open'      => 'cereri deschise',
	'confirmaccount-q-rej'       => 'cereri respinse recent',
	'confirmaccount-q-stale'     => 'cereri expirate',
	'confirmaccount-leg-user'    => 'Cont de utilizator',
	'confirmaccount-leg-areas'   => 'Arii principale de interes',
	'confirmaccount-leg-person'  => 'Informaţii personale',
	'confirmaccount-leg-other'   => 'Alte informaţii',
	'confirmaccount-name'        => 'Nume de utilizator',
	'confirmaccount-real'        => 'Nume:',
	'confirmaccount-email'       => 'E-mail:',
	'confirmaccount-reqtype'     => 'Poziţie:',
	'confirmaccount-pos-0'       => 'autor',
	'confirmaccount-bio'         => 'Biografie:',
	'confirmaccount-attach'      => 'CV:',
	'confirmaccount-urls'        => 'Listă de situri web:',
	'confirmaccount-econf'       => '(confirmat)',
	'confirmaccount-ip'          => 'Adresă IP:',
	'confirmaccount-submit'      => 'Confirmă',
	'usercredentials-user'       => 'Nume de utilizator:',
	'usercredentials-leg-user'   => 'Cont de utilizator',
	'usercredentials-leg-areas'  => 'Arii principale de interes',
	'usercredentials-leg-person' => 'Informaţii personale',
	'usercredentials-leg-other'  => 'Alte informaţii',
	'usercredentials-email'      => 'E-mail:',
	'usercredentials-real'       => 'Nume real:',
	'usercredentials-bio'        => 'Biografie:',
	'usercredentials-attach'     => 'CV:',
	'usercredentials-urls'       => 'Listă de situri web:',
	'usercredentials-ip'         => 'Adresă IP originală:',
	'usercredentials-member'     => 'Drepturi:',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'requestaccount'                  => 'Запрос учётной записи',
	'requestaccount-text'             => "'''Заполните и отправьте следующую форму запроса учётной записи.'''
	
	Перед подачей запроса, пожалуйста, прочитайте [[{{MediaWiki:Requestaccount-page}}|Условия предоставления услуг]].
	
	После того, как учётная запись будет подтверждена, вам придёт уведомление по электронной почте, можно будет 
	[[Special:Userlogin|представиться системе]].",
	'requestaccount-page'             => '{{ns:project}}:Условия предоставления услуг',
	'requestaccount-dup'              => "'''Примечание: вы уже представились системе с зарегистрированной учётной записи.'''",
	'requestaccount-leg-user'         => 'Учётная запись',
	'requestaccount-leg-areas'        => 'Основные области интересов',
	'requestaccount-leg-person'       => 'Личные сведения',
	'requestaccount-leg-other'        => 'Прочая информация',
	'requestaccount-acc-text'         => 'После отправки заявки на ваш адрес будет о отправлено письмо с запросом подтверждения. Пожалуйста, нажмите на ссылку в письме, чтобы дать подтверждение. Пароль будет отправлен вам по почте, когда ваша учётная запись будет создана.',
	'requestaccount-areas-text'       => 'Выберите области, в которых вы компетентны или в которых собираетесь работать в наибольшей степени.',
	'requestaccount-ext-text'         => 'Следующая информация будет сохранена в секрете и будет использована только для обработки данного запроса.
	Вы можете перечислить способы связи, например, номер телефона, чтобы помочь в подтверждении идентичности.',
	'requestaccount-bio-text'         => 'Ваша биография будет по умолчанию помещена на вашу личную страницу. Попробуйте включить какие-либо полномочия. Убедитесь, что вы не против публикации этой информации. Ваше имя может быть изменено с помощью настроек [[Special:Preferences]].',
	'requestaccount-real'             => 'Настоящее имя:',
	'requestaccount-same'             => '(такая же как и настоящее имя)',
	'requestaccount-email'            => 'Электронная почта:',
	'requestaccount-reqtype'          => 'Должность:',
	'requestaccount-level-0'          => 'автор',
	'requestaccount-level-1'          => 'редактор',
	'requestaccount-bio'              => 'Личная биография:',
	'requestaccount-attach'           => 'Резюме (необязательно):',
	'requestaccount-notes'            => 'Дополнительные замечания:',
	'requestaccount-urls'             => 'Список веб-сайтов, если есть (по одному на каждой строчке):',
	'requestaccount-agree'            => 'Вы должны подтвердить, что ваше настоящее имя указано правильно и вы согласны с нашими Условиями предоставления услуг.',
	'requestaccount-inuse'            => 'Имя участника уже указано в одном из запросов на учётную запись.',
	'requestaccount-tooshort'         => 'Ваша биография должна содержать не менее $1 слов.',
	'requestaccount-emaildup'         => 'В другом необработанном запросе на получение учётной записи указан такой же адрес электронной почты.',
	'requestaccount-exts'             => 'Присоединение данного типа файлов запрещено.',
	'requestaccount-resub'            => 'В целях безопасности, ваш файл с резюме должен быть заменён. Оставьте поле пустым,
	если вы не желаете отправлять резюме.',
	'requestaccount-tos'              => 'Я прочитал и соглшаюсь следовать [[{{MediaWiki:Requestaccount-page}}|Условиям предоставления услуг]] проекта {{SITENAME}}.
	Имя, которое я указал в поле «Настоящее имя», действительно является моим настоящим именем.',
	'requestaccount-submit'           => 'Запросить учётную запись',
	'requestaccount-sent'             => 'Ваш запрос на получение учётной записи был успешно отправлен и теперь ожидает обработки.',
	'request-account-econf'           => 'Ваш адрес электронной почты был подтверждён и будет указан в вашем запросе учётной записи.',
	'requestaccount-email-subj'       => '{{SITENAME}}: подтверждение по эл. почте',
	'requestaccount-email-body'       => 'Кто-то (вероятно, вы) с IP-адреса $1 запросил на сайте {{SITENAME}},
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
	'acct_request_throttle_hit'       => 'Извините, вы уже запросили $1 учётных записей. Больше делать запросов вы не можете.',
	'requestaccount-loginnotice'      => 'Чтобы получить учётную запись, вы должны её [[Special:RequestAccount|запросить]].',
	'confirmaccount-newrequests'      => "Ожидается обработка '''$1'''  
{{PLURAL:$1|[[Special:ConfirmAccounts|запроса на учётную запись]]|[[Special:ConfirmAccounts|запросов на учётные записи]]|[[Special:ConfirmAccounts|запросов на учётные записи]]}}.",
	'confirmaccounts'                 => 'Подтверждение запросов учётных записей',
	'confirmedit-desc'                => 'Даёт бюрократам возможность подтверждать запросы на учётные записи',
	'confirmaccount-maintext'         => "'''Эта страница используется для подтверждения заявок на учётные записи проекта «{{SITENAME}}»'''.

Каждая очередь заявок состоит из трёх частей: открытые заявки; заявки отложенные администраторами до получения дополнительной информации; недавно отклонённые заявки.

Открыв заявку, внимательно просмотрите её, при необходимости, проверьте содержащуюся в ней информацию. Ваши действия будет записаты в журнал. Ожидается, что ваша работа по просмотру и подтверждению заявок будет независима от того, чем вы занимаетесь.",
	'confirmaccount-list'             => 'Ниже приведён список запросов на учётные записи, ожидающие утверждения. После подтверждения заявки, создаётся новая учётная запись, а заявка удаляется из этого списка. Отклонённые заявки просто удаляются из списка.',
	'confirmaccount-list2'            => 'Ниже представлен список недавно отклонённых заявок на учётные записи, через некоторое время заявки автоматически из него удаляются. Вы всё-таки можете утвердить заявку из этого списка, но, вероятно, это требует обсуждения с администратором, отклонившем заявку.',
	'confirmaccount-list3'            => 'Ниже приведён список устаревших запросов на учётные записи, которые могут быть удалены через несколько дней. Запрашиваемые учётные записи всё ещё могут быть утверждены.',
	'confirmaccount-text'             => "Это запрос на получение учётной записи в проекте '''«{{SITENAME}}»'''.

Внимательно рассмотрите представленную ниже информацию. Если вы решили подтвердить запрос, укажите положение учётной записи с помощью выпадающего списка. Изменения, внесённые в биографию не отразятся в постоянном хранилище удостоверений личности. Заметьте, что вы можете создать учётную запись под другим именем пользователя. Используйте эту возможность только для предотвращения столкновения с другими именами.

Если вы просто покинете эту страницу, не утвердив и не отклонив запрос, то запрос останется открытым.",
	'confirmaccount-none-o'           => 'В настоящее время необработанные запросы учётных записей отсутствуют.',
	'confirmaccount-none-h'           => 'В настоящее время отсутствуют отложенные запросы учётных записей.',
	'confirmaccount-none-r'           => 'В настоящее время список недавно отклонённых запросов пуст.',
	'confirmaccount-none-e'           => 'В настоящее время нет устаревших запросов учётных записей в этом списке.',
	'confirmaccount-real-q'           => 'Имя',
	'confirmaccount-email-q'          => 'Эл. адрес',
	'confirmaccount-bio-q'            => 'Биография',
	'confirmaccount-showopen'         => 'отрытые запросы',
	'confirmaccount-showrej'          => 'отклонённые запросы',
	'confirmaccount-showheld'         => 'Просмотр списка отложенных запросов',
	'confirmaccount-showexp'          => 'устаревшие запросы',
	'confirmaccount-review'           => 'Просмотреть',
	'confirmaccount-types'            => 'Выберете очередь подтверждения запросов из предложенных ниже:',
	'confirmaccount-all'              => '(показать все очереди)',
	'confirmaccount-type'             => 'Выбранная очередь:',
	'confirmaccount-type-0'           => 'будущие авторы',
	'confirmaccount-type-1'           => 'будущие редакторы',
	'confirmaccount-q-open'           => 'открытые запросы',
	'confirmaccount-q-held'           => 'отложенные запросы',
	'confirmaccount-q-rej'            => 'недавно отклонённые запросы',
	'confirmaccount-q-stale'          => 'устаревшие запросы',
	'confirmaccount-badid'            => 'Отсутствует отложенный запрос, соответствующий указанному идентификатору. Вероятно, он уже обработан.',
	'confirmaccount-leg-user'         => 'Учётная запись',
	'confirmaccount-leg-areas'        => 'Основные области интересов',
	'confirmaccount-leg-person'       => 'Личные сведения',
	'confirmaccount-leg-other'        => 'Прочая информация',
	'confirmaccount-name'             => 'Имя участника',
	'confirmaccount-real'             => 'Имя:',
	'confirmaccount-email'            => 'Эл. адрес:',
	'confirmaccount-reqtype'          => 'Должность:',
	'confirmaccount-pos-0'            => 'автор',
	'confirmaccount-pos-1'            => 'редактор',
	'confirmaccount-bio'              => 'Биография:',
	'confirmaccount-attach'           => 'Резюме:',
	'confirmaccount-notes'            => 'Дополнительные замечания:',
	'confirmaccount-urls'             => 'Список веб-сайтов:',
	'confirmaccount-none-p'           => '(не указано)',
	'confirmaccount-confirm'          => 'Используйте настройки для принятия, отклонения или откладывания запроса:',
	'confirmaccount-econf'            => '(подтверждён)',
	'confirmaccount-reject'           => '(отклонил [[User:$1|$1]] $2)',
	'confirmaccount-rational'         => 'Обоснование, даваемое заявителю:',
	'confirmaccount-noreason'         => '(нет)',
	'confirmaccount-autorej'          => '(этот запрос был автоматически отвергнут из-за неактивности)',
	'confirmaccount-held'             => '(отложил [[User:$1|$1]] $2)',
	'confirmaccount-create'           => 'Утвердить (создать учётную запись)',
	'confirmaccount-deny'             => 'Отклонить (убрать из списка)',
	'confirmaccount-hold'             => 'Отложить',
	'confirmaccount-spam'             => 'Спам (не будет отправлено письмо)',
	'confirmaccount-reason'           => 'Комментарий (будет включён в письмо):',
	'confirmaccount-ip'               => 'IP-адрес:',
	'confirmaccount-submit'           => 'Подтвердить',
	'confirmaccount-needreason'       => 'Вы должны указать причину в поле комментария.',
	'confirmaccount-canthold'         => 'Этот запрос уже удалён или отложен.',
	'confirmaccount-acc'              => 'Запрос на учётную запись успешно обработан, создана новая учётная запись [[User:$1]].',
	'confirmaccount-rej'              => 'Запрос на учётную запись был отклонён.',
	'confirmaccount-viewing'          => '(сейчас просматривается участником [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Создание страницы участника с биографией нового участника',
	'confirmaccount-welc'             => "'''Добро пожаловать в ''{{SITENAME}}''!''' Мы надеемся на ваше плодотворное участие.
Возможно, вам будет интересно ознакомиться со [[{{MediaWiki:Helppage}}|справочными страницами]]. Ещё раз добро пожаловать, приятного времяпрепровождения.",
	'confirmaccount-wsum'             => 'Добро пожаловать!',
	'confirmaccount-email-subj'       => 'Запрос учётной записи в {{SITENAME}}',
	'confirmaccount-email-body'       => 'Ваш запрос на создание учётной записи в {{SITENAME}} был утверждён.

Название учётной записи: $1

Пароль: $2

По соображениям безопасности, после первого входа в систему вам нужно будет изменить пароль. Представиться системе можно на странице 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Ваш запрос на создание учётной записи в {{SITENAME}} был утверждён.

Название учётной записи: $1

Пароль: $2

$3

По соображениям безопасности, после первого входа в систему вам нужно будет изменить пароль. Представиться системе можно на странице 
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Извините, ваш запрос на создание учётной записи «$1» на сайте {{SITENAME}} был отклонён.

Это могло произойти по различным причинам. Возможно, вы неверно заполнили поля формы, ваши ответы были недостаточно полными
или не удовлетворительными с точки зрения правил проекта. На сайте могут быть списки контактов, которыми вы можете воспользоваться,
чтобы получить более подробную информацию о правилах, касающихся учётных записей участников.',
	'confirmaccount-email-body4'      => 'Извините, ваш запрос на создание учётной записи «$1» на сайте {{SITENAME}} был отклонён.

$2

На сайте могут быть списки контактов, которыми вы можете воспользоваться,
чтобы получить более подробную информацию о правилах, касающихся учётных записей участников.',
	'confirmaccount-email-body5'      => 'Чтобы ваш запрос на создание учётной записи «$1» на сайте {{SITENAME}} был утверждён, вам следует
предоставить дополнительную информацию.

$2

На сайте могут быть списки контактов, которыми вы можете воспользоваться,
чтобы получить более подробную информацию о правилах, касающихся учётных записей участников.',
	'usercredentials'                 => 'Удостоверяющая информация об участнике',
	'usercredentials-leg'             => 'Поиск подтверждённой удостоверяющей информации об участнике',
	'usercredentials-user'            => 'Имя участника:',
	'usercredentials-text'            => 'Ниже показана проверенная удостоверяющая информация о выбранной учётной записи участника.',
	'usercredentials-leg-user'        => 'Учётная запись',
	'usercredentials-leg-areas'       => 'Основные области интересов',
	'usercredentials-leg-person'      => 'Личные сведения',
	'usercredentials-leg-other'       => 'Прочая информация',
	'usercredentials-email'           => 'Эл. почта:',
	'usercredentials-real'            => 'Настоящее имя:',
	'usercredentials-bio'             => 'Биография:',
	'usercredentials-attach'          => 'Резюме:',
	'usercredentials-notes'           => 'Дополнительные замечания:',
	'usercredentials-urls'            => 'Список веб-сайтов:',
	'usercredentials-ip'              => 'IP-адрес:',
	'usercredentials-member'          => 'Права:',
	'usercredentials-badid'           => 'Не найдена удостоверяющая информация об участнике. Проверьте правильность написания имени.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author SPQRobin
 */
$messages['sk'] = array(
	'requestaccount'                  => 'Vyžiadať účet',
	'requestaccount-text'             => "'''Vyplnením a odoslaním nasledovného formulára vyžiadate používateľský účet'''. Uistite sa, že ste si pred vyžiadaním účtu najskôr prečítali [[{{MediaWiki:Requestaccount-page}}|Podmienky použitia]]. Keď bude účet schválený, príde vám emailom oznámenie a bude možné prihlásiť sa na [[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:Podmienky použitia',
	'requestaccount-dup'              => "'''Pozn.: Už ste prihlásený ako zaregistrovaný používateľ.'''",
	'requestaccount-leg-user'         => 'Používateľský účet',
	'requestaccount-leg-areas'        => 'Hlavné oblasti záujmu',
	'requestaccount-leg-person'       => 'Osobné informácie',
	'requestaccount-leg-other'        => 'Ďalšie informácie',
	'requestaccount-acc-text'         => 'Na vašu emailovú adresu bude po odoslaní žiadosti zaslaná potvrdzujúca správa. Prosím, reagujte na ňu kliknutím na odkaz v nej. Potom ako bude váš účet vytvorený, dostanete emailom heslo k nemu.',
	'requestaccount-areas-text'       => 'Nižšie zvoľte tematické oblasti v ktorých ste formálne expertom alebo by ste v nich radi vykonávali väčšinu práce.',
	'requestaccount-ext-text'         => 'Nasledovné informácie budú držané v tajnosti a použijú sa iba na účel tejto žiadosti. Možno budete chcieť uviesť kontakty ako telefónne číslo, ktoré môžu pomôcť pri potvrdení.',
	'requestaccount-bio-text'         => 'Vaša biografia bude prvotným obsahom vašej používateľskej stránky. Pokúste sa uviesť všetky referencie. Zvážte, či ste ochotní zverejniť tieto informácie. Vaše meno je možné zmeniť pomocou [[Special:Preferences]].',
	'requestaccount-real'             => 'Skutočné meno:',
	'requestaccount-same'             => '(rovnaké ako skutočné meno)',
	'requestaccount-email'            => 'Emailová adresa:',
	'requestaccount-reqtype'          => 'Pozícia:',
	'requestaccount-level-0'          => 'autor',
	'requestaccount-level-1'          => 'redaktor',
	'requestaccount-bio'              => 'Osobná biografia:',
	'requestaccount-attach'           => 'Resumé alebo CV (nepovinné):',
	'requestaccount-notes'            => 'Ďalšie poznámky:',
	'requestaccount-urls'             => 'Zoznam webstránok, ak nejaké sú (jednu na každý riadok):',
	'requestaccount-agree'            => 'Musíte osvedčiť, že vaše skutočné meno je správne a že súhlasíte s našimi Podmienkami použitia.',
	'requestaccount-inuse'            => 'Používateľské meno už bolo vyžiadané v prebiehajúcej žiadosti o účet.',
	'requestaccount-tooshort'         => 'Vaša biografia musí mať aspoň $1 slov.',
	'requestaccount-emaildup'         => 'Iný účet čakajúci na schválenie používa rovnakú emailovú adresu.',
	'requestaccount-exts'             => 'Tento typ prílohy nie je povolený.',
	'requestaccount-resub'            => 'Váš súbor s CV/resumé je potrebné z bezpečnostných dôvodov znova vybrať. nechajte pole prázdne
	ak ste sa rozhodli žiadny nepriložiť.',
	'requestaccount-tos'              => 'Prečítal som a súhlasím, že budem dodržiavať [[{{MediaWiki:Requestaccount-page}}|Podmienky používania služby]] {{GRAMMAR:genitív|{{SITENAME}}}}. Meno, ktoré som uviedol ako „Skutočné meno“ je naozaj moje občianske meno.',
	'requestaccount-submit'           => 'Požiadať o účet',
	'requestaccount-sent'             => 'Vaša žiadosť o účet bola úspešne odoslaná a teraz sa čaká na jej kontrolu.',
	'request-account-econf'           => 'Vaša emailová adresa bola potvrdená a v takomto tvare sa uvedie vo vašej žiadosti o účet.',
	'requestaccount-email-subj'       => 'potvrdenie e-mailovej adresy pre {{GRAMMAR:akuzatív|{{SITENAME}}}}',
	'requestaccount-email-body'       => 'Niekto, pravdepodobne vy z IP adresy $1, zaregistroval účet
"$2" s touto e-mailovou adresou na {{GRAMMAR:lokál|{{SITENAME}}}}.

Pre potvrdenie, že tento účet skutočne patrí vám a pre aktivovanie
e-mailových funkcií na {{GRAMMAR:lokál|{{SITENAME}}}}, otvorte tento odkaz vo vašom prehliadači:

$3

Ak ste to *neboli* vy, neotvárajte odkaz. Tento potvrdzovací kód
vyprší o $4.',
	'requestaccount-email-subj-admin' => 'Žiadosť o účet vo {{GRAMMAR:lokál|{{SITENAME}}}}',
	'requestaccount-email-body-admin' => '„$1“ požiadal o účet a čaká na potvrdenie.
Emailová adresa bola potvrdená. Požiadavku môžete potvrdiť tu: „$2“.',
	'acct_request_throttle_hit'       => 'Prepáčte, už ste požiadali o vytvorenie $1 účtov. Nemôžete ich odoslať viac žiadostí.',
	'requestaccount-loginnotice'      => "Aby ste dostali používateľský účet, musíte '''[[Special:RequestAccount|oň požiadať]]'''.",
	'confirmaccount-newrequests'      => "Momentálne {{PLURAL:$1|je jedna otvorená|sú '''$1''' otvorené|je '''$1''' otvorených}} 
[[Special:ConfirmAccounts|{{PLURAL:$1|žiadosť o účet|žiadosti o účet|žiadostí o účet}}]].",
	'confirmaccounts'                 => 'Potvrdiť žiadosti o účet',
	'confirmedit-desc'                => 'Dáva byroktatom schopnosť potvrdzovať žiadosti o účet',
	'confirmaccount-maintext'         => "'''Táto stránka sa používa na potvrdzovanie nevybavencýh žiadostí o účet na ''{{GRAMMAR:lokál|{{SITENAME}}}}''''''.

Každý front žiadostí o účet pozostáva z troch podfront -- jednej pre otvorené požiadavky, druhej pre tie, ktoré boli pozdržané sptávcami kvôli chýbajúcim informáciám a tretej pre nedávno zamietnuté žiadosti.

Keď odpovedáte na žiadosť, pozorne si ju prečítajte a ak je to potrebné, overte obsiahnuté 
informácie.
O vašej činnosti sa povedie neverejný záznam. Tiež sa od vás očakáva, že budete kontrolovať činnosti, ktoré tu robia iní okrem vás.",
	'confirmaccount-list'             => 'Nižšie je zoznam žiadostí o účet, ktoré čakajú na schválenie. Schválené účty budú vytvorené a odstránené z tohoto zoznamu. Odmietnuté účty budú jednoducho odstránené z tohoto zoznamu.',
	'confirmaccount-list2'            => 'Nižšie je zoznam nedávno odmietnutých žiadostí o účet, ktoré môžu byť automaticky odstránené po niekoľkých dňoch. Ešte stále ich môžete schváliť a vytvoriť z nich platné účty, hoci by ste sa mali predtým, než tak učiníte, poradiť so správcom, ktorý ich odmietol.',
	'confirmaccount-list3'            => 'Toto je zoznam žiadostí o účet, ktorých platnosť vypršala a je ich možné po niekoľkých dňoch automaticky zmazať. Ešte stále je možné ich schváliť.',
	'confirmaccount-text'             => "Toto je žiadosť o používateľský účet na '''{{GRAMMAR:lokál|{{SITENAME}}}}'''.

Pozorne skontrolujte všetky dolu uvedené informácie. Ak schvaľute túto žiadosť, nastavte status používateľa z roletovej ponuky. Úpravy vykonané v biografii neovplyvnia akékoľvek trvalé uložisko údajov. Máte tiež možnosť vytvoriť účet pod odlišným používateľským menom. To však používajte iba na odstránenie konfliktov s inými menami.

Ak jednoducho opustíte túto stránku bez toho, aby ste ju schválili alebo odmietli, zostane v štádiu spracovania.",
	'confirmaccount-none-o'           => 'Momentálne nie sú v tomto zozname žiadne čakajúce žiadosti na vytvorenie účtu.',
	'confirmaccount-none-h'           => 'Momentálne nie sú v tomto zozname žiadne pozastavené žiadosti na vytvorenie účtu.',
	'confirmaccount-none-r'           => 'Momentálne nie sú v tomto zozname žiadne zamietnuté žiadosti na vytvorenie účtu.',
	'confirmaccount-none-e'           => 'Momentálne neexistujú žiadne žiadosti o účet s vypršanou platnosťou.',
	'confirmaccount-real-q'           => 'Meno',
	'confirmaccount-email-q'          => 'Email',
	'confirmaccount-bio-q'            => 'Biografia',
	'confirmaccount-showopen'         => 'otvorené žiadosti',
	'confirmaccount-showrej'          => 'odmietnuté žiadosti',
	'confirmaccount-showheld'         => 'Zobraziť zoznam účtov čakajúcich na schválenie',
	'confirmaccount-showexp'          => 'expirované žiadosti',
	'confirmaccount-review'           => 'Schváliť/odmietnuť',
	'confirmaccount-types'            => 'Dolu zvoľte front potvrdení účtov:',
	'confirmaccount-all'              => '(zobraziť všetky fronty)',
	'confirmaccount-type'             => 'Zvolený front:',
	'confirmaccount-type-0'           => 'budúci autori',
	'confirmaccount-type-1'           => 'budúci redaktori',
	'confirmaccount-q-open'           => 'otvorené žiadosti',
	'confirmaccount-q-held'           => 'pozastavené žiadosti',
	'confirmaccount-q-rej'            => 'nedávno zamietnuté žiadosti',
	'confirmaccount-q-stale'          => 'expirované žiadosti',
	'confirmaccount-badid'            => 'Neexistuje žiadna nespracovaná žiadosť o účet zodpovedajúca zadanému ID. Je možné, že už bola spracovaná.',
	'confirmaccount-leg-user'         => 'Používateľský účet',
	'confirmaccount-leg-areas'        => 'Hlavné oblasti záujmu',
	'confirmaccount-leg-person'       => 'Osobné informácie',
	'confirmaccount-leg-other'        => 'Ďalšie informácie',
	'confirmaccount-name'             => 'Používateľské meno',
	'confirmaccount-real'             => 'Meno:',
	'confirmaccount-email'            => 'Email:',
	'confirmaccount-reqtype'          => 'Pozícia:',
	'confirmaccount-pos-0'            => 'autor',
	'confirmaccount-pos-1'            => 'redaktor',
	'confirmaccount-bio'              => 'Biografia:',
	'confirmaccount-attach'           => 'Resumé/CV:',
	'confirmaccount-notes'            => 'Ďalšie poznámky:',
	'confirmaccount-urls'             => 'Zoznam webstránok:',
	'confirmaccount-none-p'           => '(neposkytnuté)',
	'confirmaccount-confirm'          => 'Tlačidlami nižšie môžete prijať alebo odmietnuť túto žiadosť.',
	'confirmaccount-econf'            => '(potvrdený)',
	'confirmaccount-reject'           => '(odmietol [[User:$1|$1]] $2)',
	'confirmaccount-rational'         => 'Zdôvodnenie pre uchádzača:',
	'confirmaccount-noreason'         => '(žiadne)',
	'confirmaccount-autorej'          => '(táto požiadavka bola automaticky zrušená z dôvodu neaktivity)',
	'confirmaccount-held'             => '(používateľ [[User:$1|$1]] $2 označenil ako „pozastavené“)',
	'confirmaccount-create'           => 'Prijať (vytvoriť účet)',
	'confirmaccount-deny'             => 'Odmietnuť (odstrániť žiadosť)',
	'confirmaccount-hold'             => 'Pozastaviť',
	'confirmaccount-spam'             => 'Spam (neposielať email)',
	'confirmaccount-reason'           => 'Komentár (bude súčasťou emailu email):',
	'confirmaccount-ip'               => 'IP adresa:',
	'confirmaccount-submit'           => 'Potvrdiť',
	'confirmaccount-needreason'       => 'Do komentára dolu musíte napísať dôvod.',
	'confirmaccount-canthold'         => 'Táto žiadosť je už buď pozdržaná alebo zmazaná.',
	'confirmaccount-acc'              => 'Žiadosť o účet bola úspešne potvrdená; bol vytvorený nový používateľský účet [[User:$1]].',
	'confirmaccount-rej'              => 'Žiadosť o účet bola úspešne odmietnutá.',
	'confirmaccount-viewing'          => '(momentálne sa na ňu pozerá [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Vytvára sa používateľská stránka s biografiou nového používateľa.',
	'confirmaccount-welc'             => "'''Vitajte v ''{{GRAMMAR:lokál|{{SITENAME}}}}''!''' Dúfame, že budete prispievať vo veľkom množstve a kvalitne. Pravdepodobne si budete chcieť prečítať [[{{MediaWiki:Helppage}}|Začíname]]. Tak ešte raz vitajte a bavte sa!",
	'confirmaccount-wsum'             => 'Vitajte!',
	'confirmaccount-email-subj'       => 'žiadosť o účet {{GRAMMAR:genitív|{{SITENAME}}}}',
	'confirmaccount-email-body'       => 'Vaša žiadosť o účet na {{GRAMMAR:lokál|{{SITENAME}}}} bola schválená. Názov účtu: $1 Heslo: $2 Z bezpečnostných dôvodov si budete musieť pri prvom prihlásení svoje heslo zmeniť. Teraz sa môžete prihlásiť na {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Vaša žiadosť o účet na {{GRAMMAR:lokál|{{SITENAME}}}} bola schválená. Názov účtu: $1 Heslo: $2 $3 Z bezpečnostných dôvodov si budete musieť pri prvom prihlásení svoje heslo zmeniť. Teraz sa môžete prihlásiť na {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Je nám ľúto, ale vaša žiadosť o účet „$1“ na {{GRAMMAR:lokál|{{SITENAME}}}} bola zamietnutá. Je niekoľko dôvodov, prečo sa to mohlo stať. Buď ste nevyplnili formulár správne, neposkytli ste požadovanú dĺžku vašich odpovedí alebo inak ste nesplnili kritériá. Ak sa chcete dozvedieť viac o politike tvorby účtov, na tejto stránke môžete nájsť kontakty.',
	'confirmaccount-email-body4'      => 'Je nám ľúto, ale vaša žiadosť o účet „$1“ na {{GRAMMAR:lokál|{{SITENAME}}}} bola zamietnutá.

$2

Ak sa chcete dozvedieť viac o politike tvorby účtov, na tejto stránke môžete nájsť kontakty.',
	'confirmaccount-email-body5'      => 'Predtým, než bude možné vašu žiadosť o účet „$1“ na {{GRAMMAR:lokál|{{SITENAME}}}} možné prijať 
	musíte poskytnúť ďalšie informácie.

$2

Na stránke môže byť uvedený zoznam kontaktov, ktorý môžete použiť ak sa chcete dozvedieť viac o politike používateľských účtov.',
	'usercredentials'                 => 'Osobné údaje používateľa',
	'usercredentials-leg'             => 'Vyhľadať potvrdené osobné údaje používateľa',
	'usercredentials-user'            => 'Používateľské meno:',
	'usercredentials-text'            => 'Dolu sú overené osobné údaje zvoleného používateľského účtu.',
	'usercredentials-leg-user'        => 'Používateľský účet',
	'usercredentials-leg-areas'       => 'Hlavné oblasti záujmu',
	'usercredentials-leg-person'      => 'Osobné informácie',
	'usercredentials-leg-other'       => 'Ďalšie informácie',
	'usercredentials-email'           => 'Email:',
	'usercredentials-real'            => 'Skutočné meno:',
	'usercredentials-bio'             => 'Biografia:',
	'usercredentials-attach'          => 'Resumé/CV:',
	'usercredentials-notes'           => 'Ďalšie poznámky:',
	'usercredentials-urls'            => 'Zoznam webstránok:',
	'usercredentials-ip'              => 'Pôvodná IP adresa:',
	'usercredentials-member'          => 'Práva:',
	'usercredentials-badid'           => 'Žiadne osobné informácie tohto používateľa neboli nájdené. Skontrolujte, či ste správne napísali meno.',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'requestaccount-email'    => 'Е-пошта:',
	'confirmaccount-noreason' => '(нема)',
);

/** Swati (SiSwati)
 * @author Jatrobat
 */
$messages['ss'] = array(
	'confirmaccount-real-q' => 'Ligama',
	'confirmaccount-real'   => 'Ligama:',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'requestaccount'             => 'Benutserkonto fräigje',
	'requestaccount-text'        => "'''Fäl dät foulgjende Formular uut un ferseend dät, uum n Benutserkonto tou fräigjen'''. 

	Läs eerste do [[{{MediaWiki:Requestaccount-page}}|Nutsengsbedingengen]] eer du n Benutserkonto fräigest.

	Sobolde dät Konto bestäätiged wuude, krichst du per E-Mail Bescheed un du koast die unner „[[{{ns:special}}:Userlogin|Anmäldje]]“ ienlogje.",
	'requestaccount-page'        => '{{ns:project}}:Nutsengsbedingengen',
	'requestaccount-dup'         => "'''Oachtenge: Du bäst al mäd n registrierd Benutserkonto ienlogged.'''",
	'requestaccount-acc-text'    => 'An dien E-Mail-Adresse wäd ätter dät Ouseenden fon dit Formular ne Bestäätigengsmail soand. 
Reagier deerap, wan du ap ju in ju Mail äntheeldene Bestäätigengsferbiendenge klikst.
Sobolde n dien Konto anlaid wuude,
wäd die dien Paaswoud per E-Mail tousoand.',
	'requestaccount-ext-text'    => 'Do foulgjende Informatione wäide fertjouelk behanneld un bloot foar dissen Andraach
ferwoand. Dd koast Kontakt-Angoawen as ne Telefonnummer moakje, uum ju Beoarbaidenge fon din Andraach eenfacher tou moakjen.',
	'requestaccount-bio-text'    => 'Dien Biographie wäd as initioale Inhoold fon dien Benutsersiede spiekerd. Fersäik aal do nöödige Referenzen tou ärwäänen, man staal sicher, dät du do Informatione wuddelk eepentelk bekoand moakje moatest. Du koast din Noome unner „[[{{ns:special}}:preferences|Ienstaalengen]]“ annerje.',
	'requestaccount-real'        => 'Realname:',
	'requestaccount-same'        => '(as die Realname)',
	'requestaccount-email'       => 'E-Mail-Adresse:',
	'requestaccount-bio'         => 'Persöönelke Biographie:',
	'requestaccount-attach'      => 'Lieuwensloop (optional):',
	'requestaccount-notes'       => 'Bietoukuumende Angoawen:',
	'requestaccount-urls'        => 'Lieste fon Websieden (truch Riegenuumbreeke tränd):',
	'requestaccount-agree'       => 'Du moast bestäätigje, dät din Realname so gjucht is un du do Benutserbedingengen akzeptierst.',
	'requestaccount-inuse'       => 'Die Benutsernoome is al in n uur Benutserandraach in Ferweendenge.',
	'requestaccount-tooshort'    => 'Dien Biographie schuul mindestens $1 Woude loang weese.',
	'requestaccount-exts'        => 'Die Doatäityp fon dän Anhong is nit ferlööwed.',
	'requestaccount-resub'       => 'Ju Doatäi mäd din Lieuwensloop mout uut Sicherhaidsgruunden näi uutwääld wäide.
Läit dät Fäild loos, wan du naan Lieuwensloop moor anföigje moatest.',
	'requestaccount-tos'         => 'Iek hääbe do [[{{MediaWiki:Requestaccount-page}}|Benutsengsbedingengen]] fon {{SITENAME}} leesen un akzeptierje do.
Iek bestäätigje, dät die Noome, dän iek unner „Realname“ ounroat hääbe, min wuddelke Noome is.',
	'requestaccount-submit'      => 'Fräigje uum n Benutserkonto',
	'requestaccount-sent'        => 'Dien Andraach wuude mäd Ärfoulch fersoand un mout nu noch wröiged wäide.',
	'request-account-econf'      => 'Dien E-Mail-Adresse wuude bestäätiged un wäd nu as sodoane in dien  Account-Froage fierd.',
	'requestaccount-email-subj'  => '{{SITENAME}} E-Mail-Adressen Wröich',
	'requestaccount-email-body'  => 'Wäl mäd ju IP-Adresse $1, muugelkerwiese du, häd bie {{SITENAME}} uum dät Benutserkonto "$2" mäd dien E-Mail Adresse fräiged.

Uum tou bestäätigjen, dät wuddelk du uum dit Konto bie {{SITENAME}} fräiged hääst, eepenje foulgjende Ferbiendenge in din Browser:

$3

Wan dät Benutserkonto moaked wuude, krichst du ne E-Mail mäd dät Paaswoud.

Wan du *nit* uum dät Benutserkonto fräiged hääst, eepenje ju Ferbiendenge nit!

Disse Bestäätigengscode wäd uum $4 uungultich.',
	'acct_request_throttle_hit'  => 'Du hääst al $1 uum Benutserkonten fräiged, du koast apstuuns neen wiedere fräigje.',
	'requestaccount-loginnotice' => "Uum n näi Benutserkonto tou kriegen, moast du 
der uum '''[[{{ns:special}}:RequestAccount|fräigje]]'''.",
	'confirmaccounts'            => 'Benutserkonto-Froagen bestäätigje',
	'confirmaccount-list'        => 'Hier unner finst du ne Lieste fon noch tou beoarbaidjen Benutserkonto-Froagen.
Bestäätigede Konten wäide anlaid un uut ju Lieste wächhoald. Ouliende Konten wäide eenfach uut ju Lieste läsked.',
	'confirmaccount-text'        => "Dit is n Andraach ap n Benutserkonto bie '''{{SITENAME}}'''. Wröigje aal hier unner stoundene Informatione gruundelk un bestäätigje do Informatione wan muugelk. Beoachtje, dät du dän Tougong bie Bedarf unner 
n uur Benutsernoome anlääse koast. Du schuust dät bloot nutsje, uum Kollisione mäd uur Noomen tou fermieden.

Wan du disse Siede ferlätst, sunner dät Konto tou bestäätigjen of outoulienen, dan blift die Andraach eepen stounde.",
	'confirmaccount-none-o'      => 'Apstuuns rakt et neen eepene Benutserandraage ap disse Lieste.',
	'confirmaccount-none-h'      => 'Apstuuns rakt et neen Andraage in dän „outäiwe“-Stoatus ap disse Lieste.',
	'confirmaccount-none-r'      => 'Apstuuns rakt et neen knu ouliende Benutserandraage ap disse Lieste.',
	'confirmaccount-real-q'      => 'Noome',
	'confirmaccount-email-q'     => 'E-Mail',
	'confirmaccount-bio-q'       => 'Biographie',
	'confirmaccount-showheld'    => 'Lieste fon do Andraage ap „outäiwe“-Stoatus anwiese',
	'confirmaccount-review'      => 'Bestäätigje/Ouliene',
	'confirmaccount-badid'       => 'Apstuuns rakt et neen Benutserandraach tou ju anroate ID. Muugelkerwiese wuude hie al beoarbaided.',
	'confirmaccount-name'        => 'Benutsernoome',
	'confirmaccount-real'        => 'Noome:',
	'confirmaccount-email'       => 'E-Mail:',
	'confirmaccount-bio'         => 'Biographie:',
	'confirmaccount-attach'      => 'Lieuwensloop:',
	'confirmaccount-urls'        => 'Lieste fon do Websieden:',
	'confirmaccount-none-p'      => '(Niks ounroat)',
	'confirmaccount-confirm'     => 'Benutsje ju foulgjende Uutwoal, uum dän Andraach tou akzeptierjen, outoulienen of noch tou täiwen.',
	'confirmaccount-econf'       => '(bestäätiged)',
	'confirmaccount-reject'      => '(ouliend truch [[User:$1|$1]] ap n $2)',
	'confirmaccount-held'        => '(markierd as „outäiwe“ truch [[User:$1|$1]] ap n $2)',
	'confirmaccount-create'      => 'Bestäätigje (Konto anlääse)',
	'confirmaccount-deny'        => 'Ouliene (Andraach läskje)',
	'confirmaccount-hold'        => 'Markierd as „outäiwe“',
	'confirmaccount-reason'      => 'Begruundenge (wäd in ju Mail an dän Andraachstaaler ienföiged):',
	'confirmaccount-ip'          => 'IP-Addresse:',
	'confirmaccount-submit'      => 'Ouseende',
	'confirmaccount-needreason'  => 'Du moast ne Begruundenge ounreeke.',
	'confirmaccount-canthold'    => 'Disse Froage wuude al as „outäiwe“ markierd of läsked.',
	'confirmaccount-acc'         => 'Benutserandraach mäd Ärfoulch bestäätiged; Benutser [[{{ns:User}}:$1]] wuude anlaid.',
	'confirmaccount-rej'         => 'Benutserandraach wuude ouliend.',
	'confirmaccount-summary'     => 'Moak Benutsersiede mäd ju Biographie fon dän näie Benutser.',
	'confirmaccount-welc'        => "'''Wäilkuumen bie ''{{SITENAME}}''!''' Wie hoopje, dät du fuul goude Informatione biedrächst.
	Muugelkerwiese moatest du eerste do [[{{MediaWiki:Helppage}}|Eerste Stappe]] leese. Nochmoal: Wäilkuumen un hääb Spoas!~",
	'confirmaccount-wsum'        => 'Wäilkuumen!',
	'confirmaccount-email-subj'  => '{{SITENAME}} Froage uum n Benutserkonto',
	'confirmaccount-email-body'  => 'Dien Froage uum n Benutserkonto bie {{SITENAME}} wuude bestäätiged.

Benutsernoome: $1

Paaswoud: $2

Uut Sicherhaidsgruunden schuust du dien Paaswoud uunbedingd bie dät eerste
Ienlogjen annerje. Uum die ientoulogjen gungst du ap ju Siede
{{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2' => 'Dien Froage uum n Benutserkonto bie {{SITENAME}} wuude bestäätiged. 

Benutsernoome: $1 

Paaswoud: $2 

$3

Uut Sicherhaidsgruunden schuust du dien Paaswoud uunbedingd bie dät eerste Ienlogjen annerje. Uum die ientoulogjen gungst du ap ju Siede {{fullurl:Special:Userlogin}}.',
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
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 * @author Irwangatot
 */
$messages['su'] = array(
	'requestaccount'                  => 'Ménta rekening',
	'requestaccount-dup'              => "'''CATETAN: Anjeun geus asup log migunakeun rekening nu geus kadaptar.'''",
	'requestaccount-leg-user'         => 'Rekening pamaké',
	'requestaccount-leg-areas'        => 'Widang pangaresep/minat',
	'requestaccount-leg-person'       => 'Émbaran pribadi',
	'requestaccount-leg-other'        => 'Émbaran lianna',
	'requestaccount-real'             => 'Ngaran asli:',
	'requestaccount-same'             => '(sarua jeung ngaran asli)',
	'requestaccount-email'            => "Alamat surélék (''e-mail''):",
	'requestaccount-reqtype'          => 'Posisi:',
	'requestaccount-level-0'          => 'pangarang',
	'requestaccount-level-1'          => 'éditor',
	'requestaccount-bio'              => 'Biografi pribadi:',
	'requestaccount-attach'           => 'Résumeu atawa CV (teu wajib):',
	'requestaccount-notes'            => 'Catetan panambih:',
	'requestaccount-urls'             => 'Béréndélan ramatloka, mun aya (pisahkeun ku baris anyar):',
	'requestaccount-tooshort'         => 'Biografi anjeun sahanteuna kudu ngandung $1 kecap.',
	'requestaccount-exts'             => 'Jenis lampiran nu dimuatkeun dipahing.',
	'requestaccount-submit'           => 'Pénta rekening',
	'requestaccount-sent'             => 'Paménta rekening anjeun anggeus dikirim sarta rék dipariksa heula.',
	'request-account-econf'           => 'Alamat surélék anjeun geus dikonfirmasi sarta bakal ditambahkeun kana paménta rekening anjeun.',
	'requestaccount-email-subj'       => 'Konfirmasi alamat surélék {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'Paménta rekening {{SITENAME}}',
	'requestaccount-loginnotice'      => "Pikeun miboga rekening pamaké, anjeun kudu '''[[Special:RequestAccount|daptar heula]]'''.",
	'confirmaccounts'                 => 'Konfirmasi pamundut rekening',
	'confirmedit-desc'                => 'Leler birokrat kawenangan ngonfirmasi paménta rekening.',
	'confirmaccount-real-q'           => 'Ngaran',
	'confirmaccount-email-q'          => 'Surélék',
	'confirmaccount-bio-q'            => 'Biografi',
	'confirmaccount-showopen'         => 'keur dipénta',
	'confirmaccount-showrej'          => 'paménta nu ditolak',
	'confirmaccount-showheld'         => 'paménta ngagantung',
	'confirmaccount-showexp'          => 'paménta kadaluwarsa',
	'confirmaccount-types'            => 'Pilih antrian konfirmasi rekening di handap:',
	'confirmaccount-all'              => '(témbongkeun sakabéh antrian)',
	'confirmaccount-type'             => 'Antrian:',
	'confirmaccount-leg-user'         => 'Rekening pamaké',
	'confirmaccount-leg-areas'        => 'Widang karesep/minat',
	'confirmaccount-leg-person'       => 'Émbaran pribadi',
	'confirmaccount-leg-other'        => 'Émbaran lianna',
	'confirmaccount-name'             => 'Landihan',
	'confirmaccount-real'             => 'Ngaran:',
	'confirmaccount-email'            => 'Surélék:',
	'confirmaccount-reqtype'          => 'Posisi:',
	'confirmaccount-pos-0'            => 'pangarang',
	'confirmaccount-pos-1'            => 'éditor',
	'confirmaccount-bio'              => 'Biografi:',
	'confirmaccount-attach'           => 'Résumeu/CV:',
	'confirmaccount-notes'            => 'Catetan panambih:',
	'confirmaccount-urls'             => 'Béréndélan ramatloka:',
	'confirmaccount-none-p'           => '(teu disadiakeun)',
	'confirmaccount-confirm'          => 'Pilih di handap pikeun nampa, nolak, atawa ngagantung ieu paménta:',
	'confirmaccount-econf'            => '(geus dikonfirmasi)',
	'confirmaccount-reject'           => '(ditolak ku [[User:$1|$1]] jam $2)',
	'confirmaccount-autorej'          => '(paménta ieu sacara otomatis dipiceun kusabab teu aktif)',
	'confirmaccount-held'             => '("keur ditahan" ku [[User:$1|$1]] jam $2)',
	'confirmaccount-create'           => 'Tampa (jieun rekening)',
	'confirmaccount-hold'             => 'Tahan',
	'confirmaccount-spam'             => 'Spam (ulah kirim surélék)',
	'confirmaccount-reason'           => 'Pamanggih (bakal dimuat dina surélék):',
	'confirmaccount-ip'               => 'Alamat IP:',
	'confirmaccount-submit'           => 'Konfirmasi',
	'confirmaccount-needreason'       => 'Anjeun kudu méré alesan dina kotak pamanggih di handap.',
	'confirmaccount-canthold'         => 'Ieu paménta keur digantung atawa geus dihapus.',
	'confirmaccount-acc'              => 'Paménta rekening geus dikonfirmasi; rekening anyar geus dijieun pikeun [[User:$1]].',
	'confirmaccount-wsum'             => 'Wilujeng sumping!',
	'usercredentials-user'            => 'Ngaran pamaké:',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Jon Harald Søby
 */
$messages['sv'] = array(
	'requestaccount'                  => 'Ansök om konto',
	'requestaccount-text'             => "'''Fyll i och skicka följande formulär för att ansöka om ett konto.'''

Se till att du har läst [[{{MediaWiki:Requestaccount-page}}|användningsvillkoren]] innan du frågar efter ett konto.

När din ansökan har godkänts, så kommer ett e-postmeddelande skickas till dig och ditt konto kan användas på [[Special:Userlogin]].",
	'requestaccount-page'             => '{{ns:project}}:Användningsvillkor',
	'requestaccount-dup'              => "'''Notera: Du är redan inloggad med ett registrerat konto.'''",
	'requestaccount-leg-user'         => 'Användarkonto',
	'requestaccount-leg-areas'        => 'Intresseområden',
	'requestaccount-leg-person'       => 'Personlig information',
	'requestaccount-leg-other'        => 'Annan information',
	'requestaccount-acc-text'         => 'När du skickar in den här ansökningen så kommer ett bekräftelsemeddelande skickas till din e-postadress. Svara på det meddelandet genom att klicka på bekräftelselänken i e-brevet. Till din e-postadress kommer även ditt lösenord skickas när ditt konto har skapats.',
	'requestaccount-areas-text'       => 'Välj här de ämnesområden som du har expertkunskap om eller som du kommer att arbeta mest med.',
	'requestaccount-ext-text'         => 'Följande information kommer hållas hemlig och bara användas för denna ansökan.
Om du vill kan du här ange kontaktinformation, t.ex. telefonnummer, för att lättare bekräfta din identitet.',
	'requestaccount-bio-text'         => 'Din biografi kommer användas som innehåll på din användarsida. Försök att ange dina meriter och referenser. Men se till att du inte besväras av att publicera sådan information. Ditt namn kan du ändra i dina  [[Special:Preferences|inställningar]].',
	'requestaccount-real'             => 'Riktigt namn:',
	'requestaccount-same'             => '(samma som ditt riktiga namn)',
	'requestaccount-email'            => 'E-postadress:',
	'requestaccount-reqtype'          => 'Ställning:',
	'requestaccount-level-0'          => 'författare',
	'requestaccount-level-1'          => 'redaktör',
	'requestaccount-bio'              => 'Personlig biografi:',
	'requestaccount-attach'           => 'Meritförteckning/CV (frivilligt):',
	'requestaccount-notes'            => 'Andra anmärkningar',
	'requestaccount-urls'             => 'Lista över webbplatser (skriv en per rad om det är flera):',
	'requestaccount-agree'            => 'Du måste bekräfta att ditt namn är riktigt och att du accepterar våra användningsvillkor.',
	'requestaccount-inuse'            => 'Användarnamnet används redan i en kontoansökan som väntar på att godkännas.',
	'requestaccount-tooshort'         => 'Din biografi måste innehålla minst $1 ord.',
	'requestaccount-emaildup'         => 'Samma e-postadress används i en annan kontoansökan som väntar på att godkännas.',
	'requestaccount-exts'             => 'Den bifogade filen har en otillåten filtyp.',
	'requestaccount-resub'            => 'Av säkerhetsskäl måste du välja filen med din meritförteckning/CV igen.
Lämna fältet tomt om du inte längre vill bifoga någon fil.',
	'requestaccount-tos'              => 'Jag har läst och lovar att följa [[{{MediaWiki:Requestaccount-page}}|användningsvillkoren]] på {{SITENAME}}.
Namnet som jag angivit som "Riktigt namn" är verkligen mitt egna riktiga namn.',
	'requestaccount-submit'           => 'Ansök om konto',
	'requestaccount-sent'             => 'Din kontoansökan har nu skickats och väntar på att godkännas.',
	'request-account-econf'           => 'Din e-postadress har bekräftats. Det kommer att anges i din kontoansökan.',
	'requestaccount-email-subj'       => 'Bekräftelse av e-postadress på {{SITENAME}}',
	'requestaccount-email-body'       => 'Någon, förmodligen du från IP-adressen $1, har ansökt om kontot "$2" med den här e-postadressen på {{SITENAME}}.

För att bekräfta att det är du som ansökt om detta konto på {{SITENAME}} så måste du öppna följande länk i din webbläsare:

$3

Om kontot skapas så kommer lösenordet skickas via e-post endast till dig. Om det *inte* är du som gjort ansökan, följ då inte länken.
Den här bekräftelsekoden slutar gälla den $4.',
	'requestaccount-email-subj-admin' => 'Ansökan om konto på {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" har ansökt om ett konto och väntar på att godkännas.
E-postadressen har bekräftats. Du kan godkänna ansökan på 
$2',
	'acct_request_throttle_hit'       => 'Du har redan ansökt om $1 konton. Du kan inte göra fler ansökningar.',
	'requestaccount-loginnotice'      => "För att få ett användarkonto måste du '''[[Special:RequestAccount|ansöka om det]]'''.",
	'confirmaccount-newrequests'      => "Just nu väntar '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|kontoansökning|kontoansökningar}}]] med bekräftad e-postadress på att behandlas.",
	'confirmaccounts'                 => 'Behandla kontoansökningar',
	'confirmedit-desc'                => 'Gör att nya användare måste ansöka om ett konto och bekräftas av byråkrater',
	'confirmaccount-maintext'         => "'''Den här sidan används för att verifiera kontoansökningar på ''{{SITENAME}}'''''.

Varje ansökningskö består av tre delköer, en för obehandlade ansökningar, en för ansökningar som avvaktar ytterligare information, och en för ansökningar som nyligen avslagits.

Granska noggrant ansökningar du svarar på, och verifiera informationen om det behövs.
De åtgärder du utför här skrivs in i en privat logg. Du förväntas även kontrollera hur andra användare hanterar ansökningar.",
	'confirmaccount-list'             => 'Härunder finns en lista över kontoansökningar som väntar på att godkännas. När en ansökning godkänns eller avslås så tas den bort från den här listan.',
	'confirmaccount-list2'            => 'Härunder finns en lista över kontoansökningar som nyligen avslagits. De kan komma att raderas automatiskt efter ett visst antal dagar.
Du kan fortfarande godkänna ansökningarna, men i så fall bör du först diskutera det med den administratör som avslog ansökningen.',
	'confirmaccount-list3'            => 'Härunder finns en lista över utgångna kontoansökningar som automatiskt kan komma att tas bort om några dagar. Tills dess kan ansökningarna fortfarande godkännas.',
	'confirmaccount-text'             => "Det här är en ansökan om ett konto på '''{{SITENAME}}'''.

Granska informationen härunder noggrant. Om du godkänner ansökningen så kan du använda ställningslistan för att välja kontostatus för den nya användaren.

Redigeringar av den ansökandes biografi kommer inte påverka vad som sparas permanent för användarens referenser. Observera att du kan välja att skapa kontot under ett annat användarnamn, men gör det bara för att undvika kollisioner med andra namn.

Om du lämnar den här sidan utan att godkänna eller avslå ansökan, så kommer ansökan att finnas kvar i sin nuvarande kö.",
	'confirmaccount-none-o'           => 'För närvarande finns inga obehandlade kontoansökningar.',
	'confirmaccount-none-h'           => 'För närvarande finns inga avvaktande kontoansökningar.',
	'confirmaccount-none-r'           => 'Inga kontoansökningar har avslagits nyligen.',
	'confirmaccount-none-e'           => 'För närvarande finns inga utgångna kontoansökningar.',
	'confirmaccount-real-q'           => 'Namn',
	'confirmaccount-email-q'          => 'E-post',
	'confirmaccount-bio-q'            => 'Biografi',
	'confirmaccount-showopen'         => 'obehandlade ansökningar',
	'confirmaccount-showrej'          => 'avslagna ansökningar',
	'confirmaccount-showheld'         => 'avvaktande ansökningar',
	'confirmaccount-showexp'          => 'utgångna ansökningar',
	'confirmaccount-review'           => 'Granska',
	'confirmaccount-types'            => 'Välj någon av ansökningslistorna härunder:',
	'confirmaccount-all'              => '(visa alla köer)',
	'confirmaccount-type'             => 'Kö:',
	'confirmaccount-type-0'           => 'ansökande författare',
	'confirmaccount-type-1'           => 'ansökande redaktörer',
	'confirmaccount-q-open'           => 'obehandlade ansökningar',
	'confirmaccount-q-held'           => 'avvaktande ansökningar',
	'confirmaccount-q-rej'            => 'nyligen avslagna ansökningar',
	'confirmaccount-q-stale'          => 'utgångna ansökningar',
	'confirmaccount-badid'            => 'Det finns ingen ansökan med det ID som angavs.
Ansökan kanske redan har behandlats.',
	'confirmaccount-leg-user'         => 'Användarkonto',
	'confirmaccount-leg-areas'        => 'Intresseområden',
	'confirmaccount-leg-person'       => 'Personlig information',
	'confirmaccount-leg-other'        => 'Annan information',
	'confirmaccount-name'             => 'Användarnamn',
	'confirmaccount-real'             => 'Namn:',
	'confirmaccount-email'            => 'E-post:',
	'confirmaccount-reqtype'          => 'Ställning:',
	'confirmaccount-pos-0'            => 'författare',
	'confirmaccount-pos-1'            => 'redaktör',
	'confirmaccount-bio'              => 'Biografi:',
	'confirmaccount-attach'           => 'Meritförteckning/CV:',
	'confirmaccount-notes'            => 'Andra anmärkningar:',
	'confirmaccount-urls'             => 'Lista över webbplatser:',
	'confirmaccount-none-p'           => '(bifogades ej)',
	'confirmaccount-confirm'          => 'Välj något av alternativen nedan för att godkänna, avslå, eller avvakta med ansökan:',
	'confirmaccount-econf'            => '(bekräftad)',
	'confirmaccount-reject'           => '(avslogs av [[User:$1|$1]] den $2)',
	'confirmaccount-rational'         => 'Motivering som gavs till den sökande:',
	'confirmaccount-noreason'         => '(ingen)',
	'confirmaccount-autorej'          => '(den här ansökningen har kasserats automatiskt på grund av inaktvitet)',
	'confirmaccount-held'             => '(markerad som "avvaktande" av [[User:$1|$1]] den $2)',
	'confirmaccount-create'           => 'Godkänn (skapa konto)',
	'confirmaccount-deny'             => 'Avslå (stryk från listan)',
	'confirmaccount-hold'             => 'Avvakta',
	'confirmaccount-spam'             => 'Spam (sänd inte e-post)',
	'confirmaccount-reason'           => 'Kommentar (skickas som e-post):',
	'confirmaccount-ip'               => 'IP-adress:',
	'confirmaccount-submit'           => 'Bekräfta',
	'confirmaccount-needreason'       => 'Du måste skriva en motivering i kommentarrutan nedan.',
	'confirmaccount-canthold'         => 'Ansökningen är antingen redan avvaktande eller har avslagits.',
	'confirmaccount-acc'              => 'Kontoansökningen har godkänts och användarkontot [[User:$1|$1]] har skapats.',
	'confirmaccount-rej'              => 'Ansökningen har avslagits.',
	'confirmaccount-viewing'          => '(granskas just nu av [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Skapar användarsida med biografi för en ny användare.',
	'confirmaccount-welc'             => "'''Välkommen till ''{{SITENAME}}''!''' Vi hoppas att du kommer skriva många bra bidrag.
Du kommer formodligen ha nytta av att läsa [[{{MediaWiki:Helppage}}|hjälpsidorna]]. Vi önskar igen välkommen och ha kul!",
	'confirmaccount-wsum'             => 'Välkommen!',
	'confirmaccount-email-subj'       => 'Ansökan om konto på {{SITENAME}}',
	'confirmaccount-email-body'       => 'Din ansökan om ett konto på {{SITENAME}} har godkänts.

Användarnamn: $1

Lösenord: $2

Av säkerhetsskäl måste du byta lösenord första gången du loggar in. För att logga in, gå till {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Din ansökan om ett konto på {{SITENAME}} har godkänts.

Användarnamn: $1

Lösenord: $2

$3

Av säkerhetsskäl måste du byta lösenord första gången du loggar in. För att logga in, gå till {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Tyvärr har din ansökan om kontot "$1" på {{SITENAME}} avslagits.

Det kan finnas flera orsaker till det.
Det är möjligt att du inte fyllde i formuläret på rätt sätt, att du inte gav tillräckligt utförliga svar, eller att du på något annat sätt inte uppfyller villkoren för att få ett användarkonto.
Det kan finnas kontaktinformation på webbplatsen som du kan använda om du vill få mer information om reglerna för användarkonton.',
	'confirmaccount-email-body4'      => 'Tyvärr har din ansökan om kontot "$1" på {{SITENAME}} avslagits.

$2

Det kan finnas kontaktinformation på webbplatsen som du kan använda om du vill få mer information om reglerna för användarkonton.',
	'confirmaccount-email-body5'      => 'Innan din ansökan om kontot "$1" på {{SITENAME}} kan godkännas så måste du lämna ytterligare information.

$2

Det kan finnas kontaktinformation på webbplatsen som du kan använda om du vill få mer information om reglerna för användarkonton.',
	'usercredentials'                 => 'Referenser för användare',
	'usercredentials-leg'             => 'Se bekräftade referenser för en användare',
	'usercredentials-user'            => 'Användarnamn:',
	'usercredentials-text'            => 'Härunder visas de bekräftade referenserna för det valda användarkontot.',
	'usercredentials-leg-user'        => 'Användarkonto',
	'usercredentials-leg-areas'       => 'Intresseområden',
	'usercredentials-leg-person'      => 'Personlig information',
	'usercredentials-leg-other'       => 'Annan information',
	'usercredentials-email'           => 'E-post:',
	'usercredentials-real'            => 'Riktigt namn:',
	'usercredentials-bio'             => 'Biografi:',
	'usercredentials-attach'          => 'Meritförteckning/CV:',
	'usercredentials-notes'           => 'Andra anmärkningar:',
	'usercredentials-urls'            => 'Lista över webbplatser:',
	'usercredentials-ip'              => 'Ursprunglig IP-adress:',
	'usercredentials-member'          => 'Rättigheter:',
	'usercredentials-badid'           => 'Hittade inga referenser för denna användare. Kontrollera att namnet är rättstavat.',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'confirmaccount-real-q' => 'Mjano',
	'confirmaccount-real'   => 'Mjano:',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'confirmaccount-name'  => 'பயனர் பெயர்',
	'usercredentials-user' => 'பயனர் பெயர்:',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author Chaduvari
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'requestaccount'                  => 'ఖాతాను అభ్యర్ధించండి',
	'requestaccount-text'             => "'''వాడుకరి ఖాతా కోసం కింది ఫారమును నింపి పంపించండి'''.  

ఖాతా కావాలని అడిగే ముందు [[{{MediaWiki:Requestaccount-page}}|సేవా నియమాలను]] తప్పక చదవండి.

ఖాతాను అనుమతించాక, ఆ సంగతి తెలుపుతూ మీకో ఈమెయిలు వస్తుంది. ఖాతా వివరాలను [[Special:Userlogin]] వద్ద వాడుకోవచ్చు.",
	'requestaccount-page'             => '{{ns:project}}:సేవా నియమాలు',
	'requestaccount-dup'              => "'''గమనిక: మీరు ఈసరికే నమోదైన ఖాతాతో లోనికి ప్రవేశించారు.'''",
	'requestaccount-leg-user'         => 'వాడుకరి ఖాతా',
	'requestaccount-leg-areas'        => 'ప్రధాన ఆసక్తులు',
	'requestaccount-leg-person'       => 'వ్యక్తిగత సమాచారం',
	'requestaccount-leg-other'        => 'ఇతర సమాచారం',
	'requestaccount-acc-text'         => 'మీరీ అభ్యర్ధన పంపించగానే మీ ఈమెయిలుకో ధృవీకరణ సందేశం వస్తుంది. దానిలో ఉన్న షృవీకరణ లింకును నొక్కండి. మీ ఖాతా తయారు కాగానే మీ సంకేతపదాన్ని కూడా పంపిస్తాం.',
	'requestaccount-areas-text'       => 'కింది విషయాల లోంచి మీకు ప్రవేశం ఉన్న వాటిని లేదా మీరు పనిచేయదలచిన వాటిని ఎంచుకోండి.',
	'requestaccount-ext-text'         => 'కింది సమాచారాన్ని గోప్యంగా ఉంచుతాం, ఈ అభ్యర్ధన కోసం మాత్రమే వాడుతాం. 
మిమ్మల్ని గుర్తించటంలో సాయపడే ఫోను నంబరు వంటి పరిచయ వివరలను ఇవ్వవచ్చు.',
	'requestaccount-bio-text'         => 'మీ వ్యక్తిగత వివరాలే మీ వాడుకరిపేజీకి డిఫాల్టు కంటెంటుగా ఉంటుంది. 
ఇంకా ఏమైనా చేర్చాలంటే చేర్చండి.
మీకు ఇబ్బంది లేని సమాచారాన్ని మాత్రమే ప్రచురించండి.
[[Special:Preferences]] కు వెళ్ళి మీ పేరును మార్చుకోవచ్చు.',
	'requestaccount-real'             => 'అసలు పేరు:',
	'requestaccount-same'             => '(వాస్తవిక పేరు ఏదో అదే)',
	'requestaccount-email'            => 'ఈమెయిలు చిరునామా:',
	'requestaccount-reqtype'          => 'స్థానము:',
	'requestaccount-level-0'          => 'రచయిత',
	'requestaccount-level-1'          => 'సంపాదకులు',
	'requestaccount-bio'              => 'వ్యక్తిగత జీవితచరిత్ర:',
	'requestaccount-attach'           => 'రెజ్యూమె లేదా CV (మీ ఇష్టం):',
	'requestaccount-notes'            => 'అదనపు గమనికలు:',
	'requestaccount-urls'             => 'వెబ్&zwnj;సైట్ల జాబితా, ఉంటే గనక (లైనుకి ఒకటి చొప్పున):',
	'requestaccount-agree'            => 'మీ నిజమైన పేరు సరియేనని మరియు మా సేవా నియమాలని మీరు అంగీకరిస్తున్నారని దృవపరచాలి.',
	'requestaccount-inuse'            => 'వాడుకరిపేరు ఈసరికే వేచివున్న ఖాతా అభ్యర్థనలలో ఉంది.',
	'requestaccount-tooshort'         => 'మీ బయోగ్రఫీ తప్పనిసరిగా కనీసం $1 పదాల పొడవు ఉండాలి.',
	'requestaccount-emaildup'         => 'మరో వేచివున్న ఖాతా అభ్యర్థన ఇదే ఈ-మెయిల్ చిరునామాని వాడుతుంది.',
	'requestaccount-exts'             => 'జోడించిన ఫైలు రకానికి అనుమతి లేదు.',
	'requestaccount-resub'            => 'భద్రతా కారణాల రీత్యా మీ CV/రెజ్యూమె ఫైలును తిరిగి ఎంచుకోవాలి.
అసలు దేన్నీ పెట్టదలచకపోతే ఈ ఫీల్డును ఖాళీగా వదిలెయ్యండి.',
	'requestaccount-tos'              => '{{SITENAME}} యొక్క [[{{MediaWiki:Requestaccount-page}}|సేవా నియమాలను]] చదివాను. వాటికి బద్ధుడనై/బద్ధురాలనై ఉంటాను.
"అసలు పేరు" కింద నేను ఇచ్చిన పేరు నిజంగానే నా అసలు పేరు.',
	'requestaccount-submit'           => 'ఖాతాని అభ్యర్థించండి',
	'requestaccount-sent'             => 'ఈ ఖాతా అభ్యర్థనని విజయవంతంగా పంపించాం. అది సమీక్షకై వేచివుంది.',
	'request-account-econf'           => 'మీ ఈ-మెయిల్ చిరునామా నిర్థారితమయ్యింది మరియు మీ ఖాతా అభ్యర్థనలో అలానే నమోదవుతుంది.',
	'requestaccount-email-subj'       => '{{SITENAME}} ఈ-మెయిల్ చిరునామా నిర్ధారణ',
	'requestaccount-email-body'       => '{{SITENAME}} లో $1 ఐపీ అడ్రసు నుండి ఎవరో, బహుశా మీరే, ఈ ఈమెయిలు అడ్రసుతో "$2" ఖాతా కావాలని అభ్యర్ధించారు.

{{SITENAME}} లోని ఈ ఖాతా నిజంగానే మీదేనని నిర్ధారించేందుకు, ఈ లింకును మీ బ్రౌజరులో తెరవండి:

$3

ఖాతా సృష్టించబడితే, మీకు మాత్రమే సంకేతపదం ఈ-మెయిలులో వస్తుంది.
ఖాతా అభ్యర్థించినది మీరు *కాకపోతే*, ఆ లింకును నొక్కకండి.
ఈ నిర్థారణ సంకేతం $4 నాడు కాలం చెల్లుతుంది.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} ఖాతా అభ్యర్థన',
	'requestaccount-email-body-admin' => '"$1" ఓ ఖాతా కావాలని అడిగి నిర్ధారణ కోసం చూస్తున్నారు.
ఈ-మెయిలు అడ్రసు నిర్ధారణైంది. మీ అభ్యర్ధనను "$2" వద్ద నిర్ధారించవచ్చు.',
	'acct_request_throttle_hit'       => 'క్షమించండి, మీరిప్పటికే $1 ఖాతాలను అభ్యర్ధించారు. ఇంకా ఎక్కవ అభ్యర్థనలు చెయ్యలేరు.',
	'requestaccount-loginnotice'      => "ఖాతా పొందడానికి, మీరు తప్పనిసరిగా '''[[Special:RequestAccount|అభ్యర్థించాలి]]'''.",
	'confirmaccount-newrequests'      => "ప్రస్తుతం '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|ఖాతా అభ్యర్థన]]|[[Special:ConfirmAccounts|ఖాతా అభ్యర్థనలు]]}} వేచి{{PLURAL:$1|వుంది|వున్నాయి}}.",
	'confirmaccounts'                 => 'ఖాతా అభ్యర్థనలను నిర్ధారించండి',
	'confirmedit-desc'                => 'అధికారులకు ఖాతా అభ్యర్థనలను నిర్ధారించే వీలుకల్పిస్తుంది',
	'confirmaccount-none-o'           => 'ప్రస్తుతం ఈ జాబితాలో పెండింగులో ఉన్న తెరచి ఉన్న అభ్యర్ధనలేమీ లేవు.',
	'confirmaccount-none-h'           => 'ప్రస్తుతం ఈ జాబితాలో అట్టేపెట్టిన పెండింగు అభ్యర్ధనలేమీ లేవు.',
	'confirmaccount-none-r'           => 'ప్రస్తుతం ఈ జాబితాలో ఇటీవల తిరస్కరించిన ఖాతా అభ్యర్థనలు ఏమీలేవు.',
	'confirmaccount-none-e'           => 'ప్రస్తుతం ఈ జాబితాలో మురిగిపోయిన ఖాతాల అభ్యర్ధనలేమీ లేవు.',
	'confirmaccount-real-q'           => 'పేరు',
	'confirmaccount-email-q'          => 'ఈ-మెయిల్',
	'confirmaccount-bio-q'            => 'బయోగ్రఫీ',
	'confirmaccount-showopen'         => 'తెరచి ఉన్న అభ్యర్ధనలు',
	'confirmaccount-showrej'          => 'తిరస్కరించిన అభ్యర్ధనలు',
	'confirmaccount-showheld'         => 'అట్టేపెట్టిన ఉన్న అభ్యర్ధనలు',
	'confirmaccount-showexp'          => 'కాలంచెల్లిన అభ్యర్థనలు',
	'confirmaccount-review'           => 'సమీక్ష',
	'confirmaccount-types'            => 'కిందివాటిలోంచి ఒక ఖాతా నిర్ధారణ క్యూను ఎంచుకోండి:',
	'confirmaccount-all'              => '(క్యూలన్నిటినీ చూపించు)',
	'confirmaccount-type'             => 'క్యూ:',
	'confirmaccount-type-0'           => 'కాబోయే రచయితలు',
	'confirmaccount-type-1'           => 'కాబోయే సంపాదకులు',
	'confirmaccount-q-open'           => 'తెరచి ఉన్న అభ్యర్ధనలు',
	'confirmaccount-q-held'           => 'అట్టేపెట్టిన అభ్యర్ధనలు',
	'confirmaccount-q-rej'            => 'ఇటీవల తిరస్కరించిన అభ్యర్థనలు',
	'confirmaccount-q-stale'          => 'మురిగిపోయిన అభ్యర్ధనలు',
	'confirmaccount-badid'            => 'ఇచ్చిన IDకి సరిపోలిన పెండింగు అభ్యర్ధనలేమీ లేవు.
దాన్ని ఇప్పటికే పరిశీలించి ఉండవచ్చు.',
	'confirmaccount-leg-user'         => 'వాడుకరి ఖాతా',
	'confirmaccount-leg-areas'        => 'ప్రధాన ఆసక్తులు',
	'confirmaccount-leg-person'       => 'వ్యక్తిగత సమాచారం',
	'confirmaccount-leg-other'        => 'ఇతర సమాచారం',
	'confirmaccount-name'             => 'వాడుకరి పేరు',
	'confirmaccount-real'             => 'పేరు:',
	'confirmaccount-email'            => 'ఈ-మెయిల్:',
	'confirmaccount-reqtype'          => 'స్థానం:',
	'confirmaccount-pos-0'            => 'రచయిత',
	'confirmaccount-pos-1'            => 'రచయిత',
	'confirmaccount-bio'              => 'బయోగ్రఫీ:',
	'confirmaccount-notes'            => 'అదనపు గమనికలు:',
	'confirmaccount-urls'             => 'వెబ్ సైట్ల జాబితా:',
	'confirmaccount-none-p'           => '(ఇవ్వలేదు)',
	'confirmaccount-confirm'          => 'ఈ అభ్యర్థనను అంగీకరించడానికి, తిరస్కరించడానికి, లేదా ఆపివుంచడానికి ఈ క్రింది ఎంపికలు వాడండి:',
	'confirmaccount-econf'            => '(ధృవీకరించబడినది)',
	'confirmaccount-reject'           => '($2 నాడు [[User:$1|$1]] తిరస్కరించారు)',
	'confirmaccount-rational'         => 'అభ్యర్థికి తెలుపాల్సిన కారణం:',
	'confirmaccount-noreason'         => '(ఏమీలేదు)',
	'confirmaccount-held'             => '($2 నాడు [[User:$1|$1]] "ఆపివుంచు" అని గుర్తించారు)',
	'confirmaccount-create'           => 'అంగీకరించు (ఖాతా సృష్టించు)',
	'confirmaccount-deny'             => 'తిరస్కరించు (జాబితానుండి తీసివేయి)',
	'confirmaccount-hold'             => 'ఆపివుంచు',
	'confirmaccount-reason'           => 'వ్యాఖ్య (ఈ-మెయిల్&zwnj;లో చేర్చుతాం):',
	'confirmaccount-ip'               => 'ఐపీ చిరునామా:',
	'confirmaccount-submit'           => 'నిర్ధారించు',
	'confirmaccount-needreason'       => 'క్రిందనిచ్చిన వ్యాఖ్య పెట్టెలో తప్పనిసరిగా ఓ కారణం ఇవ్వాలి',
	'confirmaccount-canthold'         => 'ఈ అభ్యర్థనని ఈపాటికే ఆపివుంచారు లేదా తొలగించారు.',
	'confirmaccount-acc'              => 'ఖాతా అభ్యర్థనని విజయవంతంగా నిర్థారించారు; [[User:$1]] అనే కొత్త వాడుకరి ఖాతాని సృష్టించాం.',
	'confirmaccount-rej'              => 'ఖాతా కోసం చేసిన అభ్యర్ధన తిరస్కరించబడినది',
	'confirmaccount-viewing'          => '(ప్రస్తుతం [[User:$1|$1]] చూస్తున్నారు)',
	'confirmaccount-summary'          => 'కొత్త వాడుకరి యొక్క బయోగ్రఫీతో వాడుకరి పేజీ సృష్టిస్తున్నాం',
	'confirmaccount-wsum'             => 'స్వాగతం!',
	'confirmaccount-email-subj'       => '{{SITENAME}} ఖాతా అభ్యర్థన',
	'confirmaccount-email-body'       => '{{SITENAME}}లో ఖాతా కొరకు మీ అభ్యర్థనని సమ్మతించాము.

ఖాతా పేరు: $1

సంకేతపదం: $2

భద్రతా కారణాల వల్ల మీ మొదటి ప్రవేశంలో మీ సంకేతపదాన్ని మార్చుకోవాలి. ప్రవేశించడానికి, {{fullurl:Special:Userlogin}}కి వెళ్ళండి.',
	'confirmaccount-email-body2'      => '{{SITENAME}}లో ఖాతా కొరకు మీ అభ్యర్థనని సమ్మతించాము.

ఖాతా పేరు: $1

సంకేతపదం: $2

$3

భద్రతా కారణాల వల్ల మీ మొదటి ప్రవేశంలో మీ సంకేతపదాన్ని మార్చుకోవాలి. ప్రవేశించడానికి, {{fullurl:Special:Userlogin}}కి వెళ్ళండి.',
	'confirmaccount-email-body4'      => 'క్షమించండి, {{SITENAME}}లో "$1" అనే ఖాతా కొరకు మీ అభ్యర్థనని తిరస్కరించారు.

$2

వాడుకరి ఖాతా విధానం గురించి మీరు మరింత తెలుసుకోవాలనుంటే పైటులో సంప్రదింపు చిరునామాని వాడవచ్చు.',
	'confirmaccount-email-body5'      => '{{SITENAME}}లో "$1" అనే ఖాతా కొరకు మీ అభ్యర్థనని అంగీకరించాలంటే మీరు తప్పనిసరిగా మరింత అదనపు సమాచారం ఇవ్వాలి.

$2

వాడుకరి ఖాతా విధానం గురించి మీరు మరింత తెలుసుకోవాలనుకుంటే పైటులో సంప్రదింపు చిరునామాని వాడవచ్చు.',
	'usercredentials'                 => 'వాడుకరి తాఖీదులు',
	'usercredentials-user'            => 'వాడుకరి పేరు:',
	'usercredentials-leg-user'        => 'వాడుకరి ఖాతా',
	'usercredentials-leg-areas'       => 'ప్రధాన ఆసక్తులు',
	'usercredentials-leg-person'      => 'వ్యక్తిగత సమాచారం',
	'usercredentials-leg-other'       => 'ఇతర సమాచారం',
	'usercredentials-email'           => 'ఈ-మెయిల్:',
	'usercredentials-real'            => 'నిజమైన పేరు:',
	'usercredentials-bio'             => 'బయోగ్రఫీ:',
	'usercredentials-attach'          => 'రెస్యూమె/CV:',
	'usercredentials-notes'           => 'అదనపు గమనికలు:',
	'usercredentials-urls'            => 'వెబ్&zwnj;సైట్ల జాబితా:',
	'usercredentials-ip'              => 'అసలు IP చిరునామా:',
	'usercredentials-member'          => 'హక్కులు:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'requestaccount-email'   => 'Diresaun korreiu eletróniku:',
	'requestaccount-level-0' => 'autór',
	'confirmaccount-real-q'  => 'Naran',
	'confirmaccount-email-q' => 'Korreiu eletróniku',
	'confirmaccount-real'    => 'Naran:',
	'confirmaccount-email'   => 'Korreiu eletróniku:',
	'confirmaccount-pos-0'   => 'autór',
	'usercredentials-email'  => 'Korreiu eletróniku:',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 * @author Siebrand
 */
$messages['tg-cyrl'] = array(
	'requestaccount'                  => 'Дархости ҳисоб',
	'requestaccount-text'             => "'''Форми зеринро барои дархости ҳисоби корбарӣ пур карда ирсол кунед'''.

Мутмани бошед, ки шумо аввал [[{{MediaWiki:Requestaccount-page}}|Шартҳои Хидматро]] қабл аз дахости ҳисоб хондаед.

Дар ҳоли тасдиқ шудани ҳисоб, паёми огоҳсозӣ тариқи почтаи электронӣ ба шумо фиристода хоҳад шуд ва ҳисоби шумо дар [[Special:Userlogin]] қобили истифода хоҳад шуд.",
	'requestaccount-page'             => '{{ns:project}}:Шартҳои Хидмат',
	'requestaccount-dup'              => "'''Эзоҳ: Шумо аллакай бо ҳисоби сабтшуда вуруд кардаед.'''",
	'requestaccount-leg-user'         => 'Ҳисоби корбар',
	'requestaccount-leg-person'       => 'Иттилооти шахсӣ',
	'requestaccount-leg-other'        => 'Иттилооти дигар',
	'requestaccount-acc-text'         => 'Ба нишонаи почтаи электронии шумо паёми тасдиқи дар ҳоли фиристодани ин дархост фиристода хоҳад шуд.
Лутфан бо клик кардани пайванди тасдиқии тариқи почтаи электронӣ фиристода шуда посух диҳед.
Гузарвожа низ дар ҳолати эҷод шудани ҳисоби шумо ба нишонаи почтаи электронӣ фиристода хоҳад шуд.',
	'requestaccount-bio-text'         => 'Зиндагиномаи шумо дар саҳифаи корбариатон ҳамчун мӯҳтавои пешфарз ҷой дода хоҳад шуд.
Барои қарор додани ягон ихтиёроти худ кӯшиш кунед.
Мутмаин бошед, ки шумо барои мунташир кардани ин намуд иттилоот роҳатӣ ҳастед.
Номи шумо метавонад тариқи [[Special:Preferences]] тағйир дода шавад.',
	'requestaccount-real'             => 'Номи аслӣ:',
	'requestaccount-same'             => '(монанди номи аслӣ)',
	'requestaccount-email'            => 'Нишонаи почтаи электронӣ:',
	'requestaccount-reqtype'          => 'Вазифа:',
	'requestaccount-level-0'          => 'муаллиф',
	'requestaccount-level-1'          => 'вироишгар',
	'requestaccount-bio'              => 'Зиндагиномаи шахсӣ:',
	'requestaccount-notes'            => 'Эзоҳоти иловагӣ:',
	'requestaccount-urls'             => 'Феҳристи сомонаҳо, агар зиёд бошад (бо сатрҳои ҷадид ҷудо кунед):',
	'requestaccount-agree'            => 'Шумо бояд тасдиқ кунед ки номи аслии шумо дуруст аст ва шумо бо Шартҳои Хидмати мо розӣ ҳастед.',
	'requestaccount-inuse'            => 'Номи корбарӣ аллакай дар истифодаи дархости ҳисоби дар тайбуда аст.',
	'requestaccount-tooshort'         => 'Зиндагиномаи шумо бояд ҳадди ақал $1 дароз бошад.',
	'requestaccount-emaildup'         => 'Дигар дархости ҳисоби дар тайбуда ҳамин нишонии почтаи электрониро истифода мебарад.',
	'requestaccount-exts'             => 'Навъи замимавии парванда норавост.',
	'requestaccount-tos'              => 'Ман [[{{MediaWiki:Requestaccount-page}}|Шартҳои Хидмати]] дар {{SITENAME}} бударо хондам ва бо онҳо вафодор ҳастам.
Номи мушаххаскардаи ман зери "Номи Аслӣ" дар ҳақиқат номи аслии худи ман аст.',
	'requestaccount-submit'           => 'Дархости ҳисоб',
	'requestaccount-sent'             => 'Дархост шумо бо муваффақият фиристода шуд ва ҳамакнун дар тайи баррасӣ аст.',
	'request-account-econf'           => 'Нишонаи почтаи электронии шумо тасдиқ шуд ва ҳамин тавр дар дархости ҳисоби шумо феҳрист хоҳад шуд.',
	'requestaccount-email-subj'       => '{{SITENAME}} тасдиқи нишонаи почтаи электронӣ',
	'requestaccount-email-body'       => 'Шахсе, эҳтимолан шумо аз нишонаи IP $1, ҳисоби "$2" бо нишонаи почтаи электронӣ дар {{SITENAME}} дархост кард.

Барои тасдиқ, ки ин ҳисоб дар ҳақиқат ба шумо дар {{SITENAME}} таалуқ дорад, ин пайвандро дар мурургаратон боз кунед:

$3

Агар ҳисоб эҷод шуда бошад, танҳо ба шумо калимаи убур тариқи почтаи электронӣ фиристода хоҳад шуд.
Агар ин шумо *нест*, пайвандро дунбол накунед.
Ин коди тасдиқ дар $4 ба хотима хоҳад расид.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} дархости ҳисоб',
	'requestaccount-email-body-admin' => '"$1" ҳисоберо дархост кард ва мунтазири тасдиқи он мебошад.
Нишонаи почтаи электронӣ тасдиқ шуд. Шумо дархостро метавонед инҷо "$2" тасдиқ кунед.',
	'acct_request_throttle_hit'       => 'Бубахшед, шумо аллакай $1 ҳисобҳо дархост кардед.
Шумо наметавонед аз ин зиёд дархост кунед.',
	'requestaccount-loginnotice'      => "Барои дастрас кардани ҳисоби корбарӣ, шумо бояд '''[[Special:RequestAccount|дархост]]''' кунед.",
	'confirmaccounts'                 => 'Дархостҳои ҳисобҳоро тасдиқ кунед',
	'confirmaccount-list'             => 'Дар зер феҳристи дархостҳои ҳисобҳои мунтазири тасдиқ оварда шудааст.
Дар ҳолати тасдиқ кардан ва ё рад кардани дархост, он аз ин феҳрист пок кардан хоҳад шуд.',
	'confirmaccount-real-q'           => 'Ном',
	'confirmaccount-email-q'          => 'Почтаи электронӣ',
	'confirmaccount-bio-q'            => 'Зиндагинома',
	'confirmaccount-showopen'         => 'дархостҳои кушод',
	'confirmaccount-showrej'          => 'дархостҳои радшуда',
	'confirmaccount-review'           => 'Пешнамоиш',
	'confirmaccount-q-open'           => 'дархостҳои кушод',
	'confirmaccount-leg-user'         => 'Ҳисоби корбарӣ',
	'confirmaccount-leg-person'       => 'Иттилооти шахсӣ',
	'confirmaccount-leg-other'        => 'Иттилооти дигар',
	'confirmaccount-name'             => 'Номи корбарӣ',
	'confirmaccount-real'             => 'Ном:',
	'confirmaccount-email'            => 'Почтаи электронӣ:',
	'confirmaccount-reqtype'          => 'Вазифа:',
	'confirmaccount-pos-0'            => 'муаллиф',
	'confirmaccount-pos-1'            => 'вироишгар',
	'confirmaccount-bio'              => 'Зиндагинома:',
	'confirmaccount-notes'            => 'Эзоҳоти иловагӣ:',
	'confirmaccount-urls'             => 'Феҳристи сомонаҳо:',
	'confirmaccount-none-p'           => '(пешниҳод нашудааст)',
	'confirmaccount-econf'            => '(таъйидшуда)',
	'confirmaccount-noreason'         => '(ҳеҷ)',
	'confirmaccount-create'           => 'Қабул (эҷоди ҳисоб)',
	'confirmaccount-deny'             => 'Рад (аз феҳрист гирифтан)',
	'confirmaccount-hold'             => 'Нигоҳ доштан',
	'confirmaccount-spam'             => 'Ҳаразнома (почтаи электронӣ нафиристед)',
	'confirmaccount-reason'           => 'Тавзеҳ (дар паёми электронӣ илова хоҳад шуд):',
	'confirmaccount-ip'               => 'Нишонаи IP:',
	'confirmaccount-submit'           => 'Таъйид',
	'confirmaccount-needreason'       => 'Шумо бояд далел дар ҷаъбаи тавзеҳ дар зер пешкаш намоед.',
	'confirmaccount-canthold'         => 'Ин дархост аллакай ё нигоҳ дошта шудааст ё ҳазф шудааст.',
	'confirmaccount-acc'              => 'Дархости ҳисоб бо муваффақият тасдиқ карда шуд; ҳисоби корбарии ҷадидӣ [[User:$1]] эҷод шуд.',
	'confirmaccount-rej'              => 'Дархости ҳисоб бо муваффақият рад карда шуд.',
	'confirmaccount-viewing'          => '(ҳоло дар ҳоли дидан аст тавассути [[User:$1|$1]])',
	'confirmaccount-summary'          => 'Дар ҳоли эҷоди саҳифаи корбарӣ бо зиндагиномаи корбари ҷадид.',
	'confirmaccount-welc'             => "'''Хуш омадед ба ''{{SITENAME}}''!''' Мо умедворем, ки шумо бисёр ва хуб ҳиссагузорӣ хоҳед кард.  
Шумо эҳтимолан мехоҳед [[{{MediaWiki:Helppage}}|саҳифаҳои роҳнаморо]] бихонед. Бори дигар, хуш омадед ва шод бошед!",
	'confirmaccount-wsum'             => 'Хуш омадед!',
	'confirmaccount-email-subj'       => '{{SITENAME}} дархости корбар',
	'confirmaccount-email-body'       => 'Дархости шумо барои ҳисобе дар {{SITENAME}} тасдиқ шуд.

Номи ҳисоб: $1

Гузарвожа: $2

Аз сабабҳои амниятӣ, шумо бояд дар вурудшваии аввалин гузарвожаи худро тағйир диҳед.
Барои вуруд шудан, лутфан равед ба {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body2'      => 'Дархости шумо барои ҳисобе дар {{SITENAME}} тасдиқ шуд.

Номи ҳисоб: $1

Гузарвожа: $2

$3

Аз сабабҳои амниятӣ, шумо бояд дар вурудшваии аввалин гузарвожаи худро тағйир диҳед.
Барои вуруд шудан, лутфан равед ба {{fullurl:Special:Userlogin}}.',
	'confirmaccount-email-body3'      => 'Бубахшед, дархости шумо барои ҳисоби "$1" дар {{SITENAME}} рад шуд.

Чанд сабабҳое ҳастанд ки боиси рад шудан мешаванд.
Шумо шояд формро дуруст пур накардаед, посухи шумо аз рӯи талабот тӯлонӣ набуд, ё ба меъёри талаботи сиёсати ҷавобгӯ набуд.
Дар сомона феҳристи тамос мумкин оварда шуда бошад, ки тариқи он шумо метавонед маълумоти бештар оиди сиёсати ҳисоби корбарӣ дастрас намоед.',
	'confirmaccount-email-body4'      => 'Бубахшед, дархости шумо барои ҳисоби "$1" дар {{SITENAME}} рад шуд.

$2

Дар сомона феҳристи тамос мумкин оварда шуда бошад, ки тариқи он шумо метавонед маълумоти бештар оиди сиёсати ҳисоби корбарӣ дастрас намоед.',
	'confirmaccount-email-body5'      => 'Қабл аз қабул кардани дархости шумо барои ҳисоби "$1" дар {{SITENAME}} шумо бояд аввал чанд иттилооти иловагиро пешкаш кунед.

$2

Дар сомона феҳристи тамос мумкин оварда шуда бошад, ки тариқи он шумо метавонед маълумоти бештар оиди сиёсати ҳисоби корбарӣ дастрас намоед.',
	'usercredentials'                 => 'Ихтиёроти корбар',
	'usercredentials-user'            => 'Номи корбарӣ:',
	'usercredentials-leg-user'        => 'Ҳисоби корбарӣ',
	'usercredentials-leg-person'      => 'Иттилооти шахсӣ',
	'usercredentials-leg-other'       => 'Иттилооти дигар',
	'usercredentials-email'           => 'Почтаи электронӣ:',
	'usercredentials-real'            => 'Номи аслӣ:',
	'usercredentials-bio'             => 'Зиндагинома:',
	'usercredentials-notes'           => 'Эзоҳоти иловагӣ:',
	'usercredentials-urls'            => 'Феҳристи сомонаҳо:',
	'usercredentials-ip'              => 'Нишонаи IP-и аслӣ:',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'confirmaccount-email-body2' => 'การเรียกร้องของคุณสำหรับบัญชีผู้ใช้ใหม่ได้รับการยอมรับบน {{SITENAME}}

ชื่อบัญชีผู้ใช้: $1

รหัสผ่าน: $2

$3

สำหรับเหตุผลทางความปลอดภัยคุณจะต้องเปลี่ยนรหัสผ่านของคุณหลังจากที่ล็อกอินครั้งแรก
กรุณาไปที่ {{fullurl:Special:Userlogin}} เพื่อล็อกอิน',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Suelnur
 */
$messages['tr'] = array(
	'requestaccount-email'    => 'E-posta adresi:',
	'confirmaccount-email-q'  => 'E-posta',
	'confirmaccount-name'     => 'Kullanıcı adı',
	'confirmaccount-email'    => 'E-posta:',
	'confirmaccount-noreason' => '(hiçbiri)',
	'confirmaccount-ip'       => 'IP adresi:',
	'confirmaccount-wsum'     => 'Hoşgeldiniz!',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author AS
 */
$messages['uk'] = array(
	'requestaccount'           => 'Запит облікового запису',
	'requestaccount-text'      => "'''Заповніть та відправте наступну форму запиту облікового запису'''.

Будь ласка, спершу прочитайте [[{{MediaWiki:Requestaccount-page}}|Умови надання послуг]].

Після того, як обліковий запис буде підтверджено, вас буде повідомлено про це електронною поштою і ви зможете [[Special:Userlogin|ввійти до системи]].",
	'requestaccount-page'      => '{{ns:project}}:Умови надання послуг',
	'requestaccount-dup'       => "'''Примітка: Ви вже ввійшли в систему із зареєстрованого облікового запису.'''",
	'requestaccount-leg-user'  => 'Обліковий запис',
	'requestaccount-leg-areas' => 'Головні області зацікавлень',
	'requestaccount-level-0'   => 'автор',
	'requestaccount-level-1'   => 'редактор',
	'confirmaccount-name'      => "Ім'я користувача",
	'confirmaccount-real'      => "Ім'я:",
	'confirmaccount-email'     => 'Електронна адреса:',
	'confirmaccount-reqtype'   => 'Посада:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'confirmedit-desc' => 'Permete ai burocrati de confermar le richieste de account',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'requestaccount'             => 'Xin tài khoản',
	'requestaccount-page'        => '{{ns:project}}:Điều kiện dịch vụ',
	'requestaccount-leg-user'    => 'Tài khoản',
	'requestaccount-leg-person'  => 'Thông tin cá nhân',
	'requestaccount-leg-other'   => 'Thông tin khác',
	'requestaccount-level-0'     => 'tác giả',
	'requestaccount-notes'       => 'Chi tiết:',
	'requestaccount-submit'      => 'Xin tài khoản',
	'confirmaccount-bio-q'       => 'Tiểu sử',
	'confirmaccount-leg-user'    => 'Tài khoản',
	'confirmaccount-leg-person'  => 'Thông tin cá nhân',
	'confirmaccount-leg-other'   => 'Thông tin khác',
	'confirmaccount-name'        => 'Tên người dùng',
	'confirmaccount-pos-0'       => 'tác giả',
	'confirmaccount-bio'         => 'Tiểu sử:',
	'confirmaccount-notes'       => 'Chi tiết:',
	'confirmaccount-noreason'    => '(không có)',
	'usercredentials-user'       => 'Tên người dùng:',
	'usercredentials-leg-user'   => 'Tài khoản',
	'usercredentials-leg-person' => 'Thông tin cá nhân',
	'usercredentials-leg-other'  => 'Thông tin khác',
	'usercredentials-bio'        => 'Tiểu sử:',
	'usercredentials-notes'      => 'Chi tiết:',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'requestaccount'            => 'Begön kali',
	'requestaccount-real'       => 'Nem jenöfik:',
	'requestaccount-level-0'    => 'lautan',
	'requestaccount-submit'     => 'Begön kali',
	'confirmaccount-real-q'     => 'Nem',
	'confirmaccount-bio-q'      => 'Lifajenäd',
	'confirmaccount-name'       => 'Gebananem',
	'confirmaccount-real'       => 'Nem:',
	'confirmaccount-pos-0'      => 'lautan',
	'confirmaccount-noreason'   => '(nonik)',
	'confirmaccount-wsum'       => 'Benokömö!',
	'confirmaccount-email-subj' => 'Beg kala ela {{SITENAME}}',
	'usercredentials-user'      => 'Gebananem:',
	'usercredentials-real'      => 'Nem jenöfik:',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'requestaccount'             => '請求戶口',
	'requestaccount-text'        => "'''完成並遞交下面嘅表格去請求一個用戶戶口'''。 
	
	請確認你響請求一個戶口之前，先讀過[[{{MediaWiki:Requestaccount-page}}|服務細則]]。
	
	一旦個戶口批准咗，你將會收到一個電郵通知訊息，噉個戶口就可以響[[Special:Userlogin]]度用。",
	'requestaccount-dup'         => "'''留意: 你已經登入咗做一個已經註冊咗嘅戶口。'''",
	'requestaccount-acc-text'    => '當完成請求時，一封確認訊息會發到你嘅電郵地址。
	請響封電郵度撳個確認連結去回應佢。同時，當你個戶口開咗之後，你戶口個密碼將會電郵畀你。',
	'requestaccount-ext-text'    => '下面嘅資料會保密，而且只係會用響呢次請求度。 
	你可能需要列示聯絡資料，好似電話號碼等去幫手證明你嘅確認。',
	'requestaccount-bio-text'    => '你嘅傳記將會設定做響你用戶頁度嘅預設內容。試吓包含任何嘅憑據。
	而且你係肯定你係可以發佈呢啲資料。你嘅名可以透過[[Special:Preferences]]改到。',
	'requestaccount-real'        => '真名:',
	'requestaccount-same'        => '(同真名一樣)',
	'requestaccount-email'       => '電郵地址:',
	'requestaccount-bio'         => '個人傳記:',
	'requestaccount-notes'       => '附加註解:',
	'requestaccount-urls'        => '網站一覽，如有者 (用新行分開):',
	'requestaccount-agree'       => '你一定要證明到你個真名係啱嘅，而且你同意我哋嘅服務細則。',
	'requestaccount-inuse'       => '個用戶名已經用來請求緊個戶口。',
	'requestaccount-tooshort'    => '你嘅傳記一定要最少有$1個字長。',
	'requestaccount-tos'         => '我已經讀咗同埋同意持續遵守{{SITENAME}}嘅服務細則。',
	'requestaccount-submit'      => '請求戶口',
	'requestaccount-sent'        => '你個戶口請求已經成功發出，現正等候複審。',
	'request-account-econf'      => '你嘅電郵地址已經確認，將會響你嘅戶口請求度列示。',
	'requestaccount-email-subj'  => '{{SITENAME}}電郵地址確認',
	'requestaccount-email-body'  => '有人，可能係你，由IP地址$1，響{{SITENAME}}度用呢個電郵地址請求一個叫做"$2"嘅戶口。

去確認呢個戶口真係屬於響{{SITENAME}}上面嘅你，就響你嘅瀏覽器度開呢個連結:

$3

如果個戶口開咗，只有你先至會收到個電郵密碼。如果呢個戶口*唔係*你嘅話，唔好撳個連結。 
呢個確認碼將會響$4過期。',
	'acct_request_throttle_hit'  => '對唔住，你已經請求咗$1個戶口。你唔可以請求更多個戶口。',
	'requestaccount-loginnotice' => "要拎一個用戶戶口，你一定要'''[[Special:RequestAccount|請求一個]]'''。",
	'confirmaccounts'            => '確認戶口請求',
	'confirmaccount-list'        => '下面係等緊批准嘅用戶請求一覽。 
	已經批准嘅戶口將會建立同埋響呢個表度拎走。拒絕咗嘅用戶將會就噉響呢個表度拎走。',
	'confirmaccount-list2'       => '下面係一個先前拒絕過嘅戶口請求，可能會響幾日之後刪除。
	佢哋仍舊可以批准去開一個戶口，但係響你做之前請問吓拒絕嘅管理員先。',
	'confirmaccount-text'        => "呢個係響'''{{SITENAME}}'''度等候請求戶口嘅一版。
	請小心去睇過，有需要嘅話，就要確認埋佢下面全部嘅資料。
	要留意嘅係你可以用另一個用戶名去開一個戶口。只係同其他嘅名有衝突嗰陣先至去做。
	
	如果你無確認或者拒絕呢個請求，就噉留低呢版嘅話，佢就會維持等候狀態。",
	'confirmaccount-review'      => '批准/拒絕',
	'confirmaccount-badid'       => '提供嘅ID係無未決定嘅請求。佢可能已經被處理咗。',
	'confirmaccount-name'        => '用戶名',
	'confirmaccount-real'        => '名',
	'confirmaccount-email'       => '電郵',
	'confirmaccount-bio'         => '傳記',
	'confirmaccount-urls'        => '網站一覽:',
	'confirmaccount-confirm'     => '用下面嘅掣去批准或拒絕呢個請求。',
	'confirmaccount-econf'       => '(已批准)',
	'confirmaccount-reject'      => '(響$2被[[User:$1|$1]]拒絕)',
	'confirmaccount-create'      => '接受 (開戶口)',
	'confirmaccount-deny'        => '拒絕 (反列示)',
	'confirmaccount-reason'      => '註解 (會用響封電郵度):',
	'confirmaccount-submit'      => '確認',
	'confirmaccount-acc'         => '戶口請求已經成功噉確認；開咗一個新嘅用戶戶口[[User:$1]]。',
	'confirmaccount-rej'         => '戶口請求已經成功噉拒絕。',
	'confirmaccount-summary'     => '開緊一個新用戶擁有傳記嘅用戶頁。',
	'confirmaccount-welc'        => "'''歡迎來到''{{SITENAME}}''！'''我哋希望你會作出更多更好的貢獻。 
	你可能會去睇吓[[{{MediaWiki:Helppage}}|開始]]。再一次歡迎你！ 
	~~~~",
	'confirmaccount-wsum'        => '歡迎！',
	'confirmaccount-email-subj'  => '{{SITENAME}}戶口請求',
	'confirmaccount-email-body'  => '你請求嘅戶口已經響{{SITENAME}}度批准咗。

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
	'requestaccount'             => '请求账户',
	'requestaccount-text'        => "'''完成并递交以下的表格去请求一个用户账户'''。 
	
	请确认您在请求一个账户之前，先读过[[{{MediaWiki:Requestaccount-page}}|服务细则]]。
	
	一旦该账户获得批准，您将会收到一个电邮通知信息，该账户就可以在[[Special:Userlogin]]中使用。",
	'requestaccount-dup'         => "'''注意: 您已经登入成一个已注册的账户。'''",
	'requestaccount-acc-text'    => '当完成请求时，一封确认信息会发到您的电邮地址。
	请在该封电邮中点击确认连结去反应它。同时，当您的账户被创建后，您账户的个密码将会电邮给您。',
	'requestaccount-ext-text'    => '以下的资料将会保密，而且只是会用在这次请求中。 
	您可能需要列示联络资料，像电话号码等去帮助证明您的确认。',
	'requestaccount-bio-text'    => '您传记将会设置成在您用户页中的预设内容。尝试包含任何的凭据。
	而且你是肯定您是可以发布这些资料。您的名字可以通过[[Special:Preferences]]更改。',
	'requestaccount-real'        => '真实名字:',
	'requestaccount-same'        => '(同真实名字)',
	'requestaccount-email'       => '电邮地址:',
	'requestaccount-bio'         => '个人传记:',
	'requestaccount-notes'       => '附加注解:',
	'requestaccount-urls'        => '网站列表，如有者 (以新行分开):',
	'requestaccount-agree'       => '您一定要证明到您的真实名字是正确的，而且您同意我们的服务细则。',
	'requestaccount-inuse'       => '该用户名已经用来请求账户。',
	'requestaccount-tooshort'    => '您的传记必须最少有$1个字的长度。',
	'requestaccount-tos'         => '我已经阅读以及同意持续遵守{{SITENAME}}的服务细则。',
	'requestaccount-submit'      => '请求账户',
	'requestaccount-sent'        => '您的账户请求已经成功发出，现正等候复审。',
	'request-account-econf'      => '您的电邮地址已经确认，将会在您的账户口请求中列示。',
	'requestaccount-email-subj'  => '{{SITENAME}}电邮地址确认',
	'requestaccount-email-body'  => '有人，可能是您，由IP地址$1，在{{SITENAME}}中用这个电邮地址请求一个名叫"$2"的账户。

要确认这个户口真的属于在{{SITENAME}}上面?您，就在您的浏览器中度开启这个连结:

$3

如果该账户已经创建，只有您才会收到该电邮密码。如果这个账户*不是*属于您的话，不要点击这个连结。 
呢个确认码将会响$4过期。',
	'acct_request_throttle_hit'  => '抱歉，您已经请求了$1个户口。您不可以请求更多个账户。',
	'requestaccount-loginnotice' => "要取得个用户账户，您一定要'''[[Special:RequestAccount|请求一个]]'''。",
	'confirmaccounts'            => '确认户口请求',
	'confirmaccount-list'        => '以下是正在等候批准的用户请求列表。 
	已经批准的账户将会创建以及在这个列表中移除。已拒绝的用户将只会在这个表中移除。',
	'confirmaccount-list2'       => '以下是一个先前拒绝过的帐口请求，可能会在数日后删除。
	它们仍旧可以批准创建一个账户，但是在您作之前请先问拒绝该账户的管理员。',
	'confirmaccount-text'        => "这个是在'''{{SITENAME}}'''中等候请求账户的页面。
	请小心阅读，有需要的话，就要同时确认它下面的全部资料。
	要留意的是您可以用另一个用户名字去创建一个账户。只有其他的名字有冲突时才需要去作。
	
	如果你无确认或者拒绝这个请求，只留下这页面的话，它便会维持等候状态。",
	'confirmaccount-review'      => '批准/拒绝',
	'confirmaccount-badid'       => '提供的ID是没有未决定的请求。它可能已经被处理。',
	'confirmaccount-name'        => '用户名字',
	'confirmaccount-real'        => '名字',
	'confirmaccount-email'       => '电邮',
	'confirmaccount-bio'         => '传记',
	'confirmaccount-urls'        => '网站列表:',
	'confirmaccount-confirm'     => '用以下的按钮去批准或拒绝这个请求。',
	'confirmaccount-econf'       => '(已批准)',
	'confirmaccount-reject'      => '(于$2被[[User:$1|$1]]拒绝)',
	'confirmaccount-create'      => '接受 (创建账户)',
	'confirmaccount-deny'        => '拒绝 (反列示)',
	'confirmaccount-reason'      => '注解 (在电邮中使用):',
	'confirmaccount-submit'      => '确认',
	'confirmaccount-acc'         => '账户请求已经成功确认；已经创建一个新的用户帐号[[User:$1]]。',
	'confirmaccount-rej'         => '账户请求已经成功拒绝。',
	'confirmaccount-summary'     => '正在创建一个新用户拥有传记的用户页面。',
	'confirmaccount-welc'        => "'''欢迎来到''{{SITENAME}}''！'''我们希望您会作出更多更好的贡献。 
	您可能会去参看[[{{MediaWiki:Helppage}}|开始]]。再一次欢迎你！ 
	~~~~",
	'confirmaccount-wsum'        => '欢迎！',
	'confirmaccount-email-subj'  => '{{SITENAME}}账户请求',
	'confirmaccount-email-body'  => '您请求的账户已经在{{SITENAME}}中批准。

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
	'requestaccount'             => '請求帳戶',
	'requestaccount-text'        => "'''完成並遞交以下的表格去請求一個用戶帳戶'''。 
	
	請確認您在請求一個帳戶之前，先讀過[[{{MediaWiki:Requestaccount-page}}|服務細則]]。
	
	一旦該帳戶獲得批准，您將會收到一個電郵通知訊息，該帳戶就可以在[[Special:Userlogin]]中使用。",
	'requestaccount-dup'         => "'''注意: 您已經登入成一個已註冊的帳戶。'''",
	'requestaccount-acc-text'    => '當完成請求時，一封確認訊息會發到您的電郵地址。
	請在該封電郵中點擊確認連結去回應它。同時，當您的帳戶被創建後，您帳戶的個密碼將會電郵給您。',
	'requestaccount-ext-text'    => '以下的資料將會保密，而且只是會用在這次請求中。 
	您可能需要列示聯絡資料，像電話號碼等去幫助證明您的確認。',
	'requestaccount-bio-text'    => '您傳記將會設定成在您用戶頁中的預設內容。嘗試包含任何的憑據。
	而且你是肯定您是可以發佈這些資料。您的名字可以透過[[Special:Preferences]]更改。',
	'requestaccount-real'        => '真實名字:',
	'requestaccount-same'        => '(同真實名字)',
	'requestaccount-email'       => '電郵地址:',
	'requestaccount-bio'         => '個人傳記:',
	'requestaccount-notes'       => '附加註解:',
	'requestaccount-urls'        => '網站列表，如有者 (以新行分開):',
	'requestaccount-agree'       => '您一定要證明到您的真實名字是正確的，而且您同意我們的服務細則。',
	'requestaccount-inuse'       => '該用戶名已經用來請求帳戶。',
	'requestaccount-tooshort'    => '您的傳記必須最少有$1個字的長度。',
	'requestaccount-tos'         => '我已經閱讀以及同意持續遵守{{SITENAME}}的服務細則。',
	'requestaccount-submit'      => '請求帳戶',
	'requestaccount-sent'        => '您的帳戶請求已經成功發出，現正等候複審。',
	'request-account-econf'      => '您的電郵地址已經確認，將會在您的帳戶口請求中列示。',
	'requestaccount-email-subj'  => '{{SITENAME}}電郵地址確認',
	'requestaccount-email-body'  => '有人，可能是您，由IP地址$1，在{{SITENAME}}中用這個電郵地址請求一個名叫"$2"的帳戶。

要確認這個戶口真的屬於在{{SITENAME}}上面嘅您，就在您的瀏覽器中度開啟這個連結:

$3

如果該帳戶已經創建，只有您才會收到該電郵密碼。如果這個帳戶*不是*屬於您的話，不要點擊這個連結。 
呢個確認碼將會響$4過期。',
	'acct_request_throttle_hit'  => '抱歉，您已經請求了$1個戶口。您不可以請求更多個帳戶。',
	'requestaccount-loginnotice' => "要取得個用戶帳戶，您一定要'''[[Special:RequestAccount|請求一個]]'''。",
	'confirmaccounts'            => '確認戶口請求',
	'confirmaccount-list'        => '以下是正在等候批准的用戶請求列表。 
	已經批准的帳戶將會創建以及在這個列表中移除。已拒絕的用戶將只會在這個表中移除。',
	'confirmaccount-list2'       => '以下是一個先前拒絕過的帳口請求，可能會在數日後刪除。
	它們仍舊可以批准創建一個帳戶，但是在您作之前請先問拒絕該帳戶的管理員。',
	'confirmaccount-text'        => "這個是在'''{{SITENAME}}'''中等候請求帳戶的頁面。
	請小心閱讀，有需要的話，就要同時確認它下面的全部資料。
	要留意的是您可以用另一個用戶名字去創建一個帳戶。只有其他的名字有衝突時才需要去作。
	
	如果你無確認或者拒絕這個請求，只留下這頁面的話，它便會維持等候狀態。",
	'confirmaccount-review'      => '批准/拒絕',
	'confirmaccount-badid'       => '提供的ID是沒有未決定的請求。它可能已經被處理。',
	'confirmaccount-name'        => '用戶名字',
	'confirmaccount-real'        => '名字',
	'confirmaccount-email'       => '電郵',
	'confirmaccount-bio'         => '傳記',
	'confirmaccount-urls'        => '網站列表:',
	'confirmaccount-confirm'     => '用以下的按鈕去批准或拒絕這個請求。',
	'confirmaccount-econf'       => '(已批准)',
	'confirmaccount-reject'      => '(於$2被[[User:$1|$1]]拒絕)',
	'confirmaccount-create'      => '接受 (創建帳戶)',
	'confirmaccount-deny'        => '拒絕 (反列示)',
	'confirmaccount-reason'      => '註解 (在電郵中使用):',
	'confirmaccount-submit'      => '確認',
	'confirmaccount-acc'         => '帳戶請求已經成功確認；已經創建一個新的用戶帳號[[User:$1]]。',
	'confirmaccount-rej'         => '帳戶請求已經成功拒絕。',
	'confirmaccount-summary'     => '正在創建一個新用戶擁有傳記的用戶頁面。',
	'confirmaccount-welc'        => "'''歡迎來到''{{SITENAME}}''！'''我們希望您會作出更多更好嘅貢獻。 
	您可能會去參看[[{{MediaWiki:Helppage}}|開始]]。再一次歡迎你！ 
	~~~~",
	'confirmaccount-wsum'        => '歡迎！',
	'confirmaccount-email-subj'  => '{{SITENAME}}帳戶請求',
	'confirmaccount-email-body'  => '您請求的帳戶已經在{{SITENAME}}中批准。

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

