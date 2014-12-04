<?php
/**
 * Internationalisation file for RequestAccount special page.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
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
	'requestaccount-areas' 		=> '', # Do not translate this message to other languages
	'requestaccount-areas-text' => 'Select the topic areas below in which you have formal expertise or would like to do the most work in.',
	'requestaccount-ext-text'   => 'The following information is kept private and will only be used for this request.
You may want to list contacts such a phone number to aid in identify confirmation.',
	'requestaccount-bio-text'   => "Try to include any relevant credentials in your biography below.",
	'requestaccount-bio-text-i' => "'''Your biography will be set as the initial content for your userpage.'''
Make sure you are comfortable publishing such information.",
	'requestaccount-real'       => 'Real name:',
	'requestaccount-same'       => '(same as real name below)',
	'requestaccount-email'      => 'E-mail address:',
	'requestaccount-reqtype'    => 'Position:',
	'requestaccount-level-0'    => 'author',
	'requestaccount-level-1'    => 'editor',
	'requestaccount-info'       => '(?)',
	'requestaccount-bio'        => 'Personal biography (plain text only):',
	'requestaccount-attach'     => 'Resume or CV (optional):',
	'requestaccount-notes'      => 'Additional notes:',
	'requestaccount-urls'       => 'List of websites, if any (each on a separate line):',
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
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Lejonel
 * @author McDutchie
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'requestaccount' => '{{Identical|Request account}}',
	'requestaccount-footer' => '{{optional}}',
	'requestaccount-leg-user' => '{{Identical|User account}}',
	'requestaccount-leg-areas' => '{{Identical|Main areas of interest}}',
	'requestaccount-leg-person' => '{{Identical|Personal information}}',
	'requestaccount-leg-other' => '{{Identical|Other information}}',
	'requestaccount-real' => 'When changing this message, please make sure to change {{msg-mw|requestaccount-tos|notext=yes}} too, which directly references to this message.
{{Identical|Real name}}',
	'requestaccount-email' => '{{Identical|E-mail address}}',
	'requestaccount-reqtype' => '{{Identical|Position}}',
	'requestaccount-level-0' => '{{Identical|Author}}',
	'requestaccount-level-1' => '{{Identical|Editor}}',
	'requestaccount-info' => '{{optional}}',
	'requestaccount-notes' => '{{Identical|Additional notes}}',
	'requestaccount-tos' => '"Real name" should be exactly as {{msg-mw|requestaccount-real}}, minus the colon.',
	'requestaccount-submit' => '{{Identical|Request account}}',
	'requestaccount-email-subj' => '{{Identical|SITENAME e-mail address confirmation}}',
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
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'requestaccount' => 'Kërkesë llogari',
	'requestaccount-text' => "'''E plota dhe të dorëzojë formularin e mëposhtëm për të kërkuar një llogari përdoruesi'''.

Sigurohuni që e keni parë lexuar [[{{MediaWiki:Requestaccount-page}}|Kushtet e Shërbimit]] para se të kërkojnë një llogari.

Pasi llogari është aprovuar, ju do të jetë e-mail një mesazh njoftim dhe llogari do të jetë i përdorshëm në [[Special:UserLogin|login]].",
	'requestaccount-page' => '{{ns:project}}: Terms of Service',
	'requestaccount-dup' => "'''Shënim: Ju tashmë jeni i regjistruar me një llogari të regjistruar.'''",
	'requestaccount-leg-user' => 'Profili i përdoruesit',
	'requestaccount-leg-areas' => 'fushat kryesore të interesit',
	'requestaccount-leg-person' => 'Të dhënat personale',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'requestaccount-email' => 'የኢ-ሜል አድራሻ:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'requestaccount-level-1' => 'editor',
);

/** Arabic (العربية)
 * @author Ciphers
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
	'requestaccount-bio-text' => 'حاول تضمين أي شهادات متعلقة في سيرتك الذاتية بالأسفل.',
	'requestaccount-bio-text-i' => "''' سيتم تعيين السيرة الذاتية الخاصة بك كمحتوى مبدئي لصفحة المستخدم الخاصة بك.''' رجاء الانتباه إلى أنك لا تمانع من نشر معلومات من هذا القبيل.",
	'requestaccount-real' => 'الاسم الحقيقي:',
	'requestaccount-same' => '(مثل الاسم الحقيقي)',
	'requestaccount-email' => 'عنوان البريد الإلكتروني:',
	'requestaccount-reqtype' => 'الموضع:',
	'requestaccount-level-0' => 'مؤلف',
	'requestaccount-level-1' => 'محرر',
	'requestaccount-info' => '(؟)',
	'requestaccount-bio' => 'السيرة الشخصية (نص بحت فقط):',
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
	'requestaccount-email' => 'ܦܪܫܓܢܐ ܕܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ:',
	'requestaccount-level-0' => 'ܣܝܘܡܐ',
	'requestaccount-level-1' => 'ܫܚܠܦܢܐ',
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
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'requestaccount-real' => 'Həqiqi adınız:',
	'requestaccount-email' => 'E-poçt ünvanı',
	'requestaccount-reqtype' => 'Mövqe:',
	'requestaccount-level-0' => 'müəllif',
	'requestaccount-level-1' => 'redaktor',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'requestaccount-real' => 'Totoong pangaran:',
	'requestaccount-same' => '(pareho sa  totoong pangaran)',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'requestaccount-level-0' => 'аўтар',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Zedlik
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
	'requestaccount-bio-text' => 'Паспрабуйце уключыць любыя адпаведныя ступені ў Вашай біяграфіі ніжэй.',
	'requestaccount-bio-text-i' => "'''Вашая біяграфія будзе разьмешчаная на Вашай старонцы ўдзельніка.'''
Упэўніцеся, што Вы ня супраць апублікаваньня падобнай інфармацыі.",
	'requestaccount-real' => 'Сапраўднае імя:',
	'requestaccount-same' => '(такое ж як і сапраўднае імя)',
	'requestaccount-email' => 'Адрас электроннай пошты:',
	'requestaccount-reqtype' => 'Пасада:',
	'requestaccount-level-0' => 'аўтар',
	'requestaccount-level-1' => 'рэдактар',
	'requestaccount-bio' => 'Асабістая біяграфія (толькі звычайны тэкст):',
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
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Ehsanulhb
 * @author Wikitanvir
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
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'requestaccount' => 'Goulenn ur gont implijer',
	'requestaccount-text' => "'''Leugnit hag adkasit ar furmskird a-is evit goulenn ur gont implijer'''.

Ho pet sur da vezañ lennet mat [[{{MediaWiki:Requestaccount-page}}|Termenoù ar servij]] da gentañ a-raok goulenn krouiñ ur gont.

Ur wezh aprouet ar gont e vo kaset deoc'h ur gemennadenn der bostel hag e c'hallot implijout ho kont war [[Special:UserLogin|ar bajenn gevreañ]].",
	'requestaccount-page' => '{{ns:project}}: Amplegadoù implijout',
	'requestaccount-dup' => "'''Notenn : Kevreet oc'h dija gant ur gont marilhet.'''",
	'requestaccount-leg-user' => 'Kont implijer',
	'requestaccount-leg-areas' => 'Diduadennoù pennañ',
	'requestaccount-leg-person' => 'Titouroù personel',
	'requestaccount-leg-other' => 'Titouroù all',
	'requestaccount-leg-tos' => 'Divizoù servij',
	'requestaccount-acc-text' => "Kaset e vo ur c'hemenn kadarnaat d'ho chomlec'h postel kerkent ha ma vo bet kaset ar goulenn.
Respontit d'ar c'hemenn en ur glikañ war al liamm kadarnaat a gavot er postel.
Kaset e vo deoc'h ho ker-tremen dre bostel ivez pa vo bet krouet ho kont ganeoc'h.",
	'requestaccount-areas-text' => "Dibabit an tachennoù ma'z oc'h barrek da vat, pe ar re ma'z oc'h tuet da gemer perzh ar muiañ.",
	'requestaccount-ext-text' => "Prevez e chomo an titour da-heul ha n'hallo bezañ implijet nemet evit ar reked-mañ.
Gallout a rit rollañ darempredoù evel an niverennoù pellgomz evit kaout un tamm skoazell da gadarnaat piv oc'h.",
	'requestaccount-bio-text' => 'Klaskit merkañ tammoù testenioù talvoudus diwar-benn ho puhezskrid amañ dindan.',
	'requestaccount-bio-text-i' => "'''Lakaet e vo ho tamm buhezskrid da vezañ an danvez pennañ evit ho pajenn implijer.'''
Bezit sur eo mat deoc'h embann seurt titouroù.",
	'requestaccount-real' => 'Anv gwir :',
	'requestaccount-same' => '(heñvel ou zh ar gwir anv)',
	'requestaccount-email' => "Chomlec'h postel :",
	'requestaccount-reqtype' => "Lec'hiadur :",
	'requestaccount-level-0' => 'aozer',
	'requestaccount-level-1' => 'skridaozer',
	'requestaccount-bio' => 'Buhezskrid personel (skrid plaen nemetken) :',
	'requestaccount-attach' => 'CV (diret) :',
	'requestaccount-notes' => 'Notennoù ouzhpenn :',
	'requestaccount-urls' => "Roll lec'hiennoù web, dispartiet gant lammoù-linenn :",
	'requestaccount-agree' => 'Rankout a rit testeni ez eo reizh ho anv gwir hag e zegemerit an Amplegadoù Implijout.',
	'requestaccount-inuse' => "Implijet eo an anv implijer en ur goulenn kont n'eo ket bet respontet c'hoazh.",
	'requestaccount-tooshort' => 'Ho puhezskrid a rank bezañ ennañ $1 {{PLURAL:$1|ger|ger}} da nebeutañ.',
	'requestaccount-emaildup' => "Ur goulenn all a c'hortoz bezañ aprouet a ra gant an hevelep chomlec'h elektronek.",
	'requestaccount-exts' => "Ar seurt restr stag n'eo ket aotreet.",
	'requestaccount-resub' => "Ret eo deo'h addibab ho CV evit abegoù surentez. Mar ne fell ket deoc'h lakaat anezhañ ken, lezit goullo ar vaezienn-mañ.",
	'requestaccount-tos' => 'Lennet em eus [[{{MediaWiki:Requestaccount-page}}|reolennoù implijout]] {{SITENAME}} hag asantiñ a ran doujañ outo.
Da vat eo ma anv gwir an hini am eus merket dindan "Anv gwir".',
	'requestaccount-submit' => 'Goulenn ur gont implijer',
	'requestaccount-sent' => "Kaset eo bet ervat ho koulenn krouién ur gont implijer; lakaet eo bet e roll gortoz ar goulennoù da vezañ aprouet.
Ur postel kadarnaat zo bet kaset d'ho chomlec'h postel.",
	'request-account-econf' => "Kadarnaet eo bet ho chomlec'h postel ha meneget e vo evel m'emañ en ho koulenn kont.",
	'requestaccount-email-subj' => "Kadarnadenn chomlec'h postel evit {{SITENAME}}",
	'requestaccount-email-body' => "Unan bennak, c'hwi moarvat, gant ar chomlec'h IP \$1, en deus goulennet sevel ur gont \"\$2\" gant ar chomlec'h postel-mañ war {{SITENAME}}.

Evit kadarnaat eo deoc'h ar gont-se war {{SITENAME}} e gwirionez, digorit al liamm-mañ en ho merdeer :

\$3

Mard eo bet krouet ar gont e vo kaset ar ger-tremen dre bostel deoc'h hepken
Ma n'eo ket gwir, *arabat* deoc'h implijout al liamm.
Mont a raio ar c'hod gwiriañ-mañ d'e dermen d'an \$4.",
	'requestaccount-email-subj-admin' => 'Goulenn kont evit {{SITENAME}}',
	'requestaccount-email-body-admin' => "« $1 » en deus goulennet ur gont ha zo o c'hortoz ar c'hadarnadur.

Kadarnaet eo bet ar chomlec'h postel. Gallout a rit kadarnaat ar goulenn amañ « $2 ».",
	'acct_request_throttle_hit' => "Digarez, met goulennet hoc'h eus {{PLURAL:$1|1 gont|$1 kont}} dija.
Ne c'hallit ket ober goulennoù all.",
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
	'requestaccount-areas-text' => 'Odaberite tematske oblasti ispod u kojima imate formalno iskustva ili u kojima bi željeli najviše raditi.',
	'requestaccount-real' => 'Pravo ime:',
	'requestaccount-same' => '(isto kao i pravo ime)',
	'requestaccount-email' => 'E-mail adresa:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'uređivač',
	'requestaccount-bio' => 'Lična biografija (samo obični tekst):',
	'requestaccount-attach' => 'Biografija (opcionalno):',
	'requestaccount-notes' => 'Dodatne napomene:',
	'requestaccount-urls' => 'Spisak web stranica, ako ih ima (odvojiti sa novim redovima):',
	'requestaccount-agree' => 'Morate potvrditi da je ovo Vaše pravo ime i da prihvatate naša Pravila usluga.',
	'requestaccount-inuse' => 'Korisničko ime je već u upotrebi u zahtjevu za račun.',
	'requestaccount-tooshort' => 'Vaša biografija mora biti duga najmanje $1 {{PLURAL:$1|riječ|riječi}}.',
	'requestaccount-emaildup' => 'Drugi zahtjev za račun na čekanju koristi istu e-mail adresu.',
	'requestaccount-exts' => 'Vrsta datoteke u privitku nije dopuštena.',
	'requestaccount-submit' => 'Zahtjevaj račun',
	'requestaccount-sent' => 'Vaš zahtjev za račun je uspješno poslan i sada očekuje provjeru.
Mail za potvrdu je poslan na Vašu e-mail adresu.',
	'request-account-econf' => 'Vaša e-mail adresa je potvrđena i bit će prikazana kako je navedeno u Vašem zahjevu za račun.',
	'requestaccount-email-subj' => '{{SITENAME}} e-mail adresa potvrde',
	'requestaccount-email-subj-admin' => 'Zahtjev za račun na {{SITENAME}}',
	'acct_request_throttle_hit' => 'Žao nam je, već ste zahtjevali otvaranje {{PLURAL:$1|1 računa|$1 računa}}.
Ne možete podnositi više zahtjeva.',
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
);

/** Czech (Česky)
 * @author Jkjk
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
	'requestaccount-leg-tos' => 'Podmínky služby',
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
	'requestaccount-email-subj-admin' => 'Žádost o účet na {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" požádal o účet a čeká na vaše schválení.
E-mail byla ověřena. Žádost můžete schválit zde "$2".',
	'acct_request_throttle_hit' => 'Promiňte, ale už jste {{gender:|požádal|požádala|požádali}} o vytvoření {{PLURAL:$1|1 účtu|$1 účtů}}.
Další žádost již není možná.',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'requestaccount-real' => 'и́стиньно и́мѧ :',
	'requestaccount-level-0' => 'творь́ць',
);

/** Danish (Dansk)
 * @author Aka-miki
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'requestaccount-leg-user' => 'Brugerkonto',
	'requestaccount-leg-person' => 'Personlige oplysninger',
	'requestaccount-real' => 'Virkeligt navn:',
	'requestaccount-same' => '(Samme som rigtige navn)',
	'requestaccount-email' => 'E-mail adresse',
	'requestaccount-reqtype' => 'Placering',
	'requestaccount-level-0' => 'Forfatter',
	'requestaccount-level-1' => 'redigerer',
	'requestaccount-bio' => 'Personlig biografi:',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Kghbln
 * @author Leithian
 * @author MF-Warburg
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking
 * @author Revolus
 * @author Rrosenfeld
 * @author The Evil IP address
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
	'requestaccount-leg-tos' => 'Nutzungsbedingungen',
	'requestaccount-acc-text' => 'An deine E-Mail-Adresse wird nach dem Absenden dieses Formulars eine Bestätigungsmail geschickt.
Bitte reagiere darauf, indem du auf den in dieser Mail enthaltenen Bestätigungs-Link klickst.
Sobald dein Konto angelegt wurde, wird dir dein Passwort per E-Mail zugeschickt.',
	'requestaccount-areas-text' => 'Wähle die Themengebiete aus, in denen du das meiste Fachwissen hast oder wo du am meisten involviert sein wirst.',
	'requestaccount-ext-text' => 'Die folgenden Informationen werden vertraulich behandelt und ausschließlich für diesen Antrag verwendet.
Du kannst Kontakt-Angaben wie eine Telefonnummer machen, um die Bearbeitung deines Antrags zu vereinfachen.',
	'requestaccount-bio-text' => 'Versuche alle relevanten Informationen in deine untenstehende Biografie aufzunehmen.',
	'requestaccount-bio-text-i' => "'''Deine Biografie wird als die erste Version deiner Benutzerseite veröffentlicht.'''
Du musst daher auch tatsächlich mit der Veröffentlichung dieser Daten einverstanden sein.",
	'requestaccount-real' => 'Bürgerlicher Name:',
	'requestaccount-same' => '(wie mein bürgerlicher Name)',
	'requestaccount-email' => 'E-Mail-Adresse:',
	'requestaccount-reqtype' => 'Position:',
	'requestaccount-level-0' => 'Autor',
	'requestaccount-level-1' => 'Bearbeiter',
	'requestaccount-bio' => 'Persönliche Biografie (nur Text):',
	'requestaccount-attach' => 'Lebenslauf (optional):',
	'requestaccount-notes' => 'Zusätzliche Angaben:',
	'requestaccount-urls' => 'Liste von Webseiten (durch Zeilenumbrüche getrennt):',
	'requestaccount-agree' => 'Du musst bestätigen, dass dein bürgerlicher Name korrekt ist und du die Nutzungsbedingungen akzeptierst.',
	'requestaccount-inuse' => 'Der Benutzername ist bereits in einem anderen Benutzerantrag in Verwendung.',
	'requestaccount-tooshort' => 'Deine Biographie muss mindestens {{PLURAL:$1|1 Wort|$1 Wörter}} lang sein.',
	'requestaccount-emaildup' => 'Ein weiterer noch nicht erledigter Antrag benutzt die gleiche E-Mail-Adresse.',
	'requestaccount-exts' => 'Der Dateityp des Anhangs ist nicht erlaubt.',
	'requestaccount-resub' => 'Die Datei mit deinem Lebenslauf muss aus Sicherheitsgründen neu ausgewählt werden.
Lasse das Feld leer, wenn du keinen Lebenslauf mehr anfügen möchtest.',
	'requestaccount-tos' => 'Ich habe die [[{{MediaWiki:Requestaccount-page}}|Nutzungsbedingungen]] von {{SITENAME}} gelesen und akzeptiere sie.
Ich bestätige, dass der Name, den ich unter „Bürgerlicher Name“ angegeben habe, mein wirklicher Name ist.',
	'requestaccount-submit' => 'Benutzerkonto beantragen',
	'requestaccount-sent' => 'Dein Antrag wurde erfolgreich verschickt und muss nun noch überprüft werden.
Eine Bestätigungs-E-Mail wurde an deine E-Mail-Adresse gesendet.',
	'request-account-econf' => 'Deine E-Mail-Adresse wurde bestätigt und wird nun als solche in deinem Antrag auf ein Benutzerkonto geführt.',
	'requestaccount-email-subj' => '[{{SITENAME}}] Bestätigung der E-Mail-Adresse',
	'requestaccount-email-body' => 'Jemand, mit der IP Adresse $1, möglicherweise du, hat bei {{SITENAME}} das Benutzerkonto „$2“ mit deiner E-Mail-Adresse beantragt.

Um zu bestätigen, dass wirklich du dieses Konto bei {{SITENAME}} beantragt hast, öffne bitte folgenden Link in deinem Browser:

$3

Wenn das Benutzerkonto erstellt wurde, bekommst du eine weitere E-Mail mit dem Passwort.

Wenn du das Benutzerkonto *nicht* beantragt hast, öffne den Link bitte nicht!

Dieser Bestätigungscode wird am $5 um $6 Uhr ungültig.',
	'requestaccount-email-subj-admin' => '[{{SITENAME}}] Antrag auf Benutzerkonto',
	'requestaccount-email-body-admin' => '„$1“ hat ein Benutzerkonto beantragt und wartet auf Bestätigung.
Die E-Mail-Adresse wurde bestätigt. Du kannst den Antrag hier bestätigen: „$2“.',
	'acct_request_throttle_hit' => 'Du hast bereits {{PLURAL:$1|1 Benutzerkonto|$1 Benutzerkonten}} beantragt, du kannst momentan keine weiteren beantragen.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 * @author The Evil IP address
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
	'requestaccount-bio-text' => 'Versuchen Sie alle relevanten Informationen in Ihre untenstehende Biografie aufzunehmen.',
	'requestaccount-bio-text-i' => "'''Ihre Biografie wird als die erste Version Ihrer Benutzerseite veröffentlicht.'''
Sie müssen daher auch tatsächlich mit der Veröffentlichung dieser Daten einverstanden sein.",
	'requestaccount-agree' => 'Sie müssen bestätigen, dass Ihr bürgerlicher Name korrekt ist und Sie die Nutzungsbedingungen akzeptieren.',
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
	'requestaccount-bio-text' => 'Wopytaj wšykne relewantne informacije do swójeje slědujuceje biografije zapśimjeś.',
	'requestaccount-bio-text-i' => "'''Twója biografija wózjawijo se ako prědna wersija twójeje wužywarskego boka.'''
Musyš togodla z wózjawjenim toś tych informacijow wobjadny byś.",
	'requestaccount-real' => 'Napšawdne mě:',
	'requestaccount-same' => '(kaž napšawdne mě)',
	'requestaccount-email' => 'E-mailowa adresa:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'awtor',
	'requestaccount-level-1' => 'wobźěłaŕ',
	'requestaccount-bio' => 'Wósobinska biografija (jano samy tekst):',
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
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Egmontaz
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
	'requestaccount-tooshort' => 'Το βιογραφικό σας θα πρέπει να είναι τουλάχιστον $1 {{PLURAL:$1|λέξη|λέξεις}}',
	'requestaccount-submit' => 'Αίτηση λογαριασμού',
	'requestaccount-email-subj-admin' => 'Αίτηση λογαριασμού στο {{SITENAME}}',
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
);

/** Spanish (Español)
 * @author BicScope
 * @author Crazymadlover
 * @author Fitoschido
 * @author Imre
 * @author Lin linao
 * @author Locos epraix
 * @author Pertile
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'requestaccount' => 'Solicitar cuenta',
	'requestaccount-text' => "'''Completa y envía el siguiente formulario para solicitar una cuenta de usuario'''.

Antes de solicitar una cuenta, asegúrate de haber leído los [[{{MediaWiki:Requestaccount-page}}|términos del servicio]].

Una vez que la cuenta sea aprobada, se te enviará una notificación a través de correo electrónico y la cuenta se podrá usar [[Special:UserLogin|iniciando sesión]].",
	'requestaccount-page' => '{{ns:project}}:Términos de servicio',
	'requestaccount-dup' => "'''Nota: Ya has iniciado sesión en una cuenta registrada.'''",
	'requestaccount-leg-user' => 'Cuenta de usuario',
	'requestaccount-leg-areas' => 'Áreas de interés principales',
	'requestaccount-leg-person' => 'Información personal',
	'requestaccount-leg-other' => 'Otra información',
	'requestaccount-leg-tos' => 'Términos de servicio',
	'requestaccount-acc-text' => 'Una vez que se envíe este pedido, recibirás en tu correo un mensaje de confirmación.
Responde pulsando en el enlace de confirmación proporcionado por el mensaje.
Además, tu contraseña se enviará a tu dirección de correo una vez que la cuenta sea creada.',
	'requestaccount-areas-text' => 'Seleccione las áreas en las que tiene experiencia formal o que le interesa colaborar.',
	'requestaccount-ext-text' => 'La siguiente información se mantiene privada y sólo será usada para esta solicitud.
Usted puede desear enlistar contactos como un número telefónico para ayudar en la confirmación de la identidad.',
	'requestaccount-bio-text' => 'Trata de incluir alguna credencial relevante en tu biografía abajo.',
	'requestaccount-bio-text-i' => "'''Su biografía se establecerá como el contenido inicial de tu página de usuario.'''
Asegúrate de estar cómodo con la publicación de dicha información.",
	'requestaccount-real' => 'Nombre real:',
	'requestaccount-same' => '[Tu nombre real]',
	'requestaccount-email' => 'Dirección de correo electrónico:',
	'requestaccount-reqtype' => 'Posición:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografía personal (sólo texto simple):',
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
	'requestaccount-tos' => 'He leído y estoy de acuerdo con los [[{{MediaWiki:Requestaccount-page}}|términos del servicio]] de {{SITENAME}}. El nombre que especificado bajo "Nombre real" es de hecho mi propio nombre real.',
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
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
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
	'requestaccount-bio' => 'Isiku biograafia (vaid lihttekst):',
	'requestaccount-attach' => 'Resümee või CV (valikuline):',
	'requestaccount-notes' => 'Lisainfo:',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'requestaccount-leg-user' => 'Erabiltzaile kontua',
	'requestaccount-leg-person' => 'Norberaren informazioa',
	'requestaccount-leg-other' => 'Bestelako informazioa',
	'requestaccount-real' => 'Benetako izena:',
	'requestaccount-email' => 'E-posta helbidea:',
	'requestaccount-level-0' => 'egilea',
	'requestaccount-bio' => 'Norberaren biografia:',
	'requestaccount-attach' => 'Curriculuma (hautazkoa):',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'requestaccount-real' => 'Nombri verdaeru:',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'requestaccount-leg-person' => 'اطلاعات شخصی',
	'requestaccount-leg-other' => 'اطلاعات دیگر',
	'requestaccount-real' => 'نام واقعی:',
	'requestaccount-same' => '(همان نام واقعی)',
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
);

/** French (Français)
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Louperivois
 * @author McDutchie
 * @author Meithal
 * @author Peter17
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
	'requestaccount-bio-text' => "Essayez d'inclure toute références pertinentes à votre biographie ci-dessous.",
	'requestaccount-bio-text-i' => "'''Votre biographie servira comme contenu initial de votre page utilisateur.'''
Assurez-vous d'être à l'aise de publier de telles informations.",
	'requestaccount-real' => 'Nom réel :',
	'requestaccount-same' => '(nom figurant dans votre état civil)',
	'requestaccount-email' => 'Adresse électronique :',
	'requestaccount-reqtype' => 'Situation :',
	'requestaccount-level-0' => 'auteur',
	'requestaccount-level-1' => 'contributeur',
	'requestaccount-bio' => 'Biographie personnelle (texte brut seulement)  :',
	'requestaccount-attach' => 'CV (facultatif) :',
	'requestaccount-notes' => 'Notes supplémentaires :',
	'requestaccount-urls' => "Liste des sites Web. S'il y en a plusieurs, séparez-les par un saut de ligne :",
	'requestaccount-agree' => 'Vous devez certifier que votre nom réel est correct et que vous acceptez les conditions d’utilisation.',
	'requestaccount-inuse' => 'Le nom d’utilisateur est déjà utilisé dans une requête en cours d’approbation.',
	'requestaccount-tooshort' => 'Votre biographie doit avoir au moins $1 mot{{PLURAL:$1||s}}.',
	'requestaccount-emaildup' => 'Une autre demande en cours utilise la même adresse électronique.',
	'requestaccount-exts' => 'Le type du fichier joint n’est pas permis.',
	'requestaccount-resub' => 'Veuillez sélectionner à nouveau votre curriculum vitæ pour des raisons de sécurité. Si vous ne souhaitez plus inclure celui-ci, laissez ce champ vierge.',
	'requestaccount-tos' => "J’ai lu et j’accepte les [[{{MediaWiki:Requestaccount-page}}|conditions d’utilisation]] de {{SITENAME}}.
Le nom que j'ai indiqué à la rubrique « Nom réel » est bien mon nom réel.",
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
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'requestaccount' => 'Demanda de compto usanciér',
	'requestaccount-text' => "'''Rempléd et pués mandâd lo formulèro ce-desot por demandar un compto usanciér.'''

Assurâd-vos que vos éd ja liesu les [[{{MediaWiki:Requestaccount-page}}|condicions d’usâjo]] devant que fâre voutra demanda de compto usanciér.

Setout que lo compto est accèptâ, vos recevréd un mèssâjo de notificacion et pués voutron compto usanciér porrat étre utilisâ sur la [[Special:UserLogin|pâge de branchement]].",
	'requestaccount-page' => '{{ns:project}}:Condicions d’usâjo',
	'requestaccount-dup' => "'''Nota : vos éte ja sur una sèance avouéc un compto usanciér encartâ.'''",
	'requestaccount-leg-user' => 'Compto usanciér',
	'requestaccount-leg-areas' => 'Centros d’entèrèts principâls',
	'requestaccount-leg-person' => 'Enformacions a sè',
	'requestaccount-leg-other' => 'Ôtres enformacions',
	'requestaccount-leg-tos' => 'Condicions d’usâjo',
	'requestaccount-acc-text' => 'Un mèssâjo de confirmacion serat mandâ a voutra adrèce èlèctronica setout que la demanda arat étâ mandâ.
Dens lo mèssâjo reçu, clicâd sur lo lim que corrèspond a la confirmacion de voutra demanda.
Et pués, un contresegno serat mandâ per mèssageria èlèctronica quand voutron compto usanciér serat fêt.',
	'requestaccount-areas-text' => 'Chouèsésséd los domênos que vos avéd una èxpèrtisa dèmontrâ, ou ben que vos éte encllin a contribuar lo ples.',
	'requestaccount-ext-text' => 'Ceta enformacion réste privâ et pués porrat étre utilisâ ren que por ceta demanda.
Vos avéd la possibilitât de listar des contactes coment un numerô de tèlèfono por avêr una assistance por confirmar voutra identitât.',
	'requestaccount-bio-text' => 'Tâchiéd d’encllure totes les recomandacions que vont avouéc dens voutra biografia ce-desot.',
	'requestaccount-real' => 'Veré nom :',
	'requestaccount-same' => '(nom que figure dens voutron ètat civilo)',
	'requestaccount-email' => 'Adrèce èlèctronica :',
	'requestaccount-reqtype' => 'Situacion :',
	'requestaccount-level-0' => 'ôtor',
	'requestaccount-level-1' => 'contributor',
	'requestaccount-bio' => 'Biografia a sè (solament lo tèxto bruto) :',
	'requestaccount-attach' => 'CV (u chouèx) :',
	'requestaccount-notes' => 'Notes de ples :',
	'requestaccount-urls' => 'Lista des setos vouèbe. S’y en at un mouél, sèparâd-los per un sôt de legne :',
	'requestaccount-agree' => 'Vos dête cèrtifiar que voutron veré nom est justo et pués que vos accèptâd les condicions d’usâjo.',
	'requestaccount-inuse' => 'Lo nom d’usanciér est ja utilisâ dens una demanda de compto usanciér qu’est aprés étre aprovâ.',
	'requestaccount-tooshort' => 'Voutra biografia dêt avêr u muens $1 mot{{PLURAL:$1||s}}.',
	'requestaccount-emaildup' => 'Una ôtra demanda qu’est aprés étre confirmâ utilise la méma adrèce èlèctronica.',
	'requestaccount-exts' => 'Lo tipo du fichiér apondu est pas pèrmês.',
	'requestaccount-resub' => 'Volyéd tornar chouèsir voutron fichiér de CV por des rêsons de sècuritât.
Se vos souhètâd pas més encllure ceti, lèssiéd lo champ vouedo.',
	'requestaccount-tos' => 'J’é liesu et pués j’accèpto les [[{{MediaWiki:Requestaccount-page}}|condicions d’usâjo]] de {{SITENAME}}.
Lo nom que j’é buchiê dens lo champ « Veré nom » est franc mon prôpro nom.',
	'requestaccount-submit' => 'Demanda de compto usanciér',
	'requestaccount-sent' => 'Voutra demanda de compto at étâ mandâ avouéc reusséta et pués at étâ betâ dens la lista d’atenta d’aprobacion.
Un mèssâjo de confirmacion at étâ mandâ a voutra adrèce èlèctronica.',
	'request-account-econf' => 'Voutra adrèce èlèctronica at étâ confirmâ et serat listâ d’ense dens voutra demanda de compto usanciér.',
	'requestaccount-email-subj' => 'Confirmacion de l’adrèce èlèctronica por {{SITENAME}}',
	'requestaccount-email-body' => 'Quârqu’un, probâblament vos, at fêt, dês l’adrèce IP $1, una demanda de compto usanciér « $2 » avouéc ceta adrèce èlèctronica sur lo seto {{SITENAME}}.

Por confirmar que cél compto est franc a vos dessus {{SITENAME}}, vos éte preyê d’uvrir ceti lim dens voutron navigator :

$3

Voutron contresegno vos serat mandâ ren que se voutron compto usanciér est fêt.
S’o ére *pas* lo câs, utilisâd pas cél lim.
Ceti code de confirmacion èxpirerat lo $4.',
	'requestaccount-email-subj-admin' => 'Demanda de compto dessus {{SITENAME}}',
	'requestaccount-email-body-admin' => '« $1 » at demandâ un compto usanciér et sè trove en atenta de confirmacion.
L’adrèce èlèctronica at étâ confirmâ. Vos pouede aprovar la demanda ique « $2 ».',
	'acct_request_throttle_hit' => 'Dèsolâ, vos éd ja demandâ $1 compto{{PLURAL:$1||s}} usanciér.
Vos pouede pas més fâre de demanda.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'requestaccount-level-0' => 'auteur',
	'requestaccount-level-1' => 'redakteur',
);

/** Galician (Galego)
 * @author Alma
 * @author Elisardojm
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
	'requestaccount-bio-text' => 'Intente incluír algunhas credenciais relevantes na súa biografía.',
	'requestaccount-bio-text-i' => "'''A súa biografía será definida como o contido inicial da súa páxina de usuario.'''
Asegúrese de que se sinte cómodo publicando esa información.",
	'requestaccount-real' => 'Nome real:',
	'requestaccount-same' => '(o mesmo que o nome real)',
	'requestaccount-email' => 'Enderezo de correo electrónico:',
	'requestaccount-reqtype' => 'Posición:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografía persoal (só texto):',
	'requestaccount-attach' => 'Curriculum Vitae (opcional):',
	'requestaccount-notes' => 'Notas adicionais:',
	'requestaccount-urls' => 'Lista de sitios web, de habelos, (separados cun parágrafo novo):',
	'requestaccount-agree' => 'Debe certificar que o seu nome real é correcto e que está de acordo coas nosas Condicións de servizo.',
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
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
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
	'requestaccount-bio-text' => 'Nimm wänn mögli alli relevanti Details in dyni Biographi doo unte uff.',
	'requestaccount-bio-text-i' => "'''Dyni Biografi wird als di ersti Version vo dyner Benutzersyte veröffentlicht.'''
Wäge däm muesch au würkli demit yyverstande sy, dass die Date veröffentlicht werde.",
	'requestaccount-real' => 'Realname:',
	'requestaccount-same' => '(wie dr Realname)',
	'requestaccount-email' => 'E-Mail-Adräss:',
	'requestaccount-reqtype' => 'Position:',
	'requestaccount-level-0' => 'Autor',
	'requestaccount-level-1' => 'Bearbeiter',
	'requestaccount-bio' => 'Persenligi Biografii (numme Teggst):',
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
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'requestaccount-level-1' => 'luna',
);

/** Hebrew (עברית)
 * @author Amire80
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
	'requestaccount-areas-text' => 'בחרו את הנושאים שבהם יש לכם מומחיות פורמלית או שבהם אתם עושים את רוב העבודה.',
	'requestaccount-ext-text' => 'המידע הבא נשמר בפרטיות וישמש עבור בקשה זו בלבד.
יתכן שתרצו לציין פרטי קשר כגון מספר טלפון כדי לסייע באימות זהותכם.',
	'requestaccount-bio-text' => 'נסו לכלול הסמכות רלוונטיות בביוגרפיה להלן.',
	'requestaccount-bio-text-i' => "'''הביוגרפיה שלכם תוגדר בתור התוכן ההתחלתי לדף המשתמש שלכם.'''
נא לוודא שאתם מסכימים לפרסם מידע כזה.",
	'requestaccount-real' => 'שם אמיתי:',
	'requestaccount-same' => '(כמו השם האמיתי)',
	'requestaccount-email' => 'כתובת הדוא"ל:',
	'requestaccount-reqtype' => 'משרה:',
	'requestaccount-level-0' => 'מחבר',
	'requestaccount-level-1' => 'עורך',
	'requestaccount-bio' => 'ביוגרפיה אישית (רק טקסט פשוט):',
	'requestaccount-attach' => 'קורות חיים (אופציונאלי):',
	'requestaccount-notes' => 'הערות נוספות:',
	'requestaccount-urls' => 'רשימה של אתרים, אם יש כאלה (הפרידו באמצעות שורות חדשות):',
	'requestaccount-agree' => 'עליכם לאמת כי השם שציינתם הוא שמכם האמיתי ושהוא נכון ושאתם מסכימים לתנאי השימוש שלנו.',
	'requestaccount-inuse' => 'שם המשתמש כבר נמצא בשימוש בבקשת חשבון ממתינה.',
	'requestaccount-tooshort' => 'על הביוגרפיה שלכם להכיל לפחות {{PLURAL:$1|מילה אחת|$1 מילים}}.',
	'requestaccount-emaildup' => 'בקשת חשבון ממתינה אחרת משתמשת באותה כתובת דוא"ל.',
	'requestaccount-exts' => 'סוג הקובץ המצורף אינו מורשה.',
	'requestaccount-resub' => 'מסיבות של אבטחת מידע יש לבחור מחדש את קובץ קורות החיים שלכם.
השאירו את השדה הזה ריק אם אינכם רוצים לכלול כאן קובץ כזה.',
	'requestaccount-tos' => 'קראתי והסכמתי ל[[{{MediaWiki:Requestaccount-page}}|תנאי השימוש]] של {{SITENAME}}.
השם שציינתי תחת "השם האמתי" הוא באמת שמי האמתי.',
	'requestaccount-submit' => 'בקשת חשבון',
	'requestaccount-sent' => 'בקשת החשבון שלכם נשלחה בהצלחה וממתינה לסקירה.
מכתב וידוא נשתח לכתובת הדואר האלקטרוני שלכם.',
	'request-account-econf' => 'המערכת וידאה את נכונות כתובת הדואר האלקטרוני שלכם והיא תירשם בבקשת החשבון שלכם.',
	'requestaccount-email-subj' => 'אימות כתובת דוא"ל עבור {{SITENAME}}',
	'requestaccount-email-body' => 'מישהו, כנראה אתם מכתובת ה־IP‏ $1 ביקש ליצור חשבון בשם "$2" המזוהה עם כתובת הדואר האלקטרוני הזאת באתר {{SITENAME}}.

כדי לאשר שהחשבון הזה אכן שייך לכם באתר {{SITENAME}}, פתחו את הקישור הבא בדפדפן שלכם:

$3

אם החשבון נוצר, הססמה תישלח רק אליכם.
אם לא ביקשתם את זה, אין ללחוץ על הקישור.
קוד האישור הזה יפוג ב־$4.',
	'requestaccount-email-subj-admin' => 'בקשת חשבון באתר {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" ביקש חשבון וממתין לאישור.
בוצע וידוא כתובת דואר אלקטרוני. אפשר לאשר את הבקשה כאן "$2".',
	'acct_request_throttle_hit' => 'סליחה, אתם כבר ביקשתם {{PLURAL:$1|חשבון|$1 חשבונות}}.
אי־אפשר לבקש עוד.',
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
	'requestaccount-bio-text' => 'Spytaj wšě relewantne informacije do swojeje slědowaceje biografije zapřijimać.',
	'requestaccount-bio-text-i' => "'''Twoja biografija wozjewi so jako prěnja wersija twojeje wužiwarskeje strony.'''
Dyrbiš tohodla z wozjewjenjom tutych informacijow přezjedny być.",
	'requestaccount-real' => 'Woprawdźite mjeno:',
	'requestaccount-same' => '(kaž woprawdźite mjeno)',
	'requestaccount-email' => 'E-mejlowa adresa:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'awtor',
	'requestaccount-level-1' => 'Wobdźěłowar',
	'requestaccount-bio' => 'Wosobinska biografija (jenož luty tekst):',
	'requestaccount-attach' => 'Žiwjenjoběh',
	'requestaccount-notes' => 'Přidatne podaća:',
	'requestaccount-urls' => 'Lisćina webowych sydłow (přez linkowe łamanja wotdźělene)',
	'requestaccount-agree' => 'Dyrbiš potwjerdźić, zo twoje woprawdźite mjeno je korektne a wužiwarske wuměnjenja akceptuješ.',
	'requestaccount-inuse' => 'Wužiwarske mjeno so hižo w druhim kontowym požadanju wužiwa.',
	'requestaccount-tooshort' => 'Twoja biografija dyrbi znajmjeńša $1 {{PLURAL:$1|słowo|słowje|słowa|słowow}} dołho być.',
	'requestaccount-emaildup' => 'Druhe předležace kontowe požadanje samsnu e-mejlowu adresu wužiwa.',
	'requestaccount-exts' => 'Datajowy typ přiwěška je njedowoleny.',
	'requestaccount-resub' => 'Twoja žiwjenjoběhowa dataja dyrbi so z přičinow wěstoty znowa wubrać. Wostaj polo prózdne, jeli hižo nochceš tajku zapřijimać.',
	'requestaccount-tos' => 'Sym [[{{MediaWiki:Requestaccount-page}}|wužiwarske wuměnjenja]] strony {{SITENAME}} přečitał a budu je dodźeržować.
Mjeno, kotrež sym pod "Woprawdźite mjeno" podał je woprawdźe moje swójske woprawdźite mjeno.',
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
	'requestaccount-bio-text' => 'Essaya includer omne qualificationes relevante in tu biographia hic infra.',
	'requestaccount-bio-text-i' => "'''Le biographia essera inserite como le contento initial de tu pagina de usator.'''
Assecura te que tu sia confortabile con le publication de tal informationes.",
	'requestaccount-real' => 'Nomine real:',
	'requestaccount-same' => '(equal al nomine real)',
	'requestaccount-email' => 'Adresse de e-mail:',
	'requestaccount-reqtype' => 'Position:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'contributor',
	'requestaccount-bio' => 'Biographia personal (texto simple solmente):',
	'requestaccount-attach' => 'Résumé o CV (optional):',
	'requestaccount-notes' => 'Notas additional:',
	'requestaccount-urls' => 'Lista de sitos web, si alcun (un per linea):',
	'requestaccount-agree' => 'Tu debe certificar que tu nomine real es correcte e que tu accepta nostre Conditiones de Servicio.',
	'requestaccount-inuse' => 'Le nomine de usator es ja in uso in un requesta de conto pendente.',
	'requestaccount-tooshort' => 'Tu biographia debe haber al minus $1 {{PLURAL:$1|parola|parolas}} de longor.',
	'requestaccount-emaildup' => 'Un altere requesta pendente de conto usa le mesme adresse de e-mail.',
	'requestaccount-exts' => 'Iste typo de file non es permittite in annexos.',
	'requestaccount-resub' => 'Tu debe reseliger tu file CV/résumé pro motivos de securitate.
Lassa le campo vacue si tu non vole plus includer un.',
	'requestaccount-tos' => 'Io ha legite e consenti a acceptar le [[{{MediaWiki:Requestaccount-page}}|Conditiones de Servicio]] of {{SITENAME}}.
Le nomine que io ha specificate sub "Nomine real" es de facto mi proprie nomine real.',
	'requestaccount-submit' => 'Requesta de conto',
	'requestaccount-sent' => 'Tu requesta de conto ha essite inviate con successo e nunc attende revision.
Un message de confirmation ha essite inviate a tu adresse de e-mail.',
	'request-account-econf' => 'Tu adresse de e-mail ha essite confirmate e essera listate como tal in tu requesta de conto.',
	'requestaccount-email-subj' => 'Confirmation del adresse de e-mail pro {{SITENAME}}',
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
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
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
	'requestaccount-bio-text' => 'Usakan untuk memasukkan kredensial yang relevan ke dalam biografi Anda di bawah ini.',
	'requestaccount-bio-text-i' => "'''Biografi Anda akan ditetapkan sebagai konten awal halaman pengguna Anda.'''
Pastikan Anda merasa nyaman untuk menerbitkan informasi semacam itu.",
	'requestaccount-real' => 'Nama asli:',
	'requestaccount-same' => '(sama dengan nama asli)',
	'requestaccount-email' => 'Alamat surel:',
	'requestaccount-reqtype' => 'Posisi:',
	'requestaccount-level-0' => 'penulis',
	'requestaccount-level-1' => 'penyunting',
	'requestaccount-bio' => 'Biografi pribadi (hanya teks sederhana):',
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
Kode konfirmasi ini akan kedaluwarsa pada $4.',
	'requestaccount-email-subj-admin' => 'Permintaan akun {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" telah mengajukan permintaan pembuatan akun dan sedang menunggu konfirmasi.
Surel ini telah dikonfirmasi. Anda dapat memberikan konfirmasi atas permintaan tersebut di sini "$2".',
	'acct_request_throttle_hit' => 'Anda telah meminta {{PLURAL:$1|1 akun|$1 akun}}.
Anda tidak dapat lagi melakukan permintaan.',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Ævar Arnfjörð Bjarmason
 */
