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

	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

In the first step you must sign up.

Credit for your translations is attributed to your user name.
The image on the right shows how to fill the fields.

If you have already signed up, $1log in$2 instead.
Once you are signed up, please return to this page.

$3Sign up$4',
	'translate-fs-settings-text' => 'You should now go to your preferences and
at least change your interface language to the language you are going to translate to.

Your interface language is used as the default target language.
It is easy to forget to change the language to the correct one, so setting it now is highly recommended.

While you are there, you can also request the software to display translations in other languages you know.
This setting can be found under tab "{{int:prefs-editing}}".
Feel free to explore other settings, too.

Go to your [[Special:Preferences|preferences page]] now and then return to this page.',
	'translate-fs-settings-skip' => "I'm done.
Let me proceed.",
	'translate-fs-userpage-text' => 'Now you need to create an user page.

Please write something about yourself; who you are and what you do.
This will help the {{SITENAME}} community to work together.
At {{SITENAME}} there are people from all around the world working on different languages and projects.

In the prefilled box above in the very first line you see <nowiki>{{#babel:en-2}}</nowiki>.
Please complete it with your language knowledge.
The number after the language code describes how well you know the language.
The alternatives are:
* 1 - a little
* 2 - basic knowledge
* 3 - good knowledge
* 4 - native speaker level
* 5 - you use the language professionally, for example you are a professional translator.

If you are a native speaker of a language, leave the skill level out, and only use the language code.
Example: if you speak Tamil natively, English well, and little Swahili, you would write:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

If you do not know the language code of a language, now is a good time to look it up.
You can use the list below.',
	'translate-fs-userpage-submit' => 'Create my userpage',
	'translate-fs-userpage-done' => 'Well done! You now have an user page.',
	'translate-fs-permissions-text' => 'Now you need to place a request to be added to the translator group.

Until we fix the code, please go to [[Project:Translator]] and follow the instructions.
Then come back to this page.

After you have submitted your request, one of the volunteer staff members will check your request and approve it as soon as possible.
Please be patient.

<del>Check that the following request is correctly filled and then press the request button.</del>',

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
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'translate-fs-signup-title' => '{{Identical|Sign up}}',
	'translate-fs-signup-text' => 'The parameters represent the start and end of an HTML link.',
	'translate-fs-userpage-text' => 'You may replace "Tamil" (ta) and "Swahili" (sw) with languages that people from your language are more likely to speak.',
	'translate-fs-permissions-text' => 'Synonym for "filed" is "submitted".',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = array(
	'firststeps' => 'الخطوات الأولى',
	'translate-fs-pagetitle-done' => '- تمّ!',
	'translate-fs-signup-title' => 'سجّل',
	'translate-fs-settings-title' => 'اضبط تفضيلاتك',
	'translate-fs-userpage-title' => 'أنشئ صفحة المستخدم',
	'translate-fs-permissions-title' => 'اطلب صلاحيات مترجم',
	'translate-fs-target-title' => 'ابدأ الترجمة!',
	'translate-fs-email-title' => 'أكّد عنوان بريدك الإلكتروني',
	'translate-fs-userpage-submit' => 'أنشئ صفحة المستخدم',
	'translate-fs-userpage-done' => 'أحسنت! لديك الآن صفحة مستخدم.',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]
Башта һеҙгә теркәлергә кәрәк.

Тәржемәләрегеҙҙең авторы тип һеҙҙең иҫәп яҙмаһы исеме күрһәтеләсәк.
Уң яҡтағы рәсем юлдарҙы нисек тултырырға кәрәклеген күрһәтә.

Әгәр һеҙ теркәлгәнһегеҙ икән, бының урынына $1танылығыҙ$2.
Теркәлеүҙән һуң ошо биткә ҡайтығыҙ, зинһар.

$3Теркәлергә$4',
	'translate-fs-settings-text' => 'Хәҙер һеҙгә көйләүҙәр битенә күсергә һәм интерфейс телен ниндәй телгә тәржемә итергә теләйһегеҙ, шул биткә үҙгәртергә кәрәк.

Һеҙҙең интерфейс теле тәржемә өсөн ғәҙәттәге  тел булараҡ ҡулланыласаҡ.
Телде дөрөҫ телгә алыштырырға онотоу бик еңел,  шуға күрә уны хәҙер көйләү бик мөһим.

Көйләү битендә булған саҡта, һеҙ шулай уҡ үҙегеҙ белгән бүтән телдәргә тәржемәләр күрһәтеүҙе көйләй алаһығыҙ.
Был мөмкинлекте "{{int:prefs-editing}}" бүлегендә таба алаһығыҙ.
Һеҙ шулай уҡ бүтән көйләүҙәрҙе ҡарап сыға алаһығыҙ.

Хәҙер үҙегеҙҙең [[Special:Preferences|көйләүҙәр битенә]] күсегеҙ, шунан ошо биткә кире ҡайтығыҙ.',
	'translate-fs-settings-skip' => 'Әҙер. Артабан.',
	'translate-fs-userpage-text' => 'Хәҙер һеҙгә үҙегеҙҙең ҡатнашыусы битен булдырырға кәрәк.

Үҙегеҙ тураһында берәй нимә яҙығыҙ, зинһар; кем һеҙ һәм нимә менән шөғөлләнәһегеҙ.
Бел {{SITENAME}} берләшмәһенә бергәләп эшләргә ярҙам итәсәк.
{{SITENAME}} проектында бөтә донъя кешеләре төрлө телдәр һәм проекттар менән эшләргә йыйыла.

Өҫтәге алдан тултырылған формала <nowiki>{{#babel:en-2}}</nowiki> күрәһегеҙ.
Ошо блокты үҙегеҙҙең телдәрҙе белеүегеҙгә ярашлы тултырығыҙ.
Тел коды номеры һеҙ был телде ни тиклем белеүегеҙҙе күрһәтә.
Мөмкин булған һандар:
* 1 — башланғыс дәрәжәлә
* 2 — урта дәрәжәлә
* 3 — һәйбәт дәрәжәлә
* 4 — туған теле дәрәжәһендә 
* 5 — профессиональ дәрәжәлә (мәҫәлән, әгәр һеҙ  профессиональ тәржемәсе булһағыҙ).

Әгәр теге йәки был тел һеҙҙең туған телегеҙ булһа, һан менән дефисты юйығыҙ һәм тел кодын ғына ҡалдырығыҙ.
Мәҫәлән, әгәр тамил теле һеҙҙең туған телегеҙ булһа, шулай уҡ һеҙ инглиз телен яҡшы белһәгеҙ һәм суахили телен бер аҙ белһәгеҙ, һеҙгә түбәндәгесә яҙырға кәрәк:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Әгәр һеҙ тел кодын белмәһәгеҙ, хәҙер белеү өсөн бик уңайлы ваҡыт. Һеҙ түбәндәге исемлекте ҡуллана алаһығыҙ.',
	'translate-fs-userpage-submit' => 'Минең ҡатнашыусы битен булдырырға',
	'translate-fs-userpage-done' => 'Бик яҡшы! Хәҙер һеҙҙең ҡатнашыусы битегеҙ бар.',
	'translate-fs-permissions-text' => 'Хәҙер һеҙгә тәржемәселәр төркөмөнә ҡушылыу өсөн һорау ҡуйырға кәрәк.

Беҙ кодты төҙәткәнгә тиклем, зинһар, [[Project:Translator]] битенә күсегеҙ һәм күрһәтмәлә яҙылғанса эшләгеҙ.
Һуңынан ошо биткә ҡайтығыҙ.

Һеҙ һорау ҡуйғандан һуң, сайт  волонтерҙарының береһе уны мөмкин тиклем тиҙерәк тикшерәсәк һәм раҫлаясаҡ.
Зинһар, түҙемле булығыҙ.

<del>Түбәндәге һорау дөрөҫ тултырылған булыуын тикшерегеҙ һәм ебәреү төймәһенә баҫығыҙ. </del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Спачатку Вам неабходна зарэгістравацца.

Аўтарства Вашых перакладаў будзе прыпісвацца Вашаму рахунку.
Выява справа паказвае, як запаўняць палі.

Калі Вы ўжо зарэгістраваныя, то замест$1 увайдзіце як$2.
Пасьля рэгістрацыі, калі ласка, вярніцеся на гэтую старонку.

$3Зарэгістравацца$4',
	'translate-fs-settings-text' => 'Цяпер Вам неабходна перайсьці ў налады і
зьмяніць мову інтэрфэйсу на мову, на якую Вы зьбіраецеся перакладаць.

Мова Вашага інтэрфэйсу будзе выкарыстоўвацца, як мова перакладу па змоўчваньні.
Вельмі лёгка забыцца зьмяніць мову, таму настойліва рэкамэндуем зьмяніць яе зараз.

Пакуль Вы там, Вы можаце ўключыць паказ перакладаў на іншых мовах, якія Вы ведаеце.
Гэтая налада знаходзіцца ў закладцы «{{int:prefs-editing}}».
Таксама, Вы можаце паспрабаваць іншыя налады.

Перайдзіце на Вашую [[Special:Preferences|старонку наладаў]], а потым вярніцеся на гэтую старонку.',
	'translate-fs-settings-skip' => 'Я ўсё выканаў.
Перайсьці далей.',
	'translate-fs-userpage-text' => 'Цяпер Вам неабходна стварыць старонку ўдзельніка.

Калі ласка, напішыце што-небудзь пра сябе; хто Вы і чым займаецеся.
Гэта дапаможа супольнасьці {{GRAMMAR:родны|{{SITENAME}}}} працаваць разам.
У {{GRAMMAR:месны|{{SITENAME}}}} ёсьць людзі з усяго сьвету, якія працуюць на розных мовах і ў розных праектах.

У папярэдне запоўненай форме наверсе, на самым першым радку Вы бачыце <nowiki>{{#babel:en-2}}</nowiki>.
Калі ласка, запоўніце яго, у адпаведнасьці з Вашымі ведамі мовы.
Лічба пасьля коду мовы паказвае як добра Вы валодаеце мовай.
Варыянтамі зьяўляюцца:
* 1 - крыху
* 2 - базавыя веды
* 3 - добрыя веды
* 4 - родная мова
* 5 - Вы карыстаецеся мовай прафэсійна, напрыклад, Вы — прафэсійны перакладчык.

Калі гэтая мова зьяўляецца Вашай роднай, то не стаўце лічбу ўзроўню валоданьня, а пакіньце толькі код мовы.
Напрыклад: калі Вашай роднай мовай зьяўляецца тамільская, ангельскую Вы ведаеце добра, і крыху ведаеце свахілі, Вам неабходна напісаць: <code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Калі Вы ня ведаеце код мовы, то зараз Вы можаце яго даведацца. Вы можаце паглядзець сьпіс пададзены ніжэй.',
	'translate-fs-userpage-submit' => 'Стварыць маю старонку ўдзельніка',
	'translate-fs-userpage-done' => 'Выдатна! Цяпер Вы маеце старонку ўдзельніка.',
	'translate-fs-permissions-text' => 'Вам неабходна падаць запыт на даданьне да групы перакладчыкаў.

Пакуль мы выправім код, калі ласка, перайдзіце на [[Project:Translator]] і выконвайце інструкцыі. Потым вярніцеся на гэтую старонку.

Пасьля таго, як Вы падалі запыт, адзін з добраахвотнікаў каманды падтрымкі праверыць і зацьвердзіць яго як мага хутчэй.
Калі ласка, майце цярпеньне.

<del>Праверце, каб наступны запыт быў запоўнены дакладна, а потым націсьніце кнопку адпраўкі.</del>',
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
	'translate-fs-signup-text' => "[[Image:HowToStart1CreateAccount.png|framm]]

Evit ar bazenn gentañ e rankez kevreañ.

An troidigezhioù graet ganeoc'h a vo laket war ho kont, dre hoc'h anv implijer.
Diskouez a ra ar skeudenn a-zehou penaos leuniañ ar maeziennoù.

M'emaoc'h enskrivet dija, hoc'h eus da $1gevreañ$2 kentoc'h.
Ur wezh enskrivet, distroit d'ar bajenn-mañ.

$3En em enskrivañ$4",
	'translate-fs-settings-text' => "Dleout a rafec'h mont da welet ho penndibaboù ha
da nebeutañ lakaat da yezh an etrefas ar yezh emaoc'h o vont da reiñ enni.

Lakaet e vez yezh hoc'h etrefas da yezh treiñ dre ziouer.
Aes eo disoñjal lakaat ar yezh a zere, setu eo kenkoulz en ober diouzhtu.

E-keit ha m'emaoc'h ganti e c'hallit ivez goulenn digant ar meziant diskouez an troidigezhioù e yezhoù all anavezet ganeoc'h.
Emañ an arventenn-se en ivinell \"{{int:prefs-editing}}\".
Taolit ur sell ouzh an arventennoù all ma karit ivez.

Kit d'ho [[Special:Preferences|pajenn penndibaboù]] diouzhtu ha distroit d'ar bajenn-mañ goude-se.",
	'translate-fs-settings-skip' => "Echuet eo ganin.
Lezit ac'hanon da genderc'hel.",
	'translate-fs-userpage-text' => "Bremañ hoc'h eus da sevel ho pajenn implijer.

Merkit un dra bennak diwar ho penn ; piv oc'h ha petra a rit da skouer.
Sikour a raio tud kumuniezh {{SITENAME}} da genlabourat ganeoc'h.
E {{SITENAME}} ez eus tud eus ar bed-holl a labour war raktresoù disheñvel e yezhoù disheñvel.

Er voest rakleuniet a-us, el linenn gentañ diouzhtu e welit <nowiki>{{#babel:en-2}}</nowiki>.
Klokait anezhi diouzh ho parregezhioù yezh.
Merkañ a ra an niver goude kod ar yezh pegen mat e komzit yezh pe yezh.
Setu a c'haller dibab :
* 1 - Un tammig bihan
* 2 - Un anaoudegezh diazez
* 3 - Un anaoudegezh vat
* 4 - Live unan a gomz a-vihanik
* 5 - Implijout a rit ar yezh en un doare micherel, da kouer ma'z oc'h troer a-vicher.

Ma komzit ur yezh a-vihanik, lezit al live barregezh disifr ha merkit hepken ar c'hod yezh.
Da skouer : ma komzit brezhineg a-vihanik, galleg evel m'eo dleet, ma tistripit un tamm saozneg ha m'hoc'h eus tamm anaoudegezh eus ar swahileg, e c'hallot skrivañ :
<code><nowiki>{{#babel:br|fr-3|en-2|sw-1}}</nowiki></code>

Ma n'anavezit ket kod yezh ar yezhoù a rit ganto eo deuet ar mare da glask anezho.
Implijout a roll a-is a c'hallit.",
	'translate-fs-userpage-submit' => 'Krouiñ ma fajenn implijer',
	'translate-fs-userpage-done' => "Dispar ! Ur bajenn implijer hoc'h eus bremañ.",
	'translate-fs-permissions-text' => "Ret eo deoc'h goulenn bezañ enskrivet d'ar strollad troerien.

Da c'hortoz ma vo kempennet ar c'hod ganeomp, kit da welet war [[Project:Translator]] ha heuilhit an erbedadennoù.
Goude-se, distroit d'ar bajenn-mañ.

Pa vo bet lakaet ho koulenn ez aio unan eus hor skipailh a-youl vat da wiriañ anezhañ hag e vo aprouet kerkent ha ma vo tu.
Un tamm pasianted mar plij.

<del>Gwiriit mat eo leuniet prop ar goulenn-mañ ha klikit war ar bouton goulenn.</del>",
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

U prvom koraku se morate prijaviti.

Zasluge za vaš prevod će biti dodijeljene vašem korisničkom imenu.
Slika s desne strane pokazuje kako se popunjavaju polja.

Ako ste već registrirani, $1prijavite se$2.
Jednom kad ste registrirani, vratite se na ovu stranicu.

$3Registracija$4',
	'translate-fs-settings-text' => 'Sada bi ste trebali otići na vaše postavke i
barem promijeniti vaš jezik interfejsa na jezik na kojem ćete prevoditi.

Vaš jezik interfejsa se koristi kao osnovni ciljni jezik.
Veoma je lahko zaboraviti prebaciti jezik na pravi, tako da je preporučljivo da se to odmah postavi.

Dok ste na postavkama, također možete postaviti softver za prikaz prevoda na drugim jezicima koje poznajete.
Ova postavka se može naći na jezičku "{{int:prefs-editing}}".
Slobodno istraživajte i druge postavke.

Idite na [[Special:Preferences|stranicu postavki]] sad i zatim se vratite na ovu stranicu.',
	'translate-fs-settings-skip' => 'Završio sam.
Želim nastaviti.',
	'translate-fs-userpage-text' => 'Sada je potrebno da napravite korisničku stranicu.

Molimo napišite nešto o sebi; ko ste i šta radite.
To će pomoći zajednici oko {{SITENAME}} da radimo zajedno.
Na {{SITENAME}} rade ljudi iz svih dijelova svijeta na različitim jezicima i projektima.

U popunjenom polju iznad na prvoj liniji možete vidjeti <nowiki>{{#babel:en-2}}</nowiki>.
Molimo dovršite sa jezicima koje vi poznajete.
Broj poslije jezičkog koda opisuje koliko dobro poznajete taj jezik.
Mogućnosti su:
* 1 - vrlo slabo
* 2 - osnovno znanje
* 3 - dobro znanje
* 4 - nivo blizu maternjeg jezika
* 5 - koristite jezik profesionalno, npr. vi ste profesionalni prevodioc.

Ako vam je taj jezik maternji, ostavite broj nivoa prazan i koristite samo jezički kod.
Naprimjer: ako vam je bosanski maternji jezik, dobro poznajete engleski i vrlo malo svahili jezik, napišite slijedeće:
<code><nowiki>{{#babel:bs|en-3|sw-1}}</nowiki></code>

Ako ne znate tačan jezički kod jezika, sada je vrijeme da ga potražite.
Možete koristiti spisak ispod.',
	'translate-fs-userpage-submit' => 'Napravi moju korisničku stranicu',
	'translate-fs-userpage-done' => 'Odlično urađeno! Sada imate korisničku stranicu.',
	'translate-fs-permissions-text' => 'Sada trebate da podnesete zahtjev da vas dodaju u grupu prevodioca.

Dok ne popravimo kod, molimo idite na [[Project:Translator]] i slijedite uputstva.
Zatim se vratite na ovu stranicu.

Nakon što ste podnijeli zahtjev, jedan od članova našeg volonterskog osoblja će provjeriti vaš zahtjev i odobriti ga kad se steknu uslovi za to.
Molimo da budete strpljivi.

<del>Provjerite da je slijedeći zahtjev pravilno ispunjen i zatim pritisnite dugme za zahtjev.</del>',
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
	'translate-fs-settings-skip' => 'He acabat.
Deixeu-me procedir.',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'firststeps' => 'První kroky',
	'firststeps-desc' => '[[Special:FirstSteps|Speciální stránka]] pomáhající uživatelům začít pracovat na wiki s rozšířením Translate',
	'translate-fs-pagetitle-done' => ' – hotovo!',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Nejprve se budete muset zaregistrovat.

Autorství překladu je připisováno pod vaším uživatelským jménem.
Obrázek vpravo ukazuje, jak vyplnit všechny položky.

Pokud jste se již zaregistrovali, stačí se $1přihlásit$2.
Po registraci se vraťte na tuto stránku.

$3Zaregistrovat se$4',
	'translate-fs-settings-text' => 'Teď byste měli jít do svého nastavení a přinejmenším si přepnout jazyk rozhraní na jazyk, do kterého se chystáte překládat.

Váš jazyk rozhraní se používá jako implicitní cílový jazyk.
Snadno se zapomene na jeho změnu na ten správný, proto důrazně doporučujeme nastavit si ho teď.

Dokud tam budete, můžete si také nastavit, aby vám software ukazoval překlady v dalších jazycích, které ovládáte.
Toto nastavení najdete na záložce „{{int:prefs-editing}}“.
Klidně se rozhlédněte i po dalších možnostech.

Teď jděte do [[Special:Preferences|svého uživatelského nastavení]] a pak se sem vraťte.',
	'translate-fs-settings-skip' => 'Hotovo.
Nechte mě pokračovat.',
	'translate-fs-userpage-text' => 'Teď je potřeba, abyste si {{gender:|založil|založila|založili}} uživatelskou stránku.

Napište tam něco o sobě; kdo jste a co děláte.
To pomůže komunitě {{grammar:2sg|{{SITENAME}}}} spolupracovat.
Na {{grammar:6sg|{{SITENAME}}}} lidé z celého světa pracují na mnoha jazycích a projektech.

V předvyplněném poli nahoře hned na prvním řádku vidíte <nowiki>{{#babel:en-2}}</nowiki>.
Doplňte tam své jazykové znalosti.
Číslo po kódu jazyka popisuje, jak dobře jazyk znáte.
Možnosti jsou:
* 1 – trochu,
* 2 – základní znalosti,
* 3 – dobré znalosti,
* 4 – téměř úroveň rodilého mluvčího,
* 5 – pokud jazyk užíváte profesionálně, například jste profesionální překladatel.

Pokud jste rodilým mluvčím nějakého jazyka, úroveň vynechte a napište jen kód.
Příklad: Pokud jste rodilým mluvčím češtiny, umíte dobře anglicky a trochu německy, napište:
<code><nowiki>{{#babel:cs|en-3|de-1}}</nowiki></code>

Pokud neznáte kód nějakého jazyka, je teď nejlepší chvíle si ho najít.
Můžete použít seznam níže.',
	'translate-fs-userpage-submit' => 'Založit mou uživatelskou stránku',
	'translate-fs-userpage-done' => 'Výtečně! Teď máte svou uživatelskou stránku.',
	'translate-fs-permissions-text' => "Nyní si musíte požádat, abyste {{gender:|byl přidán|byla přidána|byli přidáni}} do uživatelské skupiny ''překladatelé''.

Dokud neopravíme program, je potřeba jít na [[Project:Translator]] a následovat instrukce.
Pak se vraťte na tuto stránku.

Poté, co vložíte svou žádost, některý z dobrovolníků žádost zkontroluje a schválí ji, co nejdříve to bude možné.
Mějte prosím trpělivost.

<del>Zkontrolujte, že je následující žádost správně vyplněna, a klikněte na tlačítko.</del>",
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
 */
$messages['da'] = array(
	'firststeps' => 'De første skridt',
	'firststeps-desc' => '[[Special:FirstSteps|Special side]] for at få brugerne i gang med et wiki der bruger Oversæt udvidelsen',
	'translate-fs-pagetitle-done' => '- færdig!',
	'translate-fs-pagetitle' => 'Kom godt i gang guiden - $1',
	'translate-fs-signup-title' => 'Opret en konto',
	'translate-fs-settings-title' => 'Konfigurer dine indstillinger',
	'translate-fs-userpage-title' => 'Opret din brugerside',
	'translate-fs-permissions-title' => 'Anmodning om oversætter tilladelse',
	'translate-fs-target-title' => 'Start med at oversætte!',
	'translate-fs-email-title' => 'Bekræft din e-mail-adresse',
	'translate-fs-intro' => "Velkommen til {{SITENAME}} kom godt i gang guide.
Du vil blive guidet igennem processen med til at blive en oversætter trin for trin. 
I sidste ende vil du være i stand til at oversætte ''brugerflade beskeder'' hos alle støttede projekter på {{SITENAME}}.",
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

I det første trin skal du tilmelde dig. 

Æren for dine oversættelser er tilskrevet dit brugernavn. 
Billedet til højre viser, hvordan du udfylde felterne. 

Hvis du allerede har tilmeldt dig, $1log ind$2 i stedet. 
Når du er tilmeldt, skal du vende tilbage til denne side. 

$3Tilmeld$4',
	'translate-fs-settings-text' => 'Du bør nu gå til dine indstillinger og 
mindst ændre dit brugerflade sprog til det sprog, du vil oversætte til. 

Dit brugerflade sprog bruges som standard målsproget. 
Det er nemt at glemme at ændre sproget til det rigtige, så at indstille det nu kan varmt anbefales. 

Mens du er der, kan du også anmode softwaren om at vise oversættelser på andre sprog du kender. 
Denne indstilling kan findes under fanebladet "{{int:prefs-editing}}". 
Du er velkommen til også at udforske andre indstillinger. 

Gå til din [[Special:Preferences|indstillinger side]] nu og vend derefter tilbage til denne side.',
	'translate-fs-settings-skip' => 'Jeg er færdig. 
Lad mig fortsætte.',
	'translate-fs-userpage-text' => 'Nu skal du oprette en bruger side.

Skriv venligst noget om dig selv, hvem du er og hvad du gør.
Dette vil hjælpe {{SITENAME}} samfundet til at arbejde sammen.
På {{SITENAME}} er der folk fra hele verden der arbejder på forskellige sprog og projekter.

I den forudfyldte boks ovenfor i allerførste linje, ser du <nowiki>{{#babel:en-2}}</nowiki> .
Udfyld venligst det med din sprogkundskaber.
Tallet efter sprogkoden beskriver, hvor godt du kender sproget.
Alternativerne er: 
* 1 - en lille smule
* 2 - grundlæggende kendskab
* 3 - godt kendskab
* 4 - modersmål niveau
* 5 - du bruger sproget professionelt, du er for eksempel er en professionel oversætter.

Hvis et sprog er dit modersmål, skal du undlade færdighedsniveaet, og kun bruge sprogkoden.
Eksempel: Hvis du har tamilsk som modersmål, taler godt engelsk, og lidt swahili, ville du skrive:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Hvis du ikke kender sprog koden for et sprog, så er nu et godt tidspunkt at slå det op.
Du kan bruge listen nedenfor.',
	'translate-fs-userpage-submit' => 'Opret min brugerside',
	'translate-fs-userpage-done' => 'Godt gået! Du har nu en bruger side.',
	'translate-fs-permissions-text' => 'Nu skal du lave en anmodning om at blive tilføjet til oversætteren gruppen.

Indtil vi løser koden, kan du gå til [[Project:Translator]] og følge vejledningen.
Kom så tilbage til denne side.

Når du har sendt din anmodning, vil en af de frivillige medarbejdere tjekke din anmodning og godkende den så hurtigt som muligt.
Vær tålmodig.

<del>Kontroller at følgende anmodning er udfyldt korrekt, og tryk derefter på anmodning knappen.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Als erstes musst du dir ein Benutzerkonto anlegen.

Dein Benutzername wird in den Autorenlisten deiner Übersetzungen genannt.
Das Bild rechts zeigt, wie du die Felder ausfüllen musst.

Wenn du dich bereits registriert hast, $1logge dich stattdessen ein$2.
Wenn du eingeloggt bist, kehre auf diese Seite zurück.

$3Benutzerkonto anlegen$4',
	'translate-fs-settings-text' => 'Gehe nun zu deinen Einstellungen und ändere zumindest deine Oberflächensprache in die Sprache, die du übersetzen wirst.

Deine Oberflächensprache wird als deine Standardsprache benutzt.
Man vergisst leicht, die Sprache in die Richtige zu verändern, daher ist es empfohlen, dies sofort zu tun.

Wenn du dabei bist, kannst du die Software auch bitten, Übersetzungen in anderen Sprachen anzuzeigen, die du kennst.
Diese Einstellung findest du unter dem Tab „{{int:prefs-editing}}“.
Guck dir auch ruhig die anderen Einstellungsmöglichkeiten an.

Gehe jetzt in deine [[Special:Preferences|Einstellungen]] und kehre dann auf diese Seite zurück.',
	'translate-fs-settings-skip' => 'Fertig.
Nächster Schritt.',
	'translate-fs-userpage-text' => 'Jetzt musst du eine Benutzerseite erstellen.

Bitte schreibe etwas über dich, wer du bist und was du machst.
Dies hilft der {{SITENAME}}-Gemeinschaft bei der Zusammenarbeit.
Auf {{SITENAME}} gibt es Leute aus der ganzen Welt, die an verschiedenen Sprachen und Projekten arbeiten.

In der ausgefüllten Box oben siehst du in der ersten Zeile <nowiki>{{#babel:en-2}}</nowiki>.
Bitte fülle es mit deinen Sprachkenntnissen aus.
Die Zahl hinter dem Sprachcode beschreibt wie gut du die Sprache kannst.
Die Möglichkeiten sind:
*1 - ein bisschen
*2 - Basiswissen
*3 - fließend
*4 - nahezu Muttersprachler
*5 - professionell, z.B. wenn du ein professioneller Übersetzer bist.

Wenn du ein Muttersprachler bist, lasse die Zahl aus und benutze nur den Sprachcode.
Beispiel: Wenn du Deutsch als Muttersprache, Englisch gut und ein wenig Französisch sprechen, könntest du Folgendes schreiben:
<code><nowiki>{{#babel:de|en-3|fr-1}}</nowiki></code>

Wenn du den Sprachcode einer Sprache nicht kennst, dann guck ihn jetzt nach.
Du kannst die Liste unten benutzen.',
	'translate-fs-userpage-submit' => 'Benutzerseite erstellen',
	'translate-fs-userpage-done' => 'Gut gemacht! Du hast nun eine Benutzerseite',
	'translate-fs-permissions-text' => 'Jetzt musst du einen Antrag stellen, um zur Übersetzergruppe hinzugefügt zu werden.

Bis wir den Code korrigieren, gehe auf [[Project:Translator]] und folge den Anweisungen.
Kehre danach zurück auf diese Seite.

Nachdem du den Antrag abgeschickt hast, wird ein freiwilliger Mitarbeiter deinen Antrag prüfen und ihn so bald wie möglich akzeptieren.
Bitte habe dabei etwas Geduld.

<del>Stelle sicher, dass der folgende Antrag korrekt ausgefüllt ist und drücke dann den Button.</del>',
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
 * @author Purodha
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'translate-fs-settings-title' => 'Ihre Einstellungen anpassen',
	'translate-fs-userpage-title' => 'Ihre Benutzerseite erstellen',
	'translate-fs-email-title' => 'Ihre E-Mail-Adresse bestätigen',
	'translate-fs-intro' => "Willkommen bei dem {{SITENAME}}-Startassistenten.
Ihnen wird gezeigt, wie Sie Schritt für Schritt ein Übersetzer werden.
Am Ende werden Sie alle ''Oberflächen-Nachrichten'' der von {{SITENAME}} unterstützten Projekte übersetzen können.",
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Als erstes müssen Sie sich ein Benutzerkonto anlegen.

Ihr Benutzername wird in den Autorenlisten Ihrer Übersetzungen genannt.
Das Bild rechts zeigt, wie Sie die Felder ausfüllen müssen.

Wenn Sie sich bereits registriert haben, $1loggen Sie sich stattdessen ein$2.
Wenn Sie eingeloggt sind, kehren Sie auf diese Seite zurück.

$3Benutzerkonto anlegen$4',
	'translate-fs-settings-text' => 'Gehen Sie nun zu Ihren Einstellungen und ändern Sie zumindest Ihre Oberflächensprache in die Sprache, die Sie übersetzen werden.

Ihre Oberflächensprache wird als Standardsprache benutzt.
Man vergisst leicht, die Sprache in die Richtige zu verändern, daher ist es empfohlen, dies sofort zu tun.

Wenn Sie dabei sind, können Sie die Software auch bitten, Übersetzungen in anderen Sprachen anzuzeigen, die Sie kennen.
Diese Einstellung finden Sie unter dem Tab „{{int:prefs-editing}}“.
Gucken Sie sich auch ruhig die anderen Einstellungsmöglichkeiten an.

Gehen Sie jetzt in Ihre [[Special:Preferences|Einstellungen]] und kehren Sie dann auf diese Seite zurück.',
	'translate-fs-userpage-text' => 'Jetzt müssen Sie eine Benutzerseite erstellen.

Bitte schreiben Sie etwas über sich, wer Sie sind und was Sie machen.
Dies hilft der {{SITENAME}}-Gemeinschaft bei der Zusammenarbeit.
Auf {{SITENAME}} gibt es Leute aus der ganzen Welt, die an verschiedenen Sprachen und Projekten arbeiten.

In der ausgefüllten Box oben sehen Sie in der ersten Zeile <nowiki>{{#babel:en-2}}</nowiki>.
Bitte füllen Sie es mit Ihren Sprachkenntnissen aus.
Die Zahl hinter dem Sprachcode beschreibt wie gut Sie die Sprache kennen.
Die Möglichkeiten sind:
*1 - ein bisschen
*2 - Basiswissen
*3 - fließend
*4 - nahezu Muttersprachler
*5 - professionell, z.B. wenn Sie ein professioneller Übersetzer sind.

Wenn Sie ein Muttersprachler sind, lassen Sie die Zahl aus und benutzen Sie nur den Sprachcode.
Beispiel: Wenn Sie Deutsch als Muttersprache, Englisch gut und ein wenig Französisch sprechen, könnten Sie Folgendes schreiben:
<code><nowiki>{{#babel:de|en-3|fr-1}}</nowiki></code>

Wenn Sie den Sprachcode einer Sprache nicht kennen, dann gucken Sie ihn jetzt nach.
Sie können die Liste unten benutzen.',
	'translate-fs-userpage-done' => 'Gut gemacht! Sie haben nun eine Benutzerseite',
	'translate-fs-permissions-text' => 'Jetzt müssen Sie einen Antrag stellen, um zur Übersetzergruppe hinzugefügt zu werden.

Bis wir den Code korrigieren, gehe auf [[Project:Translator]] und folgen Sie den Anweisungen.
Kehren Sie danach zurück auf diese Seite.

Nachdem Sie den Antrag abgeschickt haben, wird ein freiwilliger Mitarbeiter Ihren Antrag prüfen und ihn so bald wie möglich akzeptieren.
Bitte haben Sie dabei etwas Geduld.

<del>Stellen Sie sicher, dass der folgende Antrag korrekt ausgefüllt ist und drücken Sie dann den Button.</del>',
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
	'translate-fs-settings-skip' => 'Som gótowy.
Dalej.',
	'translate-fs-userpage-submit' => 'Mój wužywarski bok napóraś',
	'translate-fs-userpage-done' => 'Derje cynił! Maš něnto wužywarski bok.',
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
 * @author Yekrats
 */
$messages['eo'] = array(
	'translate-fs-pagetitle-done' => '- farita!',
	'translate-fs-target-title' => 'Ek traduku!',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Diego Grez
 * @author Drini
 * @author Tempestas
 */
$messages['es'] = array(
	'firststeps' => 'Primeros pasos',
	'firststeps-desc' => '[[Special:FirstSteps|Página especial]] para que los usuarios comiencen en un wiki usando la extensión de traducción',
	'translate-fs-pagetitle-done' => '- hecho!',
	'translate-fs-pagetitle' => 'Guía de inicio - $1',
	'translate-fs-signup-title' => 'Registrarse',
	'translate-fs-settings-title' => 'Configurar tus preferencias',
	'translate-fs-userpage-title' => 'Crear tu página de usuario',
	'translate-fs-permissions-title' => 'Solicitar permisos de traducción',
	'translate-fs-target-title' => 'Comenzar a traducir!',
	'translate-fs-email-title' => 'Confirmar tu dirección de correo electrónico',
	'translate-fs-intro' => "Bienvenido al asistente de los primeros pasos en {{SITENAME}}.
Serás guíado a través del proceso de convertirte en un traductor pasa a paso.
Al final serás capaz de traducir los ''mensajes de interfaz'' de todos los proyectos soportados en {{SITENAME}}",
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|marco]]

El primer paso es que debes registrarte.

Los créditos por tu traducción se atribuyen a tu nombre de usuario.
La imagen de la derecha muestra como llenar los campos.

Si ya te has registrado, $1inicia sesión$2 entonces.
Una vez que te has registrado, por favor regresa a esta página.

$3Registrarse$4',
	'translate-fs-settings-text' => 'Ahora debes ir a tus preferencias y
cambiar el idioma de la interfaz al idioma que quieres traducir.

El idioma de la interfaz es usado como el idioma a traducir por defecto.
Es fácil olvidarse de cambiar el idioma al correcto, por lo que configurarlo ahora es altamente recomendado.

Mientras estás aquí, puedes hacer que el software muestre traducciones en otros idiomas que conozcas.
Esta configuración se encuentra bajo la pestaña "{{int:prefs-editing}}".
Siéntete libre de explorar otras configuraciones también.

Ve a tu [[Special:Preferences|página de preferencias]] ahora y entonces puedes volver a esta página.',
	'translate-fs-settings-skip' => 'He terminado.
Déjenme continuar.',
	'translate-fs-userpage-text' => 'Ahora es necesario crear una página de usuario.
Por favor escribe algo sobre ti; Quién eres y qué haces.
Esto ayudará a la {{SITENAME}} comunidad para trabajar juntos.
En {{SITENAME}} hay gente de todo el mundo trabajando en distintos idiomas y proyectos.',
	'translate-fs-userpage-submit' => 'Crear mi página de usuario',
	'translate-fs-userpage-done' => 'Bien hecho! Ahora tienes una página de usuario.',
	'translate-fs-permissions-text' => 'Ahora necesitas colocar una solicitud para ser agregado al grupo de traductores.

Hasta que arreglemos el código, por favor ve a [[Project:Translator]] y sigue las instrucciones.

Después que hayas enviado tu solicitud, uno de los miembros del staff de voluntarios verificará tu solicitud y lo aprobará tan pronto como sea posible. Por favor se paciente.

<del>Verifica que la siguiente solicitud está correctamente llenada y luego presiona el botón de solicitud.</del>',
	'translate-fs-target-text' => 'Felicitaciones!
Puedes ahora comenzar a traducir.

No temas si lo sientes nuevo y confuso para ti.
En la [[Project list]] hay una visión general de los proyectos en los que puedes contribuir con traducciones.
La mayoría de los proyectos tiene una página de descripción corta con un enlace "\'\'Traducir este proyecto\'\'", que te llevará a una página que lista todos los mensajes sin traducir.
Una lista de todos los grupos de mensajes con el [[Special:LanguageStats|status de traducción actual para un idioma]] está también disponible.

Si sientes que necesitas entender más antes de empezar a traducir, puedes leer las [[FAQ|Preguntas frecuentes]].
Desafortunadamente la documentación puede estar desactualizada a veces.
Si hay algo que pienses que deberías ser capaz de hacer, pero no cómo, no dudes en preguntarlo en la [[Support|página de soporte]].

Puedes también contactar con otros traductores al mismo idioma en la [[Portal_talk:$1|página de discusión]] del [[Portal:$1|portal de tu idioma]].
El portal enlaza a tu [[Special:Preferences|preferencia de idioma]] actual.
Por favor cámbialo si es necesario.',
	'translate-fs-email-text' => 'Por favor brinda tu dirección de correo electrónico en [[Special:Preferences|tus preferencias]] y confírmalo desde el correo que se te envíe.

Esto permite a los otros usuarios contactarte por correo electrónico.
También recibirás boletines de noticias como máximo una vez al mes.
Si no deseas recibir boletines de noticias, puedes cancelarlas en la pestaña  "{{int:prefs-personal}}" de tus [[Special:Preferences|preferencias]].',
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
	'translate-fs-settings-skip' => 'Egina.
Aurrera jarraitu.',
	'translate-fs-userpage-submit' => 'Nire lankide orria sortu',
	'translate-fs-userpage-done' => 'Ondo egina! Orain lankide orrialdea duzu.',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Nike
 * @author ZeiP
 */
$messages['fi'] = array(
	'firststeps' => 'Alkutoimet',
	'firststeps-desc' => '[[Special:FirstSteps|Toimintosivu]] joka ohjastaa uudet käyttäjät Translate-laajennoksen käyttöön.',
	'translate-fs-pagetitle-done' => ' - valmis!',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Ensimmäinen askel on rekisteröityminen.

Käyttäjätunnuksesi näytetään käännösten yhteydessä.
Voit katsoa apua kenttien täyttämiseen oikealla olevasta kuvasta.

Jos olet jo rekisteröitynyt, $1kirjaudu sisään$2.
Palaa rekisteröitymisen jälkeen tälle sivulle.

$3Rekisteröidy$4',
	'translate-fs-settings-text' => 'Mene seuraavaksi asetussivulle.
Muuta käyttöliittymäkielesi kieleksi, jolle käännät.

Käyttöliittymäkieltäsi käytetään oletusarvoisena kohdekielenä.
Kielen asettaminen kannattaa tehdä jo nyt, koska sen valitseminen unohtuu helposti.

Samalla voit määritellä ne kielet, jotka haluat nähdä kääntämisen aikana.
Tämä asetus löytyy välilehdeltä {{int:prefs-editing}}.
Voit vapaasti kurkkia muitakin asetuksia.

Mene nyt [[Special:Preferences|asetussivulle]] ja palaa sitten tälle sivulle.',
	'translate-fs-settings-skip' => 'Olen valmis.
Haluan jatkaa.',
	'translate-fs-userpage-text' => 'Nyt on aika luoda oma käyttäjäsivusi.

Kirjoita jotain itsestäsi – kuka olet ja mitä teet.
Tämän tarkoituksena on edistää yhteisöllisyyttä.
{{GRAMMAR:inessive|{{SITENAME}}}} käyttäjät eri puolilta maailmaa työskentelevät eri kielten ja projektien parissa.

Ylläolevan tekstikentän ensimmäinen rivi on <nowiki>{{#babel:en-2}}</nowiki>.
Päivitä se vastaamaan kielitaitoasi.
Numero kielitunnuksen jälkeen kuvaa kielitaitoasi.
Vaihtoehdot:
* 1 — vähäinen
* 2 — perustiedot
* 3 — hyvät tiedot
* 4 — kuin syntyperäinen
* 5 — käytät kieltä ammattimaisesti – esimerkiksi olet kielenkääntäjä

Jos olet kielen synnynnäinen puhuja, jätä taitotaso pois ja käytä vain kielitunnusta.
Esimerkki: Jos olet tamilin synnynnäinen puhuja ja osaat englantia hyvin ja swahilia vähän, voit merkitä:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Jos et tiedä kielen kielitunnusta, nyt on hyvä aika etsiä se.
Voit käyttää allaolevaa listaa.',
	'translate-fs-userpage-submit' => 'Luo käyttäjäsivuni',
	'translate-fs-userpage-done' => 'Hyvin tehty! Sinulla on nyt käyttäjäsivu.',
	'translate-fs-permissions-text' => 'Nyt sinun tulee pyytää, että sinut lisätään kääntäjäryhmään.

Kunnes saamme koodin korjattua, mene sivulle [[Project:Translator]] ja seuraa ohjeita.
Palaa sitten tälle sivulle.

Kun olet tehnyt pyynnön, joku projektin ylläpitäjistä tarkistaa ja hyväksyy sen mahdollisimman pian.
Olethan kärsivällinen.',
	'translate-fs-target-text' => 'Onnittelut!
Voit nyt aloittaa kääntämisen.

Älä huolestu, vaikka et vielä täysin ymmärtäisi miten kaikki toimii.
Meillä on [[Project list|luettelo projekteista]], joiden kääntämiseen voit osallistua.
Useimmilla projekteilla on lyhyt kuvaussivu, jossa on "\'\'Käännä tämä projekti\'\'"-linkki varsinaiselle käännössivulle.
[[Special:LanguageStats|Kielen nykyisen käännöstilanteen]] näyttävä lista on myös saatavilla.

Jos haluat tietää lisää, voit lukea vaikkapa [[FAQ|usein kysyttyjä kysymyksiä]].
Valitettavasti dokumentaatio voi joskus olla hivenen vanhentunutta.
Jos et keksi, miten joku tarvitsemasi asia tehdään, älä epäröi pyytää apua [[Support|tukisivulla]].

Voit myös ottaa yhteyttä muihin saman kielen kääntäjiin [[Portal:$1|oman kielesi portaalin]] [[Portal_talk:$1|keskustelusivulla]].
Valikon portaalilinkki osoittaa [[Special:Preferences|valitsemasi kielen]] portaaliin.
Jos valitsemasi kieli on väärä, muuta se.',
	'translate-fs-email-text' => 'Anna sähköpostiosoitteesi [[Special:Preferences|asetuksissasi]] ja vahvista se sähköpostiviestistä, joka lähetetään sinulle. 

Tämä mahdollistaa muiden käyttäjien ottaa sinuun yhteyttä sähköpostitse. 
Saat myös uutiskirjeen korkeintaan kerran kuukaudessa. 
Jos et halua vastaanottaa uutiskirjeitä, voit valita sen pois välilehdellä "{{int:prefs-personal}}" omat [[Special:Preferences|asetukset]].',
);

/** French (Français)
 * @author Hashar
 * @author Peter17
 */
$messages['fr'] = array(
	'firststeps' => 'Premiers pas',
	'firststeps-desc' => '[[Special:FirstSteps|Page spéciale]] pour guider les utilisateurs sur un wiki utilisant l’extension Translate',
	'translate-fs-pagetitle-done' => ' - fait !',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|cadre]]

La première étape consiste à s’inscrire.

Les traductions que vous effectuerez seront créditées à votre nom d’utilisateur.
L’image sur la droite montre comment remplir les champs.

Si vous vous êtes déjà inscrit, veuillez $1vous identifier$2.
Une fois inscrit, veuillez revenir vers cette page.

$3Inscrivez-vous$4',
	'translate-fs-settings-text' => 'Vous devez à présent vous rendre dans vos préférences et au moins choisir comme langue d’interface celle dans laquelle vous voulez traduire.

La langue choisie pour l’interface est utilisée comme langue par défaut pour les traductions.
Il est facile d’oublier de changer cette préférence et donc hautement recommandé de le faire maintenant.

Tant que vous y êtes, vous pouvez aussi demander au logiciel d’afficher les traductions dans les autres langues que vous connaissez.
Cette préférence se trouve sous l’onglet « {{int:prefs-editing}} ».
N’hésitez pas à parcourir également les autres préférences.

Allez maintenant à votre [[Special:Preferences|page de préférences]] puis revenez à cette page.',
	'translate-fs-settings-skip' => 'J’ai fini. Laissez-moi continuer.',
	'translate-fs-userpage-text' => 'Vous devez maintenant créer une page utilisateur.

Veuillez écrire quelque chose à propos de vous : qui vous êtes et ce que vous faites.
Cela aidera la communauté de {{SITENAME}} à travailler ensemble.
Sur {{SITENAME}}, il y a des gens de tous les coins du monde qui travaillent sur différentes langues et projets.

Dans la boîte pré-remplie ci-dessous, dans la toute première ligne, vous voyez <nowiki>{{#babel:en-2}}</nowiki>.
Veuillez la compléter avec votre connaissance des langues.
Le nombre qui suit le code de la langue décrit comment vous maîtrisez cette langue.
Les valeurs possibles sont :
* 1 - un peu
* 2 - connaissances de base
* 3 - bonnes connaissances
* 4 - niveau bilingue
* 5 - vous utilisez cette langue de manière professionnelle, par exemple en tant que traducteur professionnel.

Pour votre langue maternelle, ignorez le niveau et n’utilisez que le code de la langue.
Exemple : si votre langue maternelle est le tamoul et que vous parlez bien l’anglais et un peu le swahili, écrivez :
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Si vous ne connaissez pas le code d’une langue donnée, vous pouvez le chercher maintenant dans la liste ci-dessous.',
	'translate-fs-userpage-submit' => 'Créer ma page utilisateur',
	'translate-fs-userpage-done' => 'Bien joué ! Vous avez à présent une page utilisateur.',
	'translate-fs-permissions-text' => 'Vous devez déposer une demande pour être ajouté au groupe des traducteurs.

Jusqu’à ce que nous ayons réparé le code, merci d’aller sur [[Project:Translator]] et de suivre les instructions.
Revenez ensuite à cette page.

Quand vous aurez déposé votre demande, un des membre de l’équipe de volontaires la vérifiera et l’approuvera dès que possible.
Merci d’être patient.

<del>Veuillez vérifier que la demande suivante est correctement remplie puis cliquez sur le bouton de demande.</del>',
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
	'translate-fs-userpage-title' => 'Féte voutra pâge utilisator',
	'translate-fs-permissions-title' => 'Demandâd les pèrmissions de traductor',
	'translate-fs-target-title' => 'Comenciéd a traduire !',
	'translate-fs-email-title' => 'Confirmâd voutra adrèce èlèctronica',
	'translate-fs-settings-skip' => 'J’é chavonâ.
Lèssiéd-mè continuar.',
	'translate-fs-userpage-submit' => 'Fâre ma pâge utilisator',
	'translate-fs-userpage-done' => 'Bien fêt ! Ora, vos avéd una pâge utilisator.',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'translate-fs-email-title' => 'Conferme la tô direzion email',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'firststeps' => 'Primeiros pasos',
	'firststeps-desc' => '[[Special:FirstSteps|Páxina especial]] para iniciar aos usuarios no uso da extensión Translate',
	'translate-fs-pagetitle-done' => '; feito!',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

No primeiro paso, cómpre que se rexistre.

As traducións que faga atribuiránselle ao seu nome de usuario.
A imaxe da dereita mostra como encher os campos.

Se xa se rexistrou, $1acceda ao sistema$2.
Unha vez que o faga, volva a esta páxina.

$3Rexístrese$4',
	'translate-fs-settings-text' => 'Agora ten que ir ás súas preferencias e
cambiar a lingua da interface pola lingua á que vai traducir as mensaxes.

A lingua da interface úsase como lingua por defecto para as traducións.
É doado esquecerse de cambiar a lingua, de xeito que definila agora é bastante recomendable.

De paso que vai ás preferencias, tamén pode solicitar que o software mostre as traducións noutras linguas que coñeza.
Esta configuración pódese atopar na lapela "{{int:prefs-editing}}".
Síntase libre de probar o resto de opcións tamén.

Vaia á [[Special:Preferences|páxina das súas preferencias]] e volva despois a esta páxina.',
	'translate-fs-settings-skip' => 'Listo.
Que vén agora?',
	'translate-fs-userpage-text' => 'Agora necesita crear unha páxina de usuario.

Escriba algo sobre si mesmo; quen é vostede e o que fai.
Isto axudará á comunidade de {{SITENAME}} a traballar xuntos.
En {{SITENAME}} hai xente de todo o mundo traballando en diferentes linguas e proxectos.

No cadro preenchido enriba na primeira liña pode ollar isto: <nowiki>{{#babel:en-2}}</nowiki>.
Compléteo cos seus coñecementos lingüísticos.
O número que vai despois do código da lingua describe o ben que a coñece.
As alternativas son:
* 1 - un pouco
* 2 - coñecemento básico
* 3 - bo coñecemento
* 4 - nivel de falante nativo
* 5 - usa a lingua profesionalmente, é dicir, é un tradutor profesional.

Se vostede é un falante nativo dunha lingua, ignore o nivel e use só o código de lingua.
Exemplo: se a súa lingua materna é o italiano, se fala o galego ben e o inglés un pouco, tería que escribir:
<code><nowiki>{{#babel:it|gl-3|en-1}}</nowiki></code>

Se non coñece o código de lingua dalgunha lingua, agora é un bo momento para descubrilo.
Pode empregar a lista que hai a continuación.',
	'translate-fs-userpage-submit' => 'Crear a miña páxina de usuario',
	'translate-fs-userpage-done' => 'Ben feito! Agora xa ten unha páxina de usuario.',
	'translate-fs-permissions-text' => 'Agora cómpre solicitar permisos para comezar a formar parte do grupo de tradutores.

Ata que arranxemos o código, vaia a [[Project:Translator]] e siga as instrucións.
A continuación, volva a esta páxina.

Despois de presentar a súa solicitude, un dos membros do equipo de voluntarios ha comprobar a súa petición e aprobala o máis axiña posible.
Por favor, sexa paciente.

<del>Asegúrese de que a seguinte solicitude está correctamente cuberta e prema o botón axeitado.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

As erschtes muesch dir e Benutzerkonto aalege.

Dyy Benutzername wird in dr Autorelischte fir Dyyni Ibersetzige gnännt.
S Bild rächts zeigt, wie Du d Fälder muesch uusfille.

Wänn Du di scho regischtriert hesch, $1mäld di statt däm aa$2.
Wänn Du aagmäldet bisch, chumm zruck uf die Syte.

$3Benutzerkonto aalege$4',
	'translate-fs-settings-text' => 'Gang jetz zue Dyyne Yystellige un tue zerscht Dyy Oberflechesproch uf d Sproch ändere, wu Du ibersetze tuesch.

Dyy Oberflechesproch wird as Dyy Standardsproch brucht.
Mer vergisst lyycht, d Sproch in di Richtig z ändere, wäge däm wir dempfohle, des sofort z mache.

Wänn Du draa bisch, chasch au d Software au aafroge, Ibersetzige in andere Sproche aazzeige, wu Du chänsch.
Die Yystellig findsch unter em Tab „{{int:prefs-editing}}“.
Lueg dir au rueig di andere Yystelligsmegligkeiten aa.

Gang jetz in Dyyni [[Special:Preferences|Yystellige]] un chumm derno zruck uf die Syte.',
	'translate-fs-settings-skip' => 'Fertig.
Negschte Schritt.',
	'translate-fs-userpage-text' => 'Jetz muesch Dyyni Benutzersyte aalege.

Bitte schryyb ebis iber di, wär Du bisch un was du machsch.
Des hilft dr {{SITENAME}}-Gmeinschaft bi dr Zämmearbet.
Uf {{SITENAME}} git s Lyt us dr ganze Wält, wu an verschidene Sproche un Projäkt schaffe.

Im uusgfillte Chäschtli obe sihsch in dr erschte Zyyle <nowiki>{{#babel:en-2}}</nowiki>.
Bitte fill e uus mit Dyyne Sprochchänntnis.
D Zahl hinter em Sprochcode bschrybt, wie guet Du die Sproch chasch.
D Megligkeite sin:
*1 - e bitzeli
*2 - Grundchänntnis
*3 - seli guet
*4 - fascht wie ne Muetsprochler
*5 - professionäll, z.B. wänn e professionälle Ibersetzer bisch.

Wänn Du ne Muetersprochler bisch, no loss d Zahl ewäg un nimm nume dr Sprochcode.
Byyschpel: Wänn Du Alemannisch as Muetersproch, Änglisch guet un e weng Swahili chasch, no chennscht des schryybe:
<code><nowiki>{{#babel:gsw|en-3|sw-1}}</nowiki></code>

Wänn Du dr Sprochcode vun ere Sproch nit chännsch, no lueg e jetz no.
Du chasch d Lischte unter bruche.',
	'translate-fs-userpage-submit' => 'Myy Benutzersyte aalege',
	'translate-fs-userpage-done' => 'Guet gmacht! Du hesch jetz e Benutzersyte',
	'translate-fs-permissions-text' => 'Jetz muesch e Aatrag stelle, ass Du zue dr Ibersetzergruppe zuegfiegt wirsch.

Bis mir dr Code korrigiere, gang uf [[Project:Translator]] un gang dr Aawyysysige no.
Chumm derno zruck uf die Syte.

Wänn Du dr Aatrag abgschickt hesch, wird e frejwillige Mitarbeiter Dyy Aatrag priefe un e so schnäll wie megli akzeptiere.
Bitte haa do ne weng Geduld.

<del>Stell sicher, ass dää Aatrag korräkt uusgfillt isch, un druck derno dr Chnopf.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

I ka mea mua, pono e kāinoa.

Inā loaʻa nā uhuhi, e kau ʻia nā hōʻaiʻē ma muli hoʻi o kau inoa kapakapa.
Hōʻike ke kiʻi ma ka ʻaoʻao ʻākau i ka hana ʻana i nā kahua like ʻole.

Inā ua kāinoa ʻia, $1ʻEʻe$2 i loko.
Ma hope o kou kāinoa ʻana, hoʻi mai i kēia ʻaoʻao.

$3Kāinoa$4',
	'translate-fs-settings-text' => 'Pono e hele i kau makemake a hoʻololi i kau ʻōlelo aloloko i ka ʻōlelo āu e uhuhi ana.

ʻO kau ʻōlelo aloloko ka ʻōlelo paʻamau.
Hiki ke poina e hoʻololi i ka ʻōlelo i ka ʻōlelo pololei, no laila, e hana i kēia manawa.

I kou noho ʻana i laila, hiki ke noi i ka polokalamu e hōʻike i nā uhuhi ma nā ʻōlelo ʻē aʻe āu e ʻike ai.
Hiki ke loaʻa ka makemake i loko o ka kāwāholo "{{int:prefs-editing}}".
E ʻike i nā makemake ʻē aʻe, inā makemake.

Hele i kau [[Special:Preferences|ʻaoʻao makemake]] i kēia manawa a laila hoʻi i kēia ʻaoʻao ma hope',
	'translate-fs-settings-skip' => 'Ua pau ka hana.
Neʻe i mua.',
	'translate-fs-userpage-text' => 'Pono e hana i kekahi ʻaoʻao mea hoʻohana i kēia manawa.

E ʻoluʻolu e kākau e pili ana iā ʻoe; ʻo wai ʻoe? a me he aha kau e hana ai?
Hiki kēia ke kōkua i ke kaiāulu {{SITENAME}} e laulima.
Ma {{SITENAME}}, aia nā poʻe he nui mai ʻō a ʻō ka hōnua e hana nei ma nā ʻōlelo a me nā papa hana ʻokoʻa.

I loko o ka pahu i hoʻopiha ma mua, aia kekahi laina āu e ʻika ana: <nowiki>{{#babel:en-2}}</nowiki>.
E ʻoluʻolu e hana me kau ʻike ʻōlelo.
Hōʻike ʻano ka helu ma hope i ka ʻike o ka ʻōlelo kau e ʻike ai.
Nā koho:
* 1 - liʻiliʻi
* 2 - ʻikena kumu
* 3 - ʻikena maikaʻi
* 4 - ʻōlelo like nā mānaleo
* 5 - Hana ʻoe i ka ʻōlelo no ka ʻoihana

Inā he mānaleo ʻoe, kāpae ka mākau and hana ke pāʻālua ʻōlelo wale nō.
Lāʻana: Inā mānaleo ʻoe me ka ʻōlelo Kepanī, ʻōlelo maikaʻi ka ʻōlelo Pelekānia a ʻōlelo liʻi ka ʻōlelo Kōlea, e kākau:
<code><nowiki>{{#babel:ja|en-3|ko-1}}</nowiki></code>

Inā ʻaʻole maopopo ka pāʻālua ʻōlelo o kekahi ʻōlelo, pono e ʻimi.
Hiki ke hana i ka helu i lalo.',
	'translate-fs-userpage-submit' => 'Hana i kaʻu ʻaoʻao mea hoʻohana',
	'translate-fs-userpage-done' => 'Maikaʻi! Loaʻa ka ʻaoʻao mea hoʻohana i kēia manawa.',
	'translate-fs-permissions-text' => 'Pono e kau i kekahi noi no ka hoʻohui ʻana i ka hui unuhi.

A hiki i ka hoʻopololei ʻana i ka pāʻālua, e ʻoluʻolu, e hele i [[Project:Translator]] a hahai i nā aʻona.
A laila hoʻi i kēia ʻaoʻao.

Ma hope o ka hoʻouna ʻana o ka noina, e ʻike ana ʻia ka noina e kekahi poʻe hana ʻaʻa a ʻae.
E hoʻomanawanui ke ʻoluʻolu',
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
	'translate-fs-pagetitle-done' => '- בוצע!',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

בשלב הראשון עליכם להירשם.

קרדיט עבור התרגומים שלכם מיוחס לשם המשתמש שלכם.
התמונה בצד ימין מראה כיצד למלא את השדות.

אם כבר נרשמתם, $1היכנסו לחשבון$2.
אחרי שתירשמו, אנא חִזרו לדף זה.

$3הרשמה$4',
	'translate-fs-settings-text' => 'כעת נא לעבור להעדפות שלכם
ולכל הפחות שנו את שפת הממשק לשפה שאתם עומדים לתרגם.

שפת הממשק משמשת שפת היעד לפי בררת המחדל.
קל לשכוח להגדיר את השפה הנכונה, ולכן מומלץ מאוד להגדירה כעת.

כאשר תהיו שם, תוכלו לבקש שהתוכנה תציג תרגומים בשפות אחרות שאתם יודעים.
ניתן למצוא הגדרה זו תחת הלשונית "{{int:prefs-editing}}".
אל תהססו להכיר גם הגדרות אחרות.

לכו ל[[Special:Preferences|דף ההעדפות]] עכשיו ואחר־כך חזרו לדף הזה.',
	'translate-fs-settings-skip' => 'סיימתי. 
תנו לי להמשיך.',
	'translate-fs-userpage-text' => 'כעת עליכם ליצור דף משתמש.

נא לכתוב משהו על עצמכם – מי אתם ומה אתם עושים.
פעולה זו תסייע לקהילת {{SITENAME}} לעבוד אִתכם.
באתר {{SITENAME}} ישנם אנשים מכל רחבי העולם שעובדים בשפות שונות והפרויקטים שונים.

בתיבת העריכה הממולאת מראש בשורה הראשונה כתוב <nowiki>{{#babel:en-2}}</nowiki>.
נא להשלים אותה בהתאם לידיעותיכם בשפות.
המספר לאחר קוד השפה מתאר כמה אתם יודעים את השפה.
האפשרויות הן:
* 1 - קצת
* 2 - ידע של מתחיל
* 3 - ידע טוב
* 4 - רמת דובר ילידי
* 5 - ידע ברמה מקצועית, למשל אם אתם עובדים בתרגום.

אל תרשמו שום מספר בקוד של שפת האם שלכם.
למשל: אם שפת אמכם היא עברית ובנוסף לכך אתם יודעים טוב אנגלית וגם קצת סוואהילי יש לכתוב:
<code><nowiki>{{#babel:he|en-3|sw-1}}</nowiki></code>

אם אינכם יודעים את קוד השפה שלכם, זה זמן טוב לחפש אותו.
באפשרותכם להשתמש ברשימה שלהלן.',
	'translate-fs-userpage-submit' => 'יצירת דף המשתמש שלי',
	'translate-fs-userpage-done' => 'מצוין! כעת יש לך דף משתמש.',
	'translate-fs-permissions-text' => 'כעת עליכם להוסיף בקשה להוסיף אתכם לקבוצת מתרגמים.

עד שנתקן את הקוד של האתר, יש ללכת לדף [[Project:Translator]] ולבצע את ההוראות שם.
לאחר מכן חִזרו לדף זה.

לאחר שתשלחו את בקשתכם, אחד מחברי צוות המתנדבים יבדוק את בקשתכם ויאשר אותה בהקדם האפשרי.
אנא המתינו בסבלנות.

<del>בִדקו כי הבקשה הבאה מולאה כהלכה ולאחר מכן הקישו על לחצן הבקשה.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

W prěnim kroku dyrbiš so registrować, t. r. wužiwarske konto wutworić.

Přełožki, kotrež sy sčinił, budu so twojemu wužiwarskemu mjenu připokazować.
Wobraz naprawo ći pokazuje, kak dyrbiš pola wupjelnić.

Jeli sy hižo zregistrowany, $1přizjew so$2 město toho.
Hdyž sy zregistrowany, wróć so k tutej stronje.

$3Registrować$4',
	'translate-fs-settings-text' => 'Dźi nětko do swojich nastajenjow a změń znajmjeńša swoju powjerchowu rěc do rěče, do kotrejež chceš přełožić.

Twoja powjerchowa rěč wužiwa so jako standardna cilowa rěč.
Zabywa so lochko, rěč do praweje rěče změnić, tohodla so jara poručuje, ju nětko nastajić.

Hdyž sy jónu tu, móžeš tež softwaru prosyć, přełožki tež w druhich rěčach zwobraznić, kotrež rozumiš.
Tute nastajenje namakaš pod rajtarkom "{{int:prefs-editing}}".
Wobhladaj sej woměrje tež druhe nastajenja.

Dźi nětko k swojej [[Special:Preferences|stronje nastajenjow]] a wróć so potom k tutej stronje.',
	'translate-fs-settings-skip' => 'Sym hotowy.
Daj mi pokročować.',
	'translate-fs-userpage-text' => 'Nětko dyrbiš wužiwarsku stronu wutworić.

Prošu napisaj něšto wo sebi; štó sy a što činiš.
To budźe zhromadźenstwu {{SITENAME}} při zhromadnym dźěle pomhać.
Na {{SITENAME}} su ludźo z cyłeho swěta, kotřiž na rozdźělnych rěčach a projektach dźěłaja.

We wupjelnjenym kašćiku horjeka w prěnjej lince, widźiš <nowiki>{{#babel:en-2}}</nowiki>.
Prošu wudospołń jón přez twoje rěčne znajomosće.
Ličba za rěčnym kodom wopisuje, kak derje znaješ rěč.
Móžnosće su:
* 1 - trochu
* 2 - zakładne znajomosće
* 3 - dobre znajomosće
* 4 - niwow maćernorěčneho rěčnika
* 5 - wužiwaš rěč profesionelnje, na přikład twoje powołanje je přełožowar.

Jeli sy maćernorěčny rěčnik rěče, wuwostaj ličbu za rěčnym kodom a wužij jenož rěčny kod.
Přikład: jeli tamilšćina je twoja maćeršćina, jendźelšćinu derje a swahilšćinu trochu rozumiš, by pisał:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Jeli njeznaješ rěčny kod rěče, pohladaj nětko za nim.
Móžeš slědowacu lisćinu za to wužiwać.',
	'translate-fs-userpage-submit' => 'Moju wužiwarsku stronu wutworić',
	'translate-fs-userpage-done' => 'Gratulacija! Maš nětko wužiwarsku stronu.',
	'translate-fs-permissions-text' => 'Nětko dyrbiš wo přiwzaće do skupiny přełožowarjow prosyć.

Doniž kod njekorigujemy, dźi na stronu [[Project:Translator]] a slěduj instrukcije. Wróć so potom na tutu stronu.

Po tym zo sy swoje požadanje wotpósłał, budźe jedyn z dobrowólnych čłonow teama twoje požadanje kontrolować a jo tak bórze kaž móžno schwalić.
Prošu budź sćerpliwy.

<del>Skontroluj, hač slědowace požadanje je korektnje wupjelnjene a klikń potom na tłóčatko.</del>',
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

To dowola druhim wužiwarjam, so z tobu přez e-mejl do zwisk stajić.
Dóstanješ tež powěsćowe listy, zwjetša jónkróć wob měsać.
Jeli nochceš powěsćowe listy dóstać, móžeš tutu opciju na rajtarku "{{int:prefs-personal}}" swojich [[Special:Preferences|preferencow]] znjemóžnić.',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|kad]]

Nan premye etap, ou dwe kreye yon kont.

Tout tradiksyon ou fè ap tonbe sou kont ou.
Imaj ki sou bò dwat montre ki jan pou ou ranpli chan yo.

Si ou te gentan kreye kont ou deja, tanpri $1konekte ou$2.
Apre ou fin konekte, tanpri tounen nan paj sa a.

$3Kreye yon kont$4',
	'translate-fs-settings-text' => 'Kounye a, alel nan preferans ou yo epi
omwens chanje lang entèfas ou an pou lang vè ki sa w ap tradui.

Lang entèfas ou an sèvi pa defo kòm lang sib.
Li fasil pou ou bliye chanje lang pou sa ki bon, kidonk fè sa tousuit.

Toutpandan ou la, ou mèt mande pou logisyèl montre tradiksyon nan lòt lang ou konn pale tou.
Ou ka jwenn preferans sa anbe onglè "{{int:prefs-editing}}".

Ou kapab gade lòt preferans tou.

Ale nan [[Special:Preferences|paj preferans]] ou kounye a epi tounen nan paj sa a.',
	'translate-fs-settings-skip' => 'Mwen fini.
Kite m kontinye.',
	'translate-fs-userpage-text' => 'Kounye a, ou bezwen kreye yon paj itilizatè. 

Tanpri ekri yon bagay sou tèt ou; ki moun ou ye epi kisa ou fè. 
Sa pral ede kominote {{SITENAME}} pou yo travay ansanm. 
Nan {{SITENAME}} gen moun ki soti nan lemonnantye k ap travay sou diferan lang ak pwojè. 

Nan bwat ki deja ranpli anwo a, nan premye liy la ou wè <nowiki>{{#babel:en-2}}</nowiki> . 
Tanpri, ranpli li ak lang ou konnen yo. 
Nimewo ki vin apre kòd lang la dekri nan ki nivo ou konnen lang nan. 
Men chwa yo: 
 * 1 - yon ti kras 
 * 2 - konesans debaz 
 * 3 - bon konesans 
 * 4 - menm ak natif natal 
 * 5 - ou itilize lang nan yon nivo pwofesyonèl, pa egzanp ou se yon tradiktè pwofesyonèl. 

Si ou natif natal nan yon lang, pa sèvi ak nivo konpetans, epi itilize sèlman kòd lang la. 
Egzanp: Si se natif natal tamil ou pale, angle byen, epi ti swahili, ou ta ekri: 
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Si ou pa konnen kòd pou yon lang, kounye a se yon bon moman pou ou jwenn li. 
Ou ka itilize lis ki anba a.',
	'translate-fs-userpage-submit' => 'Kreye paj itilizatè mwen',
	'translate-fs-userpage-done' => 'Byen fè!  Kounye a ou gen yon paj itilizatè.',
	'translate-fs-permissions-text' => 'Kounye a, ou bezwen fè yon demann pou ou ajoute nan gwoup tradiktè yo.

Jiskaske nou ranje kòd la, tanpri ale nan [[Project:Translator]] epi swiv enstriksyon yo. 
Apre sa, tounen nan paj sa a.

Apre ou finn soumèt demann ou an, youn nan manm pèsonèl volontè yo ap verifye demann ou an pou l aprouve l osito sa posib.
Tanpri pran pasyans.

<del>Verifye ke demann sa te byen ranpli epi klike sou bouton pou fè demann ou an.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Első lépés a regisztráció.

A fordításaid a te felhasználónevedhez lesznek kötve.
A jobb oldalon található kép megmutatja, hogyan kell helyesen kitölteni a mezőket.

Ha már korábban regisztráltál, inkább $1jelentkezz be$2.
Ha megtörtént a regisztráció, látogass vissza erre a lapra.

$3Regisztráció$4',
	'translate-fs-settings-text' => 'Most menj a beállításaidhoz, és ha mást nem is,
de állítsd át a felület nyelvét arra, amire fordítani fogsz.

A felület nyelve lesz az alapértelmezett célnyelv.
Könnyű elfelejteni a helyes nyelvre váltást, így erősen ajánlott a módosítás.

Míg ott vagy, beállíthatod, hogy a szoftver más olyan nyelveken is megjelenítse a fordításokat, melyeket ismersz.
Ez a beállítás a „{{int:prefs-editing}}” fülön található.
Ezeken kívül további beállításokat is kipróbálhatsz.

Menj a [[Special:Preferences|beállításaidhoz]], majd térj vissza erre a lapra.',
	'translate-fs-settings-skip' => 'Végeztem.
Szeretném folytatni.',
	'translate-fs-userpage-text' => 'Most létre kell hoznod egy felhasználói lapot!

Írj valamit magadról: ki vagy és mit csinálsz.
Ez elősegíti a {{SITENAME}} közösség közös munkáját.
A {{SITENAME}}-en a világ minden tájáról végeznek szerkesztéseket különböző nyelven és projekteken.

A fenti, előre kitöltött dobozban az első sorban ezt látod: <nowiki>{{#babel:en-2}}</nowiki>.
Egészítsd ki a nyelvtudásoddal.
A nyelv utáni szám leírja, hogy milyen tudással rendelkezel az adott nyelvből.
A lehetőségek:
* 1 – minimális
* 2 – alaptudás
* 3 – jó tudás
* 4 – anyanyelvi szinten
* 5 – a nyelvet hivatásszerűen használod, például hivatásos fordító vagy.

Ha a nyelv anyanyelved, akkor hagyd ki a tudásszintet, és csak a nyelvkódot írd be.
Például ha magyar az anyanyelved, jól beszélsz angolul és még egy kicsit németül, akkor a következőt írd:
<code><nowiki>{{#babel:hu|en-3|de-1}}</nowiki></code>

Ha nem tudod egy nyelv kódját, itt az ideje, hogy megkeresd.
Az alábbi listát használhatod hozzá.',
	'translate-fs-userpage-submit' => 'Felhasználói lap létrehozása',
	'translate-fs-userpage-done' => 'Felhasználói lap létrehozva.',
	'translate-fs-permissions-text' => 'Most kérned kell, hogy a fordítói csoportba kerülhess.

Amíg nem javítjuk ki a kódot, menj a [[Project:Translator]] lapra, és kövesd az ott megjelenő információkat, majd gyere vissza erre a lapra.

Miután elküldted a kérésedet, a személyzet egyik önkéntes tagja ellenőrzi a kérésedet, és elfogadja, amilyen gyorsan lehetséges
Légy türelmes.

<del>Ellenőrizd, hogy az alábbi kérelem megfelelően ki van-e töltve, majd kattints a Kérelem elküldése gombra.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount-ia.png|frame]]

In le prime passo tu debe crear un conto.

Le traductiones que tu facera essera attribuite a tu nomine de usator.
Le imagine al dextra demonstra como completar le formulario.

Si tu possede jam un conto in le sito, $1aperi un session$2.
Quando tu ha create un conto, per favor retorna a iste pagina.

$3Crear un conto$4',
	'translate-fs-settings-text' => 'Tu deberea ora visitar tu preferentias e,
al minus, cambiar le lingua de interfacie al lingua in le qual tu vole traducer.

Tu lingua de interfacie es usate automaticamente como lingua in le qual traducer.
Il es facile oblidar de cambiar al lingua correcte, dunque il es altemente recommendate de facer lo ora.

Intertanto, tu pote etiam demandar que le software presenta traductiones existente in altere linguas que tu cognosce.
Iste preferentia se trova sub le scheda "{{int:prefs-editing}}".
Sia libere de explorar etiam le altere preferentias.

Visita ora tu [[Special:Preferences|pagina de preferentias]] e postea retorna a iste pagina.',
	'translate-fs-settings-skip' => 'Io ha finite. Lassa me continuar.',
	'translate-fs-userpage-text' => 'Ora, tu debe crear un pagina de usator.

Per favor scribe alique super te; qui tu es e lo que tu face.
Isto adjutara le communitate de {{SITENAME}} a collaborar.
In {{SITENAME}} il ha personas de tote le mundo laborante a diverse linguas e projectos.

In le quadro precompletate hic supra, in le primissime linea, tu vide <nowiki>{{#babel:en-2}}</nowiki>.
Per favor completa isto con tu cognoscentia linguistic.
Le numero post le codice de lingua describe tu nivello de maestria del lingua.
Le optiones es:
* 1 - un poco
* 2 - cognoscentia de base
* 3 - bon cognoscentia
* 4 - nivello de parlante native
* 5 - tu usa le lingua professionalmente, per exemplo tu es traductor professional.

Si tu es un parlante native de un lingua, omitte le nivello de cognoscentia, usante solmente le codice de lingua.
Per exemplo: si tu parla tamil nativemente, anglese ben, e un poco de swahili, tu scriberea:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Si tu non cognosce le codice de un lingua, ora es un bon tempore pro cercar lo. Tu pote usar le lista hic infra.',
	'translate-fs-userpage-submit' => 'Crear mi pagina de usator',
	'translate-fs-userpage-done' => 'Ben facite! Tu ha ora un pagina de usator.',
	'translate-fs-permissions-text' => 'Ora, tu debe facer un requesta pro esser addite al gruppo de traductores.

Nos non ha ancora automatisate isto; pro le momento, per favor visita [[Project:Translator]] e seque le instructiones.
Postea, retorna a iste pagina.

Post que tu ha submittite tu requesta, un del membros del personal voluntari verificara tu requesta e lo approbara si tosto como possibile.
Per favor sia patiente.

<del>Verifica que le sequente requesta es correcte e complete, postea clicca super le button de requesta.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Pada tahap pertama Anda harus mendaftar.

Kredit terjemahan Anda berupa nama pengguna Anda.
Gambar di kanan menunjukkan cara mengisi kotak.

Jika Anda sudah mendaftar, silakan $1masuk log$2.
Setelah Anda mendaftar, silakan kembali ke halaman ini.

$3Daftar$4',
	'translate-fs-settings-text' => 'Silakan tuju ke preferensi Anda dan
setidaknya ubah bahasa antarmuka Anda ke bahasa terjemahan Anda.

Bahasa antarmuka Anda digunakan sebagai bahasa tujuan baku.
Hal ini mudah dilupakan untuk mengubah bahasa ke bahasa yang benar, jadi dianjurkan apabila pengaturan dilakukan sekarang.

Ketika Anda berada di sana, Anda juga dapat meminta perangkat lunak untuk menampilkan terjemahan dalam bahasa lain yang Anda tahu.
Pengaturan ini dapat ditemukan di bawah tab "{{int:prefs-editing}}".
Jangan ragu untuk menjelajahi pengaturan lainnya juga.

Tuju ke [[Special:Preferences|halaman preferensi]] sekarang dan kemudian kembali ke halaman ini.',
	'translate-fs-settings-skip' => 'Saya sudah selesai.
Izinkan saya melanjutkan.',
	'translate-fs-userpage-text' => 'Sekarang Anda perlu membuat halaman pengguna.

Silakan tulis tentang diri Anda; siapa Anda dan apa pekerjaan Anda.
Ini akan membantu komunitas {{SITENAME}} untuk bekerjasama.
Di {{SITENAME}} ada banyak orang dari seluruh dunia yang bekerja dalam berbagai bahasa dan proyek.

Pada kotak isian awal di atas, tepatnya kalimat pertama, Anda melihat <nowiki>{{#babel:en-2}}</nowiki>.
Silakan isi dengan pengetahuan bahasa Anda.
Angka setelah kode bahasa menjelaskan sejauh mana Anda mengenal bahasa ini.
Alternatifnya ialah:
* 1 - sedikit
* 2 - pengetahuan dasar
* 3 - pengetahuan baik
* 4 - setingkat penutur asli
* 5 - Anda menuturkannya secara profesional, misalnya Anda adalah penerjemah profesional.

Jika Anda seorang penutur asli suatu bahasa, kosongkan tingkat kemampuan, dan gunakan kode bahasa saja.
Misal: Anda penutur asli bahasa Tamil, dapat berbahasa Inggris dengan baik, dan sedikit bahasa Swahili, Anda dapat menuliskan:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Jika Anda tidak mengetahui kode bahasa dari suatu bahasa, saatnya untuk mencari tahu.
Anda dapat menggunakan daftar di bawah.',
	'translate-fs-userpage-submit' => 'Buat halaman pengguna saya',
	'translate-fs-userpage-done' => 'Bagus! Sekarang Anda memiliki halaman pengguna.',
	'translate-fs-permissions-text' => 'Sekarang Anda perlu memberikan permintaan yang akan ditambahkan ke grup penerjemah.

Hingga kami memerbaiki kode, silakan kunjungi [[Project:Translator]] dan ikuti petunjuknya.
Kemudian kembali ke halaman ini.

Setelah Anda mengirim permintaan Anda, satu dari anggota staf relawan akan memeriksa dan menyetujui permintaan Anda sesegera mungkin.
Harap bersabar.

<del>Periksa apabila permintaan tersebut diisi dengan benar dan kemudian tekan tombol minta.</del>',
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

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'firststeps' => '開始手順',
	'firststeps-desc' => 'Translate 拡張機能を使用するウィキで利用者が開始準備をするための[[Special:FirstSteps|特別ページ]]',
	'translate-fs-pagetitle-done' => ' - 完了！',
	'translate-fs-pagetitle' => '開始準備ウィザード - $1',
	'translate-fs-signup-title' => '利用者登録',
	'translate-fs-settings-title' => '個人設定の設定',
	'translate-fs-userpage-title' => 'あなたの利用者ページを作成',
	'translate-fs-permissions-title' => '翻訳者権限の申請',
	'translate-fs-target-title' => '翻訳を始めましょう！',
	'translate-fs-email-title' => '自分の電子メールアドレスの確認',
	'translate-fs-intro' => '{{SITENAME}} 開始準備ウィザードへようこそ。これから翻訳者になるための手順について1つずつ案内していきます。それらを終えると、あなたは {{SITENAME}} でサポートしているすべてのプロジェクトのインターフェイスメッセージを翻訳できるようになります。',
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

手順の初めは利用者登録を済ませることです。

あなたが為した翻訳にはあなたの利用者名がクレジットとして付記されます。右の画像ではフォームの各欄をどのように埋めるのかを示しています。

既に登録が済んでいる場合は、代わりに$1ログイン$2してください。登録がまだの場合は、登録を済ませてからこのページに戻ってきてください。

$3登録$4',
	'translate-fs-settings-text' => '個人設定に移動し、まずインターフェイス言語をあなたが作業しようとしている翻訳先の言語に変更してください。

あなたのインターフェイス言語は既定の翻訳先言語として使われます。この言語を正しいものに変更する作業は忘れがちであるため、今それを行うことを強く勧めます。

またさらに、あなたが知っている他の言語での訳文も表示するよう設定することができます。その設定は「{{int:prefs-editing}}」タブの下にあります。他の設定について探ってみるのもよいでしょう。

[[Special:Preferences|個人設定ページ]]に移動し、終わったらこのページに戻ってきてください。',
	'translate-fs-settings-skip' => '終わったので次に進みます。',
	'translate-fs-userpage-text' => '次に、あなたの利用者ページを作成する必要があります。

自身について、あなたが何者で何をしているのかなど、なにかを書いてください。これは {{SITENAME}} のコミュニティーで共同作業を行う助けとなります。{{SITENAME}} には世界中から異なる言語やプロジェクトで作業を行っている人々が集まっています。

上の入力済みのボックスのちょうど1行目に <nowiki>{{#babel:en-2}}</nowiki> とあるのを確認してください。それをあなたの言語に関する知識を書いて完成させます。言語コードの後に続く数字は、その言語をあなたがどれだけ理解できるか伝えるものです。以下が選択肢です:
* 1 - 少し
* 2 - 基礎的な知識
* 3 - 十分な知識
* 4 - 母語話者の水準
* 5 - プロの翻訳家であるなど、その言語を職業的に使用している

あなたがその言語のまさに母語話者である場合、理解度を表す数字の部分は消して、言語コードのみを書きます。例えば、あなたが母語としてタミル語を話し、英語をうまく、スワヒリ語を少し話す場合は、次のようになります:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

言語コードがわからない場合は、いい機会ですので調べてみましょう。下記の一覧を参考にしてください。',
	'translate-fs-userpage-submit' => '自分の利用者ページを作成',
	'translate-fs-userpage-done' => 'お疲れ様です。あなたの利用者ページができました。',
	'translate-fs-permissions-text' => '次に、翻訳者グループに追加してもらうよう申請を出す必要があります。

新しい仕組みが完成するまでは、[[Project:Translator]] に移動してそこにある指示に従っていただくことになっています。終わったらこのページに戻ってきてください。

申請が提出されると、できる限り速やかにボランティアスタッフの誰かがあなたの申請を審査し承認いたします。この間しばらくお待ちください。

<del>以下の申請が正しく入力されているか確認し、それから申請ボタンを押してください。</del>',
	'translate-fs-target-text' => "お疲れ様でした！あなたが翻訳を開始する準備が整いました。

まだ慣れないことや分かりにくいことがあっても、心配することはありません。[[Project list|プロジェクト一覧]]にあなたが翻訳を行うことのできる各プロジェクトの概要があります。ほとんどのプロジェクトには短い解説ページがあり、「'''Translate this project'''」というリンクからそのプロジェクトの未翻訳メッセージをすべて一覧できるページに移動できます。すべてのメッセージグループに関して[[Special:LanguageStats|各言語別に現在の翻訳状況]]を一覧することもできます。

翻訳を始める前にもっと知らなければならないことがあると感じられたならば、[[FAQ]] のページを読むのもよいでしょう。残念なことにドキュメントの中には更新が途絶えてしまっているものもあります。もし、なにかやりたいことがあって、それをどうやって行えばよいのかわからない場合には、遠慮せず[[Support|サポートページ]]にて質問してください。

また、同じ言語で作業している仲間の翻訳者とは[[Portal:$1|言語別のポータル]]の[[Portal_talk:$1|トークページ]]で連絡することができます。
まだ設定されていなければ、[[Special:Preferences|インターフェースの言語を、翻訳先としたい言語に変更]]すれば、ウィキ上では最も関連性のあるリンクが表示されます。",
	'translate-fs-email-text' => 'あなたの電子メールアドレスを[[Special:Preferences|個人設定]]で入力し、送られてきたメールからそのメールアドレスの確認を行ってください。

これにより、他の利用者があなたに電子メールを通じて連絡できるようになります。また、多くて月に1回ほどニュースレターが送られてきます。ニュースレターを受け取りたくない場合は、[[Special:Preferences|個人設定]]の「{{int:prefs-personal}}」タブで受信の中止を設定できます。',
);

/** Jamaican Creole English (Jamaican Creole English)
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|friem]]

Ina di fos tep yu fi sain op.

Kredit fi yu chranslieshan achribiut tu yu yuuza niem.
Di imij pahn di rait shuo ou fi fulop di fiildem.

Ef yu sain op aredi, $1lag iin$2 insted.
Wans yu sain op, begyu kumbak a dis piej.

$3Sain op$4',
	'translate-fs-settings-text' => 'Yu fi go nou tu yu prefransdem ahn akliis chienj yu intafies langwij tu di langwij yu a go chransliet tu.

Yu intafies langwij wi yuuz az di difaalt taagit langwij.
Ihiizi fi figat fi chienj dilangwij tu di karek wan, so wi aili rekomen yu fi seti nou.

Wails yu di de, yu kiahn alzwel rikwes di saafwier fi displie chranslieshan in ada langwij yu nuo.
Di setn kiahn fain anda di tab "{{int:prefs-editing}}".
Fiil frii fi expluor ada setn tu.

Go tu yu [[Special:Preferences|prefrans piej]] nou ahn den kumbak a dis piej.',
	'translate-fs-settings-skip' => 'Mi don.
Mek mi prosiid.',
	'translate-fs-userpage-submit' => 'Kriet mi yuuza piej',
	'translate-fs-userpage-done' => 'Yaa gwaan! Yu nou ab a yuuza piej.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'firststeps' => 'ជំហានដំបូង',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'firststeps' => 'Eetste Schredde',
	'firststeps-desc' => '[[Special:FirstSteps|Extra Sigg]] för Metmaacher op Wikis met däm Zohsazprojramm <i lang="en">Translate</i> aan et werke ze krijje.',
	'translate-fs-pagetitle-done' => ' - jedonn!',
	'translate-fs-pagetitle' => 'En de Jäng kumme - $1',
	'translate-fs-signup-title' => 'Aanmälde',
	'translate-fs-settings-title' => 'Enstellunge maache',
	'translate-fs-userpage-title' => 'Metmaachersigg aanlääje',
	'translate-fs-permissions-title' => 'Noh dem Rääsch als {{int:Group-translator-member}} froore',
	'translate-fs-target-title' => 'Loßlääje mem Övversäze!',
	'translate-fs-email-title' => 'De <i lang="en">e-mail</i> Adress bestätije',
	'translate-fs-intro' => 'Wellkumme bei {{GRAMMAR:Genitiv ier|{{SITENAME}}}} Hölp bei de eetsde Schredde för neu Metmaacher.
Heh kreß De Schrett för Schrett jesaat, wi De ene Övversäzer weeß.
Aam Engk kanns De de Täxte un Nohreeschte uß alle Projäkte övversäze, di {{GRAMMAR:em Dativ|{{SITENAME}}}} ongerstoz wääde.',
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Dä eetsde Schredd es et Aanmelde.

För Ding Övversäzonge weed Dinge Name als Metmaacher hehem
Wiki als Urhävver un Verantwootlescher jenannt.
Dat Beld heh bei zeisch, wi mer dat Fommulaa ußfölle moß.

Wann De alld aanjemäldt bes, don $1enlogge$2 un
wann de ennjelogg bes, küß De wider op heh di Sigg.

Söns $3don Desch anmällde$4.',
	'translate-fs-settings-text' => 'Jäz sullts De op di Sigg met Dinge Enstellunge jon un doh
winneschsdens ens de Schprooch för de Bedeenbofferfläsh
op di Shprooch säze, woh De noh övversäze wells.

Di Shprooch, di doh enjeshtalld es, weed als Ding Standatt-Shprooch
för Ding Övversäzonge jenumme.

Wann De alld dobei bes, kanns De doh och jlish enstelle, dat De
Övversäzonge en andere Shprooche aanjezeish kriß, di De kanns.
Di Enstellung fengks De onger „{{int:prefs-editing}}“ onge.
Wann De löstich bes, kanns De nattörlish och noch ander
Enstelluinge ußprobeere.

Jangk jäz op di [[Special:Preferences|Sigg met Dinge Enstellunge]]
un wann De doh fäädesch bes, küß De wider retuur noh heh dä Sigg.',
	'translate-fs-settings-skip' => 'Ben fäädesch.
Wigger maache!',
	'translate-fs-userpage-text' => 'Jäz moß De en Metmaachersigg för Desch enreeschte.

Donn jät övver Desch schrieve, wä De bes, wat De määß un esu.
Dat sull dä {{GRAMMAR:Genitiv ier|{{SITENAME}}}} Gemeinschaff hellfe,joot zosammezewerke.
Dat sin Minsche vun övverall op de Wält, di aan de öngerscheidleschßte Shprooche un Projäkte aam brasselle sin.

En dämm för-ußjeföllte Kaste bovve en de allereezte Reih sühß De <nowiki>{{#babel:en-2}}</nowiki>.
Bes esu joot un donn dä met Dinge Shproochkäntneße fölle.
De Nommere noh dä Afköözung för en Shprooch saare, wi joot De se kanns.
Doh bedügge:
* 1 — e beßje,
* 2 — jrundlääje Weße,
* 3 — joode Kenntneß,
* 4 — wi ene Einheimesche,
* 5 — Do schwaads di Shprooch berooflesch, för e Beishpell, Do bes ene Dolmätscher.

För Ding Mottershprooch schrief jaa kein Nommer hen, un donn bloß di Afköözung dohenn.
För e Beishpell, wann De Tamiilesch vun klein aan kalls, joot Änglesch un e beßje Kisuaheeli kanns, dann deihß De schriive: <code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Künnt sin, dat De di Affköözung för en Shprooche nit weiß, dann es dat en joode Jelääjeheit, se nohzeloore.
Dat kanns De en dä Leß heh dronger maache.',
	'translate-fs-userpage-submit' => 'En Metmaachersigg aanlääje',
	'translate-fs-userpage-done' => 'Joot jemaat! Jäz häs De en Metmaachersigg.',
	'translate-fs-permissions-text' => 'Jäz möß De dröm froore, dat De en de Metmaacherjropp „{{int:group-translator}}“ opjenumme wees.

Bes mer doh draan jet verändert han, jangk op di Sigg [[Project:Translator]] un donn, wat doh shteiht.
Donoh jangk retuur op heh di Sigg.

Wann de di Aanfrooch loßjescheck häs, weed eine vun dä Freiwellije, di dat maache künne, dobei jonn un alles prööfe, un dämm nohkumme.
Bes dohenn bes esu joot un han e beßje Jedold.

<del>Föll dat Fommulaa heh dronger reschtesch uß, un donn dann op dä Knopp klecke.</del>',
	'translate-fs-target-text' => 'Onse Jlöckwonsch!
Jez kanns De e t Övversäze aanfange

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

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'firststeps' => 'Gavên yekem',
	'translate-fs-pagetitle-done' => '-çêbû!',
	'translate-fs-target-title' => 'Bi wergerrê dest pê bike!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'firststeps' => 'Éischt Schrëtt',
	'firststeps-desc' => "[[Special:FirstSteps|Spezialsäit]] fir datt Benotzer besser ukommen fir d'Erweiderung 'Translate' op enger Wiki ze benotzen",
	'translate-fs-pagetitle-done' => ' - fäerdeg!',
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
	'translate-fs-signup-text' => "[[Image:HowToStart1CreateAccount.png|frame]]

als éischte Schrëtt musst dir iech umellen.

Déi Iwwersetzungen déi Dir maacht ginn Ärem Benotzernumm ugerechent.
D'Bild riets weist wéi Dir d'Felder ausfëlle sollt.

Wann dir Iech schonn ugemellt hutt, $1logg Iech$2 an.
Esou bal wéi Dir ugellt an ageloggt sidd, kommt w.e.g. op dës Säit zréck.

$3Umellen$4",
	'translate-fs-settings-text' => "Elo gitt Dir am beschten op Är Astellungen a
wiesselt Är Sprooch vum Interface an déi Sprooch an déi Dir iwwersetze wëllt.

D'Sprooch déi Dir fir den Interface benotzt gëtt als Standard-Zilsprooch benotzt.
Et geet séier fir d'Astelle vun der Sprooch op déi korrekt ze vergiessen, dofir ass et ugeroden dat elo direkt ze maachen.

Wann Dir schonn do sidd, da kënnt Dir d'Software och froe fir Iwwersetzungen aner Sproochen déi Dir kennt ze weisen.
Dës Astellung fannt Dir op dem Tab \"{{int:prefs-editing}}\".
Zéckt net fir och aner Astellungen auszeprobéieren.

Gitt elo op Är [[Special:Preferences|Säit mat den Astellungen]] a kommt duerno op dës Säit zréck.",
	'translate-fs-settings-skip' => 'Ech si fäerdeg.
Loosst mech weidermaachen.',
	'translate-fs-userpage-text' => "Elo musst Dir eng Benotzersäit leeën.

Schreift w.e.g. eppes iwwer Iech, wien Dir sidd a wat Dir maacht.
Dat hëlleft der {{SITENAME}}-Gemeinschaft bäi der Zesummenaarbecht.
Op {{SITENAME}} gëtt et Leit aus ganzer Welt, déi u verschiddene Sproochen a Projeten schaffen.

An der ausgefëllter Këscht uewe gesi Dir an der éischter Zeil <nowiki>{{#babel:en-2}}</nowiki>.
Fëllt et w.e.g mat Äre Sproochkenntnisser aus.
D'Zuel hanner dem Sproochcode beschreiwt wéi gudd Dir d'Sprooch kënnt.
D'Méiglechkeete sinn:
*1 - e bëssen
*2 - Basiswëssen
*3 - fléissend
*4 - bal wéi d'Mammesprooch
*5 - professionell, z.B. wann Dir e professionellen Iwwersetzer sidd.

Wenn dat Är Mammesprooch ass, loosst d'Zuel ewech a benotzt nëmmen de Sproochcode.
Beispill: Wann Dir Tamil als Mammesprooch, Englesch gutt an e bësse Swahili kéint Dir dat esou uginn:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Wann Dir de Sproochcode vun enger Sprooch net kennt, da kuckt en elo no.
Dir kënnt d'Lëscht ënnen drënner benotzen.",
	'translate-fs-userpage-submit' => 'Meng Benotzersäit maachen',
	'translate-fs-userpage-done' => 'Gutt gemaach! dir hutt elo eng Benotzersäit.',
	'translate-fs-permissions-text' => 'Elo musst Dir eng Ufro maache fir an de Grupp vun den Iwwersetzer derbäigesat ze ginn.

Bis mir de Code geännert hunn, gitt w.e.g. op [[Project:Translator]] a maacht ete sou wéi et do beschriwwen ass.
Kommt duerno zréck op dës Säit.

Nodeems datt Dir Är Ufro gemaacht hutt, kuckt ee vun de fräiwëllege Membere vun eise Mataarbechter Är Ufro no an approuvéiert se esou séier wéi méiglech. Hutt w.e.g. e bësse Gedold.

<del>Kuckt w.e.g. no ob dës Ufro korrekt ausgefëllt ass a klickt dann op de Knäppche vun der Ufro.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]
Најпрвин мора да се регистрирате.

Заслугите за преводите ќе се припишуваат на вашето корисничко име.
Сликата десно покажува како треба да се пополнат полињата.

Ако сте веќе регистрирани, сега $1најавете се$2.
Откога ќе се регистрирате, вратете се на оваа страница.

$3Регистрација$4',
	'translate-fs-settings-text' => 'Сега одете во вашите нагодувања и
барем сменете го јазикот на посредникот (interface) во јазикот на којшто ќе преведувате.

Јазикот на посредникот ќе се смета за ваш матичен целен јазик.
Може лесно да заборавите да го смените јазикот на исправниот, па затоа поставете го сега.

Додека сте тука, можете да побарате програмот да ги прикажува напревените преводи на други јазици.
Оваа функција ќе ја најдете во јазичето „{{int:prefs-editing}}“.
Најслободно истражувајте ги и другите поставки и можности.

Сега одете на [[Special:Preferences|вашите нагодувања]], па вратете се пак на оваа страница.',
	'translate-fs-settings-skip' => 'Завршив. Одиме понатаму.',
	'translate-fs-userpage-text' => 'Сега ќе треба да направите корисничка страница.

Напишете нешто за вас; кој сте и со што се занимавате.
Така заедницата на {{SITENAME}} ќе може да работи подобро.
На {{SITENAME}} има луѓе од целиот свет кои работат на различни јазици и проекти.

Во подготвената кутија горе, на најпрвиот ред ќе видите <nowiki>{{#babel:en-2}}</nowiki>.
Пополнете ја со јазикот или јазиците од кои имате познавања.
Бројката до јазичната кратенка го означува нивото на кое го владеете јазикот.
Еве ги можностите:
* 1 - малку
* 2 - основни познавања
* 3 - солидни познавања
* 4 - на ниво на мајчин
* 5 - го користите јазикот професионално, на пр. сте професионален преведувач.

Ако јазикот е ваш мајчин јазик, тогаш изоставете го нивото, и ставете го само јазичниот код (кратенка).
Пример: ако зборувате македонски од раѓање, англиски добро, и малку шпански, ќе внесете:
<code><nowiki>{{#babel:mk|en-3|es-1}}</nowiki></code>

Ако не го знаете јазичниот код на некој јазик, сега имате добра можност да го дознаете. Погледајте на списокот подолу.',
	'translate-fs-userpage-submit' => 'Создај корисничка страница',
	'translate-fs-userpage-done' => 'Одлично! Сега имате корисничка страница.',
	'translate-fs-permissions-text' => 'Сега ќе треба да поднесете барање за да ве стават во групата на преведувачи.

Додека не го поправиме овој код, одете на [[Project:Translator]] и проследете ги напатствијата.
Потоа вратете се на страницава.

Откако ќе го пополните барањето, доброволец од персоналот ќе го провери и одобри во најкраток можен рок.
Бидете трпеливи.

<del>Проверете дали следново барање е правилно пополнето, а потоа притиснете го копчето за поднесување на барањето.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

ആദ്യചുവടുകൾക്കായി നിർബന്ധമായും അംഗത്വമെടുത്തിരിക്കണം.

താങ്കളുടെ പരിഭാഷകൾക്ക് കടപ്പാട് ലഭിക്കുക താങ്കളുടെ ഉപയോക്തൃനാമത്തിലായിരിക്കും.
വലതുഭാഗത്തുള്ള ചിത്രം എപ്രകാരം ഫീൽഡുകൾ പൂരിപ്പിക്കാം എന്നു കാട്ടിത്തരുന്നു.

താങ്കൾ മുമ്പേ അംഗത്വമെടുത്തിട്ടുണ്ടെങ്കിൽ, ആദ്യം $1പ്രവേശിക്കുക$2.
അംഗത്വമെടുത്താൽ, ഈ താളിലേക്ക് തിരിച്ചുവരിക.

$3അംഗത്വമെടുക്കുക$4',
	'translate-fs-settings-text' => 'താങ്കൾ താങ്കളുടെ ക്രമീകരണങ്ങൾ ഉപയോഗിച്ച്, താങ്കൾ പരിഭാഷപ്പെടുത്താൻ ആഗ്രഹിക്കുന്ന ഭാഷയിലേയ്ക്ക് താങ്കളുടെ സമ്പർക്കമുഖ ഭാഷയെങ്കിലും മാറ്റേണ്ടതാണ്.

താങ്കളുടെ സമ്പർക്കമുഖ ഭാഷയായിരിക്കും താങ്കൾ പരിഭാഷപ്പെടുത്താൻ സ്വതേ ലക്ഷ്യം വെയ്ക്കുന്ന ഭാഷ.
ഇത് ശരിയായി ക്രമീകരിക്കുന്നത് മറന്നു പോകാൻ ഇടയുള്ളതിനാൽ, ഇപ്പോൾ തന്നെ ചെയ്യുന്നതാണ് അഭികാമ്യം.

ഒരിക്കൽ ആ താളിലെത്തിയാൽ, താങ്കൾക്കറിയാവുന്ന മറ്റുഭാഷകളിലെ പരിഭാഷകളും പ്രദർശിപ്പിക്കാൻ സോഫ്റ്റ്‌വേറിനോട് ആവശ്യപ്പെടാം.
ഈ സജ്ജീകരണം "{{int:prefs-editing}}" എന്ന റ്റാബിൽ ലഭ്യമാണ്.
മറ്റ് സജ്ജീകരണങ്ങളും ധൈര്യമായി പരീക്ഷിക്കുക.

താങ്കളുടെ [[Special:Preferences|ക്രമീകരണങ്ങൾ താൾ]] ഇപ്പോൾ തന്നെ സന്ദർശിച്ച ശേഷം തിരിച്ചെത്തുക.',
	'translate-fs-settings-skip' => 'മതിയായേ.
എന്നെ ഒന്നനുവദിക്കൂ.',
	'translate-fs-userpage-submit' => 'എന്റെ ഉപയോക്തൃ താൾ സൃഷ്ടിക്കുക',
	'translate-fs-userpage-done' => 'കൊള്ളാം! താങ്കൾക്കിപ്പോൾ ഒരു ഉപയോക്തൃതാൾ ഉണ്ട്.',
);

/** Marathi (मराठी)
 * @author Htt
 */
$messages['mr'] = array(
	'firststeps' => 'पहिल्या पायर्‍या',
	'translate-fs-pagetitle-done' => ' - झाले!',
	'translate-fs-userpage-title' => 'माझे सदस्यपान तयार करा.',
	'translate-fs-target-title' => 'भाषांतरास सुरुवात करा!',
	'translate-fs-userpage-submit' => 'माझे सदस्यपान तयार करा.',
	'translate-fs-userpage-done' => 'छान! तुम्हाला आता सदस्यपान आहे.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'firststeps' => 'Langkah pertama',
	'firststeps-desc' => '[[Special:FirstSteps|Laman khas]] untuk melatih pengguna untuk menggunakan sambungan Terjemahan untuk membangunkan wiki',
	'translate-fs-pagetitle-done' => '- siap!',
	'translate-fs-pagetitle' => 'Pendeta permulaan - $1',
	'translate-fs-signup-title' => 'Berdaftar',
	'translate-fs-settings-title' => 'Tataletak keutamaan anda',
	'translate-fs-userpage-title' => 'Cipta laman pengguna anda',
	'translate-fs-permissions-title' => 'Pohon kebenaran penterjemah',
	'translate-fs-target-title' => 'Mula menterjemah!',
	'translate-fs-email-title' => 'Sahkan alamat e-mel anda',
	'translate-fs-intro' => 'Selamat datang ke pendeta langkah pertama {{SITENAME}}.
Anda akan dibimbing sepanjang proses langkah demi langkah untuk menjadi penterjemah.
Pada akhirnya, anda akan dapat menterjemahkan "pesanan antara muka" bagi semua projek yang disokong di {{SITENAME}}.',
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Langkah pertama sekali, anda mesti mendaftar diri.

Segala terjemahan yang anda buat dilakukan di bawah nama pengguna anda.
Gambarajah di kanan menunjukkan cara mengisi ruangannya.

Jika anda sudah berdaftar, $1log masuk$2 sahaja.
Selepas mendaftar, sila kembali ke laman ini.

$3Daftar$4',
	'translate-fs-settings-text' => 'Sekarang, anda haruslah pergi ke keutamaan anda dan sekurang-kurangnya mengubah bahasa antara muka kepada bahasa sasar terjemahan anda.

Bahasa antara muka anda dijadikan bahasa sasar yang sediakala. Anda disarankan supaya menetapkan bahasa itu supaya tidak perlu lupa menukar opsyen bahasa kepada yang betul setiap kali anda datang ke sini.

Di sana, anda boleh memohon perisian untuk memaparkan terjemahan dalam bahasa-bahasa lain yang anda tahu. Tetapan ini boleh dijumpai di bawah tab "{{int:prefs-editing}}". Jangan malu untuk mencuba tetapan lain juga.

Pergi ke [[Special:Preferences|laman keutamaan]] anda sekarang, kemudian kembali ke laman ini.',
	'translate-fs-settings-skip' => 'Dah siap.
Saya nak teruskan.',
	'translate-fs-userpage-text' => 'Sekarang, anda perlu mencipta laman pengguna.

Sila tuliskan perihal diri anda untuk memperkenalkan diri kepada orang lain. Ini akan mengeratkan lagi jalinan sesama komuniti {{SITENAME}}. Di {{SITENAME}}, terdapat ramai orang dari seluruh dunia yang mengusahakan projek-projek dalam pelbagai bahasa.

Dalam petak yang tersedia diisi di atas di baris pertama sekali, anda melihat <nowiki>{{#babel:en-2}}</nowiki>. Sila isinya dengan pengetahuan bahasa anda. Nombor selepas kod bahasa itu memerikan tahap kefasihan bahasa itu. Pilihan-pilihannya adalah seperti berikut:
* 1 - sedikit sahaja
* 2 - pengetahuan asas
* 3 - cukup fasih
* 4 - fasih seperti penutur asli
* 5 - anda menuturkan bahasa itu seperti profesional, misalnya anda merupakan penterjemah profesional.

Untuk bahasa pertuturan asli anda, jangan nyatakan nombor kemahiran, gunakan sahaja kod bahasa.
Cth: jika anda penutur asli bahasa Melayu, dan cukup fasih berbahasa Inggeris dan sedikit bahasa Cina, tuliskan:
<code><nowiki>{{#babel:ms|en-3|zh-1}}</nowiki></code>

Jika anda tidak tahu kod bahasa itu, lebih baik anda perci mencarinya sekarang dengan mencari dalam senarai di bawah.',
	'translate-fs-userpage-submit' => 'Cipta laman pengguna saya',
	'translate-fs-userpage-done' => 'Syabas! Sekarang, anda ada laman pengguna.',
	'translate-fs-permissions-text' => 'Sekarang, anda perlu membuat permohonan untuk menyertai kumpulan penterjemah.

Sehingga kami membetulkan kodnya, sila ke [[Project:Translator]] dan ikut arahan-arahan di situ, kemudian balik ke sini.

Selepas anda menyerahkan permohonan anda, seorang ahli kakitangan sukarela akan menyemak permohonan anda dan meluluskan sebaik mungkin. Sila bersabar.

<del>Pastikan bahawa permintaan berikut diisikan dengan betul, kemudian tekan butang permohonan.</del>',
	'translate-fs-target-text' => "Syabas! Sekarang, anda boleh mulai menterjemah.

Jangan risau jika kebingungan kerana anda memerlukan masa untuk membiasakan diri. Di [[Project list]] terdapat sekilas pandang projek yang boleh anda sumbangkan terjemahan. Kebanyakan projek mempunyai laman keterangan ringkas dengan pautan \"''Translate this project''\" yang membawa anda ke laman yang menyenaraikan pesanan yang belum diterjemah. Juga terdapat senarai semua kumpulan pesanan dengan [[Special:LanguageStats|status penterjemahan semasa bahasa itu]].

Jika anda rasa anda perlu meningkatkan kefahaman anda sebelum memulakan penterjemahan, anda boleh membaca [[FAQ|Soalan Lazim]] kami, tetapi berhati-hati kerana sesetengah isinya mungkin ketinggalan zaman. Jika anda merasa apa-apa yang anda sepatutnya boleh lakukan, tetapi tidak dapat mengetahui caranya, jangan malu untuk bertanya di [[Support|laman bantuan]].

Anda juga boleh menghubungi para penterjemah lain yang sama bahasa dengan anda di [[Portal_talk:\$1|laman perbincangan]] [[Portal:\$1|portal bahasa anda]]. Sekiranya anda belum berbuat demikian, sila [[Special:Preferences|ubah bahasa antara muka pengguna anda kepada bahasa terjemahan anda]] supaya wiki ini dapat menunjukkan pautan-pautan (''links'') yang paling relevan kepada anda.",
	'translate-fs-email-text' => 'Sila berikan alamat e-mel anda di [[Special:Preferences|keutamaan anda]] dan sahkannya daripada e-mel yang dihantar kepada anda.

Ini membolehkan pengguna lain untuk menghubungi anda melalui e-mel.
Anda juga akan menerima surat berita selebih-lebihnya sebulan sekali.
Jika anda tidak ingi menerima surat berita, anda boleh memilih untuk mengecualikan diri daripada senarai penghantaran kami dalam tab "{{int:prefs-personal}}" dalam [[Special:Preferences|keutamaan]] anda.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'firststeps' => 'Eerste stappen',
	'firststeps-desc' => '[[Special:FirstSteps|Speciale pagina]] voor het op gang helpen van gebruikers op een wiki met de uitbreiding Translate',
	'translate-fs-pagetitle-done' => ' - afgerond!',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

In de eerste stap moet u registreren.

Uw gebruikersnaam wordt gebruikt als naamsvermelding voor uw vertalingen.
De afbeelding rechts geeft aan hoe u de velden moet invullen.

Als u al bent geregistreerd, dan kunt u zich $1aanmelden$2.
Kom terug naar deze pagina als u bent aangemeld.

$3Registreren$4',
	'translate-fs-settings-text' => 'Ga nu naar uw voorkeuren en wijzig tenminste de interfacetaal naar de taal waarin u gaat vertalen.

Uw interfacetaal wordt gebruikt als de standaardtaal waarin u gaat vertalen.
Het is makkelijk te vergeten de taal te wijzigen, dus maak die instelling vooral nu.

Als u toch uw instellingen aan het wijzigen bent, kunt u ook een instelling maken om vertalingen in andere talen als hulpje weer te geven.
Deze instellingen is te vinden in het tabblad "{{int:prefs-editing}}".
Voel u vrij om ook andere instellingen aan te passen.

Ga nu naar uw [[Special:Preferences|voorkeuren]] en kom na het wijzigen terug naar deze pagina.',
	'translate-fs-settings-skip' => 'Ik ben klaar en wil doorgaan.',
	'translate-fs-userpage-text' => 'Maak nu uw eigen gebruikerspagina aan.

Schrijf alstublieft iets over uzelf; wie u bent en wat u doet.
Dit helpt de gemeenschap van {{SITENAME}} samen te werken.
Op {{SITENAME}} werken mensen van over de hele wereld samen aan verschillende talen en projecten.

In het ingevulde formulier boven de eerste regel ziet u <nowiki>{{#babel:en-2}}</nowiki>.
Vul dit aan met uw eigen talenkennis.
Het getal achter de taalcode beschrijft hoe goed u een taal in schrift beheerst.
De mogelijkheden zijn:
* 1 - elementair niveau
* 2 - basisniveau
* 3 - gevorderd niveau
* 4 - moedertaalniveau
* 5 - u gebruikt de taal professioneel, bijvoorbeeld als professioneel vertaler.

Als u een taal als moedertaal spreekt, laat het niveau dan weg, en gebruik alleen de taalcode.
Bijvoorbeeld: uw moedertaal is Nederlands, u beheerst het Engels op gevorderd niveau, en Swahili op elementair niveau. Noteer dan:
<code><nowiki>{{#babel:nl|en-3|sw-1}}</nowiki></code>

Als u de taalcode van een taal niet kent, dan is dit een goed moment.
U kunt de lijst hieronder gebruiken.',
	'translate-fs-userpage-submit' => 'Mijn gebruikerspagina aanmaken',
	'translate-fs-userpage-done' => 'Goed gedaan!
U hebt nu een gebruikerspagina.',
	'translate-fs-permissions-text' => 'Nu moet u een verzoek doen om vertaalrechten te krijgen.

Totdat we de code wijzigen, moet u naar [[Project:Translator]] en daar de instructies volgen.
Kom daarna terug naar deze pagina.

Nadat u uw aanvraag hebt ingediend, controleert een medewerker zo snel mogelijk uw aanvraag.
Heb even geduld, alstublieft.

<del>Controleer of de onderstaande aanvraag correct is ingevuld en klik vervolgens op de knop.</del>',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Det første steget er å registrere seg.

Æren for oversettelsene tilskrives brukernavnet ditt.
Bildet til høyre viser hvordan feltene fylles ut.

Om du allerede har registrert deg, $1logg inn$2 i stedet.
Kom tilbake til denne siden når du har registrert deg.

$3Registrer deg$4',
	'translate-fs-settings-text' => 'Du bør nå gå til innstillingene dine og
i det minste endre grensesnittspråket til det språket du skal oversette til.

Ditt grensesnittspråk blir brukt som standard målspråk.
Det er lett å glemme å endre til rett språk så det anbefales på det sterkeste å gjøre dette.

Mens du er der kan du også be programvaren om å vise oversettelser i andre språk du kan.
Denne innstillingen kan du finne i fanen «{{int:prefs-editing}}».
Du må gjerne utforske de andre innstillingene også.

Gå til [[Special:Preferences|innstillingssiden]] din nå og kom tilbake hit etterpå.',
	'translate-fs-settings-skip' => 'Jeg er ferdig og vil fortsette.',
	'translate-fs-userpage-text' => 'Nå må du opprette en brukerside.

Skriv inn noe om deg selv; hvem du er og hva du gjør.
Dette vil hjelpe {{SITENAME}}-fellesskapet til å samarbeide.
Hos {{SITENAME}} er det personer fra hele verden som jobber med forskjellige språk og prosjekter.

I den ferdigutfylte boksen over i den aller første linjen ser du <nowiki>{{#babel:en-2}}</nowiki>.
Vennligst fullfør den med språkkunnskapene dine.
Tallet bak språkkoden beskriver hvor godt du kjenner det språket.
Alternativene er:
* 1 - litt
* 2 - grunnleggende kunnskaper
* 3 - gode kunnskaper
* 4 - morsmål
* 5 - du bruker språket profesjonellt, for eksempel er du en profesjonell oversetter.

Om du snakker språket som morsmål, ikke ta med kunnskapsnivået, og bruk bare språkkoden.
Eksempel: om du snakker tamil som morsmål, engelsk godt og litt swahili, vil du skrive:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Om du ikke vet språkkoden til et språk bør du slå det opp nå.
Du kan bruke listen under.',
	'translate-fs-userpage-submit' => 'Opprett brukersiden min',
	'translate-fs-userpage-done' => 'Flott! Nå har du en brukerside.',
	'translate-fs-permissions-text' => 'Nå må du sende en forespørsel om å bli lagt til oversettergruppen.

Inntil vi får fikset koden, gå til [[Project:Translator]] og følg instruksjonene.
Kom så tilbake til denne siden.

Etter at du har sendt inn forespørselen din vil en av de frivillige merarbeiderne kontrollere forespørselen din og godkjenne den så fort som mulig.
Vær tålmodig.

<del>Kontroller at følgende forespørsel er korrekt ufyllt og trykk på knappen for å sende forespørselen.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Najpierw należy się zarejestrować.

Możliwość wykonywania tłumaczeń jest przypisana do Twojej nazwy użytkownika.
Po prawej stronie na obrazku przedstawiono jak należy wypełnić pola.

Jeśli już się rejestrowałeś i posiadasz konto, po prostu $1zaloguj się$2.
Po utworzeniu konta wróć na tę stronę.

$3Zarejestruj się$4',
	'translate-fs-settings-text' => 'Teraz powinieneś wejść do swoich preferencji i co najmniej ustawić język interfejsu na ten, na który zamierzasz tłumaczyć.

Język interfejsu jest wykorzystywany jako docelowy domyślny język tłumaczeń.
Łatwo jest zapomnieć zmienić język na właściwy, więc ustawienie języka jest wysoce zalecane.

Gdy tam jesteś, możesz również nakazać oprogramowaniu wyświetlać tłumaczenia na inne języki, które znasz.
Opcję tę można znaleźć w zakładce „{{int:prefs-editing}}”.
Zapraszamy również do korzystania z innych ustawień.

Przejdź teraz na [[Special:Preferences|stronę preferencji]], a następnie wrócić tutaj.',
	'translate-fs-settings-skip' => 'Skończyłem. 
Pozwól mi przejść dalej.',
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
	'translate-fs-signup-text' => "[[Image:HowToStart1CreateAccount.png|frame]]

Ël prim pass a l'é d'anscriv-se.

L'arconossiment për soe tradussion a l'é atribuì a sò stranòm d'utent.
La figura a la drita a mostra com ampinì ij camp.

Se nopà a l'é già anscrivusse, $1ch'a rintra ant ël sistema$2.
Na vira ch'a l'é anscrivusse, për piasì ch'a artorna a sta pàgina-sì.

$3Ch'as anscriva$4",
	'translate-fs-settings-text' => "A dovrìa adess andé ai sò gust e
almanch cangé soa lenga d'antërfacia a la lenga ant la qual a veul volté.

Soa lenga d'antërfacia a l'é dovrà com la lenga ëd destinassion dë stàndard.
A l'é bel fé dësmentié ëd cangé la lenga a cola giusta, parèj a l'é motobin arcomandà d'ampostela adess.

Dagià ch'a-i é, a peul ëdcò ciamé al programa dë smon-e le tradussion ant j'àutre lenghe ch'a conòss.
Costa ampostassion a peul esse trovà sota la tichëtta \"{{int:prefs-editing}}\".
Ch'as senta lìber d'esploré ëdcò d'àutre ampostassion.

Ch'a vada a soa [[Special:Preferences|pàgina dij gust]] adess e ch'a artorna peui a sta pàgina-sì.",
	'translate-fs-settings-skip' => "I l'heu fàit.
I von anans.",
	'translate-fs-userpage-text' => "Adess a dev creé na pàgina utent.

Për piasì ch'a scriva quaicòs a propòsit ëd chiel; ch'i ch'a l'é e lòn ch'a fa.
Sòn a giutërà la comunità {{SITENAME}} a travajé ansema.
A {{SITENAME}} a-i é ëd përson-e da tut ël mond ch'a travajo su lenghe e proget diferent.

Ant ël camp preampostà dzora, ant la prima linia a vëd <nowiki>{{#babel:en-2}}</nowiki>.
Për piasì ch'a lo completa con soa conossensa dla lenga.
Ël nùmer dapress dël còdes dla lenga a descriv com ch'a conòss la lenga.
J'alternative a son:
* 1 - un pòch
* 2 - conossensa ëd bas
* 3 - bon-a conossensa
* 4 - livel ëd parlant nativ
* 5 - a deuvra la lenga professionalment, për esempi a l'é un tradutor professionista.

S'a l'é un parlant nativ ëd la lenga, ch'a lassa perde ël livel ëd conossensa, e ch'a deuvra mach ël còdes ëd la lenga.
Esempi: s'a l'é un parlant nativ Tamil, bon Anglèis, e pòch Swahili, a dovrìa scrive:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

S'a conòss pa ël còdes ëd na lenga, adess a l'é un bon moment për sërchelo.
A peul dovré la lista sì-sota.",
	'translate-fs-userpage-submit' => 'Crea mia pàgina utent',
	'translate-fs-userpage-done' => "Bin fàit! Adess it l'has na pàgina utent.",
	'translate-fs-permissions-text' => "Adess a dev fé n'arcesta d'esse giontà a la partìa dij tradutor.

Antramentre ch'i coregioma ël còdes, për piasì ch'a vada a [[Project:Translator]] e ch'a fasa conforma a j'istrussion.
Peui ch'a torna andré a sta pàgina-sì.

Apress d'avèj fàit soa arcesta, un dij mèmber volontari dl'echip a controlërà soa arcesta e a l'aprovërà prima ch'a peul.
Për piasì, ch'a pòrta passiensa.

<del>Ch'a contròla che l'arcesta sì-sota a sia compilà për da bin e peui ch'a sgnaca ël boton d'arcesta.</del>",
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount-pt.png|frame]]

No primeiro passo precisa de se registar.

A autoria das suas contribuições é atribuída ao seu nome de utilizador.
A imagem à direita mostra como deve preencher os campos.

Se já se registou antes, então $1autentique-se$2.
Depois de estar registado, volte a esta página, por favor.

$3Registar$4',
	'translate-fs-settings-text' => 'Agora deve ir até as suas preferências e, pelo menos, configurar na língua da interface a língua para a qual vai traduzir.

Por padrão, a sua língua da interface é usada como a língua de destino das traduções.
É fácil esquecer-se de alterar a língua para a correcta, por isso é altamente recomendado que a configure agora.

Enquanto está nas preferências, pode também pedir ao software que apresente as traduções noutras línguas que também conheça.
Esta configuração pode ser encontrada no separador «{{int:prefs-editing}}».
Esteja à vontade para explorar também as restantes configurações.

Vá agora à sua [[Special:Preferences|página de preferências]] e depois volte a esta página.',
	'translate-fs-settings-skip' => 'Terminei.
Passar ao seguinte.',
	'translate-fs-userpage-text' => 'Agora precisa de criar uma página de utilizador.

Escreva qualquer coisa sobre si, por favor; descreva quem é e o que faz.
Isto ajudará a comunidade da {{SITENAME}} a trabalhar em conjunto.
Na {{SITENAME}} existem pessoas de todo o mundo a trabalhar em línguas e projectos diferentes.

Na caixa que foi introduzida acima, verá na primeira linha <nowiki>{{#babel:en-2}}</nowiki>.
Preencha-a com o seu conhecimento de línguas.
O número a seguir ao código da língua descreve o seu grau de conhecimento dessa língua.
As alternativas são:
* 1 - nível básico
* 2 - nível médio
* 3 - nível avançado
* 4 - nível quase nativo
* 5 - nível profissional (usa a língua profissionalmente, por exemplo, é um tradutor profissional).

Se a língua é a sua língua materna, não coloque nenhum número e use somente o código da língua.
Por exemplo: se o português é a sua língua materna, fala bem inglês e um pouco de francês, deve escrever: <tt><nowiki>{{#babel:pt|en-3|fr-1}}</nowiki></tt>

Se desconhece o código de língua de uma língua, esta é uma boa altura para descobri-lo.
Pode usar a lista abaixo.',
	'translate-fs-userpage-submit' => 'Criar a minha página de utilizador',
	'translate-fs-userpage-done' => 'Bom trabalho! Agora tem uma página de utilizador.',
	'translate-fs-permissions-text' => 'Agora precisa de criar um pedido para ser adicionado ao grupo dos tradutores.

Até termos corrigido o software, vá a [[Project:Translator]] e siga as instruções, por favor.
Depois volte a esta página.

Após ter submetido o pedido, um dos membros da equipa de voluntários irá verificar o seu pedido e aprová-lo logo que possível.
Tenha alguma paciência, por favor.

<del>Verifique que o seguinte pedido está preenchido correctamente e depois clique o botão.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount-pt.png|frame]]

No primeiro passo, você precisa se registar.

A autoria das suas contribuições é atribuída ao seu nome de usuário.
A imagem à direita mostra como deve preencher os campos.

Se já você já se registou, então $1autentique-se$2.
Depois de estar registado, volte a esta página, por favor.

$3Registar$4',
	'translate-fs-settings-text' => 'Agora você deve ir até as suas preferências e, pelo menos, configurar na língua da interface a língua para a qual vai traduzir.

Por padrão, a sua língua da interface é usada como a língua de destino das traduções.
É fácil esquecer-se de alterar a língua para a correta, por isso é altamente recomendado que a configure agora.

Enquanto está nas preferências, pode também pedir ao software que apresente as traduções noutras línguas que também conheça.
Esta configuração pode ser encontrada no separador "{{int:prefs-editing}}".
Sinta-se à vontade para explorar também as restantes configurações.

Vá agora à sua [[Special:Preferences|página de preferências]] e depois volte a esta página.',
	'translate-fs-settings-skip' => 'Terminei.
Passar ao passo seguinte.',
	'translate-fs-userpage-text' => 'Agora você precisa criar uma página de usuário.

Escreva qualquer coisa sobre si, por favor; descreva quem é e o que faz.
Isto ajudará a comunidade da {{SITENAME}} a trabalhar em conjunto.
Na {{SITENAME}} existem pessoas de todo o mundo a trabalhar em línguas e projetos diferentes.

Na caixa que foi introduzida acima, verá na primeira linha <nowiki>{{#babel:en-2}}</nowiki>.
Preencha-a com o seu conhecimento de línguas.
O número a seguir ao código da língua descreve o seu grau de conhecimento dessa língua.
As alternativas são:
* 1 - nível básico
* 2 - nível médio
* 3 - nível avançado
* 4 - nível quase nativo
* 5 - nível profissional (usa a língua profissionalmente, por exemplo, é um tradutor profissional).

Se a língua é a sua língua materna, não coloque nenhum número e use somente o código da língua.
Por exemplo: se o português é a sua língua materna, fala bem inglês e um pouco de francês, deve escrever: <tt><nowiki>{{#babel:pt|en-3|fr-1}}</nowiki></tt>

Se desconhece o código de língua de uma língua, esta é uma boa hora para descobri-lo.
Você pode usar a lista abaixo.',
	'translate-fs-userpage-submit' => 'Criar a minha página de usuário',
	'translate-fs-userpage-done' => 'Bom trabalho! Agora você tem uma página de usuário.',
	'translate-fs-permissions-text' => 'Agora precisa de criar um pedido para ser adicionado ao grupo dos tradutores.

Até termos corrigido o software, vá a [[Project:Translator]] e siga as instruções, por favor.
Depois volte a esta página.

Após ter submetido o pedido, um dos membros da equipe de voluntários irá verificar o seu pedido e aprová-lo logo que possível.
Seja paciente, por favor.

<del>Verifique que o seguinte pedido está preenchido corretamente e depois clique o botão.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

În primul rând va trebui să vă înregistrați.

Numelui dumneavoastră de utilizator îi vor fi atribuite toate traducerile pe care le efectuați.
Imaginea din dreapta vă arată cum trebuie să completați câmpurile.

Dacă dețineți deja un cont, nu trebuie decât să vă $1autentificați$2.
Odată înregistrat, vă rugăm să reveniți la această pagină.

$3Înregistrare$4',
	'translate-fs-settings-text' => 'Acum ar trebui să mergeți în pagina preferințelor și să operați cel puțin o modificare constând în alegerea limbii interfeței (aceeași limbă în care veți traduce).

Limba aleasă pentru interfață va fi utilizată ca limbă implicită pentru traducere.
Este foarte ușor să treceți cu vederea acest aspect și de aceea vă recomandăm să faceți modificarea chiar acum.

Pentru că tot veți merge în pagina destinată preferințelor, puteți cere software-ului să afișeze traduceri și în alte limbi pe care le stăpâniți.
Această opțiune poate fi găsită în fila „{{int:prefs-editing}}”.
Nu ezitați să explorați și alte setări, de asemenea.

Puteți merge acum la [[Special:Preferences|pagina preferințelor]] după care să reveniți aici.',
	'translate-fs-settings-skip' => 'Sunt gata.
Lasă-mă să continui.',
	'translate-fs-userpage-text' => 'Acum va trebui să vă creați o pagină de utilizator.

Vă rugăm să ne spuneți câte ceva despre dumneavoastră: cine sunteți și ce faceți.
Acest lucru va ajuta comunitatea {{SITENAME}} să își desfășoare activitatea mai eficient, întrucât la {{SITENAME}} sunt oameni din toate colțurile lumii care lucrează în diferite limbi și pentru diferite proiecte.

În caseta precompletată de mai sus, în prima linie, veți descoperi sintagma <nowiki>{{#babel:en-2}}</nowiki>.
Vă rugăm să o completați în conformitate cu competențele dumneavoastră lingvistice.
Numărul de după codul limbii reprezintă nivelul de competență asociată limbii respective.
Opțiunile sunt următoarele:
* 1 – foarte puțin
* 2 – cunoștințe de bază
* 3 – cunoștințe avansate
* 4 – cunoștințe de limbă maternă
* 5 – stăpâniți foarte bine limba, asemenea unui traducător profesionist.

Dacă sunteți un vorbitor nativ al unei limbi, completați doar codul limbii, fără a specifica nivelul competenței.
De exemplu, dacă limba maternă este româna, dar puteți comunica destul de bine în limba engleză, însă foarte puțin în franceză, iată ce ar trebui să scrieți:
<code><nowiki>{{#babel:ro|en-3|fr-1}}</nowiki></code>

Dacă nu cunoașteți codul asociat unei limbi, acum este momentul să-l căutați în lista de mai jos.',
	'translate-fs-userpage-submit' => 'Creează-mi pagina mea de utilizator',
	'translate-fs-userpage-done' => 'Foarte bine! Acum aveți o pagină de utilizator.',
	'translate-fs-permissions-text' => 'Acum trebuie să depuneți o cerere pentru a vă ralia grupului de traducători.

Până când vom reuși să reparăm codul, vă rugăm să mergeți la [[Project:Translator]] și să urmați instrucțiunile de acolo.
Apoi reveniți la această pagină.

După ce ați trimis cererea, unul din membrii voluntari ai comitetului o va analiza și o va aproba cât de curând posibil.
Vă rugăm, fiți răbdător.

<del>Verificați dacă cererea de mai jos este în corect completată după care apăsați butonul de trimitere.</del>',
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
 * @author G0rn
 * @author Hypers
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
	'translate-fs-email-title' => 'Подтвердите ваш адрес электронной почты',
	'translate-fs-intro' => 'Добро пожаловать в программу начального обучения проекта {{SITENAME}}.
Шаг за шагом вы будете проведены по обучающей программе переводчиков.
По окончанию обучения вы сможете переводить интерфейсные сообщения всех поддерживаемых проектов {{SITENAME}}.',
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount-ru.png|frame]]

Для начала вам необходимо зарегистрироваться.

Авторство ваших переводов будет присваиваться имени вашей учётной записи.
Изображение справа показывает, как надо заполнять поля.

Если вы уже зарегистрированы, то вместо этого $1представьтесь$2.
После регистрации, пожалуйста, вернитесь на эту страницу.

$3Зарегистрироваться$4',
	'translate-fs-settings-text' => 'Теперь вам надо пройти в настройки и
изменить язык интерфейса на язык, на который вы собираетесь переводить.

Ваш язык интерфейса будет использоваться как язык для перевода по умолчанию.
Поскольку легко забыть изменить язык на правильный, установка его сейчас крайне рекомендуется.

Пока вы там, вы также можете включить отображение переводов на другие языки, которые вы знаете.
Эта опция находится во вкладке «{{int:prefs-editing}}».
Вы также можете изучить и другие настройки.

Сейчас пройдите на свою [[Special:Preferences|страницу настроек]], а потом вернитесь на эту страницу.',
	'translate-fs-settings-skip' => 'Готово. Перейти далее.',
	'translate-fs-userpage-text' => 'Теперь вам надо создать свою страницу участника.

Пожалуйста, напишите что-нибудь о себе; кто вы и чем вы занимаетесь.
Это поможет сообществу {{SITENAME}} работать вместе.
На {{SITENAME}} собираются люди со всего мира для работы над различными языками и проектами.

В предварительно заполненной форме наверху в самой первой строке указано <nowiki>{{#babel:en-2}}</nowiki>.
Пожалуйста, заполните этот блок в соответствии с вашим знанием языка.
Номер после кода языка показывает, насколько хорошо вы знаете этот язык.
Возможные варианты:
* 1 — небольшое знание
* 2 — базовое знание
* 3 — хорошее знание
* 4 — владение на уровне родного языка
* 5 — вы используете язык профессионально, например, если вы профессиональный переводчик.

Если этот язык является вашим родным, то уберите цифру и дефис, оставьте только код языка.
Пример: если тамильский язык является вашим родным, а также у вас есть хорошее знание английского и небольшое знание суахили, то вам нужно написать:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Если вы не знаете код языка, то сейчас самое время его узнать. Вы можете использовать список ниже.',
	'translate-fs-userpage-submit' => 'Создать мою страницу участника',
	'translate-fs-userpage-done' => 'Отлично! Теперь у вас есть страница участника.',
	'translate-fs-permissions-text' => 'Теперь вам необходимо подать запрос на добавление в группу переводчиков.

Пока мы не исправим код, пожалуйста, пройдите на страницу [[Project:Translator]] и следуйте инструкциями, а после этого вернитесь сюда.

После того, как вы подали запрос, один из волонтёров из команды сайта проверит его и одобрит как можно скорее.
Пожалуйста, будьте терпеливы.

<del>Убедитесь, что следующий запрос корректно заполнен и нажмите кнопку отправки.</del>',
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
	'translate-fs-email-text' => 'Пожалуйста, укажите ваш адрес электронной почты в [[Special:Preferences|настройках]] и подтвердите его из письма, которое вам будет отправлено.

Это позволяет другим участникам связываться с вами по электронной почте.
Вы также будете получать новостную рассылку раз в месяц.
Если вы не хотите получать рассылку, то вы можете отказаться от неё на вкладке «{{int:prefs-personal}}» ваших [[Special:Preferences|настроек]].',
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
	'translate-fs-userpage-text' => 'Теперь вам треба створити сторінку хоснователя.

Напиште дашто о собі, хто сьте і де робите.
Тото поможе {{SITENAME}} комунітї працовати вєдно.
На {{SITENAME}} суть люде з цілого світа, котры працують на вшелиякых языках і проєктах.

В поличку выповненым допереду на каждім першім рядку видите <nowiki>{{#babel:en-2}}</nowiki>.
Просиме, докінчте то з вашов языковов зналостёв.
Чісло за языковым кодом пописує як добру знаєте тот язык.
Можности суть:
* 1 - маленько
* 2 - основна зналость
* 3 - добра зналость
* 4 - рівень материньского языка
* 5 - язык хоснуєте професіонално, наприклад сьте професіоналный перекладач.

Кідь є язык ваш материньскый, зохабте рівень языкя так, і хоснуйте лем код языка.
Приклад: кідь Tamil є ваш материньскый язык, Анґліцкы добрі, і маленько Swahili, вы бы написали:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Кідь не знаєте код языка, так є час ёго поглядати.
Можете хосновати список ниже.',
	'translate-fs-userpage-submit' => 'Створити мою сторінку хоснователя',
	'translate-fs-userpage-done' => 'Добрі зроблено! Теперь маєте сторінку хоснователя.',
	'translate-fs-permissions-text' => 'Теперь потребуєте подати жадость про приданя до чрупы перекладателїв.
Покы мы не справиме  код, ідьте до [[Project:Translator]] і наслїдуйте інштрукції.
Потім ся верните на тоту сторінку.

Кідь сьте одослали вашу пожадавку, єден член з добровольных працовників перевірить вашу пожадавку і схваліть єй так скоро як то буде можне.
Просиме, будьте терпезливы.

<del>Перевірте ці наслїдуюча пожадавка є  правилно выповнена і стисните ґомбічку пожадавкы.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Na prvem koraku se morate registrirati.

Zasluge za vaše prevode so pripisane vašemu uporabniškemu imenu.
Slika na desni prikazuje, kako izpolniti polja.

Če ste se že registrirali, se namesto tega $1prijavite$2.
Ko ste enkrat registrirani, se prosimo vrnite na to stran.

$3Registracija$4',
	'translate-fs-settings-text' => 'Sedaj pojdite v svoje nastavitve in
vsaj spremenite jezik vmesnika v jezik v katerega nameravate prevajati.

Vaš jezik vmesnika je uporabljen kot privzeti ciljni jezik.
Hitro se lahko zgodi, da pozabimo spremeniti jezik v pravega, zato je ta nastavitev zelo priporočljiva.

Medtem ko ste tam, lahko programje zaprosite za prikaz prevodov v drugih jezikih, ki jih poznate.
To nastavitev je mogoče najti pod zavihkom »{{int:prefs-editing}}«.
Brez zadržkov raziščite tudi ostale nastavitve.

Sedaj pojdite na vašo [[Special:Preferences|stran z nastavitvami]] in se nato vrnite na to stran.',
	'translate-fs-settings-skip' => 'Končal sem.
Pustite mi nadaljevati.',
	'translate-fs-userpage-text' => 'Sedaj ustvarite uporabniško stran.

Prosimo, napišite nekaj o sebi; kdo ste in kaj počnete.
To bo pripomoglo k sodelovanju skupnosti {{GRAMMAR:rodilnik|{{SITENAME}}}}.
Na {{GRAMMAR:dajalnik|{{SITENAME}}}} so ljudje iz celega sveta, ki delujejo na različnih jezikih in projektih.

V že izpolnjenem polju spodaj boste v prvi vrstici videli <nowiki>{{#babel:en-2}}</nowiki>.
Prosimo, izpolnite ga s svojim znanjem jezikov.
Številka za kodo jezika opisuje, kako dobro poznate jezik.
Možnosti so:
* 1 – malo,
* 2 – osnovno znanje,
* 3 – dobro znanje,
* 4 – raven naravnega govorca,
* 5 – jezik uporabljate poklicno, na primer ste profesionalni prevajalec.

Če ste naravni govorec, izpustite raven izurjenosti in uporabite samo kodo jezika.
Primer: če ste naravni govorec tamilščine, angleščino dobro obvladate in znate še nekaj svahilija, potem napišete:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Če ne veste jezikovne kode nekega jezika, jo je sedaj priporočljivo poiskati.
Uporabite lahko spodnji seznam.',
	'translate-fs-userpage-submit' => 'Ustvari mojo uporabniško stran',
	'translate-fs-userpage-done' => 'Dobro opravljeno! Sedaj imate uporabniško stran.',
	'translate-fs-permissions-text' => 'Sedaj morate vložiti prošnjo za vključitev v skupino prevajalcev.

Dokler ne popravimo kode, prosimo, pojdite na [[Project:Translator]] in sledite navodilom.
Nato se vrnite nazaj na to stran.

Ko oddate prošnjo, bo nekdo od prostovoljnih članov osebja preveril vašo zahtevo in jo potrdil takoj, ko bo to mogoče.
Prosimo, bodite potrpežljivi.

<del>Preverite, ali je naslednja zahteva izpolnjena pravilno, in pritisnite gumb za zahtevek.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Först behöver du skapa ett användarkonto.

Poäng för dina översättningar tillskrivs ditt användarnamn.
Bilden till höger visar hur du fyller i fälten.

Om du redan har registrerat dig så $1logga in$2 istället.
När du har registrerat dig går du tillbaka till denna sida.

$3Skapa ett användarkonto$4',
	'translate-fs-settings-text' => 'Du bör nu gå till dina inställningar och
åtminstone byta språk för gränssnittet till det språk du ska översätta till.

Språket för gränssnittet används som standard för det språk du översätter till.
Det är lätt att glömma att ändra till rätt språk, så det är varmt rekommenderat att göra det nu.

Medan du är där kan du även be om programvaran för att visa översättningar till andra språk du kan.
Denna inställning finns under fliken "((int: prefs-redigering))".
Du får gärna utforska andra inställningar också.

Gå nu till din [[Special:Preferences|inställningssida]] och återvänd sedan till den här sidan.',
	'translate-fs-settings-skip' => 'Jag är klar.
Låt mig gå vidare.',
	'translate-fs-userpage-text' => 'Nu behöver du skapa en användarsida.

Skriv gärna något om dig själv, vem du är och vad du gör.
Detta kommer att hjälpa användare av {{SITENAME}} att arbeta tillsammans.
På {{SITENAME}} arbetar människor från hela världen med olika språk och projekt.

I den allra första raden i den förifyllda rutan ovan visas <nowiki>{{#babel:en-2}}</nowiki>.
Fyll i raden med dina språkkunskaper.
Siffran bredvid språkkoden beskriver hur väl du behärskar språket.
Valmöjligheterna är:
 * 1 - lite grann
 * 2 - grundläggande kunskaper
 * 3 - goda kunskaper
 * 4 - nästan som ett modersmål
 * 5 - du använder språket professionellt, till exempel om du är en professionell översättare.

Om du har ett språk som modersmål, så strunta i att skriva ut kompetensnivån och använda bara språkkoden.
Exempel: Om svenska är ditt modersmål, du talar engelska väl och lite swahili, så skriver du:
<code><nowiki>{{#babel:sv|en-3|sw-1}}</nowiki></code>

Om du inte känner till språkkoden för ett språk så är det dags att slå upp den nu.
Du kan använda listan nedan.',
	'translate-fs-userpage-submit' => 'Skapa din användarsida',
	'translate-fs-userpage-done' => 'Mycket bra! Du har nu en användarsida.',
	'translate-fs-permissions-text' => 'Nu behöver du skicka en förfrågan om att få komma med i översättargruppen.

Tills vi har fixat till koden får du gå till [[Project:Translator]] och följa instruktionerna.
Återvänd sedan tillbaka till den här sidan.

När du har skickat din förfrågan kommer en av de frivilligarbetande medlemmarna att granska din ansökan och godkänna den så snart som möjligt.
Ha tålamod.

<del>Kontrollera att följande förfrågan är korrekt ifylld och tryck sedan på knappen för att skicka förfrågan.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

మొదటి మెట్టుగా మీరు నమోదు చేసుకోవాలి.

మీరు చేసే అనువాదాల శ్రేయస్సు మీ వాడుకరిపేరుకు లభిస్తుంది.
కుడివైపున ఉన్న బొమ్మ, ఫీల్డులను ఎలా నింపాలో చూపిస్తుంది.

మీరు ఈపాటికే నమోదై ఉంటే, $1లాగినవండి$2.
నమోదయ్యాక, తిరిగి ఈ పేజీకి రండి.

$3నమోదు$4',
	'translate-fs-settings-text' => 'ఇప్పుడు మీరు మీ అభిరుచులు పేజీకి వెళ్ళి
కనీసం ఏ భాషలోకి అనువాదాలు చెయ్యదలచుకున్నారో ఆ భాషకు మీ ఇంటరుఫెసు భాషను మార్చండి.

మీ ఇంటరుఫేసు భాషే మీ డిఫాల్టు లక్ష్య భాష అవుతుంది.
భాషను మార్చడమనే సంగతిని మర్చిపోవడం బహు తేలిక. అంచేత ఇప్పుడే మార్చుకోవడం మంచిదని నొక్కి చెబుతున్నాం.

అక్కడే, మీకు తెలిసిన ఇతర భాషల్లోని అనువాదాలను కూడా చూపించమని సాఫ్టువేరును అడగండి..
ఈ సెట్టింగు "{{int:prefs-editing}}" ట్యాబులో కనిపిస్తుంది.
ఇతర సెట్టింగుల్లో కూడా ఏముందో శోధించండి.

ఇక మీ [[Special:Preferences|అభిరుచులు పేజీ]] కి వెళ్ళి, తిరిగి ఇక్కడికి రండి.',
	'translate-fs-settings-skip' => 'పూర్తి చేసాను.
ఇక ముందుకు తీసుకెళ్ళు.',
	'translate-fs-userpage-text' => 'ఇప్పుడు మీరో వాడుకరి పేజీని తయారు చేసుకోవాలి.

మీ గురించి కాస్త రాయండి -  మీ రెవెఅరు, ఏం చేస్తూంటారు లాంటివి.
{{SITENAME}} సమాజంతో కలిసి పనిచేయడానికి ఇది ఉపయోగపడుతుంది. 
{{SITENAME}} లో ప్రపంచం నలుమూల నుండి వచ్చిన ప్రజలు వివిధ భాషలు, ప్రాజెక్టులపై పనిచేస్తున్నారు.

పైనున్న మొదటి లైనులోని ముందే నింపిన పెట్టెలో <nowiki>{{#babel:en-2}}</nowiki> అని మీకు కనిపిస్తుంది.
మీ భాషా పరిజ్ఞానపు స్థాయిని అక్కడ నింపండి.
భాషా సంకేతం తరువాత ఉన్న సంఖ్య ఆ భాషలో మీకున్న ప్రావీణ్యాన్ని తెలియజేస్తుంది.
మీకున్న ప్రత్యామ్నాయాలు:
* 1 - కొద్దిగా
* 2 - సాధారణ పరిజ్ఞానం
* 3 - మంచి పరిజ్ఞానం
* 4 - స్వంత భాష స్థాయి (మాతృ భాష వంటిది)
* 5 - వృత్తి రీత్యా భాషను వాడుతారు, ఉదాహరణకు మీరు ప్రొఫెషనల్ అనువాదకులు.
ఏదైనా భాషను మీరు స్వంత భాష లాగా మాట్లాడగలిగితే, నైపుణ్యం స్థాయిని వదిలేసి, భాష సంకేతం మాత్రమే రాయండి.
ఉదా: మీరు తెలుగు స్వంత భాషలాగా మాట్లాడగలిగి, ఇంగ్లీషులో మంచి పరిజ్ఞానం ఉండి, కొద్దిగా స్వాహిలి వస్తే, ఇలా రాయాలి:
<code><nowiki>{{#babel:te|en-3|sw-1}}</nowiki></code>

ఏదైనా భాషకు సంబంధించిన కోడు మీకు తెలియకపోతే, తెలుసుకొనేందుకు ఇది సరైన సమయం.
కింది జాబితాను వాడండి.',
	'translate-fs-userpage-submit' => 'నా వాడుకరి పుటని సృష్టించు',
	'translate-fs-userpage-done' => 'భళా! మీకు ఇప్పుడు వాడుకరి పుట ఉంది.',
	'translate-fs-permissions-text' => 'ఇప్పుడిక మిమ్మల్ని అనువాదకుల గుంపుకు చేర్చమని అడగండి. 

మేం కోడును సరిచేసే లోపు [[Project:Translator]] కు వెళ్ళి అక్కడి సూచనలను పాటించండి.
ఆ తరువాత ఈ పేజీకి రండి.

మీ అభ్యర్ధనను పంపించాక, మా ఔత్సాహిక సభ్యులు వీలైనంత త్వరగా మీ అభ్యర్ధనను పరిశీలించి, ఆమోదిస్తారు.
ఓపికగా ఉండండి.

<del>కింది అభ్యర్ధనను సరిగ్గా పూర్తి చేసారని నిర్ధారించుకుని, అభ్యర్ధించు బొత్తాన్ని నొక్కండి.</del>',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|balangkas]]

Sa unang hakbang ay dapat kang magpatala.

Ang pagpapatungkol sa iyong mga pagsasalinwika ay ipinapatungkol sa iyong pangalan ng tagagamit.
Ang larawan sa kanan ay nagpapakita ng kung paano pupunuin ang mga hanay.

Kung nakapagpatala ka na, $1lumagda$2 sa halip.
Kapag nakapagpatala ka na, mangyaring bumalik sa pahinang ito.

$3Magpatala$4',
	'translate-fs-settings-skip' => 'Tapos na ako.
Bayaan akong magpatuloy.',
	'translate-fs-userpage-submit' => 'Likhain ang aking pahina ng tagagamit',
	'translate-fs-userpage-done' => 'Mahusay! Mayroon ka na ngayong isang pahina ng tagagamit.',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount-ru.png|frame]]

На першому кроці вам необхідно зареєструватися.

Авторство ваших перекладів надається вашому імені користувача.
Зображення праворуч показує, як заповнити поля.

Якщо ви вже зареєстровані, тоді замість цього $1увійдіть$2.
Після реєстрації, будь ласка, поверніться на цю сторінку.

$3Зареєструватися$4',
	'translate-fs-settings-text' => 'Тепер вам необхідно перейти до налаштувань і
щонайменше змінити мову інтерфейсу на ту мову, на яку ви збираєтесь перекладати.

Ваша мова інтерфейсу буде використовуватися як мова, на яку здійснюється переклад, за замовчуванням.
Оскільки забути обрати правильну мову легко, то вкрай рекомендовано встановити її зараз.

Пока ви знаходитесь у налаштуваннях, ви також можете увімкнути відображення перекладів іншими мовами, які ви знаєте.
Це налаштування можна знати у вкладці «{{int:prefs-editing}}».
Можете також дослідити й інші налаштування.

Зараз перейдіть на свою [[Special:Preferences|сторінку налаштувань]], а потім поверніться на цю сторінку.',
	'translate-fs-settings-skip' => 'Зроблено.
Дозвольте мені продовжити.',
	'translate-fs-userpage-text' => 'Тепер вам потрібно створити сторінку учасника.

Будь ласка, напишіть щось про себе: хто ви і чим займаєтесь.
Це допоможе спільноті {{SITENAME}} працювати разом.
На {{SITENAME}} є люди з усього світу, які працюють на різних мовах і проектах.

У попередньо заповненому полі зверху в найпершому рядку ви побачите <nowiki>{{#babel:en-2}}</nowiki>.
Будь ласка, заповніть це поле у відповідності з вашими знаннями мов.
Номер після коду мови визначає, наскільки добре ви знаєте цю мову.
Варіанти:
* 1 — трохи
* 2 — базове знання
* 3 — хороше знання
* 4 — рівень носія мови
* 5 — ви використовуєте мову професійно, наприклад, ви — професійний перекладач.

Якщо мова є вашою рідною, то не зазначайте рівень (цифру й дефіс), а використовуйте тільки код мови.
Приклад: якщо тамільська мова є вашою рідною, а також у вас є хороше знання англійської та невелике знання суахілі, то вам потрібно написати:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Якщо ви не знаєте коду мови, то зараз саме час його знайти.
Можете використовувати перелік нижче.',
	'translate-fs-userpage-submit' => 'Створити мою сторінку користувача',
	'translate-fs-userpage-done' => 'Чудово! Тепер у вас є сторінка користувача.',
	'translate-fs-permissions-text' => 'Тепер вам необхідно подати запит, щоб вас додали до групи перекладачів.

Поки ми не виправимо код, потрібно переходити до [[Project:Translator]] та дотримуватись інструкцій.
Потім поверніться до цієї сторінки.

Після того, як ви подасте запит, один з волонтерів команди сайту перевірить ваш запит і схвалить його якомога швидше.
Будь ласка, будьте терплячими.

<del>Переконайтеся, що наступний запит правильно заповнений, а потім натисніть кнопку запиту.</del>',
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

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'firststeps' => 'Các bước đầu',
	'firststeps-desc' => '[[Special:FirstSteps|Trang đặc biệt]] để giúp những người mơi đến bắt đầu sử dụng phần mở rộng Dịch',
	'translate-fs-pagetitle-done' => ' – đã hoàn tất!',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

Đầu tiên bạn phải mở tài khoản.

Chúng tôi sẽ ghi công cho bản dịch của bạn thông qua tên người dùng của bạn.
Hình bên phải hướng dẫn cho bạn cách điền vào các ô trống.

Nếu bạn đã mở tài khoản rồi, hãy $1đăng nhập$2.
Sau khi đã mở tài khoản, hãy trở lại trang này.

$3Mở tài khoản$4',
	'translate-fs-settings-text' => 'Giờ bạn nên đến trang tùy chọn cá nhân của mình và
nhớ phải thay đổi ngôn ngữ giao diện sang loại ngôn ngữ mà bạn dự định sẽ dịch sang.

Ngôn ngữ giao diện của bạn sẽ được dùng làm ngôn ngữ đích mặc định.
Rất dễ quên thay đổi ngôn ngữ sang một ngôn ngữ đúng, vì thế chúng tôi khuyên bạn nên làm ngay bây giờ.

Khi ở đó, bạn cũng có thể yêu cầu phần mềm hiển thị các bản dịch trong các ngôn ngữ khác mà bạn biết.
Thiết lập này bạn có thể tìm thấy ở thẻ "{{int:prefs-editing}}".
Bạn cứ thoải mái khám phá các thiết lập khác nhé.

Đến [[Special:Preferences|trang tùy chọn cá nhân]] của bạn ngay bây giờ rồi trở lại trang này.',
	'translate-fs-settings-skip' => 'Tôi đã xong.
Cho tôi xem tiếp nào.',
	'translate-fs-userpage-text' => 'Bây giờ bạn cần phải tạo trang cá nhân của mình.

Xin hãy viết một chút về bản thân; giới thiệu bạn là ai và bạn làm gì.
Điều này sẽ giúp cho cộng đồng {{SITENAME}} cộng tác với nhau dễ hơn.
Tại {{SITENAME}} có nhiều người từ khắp nơi trên thế giới làm việc trên các dự án và ngôn ngữ khác nhau.

Trong hộp đã điền sẵn ở phía trên ngay dòng đầu tiên bạn sẽ nhìn thấy <nowiki>{{#babel:en-2}}</nowiki>.
Xin hãy điền nó bằng ngôn ngữ mà bạn biết.
Con số phía sau mã ngôn ngữ biểu thị mức độ thông thạo của bạn đối với ngôn ngữ.
Các con số đó có nghĩa là:
* 1 - một chút
* 2 - biết cơ bản
* 3 - có kiến thức tốt
* 4 - cấp độ bản địa
* 5 - bạn sử dụng ngôn ngữ một cách chuyên nghiệp, ví dụ bạn là biên dịch viên chuyên nghiệp.

Nếu bạn là người nói tiếng bản địa của ngôn ngữ đó, không cần phải điền mức độ thành thạo, chỉ cần ghi mã ngôn ngữ là được.
Ví dụ: Nếu Tamil là ngôn ngữ mẹ đẻ của bạn, nói tiếng Anh tốt, một chút tiếng Swahili, bạn cần viết:
<code><nowiki>{{#babel:ta|en-3|sw-1}}</nowiki></code>

Nếu bạn không biết mã ngôn ngữ của một ngôn ngữ, lúc này bạn có thể tra nó.
Bạn có thể dùng danh sách phía dưới.',
	'translate-fs-userpage-submit' => 'Tạo trang cá nhân',
	'translate-fs-userpage-done' => 'Tốt lắm! Bây giờ bạn đã có trang người dùng.',
	'translate-fs-permissions-text' => 'Giờ bạn cần phải đặt yêu cầu được thêm vào một nhóm biên dịch.

Cho đến khi chúng tôi sửa xong lỗi, xin đến [[Project:Translator]] và làm theo hướng dẫn.
Sau đó trở lại trang này.

Sau khi đã đăng yêu cầu, một trong các thành viên tình nguyện của chúng tôi sẽ kiểm tra yêu cầu và chứng thực nó rất sớm.
Xin hãy kiên nhẫn.

<del>Kiểm tra xem yêu cầu dưới đây đã được điền đúng hay chưa rồi nhấn nút gửi.</del>',
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
	'translate-fs-userpage-title' => 'שאַפֿן אײַער באַניצער בלאַט',
	'translate-fs-permissions-title' => 'בעטן איבערזעצער אויטאריזאַציע',
	'translate-fs-target-title' => 'אָנהייבן איבערזעצן!',
	'translate-fs-email-title' => 'באַשטעטיקט אײַער בליצפּאָסט אַדרעס',
	'translate-fs-userpage-submit' => 'שאַפֿן מיין באַניצער בלאַט',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenxiaoqino
 * @author Hydra
 * @author Mark85296341
 */
$messages['zh-hans'] = array(
	'firststeps' => '第一步',
	'firststeps-desc' => '让用户开始wiki翻译的[[Special:FirstSteps|引导页面]]',
	'translate-fs-pagetitle-done' => ' - 完成！',
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
	'translate-fs-signup-text' => '[[Image:HowToStart1CreateAccount.png|frame]]

首先你必须注册。

翻译行为将基于用户名记录。
右边的图片指示了如何在网页里填表。

如果你已经注册了，请$1 登录$2 。
当你完成注册后，请回到此页面。

$3 注册$4',
	'translate-fs-settings-text' => '现在你应该到选项页面并且至少将界面语言设置成你希望翻译成的语言。

你的界面语言将会是默认的翻译目标语言。
设置语言很容易被忘记，所以我们建议你现在就去设置。

你也可以要求软件显示你懂得的其他语言，这可以在"{{int:prefs-editing}}"进行设置。
自由探索其他设置选项吧。

到[[Special:Preferences|设置页面]]完成设置，并返回此页面。',
	'translate-fs-settings-skip' => '我完成了。继续进行。',
	'translate-fs-userpage-text' => '现在你需要创建用户页面。

请写一些关于你的东西，比如，你是谁？你希望干些什么？
这会帮助凝聚{{SITENAME}}用户群体。
在{{SITENAME}}有来自世界各地的用户在翻译不同的语言和项目。


在已经填好的文字区域中的第一行你会看到<nowiki>{{#babel:en-2}}</nowiki>。
继续填入其他你懂得的语言知识。
跟在语言代码后面的表示你通晓这门语言的程度。
他们表示：
* 1 - 懂得一点点；
* 2 - 懂得基本知识；
* 3 - 能很好的掌握；
* 4 - 母语水平；
* 5 - 专业水平，比如说你是专业语言学家。

如果你使用某种语言作为母语，不要填写通晓程度代码。
样例：如果你的母语是中文，能说英语说的很好，还会一点日语，那么你应该写：
<code><nowiki>{{#babel:zh|en-3|ja-1}}</nowiki></code>

如果你还不知道一门语言的代码，现在是时候查找一下了。
你可以使用下面的列表。',
	'translate-fs-userpage-submit' => '创建我的用户页面',
	'translate-fs-userpage-done' => '很好！现在你有了一个用户页面。',
	'translate-fs-permissions-text' => '你现在需要提交申请以加入翻译组。

请到[[Project:Translator]]页面，并跟随上面的指引。
然后，回到此页面。

在你提交申请之后，其中一名志愿者员工会检查您的申请并尽快批准。
请耐心点。',
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
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'translate-fs-pagetitle-done' => ' - 完成！',
	'translate-fs-pagetitle' => '入門指導 - $1',
	'translate-fs-signup-title' => '註冊',
	'translate-fs-userpage-title' => '建立您的使用者頁面',
	'translate-fs-permissions-title' => '請求翻譯者權限',
	'translate-fs-target-title' => '開始翻譯！',
	'translate-fs-intro' => "歡迎來到 {{SITENAME}} 入門指導。
你會被指導如何成為一名翻譯者。
最後你將可以翻譯 {{SITENAME}} 裡所有計畫的''介面訊息''.",
	'translate-fs-settings-text' => '現在你應該到選項頁面並且至少將介面語言設定成你希望翻譯成的語言。

你的介面語言將會是預設的翻譯目標語言。
設定語言很容易被忘記，所以我們建議你現在就去設定。

你也可以要求軟體顯示你懂得的其他語言，這可以在「{{int:prefs-editing}}」進行設定。
自由探索其他設定選項吧。

到[[Special:Preferences|設定頁面]]完成設定，並回到此頁面。',
	'translate-fs-userpage-text' => '現在你需要建立使用者頁面。

請寫一些關於你的東西，比如，你是誰？你希望做些什麼？
這會幫助凝聚 {{SITENAME}} 用戶群體。
在 {{SITENAME}} 有來自世界各地的使用者在翻譯不同的語言和項目。

在已經填好的文字區域中的第一行你會看到<nowiki>{{#babel:en-2}}</nowiki>。
繼續填入其他你懂得的語言知識。
跟在語言代碼後面的表示你通曉這門語言的程度。
他們表示：
* 1 - 懂得一點點；
* 2 - 懂得基本知識；
* 3 - 能很好的掌握；
* 4 - 母語水準；
* 5 - 專業水準，比如說你是專業語言學家。

如果你使用某種語言作為母語，不要填寫通曉程度代碼。
樣例：如果你的母語是中文，能說英語說的很好，還會一點日語，那麼你應該寫：
<code><nowiki>{{#babel:zh|en-3|ja-1}}</nowiki></code>

如果你還不知道一門語言的代碼，現在是時候尋找一下了。
你可以使用下面的列表。',
	'translate-fs-userpage-submit' => '建立我的使用者頁面',
	'translate-fs-userpage-done' => '很好！現在你擁有了一個使用者頁面。',
);

