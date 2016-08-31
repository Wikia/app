<?php
/**
 * AutomaticWikiAdoption
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

$messages = array();

$messages['en'] = array(
	'wikiadoption' => 'Automatic wiki adoption',
	'wikiadoption-desc' => 'An AutomaticWikiAdoption extension for MediaWiki',
	'wikiadoption-header' => 'Adopt this wiki',
	'wikiadoption-button-adopt' => 'Yes, I want to adopt {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Find out more!',
	'wikiadoption-description' => "$1, ready to adopt {{SITENAME}}?
<br /><br />
There hasn't been an active administrator on {{SITENAME}} for a while, and we're looking for a new leader to help this wiki's content and community grow! As someone who's contributed to {{SITENAME}} we were wondering if you'd like the job.
<br /><br />
By adopting the wiki, you'll be promoted to administrator and bureaucrat to give you the tools you'll need to manage the wiki's community and content. You'll also be able to create other administrators to help, delete, rollback, move and protect pages.
<br /><br />
Are you ready to take the next steps to help {{SITENAME}}?",
	'wikiadoption-know-more-header' => 'Want to know more?',
	'wikiadoption-know-more-description' => 'Check out these links for more information. And of course, feel free to contact us if you have any questions!',
	'wikiadoption-adoption-successed' => 'Congratulations! You are a now an administrator on this wiki!',
	'wikiadoption-adoption-failed' => "We are sorry. We tried to make you an administrator, but it did not work out. Please [http://community.wikia.com/Special:Contact contact us], and we will try to help you out.",
	'wikiadoption-not-allowed' => "We are sorry. You cannot adopt this wiki right now.",
	'wikiadoption-not-enough-edits' => "Oops! You need to have more than 10 edits to adopt this wiki.",
	'wikiadoption-adopted-recently' => "Oops! You have already adopted another wiki recently. You will need to wait a while before you can adopt a new wiki.",
	'wikiadoption-log-reason' => 'Automatic Wiki Adoption',
	'wikiadoption-notification' => "{{SITENAME}} is up for adoption. Interested in becoming a leader here? Adopt this wiki to get started! $2",
	'wikiadoption-mail-first-subject' => "We have not seen you around in a while",
	'wikiadoption-mail-first-content' => "Hi $1,

It's been a couple of weeks since we have seen an administrator on #WIKINAME. Administrators are an integral part of #WIKINAME and it's important they have a regular presence. If there are no active administrators for a long period of time, this community may be put up for adoption to allow another user to become an administrator.

If you need help taking care of the community, you can also allow other community members to become administrators now by going to $2.  Hope to see you on #WIKINAME soon!

The Fandom Team

You can unsubscribe from changes to this list here: $3",
	'wikiadoption-mail-first-content-HTML' => "Hi $1,<br /><br />

It's been a couple of weeks since we have seen an administrator on #WIKINAME. Administrators are an integral part of #WIKINAME and it's important they have a regular presence. If there are no active administrators for a long period of time, this community may be put up for adoption to allow another user to become an administrator.<br /><br />

If you need help taking care of the community, you can also allow other community members to become administrators now by going to <a href=\"$2\">User Rights management</a>.  Hope to see you on #WIKINAME soon!<br /><br />

The Fandom Team<br /><br />

You can <a href=\"$3\">unsubscribe</a> from changes to this list.",
	'wikiadoption-mail-second-subject' => "#WIKINAME will be put up for adoption soon",
	'wikiadoption-mail-second-content' => "Hi $1,
It's been almost 60 days since there's been an active administrator on #WIKINAME. It's important that administrators regularly appear and contribute so the community can continue to run smoothly.

Since it's been so many days since a current administrator has appeared, #WIKINAME will now be offered for adoption to other editors.

The Fandom Team

You can unsubscribe from changes to this list here: $3",
	'wikiadoption-mail-second-content-HTML' => "Hi $1,<br /><br />
It's been almost 60 days since there's been an active administrator on #WIKINAME. It's important that administrators regularly appear and contribute so the community can continue to run smoothly.<br /><br />

Since it's been so many days since a current administrator has appeared, #WIKINAME will now be offered for adoption to other editors. <br /><br />

The Fandom Team<br /><br />

You can <a href=\"$3\">unsubscribe</a> from changes to this list.",
	'wikiadoption-mail-adoption-subject' => '#WIKINAME has been adopted',
	'wikiadoption-mail-adoption-content' => "Hi $1,

#WIKINAME has been adopted.  Communities are available to be adopted when none of the current administrators are active for 60 days or more.

The adopting user of #WIKINAME will now have bureaucrat and admin status.  Don't worry, you'll also your retain administrator status on this community and are welcome to return and continue contributing at any time!

The Fandom Team

You can unsubscribe from changes to this list here: $3",
	'wikiadoption-mail-adoption-content-HTML' => "Hi $1,<br /><br />

#WIKINAME has been adopted.  Communities are available to be adopted when none of the current administrators are active for 60 days or more.<br /><br />

The adopting user of #WIKINAME will now have bureaucrat and admin status.  Don't worry, you'll also your retain administrator status on this community and are welcome to return and continue contributing at any time!<br /><br />

The Fandom Team<br /><br />

You can <a href="$3">unsubscribe</a> from changes to this list.",
	'tog-adoptionmails' => 'Email me if $1 will become available for other users to adopt',
	'tog-adoptionmails-v2' => '...if the wiki will become available for other users to adopt',
	'wikiadoption-pref-label' => 'Changing these preferences will only affect emails from $1.',
	'wikiadoption-welcome-header' => 'Congratulations! You\'ve adopted {{SITENAME}}!',
	'wikiadoption-welcome-body' => "You're now a bureaucrat on this wiki. With your new status you now have access to all the tools that will help you manage {{SITENAME}}.
<br /><br />
The most important thing you can do to help {{SITENAME}} grow is keep editing.
<br /><br />
If there is no active administrator on a wiki it can be put up for adoption so be sure to check in on the wiki frequently.
<br /><br />
Helpful Tools:
<br /><br />
[[Special:ThemeDesigner|ThemeDesigner]]
<br />
[[Special:LayoutBuilder|Page Layout Builder]]
<br />
[[Special:ListUsers|User List]]
<br />
[[Special:UserRights|Manage Rights]]",
);

/** Message documentation (Message documentation)
 * @author Siebrand
 * @author TK-999
 */
