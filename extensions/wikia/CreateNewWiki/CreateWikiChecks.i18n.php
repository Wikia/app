<?php
/**
 * Internationalization file for CreateWikiChecks extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'autocreatewiki' => 'Create a new wiki',
	'autocreatewiki-desc' => 'Create wiki in WikiFactory by user requests',
	'autocreatewiki-page-title-default' => 'Create a new wiki',
	'autocreatewiki-page-title-answers' => 'Create a new Answers site',
	'createwiki' => 'Create a new wiki',
	'autocreatewiki-chooseone' => 'Choose one',
	'autocreatewiki-required' => '$1 = required',
	'autocreatewiki-web-address' => 'Web address:',
	'autocreatewiki-category-select' => 'Select one',
	'autocreatewiki-language-top' => 'Top $1 languages',
	'autocreatewiki-language-all' => 'All languages',
	'autocreatewiki-remember' => 'Remember me',
	'autocreatewiki-create-account' => 'Create an account',
	'autocreatewiki-haveaccount-question' => 'Do you already have a Wikia account?',
	'autocreatewiki-info-domain' => "It's best to use a word likely to be a search keyword for your topic.",
	'autocreatewiki-info-topic' => 'Add a short description such as "Star Wars" or "TV shows".',
	'autocreatewiki-info-category-default' => 'This will help visitors find your wiki.',
	'autocreatewiki-info-category-answers' => 'This will help visitors find your Answers site.',
	'autocreatewiki-info-language' => 'This will be the default language for visitors to your wiki.',
	'autocreatewiki-info-email-address' => 'Your email address is never shown to anyone on Wikia.',
	'autocreatewiki-info-realname' => 'If you choose to provide it, this will be used for giving you attribution for your work.',
	'autocreatewiki-info-birthdate' => 'Wikia requires all users to provide their real date of birth as both a safety precaution and as a means of preserving the integrity of the site while complying with federal regulations.',
	'autocreatewiki-info-blurry-word' => 'To help protect against automated account creation, please type the blurry word that you see into this field.',
	'autocreatewiki-info-terms-agree' => "By creating a wiki and a user account, you agree to the {{#NewWindowLink: w:Terms of use | Wikia's Terms of Use}}",
	'autocreatewiki-info-staff-username' => '<b>Staff only:</b> The specified user will be listed as the founder.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => 'Wikia has exceeded the maximum number of wiki creations today ($1).',
	'autocreatewiki-limit-creation' => 'You have exceeded the maximum number of wiki creation in 24 hours ($1).',
	'autocreatewiki-empty-field' => 'Please complete this field.',
	'autocreatewiki-bad-name' => 'The name cannot contain special characters (like $ or @) and must be a single lower-case word without spaces.',
	'autocreatewiki-invalid-wikiname' => 'The name cannot contain special characters (like $ or @) and cannot be empty',
	'autocreatewiki-violate-policy' => 'This wikia name contains a word that violates our naming policy',
	'autocreatewiki-name-taken' => 'There’s already a wikia with this address. Start editing at <a href="http://$1.wikia.com">http://$1.wikia.com</a> or choose another address.',
	'autocreatewiki-name-too-short' => 'This address is too short, choose an address with at least 3 characters.',
	'autocreatewiki-name-too-long' => 'This address is too long. Please choose an address with maximum 50 characters.',
	'autocreatewiki-similar-wikis' => 'Below are the wikis already created on this topic. We suggest editing one of them.',
	'autocreatewiki-invalid-username' => 'This username is invalid.',
	'autocreatewiki-busy-username' => 'This username is already taken.',
	'autocreatewiki-blocked-username' => 'You cannot create account.',
	'autocreatewiki-user-notloggedin' => 'Your account was created but not logged in!',
	'autocreatewiki-empty-language' => 'Please select the language for the wiki.',
	'autocreatewiki-empty-category' => 'Please select a category.',
	'autocreatewiki-empty-wikiname' => 'The name of the wiki cannot be empty.',
	'autocreatewiki-empty-username' => 'Username cannot be empty.',
	'autocreatewiki-empty-password' => 'Password cannot be empty.',
	'autocreatewiki-empty-retype-password' => 'Retype password cannot be empty.',
	'autocreatewiki-category-label' => 'Category:',
	'autocreatewiki-category-other' => 'Other',
	'autocreatewiki-set-username' => 'Set username first.',
	'autocreatewiki-invalid-category' => 'Invalid value of category.
Please select proper from dropdown list.',
	'autocreatewiki-invalid-language' => 'Invalid value of language.
Please select proper from dropdown list.',
	'autocreatewiki-invalid-retype-passwd' => 'Please retype the same password as above',
	'autocreatewiki-invalid-birthday' => 'Invalid birth date',
	'autocreatewiki-log-title' => 'Your wiki is being created',
	'autocreatewiki-step0' => 'Initializing process ...',
	'autocreatewiki-stepdefault' => 'Process is running, please wait ...',
	'autocreatewiki-errordefault' => 'Process was not finished ...',
	'autocreatewiki-step1' => 'Creating images folder ...',
	'autocreatewiki-step2' => 'Creating database ...',
	'autocreatewiki-step3' => 'Setting default information in database ...',
	'autocreatewiki-step4' => 'Copying default images and logo ...',
	'autocreatewiki-step5' => 'Setting default variables in database ...',
	'autocreatewiki-step6' => 'Setting default tables in database ...',
	'autocreatewiki-step7' => 'Setting language starter ...',
	'autocreatewiki-step8' => 'Setting user groups and categories ...',
	'autocreatewiki-step9' => 'Setting variables for new wiki ...',
	'autocreatewiki-step10' => 'Setting pages on central wiki ...',
	'autocreatewiki-step11' => 'Sending email to user ...',
	'autocreatewiki-redirect' => 'Redirecting to new wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Congratulations!',
	'autocreatewiki-welcometalk-log' => 'Welcome Message',
	'autocreatewiki-regex-error-comment' => 'used in wiki $1 (whole text: $2)',
	'autocreatewiki-step2-error' => 'Database exists!',
	'autocreatewiki-step3-error' => 'Cannot set default information in database!',
	'autocreatewiki-step6-error' => 'Cannot set default tables in database!',
	'autocreatewiki-step7-error' => 'Cannot copy starter database for language!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => 'Part of the official interface',
	'autocreatewiki-welcomesubject' => '$1 has been created!',
	'autocreatewiki-welcomebody' => 'Hello $2!

Your wiki has been created! Take a look: <$1>

Ready to get started? We’ve added some links to your talk page (<$5>) to help you get started and to encourage you to explore the many helpful areas around Wikia. If you have any questions or feel a bit lost, reply to this email or check out our Help pages <http://help.wikia.com>.

You can also check out the Founder & Admin blog <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> and the Wikia Staff blog <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> where you’ll find tips and tricks, info about new features and new things happening at Wikia.

Happy editing!

$3
Wikia Community Support
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Want to receive fewer messages from us? You can unsubscribe or change your email preferences here: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Welcome!',
	'autocreatewiki-welcometalk-wall' => "Hello, We're excited to have {{subst:SITENAME}} as part of the Wikia community!

There's still a lot to do; here are some helpful tips and links to get your wikia going:
*Check out [[Special:WikiFeatures|Wiki Features]] to see which features you can enable on your wikia, including Chat, Achievements and many more.
*Customize your wikia's look by visiting the [[Special:ThemeDesigner|Theme Designer]], where you can add color and style to your background and wordmark.
*Stop by [[w:c:community|Community Central]] to stay informed through our [[w:c:community:Blog:Wikia_Staff_Blog|staff blog]], ask questions on our [[w:c:community:Special:Forum|community forum]], participate in our [[w:c:community:Help:Webinars|webinar series]], or [[w:c:community:Special:Chat|chat live]] with fellow Wikians.
*Lastly, visit our [[Help:Contents|help pages]] to learn the ins and outs of using Wikia, including [[Help:New page|how to add a new page to your wikia]], [[Help:Attracting contributors|how to attract contributors]], and [[Help:User access levels|how to add other admins]].
* You can also use all of these tools by visiting your Admin Dashboard, which can by found by clicking \"Admin\" on the bottom toolbar.

All of the above links are a great place to start exploring, and have fun!",
	'autocreatewiki-welcometalk' => "==Welcome!==
Hey there!

We're excited to have $4 as part of the Wikia community! There's still a lot to do; here are some helpful tips and links to get your wikia going:

*Check out [[Special:WikiFeatures|Wiki Features]] to see which features you can enable on your wikia, including chat, achievements and much more.
*Stop by [[w:c:community|Community Central]] to stay informed through our [[w:c:community:Blog:Wikia_Staff_Blog|staff blog]], ask questions on our [[w:c:community:Special:Forum|community forum]], participate in our [[w:c:community:Help:Webinars|webinar series]], or chat live with fellow Wikians
*Lastly, visit our [[Help:Contents|help pages]] to learn the ins and outs of using Wikia

All of the above links are a great place to start exploring, and have fun!

-- [[User:$2|$3]] <staff />",
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Message documentation (This is the name of the message documentation language code (qqq). Follow the rules of your languages and use small first letter if it doesn't capitalize language names always. It might be easier to translate it as "translation guidelines" or "translation help".)
 * @author Prima klasy4na
 * @author Purodha
 * @author Shirayuki
 * @author Siebrand
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'autocreatewiki-desc' => '{{desc}}',
	'autocreatewiki-page-title-answers' => '"Answers sites" are  special wikis of the type answers.wikia.com, where you ask and answer questions.',
	'autocreatewiki-language-top' => 'When the user is choosing the wiki\'s language from a dropdown menu, the most commonly chosen languages are listed in a separate section of the menu. This message is the title for that "Top Languages" section. The $1 parameter is a  basic number (ex. 7 or 12) that matches the number of languages in the "Top Languages" section.',
	'autocreatewiki-create-account' => '{{Identical|Create an account}}',
	'autocreatewiki-info-category-answers' => '"Answers sites" are  special wikis of the type answers.wikia.com, where you ask and answer questions.',
	'autocreatewiki-info-realname' => '{{Identical|Real name attribution}}',
	'autocreatewiki-info-blurry-word' => 'Message {{msg-Wikia|Autocreatewiki-blurry-word}} refers here.',
	'autocreatewiki-title-template' => 'This will be the sitename of the wiki, i.e. the text that shows up in the TITLE element as well as in other places on the site.',
	'autocreatewiki-category-other' => '{{Identical|Other}}',
	'autocreatewiki-set-username' => 'If user does not provide a username when attempting to log in, an error message appears prompting a username to be provided',
	'autocreatewiki-welcometalk' => 'Text of the welcome message left for wiki founder upon wiki creation.
Parameters:

* $1 - User name of wiki founder
* $2 - <NO LONGER IN USE>
* $3 - Name of Wikia Community Support member who is signing the welcome message
* $4 - <nowiki>{{SITENAME}}</nowiki> of the wiki welcome message is being left on',
	'autocreatewiki-language-top-list' => 'Do not translate. List of the top 13 languages used for wiki creation.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'autocreatewiki' => "Skep 'n nuwe Wiki",
	'autocreatewiki-page-title-default' => "Skep 'n nuwe Wiki",
	'createwiki' => "Skep 'n nuwe Wiki",
	'autocreatewiki-chooseone' => 'Kies een',
	'autocreatewiki-required' => '$1 = word vereis',
	'autocreatewiki-web-address' => 'Webtuiste:',
	'autocreatewiki-category-select' => 'Kies een',
	'autocreatewiki-language-top' => 'Top $1 tale',
	'autocreatewiki-language-all' => 'Alle tale',
	'autocreatewiki-remember' => 'Onthou my',
	'autocreatewiki-create-account' => "Skep 'n rekening",
	'autocreatewiki-info-staff-username' => '<b>Slegs vir personeel:</b> die gespesifiseerde gebruiker sal as die stigter gelys word.',
	'autocreatewiki-title-template' => '$1 wiki',
	'autocreatewiki-empty-field' => 'Voltooi asseblief hierdie veld.',
	'autocreatewiki-invalid-username' => 'Hierdie gebruikersnaam is ongeldig.',
	'autocreatewiki-busy-username' => 'Hierdie gebruikersnaam is reeds geneem.',
	'autocreatewiki-user-notloggedin' => 'U rekening is geskep maar nie ingeteken nie.',
	'autocreatewiki-empty-language' => 'Kies asseblief die Wiki se taal.',
	'autocreatewiki-empty-category' => 'Kies asseblief een van die kategorieë.',
	'autocreatewiki-empty-wikiname' => 'Die naam van die Wiki kan nie leeg wees nie.',
	'autocreatewiki-empty-username' => 'Gebruikersnaam kan nie leeg wees nie.',
	'autocreatewiki-empty-password' => 'Wagwoord kan nie leeg wees nie.',
	'autocreatewiki-empty-retype-password' => 'Herhaling van wagwoord kan nie leeg wees nie.',
	'autocreatewiki-category-label' => 'Kategorie:',
	'autocreatewiki-category-other' => 'Ander',
	'autocreatewiki-set-username' => 'Stel eers die gebruikersnaam.',
	'autocreatewiki-invalid-birthday' => 'Ongeldige geboortedatum',
	'autocreatewiki-step2' => 'Besig om databasis te skep...',
	'autocreatewiki-congratulation' => 'Baie geluk!',
	'autocreatewiki-welcometalk-log' => 'Welkom-boodskap',
	'autocreatewiki-step2-error' => 'Databasis bestaan al!',
	'autocreatewiki-protect-reason' => 'Deel van die amptelike koppelvlak',
	'autocreatewiki-welcomesubject' => '$1 is geskep!',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Alexknight12
 * @author ترجمان05
 */
$messages['ar'] = array(
	'autocreatewiki' => 'أنشئ ويكي جديدة',
	'autocreatewiki-desc' => 'أنشأ ويكي في ويكيفاكتوري من قبل طلب المستخدم',
	'autocreatewiki-page-title-default' => 'إنشاء ويكي جديدة',
	'autocreatewiki-page-title-answers' => 'إنشاء موقع إجابات جديد',
	'createwiki' => 'إنشاء ويكي جديد',
	'autocreatewiki-chooseone' => 'إختر واحدة',
	'autocreatewiki-required' => '$1 = مطلوب',
	'autocreatewiki-web-address' => 'عنوان الويب:',
	'autocreatewiki-category-select' => 'إختر واحدة',
	'autocreatewiki-language-top' => ' أحسن $1 لغة',
	'autocreatewiki-language-all' => 'كل اللغات',
	'autocreatewiki-remember' => 'تذكرني',
	'autocreatewiki-create-account' => 'إنشاء حساب',
	'autocreatewiki-haveaccount-question' => 'هل لديك حساب على ويكيا؟',
	'autocreatewiki-info-domain' => 'من الافضل لاستخدام كلمة المحتمل أن تكون كلمة رئيسية للبحث عن الموضوع الخاص بك',
	'autocreatewiki-info-topic' => 'أضف وصفا موجزا مثل "لوست" أو "ناروو".',
	'autocreatewiki-info-category-default' => 'هذا يساعد الزوار على العثور على الويكي التي تنشأها',
	'autocreatewiki-info-category-answers' => 'هذا سوف يساعد الزوار على العثور على موقع الإجابات الذي تنشأه.',
	'autocreatewiki-info-language' => ' ستكون هذه هي اللغة الافتراضية للزوار الويكي الخاص بك',
	'autocreatewiki-info-email-address' => 'بريدك الإلكروني لن يظهر لأي شخص على ويكيا.',
	'autocreatewiki-info-realname' => 'إذا إخترت أن تزود هذه المعلومة فستستعمل في إعطائك الشكر على عملك.',
	'autocreatewiki-info-birthdate' => 'ويكيا تطلب من جميع المستخدمين تقديم تاريخ الولادة الحقيقي على حد سواء وذلك كاجراء وقائي كوسيلة للحفاظ على سلامة الموقع مع الامتثال للقوانين الاتحادية.',
	'autocreatewiki-info-blurry-word' => 'لمساعدة في حماية ضد إنشاء الحساب الآلي ، يرجى كتابة كلمة الباهتة التي تشاهدها في هذا المجال.',
	'autocreatewiki-info-terms-agree' => 'عن طريق إنشاء ويكي و حساب مستخدم، أنت توافق على <a href="http://www.wikia.com/wiki/Terms_of_use">شروط استخدام ويكيا</a>',
	'autocreatewiki-info-staff-username' => '<b>للموظفين فقط:</b> هذا المستخدم المحدد سيكون مدرجا كمؤسس.',
	'autocreatewiki-title-template' => 'ويكي $1',
	'autocreatewiki-limit-day' => 'لقد تجاوزت عدد ويكيا الأقصى لإنشاء الويكيات في هذا اليوم($1).',
	'autocreatewiki-limit-creation' => 'لقد تجاوزت الحد الأقصى لعدد من إنشاء ويكي في 24 ساعة ($1).',
	'autocreatewiki-empty-field' => 'يرجى استكمال هذا المجال.',
	'autocreatewiki-bad-name' => 'هذا الإسم لا يمكنه أن يحتوي على أحرف خاصة (مثل $ أو @)و يجب أن يكون كلمة مفردة بدون مسافات.',
	'autocreatewiki-invalid-wikiname' => 'الإسم لا يمكن أن يحتوي على أحرف خاصة (مثل  $ أو @) و لا يمكن أن يكون فارغا',
	'autocreatewiki-violate-policy' => 'اسم الويكي هذا يحتوي على كلمة تخالف سياسة التسمية',
	'autocreatewiki-similar-wikis' => 'فيما يلي ويكيات تم إنشاؤها سابقاً تحمل نفس هذا الموضوع. نقترح عليك المشاركة في واحدة منهم.',
	'autocreatewiki-invalid-username' => 'اسم المستخدم هذا غير صحيح.',
	'autocreatewiki-busy-username' => 'اسم المستخدم هذا مستعمل من قبل مسخدم آخر',
	'autocreatewiki-blocked-username' => 'لا يمكنك إنشاء حساب.',
	'autocreatewiki-user-notloggedin' => 'تم إنشاء الحساب الخاص بك ولكن لم تسجل دخولك!',
	'autocreatewiki-empty-language' => 'الرجاء تحديد لغة الويكي.',
	'autocreatewiki-empty-category' => 'الرجاء تحديد فئة.',
	'autocreatewiki-empty-wikiname' => 'لا يمكن أن يكون اسم الويكي فارغا.',
	'autocreatewiki-empty-username' => 'لا يمكن أن يكون اسم المستخدم فارغاً.',
	'autocreatewiki-empty-password' => 'لا يمكن أن تكون كلمة السر فارغة.',
	'autocreatewiki-empty-retype-password' => 'لا يمكن أن تكون إعادة كتابة كلمة السر فارغة.',
	'autocreatewiki-category-label' => 'الفئة:',
	'autocreatewiki-category-other' => 'أخرى',
	'autocreatewiki-set-username' => 'قم بتعيين اسم المستخدم أولاً.',
	'autocreatewiki-invalid-category' => 'فئة غير صحيحة.
الرجاء اختيار فئة مناسبة من القائمة المنسدلة.',
	'autocreatewiki-invalid-language' => 'لغة غير صحيحة.
الرجاء اختيار لغة مناسبة من القائمة المنسدلة.',
	'autocreatewiki-invalid-retype-passwd' => 'الرجاء إعادة كتابة كلمة السر الواردة أعلاه',
	'autocreatewiki-invalid-birthday' => 'تاريخ الميلاد غير صحيح',
	'autocreatewiki-log-title' => 'يتم الآن إنشاء الويكي',
	'autocreatewiki-step0' => 'تهيئة العملية ...',
	'autocreatewiki-stepdefault' => 'العملية قيد التشغيل، الرجاء الانتظار...',
	'autocreatewiki-errordefault' => 'لم يتم الإنتهاء من العملية...',
	'autocreatewiki-congratulation' => 'مبروك!',
	'autocreatewiki-welcometalk-log' => 'رسالة ترحيب',
	'autocreatewiki-welcometalk-wall-title' => 'مرحبا!',
	'autocreatewiki-welcometalk' => '==مرحبا!==
و أهلا بك!

نحن متحمسون لكون  $4  جزءا من مجتمع ويكيا! هناك الكثير من الأشياء التي يجب القيام بها؛ إليك بعض النصائح والوصلات المفيدة للحصول على ويكي جيدة:

* تحقق من [[خاص:WikiFeatures|خاصيات الويكي]] لمعرفة الميزات التي يمكن تفعيلها في الويكي الخاصة بك، بما في ذلك الدردشة والإنجازات والكثير من الخاصيات الأخرى.
* قم بزيارة [[w:c:ar|مركز ويكيا]] لكي تبقى على إطلاع بالأحداث من خلال [[w:c:ar:Blog:ويكيا|مدونة ويكيا]]، كما يمكنك طرح الأسئلة هناك أيضا عن طريق [[w:c:community:Special:Forum|منتدانا]]، والمشاركة في أعمالنا عن طريق [[w:c:community:Help:Webinars|المؤتمرات]]، بإمكانك أيضا الدردشة مع زملائك الويكيين هناك
* وأخيراً، قم بزيارة [[مساعدة:محتويات|صفحات المساعدة]] لمعرفة خصوصيات وعموميات استخدام ويكيا

جميع الروابط أعلاه هي أفضل طريقة لاستكشاف عالم الويكيات، استمتع بوقتك معنا!

-- [[مستخدم:$2|$3]]<staff />',
);

/** Assamese (অসমীয়া)
 * @author Bishnu Saikia
 */
$messages['as'] = array(
	'autocreatewiki' => 'এখন নতুন ৱিকি সৃষ্টি কৰক',
	'autocreatewiki-page-title-default' => 'এখন নতুন ৱিকি সৃষ্টি কৰক',
	'createwiki' => 'এখন নতুন ৱিকি সৃষ্টি কৰক',
	'autocreatewiki-required' => '$1 = প্ৰয়োজন',
	'autocreatewiki-web-address' => 'ৱেব ঠিকনা:',
	'autocreatewiki-category-select' => 'এটা নিৰ্বাচন কৰক',
	'autocreatewiki-language-top' => 'শীৰ্ষৰ $1 ভাষাসমূহ',
	'autocreatewiki-language-all' => 'সকলোবোৰ ভাষা',
	'autocreatewiki-remember' => 'মোৰ প্ৰৱেশ মনত ৰাখক',
	'autocreatewiki-create-account' => 'নতুন একাউণ্ট খোলক',
	'autocreatewiki-title-template' => '$1 ৱিকি',
	'autocreatewiki-invalid-username' => 'এই সদস্য নাম অবৈধ',
	'autocreatewiki-busy-username' => 'এই সদস্যনাম ইতিমধ্যে আছেই',
	'autocreatewiki-blocked-username' => 'আপুনি একাউণ্ট সৃষ্টি কৰিব নোৱাৰে',
	'autocreatewiki-category-label' => 'শ্ৰেণী:',
	'autocreatewiki-category-other' => 'অন্যান্য',
	'autocreatewiki-invalid-birthday' => 'অবৈধ জন্মৰ তাৰিখ',
	'autocreatewiki-congratulation' => 'অভিন্দন!',
	'autocreatewiki-welcometalk-log' => 'আদৰণি বাৰ্তা',
	'autocreatewiki-welcomesubject' => '$1 সৃষ্টি কৰা হ’ল!',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'autocreatewiki-web-address' => 'Veb ünvanı:',
	'autocreatewiki-language-all' => 'Bütün dillər',
	'autocreatewiki-title-template' => '$1 Viki',
	'autocreatewiki-category-label' => 'Kateqoriya:',
	'autocreatewiki-category-other' => 'Digər',
);

/** Batak Toba (Batak Toba)
 * @author Stephensuleeman
 */
$messages['bbc-latn'] = array(
	'autocreatewiki-title-template' => '$1 Wikia',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'autocreatewiki' => 'Стварыць новую вікі',
	'autocreatewiki-page-title-default' => 'Стварыць новую вікі',
	'autocreatewiki-language-all' => 'Усе мовы',
);

/** Bulgarian (български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'autocreatewiki' => 'Създаване на ново уики',
	'autocreatewiki-page-title-default' => 'Заявка за ново уики',
	'createwiki' => 'Създаване на уики',
	'autocreatewiki-required' => '$1 = задължително',
	'autocreatewiki-web-address' => 'Уеб адрес:',
	'autocreatewiki-language-all' => 'Всички езици',
	'autocreatewiki-create-account' => 'Създаване на сметка',
	'autocreatewiki-bad-name' => 'Името не може да съдържа специални символи (като $ или @) и е необходимо да е една дума, изписана с малки букви и без интервали.',
	'autocreatewiki-violate-policy' => 'Името на уикито съдържа дума, която нарушава политиката ни за наименуване',
	'autocreatewiki-name-taken' => 'Вече съществува уики с този адрес. Можете да го редактирате на <a href="http://$1.wikia.com">http://$1.wikia.com</a> или да изберете друг адрес.',
	'autocreatewiki-name-too-short' => 'Този адрес е твърде кратък. Изберете адрес с поне 3 знака.',
	'autocreatewiki-name-too-long' => 'Този адрес е твърде дълъг. Изберете адрес, състоящ се от най-много 50 знака.',
	'autocreatewiki-similar-wikis' => 'По-долу са уикитата на тази тема, които вече съществуват. Обмислете да допринасяте към някое от тях.',
	'autocreatewiki-invalid-username' => 'Това потребителско име е невалидно.',
	'autocreatewiki-busy-username' => 'Избраното потребителско име е вече заето.',
	'autocreatewiki-empty-username' => 'Полето за потребителско име не може да бъде празно.',
	'autocreatewiki-empty-password' => 'Полето за парола не може да бъде празно.',
	'autocreatewiki-category-label' => 'Категория:',
	'autocreatewiki-invalid-birthday' => 'Невалидна дата на раждане',
	'autocreatewiki-step0' => 'Стартиране на процеса ...',
	'autocreatewiki-step1' => 'Създаване на директорията за изображения ...',
	'autocreatewiki-step2' => 'Създаване на базата данни ...',
	'autocreatewiki-step4' => 'Копиране на основните изображения и лого ...',
	'autocreatewiki-step5' => 'Създаване на основните променливи в базата от данни ...',
	'autocreatewiki-step6' => 'Създаване на основните таблици в базата от данни ...',
	'autocreatewiki-step8' => 'Създаване потребителски групи и категории ...',
	'autocreatewiki-step9' => 'Създаване променливите за новото уики ...',
	'autocreatewiki-step10' => 'Създаване страници в централното уики ...',
	'autocreatewiki-redirect' => 'Пренасочване към новото уики: $1 ...',
	'autocreatewiki-congratulation' => 'Поздравления!',
	'autocreatewiki-step2-error' => 'Базата данни съществува!',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'autocreatewiki' => 'Krouiñ ur Wiki nevez.',
	'autocreatewiki-desc' => 'Krouiñ ur wiki er WikiFactory dre rekedoù implijerien',
	'autocreatewiki-page-title-default' => 'Krouiñ ur wiki nevez',
	'autocreatewiki-page-title-answers' => "Krouiñ ul lec'hienn respontoù nevez",
	'createwiki' => 'Krouiñ ur Wiki nevez',
	'autocreatewiki-chooseone' => 'Dibab unan',
	'autocreatewiki-required' => '$1 = dre ret',
	'autocreatewiki-web-address' => "Chomlec'h web :",
	'autocreatewiki-category-select' => 'Diuzañ unan',
	'autocreatewiki-language-top' => 'Ar $1 yezh implijetañ',
	'autocreatewiki-language-all' => 'An holl yezhoù',
	'autocreatewiki-remember' => "Derc'hel soñj ac'hanon",
	'autocreatewiki-create-account' => 'Krouiñ ur gont',
	'autocreatewiki-haveaccount-question' => 'Hag ur gont Wikia ho peus dija ?',
	'autocreatewiki-info-domain' => "Ar gwellañ zo implijout ur ger a vo, evit doare, ur ger-alc'hwez evit klask diwar-benn ho tanvez.",
	'autocreatewiki-info-topic' => 'Ouzhpennañ un deskrivadur evel « Brezel ar Stered » pe « Abadenn skinwel ».',
	'autocreatewiki-info-category-default' => 'Sikour a raio an dra-mañ ar weladennerien da gavout ho wiki.',
	'autocreatewiki-info-category-answers' => "Sikour a raio an dra-mañ ar weladennerien da gavout ho lec'hienn Respontoù.",
	'autocreatewiki-info-language' => "An dra-se a c'hall bezañ ar yezh dre ziouer evit an dud a zeu da welet ho wiki.",
	'autocreatewiki-info-email-address' => "Morse ne vez diskouezet ho chomlec'h da zen ebet war wiki.",
	'autocreatewiki-info-realname' => "Ma tibabit reiñ ho kwir anv e vo implijet evit reiñ ho labour deoc'h.",
	'autocreatewiki-info-birthdate' => "Goulenn a ra Wikia digant an implijerien reiñ o deiziad ganedigezh gwirion evel doare gwareziñ hag evel doare diwall anterinder al lec'hienn en ur sevel a-du gant reolennoù kevredadel ar Stadoù-Unanet.",
	'autocreatewiki-info-blurry-word' => "Evit sikour ac'hanomp d'en em wareziñ a-enep krouiñ emgefreek kontoù, biskrivit ar ger dispis a welit er vaezienn-mañ.",
	'autocreatewiki-info-terms-agree' => 'Pa vez krouet ur wiki hag ur gont implijer ez asantit da <a href="http://www.wikia.com/wiki/Terms_of_use"> amplegadoù implijout Wiki</a>.',
	'autocreatewiki-info-staff-username' => '<b>Skipailh hepken:</b> an implijer spisaet a dremeno da ziazezer ar wiki.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => 'Aet eo Wikia dreist bevenn krouiñ ar wikioù nevez hiziv ($1).',
	'autocreatewiki-limit-creation' => "Aet oc'h dreist bevenn uhelañ ar c'hrouiñ wiki dindan 24 eurvezh ($1).",
	'autocreatewiki-empty-field' => 'Mar plij leunit an takad-mañ.',
	'autocreatewiki-bad-name' => 'An anv zo da bezañ skrivet gant lizherennoù bihan, hep esaouennoù hag hep arouezennoù dibar (evel $ hag @).',
	'autocreatewiki-invalid-wikiname' => "Ne c'haller ket skrivañ an anv gant arouezennoù dibar (evel \$ hag @) ha ne c'hall ket bezañ goullo.",
	'autocreatewiki-violate-policy' => 'Un anv zo er wiki-se a dorr hor politikerezh a-fet reiñ anvioù.',
	'autocreatewiki-name-taken' => 'Ur wiki a zo dija d\'ar chomlec\'h-se. Kemerit perzh war <a href="http://$1.wikia.com">http://$1.wikia.com</a> pe dibabit ur chomlec\'h all.',
	'autocreatewiki-name-too-short' => "Re verr eo ar chomlec'h, dibabit ur chomlec'h gant 3 araouezenn d'an nebeutañ.",
	'autocreatewiki-name-too-long' => "Re hir eo ar chomlec'h, dibabit ur chomlec'h gant 50 arouezenn d'ar muiañ.",
	'autocreatewiki-similar-wikis' => "Ur roll wikioù krouet war an hevelep danvez zo diskwelet amañ dindan. Kinnig a reomp deoc'h mont war unan anezho.",
	'autocreatewiki-invalid-username' => "N'eo ket mat an anv-implijer-mañ.",
	'autocreatewiki-busy-username' => 'Kemeret eo an anv implijer dija.',
	'autocreatewiki-blocked-username' => "Ne c'heloc'h ket krouiñ ur gont.",
	'autocreatewiki-user-notloggedin' => "Krouet eo bet ho kont met n'oc'h ket kevreet !",
	'autocreatewiki-empty-language' => 'Dibabit yezh ar wiki, mar plij.',
	'autocreatewiki-empty-category' => 'Mar plij dibabit ur rummad.',
	'autocreatewiki-empty-wikiname' => "Goullo ne c'hall ket bezañ anv ar wiki.",
	'autocreatewiki-empty-username' => "Goullo ne c'hall ket bezañ an anv implijer.",
	'autocreatewiki-empty-password' => "Ne c'hell ket bezañ goullo ar ger tremen",
	'autocreatewiki-empty-retype-password' => "Goullo ne c'hall ket ar ger-tremen adlakaet bezañ",
	'autocreatewiki-category-label' => 'Rummad :',
	'autocreatewiki-category-other' => 'All',
	'autocreatewiki-set-username' => 'Termenit an anv implijer da gentañ.',
	'autocreatewiki-invalid-category' => 'Talvoud direizh evit ar rummad. Dibabit un talvoud er roll, mar plij.',
	'autocreatewiki-invalid-language' => 'Yezh direizh evit ar rummad. Dibabit ur yezh er roll, mar plij.',
	'autocreatewiki-invalid-retype-passwd' => 'Skrivit ar ger-tremen amañ a-us, mar plij.',
	'autocreatewiki-invalid-birthday' => 'Deiziad ganedigezh direizh',
	'autocreatewiki-log-title' => 'Emeur o krouiñ ho wiki',
	'autocreatewiki-step0' => 'Adderaouekaat...',
	'autocreatewiki-stepdefault' => 'An argerzh zo dindan seveniñ , gortozit...',
	'autocreatewiki-errordefault' => "N'eo ket echu an argerzh...",
	'autocreatewiki-step1' => 'Krouiñ renkell ar skeudennoù...',
	'autocreatewiki-step2' => 'O krouiñ an diaz roadennoù...',
	'autocreatewiki-step3' => 'Ouzhpennañ titouroù dre ziouer war an diaz roadennoù...',
	'autocreatewiki-step4' => 'Eilañ ar skeudennoù dre ziouer hag al logo...',
	'autocreatewiki-step5' => 'Ouzhpennañ argemmennoù dre ziouer an diaz roadennoù...',
	'autocreatewiki-step6' => 'Ouzhpennañ an taolennoù dre ziouer en diaz roadennoù...',
	'autocreatewiki-step7' => 'Ouzhpennañ diazoù evit ar yezh...',
	'autocreatewiki-step8' => 'Ouzhpennañ strolladoù implijerien ha rummadoù...',
	'autocreatewiki-step9' => 'Ouzhpennañ argemmennoù ar wiki nevez...',
	'autocreatewiki-step10' => 'Ouzhpennañ pajennoù er wiki kreiz...',
	'autocreatewiki-step11' => "Kas ar postel d'an implijer...",
	'autocreatewiki-redirect' => 'Adkas war-du ar wiki nevez : $1 ...',
	'autocreatewiki-congratulation' => "Gourc'hemennoù !",
	'autocreatewiki-welcometalk-log' => 'Kemennadenn Degemer',
	'autocreatewiki-regex-error-comment' => 'implijet er wiki $1 (skrid  klok : $2)',
	'autocreatewiki-step2-error' => "Bez' ez eus c'hoazh eus an diaz roadennoù-se !",
	'autocreatewiki-step3-error' => "Ne c'haller ket ouzhpennañ an titouroù dre ziouer en diaz roadennoù !",
	'autocreatewiki-step6-error' => "Ne c'haller ket ouzhpennañ an taolennoù dre ziouer en diaz roadennoù !",
	'autocreatewiki-step7-error' => "N'haller ket eilañ an diaz roadennoù diazez evit ar ar yezh-mañ !",
	'autocreatewiki-protect-reason' => 'Darn eus an etrefas ofisiel',
	'autocreatewiki-welcomesubject' => 'Krouet eo bet ar $1 !',
	'autocreatewiki-welcomebody' => "Demat, $2,

Ar Wikia zo bet savet ganeoc'h a gaver bremañ war <$1> Emichañs e kemerot perzh ennañ a-zevri evit e lakaat da vevañ !

Degaset hon eus un nebeud titouroù war ho pajenn gaozeal (<$5>) evit sikour ac'hanoc'h da gregiñ ganti.

M'hoc'h eus goulennoù c'hoazh e c'hallit goulenn sikour ouzh ar gumuniezh war ar wiki <http://www.wikia.com /wiki/Forum:Help_desk>, pe dre bostel d'ar chomlec'h community@wikia.com. Gallout a rit respont pe sellet ouzh hor pajennoù skoazell : <http://irc.wikia.com>.

Chañs vat deoc'h en ho raktres .


$3

Skipailh Kumuniezh Wikia

<http://www.wikia.com/wiki/User:$4>",
	'autocreatewiki-welcometalk-wall-title' => "Deuet-mat oc'h !",
	'autocreatewiki-welcometalk' => "== Degemer mat ! ==
<div style=\"font-size:120%; line-height:1.2em;\">Demat deoc'h \$1 -- lorc'h zo ennomp oc'h herberc'hiañ ho lec'hienn '''\$4''' er gumuniezh  Wiki!

Bremañ ho peus ul lec'hienn Genrouedad a vo ret kargañ gant titouroù, skeudennoù ha videoioù. Goullo eo  bremañ avat ha gortoz a ra ac'hanout... Aon ho peus rak se ? Setu un nebeud alioù evit kregiñ mat ganti.

* '''Deskrivit' an danvez''' war ar bajenn zegemer. Gant se e c'hallit displegañ d'ho lennerien peseurt danvezioù a blij deoc'h ar gwellañ. Skrivit kement tra ho peus c'hoant ! Gallout a rit krouiñ liammoù en ho teskrivadur war-du holl bajennoù pouezus ho wiki.

* '''Boulc'hit un nebeud pajennoù''' --  gant un nebeud frazennoù hepken evit kregiñ ganti. Na lezit pajenn wenn ebet ! Graet eo ur wiki ivez evit ouzhpennañ  skeudennoù ha videoioù, evit klokaat ar pajennoù ha lakaat anezho da vezañ dedennusoc'h.

Ha kendalc'hit goude ! Plijout a ra d'an dud mont war ar wikioù ma vez traoù da lenn, kendalc'hit neuze da skrivañ warno evit dedennañ al lennerien hag an embannerien. Kalz a draoù a chom d'ober -- ne rit ket biloù -- hiziv emañ an deiz kentañ, ha kalz amzer ho peus evit en ober. An holl wikioù zo bet krouet deiz pe zeiz -- ur pennad amzer zo ezhomm evit kregiñ da skrivañ un nebeud pajennoù, betek dont da vezañ ul lec'hienn vras

M'ho peus goulennoù da sevel e c'hallit skrivañ ur gerig dimp war ar bajenn  [[Special:Contact|contact form]]-mañ. Hetiñ a reomp kalz a blijadur deoc'h !

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Catalan (català)
 * @author BroOk
 * @author Marcmpujol
 */
$messages['ca'] = array(
	'autocreatewiki' => 'Crea un nou wiki',
	'autocreatewiki-desc' => "Crear un wiki en WikiFactory a petició d'un usuari",
	'autocreatewiki-page-title-default' => 'Crear un nou wiki',
	'autocreatewiki-page-title-answers' => 'Crear un nou lloc de Respostes',
	'createwiki' => 'Crear un nou wiki',
	'autocreatewiki-chooseone' => 'Tria una',
	'autocreatewiki-required' => '$1 = requerit',
	'autocreatewiki-web-address' => 'Adreça Web:',
	'autocreatewiki-category-select' => 'Selecciona una',
	'autocreatewiki-language-top' => 'Top $1 de llengües',
	'autocreatewiki-language-all' => 'Totes les llengües',
	'autocreatewiki-remember' => 'Recordar-me',
	'autocreatewiki-create-account' => 'Crear un compte',
	'autocreatewiki-haveaccount-question' => 'Ja tens un compte de Wikia?',
	'autocreatewiki-info-domain' => 'És millor utilitzar les paraules que tinguin més possibilitats de ser buscades sobre el tema del teu wiki.',
	'autocreatewiki-info-topic' => 'Afegir una breu descripció, com ara "Star Wars" o "Programes de TV".',
	'autocreatewiki-info-category-default' => 'Això ajudarà als visitants a trobar el seu wiki.',
	'autocreatewiki-info-category-answers' => 'Això ajudarà als visitants a trobar el seu lloc de Respostes.',
	'autocreatewiki-info-language' => 'Aquesta serà la llengua per defecte pels visitants del teu wiki.',
	'autocreatewiki-info-email-address' => 'La teva adreça de correu electrònic mai es mostrarà a ningú en Wikia.',
	'autocreatewiki-info-realname' => "Si esculls proporcionar-lo, s'utilitzarà per donar-te reconeixement per la teva feina.",
	'autocreatewiki-info-birthdate' => 'Wikia requereix que tots els usuaris proporcionin la seva veritable data de naixement com a mesura de seguretat i com a mitjà de preservar la integritat del lloc mentre compleixi amb els reglaments federals.',
	'autocreatewiki-info-blurry-word' => 'Per ajudar a protegir contra la creació automatitzada de comptes, si us plau, escriviu la paraula borrosa que veus en aquest camp.',
	'autocreatewiki-info-terms-agree' => "Mitjançant la creació d'un wiki i un compte d'usuari, vostè accepta els <a href=\"http://www.wikia.com/wiki/Terms_of_use\">Termes d'ús de Wikia</a>",
	'autocreatewiki-info-staff-username' => "<b>Només Staff:</b> L'usuari especificat figurarà com el fundador del wiki.",
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => "Wikia ha superat el nombre màxim de creacions de wikis d'avui ($1).",
	'autocreatewiki-limit-creation' => 'Has superat el nombre màxim de creació de wikis en 24 hores ($1).',
	'autocreatewiki-empty-field' => 'Si us plau, completa aquest camp.',
	'autocreatewiki-bad-name' => 'El nom no pot contenir caràcters especials (com $ o @) i han de ser paraules simples i sense espais.',
	'autocreatewiki-invalid-wikiname' => 'El nom no pot contenir caràcters especials (com $ o @) i el camp no pot estar buit.',
	'autocreatewiki-violate-policy' => 'El nom del wiki conté una paraula que viola la nostra política de noms',
	'autocreatewiki-name-taken' => 'Ja hi ha un wiki amb aquesta adreça. Començar a editar a <a href="http://<span class=" notranslate"="">$1.wikia.com">http:// $1 . wikia.com</a> o trieu una altra adreça.',
	'autocreatewiki-name-too-short' => 'Aquesta adreça és massa curta, tria una adreça amb com a mínim 3 caràcters.',
	'autocreatewiki-name-too-long' => 'Aquesta adreça és massa llarga. Trieu una adreça amb un màxim de 50 caràcters.',
	'autocreatewiki-similar-wikis' => "A continuació es presenten els wikis ja creats sobre aquest tema. Us recomanem editar en algun d'ells.",
	'autocreatewiki-invalid-username' => "Aquest nom d'usuari no és vàlid.",
	'autocreatewiki-busy-username' => "Aquest nom d'usuari ja està utilitzat.",
	'autocreatewiki-blocked-username' => 'No pots crear el compte.',
	'autocreatewiki-user-notloggedin' => 'El teu compte va ser creat, però no et vas identificar!',
	'autocreatewiki-empty-language' => 'Si us plau, selecciona la llengua del wiki.',
	'autocreatewiki-empty-category' => 'Si us plau, selecciona una de les categories.',
	'autocreatewiki-empty-wikiname' => 'El camp del nom del wiki no pot estar buit.',
	'autocreatewiki-empty-username' => "El camp del nom d'usuari no pot estar buit.",
	'autocreatewiki-empty-password' => 'El camp de la contrasenya no pot estar buit.',
	'autocreatewiki-empty-retype-password' => 'El camp per a tornar a escriure la contrasenya no pot estar buit.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Altre',
	'autocreatewiki-set-username' => "En primer lloc, estableix el nom d'usuari.",
	'autocreatewiki-invalid-category' => 'Valor no vàlid per a la categoria.
Si us plau, selecciona el correcte des de la llista desplegable de sota.',
	'autocreatewiki-invalid-language' => 'Valor no vàlid per a la llengua.
Si us plau, selecciona el correcte des de la llista desplegable de sota.',
	'autocreatewiki-invalid-retype-passwd' => 'Torneu a escriure la mateixa contrasenya que a dalt.',
	'autocreatewiki-invalid-birthday' => 'Data de naixement no vàlida',
	'autocreatewiki-log-title' => "S'està creant el teu wiki",
	'autocreatewiki-step0' => 'Inicialitzant el procés ...',
	'autocreatewiki-stepdefault' => "S'està executant el procés, si us plau, espera ...",
	'autocreatewiki-errordefault' => 'El procés no va ser acabat ...',
	'autocreatewiki-step1' => "Creant carpeta d'imatges ...",
	'autocreatewiki-step2' => 'Creant base de dades ...',
	'autocreatewiki-step3' => 'Configurant la informació per defecte en la base de dades ...',
	'autocreatewiki-step4' => 'Copiant imatges i logo per defecte ...',
	'autocreatewiki-step5' => 'Configurant variables per defecte en la base de dades ...',
	'autocreatewiki-step6' => 'Configurant taules per defecte en la base de dades ...',
	'autocreatewiki-step7' => 'Configurant la llengua del starter ...',
	'autocreatewiki-step8' => "Configurant grups d'usuaris i categories ...",
	'autocreatewiki-step9' => 'Configurant les variables per al nou wiki ...',
	'autocreatewiki-step10' => 'Configurant les pàgines de la central de Wikia ...',
	'autocreatewiki-step11' => "Enviant correu electrònic a l'usuari ...",
	'autocreatewiki-redirect' => 'Redirigint al nou wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Felicitats!',
	'autocreatewiki-welcometalk-log' => 'Missatge de benvinguda',
	'autocreatewiki-regex-error-comment' => 'utilitzat en $1 wiki (text íntegre: $2)',
	'autocreatewiki-step2-error' => 'La base de dades ja existeix!',
	'autocreatewiki-step3-error' => 'No es pot configurar la informació per defecte en la base de dades!',
	'autocreatewiki-step6-error' => 'No es poden configurar les taules per defecte en la base de dades!',
	'autocreatewiki-step7-error' => "No es pot copiar l'starter per aquesta llengua en la base de dades!",
	'autocreatewiki-protect-reason' => 'Part de la interfície oficial',
	'autocreatewiki-welcomesubject' => "$1 s'ha creat!",
	'autocreatewiki-welcomebody' => 'Hola $2!

S\'ha creat el teu wiki! Fes-li una ullada: <$1>

Preparat per començar? Hem afegit alguns enllaços a la pàgina de discussió (<$5>) que t\'ajudarà a començar i per animar-te a explorar les moltes àrees útils al voltant de Wikia. Si vostè té alguna pregunta o estàs una mica perdut, respon a aquest missatge o comprova les nostres pàgines d\'ajuda <http://ayuda.wikia.com=""> (en espanyol).

També pots comprovar el bloc dels Fundadors i Administradors <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> (en anglès) i el bloc de l\'Staff de Wikia <http://comunidad.wikia.com/wiki/Blog:Actualizaciones_t%C3%A9cnicas> (en espanyol) on trobaràs consells i trucs, informació sobre novetats i coses noves que passen a Wikia.

Gaudeix editant!

$3
L\'equip Comunitari de Wikia
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Vols rebre menys missatges de nosaltres? Pots cancel·lar la subscripció o canviar les preferències de correu electrònic aquí: http://ca.wikia.com/wiki/Especial:Prefer%C3%A8ncies',
	'autocreatewiki-welcometalk-wall-title' => 'Benvingut!',
	'autocreatewiki-welcometalk-wall' => "Hola, ens alegrem de tenir {{subst:SITENAME}} com a part de la comunitat de Wikia!

Encara tens moltes coses a fer; aquí et donem alguns consells i enllaços que t'ajudaran a millorar el wiki:
*Fes un cop d'ull a les [[Special:WikiFeatures|Wiki Funcionalitats]] per veure quina funcionalitat pot ser activada al teu wiki, com ara el Xat, els Assoliments i moltes més.
* Para't un moment a la [[w:ca:|Comunitat Central]] per estar informat de les últimes [[w:ca:Blog:Notícies de Wikia|notícies de Wikia]], fer preguntes al nostre [[w:ca:Forum:Index|fòrum comunitari]] i [[w:ca:Especial:Chat|xatejar]] amb altres usuaris.
* Llegeix les [[Help:Contents|pàgines d'ajuda]] per respondre les preguntes que puguis tenir.

Tots els enllaços anteriors són llocs magnífics per començar a explorar Wikia i, sobretot, passar-s'ho bé!",
	'autocreatewiki-welcometalk' => "==Benvingut!==
Hola!

Ens alegrem que $4 sigui part de la comunitat de Wikia! Encara tens moltes coses a fer; aquí et donem alguns consells i enllaços que t'ajudaran a millorar el wiki:
*Fes un cop d'ull a les [[Special:WikiFeatures|Wiki Funcionalitats]] per veure quina funcionalitat pot ser activada al teu wiki, com ara el Xat, els Assoliments i moltes més.
* Para't un moment a la [[w:ca:|Comunitat Central]] per estar informat de les últimes [[w:ca:Blog:Notícies de Wikia|notícies de Wikia]], fer preguntes al nostre [[w:ca:Forum:Index|fòrum comunitari]] i [[w:ca:Especial:Chat|xatejar]] amb altres usuaris.
* Llegeix les [[Help:Contents|pàgines d'ajuda]] per respondre les preguntes que puguis tenir.

Tots els enllaços anteriors són llocs magnífics per començar a explorar Wikia i, sobretot, passar-s'ho bé!

-- [[User:$2|$3]] <staff />",
);

/** Sorani Kurdish (کوردی)
 */
$messages['ckb'] = array(
	'autocreatewiki' => 'ویکییەکی نوێ دروست بکە',
	'autocreatewiki-page-title-default' => 'دروستکردنی ویکییەکی نوێ',
	'autocreatewiki-category-select' => 'یەکێک ھەڵبژێرە',
	'autocreatewiki-language-top' => '$1 زمانی سەرتر',
	'autocreatewiki-language-all' => 'گشت زمانەکان',
	'autocreatewiki-log-title' => 'ویکییەکەت خەریکە دروست‌دەبێ',
	'autocreatewiki-welcometalk-log' => 'پەیامی بەخێرھاتن',
);

/** Czech (česky)
 * @author Chmee2
 * @author Jezevec
 * @author Jkjk
 * @author Reaperman
 * @author Vks
 */
$messages['cs'] = array(
	'autocreatewiki' => 'Vytvořit novou wiki',
	'autocreatewiki-desc' => 'Vytvořit wiki podle požadavků uživatelů s pomocí WikiFactory',
	'autocreatewiki-page-title-default' => 'Vytvořit novou wiki',
	'autocreatewiki-page-title-answers' => 'Vytvořit nový web s odpověďmi',
	'createwiki' => 'Vytvořit novou wiki',
	'autocreatewiki-chooseone' => 'Vyberte jednu možnost',
	'autocreatewiki-required' => '$1= požadováno',
	'autocreatewiki-web-address' => 'Internetová adresa (URL):',
	'autocreatewiki-category-select' => 'Vyberte jednu možnost',
	'autocreatewiki-language-top' => '$1 největších jazyků',
	'autocreatewiki-language-all' => 'Všechny jazyky',
	'autocreatewiki-remember' => 'Pamatuj si mě',
	'autocreatewiki-create-account' => 'Založit účet',
	'autocreatewiki-haveaccount-question' => 'Máte již Wikia účet?',
	'autocreatewiki-info-topic' => 'Přidejte krátký popis, například "Star Wars" nebo "Televizní seriály".',
	'autocreatewiki-info-category-default' => 'To pomůže návštěvníkům najít vaší wiki.',
	'autocreatewiki-info-language' => 'To bude výchozí jazyk pro návštěvníky vaší wiki.',
	'autocreatewiki-info-email-address' => 'Vaše e-mailová adresa se nikdy nikomu na Wikia nezobrazuje.',
	'autocreatewiki-info-birthdate' => 'Wikia vyžaduje od všech uživatelů datum jejich narození z bezpečnostních důvodu a jako prostředek k zachování integrity webu v souladu se zákony.',
	'autocreatewiki-info-blurry-word' => 'Z důvodu ochrany před strojovým zakládáním účtů napiště slovo, které vidíte rozmazané v tomto poli.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-empty-field' => 'Vyplňte, prosím, toto pole.',
	'autocreatewiki-bad-name' => 'Název nesmí obsahovat speciální znaky (jako $ nebo @) a musí to být jedno slovo malými písmeny bez mezer.',
	'autocreatewiki-invalid-wikiname' => 'Název nesmí obsahovat speciální znaky (jako $ nebo @) a nemůže být prázdný.',
	'autocreatewiki-violate-policy' => 'Tato wiki obsahuje v názvu slovo, které porušuje naše pravidla pojmenovávání',
	'autocreatewiki-name-taken' => 'Wiki s touto adresou již existuje. Začněte upravovat na <a href="http://<span class=" notranslate"="">$1.wikia.com">http:// $1 . wikia.com</a> , nebo zvolte jinou adresu.',
	'autocreatewiki-name-too-short' => 'Tato adresa je příliš krátká, vyberte adresu s nejméně 3 znaky.',
	'autocreatewiki-name-too-long' => 'Tato adresa je příliš dlouhá. Zvolte prosím adresu s maximálně 50 znaky.',
	'autocreatewiki-invalid-username' => 'Toto uživatelské jméno je neplatné.',
	'autocreatewiki-busy-username' => 'Toto uživatelské jméno je již obsazené.',
	'autocreatewiki-blocked-username' => 'Nemůžete vytvořit účet.',
	'autocreatewiki-user-notloggedin' => 'Váš účet byl vytvořen, ale nejste přihlášeni.',
	'autocreatewiki-empty-language' => 'Prosím, vyberte jazyk pro wiki.',
	'autocreatewiki-empty-category' => 'Prosím, vyberte kategorii.',
	'autocreatewiki-empty-wikiname' => 'Jméno wiki nemůže být prázdné.',
	'autocreatewiki-empty-username' => 'Přihlašovací jméno nemůže být prázdné.',
	'autocreatewiki-empty-password' => 'Heslo nemůže být prázdné.',
	'autocreatewiki-empty-retype-password' => 'Zopakování hesla nemůže být prázdné.',
	'autocreatewiki-category-label' => 'Kategorie:',
	'autocreatewiki-category-other' => 'Jiné',
	'autocreatewiki-set-username' => 'Nejprve zvolte uživatelské jméno.',
	'autocreatewiki-invalid-category' => 'Neplatný výběr kategorie.
Prosím, vyberte hodnotu ze seznamu.',
	'autocreatewiki-invalid-language' => 'Neplatný výběr jazyka.
Prosím, vyberte hodnotu ze seznamu.',
	'autocreatewiki-invalid-retype-passwd' => 'Prosím, zopakujte stejné heslo',
	'autocreatewiki-invalid-birthday' => 'Neplatné datum narození',
	'autocreatewiki-log-title' => 'Vaše wiki se právě vytváří',
	'autocreatewiki-step0' => 'Probíha inicializace ...',
	'autocreatewiki-stepdefault' => 'Proces probíhá, prosím čekejte ...',
	'autocreatewiki-errordefault' => 'Proces nebyl dokončen ...',
	'autocreatewiki-step1' => 'Vytváření složky pro obrázky ...',
	'autocreatewiki-step2' => 'Vytváření databáze ...',
	'autocreatewiki-step3' => 'Nastavování výchozích informací v databázi ...',
	'autocreatewiki-step4' => 'Přenos výchozích obrázků a loga ...',
	'autocreatewiki-step5' => 'Nastavování výchozích proměnných v databázi ...',
	'autocreatewiki-step6' => 'Vytváření tabulek v databázi ...',
	'autocreatewiki-step7' => 'Nastavit počáteční hodnotu pro daný jazyk ...',
	'autocreatewiki-step11' => 'Odesílání e-mailu uživateli ...',
	'autocreatewiki-redirect' => 'Přesměrování na novou wiki: $1  ...',
	'autocreatewiki-congratulation' => 'Blahopřejeme!',
	'autocreatewiki-welcometalk-log' => 'Uvítací zpráva',
	'autocreatewiki-regex-error-comment' => 'použito na wiki $1 (celý text: $2)',
	'autocreatewiki-step2-error' => 'Databáze existuje!',
	'autocreatewiki-step3-error' => 'Nelze nastavit výchozí informace v databázi!',
	'autocreatewiki-step6-error' => 'Nelze nastavit výchozí tabulky v databázi!',
	'autocreatewiki-protect-reason' => 'Součást oficiálního rozhraní',
	'autocreatewiki-welcomesubject' => '$1 bylo vytvořeno!',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Pwyll
 * @author Thefartydoctor
 */
$messages['cy'] = array(
	'autocreatewiki' => 'Dechrau wici newydd',
	'autocreatewiki-desc' => 'Creu wici yn y WikiFactory gyda ymofyniadau defnyddiwyr',
	'autocreatewiki-page-title-default' => 'Creu wici newydd',
	'autocreatewiki-page-title-answers' => 'Creu gwefan Atebion newydd',
	'createwiki' => 'Creu wici newydd',
	'autocreatewiki-chooseone' => 'Dewiswch un',
	'autocreatewiki-required' => '$1 = gofynnol',
	'autocreatewiki-web-address' => 'Cyfeiriad gwe:',
	'autocreatewiki-category-select' => 'Dewiswch un',
	'autocreatewiki-language-top' => 'Y $1 iaith fwyaf',
	'autocreatewiki-language-all' => 'Holl ieithoedd',
	'autocreatewiki-remember' => 'Cofio fi',
	'autocreatewiki-create-account' => 'Creu cyfrif',
	'autocreatewiki-haveaccount-question' => 'Oes cyfrif Wikia gyda chi?',
	'autocreatewiki-info-topic' => 'Ychwanegu disgrifiad bach fel "Star Wars" neu "Sioeau deledu".',
	'autocreatewiki-info-category-default' => 'Bydd hwn yn helpu ymwelwyr i ffeindio eich wici chi.',
	'autocreatewiki-info-category-answers' => 'Bydd hwn yn helpu ymwelwyr i ffeindio eich gwefan Atebion chi.',
	'autocreatewiki-info-language' => 'Hon fydd yr iaith rhagosodedig i ymwelwyr eich wici chi.',
	'autocreatewiki-info-email-address' => 'Mae eich cyfeiriad e-bost chi erioed yn dangos i unrhywun ar Wikia.',
	'autocreatewiki-info-realname' => "Os ydych chi'n dewis ei roi, byddwn ni'n ei ddefnyddio i roi priodoliad i chi am eich gwaith.",
	'autocreatewiki-info-birthdate' => "Mae Wikia yn gofyn i bob defnyddiwr roi ei ddyddiad geni fel mesur diogelwch, ac er mwyn cadw uniondeb y wefan tra'n cydymffurfio â rheolau ffederal.",
	'autocreatewiki-info-blurry-word' => "I helpu nhw i ddiogelu rhag y greadigaeth gyfrif awtomatig, teipwich y gair blyri fod chi'n gallu gweud yn y bocs hwn.",
	'autocreatewiki-info-terms-agree' => 'Gan creu wici a chyfrif defnyddiwr, dych chi\'n cyd-fynd y <a href="http://www.wikia.com/wiki/Terms_of_use">Termiau Defnydd o Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Staff yn unig:</b> Bydd y defnyddiwr penodol yn cofrestru fel syflaenwr.',
	'autocreatewiki-title-template' => 'Wici $1',
	'autocreatewiki-limit-day' => 'Mae Wikia wedi rhagori y rhif uchafrif o greadigaeth wici heddiw ($1).',
	'autocreatewiki-limit-creation' => 'Dych chi wedi rhagori y rhif uchafrif o greadigaeth wici yn 24 awr ($1).',
	'autocreatewiki-empty-field' => "Cwblhau'r bocs hwn, os gwelwch chi'n dda.",
	'autocreatewiki-bad-name' => 'Mae enwau gyda llythryn arbennig (fel $ neu @) ddim yn oddefol ac mae\'n reidiol yn bod yn bachlythrennau heb bylchau.',
	'autocreatewiki-invalid-wikiname' => 'Mae enwau gyda llythryn arbennig (fel $ neu @) ac enwau gwag ddim yn oddefol.',
	'autocreatewiki-violate-policy' => "Mae'r enw wici hwn yn cynnwys gair fod yn treisio ein polisi enwi ni.",
	'autocreatewiki-name-taken' => 'Mae\'n wici gyda y cyfeiriad hwn. Dych chi\'n gallu creu newidiadau wrth <a href="http://$1.wikia.com">http://$1.wikia.com</a> neu dewis cyfeiriad arall.',
	'autocreatewiki-name-too-short' => "Mae'r cyfeiriad yn rhy fach, dewis cyfeiriad gyda 3 llythryn neu nifer o leiaf.",
);

/** Danish (dansk)
 * @author HenrikKbh
 */
$messages['da'] = array(
	'autocreatewiki' => 'Opret en ny wiki',
	'autocreatewiki-desc' => 'Opret wiki i WikiFactory efter en bruger forespørsel',
	'autocreatewiki-page-title-default' => 'Opret en ny Wiki',
	'autocreatewiki-page-title-answers' => 'Opret en ny Svar-side',
	'createwiki' => 'Opret en ny Wiki',
	'autocreatewiki-chooseone' => 'Vælg en',
	'autocreatewiki-required' => '$1 = påkrævet',
	'autocreatewiki-web-address' => 'Netadresse',
	'autocreatewiki-category-select' => 'Vælg en',
	'autocreatewiki-language-top' => 'Top $1 sprog',
	'autocreatewiki-language-all' => 'Alle sprog',
	'autocreatewiki-remember' => 'Husk mig',
	'autocreatewiki-create-account' => 'Opret en konto',
	'autocreatewiki-haveaccount-question' => 'Har du allerede en Wikia-konto?',
	'autocreatewiki-info-domain' => 'Det er bedst at bruge et ord, der kan være et nøgleord til søgningen for dit emne.',
	'autocreatewiki-info-topic' => 'Tilføj en kort beskrivelse som "Star Wars" eller "Tv-programmer".',
	'autocreatewiki-info-category-default' => 'Dette vil hjælpe besøgende med at finde din wiki.',
	'autocreatewiki-info-category-answers' => 'Dette vil hjælpe besøgende med at finde dit svar websted.',
	'autocreatewiki-info-language' => 'Dette vil blive standardsproget for besøgende på din wiki.',
	'autocreatewiki-info-email-address' => 'Din e-mail-adresse vil aldrig blive vist for nogen på Wikia.',
	'autocreatewiki-info-realname' => 'Hvis du vælger at oplyse dit navn, vil det blive brugt til at godskrive dig dit arbejde.',
	'autocreatewiki-info-birthdate' => 'Wikia kræver at alle brugere oplyser deres fødselsdato dels som en sikkerhedsforanstaltning og dels som et middel til at bevare integriteten af webstedet mens vi overholder national lovgivning.',
	'autocreatewiki-info-blurry-word' => 'For at beskytte mod automatiserede kontooprettelser, skriv da det slørede ord, som du kan se i dette felt.',
	'autocreatewiki-info-terms-agree' => 'Ved at oprette en wiki og en brugerkonto, accepterer du <a href="http://www.wikia.com/wiki/Terms_of_use">Wikias vilkår for anvendelse</a>',
	'autocreatewiki-info-staff-username' => '<b>Kun ansatte:</b> Den angivne bruger vises som grundlægger.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia har overskredet det maksimale antal wiki oprettelser i dag ( $1 ).',
	'autocreatewiki-limit-creation' => 'Du har overskredet det maksimale antal wiki oprettelser på 24 timer ( $1 ).',
	'autocreatewiki-empty-field' => 'Udfyld venligst feltet.',
	'autocreatewiki-bad-name' => 'Navnet må ikke indeholde specialtegn (som $ eller @) og skal være ét ord med små bogstaver uden mellemrum.',
	'autocreatewiki-invalid-wikiname' => 'Navnet må ikke indeholde specialtegn (som $ eller @) og må ikke være tomt',
	'autocreatewiki-violate-policy' => 'Denne wikinavn indeholder et ord, der krænker vores navngivningspolitik',
	'autocreatewiki-name-taken' => 'Der findes allerede en wiki med denne adresse. Start redigering på <a href="http://<span class=" notranslate"="">$1.wikia.com">http:// $1 . wikia.com</a> eller vælg en anden adresse.',
	'autocreatewiki-name-too-short' => 'Denne adresse er for kort, du skal vælge en adresse med mindst 3 tegn.',
	'autocreatewiki-name-too-long' => 'Denne adresse er for lang. Vælg en adresse med maksimalt 50 tegn.',
	'autocreatewiki-similar-wikis' => 'Nedenfor er de wiki-websteder der allerede er oprettet om dette emne. Vi foreslår, at du redigerer én af dem.',
	'autocreatewiki-invalid-username' => 'Dette brugernavn er ugyldigt.',
	'autocreatewiki-busy-username' => 'Dette brugernavn er allerede taget.',
	'autocreatewiki-blocked-username' => 'Du kan ikke oprette konto.',
	'autocreatewiki-user-notloggedin' => 'Kontoen blev oprettet, men ikke logget ind!',
	'autocreatewiki-empty-language' => "Vælg sprog for wiki'en.",
	'autocreatewiki-empty-category' => 'Vælg venligst en kategori.',
	'autocreatewiki-empty-wikiname' => "Navnet på wiki'en må ikke være tomt.",
	'autocreatewiki-empty-username' => 'Brugernavnet må ikke være tomt.',
	'autocreatewiki-empty-password' => 'Adgangskoden må ikke være tom.',
	'autocreatewiki-empty-retype-password' => 'Den nye adgangskode må ikke være tom.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Andet:',
	'autocreatewiki-set-username' => 'Angive først brugernavn.',
	'autocreatewiki-invalid-category' => 'Ugyldig værdi for kategori.
Vælg venligst en korrekt en fra rullelisten.',
	'autocreatewiki-invalid-language' => 'Ugyldig værdi for sprog.
Vælg venligst korrekt sprog fra rullelisten.',
	'autocreatewiki-invalid-retype-passwd' => 'Skriv den samme adgangskode som ovenfor',
	'autocreatewiki-invalid-birthday' => 'Ugyldig fødselsdato',
	'autocreatewiki-log-title' => 'Din wiki oprettes',
	'autocreatewiki-step0' => 'Initialiserer proces...',
	'autocreatewiki-stepdefault' => 'Processen kører, vent venligst...',
	'autocreatewiki-errordefault' => 'Processen blev ikke færdig...',
	'autocreatewiki-step1' => 'Opretter billedmappe...',
	'autocreatewiki-step2' => 'Opretter database...',
	'autocreatewiki-step3' => 'Angiver standardoplysninger i database...',
	'autocreatewiki-step4' => 'Kopierer standard billeder og logo...',
	'autocreatewiki-step5' => 'Angiver standardoplysninger i database...',
	'autocreatewiki-step6' => 'Angiver standardoplysninger i database..',
	'autocreatewiki-step7' => 'Indstiller opstartssprog...',
	'autocreatewiki-step8' => 'Indstiller brugergrupper og kategorier...',
	'autocreatewiki-step9' => 'Indstiller variabler for ny wiki...',
	'autocreatewiki-step10' => 'Indstiller sider på central wiki...',
	'autocreatewiki-step11' => 'Sender e-mail til bruger...',
	'autocreatewiki-redirect' => 'Omdirigerer til ny wiki:  $1  ...',
	'autocreatewiki-congratulation' => 'Tillykke!',
	'autocreatewiki-welcometalk-log' => 'Velkomstmeddelelse',
	'autocreatewiki-regex-error-comment' => 'bruges i wiki  $1  (hele teksten:  $2 )',
	'autocreatewiki-step2-error' => 'Databasen findes!',
	'autocreatewiki-step3-error' => 'Kan ikke angive standardoplysninger i databasen!',
	'autocreatewiki-step6-error' => 'Kan ikke indstille standard tabeller i databasen!',
	'autocreatewiki-step7-error' => 'Kan ikke kopiere startdatabasen for sprog!',
	'autocreatewiki-protect-reason' => 'Del af den officielle grænseflade',
	'autocreatewiki-welcomesubject' => '$1er blevet oprettet!',
	'autocreatewiki-welcomebody' => 'Hej  $2 !

Din wiki er blevet oprettet! Tag et kig:  $1 >

Er du klar til at komme i gang? Vi har føjet nogle links til din diskussionsside, ( $5 >) for at hjælpe dig i gang og opfordrer dig til at udforske de mange nyttige sider omkring Wikia. Hvis du har spørgsmål eller føler en smule fortabt, besvar da denne e-mail eller tjek vores hjælpesider <http: help.wikia.com="">.

Du kan også tjekke bloggen for grundlæggere & administratorer <http:> </http:>  %3AWikia_Founders_% 26_Admins > og bloggen for Wikiaansatte<http: community.wikia.com/wiki/blog:wikia_staff_blog="">hvor du kan finde tips og tricks, info om nye funktioner og nye ting der sker på Wikia.

God redigering!

$3
Wikia Fællesskabets hjælp
<http:></http:>$4>

___________________________________________
 * vil du modtage færre meddelelser fra os? Du kan afmelde eller ændre dine email indstillinger her: http://community.wikia.com/Special:Preferences</http:> </http:>',
	'autocreatewiki-welcometalk-wall-title' => 'Velkommen!',
	'autocreatewiki-welcometalk-wall' => 'Hej, det glæder os at have {{subst:SITENAME}} som en del af Wikia fællesskabet!

Der er stadig meget, der skal gøres og her er værdifulde tips og henvisninger til at få dig i gang:

* Kig på [[Special:WikiFeatures|Wiki Funktioner]] for at se hvilke funktioner du kan aktivere på din wikia, inklusive chat, resultater og meget mere.
* Kig også forbi [[w:c:community|Fællesskabs centralen]] for at holde dig opdateret om hvad der sker på de [[w:c:community:Blog:Wikia_Staff_Blog|ansattes blog]], stil spørgsmål i vores [[w:c:community:Special:Forum|fællesskabsforum]], deltag i vore [[w:c:community:Help:Webinars|webinar serier]], eller chat live med andre wikipedianere.
* Og til sidst besøg vores [[Help:Contents|hjælpesider]], for at lære hvordan man bruger en Wikia.

Alle de ovenstående henvisninger er gode steder at starte udforskningen og få del i alt det sjove.',
	'autocreatewiki-welcometalk' => '==Velkommen==
Hej.

Vi glæder os over at $4 som en del af Wikia fællesskabet. Der er stadig meget at gøre og her er værdifulde tips og henvisninger til at få dig i gang:

* Kig på [[Special:WikiFeatures|Wiki Features]] for at se hvilke funktioner du kan aktivere på din wikia, inklusive chat, resultater og meget mere.
* Kig også forbi [[w:c:community|Community Central]] for at holde dig opdateret om hvad der sker på [[w:c:community:Blog:Wikia_Staff_Blog|staff blog]], stil spørgsmål i vores [[w:c:community:Special:Forum|fællesskabsforum]], deltag i vore [[w:c:community:Help:Webinars|webinar serier]], eller chat live med andre wikipedianere.
* Og til sidst besøg vores [[Help:Contents|hjælpesider]] for at lære hvordan man bruger en Wikia.

Alle de ovenstående henvisninger er gode steder at starte udforskningen og få del i alt det sjove.

-- [[User:$2|$3]] <staff />',
);

/** German (Deutsch)
 * @author Claudia Hattitten
 * @author LWChris
 * @author Metalhead64
 * @author PtM
 * @author The Evil IP address
 */
$messages['de'] = array(
	'autocreatewiki' => 'Erstelle ein neues Wiki',
	'autocreatewiki-desc' => 'Erzeugt ein Wiki in WikiFactory nach Benutzeranforderungen',
	'autocreatewiki-page-title-default' => 'Erstelle ein neues Wiki',
	'autocreatewiki-page-title-answers' => 'Eine neue Frage-Antwort-Site erstellen',
	'createwiki' => 'Ein neues Wiki erstellen',
	'autocreatewiki-chooseone' => 'Bitte auswählen',
	'autocreatewiki-required' => '$1 = notwendige Angabe',
	'autocreatewiki-web-address' => 'Web-Adresse:',
	'autocreatewiki-category-select' => 'Eine Option auswählen',
	'autocreatewiki-language-top' => 'Top-$1 Sprachen',
	'autocreatewiki-language-all' => 'Alle Sprachen',
	'autocreatewiki-remember' => 'Automatische Anmeldung',
	'autocreatewiki-create-account' => 'Benutzerkonto erstellen',
	'autocreatewiki-haveaccount-question' => 'Hast du bereits ein Benutzerkonto bei Wikia?',
	'autocreatewiki-info-domain' => 'Gib ein Wort ein, das am ehesten als Suchbegriff für dieses Thema verwendet wird.',
	'autocreatewiki-info-topic' => 'Füge eine kurze Beschreibung hinzu (z. B. „Star Wars“ oder „Fernsehserien“).',
	'autocreatewiki-info-category-default' => 'So können Besucher dein Wiki einfacher finden.',
	'autocreatewiki-info-category-answers' => 'So können Besucher deine Frage-Antwort-Site einfacher finden.',
	'autocreatewiki-info-language' => 'Dies wird die Standardsprache für Besucher deines Wikis.',
	'autocreatewiki-info-email-address' => 'Deine E-Mail-Adresse wird niemandem angezeigt.',
	'autocreatewiki-info-realname' => 'Wenn du dich dafür entscheidest, deinen realen Namen anzugeben, wird dies dafür verwendet, dir deine Beiträge zuzuordnen.',
	'autocreatewiki-info-birthdate' => 'Wikia verlangt von allen Nutzern, ihr tatsächliches Geburtsdatum anzugeben, sowohl als Sicherheitsmaßnahme, als auch als Mittel zur Wahrung der Integrität der Website unter Einhaltung der behördlichen Vorschriften.',
	'autocreatewiki-info-blurry-word' => 'Um die automatische Erstellung von Benutzerkonten zu verhindern, tippe bitte das verschwommene Wort ein.',
	'autocreatewiki-info-terms-agree' => 'Mit Erstellung eines Wikis und eines Benutzerkontos stimmst du Wikias {{#NewWindowLink: w:Terms of use | Nutzerbedingungen}} zu.',
	'autocreatewiki-info-staff-username' => '<b>Nur für Mitarbeiter:</b> Der angegebene Benutzer wird als Gründer aufgeführt.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia hat die maximale Anzahl von Wiki-Erstellungen für heute überschritten ($1).',
	'autocreatewiki-limit-creation' => 'Du hast die maximale Anzahl an Wikis überschritten, die du in 24 Stunden erstellen kannst ($1).',
	'autocreatewiki-empty-field' => 'Fülle bitte dieses Feld aus.',
	'autocreatewiki-bad-name' => 'Der Name darf keine Sonderzeichen (wie $ oder @) enthalten und muss ein einzelnes Wort in Kleinbuchstaben ohne Leerzeichen sein.',
	'autocreatewiki-invalid-wikiname' => 'Der Name darf keine Sonderzeichen (wie $ oder @) enthalten und muss ausgefüllt werden.',
	'autocreatewiki-violate-policy' => 'Im Wikia-Namen ist ein Wort enthalten, dass unsere Richtlinien zur Namensgebung verletzt.',
	'autocreatewiki-name-taken' => 'Es gibt bereits ein Wiki mit dieser Adresse. Beteilige dich unter <a href="http://$1.wikia.com">http://$1.wikia.com</a> oder wähle eine andere Adresse.',
	'autocreatewiki-name-too-short' => 'Diese Adresse ist zu kurz, bitte wähle eine Adresse mit mindestens 3 Buchstaben aus.',
	'autocreatewiki-name-too-long' => 'Diese Adresse ist zu lang. Bitte wähle eine Adresse mit maximal 50 Zeichen aus.',
	'autocreatewiki-similar-wikis' => 'Weiter unten findest du die Wikis, die bereits zu diesem Thema erstellt wurden. Wir schlagen vor, dass du dich an einem davon beteiligst.',
	'autocreatewiki-invalid-username' => 'Dieser Benutzername ist ungültig.',
	'autocreatewiki-busy-username' => 'Dieser Benutzername existiert bereits.',
	'autocreatewiki-blocked-username' => 'Du kannst kein Benutzerkonto anlegen.',
	'autocreatewiki-user-notloggedin' => 'Dein Konto wurde erstellt aber nicht eingeloggt!',
	'autocreatewiki-empty-language' => 'Wähle bitte eine Sprache für dein Wiki aus.',
	'autocreatewiki-empty-category' => 'Bitte wähle eine Kategorie aus.',
	'autocreatewiki-empty-wikiname' => 'Bitte gib deinem Wiki einen Namen.',
	'autocreatewiki-empty-username' => 'Bitte gib einen Benutzernamen an.',
	'autocreatewiki-empty-password' => 'Bitte gib ein Passwort an.',
	'autocreatewiki-empty-retype-password' => 'Bitte gib das Passwort noch einmal ein.',
	'autocreatewiki-category-label' => 'Kategorie:',
	'autocreatewiki-category-other' => 'Andere',
	'autocreatewiki-set-username' => 'Wähle zuerst einen Benutzernamen.',
	'autocreatewiki-invalid-category' => 'Ungültige Kategorie-Auswahl.
Bitte wähle eine Kategorie aus der Dropdown-Liste aus.',
	'autocreatewiki-invalid-language' => 'Ungültige Sprach-Auswahl.
Bitte wähle eine Sprache aus der Dropdown-Liste aus.',
	'autocreatewiki-invalid-retype-passwd' => 'Bitte gib das gleiche Passwort wie oben ein',
	'autocreatewiki-invalid-birthday' => 'Ungültiges Geburtsdatum',
	'autocreatewiki-log-title' => 'Dein Wiki wird erstellt',
	'autocreatewiki-step0' => 'Prozess wird initialisiert ...',
	'autocreatewiki-stepdefault' => 'Prozess läuft, bitte warten ...',
	'autocreatewiki-errordefault' => 'Prozess wurde nicht beendet ...',
	'autocreatewiki-step1' => 'Bilderordner wird erstellt...',
	'autocreatewiki-step2' => 'Datenbank wird erstellt...',
	'autocreatewiki-step3' => 'Standard-Datenbankinformationen werden festgelegt...',
	'autocreatewiki-step4' => 'Standardbilder und Logo werden übertragen...',
	'autocreatewiki-step5' => 'Standard-Datenbankvariablen werden festgelegt...',
	'autocreatewiki-step6' => 'Standard-Datenbanktabellen werden festgelegt...',
	'autocreatewiki-step7' => 'Sprach-Basisversion wird festgelegt...',
	'autocreatewiki-step8' => 'Benutzergruppen und Kategorien werden festgelegt...',
	'autocreatewiki-step9' => 'Variablen für das neue Wiki werden festgelegt...',
	'autocreatewiki-step10' => 'Seiten im Central-Wikia werden festgelegt...',
	'autocreatewiki-step11' => 'E-Mail wird an Benutzer gesendet...',
	'autocreatewiki-redirect' => 'Weiterleitung zum neuen Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Glückwunsch!',
	'autocreatewiki-welcometalk-log' => 'Willkommensnachricht',
	'autocreatewiki-regex-error-comment' => 'verwendet in Wiki $1 (ganzer Text: $2)',
	'autocreatewiki-step2-error' => 'Datenbank existiert bereits!',
	'autocreatewiki-step3-error' => 'Initialisierung der Standard-Datenbankinformationen fehlgeschlagen!',
	'autocreatewiki-step6-error' => 'Initialisierung der Standard-Datenbanktabellen fehlgeschlagen!',
	'autocreatewiki-step7-error' => 'Fehler beim Übertragen der Sprach-Basisversion!',
	'autocreatewiki-protect-reason' => 'Teil der offiziellen Oberfläche',
	'autocreatewiki-welcomesubject' => '$1 wurde erstellt!',
	'autocreatewiki-welcomebody' => 'Hallo $2,

das von dir erstellte Wiki ist nun unter <$1> erreichbar.

Bereit loszulegen? Wir haben auf deiner Diskussionsseite (<$5>) ein paar Links hinterlassen, die dir für den Anfang helfen sollen und dich hoffentlich ermutigen, die Hilfebereiche bei Wikia zu nutzen. Falls du einmal eine Frage hast oder nicht weiter weißt, dann antworte auf diese E-Mail oder sieh dir die Hilfeseiten <http://hilfe.wikia.com> an.

Du kannst dir auch das Gründer- und Administratoren-Blog <http://de.community.wikia.com/wiki/Blog:Gr%C3%BCnder_und_Administratoren> sowie das Wikia-Deutschland-News-Blog <http://de.community.wikia.com/wiki/Blog:Wikia_Deutschland_News> ansehen. Dort findest du Tipps und Tricks, Infos über neue Funktionen und Neuigkeiten rund um Wikia.

Viel Spaß beim Schreiben!

$3
Wikia Community-Support
<http://de.community.wikia.com/wiki/User:$4>

___________________________________________
* Wenn du weniger Nachrichten von uns erhalten möchtest, kannst du hier deine E-Mail-Einstellungen ändern: http://de.community.wikia.com/Spezial:Einstellungen',
	'autocreatewiki-welcometalk-wall-title' => 'Willkommen!',
	'autocreatewiki-welcometalk-wall' => 'Hallo! Wir freuen uns, dass {{subst:SITENAME}} jetzt auch Teil der Wikia-Gemeinschaft bist!

Es gibt noch einiges zu tun, deshalb hier nun als Hilfe ein paar Tipps und Links, damit dein Wikia ordentlich in Fahrt kommt!
* Sieh dir bei den [[Special:WikiFeatures|Wiki-Funktionen]] an, welche Erweiterungen - wie zum Beispiel den Chat oder die Herausforderungen - du in deinem Wikia aktivieren kannst.
* Du kannst das Aussehen deines Wikias im [[Special:ThemeDesigner|Theme-Designer]] individuell anpassen. Dort kannst du deinen Hintergrund und das Logo deines Wikias mit Farben und anderen Stilelementen verändern.
* Besuche die [[w:c:de.community|deutsche Wikia-Community]], um immer über [http://de.community.wikia.com/wiki/Blog:Wikia_Deutschland_News das aktuelle Wikia-Geschehen] informiert zu sein, Fragen im [[w:c:de.community:Special:Forum|Community-Forum]] zu stellen, an der [http://de.community.wikia.com/wiki/Wikia-Universit%C3%A4t Wikia-Universität] dein Wissen weiter zu vertiefen oder mit anderen Wikianern zu chatten.
* Außerdem kannst du alles zur Nutzung von Wikia auf unseren [[Hilfe:Übersicht|Hilfeseiten]] lernen. Besonders interessant sind zum Beispiel die Seiten, auf denen du lernst, wie du [[Hilfe:Neue_Seite|deinem Wikia eine neue Seite hinzufügen]], [[Hilfe:Benutzer_begeistern|neue Beitragende für dein Wikia finden]] und [[Hilfe:Benutzer|weitere Wiki-Admins hinzufügen]] kannst.

All diese Links sind gute Startpunkte, um sich zurechtzufinden und Spaß zu haben!',
	'autocreatewiki-welcometalk' => '== Willkommen! ==

Hallo! Wir freuen uns, dass {{subst:SITENAME}} jetzt auch Teil der Wikia-Gemeinschaft bist!

Es gibt noch einiges zu tun, deshalb hier nun als Hilfe ein paar Tipps und Links, damit dein Wikia ordentlich in Fahrt kommt!
* Sieh dir bei den [[Special:WikiFeatures|Wiki-Funktionen]] an, welche Erweiterungen - wie zum Beispiel den Chat oder die Herausforderungen - du in deinem Wikia aktivieren kannst.
* Du kannst das Aussehen deines Wikias im [[Special:ThemeDesigner|Theme-Designer]] individuell anpassen. Dort kannst du deinen Hintergrund und das Logo deines Wikias mit Farben und anderen Stilelementen verändern.
* Besuche die [[w:c:de.community|deutsche Wikia-Community]], um immer über [http://de.community.wikia.com/wiki/Blog:Wikia_Deutschland_News das aktuelle Wikia-Geschehen] informiert zu sein, Fragen im [[w:c:de.community:Special:Forum|Community-Forum]] zu stellen, an der [http://de.community.wikia.com/wiki/Wikia-Universit%C3%A4t Wikia-Universität] dein Wissen weiter zu vertiefen oder mit anderen Wikianern zu chatten.
* Außerdem kannst du alles zur Nutzung von Wikia auf unseren [[Hilfe:Übersicht|Hilfeseiten]] lernen. Besonders interessant sind zum Beispiel die Seiten, auf denen du lernst, wie du [[Hilfe:Neue_Seite|deinem Wikia eine neue Seite hinzufügen]], [[Hilfe:Benutzer_begeistern|neue Beitragende für dein Wikia finden]] und [[Hilfe:Benutzer|weitere Wiki-Admins hinzufügen]] kannst.

All diese Links sind gute Startpunkte, um sich zurechtzufinden und Spaß zu haben!

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author Claudia Hattitten
 * @author LWChris
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'autocreatewiki' => 'Ein neues Wiki erstellen',
	'autocreatewiki-page-title-default' => 'Ein neues Wiki erstellen',
	'autocreatewiki-haveaccount-question' => 'Haben Sie bereits ein Benutzerkonto bei Wikia?',
	'autocreatewiki-info-domain' => 'Verwenden Sie am besten ein Wort, das vermutlich als Suchbegriff für dieses Thema verwendet wird.',
	'autocreatewiki-info-topic' => 'Wählen Sie am besten einen kurzen, beschreibenden Namen (z. B. „Star Wars“ oder „Fernsehserien“).',
	'autocreatewiki-info-category-default' => 'Besucher können so Ihr Wiki einfacher finden.',
	'autocreatewiki-info-category-answers' => 'Besucher können so Ihre Frage-Antwort-Site einfacher finden.',
	'autocreatewiki-info-language' => 'Dies wird die Standard-Sprache für Besucher Ihres Wikis.',
	'autocreatewiki-info-email-address' => 'Ihre E-Mail-Adresse wird niemandem angezeigt.',
	'autocreatewiki-info-realname' => 'Damit kann Ihr bürgerlicher Name Ihren Beiträgen zugeordnet werden.',
	'autocreatewiki-info-blurry-word' => 'Um die automatische Erstellung von Benutzerkonten zu verhindern, geben Sie bitte das verschwommene Wort ein.',
	'autocreatewiki-info-terms-agree' => 'Mit Erstellung eines Wikis und eines Benutzerkontos stimmen Sie Wikias <a href="http://www.wikia.com/wiki/Terms_of_use">Nutzungsbedingungen</a> zu.',
	'autocreatewiki-limit-creation' => 'Sie haben die maximale Anzahl an Wikis überschritten, die in 24 Stunden erstellt werden können ($1).',
	'autocreatewiki-empty-field' => 'Füllen Sie bitte dieses Feld aus.',
	'autocreatewiki-name-taken' => 'Ein Wiki mit dieser Adresse existiert bereits. Werden Sie unter <a href="http://$1.wikia.com">http://$1.wikia.com</a> aktiv oder wählen sie eine andere Adresse.',
	'autocreatewiki-name-too-short' => 'Diese Adresse ist zu kurz, bitte wählen Sie eine Adresse mit mindestens 3 Buchstaben.',
	'autocreatewiki-name-too-long' => 'Diese Adresse ist zu lang. Bitte wählen Sie eine Adresse mit maximal 50 Zeichen.',
	'autocreatewiki-similar-wikis' => 'Unten sind die Wikis zu diesem Thema, die bereits erstellt wurden. Wir schlagen vor, dass Sie sich dort beteiligen.',
	'autocreatewiki-blocked-username' => 'Sie dürfen kein Benutzerkonto anlegen.',
	'autocreatewiki-user-notloggedin' => 'Ihr Konto wurde erstellt aber nicht eingeloggt!',
	'autocreatewiki-empty-language' => 'Wählen Sie bitte eine Sprache für Ihr Wiki.',
	'autocreatewiki-empty-category' => 'Bitte wählen Sie eine Kategorie.',
	'autocreatewiki-empty-wikiname' => 'Bitte geben Sie Ihrem Wiki einen Namen.',
	'autocreatewiki-empty-username' => 'Bitte geben Sie einen Benutzernamen an.',
	'autocreatewiki-set-username' => 'Wählen Sie zuerst einen Benutzernamen.',
	'autocreatewiki-invalid-category' => 'Ungültige Kategorie-Auswahl.
Bitte wählen Sie eine Kategorie aus der Liste.',
	'autocreatewiki-invalid-language' => 'Ungültige Sprach-Auswahl.
Bitte wählen Sie eine Sprache aus der Liste.',
	'autocreatewiki-invalid-retype-passwd' => 'Bitte geben Sie das gleiche Passwort wie oben ein',
	'autocreatewiki-log-title' => 'Ihr Wiki wird erstellt',
	'autocreatewiki-welcomebody' => 'Hallo $2,

Das von Ihnen erstellte Wikia ist nun unter <$1> erreichbar. Hoffentlich sehen wir Sie bald dort editieren!

Wir haben auf Ihrer Diskussionsseite (<$5>) ein paar Informationen und Tipps für den Start hinterlassen.

Falls Sie irgendwelche Probleme haben, können Sie unter <http://de.wikia.com/wiki/Forum:Übersicht> die Gemeinschaft um Hilfe bitten oder sich per E-Mail an community@wikia.com wenden. Sie können auch unseren #wikia IRC-Channel besuchen <http://irc.wikia.com>.

Falls Sie noch weitere Fragen oder Probleme haben, können Sie sich auch direkt per Mail oder Diskussionsseite an mich wenden.

Viel Erfolg mit Ihrem Projekt!

$3

Wikia Community Team

<http://de.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Willkommen! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hallo \$1 -- wir freuen uns, dass '''\$4''' jetzt Teil der Wikia-Gemeinschaft ist!

Jetzt haben Sie eine ganze Webseite, die Sie mit Informationen, Bildern und Videos über dein Lieblingsthema füllen können. Aber im Moment gibt es nur leere Seiten... Unheimlich? Hier einige Anregungen, wie Sie anfangen können.

* '''Stellen Sie Ihr Thema vor''' - auf der Hauptseite. Diese Seite ist Ihre Chance, den Lesern alles über Ihr Thema zu verraten. Schreiben Sie so viel Sie wollen! Ihre Beschreibung kann zu allen wichtigen Seiten im Wiki verlinken.

* '''Erstellen Sie einige neue Seiten''' - nur ein oder zwei Sätze um anzufangen. Lassen Sie sich nicht von den leeren Seiten unterkriegen! In einem Wiki werden laufend Dinge hinzugefügt oder verändert. Sie können auch Bilder und Videos auf die Hauptseite packen um sie zu füllen und interessanter zu machen.

Machen Sie im Anschluss einfach weiter! Leute mögen große Wikis, in denen man viel entdecken kann. Fügen Sie also weiterhin Inhalte hinzu, und Sie werden schon bald neue Leser und Benutzer anziehen. Es gibt viel zu tun, aber seien Sie unbesorgt - heute ist Ihr erster Tag, und Sie haben genügend Zeit. Jedes Wiki fängt auf dieselbe Weise an - es braucht nur ein bisschen Zeit, und nach den ersten paar Seiten, und einer Weile wird das Wiki zu einer großen, häufig besuchten Seite anwachsen.

Wenn Sie Fragen haben, können Sie uns eine Mail über unser [[Special:Contact|Kontaktformular]] schreiben. Viel Spaß!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'autocreatewiki' => 'Wikiya newi vıraze',
	'autocreatewiki-desc' => 'Wikifebrika vıraştışire Qarqer buwaze',
	'autocreatewiki-page-title-default' => 'Wikiya newi vıraze',
	'autocreatewiki-page-title-answers' => 'yew siteya newiyaqande cewaba vıraze',
	'createwiki' => 'Wikiya newi vıraze',
	'autocreatewiki-chooseone' => 'zeweri bıweçine',
	'autocreatewiki-required' => '$1 = icab keno',
	'autocreatewiki-web-address' => 'Adrese webi',
	'autocreatewiki-category-select' => 'Yeweri weçine',
	'autocreatewiki-language-top' => 'Top $1 zıwani',
	'autocreatewiki-language-all' => 'Zıwani pêro',
	'autocreatewiki-remember' => 'Mı biya xo viri',
	'autocreatewiki-create-account' => 'Yew hesab vıraze',
	'autocreatewiki-haveaccount-question' => 'Xora yew hesabê şımayê Wikia esto?',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-invalid-username' => 'No namey qarqeri çıno',
	'autocreatewiki-busy-username' => 'No namey karberi  veror dı jew na merdumi groto',
	'autocreatewiki-blocked-username' => 'Şıma nêşenê hesab vırazê.',
	'autocreatewiki-empty-category' => 'Kategoriye weçine.',
	'autocreatewiki-empty-username' => 'Wa heruna karberi veng nêbo',
	'autocreatewiki-empty-password' => 'Wa heruna parolayer veng nêbo.',
	'autocreatewiki-category-label' => 'Kategoriye:',
	'autocreatewiki-category-other' => 'Zewmi',
	'autocreatewiki-set-username' => 'Veror namey karberi nışan kerê',
	'autocreatewiki-invalid-birthday' => 'Xırab rocabiyayen',
	'autocreatewiki-log-title' => 'Wikiaya şıma vıraziyê!',
	'autocreatewiki-step1' => 'Rateya resimana vırazêna ...',
	'autocreatewiki-step2' => 'Databaseo vırazêno ...',
	'autocreatewiki-redirect' => 'Wikiya newi açarnê: $1 ...',
	'autocreatewiki-congratulation' => 'Çımê şıma roşni bê!',
	'autocreatewiki-welcometalk-log' => 'Mesacê Xeyr Amyayışi',
	'autocreatewiki-welcomesubject' => '$1 vıraziya!',
	'autocreatewiki-welcometalk-wall-title' => 'Xeyr amey!',
);

/** Ewe (eʋegbe)
 */
$messages['ee'] = array(
	'autocreatewiki-create-account' => 'Ŋlɔ ŋkɔ daɖi',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Evropi
 * @author Geraki
 * @author Glavkos
 * @author Περίεργος
 */
$messages['el'] = array(
	'autocreatewiki' => 'Δημιουργήστε έναν νέο ιστότοπο τύπου Wiki',
	'autocreatewiki-desc' => 'Δημιουργήστε έναν ιστότοπο τύπου wiki στο WikiFactory από αιτήματα χρηστών',
	'autocreatewiki-page-title-default' => 'Δημιουργήστε έναν καινούργιο ιστότοπο τύπου Wiki',
	'autocreatewiki-page-title-answers' => 'Δημιουργήστε έναν νέο ιστότοπο για απαντήσεις',
	'createwiki' => 'Δημιουργήστε έναν ιστότοπο τύπου Wiki',
	'autocreatewiki-chooseone' => 'Διαλέξτε ένα',
	'autocreatewiki-required' => '$1 = απαιτείται',
	'autocreatewiki-web-address' => 'Ηλεκτρονική διεύθυνση:',
	'autocreatewiki-category-select' => 'Επιλέξτε ένα',
	'autocreatewiki-language-top' => 'Οι $1 πιο δημοφιλείς γλώσσες',
	'autocreatewiki-language-all' => 'Όλες οι γλώσσες',
	'autocreatewiki-remember' => 'Αποθήκευση',
	'autocreatewiki-create-account' => 'Δημιουργία λογαριασμού',
	'autocreatewiki-haveaccount-question' => 'Έχετε ήδη ένα λογαριασμό Wikia;',
	'autocreatewiki-info-domain' => 'Καλύτερα να χρησιμοποιήσετε μια λέξη-κλειδί αναζήτησης του θέματός σας.',
	'autocreatewiki-info-topic' => 'Βάλε τε μια σύντομη περιγραφή όπως "Διαδίκτυο" ή "Λογοτεχνεία".',
	'autocreatewiki-info-category-default' => 'Αυτό θα βοηθήσει τους επισκέπτες να βρουν wiki σας.',
	'autocreatewiki-info-category-answers' => 'Αυτό θα βοηθήσει τους επισκέπτες να βρουν την ιστοσελίδα σας για απαντήσεις.',
	'autocreatewiki-info-language' => 'Αυτή θα είναι η προεπιλεγμένη γλώσσα για τους επισκέπτες του wiki σας.',
	'autocreatewiki-info-email-address' => 'Το ηλεκτρονικό σας ταχυδρομείο δεν φαίνεται σε κανέναν στο Wikia.',
	'autocreatewiki-info-realname' => 'Αν το δώσετε, αυτό θα χρησιμοποιηθεί για να σας αποδωθεί η δουλειά σας.',
	'autocreatewiki-info-birthdate' => 'Η Wikia απαιτεί από όλους τους χρήστες να δώσουν την πραγματική ημερομηνία γέννησής τους ως μέτρο ασφάλειας και ως μέσο διατήρησης της ακεραιότητας του ιστότοπου ενόσω συμμορφώνεται με κανονισμούς των Ηνωμένων Πολιτειών Αμερικής.',
	'autocreatewiki-info-blurry-word' => 'Για αποφυγή αυτόματης δημιουργίας λογαριασμού, παρακαλώ πληκτρολογίστε τη θολή λέξη που βλέπετε στο πεδίο.',
	'autocreatewiki-title-template' => '$1Wiki',
	'autocreatewiki-limit-day' => 'Wikia έχει υπερβεί το μέγιστο αριθμό δημιουργίας wiki σήμερα ( $1 ).',
	'autocreatewiki-name-too-short' => 'Αυτό η διεύθυνση είναι πολύ μικρή, παρακαλώ διαλέξτε μια διεύθυνση με τουλάχιστον 3 χαρακτήρες.',
	'autocreatewiki-invalid-username' => 'Αυτό το όνομα χρήστη δεν είναι έγκυρο.',
	'autocreatewiki-busy-username' => 'Αυτό το όνομα χρήστη υπάρχει ήδη.',
	'autocreatewiki-blocked-username' => 'Δεν μπορείτε να δημιουργήσετε λογαριασμό.',
	'autocreatewiki-empty-language' => 'Παρακαλώ επιλέξτε τη γλώσσα για το wiki.',
	'autocreatewiki-empty-category' => 'Παρακαλούμε επιλέξτε μια κατηγορία.',
	'autocreatewiki-empty-wikiname' => 'Το όνομα του wiki δεν μπορεί να είναι κενό.',
	'autocreatewiki-empty-username' => 'Όνομα χρήστη δεν μπορεί να είναι κενό.',
	'autocreatewiki-category-label' => 'Κατηγορία:',
	'autocreatewiki-category-other' => 'Άλλο',
	'autocreatewiki-set-username' => 'Πρώτα ορίστε όνομα χρήστη.',
	'autocreatewiki-step1' => 'Δημιουργία φακέλου εικόνων...',
	'autocreatewiki-step2' => 'Δημιουργία βάσης δεδομένων...',
	'autocreatewiki-step3' => 'Ρύθμιση προεπιλεγμένων πληροφοριών στη βάση δεδομένων...',
	'autocreatewiki-congratulation' => 'Συγχαρητήρια!',
	'autocreatewiki-welcometalk-log' => 'Χαιρετιστήριο Μήνυμα',
	'autocreatewiki-step2-error' => 'Η βάση δεδομένων υπάρχει!',
);

/** Esperanto (Esperanto)
 * @author Objectivesea
 * @author Tradukisto
 */
$messages['eo'] = array(
	'autocreatewiki' => 'Krei novan vikion',
	'autocreatewiki-language-top' => '$1 plej gravaj lingvoj',
	'autocreatewiki-language-all' => 'Ĉiuj lingvoj',
	'autocreatewiki-remember' => 'Memori min:',
	'autocreatewiki-create-account' => 'Registri sin',
	'autocreatewiki-haveaccount-question' => 'Ĉu vi jam havas Wikia-konton?',
	'autocreatewiki-info-topic' => 'Aldoni mallongan priskribon, ekzemple "Stelaj Militoj" aŭ "Televidaj programoj".',
	'autocreatewiki-info-category-default' => 'Ĉi tio helpos vizitontojn trovi vian vikion.',
	'autocreatewiki-info-category-answers' => 'Ĉi tio helpos vizitontojn trovi vian respondoj-situon.',
	'autocreatewiki-title-template' => '$1 Vikio',
	'autocreatewiki-limit-day' => 'Wikia superis la maksimuman nombron da vikikreaĵoj hodiaŭ ($1).',
	'autocreatewiki-limit-creation' => 'Vi superis la ĉiutage maksimuman nombron da vikikreaĵoj ($1).',
	'autocreatewiki-invalid-wikiname' => 'La nomo ne povas enhavi specialajn signojn (ekzemple $ aŭ @) aŭ esti malplena.',
	'autocreatewiki-violate-policy' => 'Ĉi tiu vikinomo entenas vorton kiu malobservas nian nompolitikon',
	'autocreatewiki-name-too-short' => 'Ĉi tiu adreso estas tro mallonga. Bonvolu elekti adreson kun minimume 3 signoj.',
	'autocreatewiki-name-too-long' => 'Ĉi tiu adreso estas tro longa. Bonvolu elekti adreson kun maksimume 50 signoj.',
	'autocreatewiki-invalid-username' => 'Ĉi tiu uzantnomo estas nevalida.',
	'autocreatewiki-empty-wikiname' => 'La vikia nomo ne rajtas esti malplena.',
	'autocreatewiki-empty-username' => 'Uzantnomo ne rajtas esti malplena.',
	'autocreatewiki-category-label' => 'Kategorio:',
	'autocreatewiki-category-other' => 'Alia',
	'autocreatewiki-log-title' => 'Via vikio kreiĝas',
	'autocreatewiki-step1' => 'Kreas dosierujon de bildoj ...',
	'autocreatewiki-step2' => 'Kreas datenbazon ...',
	'autocreatewiki-welcomebody' => 'Saluton, $2!

Via vikio kreiĝis! Rigardu ĝin ĉe <$1>.

Ĉu vi emas komenci? Ni aldonis iom da ligiloj sur vian diskutan paĝon (<$5>) por helpi vin komenci kaj instigi vin esplori la multajn utilajn zonojn ĉirkaŭ Wikia. Se vi havos iujn ajn demandojn aŭ vi sentas iomete senkomprena, vi povos respondi ĉi tiun retpoŝton aŭ rigardi niajn rethelpajn paĝojn <http://helpo.wikia.com>.

Vi povos ankaŭ rigardi la loglibron de fondintojn kaj estraro <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> kaj la loglibron de Wikia-oficistoj <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> (angle), kie vi trovos sugestojn, rimedojn, kaj informojn pri nova trajtaro kaj novaj okazoj ĉe Wikia.

Feliĉan redaktadon!

$3
Wikia-komunuma asistaro
<http://community.wikia.com/wiki/Uzanto:$4>',
);

/** Spanish (español)
 * @author Benfutbol10
 * @author Bola
 * @author Crazymadlover
 * @author DJ Nietzsche
 * @author Locos epraix
 * @author Pertile
 * @author Peter17
 * @author Translationista
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'autocreatewiki' => 'Crear una nueva wikia',
	'autocreatewiki-desc' => 'Crear una wikia en WikiFactory a petición de un usuario',
	'autocreatewiki-page-title-default' => 'Crear una nueva wikia',
	'autocreatewiki-page-title-answers' => 'Crear un nuevo sitio de preguntas y respuestas',
	'createwiki' => 'Crea una nueva wikia',
	'autocreatewiki-chooseone' => 'Elige una',
	'autocreatewiki-required' => '$1 = requerido',
	'autocreatewiki-web-address' => 'Dirección web:',
	'autocreatewiki-category-select' => 'Selecciona una',
	'autocreatewiki-language-top' => 'Top $1 de idiomas',
	'autocreatewiki-language-all' => 'Todos los idiomas',
	'autocreatewiki-remember' => 'Recordarme',
	'autocreatewiki-create-account' => 'Crear una cuenta',
	'autocreatewiki-haveaccount-question' => '¿Ya tienes una cuenta en Wikia?',
	'autocreatewiki-info-domain' => 'Lo mejor es usar una palabra que probablemente sea una palabra clave en las búsquedas sobre tu tema.',
	'autocreatewiki-info-topic' => 'Añade una descripción corta como por ejemplo "Star Wars" o "Series de TV".',
	'autocreatewiki-info-category-default' => 'Esto ayudará a los visitantes a encontrar tu wikia.',
	'autocreatewiki-info-category-answers' => 'Esto ayudará a los visitantes a encontrar tu sitio de preguntas y respuestas.',
	'autocreatewiki-info-language' => 'Este será el idioma por defecto para los visitantes de tu wikia.',
	'autocreatewiki-info-email-address' => 'Tu dirección de correo electrónico no se mostrará a nadie en Wikia.',
	'autocreatewiki-info-realname' => 'Si optas por proporcionarlo, se usará para dar atribución a tu trabajo.',
	'autocreatewiki-info-birthdate' => 'Wikia solicita a todos los usuarios que pongan su fecha real de nacimiento como medida de seguridad y como forma de preservar la integridad del sitio mientras cumple con las regulaciones federales.',
	'autocreatewiki-info-blurry-word' => 'Para ayudar a protegernos contra la creación de cuentas automáticas, escribe la palabra borrosa que ves en este campo, por favor.',
	'autocreatewiki-info-terms-agree' => 'Al crear una wikia y una cuenta de usuario, aceptas los {{#NewWindowLink: w:c:es:Términos de uso|Términos de uso de Wikia}}',
	'autocreatewiki-info-staff-username' => '<b>Solamente Staff:</b> El usuario especificado figurará como el fundador de la wikia.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => 'Wikia ha superado el número máximo de creaciones de wikias de hoy ($1).',
	'autocreatewiki-limit-creation' => 'Has excedido el número máximo de creación de wikias en 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, completa este campo.',
	'autocreatewiki-bad-name' => 'El nombre no puede contener caracteres especiales (como $ o @) y debe componerse por palabras en minúscula y sin espacios.',
	'autocreatewiki-invalid-wikiname' => 'El nombre no puede contener caracteres especiales (como $ o @) y el campo no puede estar vacío.',
	'autocreatewiki-violate-policy' => 'El nombre de esta wikia contiene una palabra que viola nuestra política de nombres',
	'autocreatewiki-name-taken' => 'Ya existe una wikia con esta dirección. Comienza a editar en <a href="http://$1.wikia.com">http://$1.wikia.com</a> o escoge otra dirección.',
	'autocreatewiki-name-too-short' => 'Esta dirección es demasiado corta, por favor, elige una dirección con al menos 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Esta dirección es demasiado larga, por favor, elige una dirección con un máximo de 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'Debajo están las wikias ya creadas sobre este tema. Te sugerimos editar en alguna de ellas.',
	'autocreatewiki-invalid-username' => 'Este nombre de usuario no es válido.',
	'autocreatewiki-busy-username' => 'Este nombre de usuario ya está en uso.',
	'autocreatewiki-blocked-username' => 'No puedes crear la cuenta.',
	'autocreatewiki-user-notloggedin' => '¡Tu cuenta fue creada, pero no te identificaste!',
	'autocreatewiki-empty-language' => 'Por favor, selecciona el idioma de la wikia.',
	'autocreatewiki-empty-category' => 'Por favor, selecciona una categoría.',
	'autocreatewiki-empty-wikiname' => 'El campo del nombre de la wikia no puede estar vacío.',
	'autocreatewiki-empty-username' => 'El campo del nombre de usuario no puede estar vacío.',
	'autocreatewiki-empty-password' => 'El campo de la contraseña no puede estar vacío.',
	'autocreatewiki-empty-retype-password' => 'El campo para repetir la contraseña no puede estar vacío.',
	'autocreatewiki-category-label' => 'Categoría:',
	'autocreatewiki-category-other' => 'Otro',
	'autocreatewiki-set-username' => 'Pon el nombre de usuario primero.',
	'autocreatewiki-invalid-category' => 'Valor inválido para la categoría. Por favor, selecciona el apropiado desde la lista desplegable de abajo.',
	'autocreatewiki-invalid-language' => 'Valor inválido para el idioma. Por favor, selecciona el apropiado desde la lista desplegable de abajo.',
	'autocreatewiki-invalid-retype-passwd' => 'Escribe la misma contraseña que arriba.',
	'autocreatewiki-invalid-birthday' => 'Fecha de nacimiento inválida',
	'autocreatewiki-log-title' => 'Tu wikia está siendo creada',
	'autocreatewiki-step0' => 'Iniciando proceso ...',
	'autocreatewiki-stepdefault' => 'El proceso está en marcha, por favor, espera un poco ...',
	'autocreatewiki-errordefault' => 'El proceso no fue terminado ...',
	'autocreatewiki-step1' => 'Creando directorio de imágenes ...',
	'autocreatewiki-step2' => 'Creando base de datos ...',
	'autocreatewiki-step3' => 'Configurando la información por defecto en la base de datos ...',
	'autocreatewiki-step4' => 'Copiando imágenes y logo por defecto ...',
	'autocreatewiki-step5' => 'Configurando variables por defecto en la base de datos ...',
	'autocreatewiki-step6' => 'Configurando tablas por defecto en la base de datos ...',
	'autocreatewiki-step7' => 'Configurando el idioma de comienzo ...',
	'autocreatewiki-step8' => 'Configurando grupos de usuarios y categorías ...',
	'autocreatewiki-step9' => 'Configurando las variables para la nueva wikia ...',
	'autocreatewiki-step10' => 'Configurando páginas en Comunidad Central ...',
	'autocreatewiki-step11' => 'Enviando correo electrónico al usuario ...',
	'autocreatewiki-redirect' => 'Redirigiendo a la nueva comunidad: $1 ...',
	'autocreatewiki-congratulation' => '¡Felicidades!',
	'autocreatewiki-welcometalk-log' => 'Mensaje de bienvenida',
	'autocreatewiki-regex-error-comment' => 'usados en $1 wiki (texto íntegro: $2)',
	'autocreatewiki-step2-error' => '¡La base de datos ya existe!',
	'autocreatewiki-step3-error' => '¡No se puede configurar la información por defecto en la base de datos!',
	'autocreatewiki-step6-error' => '¡No se pueden configurar las tablas por defecto en la base de datos!',
	'autocreatewiki-step7-error' => '¡No se puede copiar el idioma de comienzo en la base de datos!',
	'autocreatewiki-protect-reason' => 'Parte de la interfaz oficial',
	'autocreatewiki-welcomesubject' => '¡$1 ha sido creada!',
	'autocreatewiki-welcomebody' => '¡Hola, $2!

¡Tu wikia ha sido creada! Échale un vistazo: <$1>

¿Todo preparado para comenzar? Hemos añadido algunos enlaces a tu muro de mensajes (<$5>) para ayudarte a comenzar y animarte a explorar las numerosas zonas útiles de Wikia. Si tienes alguna pregunta o estás un poco perdido responde a este correo electrónico o échale un vistazo a nuestras páginas de ayuda <http://comunidad.wikia.com/wiki/Ayuda:Contenido>.

También puedes consultar el blog del Staff de Wikia <http://comunidad.wikia.com/wiki/Blog%3ANoticias_de_Wikia> para encontrar noticias, consejos y trucos, información sobre las nuevas funcionalidades y las últimas novedades sobre lo que ocurre en Wikia.

¡Disfruta editando!

$3
El equipo comunitario de Wikia
<http://comunidad.wikia.com/wiki/Usuario:$4>

___________________________________________
* ¿Quieres recibir menos mensajes de nosotros? Puedes cancelar tu suscripción o cambiar tus preferencias de correo electrónico aquí: http://comunidad.wikia.com/wiki/Especial:Preferencias',
	'autocreatewiki-welcometalk-wall-title' => '¡Bienvenido/a!',
	'autocreatewiki-welcometalk-wall' => '¡Hola, estamos encantados de que {{subst:SITENAME}} forme parte de la comunidad de Wikia!

Todavía queda mucho por hacer, así que aquí tienes algunos consejos y enlaces para mejorar tu wikia:
*Revisa la página de [[special:WikiFeatures|funcionalidades de Wikia]] para ver qué funcionalidades puedes activar en tu wikia, incluyendo el chat, los logros y muchas cosas más.
*Personaliza la apariencia de tu wikia visitando el [[Special:ThemeDesigner|diseñador de temas]], donde puedes añadir colores y tu propio estilo al fondo y al logo.
*Para por [[w:c:comunidad|Comunidad Central]] para mantenerte al día a través del [[w:c:comunidad:Blog:Noticias de Wikia|blog del staff]], haz preguntas en los [[w:c:comunidad:Special:Forum|foros de la comunidad]] y participa en el [[w:c:comunidad:special:chat|chat]] con otros wikinautas.
*Por último, visita nuestras [[ayuda:contenido|páginas de ayuda]] para descubrir todos los secretos de Wikia, incluyendo [[Ayuda:Página nueva|cómo añadir una nueva página en tu wikia]], [[Ayuda:Atrayendo editores|cómo atraer editores]] y [[Ayuda:Niveles de acceso de los usuarios|cómo añadir más administradores]].
*También puedes usar todas estas herramientas visitando el panel de administración, que puedes encontrar haciendo clic en el enlace "Panel de administración" de la barra de herramientas inferior.

Todos los enlaces anteriores son una genial forma de comenzar a explorar, pero por encima de todo, ¡diviértete!',
	'autocreatewiki-welcometalk' => "== ¡Recibe nuestra bienvenida! ==
¡Hola!

¡Nos encanta que '''$4''' sea parte de la comunidad Wikia! Ahora hay muchas cosas que hacer; aquí tienes algunos enlaces y consejos útiles para comenzar:

*Revisa las [[Special:WikiFeatures|funcionalidades de Wikia]] para ver las funcionalidades que puedes habilitar en tu wikia, incluyendo un chat, logros y mucho más.
*Pásate por [[w:c:comunidad|Comunidad Central]] para mantenerte al día a través de nuestro [[w:c:comunidad:Blog:Noticias de Wikia|blog del staff]], hacer tus preguntas en el [[w:c:comunidad:Especial:Foro|foro de la comunidad]], o conversar en directo con otros wikinautas.
*Finalmente, visita nuestras [[ayuda:contenido|páginas de ayuda]] para saber la información básica sobre cómo usar Wikia.

Todos los enlaces anteriores son un gran lugar para comenzar a explorar, ¡así que diviértete!

-- [[User:$3|$3]] <staff />",
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Estonian (eesti)
 * @author KalmerE.
 */
$messages['et'] = array(
	'autocreatewiki' => 'Loo uus viki',
	'autocreatewiki-desc' => 'Loo uus viki WikiFactorysse kasutaja taotluse soovil',
	'autocreatewiki-page-title-default' => 'Loo uus viki',
	'autocreatewiki-page-title-answers' => 'Loo uus Vastuste sait',
	'createwiki' => 'Loo uus viki',
	'autocreatewiki-chooseone' => 'Vali üks',
	'autocreatewiki-required' => '$1= kohustuslik',
	'autocreatewiki-web-address' => 'Veebiaadress',
	'autocreatewiki-category-select' => 'Vali üks',
	'autocreatewiki-language-top' => 'Keelte esitabel $1',
	'autocreatewiki-language-all' => 'Kõik keeled',
	'autocreatewiki-remember' => 'Pea mind meeles',
	'autocreatewiki-create-account' => 'Loo konto',
	'autocreatewiki-haveaccount-question' => 'Kas sul on juba Wikias konto?',
	'autocreatewiki-info-domain' => 'Soovituslik on kasutada sõna, mis oleks sinu teema otsingu võtmesõna.',
	'autocreatewiki-info-topic' => 'Lisa lühike kirjeldus, näiteks "Star Warsist" või "Telesaadetest".',
	'autocreatewiki-info-category-default' => 'See aitab leida külastajatel sinu vikit.',
	'autocreatewiki-title-template' => '$1 Viki',
	'autocreatewiki-category-label' => 'Kategooria:',
	'autocreatewiki-category-other' => 'Muu',
	'autocreatewiki-congratulation' => 'Õnnitlen!',
	'autocreatewiki-welcometalk-log' => 'Tere tulemast sõnum',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'autocreatewiki' => 'Wiki berria sortu',
	'autocreatewiki-category-select' => 'Bat aukeratu',
	'autocreatewiki-language-all' => 'Hizkuntza guztiak',
	'autocreatewiki-remember' => 'Gogora nazazu',
	'autocreatewiki-create-account' => 'Kontua sortu',
	'autocreatewiki-category-label' => 'Kategoria:',
	'autocreatewiki-congratulation' => 'Zorionak!',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Ebraminio
 * @author Huji
 * @author Wayiran
 * @author جواد
 * @author پاناروما
 */
$messages['fa'] = array(
	'autocreatewiki' => 'ایجاد ویکی جدید',
	'autocreatewiki-page-title-default' => 'ایجاد ویکی جدید',
	'autocreatewiki-page-title-answers' => 'ایجاد یک تارنمای جدید پاسخ‌ها',
	'createwiki' => 'ایجاد ویکی جدید',
	'autocreatewiki-chooseone' => 'یکی را انتخاب کنید',
	'autocreatewiki-required' => '$1= مورد نیاز',
	'autocreatewiki-web-address' => 'نشانی اینترنتی:',
	'autocreatewiki-category-select' => 'یکی را انتخاب کنید',
	'autocreatewiki-language-top' => '$1 زبان برتر',
	'autocreatewiki-language-all' => 'همۀ زبان‌ها',
	'autocreatewiki-remember' => 'مرا به خاطر بسپار',
	'autocreatewiki-create-account' => 'ایجاد حساب کاربری',
	'autocreatewiki-haveaccount-question' => 'آیا از قبل در ویکیا حساب کاربری دارید؟',
	'autocreatewiki-info-domain' => 'بهتر است از کلمه‌ای استفاده کنید که درصد جستجو شدن آن در موضوع ویکی شما زیاد باشد.',
	'autocreatewiki-info-topic' => 'اضافه کردن توضیحات کوتاه مانند "جنگ ستارگان" یا "نمایش‌های تلویزیونی".',
	'autocreatewiki-info-category-default' => 'این به بازدیدکنندگان کمک می‌کند ویکی شما را پیدا کنند.',
	'autocreatewiki-info-language' => 'این زبان پیش‌فرض ویکی شما خواهد بود.',
	'autocreatewiki-info-email-address' => 'آدرس پست الکترونیکی شما به کاربران ویکیا نمایش داده نخواهد شد.',
	'autocreatewiki-info-birthdate' => 'تمام کاربران ویکیا مستلزم هستند که تاریخ تولد اصلی خود را برای احتیاط و حفظ منافع وب‌گاه در برابر دولت ارائه کنند.',
	'autocreatewiki-info-blurry-word' => 'برای جلوگیری از ایجاد خودکار حساب کاربری، لطفا حروف بالا را در این فیلد وارد کنید.',
	'autocreatewiki-info-terms-agree' => 'با ایجاد ویکی و حساب کاربری شما <a href="http://www.wikia.com/wiki/Terms_of_use">شرایط استفاده از ویکیا</a> را قبول می‌کنید.',
	'autocreatewiki-title-template' => 'ویکی $1',
	'autocreatewiki-empty-field' => 'لطفا این فیلد را کامل کنید.',
	'autocreatewiki-bad-name' => 'نام ویکی شامل کاراکترهای مخصوص (مانند $ یا @) نمی‌تواند باشد و باید حروف کوچک انگلیسی بدون فاصله باشد.',
	'autocreatewiki-violate-policy' => 'نام این ویکی شامل لغتی است که ناقض سیاست‌ نام‌گذاری ما است',
	'autocreatewiki-name-too-short' => 'نشانی بسیار کوتاه است، یک نشانی با کمینه ۳ نویسه برگزینید.',
	'autocreatewiki-name-too-long' => 'نشانی بسیار طولانی است. لطفاً یک نشانی با بیشینه ۵۰ نویسه برگزینید.',
	'autocreatewiki-similar-wikis' => 'در زیر ویکی‌های قرار دارند که تاکنون در این موضوع ایجاد شده‌اند. ما ویرایش یکی از آن‌ها را پیشنهاد می‌کنیم.',
	'autocreatewiki-invalid-username' => 'این نام کاربری معتبر نیست.',
	'autocreatewiki-busy-username' => 'این نام کاربری از قبل انتخاب شده‌است.',
	'autocreatewiki-blocked-username' => 'شما اجازۀ ایجاد حساب کاربری ندارید.',
	'autocreatewiki-user-notloggedin' => 'حساب کاربری شما ساخته‌شد ولی هنوز به سامانه وارد نشده‌اید!',
	'autocreatewiki-empty-language' => 'لطفا زبان ویکی را انتخاب کنید.',
	'autocreatewiki-empty-category' => 'لطفا یکی از رده‌ها را انتخاب کنید.',
	'autocreatewiki-empty-wikiname' => 'نام ویکی نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-username' => 'نام کاربری نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-password' => 'گذرواژه نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-retype-password' => 'فیلد تکرار گذرواژه نمی‌تواند خالی باشد.',
	'autocreatewiki-category-label' => 'رده:',
	'autocreatewiki-category-other' => 'سایر',
	'autocreatewiki-set-username' => 'نخست نام کاربری را تنظیم کن.',
	'autocreatewiki-invalid-category' => 'مقدار نامعتبر رده.
لطفاً از فهرست کشویی گزینهٔ مناسب را برگزینید.',
	'autocreatewiki-invalid-language' => 'مقدار نامعتبر برای زبان.
لطفاً گزینهٔ مناسب را از فهرست کشویی زیر برگزینید.',
	'autocreatewiki-invalid-retype-passwd' => 'لطفاً گذرواژهٔ بالا را دوباره تایپ کنید',
	'autocreatewiki-invalid-birthday' => 'تاریخ تولد نامعتبر',
	'autocreatewiki-log-title' => 'ویکی شما در حال ایجادشدن است',
	'autocreatewiki-step0' => 'فرایند راه‌اندازی ...',
	'autocreatewiki-stepdefault' => 'فرآیند در حال انجام‌شدن است، لطفا صبر کنید ...',
	'autocreatewiki-errordefault' => 'عمل پایان نیافت ...',
	'autocreatewiki-step1' => 'ایجاد پوشهٔ تصاویر ...',
	'autocreatewiki-step2' => 'ایجاد پایگاه داده ...',
	'autocreatewiki-step3' => 'تنظیم اطلاعات پیش‌فرض در پایگاه داده ...',
	'autocreatewiki-step4' => 'کپی‌کردن تصاویر پیش‌فرض و آرم ...',
	'autocreatewiki-step5' => 'تنظیم متغیرهای پیش‌فرض در پایگاه داده ...',
	'autocreatewiki-step6' => 'تنظیم جدول‌های پیش‌فرض در پایگاه داده ...',
	'autocreatewiki-step7' => 'در حال تنظیم نسخه آغازگر ویکی ...',
	'autocreatewiki-step8' => 'در حال تنظیم اختیارات گروه‌های کاربری و رده‌ها ...',
	'autocreatewiki-step9' => 'در حال تنظیم متغیرهای ویکی جدید ...',
	'autocreatewiki-step10' => 'تنظیم صفحات در ویکی مرکزی ...',
	'autocreatewiki-step11' => 'فرستادن رایانامه به کاربر...',
	'autocreatewiki-redirect' => 'تغییر مسیر به ویکی جدید: $1 ...',
	'autocreatewiki-congratulation' => 'مبارک باشد!',
	'autocreatewiki-welcometalk-log' => 'پیغام خوش‌آمد گویی',
	'autocreatewiki-regex-error-comment' => 'در ویکی $1 به کار رفته است (کل متن: $2)',
	'autocreatewiki-step2-error' => 'پایگاه داده وجود دارد!',
	'autocreatewiki-step3-error' => 'نمی‌توان اطلاعات پیش‌فرض را در پایگاه داده تنظیم کرد!',
	'autocreatewiki-step6-error' => 'نمی‌توان جدول‌های پیش‌فرض را در پایگاه داده تنظیم کرد!',
	'autocreatewiki-step7-error' => 'نسخه‌برداری از پایگاه آغازگر ویکی با موفقیت انجام نشد!',
	'autocreatewiki-protect-reason' => 'بخشی از رابط رسمی',
	'autocreatewiki-welcomesubject' => '$1 ساخته شد!',
	'autocreatewiki-welcomebody' => 'سلام $2،

ویکیایی که شما درخواست کرده بودید در <$1> قابل دسترسی است. ما امیدواریم به زودی شاهد ویرایش شما در آنجا باشیم!

ما یک سری اطلاعات و نکته‌هایی در صفحهٔ بحثتان (<$5>) اضافه کرده‌ایم تا به شما برای شروع ویکی‌تان کمک کند.

اگر سوالی دارید، به این ایمیل پاسخ دهید یا در صفحات راهنمای ویکیا در <http://help.wikia.com> جستجو کنید یا با community@wikia.com نامه‌نگاری کنید. شما همچنین می‌توانید &lrm;#wikia کانال چت آی‌آرسی <http://irc.wikia.com> ما را ببینید.

با پروژه موفق باشید!

$3

تیم جامعهٔ ویکیا

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '<div align="right" dir="rtl" style="font-family: Tahoma;">
سلام $1، ما از داشتن \'\'\'$4\'\'\' در بین دیگر ویکیاهای ویکیا بسیار خوشحالیم!

شروع کردن ویکی جدید می‌تواند کار بزرگی باشد، ولی نگران نباشید، [[wikia:Community Team|تیم اجتماع ویکیا]] برای کمک اینجاست! ما راهنمایی‌هایی برای کمک به شروع ویکی جدید آماده کرده‌ایم. در کنار راهنمایی‌های ویکیا می‌توانید به ویکی‌های دیگر در [[w:c:fa:شرکت ویکیا|ویکیا]] برای گرفتن ایده جهت قالب بندی، رده بندی، و غیره سر بزنید. همه ما عضوی از خانواده بزرگ ویکیا هستیم که برای خوش گذرانی در اینجا با هم مشارکت می‌کنیم!
* [[w:c:help:Help:Starting this wiki|راهنمای شروع ویکی]] ما ۵ نکته به شما می‌دهد تا همین الان ویکی خود را به بهترین وجه تنظیم نمایید.
*ما همچنین [[w:c:help:Advice:Advice on starting a wiki| توصیه‌هایی برای شروع ویکی]] آماده  کرده‌ایم که اطلاعات عمیق‌تری برای ساخت ویکی جدید به شما می‌دهد.
*اگر شما کاربر جدید ویکیا هستید، ما به شما توصیه می‌کنیم که به [[w:c:fa:پرسش‌های رایج|پرسش‌های رایج کاربران جدید]]  مراجعه کنید.
اگر کمکی نیاز داشتید، می‌توانید به [[w:c:help|راهنمای ویکیا]] مراجعه کنید و یا از طریق [[Special:Contact|فرم تماس]] به ما پست الکترونیکی بزنید.

منتظر درخشش پروژه شما هستیم!

با آرزوی بهترین‌ها، [[User:$2|$3]] <staff />
</div>',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Crt
 * @author Lukkipoika
 * @author Nedergard
 * @author Nike
 * @author Tofu II
 * @author VezonThunder
 */
$messages['fi'] = array(
	'autocreatewiki' => 'Luo uusi wiki',
	'autocreatewiki-desc' => 'Luo käyttäjän pyynnöistä wikin sivustolle WikiFactory',
	'autocreatewiki-page-title-default' => 'Luo uusi wiki',
	'autocreatewiki-page-title-answers' => 'Luo uusi "Vastaussivusto"',
	'createwiki' => 'Luo uusi wiki',
	'autocreatewiki-chooseone' => 'Valitse yksi',
	'autocreatewiki-required' => '$1 = vaadittu',
	'autocreatewiki-web-address' => 'Verkko-osoite:',
	'autocreatewiki-category-select' => 'Valitse yksi',
	'autocreatewiki-language-top' => 'Top$1 kieltä',
	'autocreatewiki-language-all' => 'Kaikki kielet',
	'autocreatewiki-remember' => 'Muista minut',
	'autocreatewiki-create-account' => 'Luo tunnus',
	'autocreatewiki-haveaccount-question' => 'Onko sinulla jo Wikia-tili?',
	'autocreatewiki-info-domain' => 'Kannattaa käyttää sanaa, jolla aihettasi todennäköisesti haetaan.',
	'autocreatewiki-info-topic' => 'Lisää lyhyt kuvaus, kuten ”Tähtien sota” tai ”TV-ohjelmat”.',
	'autocreatewiki-info-category-default' => 'Tämä auttaa kävijöitä löytämään wikisi.',
	'autocreatewiki-info-category-answers' => 'Tämä auttaa vierailijoita löytämään sinun Vastaussivustosi.',
	'autocreatewiki-info-language' => 'Tämä tulee olemaan wikisi kävijöiden oletuskieli.',
	'autocreatewiki-info-email-address' => 'Sähköpostiosoitettasi ei koskaan näytetä kenellekään Wikiassa.',
	'autocreatewiki-info-realname' => 'Jos valitset sen tarjoamisen, tätä käytetään antamaan sinulle syy työhön.',
	'autocreatewiki-info-birthdate' => 'Wikia vaatii kaikkia käyttäjiä antamaan oikean syntymäaikansa sekä turvatoimena että tapana säilyttää sivuston eheys samalla, kun tulee noudattaa hallinnollisia säädöksiä.',
	'autocreatewiki-info-blurry-word' => 'Automaattisen tunnusten luonnin estämiseksi kirjoita näkemäsi sumea sana tähän kenttään.',
	'autocreatewiki-info-terms-agree' => 'Luomalla wikin ja käyttäjätunnuksen hyväksyt <a href="http://www.wikia.com/wiki/Terms_of_use">Wikian käyttösäännöt</a>.',
	'autocreatewiki-info-staff-username' => '<b>Vain henkilökunnalle:</b> Valittu käyttäjä merkitään perustajaksi.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia on saavuttanut maksimimäärän luotuja wikejä tänään ($1).',
	'autocreatewiki-limit-creation' => 'Olet ylittänyt wikien luonnin enimmäismäärän 24 tunnin sisällä ( $1 ).',
	'autocreatewiki-empty-field' => 'Täytä tämä kenttä, kiitos.',
	'autocreatewiki-bad-name' => 'Nimi ei voi sisältää erikoismerkkejä (kuten $ tai @) ja sen on oltava pienin kirjaimin kirjoitettu sana ilman välilyöntejä.',
	'autocreatewiki-invalid-wikiname' => 'Nimi ei voi sisältää erikoismerkkejä (kuten $ tai @) ja se ei voi olla tyhjä',
	'autocreatewiki-violate-policy' => 'Tämän wikin nimi sisältää sanan joka vastustaa nimipolitiikkaamme.',
	'autocreatewiki-name-taken' => 'Wiki tässä osoitteessa on jo olemassa. Aloita muokkaaminen <a href="http://$1.wikia.com">http://$1.wikia.com</a>ssä tai valitse toinen osoite.',
	'autocreatewiki-name-too-short' => 'Tämä osoite on liian lyhyt. Valitse osoite, jossa on vähintään 3 merkkiä.',
	'autocreatewiki-name-too-long' => 'Tämä osoite on liian pitkä. Valitse osoite, jossa on enintään 50 merkkiä.',
	'autocreatewiki-similar-wikis' => 'Alla ovat wikit jotka ovat jo luotu tälle aiheelle. Ehdotamme yhden muokkaamista niistä.',
	'autocreatewiki-invalid-username' => 'Tämä käyttäjätunnus on virheellinen.',
	'autocreatewiki-busy-username' => 'Tämä käyttäjätunnus on jo varattu.',
	'autocreatewiki-blocked-username' => 'Et voi luoda tunnusta.',
	'autocreatewiki-user-notloggedin' => 'Tunnuksesi luotiin mutta et ole kirjautunut sisään!',
	'autocreatewiki-empty-language' => 'Valitse wikillesi kieli.',
	'autocreatewiki-empty-category' => 'Valitse yksi luokista.',
	'autocreatewiki-empty-wikiname' => 'Wikinimi ei voi olla tyhjä.',
	'autocreatewiki-empty-username' => 'Käyttäjätunnus ei voi olla tyhjä.',
	'autocreatewiki-empty-password' => 'Salasana ei voi olla tyhjä.',
	'autocreatewiki-empty-retype-password' => 'Kirjoita salasana; se ei voi olla tyhjä.',
	'autocreatewiki-category-label' => 'Luokka:',
	'autocreatewiki-category-other' => 'Muu',
	'autocreatewiki-set-username' => 'Aseta käyttäjätunnus ensin.',
	'autocreatewiki-invalid-category' => 'Virheellinen luokka.
Valitse asianmukainen nimi avattavasta luettelosta.',
	'autocreatewiki-invalid-language' => 'Valitse kelvollinen kieli alasvetovalikosta.',
	'autocreatewiki-invalid-retype-passwd' => 'Kirjoita sama salasana kuin edellä',
	'autocreatewiki-invalid-birthday' => 'Virheellinen syntymäaika',
	'autocreatewiki-log-title' => 'Wikisi on nyt luotu.',
	'autocreatewiki-step0' => 'Alustetaan prosessia...',
	'autocreatewiki-stepdefault' => 'Prosessi on käynnissä, odota...',
	'autocreatewiki-errordefault' => 'Prosessi ei ole päättynyt...',
	'autocreatewiki-step1' => 'Luodaan kuvahakemisto...',
	'autocreatewiki-step2' => 'Luodaan tietokanta...',
	'autocreatewiki-step3' => 'Asetetaan oletustiedot tietokantaan...',
	'autocreatewiki-step4' => 'Kopioidaan oletuskuvat ja logo...',
	'autocreatewiki-step5' => 'Asetetaan oletustiedot tietokantaan...',
	'autocreatewiki-step6' => 'Asetetaan tietokannan oletustaulukot...',
	'autocreatewiki-step7' => 'Asetetaan kielialoitinta...',
	'autocreatewiki-step8' => 'Määritetään käyttäjäryhmät ja luokat...',
	'autocreatewiki-step9' => 'Määritetään uudet wikimuuttujat...',
	'autocreatewiki-step10' => 'Määritetään sivuja keskuswikiin...',
	'autocreatewiki-step11' => 'Lähetetään sähköpostia käyttäjälle...',
	'autocreatewiki-redirect' => 'Ohjataan uuteen wikiin: $1...',
	'autocreatewiki-congratulation' => 'Onnittelut!',
	'autocreatewiki-welcometalk-log' => 'Tervetuloviesti',
	'autocreatewiki-regex-error-comment' => 'käytetty wikissä $1 (koko teksti: $2)',
	'autocreatewiki-step2-error' => 'Tietokanta on olemassa!',
	'autocreatewiki-step3-error' => 'Oletusarvon mukaan tietoja ei voi asettaa tietokantaan!',
	'autocreatewiki-step6-error' => 'Oletusarvon mukaan taulukoita ei voi asettaa tietokantaan!',
	'autocreatewiki-step7-error' => 'Aloitusversion tietokannan kieltä ei voi kopioida!',
	'autocreatewiki-protect-reason' => 'Osa virallista käyttöliittymää',
	'autocreatewiki-welcomesubject' => '$1 on luotu.',
	'autocreatewiki-welcomebody' => 'Hei $2

Wikisi on luotu! Katso: <$1>

Oletko valmis aloittamaan? Olemme lisänneet muutamia linkkejä keskustelusivulle ( $5 >), joka auttaa sinut alkuun ja kannustaa. Voit tutkia monia hyödyllisiä alueita Wikian ympärillä. Jos sinulla on kysymyksiä tai tuntuu hieman menetetyltä, vastaa tähän viestiin tai tutustu Ohjesivuihimme <http: help.wikia.com="">.

Voit katsoa myös Perustaja & Ylläpitäjä-blogi <http:> </http:>  %3AWikia_Founders_% 26_Admins > ja Wikian henkilökunnan blogiin <http: community.wikia.com/wiki/blog:wikia_staff_blog=""> josta löydät vinkkejä, uusia ominaisuuksia ja uusia asioita joita Wikiassa tapahtuu.

Onnellista muokkaamista!

$3
Wikia-yhteisön tukihenkilökunta
<http://community.wikia.com/wiki/User:$4>

___________________________________________
 * haluatko saada meiltä vähemmän viestejä? Voit peruuttaa tilauksen tai muuttaa sähköpostin asetukset tässä: http://community.wikia.com/Special:Preferences</http:> </http:>',
	'autocreatewiki-welcometalk-wall-title' => 'Tervetuloa!',
	'autocreatewiki-welcometalk' => "== Tervetuloa! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hei \$1 -- olemme innostuneita saamaan '''\$4''' osaksi Wikia-yhteisöämme!

Nyt sinulla on kokonainen nettisivusto täytettäväksi tiedolla, kuvilla ja videoilla suosikkiaiheestasi. Mutta juuri nyt, se on tyhjä wiki täynnä tyhjiä sivuja vain tuijottamassa sinua... Pelottavaa, eikö? Tässä on muutamia keinoja aloittamiseen:

* '''Esittele aihettasi''' etusivulla. Tämä on mahdollisuutesi selittää wikisi lukijoille, mistä se kertoo. Kirjoita niin paljon kuin haluat! Kuvauksessasi voi olla vaikka linkkejä wikisi tärkeille sivuille.

* '''Tee uusia sivuja''' -- vain lause tai kaksi on hyvä aloitus. Älä anna tyhjien sivujen tuijottaa sinua enempää! Joka kerta kun tulet sivulle, voit muokata sitä miten haluat. Sinä voit myös lisätä kuvia ja videoita täyttääksesi sivusi ja tehdäksesi siitä kiinnostavamman.

Ja sitten jatka vain samaan malliin! Ihmiset pitävät vierailusta wikeissä kun siellä on paljon mistä lukea ja katsoa, joten lisää asioita usein wikiisi, ja sinä houkuttelet varmasti paljon lukijoita ja muokkaajia. Täällä on paljon tehtävää, mutta älä huoli -- tämä on ensimmäinen päiväsi, ja sinulla on paljon aikaa. Joka wiki aloittaa samalla tavalla -- vähän kerrallaan, aloittamalla muutamia entisiä sivuja, kunnes se kasvaa suureksi, kiireiseksi wikiksi.

Jos sinulla on kysyttävää, [[Special:Contact|lähetä sähköpostia]] Wikian tukihenkilökunnalle. Pidä hauskaa!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'autocreatewiki' => 'Stovnað eina nýggja wiki',
	'autocreatewiki-desc' => 'Stovnað wiki í WikiFactory eftir áheitan frá brúkara',
	'autocreatewiki-page-title-default' => 'Stovnað nýggja wiki',
	'autocreatewiki-page-title-answers' => 'Stovnað eina nýggja Svar síðu',
	'createwiki' => 'Stovna eina nýggja wiki',
	'autocreatewiki-chooseone' => 'Vel ein',
	'autocreatewiki-required' => '$1 = er kravt',
	'autocreatewiki-web-address' => 'Internet bústaður:',
);

/** French (français)
 * @author Gomoko
 * @author IAlex
 * @author Iluvalar
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Peter17
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'autocreatewiki' => 'Créer un  nouveau wikia',
	'autocreatewiki-desc' => 'Crée un wikia dans WikiFactory à la demande des utilisateurs',
	'autocreatewiki-page-title-default' => 'Créer un nouveau wikia',
	'autocreatewiki-page-title-answers' => 'Créer un nouveau site de réponses',
	'createwiki' => 'Créer un nouveau wikia',
	'autocreatewiki-chooseone' => 'Choisissez-en un',
	'autocreatewiki-required' => '$1 = obligatoire',
	'autocreatewiki-web-address' => 'URL :',
	'autocreatewiki-category-select' => 'En choisir un',
	'autocreatewiki-language-top' => 'Les $1 langues les plus utilisées',
	'autocreatewiki-language-all' => 'Toutes les langues',
	'autocreatewiki-remember' => 'Se souvenir de moi',
	'autocreatewiki-create-account' => 'Créer un compte',
	'autocreatewiki-haveaccount-question' => 'Vous avez déjà un compte Wikia ?',
	'autocreatewiki-info-domain' => 'Choisissez de préférence un mot qui sera utilisé par des utilisateurs effectuant une recherche sur ce sujet.',
	'autocreatewiki-info-topic' => 'Ajoutez une courte description telle que « Star Wars » ou « séries ».',
	'autocreatewiki-info-category-default' => 'Cela permettra aux visiteurs de trouver votre wikia.',
	'autocreatewiki-info-category-answers' => 'Cela permettra aux visiteurs de trouver votre site de réponses.',
	'autocreatewiki-info-language' => "Il s'agit de la langue par défaut de votre wikia.",
	'autocreatewiki-info-email-address' => "Votre adresse e-mail n'est pas visible sur Wikia.",
	'autocreatewiki-info-realname' => 'Si vous choisissez de le partager, il sera utilisé pour vous attribuer les actions que vous avez effectuées.',
	'autocreatewiki-info-birthdate' => 'Wikia demande à tous les utilisateurs de fournir leur date de naissance réelle ; ceci est une mesure de sécurité et permet également de préserver l’intégrité du site tout en respectant les lois fédérales américaines.',
	'autocreatewiki-info-blurry-word' => 'Afin de nous aider à lutter contre la création de comptes automatisée, merci de saisir le mot flou dans ce champ.',
	'autocreatewiki-info-terms-agree' => "En créant un wikia et un compte utilisateur, vous acceptez nos {{#NewWindowLink:homepage:fr:Conditions d'utilisation|Conditions d'utilisation}}",
	'autocreatewiki-info-staff-username' => "<b>Staff uniquement :</b> l'utilisateur spécifié deviendra le fondateur du wikia.",
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => "Le nombre de nouveaux wikias pouvant être créés aujourd'hui ($1) a été dépassé.",
	'autocreatewiki-limit-creation' => 'Vous avez dépassé le nombre maximum de wikias pouvant être créés en 24 heures ($1).',
	'autocreatewiki-empty-field' => 'Merci de compléter ce champ.',
	'autocreatewiki-bad-name' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @), doit être un mot unique, en minuscules et sans espaces.',
	'autocreatewiki-invalid-wikiname' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @) et ne doit pas être vide.',
	'autocreatewiki-violate-policy' => 'Le nom de ce wikia contient un mot qui enfreint notre règlement.',
	'autocreatewiki-name-taken' => 'Cette URL est déjà prise. Participez sur <a href="http://$1.wikia.com">http://$1.wikia.com</a> ou choisissez une autre URL.',
	'autocreatewiki-name-too-short' => 'Cette URL est trop courte, choisissez une URL avec au moins 3 caractères.',
	'autocreatewiki-name-too-long' => 'Cette URL est trop longue, choisissez une URL avec au maximum 50 caractères.',
	'autocreatewiki-similar-wikis' => "Vous trouverez ci-dessous une liste des wikias sur le même sujet. Peut-être pouvez-vous participer sur l'un d'entre eux ?",
	'autocreatewiki-invalid-username' => "Ce nom d'utilisateur n'est pas valide.",
	'autocreatewiki-busy-username' => "Ce nom d'utilisateur est déjà pris.",
	'autocreatewiki-blocked-username' => 'Vous ne pouvez pas créer de compte.',
	'autocreatewiki-user-notloggedin' => "Votre compte a été créé mais vous n'êtes pas connecté !",
	'autocreatewiki-empty-language' => 'Sélectionnez la langue du wikia.',
	'autocreatewiki-empty-category' => 'Sélectionnez une catégorie.',
	'autocreatewiki-empty-wikiname' => 'Le nom du wikia ne peut pas être vide.',
	'autocreatewiki-empty-username' => "Le nom d'utilisateur ne peut pas être vide.",
	'autocreatewiki-empty-password' => 'Le mot de passe ne peut pas être vide.',
	'autocreatewiki-empty-retype-password' => 'Veuillez saisir à nouveau le mot de passe.',
	'autocreatewiki-category-label' => 'Catégorie :',
	'autocreatewiki-category-other' => 'Autre',
	'autocreatewiki-set-username' => "Vous devez d'abord définir votre nom d'utilisateur.",
	'autocreatewiki-invalid-category' => 'Catégorie non valide.
Merci de sélectionner une valeur dans le menu déroulant.',
	'autocreatewiki-invalid-language' => 'Langue non valide.
Merci de sélectionner une valeur dans le menu déroulant.',
	'autocreatewiki-invalid-retype-passwd' => 'Veuillez saisir le même mot de passe que celui ci-dessus.',
	'autocreatewiki-invalid-birthday' => 'Date de naissance non valide',
	'autocreatewiki-log-title' => 'Votre wikia est en cours de création.',
	'autocreatewiki-step0' => 'Initialisation...',
	'autocreatewiki-stepdefault' => 'Votre wikia est en cours de création, veuillez patienter...',
	'autocreatewiki-errordefault' => "La création du wikia n'est pas finie...",
	'autocreatewiki-step1' => 'Création du dossier des images en cours...',
	'autocreatewiki-step2' => 'Création de la base de données en cours...',
	'autocreatewiki-step3' => 'Ajout des informations par défaut dans la base de données en cours...',
	'autocreatewiki-step4' => 'Copie des images par défaut et du logo en cours...',
	'autocreatewiki-step5' => 'Ajout des variables par défaut dans la base de données en cours...',
	'autocreatewiki-step6' => 'Ajout des tables par défaut dans la base de données en cours...',
	'autocreatewiki-step7' => 'Ajout des bases pour la langue en cours...',
	'autocreatewiki-step8' => 'Ajout des groupes utilisateurs et catégories en cours...',
	'autocreatewiki-step9' => 'Ajout des variables du nouveau wikia en cours...',
	'autocreatewiki-step10' => 'Ajout des pages dans le wikia central en cours...',
	'autocreatewiki-step11' => "Envoi de l'e-mail à l'utilisateur en cours...",
	'autocreatewiki-redirect' => 'Redirection vers le nouveau wikia : $1...',
	'autocreatewiki-congratulation' => 'Félicitations !',
	'autocreatewiki-welcometalk-log' => 'Message de bienvenue',
	'autocreatewiki-regex-error-comment' => 'utilisé sur le wikia $1 (texte complet : $2)',
	'autocreatewiki-step2-error' => 'La base de données existe déjà !',
	'autocreatewiki-step3-error' => "Impossible d'ajouter les informations par défaut à la base de données !",
	'autocreatewiki-step6-error' => "Impossible d'ajouter les tables par défaut dans la base de données !",
	'autocreatewiki-step7-error' => 'Impossible de copier la base de données de base pour cette langue !',
	'autocreatewiki-protect-reason' => "Partie de l'interface officielle",
	'autocreatewiki-welcomesubject' => "$1 vient d'être créé !",
	'autocreatewiki-welcomebody' => "Bonjour $2 !

Vous venez de créer un wikia !  Le voici : <$1>

Vous êtes prêt à commencer ?  Nous avons ajouté quelques liens sur votre page de discussion (<$5>) pour vous aider à faire vos premiers pas et vous rediriger vers les nombreuses pages d'aide de Wikia. Si vous avez des questions ou vous sentez un peu perdu, répondez à ce message ou consultez nos pages d'aide <http://communaute.wikia.com/wiki/Aide:Contenu>.

Nous vous encourageons également à lire le blog « Fondateur et administrateur » <http://communaute.wikia.com/wiki/Blog:Conseils_pour_fondateurs/administrateurs>  et le blog Actualité Wikia <http://communaute.wikia.com/wiki/Blog:Actualité_Wikia> ; vous y trouverez des astuces ainsi que des informations sur les nouvelles fonctionnalités de Wikia.

Merci d'avance pour vos contributions !

$3
L’équipe Support de Wikia
<http://communaute.wikia.com/wiki/Utilisateur:$4>

___________________________________________
* Vous souhaitez recevoir moins de notifications de notre part ? Vous pouvez vous désabonner ou modifier vos préférences e-mail ici : http://community.wikia.com/Special:Preferences",
	'autocreatewiki-welcometalk-wall-title' => 'Bienvenue !',
	'autocreatewiki-welcometalk-wall' => "Bonjour !

Nous sommes heureux d'accueillir {{subst:SITENAME}} dans la communauté Wikia ! Voici quelques liens et astuces utiles qui vous permettront de dynamiser et gérer votre wikia :

*Vous n'êtes pas sûr de savoir par où commencer ? Arrêtez-vous sur le [[w:fr:Accueil|Centre des communautés]] et lisez le blog « [[w:fr:Blog:Conseils pour fondateurs/administrateurs|Conseils pour fondateurs et administrateurs]] ». Vous y trouverez des astuces pour démarrer votre wikia et le faire évoluer.
*Consultez l'[[w:fr:Blog:Actualité Wikia|actualité Wikia]] pour vous tenir informé des derniers événements.
*Explorez le [[w:fr:Special:Forum|forum]] sur le Centre des communautés pour voir quelles questions posent les autres administrateurs.
*Personnalisez l'apparence de votre wikia en visitant le [[Special:ThemeDesigner|Concepteur de thème]] : ajoutez des couleurs, modifiez l'arrière-plan et le logo etc.
*Consultez la page [[Special:WikiFeatures|Composants de wikia]] pour découvrir quelles fonctionnalités vous pouvez activer sur votre wikia.
*Pour finir, parcourez les [[Aide:Contenu|pages d'aide]] pour trouver des réponses à vos questions.

Tous les liens ci-dessus sont un bon moyen de commencer à naviguer sur Wikia. Si vous êtes bloqué ou si vous avez toujours des questions, [[Special:Contact|contactez-nous]]. Mais le plus important est que vous vous amusiez !

Bonnes modifications !",
	'autocreatewiki-welcometalk' => "==Bienvenue !==
Bonjour !

Nous sommes heureux d'accueillir $4 dans la communauté Wikia ! Voici quelques liens et astuces utiles qui vous permettront de dynamiser et gérer votre wikia :

*Vous n'êtes pas sûr de savoir par où commencer ? Arrêtez-vous sur le [[w:fr:Accueil|Centre des communautés]] et lisez le blog « [[w:fr:Blog:Conseils pour fondateurs/administrateurs|Conseils pour fondateurs et administrateurs]] ». Vous y trouverez des astuces pour démarrer votre wikia et le faire évoluer.
*Consultez l'[[w:fr:Blog:Actualité Wikia|actualité Wikia]] pour vous tenir informé des derniers événements.
*Explorez le [[w:fr:Special:Forum|forum]] sur le Centre des communautés pour voir quelles questions posent les autres administrateurs.
*Personnalisez l'apparence de votre wikia en visitant le [[Special:ThemeDesigner|Concepteur de thème]] : ajoutez des couleurs, modifiez l'arrière-plan et le logo etc.
*Consultez la page [[Special:WikiFeatures|Composants de wikia]] pour découvrir quelles fonctionnalités vous pouvez activer sur votre wikia.
*Pour finir, parcourez les [[Aide:Contenu|pages d'aide]] pour trouver des réponses à vos questions.

Tous les liens ci-dessus sont un bon moyen de commencer à naviguer sur Wikia. Si vous êtes bloqué ou si vous avez toujours des questions, [[Special:Contact|contactez-nous]]. Mais le plus important est que vous vous amusiez !

Bonnes modifications !

— [[User:$2|$3]] <staff /></div>",
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'autocreatewiki' => 'Crear un novo wiki',
	'autocreatewiki-desc' => 'Crea un wiki en WikiFactory mediante a solicitude dun usuario',
	'autocreatewiki-page-title-default' => 'Crear un novo wiki',
	'autocreatewiki-page-title-answers' => 'Crear un novo sitio de respostas',
	'createwiki' => 'Crear un novo wiki',
	'autocreatewiki-chooseone' => 'Escolla un',
	'autocreatewiki-required' => '$1 = obrigatorio',
	'autocreatewiki-web-address' => 'Enderezo web:',
	'autocreatewiki-category-select' => 'Seleccione un',
	'autocreatewiki-language-top' => 'As $1 linguas máis empregadas',
	'autocreatewiki-language-all' => 'Todas as linguas',
	'autocreatewiki-remember' => 'Lembrádeme',
	'autocreatewiki-create-account' => 'Crear unha conta',
	'autocreatewiki-haveaccount-question' => 'Xa ten unha conta Wikia?',
	'autocreatewiki-info-domain' => 'O mellor é usar como palabra clave unha que describa claramente o seu tema.',
	'autocreatewiki-info-topic' => 'Engada unha breve descrición, como "Star Wars" ou "series de televisión".',
	'autocreatewiki-info-category-default' => 'Isto axudará aos visitantes a atopar o seu wiki.',
	'autocreatewiki-info-category-answers' => 'Isto axudará aos visitantes a atopar o seu sitio de respostas.',
	'autocreatewiki-info-language' => 'Esta será a lingua por defecto para os visitantes do seu wiki.',
	'autocreatewiki-info-email-address' => 'Non se mostrará a ninguén en Wikia o seu enderezo de correo electrónico.',
	'autocreatewiki-info-realname' => 'Se escolle dalo utilizarase para atribuírlle o seu traballo.',
	'autocreatewiki-info-birthdate' => 'Wikia necesita que todos os usuarios acheguen a súa data de nacemento real como precaución de seguridade e como medio para preservar a integridade do sitio, respectando as normativas nacionais.',
	'autocreatewiki-info-blurry-word' => 'Para axudarnos á protección contra a creación de contas automáticas, escriba a palabra borrosa que vexa neste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao crear un wiki e unha conta de usuario, vostede acepta os <a href="http://www.wikia.com/wiki/Terms_of_use">termos de uso de Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Persoal só:</b> o usuario especificado será considerado o fundador.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => 'Wikia superou o número máximo de novos wikis para hoxe ($1).',
	'autocreatewiki-limit-creation' => 'Superou o número máximo de novos wikis en 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, encha este campo.',
	'autocreatewiki-bad-name' => 'O nome non pode conter caracteres especiais (como $ ou @) e debe ser unha soa palabra en minúsculas e sen espazos.',
	'autocreatewiki-invalid-wikiname' => 'O nome non pode conter caracteres especiais (como $ ou @) e non pode estar baleiro',
	'autocreatewiki-violate-policy' => 'O nome deste wiki contén unha palabra que viola a nosa política de nomes',
	'autocreatewiki-name-taken' => 'Xa existe un wiki con este enderezo. Comece a editar en <a href="http://$1.wikia.com">http://$1.wikia.com</a> ou escolla outro enderezo.',
	'autocreatewiki-name-too-short' => 'Este enderezo é curto de máis; escolla un enderezo cun mínimo de 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Este enderezo é longo de máis; escolla un enderezo cun máximo de 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'A continuación móstranse os wikis existentes sobre este tema. Suxerímoslle que edite nalgún deles.',
	'autocreatewiki-invalid-username' => 'Este nome de usuario non é válido.',
	'autocreatewiki-busy-username' => 'Este nome de usuario xa está en uso.',
	'autocreatewiki-blocked-username' => 'Non pode crear unha conta.',
	'autocreatewiki-user-notloggedin' => 'Creouse a súa conta, pero non accedeu ao sistema!',
	'autocreatewiki-empty-language' => 'Por favor, seleccione a lingua do wiki.',
	'autocreatewiki-empty-category' => 'Por favor, seleccione unha categoría.',
	'autocreatewiki-empty-wikiname' => 'O nome do wiki non pode estar baleiro.',
	'autocreatewiki-empty-username' => 'O nome de usuario non pode estar baleiro.',
	'autocreatewiki-empty-password' => 'O contrasinal non pode estar baleiro.',
	'autocreatewiki-empty-retype-password' => 'O campo para repetir o contrasinal non pode estar baleiro.',
	'autocreatewiki-category-label' => 'Categoría:',
	'autocreatewiki-category-other' => 'Outro',
	'autocreatewiki-set-username' => 'Defina o nome de usuario primeiro.',
	'autocreatewiki-invalid-category' => 'Valor inválido para a categoría. Por favor, escolla o valor axeitado da lista despregable.',
	'autocreatewiki-invalid-language' => 'Valor inválido para a lingua. Por favor, escolla o valor axeitado da lista despregable.',
	'autocreatewiki-invalid-retype-passwd' => 'Por favor, escriba o mesmo contrasinal que enriba',
	'autocreatewiki-invalid-birthday' => 'Data de nacemento non válida',
	'autocreatewiki-log-title' => 'Estase creando o seu wiki',
	'autocreatewiki-step0' => 'Iniciando o proceso...',
	'autocreatewiki-stepdefault' => 'O proceso está en marcha, por favor, agarde...',
	'autocreatewiki-errordefault' => 'O proceso non rematou...',
	'autocreatewiki-step1' => 'Creando a carpeta de imaxes...',
	'autocreatewiki-step2' => 'Creando a base de datos...',
	'autocreatewiki-step3' => 'Definindo a información por defecto na base de datos...',
	'autocreatewiki-step4' => 'Copiando as imaxes por defecto e mais o logo...',
	'autocreatewiki-step5' => 'Definindo as variables por defecto na base de datos...',
	'autocreatewiki-step6' => 'Definindo as táboas por defecto na base de datos...',
	'autocreatewiki-step7' => 'Definindo o iniciador para a lingua...',
	'autocreatewiki-step8' => 'Definindo os grupos de usuario e mais as categorías...',
	'autocreatewiki-step9' => 'Definindo as variables para o novo wiki...',
	'autocreatewiki-step10' => 'Definindo as páxinas no wiki central...',
	'autocreatewiki-step11' => 'Enviando un correo electrónico ao usuario...',
	'autocreatewiki-redirect' => 'Redirixindo cara ao novo wiki: $1...',
	'autocreatewiki-congratulation' => 'Parabéns!',
	'autocreatewiki-welcometalk-log' => 'Mensaxe de benvida',
	'autocreatewiki-regex-error-comment' => 'empregado no wiki $1 (texto completo: $2)',
	'autocreatewiki-step2-error' => 'Xa existe a base de datos!',
	'autocreatewiki-step3-error' => 'Non se pode definir a información por defecto na base de datos!',
	'autocreatewiki-step6-error' => 'Non se poden definir as táboas por defecto na base de datos!',
	'autocreatewiki-step7-error' => 'Non se pode copiar o iniciador da base de datos para esta lingua!',
	'autocreatewiki-protect-reason' => 'Parte da interface oficial',
	'autocreatewiki-welcomesubject' => 'Creouse $1!',
	'autocreatewiki-welcomebody' => 'Boas, $2!

Creouse o seu wiki! Bótelle unha ollada: <$1>.

Está preparado para comezar? Vimos de engadir algunhas ligazóns na súa páxina de conversa (<$5>) para axudalo a dar os primeiros pasos e animalo a explorar as numerosas zonas útiles de Wikia. Se ten algunha pregunta ou está perdido, responda este correo ou vaia a algunha das nosas páxinas de axuda <http://help.wikia.com>.

Tamén pode consultar o blogue dos fundadores e administradores <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e o do persoal de Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> para atopar consellos e trucos, información sobre as novas características e novas sobre todo o que acontece en Wikia.

Que o pase ben editando!

$3
O equipo comunitario de Wikia
<http://www.wikia.com/wiki/User:$4>

___________________________________________
* Quere recibir menos mensaxes da nosa parte? Pode cancelar a súa subscrición ou cambiar as súas preferencias de correo electrónico aquí: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Reciba a nosa benvida!',
	'autocreatewiki-welcometalk-wall' => 'Ola! Estamos encantados de que {{subst:SITENAME}} sexa parte da comunidade de Wikia!

Aínda hai moito por facer, así que aquí hai algúns consellos e ligazóns para comezar a darlle un pulo ao seu wiki:
*Consulte as [[Special:WikiFeatures|características do wiki]] para ollar as características que pode activar no seu wiki, incluído o chat, os logros e moitas outras cousas.
*Explore a [[w:c:community|central da comunidade]] para informarse a través do [[w:c:community:Blog:Wikia_Staff_Blog|blogue do persoal]], facer preguntas no noso [[w:c:community:Special:Forum|foro comunitario]], participar na nosa [[w:c:community:Help:Webinars|serie webinar]] ou conversar en tempo real con outros compañeiros de Wikia.
*Por último, visite as nosas [[Help:Contents|páxinas de axuda]] para aprender os pormenores de Wikia.

Todas as ligazóns anteriores son magníficos lugares para comezar a explorar Wikia e divertirse!',
	'autocreatewiki-welcometalk' => '==Reciba a nosa benvida!==
Ola!

Estamos encantados de que $4 sexa parte da comunidade de Wikia! Aínda hai moito por facer, así que aquí hai algúns consellos e ligazóns para comezar a darlle un pulo ao seu wiki:

*Consulte as [[Special:WikiFeatures|características do wiki]] para ollar as características que pode activar no seu wiki, incluído o chat, os logros e moitas outras cousas.
*Explore a [[w:c:community|central da comunidade]] para informarse a través do [[w:c:community:Blog:Wikia_Staff_Blog|blogue do persoal]], facer preguntas no noso [[w:c:community:Special:Forum|foro comunitario]], participar na nosa [[w:c:community:Help:Webinars|serie webinar]] ou conversar en tempo real con outros compañeiros de Wikia.
*Por último, visite as nosas [[Help:Contents|páxinas de axuda]] para aprender os pormenores de Wikia.

Todas as ligazóns anteriores son magníficos lugares para comezar a explorar Wikia e divertirse!

-- [[User:$2|$3]] <staff />',
);

/** Hebrew (עברית)
 * @author 0ftal
 * @author פדיחה
 */
$messages['he'] = array(
	'autocreatewiki' => 'צור אתר וויקי חדש',
	'autocreatewiki-desc' => 'צור אתר ווקי במפעל הווקי עם הגדרות משתמש',
	'autocreatewiki-page-title-default' => 'צור אתר וויקי חדש',
	'createwiki' => 'צור אתר וויקי חדש',
	'autocreatewiki-chooseone' => 'בחר אחד',
	'autocreatewiki-required' => '1$ = חובה',
	'autocreatewiki-web-address' => 'כתובת האינטרנט:',
	'autocreatewiki-category-select' => 'בחר אחד',
	'autocreatewiki-language-top' => '$1 השפות המובילות',
	'autocreatewiki-language-all' => 'כל השפות',
	'autocreatewiki-remember' => 'זכור אותי',
	'autocreatewiki-create-account' => 'יצירת חשבון',
	'autocreatewiki-haveaccount-question' => 'האם יש לך כבר חשבון בוויקיה?',
	'autocreatewiki-info-domain' => 'כדאי להשתמש במילה שהיא מילת מפתח לחיפוש הנושא שלך.',
	'autocreatewiki-info-topic' => 'הוסף תיאור קצר כגון "מלחמת הכוכבים" או "תוכניות טלוויזיה".',
	'autocreatewiki-info-language' => 'זו תהיה שפת ברירת המחדל עבור המבקרים בוויקי שלך.',
	'autocreatewiki-info-email-address' => 'כתובת הדוא"ל שלך נשמרת בסודיות ואף אחד לא יכול לראותה.',
	'autocreatewiki-info-realname' => 'את תבחרו לציין אותו, הוא ישמש לייחוס עבודתכם אליכם.',
	'autocreatewiki-category-label' => 'קטגוריה:',
);

/** Hindi (हिन्दी)
 * @author Kush rohra
 */
$messages['hi'] = array(
	'autocreatewiki' => 'बनाएँ एक नई wiki',
	'autocreatewiki-desc' => 'Wiki में WikiFactory उपयोगकर्ता का अनुरोध बनाएँ',
	'autocreatewiki-page-title-default' => 'बनाएँ एक नई wiki',
	'autocreatewiki-page-title-answers' => 'एक नए जवाब साइट बनाएँ',
	'createwiki' => 'बनाएँ एक नई wiki',
	'autocreatewiki-chooseone' => 'एक को चुनें',
	'autocreatewiki-required' => '$1 =
चाहा हुआ',
	'autocreatewiki-web-address' => 'आईपी पता:',
	'autocreatewiki-category-select' => 'एक का चयन करें',
	'autocreatewiki-language-top' => 'शीर्ष  $1  भाषाएँ',
	'autocreatewiki-language-all' => 'सर्रि भाषा',
	'autocreatewiki-remember' => 'मुझ याअद रख्न',
	'autocreatewiki-create-account' => 'अप्न खत बनयिय',
	'autocreatewiki-haveaccount-question' => 'क्य अप्क्के पस्स Wikia का खता हे',
	'autocreatewiki-info-domain' => 'यह अपने विषय के लिए एक खोज खोजशब्द होने की संभावना एक शब्द का उपयोग करने के लिए सबसे अच्छा है।',
	'autocreatewiki-info-category-default' => 'यह मिल अपने wiki आगंतुकों में मदद मिलेगी।',
	'autocreatewiki-info-category-answers' => 'एक छोटी "स्टार वार्स" या "टीवी शो" जैसे विवरण जोड़ें.',
	'autocreatewiki-info-email-address' => 'अपना ईमेल पता कभी नहीं Wikia पर किसी को भी दिखाया गया है।',
	'autocreatewiki-info-blurry-word' => 'स्वचालित खाता निर्माण के खिलाफ की रक्षा में मदद करने के लिए, कृपया इस फ़ील्ड में blurry शब्द है कि आप देखें लिखें।',
	'autocreatewiki-title-template' => '$1 विकि',
);

/** Hungarian (magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author TK-999
 */
$messages['hu'] = array(
	'autocreatewiki' => 'Új wiki létrehozása',
	'autocreatewiki-desc' => 'Új wiki létrehozása a Wikigyárban a felhasználói kérések alapján',
	'autocreatewiki-page-title-default' => 'Új wiki létrehozása',
	'createwiki' => 'Új wiki létrehozása',
	'autocreatewiki-chooseone' => 'Válassz egyet',
	'autocreatewiki-required' => '$1 = kötelező',
	'autocreatewiki-web-address' => 'Webcím:',
	'autocreatewiki-category-select' => 'Válassz egyet',
	'autocreatewiki-language-top' => 'Top $1 nyelv',
	'autocreatewiki-language-all' => 'Összes nyelv',
	'autocreatewiki-remember' => 'Emlékezzen rám',
	'autocreatewiki-create-account' => 'Fiók létrehozása',
	'autocreatewiki-haveaccount-question' => 'Már van Wikia-fiókod?',
	'autocreatewiki-info-domain' => 'A legcélszerűbb a wikidhez kapcsolódó potenciális keresési kulcsszó beállítása.',
	'autocreatewiki-info-topic' => 'Adj meg egy rövid leírást, például „Star Wars” vagy „TV-műsorok”.',
	'autocreatewiki-info-category-default' => 'Ez segít a látogatóknak a wikid megtalálásában.',
	'autocreatewiki-info-language' => 'Ez lesz a wikid alapértelmezett nyelve a látogatóid számára.',
	'autocreatewiki-info-email-address' => 'Az e-mail címedet sosem mutatjuk meg senkinek a Wikián.',
	'autocreatewiki-info-realname' => 'Ha megadod, ezen a néven leszel jelölve szerzőként a munkáidnál.',
	'autocreatewiki-info-birthdate' => 'A Wikia megköveteli valós születési dátumuk megadását minden felhasználótól elővigyázatosságból, a webhely egységességének megőrzése végett, valamint a szövetségi előírásoknak való megfelelés céljából.',
	'autocreatewiki-info-blurry-word' => 'Az automatizált fióklétrehozás elleni védelem részeként kérjük, hogy írja be a fenti elmosódott szót ebbe a mezőbe.',
	'autocreatewiki-info-terms-agree' => 'A wiki és a felhasználói fiók létrehozásával Ön elfogadja a Wikia <a href="http://www.wikia.com/wiki/Terms_of_Use">felhasználói feltételeit</a>.',
	'autocreatewiki-info-staff-username' => '<b>Csak személyzet:</b> A megadott felhasználó lesz feltüntetve alapítóként.',
	'autocreatewiki-title-template' => '$1-wiki',
	'autocreatewiki-limit-day' => 'A Wikia elérte a ma létrehozható wikik számának maximumát ($1).',
	'autocreatewiki-limit-creation' => 'Túllépted a 24 óra alatt létrehozható wikik maximumát ($1).',
	'autocreatewiki-empty-field' => 'Kérjük, töltse ki ezt a mezőt.',
	'autocreatewiki-bad-name' => 'A felhasználónév nem tartalmazhat különleges karaktereket (pl. $ vagy @) és egy kisbetűs, szóköz nélküli szóból kell állnia.',
	'autocreatewiki-invalid-wikiname' => 'A név nem tartalmazhat speciális karaktereket (például @ vagy $), és nem lehet üres.',
	'autocreatewiki-violate-policy' => 'Ez a wiki-név az elnevezési feltételeinket sértő szót tartalmaz.',
	'autocreatewiki-name-taken' => 'Már található egy wiki ezen a címen. Kezdj el szerkeszteni a <a href="http://$1.wikia.com">http://$1.wikia.com</a> oldalon, vagy válassz egy másik címet.',
	'autocreatewiki-name-too-short' => 'Ez a cím túl rövid, legalább 3 betűset kell választanod.',
	'autocreatewiki-name-too-long' => 'Ez a cím túl hosszú; kérünk, legfeljebb 50 karakteres címet válassz.',
	'autocreatewiki-similar-wikis' => 'Alább láthatók a témába vágó, már létező wikik. Javasoljuk, hogy ezek valamelyiké(i)t szerkeszd.',
	'autocreatewiki-invalid-username' => 'Ez a felhasználónév érvénytelen.',
	'autocreatewiki-busy-username' => 'Ez a felhasználónév már foglalt.',
	'autocreatewiki-blocked-username' => 'Nem hozhatsz létre fiókot.',
	'autocreatewiki-user-notloggedin' => 'A fiók létrejött, de nem lett bejelentkeztetve!',
	'autocreatewiki-empty-language' => 'Válassz nyelvet a wikinek!',
	'autocreatewiki-empty-category' => 'Válassz egy kategóriát.',
	'autocreatewiki-empty-wikiname' => 'A wiki neve nem maradhat üresen.',
	'autocreatewiki-empty-username' => 'A felhasználónév nem maradhat üresen.',
	'autocreatewiki-empty-password' => 'A jelszó nem maradhat üresen.',
	'autocreatewiki-empty-retype-password' => 'A megismételt jelszó nem maradhat üresen.',
	'autocreatewiki-category-label' => 'Kategória:',
	'autocreatewiki-category-other' => 'Egyéb',
	'autocreatewiki-set-username' => 'Először add meg a felhasználónevet!',
	'autocreatewiki-invalid-category' => 'A kategória értéke érvénytelen.
Kérünk, válassz egy megfelelőt a legördülő listából.',
	'autocreatewiki-invalid-language' => 'Érvénytelen nyelvbeállítás.
Kérünk, válassz egy megfelelőt a legördülő listából.',
	'autocreatewiki-invalid-retype-passwd' => 'Írd be újra a fenti jelszót.',
	'autocreatewiki-invalid-birthday' => 'Érvénytelen születési dátum',
	'autocreatewiki-log-title' => 'A wiki létrehozása folyamatban van',
	'autocreatewiki-step0' => 'Folyamat inicializálása ...',
	'autocreatewiki-stepdefault' => 'A folyamat fut, kérlek várj ...',
	'autocreatewiki-errordefault' => 'A folyamat nem fejeződött be ...',
	'autocreatewiki-step1' => 'Képek mappájának létrehozása ...',
	'autocreatewiki-step2' => 'Adatbázis létrehozása…',
	'autocreatewiki-step3' => 'Adatbázis feltöltése az alapértelmezett információkkal ...',
	'autocreatewiki-step4' => 'Alapértelmezett logó és képek másolása ...',
	'autocreatewiki-step5' => 'Alapértelmezett változók beállítása az adatbázisban ...',
	'autocreatewiki-step6' => 'Az adatbázis alapértelmezett tábláinak beállítása ...',
	'autocreatewiki-step7' => 'Induló nyelv beállítása ...',
	'autocreatewiki-step8' => 'Felhasználói csoportok és kategóriák beállítása ...',
	'autocreatewiki-step9' => 'Az új wiki változónak beállítása ...',
	'autocreatewiki-step10' => 'Oldalak beállítása a központi wikin ...',
	'autocreatewiki-step11' => 'E-nail küldése a felhasználónak ...',
	'autocreatewiki-redirect' => 'Átirányítás az új wikihez: $1',
	'autocreatewiki-congratulation' => 'Gratulálunk!',
	'autocreatewiki-welcometalk-log' => 'Üdvözlő üzenet',
	'autocreatewiki-regex-error-comment' => 'már használt az $1 wikin (teljes szöveg: $2)',
	'autocreatewiki-step2-error' => 'Az adatbázis létezik!',
	'autocreatewiki-step3-error' => 'Nem sikerült beállítani az alapértelmezett információkat az adatbázisban!',
	'autocreatewiki-step6-error' => 'Nem sikerült létrehozni az alapértelmezett táblákat az adatbázisban!',
	'autocreatewiki-step7-error' => 'Nem tudunk kezdő adatbázist másolni a kiválasztott nyelven.',
	'autocreatewiki-protect-reason' => 'A hivatalos felölet része',
	'autocreatewiki-welcomesubject' => '$1 elkészült!',
	'autocreatewiki-welcomebody' => 'Szia, $2!

Létrehoztuk a wikidet! Tekintsd meg: <$1>

Készen állsz az indulásra? Néhány hivatkozást helyeztünk el a vitalapodon, (<$5>) hogy segítsünk az elkezdésben és a Wikia sok hasznos zugának bebarangolására buzdítsunk. Ha valamilyen kérdésed van, vagy elveszettnek érzed magad, válaszolj erre az e-mailre vagy nézz körül a segítő oldalaink közt <http://help.wikia.com>.

Szintén megnézheted a Founder & Admin blogot <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> és a Wikia személyzet blogját <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> ahol tippeket és trükköket gyűjthetsz, továbbá információt szerezhetsz a Wikia friss eseményeiről és új szolgáltatásairól.

Jó szerkesutést!

$3
Wikia közösségi támogatás
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Kevesebb üzenetet szeretnél kapni tőlünk? Itt leiratkozhatsz vagy megváltoztathatod az e-mailekre vonatkozó beállításaidat: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk' => "== Üdv! ==
<div style=\"font-size:120%; line-height:1.2em;\">Szia \$1! &mdash; Örülünk, hogy a(z) '''\$4''' a Wikia közösség része lett!

Most már van egy egész weboldalad, melyet teletölthetsz információval, képekkel és videókkal a kedvenc témádról. De még csak üres lapok néznek vissza rád... Félelmetes, igaz? Itt van néhány módszer az induláshoz.

* '''Mutasd be a témát''' a főoldalon. Ez a lehetőséged, hogy elmagyarázd a témád részleteit az olvasóidnak. Írj annyit, amennyit csak akarsz! A leírásod akár a wikid összes fontos oldalára is hivatkozhat.
* '''Hozz létre néhány új oldalt''' &mdash; egy két mondat is elég a kezdéshez. Ne hagyd, hogy az üres oldal hipnotizáljon! Egy wiki lényege a dolgok állandó hozzáadása és változtatása. Képeket és videókat is beszúrhatsz, hogy kitöltsd és érdekesebbé tedd az oldalt.

Aztán csak menj tovább! Az emberek akkor látogatják a wikiket, ha sok olvasnivaló és megnézendő dolog van, úgyhogy a tartalom folyamatos növelésével olvasókat és szerkesztőket fogsz szerezni. Sok mindent kell tenned, de ne aggódj&mdash;a mai az első napod és rengeteg időd van. Minden wiki ugyanúgy indul&mdash;egyszerre egy kicsi, az első néhány oldal, aztán hatalmas, nyüzsgő wiki lesz belőle.

Ha kérdéseid vannak, küldhetsz nekünk e-mailt a [[Special:Contact|kapcsolatfelvételi űrlap]] segítségével. Jó szórakozást!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'autocreatewiki' => 'Crear un nove wiki',
	'autocreatewiki-desc' => 'Crear wiki in WikiFactory per requestas de usatores',
	'autocreatewiki-page-title-default' => 'Crear un nove wiki',
	'autocreatewiki-page-title-answers' => 'Crear un nove sito de responsas',
	'createwiki' => 'Crear un nove wiki',
	'autocreatewiki-chooseone' => 'Selige un',
	'autocreatewiki-required' => '$1 = requirite',
	'autocreatewiki-web-address' => 'Adresse web:',
	'autocreatewiki-category-select' => 'Selige un',
	'autocreatewiki-language-top' => 'Le $1 linguas le plus usate',
	'autocreatewiki-language-all' => 'Tote le linguas',
	'autocreatewiki-remember' => 'Memorar me',
	'autocreatewiki-create-account' => 'Crear un conto',
	'autocreatewiki-haveaccount-question' => 'Ha tu ja un conto Wiki?',
	'autocreatewiki-info-domain' => 'Es recommendate usar un parola susceptibile de esser cercate pro tu topico.',
	'autocreatewiki-info-topic' => 'Adde un breve description como "Star Wars" o "Series de TV".',
	'autocreatewiki-info-category-default' => 'Isto adjutara le visitatores a trovar tu wiki.',
	'autocreatewiki-info-category-answers' => 'Isto adjutara le visitatores a trovar tu sito de responsas.',
	'autocreatewiki-info-language' => 'Iste essera le lingua predefinite pro le visitatores de tu wiki.',
	'autocreatewiki-info-email-address' => 'Tu adresse de e-mail nunquam es monstrate a alcuno in Wikia.',
	'autocreatewiki-info-realname' => 'Si tu opta pro dar lo, illo essera usate pro dar te attribution pro tu contributiones.',
	'autocreatewiki-info-birthdate' => 'Wikia require que tote le usatores forni lor real data de nascentia como mesura de securitate e como medio de preservar le integritate del sito in conformitate con le regulationes federal statounitese.',
	'autocreatewiki-info-blurry-word' => 'Pro adjutar a proteger le sito contra le creation automatic de contos, per favor entra in iste campo le parola brumose que tu vide.',
	'autocreatewiki-info-terms-agree' => 'Per crear un wiki e un conto de usator, tu accepta le <a href="http://www.wikia.com/wiki/Terms_of_use">conditiones de uso de Wikia</a>.',
	'autocreatewiki-info-staff-username' => '<b>Personal solmente:</b> Le usator specificate essera listate qua fundator.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => 'Wikia ha excedite le limite de creation de nove wikis pro hodie ($1).',
	'autocreatewiki-limit-creation' => 'Tu ha excedite le numero de wikis que tu pote crear durante 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Per favor completa iste campo.',
	'autocreatewiki-bad-name' => 'Le nomine non pote continer characteres special (como $ o @) e debe esser un sol parola in minusculas e sin spatios.',
	'autocreatewiki-invalid-wikiname' => 'Le nomine non pote continer characteres special (como $ o @) e non pote esser vacue.',
	'autocreatewiki-violate-policy' => 'Iste nomine de wiki contine un parola que viola nostre politica de nomines.',
	'autocreatewiki-name-taken' => 'Un wiki con iste adresse ja existe. Participa in illo a <a href="http://$1.wikia.com">http://$1.wikia.com</a> o selige un altere adresse.',
	'autocreatewiki-name-too-short' => 'Iste adresse es troppo curte. Selige un adresse con al minus 3 characteres.',
	'autocreatewiki-name-too-long' => 'Iste addresse es troppo longe. Per favor selige un addresse con al plus 50 characteres.',
	'autocreatewiki-similar-wikis' => 'Ecce le wikis ja existente super iste thema. Nos suggere participar in un de illos.',
	'autocreatewiki-invalid-username' => 'Iste nomine de usator es invalide.',
	'autocreatewiki-busy-username' => 'Iste nomine de usator es ja in uso.',
	'autocreatewiki-blocked-username' => 'Tu non pote crear un conto.',
	'autocreatewiki-user-notloggedin' => 'Tu conto ha essite create ma le apertura del session non ha succedite!',
	'autocreatewiki-empty-language' => 'Per favor selige le lingua del wiki.',
	'autocreatewiki-empty-category' => 'Per favor selige un del categorias.',
	'autocreatewiki-empty-wikiname' => 'Le nomine del wiki non pote esser vacue.',
	'autocreatewiki-empty-username' => 'Le nomine de usator non pote esser vacue.',
	'autocreatewiki-empty-password' => 'Le contrasigno non pote esser vacue.',
	'autocreatewiki-empty-retype-password' => 'Le contrasigno repetite non pote esser vacue.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Altere',
	'autocreatewiki-set-username' => 'Defini primo le nomine de usator.',
	'autocreatewiki-invalid-category' => 'Valor invalide de categoria. Per favor selige un categoria del lista disrolante.',
	'autocreatewiki-invalid-language' => 'Valor invalide de lingua. Per favor selige un lingua del lista disrolante.',
	'autocreatewiki-invalid-retype-passwd' => 'Per favor repete le contrasigno entrate hic supra.',
	'autocreatewiki-invalid-birthday' => 'Data de nascentia invalide',
	'autocreatewiki-log-title' => 'Tu wiki es in curso de creation',
	'autocreatewiki-step0' => 'Initialisation del processo…',
	'autocreatewiki-stepdefault' => 'Le processo es in curso de execution, un momento…',
	'autocreatewiki-errordefault' => 'Le processo non ha finite…',
	'autocreatewiki-step1' => 'Creation del dossier de imagines…',
	'autocreatewiki-step2' => 'Creation del base de datos…',
	'autocreatewiki-step3' => 'Insertion del informationes predefinite in le base de datos…',
	'autocreatewiki-step4' => 'Copia del imagines predefinite e del logotypo…',
	'autocreatewiki-step5' => 'Configuration del variabiles predefinite in le base de datos…',
	'autocreatewiki-step6' => 'Configuration del tabellas predefinite in le base de datos…',
	'autocreatewiki-step7' => 'Configuration del initiator de lingua…',
	'autocreatewiki-step8' => 'Configuration del gruppos de usator e del categorias…',
	'autocreatewiki-step9' => 'Configuration del variabiles del nove wiki…',
	'autocreatewiki-step10' => 'Insertion de paginas in Wiki central…',
	'autocreatewiki-step11' => 'Invio de e-mail al usator…',
	'autocreatewiki-redirect' => 'Redirection verso le nove Wiki: $1…',
	'autocreatewiki-congratulation' => 'Felicitationes!',
	'autocreatewiki-welcometalk-log' => 'Message de benvenita',
	'autocreatewiki-regex-error-comment' => 'usate in le wiki $1 (texto complete: $2)',
	'autocreatewiki-step2-error' => 'Le base de datos existe!',
	'autocreatewiki-step3-error' => 'Impossibile inserer le informationes predefinite in le base de datos!',
	'autocreatewiki-step6-error' => 'Impossibile inserer le tabellas predefinite in le base de datos!',
	'autocreatewiki-step7-error' => 'Impossibile copiar le base de datos initial pro le lingua!',
	'autocreatewiki-protect-reason' => 'Parte del interfacie official',
	'autocreatewiki-welcomesubject' => '$1 ha essite create!',
	'autocreatewiki-welcomebody' => 'Salute $2!

Tu wiki ha essite create! Jecta un oculo: <$1>

Preste a comenciar? Nos ha addite alcun ligamines a tu pagina de discussion personal (<$5>) pro adjutar te a comenciar e pro incoragiar te a explorar le multitude de areas utile in Wikia. Si tu ha questiones o si tu te senti un poco perdite, responde a iste message o lege nostre paginas de adjuta <http://help.wikia.com>.

Tu pote etiam leger le blog de nostre fundatores e administratores <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e le blog del personal de Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> ubi se trova consilios e trucos, information sur nove functionalitate e evenimentos recente a Wikia.

Bon fortuna con le projecto!

$3
Le equipa communitari de Wikia
<http://www.wikia.com/wiki/User:$4>

___________________________________________
* Vole reciper minus messages de nos? Tu pote disabonar te o cambiar tu preferentias de e-mail hic: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk' => "== Benvenite! ==
<div style=\"font-size:120%; line-height:1.2em;\">Salute \$1 -- nos es felice de haber '''\$4''' como parte del communitate de Wikia!

Ora tu ha un tote sito web a impler con informationes, imagines e videos super tu thema favorite. Ma in iste momento, illo consiste solmente de paginas vacue… Intimidante, nonne? Ecce alcun modos de comenciar.

* '''Introduce tu thema''' in le pagina principal. Prende le opportunitate de exponer a tu lectores le essentiales de tu thema. Scribe tanto como tu vole! Le description pote continer ligamines a tote le paginas importante in tu sito.

* '''Comencia nove paginas'''. Non es un problema comenciar con un phrase o duo. Non lassa le pagina vacue intimidar te! In un wiki, il es normal adder e modificar le paginas in modo ad hoc. Tu pote tamben adder imagines e videos, pro completar le pagina e render lo plus interessante.

E postea simplemente continua! Un wiki attractive ha multe cosas a leger e reguardar, dunque continua a adder cosas e tu attrahera lectores e contributores. Il ha multo a facer, ma non te inquieta; hodie es le prime die, e tu ha multe tempore. Omne wiki comencia del mesme modo; pauco a pauco, comenciante con le prime pauc paginas, crescente e transformante se in un grande sito ben frequentate.

Si tu ha questiones, invia nos e-mail per nostre [[Special:Contact|formulario de contacto]]. Bon divertimento!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author Farras
 * @author Irwangatot
 */
$messages['id'] = array(
	'autocreatewiki' => 'Buat wiki baru',
	'autocreatewiki-desc' => 'Buat wiki di WikiFactory dari permintaan pengguna',
	'autocreatewiki-page-title-default' => 'Membuat wiki baru',
	'autocreatewiki-page-title-answers' => 'Buat situs Answers baru',
	'createwiki' => 'Buat wiki baru',
	'autocreatewiki-chooseone' => 'Pilih salah satu',
	'autocreatewiki-required' => '$1 = dibutuhkan',
	'autocreatewiki-web-address' => 'Alamat web:',
	'autocreatewiki-category-select' => 'Pilih salah satu',
	'autocreatewiki-language-top' => '$1 bahasa teratas',
	'autocreatewiki-language-all' => 'Semua bahasa',
	'autocreatewiki-remember' => 'Ingat saya',
	'autocreatewiki-create-account' => 'Buat akun',
	'autocreatewiki-haveaccount-question' => 'Apakah anda sudah memiliki akun Wikia?',
	'autocreatewiki-info-domain' => 'Lebih baik menggunakan kata kunci pencarian paling digemari sebagai  topik anda.',
	'autocreatewiki-info-topic' => 'Tambahkan penjelasan singkat seperti "Star Wars" atau "Acara TV".',
	'autocreatewiki-info-category-default' => 'Hal ini akan membantu pengunjung menemukan wiki Anda.',
	'autocreatewiki-info-category-answers' => 'Hal ini akan membantu pengunjung menemukan situs Answers anda.',
	'autocreatewiki-info-language' => 'Ini akan menjadi bahasa baku untuk pengunjung ke wiki Anda.',
	'autocreatewiki-info-email-address' => 'Alamat surat elektronik Anda tidak pernah ditunjukkan kepada siapa pun di Wikia.',
	'autocreatewiki-info-realname' => 'Jika anda memilih menyediakan ini akan di gunakan  untuk memberi pengenalan atas hasil kerja Anda.',
	'autocreatewiki-info-birthdate' => 'Wikia mengharuskan semua pengguna untuk memberikan tanggal lahir nyata mereka sebagai tindakan pencegahan keamanan dan sebagai cara untuk menjaga integritas dari situs ini sekaligus mematuhi peraturan federal.',
	'autocreatewiki-info-blurry-word' => 'Untuk membantu melindungi terhadap pembuatan akun otomatis, silahkan ketik kata buram yang Anda lihat ke dalam bidang ini.',
	'autocreatewiki-info-terms-agree' => 'Dengan membuat wiki dan akun pengguna,Anda setuju dengan <a href="http://www.wikia.com/wiki/Terms_of_use">Syarat Penggunaan Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Hanya staf:</b> Pengguna yang ditetapkan  akan terdaftar sebagai pendiri.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia telah melampaui jumlah maksimum pembuatan wiki hari ini ($1).',
	'autocreatewiki-limit-creation' => 'Anda telah melebihi jumlah maksimum pembuatan wiki dalam 24 jam ($1).',
	'autocreatewiki-empty-field' => 'Silakan isi bagian ini.',
	'autocreatewiki-bad-name' => 'Nama tidak boleh berisi karakter khusus (seperti $ atau @) dan harus satu kata dalam huruf kecil tanpa spasi .',
	'autocreatewiki-invalid-wikiname' => 'Nama tidak boleh berisi karakter khusus (seperti $ atau @) dan tidak boleh kosong',
	'autocreatewiki-violate-policy' => 'Nama wiki ini berisi kata yang melanggar kebijakan penamaan kami',
	'autocreatewiki-name-taken' => 'Wiki dengan nama ini sudah ada. Anda dipersilakan untuk bergabung dengan kami di <a href="http://$1.wikia.com">http:// $1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Nama ini terlalu pendek. Silakan pilih nama setidaknya memiliki 3 karakter.',
	'autocreatewiki-name-too-long' => 'Nama ini terlalu panjang. Silakan pilih nama maksimal 50 karakter.',
	'autocreatewiki-similar-wikis' => 'Di bawah ini adalah wiki yang sudah dibuat dengan topik ini. Kami menyarankan penyuntingan salah satu dari mereka.',
	'autocreatewiki-invalid-username' => 'Nama pengguna ini tidak sah.',
	'autocreatewiki-busy-username' => 'Nama pengguna ini sudah digunakan.',
	'autocreatewiki-blocked-username' => 'Anda tak dapat membuat Akun.',
	'autocreatewiki-user-notloggedin' => 'Akun anda telah dibuat tetapi belum masuk log!',
	'autocreatewiki-empty-language' => 'Silakan pilih bahasa untuk wiki.',
	'autocreatewiki-empty-category' => 'Silakan pilih salah satu kategori.',
	'autocreatewiki-empty-wikiname' => 'Nama wiki tidak boleh kosong.',
	'autocreatewiki-empty-username' => 'Nama pengguna tidak boleh kosong.',
	'autocreatewiki-empty-password' => 'Kata sandi tidak boleh kosong.',
	'autocreatewiki-empty-retype-password' => 'Kata sandi ulang tidak boleh kosong.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Lainnya',
	'autocreatewiki-set-username' => 'Atur nama pengguna lebih dulu.',
	'autocreatewiki-invalid-category' => 'Nilai tidak sah dari kategori.
Silakan pilih yang benar dari daftar pilihan.',
	'autocreatewiki-invalid-language' => 'Nilai tidak sah dari bahasa.
Silakan pilih yang benar dari daftar pilihan.',
	'autocreatewiki-invalid-retype-passwd' => 'Silahkan ketik kembali kata kunci yang sama seperti di atas',
	'autocreatewiki-invalid-birthday' => 'Tanggal lahir tidak sah',
	'autocreatewiki-log-title' => 'Wiki anda telah dibuat!',
	'autocreatewiki-step0' => 'Memulai proses ...',
	'autocreatewiki-stepdefault' => 'Proses berjalan, harap tunggu ...',
	'autocreatewiki-errordefault' => 'Proses belum selesai ...',
	'autocreatewiki-step1' => 'Membuat folder gambar ...',
	'autocreatewiki-step2' => 'Membuat basis data...',
	'autocreatewiki-step3' => 'Mengatur informasi baku dalam basis data...',
	'autocreatewiki-step4' => 'Menyalin gambar dan logo baku ...',
	'autocreatewiki-step5' => 'Pengaturan variabel baku dalam basis data ...',
	'autocreatewiki-step6' => 'Mengatur tabel baku dalam basis data...',
	'autocreatewiki-step7' => 'Menetapkan bahasa pemulai...',
	'autocreatewiki-step8' => 'Mengatur kelompok pengguna dan kategori ...',
	'autocreatewiki-step9' => 'Pengaturan variabel untuk wiki baru ...',
	'autocreatewiki-step10' => 'Mengatur halaman pada wiki pusat ...',
	'autocreatewiki-step11' => 'Mengirim surel ke pengguna ...',
	'autocreatewiki-redirect' => 'Pengalihan ke wiki baru: $1 ...',
	'autocreatewiki-congratulation' => 'Selamat!',
	'autocreatewiki-welcometalk-log' => 'Pesan Selamat Datang',
	'autocreatewiki-regex-error-comment' => 'digunakan dalam wiki $1 (semua teks: $2)',
	'autocreatewiki-step2-error' => 'Database ada!',
	'autocreatewiki-step3-error' => 'Tidak dapat mengatur informasi baku dalam basisdata!',
	'autocreatewiki-step6-error' => 'Dapat tidak menetapkan tabel baku dalam basisdata!',
	'autocreatewiki-step7-error' => 'Tidak dapat menyalin basisdata pemulai untuk bahasa!',
	'autocreatewiki-protect-reason' => 'Bagian dari antarmuka resmi',
	'autocreatewiki-welcomesubject' => '$1 telah dibuat!',
	'autocreatewiki-welcomebody' => 'Halo, $2,

Permintaan Wikia Anda sekarang tersedia di <$1> Kami berharap dapat melihat Anda meyunting disana segera!

Kami telah menambahkan beberapa Informasi dan Tips pada halaman Pembicaraan Pengguna Anda (<$5>) untuk membantu Anda memulai.

Jika Anda memiliki masalah, Anda dapat meminta bantuan komunitas di wiki di <http://www.wikia.com/wiki/Forum:Help_desk> , Atau melalui surel ke community@wikia.com. Anda juga dapat mengunjungi kami ruang obrolan IRC #wikia <http://irc.wikia.com> .

Saya dapat dihubungi langsung melalui email atau di halaman pembicaraan saya, jika Anda memiliki pertanyaan atau masalah.

Semoga berhasil dengan proyek ini!

$3

Tim Komunitas Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Selamat Datang! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hi \$1 -- kami sangat gembira untuk memiliki '''\$4''' sebagai bagian dari komunitas Wikia!

Sekarang Anda punya website secara utuh untuk diisi dengan informasi, gambar dan video tentang topik kesukaan Anda. Tapi sekarang, itu hanya halaman kosong mengunggu anda ... Menyeramkan, bukan? Berikut adalah beberapa cara untuk memulai.

*'''Mengenalkan topik Anda''' di halaman depan. Ini adalah kesempatan Anda untuk menjelaskan kepada pembaca tentang topik Anda. Menulis sebanyak yang Anda inginkan! deskripsi Anda dapat menghubungkan ke semua halaman yang penting di situs Anda.

*'''Mulai beberapa halaman baru''' - hanya satu atau dua kalimat baik untuk memulai. Jangan biarkan halaman kosong menunggu! Wiki adalah semua tentang menambah dan mengubah hal-hal selama Anda pergi. Anda juga dapat menambahkan gambar dan video, untuk mengisi halaman dan membuatnya lebih menarik.

Dan kemudian teruskan! Orang-orang senang mengunjungi wiki ketika ada banyak hal untuk dibaca dan dilihat, sehingga terus menambahkan hal-hal lain, dan Anda akan menarik pembaca dan penyunting. Ada banyak yang harus dilakukan, tapi jangan khawatir - hari ini hari pertama Anda, dan Anda punya banyak waktu. Setiap wiki dimulai dengan cara yang sama - sedikit demi sedikit, dimulai dengan beberapa halaman pertama, sampai tumbuh menjadi situs yang besar dan sibuk.

Jika Anda punya pertanyaan, Anda dapat mengirim kami sur-el melalui [[Special:Contact|formulir]]. Selamat bersenang-senang!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'autocreatewiki-category-select' => 'Kpàtá otụ',
	'autocreatewiki-category-label' => 'Ébéonọr:',
);

/** Ingush (ГӀалгӀай)
 * @author Sapral Mikail
 */
$messages['inh'] = array(
	'autocreatewiki-category-label' => 'Цатег:',
);

/** Italian (italiano)
 * @author Gianfranco
 * @author Gifh
 * @author Minerva Titani
 * @author Nemo bis
 * @author Ximo17
 */
$messages['it'] = array(
	'autocreatewiki' => 'Crea una nuova wikia',
	'autocreatewiki-desc' => "Crea una wikia in WikiFactory su richiesta dell'utente",
	'autocreatewiki-page-title-default' => 'Crea una nuova wikia',
	'autocreatewiki-page-title-answers' => 'Crea un nuovo sito di Wiki risposte',
	'createwiki' => 'Crea una nuova wikia',
	'autocreatewiki-chooseone' => 'Scegline una',
	'autocreatewiki-required' => '$1 = obbligatorio',
	'autocreatewiki-web-address' => 'Indirizzo web:',
	'autocreatewiki-category-select' => 'Scegline una',
	'autocreatewiki-language-top' => '$1 lingue principali',
	'autocreatewiki-language-all' => 'Tutte le lingue',
	'autocreatewiki-remember' => 'Ricordami',
	'autocreatewiki-create-account' => 'Crea un account',
	'autocreatewiki-haveaccount-question' => 'Hai già un account Wikia?',
	'autocreatewiki-info-domain' => 'È meglio usare una parola che sia una possibile parola chiave per le ricerche sul tuo argomento.',
	'autocreatewiki-info-topic' => 'Aggiungi una breve descrizione come "Guerre stellari" o "Spettacoli televisivi".',
	'autocreatewiki-info-category-default' => 'Aiuterà i visitatori a trovare la tua wikia.',
	'autocreatewiki-info-category-answers' => 'Aiuterà i visitatori a trovare il tuo sito di Wiki risposte.',
	'autocreatewiki-info-language' => 'Questa sarà la lingua di default per i visitatori della tua wikia.',
	'autocreatewiki-info-email-address' => 'Il tuo indirizzo email non viene mai mostrato agli utenti di Wikia.',
	'autocreatewiki-info-realname' => 'Se scegli di fornirlo, verrà usato per attribuirti il lavoro svolto.',
	'autocreatewiki-info-birthdate' => "Wikia richiede che tutti gli utenti forniscano la loro data di nascita effettiva, sia come misura di sicurezza sia come un modo per preservare l'integrità del sito nel rispetto delle regole federali.",
	'autocreatewiki-info-blurry-word' => 'Per aiutarci a contrastare la creazione automatica di account, inserisci la parola sfuocata che vedi in questo campo.',
	'autocreatewiki-info-terms-agree' => "Con la creazione di una wikia e di un account utente, accetti i {{#NewWindowLink: w:Terms of use | Wikia's Terms of Use}}",
	'autocreatewiki-info-staff-username' => "<b>Solo staff:</b> L'utente specificato verrà indicato come il fondatore.",
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Oggi Wikia ha superato il numero massimo di creazione di wikia ($1).',
	'autocreatewiki-limit-creation' => 'Hai superato il numero massimo di creazione di wikia in 24 ore ($1).',
	'autocreatewiki-empty-field' => 'Completa questo campo.',
	'autocreatewiki-bad-name' => 'Il nome non può contenere caratteri speciali (come $ o @) e deve essere una singola parola minuscola senza spazi.',
	'autocreatewiki-invalid-wikiname' => 'Il nome non può contenere caratteri speciali (come $ o @) e non può essere vuoto.',
	'autocreatewiki-violate-policy' => 'Il nome di questa wikia contiene una parola che viola la nostra politica di denominazione.',
	'autocreatewiki-name-taken' => 'C\'è già una wikia con questo indirizzo. Contribuisci a <a href="http://$1.wikia.com">http://$1.wikia.com</a> o scegli un altro indirizzo.',
	'autocreatewiki-name-too-short' => 'Questo indirizzo è troppo breve. Scegli un indirizzo di almeno 3 caratteri.',
	'autocreatewiki-name-too-long' => 'Questo indirizzo è troppo lungo. Scegli un indirizzo con un massimo di 50 caratteri.',
	'autocreatewiki-similar-wikis' => 'Di seguito trovi le wikia già create su questo argomento. Ti consigliamo di contribuire a una di queste.',
	'autocreatewiki-invalid-username' => 'Questo nome utente non è valido.',
	'autocreatewiki-busy-username' => 'Questo nome utente è già in uso.',
	'autocreatewiki-blocked-username' => 'Non puoi creare un account.',
	'autocreatewiki-user-notloggedin' => "Il tuo account è stato creato ma non hai eseguito l'accesso!",
	'autocreatewiki-empty-language' => 'Scegli la lingua per la wikia.',
	'autocreatewiki-empty-category' => 'Scegli una categoria.',
	'autocreatewiki-empty-wikiname' => 'Il nome della wiki non può essere vuoto.',
	'autocreatewiki-empty-username' => 'Il nome utente non può essere vuoto.',
	'autocreatewiki-empty-password' => 'La password non può essere vuota.',
	'autocreatewiki-empty-retype-password' => 'La ripetizione della password non può essere vuota.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Altro',
	'autocreatewiki-set-username' => 'Prima imposta il nome utente.',
	'autocreatewiki-invalid-category' => 'Categoria non valida.
Scegline una dal menu a comparsa.',
	'autocreatewiki-invalid-language' => 'Lingua non valida.
Scegline una dal menu a comparsa.',
	'autocreatewiki-invalid-retype-passwd' => 'Ripeti la stessa password di prima.',
	'autocreatewiki-invalid-birthday' => 'Data di nascita non valida',
	'autocreatewiki-log-title' => 'Stiamo creando la tua wiki',
	'autocreatewiki-step0' => 'Inizializzazione del processo...',
	'autocreatewiki-stepdefault' => 'Il processo è in corso, attendere prego...',
	'autocreatewiki-errordefault' => 'Il processo non è ancora completato...',
	'autocreatewiki-step1' => 'Creazione della cartella delle immagini...',
	'autocreatewiki-step2' => 'Creazione del database...',
	'autocreatewiki-step3' => 'Impostazione delle informazioni di default nel database...',
	'autocreatewiki-step4' => 'Copia delle immagini e del logo di default...',
	'autocreatewiki-step5' => 'Impostazione delle variabili di default nel database...',
	'autocreatewiki-step6' => 'Impostazione delle tabelle di default nel database...',
	'autocreatewiki-step7' => 'Impostazione dei dati iniziali della lingua...',
	'autocreatewiki-step8' => 'Impostazione dei gruppi utente e delle categorie...',
	'autocreatewiki-step9' => 'Impostazione delle variabili per la nuova wikia...',
	'autocreatewiki-step10' => 'Impostazione delle pagine nella wikia centrale...',
	'autocreatewiki-step11' => "Invio dell'email all'utente...",
	'autocreatewiki-redirect' => 'Reindirizzamento alla nuova wikia: $1...',
	'autocreatewiki-congratulation' => 'Congratulazioni!',
	'autocreatewiki-welcometalk-log' => 'Messaggio di benvenuto',
	'autocreatewiki-regex-error-comment' => 'usato nella wikia $1 (testo completo: $2)',
	'autocreatewiki-step2-error' => 'Il database esiste già!',
	'autocreatewiki-step3-error' => 'Impossibile impostare le informazioni di default nel database!',
	'autocreatewiki-step6-error' => 'Impossibile impostare le tabelle di default nel database!',
	'autocreatewiki-step7-error' => 'Impossibile copiare il database dei dati iniziali per la lingua!',
	'autocreatewiki-protect-reason' => "Parte dell'interfaccia ufficiale",
	'autocreatewiki-welcomesubject' => '$1 è stata creata!',
	'autocreatewiki-welcomebody' => 'Ciao, $2!

La tua wikia è stata creata. Puoi trovarla qui: <$1>

Ti va di cominciare? Abbiamo aggiunto alcuni link alla tua pagina di discussione (<$5>) per darti una mano e per incoraggiarti a esplorare tutte le aree di Wikia. Per qualunque domanda o problema, rispondi a questa email o consulta le nostre pagine di Aiuto <http://help.wikia.com>.

Puoi inoltre visitare il Blog degli amministratori
<http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e il blog dello staff di Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> dove troverai suggerimenti e trucchi, oltre alle info sulle novità di Wikia.

Buon lavoro!

$3

Supporto comunitario di Wikia
<http://www.wikia.com/wiki/User:$4>

___________________________________________
* Vuoi ricevere meno messaggi da noi? Puoi modificare le preferenze sulla ricezione delle email qui: http://community.wikia.com/Special:Preferences/it',
	'autocreatewiki-welcometalk-wall-title' => 'Ti diamo il benvenuto!',
	'autocreatewiki-welcometalk' => "==Ti diamo il benvenuto!==
Ciao!

Siamo molto contenti di avere $4 nella community di Wikia! C'è ancora molto da fare, perciò ti vogliamo dare alcuni suggerimenti e link utili per mettere in moto la tua wikia:

*Dai un'occhiata a [[Special:WikiFeatures|Wiki Funzioni]] per vedere le funzioni che puoi attivare sulla tua wikia, come Chat, Successi e molto altro.
*Fai un salto nella [[w:c:it.community|Wiki della Community]] per tenerti informato tramite il nostro [[w:c:it.community:Blog:Wikia_Staff_Blog|Blog ufficiale di Wikia Italia]], per fare delle domande nel [[w:c:it.community:Special:Forum|Forum della Community]], per partecipare ai nostri [[w:c:it.community:Help:Webinars|webinar]] o alla [[w:c:it:community:Special:Chat|chat]] con altri utenti di Wikia.
*Per finire, visita le nostre [[Help:Contents|pagine di aiuto]] per imparare al meglio come funziona Wikia.

Tutti questi link sono un buon punto di partenza per entrare nel mondo di Wikia e iniziare a divertirsi!

-- [[User:$2|$3]] <staff />",
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-welcometalk-wall' => "Ciao. Siamo molto contenti di avere {{subst:SITENAME}} nella community di Wikia!

C'è ancora molto da fare; perciò ti vogliamo dare alcuni suggerimenti e link utili per mettere in moto la tua wikia:
*Dai un'occhiata a [[Special:WikiFeatures|Wiki Funzioni]] per vedere le funzioni che puoi attivare sulla tua wikia, come Chat, Successi e molto altro.
*Personalizza l'aspetto della tua wikia tramite il [[Special:ThemeDesigner|Theme Designer]] che ti permette di cambiare il colore e lo stile del tuo sfondo e del tuo logo.
*Fai un salto nella [[w:c:it.community|Wiki della Community]] per tenerti informato tramite il nostro [[w:c:it.community:Blog:Wikia_Staff_Blog|Blog ufficiale di Wikia Italia]], per fare delle domande nel [[w:c:it.community:Special:Forum|Forum della Community]], per partecipare ai nostri [[w:c:it.community:Help:Webinars|webinar]] o alla [[w:c:it.community:Special:Chat|chat]] con altri utenti di Wikia.
*Per finire, visita le nostre [[Help:Contents|pagine di aiuto]] per imparare al meglio come funziona Wikia: per esempio, [[Help:New page|come aggiungere una pagina alla tua wikia]], [[Help:Attracting contributors|come attrarre nuovi utenti]] e [[Help:User access levels|come aggiungere altri amministratori]].
* Puoi anche usare tutti questi strumenti esplorando il tuo Pannello di controllo Admin che troverai cliccando su \"Pannello Admin\" nella barra degli strumenti in basso.

Tutti questi link sono un buon punto di partenza per entrare nel mondo di Wikia e iniziare a divertirsi!",
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Japanese (日本語)
 * @author Naohiro19
 * @author Shirayuki
 * @author Tommy6
 * @author 青子守歌
 */
$messages['ja'] = array(
	'autocreatewiki' => '新しいWikiaコミュニティを作成する',
	'autocreatewiki-desc' => 'ユーザーのリクエストにより、ウィキファクトリーにWikiaコミュニティを作成します',
	'autocreatewiki-page-title-default' => '新しいWikiaコミュニティを作成',
	'autocreatewiki-page-title-answers' => '新しいアンサーサイトの作成',
	'createwiki' => '新しいWikiaコミュニティを作成',
	'autocreatewiki-chooseone' => '1つを選択',
	'autocreatewiki-required' => '$1は必須です',
	'autocreatewiki-web-address' => 'URL：',
	'autocreatewiki-category-select' => '1つを選択',
	'autocreatewiki-language-top' => '上位$1の言語',
	'autocreatewiki-language-all' => 'すべての言語',
	'autocreatewiki-remember' => 'パスワードを記憶させる',
	'autocreatewiki-create-account' => 'アカウントを作成',
	'autocreatewiki-haveaccount-question' => '既にWikiaアカウントをお持ちですか？',
	'autocreatewiki-info-domain' => 'ここでは、トピックの検索キーワードとなるような言葉を入力してください。',
	'autocreatewiki-info-topic' => '「スター・ウォーズ」や「テレビ番組」など、簡単な説明を追加してください。',
	'autocreatewiki-info-category-default' => '他のユーザーがこのWikiaコミュニティを見つけやすくなるような紹介文を書いてください。',
	'autocreatewiki-info-category-answers' => 'あなたのアンサーサイトを見つかりやすくしましょう。',
	'autocreatewiki-info-language' => 'ここで選択した言語があなたのWikiaコミュニティのデフォルト言語となります。',
	'autocreatewiki-info-email-address' => 'あなたのメールアドレスがWikia上で誰かに表示されることはありません。',
	'autocreatewiki-info-realname' => '本名を入力すると、作者名を表示する際に使用されます。',
	'autocreatewiki-info-birthdate' => 'Wikiaでは、アメリカ合衆国の法規定に則り、サイトの品質維持および安全対策として、すべてのユーザーに対して生年月日の入力を必須としています。',
	'autocreatewiki-info-blurry-word' => 'ボットなどによるアカウントの自動作成を防ぐため、表示されている文字を入力してください。',
	'autocreatewiki-info-terms-agree' => 'Wikiaおよびユーザーアカウントを作成すると、{{#NewWindowLink: w:Terms of use | Wikiaの利用規約}}に同意したと見なされます。',
	'autocreatewiki-info-staff-username' => '<b>スタッフのみ：</b>指定されたユーザーが設立者として表示されます。',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => '1日にWikiaで作成可能なコミュニティの上限数（$1）を超えました。',
	'autocreatewiki-limit-creation' => '24時間以内に作成可能なコミュニティの上限数（$1）を超えました。',
	'autocreatewiki-empty-field' => 'この項目は必須です。',
	'autocreatewiki-bad-name' => 'アドレスは、半角英数字の小文字のみを使用してください。¥や@などの記号、スペースは使用できません。',
	'autocreatewiki-invalid-wikiname' => 'アドレスには、¥や@などの記号は使えません。また空欄にすることもできません。',
	'autocreatewiki-violate-policy' => 'このコミュニティ名には、Wikiaのポリシーに違反する単語が含まれています。',
	'autocreatewiki-name-taken' => 'このアドレスのWikiaコミュニティは既に存在します。まずは<a href="http://$1.wikia.com">http://$1.wikia.com</a> を見てみましょう。',
	'autocreatewiki-name-too-short' => 'アドレスが短すぎるようです。3文字以上のアドレスを指定してください。',
	'autocreatewiki-name-too-long' => 'アドレスが長すぎるようです。50文字以下のアドレスを指定してください。',
	'autocreatewiki-similar-wikis' => 'このトピックを扱っているWikiaには、以下ようなのものもあります。これらの編集もぜひご検討ください。',
	'autocreatewiki-invalid-username' => 'このユーザー名は無効です。',
	'autocreatewiki-busy-username' => 'このユーザー名は既に使用されています。別のものをお試しください。',
	'autocreatewiki-blocked-username' => 'アカウントを作成できません。',
	'autocreatewiki-user-notloggedin' => 'アカウントの作成は完了しています。ログインしてください。',
	'autocreatewiki-empty-language' => 'このWikiaコミュニティの言語を選択してください。',
	'autocreatewiki-empty-category' => 'カテゴリを選択してください。',
	'autocreatewiki-empty-wikiname' => 'Wikiaコミュニティ名は空欄にできません。',
	'autocreatewiki-empty-username' => 'ユーザー名を入力してください。',
	'autocreatewiki-empty-password' => 'パスワードは空白にできません。',
	'autocreatewiki-empty-retype-password' => 'パスワードの再入力は空白にできません。',
	'autocreatewiki-category-label' => 'カテゴリ：',
	'autocreatewiki-category-other' => 'その他',
	'autocreatewiki-set-username' => 'まずはユーザー名を指定してください。',
	'autocreatewiki-invalid-category' => 'カテゴリの値が無効です。
ドロップダウン・リストから適切なものを選択してください。',
	'autocreatewiki-invalid-language' => '言語の値が無効です。
ドロップダウン・リストから適切なものを選択してください。',
	'autocreatewiki-invalid-retype-passwd' => '上のパスワードを再入力してください。',
	'autocreatewiki-invalid-birthday' => '生年月日が不適切です。',
	'autocreatewiki-log-title' => 'あなたのWikiaコミュニティを作成中です',
	'autocreatewiki-step0' => 'プロセスを初期化しています...',
	'autocreatewiki-stepdefault' => 'プロセスを実行しています。少々お待ちください...',
	'autocreatewiki-errordefault' => 'プロセスを完了することができませんでした...',
	'autocreatewiki-step1' => '画像フォルダを作成しています...',
	'autocreatewiki-step2' => 'データベースを作成しています...',
	'autocreatewiki-step3' => 'データベースに初期情報を設定しています...',
	'autocreatewiki-step4' => '初期画像とロゴをコピーしています...',
	'autocreatewiki-step5' => 'データベースに初期変数を設定しています...',
	'autocreatewiki-step6' => 'データベースに初期テーブルを設定しています...',
	'autocreatewiki-step7' => '言語スターターを設定しています...',
	'autocreatewiki-step8' => 'ユーザーグループとカテゴリを設定しています...',
	'autocreatewiki-step9' => '新しいWikiaコミュニティの変数を設定しています...',
	'autocreatewiki-step10' => 'セントラルウィキにページを設置しています...',
	'autocreatewiki-step11' => 'ユーザーにメールを送信しています...',
	'autocreatewiki-redirect' => '新しいWikiaコミュニティ（$1）に転送しています...',
	'autocreatewiki-congratulation' => '完了しました！',
	'autocreatewiki-welcometalk-log' => 'ウェルカム・メッセージ',
	'autocreatewiki-regex-error-comment' => 'wikiaコミュニティ「$1」で使用されています（全文：$2）',
	'autocreatewiki-step2-error' => 'データベースは既に存在します。',
	'autocreatewiki-step3-error' => 'データベースに初期情報を設定できません。',
	'autocreatewiki-step6-error' => 'データベースに初期テーブルを設定できません。',
	'autocreatewiki-step7-error' => '言語スターターのデータベースをコピーできません。',
	'autocreatewiki-protect-reason' => '公式インターフェースの一部です。',
	'autocreatewiki-welcomesubject' => '「$1」の作成が完了しました！',
	'autocreatewiki-welcomebody' => '$2さん

この度は新しいWikiaコミュニティを作成していただきありがとうございます。早速<$1> をチェックしてみましょう！
トークページ（<$5>）にてリンクをいくつかご紹介しています。Wikiaの便利なツールなど、ご利用のヒントとしてご参照ください。その他ご不明な点がありましたら、このメールにご返信いただくか、ヘルプページ（<http://ja.community.wikia.com/wiki/ヘルプ:コンテンツ>）をご覧ください。

また、Wikiaのスタッフブログ（<http://ja.community.wikia.com/wiki/ブログ:ウィキアスタッフブログ>）も是非ともご覧ください。ご利用のヒント、新機能に関する情報、Wikiaの最新情報などをご紹介しています。

それでは、どうぞ編集をお楽しみください。

$3
Wikia コミュニティ・サポート
<http://ja.community.wikia.com/wiki/User:$4>

___________________________________________
* Wikiaから送信される通知について変更をご希望の場合は、こちらでご登録を解除するか、メール設定をご変更ください：http://ja.community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk' => '==ようこそ！==

この度は、Wikiaで「$4」を立ち上げていただきありがとうございます！こちらに、Wikiaコミュニティを盛り上げていくためのヒントやリンクをご紹介します。ぜひご参照ください。

*[[特別:WikiFeatures|ウィキ・フィーチャーズ]]で、あなたのWikiaコミュニティで有効にできる機能（チャット、アチーブメントなど）をチェックしてみよう！
*[[w:c:ja.communtiy|コミュニティ・セントラル]]の[[w:c:ja.communtiy:ブログ:ウィキアスタッフブログ|スタッフブログ]]で最新情報を入手したり、[[w:c:ja.communtiy:特別:Forum|コミュニティ・フォーラム]]で分からないことを質問してみよう！
*[[ヘルプ:コンテンツ|ヘルプページ]]で、ウィキアについての様々な記事を見つけてみよう！

このリンクを活用して、Wikiaをどんどんお楽しみください！

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-welcometalk-wall-title' => 'ようこそ！',
	'autocreatewiki-welcometalk-wall' => 'こんにちは！この度は、Wikiaで{{subst:SITENAME}}を立ち上げていただき、ありがとうございます！

こちらに、Wikiaコミュニティを盛り上げていくためのヒントやリンクをご紹介します。ぜひご参照ください。
*[[特別:WikiFeatures|ウィキ・フィーチャーズ]]で、あなたのWikiaコミュニティで有効にできる機能（チャット、アチーブメントなど）をチェックしてみよう！
*[[特別:ThemeDesigner|テーマデザイナー]]を使って、背景、ロゴ、色、スタイルなど、コミュニティのデザインをカスタマイズしてみよう！
*[[w:c:ja.communtiy|コミュニティ・セントラル]]の[[w:c:ja.communtiy:ブログ:ウィキアスタッフブログ|スタッフブログ]]で最新情報を入手したり、[[w:c:ja.communtiy:特別:Forum|コミュニティ・フォーラム]]で分からないことを質問してみよう！
*[[ヘルプ:コンテンツ|ヘルプページ]]で、[[ヘルプ:新規ページ|新規しいページを追加する方法]]、[[ヘルプ:コミュニティを作り上げる|コミュニティを作り上げる方法]]、[[ヘルプ:ユーザーアクセスレベル|管理者を追加する方法]]など、コミュニティについての様々な記事を見つけてみよう！
*管理者ダッシュボード（下部のツールバーの「管理作業」をクリック）で、上記のすべてのツールを見つけて使ってみよう！

このリンクを活用して、ウィキアをどんどんお楽しみください！',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'autocreatewiki' => 'បង្កើតវិគីថ្មីមួយ',
	'autocreatewiki-desc' => 'បង្កើតវិគីក្នុង WikiFactory តាមសំណើរបស់អ្នកប្រើប្រាស់',
	'autocreatewiki-page-title-default' => 'បង្កើតវិគីថ្មីមួយ',
	'createwiki' => 'បង្កើតវិគីថ្មីមួយ',
	'autocreatewiki-chooseone' => 'ជ្រើសរើសមួយ',
	'autocreatewiki-required' => '$1 = ចាំបាច់',
	'autocreatewiki-web-address' => 'អាសយដ្ឋានវិប៖',
	'autocreatewiki-category-select' => 'ជ្រើសរើសមួយ',
	'autocreatewiki-language-top' => 'ភាសាចំនួន $1 លើគេ',
	'autocreatewiki-language-all' => 'ភាសាទាំងអស់',
	'autocreatewiki-remember' => 'ចងចាំខ្ញុំ',
	'autocreatewiki-create-account' => 'បង្កើតគណនីមួយ',
	'autocreatewiki-haveaccount-question' => 'តើអ្នកមានគណនី Wikia មួយហើយឬនៅ?',
	'autocreatewiki-info-email-address' => 'អាសដ្ឋានអ៊ីមែលរបស់អ្នកនឹងមិនត្រូវបង្ហាញអោយនរណាម្នាក់ឃើញឡើយនៅលើ Wikia។',
	'autocreatewiki-info-realname' => ' បើអ្នកផ្ដល់ឱ្យ វានឹងត្រូវបានប្រើប្រាស់់ដើម្បីបញ្ជាក់ភាពជាម្ចាស់​លើការរួមចំណែក​នានា​របស់អ្នក។',
	'autocreatewiki-invalid-username' => 'អត្តនាមនេះគ្មានសុពលភាពទេ',
	'autocreatewiki-busy-username' => 'អត្តនាមនេះត្រូវបានគេយកប្រើហើយ។',
	'autocreatewiki-blocked-username' => 'មិនអាចបង្កើតគណនីបានទេ។',
	'autocreatewiki-user-notloggedin' => 'គណនីរបស់អ្នកត្រូវបានបង្កើត ប៉ុន្តែមិនទាន់បានកត់ឈ្មោះចូលទេ!',
	'autocreatewiki-empty-language' => 'សូមជ្រើសរើសភាសាសំរាប់វិគីនេះ។',
	'autocreatewiki-empty-category' => 'សូមជ្រើសរើសចំណាត់ថ្នាក់ក្រុមមួយ។',
	'autocreatewiki-empty-wikiname' => 'ឈ្មោះរបស់វិគីនេះមិនអាចនៅទទេបានទេ។',
	'autocreatewiki-empty-username' => 'អត្តនាមមិនអាចនៅទទេបានទេ។',
	'autocreatewiki-empty-password' => 'ពាក្យសំងាត់មិនអាចនៅទទេបានទេ។',
	'autocreatewiki-empty-retype-password' => 'ពាក្យសំងាត់វាយបញ្ចូលឡើងវិញមិនអាចនៅទទេបានទេ។',
	'autocreatewiki-category-label' => 'ចំណាត់ថ្នាក់ក្រុម៖',
	'autocreatewiki-category-other' => 'ផ្សេងទៀត',
	'autocreatewiki-set-username' => 'ដាក់អត្តនាមមុន។',
);

/** Korean (한국어)
 * @author Cafeinlove
 * @author 아라
 */
$messages['ko'] = array(
	'autocreatewiki' => '새 위키 만들기',
	'autocreatewiki-page-title-default' => '새 위키 만들기',
	'createwiki' => '새 위키 만들기',
	'autocreatewiki-language-all' => '모든 언어',
	'autocreatewiki-create-account' => '계정 만들기',
	'autocreatewiki-haveaccount-question' => '이미 위키아 계정이 있습니까?',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'autocreatewiki' => 'E neu Wiki opmaache',
	'autocreatewiki-desc' => 'Määt e neu Wiki en de Wiki_Fabrek wi ene Metmaacher et well.',
	'autocreatewiki-page-title-default' => 'E neu Wiki opmaache',
	'autocreatewiki-page-title-answers' => 'Maach en neu ẞait för Antwoote',
	'createwiki' => 'E neu Wiki opmaache',
	'autocreatewiki-chooseone' => 'Donn eine ußwähle',
	'autocreatewiki-required' => '$1 = nüüdesch',
	'autocreatewiki-web-address' => 'Web-Adräß:',
	'autocreatewiki-category-select' => 'Donn eine ußwähle',
	'autocreatewiki-language-top' => 'Bövverste $1 Shprooche
',
	'autocreatewiki-language-all' => 'All Schprooche',
	'autocreatewiki-remember' => 'Op Duur enlogge',
	'autocreatewiki-create-account' => 'Ene neue Metmaacher aanmelde',
	'autocreatewiki-haveaccount-question' => 'Häß De ald ene Zohjang op Wikia?',
	'autocreatewiki-info-domain' => 'Et beß nemm e Wood, wat jähn zom Söhke noh Dingem Teema jenumme weed.',
	'autocreatewiki-info-topic' => 'Et beß donn ene knackije, kloore Bejreff dobei, esu wi „kölsche Fasterleer“ udder „Färsesändonge“.',
	'autocreatewiki-info-category-default' => 'Dat hellef de Besöker, Ding Wiki ze fenge.',
	'autocreatewiki-info-category-answers' => 'Dat hellef de Besöker, Ding Antwoote-ẞait ze fenge.',
	'autocreatewiki-info-language' => 'Dat weet de standattmääßejje Shprooch för de Besöker vun Dingem Wiki.',
	'autocreatewiki-info-email-address' => 'Ding Adräß för de <i lang="en">e-mail</i> kritt nie Eine aanjezeish op Wikia.',
	'autocreatewiki-info-realname' => 'Dinge richtije Name kanns De fott looße — wann De en ävver nenne wells, dann weed dä jebruch, öm Ding Beidräch domet ze schmöcke.',
	'autocreatewiki-info-birthdate' => 'Wikia well vun alle Metmaacher et reshtije Jebootß_Dattum han, zor Sesherheid un och um sing ẞait iehre Zosammehalt ze schöze un dobei Vörschreffte vun de USA ze befollje.',
	'autocreatewiki-info-blurry-word' => 'Öm ons jääje automattesch aanjelaate Zohjäng nohm Wiki ze schöze,
wulle mer, dat De dat verwaggelt Woot, wat De heh sühß, en heh dat Feld entipps.',
	'autocreatewiki-info-terms-agree' => 'Mem Wiki Opmaache un mem Zohjang Aanlääje, deihß De automattesch dä <a href="http://www.wikia.com/wiki/Terms_of_use">Rääjelle un Bedengonge för Wikia ze benöze</a> zohshtemme.',
	'autocreatewiki-info-staff-username' => '<b>Bloß för et Päsonaal:</b> Dä aanjejovve Metmaacher weed als der Jrönder vum Wiki opjeföhrt.',
	'autocreatewiki-title-template' => 'Et $1 Wiki',
	'autocreatewiki-limit-day' => 'För hück es de zohjelohße Aanzahl Wikis op Wikia ald aanjelaat ($1)',
	'autocreatewiki-limit-creation' => 'Do häs de zohjelohße Aanzahl Wikis övverschredde, di mer en 24 Shtonde opmaache kann ($1)',
	'autocreatewiki-empty-field' => 'Bes esu jood, un föll dat Feld uß.',
	'autocreatewiki-bad-name' => 'En däm Name künne kein Sönderzeishe (wi $ udder @) sin, un dä moß e einzel Woot us kleine Boochshtaabe der ohne Zwescheräum sin.',
	'autocreatewiki-invalid-wikiname' => 'En däm Name künne kein Sönderzeishe (wi $ udder @) sin, un läddesch lohße jeiht och nit.',
	'autocreatewiki-violate-policy' => 'En däm name för et Wiki es e Woot, wat uns Rääjelle nit zohlohße.',
	'autocreatewiki-name-taken' => 'Et jitt ald e Wiki met dä Adräß. Jangk op <a href="http://$1.wikia.com">http://$1.wikia.com</a> udder söhk Der en andere Adräss uß.',
	'autocreatewiki-name-too-short' => 'Di Adräß es ze koot. Söhk Der ein met winnishßdens 3 Zeijshe us.',
	'autocreatewiki-name-too-long' => 'Di Adräß es ze lang. Söhk Der ein met hüüshßdens 50 Zeijshe us.',
	'autocreatewiki-similar-wikis' => 'Onge shtonn de Wikis zom Teema, di et als jit. Mer schlonn vör, en einem vun dänne ze schrieve.',
	'autocreatewiki-invalid-username' => 'Dä Name es för ene Metmaacher nit jöltesh.',
	'autocreatewiki-busy-username' => 'Dä Name för ene Metmaacher weed ald jebruch.',
	'autocreatewiki-blocked-username' => 'Do darfs keine Zohjang aanlääje.',
	'autocreatewiki-user-notloggedin' => 'Dinge Zohjang es aanjelaat, De bes ävver doh nit enjelogg!',
	'autocreatewiki-empty-language' => 'Söhg en Shprooch för Ding Wiki uß.',
	'autocreatewiki-empty-category' => 'Donn en Kattejori ußsöhke.
',
	'autocreatewiki-empty-wikiname' => 'Dä Name för dat Wiki kann nit läddesh sin.',
	'autocreatewiki-empty-username' => 'Ene Name för ene Metmacher kann nit läddesch sin.',
	'autocreatewiki-empty-password' => 'E Paßwoot kann nit läddesch sin.',
	'autocreatewiki-empty-retype-password' => 'Et Paßwoot widderhollt kann nit läddesch sin.',
	'autocreatewiki-category-label' => 'Saachjropp:',
	'autocreatewiki-category-other' => 'Ander',
	'autocreatewiki-set-username' => 'Lääsh et eez ene Metmaaacher_Name faß.',
	'autocreatewiki-invalid-category' => 'Dat es ene onjölteje Saachjripp.
Donn eine ööhndlesch uß dä Leß ußwähle.
',
	'autocreatewiki-invalid-language' => 'Dat es ene onjölteje Shprooch.
Donn eine ööhndlesch uß dä Leß ußwähle.
',
	'autocreatewiki-invalid-retype-passwd' => 'Bes esu jood, un jiv et sellve Paßwoot en wi bovve.',
	'autocreatewiki-invalid-birthday' => 'Dat Dattum vun de Jeboot es nit jöltesch.',
	'autocreatewiki-log-title' => 'Ding Wiki weed jraad aanjelaat',
	'autocreatewiki-step0' => 'Ben dä Vörjang aam aanshtüßße&nbsp;…',
	'autocreatewiki-stepdefault' => 'Dä Vörjang es aam loufe, waadt&nbsp;…',
	'autocreatewiki-errordefault' => 'Dä Vörjang es nit fäädesch jewoode&nbsp;…',
	'autocreatewiki-step1' => 'Ben et Verzeishneß för Belder aam aanlääje&nbsp;…',
	'autocreatewiki-step2' => 'Ben de Daatebangk aam aanlääje&nbsp;…',
	'autocreatewiki-step3' => 'Ben de Standatt_Enfommazjuhne en de Daatebangk aam donn&nbsp;…',
	'autocreatewiki-step4' => 'Ben de Shtandatt_Belder un et Logo aam kopeeree&nbsp;…',
	'autocreatewiki-step5' => 'Ben de Standatt_Varijaable en de Daatebangk aam donn&nbsp;…',
	'autocreatewiki-step6' => 'Ben de Shtandatt_Tabälle en de Daatebangk aam aanlääje&nbsp;…',
	'autocreatewiki-step7' => 'Ben de Shprooche ier Aanfäng aam opsäze&nbsp;…',
	'autocreatewiki-step8' => 'Ben de Metmaacherjroppe un Saachjroppe aam aanlääje&nbsp;…',
	'autocreatewiki-step9' => 'Ben de Varijaable för et neue Wiki aam opsäze&nbsp;…',
	'autocreatewiki-step10' => 'Ben de Sigge em zentraale Wiki aam aanlääje&nbsp;…',
	'autocreatewiki-step11' => 'Ben <i lang="en">e-mails</i> aan de Metmaacher aam schecke&nbsp;…',
	'autocreatewiki-redirect' => 'Ben aam ömleide op et neue Wiki: $1&nbsp;…',
	'autocreatewiki-congratulation' => 'Uns Jlöckwönsch!',
	'autocreatewiki-welcometalk-log' => 'Wellkummens_Nohreesh',
	'autocreatewiki-regex-error-comment' => 'weed jebruch em Wiki $1 (der janze Täx: $2)',
	'autocreatewiki-step2-error' => 'De Daatebangk jidd_et ald!',
	'autocreatewiki-step3-error' => 'Kann de Standatt_Enfommazjuhne nit en de Daatebangk donn!',
	'autocreatewiki-step6-error' => 'Kann de Shtandatt_Tabälle en de Daatebangk nit aanlääje!',
	'autocreatewiki-step7-error' => 'Kann de Shprooche ier Aanfäng nit opsäze!',
	'autocreatewiki-protect-reason' => 'Deil vun de offizjälle Schnettshtäll',
	'autocreatewiki-welcomesubject' => '$1 es aanjelaat woode!',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'autocreatewiki-language-all' => 'Hemû ziman',
	'autocreatewiki-category-label' => 'Kategorî:',
);

/** Kirghiz (Кыргызча)
 * @author Growingup
 */
$messages['ky'] = array(
	'autocreatewiki-remember' => 'Мени эске сактоо',
	'autocreatewiki-create-account' => 'Эсеп жазуусун жаратуу',
	'autocreatewiki-category-label' => 'Категория:',
	'autocreatewiki-category-other' => 'Башка',
);

/** Latin (Latina)
 * @author Rsa23899
 */
$messages['la'] = array(
	'autocreatewiki-category-label' => 'Categoria:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'autocreatewiki' => 'Eng nei Wiki uleeën',
	'autocreatewiki-page-title-default' => 'Eng nei Wiki uleeën',
	'createwiki' => 'Eng nei Wiki uleeën',
	'autocreatewiki-chooseone' => 'Eng eraussichen',
	'autocreatewiki-category-select' => 'Eng eraussichen',
	'autocreatewiki-language-top' => 'Top $1 Sproochen',
	'autocreatewiki-language-all' => 'All Sproochen',
	'autocreatewiki-remember' => 'Sech u mech erënneren',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-invalid-username' => 'Dëse Benotzernumm ass net valabel.',
	'autocreatewiki-busy-username' => 'Dëse Benotzernumm gëtt scho benotzt.',
	'autocreatewiki-empty-category' => 'Sicht w.e.g. eng Kategorie eraus.',
	'autocreatewiki-empty-wikiname' => 'Den NUmm vun der Wiki däerf net eidel sinn.',
	'autocreatewiki-empty-username' => 'De Benotzernumm kann net eidel sinn.',
	'autocreatewiki-empty-password' => "D'Passwuert kann net eidel sinn.",
	'autocreatewiki-category-label' => 'Kategorie:',
	'autocreatewiki-category-other' => 'Anerer',
	'autocreatewiki-log-title' => 'Är Wiki gëtt ugeluecht',
	'autocreatewiki-congratulation' => 'Gratulatioun!',
	'autocreatewiki-welcometalk-log' => 'Wëllkommensmessage',
	'autocreatewiki-step2-error' => "D'Datebank gëtt et!",
);

/** Lezghian (лезги)
 * @author Namik
 */
$messages['lez'] = array(
	'autocreatewiki-page-title-default' => 'Туькlурун цlийи вики',
);

/** Lithuanian (lietuvių)
 * @author Cyklopas
 * @author Eitvys200
 * @author Vilius
 */
$messages['lt'] = array(
	'autocreatewiki' => 'Sukurti naują wiki',
	'autocreatewiki-desc' => 'Sukurti wiki WikiFactory pagal vartotojų prašymus',
	'autocreatewiki-page-title-default' => 'Sukurti naują wiki',
	'autocreatewiki-page-title-answers' => 'Sukurti naują atsakymų svetainę',
	'createwiki' => 'Sukurti naują wiki',
	'autocreatewiki-chooseone' => 'Pasirinkite vieną',
	'autocreatewiki-required' => '$1 = būtina',
	'autocreatewiki-web-address' => 'Tinklalapio adresas:',
	'autocreatewiki-category-select' => 'Pasirinkite vieną',
	'autocreatewiki-language-top' => 'Top $1 kalbos',
	'autocreatewiki-language-all' => 'Visos kalbos',
	'autocreatewiki-remember' => 'Prisiminti mane',
	'autocreatewiki-create-account' => 'Sukurti sąskaitą',
	'autocreatewiki-haveaccount-question' => 'Ar jau turite Wikia sąskaitą?',
	'autocreatewiki-info-topic' => 'Pridėkite trumpą aprašymą, pavyzdžiui, "Žvaigždžių karai" ar "TV šou".',
	'autocreatewiki-info-category-default' => 'Tai padės lankytojams rasti jūsų wiki.',
	'autocreatewiki-info-category-answers' => 'Tai padės lankytojams rasti jūsų Atsakymų svetainę.',
	'autocreatewiki-info-language' => 'Tai bus numatytosi kalbą lankytojams jūsų wiki.',
	'autocreatewiki-info-email-address' => 'Jūsų elektroninio pašto adresas niekada nebus rodomas betkam Wikia svetainėje.',
	'autocreatewiki-info-terms-agree' => 'Kuriant wiki ir vartotojo abonementą, jūs sutinkate su <a href="http://www.wikia.com/wiki/Terms_of_use">Naudojimosi Wikia sąlygomis</a>',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-empty-field' => 'Prašome užpildyti šį lauką.',
	'autocreatewiki-invalid-username' => 'Šis vartotojo vardas yra neleistinas.',
	'autocreatewiki-busy-username' => 'Šis vartotojo vardas jau užimtas.',
	'autocreatewiki-blocked-username' => 'Jūs negalite sukurti sąskaitos.',
	'autocreatewiki-empty-language' => 'Prašome pasirinkti kalbą wiki',
	'autocreatewiki-empty-category' => 'Prašome pasirinkti kategoriją.',
	'autocreatewiki-empty-wikiname' => 'Wiki pavadinimas negali būti tuščias.',
	'autocreatewiki-empty-username' => 'Vartotojo vardas negali būti tuščias.',
	'autocreatewiki-empty-password' => 'Slaptažodis negali būti tuščias.',
	'autocreatewiki-empty-retype-password' => 'Iš naujo įveskite slaptažodį negali būti tuščias.',
	'autocreatewiki-category-label' => 'Kategorija:',
	'autocreatewiki-category-other' => 'Kita',
	'autocreatewiki-set-username' => 'Pirma pasirinkite naudotojo vardą.',
	'autocreatewiki-invalid-birthday' => 'Neleistina gimimo data',
	'autocreatewiki-log-title' => '↓Jūsų wiki yra kuriama',
	'autocreatewiki-errordefault' => '↓Procesas nebuvo baigtas ...',
	'autocreatewiki-congratulation' => 'Sveikinimai!',
	'autocreatewiki-welcometalk-log' => 'Sveikinimo Žinutė',
	'autocreatewiki-step2-error' => '↓Duomenų bazę egzistuoja!',
	'autocreatewiki-welcomesubject' => '$1 buvo sukurta!',
	'autocreatewiki-welcomebody' => '↓Sveikas(a) $2!

Tavo wiki buvo sukurta! Pažvelkite: <$1>

Pasirengęs pradėti? Mes pridėjome kelias nuorodas į tavo aptarimo puslapį (<$5>), kad padėtume tau pradėti ir skatinti tave patyrinėti daug naudingų zonų apie Wikia. Jei turite bet kokių klausimų ar jaučiatės šiek tiek pasiklydę, atsakykite į šį laišką arba aplankykite mūsų Pagalbos puslapius <http://help.wikia.com>.

Tu taip pat gali aplankyti Įkūrėjo & Administratoriaus dienoraštį <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> ir Wikia Personalų dienoraštį <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> kur jūs rasite patarimų ir gudrybių, informacijos apie naujausias funkcijas ir naujų vykstančių Wikia dalykų.

Laimingo redagavimo!

$3
Wikia Bendruomenės Parama
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Norite gauti mažiau pranešimų nuo mūsų? Jūs galite atsisakyti arba pakeisti savo elektroninio pašto nuostatas čia:
http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Sveiki atvykę!',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'autocreatewiki' => 'Создај ново вики',
	'autocreatewiki-desc' => 'Создавање на вики во ВикиФабрика по барања на корисници',
	'autocreatewiki-page-title-default' => 'Создај ново вики',
	'autocreatewiki-page-title-answers' => 'Создај нова страница за одговори',
	'createwiki' => 'Создај ново вики',
	'autocreatewiki-chooseone' => 'Изберете',
	'autocreatewiki-required' => '$1 = задолжително',
	'autocreatewiki-web-address' => 'Мреж. адреса:',
	'autocreatewiki-category-select' => 'Одберете',
	'autocreatewiki-language-top' => 'Најуспешни $1 јазици',
	'autocreatewiki-language-all' => 'Сите јазици',
	'autocreatewiki-remember' => 'Запомни ме',
	'autocreatewiki-create-account' => 'Направи сметка',
	'autocreatewiki-haveaccount-question' => 'Дали веќе имате сметка на Викија?',
	'autocreatewiki-info-domain' => 'Најдобро е да се користи збор што веројатно би бил клучен збор за пребарување на вашата тема.',
	'autocreatewiki-info-topic' => 'Додајте краток опис, од типот „Војна на ѕвездите“, или „ТВ емисии“.',
	'autocreatewiki-info-category-default' => 'Ова ќе им помогне на посетителите да го  најдат вашето вики.',
	'autocreatewiki-info-category-answers' => 'Ова ќе им помогне на посетителите да ја најдат вашата страница за одговори.',
	'autocreatewiki-info-language' => 'Ова ќе биде автоматски-зададениот јазик за посетителите на вашето вики.',
	'autocreatewiki-info-email-address' => 'Вашата е-поштенска адреса никогаш не се покажува никому на Викија.',
	'autocreatewiki-info-realname' => 'Доколку изберете да го наведете вашето име, истото ќе се користи за оддавање на заслуги за вашата работа.',
	'autocreatewiki-info-birthdate' => 'Викија бара сите корисници да го наведат нивниот датум на раѓање како безбедносна мерка, но и каконачин на зачувување на интегритетот на ова мрежно место, истовремено придржувајќи се до федералните регулативи.',
	'autocreatewiki-info-blurry-word' => 'За да ни помогнете да се заштитиме од автоматизирано создавање на сметки, внесете го заматениот збор прикажан во ова поле.',
	'autocreatewiki-info-terms-agree' => 'Со тоа што го создавате ова вики и корисничка сметка, вие се согласувате со <a href="http://www.wikia.com/wiki/Terms_of_use">Условите на употреба на Викија</a>',
	'autocreatewiki-info-staff-username' => '<b>Само за персонал:</b> Назначениот корисник ќе биде заведен како основач.',
	'autocreatewiki-title-template' => '$1 вики',
	'autocreatewiki-limit-day' => 'Викија го надмина максималниот дозволен број на создадени викија за денес ($1).',
	'autocreatewiki-limit-creation' => 'Го надминавте максималниот број на создадени викија во рок од 24 часа ($1).',
	'autocreatewiki-empty-field' => 'Пополнете го ова поле.',
	'autocreatewiki-bad-name' => 'Името не може да содржи специјални знаци (како $ или @) и мора да еден збор составен од мали букви, без празни места помеѓу нив.',
	'autocreatewiki-invalid-wikiname' => 'Името не може да содржи специјални знаци (како $ или @) и не може да стои празно',
	'autocreatewiki-violate-policy' => 'Името на ова вики содржи збор што ги прекршува нашите правила за именување',
	'autocreatewiki-name-taken' => 'Веќе постои вики со тоа име. Почнете да уредувате на <a href="http://$1.wikia.com">http://$1.wikia.com</a> или пак одберете друга адреса.',
	'autocreatewiki-name-too-short' => 'Адресата е прекратка. Одберете адреса со барем 3 знаци.',
	'autocreatewiki-name-too-long' => 'Адресата е предолга. Одберете адреса со највеќе 50 знаци.',
	'autocreatewiki-similar-wikis' => 'Подолу се наведени веќе создадените викија на оваа тема. Ви предлагаме да уредувате некое од нив.',
	'autocreatewiki-invalid-username' => 'Ова корисничко име е неважечко.',
	'autocreatewiki-busy-username' => 'Ова корисничко име е веќе зафатено.',
	'autocreatewiki-blocked-username' => 'Не можете да создадете сметка.',
	'autocreatewiki-user-notloggedin' => 'Вашата сметка е создадена, но не сте најавени со неа!',
	'autocreatewiki-empty-language' => 'Одберете јазик за викито.',
	'autocreatewiki-empty-category' => 'Одберете една категорија.',
	'autocreatewiki-empty-wikiname' => 'Името на викито не може да стои празно.',
	'autocreatewiki-empty-username' => 'Корисничкото име не може да стои празно.',
	'autocreatewiki-empty-password' => 'Лозинката не може да стои празна.',
	'autocreatewiki-empty-retype-password' => 'Превнесувањето на лозинката не може да стои празно.',
	'autocreatewiki-category-label' => 'Категорија:',
	'autocreatewiki-category-other' => 'Друго',
	'autocreatewiki-set-username' => 'Најпрвин постави корисничко име.',
	'autocreatewiki-invalid-category' => 'Неважечка вредност на категоријата. Одберете правилна категорија од паѓачкиот список.',
	'autocreatewiki-invalid-language' => 'Неважечка вредност за јазик. Одберете правилна вредност од паѓачкиот список.',
	'autocreatewiki-invalid-retype-passwd' => 'Превнесете ја истата лозинка од погоре',
	'autocreatewiki-invalid-birthday' => 'Неважечки датум на раѓање',
	'autocreatewiki-log-title' => 'Вашето вики се создава',
	'autocreatewiki-step0' => 'Иницијализација на процесот...',
	'autocreatewiki-stepdefault' => 'Процесот е во тек. Почекајте...',
	'autocreatewiki-errordefault' => 'Процесот не е довршен ...',
	'autocreatewiki-step1' => 'Ја создавам папката за слики ...',
	'autocreatewiki-step2' => 'Ја создавам базата на податоци ...',
	'autocreatewiki-step3' => 'Поставувам основно-зададени информации во базата на податоци ...',
	'autocreatewiki-step4' => 'Ги копирам основно-зададените слики и лого ...',
	'autocreatewiki-step5' => 'Ги поставувам основно-зададените променливи во базата на податоци ...',
	'autocreatewiki-step6' => 'Ги поставувам основно-зададените табели во базата на податоци ...',
	'autocreatewiki-step7' => 'Го поставувам почетниот утврдувач на јазик ...',
	'autocreatewiki-step8' => 'Поставувам кориснички групи и категории ...',
	'autocreatewiki-step9' => 'Поставувам променливи за новото вики ...',
	'autocreatewiki-step10' => 'Поставувам страници на централното вики ...',
	'autocreatewiki-step11' => 'Испраќам е-пошта до корисникот ...',
	'autocreatewiki-redirect' => 'Пренасочувам кон новото вики: $1 ...',
	'autocreatewiki-congratulation' => 'Честитки!',
	'autocreatewiki-welcometalk-log' => 'Порака за добредојде',
	'autocreatewiki-regex-error-comment' => 'се користи на викито $1 (цел текст: $2)',
	'autocreatewiki-step2-error' => 'Базата на податоци постои!',
	'autocreatewiki-step3-error' => 'Не можам да поставам основно-зададени информации во базата на податоци!',
	'autocreatewiki-step6-error' => 'Не можам да поставам основно-зададени табели во базата на податоци!',
	'autocreatewiki-step7-error' => 'Не можам да ја ископирам почетната база на податоци за јазик!',
	'autocreatewiki-protect-reason' => 'Дел од официјалниот посредник',
	'autocreatewiki-welcomesubject' => 'Создавањето на $1 заврши успешно!',
	'autocreatewiki-welcomebody' => 'Здраво $2!

Вашето вики е создадено! Погледајте: <$1>

Сакате сте да почнете? Ставивме некои врски на вашата страница (<$5>) за да ви помогнеме да почнете и за ве поттикнеме да ги осознаете разните корисни места на Викија. Ако имате било какви прашања или се чувствувате изгубено, одговорете ни на ова писмо или поглејдате ги страниците за помош на <http://help.wikia.com>.

Можете да го прочитате и „Блогот за основачи и администратори“ <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> и Блогот на персоналот на Викија <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> каде ќе најдете совети и финти, информации за нови функции и новини на Викија.

Со среќа!

$3
Поддршка на заедницата на Викимедија
<http://community.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk-wall-title' => 'Добредојдовте!',
	'autocreatewiki-welcometalk-wall' => 'Здраво!
Со возбуда му посакуваме добредојде на викито „{{subst:SITENAME}}“, кое сега е дел од заедницата на Викија! Сепак, има многу што да се прави, па затоа еве некои корисни совети и врски што ќе ве наведат на добар почеток:
*Не знаете каде да почнете? Навратете на [[w:c:community:Admin_Central:Main_Page|Центарот на основачи и администратори]] и погледајте го [[w:c:community:Blog:Wikia_Founders_&_Admins|Блогот]] за да добиете совети како да го започнете викито и како да почнете да го развивате! *Посетете го [[w:c:community:main page|Центарот на заедницата]] за да се запознаете со другите преку [[w:c:community:Special:Chat|разговорот во живо]], дознајте за новите функции, најновите збиднувања и престојните можности на [[w:c:community:Blog:Wikia_Staff_Blog|Блогот за персоналот]]. *Проследете ја [[w:c:community:Webinars|серијата „Вебинар“]] -- каде можете да се пријавите за да општите и соработувате со персоналот на Викија, но и да ги прегледате изминатите седници *Исто така не заборавајте да ги погледате [[Special:WikiFeatures|Викифункциите]] за да дознаете кои функции ќе можете да ги ставите на вашето вики! *Истражете ги [[w:c:community:Admin_Central:Forum|форумите]] на Центарот за основачи и администратори за да видите што прашуваат другите администратори. *На крај, посетете ги  [[w:c:community:Help:Contents|страниците за помош]] на кои ќе најдете одговори на сите поедини прашања.
Сите горенаведени врски се одлични места што ве воведуваат во Викија. Ако некаде заглавите или не можете да најдете одговор на некое прашање -- тогаш обратете ни се [[Special:Contact|тука]]. Но, најважно од сè - забавувајте се! :)
Пријатно уредување!',
	'autocreatewiki-welcometalk' => "== Добредојдовте! ==
<div style=\"font-size:120%; line-height:1.2em;\">Здраво \$1 -- баш ни е драго што го имаме викито '''\$4''' како дел од заедницата на Викија!

Сега имате една цело мрежното место за пополнување со информации, слики и видеоснимки на вашите омилени теми. Но засега има само страници што зјаат во вас празни... Застрашувачки, нели? Еве како можете да започнете.

* '''Напишете вовед за вашата тема''' на насловната страница. Ова е прилика да им објасните на читателите за какво вики се работи и која е темата. Пишувајте колку што сакате! Во писот може да се поврзат сите важни страници на викито.

* '''Започнете некои нови страници''' -- за почеток доволни се реченица-две. Не дозволувајте празнотијата да ве уплаши! Секое вики служи за додавање и менување на разни нешта како што тече времето. Можете да додавате и слики и видеоснимки за да ја пополните страницата и да ја направите поинтересна.

И само терајте! Луѓето многу сакаат да посетуваат викија кајшто има многу што да се прочита и разгледа, па затоа постојано додавајте разни нешта, и така ќе привлечете читатели и уредници. Има многу што да се работи, но не грижете се -- денес ви е прв ден, и имате многу време. Секое вики започнува исто -- малку по малку, почнувајќи со првите неколку страници, па со време нараснува во огромно, посетено и активно мрежно место.

Ако имате било какви прашања, обратете ни се по е-пошта преку вашиот [[Special:Contact|контактен образец]]. Забавувајте се!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'autocreatewiki' => 'പുതിയൊരു വിക്കി സൃഷ്ടിക്കുക',
	'autocreatewiki-page-title-default' => 'പുതിയൊരു വിക്കി സൃഷ്ടിക്കുക',
	'createwiki' => 'പുതിയൊരു വിക്കി സൃഷ്ടിക്കുക',
	'autocreatewiki-chooseone' => 'ഒരെണ്ണം തിരഞ്ഞെടുക്കുക',
	'autocreatewiki-required' => '$1 = നിർബന്ധമാണ്',
	'autocreatewiki-web-address' => 'വെബ് വിലാസം:',
	'autocreatewiki-category-select' => 'ഒരെണ്ണം തിരഞ്ഞെടുക്കുക',
	'autocreatewiki-language-top' => 'ആദ്യ $1 ഭാഷകൾ',
	'autocreatewiki-language-all' => 'എല്ലാ ഭാഷകളും',
	'autocreatewiki-remember' => 'എന്നെ ഓർത്തുവെയ്ക്കുക',
	'autocreatewiki-create-account' => 'ഒരംഗത്വമെടുക്കുക',
	'autocreatewiki-haveaccount-question' => 'താങ്കൾക്ക് വിക്കിയ അംഗത്വമുണ്ടോ?',
	'autocreatewiki-title-template' => '$1 വിക്കി',
	'autocreatewiki-invalid-username' => 'ഈ ഉപയോക്തൃനാമം അസാധുവാണ്.',
	'autocreatewiki-busy-username' => 'ഈ ഉപയോക്തൃനാമം മുമ്പെ എടുത്തിരിക്കുന്നു.',
	'autocreatewiki-category-label' => 'വർഗ്ഗം:',
	'autocreatewiki-set-username' => 'ആദ്യം ഉപയോക്തൃനാമം സജ്ജീകരിക്കുക.',
	'autocreatewiki-invalid-birthday' => 'അസാധുവായ ജനന തീയതി',
	'autocreatewiki-congratulation' => 'അഭിനന്ദനങ്ങൾ!',
	'autocreatewiki-welcometalk-log' => 'സ്വാഗതസന്ദേശം',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'autocreatewiki' => 'Cipta wiki baru',
	'autocreatewiki-desc' => 'Cipta wiki di WikiFactory atas permintaan pengguna',
	'autocreatewiki-page-title-default' => 'Cipta wiki baru',
	'autocreatewiki-page-title-answers' => 'Cipta laman Jawapan baru',
	'createwiki' => 'Cipta wiki baru',
	'autocreatewiki-chooseone' => 'Pilih satu',
	'autocreatewiki-required' => '$1 = diperlukan',
	'autocreatewiki-web-address' => 'Alamat web:',
	'autocreatewiki-category-select' => 'Pilih satu',
	'autocreatewiki-language-top' => '$1 bahasa teratas',
	'autocreatewiki-language-all' => 'Semua bahasa',
	'autocreatewiki-remember' => 'Ingati saya',
	'autocreatewiki-create-account' => 'Buka akaun baru',
	'autocreatewiki-haveaccount-question' => 'Adakah anda mempunyai akaun Wikia?',
	'autocreatewiki-info-domain' => 'Lebih baik gunakan perkataan yang dirasai kerap dijadikan kata kunci carian untuk topik anda.',
	'autocreatewiki-info-topic' => 'Isikan keterangan ringkas seperti "Star Wars" atau "Filem".',
	'autocreatewiki-info-category-default' => 'Ini akan membantu pengunjung mencari wiki anda.',
	'autocreatewiki-info-category-answers' => 'Ini akan membantu pengunjung mencari tapak Jawapan anda.',
	'autocreatewiki-info-language' => 'Inilah yang akan menjadi bahasa yang asali bagi para pengunjung wiki anda.',
	'autocreatewiki-info-email-address' => 'Alamat emel anda tidak akan ditunjukkan kepada sesiapa di Wikia.',
	'autocreatewiki-info-realname' => 'Jika anda memilih untuk menyatakannya, ini akan digunakan untuk memperakui anda atas kerja anda.',
	'autocreatewiki-info-birthdate' => 'Wikia mewajibkan semua pengguna memeberikan tarikh lahir sebenar mereka sebagai langkah berjaga-jaga serta kaedah memelihara keutuhan tapak supaya mematuhi peraturan persekutuan.',
	'autocreatewiki-info-blurry-word' => 'Untuk membantu mencegah pembukaan akaun berautomasi, sila isikan kata kabur yang nada lihat ke dalam ruangan ini.',
	'autocreatewiki-info-terms-agree' => 'Dengan mencipta wiki dan akaun pengguna, anda menyetujui <a href="http://www.wikia.com/wiki/Terms_of_use">Terma Penggunaan Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Kakitangan sahaja:</b> Pengguna yang dinyatakan ini disenaraikan sebagai pengasas.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => 'Wikia telah melampaui jumlah maksimum penciptaan wiki hari ini ( $1 ).',
	'autocreatewiki-limit-creation' => 'Anda telah melampaui jumlah maksimum penciptaan wiki dalam masa 24 jam ( $1 ).',
	'autocreatewiki-empty-field' => 'Sila isikan ruangan ini.',
	'autocreatewiki-bad-name' => 'Nama mestilah terdiri daripada sepatah perkataan huruf kecil sahaja, tanpa jarak dan tidak boleh mengandungi aksara khas (seperti $ atau @).',
	'autocreatewiki-invalid-wikiname' => 'Nama tidak boleh mengandungi aksara khas (seperti $ atau @) dan tidak boleh dibiarkan kosong',
	'autocreatewiki-violate-policy' => 'Nama wiki ini mengandungi kata-kata yang melanggar dasar penamaan kami',
	'autocreatewiki-name-taken' => 'Alamat ini sudah dipunyai wiki lain. Mulai menyunting di <a href="http://$1.wikia.com">http://$1.wikia.com</a> atau pilih alamat lain.',
	'autocreatewiki-name-too-short' => 'Nama ini terlalu singkat; sila pastikan nama anda ada sekurang-kurangnya 3 aksara.',
	'autocreatewiki-name-too-long' => 'Nama ini terlalu panjang; sila pastikan nama anda tidak melebihi 50 aksara.',
	'autocreatewiki-similar-wikis' => 'Berikut adalah wiki-wiki yang sudah dicipta mengenai topik ini. Apa kata anda sunting salah satu daripadanya.',
	'autocreatewiki-invalid-username' => 'Nama pengguna ini tidak sah.',
	'autocreatewiki-busy-username' => 'Nama pengguna ini sudah dipakai.',
	'autocreatewiki-blocked-username' => 'Anda tidak boleh membuka akaun.',
	'autocreatewiki-user-notloggedin' => 'Akaun anda telah dibuka tetapi belum dilog masuk!',
	'autocreatewiki-empty-language' => 'Sila pilih bahasa untuk wiki ini.',
	'autocreatewiki-empty-category' => 'Sila pilih kategori.',
	'autocreatewiki-empty-wikiname' => 'Nama wiki tidak boleh kosong.',
	'autocreatewiki-empty-username' => 'Nama pengguna tidak boleh dibiarkan kosong.',
	'autocreatewiki-empty-password' => 'Kata laluan tidak boleh dibiarkan kosong.',
	'autocreatewiki-empty-retype-password' => 'Kata laluan yang perlu ditaip semula tidak boleh dibiarkan kosong.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Lain-lain',
	'autocreatewiki-set-username' => 'Tentukan nama pengguna terlebih dahulu.',
	'autocreatewiki-invalid-category' => 'Nilai kategori tidak sah.
Sila pilih yang sewajarnya dari senarai juntai bawah.',
	'autocreatewiki-invalid-language' => 'Nilai bahasa tidak sah.
Sila pilih yang sewajarnya dari senarai juntai bawah.',
	'autocreatewiki-invalid-retype-passwd' => 'Sila taip semula kata laluan yang sama seperti di atas',
	'autocreatewiki-invalid-birthday' => 'Tarikh lahir tidak sah',
	'autocreatewiki-log-title' => 'Wiki anda sedang dicipta',
	'autocreatewiki-step0' => 'Proses dimulakan ...',
	'autocreatewiki-stepdefault' => 'Proses sedang berjalan, sila tunggu ...',
	'autocreatewiki-errordefault' => 'Proses belum selesai ...',
	'autocreatewiki-step1' => 'Folder gambar sedang dicipta ...',
	'autocreatewiki-step2' => 'Pangkalan data sedang dicipta ...',
	'autocreatewiki-step3' => 'Maklumat asali sedang ditetapkan dalam pangkalan data ...',
	'autocreatewiki-step4' => 'Gambar dan logo asali sedang disalin ...',
	'autocreatewiki-step5' => 'Pembolehubah asali sedang ditetapkan dalam pangkalan data ...',
	'autocreatewiki-step6' => 'Jadual asali sedang ditetapkan dalam pangkalan data ...',
	'autocreatewiki-step7' => 'Pemula bahasa sedang dicipta ...',
	'autocreatewiki-step8' => 'Kumpulan pengguna dan kategori sedang dicipta ...',
	'autocreatewiki-step9' => 'Pembolehubah ditetapkan untuk wiki baru ...',
	'autocreatewiki-step10' => 'Laman-laman ditetapkan pada wiki pusat ...',
	'autocreatewiki-step11' => 'E-emel sedang dihantar kepada pengguna ...',
	'autocreatewiki-redirect' => 'Melencong ke wiki baru: $1 ...',
	'autocreatewiki-congratulation' => 'Tahniah!',
	'autocreatewiki-welcometalk-log' => 'Mesej Selamat Datang',
	'autocreatewiki-regex-error-comment' => 'digunakan dalam wiki $1 (seluruh teks: $2)',
	'autocreatewiki-step2-error' => 'Pangkalan data wujud!',
	'autocreatewiki-step3-error' => 'Maklumat asali tidak dapat ditetapkan dalam pangkalan data!',
	'autocreatewiki-step6-error' => 'Jadual asali tidak dapat ditetapkan dalam pangkalan data!',
	'autocreatewiki-step7-error' => 'Pangkalan data pemula untuk bahasa tidak dapat disalin!',
	'autocreatewiki-protect-reason' => 'Sebahagian antara muka rasmi',
	'autocreatewiki-welcomesubject' => '$1 telah dicipta!',
	'autocreatewiki-welcomebody' => 'Apa khabar, $2!

Wiki anda telah dicipta! Lihatlah: <$1>

Sedia untuk bermula? Kami telah menyediakan beberapa pautan ke laman perbincangan anda (<$5>) untuk membantu anda bermula serta menggalakkan anda untuk meninjau pelbagai ciri yang membantu di sekitar Wikia. Jika anda mempunyai sebarang soalan atau terasa sedikit sesat, sila balas e-mel ini atau layari laman Bantuan kami <http://help.wikia.com>.

Anda juga boleh membaca blog Pengasas & Pentadbir <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> dan blog Kakitangan Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> untuk mengetahui petua-petua yang menarik, maklumat tentang ciri-ciri baru dan perkembangan terkini di Wikia.

Selamat menyunting!

$3
Wikia Community Support
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Ingin kurangkan penerimaan pesanan dari kami? Anda boleh berhenti melanggan atau mengubah suai keutamaan e-mel anda di sini: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Selamat datang!',
	'autocreatewiki-welcometalk-wall' => 'Selamat sejahtera. Dengan sukacitanya kami menyambut kemasukan {{subst:SITENAME}} ke dalam komuniti Wikia!

Masih ada banyak kerja yang perlu dilakukan; berikut adalah beberapa petua dan pautan yang berguna untuk merancakkan wiki anda:
*Tinjau [[Special:WikiFeatures|Wiki Features]] untuk melihat ciri-ciri yang ingin anda hidupkan dalam wiki anda, termasuk Sembang, Pencapaian dan banyak lagi.
*Singgah di [[w:c:community|Community Central]] untuk mengikuti perkembangan melalui [[w:c:community:Blog:Wikia_Staff_Blog|blog kakitangan]], mengemukakan soalan di [[w:c:community:Special:Forum|forum]], menyertai [[w:c:community:Help:Webinars|siri webinar]], atau bersembang secara langsung dengan ahli-ahli Wikia yang lain.
*Akhir sekali, kunjungi [[Help:Contents|halaman bantuan]] kami untuk mempelajari bagaimana untuk memanfaatkan Wikia dengan sebaiknya.

Kesemua pautan di atas sesuai sekali untuk memulakan jelajah anda. Semoga ceria!',
	'autocreatewiki-welcometalk' => '==Selamat datang!==
Selamat sejahtera. Dengan sukacitanya kami menyambut kemasukan $4 ke dalam komuniti Wikia!

Masih ada banyak kerja yang perlu dilakukan; berikut adalah beberapa petua dan pautan yang berguna untuk merancakkan wiki anda:
*Tinjau [[Special:WikiFeatures|Wiki Features]] untuk melihat ciri-ciri yang ingin anda hidupkan dalam wiki anda, termasuk Sembang, Pencapaian dan banyak lagi.
*Singgah di [[w:c:community|Community Central]] untuk mengikuti perkembangan melalui [[w:c:community:Blog:Wikia_Staff_Blog|blog kakitangan]], mengemukakan soalan di [[w:c:community:Special:Forum|forum]], menyertai [[w:c:community:Help:Webinars|siri webinar]], atau bersembang secara langsung dengan ahli-ahli Wikia yang lain.
*Akhir sekali, kunjungi [[Help:Contents|halaman bantuan]] kami untuk mempelajari bagaimana untuk memanfaatkan Wikia dengan sebaiknya.

Kesemua pautan di atas sesuai sekali untuk memulakan jelajah anda. Semoga ceria!

-- [[User:$2|$3]] <staff />',
);

/** Mazanderani (مازِرونی)
 * @author Firuz
 */
$messages['mzn'] = array(
	'autocreatewiki' => 'اتا نو ویکی درس هکردن',
	'autocreatewiki-page-title-default' => 'اتا نو ویکی درس هکردن',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'autocreatewiki' => 'Opprett en ny Wiki',
	'autocreatewiki-desc' => 'Opprett wiki i WikiFactory etter forespørsel fra bruker',
	'autocreatewiki-page-title-default' => 'Opprett en ny Wiki',
	'autocreatewiki-page-title-answers' => 'Opprett en ny Svar-side',
	'createwiki' => 'Opprett en ny Wiki',
	'autocreatewiki-chooseone' => 'Velg en',
	'autocreatewiki-required' => '$1 = påkrevd',
	'autocreatewiki-web-address' => 'Nettadresse:',
	'autocreatewiki-category-select' => 'Velg en',
	'autocreatewiki-language-top' => 'Topp $1 språk',
	'autocreatewiki-language-all' => 'Alle språk',
	'autocreatewiki-remember' => 'Husk meg',
	'autocreatewiki-create-account' => 'Opprett en konto',
	'autocreatewiki-haveaccount-question' => 'Har du allerede en Wikia-konto?',
	'autocreatewiki-info-domain' => 'Det er best å bruke ord som trolig vil bli brukt som søkeord etter emnet ditt.',
	'autocreatewiki-info-topic' => 'Legg til en kort beskrivelse som «Star Wars» eller «TV-program».',
	'autocreatewiki-info-category-default' => 'Dette vil hjelpe besøkende å finne wikien din.',
	'autocreatewiki-info-category-answers' => 'Dette vil hjelpe besøkende å finne Svar-siden din.',
	'autocreatewiki-info-language' => 'Dette blir standardspråket for besøkende på wikien din.',
	'autocreatewiki-info-email-address' => 'Din e-postadresse vil aldri bli vist til noen på Wikia.',
	'autocreatewiki-info-realname' => 'Om du velger å oppgi dette vil det bli brukt til å kreditere deg for ditt arbeid.',
	'autocreatewiki-info-birthdate' => 'Wikia krever at alle brukere oppgir deres virkelige fødselsdato, både som et sikkerhetsforetak og som et middel for å bevare integriteten til nettstedet, og samtidig etterkomme føderale bestemmelser.',
	'autocreatewiki-info-blurry-word' => 'For å beskytte mot automatisk opprettede kontoer vennligst skriv inn det forvrengte ordet som du ser i dette feltet.',
	'autocreatewiki-info-terms-agree' => 'Ved å opprette en wiki og en brukerkonto godtar du <a href="http://www.wikia.com/wiki/Terms_of_use">Wikias vilkår for bruk</a>',
	'autocreatewiki-info-staff-username' => '<b>Kun stab:</b> Den angitte brukeren vil bli listet opp som grunnlegger.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia har overskredet maks antall wikier den kan opprette idag ($1).',
	'autocreatewiki-limit-creation' => 'Du har overskredet maks antall wikier du kan opprette innen 24 timer ($1).',
	'autocreatewiki-empty-field' => 'Fyll ut dette feltet.',
	'autocreatewiki-bad-name' => 'Navnet kan ikke innholde spesialtegn (som $ eller @) og må være kun ett ord skrevet med små bokstaver uten mellomrom.',
	'autocreatewiki-invalid-wikiname' => 'Navnet kan ikke inneholder spesialtegn (som $ eller @) og kan ikke være tomt',
	'autocreatewiki-violate-policy' => 'Dette wikinavnet inneholder et ord som bryter med våre retningslinjer for navngivning',
	'autocreatewiki-name-taken' => 'Det er allerede en wiki med denne adressen. Begynn å redigere på <a href="http://$1.wikia.com">http://$1.wikia.com</a> eller velg en annen adresse.',
	'autocreatewiki-name-too-short' => 'Denne adressen er for kort, velg en adresse med minst 3 tegn.',
	'autocreatewiki-name-too-long' => 'Denne adressen er for lang. Vennligst velg en adresse med maksimalt 50 tegn.',
	'autocreatewiki-similar-wikis' => 'Nedenfor er wikiene som allerede er opprettet om temaet. Vi foreslår å redigere en av dem.',
	'autocreatewiki-invalid-username' => 'Brukernavnet er ugyldig.',
	'autocreatewiki-busy-username' => 'Brukernavnet er allerede tatt.',
	'autocreatewiki-blocked-username' => 'Du kan ikke opprette en konto.',
	'autocreatewiki-user-notloggedin' => 'Kontoen er opprettet men du er ikke logget inn!',
	'autocreatewiki-empty-language' => 'Vennligst velg språk på Wikien.',
	'autocreatewiki-empty-category' => 'Vennligst velg en kategori.',
	'autocreatewiki-empty-wikiname' => 'Navnet på Wikien kan ikke være tomt.',
	'autocreatewiki-empty-username' => 'Brukernavn kan ikke være tomt.',
	'autocreatewiki-empty-password' => 'Passord kan ikke være tomt.',
	'autocreatewiki-empty-retype-password' => 'Gjenta passord kan ikke være tomt.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Andre',
	'autocreatewiki-set-username' => 'Angi brukernavn først.',
	'autocreatewiki-invalid-category' => 'Ugyldig kategoriverdi.
Vennligst velg en riktig fra rullegardinlisten.',
	'autocreatewiki-invalid-language' => 'Ugyldig verdi for språk.
Velg riktig fra rullegardinlisten.',
	'autocreatewiki-invalid-retype-passwd' => 'Skriv inn det samme passordet som over',
	'autocreatewiki-invalid-birthday' => 'Ugyldig fødselsdato',
	'autocreatewiki-log-title' => 'Wikien din blir opprettet',
	'autocreatewiki-step0' => 'Initialiserer prosess ...',
	'autocreatewiki-stepdefault' => 'Prosessen er i gang, vent ...',
	'autocreatewiki-errordefault' => 'Prosessen ble ikke ferdig ...',
	'autocreatewiki-step1' => 'Oppretter bildemappe ...',
	'autocreatewiki-step2' => 'Oppretter database ...',
	'autocreatewiki-step3' => 'Setter opp standardinformasjon i database ...',
	'autocreatewiki-step4' => 'Kopierer standardbilder og -logo ...',
	'autocreatewiki-step5' => 'Setter opp standardvariabler i database ...',
	'autocreatewiki-step6' => 'Setter opp standardtabeller i database ...',
	'autocreatewiki-step7' => 'Setter opp oppstartsspråk ...',
	'autocreatewiki-step8' => 'Setter opp brukergrupper og -kategorier ...',
	'autocreatewiki-step9' => 'Setter opp variabler for ny wiki ...',
	'autocreatewiki-step10' => 'Setter opp sider på en sentral wiki ...',
	'autocreatewiki-step11' => 'Sender e-post til bruker ...',
	'autocreatewiki-redirect' => 'Omdirigerer til ny wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gratulerer!',
	'autocreatewiki-welcometalk-log' => 'Velkomstmelding',
	'autocreatewiki-regex-error-comment' => 'brukt i wiki $1 (hele teksten: $2)',
	'autocreatewiki-step2-error' => 'Database finnes!',
	'autocreatewiki-step3-error' => 'Kan ikke sette standardinformasjon i database!',
	'autocreatewiki-step6-error' => 'Kan ikke sette standardtabeller i database!',
	'autocreatewiki-step7-error' => 'Kan ikke kopiere database for oppstartsspråk!',
	'autocreatewiki-protect-reason' => 'Del av det offisielle grensesnittet',
	'autocreatewiki-welcomesubject' => '$1 har blitt opprettet!',
	'autocreatewiki-welcomebody' => 'Hallo $2!

Wikien du har blitt opprettet! Ta en kikk: <$1>

Er du klar til å begynne? Vi har lagt noen lenker på diskusjonssiden din (<$5>) for å hjelpe deg med å komme i gang og oppfordre deg til å utforske de mange nyttige områdene i og rundt Wikia. Hvis du har spørsmål eller føler deg litt fortapt, svar på denne e-posten eller sjekk ut hjelpesidene <http://help.wikia.com>.

Du kan også sjekke ut Grunnlegger- & administratorbloggen <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> og bloggen til Wikia-ledelsen <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> hvor du vil finne tips og triks, info om nye funksjoner og nye ting som foregår på Wikia.

Lykke til med redigeringen!

$3
Wikia fellesskapssupport
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Vil du motta færre meldinger fra oss? Du kan avslutte abonnementet eller endre e-postinnstillingene dine her: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Velkommen!',
	'autocreatewiki-welcometalk-wall' => 'Hei der!
Vi er stolte over å ha {{subst:SITENAME}} som en del av Wikia-fellesskapet! Det er fortsatt en masse å gjøre, så her har du noen hjelpsomme tips og lenker for å komme i gang med wikien din:
*Ikke sikker på hvor du skal begynne? Kom innom [[w:c:community:Admin_Central:Main_Page|Grunnlegger- &amp; Admin-sentralen]] og sjekk ut [[w:c:community:Blog:Wikia_Founders_&_Admins|Bloggen]] for tips om hvordan du kan gi wikien din en pangstart og få den til å vokse!
*Besøk [[w:c:community:main page|Fellesskapssentralen]] for å skaffe deg venner via [[w:c:community:Special:Chat|chatten]], lære om nye funksjoner og holde deg oppdatert på Wikia-nyheter og kommende funksjoner på [[w:c:community:Blog:Wikia_Staff_Blog|Ledelsesbloggen]].
*Ta en titt på [[w:c:community:Webinars|webinar-serien vår]] -- hvor du kan registrere deg for å komme i kontakt med Wikia-ledelsen, og i tillegg se tidligere innslag.
*Sørg for å sjekke ut [[Special:WikiFeatures|Wiki-funksjoner]] for å se hva slags funksjoner du kan aktivere på wikien din! *Utforsk [[w:c:community:Admin_Central:Forum|forumet vårt]] på Grunnlegger- og Admin-sentralen for å se hva andre wiki-administratorer lurer på.
*Til slutt, besøk [[w:c:community:Help:Contents|hjelpesidene våre]] for å få svar på de spesifikke spørsmålene du måtte ha.
Alle lenkene ovenfor er gode steder å begynne å utforske Wikia på. Hvis du setter deg fast eller har spørsmål du ikke finner svar på -- vennligst kontakt oss [[Special:Contact|her]]. Men viktigst av alt, ha det gøy! :)
Gledelig redigering!',
	'autocreatewiki-welcometalk' => "== Velkommen! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hei \$1 -- vi er glade over å ha '''\$4''' som en del av Wikia Fellesskapet!

Nå har du en hel nettside å fylle opp med informasjon, bilder og video om yndlingstemaet ditt. Men akkurat nå er det bare tomme sider som stirrer på deg... Skremmende, eller hva? Her er noen måter å komme i gang på.

* '''Introduser temaet ditt''' på forsiden. Dette er din mulighet til å forklare leserne mer om hva temaet handler om. Skriv så mye du vil! Beskrivelsen din kan lenke til alle slags viktige artikler på siden din.

* '''Opprett noen nye sider''' -- bare en setning eller to er flott i begynnelsen. Ikke la de tomme sidene stirre deg i senk! En wiki handler om å legge til og endre ting som det faller seg. Du kan også legge til bilder og video for å fylle siden og gjøre den mer interessant.

Så er det bare å fortsette! Folk liker å besøke wikier med en masse å lese og se på, så fortsett å legge til ting, og du vil tiltrekke nye lesere og bidragsytere. Det er en masse å gjøre, men slapp av -- i dag er den første dagen, og du har masser av tid. Hver eneste wiki starter på samme måte -- litt om gangen, fra de første få sidene, til en stor og travel side.

Hvis du har spørsmål, kan du sende oss en e-post gjennom vårt [[Special:Contact|kontaktskjema]]. Ha det gøy!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Dutch (Nederlands)
 * @author Kippenvlees1
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'autocreatewiki' => 'Begin een nieuwe wiki',
	'autocreatewiki-desc' => 'Wiki aanmaken in WikiFactory door gebruikersverzoeken',
	'autocreatewiki-page-title-default' => 'Nieuwe wiki aanmaken',
	'autocreatewiki-page-title-answers' => 'Nieuwe Antwoordensite aanmaken',
	'createwiki' => 'Nieuwe wiki aanmaken',
	'autocreatewiki-chooseone' => 'Kies er een',
	'autocreatewiki-required' => '$1 = vereist',
	'autocreatewiki-web-address' => 'Webadres:',
	'autocreatewiki-category-select' => 'Maak een keuze',
	'autocreatewiki-language-top' => 'Top $1 talen',
	'autocreatewiki-language-all' => 'Alle talen',
	'autocreatewiki-remember' => 'Aanmeldgegevens onthouden',
	'autocreatewiki-create-account' => 'Registreren',
	'autocreatewiki-haveaccount-question' => 'Hebt u al een Wikia-gebruiker?',
	'autocreatewiki-info-domain' => 'Het is het beste om een woord te kiezen dat vaak gebruikt wordt om uw onderwerp te vinden.',
	'autocreatewiki-info-topic' => 'Voeg een korte beschrijving toe, zoals "Star Wars" of "TV-programma".',
	'autocreatewiki-info-category-default' => 'Hierdoor kunnen bezoekers uw wiki vinden.',
	'autocreatewiki-info-category-answers' => 'Hierdoor kunnen bezoekers uw Antwoordensite vinden.',
	'autocreatewiki-info-language' => 'Dit wordt de standaardtaal voor bezoekers van uw wiki.',
	'autocreatewiki-info-email-address' => 'Uw e-mailadres wordt nooit bekend gemaakt aan welk persoon dan ook op Wikia.',
	'autocreatewiki-info-realname' => 'Geef uw naam op zodat deze gebruikt kan worden om u erkenning te geven voor uw werk.',
	'autocreatewiki-info-birthdate' => 'Wikia vraagt aan alle gebruikers om hun echte geboortedatum op te geven voor veiligheid, maar ook om de integriteit van de site aan de federale regels te laten voldoen.',
	'autocreatewiki-info-blurry-word' => 'Om het automatisch aanmaken van gebruikers tegen te gaan moet u het wazige woord dat u in dit veld ziet invoeren.',
	'autocreatewiki-info-terms-agree' => 'Door een wiki en een gebruiker aan te maken accepteert u de <a href="http://www.wikia.com/wiki/Terms_of_use">gebruiksvoorwaarden van Wikia</a>.',
	'autocreatewiki-info-staff-username' => '<b>Alleen voor stafleden:</b> de aangegeven gebruiker wordt vermeld als de oprichter.',
	'autocreatewiki-title-template' => '$1 wiki',
	'autocreatewiki-limit-day' => "Wikia heeft het maximum aantal nieuwe wiki's voor vandaag ($1) overschreden.",
	'autocreatewiki-limit-creation' => "U hebt het maximum aantal nieuwe wiki's in 24 uur ($1) overschreden.",
	'autocreatewiki-empty-field' => 'Vul dit veld in.',
	'autocreatewiki-bad-name' => 'De naam kan geen speciale tekens bevatten (zoals $ of @) en moet bestaan uit één woord, zonder hoofdletters en zonder spaties.',
	'autocreatewiki-invalid-wikiname' => 'De naam kan geen speciale tekens (zoals $ of @) bevatten en kan niet leeg zijn.',
	'autocreatewiki-violate-policy' => 'Deze wikinaam bevat een woord dat ons beleid voor namen schendt.',
	'autocreatewiki-name-taken' => 'Er bestaat al een wiki met dit adres.
U kunt meehelpen op <a href="http://$1.wikia.com">http://$1.wikia.com</a> of een ander adres kiezen.',
	'autocreatewiki-name-too-short' => 'Dit adres is te kort.
Kies alstublieft een adres met tenminste drie tekens.',
	'autocreatewiki-name-too-long' => 'Het adres is te lang.
Kies een naam met hoogstens vijftig tekens.',
	'autocreatewiki-similar-wikis' => "Hieronder staan de wiki's die al aangemaakt zijn voor dit onderwerp.
We raden u aan aan een van deze wiki's te gaan werken.",
	'autocreatewiki-invalid-username' => 'Deze gebruikersnaam is ongeldig.',
	'autocreatewiki-busy-username' => 'Deze gebruikersnaam is al in gebruik.',
	'autocreatewiki-blocked-username' => 'U kunt geen gebruiker aanmaken.',
	'autocreatewiki-user-notloggedin' => 'Uw gebruiker is aangemaakt maar u bent niet aangemeld!',
	'autocreatewiki-empty-language' => 'Selecteer de taal voor de wiki.',
	'autocreatewiki-empty-category' => 'Selecteer een categorie.',
	'autocreatewiki-empty-wikiname' => 'De naam van de wiki kan niet leeg zijn.',
	'autocreatewiki-empty-username' => 'De gebruikersnaam kan niet leeg zijn.',
	'autocreatewiki-empty-password' => 'Het wachtwoord kan niet leeg zijn.',
	'autocreatewiki-empty-retype-password' => 'Het herhaalde wachtwoord kan niet leeg zijn.',
	'autocreatewiki-category-label' => 'Categorie:',
	'autocreatewiki-category-other' => 'Overige',
	'autocreatewiki-set-username' => 'Stel eerst een gebruikersnaam in.',
	'autocreatewiki-invalid-category' => 'Ongeldige categoriekeuze.
Kies een categorie uit de lijst.',
	'autocreatewiki-invalid-language' => 'Ongeldige taalkeuze.
Kies een taal uit de lijst.',
	'autocreatewiki-invalid-retype-passwd' => 'Herhaal hetzelfde wachtwoord',
	'autocreatewiki-invalid-birthday' => 'Ongeldige geboortedatum',
	'autocreatewiki-log-title' => 'Uw wiki wordt aangemaakt',
	'autocreatewiki-step0' => 'Proces aan het initialiseren ...',
	'autocreatewiki-stepdefault' => 'Proces is aan het werk. Een moment geduld alstublieft...',
	'autocreatewiki-errordefault' => 'Het proces was niet afgerond...',
	'autocreatewiki-step1' => 'Afbeeldingenmap aanmaken…',
	'autocreatewiki-step2' => 'Database aan het aanmaken...',
	'autocreatewiki-step3' => 'Standaardgegevens in de database aan het laden...',
	'autocreatewiki-step4' => 'Standaard afbeeldingen en logo aan het kopiëren ...',
	'autocreatewiki-step5' => 'Standaard variabelen in de database aan het laden...',
	'autocreatewiki-step6' => 'Standaard tabellen in de database aan het laden...',
	'autocreatewiki-step7' => 'Taal aan het instellen...',
	'autocreatewiki-step8' => 'Gebruikersgroepen en categorieën aan het instellen ...',
	'autocreatewiki-step9' => 'Variabelen voor de nieuwe wiki aan het instellen...',
	'autocreatewiki-step10' => "Pagina's op centrale wiki aan het instellen...",
	'autocreatewiki-step11' => 'E-mail aan het verzenden naar gebruiker...',
	'autocreatewiki-redirect' => 'Bezig met het doorverwijzen naar de nieuwe wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gefeliciteerd!',
	'autocreatewiki-welcometalk-log' => 'Welkomstbericht',
	'autocreatewiki-regex-error-comment' => 'gebruikt in wiki $1 (volledige tekst: $2)',
	'autocreatewiki-step2-error' => 'De database bestaat al!',
	'autocreatewiki-step3-error' => 'Het was niet mogelijk de standaard gegevens in de database te laden!',
	'autocreatewiki-step6-error' => 'Het was niet mogelijk de standaard tabellen in de database te laden!',
	'autocreatewiki-step7-error' => 'Het was niet mogelijk de database voor de taal te kopiëren!',
	'autocreatewiki-protect-reason' => 'Onderdeel van de officiële interface',
	'autocreatewiki-welcomesubject' => '$1 is aangemaakt!',
	'autocreatewiki-welcomebody' => "Hallo $2!

Uw wiki is aangemaakt! Ga maar kijken op <$1>

Bent u klaar om te beginnen? We hebben een aantal koppelingen op uw overlegpagina toegevoegd (<$5>) om u op weg te helpen en om u aan te moedigen om de vele handige bronnen rondom Wikia te verkennen. Als u vragen hebt of een beetje de weg kwijt bent, antwoord dan op deze e-mail of kijk op onze hulpppagina's: <http://help.wikia.com>.

U kunt ook op onze blog voor Oprichters en beheerders kijken <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> of op de blog van Wikiamedewerkers <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>. Daar vindt u tips en trucs, informatie over nieuwe functies en ander nieuws over Wikia.

Succes met uw project!

$3
Wikia Gemeenschapsondersteuning
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Wilt u minder berichten van ons ontvangen? U kunt hier uitschrijven of uw e-mailvoorjeuren wijzigen: http://community.wikia.com/Special:Preferences",
	'autocreatewiki-welcometalk-wall-title' => 'Welkom!',
	'autocreatewiki-welcometalk-wall' => "Hallo!
We zijn blij dat {{subst:SITENAME}} nu onderdeel is van de Wikiagemeenschap.

Er is nog veel te doen, dus hier zijn wat handige tips om uw wiki verder te helpen:
* Neem een kijkje op [[Special:WikiFeatures|Wikifuncties]] om te zien welke functies u voor uw wiki in kunt schakelen, waaronder chat, speldjes en nog veel meer.
* Ga langs bij [[w:c:community|Community Central]] om op de hoogte te blijven via onze [[w:c:community:Blog:Wikia_Staff_Blog|medewerkersblog]], stel vragen op ons [[w:c:community:Special:Forum|gemeenschapsforum]], neem deel aan onze [[w:c:community:Help:Webinars|webinars]] of chat live met mede-Wikianen.
* Tenslotte kunt u onze [[Help:Contents|Hulppagina's]] bekijken om alle ins en outs van Wikia te leren kennen.

Alle bovenstaande koppelingen zijn een prima plaats om te beginnen met het verkennen van Wikia. Veel plezier!",
	'autocreatewiki-welcometalk' => "==Hallo!==
We zijn blij dat $4 nu onderdeel is van de Wikiagemeenschap. Er is nog veel te doen, dus hier zijn wat handige tips om uw wiki verder te helpen:

* Neem een kijkje op [[Special:WikiFeatures|Wikifuncties]] om te zien welke functies u voor uw wiki in kunt schakelen, waaronder chat, speldjes en nog veel meer.
* Ga langs bij [[w:c:community|Community Central]] om op de hoogte te blijven via onze [[w:c:community:Blog:Wikia_Staff_Blog|medewerkersblog]], stel vragen op ons [[w:c:community:Special:Forum|gemeenschapsforum]], neem deel aan onze [[w:c:community:Help:Webinars|webinars]] of chat live met mede-Wikianen.
* Tenslotte kunt u onze [[Help:Contents|Hulppagina's]] bekijken om alle ins en outs van Wikia te leren kennen.

Alle bovenstaande koppelingen zijn een prima plaats om te beginnen met het verkennen van Wikia. Veel plezier!

-- [[User:$2|$3]] <staff />",
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'autocreatewiki-haveaccount-question' => 'Heb je al een Wikia-gebruiker?',
	'autocreatewiki-info-domain' => 'Het is het beste om een woord te kiezen dat vaak gebruikt wordt om je onderwerp te vinden.',
	'autocreatewiki-info-category-default' => 'Hierdoor kunnen bezoekers je wiki vinden.',
	'autocreatewiki-info-category-answers' => 'Hierdoor kunnen bezoekers je Antwoordensite vinden.',
	'autocreatewiki-info-language' => 'Dit wordt de standaardtaal voor bezoekers van je wiki.',
	'autocreatewiki-info-email-address' => 'Je e-mailadres wordt nooit bekend gemaakt aan welk persoon dan ook op Wikia.',
	'autocreatewiki-info-realname' => 'Geef je naam op zodat deze gebruikt kan worden om je erkenning te geven voor je werk.',
	'autocreatewiki-info-blurry-word' => 'Om het automatisch aanmaken van gebruikers tegen te gaan moet je het wazige woord dat je in dit veld ziet invoeren.',
	'autocreatewiki-info-terms-agree' => 'Door een wiki en een gebruiker aan te maken accepteer je de <a href="http://www.wikia.com/wiki/Terms_of_use">gebruikersvoorwaarden van Wikia</a>.',
	'autocreatewiki-limit-creation' => "Je hebt het maximum aantal nieuwe wiki's in 24 uur ($1) overschreden.",
	'autocreatewiki-blocked-username' => 'Je kunt geen gebruiker aanmaken.',
	'autocreatewiki-user-notloggedin' => 'Je gebruiker is gemaakt maar je bent niet aangemeld!',
	'autocreatewiki-log-title' => 'Je wiki wordt aangemaakt',
	'autocreatewiki-welcomebody' => "Hoi $2!

Je wiki is aangemaakt! Ga maar kijken op <$1>

Ben je klaar om te beginnen? We hebben een aantal koppelingen op je overlegpagina toegevoegd (<$5>) om je op weg te helpen en om je aan te moedigen om de vele handige bronnen rondom Wikia te verkennen. Als je vragen hebt of een beetje de weg kwijt bent, antwoord dan op deze e-mail of kijk op onze hulpppagina's: <http://help.wikia.com>.

Je kunt ook op onze blog voor Oprichters en beheerders kijken <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> of op de blog van Wikiamedewerkers <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>. Daar vindt je tips en trucs, informatie over nieuwe functies en ander nieuws over Wikia.

Succes met je project!

$3
Wikia Gemeenschapsondersteuning
<http://community.wikia.com/wiki/User:$4>",
	'autocreatewiki-welcometalk' => "== Welkom! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hallo \$1 -- we zijn erg blij dat '''\$4''' onderdeel is geworden van de Wikia-gemeenschap!

Je hebt nu een hele website tot je beschikking hebt die je met informatie, afbeeldingen en video over je favoriete onderwerp kunt gaan vullen. Maar nu staart een lege pagina je aan. Spannend, toch? Hier volgen wat tips om je op weg te helpen.

* '''Leid je onderwerp in''' op de hoofdpagina. Dit is je gelegenheid om uw lezers aan te geven wat je onderwerp van belang maakt. Schrijf zoveel je wilt. In je beschrijving kan je naar alle belangrijke pagina's op je site verwijzen.

* '''Maak nieuwe pagina's aan''' -- soms zijn een paar zinnen al voldoende als beginnetje. Laat het geen lege pagina's zijn! Een belangrijke werkwijze in een wiki is toevoegen en later verbeteren en verfijnen. Je kunt ook afbeeldingen en video toevoegen om de pagina te vullen en deze interessanter en spannender te maken.

En daarna vooral volhouden! De wiki's waar veel te lezen en te zien is zijn het meest aantrekkelijk, dus blijf vooral informatie toevoegen zodat je meer lezers krijgt en daardoor nieuwe gebruikers die ook bijdragen. Er is veel te doen, maar maak u geen zorgen. Vandaag is uw eerste dag en er is voldoende tijd. Iedere wiki start op dezelfde manier. Beetje voor beetje, de eerste pagina's eerst, om zich in de tijd mogelijk tot een grote, drukke website te ontwikkelen.

Als je vragen hebt, e-mail ons dan via het [[Special:Contact|contactformulier]]. Veel plezier!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'autocreatewiki' => 'Ä naijes Wiki grinde',
	'autocreatewiki-page-title-default' => 'Ä naijes Wiki grinde',
	'autocreatewiki-page-title-answers' => 'Ä naiji Oandwoad-Said mache',
	'createwiki' => 'Ä naijes Wiki grinde',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-invalid-username' => 'De Benudzanoame isch ugildisch.',
	'autocreatewiki-busy-username' => "De Benudzanoame hods b'raids.",
	'autocreatewiki-blocked-username' => 'Du deafschd kä Kondo oalesche.',
	'autocreatewiki-user-notloggedin' => 'Doi Kondo isch erzaischd worre, awa bischd ned oagmeld!',
	'autocreatewiki-empty-language' => 'Wehlda ä Schbrooch fa doi Wiki.',
	'autocreatewiki-invalid-birthday' => 'Ugilidische Gbuadsdaach',
	'autocreatewiki-congratulation' => 'Gliggwinsch',
	'autocreatewiki-welcomebody' => "Hei $2!

Doi Wiki isch eazaischd worre! Gugg do: <$1>

Ferdisch fas loschlesche? S'sin ä paa Ling'gs uff doi Dischbediersaid (<$5>) kumme, domid laischda de Oischdiesch in die B'raisch vun Wikia finne duschd. Wonn Frooche hoschd, doan oandwoad uff die Mail oda guggda die Hilfsaid <http://help.wikia.com> oa.

Du konschd a die Said <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> un <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> oagugge, wus a Hilf un Naijischkaide gewe dud.

Alla hob!

$3
Wikia Community Support
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Wilschd wenischa Nochrischde krische? Konschd disch ausschraiwe oda doi doi E-Mail Oischdellunge änare: http://community.wikia.com/Special:Preferences",
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'autocreatewiki' => 'Utwórz nową wiki',
	'autocreatewiki-desc' => 'Utwórz wiki w WikiFactory na prośbę użytkownika',
	'autocreatewiki-page-title-default' => 'Utwórz nową wiki',
	'autocreatewiki-page-title-answers' => 'Utwórz nową wiki Zapytaj',
	'createwiki' => 'Utwórz nową wiki',
	'autocreatewiki-chooseone' => 'Wybierz',
	'autocreatewiki-required' => '$1 = wymagane',
	'autocreatewiki-web-address' => 'Adres strony internetowej:',
	'autocreatewiki-category-select' => 'Wybierz',
	'autocreatewiki-language-top' => '$1 najpopularniejszych języków',
	'autocreatewiki-language-all' => 'Wszystkie języki',
	'autocreatewiki-remember' => 'Zapamiętaj mnie',
	'autocreatewiki-create-account' => 'Utwórz konto',
	'autocreatewiki-haveaccount-question' => 'Czy masz już konto na portalu Wikia?',
	'autocreatewiki-info-domain' => 'Najlepiej użyć słowa, które może być słowem kluczowym szukanego tematu.',
	'autocreatewiki-info-topic' => 'Dodaj krótki opis, taki jak „Gwiezdne Wojny” lub „Seriale”.',
	'autocreatewiki-info-category-default' => 'Pomoże to odnaleźć odwiedzającym Twoją wiki.',
	'autocreatewiki-info-category-answers' => 'Pomoże to odnaleźć odwiedzającym Twoją Zapytaj wiki.',
	'autocreatewiki-info-language' => 'Będzie to domyślny język dla odwiedzających Twoją wiki.',
	'autocreatewiki-info-email-address' => 'Twój adres e-mail nigdy nie będzie widoczny dla nikogo na portalu Wikia.',
	'autocreatewiki-info-realname' => 'Jeśli zdecydujesz się go podać, zostanie użyty, żeby oznaczyć Ciebie jako autora.',
	'autocreatewiki-info-birthdate' => 'Wikia wymaga od wszystkich użytkowników podania rzeczywistej daty urodzenia ze względów bezpieczeństwa oraz dla zachowania spójności strony, przy zapewnieniu zgodności z przepisami federalnymi.',
	'autocreatewiki-info-blurry-word' => 'Ze względu na ochronę przed automatycznym tworzeniem kont, przepisz zamazane słowo widoczne w tym polu.',
	'autocreatewiki-info-terms-agree' => 'Tworząc wiki i konto użytkownika, akceptujesz {{#NewWindowLink: w:Terms of use | Zasady Użytkowania portalu Wikia}}',
	'autocreatewiki-info-staff-username' => '<b>Tylko dla pracowników:</b> Wybrany użytkownik zostanie wyszczególniony jako założyciel.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia przekroczyła dzisiaj maksymalną liczbę utworzonych wiki ($1).',
	'autocreatewiki-limit-creation' => 'Przekroczyłeś maksymalną liczbę wiki, które możesz utworzyć w ciągu 24 godzin ($1).',
	'autocreatewiki-empty-field' => 'Należy wypełnić to pole.',
	'autocreatewiki-bad-name' => 'Nazwa nie może zawierać znaków specjalnych (np. $ czy @) oraz musi stanowić jedno słowo zapisane małymi literami bez odstępów.',
	'autocreatewiki-invalid-wikiname' => 'Nazwa nie może zawierać znaków specjalnych (np. $ czy @) i nie może być pusta',
	'autocreatewiki-violate-policy' => 'Nazwa wiki zawiera słowo, które narusza nasze zasady nadawania tytułów',
	'autocreatewiki-name-taken' => 'Wiki o tym adresie już istnieje. Przyłącz się do edytowania na <a href="http://$1.wikia.com">http://$1.wikia.com</a> lub wybierz inny adres.',
	'autocreatewiki-name-too-short' => 'Adres jest zbyt krótki. Wybierz adres, który zawiera przynajmniej 3 znaki.',
	'autocreatewiki-name-too-long' => 'Adres jest zbyt długi. Wybierz adres, który zawiera maksymalnie 50 znaków.',
	'autocreatewiki-similar-wikis' => 'Poniżej znajdują się istniejące wiki dotyczące tego tematu. Proponujemy edycję jednej z nich.',
	'autocreatewiki-invalid-username' => 'Ta nazwa użytkownika jest nieprawidłowa.',
	'autocreatewiki-busy-username' => 'Ta nazwa użytkownika jest już wykorzystywana.',
	'autocreatewiki-blocked-username' => 'Nie można utworzyć konta.',
	'autocreatewiki-user-notloggedin' => 'Twoje konto zostało utworzone, ale nie jesteś zalogowany!',
	'autocreatewiki-empty-language' => 'Wybierz język dla tej wiki.',
	'autocreatewiki-empty-category' => 'Wybierz kategorię.',
	'autocreatewiki-empty-wikiname' => 'Nazwa wiki nie może być pusta.',
	'autocreatewiki-empty-username' => 'Nazwa użytkownika nie może być pusta.',
	'autocreatewiki-empty-password' => 'Hasło nie może być puste.',
	'autocreatewiki-empty-retype-password' => 'Powtórzone hasło nie może być puste.',
	'autocreatewiki-category-label' => 'Kategoria:',
	'autocreatewiki-category-other' => 'Inne',
	'autocreatewiki-set-username' => 'Najpierw podaj nazwę użytkownika.',
	'autocreatewiki-invalid-category' => 'Nieprawidłowa kategoria.
Wybierz prawidłową z listy.',
	'autocreatewiki-invalid-language' => 'Nieprawidłowy język.
Wybierz prawidłowy z listy.',
	'autocreatewiki-invalid-retype-passwd' => 'Przepisz hasło tak, aby było identyczne z powyższym',
	'autocreatewiki-invalid-birthday' => 'Nieprawidłowa data urodzenia',
	'autocreatewiki-log-title' => 'Twoja wiki jest w trakcie tworzenia',
	'autocreatewiki-step0' => 'Trwa inicjowanie procesu...',
	'autocreatewiki-stepdefault' => 'Proces trwa, proszę czekać...',
	'autocreatewiki-errordefault' => 'Proces nie został ukończony...',
	'autocreatewiki-step1' => 'Tworzenie folderu obrazów...',
	'autocreatewiki-step2' => 'Tworzenie bazy danych...',
	'autocreatewiki-step3' => 'Ustawianie domyślnych informacji w bazie danych...',
	'autocreatewiki-step4' => 'Kopiowanie domyślnych obrazów oraz logo...',
	'autocreatewiki-step5' => 'Ustawianie w bazie danych domyślnych zmiennych...',
	'autocreatewiki-step6' => 'Ustawianie w bazie danych domyślnych tabel...',
	'autocreatewiki-step7' => 'Ustawianie początkowych wartości dla języka...',
	'autocreatewiki-step8' => 'Ustawianie grup użytkowników i kategorii...',
	'autocreatewiki-step9' => 'Ustawianie zmiennych dla nowej wiki...',
	'autocreatewiki-step10' => 'Ustawianie stron na centralnej wiki...',
	'autocreatewiki-step11' => 'Wysyłanie e‐maila do użytkownika...',
	'autocreatewiki-redirect' => 'Przekierowanie do nowej wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gratulacje!',
	'autocreatewiki-welcometalk-log' => 'Wiadomość powitalna',
	'autocreatewiki-regex-error-comment' => 'wykorzystane na wiki $1 (pełny tekst: $2)',
	'autocreatewiki-step2-error' => 'Baza danych istnieje!',
	'autocreatewiki-step3-error' => 'Nie można ustawić domyślnych informacji w bazie danych!',
	'autocreatewiki-step6-error' => 'Nie można ustawić domyślnych tabel w bazie danych!',
	'autocreatewiki-step7-error' => 'Nie można skopiować do bazy danych początkowych wartości dla języka!',
	'autocreatewiki-protect-reason' => 'Część oficjalnego interfejsu',
	'autocreatewiki-welcomesubject' => '$1 została utworzona!',
	'autocreatewiki-welcomebody' => 'Cześć $2,

Twoja wiki została utworzona! Zobacz:
<$1>.

Czy jesteś gotowy, aby rozpocząć edytowanie? Dodaliśmy do Twojej strony dyskusji (<$5>) kilka linków, aby pomóc Ci na początku i zachęcić do przeglądania przydatnych miejsc na portalu Wikia. Jeśli masz jakiekolwiek pytania lub nie wiesz co robić, odpowiedz na ten e-mail albo wejdź na stronę <http://pomoc.wikia.com>.

Możesz też odwiedzić blog Założycieli i Administratorów <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins>, lub blog  Wikia Staff <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog.> Znajdziesz tam porady i wskazówki, informacje o nowych funkcjach oraz najświeższe informacje o tym, co dzieje się na portalu Wikia.

Udanego edytowania!

$3
Wikia – Wsparcie Społeczności
<http://community.wikia.com/wiki/User:$4>


___________________________________________
* Chcesz otrzymywać mniej wiadomości? Możesz zrezygnować z otrzymywania powiadomień lub zmienić ustawienia powiadomień tutaj: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Witaj!',
	'autocreatewiki-welcometalk-wall' => 'Cieszymy się, że {{subst:SITENAME}} dołączyła do społeczności portalu Wikia.

Pozostało wiele do zrobienia. Oto kilka wskazówek i linków na dobry początek:

*Sprawdź [[Special:WikiFeatures|Rozszerzenia Wiki]], żeby zobaczyć, które funkcje możesz włączyć na swojej wiki, w tym Chat, Osiągnięcia i wiele innych.
*Dostosuj wygląd swojej wiki odwiedzając [[Special:ThemeDesigner|Kreator Motywów]], gdzie możesz dodać kolor i style do tła i logo.
*Zajrzyj na [[w:c:community|Centrum Społeczności]], aby być na bieżąco dzięki [[w:c:community:Blog:Wikia_Staff_Blog|blogowi staff]], aby zadawać pytania wejdź na [[w:c:community:Special:Forum|forum społeczności]], bierz udział w naszych [[w:c:community:Help:Webinars|webinariach]], oraz w [[w:c:community:Special:Chat|chatach na żywo]] z innymi Wikianami.
*Odwiedź też [[Help:Contents|strony pomocy]], aby poznać tajniki korzystania z portalu Wikia, w tym, [[Help:New page|jak dodać nową stronę do twojej wiki]], [[Help:Attracting contributors|jak przyciągnąć współtwórców]], oraz [[Help:User access levels|jak dodać administratorów]].
* Możesz też skorzystać ze wszystkich tych narzędzi odwiedzając Panel administratora, który znajdziesz klikając w przycisk „Admin” na dolnym pasku narzędzi.

Wszystkie powyższe linki to świetne miejsca, od których możesz rozpocząć zabawę!',
	'autocreatewiki-welcometalk' => '==Witaj!==

Cieszymy się, że $4 dołączyła do społeczności portalu Wikia. Pozostało wiele do zrobienia. Oto kilka wskazówek i linków na dobry początek:

*Sprawdź [[Special:WikiFeatures|Rozszerzenia Wiki]], żeby zobaczyć, które funkcje możesz włączyć na swojej wiki, w tym Chat, Osiągnięcia i wiele innych.
*Zajrzyj na [[w:c:community|Centrum Społeczności]], aby być na bieżąco dzięki
[[w:c:community:Blog:Wikia_Staff_Blog|blogowi staff]], aby zadawać pytania wejdź na [[w:c:community:Special:Forum|forum społeczności]], bierz udział w naszych [[w:c:community:Help:Webinars|webinariach]], oraz w [[w:c:community:Special:Chat|chatach na żywo]] z innymi Wikianami.
*Odwiedź też [[Help:Contents|strony pomocy]], aby poznać tajniki korzystania z portalu Wikia

Wszystkie powyższe linki to świetne miejsca, od których możesz rozpocząć zabawę!

-- [[Używkownik:$2|$3]] <staff />',
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'autocreatewiki' => 'Crea na neuva Wiki',
	'autocreatewiki-desc' => 'Crea wiki an WikiFactory për arcesta utent',
	'autocreatewiki-page-title-default' => 'Crea na neuva Wiki',
	'autocreatewiki-page-title-answers' => "Crea un sit neuv d'Arspòste",
	'createwiki' => 'Crea na neuva Wiki',
	'autocreatewiki-chooseone' => 'Sern-ne un-a',
	'autocreatewiki-required' => '$1 = ciamà',
	'autocreatewiki-web-address' => "Adrëssa dl'Aragnà:",
	'autocreatewiki-category-select' => 'Sern-ne un-a',
	'autocreatewiki-language-top' => 'Prime $1 lenghe',
	'autocreatewiki-language-all' => 'Tute lenghe',
	'autocreatewiki-remember' => 'Arcòrdme',
	'autocreatewiki-create-account' => 'Crea un Cont',
	'autocreatewiki-haveaccount-question' => 'Ha-lo già un cont Wikia?',
	'autocreatewiki-info-domain' => "A l'é mej dovré na paròla ch'a peussa esse na ciav d'arserca për tò argoment.",
	'autocreatewiki-info-topic' => 'Gionté na descrission curta com "Guère Stelar" o "Spetàcol dla television".',
	'autocreatewiki-info-category-default' => 'Sòn a giuterà ij visitador a trové soa wiki.',
	'autocreatewiki-info-category-answers' => "Sòn a giutërà ij visitador a trové sò sit d'arspòste.",
	'autocreatewiki-info-language' => 'Costa a sarà la lenga dë stàndard për ij visitador ëd soa wiki.',
	'autocreatewiki-info-email-address' => "Soa adrëssa ëd pòsta eletrònica a l'é mai mostrà a gnun su Wikia.",
	'autocreatewiki-info-realname' => "S'a sern ëd delo, a sarà dovrà për atribuije sò travaj.",
	'autocreatewiki-info-birthdate' => "Wikia a ciama a tùit j'utent ëd dé soa vera data ëd nàssita sia për precaussion ëd sigurëssa sia com mojen ëd preeservé l'antegrità dël sit ant ël rispet dij regolament federaj.",
	'autocreatewiki-info-blurry-word' => "Për giuté a protege contra la creassion ëd cont automàtica, për piasì ch'a anserissa la paròla tërmolanta ch'a vëd an sto camp-sì.",
	'autocreatewiki-info-terms-agree' => "An creand na wiki e un cont utent, a l'é d'acòrdi con le <a href=\"http://www.wikia.com/wiki/Terms_of_use\">Condission d'usagi ëd Wikia</a>",
	'autocreatewiki-info-staff-username' => "<b>Mach Echip:</b> L'utent specificà a sarà listà com fondator.",
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => "Wikia a l'ha passà ël màssim nùmer ëd creassion ëd wiki ancheuj ($1).",
	'autocreatewiki-limit-creation' => "It l'has passà ël màssim nùmer ëd creassion ëd wiki an 24 ore ($1).",
	'autocreatewiki-empty-field' => 'Për piasì completa sto camp-sì.',
	'autocreatewiki-bad-name' => 'Ël nòm a peul pa conten-e caràter speciaj (com $ o @) e a deuv esse na sola paròla minùscola sensa spassi.',
	'autocreatewiki-invalid-wikiname' => 'Ël nòm a peul pa conten-e caràter speciaj (com $ e @) e a peul pa esse veuid',
	'autocreatewiki-violate-policy' => "Sto nòm ëd wiki-sì a conten na paròla ch'a rispeta pa nòstre régole pr'ij nòm",
	'autocreatewiki-name-taken' => 'A-i é già na wiki con costa adrëssa. Ch\'a ancamin-a a modifiché a <a href="http://$1.wikia.com">http://$1.wikia.com</a> o ch\'a serna n\'àutra adrëssa.',
	'autocreatewiki-name-too-short' => "St'adrëssa a l'é tròp curta, sern n'adrëssa con almanch 3 caràter.",
	'autocreatewiki-name-too-long' => "St'adrëssa a l'é tròp longa. Për piasì, ch'a serna n'adrëssa con al pi 50 caràter.",
	'autocreatewiki-similar-wikis' => "Sì-sota a-i son le wiki già creà su sto argoment-sì. Nòst sugeriment a l'é ëd travajé su un-a ëd cole.",
	'autocreatewiki-invalid-username' => "Sto nòm utent a l'é pa bon.",
	'autocreatewiki-busy-username' => "Sto nòm utent a l'é già pijà.",
	'autocreatewiki-blocked-username' => 'It peule pa creé ëd cont.',
	'autocreatewiki-user-notloggedin' => "Sò cont a l'é stàit creà ma a l'é pa intrà ant ël sistema!",
	'autocreatewiki-empty-language' => 'Për piasì, selessioné la lenga dla Wiki.',
	'autocreatewiki-empty-category' => 'Për piasì, selession-a na categorìa.',
	'autocreatewiki-empty-wikiname' => 'Ël nòm ëd la Wiki a peul pa esse veuid.',
	'autocreatewiki-empty-username' => 'Ël nòm utent a peul pa esse veuid.',
	'autocreatewiki-empty-password' => 'La ciav a peul pa esse veuida.',
	'autocreatewiki-empty-retype-password' => 'La ciav torna scrivùa a peul pa esse veuida.',
	'autocreatewiki-category-label' => 'Categorìa:',
	'autocreatewiki-category-other' => 'Àutr',
	'autocreatewiki-set-username' => 'Ampòsta nòm utent prima.',
	'autocreatewiki-invalid-category' => "Valor ëd categorìa pa bon. Për piasì, ch'a selession-a col giust da la lista a ridò.",
	'autocreatewiki-invalid-language' => "Valor ëd lenga pa bon. Për piasì, ch'a selession-a col bon da la lista a ridò.",
	'autocreatewiki-invalid-retype-passwd' => "Për piasì, ch'a scriva torna la midema ciav ëd cola dëdzora",
	'autocreatewiki-invalid-birthday' => 'Data ëd nàssita pa bon-a',
	'autocreatewiki-log-title' => "Toa wiki a l'é an creassion",
	'autocreatewiki-step0' => 'Process an camin ...',
	'autocreatewiki-stepdefault' => "Ël process a gira, për piasì ch'a speta ...",
	'autocreatewiki-errordefault' => "Ël process a l'é pa finì ...",
	'autocreatewiki-step1' => 'Creé cartela dle figure ...',
	'autocreatewiki-step2' => 'Creassion dla base ëd dàit ...',
	'autocreatewiki-step3' => "Amposté dj'anformassion dë stàndard ant la base ëd dàit ...",
	'autocreatewiki-step4' => 'Copia dle figure stàndard e dla marca ...',
	'autocreatewiki-step5' => 'Ampostassion dle variàbij dë stàndard ant la base ëd dàit ...',
	'autocreatewiki-step6' => 'Ampostassion dle tàule dë stàndard ant la base ëd dàit ...',
	'autocreatewiki-step7' => 'Amposté lenga inissial ...',
	'autocreatewiki-step8' => "Ampostassion dle partìe dj'utent e dle categorìe ...",
	'autocreatewiki-step9' => 'Ampostassion dle variàbij për la neuva Wiki ...',
	'autocreatewiki-step10' => 'Ampostassion dle pàgine an sla Wiki sentral ...',
	'autocreatewiki-step11' => "Spedission dël mëssagi a l'utent ...",
	'autocreatewiki-redirect' => 'Ridiression a la neuva Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Congratulassion!',
	'autocreatewiki-welcometalk-log' => 'Mëssagi ëd Bin ëvnù',
	'autocreatewiki-regex-error-comment' => 'dovrà ant la Wiki $1 (test antregh: $2)',
	'autocreatewiki-step2-error' => 'La base ëd dàit a esist!',
	'autocreatewiki-step3-error' => "Impossìbil amposté j'anformassion dë stàndard ant la base ëd dàit!",
	'autocreatewiki-step6-error' => 'Impossìbil amposté le tàule dë stàndard ant la base ëd dàit!',
	'autocreatewiki-step7-error' => 'Impossìbil copié la base ëd dàit inissial për la lenga!',
	'autocreatewiki-protect-reason' => "Part ëd l'antërfacia ufissial",
	'autocreatewiki-welcomesubject' => "$1 a l'é stàit creà!",
	'autocreatewiki-welcomebody' => "Cerea $2!

Soa wiki a l'é stàita creà! Ch'a-j daga n'ociada: <$1>

Pront a parte? Noi i l'oma giontà chèiche liure a soa pagina ëd ciaciarade (<$5>) për giutelo a ancaminé e për ancoragelo a esploré le vàire àree ùtij ëd Wikia. S'a l'ha qualsëssìa chestion o s'as sent un pòch pers, ch'a rësponda a 's mëssagi o ch'a lesa nòstre pàgine d'agiut <http://help.wikia.com>.

A peul ëdcò vardé lë scartari dël Fondator e Aministrator <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e lë scartari dl'Echip Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> anté a peul trové ëd sugeriment e truch, anformassion dzora neuve funsion e neuve ròbe ch'a càpito an Wikia.

Tant boneur con ël proget!

$3
Echip ëd la Comunità Wikia
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Veul-lo arseive meno 'd mëssagi da noi? A peul ësganfé l'anscrission o cangé sò gust ëd pòsta eletrònica ambelessì:
http://community.wikia.com/Special:Preferences",
	'autocreatewiki-welcometalk-wall-title' => 'Bin ëvnù!',
	'autocreatewiki-welcometalk-wall' => "Cerea!
I soma content d'avèj {{subst:SITENAME}} com part ëd la Comunità Wikia! A-i é anco' un baron ëd còse da fé, parèj sì a-i son chèich consèj ch'a peulo ven-e a taj e dij colegament për anandié soa wiki:
*A l'é nen sigur d'andoa ancaminé? Ch'as fërma a la [[w:c:community:Admin_Central:Main_Page|Founder &amp; Sentral ëd j'Aministrator]] e ch'a consulta lë [[w:c:community:Blog:Wikia_Founders_&_Admins|scartari]] për dij consèj dzora a com fé parte soa wiki e fela chërse!
*Ch'a vìsita la [[w:c:community:main page|Sentral dla comunità]] për fesse dj'amis con le [[w:c:community:Special:Chat|ciaciarade]], amparé a propòsit ëd neuve funsion e pijé dzora a Wikia funsion neuve e anserije dzora a lë [[w:c:community:Blog:Wikia_Staff_Blog|scartari dël përsonal]].
*Ch'a daga n'ociada a la nòstra [[w:c:community:Webinars|serie ëd seminari]] -- andoa a peul anscriv-se për anteragì con l'Echip ëd Wikia, e ëdcò vardé le session passà
*Ch'a fasa an manera ëd controlé ij [[Special:WikiFeatures|Component ëd wiki]] për vëdde che funsion a peul abilité dzora a soa wiki!
*Ch'a esplora nòstre [[w:c:community:Admin_Central:Forum|piasse ëd discussion]] dzora a la Sentral dj'Aministrator e dij Fondator për vëdde lòn che d'àutri aministrator ëd wiki a ciamo.
*E a la fin, ch'a vìsita nòstre [[w:c:community:Help:Contents|pàgine d'agiut]] për dle rispòste a qualsëssìaa chestion specìfica ch'a peula avèj.
Tute le liure sì-dzora a son dij gran bej pòst për ancaminé a esploré Wikia. Se a l'é blocà o a l'ha na chestion dont a treuva nen la rispòsta -- për piasì, ch'an contata [[Special:Contact|ambelessì]]. Ma dzortut, ch'as amusa! :)
Bon-e modìfiche!",
	'autocreatewiki-welcometalk' => "== Bin ëvnù! ==
<div style=\"font-size:120%; line-height:1.2em;\">Cerea \$1 -- noi i soma content d'avèj '''\$4''' com part ëd la comunità Wikia!

Adess a l'ha 'n sit antregh da ampinì con anformassion, figure e filà dzora ai sò argoment favorì. Ma për ël moment, a-i é mach ëd pàgine bianche dëdnans a chiel ... Brut, pa vera? Ambelessì a-i son chèich manere d'ancaminé.

* '''Ch'a antroduva ij sò argoment''' ant la prima pàgina. Costa a l'é soa oportunità dë spieghé ai sò letor lòn che sò argoment a l'é. Ch'a scriva vàire ch'a veul! Soa descrission a peul avèj d'anliure a tute le pàgine amportante dzora a sò sit.

* '''Ch'a ancamin-a dle pàgine neuve''' -- mach na fras o doe a l'é giust për ancaminé. Ch'as fasa pa sbaruvé da le pàgine bianche! Na wiki a l'é mach gionté e cangé dle còse man a man. A peul ëdcò gionté ëd figure e filmà, për ampinì le pàgine e feje pi anteressante.

E peui ch'a la cudissa! A le përson-e a-i pias visité le wiki quand ch'a-i é motobin ëd ròba da lese e vardé, parèj ch'a continua a gionté 'd ròba, e as tirërà letor e contribudor. A-i é motobin da fé, ma ch'as sagrin-a pa -- ancheuj a l'é sò prim di, e a-i é motobin ëd temp. Minca wiki a part a la midema manera -- un tòch për vòta, ancaminand con le prime pòche pàgine, fin a chërse ant un sit gròss, pien.

S'a l'ha ëd chestion, a peul mandeje për pòsta eletrònica a nòstr [[Special:Contact|formolari ëd contat]]. Tant boneur!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'autocreatewiki' => 'يو نوی ويکي جوړول',
	'autocreatewiki-page-title-default' => 'یو نوی ويکي جوړول',
	'autocreatewiki-page-title-answers' => 'د ځوابونو يو نوی وېبځی جوړول',
	'createwiki' => 'يو نوی ويکي جوړول',
	'autocreatewiki-chooseone' => 'يو وټاکۍ',
	'autocreatewiki-web-address' => 'د جال پته:',
	'autocreatewiki-category-select' => 'يو وټاکۍ',
	'autocreatewiki-language-top' => 'د سر $1 ژبې',
	'autocreatewiki-language-all' => 'ټولې ژبې',
	'autocreatewiki-remember' => 'ما په ياد لره',
	'autocreatewiki-create-account' => 'يو ګڼون جوړول',
	'autocreatewiki-haveaccount-question' => 'آيا تاسې له پخوا نه په ويکييا کې يو کارن-حساب لرۍ؟',
	'autocreatewiki-title-template' => '$1 ويکي',
	'autocreatewiki-invalid-username' => 'دا کارن نوم سم نه دی.',
	'autocreatewiki-busy-username' => 'دا کارن نوم بل چا ځانته ټاکلی.',
	'autocreatewiki-blocked-username' => 'تاسې کارن حساب نه شی جوړولای.',
	'autocreatewiki-empty-category' => 'لطفاً د وېشنيزو نه يوه وټاکۍ.',
	'autocreatewiki-category-label' => 'وېشنيزه:',
	'autocreatewiki-category-other' => 'بل',
	'autocreatewiki-set-username' => 'لومړی مو کارن نوم وټاکۍ.',
	'autocreatewiki-invalid-birthday' => 'ناسمه زېږون نېټه',
	'autocreatewiki-log-title' => 'ستاسې ويکي د جوړېدو په حال کې دی',
	'autocreatewiki-step0' => 'بهير پيلېدو کې دی ...',
	'autocreatewiki-step2' => 'توکبنسټ د جوړولو په حال کې...',
	'autocreatewiki-congratulation' => 'مبارک مو شه!',
	'autocreatewiki-welcometalk-log' => 'د ښه راغلاست پيغام',
	'autocreatewiki-welcomesubject' => '$1 جوړ شو!',
	'autocreatewiki-welcometalk-wall-title' => 'ښه راغلۍ!',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Pttraduc
 * @author SandroHc
 * @author Waldir
 */
$messages['pt'] = array(
	'autocreatewiki' => 'Crie uma nova wikia',
	'autocreatewiki-desc' => 'Crie uma wikia no WikiFactory a partir de pedidos de usuários.',
	'autocreatewiki-page-title-default' => 'Crie uma nova wikia',
	'autocreatewiki-page-title-answers' => 'Crie um novo site de Respostas',
	'createwiki' => 'Crie uma nova wikia',
	'autocreatewiki-chooseone' => 'Escolha um(a)',
	'autocreatewiki-required' => '$1 = necessário',
	'autocreatewiki-web-address' => 'Endereço web:',
	'autocreatewiki-category-select' => 'Escolha um(a)',
	'autocreatewiki-language-top' => 'Os $1 idiomas mais usados',
	'autocreatewiki-language-all' => 'Todos os idiomas',
	'autocreatewiki-remember' => 'Lembrar de mim',
	'autocreatewiki-create-account' => 'Crie uma conta',
	'autocreatewiki-haveaccount-question' => 'Você já tem uma conta Wikia?',
	'autocreatewiki-info-domain' => 'É melhor usar uma palavra que funcione como palavra-chave para facilitar a busca de seu tópico.',
	'autocreatewiki-info-topic' => 'Adicione uma breve descrição como "Star Wars" ou "Programas de TV".',
	'autocreatewiki-info-category-default' => 'Isto ajudará os visitantes a encontrar a sua wikia.',
	'autocreatewiki-info-category-answers' => 'Isto ajudará os visitantes a encontrar o seu site de Respostas.',
	'autocreatewiki-info-language' => 'Este será o idioma padrão para os visitantes da sua wikia.',
	'autocreatewiki-info-email-address' => 'Seu e-mail nunca é mostrado para ninguém na Wikia.',
	'autocreatewiki-info-realname' => 'Se você optar por fornecê-lo, isso será usado para dar atribuição por seu trabalho.',
	'autocreatewiki-info-birthdate' => 'A Wikia exige que todos os usuários forneçam suas datas de nascimento verdadeiras como medida de segurança e para preservar a integridade do site, mantendo a conformidade com os regulamentos federais.',
	'autocreatewiki-info-blurry-word' => 'Para ajudar a proteger o site contra a criação automática de contas, digite a palavra borrada que você vê dentro deste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao criar uma wikia e uma conta de usuário, você está concordando com os {{#NewWindowLink: w: pt:Terms of use |Termos de Uso da Wikia}}',
	'autocreatewiki-info-staff-username' => '<b>Apenas para o staff:</b> O usuário especificado será listado como fundador.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => 'A Wikia excedeu o número máximo de criação de wikias hoje ($1).',
	'autocreatewiki-limit-creation' => 'Você excedeu o número máximo de criação de wikias em 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, preencha esse campo.',
	'autocreatewiki-bad-name' => 'O nome não pode conter caracteres especiais (como $ ou @) nem espaços e precisa estar todo em minúsculas.',
	'autocreatewiki-invalid-wikiname' => 'O nome não pode conter caracteres especiais (como $ ou @) e não pode estar vazio.',
	'autocreatewiki-violate-policy' => 'Esse nome contém uma palavra que viola as nossas políticas de nomeação',
	'autocreatewiki-name-taken' => 'Já existe uma wikia com este endereço. Você pode editá-la em <ahref="http://$1.wikia.com">http://$1.wikia.com</a> ou escolher outro endereço.',
	'autocreatewiki-name-too-short' => 'Este endereço é muito curto, por favor escolha outro com no mímino 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Este endereço é muito longo. Escolha outro com no máximo 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'Abaixo estão as wikias já criadas sobre este tópico. Nós sugerimos que você edite uma delas.',
	'autocreatewiki-invalid-username' => 'Este nome de usuário é inválido.',
	'autocreatewiki-busy-username' => 'Este nome de usuário já está sendo usado.',
	'autocreatewiki-blocked-username' => 'Você não pode criar uma conta.',
	'autocreatewiki-user-notloggedin' => 'Sua conta foi criada, mas você não está conectado!',
	'autocreatewiki-empty-language' => 'Por favor, selecione o idioma da wikia.',
	'autocreatewiki-empty-category' => 'Por favor, selecione uma categoria.',
	'autocreatewiki-empty-wikiname' => 'O nome da wikia não pode estar vazio.',
	'autocreatewiki-empty-username' => 'O nome de usuário não pode estar vazio.',
	'autocreatewiki-empty-password' => 'A senha não pode estar vazia.',
	'autocreatewiki-empty-retype-password' => '"Redigite sua senha" não pode estar vazio.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Outro',
	'autocreatewiki-set-username' => 'Primeiro defina o nome de usuário.',
	'autocreatewiki-invalid-category' => 'Categoria inválida.
Selecione uma apropriada da lista.',
	'autocreatewiki-invalid-language' => 'Idioma inválido.
Selecione um apropriado da lista.',
	'autocreatewiki-invalid-retype-passwd' => 'Redigite a mesma senha acima',
	'autocreatewiki-invalid-birthday' => 'Data de nascimento inválida',
	'autocreatewiki-log-title' => 'A sua wikia está sendo criada.',
	'autocreatewiki-step0' => 'Iniciando processo ...',
	'autocreatewiki-stepdefault' => 'Em processo, por favor aguarde...',
	'autocreatewiki-errordefault' => 'O processo não foi finalizado...',
	'autocreatewiki-step1' => 'Criando a pasta de imagens ...',
	'autocreatewiki-step2' => 'Criando o banco de dados...',
	'autocreatewiki-step3' => 'Definindo as informações padrão no banco de dados ...',
	'autocreatewiki-step4' => 'Copiando as imagens e logotipo padrões ...',
	'autocreatewiki-step5' => 'Definindo as variáveis padrão no banco de dados ...',
	'autocreatewiki-step6' => 'Definindo as tabelas padrão no banco de dados ...',
	'autocreatewiki-step7' => 'Definindo idioma inicial ...',
	'autocreatewiki-step8' => 'Definindo grupos de usuários e categorias ...',
	'autocreatewiki-step9' => 'Definindo variáveis da nova wikia ...',
	'autocreatewiki-step10' => 'Definindo páginas na wikia central ...',
	'autocreatewiki-step11' => 'Enviando e-mail para o usuário...',
	'autocreatewiki-redirect' => 'Redirecionando para a nova wikia: $1 ...',
	'autocreatewiki-congratulation' => 'Parabéns!',
	'autocreatewiki-welcometalk-log' => 'Mensagem de Boas-vindas',
	'autocreatewiki-regex-error-comment' => 'usado na wikia $1 (texto completo: $2)',
	'autocreatewiki-step2-error' => 'O banco de dados existe!',
	'autocreatewiki-step3-error' => 'Não é possível definir informações padrão no banco de dados!',
	'autocreatewiki-step6-error' => 'Não é possível definir as tabelas padrão no banco de dados!',
	'autocreatewiki-step7-error' => 'Não é possível copiar o banco de dados inicial para a língua!',
	'autocreatewiki-protect-reason' => 'Parte da interface oficial',
	'autocreatewiki-welcomesubject' => '$1 foi criada!',
	'autocreatewiki-welcomebody' => 'Olá, $2!

Sua wiki foi criada! Dê uma olhada: <$1>

Pronto para começar? Adicionamos alguns links a sua página de discussão (<$5>) para o ajudar a começar e para encorajá-lo a explorar as variadas áreas úteis da Wikia. Caso tenha dúvidas ou se sinta um pouco perdido, responda a este e-mail ou confira nossas Páginas de Ajuda <http://help.wikia.com>.

Você também pode conferir o blog do Fundador & Administrador <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e o blog do staff da Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>, onde você achará dicas, truques e informações sobre os novos recursos e novas coisas que estão acontecendo na Wikia.

Boa edição!

$3
Suporte da Comunidade Wikia
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Quer receber menos mensagens de nós? Você pode desinscrever-se ou configurar suas preferências de e-mail aqui: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Bem-vindo!',
	'autocreatewiki-welcometalk' => '== Bem-vindo! ==
Olá!

Estamos felizes em ter $4 como parte da comunidade Wikia! Ainda há muita coisa a fazer; aqui estão algumas dicas e links importantes para incrementar sua wikia:

*Confira os [[Special:WikiFeatures|Recursos da Wiki]] para ver quais recursos você pode ativar em sua wikia, incluindo Chat, Medalhas e muito mais.
*Pare na [[w:c:comunidade|Central da Comunidade]] para ficar informado através do nosso [[w:c:comunidade:Categoria:Notícias da Wikia|blog da equipe]], tenha suas dúvidas respondidas no nosso [[w:c:comunidade:Special:Forum|fórum da comunidade]], ou converse ao vivo com outros Wikianos.
*Por último, visite nossas [[Ajuda:Conteúdos|páginas de ajuda]] para aprender mais sobre as manhas de como usar a Wikia.

Todos os links acima são ótimos lugares para começar explorando, divirta-se!

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-welcometalk-wall' => 'Olá, estamos felizes em ter {{subst:SITENAME}} como parte da comunidade Wikia!

Ainda há muita coisa a fazer; aqui estão algumas dicas e links importantes para incrementar sua wikia:
*Confira os [[Special:WikiFeatures|Recursos da Wiki]] para ver quais recursos você pode ativar em sua wikia, incluindo Chat, Medalhas e muito mais.
*Personalize o visual de sua wikia visitando [[Special:ThemeDesigner|Theme Designer]], onde você pode adicionar cor e estilo ao seu background e ao logotipo.
*Pare na [[w:c:comunidade|Central da Comunidade]] para ficar informado através do nosso [[w:c:comunidade:Categoria:Notícias da Wikia|blog da equipe]], tenha suas dúvidas respondidas no nosso [[w:c:comunidade:Special:Forum|fórum da comunidade]], ou converse ao vivo com outros Wikianos.
*Por último, visite nossas [[Ajuda:Conteúdos|páginas de ajuda]] para aprender mais sobre as manhas de como usar a Wikia, incluindo [[Ajuda:Nova página|como adicionar uma nova página a sua wikia]], [[Ajuda:Atraindo contribuidores|como atrair contribuidores]] e [[Ajuda:Níveis_de_acesso_de_usuários|como adicionar outros administradores]].
* Você também pode utilizar todas essas ferramentas visitando o Painel de administração clicando "Admin" na barra de ferramentas inferior.

Todos os links acima são bons lugares para começar explorando, divirta-se!',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Giro720
 * @author JM Pessanha
 * @author Jesielt
 * @author Luckas Blade
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'autocreatewiki' => 'Crie uma nova Wiki',
	'autocreatewiki-desc' => 'Crie uma wiki no WikiFactory a partir de pedidos de usuários',
	'autocreatewiki-page-title-default' => 'Crie uma nova Wiki',
	'autocreatewiki-page-title-answers' => 'Criar um site novo de Respostas',
	'createwiki' => 'Crie uma nova Wiki',
	'autocreatewiki-chooseone' => 'Escolha uma',
	'autocreatewiki-required' => '$1 = campos obrigatórios',
	'autocreatewiki-web-address' => 'Endereço:',
	'autocreatewiki-category-select' => 'Escolha uma',
	'autocreatewiki-language-top' => 'Os $1 idiomas mais usados',
	'autocreatewiki-language-all' => 'Todos os idiomas',
	'autocreatewiki-remember' => 'Me lembre',
	'autocreatewiki-create-account' => 'Crie uma conta',
	'autocreatewiki-haveaccount-question' => 'Você já tem uma conta Wikia?',
	'autocreatewiki-info-domain' => 'É melhor usar uma palavra com a qual as pessoas irão encontrar seu tópico através de buscas.',
	'autocreatewiki-info-topic' => 'Coloque uma descrição curta como "Star Wars" ou "Programas de TV".',
	'autocreatewiki-info-category-default' => 'Isto ajudará os visitantes a encontrar a sua wiki.',
	'autocreatewiki-info-category-answers' => 'Isto ajudará os visitantes a encontrar o seu site de Respostas.',
	'autocreatewiki-info-language' => 'Esse irá ser o idioma padrão para os visitantes da sua wiki.',
	'autocreatewiki-info-email-address' => 'Seu e-mail nunca é mostrado para ninguém no Wikia.',
	'autocreatewiki-info-realname' => 'Se você optar por preenchê-lo, este será utilizado para dar-lhe crédito pelo seu trabalho.',
	'autocreatewiki-info-birthdate' => 'O Wikia exige que todos os usuários providam suas verdadeiras datas de nascimento como uma medida de segurança e para preservar a integridade do site, mantendo a conformidade com os regulamentos federais.',
	'autocreatewiki-info-blurry-word' => 'Para ajudar a proteger o site contra a criação automática de contas, por favor digite a palavra borrada que você vê dentro deste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao criar uma wiki e uma conta de usuário, você está concordando com os <a href="http://www.wikia.com/wiki/Terms_of_use">Termos de Uso do Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Só o staff:</b> O usuário especificado será listado com o fundador.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-limit-day' => 'O Wikia excedeu o número máximo de criação de wiki hoje ($1).',
	'autocreatewiki-limit-creation' => 'Você excedeu o máximo número de criação de wikis em 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, preencha esse campo.',
	'autocreatewiki-bad-name' => 'O nome não pode conter caracteres especiais (como $ ou @) nem espaços e precisa estar todo em minúsculo.',
	'autocreatewiki-invalid-wikiname' => 'O nome não pode conter caracteres especiais (como $ ou @) e não pode estar vazio.',
	'autocreatewiki-violate-policy' => 'Esse nome de wiki contém uma palavra que viola as nossas políticas de nomeação.',
	'autocreatewiki-name-taken' => 'Já existe uma wiki com esse nome. Você é bem-vindo a partipar dela em <ahref="http://$1.wikia.com">http://$1.wikia.com</a> ou escolher outro endereço.',
	'autocreatewiki-name-too-short' => 'Esse nome é muito curto, por favor escolha um nome com no mímino 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Esse nome é muito longo, por favor escolha um nome com no máximo 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'Abaixo estão as wikis já criadas nesse tópico. Nós sugerimos que você edite uma delas.',
	'autocreatewiki-invalid-username' => 'Esse nome de usuário é inválido.',
	'autocreatewiki-busy-username' => 'Esse nome de usuário já é usado.',
	'autocreatewiki-blocked-username' => 'Você não pode criar uma conta.',
	'autocreatewiki-user-notloggedin' => 'Sua conta foi criada, mas você não está logado.',
	'autocreatewiki-empty-language' => 'Por favor, selecione o idioma da Wiki.',
	'autocreatewiki-empty-category' => 'Por favor, selecione uma categoria.',
	'autocreatewiki-empty-wikiname' => 'O nome da Wiki não pode estar vazio.',
	'autocreatewiki-empty-username' => 'O nome de usuário não pode estar vazio.',
	'autocreatewiki-empty-password' => 'A senha não pode estar vazia.',
	'autocreatewiki-empty-retype-password' => '"Redigite sua senha" não pode estar vazio.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Outro',
	'autocreatewiki-set-username' => 'Primeiro defina o nome de usuário.',
	'autocreatewiki-invalid-category' => 'Categoria inválida.
Selecione uma apropriada da lista.',
	'autocreatewiki-invalid-language' => 'Língua inválida.
Selecione uma apropriada da lista.',
	'autocreatewiki-invalid-retype-passwd' => 'Repita a mesma senha, por favor',
	'autocreatewiki-invalid-birthday' => 'Data de nascimento inválida',
	'autocreatewiki-log-title' => 'A sua wiki está sendo criada',
	'autocreatewiki-step0' => 'Iniciando processo ...',
	'autocreatewiki-stepdefault' => 'O processo está sendo feito, por favor aguarde...',
	'autocreatewiki-errordefault' => 'O processo não foi finalizado...',
	'autocreatewiki-step1' => 'Criando o diretório de imagens ...',
	'autocreatewiki-step2' => 'Criando a base de dados ...',
	'autocreatewiki-step3' => 'Definindo os dados por padrão na base de dados ...',
	'autocreatewiki-step4' => 'Copiando as imagens e logotipo padrões ...',
	'autocreatewiki-step5' => 'Definindo as variáveis padrões na base de dados ...',
	'autocreatewiki-step6' => 'Definindo as tabelas padrões na base de dados ...',
	'autocreatewiki-step7' => 'Definindo base de dados inicial da língua ...',
	'autocreatewiki-step8' => 'Definindo grupos de usuários e categorias ...',
	'autocreatewiki-step9' => 'Definindo variáveis da nova wiki ...',
	'autocreatewiki-step10' => 'Definindo páginas na wiki central ...',
	'autocreatewiki-step11' => 'A enviar correio eletrônico para o usuário ...',
	'autocreatewiki-redirect' => 'Redirecionando para a nova wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Parabéns!',
	'autocreatewiki-welcometalk-log' => 'Mensagem de Boas-vindas',
	'autocreatewiki-regex-error-comment' => 'usada na wiki $1 (texto completo: $2)',
	'autocreatewiki-step2-error' => 'A base de dados existe!',
	'autocreatewiki-step3-error' => 'Não foi possível definir os dados padrões na base de dados!',
	'autocreatewiki-step6-error' => 'Não foi possível definir as tabelas padrões na base de dados!',
	'autocreatewiki-step7-error' => 'Não foi possível copiar a base de dados inicial para a língua!',
	'autocreatewiki-protect-reason' => 'Parte da interface oficial',
	'autocreatewiki-welcomesubject' => '$1 foi criado!',
	'autocreatewiki-welcomebody' => 'Olá, $2!

Sua wiki foi criada! Dê uma olhada: <$1>

Pronto para começar? Adicionamos alguns links para sua página de discussão (<$5>) para o ajudar à começar e o encorajar à explorar as variadas áreas úteis ao redor da Wikia. Caso tenha dúvidas ou sente-se um pouco perdido, responda a esse email ou confira nossas Páginas de Ajuda <http://help.wikia.com>.

Você também pode conferir o blog do Fundador & Administrador <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e o blog do time da Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>, onde você achará dicas e truques e informações sobre os novos recursos e novas coisas que estão acontecendo na Wikia.

Boa edição!

$3
Suporte da Comunidade Wikia
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Quer receber menos mensagens de nós? Você pode desinscrever-se ou configurar suas preferências de email aqui: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Bem-vindo!',
	'autocreatewiki-welcometalk-wall' => 'Olá, estamos felizes em ter {{subst:SITENAME}} como parte da comunidade Wikia!

Ainda há muita coisa a fazer; aqui estão algumas dicas e links importantes para fluir sua wiki:
*Confira os [[Special:WikiFeatures|Recursos da Wiki]] para ver quais recursos você pode ativar em sua wiki, incluindo Chat, Medalhas e mais.
*Pare na [[w:c:community|Central da Comunidade]] para ficar informado pelo nosso [[w:c:community:Blog:Wikia_Staff_Blog|blog da staff]], tenha suas dúvidas respondidas no nosso [[w:c:community:Special:Forum|fórum da comunidade]], participe em nossos [[w:c:community:Help:Webinars|webinares]], ou converse ao vivo com nossos queridos Wikianos.
*Por último, visite nossas [[Help:Contents|páginas de ajuda]] para aprender mais sobre as manhas de como usar a Wikia.

Todos os links acima são bons lugares para começar explorando, e divirta-se!',
	'autocreatewiki-welcometalk' => '== Bem-vindo! ==
Olá!

Estamos felizes em ter $4 como parte da comunidade Wikia! Ainda há muita coisa a fazer; aqui estão algumas dicas e links importantes para fluir sua wiki:

*Confira os [[Special:WikiFeatures|Recursos da Wiki]] para ver quais recursos você pode ativar em sua wiki, incluindo Chat, Medalhas e muito mais.
*Pare na [[w:c:community|Central da Comunidade]] para ficar informado pelo nosso [[w:c:community:Blog:Wikia_Staff_Blog|blog da staff]], tenha suas dúvidas respondidas no nosso [[w:c:community:Special:Forum|fórum da comunidade]], participe de nossas [[w:c:community:Help:Webinars|séries webinar]] ou converse ao vivo com nossos queridos Wikianos.
*Por último, visite nossas [[Help:Contents|páginas de ajuda]] para aprender mais sobre as manhas de como usar a Wikia.

Todos os links acima são ótimos lugares para começar explorando, e divirta-se!

-- [[User:$2|$3]] <staff />',
);

/** Romanian (română)
 * @author Minisarm
 * @author Misterr
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'autocreatewiki' => 'Creează un site de tip wiki',
	'autocreatewiki-desc' => 'Creează wiki în Wikifactory la cererea unui utilizator',
	'autocreatewiki-page-title-default' => 'Creează un nou site de tip wiki',
	'autocreatewiki-page-title-answers' => 'Creează un nou site de răspunsuri',
	'createwiki' => 'Creează un nou site de tip wiki',
	'autocreatewiki-chooseone' => 'Alegeți una',
	'autocreatewiki-required' => '$1 = solicitat',
	'autocreatewiki-web-address' => 'Adresă web:',
	'autocreatewiki-category-select' => 'Selectați unul',
	'autocreatewiki-language-top' => 'Clasamentul primelor $1 (de) limbi',
	'autocreatewiki-language-all' => 'Toate limbile',
	'autocreatewiki-remember' => 'Ține-mă minte',
	'autocreatewiki-create-account' => 'Creați-vă un cont',
	'autocreatewiki-haveaccount-question' => 'Aveți deja un cont Wikia?',
	'autocreatewiki-info-domain' => 'Cel mai bun mod de a căuta un subiect este să utilizați cuvinte cheie.',
	'autocreatewiki-info-topic' => 'Adăugați o scurtă descriere, cum ar fi „Star Wars” sau „emisiuni TV”.',
	'autocreatewiki-info-category-default' => 'Acest lucru îi va ajuta pe vizitatori să găsească site-ul dumneavoastră de tip wiki.',
	'autocreatewiki-info-category-answers' => 'Acest lucru îi va ajuta pe vizitatori să găsească site-ul dumneavoastră de răspunsuri.',
	'autocreatewiki-info-language' => 'Aceasta va fi limba implicită a interfeței pentru vizitatorii site-ului dumneavoastră de tip wiki.',
	'autocreatewiki-info-email-address' => 'Adresa dvs. de email nu va fi niciodată văzută pe vreun proiect Wikia.',
	'autocreatewiki-limit-creation' => 'Ați depășit numărul maxim de site-uri wiki create în 24 de ore ($1).',
	'autocreatewiki-empty-field' => 'Te rugăm completează acest câmp.',
	'autocreatewiki-empty-username' => 'Numele de utilizator nu poate fi gol.',
	'autocreatewiki-empty-password' => 'Parola nu poate fi goală.',
	'autocreatewiki-category-label' => 'Categorie:',
	'autocreatewiki-invalid-birthday' => 'Data naşterii invalidă',
	'autocreatewiki-step0' => 'Se iniţializează procesul...',
	'autocreatewiki-stepdefault' => 'Procesul rulează, vă rugăm aşteptaţi...',
	'autocreatewiki-step2' => 'Se creează baza de date...',
	'autocreatewiki-step3' => 'Se setează informaţiile implicite în baza de date...',
	'autocreatewiki-step4' => 'Se creează imaginile implicite şi logourile...',
	'autocreatewiki-congratulation' => 'Felicitări!',
	'autocreatewiki-welcometalk-log' => 'Mesaj de bun venit',
	'autocreatewiki-step2-error' => 'Baza de date există!',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'autocreatewiki-page-title-default' => "Ccreje 'na uicchi nove",
	'autocreatewiki-required' => '$1 = richieste',
	'autocreatewiki-web-address' => 'Indirizze web:',
	'autocreatewiki-category-select' => 'Scacchie une',
	'autocreatewiki-language-all' => 'Tutte le lènghe',
	'autocreatewiki-remember' => 'Arrecuèrdeme',
	'autocreatewiki-create-account' => "Ccreje 'nu cunde utende",
	'autocreatewiki-title-template' => '$1 Uicchi',
	'autocreatewiki-invalid-username' => 'Stu nome utende jè invalide.',
	'autocreatewiki-busy-username' => 'Stu nome utende jè ggià assegnate.',
	'autocreatewiki-blocked-username' => "Tu non ge puè ccrejà 'nu cunde utende.",
	'autocreatewiki-empty-language' => "Pe piacere scacchie 'a lènghe pa uicchi.",
	'autocreatewiki-empty-category' => "Pe piacere scacchie 'na categorije.",
	'autocreatewiki-category-label' => 'Categorije:',
	'autocreatewiki-category-other' => 'otre',
	'autocreatewiki-step2' => "Stoche a ccreje l'archivije ...",
);

/** Russian (русский)
 * @author DCamer
 * @author Eleferen
 * @author Grigol
 * @author Kuzura
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'autocreatewiki' => 'Создать новую вики',
	'autocreatewiki-desc' => 'Создать вики в WikiFactory по запросам участников',
	'autocreatewiki-page-title-default' => 'Создать новую вики',
	'autocreatewiki-page-title-answers' => 'Создать новый сайт ответов',
	'createwiki' => 'Создать новую вики',
	'autocreatewiki-chooseone' => 'Выберите из списка',
	'autocreatewiki-required' => '$1 = обязательно',
	'autocreatewiki-web-address' => 'Веб-адрес:',
	'autocreatewiki-category-select' => 'Выберите одну категорию',
	'autocreatewiki-language-top' => 'Наиболее используемые языки ($1)',
	'autocreatewiki-language-all' => 'Все языки',
	'autocreatewiki-remember' => 'Запомнить меня',
	'autocreatewiki-create-account' => 'Создание учётной записи',
	'autocreatewiki-haveaccount-question' => 'У вас уже есть учётная записи Викия?',
	'autocreatewiki-info-domain' => 'Рекомендуется использовать такое слово, которое для вашей темы будет ключевым при поиске.',
	'autocreatewiki-info-topic' => 'Добавьте краткое описание, например, «Звёздные войны» или «ТВ-шоу».',
	'autocreatewiki-info-category-default' => 'Это поможет посетителям найти вашу вики.',
	'autocreatewiki-info-category-answers' => 'Это поможет посетителям найти ваш сайт ответов.',
	'autocreatewiki-info-language' => 'Язык по умолчанию для посетителей вашей вики.',
	'autocreatewiki-info-email-address' => 'Викия никому не показывает адрес вашей электронной почты.',
	'autocreatewiki-info-realname' => 'Если вы решите предоставить его, он будет использован для указания авторства вашей работы.',
	'autocreatewiki-info-birthdate' => 'Согласно требованиям Викия, все пользователи должны указывать свою настоящую дату рождения. Это мера позволяет обеспечить безопасность и соответствие сайта требованиям федеральных правил.',
	'autocreatewiki-info-blurry-word' => 'Введите размытое слово, которое вы видите, в это поле. Это делается для защиты от автоматического создания учётных записей.',
	'autocreatewiki-info-terms-agree' => 'Создавая вики и учётную запись, вы соглашаетесь с {{#NewWindowLink: w:Terms of use |Условиями использования Викия}}.',
	'autocreatewiki-info-staff-username' => '<b>Только для сотрудников:</b> указанный участник будет показан как основатель.',
	'autocreatewiki-title-template' => 'Вики $1',
	'autocreatewiki-limit-day' => 'Сегодня Викия превысила максимальное число создаваемых вики ($1).',
	'autocreatewiki-limit-creation' => 'Вы превысили максимальное количество вики, которое можно создать за 24 часа ($1).',
	'autocreatewiki-empty-field' => 'Пожалуйста, заполните это поле.',
	'autocreatewiki-bad-name' => 'Название не может содержать специальные символы (например, $ или @) и должно быть представлено одним словом, написанным строчными буквами без пробелов.',
	'autocreatewiki-invalid-wikiname' => 'Название не может содержать специальные символы (например, $ или @) и является обязательным для заполнения.',
	'autocreatewiki-violate-policy' => 'Название вики содержит слово, нарушающее наши правила именования.',
	'autocreatewiki-name-taken' => 'Вики с таким адресом уже существует. Вы можете присоединиться к проекту <a href="http://$1.wikia.com">http://$1.wikia.com</a> или выбрать другой адрес.',
	'autocreatewiki-name-too-short' => 'Слишком короткий адрес. Выберите адрес длиной не менее 3 символов.',
	'autocreatewiki-name-too-long' => 'Слишком длинный адрес. Выберите адрес длиной не более 50 символов.',
	'autocreatewiki-similar-wikis' => 'Ниже приведены уже существующие вики по этой теме. Рекомендуется редактировать одну из них.',
	'autocreatewiki-invalid-username' => 'Недопустимое имя участника.',
	'autocreatewiki-busy-username' => 'Имя участника уже используется.',
	'autocreatewiki-blocked-username' => 'Вы не можете создать учётную запись.',
	'autocreatewiki-user-notloggedin' => 'Ваша учётная запись была создана, однако вы не вошли в систему!',
	'autocreatewiki-empty-language' => 'Необходимо выбрать язык для вики.',
	'autocreatewiki-empty-category' => 'Необходимо выбрать категорию.',
	'autocreatewiki-empty-wikiname' => 'Поле имени вики не может быть пустым.',
	'autocreatewiki-empty-username' => 'Поле имени участника не может быть пустым.',
	'autocreatewiki-empty-password' => 'Поле пароля не может быть пустым.',
	'autocreatewiki-empty-retype-password' => 'Поле повторного ввода пароля не может быть пустым.',
	'autocreatewiki-category-label' => 'Категория:',
	'autocreatewiki-category-other' => 'Другое',
	'autocreatewiki-set-username' => 'Сначала введите имя участника.',
	'autocreatewiki-invalid-category' => 'Неправильное значение категории.
Выберите подходящий вариант из выпадающего списка.',
	'autocreatewiki-invalid-language' => 'Неправильное значение языка.
Выберите подходящий вариант из выпадающего списка.',
	'autocreatewiki-invalid-retype-passwd' => 'Повторно введите тот же самый пароль.',
	'autocreatewiki-invalid-birthday' => 'Неверная дата рождения',
	'autocreatewiki-log-title' => 'Ваша вики создаётся',
	'autocreatewiki-step0' => 'Процесс начался …',
	'autocreatewiki-stepdefault' => 'Процесс запущен, пожалуйста, подождите …',
	'autocreatewiki-errordefault' => 'Процесс не был завершён …',
	'autocreatewiki-step1' => 'Создание директории изображений …',
	'autocreatewiki-step2' => 'Создание базы данных …',
	'autocreatewiki-step3' => 'Установка информации по умолчанию в базе данных …',
	'autocreatewiki-step4' => 'Копирование изображений по умолчанию и логотипа …',
	'autocreatewiki-step5' => 'Установка стандартных переменных в базе данных …',
	'autocreatewiki-step6' => 'Установка стандартных таблиц в базе данных …',
	'autocreatewiki-step7' => 'Настройка начального языка …',
	'autocreatewiki-step8' => 'Настройка групп участников и категорий …',
	'autocreatewiki-step9' => 'Настройка переменных для новой вики …',
	'autocreatewiki-step10' => 'Настройка страниц на центральной вики …',
	'autocreatewiki-step11' => 'Отправка электронного сообщения участнику …',
	'autocreatewiki-redirect' => 'Перенаправление на новую вики: $1 …',
	'autocreatewiki-congratulation' => 'Поздравляем!',
	'autocreatewiki-welcometalk-log' => 'Приветственное сообщение',
	'autocreatewiki-regex-error-comment' => 'использовано в вики «$1» (полный текст: $2)',
	'autocreatewiki-step2-error' => 'База данных существует!',
	'autocreatewiki-step3-error' => ' В базе данных не удаётся установить сведения по умолчанию!',
	'autocreatewiki-step6-error' => 'В базе данных не удаётся установить таблицы по умолчанию!',
	'autocreatewiki-step7-error' => 'Не удаётся скопировать начальную базу данных для языка!',
	'autocreatewiki-protect-reason' => 'Часть официального интерфейса',
	'autocreatewiki-welcomesubject' => '«$1» успешно создана!',
	'autocreatewiki-welcomebody' => 'Здравствуйте, $2!

Ваша вики была создана! Взгляните: <$1>.

Готовы начать? Мы добавили несколько ссылок на вашу страницу обсуждения (<$5>), которые помогут вам начать работу и покажут множество полезных областей Викия. Если у вас есть какие-либо вопросы или вы немного растеряны, ответьте на это письмо или ознакомьтесь с нашей Справкой <http://ru.community.wikia.com/wiki/Справка:Содержание>.

Вы также можете посмотреть блог администраторов на Центральной Вики <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> или блог сотрудников Викия <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>, чтобы узнать новости, найти полезные советы и информацию о новых функциях Викия.

Удачи в редактировании!

$3

Команда сообщества Викия

<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Хотите получать от нас меньше писем? Вы можете отписаться от рассылки или изменить её параметры по ссылке: http://community.wikia.com/Special:Preferences.',
	'autocreatewiki-welcometalk-wall-title' => 'Добро пожаловать!',
	'autocreatewiki-welcometalk-wall' => 'Здравствуйте!
Мы рады, что вики «{{subst:SITENAME}}» стала частью сообщества Викия!

Вам ещё многое предстоит сделать, поэтому позвольте дать несколько советов и полезных ссылок, которые помогут вам начать работу.
*Посетите страницу [[Special:WikiFeatures|Функции Вики]], чтобы узнать о том, какие функции можно активировать для вашей вики, включая чат, достижения и многие другие.
*[[Special:ThemeDesigner|Конструктор тем]] поможет сделать вашу вики индивидуальной – попробуйте добавить различные цвета и стили для фона и логотипа!
*Загляните на [[w:c:community|Вики Сообщества]] и будьте в курсе новостей благодаря [[w:c:community:Blog:Wikia_Staff_Blog|блогу сотрудников Викия]]. Вы можете задать вопросы на нашем [[w:c:community:Special:Forum|Форуме сообщества]], поучаствовать в [[w:c:community:Help:Webinars|вебинарах]] или [[w:c:community:Special:Chat|живом чате]] с другими фанатами Викия.
*Наконец, не забывайте о [[w:ru:Справка:Содержание|Справке]], на страницах которой вы узнаете обо всех особенностях использования Викия, включая [[w:ru:Справка:Новая_страница|добавление страниц]], [[w:ru:Справка:Продвижение Вики|продвижение]] и [[Help:User access levels|добавление новых администраторов для вашей вики]].
*Эти инструменты также можно найти в кабинете администратора, нажав на значок «Администратор» на панели инструментов внизу страницы.

Все перечисленные ресурсы позволят вам изучить основы создания вики и, самое главное, получать от нее удовольствие!',
	'autocreatewiki-welcometalk' => '== Добро пожаловать! ==
Приветствуем вас!
Мы рады, что вики «$4» стала частью сообщества Викия! Вам ещё многое предстоит сделать, поэтому позвольте дать несколько советов и полезных ссылок, которые помогут вам начать работу.

*Посетите страницу [[Special:WikiFeatures|Функции Вики]], чтобы узнать о том, какие функции можно активировать для вашей вики, включая чат, достижения и многие другие.
*Загляните на [[w:c:community|Вики Сообщества]] и будьте в курсе новостей благодаря [[w:c:community:Blog:Wikia_Staff_Blog|блогу сотрудников Викия]]. Вы можете задать вопросы на нашем [[w:c:community:Special:Forum|Форуме сообщества]], поучаствовать в [[w:c:community:Help:Webinars|вебинарах]] или [[w:c:community:Special:Chat|живом чате]] с другими фанатами Викия.
*Наконец, не забывайте о [[w:ru:Справка:Содержание|Справке]], на страницах которой вы узнаете обо всех особенностях использования Викия.
Все перечисленные ресурсы позволят вам изучить основы создания вики и, самое главное, получать от нее удовольствие!

-- [[Участник:$2|$3]] <staff />',
	'autocreatewiki-tagline' => '',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Nikola Smolenski
 * @author Rancher
 * @author Verlor
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'autocreatewiki' => 'Направи нову викију',
	'autocreatewiki-page-title-default' => 'Стварање новог викија',
	'createwiki' => 'Направи нову викију',
	'autocreatewiki-category-select' => 'Изаберите',
	'autocreatewiki-language-top' => 'Најбољих $1 језика',
	'autocreatewiki-language-all' => 'Сви језици',
	'autocreatewiki-remember' => 'Запамти ме',
	'autocreatewiki-create-account' => 'Отвори налог',
	'autocreatewiki-haveaccount-question' => 'Имате ли налог на Викији?',
	'autocreatewiki-info-category-default' => 'Ово ће помоћи да посетиоци пронађу вашу викију.',
	'autocreatewiki-info-category-answers' => 'Ово ће помоћи посетиоцима да пронађу ваш сајт с одговорима.',
	'autocreatewiki-info-language' => 'Ово ће бити подразумевани језик за посетиоце ваше викије.',
	'autocreatewiki-info-email-address' => 'Ваша е-адреса се не приказује другима.',
	'autocreatewiki-info-terms-agree' => 'Прављењем викије и налога прихватате <a href="http://www.wikia.com/wiki/Terms_of_use">правилник</a>',
	'autocreatewiki-empty-field' => 'Попуните ово поље.',
	'autocreatewiki-name-taken' => 'Већ постоји вики с тим називом. Почните да уређујете на <a href="http://$1.wikia.com">http://$1.wikia.com</a> или изаберите другу адресу.',
	'autocreatewiki-invalid-username' => 'Корисничко име је неисправно.',
	'autocreatewiki-busy-username' => 'Корисничко име је заузето.',
	'autocreatewiki-blocked-username' => 'Не можете направити налог.',
	'autocreatewiki-user-notloggedin' => 'Ваш налог је отворен, али нисте пријављени!',
	'autocreatewiki-empty-language' => 'Изаберите језик овог викија.',
	'autocreatewiki-empty-category' => 'Изаберите категорију.',
	'autocreatewiki-empty-wikiname' => 'Назив викија не може остати празан.',
	'autocreatewiki-empty-username' => 'Корисничко име не може остати празно.',
	'autocreatewiki-empty-password' => 'Лозинка не може остати празна.',
	'autocreatewiki-empty-retype-password' => 'Лозинка за потврђивање не може остати празна.',
	'autocreatewiki-category-label' => 'Категорија:',
	'autocreatewiki-category-other' => 'Друго',
	'autocreatewiki-set-username' => 'Унесите корисничко име.',
	'autocreatewiki-invalid-birthday' => 'Датум рођења је неисправан',
	'autocreatewiki-log-title' => 'Ваша викија се прави...',
	'autocreatewiki-step0' => 'Покретање поступка...',
	'autocreatewiki-stepdefault' => 'Поступак је покренут. Молимо, сачекајте...',
	'autocreatewiki-errordefault' => 'Поступак није завршен.',
	'autocreatewiki-step1' => 'Правим фасциклу за слике…',
	'autocreatewiki-step2' => 'Правим базу података…',
	'autocreatewiki-step11' => 'Шаљем е-поруку кориснику…',
	'autocreatewiki-redirect' => 'Преусмеравање на нову викију: $1...',
	'autocreatewiki-congratulation' => 'Честитамо!',
	'autocreatewiki-welcometalk-log' => 'Порука добродошлице',
	'autocreatewiki-step2-error' => 'База података постоји!',
	'autocreatewiki-protect-reason' => 'Део званичног сучеља',
	'autocreatewiki-welcomesubject' => '$1 је направљена!',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'autocreatewiki' => 'Skapa en ny wiki',
	'autocreatewiki-desc' => 'Create wiki in WikiFactory by user requests',
	'autocreatewiki-page-title-default' => 'Skapa en ny wiki',
	'autocreatewiki-page-title-answers' => 'Skapa en ny Svar-sida',
	'createwiki' => 'Skapa en ny wiki',
	'autocreatewiki-chooseone' => 'Välj en',
	'autocreatewiki-required' => '$1 = krävs',
	'autocreatewiki-web-address' => 'Webbadress:',
	'autocreatewiki-category-select' => 'Välj en',
	'autocreatewiki-language-top' => 'Topp $1-språk',
	'autocreatewiki-language-all' => 'Alla språk',
	'autocreatewiki-remember' => 'Kom ihåg mig',
	'autocreatewiki-create-account' => 'Skapa ett konto',
	'autocreatewiki-haveaccount-question' => 'Har du redan ett konto hos Wikia?',
	'autocreatewiki-info-domain' => 'Det är bäst att använda ett ord är ett sannolikt sökord för ditt ämne.',
	'autocreatewiki-info-topic' => 'Lägg till en kort beskrivning, som "Star Wars" eller "TV-program".',
	'autocreatewiki-info-category-default' => 'Detta kommer att hjälpa besökare att hitta din wiki.',
	'autocreatewiki-info-category-answers' => 'Detta kommer att hjälpa besökare att hitta din Svarsida.',
	'autocreatewiki-info-language' => 'Detta kommer att vara standardspråket för dina besökare på din wiki.',
	'autocreatewiki-info-email-address' => 'Din e-postadress visas aldrig för någon på Wikia.',
	'autocreatewiki-info-realname' => 'Om du väljer att ange det, kommer det att användas för att tillskriva dig ditt arbete.',
	'autocreatewiki-info-birthdate' => 'Wikia kräver att alla användare ger ut sina verkliga födelsedatum, som både en säkerhetsåtgärd och som ett sätt att bevara integriteten på sidan under iakttagande av nationella bestämmelser.',
	'autocreatewiki-info-blurry-word' => 'För att skydda sidan mot automatiskt skapande konton, skriver du in det suddiga ordet som du ser i detta fält.',
	'autocreatewiki-info-terms-agree' => 'Genom att skapa en wiki och ett användarkonto, accepterar du <a href="http://www.wikia.com/wiki/Terms_of_use">Wikias Användarvillkor</a>',
	'autocreatewiki-info-staff-username' => '<b>Endast personal:</b> Den angivna användaren kommer att anges som grundare.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia har överskridit det maximala antalet av skapade wikis idag ($1).',
	'autocreatewiki-limit-creation' => 'Du har överskridit det maximala antalet av wiki-skapande på 24 timmar ($1).',
	'autocreatewiki-empty-field' => 'Vänligen fyll i detta område.',
	'autocreatewiki-bad-name' => 'Namnet får inte innehålla specialtecken (som $ eller @) och måsta vara ett enda ord med små bokstäver utan mellanslag.',
	'autocreatewiki-invalid-wikiname' => 'Namnet får inte innehålla specialtecken (som $ eller @) och får inte vara tomt',
	'autocreatewiki-violate-policy' => 'Detta wikinamn innehåller ett ord som bryter mot vår namngivnings-politik',
	'autocreatewiki-name-taken' => 'En wiki med denna adress finns redan. Börja redigera på <a href="http://$1.wikia.com">http://$1.wikia.com</a> eller välj en annan adress.',
	'autocreatewiki-name-too-short' => 'Denna adress är för kort. Välj en adress med minst 3 tecken.',
	'autocreatewiki-name-too-long' => 'Denna adress är för långt. Välj en adress med högst 50 tecken.',
	'autocreatewiki-similar-wikis' => 'Nedan visas de wikis som redan skapats på detta ämne. Vi föreslår att du redigerar en av dem.',
	'autocreatewiki-invalid-username' => 'Detta användarnamn är ogiltigt.',
	'autocreatewiki-busy-username' => 'Detta användarnamn är upptaget.',
	'autocreatewiki-blocked-username' => 'Du kan inte skapa ett konto.',
	'autocreatewiki-user-notloggedin' => 'Ditt konto skapades men loggades inte in!',
	'autocreatewiki-empty-language' => 'Välj språk för wikin.',
	'autocreatewiki-empty-category' => 'Välj en kategori.',
	'autocreatewiki-empty-wikiname' => 'Namnet på wikin kan inte vara tomt.',
	'autocreatewiki-empty-username' => 'Användarnamnet kan inte vara tomt.',
	'autocreatewiki-empty-password' => 'Lösenordet kan inte vara tomt.',
	'autocreatewiki-empty-retype-password' => 'Det upprepande lösenordet kan inte vara tom.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Annat',
	'autocreatewiki-set-username' => 'Sätt ett användarnamn först.',
	'autocreatewiki-invalid-category' => 'Ogiltigt värde på kategori.
Välj rätt från rullgardinsmenyn.',
	'autocreatewiki-invalid-language' => 'Ogiltigt värde av språk.
Välj rätt från rullgardinsmenyn.',
	'autocreatewiki-invalid-retype-passwd' => 'Vänligen skriv in samma lösenord som ovan',
	'autocreatewiki-invalid-birthday' => 'Ogiltigt födelsedatum',
	'autocreatewiki-log-title' => 'Din wiki skapas',
	'autocreatewiki-step0' => 'Initierar processen ...',
	'autocreatewiki-stepdefault' => 'Processen är igång, vänta ...',
	'autocreatewiki-errordefault' => 'Processen var inte klar ...',
	'autocreatewiki-step1' => 'Skapar mapp för bilder ...',
	'autocreatewiki-step2' => 'Skapar databas ...',
	'autocreatewiki-step3' => 'Sätter grundinformation i databasen ...',
	'autocreatewiki-step4' => 'Kopierar standard-bilder och logotyp ...',
	'autocreatewiki-step5' => 'Sätter grundvariabler i databasen ...',
	'autocreatewiki-step6' => 'Sätter grundtabeller i databasen ...',
	'autocreatewiki-step7' => 'Sätter in språk-startaren ...',
	'autocreatewiki-step8' => 'Ställer in användargrupper och kategorier ...',
	'autocreatewiki-step9' => 'Ställer in variabler för den nya wikin ...',
	'autocreatewiki-step10' => 'Ställer in sidor på centrala wikin ...',
	'autocreatewiki-step11' => 'Skickar e-post till användare ...',
	'autocreatewiki-redirect' => 'Omdirigerar till nya wikin: $1 ...',
	'autocreatewiki-congratulation' => 'Grattis!',
	'autocreatewiki-welcometalk-log' => 'Välkomstmeddelande',
	'autocreatewiki-regex-error-comment' => 'används i wikin $1 (hela texten: $2)',
	'autocreatewiki-step2-error' => 'Databasen existerar!',
	'autocreatewiki-step3-error' => 'Kan inte sätta in standardinformation i databasen!',
	'autocreatewiki-step6-error' => 'Kan inte sätta in standardtabeller i databasen!',
	'autocreatewiki-step7-error' => 'Kan inte kopiera databasen för språk!',
	'autocreatewiki-protect-reason' => 'Del av det officiella gränssnittet',
	'autocreatewiki-welcomesubject' => '$1 har skapats!',
	'autocreatewiki-welcomebody' => 'Hej $2!

Din wiki har skapats! Spana in den: <$1>

Är du redo att komma igång? Vi har lagt till några länkar på din diskussionssida (<$5>) för att hjälpa dig komma igång och uppmuntra dig att utforska de användbara områdena runt Wikia. Om du har några frågor eller känner dig lite vilse, svara på detta e-postmeddelande eller kolla på våra hjälpsidor <http://help.wikia.com>.

Du kan också kolla på Grundar- och administratörsbloggen <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> och Wikias personalblogg <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> där du kan hitta tips och tricks, information om nya funktioner och nya saker som händer på Wikia.

Lycka till med redigeringen!

$3

Wikias gemenskapssupport

<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Vill du få färre meddelanden från oss? Du kan avprenumerera eller ändra din e-postadress här: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Välkommen!',
	'autocreatewiki-welcometalk-wall' => 'Hej, vi är glada att ha {{subst:SITENAME}} som en del av Wikias gemenskap!

Det finns fortfarande mycket att göra, så här kommer några hjälpsamma tips och länkar för att komma igång med din wiki:
*Spana in [[Special:WikiFeatures|Wiki-funktioner]] för att se vilka funktioner du kan aktivera på din wiki; inklusive chatt, utmärkelser och mycket mer.

*Gå in på [[w:c:community|gemenskapscentralen]] för att bli informerad med vår [[w:c:community:Blog:Wikia_Staff_Blog|personals blogg]], ställ frågor på vårt [[w:c:community:Special:Forum|gemenskapsforum]], delta i våra [[w:c:community:Help:Webinars|webbkonferenser]] eller chatta direkt med andra Wikianer.
*Och till sist kan du besöka våra [[Help:Contents|hjälpsidor]] för att lära dig hur man använder Wikia.

Alla ovanstående länkar är perfekta platser att börja utforska och ha kul!',
	'autocreatewiki-welcometalk' => '== Välkommen! ==
Hallå där!

Vi är glada över att ha $4 som en del av Wikia-gemenskapen! Det finns fortfarande mycket att göra, så här kommer några hjälpsamma tips och länkar för att komma igång med din wiki:

*Spana in [[Special:WikiFeatures|Wiki-funktioner]] för att se vilka funktioner du kan aktivera på din wiki; inklusive chatt, utmärkelser och mycket mer.
*Gå in på [[w:c:community|gemenskapscentralen]] för att bli informerad med vår [[w:c:community:Blog:Wikia_Staff_Blog|personals blogg]], ställ frågor på vårt [[w:c:community:Special:Forum|gemenskapsforum]], delta i våra [[w:c:community:Help:Webinars|webbkonferenser]] eller chatta direkt med andra Wikianer.
*Och till sist kan du besöka våra [[Help:Contents|hjälpsidor]] för att lära dig hur man använder Wikia.

Alla ovanstående länkar är perfekta platser att börja utforska och ha kul!

-- [[User:$2|$3]] <staff />',
);

/** Swahili (Kiswahili)
 */
$messages['sw'] = array(
	'autocreatewiki-create-account' => 'Sajili akaunti',
	'autocreatewiki-category-label' => 'Jamii:',
	'autocreatewiki-category-other' => 'Nyingine',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 * @author TRYPPN
 * @author செல்வா
 */
$messages['ta'] = array(
	'autocreatewiki-category-select' => 'ஒன்றைத் தேர்வு செய்யவும்',
	'autocreatewiki-language-all' => 'அனைத்து மொழிகள்',
	'autocreatewiki-remember' => 'என்னை நினைவில் வைத்துக்கொள்ளவும்',
	'autocreatewiki-create-account' => 'கணக்கு ஒன்றை உருவாக்கவும்',
	'autocreatewiki-title-template' => '$1 விக்கி',
	'autocreatewiki-category-label' => 'பகுப்பு:',
	'autocreatewiki-category-other' => 'மற்றவை',
	'autocreatewiki-log-title' => 'தங்களது விக்கி உருவாக்கப்பட்டுவிட்டது',
	'autocreatewiki-welcometalk-log' => 'வரவேற்பு செய்தி',
);

/** Telugu (తెలుగు)
 * @author Praveen Illa
 * @author Veeven
 */
$messages['te'] = array(
	'autocreatewiki-required' => '$1 = తప్పనిసరి',
	'autocreatewiki-web-address' => 'జాల చిరునామా:',
	'autocreatewiki-language-all' => 'అన్ని భాషలు',
	'autocreatewiki-remember' => 'నన్ను గుర్తుంచుకో',
	'autocreatewiki-title-template' => '$1 వికీ',
	'autocreatewiki-category-label' => 'వర్గం:',
	'autocreatewiki-category-other' => 'ఇతర',
	'autocreatewiki-congratulation' => 'అభినందనలు!',
	'autocreatewiki-welcometalk-log' => 'స్వాగత సందేశం',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'autocreatewiki' => 'Lumikha ng isang bagong wiki',
	'autocreatewiki-desc' => 'Lumikha ng wiki sa WikiPabrika ayon sa mga kahilingan ng tagagamit',
	'autocreatewiki-page-title-default' => 'Lumikha ng isang bagong wiki',
	'autocreatewiki-page-title-answers' => 'Lumikha ng isang bagong sityo ng Mga Sagot',
	'createwiki' => 'Lumikha ng isang bagong wiki',
	'autocreatewiki-chooseone' => 'Pumili ng isa',
	'autocreatewiki-required' => '$1 = kailangan',
	'autocreatewiki-web-address' => 'Tirahan ng web:',
	'autocreatewiki-category-select' => 'Pumili ng isa',
	'autocreatewiki-language-top' => 'Pinakamataas na $1 na mga wika',
	'autocreatewiki-language-all' => 'Lahat ng mga wika',
	'autocreatewiki-remember' => 'Tandaan ako',
	'autocreatewiki-create-account' => 'Lumikha ng isang akawnt',
	'autocreatewiki-haveaccount-question' => 'Mayroon ka na bang isang akawnt sa Wikia',
	'autocreatewiki-info-domain' => 'Pinakamainam na gamitin ang isang salitang mas malamang na isang susing-salita ng paghahanap para sa iyong paksa.',
	'autocreatewiki-info-topic' => 'Magdagdag ng isang maikling paglalarawan na katulad ng "Star Wars" o "mga palabas sa TV".',
	'autocreatewiki-info-category-default' => 'Makakatulong ito sa mga panauhin na matagpuan ang wiki mo.',
	'autocreatewiki-info-category-answers' => 'Makakatulong ito sa mga panauhin na matagpuan ang sityo mo ng Mga Sagot.',
	'autocreatewiki-info-language' => 'Ito ang magiging likas na nakatakdang wika para sa mga panauhin ng wiki mo.',
	'autocreatewiki-info-email-address' => 'Hindi ipapakita kailanman ng Wikia sa sinuman ang tirahan mo ng e-liham.',
	'autocreatewiki-info-realname' => 'Kung pipiliin mong ibigay ito, gagamitin ito para sa pagbibigay ng atribusyon para sa ginawa mo.',
	'autocreatewiki-info-birthdate' => 'Kailangan ng Wikia na ang lahat ng mga tagagamit ay magbigay ng kanilang tunay na petsa ng kapanganakan kapwa bilang isang pag-iingat na pangkaligtasan at bilang isang kaparaanan ng pagpapanatili sa karangalan ng pook habang tumatalima sa mga tuntuning pederal.',
	'autocreatewiki-info-blurry-word' => 'Upang makatulong sa pagprutekta laban sa kusang paglikha ng akawnt, paki imakinilya ang malabong salita na nakikita mo sa loob ng hanay na ito.',
	'autocreatewiki-info-terms-agree' => 'Sa paglikha ng isang wiki at ng isang akawnt ng tagagamit, sumasang-ayon ka sa <a href="http://www.wikia.com/wiki/Terms_of_use">Mga Hinihingi sa Paggamit ng Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Tauhan lamang:</b> Ang tinukoy na tagagamit ay ililista bilang ang tagapagtatag.',
	'autocreatewiki-title-template' => 'Wiki ng $1',
	'autocreatewiki-limit-day' => 'Lumampas na ang Wikia sa pinaka mataas na bilang ng mga paglikha ng wiki sa araw na ito ($1).',
	'autocreatewiki-limit-creation' => 'Lumampas ka na sa pinaka mataas na bilang ng paglikha ng wiki sa loob ng 24 mga oras ($1).',
	'autocreatewiki-empty-field' => 'Pakikumpleto ang lugar na ito.',
	'autocreatewiki-bad-name' => 'Ang pangalan ay hindi maaaring maglaman ng natatanging mga panitik (katulad ng $ o @) at dapat na isang nag-iisang salitang maliliit ang mga titik na walang mga patlang.',
	'autocreatewiki-invalid-wikiname' => 'Ang pangalan ay hindi maaaring maglaman ng natatanging mga panitik (katulad ng $ o @) at hindi maaaring walang laman',
	'autocreatewiki-violate-policy' => 'Ang pangalan ng wiking ito ay naglalaman ng isang salita na lumalabag sa aming patakaran ng pagpapangalan',
	'autocreatewiki-name-taken' => 'Mayroon nang isang wiki na may ganitong tirahan. Magsimulang mamatnugot sa <a href="http://$1.wikia.com">http://$1.wikia.com</a> o pumili ng ibang tirahan.',
	'autocreatewiki-name-too-short' => 'Napaka maiksi ng tirahang ito, pumili ng isang tirahan na mayroong kahit na 3 mga panitik.',
	'autocreatewiki-name-too-long' => 'Napaka mahaba ng tirahang ito. Paki pumili ng isang tirahan na may pinaka mataas na 50 mga panitik.',
	'autocreatewiki-similar-wikis' => 'Nasa ibaba ang nalikha nang mga wiki na hinggil sa paksang ito. Iminumungkahi namin ang pamamatnugot sa isa sa mga ito.',
	'autocreatewiki-invalid-username' => 'Hindi tanggap ang pangalang pangtagagamit na ito.',
	'autocreatewiki-busy-username' => 'May nakakuha na ng pangalang pangtagagamit na ito.',
	'autocreatewiki-blocked-username' => 'Hindi mo malilikha ang akawnt.',
	'autocreatewiki-user-notloggedin' => 'Nalikha ang akawnt mo pero hindi nakalagda!',
	'autocreatewiki-empty-language' => 'Pakipili ang wika na para sa wiki.',
	'autocreatewiki-empty-category' => 'Paki pumili ng isang kategorya.',
	'autocreatewiki-empty-wikiname' => 'Hindi maaaring walang laman ang pangalan ng wiki.',
	'autocreatewiki-empty-username' => 'Hindi maaaring walang laman ang pangalang pangtagagamit.',
	'autocreatewiki-empty-password' => 'Hindi maaaring walang laman ang hudyat.',
	'autocreatewiki-empty-retype-password' => 'Hindi maaaring walang laman ang muling imakinilya ang hudyat.',
	'autocreatewiki-category-label' => 'Kategorya:',
	'autocreatewiki-category-other' => 'Iba pa',
	'autocreatewiki-set-username' => 'Itakda muna ang pangalan ng tagagamit.',
	'autocreatewiki-invalid-category' => 'Hindi katanggap-tanggap na halaga ng kategorya.
Mangyaring pumili ng angkop mula sa listahang bumabagsak pababa.',
	'autocreatewiki-invalid-language' => 'Hindi katanggap-tanggap na halaga ng wika.
Mangyaring pumili ng angkop mula sa listahang bumabagsak pababa.',
	'autocreatewiki-invalid-retype-passwd' => 'Mangyaring pakimakinilya ulit ang kaparehong hudyat na katulad ng nasa itaas',
	'autocreatewiki-invalid-birthday' => 'Hindi tanggap na petsa ng kaarawan',
	'autocreatewiki-log-title' => 'Nililikha na ang wiki mo',
	'autocreatewiki-step0' => 'Sinisimulan ang pagsasagawa ...',
	'autocreatewiki-stepdefault' => 'Tumatakbo ang pagsasagawa, pakihintay ...',
	'autocreatewiki-errordefault' => 'Hindi tapos ang pagsasagawa ...',
	'autocreatewiki-step1' => 'Nililikha ang sisidlan ng mga larawan ...',
	'autocreatewiki-step2' => 'Nililikha ang kalipunan ng dato ...',
	'autocreatewiki-step3' => 'Itinatalaga ang likas na nakatakdang kabatiran sa loob ng kalipunan ng dato ...',
	'autocreatewiki-step4' => 'Kinokopya ang likas na nakatakdang mga larawan at logo ...',
	'autocreatewiki-step5' => 'Itinatalaga ang likas na nakatakdang mga nagbabago sa loob ng kalipunan ng dato ...',
	'autocreatewiki-step6' => 'Itinatalaga ang likas na nakatakdang mga talahanayan sa kalipunan ng dato ...',
	'autocreatewiki-step7' => 'Itinatakda ang pangsimula ng wika ...',
	'autocreatewiki-step8' => 'Itinatakda ang mga pangkat ng tagagamit at mga kategorya ...',
	'autocreatewiki-step9' => 'Itinatakda ang mga bagay na nagpapabagu-bago para sa bagong wiki ...',
	'autocreatewiki-step10' => 'Itinatakda ang mga pahina sa lunduyang wiki ...',
	'autocreatewiki-step11' => 'Ipinapadala ang e-liham sa tagagamit ...',
	'autocreatewiki-redirect' => 'Sa halip ay pinapapunta sa bagong wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Maligayang bati!',
	'autocreatewiki-welcometalk-log' => 'Pambati sa Pagdating',
	'autocreatewiki-regex-error-comment' => 'ginagamit sa loob ng wiki na $1 (buong teksto: $2)',
	'autocreatewiki-step2-error' => 'Umiiral ang kalipunan ng dato!',
	'autocreatewiki-step3-error' => 'Hindi maitakda ang likas na nakatakdang kabatiran sa loob ng kalipunan ng dato!',
	'autocreatewiki-step6-error' => 'Hindi maitakda ang likas na nakatakdang mga talahanayan sa loob ng kalipunan ng dato!',
	'autocreatewiki-step7-error' => 'Hindi makopya ang pangsimulang kalipunan ng dato para sa wika!',
	'autocreatewiki-protect-reason' => 'Bahagi ng opisyal na ugnayang-mukha',
	'autocreatewiki-welcomesubject' => 'Nalikha na ang $1!',
	'autocreatewiki-welcomebody' => 'Kumusta $2!

Nalikha na ang wiki mo! Tingnan na: <$1>

Handa ka nang magsimula? Nagdagdag kami ng ilang mga kawing sa iyong pahina ng usapan (<$5>) upang matulungan ka sa pagsisimula at upang hikayatin ka na galugarin ang maraming makatutulong na mga pook sa paligid ng Wikia. Kung mayroon kang anumang mga katanungan o nakakaramdam na tila naliligaw nang bahagya, tumugon sa e-liham na ito o tingnan ang aming mga pahina ng Tulong <http://help.wikia.com>.

Matitingnan mo rin ang blog ng Tagapagtatag at Tagapangasiwa <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> at ang blog ng tauhan ng Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> kung saan ka makakakuha ng mga payo at mga kaparaanan, kabatiran patungkol sa bagong mga tampok at bagong mga bagay na nagaganap sa Wikia.

Maligayang pamamatnugot!

$3
Suporta ng Pamayanan ng Wikia
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Nais makatanggap ng mas kaunting mga mensahe mula sa amin? Maaari kang huwag nang magpasipi o baguhin ang iyong mga kanaisan ng e-liham dito: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk' => "== Maligayang pagdating! ==
<div style=\"font-size:120%; line-height:1.2em;\">Kumusta \$1 -- natutuwa kaming magkaroon ng '''\$4''' bilang bahagi ng pamayakan ng Wikia!

Ngayon mayroon ka nang isang buong pook sa sangkasaputan na pupunuan ng kabatiran, mga larawan at mga bidyo tungkol sa paborito mong paksa. Subalit sa ngayon, mga pahinang walang laman lamang ang nakatitig sa iyo... Nakakatakot, hindi ba? Narito ang ilang mga paraan upang makapagsimula.

* '''Ipakilala ang iyong paksa'' sa pangharapang pahina. Ito na ang iyong pagkakataon upang maipaliwanag sa mga mambabasa mo kung saan patungkol ang iyong paksa. Magsulat ng marami hangga't gusto mo! Ang paglalarawan mo ay maaaring kumawing sa lahat ng mahahalagang mga pahina sa pook mo.

* '''Magsimula ng ilang bagong mga pahina''' -- ayos lang kung isang pangungusap o dalawa lamang upang makapag-umpisa. Huwag bayaang titigan ka nang may katamlayan ng pahinang walang laman! Ang wiki ay talagang patungkol sa pagdaragdag at pagbabago ng mga bagay habang nagtatagal. Makapagdaragdag ka rin ng mga larawan at mga bidyo, upang mapunuan ang pahina at upang magawa itong mas kahali-halina.

At pagkaraan ay magpatuloy lamang nang magpatuloy! Ang mga tao ay mahihilig dumalaw sa mga wiki kung mayroong maraming mga bagay na mababasa at matatanaw, kung kaya't magpatuloy sa pagdaragdag pa ng mga bagay-bagay, at makakaakit ka ng mga mambabasa at mga patnugot. Maraming nararapat na gawin, subalit huwag mag-alala -- ngayong araw na ito ang iyong unang araw, at sagana ka sa panahon. Bawat isang wiki ay nagsisimula sa ganiyan din paraan -- unti-unti lamang bawat panahon, na nagsisimula sa unang mangilan-ngilang mga pahina, hanggang sa lumaki na ito at naging isang pagkalaki-laki at abalang pook.

Kung mayroong kang mga katanungan, mapapadalhan mo kami ng e-liham sa pamamagitan ng aming [[Special:Contact|pormularyo ng pakikipag-ugnayan]]. Magsaya ka!

-- [[User:\$2|\$3]] <staff /></div>",
);

/** толышә зывон (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'autocreatewiki' => 'Тожә вики сохтеј',
	'autocreatewiki-page-title-default' => 'Тожә вики сохте',
	'createwiki' => 'Тожә вики сохте',
	'autocreatewiki-category-select' => 'Бывыжнән',
);

/** Turkish (Türkçe)
 * @author Gizemb
 * @author Suelnur
 */
$messages['tr'] = array(
	'autocreatewiki' => 'Yeni bir wiki oluştur',
	'autocreatewiki-page-title-default' => 'Yeni bir wiki oluştur',
	'autocreatewiki-page-title-answers' => 'Yeni bir yanıt sitesi oluştur',
	'createwiki' => 'Yeni bir wiki oluştur',
	'autocreatewiki-chooseone' => 'Birini seç',
	'autocreatewiki-required' => '$1 = gerekli',
	'autocreatewiki-web-address' => 'Web adresi:',
	'autocreatewiki-category-select' => 'Birini seç',
	'autocreatewiki-remember' => 'Beni hatırla',
	'autocreatewiki-create-account' => 'Bir hesap oluştur',
	'autocreatewiki-haveaccount-question' => 'Zaten bir Wikia hesabınız var mı?',
	'autocreatewiki-info-category-default' => 'Bu, ziyaretçilerinizin wikinizi bulmasını kolaylaştıracak.',
	'autocreatewiki-info-category-answers' => 'Bu, ziyaretçilerinizin cevap sitenizi bulmasını kolaylaştıracak.',
	'autocreatewiki-info-language' => 'Bu, ziyaretçileriniz için öntanımlı dil olacak.',
	'autocreatewiki-info-email-address' => 'E-posta adresiniz Wikia üzerinde kimseye gösterilmeyecek.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-empty-field' => 'Lütfen bu alanı doldurun.',
	'autocreatewiki-invalid-username' => 'Bu kullanıcı adı geçersiz.',
	'autocreatewiki-busy-username' => 'Bu kullanıcı adı daha önce alınmış.',
	'autocreatewiki-blocked-username' => 'Hesap oluşturamazsın.',
	'autocreatewiki-user-notloggedin' => 'Hesabın oluşturuldu ama giriş yapmadın!',
	'autocreatewiki-empty-language' => 'Lütfen wiki için dil seçin.',
	'autocreatewiki-empty-category' => 'Lütfen bir kategori seçin.',
	'autocreatewiki-empty-wikiname' => 'Wikinin adı boş olamaz.',
	'autocreatewiki-empty-username' => 'Kullanıcı adı kısmı boş olamaz.',
	'autocreatewiki-empty-password' => 'Parola kısmı boş olamaz.',
	'autocreatewiki-empty-retype-password' => 'Tekrar girilen parola kısmı boş olamaz.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Diğer',
	'autocreatewiki-set-username' => 'Önce kullanıcı adı belirleyin.',
	'autocreatewiki-invalid-retype-passwd' => 'Lütfen yukarıdaki parolayı aynen girin',
	'autocreatewiki-invalid-birthday' => 'Geçersiz doğum tarihi',
	'autocreatewiki-log-title' => 'Wikiniz oluşturuldu',
	'autocreatewiki-stepdefault' => 'İşlem yapılıyor, lütfen bekleyiniz...',
	'autocreatewiki-errordefault' => 'İşlem tamamlanmadı...',
	'autocreatewiki-step1' => 'Görsel dizini oluşturuluyor ...',
	'autocreatewiki-step2' => 'Veri tabanı oluşturuluyor...',
	'autocreatewiki-congratulation' => 'Tebrikler!',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'autocreatewiki' => 'Яңа вики ясау',
	'autocreatewiki-desc' => 'Катнашучылар соравы буенча Вики-фабрикада вики ясау',
	'autocreatewiki-page-title-default' => 'Яңа вики ясау',
	'autocreatewiki-page-title-answers' => 'Яңа җаваплар сайты ясау',
	'createwiki' => 'Яңа вики ясау',
	'autocreatewiki-chooseone' => 'Исемлектән сайлау',
	'autocreatewiki-required' => '$1 - мәҗбүри',
	'autocreatewiki-web-address' => 'Веб-адрес:',
	'autocreatewiki-category-select' => 'Сайлагыз',
	'autocreatewiki-language-top' => '$1 иң күп кулланылган телләр',
	'autocreatewiki-language-all' => 'Барлык телләр',
	'autocreatewiki-remember' => 'Мине истә калдыру',
	'autocreatewiki-create-account' => 'Яңа кулланучы теркәү',
	'autocreatewiki-haveaccount-question' => 'Сезнең Викиядә хисап язмасы бармы?',
	'autocreatewiki-info-domain' => 'Эләүдә сезнең тема өчен ачкыч сүз булырдай сүзне куллану яхшырак булыр.',
	'autocreatewiki-info-topic' => 'Кыскача тасвирлама өстәгез, мәсәлән, "Габдулла Тукай" яки "ТВ тапшыруы".',
	'autocreatewiki-info-category-default' => 'Бу кунакларга сезнең викине табарга ярдәм итәчәк.',
	'autocreatewiki-info-category-answers' => 'Бу кунакларга сезнең җаваплар сайтын табарга ярдәм итәчәк.',
	'autocreatewiki-info-language' => 'Сезнең вики кунаклары өчен интерфейс теле',
	'autocreatewiki-info-email-address' => 'Сезнең электрон әрҗәгез, Викиядә беркемгә дә күрсәтелми.',
	'autocreatewiki-info-realname' => 'Әгәр сез аны күрсәтсәгез, ул сезнең эшегезнең авторлыгын атар өчен кулланылачак.',
	'autocreatewiki-info-birthdate' => 'Wikia барлык кулланучылардан да чын туган көннәрен күрсәтүне таләп итә, бу сайтның федераль таләпләргә туры килүен тәэмин итәр өчен кирәк һәм куркынычсызлык чарасы да булып тора.',
	'autocreatewiki-info-blurry-word' => 'Сез бу урында күрә торган ярымсөртелгән сүзләрне, зинһар өчен, язсагыз иде. Бу хисап язмаларының автоматик рәвештә ясалуыннан сакланыр өчен эшләнелә.',
	'autocreatewiki-info-terms-agree' => 'Викине оештырып һәм хисап язмасын төзеп, сез <a href="http://www.wikia.com/wiki/Terms_of_use">Wikia куллану шартлары</a> белән килешәсез.',
	'autocreatewiki-info-staff-username' => '<b>Персонал өчен генә:</b> Әйтелгән кулланучы оештыручы буларак күрсәтелгән.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-limit-day' => 'Wikia бер көн эчендә ясалырга мөмкин булган викилар санын узды ($1).',
	'autocreatewiki-limit-creation' => 'Сез 24 сәгать эчендә ясарга мөмкин булган викилар санын уздыгыз ($1).',
	'autocreatewiki-empty-field' => 'Зинһар өчен, бу кырны тутырыгыз.',
	'autocreatewiki-bad-name' => 'Исемдә махсус символлар (мәсәлән, @ яки $) була алмый, һәм аны юл хәрефләре белән буш арасыз язылган бер сүз белән күрсәтергә кирәк',
	'autocreatewiki-invalid-wikiname' => 'Исемдә махсус символлар (мәсәлән, $ яки #) була алмый һәм буш килеш калырга тиеш түгел.',
	'autocreatewiki-violate-policy' => 'Бу вики исемендә исем кушу кагыйдәләрен бозучы сүзләр бар',
	'autocreatewiki-name-taken' => 'Мондый URL белән бер вики бар инде. Сез <a href="http://$1.wikia.com">http://$1.wikia.com</a>  проектына кушыла яки башка адрес сайлый аласыз.',
	'autocreatewiki-name-too-short' => 'Бу исем артык кыска. Зинһар өчен, кимендә 3 символдан торган исем сайлагыз',
	'autocreatewiki-name-too-long' => 'Бу исем артык озын. Зинһар өчен, 50 символдан артмаган исем сайлагыз.',
	'autocreatewiki-similar-wikis' => 'Түбәндә бу темага кагылган һәм инде эшләп килүче викилар китерелгән. Без аларның берсендә катнашырга тәкъдим итәбез.',
	'autocreatewiki-invalid-username' => 'Тыелган кулланучы исеме.',
	'autocreatewiki-busy-username' => 'Бу кулланучы исеме кулланыла инде.',
	'autocreatewiki-blocked-username' => 'Сезгә хисап язмасы төземәсәгез дә була.',
	'autocreatewiki-user-notloggedin' => 'Сезнең хисап язмасы төзелгән, ләкин сез системага кермәдегез!',
	'autocreatewiki-empty-language' => 'Зинһар өчен, викиегез өчен тел сайлагыз.',
	'autocreatewiki-empty-category' => 'Зинһар өчен, бер төркемне сайлагыз.',
	'autocreatewiki-empty-wikiname' => 'Вики исеме буш кала алмый.',
	'autocreatewiki-empty-username' => 'Кулланучы исеме буш кала алмый.',
	'autocreatewiki-empty-password' => 'Серсүз буш кала алмый',
	'autocreatewiki-empty-retype-password' => 'Серсүзне кабатлау буш була алмый.',
	'autocreatewiki-category-label' => 'Төркем:',
	'autocreatewiki-category-other' => 'Башка',
	'autocreatewiki-set-username' => 'Башта кулланучы исемен сайлагыз.',
	'autocreatewiki-invalid-category' => 'Ялгыш төркем.
Зинһар өчен, чыгучы исемлектән мөмкин булган вариантны сайлагыз.',
	'autocreatewiki-invalid-language' => 'Ялгыш, мөмкин булмаган тел.
Зинһар өчен, килеп чыгучы исемлектән мөмкин булган вариантны сайлагыз.',
	'autocreatewiki-invalid-retype-passwd' => 'Зинһар өчен, шул ук серсүзне яңадан языгыз',
	'autocreatewiki-invalid-birthday' => 'Хаталы туган көн.',
	'autocreatewiki-log-title' => 'Сезнең вики ясала',
	'autocreatewiki-step0' => 'Инициализация...',
	'autocreatewiki-stepdefault' => 'Эш бара, зинһар, көтегез...',
	'autocreatewiki-errordefault' => 'Процесс тукталмады...',
	'autocreatewiki-step1' => 'Сурәтләр директориясен эшләү . . .',
	'autocreatewiki-step2' => 'Мәгълүматлар базасын оештыру ...',
	'autocreatewiki-step3' => 'Мәгълүматлар җыелмасында куелган мәгълүматны урнаштыру...',
	'autocreatewiki-step4' => 'Куелган сурәтләрне һәм логотипны күчереп алу . . .',
	'autocreatewiki-step5' => 'Мәгълүматлар җыелмасында стандарт үзгәрешлеләрне урнаштыру...',
	'autocreatewiki-step6' => 'Мәгълүматлар җыелмасында стандарт җәдвәлләрне урнаштыру...',
	'autocreatewiki-step7' => 'Башлангыч телне урнаштыру...',
	'autocreatewiki-step8' => 'Катнашучылар төркемнәрен һәм төркемнәрне көйләү...',
	'autocreatewiki-step9' => 'Яңа вики өчен үзгәрелешлеләрне урнаштыру...',
	'autocreatewiki-step10' => 'Үзәк викидагы битләрне көйләү...',
	'autocreatewiki-step11' => 'Катнашучының электрон почтасына хат җибәрү...',
	'autocreatewiki-redirect' => 'Яңа викига юнәлтү: $1',
	'autocreatewiki-congratulation' => 'Котлыйбыз!',
	'autocreatewiki-welcometalk-log' => 'Сәламләү хаты',
	'autocreatewiki-regex-error-comment' => '$1 викисында кулланылган (тулы текст:$2)',
	'autocreatewiki-step2-error' => 'Мәгълүматлар җыелмасы юк!',
	'autocreatewiki-step3-error' => 'Мәгълүматлар җыелмасында алдан куелган белешмәләрне урнаштырып булмый!',
	'autocreatewiki-step6-error' => 'Мәгълүматлар җыелмасында җәдвәлләрне урнаштыру мөмкин түгел!',
	'autocreatewiki-step7-error' => 'Тел өчен башлангыч мәгълүматлар базасын күчермәләү мөмкин түгел!',
	'autocreatewiki-protect-reason' => 'Рәсми интерфейсның бер өлеше',
	'autocreatewiki-welcomesubject' => '$1 уңышлы ясалды!',
	'autocreatewiki-welcomebody' => 'Исәнмесез,$2.

Сезнең вики төзелде! Күз салыгыз: <$1>

Башларга әзерсезме? Без сезнең фикер алышу сәхифәсенә (<$5>) берничә сылтама өстәдек, алар сезгә эшне башларга ярдәм итәрләр һәм Викиянең күп санлы файдалы өлкәләрен күрсәтерләр. Әгәр дә сезнең нинди дә булса сорауларыгыз була икән, яки үзегезне югалып калгандай хис итәсез икән, бу хатка җавап языгыз яисә безнең Белешмәлек <http://help.wikia.com> белән танышыгыз.

Шулай ук  сез, файдалы киңәшләр, Викиянең яңа мөмкинлекләре һәм яңа кушымталар турында мәгълүмат табар өчен,  Үзәк Викидә идарәчеләр өчен блогны <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> яки Викия хезмәткәрләре блогын  <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>  карый аласыз.

Хәерле сәгатьтә!

$3
Викия җәмгыяте
<http://community.wikia.com/wiki/User:$4>


___________________________________________
* Бездән хатларның азрак килүен телисезме? Сез шәхси көйләнмәләр битендә (http://community.wikia.com/Special:Preferences ) таратылмага  язылуны туктата яки үзгәртә аласыз.',
	'autocreatewiki-welcometalk' => "== Рәхим итегез! ==
<div style=\"font-size:120%; line-height:1.2em;\">Исәнмесез, \$1 — Без '''\$4''' Wikia җәмгыятенең бер өлеше булуына шатбыз!

Хәзер сезнең яраткан темагызга  мәгълүмат, фотографияләр һәм видео өстәү өчен тулы бер сайт бар. Ләкин хәзер сезгә буш битләр карап торалар... Куркыныч, әйеме? Менә эшне башлау өчен кайбер ысуллар.

* '''Беренче биттә темагызны күрсәтегез'''. Бу сезнең укучыларыгызга темагызның ни хакында булуын аңлатыр өчен мөмкинлек. Күпме телисез – шулкадәр языгыз! Сезнең тасвирламагыз сезнең сайттагы барлык мөһим битләрне бәйли ала.

* '''Яңа битләр башлагыз'''. Башлау өчен бер-ике җөмлә дә җитә. Буш битләр эшләмәгез! Викиның мәгънәсе сезнең алга таба хәрәкәтегез дәвамында мәкаләләр өстәү һәм тулыландырудан гыйбарәт. Шулай ук, сез фото һәм видео өсти аласыз, бу мәкаләне кызыклырак һәм тулырак итәчәк.

Ә аннары барыгыз гына! Кешеләр уку һәм карау өчен күп материал булган викиларга керергә ярата, шуңа күрә материал өстәүне дәвам итегез һәм сезгә укучылар һәм төзәтүчеләр тартылыр. Күп нәрсә эшлисе булыр, тик курыкмагыз – бүген беренче генә көн, ә сезнең вакыт күп. Һәр вики нәкъ шулай башлана – әкренләп, башта берничә бит, соңрак кына зур, тере сайт була.

Әгәр сорауларыгыз була икән, сез [[Special:Contact|элемтәгә]] чыга аласыз. Уңышлар!

— [[User:\$2|\$3]] <staff /></div>",
);

/** Central Atlas Tamazight (ⵜⴰⵎⴰⵣⵉⵖⵜ)
 * @author Tifinaghes
 */
$messages['tzm'] = array(
	'autocreatewiki' => 'ⵔⵏⵓ ⵡⵉⴽⵉ ⵜⴰⵎⴰⵢⵏⵓⵜ',
	'autocreatewiki-page-title-default' => 'ⵔⵏⵓ ⵡⵉⴽⵉ ⵜⴰⵎⴰⵢⵏⵓⵜ',
	'autocreatewiki-category-select' => 'ⵙⵜⵉ ⵢⴰⵜ',
	'autocreatewiki-language-top' => '10 ⵏ ⵜⵓⵜⵍⴰⵢⵉⵏ ⴰⴽⴽ ⵢⵓⴼⵏ',
	'autocreatewiki-language-all' => 'ⵎⴰⵕⵕⴰ ⵜⵓⵜⵍⴰⵢⵉⵏ',
	'autocreatewiki-title-template' => '$1 ⵡⵉⴽⵉ',
	'autocreatewiki-category-label' => 'ⵜⴰⴳⴳⴰⵢⵜ:',
	'autocreatewiki-welcometalk-wall-title' => 'ⴰⵏⵙⵓⴼ!',
);

/** Ukrainian (українська)
 * @author A1
 * @author AS
 * @author Ahonc
 * @author NickK
 * @author Prima klasy4na
 * @author Steve.rusyn
 * @author Vox
 * @author Тест
 */
$messages['uk'] = array(
	'autocreatewiki' => 'Створити нову Вікі',
	'autocreatewiki-desc' => 'Створити вікі у WikiFactory з запитів користувачів',
	'autocreatewiki-page-title-default' => 'Створити нову Вікі',
	'createwiki' => 'Створити нову Вікі',
	'autocreatewiki-chooseone' => 'Виберіть зі списку',
	'autocreatewiki-required' => "$1 = обов'язково",
	'autocreatewiki-web-address' => 'Веб-адреса:',
	'autocreatewiki-category-select' => 'Виберіть одну',
	'autocreatewiki-language-top' => '$1 {{PLURAL:$1|найважливіша мова|найважливіші мови|найважливіших мов}}',
	'autocreatewiki-language-all' => 'Всі мови',
	'autocreatewiki-remember' => "Запам'ятати мене",
	'autocreatewiki-create-account' => 'Створити обліковий запис',
	'autocreatewiki-haveaccount-question' => 'Ви вже маєте обліковий запис у Вікії?',
	'autocreatewiki-info-domain' => 'Краще використати слово, що може бути ключовим для вашої теми при пошуку.',
	'autocreatewiki-info-topic' => 'Додайте короткий опис, наприклад, "Зоряні війни" або "ТВ-шоу".',
	'autocreatewiki-info-category-default' => 'Це допоможе відвідувачам знайти вашу вікі.',
	'autocreatewiki-info-language' => 'Ця мова використовуватиметься за замовчанням для відвідувачів вашої вікі.',
	'autocreatewiki-info-email-address' => 'Ваша адреса електронної пошти ніколи не відображається нікому на Wikia.',
	'autocreatewiki-info-birthdate' => 'Вікія зобов’язує всіх користувачів указувати свою справжню дату народження; це є запобіжним засобом, дозволяє забезпечити відповідність сайту вимогам федеральних правил.',
	'autocreatewiki-info-blurry-word' => 'Для захисту від автоматичного створення облікових записів, будь ласка, введіть розмиті слова, що ви бачите, у надане поле.',
	'autocreatewiki-info-terms-agree' => 'Створюючи вікі й обліковий запис користувача, ви погоджуєтеся з <a href="http://www.wikia.com/wiki/Terms_of_use">умовами використання Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Лише для персоналу:</b> Вказаний користувач буде зазначений як засновник.',
	'autocreatewiki-title-template' => 'Вікі $1',
	'autocreatewiki-empty-field' => 'Будь ласка, заповніть це поле.',
	'autocreatewiki-bad-name' => 'Назва не може містити спеціальних символів (як, наприклад, $ чи @) і має бути одним словом, написаним малими літерами без пробілів.',
	'autocreatewiki-invalid-wikiname' => 'Назва не може містити спеціальних символів (як, наприклад, $ або @) і не може бути пустою',
	'autocreatewiki-violate-policy' => 'Ця назва вікі містить слова, що порушують наші правила йменування',
	'autocreatewiki-name-taken' => 'Вікі з цією URL адресою вже існує. Ви можете почати редагування в <a href="http://<span class=" notranslate"="">$1.wikia.com">http:// $1 . wikia.com</a> або вибрати іншу адресу.',
	'autocreatewiki-name-too-short' => 'Ця адреса занадто коротка. Будь ласка, оберіть адресу, що містить щонайменше 3 символи.',
	'autocreatewiki-name-too-long' => 'Ця адреса занадто довга. Будь ласка, оберіть адресу, яка має не більше 50 символів.',
	'autocreatewiki-similar-wikis' => 'Нижче наведені вже існуючі вікі з такою тематикою. Ми пропонуємо редагування однієї з них.',
	'autocreatewiki-invalid-username' => 'Неприпустиме ім’я користувача.',
	'autocreatewiki-busy-username' => "Це ім'я користувача вже зайнято.",
	'autocreatewiki-blocked-username' => 'Ви не можете створити обліковий запис.',
	'autocreatewiki-user-notloggedin' => 'Ваш обліковий запис був створений, але ви не ввійшли в систему!',
	'autocreatewiki-empty-language' => 'Будь ласка, виберіть мову для вікі.',
	'autocreatewiki-empty-category' => 'Будь ласка, виберіть категорію.',
	'autocreatewiki-empty-wikiname' => 'Назва вікі не може бути порожньою.',
	'autocreatewiki-empty-username' => "Ім'я користувача не може бути порожнім.",
	'autocreatewiki-empty-password' => 'Пароль не може бути порожнім.',
	'autocreatewiki-empty-retype-password' => 'Підтвердження пароля не може бути порожнім.',
	'autocreatewiki-category-label' => 'Категорія:',
	'autocreatewiki-category-other' => 'Інше',
	'autocreatewiki-set-username' => 'Спочатку оберіть ім’я користувача.',
	'autocreatewiki-invalid-category' => 'Неприпустиме значення категорії.
Будь ласка, виберіть належне з випадаючого списку.',
	'autocreatewiki-invalid-language' => 'Неприпустиме значення мови.
Будь ласка, виберіть належне з випадаючого списку.',
	'autocreatewiki-invalid-retype-passwd' => 'Будь ласка, введіть той самий пароль, що ви ввели вище',
	'autocreatewiki-invalid-birthday' => 'Неправильна дата народження',
	'autocreatewiki-log-title' => 'Ваша вікі створюється!',
	'autocreatewiki-step0' => 'Процес ініціализації…',
	'autocreatewiki-stepdefault' => 'Процес запущено, будь ласка, зачекайте...',
	'autocreatewiki-errordefault' => 'Процес не було завершено...',
	'autocreatewiki-step1' => 'Створення папки зображень...',
	'autocreatewiki-step2' => 'Створення бази даних...',
	'autocreatewiki-step3' => 'Налаштування інформації за замовчуванням в базі даних...',
	'autocreatewiki-step4' => 'Копіювання зображень за замовчанням і логотипу...',
	'autocreatewiki-step5' => 'Налаштування змінних за замовчуванням в базі даних...',
	'autocreatewiki-step6' => 'Налаштування таблиць за замовчанням в базі даних...',
	'autocreatewiki-step7' => 'Налаштування початкової мови...',
	'autocreatewiki-step8' => 'Створення груп користувачів та категорій...',
	'autocreatewiki-step9' => 'Налаштування змінних для нової вікі...',
	'autocreatewiki-step10' => 'Налаштування сторінок на центральній вікі...',
	'autocreatewiki-step11' => 'Надсилання електронної пошти користувачеві...',
	'autocreatewiki-redirect' => 'Перенаправлення на нову вікі: $1...',
	'autocreatewiki-congratulation' => 'Вітаємо!',
	'autocreatewiki-welcometalk-log' => 'Повідомлення привітання',
	'autocreatewiki-regex-error-comment' => 'використано в вікі $1 (весь текст: $2)',
	'autocreatewiki-step2-error' => 'База даних існує!',
	'autocreatewiki-step3-error' => 'Не вдалося налаштувати інформацію за замовчуванням в базі даних!',
	'autocreatewiki-step6-error' => 'Не вдалося налаштувати таблиці за замовчуванням у базі даних!',
	'autocreatewiki-step7-error' => 'Не вдалося скопіювати початкову бази даних для мови!',
	'autocreatewiki-protect-reason' => 'Частина офіційного інтерфейсу',
	'autocreatewiki-welcomesubject' => '$1 було створено!',
	'autocreatewiki-welcomebody' => 'Вітаємо вас, $2.

Вікі з вашого запиту тепер доступна за адресою <$1>. Ми сподіваємося, що ви скоро почнете її редагування.

Ми додали деяку інформацію та поради на вашу сторінку обговорення користувача (<$5>), щоб допомогти вам розпочати роботу.

Якщо у вас виникли якісь проблеми, ви можете звернутися по допомогу до спільноти в вікі на <http: www.wikia.com/wiki/forum:help_desk="">, або за електронною поштою community@wikia.com. Ви можете також відвідати наш IRC чат-канал #wikia <http: irc.wikia.com="">.

Зі мною можна зв’язатися напряму за електронною поштою або на моїй сторінці обговорення, якщо у вас є питання чи зауваження.

Удачі в розвитку проекту!

Команда спільноти Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk-wall-title' => 'Ласкаво просимо!',
	'autocreatewiki-welcometalk' => "== Ласкаво просимо! ==
<div style=\"font-size:120%; line-height:1.2em;\">Вітаємо, \$1 — ми раді, що '''\$4''' — частина спільноти Wikia!

Тепер вам слід розпочати роботу. Ось деякі поради:

* '''Опишіть свою тему''' на першій сторінці, нехай читачі одразу зрозуміють, що на них очікує!

* '''Створіть кілька сторінок''' — можна почати з кількох речень, а потім додавати картинки і відео.

А далі просто рухайтесь вперед! Звернутися до розробників можна  [[Special:Contact|тут]]. Успіхів!

— [[User:\$2|\$3]] <staff /></div>",
);

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'autocreatewiki' => "Säta uz' wiki",
	'autocreatewiki-page-title-default' => "Säta uz' wiki",
	'createwiki' => "Säta uz' wiki",
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-category-label' => 'Kategorii:',
);

/** Vietnamese (Tiếng Việt)
 * @author Thanhtai2009
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'autocreatewiki' => 'Tạo wiki mới',
	'autocreatewiki-info-terms-agree' => 'Bằng việc tạo ra một wiki và một tài khoản thành viên, bạn đồng ý với <a href="http://www.wikia.com/wiki/Terms_of_use">Điều khoản Sử dụng của Wikia</a>',
	'autocreatewiki-title-template' => 'Wikia $1',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'autocreatewiki-create-account' => 'שאַפֿן אַ קאנטע',
);

/** Chinese (中文)
 */
$messages['zh'] = array(
	'autocreatewiki-page-title-default' => '申请wiki',
	'createwiki' => '申請Wiki',
	'autocreatewiki-info-language' => '的預設語文',
	'autocreatewiki-welcomesubject' => '$1 已建立!',
	'autocreatewiki-welcomebody' => '嗨 $2,

歡迎加入Wikia社群。相信很快能看到你對此站的貢獻。

如果您在使用上有任何問題，可先查閱說明頁面<http://help.wikia.com> (英文)，或是查看中文的[[w:c:zh:Category:中文說明|使用說明]]

祝您使用快

Wikia 社群團隊',
);

/** Chinese (China) (中文（中国大陆）‎)
 */
$messages['zh-cn'] = array(
	'autocreatewiki-page-title-default' => '申请wiki',
	'createwiki' => '申请wiki',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Sam Wang
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'autocreatewiki' => '创建新的维基',
	'autocreatewiki-desc' => '按用户的请求在维基出厂配置中创建维基',
	'autocreatewiki-page-title-default' => '创建新的维基',
	'autocreatewiki-page-title-answers' => '创建新的问答网站',
	'createwiki' => '创建新的维基',
	'autocreatewiki-chooseone' => '选择一个',
	'autocreatewiki-required' => '$1 = 必选项',
	'autocreatewiki-web-address' => '网站地址：',
	'autocreatewiki-category-select' => '选择一个',
	'autocreatewiki-language-top' => '最常用的$1种语言',
	'autocreatewiki-language-all' => '所有语言',
	'autocreatewiki-remember' => '记住我',
	'autocreatewiki-create-account' => '创建帐户',
	'autocreatewiki-haveaccount-question' => '已经有Wikia帐户？',
	'autocreatewiki-info-domain' => '最好使用一个可能会搜索到你的主题的关键字。',
	'autocreatewiki-info-topic' => '添加简短的描述，如“星球大战”或“电视节目”。',
	'autocreatewiki-info-category-default' => '这会帮助访客找到您的维基。',
	'autocreatewiki-info-category-answers' => '这会帮助访客找到您的问答网站。',
	'autocreatewiki-info-language' => '这将是您的维基访客的默认语言。',
	'autocreatewiki-info-email-address' => '我们绝不会将您的电子邮件地址显示给Wikia上的任何人。',
	'autocreatewiki-info-realname' => '如果您选择提供此信息，这将用来表明这些工作是由您完成的。',
	'autocreatewiki-title-template' => '$1Wiki',
	'autocreatewiki-limit-day' => '今天已超过了Wikia每日维基创建数上限($1)。',
	'autocreatewiki-limit-creation' => '您已超过了所允许的24小时维基创建数的上限($1)。',
	'autocreatewiki-empty-field' => '请填写此栏。',
	'autocreatewiki-bad-name' => '名称不能包含特殊字符（如$或@），且必须是不含空格、由小写字母组成的单词。',
	'autocreatewiki-invalid-wikiname' => '名称不能包含特殊字符（如$或@），且不能为空。',
	'autocreatewiki-violate-policy' => '此维基名中含有违反命名准则的字词。',
	'autocreatewiki-name-too-short' => '此地址过短，请选择一个至少含3个字符的地址。',
	'autocreatewiki-name-too-long' => '此地址过长，请选择一个最多含50个字符的地址。',
	'autocreatewiki-similar-wikis' => '下面是已经创建的关于该主题的维基。我们建议您参与编辑其中之一。',
	'autocreatewiki-invalid-username' => '此用户名无效。',
	'autocreatewiki-busy-username' => '此用户名已有人使用。',
	'autocreatewiki-blocked-username' => '无法创建帐户。',
	'autocreatewiki-user-notloggedin' => '您的帐户已创建，但未登入！',
	'autocreatewiki-empty-language' => '请选择维基的语言。',
	'autocreatewiki-empty-category' => '请选择一个类别。',
	'autocreatewiki-empty-wikiname' => '维基的名称不能为空。',
	'autocreatewiki-empty-username' => '用户名不能为空。',
	'autocreatewiki-empty-password' => '密码不能为空。',
	'autocreatewiki-empty-retype-password' => '重新键入密码栏不能为空。',
	'autocreatewiki-category-label' => '类别：',
	'autocreatewiki-category-other' => '其他',
	'autocreatewiki-set-username' => '请先设置用户名。',
	'autocreatewiki-invalid-category' => '类别值无效。
请从下拉列表中选择适当的类别。',
	'autocreatewiki-invalid-language' => '语言值无效。
请从下拉列表中选择适当的语言。',
	'autocreatewiki-invalid-retype-passwd' => '请重新输入与上栏密码相同的密码。',
	'autocreatewiki-invalid-birthday' => '出生日期无效。',
	'autocreatewiki-log-title' => '正在创建您的维基',
	'autocreatewiki-step0' => '正在进行初始化处理...',
	'autocreatewiki-stepdefault' => '进程正在运行，请稍候...',
	'autocreatewiki-errordefault' => '进程还没结束 …',
	'autocreatewiki-step1' => '正在创建图像文件夹...',
	'autocreatewiki-step2' => '正在创建数据库...',
	'autocreatewiki-step3' => '正在数据库中设置默认信息...',
	'autocreatewiki-step4' => '正在复制默认的图标和图像...',
	'autocreatewiki-step5' => '正在数据库中设置默认变量...',
	'autocreatewiki-step6' => '正在数据库中设置默认表格...',
	'autocreatewiki-step7' => '正在设置语言启动器...',
	'autocreatewiki-step8' => '正在设置用户组和类别...',
	'autocreatewiki-step9' => '正在为新的维基设置变量...',
	'autocreatewiki-step10' => '正在中央维基上设置页面...',
	'autocreatewiki-step11' => '正在给用户发送电子邮件...',
	'autocreatewiki-redirect' => '正在重定向到新的维基： $1...',
	'autocreatewiki-congratulation' => '恭喜您！',
	'autocreatewiki-welcometalk-log' => '欢迎辞',
	'autocreatewiki-regex-error-comment' => '已用于$1维基中（全文：$2）',
	'autocreatewiki-step2-error' => '数据库已存在！',
	'autocreatewiki-step3-error' => '无法在数据库中设置默认信息！',
	'autocreatewiki-step6-error' => '无法在数据库中设置默认表！',
	'autocreatewiki-step7-error' => '无法复制语言启动器数据库！',
	'autocreatewiki-protect-reason' => '属於官方界面的一部分',
	'autocreatewiki-welcomesubject' => '$1已创建！',
	'autocreatewiki-welcometalk-wall-title' => '欢迎光临！',
	'autocreatewiki-welcometalk-wall' => '嘿，您好！我们很高兴{{subst:SITENAME}}能成为Wikia社区的一部分！还有很多事情要做。这里有一些有用的提示和链接，能让您的维基运转起来：

*查看[[Special：WikiFeatures|维基功能]，看看您可以在您的维基上开启哪些功能，包括聊天、成就及更多其他功能。
 *通过访问 [[Special:ThemeDesigner|主题界面]]自定义您的维基的外观，在这里您可以给您的背景和文字添加颜色和样式。
*到[[w:c:zh.community|社区中心]]来看看，通过我们的[[w:c:zh.community:Category:社区中心博客|社区中心博客]]了解最新信息、在我们的[[w:c:zh.community:Special:Forum|社区论坛]]提问、参与我们的[[w:c:community:Help:Webinars|网络研讨会系列]]（英文）或与其他Wikia用户[[w:c:zh.community:Special:Chat|在线聊天]]
*最后，请访问我们的[[Help:Contents|帮助页面]]了解如何使用Wikia的所有功能， 包括[[Help:New page|如何在您的维基上添加新页面]]、[[Help:Attracting contributors|如何吸引用户]] 以及[[Help:User access levels|如何添加其他管理员]]。
 * 您还可以到您的管理员控制面板使用上述所有工具，只需点击底部工具栏的“管理员”即可找到这些工具。

上面列出的所有链接都是开始探索的好起点。祝您玩得开心！',
	'autocreatewiki-info-birthdate' => '作为安全预防措施，也为了遵守美国联邦法规而保持网站的完整性，Wikia要求所有用户提供自己的真实出生日期。',
	'autocreatewiki-info-blurry-word' => '为了避免自动创建帐户，请在此栏中键入您看到的模糊字词。',
	'autocreatewiki-info-terms-agree' => '创建维基和用户账户，即表示您同意并接受此{{#NewWindowLink: w:Terms of use | Wikia 使用条款}}',
	'autocreatewiki-info-staff-username' => '<b>仅供工作人员使用：</b>指定的用户将被列为创始人。',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-name-taken' => '已有用此地址创建的维基。可在<a href="http://$1.wikia.com">http://$1.wikia.com</a>页面进行编辑或选择其他地址。',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-welcomebody' => '$2!，您好，

您的维基已创建！请点击<$1>查看 。

准备好开始了吗？我们添加了一些链接到您的聊天页面（<$5>）帮助您开始，并鼓励您去探索与Wikia相关的许多有用信息。如有任何疑问或感到困惑，请回复此电子邮件或查看我们的帮助页面<http://zh.help.wikia.com>。

您还可以查阅一下创始人与管理员博客<http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins>（英文）和Wikia社区中心博客<http://zh.community.wikia.com/wiki/Category:%E7%A4%BE%E5%8C%BA%E4%B8%AD%E5%BF%83%E5%8D%9A%E5%AE%A2>。在这里您会找到很多提示和技巧，以及关于Wikia新事物和新功能的信息。

祝您编辑愉快！

$3
Wikia社区支持
<http://zh.community.wikia.com/wiki/用户:$4>

___________________________________________
* 不再希望收到任何消息?您可以前往以下页面取消订阅或更改您的电子邮件偏好设置：http://zh.community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk' => '==欢迎您==

嘿！

我们很高兴$4能成为维基社区的一部分！还有很多事情要做；这里有一些有用提示和链接，能让您的维基运转起来：

*查看[[Special：WikiFeatures|维基功能]，看看您可以在您的维基上开启哪些功能，包括聊天、成就及更多功能。
*到[[w:c:zh.community|社区中心]]来看看，通过我们的[[w:c:zh.community:Category:社区中心博客|社区中心博客]]了解最新信息、在我们的[[w:c:zh.community:Special:Forum|社区论坛]]提问、参与我们的[[w:c:community:Help:Webinars|网络研讨会系列]]（英文）或与其他wikia用户在线聊天
*最后，请访问我们的[[Help:Contents|帮助页面]]了解如何使用Wikia的所有功能

上面列出的所有链接都是开始探索的好起点。祝你玩得开心！

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 * @author Oapbtommy
 */
$messages['zh-hant'] = array(
	'autocreatewiki' => '創建一個新的 wiki',
	'autocreatewiki-desc' => '通過使用者的請求，在 WikiFactory 中創建 wiki',
	'autocreatewiki-page-title-default' => '建立一個新的維基',
	'autocreatewiki-page-title-answers' => '創建一個新的問答網站',
	'createwiki' => '建立一個新的維基',
	'autocreatewiki-chooseone' => '請選擇一個',
	'autocreatewiki-web-address' => '網址',
	'autocreatewiki-category-select' => '選擇一個',
	'autocreatewiki-language-top' => '最常用 $1 種語言',
	'autocreatewiki-language-all' => '所有語言',
	'autocreatewiki-remember' => '記住我：',
	'autocreatewiki-create-account' => '創建帳戶',
	'autocreatewiki-haveaccount-question' => '你已經有一個 Wikia 帳戶嗎？',
	'autocreatewiki-info-domain' => '最好使用一個最可能搜尋到你的主題的關鍵字。',
	'autocreatewiki-info-topic' => '增加一个短的描述，如「星際大戰」或「電視節目」。',
	'autocreatewiki-info-category-default' => '這將有助於訪客找到你的wiki',
	'autocreatewiki-info-category-answers' => '這將有助於你的訪客找到你的問答網站',
	'autocreatewiki-info-language' => '這將是你的 wiki 訪客的預設語言。',
	'autocreatewiki-info-email-address' => '您的電子郵寄地址不會顯示給 Wikia 上的任何人。',
	'autocreatewiki-info-blurry-word' => '為了幫助防止創建自動化的帳戶，請鍵入您在下面的框中看到的這兩個字：',
	'autocreatewiki-info-terms-agree' => '通過創建 wiki 和使用者帳戶，您同意<a href="http://www.wikia.com/wiki/Terms_of_use">Wikia 的使用條款</a>',
	'autocreatewiki-title-template' => '$1Wiki',
	'autocreatewiki-limit-day' => 'Wikia 今天超過了 wiki 創建的最大數量 （ $1 ）。',
	'autocreatewiki-limit-creation' => '您已超出了 在一天內創建wiki 的最大數量 （ $1 ）。',
	'autocreatewiki-empty-field' => '請填寫此欄位。',
	'autocreatewiki-bad-name' => '名稱不能包含特殊字元 （如 $ 或 @），並且必須是一個小寫字母詞沒有空格。',
	'autocreatewiki-invalid-wikiname' => '名稱不能包含特殊字元 （如 $ 或 @） 且不能為空白',
	'autocreatewiki-violate-policy' => '此 wiki 名稱中包含了違反我們的命名政策的詞語',
	'autocreatewiki-name-taken' => '已經有一個使用此網址的 wiki。可以在<a href="http://<span class=" notranslate"="">$1.wikia.com">http:// $1.wikia.com</a>開始編輯，或選擇另一個位址。',
	'autocreatewiki-name-too-short' => '此網址太短，選擇一個具有至少 3 個字元的網址。',
	'autocreatewiki-name-too-long' => '此網址太長，請另選擇一個網址，最多 50 個字元。',
	'autocreatewiki-similar-wikis' => '下面是已經創建的關於這一主題的 wiki。我們建議您參與編輯其中之一。',
	'autocreatewiki-invalid-username' => '此用戶名無效。',
	'autocreatewiki-busy-username' => '此用戶名已被使用。',
	'autocreatewiki-blocked-username' => '您不能創建帳戶。',
	'autocreatewiki-user-notloggedin' => '您的帳戶已創建，但未登錄 ！',
	'autocreatewiki-empty-language' => '請選擇wiki的語言。',
	'autocreatewiki-empty-category' => '請選擇一個分類。',
	'autocreatewiki-empty-wikiname' => 'Wiki 的名稱不能為空白。',
	'autocreatewiki-empty-username' => '使用者名稱不能為空。',
	'autocreatewiki-empty-password' => '密碼不能為空。',
	'autocreatewiki-empty-retype-password' => '重新鍵入密碼不能為空。',
	'autocreatewiki-category-label' => '類別：',
	'autocreatewiki-category-other' => '其他',
	'autocreatewiki-set-username' => '首先設置使用者名稱。',
	'autocreatewiki-invalid-category' => '類別的值無效。
請從下拉列表中選擇適當的類別。',
	'autocreatewiki-invalid-language' => '語言的值無效。
請從下拉列表中選擇適當的語言。',
	'autocreatewiki-invalid-retype-passwd' => '請重新輸入與上面相同的密碼',
	'autocreatewiki-invalid-birthday' => '無效的出生日期',
	'autocreatewiki-log-title' => '您的wiki已經創建了',
	'autocreatewiki-step0' => '正在初始化過程...',
	'autocreatewiki-stepdefault' => '進程正在運行，請稍候...',
	'autocreatewiki-errordefault' => '過程還沒結束...',
	'autocreatewiki-step1' => '正在創建的影像文件夾...',
	'autocreatewiki-step2' => '正在創建資料庫...',
	'autocreatewiki-step3' => '在資料庫中設置預設資訊...',
	'autocreatewiki-step4' => '正在複製logo和預設圖像...',
	'autocreatewiki-step5' => '正在資料庫中設置預設變數...',
	'autocreatewiki-step6' => '正在資料庫中設置預設表格...',
	'autocreatewiki-step7' => '設置語言起動器...',
	'autocreatewiki-step8' => '設置使用者群體和類別...',
	'autocreatewiki-step9' => '設置新 wiki 的變數...',
	'autocreatewiki-step10' => '在中央wiki上設置頁面',
	'autocreatewiki-step11' => '將電子郵件發送到使用者...',
	'autocreatewiki-redirect' => '重定向到新的 wiki：  $1  ...',
	'autocreatewiki-congratulation' => '恭喜 ！',
	'autocreatewiki-welcometalk-log' => '歡迎留言',
	'autocreatewiki-regex-error-comment' => '在 wiki 中使用 $1 （整個文本：  $2 ）',
	'autocreatewiki-step2-error' => '資料庫存在 ！',
	'autocreatewiki-step3-error' => '不能在資料庫中設置預設資訊 ！',
	'autocreatewiki-step6-error' => '不能在資料庫中設置預設表格 ！',
	'autocreatewiki-step7-error' => '無法複製語言起動器資料庫 ！',
	'autocreatewiki-protect-reason' => '官方介面的一部分',
	'autocreatewiki-welcomesubject' => '$1已創建 ！',
);

/** Chinese (Hong Kong) (中文（香港）‎)
 */
$messages['zh-hk'] = array(
	'autocreatewiki-page-title-default' => '申請wiki',
	'createwiki' => '申請wiki',
);

/** Chinese (Singapore) (中文（新加坡）‎)
 */
$messages['zh-sg'] = array(
	'autocreatewiki-page-title-default' => '申请wiki',
	'createwiki' => '申请wiki',
);

/** Chinese (Taiwan) (中文（台灣）‎)
 */
$messages['zh-tw'] = array(
	'autocreatewiki-page-title-default' => '創建新的維基',
	'createwiki' => '創建新的維基',
	'autocreatewiki' => '創建新的維基',
	'autocreatewiki-desc' => '按用戶的請求在維基出廠配置中創建維基',
	'autocreatewiki-page-title-answers' => '創建新的問答網站',
	'autocreatewiki-chooseone' => '選擇一個',
	'autocreatewiki-required' => '$1 = 必選項目',
	'autocreatewiki-web-address' => '網站位址：',
	'autocreatewiki-category-select' => '選擇一個',
	'autocreatewiki-language-top' => '最常用的$1種語言',
	'autocreatewiki-language-all' => '所有語言',
	'autocreatewiki-remember' => '記住我',
	'autocreatewiki-create-account' => '創建帳戶',
	'autocreatewiki-haveaccount-question' => '已經有Wikia帳戶？',
	'autocreatewiki-info-domain' => '最好使用一個可能會搜尋到你的主題的關鍵字。',
	'autocreatewiki-info-topic' => '增加簡短的描述，如「星際大戰」或「電視節目」。',
	'autocreatewiki-info-category-default' => '這會幫助訪客找到你的維基。',
	'autocreatewiki-info-category-answers' => '這會幫助訪客找到你的問答網站。',
	'autocreatewiki-info-language' => '這將是你的維基訪客的預設語言。',
	'autocreatewiki-info-email-address' => '我們絕不會把你的電子郵寄地址顯示給Wikia上的任何人。',
	'autocreatewiki-info-realname' => '如果您選擇提供此資訊，這將用來表明這些工作是由你完成的。',
	'autocreatewiki-info-birthdate' => '作爲安全措施，也作爲保持網站完整性的手段，同時也爲了遵守美國聯邦法規，Wikia要求所有用戶提供自己的真實出生日期。',
	'autocreatewiki-info-blurry-word' => '為了幫助防止自動創建帳戶，請在此欄中鍵入你看到的模糊字詞。',
	'autocreatewiki-info-terms-agree' => '創建維基和使用者帳戶，即表示你同意此<a {{#NewWindowLink: w:zh.Terms of use | Wikia使用條款}}</a>。',
	'autocreatewiki-info-staff-username' => '<b>僅供工作人員使用：</b>指定的用戶將被列爲創始人。',
	'autocreatewiki-title-template' => '$1Wiki',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => '在今天已超過了Wikia每日維基創建數上限($1)。',
	'autocreatewiki-limit-creation' => '您已超出所允許的24小時維基創建數上限($1)。',
	'autocreatewiki-empty-field' => '請填寫此欄位。',
	'autocreatewiki-bad-name' => '名稱不能包含特殊字元 （如 $ 或 @），並且必須是沒有空格、由小寫字母組成的單字。',
	'autocreatewiki-invalid-wikiname' => '名稱不能包含特殊字元 （如 $ 或 @） 且不能為空白。',
	'autocreatewiki-violate-policy' => '此維基名稱中包含有違反我們的命名準則的字詞。',
	'autocreatewiki-name-taken' => '已經有用此網址創建的維基。可在<a href="http://<span class=" notranslate"="">$1.wikia.com">http:// $1.wikia.com</a> 進行編輯或選擇另一個位址。',
	'autocreatewiki-name-too-short' => '此網址太短，請選擇一個至少有3個字元的網址。',
	'autocreatewiki-name-too-long' => '此網址太長，請選擇一個50個字元以下的網址。',
	'autocreatewiki-similar-wikis' => '下面是已經創建的關於這一主題的維基。我們建議您參與編輯其中之一。',
	'autocreatewiki-invalid-username' => '此用戶名無效。',
	'autocreatewiki-busy-username' => '此用戶名已有人使用。',
	'autocreatewiki-blocked-username' => '無法創建帳戶。',
	'autocreatewiki-user-notloggedin' => '你的帳戶已創建，但未登入！',
	'autocreatewiki-empty-language' => '請選擇維基的語言。',
	'autocreatewiki-empty-category' => '請選擇一個類別。',
	'autocreatewiki-empty-wikiname' => '維基的名稱不能為空白。',
	'autocreatewiki-empty-username' => '使用者名稱不能為空白。',
	'autocreatewiki-empty-password' => '密碼不能為空白。',
	'autocreatewiki-empty-retype-password' => '重新鍵入密碼不能為空白。',
	'autocreatewiki-category-label' => '類別：',
	'autocreatewiki-category-other' => '其他',
	'autocreatewiki-set-username' => '請先設置使用者名稱。',
	'autocreatewiki-invalid-category' => '無效的類別。
請從下拉列表中選擇適當的類別。',
	'autocreatewiki-invalid-language' => '無效的語言。
請從下拉列表中選擇適當的語言。',
	'autocreatewiki-invalid-retype-passwd' => '請再輸入與上欄密碼相同的密碼。',
	'autocreatewiki-invalid-birthday' => '出生日期無效。',
	'autocreatewiki-log-title' => '正在創建你的維基',
	'autocreatewiki-step0' => '正在進行初始化處理...',
	'autocreatewiki-stepdefault' => '處理中，請稍候...',
	'autocreatewiki-errordefault' => '仍在處理中...',
	'autocreatewiki-step1' => '正在創建影像文件夾...',
	'autocreatewiki-step2' => '正在創建資料庫...',
	'autocreatewiki-step3' => '正在資料庫中設置預設資訊...',
	'autocreatewiki-step4' => '正在複製預設的圖標和圖像...',
	'autocreatewiki-step5' => '正在資料庫中設置預設變數...',
	'autocreatewiki-step6' => '正在資料庫中設置預設表格...',
	'autocreatewiki-step7' => '設置語言啟動器...',
	'autocreatewiki-step8' => '設置用戶組和類別...',
	'autocreatewiki-step9' => '正在為新的維基設置變數...',
	'autocreatewiki-step10' => '正在中央維基上設置頁面...',
	'autocreatewiki-step11' => '正在給用戶發送電子郵件...',
	'autocreatewiki-redirect' => '正在重定向到新的維基：$1 ...',
	'autocreatewiki-congratulation' => '恭喜你！',
	'autocreatewiki-welcometalk-log' => '歡迎辭',
	'autocreatewiki-regex-error-comment' => '已用於$1維基（全文：$2 ）',
	'autocreatewiki-step2-error' => '資料庫已存在！',
	'autocreatewiki-step3-error' => '無法在資料庫中設置預設資訊 ！',
	'autocreatewiki-step6-error' => '無法在資料庫中設置預設表格！',
	'autocreatewiki-step7-error' => '無法複製啟動資料庫的語言 ！',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => '屬於官方介面',
	'autocreatewiki-welcomesubject' => '$1已創建！',
	'autocreatewiki-welcomebody' => '$2，你好！

 你的維基網站已創建！請點擊<$1>查看。

 準備好開始了嗎？我們在你的聊天頁面（<$5>）添加了一些連結以幫助你開始，並鼓勵你去探索與Wikia相關的很多有用資訊。如有任何疑問或感到困惑，請回覆此電子郵件或查看我們的幫助頁面<http://zh.help.wikia.com>。

 你還可以查閲一下創始人與管理員網誌<http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins>（英文）和Wikia社區中心網誌<http://zh.community.wikia.com/wiki/Category:%E7%A4%BE%E5%8C%BA%E4%B8%AD%E5%BF%83%E5%8D%9A%E5%AE%A2>。在這裡你會找到很多提示和技巧，以及關於Wikia的新事物和新功能的資訊。

 祝你編輯愉快！

 $3
 Wikia社區支持
<http://zh.community.wikia.com/wiki/使用者:$4>

___________________________________________
 * 不再希望收到任何消息？你可以前往以下頁面取消訂閲或更改你的電子郵件首選項： http://zh.community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => '歡迎你！',
	'autocreatewiki-welcometalk-wall' => '嘿，你好！我們很高興{{subst:SITENAME}}能成爲Wikia社區的一部分！

 還有很多事情要做。這裡有一些有用的提示和連接，能讓你的維基運轉起來：
 *查看[[Special:WikiFeatures|維基功能]]，看看你可以在你的維基上開啓那些功能，包括聊天、成就及更多其他功能。
 *透過訪問[[Special:ThemeDesigner|主題界面]]自訂你的維基的外觀，在這裡你可以給你的背景和文字添加顔色和樣式。
 *到[[w:c:zh.community|社區中心]]來看看，透過我們的[[w:c:zh.community:Category:社区中心博客|社區中心網誌]]了解最新資訊、在我們的[[w:c:zh.community:Special:Forum|社區論壇]]提問、參與我們的[[w:c:community:Help:Webinars|網路研討會系列]]（英文）或與其他Wikia用户[[w:c:zh.community:Special:Chat|線上聊天]]。
 *最後，請訪問我們的[[Help:Contents|幫助頁面]]了解如何使用Wikia的所有功能，包括[[Help:New page|如何在你的維基上添加新頁面]]、 [[Help:Attracting contributors|如何吸引網友]]以及[[Help:User access levels|如何添加其他管理員]]。
 * 你還可以到你的管理員控制面板使用上述所有工具，只需按一下底部工具欄的「管理員」即可找到這些工具。

 上面列出的所有連結都是開始探索的好起點。祝你使用愉快！',
	'autocreatewiki-welcometalk' => '==歡迎你！==
 嘿，你好！

 你好！我們很高興{{subst:SITENAME}}能成爲Wikia社區的一部分！還有很多事情要做。這裡有一些有用的提示和連接，能讓你的維基開始運轉：

 *查看[[Special:WikiFeatures|維基功能]]，看看你可以在你的維基上開啓哪些功能，包括聊天、成就及更多其他功能。
 *到[[w:c:zh.community|社區中心]]來看看，透過我們的[[w:c:zh.community:Category:社区中心博客|社區中心網誌]]了解最新資訊、在我們的[[w:c:zh.community:Special:Forum|社區論壇]]提問、參與我們的[[w:c:community:Help:Webinars|網路研討會系列]]（英文）或與其他Wikia使用者[[w:c:zh.community:Special:Chat|線上聊天]]。
 *最後，請訪問我們的[[Help:Contents|幫助頁面]]了解如何使用Wikia的所有功能

上面列出的所有連接都是開始探索的好起點。祝你使用愉快！

 -- [[User:$2|$3]]  <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);