$messages['is'] = array(
	'requestaccount' => 'Sækja um aðgang',
	'requestaccount-leg-user' => 'Aðgangur notanda',
	'requestaccount-leg-areas' => 'Aðal áhugamál',
	'requestaccount-leg-person' => 'Persónulegar upplýsingar',
	'requestaccount-leg-other' => 'Aðrar upplýsingar',
	'requestaccount-real' => 'Raunverulegt nafn:',
	'requestaccount-same' => '(fyllt út hér fyrir neðan)',
	'requestaccount-email' => 'Netfang:',
	'requestaccount-reqtype' => 'Staða:',
	'requestaccount-level-0' => 'höfundur',
	'requestaccount-level-1' => 'ritstjóri',
	'requestaccount-bio' => 'Sjálfsævisaga:',
	'requestaccount-attach' => 'Ferilskrá (valfrjálst):',
	'requestaccount-notes' => 'Viðbótarskýring:',
	'requestaccount-urls' => 'Listi yfir vefsíður, ef einhverjar (aðskildu með línum):',
	'requestaccount-tooshort' => 'Notendaupplýsingarnar þínar þurfa að vera að minnsta kosti $1 orð á lengd.',
	'requestaccount-submit' => 'Sækja um aðgang',
	'requestaccount-sent' => 'Beðni þín um aðgang var móttekin og bíður nú yfirferðar hjá stjórnendum. Staðfestingarpóstur var sendur á netfangið þitt.',
	'request-account-econf' => 'Netfangið þitt hefur verið staðfest og mun vera listað sem slíkt meðal aðgangsbeðna.',
	'requestaccount-email-subj' => '{{SITENAME}} netfangs-staðfesting',
	'requestaccount-email-body' => 'Einhver með vistfangið „$1“ hefur beðið um að búa til aðganginn „$2“ með þessu netfangi á {{SITENAME}} vefnum.

Til að steðfesta að þú viljir búa til þennan aðgang á {{SITENAME}} þarftu að opna þennan tengil í vafranum þínum:

$3

Þér verður sent lykilorð í pósti verði aðgangurinn búinn til. Þessi staðfestingarpóstur rennur út $4.',
	'requestaccount-email-subj-admin' => 'Beðni um notanda a {{SITENAME}}',
	'requestaccount-email-body-admin' => '„$1“ hefur beðið um aðgang að sem bíður staðfestingar, notandinn hefur þegar staðfest netfangið sitt.

Þú getur staðfest beðnina hér:

$2',
	'acct_request_throttle_hit' => 'Þú hefur þegar sótt um {{PLURAL:$1|1 aðgang|$1 aðganga}}. Þú getur ekki sent inn fleiri beðnir.',
);

