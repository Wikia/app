<?php
/**
 * Internationalisation file for WikimediaIncubator extension.
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author SPQRobin
 */
$messages['en'] = array(
	'wminc-desc' => 'Test wiki system for Wikimedia Incubator',
	'wminc-viewuserlang' => 'Look up user language and test wiki',
	'wminc-viewuserlang-user' => 'Username:',
	'wminc-viewuserlang-go' => 'Go',
	'wminc-testwiki' => 'Test wiki:',
	'wminc-testwiki-none' => 'None/All',
	'wminc-prefinfo-language' => 'Your interface language - independent from your test wiki',
	'wminc-prefinfo-code' => 'The ISO 639 language code',
	'wminc-prefinfo-project' => 'Select the Wikimedia project (Incubator option is for users who do general work)',
	'wminc-prefinfo-error' => 'You selected a project that needs a language code.',
	'wminc-warning-unprefixed' => "'''Warning:''' The page you are editing is unprefixed!",
	'wminc-warning-suggest' => 'You can create a page at [[$1]].',
	'wminc-warning-suggest-move' => 'You can [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} move this page to $1].',
	'right-viewuserlang' => 'View [[Special:ViewUserLang|user language and test wiki]]',
	'randombytest' => 'Random page by test wiki',
	'randombytest-nopages' => 'There are no pages in your test wiki, in the namespace: $1.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Purodha
 * @author SPQRobin
 */
$messages['qqq'] = array(
	'wminc-desc' => '{{desc}}',
	'wminc-viewuserlang' => 'Title of a special page to look up the language and test wiki of a user. See [[:File:Incubator-testwiki-viewuserlang.jpg]].',
	'wminc-viewuserlang-user' => 'Label for the input.

{{Identical|Username}}',
	'wminc-viewuserlang-go' => "Text on the submit button to view the user's language and test wiki.

{{Identical|Go}}",
	'wminc-testwiki' => 'See [[:File:Incubator-testwiki-preference.jpg]].',
	'wminc-testwiki-none' => "* Used on Special:Preferences when the user didn't select a test wiki preference (yet).
* Used on Special:RecentChanges to show normal recent changes display.",
	'wminc-prefinfo-language' => 'See [[:File:Incubator-testwiki-preference.jpg]]. Extra clarification for the (normal) language selection.',
	'wminc-prefinfo-code' => 'See [[:File:Incubator-testwiki-preference.jpg]].',
	'wminc-prefinfo-project' => 'See [[:File:Incubator-testwiki-preference.jpg]].',
	'wminc-prefinfo-error' => 'See [[:File:Incubator-testwiki-preference.jpg]]. If the user selected a Wikimedia project but not a language code, this error message is shown.',
	'wminc-warning-unprefixed' => 'This warning is shown when creating or editing a page that does not match <code>/W[bnpqt]\\/[a-z][a-z][a-z]?/</code>.',
	'wminc-warning-suggest' => '* $1 is user prefix + current page title (for example "Wp/nl/Pagina" when creating "Pagina").',
	'wminc-warning-suggest-move' => '* $1 is user prefix + current page title (for example "Wp/nl/Pagina" when creating "Pagina").
* $2 is the same, but for use in URLs.
* $3 is the current page title.',
	'right-viewuserlang' => '{{doc-right|viewuserlang}}',
);

/** Moroccan Spoken Arabic (Maġribi)
 * @author Enzoreg
 */
$messages['ary'] = array(
	'wminc-desc' => "L-Wiki dyal 't-tést le Wikimédya Incubator",
	'wminc-viewuserlang' => "Ha hiya loġaṫ l-mosṫeĥdim o l-Wiki dyal 't-tést dyalo",
	'wminc-viewuserlang-user' => 'Smiyṫ l-mosṫeĥdim :',
	'wminc-viewuserlang-go' => 'Sir',
	'wminc-testwiki' => "L-Wiki dyal 't-tést :",
	'wminc-testwiki-none' => 'Ḫṫa ḫaja / Kol ċi',
	'wminc-prefinfo-language' => "Loġṫ wajihṫek - mesṫaqela men 't-tést dyal l-Wiki dyalek",
	'wminc-prefinfo-code' => 'L-kod ISO 639 dyal l-loġa',
	'wminc-prefinfo-project' => 'Ĥṫar l-meċroĝ Wikimédya (l-opsyon Incubator mĥeṣeṣa le mosṫeĥdimin li ka iṣaybo ĥedma ĝama)',
	'wminc-prefinfo-error' => 'Ĥṫariṫi meċroĝ li ka iḫṫaj l-kod dyal l-loġa.',
	'wminc-warning-unprefixed' => "'''Ĝendak :''' 'ṣ-ṣefḫa li ka ṫṫbedel ma ĝendha ḫṫa préfiks !",
	'wminc-warning-suggest' => 'Imkenlik ṫĥṫareĝ ċi ṣefḫa fe [[$1]].',
	'wminc-warning-suggest-move' => "Imkenlik [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} ṫneqel had 'ṣ-ṣefḫa le $1].",
	'right-viewuserlang' => "Ċof [[Special:ViewUserLang|loġṫ l-mosṫeĥdim o l-Wiki dyal 't-tést]]",
	'randombytest' => "Ṣefḫa ĝel l-Lah men l-Wiki dyal 't-tést",
	'randombytest-nopages' => "L-Wiki dyal 't-tést ma fih ḫṫa ṣefḫa, fe l-maḫel dyal 's-smiyaṫ : $1.",
);

/** Laz (Laz)
 * @author Bombola
 */
$messages['lzz'] = array(
	'wminc-viewuserlang-go' => 'İgzali',
	'wminc-prefinfo-code' => "ISO 639 nena k'odi",
);

/** Achinese (Acèh)
 * @author Fadli Idris
 */
$messages['ace'] = array(
	'wminc-desc' => 'Sistem cuba wiki keu Wikimedia Incubator',
	'wminc-viewuserlang' => 'Kaleun bahsa pengguna dan cuba wiki',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wminc-desc' => 'Toets wiki-stelsel vir die Wikipedia Inkubator',
	'wminc-viewuserlang' => 'Soek op gebruikerstaal en toetswiki',
	'wminc-viewuserlang-user' => 'Gebruikersnaam:',
	'wminc-viewuserlang-go' => 'OK',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Geen/alles',
	'wminc-prefinfo-language' => 'U koppelvlaktaal - onafhanklik van u toetswiki',
	'wminc-prefinfo-code' => 'Die ISO 639-taalkode',
	'wminc-prefinfo-project' => 'Kies die Wikimedia-projek (Inkubator-opsie is vir gebruikers wat nie algemeen werk doen nie)',
	'wminc-prefinfo-error' => "Jy het 'n projek gekies wat 'n taalkode benodig.",
	'wminc-warning-unprefixed' => "'''Waarskuwing:''' Die bladsy wat jy wysig het nie 'n voorvoegsel nie!",
	'wminc-warning-suggest' => "U kan 'n bladsy skep by [[$1]].",
	'wminc-warning-suggest-move' => 'U kan [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} hierdie bladsy skuif na $1].',
	'right-viewuserlang' => 'Sien [[Special:ViewUserLang|gebruikerstaal en toetswiki]]',
	'randombytest' => 'Lukrake bladsy uit die toetswiki',
	'randombytest-nopages' => 'Daar is geen bladsye in jou toetswiki in die $1-naamruimte nie.',
);

/** Arabic (العربية)
 * @author Ciphers
 * @author Meno25
 * @author Orango
 * @author OsamaK
 */
$messages['ar'] = array(
	'wminc-desc' => 'جرّب نظام الويكي لحضانة ويكيميديا',
	'wminc-viewuserlang' => 'أوجد لغة المستخدم و جرّب الويكي',
	'wminc-viewuserlang-user' => 'اسم المستخدم:',
	'wminc-viewuserlang-go' => 'اذهب',
	'wminc-testwiki' => 'ويكي الاختبار:',
	'wminc-testwiki-none' => 'لا شيء/الكل',
	'wminc-prefinfo-language' => 'لغة واجهتك - مستقلة عن ويكي الاختبار',
	'wminc-prefinfo-code' => 'رمز ISO 639 للغة',
	'wminc-prefinfo-project' => 'إختر مشروع ويكيميديا (خيار الحضانة هو للمستخدمين الذين يقومون بعمل عام)',
	'wminc-prefinfo-error' => 'اخترت مشروعًا يختاج رمز لغة.',
	'wminc-warning-unprefixed' => "'''تحذير:''' الصفحة التي تعدلها بدون بادئة!",
	'wminc-warning-suggest' => 'تستطيع إنشاء صفحة في [[$1]].',
	'wminc-warning-suggest-move' => 'يمكنك [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} نقل الصفحة إلى $1].',
	'right-viewuserlang' => 'رؤية [[Special:ViewUserLang|لغة وويكي الاختبار الخاص بالمستخدم]]',
	'randombytest' => 'صفحة عشوائية بواسطة ويكي الاختبار',
	'randombytest-nopages' => 'لا توجد صفحات في ويكي الاختبار الخاص بك، في النطاق: $1.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'wminc-viewuserlang-user' => 'ܫܡܐ ܕܡܦܠܚܢܐ:',
	'wminc-viewuserlang-go' => 'ܙܠ',
	'wminc-testwiki' => 'ܘܝܩܝ ܢܣܝܘܢܐ:',
	'wminc-testwiki-none' => 'ܠܐ ܡܕܡ/ܟܠ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'wminc-viewuserlang-user' => 'اسم اليوزر:',
	'wminc-viewuserlang-go' => 'روح',
	'wminc-testwiki' => 'ويكى تجربه:',
	'wminc-testwiki-none' => 'ولاحاجه/كل',
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'wminc-viewuserlang-user' => 'Benutzanãm:',
	'wminc-viewuserlang-go' => 'Hoin',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Koane/Ålle',
	'wminc-prefinfo-language' => 'Språch vu deina Benutzaowaflächn – vum Testwiki åbhängig',
	'wminc-prefinfo-code' => 'Da ISO-639-Språchcode',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'wminc-desc' => 'Тэставая вікі-сыстэма для інкубатара фундацыі «Вікімэдыя»',
	'wminc-viewuserlang' => 'Пошук мовы ўдзельніка і тэставай вікі',
	'wminc-viewuserlang-user' => 'Імя ўдзельніка:',
	'wminc-viewuserlang-go' => 'Перайсьці',
	'wminc-testwiki' => 'Тэставая вікі:',
	'wminc-testwiki-none' => 'Ніякая/усе',
	'wminc-prefinfo-language' => 'Вашая мова інтэрфэйсу — незалежная ад мовы Вашай тэставай вікі',
	'wminc-prefinfo-code' => 'Код мовы ISO 639',
	'wminc-prefinfo-project' => 'Выберыце праект фундацыі «Вікімэдыя» (устаноўка інкубатара для ўдзельнікаў, якія займаецца асноўнай працай)',
	'wminc-prefinfo-error' => 'Вы выбралі праект, які патрабуе код мовы.',
	'wminc-warning-unprefixed' => 'Папярэджаньне: старонка, якую Вы рэдагуеце, ня мае прэфікса!',
	'wminc-warning-suggest' => 'Вы можаце стварыць старонку [[$1]].',
	'wminc-warning-suggest-move' => 'Вы можаце [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} перанесьці гэту старонку ў $1].',
	'right-viewuserlang' => 'прагляд [[Special:ViewUserLang|мовы ўдзельніка і тэставаньне вікі]]',
	'randombytest' => 'Выпадковая старонка тэставай вікі',
	'randombytest-nopages' => 'Няма старонак ў Вашай тэставай вікі, у прасторы назваў: $1.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Stanqo
 */
$messages['bg'] = array(
	'wminc-desc' => 'Тестова уики система за Инкубатора на Уикимедия',
	'wminc-viewuserlang' => 'Справка за езика на потребителя и тестваното от него уики',
	'wminc-viewuserlang-user' => 'Потребител:',
	'wminc-viewuserlang-go' => 'Търсене',
	'wminc-testwiki' => 'Тестово уики:',
	'wminc-testwiki-none' => 'Никои / Всички',
	'wminc-prefinfo-language' => 'Език на интерфейса (независим от езика на вашето тестово уики)',
	'wminc-prefinfo-code' => 'Езиковият код според стандарта ISO 639',
	'wminc-prefinfo-project' => 'Изберете проект на Уикимедия (Опцията инкубатор е за потребители, които извършват обща работа)',
	'wminc-prefinfo-error' => 'Избрали сте проект, който се нуждае от езиков код.',
	'wminc-warning-unprefixed' => "'''Внимание:''' В заглавието на редактираната от вас страница липсва префикс!",
	'wminc-warning-suggest' => 'Можете да създадете страница на [[$1]].',
	'wminc-warning-suggest-move' => 'Можете да [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} преместите тази страница като $1].',
	'right-viewuserlang' => 'Вижте [[Special:ViewUserLang|езика на потребителя и езика на тестваното уики]]',
	'randombytest' => 'Случайна страница от тестваното уики',
	'randombytest-nopages' => 'В тестваното уики няма страници в именно пространство $1.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'wminc-desc' => 'উইকিমিডিয়া ইনকিউবেটরের জন্য পরীক্ষামূলক উইকি ব্যবস্থা',
	'wminc-viewuserlang' => 'ব্যবহারকারী ভাষা এবং পরীক্ষামূলক উইকি দেখুন',
	'wminc-viewuserlang-user' => 'ব্যবহারকারী নাম:',
	'wminc-viewuserlang-go' => 'যাও',
	'wminc-testwiki' => 'পরীক্ষামূলক উইকি:',
	'wminc-testwiki-none' => 'কিছু না/সমস্ত',
	'wminc-prefinfo-language' => 'আপনার ইন্টারফেস ভাষা - আপনার পরীক্ষামূলক উইকি হতে স্বাধীন',
	'wminc-prefinfo-code' => 'ISO 639 ভাষা কোড',
	'wminc-prefinfo-error' => 'আপনার নির্বাচিত প্রকল্পের ভাষার কোড প্রয়োজন।',
	'wminc-warning-suggest' => '[[$1]] তে আপনি পাতা তৈরি করতে পারেন।',
	'wminc-warning-suggest-move' => 'আপনি [ $1 এ {{fullurl:Special:MovePage/$3|wpNewTitle=$2}} এই পাতা সরিয়ে নিতে পারেন]।',
	'right-viewuserlang' => '[[Special:ViewUserLang|ব্যবহারকারী ভাষা এবং পরীক্ষামূলক উইকি]] দেখাও',
	'randombytest' => 'পরীক্ষামূলক উইকির অজানা পাতা',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'wminc-desc' => 'Reizhiad testiñ wiki evit Wikimedia Incubator',
	'wminc-viewuserlang' => 'Gwelet yezh an implijer hag e wiki testiñ',
	'wminc-viewuserlang-user' => 'Anv implijer :',
	'wminc-viewuserlang-go' => 'Mont',
	'wminc-testwiki' => 'Wiki testiñ :',
	'wminc-testwiki-none' => 'Hini ebet / An holl',
	'wminc-prefinfo-language' => "Yezh hoc'h etrefas - distag diouzh hini ho wiki testiñ",
	'wminc-prefinfo-code' => 'Kod ISO 639 ar yezh',
	'wminc-prefinfo-project' => 'Diuzit ar raktres Wikimedia (miret eo an dibarzh Incubator evit an implijerien a gas da benn ul labour dre vras)',
	'wminc-prefinfo-error' => "Diuzet hoc'h eus ur raktres zo ezhomm ur c'hod yezh evitañ.",
	'wminc-warning-unprefixed' => "'''Diwallit : ''' Emaoc'h oc'h aozañ ur bajenn hep rakger ebet dezhi !",
	'wminc-warning-suggest' => 'Gallout a rit krouiñ ur bajenn war [[$1]].',
	'wminc-warning-suggest-move' => 'Gallout a rit [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} adenvel ar bajenn-mañ e $1].',
	'right-viewuserlang' => 'Gwelet [[Special:ViewUserLang|yezh an implijer hag ar wiki testiñ]]',
	'randombytest' => 'Pajenn dargouezhek gant ar wiki amprouiñ',
	'randombytest-nopages' => "N'eus pajenn ebet en ho wiki amprouiñ, en esaouenn anv : $1.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'wminc-desc' => 'Testiranje wiki sistema za Wikimedia Incubator',
	'wminc-viewuserlang' => 'Pregledaj korisnički jezik i testiranu wiki',
	'wminc-viewuserlang-user' => 'Korisničko ime:',
	'wminc-viewuserlang-go' => 'Idi',
	'wminc-testwiki' => 'Testna wiki:',
	'wminc-testwiki-none' => 'Ništa/Sve',
	'wminc-prefinfo-language' => 'Vaš jezik interfejsa - nezavisno od Vaše testirane wiki',
	'wminc-prefinfo-code' => 'ISO 639 kod jezika',
	'wminc-prefinfo-project' => 'Odaberite Wikimedia projekat (Opcija u inkubatoru za korisnike koje rade opći posao)',
	'wminc-prefinfo-error' => 'Odabrali ste projekat koji zahtijeva kod jezika.',
	'wminc-warning-unprefixed' => 'Upozorenje: stranica koju uređujete nema prefiksa!',
	'wminc-warning-suggest' => 'Možete napraviti stranicu na [[$1]].',
	'wminc-warning-suggest-move' => 'Možete [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} premjestiti ovu stranicu na $1].',
	'right-viewuserlang' => 'Pregledavanje [[Special:ViewUserLang|korisničkog jezika i probne wiki]]',
	'randombytest' => 'Slučajna stranica od testirane wiki',
	'randombytest-nopages' => 'Nema stranica u Vašoj probnoj wiki, u imenskom prostoru: $1.',
);

/** Catalan (Català)
 * @author Paucabot
 * @author Solde
 */
$messages['ca'] = array(
	'wminc-viewuserlang-user' => "Nom d'usuari:",
	'wminc-viewuserlang-go' => 'Vés-hi!',
	'wminc-testwiki-none' => 'Cap/Tots',
	'wminc-prefinfo-code' => 'El codi de llengua ISO 639',
);

/** Sorani (Arabic script) (‫کوردی (عەرەبی)‬)
 * @author Marmzok
 */
$messages['ckb-arab'] = array(
	'wminc-viewuserlang-user' => 'ناوی بەکارهێنەری:',
	'wminc-viewuserlang-go' => 'بڕۆ',
	'wminc-testwiki' => 'تاقی‌کردنه‌وه‌ی ویکی:',
	'wminc-testwiki-none' => 'هیچیان\\هەموویان',
	'wminc-prefinfo-language' => 'ڕووکاری زمانی تۆ جیاوازه‌ له‌ تاقی کردنه‌وه‌ی ویکی',
	'wminc-prefinfo-code' => 'کۆدی زمانی ISO 639',
	'wminc-prefinfo-error' => 'پڕۆژەیەکت هەڵبژاردووه کە پێویستی بە کۆدی زمانە.',
	'wminc-warning-suggest' => 'دەتوانی لاپەڕەیەک لە [[$1]]دا درووست‌بکەی.',
	'wminc-warning-suggest-move' => '',
);

/** Czech (Česky)
 * @author Kuvaly
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'wminc-desc' => 'Testovací wiki systém pro Inkubátor Wikimedia',
	'wminc-viewuserlang' => 'Vyhledat jazyk uživatele a testovací wiki',
	'wminc-viewuserlang-user' => 'Uživatelské jméno:',
	'wminc-viewuserlang-go' => 'Přejít',
	'wminc-testwiki' => 'Testovací wiki:',
	'wminc-testwiki-none' => 'Nic/vše',
	'wminc-prefinfo-language' => 'Váš jazyk rozhraní – nezávislý na vaší testovací wiki',
	'wminc-prefinfo-code' => 'Jazykový kód ISO 639',
	'wminc-prefinfo-project' => 'Vybrat projekt Wikimedia (možnost „Inkubátor“ je pro uživatele, kteří vykonávají všeobecnou činnost)',
	'wminc-prefinfo-error' => 'Vybrali jste projekt, který vyžaduje kód jazyku.',
	'wminc-warning-unprefixed' => "'''Upozornění:''' Stránka, kterou upravujete je bez prefixu!",
	'wminc-warning-suggest' => 'Můžete vytvořit stránku na [[$1]].',
	'wminc-warning-suggest-move' => 'Můžete [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} přesunout tuto stránku na $1].',
	'right-viewuserlang' => 'Prohlížení [[Special:ViewUserLang|uživatelského jazyka a testovací wiki]]',
	'randombytest' => 'Náhodná stránka z testovací wiki',
	'randombytest-nopages' => 'Ve vaší testovací wiki nejsou ve jmenném prostoru $1 žádné stránky.',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Masz
 */
$messages['da'] = array(
	'wminc-desc' => 'Testwikisystem for Wikimedia Incubator',
	'wminc-viewuserlang-user' => 'Brugernavn:',
	'wminc-viewuserlang-go' => 'Gå',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Ingen/Alle',
);

/** German (Deutsch)
 * @author Imre
 * @author MF-Warburg
 * @author Umherirrender
 */
$messages['de'] = array(
	'wminc-desc' => 'Testwiki-System für den Wikimedia Incubator',
	'wminc-viewuserlang' => 'Benutzersprache und Testwiki einsehen',
	'wminc-viewuserlang-user' => 'Benutzername:',
	'wminc-viewuserlang-go' => 'Holen',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Keins/Alle',
	'wminc-prefinfo-language' => 'Sprache deiner Benutzeroberfläche - vom Testwiki unabhängig',
	'wminc-prefinfo-code' => 'Der ISO-639-Sprachcode',
	'wminc-prefinfo-project' => 'Das Wikimedia-Projekt, an dem du hier arbeitest („Incubator“ für Benutzer, die allgemeine Aufgaben übernehmen)',
	'wminc-prefinfo-error' => 'Bei diesem Projekt muss ein Sprachcode angeben werden!',
	'wminc-warning-unprefixed' => 'Achtung: Du bearbeitest eine Seite ohne Präfix!',
	'wminc-warning-suggest' => 'Du kannst hier eine Seite erstellen: [[$1]].',
	'wminc-warning-suggest-move' => 'Du kannst [{{fullurl:{{#special:MovePage}}/$3|wpNewTitle=$2}} diese Seite nach $1 verschieben].',
	'right-viewuserlang' => '[[Special:ViewUserLang|Benutzersprache und Testwiki]] anschauen',
	'randombytest' => 'Zufällige Seite aus dem Testwiki',
	'randombytest-nopages' => 'Es befinden sich keine Seiten im Namensraum „$1“ deines Testwikis.',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author MF-Warburg
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'wminc-prefinfo-language' => 'Sprache Ihrer Benutzeroberfläche - vom Testwiki unabhängig',
	'wminc-prefinfo-project' => 'Das Wikimedia-Projekt, an dem Sie hier arbeiten („Incubator“ für Benutzer, die allgemeine Aufgaben übernehmen)',
	'wminc-warning-unprefixed' => 'Achtung: Sie bearbeiten eine Seite ohne Präfix!',
	'wminc-warning-suggest' => 'Sie können hier eine Seite erstellen: [[$1]].',
	'wminc-warning-suggest-move' => 'Sie können [{{fullurl:{{#special:MovePage}}/$3|wpNewTitle=$2}} diese Seite nach $1 verschieben].',
	'randombytest-nopages' => 'Es befinden sich keine Seiten im Namensraum „$1“ Ihres Testwikis.',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'wminc-viewuserlang-user' => 'Namey karberi:',
	'wminc-viewuserlang-go' => 'Şo',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'wminc-desc' => 'Testowy wikijowy system za Wikimedia Incubator',
	'wminc-viewuserlang' => 'Wužywarsku rěc a testowy wiki se woglědaś',
	'wminc-viewuserlang-user' => 'Wužywarske mě:',
	'wminc-viewuserlang-go' => 'Pokazaś',
	'wminc-testwiki' => 'Testowy wiki:',
	'wminc-testwiki-none' => 'Žeden/Wše',
	'wminc-prefinfo-language' => 'Rěc twójogo wužywarskego pówjercha - wót twójogo testowego wikija njewótwisna',
	'wminc-prefinfo-code' => 'Rěcny kod ISO 639',
	'wminc-prefinfo-project' => 'Wikimedijowy projekt wubraś (Incubatorowa opcija jo za wužywarjow, kótarež cynje powšykne źěło)',
	'wminc-prefinfo-error' => 'Sy projekt wubrał, kótaryž se rěcny kod pomina.',
	'wminc-warning-unprefixed' => 'Warnowanje: bok, kótaryž wobźěłujoš, njama prefiks!',
	'wminc-warning-suggest' => 'Móžoš na [[$1]] bok napóraś.',
	'wminc-warning-suggest-move' => 'Móžoš [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} toś ten bok do $1 pśesunuś].',
	'right-viewuserlang' => '[[Special:ViewUserLang|Wužywarsku rěc a testowy wiki]] se woglědaś',
	'randombytest' => 'Pśipadny bok pó testowem wikiju',
	'randombytest-nopages' => 'W twójom testowem wikiju w mjenjowem rumje $1 boki njejsu.',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'wminc-desc' => 'Δοκιμή του συστήματος βίκι για το Wikimedia Incubator',
	'wminc-viewuserlang' => 'Ανατρέξτε στη γλώσσα χρήστη και στο δοκιμαστικό βίκι',
	'wminc-viewuserlang-user' => 'Όνομα χρήστη:',
	'wminc-viewuserlang-go' => 'Μετάβαση',
	'wminc-testwiki' => 'Δοκιμαστικό wiki:',
	'wminc-testwiki-none' => 'Κανένα/Όλα',
	'wminc-prefinfo-language' => 'Η γλώσσα συστήματος - ανεξάρτητη από το δοκιμαστικό σας βίκι',
	'wminc-prefinfo-code' => 'Ο κωδικός γλώσσας ISO 639',
	'wminc-prefinfo-project' => 'Επιλογή του εγχειρήματος Wikimedia (η επιλογή Incubator είναι για όσους χρήστες κάνουν γενική δουλειά)',
	'wminc-prefinfo-error' => 'Επιλέξατε ένα σχέδιο που χρειάζεται ένα κωδικό γλώσσας.',
	'wminc-warning-unprefixed' => "'''Προειδοποίηση:''' Η σελίδα που επεξεργάζεστε είναι χωρίς πρόθεμα!",
	'wminc-warning-suggest' => 'Μπορείτε να δημιουργήσετε μια σελίδα στο [[$1]].',
	'wminc-warning-suggest-move' => 'Μπορείτε να [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} μετακινήσετε αυτή τη σελίδα στο $1].',
	'right-viewuserlang' => 'Προβολή της [[Special:ViewUserLang|γλώσσας χρήστη και του δοκιμαστικού βίκι]]',
	'randombytest' => 'Τυχαία σελίδα βάσει του δοκιμαστικού βίκι',
	'randombytest-nopages' => 'Δεν υπάρχουν σελίδες στο wiki δοκιμής σας, στις περιοχές ονομάτων: $1.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'wminc-desc' => 'Testa vikisistemo por Wikimedia-Inkubatoro',
	'wminc-viewuserlang' => 'Trarigardi uzulan lingvon kaj testi vikion',
	'wminc-viewuserlang-user' => 'Salutnomo:',
	'wminc-viewuserlang-go' => 'Ek',
	'wminc-testwiki' => 'Prova vikio:',
	'wminc-testwiki-none' => 'Nenio/Ĉio',
	'wminc-prefinfo-language' => 'Via interfaca lingvo - sendepende de via prova vikio',
	'wminc-prefinfo-code' => 'La lingvo kodo ISO 639',
	'wminc-prefinfo-error' => 'Vi elektis projekton kiu bezonas lingvan kodon.',
	'wminc-warning-unprefixed' => "'''Averto:''' La paĝon kiun vi redaktas estas senprefiksa!",
	'wminc-warning-suggest' => 'Vi povas krei paĝon ĉe [[$1]].',
	'wminc-warning-suggest-move' => 'Vi povas [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} movi ĉi tiun paĝon al $1].',
	'right-viewuserlang' => 'Vidi [[Special:ViewUserLang|uzulan lingvon kaj testvikion]]',
	'randombytest' => 'Hazarda paĝo de testvikio',
	'randombytest-nopages' => 'Mankas paĝoj en via testvikio en la nomspaco: $1.',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Translationista
 */
$messages['es'] = array(
	'wminc-desc' => 'Sistema de wiki de prueba para Wikimedia Incubator',
	'wminc-viewuserlang' => 'Ver lenguaje de usuario y wiki de prueba',
	'wminc-viewuserlang-user' => 'Nombre de usuario:',
	'wminc-viewuserlang-go' => 'Ir',
	'wminc-testwiki' => 'Wiki de prueba:',
	'wminc-testwiki-none' => 'Ninguno/Todo',
	'wminc-prefinfo-language' => 'Tu idioma de interface - independiente de tu wiki de prueba',
	'wminc-prefinfo-code' => 'El código de idioma ISO 639',
	'wminc-prefinfo-project' => 'Seleccionar el proyecto wikimedia (opción Incubator es para usuarios que hacen trabajo general)',
	'wminc-prefinfo-error' => 'Seleccionaste un proyecto que necesita un código de lenguaje.',
	'wminc-warning-unprefixed' => 'Advertencia: la página que estás editando está sin prefijo!',
	'wminc-warning-suggest' => 'Puedes crear una página en [[$1]].',
	'wminc-warning-suggest-move' => 'Puedes [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} mover esta página a $1].',
	'right-viewuserlang' => 'Ver [[Special:ViewUserLang|idioma de usuario y prueba wiki]]',
	'randombytest' => 'Página aleatoria para probar wiki',
	'randombytest-nopages' => 'No hay páginas en su wiki de prueba, en el espacio de nombres: $1.',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'wminc-viewuserlang-user' => 'Kasutajanimi:',
	'wminc-viewuserlang-go' => 'Mine',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'wminc-desc' => 'Wikimedia Incubatorrerako wiki proba sistema',
	'wminc-viewuserlang' => 'Lankidearen hizkuntza eta probazko wikia ikusi',
	'wminc-viewuserlang-user' => 'Erabiltzaile izena:',
	'wminc-viewuserlang-go' => 'Joan',
	'wminc-testwiki' => 'Probazko wikia:',
	'wminc-testwiki-none' => 'Bat ere ez/Guztiak',
	'wminc-prefinfo-language' => 'Zure interfazearen hizkuntza - Wiki probatik independentea da',
	'wminc-prefinfo-code' => 'ISO 639 hizkuntza kodea',
	'wminc-prefinfo-project' => 'Aukeratu Wikimedia proiektua (Incubator aukera lan orokorra egiten dutenentzako da)',
	'wminc-prefinfo-error' => 'Hizkuntza-kodea behar duen proiektua aukeratu duzu.',
	'wminc-warning-unprefixed' => "'''Abisua:''' Editatzen ari zaren orrialdeak ez du aurrizkirik!",
	'wminc-warning-suggest' => '[[$1]]-(e)an orrialdea sortu dezakezu.',
	'wminc-warning-suggest-move' => 'Orrialde hau [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} $1-(e)ra mugitu dezakezu].',
	'right-viewuserlang' => 'Ikusi [[Special:ViewUserLang|lankide hizkuntza eta wiki testa]]',
	'randombytest' => 'Wiiki testaren ausazko orria',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Silvonen
 * @author Str4nd
 * @author Varusmies
 */
$messages['fi'] = array(
	'wminc-desc' => 'Testiwiki-järjestelmä Wikimedia-hautomoa varten',
	'wminc-viewuserlang' => 'Hae esiin käyttäjän kieli ja testiwiki',
	'wminc-viewuserlang-user' => 'Käyttäjätunnus:',
	'wminc-viewuserlang-go' => 'Siirry',
	'wminc-testwiki' => 'Testiwiki:',
	'wminc-testwiki-none' => 'Ei lainkaan/Kaikki',
	'wminc-prefinfo-language' => 'Käyttöliittymän kieli – riippumaton testiwikistäsi',
	'wminc-prefinfo-code' => 'ISO 639:n mukainen kielilyhennekoodi',
	'wminc-prefinfo-project' => 'Valitse Wikimedia-hanke (Hautomossa tätä käyttävät ne jotka toimittavat yleisluontoisia askareita)',
	'wminc-prefinfo-error' => 'Olet valinnut hankkeen, joka vaatii kielikoodin.',
	'wminc-warning-unprefixed' => "'''Varoitus:''' Sivu, jota muokkaat on etuliitteetön.",
	'wminc-warning-suggest' => 'Voit luoda sivun nimelle [[$1]].',
	'wminc-warning-suggest-move' => 'Voit [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} siirtää tämän sivun nimelle $1].',
	'right-viewuserlang' => 'Nähdä [[Special:ViewUserLang|käyttäjän kieli ja testiwiki]]',
	'randombytest' => 'Satunnainen sivu testiwikistä',
	'randombytest-nopages' => 'Testiwikisi nimiavaruudessa $1 ei ole sivuja.',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'wminc-desc' => 'Système de test de wiki pour Wikimedia Incubator',
	'wminc-viewuserlang' => 'Voir la langue de l’utilisateur et son wiki de test',
	'wminc-viewuserlang-user' => "Nom d'utilisateur :",
	'wminc-viewuserlang-go' => 'Aller',
	'wminc-testwiki' => 'Wiki de test :',
	'wminc-testwiki-none' => 'Aucun / tous',
	'wminc-prefinfo-language' => 'Votre langue de l’interface - indépendante de votre wiki de test',
	'wminc-prefinfo-code' => 'Le code ISO 639 de la langue',
	'wminc-prefinfo-project' => 'Sélectionnez le projet Wikimedia (l’option Incubator est destinée aux utilisateurs qui font un travail général)',
	'wminc-prefinfo-error' => 'Vous avez sélectionné un projet qui nécessite un code de langue.',
	'wminc-warning-unprefixed' => "'''Attention :''' la page que vous modifiez n’a pas de préfixe !",
	'wminc-warning-suggest' => 'Vous pouvez créer la page à [[$1]].',
	'wminc-warning-suggest-move' => 'Vous pouvez [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} renommer cette page vers $1].',
	'right-viewuserlang' => 'Voir [[Special:ViewUserLang|la langue de l’utilisateur et le wiki de test]]',
	'randombytest' => 'Page aléatoire par le wiki de test',
	'randombytest-nopages' => "Votre wiki de test ne contient pas de page dans l'espace de noms : $1.",
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'wminc-viewuserlang-user' => 'Nom d’utilisator :',
	'wminc-viewuserlang-go' => 'Alar trovar',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wminc-desc' => 'Sistema wiki de probas para a Incubadora da Wikimedia',
	'wminc-viewuserlang' => 'Olle a lingua de usuario e o wiki de proba',
	'wminc-viewuserlang-user' => 'Nome de usuario:',
	'wminc-viewuserlang-go' => 'Ir',
	'wminc-testwiki' => 'Wiki de proba:',
	'wminc-testwiki-none' => 'Ningún/Todos',
	'wminc-prefinfo-language' => 'A súa lingua da interface (independente do seu wiki de proba)',
	'wminc-prefinfo-code' => 'O código de lingua ISO 639',
	'wminc-prefinfo-project' => 'Seleccione o proxecto Wikimedia (a opción da Incubadora é para os usuarios que fan traballo xeral)',
	'wminc-prefinfo-error' => 'Escolleu un proxecto que precisa dun código de lingua.',
	'wminc-warning-unprefixed' => 'Aviso: a páxina que está editando non ten prefixo!',
	'wminc-warning-suggest' => 'Pode crear a páxina en "[[$1]]".',
	'wminc-warning-suggest-move' => 'Pode [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} mover esta páxina a "$1"].',
	'right-viewuserlang' => 'Ver [[Special:ViewUserLang|a lingua do usuario e o wiki de probas]]',
	'randombytest' => 'Páxina ao chou para o wiki de proba',
	'randombytest-nopages' => 'O seu wiki de proba aínda non ten páxinas no espazo de nomes: $1.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'wminc-viewuserlang-user' => 'Ὄνομα χρωμένου:',
	'wminc-viewuserlang-go' => 'Ἰέναι',
	'wminc-testwiki' => 'Βίκι δοκιμή:',
	'wminc-testwiki-none' => 'Οὐδέν/Ἅπαντα',
	'wminc-prefinfo-code' => 'Ὁ κῶδιξ γλώσσης ISO 639',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'wminc-desc' => 'Teschtwiki-Syschtem fir dr Wikimedia Incubator',
	'wminc-viewuserlang' => 'Benutzersproch un Teschtwiki aaluege',
	'wminc-viewuserlang-user' => 'Benutzername:',
	'wminc-viewuserlang-go' => 'Gang ane',
	'wminc-testwiki' => 'Teschtwiki:',
	'wminc-testwiki-none' => 'Keis/Alli',
	'wminc-prefinfo-language' => 'Sproch vu Dyyre Benutzeroberflächi - nit abhängig vum Teschtwiki',
	'wminc-prefinfo-code' => 'Dr ISO-639-Sprochcode',
	'wminc-prefinfo-project' => 'S Wikimedia-Projäkt, wu du dra schaffsch („Incubator“ fir Benutzer, wu allgmeini Ufgabe ibernämme)',
	'wminc-prefinfo-error' => 'Du hesch e Projäkt uusgwehlt, wu s e Sprochcode derfir brucht.',
	'wminc-warning-unprefixed' => 'Obacht: Du bearbeitsch e Syte ohni Präfix!',
	'wminc-warning-suggest' => 'Do chasch e Syte aalege: [[$1]].',
	'wminc-warning-suggest-move' => 'Du chasch [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} die Syte no $1 verschiebe].',
	'right-viewuserlang' => '[[Special:ViewUserLang|D Benutzersproch und s Teschtwiki]] aaluege',
	'randombytest' => 'Zuefallssyte no Teschtwiki',
	'randombytest-nopages' => 'S git kei Syte im Namensruum $1 in Dyym Teschtwiki.',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 */
$messages['gu'] = array(
	'wminc-desc' => 'વિકિમીડિયા ઇનક્યુબેટર માટે પરિક્ષણ વિકિ પ્રણાલી',
	'wminc-viewuserlang' => 'સભ્ય ભાષા અને પરિક્ષણ વિકિ જુઓ',
	'wminc-viewuserlang-user' => 'સભ્યનામ:',
	'wminc-viewuserlang-go' => 'જાઓ',
	'wminc-testwiki' => 'પરિક્ષણ વિકિ:',
	'wminc-testwiki-none' => 'કોઇ પણ નહીં/તમામ',
	'wminc-prefinfo-language' => 'તમારી ઇન્ટરફેસ ભાષા - તમારા પરિક્ષણ વિકિથી સ્વતંત્ર',
	'wminc-prefinfo-code' => 'ISO ૬૩૯ ભાષા સંજ્ઞા',
	'wminc-prefinfo-project' => 'વિકિમીડિયા યોજના પસંદ કરો (સામાન્ય કાર્ય કરતા સભ્ય માટે ઇનક્યુબેટર વિકલ્પ)',
	'wminc-prefinfo-error' => 'તમે પસંદ કરેલ યોજના માટે ભાષા સંજ્ઞા જરૂરી છે.',
	'wminc-warning-unprefixed' => "'''ચેતાવણી:''' તમે જે પાનું સંપાદન કરી રહ્યા છો તે ઉપસર્ગરહીત છે!",
	'wminc-warning-suggest' => 'તમે [[$1]] પર પાનું બનાવી શકો છો.',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'wminc-desc' => 'מערכת אתרי ויקי נסיוניים עבור האינקובטור של ויקימדיה',
	'wminc-viewuserlang' => 'חיפוש שפת משתמש ואתר ויקי נסיוני',
	'wminc-viewuserlang-user' => 'שם המשתמש:',
	'wminc-viewuserlang-go' => 'הצגה',
	'wminc-testwiki' => 'אתר ויקי נסיוני:',
	'wminc-testwiki-none' => 'הכול/כלום',
	'wminc-prefinfo-language' => 'שפת הממשק שלכם - בלתי תלויה באתר הוויקי הנסיוני שלכם',
	'wminc-prefinfo-code' => 'קוד השפה לפי ISO 639',
	'wminc-prefinfo-project' => 'בחרו אחד ממיזמי ויקימדיה (האפשרות "אינקובטור" מיועדת למשתמשים המבצעים עבודה כללית)',
	'wminc-prefinfo-error' => 'בחרתם במיזם הדורש קוד שפה.',
	'wminc-warning-unprefixed' => "'''אזהרה:''' לדף שאתם עורכים אין קידומת!",
	'wminc-warning-suggest' => 'באפשרותכם ליצור דף בשם [[$1]].',
	'wminc-warning-suggest-move' => 'באפשרותכם [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} להעביר דף זה ל$1].',
	'right-viewuserlang' => 'צפייה ב[[Special:ViewUserLang|שפת המשתמש ואתר הוויקי הנסיוני]]',
	'randombytest' => 'דף אקראי באתר ויקי נסיוני',
	'randombytest-nopages' => 'אין דפים באתר הוויקי הנסיוני שלכם, במרחב השם: $1.',
);

/** Hiligaynon (Ilonggo)
 * @author Tagimata
 */
$messages['hil'] = array(
	'wminc-desc' => 'Testing nga sistema wiki para sa Wikimedia Inkyubeytor',
	'wminc-viewuserlang' => 'Tan-awon ang user halamabalanon kag pagtilaw wiki',
	'wminc-viewuserlang-user' => 'Usarngalan:',
	'wminc-viewuserlang-go' => 'Lakat',
	'wminc-testwiki' => 'Pagtilaw wiki:',
	'wminc-testwiki-none' => 'Wala/Tanan',
	'wminc-prefinfo-language' => 'Ang imo hambalanon nga interface - kahilwayan halin sa imo pagtilaw wiki',
	'wminc-prefinfo-code' => 'Ang ISO 639 lengwahe koda',
	'wminc-prefinfo-project' => 'Pilion ang Wikimedia proyekto (Inkyubeytor pilili-an ar para sa mga user nga nagahimo sang kabilugan nga obra)',
	'wminc-prefinfo-error' => 'Ginpili mo nga proyekto nga naga kilanlan sang lengwahe koda.',
	'wminc-warning-unprefixed' => "'''Pa-andam:''' Ini nga pahina nga imo gina-islan ay diprefiks!",
	'wminc-warning-suggest' => 'Makahimo ka pahina sa [[$1]].',
	'wminc-warning-suggest-move' => 'Pwede mo [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} magiho ini nga pahina sa $1].',
	'right-viewuserlang' => 'Tan-awon [[Special:ViewUserLang|user lengwahe kag pagtilaw wiki]]',
	'randombytest' => 'Ginpalagpat-pagpili nga pahina sang test wiki',
	'randombytest-nopages' => 'Wala sang mga pahina sa imo nga test wiki, sa may ngalanespasyo: $1.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'wminc-desc' => 'Testowy wikijowy system za Wikimedia Incubator',
	'wminc-viewuserlang' => 'Wužiwarsku rěč a testowy wiki sej wobhladać',
	'wminc-viewuserlang-user' => 'Wužiwarske mjeno:',
	'wminc-viewuserlang-go' => 'Pokazać',
	'wminc-testwiki' => 'Testowy wiki:',
	'wminc-testwiki-none' => 'Žadyn/Wšě',
	'wminc-prefinfo-language' => 'Rěč twojeho wužiwarskeho powjercha - wot twojeho testoweho wikija njewotwisna',
	'wminc-prefinfo-code' => 'Rěčny kod ISO 639',
	'wminc-prefinfo-project' => 'Wikimedijowy projekt wubrać (Incubatorowa opcija je za wužiwarjow, kotřiž powšitkowne dźěło činja)',
	'wminc-prefinfo-error' => 'Sy projekt wubrał, kotryž sej rěčny kod wužaduje.',
	'wminc-warning-unprefixed' => 'Warnowanje: strona, kotruž wobdźěłuješ, nima prefiks!',
	'wminc-warning-suggest' => 'Móžeš na [[$1]] stronu wutworić.',
	'wminc-warning-suggest-move' => 'Móžeš [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} tutu stronu do $1 přesunyć].',
	'right-viewuserlang' => '[[Special:ViewUserLang|Wužiwarsku rěč a testowy wiki]] sej wobhladać',
	'randombytest' => 'Připadna strona po testowym wikiju',
	'randombytest-nopages' => 'W twojim testowym wikiju w mjenowym rumje $1 strony njejsu.',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'wminc-desc' => 'Tesztwiki rendszer a Wikimédia Inkubátorhoz',
	'wminc-viewuserlang' => 'Felhasználó nyelvének és a tesztwikinek a felkeresése',
	'wminc-viewuserlang-user' => 'Felhasználói név:',
	'wminc-viewuserlang-go' => 'Menj',
	'wminc-testwiki' => 'Tesztwiki:',
	'wminc-testwiki-none' => 'Egyik sem/Mind',
	'wminc-prefinfo-language' => 'A felhasználói felületed nyelve – független a teszt wikidtől',
	'wminc-prefinfo-code' => 'Az ISO 639 szerinti nyelvkód',
	'wminc-prefinfo-project' => 'Válaszd ki a Wikimédia projektet (az inkubátor választási lehetőség azoknak a felhasználóknak szól, akik általános munkát végeznek)',
	'wminc-prefinfo-error' => 'Olyan projektet választottál, amihez szükség van nyelvkódra.',
	'wminc-warning-unprefixed' => "'''Figyelmeztetés:''' nincs előtagja a lapnak, amit szerkesztesz!",
	'wminc-warning-suggest' => 'Létrehozhatsz lapot a(z) [[$1]] címen.',
	'wminc-warning-suggest-move' => '[{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} Átnevezheted a lapot erre: $1].',
	'right-viewuserlang' => '[[Special:ViewUserLang|felhasználó nyelv és teszt wiki]] megjelenítése',
	'randombytest' => 'Véletlen lap a tesztwikiből',
	'randombytest-nopages' => 'Nincsenek lapok a teszt wikid $1 névterében.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wminc-desc' => 'Systema pro wikis de test in Wikimedia Incubator',
	'wminc-viewuserlang' => 'Vider le lingua de un usator e su wiki de test',
	'wminc-viewuserlang-user' => 'Nomine de usator:',
	'wminc-viewuserlang-go' => 'Ir',
	'wminc-testwiki' => 'Wiki de test:',
	'wminc-testwiki-none' => 'Nulle/Totes',
	'wminc-prefinfo-language' => 'Le lingua de tu interfacie - independente de tu wiki de test',
	'wminc-prefinfo-code' => 'Le codice ISO 639 del lingua',
	'wminc-prefinfo-project' => 'Selige le projecto Wikimedia (le option Incubator es pro usatores qui face labor general)',
	'wminc-prefinfo-error' => 'Tu seligeva un projecto que require un codice de lingua.',
	'wminc-warning-unprefixed' => 'Attention: le pagina que tu modifica es sin prefixo!',
	'wminc-warning-suggest' => 'Tu pote crear un pagina a [[$1]].',
	'wminc-warning-suggest-move' => 'Tu pote [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} renominar iste pagina verso $1].',
	'right-viewuserlang' => 'Vider le [[Special:ViewUserLang|lingua e wiki de test de usatores]]',
	'randombytest' => 'Pagina aleatori per le wiki de test',
	'randombytest-nopages' => 'Le wiki de test non ha paginas in le spatio de nomines: $1',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author Kandar
 * @author Rex
 */
$messages['id'] = array(
	'wminc-desc' => 'Sistem wiki pengujian untuk Inkubator Wikimedia',
	'wminc-viewuserlang' => 'Cari bahasa pengguna dan wiki pengujian',
	'wminc-viewuserlang-user' => 'Nama pengguna:',
	'wminc-viewuserlang-go' => 'Tuju ke',
	'wminc-testwiki' => 'Wiki pengujian:',
	'wminc-testwiki-none' => 'Tidak ada/Semua',
	'wminc-prefinfo-language' => 'Bahasa antarmuka Anda - tidak terpengaruh oleh wiki pengujian Anda',
	'wminc-prefinfo-code' => 'Kode bahasa ISO 639',
	'wminc-prefinfo-project' => 'Pilih proyek Wikimedia (pilihan Inkubator adalah untuk pengguna-pengguna yang melakukan kerja umum)',
	'wminc-prefinfo-error' => 'Anda memilih sebuah proyek yang membutuhkan sebuah kode bahasa.',
	'wminc-warning-unprefixed' => "'''Perhatian:''' Halaman yang Anda sunting tidak memiliki prefiks!",
	'wminc-warning-suggest' => 'Anda dapat membuat halaman di [[$1]].',
	'wminc-warning-suggest-move' => 'Anda dapat [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} memindahkan halaman ini ke $1].',
	'right-viewuserlang' => 'Lihat [[Special:ViewUserLang|bahasa pengguna dan wiki pengujian]]',
	'randombytest' => 'Halaman sembarang oleh wiki percobaan',
	'randombytest-nopages' => 'Tidak ada halaman  wiki pengujian anda, dalam ruangnama: $1.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'wminc-viewuserlang-go' => 'Gá',
	'wminc-testwiki' => 'Dàmatu wiki:',
	'wminc-testwiki-none' => 'Enwerö/Hánilé',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'wminc-viewuserlang-user' => 'Nome utente:',
	'wminc-viewuserlang-go' => 'Vai',
	'wminc-prefinfo-project' => "Seleziona il progetto Wikimedia (l'opzione Incubator è per gli utentu che fanno del lavoro generale)",
	'right-viewuserlang' => 'Visualizza [[Special:ViewUserLang|il linguaggio utente e prova la wiki]]',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'wminc-desc' => 'ウィキメディア・インキュベーター用の試験版ウィキシステム',
	'wminc-viewuserlang' => '利用者の言語と試験版ウィキを探す',
	'wminc-viewuserlang-user' => '利用者名:',
	'wminc-viewuserlang-go' => '表示',
	'wminc-testwiki' => '試験版ウィキ:',
	'wminc-testwiki-none' => 'なし/すべて',
	'wminc-prefinfo-language' => 'あなたのインタフェース言語 (あなたの試験版ウィキとは独立しています)',
	'wminc-prefinfo-code' => 'ISO 639 言語コード',
	'wminc-prefinfo-project' => 'ウィキメディア・プロジェクトを選択する (「Incubator」オプションは全般的な作業を行う利用者のためのものです)',
	'wminc-prefinfo-error' => 'あなたが選択したプロジェクトは言語コードが必要です。',
	'wminc-warning-unprefixed' => '警告: あなたが編集しているページには接頭辞が付いていません！',
	'wminc-warning-suggest' => '[[$1]] にページを作ることができます。',
	'wminc-warning-suggest-move' => '[{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} このページを $1 に移動]できます。',
	'right-viewuserlang' => '[[Special:ViewUserLang|利用者言語と試験版ウィキ]]を見る',
	'randombytest' => '試験版ウィキによるおまかせ表示',
	'randombytest-nopages' => 'あなたの試験版ウィキには名前空間 $1 にページがありません。',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'wminc-desc' => 'Sistem pangujian wiki kanggo Inkubator Wikimedia',
	'wminc-viewuserlang' => 'Golèki basa panganggo lan wiki pangujian',
	'wminc-viewuserlang-user' => 'Jeneng panganggo:',
	'wminc-viewuserlang-go' => 'Tumuju menyang',
	'wminc-testwiki' => 'Wiki pangujian:',
	'wminc-testwiki-none' => 'Ora ana/Kabèh',
	'wminc-prefinfo-language' => 'Basa adu-rai panjenengan - indhepèndhen saka wiki pacoban panjenengan',
	'wminc-prefinfo-code' => 'Kodhe basa ISO 639',
	'wminc-prefinfo-project' => 'Pilih proyèk Wikimedia (pilihan inkubator iku kanggo para panganggo sing ngayahi kerja umum)',
	'wminc-prefinfo-error' => 'Panjenengan milih sawijining proyèk sing mbutuhaké sawijining kodhe basa.',
	'wminc-warning-unprefixed' => "'''Pènget:''' Kaca sing panjenengan sunting ora nduwèni ater-ater!",
	'wminc-warning-suggest' => 'Panjenengan bisa gawé kaca ing [[$1]].',
	'wminc-warning-suggest-move' => 'Panjenengan bisa [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} mindhah kaca iki] menyang $1.',
	'right-viewuserlang' => 'Pirsani [[Special:ViewUserLang|basa panganggo lan wiki pacoban]]',
);

/** Khmer (ភាសាខ្មែរ)
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'wminc-desc' => 'សាកល្បង​ប្រព័ន្ធ​វិគី​សម្រាប់​ Wikimedia Incubator',
	'wminc-viewuserlang' => 'រក​មើល​ភាសា​អ្នក​ប្រើប្រាស់​និង​សាក​ល្បង​វិគី​',
	'wminc-viewuserlang-user' => 'អ្នកប្រើប្រាស់​៖',
	'wminc-viewuserlang-go' => 'ទៅ​',
	'wminc-testwiki' => 'សាកល្បង​វីគី៖',
	'wminc-testwiki-none' => 'គ្មាន​/ទាំងអស់​',
	'wminc-prefinfo-code' => 'លេខ​កូដ​ភាសា​ ISO 639',
	'wminc-prefinfo-error' => 'អ្នក​បាន​ជ្រើសរើស​គម្រោង​មួយ​ដែល​ត្រូវការ​លេខ​កូដ​ភាសា​។',
	'wminc-warning-suggest' => 'អ្នក​អាច​បង្កើត​ទំព័រ​មួយ​នៅ [[$1]] ។​',
	'wminc-warning-suggest-move' => 'អ្នក​អាច​[{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} ផ្លាស់​ប្ដូរ​ទីតាំង​ទំព័រ​នេះ​ទៅកាន់​ $1].',
	'right-viewuserlang' => 'មើល​[[Special:ViewUserLang|ភាសា​អ្នកប្រើប្រាស់​និងធ្វើការ​សាកល្បង​វិគី]]',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'wminc-viewuserlang-go' => 'ಹೋಗು',
);

/** Korean (한국어)
 * @author Pakman
 */
$messages['ko'] = array(
	'wminc-viewuserlang-user' => '사용자이름:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'wminc-desc' => 'Täß-Wiki Süßtemm för dä Inkubator vun de Wikimedia Shtefftung',
	'wminc-viewuserlang' => 'Däm Metmaacher sing Shprooch un sing Täß-Wiki aanloore',
	'wminc-viewuserlang-user' => 'Metmaacher-Name:',
	'wminc-viewuserlang-go' => 'Lohß Jonn!',
	'wminc-testwiki' => 'Täß-Wiki:',
	'wminc-testwiki-none' => 'Kein/All',
	'wminc-prefinfo-language' => 'De Shprooch för däm Wiki sing Bovverfläsch un et Wiki ze Bedeene — hät nix met Dingem Täß-Wiki singe Shprooch ze donn',
	'wminc-prefinfo-code' => 'Dat Köözel för de Shprooch noh dä Norrem ISO 639',
	'wminc-prefinfo-project' => 'Donn dat Projak ußwähle — „Incubator“ is för Lück met alljemein Werk.',
	'wminc-prefinfo-error' => 'Bei dämm Projäk moß och en Köözel för de Shprooch aanjejovve wääde.',
	'wminc-warning-unprefixed' => 'Opjepaß: Do bes en Sigg oohne ene Namess-Försatz för et Projäk un en Shprooch am beärbeide!',
	'wminc-warning-suggest' => 'De kanns en Sigg aanlääje als [[$1]].',
	'wminc-warning-suggest-move' => 'Do kanns hee di Sigg [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} op $1 ömnänne].',
	'right-viewuserlang' => 'De [[Special:ViewUserLang|Metmaacher ier Shprooche un Täßwiki]] beloore',
	'randombytest' => 'Zofällije Sigg uss_em Versoochswiki',
	'randombytest-nopages' => 'Et Appachtemang $1 änthält kein Sigge en Dingem Versöhkß-Wiki.',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'wminc-viewuserlang-user' => 'Hanow-usyer:',
	'wminc-viewuserlang-go' => 'Ke',
	'wminc-testwiki-none' => 'Vyth/Oll',
	'wminc-prefinfo-code' => 'Koden ISO 639 an yeth',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wminc-desc' => 'Testwiki-System fir de Wikimedia-Incubator',
	'wminc-viewuserlang' => 'Benotzersprooch an Test-Wiki nokucken',
	'wminc-viewuserlang-user' => 'Benotzernumm:',
	'wminc-viewuserlang-go' => 'Lass',
	'wminc-testwiki' => 'Test-Wiki:',
	'wminc-testwiki-none' => 'Keen/All',
	'wminc-prefinfo-language' => 'Sprooch vun ärem Interface - onofhängeg vun Ärer Test-Wiki',
	'wminc-prefinfo-code' => 'Den ISO 639 Sprooche-Code',
	'wminc-prefinfo-project' => "Wielt de Wikimediaprojet (D'Optioun 'Incubator' ass fir Benotzer déi allgemeng Aufgaben erledigen)",
	'wminc-prefinfo-error' => 'Dir hutt e Projet gewielt deen e Sproochecode brauch.',
	'wminc-warning-unprefixed' => "Opgepasst: d'Säit déi Dir ännert huet kee Prefix!",
	'wminc-warning-suggest' => 'Dir kënnt eng Säit op [[$1]] uleeën.',
	'wminc-warning-suggest-move' => 'Dir kënnt [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} dës Säit op $1 réckelen].',
	'right-viewuserlang' => '[[Special:ViewUserLang|Benotzersprooch an Test-Wiki]] weisen',
	'randombytest' => 'Zoufallssäit duerch Test Wiki',
	'randombytest-nopages' => 'Et si keng Säiten op Ärer Test-Wiki, am Nummraum: $1.',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'wminc-viewuserlang-user' => 'Solonanarana :',
	'wminc-viewuserlang-go' => 'Andana',
	'wminc-testwiki' => 'Wiki fanandramana :',
	'wminc-testwiki-none' => 'Tsy misy / izy rehetra',
	'wminc-prefinfo-language' => "Ny ten'ny rindrankajy ho anao - tsy mifatotra amin'ny wiki fanandramanao",
	'wminc-prefinfo-code' => 'Kaody ISO 639 ny teny',
	'wminc-prefinfo-error' => 'Nisafidy tetikasa mila kaodim-piteny ianao.',
	'wminc-warning-unprefixed' => "'''Tandremo''' : tsy manana prefiksa ny pejy ovainao",
	'wminc-warning-suggest' => "Afaka mamorona ny pejy an'i [[$1]] ianao.",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wminc-desc' => 'Тестирање на вики-систем за Викимедија Инкубаторот',
	'wminc-viewuserlang' => 'Провери го јазикот на корисникот и неговото тест-вики',
	'wminc-viewuserlang-user' => 'Корисничко име:',
	'wminc-viewuserlang-go' => 'Оди',
	'wminc-testwiki' => 'Тест-вики:',
	'wminc-testwiki-none' => 'Ништо/Сè',
	'wminc-prefinfo-language' => 'Јазикот на вашиот интерфејс - назависно од вашето тест-вики',
	'wminc-prefinfo-code' => 'Јазичниот ISO 639 код',
	'wminc-prefinfo-project' => 'Изберете го проектот (можноста за Инкубатор е за корисници кои работат општи задачи)',
	'wminc-prefinfo-error' => 'Избравте проект на кој му треба јазичен код.',
	'wminc-warning-unprefixed' => "'''Предупредување:''' Страницата што ја уредувате нема префикс!",
	'wminc-warning-suggest' => 'Можете да созададете страница на [[$1]].',
	'wminc-warning-suggest-move' => 'Можете  [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} ја преместите страницава на $1].',
	'right-viewuserlang' => 'Погледајте [[Special:ViewUserLang|кориснички јазик и текст вики]]',
	'randombytest' => 'Случајна страница од тест вики',
	'randombytest-nopages' => 'Не постојат страници на вашето пробно вики, во именскиот простор: $1.',
);

/** Malayalam (മലയാളം)
 * @author Junaidpv
 * @author Praveenp
 */
$messages['ml'] = array(
	'wminc-viewuserlang-user' => 'ഉപയോക്തൃനാമം:',
	'wminc-viewuserlang-go' => 'പോകൂ',
	'wminc-testwiki' => 'പരീക്ഷണ വിക്കി:',
	'wminc-testwiki-none' => 'ഒന്നുമില്ല/എല്ലാം',
	'randombytest' => 'പരീക്ഷണ വിക്കിയിൽ നിന്നും ക്രമരഹിതമായി എടുത്ത താൾ',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 * @author Yosri
 */
$messages['ms'] = array(
	'wminc-desc' => 'Sistem wiki ujian untuk Wikimedia Incubator',
	'wminc-viewuserlang' => 'Lihat bahasa pengguna dan wiki ujian',
	'wminc-viewuserlang-user' => 'Nama pengguna:',
	'wminc-viewuserlang-go' => 'Pergi',
	'wminc-testwiki' => 'Wiki ujian:',
	'wminc-testwiki-none' => 'Tiada/Semua',
	'wminc-prefinfo-language' => 'Bahasa antaramuka anda - bebas dari wiki ujian anda',
	'wminc-prefinfo-code' => 'Kod bahasa ISO 639',
	'wminc-prefinfo-project' => 'Pilih projek Wikimedia (pilihan Incubator ialah bagi pengguna yang membuat kerja umum)',
	'wminc-prefinfo-error' => 'Anda memilih projek yang memerlukan kod bahasa.',
	'wminc-warning-unprefixed' => "'''Amaran:''' Laman yang anda sunting tiada awalan!",
	'wminc-warning-suggest' => 'Anda boleh cipta satu laman di [[$1]].',
	'wminc-warning-suggest-move' => 'Anda boleh [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} alih laman ini ke $1].',
	'right-viewuserlang' => 'Lihat [[Special:ViewUserLang|bahasa pengguna dan wiki ujian]]',
	'randombytest' => 'Laman rawak oleh wiki ujian',
	'randombytest-nopages' => 'Tidak terdapat laman dalam wiki ujian anda, dalam ruang nama: $1.',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'wminc-viewuserlang-user' => 'Сёрмадыцянь леметь:',
	'wminc-testwiki-none' => 'Мезеяк/Весе',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'wminc-desc' => 'Testwiki-systeem voor Wikimedia Incubator',
	'wminc-viewuserlang' => 'Gebruikerstaal en testwiki opzoeken',
	'wminc-viewuserlang-user' => 'Gebruikersnaam:',
	'wminc-viewuserlang-go' => 'OK',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Geen/alles',
	'wminc-prefinfo-language' => 'Uw interfacetaal - onafhankelijk van uw testwiki',
	'wminc-prefinfo-code' => 'De ISO 639-taalcode',
	'wminc-prefinfo-project' => 'Selecteer het Wikimedia-project (Incubator-optie is voor gebruikers die algemeen werk doen)',
	'wminc-prefinfo-error' => 'U selecteerde een project dat een taalcode nodig heeft.',
	'wminc-warning-unprefixed' => 'Waarschuwing: de pagina die u aan het bewerken bent, heeft geen voorvoegsel!',
	'wminc-warning-suggest' => 'U kunt een pagina aanmaken op [[$1]].',
	'wminc-warning-suggest-move' => 'U kunt [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} deze pagina hernoemen naar $1].',
	'right-viewuserlang' => '[[Special:ViewUserLang|Gebruikerstaal en test wiki]] bekijken',
	'randombytest' => 'Willekeurige pagina uit testwiki',
	'randombytest-nopages' => "Er zijn geen pagina's in uw testwiki in de naamruimte $1.",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 */
$messages['nn'] = array(
	'wminc-desc' => 'Testwikisystem for Wikimedia Incubator',
	'wminc-viewuserlang' => 'Slå opp brukarspråk og testwiki',
	'wminc-viewuserlang-user' => 'Brukarnamn:',
	'wminc-viewuserlang-go' => 'Gå',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Ingen/alle',
	'wminc-prefinfo-language' => 'Ditt grensesnittspråk - uavhengig av testwikien din',
	'wminc-prefinfo-code' => 'ISO 639-språkkode',
	'wminc-prefinfo-project' => 'Vél Wikimediaprosjekt (alternativet Incubator er for brukarar som gjer generelt arbeid)',
	'wminc-prefinfo-error' => 'Du valde eit prosjekt som krev ei språkkode.',
	'wminc-warning-unprefixed' => "'''Åtvaring:''' Sida du endrar er utan prefiks!",
	'wminc-warning-suggest' => 'Du kan oppretta ei side på [[$1]].',
	'wminc-warning-suggest-move' => 'Du kan [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} flytta denne sida til $1].',
	'right-viewuserlang' => 'Vis [[Special:ViewUserLang|brukarspråk og testwiki]]',
	'randombytest' => 'Tilfelleleg side frå testwiki',
	'randombytest-nopages' => 'Det er ingen sider i testwikien din, i namneromet:  $1.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'wminc-desc' => 'Testwikisystem for Wikimedia Incubator',
	'wminc-viewuserlang' => 'Slå opp brukerspråk og testwiki',
	'wminc-viewuserlang-user' => 'Brukernavn:',
	'wminc-viewuserlang-go' => 'Gå',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Ingen/Alle',
	'wminc-prefinfo-language' => 'Ditt grensesnittspråk - uavhengig av din testwiki',
	'wminc-prefinfo-code' => 'ISO 639-språkkoden',
	'wminc-prefinfo-project' => 'Velg Wikimediaprosjektet (alternativet Incubator er for brukere som gjør generelt arbeid)',
	'wminc-prefinfo-error' => 'Du valgte et prosjekt som krever en språkkode.',
	'wminc-warning-unprefixed' => "'''Advarsel:''' Siden du endrer er uprefiksert!",
	'wminc-warning-suggest' => 'Du kan opprette en side på [[$1]].',
	'wminc-warning-suggest-move' => 'Du kan [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} flytte denne siden til $1].',
	'right-viewuserlang' => 'Vis [[Special:ViewUserLang|brukerspråk og testwiki]]',
	'randombytest' => 'Tilfeldig side fra testwiki',
	'randombytest-nopages' => 'Det er ingen sider i din testwiki, i navnerommet: $1.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'wminc-desc' => 'Sistèma de tèst de wiki per Wikimedia Incubator',
	'wminc-viewuserlang' => "Veire la lenga de l'utilizaire e son wiki de tèst",
	'wminc-viewuserlang-user' => "Nom d'utilizaire :",
	'wminc-viewuserlang-go' => 'Anar',
	'wminc-testwiki' => 'Wiki de tèst :',
	'wminc-testwiki-none' => 'Pas cap / totes',
	'wminc-prefinfo-language' => "Vòstra lenga de l'interfàcia - independenta de vòstre wiki de tèst",
	'wminc-prefinfo-code' => 'Lo còde ISO 639 de la lenga',
	'wminc-prefinfo-project' => "Seleccionatz lo projècte Wikimedia (l'opcion Incubator es destinada als utilizaires que fan un trabalh general)",
	'wminc-prefinfo-error' => 'Avètz seleccionat un projècte que necessita un còde de lenga.',
	'wminc-warning-unprefixed' => 'Atencion : la pagina que modificatz a pas de prefixe !',
	'wminc-warning-suggest' => 'Podètz crear la pagina a [[$1]].',
	'wminc-warning-suggest-move' => 'Podètz [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} tornar nomenar aquesta pagina cap a $1].',
	'right-viewuserlang' => 'Vejatz [[Special:ViewUserLang|lenga de l’utilizaire e lo wiki de tèst]]',
	'randombytest' => 'Pagina aleatòria pel wiki de tèst',
	'randombytest-nopages' => "Vòstre wiki de tèst conten pas de pagina dins l'espaci de noms : $1.",
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'wminc-viewuserlang-user' => 'Yuuser-Naame:',
	'wminc-viewuserlang-go' => 'Hole',
	'wminc-testwiki-none' => 'Ken/All',
);

/** Polish (Polski)
 * @author Leinad
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'wminc-desc' => 'Testowa wiki dla Inkubatora Wikimedia',
	'wminc-viewuserlang' => 'Sprawdzanie języka użytkownika i testowej wiki',
	'wminc-viewuserlang-user' => 'Nazwa użytkownika',
	'wminc-viewuserlang-go' => 'Pokaż',
	'wminc-testwiki' => 'Testowa wiki',
	'wminc-testwiki-none' => 'Żadna lub wszystkie',
	'wminc-prefinfo-language' => 'Język interfejsu (niezależny od języka testowej wiki)',
	'wminc-prefinfo-code' => 'Kod języka według ISO 639',
	'wminc-prefinfo-project' => 'Wybierz projekt Wikimedia (opcja wyboru Inkubatora jest przeznaczona dla użytkowników, którzy wykonują prace ogólne)',
	'wminc-prefinfo-error' => 'Został wybrany projekt, który wymaga podania kodu języka.',
	'wminc-warning-unprefixed' => "'''Uwaga''' – strona, którą edytujesz, nie posiada prefiksu!",
	'wminc-warning-suggest' => 'Możesz utworzyć stronę „[[$1]]”.',
	'wminc-warning-suggest-move' => 'Możesz [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} przenieść tę stronę do „$1”].',
	'right-viewuserlang' => 'Zobacz [[Special:ViewUserLang|język użytkownika oraz testową wiki]]',
	'randombytest' => 'Losowa strona testowej wiki',
	'randombytest-nopages' => 'W Twojej testowej wiki brak jest stron w przestrzeni nazw $1.',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'wminc-desc' => 'Preuva ël sistema ëd wiki për Wikimedia Incubator',
	'wminc-viewuserlang' => "varda la lenga dl'utent e preuva la wiki",
	'wminc-viewuserlang-user' => 'Nòm utent:',
	'wminc-viewuserlang-go' => 'Va',
	'wminc-testwiki' => 'Preuva wiki:',
	'wminc-testwiki-none' => 'Gnun/Tùit',
	'wminc-prefinfo-language' => "Toa lenga d'antërfacia - andipendenta da toa wiki ëd preuva",
	'wminc-prefinfo-code' => 'Ël còdes ISO 639 dla lenga',
	'wminc-prefinfo-project' => "Selession-a ël proget Wikimedia (l'opsion Incubator a l'é për utent che a fan travaj general)",
	'wminc-prefinfo-error' => "It l'has selessionà un proget che a l'ha dbzògn d'un còdes ëd lenga.",
	'wminc-warning-unprefixed' => "'''Avis:''' la pàgina ch'i të stas modificand a l'é sensa prefiss!",
	'wminc-warning-suggest' => 'It peule creé na pàgina a [[$1]].',
	'wminc-warning-suggest-move' => 'It peule [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} tramudé sta pàgina-sì a $1].',
	'right-viewuserlang' => "Visualisa [[Special:ViewUserLang|lenga dl'utent e wiki ëd preuva]]",
	'randombytest' => 'Pàgina a cas da wiki ëd preuva',
	'randombytest-nopages' => 'A-i son pa ëd pàgine ant toa wiki ëd preuva, ant lë spassi nominal: $1:',
);

/** Pontic (Ποντιακά)
 * @author Omnipaedista
 */
$messages['pnt'] = array(
	'wminc-viewuserlang-go' => 'Δέβα',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wminc-viewuserlang-user' => 'کارن-نوم:',
	'wminc-viewuserlang-go' => 'ورځه',
	'wminc-testwiki' => 'د آزمېښت ويکي:',
	'wminc-testwiki-none' => 'هېڅ/ټول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'wminc-desc' => 'Sistema de wikis de testes para a Incubadora Wikimedia',
	'wminc-viewuserlang' => 'Procurar a língua do utilizador e a wiki de testes',
	'wminc-viewuserlang-user' => 'Nome de utilizador:',
	'wminc-viewuserlang-go' => 'Ir',
	'wminc-testwiki' => 'Wiki de testes:',
	'wminc-testwiki-none' => 'Nenhum/Tudo',
	'wminc-prefinfo-language' => 'A língua da interface - independente da da sua wiki de testes',
	'wminc-prefinfo-code' => 'O código de língua ISO 639',
	'wminc-prefinfo-project' => 'Seleccione o projeto Wikimedia (a opção Incubadora é para utilizadores que fazem trabalho geral)',
	'wminc-prefinfo-error' => 'Seleccionou um projecto que necessita de um código de língua.',
	'wminc-warning-unprefixed' => 'Aviso: a página que está a editar não tem prefixo!',
	'wminc-warning-suggest' => 'Pode criar uma página em [[$1]].',
	'wminc-warning-suggest-move' => 'Pode [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} mover esta página para $1].',
	'right-viewuserlang' => 'Ver [[Special:ViewUserLang|língua do utilizador e wiki de testes]]',
	'randombytest' => 'Página aleatória da wiki de testes',
	'randombytest-nopages' => 'Não há páginas na sua wiki de testes, no espaço nominal: $1.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'wminc-desc' => 'Sistema de wikis de teste para a Incubadora Wikimedia',
	'wminc-viewuserlang' => 'Procurar idioma do utilizador e wiki de teste',
	'wminc-viewuserlang-user' => 'Nome de usuário:',
	'wminc-viewuserlang-go' => 'Ir',
	'wminc-testwiki' => 'Wiki de teste:',
	'wminc-testwiki-none' => 'Nenhum/Tudo',
	'wminc-prefinfo-language' => 'Seu idioma de interface - independente do seu wiki de teste',
	'wminc-prefinfo-code' => 'O código de língua ISO 639',
	'wminc-prefinfo-project' => 'Selecione o projeto Wikimedia (a opção Incubadora é para usuários que fazem trabalho geral)',
	'wminc-prefinfo-error' => 'Você selecionou um projeto que necessita de um código de língua.',
	'wminc-warning-unprefixed' => 'Aviso: a página que você está editando não tem prefixo!',
	'wminc-warning-suggest' => 'Você pode criar uma página em [[$1]].',
	'wminc-warning-suggest-move' => 'Você pode [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} mover esta página para $1].',
	'right-viewuserlang' => 'Ver [[Special:ViewUserLang|idioma do usuário e wiki de teste]]',
	'randombytest' => 'Página aleatória da wiki de testes',
	'randombytest-nopages' => 'Não há páginas em sua wiki de testes no domínio: $1',
);

/** Romanian (Română)
 * @author Emily
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'wminc-desc' => 'Sistemul wiki de testare pentru Wikimedia Incubator',
	'wminc-viewuserlang-user' => 'Nume de utilizator:',
	'wminc-viewuserlang-go' => 'Du-te',
	'wminc-testwiki' => 'Wikia test:',
	'wminc-testwiki-none' => 'Niciunul/Toţi',
	'wminc-prefinfo-language' => 'Limba interfeţei dumneavoastră - independentă de wikia test',
	'wminc-prefinfo-code' => 'Limbajul cod ISO 639',
	'wminc-prefinfo-error' => 'Aţi selectat un proiect care are nevoie de un cod al limbajului.',
	'wminc-warning-unprefixed' => "'''Avertisment:''' Pagina pe care o editaţi nu este prefixată!",
	'wminc-warning-suggest' => 'Puteţi crea o pagină la [[$1]].',
	'wminc-warning-suggest-move' => 'Puteţi [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} muta această pagină la $1].',
	'right-viewuserlang' => 'Vizualizează [[Special:ViewUserLang|limba utilizatorului şi wikia test]]',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'wminc-desc' => 'Test pu sisteme Uicchi pe UicchiMedia Incubatore',
	'wminc-viewuserlang' => "Combronde 'mbrà 'a lènghe de l'utende e 'u teste de Uicchi",
	'wminc-viewuserlang-user' => "Nome de l'utende:",
	'wminc-viewuserlang-go' => 'Veje',
	'wminc-testwiki' => 'Test de Uicchi:',
	'wminc-testwiki-none' => 'Nisciune/Tutte',
	'wminc-prefinfo-language' => "L'inderfacce indipendende de lènghe da 'u teste tue de Uicchi",
	'wminc-prefinfo-code' => "'U codece ISO 639 d'a lènghe",
	'wminc-prefinfo-project' => "Scacchie 'u proggette UicchiMedia (opzione Incubatore jè pe l'utinde ca fanne 'na fatìe generale)",
	'wminc-prefinfo-error' => "Tu è scacchiate 'nu proggette ca abbesogne de 'nu codece de lènghe.",
	'wminc-warning-unprefixed' => "'''Attenziò:''' 'A pàgene ca tu ste cange jè senza prefisse!",
	'wminc-warning-suggest' => "Tu puè ccreja 'na pàgene a [[$1]].",
	'wminc-warning-suggest-move' => 'Tu puè [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} spustà sta pàgene sus a $1].',
	'right-viewuserlang' => "Vide [[Special:ViewUserLang|'a lènghe de l'utende e teste Uicchi]]",
	'randombytest' => 'Pàgene a uecchie pe testà Uicchi',
	'randombytest-nopages' => "Non ge stonne pàggene jndr'à Uicchi de test, jndr'à 'u namespace: $1.",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Kaganer
 * @author Kv75
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'wminc-desc' => 'Пробная вики-система для Инкубатора Викимедиа',
	'wminc-viewuserlang' => 'Поиск языковых настроек участника и его пробной вики',
	'wminc-viewuserlang-user' => 'Имя участника:',
	'wminc-viewuserlang-go' => 'Найти',
	'wminc-testwiki' => 'Пробная вики:',
	'wminc-testwiki-none' => 'Нет/все',
	'wminc-prefinfo-language' => 'Ваш язык интерфейса не зависит от вашей пробной вики',
	'wminc-prefinfo-code' => 'Код языка по ISO 639',
	'wminc-prefinfo-project' => 'Выбор проекта Викимедиа (выберите Инкубатор, если занимаетесь общими вопросами)',
	'wminc-prefinfo-error' => 'Вы выбрали проект, для которого необходимо указать код языка.',
	'wminc-warning-unprefixed' => "'''Внимание.''' Название страницы, которую вы правите, не содержит префикса!",
	'wminc-warning-suggest' => 'Вы можете создать страницу на [[$1]].',
	'wminc-warning-suggest-move' => 'Вы можете [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} переименовать эту страницу в $1].',
	'right-viewuserlang' => 'просматривать [[Special:ViewUserLang|языковые настройки участника и его пробную вики]]',
	'randombytest' => 'Случайная страница пробной вики',
	'randombytest-nopages' => 'В вашей пробной вики нет страниц в пространстве имён $1.',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'wminc-desc' => 'Бикимиэдьийэ Инкубаатарын тургутар биики-систиэмэтэ',
	'wminc-viewuserlang' => 'Кыттааччы тыллары талыытын уонна тургутар биикитин көрдөөһүн',
	'wminc-viewuserlang-user' => 'Кытааччы аата:',
	'wminc-viewuserlang-go' => 'Бул',
	'wminc-testwiki' => 'Тургутуллар биики:',
	'wminc-testwiki-none' => 'Суох/Барыта',
	'wminc-prefinfo-language' => 'Эн тылыҥ туруоруута тургутар биикигиттэн тутулуга суох',
	'wminc-prefinfo-code' => 'Тыл ISO 639 тиһилигэр анаммыт куода',
	'wminc-prefinfo-project' => 'Бикимиэдьийэ бырайыактарыттан талыы (уопсай боппуруостарынан дьарыктаныаххын баҕарар буоллаххына Инкубаатары тал)',
);

/** Tachelhit (Tašlḥiyt)
 * @author Dalinanir
 */
$messages['shi'] = array(
	'wminc-viewuserlang' => 'Af tutlayt nu amsdaqc tarmt wiki',
	'wminc-viewuserlang-user' => 'Assaɣ nu-msxdan',
	'wminc-viewuserlang-go' => 'Balak',
	'wminc-testwiki' => 'Arm n wiki',
	'wminc-testwiki-none' => 'Walu/kullu',
	'wminc-prefinfo-language' => 'Udm n tutlayt nk.  tbḍa d arm  n wiki',
	'wminc-prefinfo-code' => 'Asngl ISO 639 n tutlayt',
	'wminc-prefinfo-project' => 'Sti tawuri n Wikipedya (Astay n tusnkert ittuyzlay s imsxdamn li skarni tawuri ur ittiyslayn)',
	'wminc-prefinfo-error' => 'Tstit yat tuwuri li iran asngl n tutlayt',
	'wminc-warning-unprefixed' => 'Wayyak  ḥan tasna li tarat ur tla amttuz (prefix)',
	'wminc-warning-suggest' => 'Ttzdart at tarat tasna ɣ [[$1]]',
	'wminc-warning-suggest-move' => 'Tzdart at [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}}  smmatit tasna yad s $1.]',
	'right-viewuserlang' => 'Ẓr [[Special:ViewUserLang|Tutlayt nu umsxdam d arm n  wiki]]',
	'randombytest' => 'Tasna nn ḥlli s astay n wiki',
	'randombytest-nopages' => 'Ur gis kra n tasna ɣ warm n wiki, li ittafn assaɣ: $1.',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'wminc-desc' => 'විකි මීඩියා ආසීනකාරකය සඳහා විකි පද්ධතිය පරීක්ෂා කරන්න',
	'wminc-viewuserlang' => 'පරිශීලක භාෂාව බලා විකිය පරීක්ෂා කරන්න.',
	'wminc-viewuserlang-user' => 'පරිශීලක නාමය:',
	'wminc-viewuserlang-go' => 'යන්න',
	'wminc-testwiki' => 'විකිය පරීක්ෂා කරන්න:',
	'wminc-testwiki-none' => 'කිසිවක් නොවේ/සියල්ලම',
	'wminc-prefinfo-language' => 'ඔබේ අතුරු මුහුණත් භාෂාව - ඔබේ විකි පරීක්ෂාවෙන් ස්වායත්ත වේ',
	'wminc-prefinfo-code' => 'ISO  639 භාෂා කේතය',
	'wminc-prefinfo-project' => 'විකි මීඩියා ව්‍යාපෘතිය තෝරන්න.(ආසීනකාරක තොරාගැනීම සාමාන්‍ය කාර්යයන් කරන පරිශීලකයන් සඳහා වේ)',
	'wminc-prefinfo-error' => 'භාෂා කේතයක් අවශ්‍ය වන ව්‍යාපෘතියක් ඔබ විසින්  තෝරා ගෙන ඇත.',
	'wminc-warning-unprefixed' => "'''අවවාදයයි:'''  ඔබ සංස්කරණය කරන පිටුව උපසර්ග නොයෙදවූවකි!",
	'wminc-warning-suggest' => 'ඔබට  [[$1]] හි පිටුවක් නිර්මාණය කළ හැක.',
	'wminc-warning-suggest-move' => 'ඔබට [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} මෙම පිටුව $1] වෙත ගෙන යා හැක.',
	'right-viewuserlang' => ' [[Special:ViewUserLang|පරිශීලක භාෂාව හා විකි පරීක්ෂාව]] බලන්න.',
	'randombytest' => 'විකි පරීක්ෂාවකින් සසම්භාවී පිවුවක්',
	'randombytest-nopages' => '$1 නාම අවකාශය තුළ,ඔබේ විකි පරීක්ෂාවේ කිසිදු පිටුවක් නොමැත.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'wminc-desc' => 'Testovací wiki systém pre Inkubátor Wikimedia',
	'wminc-viewuserlang' => 'Vyhľadať jazyk používateľa a testovaciu wiki',
	'wminc-viewuserlang-user' => 'Používateľské meno:',
	'wminc-viewuserlang-go' => 'Vykonať',
	'wminc-testwiki' => 'Testovacia wiki:',
	'wminc-testwiki-none' => 'Žiadna/všetky',
	'wminc-prefinfo-language' => 'Jazyk vášho rozhrania - nezávisle od vašej testovacej wiki',
	'wminc-prefinfo-code' => 'ISO 639 kód jazyka',
	'wminc-prefinfo-project' => 'Vybrať projekt Wikimedia (voľba Inkubátor je pre používateľov, ktorí vykonávajú všeobecnú prácu)',
	'wminc-prefinfo-error' => 'Vybrali ste projekt, ktorý potrebuje kód jazyka.',
	'wminc-warning-unprefixed' => 'Upozornenie: stránka, ktorú upravujete je bez predpony!',
	'wminc-warning-suggest' => 'Môžete vytvoriť stránku na [[$1]].',
	'wminc-warning-suggest-move' => 'Môžete [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} presunúť túto stránku na $1].',
	'right-viewuserlang' => 'Zobraziť [[Special:ViewUserLang|jazyk používateľa a testovaciu wiki]]',
	'randombytest' => 'Náhodná stránka z testovacej wiki',
	'randombytest-nopages' => 'Vo vašej testovacej wiki neexistujú stránky v mennom priestore $1.',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'wminc-viewuserlang-user' => 'Корисничко име:',
	'wminc-viewuserlang-go' => 'Иди',
	'wminc-testwiki' => 'Тест-Вики:',
	'wminc-testwiki-none' => 'Ништа/Све',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'wminc-viewuserlang-user' => 'Korisničko ime:',
	'wminc-viewuserlang-go' => 'Idi',
	'wminc-testwiki' => 'Test-Viki:',
	'wminc-testwiki-none' => 'Ništa/Sve',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'wminc-prefinfo-code' => 'Sandi basa ISO 639',
	'wminc-prefinfo-project' => 'Pilih proyék Wikimédia (pilihan Inkubator pikeun pamaké nu ngahanca pagawéan umum)',
	'wminc-prefinfo-error' => 'Anjeun milih proyék anu merlukeun sandi basa.',
	'wminc-warning-suggest' => 'Anjeun bisa nyieun kaca/artikel di [[$1]].',
	'wminc-warning-suggest-move' => 'Anjeun bisa [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} mindahkeun ieu kaca ka $1].',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Gabbe.g
 * @author Najami
 * @author Ozp
 * @author Poxnar
 */
$messages['sv'] = array(
	'wminc-desc' => 'Testwikisystem för Wikimedia Incubator',
	'wminc-viewuserlang' => 'Kolla upp användarspråk och testwiki',
	'wminc-viewuserlang-user' => 'Användarnamn:',
	'wminc-viewuserlang-go' => 'Gå till',
	'wminc-testwiki' => 'Testwiki:',
	'wminc-testwiki-none' => 'Ingen/Alla',
	'wminc-prefinfo-language' => 'Ditt gränssnittsspråk - oavhängigt från din testwiki',
	'wminc-prefinfo-code' => 'ISO 639-språkkoden',
	'wminc-prefinfo-project' => 'Välj Wikimediaprojekt (alternativet Incubator för användare som gör allmänt arbete)',
	'wminc-prefinfo-error' => 'Du valde ett projekt som kräver en språkkod.',
	'wminc-warning-unprefixed' => "'''Varning:''' Sidan du redigerar saknar prefix!",
	'wminc-warning-suggest' => 'Du kan skapa sidan [[$1]].',
	'wminc-warning-suggest-move' => 'Du kan [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} flytta denna sidan till $1].',
	'right-viewuserlang' => 'Visa [[Special:ViewUserLang|användarspråk och testwiki]]',
	'randombytest' => 'Slumpvis sida från testwiki',
	'randombytest-nopages' => 'Det finns inga sidor i din textwiki, i namnrymden: $1.',
);

/** Silesian (Ślůnski)
 * @author Ozi64
 */
$messages['szl'] = array(
	'wminc-viewuserlang-user' => 'Mjano używacza:',
	'wminc-testwiki-none' => 'Żodno/Wszyjske',
	'wminc-prefinfo-code' => 'Kod godki ISO 639',
	'wminc-prefinfo-project' => 'Uobjer projekt Wikimedia (upcyjo uobjyrańo Inkubatora je zuůnaczůno lo używaczůw, kere robjům uogůlne proce)',
	'wminc-prefinfo-error' => 'Uostoł uobrany projekt, przi kerym trza podać kod godki.',
	'wminc-warning-unprefixed' => "'''Pozůr''' - edytowana zajta ńy mo prefiksa!",
	'wminc-warning-suggest' => 'Mogesz zrobić zajta [[$1]].',
	'wminc-warning-suggest-move' => 'Mogesz [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} przećepnyńc zajta do $1].',
	'right-viewuserlang' => 'Uobocz [[Special:ViewUserLang|zajta używacza a testowo wiki]]',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'wminc-desc' => 'వికీమీడియా ఇంక్యుబేటర్ కొరకు పరీక్షా వికీ సిస్టం',
	'wminc-viewuserlang-user' => 'వాడుకరిపేరు:',
	'wminc-viewuserlang-go' => 'వెళ్ళు',
	'wminc-testwiki' => 'పరీక్షా వికీ:',
	'wminc-testwiki-none' => 'ఏమికాదు/అన్నీ',
	'wminc-prefinfo-code' => 'ISO 639 భాష కోడు',
	'wminc-prefinfo-error' => 'భాష కోడు కావాల్సిన ఒక ప్రాజెక్టును మీరు ఎన్నుకున్నారు.',
	'wminc-warning-suggest' => '[[$1]] దగ్గర మీరు పేజిని సృష్టించవచ్చు.',
	'wminc-warning-suggest-move' => 'మీరు [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} ఈ పేజీని $1కి తరలించ]వచ్చు.',
	'right-viewuserlang' => 'వీక్షించండి [[Special:ViewUserLang|సభ్యుని భాష మరియు పరీక్షా వికీ]]',
	'randombytest' => 'పరీక్షా వికీ ద్వారా ఒక యాధృచిక పేజి',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'wminc-viewuserlang-user' => 'Номи корбарӣ:',
	'wminc-viewuserlang-go' => 'Рав',
	'wminc-testwiki' => 'Санҷиши вики:',
	'wminc-testwiki-none' => 'Ҳеҷ/Ҳама',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'wminc-viewuserlang-user' => 'Nomi korbarī:',
	'wminc-viewuserlang-go' => 'Rav',
	'wminc-testwiki' => 'Sançişi viki:',
	'wminc-testwiki-none' => 'Heç/Hama',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'wminc-viewuserlang-user' => 'Ulanyjy ady:',
	'wminc-viewuserlang-go' => 'Git',
	'wminc-testwiki' => 'Test wiki:',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'wminc-desc' => 'Vikimedya İnkübatör için test viki sistemi',
	'wminc-viewuserlang' => 'Kullanıcı dili ve test vikisine bak',
	'wminc-viewuserlang-user' => 'Kullanıcı adı:',
	'wminc-viewuserlang-go' => 'Git',
	'wminc-testwiki' => 'Test viki:',
	'wminc-testwiki-none' => 'Hiçbiri/Tümü',
	'wminc-prefinfo-language' => 'Arayüz diliniz - test vikinizden bağımsız',
	'wminc-prefinfo-code' => 'ISO 639 dil kodu',
	'wminc-prefinfo-project' => 'Vikimedya projesini seçin (İnkübatör seçeneği genel çalışma yapan kullanıcılar için)',
	'wminc-prefinfo-error' => 'Bir dil kodu gereken bir proje seçtiniz.',
	'wminc-warning-unprefixed' => "'''Uyarı:''' Değiştirdiğiniz sayfanın öneki yok!",
	'wminc-warning-suggest' => '[[$1]] adında yeni bir sayfa oluşturabilirsiniz.',
	'wminc-warning-suggest-move' => '[{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} Bu sayfayı $1 sayfasına taşıyabilirsiniz].',
	'right-viewuserlang' => '[[Special:ViewUserLang|Kullanıcı dilini ve test vikisini]] gör',
	'randombytest' => 'Test vikisinden rastgele sayfa',
	'randombytest-nopages' => 'Test vikinizdeki $1 isim alanında herhangi bir sayfa bulunmuyor.',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Sahran
 */
$messages['ug-arab'] = array(
	'wminc-viewuserlang' => 'ئىشلەتكۈچى تىلىنى كۆرۈپ، wiki سىناش',
	'wminc-viewuserlang-user' => 'ئىشلەتكۈچى ئاتى:',
	'wminc-viewuserlang-go' => 'يۆتكەل',
	'wminc-testwiki' => 'wiki سىناش:',
	'wminc-testwiki-none' => 'ھەممىسى/يوق',
	'wminc-prefinfo-language' => 'سىزنىڭ كۆرۈنمە تىلىڭىز - wiki سىناشتىن مۇستەقىل تۇرىدۇ',
	'wminc-prefinfo-code' => 'ISO 639 تىل كودى',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Aleksandrit
 */
$messages['uk'] = array(
	'wminc-desc' => 'Тестова вікі для Інкубатора Вікімедіа',
	'wminc-viewuserlang' => 'Проглянути мову й тестову вікі користувача',
	'wminc-viewuserlang-user' => 'Ім’я користувача:',
	'wminc-viewuserlang-go' => 'Пошук',
	'wminc-testwiki' => 'Тестова вікі:',
	'wminc-testwiki-none' => 'Жодна або всі',
	'wminc-prefinfo-language' => 'Мова інтерфейсу (залежить від мови тестової вікі)',
	'wminc-prefinfo-code' => 'Код мови згідно з ISO 639',
	'wminc-prefinfo-project' => 'Оберіть проект Вікімедіа (варіант Інкубатор для тих, хто займається загальними питаннями)',
	'wminc-prefinfo-error' => 'Ви обрали проект, для якого необхідно вказати код мови.',
	'wminc-warning-unprefixed' => "'''Увага.''' Назва сторінки, яку ви редагуєте, не містить префікса!",
	'wminc-warning-suggest' => 'Ви можете створити сторінку на [[$1]].',
	'wminc-warning-suggest-move' => 'Ви можете [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} перейменувати цю сторінку в $1].',
	'right-viewuserlang' => 'Переглядати [[Special:ViewUserLang|мовні налаштування користувача і його тестову вікі]]',
	'randombytest' => 'Випадкова сторінка тестової вікі',
	'randombytest-nopages' => 'У вашій тестовій вікі немає сторінок у просторі імен $1.',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'wminc-viewuserlang-user' => 'Kävutajan nimi:',
	'wminc-viewuserlang-go' => 'Ectä',
	'wminc-testwiki' => 'Kodvwiki:',
	'wminc-testwiki-none' => 'Ei ole/Kaik',
	'wminc-prefinfo-code' => "ISO 639-kel'kod",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'wminc-desc' => 'Hệ thống wiki thử của Wikimedia Incubator',
	'wminc-viewuserlang' => 'Ngôn ngữ và wiki thử của người dùng',
	'wminc-viewuserlang-user' => 'Tên hiệu:',
	'wminc-viewuserlang-go' => 'Xem',
	'wminc-testwiki' => 'Wiki thử:',
	'wminc-testwiki-none' => 'Không có / tất cả',
	'wminc-prefinfo-language' => 'Ngôn ngữ giao diện của bạn – có thể khác với wiki thử',
	'wminc-prefinfo-code' => 'Mã ngôn ngữ ISO 639',
	'wminc-prefinfo-project' => 'Hãy chọn dự án Wikimedia (hay Incubator để làm việc chung)',
	'wminc-prefinfo-error' => 'Bạn đã chọn một dự án bắt phải có mã ngôn ngữ.',
	'wminc-warning-unprefixed' => 'Cảnh báo: bạn đang sửa đổi trang chưa có tiền tố!',
	'wminc-warning-suggest' => 'Bạn có thể tạo trang “[[$1]]”.',
	'wminc-warning-suggest-move' => 'Bạn có thể [{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} di chuyển trang này đến $1].',
	'right-viewuserlang' => 'Xem [[Special:ViewUserLang|ngôn ngữ và wiki thử của người dùng]]',
	'randombytest' => 'Trang ngẫu nhiên theo wiki thử',
	'randombytest-nopages' => 'Không có trang này tại wiki thử của bạn trong không gian tên “$1”.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'wminc-viewuserlang-user' => 'באַניצער נאָמען:',
	'wminc-viewuserlang-go' => 'גיין',
	'wminc-testwiki' => 'פרווו וויקי',
	'wminc-testwiki-none' => 'קיינע/אלע',
	'wminc-warning-suggest' => 'איר קענט שאַפֿן א בלאַט [[$1]].',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'wminc-desc' => 'Wikimedia Incubator嘅測試wiki系統',
	'wminc-viewuserlang' => '睇用戶語言同測試wiki',
	'wminc-testwiki' => '測試wiki:',
	'wminc-testwiki-none' => '無/全部',
	'wminc-prefinfo-language' => '你嘅界面語言 - 響你嘅測試wiki獨立嘅',
	'wminc-prefinfo-code' => 'ISO 639語言碼',
	'wminc-prefinfo-project' => '揀Wikimedia計劃 (Incubator選項用來做一般嘅嘢)',
	'wminc-prefinfo-error' => '你揀咗一個需要語言碼嘅計劃。',
	'wminc-warning-unprefixed' => '警告: 你編輯嘅版未加入前綴！',
	'wminc-warning-suggest' => '你可以響[[$1]]開版。',
	'wminc-warning-suggest-move' => '你可以[{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} 搬呢一版到$1]。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Jimmy xu wrk
 * @author Liangent
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'wminc-desc' => '维基孵育场的测试wiki系统',
	'wminc-viewuserlang' => '查看用户语言与测试wiki',
	'wminc-viewuserlang-user' => '用户名：',
	'wminc-viewuserlang-go' => '转到',
	'wminc-testwiki' => '测试wiki:',
	'wminc-testwiki-none' => '无/所有',
	'wminc-prefinfo-language' => '您的接口语言 - 在您的测试wiki中为独立的',
	'wminc-prefinfo-code' => 'ISO 639语言代码',
	'wminc-prefinfo-project' => '选择维基媒体计划 （孵育场选项用作一般用途）',
	'wminc-prefinfo-error' => '您已选择一个需要语言代码的计划。',
	'wminc-warning-unprefixed' => '警告: 您编辑的页面尚未加入前缀！',
	'wminc-warning-suggest' => '您可以在[[$1]]开新页面。',
	'wminc-warning-suggest-move' => '您可以[{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} 移动这个页面到$1]。',
	'right-viewuserlang' => '查看[[Special:ViewUserLang|用户语言和测试维基]]',
	'randombytest' => '测试维基上的随机页面',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Shinjiman
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'wminc-desc' => '維基孵育場的測試wiki系統',
	'wminc-viewuserlang' => '查看用戶語言與測試wiki',
	'wminc-viewuserlang-user' => '使用者名稱：',
	'wminc-viewuserlang-go' => '轉到',
	'wminc-testwiki' => '測試wiki:',
	'wminc-testwiki-none' => '無/所有',
	'wminc-prefinfo-language' => '您的界面語言 - 在您的測試wiki中為獨立的',
	'wminc-prefinfo-code' => 'ISO 639語言代碼',
	'wminc-prefinfo-project' => '選擇維基媒體計劃 （孵育場選項用作一般用途）',
	'wminc-prefinfo-error' => '您已選擇一個需要語言代碼的計劃。',
	'wminc-warning-unprefixed' => '警告: 您編輯的頁面尚未加入前綴！',
	'wminc-warning-suggest' => '您可以在[[$1]]開新頁面。',
	'wminc-warning-suggest-move' => '您可以[{{fullurl:Special:MovePage/$3|wpNewTitle=$2}} 移動這個頁面到$1]。',
	'right-viewuserlang' => '查看[[Special:ViewUserLang|用戶語言和測試維基]]',
	'randombytest' => '測試維基上的隨機頁面',
);

