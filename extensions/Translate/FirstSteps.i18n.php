<?php
/**
 * %Messages for Special:FirstSteps of the Translate extension.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$messages = array();

/** English
 * @author Nike
 * @author Siebrand
 */
$messages['en'] = array(
	'firststeps' => 'First steps',
	'firststeps-desc' => '[[Special:FirstSteps|Special page]] for getting users started on a wiki using the Translate extension',
	'translate-fs-pagetitle-done' => ' - done!',
	'translate-fs-pagetitle-pending' => ' - pending',
	'translate-fs-pagetitle' => 'Getting started wizard - $1',
	'translate-fs-signup-title' => 'Sign up',
	'translate-fs-settings-title' => 'Configure your preferences',
	'translate-fs-userpage-title' => 'Create your user page',
	'translate-fs-permissions-title' => 'Request translator permissions',
	'translate-fs-target-title' => 'Start translating!',
	'translate-fs-email-title' => 'Confirm your e-mail address',

	'translate-fs-intro' => "Welcome to the {{SITENAME}} first steps wizard.
You will be guided through the process of becoming a translator step by step.
In the end you will be able to translate ''interface messages'' of all supported projects at {{SITENAME}}.",

	'translate-fs-selectlanguage' => "Pick a language",
	'translate-fs-settings-planguage' => "Primary language:",
	'translate-fs-settings-planguage-desc' => "The primary language doubles as your interface language on this wiki
and as default target language for translations.",
	'translate-fs-settings-slanguage' => "Assistant language $1:",
	'translate-fs-settings-slanguage-desc' => "It is possible to show translations of messages in other languages in the translation editor.
Here you can choose which languages, if any, you would like to see.",
	'translate-fs-settings-submit' => "Save preferences",
	'translate-fs-userpage-level-N' => 'I am a native speaker of',
	'translate-fs-userpage-level-5' => 'I am a professional translator of',
	'translate-fs-userpage-level-4' => 'I know it like a native speaker',
	'translate-fs-userpage-level-3' => 'I have a good command of',
	'translate-fs-userpage-level-2' => 'I have a moderate command of',
	'translate-fs-userpage-level-1' => 'I know a little',
	'translate-fs-userpage-help' => 'Please indicate your language skills and tell us something about yourself. If you know more than five languages you can add more later. ',
	'translate-fs-userpage-submit' => 'Create my userpage',
	'translate-fs-userpage-done' => 'Well done! You now have an user page.',
	'translate-fs-permissions-planguage' => "Primary language:",
	'translate-fs-permissions-help' => 'Now you need to place a request to be added to the translator group.
Select the primary language you are going to translate to.

You can mention other languages and other remarks in textbox below.',
	'translate-fs-permissions-pending' => 'Your request has been submitted to [[$1]] and someone from the site staff will check it as soon as possible.
If you confirm your e-mail address, you will get an e-mail notification as soon as it happens.',
	'translate-fs-permissions-submit' => 'Send request',
	'translate-fs-target-text' => 'Congratulations!
You can now start translating.

Do not be afraid if it still feels new and confusing to you.
At [[Project list]] there is an overview of projects you can contribute translations to.
Most of the projects have a short description page with a "\'\'Translate this project\'\'" link, that will take you to a page which lists all untranslated messages.
A list of all message groups with the [[Special:LanguageStats|current translation status for a language]] is also available.

If you feel that you need to understand more before you start translating, you can read the [[FAQ|Frequently asked questions]].
Unfortunately documentation can be out of date sometimes.
If there is something that you think you should be able to do, but cannot find out how, do not hesitate to ask it at the [[Support|support page]].

You can also contact fellow translators of the same language at [[Portal:$1|your language portal]]\'s [[Portal_talk:$1|talk page]].
If you have not already done so, [[Special:Preferences|change your user interface language to the language you want to translate in]], so that the wiki is able to show the most relevant links for you.',

	'translate-fs-email-text' => 'Please provide your e-mail address in [[Special:Preferences|your preferences]] and confirm it from the e-mail that is sent to you.

This allows other users to contact you by e-mail.
You will also receive newsletters at most once a month.
If you do not want to receive newsletters, you can opt-out in the tab "{{int:prefs-personal}}" of your [[Special:Preferences|preferences]].',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Lloffiwr
 * @author Purodha
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'translate-fs-signup-title' => '{{Identical|Sign up}}',
	'translate-fs-selectlanguage' => "Default value in language selector, acts as 'nothing chosen'",
	'translate-fs-settings-planguage' => 'Label for choosing interface language, followed by language selector',
	'translate-fs-settings-planguage-desc' => 'Help message for choosing interface language',
	'translate-fs-settings-slanguage' => 'Other languages shown while translating, followed by language selector, $1 is running number',
	'translate-fs-settings-slanguage-desc' => 'Help message for choosing assistant languages',
	'translate-fs-settings-submit' => 'Submit button',
	'translate-fs-userpage-level-N' => 'A language skill level option.
It is used inside a selector, which is followed by another selector, where you choose a language.
Wording of this message may refer to it per "this language" or "the selected language", for example.

The data collected via the pair of selectors will later be used in the <code>{<!-- -->{#Babel|&hellip;}}</code> context.',
	'translate-fs-userpage-level-5' => 'A language skill level option.
It is used inside a selector, which is followed by another selector, where you choose a language.
Wording of this message may refer to it per "this language" or "the selected language", for example.

The data collected via the pair of selectors will later be used in the <code>{<!-- -->{#Babel|&hellip;}}</code> context.',
	'translate-fs-userpage-level-4' => 'A language skill level option.
It is used inside a selector, which is followed by another selector, where you choose a language.
Wording of this message may refer to it per "this language" or "the selected language", for example.

The data collected via the pair of selectors will later be used in the <code>{<!-- -->{#Babel|&hellip;}}</code> context.',
	'translate-fs-userpage-level-3' => 'A language skill level option.
It is used inside a selector, which is followed by another selector, where you choose a language.
Wording of this message may refer to it per "this language" or "the selected language", for example.

The data collected via the pair of selectors will later be used in the <code>{<!-- -->{#Babel|&hellip;}}</code> context.',
	'translate-fs-userpage-level-2' => 'A language skill level option.
It is used inside a selector, which is followed by another selector, where you choose a language.
Wording of this message may refer to it per "this language" or "the selected language", for example.

The data collected via the pair of selectors will later be used in the <code>{<!-- -->{#Babel|&hellip;}}</code> context.',
	'translate-fs-userpage-level-1' => 'A language skill level option.
It is used inside a selector, which is followed by another selector, where you choose a language.
Wording of this message may refer to it per "this language" or "the selected language", for example.

The data collected via the pair of selectors will later be used in the <code>{<!-- -->{#Babel|&hellip;}}</code> context.',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author ترجمان05
 * @author روخو
 */
$messages['ar'] = array(
	'firststeps' => 'الخطوات الأولى',
	'translate-fs-pagetitle-done' => '- تمّ!',
	'translate-fs-pagetitle-pending' => ' - معلقة',
	'translate-fs-pagetitle' => 'بدأ الحصول على المعالج  - $1',
	'translate-fs-signup-title' => 'سجّل',
	'translate-fs-settings-title' => 'اضبط تفضيلاتك',
	'translate-fs-userpage-title' => 'أنشئ صفحة المستخدم',
	'translate-fs-permissions-title' => 'اطلب صلاحيات مترجم',
	'translate-fs-target-title' => 'ابدأ الترجمة!',
	'translate-fs-email-title' => 'أكّد عنوان بريدك الإلكتروني',
	'translate-fs-selectlanguage' => 'اختر اللغة',
	'translate-fs-settings-planguage' => 'اللغة الأساسية:',
	'translate-fs-settings-slanguage' => 'مساعد لغوي $1:',
	'translate-fs-userpage-level-5' => 'أنا مترجم محترف في',
	'translate-fs-userpage-level-3' => 'لدي نزعة قيادية جيدة في',
	'translate-fs-userpage-level-2' => 'لدي نزعة قيادية متوسطة في',
	'translate-fs-userpage-level-1' => 'أعرف القليل',
	'translate-fs-userpage-help' => 'يرجى الإشارة إلى مهاراتك اللغوية واخبرنا شيئا عن نفسك. إذا كنت تعرف أكثر من خمس لغات يمكنك إضافة المزيد لاحقا.',
	'translate-fs-userpage-submit' => 'أنشئ صفحة المستخدم',
	'translate-fs-userpage-done' => 'أحسنت! لديك الآن صفحة مستخدم.',
	'translate-fs-permissions-planguage' => 'اللغة الأساسية:',
	'translate-fs-permissions-help' => 'الآن تحتاج إلى لطلب مكان تضاف فيه إلى مجموعة مترجمين.

حدد اللغة الأساسية أنت سوف تترجم الى.

يمكنك ذكر لغات وملاحظات أخرى في مربع النص أدناه.',
	'translate-fs-permissions-submit' => 'إرسال طلب',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'firststeps' => 'Primeros pasos',
	'firststeps-desc' => "[[Special:FirstSteps|Páxina especial]] pa los usuarios que principien con una wiki qu'use la estensión Translate",
	'translate-fs-pagetitle-done' => '- ¡fecho!',
	'translate-fs-pagetitle-pending' => ' - pendiente',
	'translate-fs-pagetitle' => 'Asistente pa los primeros pasos - $1',
	'translate-fs-signup-title' => "Date d'alta",
	'translate-fs-settings-title' => 'Configura les tos preferencies',
	'translate-fs-userpage-title' => "Crea la to páxina d'usuariu",
	'translate-fs-permissions-title' => 'Pidi permisos de traductor',
	'translate-fs-target-title' => '¡Comienza a traducir!',
	'translate-fs-email-title' => 'Confirma la to direición de corréu',
	'translate-fs-intro' => "Bienveníu al asistente pa dar los primeros pasos en {{SITENAME}}.
Vamos guiate, pasu ente pasu, pel procesu de convertite nun traductor.
Cuando acabes, podrás traducir los ''mensaxes de la interfaz'' de tolos proyeutos sofitaos en {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Escueyi una llingua',
	'translate-fs-settings-planguage' => 'Llingua principal:',
	'translate-fs-settings-planguage-desc' => 'A llingua principal ye tanto la llingua de la interfaz de la wiki
como la llingua predeterminada pa facer les traducciones.',
	'translate-fs-settings-slanguage' => "Llingua d'ayuda $1:",
	'translate-fs-settings-slanguage-desc' => 'Ye posible amosar les traducciones de los mensaxes a otres llingües ne editor de traducciones.
Equí pues escoyer qué llingües quies ver, si quies dalguna.',
	'translate-fs-settings-submit' => 'Guardar les preferencies',
	'translate-fs-userpage-level-N' => 'Soi falante nativu de',
	'translate-fs-userpage-level-5' => 'Soi traductor profesional de',
	'translate-fs-userpage-level-4' => 'La conozo como un falante nativu',
	'translate-fs-userpage-level-3' => 'Tengo un bon dominiu de',
	'translate-fs-userpage-level-2' => 'Tengo un dominiu moderáu de',
	'translate-fs-userpage-level-1' => 'Se un poco de',
	'translate-fs-userpage-help' => 'Indica les tos capacidaes llingüístiques y cunta daqué tocante a ti. Si sabes más de cinco llingües pues amestales más alantre.',
	'translate-fs-userpage-submit' => "Crear la mio páxina d'usuariu",
	'translate-fs-userpage-done' => "¡Bien fecho! Agora tienes una páxina d'usuariu.",
	'translate-fs-permissions-planguage' => 'Llingua principal:',
	'translate-fs-permissions-help' => "Agora tienes de facer una solicitú pa que t'amiesten al grupu de traductores.
Seleiciona la llingua principal a la que vas a traducir.

Pues mentar más llingües y otros comentarios nel cuadru de testu d'abaxo.",
	'translate-fs-permissions-pending' => "La to solicitú s'unvió a «[[$1]]» y dalguién del equipu d'esi sitiu la revisará tan ceo como pueda.
Si confirmes la to direición de corréu electrónicu, recibirás un avisu pel corréu cuando lo faiga.",
	'translate-fs-permissions-submit' => 'Unviar la solicitú',
	'translate-fs-target-text' => "¡Felicidaes!
Agora pues comenzar a traducir.

Nun tengas mieu si te paez nuevo y te confunde.
Na [[Project list]] hai una vista xeneral de los proyeutos nos que pues collaborar coles tos traducciones.
La mayoría de los proyeutos tien una páxina de descripción curtia con un enllaz \"''Traducir esti proyeutu''\", que te llevará a una páxina cola llista de tollos mensaxes por traducir.
Tamién ta disponible la llista de tolos grupos de mensaxes col [[Special:LanguageStats|estáu actual de la traducción a una llingua]].

Si crees que necesites entender más enantes de principiar coles traducciones, pues lleer les [[FAQ|Entrugues frecuentes]].
Por desgracia la documentación pue tar ensin actualizar dacuando.
Si hai dalgo que crees que podríes facer, pero nun yes a alcontrar cómo, nun duldes n'entrugalo na [[Support|páxina de sofitu]].

Tamién pues ponete en contautu con otros traductores a la mesma llingua na [[Portal_talk:\$1|páxina d'alderique]] del [[Portal:\$1|portal de la to llingua]].
Si nun lo ficisti entá, [[Special:Preferences|camuda la llingua de la interfaz d'usuariu a la llingua a la que quies traducir]], pa que la wiki te pueda amosar los enllaces más relevantes pa ti.",
	'translate-fs-email-text' => 'Por favor da la to direición de corréu electrónicu nes tos [[Special:Preferences|preferencies]] y confírmala dende\'l corréu que vamos unviate.

Esto permite qu\'otros usuarios se pongan en contautu contigo per corréu.
Tamién recibirás boletinos de noticies tolo más una vegada al mes.
Si nun quies recibir boletinos de noticies, pues desapuntate na llingüeta "{{int:prefs-personal}}" de les tos [[Special:Preferences|preferencies]].',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'firststeps' => 'Тәүге аҙымдар',
	'firststeps-desc' => 'Викилағы тәржемә киңәйеүен ҡуллана башлаусы яңы ҡатнашыусылар өсөн [[Special:FirstSteps|Махсус бит]]',
	'translate-fs-pagetitle-done' => ' — булды!',
	'translate-fs-pagetitle' => 'Башланғыс өйрәнеү программаһы — $1',
	'translate-fs-signup-title' => 'Теркәлегеҙ',
	'translate-fs-settings-title' => 'Көйләгеҙ',
	'translate-fs-userpage-title' => 'Үҙегеҙҙең ҡатнашыусы битен булдырығыҙ',
	'translate-fs-permissions-title' => 'Тәржемәсе хоҡуҡтарын һорағыҙ',
	'translate-fs-target-title' => 'Тәржемә итә башлағыҙ!',
	'translate-fs-email-title' => 'Электрон почта адресығыҙҙы раҫлағыҙ',
	'translate-fs-intro' => '{{SITENAME}} башланғыс өйрәнеү программаһына рәхим итегеҙ.
Һеҙ тәржемәселәр өйрәнеү программаһы буйынса аҙымлап үтерһегеҙ.
Әҙерлек үтеү менән, һеҙ {{SITENAME}} проектында мөмкин булған бөтә интерфейс яҙмаларын тәржемә итә аласаҡһығыҙ.',
	'translate-fs-userpage-submit' => 'Минең ҡатнашыусы битен булдырырға',
	'translate-fs-userpage-done' => 'Бик яҡшы! Хәҙер һеҙҙең ҡатнашыусы битегеҙ бар.',
	'translate-fs-target-text' => "Ҡотлайбыҙ!
Хәҙер һеҙ тәржемә итә башлай алаһығыҙ.

Әгәр нимәлер һеҙгә һаман да яңы һәм буталған һымаҡ күренһә, ҡурҡмағыҙ.
[[Project list|Проекттар битендә]] һеҙ тәржемә итә алған проекттар исемлеге бар.
Проекттарҙың күпселегенең ҡыҫҡаса тасуирламаһы һәм бөтә тәржемә ителмәгән яҙмалар исемлеге менән биткә барған ''«Был проектты тәржемә итергә»'' һылтанмаһы бар.
Шулай уҡ [[Special:LanguageStats|тел өсөн хәҙерге тәржемә статусы]] күрһәтелгән бөтә яҙмалар төркөмө исемлеге бар.

Әгәр һеҙгә тәржемә итер алдынан күберәк мәғлүмәт алырға кәрәк һымаҡ күренһә, һеҙ [[FAQ|йыш бирелгән һорауҙар]] менән таныша алаһығыҙ.
Ҡыҙғанысҡа ҡаршы, ҡайһы бер мәғлүмәт иҫкергән булыуы мөмкин.
Әгәр нимәнелер, һеҙҙең уйығыҙса, эшләй алаһығыҙ, әммә нисек эшләргә белмәйһегеҙ икән, [[Support|ярҙам битендә]] был турала һорарға оялмағыҙ.

Һеҙ шулай уҡ тәржемәселәр менән [[Portal:$1|һеҙҙең тел порталының]] [[Portal_talk:$1|фекерләшеү битендә]] аралаша алаһығыҙ.
Әгәр һеҙ быларҙы әле эшләмәһәгеҙ, үҙегеҙҙең [[Special:Preferences|көйләүҙәр битендә]] ниндәй телгә тәржемә итергә йыйынаһығыҙ, шул телде күрһәтегеҙ, һәм кәрәкле һылтанмалар интерфейста күрһәтеләсәк.",
	'translate-fs-email-text' => 'Зинһар, үҙегеҙҙең [[Special:Preferences|көйләү битендә]] электрон почта адресығыҙҙы күрһәтегеҙ һәм уны ебәреләсәк хат аша раҫлағыҙ.

Был башҡа ҡатнашыусыларға һеҙҙең менән электрон почта аша аралашырға мөмкинлек бирәсәк.
Һеҙ шулай уҡ айына бер яңылыҡтар алып торасаҡһығыҙ.
Әгәр һеҙ яңылыҡтар алырға теләмәһәгеҙ, һеҙ унан [[Special:Preferences|көйләүҙәр битендә]],  «{{int:prefs-personal}}» бүлегендә баш тарта алаһығыҙ.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'firststeps' => 'Першыя крокі',
	'firststeps-desc' => '[[Special:FirstSteps|Спэцыяльная старонка]] для пачатку працы з пашырэньнем Translate',
	'translate-fs-pagetitle-done' => ' — зроблена!',
	'translate-fs-pagetitle' => 'Майстар пачатковага навучаньня — $1',
	'translate-fs-signup-title' => 'Зарэгіструйцеся',
	'translate-fs-settings-title' => 'Вызначыце Вашыя налады',
	'translate-fs-userpage-title' => 'Стварыце Вашую старонку ўдзельніка',
	'translate-fs-permissions-title' => 'Запытайце правы перакладчыка',
	'translate-fs-target-title' => 'Пачніце перакладаць!',
	'translate-fs-email-title' => 'Пацьвердзіць Ваш адрас электроннай пошты',
	'translate-fs-intro' => "Запрашаем у майстар пачатковага навучаньня {{GRAMMAR:родны|{{SITENAME}}}}.
Вас правядуць праз працэс станаўленьня перакладчыкам крок за крокам.
Пасьля гэтага Вы зможаце перакладаць ''паведамленьні інтэрфэйсу'' ўсіх праектаў, якія падтрымліваюцца ў {{GRAMMAR:месны|{{SITENAME}}}}.",
	'translate-fs-selectlanguage' => 'Выберыце мову',
	'translate-fs-settings-planguage' => 'Асноўная мова:',
	'translate-fs-settings-planguage-desc' => 'Асноўная мова выступае ў ролі як мовы інтэрфэйсу, гэтак і перадвызначанай мовы перакладу.',
	'translate-fs-settings-slanguage' => 'Дапаможная мова $1:',
	'translate-fs-settings-slanguage-desc' => 'Існуе магчымасьць паказваць пераклады паведамленьняў на іншыя мовы ў акне рэдактара перакладаў.
Тут Вы можаце выбраць мовы, калі патрэбна, на якіх будуць паказвацца падобныя пераклады.',
	'translate-fs-settings-submit' => 'Захаваць налады',
	'translate-fs-userpage-level-N' => 'Мая родная мова',
	'translate-fs-userpage-submit' => 'Стварыць маю старонку ўдзельніка',
	'translate-fs-userpage-done' => 'Выдатна! Цяпер Вы маеце старонку ўдзельніка.',
	'translate-fs-permissions-planguage' => 'Асноўная мова:',
	'translate-fs-permissions-submit' => 'Даслаць запыт',
	'translate-fs-target-text' => "Віншуем!
Цяпер Вы можаце пачаць перакладаць.

Не бойцеся, калі што-небудзь здаецца Вам новым і незразумелым.
У [[Project list|сьпісе праектаў]] знаходзіцца агляд праектаў, для якіх Вы можаце перакладаць.
Большасьць праектаў мае старонку з кароткім апісаньнем са спасылкай «''Перакласьці гэты праект''», якая перанясе Вас на старонку са сьпісам усіх неперакладзеных паведамленьняў.
Таксама даступны сьпіс усіх групаў паведамленьняў з [[Special:LanguageStats|цяперашнім статусам перакладу для мовы]].

Калі Вам здаецца, што неабходна даведацца болей перад пачаткам перакладаў, Вы можаце пачытаць [[FAQ|адказы на частыя пытаньні]].
На жаль дакумэнтацыя можа быць састарэлай.
Калі ёсьць што-небудзь, што, як Вы мяркуеце, Вы можаце зрабіць, але ня ведаеце як, не вагаючыся пытайцеся на [[Support|старонцы падтрымкі]].

Таксама, Вы можаце зьвязацца з перакладчыкамі на Вашую мову на [[Portal_talk:$1|старонцы абмеркаваньня]] [[Portal:$1|парталу Вашай мовы]].
Калі Вы яшчэ гэтага не зрабілі, Вы можаце [[Special:Preferences|зьмяніць Вашыя моўныя налады інтэрфэйсу на мову, на якую жадаеце перакладаць]], для таго каб вікі паказала Вам адпаведныя спасылкі.",
	'translate-fs-email-text' => 'Калі ласка, падайце адрас Вашай электроннай пошты ў [[Special:Preferences|Вашых наладах]] і пацьвердзіце яго з электроннага ліста, які будзе Вам дасланы.

Гэта дазволіць іншым удзельнікам зносіцца з Вамі праз электронную пошту.
Таксама, Вы будзеце атрымліваць штомесячныя лісты з навінамі.
Калі Вы не жадаеце атрымліваць лісты з навінамі, Вы можаце адмовіцца ад іх на закладцы «{{int:prefs-personal}}» Вашых [[Special:Preferences|наладаў]].',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'firststeps' => 'Първи стъпки',
	'translate-fs-signup-title' => 'Регистриране',
	'translate-fs-userpage-done' => 'Готово! Вече имате потребителска страница.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'translate-fs-pagetitle-done' => ' - সম্পন্ন!',
	'translate-fs-userpage-title' => 'আপনার ব্যবহারকারী পাতা তৈরি করুন',
);

/** Tibetan (བོད་ཡིག)
 * @author Freeyak
 */
$messages['bo'] = array(
	'firststeps' => 'ཐོག་མའི་གོམ་པ།',
	'translate-fs-pagetitle-done' => '- འགྲིག་སོང་།',
	'translate-fs-signup-title' => 'ཐོ་འགོད་པ།',
	'translate-fs-userpage-title' => 'སྤྱོད་མིའི་ཤོག་ངོས་གསར་བཟོ།',
	'translate-fs-permissions-title' => 'སྐད་སྒྱུར་བའི་ཆོག་འཆན་ཞུ་བ།',
	'translate-fs-target-title' => 'སྐད་སྒྱུར་འགོ་འཛུགས་པ།',
	'translate-fs-email-title' => 'ཁྱེད་ཀྱི་གློག་འཕྲིན་ཁ་བྱང་གཏན་འཁེལ་བྱེད་པ།',
	'translate-fs-userpage-submit' => 'ངའི་སྤྱོད་མིའི་ཤོག་ངོས་བཟོ་བ།',
	'translate-fs-userpage-done' => 'ཡག་པོ་བྱུང་། ད་ནི་ཁྱོད་ལ་སྤྱོད་མིའི་ཤོག་ངོས་ཡོད།',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'firststeps' => 'Pazenn gentañ',
	'firststeps-desc' => '[[Special:FirstSteps|Pajenn dibar]] evit hentañ an implijerien war ur wiki hag a implij an astenn Translate',
	'translate-fs-pagetitle-done' => ' - graet !',
	'translate-fs-pagetitle-pending' => ' - war ober',
	'translate-fs-pagetitle' => "Heñcher loc'hañ - $1",
	'translate-fs-signup-title' => 'En em enskrivañ',
	'translate-fs-settings-title' => 'Kefluniañ ho arventennoù',
	'translate-fs-userpage-title' => 'Krouiñ ho fajenn implijer',
	'translate-fs-permissions-title' => 'Goulennit an aotreoù troer',
	'translate-fs-target-title' => 'Kregiñ da dreiñ !',
	'translate-fs-email-title' => "Kadarnait ho chomlec'h postel",
	'translate-fs-intro' => "Deuet mat oc'h er skoazeller evit pazioù kentañ {{SITENAME}}.
Emaomp o vont da hentañ ac'hanoc'h paz ha paz evit dont da vezañ un troer.
E fin an hentad e c'helloc'h treiñ \"kemennadennoù etrefas\" an holl raktresoù meret gant {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Dibab ur yezh',
	'translate-fs-settings-planguage' => 'Yezh pennañ :',
	'translate-fs-settings-submit' => 'Enrollañ ar penndibaboù',
	'translate-fs-userpage-level-N' => 'A-vihanik e komzan',
	'translate-fs-userpage-level-5' => 'Troer a-vicher on war ar',
	'translate-fs-userpage-level-4' => 'Evel ur yezher a-vihanik e komzan',
	'translate-fs-userpage-level-3' => 'Ampart on war ar',
	'translate-fs-userpage-level-2' => "Barrek a-walc'h on war ar",
	'translate-fs-userpage-level-1' => 'Un tammig e ouzon ar',
	'translate-fs-userpage-submit' => 'Krouiñ ma fajenn implijer',
	'translate-fs-userpage-done' => "Dispar ! Ur bajenn implijer hoc'h eus bremañ.",
	'translate-fs-permissions-planguage' => 'Yezh pennañ :',
	'translate-fs-permissions-submit' => 'Kas ar goulenn',
	'translate-fs-target-text' => "Gourc'hemennoù !
Kregiñ da dreiñ a c'hallit ober bremañ.

Arabat bezañ chalet ma seblant pep tra bezañ nevez ha divoas.
E [[Project list|Roll ar raktresoù]] e c'hallit kaout ur sell war an holl raktresoù a c'hallit kemer perzh en o zroidigezh.
Ar pep brasañ eus ar raktresoù zo bet savet evito ur bajenn warni un deskrivadur berr gant ul liamm \"''Troit ar raktres-mañ''\", a gaso ac'hanoc'h d'ur bajenn ma kavot an holl gemennadennoù didro.
Gallout a c'haller kaout ivez roll an holl gemennadennoù dre strollad dre [[Special:LanguageStats|stad an troidigezhioù en ur yezh bennak]].

Ma soñj deoc'h eo ret deoc'h kompren gwelloc'h an traoù a-raok stagañ ganti, e c'hallit lenn [[FAQ|Foar ar Goulennoù]].
Diwallit, a-wezhioù e c'hall bezañ blaz ar c'hozh gant an titouroù.
Ma soñj deoc'h ez eus un dra bennak a zlefec'h bezañ gouest d'ober ha ma ne gavit ket, kit da c'houlenn war [[Support|ar bajenn skoazell]].

Gallout a rit ivez mont e darempred gant ho keneiled troourien a ra gant ho yezh war [[Portal_talk:\$1|pajenn gaozeal]] [[Portal:\$1|ar porched evit ho yezhl]].
Mar n'eo ket bet graet ganeoc'h c'hoazh e c'hallit [[Special:Preferences|lakaat yezh hoc'h etrefas implijer er yezh a fell deoc'h treiñ enni]]. Evel-se e c'hallo ar wiki kinnig deoc'h al liammoù a zere ar gwellañ evideoc'h.",
	'translate-fs-email-text' => "Lakait ho chomlec'h postel en [[Special:Preferences|ho penndibaboù]] ha kadarnait dre ar postel a vo kaset deoc'h.

Evel-se e c'hallo an implijerien all mont e darempred ganeoc'h dre bostel.
Keleier a resevot ivez ur wezh ar miz.
Mar ne fell ket deoc'h resev keleier e c'hallit disteuler anezho dre ivinell \"{{int:prefs-personal}}\" en ho [[Special:Preferences|penndibaboù]].",
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Palapa
 */
$messages['bs'] = array(
	'firststeps' => 'Prvi koraci',
	'firststeps-desc' => '[[Special:FirstSteps|Posebna stranica]] za pomoć korisnicima koji počinju sa wiki korištenjem proširenja za prevod',
	'translate-fs-pagetitle-done' => ' - urađeno!',
	'translate-fs-pagetitle' => 'Čarobnjak za početak - $1',
	'translate-fs-signup-title' => 'Prijavite se',
	'translate-fs-settings-title' => 'Podesi svoje postavke',
	'translate-fs-userpage-title' => 'Napravi svoju korisničku stranicu',
	'translate-fs-permissions-title' => 'Zahtijevaj prevodilačku dozvolu',
	'translate-fs-target-title' => 'Počni prevoditi!',
	'translate-fs-email-title' => 'Potvrdi svoju e-mail adresu',
	'translate-fs-intro' => "Dobro došli u čarobnjak za prve korake na {{SITENAME}}.
Ovaj čarobnjak će vas postepeno voditi kroz proces dobijanja prava prevodioca.
Na kraju ćete moći prevoditi ''poruke interfejsa'' svih podržanih projekata na {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Napravi moju korisničku stranicu',
	'translate-fs-userpage-done' => 'Odlično urađeno! Sada imate korisničku stranicu.',
	'translate-fs-target-text' => 'Čestitamo!
Sad možete početi prevoditi.

Ne plašite se ako se još osjećate novi i zbunjeni.
Na stranici [[Project list]] postavljen je pregled projekata na kojima možete raditi na prevodu.
Najveći dio projekata ima stranicu sa kratkim opisom sa linkom "\'\'Prevedite ovaj projekat\'", koji će vas odvesti na stranicu sa spiskom svih neprevedenih poruka.
Spisak svih grupa poruka sa [[Special:LanguageStats|trenutnim stanjem prevoda za jezik]] je također dostupan.
Ako želite da shvatite više o samom prevođenju prije nego što počnete, možete pročitati [[FAQ|Najčešće postavljana pitanja]].
Nažalost, dokumentacija nekad može biti zastarjela.
Ako nađete nešto što mislite da možete da uradite, a ne znate kako, ne ustručavajte se da pitate na [[Support|stranici za podršku]].

Također možete kontaktirati prijatelje prevodioce na isti jezik na[[Portal_talk:$1|stranici za razgovor]] [[Portal:$1|portala vašeg jezika]].
Ako već niste uradili, [[Special:Preferences|promijenite vaš jezik interfejsa na jezik na koji želite prevoditi]], tako će wiki biti u mogućnosti da vam prikaže najvažnije linkove za vas.',
	'translate-fs-email-text' => 'Molimo navedite vašu e-mail adresu u [[Special:Preferences|vašim postavkama]] i potvrdite je iz vašeg e-maila koji vam je poslan.

Ovo omogućava drugim korisnicima da vas kontaktiraju putem e-maila.
Također ćete dobijati novosti najviše jednom mjesečno.
Ako ne želite primati novosti, možete se odjaviti na jezičku "{{int:prefs-personal}}" u vašim [[Special:Preferences|postavkama]].',
);

/** Catalan (Català)
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'firststeps' => 'Primers passos',
	'translate-fs-pagetitle-done' => ' - fet!',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'firststeps' => 'První kroky',
	'firststeps-desc' => '[[Special:FirstSteps|Speciální stránka]] pomáhající uživatelům začít pracovat na wiki s rozšířením Translate',
	'translate-fs-pagetitle-done' => ' – hotovo!',
	'translate-fs-pagetitle-pending' => ' – probíhá',
	'translate-fs-pagetitle' => 'Průvodce začátkem – $1',
	'translate-fs-signup-title' => 'Registrace',
	'translate-fs-settings-title' => 'Úprava nastavení',
	'translate-fs-userpage-title' => 'Založení uživatelské stránky',
	'translate-fs-permissions-title' => 'Žádost o překladatelská práva',
	'translate-fs-target-title' => 'Začněte překládat!',
	'translate-fs-email-title' => 'Ověření e-mailové adresy',
	'translate-fs-intro' => "Vítejte v průvodci prvními kroky po {{grammar:7sg|{{SITENAME}}}}.
Provedeme vás všemi kroky, které jsou třeba, abyste se {{gender:|mohl stát překladatelem|mohla stát překladatelkou|mohli stát překladateli}}.
Na konci budete moci překládat ''zprávy uživatelského rozhraní'' všech projektů podporovaných na {{grammar:6sg|{{SITENAME}}}}.",
	'translate-fs-selectlanguage' => 'Vyberte jazyk',
	'translate-fs-settings-planguage' => 'Primární jazyk:',
	'translate-fs-settings-planguage-desc' => 'Primární jazyk slouží na této wiki i jako jazyk pro vaše rozhraní
a jako implicitní cílový jazyk pro překlady.',
	'translate-fs-settings-slanguage' => 'Pomocný jazyk $1:',
	'translate-fs-settings-slanguage-desc' => 'V editoru překladů je možné zobrazovat překlady zpráv do jiných jazyků.
Zde si můžete zvolit, které jazyky, pokud vůbec nějaké, chcete vidět.',
	'translate-fs-settings-submit' => 'Uložit nastavení',
	'translate-fs-userpage-level-N' => 'Jsem rodilý mluvčí jazyka',
	'translate-fs-userpage-level-5' => 'Jsem profesionální překladatel jazyka',
	'translate-fs-userpage-level-4' => 'Jazyk ovládám jako rodilý mluvčí',
	'translate-fs-userpage-level-3' => 'Mám dobrou znalost jazyka',
	'translate-fs-userpage-level-2' => 'Mám průměrnou znalost jazyka',
	'translate-fs-userpage-level-1' => 'Umím trochu jazyk',
	'translate-fs-userpage-help' => 'Uveďte své jazykové znalosti a řekněte nám něco o sobě. Pokud umíte víc než pět jazyků, budete později moci přidat další.',
	'translate-fs-userpage-submit' => 'Založit mou uživatelskou stránku',
	'translate-fs-userpage-done' => 'Výtečně! Teď máte svou uživatelskou stránku.',
	'translate-fs-permissions-planguage' => 'Primární jazyk:',
	'translate-fs-permissions-help' => 'Nyní bude potřeba požádat o přidání do skupiny překladatelů.
Zvolte primární jazyk, do kterého budete překládat.

Další jazyky a jiné poznámky můžete zmínit v textovém poli níže.',
	'translate-fs-permissions-pending' => 'Vaše žádost byla přidána na [[$1]] a někdo z pracovníků ji co nejdříve zkontroluje.
Pokud si ověříte svou e-mailovou adresu, dostanete poté upozornění e-mailem.',
	'translate-fs-permissions-submit' => 'Odeslat žádost',
	'translate-fs-target-text' => "Gratulujeme!
Teď můžete začít překládat.

Nebojte se, pokud vám to tu připadá nové a matoucí.
Na stránce [[Project list]] najdete přehled projektů, do kterých můžete přispívat překlady.
Většina projektů obsahuje stručný popis a odkaz ''Translate this project'', který vás dovede na stránku s přehledem všech nepřeložených zpráv.
Také je k dispozici seznam všech skupin zpráv spolu s [[Special:LanguageStats|aktuálním stavem překladu do daného jazyka]].

Pokud máte potřebu rozumět věcem lépe, ještě než začnete překládat, můžete si přečíst [[FAQ|často kladené otázky]].
Dokumentace může být bohužel někdy zastaralá.
Pokud najdete něco, co si myslíte, že byste {{gender:|měl být schopen|měla být schopna|měli být schopni}} dělat, ale nejde to, neváhejte se zeptat na [[Support|stránce podpory]].

Také můžete kontaktovat spolupřekladatele do stejného jazyka pomocí [[Portal_talk:$1|diskusní stránky]] [[Portal:$1|vašeho jazykového portálu]].
Pokud jste to dosud {{gender:|neučinil|neučinila|neučinili}}, [[Special:Preferences|nastavte svůj jazyk rozhraní na jazyk, do kterého chcete překládat]], aby vám tato wiki byla schopna ukazovat nejrelevantnější odkazy.",
	'translate-fs-email-text' => 'Prosíme, uveďte v [[Special:Preferences|nastavení]] svou e-mailovou adresu a potvrďte ji pomocí zprávy, která vám byla poslána.

To umožní ostatním, aby vás kontaktovali pomocí e-mailu.
Také budete maximálně jednou měsíčně dostávat novinky.
Pokud novinky nechcete dostávat, můžete se z odběru odhlásit na záložce „{{int:prefs-personal}}“ v [[Special:Preferences|nastavení]].',
);

/** Danish (Dansk)
 * @author Emilkris33
 * @author Peter Alberti
 */
$messages['da'] = array(
	'firststeps' => 'De første skridt',
	'firststeps-desc' => '[[Special:FirstSteps|Specialside]] for at hjælpe brugere i gang på en wiki, der bruger oversættelsesudvidelsen',
	'translate-fs-pagetitle-done' => '- færdig!',
	'translate-fs-pagetitle-pending' => '- afventer',
	'translate-fs-pagetitle' => 'Kom godt i gang guiden - $1',
	'translate-fs-signup-title' => 'Opret en konto',
	'translate-fs-settings-title' => 'Konfigurer dine indstillinger',
	'translate-fs-userpage-title' => 'Opret din brugerside',
	'translate-fs-permissions-title' => 'Anmodning om oversættertilladelse',
	'translate-fs-target-title' => 'Start med at oversætte!',
	'translate-fs-email-title' => 'Bekræft din e-mail-adresse',
	'translate-fs-intro' => "Velkommen til {{SITENAME}} kom godt i gang guide.
Du vil blive guidet igennem processen med til at blive en oversætter trin for trin.
I sidste ende vil du være i stand til at oversætte ''brugerflade beskeder'' hos alle støttede projekter på {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Vælg et sprog',
	'translate-fs-settings-planguage' => 'Primært sprog:',
	'translate-fs-settings-planguage-desc' => 'Det primære sprog er både sproget for din brugerflade på denne wiki og standardsproget for dine oversættelser.',
	'translate-fs-settings-slanguage' => 'Hjælpesprog $1:',
	'translate-fs-settings-slanguage-desc' => 'Under oversættelsesredigeringen, er det muligt at vise oversættelser af beskeder i andre sprog.
Her kan du vælge hvilke sprog, om nogen, du ønsker at se.',
	'translate-fs-settings-submit' => 'Gem indstillinger',
	'translate-fs-userpage-level-N' => 'Mit modersmål er',
	'translate-fs-userpage-level-5' => 'Jeg er en professionel oversætter af',
	'translate-fs-userpage-level-4' => 'Jeg er lige så god som en indfødt til',
	'translate-fs-userpage-level-3' => 'Jeg er god til',
	'translate-fs-userpage-level-2' => 'Jeg er nogenlunde god til',
	'translate-fs-userpage-level-1' => 'Jeg kan lidt',
	'translate-fs-userpage-help' => 'Vær så venlig at angive dine sprogfærdigheder og fortæl os lidt om dig selv. Hvis du kan flere end fem sprog, kan du tilføje dem senere.',
	'translate-fs-userpage-submit' => 'Opret min brugerside',
	'translate-fs-userpage-done' => 'Godt gået! Du har nu en bruger side.',
	'translate-fs-permissions-planguage' => 'Primært sprog:',
	'translate-fs-permissions-help' => 'Nu skal du indsende en anmodning om at blive tilføjet til gruppen af oversættere.
Vælg det primære sprog, du ønsker at oversætte til.

Du kan nævne andre sprog eller tilføje andre bemærkninger i tekstfeltet nedenfor.',
	'translate-fs-permissions-pending' => 'Din anmodning er blevet sendt til [[$1]], og en af hjemmesidens ansatte vil tjekke den snarest muligt.
Hvis du bekræfter din email-adresse, vil du modtage en notits per email, så snart det sker.',
	'translate-fs-permissions-submit' => 'Send anmodning',
	'translate-fs-target-text' => 'Tillykke!
Du kan nu begynde at oversætte.

Vær ikke bange, hvis det stadig føles nyt og forvirrende for dig.
På [[Project list]] er der en oversigt over projekter, som du kan bidrage oversættelser til.
De fleste af projekterne har en kort beskrivelses side med et "\'\'Oversæt dette projekt\'\'" link, der vil tage dig til en side som indeholder alle uoversatte beskeder.
En liste over alle besked grupper med [[Special:LanguageStats|aktuelle oversættelse status for et sprog]] er også tilgængelig.

Hvis du føler at du har brug for at forstå mere, før du begynder at oversætte, kan du læse [[FAQ|Ofte stillede spørgsmål.]]
Desværre kan dokumentation være forældede tider.
Hvis der er noget, du tror, du bør være i stand til at gøre, men kan ikke finde ud af, hvordan, så tøv ikke med at spørge på [[Support|support-siden]].

Du kan også kontakte andre oversættere af samme sprog på [[Portal:$1|din sprog portal]]s [[Portal_talk:$1|diskussionsside]].
Hvis du ikke allerede har gjort det, [[Special:Preferences|ændrer dit brugergrænseflade sprog til det sprog, du ønsker at oversætte til]], således at wiki er i stand til at vise de mest relevante links til dig.',
	'translate-fs-email-text' => 'Angiv venligst din e-mail-adresse i [[Special:Preferences|dine indstillinger]] og bekræft den via den e-mail der sendes til dig.

Dette gør det muligt for andre brugere at kontakte dig via e-mail.
Du vil også modtage nyhedsbreve for det meste en gang om måneden.
Hvis du ikke ønsker at modtage nyhedsbreve, kan du framelde det i fanebladet "{{int:prefs-personal}}" i dine [[Special:Preferences|indstillinger]].',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Kghbln
 * @author Purodha
 * @author The Evil IP address
 */
$messages['de'] = array(
	'firststeps' => 'Erste Schritte',
	'firststeps-desc' => '[[Special:FirstSteps|Spezialseite]] zur Starterleichterung auf Wikis mit der „Translate“-Extension',
	'translate-fs-pagetitle-done' => ' – erledigt!',
	'translate-fs-pagetitle-pending' => '– in Arbeit',
	'translate-fs-pagetitle' => 'Startassistent - $1',
	'translate-fs-signup-title' => 'Registrierung durchführen',
	'translate-fs-settings-title' => 'Einstellungen anpassen',
	'translate-fs-userpage-title' => 'Benutzerseite erstellen',
	'translate-fs-permissions-title' => 'Übersetzerrechte beantragen',
	'translate-fs-target-title' => 'Übersetzen!',
	'translate-fs-email-title' => 'E-Mail-Adresse bestätigen',
	'translate-fs-intro' => "Willkommen beim translatewiki.net-Startassistenten.
Dir wird hier gezeigt, wie du Schritt für Schritt ein Übersetzer bei  translatewiki.net wirst.
Am Ende wirst du alle ''Nachrichten der Benutzeroberfläche'' der von translatewiki.net unterstützten Projekte übersetzen können.",
	'translate-fs-selectlanguage' => 'Wähle eine Sprache',
	'translate-fs-settings-planguage' => 'Hauptsprache:',
	'translate-fs-settings-planguage-desc' => 'Die Hauptsprache ist zum einen deine Sprache für die Benutzeroberfläche auf diesem Wiki
und zum anderen die Zielsprache für deine Übersetzungen.',
	'translate-fs-settings-slanguage' => 'Unterstützungssprache $1:',
	'translate-fs-settings-slanguage-desc' => 'Es ist möglich im Übersetzungseditor Übersetzungen von Nachrichten in anderen Sprachen anzeigen zu lassen.
Hier kannst du wählen, welche Sprachen du, wenn überhaupt, angezeigt bekommen möchtest.',
	'translate-fs-settings-submit' => 'Einstellungen speichern',
	'translate-fs-userpage-level-N' => 'Ich bin ein Muttersprachler',
	'translate-fs-userpage-level-5' => 'Ich bin ein professioneller Übersetzer',
	'translate-fs-userpage-level-4' => 'Ich habe die Kenntnisse eines Muttersprachlers',
	'translate-fs-userpage-level-3' => 'Ich habe gute Kenntnisse',
	'translate-fs-userpage-level-2' => 'Ich habe mittelmäßige Kenntnisse',
	'translate-fs-userpage-level-1' => 'Ich habe kaum Kenntnisse',
	'translate-fs-userpage-help' => 'Bitte gib deine Sprachkenntnisse an und teile uns etwas über dich mit. Sofern du Kenntnisse zu mehr als fünf Sprachen hast, kannst du diese später angeben.',
	'translate-fs-userpage-submit' => 'Benutzerseite erstellen',
	'translate-fs-userpage-done' => 'Gut gemacht! Du hast nun eine Benutzerseite',
	'translate-fs-permissions-planguage' => 'Hauptsprache:',
	'translate-fs-permissions-help' => 'Jetzt musst du eine Anfrage stellen, um in die Benutzergruppe der Übersetzer aufgenommen werden zu können.
Wähle die Hauptsprache in die du übersetzen möchtest.

Du kannst andere Sprachen sowie weitere Hinweise im Textfeld unten angeben.',
	'translate-fs-permissions-pending' => 'Deine Anfrage wurde auf Seite [[$1]] gespeichert. Einer der Mitarbeiter von translatewiki.net wird sie sobald als möglich prüfen.
Sofern du deine E-Mail-Adresse bestätigst, erhältst du eine E-Mail-Benachrichtigung, sobald dies erfolgt ist.',
	'translate-fs-permissions-submit' => 'Anfrage absenden',
	'translate-fs-target-text' => "Glückwunsch!
Du kannst nun mit dem Übersetzen beginnen.

Sei nicht verwirrt, wenn es dir noch neu und unübersichtlich vorkommt.
Auf der Seite [[Project list|Projekte]] gibt es eine Übersicht der Projekte, die du übersetzen kannst.
Die meisten Projekte haben eine kurze Beschreibungsseite zusammen mit einem „''Übersetzen''“- Link, der dich auf eine Seite mit nicht-übersetzten Nachrichten bringt.
Eine Liste aller Nachrichtengruppen und dem [[Special:LanguageStats|momentanen Status einer Sprache]] gibt es auch.

Wenn du mehr hiervon verstehen möchtest, kannst du die [[FAQ|häufig gestellten Fragen]] lesen.
Leider kann die Dokumentation zeitweise veraltet sein.
Wenn du etwas tun möchtest, jedoch nicht weißt wie, zögere nicht auf der [[Support|Hilfeseite]] zu fragen.

Du kannst auch Übersetzer deiner Sprache auf der [[Portal_talk:$1|Diskussionsseite]] [[Portal:$1|des entsprechenden Sprachportals]] kontaktieren.
Das Portal verlinkt auf deine momentane [[Special:Preferences|Spracheinstellung]].
Bitte ändere sie falls nötig.",
	'translate-fs-email-text' => 'Bitte gib deine E-Mail-Adresse in [[Special:Preferences|deinen Einstellungen]] ein und bestätige die an dich versandte E-Mail.

Dies gibt anderen die Möglichkeit, dich über E-Mail zu erreichen.
Du erhältst außerdem bis zu einmal im Monat einen Newsletter.
Wenn du keinen Newsletter erhalten möchtest, kannst du dich im Tab „{{int:prefs-personal}}“ in deinen [[Special:Preferences|Einstellungen]] austragen.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author Purodha
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'translate-fs-settings-title' => 'Ihre Einstellungen anpassen',
	'translate-fs-userpage-title' => 'Ihre Benutzerseite erstellen',
	'translate-fs-email-title' => 'Ihre E-Mail-Adresse bestätigen',
	'translate-fs-intro' => "Willkommen beim translatewiki.net-Startassistenten.
Ihnen wird hier gezeigt, wie Sie Schritt für Schritt ein Übersetzer bei translatewiki.net werden.
Am Ende werden Sie alle ''Nachrichten der Benutzeroberfläche'' der von translatewiki.net unterstützten Projekte übersetzen können.",
	'translate-fs-selectlanguage' => 'Wählen Sie eine Sprache',
	'translate-fs-settings-planguage-desc' => 'Die Hauptsprache ist zum einen Ihre Sprache für die Benutzeroberfläche auf diesem Wiki
und zum anderen die Zielsprache für Ihre Übersetzungen.',
	'translate-fs-settings-slanguage-desc' => 'Es ist möglich im Übersetzungseditor Übersetzungen von Nachrichten in anderen Sprachen anzeigen zu lassen.
Hier können Sie wählen, welche Sprachen Sie, wenn überhaupt, angezeigt bekommen möchten.',
	'translate-fs-userpage-help' => 'Bitte geben Sie Ihre Sprachkenntnisse an und teilen Sie uns etwas über sich mit. Sofern Sie Kenntnisse zu mehr als fünf Sprachen haben, können Sie diese später angeben.',
	'translate-fs-userpage-done' => 'Gut gemacht! Sie haben nun eine Benutzerseite',
	'translate-fs-permissions-help' => 'Jetzt müssen Sie eine Anfrage stellen, um in die Benutzergruppe der Übersetzer aufgenommen werden zu können.
Wählen Sie die Hauptsprache in die Sie übersetzen möchten.

Sie können andere Sprachen sowie weitere Hinweise im Textfeld unten angeben.',
	'translate-fs-permissions-pending' => 'Ihre Anfrage wurde auf Seite [[$1]] gespeichert. Einer der Mitarbeiter von translatewiki.net wird sie sobald als möglich prüfen.
Sofern Sie Ihre E-Mail-Adresse bestätigen, erhalten Sie eine E-Mail-Benachrichtigung, sobald dies erfolgt ist.',
	'translate-fs-target-text' => "Glückwunsch!
Sie können nun mit dem Übersetzen beginnen.

Seien Sie nicht verwirrt, wenn es Ihnen noch neu und unübersichtlich vorkommt.
Auf der Seite [[Project list|Projekte]] gibt es eine Übersicht der Projekte, die Sie übersetzen können.
Die meisten Projekte haben eine kurze Beschreibungsseite zusammen mit einem „''Übersetzen''“- Link, der Sie auf eine Seite mit nicht-übersetzten Nachrichten bringt.
Eine Liste aller Nachrichtengruppen und dem [[Special:LanguageStats|momentanen Status einer Sprache]] gibt es auch.

Wenn Sie mehr hiervon verstehen möchten, können Sie die [[FAQ|häufig gestellten Fragen]] lesen.
Leider kann die Dokumentation zeitweise veraltet sein.
Wenn Sie etwas tun möchten, jedoch nicht wissen wie, zögern Sie nicht auf der [[Support|Hilfeseite]] zu fragen.

Sie kannst auch Übersetzer Ihrer Sprache auf der [[Portal_talk:$1|Diskussionsseite]] [[Portal:$1|des entsprechenden Sprachportals]] kontaktieren.
Das Portal verlinkt auf deine momentane [[Special:Preferences|Spracheinstellung]].
Bitte ändern Sie sie falls nötig.",
	'translate-fs-email-text' => 'Bitte geben Sie Ihre E-Mail-Adresse in [[Special:Preferences|Ihren Einstellungen]] ein und bestätigen Sie die an Sie versandte E-Mail.

Dies gibt anderen die Möglichkeit, Sie über E-Mail zu erreichen.
Sie erhalten außerdem bis zu einmal im Monat einen Newsletter.
Wenn Sie keinen Newsletter erhalten möchten, können Sie sich im Tab „{{int:prefs-personal}}“ in Ihren [[Special:Preferences|Einstellungen]] austragen.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'firststeps' => 'Prědne kšace',
	'firststeps-desc' => '[[Special:FirstSteps|Specialny bok]], aby  wólažcył wužywarjam wužywanje rozšyrjenja Translate',
	'translate-fs-pagetitle-done' => ' - wótbyte!',
	'translate-fs-pagetitle-pending' => '´- wobźěłujo se',
	'translate-fs-pagetitle' => 'Startowy asistent - $1',
	'translate-fs-signup-title' => 'Registrěrowaś',
	'translate-fs-settings-title' => 'Twóje nastajenja konfigurěrowaś',
	'translate-fs-userpage-title' => 'Twój wužywarski bok napóraś',
	'translate-fs-permissions-title' => 'Póžedanje na pśełožowarske pšawa stajiś',
	'translate-fs-target-title' => 'Zachop pśełožowaś!',
	'translate-fs-email-title' => 'Twóju e-mailowu adresu wobkšuśiś',
	'translate-fs-intro' => "Witaj do startowego asistenta {{GRAMMAR:genitiw|SITENAME}}.
Pokazujo so śi kšać pó kšać, kak buźoš pśełožowaŕ.
Na kóńcu móžoš ''powěźeńki wužywarskego powjercha'' wšyknych pódpěranych projektow na {{SITENAME}} pśełožowaś.",
	'translate-fs-selectlanguage' => 'Wubjeŕ rěc',
	'translate-fs-settings-planguage' => 'Głowna rěc:',
	'translate-fs-settings-planguage-desc' => 'Głowna rěc ma dwě funkciji: słužy ako rěc wužywarskego pówjercha w toś tom wikiju a ako standardna celowa rěc za pśełožki.',
	'translate-fs-settings-slanguage' => 'Pomocna rěc $1:',
	'translate-fs-settings-slanguage-desc' => 'Jo móžno pśełožki powěźeńkow w drugich rěcach w pśełožowańskem editorje pokazaś.
How móžoš wubraś, kótare rěcy coš rady wiźeś.',
	'translate-fs-settings-submit' => 'Nastajenja składowaś',
	'translate-fs-userpage-level-N' => 'Som maminorěcny',
	'translate-fs-userpage-level-5' => 'Som profesionelny pśełožowaŕ',
	'translate-fs-userpage-level-4' => 'Mam znajobnosći maminorěcnego',
	'translate-fs-userpage-level-3' => 'Mam dobre znajobnosći',
	'translate-fs-userpage-level-2' => 'Mam pśerězne znajobnosći',
	'translate-fs-userpage-level-1' => 'Mam jano mało znajobnosćow',
	'translate-fs-userpage-help' => 'Pšosym pódaj swóje rěcne znajobnosći a daj nam něco wó sebje k wěsći. Jolic maš znajobnosći we wěcej ako pěś rěcach, móžoš je pózdźej pódaś.',
	'translate-fs-userpage-submit' => 'Mój wužywarski bok napóraś',
	'translate-fs-userpage-done' => 'Derje cynił! Maš něnto wužywarski bok.',
	'translate-fs-permissions-planguage' => 'Głowna rěc:',
	'translate-fs-permissions-help' => 'Musyš něnto napšašowanje stajiś, aby se do kupki pśełožowarjow pśiwzeł.
Wubjeŕ głownu rěc, do kótarejež coš pśełožowaś.

Móžoš druge rěcy a druge pśipomnjeśa w slědujucem tekstowem pólu pódaś.',
	'translate-fs-permissions-pending' => 'Twójo napšašowanje jo se do [[$1]] wótpósłało a něchten z teama translatewiki.net buźo jo tak skóro ako móžno pśeglědowaś. Jolic swóju e-mailowu adresu wobkšuśiš, dostanjoš e-mailowu powěźeńku, gaž jo se to stało.',
	'translate-fs-permissions-submit' => 'Napšašowanje pósłaś',
	'translate-fs-target-text' => 'Gratulacija!
Móžoš něnto pśełožowanje zachopiś.

Buź mimo starosći, jolic zda se śi hyšći nowe a konfuzne.
Na [[Project list|lisćinje projektow]] jo pśeglěd projektow, ku kótarymž móžoš pśełožki pśinosowaś. Nejwěcej projektow ma krotky wopisański bok z wótkazom "\'\'Toś ten projekt pśełožyś\'\'", kótaryž wjeźo śi k bokoju, kótaryž wšykne njepśełožone powěźeńki wopśimujo.
Lisćina wšyknych kupkow powěźeńkow z [[Special:LanguageStats|aktualnym pśełožowanskim stawom za rěc]] stoj teke k dispoziciji.

Jolic měniš, až dejš nejpjerwjej wěcej rozumiś, nježli až zachopijoš  pśełožowaś, móžoš [[FAQ|Ceste pšašanja]] cytaś.
Dokumentacija móžo bóžko wótergi zestarjona byś.
Joli něco jo, wó kótaremž mysliš, až by měło móžno byś, ale njenamakajoš, kak móžoš to cyniś, pšašaj se ga na boku [[Support|Pódpěra]].

Móžoš se teke ze sobupśełožowarjami teje sameje rěcy na [[Portal_talk:$1|diskusijnem boku]] [[Portal:$1|portala swójeje rěcy]] do zwiska stajiś.
Jolic hyšći njejsy to cynił, [[Special:Preferences|změń swój wužywarski powjerch do rěcy, do kótarejež coš pśełožowaś]], aby se wiki mógał wótkaze pokazaś, kótarež su relewantne za tebje.',
	'translate-fs-email-text' => 'Pšosym pódaj swóju e-mailowu adresu w [[Special:Preferences|swójich nastajenach]] a wobkšuś ju pśez e-mail, kótaraž sćelo se na tebje.

To dowólujo drugim wužywarjam se z tobu do zwiska stajiś.
Buźoš teke powěsćowe listy jaden raz na mjasec dostaś.
Jolic njocoš  powěsćowe listy dostaś, móžoš to na rejtarku "{{int:prefs-personal}}" swójich [[Special:Preferences|nastajenjow]] wótwóliś.',
);

/** Esperanto (Esperanto)
 * @author ArnoLagrange
 * @author Yekrats
 */
$messages['eo'] = array(
	'firststeps' => 'Unuaj paŝoj',
	'firststeps-desc' => '[[Special:FirstSteps|Speciala paĝo]] por helpi novajn viki-uzantojn ekuzi la Traduk-etendaĵon',
	'translate-fs-pagetitle-done' => '- farita!',
	'translate-fs-pagetitle' => 'Asistilo por ekuzado - $1',
	'translate-fs-signup-title' => 'Ensalutu',
	'translate-fs-settings-title' => 'Agordu viajn preferojn.',
	'translate-fs-userpage-title' => 'Kreu vian uzantopaĝon.',
	'translate-fs-permissions-title' => 'Petu rajtojn de tradukisto',
	'translate-fs-target-title' => 'Ek traduku!',
	'translate-fs-email-title' => 'Konfirmu vian retpoŝtan adreson',
	'translate-fs-intro' => "Bonvenon en la ekuz-asistilo de {{SITENAME}}.
Vi estos gvidata tra la proceso por fariĝi tradukisto pason post paŝo.
Fine vi kapablos traduki ''interfacajn mesaĝojn'' de ĉiuj eltenitaj projektoj je {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Krei mian uzantopaĝon.',
	'translate-fs-userpage-done' => 'Bone! Vi nun havas uzantopaĝon.',
	'translate-fs-target-text' => "Gratulojn  !
Vi povas nun ektraduki.

Ne maltrankviliĝu se vi trovas tion iom nova kaj stranga.
Sur la [[Project list|projektolisto]] troviĝas superrigardo de la projektojn al kies traduko vi povas helpi.

Plej multaj el tiuj projektoj enhavas paĝon entenantan  mallongan priskribon kaj ligilon « ''Traduki ĉi tiun projekton'' » kiu gvidos vin al paĝo listiganta ĉiuj netradukitajn mesaĝojn. Havebla estas listo de ĉiuj mesaĝgrupoj kun la [[Special:LanguageStats|nuna tradukostato por difinita lingvo]].

Se vi sentas ke vi bezonas pli da informoj antaŭ ektraduki, vi povas legi al [[FAQ|Plej oftajn demandojn]]. Bedaŭrinde la dokumentado povas esti eksdata. Se vi opinias ke vi povus fari ion, ne trovante kiel fari, ne hezitu fari demandojn en la [[Support|helppaĝo]].

Vi ankaŭ povas kontakti la aliajn tradukantojn de la sama lingvo sur [[Portal_talk:$1|diskutpaĝo]] de [[Portal:$1|via propra lingvo]].
Se vi ne jam faris tion,  [[Special:Preferences|agordu la interfacan lingvon]] por ke ĝi estu tiu en kiun vi estas tradukonta. Tiel la ligiloj kiujn proponas la vikio estos plej adaptitaj al via situacio.",
	'translate-fs-email-text' => 'Bonvolu enigi vian retpoŝtadreson en  [[Special:Preferences|viaj preferoj]] kaj konfirmi ĝin per la mesaĝo kiun vi ricevos.

Tio ebligos al la aliaj uzantoj kontakti vin per retpoŝto.
Vi ankaŭ ricevos informleteron maksimume unu fojon en la monato.
Se vi ne deziras ricevi ĝin, vi povas malaktivigi en la langeto  « {{int:prefs-personal}} »  de  [[Special:Preferences|viaj preferoj]].',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Diego Grez
 * @author Drini
 * @author Fitoschido
 * @author Mor
 * @author Tempestas
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'firststeps' => 'Primeros pasos',
	'firststeps-desc' => '[[Special:FirstSteps|Página especial]] para que los usuarios comiencen en un wiki usando la extensión de traducción',
	'translate-fs-pagetitle-done' => '- ¡hecho!',
	'translate-fs-pagetitle-pending' => '; pendiente',
	'translate-fs-pagetitle' => 'Guía de inicio - $1',
	'translate-fs-signup-title' => 'Registrarse',
	'translate-fs-settings-title' => 'Configurar tus preferencias',
	'translate-fs-userpage-title' => 'Crear tu página de usuario',
	'translate-fs-permissions-title' => 'Solicitar permisos de traducción',
	'translate-fs-target-title' => '¡Comienza a traducir!',
	'translate-fs-email-title' => 'Confirmar tu dirección de correo electrónico',
	'translate-fs-intro' => "Bienvenido al asistente de los primeros pasos en {{SITENAME}}.
Serás guíado a través del proceso de convertirte en un traductor pasa a paso.
Al final serás capaz de traducir los ''mensajes de interfaz'' de todos los proyectos soportados en {{SITENAME}}",
	'translate-fs-selectlanguage' => 'Elija un idioma',
	'translate-fs-settings-planguage' => 'Idioma principal:',
	'translate-fs-settings-planguage-desc' => 'El idioma principal es tanto el idioma de la interfaz en este wiki
y también el idioma en el que se van a realizar las traducciones.',
	'translate-fs-settings-slanguage' => 'Idioma soportado $1:',
	'translate-fs-settings-slanguage-desc' => 'Es posible mostrar las traducciones de los mensajes en otros idiomas en el editor de traducciones.
Aquí puede elegir, si quiere, los idiomas que le gustaría ver.',
	'translate-fs-settings-submit' => 'Guardar las preferencias',
	'translate-fs-userpage-level-N' => 'Soy hablante nativo de',
	'translate-fs-userpage-level-5' => 'Soy traductor profesional de',
	'translate-fs-userpage-level-4' => 'Lo conozco como un hablante nativo',
	'translate-fs-userpage-level-3' => 'Tengo un buen dominio de',
	'translate-fs-userpage-level-2' => 'Tengo un dominio con moderado de',
	'translate-fs-userpage-level-1' => 'Sé un poco de',
	'translate-fs-userpage-help' => 'Por favor indique sus competencias lingüísticas y coméntenos algo sobre usted. Si sabe más de cinco idiomas los puede añadir más adelante.',
	'translate-fs-userpage-submit' => 'Crear mi página de usuario',
	'translate-fs-userpage-done' => '¡Bien hecho! Ahora tienes una página de usuario.',
	'translate-fs-permissions-planguage' => 'Idioma principal:',
	'translate-fs-permissions-help' => 'Ahora tiene que hacer una solicitud para pasar a formar parte del grupo de traductores.
Seleccione el idioma principal en el que se va a traducir.

Puede mencionar otros idiomas y otras observaciones en el cuadro de texto inferior.',
	'translate-fs-permissions-pending' => 'Su solicitud ha sido enviada a "[[$1]]" y alguno de los miembros del personal del sitio atenderá tan pronto como sea posible.
Si confirmas tu dirección de correo electrónico, recibirá una notificación por correo electrónico tan pronto como ocurra.',
	'translate-fs-permissions-submit' => 'Enviar la solicitud',
	'translate-fs-target-text' => '¡Felicidades!
Ahora puedes comenzar a traducir.

No temas si lo sientes nuevo y confuso para ti.
En la [[Project list]] hay una visión general de los proyectos en los que puedes contribuir con traducciones.
La mayoría de los proyectos tiene una página de descripción corta con un enlace "\'\'Traducir este proyecto\'\'", que te llevará a una página que lista todos los mensajes sin traducir.
Una lista de todos los grupos de mensajes con el [[Special:LanguageStats|status de traducción actual para un idioma]] está también disponible.

Si sientes que necesitas entender más antes de empezar a traducir, puedes leer las [[FAQ|Preguntas frecuentes]].
Desafortunadamente la documentación puede estar desactualizada a veces.
Si hay algo que crees que deberías ser capaz de hacer, pero no sabes cómo, no dudes en preguntarlo en la [[Support|página de apoyo]].

También puedes contactar con otros traductores del mismo idioma en la [[Portal_talk:$1|página de discusión]] del [[Portal:$1|portal de tu idioma]].
El portal enlaza a tu [[Special:Preferences|preferencia de idioma]] actual.
Si todavía no lo has hecho, [[Special:Preferences|cambia el idioma de tu interfaz de usuario al idioma al que quieras traducir]], para que el wiki te pueda mostrar los enlaces más relevantes para ti.',
	'translate-fs-email-text' => 'Por favor proporciona tu dirección de correo electrónico en [[Special:Preferences|tus preferencias]] y confírmala desde el mensaje de correo que se te envíe.

Esto permite a los otros usuarios contactar contigo por correo electrónico.
También recibirás boletines de noticias como máximo una vez al mes.
Si no deseas recibir boletines de noticias, puedes cancelarlos en la pestaña "{{int:prefs-personal}}" de tus [[Special:Preferences|preferencias]].',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'firststeps' => 'Esimesed sammud',
	'firststeps-desc' => '[[Special:FirstSteps|Erilehekülg]], mis aitab tõlkimisga alustada',
	'translate-fs-pagetitle-done' => ' – valmis!',
	'translate-fs-pagetitle-pending' => ' – ootel',
	'translate-fs-pagetitle' => 'Alustusviisard – $1',
	'translate-fs-signup-title' => 'Registreerumine',
	'translate-fs-settings-title' => 'Eelistuste seadmine',
	'translate-fs-userpage-title' => 'Kasutajalehekülje loomine',
	'translate-fs-permissions-title' => 'Tõlkijaõiguste taotlemine',
	'translate-fs-target-title' => 'Alusta tõlkimist!',
	'translate-fs-email-title' => 'E-posti aadressi kinnitamine',
	'translate-fs-intro' => "Tere tulemast {{GRAMMAR:genitive|{{SITENAME}}}} alustusviisardisse.
Sul aidatakse sammhaaval tõlkijaks saada.
Lõpuks saad tõlkida kõikide {{GRAMMAR:genitive|{{SITENAME}}}} toetatud projektide ''liidese sõnumeid''.",
	'translate-fs-selectlanguage' => 'Vali keel',
	'translate-fs-settings-planguage' => 'Põhikeel:',
	'translate-fs-settings-planguage-desc' => 'Põhikeel kattub sinu siin vikis kasutatava liidesekeelega
ja keelega, millesse vaikimisi tõlgid.',
	'translate-fs-settings-slanguage' => '$1. abikeel:',
	'translate-fs-settings-slanguage-desc' => 'Tõlkeredaktoris saab näidata sõnumite teiskeelseid tõlkeid.
Siin saad valida, milliseid keeli soovid näha, kui soovid.',
	'translate-fs-settings-submit' => 'Salvesta eelistused',
	'translate-fs-userpage-level-N' => 'See on minu emakeel',
	'translate-fs-userpage-level-5' => 'Mul on selle keele tõlkija kutse',
	'translate-fs-userpage-level-4' => 'Räägin seda keelt emakeelelähedasel tasemel',
	'translate-fs-userpage-level-3' => 'Räägin seda keelt heal tasemel',
	'translate-fs-userpage-level-2' => 'Räägin seda keelt keskmisel tasemel',
	'translate-fs-userpage-level-1' => 'Räägin natuke seda keelt',
	'translate-fs-userpage-help' => 'Palun kirjelda oma keelteoskust ja räägi midagi endast. Kui oskad rohkem kui viit keelt, saad ülejäänud hiljem lisada.',
	'translate-fs-userpage-submit' => 'Loo minu kasutajalehekülg',
	'translate-fs-userpage-done' => 'Hästi tehtud! Nüüd on sul kasutajalehekülg.',
	'translate-fs-permissions-planguage' => 'Põhikeel:',
	'translate-fs-permissions-help' => 'Nüüd pead esitama taotluse, et sind lisataks tõlkijate rühma.
Vali põhikeel, millesse tõlgid.

Allolevas tekstikastis saad mainida teisi keeli ja teha muid märkusi.',
	'translate-fs-permissions-pending' => 'Sinu taotlus on lisatud leheküljele "[[$1]]" ja keegi võrgukoha kooseisust vaatab selle esimesel võimalusel üle.
Kui kinnitad oma e-posti aadressi, saad e-kirja niipea, kui su taotlus on üle vaadatud.',
	'translate-fs-permissions-submit' => 'Saada taotlus',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'firststeps' => 'Lehen urratsak',
	'translate-fs-pagetitle-done' => ' - egina!',
	'translate-fs-pagetitle' => 'Martxan jarri - $1',
	'translate-fs-signup-title' => 'Kontua sortu',
	'translate-fs-settings-title' => 'Zure hobespenak konfiguratu',
	'translate-fs-userpage-title' => 'Zure lankide orria sortu',
	'translate-fs-permissions-title' => 'Itzultzaile eskubidea eskatu',
	'translate-fs-target-title' => 'Hasi itzultzen!',
	'translate-fs-selectlanguage' => 'Hizkuntza aukeratu',
	'translate-fs-settings-planguage' => 'Lehen hizkuntza:',
	'translate-fs-userpage-submit' => 'Nire lankide orria sortu',
	'translate-fs-userpage-done' => 'Ondo egina! Orain lankide orrialdea duzu.',
	'translate-fs-permissions-submit' => 'Eskaera bidali',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'firststeps' => 'گام‌های نخست',
	'firststeps-desc' => '[[Special:FirstSteps|گام‌های نخست]] برای به راه افتادن کاربران در ویکی با استفاده از افزونه ترجمه',
	'translate-fs-pagetitle-done' => '- شد!',
	'translate-fs-pagetitle-pending' => '- در انتظار',
	'translate-fs-pagetitle' => 'جادوگر آغاز به کار - $1',
	'translate-fs-signup-title' => 'ثبت نام',
	'translate-fs-settings-title' => 'تنظیمات‌تان را پیکربندی کنید',
	'translate-fs-userpage-title' => 'صفحه کاربری‌تان را ایجاد کنید',
	'translate-fs-permissions-title' => 'درخواست مجوز مترجم بدهید',
	'translate-fs-target-title' => 'شروع به ترجمه کنید!',
	'translate-fs-email-title' => 'نشانی پست الکترونیکی خود را تأیید کنید',
	'translate-fs-intro' => "به جادوگر گام‌های نخست {{SITENAME}} خوش آمدید.
شما گام به گام در راه مترجم شدن راهنمایی خواهید شد.
در انتها شما قادر خواهید بود ''پیغام‌های رابط کاربری'' تمام پروژه‌های پشتیبانی شده در {{SITENAME}} را ترجمه کنید.",
	'translate-fs-selectlanguage' => 'یک زبان انتخاب کنید',
	'translate-fs-settings-planguage' => 'زبان اصلی:',
	'translate-fs-settings-planguage-desc' => 'زبان اصلی به عنوان زبان رابط کاربری این ویکی
و نیز به عنوان زبان هدف در ترجمه‌ها در نظر گرفته می شود.',
	'translate-fs-settings-slanguage' => 'زبان دستیار $1:',
	'translate-fs-settings-slanguage-desc' => 'ترجمه‌های پیغام‌ها در زبان‌های دیگر نیز می‌تواند در ویرایشگر ترجمه نمایش یابد.
در این‌جا شما می‌توانید انتخاب کنید چه زبانی را می‌خواهید ببینید.',
	'translate-fs-settings-submit' => 'ذخیره کردن ترجیحات',
	'translate-fs-userpage-level-N' => 'این زبان مادری من است',
	'translate-fs-userpage-level-5' => 'من مترجم حرفه‌ای این زبان هستم',
	'translate-fs-userpage-level-4' => 'این زبان را مانند زبان مادری بلدم',
	'translate-fs-userpage-level-3' => 'این زبان را خوب بلدم',
	'translate-fs-userpage-level-2' => 'این زبان را در حد متوسط بلدم',
	'translate-fs-userpage-level-1' => 'این زبان را کمی بلدم',
	'translate-fs-userpage-help' => 'لطفا مهارت‌های زبانی خود را مشخص کنید و کمی درباره خودتان به ما بگویید. اگر بیش از پنج زبان می‌دانید می‌توانید بقیه را بعداً اضافه کنید.',
	'translate-fs-userpage-submit' => 'ایجاد صفحه کاربری',
	'translate-fs-userpage-done' => 'آفرین! اکنون یک صفحه کاربری دارید.',
	'translate-fs-permissions-planguage' => 'زبان اصلی:',
	'translate-fs-permissions-help' => 'اکنون باید درخواست کنید تا به گروه مترجمان اضافه شوید.
زبان اصلی که قادرید به آن ترجمه کنید را انتخاب کنید.

شما می‌توانید زبان‌های دیگر و سایر توضیحات را در جعبه زیر وارد کنید.',
	'translate-fs-permissions-pending' => 'درخواست شما به  [[$1]] ارسال شد و یکی از کارکنان سایت در اولین فرصت آن را بررسی خواهد کرد.
اگر نشانی پست الکترونیکی خود را تأیید کنید، به محض این که این اتفاق بیفتد از طریق پست الکترونیکی با خبر خواهید شد.',
	'translate-fs-permissions-submit' => 'ارسال درخواست',
	'translate-fs-target-text' => "تبریک!
شما اینک می‌توانید شروع به ترجمه کنید.

از این که این که برایتان تازگی دارد و گیج شده‌اید نگران نباشید.
در [[Project list|فهرست پروژه‌ها]] چکیده‌ای از پروژه‌هایی که می‌توانید به ترجمه‌شان کمک کنید وجود دارد.
بیشتر پروژه‌ها یک صفحه توضیحات به همراه یک پیوند «''این پروژه را ترجمه کنید''» دارند که شما را به صفحه‌ای می‌برد که تمام پیغام‌های ترجمه نشده را فهرست می‌کند.
فهرستی از تمام گروه‌های پیغام‌ها به همراه [[Special:LanguageStats|وضعیت فعلی ترجمه آن‌ها به هر زبان]] نیز موجود است.

اگر فکر می‌کنید که قبل از شروع به ترجمه نیاز به دانستن چیزهای بیشتری دارید، می‌توانید [[FAQ|پرسش‌های متداول]] را مطالعه کنید.
متاسفانه مستندات گاهی قدیمی هستند.
اگر فکر می‌کنید کاری را باید بتوانید انجام بدهید، اما نمی‌دانید چگونه، بدون تردید در [[Support|صفحه پشتیبانی]] سوال کنید.

شما همچنین می‌توانید با دیگر مترجمان همزبان با خودتان از طریق [[Portal_talk:$1|صفحه بحث]] [[Portal:$1|ورودی زبان خودتان]] ارتباط برقرار کنید.
لطفا همین الان [[Special:Preferences|زبان رابطه کاربری را به زبانی که به آن ترجمه می‌کنید تغییر دهید]] تا ویکی پیوندها مرتبط را به شما نشان دهد.",
	'translate-fs-email-text' => 'لطفاً نشانی پست الکترونیکی خود را در [[Special:Preferences|تنظیامت خود]] مشخص کنید و از طریق نامه‌ای که به شما فرستاده می‌شود آن را تأیید کنید.

این کار باعث می‌شود دیگران بتوانند با شما از طریق پست الکترونیکی تماس بگیرند.
همچنین ماهی یک بار یک خبرنامه دریافت خواهید کرد.
اگر نمی‌خواهید خبرنامه دریافت کنید، می توانید در زبانه «{{int:prefs-personal}}» [[Special:Preferences|ترجیحات]] آن را غیر فعال کنید.',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Nike
 * @author ZeiP
 */
$messages['fi'] = array(
	'firststeps' => 'Alkutoimet',
	'firststeps-desc' => '[[Special:FirstSteps|Toimintosivu]], joka ohjastaa uudet käyttäjät Translate-laajennoksen käyttöön.',
	'translate-fs-pagetitle-done' => ' - valmis!',
	'translate-fs-pagetitle-pending' => ' - vireillä',
	'translate-fs-pagetitle' => 'Alkutoimet - $1',
	'translate-fs-signup-title' => 'Rekisteröityminen',
	'translate-fs-settings-title' => 'Asetusten määrittäminen',
	'translate-fs-userpage-title' => 'Käyttäjäsivun luominen',
	'translate-fs-permissions-title' => 'Pyyntö kääntäjäryhmään liittämisestä',
	'translate-fs-target-title' => 'Kääntäminen voi alkaa!',
	'translate-fs-email-title' => 'Sähköpostiosoitteen vahvistus',
	'translate-fs-intro' => "Tervetuloa {{GRAMMAR:genitive|{{SITENAME}}}} ohjattuihin ensiaskeleisiin.
Seuraamalla sivun ohjeita pääset kääntäjäksi alta aikayksikön.
Suoritettuasi kaikki askeleet, voit kääntää kaikkien {{GRAMMAR:inessive|{{SITENAME}}}} olevien projektien ''käyttöliittymäviestejä''.",
	'translate-fs-selectlanguage' => 'Valitse kieli',
	'translate-fs-settings-planguage' => 'Ensisijainen kieli',
	'translate-fs-settings-planguage-desc' => 'Ensisijainen kieli on sekä tämän wikin käyttöliittymäkieli että oletuskielesi käännöksille.',
	'translate-fs-settings-slanguage' => '$1. apukieli',
	'translate-fs-settings-slanguage-desc' => 'Tässä voit valita minkä muiden kielten käännöksiä haluat nähdä käännöstyökalussa.',
	'translate-fs-settings-submit' => 'Tallenna asetukset',
	'translate-fs-userpage-level-N' => 'Äidinkieli',
	'translate-fs-userpage-level-5' => 'Ammattimainen kääntäjä',
	'translate-fs-userpage-level-4' => 'Äidinkielisen veroinen',
	'translate-fs-userpage-level-3' => 'Hyvä taito',
	'translate-fs-userpage-level-2' => 'Keskinkertainen taito',
	'translate-fs-userpage-level-1' => 'Tiedän vähän',
	'translate-fs-userpage-help' => 'Kerro kielitaidostasi ja jotain itsestäsi. Jos osaat yli viittä kieltä, voit lisätä lisää myöhemmin.',
	'translate-fs-userpage-submit' => 'Luo käyttäjäsivuni',
	'translate-fs-userpage-done' => 'Hyvin tehty! Sinulla on nyt käyttäjäsivu.',
	'translate-fs-permissions-planguage' => 'Ensisijainen kieli',
	'translate-fs-permissions-help' => 'Nyt sinun pitää esittää pyyntö kääntäjäryhmään lisäämisestä.
Valitse ensisijainen kieli, jolle aiot kääntää.

Voit mainita muita kieliä ja kirjoittaa muita huomautuksia alla olevaan kenttään.',
	'translate-fs-permissions-pending' => 'Pyyntösi on lisätty sivulle [[$1]] ja joku sivuston henkilökunnasta tarkistaa sen niin pian kuin mahdollista.
Jos vahvistat sähköpostiosoitteesi, saat huomautuksen sähköpostin kautta heti, kun se tapahtuu.',
	'translate-fs-permissions-submit' => 'Lähetä pyyntö',
	'translate-fs-target-text' => "Onnittelut!
Voit nyt aloittaa kääntämisen.

Älä huolestu, vaikka et vielä täysin ymmärtäisi miten kaikki toimii.
Meillä on [[Project list|luettelo projekteista]], joiden kääntämiseen voit osallistua.
Useimmilla projekteilla on lyhyt kuvaussivu, jossa on ''Käännä tämä projekti'' -linkki varsinaiselle käännössivulle.
[[Special:LanguageStats|Kielen nykyisen käännöstilanteen]] näyttävä lista on myös saatavilla.

Jos haluat tietää lisää, voit lukea vaikkapa [[FAQ|usein kysyttyjä kysymyksiä]].
Valitettavasti dokumentaatio voi joskus olla hivenen vanhentunutta.
Jos et keksi, miten joku tarvitsemasi asia tehdään, älä epäröi pyytää apua [[Support|tukisivulla]].

Voit myös ottaa yhteyttä muihin saman kielen kääntäjiin [[Portal:$1|oman kielesi portaalin]] [[Portal_talk:$1|keskustelusivulla]].
Valikon portaalilinkki osoittaa [[Special:Preferences|valitsemasi kielen]] portaaliin.
Jos valitsemasi kieli on väärä, muuta se.",
	'translate-fs-email-text' => 'Anna sähköpostiosoitteesi [[Special:Preferences|asetuksissasi]] ja vahvista se sähköpostiviestistä, joka lähetetään sinulle.

Tämä mahdollistaa muiden käyttäjien ottaa sinuun yhteyttä sähköpostitse.
Saat myös uutiskirjeen korkeintaan kerran kuukaudessa.
Jos et halua vastaanottaa uutiskirjeitä, voit muuttaa asetusta välilehdellä »{{int:prefs-personal}}» omat [[Special:Preferences|asetukset]].',
);

/** French (Français)
 * @author Gomoko
 * @author Hashar
 * @author Peter17
 */
$messages['fr'] = array(
	'firststeps' => 'Premiers pas',
	'firststeps-desc' => '[[Special:FirstSteps|Page spéciale]] pour guider les utilisateurs sur un wiki utilisant l’extension Translate',
	'translate-fs-pagetitle-done' => ' - fait !',
	'translate-fs-pagetitle-pending' => '- en cours',
	'translate-fs-pagetitle' => 'Guide de démarrage - $1',
	'translate-fs-signup-title' => 'Inscrivez-vous',
	'translate-fs-settings-title' => 'Configurez vos préférences',
	'translate-fs-userpage-title' => 'Créez votre page utilisateur',
	'translate-fs-permissions-title' => 'Demandez les permissions de traducteur',
	'translate-fs-target-title' => 'Commencez à traduire !',
	'translate-fs-email-title' => 'Confirmez votre adresse électronique',
	'translate-fs-intro' => "Bienvenue sur l’assistant premiers pas de {{SITENAME}}.
Nous allons vous guider étape par étape pour devenir un traducteur.
À la fin du processus, vous pourrez traduire les ''messages des interfaces'' de tous les projets gérés par {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Choisissez une langue',
	'translate-fs-settings-planguage' => 'Langue principale:',
	'translate-fs-settings-planguage-desc' => 'La langue principale sert aussi comme la langue de votre interface sur ce wiki
et comme la langue cible par  défaut pour les traductions.',
	'translate-fs-settings-slanguage' => "Langue d'assistance $1:",
	'translate-fs-settings-slanguage-desc' => "Il est possible d'afficher des traductions de message dans d'autres langues dans l'éditeur de traduction.
Ici, vous pouvez choisir quelles langues, si c'est le cas, vous aimeriez voir.",
	'translate-fs-settings-submit' => 'Enregistrer les préférences',
	'translate-fs-userpage-level-N' => 'Je suis un locuteur natif de',
	'translate-fs-userpage-level-5' => 'Je suis un traducteur professionnel de',
	'translate-fs-userpage-level-4' => 'Je la connais comme un locuteur natif',
	'translate-fs-userpage-level-3' => "J'ai une bonne maîtrise de",
	'translate-fs-userpage-level-2' => "J'ai une maîtrise modérée de",
	'translate-fs-userpage-level-1' => 'Je connais un peu',
	'translate-fs-userpage-help' => 'Veuillez indiquer vos compétences linguistiques et nous parler un peu de vous-même. Si vous connaissez plus de cinq langues, vous pourrez en ajouter plus tard.',
	'translate-fs-userpage-submit' => 'Créer ma page utilisateur',
	'translate-fs-userpage-done' => 'Bien joué ! Vous avez à présent une page utilisateur.',
	'translate-fs-permissions-planguage' => 'Langue principale:',
	'translate-fs-permissions-help' => "Maintenant, vous devez faire une demande pour être ajouté au groupe des traducteurs.
Sélectionnez la langue principale dans laquelle vous allez traduire.

Vous pouvez mentionner d'autres langues et d'autres remarques dans la zone de texte ci-dessous.",
	'translate-fs-permissions-pending' => "Votre demande a été transmise à [[$1]] et quelqu'un de l'équipe du site la vérifiera dès que possible.
Si vous confirmez votre adresse électronique, vous recevrez une notification par courriel dès que ce sera le cas.",
	'translate-fs-permissions-submit' => 'Envoyer la demande',
	'translate-fs-target-text' => "Félicitations !
Vous pouvez maintenant commencer à traduire.

Ne vous inquiétez pas si cela vous paraît un peu nouveau et étrange.
Sur la [[Project list|liste des projets]] se trouve une vue d’ensemble des projets que vous pouvez contribuer à traduire.
Ces projets possèdent, pour la plupart, une page contenant une courte description et un lien « ''Traduire ce projet'' » qui vous mènera vers une page listant tous les messages non traduits.
Une liste de tous les groupes de messages avec l’[[Special:LanguageStats|état actuel de la traduction pour une langue donnée]] est aussi disponible.

Si vous sentez que vous avez besoin de plus d’informations avant de commencer à traduire, vous pouvez lire la [[FAQ|foire aux questions]].
La documentation peut malheureusement être périmée de temps à autres.
Si vous pensez que vous devriez pouvoir faire quelque chose, sans parvenir à trouver comment, n’hésitez pas à poser la question sur la [[Support|page support]].

Vous pouvez aussi contacter les autres traducteurs de la même langue sur [[Portal_talk:$1|la page de discussion]] du [[Portal:$1|portail de votre langue]].
Si vous ne l’avez pas encore fait, [[Special:Preferences|ajustez la langue de l’interface pour qu’elle soit celle dans laquelle vous voulez traduire]]. Ainsi, les liens que vous propose le wiki seront les plus adaptés à votre situation.",
	'translate-fs-email-text' => 'Merci de bien vouloir saisir votre adresse électronique dans [[Special:Preferences|vos préférences]] et la confirmer grâce au message qui vous sera envoyé.

Cela permettra aux autres utilisateurs de vous contacter par courrier électronique.
Vous recevrez aussi un courrier d’informations au plus une fois par mois.
Si vous ne souhaitez pas recevoir ce courrier d’informations, vous pouvez le désactiver dans l’onglet « {{int:prefs-personal}} » de vos [[Special:Preferences|préférences]].',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'firststeps' => 'Premiérs pâs',
	'firststeps-desc' => '[[Special:FirstSteps|Pâge spèciâla]] por guidar los utilisators sur un vouiqui qu’utilise l’èxtension « Translate ».',
	'translate-fs-pagetitle-done' => ' - fêt !',
	'translate-fs-pagetitle' => 'Guido d’emmodâ - $1',
	'translate-fs-signup-title' => 'Enscrîde-vos',
	'translate-fs-settings-title' => 'Configurâd voutres prèferences',
	'translate-fs-userpage-title' => 'Féte voutra pâge usanciér',
	'translate-fs-permissions-title' => 'Demandâd les pèrmissions de traductor',
	'translate-fs-target-title' => 'Comenciéd a traduire !',
	'translate-fs-email-title' => 'Confirmâd voutra adrèce èlèctronica',
	'translate-fs-selectlanguage' => 'Chouèsésséd una lengoua',
	'translate-fs-settings-planguage' => 'Lengoua principâla :',
	'translate-fs-settings-slanguage' => 'Lengoua d’assistance $1 :',
	'translate-fs-settings-submit' => 'Encartar les prèferences',
	'translate-fs-userpage-submit' => 'Fâre ma pâge usanciér',
	'translate-fs-userpage-done' => 'Bien fêt ! Ora, vos avéd una pâge usanciér.',
	'translate-fs-permissions-planguage' => 'Lengoua principâla :',
	'translate-fs-permissions-submit' => 'Mandar la requéta',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'firststeps' => 'Prins pas',
	'translate-fs-pagetitle-done' => '- fat!',
	'translate-fs-signup-title' => 'Regjistriti',
	'translate-fs-settings-title' => 'Configure lis tôs preferencis',
	'translate-fs-userpage-title' => 'Cree la tô pagjine utent',
	'translate-fs-target-title' => 'Scomence a tradusi!',
	'translate-fs-email-title' => 'Conferme la tô direzion email',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'firststeps' => 'Primeiros pasos',
	'firststeps-desc' => '[[Special:FirstSteps|Páxina especial]] para iniciar aos usuarios no uso da extensión Translate',
	'translate-fs-pagetitle-done' => '; feito!',
	'translate-fs-pagetitle-pending' => '; pendente',
	'translate-fs-pagetitle' => 'Asistente para dar os primeiros pasos: $1',
	'translate-fs-signup-title' => 'Rexístrese',
	'translate-fs-settings-title' => 'Configure as súas preferencias',
	'translate-fs-userpage-title' => 'Cree a súa páxina de usuario',
	'translate-fs-permissions-title' => 'Solicite permisos de tradutor',
	'translate-fs-target-title' => 'Comece a traducir!',
	'translate-fs-email-title' => 'Confirme o seu enderezo de correo electrónico',
	'translate-fs-intro' => "Benvido ao asistente para dar os primeiros pasos en {{SITENAME}}.
Esta guía axudaralle, paso a paso, a través do proceso para se converter nun tradutor.
Cando remate, poderá traducir as ''mensaxes da interface'' de todos os proxectos soportados por {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Escolla unha lingua',
	'translate-fs-settings-planguage' => 'Lingua principal:',
	'translate-fs-settings-planguage-desc' => 'A lingua principal é tanto a lingua da interface neste wiki
como a lingua na que vai realizar as traducións.',
	'translate-fs-settings-slanguage' => 'Lingua axudante $1:',
	'translate-fs-settings-slanguage-desc' => 'É posible mostrar as traducións das mensaxes noutras linguas no editor de traducións.
Aquí pode elixir, se quere, as linguas que queira ver.',
	'translate-fs-settings-submit' => 'Gardar as preferencias',
	'translate-fs-userpage-level-N' => 'Son falante nativo de',
	'translate-fs-userpage-level-5' => 'Son tradutor profesional de',
	'translate-fs-userpage-level-4' => 'Coñézoa como un falante nativo',
	'translate-fs-userpage-level-3' => 'Teño un bo dominio de',
	'translate-fs-userpage-level-2' => 'Teño un dominio moderado de',
	'translate-fs-userpage-level-1' => 'Sei un pouco de',
	'translate-fs-userpage-help' => 'Indique as súas competencias lingüísticas e cóntenos algo sobre vostede. Se sabe máis de cinco linguas pódeas engadir máis adiante.',
	'translate-fs-userpage-submit' => 'Crear a miña páxina de usuario',
	'translate-fs-userpage-done' => 'Ben feito! Agora xa ten unha páxina de usuario.',
	'translate-fs-permissions-planguage' => 'Lingua principal:',
	'translate-fs-permissions-help' => 'Agora ten que facer unha petición para pasar a formar parte do grupo de tradutores.
Seleccione a lingua principal na que vai traducir.

Pode mencionar outras linguas ou observacións na caixa de texto inferior.',
	'translate-fs-permissions-pending' => 'A súa solicitude enviouse a "[[$1]]" e algún dos membros do persoal do sitio atenderá a petición axiña.
Se confirma o seu enderezo de correo electrónico recibirá unha notificación en canto ocorra.',
	'translate-fs-permissions-submit' => 'Enviar a solicitude',
	'translate-fs-target-text' => 'Parabéns!
Agora xa pode comezar a traducir.

Non teña medo se aínda se sente novo e confuso.
En [[Project list]] hai unha visión xeral dos proxectos nos que pode contribuír coas súas traducións.
A maioría dos proxectos teñen unha páxina cunha breve descrición e mais unha ligazón que di "\'\'Traducir este proxecto\'\'", que o levará a unha páxina que lista todas as mensaxes non traducidas.
Tamén hai dispoñible unha lista con todos os grupos de mensaxes co seu [[Special:LanguageStats|estado actual da tradución nunha lingua]].

Se pensa que necesita aprender máis antes de comezar a traducir, pode ler as [[FAQ|preguntas máis frecuentes]].
Por desgraza, a documentación pode estar desactualizada ás veces.
Se cre que hai algo que debe ser capaz de facer, pero non sabe como, non dubide en pedir [[Support|axuda]].

Tamén pode poñerse en contacto cos demais tradutores da mesma lingua na [[Portal_talk:$1|páxina de conversa]] do [[Portal:$1|portal da súa lingua]].
Se aínda non o fixo, [[Special:Preferences|cambie a lingua da interface de usuario elixindo aquela na que vai traducir]]; deste xeito, o wiki pode mostrar as ligazóns máis relevantes e que lle poidan interesar.',
	'translate-fs-email-text' => 'Proporcione o seu enderezo de correo electrónico [[Special:Preferences|nas súas preferencias]] e confírmeo mediante a mensaxe que chegará á súa bandexa de entrada.

Isto permite que outros usuarios se poñan en contacto con vostede por correo electrónico.
Tamén recibirá boletíns informativos, como máximo unha vez ao mes.
Se non quere recibir estes boletíns, pode cancelar a subscrición na lapela "{{int:prefs-personal}}" das súas [[Special:Preferences|preferencias]].',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'firststeps' => 'Erschti Schritt',
	'firststeps-desc' => '[[Special:FirstSteps|Spezialsyte]] as Hilf fir neji Benutzer zum Aafange uf eme Wiki mit dr „Translate“-Erwyterig',
	'translate-fs-pagetitle-done' => '- erledigt!',
	'translate-fs-pagetitle' => 'Hilfsprogramm zum Aafang - $1',
	'translate-fs-signup-title' => 'Regischtriere',
	'translate-fs-settings-title' => 'Dyy Yystellige aapasse',
	'translate-fs-userpage-title' => 'Dyy Benutzersyte aalege',
	'translate-fs-permissions-title' => 'E Aatrag stelle uf s Ibersetzerrächt',
	'translate-fs-target-title' => 'Aafange mit em Ibersetze!',
	'translate-fs-email-title' => 'Dyy E-Mail-Adräss bstetige',
	'translate-fs-intro' => "Willchuu bi dr {{SITENAME}}-Hilf zue dr erschte Schritt.
Dir wird zeigt, wie Du Schritt fir Schritt e Ibersetzer wirsch.
Am Änd wirsch alli ''Oberfleche-Nochrichte'' vu dr Projäkt, wu vu {{SITENAME}} unterstitzt wäre, chenne ibersetze.",
	'translate-fs-userpage-submit' => 'Myy Benutzersyte aalege',
	'translate-fs-userpage-done' => 'Guet gmacht! Du hesch jetz e Benutzersyte',
	'translate-fs-target-text' => "Glickwunsch!
Du chasch jetz aafange mit Ibersetze.

Bi nit verwirrt, wänn s dir no nej un unibersichtli vorchunnt.
Uf dr Syte [[Project list|Projäkt]] git s e Ibersicht vu dr Projäkt, wu Du chasch ibersetze.
Di meischte Projäkt hän e churzi Bschryybigssyte zämme mit eme „''Ibersetze''“- Link, wu di uf e Syte mit Nochrichte bringt, wu nonig ibersetzt sin.
E Lischt vu allne Nochrichtegruppe un em [[Special:LanguageStats|momentane Status vun ere Sproch]] git s au.

Wänn Du meh dodervu witt verstoh, chasch di [[FAQ|hyfig gstellte Froge]] läse.
Leider cha d Dokumäntation zytwyys veraltet syy.
Wänn Du ebis witt mache, weisch aber nit wie, no frog no uf dr [[Support|Hilfssyte]].

Du chasch au Ibersetzer vu Dyyre Sproch uf dr [[Portal_talk:$1|Diskussionssyte]] [[Portal:$1|vum Sprochportal]] kontaktiere.
S Portal verlinkt uf Dyyni derzytig [[Special:Preferences|Sprochyystellig]].
Bitte tue si ändere wänn netig.",
	'translate-fs-email-text' => 'Bitte gib Dyy E-Mail-Adräss yy in [[Special:Preferences|Dyyne Yystellige]] un tue d E-Mail, wu an di gschickt wird, bstetige.

Des git andere d Megligkeit, di iber E-Mail z erreiche.
Du chunnsch derno derzue eimol im Monet e Newsletter iber.
Wänn Du kei Newsletter witt iberchuu, chasch di im Tab „{{int:prefs-personal}}“ in [[Special:Preferences|Dyyne Yystellige]] uustrage.',
);

/** Hawaiian (Hawai`i)
 * @author Kolonahe
 */
$messages['haw'] = array(
	'firststeps' => 'Nā Mea Mua Loa',
	'firststeps-desc' => '[[Special:FirstSteps|Special page]] no ka hoʻomaka ʻana o nā mea hoʻohana ma kekahi wiki i hoʻohana i ka pākuʻi unuhi',
	'translate-fs-pagetitle-done' => ' - hoʻopau ʻia!',
	'translate-fs-pagetitle' => 'Polokalamu Hana Kōkua me ka Hoʻomaka ʻana - $1',
	'translate-fs-signup-title' => 'Kāinoa',
	'translate-fs-settings-title' => 'Hoʻololi i Kau Makemake',
	'translate-fs-userpage-title' => 'Hana i Kau ʻAoʻao Mea hoʻohana',
	'translate-fs-permissions-title' => 'Noi no nā ʻAe Unuhi',
	'translate-fs-target-title' => 'E Hoʻomaka i ka ʻUnuhina!',
	'translate-fs-email-title' => 'Hōʻoia i Kau Wahi leka uila',
	'translate-fs-intro' => 'Welina mai i ke Polokalamu hana kōkua no nā mea hana mua loa o {{SITENAME}}.
E  alakaʻi ana ʻoe i kēia hana o ka lilo ʻana i mea unuhi.
Ma ka hopena, hiki iā ʻoe ke uhuhi i nā "leka aloloko" o nā papa hana a pau i kākoʻo ʻia ma {{SITENAME}}.',
	'translate-fs-userpage-submit' => 'Hana i kaʻu ʻaoʻao mea hoʻohana',
	'translate-fs-userpage-done' => 'Maikaʻi! Loaʻa ka ʻaoʻao mea hoʻohana i kēia manawa.',
	'translate-fs-target-text' => 'Hoʻomaikaʻi ʻana!
Hiki ke hoʻomaka i ka uhuni ʻana.

Mai makaʻu inā huikau ʻoe.
Ma [[Project list]], aia kekahi ʻike piha o nā papa hana i hiki iā ʻoe ke kōkua.
ʻO ka nui o nā papa hana, loaʻa kekahi ʻaoʻao kikoʻī pōkole me kekahi loulou "\'\'Translate this project\'\'" e lawe ana ʻoe i kekahi ʻaoʻao i helu i nā leka unuhi ʻole.
Loaʻa nō hoʻi kekahi helu no nā leka hui a pau me ke [[Special:LanguageStats|nā kūlana unuhi o kēia wa no kekahi ʻōlelo]].

Inā makemake ʻoe e maopopo ma mua hoʻi o kou unuhi ʻana, hiki ke heluhelu i ka [[FAQ|Nīnau i nīnau pinepine]].
Akā hiki i nā hana palapala ke hele a kahiko i kekahi mau manawa.
Inā loaʻa kekahi mau mea āu i noʻonoʻo hiki paha iā ʻoe ke hana, akā ʻaʻole maopopo, mai nīnau ʻole ma ke [[Support|ʻaoʻao kākoʻo]].

Hiki ke walaʻau kekahi me nā mea unuhi ʻē aʻe o ka ʻōlelo like ma loko o ko [[Portal:$1|kau wahi ʻōlelo]] [[Portal_talk:$1|ʻaoʻao kūkākūkā]].
Inā ʻaʻole i hana, [[Special:Preferences|hoʻololi i kau mea hoʻohana aloloko ʻōlelo i ka ʻōlelo āu e makemake e unuhi]], i hiki i ka wiki ke hōʻike i nā loulou e pili ana nau.',
	'translate-fs-email-text' => 'E ʻoluʻolu, e kau kau wahi leka uila i loko o [[Special:Preferences|kau makemake]] a ʻae mai loko o ka leka uila e hoʻouna ana iā ʻoe.

Hiki i kēia ʻano hana ke hoʻokuʻu i nā mea hoʻohana ʻē aʻe ke walaʻau me ʻoe i ka leka uila ʻana.
E loaʻa ana nā nū hou i hoʻokahi manawa kēlā me kēia māhina.
Inā ʻaʻole makemake e loaʻa nā nū hou, hiki ke pale i ke kāwāholo "{{int:prefs-personal}}" o kau [[Special:Preferences|makemake]].',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'firststeps' => 'הצעדים הראשונים',
	'firststeps-desc' => 'דף מיוחד כדי לעזור למשתמשים להתחיל לעבוד בוויקי שמשתמש בהרחבת תרגום',
	'translate-fs-pagetitle-done' => ' - בוצע!',
	'translate-fs-pagetitle-pending' => ' - בהמתנה',
	'translate-fs-pagetitle' => 'אשף תחילת עבודה – $1',
	'translate-fs-signup-title' => 'הרשמה',
	'translate-fs-settings-title' => 'הגדרת ההעדפות שלך',
	'translate-fs-userpage-title' => 'ליצור את דף המשתמש שלך',
	'translate-fs-permissions-title' => 'לבקש הרשאות מתרגם',
	'translate-fs-target-title' => 'להתחיל לתרגם!',
	'translate-fs-email-title' => 'לאשר את כתובת הדוא״ל',
	'translate-fs-intro' => "ברוכים הבאים לאשף הצעדים הראשונים של אתר {{SITENAME}}.
האשף ידריך אתכם בתהליך שיהפוך אתכם לחלק מצוות המתרגמים.
בסופו תוכלו לתרגם '''הודעות ממשק''' של כל הפרויקטים הנתמכים באתר {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'בחירת שפה',
	'translate-fs-settings-planguage' => 'שפה עיקרית:',
	'translate-fs-settings-planguage-desc' => 'השפה העיקרית היא גם שפת הממשק בוויקי הזה
ושפת היעד לתרגומים לפי בררת המחדל.',
	'translate-fs-settings-slanguage' => 'שפת עזר $1:',
	'translate-fs-settings-slanguage-desc' => 'אפשר להראות תרגומים של הודעות לשפות אחרות בעורך התרגומים.
כאן אפשר לבחור אילו שפות, אם בכלל, תרצו לראות.',
	'translate-fs-settings-submit' => 'שמירת העדפות',
	'translate-fs-userpage-level-N' => 'אני דובר ילידי של',
	'translate-fs-userpage-level-5' => 'אני מתרגם מקצועי בשפה הזאת',
	'translate-fs-userpage-level-4' => 'אני יודע אותה כמו דובר ילידי',
	'translate-fs-userpage-level-3' => 'אני יודע טוב',
	'translate-fs-userpage-level-2' => 'אני יודע באופן בינוני',
	'translate-fs-userpage-level-1' => 'אני יודע קצת',
	'translate-fs-userpage-help' => 'אנא ציינו את כישורי השפה שלכם וספרו לנו כמה דברים על עצמכם. אם אתם יודעים יותר מחמש שפות, אפשר להוסיף אותן מאוחר יותר.',
	'translate-fs-userpage-submit' => 'יצירת דף המשתמש שלי',
	'translate-fs-userpage-done' => 'מצוין! כעת יש לך דף משתמש.',
	'translate-fs-permissions-planguage' => 'שפה עיקרית:',
	'translate-fs-permissions-help' => 'עכשיו צריך להעלות בקשה להתווסף לקבוצת מתרגמים.
נא לבחור את השפה העיקרית שתתרגמו אליה.

אפשר להזכיר שפות אחרות והערות אחרות בתיבה להלן.',
	'translate-fs-permissions-pending' => 'בקשתך נשלחה אל [[$1]] ומישהו מסגל האתר יבדוק אותה מהר ככל האפשר.
אם תאמתו את הכתובת הדואר האקטרוני שלכם, תקבלו הודעה כשזה יקרה.',
	'translate-fs-permissions-submit' => 'שליחת בקשה',
	'translate-fs-target-text' => "מזל טוב!
כעת, תוכלו להתחיל לתרגם.

אל תפחדו אם האתר הזה עדיין נראה לכם מבלבל וחדש.
ב[[Project list|רשימת הפרויקטים]] יש סקירה של פרויקטים שתוכלו לתרום להם תרגומים.
לרוב הפרויקטים יש דף תיאור קצר עם קישור \"'''לתרגם פרוייקט זה'''\", שיוביל אותך אל דף המפרט את כל ההודעות שאינן מתורגמות.
יש גם רשימה של כל קבוצות ההודעות עם [[Special:LanguageStats|המצב הנוכחי של תרגום אל השפה]].

אם אתם מרגישים שאתם צריכים להבין עוד לפני שתתחילו לתרגם, תוכלו לקרוא את [[FAQ|דף שאלות נפוצות]].
למרבה הצער התיעוד יכול להיות לעתים לא עדכני.
אם יש משהו שנראה לכם שאמורה להיות לכם אפשרות לעשות, ואתם לא מוצאים איך, אל תהססו לשאול אותו בדף [[Support]].

ניתן גם לפנות אל המתרגמים העמיתים באותה השפה ב[[Portal_talk:\$1|דף השיחה]] של [[Portal:\$1|פורטל השפה שלכם]].
אם טרם עשיתם זאת, [[Special:Preferences|שנו את שפת הממשק את השפה שאליה אתם רוצים לתרגם]], כדי שהוויקי הזה יציג את הקישורים המתאימים ביותר עבורכם.",
	'translate-fs-email-text' => 'נא להקליד את כתובת הדואר האלקטרוני שלכם ב[[Special:Preferences|דף ההעדפות]] ואשרו אותו באמצעות המכתב שיישלח אליכם.

פעולה זו מאפשרת למשתמשים אחרים ליצור אִתכם קשר באמצעות דואר אלקטרוני.
כמו־כן, תקבלו ידיעונים, לכל היותר פעם בחודש.
אם אינכם רוצים לקבל ידיעונים, תוכלי לבטל זאת בלשונית "{{int:prefs-personal}}" של [[Special:Preferences|דף ההעדפות]].',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'firststeps' => 'Prvi koraci',
	'translate-fs-pagetitle-done' => ' - učinjeno!',
	'translate-fs-signup-title' => 'Prijavite se',
	'translate-fs-settings-title' => 'Namjestite vaše postavke',
	'translate-fs-userpage-title' => 'Stvorite svoju suradničku stranicu',
	'translate-fs-permissions-title' => 'Zatražite prevoditeljski status',
	'translate-fs-target-title' => 'Počnite prevoditi poruke!',
	'translate-fs-email-title' => 'Potvrdite svoju adresu e-pošte',
	'translate-fs-userpage-submit' => 'Stvori moju suradničku stranicu',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'firststeps' => 'Prěnje kroki',
	'firststeps-desc' => '[[Special:FirstSteps|Specialna strona]] za startowu pomoc na wikiju, kotryž rozšěrjenje Translate wužiwa',
	'translate-fs-pagetitle-done' => ' - sčinjene!',
	'translate-fs-pagetitle-pending' => '´- wobdźěłuje so',
	'translate-fs-pagetitle' => 'Startowy asistent - $1',
	'translate-fs-signup-title' => 'Registrować',
	'translate-fs-settings-title' => 'Konfiguruj swoje nastajenja',
	'translate-fs-userpage-title' => 'Wutwor swoju wužiwarsku stronu',
	'translate-fs-permissions-title' => 'Wo přełožowanske prawa prosyć',
	'translate-fs-target-title' => 'Započń přełožować!',
	'translate-fs-email-title' => 'Wobkruć swoju e-mejlowu adresu',
	'translate-fs-intro' => "Witaj do startoweho asistenta projekta {{SITENAME}}.
Dóstanješ nawod krok po kroku, kak so z přełožowarjom stanješ.
Na kóncu móžeš ''zdźělenki programoweho powjercha'' wšěch podpěrowanych projektow na {{SITENAME}} přełožić.",
	'translate-fs-selectlanguage' => 'Wubjer rěč',
	'translate-fs-settings-planguage' => 'Hłowna rěč:',
	'translate-fs-settings-planguage-desc' => 'Hłowna rěč ma dwě funkciji: słuži jako rěč wužiwarskeho powjercha w tutym wikiju a jako standardna cilowa rěč za přełožki.',
	'translate-fs-settings-slanguage' => 'Pomocna rěč $1:',
	'translate-fs-settings-slanguage-desc' => 'Je móžno přełožki zdźělenkow w druhich rěčach w přełožowanskim editorje pokazać.
Tu móžeš wubrać, kotre rěče chceš rady widźeć.',
	'translate-fs-settings-submit' => 'Nastajenja składować',
	'translate-fs-userpage-level-N' => 'Sym maćernorěčnik',
	'translate-fs-userpage-level-5' => 'Sym profesionalny přełožowar',
	'translate-fs-userpage-level-4' => 'Mam znajomosće maćernorěčnika',
	'translate-fs-userpage-level-3' => 'Mam dobre znajomosće',
	'translate-fs-userpage-level-2' => 'Mam přerězne znajomosće',
	'translate-fs-userpage-level-1' => 'Mam snadne znajomosće',
	'translate-fs-userpage-help' => 'Prošu podaj swoje rěčne znajomosće a zdźěl nam něšto wo sebje. Jeli maš znajomosće we wjace hač pjeć rěčach, móžeš je pozdźišo podać.',
	'translate-fs-userpage-submit' => 'Moju wužiwarsku stronu wutworić',
	'translate-fs-userpage-done' => 'Gratulacija! Maš nětko wužiwarsku stronu.',
	'translate-fs-permissions-planguage' => 'Hłowna rěč:',
	'translate-fs-permissions-help' => 'Dyrbiš nětko naprašowanje stajić, zo by so do skupiny přełožowarjow přiwzał.
Wubjer hłownu rěč, do kotrejež chceš přełožować.

Móžeš druhe rěče a druhe přispomnjenki w slědowacym tekstowym polu podać.',
	'translate-fs-permissions-pending' => 'Twoje naprašowanje je so do [[$1]] wotpósłało a něchtó z teama translatewiki.net budźe jo tak bórze kaž móžno přehladować. Jeli swoju e-mejlowu adresu wobkrućiš, dóstanješ e-mejlowu zdźělenku, tak chětře kaž je so to stało.',
	'translate-fs-permissions-submit' => 'Naprašowanje pósłać',
	'translate-fs-target-text' => 'Zbožopřeće!
Móžeš nětko přełožowanje započeć.

Nječiń sej žane starosće, jeli so ći hišće nowe a konfuzne zda.
Na [[Project list|lisćinje projektow]] je přehlad projektow, ke kotrymž móžeš přełožki přinošować.
Najwjace projektow ma krótku wopisansku stronu z wotkazom "\'\'Tutón projekt přełožić\'\'", kotryž će k stronje wjedźe, kotraž wšě njepřełožene zdźělenki nalistuje.
Lisćina wšěch skupinow zdźělenkow z [[Special:LanguageStats|aktualnym přełožowanskim stawom za rěč]] tež k dispoziciji steji.

Jeli měniš, zo dyrbiš najprjedy wjace rozumić, prjedy hač zapóčnješ přełožować, móžeš [[FAQ|Časte prašenja]] čitać.
Bohužel móže dokumentacija druhdy zestarjena być.
Jeli něšto je, wo kotrymž mysliš, zo měło móžno być, ale njenamakaš, kak móžeš to činić, prašej so woměrje na stronje [[Support|Podpěra]].

Móžeš so tež ze sobupřełožowarjemi samsneje rěče na [[Portal_talk:$1|diskusijnej stronje]] [[Portal:$1|portala swojeje rěče]] do zwiska stajić.
Jeli hišće njejsy to činił, [[Special:Preferences|změń swój wužiwarski powjerch do rěče, do kotrejež chceš přełožować]], zo by wiki móhł wotkazy pokazać, kotrež su relewantne za tebje.',
	'translate-fs-email-text' => 'Prošu podaj swoju e-mejlowu adresu w [[Special:Preferences|swojich nastajenjach]] a wobkruć ju přez e-mejl, kotraž so ći sćele.

To dowola druhim wužiwarjam, so z tobu přez e-mejl do zwiska stajić.
Dóstanješ tež powěsćowe listy, zwjetša jónkróć wob měsac.
Jeli nochceš powěsćowe listy dóstać, móžeš tutu opciju na rajtarku "{{int:prefs-personal}}" swojich [[Special:Preferences|nastajenjow]] znjemóžnić.',
);

/** Haitian (Kreyòl ayisyen)
 * @author Boukman
 */
$messages['ht'] = array(
	'firststeps' => 'Premye etap yo',
	'firststeps-desc' => '[[Special:FirstSteps|Paj espesyal]] pou gide itilizatè yo sou yon wiki ki sèvi ak ekstansyon Tradiksyon',
	'translate-fs-pagetitle-done' => '- fini!',
	'translate-fs-pagetitle' => 'Gid pou komanse - $1',
	'translate-fs-signup-title' => 'Anrejistre ou',
	'translate-fs-settings-title' => 'Konfigire preferans ou yo',
	'translate-fs-userpage-title' => 'Kreye paj itilizatè ou an',
	'translate-fs-permissions-title' => 'Mande pou otorizasyon tradiktè yo',
	'translate-fs-target-title' => 'Kòmanse tradui!',
	'translate-fs-email-title' => 'Konfime adrès imèl ou an',
	'translate-fs-intro' => "Byenveni nan asistan premye etap {{SITENAME}}.
N ap gide ou atravè tout etap pwosesis pou ou vin yon tradiktè.
Lè ou rive nan bout pwosesis sa, w ap kapab tradui tou ''mesaj entèfas'' pou tout pwojè ki sipòte nan {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Kreye paj itilizatè mwen',
	'translate-fs-userpage-done' => 'Byen fè!  Kounye a ou gen yon paj itilizatè.',
	'translate-fs-target-text' => 'Konpliman!
Ou kapab komanse tradui kounye a.

Ou pa bezwen pè si ou santi bagay sa nouvo epi le ba ou konfizyon.
Nan [[Project list|Lis pwojè yo]], genyen yon apèsi tout projè ou kapab kontribye tradiksyon pou yo.
Pifò nan pwojè yo gen yon paj ki bay yon deskripsyon kout avèk yon lyen "\'\'Tradui pwojè sa a\'", k ap mennen ou nan yon paj ki liste tout mesaj ki poko tradui.
Yon lis ak tout gwoup mesaj yo ki bay [[Special:LanguageStats|estati tradiksyon yo pou yon lang]] disponib tou.

Si ou santi ou ta bezwen konnen pi plis anvan ou komanse tradui, ou ka li [[FAQ|Kesyon ki mande souvan]].
Malerezman, dokimantasyon gendwa pa a jou.
Si gen yon bagay ou panse ou ta dwe kapab fè, men ou pa ka jwenn kijan, pa ezite mande nan [[Support|paj sipò]].

Ou kapab kontakte lòt tradiktè nan menm lang tou nan [[Portal_talk:$1|paj diskisyon]] pou [[Portal:$1|potay pou lang ou an]].
Si ou poko fè sa, [[Special:Preferences|chanje lang entèfas itilizatè ou an pou l sèvi ak lang ou pral tradui ladan l]]',
	'translate-fs-email-text' => 'Tanpri, bay adrès imèl ou an nan [[Special:Preferences|preferans ou yo]] epi konfime l depi imèl ki te voye ba ou.

Sa ap pèmèt lòt itilizatè kontakte ou pa imèl.
W ap resevwa nouvèl tou yon fwa pa mwa o maksimòm.
Si ou pa vle resevwa nouvèl, ou kapab retire ou nan opsyon sa nan onglè "{{int:prefs-personal}}" ki nan [[Special:Preferences|preferans ou yo]].',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Misibacsi
 */
$messages['hu'] = array(
	'firststeps' => 'Első lépések',
	'firststeps-desc' => '[[Special:FirstSteps|Speciális lap]], ami felkészíti az új felhasználókat a fordító kiterjesztés használatára',
	'translate-fs-pagetitle-done' => ' - kész!',
	'translate-fs-pagetitle' => 'Első lépések varázsló – $1',
	'translate-fs-signup-title' => 'Regisztráció',
	'translate-fs-settings-title' => 'Nézd át a beállításaidat!',
	'translate-fs-userpage-title' => 'Hozz létre egy felhasználói lapot',
	'translate-fs-permissions-title' => 'Kérj fordítói jogosultságot!',
	'translate-fs-target-title' => 'Kezdj fordítani!',
	'translate-fs-email-title' => 'Erősítsd meg az e-mail címedet!',
	'translate-fs-intro' => "Üdvözlünk a {{SITENAME}} használatának első lépéseiben segítő varázslóban!
Lépésről lépésre segítünk a fordítóvá válás folyamatában.
A végén hozzákezdhetsz bármelyik, {{SITENAME}} által támogatott projekt ''felületének üzeneteinek'' fordításához.",
	'translate-fs-settings-submit' => 'Beállítások mentése',
	'translate-fs-userpage-submit' => 'Felhasználói lap létrehozása',
	'translate-fs-userpage-done' => 'Felhasználói lap létrehozva.',
	'translate-fs-permissions-planguage' => 'Elsődleges nyelv:',
	'translate-fs-target-text' => "Gratulálunk!
Most már elkezdhetsz fordítani.

Ne ijedj meg, ha még új a felület, és valami összezavar.
A [[Project list|projektlista]] lapon megtalálod azon projektek listáját, melyek fordításában részt vehetsz.
A legtöbb projekthez tartozik egy rövid leírás és egy „''Projekt fordítása''” hivatkozás, ami elvezet arra a lapra, ahol a fordítatlan üzenetek vannak listázva.
Rendelkezésre áll egy olyan lista is, ahol az üzenetcsoportok tekinthetőek meg, a hozzátartozó, [[Special:LanguageStats|adott nyelvre vonatkozó fordítási állapottal]].

Ha a fordítás előtt inkább tájékozódni szeretnél, olvasd el a [[FAQ|gyakran ismételt kérdéseket]].
Sajnos a dokumentáció néha kicsit elavult lehet.
Ha úgy érzed, hogy valamit meg tudnál csinálni, de nem jössz rá, hogyan, ne habozz, kérdezz a [[Support|támogatással foglalkozó oldalon]].

Kapcsolatba léphetsz fordítótársaiddal a [[Portal:$1|nyelvedhez tartozó portál]] [[Portal_talk:$1|vitalapján]] keresztül.
Ha még nem tetted meg, [[Special:Preferences|állítsd át a felhasználói felületed nyelvét arra a nyelvre, amire fordítani szeretnél]], hogy a wiki a megfelelő linkeket tudja nyújtani neked.",
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'firststeps' => 'Prime passos',
	'firststeps-desc' => '[[Special:FirstSteps|Pagina special]] pro familiarisar le usatores de un wiki con le extension Translate',
	'translate-fs-pagetitle-done' => ' - finite!',
	'translate-fs-pagetitle-pending' => ' - pendente',
	'translate-fs-pagetitle' => 'Assistente de initiation - $1',
	'translate-fs-signup-title' => 'Crear un conto',
	'translate-fs-settings-title' => 'Configurar tu preferentias',
	'translate-fs-userpage-title' => 'Crear tu pagina de usator',
	'translate-fs-permissions-title' => 'Requestar permissiones de traductor',
	'translate-fs-target-title' => 'Comenciar a traducer!',
	'translate-fs-email-title' => 'Confirmar tu adresse de e-mail',
	'translate-fs-intro' => "Benvenite al assistente de initiation de {{SITENAME}}.
Tu essera guidate passo a passo trans le processo de devenir traductor.
Al fin tu potera traducer le ''messages de interfacie'' de tote le projectos supportate in {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Selige un lingua',
	'translate-fs-settings-planguage' => 'Lingua primari:',
	'translate-fs-settings-planguage-desc' => 'Le lingua primari es usate como le lingua de interfacie in iste wiki
e como le lingua de destination predefinite pro traductiones.',
	'translate-fs-settings-slanguage' => 'Lingua assistente $1:',
	'translate-fs-settings-slanguage-desc' => 'Es possibile monstrar traductiones de messages in altere linguas in le editor de traductiones.
Hic tu pote seliger le linguas que tu vole vider (si desirate).',
	'translate-fs-settings-submit' => 'Confirmar preferentias',
	'translate-fs-userpage-level-N' => 'Io es un parlante native de',
	'translate-fs-userpage-level-5' => 'Io es un traductor professional de',
	'translate-fs-userpage-level-4' => 'Io ha cognoscentia quasi native de',
	'translate-fs-userpage-level-3' => 'Io ha un bon maestria de',
	'translate-fs-userpage-level-2' => 'Io ha un maestria moderate de',
	'translate-fs-userpage-level-1' => 'Io cognosce un poco de',
	'translate-fs-userpage-help' => 'Per favor indica tu habilitates linguistic e dice nos qualcosa super te. Si tu cognosce plus de cinque linguas, tu pote adder alteres plus tarde.',
	'translate-fs-userpage-submit' => 'Crear mi pagina de usator',
	'translate-fs-userpage-done' => 'Ben facite! Tu ha ora un pagina de usator.',
	'translate-fs-permissions-planguage' => 'Lingua primari:',
	'translate-fs-permissions-help' => 'Ora tu debe poner un requesta de esser addite al gruppo de traductores.
Selige le lingua primari in le qual tu va traducer.

Tu pote mentionar altere linguas e altere remarcas in le quadro de texto hic infra.',
	'translate-fs-permissions-pending' => 'Tu requesta ha essite submittite a [[$1]] e un persona del personal del sito lo verificara si presto como possibile.
Si tu confirma tu adresse de e-mail, tu recipera un notification in e-mail al momento que isto eveni.',
	'translate-fs-permissions-submit' => 'Inviar requesta',
	'translate-fs-target-text' => 'Felicitationes!
Tu pote ora comenciar a traducer.

Non sia intimidate si isto te pare ancora nove e confundente.
In [[Project list]] il ha un summario del projectos al quales tu pote contribuer traductiones.
Le major parte del projectos ha un curte pagina de description con un ligamine "\'\'Traducer iste projecto\'\'", que te portara a un pagina que lista tote le messages non traducite.
Un lista de tote le gruppos de messages con le [[Special:LanguageStats|stato de traduction actual pro un lingua]] es etiam disponibile.

Si tu senti que tu ha besonio de comprender plus ante de traducer, tu pote leger le [[FAQ|folio a questiones]].
Infelicemente le documentation pote a vices esser obsolete.
Si il ha un cosa que tu pensa que tu deberea poter facer, ma non succede a discoperir como, non hesita a poner le question in le [[Support|pagina de supporto]].

Tu pote etiam contactar altere traductores del mesme lingua in [[Portal_talk:$1|le pagina de discussion]] del [[Portal:$1|portal de tu lingua]].
Si tu non ja lo ha facite, [[Special:Preferences|cambia tu lingua de interfacie de usator al lingua in le qual tu vole traducer]], de sorta que le wiki pote monstrar te le ligamines le plus relevante a te.',
	'translate-fs-email-text' => 'Per favor entra tu adresse de e-mail in [[Special:Preferences|tu preferentias]] e confirma lo per medio del e-mail que te essera inviate.

Isto permitte que altere usatores te contacta via e-mail.
Tu recipera anque bulletines de novas al plus un vice per mense.
Si tu non vole reciper bulletines de novas, tu pote disactivar los in le scheda "{{int:prefs-personal}}" de tu [[Special:Preferences|preferentias]].',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'firststeps' => 'Langkah pertama',
	'firststeps-desc' => '[[Special:FirstSteps|Halaman istimewa]] untuk mendapatkan pengguna memulai di wiki menggunakan ekstensi Terjemahan',
	'translate-fs-pagetitle-done' => '- Selesai!',
	'translate-fs-pagetitle' => 'Wisaya perkenalan - $1',
	'translate-fs-signup-title' => 'Mendaftar',
	'translate-fs-settings-title' => 'Mengkonfigurasi preferensi anda',
	'translate-fs-userpage-title' => 'Buat halaman pengguna anda',
	'translate-fs-permissions-title' => 'Permintaan izin penerjemah',
	'translate-fs-target-title' => 'Mulai menerjemahkan!',
	'translate-fs-email-title' => 'Konfirmasikan alamat surel Anda',
	'translate-fs-intro' => "Selamat datang di wisaya tahapan pertama {{SITENAME}}.
Anda akan dipandu melalui proses untuk menjadi seorang penerjemah tahap demi tahap.
Hasilnya Anda akan mampu menerjemahkan ''pesan antarmuka'' semua proyek yang didukung di {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Buat halaman pengguna saya',
	'translate-fs-userpage-done' => 'Bagus! Sekarang Anda memiliki halaman pengguna.',
	'translate-fs-target-text' => 'Selamat!
Sekarang Anda dapat mulai menerjemahkan.

Jangan takut apabila masih terasa baru dan membingungkan Anda.
Di [[Project list]] ada gambaran mengenai proyek yang dapat Anda sumbangkan terjemahannya.
Sebagian besar proyek memiliki halaman deskripsi pendek dengan pranala "\'\'Terjemahkan proyek ini\'\'", pranala tersebut akan membawa Anda ke halaman yang berisi daftar semua pesan yang belum diterjemahkan.
Daftar semua grup pesan dengan [[Special:LanguageStats|status terjemahan saat ini untuk suatu bahasa]] juga tersedia.

Jika Anda merasa bahwa Anda perlu untuk memahami lebih lanjut sebelum mulai menerjemahkan, Anda dapat membaca [[FAQ|Pertanyaan-pertanyaan yang Sering Diajukan]].
Sayangnya dokumentasi kadang dapat kedaluwarsa.
Jika ada sesuatu yang Anda pikir Anda harus mampu lakukan, tetapi tidak dapat menemukan caranya, jangan ragu untuk menanyakannya di [[Support|halaman dukungan]].

Anda juga dapat menghubungi sesama penerjemah bahasa yang sama di [[Portal_talk:$1|halaman pembicaraan]] [[Portal:$1|portal bahasa Anda]].
Jika Anda belum melakukannya, [[Special:Preferences|ubah bahasa antarmuka pengguna Anda menjadi bahasa terjemahan Anda]] sehingga wiki dapat menunjukkan pranala paling relevan untuk Anda.',
	'translate-fs-email-text' => 'Mohon masukkan alamat surel Anda di [[Special:Preferences|preferensi Anda]] dan konfirmasikan dari surel yang dikirimkan ke Anda.

Tindakan ini memungkinkan pengguna lain menghubungi Anda melalui surel.
Anda juga akan menerima langganan berita sekali sebulan.
Jika Anda tidak ingin menerima langganan berita, Anda dapat memilih tidak di tab "{{int:prefs-personal}}" di [[Special:Preferences|preferensi]] Anda.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'translate-fs-pagetitle-done' => '- ọméchá!',
);

/** Icelandic (Íslenska)
 * @author Snævar
 */
$messages['is'] = array(
	'firststeps' => 'Fyrstu skrefin',
	'translate-fs-pagetitle-done' => '- búið!',
	'translate-fs-pagetitle-pending' => '- í bið',
	'translate-fs-signup-title' => 'Skráðu þig',
	'translate-fs-settings-title' => 'Breyttu stillingunum þínum',
	'translate-fs-userpage-title' => 'Búðu til notendasíðu',
	'translate-fs-permissions-title' => 'Óskaðu eftir þýðingar réttindum',
	'translate-fs-target-title' => 'Byrjaðu að þýða!',
	'translate-fs-email-title' => 'Staðfestu netfangið þitt',
	'translate-fs-selectlanguage' => 'Veldu tungumál',
	'translate-fs-settings-planguage' => 'Fyrsta tungumál:',
	'translate-fs-settings-planguage-desc' => 'Fyrsta tungumál verður notað bæði sem viðmótstungumálið þitt á þessum wiki og sjálfgefið tungumál fyrir þýðingar.',
	'translate-fs-settings-slanguage' => 'Aðstoðar tungumál: $1',
	'translate-fs-settings-slanguage-desc' => 'Það er hægt að sýna þýðingar fyrir skilaboð á öðrum tungumálum í þýðingar viðmótinu.
Hér getur þú valið hvaða tungumál, ef einhver, þú villt sjá.',
	'translate-fs-settings-submit' => 'Vista stillingar',
	'translate-fs-userpage-level-N' => 'Móðurmál mitt er',
	'translate-fs-userpage-level-5' => 'Ég hef atvinnufærni í',
	'translate-fs-userpage-level-4' => 'Ég tala málið eins og innfæddur',
	'translate-fs-userpage-level-3' => 'Ég hef yfirburðarkunnáttu á',
	'translate-fs-userpage-level-2' => 'Ég hef miðlungskunnáttu á',
	'translate-fs-userpage-level-1' => 'Ég hef grundvallarkunnáttu á',
	'translate-fs-userpage-help' => 'Vinsamlegast gefðu upp færni þína á tungumálinu og segðu okkur eitthvað um þig. Ef þú þekkir fleiri en fimm tungumál, þá getur þú bætt við fleirum seinna.',
	'translate-fs-userpage-submit' => 'Búðu til notendasíðuna mína',
	'translate-fs-userpage-done' => 'Vel gert! Þú hefur nú notendasíðu.',
	'translate-fs-permissions-planguage' => 'Fyrsta tungumál:',
	'translate-fs-permissions-help' => 'Nú þarft þú að óska eftir að fá þýðinda réttindi.
Veldu það tungumál sem þú ætlar að þýða á.

Þú getur nefnt önnur tungumál og athugasemdir í texta boxinu hér fyrir neðan.',
	'translate-fs-permissions-pending' => 'Beiðni þín hefur verið sent til [[$1]] og starfsmaður síðunnar mun fara yfir hana eins fljótt og auðið er.
Ef þú staðfestir netfangið þitt, þá færð þú tölvupóst um leið og það gerist.',
	'translate-fs-permissions-submit' => 'Senda beiðni',
	'translate-fs-email-text' => 'Vinsamlegast tilgreindu netfangið þitt í [[Special:Preferences|stillingunum þínum]] og staðfestu það frá tölvupóstinum sem er sendur til þín.

Þetta gerir öðrum notendum kleift að hafa samband við þig með tölvupósti.
Þú munt einnig fá fréttabréf allt að einu sinni í mánuði.
Ef þú villt ekki fá send fréttabréf þá getur þú afvirkjað möguleikann undir "{{int:prefs-personal}}" flipanum í [[Special:Preferences|stillingunum þínum]]',
);

/** Italian (Italiano)
 * @author Nemo bis
 */
$messages['it'] = array(
	'firststeps' => 'Primi passi',
	'firststeps-desc' => "[[Special:FirstSteps|Pagina speciale]] per aiutare gli utenti nei loro inizi in un wiki che fa uso dell'estensione Translate.",
	'translate-fs-pagetitle-done' => '- fatto!',
	'translate-fs-pagetitle-pending' => '- in attesa',
	'translate-fs-pagetitle' => 'Percorso guidato per i primi passi - $1',
	'translate-fs-signup-title' => 'Registrati',
	'translate-fs-settings-title' => 'Configura le tue preferenze',
	'translate-fs-userpage-title' => 'Crea la tua pagina utente',
	'translate-fs-permissions-title' => 'Richiedi i permessi per tradurre',
	'translate-fs-target-title' => 'Comincia a tradurre!',
	'translate-fs-email-title' => 'Conferma il tuo indirizzo e-mail',
	'translate-fs-intro' => "Benvenuto/a nel percorso guidato per i primi passi in {{SITENAME}}.
Sarai guidato passo passo nel processo di diventare un traduttore.
Alla fine sarai in grado di tradurre i ''messaggi di sistema'' di tutti i progetti supportati da {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Scegli una lingua',
	'translate-fs-settings-planguage' => 'Lingua principale:',
	'translate-fs-settings-planguage-desc' => "La tua lingua principale funge per te sia da lingua dell'interfaccia del wiki sia da lingua predefinita in cui tradurre.",
	'translate-fs-settings-slanguage' => 'Lingua di confronto $1:',
	'translate-fs-settings-slanguage-desc' => "È possibile mostrare le traduzioni dei messaggi in altre lingue nell'interfaccia di traduzione.
Qui puoi scegliere eventualmente quali lingue vuoi vedere.",
	'translate-fs-settings-submit' => 'Salva preferenze',
	'translate-fs-userpage-level-N' => 'Sono madrelingua in',
	'translate-fs-userpage-level-5' => 'Sono un traduttore professionista di',
	'translate-fs-userpage-level-4' => 'La conosco come un madrelingua.',
	'translate-fs-userpage-level-3' => 'Ho una buona conoscenza di',
	'translate-fs-userpage-level-2' => 'Ho una discreta conoscenza di',
	'translate-fs-userpage-level-1' => "Conosco un po' di",
	'translate-fs-userpage-help' => 'Indica le tue abilità linguistiche e dicci qualcosa di te. Se conosci più di cinque lingue puoi aggiungerne altre in seguito.',
	'translate-fs-userpage-submit' => 'Crea la mia pagina utente',
	'translate-fs-userpage-done' => 'Ben fatto! Ora hai una pagina utente.',
	'translate-fs-permissions-planguage' => 'Lingua principale:',
	'translate-fs-permissions-help' => 'Ora devi fare richiesta per essere aggiunto al gruppo dei traduttori.
Seleziona la lingua principale in cui vuoi tradurre.

Puoi indicare altre lingue e altre informazioni rilevanti nella casella di testo sottostante.',
	'translate-fs-permissions-pending' => "La tua richiesta è stata pubblicata in [[$1]] e un membro dell'organico del sito la verificherà al più presto.
Se confermi il tuo indirizzo e-mail, riceverai una notifica via e-mail appena succederà.",
	'translate-fs-permissions-submit' => 'Invia richiesta',
	'translate-fs-target-text' => "Congratulazioni!
Ora puoi cominciare a tradurre.

Non preoccuparti se tutto ti sembra ancora nuovo e ti confonde.
Alla pagina [[Project list]] c'è una panoramica dei progetti alla cui traduzione puoi collaborare.
La maggior parte dei progetti ha una breve pagina di descrizione con un collegamento \"''Traduci questo progetto''\" che ti porterà a una pagina che elenca tutti i messaggi rimasti da tradurre.
C'è anche un elenco di tutti i gruppi di messaggi con [[Special:LanguageStats|l'attuale stato della loro traduzione in una certa lingua]].

Se pensi di aver bisogno di capire meglio prima di cominciare a tradurre, puoi leggere le [[FAQ|risposte alle domande più frequenti]].
Purtroppo la documentazione è talvolta non aggiornata.
Se c'è qualcosa che pensi dovresti poter fare, ma non riesci a capire come, non farti problemi a chiedere alla [[Support|pagina d'aiuto]].

Puoi anche contattare colleghi traduttore della stessa lingua nella [[Portal_talk:\$1|pagina di discussione]] del [[Portal:\$1|portale della tua lingua]].
Se non l'hai già fatto, [[Special:Preferences|seleziona come lingua dell'interfaccia utente la lingua in cui vuoi tradurre]], così che il wiki sia in grado di mostrarti i collegamenti più pertinenti per te.",
	'translate-fs-email-text' => 'Ti consigliamo di inserire il tuo indirizzo e-mail nelle [[Special:Preferences|tue preferenze]] e di confermarlo attraverso il messaggio che ti sarà inviato.

Ciò permetterà agli altri utenti di contattarti per e-mail.
Inoltre, riceverai la newsletter al più una volta al mese.
Se non vuoi ricevere la newsletter, puoi esserne escluso attraverso l\'apposita opzione della scheda "{{int:prefs-personal}}" delle [[Special:Preferences|tue preferenze]].',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'firststeps' => '開始手順',
	'firststeps-desc' => 'Translate 拡張機能を使用するウィキで利用者が開始準備をするための[[Special:FirstSteps|特別ページ]]',
	'translate-fs-pagetitle-done' => ' - 完了！',
	'translate-fs-pagetitle-pending' => ' - 保留中',
	'translate-fs-pagetitle' => '開始準備ウィザード - $1',
	'translate-fs-signup-title' => '利用者登録',
	'translate-fs-settings-title' => '個人設定の設定',
	'translate-fs-userpage-title' => 'あなたの利用者ページを作成',
	'translate-fs-permissions-title' => '翻訳者権限の申請',
	'translate-fs-target-title' => '翻訳を始めましょう！',
	'translate-fs-email-title' => '自分の電子メールアドレスの確認',
	'translate-fs-intro' => '{{SITENAME}} 開始準備ウィザードへようこそ。これから翻訳者になるための手順について1つずつ案内していきます。それらを終えると、あなたは {{SITENAME}} でサポートしているすべてのプロジェクトのインターフェイスメッセージを翻訳できるようになります。',
	'translate-fs-selectlanguage' => '言語を選択',
	'translate-fs-settings-planguage' => '第一言語：',
	'translate-fs-settings-planguage-desc' => '第一言語は、このウィキのインターフェースで使用する言語と
翻訳対象の言語を兼ねます',
	'translate-fs-settings-slanguage' => '補助言語$1：',
	'translate-fs-settings-slanguage-desc' => '翻訳編集画面でそのメッセージの翻訳を他の言語で表示することができます。
見たい言語があれば、ここで選択してください。',
	'translate-fs-settings-submit' => '設定を保存',
	'translate-fs-userpage-level-N' => '母語話者です',
	'translate-fs-userpage-level-5' => '翻訳の専門家です',
	'translate-fs-userpage-level-4' => '母語のように扱えます',
	'translate-fs-userpage-level-3' => '流暢に扱えます',
	'translate-fs-userpage-level-2' => '中級程度の能力です',
	'translate-fs-userpage-level-1' => '少し使うことができます',
	'translate-fs-userpage-help' => '自分の言語能力について紹介し、何か自己紹介をしてください。5つ以上の言語について知っている場合は、あとで追加することができます。',
	'translate-fs-userpage-submit' => '自分の利用者ページを作成',
	'translate-fs-userpage-done' => 'お疲れ様です。あなたの利用者ページができました。',
	'translate-fs-permissions-planguage' => '第一言語：',
	'translate-fs-permissions-help' => '次に翻訳者グループへの追加申請をする必要があります。
翻訳する予定の第一言語を選択してください。

他の言語やその他の事項については、以下のテキストボックスで説明できます。',
	'translate-fs-permissions-pending' => '申請は[[$1]]に送信され、サイトのスタッフの誰かが早急に確認します。
もしメールアドレスを設定していれば、メール通知によって結果をすぐに知ることができます。',
	'translate-fs-permissions-submit' => '申請を送信',
	'translate-fs-target-text' => "お疲れ様でした！あなたが翻訳を開始する準備が整いました。

まだ慣れないことや分かりにくいことがあっても、心配することはありません。[[Project list|プロジェクト一覧]]にあなたが翻訳を行うことのできる各プロジェクトの概要があります。ほとんどのプロジェクトには短い解説ページがあり、「'''Translate this project'''」というリンクからそのプロジェクトの未翻訳メッセージをすべて一覧できるページに移動できます。すべてのメッセージグループに関して[[Special:LanguageStats|各言語別に現在の翻訳状況]]を一覧することもできます。

翻訳を始める前にもっと知らなければならないことがあると感じられたならば、[[FAQ]] のページを読むのもよいでしょう。残念なことにドキュメントの中には更新が途絶えてしまっているものもあります。もし、なにかやりたいことがあって、それをどうやって行えばよいのかわからない場合には、遠慮せず[[Support|サポートページ]]にて質問してください。

また、同じ言語で作業している仲間の翻訳者とは[[Portal:$1|言語別のポータル]]の[[Portal_talk:$1|トークページ]]で連絡することができます。
まだ設定されていなければ、[[Special:Preferences|インターフェースの言語を、翻訳先としたい言語に変更]]すれば、ウィキ上では最も関連性のあるリンクが表示されます。",
	'translate-fs-email-text' => 'あなたの電子メールアドレスを[[Special:Preferences|個人設定]]で入力し、送られてきたメールからそのメールアドレスの確認を行ってください。

これにより、他の利用者があなたに電子メールを通じて連絡できるようになります。また、多くて月に1回ほどニュースレターが送られてきます。ニュースレターを受け取りたくない場合は、[[Special:Preferences|個人設定]]の「{{int:prefs-personal}}」タブで受信の中止を設定できます。',
);

/** Jamaican Creole English (Patois)
 * @author Yocahuna
 */
$messages['jam'] = array(
	'firststeps' => 'Fos tepdem',
	'firststeps-desc' => '[[Special:FirstSteps|Peshal piej]] fi get yuuza taat pan a wiki a yuuz di Chransliet extenshan',
	'translate-fs-pagetitle-done' => '- don!',
	'translate-fs-pagetitle' => 'Taat op wizad - $1',
	'translate-fs-signup-title' => 'Sain op',
	'translate-fs-settings-title' => 'Kanfiga yu prefransdem',
	'translate-fs-userpage-title' => 'Kriet yu yuuza piej',
	'translate-fs-permissions-title' => 'Rikwes chranslieta pomishan',
	'translate-fs-target-title' => 'Taat fi chransliet!',
	'translate-fs-email-title' => 'Kanfoerm yu e-miel ajres.',
	'translate-fs-intro' => "Welkom tu di {{SITENAME}} fos tep wizad.
Yu wi gaid chruu di pruoses fi ton chranslieta tep bi tep.
Wen yu don yu wi iebl fi chransliet '''intafies mechiz''' a aal prajek wa supuot a {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Kriet mi yuuza piej',
	'translate-fs-userpage-done' => 'Yaa gwaan! Yu nou ab a yuuza piej.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'firststeps' => 'ជំហានដំបូង',
);

/** Korean (한국어)
 * @author 관인생략
 */
$messages['ko'] = array(
	'translate-fs-pagetitle-done' => '- 완료!',
	'translate-fs-pagetitle-pending' => '- 보류',
	'translate-fs-pagetitle' => '시작 마법사 - $1',
	'translate-fs-signup-title' => '가입하기',
	'translate-fs-settings-title' => '기본 설정 구성',
	'translate-fs-userpage-title' => '사용자 페이지 만들기',
	'translate-fs-target-title' => '번역 시작하기',
	'translate-fs-email-title' => '이메일 주소 확인하기',
	'translate-fs-selectlanguage' => '언어 선택',
	'translate-fs-settings-planguage' => '모국어:',
	'translate-fs-settings-slanguage' => '보조 언어 $1:',
	'translate-fs-settings-submit' => '설정 저장하기',
	'translate-fs-userpage-submit' => '내 사용자 페이지 만들기',
	'translate-fs-userpage-done' => '잘하셨습니다! 당신은 이제 사용자 페이지를 가졌습니다.',
	'translate-fs-permissions-planguage' => '모국어:',
	'translate-fs-permissions-submit' => '요청 보내기',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'firststeps' => 'Eetste Schredde',
	'firststeps-desc' => '[[Special:FirstSteps|Extra Sigg]] för Metmaacher op Wikis met däm Zohsazprojramm <i lang="en">Translate</i> aan et werke ze krijje.',
	'translate-fs-pagetitle-done' => ' - jedonn!',
	'translate-fs-pagetitle-pending' => ' - noch nit jedonn',
	'translate-fs-pagetitle' => 'En de Jäng kumme - $1',
	'translate-fs-signup-title' => 'Aanmälde',
	'translate-fs-settings-title' => 'Enstellunge maache',
	'translate-fs-userpage-title' => 'Metmaachersigg aanlääje',
	'translate-fs-permissions-title' => 'Noh dem Rääsch als {{int:Group-translator-member}} froore',
	'translate-fs-target-title' => 'Loßlääje mem Övversäze!',
	'translate-fs-email-title' => 'De <i lang="en">e-mail</i> Adress bestätije',
	'translate-fs-intro' => 'Wellkumme bei {{GRAMMAR:Genitiv ier|{{SITENAME}}}} Hölp bei de eetsde Schredde för neu Metmaacher.
Heh kreß De Schrett för Schrett jesaat, wi De ene Övversäzer weeß.
Aam Engk kanns De de Täxte un Nohreeschte uß alle Projäkte övversäze, di {{GRAMMAR:em Dativ|{{SITENAME}}}} ongerstöz wääde.',
	'translate-fs-selectlanguage' => 'Söhg en Shprooch uß',
	'translate-fs-settings-planguage' => 'Houpshprooch:',
	'translate-fs-settings-planguage-desc' => 'De Houpshprooch is och di Schprooch, die heh dat Wiki met Der kallt, un des es och Ding shtandattmääßeje Shprooch för dren ze övversäze.',
	'translate-fs-settings-slanguage' => 'Zohsäzlejje Shprooch Nommer $1:',
	'translate-fs-settings-slanguage-desc' => 'Et es müjjelesch, sesch Övversäzonge en ander Shprooche beim sellver övversäze aanzeije ze lohße. Söhg uß, wat för esu en Shprooche De ze sinn krijje wells, wan De övverhoup wälsche han wells.',
	'translate-fs-settings-submit' => 'Enstellunge faßhallde',
	'translate-fs-userpage-level-N' => 'Ming Mottershprooch es:',
	'translate-fs-userpage-level-5' => 'Esch ben ene beroofsmääßeje Övversäzer vun:',
	'translate-fs-userpage-level-4' => 'Esch kennen mesch esu jood uß, wi wann et ming Motterschprooch wöhr, met:',
	'translate-fs-userpage-level-3' => 'Esch kann joot ömjonn met dä Schprooch:',
	'translate-fs-userpage-level-2' => 'Esch kann di Schprooch meddelmääßesch:',
	'translate-fs-userpage-level-1' => 'Esch kann e beßje vun dä Schprooch:',
	'translate-fs-userpage-help' => 'Jiv Ding Shprooche aan un sach ons jät övvr Desch. Wann De mieh wi fönnef Schprooche kanns, kanns De di schpääder emmer noch derbei donn.',
	'translate-fs-userpage-submit' => 'Don en Metmaachersigg för Desch aanlääje',
	'translate-fs-userpage-done' => 'Joot jemaat! Jäz häs De en Metmaachersigg.',
	'translate-fs-permissions-planguage' => 'Ding Houpshprooch:',
	'translate-fs-permissions-help' => 'Jäz moß De en Aanfrooch loßlohße, öm en de Övversäzer-Jropp ze kumme.
Donn Ding Houpschprooch aanjävve, woh De et miehts noh övversäze wells.

Do kanns natöörlesch ander Schprooche un wat De söns noch saare wells en dä Kaßte heh endraare.',
	'translate-fs-permissions-pending' => 'Ding Aanfrooch es jäz noh [[$1]] övvermeddelt, un eine vun de {{int:group-staff/ksh}}
weed sesch esu flöck, wi_t jeiht, dröm kömmere.
Wann De Ding Addräß för de <i lang="en">e-mail<i> beschtäätesch häs, kriß De en Nohreesch drövver, wann ed esu wigg es.',
	'translate-fs-permissions-submit' => 'Lohß Jonn!',
	'translate-fs-target-text' => 'Onse Jlöckwonsch!
Jez kanns De et Övversäze aanfange

Lohß Desch nit jeck maache, wann dat eets ens jet fresch un onövversseshlesh schingk.
Op dä Sigg [[Project list|met dä Leß met de Projäkte]] kanns Der enne Övverbleck holle, woh De jäz övverall jet zoh beidraare kanns met Dinge Övversäzonge.
De miehßte Projäkte han en koote Sigg övver dat Projäk, woh ene Lengk „Translate this project<!--{{int:xxxxxxxxxxx}}-->“ drop es. Dä brengk Desh op en Leß met alle Täxte un Nohreeschte för dat Projäk, di noch nit övversaz sin.
Et jitt och en [[Special:LanguageStats|Leß met alle Jroppe vun Täxte un Nohreeshte un de Zahle dohzoh]].

Wann De meins, dat De noch jät mieh wesse mööts, ih dat De mem Övversäze aanfängks, jangk en de [[FAQ|öff jeshtallte Froore]] dorsh.
Onjlöcklesch es, uns Dokemäntazjuhn künnt ald ens övverhollt sin.
Wann De jät donn wells, wat De nit esu eifach henkriß wie et sin sullt, dann bes nit bang un donn op dä Sigg „[[Support|{{int:bw-mainpage-support-title}}]]“ donoh froore.

Do kanns och met Dinge Kolleje, di de sellve Shprooche övversäze wi Do, övver de [[Portal:$1|Pooz-Sigg för Ding Shprooch]] ier [[Portal_talk:$1|Klaafsigg]] zosamme kumme.
Wann De dat noch nit jedonn häs, [[Special:Preferences|donn Ding Shprooch för de Bovverflääsch vum Wiki op di Shprooch ensthälle, woh de noh övversäze wells]], domet et wiki Der de beß zopaß Lengks automattesch aanzeije kann.',
	'translate-fs-email-text' => 'Bes esu joot un jiff Ding Adräß för de <i lang="en">e-mail</i> en [[Special:Preferences|Dinge Enstellunge]]
aan, un dun se beschtäätejje. Doför es ene Lengk udder en <i lang="en">URL</i> en dä <i lang="en">e-mail</i>
an Desh dren.

Dat määd et müjjelesch, dat ander Metmaacher Dir en <i lang="en">e-mail</i> schecke künne.
Do kriß och Neueschkeite vum Wiki zohjescheck, esu ätwa eijmohl em Mohnd.
Wann De dat nit han wells, kanns De et onger „{{int:prefs-personal}}“ en [[Special:Preferences|Dinge Enstellunge]] afschallde.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'firststeps' => 'Gavên yekem',
	'translate-fs-pagetitle-done' => '- çêbû!',
	'translate-fs-target-title' => 'Bi wergerrê dest pê bike!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'firststeps' => 'Éischt Schrëtt',
	'firststeps-desc' => "[[Special:FirstSteps|Spezialsäit]] fir datt Benotzer besser ukommen fir d'Erweiderung 'Translate' op enger Wiki ze benotzen",
	'translate-fs-pagetitle-done' => ' - fäerdeg!',
	'translate-fs-pagetitle-pending' => '- am gaang',
	'translate-fs-pagetitle' => 'Assistent fir unzefänken - $1',
	'translate-fs-signup-title' => 'Schreift Iech an',
	'translate-fs-settings-title' => 'Är Astellunge festleeën',
	'translate-fs-userpage-title' => 'Maacht Är Benotzersäit',
	'translate-fs-permissions-title' => 'Iwwersetzerrechter ufroen',
	'translate-fs-target-title' => 'Ufänke mat iwwersetzen!',
	'translate-fs-email-title' => 'Confirméiert är E-Mailadress',
	'translate-fs-intro' => "Wëllkomm beim {{SITENAME}}-Startassistent.
Iech gëtt gewisen, Déi Dir Schrëtt fir Schrëtt zum Iwwersetzer gitt.
Um Schluss kënnt Dir all ''Interface-Messagen'' vun de vun {{SITENAME}} ënnerstetzte Projeten iwwersetzen.",
	'translate-fs-selectlanguage' => 'Eng Sprooch eraussichen',
	'translate-fs-settings-planguage' => 'Haaptsprooch:',
	'translate-fs-settings-slanguage' => 'Ënnerstetzungs-Sprooch $1:',
	'translate-fs-settings-slanguage-desc' => 'Et ass méiglech fir Iwwersetzunge vu Messagen an anere Sproochen am Iwwersetzungsediteur ze weisen.
Hei kënnt Dir eraussiche wat fir eng Sprooch, wann Dir dat wëllt, Dir gesi wëllt.',
	'translate-fs-settings-submit' => 'Astellunge späicheren',
	'translate-fs-userpage-level-5' => 'Ech sinn e professionellen Iwwersetzer vu(n)',
	'translate-fs-userpage-level-4' => 'Ech kenne se wéi wann et meng Mammesprooch wier',
	'translate-fs-userpage-level-3' => 'Ech ka mech gutt ausdrécken op',
	'translate-fs-userpage-level-2' => 'Ech hu mëttelméisseg Kenntnisser vu(n)',
	'translate-fs-userpage-level-1' => 'Ech kann a bëssen',
	'translate-fs-userpage-submit' => 'Meng Benotzersäit maachen',
	'translate-fs-userpage-done' => 'Gutt gemaach! dir hutt elo eng Benotzersäit.',
	'translate-fs-permissions-planguage' => 'Haaptsprooch:',
	'translate-fs-permissions-submit' => 'Ufro schécken',
	'translate-fs-target-text' => "Felicitatiounen!
Dir kënnt elo ufänke mat iwwersetzen.

Maacht Iech näischt doraus wann dat am Ufank fir Iech nach e komescht Gefill ass.
Op [[Project list]] gëtt et eng Iwwersiicht vu Projeten bäi deenen Dir hëllefe kënnt z'iwwersetzen.
Déi meescht Projeten hunn eng kuerz Beschreiwungssäit mat engem \"''Iwwersetz dës e Projet''\" Link, deen Iech op eng Säit op där all net iwwersate Messagen dropstinn.
Eng Lëscht mat alle Gruppe vu Messagen mat dem [[Special:LanguageStats|aktuellen Iwwersetzungsstatus fir eng Sprooch]] gëtt et och.

Wann dir mengt Dir sollt méi verstoen ier Dir ufänkt mat Iwwersetzen, kënnt Dir déi [[FAQ|dacks gestallte Froe]] liesen.
Onglécklecherweis kann et virkommen datt d'Dokumentatioun heiansdo net à jour ass.
Wann et eppes gëtt vun deem Dir mengt datt Dir e maache kënnt, awer Dir fannt net eraus wéi, dann zéckt net fir eis op der [[Support|Support-Säit]] ze froen.

Dir kënnt och aner Iwwersetzer vun der selwechter Sprooch op der [[Portal_talk:\$1|Diskussiounssäit]] vun [[Portal:\$1|Ärem Sproocheportal]] kontaktéieren. Wann dir et net scho gemaach hutt, [[Special:Preferences|ännert d'Sprooch vum Interface an déi Sprooch an déi Dir iwwersetze wëllt]], esou datt d'Wiki Iech déi wichtegst Linke weise kann.",
	'translate-fs-email-text' => 'Gitt w.e.g. Är E-Mailadress an [[Special:Preferences|Ären Astellungen]] un a confirméiert se vun der E-Mail aus déi Dir geschéckt kritt.

Dëst erlaabte et anere Benotzer fir Iech per Mail ze kontaktéieren.
Dir och Newsletteren awer héchstens eng pro Mount.
Wann Dir keng Newslettere kréie wëllt, da kënnt Dir dat am Tab "{{int:prefs-personal}}"  vun Ären [[Special:Preferences|Astellungen]] ausschalten.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'firststeps' => 'Први чекори',
	'firststeps-desc' => '[[Special:FirstSteps|Специјална страница]] за помош со првите чекори на вики што го користи додатокот Преведување (Translate)',
	'translate-fs-pagetitle-done' => '- завршено!',
	'translate-fs-pagetitle-pending' => ' - во исчекување',
	'translate-fs-pagetitle' => 'Помошник „Како да започнете“ - $1',
	'translate-fs-signup-title' => 'Регистрација',
	'translate-fs-settings-title' => 'Поставете ги вашите нагодувања',
	'translate-fs-userpage-title' => 'Создајте своја корисничка страница',
	'translate-fs-permissions-title' => 'Барање на дозвола за преведување',
	'translate-fs-target-title' => 'Почнете со преведување!',
	'translate-fs-email-title' => 'Потврдете ја вашата е-пошта',
	'translate-fs-intro' => "Добредојдовте на помошникот за први чекори на {{SITENAME}}.
Овој помошник постепено ќе води низ постапката за станување преведувач.
Потоа ќе можете да преведувате ''посреднички (interface) пораки'' за сите поддржани проекти на {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Одберете јазик',
	'translate-fs-settings-planguage' => 'Главен јазик',
	'translate-fs-settings-planguage-desc' => 'Главниот јазик е вашиот јазик на посредникот на ова вики,
а воедно и стандарден целен јазик за преводите.',
	'translate-fs-settings-slanguage' => 'Помошен јазик $1:',
	'translate-fs-settings-slanguage-desc' => 'Додека преведувате, во уредникот можат да се прикажуваат преводи од други јазици.
Доколку сакате да ја користите функцијава, тука можете да одберете кои јазици да ви се прикажуваат.',
	'translate-fs-settings-submit' => 'Зачувај нагодувања',
	'translate-fs-userpage-level-N' => 'Мајчин јазик ми е',
	'translate-fs-userpage-level-5' => 'Стручно преведувам на',
	'translate-fs-userpage-level-4' => 'Го владеам како мајчин',
	'translate-fs-userpage-level-3' => 'Добро владеам',
	'translate-fs-userpage-level-2' => 'Умерено го владеам',
	'translate-fs-userpage-level-1' => 'Знам по малку',
	'translate-fs-userpage-help' => 'Тука наведете кои јазици ги познавате и колку добро го владеете секој од нив. Воедно напишете и нешто за себе. Доколку знаете повеќе од пет јазика, останатите додајте ги подоцна.',
	'translate-fs-userpage-submit' => 'Создај корисничка страница',
	'translate-fs-userpage-done' => 'Одлично! Сега имате корисничка страница.',
	'translate-fs-permissions-planguage' => 'Главен јазик:',
	'translate-fs-permissions-help' => 'Сега ќе треба да поставите барање за да ве додадеме во групата на преведувачи.
Одберете го главниот јазик на кој ќе преведувате.

Во полето за текст подолу можете да споменете други јазици и да напишете забелешки.',
	'translate-fs-permissions-pending' => 'Вашето барање е поднесено на [[$1]] и ќе разгледано во најкус можен рок.
Доколку ја потврдите вашата е-пошта, тогаш известувањето ќе го добиете таму.',
	'translate-fs-permissions-submit' => 'Испрати барање',
	'translate-fs-target-text' => "Честитаме!
Сега можете да почнете со преведување.

Не плашете се ако сето ова сè уште ви изгледа ново и збунително.
[[Project list|Списокот на проекти]] дава преглед на проектите каде можете да придонесувате со ваши преводи.
Највеќето проекти имаат страница со краток опис и врска „''Преведи го проектов''“, која ќе ве одвете до страница со сите непреведени пораки за тој проект.
Има и список на сите групи на пораки со [[Special:LanguageStats|тековниот статус на преведеност за даден јазик]].

Ако мислите дека треба да осознаете повеќе пред да почнете со преведување, тогаш прочитајте ги [[FAQ|често поставуваните прашања]].
Нажалост документацијата напати знае да биде застарена.
Ако има нешто што мислите дека би требало да можете да го правите, но не можете да дознаете како, најслободно поставете го прашањето на [[Support|страницата за поддршка]].

Можете и да се обратите кај вашите колеги што преведуваат на истиот јазик на [[Portal_talk:$1|страницата за разговор]] на [[Portal:$1|вашиот јазичен портал]].
Ако ова веќе го имате сторено, тогаш [[Special:Preferences|наместете го јазикот на посредникот на оној на којшто сакате да преведувате]], и така викито ќе ви ги прикажува врските што се однесуваат на вас.",
	'translate-fs-email-text' => 'Наведете ја вашата е-пошта во [[Special:Preferences|нагодувањата]] и потврдете ја преку пораката испратена на неа.

Ова им овозможува на корисниците да ве контактираат преку е-пошта.
На таа адреса ќе добивате и билтени со новости, највеќе еднаш месечно.
Ако не сакате да добиват билтени, можете да се отпишете преку јазичето „{{int:prefs-personal}}“ во вашите [[Special:Preferences|нагодувања]].',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Santhosh.thottingal
 */
$messages['ml'] = array(
	'firststeps' => 'ആദ്യ ചുവടുകൾ',
	'translate-fs-pagetitle-done' => '- ചെയ്തു കഴിഞ്ഞു!',
	'translate-fs-pagetitle' => 'ചുവടുവെക്കാനൊരു സഹായി -$1',
	'translate-fs-signup-title' => 'അംഗത്വമെടുക്കുക',
	'translate-fs-settings-title' => 'താങ്കളുടെ ഐച്ഛികങ്ങൾ ക്രമീകരിക്കുക',
	'translate-fs-userpage-title' => 'താങ്കളുടെ ഉപയോക്തൃ താൾ സൃഷ്ടിക്കുക',
	'translate-fs-permissions-title' => 'തർജ്ജമയ്ക്കുള്ള അനുമതി ആവശ്യപ്പെടുക',
	'translate-fs-target-title' => 'പരിഭാഷപ്പെടുത്തൽ തുടങ്ങുക!',
	'translate-fs-email-title' => 'ഇമെയിൽ വിലാസം സ്ഥിരീകരിക്കുക',
	'translate-fs-intro' => "{{SITENAME}} ആദ്യചുവടുകൾ സഹായത്തിലേയ്ക്ക് സ്വാഗതം.
പരിഭാഷക(ൻ) പദവിയിലേക്ക് എത്താനുള്ള ഘട്ടം ഘട്ടമായി എത്താനുള്ള വഴികാട്ടിയാണിത്.
അവസാനം {{SITENAME}} സംരംഭത്തിൽ പിന്തുണയുള്ള എല്ലാ പദ്ധതികളുടെയും ''സമ്പർക്കമുഖ സന്ദേശങ്ങൾ'' പരിഭാഷപ്പെടുത്താൻ താങ്കൾക്ക് സാധിച്ചിരിക്കും.",
	'translate-fs-selectlanguage' => 'ഭാഷ തിരഞ്ഞെടുക്കുക',
	'translate-fs-settings-planguage' => 'പ്രാഥമികഭാഷ:',
	'translate-fs-settings-planguage-desc' => 'പ്രാഥമിക ഭാഷ നിങ്ങളുടെ സമ്പർക്കമുഖ ഭാഷയായും പരിഭാഷയ്ക്കുള്ള ഭാഷയായും മാറുന്നു.',
	'translate-fs-settings-slanguage' => 'സഹായകഭാഷ $1:',
	'translate-fs-settings-submit' => 'ക്രമീകരണങ്ങൾ ഓർത്തുവെയ്ക്കുക',
	'translate-fs-userpage-submit' => 'എന്റെ ഉപയോക്തൃ താൾ സൃഷ്ടിക്കുക',
	'translate-fs-userpage-done' => 'കൊള്ളാം! താങ്കൾക്കിപ്പോൾ ഒരു ഉപയോക്തൃതാൾ ഉണ്ട്.',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Shubhamlanke
 */
$messages['mr'] = array(
	'firststeps' => 'पहिल्या पायर्‍या',
	'firststeps-desc' => '[[महत्त्वाचे; पहिली पायरी महत्त्वाचे पान]] भाषांतर विस्तार वापरून सुरु केलेल्या युजर्सना मिळण्यासाठी .',
	'translate-fs-pagetitle-done' => ' - झाले!',
	'translate-fs-pagetitle-pending' => 'अनिर्णीत,राहिलेले,',
	'translate-fs-pagetitle' => 'सुरु झालेले विझार्ड मिळण्यासाठी ‌-$१',
	'translate-fs-signup-title' => 'करार करणे.',
	'translate-fs-userpage-title' => 'माझे सदस्यपान तयार करा.',
	'translate-fs-permissions-title' => 'भाषांतरास परवानगी मिळण्यासाठी विनंती करा. (भाषांतर करणार्या व्यक्तीस )',
	'translate-fs-target-title' => 'भाषांतरास सुरुवात करा!',
	'translate-fs-email-title' => 'आपला इमेल पत्ता पडताळून पहा.',
	'translate-fs-intro' => '{{साइटचे नाव}} साइटवर तुमचे स्वागत आहे पहिली पायरी
योग्य भाषांतकार होण्याच्या प्रक्रियेद्वारे तुम्हाला क्रमा-क्रमाने मार्गदर्शन केले जाईल.
शेवटी तुम्ही ह्या साईटवर  {{साइटचे नाव}} उपलब्ध  असलेल्या सर्व प्रकल्प ईंटरफेस संदेशांचे भाषांतर करण्यास लायकवान बनाल.',
	'translate-fs-selectlanguage' => '(योग्य) भाषा निवडा.',
	'translate-fs-settings-planguage' => 'मुख्य(महत्त्वाची) भाषा निवडा.',
	'translate-fs-settings-planguage-desc' => 'तुमची मुख्य भाषा ही विकीवर तुमची दुवा साधणारी भाषा आणि भाषांतरासाठी दिफॉल्ट भाषा म्हणुन वापरली जाते.',
	'translate-fs-settings-slanguage' => 'उप‌-भाषा $१:',
	'translate-fs-settings-slanguage-desc' => 'भाषांतर एडिटर मध्ये संदेशांचे दुसर्या भाषेमध्ये भाषांतर सहज शक्य आहे.
जर तुम्हाला एखादी भाषा पाहण्यासाठी आवडेल; तर इथे तुम्ही ती भाषा निवडू शकता.',
	'translate-fs-settings-submit' => 'माझ्या पसंती जतन करा.',
	'translate-fs-userpage-level-N' => 'मी जन्मतः (..........)(एखादी भाषा)  बोलतो.',
	'translate-fs-userpage-level-5' => 'मी( ..........)(एखादया भाषेचे दुसर्या भाषेत रुपांतर)व्यवसायिक भाषांतकार आहे',
	'translate-fs-userpage-level-4' => 'मी त्या (भाषेला)माझ्या मूळ बोलीभाषे एवढा जाणतो.
उदा. एखादी भाषा,गोष्ट',
	'translate-fs-userpage-level-3' => 'माझी त्या ...... चांगली पकड(कौशल्य) आहे.',
	'translate-fs-userpage-level-2' => 'माझी त्या.....(भाषेवर) मध्यम कौशल्य आहे.',
	'translate-fs-userpage-level-1' => 'मला थोडेसे माहिती आहे.',
	'translate-fs-userpage-help' => 'क्रुपया तुमचे भाषेचे कौशल्य दाखवा आणि स्वतःबद्दल काहीतरी सांगा. जर तुम्हाला पाच पेक्षा जास्त भाषा माहित असतील; तर त्यांचा तुम्ही नंतर समावेश करू शकता.',
	'translate-fs-userpage-submit' => 'माझे सदस्यपान तयार करा.',
	'translate-fs-userpage-done' => 'छान! तुम्हाला आता सदस्यपान आहे.',
	'translate-fs-permissions-planguage' => 'मुख्य(महत्त्वाची) भाषा निवडा',
	'translate-fs-permissions-help' => 'भाषांतर करणार्या समुहामध्ये समवेश होण्यासाठी विनंती पाठवण्याची तुम्हाला गरज आहे.
तुम्ही भाषांतर करण्यासाठी वापरणारी मुख्य भाषा निवडा.
तुम्ही खाली टेक्सबॉक्स मध्ये इतर भाषा आणि सूचना देऊ शकता.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'firststeps' => 'Langkah pertama',
	'firststeps-desc' => '[[Special:FirstSteps|Laman khas]] untuk melatih pengguna untuk menggunakan sambungan Terjemahan untuk membangunkan wiki',
	'translate-fs-pagetitle-done' => '- siap!',
	'translate-fs-pagetitle-pending' => ' - menunggu',
	'translate-fs-pagetitle' => 'Pendeta permulaan - $1',
	'translate-fs-signup-title' => 'Daftar diri',
	'translate-fs-settings-title' => 'Tataletak keutamaan anda',
	'translate-fs-userpage-title' => 'Cipta laman pengguna anda',
	'translate-fs-permissions-title' => 'Pohon kebenaran penterjemah',
	'translate-fs-target-title' => 'Mula menterjemah!',
	'translate-fs-email-title' => 'Sahkan alamat e-mel anda',
	'translate-fs-intro' => 'Selamat datang ke pendeta langkah pertama {{SITENAME}}.
Anda akan dibimbing sepanjang proses langkah demi langkah untuk menjadi penterjemah.
Pada akhirnya, anda akan dapat menterjemahkan "pesanan antara muka" bagi semua projek yang disokong di {{SITENAME}}.',
	'translate-fs-selectlanguage' => 'Pilih bahasa',
	'translate-fs-settings-planguage' => 'Bahasa utama:',
	'translate-fs-settings-planguage-desc' => 'Bahasa utama ini juga merupakan bahasa antara muka anda di wiki ini
dan juga bahasa sasaran asali untuk terjemahan.',
	'translate-fs-settings-slanguage' => 'Bahasa pembantu: $1',
	'translate-fs-settings-slanguage-desc' => 'Anda boleh memaparkan terjemahan mesej dalam bahasa lain dalam editor penterjemahan.
Di sini anda boleh memilih bahasa-bahasa yang anda ingin lihat.',
	'translate-fs-settings-submit' => 'Simpan keutamaan',
	'translate-fs-userpage-level-N' => 'Saya penutur asli',
	'translate-fs-userpage-level-5' => 'Saya penterjemah profesional',
	'translate-fs-userpage-level-4' => 'Saya fasih seperti penutur asli',
	'translate-fs-userpage-level-3' => 'Saya agak fasih',
	'translate-fs-userpage-level-2' => 'Saya sederhana fasih',
	'translate-fs-userpage-level-1' => 'Saya tahu sedikit',
	'translate-fs-userpage-help' => 'Sila nyatakan kemahiran bahasa anda dan perihalkan diri anda kepada kami. Jika anda tahu lebih daripada lima bahasa, anda boleh tambahkan banyak lagi lain kali.',
	'translate-fs-userpage-submit' => 'Cipta laman pengguna saya',
	'translate-fs-userpage-done' => 'Syabas! Sekarang, anda ada laman pengguna.',
	'translate-fs-permissions-planguage' => 'Bahasa utama:',
	'translate-fs-permissions-help' => 'Kini, anda perlu membuat permintaan untuk disertakan dalam kumpulan penterjemah.
Pilih bahasa utama yang anda ingin membuat terjemahan anda.

Anda boleh menyebut bahasa-bahasa lain dan catatan-catatan lain dalam ruangan teks di bawah.',
	'translate-fs-permissions-pending' => 'Permintaan anda telah diserahkan kepada [[$1]] untuk dilihat oleh seseorang kakitangan secepat mungkin.
Jika anda mengesahkan alamat e-mel anda, anda akan menerima pemberitahuan melalui e-mel secepat mungkin.',
	'translate-fs-permissions-submit' => 'Hantar permohonan',
	'translate-fs-target-text' => "Syabas! Sekarang, anda boleh mulai menterjemah.

Jangan risau jika kebingungan kerana anda memerlukan masa untuk membiasakan diri. Di [[Project list]] terdapat sekilas pandang projek yang boleh anda sumbangkan terjemahan. Kebanyakan projek mempunyai laman keterangan ringkas dengan pautan \"''Translate this project''\" yang membawa anda ke laman yang menyenaraikan pesanan yang belum diterjemah. Juga terdapat senarai semua kumpulan pesanan dengan [[Special:LanguageStats|status penterjemahan semasa bahasa itu]].

Jika anda rasa anda perlu meningkatkan kefahaman anda sebelum memulakan penterjemahan, anda boleh membaca [[FAQ|Soalan Lazim]] kami, tetapi berhati-hati kerana sesetengah isinya mungkin ketinggalan zaman. Jika anda merasa apa-apa yang anda sepatutnya boleh lakukan, tetapi tidak dapat mengetahui caranya, jangan malu untuk bertanya di [[Support|laman bantuan]].

Anda juga boleh menghubungi para penterjemah lain yang sama bahasa dengan anda di [[Portal_talk:\$1|laman perbincangan]] [[Portal:\$1|portal bahasa anda]]. Sekiranya anda belum berbuat demikian, sila [[Special:Preferences|ubah bahasa antara muka pengguna anda kepada bahasa terjemahan anda]] supaya wiki ini dapat menunjukkan pautan-pautan (''links'') yang paling relevan kepada anda.",
	'translate-fs-email-text' => 'Sila berikan alamat e-mel anda di [[Special:Preferences|keutamaan anda]] dan sahkannya daripada e-mel yang dihantar kepada anda.

Ini membolehkan pengguna lain untuk menghubungi anda melalui e-mel.
Anda juga akan menerima surat berita selebih-lebihnya sebulan sekali.
Jika anda tidak ingi menerima surat berita, anda boleh memilih untuk mengecualikan diri daripada senarai penghantaran kami dalam tab "{{int:prefs-personal}}" dalam [[Special:Preferences|keutamaan]] anda.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'firststeps' => 'Første steg',
	'firststeps-desc' => '[[Special:FirstSteps|Spesialside]] for å få brukere igang med wikier som bruker Translate-utvidelsen',
	'translate-fs-pagetitle-done' => ' – ferdig!',
	'translate-fs-pagetitle' => 'Veiviser for å komme igang – $1',
	'translate-fs-signup-title' => 'Registrer deg',
	'translate-fs-settings-title' => 'Konfigurer innstillingene dine',
	'translate-fs-userpage-title' => 'Opprett brukersiden din',
	'translate-fs-permissions-title' => 'Spør om oversetterrettigheter',
	'translate-fs-target-title' => 'Start å oversette!',
	'translate-fs-email-title' => 'Bekreft e-postadressen din',
	'translate-fs-intro' => "Velkommen til veiviseren for å komme igang med {{SITENAME}}.
Du vil bli veiledet gjennom prosessen med å bli en oversetter steg for steg.
Til slutt vil du kunne oversette ''grensesnittsmeldinger'' for alle støttede prosjekt på {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Opprett brukersiden min',
	'translate-fs-userpage-done' => 'Flott! Nå har du en brukerside.',
	'translate-fs-target-text' => "Gratulerer.
Du kan nå begynne å oversette.

Ikke vær redd om det fortsatt føles nytt og forvirrende.
I [[Project list|prosjektlisten]] er det en liste over prosjekt du kan bidra med oversettelser til.
De fleste av prosjektene har en kort beskrivelsesside med en «''Oversett dette prosjektet''»-lenke som vil føre deg til en side som lister opp alle uoversatte meldinger.
En liste over alle meldingsgruppene med den [[Special:LanguageStats|nåværende oversettelsesstatusen for et språk]] er også tilgjengelig.

Om du synes at du må forstå mer før du begynner å oversette kan du lese [[FAQ|Ofte stilte spørsmål]].
Dessverre kan dokumentasjonen av og til være utdatert.
Om det er noe du tror du kan gjøre men ikke vet hvordan, ikke nøl med å spørre på [[Support|støttesiden]].

Du kan også kontakte medoversettere av samme språk på [[Portal:$1|din språkportal]]s [[Portal_talk:$1|diskusjonsside]].
Om du ikke allerede har gjort det, [[Special:Preferences|endre grensesnittspråket ditt til det språket du vil oversette til]] slik at wikien kan vise de mest relevante lenkene for deg.",
	'translate-fs-email-text' => 'Oppgi e-postadressen din i [[Special:Preferences|innstillingene dine]] og bekreft den i e-posten som blir sendt til deg.

Dette lar andre brukere kontakte deg via e-post.
Du vil også motta nyhetsbrev høyst én gang i måneden.
Om du ikke vil motta nyhetsbrevet kan du melde deg ut i fanen «{{int:prefs-personal}}» i [[Special:Preferences|innstillingene]] dine.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'firststeps' => 'Eerste stappen',
	'firststeps-desc' => '[[Special:FirstSteps|Speciale pagina]] voor het op gang helpen van gebruikers op een wiki met de uitbreiding Translate',
	'translate-fs-pagetitle-done' => ' - afgerond!',
	'translate-fs-pagetitle-pending' => '- in behandeling',
	'translate-fs-pagetitle' => 'Aan de slag - $1',
	'translate-fs-signup-title' => 'Registreren',
	'translate-fs-settings-title' => 'Uw voorkeuren instellen',
	'translate-fs-userpage-title' => 'Uw gebruikerspagina aanmaken',
	'translate-fs-permissions-title' => 'Vertaalrechten aanvragen',
	'translate-fs-target-title' => 'Beginnen met vertalen!',
	'translate-fs-email-title' => 'Uw e-mailadres bevestigen',
	'translate-fs-intro' => 'Welkom bij de wizard Aan de slag van {{SITENAME}}.
We loodsen u stap voor stap door het proces van vertaler worden.
Aan het einde kunt u alle door {{SITENAME}} ondersteunde projecten vertalen.',
	'translate-fs-selectlanguage' => 'Kies een taal',
	'translate-fs-settings-planguage' => 'Primaire taal:',
	'translate-fs-settings-planguage-desc' => 'De primaire taal is de taal van de interface op deze wiki en ook de standaard taal voor vertalingen.',
	'translate-fs-settings-slanguage' => 'Hulptaal $1:',
	'translate-fs-settings-slanguage-desc' => 'Het is mogelijk om vertalingen van berichten in andere talen weer te geven in de vertalingsbewerker.
Hier kunt u kiezen welke talen u wilt zien.',
	'translate-fs-settings-submit' => 'Voorkeuren opslaan',
	'translate-fs-userpage-level-N' => 'Dit is mijn moedertaal',
	'translate-fs-userpage-level-5' => 'In deze taal vertaal ik professioneel',
	'translate-fs-userpage-level-4' => 'Ik ken deze taal zo goed als een moedertaalspreker',
	'translate-fs-userpage-level-3' => 'Deze taal beheers ik goed',
	'translate-fs-userpage-level-2' => 'Deze taal beheers ik gemiddeld',
	'translate-fs-userpage-level-1' => 'Deze taal ken ik een beetje',
	'translate-fs-userpage-help' => 'Geef uw taalvaardigheden aan en vertel ons iets over uzelf. Als u meer dan vijf talen kent, kunt u er later meer toevoegen.',
	'translate-fs-userpage-submit' => 'Mijn gebruikerspagina aanmaken',
	'translate-fs-userpage-done' => 'Goed gedaan!
U hebt nu een gebruikerspagina.',
	'translate-fs-permissions-planguage' => 'Primaire taal:',
	'translate-fs-permissions-help' => 'Plaats nu een verzoek om te mogen vertalen.
Selecteer de primaire taal waarin u gaat vertalen.

U kunt andere talen en andere opmerkingen vermelden in het tekstvak hieronder.',
	'translate-fs-permissions-pending' => 'Uw verzoek is opgenomen op de pagina [[$1]] en een staflid van deze site handelt dit zo snel mogelijk af. Als uw e-mailadres bevestigd is, ontvangt u een melding per e-mail zodra dit gebeurt.',
	'translate-fs-permissions-submit' => 'Verzoek versturen',
	'translate-fs-target-text' => 'Gefeliciteerd!
U kunt nu beginnen met vertalen.

Wees niet bang als het nog wat verwarrend aanvoelt.
In de [[Project list|Projectenlijst]] vindt u een overzicht van projecten waar u vertalingen aan kunt bijdragen.
Het merendeel van de projecten heeft een korte beschrijvingspagina met een verwijzing "\'\'Dit project vertalen\'\'", die u naar een pagina leidt waarop alle onvertaalde berichten worden weergegeven.
Er is ook een lijst met alle berichtengroepen beschikbaar met de [[Special:LanguageStats|huidige status van de vertalingen voor een taal]].

Als u denkt dat u meer informatie nodig hebt voordat u kunt beginnen met vertalen, lees dan de [[FAQ|Veel gestelde vragen]].
Helaas kan de documentatie soms verouderd zijn.
Als er iets is waarvan u denkt dat het mogelijk moet zijn, maar u weet niet hoe, aarzel dan niet om het te vragen op de [[Support|pagina voor ondersteuning]].

U kunt ook contact opnemen met collegavertalers van dezelfde taal op de [[Portal_talk:$1|overlegpagina]] van [[Portal:$1|uw taalportaal]].
Als u het niet al hebt gedaan, [[Special:Preferences|wijzig dan de taal van de gebruikersinterface in de taal waarnaar u gaat vertalen]], zodat de wiki u de meest relevante verwijzingen kan presenteren.',
	'translate-fs-email-text' => 'Geef uw e-mail adres in in [[Special:Preferences|uw voorkeuren]] en bevestig het via de e-mail die naar u verzonden is.

Dit makt het mogelijk dat andere gebruikers contact met u opnemen per e-mail.
U ontvangt dan ook maximaal een keer per maand de nieuwsbrief.
Als u geen nieuwsbrieven wilt ontvangen, dan kunt u dit aangeven in het tabblad "{{int:prefs-personal}}" van uw [[Special:Preferences|voorkeuren]].',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'translate-fs-userpage-submit' => 'Opprett brukarsida mi',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'translate-fs-pagetitle-done' => '- geduh!',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'firststeps' => 'Pierwsze kroki',
	'firststeps-desc' => '[[Special:FirstSteps|Strona specjalna]] ułatwiająca rozpoczęcie pracy na wiki z wykorzystaniem rozszerzenia Translate',
	'translate-fs-pagetitle-done' => '&#32;– gotowe!',
	'translate-fs-pagetitle' => 'Kreator pierwszych kroków – $1',
	'translate-fs-signup-title' => 'Rejestracja',
	'translate-fs-settings-title' => 'Konfiguracja preferencji',
	'translate-fs-userpage-title' => 'Tworzenie swojej strony użytkownika',
	'translate-fs-permissions-title' => 'Wniosek o uprawnienia tłumacza',
	'translate-fs-target-title' => 'Zacznij tłumaczyć!',
	'translate-fs-email-title' => 'Potwierdź swój adres e‐mail',
	'translate-fs-intro' => "Witaj w kreatorze pierwszych kroków na {{GRAMMAR:MS,pl|{{SITENAME}}}}.
Pomożemy Ci krok po kroku przejść przez proces zostania tłumaczem.
Po jego zakończeniu będziesz mógł tłumaczyć ''komunikatu interfejsu'' wszystkich wspieranych przez {{GRAMMAR:B.lp|{{SITENAME}}}} projektów.",
	'translate-fs-userpage-submit' => 'Utwórz moją stronę użytkownika',
	'translate-fs-userpage-done' => 'Udało się! Masz już swoją stronę użytkownika.',
	'translate-fs-email-text' => 'Podaj swój adres e‐mail w [[Special:Preferences|preferencjach]] i potwierdź go korzystając z e‐maila wysłanego do Ciebie.

Umożliwi to innym użytkownikom kontakt z Tobą.
Będziesz również, nie częściej niż co miesiąc, otrzymywać biuletyny.
Jeśli nie chcesz otrzymywać informacji o aktualnościach możesz z nich zrezygnować w zakładce „{{int:prefs-personal}}” w swoich [[Special:Preferences|preferencjach]].',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'firststeps' => 'Prim pass',
	'firststeps-desc' => "[[Special:FirstSteps|Pàgina special]] për anandié j'utent an sna wiki dovrand l'estension Translate",
	'translate-fs-pagetitle-done' => ' - fàit!',
	'translate-fs-pagetitle' => 'Guida për parte - $1',
	'translate-fs-signup-title' => "Ch'as anscriva",
	'translate-fs-settings-title' => 'Configura ij tò gust',
	'translate-fs-userpage-title' => 'Crea toa pàgina utent',
	'translate-fs-permissions-title' => "Ch'a ciama ij përmess ëd tradutor",
	'translate-fs-target-title' => "Ch'a ancamin-a a volté!",
	'translate-fs-email-title' => 'Che an conferma soa adrëssa ëd pòsta eletrònica',
	'translate-fs-intro' => "Bin ëvnù an sl'assistent dij prim pass ëd {{SITENAME}}.
A sarà guidà pass për pass ant ël process dë vnì un tradutor.
A la fin a sarà bon a volté ij ''mëssagi dj'antërfasse'' ëd tùit ij proget gestì da {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Crea mia pàgina utent',
	'translate-fs-userpage-done' => "Bin fàit! Adess it l'has na pàgina utent.",
	'translate-fs-target-text' => "Congratulassion!
Adess a peul ancaminé a volté!

Ch'a l'abia pa tëmma s'as sent anco' neuv e confus.
A [[Project list]] a-i é na presentassion dij proget ch'a peul contribuì a volté.
Vàire proget a l'han na curta pàgina ëd descrission con un colegament \"''Vòlta ës proget''\", ch'a lo pòrta a na pàgina ch'a lista tùit ij mëssagi nen voltà.
Na lista ëd tute le partìe ëd mëssagi con lë [[Special:LanguageStats|stat corent ëd tradussion për na lenga]] a l'é ëdcò disponìbil.

S'a pensa ch'a l'ha dabzògn ëd capì ëd pi prima d'ancaminé a volté, a peul lese le [[FAQ|chestion ciamà ëd soens]].
Për maleur, dle vire la documentassion a peul esse veja.
S'a-i é quaicòs ch'a pensa ch'a podrìa esse bon a fé, ma a tiess pa a trové coma, ch'as gene pa a ciamelo a la [[Support|pàgina d'agiut]].

A peul ëdcò contaté ij tradutor amis ëd la midema lenga a la [[Portal_talk:\$1|pàgina ëd discussion]] ëd [[Portal:\$1|sò portal ëd la lenga]]'.
S'a l'ha pa anco' falo, [[Special:Preferences|ch'a cangia la lenga ëd soa antërfacia utent a la lenga ant la qual a veul fé dle tradussion]], an manera che la wiki a sia bon-a a smon-e ij colegament pi amportant për chiel.",
	'translate-fs-email-text' => "Për piasì, ch'a buta soa adrëssa ëd pòsta eletrònica ant ij [[Special:Preferences|sò gust]] e ch'a la conferma dal mëssagi che i l'oma mandaje.

Sòn a përmët a j'àutri utent ëd contatelo për pòsta eletrònica.
A arseivrà ëdcò na litra d'anformassion, al pi na vira al mèis.
S'a veul pa arsèive le litre d'anformassion, a peule serne ëd nò ant la tichëtta \"{{int:prefs-personal}}\" dij sò [[Special:Preferences|gust]].",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'firststeps' => 'لومړي ګامونه',
	'translate-fs-pagetitle-done' => ' - ترسره شو!',
	'translate-fs-signup-title' => 'نومليکل',
	'translate-fs-userpage-title' => 'ستاسې کارن مخ جوړول',
	'translate-fs-permissions-title' => 'د ژباړې د اجازې غوښتنه',
	'translate-fs-target-title' => 'په ژباړې پيل وکړۍ',
	'translate-fs-userpage-submit' => 'خپل کارن مخ جوړول',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'firststeps' => 'Primeiros passos',
	'firststeps-desc' => '[[Special:FirstSteps|Página especial]] para familiarizar os utilizadores com o uso da extensão Translate numa wiki',
	'translate-fs-pagetitle-done' => ' - terminado!',
	'translate-fs-pagetitle' => 'Assistente de iniciação - $1',
	'translate-fs-signup-title' => 'Registe-se',
	'translate-fs-settings-title' => 'Configure as suas preferências',
	'translate-fs-userpage-title' => 'Crie a sua página de utilizador',
	'translate-fs-permissions-title' => 'Solicite permissões de tradutor',
	'translate-fs-target-title' => 'Comece a traduzir!',
	'translate-fs-email-title' => 'Confirme o seu endereço de correio electrónico',
	'translate-fs-intro' => "Bem-vindo ao assistente de iniciação da {{SITENAME}}.
Será conduzido passo a passo através do processo necessário para se tornar um tradutor.
No fim, será capaz de traduzir as ''mensagens da interface'' de todos os projectos suportados na {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Criar a minha página de utilizador',
	'translate-fs-userpage-done' => 'Bom trabalho! Agora tem uma página de utilizador.',
	'translate-fs-target-text' => 'Parabéns!
Agora pode começar a traduzir.

Não se amedronte se tudo lhe parece ainda novo e confuso.
Na [[Project list|lista de projectos]] há um resumo dos projectos de tradução em que pode colaborar.
A maioria dos projectos tem uma página de descrição breve com um link «Traduza este projecto», que o leva a uma página com todas as mensagens ainda por traduzir.
Também está disponível uma lista de todos os grupos de mensagens com o [[Special:LanguageStats|estado presente de tradução para uma língua]].

Se acredita que precisa de compreender o processo melhor antes de começar a traduzir, pode ler as [[FAQ|perguntas frequentes]].
Infelizmente a documentação pode, por vezes, estar desactualizada.
Se há alguma coisa que acha que devia poder fazer, mas não consegue descobrir como, não hesite em perguntar na [[Support|página de suporte]].

Pode também contactar os outros tradutores da mesma língua na [[Portal_talk:$1|página de discussão]] do [[Portal:$1|portal da sua língua]].
Se ainda não o fez, [[Special:Preferences|defina como a sua língua da interface a língua para a qual pretende traduzir]]. Isto permite que a wiki lhe apresente os links mais relevantes para si.',
	'translate-fs-email-text' => 'Forneça o seu endereço de correio electrónico nas [[Special:Preferences|suas preferências]] e confirme-o a partir da mensagem que lhe será enviada.

Isto permite que os outros utilizadores o contactem por correio electrónico.
Também receberá newsletters, no máximo uma vez por mês.
Se não deseja receber as newsletters, pode optar por não recebê-las no separador "{{int:prefs-personal}}" das suas [[Special:Preferences|preferências]].',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'firststeps' => 'Primeiros passos',
	'firststeps-desc' => '[[Special:FirstSteps|Página especial]] para familiarizar os usuários com o uso da extensão Translate numa wiki',
	'translate-fs-pagetitle-done' => ' - feito!',
	'translate-fs-pagetitle' => 'Assistente de iniciação - $1',
	'translate-fs-signup-title' => 'Registe-se',
	'translate-fs-settings-title' => 'Configure as suas preferências',
	'translate-fs-userpage-title' => 'Crie a sua página de usuário',
	'translate-fs-permissions-title' => 'Solicite permissões de tradutor',
	'translate-fs-target-title' => 'Comece a traduzir!',
	'translate-fs-email-title' => 'Confirme o seu endereço de e-mail',
	'translate-fs-intro' => "Bem-vindo ao assistente de iniciação da {{SITENAME}}.
Você será conduzido passo-a-passo através do processo necessário para se tornar um tradutor.
No fim, será capaz de traduzir as ''mensagens da interface'' de todos os projetos suportados na {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Criar a minha página de usuário',
	'translate-fs-userpage-done' => 'Bom trabalho! Agora você tem uma página de usuário.',
	'translate-fs-target-text' => 'Parabéns!
Agora pode começar a traduzir.

Não tenha medo se tudo lhe parecer ainda novo e confuso.
Na [[Project list|lista de projetos]] há um resumo dos projetos de tradução em que você pode colaborar.
A maioria dos projetos tem uma página de descrição breve com um link "Traduza este projeto", que o leva a uma página com todas as mensagens ainda por traduzir.
Também está disponível uma lista de todos os grupos de mensagens com o [[Special:LanguageStats|estado presente de tradução para uma língua]].

Se acredita que precisa de compreender o processo melhor antes de começar a traduzir, pode ler as [[FAQ|perguntas frequentes]].
Infelizmente a documentação pode, por vezes, estar desatualizada.
Se há alguma coisa que acha que devia poder fazer, mas não consegue descobrir como, não hesite em perguntar na [[Support|página de suporte]].

Pode também contatar os outros tradutores da mesma língua na [[Portal_talk:$1|página de discussão]] do [[Portal:$1|portal da sua língua]].
Se ainda não o fez, [[Special:Preferences|defina como a sua língua da interface a língua para a qual pretende traduzir]]. Isto permite que a wiki lhe apresente os links mais relevantes para você.',
	'translate-fs-email-text' => 'Forneça o seu endereço de e-mail nas [[Special:Preferences|suas preferências]] e confirme-o a partir da mensagem que lhe será enviada.

Isto permite que os outros utilizadores o contatem por e-mail.
Também receberá newsletters, no máximo uma vez por mês.
Se não deseja receber as newsletters, pode optar por não recebê-las no separador "{{int:prefs-personal}}" das suas [[Special:Preferences|preferências]].',
);

/** Romanian (Română)
 * @author Minisarm
 */
$messages['ro'] = array(
	'firststeps' => 'Primii pași',
	'firststeps-desc' => '[[Special:FirstSteps|Pagină specială]] pentru a veni în întâmpinarea utilizatorilor unui site wiki care folosesc extensia Translate',
	'translate-fs-pagetitle-done' => ' – realizat!',
	'translate-fs-pagetitle' => 'Ghidul începătorului – $1',
	'translate-fs-signup-title' => 'Înregistrați-vă',
	'translate-fs-settings-title' => 'Configurați-vă preferințele',
	'translate-fs-userpage-title' => 'Creați-vă propria pagină de utilizator',
	'translate-fs-permissions-title' => 'Cereți permisiuni de traducător',
	'translate-fs-target-title' => 'Să traducem!',
	'translate-fs-email-title' => 'Confirmați-vă adresa de e-mail',
	'translate-fs-intro' => "Bine ați venit: acesta este un ghid al începătorului oferit de {{SITENAME}}.
Veți fi îndrumat pas cu pas pentru a deveni un traducător.
În finalul procesului, veți putea traduce ''mesaje din interfața'' tuturor proiectelor care dispun de serviciile {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Creează-mi pagina mea de utilizator',
	'translate-fs-userpage-done' => 'Foarte bine! Acum aveți o pagină de utilizator.',
	'translate-fs-target-text' => "Felicitări!
Din acest moment puteți traduce.

Nu vă faceți griji dacă încă nu v-ați acomodat, iar unele lucruri vi se par ciudate.
[[Project list|Lista de aici]] reprezintă o trecere în revistă a proiectelor la care puteți contribui.
Majoritatea proiectelor beneficiază de o pagină descriptivă care conține și legătura „''Tradu acest proiect''”, legătură ce vă va conduce către o pagină afișând toate mesajele netraduse.
De asemenea, este disponibilă o listă a grupurilor de mesaje cu [[Special:LanguageStats|situația curentă în funcție de limbă]].

Dacă simțiți că detaliile de până acum sunt insuficiente, puteți consulta  [[FAQ|întrebările frecvente]] înainte de a traduce.
Din păcate, în unele cazuri, documentația este învechită și neactualizată.
Dacă există vreun lucru de care bănuiți că sunteți capabil, dar nu ați descoperit încă cum să procedați, nu ezitați să puneți întrebări la [[Support|cafeneaua locală]].

Puteți, de asemenea, să contactați și alți traducători de aceeași limbă pe [[Portal_talk:$1|pagina de discuție]] a [[Portal:$1|portalului lingvistic]] asociat comunității dumneavoastră.
Dacă nu ați procedat deja conform îndrumărilor, [[Special:Preferences|schimbați limba interfeței în așa fel încât să fie identică cu limba în care traduceți]]. Astfel, site-ul wiki este capabil să se plieze nevoilor dumneavoastră mult mai bine prin legături relevante.",
	'translate-fs-email-text' => 'Vă rugăm să ne furnizați o adresă de e-mail prin intermediul [[Special:Preferences|paginii preferințelor]], după care să o confirmați (verificați-vă căsuța de poștă electronică căutând un mesaj trimis de noi).

Acest lucru oferă posibilitatea altor utilizator să vă contacteze utilizând poșta electronică.
De asemenea, veți primi, cel mult o dată pe lună, un mesaj cu noutăți și știri.
Dacă nu doriți să recepționați acest newsletter, vă puteți dezabona în fila „{{int:prefs-personal}}” a [[Special:Preferences|preferințelor]] dumneavoastră.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'translate-fs-pagetitle-done' => '- apposte!',
);

/** Russian (Русский)
 * @author Eleferen
 * @author G0rn
 * @author Hypers
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'firststeps' => 'Первые шаги',
	'firststeps-desc' => '[[Special:FirstSteps|Служебная страница]] для новых пользователей вики с установленным расширением перевода',
	'translate-fs-pagetitle-done' => ' — сделано!',
	'translate-fs-pagetitle' => 'Программа начального обучения — $1',
	'translate-fs-signup-title' => 'Зарегистрируйтесь',
	'translate-fs-settings-title' => 'Произведите настройку',
	'translate-fs-userpage-title' => 'Создайте свою страницу участника',
	'translate-fs-permissions-title' => 'Запросите права переводчика',
	'translate-fs-target-title' => 'Начните переводить!',
	'translate-fs-email-title' => 'Подтвердите свой адрес электронной почты',
	'translate-fs-intro' => 'Добро пожаловать в программу начального обучения проекта {{SITENAME}}.
Шаг за шагом вы будете проведены по обучающей программе переводчиков.
По окончанию обучения вы сможете переводить интерфейсные сообщения всех поддерживаемых проектов {{SITENAME}}.',
	'translate-fs-selectlanguage' => 'Выберите язык',
	'translate-fs-settings-planguage' => 'Основной язык:',
	'translate-fs-settings-slanguage' => 'Вспомогательные языки $1:',
	'translate-fs-settings-submit' => 'Сохранить настройки',
	'translate-fs-userpage-level-N' => 'Мой родной язык',
	'translate-fs-userpage-level-5' => 'Я профессиональный переводчик с',
	'translate-fs-userpage-level-4' => 'Я в совершенстве владею',
	'translate-fs-userpage-level-3' => 'Я хорошо знаю',
	'translate-fs-userpage-level-2' => 'Я средне владею',
	'translate-fs-userpage-level-1' => 'Начальные знания',
	'translate-fs-userpage-help' => 'Пожалуйста, укажите свои знания языков и расскажите нам немного о себе. Если вы знаете больше, чем пять языков, вы сможете добавить их позже.',
	'translate-fs-userpage-submit' => 'Создать мою страницу участника',
	'translate-fs-userpage-done' => 'Отлично! Теперь у вас есть страница участника.',
	'translate-fs-permissions-planguage' => 'Основной язык:',
	'translate-fs-permissions-help' => 'Теперь вам нужно разместить запрос, для вступления в группу переводчиков.
Выберите основной язык, на который Вы планируете осуществлять переводы.

Можно указать другие языки и примечания в текстовом поле ниже.',
	'translate-fs-permissions-pending' => 'Ваша заявка была подана [[$1]], и кто-то из сотрудников сайта проверит её в ближайшее время.
Если вы подтвердите свой адрес электронной почты, Вы получите уведомление по электронной почте, как только это произойдёт.',
	'translate-fs-permissions-submit' => 'Отправить запрос',
	'translate-fs-target-text' => "Поздравляем!
Теперь вы можете начать переводить.

Не бойтесь, если что-то до сих пор кажется новым и запутанным для вас.
В [[Project list|списке проектов]] находится обзор проектов, для которых вы можете осуществлять перевод.
Большинство проектов имеют небольшую страницу с описанием и ссылкой ''«Translate this project»'', которая ведёт на страницу со списком всех непереведённых сообщений.
Также имеется список всех групп сообщений с [[Special:LanguageStats|текущим статусом перевода для языка]].

Если вам кажется, что вам необходимо получить больше сведений перед началом перевода, то вы можете прочитать [[FAQ|часто задаваемые вопросы]].
К сожалению, документация иногда может быть устаревшей.
Если есть что-то, что по вашему мнению вы можете сделать, но не знаете как, то не стесняйтесь спросить об этом на [[Support|странице поддержки]].

Вы также можете связаться с переводчиками на странице [[Portal_talk:$1|обсуждения]] [[Portal:$1|портала вашего языка]].
Если вы этого ещё не сделали, укажите в [[Special:Preferences|ваших настройках]] язык, на который вы собираетесь переводить, тогда в интерфейсе вам будут показаны соответствующие ссылки.",
	'translate-fs-email-text' => 'Пожалуйста, укажите свой адрес электронной почты в [[Special:Preferences|персональных настройках]] и подтвердите его, перейдя по ссылке из письма, которое вам будет отправлено.

Это позволит другим участникам связываться с вами по электронной почте.
Вы также будете получать новостную рассылку раз в месяц.
Если вы не хотите получать рассылку, то можете отказаться от неё на вкладке «{{int:prefs-personal}}» своих [[Special:Preferences|персональных настроек]].',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'firststeps' => 'Першы крокы',
	'translate-fs-pagetitle-done' => ' - зроблено!',
	'translate-fs-signup-title' => 'Зареґіструйте ся',
	'translate-fs-userpage-title' => 'Створити вашу сторінку хоснователя',
	'translate-fs-permissions-title' => 'Жадати права перекладателя',
	'translate-fs-target-title' => 'Започати перекладаня!',
	'translate-fs-email-title' => 'Підтвердьте свою адресу ел. пошты',
	'translate-fs-userpage-submit' => 'Створити мою сторінку хоснователя',
	'translate-fs-userpage-done' => 'Добрі зроблено! Теперь маєте сторінку хоснователя.',
);

/** Sinhala (සිංහල)
 * @author බිඟුවා
 */
$messages['si'] = array(
	'firststeps' => 'පළමු පියවරවල්',
	'translate-fs-pagetitle-done' => ' - හරි!',
	'translate-fs-signup-title' => 'ප්‍රවිෂ්ඨ වන්න',
	'translate-fs-target-title' => 'පරිවර්තනය කිරීම අරඹන්න!',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'firststeps' => 'Prvi koraki',
	'firststeps-desc' => '[[Special:FirstSteps|Posebna stran]] za pripravo uporabnikov na začetek uporabe wikija z uporabo razširitve Translate',
	'translate-fs-pagetitle-done' => ' – končano!',
	'translate-fs-pagetitle-pending' => ' - na čakanju',
	'translate-fs-pagetitle' => 'Čarovnik prvih korakov – $1',
	'translate-fs-signup-title' => 'Prijavite se',
	'translate-fs-settings-title' => 'Konfigurirajte svoje nastavitve',
	'translate-fs-userpage-title' => 'Ustvarite svojo uporabniško stran',
	'translate-fs-permissions-title' => 'Zaprosite za prevajalska dovoljenja',
	'translate-fs-target-title' => 'Začnite prevajati!',
	'translate-fs-email-title' => 'Potrdite svoj e-poštni naslov',
	'translate-fs-intro' => "Dobrodošli v čarovniku prvih korakov na {{GRAMMAR:dajalnik|{{SITENAME}}}}.
Vodili vas bomo skozi postopek, da postanete prevajalec, korak za korakom.
Na koncu boste lahko prevajali ''sporočila vmesnika'' vseh podprtih projektov na {{GRAMMAR:dajalnik|{{SITENAME}}}}.",
	'translate-fs-selectlanguage' => 'Izberite jezik',
	'translate-fs-settings-planguage' => 'Prvotni jezik:',
	'translate-fs-settings-planguage-desc' => 'Prvotni jezik se kaže kot vaš jezik vmesnika na tem wikiju
in kot privzeti ciljni jezik prevodov.',
	'translate-fs-settings-slanguage' => 'Pomožni jezik $1:',
	'translate-fs-settings-slanguage-desc' => 'V urejevalniku prevodov je mogoče prikazati prevode sporočil v drugih jezikih.
Tukaj lahko izberete jezike, ki bi jih radi videli, če to želite.',
	'translate-fs-settings-submit' => 'Shrani nastavitve',
	'translate-fs-userpage-level-N' => 'Sem naravni govorec',
	'translate-fs-userpage-level-5' => 'Sem profesionalni prevajalec',
	'translate-fs-userpage-level-4' => 'Govorim ga skoraj enako dobro kakor prvi jezik',
	'translate-fs-userpage-level-3' => 'Zelo dobro govorim',
	'translate-fs-userpage-level-2' => 'Srednje dobro govorim',
	'translate-fs-userpage-level-1' => 'Poznam osnove',
	'translate-fs-userpage-help' => 'Prosimo, navedite svoje znanje jezikov in nam povejte nekaj o sebi. Če znate več kot pet jezikov, jih lahko dodate pozneje.',
	'translate-fs-userpage-submit' => 'Ustvari mojo uporabniško stran',
	'translate-fs-userpage-done' => 'Dobro opravljeno! Sedaj imate uporabniško stran.',
	'translate-fs-permissions-planguage' => 'Prvotni jezik:',
	'translate-fs-permissions-help' => 'Sedaj morate vložiti prošnjo za priključitev k skupini prevajalcev.
Izberite prvotni jezik, v katerega boste prevajali.

V spodnjem polju lahko omenite tudi druge jezike in druge pripombe.',
	'translate-fs-permissions-pending' => 'Vašo prošnjo smo posredovali na [[$1]] in nekdo od osebja strani jo bo čim prej preveril.
Če potrdite svoj e-poštni naslov, boste prejeli e-poštno obvestilo takoj, ko se to zgodi.',
	'translate-fs-permissions-submit' => 'Pošlji zahtevo',
	'translate-fs-target-text' => "Čestitamo!
Sedaj lahko začnete prevajati.

Ne bojte se, če se vam še vedno zdi novo in zmedeno.
Na [[Project list|Seznamu projektov]] se nahaja pregled projektov, h katerim lahko prispevate s prevajanjem.
Večina projektov ima kratko opisno stran s povezavo »''Prevedi ta projekt''«, ki vas bo ponesla na stran s seznamom neprevedenih sporočil.
Na voljo je tudi seznam vseh skupin sporočil s [[Special:LanguageStats|trenutnim stanjem prevodov za jezik]].

Če menite, da morate razumeti več stvari, preden začnete prevajati, lahko preberete [[FAQ|Pogosto zastavljena vprašanja]].
Žal je lahko dokumentacija ponekod zastarela.
Če je kaj takega, kar bi morali storiti, vendar ne ugotovite kako, ne oklevajte in povprašajte na [[Support|podporni strani]].

Prav tako lahko stopite v stik s kolegi prevajalci istega jezika na [[Portal_talk:$1|pogovorni strani]] [[Portal:$1|vašega jezikovnega portala]].
Če še tega niste storili, nastavite [[Special:Preferences|jezik vašega uporabniškega vmesnika na jezik v katerega želite prevajati]], da bo wiki lahko prikazal povezave, ki vam najbolje ustrezajo.",
	'translate-fs-email-text' => 'Prosimo, navedite svoj e-poštni naslov v [[Special:Preferences|svojih nastavitvah]] in ga potrdite iz e-pošte, ki vam bo poslana.

To omogoča drugim uporabnikom, da stopijo v stik z vami preko e-pošte.
Prav tako boste prejemali glasilo, največ enkrat mesečno.
Če ne želite prejemati glasila, se lahko odjavite na zavihku »{{int:prefs-personal}}« v vaših [[Special:Preferences|nastavitvah]].',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'translate-fs-pagetitle-done' => ' - anggeus!',
	'translate-fs-pagetitle' => 'Sulap mitembeyan - $1',
	'translate-fs-signup-title' => 'Daptar',
	'translate-fs-settings-title' => 'Setél préferénsi anjeun',
	'translate-fs-userpage-title' => 'Jieun kaca pamaké anjeun',
	'translate-fs-permissions-title' => 'Ménta kawenangan panarjamah',
	'translate-fs-target-title' => 'Mimitian narjamahkeun!',
	'translate-fs-email-title' => 'Konfirmasi alamat surélék anjeun',
);

/** Swedish (Svenska)
 * @author Fredrik
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'firststeps' => 'Komma igång',
	'firststeps-desc' => '[[Special:FirstSteps|Särskild sida]] för att få användare att komma igång med en wiki med hjälp av översättningstillägget',
	'translate-fs-pagetitle-done' => ' – klart!',
	'translate-fs-pagetitle' => 'Guide för att komma igång - $1',
	'translate-fs-signup-title' => 'Skapa ett användarkonto',
	'translate-fs-settings-title' => 'Konfigurera inställningar',
	'translate-fs-userpage-title' => 'Skapa din användarsida',
	'translate-fs-permissions-title' => 'Ansök om översättarbehörigheter',
	'translate-fs-target-title' => 'Börja översätta!',
	'translate-fs-email-title' => 'Bekräfta din e-postadress',
	'translate-fs-intro' => "Välkommen till guiden för att komma igång med {{SITENAME}}. Du kommer att vägledas stegvis i hur man blir översättare. När du är färdig kommer du att kunna översätta ''gränssnittsmeddelanden'' av alla projekt som stöds av {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Skapa din användarsida',
	'translate-fs-userpage-done' => 'Mycket bra! Du har nu en användarsida.',
	'translate-fs-target-text' => 'Grattis! Nu kan du börja översätta.

Var inte rädd om det fortfarande känns nytt och främmande för dig.
På sidan [[Project list|Projektlista]] finns en översikt över projekt du kan bidra med översättningar till. De flesta projekt har en sida med en kort beskrivning och en länk "\'\'Översätt det här projektet\'\'" som tar dig till en sida som listar alla oöversatta meddelanden.
Det finns även en förteckning över alla meddelandegrupper med [[Special:LanguageStats|den aktuella översättningsstatusen för ett språk]].

Om du känner att du behöver förstå mer innan du börjar översätta kan du läsa igenom [[FAQ|Vanliga frågor]].
Tyvärr kan dokumentationen vara föråldrad ibland.
Om det finns något som du tror att du skulle kunna göra men inte lyckas ta på reda på hur, så tveka inte att fråga på [[Support|supportsidan]].

Du kan också ta kontakt med de andra översättarna av samma språk på [[Portal:$1|din språkportals]] [[Portal_talk:$1|diskussionssida]].
Portalen länkar till språket i din nuvarande [[Special:Preferences|språkinställning]].
Du kan ändra om det behövs.',
	'translate-fs-email-text' => 'Ange din e-postadress i [[Special:Preferences|dina inställningar]] och bekräfta den genom det e-postmeddelande som skickas till dig.

Detta gör det möjligt för andra användare att kontakta dig via e-post.
Du kommer också att få ett nyhetsbrev högst en gång i månaden.
Om du inte vill få några nyhetsbrev så kan kan välja bort dem under fliken "{{int:prefs-personal}}" i dina [[Special:Preferences|inställningar]].',
);

/** Tulu (ತುಳು)
 * @author VASANTH S.N.
 */
$messages['tcy'] = array(
	'firststeps' => 'ಸುರುತ ಪಜ್ಜೆಲು',
	'translate-fs-selectlanguage' => 'ಒಂಜಿ ಬಾಸೆನ್ ಆಯ್ಕೆ ಮಲ್ಪುಲೆ',
	'translate-fs-settings-planguage' => 'ಪ್ರಾಥಮಿಕೆ ಬಾಸೆ',
	'translate-fs-settings-slanguage' => 'ಸಹಾಯಕ ಬಾಸೆ: $1',
	'translate-fs-userpage-level-N' => 'ಎನ್ನ ಮಾತೃಭಾಸೆ',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'firststeps' => 'మొదటి అడుగులు',
	'translate-fs-pagetitle-done' => ' - పూర్తయ్యింది!',
	'translate-fs-signup-title' => 'నమోదు',
	'translate-fs-settings-title' => 'మీ అభిరుచులను అమర్చుకోండి',
	'translate-fs-userpage-title' => 'మీ వాడుకరి పుటని సృష్టించుకోండి',
	'translate-fs-permissions-title' => 'అనువాద అనుమతులకై అభ్యర్థించండి',
	'translate-fs-target-title' => 'అనువదించడం మొదలుపెట్టండి!',
	'translate-fs-email-title' => 'మీ ఈమెయిలు చిరునామాని నిర్ధారించండి',
	'translate-fs-intro' => '{{SITENAME}} యొక్క తొలి అడుగుల విజార్డుకు స్వాగతం.
అంచెలంచెలుగా అనువాదకుడిగా తయారయే విధానం గురించి మీకిక్కడ మార్గదర్శకత్వం లభిస్తుంది.
చివరికి, {{SITENAME}} లో మద్దతు ఉన్న అన్ని ప్రాజెక్టుల్లోను "ఇంటరుఫేసు సందేశాల"ను అనువదించే సామర్ధ్యం మీకు లభిస్తుంది.',
	'translate-fs-userpage-submit' => 'నా వాడుకరి పుటని సృష్టించు',
	'translate-fs-userpage-done' => 'భళా! మీకు ఇప్పుడు వాడుకరి పుట ఉంది.',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'translate-fs-pagetitle-done' => 'เรียบร้อย!',
	'translate-fs-signup-title' => 'สมัครสมาชิก',
	'translate-fs-settings-title' => 'ตั้งค่าการใช้งาน',
	'translate-fs-userpage-title' => 'สร้างหน้าผู้ใช้ของคุณ',
	'translate-fs-permissions-title' => 'ขออนุญาตแปล',
	'translate-fs-target-title' => 'เริ่มต้นแปล!',
	'translate-fs-email-title' => 'ยืนยันอีเมล',
	'translate-fs-userpage-submit' => 'สร้างหน้าผู้ใช้ของฉัน',
	'translate-fs-userpage-done' => 'ตอนนี้คุณมีหน้าผู้ใช้ของคุณเองแล้ว',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'firststeps' => 'Unang mga hakbang',
	'firststeps-desc' => '[[Special:FirstSteps|Natatanging pahina]] upang magawang magsimula ang mga tagagamit sa isang wiki sa pamamagitan ng dugtong na Pagsasalinwika',
	'translate-fs-pagetitle-done' => ' - gawa na!',
	'translate-fs-pagetitle' => 'Masalamangkang pagsisimula - $1',
	'translate-fs-signup-title' => 'Magpatala',
	'translate-fs-settings-title' => 'Isaayos ang mga nais mo',
	'translate-fs-userpage-title' => 'Likhain ang pahina mo ng tagagamit',
	'translate-fs-permissions-title' => 'Humiling ng mga pahintulot na pangtagapagsalinwika',
	'translate-fs-target-title' => 'Magsimulang magsalinwika!',
	'translate-fs-email-title' => 'Tiyakin ang tirahan mo ng e-liham',
	'translate-fs-intro' => "Maligayang pagdating sa masalamangkang unang mga hakbang ng {{SITENAME}}.
Hakbang-hakbang na gagabayan ka sa proseso ng pagiging isang tagapagsalinwika.
Sa huli, makakapagsalinwika ka ng ''mga mensahe ng ugnayang-mukha'' ng lahat ng tinatangkilik na mga proyekto sa {{SITENAME}}.",
	'translate-fs-userpage-submit' => 'Likhain ang aking pahina ng tagagamit',
	'translate-fs-userpage-done' => 'Mahusay! Mayroon ka na ngayong isang pahina ng tagagamit.',
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 */
$messages['tr'] = array(
	'firststeps' => 'İlk adımlar',
	'translate-fs-pagetitle-done' => ' - tamam!',
	'translate-fs-pagetitle-pending' => ' - bekliyor',
	'translate-fs-signup-title' => 'Kaydol',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Sahran
 */
$messages['ug-arab'] = array(
	'firststeps' => 'تۇنجى قەدەم',
	'translate-fs-pagetitle-done' => ' - تامام!',
	'translate-fs-pagetitle' => 'باشلاش يېتەكچىسىگە ئېرىش - $1',
	'translate-fs-settings-title' => 'مايىللىقىڭىزنى سەپلەڭ',
	'translate-fs-userpage-title' => 'ئىشلەتكۈچى بېتىڭىزنى قۇرۇڭ',
	'translate-fs-permissions-title' => 'تەرجىمە قىلىش ھوقۇق ئىلتىماسى',
	'translate-fs-target-title' => 'تەرجىمە قىلىشنى باشلا!',
	'translate-fs-email-title' => 'ئېلخەت مەنزىلىڭىزنى جەزملەڭ',
);

/** Ukrainian (Українська)
 * @author A1
 * @author Hypers
 * @author Тест
 */
$messages['uk'] = array(
	'firststeps' => 'Перші кроки',
	'firststeps-desc' => '[[Special:FirstSteps|Спеціальна сторінка]], яка полегшує новим користувачам початок роботи з використанням розширення Translate',
	'translate-fs-pagetitle-done' => ' - зроблено!',
	'translate-fs-pagetitle' => 'Майстер "Початок роботи" - $1',
	'translate-fs-signup-title' => 'Зареєструйтеся',
	'translate-fs-settings-title' => 'Встановіть ваші налаштування',
	'translate-fs-userpage-title' => 'Створіть вашу сторінку користувача',
	'translate-fs-permissions-title' => 'Зробіть запит на права перекладача',
	'translate-fs-target-title' => 'Почніть перекладати!',
	'translate-fs-email-title' => 'Підтвердіть вашу адресу електронної пошти',
	'translate-fs-intro' => 'Ласкаво просимо до майстра "перші кроки" проекту {{SITENAME}}.
Крок за кроком майстер проведе вас шляхом становлення як перекладача.
Зрештою, ви зможете перекладати інтерфейсні повідомлення усіх проектів, що підтримуються на {{SITENAME}}.',
	'translate-fs-userpage-level-N' => 'Моя рідна мова',
	'translate-fs-userpage-level-5' => 'Я - професійний перекладач з',
	'translate-fs-userpage-level-4' => 'Досконало володію',
	'translate-fs-userpage-level-3' => 'Добре володію',
	'translate-fs-userpage-level-2' => 'Володію на середньому рівні',
	'translate-fs-userpage-level-1' => 'Трішки знаю',
	'translate-fs-userpage-help' => "Будь ласка, вкажіть свої знання мов і розкажіть нам трохи про себе. Якщо ви знаєте більше, ніж п'ять мов, ви зможете додати їх пізніше.",
	'translate-fs-userpage-submit' => 'Створити мою сторінку користувача',
	'translate-fs-userpage-done' => 'Чудово! Тепер у вас є сторінка користувача.',
	'translate-fs-permissions-planguage' => 'Основна мова:',
	'translate-fs-permissions-help' => 'Тепер вам потрібно розмістити запит для вступу в групу перекладачів.
Виберіть основну мову, на яку Ви плануєте перекладати.

Можна вказати інші мови і примітки в текстовому полі нижче.',
	'translate-fs-permissions-pending' => 'Ваш запит подано [[$1]], і хтось із співробітників сайту перевірить її найближчим часом.
Якщо ви підтвердите свою адресу електронної пошти, Ви отримаєте повідомлення по електронній пошті, як тільки це станеться.',
	'translate-fs-permissions-submit' => 'Надіслати запит',
	'translate-fs-target-text' => 'Вітаємо!
Тепер ви можете розпочати перекладати.

Не турбуйтеся, якщо це досі здається вам новим і заплутаним.
В [[Project list|переліку проектів]] є огляд проектів, яким ви можете допомогти з перекладами.
Більшість цих проектів має сторінку з невеличким описом та посиланням "\'\'Translate this project\'\'", яке приведе Вас на сторінку з переліком усіх неперекладених повідомлень.
Також доступний список всіх груп повідомлень з [[Special:LanguageStats|поточним статусом перекладу для цієї мови]].

Якщо ви відчуваєте, що вам необхідно отримати більше інформації, перш ніж приступити до перекладу, ви можете прочитати [[FAQ|часті запитання]].
На жаль, іноді документація може бути застарілою.
Якщо ви думаєте, що повинна бути можливість щось зробити, але не можете дізнатися як, не вагайтеся питати про це на [[Support|сторінці підтримки]].

Ви також можете звернутися до колег - перекладачів тієї ж мови на [[Portal_talk:$1|сторінці обговорення]] [[Portal:$1|порталу вашої мови]].
Якщо ви ще не зробили цього, [[Special:Preferences|змініть мову вашого інтерфейсу користувача на ту, якою хочете перекладати]], щоб у вікі була змога показувати найбільш відповідні для Вас посилання.',
	'translate-fs-email-text' => 'Будь ласка, введіть Вашу адресу електронної пошти в [[[Special:Preferences|налаштуваннях]] і підтвердіть її з листа, який буде вам надіслано.

Це дозволить іншим користувачам зв\'язуватися з вами електронною поштою.
Ви також будете отримувати розсилку новин не частіше одного разу на місяць.
Якщо ви не хочете отримувати розсилку новин, ви можете відмовитися від неї у вкладці "{{int:prefs-personal}}" ваших [Special:Preferences|налаштувань]].',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'firststeps' => 'Ezmäižed haškud',
	'translate-fs-pagetitle-done' => '- om tehtud!',
	'translate-fs-target-title' => "Zavot'kat kändmaha!",
	'translate-fs-email-title' => 'Vahvištoitta e-počtan adres',
	'translate-fs-selectlanguage' => "Valita kel'",
	'translate-fs-settings-planguage' => "Aluskel'",
	'translate-fs-settings-slanguage' => "$1. abukel':",
	'translate-fs-settings-submit' => 'Kaita järgendused',
	'translate-fs-userpage-level-N' => "Minun mamankel'",
	'translate-fs-userpage-level-5' => 'Olen professionaline kändai',
	'translate-fs-userpage-level-4' => 'Mahtan pagišta kut kelenkandai',
	'translate-fs-userpage-level-3' => 'Mahtan hüvin',
	'translate-fs-userpage-level-2' => 'Mahtan keskmäras',
	'translate-fs-userpage-level-1' => 'Mahtan vähäižel',
	'translate-fs-userpage-submit' => "Säta minun personaline lehtpol'",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'firststeps' => 'Các bước đầu',
	'firststeps-desc' => '[[Special:FirstSteps|Trang đặc biệt]] để giúp những người mơi đến bắt đầu sử dụng phần mở rộng Dịch',
	'translate-fs-pagetitle-done' => ' – đã hoàn tất!',
	'translate-fs-pagetitle-pending' => ' – đang chờ',
	'translate-fs-pagetitle' => 'Trình Thuật sĩ Bắt đầu – $1',
	'translate-fs-signup-title' => 'Đăng ký',
	'translate-fs-settings-title' => 'Cấu hình tùy chọn',
	'translate-fs-userpage-title' => 'Tạo trang cá nhân',
	'translate-fs-permissions-title' => 'Yêu cầu quyền biên dịch viên',
	'translate-fs-target-title' => 'Tiến hành dịch!',
	'translate-fs-email-title' => 'Xác nhận địa chỉ thư điện tử',
	'translate-fs-intro' => "Hoan nghênh bạn đến với trình hướng dẫn sử dụng {{SITENAME}}.
Bạn sẽ được hướng dẫn từng bước quá trình trở thành biên dịch viên.
Cuối cùng bạn sẽ có thể dịch được ''thông điệp giao diện'' của tất cả các dự án được hỗ trợ tại {{SITENAME}}.",
	'translate-fs-selectlanguage' => 'Chọn một ngôn ngữ',
	'translate-fs-settings-planguage' => 'Ngôn ngữ chính:',
	'translate-fs-settings-planguage-desc' => 'Ngôn ngữ chính cũng là ngôn ngữ giao diện khi bạn sử dụng wiki này
và là ngôn ngữ mặc định để biên dịch sang.',
	'translate-fs-settings-slanguage' => 'Ngôn ngữ bổ trợ $1:',
	'translate-fs-settings-slanguage-desc' => 'Để hiển thị bản dịch tương ứng trong ngôn ngữ khác trong hộp biên dịch, chọn các ngôn ngữ bổ trợ tại đây.',
	'translate-fs-settings-submit' => 'Lưu tùy chọn',
	'translate-fs-userpage-level-N' => 'Ngôn ngữ mẹ đẻ của tôi là',
	'translate-fs-userpage-level-5' => 'Tôi là một chuyên gia biên dịch',
	'translate-fs-userpage-level-4' => 'Tôi biên dịch gần như ngôn ngữ mẹ đẻ sang',
	'translate-fs-userpage-level-3' => 'Tôi biên dịch lưu loát sang',
	'translate-fs-userpage-level-2' => 'Tôi biên dịch với trình độ trung bình sang',
	'translate-fs-userpage-level-1' => 'Tôi biên dịch với trình độ cơ bản sang',
	'translate-fs-userpage-help' => 'Xin vui lòng tự giới thiệu và cho biết khả năng sử dụng các ngôn ngữ. Nếu bạn sử dụng hơn năm thứ tiếng, bạn có thể bổ sung thêm sau này.',
	'translate-fs-userpage-submit' => 'Tạo trang cá nhân',
	'translate-fs-userpage-done' => 'Tốt lắm! Bây giờ bạn đã có trang người dùng.',
	'translate-fs-permissions-planguage' => 'Ngôn ngữ chính:',
	'translate-fs-permissions-help' => 'Bây giờ bạn cần phải yêu cầu được thêm vào nhóm biên dịch viên.
Chọn ngôn ngữ chính mà bạn sẽ biên dịch sang.

Bạn cũng có thể đề cập đến ngôn ngữ khác và cho biết thêm thông tin trong hộp ở dưới.',
	'translate-fs-permissions-pending' => 'Lời yêu cầu của bạn đã được gửi cho [[$1]]. Một nhân viên trang sẽ duyệt qua nó không lâu.
Nếu bạn xác nhận địa chỉ thư điện tử của bạn, bạn sẽ nhận một thư điện tử báo cho bạn ngay khi nó được duyệt qua.',
	'translate-fs-permissions-submit' => 'Gửi yêu cầu',
	'translate-fs-target-text' => 'Chúc mừng bạn!
Giờ bạn đã có thể bắt đầu biên dịch.

Đừng e ngại nếu bạn còn cảm thấy bỡ ngỡ và rối rắm.
Tại [[Project list]] có danh sách tổng quan các dự án mà bạn có thể đóng góp bản dịch vào.
Phần lớn các dự án đều có một trang miêu tả ngắn cùng với liên kết "\'\'Dịch dự án này\'\'", nó sẽ đưa bạn đến trang trong đó liệt kê mọi thông điệp chưa dịch.
Danh sách tất cả các nhóm thông điệp cùng với [[Special:LanguageStats|tình trạng biên dịch hiện tại của một ngôn ngữ]] cũng có sẵn.

Nếu bạn cảm thấy bạn cần phải hiểu rõ hơn trước khi bắt đầu dịch, bạn có thể đọc [[FAQ|các câu hỏi thường gặp]].
Rất tiếc là văn bản này đôi khi hơi lạc hậu.
Nếu có gì bạn nghĩ bạn nên làm, nhưng không biết cách, đừng do dự hỏi nó tại [[Support|trang hỗ trợ]].

Bạn cũng có thể liên hệ với đồng nghiệp biên dịch của cùng ngôn ngữ ở [[Portal_talk:$1|trang thảo luận]] của [[Portal:$1|cổng ngôn ngữ của bạn]].
Cổng này liên kết đến [[Special:Preferences|tùy chọn ngôn ngữ của bạn]].
Xin hãy thay đổi nếu cần.',
	'translate-fs-email-text' => 'Xin cung cấp cho chúng tôi địa chỉ thư điện tử của bạn trong [[Special:Preferences|tùy chọn cá nhân]] và xác nhận nó trong thư chúng tôi gửi cho bạn.

Nó cho phép người khác liên hệ với bạn qua thư.
Bạn cũng sẽ nhận được thư tin tức tối đa một bức một tháng.
Nếu bạn không muốn nhận thư tin tức, bạn có thể bỏ nó ra khỏi thẻ "{{int:prefs-personal}}" trong [[Special:Preferences|tùy chọn cá nhân]].',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'firststeps' => 'ערשטע טריט',
	'translate-fs-userpage-title' => 'שאַפֿן אײַער באַניצער בלאַט',
	'translate-fs-permissions-title' => 'בעטן איבערזעצער אויטאריזאַציע',
	'translate-fs-target-title' => 'אָנהייבן איבערזעצן!',
	'translate-fs-email-title' => 'באַשטעטיקט אײַער בליצפּאָסט אַדרעס',
	'translate-fs-userpage-submit' => 'שאַפֿן מיין באַניצער בלאַט',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Anakmalaysia
 * @author Chenxiaoqino
 * @author Hydra
 * @author Hzy980512
 * @author Mark85296341
 */
$messages['zh-hans'] = array(
	'firststeps' => '第一步',
	'firststeps-desc' => '让用户开始wiki翻译的[[Special:FirstSteps|引导页面]]',
	'translate-fs-pagetitle-done' => ' - 完成！',
	'translate-fs-pagetitle-pending' => '- 待定',
	'translate-fs-pagetitle' => '入门向导 - $1',
	'translate-fs-signup-title' => '注册',
	'translate-fs-settings-title' => '设置你的选项',
	'translate-fs-userpage-title' => '创建你的用户页面',
	'translate-fs-permissions-title' => '请求翻译者权限',
	'translate-fs-target-title' => '开始翻译！',
	'translate-fs-email-title' => '确认您的邮箱地址',
	'translate-fs-intro' => "欢迎来到 {{SITENAME}}入门向导。
你会被指导如何成为一名翻译者。
最后你将可以翻译{{SITENAME}}里所有项目的''界面消息''.",
	'translate-fs-selectlanguage' => '选择一种语言',
	'translate-fs-settings-planguage' => '首选语言：',
	'translate-fs-settings-planguage-desc' => '该首选语言作为此维基项目的用户界面，
并成为默认的翻译目标语言。',
	'translate-fs-settings-slanguage' => '第$1辅助语言：',
	'translate-fs-settings-slanguage-desc' => '在翻译编辑器之内可以显示其他语言翻译的消息。
您可以在此选择您想显示的语言。',
	'translate-fs-settings-submit' => '保存设定',
	'translate-fs-userpage-level-N' => '我的母语是',
	'translate-fs-userpage-level-5' => '我能专业地翻译的语言是',
	'translate-fs-userpage-level-4' => '我熟练像母语者一样流利',
	'translate-fs-userpage-level-3' => '我熟练不错',
	'translate-fs-userpage-level-2' => '我熟练平平',
	'translate-fs-userpage-level-1' => '我知道一点点',
	'translate-fs-userpage-help' => '请说明您的语言能力，并告诉我们关于您自己。如果您知道超过五种语言，您可以以后添加更多。',
	'translate-fs-userpage-submit' => '创建我的用户页面',
	'translate-fs-userpage-done' => '很好！现在你有了一个用户页面。',
	'translate-fs-permissions-planguage' => '主要语言：',
	'translate-fs-permissions-help' => '现在，您需要请求参加翻译组。
请选择您想参入翻译的首选语言。

您可以在以下的文本框之内提及其他语言及其他备注。',
	'translate-fs-permissions-pending' => '您的请求已提交至[[$1]]，站点管理员会尽快查阅您的请求。
如果您已验证您的电子邮箱，那么这个请求有答复后就会给您发送邮件。',
	'translate-fs-permissions-submit' => '发送请求',
	'translate-fs-target-text' => '恭喜 ！
您现在可以开始翻译。

不要害怕如果仍然认为新的和令人困惑，你。
在 [[Project list|项目列表]] 有你可以贡献的翻译项目的概述。
的大多数项目有一个简短说明页"翻译此项目 \'"的链接，将带您到一个页面，其中列出了所有未翻译的消息。
[[Special:LanguageStats|current 翻译状态的一种语言]] 所有邮件组的列表也是可用。

是否你感觉到您需要了解更多，你开始翻译之前，你可以读，[[FAQ|Frequently 问问题]]。
不幸的是文档是过时的有时。
如果有什么，你认为你应该能够做到，但是不能找出如何，不要犹豫，请在 [[Support|帮助页]]。

您也可以联系同翻译人员在语言相同的语言的 [[Portal:$1|your 语言门户]] 的 [[Portal_talk:$1|talk 页]]。
如果已经这样 [[Special:Preferences|change 您的用户界面语言，您要翻译的语言]]，做以便 wiki 是能够为您显示最相关的链接。',
	'translate-fs-email-text' => '请在[[Special:Preferences|选项]]页面留下电子邮箱地址并进行验证。

这能让其他用户通过电子邮件联系你。
你也会收到至多每月一次的电子通讯。
如果你不想收到通讯，你可以在[[Special:Preferences|选项]]"页面的{{int:prefs-personal}}"标签选择停止接收。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Lauhenry
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'firststeps' => '第一步',
	'firststeps-desc' => '讓用戶開始維基翻譯的[[Special:FirstSteps|引導頁面]]',
	'translate-fs-pagetitle-done' => ' - 完成！',
	'translate-fs-pagetitle' => '入門指導 - $1',
	'translate-fs-signup-title' => '註冊',
	'translate-fs-settings-title' => '設定你的偏好',
	'translate-fs-userpage-title' => '建立您的使用者頁面',
	'translate-fs-permissions-title' => '請求翻譯者權限',
	'translate-fs-target-title' => '開始翻譯！',
	'translate-fs-email-title' => '確認您的電郵地址',
	'translate-fs-intro' => "歡迎來到 {{SITENAME}} 入門指導。
你會被指導如何成為一名翻譯者。
最後你將可以翻譯 {{SITENAME}} 裡所有計畫的''介面訊息''.",
	'translate-fs-userpage-submit' => '建立我的使用者頁面',
	'translate-fs-userpage-done' => '很好！現在你擁有了一個使用者頁面。',
	'translate-fs-target-text' => '恭喜 ！
您現在可以開始翻譯。

如果你仍覺得不知所措，不要害怕。
在[[Project list|項目列表]] 有你可以貢獻的翻譯項目的概述。
大部分的項目有一個簡短的說明頁與“翻譯這個項目”鏈接，它將帶您到一個頁面，其中列出了所有未翻譯的消息。
 [[Special:LanguageStats|同一語言中所有未翻譯的訊息]]列表也是一個好起點。

如您開始翻譯前想了解更多，您可以去看一下[[FAQ|常見問題]]。
不幸的是文檔可能是舊版，如果你找不到答案，不要猶豫，請到[[Support|幫助頁]]發問。

您也可以在[[Portal:$1|語言門戶]] 的[[Portal_talk:$1|talk 頁]]聯繫相同語言的翻譯人員在。
請到[[Special:Preferences|偏好設定]]設定您的用戶界面和要翻譯的語言，以便wiki顯示和適合您的鏈接。',
	'translate-fs-email-text' => '請到[[Special:Preferences|偏好設定]]留下並確認您的電郵地址。
使其他譯者聯絡您，你亦可收取我們的每月電子報。

如您不想收到月刊，可以到[[Special:Preferences|偏好設定]]頁面的{{int:prefs-personal}}標籤選擇停止接收。',
);

