<?php
/**
 * Internationalisation file for ConfirmAccount special page.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
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
	'confirmaccount-confirm'  => 'Use the options below to accept, reject, or hold this request:',
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
	'confirmaccount-badaction' => 'An valid action (accept, reject, hold) must be specified in order to proceed.',
	'confirmaccount-acc'     => 'Account request confirmed successfully;
	created new user account [[User:$1|$1]].',
	'confirmaccount-rej'     => 'Account request rejected successfully.',
	'confirmaccount-viewing' => '(currently being viewed by [[User:$1|$1]])',
	'confirmaccount-summary' => 'Creating user page for new user.',
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
 */
$messages['qqq'] = array(
	'confirmedit-desc' => '{{desc}}',
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
	'confirmaccount-wsum' => 'In the ConfirmAccount extension. This is an edit summary used when a welcome message is automatically placed on the talk pages for new accounts.
{{Identical|Welcome}}',
	'confirmaccount-email-subj' => '{{Identical|SITENAME account request}}',
	'confirmaccount-email-body' => '{{Identical|Your request for an account ...}}',
	'confirmaccount-email-body2' => '{{Identical|Your request for an account ...}}',
	'confirmaccount-email-body3' => 'This message is sent as an email to users when their account request has been denied by an bureaucrat.

*Parameter $1 is the requested account name',
	'confirmaccount-email-body4' => 'This message is sent as an email to users when their account request has been denied by an bureaucrat.

*Parameter $1 is the requested account name
*Parameter $2 is a comment written by the bureaucrat',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'confirmaccount-name' => 'Asa',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'confirmaccount-email-q' => 'Meli hila',
	'confirmaccount-name' => 'Matahigoa he tagata',
	'confirmaccount-email' => 'Meli hila:',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'confirmaccount-real-q' => 'Naam',
	'confirmaccount-email-q' => 'E-pos',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showopen' => 'oop versoeke',
	'confirmaccount-showheld' => 'afgehandelde versoeke',
	'confirmaccount-showexp' => 'vervalle versoeke',
	'confirmaccount-review' => 'Kontroleer',
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
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'confirmaccount-real-q' => 'ስም',
	'confirmaccount-email-q' => 'ኢ-ሜል',
	'confirmaccount-real' => 'ስም:',
	'confirmaccount-email' => 'ኢ-ሜል:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'confirmaccount-real' => 'Nombre:',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-noreason' => '(garra)',
	'confirmaccount-submit' => 'Confirmar',
);

/** Arabic (العربية)
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = array(
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
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'confirmaccount-real-q' => 'ܫܡܐ',
	'confirmaccount-email-q' => 'ܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ',
	'confirmaccount-review' => 'ܬܢܝ',
	'confirmaccount-leg-user' => 'ܚܘܫܒܢܐ ܕܡܦܠܚܢܐ',
	'confirmaccount-leg-person' => 'ܝܕ̈ܥܬܐ ܦܪ̈ܨܘܦܝܬܐ',
	'confirmaccount-leg-other' => 'ܝܕ̈ܥܬܐ ܐܚܪ̈ܢܝܬܐ',
	'confirmaccount-pos-0' => 'ܣܝܘܡܐ',
	'confirmaccount-noreason' => '(ܠܐ ܡܕܡ)',
	'confirmaccount-submit' => 'ܚܬܬ',
	'confirmaccount-wsum' => 'ܒܫܝܢܐ!',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
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
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'confirmaccount-real-q' => 'Ad',
	'confirmaccount-email-q' => 'E-poçt',
	'confirmaccount-bio-q' => 'Bioqrafiya',
	'confirmaccount-leg-other' => 'Digər məlumatlar',
	'confirmaccount-name' => 'İstifadəçi adı',
	'confirmaccount-real' => 'Ad:',
	'confirmaccount-email' => 'E-poçt:',
	'confirmaccount-reqtype' => 'mövqe:',
	'confirmaccount-pos-0' => 'müəllif',
	'confirmaccount-pos-1' => 'redaktor',
	'confirmaccount-bio' => 'Bioqrafiya:',
	'confirmaccount-urls' => 'Vebsaytların siyahısı',
	'confirmaccount-noreason' => '(heç biri)',
	'confirmaccount-hold' => 'Təxirə salmaq',
	'confirmaccount-ip' => 'IP ünvanı:',
	'confirmaccount-submit' => 'Təsdiq et',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'confirmaccount-real' => 'Pangaran',
	'confirmaccount-submit' => 'Kompermaron',
	'confirmaccount-wsum' => 'Dagos!',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'confirmaccount-pos-0' => 'аўтар',
	'confirmaccount-submit' => 'Пацвердзіць',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
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
	'confirmaccount-confirm' => 'Выкарыстоўвайце налады ніжэй для прыняцьця, адхіленьня ці адкладаньня запыту:',
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
	'confirmaccount-badaction' => 'Для працягу мусіць быць абранае адно зь дзеяньняў (прыняць, адхіліць, адкласьці).',
	'confirmaccount-acc' => 'Запыт на стварэньне рахунку пасьпяхова пацьверджаны;
створаны рахунак [[User:$1|$1]].',
	'confirmaccount-rej' => 'Запыт на стварэньне рахунку быў пасьпяхова адхілены.',
	'confirmaccount-viewing' => '(зараз праглядаецца [[User:$1|$1]])',
	'confirmaccount-summary' => 'Стварэньне ўласнай старонкі новага ўдзельніка.',
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
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
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
	'confirmaccount-reject' => '(отказана от [[User:$1|$1]] на $2)',
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
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Ehsanulhb
 * @author Wikitanvir
 * @author Zaheen
 */
$messages['bn'] = array(
	'confirmaccounts' => 'অ্যাকাউন্ট অনুরোধ নিশ্চিত',
	'confirmaccount-none-o' => 'তালিকায় বর্তমানে কোনো খোলা অমীমাংসিত অ্যাকাউন্ট অনুরোধ নেই।',
	'confirmaccount-real-q' => 'নাম',
	'confirmaccount-email-q' => 'ইমেইল',
	'confirmaccount-bio-q' => 'জীবনী',
	'confirmaccount-showopen' => 'অনুরোধ খোলা',
	'confirmaccount-showrej' => 'অনুরোধ পরিত্যক্ত হয়েছে',
	'confirmaccount-showheld' => 'অপেক্ষমাণ অনুরোধসমূহ',
	'confirmaccount-showexp' => 'অনুরোধ মেয়াদোত্তীর্ণ হয়ে গেছে',
	'confirmaccount-review' => 'পর্যবেক্ষণ',
	'confirmaccount-types' => 'নিচ থেকে একটি অ্যাকাউন্ট নিশ্চিতকরণ লাইন নির্বাচন করুন:',
	'confirmaccount-all' => '(সারিতে সব দেখাও)',
	'confirmaccount-type' => 'লাইন:',
	'confirmaccount-q-open' => 'খোলা অনুরোধসমূহ',
	'confirmaccount-q-held' => 'গ্রহণকৃত অনুরোধসমূহ',
	'confirmaccount-q-rej' => 'সাম্প্রতিককালে বাতিলকৃত অনুরোধসমূহ',
	'confirmaccount-q-stale' => 'মেয়াদউত্তীর্ণ অনুরোধসমূহ',
	'confirmaccount-leg-user' => 'ব্যবহারকারী অ্যাকাউন্ট',
	'confirmaccount-leg-areas' => 'আগ্রহের মূল ক্ষেত্র',
	'confirmaccount-leg-person' => 'ব্যক্তিগত তথ্য',
	'confirmaccount-leg-other' => 'অন্যান্য তথ্য',
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
	'confirmaccount-confirm' => 'গ্রহণ, বর্জন, বা অপেক্ষা করতে নিচের অপশনগুলো ব্যবহার করুন:',
	'confirmaccount-econf' => '(নিশ্চিতকৃত)',
	'confirmaccount-reject' => '([[User:$1|$1]] দ্বারা বাতিলকৃত হয়েছে $2টার সময়)',
	'confirmaccount-noreason' => '(কিছু নাই)',
	'confirmaccount-autorej' => 'এই অনুরোধটি নিষ্ক্রিয়তার কারণে স্বয়ংক্রিয়ভাবে বাতিল হয়ে গেছে',
	'confirmaccount-create' => 'গৃহীত (অ্যাকাউন্ট তৈরি)',
	'confirmaccount-deny' => 'বাতিল (তালিকা থেকে বাতিল)',
	'confirmaccount-hold' => 'অপেক্ষমান',
	'confirmaccount-spam' => 'স্প্যাম (ই-মেইল পাঠাবেন না)',
	'confirmaccount-reason' => 'মন্তব্য (ই-মেইলে যোগ করা হবে)',
	'confirmaccount-ip' => 'আইপি ঠিকানা:',
	'confirmaccount-legend' => 'এই অ্যাকাউন্টটি নিশ্চিত/বাতিল করুন',
	'confirmaccount-submit' => 'নিশ্চিত করুন',
	'confirmaccount-needreason' => 'আপনাকে নিচের মন্তব্য বাক্সে অবশ্যই একটি কারণ দিতে হবে।',
	'confirmaccount-canthold' => 'এই অনুরোধটি ইতিমধ্যেই হয় অপেক্ষমান বা অপসারিত।',
	'confirmaccount-rej' => 'অ্যাকাউন্ট অনুরোধ সফলভাবে বাতিল করা হয়েছে।',
	'confirmaccount-viewing' => '(বর্তমানে [[User:$1|$1]]-এর দ্বারা পরিদর্শিত হয়েছে)',
	'confirmaccount-summary' => 'নতুন ব্যবহারকারীর জীবনীসহ পাতা তৈরি',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'confirmaccounts' => 'Kadarnaat ar goulennoù kont',
	'confirmedit-desc' => "Reiñ a ra ar galloud d'ar burevidi da wiriañ rekedoù ar c'hontoù implijer",
	'confirmaccount-maintext' => "'''Implijet e vez ar bajenn-mañ evit kadarnaat ar goulennoù krouiñ kontoù evit ''{{SITENAME}}'''''.

Tri isroll a ya d'ober pep goulenn krouiñ ur gont implijer.
Unan evit ar goulennoù da vezañ pledet ganto, unan evit ar re lakaet a-gostez gant merourien all da c'hortoz muioc'h a ditouroù, hag unan all evit ar goulennoù nac'het nevez zo.

Pa respontit d'ur  goulenn, gwiriit anezhañ pizh ha, diouzh an dro, kadarnait an titouroù zo ennañ.
Miret e vo hoc'h oberiadennoù en ur marilh a-ziforc'h.
Emaoc'h sañset adwelet ivez an obererezh a c'hoarvez amañ en tu all eus ar pezh a rit-c'hwi hoc'h-unan.",
	'confirmaccount-list' => 'A-is emañ roll ar goulennoù krouiñ kontoù a chom da vezañ aprouet.
Ur wezh aprouet pe distaolet ur goulenn e vo tennet a-ziwar ar roll.',
	'confirmaccount-list2' => "A-is emañ roll ar goulennoù distaolet nevez zo a c'hall bezañ diverket ent emgefre goude un nebeud devezhioù. Aprouet e c'hallont c'hoazh bezañ, setu ma c'hallit teuler ur sell war an nac'hadennoù a-raok ma vint diverket.",
	'confirmaccount-list3' => "A-is emañ roll ar goulennoù krouiñ kontoù zo aet d'o zermen; diverket e c'hallfent bezañ ent emgefre a-benn un nebeud deizioù.
Aprouet e c'hallont c'hoazh bezañ.",
	'confirmaccount-text' => "Setu ur goulenn da c'hortoz evit ur gont implijer war '''{{SITENAME}}'''.

Gwiriit pizh an holl ditouroù a-is. Ma aprouit ar goulenn, diuzit ar statud da vezañ roet d'an implijer. Ne sello ket ar c'hemmoù degaset da vuhezskridoù an arload ouzh an daveennoù-pad miret a-raok.

Notit e c'hallit dibab krouiñ ur gont gant un anv all. Na rit se nemet kuit da gaout tabutoù gant anvioù implijerien all.

Mar kuitait ar bajenn-mañ hep kadarnaat pe disteuler ar goulenn e chomo hemañ war c'hortoz.",
	'confirmaccount-none-o' => "N'eus er mare-mañ, er roll, goulenn krouiñ kont digor ebet da c'hortoz.",
	'confirmaccount-none-h' => "N'eus er mare-mañ, er roll, goulenn krouiñ kont ebet da c'hortoz.",
	'confirmaccount-none-r' => "Evit ar mare n'eus ket a c'houlennoù distaolet er roll.",
	'confirmaccount-none-e' => "N'eus er roll, er mare-mañ, goulenn krouiñ kont ebet zo aet d'e dermen.",
	'confirmaccount-real-q' => 'Anv',
	'confirmaccount-email-q' => 'Postel',
	'confirmaccount-bio-q' => 'Levrlennadur',
	'confirmaccount-showopen' => 'rekedoù digor',
	'confirmaccount-showrej' => 'rekedoù distaolet',
	'confirmaccount-showheld' => "goulennoù dalc'het",
	'confirmaccount-showexp' => 'Goulennoù dispredet',
	'confirmaccount-review' => 'Adwelet',
	'confirmaccount-types' => 'Diuzañ ur gont er roll gortoz amañ a-is :',
	'confirmaccount-all' => '(Gwelet an holl rolloù gortoz)',
	'confirmaccount-type' => 'Roll gortoz :',
	'confirmaccount-type-0' => 'oberourien posupl',
	'confirmaccount-type-1' => 'kenoberien posupl',
	'confirmaccount-q-open' => 'rekedoù digor',
	'confirmaccount-q-held' => "goulennoù dalc'het",
	'confirmaccount-q-rej' => 'goulennoù distaolet nevez zo',
	'confirmaccount-q-stale' => 'Goulennoù dispredet',
	'confirmaccount-badid' => "N'eus goulenn ebet da c'hortoz a glot gant an ID roet.
Moarvat eo bet graet war-dro dija.",
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
	'confirmaccount-attach' => 'Diverrañ/CV :',
	'confirmaccount-notes' => 'Notennoù ouzhpenn :',
	'confirmaccount-urls' => "Roll lec'hiennoù web :",
	'confirmaccount-none-p' => "(n'eo ket pourchaset)",
	'confirmaccount-confirm' => "Implijit ar boutonioù amañ dindan da zegemer, nach pe zerc'hel ar goulenn-mañ :",
	'confirmaccount-econf' => '(kadarnaet)',
	'confirmaccount-reject' => "(distaolet gant [[User:$1|$1]] d'an $2)",
	'confirmaccount-rational' => "Abeg roet d'an dud war ar renk",
	'confirmaccount-noreason' => '(hini ebet)',
	'confirmaccount-autorej' => "(distaolet eo bet ar goulenn-mañ ent emgefre abalamour d'an dioberiantiz)",
	'confirmaccount-held' => '(merket "miret" gant [[User:$1|$1]] war $2)',
	'confirmaccount-create' => 'Asantiñ (krouiñ ar gont)',
	'confirmaccount-deny' => 'Disteurel (lemel eus ar roll)',
	'confirmaccount-hold' => 'Mirout',
	'confirmaccount-spam' => 'Strob (na gasit ket posteloù)',
	'confirmaccount-reason' => 'Evezhiadenn (lakaet e vo er postel) :',
	'confirmaccount-ip' => "Chomlec'h IP :",
	'confirmaccount-legend' => "Kadarnaat/nac'hañ ar gont",
	'confirmaccount-submit' => 'Kadarnaat',
	'confirmaccount-needreason' => "Ret eo deoc'h pourchas un abeg er voest amañ dindan.",
	'confirmaccount-canthold' => 'Ar reked-mañ a zo pe kemeret e kont dija, pe dilamet.',
	'confirmaccount-acc' => 'Kardarnaet eo bet ar goulenn kont ;
krouet eo bet ar gont implijer nevez [[User:$1|$1]].',
	'confirmaccount-rej' => 'Distaolet eo bet ar goulenn kont.',
	'confirmaccount-viewing' => '(gwelet gant [[User:$1|$1]] evit bremañ)',
	'confirmaccount-summary' => 'O krouiñ pajenn implijer an implijer nevez gant e vuhezskrid.',
	'confirmaccount-welc' => "'''Degemer mat e ''{{SITENAME}}''!'''
Spi hon eus e kemerot perzh da vat ha mat.
Marteze hoc'h eus c'hoant da lenn ar [[{{MediaWiki:Helppage}}|pajennoù skoazell]].
Adarre, degemer mat ha plijadur deoc'h !",
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
	'confirmaccount-email-body3' => "Ho tigarez met distaolet eo bet ho koulenn evit ar gont \"\$1\" war {{SITENAME}}.

Meur a abeg a c'hall displegañ kement-mañ.
Marteze n'eo ket bet leuniet mat ar furmskrid ganeoc'h, pe n'hoc'h eus ket lakaet a-walc'h a ditouroù. A c'hall bezaén ne glotfe ket ho koulenn gant an dezverkoù rekis ivez.
Gallout a ra bezañ rolloù daremprediñ mwar al lec'hienn a c'hallit mont da welet mar fell deoc'h gouzout hiroc'h diwar-benn dezverkoù ar c'hontoù implijer.",
	'confirmaccount-email-body4' => 'Ho tigarez, distaolet eo bet ho koulenn kont "$1" evit {{SITENAME}}.

$2

Gallout a ra bezañ rolloù daremprediñ a c\'hallit mont da welet mar fell deoc\'h gouzout hiroc\'h diwar-benn dezverkoù rekis ar c\'hontoù implijer.',
	'confirmaccount-email-body5' => "A-raok na c'hallfe ho koulenn kont \"\$1\" bezañ degemeret evit {{SITENAME}} e rankit rein un nebeud titouroù ouzhpenn.

\$2

Gallout a ra bezañ rolloù daremprediñ a c'hallit mont da welet mar fell deoc'h gouzout hiroc'h diwar-benn dezverkoù rekis ar c'hontoù implijer.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'confirmaccounts' => 'Potvrdi zahtjeve za račun',
	'confirmedit-desc' => 'Daje mogućnost birokratima da potvrde zahtjeve za računima',
	'confirmaccount-list' => 'Ispod je spisak zahtjeva za računima koji čekaju na odobravanje.
Jednom podnesen zahtjev koji se odobri ili odbije će se ukloniti sa ovog spiska.',
	'confirmaccount-none-o' => 'Trenutno nema otvorenih zahtjeva na račun na čekanju na ovom spisku.',
	'confirmaccount-none-h' => 'Trenutno nema zadržanih zahtjeva na račun na čekanju na ovom spisku.',
	'confirmaccount-real-q' => 'Ime',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografija',
	'confirmaccount-showopen' => 'otvoreni zahtjevi',
	'confirmaccount-showrej' => 'odbijeni zahtjevi',
	'confirmaccount-showexp' => 'zahtijevi istekli',
	'confirmaccount-review' => 'Pregled',
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
	'confirmaccount-legend' => 'Potvrdi/odbij ovaj račun',
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
);