/** Italian (Italiano)
 * @author Beta16
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
	'requestaccount-bio-text' => 'Cerca di inserire tutte le credenziali e le informazioni rilevanti nella tua biografia.',
	'requestaccount-bio-text-i' => "'''La tua biografia sarà impostata come contenuto predefinito per la tua pagina utente.'''
Assicurati di voler pubblicare tali informazioni.",
	'requestaccount-real' => 'Vero nome:',
	'requestaccount-same' => '(uguale al vero nome)',
	'requestaccount-email' => 'Indirizzo e-mail:',
	'requestaccount-reqtype' => 'Posizione:',
	'requestaccount-level-0' => 'autore',
	'requestaccount-level-1' => 'editore',
	'requestaccount-bio' => 'Biografia personale (solo testo):',
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
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Schu
 * @author 青子守歌
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
	'requestaccount-leg-person' => '個人情報',
	'requestaccount-leg-other' => 'その他',
	'requestaccount-leg-tos' => '利用規約',
	'requestaccount-acc-text' => '申請を行うと、確認メッセージがあなたの電子メールアドレスへ送信されます。その電子メールにある確認のためのリンクをクリックすると申請が承認されます。また、アカウントが作成された際には、電子メールでパスワードが送られます。',
	'requestaccount-areas-text' => 'あなたが見識をお持ちの分野、または主に活動したい分野を選択してください。',
	'requestaccount-ext-text' => '以下の個人情報は公開されず、この申請処理にのみ利用されます。
電話番号をはじめとする連絡先は、あなたが本人確認の補助を目的として記入いただけます。',
	'requestaccount-bio-text' => '下記のあなたの経歴に、関連する資格情報を含めるようにしてください。',
	'requestaccount-bio-text-i' => "'''あなたの経歴はあなたの利用者ページに初期のコンテンツとして設定されます。'''
この情報を公開してよいかどうかを確認してください。",
	'requestaccount-real' => '本名:',
	'requestaccount-same' => '(本名での登録に限定されます)',
	'requestaccount-email' => '電子メールアドレス:',
	'requestaccount-reqtype' => 'サイトでの役割:',
	'requestaccount-level-0' => '著者',
	'requestaccount-level-1' => '編集者',
	'requestaccount-bio' => '個人の経歴 ( プレーンテキストのみ )：',
	'requestaccount-attach' => '履歴書またはCV (オプション)：',
	'requestaccount-notes' => '特記事項：',
	'requestaccount-urls' => 'ウェブサイト一覧、任意回答 ( 改行で区切ってください)：',
	'requestaccount-agree' => '本名が正しいこと、および、サービス利用規約に同意したことを宣誓していただく必要があります。',
	'requestaccount-inuse' => 'この利用者名は、承認待ちのアカウントにて既に申請済みです。',
	'requestaccount-tooshort' => "あなたの経歴は、最低限 $1個以上の単語で構成される必要があります。''(訳注：この機能は日本語版ではうまく動作しないかもしれません。あなたが管理者であるならば、この制約の使用に慎重であってください。あなたが一般利用者である場合、このサイトの管理者と相談してください。)''",
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
	'requestaccount-email-body' => 'IP アドレス $1 を使用するどなたか(おそらくあなた)が、この電子メールアドレスを用いて {{SITENAME}} のアカウント "$2" の作成を申請しました。

この {{SITENAME}}　のアカウント作成が本当にあなたによる申請であると証明するには、以下のリンク先をブラウザから開いてください:

$3

アカウントが作成されると、パスワードが電子メールで送信されます。もしも、この申請があなたによるもの\'\'\'ではない\'\'\'場合、このリンクはクリックしないでください。
この承認手続きは $4 で期限切れとなります。',
	'requestaccount-email-subj-admin' => '{{SITENAME}} のアカウント申請',
	'requestaccount-email-body-admin' => '"$1" によるアカウント申請が承認待ちになっています。
申請電子メールアドレスは本人確認済みです。この申請への承認は、"$2"　から行うことができます。',
	'acct_request_throttle_hit' => '申し訳ありません、あなたは既に$1{{PLURAL:$1|アカウント}}を申請済みです。これ以上の申請はできません。',
);

/** Jamaican Creole English (Patois)
 * @author Yocahuna
 */
