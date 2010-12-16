<?php
/**
 * Internationalisation file for extension Gadgets.
 *
 * @addtogroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

$messages = array();

/** English
 * @author Daniel Kinzler, brightbyte.de
 */
$messages['en'] = array(
	#for Special:Version
	'gadgets-desc'      => 'Lets users select custom [[Special:Gadgets|CSS and JavaScript gadgets]] in their [[Special:Preferences|preferences]]',

	#for Special:Preferences
	'prefs-gadgets'     => 'Gadgets',
	'gadgets-prefstext' => 'Below is a list of special gadgets you can enable for your account.
These gadgets are mostly based on JavaScript, so JavaScript has to be enabled in your browser for them to work.
Note that these gadgets will have no effect on this preferences page.

Also note that these special gadgets are not part of the MediaWiki software, and are usually developed and maintained by users on your local wiki.
Local administrators can edit available gadgets using [[MediaWiki:Gadgets-definition|definitions]] and [[Special:Gadgets|descriptions]].',

	#for Special:Gadgets
	'gadgets'           => 'Gadgets',
	'gadgets-title'     => 'Gadgets',
	'gadgets-pagetext'  => "Below is a list of special gadgets users can enable on their [[Special:Preferences|preferences page]], as defined by the [[MediaWiki:Gadgets-definition|definitions]].
This overview provides easy access to the system message pages that define each gadget's description and code.",
	'gadgets-uses'      => 'Uses',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 * @author SPQRobin
 * @author Siebrand
 */
$messages['qqq'] = array(
	'gadgets-desc' => 'Short description of the Gadgets extension, shown in [[Special:Version]]. Do not translate or change links.',
	'prefs-gadgets' => 'In Gadgets extension. The name of a tab in [[Special:Preferences]] where user set their preferences for the extension.

{{Identical|Gadgets}}',
	'gadgets-prefstext' => 'In Gadgets extension. This is the explanation text displayed under the Gadgets tab in [[Special:Preferences]].',
	'gadgets' => '{{Identical|Gadgets}}',
	'gadgets-title' => '{{Identical|Gadgets}}',
	'gadgets-uses' => "This is used as a verb in third-person singular. It appears in front of a script name. Example: \"''Uses: Gadget-UTCLiveClock.js''\"

See [http://meta.wikimedia.org/wiki/Special:Gadgets Gadgets page in meta.wikimedia.org]",
);

/** Afrikaans (Afrikaans)
 * @author Anrie
 * @author Naudefj
 */
$messages['af'] = array(
	'gadgets-desc' => 'Laat gebruikers toe om [[Special:Gadgets|CSS en JavaScripts]] geriewe te aktiveer in hulle [[Special:Preferences|voorkeure]]',
	'prefs-gadgets' => 'Geriewe',
	'gadgets-prefstext' => "Hieronder is 'n lys van spesiale geriewe wat u kan aktiveer.
Hierdie geriewe maak hoofsaaklik van JavaScript gebruik. Dus moet JavaScript in u webblaaier geaktiveer wees.
Hierdie geriewe het geen invloed op hoe hierdie voorkeurbladsy vertoon nie.

Hierdie geriewe is nie deel van die MediaWiki-sagteware nie en word gewoonlik deur gebruikers op u tuiswiki ontwikkel en onderhou.
Plaaslike administrateurs kan die beskikbare geriewe by [[MediaWiki:Gadgets-definition|definisies]] en [[Special:Gadgets|beskrywings]] wysig.",
	'gadgets' => 'Geriewe',
	'gadgets-title' => 'Geriewe',
	'gadgets-pagetext' => "Hieronder is 'n lys van spesiale geriewe wat gebruikers deur hulle [[Special:Preferences|voorkeure]] kan aktiveer, soos gedefinieer in [[MediaWiki:Gadgets-definition]].
Die oorsig bied maklike toegang tot die stelselboodskapblaaie wat elke gerief se beskrywing  en kode wys.",
	'gadgets-uses' => 'Gebruik',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'prefs-gadgets' => 'ተጨማሪ መሣርያዎች',
	'gadgets-prefstext' => 'ከዚህ ታች አንዳንድ ተጨማሪ መሣርያ ወይም መኪናነት በዝርዝር ሊገኝ ይችላል። እነዚህ በደንብ እንዲሠሩ በኮምፒውተርዎ ላይ ጃቫ-ስክሪፕት እንዲኖር አስፈላጊነት ነው።

የዚህ ዊኪ መጋቢዎች [[MediaWiki:Gadgets-definition]]
እና [[Special:Gadgets]] በመጠቀም አዲስ መሣርያ ሊጨምሩ ይቻላል።',
	'gadgets' => 'ተጨማሪ መሣርያዎች',
	'gadgets-title' => 'ተጨማሪ መሣርያዎች',
	'gadgets-pagetext' => 'ተጨማሪ መሣርያዎች ወይም መኪናዎች በየዊኪ ፕሮዤ የለያያሉ።

ተጨማሪ መሣሪያዎች ለማግኘት፣ ወደ [[Special:Preferences|ምርጫዎች]] ይሂዱ።

የዚህ ገጽ መራጃ በተለይ ለመጋቢዎችና አስተዳዳሪዎች ይጠቅማል።

በዚህ {{SITENAME}} የሚገኙት ተቸማሪ መሣርያዎች እነኚህ ናቸው፦',
	'gadgets-uses' => 'የተጠቀመው ጃቫ-ስክሪፕት',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'gadgets-desc' => 'Deixa que os usuario selezionen os [[Special:Gadgets|gadgets de CSS y JavaScript]] que quieran en as suyas [[Special:Preferences|preferenzias]]',
	'prefs-gadgets' => 'Trastes',
	'gadgets-prefstext' => "Contino ye una lista de trastes espezials que puede fer serbir en a suya cuenta.
Como cuasi toz istos trastes son feitos en JavaScript, caldrá que tienga autibato JavaScript en o suyo nabegador ta que baigan bien. Pare cuenta que istos trastes no tendrán garra efeuto en ista pachina de preferenzias.

Pare cuenta tamién que istos trastes espezials no fan parte d'o software MediaWiki, y que gosan estar desembolicatos y mantenitos por usuarios d'a suya wiki local. 
Os almenistradors locals pueden editar os trastes disponibles en as pachinas de [[MediaWiki:Gadgets-definition|definizions]] y de [[Special:Gadgets|descripzions]].",
	'gadgets' => 'Trastes',
	'gadgets-title' => 'Trastes',
	'gadgets-pagetext' => "Contino ye una lista de trastes espezials que os usuarios pueden autibar en a suya [[Special:Preferences|pachina de preferenzias]], como se define en a pachina de [[MediaWiki:Gadgets-definition|definizions]].
Ista lista premite ir fazilment t'as pachinas de mensaches d'o sistema que definen a descripzión y o codigo de cada traste.",
	'gadgets-uses' => 'Fa serbir',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'gadgets-desc' => 'يسمح للمستخدمين باختيار [[Special:Gadgets|إضافات سي إس إس وجافاسكريبت]] معدلة في [[Special:Preferences|تفضيلاتهم]]',
	'prefs-gadgets' => 'الإضافات',
	'gadgets-prefstext' => 'بالأسفل قائمة بالإضافات الخاصة التي يمكن تفعيلها لحسابك.
هذه الإضافات مبنية على الأغلب على جافاسكريبت، لذا فالجافاسكريبت يجب أن تكون مفعلة في متصفحك لكي يعملوا.
لاحظ أن هذه الإضافات لن يكون لها أي تأثير على صفحة التفضيلات هذه.

أيضا لاحظ أن هذه الإضافات الخاصة ليست جزءا من برنامج ميدياويكي، وعادة يتم تطويرها وصيانتها بواسطة مستخدمين في الويكي المحلي الخاص بك.
الإداريون المحليون يمكنهم تعديل الإضافات المتوفرة باستخدام [[MediaWiki:Gadgets-definition|التعريفات]]
و [[Special:Gadgets|الوصوفات]].',
	'gadgets' => 'إضافات',
	'gadgets-title' => 'إضافات',
	'gadgets-pagetext' => 'بالأسفل قائمة بالإضافات الخاصة التي يمكن أن يقوم المستخدمون بتفعيلها على [[Special:Preferences|صفحة تفضيلاتهم]]، معرفة بواسطة [[MediaWiki:Gadgets-definition|التعريفات]].
هذا العرض يوفر دخولا سهلا لصفحات رسائل النظام التي تعرف وصف وكود كل إضافة.',
	'gadgets-uses' => 'تستخدم',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'gadgets-desc' => 'بيسمح لليوزرز انهم يختارو [[Special:Gadgets|اضافاتCSS وJavaScript]] فى [[Special:Preferences|التفضيلات]] بتاعتهم',
	'prefs-gadgets' => 'اضافات',
	'gadgets-prefstext' => 'تحت فى لستة بالضافات المخصوصة اللى انت ممكن تفعلها فى الحساب بتاعك.
الاضافات دى غالبا ما بتبقى مبينة على الجافاسكريبت،و علشان كده لازم تفعل الجافاسطريبت فى البراوزر بتاعك علشتن يشتغلو.
اعمل حسابك ان الاضافات دى مش ح يكون ليها اى تاثير على صفحة التفضيلات دى.

كمان،خد بالك ان الاضافات المخصوصة دى مش جزء من  برامج الميدياويكى ،و غالبا بيطورها و يعملها صيانة اليوزرز اللى فى الويكى المحلى بتاعك.
الادارى المحلى ممكن يعدل الاضافات الموجودة باستخدام [[MediaWiki:Gadgets-definition|التعريفات]] و [[Special:Gadgets|التوصيفات]].',
	'gadgets' => 'إضافات',
	'gadgets-title' => 'إضافات',
	'gadgets-pagetext' => 'تحت فى لستة بالاضافات المخصوصة و اللى اليوزرز ممكن يفعلوها على  [[Special:Preferences|صفحة التفضيلات]], زى ما بتعرفها [[MediaWiki:Gadgets-definition|التعريفات]].
العرض دا بيوفر دخول سهل لصفحات رسايل النظام و اللى بتعرف وصف و كود كل اضافة.',
	'gadgets-uses' => 'إستخدامات',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'gadgets-desc' => 'Permite a los usuarios seleicionar al gustu [[Special:Gadgets|accesorios CSS y JavaScript]] nes sos [[Special:Preferences|preferencies]]',
	'prefs-gadgets' => 'Accesorios',
	'gadgets-prefstext' => "Embaxo amuésase una llista de los accesorios especiales que pues activar pa la to cuenta.
Estos accesorios tán mayormente basaos en JavaScript, polo qu'has tener activáu esti nel to navegador pa que funcionen.
Date cuenta de qu'estos accesorios nun tendrán efeutu nesta páxina de preferencies.

Has decatate tamién de qu'estos accesorios especiales nun son parte del software MediaWiki, y que normalmente son
desenrollaos y manteníos por usuarios de la to wiki llocal.
Los alministradores llocales puen editar los accesorios disponibles usando les [[MediaWiki:Gadgets-definition|definiciones]] y les [[Special:Gadgets|descripciones]].",
	'gadgets' => 'Accesorios',
	'gadgets-title' => 'Accesorios',
	'gadgets-pagetext' => 'Embaxo amuésase una llista de los accesorios especiales que los usuarios puen activar na so [[Special:Preferences|páxina de preferencies]], según queden definíos poles [[MediaWiki:Gadgets-definition|definiciones]].
Esta visión xeneral proporciona un accesu fácil a les páxines de mensaxes del sistema que definen la descripción y el códigu de cada accesoriu.',
	'gadgets-uses' => 'Usa',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 */
$messages['bat-smg'] = array(
	'gadgets' => 'Rakondā',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'gadgets-desc' => 'اجازت دن کابرانء که انتخاب کنن دلواهی [[Special:Gadgets|گجت آنی سی اس اس و جاوا اسکرسپت]] ته وتی [[Special:Preferences|ترجیحات]]',
	'prefs-gadgets' => 'گجت آن',
	'gadgets' => 'گجت آن',
	'gadgets-title' => 'گجت آن',
	'gadgets-uses' => 'استفاده بیت',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author Cesco
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'gadgets-desc' => 'Дазваляе ўдзельнікам выбіраць [[Special:Gadgets|CSS і JavaScript-дадаткі]] ў сваіх [[Special:Preferences|устаноўках]]',
	'prefs-gadgets' => 'Гаджэты',
	'gadgets-prefstext' => 'Ніжэй знаходзіцца сьпіс спэцыяльных гаджэтаў, якія Вы можаце ўключыць для свайго рахунка.
Гэтыя гаджэты, пераважна, заснаваныя на JavaScript, таму Вам неабходна ўключыць JavaScript у сваім браўзэры для таго, каб яны працавалі.
Заўважце, што гэтыя гаджэты не працуюць на старонцы ўстановак.

Таксама заўважце, што гэтыя гаджэты не зьяўляюцца часткай праграмнага забесьпячэньня MediaWiki, і, звычайна, распрацоўваюцца ўдзельнікамі Вашай лякальнай вікі.
Лякальныя адміністратары маюць магчымасьць мяняць сьпіс гаджэтаў з дапамогай [[MediaWiki:Gadgets-definition|вызначэньняў]] і [[Special:Gadgets|апісаньняў]].',
	'gadgets' => 'Гаджэты',
	'gadgets-title' => 'Гаджэты',
	'gadgets-pagetext' => 'Ніжэй знаходзіцца сьпіс гаджэтаў, якія ўдзельнікі могуць уключыць у [[Special:Preferences|сваіх устаноўках]], у адпаведнасьці са сьпісам на старонцы [[MediaWiki:Gadgets-definition|вызначэньняў]].
Гэты сьпіс дазваляе лёгка атрымаць доступ да старонак сыстэмных паведамленьняў, якія вызначаюць апісаньні і крынічныя коды гаджэтаў.',
	'gadgets-uses' => 'Выкарыстаньне',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'gadgets-desc' => 'Позволява на потребителите да избират и активират [[Special:Gadgets|CSS и JavaScript джаджи]] от своите [[Special:Preferences|настройки]]',
	'prefs-gadgets' => 'Джаджи',
	'gadgets-prefstext' => 'По-долу е списъкът на специалните джаджи, които можете да активирате на своята потребителска сметка.
Тъй като почти всички джаджи са базирани на Джаваскрипт, трябва да го активирате на браузъра си, за да могат те да работят.
Имайте предвид, че тези джаджи няма да окажат влияние на тази страница с настройки.

Също така, джаджите не са част от софтуера МедияУики, и обикновено се разработват и поддържат от потребители в локалното уики. Локалните администратори могат да редактират наличните джаджи посредством [[MediaWiki:Gadgets-definition|дефинициите]] и [[Special:Gadgets|описанията]].',
	'gadgets' => 'Джаджи',
	'gadgets-title' => 'Джаджи',
	'gadgets-pagetext' => 'По-долу е списъкът на специалните джаджи, които потребителите могат да активират чрез [[Special:Preferences|страницата си с настройки]], както е указано на [[MediaWiki:Gadgets-definition]].
Този списък дава лесен достъп до страниците със системни съобщения, съдържащи описанието и кода на всяка джаджа.',
	'gadgets-uses' => 'Използва',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'gadgets-desc' => 'ব্যবহারকারীদের তাদের [[Special:Preferences|পছন্দে]] স্বনির্বাচিত [[Special:Gadgets|সিএসএস এবং জাভাস্ক্রিপ্ট গ্যাজেট]] নির্বাচনের সুযোগ দাও',
	'prefs-gadgets' => 'গ্যাজেটগুলি',
	'gadgets-prefstext' => 'নিচে কিছু বিশেষ গ্যাজেটের তালিকা দেওয়া হল, যেগুলি আপনি আপনার অ্যাকাউন্টের জন্য সক্রিয় করতে পারেন।
এই গ্যাজেটগুলি বেশিরভাগই জাভাস্ক্রিপ্ট-ভিত্তিক, তাই এগুলি কাজ করতে হলে আপনার ব্রাউজারে জাভাস্ক্রিপ্ট সক্রিয় থাকতে হবে।
লক্ষ্য করুন, এই গ্যাজেটগুলি এই পছন্দ পাতায় কোন প্রভাব ফেলবে না।

আরও লক্ষ্য করুন যে এই বিশেষ গ্যাজেটগুলি মিডিয়াউইকি সফটওয়্যারের অংশ নয়, এবং সাধারণত আপনার স্থানীয় উইকির ব্যবহারকারীরা এগুলি তৈরি করেন ও রক্ষণাবেক্ষণ করেন। স্থানীয় প্রশাসকেরা লভ্য গ্যাজেটগুলি [[MediaWiki:Gadgets-definition|সংজ্ঞা]] এবং [[Special:Gadgets|বর্ণনা]]-এর সাহায্যে সম্পাদনা করতে পারেন।',
	'gadgets' => 'গ্যাজেটগুলি',
	'gadgets-title' => 'গ্যাজেট',
	'gadgets-pagetext' => 'নিচে বিশেষ গ্যাজেটের একটি তালিকা রয়েছে, যা ব্যবহারকারী তাদের [[Special:Preferences|প্রছন্দের পাতা]] থেকে সক্রিয় করে নিতে পারবেন এবং যা [[MediaWiki:Gadgets-definition|definitions]] পাতায় সংজ্ঞায়িত রয়েছে। পর্যালোচনা সিস্টেম বার্তা পাতায় সহজ প্রবেশাধিকার দিবে, যেখানে গ্যাজেটের বর্ণনা এবং কোড রয়েছে।',
	'gadgets-uses' => 'ব্যবহারসমূহ',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'gadgets-desc' => 'Leuskel a ra an implijerien da bersonelaat [[Special:Gadgets|bitrakoù CSS ha JavaScript]] en o [[Special:Preferences|fenndibaboù]]',
	'prefs-gadgets' => 'Bitrakoù',
	'gadgets-prefstext' => "A-is ez eus ur roll eus ar bitrakoù a c'hallit gweredekaat evit ho kont.
Evit ar pep brasañ eo diazezet ar bitrakoù-se war JavaScript, setu ma rank JavaScript bezañ gweredekaet war ho merdeer evit ma'z afent en-dro.
Notennit mat ne vo efed ebet gant ar bitrakoù-se war ar bajenn penndibaboù-mañ.

Notennit ivez n'eus ket eus ar bitrakoù-se tammoù eus meziant MediaWiki; peurliesañ ez int diorroet ha trezalc'het gant implijerien war ho wiki lec'hel.
Gallout a ra ar verourien lec'hel degas cheñchamantoù er bitrakoù en ur ober gant an [[MediaWiki:Gadgets-definition|termenadurioù]] hag an [[Special:Gadgets|deskrivadurioù]].",
	'gadgets' => 'Bitrakoù',
	'gadgets-title' => 'Bitrakoù',
	'gadgets-pagetext' => "A-is ez eus ur roll eus ar bitrakoù a c'hall bezañ gweredekaet gant an implijerien war o fajenn [[Special:Preferences|penndibaboù]], evel m'eo termenet en [[MediaWiki:Gadgets-definition|termenadurioù]].
Ar sell hollek-mañ a bourchas ur moned aes d'ar pajennoù kemennadennoù reizhiad a dermen deskrivadur ha kod pep bitrak.",
	'gadgets-uses' => 'A implij',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'gadgets-desc' => 'Omogućava korisnicima da odaberu vlastite [[Special:Gadgets|CSS i JavaScript dodatke]] (gadgets) u svojim [[Special:Preferences|postavkama]]',
	'prefs-gadgets' => 'Dodaci',
	'gadgets-prefstext' => "Ovo je spisak specijalih gadgets (''dodataka'') koje možete omogućiti za Vaš korisnički račun. Ovi dodaci su najčešće bazirani na JavaScript, tako da se postavke JavaScript moraju omogućiti u Vašem web pregledniku da bi mogli raditi.
Zapamtite da ovi gadgets ne uzrokuju nikakve efekte na ovoj stranici za postavke.

Također morate obratiti pažnju da ovi specijalni dodaci nisu dio MediaWiki software-a, a obično ih prave i razvijaju korisnici na lokalnim wikijima.
Administratori mogu mijenjati dostupne gadgetse koristeći [[MediaWiki:Gadgets-definition|definicije]] i [[Special:Gadgets|opise]].",
	'gadgets' => 'Dodaci (gadgets)',
	'gadgets-title' => 'Dodaci',
	'gadgets-pagetext' => 'Ispod je spisak posebnih dodataka koje korisnici mogu omogućiti na svojim [[Special:Preferences|postavkama]], kako je to definisano u [[MediaWiki:Gadgets-definition|definicijama dodataka]].
Ovaj pregled daje jednostavan pristup sistemu stranica poruka koje definišu svaki dodatak i njihov opis i kod.',
	'gadgets-uses' => 'Upotrebe',
);

/** Catalan (Català)
 * @author Aleator
 * @author Paucabot
 * @author SMP
 * @author Vriullop
 */
$messages['ca'] = array(
	'gadgets-desc' => 'Permet als usuaris personalitzar [[Special:Gadgets|ginys CSS i JavaScript]] a les seves [[Special:Preferences|preferències]]',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => "A continuació teniu una llista de ginys especials que podeu activar al vostre compte.<br />
La majoria d'aquests ginys fan servir JavaScript, per tant l'haureu de tenir activat al vostre navegador per a que funcionin.
Tingueu en compte que aquests ginys no tenen cap efecte sobre aquesta pàgina de preferències.

Tingueu també present que aquests ginys especials no formen part del programari MediaWiki i que acostumen a estar fets i mantinguts per usuaris del vostre wiki local.<br />
Els administradors locals poden editar els ginys disponibles fent servir [[MediaWiki:Gadgets-definition|definicions]] i [[Special:Gadgets|descripcions]].",
	'gadgets' => 'Ginys',
	'gadgets-title' => 'Ginys',
	'gadgets-pagetext' => 'A continuació teniu una llista de ginys especials que els usuaris poden activar a la seva [[Special:Preferences|pàgina de preferències]], segons les [[MediaWiki:Gadgets-definition|seves definicions]].
Aquesta llista permet un fàcil accés a les pàgines del sistema que defineixen la descripció i el codi de cada giny.',
	'gadgets-uses' => 'Usa',
);

/** Sorani (Arabic script) (‫کوردی (عەرەبی)‬)
 * @author Asoxor
 */
$messages['ckb-arab'] = array(
	'prefs-gadgets' => 'ئامرازەکان',
	'gadgets' => 'ئامرازەکان',
	'gadgets-title' => 'ئامرازەکان',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'gadgets-desc' => 'Umožňuje uživatelům vybrat si [[Special:Gadgets|CSS a JavaScriptové udělátko]] ve svém [[Special:Preferences|nastavení]].',
	'prefs-gadgets' => 'Udělátka',
	'gadgets-prefstext' => 'Níže je přehled speciálních udělátek, která si můžete ve svém účtu zapnout.
Tato udělátka jsou založena převážně na JavaScriptu, takže je pro jejich funkčnost nutné mít v prohlížeči JavaScript zapnutý.
Udělátka nejsou aplikována na této stránce nastavení.

Uvědomte si také, že speciální udělátka nejsou součástí softwaru MediaWiki a&nbsp;jsou vytvářena a&nbsp;spravována uživateli této wiki.
Místní správci mohou upravovat [[MediaWiki:Gadgets-definition|definice]] a&nbsp;[[Special:Gadgets|popisy]] dostupných udělátek.',
	'gadgets' => 'Udělátka',
	'gadgets-title' => 'Udělátka',
	'gadgets-pagetext' => 'Níže je přehled speciálních udělátek, která si uživatelé mohou zapnout ve svém [[Special:Preferences|nastavení]]. Jejich seznam lze upravovat na stránce [[MediaWiki:Gadgets-definition]].
Tento přehled poskytuje jednoduchý přístup k&nbsp;systémovým hlášením, která definují zdrojový kód a&nbsp;popis každého udělátka.',
	'gadgets-uses' => 'používá',
);

/** Danish (Dansk)
 * @author Byrial
 */
$messages['da'] = array(
	'gadgets-desc' => 'Lader brugere vælge brugerdefinerede [[Special:Gadgets|CSS og JavaScript gadgets]] i deres [[Special:Preferences|indstillinger]]',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => 'Nedenstående er en liste over de gadgets som du kan aktivere for din brugerkonto.
Da disse gadgets hovedsageligt er baseret på JavaScript skal du slå JavaScript til i din browser for at få dem til at virke.
Bemærk at disse gadgets ikke vil have nogen effekt på denne side (indstillinger).

Bemærk også at disse specielle gadgets ikke er en del af MediaWiki-softwaren og at de typisk bliver vedligeholdt af brugere på din lokale wiki.
Lokale administratorer kan redigere tilgængelige gadgets med [[MediaWiki:Gadgets-definition|definitioner]] og [[Special:Gadgets|beskrivelser]].',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => 'Nedenstående er en liste med de specielle gadgets som brugere kan aktivere i deres [[Special:Preferences|indstillinger]], som defineret i [[MediaWiki:Gadgets-definition|definitionerne]].
Denne oversigtsside giver simpel adgang til de beskedsider som definerer hver gadgets beskrivelse og kode.',
	'gadgets-uses' => 'Bruger',
);

/** German (Deutsch)
 * @author Daniel Kinzler, brightbyte.de
 * @author Metalhead64
 * @author Raimond Spekking
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'gadgets-desc' => 'Ermöglicht Benutzern, in ihren [[Special:Preferences|persönlichen Einstellungen]] vordefinierte [[Special:Gadgets|CSS- und JavaScript-Helferlein]] zu aktivieren',
	'prefs-gadgets' => 'Helferlein',
	'gadgets-prefstext' => 'Liste von speziellen Helferlein die für jeden Benutzer aktiviert werden können.
Die Helferlein basieren zumeist auf JavaScript, daher muss JavaScript im Browser aktiviert sein, damit sie funktionieren.
Die Helferlein funktionieren allerdings nicht auf dieser Seite mit persönlichen Einstellungen.

Außerdem ist zu beachten, dass diese Helferlein im Allgemeinen nicht Teil von MediaWiki sind, sondern meist von
Benutzern des lokalen Wikis entwickelt und gewartet werden. Lokale Administratoren können die verfügbaren Helferlein bearbeiten. Dafür stehen die [[MediaWiki:Gadgets-definition|Definitionen]] und [[Special:Gadgets|Beschreibungen]] zur Verfügung.',
	'gadgets' => 'Helferlein',
	'gadgets-title' => 'Helferlein',
	'gadgets-pagetext' => 'Liste von speziellen Helferlein, die für jeden Benutzer in seinen [[Special:Preferences|persönlichen Einstellungen]] verfügbar sind, wie [[MediaWiki:Gadgets-definition|definiert]].
Diese Übersicht bietet direkten Zugang zu den Systemnachrichten, die die Beschreibung sowie den Programmcode jedes Helferlein enthalten.',
	'gadgets-uses' => 'Benutzt',
);

/** Zazaki (Zazaki)
 * @author Xoser
 */
$messages['diq'] = array(
	'gadgets-desc' => 'Karberan rê destur bide ke pê [[Special:Preferences|opsiyonan]] ra [[Special:Gadgets|Xacetanê CSS u JavaScriptî]] biweçî',
	'prefs-gadgets' => 'Xacetî',
	'gadgets-prefstext' => 'Cor de yew listeyê xacetanê xasî estê ke ti eşkenî xesabê xo de a bike.
Enê xecatan ser JavaScript gure kenê, aya ra ti gani browser xo de JavaScript a bike.
Ena pela opsiyonî de xacetan etki nikenê.

Enê xecatanê xasî parçê sofwarê Mediyawîkî niyo, aye ra karberanê localî enê xecetî virazeno.
Adminstorê localî eşkenê xacetî  [[MediaWiki:Gadgets-definition|definitions]] u [[Special:Gadgets|descriptions]] ra bivurne.',
	'gadgets' => 'Xacetî',
	'gadgets-title' => 'Xacetî',
	'gadgets-pagetext' => 'Cor de yew listeyê xacetanê xasî estê ke ti eşkenî [[Special:Preferences|xesabê xo]] de a bike, descripsiyon [[MediaWiki:Gadgets-definition|definitions]] de esto.
Ena descripisyon kerberanê îmkan dano ke aye meajanê sistemî ra asani cikewtê.',
	'gadgets-uses' => 'Karber',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'gadgets-desc' => 'Dowólujo wužywarjam w jich [[Special:Preferences|nastajenjach]] [[Special:Gadgets|gadgets CSS a JavaScript]] wubraś',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => 'Dołojce jo lisćina specielnych gadgetow, kótarež móžoš za swójo konto zmóžniś.
Toś te gadgety se zwětšego bazěruju na JavaScripśe, togodla musy JavaScript w twójom wobglědowaku zmóžnjony byś, aby funkcioněrowali.
Glědaj, až toś te gadgety njewustatkuju se na bok nastajenjow.

Glědaj teke, až toś te gadgety njejsu źěl softwary MediaWiki a se zwětšego wót wužywarjow na twójom lokalnem wikiju wuwijaju a wótwarduju.
Lokalne administratory mógu k dispoziciji stojece gadgety z pomocu [[MediaWiki:Gadgets-definition|definicijow ]] a [[Special:Gadgets|wopisanjow]] wobźełaś.',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => 'Dołojce jo lisćina specialnych gadgetow, kótarež wužywarje mógu w [[Special:Preferences|swójich nastajenjach]] zmóžniś, kaž w [[MediaWiki:Gadgets-definition]] definiěrowane.
Toś ten pśeglěd bitujo lažki pśistup k bokam systemowych powěsćow, kótarež wopisanje a kod gadgeta definěruju.',
	'gadgets-uses' => 'Wužywa',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Dead3y3
 * @author ZaDiak
 */
$messages['el'] = array(
	'gadgets-desc' => 'Επιτρέπει στους χρήστες να διαλέξουν [[Special:Gadgets|CSS και JavaScript συσκευές]] στις [[Special:Preferences|προτιμήσεις]] τους',
	'prefs-gadgets' => 'Ειδικές επιλογές',
	'gadgets-prefstext' => 'Ακολουθεί μια λίστα με ειδικές επιλογές που μπορείτε να ενεργοποιήσειτε για το λογαριασμό σας.
Αυτές οι επιλογές είναι βασισμένες κυρίως σε JavaScript, οπότε αυτή θα πρέπει να ενεργοποιηθεί στον φυλλομετρητή σας για να δουλέψουν.
Σημειώστε ότι οι επιλογές αυτές δεν θα έχουν καμία επίδραση σε αυτή τη σελίδα προτιμήσεων.

Επίσης σημειώστε ότι αυτές οι ειδικές επιλογές δεν είναι μέρος του λογισμικού MediaWiki, και συνήθως αναπτύσσονται και συντηρούνται από χρήστες στο τοπικό σας wiki.
Οι τοπικοί διαχειριστές μπορούν να επεξεργαστούν τις διαθέσιμες επιλογές χρησιμοποιώντας τις σελίδες [[MediaWiki:Gadgets-definition]] και [[Special:Gadgets]].',
	'gadgets' => 'Ειδικές επιλογές',
	'gadgets-title' => 'Συσκευές',
	'gadgets-pagetext' => 'Παρακάτω βρίσκεται ένας κατάλογος με τις ειδικές λειτουργίες τις οποίες οι χρήστες μπορούν να ενεργοποιήσουν στη [[Special:Preferences|σελίδα προτιμήσεών]] τους, όπως ορίζεται από τη σελίδα [[MediaWiki:Gadgets-definition|ορισμών]].<br />
Αυτή η επισκόπηση παρέχει εύκολη πρόσβαση στις σελίδες μηνυμάτων του συστήματος που ορίζουν την περιγραφή και τον κώδικα κάθε λειτουργίας.',
	'gadgets-uses' => 'Χρήσεις',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'gadgets-desc' => 'Permesas al uzantoj elekti proprajn [[Special:Gadgets|CSS kaj JavaScript aldonaĵojn]] en ties [[Special:Preferences|preferoj]].',
	'prefs-gadgets' => 'Aldonaĵoj',
	'gadgets-prefstext' => 'Jen listo de specialaj aldonaĵoj kiujn vi povas aktivigi por via uzulkonto.
Plej multaj el ili baziĝas sur Ĵavaskriptoj, sekve Ĵavaskripto nepre estu aktivigita por ke ili funkciu. 
Notu ke tiuj aldonaĵoj ne efikos sur viaj preferoj. 

Notu ankaŭ ke ili ne estas parto de la programaro MediaWiki, kaj estas kutime evoluigitaj kaj prizorgataj de uzuloj sur via loka vikio.
Lokaj administrantoj povas redakti liston de haveblaj aldonaĵoj per [[MediaWiki:Gadgets-definition|difinoj]] kaj [[Special:Gadgets|priskriboj]].',
	'gadgets' => 'Aldonaĵoj',
	'gadgets-title' => 'Aldonaĵoj',
	'gadgets-pagetext' => 'Jen listo da specialaj aldonaĵoj kiujn uzuloj povas aktivigi en [[Special:Preferences|siaj preferoj]], kiel difinite en [[MediaWiki:Gadgets-definition|difinoj]]. 
Ĉi tiu superrigardo provizas facilan aliron al la sistemaj mesaĝoj kiuj difinas la priskribon kaj la kodon de ĉiuj aldonaĵoj.',
	'gadgets-uses' => 'uzas',
);

/** Spanish (Español)
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'gadgets-desc' => 'Permite a los usuarios seleccionar [[Special:Gadgets|artilugios de CSS y JavaScript]] en sus [[Special:Preferences|preferencias]].',
	'prefs-gadgets' => 'Artilugios',
	'gadgets-prefstext' => "Debajo hay una lista de artilugios que puedes activar a tu gusto. Ten en cuenta que la mayoría de ellos utilizan JavaScript para funcionar, así que debes tenerlo activado en tu explorador si quieres que los artilugios que actives funcionen.

Ten en cuenta también que estos complementos no forman parte del software MediaWiki, y están desarrollados por usuarios de este wiki.

Los administradores pueden editar los artilugios que están disponibles en las páginas [[MediaWiki:Gadgets-definition]] y [[Special:Gadgets]]. 

'''Los artilugios no tienen efecto en esta página.'''",
	'gadgets' => 'Artilugios',
	'gadgets-title' => 'Artilugios',
	'gadgets-pagetext' => 'Debajo hay una lista de artilugios especiales que los usuarios pueden activar en sus [[Special:Preferences|preferencias]], según la [[MediaWiki:Gadgets-definition|lista de definición de artilugios]]. Esta vista provee un acceso fácil a la páginas de mensajes del sistema que definen la descripción y el código de cada artilugio.',
	'gadgets-uses' => 'Usos',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'gadgets-desc' => 'Võimaldab kasutajal [[Special:Preferences|eelistuste leheküljel]] erinevaid [[Special:Gadgets|CSS- ja JavaScript-tööriistu]] valida.',
	'prefs-gadgets' => 'Tööriistad',
	'gadgets-prefstext' => 'Allpool on nimekiri eririistadest, mida kasutajad saavad oma konto jaoks sisse lülitada.
Enamasti põhinevad need riistad JavaScriptil, seega peab nende töötamiseks sinu veebilehitsejas JavaScript lubatud olema.
Pane tähele, et need riistad ei mõjuta kuidagi seda eelistuste lehekülge.

Samuti pane tähele, et need eririistad ei ole osa MediaWiki tarkvarast ja on tavaliselt arendatud ja ülalpeetud sinu kohalikus vikis.
Kohalikud ülemad saavad olemasolevaid riistu muuta [[MediaWiki:Gadgets-definition|määratluste]] ja [[Special:Gadgets|kirjelduste]] abil.',
	'gadgets' => 'Tööriistad',
	'gadgets-title' => 'Tööriistad',
	'gadgets-pagetext' => 'Allpool on nimekiri eririistadest, mida kasutajad saavad oma [[Special:Preferences|eelistuste leheküljel]] sisse lülitada, nii nagu [[MediaWiki:Gadgets-definition|määratlustes]] määratletud. See ülevaade võimaldab kergesti ligi pääseda süsteemi sõnumilehekülgedele, milles on iga riista kirjeldus ja kood.',
	'gadgets-uses' => 'Kasutab',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Inorbez
 * @author Unai Fdz. de Betoño
 */
$messages['eu'] = array(
	'prefs-gadgets' => 'Gadgetak',
	'gadgets-prefstext' => 'Zure kontuan erabili ditzakezun gadgeten zerrenda bat agertzen da behean.
JavaScript-en oinarritzen dira gehienbat gadget hauek; beraz, funtzionatzeko zure nabigatzailean JavaScript gaituta egon behar da.
Kontuan izan gadget hauek ez dutela eraginik izango hobespen orri honetan.

Kontuan izan baita gadget berezi hauek ez direla MediaWiki softwarearen zati bat. Gehienetan guneko wikietako garatzaileek sortu eta mantentzen dituzte.
Administratzaileek [[MediaWiki:Gadgets-definition|definizioak]] eta [[Special:Gadgets|deskribapenak]] erabiliz aldatu dezakete eskuragarri dauden gadgetak.',
	'gadgets' => 'Gadgetak',
	'gadgets-title' => 'Gadgetak',
	'gadgets-pagetext' => 'Erabiltzaile bakoitzak bere [[Special:Preferences|hobespen orrian]] erabili ditzakeen gadgeten zerrenda bat agertzen da behean, [[MediaWiki:Gadgets-definition|definizioek]] zehaztu bezala.
Ikuspegi orokor honek gadget bakoitza definitzen duen deskribapen eta kode orrietarako lotura errazak eskaintzen ditu.',
	'gadgets-uses' => 'Erabilerak',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'gadgets-uses' => 'Usus',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'gadgets-desc' => 'به کاربرها امکان انتخاب ابزارهای شخصی CSS و JavaScript را از طریق صفحهٔ [[Special:Preferences|ترجیحات]] می‌دهد',
	'prefs-gadgets' => 'ابزارها',
	'gadgets-prefstext' => 'در زیر فهرستی از ابزارهای ویژه‌ای که می‌توانید برای حساب کاربری‌تان فعال کنید را می‌بینید.
این ابزارها در بیشتر موارد مبتنی بر جاوااسکریپت هستند، پس برای استفاده از آن‌ها باید جاوااسکرپیت را در مرورگر خودتان فعال کنید.
توجه کنید که این ابزارها نمی‌توانند صفحهٔ ترجیحات را تغییر دهند.

دقت داشته باشد که این ابزارها جزئی از نرم‌افزار مدیاویکی نیستند، و معمولاً توسط کاربران هر ویکی ساخته و نگهداری می‌شوند.
مدیران هر ویکی می‌توانند با استفاده از صفحه‌های [[MediaWiki:Gadgets-definition|تعاریف]] و [[Special:Gadgets|توضیحات]] به ویرایش ابزارها بپردازند.',
	'gadgets' => 'ابزارها',
	'gadgets-title' => 'ابزارها',
	'gadgets-pagetext' => 'در زیر فهرستی از ابزارهای ویژه‌ای که کاربران می‌توانند از طریق [[Special:Preferences|صفحهٔ ترجیحاتشان]] فعال کنند می‌بینید، که مطابق آن چه است که در صفحهٔ [[MediaWiki:Gadgets-definition|تعاریف]] تعریف شده‌است.
این خلاصه کمک می‌کند که به صفحه‌های پیغام سیستمی که توضیحات و کد هر ابزار را شامل می‌شوند به راحتی دست پیدا کنید.',
	'gadgets-uses' => 'برنامه',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 */
$messages['fi'] = array(
	'gadgets-desc' => 'Tarjoaa mahdollisuuden käyttäjille ottaa käyttöön [[Special:Gadgets|määritettyjä CSS- ja JavaScript-pienoisohjelmia]] omista [[Special:Preferences|asetuksistaan]].',
	'prefs-gadgets' => 'Pienoisohjelmat',
	'gadgets-prefstext' => 'Alla on lista pienoisohjelmista, joita käyttäjät voivat ottaa käyttöön. Nämä pienoisohjelmat pohjautuvat usein JavaScriptiin, joten toimiakseen selaimessasi pitää olla JavaScript käytössä.

Huomio myös, että nämä pienoisohjelmat eivät ole osa MediaWiki-ohjelmistoa – tavallisesti niitä kehittävät ja ylläpitävät paikallisen wikin käyttäjät. Paikalliset ylläpitäjät voivat muokata saatavilla olevia pienoisohjelmia [[MediaWiki:Gadgets-definition|määrityssivulla]] ja [[Special:Gadgets|kuvauksista]].',
	'gadgets' => 'Pienoisohjelmat',
	'gadgets-title' => 'Pienoisohjelmat',
	'gadgets-pagetext' => 'Alla on lista pienoisohjelmista, joita käyttäjät voivat ottaa käyttöön [[Special:Preferences|asetussivulta]]. Pienoisohjelmat määritetään [[MediaWiki:Gadgets-definition|täältä]].

Tämä lista antaa helpon pääsyn järjestelmäviesteihin, jotka sisältävät pienoisohjelmien kuvauksen ja koodin.',
	'gadgets-uses' => 'Käyttää',
);

/** French (Français)
 * @author Delhovlyn
 * @author Grondin
 * @author IAlex
 * @author Meno25
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 * @author Zetud
 */
$messages['fr'] = array(
	'gadgets-desc' => 'Permet aux utilisateurs de choisir des [[Special:Gadgets|gadgets CSS et Javascripts]] personnalisés dans leurs [[Special:Preferences|préférences]]',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => "Voici une liste de gadgets que vous pouvez activer pour votre compte.
Ils font appel à JavaScript, lequel doit donc être activé sur votre navigateur Web pour qu'ils fonctionnent.
Notez que ces gadgets n'ont aucun effet sur cette page des préférences.

Notez aussi que ces gadgets spéciaux ne font nullement partie du logiciel MediaWiki, et qu'ils sont généralement développés et maintenus par des utilisateurs sur votre wiki local.
Les administrateurs locaux peuvent modifier les gadgets disponibles en utilisant les [[MediaWiki:Gadgets-definition|définitions]] et les [[Special:Gadgets|descriptions]].",
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => "Voici une liste de gadgets que les utilisateurs peuvent activer dans leur [[Special:Preferences|page de préférences]], tel que défini dans les [[MediaWiki:Gadgets-definition|définitions]].
Cette vue d'ensemble donne un accès rapide aux pages de messages système qui définissent la description et le code de chaque gadget.",
	'gadgets-uses' => 'Utilise',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'gadgets-desc' => 'Pèrmèt ux utilisators de chouèsir des [[Special:Gadgets|outils CSS et JavaScript]] pèrsonalisâs dens lors [[Special:Preferences|prèferences]].',
	'prefs-gadgets' => 'Outils',
	'gadgets-prefstext' => 'Vê-que una lista d’outils que vos pouede activar por voutron compto.
Font apèl a JavaScript, que dêt vêr étre activâ sur voutron navigator por que fonccionont.
Notâd que celos outils ont gins de rèsultat sur ceta pâge de prèferences.

Notâd asse-ben que celos outils spèciâls sont pas du tot avouéc la programeria MediaWiki, et pués que sont en g·ènèral dèvelopâs et mantegnus per des utilisators sur voutron vouiqui local.
Los administrators locals pôvont changiér los outils disponiblos en utilisent les [[MediaWiki:Gadgets-definition|dèfinicions]] et les [[Special:Gadgets|dèscripcions]].',
	'gadgets' => 'Outils',
	'gadgets-title' => 'Outils',
	'gadgets-pagetext' => 'Vê-que una lista d’outils que los utilisators pôvont activar dens lor [[Special:Preferences|pâge de prèferences]], coment dèfeni dens les [[MediaWiki:Gadgets-definition|dèfinicions]].
Ceti apèrçu balye un accès vito fêt a les pâges de mèssâjos sistèmo que dèfenéssont la dèscripcion et lo code de châque outil.',
	'gadgets-uses' => 'Utilise',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'gadgets-desc' => 'Deixa que os usuarios seleccionen [[Special:Gadgets|trebellos CSS e JavaScript]] nas súas [[Special:Preferences|preferencias]]',
	'prefs-gadgets' => 'Trebellos',
	'gadgets-prefstext' => 'Embaixo hai unha lista de trebellos especiais que pode activar para a súa conta.
A maioría destes trebellos baséanse no JavaScript, así que ten que ter o JavaScript activado no seu navegador para que funcionen.
Teña en conta que estes trebellos non funcionarán nesta páxina de preferencias.

Teña tamén en conta que estes trebellos especiais non son parte do software de MediaWiki e que os crean e manteñen os usuarios no seu wiki local. Os administradores locais poden editar os trebellos dispoñíbeis mediante [[MediaWiki:Gadgets-definition|definicións]] e [[Special:Gadgets|descricións]].',
	'gadgets' => 'Trebellos',
	'gadgets-title' => 'Trebellos',
	'gadgets-pagetext' => 'Embaixo hai unha lista dos trebellos especiais que os usuarios poden habilitar na súa páxina de preferencias, tal e como se describe nas [[MediaWiki:Gadgets-definition|definicións]].
Este panorama xeral é de doado acceso ao sistema das páxinas de mensaxes que define cada descrición e código dos trebellos.',
	'gadgets-uses' => 'Usa',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'prefs-gadgets' => 'Μηχανήματα',
	'gadgets' => 'Μηχανήματα',
	'gadgets-title' => 'Μηχανήματα',
	'gadgets-uses' => 'Χρήσεις',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'gadgets-desc' => 'Macht s Benutzer megli, in ihre [[Special:Preferences|persenlige Yystellige]] vordefinierti [[Special:Gadgets|CSS- und JavaScript-Gadgets]] z aktiviere',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => 'Unter git s e Lischt vu spezielle Gadgets, wu for jede Benutzer chenne aktiviert wäre.
D Gadgets basiere zmeischt uf JavaScript, wäge däm muess JavaScript im Browser aktiviert syy, ass si funktioniere.
D Gadgets funktionieren aber nit uf däre Syte mit persenlige Yystellige.

Mer muess au Acht gee, ass die Gadgets im Allgmeinen nit Teil vu MediaWiki sin, sundern meischt vu
Benutzer vum lokale Wikis entwicklet un gwartet wäre. Lokali Wiki-Ammanne chenne d Lischt vu dr verfiegbare Gadgets iber d Syte [[MediaWiki:Gadgets-definition]] un [[Special:Gadgets]] bearbeite',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => 'Lischt vu spezielle Gadgets, wu fir jede Benutzer in syyne [[Special:Preferences|persenlige Yystellige]] verfiegbar sin, wie s [[MediaWiki:Gadgets-definition|definiert]] isch.
Die Ibersicht bietet e direkte Zuegang zue dr Syschtemnochrichte, wu d Bschryybig un dr Programmcode vu jedem Gadget din sin.',
	'gadgets-uses' => 'Bruucht',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 */
$messages['gu'] = array(
	'prefs-gadgets' => 'યંત્રો/સાધનો',
	'gadgets-prefstext' => "નીચે એવા વિશેષ સાધનોની યાદી નીચે આપી છે જે તમે તમારા ખાતામાં સક્રિય કરી શકો છો.
આ સાધનો મહદ્ અંશે જાવા સ્ક્રિપ્ટ આધારિત છે માટે તે યોગ્ય રીતે કામ કરે તે માટે આપના બ્રાઉઝરમાં જાવા સ્ક્રિપ્ટ સક્રિય (ઍનેબલ) કરેલી હોવી જરૂરી છે.
એ બાબત નોંધમાં લેશો કે આ સાધનોની અસર તમારા 'મારી પસંદ'ના પાના ઉપર થશે નહી.

એ વાત પણ ધ્યાનમાં રાખશો કે આ વિશેષ સાધનો મિડિયાવિકિ સૉફ્ટવેરનો ભાગ નથી, સામાન્ય રીતે તે આપના સ્થાનીક વિકિના સભ્યો દ્વારા વિકસાવવામાં આવ્યા હોય છે અને તેઓજ તેનું ધ્યાન રાખે છે. સ્થાનિક પ્રબંધકો [[MediaWiki:Gadgets-definition|વ્યાખ્યા]] અને [[Special:Gadgets|વર્ણન]]નો ઉપયોગ કરીને આ સાધનોમાં ફેરફાર કરી શકે છે.",
	'gadgets' => 'યંત્રો/સાધનો',
	'gadgets-title' => 'યંત્રો/સાધનો',
	'gadgets-pagetext' => 'નીચે એવા વિશેષ સાધનોની યાદી આપી છે જેમાથી જરૂરીયાત પ્રમાણેના સાધનો સભ્ય તેમના [[Special:Preferences|મારી પસંદ]] પાના ઉપર સક્રિય કરી શકે છે ([[MediaWiki:Gadgets-definition|વ્યાખ્યા]]મા વર્ણવ્યા મુજબ).

આ નિરિક્ષણથી સહેલાઇથી સિસ્ટમ સંદેશા વાળા પાના ખોલી શકશો જ્યાં દરેક સાધનનું વર્ણન અને તેનો કોડ આપેલો છે.',
	'gadgets-uses' => 'ઉપયોગો',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'gadgets-desc' => 'אפשרות למשתמשים לבחור [[Special:Gadgets|סקריפטים בקוד JavaScript וסגנונות בקוד CSS]] ב[[Special:Preferences|העדפות]] שלהם',
	'prefs-gadgets' => 'סקריפטים',
	'gadgets-prefstext' => 'להלן רשימה של סקריפטים שתוכלו להתקין בחשבון שלכם.
הסקריפטים מבוססים ברובם על שפת JavaScript, ולכן יש לאפשר אותה בדפדפן כדי שהם יעבדו.
שימו לב שלא תהיה לסקריפטים כל השפעה על דף ההעדפות הזה.

כמו כן, הסקריפטים אינם חלק מתוכנת מדיה־ויקי, והם בדרך כלל מפותחים ומתוחזקים על ידי משתמשים
באתר זה. מפעילי המערכת יכולים לערוך את רשימת הסקריפטים האפשריים תוך שימוש ב[[MediaWiki:Gadgets-definition|הודעת המערכת]] ו[[Special:Gadgets|הדף המיוחד]] המתאימים.',
	'gadgets' => 'סקריפטים',
	'gadgets-title' => 'סקריפטים',
	'gadgets-pagetext' => 'זוהי רשימה של סקריפטים שמשתמשים יכולים להתקין באמצעות [[Special:Preferences|דף ההעדפות]] שלהם, כפי שהוגדרו ב[[MediaWiki:Gadgets-definition|הודעת המערכת המתאימה]].
מכאן ניתן לגשת בקלות לדפי הודעות המערכת שמגדירים את התיאור והקוד של כל סקריפט.',
	'gadgets-uses' => 'משתמש בדפים',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'gadgets-desc' => 'सदस्यों को उनकी [[Special:Preferences|वरीयताओं]] में से चुनिंदा [[Special:Gadgets|CSS और जावालिपि जुगत]] चुनने दो।',
	'prefs-gadgets' => 'उपकरण (गैज़ेट)',
	'gadgets-prefstext' => 'नीचे विशेष जुगतों की सूची दी गई है, जो कि आप अपने खाते में सक्षम कर सकते हैं।
ये जुगत अधिकांशत: जावालिपि पर आधारित है, इसलिए इन्हें कार्यशील कराने के लिए आप अपने ब्राउजर में जावालिपि को सक्षम कर लें।
ध्यान दें कि इन जुगतों से आपके वरीयता पृष्ठ पर कोई असर नहीं होगा।

यह भी ध्यान दें कि ये विशेष जुगत मीडियाविकी सॉफ्टवेयर का भाग नहीं हैं, और प्राय: सदस्यों द्वारा उनकी स्थानीय विकी पर विकसित एवं अनुरक्षित किए जाते हैं।
स्थानीय प्रशासक [[MediaWiki:Gadgets-definition]] एवं [[Special:Gadgets]] प्रयोग करके उपलब्ध जुगतों को संपादित कर सकते हैं।',
	'gadgets' => 'उपकरण',
	'gadgets-title' => 'उपकरण',
	'gadgets-pagetext' => 'नीचे विशेष जुगतों कि सूची दी गई है, जिन्हें सदस्य [[MediaWiki:Gadgets-definition]] की परिभाषा के अनुसार, अपने वरीयता पृष्ठ में सक्षम कर सकते हैं।
यह समीक्षा तंत्र संदेश पृष्ठों तक पहुँचने का आसान मार्ग प्रदान करती है, जो की प्रत्येक जुगत के वर्णन एवं कूट भाषा को परिभाषित करते हैं।',
	'gadgets-uses' => 'उपयोग',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'gadgets-desc' => 'Omogućava suradnicama biranje osobnih [[Special:Gadgets|CSS i JavaScript dodataka]] u svojim [[Special:Preferences|postavkama]]',
	'prefs-gadgets' => 'Dodaci',
	'gadgets-prefstext' => 'Slijedi popis posebnih dodataka koje možete omogućiti.
One su većinom napisane u JavaScriptu, stoga JavaScript mora biti omogućen u vašem web pregledniku da bi dodaci radili.
Nijedan dodatak nema učinka na ovu stranicu s postavkama.

Ovi posebni dodaci nisu dio MediaWiki softvera, najčešće su razvijane i održavane od suradnika na lokalnom wikiju.
Lokalni administratori mogu uređivati dostupne dodatke putem [[MediaWiki:Gadgets-definition|definicija]] i [[Special:Gadgets|opisa]].',
	'gadgets' => 'Dodaci',
	'gadgets-title' => 'Dodaci',
	'gadgets-pagetext' => 'Slijedi popis posebnih JavaScript dodataka koje suradnici mogu omogućiti u svojim [[Special:Preferences|postavkama]], kako je definirano stranicom [[MediaWiki:Gadgets-definition|definicija]].
Ovaj pregled omogućava lak pristup porukama sustava koje opisuju dodatke i njihov kod.',
	'gadgets-uses' => 'Koristi',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'gadgets-desc' => 'Zmóžnja wužiwarjam swójske [[Special:Gadgets|přisłuški za CSS a JavaScript]] w jich [[Special:Preferences|nastajenjach]] wubrać',
	'prefs-gadgets' => 'Specialne funkcije',
	'gadgets-prefstext' => 'Deleka je lisćina specialnych funkcijow, kotrež móžeš za swoje wužiwarske konto zmóžnić. Tute specialne funkcije zwjetša na JavaScripće bazěruja, tohodla dyrbi JavaScript we wobhladowaku zmóžnjeny być, zo bychu fungowali.
Wobkedźbuj tež, zo so tute specialne funkcije na tutu stronu z wosobinskimi nastajenjemi njewuskutkuja.

Nimo toho wobkedźbuj, zo tute specialne funkcije dźěl softwary MediaWiki njejsu a so zwjetša wot wužiwarjow na jich lokalnym wikiju wuwiwaja a wothladuja. Lokalni administratorojo móža lisćinu k dispoziciji stejacych specialnych funkcijow z pomocu [[MediaWiki:Gadgets-definition|definicijow]] a [[Special:Gadgets|wopisanjow]] wobdźěłać.',
	'gadgets' => 'Specialne funkcije',
	'gadgets-title' => 'Specialne funkcije',
	'gadgets-pagetext' => 'Deleka je lisćina specialnych funkcijow, kotrež wužiwarjo móža na swojej [[Special:Preferences|stronje nastajenjow]] zmóžnić, kaž přez [[MediaWiki:Gadgets-definition|definicije]] definowane.
Tutón přehlad skići lochki přistup k systemowym zdźělenkam, kotrež wopisanje a kod kóždeje specialneje funkcije definuja.',
	'gadgets-uses' => 'Wužiwa',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Tgr
 */
$messages['hu'] = array(
	'gadgets-desc' => 'A felhasználók saját [[Special:Gadgets|CSS és JavaScript eszközöket]] választhatnak ki a [[Special:Preferences|beállításaiknál]]',
	'prefs-gadgets' => 'Segédeszközök',
	'gadgets-prefstext' => 'Itt látható a fiókod számára engedélyezett segédeszközöket.
Legtöbbjük JavaScriptet használ, így ezt engedélyezned kell a böngésződben, hogy működjenek.
A segédeszközök nem működnek ezen a beállításoldalon, így probléma esetén ki tudod őket kapcsolni.

Ezek az eszközök nem részei a MediaWiki szoftvernek, általában a wiki felhasználói tartják karban őket.
Az adminisztrátorok a [[MediaWiki:Gadgets-definition|definíciókat]] és a [[Special:Gadgets|leírásokat]] tartalmazó lapok segítségével tudják módosítani az elérhető eszközök listáját.',
	'gadgets' => 'Segédeszközök',
	'gadgets-title' => 'Segédeszközök',
	'gadgets-pagetext' => 'Itt látható azon segédeszközök listája, amiket a felhasználók bekapcsolhatnak a beállításaiknál. A lista a [[MediaWiki:Gadgets-definition|definíciókat]] tartalmazó lapon módosítható.
Ez az áttekintő lap egyszerű hozzáférést nyúlt az eszközök kódját, illetve leírását tartalmazó rendszerüzenet-lapokhoz.',
	'gadgets-uses' => 'Kód',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'gadgets-desc' => 'Permitte que usatores selige [[Special:Gadgets|gadgets CSS e JavaScript]] personalisate in lor [[Special:Preferences|preferentias]]',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => 'Infra es un lista de gadgets special que tu pote activar in tu conto.
Iste gadgets se basa pro le major parte in JavaScript, ergo JavaScript debe esser active in tu navigator pro permitter que illos functiona.
Nota que iste gadgets non habera effecto in iste pagina de preferentias.

Nota etiam que iste gadgets special non face parte del software de MediaWiki, e es normalmente disveloppate e mantenite per usatores in tu wiki local.
Le administratores local pote modificar le gadgets disponibile per medio de [[MediaWiki:Gadgets-definition|definitiones]] e [[Special:Gadgets|descriptiones]].',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => 'Infra es un lista de gadgets special que le usatores pote activar in lor [[Special:Preferences|paginas de preferentias]], secundo le [[MediaWiki:Gadgets-definition|definitiones]].
Iste supervista permitte le accesso commode al paginas de messages de systema que defini le description e codice de cata gadget.',
	'gadgets-uses' => 'Usa',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'gadgets-desc' => 'Memungkinkan pengguna memilih [[Special:Gadgets|gadget CSS dan JavaScript]] melalui [[Special:Preferences|preferensi]] mereka',
	'prefs-gadgets' => 'Gadget',
	'gadgets-prefstext' => 'Berikut adalah daftar gadget istimewa yang dapat Anda aktifkan untuk akun Anda. Gadget-gadget tersebut sebagian besar berbasis JavaScript sehingga Anda harus mengaktifkan JavaScript pada penjelajah Anda untuk dapat menjalankannya. Perhatikan bahwa gadget-gadget tersebut tak memiliki pengaruh terhadap halaman preferensi ini.

Juga perhatikan bahwa gadget istimewa ini bukanlah bagian dari perangkat lunak MediaWiki dan biasanya dikembangkan dan dipelihara oleh pengguna-pengguna di wiki lokal Anda. Pengurus lokal dapat menyunting gadget yang tersedia melalui [[MediaWiki:Gadgets-definition]] dan [[Special:Gadgets]].',
	'gadgets' => 'Gadget',
	'gadgets-title' => 'Gadget',
	'gadgets-pagetext' => 'Berikut adalah daftar gadget istimewa yang dapat diaktifkan pengguna melalui halaman preferensi mereka sebagaimana didefinisikan oleh [[MediaWiki:Gadgets-definition]]. Tinjauan berikut memberikan kemudahan akses ke dalam halaman pesan sistem yang mendefinisikan deskripsi dan kode masing-masing gadget.',
	'gadgets-uses' => 'Penggunaan',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'gadgets-uses' => 'Ol uzas',
);

/** Icelandic (Íslenska)
 * @author Jóna Þórunn
 */
$messages['is'] = array(
	'gadgets-desc' => 'Gerir notendum kleift að velja [[Special:Gadgets|CSS og JavaScript-forrit]] í [[Special:Preferences|stillingum sínum]]',
	'prefs-gadgets' => 'Smáforrit',
	'gadgets-prefstext' => 'Eftirfarandi er listi yfir smáforrit sem þú getur notað á notandareikningi þínum. Þessi forrit eru að mestu byggð á JavaScript svo vafrinn þarf að styðja JavaScript til að þau virki. Athugaðu einnig að forritin hafa engin áhrif á stillingasíðunni.

Forritin eru ekki hluti af MediaWiki-hugbúnaðinum heldur eru skrifuð og viðhaldin af notendum á þessu wiki-verkefni. Möppudýr geta breytt forritunum á [[MediaWiki:Gadgets-definition]] og [[Special:Gadgets]].',
	'gadgets' => 'Smáforrit',
	'gadgets-title' => 'Smáforrit',
	'gadgets-uses' => 'Notar',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 * @author Nemo bis
 */
$messages['it'] = array(
	'gadgets-desc' => 'Consente agli utenti di selezionare [[Special:Gadgets|accessori CSS e JavaScript]] nelle proprie [[Special:Preferences|preferenze]]',
	'prefs-gadgets' => 'Accessori',
	'gadgets-prefstext' => "Di seguito viene presentata una lista di accessori speciali (''gadget'') che è possibile abilitare per il proprio account.
La maggior parte di questi accessori è basata su JavaScript, è quindi necessario abilitare JavaScript nel proprio browser perché funzionino correttamente. Si noti che gli accessori non hanno alcun effetto in questa pagina di preferenze.

Inoltre, si noti che questi accessori speciali non sono compresi nel software MediaWiki e vengono di solito realizzati e gestiti dagli utenti di ciascun sito wiki. Gli amministratori del sito possono modificare la lista degli accessori disponibili tramite le pagine delle [[MediaWiki:Gadgets-definition|definizioni]] e delle [[Special:Gadgets|descrizioni]].",
	'gadgets' => 'Accessori',
	'gadgets-title' => 'Accessori',
	'gadgets-pagetext' => "Di seguito sono elencati gli accessori (''gadget'') che gli utenti possono abilitare sulla propria pagina delle [[Special:Preferences|preferenze]], seguendo le [[MediaWiki:Gadgets-definition|definizioni]]. Questa panoramica fornisce un comodo meccanismo per accedere ai messaggi di sistema nei quali sono definiti la descrizione e il codice di ciascun accessorio.",
	'gadgets-uses' => 'Utilizza',
);

/** Japanese (日本語)
 * @author Aotake
 * @author JtFuruhata
 * @author Mzm5zbC3
 */
$messages['ja'] = array(
	'gadgets-desc' => '利用者が[[Special:Gadgets|CSSやJavaScriptのカスタムガジェット]]を[[Special:Preferences|{{int:preferences}}]]で選択できるようにする',
	'prefs-gadgets' => 'ガジェット',
	'gadgets-prefstext' => '下記はあなたのアカウントで利用できるガジェットの一覧です。これらのガジェットはほとんどがJavaScriptベースのため、動作させるにはブラウザ設定でJavaScriptを有効にする必要があります。なお、{{int:preferences}}ページ上では動作しません。

また、これらのガジェットは MediaWiki ソフトウェアの一部ではなく、開発とメンテナンスは通常ウィキ毎の利用者によって行われていることにも注意してください。管理者は[[MediaWiki:Gadgets-definition|ガジェットの定義]]や[[Special:Gadgets|ガジェットの説明]]から利用可能なガジェットを編集できます。',
	'gadgets' => 'ガジェット',
	'gadgets-title' => 'ガジェット',
	'gadgets-pagetext' => '以下は、[[MediaWiki:Gadgets-definition]] 上で定義された、利用者が[[Special:Preferences|{{int:preferences}}]]にて利用可能にすることができるガジェットの一覧です。この一覧はガジェットの説明やプログラムコードを定義しているシステムメッセージページへの簡単なアクセスも提供します。',
	'gadgets-uses' => '利用するファイル',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'prefs-gadgets' => 'Gøreter',
	'gadgets-prefstext' => 'Nedenstående er en liste over de gadgets som du kan aktivere for din brugerkonto. Da disse gadgets hovedsageligt er baseret på JavaScript skal du slå JavaScript til i din browser for at få dem til at virke. Bemærk at disse gadgets ikke vil have nogen effekt på denne side (indstillinger).

Bemærk også at disse specielle gadgets ikke er en del af MediaWiki-softwaren og at de typisk bliver vedligeholdt af brugere på din lokale wiki. Lokale administratorer kan redigere tilgængelige gadgets med [[MediaWiki:Gadgets-definition]] og [[Special:Gadgets]].',
	'gadgets' => 'Gøreter',
	'gadgets-title' => 'Gøreter',
	'gadgets-pagetext' => 'Nedenstående er en liste med de specielle gadgets som brugere kan aktivere i deres indstillinger som defineret i [[MediaWiki:Gadgets-definition]]. Denne oversigtsside giver simpel adgang til de systembeskeder som definerer hver gadgets beskrivelse og kode.',
	'gadgets-uses' => 'Brugere',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'gadgets-desc' => 'Marengaké para panganggo milih [[Special:Gadgets|gadget CSS lan JavaScript]] ngliwati [[Special:Preferences|préferènsi]] dhéwé-dhéwé.',
	'prefs-gadgets' => 'Gadget',
	'gadgets-prefstext' => 'Ing ngisor iki daftar gadget astaméwa sing bisa panjenangan aktifaké kanggo rékening panjenengan. Gadget-gadget iki sabagéyan gedhé adhedhasar JavaScript dadi panjenengan kudu ngaktifaké JavaScript ing panjlajah wèb panjenengan supaya bisa nglakokaké. 
Mangga diwigatèkaké yèn gadget-gadget iki ora ndarbèni pangaruh marang kaca préferènsi iki.

Uga mangga diwigatèkaké yèn gadget astaméwa iki dudu bagéyan saka piranti empuk MediaWiki lan biasané dikembangaké lan diopèni déning panganggo-panganggo ing wiki lokal panjenengan. Pangurus lokal bisa nyunting gadget sing kasedyakaké nganggo [[MediaWiki:Gadgets-definition|dhéfinisi]] lan [[Special:Gadgets|uraian]].',
	'gadgets' => 'Gadget',
	'gadgets-title' => 'Gadget',
	'gadgets-pagetext' => 'Ing ngisor iki daftar gadget astaméwa sing bisa diaktifaké ing [[Special:Preferences|kaca prèferènsi]] panganggo, kayadéné didéfinisi déning [[MediaWiki:Gadgets-definition|dhéfinisi]].
Tinjoan iki mènèhi aksès sing gampang menyang kaca-kaca pesen sistem sing ngawedhar saben gadget lan kodhe.',
	'gadgets-uses' => 'Kagunan',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'prefs-gadgets' => 'قاجەت قۇرالدار',
	'gadgets-prefstext' => 'تومەندە ٴوز تىركەلگىڭىزدە قوسا الاتىن ارناۋلى قاجەت قۇرالدار ٴتىزىمى بەرىلەدى.
وسى قاجەت قۇرالدار كوبىنەسە JavaScript امىرلەرىنە نەگىزدەلىنەدى, سوندىقتان بۇلار جۇمىس ىستەۋى ٴۇشىن شولعىشىڭىزدا JavaScript قوسىلعان بولۋى كەرەك.
بۇل باپتاۋ بەتىنە وسى قاجەت قۇرالدار اسەر ەتپەيتىنىڭ ەسكەرىڭىز.

تاعى دا ەسكەرىڭىز: وسى قاجەت قۇرالدار MediaWiki باعدارلاماسىنىڭ بولىگى ەمەس, جانە دە بۇلاردى جايشىلىقتا جەرگىلىكتى ۋىيكىيدىڭ قاتىسۋشىلارى دامىتادى جانە قوشتايدى.
جەرگىلىكتى اكىمشىلەر جەتىمدى قاجەت نارسە ٴتىزىمىن [[{{ns:mediawiki}}:Gadgets-definition]] جانە [[{{ns:special}}:Gadgets]] بەتتەرى ارقىلى
وڭدەي الادى.',
	'gadgets' => 'قاجەت قۇرالدار',
	'gadgets-title' => 'قاجەت قۇرالدار',
	'gadgets-pagetext' => 'تومەندە ارناۋلى قاجەت قۇرالدار ٴتىزىمى بەرىلەدى. [[{{ns:mediawiki}}:Gadgets-definition]] بەتىندە انىقتالعان قاجەت قۇرالداردى قاتىسۋشىلار ٴوزىنىڭ باپتاۋىندا قوسا الادى.
بۇل شولۋ بەتى ارقىلى ٴاربىر قاجەت قۇرالدىڭ سىيپاتتاماسى مەن ٴامىرىن انىقتايتىن جۇيە حابار بەتتەرىنە جەڭىل قاتىناي الاسىز.',
	'gadgets-uses' => 'قولدانۋداعىلار',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'prefs-gadgets' => 'Қажет құралдар',
	'gadgets-prefstext' => 'Төменде өз тіркелгіңізде қоса алатын арнаулы қажет құралдар тізімі беріледі.
Осы қажет құралдар көбінесе JavaScript әмірлеріне негізделінеді, сондықтан бұлар жұмыс істеуі үшін шолғышыңызда JavaScript қосылған болуы керек.
Бұл баптау бетіне осы қажет құралдар әсер етпейтінің ескеріңіз.

Тағы да ескеріңіз: осы қажет құралдар MediaWiki бағдарламасының бөлігі емес, және де бұларды жайшылықта жергілікті уикидің қатысушылары дамытады және қоштайды.
Жергілікті әкімшілер жетімді қажет нәрсе тізімін [[{{ns:mediawiki}}:Gadgets-definition]] және [[{{ns:special}}:Gadgets]] беттері арқылы
өңдей алады.',
	'gadgets' => 'Қажет құралдар',
	'gadgets-title' => 'Қажет құралдар',
	'gadgets-pagetext' => 'Төменде арнаулы қажет құралдар тізімі беріледі. [[{{ns:mediawiki}}:Gadgets-definition]] бетінде анықталған қажет құралдарды қатысушылар өзінің баптауында қоса алады.
Бұл шолу беті арқылы әрбір қажет құралдың сипаттамасы мен әмірін анықтайтын жүйе хабар беттеріне жеңіл қатынай аласыз.',
	'gadgets-uses' => 'Қолданудағылар',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'prefs-gadgets' => 'Qajet quraldar',
	'gadgets-prefstext' => 'Tömende öz tirkelgiñizde qosa alatın arnawlı qajet quraldar tizimi beriledi.
Osı qajet quraldar köbinese JavaScript ämirlerine negizdelinedi, sondıqtan bular jumıs istewi üşin şolğışıñızda JavaScript qosılğan bolwı kerek.
Bul baptaw betine osı qajet quraldar äser etpeýtiniñ eskeriñiz.

Tağı da eskeriñiz: osı qajet quraldar MediaWiki bağdarlamasınıñ böligi emes, jäne de bulardı jaýşılıqta jergilikti wïkïdiñ qatıswşıları damıtadı jäne qoştaýdı.
Jergilikti äkimşiler jetimdi qajet närse tizimin [[{{ns:mediawiki}}:Gadgets-definition]] jäne [[{{ns:special}}:Gadgets]] betteri arqılı
öñdeý aladı.',
	'gadgets' => 'Qajet quraldar',
	'gadgets-title' => 'Qajet quraldar',
	'gadgets-pagetext' => 'Tömende arnawlı qajet quraldar tizimi beriledi. [[{{ns:mediawiki}}:Gadgets-definition]] betinde anıqtalğan qajet quraldardı qatıswşılar öziniñ baptawında qosa aladı.
Bul şolw beti arqılı ärbir qajet quraldıñ sïpattaması men ämirin anıqtaýtın jüýe xabar betterine jeñil qatınaý alasız.',
	'gadgets-uses' => 'Qoldanwdağılar',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'prefs-gadgets' => 'គ្រឿងបន្ទាប់បន្សំ',
	'gadgets' => 'គ្រឿងបន្ទាប់បន្សំ',
	'gadgets-title' => 'គ្រឿងបន្ទាប់បន្សំ',
	'gadgets-uses' => 'ប្រើ',
);

/** Korean (한국어)
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 */
$messages['ko'] = array(
	'gadgets-desc' => '사용자들이 [[Special:Gadgets|CSS와 자바스크립트 소도구]]를 [[Special:Preferences|사용자 환경 설정]]에서 설정할 수 있게 함',
	'prefs-gadgets' => '소도구',
	'gadgets-prefstext' => '아래는 당신이 사용할 수 있는 소도구의 목록입니다.
이 소도구들은 대부분 자바스크립트 기반이며 당신의 웹 브라우저에서 사용할 수 있습니다.
참고로 이 소도구들은 사용자 환경 설정에서는 아무런 영향을 주지 않습니다.

또한 이 소도구들은 미디어위키 소프트웨어의 일부분이 아니며, 주로 해당 위키의 사용자가 개발한 것입니다.
관리자는 [[MediaWiki:Gadgets-definition|소도구 정의 문서]]와 [[Special:Gadgets|소도구 설명 문서]]를 통해 사용할 수 있는 소도구들을 편집할 수 있습니다.',
	'gadgets' => '소도구 목록',
	'gadgets-title' => '소도구',
	'gadgets-pagetext' => '다음은 [[MediaWiki:Gadgets-definition|소도구 정의]]에 따라, [[Special:Preferences|사용자 환경 설정]]에서 활성화시킬 수 있는 소도구의 목록입니다.
이 둘러보기 문서는 각 소도구의 설명과 코드를 정의하는 시스템 메시지를 가리는 링크를 제공합니다.',
	'gadgets-uses' => '다음 코드를 이용',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'gadgets-desc' => 'En iere [[Special:Preferences|Enstellunge]] künne Metmaacher [[Special:Gadgets|CSS- un JavaScrip-Gadgets]] en- un ußschallde.',
	'prefs-gadgets' => '<i lang="en">Gadgets</i>',
	'gadgets-prefstext' => 'Hee is en Liss met bestemmpte <i lang="en">Gadgets</i>,
di för jede Metmaacher enjeschalldt wäde könne.
Di boue miets op Javascrip op, drom moß mer\'t em Brauser
enschallde, domet dat klapp.
<i lang="en">Gadgets</i> werke nimmohls op dä Sigg hee,
met Dinge persönleche Enstellunge.

Opjepaß! <i lang="en">Gadgets</i>, sin kei Schtöck vun MediaWiki,
söndern sin extra em Wiki installeet, un sin vun de Wiki-Bedriever
oder Metmaacher ußjedaach un enjerescht.
Wä et Rääsch doför hät, kann se övver de Sigge
[[MediaWiki:Gadgets-definition|<i lang="en">Gadgets</i> fäßlääje]]
un [[Special:Gadgets|<i lang="en">Gadgets</i> beschriewe]]
enreschte un ändere.',
	'gadgets' => '<i lang="en">Gadgets</i>',
	'gadgets-title' => '<i lang="en">Gadgets</i>',
	'gadgets-pagetext' => 'He kütt en Liss met spezielle <i lang="en">Gadgets</i>,
di jede Metmaacher övver sing
[[Special:Preferences|päsönlije Enstellunge]] enschallte kann.
Se wääde üvver [[MediaWiki:Gadgets-definition]] enjerecht.
Die Övverseech hee jit enne direkte Zohjang op di Texte em Wiki,
wo de Projramme, un de Erklierunge för de <i lang="en">Gadgets</i> dren enthallde
sin.',
	'gadgets-uses' => 'Bruch',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'gadgets-desc' => 'Erméiglecht de Benotzer et perséinlech [[Special:Gadgets|CSS a JavaScript Gadgeten]] an hiren [[Special:Preferences|Astellunge]] festzeleeën.',
	'prefs-gadgets' => 'Gadgeten',
	'gadgets-prefstext' => "Lëscht vu spezielle Gadgeten déi fir Äre Benotzerkont aktivéiert kënne ginn.
D'Gadgete baséiere meeschtens op engem JavaScript, dofir muss JavaScript an Ärem Browser aktivéiert sinn, fir datt se fonctionéieren.
D'Gadgete fonctionéieren awer net op dëser Säit mat de perséinlechen Astellungen.

Ausserdeem sollt Dir wëssen, datt dës Gadgete generell net Deel vu MediaWiki sinn, a meeschtens vu Benotzer vu lokale Wikien entwéckelt an ënnerhale ginn. 
Lokal Wiki-Administrateure kënnen d'Lëscht von den disponibele Gadgeten op de Säiten [[MediaWiki:Gadgets-definition|Definitioune vun Gadgeten]] a [[Special:Gadgets|Beschreiwunge vu Gadgeten]] änneren.",
	'gadgets' => 'Gadgeten',
	'gadgets-title' => 'Gadgeten',
	'gadgets-pagetext' => "Ënnendrënner ass eng Lëscht vun de spezielle Gadgeten déi d'Benotzer op hire [[Special:Preferences|Benotzer-Astellungen]] aschalte kënnen, esou wéi dat op [[MediaWiki:Gadgets-definition|definéiert]] ass.
Dës Iwwersiicht gëtt einfachen Zougang zu de Systemmessage-Säiten, déi all Gadget beschreiwen an zum Programméiercode vun dem Gadget.",
	'gadgets-uses' => 'Benotzt',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Tibor
 */
$messages['li'] = array(
	'gadgets-desc' => 'Laat gebroekers [[special:Gadgets|CSS en JavaScripts]] activere in hun [[Special:Preferences|veurkeure]]',
	'prefs-gadgets' => 'Biedènger',
	'gadgets-prefstext' => 'Hiejónger sjtaon de sjpeciaal oetbreijinge dies te veur dien gebroekersaccount kèns insjakele.
De oetbreijinge zeen veurnamelik gebaseerd op JavaScript, dus JavaScript mót veur diene browser ingesjakeld zeen óm die te laote wirke.
De oetbreijinge höbbe geine invlood op dees pazjena mit veurkäöre.

Dees sjpeciaal oetbreijinge zeen ouch gein óngerdeil van de MediaWiki-software en die mótte meistal óntwikkeld en óngerhauwe waere door gebroekers van diene wiki. 
Lokaal beheerders kónne de besjikbaar oetbreijinge aangaeve in [[MediaWiki:Gadgets-definition]] en [[Special:Gadgets]].',
	'gadgets' => 'Oetbreijinger',
	'gadgets-title' => 'Oetbreijinger',
	'gadgets-pagetext' => 'Hiej ónger staon de speciaal oetbreijinger die gebroekers kinne insjakele via häöre [[Special:Preferences|veurkeure]] wie ingesteldj is in [[MediaWiki:Gadgets-definition]].
Dit euverzich bi-jtj uch einvoudige toegank toet de systeemtekspazjena wo de besjrieving en de programmacode van edere oetbreijing steit.',
	'gadgets-uses' => 'Gebroek',
);

/** Lithuanian (Lietuvių)
 * @author Homo
 * @author Vpovilaitis
 */
$messages['lt'] = array(
	'gadgets-desc' => 'Leidžia naudotojams pasirinkti savo [[Special:Gadgets|CSS ir JavaScript priemones]] jų [[Special:Preferences|nustatymuose]]',
	'prefs-gadgets' => 'Priemonės',
	'gadgets-prefstext' => 'Žemiau yra sąrašas specialių priemonių, kurias jūs galite įjungti naudojimui.
Šios priemonės daugiausiai yra sukurtos naudojant JavaScript, todėl, kad jos veiktų, jūsų naršyklėje turi būti įjungtas JavaScript palaikymas.
Atsiminkite, kad šios priemonės neturi įtakos jūsų nustatymų puslapiui.

Taip pat žinokite, kad šios specialios priemonės nėra MediaWiki programinės įrangos dalis ir yra sukurtos bei palaikomos vietinio vikiprojekto naudotojų. Vietiniai administratoriai gali redaguoti suteikiamų specialių priemonių sąrašą, naudodami puslapius [[MediaWiki:Gadgets-definition|priemonių aprašymas]] ir [[Special:Gadgets|priemonės]].',
	'gadgets' => 'Priemonės',
	'gadgets-title' => 'Priemonės',
	'gadgets-pagetext' => 'Žemiau yra sąrašas specialių priemonių, kurias naudotojai gali įjungti savo [[Special:Preferences|nustatymų puslapyje]]. Jos apibūdintos [[MediaWiki:Gadgets-definition|priemonių aprašyme]]. Ši apžvalga suteikia lengvą priėjimą prie sisteminių pranešimų puslapių, kuriuose pateiktas kiekvienos priemonės trumpas aprašas ir kodas.',
	'gadgets-uses' => 'Panaudojimai',
);

/** Latvian (Latviešu)
 * @author Marozols
 */
$messages['lv'] = array(
	'prefs-gadgets' => 'Rīki',
	'gadgets' => 'Rīki',
	'gadgets-title' => 'Rīki',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'gadgets-desc' => 'Овозможува на корисниците да одберат свои сопствени [[Special:Gadgets|CSS и JavaScript додатоци]] во нивните [[Special:Preferences|нагодувања]]',
	'prefs-gadgets' => 'Додатоци',
	'gadgets-prefstext' => 'Листа на специјални додатоци кои можете да ги активирате за вашата корисничка сметка.
Овие додатоци главно се базираат на JavaScript, па затоа морате да имате овозможено JavaScript на вашиот прелистувач за да можат да работат.
Имајте в предвид дека овие додатоци нема да имаат никаков ефект врз оваа страница за нагодување.

Исто така имајте на ум дека овие специјални додатоци не се дел од MediaWiki софтверот и обично истите се развиени и се одржуват од корисници на вашето локално вики.
Локалните администратори можат да ги уредуваат и прилагодуваат додатоците користејќи се со [[MediaWiki:Gadgets-definition|дефиниции]] и [[Special:Gadgets|описи]].',
	'gadgets' => 'Додатоци',
	'gadgets-title' => 'Додатоци',
	'gadgets-pagetext' => 'Листа на специјални додатоци кои корисниците можат да ги активираат на нивните [[Special:Preferences|страници за нагодување]], наведени во [[MediaWiki:Gadgets-definition|дефинициите]].
Овој преглед дава лесен пристап до системските пораки кои го дефинираат описот и кодот на секој додаток.',
	'gadgets-uses' => 'Користи',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'gadgets-desc' => 'ഉപയോക്താക്കള്‍ [[Special:Preferences|ക്രമീകരണങ്ങളില്‍ നിന്നു]] അവര്‍ക്കിഷ്ടമുള്ള [[Special:Gadgets|CSS, JavaScript ഗാഡ്ജറ്റുകള്‍]] തിരഞ്ഞെടുക്കട്ടെ.',
	'prefs-gadgets' => 'ഗാഡ്ജറ്റ്',
	'gadgets-prefstext' => 'താങ്കളുടെ അംഗത്വത്തിനു പ്രാപ്തമാക്കാവുന്ന പ്രത്യേക ഗാഡ്ജറ്റുകളുടെ പട്ടികയാണ് താഴെയുള്ളത്.
ഈ ഗാഡ്‌‌ജറ്റുകൾ പ്രധാനമായും ജാവാസ്ക്രിപ്റ്റിൽ അധിഷ്ഠിതമാണ്, അതുകൊണ്ട് ഇവ പ്രവർത്തിക്കുവാൻ താങ്കളുടെ ബ്രൗസറിൽ ജാവാസ്ക്രിപ്റ്റ് സജ്ജമാക്കി നൽകിയിരിക്കണം.
ഈ ക്രമീകരണങ്ങൾ താളിൽ ഈ ഗാഡ്ജറ്റുകൾക്ക് യാതൊരു സ്വാധീനവുമില്ല എന്നു മനസ്സിലാക്കുക.

ഈ പ്രത്യേക ഗാഡ്‌‌ജറ്റുകൾ മീഡിയവിക്കി സോഫ്റ്റ്‌‌വേറിന്റെ ഭാഗമേയല്ല എന്നും മനസ്സിലാക്കുക, അവ വികസിപ്പിക്കുന്നതും പരിപാലിക്കുന്നതും താങ്കളുടെ പ്രാദേശിക വിക്കിയിലെ ഉപയോക്താക്കളായിരിക്കും.
പ്രാദേശിക കാര്യനിർവാഹകർക്ക് ലഭ്യമായ ഗാഡ്‌‌ജറ്റുകളെ [[MediaWiki:Gadgets-definition|നിർവ്വചനങ്ങളും]] [[Special:Gadgets|വിവരണങ്ങളും]] ഉപയോഗിച്ച് തിരുത്താൻ കഴിയുന്നതാണ്.',
	'gadgets' => 'ഗാഡ്ജറ്റ്',
	'gadgets-title' => 'ഗാഡ്ജറ്റ്',
	'gadgets-pagetext' => 'ഉപയോക്താക്കൾക്ക് അവരുടെ [[Special:Preferences|ക്രമീകരണങ്ങൾ താളിൽ]] നിന്നും സജ്ജമാക്കാവുന്ന ഗാഡ്ജറ്റുകളുടെ പട്ടിക [[MediaWiki:Gadgets-definition|അവ നിർവ്വചിക്കപ്പെട്ട പ്രകാരം]] താഴെ കൊടുത്തിരിക്കുന്നു.
ഓരോ ഗാഡ്ജറ്റിന്റേയും വിവരണവും കോഡും ഉള്ള സന്ദേശ താളുകളിലേക്കു പോകാനുള്ള എളുപ്പവഴി ഈ പട്ടിക നല്‍കുന്നു.',
	'gadgets-uses' => 'ഉപയോഗങ്ങള്‍',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'gadgets-desc' => 'सदस्यांना त्यांच्या [[Special:Preferences|पसंतीची]] [[Special:Gadgets|CSS व जावास्क्रीप्ट गॅजेट्स]] निवडण्याची परवानगी देते.',
	'prefs-gadgets' => 'उपकरण(गॅजेट)',
	'gadgets-prefstext' => 'खाली तुम्ही तुमच्या सदस्यत्वासाठी वापरू शकत असलेल्या गॅजेट्सची यादी दिलेली आहे. ही गॅजेट्स मुख्यत्वे जावास्क्रीप्टवर अवलंबून असल्यामुळे तुमच्या ब्राउझर मध्ये जावास्क्रीप्ट एनेबल असणे आवश्यक आहे. या गॅजेट्समुळे या पसंतीच्या पानावर कुठलेही परिणाम होणार नाहीत याची कृपया नोंद घ्यावी.

तसेच ही गॅजेट्स मीडियाविकी प्रणालीचा हिस्सा नाहीत, व ही मुख्यत्वे स्थानिक विकिवर सदस्यांद्वारे उपलब्ध केली जातात. स्थानिक प्रबंधक उपलब्ध गॅजेट्स [[MediaWiki:Gadgets-definition]] व [[Special:Gadgets]] वापरून बदलू शकतात.',
	'gadgets' => 'सुविधा (गॅजेट)',
	'gadgets-title' => 'गॅजेट',
	'gadgets-pagetext' => 'खाली तुम्ही तुमच्या सदस्यत्वासाठी वापरू शकत असलेल्या [[MediaWiki:Gadgets-definition]]ने सांगितलेल्या गॅजेट्सची यादी दिलेली आहे. हे पान तुम्हाला प्रत्येक गॅजेट्सचा कोड व व्याख्या देणार्‍या पानासाठी सोपी संपर्क सुविधा पुरविते.',
	'gadgets-uses' => 'उपयोग',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'gadgets-desc' => 'Membolehkan pengguna memilih [[Special:Gadgets|gajet CSS dan JavaScript]] tempahan melalui [[Special:Preferences|laman keutamaan]]',
	'prefs-gadgets' => 'Gajet',
	'gadgets-prefstext' => 'Yang berikut ialah senarai gajet khas yang anda boleh hidupkan untuk akaun anda. Kebanyakan daripada gajet-gajet ini memerlukan JavaScript, oleh itu anda perlu menghidupkan ciri JavaScript dalam pelayar web anda untuk menggunakannya. Sila ambil perhatian bahawa gajet-gajet ini tidak menjejaskan laman keutamaan ini.

Sila ambil perhatian juga bahawa gajet-gajet khas ini bukan sebahagian daripada perisian MediaWiki, dan biasanya dibangunkan dan diselenggara oleh para pengguna di wiki tempatan anda. Pentadbir tempatan boleh mengubah gajet-gajet yang sedia ada menggunakan [[MediaWiki:Gadgets-definition|takrif]] dan [[Special:Gadgets|keterangan]].',
	'gadgets' => 'Gajet',
	'gadgets-title' => 'Gajet',
	'gadgets-pagetext' => 'Yang berikut ialah senarai gajet khas yang boleh dihidupkan oleh pengguna melalui [[Special:Preferences|laman keutamaan]], sebagai mana yang telah [[MediaWiki:Gadgets-definition|ditakrifkan]]. Laman ini menyediakan capaian mudah kepada laman pesanan sistem yang mentakrifkan setiap kod dan keterangan gajet.',
	'gadgets-uses' => 'Menggunakan',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'gadgets-desc' => 'Lett Brukers vörgeven [[Special:Gadgets|CSS- un JavaScript-Gadgets]] in jemehr [[Special:Preferences|Instellungen]] aktiveren',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => 'Ünnen steit en List vun spezielle Warktüüch, de elkeen Bruker för sik anstellen kann.
Disse Warktüüch loopt tomehrst mit Javascript. Dat mutt also in’n Browser anstellt wesen, dat dat löppt.
Wees aver gewohr, dat de Warktüüch hier direkt op disse Sied mit de persönlichen Instellungen nix bewarkt.

De Warktüüch sünd denn ok keen offiziellen Deel vun MediaWiki, sünnern warrt normalerwies vun enkelte Brukers vun dat lokale Wiki schreven. De Administraters vun dat Wiki köönt de List mit de Warktüüch över de Sieden [[MediaWiki:Gadgets-definition]] un [[Special:Gadgets]] ännern.',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => 'Ünnen steit en List mit spezielle Warktüüch, de för all Brukers in de [[Special:Preferences|Instellungen]] anstellt warrn köönt. Defineert sünd de Warktüüch in [[MediaWiki:Gadgets-definition]].
Disse Översicht gifft direkten Togang to de Systemnarichten, in de de Text to de Warktüüch un jemehr Programmkood steit.',
	'gadgets-uses' => 'Bruukt',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'gadgets-desc' => 'Laot gebrukers [[Special:Gadgets|CSS en JavaScripts]] activeren in der [[Special:Preferences|veurkeuren]]',
	'prefs-gadgets' => 'Technisch spul',
	'gadgets-prefstext' => "Hieronder steet speciaal techinische spul da-j inschakelen kunnen.
't Is veurnamelijk ebaseerd op JavaScript, dus JavaScript mu-j an hemmen staon in joew webkieker um 't te laoten warken.
Al dit technische spul hef gien invleud op disse veurkeurenpagina.

Disse technische snufjes maken oek gien deel uut van de MediaWiki-pregrammetuur, en 't wönnen meestentieds ontwikkeld en onderhouwen
deur gebrukers van joew eigen wiki.
Beheerders kunnen 't beschikbaore technische spul angeven in [[MediaWiki:Gadgets-definition|defenisies]] en [[Special:Gadgets|beschrievingen]].",
	'gadgets' => 'Technisch spul',
	'gadgets-title' => 'Technisch spul',
	'gadgets-pagetext' => 'Hieronder steet speciaal technisch spul dee gebrukers in kunnen schakelen bie [[Special:Preferences|mien veurkeuren]], zoas in-esteld in de [[MediaWiki:Gadgets-definition|defenisies]].
Dit overzichte biejt eenvoudige toegang tot de systeemtekspagina waor de beschrieving en de pregrammacode van elke technisch snufjen steet.',
	'gadgets-uses' => 'Gebruuk',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'gadgets-desc' => 'Laat gebruikers [[Special:Gadgets|CSS en JavaScripts]] activeren in hun [[Special:Preferences|voorkeuren]]',
	'prefs-gadgets' => 'Uitbreidingen',
	'gadgets-prefstext' => 'Hieronder staan de speciale uitbreidingen die u kunt inschakelen.
De uitbreidingen zijn voornamelijk gebaseerd op JavaScript, dus JavaScript moet voor uw browser ingeschakeld zijn om ze te laten werken.
De uitbreidingen hebben geen invloed op deze pagina met voorkeuren.

Deze speciale uitbreidingen zijn ook geen onderdeel van de MediaWiki-software, en ze worden meestal ontwikkeld en onderhouden
door gebruikers van uw wiki.
Beheerders kunnen de beschikbare uitbreidingen aangeven in [[MediaWiki:Gadgets-definition|definities]] en [[Special:Gadgets|beschrijvingen]].',
	'gadgets' => 'Uitbreidingen',
	'gadgets-title' => 'Uitbreidingen',
	'gadgets-pagetext' => 'Hieronder staan de speciale uitbreidingen die gebruikers kunnen inschakelen via hun [[Special:Preferences|voorkeuren]], zoals ingesteld in de [[MediaWiki:Gadgets-definition|definities]].
Dit overzicht biedt eenvoudige toegang tot de systeemtekstpagina waar de beschrijving en de programmacode van iedere uitbreiding staat.',
	'gadgets-uses' => 'Gebruikt',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Harald Khan
 */
$messages['nn'] = array(
	'gadgets-desc' => 'Lèt brukarane velje eigendefinerte [[Special:Gadgets|CSS- og JavaScript-verktøy]]  i [[Special:Preferences|innstillingane sine]].',
	'prefs-gadgets' => 'Tilleggsfunksjonar',
	'gadgets-prefstext' => 'Under finn du ei liste over tilleggsfunksjonar som du kan slå på på kontoen din. Desse tilleggsfunksjonane er for det meste baserte på JavaScript, så JavaScript må vere slått på i nettlesaren din for at dei skal verke. Merk at desse tilleggsfunksjonane ikkje har nokon effekt på denne innstillingssida.

Merk også at tilleggsfunksjonane ikkje er ein del av MediaWiki-programvara, og at dei vanlegvis er utvikla og vedlikehaldne av brukarar på din lokale wiki. Lokale administratorar kan endre dei tilgjengelege tilleggsfunksjonane ved å endre [[MediaWiki:Gadgets-definition|definisjonane]] og [[Special:Gadgets|skildringane]].',
	'gadgets' => 'Tilleggsfunksjonar',
	'gadgets-title' => 'Tilleggsfunksjonar',
	'gadgets-pagetext' => 'Under finn du ei liste over tilleggsfunksjonar som brukarane kan slå på på [[Special:Preferences|innstillingane]] sine, som oppgjevne i [[MediaWiki:Gadgets-definition|definisjonane]].
Dette oversynet gjev enkel tilgang til systemmeldingssidene som inneheld skildringa og koden til kvar enkelt tilleggsfunksjon.',
	'gadgets-uses' => 'Brukar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'gadgets-desc' => 'Lar brukere velge egendefinerte [[Special:Gadgets|CSS- og JavaScript-verktøy]] i [[Special:Preferences|innstillingene sine]]',
	'prefs-gadgets' => 'Tilleggsfunksjoner',
	'gadgets-prefstext' => 'Nedenfor er en liste over tilleggsfunksjoner du kan slå på for kontoen din.
Disse funksjonene er for det meste basert på JavaScript, så du må ha dette slått på i nettleseren din for at de skal fungere.
Merk at funksjonene ikke vil ha noen innvirkning på denne innstillingssiden.

Merk også at disse verktøyene ikke er del av MediaWiki-programvaren, og vanligvis utvikles og vedlikeholdes av brukere på den lokale wikien. Lokale administratorer kan redigere tilgjengelig verktøy ved å endre [[MediaWiki:Gadgets-definition|definisjonene]] og [[Special:Gadgets|beskrivelsene]].',
	'gadgets' => 'Tilleggsfunksjoner',
	'gadgets-title' => 'Tilleggsfunksjoner',
	'gadgets-pagetext' => 'Nedenfor er en liste over tilleggsfunksjoner brukere kan slå på i [[Special:Preferences|innstillingene]], som definert på [[MediaWiki:Gadgets-definition]]. Denne oversikten gir lett tilgang til systembeskjedsidene som definerer hvert verktøys beskrivelse og kode.',
	'gadgets-uses' => 'Bruk',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'gadgets-desc' => 'Daissa als utilizaires los [[Special:Gadgets|gadgets CSS e JavaScript]] dins lor [[Special:Preferences|preferéncias]]',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => "Çaijós apareis una tièra de gadgets que podètz activar per vòstre compte. Fan ampèl a JavaScript, deu doncas èsser activat per vòstre navigador Web.

An pas cap d'incidéncia sus aquesta pagina de preferéncias. E mai, son generalament desvolopats e mantenguts sus aqueste wiki.
Los administrators pòdon modificar los gadgets en passant per [[MediaWiki:Gadgets-definition|las definicions]] e las [[Special:Gadgets|descripcions]].",
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => "Çaijós apareis una lista de gadgets que los utilizaires pòdon activar dins lor [[Special:Preferences|pagina de preferéncias]], coma definit dins ''[[MediaWiki:Gadgets-definition|las definicions]]''.
Aqueste susvòl dona un accès rapid a las paginas de messatges del sistèma que definisson cada descripcion e cada còde dels gadgets.",
	'gadgets-uses' => 'Utiliza',
);

/** Pampanga (Kapampangan)
 * @author Katimawan2005
 */
$messages['pam'] = array(
	'gadgets-desc' => 'Didinan nong tsansa/pamikatagun a mamiling pasadiang [[Special:Gadgets|CSS ampong JavaScript gadget]] ketang karelang [[Special:Preferences|pinili]] (preferences)',
	'prefs-gadgets' => 'Deng gadget',
	'gadgets-prefstext' => 'Ating tala (listaan) da reng espesial a gadget a agamit mu ba meng apaliari (enable) ing kekang account.
Uling makabasi la king JavaScript deng keraklan kareting gadget, kailangan yang papaliari ing JavaScript king kekang browser ba lang gumada deti.
Tandanan mung ala lang epektu king bulung da ring pinili (preferences page) deng gadget a reti.

Tandanan mu muring e la kayabe king MediaWiki software deting gadget, at keraklan, gagawan da la ampong mamantinian deng talagamit ketang kekayung lokal a wiki.
Maliari lang makapag-edit deng talapanibala (administrator) kareng gadget a atiu nung gamitan de ing [[MediaWiki:Gadgets-definition]] ampo ing [[Special:Gadgets]].',
	'gadgets' => 'Deng gadget',
	'gadgets-title' => 'Deng gadget',
	'gadgets-pagetext' => 'Makabili ya king lalam ing tala (listaan) da reng espesial a gadget a apaliari (enable) da reng talagamit ketang karelang bulung da ring pinili (preferences page), agpang king kabaldugan king [[MediaWiki:Gadgets-definition]].
Gawa nang malagua niting piyakitan (overview) ing pamanintun kareng bulung a maki system message a milalarawan king balang gadget at babie king kayang code.',
	'gadgets-uses' => 'Gamit',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'prefs-gadgets' => 'Gadgets',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'gadgets-desc' => 'Pozwala użytkownikom wybrać [[Special:Gadgets|gadżety CSS i JavaScript]] na [[Special:Preferences|stronie preferencji]]',
	'prefs-gadgets' => 'Gadżety',
	'gadgets-prefstext' => 'Poniżej znajduje się lista specjalnych gadżetów, które możesz włączyć dla swojego konta użytkownika.
Gadżety najczęściej wykorzystują JavaScript, więc by działały musisz mieć w swojej przeglądarce włączoną obsługę JavaScriptu. Gadżety nie mają wpływu na tę stronę preferencji.

Gadżety nie są częścią oprogramowania MediaWiki i najprawdopodobniej zostały stworzone przez użytkowników tego wiki.
Lokalni administratorzy mogą edytować dostępne gadżety używając stron [[MediaWiki:Gadgets-definition|Definicje gadżetów]] oraz [[Special:Gadgets|Gadżety]].',
	'gadgets' => 'Gadżety',
	'gadgets-title' => 'Gadżety',
	'gadgets-pagetext' => 'Poniżej znajduje się lista specjalnych gadżetów, które użytkownicy mogą włączyć na swojej [[Special:Preferences|stronie preferencji]]. Lista ta jest zdefiniowana na stronie [[MediaWiki:Gadgets-definition|definicji]].
Poniższy przegląd ułatwia dostęp do komunikatów systemu, które definiują opis i kod każdego z gadżetów.',
	'gadgets-uses' => 'Użycie',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'gadgets-desc' => "A lassa che j'utent a selession-o [[Special:Gadgets|CSS e gadget JavaScript]]  ant ij [[Special:Preferences|sò gust]]",
	'prefs-gadgets' => 'Component',
	'gadgets-prefstext' => "Ambelessì sota a-i é na lista ëd component ch'a peul vischesse ant sò cont personal. 
Sti component-sì a son dzortut basà ansima a JavaScript, donca a venta anans tut che JavaScript a sia avisch ant sò navigator, s'a veul che ij component a travajo. 
Ch'a ten-a present che sti component a l'han gnun efet ansima a la pàgina dij \"sò gust\".

Ch'a nòta ëdcò che a son nen part dël programa MediaWiki e che për sòlit a resto dësvlupà e mantnù da dj'utent dla wiki andova chiel/chila as treuva adess. 
J'aministrator locaj a peulo regolé ij component disponibij ën dovrand le pàgine [[MediaWiki:Gadgets-definition|definission dij component]] e [[Special:Gadgets|component]].",
	'gadgets' => 'Component',
	'gadgets-title' => 'Component',
	'gadgets-pagetext' => "Ambelessì sota a-i é na lista ëd component spessiaj che j'utent a peulo butesse avisch ant ij [[Special:Preferences|sò gust]], conforma a la [[MediaWiki:Gadgets-definition|definission dij component]]. 
Sta lista complessiva a smon na stra còmoda për rivé a le pàgine ëd messagi ëd sistema ch'a definisso descrission e còdes ëd vira component.",
	'gadgets-uses' => 'a dòvra',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'gadgets-uses' => 'کارونې',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'gadgets-desc' => "Permite aos utilizadores seleccionarem [[Special:Gadgets|''\"gadgets\"'' JavaScript e CSS]] personalizados nas suas [[Special:Preferences|preferências]]",
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => "Segue-se uma lista de ''\"gadgets\"'' especiais que pode activar na sua conta.
Estes ''gadgets'' são baseados principalmente em JavaScript, sendo necessário activar o suporte a JavaScript no seu navegador para que funcionem.
Note que não terão efeito nesta página de preferências.

Note também que estes ''gadgets'' especiais não fazem parte do programa MediaWiki, sendo geralmente desenvolvidos e mantidos por utilizadores na sua wiki local.
Administradores locais podem editar os ''gadgets'' disponíveis usando as [[MediaWiki:Gadgets-definition|definições]] e [[Special:Gadgets|descrições]].",
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => "Segue-se uma lista de ''\"gadgets\"'' que podem ser activados pelos utilizadores nas suas [[Special:Preferences|preferências]], como estabelecido pelas [[MediaWiki:Gadgets-definition|definições]].
Este resumo proporciona acesso fácil às páginas das mensagens de sistema que definem a descrição e o código de cada ''gadget''.",
	'gadgets-uses' => 'Utiliza',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'gadgets-desc' => 'Permite aos utilizadores selecionarem [[Special:Gadgets|"gadgets" JavaScript e CSS]] personalizados nas suas [[Special:Preferences|preferências]]',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => 'Segue-se uma lista de "gadgets" que podem ser ativados em sua conta.
Tais gadgets normalmente são baseados em JavaScript, o que faz com que seja necessário que o suporte a JavaScript esteja ativado em seu navegador para que os mesmos funcionem.
Note que os gadgets não possuem efeito nesta página (a página de preferências).

Note também que tais gadgets não são parte do software MediaWiki, geralmente sendo desenvolvidos e mantidos por usuários de sua wiki local.
Administradores locais podem editar os gadgets disponíveis através de [[MediaWiki:Gadgets-definition|definições]] e [[Special:Gadgets|descrições]].',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => 'Segue-se uma lista de "gadgets" que podem ser ativados por utilizadores através de [[Special:Preferences|suas páginas de preferências]], definidos em [[MediaWiki:Gadgets-definition|definições]].
Esta visão geral proporciona um acesso fácil para as mensagens de sistema que definem as descrições e códigos de cada um dos gadgets.',
	'gadgets-uses' => 'Utiliza',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'gadgets-desc' => 'Permite utilizatorilor să îşi aleagă [[Special:Gadgets|gadgeturi CSS şi JavaScript]] în [[Special:Preferences|preferinţele]] lor',
	'prefs-gadgets' => 'Gadgeturi',
	'gadgets' => 'Gadgeturi',
	'gadgets-title' => 'Gadgeturi',
	'gadgets-uses' => 'Utilizează',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'gadgets-desc' => "Lasse scacchià a l'utinde le [[Special:Gadgets|gadget CSS e JavaScript]] personalizzate jndr'à le lore [[Special:Preferences|preferenze]]",
	'prefs-gadgets' => 'Gadget',
	'gadgets-prefstext' => "Sotte stè 'n'elenghe de gadget speciale ca tu abbilità sus a 'u cunde tune.
Ste riale sò assaije basate sus a Javascript, accussì Javascript addà essere abbilitate jndr'à 'u browser tune pe le fà fatià.
Vide che ste riale non ge tènene effette sus a sta pàgene de preferenze.

Pò vide pure ca ste gadget non ge sonde parte d'u software de MediaUicchi e sonde normalmende sviluppate e mandenute da l'utinde d'a Uicchipèdie locale tune.
Le amministrature locale ponne cangià le gadget disponibbele ausanne le [[MediaWiki:Gadgets-definition|definiziune]] e le [[Special:Gadgets|descriziune]].",
	'gadgets' => 'Gadget',
	'gadgets-title' => 'Gadget',
	'gadgets-pagetext' => "Sotte stè 'n'elenghe de gadget speciale ca l'utinde ponne abbilità sus a lore [[Special:Preferences|pàgene de le preferenze]], cumme definite da le [[MediaWiki:Gadgets-definition|definiziune]].
Stu riepileghe prevede 'nu facile facile accesse a le pàggene de le messagge d'u sisteme ca definiscene ogne descrizione e codece de le gadget.",
	'gadgets-uses' => 'Ause',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Illusion
 * @author VasilievVV
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'gadgets-desc' => 'Позволяет участникам выбирать в [[Special:Preferences|настройках]] CSS- и JavaScript-гаджеты, которые они хотят подключить',
	'prefs-gadgets' => 'Гаджеты',
	'gadgets-prefstext' => 'Ниже приведён список специальных гаджетов, которые вы можете включить для своей учётной записи.
Эти гаджеты преимущественно основаны на JavaScript, поэтому вы должны включить JavaScript в своём браузере для того, чтобы они работали.
Учтите, что эти гаджеты не работают на странице настроек.

Также учтите, что эти гаджеты не являются частью MediaWiki и обычно разрабатываются и обслуживаются участниками вашей локальной вики.
Администраторы могут изменять список гаджетов с помощью страниц [[MediaWiki:Gadgets-definition|определений]] и [[Special:Gadgets|описаний]].',
	'gadgets' => 'Гаджеты',
	'gadgets-title' => 'Гаджеты',
	'gadgets-pagetext' => 'Ниже приведён список гаджетов, которые участники могут включить на своей странице настроек, в соответствии со списком на странице [[MediaWiki:Gadgets-definition|определений]].
Этот список позволяет легко получить доступ к страницам системных сообщений, определяющих описания и исходные коды гаджетов.',
	'gadgets-uses' => 'Использует',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'gadgets-desc' => 'Бэйэлэрин [[Special:Preferences|туруорууларыгар]] кыттааччылар [[Special:Gadgets|CSS уонна JavaScript гаджеттары]] холбонуохтарын сөп.',
	'prefs-gadgets' => 'Гаджеттар',
	'gadgets-prefstext' => 'Аллара аналлаах гаджеттар испииһэктэрэ көстөллөр. Балары бэйэҥ бэлиэтэммит ааккынан киирэн туһаныаххын сөп.
Бу үнүстүрүмүөннэр үксүлэрэ JavaScript көмөтүнэн үлэлииллэр, онон туһаныаххын баҕарар буоллаххына JavaScript холбоо.
Бу гаджеттар туроуорууларгын уларытар сирэйгэр үлэлээбэттэрин умнума.

Өссө маны умнума: бу гаджеттар MediaWiki сорҕото буолбатахтар, кинилэри кыттааччылар бэйэлэрэ айаллар уонна көрөллөр-истэллэр.  Дьаһабыллар гаджеттар испииһэктэрин [[MediaWiki:Gadgets-definition|быһаарыы сирэйдэр]] уонна [[Special:Gadgets|ойуулуур сирэйдэр]] көмөлөрүнэн уларытыахтарын сөп.',
	'gadgets' => 'Гаджеттар',
	'gadgets-title' => 'Гаджеттар',
	'gadgets-pagetext' => 'Манна [[MediaWiki:Gadgets-definition|быһаарыы сирэйигэр]] суруллубутун курдук [[Special:Preferences|туруоруу сирэйин]] көмөтүнэн холбонуон сөптөөх гаджеттар тиһиктэрэ көрдөрүлүннэ.
Этот список позволяет легко получить доступ к страницам системных сообщений, определяющих описания и исходные коды гаджетов.',
	'gadgets-uses' => 'Туһанар',
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'gadgets-desc' => 'උපයෝග්‍ය [[Special:Gadgets|CSS හා ජාවාස්ක්‍රිප්ට් මෙවලම්]] ඔවුන්ගේ [[Special:Preferences|අභිරුචීන්හිදී]] තෝරාගැනුමට පරිශීලකයන් හට ඉඩ සලසයි',
	'prefs-gadgets' => 'මෙවලම්',
	'gadgets' => 'මෙවලම්',
	'gadgets-title' => 'මෙවලම්',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'gadgets-desc' => 'Umožňuje používateľovi vybrať [[Special:Gadgets|CSS a JavaScriptové nástroje]] vo svojich [[Special:Preferences|nastaveniach]]',
	'prefs-gadgets' => 'Nástroje',
	'gadgets-prefstext' => 'Dolu je zoznam špeciálych nástrojov, ktoré môžete zapnúť v rámci svojho účtu.
Tieto nástroje sú zväčša založené na JavaScripte, takže aby fungovali, musíte mať v prehliadači zapnutý JavaScript.
Nástroje nemajú vplyv na túto stránku nastavení.

Tiež majte na pamäti, že tieto nástroje nie sú súčasťou MediaWiki a zvyčajne ich vyvíjajú a udržiavajú používatelia vašej lokálnej wiki.
Lokálni správcovia môžu upraviť zoznam dostupných nástrojov pomocou [[MediaWiki:Gadgets-definition|definícií]] a [[Special:Gadgets|popisov]].',
	'gadgets' => 'Nástroje',
	'gadgets-title' => 'Nástroje',
	'gadgets-pagetext' => 'Dolu je zoznam špeciálych nástrojov, ktoré môžu používatelia zapnúť v rámci svojho účtu na svojej stránke [[Special:Preferences|nastavení]]. Tento zoznam definuje stránka [[MediaWiki:Gadgets-definition]]. Tento prehľad poskytuje jednoduchý prístup k systémovým stránkam, ktoré definujú popis a kód každého z nástrojov.',
	'gadgets-uses' => 'Použitia',
);

/** Slovenian (Slovenščina)
 * @author Smihael
 */
$messages['sl'] = array(
	'gadgets-desc' => 'Omogoča uporabnikom, da vključijo [[Special:Gadgets|vtičnike CSS in JavaScript]] v [[Special:Preferences|nastvitvah]]',
	'prefs-gadgets' => 'Vtičniki',
	'gadgets-prefstext' => 'Prikazan je seznam posebnih vtičnikov, ki si jih lahko omogočite.
Večinoma temeljijo na JavaScript, zato mora biti le-ta omogočen v vašem brskalniku. 
Ti vtičniki nimajo nobenega vpliva na to nastavitveno stran. 

Prav tako pomnite, da ti vtičniki niso del programja MediaWiki, in jih običajno razvijajo ter vzdržujejo uporabniki. Administratorji lahko uredite seznam vtičnikov z uporabo [[Special:Gadgets|posebne strani]] in [[MediaWiki:Gadgets-definition|definicij]].',
	'gadgets' => 'Vtičniki',
	'gadgets-title' => 'Vtičniki',
	'gadgets-pagetext' => 'Spodaj je seznam vtičnikov (opredeljenih z [[MediaWiki:Gadgets-definition|definicijami]]), ki jih lahko uporabniki vključijo v svojih [[Special:Preferences|nastavitvah]]. Ta pregled omogoča enostaven dostop do sistema za nastavljanje opisa in kode vsakega vtičnika posebej.',
	'gadgets-uses' => 'Uporablja',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'prefs-gadgets' => 'геџети',
	'gadgets' => 'геџети',
	'gadgets-title' => 'геџети',
	'gadgets-uses' => 'користи се',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'prefs-gadgets' => 'gedžeti',
	'gadgets' => 'gedžeti',
	'gadgets-title' => 'gedžeti',
	'gadgets-uses' => 'koristi se',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'gadgets-desc' => 'Lät Benutsere in hiere [[Special:Preferences|persöönelke Ienstaalengen]] foardefinierde [[Special:Gadgets|CSS- un JavaScript-Gadgets]] aktivierje',
	'prefs-gadgets' => 'Gadgets',
	'gadgets-prefstext' => 'Lieste fon spezielle Hälpere do der fon älken Benutser aktivierd wäide konnen.
Do Hälpere basierje maastens ap Javascript, deeruum mout Javascript in dän Browser aktivierd weese, uumdät jo funktionierje.
Do Hälpere funktionierje oawers nit ap disse Siede mäd persöönelke Ienstaalengen.

Buutendät is tou beoachtjen, dät disse Hälpere in Algemeenen nit Paat fon MediaWiki sunt, man maast fon
Benutsere fon lokoale Wikis äntwikkeld un fersuurged wäide. Lokoale Wiki-Administratore konnen do ferföichboare Hälpere beoarbaidje. Deerfoar stounde do [[MediaWiki:Gadgets-definition|Definitione]] un [[Special:Gadgets|Beschrieuwengen]] tou Ferföigenge.',
	'gadgets' => 'Gadgets',
	'gadgets-title' => 'Gadgets',
	'gadgets-pagetext' => 'Lieste fon spezielle Hälpere, do der foar älken Benutser in sien [[Special:Preferences|persöönelke Ienstaalengen]] ferföichboar sunt, as [[MediaWiki:Gadgets-definition| definierd]].
Disse Uursicht bjut direkten Tougoang tou do Systemättergjuchte, do ju Beschrieuwenge as uk dän Programkode fon älken Hälper änthoolde.',
	'gadgets-uses' => 'Benutsed',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'gadgets-desc' => 'Matak bisa pamaké milih [[Special:Gadgets|Gajet CSS sarta Javascript]] ngaliwatan [[Special:Preferences|Préferénsi]] maranéhanana',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'gadgets-desc' => 'Låter användare aktivera personliga [[Special:Gadgets|CSS- och JavaScript-finesser]] genom sina [[Special:Preferences|inställningar]]',
	'prefs-gadgets' => 'Finesser',
	'gadgets-prefstext' => 'Härunder finns en lista över finesser som du kan aktivera för ditt konto.
De flesta funktionerna är baserade på JavaScript, så du måste ha JavaScript aktiverat i din webbläsare för att de ska fungera.
Notera att de här tilläggsfunktionerna inte kommer ha någon effekt den här inställningssidan.

Notera också att dessa finesser inte är en del av MediaWiki-programvaran, och är för det mesta utvecklade och underhållna av användare på den här wikin.
Lokala administratörer kan redigera de tillgängliga funktionerna med hjälp av [[MediaWiki:Gadgets-definition|definieringar]] och [[Special:Gadgets|beskrivningar]].',
	'gadgets' => 'Finesser',
	'gadgets-title' => 'Finesser',
	'gadgets-pagetext' => 'Härunder finns en lista över finesser som användare kan aktivera i sina [[Special:Preferences|inställningar]], definierad av [[MediaWiki:Gadgets-definition|definieringarna]].
Den här översikten ger enkel åtkomst till de systemmeddelanden som definierar beskrivningarna och koden för varje finess.',
	'gadgets-uses' => 'Använder',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Mpradeep
 * @author Veeven
 */
$messages['te'] = array(
	'gadgets-desc' => 'వాడుకర్లను వారి [[Special:Preferences|అభిరుచుల]]లో  ప్రత్యేక [[Special:Gadgets|CSS మరియు జావాస్క్రిప్ట్ గాడ్జెట్లను]] ఎంచుకోనిస్తుంది',
	'prefs-gadgets' => 'ఉపకరణాలు',
	'gadgets-prefstext' => 'ఈ దిగువ ఉన్న ప్రత్యేక ఉపకరణాల నుండి సభ్యులు తమకు కావలసినవి టిక్కు పెట్టి మీ ఖాతాకు వీటిని ఎనేబుల్ చేసుకొవచ్చు. ఈ ఉపకరణాలు జావాస్క్రిప్టుపై ఆధారపడి పనిచేస్తాయి కాబట్టి ఇవి సరిగా పనిచెయ్యాలంటే మీ బ్రౌజరులో జావాస్క్రిప్టును ఎనేబుల్ చేసి ఉండాలి. ఈ ఉపకరణాలు అభిరుచుల పేజీపై ఎటువంటి ప్రభావాన్ని కలుగజేయవని గమనించాలి.

అలాగే ఈ ప్రత్యేక ఉపకరణాలు మీడియావికీ సాఫ్టువేరులో భాగము కాదని గమనించాలి. వీటిని సాధారణంగా మీ స్థానిక వికీలోని సభ్యులే తయారుచేసి నిర్వహిస్తూ ఉంటారు. స్థానిక వికీ నిర్వాహకులు లభ్యమయ్యే ఉపకరణాలను [[MediaWiki:Gadgets-definition|ఉపకరణాల నిర్వచన]] మరియు [[Special:Gadgets|ఉపకరణాల వివరణ]] పేజీలను ఉపయోగించి మార్పులుచేర్పులు చేయవచ్చు.',
	'gadgets' => 'ఉపకరణాలు',
	'gadgets-title' => 'ఉపకరణాలు',
	'gadgets-pagetext' => 'ఈ దిగువన ఉన్న ప్రత్యేక ఉపకరణాల నుండి సభ్యులు తమకు కావలసినవి తమ [[Special:Preferences|అభిరుచులు పేజీ]]లోని ఉపకరణాల టాబులో టిక్కు పెట్టి ఎనేబుల్ చేసుకొనే అవకాశం ఉన్నది. వీటిని [[MediaWiki:Gadgets-definition|ఉపకరణాల నిర్వచన]] పేజీలో నిర్వచించడం జరిగింది. ఈ చిన్న పరిచయం ఆయా ఉపకరణాల నిర్వచన మరియు కోడుకు సంబంధించిన మీడియావికీ సందేశాలకు సులువుగా చేరుకునేందుకు లింకులను సమకూర్చుతుంది.',
	'gadgets-uses' => 'ఉపయోగించే ఫైళ్ళు',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'gadgets-desc' => 'Аз тариқи саҳифаи [[Special:Preferences|тарҷиҳот]] ба корбарон имконияти интихоби абзорҳои шахсии [[Special:Gadgets|CSS ва ҶаваСкрипт]]ро медиҳад.',
	'prefs-gadgets' => 'Абзорҳо',
	'gadgets-prefstext' => 'Дар зер феҳристи аз абзорҳои вижаеро мебинед, ки барои ҳисобатон метавонед фаъол кунед. Ин абзорҳо бештар дар асоси ҶаваСкрипт ҳастанд, пас барои истфода аз онҳо бояд ҶаваСкриптро дар мурургаратон фаъол кунед. Таваҷҷӯҳ кунед, ки ин абзорҳо наметавонанд саҳифаи тарҷиҳотро тағйир диҳанд.

Диққат дошта бошед, ки ин абзорҳои ҷузъӣ аз нармафзори МедиаВики нестанд ва ҳамчун яке аз қисмҳои он ба ҳисоб намераванд, ва одатан аз тарафи корбарони ҳар вики сохта ва нигаҳдорӣ мешаванд. Мудирони ҳар вики метавонанд бо истифода аз саҳифаҳои [[MediaWiki:Gadgets-definition]] ва [[Special:Gadgets]] ба вироиши абзорҳо бипардозанд.',
	'gadgets' => 'Абзорҳо',
	'gadgets-title' => 'Абзорҳо',
	'gadgets-pagetext' => 'Дар зер феҳристи абзорҳои вижаро мебинед, ки корбарон метавонанд дар саҳифаи тарҷиҳоти худ мутобиқи [[MediaWiki:Gadgets-definition]] фаъол кунанд. Ин хулоса дастрасии осонро ба саҳифаи пайғомҳои системавӣ, ки шомили тавзеҳот ва коди ҳар абзор аст, пешкаш мекунад.',
	'gadgets-uses' => 'Корбурдҳо',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'gadgets-desc' => 'Az tariqi sahifai [[Special:Preferences|tarçihot]] ba korbaron imkonijati intixobi abzorhoi şaxsiji [[Special:Gadgets|CSS va ÇavaSkript]]ro medihad.',
	'prefs-gadgets' => 'Abzorho',
	'gadgets' => 'Abzorho',
	'gadgets-title' => 'Abzorho',
	'gadgets-uses' => 'Korburdho',
);

/** Thai (ไทย)
 * @author Ans
 * @author Passawuth
 */
$messages['th'] = array(
	'gadgets-desc' => 'ให้ผู้ใช้สามารถเลือกใช้ [[Special:Gadgets|CSS และ จาวาสคริปต์]] ที่สร้างขึ้นเป็นการเฉพาะ ในหน้า [[Special:Preferences|ตั้งค่า]] ได้',
	'prefs-gadgets' => 'อุปกรณ์เสริม',
	'gadgets-prefstext' => 'ด้านล่างเป็นรายการอุปกรณ์เสริม ที่บัญชีผู้ใช้ของคุณสามารถเปิดใช้งานได้
อุปกรณ์เสริมเหล่านี้ส่วนใหญ่จะทำงานผ่านจาวาสคริปต์ ดังนั้นเบราเซอร์ของคุณต้องเปิดใช้งานจาวาสคริปต์จึงจะสามารถใช้อุปกรณ์เสริมเหล่านี้ได้
อย่างไรก็ตามอุปกรณ์เสริมเหล่านี้จะไม่ส่งผลหรือประมวลผลใดๆ ในหน้าตั้งค่านี้

นอกจากนี้อุปกรณ์เสริมพิเศษเหล่านี้ไม่ได้เป็นส่วนหนึ่งของซอฟต์แวร์มีเดียวิกิ แต่พัฒนาและดูแลโดยผู้ใช้งานในวิกิที่คุณใช้อยู่
โดยผู้ดูแลของวิกินั้นๆ สามารถแก้ไขอุปกรณ์เสริมที่มีอยู่ผ่านทางหน้า [[MediaWiki:Gadgets-definition|definition]] และ [[Special:Gadgets|คำอธิบาย]]',
	'gadgets' => 'อุปกรณ์เสริม',
	'gadgets-title' => 'อุปกรณ์เสริม',
	'gadgets-pagetext' => 'รายการด้านล่างเป็นรายการอุปกรณ์เสริมพิเศษที่ผู้ใช้สามารถเปิดใช้ในส่วน[[Special:Preferences|การตั้งค่าส่วนตัว]] อุปกรณ์เสริมทั้งหมดได้ถูกกำหนดไว้ใน [[MediaWiki:Gadgets-definition|ส่วนกำหนดอุปกรณ์เสริม]]
ขณะที่หน้านี้จะกล่าวโดยรวมเกี่ยวกับ คำอธิบายการใช้งาน และ โค้ดของอุปกรณ์เสริมแต่ละตัว',
	'gadgets-uses' => 'เรียกใช้',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'gadgets-desc' => 'Ulanyjylaryň [[Special:Preferences|ileri tutmalarynda]] ýörite [[Special:Gadgets|CSS we JavaScript gajetlerini]] saýlamaklaryna rugsat berýär',
	'prefs-gadgets' => 'Gajetler',
	'gadgets' => 'Gajetler',
	'gadgets-title' => 'Gajetler',
	'gadgets-uses' => 'Ulanýar',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'gadgets-desc' => 'Nagpapahintulot sa mga tagagamit na makapili ng pinasadyang [[Special:Gadgets|mga gadyet na pang-CSS at pang-JavaScript]] sa kanilang [[Special:Preferences|mga kagustuhan]]',
	'prefs-gadgets' => 'Mga gadyet (kasangkapan)',
	'gadgets-prefstext' => "Nasa ibaba ang isang talaan ng mga natatanging kasangkapan (gadyet) na maaari mong paganahin para sa iyong kuwenta/akawnt.
Karamihan sa mga gadyet na ito ang nakaugnay/nakabatay sa ''JavaScript'', kaya dapat na paandarin ang ''JavaScript'' sa iyong pantingin-tingin (''browser'') upang gumana.
Pakitandaang walang magiging epekto sa pahina ng mga kagustuhang ito ang ganitong mga gadyet.

Pakitandaan din na ang mga natatanging gadyet na ito ay hindi kabahagi ng sopwer ng MediaWiki, at karaniwang pinaunlad at pinananatili ng mga tagagamit sa katutubo/lokal mong wiki.
Maaaring baguhin ng pampook/lokal na mga tagapangasiwa ang makukuhang mga gadyet sa pamamagitan ng [[MediaWiki:Gadgets-definition|mga kahulugan]] at [[Special:Gadgets|mga paglalarawan]].",
	'gadgets' => 'Mga gadyet (kasangkapan)',
	'gadgets-title' => 'Mga gadyet (kasangkapan)',
	'gadgets-pagetext' => 'Nasa ibaba ang isang talaan ng natatanging mga kasangkapan (gadyet) na mapapagana ng mga tagagamit sa kanilang [[Special:Preferences|pahina ng mga kagustuhan]], ayon sa nilalarawan ng [[MediaWiki:Gadgets-definition|mga kahulugan]].
Nagbibigay ang pagtalakay na ito ng magaang na daan/akseso patungo sa mga pahina ng sistemang pangmensahe na nagbibigay kahulugan sa paglalarawan at kodigo ng bawat gadyet.',
	'gadgets-uses' => 'Mga mapaggagamitan',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'gadgets-desc' => 'Kullanıcıların [[Special:Preferences|tercihlerinde]] özel [[Special:Gadgets|CSS ve JavaScript gadgetlerini]] seçmelerine izin verir',
	'prefs-gadgets' => 'Gadgetler',
	'gadgets-prefstext' => 'Aşağıdaki, hesabınız için etkinleştirebileceğiniz özel gadgetlerin listesidir.
Bu gadgetler çoğunlukla JavaScript temellidir, bu yüzden çalışmaları için tarayıcınızda JavaScript etkinleştirilmelidir.
Bu gadgetlerin bu tercihler sayfasına bir etkisinin olmayacağını unutmayın.

Ayrıca unutmayın ki, bu özel gadgetler MedyaViki yazılımının bir parçası değildir, ve genellikle yerel vikinizdeki kullanıcılar tarafından geliştirilip, idame ettirilirler.
Yerel yöneticiler [[MediaWiki:Gadgets-definition|tanımları]] ve [[Special:Gadgets|açıklamaları]] kullanarak uygun gadgetleri değiştirebilirler.',
	'gadgets' => 'Gadgetler',
	'gadgets-title' => 'Gadgetler',
	'gadgets-pagetext' => "Aşağıdaki, kullanıcıların [[Special:Preferences|tercihler sayfasında]] etkin hale getirebileceği, [[MediaWiki:Gadgets-definition|tanımlarla]] belirtildiği gibi, özel gadgetlerin bir listesidir.
Bu genel bakış, her gadget'in tanımını ve kodunu belirten sistem mesaj sayfalarına kolay erişim sağlar.",
	'gadgets-uses' => 'Kullanıyor',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'gadgets-desc' => 'Дозволяє користувачам обирати [[Special:Gadgets|CSS- та JavaScript-додатки]] у своїх [[Special:Preferences|налаштуваннях]]',
	'prefs-gadgets' => 'Додатки',
	'gadgets-prefstext' => 'Нижче наведений список спеціальних додатків, які ви можете ввімкнути для свого облікового запису.
Ці додатки переважно базуються на JavaScript, тому ви повинні ввімкнути JavaScript для того, щоб вони працювали.
Зауважте, що ці додатки не працюють на сторінці налаштувань.

Також зауважте, що ці додатки не є частиною MediaWiki і зазвичай розробляються і обслуговуються користувачами локальної вікі.
Адміністратори можуть змінювати список додатків за допомогою сторінок їх [[MediaWiki:Gadgets-definition|визначення]] та [[Special:Gadgets|опису]].',
	'gadgets' => 'Додатки',
	'gadgets-title' => 'Додатки',
	'gadgets-pagetext' => 'Нижче наведений список додатків, які можна ввімкнути на [[Special:Preferences|сторінці налаштувань]]. Список міститься на [[MediaWiki:Gadgets-definition|сторінці визначень]].
Цей список дозволяє легко переглядати системні повідомлення, які містять описи і коди додатків.',
	'gadgets-uses' => 'Використовує',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'gadgets-desc' => 'Consente ai utenti de selezionar [[Special:Gadgets|acessori CSS e JavaScript]] ne le proprie [[Special:Preferences|preferense]]',
	'prefs-gadgets' => 'Acessori',
	'gadgets-prefstext' => "De seguito se cata na lista de acessori speciali (''gadget'') che se pol abilitar par el proprio account.
La mazor parte de sti acessori la se basa su JavaScript, e quindi te ghè da abilitar JavaScript sul to browser se te vol che i funsiona coretamente. Nota che i accessori no i gà nissun efeto in sta pagina de preferense.

Nota anca che sti acessori speciali no i fa parte del software MediaWiki e i vien de solito realizà e gestìi dai utenti de ogni sito wiki. I aministradori del sito i pol modificar la lista dei acessori disponibili tramite le pagine [[MediaWiki:Gadgets-definition|definissioni]] e [[Special:Gadgets|descrissioni]].",
	'gadgets' => 'Acessori',
	'gadgets-title' => 'Acessori',
	'gadgets-pagetext' => "De seguito vien presentà n'elenco de acessori (''gadget'') che i utenti i pol abilitar su la so [[Special:Preferences|pagina de le preferenze]], seguendo le definizion riportà in [[MediaWiki:Gadgets-definition]].
Sta panoramica la fornisse un comodo mecanismo par accédar ai messagi de sistema nei quali xe definìo la descrizion e el codice de ciascun acessorio.",
	'gadgets-uses' => 'Dopara',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'prefs-gadgets' => 'Gadžetad',
	'gadgets' => 'Gadžetad:',
	'gadgets-title' => 'Gadžetad',
	'gadgets-uses' => 'Kävutab',
);

/** Vietnamese (Tiếng Việt)
 * @author Meno25
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'gadgets-desc' => 'Để các thành viên chọn những [[Special:Gadgets|công cụ đa năng]] đặc chế bằng CSS và JavaScript trong [[Special:Preferences|tùy chọn]]',
	'prefs-gadgets' => 'Công cụ đa năng',
	'gadgets-prefstext' => 'Dưới đây là danh sách các công cụ đa năng đặc biệt mà bạn có thể kích hoạt cho tài khoản của mình.
Những công cụ này chủ yếu dựa trên JavaScript, do đó bạn phải kích hoạt JavaScript trong trình duyệt để các công cụ này hoạt động.
Chú ý rằng những công cụ đa năng này sẽ không có tác dụng trong trang tùy chọn cá nhân.

Cũng chú ý rằng những công cụ đặc biệt này không phải là một phần của phần mềm MediaWiki, mà thường được phát triển và bảo trì bởi những thành viên ở wiki của họ. Những quản lý ở từng ngôn ngữ có thể sửa đổi các công cụ đa năng có sẵn từ các danh sách [[MediaWiki:Gadgets-definition|định nghĩa]] và [[Special:Gadgets|miêu tả]].',
	'gadgets' => 'Công cụ đa năng',
	'gadgets-title' => 'Công cụ đa năng',
	'gadgets-pagetext' => 'Dưới đây là danh sách các công cụ đa năng đặc biệt mà thành viên có thể dùng tại [[Special:Preferences|trang tùy chọn cá nhân]] của họ, theo [[MediaWiki:Gadgets-definition|định nghĩa]]. Trang tổng quan này cung cấp cách tiếp cận dễ dàng đến trang các thông báo hệ thống để định nghĩa miêu tả và mã của từng công cụ.',
	'gadgets-uses' => 'Sử dụng',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'gadgets-uses' => 'Gebs',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'gadgets-desc' => '畀用戶響佢哋嘅[[Special:Preferences|喜好設定]]度設定自定嘅[[Special:Gadgets|CSS同埋JavaScript小工具]]',
	'prefs-gadgets' => '小工具',
	'gadgets-prefstext' => '下面係一個特別小工具，你可以響你個戶口度啟用。
呢啲小工具多數都係基於JavaScript建造，如果要開佢哋，噉個瀏覽器嘅JavaScript就需要啟用咗先至用得到。
要留意嘅就係呢啲小工具響呢個喜好設定版度係無效果嘅。

亦都同時留意呢啲小工具嘅特別頁唔係MediaWiki軟件嘅一部份，通常都係由你本地嘅wiki度開發同維護。本地管理員可以響[[MediaWiki:Gadgets-definition]]同埋[[Special:Gadgets]]編輯可以用到嘅小工具。',
	'gadgets' => '小工具',
	'gadgets-title' => '小工具',
	'gadgets-pagetext' => '下面係一個按照[[MediaWiki:Gadgets-definition]]嘅定義特別小工具清單，用戶可以響佢哋嘅喜好設定頁度開佢哋。
呢個概覽提供嘅系統信息頁嘅簡易存取，可以定義每個小工具嘅描述同埋碼。',
	'gadgets-uses' => '用',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'gadgets-desc' => '使用户可以在[[Special:Preferences|参数设置]]中自行设定[[Special:Gadgets|CSS与JavaScript工具]]',
	'prefs-gadgets' => '小工具',
	'gadgets-prefstext' => '以下是一个特殊小工具，您可以在您的账户中激活。
这些小工具多数都是基于JavaScript建造，如果要激活它们，那么浏览器的JavaScript就需要激活后方可使用。
要留意的是这些小工具在这个参数设置页面中是没有效果的。

亦都同时留意这些小工具的特殊页面不是MediaWiki软件的一部份，通常都是由您本地的wiki中开发以及维护。本地管理员可以在[[MediaWiki:Gadgets-definition]]以及[[Special:Gadgets]]编辑可供使用的小工具。',
	'gadgets' => '小工具',
	'gadgets-title' => '小工具',
	'gadgets-pagetext' => '以下是一个按照[[MediaWiki:Gadgets-definition]]定义的特殊小工具列表，用户可以在他们的参数设置页面中激活它们。
通过这个概览可以方便的获得系统信息页面，从而可以定义每个小工具的描述以及源码。',
	'gadgets-uses' => '使用',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'gadgets-desc' => '讓使用者可以在[[Special:Preferences|偏好設定]]中自訂 [[Special:Gadgets|CSS與JavaScript工具]]',
	'prefs-gadgets' => '小工具',
	'gadgets-prefstext' => '以下是一個特殊小工具，您可以在您的帳戶中啟用。
這些小工具多數都是基於JavaScript建造，如果要啟用它們，那麼瀏覽器的JavaScript就需要啟用後方可使用。
要留意的是這些小工具在這個參數設置頁面中是沒有效果的。

亦都同時留意這些小工具的特殊頁面不是MediaWiki軟件的一部份，通常都是由您本地的wiki中開發以及維護。本地管理員可以在[[MediaWiki:Gadgets-definition]]以及[[Special:Gadgets]]編輯可供使用的小工具。',
	'gadgets' => '小工具',
	'gadgets-title' => '小工具',
	'gadgets-pagetext' => '以下是一個按照[[MediaWiki:Gadgets-definition]]的定義特殊小工具清單，用戶可以在它們的參數設置頁面中啟用它們。
這個概覽提供的系統資訊頁面的簡易存取，可以定義每個小工具的描述以及原碼。',
	'gadgets-uses' => '使用',
);