/** Catalan (Català)
 * @author Loupeter
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
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
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'confirmaccount-submit' => 'پشتدار بکەرەوە',
);

/** Czech (Česky)
 * @author Jkjk
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'confirmaccounts' => 'Potvrdit žádosti o účet',
	'confirmedit-desc' => 'Dává byrokratům možnost potvrzovat žádosti o účet',
	'confirmaccount-none-o' => 'V tomto seznamu nejsou žádné požadavky na schválení vytvořeného účtu.',
	'confirmaccount-none-h' => 'V tomto seznamu nyní nejsou žádné pozastavené žádosti o vytvoření účtu.',
	'confirmaccount-none-r' => 'V tomto seznamu nyní nejsou žádné zamítnuté žádosti o vytvoření účtu.',
	'confirmaccount-none-e' => 'V tomto seznamu nyní nejsou žádné vypršené žádosti o vytvoření účtu.',
	'confirmaccount-real-q' => 'Jméno',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showopen' => 'otevřené žádosti',
	'confirmaccount-showrej' => 'odmítnuté žádosti',
	'confirmaccount-showheld' => 'Zobrazit seznam účtů čekajících na schválení',
	'confirmaccount-showexp' => 'vypršelé žádosti',
	'confirmaccount-review' => 'Schválit/Odmítnout',
	'confirmaccount-types' => 'Vyberte frontu potvrzování účtů:',
	'confirmaccount-all' => '(zobrazit všechny fronty)',
	'confirmaccount-type' => 'Zvolená fronta:',
	'confirmaccount-type-0' => 'budoucí autoři',
	'confirmaccount-type-1' => 'budoucí editoři',
	'confirmaccount-q-open' => 'otevřené žádosti',
	'confirmaccount-q-held' => 'pozastavené žádosti',
	'confirmaccount-q-rej' => 'nedávno zamítnuté žádosti',
	'confirmaccount-q-stale' => 'vypršelé žádosti',
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
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'confirmaccount-pos-0' => 'творь́ць',
);

/** Danish (Dansk)
 * @author Aka-miki
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'confirmaccount-real-q' => 'Navn',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name' => 'Brugernavn',
	'confirmaccount-real' => 'Navn:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-noreason' => '(ingen)',
	'confirmaccount-ip' => 'IP-adresse:',
	'confirmaccount-submit' => 'Bekræft',
	'confirmaccount-wsum' => 'Velkommen!',
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
	'confirmaccounts' => 'Benutzerkontenanträge bestätigen',
	'confirmedit-desc' => 'Ermöglicht es Bürokraten, Benutzerkontenanträge zu bestätigen',
	'confirmaccount-maintext' => "'''Diese Seite dient dazu, wartende Benutzerkontenanträge für ''{{SITENAME}}'' zu bearbeiten.'''

Jede Benutzerkontenwarteschlange besteht aus drei Unterwarteschlangen. Eine für offene Anfrage, eine für Anträge im „abwarten“-Status und eine für kürzlich abgelehnte Anfragen.

Wenn du auf einen Antrag antwortest, überprüfe die Informationen sorgfältig und bestätige die enthaltenen Informationen.
Deine Aktionen werden nichtöffentlich protokolliert. Es wird auch von dir erwartet, die Aktionen anderer zu überprüfen.",
	'confirmaccount-list' => 'Unten findest du eine Liste von noch zu bearbeitenden Benutzerkontoanträgen.
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
	'confirmaccount-confirm' => 'Nutze die folgende Auswahl, um den Antrag zu bestätigen, abzulehnen oder um noch abzuwarten.',
	'confirmaccount-econf' => '(bestätigt)',
	'confirmaccount-reject' => '(abgelehnt durch [[User:$1|$1]] am $2)',
	'confirmaccount-rational' => 'Begründung für den Antragssteller:',
	'confirmaccount-noreason' => '(nichts)',
	'confirmaccount-autorej' => '(dieser Antrag wurde automatisch wegen Inaktivität gestrichen)',
	'confirmaccount-held' => '(markiert als „abwarten“ durch [[User:$1|$1]] am $3 um $4 Uhr)',
	'confirmaccount-create' => 'Bestätigen (Konto anlegen)',
	'confirmaccount-deny' => 'Ablehnen (Antrag löschen)',
	'confirmaccount-hold' => 'Markiert mit „abwarten“',
	'confirmaccount-spam' => 'Spam (keine E-Mail verschicken)',
	'confirmaccount-reason' => 'Begründung (wird in die E-Mail an den Antragsteller eingefügt):',
	'confirmaccount-ip' => 'IP-Adresse:',
	'confirmaccount-legend' => 'Bestätigen/Ablehnen des Antrags',
	'confirmaccount-submit' => 'Bestätigen',
	'confirmaccount-needreason' => 'Du musst eine Begründung eingeben.',
	'confirmaccount-canthold' => 'Dieser Antrag wurde bereits mit „abwarten“ markiert oder gelöscht.',
	'confirmaccount-badaction' => 'Es muss eine gültige Aktion (bestätigen, ablehnen, abwarten) angegeben werden, um fortfahren zu können.',
	'confirmaccount-acc' => 'Benutzerantrag erfolgreich bestätigt; Benutzer [[User:$1|$1]] wurde angelegt.',
	'confirmaccount-rej' => 'Benutzerantrag wurde abgelehnt.',
	'confirmaccount-viewing' => '(wird aktuell angeschaut durch [[User:$1|$1]])',
	'confirmaccount-summary' => 'Die Benutzerseite wird für den neuen Benutzer erstellt.',
	'confirmaccount-welc' => "'''Willkommen bei ''{{SITENAME}}''!'''
Wir hoffen, dass du viele gute Informationen beisteuerst.
Möglicherweise möchtest du zunächst die [[{{MediaWiki:Helppage}}|Ersten Schritte]] lesen.
Nochmal: Willkommen und viel Spaß!",
	'confirmaccount-wsum' => 'Willkommen!',
	'confirmaccount-email-subj' => '[{{SITENAME}}] Antrag auf Benutzerkonto',
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
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
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
	'confirmaccount-confirm' => 'Nutzen Sie die folgende Auswahl, um den Antrag zu bestätigen, abzulehnen oder um noch abzuwarten.',
	'confirmaccount-needreason' => 'Sie müssen eine Begründung eingeben.',
	'confirmaccount-welc' => "'''Willkommen bei ''{{SITENAME}}''!'''
Wir hoffen, dass Sie viele gute Informationen beisteuern.
Möglicherweise möchten Sie zunächst die [[{{MediaWiki:Helppage}}|Ersten Schritte]] lesen.
Nochmal: Willkommen und viel Spaß!",
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
	'confirmaccount-badid' => 'Njejo žedno njedocynjone póžedanje za pódany ID.
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
	'confirmaccount-confirm' => 'Wužyj slědujuce opcije, aby akceptěrował, wótpokazał abo docakał toś to póžedanje:',
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
	'confirmaccount-badaction' => 'Musyš płaśiwu akciju (akceptěrowaś, wótpokazaś, docakaś) pódaś, aby pókšacował.',
	'confirmaccount-acc' => 'Póžedanje na konto wuspěšnje wobkšuśone;
jo se załožyło nowe konto za wužywarja [[User:$1|$1]].',
	'confirmaccount-rej' => 'Póžedanje na konto wuspěšnje wótpokazane.',
	'confirmaccount-viewing' => '(woglědujo se tuchylu wót wužywarja [[User:$1|$1]])',
	'confirmaccount-summary' => 'Napórajo se wužywarski bok za nowego wužywarja.',
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
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'confirmaccount-wsum' => 'Woezɔ loo!',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Egmontaz
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
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
);

/** Esperanto (Esperanto)
 * @author Amikeco
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
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
	'confirmaccounts' => 'Confirmar solicitudes de cuenta',
	'confirmedit-desc' => 'Da a los burócratas la habilidad de confirmar solicitudes de cuenta',
	'confirmaccount-maintext' => "'''Esta página es utilizada para confirmar las solicitudes de cuenta pendientes en ''{{SITENAME}}'''''.

Cada cola de solicitud de cuenta consiste de tres subcolas.
Una para solicitudes abiertas, una para aquellas que han sido retenidas por administradores a la espera de mayor información y una tercera para solicitudes recientemente rechazadas.

Cuando se responda a una solicitud, revísela cuidadosamente y, de ser necesario, confirme la información que contiene en ella.
Sus acciones serán registradas de forma privada.
También se espera que revise cualquier actividad que tome lugar aquí, aparte de lo que usted mismo haga.",
	'confirmaccount-list' => 'Debajo hay una lista de solicitudes de cuenta esperando aprobación.
una vez que una solicitud es tanto aprovada como rechazada se removerá de esta lista.',
	'confirmaccount-list2' => 'A continuación se encuentran las solicitudes recientemente rechazadas, las cuales pueden ser automáticamente eliminadas cuando su antigüedad supera varios días.
Las mismas aún pueden ser aprobadas como cuentas, aunque quizás prefiera consultar primero con el administrador que las ha rechazado antes de aprobarlas.',
	'confirmaccount-list3' => 'A continuación hay una lista de solicitudes de cuenta que han expirado, las mismas pueden ser automáticamente eliminadas una vez que tienen varios días de antigüedad.
Todavía pueden ser aprobadas como cuentas.',
	'confirmaccount-text' => "Esta es una solicitud en espera de una cuenta de usuario en '''{{SITENAME}}'''.

Lee con atención la siguiente información.
Si decides aprobar esta solicitud, utiliza el menú desplegable de posición para establecer el estado de la cuenta del usuario.
Las ediciones hechas a la biografía de la aplicación no afectarán ningún almacenamiento de credenciales permanente.
Ten en cuenta que también puedes elegir crear la cuenta con un nombre de usuario diferente.
Debes elegir esta opción sólo para evitar coincidencias con otros nombres.

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
	'confirmaccount-showheld' => 'solicitudes retenidas',
	'confirmaccount-showexp' => 'solicitudes expiradas',
	'confirmaccount-review' => 'Revisar',
	'confirmaccount-types' => 'Seleccione una cola de confirmación de cuenta de abajo:',
	'confirmaccount-all' => '(mostrar todas las colas)',
	'confirmaccount-type' => 'Cola:',
	'confirmaccount-type-0' => 'autores futuros',
	'confirmaccount-type-1' => 'editores futuros',
	'confirmaccount-q-open' => 'solicitudes abiertas',
	'confirmaccount-q-held' => 'solicitudes retenidas',
	'confirmaccount-q-rej' => 'solicitudes recientemente rechazadas',
	'confirmaccount-q-stale' => 'solicitudes expiradas',
	'confirmaccount-badid' => 'No hay ninguna solicitud pendiente que se corresponda con el ID dado.
Puede que ya haya sido gestionada.',
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
	'confirmaccount-confirm' => 'Utilice las opciones que se presentan a continuación para aceptar, denegar o retener esta solicitud:',
	'confirmaccount-econf' => '(confirmado)',
	'confirmaccount-reject' => '(rechazado por [[User:$1|$1]] en $2)',
	'confirmaccount-rational' => 'Justificación dada al solicitante:',
	'confirmaccount-noreason' => '(ninguna)',
	'confirmaccount-autorej' => '(esta solicitud ha sido automáticamente descartada debido a su inactividad)',
	'confirmaccount-held' => '(Marcado como «en espera» por [[User:$1|$1]] en $2 )',
	'confirmaccount-create' => 'Aceptar (crear cuenta)',
	'confirmaccount-deny' => 'Rechazar (eliminar de lista)',
	'confirmaccount-hold' => 'Mantener',
	'confirmaccount-spam' => 'Spam (no enviar correo electrónico)',
	'confirmaccount-reason' => 'Comentario (será incluido en el correo eectrónico):',
	'confirmaccount-ip' => 'Dirección IP:',
	'confirmaccount-legend' => 'Confirmar/rechazar esta cuenta',
	'confirmaccount-submit' => 'Confirmar',
	'confirmaccount-needreason' => 'Debe proveer una razón en el cuadro de comentario que se presenta a continuación.',
	'confirmaccount-canthold' => 'Esta solicitud ya se encuentra retenida o eliminada.',
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
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
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
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
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
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'confirmaccount-name' => 'Nombri d´usuáriu',
	'confirmaccount-real' => 'Nombri',
	'confirmaccount-wsum' => 'Bienviniu!',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'confirmaccount-real-q' => 'نام',
	'confirmaccount-review' => 'بازبینی',
	'confirmaccount-reqtype' => 'موقعیت:',
	'confirmaccount-pos-1' => 'ویرایشگر',
	'confirmaccount-noreason' => '(هیچ)',
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
	'confirmaccount-legend' => 'Vahvista tai hylkää tämä tili',
	'confirmaccount-submit' => 'Vahvista',
	'confirmaccount-needreason' => 'Alla olevaan huomautuslaatikkoon on kirjoitettava perustelu.',
	'confirmaccount-canthold' => 'Tämä pyyntöf on jo joko pysäytetty tai poistettu.',
	'confirmaccount-acc' => 'Pyynnön vahvistaminen onnistui.
Käyttäjätunnus [[User:$1|$1]] luotiin.',
	'confirmaccount-rej' => 'Pyynnön hylkääminen onnistui.',
	'confirmaccount-viewing' => '(juuri nyt katseltavana käyttäjällä [[User:$1|$1]])',
	'confirmaccount-summary' => 'Luodaan käyttäjäsivu uudelle käyttäjälle.',
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
);

/** French (Français)
 * @author Crochet.david
 * @author Dereckson
 * @author Gomoko
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
	'confirmaccount-confirm' => 'Utilisez les options ci-dessous pour accepter, rejeter ou mettre en attente la demande:',
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
	'confirmaccount-badaction' => 'Une action valide (accepter, refuser, retenir) doit être spécifiée pour continuer.',
	'confirmaccount-acc' => 'La demande de compte a été confirmée avec succès ; création du nouvel utilisateur [[User:$1]].',
	'confirmaccount-rej' => 'La demande a été rejetée avec succès.',
	'confirmaccount-viewing' => "(actuellement en train d'être visionné par [[User:$1|$1]])",
	'confirmaccount-summary' => 'Création de la page utilisateur pour un nouvel utilisateur.',
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
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'confirmaccounts' => 'Confirmar les demandes de comptos usanciér',
	'confirmedit-desc' => 'Balye ux grata-papiérs la possibilitât de confirmar les demandes de comptos usanciér.',
	'confirmaccount-list' => 'Vê-que, ce-desot, la lista des comptos en atenta d’aprobacion.
Los comptos accèptâs seront fêts et pués enlevâs de ceta lista. Los comptos refusâs seront suprimâs de ceta méma lista.',
	'confirmaccount-none-o' => 'Ora, y at gins de demanda de compto usanciér en cors dens ceta lista.',
	'confirmaccount-none-h' => 'Ora, y at gins de resèrvacion de compto usanciér en cors dens ceta lista.',
	'confirmaccount-none-r' => 'Ora, y at gins de novél refus de demanda de compto usanciér dens ceta lista.',
	'confirmaccount-none-e' => 'Ora, y at gins de demanda de compto usanciér èxpirâ dens ceta lista.',
	'confirmaccount-real-q' => 'Nom',
	'confirmaccount-email-q' => 'Adrèce èlèctronica',
	'confirmaccount-bio-q' => 'Biografia',
	'confirmaccount-showopen' => 'demandes uvèrtes',
	'confirmaccount-showrej' => 'Demandes refusâs',
	'confirmaccount-showheld' => 'demandes resèrvâs',
	'confirmaccount-showexp' => 'demandes èxpirâs',
	'confirmaccount-review' => 'Revêre',
	'confirmaccount-all' => '(fâre vêre totes les feles)',
	'confirmaccount-type' => 'Fela :',
	'confirmaccount-type-0' => 'ôtors possiblos',
	'confirmaccount-type-1' => 'contributors possiblos',
	'confirmaccount-q-open' => 'demandes uvèrtes',
	'confirmaccount-q-held' => 'demandes resèrvâs',
	'confirmaccount-q-rej' => 'demandes refusâs dèrriérement',
	'confirmaccount-q-stale' => 'demandes èxpirâs',
	'confirmaccount-leg-user' => 'Compto usanciér',
	'confirmaccount-leg-areas' => 'Centros d’entèrèts principâls',
	'confirmaccount-leg-person' => 'Enformacions a sè',
	'confirmaccount-leg-other' => 'Ôtres enformacions',
	'confirmaccount-name' => 'Nom d’usanciér',
	'confirmaccount-real' => 'Nom :',
	'confirmaccount-email' => 'Mèl. :',
	'confirmaccount-reqtype' => 'Situacion :',
	'confirmaccount-pos-0' => 'ôtor',
	'confirmaccount-pos-1' => 'contributor',
	'confirmaccount-bio' => 'Biografia :',
	'confirmaccount-attach' => 'CV :',
	'confirmaccount-notes' => 'Notes de ples :',
	'confirmaccount-urls' => 'Lista des setos vouèbe :',
	'confirmaccount-none-p' => '(pas montâ)',
	'confirmaccount-econf' => '(confirmâ)',
	'confirmaccount-reject' => '(refusâ per [[User:$1|$1]] lo $2)',
	'confirmaccount-rational' => 'Rêson balyê u candidat :',
	'confirmaccount-noreason' => '(niona)',
	'confirmaccount-create' => 'Aprobacion (fât lo compto)',
	'confirmaccount-deny' => 'Refus (suprime lo compto)',
	'confirmaccount-hold' => 'Resèrvâ',
	'confirmaccount-spam' => 'Spame (mandâd gins de mèssâjo)',
	'confirmaccount-reason' => 'Comentèro (figurerat dens lo mèssâjo) :',
	'confirmaccount-ip' => 'Adrèce IP :',
	'confirmaccount-legend' => 'Confirmar / refusar ceti compto',
	'confirmaccount-submit' => 'Confirmar',
	'confirmaccount-viewing' => '(orendrêt aprés étre vu per [[User:$1|$1]])',
	'confirmaccount-wsum' => 'Benvegnua !',
	'confirmaccount-email-subj' => 'Demanda de compto dessus {{SITENAME}}',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'confirmaccount-real-q' => 'Namme',
	'confirmaccount-name' => 'Meidoggernamme',
	'confirmaccount-real' => 'Namme:',
	'confirmaccount-pos-0' => 'auteur',
	'confirmaccount-pos-1' => 'redakteur',
	'confirmaccount-noreason' => '(gjin)',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'confirmaccount-needreason' => 'Tá ort fáth a chur síos sa bhosca tráchta faoi bhun.',
);

/** Galician (Galego)
 * @author Alma
 * @author Elisardojm
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'confirmaccounts' => 'Confirmar solicitudes de contas',
	'confirmedit-desc' => 'Dá aos burócratas a capacidade de confirmar as solicitudes de contas',
	'confirmaccount-maintext' => "'''Esta páxina úsase para confirmar as solicitudes de contas pendentes en ''{{SITENAME}}''.'''

Cada cola de solicitudes consiste en tres sublistas.
Unha para abrir a solicitude, outra para aquelas que fosen postas por outros administradores en espera de máis información e unha última para as solicitudes rexeitadas recentemente.

Ao responder unha solicitude revísea con coidado e, se é necesario, confirme a información alí contida.
As súas accións quedarán rexistradas de maneira privada.
Agárdase tamén que revise calquera actividade que teña lugar aquí á parte das súas propias.",
	'confirmaccount-list' => 'A continuación está a lista de contas pendentes de aprobación.
As contas aprobadas crearanse e eliminaranse desta lista. As contas rexeitadas simplemente eliminaranse desta lista.',
	'confirmaccount-list2' => 'A continuación está a lista de solicitudes de contas rexeitadas recentemente que poden eliminarse automaticamente unha vez que teñan varios días.
Poden aínda ser aceptadas como contas, aínda que pode ser mellor que consulte primeiro co administrador que as rexeitou antes de facelo.',
	'confirmaccount-list3' => 'A continuación está a lista coas solicitudes de contas que caducaron e que poden ser borradas automaticamente unha vez que teñan uns días.
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
	'confirmaccount-q-open' => 'solicitudes en curso',
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
	'confirmaccount-confirm' => 'Use os botóns inferiores para aceptar, rexeitar ou deixar en suspenso esta solicitude:',
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
	'confirmaccount-badaction' => 'Cómpre especificar unha acción válida (aceptar, rexeitar, reter) para poder continuar.',
	'confirmaccount-acc' => 'Confirmouse sen problemas a solicitude de conta;
creouse a nova conta de usuario "[[User:$1|$1]]".',
	'confirmaccount-rej' => 'Rexeitouse sen problemas a solicitude de conta.',
	'confirmaccount-viewing' => '(actualmente sendo visto por [[User:$1|$1]])',
	'confirmaccount-summary' => 'Creando a páxina do novo usuario.',
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
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
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
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
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
);

/** Gujarati (ગુજરાતી)
 * @author Aksi great
 * @author Ashok modhvadia
 * @author Dineshjk
 * @author Dsvyas
 */