$messages['jam'] = array(
	'requestaccount' => 'Rikwes akount',
	'requestaccount-text' => "'''Kompliit ahn sobmit di falarin faam fi rikwes a yuuza akount'''.

Mek shuor se yu riid fos di [[{{MediaWiki:Requestaccount-page}}|Toerm a Saabis]] bifuo yu rikwes akount.

Wans di akount apruuv, yu wi get e-miel nuotifikieshan mechiz ahn yu kiahn yuuz di akount a [[Special:UserLogin|lagiin]].",
	'requestaccount-page' => '{{ns:project}}:Toerm a Saabis',
	'requestaccount-dup' => "'''Nuot: Yu aredi lag iin wid a rejista akount.'''",
	'requestaccount-leg-user' => 'Yuuza akount',
	'requestaccount-leg-areas' => 'Mien ieriadem a inchres',
	'requestaccount-leg-person' => 'Persnal infamieshan',
	'requestaccount-leg-other' => 'Ada infamieshan',
	'requestaccount-leg-tos' => 'Toerm a Saabis',
	'requestaccount-acc-text' => 'Yu e-miel ajres wi get a kanfoermieshan mechiz wans yu sobmit dis rikwes.
Begyu rispan bai klik pahn di kanfoermieshan lingk provaid ina di e-miel.
Alzwel yu paaswod wi e-miel tu yu wen yu akount kriet.',
	'requestaccount-areas-text' => 'Silek di tapik ieriadem biluo fi we yu gat faamal expoertiis ar wuda laik fi du di muos wok.',
	'requestaccount-ext-text' => 'Di falarin infamieshan kip praivit ahn wi onggl yuuz fi dis rikwes.
Yu maita waahn fi lis kantak laka fuon nomba fi ied ina aidentifai kanfoermieshan.',
	'requestaccount-bio-text' => 'Yu bayagrafi wi set az difaalt kantent fi yu yuuzapiej.
Chrai fi inkluud eni kridenshal.
Mek shuor se yu komfotebl fi poblish soertn infamieshan.
Yu niem kiahn chienj vaya [[Special:Preferences|yu prefransdem]].',
	'requestaccount-real' => 'Riil niem:',
	'requestaccount-same' => '(siem az riil niem)',
	'requestaccount-email' => 'E-miel ajres:',
	'requestaccount-reqtype' => 'Pozishan:',
	'requestaccount-level-0' => 'aata',
	'requestaccount-level-1' => 'edita',
	'requestaccount-bio' => 'Persnal bayagrafi:',
	'requestaccount-attach' => 'Rizume ar CV (apshanal):',
	'requestaccount-notes' => 'Adishanal nuot:',
	'requestaccount-urls' => 'Lis a websait, ef eni (separiet wid nyuu lain):',
	'requestaccount-agree' => 'Yu fi soertifai se yu riil niem karek ahn se yu agrii tu wi Toerm a Saabis.',
	'requestaccount-inuse' => 'Yuuzaniem aredi ina yuus ina pendin akount rikwes.',
	'requestaccount-tooshort' => 'Yu bayagrafi fi bi akliis $1 {{PLURAL:$1|wod|wod}} lang.',
	'requestaccount-emaildup' => 'Aneda pendin akount rikwes yuuz di siem e-miel ajres.',
	'requestaccount-exts' => 'Atachment fail taip no lou.',
	'requestaccount-resub' => 'Yu CV/rizume fail afi rii-silek fi sikioriti riizn.
Lef di fiil blangk ef yu no waahn fi inkluud wan agen.',
	'requestaccount-tos' => 'Mi riid ahn grii fi abaid bai di [[{{MediaWiki:Requestaccount-page}}|Toerm a Saabis]] a {{SITENAME}}.
Di niem mi spesifai anda "Riil niem" a mi riil niem fi chuu.',
	'requestaccount-submit' => 'Rikwes akount',
	'requestaccount-sent' => 'Yu akount rikwes sen soksesfuli ahn nou pendin rivyuu.
A kanfamieshan rivyuu sen tu yu e-miel ajres.',
	'request-account-econf' => 'Yu e-miel ajres kanfoerm ahn wi lis az soch ina yu akount rejista.',
	'requestaccount-email-subj' => '{{SITENAME}} e-miel ajres kanfamieshan',
	'requestaccount-email-body' => 'Smadi, prabli yu frahn IP ajres $1, rikwes a akount "$2" wid dis e-miel ajres pahn {{SITENAME}}.

Fi kanfoerm se dis akount riili bilangx tu yu pahn {{SITENAME}}, opn dis lingk ina yu brouza:

$3

Ef di akount kriet, onngl yu wi get e-miel wid di paaswod.
Ef dis a *no* yu, no fala di lingk.
Dis kanfamieshan kuod wi expaya a $4.',
	'requestaccount-email-subj-admin' => '{{SITENAME}} akount rikwes',
	'requestaccount-email-body-admin' => '"$1" rikwes a akount ahn a wiet fi kanfamieshan.
Di e-miel ajres kanfoerm. Yu kiahn kanfoerm di rikwes yaso "$2".',
	'acct_request_throttle_hit' => 'Sari yu aredi rikwes {{PLURAL:$1|1 akount|$1 akount}}.
Yu kyaahn mek no muo rikwes.',
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
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Sovichet
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'requestaccount' => 'សំណើសុំគណនី',
	'requestaccount-page' => '{{ns:project}}:លក្ខខណ្ឌ ប្រើប្រាស់សេវា',
	'requestaccount-dup' => "'''សម្គាល់: លោកអ្នកត្រូវបានកត់ឈ្មោះចូលរួចហើយ ជាមួយនឹងគណនីដែលបានចុះឈ្មោះ។'''",
	'requestaccount-leg-user' => 'គណនីអ្នកប្រើប្រាស់',
	'requestaccount-leg-areas' => 'ចំណង់ចំណូលចិត្ត',
	'requestaccount-leg-person' => 'ព័ត៌មានផ្ទាល់ខ្លួន',
	'requestaccount-leg-other' => 'ព័ត៌មានផ្សេងទៀត',
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
	'requestaccount-urls' => 'បញ្ជីវិបសាយ បើមាន (ចែកគ្នាដោយការចុះបន្ទាត់)៖',
	'requestaccount-agree' => 'អ្នកត្រូវតែបញ្ជាក់ថា ឈ្មោះពិតរបស់អ្នកត្រឹមត្រូវ និងថាអ្នកព្រមព្រៀងជាមួយ «លក្ខខណ្ឌប្រើប្រាស់សេវាកម្ម» នេះ ។',
	'requestaccount-tooshort' => 'ជីវប្រវត្តិរបស់អ្នកត្រូវតែមានយ៉ាងតិច $1 ពាក្យ។',
	'requestaccount-tos' => 'ខ្ញុំបានអាននិងយល់ព្រមជាមួយ[[{{MediaWiki:Requestaccount-page}}|លក្ខខណ្ឌប្រើប្រាស់សេវាកម្ម]] របស់ {{SITENAME}}។
ឈ្មោះដែលខ្ញុំបានផ្ដល់អោយនៅក្រោម «ឈ្មោះពិត» គឺពិតជាឈ្មោះពិតរបស់ខ្ញុំផ្ទាល់មែន។',
	'requestaccount-submit' => 'សំណើសុំគណនី',
	'requestaccount-email-subj' => 'ការបញ្ជាក់ទទួលស្គាល់ អាសយដ្ឋានអ៊ីមែល {{SITENAME}}',
	'requestaccount-email-subj-admin' => 'សំណើសុំគណនីរបស់{{SITENAME}}',
	'acct_request_throttle_hit' => 'សូមអភ័យទោស។ អ្នកបានស្នើសុំ {{PLURAL:$1|១ គណនី|$1 គណនី}} រួចហើយ។

អ្នកមិនអាចធ្វើការស្នើសុំទៀតបានទេ។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'requestaccount-leg-person' => 'ವೈಯುಕ್ತಿಕ ಮಾಹಿತಿ',
	'requestaccount-level-0' => 'ಕರ್ತೃ',
	'requestaccount-level-1' => 'ಸಂಪಾದಕ',
	'requestaccount-email-subj-admin' => '{{SITENAME}} ಖಾತೆ ಕೋರಿಕೆ',
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
);