$messages['qqq'] = array(
	'wikiadoption-desc' => '{{desc}}',
	'tog-adoptionmails' => 'Parameters:
* $1 is the wiki name potentially up for adoption.',
	'wikiadoption-pref-label' => 'This message is located within the Email tab of Special:Preferences. Parameters:
* $1 is the wiki name the user opened it in.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wikiadoption-know-more-header' => 'Wil u meer weet?',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 */
$messages['ar'] = array(
	'wikiadoption' => 'تبني تلقائي للويكي',
	'wikiadoption-desc' => 'ملحق تبني ويكي تلقائي للميدياويكي',
	'wikiadoption-header' => 'تبنى هذه الويكي',
	'wikiadoption-button-adopt' => 'نعم أريد أن أتبنى {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'اكتشف المزيد!',
	'wikiadoption-description' => '$1، مستعد لتبني {{SITENAME}}؟
<br /><br />
لم يكن هناك إداري نشيط في  {{SITENAME}} لفترة من الوقت، ونحن نبحث عن قائد جديد للمساعدة في محتوى هذه الويكي و تنمية المجتمع! باعتبارك ساهمت في {{SITENAME}} نحن نتسائل إذا كنت ترغب في الحصول على هذا المنصب.
<br /><br />
بتبني هذه الويكي، سوف يتم إعطائك رتب إداري و بيروقراطي لتحصل على الأدوات اللازمة لإدارة مجتمع الويكي و محتواها. سوف تتمكن أيضا من إضافة إداريين آخرين معك ليساعدوا و يحذفوا و يستعيدوا و ينقلوا و يحموا الصفحات.
<br /><br />
هل أنت مستعد لاتخاذ الخطوات التالية لمساعدة  {{SITENAME}}؟',
	'wikiadoption-know-more-header' => 'هل تريد معرفة المزيد؟',
	'wikiadoption-know-more-description' => 'قم بزيارة هذه الوصلات للحصول على مزيد من المعلومات. ولا تتردد بالطبع في الاتصال بنا إذا كان لديك أي أسئلة!',
	'wikiadoption-adoption-successed' => 'تهانينا! أنت الآن إداري مسؤول عن هذه الويكي!',
	'wikiadoption-adoption-failed' => 'نحن نأسف. حاولنا أن نجعلك إداريا، ولكن لم نتمكن. الرجاء [http://community.wikia.com/Special:Contact الاتصال بنا]، وسوف نحاول أن نساعدك.',
	'wikiadoption-not-allowed' => 'نحن نأسف. لا يمكن لك تبني هذه الويكي حاليا',
	'wikiadoption-not-enough-edits' => 'عفوا! تحتاج إلى أكثر من 10 تعديلات لكي تتمكن من تبني هذه الويكي',
	'wikiadoption-adopted-recently' => 'عفوا! لقد قمت بتبني ويكي آخرى مؤخرا. سوف تحتاج إلى الانتظار لبعض الوقت قبل أن يمكنك أن تتبنى ويكي جديدة.',
	'wikiadoption-log-reason' => 'تبني تلقائي للويكي',
	'wikiadoption-notification' => '{{SITENAME}} معروضة للتبني. هل ترغب في أن تصبح قائدا هنا؟ قم بتبني هذه الويكي للبدء! $2',
	'wikiadoption-mail-first-subject' => 'لم نرك في الويكي لمدة طويلة',
	'wikiadoption-mail-first-content' => 'مرحبا $1،

مرت بضعة أسابيع منذ أن زار إداري #WIKINAME. الإداريون هم جزء لا يتجزأ من #WIKINAME و من المهم أن يكون لهم حضور في الويكي. إذا لن يكون هناك إداريون نشطون لمدة طويلة من الزمن سوف يتم طرح هذه الويكي للتبني للسماح لمستخدم آخر لإدارتها.

إذا كنت بحاجة إلى المساعدة في الاهتمام بالويكي، يمكنك السماح لأعضاء المجتمع الآخرين بأن يصبحوا إداريين أيضا عبر زيارة $2. نأمل أن نراكم قريبا في #WIKINAME!

فريق ويكيا

يمكنك إلغاء الاشتراك من خلال التغييرات لهذه القائمة هنا: $3',
	'wikiadoption-mail-first-content-HTML' => 'مرحبا $1،

مرت بضعة أسابيع منذ أن زار إداري #WIKINAME. الإداريون هم جزء لا يتجزأ من #WIKINAME ومن المهم أن يكون لهم حضور في الويكي. إن لم يوجد إداريون نشطون لمدة طويلة سوف يتم طرح هذه الويكي للتبني للسماح لمستخدم آخر لإدارتها.

إذا كنت بحاجة إلى المساعدة في الاهتمام بالويكي، يمكنك السماح لأعضاء المجتمع الآخرين بأن يصبحوا إداريين أيضا عبر زيارة $2. نأمل أن نراكم قريبا في #WIKINAME!

فريق ويكيا

يمكنك إلغاء الاشتراك من خلال التغييرات لهذه القائمة هنا: $3',
	'wikiadoption-mail-second-subject' => 'سيتم طرح #WIKINAME للتبني في أقرب وقت',
	'wikiadoption-mail-second-content' => 'مرحبًا $1،
أوه، لا! مر ما يقرب من 60 يومًا منذ أن كان هناك إداري نشط في #WIKINAME. من المهم أن يظهر الإدرايون بانتظام ويساهمون حتى يمكن للويكي أن تستمر بسلاسة.

نظرًا لمرور عدة أيام منذ أن ظهر إداري الحالي، سيتم الآن تقديم #WIKINAME للتبني لمحررين آخرين.

فريق ويكيا

يمكنك إلغاء الاشتراك من التغييرات إلى هذه القائمة هنا:$3',
	'wikiadoption-mail-second-content-HTML' => 'مرحبًا $1،
أوه، لا! مر ما يقرب من 60 يومًا منذ أن كان هناك إداري نشط في #WIKINAME. من المهم أن يظهر الإدرايون بانتظام ويساهمون حتى يمكن للويكي أن تستمر بسلاسة.

نظرًا لمرور عدة أيام منذ أن ظهر إداري الحالي، سيتم الآن تقديم #WIKINAME للتبني لمحررين آخرين.

فريق ويكيا

يمكنك إلغاء الاشتراك من التغييرات إلى هذه القائمة هنا:$3',
	'wikiadoption-mail-adoption-subject' => 'تم تبني #WIKINAME',
	'wikiadoption-mail-adoption-content' => 'مرحبًا $1،

لقد تم تبني #WIKINAME. تتم إتاحة الويكي للتبني عند عدم عدم ظهور أي إداري حالي نشط لمدة لمدة 60 يومًا أو أكثر.

وسيتم ترقية المستخدم المتبني للويكي #WIKINAME إلى مشرف وبيروقراطي. لا داعي للقلق، ستحتفظ أيضًا بحالتك الإدارية ومرحب بك للعودة والمساهمة في أي وقت!

فريق ويكيا

يمكنك إلغاء الاشتراك من التغييرات إلى هذه القائمة هنا:$3',
	'wikiadoption-mail-adoption-content-HTML' => 'مرحبًا $1،

لقد تم تبني #WIKINAME. تتم إتاحة الويكي للتبني عند عدم عدم ظهور أي إداري حالي نشط لمدة لمدة 60 يومًا أو أكثر.

وسيتم ترقية المستخدم المتبني للويكي #WIKINAME إلى مشرف وبيروقراطي. لا داعي للقلق، ستحتفظ أيضًا بحالتك الإدارية ومرحب بك للعودة والمساهمة في أي وقت!

فريق ويكيا

يمكنك إلغاء الاشتراك من التغييرات إلى هذه القائمة هنا:$3',
	'tog-adoptionmails' => 'راسلني عبر البريد الإلكتروني إذا كانت $1 سوف تصبح متوفرة للتبني من قبل المستخدمين الآخرين',
	'tog-adoptionmails-v2' => '...إذا كانت الويكي سوف تصبح متوفرة للتبني من قبل المستخدمين الآخرين',
	'wikiadoption-pref-label' => 'سيؤثر تغيير هذه التفضيلات على رسائل البريد الإلكتروني من $1 فقط.',
	'wikiadoption-welcome-header' => 'تهانينا! لقد تبنيت {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'أنت الآن بيروقراطي على هذه الويكي. بصلاحيتك الجديدة، مسموح لك باستخدام كل الأدوات التي ستساعدك لإدارة {{SITENAME}}.
<br /><br />
أهم شيء يمكنك فعله لمساعدة {{SITENAME}} للتوسع هو مواصلة التحرير.
<br /><br />
إن لم يوجد أي إداري نشط على ويكي، يمكن وضعها للتبني لذا تأكد من زيارتك للويكي باستمرار.
<br /><br />
أدوات مفيدة:
<br /><br />
[[Special:ThemeDesigner|مصمم الويكي]]
<br />
[[Special:LayoutBuilder|منشئ نماذج الصفحات]]
<br />
[[Special:ListUsers|قائمة المستخدمين]]
<br />
[[Special:UserRights|إدارة الصلاحيات]]',
);

/** Bikol Central (Bikol Central)
 * @author Geopoet
 */
$messages['bcl'] = array(
	'wikiadoption' => 'Awtomatikong pag-ampon sa wiki',
	'wikiadoption-desc' => 'Sarong AwtomatikongPag-amponsaWiki ekstensyon para sa MediaWiki',
	'wikiadoption-header' => 'Amponon ining wiki',
	'wikiadoption-button-adopt' => 'Iyo, ako muyang amponon an {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Maghanap pa nin iba!',
	'wikiadoption-description' => '$1, andam na mag-ampon kan {{SITENAME}}?
<br /><br />
Mayo pa nin sarong aktibong administrador sa {{SITENAME}} sa nagkapirang panahon, asin kami naghahanap nin sarong baguhong lider tanganing tabangan an laog kaining wiki asin magtalubo an komunidad! Bilang saro sa nag-ambag sa {{SITENAME}} kami po naghahapot kun ika mamuya kan trabahong ini.
<br /><br />
Sa pag-ampon kan wiki, ika ipaglalangkaw na magin administrador asin burokrata tanganing itao saimo an mga gamiton na saimong kinakaipuhan tanganing imaneho an komunidad kan wiki asin an laog. Ika man makakapagmukna nin ibang mga administrador na matabang, magpura, magbalikwat, maghiro asin magprotekta kan mga pahina.
<br /><br />
Andam ka na na akoon an masunod na mga lakdang sa pagtabang kan {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Muya mo pang makaaram nin iba?',
	'wikiadoption-know-more-description' => 'Rikisaha daw tabi ining mga kasugpunan para sa kadagdagan na impormasyon. Asin siyempre, libreng mateon na kontakon kami kun ika igwa nin anuman na mga kahaputan!',
	'wikiadoption-adoption-successed' => 'Karokyawan mo! Ika sa ngunyan saro nang administrador kaining wiki!',
	'wikiadoption-adoption-failed' => 'Kami po minasori. Kami nagprubar na himoon ka nin sarong administrador, kaya lang ini dae nangyari. Tabi man [http://community.wikia.com/Special:Contact kontakon kami], asin kami mahingohang makatabang saimo.',
	'wikiadoption-not-allowed' => 'Kami po minasori. Ika tabi dae makakaampon kaining wiki sa ngunyan.',
	'wikiadoption-not-enough-edits' => 'Oops! Ika kaipong magkaigwa nin sobra sa 10 mga pagliwat tanganing maampon mo ining wiki.',
	'wikiadoption-adopted-recently' => 'Oops! Ika nakapag-ampon na nin ibang wiki dae pa sana nahaloy. Ika kaipong maghalat-halat nin kadikit na panahon saka ka na makapag-ampon nin sarong baguhong wiki.',
	'wikiadoption-log-reason' => 'Awtomatikong Pag-ampon sa Wiki',
	'wikiadoption-notification' => 'An {{SITENAME}} nakaitaas para sa pag-ampon. Interesadong ka na magigin sarong lider digde? Amponon ining wiki tanganing makapagpoon ka na! $2',
	'wikiadoption-mail-first-subject' => 'Kami haloy-haloy na dae ka nahihiling',
	'wikiadoption-mail-first-content' => 'Hi $1,

Nakalipas na din duwang semana poon na kami nakapaghiling nin sarong administrador sa #WIKINAME. An mga administrador sarong kasumpay na parte kan #WIKINAME asin ini importante na sinda nagkaigwa nin sarong regular na presensiya. Kun mayo nin mga aktibong administrador para sa halawigon na panahon, ini wiki mapupuwedeng maipamugtak para amponon tanganing matugutan an ibang paragamit na magin sarong administrador.

Kun ika nangangaipo nin tabang tanganing alagaan an wiki, ika man makakapagtugot sa ibang miyembro kan komunidad na magin mga administrador sa ngunyan sa paagi nin pagduman sa $2. Nilalaoman na mahihiling mi ika sa #WIKINAME sa dae mahaloy na panahon!

An Team kan Wikia

Ika makakahale kan subskripsyon gikan sa mga kaliwatan sa listahan na yaon digde: $3',
	'wikiadoption-mail-first-content-HTML' => 'Hi $1,<br /><br />

Nakalipas na din duwang semana poon na kami nakapaghiling nin sarong administrador sa #WIKINAME. An mga administrador sarong kasumpay na parte kan #WIKINAME asin ini importante na sinda nagkaigwa nin sarong regular na presensiya. Kun mayo nin mga aktibong administrador para sa halawigon na panahon, ini wiki mapupuwedeng maipamugtak para amponon tanganing matugutan an ibang paragamit na magin sarong administrador.<br /><br />

Kun ika nangangaipo nin tabang tanganing alagaan an wiki, ika man makakapagtugot sa ibang miyembro kan komunidad na magin mga administrador sa ngunyan sa paagi nin pagduman sa $2. Nilalaoman na mahihiling mi ika sa #WIKINAME sa dae mahaloy na panahon!<br /><br />

An Team kan Wikia<br /><br />

Ika <a href="$3">makakahale kan subskripsyon</a> gikan sa mga kaliwatan sa listahang ini.',
	'wikiadoption-mail-second-subject' => 'An #WIKINAME ipapamugtak para sa pag-ampon sa dae mahaloy na panahon',
	'wikiadoption-mail-second-content' => 'Hi $1,
Oh, dae! Haros 60 mga aldaw na an nakalipas poon na magkaigwa nin sarong aktibong administrador sa #WIKINAME. Ini importante na an mga administrador regular na nagpapahiling asin nag-aambag na tanganing an wiki makakapagpadagos sa yanong pagdalagan.

Poon sa nakalipas na kadakol na mga aldaw kaidtong an administrador ngunyan nagpahiling, an #WIKINAME sa pinagtatangro na para sa pag-ampon sa ibang mga paraliwat.

An Team kan Wikia

Ika makakahale kan subskripsyon gikan sa mga kaliwatan sa listahan na yaon digde: $3',
	'wikiadoption-mail-second-content-HTML' => '
Hi $1,<br /><br />
Oh, dae! Haros 60 mga aldaw na an nakalipas poon na magkaigwa nin sarong aktibong administrador sa #WIKINAME. Ini importante na an mga administrador regular na nagpapahiling asin nag-aambag na tanganing an wiki makakapagpadagos sa yanong pagdalagan.<br /><br />

Poon sa nakalipas na kadakol na mga aldaw kaidtong an administrador ngunyan nagpahiling, an #WIKINAME sa pinagtatangro na para sa pag-ampon sa ibang mga paraliwat.<br /><br />

An Team kan Wikia<br /><br />

Ika <a href="$3">makakahale kan subskripsyon</a> gikan sa mga kaliwatan sa listahan na ini.',
	'wikiadoption-mail-adoption-subject' => 'An #WIKINAME pinag-ampon na',
	'wikiadoption-mail-adoption-content' => 'Hi $1,

An #WIKINAME pinag-ampon na. An mga Wikis yaon sa pag-aampon kunsoarin na mayo sa ngunyan na mga administrador an aktibo sa laog nin 60 mga aldaw o sobra pa.

An nag-aampon na paragamit kan #WIKINAME ngunyan magkakaigwa nin burokrata asin admin na kamugtakan. Dae mahandal, ika man retinido an kamugtakan mong administrador sa wiking ini asin pagbabation na magbalik asin padagos na mag-aambag sa arinman na panahon!

An Tema kan Wikia

Ika makakahale kan subskripsyon gikan sa mga kaliwatan sa listahan na yaon digde: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Hi $1,<br /><br />

An #WIKINAME pinag-ampon na. An mga Wikis yaon sa pag-aampon kunsoarin na mayo sa ngunyan na mga administrador an aktibo sa laog nin 60 mga aldaw o sobra pa.<br /><br />

An nag-aampon na paragamit kan #WIKINAME ngunyan magkakaigwa nin burokrata asin admin na kamugtakan. Dae mahandal, ika man retinido an kamugtakan mong administrador sa wiking ini asin pagbabation na magbalik asin padagos na mag-aambag sa arinman na panahon!<br /><br />

An Tema kan Wikia<br /><br />

Ika <a href="$3">makakahale kan subskripsyon</a> gikan sa mga kaliwatan sa listahan na yaon digde: $3',
	'tog-adoptionmails' => 'Padarhan mo ako nin e-surat kun an $1 magigin yaon para sa pag-ampon kan ibang mga paragamit',
	'tog-adoptionmails-v2' => '...kun an wiki magigin yaon para sa pag-ampon kan ibang mga paragamit',
	'wikiadoption-pref-label' => 'Pagliliwat kanining mga kamuyahan makakaapekto sana sa mga e-surat gikan sa $1.',
	'wikiadoption-welcome-header' => 'Karokyawan mo! Pinag-ampon mo na an {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Ika ngunyan saro nang burokrata kaining wiki. Sa saimong baguhon na kamugtakan ika ngunyan igwa na nin kalangkayan sa gabos na mga gamiton na makakatabang saimo sa pagmaneho kan {{SITENAME}}.
<br /><br />
An pinakaimportanteng bagay na ika makakatabang sa {{SITENAME}} na magtalubo iyo na daguson an pagliliwat.
<br /><br />
Kun mayo nin aktibong administrador sa sarong wiki ini maipapamugtak para sa pag-ampon kaya seguraduhon na magtagalaog pirme sa wiki.
<br /><br />
Pantabang na mga Gamiton:
<br /><br />
[[Special:ThemeDesigner|Paradesinyo kan Tema]]<br /> [[Special:LayoutBuilder|Paragibo kan Panluwas na gibo nin Pahina]]
<br />
[[Special:ListUsers|Listahan nin paragamit]] <br /> [[Special:UserRights|Manihoon an mga katanosan]]',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'wikiadoption-header' => 'Осиновяване на уикито',
	'wikiadoption-adoption-successed' => 'Поздравления! Вече сте администратор на това уики!',
);

/** Bengali (বাংলা)
 * @author Aftab1995
 * @author Aftabuzzaman
 * @author Tauhid16
 */
$messages['bn'] = array(
	'wikiadoption-adopt-inquiry' => 'আরও জানুন!',
	'wikiadoption-know-more-header' => 'আরো জানতে চান?',
	'wikiadoption-adoption-successed' => 'অভিনন্দন! আপনি এখন এই উইকির একজন প্রশাসক!',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'wikiadoption' => 'Degemer ur wiki ez-emgefre',
	'wikiadoption-desc' => 'Un astenn AutomaticWikiAdoption extension evit MediaWiki',
	'wikiadoption-header' => 'Degemer ar wiki-mañ',
	'wikiadoption-button-adopt' => "Ya, c'hoant 'm eus degemer {{SITENAME}} !",
	'wikiadoption-adopt-inquiry' => "Gouzout hiroc'h !",
	'wikiadoption-description' => "$1, prest da zegemer {{SITENAME}}?
<br /><br /> N'eus bet merour oberiat ebet e {{SITENAME}}abaoe ur mare hag emaomp o klask ur atebeg nevez evit sikour da ziorren endalc'had ar wiki-mañ ha brasaat ar gumuniezh anezhañ ! Dre m'ho peus graet traoù e {{SITENAME}} e c'houlennomp diganeoc'h hag-eñ e plijfe deoc'h  al labour-se <br /><br /> Dre zegemer  ar wiki-mañ e vioc'h lakaet da verour ha da vurevour evit reiñ deoc'h ar binvioù ho peus ezhomm da verañ ar gumuniezh hag endalc'had ar wiki-mañ. Gallout a reot krouiñ merourien ha burevourien all a c'hallo sikour, lemel, adsevel, dilec'hiañ ha gwereziñ ar pajennoù. <br /><br /> Ha prest oc'h da dremen d'ar pazennoù all evit sikour {{SITENAME}} ?",
	'wikiadoption-know-more-header' => "C'hoant gouzout hiroc'h ?",
	'wikiadoption-know-more-description' => "Sellit ouzh al liammoù-se evit gouzout hiroc'h. Ha deuit hardizh e darempred ganimp m'ho peus goulenn pe c'houlenn !",
	'wikiadoption-adoption-successed' => "Gourc'hemennoù ! Merour oc'h bremañ war ar wiki-mañ !",
	'wikiadoption-adoption-failed' => "Digarezit ac'hanomp. Klasket on eus lakaat ac'hanoc'h da verour, met ne ya ket en-dro. Mar plij [http://community.wikia.com/Special:Contact deuit e darempred ganeomp], hag e klaskimp skoazellañ ac'hanoc'h.",
	'wikiadoption-not-allowed' => "Digarezit ac'hanomp. Ne c'hellit ket degemer ar wiki-mañ bremañ.",
	'wikiadoption-not-enough-edits' => "C'hem ! Rankout a rit kaout muioc'h eget 10 degasadenn evit degemer ar wiki-mañ.",
	'wikiadoption-adopted-recently' => "C'hem ! Degemeret ho peus ur wiki n'eus ket pell. Ret 'vo deoc'h gortoz un tammig a-raok gellout degemer ur wiki nevez.",
	'wikiadoption-log-reason' => 'Degemer ur wiki ez-emgefre',
	'wikiadoption-notification' => "$1 a zo prest da vezañ degemeret ! Gellout a rit bezañ ar perc'henn nevez. '''Degemer bremañ !'''", # Fuzzy
	'wikiadoption-mail-first-subject' => "N'hon eus ket gwelet ac'hanoc'h abaoe pell",
	'wikiadoption-mail-first-content' => "Se a ra meur a sizhunvezh n'hon eus gwelet merour ebet war
Demat $1,

#WIKINAME. Ar verourien zo ul lod eus #WIKINAME ha pouezus eo bezañ sur e vezont gwelet ingal. Ma n'eus merour oberiant ebet e-pad ur prantad hir e c'hall ar wiki-mañ bezañ bezañ adkemeret evit ma c'hallo un implijer all dont da vezañ ur merour.


M'ho peus ezhomm da vezañ skoazellet e c'hallit ober war-dro ar wiki-mañ. Gallout a rit ivez aotren izili all eusar gumuniezh da zont vezañ merourien bremañ o vont war $2.

Skipailh Wikia.

Gallout a rit digoumanantiñ ar c'hemmoù diouzh listenn amañ : $3",
	'wikiadoption-mail-first-content-HTML' => "Demat \$1,
Se a ra meur a sizhunvezh n'hon eus ket gwelet merourien war #WIKINAME. Ar verourien zo ul lod eus #WIKINAME ha pouezus eo bezañ sur e vezont gwelet ingal. Ma n'eus merour oberiant ebet e-pad ur prantad hir e c'hall ar wiki-mañ bezañ bezañ adkemeret evit ma c'hallo un implijer all dont da vezañ ur merour. <br/<br/>


M'ho peus ezhomm da vezañ skoazellet e c'hallit ober war-dro ar wiki-mañ. Gallout a rit ivez aotren izili all eus ar gumuniezh da zont da vezañ merourien bremañ o vont war \$2\">merour gwirioù an implijerien</a>. Emichañs e welimp ac'hanoc'h a-benn nebeut war #WIKINAME!<br/><br/>

<b>Skipailh Wikia<br/><br/>

Gallout a rit <a href=\"\$3\">digoumanantiñ diouzh</a> an hizivadurioù eus al listenn-mañ.

Gallout a rit digoumanantiñ ar c'hemmoù diouzh listenn amañ : \$3", # Fuzzy
	'wikiadoption-mail-second-subject' => '#WIKINAME a vo lakaet da zegemer a-benn nebeut',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME a zo bet degemeret',
	'tog-adoptionmails' => 'Kasit din ur gemennadenn ma vez dieub $1 da zegemer',
	'wikiadoption-pref-label' => 'Kemmañ an dibarzhioù-mañ en do un efed war posteloù $1 hepken.',
	'wikiadoption-welcome-header' => "Gourc'hemennoù ! Degemeret hoc'h eus {{SITENAME}} !",
);

/** Bosnian (bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'wikiadoption-header' => 'Usvoji ovu wiki',
	'wikiadoption-button-adopt' => 'Usvoji odmah', # Fuzzy
	'wikiadoption-know-more-header' => 'Želite saznati više?',
	'wikiadoption-adoption-successed' => 'Čestitke! Sada ste administator na ovoj wiki!',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Marcmpujol
 * @author Pintor Smeargle
 * @author Roxas Nobody 15
 * @author Unapersona
 */
$messages['ca'] = array(
	'wikiadoption' => 'Adopció automàtica de wikis',
	'wikiadoption-desc' => 'Una extensió de Adopció Automàtica de Wikis pel MediaWiki',
	'wikiadoption-header' => 'Adopta aquest wiki',
	'wikiadoption-button-adopt' => 'Si, vull adoptar {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Busca més!',
	'wikiadoption-description' => "$1, estàs disposat a adoptar {{SITENAME}}?<br /><br />
No hi ha hagut un administrador actiu al {{SITENAME}} per un temps, i estem buscant un nou líder per ajudar a què aquest contingut wiki i la comunitat creixin! Com que vas contribuir a {{SITENAME}}, ens preguntàvem si voldríeu la feina.
<br /><br />
Mitjançant l'adopció de la wiki, seràs promocionat a administrador i un buròcrata et facilitarà les eines que necessitaràs per gestionar la comunitat i el contingut de la wiki. També seràs capaç de crear altres administradors per ajudar, suprimir, revertir, moure i protegir pàgines.
<br /><br />
Estàs preparat per seguir els propers passos per ajudar {{SITENAME}}?",
	'wikiadoption-know-more-header' => 'Vols saber més?',
	'wikiadoption-know-more-description' => 'Podeu consultar aquests enllaços per obtenir més informació. I per descomptat, no dubti en contactar amb nosaltres si teniu qualsevol pregunta!',
	'wikiadoption-adoption-successed' => 'Felicitats! Ets un ara un administrador en aquest wiki!',
	'wikiadoption-adoption-failed' => 'Ens sap greu. Hem intentat fer-te administrador, però no va funcionar. Si us plau, [http://community.wikia.com/Special:Contact contacta amb nosaltres], i intentarem ajudar-te.',
	'wikiadoption-not-allowed' => 'Ens sap greu. No es pot adoptar aquesta wiki ara mateix.',
	'wikiadoption-not-enough-edits' => 'Vaja!! Cal tenir més de 10 edicions per adoptar aquesta wiki.',
	'wikiadoption-adopted-recently' => "Vaja!! Ja heu adoptat un altre wiki recentment. Haureu d'esperar un temps abans de poder adoptar una nova wiki.",
	'wikiadoption-log-reason' => 'Adopció Automàtica de wikis',
	'wikiadoption-notification' => '{{SITENAME}} ésta en adopció.Estas interessat en convertir-se en un líder aquí? Adopta aquesta wiki per començar! <span class="notranslate" traduir="no">$2</span>',
	'wikiadoption-mail-first-subject' => "No t'hem vist per aquí durant un temps",
	'wikiadoption-mail-first-content' => 'Hola <span class="notranslate" traduir="no">$1</span>,

Fa un parell de setmanes ja hem vist que ets administrador en #WIKINAME. Els administradors són una part integral de  #WIKINAME i és important que tinguin una presència regular. Si no hi ha administradors actius durant un llarg període de temps, aquest wiki serà disponible per a la seva adopció. Això permetrà a un usuari esdevenir administrador.

Si necessites ajuda per tenir cura delwiki, també podeu permetre que altres membres de la comunitat siguin administradors anant a <span class="notranslate" traduir="no">$2</span>. Esperem veure-us a #WIKINAME aviat!!!

Equip de Wikia

Que pot donar-se de baixa d\'aquests correus aquí: <span class="notranslate" traduir="no">$3</span>',
	'wikiadoption-mail-first-content-HTML' => 'Hola <span class="notranslate" traduir="no">$1</span>,<br /><br />

Fa un parell de setmanes ja hem vist que ets administrador #WIKINAME. Els administradors són una part integral de la #WIKINAME i és important que tinguen una presència regular. Si no hi ha cpa actiu en un llarg període de temps, aquest wiki es pot posar cap amunt de per a l\'adopció de permetre a un usuari per esdevenir un administrador.<br /><br />

Si vostè necessita ajuda per tenir cura de la wiki, també podeu permetre que altres membres de la comunitat a ser administradors ara per anar a <a href="<span class="notranslate" traduir="no">$2</span>">gestió de Drets d\'Usuari</a>. Esperem veure-us a #WIKINAME aviat!!!<br /><br />

Equip Comunitari de Wikia <br /><br />

Que podeu <a href="<span class="notranslate" traduir="no">$3</span>">unsubscribe</a> de canvis a aquesta llista.',
	'wikiadoption-mail-second-subject' => '#WIKINAME serà posat en adopció aviat',
	'wikiadoption-mail-second-content' => 'Hola <span class="notranslate" traduir="no">$1</span>,
Oh, no! Ha estat gairebé 60 dies des que hi ha hagut un actiu administrador #WIKINAME. És important que els administradors apareixen regularment i contribuisquen a la wiki perque puga continuar funcionant sense problemes.

Des De fa tants dies ja que no hi ha un administrador actiu, #WIKINAME ara serà ofertat en adopció a altres editors.

Equip Comunitari de Wikia

Que pot donar-se de baixa de canvis a aquesta llista aquí: <span class="notranslate" traduir="no">$3</span>',
	'wikiadoption-mail-second-content-HTML' => 'Hola $1,<br /><br />
Oh, no! Han passat 60 dies sense un administrador actiu a #WIKINAME. És important que els administradors apareixin regularment i contribueixin a la wiki perquè pugui continuar funcionant sense problemes.

Com que fa tants dies de que cap administrador a aparegut, #WIKINAME serà ofert per l\'adopció d\'altres editors. <br /><br />

L\'Equip de Wikia<br /><br />

Pots <a href="$3">cancel·lar la subscripció</a> dels canvis d\'aquesta llista.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME ha estat adoptat',
	'wikiadoption-mail-adoption-content' => "Hi $1,

#WIKINAME ha estat adoptat. Els Wikis es poden adoptar quan cap dels administradors actuals són actius durant 60 dies o més.

L'usuari que adopti #WIKINAME tindrà ara drets de buròcrata i administrador. No et preocupis, tu continuaràs sent administrador d'aquest wiki i seràs benvingut si vols tornar a contribuir!

L'equip de Wikia

Pots cancel·lar la subscripció dels canvis d'aquesta llista aquí:$3",
	'wikiadoption-mail-adoption-content-HTML' => "Hola \$1,<br /><br />

#WIKINAME ha estat adoptat. Les viquis s'han d'adoptar quan cap dels administradors actuals estan actius durant 60 dies o més.<br /><br />
Hi \$1,

#WIKINAME ha estat adoptat. Els Wikis es poden adoptar quan cap dels administradors actuals són actius durant 60 dies o més.

L'usuari que adopti #WIKINAME tindrà ara drets de buròcrata i administrador. No et preocupis, tu continuaràs sent administrador d'aquest wiki i seràs benvingut si vols tornar a contribuir!

L'equip de Wikia

Pots <a href=\"\$3\">cancel·lar la subscripció</a> dels canvis d'aquesta llista.",
	'tog-adoptionmails' => "Envia'm un correu electrònic quan $1 estigui disponible per a l'adopció.",
	'tog-adoptionmails-v2' => '...si el wiki està disponible per a altres usuaris a adoptar',
	'wikiadoption-pref-label' => 'Canviar aquestes preferències afectarà només missatges de correu electrònic des de  $1.',
	'wikiadoption-welcome-header' => 'Felicitats! Heu adoptat {{SITENAME}}!',
	'wikiadoption-welcome-body' => "Ara ets un buròcrata en aquesta wiki. Amb aquest nou estatus, ara tindràs accés a totes les eines que t'ajudaran a gestionar {{SITENAME}}.
<br /><br />
La cosa més important que pots fer per ajudar {{SITENAME}} a créixer és seguir editant.
<br /><br />
Si no hi ha cap administrador actiu en una wiki es pot proposar per a l'adopció, per això assegura't de comprovar la wiki amb regularitat.
<br /><br />
Eines útils:
<br /><br />
[[Special:ThemeDesigner|Dissenyador de Temes]]
<br />
[[Special:LayoutBuilder|Constructor de dissenys de pàgina]]
<br />
[[Special:ListUsers|Llista d'usuaris]]
<br />
[[Special:UserRights|Gestió de drets d'usuari]]",
);

/** Czech (čeština)
 * @author Aktron
 * @author Chmee2
 * @author H4nek
 * @author Jezevec
 */
$messages['cs'] = array(
	'wikiadoption' => 'Automatické přijetí wiki',
	'wikiadoption-header' => 'Přijmout tuto wiki',
	'wikiadoption-button-adopt' => 'Ano, chci přijmout {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Zjistěte více!',
	'wikiadoption-know-more-header' => 'Chcete vědět více?',
	'wikiadoption-adoption-successed' => 'Blahopřejeme! Pro tento okamžik jste správce této wiki.',
	'wikiadoption-adoption-failed' => 'Je nám líto. Pokoušeli jsme se vám přidat správcovská oprávnění, nicméně nespěšně. Můžete nás nicméně [http://community.wikia.com/Special:Contact kontaktovat] a my se vám pokusíme pomoci.',
	'wikiadoption-not-allowed' => 'Je nám to líto. Právě teď nemůžete přijmout tuto wiki.',
	'wikiadoption-not-enough-edits' => 'Ajaj! Jestli chcete tuto wiki přijmout, musíte mít více než 10 editací.',
	'wikiadoption-log-reason' => 'Automatické přijetí Wiki',
	'wikiadoption-mail-first-subject' => 'Chvíli jsme vás zde neviděli',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME byla přijata',
	'tog-adoptionmails' => 'Pošlete mi e-mail, pokud $1 bude k dispozici k převzetí pro ostatní uživatele',
	'tog-adoptionmails-v2' => '...pokud bude wiki k dispozici k převzetí pro ostatní uživatele',
	'wikiadoption-welcome-header' => 'Gratulujeme! Převzal jste {{SITENAME}}!',
);

/** Welsh (Cymraeg)
 * @author Robin Owain
 */
$messages['cy'] = array(
	'wikiadoption' => 'Mabwysiadu wiki awtomatig',
	'wikiadoption-desc' => 'Estyniad OtomaticMabwysiaduWici ar gyfer MediaWiki',
	'wikiadoption-header' => 'Mabwysiadu y wici hwn',
	'wikiadoption-button-adopt' => 'Ydw, rwyf eisiau mabwysiadu{{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Dysgwch ragor!',
	'wikiadoption-know-more-header' => 'Eisiau gwybod mwy?',
	'wikiadoption-adoption-successed' => "Llongyfarchiadau! Rydych chi'n awr yn weinyddwr ar y wici hwn!",
	'wikiadoption-adoption-failed' => 'Yr ydym yn flin. Ceisiasom rich gwneud yn weinyddwr, ond methom. Os gwelwch yn dda [http://community.wikia.com/Special:Contact cysylltwch â ni], a byddwn yn ceisio eich helpu.',
	'wikiadoption-not-allowed' => "Ymddiheurwn! Fedrwch chi ddim mabwysiadu'r wici hwn nawr.",
	'wikiadoption-not-enough-edits' => "Wwwwps! Mae angen dros 10 golygiad cyn y gallwch fabwysiadu'r wici yma.",
);

/** German (Deutsch)
 * @author Avatar
 * @author Claudia Hattitten
 * @author Das Schäfchen
 * @author Geitost
 * @author Inkowik
 * @author LWChris
 * @author Luke081515
 * @author MF-Warburg
 * @author PtM
 * @author Quedel
 * @author SVG
 */
$messages['de'] = array(
	'wikiadoption' => 'Automatische Wiki-Adoption',
	'wikiadoption-desc' => 'Ermöglicht die automatische Adoption eines Wikis',
	'wikiadoption-header' => 'Dieses Wiki adoptieren',
	'wikiadoption-button-adopt' => 'Ja, ich möchte {{SITENAME}} adoptieren!',
	'wikiadoption-adopt-inquiry' => 'Mehr erfahren!',
	'wikiadoption-description' => '$1, willst du {{SITENAME}} adoptieren?
<br /><br />
Auf {{SITENAME}} ist seit einiger Zeit kein aktiver Admin mehr unterwegs und wir suchen einen neuen Leiter, der dem Wiki beim Wachsen helfen soll. Du hast dich in diesem Wiki eingebracht, möchtest du diesen Job übernehmen?
<br /><br />
Durch die Adoption wirst du zum Administrator und Bürokraten befördert, sodass du die Werkzeuge erhältst, um den Inhalt und die Community des Wikis zu verwalten. Du wirst auch die Möglichkeit haben, andere Benutzer zu Administratoren zu ernennen, die beim Löschen, Zurücksetzen und Seitenschützen helfen können.
<br /><br />
Bist du bereit, einen weiteren Schritt zu tun, um {{SITENAME}} zu helfen?',
	'wikiadoption-know-more-header' => 'Möchtest du mehr erfahren?',
	'wikiadoption-know-more-description' => 'Sieh dir diese Links für weitere Informationen an. Und natürlich, zögere nicht, uns zu kontaktieren, wenn du Fragen hast!',
	'wikiadoption-adoption-successed' => 'Herzlichen Glückwunsch! Du bist jetzt ein Administrator in diesem Wiki!',
	'wikiadoption-adoption-failed' => 'Tut uns leid. Wir haben versucht, dich zu einem Administrator zu machen, aber es hat nicht funktioniert. Bitte [http://de.community.wikia.com/wiki/Spezial:Kontakt kontaktiere uns] und wir werden versuchen, dir weiterzuhelfen.',
	'wikiadoption-not-allowed' => 'Tut uns leid. Du kannst dieses Wiki im Moment nicht übernehmen.',
	'wikiadoption-not-enough-edits' => 'Auweia! Du musst mehr als 10 Bearbeitungen getätigt haben, um dieses Wiki adoptieren zu können.',
	'wikiadoption-adopted-recently' => 'Auweia! Du hast in letzter Zeit bereits ein anderes Wiki adoptiert. Du musst eine Weile warten, bevor du ein weiteres Wiki adoptieren kannst.',
	'wikiadoption-log-reason' => 'Automatische Wiki-Adoption',
	'wikiadoption-notification' => '{{SITENAME}} kann adoptiert werden. Möchtest du hier Leiter werden? Adoptiere dieses Wiki, um loszulegen! $2',
	'wikiadoption-mail-first-subject' => 'Wir haben dich eine Weile nicht gesehen',
	'wikiadoption-mail-first-content' => 'Hallo $1,

es ist ein paar Wochen her, dass wir einen Administrator auf #WIKINAME gesehen haben. Administratoren sind eine wesentliche Komponente von #WIKINAME und es ist wichtig, dass sie regelmäßig im Wiki präsent sind. Wenn für längere Zeit keine Administratoren aktiv werden, könnte dieses Wiki zur Adoption freigegeben werden, um einen anderen Benutzer zum Administrator zu ernennen.

Falls du Hilfe bei der Pflege des Wikis brauchst, kannst du auch anderen Mitgliedern des Wikis ermöglichen, Administrator zu werden, indem du $2 aufsuchst.

Auf ein baldiges Wiedersehen in #WIKINAME!

Das Wikia-Team


Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hallo $1, <br /><br />
es ist ein paar Wochen her, dass wir einen Administrator auf #WIKINAME gesehen haben. Administratoren sind eine wesentliche Komponente von #WIKINAME und es ist wichtig, dass sie regelmäßig im Wiki präsent sind. Wenn für längere Zeit keine Administratoren aktiv werden, könnte dieses Wiki zur Adoption freigegeben werden, um einen anderen Benutzer zum Administrator zu ernennen.<br /><br />
Wenn du Hilfe bei der Betreuung des Wikis benötigst, kannst du in der <a href="$2">Benutzerrechteverwaltung</a> auch anderen Community-Mitgliedern erlauben, Administrator zu werden.<br /><br />Auf ein baldiges Wiedersehen in #WIKINAME!<br /><br />
<b>Das Wikia-Team</b> <br /><br />
<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'wikiadoption-mail-second-subject' => '#WIKINAME wird bald zur Adoption freigegeben',
	'wikiadoption-mail-second-content' => 'Hallo $1,

es ist schon fast 60 Tage her, seit ein Administrator auf #WIKINAME aktiv gewesen ist. Es ist wichtig, dass Administratoren regelmäßig vorbeikommen und zum Wiki beitragen, damit es weiterhin rund läuft.

Da es schon so lange her ist, seit einer der derzeitigen Administratoren sich hat blicken lassen, wird #WIKINAME zur Adoption durch andere Benutzer freigegeben.

Das Wikia-Team

Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hallo $1,<br /><br />
es ist schon fast 60 Tage her, seit ein Administrator auf #WIKINAME aktiv gewesen ist. Es ist wichtig, dass Administratoren regelmäßig vorbeikommen und zum Wiki beitragen, damit es weiterhin rund läuft.<br /><br />

Da es schon so lange her ist, seit einer der derzeitigen Administratoren sich hat blicken lassen, wird #WIKINAME zur Adoption durch andere Benutzer freigegeben.<br /><br />

Das Wikia-Team<br /><br />

<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME wurde adoptiert',
	'wikiadoption-mail-adoption-content' => 'Hallo $1,

#WIKINAME wurde adoptiert!  Wikis können adoptiert werden, wenn keiner der derzeitigen Administratoren für mindestens 60 Tage aktiv gewesen ist.

Der #WIKINAME adoptierende Benutzer hat nun Bürokraten- und Administratorstatus. Mach dir keine Sorgen - du bist immer noch ein Administrator, und du kannst jederzeit wieder dazustoßen und mitmachen.

Das Wikia-Team

Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hallo $1,<br /><br />
#WIKINAME wurde adoptiert!  Wikis können adoptiert werden, wenn keiner der derzeitigen Administratoren für mindestens 60 Tage aktiv gewesen ist.<br /><br />
Der #WIKINAME adoptierende Benutzer hat nun Bürokraten- und Administratorstatus. Mach dir keine Sorgen - du bist immer noch ein Administrator, und du kannst jederzeit wieder dazustoßen und mitmachen.<br /><br />
Das Wikia-Team<br /><br />
<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'tog-adoptionmails' => 'Benachrichtige mich per E-Mail, wenn $1 zur Adoption durch andere Benutzer freigegeben wird',
	'tog-adoptionmails-v2' => '… wenn das Wiki für andere Benutzer zur Adoption freigegeben wird.',
	'wikiadoption-pref-label' => 'Eine Änderung dieser Einstellungen wirkt sich nur auf E-Mails von $1 aus.',
	'wikiadoption-welcome-header' => 'Gratulation! Du hast {{SITENAME}} adoptiert!',
	'wikiadoption-welcome-body' => 'Du bist in diesem Wiki nun ein Bürokrat. Damit hast du nun Zugang zu allen Werkzeugen, um {{SITENAME}} zu verwalten.
<br /><br />
Am meisten hilfst du {{SITENAME}} beim Wachsen immer noch, indem du weiterhin Seiten bearbeitest.
<br /><br />
Wenn in einem Wiki kein aktiver Administrator vorhanden ist, kann es zur Adoption freigegeben werden, also solltest du regelmäßig im Wiki vorbeischauen.
<br /><br />
Hilfreiche Werkzeuge:
<br /><br />
[[Special:ThemeDesigner|Theme-Designer]]
<br />
[[Special:LayoutBuilder|Layout-Ersteller]]
<br />
[[Special:ListUsers|Benutzerliste]]
<br />
[[Special:UserRights|Rechteverwaltung]]',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author Geitost
 */
$messages['de-formal'] = array(
	'wikiadoption-notification' => '{{SITENAME}} kann adoptiert werden. Möchten Sie hier Leiter werden? Adoptieren Sie dieses Wiki, um anzufangen! $2',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'wikiadoption' => 'Otomatik Adaptasyonê Wiki',
	'wikiadoption-header' => 'Ena wiki umışiyê',
	'wikiadoption-button-adopt' => 'E, ez qayıla umışê {{SITENAME}} bê!',
	'wikiadoption-adopt-inquiry' => 'Dehana zaf melumat!',
	'wikiadoption-know-more-header' => 'Şıma zewbi çıçi zanê?',
	'wikiadoption-log-reason' => 'Otomatik  Adaptasyonê Wiki',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME biya qebul',
	'wikiadoption-welcome-header' => 'Çımê şıma roşni bê! {{SITENAME}} a şıma biya qebul!',
);

/** Greek (Ελληνικά)
 * @author Glavkos
 */
$messages['el'] = array(
	'wikiadoption-desc' => 'Μια AutomaticWikiAdoption επέκταση για MediaWiki',
	'wikiadoption-header' => 'Υιοθετήστε αυτό το wiki',
	'wikiadoption-button-adopt' => 'Ναι, θέλω να υιοθετήσω {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Μάθετε περισσότερα!',
	'wikiadoption-know-more-header' => 'Θέλεις να μάθεις περισσότερα;',
	'wikiadoption-know-more-description' => 'Ελέγξτε έξω αυτούς τους συνδέσμους για περισσότερες πληροφορίες. Και φυσικά, μη διστάσετε να επικοινωνήσετε μαζί μας αν έχετε οποιαδήποτε ερώτηση!',
	'wikiadoption-adoption-successed' => 'Συγχαρητήρια! Είστε τώρα διαχειριστής σε αυτό το wiki!',
	'wikiadoption-not-allowed' => 'Λυπούμαστε. Δεν μπορείτε να υιοθετήσετε αυτό το wiki τώρα.',
	'wikiadoption-not-enough-edits' => 'Ωχ! Θα πρέπει να έχετε περισσότερα από 10 επεξεργασίες για να υιοθετήσετε αυτό το wiki.',
	'wikiadoption-welcome-header' => 'Συγχαρητήρια! Έχετε πάρει το {{SITENAME}}!',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Dalton2
 * @author Macofe
 * @author VegaDark
 */
$messages['es'] = array(
	'wikiadoption' => 'Adopción automática de wikis',
	'wikiadoption-desc' => 'Una extensión sobre Adopción Automática de Wikis para MediaWiki',
	'wikiadoption-header' => 'Adopta este wiki',
	'wikiadoption-button-adopt' => 'Sí, ¡quiero adoptar a {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => '¡Descubre más!',
	'wikiadoption-description' => '$1, ¿preparado para adoptar {{SITENAME}}?
<br /><br />
No ha habido administradores activos en {{SITENAME}} durante un tiempo, ¡y estamos buscando un nuevo líder que ayude a que el contenido y la comunidad de esta wiki crezcan! Ya que eres alguien que contribuyó en {{SITENAME}}, estamos pensando en si te gustaría el trabajo.
<br /><br />
Al adoptar este wiki, serás ascendido a administrador y burócrata para darte las herramientas que necesitarás para administrar el contenido y la comunidad de la wiki. También tendrás la capacidad de crear otros puestos de administrador para ayudar, borrar, revertir, trasladar y proteger páginas, como también crear grupos de usuario y asignar usuarios a ellos.
<br /><br />
¿Estás preparado para dar los siguientes pasos y ayudar a {{SITENAME}}?',
	'wikiadoption-know-more-header' => '¿Quieres saber más?',
	'wikiadoption-know-more-description' => 'Revisa estos enlaces para obtener más información. Y, por supuesto, ¡no dudes en contactar con nosotros si tienes alguna pregunta!',
	'wikiadoption-adoption-successed' => '¡Felicitaciones! ¡Ahora eres un administrador de este wiki!',
	'wikiadoption-adoption-failed' => 'Lo sentimos. Intentamos hacerte administrador, pero no ha funcionado. Por favor [http://community.wikia.com/Special:Contact contacta con nosotros], y trataremos de ayudarte.',
	'wikiadoption-not-allowed' => 'Lo sentimos. No puedes adoptar este wiki por ahora.',
	'wikiadoption-not-enough-edits' => '¡Uy! Necesitas tener más de 10 ediciones para adoptar este wiki.',
	'wikiadoption-adopted-recently' => '¡Oops! Ya has adoptado otro wiki recientemente. Necesitas esperar un tiempo antes de que puedas adoptar un nuevo wiki.',
	'wikiadoption-log-reason' => 'Adopción automática de wikis',
	'wikiadoption-notification' => '{{SITENAME}} está en adopción. ¿Estás interesado en ser un líder aquí? ¡Adopta esta wiki para comenzar! $2',
	'wikiadoption-mail-first-subject' => 'No te hemos visto desde hace algún tiempo',
	'wikiadoption-mail-first-content' => 'Hola $1,

Han pasado un par de semanas desde que hemos visto un administrador en #WIKINAME. Los administradores son una parte integral de #WIKINAME y es importante que tengan una presencia regular. Si no hay administradores activos por un gran período de tiempo, esta wiki podría ponerse en adopción y permitirle a otro usuario en ser administrador.

Si necesitas ayuda para cuidar la wiki, puedes permitir que otros usuarios sean administradores haciendo clic en $2. ¡Esperamos verte pronto en #WIKINAME!

El Equipo de Wikia

Haz clic en el siguiente enlace para darte de baja de los cambios a esta lista: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hola $1,<br /><br />
Han pasado un par de semanas desde que hemos visto un administrador en #WIKINAME. Los administradores son una parte integral de #WIKINAME y es importante que tengan una presencia regular. Si no hay administradores activos por un gran período de tiempo, esta wiki podría ponerse en adopción y permitirle a otro usuario en ser administrador.<br /><br />
Si necesitas ayuda para cuidar de la wiki, puedes permitir que otros miembros de la comunidad sean administradores, yendo a <a href="$2">Configuración de permisos de usuarios</a>. ¡Esperamos verte pronto en #WIKINAME!<br /><br />
<b>El Equipo de Wikia</b><br /><br />
Puedes <a href="$3">cancelar tu suscripción</a> para futuros cambios de esta lista.',
	'wikiadoption-mail-second-subject' => '#WIKINAME pronto se pondrá en adopción',
	'wikiadoption-mail-second-content' => 'Hola $1,

¡Oh, no! Han pasado casi 60 días desde que hemos visto a un administrador activo en #WIKINAME. Es importante que los administradores aparezcan regularmente y participen para que el wiki puede continuar trabajando sin problemas.

Ya que han pasado muchos días desde que editó el último administrador activo, #WIKINAME se ofrecerá ahora para su adopción a otros editores.

El Equipo de Wikia

Haz clic en el siguiente enlace para cancelar tu suscripción de esta lista: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hola $1,<br /><br />
¡Oh, no! Han pasado casi 60 días desde que hemos visto a un administrador activo en #WIKINAME. Es importante que los administradores aparezcan regularmente y participen para que el wiki puede continuar trabajando sin problemas.<br /><br />

Ya que han pasado muchos días desde que editó el último administrador activo, #WIKINAME se ofrecerá ahora para su adopción a otros editores.<br /><br />

El Equipo de Wikia<br /><br />

Puedes <a href="$3">cancelar tu suscripción</a>  para cambios en esta lista: $3.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME ha sido adoptado',
	'wikiadoption-mail-adoption-content' => 'Hola $1,

#WIKINAME ha sido adoptado. Los wikis están disponibles para ser adoptadas cuando no hay administradores activos durante 60 días o más.

El usuario que adoptó #WIKINAME ahora tiene los cargos de burócrata y administrador. No te preocupes, aún sigues manteniendo tus cargos en este wiki y eres bienvenido si regresas y continuas participando en cualquier momento.

El Equipo de Wikia

Puede darse de baja de los cambios de esta lista aquí: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hola $1,<br /><br />

#WIKINAME ha sido adoptado. Los wikis están disponibles para ser adoptadas cuando no hay administradores activos durante 60 días o más.<br /><br />

El usuario que adoptó #WIKINAME ahora tiene los cargos de burócrata y administrador. No te preocupes, aún sigues manteniendo tus cargos en este wiki y eres bienvenido si regresas y continuas participando en cualquier momento.<br /><br />

El Equipo de Wikia<br /><br />

Puede<a href="$3">darse de baja</a> de los cambios realizados en esta lista.',
	'tog-adoptionmails' => 'Notificarme por correo electrónico si $1 está disponible para otros usuarios para adoptar.',
	'tog-adoptionmails-v2' => '...si el wiki estuviera disponible para que otros usuarios lo adopten',
	'wikiadoption-pref-label' => 'Cambiar estas preferencias solo afectarán los correos electrónicos de $1.',
	'wikiadoption-welcome-header' => '¡Felicitaciones! ¡Has adoptado a {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Ahora eres burócrata en este wiki. Con tu nuevo cargo, ahora tienes acceso a todas las herramientas que te ayudarán a administrar {{SITENAME}}.
<br /><br />
Lo más importante que puedes hacer para ayudar a {{SITENAME}} es editar con regularidad.
<br /><br />
Si no hay administradores activos en un wiki, este puede ponerse en adopción, así que asegúrate de ingresar en el wiki con frecuencia.
<br /><br />
Herramientas útiles:
<br /><br />
[[Special:ThemeDesigner|Diseñador de temas]]
<br />
[[Special:LayoutBuilder|Creador de plantillas]]
<br />
[[Special:ListUsers|Lista de usuarios]]
<br />
[[Special:UserRights|Administrar permisos de usuarios]]',
);

/** Estonian (eesti)
 * @author KalmerE.
 */
$messages['et'] = array(
	'wikiadoption' => 'Automaatne wiki ülevõtmine',
	'wikiadoption-header' => 'Võta see viki üle',
	'wikiadoption-button-adopt' => 'Jah, võtan üle {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Uuri lähemalt!',
	'wikiadoption-know-more-header' => 'Soovid rohkem teada?',
	'wikiadoption-welcome-body' => 'Oled nüüd selle viki bürograat. Uue õigusega pääsed ligi kõigile tööriistadele, mis aitavad hallata {{SITENAME}}.
<br><br>
Tähtsaim on jätkata redigeerimist, et aidata {{SITENAME}} kasvamist.
<br><br>
Külastage vikit regulaarselt, kuna kui vikis ei ole aktiivset administraatorit saab püüda selle viki ülevõtmist.
<br><br>
Kasulikud tööriistad:
<br><br>
[[Eri:ThemeDesigner|Kujunduse kujundamine]]
<br>
[[Eri:LayoutBuilder|Küljenduse koostur]]
<br>
[[Eri:ListUsers|Kasutajate nimekiri]]
<br>
[[Eri:UserRights|Kasutajate õigused]]', # Fuzzy
);

/** Basque (euskara)
 * @author Subi
 */
$messages['eu'] = array(
	'wikiadoption-adopt-inquiry' => 'Jakin ezazu gehiago!',
	'wikiadoption-know-more-header' => 'Gehiago jakin nahi duzu?',
	'wikiadoption-adoption-successed' => 'Zorionak! Wiki honetako administratzailea zara orain!',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Movyn
 * @author Wayiran
 * @author پاناروما
 */
$messages['fa'] = array(
	'wikiadoption' => 'اتخاذ خودکار ویکی',
	'wikiadoption-header' => 'اتخاذ این ویکی',
	'wikiadoption-button-adopt' => 'هم‌اکنون اتخاذ کن', # Fuzzy
	'wikiadoption-adopt-inquiry' => 'بیشتر بیاب',
	'wikiadoption-know-more-header' => 'چگونه بیشتر بدانیم؟',
	'wikiadoption-adoption-successed' => 'تبریک می‌گوییم! شما اکنون مدیر این ویکی هستید!',
	'wikiadoption-adoption-failed' => 'متاسفیم. ما تلاش کردیم گروه شما را به مدیریت ارتقا دهیم اما عمل نکرد. لطفا [http://community.wikia.com/Special:Contact با ما ارتباط برقرار کنید] تا ما بتوانیم کمک کنیم.',
	'wikiadoption-mail-first-subject' => 'مدتی است شما را این اطراف ندیدیم',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Elseweyr
 * @author Lukkipoika
 * @author Nike
 * @author Tofu II
 * @author Ville96
 */
$messages['fi'] = array(
	'wikiadoption' => 'Automaattinen wikin adoptointi',
	'wikiadoption-desc' => 'AutomaticWikiAdoption -laajennus MediaWikille.',
	'wikiadoption-header' => 'Adoptoi tämä wiki',
	'wikiadoption-button-adopt' => 'Kyllä, haluan adoptoida {{SITENAME}}n!',
	'wikiadoption-adopt-inquiry' => 'Opi lisää!',
	'wikiadoption-description' => '$1, oletko valmis adoptoimaan sivuston {{SITENAME}}?
<br /><br />
Sivustolla {{SITENAME}} ei ole ollut vähään aikaan aktiivista ylläpitäjää, ja nyt etsimmekin uutta johtajaa kasvattamaan tämän wikin sisältöä ja yhteisöä! Koska sinä olet aiemmin osallistunut {{SITENAME}}n muokkaamiseen, haluaisimme tietää, otatko tehtävän vastaan.
<br /><br />
Adoptoimalla tämän wikin sinut ylennetään ylläpitäjäksi sekä byrokraatiksi ja sinulle annetaan tarvittavat työkalut wikiyhteistön ja sen sisällön hallintaan. Sinulla olisi myös kyky luoda avuksesi muita ylläpitäjiä poistaamaan, palauttamaan, siirtämään ja suojaamaan sivuja.
<br /><br />
Oletko valmis ottamaan seuraavat askeleet {{SITENAME}}n auttamiseksi?',
	'wikiadoption-know-more-header' => 'Haluatko tietää enemmän?',
	'wikiadoption-know-more-description' => 'Katso lisätietoja näistä linkeistä. Ota myös vapaasti yhteyttä meihin, mikäli sinulla on kysyttävää!',
	'wikiadoption-adoption-successed' => 'Onnittelut! Olet nyt tämän wikin ylläpitäjä!',
	'wikiadoption-adoption-failed' => 'Yritimme tehdä sinusta ylläpitäjä, mutta valitettavasti se ei onnistunut.[http://community.wikia.com/Special:Contact Ota yhteyttä meihin], niin yritämme auttaa sinua.',
	'wikiadoption-not-allowed' => 'Valitettavasti et voi adoptoida tätä wikiä juuri nyt.',
	'wikiadoption-not-enough-edits' => 'Hups! Sinulla on oltava yli 10 muokkausta, jotta voit adoptoida tämän wikin.',
	'wikiadoption-adopted-recently' => 'Hups! Sinulle on jo myönnetty toinen wiki äskettäin. Sinun on odotettava vähän aikaa ennen kuin voit adoptoida uuden wikin.',
	'wikiadoption-log-reason' => 'Automaattinen wikiadoptointi',
	'wikiadoption-notification' => '{{SITENAME}} odottaa ylläpitäjyyden myöntämistä. Haluaisitko johtajaksi täällä? Aloita adoptoimalla tämä wiki! $2',
	'wikiadoption-mail-first-subject' => 'Emme ole nähneet sinua vähään aikaan',
	'wikiadoption-mail-first-content' => 'Hei $1,

Emme ole nähneet pariin viikkoon ylläpitäjää sivustolla #WIKINAME. Ylläpitäjät ovat olennainen osa sivustoa #WIKINAME ja on tärkeää, että he ovat läsnä säännöllisesti. Jos aktiivista ylläpitäjää ei ole pitkään aikaan, tälle wikille laitetaan ylläpidon myöntämismenettely, jolla sallitaan toisen käyttäjän ryhtyä ylläpitäjäksi.

Jos tarvitset apua wikin ylläpidossa, voit sallia myös yhteisön muiden jäsenten tulla ylläpitäjäksi menemällä kohteeseen $2.  Toivon mukaan näemme sinut pian sivustolla #WIKINAME!

Wikia-ryhmä

Voit perua tilauksen tämän listan muutoksiin täältä: $3',
	'wikiadoption-mail-first-content-HTML' => 'Hei $1,<br /><br />

Emme ole pariin viikkoon nähneet ylläpitäjää sivustolla #WIKINAME. Ylläpitäjät ovat olennainen osa sivustoa #WIKINAME ja on tärkeää, että he ovat läsnä säännöllisesti. Jos aktiivista ylläpitäjää ei näy pitkään aikaan, tämä wiki saatetaan laittaa toisen käyttäjän adoptoitavaksi, jolloin hänelle annetaan ylläpitäjän oikeudet.<br /><br />

Jos tarvitset apua wikin ylläpidossa, voit myös sallia yhteisön muiden jäsenten tulla ylläpitäjiksi muuttamalla <a href="$2">käyttäjien oikeuksia</a>.  Toivomme näkevämme sinut pian sivustolla #WIKINAME! <br /><br />

Wikia-tiimi<br /><br />

Voit <a href="$3">peruuttaa</a> tilauksen tämän listan muutoksiin.',
	'wikiadoption-mail-second-subject' => '#WIKINAME laitetaan adoptoitavaksi pian',
	'wikiadoption-mail-second-content' => 'Hei $1,
Voi ei! On kulunut lähes 60 päivää siitä, kun sivustolla #WIKINAME on viimeksi ollut aktiivinen ylläpitäjä. Wikin toiminnan sujuvuuden kannalta on tärkeää, että ylläpitäjät näkyvät ja muokkaavat säännöllisesti.

Koska ylläpitäjää ei ole näkynyt niin pitkään aikaan, #WIKINAME tarjotaan nyt muiden muokkaajien adoptoitavaksi.

Wikia-tiimi

Voit peruuttaa tilauksen tämän listan muutoksiin täältä: $3',
	'wikiadoption-mail-second-content-HTML' => 'Hei $1,<br /><br />
Voi ei! On kulunut lähes 60 päivää siitä, kun sivustolla #WIKINAME on viimeksi ollut aktiivinen ylläpitäjä. Wikin toiminnan sujuvuuden kannalta on tärkeää, että ylläpitäjät näkyvät ja muokkaavat säännöllisesti.<br /><br />

Koska ylläpitäjää ei ole näkynyt niin pitkään aikaan, #WIKINAME tarjotaan nyt muiden muokkaajien adoptoitavaksi.<br /><br />

Wikia-tiimi<br /><br />

Voit <a href="$3">peruuttaa</a> tilauksen tämän listan muutoksiin.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME on adoptoitu',
	'wikiadoption-mail-adoption-content' => 'Hei $1,

#WIKINAME on adoptoitu. Wikejä voidaan adoptoida kun kukaan sen ylläpitäjistä ei ole ollut aktiivinen vähintään 60:een päivään.

Sivustion #WIKINAME adoptoineella käyttäjällä on nyt byrokraatti- ja ylläpitäjästatus. Älä huoli, sinäkin saat pitää ylläpitäjästatuksesi tässä wikissä ja olet tervetullut palamaan muokkauksen pariin koska tahansa!

Wikia-tiimi

Voit peruuttaa tilauksen tämän listan muutoksiin täältä: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Hei $1,<br /><br />

#WIKINAME on adoptoitu. Wikejä voidaan adoptoida kun kukaan sen ylläpitäjistä ei ole ollut aktiivinen vähintään 60:een päivään.<br /><br />

Sivustion #WIKINAME adoptoineella käyttäjällä on nyt byrokraatti- ja ylläpitäjästatus. Älä huoli, sinäkin saat pitää ylläpitäjästatuksesi tässä wikissä ja olet tervetullut palamaan muokkauksen pariin koska tahansa!<br /><br />

Wikia-tiimi<br /><br />

Voit <a href="$3">peruuttaa</a> tilauksen tämän listan muutoksiin.',
	'tog-adoptionmails' => 'Lähetä minulle sähköpostia, mikäli $1 laitetaan muiden käyttäjien adoptoitavaksi.',
	'tog-adoptionmails-v2' => '...mikäli muille käyttäjille tulee mahdollisuus adoptoida wiki',
	'wikiadoption-pref-label' => 'Näiden asetusten muuttaminen vaikuttaa vain sähköposteihin $1:stä.',
	'wikiadoption-welcome-header' => 'Onneksi olkoon! Olet adoptoinut sivuston {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Olet nyt tämän wikin byrokraatti. Uuden statuksesi avulla pääset käsiksi työkaluihin, jotka auttavat sinua sivuston {{SITENAME}} hallinnassa.
<br /><br />
Tärkeintä sivuston {{SITENAME}} kasvattamisen kannalta on jatkuva muokkaaminen.
<br /><br />
Jos wikissä ei ole aktiivisia ylläpitäjiä, se voidaan laittaa muiden käyttäjien adoptoitavaksi. Pidä siis huoli, että käyt wikillä usein.
<br /><br />
Hyödyllisiä työkaluja:
<br /><br />
[[Special:ThemeDesigner|Teeman suunnittelija]]
<br />
[[Special:LayoutBuilder|Page Layout Builder]]
<br />
[[Special:ListUsers|Lista käyttäjistä]]
<br />
[[Special:UserRights|Hallitse käyttäjäoikeuksia]]',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'wikiadoption' => 'Sjálvvirkandi wiki adopsjón',
	'wikiadoption-desc' => 'Ein AutomatiskWikiAdoption víðkan til MediaWiki',
	'wikiadoption-header' => 'Adoptera hesa wiki',
	'wikiadoption-button-adopt' => 'Ja, eg ynski at adoptera {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Finn útav meira!',
	'wikiadoption-know-more-header' => 'Vilt tú vita meira?',
	'wikiadoption-know-more-description' => 'Hygg nærri at hesum slóðunum fyri at fáa meira kunning. Og halt tær endiliga ikki aftur við at seta teg í samband við okkum, um tú hevur nakrar spurningar!',
	'wikiadoption-adoption-successed' => 'Tillukku! Tú ert nú ein umsitari (administator) á hesi wiki!',
	'wikiadoption-adoption-failed' => 'Vit eru kedd av tí. Vit royndu at gera teg til ein administrator, men tað virkaði ikki. Vinarliga [http://community.wikia.com/Special:Contact set teg í samband við okkum], so skulu vit royna at hjálpa tær.',
	'wikiadoption-not-allowed' => 'Halt okkum til góðar. Tú kanst ikki adoptera hesa wikiina beint nú.',
	'wikiadoption-not-enough-edits' => 'Ups! Tú mást hava gjørt meira enn 10 rættingar, áðrenn tú kanst adoptera hesa wiki.',
	'wikiadoption-adopted-recently' => 'Ups! Tú hevur longu adopterað eina aðra wiki nýliga. Tú noyðist at bíða eitt sindur, áðrenn tú kanst adoptera eina nýggja wiki.',
	'wikiadoption-log-reason' => 'Sjálvvirkandi Wiki-Adopsjón',
	'wikiadoption-notification' => '{{SITENAME}} er lýst til adopsjón. Ert tú áhugað/ur í at gerast leiðari her? Adopterað hesa wiki fyri at koma í gongd! $2',
	'wikiadoption-mail-first-subject' => 'Vit hava ikki nakað til tín eina tíð',
	'wikiadoption-mail-second-subject' => '#WIKINAME verður skjótt sett til adopsjón',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME er blivin adopterað',
	'tog-adoptionmails' => 'Send mær teldupost, um $1 verður tøk til aðrar brúkarar at adoptera',
	'tog-adoptionmails-v2' => '...um wikiin verður tøk fyri aðrar brúkarar at adoptera',
	'wikiadoption-pref-label' => 'At broyta hesar innstillingar fer bert at ávirka teldubrøv frá $1.',
	'wikiadoption-welcome-header' => 'Tillukku! Tú hevur adopterað {{SITENAME}}!',
);

/** French (français)
 * @author 0x010C
 * @author Balzac 40
 * @author Notafish
 * @author Urhixidur
 * @author Verdy p
 * @author Wyz
 * @author Zcqsc06
 */
$messages['fr'] = array(
	'wikiadoption' => 'Adoption de wiki automatique',
	'wikiadoption-desc' => 'Une extension AutomaticWikiAdoption pour MediaWiki',
	'wikiadoption-header' => 'Adopter ce wiki',
	'wikiadoption-button-adopt' => 'Oui, je veux adopter {{SITENAME}} !',
	'wikiadoption-adopt-inquiry' => 'En savoir plus !',
	'wikiadoption-description' => '$1, prêt à adopter {{SITENAME}} ?
<br /><br />
Il n’y a pas eu d’administrateur actif sur {{SITENAME}} depuis un moment et nous recherchons un nouveau responsable pour aider à développer le contenu de ce wiki et en agrandir la communauté ! En tant que personne ayant déjà contribué à {{SITENAME}}, nous nous demandons si vous aimeriez ce travail.
<br /><br />
En adoptant le wiki, vous serez promu administrateur et bureaucrate afin de vous donner les outils dont vous aurez besoin pour gérer la communauté et le contenu du wiki. Vous pourrez créer d’autres administrateurs et bureaucrates pouvant aider, supprimer, restaurer, déplacer et protéger les pages.
<br /><br />
Êtes-vous prêt à passer aux autres étapes pour aider {{SITENAME}} ?',
	'wikiadoption-know-more-header' => 'Vous voulez en savoir plus ?',
	'wikiadoption-know-more-description' => 'Veuillez consultez ces liens pour plus d’informations. Et, bien entendu, n’hésitez pas à nous contacter si vous avez des questions !',
	'wikiadoption-adoption-successed' => 'Félicitations ! Vous êtes maintenant administrateur sur ce wiki !',
	'wikiadoption-adoption-failed' => 'Nous sommes désolés. Nous avons essayé de vous nommer administrateur, mais cela n’a pas fonctionné. Veuillez [http://community.wikia.com/Special:Contact nous contacter], et nous allons essayer de vous aider.',
	'wikiadoption-not-allowed' => 'Nous sommes désolés. Vous ne pouvez pas adopter ce wiki maintenant.',
	'wikiadoption-not-enough-edits' => 'Oups ! Vous devez avoir plus de 10 contributions pour adopter ce wiki.',
	'wikiadoption-adopted-recently' => 'Oups ! Vous avez adopté un wiki récemment. Vous allez devoir attendre un peu avant de pouvoir adopter un nouveau wiki.',
	'wikiadoption-log-reason' => 'Adoption de wiki automatique',
	'wikiadoption-notification' => '{{SITENAME}} est prêt à être adopté. Intéressé de devenir un meneur ici ? Adopter ce wiki pour commencer ! $2',
	'wikiadoption-mail-first-subject' => 'Nous ne vous avons pas vu depuis un bon moment',
	'wikiadoption-mail-first-content' => 'Bonjour $1,

Cela fait quelques semaines que nous n’avons pas vu d’administrateur sur #WIKINAME. Les administrateurs sont une partie intégrante de #WIKINAME et il est important de s’assurer de leur présence régulière. S’il n’y a aucun administrateur actif durant une longue période, ce wiki peut être placé à l’adoption afin de permettre à un autre utilisateur d’en devenir un administrateur.

Si vous avez besoin d’aide pour vous occuper du wiki, vous pouvez également autoriser d’autres membres de la communauté à devenir maintenant administrateurs en allant sur $2.

L’équipe de Wikia.

Vous pouvez vous désabonner des modifications de cette liste ici : $3.',
	'wikiadoption-mail-first-content-HTML' => 'Bonjour $1,<br /><br />

Cela fait quelques semaines que nous n’avons pas vu d’administrateur sur #WIKINAME. Les administrateurs font partie intégrante de #WIKINAME et il est important de s’assurer de leur présence régulière. S’il n’y a aucun administrateur actif durant une longue période de temps, ce wiki peut être placé à l’adoption afin de permettre à un autre utilisateur d’en devenir un administrateur.<br /><br />

Si vous avez besoin d’aide pour vous occuper du wiki, vous pouvez aussi permettre à d’autres membres de la communauté de devenir maintenant des administrateurs en allant dans le <a href="$2">gestionnaire des droits des utilisateurs</a>. Nous espérons vous voir bientôt sur #WIKINAME !<br /><br />

<b>L’équipe Wikia</b><br /><br />

Vous pouvez <a href="$3">vous désabonner</a> des mises à jour de cette liste.',
	'wikiadoption-mail-second-subject' => '#WIKINAME sera bientôt placé à l’adoption',
	'wikiadoption-mail-second-content' => 'Bonjour $1,

Oh non ! Cela fait presque 60 jours qu’il n’y a eu aucun administrateur actif sur #WIKINAME. Il est important que des administrateurs apparaissent régulièrement et y contribuent afin que le wiki puisse continuer à fonctionner sans problème.

Puisque cela fait tant de jours qu’aucun des administrateurs actuels n’est apparu, #WIKINAME sera maintenant offert à l’adoption par d’autres contributeurs.

L’équipe Wikia

Vous pouvez vous désabonner des mises à jour de cette liste ici : $3.',
	'wikiadoption-mail-second-content-HTML' => 'Bonjour $1,<br /><br />
Oh non ! Cela fait pratiquement 60 jours qu’il n’y a eu aucun administrateur actif sur #WIKINAME. Il est important que des administrateurs apparaissent régulièrement et contribuent afin que le wiki puisse continuer de fonctionner sans problème.<br /><br />

Puisque cela fait tant de jours qu’aucun administrateur actif n’est apparu, #WIKINAME sera maintenant offert à l’adoption aux autres contributeurs.<br /><br />

L’équipe Wikia<br /><br />

Vous pouvez <a href="$3">vous désabonner</a> des mises à jour de cette liste.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME a été adopté',
	'wikiadoption-mail-adoption-content' => 'Bonjour $1,

#WIKINAME a été adopté. Les wikis sont placés à l’adoption lorsqu’aucun des administrateurs actuels n’y a été actif durant 60 jours ou plus.

L’utilisateur qui a adopté #WIKINAME y aura maintenant les statuts de bureaucrate et administrateur. Ne vous inquiétez pas, vous conserverez aussi votre statut d’administrateur sur ce wiki et vous restez bienvenu pour y retourner et continuer d’y contribuer à tout moment !

L’équipe Wikia

Vous pouvez vous désabonner des mises à jour de cette liste ici : $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Bonjour $1,<br /><br />

#WIKINAME a été adopté. Les wikis sont placés à l’adoption lorsqu’aucun des administrateurs actuels n’y ont été actifs pendant 60 jours ou plus.<br /><br />

L’utilisateur ayant adopté #WIKINAME y aura maintenant les statuts de bureaucrate et administrateur. Ne vous inquiétez pas, vous conserverez votre statut d’administrateur sur ce wiki et vous restez bienvenu pour y retourner et continuer d’y contribuer à tout moment !<br /><br />

L’équipe Wikia<br /><br />

Vous pouvez <a href="$3">vous désabonner</a> des mises à jour de cette liste.',
	'tog-adoptionmails' => "Envoyez-moi un message si $1 devient disponible à l'adoption",
	'tog-adoptionmails-v2' => '...si le wiki devient disponible à l’adoption',
	'wikiadoption-pref-label' => 'La modification de ces préférences affectera seulement les courriels de $1.',
	'wikiadoption-welcome-header' => 'Félicitations ! Vous avez adopté {{SITENAME}} !',
	'wikiadoption-welcome-body' => 'Vous êtes maintenant bureaucrate sur ce wiki. Avec votre nouveau statut, vous avez maintenant accès à tous les outils qui vous aideront à gérer {{SITENAME}}.
<br /><br />
La chose la plus importante pour aider {{SITENAME}} à grandir est de développer son contenu.
<br /><br />
S’il n’y a pas d’administrateur actif sur un wiki, il peut devenir disponible à l’adoption, veillez donc à venir fréquemment surveiller le wiki.
<br /><br />
Outils très utiles :
<br /><br />
[[Special:ThemeDesigner|Concepteur de thème]]
<br />
[[Special:LayoutBuilder|Générateur de mise en page]]
<br />
[[Special:ListUsers|Liste des utilisateurs]]
<br />
[[Special:UserRights|Gérer les droits]]',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wikiadoption' => 'Adopción de wiki automática',
	'wikiadoption-desc' => 'Unha extensión de adopción de wiki automática para MediaWiki',
	'wikiadoption-header' => 'Adoptar este wiki',
	'wikiadoption-button-adopt' => 'Si, quero adoptar {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Descubra máis!',
	'wikiadoption-description' => '$1, listo para adoptar {{SITENAME}}?
<br /><br />
{{SITENAME}} non ten ningún administrador activo desde hai tempo, e estamos á procura dun novo líder para axudar a que os contidos e a comunidade do wiki medren! Dado que é un dos que colaboraron activamente en {{SITENAME}}, preguntámonos se lle gustaría o cargo.
<br /><br />
Ao adoptar este wiki, converterase en administrador e burócrata e recibirá as ferramentas que necesita para xestionar o wiki. Tamén terá a posibilidade de dar permisos de administrador a outros usuarios para que axuden, borren, revertan vandalismos e movan e protexan páxinas.
<br /><br />
Está preparado para dar os seguntes pasos e axudar a {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Quere descubrir máis?',
	'wikiadoption-know-more-description' => 'Bótelle unha ollada a estas ligazóns para obter máis información. E, por suposto, síntase libre de poñerse en contacto con nós se ten algunha pregunta!',
	'wikiadoption-adoption-successed' => 'Parabéns! Agora xa é un administrador deste wiki!',
	'wikiadoption-adoption-failed' => 'Sentímolo. Intentamos convertelo en administración, pero non o conseguimos. [http://community.wikia.com/Special:Contact Póñase en contacto con nós] e intentaremos axudalo.',
	'wikiadoption-not-allowed' => 'Sentímolo. Nestes intres non pode adoptar este wiki.',
	'wikiadoption-not-enough-edits' => 'Vaites! Necesita facer máis de 10 edicións para adoptar o wiki.',
	'wikiadoption-adopted-recently' => 'Vaites! Recentemente adoptou outro wiki. Terá que agardar un tempo antes de poder adoptar un novo wiki.',
	'wikiadoption-log-reason' => 'Adopción de wiki automática',
	'wikiadoption-notification' => '{{SITENAME}} está listo para a adopción. Está interesado en converterse no líder? Adopte este wiki para comezar! $2',
	'wikiadoption-mail-first-subject' => 'Levamos sen velo bastante tempo',
	'wikiadoption-mail-first-content' => 'Ola $1:

Hai un par de semanas que non vemos un administrador en #WIKINAME. Os administradores son unha parte esencial de #WIKINAME e é importante que teñan unha presenza regular. Se non hai administradores activos durante un longo período de tempo, este wiki pode prepararse para a adopción co fin de permitir que outro usuario sexa o administrador.

Se necesita axuda para coidar o wiki, tamén pode permitir que outros membros da comunidade sexan administradores visitando $2. Agardamos velo por #WIKINAME axiña!

O equipo de Wikia

Pode cancelar a subscrición á lista de cambios aquí: $3',
	'wikiadoption-mail-first-content-HTML' => 'Ola $1:<br /><br />

Hai un par de semanas que non vemos un administrador en #WIKINAME. Os administradores son unha parte esencial de #WIKINAME e é importante que teñan unha presenza regular. Se non hai administradores activos durante un longo período de tempo, este wiki pode prepararse para a adopción co fin de permitir que outro usuario sexa o administrador.<br /><br />

Se necesita axuda para coidar o wiki, tamén pode permitir que outros membros da comunidade sexan administradores visitando <a href="$2">a xestión dos dereitos de usuario</a>. Agardamos velo por #WIKINAME axiña!<br /><br />

O equipo de Wikia<br /><br />

Pode <a href="$3">cancelar a subscrición</a> á lista de cambios.',
	'wikiadoption-mail-second-subject' => '#WIKINAME estará listo para a adopción en breve',
	'wikiadoption-mail-second-content' => 'Ola $1:
Por desgraza, hai case 60 días que non hai un administrador activo en #WIKINAME. É importante que os administradores aparezan e colaboren regularmente de xeito que o wiki poida continuar funcionando sen problemas.

Dado que non houbo administradores activos durante moitos días, #WIKINAME ofrecerá a súa adopción aos outros editores.

O equipo de Wikia

Pode cancelar a subscrición á lista de cambios aquí: $3',
	'wikiadoption-mail-second-content-HTML' => 'Ola $1:<br /><br />
Por desgraza, hai case 60 días que non hai un administrador activo en #WIKINAME. É importante que os administradores aparezan e colaboren regularmente de xeito que o wiki poida continuar funcionando sen problemas.<br /><br />

Dado que non houbo administradores activos durante moitos días, #WIKINAME ofrecerá a súa adopción aos outros editores.<br /><br />

O equipo de Wikia<br /><br />

Pode <a href="$3">cancelar a subscrición</a> á lista de cambios.',
	'wikiadoption-mail-adoption-subject' => 'Adoptaron #WIKINAME',
	'wikiadoption-mail-adoption-content' => 'Ola $1:

#WIKINAME foi adoptado. Os wikis están dispoñibles para a súa adopción cando ningún dos administradores mostrou actividade en 60 días ou máis.

O usuario que adoptou #WIKINAME terá dereitos de administrador e burócrata. Non se preocupe, seguirá tendo dereitos de administrador neste wiki e agardamos que regrese e continúe colaborando cando queira!

O equipo de Wikia

Pode cancelar a subscrición á lista de cambios aquí: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Ola $1:<br /><br />

#WIKINAME foi adoptado. Os wikis están dispoñibles para a súa adopción cando ningún dos administradores mostrou actividade en 60 días ou máis.<br /><br />

O usuario que adoptou #WIKINAME terá dereitos de administrador e burócrata. Non se preocupe, seguirá tendo dereitos de administrador neste wiki e agardamos que regrese e continúe colaborando cando queira!<br /><br />

O equipo de Wikia<br /><br />

Pode <a href="$3">cancelar a subscrición</a> á lista de cambios.',
	'tog-adoptionmails' => 'Enviádeme un correo electrónico se $1 está dispoñible para a adopción por parte doutros usuarios',
	'tog-adoptionmails-v2' => '...se o wiki está dispoñible para a adopción por parte doutros usuarios',
	'wikiadoption-pref-label' => 'A modificación destas preferencias afectará soamente os correos electrónicos de $1.',
	'wikiadoption-welcome-header' => 'Parabéns! Adoptou {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Xa é burócrata deste wiki. Cos seus novos dereitos agora ten acceso a todas as ferramentas que axudarán a xestionar {{SITENAME}}.
<br /><br />
A cousa máis importante que pode facer para axudar a que {{SITENAME}} siga medrando é continuar editando.
<br /><br />
Se non hai administradores activos nun wiki, este pode prepararse para a súa adopción, así que sería bo revisar o wiki con frecuencia.
<br /><br />
Ferramentas de axuda:
<br /><br />
[[Special:ThemeDesigner|Deseñador de temas visuais]]
<br />
[[Special:LayoutBuilder|Creador de deseños de páxinas]]
<br />
[[Special:ListUsers|Lista de usuarios]]
<br />
[[Special:UserRights|Xestionar os dereitos]]',
);

/** Hebrew (עברית)
 * @author LaG roiL
 */
$messages['he'] = array(
	'wikiadoption' => 'אימוץ ויקי אוטומטי',
	'wikiadoption-header' => 'אימוץ מיזם זה',
	'wikiadoption-button-adopt' => 'כן, ברצוני לאמץ את {{SITENAME}}.',
	'wikiadoption-adopt-inquiry' => 'מידע נוסף',
	'wikiadoption-description' => '$1, {{GENDER:מוכן|מוכנה}} לאמץ את {{SITENAME}}?
<br /><br />
כבר מזמן לא היה מפעיל מערכת פעיל ב-{{SITENAME}}, ואנחנו מחפשים {{GENDER:מנהיג חדש שיעזור|מנהיגה חדשה שתעזור}} להרחיב את תוכן וקהילת המיזם! בתור {{GENDER:משתמש שתרם|משתמשת שתרמה}} ל-{{SITENAME}}, תהינו אם היית {{GENDER:מסכים|מסכימה}} לתפקיד.
<br /><br />
בעזרת אימוץ המיזם, {{GENDER:תהיה|תהיי}} ל{{GENDER:מפעיל מערכת ובירוקרט|מפעילת מערכת ובירוקרטית}} על מנת לקבל את הכלים  לניהול קהילת ותוכן המיזם. בוסף, {{GENDER:תוכל|תוכלי}} לגייס מפעילי מערכת נוספים על מנת לעזור, למחוק, לשחזר, להעביר ולהגן על דפים.
<br /><br />
{{GENDER:מוכן|מוכנה}} לנקוט את הצעדים הבאים בסיוע ל-{{SITENAME}}?',
	'wikiadoption-know-more-header' => 'רוצים לדעת עוד?',
	'wikiadoption-know-more-description' => 'בדקו את הקישורים להלן למידע נוסף. וכמובן, תרגישו חופשיים לפנות אלינו במידת הצורך!',
	'wikiadoption-adoption-successed' => 'כל הכבוד! כעת {{GENDER:אתה מפעיל מערכת|את מפעילת מערכת}} במיזם זה!',
	'wikiadoption-adoption-failed' => 'מצטערים. ניסינו למנותך ל{{GENDER:מפעיל מערכת|מפעילת מערכת}}, אך הדבר לא עבד. אנא [http://community.wikia.com/Special:Contact {{GENDER:פנה אלינו|פני אלינו}}], וננסה לעזור לך.',
	'wikiadoption-not-allowed' => 'מצטערים. כעת אינך {{GENDER:יכול|יכולה}} לאמץ את מיזם זה.',
	'wikiadoption-not-enough-edits' => 'עליך להיות {{GENDER:בעל|בעלת}} למעלה מ-10 עריכות על מנת לאמץ את מיזם זה.',
	'wikiadoption-adopted-recently' => 'לאחרונה כבר אימצת מיזם אחד. {{GENDER:תיאלץ|תיאלצי}} לחכות זמן מה לפני ש{{GENDER:תוכל|תוכלי}} לאמץ מיזם חדש.',
	'wikiadoption-log-reason' => 'אימוץ ויקי אוטומטי',
	'wikiadoption-notification' => '{{SITENAME}} זמין לאימוץ. {{GENDER:מעוניין|מעוניינת}} להיות ל{{GENDER:מנהיג|מנהיגה}} שם? {{GENDER:אמץ|אמצי}} את המיזם ו{{GENDER:תתחיל|תתחילי}}! $2',
	'wikiadoption-mail-first-subject' => 'מזמן לא ראינו אותך',
	'wikiadoption-mail-first-content' => 'שלום, $1,

עברו כמה שבועות לאחר שהיה לנו מפעיל/ת מערכת ב-#WIKINAME. מפעילי מערכת הם חלק אינטגרלי מ-#WIKINAME וחשוב שהם יהיו בסביבה בקביעות. אם לא יהיו מפעילי מערכת פעילים למשך תקופה ארוכה, ייתכן כי מיזם זה יהיה לאימוץ על מנת לאפשר למשתמש/ת אחר/ת להיות למפעיל/ת מערכת.

אם תזדקק/י לעזרה בטיפול במיזם, ניתן לתת לחברי קהילה אחרים להיות עכשיו למפעילים על ידי לחיצה כאן: $2.  מקווים לראותך ב-#WIKINAME בקרוב!

צוות ויקיה

ניתן לבטל את המנוי לשינויים ברשימה זו כאן: $3',
	'wikiadoption-mail-second-subject' => '#WIKINAME יהיה זמין לאימוץ בקרוב',
	'wikiadoption-mail-second-content' => 'Hi $1,
אוי ואבוי! עברו כמעט 60 ימים מאז שהיה מפעיל מערכת פעיל ב-#WIKINAME. חשוב שמפעילי מערכת יהיו ויתרמו בקביעות על מנת להבטיח על תפקוד תקני של המיזם.

מכיוון שעברו כל כך הרבה ימים מאז הופעת מפעיל מערכת פעיל, #WIKINAME יהיה זמין לאימוץ על ידי עורכים אחרים.

צוות ויקיה

ניתן לבטל את המנוי לשינויים ברשימה כאן: $3',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME אומץ',
	'wikiadoption-mail-adoption-content' => 'שלום, $1.

#WIKINAME אומץ. מיזמי ויקיה זמינים לאימוץ כשאף אחד ממפעילי המערכת הנוכחיים לא פעיל במשך 60 ימים ומעלה.

ה{{GENDER:משתמש המאמץ|משתמשת המאמצת}} של #WIKINAME {{GENDER:יהיה|תהיה}} עכשיו {{GENDER:בעל|בעלת}} מעמד בירוקרט ומפעיל מערכת. אל דאגה, מעמד {{GENDER|מפעיל המערכת|מפעילת המערכת}} שלך במיזם זה יישאר, והינך {{GENDER|מוזמן|מוזמנת}} לשוב ולהמשיך לתרום בכל עת!

צוות ויקיה

ניתן לבטל את המנוי לשינויים ברשימה כאן: $3',
	'tog-adoptionmails' => 'שלחו לי הודעת דוא"ל אם $1 יהיה זמין לאימוץ על ידי משתמשים אחרים.',
	'tog-adoptionmails-v2' => 'אם המיזם יהיה זמין לאימוץ על ידי משתמשים אחרים...',
	'wikiadoption-pref-label' => 'שינוי ההעדפות הללו יחל רק על הודעות דוא"ל מ$1.',
	'wikiadoption-welcome-header' => 'כל הכבוד! אימצת את {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'כעת {{GENDER:אתה בירוקרט|את בירוקרטית}} במיזם זה. עם מעמדך החדש, {{GENDER:אתה עכשיו בעל|את עכשיו בעלת}} גישה לכל הכלים שיעזרו לך לנהל את {{SITENAME}}.
<br /><br />
הדבר החשוב ביותר ש{{GENDER:תוכל|תוכלי}} לעשות על מנת לעזור להרחיב את {{SITENAME}} הוא להמשיך לערוך.
<br /><br />
אם אין מפעיל מערכת פעיל במיזם, ניתן למסורו לאימוץ, ולכן מומלץ לבדוק את המיזם לעתים קרובות.
<br /><br />
כלים שימושיים:
<br /><br />
[[Special:ThemeDesigner|מעצב ערכת נושא]]
<br />
[[Special:LayoutBuilder|בונה תסדיר דף]]
<br />
[[Special:ListUsers|רשימת משתמשים]]
<br />
[[Special:UserRights|ניהול הראשות]]',
);

/** Hunsrik (Hunsrik)
 * @author Paul Beppler
 */
$messages['hrx'] = array(
	'wikiadoption' => 'Automatische Wiki-Adoption',
	'wikiadoption-desc' => 'Ermöchlicht die automatische Adoption von en Wiki',
	'wikiadoption-header' => 'Das Wiki adoptiere',
	'wikiadoption-button-adopt' => 'Jo, ich möcht {{SITENAME}} adoptiere!',
	'wikiadoption-adopt-inquiry' => 'Meahr erfoohre!',
	'wikiadoption-log-reason' => 'Automatische Wiki-Adoption',
);

/** Hungarian (magyar)
 * @author Csega
 * @author Dani
 * @author TK-999
 */
$messages['hu'] = array(
	'wikiadoption' => 'Automatikus wiki örökbefogadás',
	'wikiadoption-desc' => 'AutomaticWikiAdoption (automatikus wiki&ndash;örökbefogadás) kiterjesztés a MediaWikihez',
	'wikiadoption-header' => 'Wiki örökbefogadása',
	'wikiadoption-button-adopt' => 'Igen, szeretném örökbefogadni a(z) {{SITENAME}}-t!',
	'wikiadoption-adopt-inquiry' => 'Tudj meg többet!',
	'wikiadoption-description' => '$1, készen állsz a(z) {{SITENAME}} örökbefogadására?
<br /><br />
Egy ideje nem volt aktív adminisztrátor a(z) {{SITENAME}} wikin, és új vezetőt keresünk a wiki tartalmának és közösségének gyarapítására! Mint a(z) {{SITENAME}} közreműködője, téged kérünk fel erre a feladatra.
<br /><br />
A wiki örökbefogadásával adminisztrátor és bürokrata jogokat kapsz, hogy hozzájuss a wiki közösségének és tartalmának kezeléséhez szükséges eszközökhöz. Előléptethetsz más adminisztrátokat is, hogy segítsenek, töröljenek, visszaállítsanak, átnevezzenek és levédjenek oldalakat.
<br /><br />
Készen állsz a(z) {{SITENAME}} megsegítéséhez szükséges következő lépések megtételére?',
	'wikiadoption-know-more-header' => 'Szeretnél többet tudni?',
	'wikiadoption-know-more-description' => 'Kövesd ezeket a hivatkozásokat további információért. Lépj kapcsolatba velünk, ha bármilyen kérdésed van!',
	'wikiadoption-adoption-successed' => 'Gratulálunk! Immár a wiki adminisztrátora vagy!',
	'wikiadoption-adoption-failed' => 'Megpróbáltunk adminisztrátorrá tenni, de nem sikerült. Kérjük, [http://community.wikia.com/Special:Contact lépj kapcsolatba velünk], hogy segíthessünk.',
	'wikiadoption-not-allowed' => 'Sajnáljuk, jelenleg nem fogadhatod örökbe ezt a wikit.',
	'wikiadoption-not-enough-edits' => 'Hoppá! Több mint 10 szerkesztés szükséges a wiki örökbefogadásához.',
	'wikiadoption-adopted-recently' => 'Hoppá! Nemrégiben már örökbefogadtál egy másik wikit, így várnod kell, míg más wikiket is örökbefogadhatsz.',
	'wikiadoption-log-reason' => 'Automatikus wiki–örökbefogadás',
	'wikiadoption-notification' => 'A(z) {{SITENAME}} örökbefogadható. Szeretnél rajta vezető lenni? Fogadd örökbe a wikit kezdésként! $2',
	'wikiadoption-mail-first-subject' => 'Már nem láttunk téged erre egy ideje',
	'wikiadoption-mail-first-content' => 'Szia, $1!

Már jó néhány hete nem volt adminisztrátor a(z) #WIKINAME wikin. Az adminisztrátorok a(z) #WIKINAME szerves részét képezik és gyakori jelenlétük fontos. Ha hoszzú ideig nincsenek aktív adminisztrátorok, a wiki elérhető lesz örökbefogadásra, hogy más felhasználóknak is lehetővé tegye az adminisztrátorrá válást.

Ha segítségre van szükséged a wiki gondozásában, a közösség más tagjait is előléptetheted adminisztrátorokká a(z) $2 oldalon.  Remáljük, hamarosan látunk a(z) #WIKINAME wikin!
A Wikia csapat

Ezen lista változtatásairól itt iratkozhatsz le: $3',
	'wikiadoption-mail-first-content-HTML' => 'Szia, $1!<br /><br />

Már jó néhány hete nem volt adminisztrátor a(z) #WIKINAME wikin. Az adminisztrátorok a(z) #WIKINAME szerves részét képezik és gyakori jelenlétük fontos. Ha hoszzú ideig nincsenek aktív adminisztrátorok, a wiki elérhető lesz örökbefogadásra, hogy más felhasználóknak is lehetővé tegye az adminisztrátorrá válást.<br /><br />

Ha segítségre van szükséged a wiki gondozásában, a közösség más tagjait is előléptetheted adminisztrátorokká a <a href="$2">felhasználói jogok kezelése</a> oldalon.  Remáljük, hamarosan látunk a(z) #WIKINAME wikin!<br /><br />
A Wikia csapat<br /><br />

Ezen lista változtatásairól <a href="$3">itt</a> iratkozhatsz le.',
	'wikiadoption-mail-second-subject' => 'A(z) #WIKINAME hamarosan örökbefogadható lesz.',
	'wikiadoption-mail-second-content' => 'Szia, $1!
Jaj, ne! Már majdnem hatvan napja nem volt aktív adminisztrátor a(z) #WIKINAME wikin. Fontos, hogy az adminisztrátorok gyakran megjelenjenek és szerkesszenek, mivel így a wiki zökkenőmentesen fog működni.

Mivel ennyire sok napja nem jelent meg adminisztrátor, a(z) #WIKINAME mostantól más szerkesztők örökbefogadhatják.

A Wikia csapat.

Ezen lista változtatásairól itt iratkozhatsz le: $3',
	'wikiadoption-mail-second-content-HTML' => 'Szia, $1!<br /><br />
Jaj, ne! Már majdnem hatvan napja nem volt aktív adminisztrátor a(z) #WIKINAME wikin. Fontos, hogy az adminisztrátorok gyakran megjelenjenek és szerkesszenek, mivel így a wiki zökkenőmentesen fog működni.!<br /><br />

Mivel ennyire sok napja nem jelent meg adminisztrátor, a(z) #WIKINAME mostantól más szerkesztők örökbefogadhatják.!<br /><br />

A Wikia csapat.!<br /><br />

Ezen lista változtatásairól <a href="$3">itt</a> iratkozhatsz le',
	'wikiadoption-mail-adoption-subject' => 'A(z) #WIKINAME-t örökbefogadták.',
	'wikiadoption-mail-adoption-content' => 'Szia, $1!

A(z) #WIKINAME wikit örökbefogadták. Egy wikit akkor lehet örökbefogadni, ha egyik adminisztrátora sem aktív hatvan vagy több napig.

A(z) #WIKINAME wikit örökbefogadó felhasználó mostantól bürokrata és adminisztrátor státusszal rendelkezik.  Ne aggódj, te is megtartod adminisztrátori pozíciódat és bármikor visszatérhetsz szerkeszteni!

A Wikia csapat

Ezen lista változtatásairól itt iratkozhatsz le: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Szia, $1!<br /><br />

A(z) #WIKINAME wikit örökbefogadták. Egy wikit akkor lehet örökbefogadni, ha egyik adminisztrátora sem aktív hatvan vagy több napig.<br /><br />

A(z) #WIKINAME wikit örökbefogadó felhasználó mostantól bürokrata és adminisztrátor státusszal rendelkezik.  Ne aggódj, te is megtartod adminisztrátori pozíciódat és bármikor visszatérhetsz szerkeszteni!<br /><br />

A Wikia csapat<br /><br />

Ezen lista változtatásairól <a href="$3">itt</a> iratkozhatsz le.',
	'tog-adoptionmails' => 'E-mail küldése, amennyiben $1 hozzáférhető válik örökbefogadásra más felhasználók által.',
	'tog-adoptionmails-v2' => '...ha a wikit más felhasználók is örökbefogadhatják.',
	'wikiadoption-pref-label' => 'Ezen beállítások módosítása csak az $1-ről érkező e-maileket befolyásolja.',
	'wikiadoption-welcome-header' => 'Gratulálunk! Örökbefogadtad a {{SITENAME}}-t!',
	'wikiadoption-welcome-body' => 'Immár bürokrata vagy ezen a wikin. Új pozíciódban a {{SITENAME}} kezeléséhez szükséges összes szköz elérhető számodra.
<br /><br />
A {{SITENAME}} növekedését segítő legfontosabb tett a szerkesztés folytatása.
<br /><br />
Ha nincs aktív adminisztrátor a wikin, azt örökbefogadhatják, tehát nézz be gyakran.
<br /><br />
Hasznos eszközök:
<br /><br />
[[Special:ThemeDesigner|Stílustervező]]
<br />
[[Special:LayoutBuilder|Oldalfelépítés-tervező]]
<br />
[[Special:ListUsers|Felhasználók listája]]
<br />
[[Special:UserRights|Jogok kezelése]]',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wikiadoption' => 'Adoption automatic de wikis',
	'wikiadoption-desc' => 'Un extension de MediaWiki pro adoption automatic de wikis',
	'wikiadoption-header' => 'Adoptar iste wiki',
	'wikiadoption-button-adopt' => 'Si, io vole adoptar {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Lege plus!',
	'wikiadoption-description' => '$1, es tu preste a adoptar {{SITENAME}}?
<br /><br />
Il non ha habite un administrator active in {{SITENAME}} durante un tempore, e nos cerca un nove dirigente pro adjutar a facer le communitate e contento de iste wiki crescer! Tu ha contribuite multo a {{SITENAME}}. Vole tu prender le posto?
<br /><br />
Adoptar iste wiki significa que tu essera promovite a administrator e bureaucrate. Isto te da accesso al instrumentos necessari pro gerer le communitate e contento del wiki. Tu potera assignar altere administratores pro adjutar, deler, reverter, renominar e proteger paginas.
<br /><br />
Es tu preste a prender le proxime passos pro adjutar {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Vole saper plus?',
	'wikiadoption-know-more-description' => 'Explora iste ligamines pro plus informationes. E, naturalmente, sia libere de contactar nos si tu ha questiones!',
	'wikiadoption-adoption-successed' => 'Felicitationes! Tu es ora administrator de iste wiki!',
	'wikiadoption-adoption-failed' => 'Nos lo regretta: nos ha tentate facer te administrator, ma le procedura non ha succedite. Per favor [http://community.wikia.com/Special:Contact contacta nos], e nos tentara adjutar te.',
	'wikiadoption-not-allowed' => 'Nos regretta que tu non pote adoptar iste wiki justo ora.',
	'wikiadoption-not-enough-edits' => 'Ups! Tu debe haber facite plus de 10 modificationes pro poter adoptar iste wiki.',
	'wikiadoption-adopted-recently' => 'Ups! Tu ha jam adoptate un wiki recentemente. Tu debe attender un certe tempore ante que tu pote adoptar un altere wiki.',
	'wikiadoption-log-reason' => 'Adoption automatic de wikis',
	'wikiadoption-notification' => '{{SITENAME}} es disponibile pro adoption. Ha tu interesse in devenir un dirigente hic? Adopta iste wiki pro comenciar! $2',
	'wikiadoption-mail-first-subject' => 'Nos non te ha vidite durante un tempore',
	'wikiadoption-mail-first-content' => 'Salute $1,

Ha passate plure septimanas desde que nos videva un administrator active in tu wiki. Le administratores face un parte integral de #WIKINAME e lor presentia regular es importante. Si il non ha administratores active durante multe tempore, iste wiki pote esser rendite disponibile pro adoption pro permitter a un altere usator de devenir administrator.

Si tu require adjuta a facer attention al wiki, tu pote permitter a altere membros del communitate de devenir administrator per visitar $2. Nos spera de vider te tosto in #WIKINAME!

Le equipa de Wikia

Clicca super le ligamine sequente pro non plus reciper cambios a iste lista: $3',
	'wikiadoption-mail-first-content-HTML' => 'Salute $1,<br /><br />

Ha passate plure septimanas desde que nos videva un administrator active in tu wiki. Le administratores face un parte integral de #WIKINAME e lor presentia regular es importante. Si il non ha administratores active durante multe tempore, iste wiki pote esser rendite disponibile pro adoption pro permitter a un altere usator de devenir administrator.<br /><br />

Si tu require adjuta a facer attention al wiki, tu pote permitter a altere membros del communitate de devenir administrator per visitar <a href="$2">Gestion de derectos de usatores</a>. Nos spera de vider te tosto in #WIKINAME!<br /><br />

Le equipa de Wikia<br /><br />

Clicca super le ligamine sequente pro <a href="$3">non plus reciper cambios</a> a iste lista.',
	'wikiadoption-mail-second-subject' => '#WIKINAME essera tosto rendite disponibile pro adoption',
	'wikiadoption-mail-second-content' => 'Salute $1,

Oh, no! Quasi 60 dies ha passate depost que nos ha vidite un administrator active in #WIKINAME. Es importante que administratores appare regularmente e contribue pro assecurar le bon functionamento del wiki.

Post que ha passate tante dies desde le apparentia de un administrator actual, #WIKINAME essera ora offerite pro adoption a altere contributores.

Le equipa de Wikia

Pro cancellar le subscription al cambios in iste lista: $3',
	'wikiadoption-mail-second-content-HTML' => 'Salute $1,<br /><br />

Oh, no! Quasi 60 dies ha passate depost que nos ha vidite un administrator active in #WIKINAME. Es importante que administratores appare regularmente e contribue pro assecurar le bon functionamento del wiki.<br /><br />

Post que ha passate tante dies desde le apparentia de un administrator actual, #WIKINAME essera ora offerite pro adoption a altere contributores.<br /><br />

Le equipa de Wikia<br /><br />

Tu pote <a href="$3">cancellar le subscription</a> al cambios in iste lista.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME ha essite adoptate',
	'wikiadoption-mail-adoption-content' => 'Salute $1,

#WIKINAME ha essite adoptate. Wikis deveni disponibile pro adoption si nulle administrator actual es active durante 60 dies o plus.

Le usator adoptante de #WIKINAME habera ora le stato de bureaucrate e administrator. Non te inquieta; tu retenera tamben le stato de administrator in iste wiki, e tu es benvenite a retornar e continuar a contribuer a omne tempore!

Le equipa de Wikia

Pro cancellar le subscription a cambios in iste lista: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Salute $1,<br /><br />

#WIKINAME ha essite adoptate. Wikis deveni disponibile pro adoption si nulle administrator actual es active durante 60 dies o plus.<br /><br />

Le usator adoptante de #WIKINAME habera ora le stato de bureaucrate e administrator. Non te inquieta; tu retenera tamben le stato de administrator in iste wiki, e tu es benvenite a retornar e continuar a contribuer a omne tempore!<br /><br />

Le equipa de Wikia<br /><br />

Tu pote <a href="$3">cancellar le subscription</a> a cambios in iste lista.',
	'tog-adoptionmails' => 'Inviar me e-mail si $1 devenira disponibile pro adoption per altere usatores',
	'tog-adoptionmails-v2' => '...si le wiki devenira disponibile pro adoption per altere usatores',
	'wikiadoption-pref-label' => 'Modificar iste preferentias influentiara solmente le messages de e-mail ab $1.',
	'wikiadoption-welcome-header' => 'Felicitationes! Tu ha adoptate {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Tu es ora bureaucrate in iste wiki. Con tu nove stato, tu ha recipite accesso a tote le instrumentos que te adjutara a gerer {{SITENAME}}.
<br /><br />
Le cosa le plus importante que tu pote facer pro adjutar a facer {{SITENAME}} crescer es continuar a contribuer contento.
<br /><br />
Si il non ha un administrator active in un wiki illo pote esser rendite disponibile pro adoption, dunque assecura te de revider le wiki frequentemente.
<br /><br />
Instrumentos utile:
<br /><br />
[[Special:ThemeDesigner|Designator de apparentias]]
<br />
[[Special:LayoutBuilder|Constructor de dispositiones de pagina]]
<br />
[[Special:ListUsers|Lista de usatores]]
<br />
[[Special:UserRights|Gestion de derectos]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author C5st4wr6ch
 * @author Fate Kage
 * @author Riemogerz
 */
$messages['id'] = array(
	'wikiadoption' => 'Adopsi wiki otomatis',
	'wikiadoption-desc' => 'Ekstensien AutomaticWikiAdoption untuk MediaWiki',
	'wikiadoption-header' => 'Mengadopsi wiki ini',
	'wikiadoption-button-adopt' => 'Ya, saya ingin mengadopsi {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Cari tahu lebih lanjut!',
	'wikiadoption-description' => '$1, siap untuk mengadopsi {{SITENAME}}?
<br /><br />
Belum ada pengurus aktif pada {{SITENAME}} untuk sementara, dan kami sedang mencari pemimpin baru untuk membantu tumbuh kembang komunitas dan konten wiki ini! Kami berharap Anda mau menjadi pengurus untuk {{SITENAME}}.
<br /><br />
Dengan mengadopsi wiki, Anda akan dipromosikan menjadi pengurus dan birokrat yang diberikan peralatan khusus untuk mengelola komunitas dan konten wiki. Anda juga akan mampu mengangkat pengurus baru untuk membantu, menghapus, mengembalikan, memindahkan dan melindungi halaman.
<br /><br />
Apakah Anda siap untuk membantu kami dalam {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Ingin mengetahui lebih banyak?',
	'wikiadoption-know-more-description' => 'Periksalah pranala ini untuk informasi lebih lanjut. Dan tentu saja, silakan hubungi kami jika Anda memiliki pertanyaan!',
	'wikiadoption-adoption-successed' => 'Selamat! Anda sekarang adalah pengurus di wiki ini!',
	'wikiadoption-adoption-failed' => 'Kami mohon maaf. Kami telah mencoba untuk menjadikan Anda pengurus, tetapi ini tidak berjalan. Silakan [http://community.wikia.com/Special:Contact hubungi kami], dan kami akan mencoba untuk membantu Anda.',
	'wikiadoption-not-allowed' => 'Mohon maaf. Anda belum bisa mengadopsi wiki ini sekarang.',
	'wikiadoption-not-enough-edits' => 'Ups! Anda perlu memiliki lebih dari 10 suntingan untuk mengadopsi wiki ini.',
	'wikiadoption-adopted-recently' => 'Ups! Anda baru-baru ini telah mengadopsi wiki lain. Anda akan perlu menunggu beberapa saat sebelum Anda dapat mengadopsi sebuah wiki baru.',
	'wikiadoption-log-reason' => 'Adopsi Wiki Otomatis',
	'wikiadoption-notification' => '{{SITENAME}} tersedia untuk diadopsi. Tertarik untuk menjadi pemimpin di sini? Adopsi wiki ini untuk memulai! $2',
	'wikiadoption-mail-first-subject' => 'Kami belum melihat Anda di sini selama beberapa waktu',
	'wikiadoption-mail-first-content' => 'Hai $1,

Telah beberapa minggu sejak kami melihat seorang pengurus di #WIKINAME. Pengurus adalah bagian integral dari #WIKINAME dan penting untuk mereka memiliki kehadiran yang teratur. Jika tidak ada pengurus yang aktif untuk jangka waktu yang lama, wiki ini mungkin dapat diletakkan untuk diadopsi untuk mengizinkan pengguna lain menjadi pengurus.

Jika Anda memerlukan bantuan untuk merawat wiki ini, Anda juga dapat mengizinkan anggota komunitas lainnya untuk menjadi pengurus sekarang dengan mengunjungi $2. Sampai berjumpa di #WIKINAME segera!

Tim Wikia

Anda dapat berhenti berlangganan dari perubahan dalam daftar ini di sini: $3',
	'wikiadoption-mail-first-content-HTML' => 'Hai $1,<br /><br />

Telah beberapa minggu sejak kami melihat seorang pengurus di #WIKINAME. Pengurus adalah bagian integral dari #WIKINAME dan penting bagi mereka untuk hadir dengan teratur. Jika tidak ada pengurus yang aktif untuk jangka waktu yang lama, wiki ini mungkin dapat diletakkan untuk diadopsi untuk mengizinkan pengguna lain menjadi pengurus.<br /><br />

Jika Anda memerlukan bantuan untuk merawat wiki ini, Anda juga dapat mengizinkan anggota komunitas lainnya untuk menjadi pengurus sekarang dengan mengunjungi <a href="$2">pengelolaan hak pengguna</a>. Sampai berjumpa di #WIKINAME segera!<br /><br />

Tim Wikia<br /><br />

Anda dapat <a href="$3">berhenti berlangganan</a> dari perubahan dalam daftar ini.',
	'wikiadoption-mail-second-subject' => '#WIKINAME akan segera disiapkan untuk mengadopsi',
	'wikiadoption-mail-second-content' => 'Hai $1,
Oh, tidak! Sudah hampir 60 hari sejak adanya pengurus aktif pada #WIKINAME. Penting bahwa pengurus secara teratur muncul dan berkontribusi sehingga wiki dapat berlanjut untuk berjalan dengan mulus.<br /><br />

Karena sudah begitu banyak hari sejak kemunculan pengurus saat ini, #WIKINAME kini akan ditawarkan untuk diadopsi ke penyunting lain.

Tim Wikia

Anda dapat berhenti berlangganan dari perubahan dalam daftar ini: $3',
	'wikiadoption-mail-second-content-HTML' => 'Hai $1,<br /><br />
Oh, tidak! Sudah hampir 60 hari sejak adanya pengurus aktif pada #WIKINAME. Penting bahwa pengurus secara teratur muncul dan berkontribusi sehingga wiki dapat berlanjut untuk berjalan dengan mulus.<br /><br />

Karena sudah begitu banyak hari sejak kemunculan pengurus saat ini, #WIKINAME kini akan ditawarkan untuk diadopsi ke penyunting lain.<br /><br />

Tim Wikia<br /><br />

Anda dapat <a href="$3">berhenti berlangganan</a> dari perubahan dalam daftar ini.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME telah diadopsi',
	'wikiadoption-mail-adoption-content' => 'Hai $1,

#WIKINAME telah diadopsi. Wiki tersedia untuk diadopsi ketika tidak ada pengurus saat ini yang aktif hingga 60 hari atau lebih.

Pengguna pengadopsi #WIKINAME kini akan memiliki status birokrat dan pengurus. Jangan khawatir, Anda juga akan mendapatkan kembali status pengurus pada wiki ini dan disambut untuk kembali dan melanjutkan berkontribusi kapanpun!

Tim Wikia

Anda dapat berhenti berlangganan dari perubahan pada daftar ini di sini: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Hai $1,<br /><br />

#WIKINAME telah diadopsi. Wiki tersedia untuk diadopsi ketika tidak ada pengurus saat ini yang aktif hingga 60 hari atau lebih.<br /><br />

Pengguna pengadopsi #WIKINAME kini akan memiliki status birokrat dan pengurus. Jangan khawatir, Anda juga akan mendapatkan kembali status pengurus pada wiki ini dan disambut untuk kembali dan melanjutkan berkontribusi kapanpun!<br /><br />

Tim Wikia<br /><br />

Anda dapat <a href="$3">berhenti berlangganan</a> dari perubahan pada daftar ini.',
	'tog-adoptionmails' => 'Email saya jika  $1  akan menjadi tersedia untuk pengguna lain untuk mengadopsi',
	'tog-adoptionmails-v2' => '...jika wiki akan tersedia bagi pengguna lain untuk diadopsi',
	'wikiadoption-pref-label' => 'Mengubah preferensi ini hanya akan mempengaruhi surel dari $1.',
	'wikiadoption-welcome-header' => 'Selamat! Anda telah mengadopsi {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Anda sekarang adalah birokrat di wiki ini. Dengan status baru Anda sekarang Anda memiliki akses ke seluruh peralatan yang akan membantu Anda mengelola {{SITENAME}}.
<br /><br />
Hal paling penting yang dapat Anda lakukan untuk membantu {{SITENAME}} tumbuh adalah terus menyunting.
<br /><br />
Jika tidak ada pengurus aktif pada sebuah wiki, wiki dapat diambil untuk diangkat / diadopsi, jadi pastikan untuk memeriksa wiki secara berkala.
<br /><br />
Peralatan yang Membantu:
<br /><br />
[[Special:ThemeDesigner|ThemeDesigner]] <br /> [[Special:LayoutBuilder|Page Layout Builder]] <br /> [[Special:ListUsers|Daftar Pengguna]] <br /> [[Special:UserRights|Kelola Hak]]',
);

/** Italian (italiano)
 * @author Darth Kule
 * @author Gianfranco
 * @author Minerva Titani
 * @author PeppeAeco
 * @author TecnoMaster
 * @author Ximo17
 */
$messages['it'] = array(
	'wikiadoption' => 'Adozione Automatica di Wiki',
	'wikiadoption-desc' => "Un'estensione di AutomaticWikiAdoption per MediaWiki",
	'wikiadoption-header' => 'Adotta questa wiki',
	'wikiadoption-button-adopt' => 'Sì, voglio adottare {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Per saperne di più!',
	'wikiadoption-description' => "$1, pronto ad adottare {{SITENAME}}?
<br /> <br />
Non c'è stato un amministratore attivo su {{SITENAME}} per un po ', e stiamo cercando un nuovo leader per aiutare il contenuto di questo wiki e la comunità a crescere! Come qualcuno che ha contribuito a {{SITENAME}} ci chiedevamo se desidera il lavoro.
<br /> <br />
Adottando il wiki, ti verrà promosso a amministratore e burocrate e vi verranno dati gli strumenti necessari per gestire la comunità del wiki e i contenuti. Potrai anche essere in grado di creare altri amministratori per aiutare, eliminare, ripristinare, spostare e proteggere le pagine.
<br /> <br />
Sei pronto a fare i prossimi passi per aiutare {{SITENAME}}?",
	'wikiadoption-know-more-header' => 'Vuoi saperne di più?',
	'wikiadoption-know-more-description' => 'Per maggiori informazioni clicca sui seguenti links. Ovviamente, per qualsiasi problema non esitare a contattarci!',
	'wikiadoption-adoption-successed' => 'Congratulazioni! Ora sei amministratore di questo wiki!',
	'wikiadoption-adoption-failed' => 'Ci spiace. Abbiamo provato a renderti amministratore, ma pare esserci qualche problema. Per favore [http://community.wikia.com/Special:Contact contattaci], e proveremo di nuovo ad aiutarti.',
	'wikiadoption-not-allowed' => 'Ci spiace. Attualmente non puoi adottare questo wiki.',
	'wikiadoption-not-enough-edits' => 'Oops! Devi avere più di 10 edits per adottare questo wiki.',
	'wikiadoption-adopted-recently' => "Oop! Hai già adottato un altro wiki recentemente. Devi aspettare un po' di tempo prima di adottarne un altro.",
	'wikiadoption-log-reason' => 'Adozione Automatica di Wiki',
	'wikiadoption-notification' => '{{SITENAME}} è in adozione. Sei interessato a diventare un leader qui? Adottare questo wiki per iniziare! 2$', # Fuzzy
	'wikiadoption-mail-first-subject' => "non ti abbiamo visto in giro per un po'",
	'wikiadoption-mail-adoption-subject' => '#WIKINAME è stata adottata',
	'tog-adoptionmails' => "Mandami una mail se $1 diventa disponibile per l'adozione da parte di altri utenti",
	'tog-adoptionmails-v2' => "...se la wiki diventa disponibile per l'adozione da parte di altri utenti",
	'wikiadoption-pref-label' => 'Il cambio di queste preferenze si ripercuoterà solo sulle email da $1.',
	'wikiadoption-welcome-header' => 'Complimenti! Tu hai adottato {{SITENAME}}!',
);

/** Japanese (日本語)
 * @author Barrel0116
 * @author BryghtShadow
 */
$messages['ja'] = array(
	'wikiadoption' => '自動ウィキ採用',
	'wikiadoption-header' => 'このウィキを採用する',
	'wikiadoption-button-adopt' => 'はい、私は{{SITENAME}}を採用したいと思います！',
	'wikiadoption-adopt-inquiry' => '詳細を調べる！',
	'wikiadoption-know-more-header' => 'もっと知りたいですか？',
	'wikiadoption-mail-adoption-subject' => '#WIKINAMEが採用されました',
	'wikiadoption-welcome-header' => 'おめでとうございます！あなたは{{SITENAME}}を採用しました！',
);

/** Kannada (ಕನ್ನಡ)
 * @author Dimension10
 */
$messages['kn'] = array(
	'wikiadoption' => 'ಸ್ವಯಂಚಾಲಿತ ವಿಕಿ ದತ್ತು',
	'wikiadoption-desc' => 'ಮೆದಿಯ ವಿಕಿ ಇಗೆ ಒಂದು ಸ್ವಯಂಚಾಲಿತ ವಿಕಿ ದತ್ತು ವಿಸ್ತಾರ',
	'wikiadoption-header' => 'ಈ ವಿಕಿವನ್ನು  ದತ್ತು ಸ್ವೀಕಾರ ಮಾಡಿ',
	'wikiadoption-button-adopt' => 'ಹವದು, ನನಗೆ {{SITENAME}} ಅನ್ನು ದತ್ತು ಸ್ವೀಕಾರ ಮಾಡಬೇಕು!',
	'wikiadoption-adopt-inquiry' => 'ಇನ್ನೂ ಗೊತ್ತು ಮಾದೊಕೊಳ್ಳಿ!',
	'wikiadoption-description' => '$1, {{SITENAME}}ಅನ್ನು ದತ್ತು ಮಾದಕೊಳಿಕೆ ನೀವು ತಯ್ಯಾರು ಇದ್ದೀರಾ?
<br /><br />
{{SITENAME}} ಅಲ್ಲಿ  ಸುಮಾರು ದಿನದಿಂದ ಒಂದುಸಹ  ಸಕ್ರೀಯ ನೇತಾ  ಇರಲಿಲ್ಲ, ಮತ್ತು ನಾವು ಒಂದು ಅಂತ ಹೊಸ ನೇತಾನಿಗೆ ಹುಡುಕುತ ಇದ್ದೇವೆ, ಯಾರು ಈ ವಿಕಿ ಯ  ವಿಷಯ, ಮತ್ತು ಸಾಮಾಜ, ಎರಡರಲ್ಲಿ ಸಹ  ವೃತ್ತಿ ಮಾಡಿಸಲಿಕ್ಕೆ ಸಾಮರ್ಥ್ಯ ಇದ್ದಾರೆ . ನೀವು {{SITENAME}}ಇಗೆ ಒಂದು ಕೊಡುಗೆ ಆದ ಕಾರಣ ನಾವು ಆಲೋಚನೆ ಮಾಡುತ ಇತ್ತು ಎಂತ ಅಂದರೆ ನಿಮಗೆ ಈ ಕೆಲಸ ಕುಶಿ ಆಗ ಬಹುದ ಏನೋ, ಅಂತ ಹೆಲಿ.
 <br /><br />
ಈ ವಿಕಿ ಅನ್ನು ದತ್ತು ಮಾದುದಿಂದ ನೀವು ಅಡ್ಮಿನಿಸ್ಟ್ರೇಟರ್ ಮತ್ತು ಬುರೆಔಚ್ರತ್ ಎರದುಸಹ ಆಗುತಿರಿ, ಆವಾಗ ನಿಮಗೆ ಆ ವಿಕಿ ಅನ್ನು ಪ್ರಭಂಧನೆ ಮಾಡಲಿಕ್ಕೆ ಸರಿ ಆದ ಸಲಕರಣೆ ಸಿಗುತದೆ.   ನಿಮಗೆ ಆವಾಗ ಬೇರೆ ನೆತಾಗಳನ್ನುಸಹ ನಿರ್ಮಾಣ ಮಾಡಲಿಕ್ಕೆ ಆಗುತದೆ.
<br /><br />
ನೀವು {{SITENAME}} ಇಗೆ ಸಹಾಯತ ಮಾಡಲಿಕ್ಕೆ ಮುಂದಿನ ಹೆಜ್ಜೆ ಹಾಕಲಿಕ್ಕೆ ತಯ್ಯಾರು ಇದ್ದೀರಾ?',
	'wikiadoption-know-more-header' => 'ಜಾಸ್ತಿ ಗೊತ್ತಾಗಬೇಕ?',
	'wikiadoption-adoption-successed' => 'ಅಭಿನಂದನಗಳು! ನೀವು ಈಗ ಈ ವಿಕಿ ಅಲ್ಲಿ ಒಂದು ಅಡ್ಮಿನಿಸ್ಟ್ರೇಟರ್ ಆಗಿದ್ದೀರಿ!',
	'wikiadoption-adoption-failed' => 'ಕ್ಷಮಿಸಿ. ನಾವು ನಿಮ್ಮನ್ನ ಅಡ್ಮಿನಿಸ್ಟ್ರೇಟರ್ ಮಾಡಲಿಕ್ಕೆ ಪ್ರಯತ್ನ ಮಾಡಿತು, ಆದರೆ ನಮಗೆ ಹಾಗೆ ಮಾಡಲಿಕ್ಕೆ ಆಗಲಿಲಿಲ್ಲ.

ದೈವಿತ್ತು [http://community.wikia.com/Special:Contact ನಮ್ಮಣ್ಣ ಸಂಪರ್ಕ ಮಾಡಿ], ಮತ್ತು ನಾವು ನಿಮಗೆ ಸಹಯತೆ ಮಾಡಲಿಕ್ಕೆ ಪ್ರಯತ್ನ ಮಾದುತೇವೆ!',
	'wikiadoption-not-allowed' => 'ಕ್ಷಮಿಸಿ, ನಿಮಗೆ ಈಗ ಈ ವಿಕಿ ಅನ್ನು ದತ್ತು ಮಾಡಲಿಕ್ಕೆ ಆಗುದು ಇಲ್ಲ.',
	'wikiadoption-not-enough-edits' => 'ಅಯ್ಯಯ್ಯೋ! ನಿಮಗೆ ಈ ವಿಕಿ ವನ್ನು ದತ್ತು ಮಾಡಲಿಕ್ಕೆ ೧೦ ಸಂಪಧನೆಗಳು ಎಂಟು ಇರಲೇ ಬೇಕು!',
	'wikiadoption-adopted-recently' => 'ಅಯ್ಯಯ್ಯೋ! ನೀವು ಮೊನ್ನೆ-ಮೊನ್ನೆ ಅಷ್ಟೇ ಒಂದು ವಿಕಿ ಅನ್ನು ದತ್ತು  ಮಾಡಿದಿರಿ.    ನಿಮಗೆ ಇನ್ನು ಒಂದು ವಿಕಿ ಅನ್ನು ದತ್ತು ಮಾಡಲಿಕ್ಕೆ ಸ್ವಲ್ಪ ಹೊತ್ತು ಕಾಯಿಬೆಕಾಗೊತದೆ.',
	'wikiadoption-log-reason' => 'ಸ್ವಯಂಚಾಲಿತ ವಿಕಿ ದತ್ತು',
	'wikiadoption-notification' => '{{SITENAME}} ದತ್ತು ಸ್ವೀಕರಣಕ್ಕೆ  	ಯೋಗ್ಯ ಉನ್ತು. ಇಲ್ಲಿ ನೇತಾ ಆಗಲಿಕ್ಕೆ ನಿಮ್ಮಗೆ ರುಚಿ ಉಂಟಾ? ಶುರು ಮಾಡಲಿಕ್ಕೆ ಈ ವಿಕಿ ಅನ್ನು ದತ್ತು ಮಾದೊಕೊಲ್ಲಿ! $2',
	'wikiadoption-mail-first-subject' => 'ನಾವು ನಿಮ್ಮನ್ನ ಸ್ವಲ್ಪ ಹೊತ್ತಲ್ಲಿ ನೋಡಲಿಲ್ಲ...',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME ದತ್ತು ಆಗಿ ಬಿತ್ತಿದೆ.',
	'wikiadoption-mail-adoption-content' => 'ನಮಸ್ಕಾರ $1

#WIKINAME ದತ್ತು ಆಗಿ ಹೊಗಿದೆ.    ಸದ್ಯದ್ದು ನೆತಗಳು ೬೦ ದಿಣ್ಣ ಅಥವಾ ಜಾಸ್ತಿ ಸಕ್ರಿಯ ಅಲ್ಲ ಆದಮೇಲೆ ವಿಕಿಗಳು ದತ್ತು ಇಗೆ ಅರ್ಹ ಆಗುತದೆ.

#WIKINAME ಅನ್ನು ದತ್ತು ಮಾಡಿದ ಸದಸ್ಯನಿಗೆ ಅಡ್ಮಿನಿಸ್ಟ್ರೇಟರ್ ಮತ್ತು ಬುರೆಔಚ್ರತ್ ಸ್ಟೇಟಸ್ ಸಿಕ್ಕಿದೆ.    ಚಿಂತೆ ಮಾಡಬೇಡಿ, ನೀವು ಸಹ  ಅಡ್ಮಿನಿಸ್ಟ್ರೇಟರ್ ಇರುತೀರಿ, ಮತ್ತು ಬೇಕಿದ್ದಾಗ ವಾಪುಸ್ ಬಂದು ಪುನಃ ಕೊಡುಗೆ  ಶುರು ಮಾಡ ಬಹುದು.

ವಿಕಿಯ ಸಂಘ

ಈ ಪಟ್ಟಿಯಿಗೆ ಬದಲಾವನಿಗಳಿಂದ ನೀವು ಇಲ್ಲಿ ಅನ್ಸಬ್ಸ್ಕ್ರೈಬ್ ಮಾಡ ಬಹುದು:   $3',
	'wikiadoption-mail-adoption-content-HTML' => 'ನಮಸ್ಕಾರ $1 ,<br /><br />

#WIKINAME ದತ್ತು ಆಗಿ ಹೊಗಿದೆ.    ಸದ್ಯದ್ದು ನೆತಗಳು ೬೦ ದಿಣ್ಣ ಅಥವಾ ಜಾಸ್ತಿ ಸಕ್ರಿಯ ಅಲ್ಲ ಆದಮೇಲೆ ವಿಕಿಗಳು ದತ್ತು ಇಗೆ ಅರ್ಹ ಆಗುತದೆ.     <br /><br />

#WIKINAME ಅನ್ನು ದತ್ತು ಮಾಡಿದ ಸದಸ್ಯನಿಗೆ ಅಡ್ಮಿನಿಸ್ಟ್ರೇಟರ್ ಮತ್ತು ಬುರೆಔಚ್ರತ್ ಸ್ಟೇಟಸ್ ಸಿಕ್ಕಿದೆ.    ಚಿಂತೆ ಮಾಡಬೇಡಿ, ನೀವು ಸಹ  ಅಡ್ಮಿನಿಸ್ಟ್ರೇಟರ್ ಇರುತೀರಿ, ಮತ್ತು ಬೇಕಿದ್ದಾಗ ವಾಪುಸ್ ಬಂದು ಪುನಃ ಕೊಡುಗೆ  ಶುರು ಮಾಡ ಬಹುದು.   <br /><br />

ವಿಕಿಯ ಸಂಘ  <br /><br />

ಈ ಪಟ್ಟಿಯಿಗೆ ಬದಲಾವನಿಗಳಿಂದ ನೀವು <a href=" $3"> ಅನ್ಸಬ್ಸ್ಕ್ರೈಬ್ </a> ಮಾಡ ಬಹುದು.',
	'tog-adoptionmails' => 'ಒಂದು ಪಕ್ಷ $1 ಬೇರೆ ಸದಸ್ಯಗಳಿಗೆ ದತ್ತು ಮಾಡಲಿಕ್ಕೆ ಲಭ್ಯವಿರುವ ಆದರೆ ನನ್ನನ್ನು ಇಮೇಲ್ ಮಾದಿ.',
	'tog-adoptionmails-v2' => '... ಒಂದು ಪಕ್ಷ ಈ ವಿಕಿ ಬೇರೆ ಅವರಿಗೆ ದತ್ತು ಮಾಡಲಿಕ್ಕೆ ಲಭ್ಯವಿರುವ ಆದರೆ',
	'wikiadoption-pref-label' => 'ಈ ಆದ್ಯತೆಗಳನ್ನು ಬದಲೈಸುದರಿಂದ ಬರಿ $1 ಇಂದ ಇಮೇಲ್ ಗಳು ಬರುದು ಮುಗಿತದೆ.',
	'wikiadoption-welcome-header' => 'ಅಭಿನಂದನೆಗಳು! ನೀವು {{SITENAME}} ಅನ್ನು ದತ್ತು ಮಾಡಿಕ್ನೋದುದಿರಿ!',
	'wikiadoption-welcome-body' => 'ನೀವು ಈಗ ಈ ವಿಕಿ ಅಲ್ಲಿ ಒಂದು ಬುರೆಔಚ್ರತ್ ಆಗಿದ್ದಿರಿ.  ನಿಮ್ಮ ಈ ಹೊಸ ಅಂತಸ್ತು ಒಟ್ಟಿಗೆ  ನಿಮಗೆ {{SITENAME}} ಅನ್ನು ಪ್ರಭಂಧನ ಮಾಡಲಿಕ್ಕೆ ಎಲ್ಲ ಉಪಕಾರನೆಗಳು ಉನ್ತು.
<br /><br />
{{SITENAME}}ಅನ್ನು ಬೆಳಿತ ಇರವಾಗೆ ನೋಡುಕೊಳ್ಲಿಕ್ಕೆ ನಿಮಗೆ ಎಲ್ಲಕಿಂತ  ಪ್ರಮುಖ ವಿಷಯ ಮಾಡ ಬಹುದು; ನಿಮ್ಮ ಸಂಪಾದನೆ ವನ್ನು ಮುಂದುವರಿಸುದು.
<br /><br />
ಒಂದು ವಿಕಿ ಅಲ್ಲಿ ಒಂದು ಸಕ್ರಿಯ ನೇತಾ ಇರಲ್ಲಿಲ್ಲಿದರೆ ಅದು ದತ್ತು ಇಗೆ ಮೇಲೆ ಇತ್ತು ಹೊಗುತದೆ.     ಹಾಗಾದ ಕಾರಣ ಅದನ್ನು ಪರಿಶೀಲಿಸಿತ ಇರಿ.
<br /><br />
ಸಹಾಯತ ಮಾಡುವಂತ ಉಪಕರಣಗಳು:
<br /><br />
[[Special:ThemeDesigner|ThemeDesigner]]
<br />
[[Special:LayoutBuilder|Page Layout Builder]]
<br />
[[Special:ListUsers|User List]]
<br />
[[Special:UserRights|Manage Rights]]',
);

/** Korean (한국어)
 * @author Hym411
 * @author Leehoy
 * @author Miri-Nae
 * @author Revi
 * @author 아라
 */
$messages['ko'] = array(
	'wikiadoption' => '자동 관리자 변경',
	'wikiadoption-desc' => '미디어위키 자동 관리자 변경 확장 기능',
	'wikiadoption-header' => '이 위키의 관리자되기',
	'wikiadoption-button-adopt' => '네, {{SITENAME}}의 관리자가 되고 싶습니다!',
	'wikiadoption-adopt-inquiry' => '더 많은 정보!',
	'wikiadoption-description' => '$1 사용자 님, {{SITENAME}}의 관리자가 될 준비가 되셨나요?
<br /><br />
{{SITENAME}}에는 몇 일 동안 관리자가 접속하지 않았습니다. 저희는 {{SITENAME}}에 기여해주고, 새 단장해줄 관리자를 찾고 있습니다! 이 일에 관심이 있으신가요?
<br /><br />
관리자가 되면 관리 권한을 얻게 되며, 위키를 관리하는 데 유용한 도구를 사용할 수 있습니다. 원한다면 다른 사람을 또 다른 관리자로 임명해 문서 관리를 돕게 할 수도 있습니다.
<br /><br />
{{SITENAME}}의 관리자가 되기 위한 다음 단계로 진행할까요?',
	'wikiadoption-know-more-header' => '더 알고 싶으신가요?',
	'wikiadoption-know-more-description' => '자세한 내용은 이 링크를 확인하십시오. 질문이 있다면 원하는대로 저희에게 연락해주세요!',
	'wikiadoption-adoption-successed' => '축하합니다! 당신은 이제 이 위키의 관리자입니다!',
	'wikiadoption-adoption-failed' => '죄송합니다. 저희는 당신을 관리자로 만들기 위해 노력했지만, 불가능했습니다. [http://community.wikia.com/Special:Contact 저희에게 연락]해 주시면 다시 도와드릴 수 있습니다.',
	'wikiadoption-not-allowed' => '죄송합니다. 당신은 현재 이 위키의 관리자가 될 수 없습니다.',
	'wikiadoption-not-enough-edits' => '이런! 이 위키의 관리자가 되기 위해선 적어도 10번은 기여해야 합니다.',
	'wikiadoption-adopted-recently' => '이런! 최근에 다른 위키의 관리자가 된 적이 있습니다. 새 위키의 권한을 얻기 전에 기다려주세요.',
	'wikiadoption-log-reason' => '자동 관리자 변경',
	'wikiadoption-notification' => '{{SITENAME}}에는 관리자 자리가 비어있습니다. 직접 관리자가 되고 싶으신가요? 당장 도전해보세요! $2',
	'wikiadoption-mail-first-subject' => '오랜만입니다',
	'wikiadoption-mail-first-content' => '안녕하세요$1,

#WIKINAME의 관리자가 접속하지 않은 지 몇 주가 지났습니다. 관리자는 #WIKINAME에 있어서 매우 중요한 부분입니다. 관리자가 오랫동안 접속하지 않을 시, 다른 사용자로 관리자가 교체될 수 있습니다.

필요하다면 $2에서 다른 커뮤니티 회원을 관리자로 임명할 수 있습니다. 다음에 또 봐요!

위키아 팀

이곳에서 리스트를 변경하면 주시를 해제할 수 있습니다: $3',
	'wikiadoption-mail-first-content-HTML' => '안녕하세요$1,<br /><br />

#WIKINAME의 관리자가 접속하지 않은 지 몇 주가 지났습니다. 관리자는 #WIKINAME에 있어서 매우 중요한 부분입니다. 관리자가 오랫동안 접속하지 않을 시, 다른 유저로 관리자가 교체될 수 있습니다.<br /><br />

필요하다면 <a href="$2">사용자 권한 조정</a>에서 다른 커뮤니티 회원을 관리자로 임명할 수 있습니다. 다음에 또 봐요!

위키아 팀<br /><br />

<a href="$3">이곳</a>에서 리스트를 변경하면 주시를 해제할 수 있습니다.',
	'wikiadoption-mail-second-subject' => '곧 #WIKINAME의 관리자 권한이 빌 것입니다',
	'wikiadoption-mail-second-content' => '안녕하세요$1,
세상에! #WIKINAME의 관리자가 활동하지 않은 지 거의 60일이 지났습니다. 정상적인 위키 지속에 있어서 관리자의 위키 접속 및 기여는 매우 주요한 부분입니다.

관리자가 너무 오랫동안 접속하지 않을 시, #WIKINAME의 관리자가 교체될 수도 있습니다.

위키아 팀

이곳에서 리스트를 변경하면 주시를 해제할 수 있습니다: $3',
	'wikiadoption-mail-second-content-HTML' => '안녕하세요$1,<br /><br />
세상에! #WIKINAME의 관리자가 활동하지 않은 지 거의 60일이 지났습니다. 정상적인 위키 지속에 있어서 관리자의 위키 접속 및 기여는 매우 주요한 부분입니다.<br /><br />

관리자가 너무 오랫동안 접속하지 않을 시, #WIKINAME의 관리자가 교체될 수도 있습니다.<br /><br />

위키아 팀<br /><br />

<a href="$3">이곳</a>에서 리스트를 변경하면 주시를 해제할 수 있습니다.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME의 관리자가 변경되었습니다',
	'wikiadoption-mail-adoption-content' => '안녕하세요$1,

#WIKINAME의 관리자가 변경되었습니다. 관리자 중 아무도 60일 동안 접속하지 않으면 위키의 관리자가 변경될 수 있습니다.

#WIKINAME의 새로운 관리자는 이제 관리자 권한을 얻게 됩니다. 걱정 마세요, 언제든지 다시 돌아와 관리자 권한을 되찾고, 위키에 기여할 수 수 있으니까요.

위키아 팀

이곳에서 리스트를 변경하면 주시를 해제할 수 있습니다: $3',
	'wikiadoption-mail-adoption-content-HTML' => '안녕하세요$1,<br /><br />

#WIKINAME의 관리자가 변경되었습니다. 관리자 중 아무도 60일 동안 접속하지 않으면 위키의 관리자가 변경될 수 있습니다.<br /><br />

#WIKINAME의 새로운 관리자는 이제 관리자 권한을 얻게 됩니다. 걱정 마세요, 언제든지 다시 돌아와 관리자 권한을 되찾고, 위키에 기여할 수 수 있으니까요.<br /><br />

위키아 팀<br /><br />

<a href="$3">이곳</a>에서 리스트를 변경하면 주시를 해제할 수 있습니다.',
	'tog-adoptionmails' => '$1의 관리자 자리를 내놓을 준비가 되었다면 이메일을 보내주세요',
	'tog-adoptionmails-v2' => '...관리자를 내놓을 준비가 되었다면',
	'wikiadoption-pref-label' => '해당 설정은 $1의 메일 알림에만 영향을 미칩니다.',
	'wikiadoption-welcome-header' => '축하합니다! {{SITENAME}} 프로젝트의 관리자 권한을 얻었습니다!',
	'wikiadoption-welcome-body' => '관리자로 임명되셨습니다. 새로운 권한으로 {{SITENAME}}의 관리를 도와줄 도구를 사용할 수 있습니다.
<br /><br />
{{SITENAME}}를 성장시키는 데 가장 중요한 것은 지속적인 문서 편집입니다.
<br /><br />
자주 위키를 확인하세요. 오랫동안 관리자의 활동이 없으면 관리자가 변경될 수 있습니다.<br /><br />
유용한 도구들:
<br /><br />
[[Special:ThemeDesigner|테마 디자이너]]
<br />
[[Special:LayoutBuilder|페이지 레이아웃 빌더]]
<br />
[[Special:ListUsers|사용자 목록]]
<br />
[[Special:UserRights|권한 조정]]',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wikiadoption' => 'Automatesch Wiki-Adoptioun',
	'wikiadoption-header' => 'Dës Wiki adoptéieren',
	'wikiadoption-button-adopt' => 'Jo, Ech wëll {{SITENAME}} adoptéieren!',
	'wikiadoption-adopt-inquiry' => 'Fir méi ze wëssen!',
	'wikiadoption-know-more-header' => 'Wann Dir méi wësse wëllt.',
	'wikiadoption-adoption-successed' => 'Gratulatioun! Dir sidd elo en Administrateur op dëser Wiki!',
	'wikiadoption-not-allowed' => 'Et deet eis leed. Dir kënnt dës Wiki net direkt adoptéieren.',
	'wikiadoption-not-enough-edits' => 'Ups! Dir musst méi wéi 10 Ännerunge gemaach hu fir dës Wiki adoptéieren ze kënnen.',
	'wikiadoption-log-reason' => 'Automatesch Wiki-Adoptioun',
	'wikiadoption-mail-first-subject' => 'Mir hunn Iech schonn eng Zäit net méi gesinn.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME gouf adoptéiert',
	'wikiadoption-welcome-header' => 'Gratulatioun! Dir hutt {{SITENAME}} adoptéiert!',
);

/** Northern Luri (لوری مینجایی)
 * @author Mogoeilor
 */
$messages['lrc'] = array(
	'wikiadoption' => 'سازگاری خودانجوم ویکی',
	'wikiadoption-header' => 'ای ویکی نه سازگار کو',
	'wikiadoption-adopt-inquiry' => 'بیشتر بفمیت',
	'wikiadoption-know-more-header' => 'میهایت بیشتر بفمیت؟',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 * @author Mantak111
 * @author Vilius
 */
$messages['lt'] = array(
	'wikiadoption' => 'Automatinis wiki priėmimas',
	'wikiadoption-header' => 'Priimti šioje wiki',
	'wikiadoption-button-adopt' => '↓Taip, aš noriu įvaikinti {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Sužinokite daugiau!',
	'wikiadoption-know-more-header' => 'Norite sužinoti daugiau?',
	'wikiadoption-adoption-successed' => 'Sveikiname! Jūs dabar esate šios wiki administratorius!',
	'wikiadoption-not-allowed' => 'Mes atsiprašome. Jus negalite priimti šios wiki dabar.',
	'wikiadoption-not-enough-edits' => 'Oi! Jums reikia būti padarius daugiau negu 10 redagavimų kad galėtumėte priimti šia wiki.',
	'wikiadoption-log-reason' => 'Automatinis Wiki Priėmimas',
	'wikiadoption-notification' => '{{SITENAME}} reikia įvaikinimo. Susidomėjęs tapti lyderiu čia? Įvaikink šią wiki, kad pradėtum! $2',
	'wikiadoption-mail-first-subject' => '↓Mes nematėme jūsų ilgai',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME buvo priimta',
	'wikiadoption-welcome-header' => '↓Sveikinimai! Jūs įvaikinote {{SITENAME}}!',
);

/** Latvian (latviešu)
 * @author Sg ghost
 * @author Srolanh
 */
$messages['lv'] = array(
	'wikiadoption' => 'Automātiska wiki pieņemšana',
	'wikiadoption-desc' => 'Pagarināt AutomaticWikiAdoption MediaWiki',
	'wikiadoption-header' => 'Pieņemt šo wiki',
	'wikiadoption-button-adopt' => 'Jā, es gribu pieņemt {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Uzzini vairāk!',
	'wikiadoption-description' => '$1, gatavs pieņemt {{SITENAME}}?
<br /><br />
Nav bijis aktīvs administrators par {{SITENAME}} uz brīdi, un mēs meklējam jaunu līderi, lai palīdzētu šajā wiki saturu un Kopienas augt! Kā cilvēks, kurš ir veicinājis {{SITENAME}} mēs domājām, ja jūs vēlētos darbu.
<br /><br />
Pieņemot wiki, tu būs paaugstināts par administratoru un birokrāts, lai dotu jums rīkus jums wiki Kopienas un satura pārvaldība. Jūs arī varēsiet izveidot citus administratorus, palīdzēt, dzēst, atrite, pārvietot un aizsargāt lapu.
<br /><br />
Vai esat gatavs veikt tālāk minētās darbības, lai palīdzētu {{SITENAME}}',
	'wikiadoption-know-more-header' => 'Vēlaties uzzināt vairāk?',
	'wikiadoption-know-more-description' => 'Pārbaudiet šīs saites, lai iegūtu vairāk informācijas. Un, protams, nekautrējieties sazināties ar mums, ja jums ir kādi jautājumi!',
	'wikiadoption-adoption-successed' => 'Apsveicam! Jūs esat tagad administrators viki!',
	'wikiadoption-adoption-failed' => 'Mēs atvainojamies. Mēs centāmies, lai jums administratoru, bet tas nestrādāja out. Lūdzu [http://community.wikia.com/Special:Contact contact us], un mēs centīsimies jums palīdzēt out.',
	'wikiadoption-not-allowed' => 'Mēs atvainojamies. Jūs nevarat pieņemt šo wiki tiesības tagad.',
	'wikiadoption-not-enough-edits' => 'Ups! Jums ir nepieciešams, lai būtu vairāk nekā 10 labojumus, lai pieņemtu šo viki.',
	'wikiadoption-adopted-recently' => 'Ups! Jums jau ir pieņēmušas citu wiki nesen. Jums būs jāgaida kādu laiku, pirms jūs varat pieņemt jaunu viki.',
	'wikiadoption-log-reason' => 'Automātiska Viki pieņemšana',
	'wikiadoption-notification' => '{{SITENAME}} ir šo bērnu adopcijai. Ieinteresēti kļūt vadītājs šeit? Pieņem šajā viki, lai sāktu! $2',
	'wikiadoption-mail-first-subject' => 'Mēs neesam redzējuši ap jums, bet',
	'wikiadoption-mail-first-content' => 'Sveiki $1,

Tas ir bijis pāris nedēļas, kopš mēs esam redzējuši administrators #WIKINAME. Administratoriem ir neatņemama daļa no #WIKINAME, un ir svarīgi tie ir regulāro klātbūtni. Ja uz ilgu laiku nav aktīvs administratori, šajā wiki var safasēti pieņemšanai atļaut citam lietotājam, lai kļūtu administrators.

Ja jums vajadzīga palīdzība, rūpējoties par wiki, varat ļaut citiem sabiedrības locekļiem kļūt par administratoriem tagad, dodoties uz  $2 .  Cerību uz drīzu par #WIKINAME

Vikija komanda

Jūs varat atrakstīties no izmaiņām šo sarakstu šeit: $3',
	'wikiadoption-mail-first-content-HTML' => 'Sveiki $1,<br /><br />

Tas ir bijis pāris nedēļas, kopš mēs esam redzējuši administrators #WIKINAME. Administratoriem ir neatņemama daļa no #WIKINAME, un ir svarīgi tie ir regulāro klātbūtni. Ja uz ilgu laiku nav aktīvs administratori, šajā wiki var safasēti pieņemšanai atļaut citam lietotājam, lai kļūtu administrators.<br /><br />

Ja jums vajadzīga palīdzība, rūpējoties par wiki, varat ļaut citiem sabiedrības locekļiem kļūt par administratoriem tagad, dodoties uz <a href="<span class=" notranslate"="" translate="no">$2 "> lietotāju tiesību pārvaldības</a>.  Hope redzēt jūs #WIKINAME soon!<br /><br />

Vikija komanda<br /><br />

Jūs varat <a href="<span class=" notranslate"="" translate="no">$3 "> atrakstīties</a> no šā saraksta izmaiņas.',
	'wikiadoption-mail-second-subject' => '#WIKINAME tiks safasēti pieņemšanai drīz',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME ir pieņemts',
	'tog-adoptionmails' => 'Sūtīt man e-pastu, ja $1 kļūs piiejama citu lietotāju pieņemšanai',
	'wikiadoption-pref-label' => 'Izmaiņām šajos iestatījumos būs efekts tikai uz e-pastiem no $1.',
	'wikiadoption-welcome-header' => 'Apsveicam! Jūs esat pieņēmuši {{SITENAME}}!',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wikiadoption' => 'АвтоматскоПосвојувањеНаВики',
	'wikiadoption-desc' => 'Додаток за автоматско посвојување на вики за МедијаВики',
	'wikiadoption-header' => 'Посвој го викиво',
	'wikiadoption-button-adopt' => 'Да, сакам да го посвојам викито {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Дознајте повеќе!',
	'wikiadoption-description' => '$1, дали сте спремни да го посвоите викито {{SITENAME}}?
<br /><br />
Викито {{SITENAME}} веќе подолго време нема активен администратор, па затоа бараме нов водач за да се погрижи да се зголемат содржините и заедницата на викито! Бидејќи сте учесник на {{SITENAME}} со своите придонеси, би сакале таа функција да ви ја понудиме вам.
<br /><br />
Ако го посвоите викито, ќе бидете унапредени во администратор и бирократ, и со ова ќе ги имате на располагање сите алатки што ви се потребни за да раководите со заедницата и содржините на викито. Ќе можете да назначувате други администартори за да ви помагаат, бришат, враќаат, преместуваат и заштитуваат страници, како и да создаваат кориснички групи и да им доделуваат корисници.
<br /><br />
Дали сте подготвени да ги преземете следните чекори за да му помогнете на викито {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Сакате да дознаете повеќе?',
	'wikiadoption-know-more-description' => 'За повеќе информации, погледајте ги овие врски. И секако, најслободно обратете ни се ако имате прашања!',
	'wikiadoption-adoption-successed' => 'Честитаме! Сега сте администратор на ова вики!',
	'wikiadoption-adoption-failed' => 'За жал, се обидовме да ве назначиме за администратор, но не успеавме. [http://community.wikia.com/Special:Contact Контактирајте нè], и ќе се обидеме да ви помогнеме.',
	'wikiadoption-not-allowed' => 'За жал, во моментов не можете да го посвоите ова вики.',
	'wikiadoption-not-enough-edits' => 'Упс! Мора да имате барем 10 уредувања за да можете да го присвоите викито.',
	'wikiadoption-adopted-recently' => 'Упс! Неодамна имате посвоено друго вики. Ќе треба да почекате пред да можете да посвоите уште едно.',
	'wikiadoption-log-reason' => 'Автоматско посвојување на вики',
	'wikiadoption-notification' => '{{SITENAME}} може да се посвои! Сакате да станете водач на викито? Посвојте го и започнете!  $2',
	'wikiadoption-mail-first-subject' => 'Не ве имаме видено во последно време',
	'wikiadoption-mail-first-content' => 'Здраво $1,

Има две недели како нема администратор на #WIKINAME. Администраторите се составен дел од #WIKINAME и мора да бидат редовно присутни. Ако подолго време нема активни администратори, викито може да биде понудено за посвојување, и со тоа да му овозможиме на друг корисник да стане администратор.

Ако ви треба помош со раководењето со викито, ви предлагаме да назначите администратор(и) од другите учесници. Ова можете да го направите преку страницата $2. Се надеваме дека набргу ќе ве видиме на #WIKINAME!

Екипата на Викија

Ако сакате повеќе да не добивате известувања за измените на овој поштенски список, стиснете на следнава врска: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Здраво $1,<br /><br />

Има пар недели како немаме видено администратор на #WIKINAME. Администраторите се составен дел од #WIKINAME и мора да бидат редовно присутни. Ако подолго време нема активни администратори, викито може да биде понудено за посвојување, и со тоа да му овозможиме на друг корисник да стане администратор.<br /><br />

Ако ви треба помош со раководењето со викито, ви предлагаме да назначите администратор(и) од другите учесници. Ова можете да го направите преку страницата <a href="$2">Раководење со кориснички права</a>. Се надеваме дека набргу ќе ве видиме на #WIKINAME!<br /><br />

Екипата на Викија<br /><br />

Можете да се <a href="$3">отпишете</a> за повеќе да не добивате известувања за измените на овој список.',
	'wikiadoption-mail-second-subject' => 'Наскоро ќе го понудиме викито #WIKINAME за посвојување',
	'wikiadoption-mail-second-content' => 'Здраво $1,
Поминаа речиси 60 дена како не сме виделе активен администратор на #WIKINAME. Од голема важност е да имате активни администратори на викито за да може да работи правилно.

Бидејќи измина толку време,  #WIKINAME ќе им биде понудено за посвојување на други уредници.

Екипата на Викија

Ако сакате да не добивање известувања за измените на списоков, проследете ја врската: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Здраво $1,<br /><br />
Поминаа речиси 60 дена како не сме виделе активен администратор на #WIKINAME. Од голема важност е да имате активни администратори на викито за да може да работи правилно.

Бидејќи измина толку време,  #WIKINAME ќе им биде понудено за посвојување на други уредници.<br /><br />

Екипата на Викија<br /><br />

Можете да се <a href="$3">отпишете</a> од известувањата за промените на списоков.',
	'wikiadoption-mail-adoption-subject' => 'Викито #WIKINAME е посвоено',
	'wikiadoption-mail-adoption-content' => 'Здраво $1,

Викито #WIKINAME е посвоено! Викијата се нудат за посвојување кога немаат активен администратор веќе 60 дена.

Корисникот што го посвои #WIKINAME сега ќе биде бирократ и администратор.  Не грижете се, вие си го задржувате статусот на администратор и добредојдени сте да се вратите и да придонесувате во секое време!

Екипата на Викија

Ако сакате да не добивање известувања за измените на списоков, проследете ја врскава: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Здраво $1,<br /><br />

Викито #WIKINAME е посвоено! Викијата се нудат за посвојување кога немаат активен администратор веќе 60 дена.

Корисникот што го посвои #WIKINAME сега ќе биде бирократ и администратор.  Не грижете се, вие си го задржувате статусот на администратор и добредојдени сте да се вратите и да придонесувате во секое време!<br /><br />

Екипата на Викија<br /><br />


Можете да се <a href="$3">отпишете</a> од известувања за промените на списоков.',
	'tog-adoptionmails' => 'Извести ме по е-пошта ако $1 стане достапно за посвојување',
	'tog-adoptionmails-v2' => '...ако викито се ослободи за посвојување од други корисници',
	'wikiadoption-pref-label' => 'Измените во овие нагодувања ќе важат само за -пошта од $1.',
	'wikiadoption-welcome-header' => 'Честитаме! Го посвоивте викито {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Сега сте бирократ на ова вики. Со новиот статус, сега имате пристап до сите алатки што ви се потребни за да раководите со {{SITENAME}}.
<br /><br />
Најважно за зголемувањето и развојот на {{SITENAME}} е да продолжите да уредувате.
<br /><br />
Ако едно вики нема активен администратор, истото истото ќе биде понудено за посвојување, па затоа свраќајте на вашето вики што почесто.
<br /><br />
Корисни алатки:
<br /><br />
[[Special:ThemeDesigner|Ликовен уредник]] (уредување на изгледот на викито)
<br />
[[Special:LayoutBuilder|Распоредувач на страници]]
<br />
[[Special:ListUsers|Список на корисници]]
<br />
[[Special:UserRights|Раководење со права]]',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'wikiadoption-header' => 'ഈ വിക്കിയെ ദത്തെടുക്കുക',
	'wikiadoption-button-adopt' => 'ഇപ്പോൾ തന്നെ ദത്തെടുക്കുക', # Fuzzy
	'wikiadoption-know-more-header' => 'കൂടുതൽ അറിയണമെന്നുണ്ടോ?',
	'wikiadoption-adoption-successed' => 'അഭിനന്ദനങ്ങൾ! താങ്കൾ ഇപ്പോൾ ഈ വിക്കിയിലെ ഒരു കാര്യനിർവാഹകനാണ്!',
);

/** Marathi (मराठी)
 * @author V.narsikar
 */
$messages['mr'] = array(
	'wikiadoption-know-more-header' => 'अधिक जाणायचे आहे?',
	'wikiadoption-adoption-successed' => 'अभिनंदन!आपण या विकिवर प्रशासक झाले आहात!',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wikiadoption' => 'Pengambilalihan wiki automatik',
	'wikiadoption-desc' => 'Sambungan Pengambilalihan Wiki automatik untuk MediaWiki',
	'wikiadoption-header' => 'Ambil alih wiki ini',
	'wikiadoption-button-adopt' => 'Ya, saya mahu mengambil alih {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Ketahui lebih lanjut!',
	'wikiadoption-description' => '$1, bersediakah anda untuk mengambil alih {{SITENAME}}?
<br /><br />
Sudah sekian lama tiada pentadbir yang aktif di {{SITENAME}}, dan kami sedang mencari ketua baru untuk membantu pertumbuhan kandungan dan komuniti wiki ini! Sebagai salah seorang penyumbang kepada {{SITENAME}}, kami ingin tahu sama ada anda menerima jawatan ini.
<br /><br />
Dengan mengambil alih wiki ini, anda akan dinaik pangkat menjadi pentadbir dan birokrat dan diberikan peralatan yang anda perlukan untuk menguruskan komuniti dan kandungan wiki ini. Anda akan mampu mengambil pentadbir-pentadbir lain untuk membantu mengembangkan, menghapuskan, menggulung balik, memindahkan atau melindungi laman-laman dalam wiki.
<br /><br />
Bersediakah anda membuat langkah seterusnya untuk membantu {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Nak tahu lebih lanjut?',
	'wikiadoption-know-more-description' => 'Apa kata ikut pautan-pautan ini untuk maklumat lanjut. Seperkara lagi, jangan segan menghubungi kami jika ada apa-apa soalan untuk ditanya!',
	'wikiadoption-adoption-successed' => 'Syabas! Anda menjadi pentadbir di wiki ini!',
	'wikiadoption-adoption-failed' => 'Maaf. Kami cuba jadikan anda pentadbir, tetapi tidak menjadi pula. Sila [http://community.wikia.com/Special:Contact hubungi kami], supaya kami boleh membantu anda.',
	'wikiadoption-not-allowed' => 'Maafkan kami, anda tidak boleh mengambil alih wiki ini sekarang.',
	'wikiadoption-not-enough-edits' => 'Maaf, anda perlu membuat lebih 10 suntingan untuk mengambil alih wiki ini.',
	'wikiadoption-adopted-recently' => 'Maaf, anda baru mengambil alih wiki yang lain baru-baru ini. Anda perlu menunggu seketika sebelum anda boleh mengambil alih wiki baru.',
	'wikiadoption-log-reason' => 'Penerimaan Hakmilik Wiki Automatik',
	'wikiadoption-notification' => '{{SITENAME}} perlu diambil alih! Mungkin anda pemilik baru yang dicari-cari. $2!',
	'wikiadoption-mail-first-subject' => 'Sudah sekian lama kami tak berjumpa dengan anda',
	'wikiadoption-mail-first-content' => 'Apa khabar $1,

Sudah dua minggu lebih sejak kali terakhir kami melihat ada pentadbir di #WIKINAME. Pentadbir ialah sebahagian penting dalam #WIKINAME dan adalah penting untuk mereka sentiasa ada. Jika sudah sekian lama tiada pentadbir yang aktif, wiki ini boleh ditawarkan untuk diambil alih supaya pengguna lain boleh menjadi pentadbir.

Jika anda memerlukan bantuan untuk menjaga wiki ini, anda juga boleh membenarkan ahli-ahli komuniti yang lain menjadi pentadbir dengan pergi ke $2. Semoga berjumpa lagi di #WIKINAME!

Pasukan Wikia

Anda boleh berhenti melanggan perubahan pada senarai ini di sini: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Apa khabar $1,<br /><br />

Sudah dua minggu lebih sejak kali terakhir kami melihat ada pentadbir di #WIKINAME. Pentadbir ialah sebahagian penting dalam #WIKINAME dan adalah penting untuk mereka sentiasa ada. Jika sudah sekian lama tiada pentadbir yang aktif, wiki ini boleh ditawarkan untuk diambil alih supaya pengguna lain boleh menjadi pentadbir.<br /><br />

Jika anda memerlukan bantuan untuk menjaga wiki ini, anda juga boleh membenarkan ahli-ahli komuniti yang lain menjadi pentadbir dengan pergi ke <a href="$2">pengurusan Hak Pengguna</a>. Semoga berjumpa lagi di #WIKINAME!<br /><br />

Pasukan Wikia<br /><br />

Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.',
	'wikiadoption-mail-second-subject' => '#WIKINAME akan ditawarkan untuk diambil alih nanti',
	'wikiadoption-mail-second-content' => 'Apa khabar $1,

Alamak! Sudah hampir 60 hari sejak kali terakhir ada pentadbir yang aktif di #WIKINAME. Adalah penting untuk pentadbir kerap hadir dan menyumbang supaya wiki ini terus berjalan lancar.

Memandangkan sudah berapa lama sejak hadirnya seorang pentadbir semasa, maka #WIKINAME kini akan ditawarkan untuk diambil alih oleh pentadbir lain.

Pasukan Wikia

Anda boleh berhenti melanggan perubahan pada senarai ini di sini: $3',
	'wikiadoption-mail-second-content-HTML' => 'Apa khabar $1,<br /><br />

Alamak! Sudah hampir 60 hari sejak kali terakhir ada pentadbir yang aktif di #WIKINAME. Adalah penting untuk pentadbir kerap hadir dan menyumbang supaya wiki ini terus berjalan lancar.<br /><br />

Memandangkan sudah berapa lama sejak hadirnya seorang pentadbir semasa, maka #WIKINAME kini akan ditawarkan untuk diambil alih oleh pentadbir lain. <br /><br />

Pasukan Wikia<br /><br />

Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME telah diambil alih',
	'wikiadoption-mail-adoption-content' => 'Apa khabar $1,

#WIKINAME telah diambil alih. Wiki akan disediakan untuk diambil alih apabila tiadanya pentadbir semasa yang aktif selama 60 hari atau lebih.

Pengguna yang mengambil alih #WIKINAME kini akan mendapat status birokrat dan pentadbir. Jangan bimbang kerana anda masih mengekalkan status pentadbir di wiki ini, dan anda boleh kembali ke situ pada bila-bila masa sahaja!

Pasukan Wikia

Anda boleh berhenti melanggan perubahan pada senarai ini di sini: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Apa khabar $1,<br /><br />

#WIKINAME telah diambil alih. Wiki akan disediakan untuk diambil alih apabila tiadanya pentadbir semasa yang aktif selama 60 hari atau lebih.<br /><br />

Pengguna yang mengambil alih #WIKINAME kini akan mendapat status birokrat dan pentadbir. Jangan bimbang kerana anda masih mengekalkan status pentadbir di wiki ini, dan anda boleh kembali ke situ pada bila-bila masa sahaja.<br /><br />

Pasukan Wikia<br /><br />

Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.',
	'tog-adoptionmails' => 'E-mel kepada saya jika $1 akan dibuka kepada pengguna lain untuk mengambil alih',
	'tog-adoptionmails-v2' => '...jika wiki ini akan dibuka kepada pengguna lain untuk mengambil alih',
	'wikiadoption-pref-label' => 'Penukaran keutamaan ini akan hanya mempengaruhi e-mel dari $1.',
	'wikiadoption-welcome-header' => 'Tahniah! Anda telah mengambil alih {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Anda sudah menjadi birokrat di wiki ini. Dengan status baru anda, anda kini boleh mencapai semua peralatan yang akan membantu anda menguruskan {{SITENAME}}.
<br /><br />
Perkara paling penting yang anda boleh lakukan untuk membantu {{SITENAME}} berkembang adalah meneruskan usaha menyunting.
<br /><br />
Jika sesebuah wiki ketiadaan pentadbir yang aktif, ia boleh diserahkan untuk diambil alih, jadi tolong jenguk wiki ini selalu.
<br /><br />
Alatan yang Berguna:
<br /><br />
[[Special:ThemeDesigner|Pereka Tema]]
<br />
[[Special:LayoutBuilder|Pembina Tataletak Laman]]
<br />
[[Special:ListUsers|Senarai Pengguna]]
<br />
[[Special:UserRights|Uruskan Hak]]',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'wikiadoption-adopt-inquiry' => 'Kun af aktar!',
	'wikiadoption-know-more-header' => 'Tixtieq tkun taf aktar?',
	'wikiadoption-adoption-successed' => 'Prosit! Inti issa amministratur fuq din il-wiki!',
	'wikiadoption-adoption-failed' => 'Jiddispjaċina. Aħna pruvajna nagħmluk amministratur, imma ma ħadmitx. [http://community.wikia.com/Special:Contact Ikkuntatjana] u aħna nippruvaw ngħinuk.',
	'wikiadoption-mail-first-subject' => 'Ilna daqxejn ma narawk',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'wikiadoption' => 'Automatisk wikiadopsjon',
	'wikiadoption-desc' => 'En AutomatiskWikiAdopsjons-utvidelse for MediaWiki',
	'wikiadoption-header' => 'Adopter denne wikien',
	'wikiadoption-button-adopt' => 'Ja, jeg vil adoptere {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Finn ut mer!',
	'wikiadoption-description' => '$1, klar til å adoptere {{SITENAME}}?
<br /><br />
Det har ikke vært en aktiv administrator på {{SITENAME}} på en stund, og vi ser etter en ny leder som kan hjelpe denne wikiens innhold og fellesskap med å vokse! Som en av bidragsyterne til {{SITENAME}} lurte vi på om du ville ha jobben.
<br /><br />
Ved å adoptere wikien vil du bli forfremmet til administrator og byråkrat for å gi deg verktøyene du trenger for å håndtere wikiens fellesskap og innhold. Du vil være i stand til å utnevne andre administratorer for å hjelpe til, slette, tilbakestille, flytte og beskytte sider.
<br /><br />
Er du klar til å ta det neste steget for å hjelpe {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Vil du vite mer?',
	'wikiadoption-know-more-description' => 'Sjekk disse lenkene for mer informasjon. Du er selvsagt velkommen til å kontakte oss om du har spørsmål!',
	'wikiadoption-adoption-successed' => 'Gratulerer! Du er nå administrator på denne wikien.',
	'wikiadoption-adoption-failed' => 'Beklager. Vi prøvde å gjøre deg til administrator, men det fungerte ikke. [http://community.wikia.com/Special:Contact Kontakt oss], så skal vi prøve å hjelpe deg.',
	'wikiadoption-not-allowed' => 'Beklager. Du kan ikke adoptere denne wikien akkurat nå.',
	'wikiadoption-not-enough-edits' => 'Ops! Du må ha flere enn ti redigeringer for å adoptere denne wikien.',
	'wikiadoption-adopted-recently' => 'Ops! Du har allerede adoptert en annen wiki nylig. Du må vente en stund før du kan adoptere en ny wiki.',
	'wikiadoption-log-reason' => 'Automatisk wikiadopsjon',
	'wikiadoption-notification' => '{{SITENAME}} er tilgjengelig for adopsjon. Interessert i å bli en leder her? Adopter denne wikien for å komme i gang!  $2',
	'wikiadoption-mail-first-subject' => 'Vi har ikke sett deg på en stund',
	'wikiadoption-mail-first-content' => 'Hei $1,

Det har gått noen uker siden vi har sett en administrator på #WIKINAME. Administratorer er en vital del av #WIKINAME og det er viktig at de har en fast tilstedeværelse. Hvis det ikke er noen aktive administratorer i en lengre tidsperiode, vil denne wikien settes opp for adopsjon slik at en annen bruker kan bli administrator.

Hvis du trenger hjelp til å ta vare på wikien, kan du la andre medlemmer av fellesskapet bli administratorer ved å gå til $2. Vi håper å se deg på #WIKINAME snart!

Wikia-teamet

Du kan avslutte abonnementet på endringer fra denne listen her: $3',
	'wikiadoption-mail-first-content-HTML' => 'Hei $1,<br /><br />

Det har gått noen uker siden vi har sett en administrator på #WIKINAME. Administratorer er en vital del av #WIKINAME og det er viktig at de har en fast tilstedeværelse. Hvis det ikke er noen aktive administratorer i en lengre tidsperiode, vil denne wikien settes opp for adopsjon slik at en annen bruker kan bli administrator.<br /><br />

Hvis du trenger hjelp til å ta vare på wikien, kan du la andre medlemmer av fellesskapet bli administratorer ved å gå til <a href="$2">Brukerrettighetskontroll</a>. Vi håper å se deg på #WIKINAME snart!<br /><br />

Wikia-teamet<br /><br />

Du kan <a href="$3">avslutte abonnementet</a> på endringer fra denne listen.',
	'wikiadoption-mail-second-subject' => '#WIKINAME vil bli satt opp for adopsjon snart',
	'wikiadoption-mail-second-content' => 'Hei $1,

Å, nei! Det har gått nesten 60 dager siden det var en aktiv administrator på #WIKINAME. Det er viktig at administratorer jevnlig viser seg og bidrar slik at wikien kan fortsette problemfritt.

Siden det har gått så mange dager siden en nåværende administrator viste seg, har #WIKINAME nå blitt satt opp for adopsjon til andre redaktører.

Wikia-teamet

Du kan avslutte abonnementet på endringer fra denne listen her: $3',
	'wikiadoption-mail-second-content-HTML' => 'Hei $1,<br /><br />

Å, nei! Det har gått nesten 60 dager siden det var en aktiv administrator på #WIKINAME. Det er viktig at administratorer jevnlig viser seg og bidrar slik at wikien kan fortsette problemfritt.<br /><br />

Siden det har gått så mange dager siden en nåværende administrator viste seg, har #WIKINAME nå blitt satt opp for adopsjon til andre redaktører.<br /><br />

Wikia-teamet<br /><br />

Du kan <a href="$3">avslutte abonnementet</a> på endringer fra denne listen.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME har blitt adoptert',
	'wikiadoption-mail-adoption-content' => 'Hei $1,

#WIKINAME har blitt adoptert! Wikier er tilgjenglige for adopsjon når ingen av de nåværende administratorene har vært aktive i 60 eller flere dager.

Brukeren som har adoptert #WIKINAME vil nå ha status som byråkrat og administrator. Ikke bekymre deg, du beholder også administratorstatusen din på denne wikien og er velkommen tilbake for videre bidrag når som helst!

Wikia-teamet

Du kan avslutte abonnementet på endringer fra denne listen her: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Hei $1,<br /><br />

#WIKINAME har blitt adoptert! Wikier er tilgjenglige for adopsjon når ingen av de nåværende administratorene har vært aktive i 60 eller flere dager.<br /><br />

Brukeren som har adoptert #WIKINAME vil nå ha status som byråkrat og administrator. Ikke bekymre deg, du beholder også administratorstatusen din på denne wikien og er velkommen tilbake for videre bidrag når som helst!<br /><br />

Wikia-teamet<br /><br />

Du kan <a href="$3">avslutte abonnementet</a> på endringer fra denne listen.',
	'tog-adoptionmails' => 'Send meg en e-post hvis $1 blir tilgjengelig for adopsjon av andre brukere',
	'tog-adoptionmails-v2' => '... hvis wikien blir tilgjengelig for adopsjon av andre brukere',
	'wikiadoption-pref-label' => 'Å endre disse innstillingene vil bare påvirke e-poster fra $1.',
	'wikiadoption-welcome-header' => 'Gratulerer! Du har adoptert {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Du er nå en byråkrat på denne wikien. Med din nye status har du nå tilgang til alle verktøyene som vil hjelpe deg å håndtere {{SITENAME}}.
<br /><br />
Det viktigste du kan gjøre for å hjelpe {{SITENAME}} med å vokse er å fortsette å redigere.
<br /><br />
Hvis det ikke er noen aktive administratorer på en wiki kan den settes opp for adopsjon så sørg for å besøke wikien ofte.
<br /><br />
Nyttige verktøy:
<br /><br />
[[Special:ThemeDesigner|Temautformeren]]
<br />
[[Special:LayoutBuilder|Sideoppsett-bygger]]
<br />
[[Special:ListUsers|Brukerliste]]
<br />
[[Special:UserRights|Håndter rettigheter]]',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Yatalu
 */
$messages['nl'] = array(
	'wikiadoption' => 'Automatische wikiadoptie',
	'wikiadoption-desc' => 'Een uitbreiding voor automatisch toewijzen van nieuwe beheerders voor een wiki (adoptie)',
	'wikiadoption-header' => 'Deze wiki adopteren',
	'wikiadoption-button-adopt' => 'Ja, ik wil {{SITENAME}} adopteren!',
	'wikiadoption-adopt-inquiry' => 'Meer te weten komen',
	'wikiadoption-description' => "Bent u klaar om {{SITENAME}} te adopteren, $1?
<br /><br />
Er is al een tijdje geen actieve beheerder geweest voor {{SITENAME}} en we zoeken een nieuwe leider die ervoor zorgt dat de inhoud en de gemeenschap voor deze wiki blijft groeien! U hebt bijgedragen aan {{SITENAME}}, en we vragen ons af of u dat wilt doen.
<br /><br />
Door de wiki te adopteren wordt u beheerder en bureaucraat zodat u de hulpmiddelen hebt om de inhoud en de gemeenschap van de wiki te beheren. U kunt andere gebruikers beheerder maken en helpen met het verwijderen, hernoemen en beveiligen van pagina's en bewerkingen terugdraaien.
<br /><br />
Bent u klaar om de volgende stap te zetten in uw carrière bij {{SITENAME}}?",
	'wikiadoption-know-more-header' => 'Wilt u meer weten?',
	'wikiadoption-know-more-description' => 'Volg deze koppelingen voor meer infomatie. Het staat u natuurlijk ook vrij om contact met ons op te nemen als u vragen hebt.',
	'wikiadoption-adoption-successed' => 'Gefeliciteerd! U bent nu beheerder van deze wiki.',
	'wikiadoption-adoption-failed' => 'We hebben geprobeerd u beheerder te maken, maar dit lukte helaas niet. [http://community.wikia.com/Special:Contact Neem contact met ons op] zodat we u verder kunnen helpen.',
	'wikiadoption-not-allowed' => 'U kunt deze wiki nu helaas niet adopteren.',
	'wikiadoption-not-enough-edits' => 'U moet meer dan 10 bewerkingen gemaakt hebben om deze wiki te kunnen adopteren.',
	'wikiadoption-adopted-recently' => 'U hebt recentelijk al een wiki geadapteerd. U moet even wachten voordat u nog een wiki kunt adopteren.',
	'wikiadoption-log-reason' => 'Automatische wikiadoptie',
	'wikiadoption-notification' => '{{SITENAME}} kan geadopteerd worden. Wilt u de nieuwe leider worden? Adopteer deze wiki om er nu aan te beginnen! $2',
	'wikiadoption-mail-first-subject' => 'We hebben u al een tijdje niet gezien',
	'wikiadoption-mail-first-content' => 'Hallo $1,

Het is al weer een aantal weken geleden dat we een beheerder in uw wiki #WIKINAME hebben gezien. Beheerders zijn een integraal onderdeel van #WIKINAME en het is belangrijk dat ze regelmatig aanwezig zijn. Als er langere tijd geen actieve beheerders zijn, dan wordt de wiki opgegeven voor adoptie, zodat er een andere beheerder kan komen.

Als u hulp nodig hebt bij het zorgen voor uw wiki, dan kunt u ook andere gemeenschapsleden beheerder maken door te gaan naar $2. We hopen u snel te zien op #WIKINAME!

Het Wikia-team

Klik op de volgende koppeling om u uit te schrijven van wijzigingen op deze lijst: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hallo $1,<br /><br />

Het is al weer een aantal weken geleden dat we een beheerder in uw wiki #WIKINAME hebben gezien. Beheerders zijn een integraal onderdeel van #WIKINAME en het is belangrijk dat ze regelmatig aanwezig zijn. Als er langere tijd geen actieve beheerders zijn, dan wordt de wiki opgegeven voor adoptie, zodat er een andere beheerder kan komen.<br /><br />

Als u hulp nodig hebt bij het zorgen voor uw wiki, dan kunt u ook andere gemeenschapsleden beheerder maken door te gaan naar $2. We hopen u snel te zien op #WIKINAME!<br /><br />

Het Wikia-team<br /><br />

Klik op de volgende koppeling om u <a href="$3">uit te schrijven</a> van wijzigingen op deze lijst.',
	'wikiadoption-mail-second-subject' => '#WIKINAME wordt binnenkort voor adoptie opgegeven',
	'wikiadoption-mail-second-content' => 'Hallo $1,

Het is al weer zestig dagen geleden dat we een beheerder op #WIKINAME hebben gezien. Het is belangrijk dat beheerders regelmatig aanwezig zijn en dat ze bijdragen zodat de wiki soepel kan lopen.

Omdat er zo lang geen beheerder actief is geweest, komt #WIKINAME nu beschikbaar voor adoptie door andere gebruikers.

Het Wikia-team

Klik op de volgende koppeling om u uit te schrijven van wijzigingen op deze lijst: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hallo $1,<br /><br />
Het is al weer zestig dagen geleden dat we een beheerder op #WIKINAME hebben gezien. Het is belangrijk dat beheerders regelmatig aanwezig zijn en dat ze bijdragen zodat de wiki soepel kan lopen.<br /><br />

Omdat er zo lang geen beheerder actief is geweest, komt #WIKINAME nu beschikbaar voor adoptie door andere gebruikers.<br /><br />

Het Wikia-team<br /><br />

Klik op de volgende koppeling om u <a href="$3">unsubscribe</a>uit te schrijven</a> van wijzigingen op deze lijst.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME is geadopteerd',
	'wikiadoption-mail-adoption-content' => 'Hallo $1,

#WIKINAME is geadopteerd! Wikis zijn beschikbaar voor adoptie waar geen huidige beheerder minstens zestig dagen actief is.

De adopterende gebruiker van #WIKINAME zal nu bureaucraat- en beheerderrechten hebben. Vrees niet, u bent nog steeds beheerder en u bent nog steeds op ieder moment van harte welkom om terug te keren en opnieuw bij te dragen!

Het Wikia-team

U kunt zich van wijzigingen op deze lijst uitschrijven: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hallo $1,<br /><br />

#WIKINAME is geadopteerd! Wikis zijn beschikbaar voor adoptie waar geen huidige beheerder minstens zestig dagen actief is.<br /><br />

De adopterende gebruiker van #WIKINAME zal nu bureaucraat- en beheerderrechten hebben. Vrees niet, u bent nog steeds beheerder en u bent nog steeds op ieder moment van harte welkom om terug te keren en opnieuw bij te dragen!<br /><br />

Het Wikia-team<br /><br />

U kunt zich van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.',
	'tog-adoptionmails' => 'Mij e-mailen als $1 door andere gebruikers geadopteerd kan worden',
	'tog-adoptionmails-v2' => '... als de wiki beschikbaar komt om door andere gebruikers te worden geadopteerd',
	'wikiadoption-pref-label' => 'Het wijzigen van deze voorkeuren heeft alleen invloed op e-mails van $1.',
	'wikiadoption-welcome-header' => 'Gefeliciteerd! U hebt {{SITENAME}} geadopteerd!',
	'wikiadoption-welcome-body' => 'U bent nu bureaucraat op deze wiki. Met uw nieuwe status hebt u nu de beschikking over alle hulpmiddelen die u nodig hebt om {{SITENAME}} te beheren.<br /><br />
Het belangrijkste wat u kunt doen om {{SITENAME}} te helpen is blijven bewerken.<br /><br />
Als er geen actieve beheerder is in een wiki, dan kan deze beschikbaar gesteld worden voor adoptie. Zorg er dus voor dat u de wiki regelmatig bezoekt.<br /><br />
Handige hulpmiddelen:<br /><br />
[[Special:ThemeDesigner|Vormgeving ontwerpen]]<br />
[[Special:LayoutBuilder|Paginavormgevingen maken]]<br />
[[Special:ListUsers|Gebruikerslijst]]<br />
[[Special:UserRights|Rechten beheren]]',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author MarkvA
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'wikiadoption-description' => "Ben je klaar om {{SITENAME}} te adopteren, $1?
<br /><br />
Er is al een tijdje geen actieve beheerder geweest voor {{SITENAME}} en we zoeken een nieuwe leider die ervoor zorgt dat de inhoud en de gemeenschap voor deze wiki blijft groeien! Jij hebt bijgedragen aan {{SITENAME}}, en we vragen ons af of je dat wilt doen.
<br /><br />
Door de wiki te adopteren wordt je beheerder en bureaucraat zodat je de hulpmiddelen hebt om de inhoud en de gemeenschap van de wiki te beheren. Je kunt andere gebruikers beheerder maken en helpen met het verwijderen, hernoemen en beveiligen van pagina's en bewerkingen terugdraaien.
<br /><br />
Ben je klaar om de volgende stap te zetten in je carrière bij {{SITENAME}}?",
	'wikiadoption-know-more-description' => 'Volg deze koppelingen voor meer infomatie. Het staat je natuurlijk ook vrij om contact met ons op te nemen als je vragen hebt.',
	'wikiadoption-adoption-successed' => 'Gefeliciteerd! Je bent nu beheerder van deze wiki.',
	'wikiadoption-adoption-failed' => 'We hebben geprobeerd je beheerder te maken, maar dit lukte helaas niet. [http://community.wikia.com/Special:Contact Neem contact met ons op] zodat we je verder kunnen helpen.',
	'wikiadoption-not-allowed' => 'Je kunt deze wiki nu helaas niet adopteren.',
	'wikiadoption-not-enough-edits' => 'Je moet meer dan 10 bewerkingen gemaakt hebben om deze wiki te kunnen adopteren.',
	'wikiadoption-adopted-recently' => 'Je hebt recentelijk al een wiki geadapteerd. Je moet even wachten voordat je nog een wiki kunt adopteren.',
	'wikiadoption-notification' => '{{SITENAME}} kan geadopteerd worden. Wil jij de nieuwe leider worden? Adopteer deze wiki om er nu aan te beginnen! $2',
	'wikiadoption-mail-first-subject' => 'We hebben je al een tijdje niet gezien',
	'wikiadoption-mail-first-content' => 'Hallo $1,

Het is al weer een aantal weken geleden dat we een beheerder in je wiki #WIKINAME hebben gezien. Beheerders zijn een integraal onderdeel van #WIKINAME en het is belangrijk dat ze regelmatig aanwezig zijn. Als er langere tijd geen actieve beheerders zijn, dan wordt de wiki opgegeven voor adoptie, zodat er een andere beheerder kan komen.

Als je hulp nodig hebt bij het zorgen voor je wiki, dan kan je ook andere gemeenschapsleden beheerder maken door te gaan naar $2. We hopen je snel te zien op #WIKINAME!

Het Wikia-team

Klik op de volgende koppeling om je uit te schrijven van wijzigingen op deze lijst: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hallo $1,<br /><br />

Het is al weer een aantal weken geleden dat we een beheerder in je wiki #WIKINAME hebben gezien. Beheerders zijn een integraal onderdeel van #WIKINAME en het is belangrijk dat ze regelmatig aanwezig zijn. Als er langere tijd geen actieve beheerders zijn, dan wordt de wiki opgegeven voor adoptie, zodat er een andere beheerder kan komen.<br /><br />

Als je hulp nodig hebt bij het zorgen voor je wiki, dan kan je ook andere gemeenschapsleden beheerder maken door te gaan naar $2. We hopen je snel te zien op #WIKINAME!<br /><br />

Het Wikia-team<br /><br />

Klik op de volgende koppeling om je <a href="$3">uit te schrijven</a> van wijzigingen op deze lijst.',
	'wikiadoption-mail-second-subject' => '#WIKINAME wordt binnenkort voor adoptie opgegeven',
	'wikiadoption-mail-second-content' => 'Hoi $1,

Het is al weer zestig dagen geleden dat we een beheerder op #WIKINAME hebben gezien. Het is belangrijk dat beheerders regelmatig aanwezig zijn en dat ze bijdragen zodat de wiki soepel kan lopen.

Omdat er zo lang geen beheerder actief is geweest, komt #WIKINAME nu beschikbaar voor adoptie door andere gebruikers.

Het Wikia-team

Klik op de volgende koppeling om je uit te schrijven van wijzigingen op deze lijst: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hoi $1,<br /><br />
Het is al weer zestig dagen geleden dat we een beheerder op #WIKINAME hebben gezien. Het is belangrijk dat beheerders regelmatig aanwezig zijn en dat ze bijdragen zodat de wiki soepel kan lopen.<br /><br />

Omdat er zo lang geen beheerder actief is geweest, komt #WIKINAME nu beschikbaar voor adoptie door andere gebruikers.<br /><br />

Het Wikia-team<br /><br />

Klik op de volgende koppeling om je <a href="$3">unsubscribe</a>uit te schrijven</a> van wijzigingen op deze lijst.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME is geadopteerd',
	'wikiadoption-mail-adoption-content' => 'Hoi $1,

#WIKINAME is geadopteerd! Wikis zijn beschikbaar voor adoptie waar geen huidige beheerder minstens zestig dagen actief is.

De adopterende gebruiker van #WIKINAME zal nu bureaucraat- en beheerderrechten hebben. Vrees niet, je bent nog steeds beheerder en je bent nog steeds op ieder moment van harte welkom om terug te keren en opnieuw bij te dragen!

Het Wikia-team

Je kunt je van wijzigingen op deze lijst uitschrijven: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hoi $1,<br /><br />

#WIKINAME is geadopteerd! Wikis zijn beschikbaar voor adoptie waar geen huidige beheerder minstens zestig dagen actief is.<br /><br />

De adopterende gebruiker van #WIKINAME zal nu bureaucraat- en beheerderrechten hebben. Vrees niet, je bent nog steeds beheerder en je bent nog steeds op ieder moment van harte welkom om terug te keren en opnieuw bij te dragen!<br /><br />

Het Wikia-team<br /><br />

Je kunt je van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.',
	'wikiadoption-welcome-header' => 'Gefeliciteerd! Je hebt {{SITENAME}} geadopteerd!',
	'wikiadoption-welcome-body' => 'Je bent nu bureaucraat op deze wiki. Met je nieuwe status heb je nu de beschikking over alle hulpmiddelen die je nodig hebt om {{SITENAME}} te beheren.<br /><br />
Het belangrijkste wat je kunt doen om {{SITENAME}} te helpen is blijven bewerken.<br /><br />
Als er geen actieve beheerder is in een wiki, dan kan deze beschikbaar gesteld worden voor adoptie. Zorg er dus voor dat je de wiki regelmatig bezoekt.<br /><br />
Handige hulpmiddelen:<br /><br />
[[Special:ThemeDesigner|Vormgeving ontwerpen]]<br />
[[Special:LayoutBuilder|Paginavormgevingen maken]]<br />
[[Special:ListUsers|Gebruikerslijst]]<br />
[[Special:UserRights|Rechten beheren]]',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'wikiadoption' => 'Adopcion de wiki automatic',
	'wikiadoption-desc' => 'Una extension AutomaticWikiAdoption per MediaWiki',
	'wikiadoption-header' => 'Adoptar aqueste wiki',
	'wikiadoption-button-adopt' => 'Òc, vòli adoptar {{SITENAME}} !',
	'wikiadoption-adopt-inquiry' => 'Per ne saber mai !',
	'wikiadoption-description' => "$1, prèst a adoptar {{SITENAME}} ?
<br /><br />
I a pas agut cap d’administrator actiu sus {{SITENAME}} dempuèi un moment e recercam un novèl responsable per ajudar a desvolopar lo contengut d'aqueste wiki e n'agrandir la comunautat ! En tant que persona qu'a ja contribuit a {{SITENAME}}, nos demandam se vos agradariá aqueste trabalh.
<br /><br />
En adoptant lo wiki, seretz promolgut administrator e burocrata per tal de vos balhar las aisinas que n'auretz besonh per gerir la comunautat e lo contengut del wiki. Poiretz crear d’autres administrators e burocratas que pòdon ajudar, suprimir, restablir, desplaçar e protegir las paginas.
<br /><br />
Sètz prèst a passar a las autras etapas per ajudar {{SITENAME}} ?",
	'wikiadoption-know-more-header' => 'Ne volètz saber mai ?',
	'wikiadoption-know-more-description' => "Consultatz aqueles ligams per mai d’informacions. E, solide, trantalhetz pas a nos contactar s'avètz de questions !",
	'wikiadoption-log-reason' => 'Adopcion de wiki automatica',
	'wikiadoption-mail-first-subject' => 'Vos avèm pas vist dempuèi un brave moment',
	'wikiadoption-mail-second-subject' => '#WIKINAME serà lèu plaçat a l’adopcion',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME es estat adoptat',
	'wikiadoption-welcome-header' => 'Felicitacions ! Avètz adoptat {{SITENAME}} !',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Devwebtel
 * @author Sovq
 * @author Sp5uhe
 * @author VerMa
 */
$messages['pl'] = array(
	'wikiadoption' => 'Automatyczna adopcja wiki',
	'wikiadoption-desc' => 'Rozszerzenie AutomaticWikiAdoption dla MediaWiki',
	'wikiadoption-header' => 'Adoptuj tę wiki',
	'wikiadoption-button-adopt' => 'Tak, chcę adoptować {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Dowiedz się więcej!',
	'wikiadoption-description' => '$1, gotów na adopcję {{SITENAME}}?
<br /><br />
Od jakiegoś czasu na {{SITENAME}} nie ma aktywnych administratorów i szukamy nowych pasjonatów aby ożywić tą wiki! Jako, że {{SITENAME}} skorzystała także z Twoich edycji, może chciałbyś przejąc tę rolę.
<br /><br />
Adoptując wiki, otrzymasz uprawnienia administratora i biurokraty, które potrzebne będą do zarządzania zawartością i rozwiązywania problemów społeczności wiki. Będziesz mieć także możliwość nadawania uprawnień innym, aby także mogli brać udział w administrowaniu wiki.
<br /><br />
Czy jesteś gotów aby pomóc {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Chcesz wiedzieć więcej?',
	'wikiadoption-know-more-description' => 'Sprawdź te łącza, aby uzyskać więcej informacji. I oczywiście, prosimy o kontakt, jeśli masz jakieś pytania!',
	'wikiadoption-adoption-successed' => 'Gratulacje! Jesteś teraz administratorem na tej wiki!',
	'wikiadoption-adoption-failed' => 'Przepraszamy. Próbowaliśmy dać Ci uprawnienia administratora, ale coś poszło nie tak. Prosimy [http://community.wikia.com/Special:Contact skontaktuj się z nami], a spróbujemy Ci pomóc.',
	'wikiadoption-not-allowed' => 'Przepraszamy. Nie możesz teraz adoptować tej wiki.',
	'wikiadoption-not-enough-edits' => 'Potrzebujesz więcej niż 10 edycji aby adoptować tę wiki.',
	'wikiadoption-adopted-recently' => 'Ostatnio adoptowałeś inną wiki. Musisz poczekac, zanim adoptujesz kolejną wiki.',
	'wikiadoption-log-reason' => 'Automatyczna Adopcja Wiki',
	'wikiadoption-notification' => '{{SITENAME}} może być adoptowana. Chcesz zostać administratorem? Adoptuj wiki! $2',
	'wikiadoption-mail-first-subject' => 'Nie widzieliśmy cię jakiś czas',
	'wikiadoption-mail-first-content' => 'Witaj $1,

Od kilku tygodni na #WIKINAME nie było aktywnych administratorów.Administratorzy są niezbędni aby #WIKINAME mogła poprawnie funkcjonować. Jeśli w dłuższym okresie na wiki nie ma administratorów, może ona zostać udostępniona do adopcji, tak, aby inni aktywni użytkownicy mogli dostać dodatkowe uprawnienia.

Jeśli potrzebujesz pomocy w dbaniu o wiki, możesz pozwolić innym użytkownikom zostać administratorami odwiedzając $2. Do zobaczenia wkrótce na #WIKINAME!

Zespół Wikia

Możesz zrezygnować z otrzymywania powiadomień tutaj: $3',
	'wikiadoption-mail-first-content-HTML' => 'Witaj $1,<br /><br />

Od kilku tygodni na #WIKINAME nie było aktywnych administratorów. Administratorzy są niezbędni aby #WIKINAME mogła poprawnie funkcjonować. Jeśli w dłuższym okresie na wiki nie ma administratorów, może ona zostać udostępniona do adopcji, tak, aby inni aktywni użytkownicy mogli dostać dodatkowe uprawnienia.<br /><br />

Jeśli potrzebujesz pomocy w dbaniu o wiki, możesz pozwolić innym użytkownikom zostać administratorami odwiedzając <a href="$2">narzędzie do zarządzania uprawnieniami</a>. Do zobaczenia wkrótce na #WIKINAME!<br /><br />

Zespół Wikia<br /><br />

Możesz <a href="$3">zrezygnować</a> z otrzymywania powiadomień.',
	'wikiadoption-mail-second-subject' => '#WIKINAME będzie wkrótce dostępna do adopcji',
	'wikiadoption-mail-second-content' => 'Witaj $1,

Minęło 60 dni od momentu, gdy aktywny był administrator na wiki $WIKINAME. Regularna obecność administratorów jest ważna dla poprawnego rozwoju wiki.

Ponieważ minęło tak wiele dni od pojawienia się aktualnego administratora, $WIKINAME zostanie zaproponowana do adopcji innym edytorom.

Zespół Wikia

Możesz zrezygnować z otrzymywania zmian na tej liście klikając link $3.',
	'wikiadoption-mail-second-content-HTML' => 'Witaj $1,<br /><br />

Minęło prawie 60 dni od kiedy na #WIKINAME ostatnio aktywny był administrator. Ważnym jest, aby administratorzy regularnie patrolowali wiki aby ta mogła działać bezproblemowo.<br /><br />

Jako, że minęło tak wiele czasu od ostatniej aktywności administratora, #WIKINAME będzie wkrótce dostępna do adopcji dla innych użytkowników.<br /><br />

Zespół Wikia<br /><br />

Możesz <a href="$3">zrezygnować</a> z otrzymywania powiadomień.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME została adoptowana',
	'wikiadoption-mail-adoption-content' => 'Witaj $1,

#WIKINAME została adoptowana. Wiki mogą być adoptowane, jeżeli administratorzy nie są aktywni przez 60 lub więcej dni.

Użytkownik, który adoptował #WIKINAME, otrzymał uprawnienia administratora i biurokraty. Nie martw się, Twoje uprawnienia pozostały bez zmian i w każdym momencie możesz wrócić i ponowić edytowanie!

Zespół Wikia

Możesz zrezygnować z otrzymywania powiadomień tutaj: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Witaj $1,<br /><br />

#WIKINAME została adoptowana. Wiki mogą być adoptowane, jeżeli administratorzy nie są aktywni przez 60 lub więcej dni.<br /><br />

Użytkownik, który adoptował #WIKINAME, otrzymał uprawnienia administratora i biurokraty. Nie martw się, Twoje uprawnienia pozostały bez zmian i w każdym momencie możesz wrócić i ponowić edytowanie!<br /><br />

Zespół Wikia<br /><br />

Możesz <a href="$3">zrezygnować</a> z otrzymywania powiadomień.',
	'tog-adoptionmails' => 'Powiadom mnie emailem gdy $1 stanie się dostępna do adopcji',
	'tog-adoptionmails-v2' => '...wiki stanie się dostępna do adopcji',
	'wikiadoption-pref-label' => 'Te ustawienia dotyczą jedynie powiadomień z $1.',
	'wikiadoption-welcome-header' => 'Gratulacje! Adoptowałeś {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Jesteś teraz biurokratą na tej wiki. Z nowymi uprawnieniami masz dostęp do dodatkowych narzędzi, dzięki którym {{SITENAME}} może rosnąć.
<br /><br />
Najważniejszą rzeczą, którą możesz zrobić dla {{SITENAME}}, to edytowanie.
<br /><br />
Gdy na wiki nie ma aktywnych administratorów, staje ona się dostępna do adopcji. Upewnij się zatem, że regularnie odwiedzasz wiki.
<br /><br />
Pomocne narzędzia:
<br /><br />
[[Special:ThemeDesigner|Kreator motywu]]
<br />
[[Special:LayoutBuilder|Page Layout Builder]]
<br />
[[Special:ListUsers|Użytkownicy]]
<br />
[[Special:UserRights|Uprawnienia użytkowników]]',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'wikiadoption' => 'Adossion automàtica ëd wiki',
	'wikiadoption-desc' => "N'estension AutomaticWikiAdoption për MediaWiki",
	'wikiadoption-header' => 'Adòta sta wiki',
	'wikiadoption-button-adopt' => 'É!, i veui adoté {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Për savèjne ëd pi!',
	'wikiadoption-description' => "$1, pront a adoté {{SITENAME}}?
<br /><br />
A l'é pa staje d'aministrator ativ dzora {{SITENAME}} da 'n bel pòch, e i sërcoma un neuv responsàbil për giuté ël contnù dë sta wiki e la chërsùa dla comunità! Com quaidun che a l'ha contribuì a {{SITENAME}} is ciamoma s'a-j pias ës travaj.
<br /><br />
An adotand sta wiki, a sarà promovù a aministrator e mangiapapé për deje j'utiss dont a l'ha dabzògn për gestì la comunità e ël contnù dla wiki. A podrà ëdcò creé d'àutri aministrator për giuté, scancelé, ripristiné, tramudé e protege le pàgine.
<br /><br />
É-lo pront a fé ës neuv pass për giuté {{SITENAME}}?",
	'wikiadoption-know-more-header' => 'Veul-lo savèjne ëd pi?',
	'wikiadoption-know-more-description' => "Ch'a consulta coste liure për savèjne ëd pi. E, as capiss, ch'an contata pura s'a l'èissa dle chestion!",
	'wikiadoption-adoption-successed' => "Congratulassion! Adess a l'é aministrator dzora sta wiki!",
	'wikiadoption-adoption-failed' => "An dëspias. I l'oma provà a felo aministrator, ma a l'ha nen marcià. Për piasì [http://community.wikia.com/Special:Contact ch'an contata], e i proveroma a giutelo.",
	'wikiadoption-not-allowed' => 'An dëspias. A peul pa adoté sta wiki pròpi adess.',
	'wikiadoption-not-enough-edits' => 'Contacc! A dev avèj pi che 10 modìfiche për adoté sta wiki.',
	'wikiadoption-adopted-recently' => "Contacc! It l'has già adotà n'àutra wiki recentement. It deuve speté un pòch prima ëd podèj adoté na neuva wiki.",
	'wikiadoption-log-reason' => 'Adossion Automàtica ëd Wiki',
	'wikiadoption-notification' => "{{SITENAME}} a speta n'adossion. Anteressà a dventé na guida ambelessì? Ch'a adòta sta wiki për ancaminé! $2",
	'wikiadoption-mail-first-subject' => "I l'oma pa vist-te belessì da un pòch",
	'wikiadoption-mail-first-content' => "Cerea $1,

A l'é passaje dontré sman-e da quand i l'oma s-ciairà n'aministrator dzora #WIKINAME. J'aministrator a son na part essensial ëd #WIKINAME e a l'é amportant ch'a l'abio na presensa regolar. S'a-i è gnun aministrator ativ për un longh antërval ëd temp, sta wiki a peul esse butà an adossion për përmëtte a n'àutr utent dë vnì aministrator.

S'a l'ha dabzògn d'agiut për cudì la wiki, a peul ëdcò përmëtte a d'àutri mémber dla comunità dë vnì aministrator adess andasend a $2. I speroma ëd vëdd-lo dzor #WIKINAME tòst!

L'Echip ëd Wikia

It peule disativé l'abonament a le modìfiche a costa lista belessì: $3",
	'wikiadoption-mail-first-content-HTML' => "Cerea \$1,<br /><br />

A l'é dontré sman-e ch'i vëdoma pi gnun aministrator dzor #WIKINAME. J'aministrator a son na part essensial ëd #WIKINAME e a l'é amportant ch'a l'abio na presensa regolar. S'a-i è gnun aministrator ativ për un longh antërval ëd temp, sta wiki a peul esse butà an adossion për përmëtte a n'àutr utent dë vnì aministrator.<br /><br />

S'a l'ha dabzògn d'agiut për cudì la wiki, a peul ëdcò përmëtte a d'àutri mémber dla comunità dë vnì aministrator adess andasend a la <a href=\"\$2\">gestion dij Drit dj'Utent</a>. I speroma ëd vëdd-lo dzor #WIKINAME tòst!<br /><br />

L'Echip ëd Wikia<br /><br />

A peul <a href=\"\$3\">anulé l'abonament</a> da le modìfiche a costa lista.",
	'wikiadoption-mail-second-subject' => '#WIKINAME a sarà butà an adossion prest',
	'wikiadoption-mail-second-content' => "Cerea $1,

Oh, nò! A l'é scasi 60 di da quand a-i é staje n'aministrator ativ dzor #WIKINAME. A l'é amportant che j'aministrator a ven-o e a contribuisso ëd fasson regolar an manera che la wiki a peula continué a marcé 'me ch'as dev.

Da già ch'a son passaje tanti di parèj da quand n'aministrator corent a l'é vnù, #WIKINAME a sarà adess ësmonùa an adossion a d'àutri editor.

L'Echip ëd Wikia

A peule anulé l'abonament da le modìfiche a costa lista belessì: $3",
	'wikiadoption-mail-second-content-HTML' => "Cerea \$1,<br /><br />
Oh, nò! A son passaje scasi 60 di da quand a-i é staje n'aministrator ativ dzor #WIKINAME. A l'é amportant che j'aministrator a ven-o e a contribuisso regolarment ëd fasson che la wiki a peula continué a marcé 'me ch'as dev.<br /><br />

Da già ch'a son passaje tanti di parèj da quand n'aministrator ativ a l'é fasse vëdde, #WIKINAME a sarà adess ësmonùa an adossion a d'àutri editor.<br /><br />

L'Echip ëd Wikia<br /><br />

A peul <a href=\"\$3\">anulé l'abonament</a> da le modìfiche a sta lista.",
	'wikiadoption-mail-adoption-subject' => "#WIKINAME a l'é stàita adotà",
	'wikiadoption-mail-adoption-content' => "Cerea $1,

#WIKINAME a l'é stàita adotà. Le Wiki a son disponìbij a esse adotà quand gnun dj'aministrador atuaj a son ativ da 60 di o pi.

L'utent ch'a adota #WIKINAME a l'avrà adess lë statù ëd mangiapapé e d'aministrator. Ch'as sagrin-a pa, ëdcò chiel a l'avrà ancor lë statù d'aministrator dzora sta wiki e a l'é bin ëvnù a torné e continué a contribuì a tut moment!

L'Echip ëd Wikia

A peul anulé l'abonament da le modìfiche a costa lista belessì: $3",
	'wikiadoption-mail-adoption-content-HTML' => "Cerea \$1,<br /><br />

#WIKINAME a l'é stàita adotà. Le Wiki a son disponìbij a esse adotà quand gnun dj'aministrator corent a son ativ da 60 di o pi.<br /><br />

L'utent ch'a adota #WIKINAME a l'avrà adess lë statù ëd mangiapapé e d'aministrator. Ch'as sagrin-a nen, ëdcò chiel a goernërà lë statù d'aministrator dzora sta wiki e a l'é bin ëvnù a torné e continué a contribuì a tut moment!<br /><br />

L'Echip ëd Wikia<br /><br />

A peul <a href=\"\$3\">anulé l'abonament</a> a le modìfiche a costa lista.",
	'tog-adoptionmails' => "Scrivme se $1 a dventerà disponìbil për l'adossion da àutri utent",
	'tog-adoptionmails-v2' => "...se la wiki a dventerà disponìbil për l'adossion da àutri utent",
	'wikiadoption-pref-label' => 'La modìfica ëd costi gust a tocherà mach ij mëssagi da $1.',
	'wikiadoption-welcome-header' => "Congratulassion! It l'has adotà {{SITENAME}}!",
	'wikiadoption-welcome-body' => "Adess chiel a l'é mangiapapé dzora sta wiki. Con sò neuv statù adess chiel a l'ha acess a tùit j'utiss ch'a lo giuteran a gestì {{SITENAME}}.
<br /><br />
La ròba pi amportanta ch'a peul fé për giuté {{SITENAME}} a chërse a l'é continué a modifiché.
<br /><br />
S'a-i é gnun aministrator dzora na wiki, costa a peul esse butà an adossion parèj da esse sigur ëd controlé la wiki soens.
<br /><br />
Utiss ch'a ven-o motobin a taj:
<br /><br />
[[Special:ThemeDesigner|Progetista ëd tema]]
<br />
[[Special:LayoutBuilder|Costrutor d'ampaginassion]]
<br />
[[Special:ListUsers|List dj'Utent]]
<br />
[[Special:UserRights|Gestì ij Drit]]",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wikiadoption-header' => 'دا ويکي خپلول',
	'wikiadoption-button-adopt' => 'هو، زه غواړم چې {{SITENAME}} خپل کړم!',
	'wikiadoption-adopt-inquiry' => 'ډېر نور څه موندل!',
	'wikiadoption-know-more-header' => 'غواړې نور هم پوه شې؟',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Pttraduc
 * @author Rhaijin
 * @author Vitorvicentevalente
 */
$messages['pt'] = array(
	'wikiadoption' => 'Adoção automática de wikis',
	'wikiadoption-desc' => 'Uma extensão do MediaWiki para Adoção Automática de Wikis',
	'wikiadoption-header' => 'Adotar esta wiki',
	'wikiadoption-button-adopt' => 'Sim, quero adotar a {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Saiba mais!',
	'wikiadoption-description' => '$1, está preparado(a) para adotar a {{SITENAME}}?
<br /><br />
Há já algum tempo que a {{SITENAME}} não tem uma administração ativa. Estamos à procura de uma nova liderança, para ajudar a aumentar o conteúdo da wiki e fazer crescer a comunidade de utilizadores! Como tem colaborado na {{SITENAME}}, queremos saber se gostaria de desempenhar o cargo.
<br /><br />
Ao adotar a wiki será promovido a administrador e burocrata para que tenha acesso às ferramentas necessárias para gerir a comunidade e o conteúdo da wiki. Poderá eleger outros administradores para ajudar, eliminar, desfazer edições, mover e proteger páginas.
<br /><br />
Está preparado(a) para dar os próximos passos e ajudar a {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Quer saber mais?',
	'wikiadoption-know-more-description' => 'Para mais informações visite estas ligações. E claro, contacte-nos se tiver alguma pergunta!',
	'wikiadoption-adoption-successed' => 'Parabéns! Agora é administrador desta wiki!',
	'wikiadoption-adoption-failed' => 'Infelizmente, tentámos torná-lo administrador desta wiki mas não funcionou. [http://community.wikia.com/Special:Contact Contacte-nos] e tentaremos ajudá-lo.',
	'wikiadoption-not-allowed' => 'Desculpe. Não pode adotar esta wiki agora.',
	'wikiadoption-not-enough-edits' => 'Precisa de ter feito mais de 10 edições para adotar esta wiki.',
	'wikiadoption-adopted-recently' => 'Já adotou outra wiki recentemente. Tem de esperar algum tempo até poder adotar mais uma wiki.',
	'wikiadoption-log-reason' => 'Adoção Automática de Wikis',
	'wikiadoption-notification' => 'A wiki {{SITENAME}} está pronta para adoção. Tem interesse em tornar-se o(a) novo(a) líder? Adote a wiki para poder começar! $2',
	'wikiadoption-mail-first-subject' => 'Há já algum tempo que não nos visitava',
	'wikiadoption-mail-first-content' => 'Olá $1,

Há já duas semanas que nenhum administrador visita a #WIKINAME. Os administradores são uma parte integrante da #WIKINAME e é importante que tenham uma presença regular. Se não tiver administradores ativos durante um período extenso, esta wiki ficará disponível para adoção, para permitir que outro utilizador se torne administrador.

Se precisa de ajuda para cuidar da wiki, pode permitir que outros membros da comunidade também sejam administradores, visitando agora a página $2. Esperamos que regresse à #WIKINAME dentro de pouco tempo.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'wikiadoption-mail-first-content-HTML' => 'Olá $1,<br /><br />

Há já duas semanas que nenhum administrador está presente na wiki #WIKINAME. Os administradores são uma parte integrante da #WIKINAME e é importante que tenham uma presença regular. Se não tiver administradores ativos durante um período extenso, esta wiki ficará disponível para adoção, para permitir que outro utilizador se torne administrador.<br /><br />

Se precisa de ajuda para cuidar da wiki pode permitir que outros membros da comunidade também sejam administradores, visitando agora a página de <a href="$2">gestão das Permissões dos Utilizadores</a>. Esperamos que regresse à #WIKINAME dentro de pouco tempo.<br /><br />

A Equipa da Wikia<br /><br />

Pode <a href="$3">deixar de receber atualizações</a>.',
	'wikiadoption-mail-second-subject' => 'Em breve a #WIKINAME será disponibilizada para adoção',
	'wikiadoption-mail-second-content' => 'Olá $1,

Infelizmente, há quase 60 dias que nenhum administrador está presente na wiki #WIKINAME. É importante que os administradores tenham uma presença regular na wiki e colaborem para que ela continue a funcionar bem.

Como já passaram tantos dias desde que um dos administradores esteve presente, a #WIKINAME vai ser disponibilizada para adoção por outros utilizadores.

A Equipa da Wikia

Para deixar de receber atualizações, clique o seguinte link: $3',
	'wikiadoption-mail-second-content-HTML' => 'Olá $1,<br /><br />
Infelizmente, há quase 60 dias que nenhum administrador está presente na wiki #WIKINAME. É importante que os administradores tenham uma presença regular na wiki e colaborem para que ela continue a funcionar bem.<br /><br />

Como já passaram tantos dias desde que um dos administradores esteve presente, a #WIKINAME vai ser disponibilizada para adoção por outros utilizadores.<br /><br />

A Equipa da Wikia<br /><br />

Pode <a href="$3">deixar de receber atualizações</a>.',
	'wikiadoption-mail-adoption-subject' => 'A wiki #WIKINAME foi adotada',
	'wikiadoption-mail-adoption-content' => 'Olá $1,

A wiki #WIKINAME foi adotada. As wikis ficam disponíveis para adoção quando nenhum dos administradores está ativo há 60 ou mais dias.

O utilizador que adotou a #WIKINAME terá agora o estatuto de burocrata e administrador. Não se preocupe; mantém o seu estatuto de administrador da wiki e esperamos que regresse e continue a colaborar!

A Equipa da Wikia

Para deixar de receber atualizações, clique o seguinte link: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Olá $1,<br /><br />

A wiki #WIKINAME foi adotada. As wikis ficam disponíveis para adoção quando nenhum dos administradores está ativo há 60 ou mais dias.<br /><br />

O utilizador que adotou a #WIKINAME terá agora o estatuto de burocrata e administrador. Não se preocupe; mantém o seu estatuto de administrador da wiki e esperamos que regresse e continue a colaborar!<br /><br />

A Equipa da Wikia<br />

Pode <a href="$3">deixar de receber atualizações</a>.',
	'tog-adoptionmails' => 'Notificar-me por correio eletrónico se a wiki $1 ficar disponível para adoção por outros utilizadores',
	'tog-adoptionmails-v2' => '...se a wiki ficar disponível para adoção por outros utilizadores',
	'wikiadoption-pref-label' => 'Alterar estas preferências só afeta as mensagens por correio eletrónico vindas da $1.',
	'wikiadoption-welcome-header' => 'Parabéns! Adotou a {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'É agora burocrata nesta wiki. Com este novo estatuto tem acesso a todas as ferramentas de gestão da {{SITENAME}}.
<br /><br />
O mais importante que pode fazer para ajudar a {{SITENAME}} a crescer é continuar a editá-la.
<br /><br />
Se não houver uma administração ativa da wiki ela será disponibilizada para adoção, por isso verifique a wiki com frequência.
<br /><br />
Ferramentas Úteis:
<br /><br />
[[Special:ThemeDesigner|Compositor de Variantes do Tema]]
<br />
[[Special:LayoutBuilder|Criador de Designs de Páginas]]
<br />
[[Special:ListUsers|Lista de Utilizadores]]
<br />
[[Special:UserRights|Gerir Privilégios]]',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Caio1478
 * @author Jefersonmoraes
 * @author 555
 */
$messages['pt-br'] = array(
	'wikiadoption' => 'Adoção automática de wikis',
	'wikiadoption-desc' => 'Uma extensão do MediaWiki para Adoção Automática de Wikis',
	'wikiadoption-header' => 'Adotar esta wikia',
	'wikiadoption-button-adopt' => 'Sim, eu quero adotar {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Saiba mais!',
	'wikiadoption-description' => '$1, pronto(a) para adotar a {{SITENAME}}?
<br /><br />
Há já algum tempo que a wikia {{SITENAME}} não possui um administrador ativo. Estamos à procura de uma nova liderança, para ajudar a aumentar os conteúdos e comunidade desta wikia! Como você tem contribuído em {{SITENAME}}, gostaríamos de saber se aceita o cargo.
<br /><br />
Ao adotar a wikia você será promovido a administrador e burocrata, para que tenha acesso às ferramentas necessárias para gerir a comunidade e o conteúdo da wikia. Será possível que também conceda privilégios de administração para ajudar, eliminar, desfazer edições, mover e proteger páginas.
<br /><br />
Está preparado(a) para dar os próximos passos e ajudar a wikia {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Quer saber mais?',
	'wikiadoption-know-more-description' => 'Para mais informações visite estes links. E claro, contate-nos se tiver alguma pergunta!',
	'wikiadoption-adoption-successed' => 'Parabéns! Você se tornou administrador nesta wikia!',
	'wikiadoption-adoption-failed' => 'Desculpe-nos. Nós tentamos torná-lo um administrador, mas não deu certo. Por favor [http://comunidade.wikia.com/Especial:Contact contate-nos], e nós vamos tentar ajudá-lo.',
	'wikiadoption-not-allowed' => 'Desculpe-nos. Você não pode adotar esta wikia agora.',
	'wikiadoption-not-enough-edits' => 'Oops! Você precisa ter mais de 10 edições para adotar este wikia.',
	'wikiadoption-adopted-recently' => 'Oops! Você já adotou outro wikia recentemente. Será necessário esperar algum tempo até poder adotar mais um wikia.',
	'wikiadoption-log-reason' => 'Adoção Automática de Wikias',
	'wikiadoption-notification' => 'A wikia {{SITENAME}} está preparada para ser adotada. Tem interesse em tornar-se o(a) novo(a) líder? Adote esta wikia para começar!  $2',
	'wikiadoption-mail-first-subject' => 'Nós não nos vemos há algum tempo',
	'wikiadoption-mail-first-content' => 'Olá $1,

Já faz algumas semanas que nenhum administrador visita a wikia #WIKINAME. Os administradores são parte da wikia #WIKINAME; é importante que tenham uma presença regular. Se por um longo período nenhum administrador estiver ativo, esta wikia ficará disponível para adoção, para permitir que outro usuário se torne administrador.

Se precisar de ajuda para cuidar da wikia, você pode permitir que outros membros da comunidade também sejam administradores através da página $2. Esperamos que regresse à #WIKINAME dentro de pouco tempo.

A equipe da Wikia

Para deixar de receber atualizações desta lista, acesse o seguinte link: $3',
	'wikiadoption-mail-first-content-HTML' => 'Olá $1,<br /><br />

Já fazem algumas semanas que nenhum administrador visita o wiki #WIKINAME. Os administradores são parte do wiki #WIKINAME; é importante que tenham uma presença regular. Se por um longo período nenhum administrador estiver ativo, este wiki ficará disponível para adoção, para permitir que outro usuário se torne administrador.<br /><br />

Se precisar de ajuda para cuidar do wiki, você pode permitir que outros membros da comunidade também sejam administradores através da página de <a href="$2">gestão de privilégios de usuários</a>.  Esperamos que regresse à #WIKINAME dentro de pouco tempo.<br /><br />

A equipe da Wikia<br /><br />

<a href="$3">Deixar de receber atualizações</a> desta lista.',
	'wikiadoption-mail-second-subject' => 'A #WIKINAME será disponibilizada para adoção em breve',
	'wikiadoption-mail-second-content' => 'Olá $1,

Infelizmente, há quase 60 dias que nenhum administrador esteve ativo na wikia #WIKINAME. É importante que existam administradores ativos contribuindo na wikia, para que ela continue funcionando sem problemas.

Como já se passaram tantos dias desde a última aparição de um dos administradores, a wikia #WIKINAME será disponibilizada para outros usuários a adotarem.

A equipe da Wikia

Para deixar de receber atualizações desta lista, acesse o seguinte link: $3',
	'wikiadoption-mail-second-content-HTML' => 'Olá $1,<br /><br />
Infelizmente, há quase 60 dias que nenhum administrador esteve ativo no wiki #WIKINAME. É importante que existam administradores ativos contribuindo no wiki, para que ele continue funcionando sem problemas.<br /><br />

Como já se passaram tantos dias desde a última aparição de um dos administradores, o wiki #WIKINAME será disponibilizado para outros usuários o adotarem.<br /><br />

A equipe da Wikia<br /><br />

<a href="$3">Deixar de receber atualizações</a> desta lista.',
	'wikiadoption-mail-adoption-subject' => 'O wiki #WIKINAME foi adotado',
	'wikiadoption-mail-adoption-content' => 'Olá $1,

O wiki #WIKINAME foi adotado. Os wikis ficam disponíveis para adoção se nenhum dos administradores esteve ativo a pelo menos 60 dias.

O usuário que adotou o wiki #WIKINAME passou a ter privilégios de burocrata e administrador. Não se preocupe, você também continuará sendo administrador neste wiki e bem-vindo a retornar e continuar contribuindo quando puder!

A equipe da Wikia

Para deixar de receber atualizações desta lista, acesse o seguinte link: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Olá $1,<br /><br />
O wiki #WIKINAME foi adotado. Os wikis ficam disponíveis para adoção se nenhum dos administradores esteve ativo a pelo menos 60 dias.<br /><br />

O usuário que adotou o wiki #WIKINAME passou a ter privilégios de burocrata e administrador. Não se preocupe, você também continuará sendo administrador neste wiki e bem-vindo a retornar e continuar contribuindo quando puder!<br /><br />

A equipe da Wikia<br /><br />

<a href="$3">Deixar de receber atualizações</a> desta lista.',
	'tog-adoptionmails' => 'Receber e-mail se o wiki $1 ficar disponível para ser adotado por outros usuários',
	'tog-adoptionmails-v2' => '...se o wiki for disponibilizado para outros usuários o adotarem',
	'wikiadoption-pref-label' => 'Estas alterações de preferências afetarão apenas o wiki $1.',
	'wikiadoption-welcome-header' => 'Parabéns! Você adotou o wiki {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Agora você é um burocrata neste wiki. Com este novo privilégio, será possível acessar todas as ferramentas que te ajudarão a administrar o wiki {{SITENAME}}.
<br /><br />
A coisa mais importante que pode fazer para ajudar o wiki {{SITENAME}} a crescer é continuar editando seu conteúdo.
<br /><br />
Se nenhum administrador do wiki estiver ativo por algum tempo, o wiki será disponibilizado para adoção; por isso, verifique o wiki frequentemente.
<br /><br />
Ferramentas úteis:
<br /><br />
[[Special:ThemeDesigner|Designer de temas]]
<br />
[[Special:LayoutBuilder|Criador de layouts de páginas]]
<br />
[[Special:ListUsers|Lista de usuários]]
<br />
[[Special:UserRights|Gerir privilégios]]',
);

/** Romanian (română)
 * @author Minisarm
 */
$messages['ro'] = array(
	'wikiadoption-header' => 'Adoptă acest wiki',
	'wikiadoption-button-adopt' => 'Da, vreau să adopt {{SITENAME}}!',
	'wikiadoption-know-more-header' => 'Doriți să aflați mai multe?',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME a fost adoptat',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'wikiadoption' => "Adozione automateche d'a uicchi",
	'wikiadoption-desc' => "'N'estenzione AutomaticWikiAdoption pe MediaUicchi",
	'wikiadoption-header' => 'Adotte sta uicchi',
	'wikiadoption-button-adopt' => 'Sìne, vogghie cu adotte {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Iacchie de cchiù!',
	'wikiadoption-know-more-header' => 'Vuè ccu canusce de cchiù?',
	'wikiadoption-adoption-successed' => "Comblimende! Tu si 'n'amministratore de sta uicchi!",
	'wikiadoption-log-reason' => "Adozione automateche d'a uicchi",
	'wikiadoption-mail-adoption-subject' => '#WIKINAME ha state adottate',
	'wikiadoption-welcome-header' => 'Comblimende! Tu è adottate {{SITENAME}}!',
);

/** Russian (русский)
 * @author Kuzura
 */
$messages['ru'] = array(
	'wikiadoption' => 'Автоматическое принятие вики',
	'wikiadoption-desc' => 'AutomaticWikiAdoption расширение для MediaWiki',
	'wikiadoption-header' => 'Принять эту вики',
	'wikiadoption-button-adopt' => 'Да, я хочу принять {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Узнать больше!',
	'wikiadoption-description' => '$1, Вы готовы принять {{SITENAME}}?
<br /><br />
На {{SITENAME}} не было активного администратора длительное вреся, и мы ищем нового лидера, чтобы помочь этой Вики и её сообществу вырасти! Как тот, кто способствовал развитию {{SITENAME}}, нам итересно, не хотели бы Вы остаться здесь?
<br /><br />
Приняв эту вики, вы будете повышены до статуса администратора и бюрократ и получите инструменты для управления сообществом вики и её содержимым. Вы также сможете давать другим участникам права администратора, чтобы помочь Вам удалять, откатывать правки, переименовывать и защищать страницы.
<br /><br />
Вы готовы предпринять следующие шаги, чтобы помочь {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Хотите узнать больше?',
	'wikiadoption-know-more-description' => 'Перейдите по этим ссылкам для получения дополнительной информации. И, конечно, не стесняйтесь обращаться к нам, если у вас есть вопросы!',
	'wikiadoption-adoption-successed' => 'Поздравляем! Теперь Вы администратор этой вики!',
	'wikiadoption-adoption-failed' => 'Приносим свои извинения. Мы старались сделать Вас администратором, однако ничего не вышло. Пожалуйста, [http://community.wikia.com/Special:Contact свяжитесь с нами], и мы постараемся Вам помочь.',
	'wikiadoption-not-allowed' => 'Приносим свои извинения. Вы не можете принять эту вики прямо сейчас.',
	'wikiadoption-not-enough-edits' => 'Вам нужно иметь более чем 10 правок, чтобы принять эту вики.',
	'wikiadoption-adopted-recently' => 'Вы уже приняли другую вики недавно. Вам необходимо подождать некоторое время прежде, чем Вы сможете принять новую вики.',
	'wikiadoption-log-reason' => 'Автоматическое принятие вики',
	'wikiadoption-notification' => '{{SITENAME}} выставляется на принятие. Интересно стать лидером здесь? Примите эту вики, чтобы начать! $2',
	'wikiadoption-mail-first-subject' => 'Мы ещё не видели твою работу здесь',
	'wikiadoption-mail-first-content' => 'Привет $1,

Уже пара недель прошло с тех пор, как мы видели Вас на #WIKINAME. Администраторы являются неотъемлемой частью #WIKINAME и очень важно, чтобы они регулярно присутствовали на вики. Если на вики активных администраторов длительное времен, данная вики может быть другому участнику и статус администратора перейдёт к нему.

Если вам нужна помощь, чтобы заботится о вики, вы можете дать права администратора другим участникам сообщества, перейдя в $2. Надеемся увидеть вас скоро на #WIKINAME!

Команда Викия.

Вы можете отписаться от рассылки в этом списке: $3',
	'wikiadoption-mail-first-content-HTML' => 'Привет $1,<br /><br />

Уже пара недель прошло с тех пор, как мы видели администратора на #WIKINAME. Администраторы являются неотъемлемой частью #WIKINAME и очень важно, чтобы они регулярно присутствовали на вики. Если на вики активных администраторов длительное времен, данная вики может быть другому участнику и статус администратора перейдёт к нему.<br /><br />

Если вам нужна помощь, чтобы заботится о вики, вы можете дать <a href="$2">права администратора</a> другим участникам сообщества. Надеемся увидеть вас скоро на #WIKINAME!<br /><br />

Команда Викия.<br /><br />

Вы можете <a href="$3">отписаться</a> от рассылки в этом списке.',
	'wikiadoption-mail-second-subject' => '#WIKINAME скоро будет выставлена для принятия',
	'wikiadoption-mail-second-content' => 'Привет $1,

Ах нет! Прошло уже 60 дней с тех пор, как мы видели Вас на #WIKINAME. Администраторы являются неотъемлемой частью #WIKINAME и очень важно, чтобы они регулярно присутствовали на вики.

Так как прошло слишком много дней, а текущий администратор так и не появился, #WIKINAME будет предложено принять другому редактору.

Команда Викия.

Вы можете отписаться от рассылки в этом списке: $3',
	'wikiadoption-mail-second-content-HTML' => 'Привет $1,<br /><br />
Ах нет! Прошло уже 60 дней с тех пор, как мы видели активного администратора на #WIKINAME. Очень важно, чтобы администраторы регулярно появлялись на вики и вносили в неё свой вклад, чтобы вики могла работать без проблем.<br /><br />

Так как прошло слишком много дней, а текущий администратор так и не появился, #WIKINAME будет предложено принять другому редактору.<br /><br />

Команда Викия.<br /><br />

Вы можете <a href="$3">отписаться</a> от рассылки в этом списке.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME была принята',
	'wikiadoption-mail-adoption-content' => 'Привет, $1.

#WIKINAME была принята! Вики может быть отдана другому участнику, если ни один из текущих администраторов не будет проявлять активности в течение 60 дней и более.

Участник, который принял #WIKINAME, получил статус бюрократа и администратора. Не беспокойтесь, вы тоже сохраните свой статус администратора, и мы будем рады, если вы вернётесь и продолжите редактировать!

Команда Викия

Кликните по ссылке, чтобы отписаться от изменений в этом списке: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Привет, $1.<br /><br />

#WIKINAME была принята! Вики может быть отдана другому участнику, если ни один из текущих администраторов не будет проявлять активности в течение 60 дней и более.<br /><br />

Участник, который принял #WIKINAME, получил статус бюрократа и администратора. Не беспокойтесь, вы тоже сохраните свой статус администратора, и мы будем рады, если вы вернётесь и продолжите редактировать!<br /><br />

Команда Викия<br /><br />

Вы можете <a href="$3">отписаться</a> от рассылки в этом списке.',
	'tog-adoptionmails' => 'Мой e-mail, если $1 станет доступной для принятия другим участникам',
	'tog-adoptionmails-v2' => '...если вики станет доступной для автоматического принятие другими участниками',
	'wikiadoption-pref-label' => 'Изменение этих настроек влияет только на электронные письма от $1',
	'wikiadoption-welcome-header' => 'Поздравляем! Вы приняли {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'инструментам, которые помогут вам управлять {{SITENAME}}.
<br /><br />
Самая важная вещь, которую вы можете сделать, чтобы помочь {{SITENAME}} расти - это продолжить редактирование.
<br /><br />
Если вы не будете активным администратором, то вики опять может быть выдвинута на принятие, поэтому не забывайте бывать на вики чаще.
<br /><br />
Полезные инструменты:
<br /><br />
[[Special:ThemeDesigner|ThemeDesigner]]
<br />
[[Special:LayoutBuilder|LayoutBuilder]]
<br />
[[Special:ListUsers|Список участников]]
<br />
[[Special:UserRights|Управление правами участников]]',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Aktron
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'wikiadoption' => 'Самоприсвајање викија',
	'wikiadoption-header' => 'Присвоји вики',
	'wikiadoption-button-adopt' => 'Да, желим да присвојим {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Сазнајте више.',
	'wikiadoption-know-more-header' => 'Желите да сазнате више?',
	'wikiadoption-adoption-successed' => 'Честитамо! Постали сте администратор овог викија!',
	'wikiadoption-mail-first-subject' => 'Нисмо се дуго видели.',
);

/** Swedish (svenska)
 * @author Lokal Profil
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'wikiadoption' => 'Automatisk wikiadoption',
	'wikiadoption-desc' => 'Ett AutomatiskWikiAdoptions-tillägg för MediaWiki',
	'wikiadoption-header' => 'Adoptera den här wikin',
	'wikiadoption-button-adopt' => 'Ja, jag vill adoptera {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Lär dig mer!',
	'wikiadoption-description' => '$1, redo att adoptera {{SITENAME}}?
<br /><br />
Det har inte funnits en aktiv administratör på {{SITENAME}} på en stund, och vi letar efter en ny ledare för att hjälpa denna wikis innehåll och gemenskap att växa! Som en av bidragsgivarna på {{SITENAME}} undrar vi om du vill ha jobbet.
<br /><br />
Genom att adoptera wikin, befordras du till administratör och byråkrat som ger dig de verktyg du behöver för att hantera wikins gemenskap och innehåll. Du kommer även kunna skapa andra administratörer för att hjälpa till, ta bort, återställa, flytta och skydda sidor.
<br /><br />
Är du redo att ta nästa steg för att hjälpa {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Vill du veta mer?',
	'wikiadoption-know-more-description' => 'Kolla dessa länkar för mer information. Och naturligtvis är du välkommen att kontakta oss om du har några frågor!',
	'wikiadoption-adoption-successed' => 'Grattis! Du är nu en administratör på denna wiki!',
	'wikiadoption-adoption-failed' => 'Vi ber om ursäkt. Vi försökte att göra dig till en administratör, men det fungerade inte. Vänligen [http://community.wikia.com/Special:Contact kontakta oss], så ska vi försöka hjälpa dig.',
	'wikiadoption-not-allowed' => 'Vi ber om ursäkt. Du kan inte adoptera denna wiki just nu.',
	'wikiadoption-not-enough-edits' => 'Hoppsan! Du måste ha mer än 10 redigeringar för att adoptera denna wiki.',
	'wikiadoption-adopted-recently' => 'Hoppsan! Du har redan adopterat en wiki nyligen. Du måste vänta ett tag innan du kan adoptera en ny wiki.',
	'wikiadoption-log-reason' => 'Automatisk Wikiadoption',
	'wikiadoption-notification' => '{{SITENAME}} är tillgänglig för adoption! Intressant att bli en ledare här? Adoptera denna wiki för att komma igång! $2',
	'wikiadoption-mail-first-subject' => 'Vi har inte sett dig på ett tag',
	'wikiadoption-mail-first-content' => 'Hej $1,

Det har varit ett par veckor sen vi såg en administratör på #WIKINAME. Administratörer är en väsentlig del av #WIKINAME och det är viktigt att de är närvarande regelbundet. Om det inte finns några aktiva medlemmar administratörer under en lång period, kan denna wiki läggas ut för adoption för att låta en annan aktiv användare att bli en administratör.

Om du behöver hjälp med att sköta din wiki, kan du tillåta andra medlemmar i din gemenskap att bli administratörer genom att gå till $2. Hoppas att vi syns på #WIKINAME snart!

Wikia-teamet

Du kan avbryta prenumerationen från ändringar på denna lista här: $3',
	'wikiadoption-mail-first-content-HTML' => 'Hej $1,<br /><br />

Det har varit ett par veckor sen vi såg en administratör på #WIKINAME. Administratörer är en väsentlig del av #WIKINAME och det är viktigt att de är närvarande regelbundet. Om det inte finns några aktiva medlemmar administratörer under en lång period, kan denna wiki läggas ut för adoption för att låta en annan aktiv användare att bli en administratör.<br /><br />

Om du behöver hjälp med att sköta din wiki, kan du tillåta andra medlemmar i din gemenskap att bli administratörer genom att gå till <a href="$2">Användarrättigheterna</a>. Hoppas att vi syns på #WIKINAME snart!<br /><br />

<b>Wikia-teamet</b><br /><br />

Du kan <a href="$3">avbryta prenumerationen</a> från ändringar på denna lista.',
	'wikiadoption-mail-second-subject' => '#WIKINAME kommer att sättas upp för adoption snart',
	'wikiadoption-mail-second-content' => 'Hej $1,

Åh nej! Det har gått nästan 60 dagar sedan det har var en aktiv administratör på #WIKINAME. Det är viktigt att administratörer regelbundet dyker upp och bidrar så wikin kan fortsätta att fungera utan problem.

Eftersom det är så många dagar sedan en nuvarande administratör varit där, kommer #WIKINAME nu erbjudas för adoption till andra redigerare.

Wikia-teamet

Du kan avbryta din prenumeration på ändringar för denna lista här: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hej $1,<br /><br />
Åh nej! Det har nästan gått 30 dagar sedan det var en aktiv administratör på #WIKINAME. Det är viktig att administratörer regelbundet dyker upp och bidrar så att wikin kan ska fungera väl. <br /><br />

Eftersom det är så många dagar sedan en närvarande administratör var där, kommer #WIKINAME att erbjudas för adoption till andra redigerare. <br /><br />

Wikia-teamet<br /><br />

Du kan <a href="$3">avbryta prenumerationen</a> från ändringar av denna lista.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME har adopterats',
	'wikiadoption-mail-adoption-content' => 'Hej $1,

#WIKINAME har adopterats. Wikis finns tillgängliga för att adopteras när ingen av de närvarande administratörerna är aktiv i 30 dagar eller fler.

Den adopterande användaren av #WIKINAME kommer nu ha byråkrat- och administrationsstatus. Oroa dig inte, du kommer också att behålla din administrationsstatus på denna wiki och är välkommen att återvända och fortsätta bidra när som helst!

Wikia-teamet

Klicka på följande länk för att avsluta prenumerationen på ändringar i denna lista: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hej $1,<br /><br />

#WIKINAME har adopterats. Wikis finns tillgängliga för att adopteras när ingen av de närvarande administratörerna är aktiv i 30 dagar eller fler.<br /><br />

Den adopterande användaren av #WIKINAME kommer nu ha byråkrat- och administrationsstatus. Oroa dig inte, du kommer också att behålla din administrationsstatus på denna wiki och är välkommen att återvända och fortsätta bidra när som helst!<br /><br />

Wikia-teamet<br /><br />

Du kan <a href="$3">avbryta prenumerationen</a> på ändringar i denna lista.',
	'tog-adoptionmails' => 'Skicka ett e-post till mig om $1 kommer att bli tillgänglig för andra användare att adoptera',
	'tog-adoptionmails-v2' => '...om wikin kommer att bli tillgänglig för andra användare att adoptera',
	'wikiadoption-pref-label' => 'Att ändra dessa inställningar kommer bara påverkar e-post från $1.',
	'wikiadoption-welcome-header' => 'Gratulerar! Du har adopterat {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Du är du en byråkrat på denna wiki. Med din nya status du nu har tillgång till alla verktyg som hjälper dig hantera {{SITENAME}}.
<br /><br />
Den viktigaste saken du kan göra för att hjälpa {{SITENAME}} att växa är att fortsätta redigera.
<br /><br />
Om det inte finns någon aktiv administratör på en wiki kan den sättas upp för adoption så se till att kolla in wikin ofta.
<br /><br />
Användbara verktyg:
<br /><br />
[[Special:ThemeDesigner|Temadesigner]]
<br />
[[Special:LayoutBuilder|Sidlayout-byggare]]
<br />
[[Special:ListUsers|Användarlista]]
<br />
[[Special:UserRights|Hantera rättigheter]]',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'wikiadoption' => 'ఆటోమాటిక్ వికీ దత్తత',
	'wikiadoption-header' => 'ఈ వికీని దత్తత చేసుకోండి',
	'wikiadoption-button-adopt' => 'ఔను, నేను {{SITENAME}} ను దత్తత చేసుకోవాలనుకుంటున్నాను!',
	'wikiadoption-adopt-inquiry' => 'ఇంకా తెలుసుకోండి!',
	'wikiadoption-know-more-header' => 'మరింత తెలుసుకోవాలనుకుంటున్నారా?',
	'wikiadoption-know-more-description' => 'మరింత సమాచారం కోసం ఈ లింకులు చూడండి. అన్నట్టు, సందేహాలేమైనా ఉంటే వెనకాడకుండా మమ్మల్ని సంప్రదించండి!',
	'wikiadoption-adoption-successed' => 'అభినందనలు! ఇప్పుడు మీరీ వికీలో నిర్వాహకుడయ్యారు!',
	'wikiadoption-adoption-failed' => 'సారీ, మిమ్మల్ని నిర్వాహకునిగా చేద్దామని అనుకున్నాం. కాని కాలేదు. మమ్మల్ని [http://community.wikia.com/Special:Contact సంప్రదించండి], సాయం చేస్తాం.',
	'wikiadoption-not-allowed' => 'సారీ, ప్రస్తుతం మీరీ వికీని దత్తత చేసుకోలేరు.',
	'wikiadoption-not-enough-edits' => 'అయ్యో! ఈ వికీని దత్త చేసుకునేందుకు మీరు కనీసం 10 మార్పుచేర్పులు చేసి ఉండాలి.',
	'wikiadoption-adopted-recently' => 'అయ్యో! ఈ మధ్యనే మీరు మరో వికీని దత్తత చేసుకుని ఉన్నారు. కొత్త వికీని దత్తత చేసుకోవాలంటే కొంత ఆగాలి.',
	'wikiadoption-log-reason' => 'ఆటోమాటిక్ వికీ దత్తత',
	'wikiadoption-notification' => '{{SITENAME}} దత్తత కోసం సిదధంగా ఉంది. దీనికి సారథ్యం వహించేందుకు మీకు ఆసక్తి ఉందా? ఈ వికీని దత్తత తీసుకుని మొదలుపెట్టండి! $2',
	'wikiadoption-mail-first-subject' => 'ఈ మధ్య మీరు ఇటువైపు రానేలేదు',
	'wikiadoption-mail-second-subject' => 'త్వరలో #WIKINAME ను దత్తత కోసం పెడతాం',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME దత్తత తీసుకోబడింది',
	'tog-adoptionmails' => '$1 ఇతర వాడుకరులు దత్తత తీసుకునేందుకు అందుబాటులోకి వస్తే నాకు ఈమెయిలు చెయ్యి',
	'tog-adoptionmails-v2' => '...ఇతర వాడుకరులు దత్తత తీసుకునేందుకు ఈ వికీ అందుబాటులోకి వస్తే',
	'wikiadoption-welcome-header' => 'అభినందనలు! మీరు {{SITENAME}} ను దత్తత చేసుకున్నారు!',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'wikiadoption' => 'Kusang pag-ampon ng wiki',
	'wikiadoption-desc' => 'Isang dugtong na Kusang Pag-ampon ng Wiki para sa MediaWiki',
	'wikiadoption-header' => 'Ampunin ang wiking ito',
	'wikiadoption-button-adopt' => 'Oo, nais kong ampunin ang {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Umalam ng iba pa!',
	'wikiadoption-description' => '$1, handa na sa pag-ampon ng {{SITENAME}}?
<br /><br />
Wala pang nagiging isang masiglang tagapangasiwa sa {{SITENAME}} matapos ang ilang panahon, at naghahanap kami ng isang bagong pinuno upang makatulong sa pagpapalaki ng nilalaman at pamayanan ng wiking ito! Bila isang tao na nakapag-ambag na sa {{SITENAME}} nais naming malaman kung nais mo ang trabahong ito.

<br /><br />
Sa pag-ampon ng wiki, itataas ang ranggo mo upang maging tagapangasiwa at burokrata upang mabigyan ka ng mga kagamitang kakailanganin mo upang mapamahalaan ang pamayanan at nilalaman ng wiki. Magagawa mo ring makalikha ng iba pang mga tagapangasiwa upang makatulong, makapagbura, makapagpagulong na pabalik, makapaglipat at makapagprutekta ng mga pahina.

<br /><br />
Handa ka na bang kuhanin ang susunod na mga hakbang upang makatulong sa {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Nais mo bang umalam pa ng iba?',
	'wikiadoption-know-more-description' => 'Suriin ang mga kawing na ito para sa mas marami pang kabatiran. At may katiyakan, maging malaya na makipag-ugnayan sa amin kung mayroon kang anumang mga katanungan!',
	'wikiadoption-adoption-successed' => 'Maligayang bati! Isa ka na ngayong tagapangasiwa sa wiking ito!',
	'wikiadoption-adoption-failed' => 'Nagpapaumanhin kami. Tinangka naming gawin kang isang tagapangasiwa, subalit hindi ito nangyari. Paki [http://community.wikia.com/Special:Contact makipag-ugnayan sa amin], at susubukan naming matulungan ka.',
	'wikiadoption-not-allowed' => 'Nagpapaumanhin kami. Hindi mo maaampon ang wiking ito sa ngayon.',
	'wikiadoption-not-enough-edits' => 'Naku! Kailangan mong magkaroon ng mas mahigit kaysa sa 10 mga pamamatnugot upang maangkin ang wiking ito.',
	'wikiadoption-adopted-recently' => 'Naku! Nakapag-ampon ka na ng isang wiki kamakailan lamang. Kakailanganin mong maghintay ng ilang panahon bago ka makapag-ampon ng isang bagong wiki.',
	'wikiadoption-log-reason' => 'Kusang Pag-ampon ng Wiki',
	'wikiadoption-notification' => 'Maaaring ampunin ang {{SITENAME}}. Nais mo bang maging isang pinuno rito? Ampunin ang wiking ito upang makapagsimula na! $2',
	'wikiadoption-mail-first-subject' => 'Matagal-tagal ka naming hindi nakita rito',
	'wikiadoption-mail-first-content' => 'Kumusta $1,

Dalawang mga linggo na ang nakalipas magmula noong makakita kami ng isang tagapangasiwa sa #WIKINAME. Ang mga tagapangasiwa ay isang mahalagang bahagi ng #WIKINAME at mahalaga ang regular na paglalagi nila roon. Kung walang masisiglang mga tagapangasiwa sa loob ng matagal na haba ng panahon, ang wiking ito ay maaaring iharap sa pagpapaampon upang mapahintulutan ang ibang tagagamit upang maging isang tagapangasiwa.

Kung kailangan mo ng tulong sa pangangalaga ng wiki, mapapahintulutan mo rin ang ibang mga kasapi ng pamayanan upang maging mga tagapangasiwa na ngayon sa pamamagitan ng pagpunta sa $2. Inaasahan naming makita ka sa #WIKINAME sa lalong madaling panahon!

Ang Pangkat ng Wikia

Maaari kang huwag nang magpasipi ng mga pagbabago sa listahang ito rito: $3',
	'wikiadoption-mail-first-content-HTML' => 'Kumusta $1,

Dalawang mga linggo na ang nakalipas magmula noong makakita kami ng isang tagapangasiwa sa #WIKINAME. Ang mga tagapangasiwa ay isang mahalagang bahagi ng #WIKINAME at mahalaga ang regular na paglalagi nila roon. Kung walang masisiglang mga tagapangasiwa sa loob ng matagal na haba ng panahon, ang wiking ito ay maaaring iharap sa pagpapaampon upang mapahintulutan ang ibang tagagamit upang maging isang tagapangasiwa.<br /><br />

Kung kailangan mo ng tulong sa pangangalaga ng wiki, mapapahintulutan mo rin ang ibang mga kasapi ng pamayanan upang maging mga tagapangasiwa na ngayon sa pamamagitan ng pagpunta sa <a href="$2">pamamahala ng mga Karapatan ng Tagagamit</a>. Inaasahan naming makita ka sa #WIKINAME sa lalong madaling panahon!

Ang Pangkat ng Wikia

Maaari kang <a href="$3">huwag nang magpasipi</a> ng mga pagbabago sa listahang ito.',
	'wikiadoption-mail-second-subject' => 'Ihaharap na para sa pagpapaampon ang #WIKINAME sa lalong madaling panahon',
	'wikiadoption-mail-second-content' => 'Kumusta $1,

Hay naku! 60 mga araw na ang nakalipas magmula noong magkaroon ng isang masiglang tagapangasiwa sa #WIKINAME. Mahalaga ang regular na paglitaw at pag-aambag ng mga tagapangasiwa upang makapagpatuloy ang wiki sa panatag na pagtakbo.

Dahil sa maraming mga araw na ang nakaraan magmula noong lumitaw ang isang pangkasalukuyang tagapangasiwa, ang #WIKINAME ay iaalok na ngayon upang maipaampn sa ibang mga patnugot.

Ang Pangkat ng Wikia

Maaari kang huwag nang magpasipi ng mga pagbabago sa listahang ito rito: $3',
	'wikiadoption-mail-second-content-HTML' => 'Kumusta $1,
Naku po! 60 mga araw na ang nakalipas magmula noong magkaroon ng isang masiglang tagapangasiwa sa #WIKINAME. Mahalaga ang regular na paglitaw at pag-aambag ng mga tagapangasiwa upang makapagpatuloy ang wiki sa panatag na pagtakbo.<br /><br />

Dahil sa maraming mga araw na ang nakaraan magmula noong lumitaw ang isang pangkasalukuyang tagapangasiwa, ang #WIKINAME ay iaalok na ngayon upang maipaampn sa ibang mga patnugot. <br /><br />

Ang Pangkat ng Wikia<br /><br />

Maaari kang <a href="$3">huwag nang magpasipi ng mga pagbabago</a> sa listahang ito.',
	'wikiadoption-mail-adoption-subject' => 'Naampon na ang #WIKINAME',
	'wikiadoption-mail-adoption-content' => 'Kumusta $1,

Naampon na ang #WIKINAME. Ang mga wiki ay makukuha upang ampunin kapag walang masigla mula sa pangkasalukuyang mga tagapangasiwa sa loob ng 60 mga araw o mahigit pa.

Ang tagagamit na umampon ng #WIKINAME ay magkakaroon na ngayon ng katayuang burokrato at tagapangasiwa. Huwag mag-alala, mananatili pa rin ang iyong katayuan bilang tagapangasiwa sa wiking ito at malugod ka pa ring tatanggapin upang bumalik at magpatuloy sa pag-aambag sa anumang oras!

Ang Pangkat ng Wikia

Maaari kang huwag nang magpasipi ng mga pagbabago sa listahang ito rito: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Kumusta $1,

Naampon na ang #WIKINAME. Ang mga wiki ay makukuha upang ampunin kapag walang masigla mula sa pangkasalukuyang mga tagapangasiwa sa loob ng 60 mga araw o mahigit pa.<br /><br />

Ang tagagamit na umampon ng #WIKINAME ay magkakaroon na ngayon ng katayuang burokrato at tagapangasiwa. Huwag mag-alala, mananatili pa rin ang iyong katayuan bilang tagapangasiwa sa wiking ito at malugod ka pa ring tatanggapin upang bumalik at magpatuloy sa pag-aambag sa anumang oras!<br /><br />

Ang Pangkat ng Wikia<br /><br />

Maaari kang <a href="$3">huwag nang magpasipi</a> ng mga pagbabago sa listahang ito.',
	'tog-adoptionmails' => 'Padalhan ako ng e-liham kapag naging makukuha na ang $1 para maampon ng iba pang mga tagagamit',
	'tog-adoptionmails-v2' => '... kapag ang wiki ay magiging makukuha para maampon ng ibang mga tagagamit',
	'wikiadoption-pref-label' => 'Ang pagbago sa mga kanaisang ito ay makakaapekto lamang sa mga e-liham mula kay $1.',
	'wikiadoption-welcome-header' => 'Maligayang bati! Naampon mo na ang {{SITENAME}}!',
	'wikiadoption-welcome-body' => "Isa ka na ngayong burokrata sa wiking ito. Sa pamamagitan ng bago mong katayuan makakapunta ka na sa lahat ng mga kasangkapan na makakatulong sa pamamahala mo ng {{SITENAME}}.
<br /><br />
Ang pinaka mahalagang bagay na magagawa mo upang matulungan ang paglaki ng {{SITENAME}} ay patuloy na pamamatnugot.
<br /><br />
Kapag walang masiglang tagapangasiwa sa isang wiki maaari ito itong iharap sa pagpapaampon kaya't siguraduhin ang madalas na pagsuri ng wiki.
<br /><br />
Mga Kasangkapang Nakakatulong:
<br /><br />
[[Special:ThemeDesigner|Tagapagdisenyo ng Tema]]
<br />
[[Special:LayoutBuilder|Tagagawa ng Kalatagan ng Pahina]]
<br />
[[Special:ListUsers|Listahan ng Tagagamit]]
<br />
[[Special:UserRights|Mamahala ng mga Karapatan]]",
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 * @author Trncmvsr
 */
$messages['tr'] = array(
	'wikiadoption' => 'Otomatik wiki kabulü',
	'wikiadoption-desc' => 'MediaWiki için AutomaticWikiAdoption eklentisi',
	'wikiadoption-header' => 'Bu wikiyi kabul et',
	'wikiadoption-button-adopt' => 'Evet, Ben {{SITENAME}} sitesini kabul etmek istiyorum!',
	'wikiadoption-adopt-inquiry' => 'Daha fazla bilgi!',
	'wikiadoption-description' => '$1, {{SITENAME}} sitesini kabul etmeye hazır mısınız?
<br /><br />
{{SITENAME}} wikisinde bir süredir aktif bir yönetici yoktu ve biz bu eklentiyi sitenin içeriği ile topluluğun büyümesine yardımcı olacak yeni bir lider araması için bulduk! Biz {{SITENAME}} sitesine katkıda bulunan birisi olarak çalışmayı isteyip, istemediğinizi merak ediyoruz.
<br /><br />
Eğer wiki topluluğuna gelerek içeriği yönetmek için gerekli araçların verilmesini talep ederseniz, bu durumda kabul etme eklentisi sizi yönetici ve bürokrat olarak atayacaktır. Böylece, diğer yöneticilere yardımcı olmak için silme, geriye alma, taşıma ve sayfaları koruma yetkiniz olacaktır.
<br /><br />
{{SITENAME}} sitesine yardım etmek için bir sonraki adıma hazır mısınız?',
	'wikiadoption-know-more-header' => 'Daha fazlasını öğrenmek ister misin?',
	'wikiadoption-know-more-description' => 'Daha fazla bilgi için bu bağlantıları göz atın. Ve tabii ki, herhangi bir sorunuz varsa lütfen bizimle temas kurmaktan çekinmeyin!',
	'wikiadoption-adoption-successed' => 'Tebrikler! Bu wiki üzerinde artık bir yöneticisiniz!',
	'wikiadoption-adoption-failed' => 'Özür dileriz. Sizi bir yönetici yapmayı denedik ama bu işe yaramadı. Lütfen [http://community.wikia.com/Special:Contact bize ulaşın] ve size yardımcı olmaya çalışalım.',
	'wikiadoption-not-allowed' => 'Özür dileriz. Bu wiki şu anda bunu kabul etmiyor.',
	'wikiadoption-not-enough-edits' => "Oops! Bu wikiyi kabul edebilmeniz için 10'dan fazla düzenlemenizin olması gerekir.",
	'wikiadoption-adopted-recently' => 'Oops! Son zamanlarda başka bir wikiyi  zaten kabul ettiniz. Yeni bir wikiyi kabul etmek için daha önce bir süre beklemeniz gerekecektir.',
	'wikiadoption-log-reason' => 'Otomatik wiki kabulü',
	'wikiadoption-notification' => '{{SITENAME}} sitesi için kabul etme bulunmakta. Burada bir lider olmakla ilgileniyor musunuz? Dilerseniz bu wikiyi kabul etmeye başlayın! $2',
	'wikiadoption-mail-first-subject' => 'Biz sizi bir süredir çevrelerde göremedik',
);

/** Ukrainian (українська)
 * @author A1
 * @author Andriykopanytsia
 * @author Erami
 * @author Mykola Swarnyk
 * @author Steve.rusyn
 * @author SteveR
 * @author Ua2004
 * @author Тест
 */
$messages['uk'] = array(
	'wikiadoption' => 'Автоматичне всиновлення вікі',
	'wikiadoption-desc' => 'Розширення AutomaticWikiAdoption для MediaWiki',
	'wikiadoption-header' => 'Прийняти цю wiki',
	'wikiadoption-button-adopt' => 'Так, я хочу прийняти {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Дізнайтеся більше!',
	'wikiadoption-description' => '$1, Ви готові прийняти {{SITENAME}}?
<br /><br />
На {{SITENAME}} не було активного адміністратора тривалий час і ми шукаємо нового лідера, який би допоміг цій вікі та її спільності вирости! Оскільки ви сприяли розвитку {{SITENAME}}, нам цікаво, чи не хочете Ви лишитися тут?
<br /><br />
Прийнявши цю вікі, ви будете підвищені до статусу адміністратора та бюрократа, щоб отримати інструменти для управління спільнотою вікі та її вмістом. Ви також зможете давати іншим учасникам права адміністратора, щоби допомогти вам вилучати, відновлювати, переміщувати та захищати сторінки.
<br /><br />
Ви готові здійснити наступні кроки, щоб допомогти {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Хочете знати більше?',
	'wikiadoption-know-more-description' => "Перевірте ці посилання для отримання додаткової інформації. І, звичайно ж, не соромтеся зв'язатися з нами, якщо у вас є будь-які питання!",
	'wikiadoption-adoption-successed' => 'Вітаємо! Тепер Ви адміністратор цієї вікі!',
	'wikiadoption-adoption-failed' => "Приносимо свої вибачення. Ми намагалися зробити вас адміністратором, однак нічого не вийшло. Будь ласка,[http://community.wikia.com/Special:Contact зв'яжіться з нами], і ми постараємося вам допомогти.",
	'wikiadoption-not-allowed' => 'Ми шкодуємо. Ви не можете прийняти цю вікі прямо зараз.',
	'wikiadoption-not-enough-edits' => 'От халепа! Ви повинні мати більше 10 редагувань, щоб прийняти цю вікі.',
	'wikiadoption-adopted-recently' => 'Ви вже прийняли іншу вікі нещодавно. Вам доведеться почекати якийсь час, перш ніж можна буде прийняти нову вікі.',
	'wikiadoption-log-reason' => 'Автоматичне Прийняття вікі',
	'wikiadoption-notification' => '{{SITENAME}} виставлено на прийняття. Хочете стати лідером тут? Прийміть цю вікі, щоб почати! $2',
	'wikiadoption-mail-first-subject' => 'Щось давненько ми вас не бачили',
	'wikiadoption-mail-first-content' => "Привіт $1,

Вже кілька тижнів пройшло, відколи ми востаннє бачили вас на #WIKINAME. Адміністратори є невід'ємною частиною #WIKINAME і дуже важливо, щоб вони регулярно були присутні на вікі. Якщо на вікі нема активних адміністраторів тривалий час, то ця вікі може бути віддана іншому учаснику і статус адміністратора перейде до нього.

Якщо вам потрібна допомога, щоб піклуватися про вікі, ви можете дати права адміністратора іншим учасникам спільноти, перейшовши у $2. Сподіваємося побачити вас скоро на #WIKINAME!

Команда Вікії.

Ви можете відмовитись від розсилки в цьому списку: $3",
	'wikiadoption-mail-first-content-HTML' => 'Привіт $1,<br /><br />

Вже кілька тижнів минуло, відколи ми востаннє дбачили адміністратора на #WIKINAME. Адміністратори є невід\'ємною частиною #WIKINAME і дуже важливо, щоб вони регулярно були присутні на вікі. Якщо на вікі нема
 активних адміністраторів тривалий час, то ця вікі може бути віддана іншому учаснику і статус адміністратора перейде до нього.<br /><br />

Якщо вам потрібна допомога, щоб піклуватися про вікі, то ви зможете дати <a href="$2">права адміністратора</a> іншим учасникам спільноти. Сподіваємось побачити вас скоро на #WIKINAME!<br /><br />

Команда Вікія.<br /><br />

Ви можете <a href="$3">відмовитися від розсилки<a href="$3"> у цьому списку.',
	'wikiadoption-mail-second-subject' => '#WIKINAME буде виставлена на прийняття скоро',
	'wikiadoption-mail-second-content' => "Привіт $1,

Ох, невже! Пройшло вже 60 днів з тих пір, як ми бачили Вас на #WIKINAME. Адміністратори є невід'ємною частиною #WIKINAME і дуже важливо, щоби вони регулярно були присутні на вікі.

Оскільки пройшло надто багато днів, а поточний адміністратор так і не появився, то #WIKINAME буде запропоновано прийняти іншому редактору.

Команда Вікія.

Ви можете відписатися від розсилки у цьому списку: $3",
	'wikiadoption-mail-second-content-HTML' => 'Привіт $1,<br /><br />
О-о, ні! Минуло майже 60 днів з моменту, коли ми бачили активного адміністратора на #WIKINAME. Дуже важливо, щоби адміністратори регулярно з\'являлися на вікі та вносили у неї свій внесок, щоби вікі могла працювати без проблем.<br /><br />

Оскільки минуло надто багато днів, а поточний адміністратор так і не з\'явився, адміністрування #WIKINAME буде запропоноване іншому редактору.<br /><br />

Команда Вікія.<br /><br />

Ви можете <a href="$3">відписатися</a> від розсилки у цьому списку.',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME була прийнята',
	'wikiadoption-mail-adoption-content' => 'Привіт, $1.

#WIKINAME була прийнята! Вікі може бути віддана іншому учаснику, якщо жоден з поточних адміністраторів не проявлятиме активності протягом 60 днів і більше.

Учасник, який прийняв #WIKINAME, отримав статус бюрократа і адміністратора. Не турбуйтеся, ви теж збережете свій статус адміністратора, і ми будемо раді, якщо ви повернетеся і продовжите редагувати!

Команда Вікія

Клацніть по посиланню, щоб відписатися від змін у цьому списку: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Привіт, $1.<br /><br />

#WIKINAME була прийнята! Вікі може бути віддана іншому учаснику, якщо жоден з поточних адміністраторів не проявлятиме активності протягом 60 днів і більше.<br /><br />

Учасник, який прийняв #WIKINAME, отримав статус бюрократа і адміністратора. Не турбуйтеся, ви теж збережете свій статус адміністратора, і ми будемо раді, якщо ви повернетеся і продовжите редагувати!<br /><br />

Команда Вікія<br /><br />

Ви можете <a href="$3">відписатися</a> від розсилки у цьому списку.',
	'tog-adoptionmails' => 'Сповістити мене, якщо $1 стане доступною для привласнення іншими користувачами',
	'tog-adoptionmails-v2' => '...якщо вікі стане доступною для привласнення іншими користувачами',
	'wikiadoption-pref-label' => 'Зміна цих параметрів впливатиме лише на листи з $1.',
	'wikiadoption-welcome-header' => 'Вітаємо! Ви прийняли {{SITENAME}}!',
	'wikiadoption-welcome-body' => "Ви зараз бюрократ на цій вікі. З новим статусом тепер у вас є доступ до всіх інструментів, які допоможуть вам керувати  {{SITENAME}}.
<br /><br />
Найважливіша річ, яку ви можете зробити, щоб допомогти ім'я  {{SITENAME}} рости, це продовжити редагування.
<br /><br />
Якщо немає активних адміністратора на цій вікі, вікі знову буде висунена на прийняття, тому не забувайте заглядати на вікі частіше.
<br /><br />
Корисні інструменти:
<br /><br />
[[Special:ThemeDesigner|Дизайнер тем]]
<br />
[[Special:LayoutBuilder|Будівник розмітки сторінки]]
<br />
[[Special:ListUsers|Список користувачів]]
<br />
[[Special:UserRights|Керування правами]]",
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author KhangND
 */
$messages['vi'] = array(
	'wikiadoption' => 'Tự động nhận wiki',
	'wikiadoption-desc' => 'Một phần mở rộng AutomaticWikiAdoption cho MediaWiki',
	'wikiadoption-header' => 'Nhận wiki này',
	'wikiadoption-button-adopt' => 'Có, tôi muốn nhận {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Tìm hiểu thêm',
	'wikiadoption-description' => '$1, sẵn sàng để áp dụng {{SITENAME}}?
<br /><br />
Chưa có một quản trị viên hoạt động trên {{SITENAME}} trong một thời gian, và chúng tôi đang tìm kiếm một nhà lãnh đạo mới để giúp wiki này nội dung và cộng đồng phát triển! Là một người đã đóng góp cho {{SITENAME}}, chúng tôi đã tự hỏi nếu bạn muốn công việc.
<br /><br />
Bằng việc áp dụng wiki, bạn sẽ được lên đến người quản trị và hành chính để cung cấp cho bạn các công cụ bạn cần để quản lý wiki cộng đồng và nội dung. Bạn cũng có thể tạo các quản trị viên để giúp đỡ, xóa, quay ngược lại, di chuyển và bảo vệ trang.
<br /><br />
Bạn đã sẵn sàng để thực hiện các bước tiếp theo để giúp {{SITENAME}} trở nên thành công hơn?',
	'wikiadoption-know-more-header' => 'Bạn có muốn biết thêm chi tiết?',
	'wikiadoption-know-more-description' => 'Kiểm tra những liên kết này để biết thêm thông tin. Và tất nhiên, thoải mái liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi!',
	'wikiadoption-adoption-successed' => 'Chúc mừng bạn! Bây giờ bạn là một bảo quản viên trên wiki này!',
	'wikiadoption-adoption-failed' => 'Chúng tôi rất tiếc. Chúng tôi đã cố gắng cấp cho bạn quyền bảo quản viên, nhưng không thành công. Xin vui lòng [http://community.wikia.com/Special:Contact liên hệ chúng tôi], và chúng tôi sẽ cố gắng hỗ trợ bạn.',
	'wikiadoption-not-allowed' => 'Chúng tôi rất tiếc. Bạn không thể nhận wiki này ngay bây giờ.',
	'wikiadoption-not-enough-edits' => 'Rất tiếc! Bạn cần phải có hơn 10 sửa đổi mới có quyền nhận wiki này.',
	'wikiadoption-adopted-recently' => 'Rất tiếc! Bạn đã vừa mới nhận một wiki gần đây. Bạn cần phải đợi một thời gian nữa trước khi bạn có thể nhận một wiki mới.',
	'wikiadoption-log-reason' => 'Tự động nhận wiki',
	'wikiadoption-notification' => '{{SITENAME}} là wiki có thể được nhận. Muốn trở thành một quản trị ở đây? Nhận wiki này để bắt đầu! $2',
	'wikiadoption-mail-first-subject' => 'Chúng tôi đã không nhìn thấy bạn xung quanh trong một thời gian',
	'wikiadoption-mail-first-content' => 'Xin chào $1,

Nó đã là một vài tuần kể từ khi chúng tôi đã thấy một bảo quản viên trên #WIKINAME. bảo quản viên là một phần không thể tách rời của #WIKINAME và nó là quan trọng, họ có một sự hiện diện thường xuyên. Nếu không có không có bảo quản viên hoạt động trong một thời gian dài của thời gian, wiki này có thể được đưa lên làm con nuôi để cho phép các người dùng khác để trở thành người bảo quản viên.

Nếu bạn cần trợ giúp chăm sóc của wiki, bạn cũng có thể cho phép các thành viên khác của cộng đồng để trở thành bảo quản viên bây giờ bằng cách đi tới  $2 .  Hy vọng để xem bạn trên #WIKINAME sớm!

Đội Wikia

Bạn có thể ngừng đăng ký thay đổi vào danh sách này ở đây:$3',
	'wikiadoption-mail-first-content-HTML' => 'Hi $1,<br /><br />

Nó đã là một vài tuần kể từ khi chúng tôi đã thấy một bảo quản viên trên #WIKINAME. bảo quản viên là một phần không thể tách rời của #WIKINAME và nó là quan trọng, họ có một sự hiện diện thường xuyên. Nếu không có bảo quản viên hoạt động trong một thời gian dài của thời gian, wiki này có thể được đưa lên làm wiki cần nhận để cho phép các người dùng khác để trở thành bảo quản viên.<br /><br />

Nếu bạn cần trợ giúp chăm sóc của wiki, bạn cũng có thể cho phép các thành viên khác của cộng đồng để trở thành bảo quản viên bây giờ bằng cách đi đến <a href="<span class=" notranslate"="" translate="no">$2"> quản lý người dùng quyền</a>.  Hy vọng để xem bạn trên #WIKINAME sớm!<br /><br />

Cộng đồng hỗ trợ Wikia<br /><br />

Bạn có thể <a href="<span class=" notranslate"="" translate="no">$3"> bỏ đăng ký</a> từ các thay đổi vào danh sách này.',
	'wikiadoption-mail-second-subject' => '#WIKINAME sẽ được đưa lên làm chủ sớm',
	'wikiadoption-mail-second-content' => 'Xin chào $1,

Ôi, không! Nó đã là gần 60 ngày kể từ khi đã có hoạt động quản trị viên trên #WIKINAME. Nó là quan trọng là quản trị viên thường xuyênn xuất hiện và đóng góp để wiki có thể tiếp tục chạy trơn tru.

Kể từ khi nó đã là nhiều ngày kể từ khi một quản trị hiện tại đã xuất hiện, #WIKINAME sẽ bây giờ được cung cấp cho nhận con nuôi cho biên tập viên khác.

Đội Wikia

Bạn có thể ngừng đăng ký thay đổi vào danh sách này ở đây: $3',
	'wikiadoption-mail-second-content-HTML' => 'Xin chào $1,
Ôi, không! Nó đã là gần 60 ngày kể từ khi đã có hoạt động bảo quản viên trên #WIKINAME. Nó là quan trọng là quản trị viên thường xuyênn xuất hiện và đóng góp để wiki có thể tiếp tục chạy trơn tru.

Kể từ khi nó đã là nhiều ngày kể từ khi một quản trị hiện tại đã xuất hiện, #WIKINAME sẽ bây giờ được cung cấp cho cho biên tập viên khác.

Đội Wikia

Bạn có thể ngừng đăng ký thay đổi vào danh sách này ở đây: $3',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME đã được áp dụng',
	'wikiadoption-mail-adoption-content' => 'Hi $1,

 #WIKINAME đã được áp dụng.  Wiki có sẵn để được thông qua khi không ai trong số các quản trị viên hiện tại đang hoạt động trong 60 ngày hoặc hơn.

Người dùng chọn #WIKINAME bây giờ sẽ có trạng thái công chức và admin.  Đừng lo lắng, bạn sẽ cũng của bạn giữ lại tình trạng quản trị viên trên wiki này và được chào đón để trở lại và tiếp tục đóng góp bất cứ lúc nào

Đội Wikia

Bạn có thể ngừng đăng ký thay đổi vào danh sách này ở đây:$3',
	'wikiadoption-mail-adoption-content-HTML' => 'Hi $1,<br /><br />

 #WIKINAME đã được áp dụng.  Wiki có sẵn để được thông qua khi không ai trong số các bảo quản viên hiện tại đang hoạt động cho 60 ngày hoặc nhiều hơn.<br /><br />

Người dùng chọn #WIKINAME bây giờ sẽ có trạng thái công chức và admin.  Đừng lo lắng, bạn sẽ cũng của bạn giữ lại tình trạng bảo quản viên trên wiki này và được chào đón để trở lại và tiếp tục đóng góp bất cứ lúc nào!<br /><br />

Đội Wikia<br /><br />

Bạn có thể <a href="$3">bỏ đăng ký</a> từ các thay đổi vào danh sách này.',
	'tog-adoptionmails' => 'Gửi email cho tôi nếu $1 sẽ trở thành có sẵn cho người dùng khác để áp dụng',
	'tog-adoptionmails-v2' => '.. .Nếu wiki sẽ trở thành có sẵn cho người dùng khác để áp dụng',
	'wikiadoption-pref-label' => 'Thay đổi những tùy chọn sẽ chỉ ảnh hưởng đến email từ $1.',
	'wikiadoption-welcome-header' => 'Chúc mừng! Bạn đã thông qua {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Bạn bây giờ là một công chức wiki này. Với tình trạng mới của bạn, bạn bây giờ có quyền truy cập vào tất cả các công cụ mà sẽ giúp bạn quản lý {{SITENAME}}.
<br /><br />
Điều quan trọng nhất bạn có thể làm để giúp đỡ {{SITENAME}} phát triển là tiếp tục chỉnh sửa.
<br /><br />
Nếu có là không có quản trị viên hoạt động trên một wiki nó có thể được đưa lên cho nhận con nuôi như vậy chắc chắn để kiểm tra thường xuyên trong wiki.
<br /><br />
Công cụ hữu ích:
<br /><br />
[[Special:ThemeDesigner|ThemeDesigner]]
<br />
[[Special:LayoutBuilder|Page Layout Builder]]
<br />
[[Special:ListUsers|User List]]
<br />
[[Special:UserRights|Manage Rights]]',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Dimension
 * @author Hydra
 * @author Hzy980512
 * @author Liuxinyu970226
 * @author Sora
 * @author User670839245
 */
$messages['zh-hans'] = array(
	'wikiadoption' => '自动维基领养',
	'wikiadoption-desc' => '供MediaWiki使用的“自动维基认领”扩展程序',
	'wikiadoption-header' => '领养这个维基',
	'wikiadoption-button-adopt' => '是，我想要领养{{SITENAME}}！',
	'wikiadoption-adopt-inquiry' => '了解更多！',
	'wikiadoption-description' => '$1，准备好认领 {{SITENAME}} 了吗？
<br /><br />
在 {{SITENAME}} 上有一段时间没有活跃的管理员了，我们在为这个维基找一个新的领导者并帮助其内容和社区发展！作为 {{SITENAME}} 曾经的一位贡献者，我们很好奇您是否愿意接受这项工作。
<br /><br />
认领此维基可以让您成为此维基的管理员和行政员，并可以使用我们为您提供的管理工具来管理这个维基。您也可以赋予其他用户管理权限以帮助、删除、回退、移动和保护页面。
<br /><br />
您准备好认领 {{SITENAME}} 的下一步了吗？',
	'wikiadoption-know-more-header' => '想知道更多吗？',
	'wikiadoption-know-more-description' => '查询这些链接获取更多信息。当然，如果您遇到任何问题，请随时和我们联系！',
	'wikiadoption-adoption-successed' => '恭喜！您现在是这个维基的管理员！',
	'wikiadoption-adoption-failed' => '很抱歉。我们曾试图使您成为管理员，但失败了。请[http://community.wikia.com/Special:Contact 联系我们]，我们会努力帮助您解决。',
	'wikiadoption-not-allowed' => '我们很抱歉。您现在不能认领此维基。',
	'wikiadoption-not-enough-edits' => '糟糕！您需要编辑10次以上方能领养此维基。',
	'wikiadoption-adopted-recently' => '糟糕！您最近已认领了一个维基。您需要等待一段时间之后再认领一个新的维基。',
	'wikiadoption-log-reason' => '自动认领维基',
	'wikiadoption-notification' => '{{SITENAME}}正等待认领。您是否对领导此维基感兴趣？那就从认领它开始吧！$2',
	'wikiadoption-mail-first-subject' => '我们已经有一段时间没有看到你了',
	'wikiadoption-mail-first-content' => '嗨！$1，

距我们上次在#WIKINAME上关注到有管理员已经过了几个星期。管理员是#WIKINAME的组成部分之一，其经常出现是十分重要的。如果此处长期没有活跃管理员，这个wiki开放认领以允许其他用户成为管理员。

如果您需要帮助照顾此wiki，您还可以允许其他社群成员加入$2成为管理员。我们盼望不久您活跃在#WIKINAME上！

Wikia团队

您可以通过点此取消邮件订阅：$3',
	'wikiadoption-mail-first-content-HTML' => '你好，$1

你作为#WIKINAME的管理员，应该是要经常出现在你所管理的wiki的。可是我们发现，你在最近的几个星期都没有出现在#WIKINAME上。如果这种情况依然持续，这个wiki可能会允许其他用户成为管理员。

如果你需要其他人帮忙管理这个wiki，你还可以在<a href="$2">用户权限管理</a>中将其他社区成员设置为这个wiki的管理员。同时，我们衷心希望在今后能够在#WIKINAME上经常看到你！

Wikia团队

你可以点击<a href="$3">这里取消邮件订阅</a>。',
	'wikiadoption-mail-second-subject' => '#WIKINAME 将很快被公示认领',
	'wikiadoption-mail-second-content' => '嗨，$1,

噢，不！现役管理员上一次在#WIKINAME上出现已经是60天前的事情了。管理员经常出现并有所贡献是很重要的，这样才能使维基持续顺利的运行。

由于当前管理员已经多天没有出现，#WIKINAME将由其他编辑者认领。

Wikia小组

您可以退订本列表的改动，点击这里：$3',
	'wikiadoption-mail-second-content-HTML' => '你好，$1

糟糕！#WIKINAME的管理员已经能够有60天没有出现了。作为管理员，要维持wiki的顺利运行，需要经常出现并且有所贡献。

由于当前的管理员已经很长时间没有出现过，#WIKINAME已经被其他编辑者进行管理。

Wikia团队

你可以<a href="$3">点击这里取消邮件订阅</a>。',
	'wikiadoption-mail-adoption-subject' => '#WIKINAME已被认领',
	'wikiadoption-mail-adoption-content' => '$1，您好

#WIKINAME已被代管。当Wiki的所有管理员60天或更久没有活动时，Wiki将可被代管。

#WIKINAME的代管用户将拥有行政员与管理员权限。别担心，您还可以随时重新取得您在此Wiki上的管理员权限并继续做出贡献。

Wikia团队

您可以更改这个列表来取消订阅信息：$3',
	'wikiadoption-mail-adoption-content-HTML' => '$1，您好<br /><br />

#WIKINAME已被代管。当一个Wiki的所有管理员60天或更久没有活动时，那么它就可以被代管。<br /><br />

#WIKINAME的代管用户将拥有行政员与管理员权限。别担心，您还可以随时重新取得您在此Wiki上的管理员权限并继续做出贡献。<br /><br />

Wikia团队<br /><br />

您可以更改这个列表来<a href="$3">取消</a>订阅信息。',
	'tog-adoptionmails' => '当$1可以被其他用户认领时邮件通知我',
	'tog-adoptionmails-v2' => '……如果这个维基可以被其他用户认领',
	'wikiadoption-pref-label' => '变更首选项只会影响来自$1的邮件。',
	'wikiadoption-welcome-header' => '恭喜！你已认领了{{SITENAME}}！',
	'wikiadoption-welcome-body' => '您现在是本维基的行政员。利用这一新身份，您可以使用所有工具协助管理{{SITENAME}}。
<br /><br />
帮助{{SITENAME}}成长最重要的事就是保持编辑。
<br /><br />
如果一个维基没有活跃的管理员，它将交由他人认领。所以请务必经常查阅本维基。
<br /><br />
实用链接:
<br /><br />
[[Special:ThemeDesigner|主题设计器]]
<br />
[[Special:LayoutBuilder|页面布局生成器]]
<br />
[[Special:ListUsers|用户列表]]
<br />
[[Special:UserRights|管理权限]]',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Citizen01
 * @author Ffaarr
 * @author LNDDYL
 */
$messages['zh-hant'] = array(
	'wikiadoption' => '自動wiki認領',
	'wikiadoption-header' => '認領這個wiki',
	'wikiadoption-button-adopt' => '是的，我想要認領{{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => '瞭解更多 ！',
	'wikiadoption-know-more-header' => '想知道更多嗎？',
	'wikiadoption-adoption-successed' => '恭喜 ！你現在是這個 wiki 的管理員了 ！',
	'wikiadoption-adoption-failed' => '我們很抱歉。我們試圖使您成為管理員，但並不成功。請 [http://community.wikia.com/Special:Contact 聯絡我們]，我們會儘量幫助你。',
	'wikiadoption-not-allowed' => '很抱歉。你現在不能認領此 wiki。',
	'wikiadoption-not-enough-edits' => '哎呀 ！您需要有超過 10 次對本wiki的編輯才能認領它。',
	'wikiadoption-log-reason' => '自動 Wiki 認領',
	'wikiadoption-mail-first-subject' => '我們有一段時間沒有看到你',
	'wikiadoption-welcome-header' => '恭喜！您已認領 {{SITENAME}}！',
);