$messages['gu'] = array(
	'confirmaccount-name' => 'સભ્ય નામ:',
	'confirmaccount-summary' => 'નવા સભ્યનાં જીવન વુત્તાંત વાળું સભ્યનું પાનું બનાવી રહ્યા છો',
	'confirmaccount-wsum' => 'સુસ્વાગતમ્',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
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
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'confirmaccount-name' => 'Yung-fu-miàng',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'confirmaccount-real-q' => 'Inoa',
	'confirmaccount-real' => 'Inoa:',
	'confirmaccount-pos-1' => 'luna',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author StuB
 * @author YaronSh
 */
$messages['he'] = array(
	'confirmaccounts' => 'אישור בקשות חשבון',
	'confirmedit-desc' => 'הענקת היכולת לביורוקרטים לאשר בקשות לחשבונות',
	'confirmaccount-maintext' => "'''הדף הזה משמש לאישור בקשות ממתינות לפתוח חשבון באתר {{SITENAME}}'''.

כל בקשה לפתוח חשבון מכילה שלושה תורי־משנה.
אחד לבקשה הפתוחה, אחד לאלה שהטיפול בהם הושהה על־ידי מפעילים אחרים בשל המתנה למידע נוסף, ועוד אחד לבקשות שנדחו לאחרונה.

בזמן מענה לבקשה, יש לסקור אותה בתשומת לב ואם יש בכך צורך לוודא שהמידע בבקשה נכון.
הפעולות שתעשו תירשמנה ביומן פרטי.
כמו־כן, מצופה שתוכלו לסקור גם פעילות של מפעילים אחרים באישור חשבונות.",
	'confirmaccount-list' => 'להלן מופיעה רשימת חשבונות הממתינים לאישור.
לאחר דחייה או אישור של אחת הבקשות היא תוסר מרשימה זו.',
	'confirmaccount-list2' => 'להלן רשימה של בקשות חשבון שנדחו לאחרונה ויימחקו אוטומטית לאחר מספר ימים.
עדיין אפשר לאשר את החשבונות האלה, אבל כדאי לבדוק לפני־כן מדוע המפעיל דחה את הבקשה.',
	'confirmaccount-list3' => 'להלן רשימה של בקשות חשבון שנדחו לאחרונה ויימחקו אוטומטית לאחר מספר ימים.
עדיין אפשר לאשר את החשבונות האלה.',
	'confirmaccount-text' => "יש בקשה ממתינה לחשבון באתר '''{{SITENAME}}'''.

נא לסקור את המידע להלן בעיון.
אם אתם מאשרים את הבקשה, השתמשו בתפריט הנפתח כדי לקבוע את מצב החשבון של המשתמש.
עריכות בקורות החיים בבקשה לא תשפענה על האחסון הקבוע של פרטי הזיהוי.
שימו לב שאפשר ליצור חשבון בשם אחר.
השתמשו בזה רק כדי להימנע מהתנגשויות עם שמות אחרים.

אם אתם פשוט תעזבו את הדף הזה בלי לאשר או לדחות את הבקשה הזאת, הבקשה תישאר בהמתנה.",
	'confirmaccount-none-o' => 'אין כעת בקשות ממתינות לפתוח חשבון ברשימה הזאת.',
	'confirmaccount-none-h' => 'אין כעת בקשות ממתינות מוחזקות לפתוח חשבון ברשימה הזאת.',
	'confirmaccount-none-r' => 'אין כעת בקשות לפתוח חשבון שנדחו לאחרוה ברשימה הזאת.',
	'confirmaccount-none-e' => 'אין כעת בקשות לפתוח חשבון שפג תוקפן ברשימה הזאת.',
	'confirmaccount-real-q' => 'שם',
	'confirmaccount-email-q' => 'דוא"ל',
	'confirmaccount-bio-q' => 'ביוגרפיה',
	'confirmaccount-showopen' => 'בקשות פתוחות',
	'confirmaccount-showrej' => 'בקשות שנדחו',
	'confirmaccount-showheld' => 'בקשות שעוכבו',
	'confirmaccount-showexp' => 'בקשות שפג תוקפן',
	'confirmaccount-review' => 'סקירה',
	'confirmaccount-types' => 'בחירת תור אישור חשבונות מתוך הרשימה להלן:',
	'confirmaccount-all' => '(הצגת כל התורים)',
	'confirmaccount-type' => 'תור:',
	'confirmaccount-type-0' => 'כותבים עתידיים',
	'confirmaccount-type-1' => 'עורכים עתידיים',
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
	'confirmaccount-rational' => 'ההסבר שניתן לפונה:',
	'confirmaccount-noreason' => '(ללא)',
	'confirmaccount-autorej' => '(הבקשה הזאת נמחקה לאור חוסר פעילות)',
	'confirmaccount-held' => '(סומנה להמתנה על ידי [[User:$1|$1]] ב־$2)',
	'confirmaccount-create' => 'אישור (יצירת חשבון)',
	'confirmaccount-deny' => 'דחייה (מחיקת הבקשה)',
	'confirmaccount-hold' => 'עיכוב',
	'confirmaccount-spam' => 'זבל (ללא שליחת הודעה בדוא"ל)',
	'confirmaccount-reason' => 'הערה (תיכלל בהודעת הדוא"ל):',
	'confirmaccount-ip' => 'כתובת IP:',
	'confirmaccount-legend' => 'לאשר / לדחות את זה בחשבון',
	'confirmaccount-submit' => 'אישור',
	'confirmaccount-needreason' => 'יש לספק סיבה בתיבת התגובה למטה.',
	'confirmaccount-canthold' => 'בקשה זו כבר נמצאת בהמתנה או מחוקה.',
	'confirmaccount-acc' => 'בקשת החשבון אושרה בהצלחה; נוצר חשבון משתמש חדש בשם [[User:$1|$1]].',
	'confirmaccount-rej' => 'בקשת החשבון נדחתה בהצלחה.',
	'confirmaccount-viewing' => '(הבקשה נצפית כרגע בידי [[User:$1|$1]])',
	'confirmaccount-summary' => 'יצירת דף משתמש עם ביוגרפיה של משתמש חדש',
	'confirmaccount-welc' => "'''ברוכים הבאים לאתר ''{{SITENAME}}''!'''
אנו מקווים שתרומותיכם יהיו רבות וטובות.
כנראה כדאי שתקראו עכשיו את [[{{MediaWiki:Helppage}}|דפי העזרה]].
ושוב, ברוכים הבאים, תיהנו!",
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
	'confirmaccount-email-body3' => 'סליחה, הבקשה ליצור את החשבון "$1" נדחתה באתר {{SITENAME}}.

יש מספר סיבות אפשריות לכך.
ייתכן שלא מילאתם את הטופס נכון, לא נתתם תשובות באורך הדרוש, או לא עמדתם בתנאי כלשהו שמוגדר במדיניות.
ייתכן שבאתר יש רשימת קשר שאפשר להשתמש בה כדי לברר מידע נוסף על המדיניות הזאת.',
	'confirmaccount-email-body4' => 'סליחה, הבקשה ליצור את החשבון "$1" נדחתה באתר {{SITENAME}}.

$2

ייתכן שבאתר יש רשימת קשר שאפשר להשתמש בה כדי לברר מידע נוסף על המדיניות הזאת.',
	'confirmaccount-email-body5' => 'לפני שהבקשה לחשבון "$1" יכולה לקבל אישור באתר {{SITENAME}}, יש לספק מידע אישי נוסף.

$2

ייתכן שבאתר יש רשימת קשר שאפשר להשתמש בה כדי לברר מידע נוסף על המדיניות הזאת.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Kiranmayee
 * @author आलोक
 */
$messages['hi'] = array(
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
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name' => 'Ngalan sang Manog-gamit',
	'confirmaccount-email' => 'E-mail:',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
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
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
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
	'confirmaccount-confirm' => 'Wužij slědowace opcije, zo by tute požadanje akceptował, wotpokazał abo wočakał:',
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
	'confirmaccount-badaction' => 'Dyrbiš płaćiwu akciju (akceptować, wotpokazać, wočakać) podać, zo by pokročował.',
	'confirmaccount-acc' => 'Požadanje za kontom bu wuspěšnje wobkrućene; konto za wužiwarja [[User:$1|$1]] bu wutworjene.',
	'confirmaccount-rej' => 'Požadanje za kontom bu wotpokazane.',
	'confirmaccount-viewing' => '(wobhladuje so runje wot [[User:$1|$1]])',
	'confirmaccount-summary' => 'Wutworja so wužiwarska strona za noweho wužiwarja.',
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
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Misibacsi
 * @author Tgr
 */
$messages['hu'] = array(
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
	'confirmaccount-legend' => 'Felhasználói fiók elfogadása/visszautasítása',
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
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
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
	'confirmaccount-confirm' => 'Usa le optiones hic infra pro acceptar, rejectar o suspender iste requesta:',
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
	'confirmaccount-badaction' => 'Un action valide (acceptar, refusar, retener) debe esser specificate pro continuar.',
	'confirmaccount-acc' => 'Le requesta de conto ha essite confirmate con successo;
creava nove conto de usator [[User:$1|$1]].',
	'confirmaccount-rej' => 'Le requesta de conto ha essite rejectate con successo.',
	'confirmaccount-viewing' => '(a iste momento in revision per [[User:$1|$1]])',
	'confirmaccount-summary' => 'Crea pagina de usator pro nove usator.',
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
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Rex
 */
$messages['id'] = array(
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
	'confirmaccount-list3' => 'Berikut adalah daftar permintaan akun yang telah kedaluwarsa dan akan dihapus dalam beberapa hari.
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
	'confirmaccount-none-e' => 'Tidak ada permintaan akun yang kedaluwarsa dalam daftar ini.',
	'confirmaccount-real-q' => 'Nama',
	'confirmaccount-email-q' => 'Surel',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'permintaan dalam antrean',
	'confirmaccount-showrej' => 'permintaan ditolak',
	'confirmaccount-showheld' => 'permintaan ditunda',
	'confirmaccount-showexp' => 'permintaan kedaluwarsa',
	'confirmaccount-review' => 'Tinjau',
	'confirmaccount-types' => 'Pilih antrean konfirmasi akun di bawah ini:',
	'confirmaccount-all' => '(tampilkan semua antrean)',
	'confirmaccount-type' => 'Antrean:',
	'confirmaccount-type-0' => 'penulis prospektif',
	'confirmaccount-type-1' => 'penyunting prospektif',
	'confirmaccount-q-open' => 'permintaan dalam antrean',
	'confirmaccount-q-held' => 'permintaan ditunda',
	'confirmaccount-q-rej' => 'permintaan ditolak',
	'confirmaccount-q-stale' => 'permintaan kedaluwarsa',
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
	'confirmaccount-legend' => 'Konfirmasi/menolak akun ini',
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
 * @author Ævar Arnfjörð Bjarmason
 */
$messages['is'] = array(
	'confirmaccounts' => 'Staðfesta notandabeðnir',
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
	'confirmaccount-rej' => 'Notandabeðninni var hafnað.',
	'confirmaccount-wsum' => 'Velkomin!',
	'confirmaccount-email-body4' => 'Beðni þín um aðgang að {{SITENAME}} undir nafninu „$1“ á „$2“ hefur verið hafnað.

$2

Það kann að vera netfang á síðunni sem þú getur haft samband við til að fá frekari upplýsingar.',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
 * @author Stefano-c
 */
$messages['it'] = array(
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
	'confirmaccount-legend' => 'Conferma/respingi questo account',
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
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Schu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'confirmaccounts' => 'アカウント登録申請の承認',
	'confirmedit-desc' => '{{int:group-bureaucrat}} にアカウント申請への承認機能を提供します。',
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
申請された経歴書に重篤な個人情報などが記載されている場合、編集により取り除くことが可能です。ただし、これは一般公開向けのもので、利用者信頼情報の内部保存データには影響を与えません。
申請されたものとは別の利用者名でアカウントを作成することも可能です。
これは、他の利用者と名前が競合する際にのみ行われるべきでしょう。

承認処理を行わず単にページ移動をした場合、または承認しなかった場合、この申請は承認待ちのままとなります。",
	'confirmaccount-none-o' => '現在、申請が受理されていないアカウントはありません。',
	'confirmaccount-none-h' => '現在、申請が承認保留となっているアカウントはありません。',
	'confirmaccount-none-r' => '最近に申請が棄却されたアカウントはありません。',
	'confirmaccount-none-e' => '現在この一覧には期限切れのアカウント申請はありません。',
	'confirmaccount-real-q' => '本名',
	'confirmaccount-email-q' => '電子メールアドレス',
	'confirmaccount-bio-q' => '経歴',
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
	'confirmaccount-email' => '電子メール：',
	'confirmaccount-reqtype' => 'サイトでの役割:',
	'confirmaccount-pos-0' => '著者',
	'confirmaccount-pos-1' => '編集者',
	'confirmaccount-bio' => '経歴：',
	'confirmaccount-attach' => '履歴書／ CV：',
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
	'confirmaccount-reason' => '判断理由(電子メールに記載されます)：',
	'confirmaccount-ip' => 'IPアドレス:',
	'confirmaccount-legend' => 'このアカウントを確認、または拒否する',
	'confirmaccount-submit' => '判断確定',
	'confirmaccount-needreason' => '判断理由を以下に記載する必要があります。',
	'confirmaccount-canthold' => 'この申請は既に保留済みか、削除済みです。',
	'confirmaccount-acc' => 'アカウント申請の承認に成功しました。作成された新しいアカウントは [[User:$1|$1]] です。',
	'confirmaccount-rej' => 'アカウント申請は棄却されました。',
	'confirmaccount-viewing' => '(この申請は、現在[[User:$1|$1]]が受理しています)',
	'confirmaccount-summary' => '申請された経歴を用いた新規利用者ページ作成',
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
);

/** Jamaican Creole English (Patois)
 * @author Yocahuna
 */
$messages['jam'] = array(
	'confirmaccounts' => 'Kanfoerm akount rikwes',
	'confirmedit-desc' => 'Gi biurokratdem di abiliti fi kanfoerm akount rikwes',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
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
	'confirmaccounts' => 'បញ្ជាក់ទទួលស្គាល់ សំណើគណនី',
	'confirmaccount-list' => 'ខាងក្រោមនេះជាបញ្ជីរាយនាមគណនីដែលកំពុងរង់ចាំការអនុម័ត។ ពេលដែលសំនើត្រូវបានយល់ស្របឬបដិសេធ វានឹងត្រូវដកចេញពីបញ្ជីនេះ។',
	'confirmaccount-real-q' => 'ឈ្មោះ',
	'confirmaccount-email-q' => 'អ៊ីមែល',
	'confirmaccount-bio-q' => 'ជីវប្រវត្តិ',
	'confirmaccount-showopen' => 'ការស្នើសុំចំហ',
	'confirmaccount-showrej' => 'ការស្នើសុំត្រូវបានបដិសេធ',
	'confirmaccount-showheld' => 'ការស្នើសុំធ្វើរួចហើយ',
	'confirmaccount-showexp' => 'ការស្នើសុំផុតកំណត់ហើយ',
	'confirmaccount-review' => 'មើលឡើងវិញ',
	'confirmaccount-all' => '(បង្ហាញ គ្រប់ ជួររង់ចាំ)',
	'confirmaccount-type' => 'ជួររង់ចាំ ត្រូវបានជ្រើសយក ៖',
	'confirmaccount-q-open' => 'បើក​សំណើ',
	'confirmaccount-q-held' => 'ការស្នើសុំធ្វើរួចហើយ',
	'confirmaccount-q-rej' => 'ការស្នើសុំដែលត្រូវបានបដិសេដថ្មីៗ',
	'confirmaccount-q-stale' => 'ការស្នើសុំ​ដែល​ផុត​កំណត់',
	'confirmaccount-leg-user' => 'គណនីអ្នកប្រើប្រាស់',
	'confirmaccount-leg-areas' => 'ចំណង់ចំណូលចិត្ត',
	'confirmaccount-leg-person' => 'ព័ត៌មានផ្ទាល់ខ្លួន',
	'confirmaccount-leg-other' => 'ព័ត៌មានផ្សេងទៀត',
	'confirmaccount-name' => 'អត្តនាម',
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
	'confirmaccount-confirm' => 'ប្រើប្រាស់ជំរើសខាងក្រោមដើម្បី យល់ស្រប បដិសេដ ឬ ទុកសំនើសុំនេះមួយអន្លើសិន៖',
	'confirmaccount-econf' => '(បានបញ្ជាក់ទទួលស្គាល់)',
	'confirmaccount-reject' => '(ត្រូវបានបដិសេដដោយ [[User:$1|$1]] នៅ $2)',
	'confirmaccount-noreason' => '(ទទេ)',
	'confirmaccount-held' => '(ត្រូវបានសំគាល់ជា "ទុកមួយអន្លើ" ដោយ [[User:$1|$1]] នៅ $2)',
	'confirmaccount-create' => 'យល់ស្រប (បង្កើត​គណនី)',
	'confirmaccount-deny' => 'បដិសេដ (ដកចេញពីបញ្ជី)',
	'confirmaccount-hold' => 'ទុកមួយអន្លើសិន',
	'confirmaccount-spam' => 'ស្ប៉ាម (កុំផ្ញើអ៊ីមែល)',
	'confirmaccount-reason' => 'យោបល់(នឹងត្រូវបានបញ្ចូលទៅក្នុងអ៊ីមែល)៖',
	'confirmaccount-ip' => 'អាសយដ្ឋាន IP ៖',
	'confirmaccount-legend' => 'បញ្ជាក់ទទួលស្គាល់ឬបដិសេដគណនីនេះ',
	'confirmaccount-submit' => 'បញ្ជាក់ទទួលស្គាល់',
	'confirmaccount-needreason' => 'អ្នក​ត្រូវ​ផ្តល់​ហេតុផល ក្នុង​ប្រអប់វិចារ​ខាងក្រោម​​។',
	'confirmaccount-canthold' => 'សំនើសុំនេះត្រូវបានទុកមួយអន្លើឬលុបចោល។',
	'confirmaccount-acc' => 'សំណើគណនី​ត្រូវ​បាន​បញ្ជាក់ទទួលស្គាល់​ដោយជោគជ័យ,

បាន​បង្កើត​គណនី​អ្នកប្រើប្រាស់​ថ្មី​ហើយ [[User:$1|$1]]​។',
	'confirmaccount-rej' => 'សំណើសុំគណនីបានបដិសេធរួចជាស្រេចហើយ។',
	'confirmaccount-viewing' => '(ពេលនេះ កំពុងមើលដោយ [[User:$1|$1]])',
	'confirmaccount-summary' => 'បង្កើត​ទំព័រ​អ្នកប្រើប្រាស់​ជាមួយ​ប្រវត្តិរូប​នៃ​អ្នកប្រើប្រាស់​ថ្មី​។',
	'confirmaccount-welc' => "'''''{{SITENAME}}'' សូមស្វាគមន៍!'''
យើងខ្ញុំសង្ឃឹមថាអ្នកនឹងជួយរួមចំណែកបានច្រើនជាមួយយើងខ្ញុំ។
ជាដំបូង សូមអ្នកអាន[[{{MediaWiki:Helppage}}|ទំព័រជំនួយជាមុនសិន]]។
សូមចូលរួមដោយរីករាយ។ សូមអរគុណ។",
	'confirmaccount-wsum' => 'សូមស្វាគមន៍!',
	'confirmaccount-email-subj' => 'សំណើសុំគណនី {{SITENAME}}',
	'confirmaccount-email-body' => 'សំណើសុំគណនីរបស់អ្នកនៅលើ{{SITENAME}}ត្រូវបានអនុម័តរួចហើយ។


ឈ្មោះគណនី: $1


ពាក្យសំងាត់: $2


ដើម្បីសុវត្ថិភាព អ្នកនឹងត្រូវតែប្តូរពាក្យសំងាត់របស់អ្នកនៅពេលកត់ឈ្មោះចូលលើកដំបូង។

ដើម្បីកត់ឈ្មោះចូល សូមចូលទៅកាន់ {{fullurl:Special:UserLogin}} ។',
	'confirmaccount-email-body2' => 'សំណើសុំគណនីរបស់អ្នកនៅលើ{{SITENAME}}ត្រូវបានអនុម័តរួចហើយ។


ឈ្មោះគណនី: $1


ពាក្យសំងាត់: $2

$3


ដើម្បីសុវត្ថិភាព អ្នកនឹងត្រូវតែប្តូរពាក្យសំងាត់របស់អ្នកនៅពេលកត់ឈ្មោះចូលលើកដំបូង។

ដើម្បីកត់ឈ្មោះចូល សូមចូលទៅកាន់ {{fullurl:Special:UserLogin}} ។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'confirmaccount-real-q' => 'ಹೆಸರು',
	'confirmaccount-email-q' => 'ಇ-ಅಂಚೆ',
	'confirmaccount-bio-q' => 'ಜೀವನಚರಿತ್ರೆ',
	'confirmaccount-leg-person' => 'ವೈಯುಕ್ತಿಕ ಮಾಹಿತಿ',
	'confirmaccount-real' => 'ಹೆಸರು:',
	'confirmaccount-email' => 'ಇ-ಅಂಚೆ:',
	'confirmaccount-pos-0' => 'ಕರ್ತೃ',
	'confirmaccount-pos-1' => 'ಸಂಪಾದಕ',
	'confirmaccount-bio' => 'ಜೀವನಚರಿತ್ರೆ',
	'confirmaccount-wsum' => 'ಸುಸ್ವಾಗತ!',
	'confirmaccount-email-subj' => '{{SITENAME}} ಖಾತೆ ಕೋರಿಕೆ',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
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
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-email' => 'E-mail:',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'confirmaccounts' => 'Aanfroore noh Metmaacher beschtähtejje',
	'confirmedit-desc' => 'Määt et müjjelesch, dat {{int:group-bureaucrat}} de neu Aanmeldunge beshtätejje.',
	'confirmaccount-maintext' => "'''Die Sigg hee es för unjedonn Aanfroore noh Zohjäng als Metmaacher {{GRAMMAR:Genitiv vun|{{SITENAME}}}} ze beärbeide.'''

Jede Schlang met Aanfroore es ongerdeijlt en drei eije Schlange met dä Zoote: Unjedonn — Zeröckjeschtallt weil mer noch op Antwoote am waade sin — un köözlesch eets afjelehnt.

Wann De en Aanfrooch opnemms, dann loor jenou do dorsch, un wann nüdesch, fengk Beschtätejunge för dat, wat doh aanjejovve es. Wat de määß, dat weed faßjehallde, ävver bliev onger uns. Mer äwaade och vun Der, dat de en Ouch drop häs, wat Andere hee donn.",
	'confirmaccount-list' => 'Hee dronger es en Leß met Aanfroore, di aanjenumme wääde welle.
Wann ene Aanfrooch aanjenumme udder affjelehnt es, kütt se eruß uß dä Leß.',
	'confirmaccount-list2' => 'Hee dronger es en Leß met afjelehnte Aanfroore, di automattesch uß dä Leß eruß kumme, wann se en paa Dääsch alt sin.
Se künne emmer noch aanjenumme wähde, ävver et es wall en joode Idee, eets ens met däm Wiki-Köbes ze kalle, dä se afjelehnt hät.',
	'confirmaccount-list3' => 'Hee dronger es en Leß met ußjeloufe Aanfroore, di automattesch uß dä Leß eruß kumme, wann se en paa Dääsch alt sin.
Se künne ävver emmer noch aanjenumme wähde.',
	'confirmaccount-text' => "Dat es en Aanfrooch noh enem Zohjang als Metmaacher '''op {{GRAMMAR:Akkusativ|{{SITENAME}}}}'''.

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
	'confirmaccount-legend' => 'Dä Zohjang beshtääteje udder afflehne',
	'confirmaccount-submit' => 'Beshtähtejje',
	'confirmaccount-needreason' => 'Do moß ene Jrond en däm Feld unge endraare.',
	'confirmaccount-canthold' => 'Di Aanfrooch es entweder zerökjeshtallt udder fottjeschmeße.',
	'confirmaccount-acc' => 'Di Aanfrooch es aajenumme, un beshtätesch, dä Metmaacher [[User:$1|$1]] wood aanjelaat.',
	'confirmaccount-rej' => 'Di Aanfrooch noh enem Zojang wood afjelehnt.',
	'confirmaccount-viewing' => '(Weet em Momang {{GENDER:$1|vum|vum|vum Metmaacher|vum|vun dä}} [[User:$1|$1]] aanjeloert)',
	'confirmaccount-summary' => 'Ben en Metmaachersigg met dä Levvensdaate vun dämneue Metmaacher am aanlääje.',
	'confirmaccount-welc' => "'''Wellkumme {{GRAMMAR:em|{{SITENAME}}}}!'''
Mer hoffe, Do deihs joot un vill beidraare.
Künnt sin, Do wells de [[{{MediaWiki:Helppage}}|Sigge met Hülp]] lesse.
Norr_ens, wellkumme, un vill Shpaß hee!",
	'confirmaccount-wsum' => 'Wellkumme!',
	'confirmaccount-email-subj' => 'Ding Aanfrooch noh enem Zohjang op {{GRAMMAR:Akkusativ|{{SITENAME}}}}',
	'confirmaccount-email-body' => 'Op Ding Aanfrooch noh enem Zohjang op {{GRAMMAR:Akkusativ|{{SITENAME}}}} es de Antwoot:
Hurra, jetz kanns de erin.

Dinge Name als Metmaacher es „$1“

Ding Passwoot es „$2“

Zor Sescherheit moß De Ding Passwoot ändere, wann De et eehzte Mohl enloggs.
Zom Enlogge, jangk noh {{fullurl:Special:UserLogin}}',
	'confirmaccount-email-body2' => 'Op Ding Aanfrooch häß De enen Zohjang op {{GRAMMAR:Akkusativ|{{SITENAME}}}} krääje.

Dinge Name als Metmaacher es „$1“

Ding Passwoot es „$2“

$3

Zor Sescherheit moß De Ding Passwoot ändere, wann De et eehzte Mohl enloggs.
Zom Enlogge, jangk noh {{fullurl:Special:UserLogin}}',
	'confirmaccount-email-body3' => 'Ding Aanfrooch noh enem Zohjang op {{GRAMMAR:Akkusativ|{{SITENAME}}}}
als Metmaacher met däm Name „$1“ es afjelehnt.

Doh kann et etlijje Jrönd för jevve. De künnts dat Fommulaa verkeht ußjeföllt han,
Ding Antwoote wohre nit jenooch, udder De häs jet jemaat, wat för dat Wikki nit paß.
Wann en Leß met Kuntakte em Wikki es, kanns De doh drövver versöhke, wigger ze kumme,
wann De doch noch erin wells, udder jet ze saare udder ze froore häs.',
	'confirmaccount-email-body4' => 'Ding Aanfrooch noh enem Zohjang als Metmaacher op {{GRAMMAR:Akkusativ|{{SITENAME}}}}
met däm Name „$1“ es afjelehnt woode.

$2

Wann en Leß met Kuntakte em Wikki es, kanns De doh drövver versöhke,
wigger ze kumme, wannv De doch noch erin wells, udder jet ze saare
udder ze froore häs.',
	'confirmaccount-email-body5' => 'Iih dat Ding Aanfrooch noh enem Zohjang als Metmaacher
met däm Name „$1“
op {{GRAMMAR:Akkusativ|{{SITENAME}}}}
aanjenumme wääde kann, do moß De noch jet nohlääje.

$2

Wann en Leß met Kuntakte em Wiki es, kanns De doh drövver
versöhke, wigger ze kumme, wann De noch Froore häs.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'confirmaccount-real-q' => 'Nav',
	'confirmaccount-name' => 'Navê bikarhêner',
);

/** Cornish (Kernowek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'confirmaccount-email-q' => 'E-bost',
	'confirmaccount-name' => 'Hanow-usyer',
	'confirmaccount-email' => 'E-bost:',
	'confirmaccount-wsum' => 'Wolcum!',
);

/** Latin (Latina)
 * @author Omnipaedista
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
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
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
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
	'confirmaccount-review' => 'Nokucken',
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
	'confirmaccount-badaction' => 'Et muss eng valabel Aktioun (akzeptéieren, refuséieren, am Suspens halen) gemaach gi fir weiderfueren ze kënnen.',
	'confirmaccount-acc' => 'Benotzerkont-Ufro gouf confirméiert;
de Benotzerkont [[User:$1|$1]] gouf ugeluecht.',
	'confirmaccount-rej' => "D'Ufro fir ee Benotzerkont gouf refuséiert.",
	'confirmaccount-viewing' => '(gëtt elo gekuckt vum [[User:$1|$1]])',
	'confirmaccount-summary' => "D'Benotzersäit fir en neie Benotzer gëtt elo gemaach.",
	'confirmaccount-welc' => "'''Wëllkomm op ''{{SITENAME}}''!'''
Dir wëllt wahrscheinlech d'[[{{MediaWiki:Helppage}}|Hellëfsäite]] liesen.
Nachemol, wëllkom a vill Spaass!",
	'confirmaccount-wsum' => 'Wëllkomm!',
	'confirmaccount-email-subj' => '{{SITENAME}} Ufro fir ee Benotzerkont',
	'confirmaccount-email-body' => 'Är Ufro fir e Benotzerkont op {{SITENAME}} gouf ugeholl.

Numm vum Benotzerkont: $1

Passwuert: $2

Aus Sécherheetsgrënn musst Dir Äert Passwuert ännere wann Dir Iech déi éischt Kéier aloggt.
Fir Iech anzelogge gitt w.e.g. op {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Är Ufro fir e Benotzerkont op {{SITENAME}} gouf ugeholl.

Numm vum Benotzerkont: $1

Passwuert: $2

$3

Aus Sécherheetsgrënn musst Dir Äert Passwuert ännere wann Dir Iech déi éischt Kéier aloggt.
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
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Pahles
 */
$messages['li'] = array(
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
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Homo
 * @author Tomasdd
 */
$messages['lt'] = array(
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
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'confirmaccounts' => 'Потврдување на барања за сметки',
	'confirmedit-desc' => 'Им овозможува на бирократите да потврдуваат барања за сметка',
	'confirmaccount-maintext' => "'''Оваа страница служи за потврдување на барања за сметки на „{{SITENAME}}'''.

Секојa редica на барања за сметки се состои од три подредици.
Една за отворено барање, една за оние ставени на чекање од други администратори заради потреба од повеќе информации, и трета за неодамна одбиени барања.

Кога одговарате на барање, прегледајте го и оценете го внимателно, и по потреба, проверете ги наведените информациите.
Вашите постапки ќе бидат приватно заведени.
Од вас се очекува и да ги прегледувате сите дејствија што се случуваат овде покрај она што го правите вие самите.",
	'confirmaccount-list' => 'Подолу е наведен списокот на барања за сметка во исчекување на одобрение.
Штом ќе се одобри или одбие едно барање, истото ќе биде отстрането од списокот.',
	'confirmaccount-list2' => 'Подолу е наведен список на неодамна одбиени барања за сметка, кои може автоматски да бидат избришани по неколку дена.
Тие сепак можат да се одобрат и да се создадат сметки, иако пред ова да го направите, препорачуваме прво да го консултирате администраторот кој го одбил барањето.',
	'confirmaccount-list3' => 'Подолу е наведен список на истечени барања за сметка кои може да се избришат автоматски за неколку дена.
Тие сепак можат да се потврдат и да се создадат сметки.',
	'confirmaccount-text' => "Ова е барање за корисничка сметка на '''{{SITENAME}}''' во исчекување.

Внимателно прегледајте ги информациите подолу.
Ако решивте да го одобрите барањето, поставете го статусот на корисникот од паѓачкиот список.
Измените во биографијата нема да влијаат врз постојаните складирани акредитиви.
Можете да ја создадете сметката со поинакво корисничко име.
Ова користете го само кога некое име се коси со некое друго постоечко име.

Ако ја напуштите страницава без да го одобрите или одбиете барањето, тоа ќе си остане во исчекување.",
	'confirmaccount-none-o' => 'Моментално на списокот нема отворени барања за сметка во исчекување.',
	'confirmaccount-none-h' => 'Моментално на списокот нема задржани барања за сметка во исчекување.',
	'confirmaccount-none-r' => 'Моментално нема неодамна одбиени барања за сметка на списокот.',
	'confirmaccount-none-e' => 'Моментално нема истечени барања за сметки на списокот.',
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
	'confirmaccount-leg-person' => 'Лични податоци',
	'confirmaccount-leg-other' => 'Други информации',
	'confirmaccount-name' => 'Корисничко име',
	'confirmaccount-real' => 'Име:',
	'confirmaccount-email' => 'Е-пошта:',
	'confirmaccount-reqtype' => 'Позиција:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-pos-1' => 'уредник',
	'confirmaccount-bio' => 'Биографија:',
	'confirmaccount-attach' => 'Резиме/CV:',
	'confirmaccount-notes' => 'Дополнителни белешки:',
	'confirmaccount-urls' => 'Список на мрежни места:',
	'confirmaccount-none-p' => '(не е наведено)',
	'confirmaccount-confirm' => 'Подолу изберете дали да го прифатите, одбиете или задржите ова барање:',
	'confirmaccount-econf' => '(потврдено)',
	'confirmaccount-reject' => '(одбиено од [[User:$1|$1]] на $2)',
	'confirmaccount-rational' => 'Објаснение за барателот:',
	'confirmaccount-noreason' => '(нема)',
	'confirmaccount-autorej' => '(ова барање е автоматски отфрлено поради неактивност)',
	'confirmaccount-held' => '(обележано како „на чекање“ од [[User:$1|$1]] на $2)',
	'confirmaccount-create' => 'Прифати (создај сметка)',
	'confirmaccount-deny' => 'Одбиј (отстрани од списокот)',
	'confirmaccount-hold' => 'На чекање',
	'confirmaccount-spam' => 'Спам (не го испраќајте писмото)',
	'confirmaccount-reason' => 'Коментар (ќе биде вклучен во е-поштата):',
	'confirmaccount-ip' => 'IP-адреса:',
	'confirmaccount-legend' => 'Прифати/одбиј ја оваа корисничка сметка',
	'confirmaccount-submit' => 'Потврди',
	'confirmaccount-needreason' => 'Морате да наведете причина во полето за коментар подолу.',
	'confirmaccount-canthold' => 'Ова барање е веќе во задршка или е избришано.',
	'confirmaccount-badaction' => 'Неважечка постапка. За да продолжите мора да назначите прифати, одбиј или задршка.',
	'confirmaccount-acc' => 'Барањето за сметка е успешно потврдено;
создадена е нова сметка [[User:$1|$1]].',
	'confirmaccount-rej' => 'Барањето за сметка е успешно одбиено.',
	'confirmaccount-viewing' => '(во моментов ја гледа корисникот [[User:$1|$1]])',
	'confirmaccount-summary' => 'Создавање на корисничка страница на нов корисник.',
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
Може да несте го пополниле образецот правилно, одговорите да ви биле прекратки, или пак да не задоволувате некој друг критериум.
На страницата може да има контактни списоци кои можете да ги користите ако сакате да дознаете повеќе за правилата за сметки.',
	'confirmaccount-email-body4' => 'Жалиме, но вашето барање за сметка „$1“ на {{SITENAME}} беше одбиено.

$2

На страницата може да има контактни списоци кои можете да ги користите ако сакате да дознаете повеќе за правилата за сметки.',
	'confirmaccount-email-body5' => 'Пред да можеме да го прифатиме вашето барање за сметка „$1“ на {{SITENAME}} морате да ни дадете извесни дополнителни иформации.

$2

На страницата може да има контактни списоци кои можете да ги користите ако сакате да дознаете повеќе за правилата за сметки.',
);

/** Malayalam (മലയാളം)
 * @author Jacob.jose
 * @author Junaidpv
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'confirmaccounts' => 'അംഗത്വ അഭ്യർത്ഥനകൾ സ്ഥിരീകരിക്കുക',
	'confirmedit-desc' => 'ബ്യൂറോക്രാറ്റുകൾക്ക് ഉപയോക്തൃ അംഗത്വത്തിനായുള്ള അഭ്യർത്ഥനകൾ സ്ഥിരീകരിക്കുവാൻ അവസരം നൽകുന്നു.',
	'confirmaccount-list' => 'അംഗത്വത്തിനായി അഭ്യർത്ഥിച്ച് അതിന്റെ സ്ഥിരീകരണത്തിനായി കാത്തിരിക്കുന്നവരുടെ പട്ടികയാണ്‌ താഴെ.
ഒരു അഭ്യർത്ഥന സ്ഥിരീകരിക്കുകയോ നിരാകരിക്കുകയോ ചെയ്താൽ അത് ഈ പട്ടികയിൽ നിന്നു ഒഴിവാക്കുന്നതാണ്‌.',
	'confirmaccount-list2' => 'അംഗത്വത്തിനായുള്ള അഭ്യർത്ഥനകളിൽ അടുത്ത കാലത്ത് നിരാകരിക്കപ്പെട്ട അഭ്യർത്ഥനകളുടെ പട്ടികയാണു താഴെ. ഈ പട്ടികയ്ക്കു ചില ദിവസങ്ങളിൽ കൂടുതൽ പഴക്കമായാൽ അതു യാന്ത്രികമായി ഒഴിവാക്കപ്പെടും.
താങ്കൾക്കു താല്പര്യമെങ്കിൽ ഈ അഭ്യർത്ഥനകൾ സ്ഥിരീകരിക്കാവുന്നതാണ്‌.പക്ഷെ അങ്ങനെ ചെയ്യുന്നതിനു മുൻപ് അഭ്യർത്ഥന നിരാകരിച്ച അഡ്‌മിനിസ്റ്റ്രേറ്ററുമായി ബന്ധപ്പെടുന്നതു നന്നായിരിക്കും.',
	'confirmaccount-none-o' => 'ഈ പട്ടികയിൽ നിലവിൽ അംഗത്വത്തിനായുള്ള അഭ്യർത്ഥനകൾ ഒന്നുമില്ല',
	'confirmaccount-none-h' => 'ഈ പട്ടികയിൽ നിലവിൽ അംഗത്വത്തിനായുള്ള അഭ്യർത്ഥനകളിൽ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്ന അഭ്യർത്ഥനകൾ ഒന്നുമില്ല',
	'confirmaccount-none-r' => 'നിലവിൽ ഈ പട്ടികയിൽ നിരസിച്ച അംഗത്വത്തിനായുള്ള അഭ്യർത്ഥനകൾ ഒന്നുമില്ല.',
	'confirmaccount-none-e' => 'ഈ പട്ടികയിൽ നിലവിൽ അംഗത്വത്തിനായുള്ള കാലഹരണപ്പെട്ട അഭ്യർത്ഥനകൾ ഒന്നുമില്ല.',
	'confirmaccount-real-q' => 'പേര്‌',
	'confirmaccount-email-q' => 'ഇമെയിൽ',
	'confirmaccount-bio-q' => 'ആത്മകഥ',
	'confirmaccount-showopen' => 'തുറന്ന അഭ്യർത്ഥനകൾ',
	'confirmaccount-showrej' => 'നിരസിച്ച അപേക്ഷകൾ',
	'confirmaccount-showheld' => 'തടഞ്ഞുവെക്കപ്പെട്ട അഭ്യർത്ഥനകൾ',
	'confirmaccount-showexp' => 'കാലാവധി തീർന്ന അഭ്യർത്ഥനകൾ',
	'confirmaccount-review' => 'സം‌ശോധനം',
	'confirmaccount-type-0' => 'ലേഖകരാവാൻ സാദ്ധ്യതയുള്ളവർ',
	'confirmaccount-type-1' => 'എഡിറ്റർമാരാവാൻ സാദ്ധ്യതയുള്ളവർ',
	'confirmaccount-q-open' => 'തുറന്ന അഭ്യർത്ഥനകൾ',
	'confirmaccount-q-held' => 'തടഞ്ഞുവെക്കപ്പെട്ട അഭ്യർത്ഥനകൾ',
	'confirmaccount-q-rej' => 'അടുത്ത സമയത്ത് നിരസിച്ച അഭ്യർത്ഥനകൾ',
	'confirmaccount-q-stale' => 'കാലാവധി തീർന്ന അഭ്യർത്ഥനകൾ',
	'confirmaccount-leg-user' => 'ഉപയോക്തൃഅംഗത്വം',
	'confirmaccount-leg-areas' => 'താല്പര്യമുള്ള പ്രധാന മേഖലകൾ',
	'confirmaccount-leg-person' => 'വ്യക്തിഗത വിവരങ്ങൾ',
	'confirmaccount-leg-other' => 'മറ്റ് വിവരങ്ങൾ',
	'confirmaccount-name' => 'ഉപയോക്തൃനാമം',
	'confirmaccount-real' => 'പേര്‌:',
	'confirmaccount-email' => 'ഇമെയിൽ:',
	'confirmaccount-reqtype' => 'സ്ഥാനം:',
	'confirmaccount-pos-0' => 'ലേഖകൻ',
	'confirmaccount-pos-1' => 'എഡിറ്റർ',
	'confirmaccount-bio' => 'ആത്മകഥ:',
	'confirmaccount-attach' => 'റെസ്യൂം/സിവി:',
	'confirmaccount-notes' => 'കൂടുതൽ കുറിപ്പുകൾ:',
	'confirmaccount-urls' => 'വെബ്ബ്സൈറ്റുകളുടെ പട്ടിക:',
	'confirmaccount-none-p' => '(ഒന്നും നൽകിയിട്ടില്ല)',
	'confirmaccount-confirm' => 'താഴെയുള്ള ഓപ്ഷൻസ് ഉപയോഗിച്ച് ഈ അഭ്യർത്ഥന സ്വീകരിക്കുകയോ, നിരസിക്കുകയോ, തടഞ്ഞുവെക്കുകയോ ചെയ്യുക:',
	'confirmaccount-econf' => '(സ്ഥിരീകരിച്ചിരിക്കുന്നു)',
	'confirmaccount-reject' => '([[User:$1|$1]] എന്ന ഉപയോക്താവിനാൽ $2നു ഇതു നിരസിക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-noreason' => '(ഒന്നുമില്ല)',
	'confirmaccount-autorej' => '(പ്രവർത്തനരാഹിത്യം മൂലം ഈ അഭ്യർത്ഥന യാന്ത്രികമായി നിരസിക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-held' => '([[User:$1|$1]] എന്ന ഉപയോക്താവിനാൽ $2നു ഈ അപേക്ഷ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്നു)',
	'confirmaccount-create' => 'സ്വീകരിക്കുക (അംഗത്വം സൃഷ്ടിക്കുക)',
	'confirmaccount-deny' => 'നിരാകരിക്കുക (പട്ടികയിൽ നിന്നു ഒഴിവാക്കുക)',
	'confirmaccount-hold' => 'തടഞ്ഞുവെക്കുക',
	'confirmaccount-spam' => 'സ്പാം (ഇമെയിൽ അയക്കരുത്)',
	'confirmaccount-reason' => 'അഭിപ്രായൻ (ഇമെയിലിൽ ഉൾപ്പെടുത്തുന്നതാണ്‌):',
	'confirmaccount-ip' => 'ഐ.പി. വിലാസം:',
	'confirmaccount-submit' => 'സ്ഥിരീകരിക്കുക',
	'confirmaccount-needreason' => 'താഴെയുള്ള കമെന്റ് പെട്ടിയിൽ ഒരു കാരണം നിർബന്ധമായും രേഖപ്പെടുത്തണം.',
	'confirmaccount-canthold' => 'ഈ അഭ്യർത്ഥന ഒന്നുകിൽ തടഞ്ഞുവെക്കപ്പെട്ടിരിക്കുന്നു അല്ലെങ്കിൽ മായ്ക്കപ്പെട്ടിരിക്കുന്നു.',
	'confirmaccount-acc' => 'അംഗത്വം ഉണ്ടാക്കാനുള്ള അഭ്യർത്ഥന വിജയകരമായി സ്ഥിരീകരിച്ചിരിക്കുന്നു; പുതിയ ഉപയോക്തൃഅംഗത്വം സൃഷ്ടിച്ചിരിക്കുന്നു [[User:$1|$1]].',
	'confirmaccount-rej' => 'അംഗത്വം ഉണ്ടാക്കാനുള്ള അഭ്യർത്ഥന വിജയകരമായി നിരാകരിച്ചിരിക്കുന്നു.',
	'confirmaccount-viewing' => '(നിലവിൽ [[User:$1|$1]] എന്ന ഉപയോക്താവ് വീക്ഷിക്കുന്നു)',
	'confirmaccount-summary' => 'പുതിയ ഉപയോക്താവിന്റെ വ്യക്തിഗത വിവരങ്ങളും വെച്ച് ഉപയോക്തൃതാൾ നിർമ്മിച്ചുകൊണ്ടിരിക്കുന്നു.',
	'confirmaccount-welc' => "'''{{SITENAME}} സം‌രംഭത്തിലേക്ക് സ്വാഗതം'''.  താങ്കൾ ഇവിടെ നല്ല സംഭാവനകൾ ചെയ്യുമെന്നു പ്രതീക്ഷിക്കട്ടെ. താങ്കൾക്ക് [[{{MediaWiki:Helppage}}|സഹായ താളുകൾ]] വായിക്കുന്നതു ഗുണം ചെയ്തേക്കാം. ഒരിക്കൽ കൂടി സ്വാഗതം ചെയ്യുകയും ഇവിടം ആസ്വദിക്കുമെന്നു കരുതുകയും ചെയ്യുന്നു.",
	'confirmaccount-wsum' => 'സ്വാഗതം!',
	'confirmaccount-email-subj' => '{{SITENAME}} സം‌രംഭത്തിൽ അംഗത്വം സൃഷ്ടിക്കാനുള്ള അഭ്യർത്ഥന',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'confirmaccount-name' => 'Хэрэглэгчийн нэр',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
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
	'confirmaccount-email' => 'विपत्र:',
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
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'confirmaccounts' => 'Sahkan permohonan akaun',
	'confirmedit-desc' => 'Memberi birokrat kebolehan untuk mengesahkan permohonan akaun',
	'confirmaccount-maintext' => "'''Laman ini digunakan untuk mengesahkan permohonan akaun yang menunggu di ''{{SITENAME}}'''''.

Setiap baris gilir permohonan akaun terdiri daripada tiga baris gilir kecil.
Satu untuk permohonan terbuka, satu untuk permohonan yang digantung oleh pentadbir lain kerana menunggu maklumat lanjut, dan satu lagi untuk permohonan yang ditolak baru-baru ini.

Apabila membalas permohonan, sila kajinya dengan teliti, dan jika perlu, sahkan maklumat yang terkandung dalamnya.
Tindakan anda akan dilogkan secara rahsia.
Anda juga dijangka mengkaji sebarang aktiviti yang berlaku di sini selain yang anda lakukan.",
	'confirmaccount-list' => 'Berikut ialah senarai permohonan akaun yang menunggu kelulusan.
Sebaik sahaja permohonan diterima atau ditolak, ia akan dipadamkan dari senarai ini.',
	'confirmaccount-list2' => 'Berikut ialah senarai permohonan akaun yang ditolak baru-baru ini dan mungkin akan dihapuskan secara automatik selepas beberapa hari.
Ia masih boleh diluluskan menjadi akaun, tetapi anda harus berunding dengan pentadbir yang membuat penolakan terlebih dahulu sebelum berbuat demikian.',
	'confirmaccount-list3' => 'Berikut ialah senarai permohonan akaun luput yang mungkin akan dihapuskan secara automatik selepas beberapa hari.
Ia masih boleh diluluskan menjadi akaun.',
	'confirmaccount-text' => "Ini ialah permohonan akaun pengguna yang menunggu di '''{{SITENAME}}'''.

Sila kaji maklumat berikut secara teliti.
Jika anda ingin meluluskan permohoan ini, gunakan juntai bawah posisi untuk menetapkan status akaun pengguna.
Suntingan yang dilakukan pada biografi aplikasi tidak akan mempengaruhi sebarang storan kelayakan yang kekal.
Ingat, anda boleh memilih untuk membuka akaun itu dengan nama pengguna yang lain.
Gunakan ini untuk mengelakkan percanggahan dengan nama lain sahaja.

Jika anda membiarkan laman ini begitu sahaja tanpa mengesahkan atau menolak permohonan ini, ia akan kekal menunggu.",
	'confirmaccount-none-o' => 'Buat masa ini, tiada permohonan akaun menunggu yang terbuka dalam senarai ini.',
	'confirmaccount-none-h' => 'Buat masa ini, tiada permohonan akaun menunggu yang tergantung dalam senarai ini.',
	'confirmaccount-none-r' => 'Buat masa ini, tiada permohonan akaun yang ditolak baru-baru ini dalam senarai ini.',
	'confirmaccount-none-e' => 'Buat masa ini, tiada permohonan akaun yang luput dalam senarai ini.',
	'confirmaccount-real-q' => 'Nama',
	'confirmaccount-email-q' => 'E-mel',
	'confirmaccount-bio-q' => 'Biografi',
	'confirmaccount-showopen' => 'permohonan terbuka',
	'confirmaccount-showrej' => 'permohonan ditolak',
	'confirmaccount-showheld' => 'permohonan tergantung',
	'confirmaccount-showexp' => 'permohonan luput',
	'confirmaccount-review' => 'Kaji semula',
	'confirmaccount-types' => 'Pilih baris gilir pengesahan akaun dari bawah:',
	'confirmaccount-all' => '(tunjukkan semua baris gilir)',
	'confirmaccount-type' => 'Baris gilir:',
	'confirmaccount-type-0' => 'bakal pengarang',
	'confirmaccount-type-1' => 'bakal penyunting',
	'confirmaccount-q-open' => 'permohonan terbuka',
	'confirmaccount-q-held' => 'permohonan tergantung',
	'confirmaccount-q-rej' => 'permohonan ditolak yang terbaru',
	'confirmaccount-q-stale' => 'permohonan luput',
	'confirmaccount-badid' => 'Tiada permohonan menunggu yang sepadan dengan ID yang diberikan.
Mungkin ia sudah diuruskan.',
	'confirmaccount-leg-user' => 'Akaun pengguna',
	'confirmaccount-leg-areas' => 'Bidang-bidang yang paling diminati',
	'confirmaccount-leg-person' => 'Maklumat peribadi',
	'confirmaccount-leg-other' => 'Maklumat lain',
	'confirmaccount-name' => 'Nama pengguna',
	'confirmaccount-real' => 'Nama:',
	'confirmaccount-email' => 'E-mel:',
	'confirmaccount-reqtype' => 'Kedudukan:',
	'confirmaccount-pos-0' => 'pengarang',
	'confirmaccount-pos-1' => 'penyunting',
	'confirmaccount-bio' => 'Biografi:',
	'confirmaccount-attach' => 'Resume/CV:',
	'confirmaccount-notes' => 'Catatan tambahan:',
	'confirmaccount-urls' => 'Senarai tapak web:',
	'confirmaccount-none-p' => '(tidak disediakan)',
	'confirmaccount-confirm' => 'Gunakan pilihan di bawah untuk menerima, menolak atau menggantung permohonan ini:',
	'confirmaccount-econf' => '(disahkan)',
	'confirmaccount-reject' => '(ditolak oleh [[User:$1|$1]] pada $2)',
	'confirmaccount-rational' => 'Rasional yang diberikan kepada pemohon:',
	'confirmaccount-noreason' => '(tiada)',
	'confirmaccount-autorej' => '(permohonan ini telah dibuang secara automatik disebabkan ketidakaktifan)',
	'confirmaccount-held' => '(ditandai sebagai "tergantung" oleh [[User:$1|$1]] pada $2)',
	'confirmaccount-create' => 'Terima (buka akaun)',
	'confirmaccount-deny' => 'Tolak (buang dari senarai)',
	'confirmaccount-hold' => 'Gantung',
	'confirmaccount-spam' => 'Spam (jangan hantar e-mel)',
	'confirmaccount-reason' => 'Komen (akan disertakan dalam e-mel):',
	'confirmaccount-ip' => 'Alamat IP:',
	'confirmaccount-legend' => 'Sahkan/tolak akaun ini',
	'confirmaccount-submit' => 'Sahkan',
	'confirmaccount-needreason' => 'Anda mesti menyatakan sebab dalam ruangan komen di bawah.',
	'confirmaccount-canthold' => 'Permohonan ini digantung atau dihapuskan.',
	'confirmaccount-badaction' => 'Tindakan yang sah (terima, tolak, gantung) mestilah dinyatakan untuk teruskan.',
	'confirmaccount-acc' => 'Permohonan akaun berjaya disahkan;
	akaun pengguna baru [[User:$1|$1]] dicipta.',
	'confirmaccount-rej' => 'Permohonan akaun berjaya ditolak.',
	'confirmaccount-viewing' => '(sedang diliha oleh [[User:$1|$1]])',
	'confirmaccount-summary' => 'Laman pengguna diwujudkan untuk pengguna baru.',
	'confirmaccount-welc' => "'''Selamat datang ''{{SITENAME}}''!'''
Kami berharap agar anda memberikan sumbangan yang banyak dan bermanfaat di sini.
Apa kata anda membaca [[{{MediaWiki:Helppage}}|laman-laman bantuan]] terlebih dahulu.
Apapun, selamat datang dan salam ceria!",
	'confirmaccount-wsum' => 'Selamat datang!',
	'confirmaccount-email-subj' => 'Permohonan akaun {{SITENAME}}',
	'confirmaccount-email-body' => 'Permohonan akaun anda telah diluluskan di {{SITENAME}}.

Nama akaun: $1

Kata laluan: $2

Atas sebab keselamatan, anda perlu menukar kata laluan pada log masuk pertama.
Untuk log masuk, sila ke {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body2' => 'Permohonan akaun anda telah diluluskan di {{SITENAME}}.

Nama akaun: $1

Kata laluan: $2

$3

Atas sebab keselamatan, anda perlu menukar kata laluan pada log masuk pertama.
Untuk log masuk, sila ke {{fullurl:Special:UserLogin}}.',
	'confirmaccount-email-body3' => 'Maaf, permohonan akaun anda "$1" telah ditolak di {{SITENAME}}.

Ini mungkin timbul atas beberapa sebab.
Mungkin anda tidak mengisi borang dengan betul, tidak menulis jawapan anda secukupnya, ataupun tidak memenuhi kriteria dasar tertentu.
Terdapat senarai hubungan dalam tapak yang boleh anda gunakan jika anda ingin mengetahui lebih banyak mengenai dasar akaun pengguna.',
	'confirmaccount-email-body4' => 'Maaf, permohonan akaun anda "$1" telah ditolak di {{SITENAME}}.

$2

Terdapat senarai hubungan dalam tapak yang boleh anda gunakan jika anda ingin mengetahui lebih banyak mengenai dasar akaun pengguna.',
	'confirmaccount-email-body5' => 'Sebelum permohonan akaun anda "$1" boleh diterima di {{SITENAME}}, anda mesti memberikan maklumat tambahan terlebih dahulu.

$2

Terdapat senarai hubungan dalam tapak yang boleh anda gunakan jika anda ingin mengetahui lebih banyak mengenai dasar akaun pengguna.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-name' => 'Isem tal-utent',
	'confirmaccount-email' => 'E-mail:',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'confirmaccount-real-q' => 'Лемезэ:',
	'confirmaccount-email-q' => 'Е-сёрма',
	'confirmaccount-type' => 'Чиполань пулось:',
	'confirmaccount-name' => 'Теицянь лем',
	'confirmaccount-real' => 'Лемезэ:',
	'confirmaccount-email' => 'Е-сёрма:',
	'confirmaccount-pos-0' => 'теиця',
	'confirmaccount-pos-1' => 'витницязо-петницязо',
	'confirmaccount-none-p' => '(апак максо)',
	'confirmaccount-noreason' => '(арась мезе невтемс)',
	'confirmaccount-hold' => 'Кирдемс',
	'confirmaccount-submit' => 'Кемекстамс',
	'confirmaccount-wsum' => 'Совак, инеське!',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
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
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
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
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'confirmaccount-real-q' => 'Naam',
	'confirmaccount-email-q' => 'E-Mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-leg-user' => 'Brukerkonto',
	'confirmaccount-name' => 'Brukernaam',
	'confirmaccount-real' => 'Naam:',
	'confirmaccount-ip' => 'IP-Adress:',
	'confirmaccount-wsum' => 'Willkamen!',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'confirmaccount-name' => 'प्रयोगकर्ता नाम',
);

/** Dutch (Nederlands)
 * @author Annabel
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
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
	'confirmaccount-leg-person' => 'Persoonlijke gegevens',
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
	'confirmaccount-badaction' => 'Er moet een geldige handeling worden opgegeven om door te kunnen gaan (accepteren, afwijzen, aanhouden).',
	'confirmaccount-acc' => 'Gebruikersaanvraag goedgekeurd. De gebruiker [[User:$1|$1]] is aangemaakt.',
	'confirmaccount-rej' => 'Gebruikersaanvraag afgewezen.',
	'confirmaccount-viewing' => '(op dit ogenblik bekeken door [[User:$1|$1]])',
	'confirmaccount-summary' => 'Er wordt een gebruikerspagina gemaakt voor de nieuwe gebruiker.',
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
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
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
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'confirmaccount-real-q' => 'Leina',
	'confirmaccount-real' => 'Leina:',
	'confirmaccount-pos-0' => 'mongwadi',
	'confirmaccount-pos-1' => 'morulaganyi',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
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
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 */
$messages['or'] = array(
	'confirmaccount-real-q' => 'ନାମ',
	'confirmaccount-real' => 'ନାମ',
	'confirmaccount-email' => 'ଇ-ମେଲ',
	'confirmaccount-wsum' => 'ସ୍ଵାଗତ!',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'confirmaccount-email-q' => 'Эл. посты адрис',
	'confirmaccount-showexp' => 'eksdatiĝintaj petoj',
	'confirmaccount-name' => 'Архайæджы ном',
	'confirmaccount-email' => 'Эл. посты адрис:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-noreason' => '(нæй)',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Aalam
 */
$messages['pa'] = array(
	'confirmaccounts' => 'ਅਕਾਊਂਟ ਮੰਗ ਪੁਸ਼ਟੀ',
	'confirmaccount-real-q' => 'ਨਾਂ',
	'confirmaccount-email-q' => 'ਈਮੇਲ',
	'confirmaccount-showopen' => 'ਮੰਗਾਂ ਖੋਲ੍ਹੋ',
	'confirmaccount-showrej' => 'ਰੱਦ ਕੀਤੀਆਂ ਮੰਗਾਂ',
	'confirmaccount-review' => 'ਝਲਕ',
	'confirmaccount-type' => 'ਕਤਾਰ:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'confirmaccount-real-q' => 'Naame',
	'confirmaccount-email-q' => 'E-Poschd',
	'confirmaccount-name' => 'Yuuser-Naame',
	'confirmaccount-real' => 'Naame:',
	'confirmaccount-email' => 'E-Poschd:',
	'confirmaccount-pos-0' => 'Schreiwer',
	'confirmaccount-pos-1' => 'Schreiwer',
	'confirmaccount-noreason' => '(nix)',
	'confirmaccount-wsum' => 'Wilkum!',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'confirmaccount-name' => 'Bruckernome',
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
	'confirmaccount-legend' => 'Zatwierdź lub odrzuć to konto',
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
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
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
	'confirmaccount-confirm' => "Ch'a deuvra j'opsion ambelessì-sota për aceté, arfudé ò lassé an coa l'arcesta:",
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
	'confirmaccount-badaction' => "N'assion bon-a (aceté, arfudé, ten-e an coa) a dev esse spessificà për andé anans.",
	'confirmaccount-acc' => "Conferma dla domanda andaita a bonfin; a l'é dorbusse ël cont utent [[User:$1|$1]].",
	'confirmaccount-rej' => 'Arfud dla domanda andait a bonfin.',
	'confirmaccount-viewing' => "(al moment a l'é vist da [[User:$1|$1]])",
	'confirmaccount-summary' => "I soma antramentr ch'i foma na neuva pàgina utent për l'utent neuv.",
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
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'confirmaccount-real-q' => 'نوم',
	'confirmaccount-email-q' => 'برېښليک',
	'confirmaccount-bio-q' => 'ژوندليک',
	'confirmaccount-showrej' => 'رټل شوې غوښتنې',
	'confirmaccount-review' => 'مخکتنه',
	'confirmaccount-q-open' => 'پرانيستې غوښتنې',
	'confirmaccount-leg-user' => 'ګڼون',
	'confirmaccount-leg-person' => 'ځاني مالومات',
	'confirmaccount-leg-other' => 'نور مالومات',
	'confirmaccount-name' => 'کارن-نوم',
	'confirmaccount-real' => 'نوم:',
	'confirmaccount-email' => 'برېښليک:',
	'confirmaccount-pos-0' => 'ليکوال',
	'confirmaccount-pos-1' => 'سمونګر',
	'confirmaccount-bio' => 'ژوندليک:',
	'confirmaccount-urls' => 'د وېبځايونو لړليک:',
	'confirmaccount-noreason' => '(هېڅ)',
	'confirmaccount-ip' => 'IP پته:',
	'confirmaccount-wsum' => 'ښه راغلاست!',
	'confirmaccount-email-body' => 'په {{SITENAME}} باندې د يوه ګڼون لپاره غوښتنه مو ومنل شوه .

د ګڼون نوم: $1

پټنوم: $2

د تحفظ د سببونو لپاره تاسو ته پکار ده چې د وروسته له دې چې د لومړي ځل لپاره غونډال ته ننوتلی نو مهرباني وکړی خپل پټنوم بدل کړی. د دې لپاره چې غونډال ته ننوځی، مهرباني وکړی {{fullurl:Special:UserLogin}} ولاړ شی.',
	'confirmaccount-email-body2' => 'په {{SITENAME}} باندې د يوه ګڼون لپاره غوښتنه مو ومنل شوه .

د ګڼون نوم: $1

پټنوم: $2

$3

د تحفظ د سببونو لپاره تاسو ته پکار ده چې د وروسته له دې چې د لومړي ځل لپاره غونډال ته ننوتلی نو مهرباني وکړی خپل پټنوم بدل کړی. د دې لپاره چې غونډال ته ننوځی، مهرباني وکړی {{fullurl:Special:UserLogin}} ولاړ شی.',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
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
	'confirmaccount-urls' => 'Lista de sites na internet:',
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

Há várias formas de isto acontecer. Poderá não ter preenchido o formulário correctamente, não ter fornecido respostas de tamanho adequado, ou de outra forma não ter cumprido algumas normas e critérios. Podem existir listas de contactos no site que poderá usar se deseja saber mais sobre as normas para contas de utilizador.',
	'confirmaccount-email-body4' => 'Desculpe, o seu pedido para a conta "$1" foi rejeitado na {{SITENAME}}.

$2

Podem haver listas de contactos no site que poderá usar se deseja saber mais sobre as normas para contas de utilizador.',
	'confirmaccount-email-body5' => 'Antes que o seu pedido para a conta "$1" seja aceite na {{SITENAME}}, deverá fornecer alguma informação adicional.

$2

Podem haver listas de contactos no site que poderá usar se deseja saber mais sobre as normas para contas de utilizador.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
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
	'confirmaccount-leg-person' => 'Informações pessoais',
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
	'confirmaccount-legend' => 'Confirmar ou rejeitar esta conta',
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
);

/** Romansh (Rumantsch) */
$messages['rm'] = array(
	'confirmaccount-real-q' => 'Num',
	'confirmaccount-name' => "Num d'utilisader",
	'confirmaccount-real' => 'Num:',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'confirmaccounts' => 'Confirmă cererile de conturi',
	'confirmaccount-real-q' => 'Nume',
	'confirmaccount-email-q' => 'E-mail',
	'confirmaccount-bio-q' => 'Biografie',
	'confirmaccount-showopen' => 'cereri deschise',
	'confirmaccount-showrej' => 'cereri respinse',
	'confirmaccount-showheld' => 'cereri de ajutor',
	'confirmaccount-showexp' => 'cereri expirate',
	'confirmaccount-q-open' => 'cereri deschise',
	'confirmaccount-q-rej' => 'cereri respinse recent',
	'confirmaccount-q-stale' => 'cereri expirate',
	'confirmaccount-leg-user' => 'Cont de utilizator',
	'confirmaccount-leg-areas' => 'Arii principale de interes',
	'confirmaccount-leg-person' => 'Informații personale',
	'confirmaccount-leg-other' => 'Alte informații',
	'confirmaccount-name' => 'Nume de utilizator',
	'confirmaccount-real' => 'Nume:',
	'confirmaccount-email' => 'E-mail:',
	'confirmaccount-reqtype' => 'Poziție:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Biografie:',
	'confirmaccount-attach' => 'CV:',
	'confirmaccount-notes' => 'Note adiționale:',
	'confirmaccount-urls' => 'Listă de situri web:',
	'confirmaccount-econf' => '(confirmat)',
	'confirmaccount-rational' => 'Motiv oferit aplicantului:',
	'confirmaccount-noreason' => '(niciunul)',
	'confirmaccount-create' => 'Acceptare (crează cont)',
	'confirmaccount-deny' => 'Respinge (delist)',
	'confirmaccount-hold' => 'Reține',
	'confirmaccount-spam' => 'Spam (nu trimite e-mail)',
	'confirmaccount-reason' => 'Comentariu (va fi inclus în e-mail):',
	'confirmaccount-ip' => 'Adresă IP:',
	'confirmaccount-submit' => 'Confirmă',
	'confirmaccount-needreason' => 'Trebuie să furnizați un motiv în caseta de comentarii de mai jos.',
	'confirmaccount-welc' => "'''Bun venit pe ''{{SITENAME}}''!'''
Sperăm că veţi contribui mult şi bine.
Veţi dori probabil să citiţi [[{{MediaWiki:Helppage}}|paginile de ajutor]].
Din nou, bun venit şi distrează-te!",
	'confirmaccount-wsum' => 'Bun venit!',
	'confirmaccount-email-body2' => 'Cererea dvs. pentru un cont a fost aprobată pe {{SITENAME}}.

Numele contului: $1

Parola: $2

$3

Din motive de securitate va trebui să vă schimbaţi parola la prima autentificare.
Pentru a vă autentifica, vă rugăm mergeţi aici: {{fullurl:Special:UserLogin}}.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'confirmaccount-type' => 'Code:',
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
	'confirmaccount-confirm' => "Ause l'opzione de sotte pe accettà, scettà o tenè sta richieste:",
	'confirmaccount-econf' => '(confermete)',
	'confirmaccount-reject' => '(scettete da [[User:$1|$1]] sus a $2)',
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
	'confirmaccounts' => 'Подтверждение запросов учётных записей',
	'confirmedit-desc' => 'Даёт бюрократам возможность подтверждать запросы на учётные записи',
	'confirmaccount-maintext' => "'''Эта страница используется для подтверждения заявок на учётные записи проекта «{{SITENAME}}»'''.

Каждая очередь заявок состоит из трёх частей: открытые заявки; заявки отложенные администраторами до получения дополнительной информации; недавно отклонённые заявки.

Открыв заявку, внимательно просмотрите её, при необходимости, проверьте содержащуюся в ней информацию. Ваши действия будет записаны в журнал. Ожидается, что ваша работа по просмотру и подтверждению заявок будет независима от того, чем вы занимаетесь.",
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
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'confirmaccount-real-q' => 'Мено',
	'confirmaccount-email-q' => 'Електронічна пошта',
	'confirmaccount-bio-q' => 'Біоґрафія',
	'confirmaccount-name' => 'Мено хоснователя',
	'confirmaccount-real' => 'Мено:',
	'confirmaccount-email' => 'Електронічна пошта:',
	'confirmaccount-reqtype' => 'Позіція:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-pos-1' => 'едітор',
	'confirmaccount-bio' => 'Біоґрафія:',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'confirmaccount-real-q' => 'Nomu',
	'confirmaccount-email-q' => 'Nnirizzu email',
	'confirmaccount-real' => 'Nomu:',
	'confirmaccount-email' => 'Nnirizzu email:',
	'confirmaccount-noreason' => '(nuddu)',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
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
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'confirmaccount-name' => 'Uporabniško ime',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'confirmaccount-none-o' => 'Тренутно нема нерешених захтева у овом списку.',
	'confirmaccount-none-h' => 'Тренутно нема стопираних захтева у овом списку.',
	'confirmaccount-none-r' => 'Тренутно нема скоро одбачених захтева у овом списку.',
	'confirmaccount-none-e' => 'Тренутно нема застарелих захтева у овом списку.',
	'confirmaccount-real-q' => 'Име',
	'confirmaccount-email-q' => 'Е-пошта',
	'confirmaccount-bio-q' => 'Животопис',
	'confirmaccount-showopen' => 'нерешени захтеви',
	'confirmaccount-showrej' => 'одбачени захтеви',
	'confirmaccount-showheld' => 'стопирани захтеви',
	'confirmaccount-showexp' => 'застарели захтеви',
	'confirmaccount-review' => 'Преглед',
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
	'confirmaccount-leg-person' => 'Лични подаци',
	'confirmaccount-leg-other' => 'Други подаци',
	'confirmaccount-name' => 'Корисничко име',
	'confirmaccount-real' => 'Име:',
	'confirmaccount-email' => 'Е-пошта:',
	'confirmaccount-reqtype' => 'Положај:',
	'confirmaccount-pos-0' => 'аутор',
	'confirmaccount-pos-1' => 'уређивач',
	'confirmaccount-bio' => 'Животопис:',
	'confirmaccount-attach' => 'Резиме/CV:',
	'confirmaccount-notes' => 'Додатне напомене:',
	'confirmaccount-urls' => 'Списак вебсајтова:',
	'confirmaccount-none-p' => '(није приложено)',
	'confirmaccount-confirm' => 'Испод изаберите да ли желите да прихватите, одбијете или задржите овај захтев:',
	'confirmaccount-econf' => '(потврђено)',
	'confirmaccount-reject' => '(одбацио [[User:$1|$1]] на $2)',
	'confirmaccount-rational' => 'Образложење дато кандидату:',
	'confirmaccount-noreason' => '(нема)',
	'confirmaccount-autorej' => '(овај захтев је био аутоматски одбачен због неактивности)',
	'confirmaccount-held' => '(означено као "стопирано" од [[User:$1|$1]] на $2)',
	'confirmaccount-create' => 'Прихвати (направи налог)',
	'confirmaccount-deny' => 'Одбаци (скини са списка)',
	'confirmaccount-hold' => 'Заустави',
	'confirmaccount-reason' => 'Коментар (биће укључен у поруци):',
	'confirmaccount-ip' => 'ИП адреса:',
	'confirmaccount-submit' => 'Потврди',
	'confirmaccount-needreason' => 'Морате навести разлог у кутијици за коментаре испод.',
	'confirmaccount-canthold' => 'Овај захтев је већ стопиран или обрисан.',
	'confirmaccount-acc' => 'Захтев за налогом успешно прихваћен:
направљен је нови кориснички налог [[User:$1|$1]].',
	'confirmaccount-rej' => 'Захтев за налогом успешно одбачен.',
	'confirmaccount-viewing' => '(тренутно прегледа [[User:$1|$1]])',
	'confirmaccount-summary' => 'Стварање корисничке странице за новог корисника.',
	'confirmaccount-wsum' => 'Добро дошли!',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-el'] = array(
	'confirmaccount-none-o' => 'Trenutno nema nerešenih zahteva u ovom spisku.',
	'confirmaccount-none-h' => 'Trenutno nema stopiranih zahteva u ovom spisku.',
	'confirmaccount-none-r' => 'Trenutno nema skoro odbačenih zahteva u ovom spisku.',
	'confirmaccount-none-e' => 'Trenutno nema zastarelih zahteva u ovom spisku.',
	'confirmaccount-real-q' => 'Ime',
	'confirmaccount-email-q' => 'E-pošta',
	'confirmaccount-bio-q' => 'Životopis',
	'confirmaccount-showopen' => 'nerešeni zahtevi',
	'confirmaccount-showrej' => 'odbačeni zahtevi',
	'confirmaccount-showheld' => 'stopirani zahtevi',
	'confirmaccount-showexp' => 'zastareli zahtevi',
	'confirmaccount-review' => 'Pregled',
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
	'confirmaccount-leg-person' => 'Lični podaci',
	'confirmaccount-leg-other' => 'Druge informacije',
	'confirmaccount-name' => 'Korisničko ime',
	'confirmaccount-real' => 'Ime:',
	'confirmaccount-email' => 'E-pošta:',
	'confirmaccount-reqtype' => 'Pozicija:',
	'confirmaccount-pos-0' => 'autor',
	'confirmaccount-pos-1' => 'editor',
	'confirmaccount-bio' => 'Životopis:',
	'confirmaccount-attach' => 'Rezime/CV:',
	'confirmaccount-notes' => 'Dodatne napomene:',
	'confirmaccount-urls' => 'Spisak vebsajtova:',
	'confirmaccount-none-p' => '(nije priloženo)',
	'confirmaccount-confirm' => 'Ispod izaberite da li želite da prihvatite, odbijete ili zadržite ovaj zahtev:',
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
	'confirmaccount-summary' => 'Stvaranje korisničke stranice za novog korisnika.',
	'confirmaccount-wsum' => 'Dobro došli!',
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
	'confirmaccounts' => 'Benutserkonto-Froagen bestäätigje',
	'confirmedit-desc' => 'Rakt Bürokrate ju Muugelkhaid, Benutserkontenandraage tou bestäätigjen',
	'confirmaccount-maintext' => "'''Disse Siede tjoont deertou, täiwende Benutserkontenandraage foar ''{{SITENAME}}''''' tou beoarbaidjen.

Älke Benutserkonten-Andraachsqueue bestoant uut tjo Unnerqueues. Een foar eepene Anfroage, een foar Andraage in dän „outäiwe“-Stoatus un een foar knu ouliende Anfroagen.

Wan du ap n Andraach oantwoudest, wröich dan do Informatione suurgfooldich un bestäätigje do änthooldene Informatione.
Dien Aktione wäide nit-eepentelk protokollierd. Der wäd uk fon die ferwachted, do Aktione fon uurswäkke tou wröigjen.",
	'confirmaccount-list' => 'Hier unner finst du ne Lieste fon noch tou beoarbaidjene Benutserkonto-Froagen.
Bestäätigede Konten wäide anlaid un uut ju Lieste wächhoald. Ouliende Konten wäide eenfach uut ju Lieste läsked.',
	'confirmaccount-list2' => 'Unner is ne Lieste fon knu touräächwiesde Andraage, do automatisk läsked wäide, so gau do eenige Deege oold sunt. Do konnen noch geneemigd wäide, man in älke Fal skuust du eerste dän oulienenden Administrator kontaktierje.',
	'confirmaccount-list3' => 'Unner is ne Lieste knu touräächwiesde Andraage, do automatisk läsked wäide, so gau do eenige Deege oold sunt. Do konnen noch geneemigd wäide.',
	'confirmaccount-text' => "Dit is n Andraach ap n Benutserkonto bie '''{{SITENAME}}'''. Wröigje aal hier unner stoundene Informatione gruundelk un bestäätigje do Informatione wan muugelk. Beoachtje, dät du dän Tougong bie Bedarf unner
n uur Benutsernoome anlääse koast. Du skuust dät bloot nutsje, uum Kollisione mäd uur Noomen tou fermieden.

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

Uut Sicherhaidsgruunden skuust du dien Paaswoud uunbedingd bie dät eerste
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
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
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
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'confirmaccount-real-q' => 'Mjano',
	'confirmaccount-real' => 'Mjano:',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 */
$messages['ta'] = array(
	'confirmaccount-real-q' => 'பெயர்',
	'confirmaccount-email-q' => 'மின்னஞ்சல்',
	'confirmaccount-review' => 'மதிப்பிடு',
	'confirmaccount-type' => 'வரிசை:',
	'confirmaccount-leg-user' => 'பயனர் கணக்கு',
	'confirmaccount-name' => 'பயனர் பெயர்',
	'confirmaccount-real' => 'பெயர்:',
	'confirmaccount-email' => 'மின்னஞ்சல்:',
	'confirmaccount-reqtype' => 'இடம்:',
	'confirmaccount-pos-0' => 'ஆசிரியர்',
	'confirmaccount-pos-1' => 'பதிப்பாசிரியர்',
	'confirmaccount-noreason' => '(எதுவுமில்லை)',
	'confirmaccount-ip' => 'ஐ.பி. முகவரி:',
	'confirmaccount-submit' => 'உறுதிசெய்',
	'confirmaccount-wsum' => 'வருக ! வணக்கம் !',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'confirmaccounts' => 'ఖాతా అభ్యర్థనలను నిర్ధారించండి',
	'confirmedit-desc' => 'అధికారులకు ఖాతా అభ్యర్థనలను నిర్ధారించే వీలుకల్పిస్తుంది',
	'confirmaccount-maintext' => "'''ఈ పేజీని ''{{SITENAME}}'' లో పెండింగులో ఉన్న ఖాతా అభ్యర్ధనలను ధృవీకరించేందుకు వాడతాము'''.

ప్రతీ ఖాతా అభ్యర్ధన క్యూలోను మూడు ఉప క్యూలుంటాయి.
కొత్త అభ్యర్ధనలు ఒకదానిలో,అదనపు సమాచారం కోసం ఇతర నిర్వాహకులు పెండింగులో పెట్టిన అభ్యర్ధనలు రెండో దానిలోను, ఇటీవల తిరస్కరించిన అభ్యర్ధనలు మూడోదానిలోనూ ఉంటాయి..

అభ్యర్ధనకు స్పందించేటపుడు,దాన్ని జాగ్రత్తగా పరిశీలించండి. అవసరమైతే, దానిలో ఇచ్చిన సమాచారాన్ని నిర్ధారించుకోండి.
మీ చర్యలు గోప్యంగా లాగ్ చెయ్యబడతాయి.
మీరు చేసే పనితో పాటు, ఇక్కడ జరిగే అన్ని చర్యలనూ మీరు సమీక్షించాల్సి ఉంది.",
	'confirmaccount-list' => 'ఆమోదం కోసం వేచి ఉన్న ఖాతా అభ్యర్ధనల జాబితా కింద ఇచ్చాం.
ఈ అభ్యర్ధనలు ఆమోదం పొందినా, లేక తిరస్కరించబడినా వెంటనే అవి ఈ జాబితాలోంచి తొలగించబడతాయి.',
	'confirmaccount-list2' => 'ఇటీవల తిరస్కరించబడిన ఖాతా అభ్యర్ధన లివి. కొన్నాళ్ళకు ఇవి ఆటోమాటిగ్గా తొలగించబడతాయి.
మీరు వీటిని ఆమోదించవచ్చు, కానీ దానికంటే ముందు తిరస్కరించిన నిర్వాహకుని సంప్రదిస్తే మంచిది.',
	'confirmaccount-list3' => 'కాలం చెల్లిన ఖాతా అభ్యర్ధనల జాబితా ఇది. కొన్నాళ్ళకు ఇవి ఆటోమాటిగ్గా తొలగించబడతాయి.
వీటిని మీరు ఆమోదించవచ్చు.',
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
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'confirmaccount-real-q' => 'Naran',
	'confirmaccount-email-q' => 'Korreiu eletróniku',
	'confirmaccount-name' => "Naran uza-na'in",
	'confirmaccount-real' => 'Naran:',
	'confirmaccount-email' => 'Korreiu eletróniku:',
	'confirmaccount-pos-0' => 'autór',
	'confirmaccount-ip' => 'Diresaun IP:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
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
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
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
);

/** Thai (ไทย)
 * @author Ans
 * @author Guitar-pawat
 * @author Harley Hartwell
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
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
	'confirmaccount-pos-0' => 'ผู้เขียน',
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
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'confirmaccount-real-q' => 'At',
	'confirmaccount-name' => 'Ulanyjy ady',
	'confirmaccount-real' => 'At:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
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
	'confirmaccount-legend' => 'Tiyakin/tanggihan ang akawnt na ito',
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
);

/** Turkish (Türkçe)
 * @author Homonihilis
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
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
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'confirmaccount-wsum' => 'Рәхим итегез!',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'confirmaccount-email-q' => 'ئېلخەت',
	'confirmaccount-name' => 'ئىشلەتكۇچى ئىسمى',
	'confirmaccount-email' => 'ئېلخەت:',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'confirmaccount-email-q' => 'Élxet',
	'confirmaccount-name' => 'Ishletkuchi ismi',
	'confirmaccount-email' => 'Élxet:',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Alex Khimich
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'confirmaccounts' => 'Підтвердити запит облікового запису',
	'confirmaccount-real-q' => "Ім'я",
	'confirmaccount-email-q' => 'Електронна пошта',
	'confirmaccount-bio-q' => 'Біографія',
	'confirmaccount-showopen' => 'відкриті запити',
	'confirmaccount-review' => 'Огляд',
	'confirmaccount-type' => 'Черга:',
	'confirmaccount-q-open' => 'відкриті запити',
	'confirmaccount-leg-user' => 'Обліковий запис',
	'confirmaccount-leg-areas' => 'Основні області інтересів',
	'confirmaccount-leg-person' => 'Особиста інформація',
	'confirmaccount-leg-other' => 'Інша інформація',
	'confirmaccount-name' => "Ім'я користувача",
	'confirmaccount-real' => "Ім'я:",
	'confirmaccount-email' => 'Електронна адреса:',
	'confirmaccount-reqtype' => 'Посада:',
	'confirmaccount-pos-0' => 'автор',
	'confirmaccount-pos-1' => 'редактор',
	'confirmaccount-bio' => 'Біографія:',
	'confirmaccount-notes' => 'Додаткова інформація:',
	'confirmaccount-urls' => 'Список веб-сайтів:',
	'confirmaccount-none-p' => '(не вказано)',
	'confirmaccount-econf' => '(підтверджено)',
	'confirmaccount-noreason' => '(нема)',
	'confirmaccount-create' => 'Підтвердити (створити обліковий запис)',
	'confirmaccount-ip' => 'IP-адреса:',
	'confirmaccount-submit' => 'Підтвердити',
	'confirmaccount-wsum' => 'Ласкаво просимо!',
	'confirmaccount-email-subj' => '{{SITENAME}}: запит облікового запису',
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
	'confirmaccount-submit' => 'Xác nhận',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
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
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'confirmaccount-real-q' => 'נאמען',
	'confirmaccount-email-q' => 'ע-פאסט',
	'confirmaccount-leg-user' => 'באַניצער קאנטע',
	'confirmaccount-name' => 'באַניצער נאָמען',
	'confirmaccount-real' => 'נאָמען:',
	'confirmaccount-email' => 'ע-פאסט:',
	'confirmaccount-pos-1' => 'רעדאַקטאָר',
	'confirmaccount-bio' => 'ביאגראַפֿיע',
	'confirmaccount-econf' => '(באשטעטיקט)',
	'confirmaccount-create' => 'באשטעטיקן (שאפֿן קאנטע)',
	'confirmaccount-hold' => 'האַלטן',
	'confirmaccount-submit' => 'באַשטעטיקן',
	'confirmaccount-wsum' => 'ברוך הבא!',
	'confirmaccount-email-body' => 'אײַער בקשה פֿאַר אַ קאנטע אויף {{SITENAME}} איז געווארן באַשטעטיקט. 

 באַניצער־נאָמען: $1 

 פאַסוואָרט: $2 

 צוליב זיכערהייַט סיבות וועט איר דאַרפֿן טוישן אייער פאַסוואָרט בײַם ערשטן ארײַנלאָגירן. 
 כדי ארײַנלאָגירן, ביטע גייט צו {{fullurl:Special:UserLogin}}.',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
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

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenxiaoqino
 * @author Hydra
 * @author Kuailong
 * @author Mark85296341
 * @author Wilsonmess
 */
$messages['zh-hans'] = array(
	'confirmaccounts' => '确认户口请求',
	'confirmedit-desc' => '允许下属机构确认账户请求',
	'confirmaccount-maintext' => "'''本页面用于确认 ''{{SITENAME}}''的账户请求'''.

每个帐户请求队列包括三个子队列。
一个是开放的请求，一个是被其他管理员搁置的请求，一个是最近被拒绝的请求。

当回复请求时，请仔细阅读。如有需要，确认其中包含的信息。
你的行为将被私下记录。
也希望你能审查任何在这发生的不是你本人的操作。",
	'confirmaccount-list' => '以下是正在等候批准的用户请求列表。
	已经批准的账户将会创建以及在这个列表中移除。已拒绝的用户将只会在这个表中移除。',
	'confirmaccount-list2' => '以下是一个先前拒绝过的帐口请求，可能会在数日后删除。
	它们仍旧可以批准创建一个账户，但是在您作之前请先问拒绝该账户的管理员。',
	'confirmaccount-list3' => '下面是可能于几天后被自动删除的过期帐号请求。他们依然可以被批准。',
	'confirmaccount-text' => "这个是在'''{{SITENAME}}'''中等候请求账户的页面。
	请小心阅读，有需要的话，就要同时确认它下面的全部资料。
	要留意的是您可以用另一个用户名字去创建一个账户。只有其他的名字有冲突时才需要去作。

	如果你无确认或者拒绝这个请求，只留下这页面的话，它便会维持等候状态。",
	'confirmaccount-none-o' => '在当前列表中没有正在等待批准的帐号请求。',
	'confirmaccount-none-h' => '在当前列表中没有被挂起的帐号请求。',
	'confirmaccount-none-r' => '在当前列表中没有刚刚被拒绝的帐号请求。',
	'confirmaccount-none-e' => '在当前列表中没有过期的帐号请求。',
	'confirmaccount-real-q' => '用户名',
	'confirmaccount-email-q' => '电子邮箱',
	'confirmaccount-bio-q' => '个人简介',
	'confirmaccount-showopen' => '开放的请求',
	'confirmaccount-showrej' => '被拒绝的请求',
	'confirmaccount-showheld' => '被挂起的请求',
	'confirmaccount-showexp' => '过期的请求',
	'confirmaccount-review' => '批准/拒绝',
	'confirmaccount-types' => '在下面选择一个账户确认队列',
	'confirmaccount-all' => '（显示所有队列）',
	'confirmaccount-type' => '队列：',
	'confirmaccount-type-0' => '可能的作者',
	'confirmaccount-type-1' => '可能的作者们',
	'confirmaccount-q-open' => '开放的请求',
	'confirmaccount-q-held' => '被挂起的请求',
	'confirmaccount-q-rej' => '最近拒绝的请求',
	'confirmaccount-q-stale' => '过期的请求',
	'confirmaccount-badid' => '提供的ID是没有未决定的请求。它可能已经被处理。',
	'confirmaccount-leg-user' => '用户账户',
	'confirmaccount-leg-areas' => '主要的兴趣范围',
	'confirmaccount-leg-person' => '个人信息',
	'confirmaccount-leg-other' => '其他信息',
	'confirmaccount-name' => '用户名字',
	'confirmaccount-real' => '名称：',
	'confirmaccount-email' => '电邮',
	'confirmaccount-reqtype' => '位置',
	'confirmaccount-pos-0' => '作者',
	'confirmaccount-pos-1' => '编辑',
	'confirmaccount-bio' => '传记',
	'confirmaccount-attach' => '简历或履历：',
	'confirmaccount-notes' => '注释：',
	'confirmaccount-urls' => '网站列表:',
	'confirmaccount-none-p' => '(没有提供)',
	'confirmaccount-confirm' => '用以下的按钮去批准或拒绝这个请求。',
	'confirmaccount-econf' => '（已批准）',
	'confirmaccount-reject' => '（于$2被[[User:$1|$1]]拒绝）',
	'confirmaccount-rational' => '给申请人的理由：',
	'confirmaccount-noreason' => '（无）',
	'confirmaccount-autorej' => '（此请求已因为无活动而自动被回绝）',
	'confirmaccount-held' => '(在$2 被[[User:$1|$1]]标记为"挂起")',
	'confirmaccount-create' => '接受 （创建账户）',
	'confirmaccount-deny' => '拒绝 （反列示）',
	'confirmaccount-hold' => '挂起',
	'confirmaccount-spam' => '垃圾（请不要发送电子邮件）',
	'confirmaccount-reason' => '注解 （在电邮中使用）:',
	'confirmaccount-ip' => 'IP地址：',
	'confirmaccount-legend' => '批准/拒绝这个帐号',
	'confirmaccount-submit' => '确认',
	'confirmaccount-needreason' => '您必须在下方的评论栏阐述您的理由。',
	'confirmaccount-canthold' => '该请求已被挂起，或已被删除。',
	'confirmaccount-acc' => '账户请求已经成功确认；已经创建一个新的用户帐号[[User:$1]]。',
	'confirmaccount-rej' => '账户请求已经成功拒绝。',
	'confirmaccount-viewing' => '（当前正由[[User:$1|$1]]浏览）',
	'confirmaccount-summary' => '正在创建一个新用户拥有传记的用户页面。',
	'confirmaccount-welc' => "'''欢迎来到''{{SITENAME}}''！'''
我们希望您会作出更多更好的贡献。
您可能想先阅读一下[[{{MediaWiki:Helppage}}|帮助页面]]。
再次欢迎您，祝您愉快！",
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
	'confirmaccount-email-body5' => '在你请求账户 "$1" 能在 {{SITENAME}} 被批准之前，你必须先提供一些附加信息。

$2

如果你想知道更多有关账户政策的信息，你可以使用网站中的联系列表。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'confirmaccounts' => '確認帳號請求',
	'confirmedit-desc' => '允許下屬機構確認帳號請求',
	'confirmaccount-maintext' => "'''本頁面用於確認 ''{{SITENAME}}''的帳戶請求'''.

每個帳戶請求隊列包括三個子隊列。
一個是開放的請求，一個是被其他管理員擱置的請求，一個是最近被拒絕的請求。

當回復請求時，請仔細閱讀。如有需要，確認其中包含的資訊。
你的行為將被私下記錄。
也希望你能審查任何在這發生的不是你本人的操作。",
	'confirmaccount-list' => '以下是正在等候批准的用戶請求列表。
	已經批准的帳戶將會建立以及在這個列表中移除。已拒絕的用戶將只會在這個表中移除。',
	'confirmaccount-list2' => '以下是一個先前拒絕過的帳口請求，可能會在數日後刪除。
	它們仍舊可以批准建立一個帳戶，但是在您作之前請先問拒絕該帳戶的管理員。',
	'confirmaccount-list3' => '下面是可能於幾天後被自動刪除的過期帳號請求。他們依然可以被批准。',
	'confirmaccount-text' => "這個是在'''{{SITENAME}}'''中等候請求帳戶的頁面。
	請小心閱讀，有需要的話，就要同時確認它下面的全部資料。
	要留意的是您可以用另一個用戶名字去創建一個帳戶。只有其他的名字有衝突時才需要去作。

	如果你無確認或者拒絕這個請求，只留下這頁面的話，它便會維持等候狀態。",
	'confirmaccount-none-o' => '在當前列表中沒有正在等待批准的帳號請求。',
	'confirmaccount-none-h' => '在當前列表中沒有被掛起的帳號請求。',
	'confirmaccount-none-r' => '在當前列表中沒有剛剛被拒絕的帳號請求。',
	'confirmaccount-none-e' => '在當前列表中沒有過期的帳號請求。',
	'confirmaccount-real-q' => '用戶名',
	'confirmaccount-email-q' => '電子郵箱',
	'confirmaccount-bio-q' => '個人簡介',
	'confirmaccount-showopen' => '開放的請求',
	'confirmaccount-showrej' => '被拒絕的請求',
	'confirmaccount-showheld' => '被掛起的請求',
	'confirmaccount-showexp' => '過期的請求',
	'confirmaccount-review' => '批准/拒絕',
	'confirmaccount-types' => '在下面選擇一個賬戶確認隊列',
	'confirmaccount-all' => '（顯示所有隊列）',
	'confirmaccount-type' => '隊列：',
	'confirmaccount-type-0' => '可能的作者',
	'confirmaccount-type-1' => '可能的作者們',
	'confirmaccount-q-open' => '開放的請求',
	'confirmaccount-q-held' => '被掛起的請求',
	'confirmaccount-q-rej' => '最近拒絕的請求',
	'confirmaccount-q-stale' => '過期的請求',
	'confirmaccount-badid' => '提供的ID是沒有未決定的請求。它可能已經被處理。',
	'confirmaccount-leg-user' => '使用者帳號',
	'confirmaccount-leg-areas' => '感興趣的主要領域',
	'confirmaccount-leg-person' => '個人資訊',
	'confirmaccount-leg-other' => '其他資訊',
	'confirmaccount-name' => '使用者名稱',
	'confirmaccount-real' => '名稱：',
	'confirmaccount-email' => '電郵',
	'confirmaccount-reqtype' => '位置',
	'confirmaccount-pos-0' => '作者',
	'confirmaccount-pos-1' => '編輯',
	'confirmaccount-bio' => '傳記',
	'confirmaccount-attach' => '簡歷或履歷：',
	'confirmaccount-notes' => '注釋：',
	'confirmaccount-urls' => '網站列表：',
	'confirmaccount-none-p' => '（未提供）',
	'confirmaccount-confirm' => '用以下的按鈕去批准或拒絕這個請求。',
	'confirmaccount-econf' => '（已批准）',
	'confirmaccount-reject' => '（於$2被[[User:$1|$1]]拒絕）',
	'confirmaccount-rational' => '理由給予申請人：',
	'confirmaccount-noreason' => '（無）',
	'confirmaccount-autorej' => '（此請求已因為無活動而自動被回絕）',
	'confirmaccount-held' => '(在$2 被[[User:$1|$1]]標記為"掛起")',
	'confirmaccount-create' => '接受 （建立帳號）',
	'confirmaccount-deny' => '拒絕 （反列示）',
	'confirmaccount-hold' => '掛起',
	'confirmaccount-spam' => '垃圾（請不要發送電子郵件）',
	'confirmaccount-reason' => '註解 （在電郵中使用）:',
	'confirmaccount-ip' => 'IP 位址：',
	'confirmaccount-legend' => '批准/拒絕這個帳號',
	'confirmaccount-submit' => '確認',
	'confirmaccount-needreason' => '您必須在下方的評論欄闡述您的理由。',
	'confirmaccount-canthold' => '該請求已被掛起，或已被刪除。',
	'confirmaccount-acc' => '帳戶請求已經成功確認；已經建立一個新的使用者帳號[[User:$1]]。',
	'confirmaccount-rej' => '帳戶請求已經成功拒絕。',
	'confirmaccount-viewing' => '（目前正由[[User:$1|$1]]瀏覽）',
	'confirmaccount-summary' => '正在建立一個新用戶擁有傳記的使用者頁面。',
	'confirmaccount-welc' => "'''歡迎來到''{{SITENAME}}''！'''
我們希望您會作出更多更好的貢獻。
您可能想先閱讀一下[[{{MediaWiki:Helppage}}|說明頁面]]。
再次歡迎您，祝您愉快！",
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

在這個網站中度提供了聯絡人列表，您可以用去知道更多使用者帳號方針的資料。',
	'confirmaccount-email-body5' => '在你請求帳戶 "$1" 能在 {{SITENAME}} 被批准之前，你必須先提供一些附加資訊。

$2

如果你想知道更多有關帳戶政策的資訊，你可以使用網站中的聯繫列表。',
);