/** Colognian (Ripoarisch)
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
	'requestaccount-tos' => 'Esch han jelesse, wat op dä Sigg „[[{{MediaWiki:Requestaccount-page}}|{{int:requestaccount-leg-tos}}]]“ övver {{GRAMMAR:Akkusativ|{{SITENAME}}}} shteiht, Un esch versescheren, dat wad esch unger „reschtijje Name“ aanjejovve hann, wörklesch minge reschtijje Name es.',
	'requestaccount-submit' => 'Noh enem Zojang als ene Metmaacher frore',
	'requestaccount-sent' => 'Ding Aanfrooch es jäz op der Wääsch jebraat, un waadt drop, dat sesch Eine dröm kömmert.
För se ze beschtäätejje, es en <i lang="en">e-mail</i> aan Ding aanjejovve Adräß ongerwähß.',
	'request-account-econf' => 'Ding <i lang="en">e-mail</i>-Addräß es beschtätesch un dat shteiht jetß och esu en Dinge Aanfrooch noh enem Zohjang als Metmaacher dren.',
	'requestaccount-email-subj' => '{{ucfirst:{{GRAMMAR:Genitiv ier feminine|{{SITENAME}}}}}} <i lang="en">e-mail</i>-Addräß Beschtätejung',
	'requestaccount-email-body' => 'Daach,

künnt sin, Do woohß et sellver, jedenfalls hät eine vun dä IP-Address
$1 en Aanfrooch noh enem Zohjang op {{GRAMMAR:Akkusativ|{{SITENAME}}}}
als Metmaacher met däm Name „$2“ jeschtallt.

Jetz wulle mer vun Dier en Beschtäätejung, dat dat all ääsch es,
un dat De dat och sellver wohß, un esu ene Zohjang han wells.
Zom Beschtäätejje, jangk met Dingem Web-Brauser op dä Lengk:

$3

Wann Dinge Zohjang dann ennjerescht wood, kriß Do allein dat
Passwoot doför zohjescheck.

Wann dat alles Kappes es, un De wells jaa nit {{GRAMMAR:em|{{SITENAME}}}}
metmaache, dann donn jaa nix. Aam $5 öm $6 Uhr verfällt dä Lengk
bovve automattesch un vun janz allein.

Ene schööne Jrooß {{GRAMMAR:Genitiv vun|{{SITENAME}}}}',
	'requestaccount-email-subj-admin' => 'Aanfrooch för Metmaacher {{GRAMMAR:von|{{SITENAME}}}} ze wääde.',
	'requestaccount-email-body-admin' => '{{GENDER:$1|Dä|Dat|Dä Metmaacher|Dat|De}} „$1“ well ene Zohjang han un es am waade, dä ze krijje. De aanjejovve <i lang="en">e-mail</i>-Addräß es beschtätesch. Do kanns dämm dä Zohjang jevve op dä Sigg: $2',
	'acct_request_throttle_hit' => 'Deihd uns leid, Do häs {{PLURAL:$1|ald|ald $1 Mohl|jaanit}} noh enem Zohjang jefrooch. Do kanns nit noch mieh Aanfroore enreische.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'requestaccount-leg-user' => 'Hesabê bikarhêner',
);

/** Cornish (Kernowek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'requestaccount-email' => 'Trigva e-bost:',
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
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'requestaccount' => 'Benotzerkont ufroen',
	'requestaccount-text' => "'''Fëllt dëse Formulaire aus a schéckt e fort fir e Benotzerkont unzefroen'''.

Passt op datt Dir d'éischt d'[[{{MediaWiki:Requestaccount-page}}|Conditioune vum Benotze]] gelies hutt éier Dir e Benotzerkont ufrot.

Wann Äre Benotzerkont ugeholl as, kritt Dir eng Informatioun per E-Mail an Dir kënnt Äre Benotzerkont  [[Special:UserLogin|benotzen]].",
	'requestaccount-page' => '{{ns:project}}:Notzungsbedingungen',
	'requestaccount-dup' => "'''Opgepasst: Dir sidd scho matt engem registréierte Benotzerkont ugemellt.'''",
	'requestaccount-leg-user' => 'Benotzerkont',
	'requestaccount-leg-areas' => 'Haaptinteressen',
	'requestaccount-leg-person' => 'Perséinlech Informatiounen',
	'requestaccount-leg-other' => 'Aner Informatiounen',
	'requestaccount-leg-tos' => 'Conditioune vum Gebrauch',
	'requestaccount-acc-text' => 'Esoubal wéi Dir dës Ufro geschéckt hutt kritt Dir e Confirmatiouns-Message op Är E-Mailadress.
Äntwert w.e.g. duerch klicken op de Confirmatiouns-Link deen an där Mail drasteet.
Och Äert Passwuert gëtt Iech gemailt esoubal wéi Äre Benotzerkonnt ugeluecht gouf.',
	'requestaccount-areas-text' => 'Wielt déi Sujeten aus an denen Dir formaalt Fachwëssen huet oder an deem Dir am léifste schaffe wëllt.',
	'requestaccount-ext-text' => "Dës Informatioune gi vertraulech behandelt a gi just fir dës Ufro benotzt.
Dir kënnt Kontaktinformatiounen wéi eng Telefonsnummer uginn fir d'Identitéitskonfirmatioun ze vereinfachen.",
	'requestaccount-bio-text' => 'Versicht all néideg Informatiounen an Ärer Biographie hei drënner unzeginn.',
	'requestaccount-bio-text-i' => "'''Är Biografie gëtt als éischt Versioun vun Ärer Benotzersäit verëffentlecht.'''
Iwwerleet Iech ob Dir domat averstan sidd datt esou Informatiounen iwwer Iech verëffentlecht ginn.",
	'requestaccount-real' => 'Richtegen Numm:',
	'requestaccount-same' => "(d'selwecht wéi de richtegen Numm)",
	'requestaccount-email' => 'E-mail-Adress:',
	'requestaccount-reqtype' => 'Positioun:',
	'requestaccount-level-0' => 'Auteur',
	'requestaccount-level-1' => 'Editeur',
	'requestaccount-bio' => 'Perséinlech Biographie (nëmmen Text):',
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
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Homo
 * @author Tomasdd
 */
$messages['lt'] = array(
	'requestaccount-leg-user' => 'Naudotojo paskyra',
	'requestaccount-leg-person' => 'Asmeninė informacija',
	'requestaccount-leg-other' => 'Kita informacija',
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
	'requestaccount-dup' => "'''Напомена: Веќе се најавени со регистрирана сметка.'''",
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
	'requestaccount-bio-text' => 'По можност во биографијата подолу вклучете и препораки или уверенија.',
	'requestaccount-bio-text-i' => "'''Вашата биографија ќе стои како првична содржина на корисничката страница.'''
Размислете дали сакате да се објавуваат вакви информации за вас.",
	'requestaccount-real' => 'Вистинско име:',
	'requestaccount-same' => '(исто како вистинско име)',
	'requestaccount-email' => 'Е-поштенска адреса:',
	'requestaccount-reqtype' => 'Позиција:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'уредник',
	'requestaccount-bio' => 'Лична биографија (само прост текст):',
	'requestaccount-attach' => 'Резиме или CV (не е задолжително):',
	'requestaccount-notes' => 'Други забелешки:',
	'requestaccount-urls' => 'Список на мрежни места, ако ги има (се пишуваат во посебен ред):',
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
	'requestaccount-email-body' => 'Некој, веројатно Вие од IP-адресата $1, на {{SITENAME}} побарал сметка „$2“ со оваа е-поштенска адреса.

За да потврдите дека оваа сметка на {{SITENAME}} навистина ви припаѓа Вам, отворете ја врскава во прелистувачот:

$3

Ако сметката е создадена, само Вие ќе ја добиете лозинката по е-пошта.
Доколку тоа *не* сте Вие, не отворајте ја врската.
Овој потврден код истекува во $4.',
	'requestaccount-email-subj-admin' => 'Барање за сметка на {{SITENAME}}',
	'requestaccount-email-body-admin' => '„$1“ побара сметка и чека потврда.
Е-поштенската адреса е потврдена. Можете да го потврдите барањето тука „$2“.',
	'acct_request_throttle_hit' => 'Жалам, но веќе имате побарано {{PLURAL:$1|1 сметка|$1 сметки}}.
Не можете да поставувате повеќе барања.',
);

/** Malayalam (മലയാളം)
 * @author Jacob.jose
 * @author Junaidpv
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'requestaccount' => 'അംഗത്വത്തിനായി അഭ്യർത്ഥിക്കുക',
	'requestaccount-page' => '{{ns:project}}:സേവനത്തിന്റെ നിബന്ധനകൾ',
	'requestaccount-dup' => "'''കുറിപ്പ്: താങ്കൾ ഒരു രെജിസ്റ്റേർഡ് അംഗത്വം ഉപയോഗിച്ച് ഇതിനകം ലോഗിൻ ചെയ്തിട്ടുണ്ട്.'''",
	'requestaccount-leg-user' => 'ഉപയോക്തൃഅംഗത്വം',
	'requestaccount-leg-areas' => 'താല്പര്യമുള്ള പ്രധാന മേഖലകൾ',
	'requestaccount-leg-person' => 'വ്യക്തിഗത വിവരങ്ങൾ',
	'requestaccount-leg-other' => 'മറ്റ് വിവരങ്ങൾ',
	'requestaccount-leg-tos' => 'സേവനവ്യവസ്ഥകൾ',
	'requestaccount-acc-text' => 'ഈ അഭ്യർത്ഥന സമർപ്പിക്കപ്പെട്ടതിനു ശേഷം താങ്കളുടെ ഇമെയിൽ വിലാസത്തിലേക്ക് ഒരു സ്ഥിരീകരണമെയിൽ അയക്കുന്നതായിരിക്കും. പ്രസ്തുത ഇമെയിലിലുള്ള സ്ഥിരീകരണലിങ്കിൽ ഞെക്കി പ്രതികരിക്കുക. അംഗത്വം സൃഷ്ടിക്കപ്പെട്ടതിനു ശേഷം താങ്കളുടെ രഹസ്യവാക്കും ഇമെയിലിൽ അയക്കുന്നതായിരിക്കും.',
	'requestaccount-real' => 'യഥാർത്ഥ പേര്:',
	'requestaccount-same' => '(യഥാർത്ഥ പേരുതന്നെ)',
	'requestaccount-email' => 'ഇമെയിൽ വിലാസം:',
	'requestaccount-reqtype' => 'സ്ഥാനം:',
	'requestaccount-level-0' => 'ലേഖകൻ',
	'requestaccount-level-1' => 'എഡിറ്റർ',
	'requestaccount-bio' => 'വ്യക്തിഗത വിവരങ്ങൾ:',
	'requestaccount-attach' => 'റെസ്യൂം അല്ലെങ്കിൽ സിവി (ഓപ്ഷണൽ):',
	'requestaccount-notes' => 'കൂടുതൽ കുറിപ്പുകൾ:',
	'requestaccount-urls' => 'വെബ്ബ്സൈറ്റുകളുടെ പട്ടിക (ഓരോന്നും വെവ്വേറെ വരിയിൽ കൊടുക്കുക):',
	'requestaccount-agree' => 'താങ്കളുടെ പേരു യഥാർത്ഥമാണെന്നും, താങ്കൾ ഞങ്ങളുടെ നയങ്ങളും പരിപാടികളും അംഗീകരിക്കുന്നു എന്നും പ്രതിജ്ഞ ചെയ്യണം.',
	'requestaccount-inuse' => 'സ്ഥിരീകരണം കാത്തിരിക്കുന്ന അഭ്യർത്ഥനകളിൽ ഒന്ന് ഇതേ ഉപയോക്തൃനാമം ഉപയോഗിക്കുന്നുണ്ട്.',
	'requestaccount-tooshort' => 'താങ്കളുടെ ആത്മകഥയിൽ കുറഞ്ഞത് {{PLURAL:$1|ഒരു വാക്ക്|$1 വാക്കുകൾ}} വേണം.',
	'requestaccount-emaildup' => 'സ്ഥിരീകരണം കാത്തിരിക്കുന്ന അഭ്യർത്ഥനകളിൽ ഒന്ന് ഇതേ ഇമെയിൽ വിലാസം ഉപയോഗിക്കുന്നുണ്ട്.',
	'requestaccount-exts' => 'അറ്റാച്ച് ചെയ്ത പ്രമാണ തരം അനുവദനീയമല്ല.',
	'requestaccount-submit' => 'അംഗത്വത്തിനായി അഭ്യർത്ഥിക്കുക',
	'requestaccount-email-subj' => '{{SITENAME}} സം‌രംഭത്തിലെ ഇമെയിൽ വിലാസ സ്ഥിരീകരണം',
	'requestaccount-email-subj-admin' => '{{SITENAME}} സം‌രംഭത്തിൽ അംഗത്വം സൃഷ്ടിക്കാനുള്ള അഭ്യർത്ഥന',
	'requestaccount-email-body-admin' => '"$1" ന്റെ അംഗത്വത്തിനായുള്ള അപേക്ഷ സ്ഥിരീകരണത്തിനായി കാത്തിരിക്കുന്നു. ഇമെയിൽ വിലാസം ഇതിനകം സ്ഥിരീകരിക്കപ്പെട്ടിരിക്കുന്നു. ഈ അപേക്ഷ താങ്കൾക്ക് ഇവിടെ "$2" സ്ഥിരീകരിക്കാവുന്നതാണ്‌.',
	'acct_request_throttle_hit' => 'ക്ഷമിക്കുക, താങ്കൾ ഇതിനകം {{PLURAL:$1|അംഗത്വത്തിനായി|$1 അംഗത്വങ്ങൾക്കായി}} അഭ്യർത്ഥിച്ചു കഴിഞ്ഞു.
ഇനി കൂടുതൽ അഭ്യർത്ഥന നടത്തുന്നതു അനുവദനീയമല്ല.',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'requestaccount' => 'खाते मागवा',
	'requestaccount-text' => "'''खाते तयार करण्यासाठी खालील अर्ज भरून पाठवा'''.

अर्ज पाठविण्यापूर्वी तुम्ही [[{{MediaWiki:Requestaccount-page}}|अटी व नियम]] वाचलेले असल्याची खात्री करा.

एकदा का खाते तयार झाले की तुम्हाला तसा विपत्र संदेश येईल व तुम्ही [[Special:UserLogin]] मध्ये प्रवेश करू शकाल.",
	'requestaccount-page' => '{{ns:project}}:अटी व नियम',
	'requestaccount-dup' => "'''सूचना: तुम्ही अगोदरच नोंदीकृत खात्यामधून प्रवेश केलेला आहे.'''",
	'requestaccount-leg-user' => 'सदस्य खाते',
	'requestaccount-leg-areas' => 'मुख्य पसंती',
	'requestaccount-leg-person' => 'वैयक्तिक माहिती',
	'requestaccount-leg-other' => 'इतर माहिती',
	'requestaccount-leg-tos' => 'सेवेच्या अटी',
	'requestaccount-acc-text' => 'ही मागणी पूर्ण झाल्यावर तुमच्या इमेल पत्त्यावर एक संदेश येईल. कृपया त्या संदेशात दिलेल्या दुव्यावर टिचकी मारुन सदस्य खात्याची खात्री करा. खाते तयार झाल्यावर परवलीचा शब्द तुमच्या इमेल वर पाठविला जाईल.',
	'requestaccount-areas-text' => 'खालील क्षेत्रांपैकी तुमच्या पसंतीचे तसेच तुम्ही जाणकार असलेले विषय निवडा.',
	'requestaccount-ext-text' => 'खालील माहिती ही गोपनीय असेल व फक्त या मागणी करताच वापरली जाईल.
तुम्ही ओळख पटविण्यासाठी एखादा संपर्क क्रमांक देऊ शकता.',
	'requestaccount-bio-text' => 'तुमची वैयक्तिक माहिती तुमच्या सदस्य पानावर दिसेल.
काही विशेष उल्लेखनीय कामगिरी असल्यास ती वाढविण्याचा प्रयत्न करा.
तसेच ही माहिती प्रकाशित करण्यास तुमची हरकत नाही हे तपासून पहा.',
	'requestaccount-real' => 'खरे नाव:',
	'requestaccount-same' => '(खर्‍या नावा प्रमाणेच)',
	'requestaccount-email' => 'विपत्र पत्ता:',
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
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'requestaccount' => 'Mohon akaun',
	'requestaccount-text' => "'''Lengkapkan dan serahkan borang yang berikut untuk memohon akaun pengguna'''.

Pastikan anda sudah membaca [[{{MediaWiki:Requestaccount-page}}|Syarat-Syarat Perkhidmatan]] terlebih dahulu sebelum memohon akaun.

Sebaik sahaja akaun anda diluluskan, anda akan diberi e-mel makluman dan akaun itu akan boleh digunakan selepas anda [[Special:UserLogin|log masuk]].",
	'requestaccount-page' => '{{ns:project}}:Syarat-Syarat Perkhidmatan',
	'requestaccount-dup' => "'''Perhatian: Anda sudah log masuk dengan akaun berdaftar.'''",
	'requestaccount-leg-user' => 'Akaun pengguna',
	'requestaccount-leg-areas' => 'Bidang-bidang yang paling diminati',
	'requestaccount-leg-person' => 'Maklumat peribadi',
	'requestaccount-leg-other' => 'Maklumat lain',
	'requestaccount-leg-tos' => 'Syarat-Syarat Perkhidmatan',
	'requestaccount-acc-text' => 'Satu pesanan pengesahan akan dihantar ke alamat e-mel anda sebaik sahaja permohonan ini diserahkan.
Sila balas dengan mengklik pautan pengesahan yang diberikan dalam e-mel.
Selain itu, kata laluan anda akan die-melkan kepada anda apabila akuan anda dibuka.',
	'requestaccount-areas-text' => 'Pilih bidang-bidang topik yang anda mempunyai kepakaran formal atau ingin paling banyak usahakan di bawah.',
	'requestaccount-ext-text' => 'Maklumat berikut dirahsiakan dan digunakan untuk permohonan ini sahaja.
Mungkin anda ingin menyenaraikan maklumat hubungan seperti nombor telefon untuk memudahkan proses pengesahan identiti.',
	'requestaccount-bio-text' => 'Cuba sertakan sebarang bukti kelayakan yang berkaitan dalam biografi anda di bawah.',
	'requestaccount-bio-text-i' => "'''Biografi anda akan ditetapkan sebagai kandungan permulaan laman pengguna anda.'''
Pastikan anda berasa selesa untuk menerbitkan maklumat sedemikian.",
	'requestaccount-real' => 'Nama sebenar:',
	'requestaccount-same' => '(sama dengan nama sebenar di bawah)',
	'requestaccount-email' => 'Alamat e-mel:',
	'requestaccount-reqtype' => 'Kedudukan:',
	'requestaccount-level-0' => 'pengarang',
	'requestaccount-level-1' => 'penyunting',
	'requestaccount-bio' => 'Biografi peribadi (teks biasa sahaja):',
	'requestaccount-attach' => 'Resume atau CV (pilihan):',
	'requestaccount-notes' => 'Catatan tambahan:',
	'requestaccount-urls' => 'Senarai tapak web, jika ada (setiap satu dalam baris berasingan):',
	'requestaccount-agree' => 'Anda mesti memperakui bahawa nama sebenar anda adalah tepat dan anda bersetuju dengan Syarat-Syarat Perkhidmatan kami.',
	'requestaccount-inuse' => 'Nama pengguna sudah dipakai dalam satu permohonan akaun yang menunggu.',
	'requestaccount-tooshort' => 'Biografi anda mestilah sekurang-kurangnya mengandungi $1 patah perkataan.',
	'requestaccount-emaildup' => 'E-mel yang diberikan sudah dipakai dalam satu permohonan akaun yang menunggu.',
	'requestaccount-exts' => 'Jenis fail lampiran tidak dibenarkan.',
	'requestaccount-resub' => 'Fail CV/resume anda mesti dipilih semula atas sebab-sebab keselamatan.
Biarkan ruangan ini kosong jika anda tidak ingin melampirkan apa-apa.',
	'requestaccount-tos' => 'Saya telah membaca dan bersetuju untuk mematuhi [[{{MediaWiki:Requestaccount-page}}|Syarat-Syarat Perkhidmatan]] {{SITENAME}}.
Nama yang saya nyatakan dalam ruangan "Nama sebenar" sememangnya nama sebenar saya sendiri.',
	'requestaccount-submit' => 'Mohon akaun',
	'requestaccount-sent' => 'Permohonan akaun anda berjaya dihantar dan sedang menunggu untuk dikaji.
	Satu pesanan e-mel pengesahan telah dihantar ke alamat e-mel anda.',
	'request-account-econf' => 'Alamat e-mel anda telah disahkan dan akan disenaraikan dalam permohonan akaun anda.',
	'requestaccount-email-subj' => 'Pengesahan alamat e-mel {{SITENAME}}',
	'requestaccount-email-body' => 'Seseorang, mungkin anda dari alamat IP $1, telah memohon akaun "$2" dengan alamat e-mel ini di {{SITENAME}}.

Untuk mengesahkan bahawa akaun ini benar-benar milik anda di {{SITENAME}}, buka pautan berikut dalam pelayar anda:

$3

Jika akaun ini dibuka, hanya anda yang akan diberi kata laluan melalui e-mel.
Jika ini *bukan* anda, jangan ikut pautan ini.
Kod pengesahan ini akan luput pada $4.',
	'requestaccount-email-subj-admin' => 'Permohonan akaun {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" telah memohon akaun dan sedang menunggu pengesahan.
Alamat e-mel ini telah disahkan. Anda boleh mengesahan permohonan di sini "$2".',
	'acct_request_throttle_hit' => 'Maaf, anda sudah memohon {{PLURAL:$1|1 akaun|$1 akaun}}.
Anda tidak boleh membuat permohonan lagi.',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'requestaccount-real' => 'Алкуксонь леметь:',
	'requestaccount-same' => '(истямо кода алкуксонь лемесь)',
	'requestaccount-level-0' => 'теицязо',
	'requestaccount-level-1' => 'витницязо-петницязо',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'requestaccount-leg-user' => 'Tlatequitiltilīlli cuentah',
	'requestaccount-real' => 'Melāhuac motōcā:',
	'requestaccount-level-0' => 'chīhualōni',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
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
	'requestaccount-bio-text' => 'Ta med alle kunnskaps- og ferdighetsrelevante detaljer i biografien din under.',
	'requestaccount-bio-text-i' => "'''Biografien din blir satt som startinnholdet for brukersiden din.'''
Forsikre deg om at du synes det er greit å publisere denne informasjonen.",
	'requestaccount-real' => 'Virkelig navn:',
	'requestaccount-same' => '(samme som virkelig navn)',
	'requestaccount-email' => 'E-postadresse:',
	'requestaccount-reqtype' => 'Stilling:',
	'requestaccount-level-0' => 'forfatter',
	'requestaccount-level-1' => 'redaktør',
	'requestaccount-bio' => 'Personlig biografi (kun ren tekst):',
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
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'requestaccount-leg-user' => 'Brukerkonto',
	'requestaccount-real' => 'Echten Naam:',
	'requestaccount-email' => 'E-Mail-Adress:',
	'requestaccount-bio' => 'Biografie:',
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
	'requestaccount-leg-person' => 'Persoonlijke gegevens',
	'requestaccount-leg-other' => 'Overige informatie',
	'requestaccount-leg-tos' => 'Gebruiksvoorwaarden',
	'requestaccount-acc-text' => 'U ontvangt een e-mailbevestiging als uw aanvraag is ontvangen.
Reageer daar op door te klikken op de verwijzing die in de e-mail staat.
U krijgt een wachtwoord als uw gebruiker is aangemaakt.',
	'requestaccount-areas-text' => 'Selecteer hieronder de onderwerpen waarmee u ervaring hebt of waarvan u het meeste werk wil verrichten.',
	'requestaccount-ext-text' => 'De volgende informatie wordt vertrouwelijk behandeld en wordt alleen gebruikt voor deze aanvraag.
U kunt contactgegevens zoals een telefoonummer opgeven om te helpen bij het vaststellen van uw identiteit.',
	'requestaccount-bio-text' => 'Probeer uw belangrijkste gegevens op te nemen.',
	'requestaccount-bio-text-i' => "'''Deze tekst wordt gebruikt voor uw gebruikerspagina.'''
Zorg ervoor dat u hier gegevens noteert die gepubliceerd mogen worden.",
	'requestaccount-real' => 'Uw naam:',
	'requestaccount-same' => '(gelijk aan uw naam)',
	'requestaccount-email' => 'E-mailadres:',
	'requestaccount-reqtype' => 'Positie:',
	'requestaccount-level-0' => 'auteur',
	'requestaccount-level-1' => 'redacteur',
	'requestaccount-bio' => 'Persoonlijke biografie (alleen platte tekst):',
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
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'requestaccount-real' => 'Leina la nnete:',
	'requestaccount-email' => 'Atrese ya email:',
	'requestaccount-level-0' => 'mongwadi',
	'requestaccount-level-1' => 'morulaganyi',
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
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'requestaccount-level-0' => 'автор',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Aalam
 */
$messages['pa'] = array(
	'requestaccount' => 'ਅਕਾਊਂਟ ਬੇਨਤੀ',
	'requestaccount-page' => '{{ns:project}}: ਸਰਵਿਸ ਦੀਆਂ ਸ਼ਰਤਾਂ',
	'requestaccount-dup' => "'''ਨੋਟ: ਤੁਸੀਂ ਪਹਿਲਾਂ ਹੀ ਰਜਿਸਟਰ ਹੋਏ ਅਕਾਊਂਟ ਨਾਲ ਲਾਗ ਹੋ ਚੁੱਕੇ ਹੋ।'''",
	'requestaccount-leg-user' => 'ਯੂਜ਼ਰ ਅਕਾਊਂਟ',
	'requestaccount-leg-areas' => 'ਦਿਲਚਸਪੀ ਦੇ ਖਾਸ ਖੇਤਰ',
	'requestaccount-leg-person' => 'ਨਿੱਜੀ ਜਾਣਕਾਰੀ',
	'requestaccount-leg-other' => 'ਹੋਰ ਜਾਣਕਾਰੀ',
	'requestaccount-leg-tos' => 'ਸਰਵਿਸ ਦੀਆਂ ਸ਼ਰਤਾਂ',
	'requestaccount-real' => 'ਅਸਲੀ ਨਾਂ:',
	'requestaccount-same' => '(ਅਸਲੀ ਨਾਂ ਵਾਂਗ ਹੀ)',
	'requestaccount-email' => 'ਈਮੇਲ ਐਡਰੈੱਸ:',
	'requestaccount-reqtype' => 'ਸਥਿਤੀ:',
	'requestaccount-level-0' => 'ਲੇਖਕ',
	'requestaccount-level-1' => 'ਐਡੀਟਰ',
	'requestaccount-bio' => 'ਨਿੱਜੀ ਜਾਣਕਾਰੀ:',
	'requestaccount-notes' => 'ਹੋਰ ਨੋਟ:',
	'requestaccount-inuse' => 'ਯੂਜ਼ਰ ਨਾਂ ਪਹਿਲਾਂ ਹੀ ਅਕਾਊਂਟ ਬੇਨਤੀ ਲਈ ਵਰਤਿਆ ਜਾ ਰਿਹਾ ਹੈ।',
	'requestaccount-submit' => 'ਅਕਾਊਂਟ ਬੇਨਤੀ',
	'requestaccount-email-subj' => '{{SITENAME}} ਈਮੇਲ ਐਡਰੈੱਸ ਪੁਸ਼ਟੀ',
	'requestaccount-email-subj-admin' => '{{SITENAME}} ਅਕਾਊਂਟ ਮੰਗ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'requestaccount-level-0' => 'Schreiwer',
	'requestaccount-level-1' => 'Schreiwer',
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
	'requestaccount-bio-text' => 'Spróbuj zawrzeć w swojej poniższej biografii wszelkie istotne informacje.',
	'requestaccount-bio-text-i' => "'''Twoja biografia zostanie zamieszczona jako początkowa zawartość Twojej strony użytkownika.'''
Upewnij się, czy na pewno chcesz opublikować te informacje.",
	'requestaccount-real' => 'Imię i nazwisko:',
	'requestaccount-same' => '(prawdziwe imię i nazwisko)',
	'requestaccount-email' => 'Adres e‐mail:',
	'requestaccount-reqtype' => 'Stanowisko:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'redaktor',
	'requestaccount-bio' => 'Autobiografia (wyłącznie czysty tekst):',
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
	'requestaccount-bio-text' => "Ch'a preuva a buté dj'arferiment ùtij an soa biografìa sì-sota.",
	'requestaccount-bio-text-i' => "'''Soa biografìa a sarà ampostà com contnù inissial për soa pàgina utent.'''
Ch'as sicura d'esse content ëd publiché cole anformassion.",
	'requestaccount-real' => 'Nòm vèir:',
	'requestaccount-same' => '(istess che sò nòm vèir)',
	'requestaccount-email' => 'Adrëssa ëd pòsta eletrònica:',
	'requestaccount-reqtype' => 'Posission:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografìa përsonal (mach test sempi):',
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
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'requestaccount' => 'د ګڼون غوښتنه',
	'requestaccount-leg-user' => 'ګڼون',
	'requestaccount-leg-person' => 'ځاني مالومات',
	'requestaccount-leg-other' => 'نور مالومات',
	'requestaccount-real' => 'اصلي نوم:',
	'requestaccount-email' => 'برېښليک پته:',
	'requestaccount-level-0' => 'ليکوال',
	'requestaccount-bio' => 'شخصي ژوندليک (يوازې ساده متن):',
	'requestaccount-tooshort' => 'ستاسې ژوندليک بايد لږ تر لږه $1 {{PLURAL:$1|ويی|وييونه}} اوږد وي.',
	'requestaccount-submit' => 'د ګڼون غوښتنه',
	'requestaccount-email-subj-admin' => 'د {{SITENAME}} د ګڼون غوښتنه',
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
	'requestaccount-text' => "'''Complete e envie o seguinte formulário para pedir uma conta de utilizador'''.

Certifique-se de que lê primeiro os [[{{MediaWiki:Requestaccount-page}}|Termos de Serviço]] antes de pedir uma conta.

Assim que a conta for aprovada, ser-lhe-á enviada uma mensagem de notificação por correio electrónico e poderá [[Special:UserLogin|autenticar-se]].",
	'requestaccount-page' => '{{ns:project}}:Termos de Serviço',
	'requestaccount-dup' => "'''Nota: Já está autenticado com uma conta registada.'''",
	'requestaccount-leg-user' => 'Conta de utilizador',
	'requestaccount-leg-areas' => 'Principais áreas de interesse',
	'requestaccount-leg-person' => 'Informação pessoal',
	'requestaccount-leg-other' => 'Outras informações',
	'requestaccount-leg-tos' => 'Termos de Serviço',
	'requestaccount-acc-text' => 'Será enviada uma mensagem de confirmação para o seu endereço de correio electrónico assim que este pedido for submetido. Por favor, responda clicando o link de confirmação enviado na mensagem. A sua palavra-chave também será enviada por correio electrónico assim que a conta tenha sido criada.',
	'requestaccount-areas-text' => 'Seleccione abaixo as áreas em que possui experiência formal ou em que mais gostaria de trabalhar.',
	'requestaccount-ext-text' => 'A seguinte informação será mantida privada e só será usada para este pedido.
Talvez possa listar contactos, tais como o número de telefone, para ajudar na confirmação da identificação.',
	'requestaccount-bio-text' => 'Tente incluir todas as credenciais relevantes na sua biografia abaixo.',
	'requestaccount-bio-text-i' => "'''A sua biografia será definida como o conteúdo inicial da sua página de utilizador.'''
Certifique-se de que pretende publicar esta informação.",
	'requestaccount-real' => 'Nome real:',
	'requestaccount-same' => '(igual ao nome real)',
	'requestaccount-email' => 'Endereço de correio electrónico:',
	'requestaccount-reqtype' => 'Posição:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografia pessoal (só texto):',
	'requestaccount-attach' => 'Currículo (opcional):',
	'requestaccount-notes' => 'Notas adicionais:',
	'requestaccount-urls' => 'Lista de sites na internet, se algum (um por linha):',
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
	'requestaccount-email-body' => 'Alguém, provavelmente você a partir do endereço IP $1, solicitou uma conta "$2" com este endereço de correio electrónico na {{SITENAME}}.

Para confirmar que esta conta realmente lhe pertence na {{SITENAME}}, siga este link no seu browser:

$3

Se a conta for criada, a palavra-chave só será enviada a si. Se este pedido *não* foi feito por si, não siga o link.
Este código de confirmação irá expirar às $6 de $5.',
	'requestaccount-email-subj-admin' => 'Pedido de conta na {{SITENAME}}',
	'requestaccount-email-body-admin' => '"$1" pediu uma conta e aguarda confirmação.
O endereço electrónico foi confirmado. Pode confirmar o pedido aqui "$2".',
	'acct_request_throttle_hit' => 'Desculpe, mas já pediu {{PLURAL:$1|uma conta|$1 contas}}.
Não pode fazer mais pedidos.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Helder.wiki
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
	'requestaccount-leg-person' => 'Informações pessoais',
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
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'requestaccount-real' => 'Ism n dṣṣaḥ :',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'requestaccount' => 'Solicitare deschidere cont',
	'requestaccount-text' => "'''Completează și aplică următorul formular pentru a cere deschiderea unui cont de utilizator'''.

Asigură-te că ai citit [[{{MediaWiki:Requestaccount-page}}|Termenii]] înainte de a cere deschiderea unui cont.

După ce contul va fi aprobat, vei fi anunțat printr-un mesaj trimis prin e-mail, iar contul va putea fi accesat apelând [[Special:UserLogin|autentificare]].",
	'requestaccount-page' => '{{ns:project}}:Termeni',
	'requestaccount-dup' => "'''Notă: Sunteţi deja autentificat cu un cont înregistrat.'''",
	'requestaccount-leg-user' => 'Cont de utilizator',
	'requestaccount-leg-areas' => 'Arii principale de interes',
	'requestaccount-leg-person' => 'Informații personale',
	'requestaccount-leg-other' => 'Alte informații',
	'requestaccount-leg-tos' => 'Termenii serviciului',
	'requestaccount-bio-text' => 'Încercați să includeți orice acreditări relevante în biografia dumneavoastră, mai jos.',
	'requestaccount-real' => 'Nume real:',
	'requestaccount-same' => '(același cu numele real)',
	'requestaccount-email' => 'Adresă e-mail:',
	'requestaccount-reqtype' => 'Poziție:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-bio' => 'Biografie personală (numai text simplu):',
	'requestaccount-attach' => 'CV (opțional):',
	'requestaccount-notes' => 'Note adiționale:',
	'requestaccount-agree' => 'Trebuie să certifici că numele tău real este corect introdus și că accepți Termenii Serviciului.',
	'requestaccount-inuse' => 'Numele de utilizator este deja folosit într-o cerere de deschidere de cont în așteptare.',
	'requestaccount-tooshort' => 'Biografia ta trebuie să conțină cel puțin $1 {{PLURAL:$1|cuvânt|cuvinte}}.',
	'requestaccount-tos' => 'Am citit și accept să respect [[{{MediaWiki:Requestaccount-page}}|Termenii]] sitului {{SITENAME}}.
Numele pe care l-am introdus în câmpul "Nume real" este numele meu real.',
	'requestaccount-submit' => 'Solicitare deschidere cont',
	'request-account-econf' => 'Adresa ta de e-mail a fost confirmată și va fi listată în cererea de deschidere de cont.',
	'requestaccount-email-subj' => '{{SITENAME}} confirmare adresă e-mail',
	'requestaccount-email-body' => 'Cineva, probabil tu de la adresa IP $1, a cerut deschiderea unui cont "$2" cu această adresă de e-mail în {{SITENAME}}.

Pentru a confirma că într-adevăr adresa întrodusă în {{SITENAME}} îți aparține, deschide legătura următoare în programul tău de navigare pe internet:

$3

Dacă acest cont a fost creat, doar ție îți va fi trimisă parola.
Dacă acest mesaj nu-ți este destinat, nu deschide legătura.
Codul de confirmare expiră în $4.',
	'requestaccount-email-body-admin' => '"$1" a cerut deschiderea unui cont și așteaptă confirmarea.
Adresa de e-mail a fost confirmată. Poți confirma cererea aici "$2".',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Kaganer
 * @author Kv75
 * @author Lockal
 * @author MaxSem
 * @author Rubin
 * @author Sasha Blashenkov
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
	'requestaccount-bio-text' => 'Попробуйте включить любые соответствующие полномочия в вашей биографии ниже.',
	'requestaccount-bio-text-i' => "'''Ваша биография будет размещена на вашей личной странице.'''
Убедитесь, что вы не возражаете против публикации этих сведений.",
	'requestaccount-real' => 'Настоящее имя:',
	'requestaccount-same' => '(такая же как и настоящее имя)',
	'requestaccount-email' => 'Электронная почта:',
	'requestaccount-reqtype' => 'Должность:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'редактор',
	'requestaccount-bio' => 'Личная биография (только обычный текст):',
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
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'requestaccount-reqtype' => 'Позіція:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'едітор',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'requestaccount' => 'Бэлиэтэниллибит аат',
	'requestaccount-text' => "'''Ааты бэлиэтииргэ манна баар форманы толор уонна ыыт.'''

Ыытыаҥ иннинэ бука диэн [[{{MediaWiki:Requestaccount-page}}|Өҥө оҥоруу усулуобуйатын]] аах.

Талбыт аатыҥ бигэргэтилиннэҕинэ электроннай почтаҕар биллэрии кэлиэҕэ, оччоҕо ол аатынан [[Special:UserLogin|киирэр]] кыахтаныаҥ.",
	'requestaccount-page' => '{{ns:project}}:Өҥө оҥоруутун усулуобуйата',
	'requestaccount-dup' => "'''Биллэрии: Эн бэлиэтэммит аатынан хайыы үйэ киирбит эбиккин.'''",
	'requestaccount-leg-user' => 'Бэлиэ аат',
	'requestaccount-leg-areas' => 'Кэрэхсиир хайысхаларыҥ',
	'requestaccount-leg-person' => 'Тус бэйэҥ туһунан',
	'requestaccount-leg-other' => 'Атын сибидиэнньэлэр',
	'requestaccount-leg-tos' => 'Туһаныы сиэрэ',
	'requestaccount-acc-text' => 'Сайаапка ыыппытыҥ кэннэ эн аадырыскар бигэргэтэр ыйытыктаах сурук кэлиэ. 
Онно баар сигэн баттаатаххына сайаапкаҥ бигэргэниэ. 
Ол кэнниттэн киирии тылыҥ эмиэ электроннай почтанан кэлиэ.',
	'requestaccount-areas-text' => 'Үчүгэйдик билэр, үлэлиэххин баҕарар хайысхаларгын (эйгэлэргин) тал.',
	'requestaccount-ext-text' => 'Манна ыйбыт сибидиэнньэлэриҥ туора дьоҥҥо көстүөхтэрэ суоҕа уонна бу сайаапканы көрөргө эрэ туһаныллыахтара.
Эн буоларгын бигэргэтэр ситим көрүҥнэрин, холобур төлөппүөнүҥ нүөмэрин, этиэххин сөп.',
	'requestaccount-real' => 'Дьиҥнээх аатыҥ:',
	'requestaccount-same' => '(дьиҥнээх аатыҥ курдук)',
	'requestaccount-email' => 'Электроннай почтаҥ:',
	'requestaccount-reqtype' => 'Дуоһунаһыҥ:',
	'requestaccount-level-0' => 'ааптар',
	'requestaccount-level-1' => 'эрэдээктэр',
	'requestaccount-bio' => 'Олоҕуҥ олуктара (көннөрү тиэксинэн):',
	'requestaccount-attach' => 'Резюме (булгуччута суох):',
	'requestaccount-notes' => 'Эбии этиилэр:',
	'requestaccount-urls' => 'Ситим-сирдэр тиһиктэрэ, баар буоллаҕына (устуруока аайы биирдии):',
	'requestaccount-agree' => 'Аатыҥ сөпкө суруллубутун бигэргэт уонна Өҥө оҥоруу усулуобуйатын кытта сөбүлэһэргин биллэр.',
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
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'requestaccount-leg-user' => 'Кориснички налог',
	'requestaccount-leg-areas' => 'Главне сфере интересовања',
	'requestaccount-leg-person' => 'Лични подаци',
	'requestaccount-leg-other' => 'Други подаци',
	'requestaccount-leg-tos' => 'Услови коришћења',
	'requestaccount-real' => 'Право име:',
	'requestaccount-same' => '(истоветно правом имену)',
	'requestaccount-email' => 'Е-адреса:',
	'requestaccount-reqtype' => 'Положај:',
	'requestaccount-level-0' => 'аутор',
	'requestaccount-level-1' => 'уређивач',
	'requestaccount-info' => '(?)',
	'requestaccount-bio' => 'Лична биографија (само прост текст):',
	'requestaccount-attach' => 'Резиме или радна биографија (необавезно):',
	'requestaccount-notes' => 'Додатне напомене:',
	'requestaccount-urls' => 'Списак вебсајтова, ако их има (одвојени новим линијама):',
	'requestaccount-agree' => 'Морате да потврдите да сте добро унели своје право име и да се сложите са условима коришћења.',
	'requestaccount-inuse' => 'Корисничко име је већ у употреби и чека на одобрење.',
	'requestaccount-tooshort' => 'Ваша биографија мора да садржи најмање $1 {{PLURAL:$1|реч|речи}}.',
	'requestaccount-emaildup' => 'Исту адресу користи други захтев за налог који је на чекању.',
	'requestaccount-sent' => 'Ваш захтев за налогом је успешно послат и чека на преглед.
Електронска порука за потврду је послата на Вашу адресу Ваше електронске поште.',
	'request-account-econf' => 'Ваша е-адреса је потврђена и биће наведена као таква у вашем захтеву за налог.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-el'] = array(
	'requestaccount-leg-user' => 'Korisnički nalog',
	'requestaccount-leg-areas' => 'Glavne sfere interesovanja',
	'requestaccount-leg-person' => 'Lični podaci',
	'requestaccount-leg-other' => 'Druge informacije',
	'requestaccount-leg-tos' => 'Uslovi korišćenja',
	'requestaccount-real' => 'Pravo ime:',
	'requestaccount-same' => '(istovetno pravom imenu)',
	'requestaccount-email' => 'E-pošta:',
	'requestaccount-reqtype' => 'Pozicija:',
	'requestaccount-level-0' => 'autor',
	'requestaccount-level-1' => 'editor',
	'requestaccount-info' => '(?)',
	'requestaccount-bio' => 'Lična biografija (samo prost tekst):',
	'requestaccount-attach' => 'Rezime ili CV (neobavezno):',
	'requestaccount-notes' => 'Dodatne napomene:',
	'requestaccount-urls' => 'Spisak vebsajtova, ako ih ima (odvojeni novim linijama):',
	'requestaccount-agree' => 'Morate da potvrdite da ste dobro uneli svoje pravo ime i da se složite sa uslovima korišćenja.',
	'requestaccount-inuse' => 'Korisničko ime je već u upotrebi i čeka na odobrenje.',
	'requestaccount-tooshort' => 'Vaša biografija mora da sadrži najmanje $1 {{PLURAL:$1|reč|reči}}.',
	'requestaccount-emaildup' => 'Drugi nalog, koji čeka odobrenje, već koristi ovu imejl adresu.',
	'requestaccount-sent' => 'Vaš zahtev za nalogom je uspešno poslat i čeka na pregled.
Elektronska poruka za potvrdu je poslata na Vašu adresu Vaše elektronske pošte.',
	'request-account-econf' => 'Vaša imejl adresa je bila potvrđena i biće prikazana kao takva u Vašem zahtevu za nalogom.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'requestaccount' => 'Benutserkonto fräigje',
	'requestaccount-text' => "'''Fäl dät foulgjende Formular uut un ferseend dät, uum n Benutserkonto tou fräigjen'''.

	Läs eerste do [[{{MediaWiki:Requestaccount-page}}|Nutsengsbedingengen]] eer du n Benutserkonto fräigest.

	Sobolde dät Konto bestäätiged wuude, krichst du per E-Mail Beskeed un du koast die [[{{ns:special}}:Userlogin|anmäldje]].",
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
	'requestaccount-areas-text' => 'Wääl do Themengebiete uut, in do du dät maaste Fäkwieten hääst of wier du ap maaste involvierd weese skääst.',
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
	'requestaccount-tooshort' => 'Dien Biographie skuul mindestens $1 Woude loang weese.',
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
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Diupwijk
 * @author Fluff
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 * @author WikiPhoenix
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
	'requestaccount-bio-text' => 'Försök att ange relevanta meriter och referenser i biografin nedan.',
	'requestaccount-bio-text-i' => "'''Din biografi kommer att anges som det ursprungliga innehållet för din användarsida.'''
Se till att du känner dig bekväm med att publicera sådan information.",
	'requestaccount-real' => 'Riktigt namn:',
	'requestaccount-same' => '(samma som ditt riktiga namn)',
	'requestaccount-email' => 'E-postadress:',
	'requestaccount-reqtype' => 'Ställning:',
	'requestaccount-level-0' => 'författare',
	'requestaccount-level-1' => 'redaktör',
	'requestaccount-bio' => 'Personlig biografi (oformaterad text):',
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
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 */
$messages['ta'] = array(
	'requestaccount-leg-user' => 'பயனர் கணக்கு',
	'requestaccount-leg-other' => 'மற்ற தகவல்',
	'requestaccount-real' => 'உண்மைப் பெயர்:',
	'requestaccount-email' => 'மின்னஞ்சல் முகவரி:',
	'requestaccount-reqtype' => 'இடம்:',
	'requestaccount-level-0' => 'ஆசிரியர்',
	'requestaccount-level-1' => 'பதிப்பாசிரியர்',
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
	'requestaccount-bio-text' => 'కింది మీ జీవిత విశేషాల్లో సంబంధిత క్రెడేన్షియళ్ళను చేర్చండి.',
	'requestaccount-bio-text-i' => "'''మీ జీవిత విశేషాలే మీ వాడుకరిపేజీకి తొలి పలుకులుగా సెట్ చేస్తాం.'''
అలాంటి సమాచారాన్ని ప్రచురించడంలో మొహమాట పడకండి.",
	'requestaccount-real' => 'అసలు పేరు:',
	'requestaccount-same' => '(వాస్తవిక పేరు ఏదో అదే)',
	'requestaccount-email' => 'ఈమెయిలు చిరునామా:',
	'requestaccount-reqtype' => 'స్థానము:',
	'requestaccount-level-0' => 'రచయిత',
	'requestaccount-level-1' => 'సంపాదకులు',
	'requestaccount-bio' => 'వ్యక్తిగత జీవిత విశేషాలు (మామూలు టెక్స్టు మాత్రమే) :',
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
	'requestaccount-sent' => 'ఈ ఖాతా అభ్యర్థనని విజయవంతంగా పంపించాం మరియు అది ఇప్పుడు సమీక్షకై వేచివుంది.
మీ ఈమెయిలు చిరునామాకి ఒక నిర్ధారణ సందేశాన్ని పంపించాం.',
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
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'requestaccount-email' => 'Diresaun korreiu eletróniku:',
	'requestaccount-level-0' => 'autór',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
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
);

/** Tajik (Latin script) (tojikī)
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
	'requestaccount-bio-text' => 'Subukang isama ang anumang kaugnay na mga kredensyal sa loob ng iyong talambuhay sa ibaba.',
	'requestaccount-bio-text-i' => "'''Ang talambuhay mo ay itatakda bilang pansimulang nilalaman para sa pahina mo ng tagagamit.'''
Tiyaking maginhawa ang pakiramdam mo sa paglalathala ng ganyang kabatiran.",
	'requestaccount-real' => 'Totoong pangalan:',
	'requestaccount-same' => '(katulad ng totoong pangalan)',
	'requestaccount-email' => 'Adres ng e-liham:',
	'requestaccount-reqtype' => 'Katungkulan:',
	'requestaccount-level-0' => 'may-akda',
	'requestaccount-level-1' => 'patnugot',
	'requestaccount-bio' => 'Pansariling talambuhay (payak na teksto lamang):',
	'requestaccount-attach' => 'Buod ng mga karanasan sa hanapbuhay (maaaring wala nito):',
	'requestaccount-notes' => 'Karagdagang mga tala:',
	'requestaccount-urls' => 'Talaan ng mga websayt, kung mayroon (ihiwalay na may bagong mga guhit):',
	'requestaccount-agree' => 'Dapat mong patunayan na tama ang tunay mong pangalan at pumapayag ka sa aming Mga Patakaran ng Paglilingkod.',
	'requestaccount-inuse' => 'Ginagamit na ang pangalan ng tagagamit sa isang naghihintay na paghiling ng akawt.',
	'requestaccount-tooshort' => 'Ang talambuhay mo ay dapat na hindi bababa sa $1 {{PLURAL:$1|salita|mga salita}} ang haba.',
	'requestaccount-emaildup' => 'Isang naghihintay na kahilingan ng akawnt ang gumagamit ng katulad na adres ng e-liham.',
	'requestaccount-exts' => 'Hindi pinapayagan ang uri ng nakalakip na talaksan',
	'requestaccount-resub' => 'Dapat na muling piliin ang iyong talaan ng karanasan sa hanapbuhay para sa mga kadahilanang pangkaligtasan.
Iwanang walang laman ang hanay kung hindi mo na ninanais magsama ng isa.',
	'requestaccount-tos' => 'Nabasa ko na at sumasang-ayong susundin ang [[{{MediaWiki:Requestaccount-page}}|Mga Patakaran ng Paglilingkod]] ng {{SITENAME}}.
Sa katunayan, ang pangalang tinukoy ko sa ilalim ng "Totoong pangalan" ay ang talagang sarili kong totoong pangalan.',
	'requestaccount-submit' => 'Hilingin ang akawnt',
	'requestaccount-sent' => 'Matagumpay na naipadala ang paghiling mo ng akawnt at naghihintay na ngayon ng pagsusuri.
Nagpadala na ng isang e-liham ng pagpapatotoo sa iyong adres ng e-liham.',
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
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Alex Khimich
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'requestaccount' => 'Запит облікового запису',
	'requestaccount-text' => "'''Заповніть та відправте наступну форму запиту облікового запису'''.

Переконайтеся, що ви прочитали [[{{MediaWiki:Requestaccount-page}}|Умови надання послуг]] перед запитом облікового запису.

Як тільки обліковий запис буде підтверджено, вас буде повідомлено про це електронною поштою і ви зможете [[Special:UserLogin|ввійти до системи]].",
	'requestaccount-page' => '{{ns:project}}:Умови надання послуг',
	'requestaccount-dup' => "'''Примітка: Ви вже ввійшли в систему із зареєстрованого облікового запису.'''",
	'requestaccount-leg-user' => 'Обліковий запис',
	'requestaccount-leg-areas' => 'Головні області зацікавлень',
	'requestaccount-leg-person' => 'Особиста інформація',
	'requestaccount-leg-other' => 'Інша інформація',
	'requestaccount-leg-tos' => 'Умови надання послуг',
	'requestaccount-acc-text' => 'Оскыльки Ви надыслали запит, на Вашу адресу електронної пошти буде надіслано повідомлення з підтвердженням.
Будь ласка, дайте відповідь, натиснувши на підтверджуєче посилання в електронному листі. 
Ваш пароль буде надісланий по електронній пошті після створення облікового запису.',
	'requestaccount-real' => "Справжнє ім'я:",
	'requestaccount-email' => 'Адреса електронної пошти:',
	'requestaccount-reqtype' => 'Посада:',
	'requestaccount-level-0' => 'автор',
	'requestaccount-level-1' => 'редактор',
	'requestaccount-bio' => 'Особиста біографія (тільки звичайний текст):',
	'requestaccount-notes' => 'Додаткова інформація:',
	'requestaccount-tooshort' => 'Ваша біографія повинна містити не менше $1 {{PLURAL:$1|слова|слів}}.',
	'requestaccount-exts' => 'Недозволений тип прикріпленого файлу.',
	'requestaccount-submit' => 'Надіслати запит облікового запису',
	'requestaccount-email-subj-admin' => '{{SITENAME}}: запит облікового запису',
);

/** Urdu (اردو)
 * @author محبوب عالم
 */
$messages['ur'] = array(
	'requestaccount' => 'درخواست برائے کھاتہ',
	'requestaccount-text' => "'''صارف کھاتہ حاصل کرنے کیلئے درج ذیل درخواست کو پُر کرکے بھیج دیں'''۔

کھاتہ کیلئے درخواست دینے سے پہلے [[{{MediaWiki:Requestaccount-page}}|شرائطِ خدمت]] ضرور پڑھیں۔

کھاتہ منظور ہونے کے بعد، آپ کو خبرداری پیغام برقی ڈاک کے ذریعے بھیج دیا جائے گا اور کھاتہ [[Special:UserLogin|درنوشتہ]] پر استعمال کے قابل ہوگا۔",
	'requestaccount-dup' => "'''یاددہانی: آپ پہلے سے ایک درج شدہ کھاتہ سے داخلِ نوشتہ ہوچکے ہیں۔'''",
	'requestaccount-leg-user' => 'صارف کھاتہ',
	'requestaccount-leg-person' => 'ذاتی معلومات',
	'requestaccount-leg-other' => 'دیگر معلومات',
	'requestaccount-leg-tos' => 'شرائطِ خدمت',
	'requestaccount-acc-text' => 'درخواست ارسال ہوتے ہی آپ کے برقی ڈاک پتہ پر ایک تصدیقی پیغام بھیجا جائے گا۔
برائے مہربانی، برقی خط میں دیئے گئے ربط پر جایئے۔
نیز، آپ کا کھاتہ بننے کے بعد آپ کا پارلفظ آپ کو برقی ڈاک کے ذریعے بھیج دیا جائے گا۔',
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
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'requestaccount-level-0' => 'מחבר',
);

/** Cantonese (粵語) */
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
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenxiaoqino
 * @author Hydra
 * @author Kuailong
 * @author Mark85296341
 * @author Wilsonmess
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'requestaccount' => '请求账户',
	'requestaccount-text' => "'''完成并递交下述表格，以请求用户账户'''。

请确认您在请求账户之前，预先阅读过[[{{MediaWiki:Requestaccount-page}}|服务细则]]。

一旦该账户获得批准，您将会收到一个电邮通知信息，该账户就可以在[[Special:UserLogin|登录页面]]中使用。",
	'requestaccount-page' => '{{ns:project}}:服务条款',
	'requestaccount-dup' => "'''注意: 您已经登入成一个已注册的账户。'''",
	'requestaccount-leg-user' => '用户账户',
	'requestaccount-leg-areas' => '主要的兴趣范围',
	'requestaccount-leg-person' => '个人信息',
	'requestaccount-leg-other' => '其他信息',
	'requestaccount-leg-tos' => '服务条款',
	'requestaccount-acc-text' => '当完成请求时，一封确认信息会发到您的电邮地址。
	请在该封电邮中点击确认连结去反应它。同时，当您的账户被创建后，您账户的个密码将会电邮给您。',
	'requestaccount-areas-text' => '在下面选择你最专业的或者最感兴趣的话题。',
	'requestaccount-ext-text' => '以下的资料将会保密，而且只是会用在这次请求中。
	您可能需要列示联络资料，像电话号码等去帮助证明您的确认。',
	'requestaccount-bio-text' => '您传记将会设定成在您用户页中的预设内容，尝试包含証明。',
	'requestaccount-bio-text-i' => "'''你的简履将会成为你的用户页的内容。'''
请确保你可以发布该等资讯。",
	'requestaccount-real' => '真实名字:',
	'requestaccount-same' => '（同真实名字）',
	'requestaccount-email' => '电邮地址：',
	'requestaccount-reqtype' => '位置',
	'requestaccount-level-0' => '作者',
	'requestaccount-level-1' => '编辑',
	'requestaccount-bio' => '个人传记（只限纯文字）:',
	'requestaccount-attach' => '简历或履历（可选）：',
	'requestaccount-notes' => '附加注解:',
	'requestaccount-urls' => '网站列表，如有者 （以新行分开）:',
	'requestaccount-agree' => '您一定要证明到您的真实名字是正确的，而且您同意我们的服务细则。',
	'requestaccount-inuse' => '该用户名已经用来请求账户。',
	'requestaccount-tooshort' => '您的传记必须最少有 $1 个字的长度。',
	'requestaccount-emaildup' => '另一个尚未确认的账户已经使用了此电子邮件地址。',
	'requestaccount-exts' => '此类型的文件不允许上传',
	'requestaccount-resub' => '出于安全原因，您的简历或履历必须被重新选择。
若您不想再加入一个，请将此栏留空。',
	'requestaccount-tos' => '我已经阅读以及同意持续遵守{{SITENAME}}的服务细则。',
	'requestaccount-submit' => '请求账户',
	'requestaccount-sent' => '您的账户请求已经成功发出，现正等候复审。
一封验证邮件已经发往您的邮箱，请前去查收。',
	'request-account-econf' => '您的电邮地址已经确认，将会在您的账户口请求中列示。',
	'requestaccount-email-subj' => '{{SITENAME}}电子邮件地址确认',
	'requestaccount-email-body' => '有人，可能是您，由IP地址$1，在{{SITENAME}}中用这个电邮地址请求一个名叫"$2"的账户。

要确认这个户口真的属于在{{SITENAME}}上面?您，就在您的浏览器中度开启这个连结:

$3

如果该账户已经创建，只有您才会收到该电邮密码。如果这个账户*不是*属于您的话，不要点击这个连结。
呢个确认码将会响$4过期。',
	'requestaccount-email-subj-admin' => '{{SITENAME}}账户请求',
	'requestaccount-email-body-admin' => ' "$1" 请求了一个账户并正在等待批准.
电子邮件地址已确认. 要批准账户，请点击 "$2".',
	'acct_request_throttle_hit' => '抱歉，您已经请求了 $1 个账户。
您不可以请求更多个账户。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'requestaccount' => '請求帳戶',
	'requestaccount-text' => "'''完成並遞交以下的表格去請求一個用戶帳戶'''。

請確認您在請求一個帳戶之前，先讀過[[{{MediaWiki:Requestaccount-page}}|服務細則]]。

一旦該帳戶獲得批准，您將會收到一個電郵通知訊息，該帳戶就可以在[[Special:UserLogin|登入頁面]]中使用。",
	'requestaccount-page' => '{{ns:project}}:服務條款',
	'requestaccount-dup' => "'''注意：您已經登入成一個已註冊的帳戶。'''",
	'requestaccount-leg-user' => '使用者帳號',
	'requestaccount-leg-areas' => '感興趣的主要領域',
	'requestaccount-leg-person' => '個人資訊',
	'requestaccount-leg-other' => '其他資訊',
	'requestaccount-leg-tos' => '服務條款',
	'requestaccount-acc-text' => '當完成請求時，一封確認訊息會發到您的電郵位址。
	請在該封電郵中點擊確認連結去回應它。同時，當您的帳戶被創建後，您帳戶的個密碼將會電郵給您。',
	'requestaccount-areas-text' => '在下面選擇你最專業的或者最感興趣的話題。',
	'requestaccount-ext-text' => '以下的資料將會保密，而且只是會用在這次請求中。
	您可能需要列示聯絡資料，像電話號碼等去幫助證明您的確認。',
	'requestaccount-bio-text' => '您傳記將會設定成在您用戶頁中的預設內容，嘗試包含証明。',
	'requestaccount-bio-text-i' => "'''你的簡履將會成為你的用戶頁的內容。'''
請確保你可以發佈該等資訊。",
	'requestaccount-real' => '真實名字：',
	'requestaccount-same' => '（同真實名字）',
	'requestaccount-email' => '電郵地址：',
	'requestaccount-reqtype' => '位置',
	'requestaccount-level-0' => '作者',
	'requestaccount-level-1' => '編輯',
	'requestaccount-bio' => '個人傳記（只限純文字）:',
	'requestaccount-attach' => '簡歷或履歷（可選）：',
	'requestaccount-notes' => '附加註解:',
	'requestaccount-urls' => '網站列表，如有者 （以新行分開）:',
	'requestaccount-agree' => '您一定要證明到您的真實名字是正確的，而且您同意我們的服務細則。',
	'requestaccount-inuse' => '該用戶名已經用來請求帳戶。',
	'requestaccount-tooshort' => '您的傳記必須最少有$1{{PLURAL:$1|字|個字}}的長度。',
	'requestaccount-emaildup' => '另一個尚未確認的帳戶已經使用了此電子郵件位址。',
	'requestaccount-exts' => '此類型的文件不允許上傳',
	'requestaccount-resub' => '出於安全原因，您的簡歷或履歷必須被重新選擇。
若您不想再加入一個，請將此欄留空。',
	'requestaccount-tos' => '我已經閱讀以及同意持續遵守{{SITENAME}}的服務細則。',
	'requestaccount-submit' => '請求帳戶',
	'requestaccount-sent' => '您的帳戶請求已經成功發出，現正等候複審。
一個確認電郵已發送至您的電郵。',
	'request-account-econf' => '您的電郵位址已經確認，將會在您的帳戶口請求中列示。',
	'requestaccount-email-subj' => '{{SITENAME}}電郵位址確認',
	'requestaccount-email-body' => '有人，可能是您，由IP位址$1，在{{SITENAME}}中用這個電郵位址請求一個名叫"$2"的帳戶。

要確認這個戶口真的屬於在{{SITENAME}}上面嘅您，就在您的瀏覽器中度開啟這個連結:

$3

如果該帳戶已經創建，只有您才會收到該電郵密碼。如果這個帳戶*不是*屬於您的話，不要點擊這個連結。
呢個確認碼將會響$4過期。',
	'requestaccount-email-subj-admin' => '{{SITENAME}}帳號請求',
	'requestaccount-email-body-admin' => ' "$1" 請求了一個帳號並正在等待批准.
電子郵件位址已確認. 要批准帳號，請點擊 "$2".',
	'acct_request_throttle_hit' => '抱歉，您已經請求了{{PLURAL:$1|1個|$1個}}帳號。
您不可以請求更多帳號。',
);

