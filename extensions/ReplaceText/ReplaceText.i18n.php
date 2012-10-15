<?php
/**
 * Internationalization file for the Replace Text extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Yaron Koren
 */
$messages['en'] = array(
	// user messages
	'replacetext' => 'Replace text',
	'replacetext-desc' => 'Provides a [[Special:ReplaceText|special page]] to allow administrators to do a global string find-and-replace on all the content pages of a wiki',
	'replacetext_docu' => 'To replace one text string with another across all regular pages on this wiki, enter the two pieces of text here and then hit \'Continue\'.
You will then be shown a list of pages that contain the search text, and you can choose the ones in which you want to replace it.
Your name will appear in page histories as the user responsible for any changes.',
	'replacetext_originaltext' => 'Original text:',
	'replacetext_replacementtext' => 'Replacement text:',
	'replacetext_useregex' => 'Use regular expressions',
	'replacetext_regexdocu' => '(Example: values of "a(.*)c" for "Original text" and "ac$1" for "Replacement text" would replace "abc" with "acb".)',
	'replacetext_optionalfilters' => 'Optional filters:',
	'replacetext_categorysearch' => 'Replace only in category:',
	'replacetext_prefixsearch' => 'Replace only in pages with the prefix:',
	'replacetext_editpages' => 'Replace text in page contents',
	'replacetext_movepages' => 'Replace text in page titles, when possible',
	'replacetext_givetarget' => 'You must specify the string to be replaced.',
	'replacetext_nonamespace' => 'You must select at least one namespace.',
	'replacetext_editormove' => 'You must select at least one of the replacement options.',
	'replacetext_choosepagesforedit' => 'Replace "$1" with "$2" in the text of the following {{PLURAL:$3|page|pages}}:',
	'replacetext_choosepagesformove' => 'Replace "$1" with "$2" in the {{PLURAL:$3|title of the following page|titles of the following pages}}:',
	'replacetext_cannotmove' => 'The following {{PLURAL:$1|page|pages}} cannot be moved:',
	'replacetext_formovedpages' => 'For moved pages:',
	'replacetext_savemovedpages' => 'Save the old titles as redirects to the new titles',
	'replacetext_watchmovedpages' => 'Watch these pages',
	'replacetext_invertselections' => 'Invert selections',
	'replacetext_replace' => 'Replace',
	'replacetext_success' => '"$1" will be replaced with "$2" in $3 {{PLURAL:$3|page|pages}}.',
	'replacetext_noreplacement' => 'No pages were found containing the string "$1".',
	'replacetext_nomove' => 'No pages were found whose title contains "$1".',
	'replacetext_nosuchcategory' => 'No category exists with the name "$1".',
	'replacetext_return' => 'Return to form.',
	'replacetext_warning' => "'''Warning:''' There {{PLURAL:$1|is $1 page that already contains|are $1 pages that already contain}} the replacement string, \"$2\". If you make this replacement you will not be able to separate your replacements from these strings.",
	'replacetext_blankwarning' => "'''Warning:''' Because the replacement string is blank, this operation will not be reversible.",
	'replacetext_continue' => 'Continue',
	// content messages
	'replacetext_editsummary' => 'Text replace - "$1" to "$2"',
	'right-replacetext' => 'Do string replacements on the entire wiki',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Kwj2772
 * @author McMonster
 * @author Nike
 * @author Purodha
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'replacetext' => "This message is displayed as a title of this extension's special page.",
	'replacetext-desc' => '{{desc}}

{{Identical|Content page}}',
	'replacetext_docu' => "Description of how to use this extension, displayed on the extension's special page ([[Special:ReplaceText]]).",
	'replacetext_originaltext' => 'Label of the text field, where user enters original piece of text, which would be replaced.',
	'replacetext_regexdocu' => '* "Original text" - {{msg-mw|replacetext_originaltext}}
* "Replacement text" - {{msg-mw|replacetext_replacementtext}}',
	'replacetext_choosepagesforedit' => 'Displayed over the list of pages where the given text was found.',
	'replacetext_replace' => 'Label of the button, which triggers the begin of replacment.

{{Identical|Replace}}',
	'replacetext_continue' => '{{Identical|Continue}}',
	'right-replacetext' => '{{doc-right|replacetext}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'replacetext' => 'Vervang teks',
	'replacetext-desc' => "Administrateurs kan via 'n [[Special:ReplaceText|spesiale bladsy]] teks in alle bladsye soek en vervang",
	'replacetext_originaltext' => 'Oorspronklike teks:',
	'replacetext_replacementtext' => 'Vervangende teks:',
	'replacetext_optionalfilters' => 'Opsionele filters:',
	'replacetext_categorysearch' => 'Vervang slegs in kategorie:',
	'replacetext_prefixsearch' => 'Vervang slegs in bladsye met voorvoegsel:',
	'replacetext_editpages' => 'Vervang teks in die bladsy-inhoud',
	'replacetext_movepages' => 'Vervang teks in bladsyname (waar moontlik)',
	'replacetext_givetarget' => 'U moet die string wat vervang moet word verskaf',
	'replacetext_nonamespace' => 'U moet ten minste een naamruimte kies.',
	'replacetext_editormove' => 'U moet ten minste een van die vervangingsopsies kies.',
	'replacetext_choosepagesforedit' => "Kies die {{PLURAL:$3|bladsy|blaaie}} waar u '$1' met '$2' wil vervang:",
	'replacetext_choosepagesformove' => 'Vervang "$1" met "$2" in die volgende {{PLURAL:$3|bladsynaam|bladsyname}}:',
	'replacetext_cannotmove' => 'Die volgende {{PLURAL:$1|bladsy|blaaie}} kan nie geskuif word nie:',
	'replacetext_formovedpages' => 'Vir geskuifde bladsye:',
	'replacetext_savemovedpages' => 'Stoor die ou bladsyname as aansture na die nuwe name',
	'replacetext_watchmovedpages' => 'Hou hierdie bladsy dop',
	'replacetext_invertselections' => 'Omgekeerde seleksie',
	'replacetext_replace' => 'Vervang',
	'replacetext_success' => '"$1" word in $3 {{PLURAL:$3|bladsy|blaaie}} met "$2" vervang.',
	'replacetext_noreplacement' => "Daar was geen bladsye wat die teks '$1' bevat gevind nie.",
	'replacetext_nomove' => 'Daar is geen bladsye met "$1" in die naam gevind nie.',
	'replacetext_nosuchcategory' => 'Die kategorie "$1" bestaan nie.',
	'replacetext_return' => 'Terug na die vorm.',
	'replacetext_blankwarning' => 'Omdat u teks met niks vervang kan hierdie aksie nie ongedaan gemaak word nie.
Wil u voortgaan?',
	'replacetext_continue' => 'Gaan voort',
	'replacetext_editsummary' => "Teks vervang - '$1' na '$2'",
	'right-replacetext' => 'Doen vervangings oor die hele wiki',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'replacetext' => 'استبدل النص',
	'replacetext-desc' => 'يوفر [[Special:ReplaceText|صفحة خاصة]] للسماح للإداريين للقيام بعملية أوجد واستبدل على نص في كل صفحات المحتوى لويكي',
	'replacetext_docu' => "لاستبدال سلسلة نص بأخرى عبر كل الصفحات العادية في هذا الويكي، أدخل قطعتي النص هنا ثم اضغط 'استمرار'. سيعرض عليك بعد ذلك قائمة بالصفحات التي تحتوي على نص البحث، ويمكنك اختيار اللواتي تريد الاستبدال فيها. اسمك سيظهر في تواريخ الصفحات كالمستخدم المسؤول عن أية تغييرات.",
	'replacetext_originaltext' => 'النص الأصلي:',
	'replacetext_replacementtext' => 'نص الاستبدال:',
	'replacetext_optionalfilters' => 'مرشحات اختيارية:',
	'replacetext_categorysearch' => 'استبدل فقط في التصنيف:',
	'replacetext_prefixsearch' => 'استبدل فقط في الصفحات ذات البادئة:',
	'replacetext_editpages' => 'استبدل النص في محتويات الصفحة',
	'replacetext_movepages' => 'استبدل النص في عناوين الصفحات، عندما يكون ممكنا',
	'replacetext_givetarget' => 'لابد أن تحدد السلسلة التي تريد استبدالها',
	'replacetext_nonamespace' => 'يجب أن تختار على الأقل نطاقا واحدا.',
	'replacetext_editormove' => 'لابد أن تختار خيار واحد على الأقل من خيارات الاستبدال.',
	'replacetext_choosepagesforedit' => "استبدال ب'$1' '$2' في نص {{PLURAL:$3||الصفحة التالية|الصفحتين التاليتين|الصفحات التالية}}:",
	'replacetext_choosepagesformove' => 'استبدل "$1" ب"$2" في {{PLURAL:$3||اسم الصفحة التالية|اسمي الصفحتين التاليتين|أسماء الصفحات التالية}}:',
	'replacetext_cannotmove' => 'لا يمكن نقل {{PLURAL:$1||الصفحة التالية|الصفحتين التاليتين|الصفحات التالية}}:',
	'replacetext_formovedpages' => 'للصفحات المنقولة:',
	'replacetext_savemovedpages' => 'احفظ العناوين القديمة كتحويلات للعناوين الجديدة',
	'replacetext_watchmovedpages' => 'راقب هذه الصفحات',
	'replacetext_invertselections' => 'عكس الاختيارات',
	'replacetext_replace' => 'استبدل',
	'replacetext_success' => "سوف تستبدل '$2' ب'$1' في {{PLURAL:$3||صفحة واحدة|صفحتين|$3 صفحات|$3 صفحة}}.",
	'replacetext_noreplacement' => "لا صفحات تم العثور عليها تحتوي على السلسلة '$1'.",
	'replacetext_nomove' => "لم توجد صفحات تحتوي عناوينها '$1'.",
	'replacetext_nosuchcategory' => 'لا يوجد تصنيف بالاسم "$1".',
	'replacetext_return' => 'رجوع إلى الاستمارة',
	'replacetext_warning' => "'''تحذير''': توجد {{PLURAL:$1||صفحة واحدة تحتوي|صفحتان تحتويان|$1 صفحات تحتوي|$1 صفحة تحتوي}} بالفعل على سلسلة الاستبدال '$2'. إذا قمت بهذا الاستبدال فلن تصبح قادرًا على فصل استبدالاتك عن هذه السلاسل.",
	'replacetext_blankwarning' => 'لأن سلسلة الاستبدال فارغة، هذه العملية لن تكون عكسية؛ استمر؟',
	'replacetext_continue' => 'استمر',
	'replacetext_editsummary' => "استبدال النص - '$1' ب'$2'",
	'right-replacetext' => 'القيام باستبدال للسلاسل في الويكي بأكمله',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'replacetext_originaltext' => 'ܟܬܒܬܐ ܫܪܫܝܬܐ:',
	'replacetext_watchmovedpages' => 'ܪܗܝ ܦܐܬܬ̈ܐ ܗܠܝܢ',
	'replacetext_invertselections' => 'ܐܗܦܟ ܠܓܘܒܝ̈ܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'replacetext' => 'استبدل النص',
	'replacetext-desc' => 'يوفر [[Special:ReplaceText|صفحة خاصة]] للسماح للإداريين للقيام بعملية أوجد واستبدل على نص فى كل صفحات المحتوى لويكي',
	'replacetext_docu' => "لاستبدال سلسلة نص بأخرى عبر كل الصفحات العادية فى هذا الويكى، أدخل قطعتى النص هنا ثم اضغط 'استمرار'. سيعرض عليك بعد ذلك قائمة بالصفحات التى تحتوى على نص البحث، ويمكنك اختيار اللواتى تريد الاستبدال فيها. اسمك سيظهر فى تواريخ الصفحات كالمستخدم المسؤول عن أية تغييرات.",
	'replacetext_originaltext' => 'النص الأصلي:',
	'replacetext_replacementtext' => 'نص الاستبدال:',
	'replacetext_movepages' => 'استبدل النص فى عناوين الصفحات، عندما يكون ممكنا',
	'replacetext_choosepagesforedit' => "من فضلك اختار {{PLURAL:$3|الصفحه|الصفحات}} اللى فيها عايز تستبدل ب'$1' '$2':",
	'replacetext_choosepagesformove' => 'استبدل "$1" ب"$2" فى {{PLURAL:$3||اسم الصفحة التالية|اسمى الصفحتين التاليتين|أسماء الصفحات التالية}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|الصفحة|الصفحات}} التالية لا يمكن نقلها:',
	'replacetext_savemovedpages' => 'احفظ العناوين القديمة كتحويلات للعناوين الجديدة',
	'replacetext_invertselections' => 'عكس الاختيارات',
	'replacetext_replace' => 'استبدل',
	'replacetext_success' => "'$1' ح تتبدل بـ '$2' فى $3 {{PLURAL:$3|صفحه|صفحات}}.",
	'replacetext_noreplacement' => "لا صفحات تم العثور عليها تحتوى على السلسلة '$1'.",
	'replacetext_return' => 'رجوع إلى الإستمارة',
	'replacetext_warning' => "فيه $1 {{PLURAL:$1|$1 صفحه|$1 صفحات}} فيها سلسلة الاستبدال، '$2'.
لو أنك قمت بالاستبدال ده مش  هاتقدر تفصل استبدالاتك من السلاسل دى.
استمرار مع الاستبدال؟",
	'replacetext_blankwarning' => 'لأن سلسلة الاستبدال فارغة، هذه العملية لن تكون عكسية؛ استمر؟',
	'replacetext_continue' => 'استمر',
	'replacetext_editsummary' => "استبدال النص - '$1' ب'$2'",
	'right-replacetext' => 'القيام باستبدال للسلاسل فى الويكى بأكمله',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'replacetext_originaltext' => 'Orijinal mətn:',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'replacetext' => 'Тексты алмаштырырға',
	'replacetext-desc' => 'Хәкимдәргә бөтә эстәлек биттәрендә тексты табып алмаштырырға мөмкинлек биреүсе [[Special:ReplaceText|махсус бит]] менән тәьмин итә',
	'replacetext_docu' => 'Был викиның бөтә биттәрендә бер текст юлын икенсе менән алмаштырыр өсөн, ике текст керетегеҙ һәм "Дауам итергә" төймәһенә баҫығыҙ.
Артабан һеҙгә эҙләнгән тексты үҙ эсенә алған биттәр исемлеге күрһәтеләсәк, һеҙ улар араһында алмаштырырға теләгәндәрен һайлай алаһығыҙ.
Һеҙҙең исемегеҙ биттәрҙең үҙгәртеү тарихтарында үҙгәртеүҙәргә яуаплы ҡатнашыусы булараҡ күрһәтеләсәк.',
	'replacetext_originaltext' => 'Сығанаҡ текст:',
	'replacetext_replacementtext' => 'Алмаш текст:',
	'replacetext_useregex' => 'Регуляр аңлатмаларҙы ҡулланырға',
	'replacetext_regexdocu' => '(Миҫал: "Сығанаҡ текст" өсөн "a(.*)c" аңлатмаһы һәм "Алмаш текст" өсөн "ac$1" "abc" тексын "acb" тип алмаштырасаҡ.)',
	'replacetext_optionalfilters' => 'Мөһим булмаған һөҙгөстәр:',
	'replacetext_categorysearch' => 'Был категорияла ғына алмаштырырға:',
	'replacetext_prefixsearch' => 'Ошо хәрефтәр менән башланған биттәрҙә генә алмаштырырға:',
	'replacetext_editpages' => 'Тексты бит эстәлектәрендә алмаштырырға',
	'replacetext_movepages' => 'Тексты бит исемдәрендә, мөмкин булһа, алмаштырырға',
	'replacetext_givetarget' => 'Һеҙ алмаштырыла торған юлды күрһәтергә тейешһегеҙ.',
	'replacetext_nonamespace' => 'Һеҙ кәмендә бер исемдәр арауығын һайларға тейешһегеҙ.',
	'replacetext_editormove' => 'Һеҙ кәмендә бер алмаштырыу төрөн һайларға тейешһегеҙ.',
	'replacetext_choosepagesforedit' => '"$1" тексын "$2" менән түбәндәге {{PLURAL:$3|биттә|биттәрҙә}} алмаштырырға:',
	'replacetext_choosepagesformove' => '"$1" тексын "$2" менән түбәндәге бит {{PLURAL:$3|исемендә|исемдәрендә}} алмаштырырға:',
	'replacetext_cannotmove' => 'Түбәндәге {{PLURAL:$1|биттең|биттәрҙең}} исемен үҙгәртеп булмай:',
	'replacetext_formovedpages' => 'Исемдәре үҙгәртелгән биттәр өсөн:',
	'replacetext_savemovedpages' => 'Иҫке исемдәрен яңы исемдәргә йүнәлтеүҙәр рәүешендә һаҡларға',
	'replacetext_watchmovedpages' => 'Был биттәрҙе күҙәтеүҙәр исемлегенә индерергә',
	'replacetext_invertselections' => 'Һайланғандарҙы әйләндерергә',
	'replacetext_replace' => 'Алмаштырырға',
	'replacetext_success' => '"$1" "$2" менән $3 {{PLURAL:$3|биттә}} алмаштырыласаҡ.',
	'replacetext_noreplacement' => '"$1" юлын үҙ эсенә алған бер бит тә табылманы.',
	'replacetext_nomove' => 'Исемендә "$1" булған бер бит тә табылманы.',
	'replacetext_nosuchcategory' => '"$1" исемле бер категория ла юҡ.',
	'replacetext_return' => 'Формаға кире ҡайтырға.',
	'replacetext_warning' => "'''Иғтибар:''' Алмаш \"\$2\" тексын үҙ эсенә алған {{PLURAL:\$1|\$1 бит}} бар инде. Әгәр һеҙ алмаштырыуҙы башҡарһағыҙ, алмаштырылған текстарҙы булғандарынан айыра алмаясаҡһығыҙ.",
	'replacetext_blankwarning' => "'''Иғтибар:'''Алмаш текст буш булғанға күрә, был ғәмәлде кире алыу мөмкин түгел.",
	'replacetext_continue' => 'Дауам итергә',
	'replacetext_editsummary' => '"$1" тексын "$2" менән алмаштырыу',
	'right-replacetext' => 'Бөтә викила тексты алмаштырыу',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'replacetext' => 'Замяніць тэкст',
	'replacetext-desc' => 'Дадае [[Special:ReplaceText|спэцыяльную старонку]], якая дазваляе адміністратарам глябальны пошук і замену тэксту ва усіх старонках вікі',
	'replacetext_docu' => "Каб замяніць адзін радок на іншы ва ўсіх звычайных старонках {{GRAMMAR:родны|{{SITENAME}}}}, увядзіце два радкі тут, а потым націсьніце 'Працягваць'. Будзе паказаны сьпіс старонак, якія ўтрымліваюць тэкст, які Вы шукалі, і Вы зможаце выбраць старонкі, дзе Вы жадаеце зрабіць замену. Ваша імя будзе запісанае ў гісторыю старонкі, таму што ўдзельнікі адказныя за ўсе зробленыя зьмены.",
	'replacetext_originaltext' => 'Арыгінальны тэкст:',
	'replacetext_replacementtext' => 'Тэкст на замену:',
	'replacetext_useregex' => 'Выкарыстоўваць рэгулярныя выразы',
	'replacetext_regexdocu' => '(Напрыклад, выразы «a(.*)c» ў полі «Арыгінальны тэкст» і «ac$1» у полі «Тэкст на замену» прывядуць да замены «abc» на «acb».)',
	'replacetext_optionalfilters' => 'Неабавязковыя фільтры:',
	'replacetext_categorysearch' => 'Замяніць толькі ў катэгорыі:',
	'replacetext_prefixsearch' => 'Замяніць толькі ў старонках, назвы якіх пачынаюцца з:',
	'replacetext_editpages' => 'Замяніць тэкст ў зьмесьце старонак',
	'replacetext_movepages' => 'Замяніць тэкст у назвах старонак, калі гэта магчыма',
	'replacetext_givetarget' => 'Вам неабходна пазначыць радок для замены.',
	'replacetext_nonamespace' => 'Вам неабходна выбраць хаця б адну прастору назваў.',
	'replacetext_editormove' => 'Вам неабходна выбраць хаця б адну з наладаў пераносу.',
	'replacetext_choosepagesforedit' => 'Калі ласка, выберыце {{PLURAL:$3|старонку, у якой|старонкі, у якіх}} Вы жадаеце замяніць «$1» на «$2»:',
	'replacetext_choosepagesformove' => 'Замяніць «$1» на «$2» у {{PLURAL:$3|назьве наступнай старонкі|назвах наступных старонак}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Наступная старонка ня можа быць перанесена|Наступныя старонкі ня могуць быць перанесены}}:',
	'replacetext_formovedpages' => 'Для перанесеных старонак:',
	'replacetext_savemovedpages' => 'Захаваць старыя назвы як перанакіраваньні на новыя',
	'replacetext_watchmovedpages' => 'Назіраць за гэтымі старонкамі',
	'replacetext_invertselections' => 'Адваротны выбар',
	'replacetext_replace' => 'Замяніць',
	'replacetext_success' => '«$1» будзе заменены на «$2» ў $3 {{PLURAL:$3|старонцы|старонках|старонках}}.',
	'replacetext_noreplacement' => 'Старонак, якія ўтрымліваюць тэкст «$1» ня знойдзена.',
	'replacetext_nomove' => 'Ня знойдзена старонак, у назвах якіх утрымліваецца «$1».',
	'replacetext_nosuchcategory' => 'Не існуе катэгорыі з назвай «$1».',
	'replacetext_return' => 'Вярнуцца да формы.',
	'replacetext_warning' => "'''Папярэджаньне:''' Існуе $1 {{PLURAL:$1|старонка, якая ўтрымлівае|старонкі, якія ўтрымліваюць|старонак, якія ўтрымліваюць}} тэкст на замену «$2».
Калі Вы зробіце гэту замену, Вы ня зможаце аддзяліць Вашыя замены ад гэтых тэкстаў.",
	'replacetext_blankwarning' => 'У выніку таго, што радок, на які павінна адбыцца замена, пусты, апэрацыя ня будзе выкананая.
Вы жадаеце працягваць?',
	'replacetext_continue' => 'Працягваць',
	'replacetext_editsummary' => 'Замена тэксту: «$1» на «$2»',
	'right-replacetext' => 'замена тэксту ва ўсёй вікі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'replacetext' => 'Заместване на текст',
	'replacetext-desc' => 'Предоставя [[Special:ReplaceText|специална страница]], чрез която администраторите могат да извършват глобално откриване-и-заместване на низове в страниците на уикито',
	'replacetext_originaltext' => 'Оригинален текст:',
	'replacetext_replacementtext' => 'Текст за заместване:',
	'replacetext_choosepagesforedit' => "Изберете страници, в които желаете да замените '$1' с '$2':",
	'replacetext_replace' => 'Заместване',
	'replacetext_success' => "Заместване на '$1' с '$2' в $3 страници.",
	'replacetext_noreplacement' => "Не бяха открити страници, съдържащи низа '$1'.",
	'replacetext_blankwarning' => 'Тъй като низът за заместване е празен, процесът на заместване е необратим; продължаване?',
	'replacetext_continue' => 'Продължаване',
	'replacetext_editsummary' => "Заместване на текст - '$1' на '$2'",
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'replacetext' => 'লেখা প্রতিস্থাপন',
	'replacetext_originaltext' => 'মূল লেখা:',
	'replacetext_replacementtext' => 'প্রতিস্থাপিত লেখা:',
	'replacetext_useregex' => 'রেগুলার এক্সপ্রেশন ব্যবহার করো',
	'replacetext_optionalfilters' => 'ঐচ্ছিক ফিল্টার',
	'replacetext_categorysearch' => 'শুধুমাত্র বিষয়শ্রেণীতেই প্রতিস্থাপন করো:',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'replacetext' => "Erlec'hiañ an destenn",
	'replacetext-desc' => "Pourchas a ra ur [[Special:ReplaceText|bajenn dibar]] a aotre ar verourien da erlec'hiañ steudadoù arouezennoù dre arouezennoù all er wiki a-bezh",
	'replacetext_docu' => "Evit erlec'hiañ ur steudad arouezennoù gant unan all e holl bajennoù boutin ar wiki-mañ e c'hallit merkañ an div destenn amañ ha klikañ war 'kenderc'hel'.
Diskouezet e vo deoc'h ur roll pajennoù m'emañ an destenn klasket enno ha gallout a reot dibab ar re a fell deoc'h cheñch.
War wel e teuio hoc'h anv war roll istor pep pajenn evit ma vo gouezet gant piv eo bet graet ar cheñchamant.",
	'replacetext_originaltext' => 'Testenn orin :',
	'replacetext_replacementtext' => "Testenn erlec'hiañ :",
	'replacetext_useregex' => 'Ober gant jedadennoù reoliek',
	'replacetext_regexdocu' => '(Da skouer : Talvoudenn "a(.*)c" evit "Testenn orin" ha "ac$1" evit "Testenn erlec\'hiañ" a vo erlec\'ho "abc" gant "acb".)',
	'replacetext_optionalfilters' => 'Siloù diret :',
	'replacetext_categorysearch' => "Erlec'hiañ er rummad hepken :",
	'replacetext_prefixsearch' => "Erlec'hiañ hepken er bajennoù gant ar rakger :",
	'replacetext_editpages' => "Erlec'hiañ an destenn e-mesk danvez ar bajenn",
	'replacetext_movepages' => "Erlec'hiañ an destenn e titl ar pajennoù, pa vez posupl",
	'replacetext_givetarget' => "Rankout a rit reiñ ar chadenn a rank bezañ erlec'hiet.",
	'replacetext_nonamespace' => "Rankout a rit dibab un esaouenn anv d'an nebeutañ.",
	'replacetext_editormove' => "Rankout a rit dibab d'an nebeutañ un dibarzh erlec'hiañ.",
	'replacetext_choosepagesforedit' => 'Erlec\'hiañ "$1" gant "$2" e testenn ar bajenn{{PLURAL:$3||où}} da heul :',
	'replacetext_choosepagesformove' => 'Erlec\'hiañ  "$1" gant "$2" e titl{{PLURAL:$3| ar bajenn da heul|où ar bajennoù da heul}} :',
	'replacetext_cannotmove' => "Ne c'hell ket bezañ fiñvet ar bajenn{{PLURAL:$1||où}} da heul :",
	'replacetext_formovedpages' => "Evit ar pajennoù dilec'hiet :",
	'replacetext_savemovedpages' => 'Enrollañ an titloù kozh evel adkasoù davet an titloù nevez',
	'replacetext_watchmovedpages' => 'Evezhiañ ar pajennoù-mañ',
	'replacetext_invertselections' => 'Eilpennañ an diuzadennoù',
	'replacetext_replace' => "Erlec'hiañ",
	'replacetext_success' => '"$1" a vo erlec\'hiet gant "$2" e $3 pajenn{{PLURAL:$3||}}.',
	'replacetext_noreplacement' => "N'eus bet kavet pajenn ebet gant an neudennad « $1 ».",
	'replacetext_nomove' => 'N\'eo bet kavet pennad ebet gant "$1" en ul lodenn eus an titl.',
	'replacetext_nosuchcategory' => "N'eus rummad ebet en anv « $1 ».",
	'replacetext_return' => "Distreiñ d'ar furmskrid.",
	'replacetext_warning' => "'''Diwallit :''' {{PLURAL:\$1| \$1 bajenn enni| \$1 pajenn enno}} ar steudad arouezennoù erlec'hiañ zo dija, \"\$2\". Ma kasit ar cheñchamant da benn ne vo ket posupl diforc'hañ ar cheñchamantoù degaset ganeoc'h diouzh an neudennadoù-se ken.",
	'replacetext_blankwarning' => "'''Diwallit : ''' Dre m'eo goullo ar steudad erlec'hiañ, ne vo ket tu da zizober an urzh-mañ.",
	'replacetext_continue' => "Kenderc'hel",
	'replacetext_editsummary' => 'Erlec\'hiañ an destenn - "$1" dre "$2"',
	'right-replacetext' => "Krouiñ erlec'hiadurioù testenn er wiki a-bezh",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'replacetext' => 'Zamijeni tekst',
	'replacetext-desc' => 'Dodaje [[Special:ReplaceText|posebnu stranicu]] koja omogućava administratorima da izvrše globalnu pretragu nađi-i-zamijeni na svim stranicama sadržaja na wikiju.',
	'replacetext_docu' => "Da bi ste zamijenili jedan tekst s drugim po svim regularnim stranicama na ovom wikiju, unesite dva dijela teksta ovdje i kliknite 'Nastavi'. Prikazat će Vam se spisak stranica koje sadrže traženi tekst, i možete odabrati one kod kojih želite taj tekst zamijeniti. Vaše ime će se prikazati na historiji izmjena stranice kao korisnika koji je odgovoran za sve promjene.",
	'replacetext_originaltext' => 'Prvobitni tekst:',
	'replacetext_replacementtext' => 'Tekst za zamjenu:',
	'replacetext_useregex' => 'Koristi regularne izraze',
	'replacetext_regexdocu' => '(Primjer: vrijednosti od "a(.*)c" za "Prvobitni tekst" i "ac$1" za "Novi tekst" će zamijeniti "abc" sa "acb".)',
	'replacetext_optionalfilters' => 'Opcionalni filteri:',
	'replacetext_categorysearch' => 'Zamijeni samo u kategoriji:',
	'replacetext_prefixsearch' => 'Zamijeni samo na stranicama sa prefiksom:',
	'replacetext_editpages' => 'Zamijeni tekst u sadržaju stranice',
	'replacetext_movepages' => 'Zamijeni tekst u naslovima stranica, ako je moguće',
	'replacetext_givetarget' => 'Morate navesti znakove koji se zamjenjuju.',
	'replacetext_nonamespace' => 'Morate odabrati najmanje jedan imenski prostor.',
	'replacetext_editormove' => 'Morate odabrati najmanje jednu od opcija za zamjenu.',
	'replacetext_choosepagesforedit' => "Molimo odaberite {{PLURAL:$3|stranicu|stranice}} za {{PLURAL:$3|koju|koje}} želite zamijeniti '$1' sa '$2':",
	'replacetext_choosepagesformove' => 'Zamjena "$1" sa "$2" u nazivu {{PLURAL:$3|slijedeće stranice|slijedećih stranica}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Slijedeća stranica|Slijedeće stranice}} se ne mogu premjestiti:',
	'replacetext_formovedpages' => 'Za premještene stranice:',
	'replacetext_savemovedpages' => 'Spremi stare naslove kao preusmjerenja na nove naslove',
	'replacetext_watchmovedpages' => 'Prati ove stranice',
	'replacetext_invertselections' => 'Preokreni odabir',
	'replacetext_replace' => 'Zamijeni',
	'replacetext_success' => "'$1' će biti zamijenjeno sa '$2' na $3 {{PLURAL:$3|stranici|stranice|stranica}}.",
	'replacetext_noreplacement' => "Nije pronađena nijedna stranica koja sadrži '$1'.",
	'replacetext_nomove' => "Nijedna stranica nije pronađena čiji naslov sadrži '$1'.",
	'replacetext_nosuchcategory' => 'Ne postoji nijedna kategorija pod nazivom "$1".',
	'replacetext_return' => 'Nazad na obrazac.',
	'replacetext_warning' => "'''Upozorenje:''' {{PLURAL:$1|Postoji $1 stranica koja već sadrži|Postoje $1 stranice koje već sadrže|Postoji $1 stranica koje već sadrže}} zamjenski tekst ''$2''.
Ako želite napraviti ovu zamjenu nećete biti u mogućnosti da razdvojite Vaše zamjene od ovih tekstova.",
	'replacetext_blankwarning' => 'Pošto je zamjenski tekst prazan, ovu operaciju neće biti moguće vratiti.
Da li želite nastaviti?',
	'replacetext_continue' => 'Nastavi',
	'replacetext_editsummary' => "Zamjena teksta - '$1' u '$2'",
	'right-replacetext' => 'Pravljenje zamjene teksta na cijelom wikiju',
);

/** Catalan (Català)
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'replacetext_continue' => 'Continua',
	'right-replacetext' => 'Fer substitucions de cadena a tot el wiki',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'replacetext_optionalfilters' => 'Тlедожийна доцу литтарш:',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'replacetext' => 'Nahradit text',
	'replacetext-desc' => 'Poskytuje [[Special:ReplaceText|speciální stránku]], která správcům umožňuje globálně najít a nahradit nějaký text na všech obsahových stránkách wiki',
	'replacetext_docu' => 'Pro nahrazení jednoho textového řetězce jiným na všech běžných stránkách této wiki sem zadejte ony dva texty a klikněte na „Pokračovat“.
Zobrazí se seznam stránek obsahujících hledaný text, ze kterých si budete moci vybrat ty, na kterých chcete provést nahrazení.
Vaše jméno se objeví v historiích stránek jako osoba zodpovědná za příslušné změny.',
	'replacetext_originaltext' => 'Původní text:',
	'replacetext_replacementtext' => 'Nahradit textem:',
	'replacetext_replace' => 'Nahradit',
	'replacetext_continue' => 'Pokračovat',
	'replacetext_editsummary' => 'Nahrazení textu „$1“ textem „$2“',
	'right-replacetext' => 'Hledání a nahrazování textu na celé wiki',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Leithian
 * @author Melancholie
 * @author Merlissimo
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'replacetext' => 'Text ersetzen',
	'replacetext-desc' => 'Ergänzt eine [[Special:ReplaceText|Spezialseite]], die eine globale Text-suchen-und-ersetzen-Operation auf allen Inhaltsseiten ermöglicht',
	'replacetext_docu' => 'Um einen Text durch einen anderen Text auf allen Inhaltsseiten zu ersetzen, gib hier die beiden Textteile ein und klicke danach auf die „Fortsetzen“-Schaltfläche. Auf der dann folgenden Seite erhält man eine Aufzählung der Seiten, die den zu ersetzenden Text enthalten. Dort kann man auch auswählen, auf welchen Seiten die Ersetzungen durchgeführt werden sollen. Dein Benutzername wird während der Ersetzungen in der Versionsgeschichte aufgenommen.',
	'replacetext_originaltext' => 'Originaltext:',
	'replacetext_replacementtext' => 'Neuer Text:',
	'replacetext_useregex' => 'Platzhalter und reguläre Ausdrücke verwenden',
	'replacetext_regexdocu' => '(Beispiel: Die Werte für „a(.*)c“ für „Originaltext“ und „ac$1“ für „Neuer Text“ würden zur Ersetzung „abc“ durch „acb“ führen.)',
	'replacetext_optionalfilters' => 'Optionale Filter:',
	'replacetext_categorysearch' => 'Ersetze nur in der Kategorie:',
	'replacetext_prefixsearch' => 'Ersetze nur in Seiten mit dem Präfix:',
	'replacetext_editpages' => 'Ersetze Text im Seiteninhalt',
	'replacetext_movepages' => 'Ersetze Text auch in Seitentiteln, wenn möglich',
	'replacetext_givetarget' => 'Du musst eine Zeichenkette angeben, die ersetzt werden soll.',
	'replacetext_nonamespace' => 'Mindestens ein Namensraum muss ausgewählt werden.',
	'replacetext_editormove' => 'Du musst mindestens eine Ersetzungsoption wählen.',
	'replacetext_choosepagesforedit' => 'Ersetzen von „$1“ durch „$2“ im Text der {{PLURAL:$3|Seite|Seiten}}:',
	'replacetext_choosepagesformove' => 'Ersetze „$1“ durch „$2“ im Titel der folgenden {{PLURAL:$3|Seite|Seiten}}:',
	'replacetext_cannotmove' => 'Die {{PLURAL:$1|folgende Seite kann|folgenden Seiten können}} nicht verschoben werden:',
	'replacetext_formovedpages' => 'Für verschobene Seiten:',
	'replacetext_savemovedpages' => 'Eine Weiterleitung für die verschobene Seite anlegen',
	'replacetext_watchmovedpages' => 'Diese Seiten beobachten',
	'replacetext_invertselections' => 'Auswahl umkehren',
	'replacetext_replace' => 'Ersetzen',
	'replacetext_success' => '„$1“ wird durch „$2“ in $3 {{PLURAL:$3|Seite|Seiten}} ersetzt.',
	'replacetext_noreplacement' => 'Es wurde keine Seite gefunden, die den Text „$1“ enthält.',
	'replacetext_nomove' => 'Es wurden keine Titel gefunden, die „$1“ beinhalten.',
	'replacetext_nosuchcategory' => 'Es gibt keine Kategorie mit dem Namen „$1“.',
	'replacetext_return' => 'Zurück zum Formular.',
	'replacetext_warning' => "'''Warnung:''' $1 {{PLURAL:$1|Seite enthält|Seiten enthalten}} bereits den zu ersetzenden Textteil „$2“.
Sofern du nun die {{PLURAL:$1|Ersetzung|Ersetzungen}} durchführst, ist eine spätere Unterscheidung zwischen den nunmehr zu ersetzenden und den bereits vorhandenen Textteilen nicht mehr möglich.",
	'replacetext_blankwarning' => "'''Warnung:''' Da der zu ersetzende Textteil leer ist, kann die Operation nicht rückgängig gemacht werden. Möchtest du dennoch fortfahren?",
	'replacetext_continue' => 'Fortfahren',
	'replacetext_editsummary' => 'Textersetzung - „$1“ durch „$2“',
	'right-replacetext' => 'Textersetzung für das gesamte Wiki durchführen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'replacetext_docu' => 'Um einen Text durch einen anderen Text auf allen Inhaltsseiten zu ersetzen, geben Sie hier die beiden Textteile ein und klicken danach auf die „Fortsetzen“-Schaltfläche. Auf der dann folgenden Seite erhält man eine Aufzählung der Seiten, die den zu ersetzenden Text enthalten. Dort kann man auch auswählen, auf welchen Seiten die Ersetzungen durchgeführt werden sollen. Ihr Benutzername wird während der Ersetzungen in der Versionsgeschichte aufgenommen.',
	'replacetext_givetarget' => 'Sie müssen eine Zeichenkette angeben, die ersetzt werden soll.',
	'replacetext_editormove' => 'Sie müssen mindestens eine Ersetzungsoption wählen.',
	'replacetext_warning' => "'''Warnung:''' $1 {{PLURAL:$1|Seite enthält|Seiten enthalten}} bereits den zu ersetzenden Textteil „$2“.
Sofern Sie nun die {{PLURAL:$1|Ersetzung|Ersetzungen}} durchführen, ist eine spätere Unterscheidung zwischen den nunmehr zu ersetzenden und den bereits vorhandenen Textteilen nicht mehr möglich.",
	'replacetext_blankwarning' => "'''Warnung:''' Da der zu ersetzende Textteil leer ist, kann die Operation nicht rückgängig gemacht werden. Möchten Sie dennoch fortfahren?",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'replacetext' => 'Tekst wuměniś',
	'replacetext-desc' => 'Staja [[Special:ReplaceText|specialny bok]] k dispoziciji, aby zmóžnił administratoram operaciju globalnego namakanja-wuměnjenja na wšych wopśimjeśowych bokach wikija pśewjasć',
	'replacetext_docu' => "Aby wuměnił tekst pśez drugi tekst na wšych regularnych bokach w toś tom wikiju, zapódaj wobej tekstowej źěla a klikni na 'Dalej'. Buźoš pótom lisćinu bokow wiźeś, kótarež wopśimuju pytański tekst a móžoš wubraś te, w kótarychž coš jen wuměniś. Twójo mě zjawijo se w stawiznach boka ako wužywaŕ, kótaryž jo zagronity za te změny.",
	'replacetext_originaltext' => 'Originalny tekst:',
	'replacetext_replacementtext' => 'Tekst pó wuměnjenju:',
	'replacetext_useregex' => 'Regularne wuraze wužywaś',
	'replacetext_regexdocu' => '(Pśikład: gódnoty za "a(.*)c" za "originalny tekst" a "ac$1" za "nowy tekst" by "abc" pśez "acb" wuměnili.)',
	'replacetext_optionalfilters' => 'Opcionalne filtry:',
	'replacetext_categorysearch' => 'Jano w kategoriji wuměniś:',
	'replacetext_prefixsearch' => 'Jano w bokach wuměniś z prefiksom:',
	'replacetext_editpages' => 'Tekst w datajowem wopśimjeśu wuměniś',
	'replacetext_movepages' => 'Tekst w bokowych titelach wuměniś, jolic móžno',
	'replacetext_givetarget' => 'Musyš tekst pódaś, kótaryž ma se wuměniś.',
	'replacetext_nonamespace' => 'Musyš nanejmjenjej jaden mjenjowy rum wubraś.',
	'replacetext_editormove' => 'Musyš nanejmjenjej jadnu z wuměnjeńskich opcijow wubraś.',
	'replacetext_choosepagesforedit' => "Pšosym wubjeŕ {{PLURAL:$3|bok|boka|boki|boki}}, na {{PLURAL:$3|kótaremž|kótarymaž|kótarychž|kótarychž}} coš '$1' pśez '$2' wuměniś:",
	'replacetext_choosepagesformove' => '"$1" pśez "$2" w titelu {{PLURAL:$3|slědujucego boka|slědujuceju bokowu|slědujucych bokow|slědujucych bokow}} wuměniś:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Slědujucy bok njedajo|Slědujucej boka njedajotej|Slědujuce boki njedaju|Slědujuce boki njedaju}} se pśesunuś:',
	'replacetext_formovedpages' => 'Za pśesunjone boki:',
	'replacetext_savemovedpages' => 'Stare titele ako dalejpósrědnjenja do nowych titelow składowaś',
	'replacetext_watchmovedpages' => 'Toś te boki wobglědowaś',
	'replacetext_invertselections' => 'Wuběrk pśewobrośiś',
	'replacetext_replace' => 'Wuměniś',
	'replacetext_success' => "'$1' wuměnja se pśez '$2' na $3 {{PLURAL:$3|boku|bokoma|bokach|bokach}}.",
	'replacetext_noreplacement' => "Njejsu se namakali žedne boki, kótarež wopśimuju tekst '$1'.",
	'replacetext_nomove' => "Boki, kótarychž titel wopśimujo '$1', njejsu se namakali.",
	'replacetext_nosuchcategory' => 'Kategorija z mjenim "$1" njeeksistěrujo.',
	'replacetext_return' => 'Slědk k formularoju.',
	'replacetext_warning' => '\'\'\'Warnowanje:\'\'\' {{PLURAL:$1|Jo $1 bok, kótaryž južo wopśimujo|stej $1 boka, kótarejž južo wopśimujotej|su $1 boki, kótarež južo wopśimuju|jo $1 bokow, kótarež južo wopśimujo}} tekst, kótaryž ma se wuměniś, "$2".
Jolic wuwjedujoš toś tu wuměnu, njamóžoš rozeznaś swóje wuměny wót toś togo teksta.',
	'replacetext_blankwarning' => 'Dokulaž njejo tekst za wuměnjenje, toś ta operacija njedajo se anulěrowaś. Coš weto pókšacowaś?',
	'replacetext_continue' => 'Dalej',
	'replacetext_editsummary' => "Wuměna teksta - '$1' do '$2'",
	'right-replacetext' => 'Tekst na cełem wikiju wuměniś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Dada
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'replacetext' => 'Αντικατάσταση κειμένου',
	'replacetext_originaltext' => 'Αρχικό κείμενο:',
	'replacetext_replacementtext' => 'Κείμενο αντικατάστασης:',
	'replacetext_optionalfilters' => 'Προαιρετικά φίλτρα:',
	'replacetext_categorysearch' => 'Αντικατάσταση μόνο στην κατηγορία:',
	'replacetext_editpages' => 'Αντικατάσταση κειμένου στα περιεχόμενα σελίδας',
	'replacetext_nonamespace' => 'Πρέπει να επιλέξεις τουλάχιστον μια περιοχή.',
	'replacetext_formovedpages' => 'Για μετακινούμενες σελίδες:',
	'replacetext_watchmovedpages' => 'Παρακολούθηση αυτών των σελίδων',
	'replacetext_invertselections' => 'Αναστροφή επιλογών',
	'replacetext_replace' => 'Αντικατάσταση',
	'replacetext_noreplacement' => 'Δε βρέθηκαν σελίδες που να περιέχουν τη συμβολοσειρά "$1".',
	'replacetext_nomove' => 'Δε βρέθηκαν σελίδες των οποίων ο τίτλος να περιέχει τον όρο "$1".',
	'replacetext_nosuchcategory' => 'Δεν υπάρχει κατηγορία με το όνομα "$1".',
	'replacetext_return' => 'Επιστροφή στη φόρμα.',
	'replacetext_continue' => 'Συνέχεια',
	'replacetext_editsummary' => "Αντικατάσταση κειμένου - '$1' σε '$2'",
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'replacetext' => 'Anstataŭigi tekston',
	'replacetext_originaltext' => 'Originala teksto:',
	'replacetext_replacementtext' => 'Anstataŭigita teksto:',
	'replacetext_optionalfilters' => 'Nedevigaj filtriloj:',
	'replacetext_categorysearch' => 'Anstataŭigi nur en kategorio:',
	'replacetext_movepages' => 'Anstataŭigi tekston en paĝaj titoloj, kiam eble',
	'replacetext_nonamespace' => 'Vi devas elekti almenaŭ unu nomspacon.',
	'replacetext_watchmovedpages' => 'Atenti ĉi tiujn paĝojn',
	'replacetext_invertselections' => 'Inversigi selektojn',
	'replacetext_replace' => 'Anstataŭigi',
	'replacetext_success' => '"$1" estos anstataŭigita de "$2" en $3 {{PLURAL:$3|paĝo|paĝoj}}.',
	'replacetext_noreplacement' => "Neniuj paĝoj estis trovitaj enhavantaj la ĉenon '$1'.",
	'replacetext_return' => 'Reiri al formularo.',
	'replacetext_continue' => 'Reaktivigi',
	'replacetext_editsummary' => "Teksta anstataŭigo - '$1' al '$2'",
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Dferg
 * @author Imre
 * @author Locos epraix
 * @author Pertile
 * @author Translationista
 */
$messages['es'] = array(
	'replacetext' => 'Reemplazar texto',
	'replacetext-desc' => 'Provee a los administradores de una [[Special:ReplaceText|página especial]] para realizar una búsqueda y reemplazo global de una expresión en todas las páginas de una wiki.',
	'replacetext_docu' => "Para sustituir una cadena de texto con otra en todas las páginas de este wiki, introduce ambos textos aquí y haz clic en 'Continuar'.
A continuación verás un listado de páginas que contienen el texto de búsqueda, de los cuales podrás elegir aquellos en los que quieras cambiar el texto.
Tu nombre aparecerá como usuario responsable de los cambios en el historial de cada una de esas páginas.",
	'replacetext_originaltext' => 'Texto original:',
	'replacetext_replacementtext' => 'Texto de reemplazo:',
	'replacetext_optionalfilters' => 'Filtros opcionales:',
	'replacetext_categorysearch' => 'Reemplace sólo en la categoría:',
	'replacetext_prefixsearch' => 'Reemplaza solamente en páginas con el prefijo:',
	'replacetext_editpages' => 'Reemplazar textos en los contenidos de la página',
	'replacetext_movepages' => 'Reemplazar texto en títulos de página, cuando sea posible',
	'replacetext_givetarget' => 'Debe especificar la cadena de caracteres a reemplazar.',
	'replacetext_nonamespace' => 'Debes seleccionar al menos un espacio de nombres.',
	'replacetext_editormove' => 'Debes seleccionar al menos una de las opciones de reemplazo.',
	'replacetext_choosepagesforedit' => "Por favor seleccione las {{PLURAL:$3|página|páginas}} para las cuales desea reemplazar '$1' con '$2':",
	'replacetext_choosepagesformove' => 'Reemplazar "$1" con "$2" en los {{PLURAL:$3|título de la siguiente página|títulos de las siguientes páginas}}:',
	'replacetext_cannotmove' => 'Las siguientes {{PLURAL:$1|página|páginas}} no pueden ser movidas:',
	'replacetext_formovedpages' => 'Para páginas movidas:',
	'replacetext_savemovedpages' => 'Grabar los títulos antiguos como redirecciones a los nuevos títulos',
	'replacetext_watchmovedpages' => 'Vigilar estas páginas',
	'replacetext_invertselections' => 'Invertir selecciones',
	'replacetext_replace' => 'Reemplazar',
	'replacetext_success' => "'$1' será reemplazado con '$2' en $3 {{PLURAL:$3|página|páginas}}.",
	'replacetext_noreplacement' => "No se hallaron páginas que contengan la cadena de caracteres '$1'.",
	'replacetext_nomove' => "No se hallaron páginas cuyo título contenga '$1'.",
	'replacetext_nosuchcategory' => 'No existen categorías con el nombre "$1".',
	'replacetext_return' => 'Retornar al formulario.',
	'replacetext_warning' => '\'\'\'Advertencia:\'\'\' hay {{PLURAL:$1|$1 página que ya contiene|$1 páginas que ya contienen}} la cadena de sustitución, "$2".
Si realizas esta sustituación, no podrás separar tus sustituciones de estas cadenas.
¿Deseas continuar con la sustitución?',
	'replacetext_blankwarning' => 'Como la cadena de reemplazo está vacía, esta operación no podrá revertirse.
¿ Desea continuar ?',
	'replacetext_continue' => 'Continuar',
	'replacetext_editsummary' => "Texto reemplaza - '$1' a '$2'",
	'right-replacetext' => 'Reemplaza cadenas de caracteres en toda la wiki',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'replacetext' => 'Testua ordeztu',
	'replacetext_originaltext' => 'Jatorrizko testua:',
	'replacetext_movepages' => 'Posiblea denean, orrialdeen izenburuetan ere testua ordezkatu',
	'replacetext_cannotmove' => 'Hurrengo {{PLURAL:$1|orrialdea ezin da mugitu:|orrialdeak ezin dira mugitu:}}',
	'replacetext_watchmovedpages' => 'Orrialde hauek jarraitu',
	'replacetext_invertselections' => 'Hautaketak alderantzikatu',
	'replacetext_replace' => 'Ordeztu',
	'replacetext_noreplacement' => "Ez da aurkitu '$1' karaktere-katea duen orrialderik.",
	'replacetext_continue' => 'Jarraitu',
	'replacetext_editsummary' => "Testu aldaketa - '$1'(e)tik '$2'(e)ra.",
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Wayiran
 */
$messages['fa'] = array(
	'replacetext' => 'جایگزینی متن',
	'replacetext-desc' => 'یک [[Special:ReplaceText|صفحهٔ ویژه]] اضافه می‌کند که به مدیران اجازه می‌دهد یک جستجو و جایگزینی سراسری در تمام محتوای ویکی انجام دهند',
	'replacetext_docu' => 'برای جایگزین کردن یک رشتهٔ متنی با رشته دیگر در کل داده‌های این ویکی، شما می‌توانید دو متن را در زیر وارد کرده و دکمهٔ «جایگزین کن» را بزنید. اسم شما در تاریخچهٔ صفحه‌ها به عنوان کاربری که مسئول این تغییرها است ثبت می‌شود.',
	'replacetext_originaltext' => 'متن اصلی:',
	'replacetext_replacementtext' => 'متن جایگزین:',
	'replacetext_useregex' => 'استفاده از عبارت باقاعده',
	'replacetext_regexdocu' => '(مثال: مقادیر «a(.*)c» برای «متن اصلی» و «ac$1» برای «متن جایگزین»، «abc» را با «acb» جایگزین خواهد کرد.)',
	'replacetext_optionalfilters' => 'پالایه‌های اختیاری:',
	'replacetext_categorysearch' => 'جایگزینی فقط در ردهٔ:',
	'replacetext_prefixsearch' => 'جایگزینی فقط در صفحه‌هایی با پیشوند:',
	'replacetext_editpages' => 'جایگزینی متن در محتویات صفحه',
	'replacetext_movepages' => 'جایگزینی متن و در عنوان صفحه‌ها، وقتی که امکان‌پذیر است',
	'replacetext_givetarget' => 'شما می‌بایست متنی را که باید جایگزین شود مشخص نمایید.',
	'replacetext_nonamespace' => 'شما می‌بایست حداقل یک فضای نام را انتخاب کنید.',
	'replacetext_editormove' => 'شما می‌بایست حداقل یکی از گزینه‌های جایگزین کردن را انتخاب کنید.',
	'replacetext_choosepagesforedit' => 'جایگزینی «$1» با «$2» در متن این {{PLURAL:$3|صفحه|صفحه‌ها}}:',
	'replacetext_choosepagesformove' => 'جایگزینی «$1» با «$2» در {{PLURAL:$3|عنوان این صفحه|عنوان این صفحه‌ها}}',
	'replacetext_cannotmove' => 'این {{PLURAL:$1|صفحه|صفحه‌ها}} نمی‌توانند منتقل شوند:',
	'replacetext_formovedpages' => 'برای صفحه‌های منتقل شده:',
	'replacetext_savemovedpages' => 'ذخیره‌سازی عنوان‌های قدیم به عنوان تغییر مسیرهایی به عنوان‌های جدید',
	'replacetext_watchmovedpages' => '‌پی‌گیری این صفحه‌ها',
	'replacetext_invertselections' => 'وارانه کردن انتخاب‌ها',
	'replacetext_replace' => 'جایگزین کن',
	'replacetext_success' => 'در $3 {{PLURAL:$3|صفحه|صفحه}} «$1» با «$2» جایگزین می‌شود.',
	'replacetext_noreplacement' => "جایگزینی انجام نشد؛ صفحه‌ای که حاوی '$1' باشد پیدا نشد.",
	'replacetext_nomove' => 'صفحه‌ای پیدا نشد که عنوان آن «$1» را داشته باشد.',
	'replacetext_nosuchcategory' => 'رده‌ای با نام «$1» وجود ندارد.',
	'replacetext_return' => 'بازگشت به فرم.',
	'replacetext_warning' => "'''هشدار:''' در حال حاضر $1 صفحه وجود دارد که حاوی رشتهٔ جایگزینی «$2» {{PLURAL:$1|است|هستند}}. اگر شما این جایگزینی را انجام دهید، قادر نخواهید بود تا جایگزینی‌هایتان را از این رشته‌ها جدا کنید.",
	'replacetext_blankwarning' => 'چون متن جایگزین خالی است، این عمل قابل بازگشت نخواهد بود؛ ادامه می‌دهید؟',
	'replacetext_continue' => 'ادامه',
	'replacetext_editsummary' => "جایگزینی متن - '$1' به '$2'",
	'right-replacetext' => 'انجام جایگزین کردن رشته در تمام ویکی',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Usp
 */
$messages['fi'] = array(
	'replacetext' => 'Korvaa teksti',
	'replacetext-desc' => 'Lisää [[Special:ReplaceText|toimintosivun]], jonka kautta ylläpitäjät voivat etsiä ja korvata wikin sisältämää tekstiä',
	'replacetext_docu' => "Korvataksesi yhden merkkijonon toisella kaikissa tämän wikin tavallisissa sivuissa, syötä molemmat kaksi tekstinpätkää tänne ja sitten napsauta kohtaa 'Jatka'. Tämän jälkeen sinulle näytetään luettelo sivuista, jotka sisältävät haetun tekstin, ja voit valita ne, joihin haluat korvata sen. Oma nimesi näkyy sivun historiassa käyttäjänä joka on vastuussa kaikista tehdyistä muutoksista.",
	'replacetext_originaltext' => 'Alkuperäinen teksti',
	'replacetext_replacementtext' => 'Korvaava teksti',
	'replacetext_useregex' => 'Käytä säännöllisiä lausekkeita',
	'replacetext_optionalfilters' => 'Lisäehtoja:',
	'replacetext_categorysearch' => 'Muokkaa ainoastaan sivuja, jotka ovat luokassa:',
	'replacetext_prefixsearch' => 'Korvaa ainoastaan sivuilla, joissa on etuliite:',
	'replacetext_editpages' => 'Korvaa teksti sivujen sisällöstä',
	'replacetext_movepages' => 'Korvaa teksti otsikoista, jos mahdollista',
	'replacetext_givetarget' => 'Sinun tulee määrittää korvattava merkkijono.',
	'replacetext_nonamespace' => 'Sinun täytyy valita vähintään yksi nimiavaruus.',
	'replacetext_editormove' => 'Sinun on valittava vähintään yksi kohde, mistä etsitään.',
	'replacetext_choosepagesforedit' => 'Korvaa teksti "$1" tekstillä "$2"  {{PLURAL:$3|seuraavalta sivulta|seuraavilta sivuilta}}:',
	'replacetext_choosepagesformove' => 'Korvaa teksti "$1" tekstillä "$2" {{PLURAL:$3|seuraavan sivun otsikossa|seuraavien sivujen otsikoissa}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Seuraavaa sivua|Seuraavia sivuja}} ei voi siirtää:',
	'replacetext_formovedpages' => 'Tee siirretyille sivuille:',
	'replacetext_savemovedpages' => 'Tallenna vanhat sivujen otsikot ohjauksina uusiin sivuihin.',
	'replacetext_watchmovedpages' => 'Tarkkaile näitä sivuja',
	'replacetext_invertselections' => 'Käänteinen valinta',
	'replacetext_replace' => 'Korvaa',
	'replacetext_success' => '"$1" korvataan tekstillä "$2" $3 {{PLURAL:$3|sivulla|sivulla}}.',
	'replacetext_noreplacement' => 'Tekstin "$1" leipätekstissään sisältäviä sivuja ei löytynyt.',
	'replacetext_nomove' => 'No pages were found whose title contains "$1".',
	'replacetext_nosuchcategory' => 'Luokkaa "$1" ei ole.',
	'replacetext_return' => 'Palaa lomakkeeseen.',
	'replacetext_warning' => '\'\'\'Varoitus:\'\'\' {{PLURAL:$1|$1 sivu| $1 sivua}} sisältää jo korvaavan tekstin, "$2". Korvauksen jälkeen korvatut ja jo tekstin sisältäneet kohdat eivät erotu toisistaan.
If you make this replacement you will not be able to separate your replacements from these strings.',
	'replacetext_blankwarning' => "'''Varoitus:''' Koska korvaava teksti on tyhjä, operaatiota ei voi palauttaa käänteisellä korvauksella.",
	'replacetext_continue' => 'Jatka',
	'replacetext_editsummary' => 'Tekstin korvaus – ”$1” muotoon ”$2”',
	'right-replacetext' => 'Tehdä merkkijonojen korvauksia koko wikin laajuudella',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Peter17
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'replacetext' => 'Remplacer le texte',
	'replacetext-desc' => 'Fournit une page spéciale permettant aux administrateurs de remplacer des chaînes de caractères par d’autres sur l’ensemble du wiki',
	'replacetext_docu' => 'Pour remplacer une chaîne de caractères par une autre sur l’ensemble des données des pages de ce wiki, vous pouvez entrez les deux textes ici et cliquer sur « {{int:replacetext_replace}} ». Votre nom apparaîtra dans l’historique des pages tel un utilisateur auteur des changements.',
	'replacetext_originaltext' => 'Texte original :',
	'replacetext_replacementtext' => 'Texte de remplacement :',
	'replacetext_useregex' => 'Utiliser des expressions rationnelles',
	'replacetext_regexdocu' => '(Exemple : la valeur « a(.*)c » pour « texte original » et « ac$1 » pour « texte de remplacement » remplace « abc » avec « acb ».)',
	'replacetext_optionalfilters' => 'Filtres optionnels :',
	'replacetext_categorysearch' => 'Remplacer seulement dans la catégorie :',
	'replacetext_prefixsearch' => 'Remplacer seulement dans les pages ayant le préfixe :',
	'replacetext_editpages' => 'Remplacer le texte dans le contenu dans la page',
	'replacetext_movepages' => 'Remplacer le texte dans le titre des pages, si possible',
	'replacetext_givetarget' => 'Vous devez spécifier la chaîne à remplacer.',
	'replacetext_nonamespace' => 'Vous devez sélectionner au moins un espace de noms.',
	'replacetext_editormove' => 'Vous devez choisir au moins une option de remplacement.',
	'replacetext_choosepagesforedit' => 'Veuillez sélectionner {{PLURAL:$3|la pages|les pages}} dans {{PLURAL:$3|laquelle|lesquelles}} vous voulez remplacer « $1 » par « $2 » :',
	'replacetext_choosepagesformove' => 'Remplacer « $1 » par « $2 » dans {{PLURAL:$3|le nom de la page suivante|les noms des pages suivantes}} :',
	'replacetext_cannotmove' => '{{PLURAL:$1|La page suivante n’a pas pu être renommée|Les pages suivantes n’ont pas pu être renommées}} :',
	'replacetext_formovedpages' => 'Pour les pages renommées :',
	'replacetext_savemovedpages' => 'Enregistrer les anciens titres comme redirections vers les nouveaux titres',
	'replacetext_watchmovedpages' => 'Suivre ces pages',
	'replacetext_invertselections' => 'Inverser les sélections',
	'replacetext_replace' => 'Remplacer',
	'replacetext_success' => '« $1 » sera remplacé par « $2 » dans $3 fichier{{PLURAL:$3||s}}.',
	'replacetext_noreplacement' => 'Aucun fichier contenant la chaîne « $1 » n’a été trouvé.',
	'replacetext_nomove' => 'Aucune page n’a été trouvée dont le titre contient « $1 ».',
	'replacetext_nosuchcategory' => 'Il n’existe pas de catégorie nommée « $1 ».',
	'replacetext_return' => 'Revenir au formulaire.',
	'replacetext_warning' => 'Il y a $1 fichier{{PLURAL:$1| qui contient|s qui contiennent}} déjà la chaîne de remplacement « $2 ».
Si vous effectuez cette substitution, vous ne pourrez pas distinguer vos modifications de ces chaînes.',
	'replacetext_blankwarning' => 'Parce que la chaîne de remplacement est vide, cette opération sera irréversible ; voulez-vous continuer ?',
	'replacetext_continue' => 'Continuer',
	'replacetext_editsummary' => 'Remplacement du texte — « $1 » par « $2 »',
	'right-replacetext' => 'Faire des remplacements de texte dans tout le wiki',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'replacetext' => 'Remplaciér lo tèxto',
	'replacetext_originaltext' => 'Tèxto d’origina :',
	'replacetext_replacementtext' => 'Tèxto de remplacement :',
	'replacetext_useregex' => 'Utilisar des èxprèssions racionèles',
	'replacetext_optionalfilters' => 'Filtros u chouèx :',
	'replacetext_formovedpages' => 'Por les pâges renomâs :',
	'replacetext_watchmovedpages' => 'Siuvre cetes pâges',
	'replacetext_invertselections' => 'Envèrsar los chouèx',
	'replacetext_replace' => 'Remplaciér',
	'replacetext_return' => 'Tornar u formulèro.',
	'replacetext_continue' => 'Continuar',
	'replacetext_editsummary' => 'Remplacement du tèxto — « $1 » per « $2 »',
);

/** Galician (Galego)
 * @author Hamilton Abreu
 * @author Toliño
 */
$messages['gl'] = array(
	'replacetext' => 'Substituír un texto',
	'replacetext-desc' => 'Proporciona unha [[Special:ReplaceText|páxina especial]] para que os administradores poidan facer unha cadea global para atopar e substituír un texto no contido de todas as páxinas dun wiki',
	'replacetext_docu' => 'Para substituír unha cadea de texto por outra en todas as páxinas regulares deste wiki, teclee aquí as dúas pezas do texto e logo prema en "Continuar". Despois mostraráselle unha lista das páxinas que conteñen o texto buscado e pode elixir en cales quere substituílo. O seu nome aparecerá nos histotiais das páxinas como o usuario responsable de calquera cambio.',
	'replacetext_originaltext' => 'Texto orixinal:',
	'replacetext_replacementtext' => 'Texto de substitución:',
	'replacetext_useregex' => 'Usar expresións regulares',
	'replacetext_regexdocu' => '(Examplo: os valores "a(.*)c" para o "texto orixinal" e "ac$1" para o "texto de substitución" cambiarán "abc" por "acb".)',
	'replacetext_optionalfilters' => 'Filtros opcionais:',
	'replacetext_categorysearch' => 'Substituír só na categoría:',
	'replacetext_prefixsearch' => 'Substituír só nas páxinas co prefixo:',
	'replacetext_editpages' => 'Substituír o texto nos contidos da páxina',
	'replacetext_movepages' => 'Substituír o texto nos títulos das páxinas, cando sexa posible',
	'replacetext_givetarget' => 'Debe especificar a cadea que vai ser substituída.',
	'replacetext_nonamespace' => 'Debe escoller, polo menos, un espazo de nomes.',
	'replacetext_editormove' => 'Debe seleccionar, polo menos, unha das opcións de substitución.',
	'replacetext_choosepagesforedit' => 'Substituír "$1" por "$2" no texto {{PLURAL:$3|da seguinte páxina|das seguintes páxinas}}:',
	'replacetext_choosepagesformove' => 'Substituír "$1" por "$2" {{PLURAL:$3|no título da seguinte páxina|nos títulos das seguintes páxinas}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|A seguinte páxina|As seguintes páxinas}} non {{PLURAL:$1|pode|poden}} ser {{PLURAL:$1|movida|movidas}}:',
	'replacetext_formovedpages' => 'Para as páxinas movidas:',
	'replacetext_savemovedpages' => 'Gardar os títulos vellos como redireccións cara aos títulos novos',
	'replacetext_watchmovedpages' => 'Vixíe estas páxinas',
	'replacetext_invertselections' => 'Inverter as seleccións',
	'replacetext_replace' => 'Substituír',
	'replacetext_success' => '"$1" será substituído por "$2" {{PLURAL:$3|nunha páxina|en $3 páxinas}}.',
	'replacetext_noreplacement' => "Non foi atopada ningunha páxina que contivese a cadea '$1'.",
	'replacetext_nomove' => 'Non se atopou ningún artigo cuxo título conteña "$1".',
	'replacetext_nosuchcategory' => 'Non existe ningunha categoría co nome "$1".',
	'replacetext_return' => 'Volver ao formulario.',
	'replacetext_warning' => '\'\'\'Aviso:\'\'\' Hai {{PLURAL:$1|unha páxina|$1 páxinas}} que xa {{PLURAL:$1|contén|conteñen}} a cadea de substitución "$2". Se fai esta substitución non poderá distinguir as súas modificacións destas cadeas.',
	'replacetext_blankwarning' => "'''Atención:''' Debido a que a cadea de substitución está baleira, esta operación non será reversible.",
	'replacetext_continue' => 'Continuar',
	'replacetext_editsummary' => 'Substitución de texto - de "$1" a "$2"',
	'right-replacetext' => 'Facer substitucións de cordas no wiki enteiro',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'replacetext' => 'Ἀντικαθιστάναι κείμενον',
	'replacetext_originaltext' => 'Πρωτότυπον κείμενον:',
	'replacetext_replacementtext' => 'Κείμενον ἀντικαταστάσεως:',
	'replacetext_formovedpages' => 'Περὶ μετακεκινημένων δέλτων:',
	'replacetext_watchmovedpages' => 'Ἐφορᾶν τάσδε τὰς δέλτους',
	'replacetext_replace' => 'Ἀντικαθιστάναι',
	'replacetext_return' => 'Ἐπανιέναι εἰς τὸν τύπον.',
	'replacetext_continue' => 'Συνεχίζειν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'replacetext' => 'Täxt ersetze',
	'replacetext-desc' => 'Ergänzt e [[Special:ReplaceText|Spezialsyte]], wu s Ammanne megli macht, e wältwyti Täxt-suechen-un-ersetze-Operation in allene Inhaltsyte vum Wiki durzfiere',
	'replacetext_docu' => 'Go ne Täxt dur e andere Täxt uf allene Inhaltssyte z ersetze, gib di bede Täxtteil doo yy un druck uf Ersetze-Schaltflächi. Dir wird derno ne Lischt vu dr Syte zeigt, wu s dr gsuecht Täxt din het, un Du chasch die uuswehle, wu Du dr Täxt witt din ersetze. Dyy Benutzername wird in d Versionsgschicht ufgnuh',
	'replacetext_originaltext' => 'Originaltäxt:',
	'replacetext_replacementtext' => 'Neje Täxt:',
	'replacetext_useregex' => 'Platzhalter un reguläri Uusdruck verwände',
	'replacetext_regexdocu' => '(Byschpel: D Wärt fir „a(.*)c“ fir „Originaltext“ un „ac$1“ fir „Neje Text“ deete zue dr Ersetzig „abc“ dur „acb“ fiere.)',
	'replacetext_optionalfilters' => 'Optionali Filter:',
	'replacetext_categorysearch' => 'Nume in däre Kategorie ersetze:',
	'replacetext_prefixsearch' => 'Nume in Syte ersetze mit däm Präfix:',
	'replacetext_editpages' => 'Täxt im Syteinhalt ersetze',
	'replacetext_movepages' => 'Ersetz Täxt au in Sytetitel, wänn s goht',
	'replacetext_givetarget' => 'Du muesch d Zeichechette spezifiziere, wu soll ersetzt wäre.',
	'replacetext_nonamespace' => 'Zmindescht ei Namensruum muess uusgwehlt wäre.',
	'replacetext_editormove' => 'Du muesch zmindescht eini vu dr Ersetzigsoptione uuswehle.',
	'replacetext_choosepagesforedit' => 'Bitte d {{PLURAL:$3|Syten|Syten}} uuswehle, wu Du „$1“ dur „$2“ wetsch ersetzen:',
	'replacetext_choosepagesformove' => 'Ersetz „$1“ dur „$2“ {{PLURAL:$3|im Name vu däre Syte|in dr Näme vu däne Syte}}:',
	'replacetext_cannotmove' => 'Die {{PLURAL:$1|Syte cha|Syte chenne}} nit verschobe wäre:',
	'replacetext_formovedpages' => 'Fir verschobeni Syte:',
	'replacetext_savemovedpages' => 'Di alte Sytenäme as Wyterleitig zue dr neje Sytenäme spychere',
	'replacetext_watchmovedpages' => 'Die Syte beobachte',
	'replacetext_invertselections' => 'Uuswahl umchehre',
	'replacetext_replace' => 'Ersetze',
	'replacetext_success' => '„$1“ wird dur „$2“ in $3 {{PLURAL:$3|Syten|Syten}} ersetzt.',
	'replacetext_noreplacement' => 'S isch kei Syte gfunde wore, wu s dr Täxt „$1“ din het.',
	'replacetext_nomove' => "S sin kei Syte gfunde wore, wu '$1' im Titel hän",
	'replacetext_nosuchcategory' => 'S git kei Kategorii mit em Name „$1“.',
	'replacetext_return' => 'Zrugg zum Formular.',
	'replacetext_warning' => "'''Warnig:''' In $1 {{PLURAL:$1|Syte het s|Seite het s}} dr Täxtteil „$2“, wu ersetzt soll wäre, scho.
E Trännig vu dr Ersetzige mit dr Täxtteil, wu s scho het, sich nit megli. Mechtsch einewäg wytermache?",
	'replacetext_blankwarning' => 'Dr Täxtteil, wu soll ersetzt wären, isch läär. D Operation cha nit ruckgängig gmacht wäre, einewäg wytermache?',
	'replacetext_continue' => 'Wytermache',
	'replacetext_editsummary' => 'Täxtersetzig - „$1“ dur „$2“',
	'right-replacetext' => 'Mach e Täxtersetzig fir s gsamt Wiki',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'replacetext' => 'החלפת טקסט',
	'replacetext-desc' => 'אספקת [[Special:ReplaceText|דף מיוחד]] כדי לאפשר למפעילים לבצע חיפוש והחלפה של מחרוזות בכל דפי התוכן בוויקי',
	'replacetext_docu' => "כדי להחליף מחרוזת טקסט אחת באחרת בכל הדפים הרגילים בוויקי זה, הזינו את הטקסט בשני חלקים ולחצו על 'המשך'. אז תוצג בפניכם רשימת דפים המכילים את הטקסט שחיפשתם, ותוכלו לבחור את הדפים שבהם תרצו להחליף את הטקסט האמור. שמכם יופיע בהיסטוריית הגרסאות של כל דף בתור המשתמש האחראי לשינויים שנעשו.",
	'replacetext_originaltext' => 'הטקסט המקורי:',
	'replacetext_replacementtext' => 'טקסט ההחלפה:',
	'replacetext_useregex' => 'להשתמש בביטויים רגולריים',
	'replacetext_regexdocu' => '(דוגמה: הכנסת הערכים של "a(.*)c" ל"טקסט המקורי" ו־"ac$1" ל"טקסט ההחלפה" תחליף "abc" ב־"acb".)',
	'replacetext_optionalfilters' => 'מסננים אופציונליים:',
	'replacetext_categorysearch' => 'החלפה רק בקטגוריה:',
	'replacetext_prefixsearch' => 'החלפה רק בדפים בעלי הקידומת:',
	'replacetext_editpages' => 'החלפת טקסט בתוכן הדפים',
	'replacetext_movepages' => 'החלפת טקסט בכותרות הדפים, כשניתן',
	'replacetext_givetarget' => 'יש לציין את המחרוזת שתוחלף.',
	'replacetext_nonamespace' => 'יש לבחור מרחב שם אחד לפחות.',
	'replacetext_editormove' => 'יש לבחור לפחות באחת מאפשרויות ההחלפה.',
	'replacetext_choosepagesforedit' => "אנא בחרו את {{PLURAL:$3|הדף בו|הדפים בהם}} ברצונכם להחליף את '$1' ב־'$2':",
	'replacetext_choosepagesformove' => 'החלפת "$1" ב־"$2" ב{{PLURAL:$3|שם הדף הבא|שמות הדפים הבאים}}:',
	'replacetext_cannotmove' => 'לא ניתן להעביר את {{PLURAL:$1|הדף הבא|הדפים הבאים}}:',
	'replacetext_formovedpages' => 'עבור דפים שיועברו:',
	'replacetext_savemovedpages' => 'שמירת שמות הדפים הישנים כהפניות לשמות הדפים החדשים',
	'replacetext_watchmovedpages' => 'מעקב אחר דפים אלה',
	'replacetext_invertselections' => 'הפיכת הבחירות',
	'replacetext_replace' => 'החלפה',
	'replacetext_success' => "'$1' יוחלף ב־'$2' ב־{{PLURAL:$3|דף אחד|$3 דפים}}.",
	'replacetext_noreplacement' => "לא נמצאו דפים המכילים את המחרוזת '$1'.",
	'replacetext_nomove' => "לא נמצאו דפים ששמם מכיל '$1'.",
	'replacetext_nosuchcategory' => 'לא קיימת קטגוריה בשם "$1".',
	'replacetext_return' => 'חזרה לטופס.',
	'replacetext_warning' => '\'\'\'אזהרה\'\'\': {{PLURAL:$1|ישנו עמוד אחד שכבר מכיל|ישנם $1 עמודים שכבר מכילים}} את מחרוזת ההחלפה, "$2". אם החלפה זו תבוצע לא תהיה באפשרותך להפריד את החלפותיך מ{{PLURAL:$1|מחרוזת זו|מחרוזות אלו}}.',
	'replacetext_blankwarning' => 'כיוון שמחרוזת ההחלפה ריקה, לא ניתן יהיה לבטל פעולה זו; להמשיך?',
	'replacetext_continue' => 'המשך',
	'replacetext_editsummary' => 'החלפת טקסט – "$1" ב־"$2"',
	'right-replacetext' => 'ביצוע החלפת מחרוזות באתר הוויקי כולו',
);

/** Croatian (Hrvatski)
 * @author Bugoslav
 * @author Dalibor Bosits
 * @author Ex13
 * @author Herr Mlinka
 */
$messages['hr'] = array(
	'replacetext' => 'Zamjeni tekst',
	'replacetext-desc' => 'Dodaje [[Special:ReplaceText|posebnu stranicu]] koja omogućava administratorima globalnu zamjenu teksta na principu nađi-zamjeni na svim stranicama wikija.',
	'replacetext_docu' => "Za zamjenu jednog teksta s drugim na svim stranicama wikija, upišite ciljani i zamjenski tekst ovdje i pritisnite 'Dalje'. Pokazati će vam se popis stranica koje sadrže ciljani tekst, i moći ćete odabrati u kojima od njih želite izvršiti zamjenu. Vaše ime će se pojaviti u povijesti stranice kao suradnik odgovoran za promjenu.",
	'replacetext_originaltext' => 'Izvorni tekst:',
	'replacetext_replacementtext' => 'Zamjenski tekst:',
	'replacetext_movepages' => 'Zamijeni tekst u naslovima stranica, ako je moguće',
	'replacetext_choosepagesforedit' => "Molimo odaberite {{PLURAL:$3|stranicu|stranice}} na kojima želite zamijeniti '$1' za '$2':",
	'replacetext_choosepagesformove' => 'Zamijeni "$1" s "$2" u {{PLURAL:$1|naslovu sljedeće stranice|naslovima sljedećih stranica}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Sljedeća stranica|Sljedeće stranice}} ne mogu biti premještene:',
	'replacetext_watchmovedpages' => 'Prati ove stranice',
	'replacetext_invertselections' => 'Izvrni odabir',
	'replacetext_replace' => 'Zamjeni',
	'replacetext_success' => "'$1' će biti zamijenjen za '$2' na $3 {{PLURAL:$3|stranici|stranice|stranica}}.",
	'replacetext_noreplacement' => "Nije pronađena ni jedna stranica koja sadrži '$1'.",
	'replacetext_warning' => "Postoji {{PLURAL:$1|$1 stranica koja već sadrži|$1 stranica koje već sadrže}} zamjenski tekst, '$2'. 
Ako napravite ovu zamjenu nećete moći odvojiti svoju zamjenu od ovog teksta. Nastaviti sa zamjenom?",
	'replacetext_blankwarning' => 'Zato što je zamjenski tekst prazan, ovaj postupak se neće moći vratiti; nastaviti?',
	'replacetext_continue' => 'Dalje',
	'replacetext_editsummary' => "Zamjena teksta - '$1' u '$2'",
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'replacetext' => 'Tekst narunać',
	'replacetext-desc' => 'Staji [[Special:ReplaceText|specialnu stronu]] k dispoziciji, kotraž administratoram zmóžnja, globalne pytanje a narunanje teksta na wšěch wobsahowych stronach wikija přewjesć',
	'replacetext_docu' => "Zo by tekst přez druhi tekst na wšěch regularnych stronach tutoho wikija narunał, zapodaj wobaj tekstowej dźělej a klikń potom na 'Dale'. Budźeš potom lisćinu stronow widźeć, kotrež pytany tekst wobsahuja a móžeš jednu z nich wubrać, w kotrejž chceš tekst narunać. Twoje mjeno zjewi so w stawiznach strony jako wužiwar, kotryž je zamołwity za změny.",
	'replacetext_originaltext' => 'Originalny tekst:',
	'replacetext_replacementtext' => 'Narunanski tekst:',
	'replacetext_useregex' => 'regularne wuraz wužiwać',
	'replacetext_regexdocu' => '(Přikład: hódnoty za "a(.*)c" za "originalny tekst" a "ac$1" za "nowy tekst" bychu "abc" přez "acb" wuměnili.)',
	'replacetext_optionalfilters' => 'Opcionalne filtry:',
	'replacetext_categorysearch' => 'Jenož w kategoriji narunać:',
	'replacetext_prefixsearch' => 'Jenož w stronach narunać z prefiksom:',
	'replacetext_editpages' => 'Tekst we wobsahu strony narunać',
	'replacetext_movepages' => 'Tekst w titulach stronow narunać, jeli móžno',
	'replacetext_givetarget' => 'Dyrbiš tekst podać, kotryž ma so narunać.',
	'replacetext_nonamespace' => 'Dyrbiš znajmjeńša jedyn mjenowy rum wubrać.',
	'replacetext_editormove' => 'Dyrbiš znajmjeńša jednu z narunanskich opcijow wubrać.',
	'replacetext_choosepagesforedit' => '"$1" w {{PLURAL:$3|slědowacej stronje|slědowacymaj stronomaj|slědowacych stronach|slědowacych stronach}} přez "$2" wuměnić:',
	'replacetext_choosepagesformove' => '"$1" přez "$2" w titulu {{PLURAL:$3|slědowaceje strony|slědowaceju stronow|slědowacych stronow|slědowacych stronow}} narunać:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Slědowaca strona njehodźi|Slědowacej stronje njehodźitej|Slědowace strony njehodźa|Slědowace strony njehodźa}} so přesunyć:',
	'replacetext_formovedpages' => 'Za přesunjene strony:',
	'replacetext_savemovedpages' => 'Stare titule jako daleposrědkowanja do nowych titulow składować',
	'replacetext_watchmovedpages' => 'Tute strony wobkedźbować',
	'replacetext_invertselections' => 'Wuběry wobroćić',
	'replacetext_replace' => 'Narunać',
	'replacetext_success' => "'$1' so w $3 {{PLURAL:$3|stronje|stronomaj|stronach|stronach}} přez '$2' naruna.",
	'replacetext_noreplacement' => "Njejsu so žane strony namakali, kotrež wuraz '$1' wobsahuja.",
	'replacetext_nomove' => "Strony, kotrychž titul '$1' wobsahuje, njebuchu namakane.",
	'replacetext_nosuchcategory' => 'Kategorija z mjenom "$1" njeeksistuje.',
	'replacetext_return' => 'Wróćo k formularej',
	'replacetext_warning' => "'''Warnowanje:''' {{PLURAL:$1|Je hižo $1 strona, kotraž wobsahuje|Stej hižo $1 stronje, kotejž wobsahujetej|Su hižo $1 strony, kotrež wobsahuja|Je hižo $1 stronow, kotrež wobsahuje}} narunanski tekst, '$2'. Jeli tute narunanje činiš, njemóžeš swoje narunanja wot tutoho teksta rozdźělić.",
	'replacetext_blankwarning' => 'Narunanski dźěl je prózdny, tohodla operacija njeda so cofnyć; njedźiwajo na to pokročować?',
	'replacetext_continue' => 'Dale',
	'replacetext_editsummary' => "Tekstowe narunanje - '$1' do '$2'",
	'right-replacetext' => 'Tekstowe narunanja na cyłym wikiju činić',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'replacetext' => 'Szöveg cseréje',
	'replacetext-desc' => '[[Special:ReplaceText|Speciális lap]] adminisztrátorok részére szövegek globális keresés-és-cseréjére a wiki összes tartalom oldalán',
	'replacetext_docu' => 'Hogy lecserélj egy szöveget egy másikra az összes tartalom lapon a wikin, add meg a keresendő és a cél szöveget, majd kattints a „Folytatás”-ra.
Ezután kapsz egy listát azokról a lapokról, amelyek tartalmazzák a cserélendő szöveget, és kiválaszthatod azokat, amelyekben végre szeretnéd hajtani a cserét.
A neved szerepelni fog a laptörténetekben, mint aki a változtatásokat végezte.',
	'replacetext_originaltext' => 'Eredeti szöveg:',
	'replacetext_replacementtext' => 'Új szöveg:',
	'replacetext_optionalfilters' => 'Választható szűrők:',
	'replacetext_categorysearch' => 'Csere csak ebben a kategóriában:',
	'replacetext_prefixsearch' => 'Csere csak a következő előtaggal rendelkező lapokon:',
	'replacetext_editpages' => 'Szöveg cseréje a lap tartalmában',
	'replacetext_movepages' => 'Szöveg cseréje a lapok címeiben, ha lehetséges',
	'replacetext_givetarget' => 'Meg kell adnod a cserélendő szöveget.',
	'replacetext_nonamespace' => 'Ki kell választanod legalább egy névteret.',
	'replacetext_editormove' => 'Ki kell választanod legalább egyet a csere lehetőségek közül.',
	'replacetext_choosepagesforedit' => '„$1” cseréje „$2” kifejezésre a következő {{PLURAL:$3|lap|lapok}} szövegében:',
	'replacetext_choosepagesformove' => '„$1” cseréje „$2” kifejezésre a következő {{PLURAL:$3|lap címében|lapok címeiben}}:',
	'replacetext_cannotmove' => 'A következő {{PLURAL:$1|lap|lapok}} nem nevezhetőek át:',
	'replacetext_formovedpages' => 'Az átnevezett lapokhoz:',
	'replacetext_savemovedpages' => 'A régi címek megtartása átirányításként az új címekre',
	'replacetext_watchmovedpages' => 'Figyeld ezeket a lapokat',
	'replacetext_invertselections' => 'Kijelölések megfordítása',
	'replacetext_replace' => 'Csere',
	'replacetext_success' => '„$1” cseréje $3 lapon erre: „$2”.',
	'replacetext_noreplacement' => 'Egy lap sem tartalmazza a(z) „$1” szöveget.',
	'replacetext_nomove' => 'Nem található olyan lap, melynek címe tartalmazza a(z) „$1” keresőkifejezést.',
	'replacetext_nosuchcategory' => 'Nincs „$1” nevű kategória.',
	'replacetext_return' => 'Visszatérés az űrlapra.',
	'replacetext_warning' => "'''Figyelem:''' {{PLURAL:$1|egy|$1}} lap már tartalmazza a szöveget, amire cserélni szeretnél („$2”). Ha végrehajtod a cserét, utólag nem fogod tudni megkülönböztetni az újonnan bekerült szövegeket a már előtte is meglevő előfordulásoktól.",
	'replacetext_blankwarning' => 'Mivel az új szöveg üres, ez a művelet nem lesz visszavonható.
Biztosan folytatni szeretnéd?',
	'replacetext_continue' => 'Folytatás',
	'replacetext_editsummary' => 'Szöveg cseréje – „$1” → „$2”',
	'right-replacetext' => 'szövegcserék végrehajtása az egész wikin',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'replacetext' => 'Reimplaciar texto',
	'replacetext-desc' => 'Forni un [[Special:ReplaceText|pagina special]] que permitte al administratores cercar e reimplaciar globalmente un catena de characteres in tote le paginas de contento de un wiki',
	'replacetext_docu' => "Pro reimplaciar un catena de characteres per un altere trans tote le paginas regular in iste wiki, entra le duo pecias de texto hic e clicca super 'Continuar'. Postea se monstrara un lista de paginas que contine le texto cercate, e tu potera seliger in quales tu vole reimplaciar lo. Tu nomine figurara in le historias del paginas como le usator responsabile de omne modificationes.",
	'replacetext_originaltext' => 'Texto original:',
	'replacetext_replacementtext' => 'Nove texto:',
	'replacetext_useregex' => 'Usar expressiones regular',
	'replacetext_regexdocu' => '(Exemplo: valores de "a(.*)c" pro "Texto original" e "ac$1" pro "Texto de substitution" reimplaciarea "abc" per "acb".)',
	'replacetext_optionalfilters' => 'Filtros optional:',
	'replacetext_categorysearch' => 'Reimplaciar solmente in le categoria:',
	'replacetext_prefixsearch' => 'Reimplaciar solmente in paginas con le prefixo:',
	'replacetext_editpages' => 'Reimplaciar texto in contento de pagina',
	'replacetext_movepages' => 'Reimplaciar texto in titulos de paginas, quando possibile',
	'replacetext_givetarget' => 'Tu debe specificar le texto a esser reimplaciate.',
	'replacetext_nonamespace' => 'Tu debe seliger al minus un spatio de nomines.',
	'replacetext_editormove' => 'Tu debe seliger al minus un del optiones de reimplaciamento.',
	'replacetext_choosepagesforedit' => "Per favor selige le {{PLURAL:$3|pagina in le qual|paginas in le quales}} tu vole reimplaciar '$1' per '$2':",
	'replacetext_choosepagesformove' => 'Reimplaciar "$1" per "$2" in le {{PLURAL:$3|titulo del sequente pagina|titulos del sequente paginas}}:',
	'replacetext_cannotmove' => 'Le sequente {{PLURAL:$1|pagina|paginas}} non pote esser renominate:',
	'replacetext_formovedpages' => 'Pro pagina renominate:',
	'replacetext_savemovedpages' => 'Preservar le ancian titulos como redirectiones verso le nove titulos',
	'replacetext_watchmovedpages' => 'Observar iste paginas',
	'replacetext_invertselections' => 'Inverter selectiones',
	'replacetext_replace' => 'Reimplaciar',
	'replacetext_success' => "'$1' essera reimplaciate per '$2' in $3 {{PLURAL:$3|pagina|paginas}}.",
	'replacetext_noreplacement' => "Nulle pagina esseva trovate que contine le catena de characteres '$1'.",
	'replacetext_nomove' => "Nulle pagina esseva trovate con un titulo que contine '$1'.",
	'replacetext_nosuchcategory' => "Nulle categoria existe con le nomine '$1'.",
	'replacetext_return' => 'Retornar al formulario.',
	'replacetext_warning' => "'''Attention:''' Il ha \$1 {{PLURAL:\$1|pagina|paginas}} que contine ja le nove texto, \"\$2\".
Si tu face iste reimplaciamento, tu non potera distinguer inter tu reimplaciamentos e iste texto ja existente.",
	'replacetext_blankwarning' => 'Post que le nove texto es vacue, iste operation non essera reversibile; continuar?',
	'replacetext_continue' => 'Continuar',
	'replacetext_editsummary' => "Reimplaciamento de texto - '$1' per '$2'",
	'right-replacetext' => 'Facer reimplaciamentos de texto in le wiki integre',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'replacetext' => 'Mengganti teks',
	'replacetext-desc' => 'Menyediakan [[Special:ReplaceText|halaman istimewa]] untuk memungkinkan pengurus untuk melakukan pencarian-dan-penggantian untaian secara global pada semua halaman isi dari suatu wiki',
	'replacetext_docu' => "Untuk mengganti suatu teks kalimat dengan kalimat lain di antara semua halaman-halaman regular wiki ini, masukkan kedua teks di sini dan klik 'Lanjutkan'. Anda akan mendapatkan tampilan daftar halaman yang berisikan teks yang dicari, dan Anda dapat memilih yang mana saja yang ingin digantikan. Nama Anda akan tampil di versi terdahulu halaman sebagai pengguna yang melakukan perubahan.",
	'replacetext_originaltext' => 'Teks asli:',
	'replacetext_replacementtext' => 'Teks pengganti:',
	'replacetext_useregex' => 'Gunakan persamaan reguler',
	'replacetext_regexdocu' => '(Congoh: nilai dari "a(.*)c" untuk "Teks asal" dan "ac$1" untuk "Teks pengganti" akan mengganti "abc" dengan "acb".)',
	'replacetext_optionalfilters' => 'Filter opsional:',
	'replacetext_categorysearch' => 'Hanya ganti pada kategori:',
	'replacetext_prefixsearch' => 'Hanya ganti pada halaman dengan awalan:',
	'replacetext_editpages' => 'Ganti teks pada isi halaman',
	'replacetext_movepages' => 'Ganti teks pada judul halaman, jika mungkin',
	'replacetext_givetarget' => 'Anda harus menyebutkan untaian yang akan diganti.',
	'replacetext_nonamespace' => 'Anda harus memilih paling tidak satu ruang nama.',
	'replacetext_editormove' => 'Anda harus memilih paling tidak salah satu opsi penggantian.',
	'replacetext_choosepagesforedit' => 'Ganti "$1" dengan "$2" pada teks dari {{PLURAL:$3|halaman|halaman}} berikut:',
	'replacetext_choosepagesformove' => 'Ganti "$1" dengan "$2" pada {{PLURAL:$3|judul halaman berikut|judul halaman berikut}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Halaman|Halaman}} berikut tidak dapat dipindahkan:',
	'replacetext_formovedpages' => 'Untuk halaman yang dipindahkan:',
	'replacetext_savemovedpages' => 'Simpan judul lama sebagai pengalihan ke judul baru',
	'replacetext_watchmovedpages' => 'Pantau halaman-halaman ini',
	'replacetext_invertselections' => 'Balikkan pilihan',
	'replacetext_replace' => 'Gantikan',
	'replacetext_success' => '"$1" akan diganti dengan "$2" pada $3 {{PLURAL:$3|halaman|halaman}}.',
	'replacetext_noreplacement' => 'Tidak ada halaman yang ditemukan yang mengandung untaian "$1".',
	'replacetext_nomove' => 'Tidak ada halaman yang ditemukan yang judulnya mengandung "$1".',
	'replacetext_nosuchcategory' => 'Tidak ditemukan kategori bernama "$1".',
	'replacetext_return' => 'Kembali ke isian.',
	'replacetext_warning' => 'Ada {{PLURAL:$1|$1 halaman|$1 halaman}} yang telah berisi untaian pengganti, "$2". Jika Anda melakukan penggantian ini Anda tidak akan dapat memisahkan pengganti Anda dari untaian ini.',
	'replacetext_blankwarning' => 'Karena untaian pengganti kosong, operasi ini tidak dapat dikembalikan.
Apakah ingin dilanjutkan?',
	'replacetext_continue' => 'Lanjutkan',
	'replacetext_editsummary' => 'Penggantian teks - "$1" menjadi "$2"',
	'right-replacetext' => 'Melakukan penggantian seluruh teks kalimat di wiki ini',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'replacetext_originaltext' => 'Mkpụrụ nke mbu:',
	'replacetext_replace' => 'Kwụchí na élú',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Civvì
 * @author Darth Kule
 * @author Marco 27
 */
$messages['it'] = array(
	'replacetext' => 'Sostituzione testo',
	'replacetext-desc' => 'Fornisce una [[Special:ReplaceText|pagina speciale]] per permettere agli amministratori di effettuare una ricerca e sostituzione globale di testo su tutte le pagine di contenuti di un sito',
	'replacetext_docu' => "Per sostituire una stringa di testo con un'altra su tutte le pagine del sito, inserire qui due pezzi di testo e poi premere 'Continua'. Verrà quindi mostrato un elenco delle pagine che contengono il testo cercato, e sarà possibile scegliere quelle in cui si desidera sostituirlo. Il proprio nome verrà visualizzato nella pagina della cronologia come l'utente responsabile delle eventuali modifiche.",
	'replacetext_originaltext' => 'Testo originale:',
	'replacetext_replacementtext' => 'Testo sostituito:',
	'replacetext_useregex' => 'Utilizza le espressioni regolari',
	'replacetext_regexdocu' => '(Esempio: con valori di "a(.*)c" per "{{int:replacetext_originaltext}}" e "ac$1" per "{{int:replacetext_replacementtext}}" trasformerebbe "abc" in "acb".)',
	'replacetext_optionalfilters' => 'Filtri opzionali:',
	'replacetext_categorysearch' => 'Sostituire solo nella categoria:',
	'replacetext_prefixsearch' => 'Sostituire solo nelle pagine con il prefisso:',
	'replacetext_editpages' => 'Sostituire il testo nella pagina di contenuti',
	'replacetext_movepages' => 'Sostituisci il testo nei titoli delle pagine, quando possibile',
	'replacetext_givetarget' => 'È necessario specificare il testo da sostituire.',
	'replacetext_nonamespace' => 'È necessario selezionare almeno un namespace',
	'replacetext_editormove' => 'È necessario selezionare almeno una delle opzioni di sostituzione.',
	'replacetext_choosepagesforedit' => "Selezionare {{PLURAL:$3|la pagina per la quale|le pagine per le quali}} si desidera sostituire '$1' con '$2':",
	'replacetext_choosepagesformove' => 'Sostituire "$1" con "$2" {{PLURAL:$3|nel titolo della pagina seguente|nei titoli delle pagine seguenti}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|La pagina seguente non può essere spostata|Le pagine seguenti non possono essere spostate}}:',
	'replacetext_formovedpages' => 'Per le pagine spostate:',
	'replacetext_savemovedpages' => 'Conservare i vecchi titoli come redirect al nuovo titolo:',
	'replacetext_watchmovedpages' => 'Aggiungi agli osservati speciali',
	'replacetext_invertselections' => 'Inverti selezione',
	'replacetext_replace' => 'Sostituisci',
	'replacetext_success' => "'$1' sarà sostituito con '$2' in $3 {{PLURAL:$3|pagina|pagine}}.",
	'replacetext_noreplacement' => "Non sono state trovate pagine contenenti il testo '$1'.",
	'replacetext_nomove' => "Non sono state trovate pagine il cui titolo contiene '$1'.",
	'replacetext_nosuchcategory' => 'Non esiste categoria con il nome "$1".',
	'replacetext_return' => 'Torna al modulo.',
	'replacetext_warning' => '{{PLURAL:$1|C\'è già $1 pagina che contiene|Ci sono già $1 pagine che contengono}} il testo di sostituzione, "$2". Se si effettua questa sostituzione non si sarà in grado di separare le sostituzioni da questi testi. Continuare con la sostituzione?',
	'replacetext_blankwarning' => "Poiché il testo di sostituzione è vuoto, l'operazione non sarà reversibile. Si desidera continuare?",
	'replacetext_continue' => 'Continua',
	'replacetext_editsummary' => "Sostituzione testo - '$1' con '$2'",
	'right-replacetext' => 'Esegue sostituzioni di testo in tutto il sito',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Schu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'replacetext' => '文字列の置換',
	'replacetext-desc' => '管理者がウィキ内の全記事で、ある文字列に一致する部分すべてを置換できるようにする[[Special:ReplaceText|特別ページ]]を提供する',
	'replacetext_docu' => 'ある文字列をこのウィキ上のすべての標準ページで別のものに置換するには、必要な2つの文字列をここに入力し「続行」を押します。次に検索した文字列を含むページが一覧表示され、置換を行いたいページを選択できます。置換後には、あなたの名前がページ履歴にその編集を担当した利用者として表示されます。',
	'replacetext_originaltext' => '置換前の文字列:',
	'replacetext_replacementtext' => '置換後の文字列:',
	'replacetext_useregex' => '正規表現を使用',
	'replacetext_regexdocu' => '（例："置換前の文字列"には "a(.*)c" 、"置換後の文字列"には "ac$1"の値で、"abc" は "acb" に置換されます。）',
	'replacetext_optionalfilters' => '追加のフィルター (任意):',
	'replacetext_categorysearch' => '以下のカテゴリにあるもののみを置換:',
	'replacetext_prefixsearch' => '以下の文字列から始まるページ内のもののみを置換:',
	'replacetext_editpages' => 'ページ本文中の文字列を置換',
	'replacetext_movepages' => '可能ならば、ページ名中の文字列を置換する',
	'replacetext_givetarget' => '置換される対象となる文字列を指定しなければなりません。',
	'replacetext_nonamespace' => '最低でも1つは名前空間を選択しなければなりません。',
	'replacetext_editormove' => '置換オプションのうち最低でも1つを選択してください。',
	'replacetext_choosepagesforedit' => '以下の{{PLURAL:$3|ページ}}の本文中の「$1」を「$2」に置換する:',
	'replacetext_choosepagesformove' => '以下の名前の{{PLURAL:$3|ページ}}中の文字列「$1」を「$2」に置換する:',
	'replacetext_cannotmove' => '以下の{{PLURAL:$1|ページ}}は移動できません:',
	'replacetext_formovedpages' => '移動したページについて:',
	'replacetext_savemovedpages' => '古いページ名を新しいページへのリダイレクトとして残す',
	'replacetext_watchmovedpages' => 'これらのページをウォッチ',
	'replacetext_invertselections' => '選択を反転',
	'replacetext_replace' => '置換',
	'replacetext_success' => '$3{{PLURAL:$3|ページ}}で「$1」が「$2」に置換されます。',
	'replacetext_noreplacement' => '文字列「$1」を含むページは見つかりませんでした。',
	'replacetext_nomove' => '「$1」を名前に含むページは見つかりませんでした。',
	'replacetext_nosuchcategory' => '「$1」という名前のカテゴリーは存在しません。',
	'replacetext_return' => 'フォームに戻る',
	'replacetext_warning' => "'''警告:''' 置換後文字列「$2」を既に含んだページが $1{{PLURAL:$1|ページ}}あります。この置換を実行すると、これらの文字列と実際に置換された箇所を区別できなくなります。",
	'replacetext_blankwarning' => '置換後文字列が空であるため、この操作は実行後の取り消しができなくなります。続行しますか？',
	'replacetext_continue' => '続行',
	'replacetext_editsummary' => '文字列「$1」を「$2」に置換',
	'right-replacetext' => 'ウィキ全体で文字列の置換を実行する',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'replacetext' => 'Ganti tèks',
	'replacetext_originaltext' => 'Tèks asli:',
	'replacetext_continue' => 'Banjurna',
);

/** Georgian (ქართული)
 * @author BRUTE
 */
$messages['ka'] = array(
	'replacetext_replace' => 'ჩანაცვლება',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'replacetext' => 'ជំនួសអត្ថបទ',
	'replacetext_originaltext' => 'អត្ថបទដើម៖',
	'replacetext_replacementtext' => 'អត្ថបទជំនួស៖',
	'replacetext_movepages' => 'ជំនួស​អត្ថបទ​នៅក្នុង​ចំណងជើង​ទំព័រ​បើអាច',
	'replacetext_choosepagesforedit' => "សូម​ជ្រើសរើស {{PLURAL:$3|ទំព័រ|ទំព័រ}} សម្រាប់​អ្វី​ដែល​អ្នក​ចង់​ជំនួស '$1' ដោយ '$2':",
	'replacetext_choosepagesformove' => 'ជំនួស​អត្ថបទ​នៅក្នុង {{PLURAL:$1|ឈ្មោះ​ទំព័រ​ដូចតទៅ|ឈ្មោះ​ទំព័រ​ដូចតទៅ}}:',
	'replacetext_invertselections' => 'ដាក់បញ្ច្រាស​ជម្រើស',
	'replacetext_replace' => 'ជំនួស',
	'replacetext_success' => "'$1' នឹងត្រូវបានជំនួសដោយ '$2' ក្នុង $3 {{PLURAL:$3|ទំព័រ|ទំព័រ}}​។",
	'replacetext_noreplacement' => "រក​មិន​ឃើញ​ទំព័រ​ដែល​មាន​ខ្សែអក្សរ (string) '$1' ។",
	'replacetext_continue' => 'បន្ត',
	'replacetext_editsummary' => "អត្ថបទជំនួស - '$1' ទៅ '$2'",
);

/** Korean (한국어)
 * @author Devunt
 * @author Kwj2772
 */
$messages['ko'] = array(
	'replacetext' => '찾아 바꾸기',
	'replacetext-desc' => '관리자가 위키 전체의 내용을 찾아 바꿀 수 있도록 [[Special:ReplaceText|특수 문서]]를 추가',
	'replacetext_docu' => "이 위키에서 어떤 문자열을 다른 문자열로 바꾸기 위해서는, 찾을 문자열과 바꿀 문자열을 입력한 뒤 '계속'을 눌러 주세요.
그러면 해당 문자열을 포함하고 있는 문서 목록이 나오며, 그중에서 바꿀 문서들을 선택할 수 있습니다.
당신의 사용자 이름이 문서 역사에 나올 것입니다.",
	'replacetext_originaltext' => '찾을 문자열:',
	'replacetext_replacementtext' => '바꿀 문자열:',
	'replacetext_useregex' => '정규 표현식 사용',
	'replacetext_regexdocu' => '(예: "찾을 문자열"에 "a(.*)c"값을 입력하고 "바꿀 문자열에 "ac$1"을 입력하면 "abc"가 "acb"로 바뀝니다.)',
	'replacetext_optionalfilters' => '선택적 필터:',
	'replacetext_categorysearch' => '다음 분류에서만 바꾸기:',
	'replacetext_prefixsearch' => '다음 접두어로 시작하는 문서만 바꾸기:',
	'replacetext_editpages' => '문서 내용의 문자열을 바꾸기',
	'replacetext_movepages' => '가능하다면 문서 제목에 있는 문자열도 바꾸기',
	'replacetext_givetarget' => '찾을 문자열을 반드시 지정해야 합니다.',
	'replacetext_nonamespace' => '이름공간을 적어도 하나는 선택해야 합니다.',
	'replacetext_editormove' => '찾아 바꾸기 옵션을 적어도 하나는 선택해야 합니다.',
	'replacetext_choosepagesforedit' => '$3개의 문서에 있는 “$1” 문자열을 “$2” 문자열로 바꿉니다:',
	'replacetext_choosepagesformove' => '$3개의 문서 제목에 있는 “$1” 문자열을 “$2” 문자열로 바꿉니다:',
	'replacetext_cannotmove' => '다음 {{PLURAL:$1|문서는|문서들은}} 이동할 수 없습니다:',
	'replacetext_formovedpages' => '이동한 페이지의 경우 :',
	'replacetext_savemovedpages' => '옛 문서 제목을 새 문서 제목으로 넘겨 주는 문서로 만들기',
	'replacetext_watchmovedpages' => '이 문서 주시하기',
	'replacetext_invertselections' => '선택 반전',
	'replacetext_replace' => '찾아 바꾸기',
	'replacetext_success' => '“$1” 문자열은 $3개의 문서에서 “$2” 문자열로 바뀔 것입니다.',
	'replacetext_noreplacement' => '“$1” 문자열을 포함하고 있는 문서가 없습니다.',
	'replacetext_nomove' => '“$1” 문자열을 포함하고 있는 문서 제목이 없습니다.',
	'replacetext_nosuchcategory' => '“$1” 문자열을 포함하고 있는 분류가 없습니다.',
	'replacetext_return' => '찾아 바꾸기 양식으로 돌아가기',
	'replacetext_warning' => '“$2” 문자열을 포함하고 있는 $1개의 문서가 이미 있습니다. 이 찾아 바꾸기를 실행하면, 이미 존재하는 “$2” 문자열과 더 이상 구분되지 않을 것입니다.
찾아 바꾸기를 계속하시겠습니까?',
	'replacetext_blankwarning' => '바꿀 문자열이 비어 있으므로 이 동작은 되돌릴 수 없습니다.
계속하시겠습니까?',
	'replacetext_continue' => '계속',
	'replacetext_editsummary' => '찾아 바꾸기 – “$1” 문자열을 “$2” 문자열로',
	'right-replacetext' => '찾아 바꾸기를 위키 전체에 수행합니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'replacetext' => 'Täx-Shtöcksher ußtuusche',
	'replacetext-desc' => 'Deit en [[Special:ReplaceText|Söndersigg]] en et Wiki, womet {{int:group-sysop}} aanjefbaa Täx-Shtöcksher en alle Atikelle em Wiki söke un ußtuusche künne.',
	'replacetext_docu' => 'Öm ene Täx en alle nomaale Sigge em Wiki ze söke un ußzetuusche, jif hee
zwei Täx-Shtöcksher en, un donn dann op „{{int:replacetext continue}}“ klecke.
Dann süühß De en Leß met Sigge, wo dö dä jesoohte Täx dren enthallde es,
un De kanns Der erußsöke, en wat för enne dovun dat De dä och jetuusch
han wells. Dinge Name als Metmaacher weed met dä neu veränderte Versione
fun dä Sigge faßjehallde als dä Schriiver, dä et jemaat hät.',
	'replacetext_originaltext' => 'Dä ojinaal Täx för Ußzetuusche:',
	'replacetext_replacementtext' => 'Dä neue Täx för anshtatt dämm Ojinaal erin ze donn',
	'replacetext_useregex' => 'Met „<i lang="en">regular Expressions</i>“',
	'replacetext_regexdocu' => '(För e Beispel: Nämm „a(.*)c“ fö_t Ojinaal un „ac$1“ fö_der neue Täxt, un De kriß „abc“ dorsh „acb“ ußjetuusch.)',
	'replacetext_optionalfilters' => 'Müjjelesche Beschrängkunge:',
	'replacetext_categorysearch' => 'Bloß en dä Saachjropp ußtuusche:',
	'replacetext_prefixsearch' => 'Bloß en Sigge ußtuusche, dänne ier Tittelle aanfange met:',
	'replacetext_editpages' => 'Donn dä Täx em Sigge_Enhaldt ußtuusche',
	'replacetext_movepages' => 'Donn dä Täx en de Sigge ier Tittele ußtuusche, wan et jeiht',
	'replacetext_givetarget' => 'Do moß aanjevve, wat ußjetuusch wäde sull. „Nix“ ußtuusche künne mer nit.',
	'replacetext_nonamespace' => 'Do moß winnischßdens ei Appachtemang ußwähle.',
	'replacetext_editormove' => 'Do moß winnischßdenß ei Höksche maache, sönß brengk dat hee nix.',
	'replacetext_choosepagesforedit' => 'Don {{PLURAL:$3|en Sigg|die Sigge|nix aan Sigge}} ußsöke, en dänne De „$1“ jääje „$2“ jetuusch han wells:',
	'replacetext_choosepagesformove' => 'Donn dä Täx „$1“ en hee dä {{PLURAL:$3|Sigg|Sigge|nix}} ierem Name jäje der Täx „$2“ ußtuusche:',
	'replacetext_cannotmove' => 'Hee die {{PLURAL:$1|Sigg kann|Sigge künne|nix kann}} nit ömjenannt wäde:',
	'replacetext_formovedpages' => 'För ömjenannte Sigge:',
	'replacetext_savemovedpages' => 'Donn der ahle Tittel faßallde un en Ömleidung op der Neue druß maache,
wann en Sigg ömjenannt woode es.',
	'replacetext_watchmovedpages' => 'Op di Sigge oppasse',
	'replacetext_invertselections' => 'De Ußwahl ömdrieje',
	'replacetext_replace' => 'Tuusche',
	'replacetext_success' => '„$1“ soll en {{PLURAL:$3|eine Sigg|$3 Sigge|nix}} dorsch „$2“ ußjetuusch wääde.',
	'replacetext_noreplacement' => 'Kein Sigge jefonge met däm Täxstöck „$1“ dren.',
	'replacetext_nomove' => 'Mer han kei Sigge jefonge, woh „$1“ em Tittel dren förkütt.',
	'replacetext_nosuchcategory' => 'Mer han kein Saachjropp met dämm Name „$1“.',
	'replacetext_return' => 'Jangk retuur op dat Fommulaa.',
	'replacetext_warning' => "'''Opjepaß:'''
{{PLURAL:$1|Ein Sigg enthält|$1 Sigge enthallde}} ald dat Täxstöck „$2“, wat bemm Tuusche ennjeföch wääde sull.
Wenn De dat jemaat häs, kam_mer die Änderong nit esu leich automattesch retuur maache, weil mer die ald do woore,
un de ennjetuuschte Täxstöcker nit ungerscheide kann.
Wells De trozdämm wigger maache?",
	'replacetext_blankwarning' => 'Dat Täxstöck, wat beim Tuusche ennjfööch weed, is leddich,
dröm kam_mer die Änderong nit esu leich automattesch retuur maache.
Wells De trozdämm wigger maache?',
	'replacetext_continue' => 'Wiggermaache',
	'replacetext_editsummary' => 'Täx-Shtöcker tuusche — vun „$1“ noh „$2“',
	'right-replacetext' => 'Donn Täx-Shtöcksher em janze Wiki ußtuusche',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'replacetext' => 'Text ersetzen',
	'replacetext-desc' => "Weist eng [[Special:ReplaceText|Spezialsäit]] déi Administrateuren et erlaabt eng Rei vun Textzeechen op alle Contenu-säite vun enger Wiki ze gesinn an z'ersetzen",
	'replacetext_docu' => "Fir en Text duerch en aneren Text op allen Inhaltssäite vun dëser Wiki z'ersetzen, gitt w.e.g. déi zwéin Texter hei an klickt op 'Weider'. Dir gesitt dann eng Lëscht vu Säiten op deenen de gesichten Text dran ass, an Dir kënnt déi eraussichen op denen Dir den Text ersetze wëllt. Ären Numm steet an der Lëscht vun de Versiounen als Auteur vun all deenen Ännerungen.",
	'replacetext_originaltext' => 'Originaltext:',
	'replacetext_replacementtext' => 'Neien Text:',
	'replacetext_useregex' => 'Regulär Ausdréck benotzen',
	'replacetext_regexdocu' => '(Beispill: De Wäert „a(.*)c“ fir „Originaltext“ an „ac$1“ fir „Neien Text“ géif „abc“ duerch „acb“ ersetzen.)',
	'replacetext_optionalfilters' => 'Optional Filteren:',
	'replacetext_categorysearch' => 'Ersetz nëmmen an der Kategorie:',
	'replacetext_prefixsearch' => 'Ersetz nëmmen a Säite mam Prefix:',
	'replacetext_editpages' => 'Den Text a Säiteninhalter ersetzen',
	'replacetext_movepages' => 'Text an den Titele vun de Säiten ersetzen, wa méiglech',
	'replacetext_givetarget' => 'Dir musst déi Zeechen uginn déi ersat solle ginn.',
	'replacetext_nonamespace' => 'Dir musst mindestens een Nummraum eraussichen.',
	'replacetext_editormove' => 'Dir musst mindestens eng vun den Optioune vum Ersetzen eraussichen.',
	'replacetext_choosepagesforedit' => 'Wielt w.e.g. d\'{{PLURAL:$3|Säit op där|Säiten op deenen}} Dir "$1" duerch "$2" ersetze wëllt:',
	'replacetext_choosepagesformove' => "'$1' duerch '$2' am Titel vun {{PLURAL:$3|dëser Säit|dëse Säiten}} ersetzen:",
	'replacetext_cannotmove' => 'Dës {{PLURAL:$1|Säit kann|Säite kënne}} net geréckelt ginn:',
	'replacetext_formovedpages' => 'Fir geréckelt Säiten:',
	'replacetext_savemovedpages' => 'Déi al Titelen als Viruleedung op déi nei Titele späicheren',
	'replacetext_watchmovedpages' => 'Dës Säiten iwwerwaachen',
	'replacetext_invertselections' => 'Auswiel ëmdréinen',
	'replacetext_replace' => 'Ersetzen',
	'replacetext_success' => "'$1' gëtt duerch '$2' op $3 {{PLURAL:$3|Säit|Säiten}} ersat.",
	'replacetext_noreplacement' => "Et goufe keng Säite mam Text '$1' fonnt.",
	'replacetext_nomove' => "Keng Säite fonnt wou '$1' am Titel drasteet.",
	'replacetext_nosuchcategory' => 'Et gëtt keng Kategorie mam Numm "$1".',
	'replacetext_return' => 'Zréck op de Formulaire',
	'replacetext_warning' => "'''Opgepasst:''' Et gëtt schonn {{PLURAL:$1|eng Säit op där|$1 Säiten op deenen}} d'Zeecherei '$2' schonn dran ass.
Wann Dir dës Ännerunge maacht wäert et Iech net méi méiglech sinn déi Säiten op deenen Dir Ännerunge gemaach hutt vun de Säiten z'ënnerscheeden wou elo d'Zeecherei '$2' schonn dran ass.",
	'replacetext_blankwarning' => 'Well den Textdeel mat dem de gesichten Text ersat gi soll eidel ass, kann dës Aktioun net réckgängeg gemaach ginn; wëllt Dir awer weiderfueren?',
	'replacetext_continue' => 'Weiderfueren',
	'replacetext_editsummary' => "Text ersat - '$1' duerch '$2'",
	'right-replacetext' => 'Ersetze vun enger Rei vun Textzeechen op der ganzer Wiki',
);

/** Lithuanian (Lietuvių)
 * @author Homo
 */
$messages['lt'] = array(
	'replacetext' => 'Keisti tekstą',
	'replacetext_continue' => 'Tęsti',
	'replacetext_editsummary' => 'Teksto pakeitimas - "$1" į "$2"',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'right-replacetext' => 'Manolo lahatsoratra misy manerana ilay wiki',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'replacetext' => 'Замени текст',
	'replacetext-desc' => 'Додава [[Special:ReplaceText|специјална страница]] која им овозможува на администраторите да вршат пронаоѓање и замена на глобални низи во страниците на викито',
	'replacetext_docu' => 'За да замените една низа со друга, ширум сите регуларни страници на ова вики, внесете ги тука двете парчиња текст и потоа притиснете на „Продолжи“.
Потоа ќе ви се прикаже список на страници кои го содржат бараниот текст, и ќе можете да изберете во кои од нив сакате да ја извршите змената.
Вашето име ќе се појави во историјата на страниците како корисник одговорен за промените.',
	'replacetext_originaltext' => 'Изворен текст:',
	'replacetext_replacementtext' => 'Нов текст:',
	'replacetext_useregex' => 'Користи регуларни изрази',
	'replacetext_regexdocu' => '(Пример: вредностите на „а(.*)в“ за „Изворен текст“ и „ав$1“ за „Нов текст“ ќе го заменат „абв“ со „авб“.)',
	'replacetext_optionalfilters' => 'Незадолжителни филтри:',
	'replacetext_categorysearch' => 'Замени само во категорија:',
	'replacetext_prefixsearch' => 'Замени само во страници со префиксот:',
	'replacetext_editpages' => 'Замени текст во содржина на страница',
	'replacetext_movepages' => 'Замени текст во насловите на страниците, кога е можно',
	'replacetext_givetarget' => 'Мора да ја наведете низата што треба да се замени.',
	'replacetext_nonamespace' => 'Мора да изберете барем еден именски простор.',
	'replacetext_editormove' => 'Мора да одберете барем една од можностите за замена.',
	'replacetext_choosepagesforedit' => 'Замени „$1“ со „$2“ во текстот на {{PLURAL:$3|следнава страница|следниве страници}}:',
	'replacetext_choosepagesformove' => 'Замени „$1“ со „$2“ во {{PLURAL:$3|насловот на следната страница|насловите на следните страници}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Следнава страница не може да се премести|Следниве страници не можат да се преместат}}:',
	'replacetext_formovedpages' => 'За преместени страници:',
	'replacetext_savemovedpages' => 'Зачувај ги старите наслови како пренасочувања кон новите наслови',
	'replacetext_watchmovedpages' => 'Набљудувај ги овие страници',
	'replacetext_invertselections' => 'Обратен избор',
	'replacetext_replace' => 'Замени',
	'replacetext_success' => '„$1“ ќе биде заменето со „$2“ во $3 {{PLURAL:$3|страница|страници}}.',
	'replacetext_noreplacement' => 'Нема пронајдено страници кои ја содржат низата „$1“.',
	'replacetext_nomove' => 'Нема пронајдено страници чиј наслов содржи „$1“.',
	'replacetext_nosuchcategory' => 'Не постои категорија по име „$1“',
	'replacetext_return' => 'Назад кон образецот',
	'replacetext_warning' => "'''Предупредување:''' Има {{PLURAL:$1|$1 страница што веќе ја содржи|$1 страници што веќе ја содржат}} новата низа „$2“. Ако ја извршите оваа замена, тогаш нема да можете да ги раздвоите вашите замени од тие низи.",
	'replacetext_blankwarning' => 'Бидејќи новата низа е празна, оваа операција не може да се врати.
Дали сакате да продолжите?',
	'replacetext_continue' => 'Продолжи',
	'replacetext_editsummary' => 'Замена на текст - „$1“ со „$2“',
	'right-replacetext' => 'Вршење замена на низи во целото вики',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'replacetext' => 'എഴുത്ത് മാറ്റിച്ചേർക്കുക',
	'replacetext-desc' => 'വിക്കിയിലെ എല്ലാ ഉള്ളടക്ക താളിൽ നിന്നും കാര്യനിർവാഹകർക്ക് ഒരു പ്രത്യേക പദത്തെ കണ്ടെത്തി-മാറ്റിച്ചേർക്കാനുള്ള [[Special:ReplaceText|പ്രത്യേക താൾ]] നൽകുന്നു',
	'replacetext_originaltext' => 'യഥാർത്ഥ എഴുത്ത്:',
	'replacetext_replacementtext' => 'മാറ്റിച്ചേർക്കേണ്ട എഴുത്ത്:',
	'replacetext_optionalfilters' => 'ഐച്ഛിക അരിപ്പകൾ:',
	'replacetext_categorysearch' => 'ഈ വർഗ്ഗത്തിൽ നിന്നു മാത്രം മാറ്റിച്ചേർക്കുക:',
	'replacetext_prefixsearch' => 'ഈ പൂർവ്വപദമുള്ള താളുകളിൽ മാത്രം മാറ്റിച്ചേർക്കുക:',
	'replacetext_editpages' => 'താളിന്റെ ഉള്ളടക്കത്തിലെ എഴുത്ത് മാറ്റിച്ചേർക്കുക',
	'replacetext_movepages' => 'സാദ്ധ്യമെങ്കിൽ, താളിന്റെ ഉള്ളടക്കത്തിലെ എഴുത്തുകൾ മാറ്റിച്ചേർക്കുക',
	'replacetext_givetarget' => 'മാറ്റിച്ചേർക്കാനുള്ള പദം താങ്കൾ വ്യക്തമാക്കണം.',
	'replacetext_nonamespace' => 'ഒരു നാമമേഖലയെങ്കിലും തിരഞ്ഞെടുത്തിരിക്കണം.',
	'replacetext_editormove' => 'ഒരു മാറ്റിച്ചേർക്കൽ ഐച്ഛികമെങ്കിലും തിരഞ്ഞെടുത്തിരിക്കണം.',
	'replacetext_choosepagesforedit' => 'താഴെയുള്ള {{PLURAL:$3|താളിൽ|താളുകളിൽ}} നിന്നും  "$1" എന്നത് "$2" എന്നതുകൊണ്ട് മാറ്റിച്ചേർക്കുക:',
	'replacetext_choosepagesformove' => 'താഴെയുള്ള {{PLURAL:$3|താളിന്റെ തലക്കെട്ടിൽ|താളുകളുടെ തലക്കെട്ടുകളിൽ}} നിന്നും  "$1" എന്നത് "$2" എന്നതുകൊണ്ട് മാറ്റിച്ചേർക്കുക:',
	'replacetext_cannotmove' => 'താഴെയുള്ള {{PLURAL:$1|താൾ|താളുകൾ}} മാറ്റാനാവില്ല:',
	'replacetext_formovedpages' => 'മാറ്റിയ താളുകൾക്ക് വേണ്ടി:',
	'replacetext_savemovedpages' => 'പഴയ തലക്കെട്ടുകൾ പുതിയ തലക്കെട്ടുകളിലോട്ടുള്ള തിരിച്ചുവിടലായി നിലനിർത്തുക',
	'replacetext_watchmovedpages' => 'ഈ താളുകൾ ശ്രദ്ധിക്കുക',
	'replacetext_invertselections' => 'വിപരീതം തിരഞ്ഞെടുക്കുക',
	'replacetext_replace' => 'മാറ്റിച്ചേർക്കുക',
	'replacetext_success' => '{{PLURAL:$3|ഒരു താളിൽ|$3 താളുകളിൽ}} "$1" എന്നത് "$2" എന്നതുകൊണ്ട് മാറ്റിച്ചേർക്കപ്പെടും.',
	'replacetext_noreplacement' => '"$1" എന്ന പദമുള്ള താളുകളൊന്നും കണ്ടെത്താനായില്ല.',
	'replacetext_nomove' => 'ഒരു താളിന്റെയും തലക്കെട്ടിൽ "$1" എന്നു കണ്ടെത്താനായില്ല.',
	'replacetext_return' => 'ഫോമിലേക്ക് തിരിച്ചു പോവുക',
	'replacetext_continue' => 'തുടരുക',
	'replacetext_editsummary' => 'എഴുത്ത് മാറ്റിച്ചേർക്കൽ - "$1" എന്നത് "$2" എന്നതുകൊണ്ട്',
	'right-replacetext' => 'വിക്കിയിൽ മുഴുവനും പദം മാറ്റിച്ചേർക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'replacetext' => 'मजकूरावर पुनर्लेखन करा',
	'replacetext-desc' => 'एक [[Special:ReplaceText|विशेष पान]] देते ज्याच्यामुळे प्रबंधकांना एखाद्या विकिवरील सर्व पानांमध्ये शोधा व बदला सुविधा वापरता येते',
	'replacetext_docu' => "एखाद्या विकितील सर्व डाटा पानांवरील एखादा मजकूर बदलायचा झाल्यास, मजकूराचे दोन्ही तुकडे खाली लिहून 'पुनर्लेखन करा' कळीवर टिचकी द्या. तुम्हाला एक यादी दाखविली जाईल व त्यामधील कुठली पाने बदलायची हे तुम्ही ठरवू शकता. तुमचे नाव त्या पानांच्या इतिहास यादीत दिसेल.",
	'replacetext_originaltext' => 'मूळ मजकूर',
	'replacetext_replacementtext' => 'बदलण्यासाठीचा मजकूर',
	'replacetext_choosepagesforedit' => "ज्या पानांवर तुम्ही  '$1' ला '$2' ने बदलू इच्छिता ती पाने निवडा:",
	'replacetext_replace' => 'पुनर्लेखन करा',
	'replacetext_success' => "'$1' ला '$2' ने $3 पानांवर बदलले जाईल.",
	'replacetext_noreplacement' => "'$1' मजकूर असणारे एकही पान सापडले नाही.",
	'replacetext_warning' => "अगोदरच $1 पानांवर '$2' हा बदलण्यासाठीचा मजकूर आहे; जर तुम्ही पुनर्लेखन केले तर तुम्ही केलेले बदल तुम्ही या पानांपासून वेगळे करू शकणार नाही. पुनर्लेखन करायचे का?",
	'replacetext_blankwarning' => 'बदलण्यासाठीचा मजकूर रिकामा असल्यामुळे ही क्रिया उलटविता येणार नाही; पुढे जायचे का?',
	'replacetext_continue' => 'पुनर्लेखन करा',
	'replacetext_editsummary' => "मजकूर पुनर्लेखन - '$1' ते '$2'",
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'replacetext' => 'Ganti teks',
	'replacetext-desc' => 'Menyediakan [[Special:ReplaceText|laman khas]] untuk membolehkan para pentadbir melakukan pencarian dan penggantian rentetan sejagat di semua laman-laman kandungan wiki',
	'replacetext_docu' => "Untuk mengganti satu rentetan teks dengan satu lagi merentasi semua laman biasa di wiki ini, isikan kedua-dua teks yang terlibat di sini, kemudian tekan 'Sambung'.
Kemudian, anda akan ditunjukkan satu senarai laman yang mengandungi teks carian, dan anda boleh memilih laman-laman yang mana anda ingin melakukan penggantian itu.
Nama anda akan terpapar dalam sejarah laman sebagai pengguna yang bertanggungjawab atas sebarang perubahan.",
	'replacetext_originaltext' => 'Teks asal:',
	'replacetext_replacementtext' => 'Teks ganti:',
	'replacetext_useregex' => 'Gunakan ungkapan nalar',
	'replacetext_regexdocu' => '(Contoh: nilai "a(.*)c" untuk "Teks asal" dan "ac$1" untuk "Teks ganti" akan mengganti "abc" dengan "acb".)',
	'replacetext_optionalfilters' => 'Penapis pilihan:',
	'replacetext_categorysearch' => 'Ganti dalam kategori sahaja:',
	'replacetext_prefixsearch' => 'Ganti dalam laman yang berawalan ini sahaja:',
	'replacetext_editpages' => 'Ganti teks dalam kandungan laman',
	'replacetext_movepages' => 'Ganti teks dalam tajuk laman, jika boleh',
	'replacetext_givetarget' => 'Anda mesti menyatakan rentetan untuk diganti.',
	'replacetext_nonamespace' => 'Anda mesti memilih sekurang-kurangnya satu ruang nama.',
	'replacetext_editormove' => 'Anda mesti memilih sekurang-kurangnya satu pilihan penggantian.',
	'replacetext_choosepagesforedit' => 'Ganti "$1" dengan "$2" dalam teks {{PLURAL:$3|laman|laman-laman}} berikut:',
	'replacetext_choosepagesformove' => 'Ganti "$1" dengan "$2" dalam {{PLURAL:$3|judul|judul-judul}} laman yang berikut:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Laman|Laman-laman}} yang berikut tidak boleh dipindahkan:',
	'replacetext_formovedpages' => 'Untuk laman yang dipindahkan:',
	'replacetext_savemovedpages' => 'Simpan tajuk lama sebagai lencongan kepada tajuk baru',
	'replacetext_watchmovedpages' => 'Pantau laman-laman ini',
	'replacetext_invertselections' => 'Songsangkan pilihan',
	'replacetext_replace' => 'Ganti',
	'replacetext_success' => '"$1" akan digantikan oleh "$2" di $3 laman.',
	'replacetext_noreplacement' => 'Tiada laman yang mengandungi rentetan "$1".',
	'replacetext_nomove' => 'Tiada laman yang mengandungi "$1" dalam tajuknya.',
	'replacetext_nosuchcategory' => 'Tiada kategori dengan nama "$1".',
	'replacetext_return' => 'Kembali ke borang.',
	'replacetext_warning' => "'''Amaran:''' Terdapat \$1 laman yang sudah mengandungi rentetan ganti \"\$2\". Jika anda melakukan penggantian ini, anda tidak akan dapat mengasingkan gantian anda daripada rentetan-rentetan ini.",
	'replacetext_blankwarning' => "'''Amaran:''' Oleh sebab rentetan ganti adalah kosong, operasi ini tidak boleh dimansuhkan.",
	'replacetext_continue' => 'Sambung',
	'replacetext_editsummary' => 'Ganti teks - "$1" kepada "$2"',
	'right-replacetext' => 'Membuat penggantian rentetan di seluruh wiki',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 * @author Simny
 */
$messages['nb'] = array(
	'replacetext' => 'Erstatt tekst',
	'replacetext-desc' => 'Lar administratorer kunne [[Special:ReplaceText|erstatte tekst]] på alle innholdssider på en wiki.',
	'replacetext_docu' => 'For å erstatte én tekststreng med en annen på alle datasider på denne wikien kan du skrive inn de to tekstene her og trykke «Erstatt». Du vil da bli ført til en liste over sider som inneholder søketeksten, og du kan velge hvilke sider du ønsker å erstatte den i. Navnet ditt vil stå i sidehistorikkene som den som er ansvarlig for endringene.',
	'replacetext_originaltext' => 'Originaltekst:',
	'replacetext_replacementtext' => 'Erstatningstekst:',
	'replacetext_optionalfilters' => 'Valgfrie filter:',
	'replacetext_categorysearch' => 'Erstatt kun i kategori:',
	'replacetext_prefixsearch' => 'Erstatt kun i sider med prefikset:',
	'replacetext_editpages' => 'Erstatt tekst i sideinnholdet',
	'replacetext_movepages' => 'Erstatt tekst i sidetitler, der dette er mulig',
	'replacetext_givetarget' => 'Du må spesifisere en streng som skal erstattes.',
	'replacetext_nonamespace' => 'Du må velge minst ett navnerom.',
	'replacetext_editormove' => 'Du må velge minst ett av alternativene for erstatning.',
	'replacetext_choosepagesforedit' => 'Velg {{PLURAL:$3|siden|sidene}} der du ønsker å bytte ut «$1» med «$2»:',
	'replacetext_choosepagesformove' => 'Erstatt «$1» med «$2» i {{PLURAL:$3|tittelen på den følgende siden|titlene på de følgende sidene}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Den følgende siden|De følgende sidene}} kan ikke flyttes:',
	'replacetext_formovedpages' => 'For flyttede sider:',
	'replacetext_savemovedpages' => 'Lagre de gamle titlene som omdirigeringer til de nye',
	'replacetext_watchmovedpages' => 'Overvåk disse sidene',
	'replacetext_invertselections' => 'Inverter valg',
	'replacetext_replace' => 'Erstatt',
	'replacetext_success' => '«$1» blir erstattet med «$2» på {{PLURAL:$3|én side|$3 sider}}.',
	'replacetext_noreplacement' => 'Ingen sider ble funnet med strengen «$1».',
	'replacetext_nomove' => 'Ingen sider ble funnet der tittelen inneholder «$1».',
	'replacetext_nosuchcategory' => 'Det eksisterer ingen kategori med navnet «$1».',
	'replacetext_return' => 'Tilbake til skjemaet.',
	'replacetext_warning' => "'''Advarsel:''' Det er {{PLURAL:$1|én side|$1 sider}} som allerede har erstatningsteksten «$2». Om du gjør denne erstatningen vil du ikke kunne skille ut dine erstatninger fra denne teksten.",
	'replacetext_blankwarning' => 'Fordi erstatningsteksten er tom vil denne handlingen ikke kunne angres automatisk; fortsette?',
	'replacetext_continue' => 'Fortsett',
	'replacetext_editsummary' => 'Teksterstatting – «$1» til «$2»',
	'right-replacetext' => 'Gjennomfør teksterstatninger på hele wikien',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'replacetext' => 'Tekst vervangen',
	'replacetext-desc' => "Beheerders kunnen via een [[Special:ReplaceText|speciale pagina]] tekst zoeken en vervangen in alle pagina's",
	'replacetext_docu' => "Om een stuk tekst te vervangen door een ander stuk tekst in alle pagina's van de wiki, kunt u hier deze twee tekstdelen ingeven en daarna op 'Vervangen' klikken.
U krijgt dan een lijst met pagina's te zien waar uw te vervangen tekstdeel in voorkomt, en u kunt kiezen in welke pagina's u de tekst ook echt wilt vervangen.
Uw naam wordt opgenomen in de geschiedenis van de pagina als verantwoordelijke voor de wijzigingen.",
	'replacetext_originaltext' => 'Oorspronkelijke tekst:',
	'replacetext_replacementtext' => 'Vervangende tekst:',
	'replacetext_useregex' => 'Reguliere expressies en wildcards gebruiken',
	'replacetext_regexdocu' => 'Voorbeeld: waarden van "a(.*)c" voor "Originele tekst" en "ac$1" voor "Te vervangen tekst" vervangt "abc" door "acb".',
	'replacetext_optionalfilters' => 'Optionele filters:',
	'replacetext_categorysearch' => 'Alleen in de volgende categorie vervangen:',
	'replacetext_prefixsearch' => "Alleen in pagina's met het volgende voorvoegsel vervangen:",
	'replacetext_editpages' => 'Tekst vervangen in de pagina-inhoud',
	'replacetext_movepages' => 'Tekst vervangen in paginanamen als mogelijk',
	'replacetext_givetarget' => 'U moet de te vervangen tekst opgeven.',
	'replacetext_nonamespace' => 'U moet ten minste één naamruimte selecteren.',
	'replacetext_editormove' => 'U moet tenminste een van de vervangingingsopties kiezen.',
	'replacetext_choosepagesforedit' => "Selecteer de {{PLURAL:$3|pagina|pagina's}} waar u '$1' door '$2' wilt vervangen:",
	'replacetext_choosepagesformove' => '"$1" door "$2" vervangen in de volgende {{PLURAL:$3|paginanaam|paginanamen}}:',
	'replacetext_cannotmove' => "De volgende {{PLURAL:$1|pagina kan|pagina's kunnen}} niet hernoemd worden:",
	'replacetext_formovedpages' => "Voor hernoemde pagina's:",
	'replacetext_savemovedpages' => "Een doorwijziging aanmaken voor hernoemde pagina's",
	'replacetext_watchmovedpages' => "Deze pagina's volgen",
	'replacetext_invertselections' => 'Selecties omkeren',
	'replacetext_replace' => 'Vervangen',
	'replacetext_success' => '"$1" wordt in $3 {{PLURAL:$3|pagina|pagina\'s}} vervangen door "$2".',
	'replacetext_noreplacement' => "Er waren geen pagina's die de tekst '$1' bevatten.",
	'replacetext_nomove' => 'Er zijn geen pagina\'s gevonden met "$1" in de naam.',
	'replacetext_nosuchcategory' => 'De categorie "$1" bestaat niet.',
	'replacetext_return' => 'Terugkeren naar het formulier.',
	'replacetext_warning' => '\'\'\'Waarschuwing:\'\'\' Er {{PLURAL:$1|is $1 pagina|zijn $1 pagina\'s}} die het te vervangen tesktdeel al "$2" al {{PLURAL:$1|bevat|bevatten}}.
Als u nu doorgaat met vervangen, kunt u geen onderscheid meer maken.',
	'replacetext_blankwarning' => 'Omdat u tekst vervangt door niets, kan deze handeling niet ongedaan gemaakt worden. Wilt u doorgaan?',
	'replacetext_continue' => 'Doorgaan',
	'replacetext_editsummary' => "Tekst vervangen - '$1' door '$2'",
	'right-replacetext' => 'Tekst vervangen in de hele wiki',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'replacetext' => 'Byt ut tekst',
	'replacetext-desc' => 'Gjev ei [[Special:ReplaceText|spesialsida]] som lèt administratorar søkja etter og byta ut tekst på alle innhaldssidene på ein wiki.',
	'replacetext_docu' => 'For å byta éin tekststreng med ein annan på alle datasidene på denne wikien kan du skriva inn dei to tekstane her og trykkja «Hald fram». Du vil då bli førd til ei lista over sidene som inneheld søkjestrengen, og du kan velja kva sider du ønskjer å byta han ut i. Namnet ditt vil stå i sidehistorikkane som han som er ansvarleg for endringane.',
	'replacetext_originaltext' => 'Originaltekst:',
	'replacetext_replacementtext' => 'Ny tekst til erstatning:',
	'replacetext_optionalfilters' => 'Valfrie filter:',
	'replacetext_categorysearch' => 'Byt berre ut i kategorien:',
	'replacetext_prefixsearch' => 'Byt berre ut på sider med førestavinga:',
	'replacetext_editpages' => 'Byt ut tekst i sideinnhaldet',
	'replacetext_movepages' => 'Byt ut tekst i sidetitlar der dette er mogleg',
	'replacetext_givetarget' => 'Du må spesifisera strengen som skal verta bytt ut.',
	'replacetext_nonamespace' => 'Du må velja minst eitt namnerom.',
	'replacetext_editormove' => 'Du må velja minst eitt av vala for tekstbyte.',
	'replacetext_choosepagesforedit' => 'Vel {{PLURAL:$3|sida|sidene}} der du ønskjer å byta ut «$1» med «$2»:',
	'replacetext_choosepagesformove' => 'Byt ut «$1» med «$2» i {{PLURAL:$3|namnet på den følgjande sida|namna på dei følgjande sidene}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Den følgjande sida|Dei følgjande sidene}} kan ikkje bli flytta:',
	'replacetext_formovedpages' => 'For flytta sider:',
	'replacetext_savemovedpages' => 'Lagra dei gamle titlane som omdirigeringar til dei nye',
	'replacetext_watchmovedpages' => 'Hald oppsyn med desse sidene',
	'replacetext_invertselections' => 'Inverter val',
	'replacetext_replace' => 'Byt ut',
	'replacetext_success' => '$1» blir byta ut med «$2» på {{PLURAL:$3|éi sida|$3 sider}}.',
	'replacetext_noreplacement' => 'Fann ingen sider som inneheldt søkjestrengen «$1».',
	'replacetext_nomove' => 'Ingen sider vart funne der tittelen inneheld «$1».',
	'replacetext_nosuchcategory' => 'Det finst ingen kategoriar med namnet «$1».',
	'replacetext_return' => 'Attende til skjemaet.',
	'replacetext_warning' => 'Det finst {{PLURAL:$1|éi sida|$1 sider}} som allereie inneheld strengen som skal bli sett inn, «$2».
Om du utfører denne utbytinga vil du ikkje vera i stand til å skilja utbytingane dine frå desse strengane.
Halda fram med utbytinga?',
	'replacetext_blankwarning' => 'Av di teksten som skal bli sett inn er tom, vil ikkje denne handlinga kunna bli køyrt omvendt.
Vil du halda fram?',
	'replacetext_continue' => 'Hald fram',
	'replacetext_editsummary' => 'Utbyting av tekst - «$1» til «$2»',
	'right-replacetext' => 'Gjennomfør utbyting av tekst på heile wikien',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'replacetext' => 'Remplaçar lo tèxte',
	'replacetext-desc' => 'Provesís una [[Special:ReplaceText|pagina especiala]] que permet als administrators de remplaçar de cadenas de caractèrs per d’autras sus l’ensemble del wiki',
	'replacetext_docu' => "Per remplaçar una cadena de caractèrs amb una autra sus l'ensemble de las donadas de las paginas d'aqueste wiki, podètz picar los dos tèxtes aicí e clicar sus 'Remplaçar'. Vòstre nom apareiserà dins l'istoric de las paginas tal coma un utilizaire autor dels cambiaments.",
	'replacetext_originaltext' => 'Tèxte original :',
	'replacetext_replacementtext' => 'Tèxte novèl :',
	'replacetext_optionalfilters' => 'Filtres opcionals :',
	'replacetext_categorysearch' => 'Remplaçar solament dins la categoria :',
	'replacetext_prefixsearch' => "Remplaçar solament dins las paginas qu'an lo prefix :",
	'replacetext_editpages' => 'Remplaçar lo tèxte dins lo contengut dins la pagina',
	'replacetext_movepages' => 'Remplaçar lo tèxte dins lo títol de las paginas, se possible',
	'replacetext_givetarget' => 'Vos cal especificar la cadena de remplaçar.',
	'replacetext_nonamespace' => 'Vos cal seleccionar al mens un espaci de noms.',
	'replacetext_editormove' => 'Vos cal causir al mens una opcion de remplaçament.',
	'replacetext_choosepagesforedit' => 'Seleccionatz {{PLURAL:$3|la pagina|las paginas}} dins {{PLURAL:$3|la quala|las qualas}} volètz remplaçar « $1 » per « $2 » :',
	'replacetext_choosepagesformove' => 'Remplaçar « $1 » per « $2 » dins {{PLURAL:$3|lo nom de la pagina seguenta|los noms de las paginas seguentas}} :',
	'replacetext_cannotmove' => '{{PLURAL:$1|La pagina seguenta a pas pogut èsser renomenada|Las paginas seguentas an pas pogut èsser renomenadas}} :',
	'replacetext_formovedpages' => 'Per las paginas renomenadas :',
	'replacetext_savemovedpages' => 'Enregistratz los títols ancians coma redireccions cap als títols novèls',
	'replacetext_watchmovedpages' => 'Seguir aquestas paginas',
	'replacetext_invertselections' => 'Inversar las seleccions',
	'replacetext_replace' => 'Remplaçar',
	'replacetext_success' => '« $1 » es estat remplaçat per « $2 » dins $3 fichièr{{PLURAL:$3||s}}.',
	'replacetext_noreplacement' => 'Cap de fichièr que conten la cadena « $1 » es pas estat trobat.',
	'replacetext_nomove' => 'Cap de pagina es pas estada trobada amb lo títol que conten « $1 ».',
	'replacetext_nosuchcategory' => 'Existís pas de categoria nomenada « $1 ».',
	'replacetext_return' => 'Tornar al formulari.',
	'replacetext_warning' => "I a $1 fichièr{{PLURAL:$1| que conten|s que contenon}} ja la cadena de remplaçament « $2 ».
S'efectuatz aquesta substitucion, poiretz pas separar vòstres cambiaments a partir d'aquestas cadenas.",
	'replacetext_blankwarning' => 'Perque la cadena de remplaçament es voida, aquesta operacion serà irreversibla ; volètz contunhar ?',
	'replacetext_continue' => 'Contunhar',
	'replacetext_editsummary' => 'Remplaçament del tèxte — « $1 » per « $2 »',
	'right-replacetext' => 'Far de remplaçaments de tèxte dins tot lo wiki',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'replacetext_noreplacement' => 'Ken Blatt gfunne mit „$1“.',
	'replacetext_continue' => 'Weider',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Matma Rex
 * @author Odder
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'replacetext' => 'Zastąp tekst',
	'replacetext-desc' => 'Dodaje [[Special:ReplaceText|stronę specjalną]], pozwalającą administratorom na wyszukanie i zamianę zadanego tekstu w treści wszystkich stron wiki',
	'replacetext_docu' => 'Możesz zastąpić jeden ciąg znaków innym, w treści wszystkich stron tej wiki. W tym celu wprowadź dwa fragmenty tekstu i naciśnij „Kontynuuj”. Zostanie pokazana lista stron, które zawierają wyszukiwany tekst. Będziesz mógł wybrać te strony, na których chcesz ten tekst zamienić na nowy. W historii zmian stron, do opisu autora edycji, zostanie użyta Twoja nazwa użytkownika.',
	'replacetext_originaltext' => 'Wyszukiwany tekst',
	'replacetext_replacementtext' => 'Zamień na',
	'replacetext_useregex' => 'Użyj wyrażeń regularnych',
	'replacetext_regexdocu' => '(Przykładowo wstawiając „a(.*)c“ w polu „{{int:replacetext_originaltext}}“ oraz „ac$1“ w polu „{{int:replacetext_replacementtext}}“ spowodujesz zastąpienie „abc“ przez „acb“.)',
	'replacetext_optionalfilters' => 'Dodatkowe filtry:',
	'replacetext_categorysearch' => 'Zamień tylko w kategorii',
	'replacetext_prefixsearch' => 'Zamień tylko na stronach z prefiksem',
	'replacetext_editpages' => 'Zastąp tekst w treści stron',
	'replacetext_movepages' => 'Jeśli to możliwe wykonaj zastępowanie również w tytułach stron',
	'replacetext_givetarget' => 'Musisz podać łańcuch znaków, który ma zostać zastąpiony.',
	'replacetext_nonamespace' => 'Musisz wybrać co najmniej jedną przestrzeń nazw.',
	'replacetext_editormove' => 'Musisz wybrać co najmniej jedną opcję zastępowania.',
	'replacetext_choosepagesforedit' => 'Wybierz {{PLURAL:$3|stronę|strony}}, na których chcesz „$1” zastąpić „$2”',
	'replacetext_choosepagesformove' => 'Zastąp „$1” tekstem „$2” w {{PLURAL:$3|tytule strony|tytułach następujących stron:}}',
	'replacetext_cannotmove' => '{{PLURAL:$1|Poniższa strona nie może zostać przeniesiona|Poniższe strony nie mogą zostać przeniesione}}:',
	'replacetext_formovedpages' => 'Dla przeniesionych stron:',
	'replacetext_savemovedpages' => 'Zapisz stare tytuły jako przekierowania do nowych',
	'replacetext_watchmovedpages' => 'Obserwuj te strony',
	'replacetext_invertselections' => 'Odwróć zaznaczenie',
	'replacetext_replace' => 'Zastąp',
	'replacetext_success' => '„$1” zostanie zastąpiony przez „$2” na $3 {{PLURAL:$3|stronie|stronach}}.',
	'replacetext_noreplacement' => 'Nie znaleziono stron zawierających tekst „$1”.',
	'replacetext_nomove' => 'Nie znaleziono żadnych stron o tytule zawierającym „$1”.',
	'replacetext_nosuchcategory' => 'Kategoria „$1” nie istnieje.',
	'replacetext_return' => 'Powrót do formularza.',
	'replacetext_warning' => "'''Uwaga''' {{PLURAL:$1|Jest $1 strona zawierająca|Są $1 strony zawierające|Jest $1 stron zawierających}} tekst „$2”, którym chcesz zastępować. Jeśli wykonasz zastępowanie nie będzie możliwe odseparowanie Twoich zastąpień od tych tekstów.",
	'replacetext_blankwarning' => 'Ponieważ ciąg znaków, którym ma być wykonane zastępowanie jest pusty, operacja będzie nieodwracalna. Czy kontynuować?',
	'replacetext_continue' => 'Kontynuuj',
	'replacetext_editsummary' => 'zamienił w treści „$1” na „$2”',
	'right-replacetext' => 'Wykonywanie zastępowania tekstu w całej wiki',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'replacetext' => 'Rimpiassa test',
	'replacetext-desc' => "A dà na [[Special:ReplaceText|pàgina special]] për përmëtte a j'aministrator ëd fé un sërca-e-rampiassa dë stringhe global su tute le pàgine ëd contnù ëd na wiki",
	'replacetext_docu' => "Për rimpiassé na stringa ëd test con n'àutra ans tute  le pàgine regolar dë sta wiki-sì, anseriss ij doi tòch ëd test sì e peui sgnaca 'Continua'.
At sarà alora mostrà na lista ëd pàgine ch'a conten-o ël test d'arserca, e it podras serne cole andoa it veule rimpiasselo.
Tò nòm a aparirà ant le stòrie dle pàgine com l'utent responsàbil për minca cangiament.",
	'replacetext_originaltext' => 'Test original:',
	'replacetext_replacementtext' => 'Test ëd rimpiassadura:',
	'replacetext_useregex' => "Dovré dj'espression regolar",
	'replacetext_regexdocu' => '(Esempi: valor ëd "a(.*)c" për "Test original" e "ac$1" për "Rimpiassé test" a dovrìa rimpiassé "abc" with "acb".)',
	'replacetext_optionalfilters' => 'Filtr opsionaj:',
	'replacetext_categorysearch' => 'Rimpiassa mach an categorìa:',
	'replacetext_prefixsearch' => 'Rimpiassa mach an pàgine con ël prefiss:',
	'replacetext_editpages' => 'Rimpiassa test ant ij contnù dla pàgina',
	'replacetext_movepages' => 'Rimpiassa test ant ij tìtoj dla pàgina, quand possìbil',
	'replacetext_givetarget' => 'It deve spessifiché la stringa da esse rimpiassà.',
	'replacetext_nonamespace' => 'It deve spessifiché almanch në spassi nominal.',
	'replacetext_editormove' => "It deve selessioné almanch un-a dj'opsion ëd rampiass.",
	'replacetext_choosepagesforedit' => 'Rimpiassa "$1" con "$2" ant ël test ëd {{PLURAL:$3|la pàgina|le pàgine}} sota:',
	'replacetext_choosepagesformove' => 'Rimpiassa "$1" con "$2" ant {{PLURAL:$3|ël tìtol dla pàgina|ij tìtoj dle pàgine}} sota:',
	'replacetext_cannotmove' => '{{PLURAL:$1|La pàgina|Le pàgine}} sota a peulo pa esse tramudà:',
	'replacetext_formovedpages' => 'Për le pàgine tramudà:',
	'replacetext_savemovedpages' => 'Salva ël tìtol vej com ridiression al tìtol neuv',
	'replacetext_watchmovedpages' => "Ten d'euj ste pàgine-sì",
	'replacetext_invertselections' => 'Anvert selession',
	'replacetext_replace' => 'Rimpiassa',
	'replacetext_success' => '"$1" a sarà rimpiassà con "$2" an $3 {{PLURAL:$3|pàgina|pàgine}}.',
	'replacetext_noreplacement' => 'Pa gnun-e pàgine trovà contenente la stringa "$1".',
	'replacetext_nomove' => 'Pa gnun-e pàgine trovà con ij tìtoj contenent "$1".',
	'replacetext_nosuchcategory' => 'A esisto gnun-e categorìe con ël nòm "$1".',
	'replacetext_return' => 'Artorna al formolari.',
	'replacetext_warning' => "'''Atension:''' A-i {{PLURAL:\$1|é \$1 pàgina ch'a conten|son \$1 pàgine ch'a conten-o}} già la stringa ëd rimpiassadura, \"\$2\".
S'it fas sta rimpiassadura-sì it saras pa bon a separé toe rimpiassadure da ste stringhe-sì.",
	'replacetext_blankwarning' => "Da già che la stringa ëd rimpiass a l'é veuida, st'operassion-sì a sarà pa reversìbil.
Veul-lo continué?",
	'replacetext_continue' => 'Continua',
	'replacetext_editsummary' => 'Rimpiassadura test - "$1" a "$2"',
	'right-replacetext' => "Fà rimpiassadura dë stringhe an sl'antrega wiki",
);

/** Pontic (Ποντιακά)
 * @author Omnipaedista
 */
$messages['pnt'] = array(
	'replacetext_originaltext' => 'Πρωτότυπον κείμενον:',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'replacetext' => 'متن ځايناستول',
	'replacetext_originaltext' => 'آرنی متن:',
	'replacetext_replacementtext' => 'د متن ځايناستوب:',
	'replacetext_categorysearch' => 'يوازې په وېشنيزه کې ځايناستول:',
	'replacetext_prefixsearch' => 'يوازې په مختاړي لرونکيو مخونو کې ځايناستول:',
	'replacetext_editpages' => 'د مخ په مېنځپانګه کې متن ځايناستول',
	'replacetext_movepages' => 'د شونتيا په وخت کې، د مخ د سرليک متن ځايناستول',
	'replacetext_nonamespace' => 'تاسې بايد لږ تر لږه يو نوم-تشيال وټاکۍ.',
	'replacetext_cannotmove' => 'دا {{PLURAL:$1|لاندې مخ|لانديني مخونه}} د لېږدولو وړ نه دي:',
	'replacetext_formovedpages' => 'د لېږدل شويو مخونو لپاره:',
	'replacetext_watchmovedpages' => 'همدا مخونه کتل',
	'replacetext_invertselections' => 'ټاکنې سرچپه کول',
	'replacetext_replace' => 'ځايناستول',
	'replacetext_editsummary' => 'متن ځايناستول - له "$1" نه "$2" ته',
);

/** Portuguese (Português)
 * @author 555
 * @author Crazymadlover
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'replacetext' => 'Substituir texto',
	'replacetext-desc' => "[[Special:ReplaceText|Página especial]] que permite que os administradores façam substituições globais de texto ''(string find-and-replace)'' em todas as páginas de conteúdo de uma wiki",
	'replacetext_docu' => 'Para substituir um texto por outro texto em todas as páginas desta wiki, introduza os dois textos e clique o botão "Prosseguir".
Serão listadas as páginas que contêm o texto a substituir e poderá seleccionar em quais deseja proceder à substituição.
O seu nome aparecerá no histórico dessas páginas como o utilizador responsável pelas alterações.',
	'replacetext_originaltext' => 'Texto original:',
	'replacetext_replacementtext' => 'Texto de substituição:',
	'replacetext_useregex' => 'Usar expressões regulares',
	'replacetext_regexdocu' => '(Exemplo: os valores "a(.*)c" no "Texto original" e "ac$1" no "Texto de substituição" substituiriam "abc" por "acb")',
	'replacetext_optionalfilters' => 'Filtros opcionais:',
	'replacetext_categorysearch' => 'Substituir só na categoria:',
	'replacetext_prefixsearch' => 'Substituir só em páginas com o prefixo:',
	'replacetext_editpages' => 'Substituir texto no conteúdo da página',
	'replacetext_movepages' => 'Substituir texto nos títulos de páginas, quando possível',
	'replacetext_givetarget' => 'Deve especificar o texto que será substituído.',
	'replacetext_nonamespace' => 'Deverá seleccionar pelo menos um espaço nominal.',
	'replacetext_editormove' => 'Deve seleccionar pelo menos uma das opções de substituição.',
	'replacetext_choosepagesforedit' => 'Substituir "$1" por "$2" no texto {{PLURAL:$3|da seguinte página|das seguintes páginas}}:',
	'replacetext_choosepagesformove' => 'Substituir "$1" por "$2" {{PLURAL:$3|no título da seguinte página|nos títulos das seguintes páginas}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|A seguinte página não pode ser movida|As seguintes páginas não podem ser movidas}}:',
	'replacetext_formovedpages' => 'Para páginas movidas:',
	'replacetext_savemovedpages' => 'Gravar os títulos anteriores como redireccionamentos para os novos títulos',
	'replacetext_watchmovedpages' => 'Vigiar estas páginas',
	'replacetext_invertselections' => 'Inverter selecções',
	'replacetext_replace' => 'Substituir',
	'replacetext_success' => "'$1' será substituído por '$2' em $3 {{PLURAL:$3|página|páginas}}.",
	'replacetext_noreplacement' => 'Não foram encontradas páginas que contenham o texto "$1".',
	'replacetext_nomove' => 'Não foram encontradas páginas cujo título contenha "$1".',
	'replacetext_nosuchcategory' => 'Não existe nenhuma categoria com o nome "$1".',
	'replacetext_return' => 'Voltar ao formulário.',
	'replacetext_warning' => "'''Aviso:''' Há {{PLURAL:\$1|uma página que já contém|\$1 páginas que já contêm}} o texto de substituição, \"\$2\". Se fizer esta substituição não poderá distingui-las das suas substituições, nem desfazer a operação com uma simples substituição em ordem inversa.",
	'replacetext_blankwarning' => "'''Aviso:''' Como o texto de substituição foi deixado em branco, esta operação não será reversível.",
	'replacetext_continue' => 'Prosseguir',
	'replacetext_editsummary' => 'Substituição de texto - de "$1" para "$2"',
	'right-replacetext' => 'Fazer substituições de texto em toda a wiki',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Crazymadlover
 * @author Eduardo.mps
 * @author Enqd
 * @author Giro720
 * @author Hamilton Abreu
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'replacetext' => 'Substituir texto',
	'replacetext-desc' => 'Fornece uma [[Special:ReplaceText|página especial]] que permite que administradores procurem e substituam uma "string" global em todas as páginas de conteúdo de uma wiki.',
	'replacetext_docu' => 'Para substituir uma "string" de texto por outra em todas as páginas desta wiki você precisa fornecer o texto a ser substituído e o novo texto, logo em seguida pressione o botão \'Substituir\'. Será exibida uma lista de páginas que contenham o termo pesquisado, sendo possível selecionar em quais você deseja realizar substituições. Seu nome de utilizador aparecerá nos históricos de páginas como o responsável por ter feito as alterações.',
	'replacetext_originaltext' => 'Texto original:',
	'replacetext_replacementtext' => 'Texto substitutivo:',
	'replacetext_optionalfilters' => 'Filtros opcionais:',
	'replacetext_categorysearch' => 'Substituir apenas na categoria:',
	'replacetext_prefixsearch' => 'Substituir apenas em páginas com o prefixo:',
	'replacetext_editpages' => 'Substituir texto no conteúdo da página',
	'replacetext_movepages' => 'Substituir texto nos títulos das páginas, quando possível',
	'replacetext_givetarget' => 'Você deve especificar um texto a ser substituido.',
	'replacetext_nonamespace' => 'Você deve selecionar pelo menos um domínio.',
	'replacetext_editormove' => 'Você deve selecionar pelo menos uma das opções de substituição',
	'replacetext_choosepagesforedit' => "!!Por favor, seleccione {{PLURAL:$3|a página na qual|as páginas nas quais}} deseja substituir '$1' por '$2':",
	'replacetext_choosepagesformove' => 'Substituir "$1" por "$2" {{PLURAL:$3|no nome da seguinte página|nos nomes das seguintes páginas}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|A seguinte página não pode ser movida|As seguintes páginas não podem ser movidas}}:',
	'replacetext_formovedpages' => 'Para páginas movidas:',
	'replacetext_savemovedpages' => 'Manter os títulos antigos como redirecionamentos para os novos títulos',
	'replacetext_watchmovedpages' => 'Vigiar estas páginas',
	'replacetext_invertselections' => 'Inverter seleções',
	'replacetext_replace' => 'Substituir',
	'replacetext_success' => "'$1' será substituído por '$2' em $3 {{PLURAL:$3|página|páginas}}.",
	'replacetext_noreplacement' => 'Não foram encontradas páginas contendo a "string" \'$1\'.',
	'replacetext_nomove' => "Não foram encontradas páginas com títulos contendo '$1'.",
	'replacetext_nosuchcategory' => 'Não existe categoria com o nome "$1".',
	'replacetext_return' => 'Voltar ao formulário.',
	'replacetext_warning' => "'''Aviso:''' Há {{PLURAL:\$1|uma página que já contém|\$1 páginas que já contêm}} o texto de substituição, \"\$2\". Se fizer esta substituição não poderá desfazer a operação com uma simples substituição em ordem inversa.",
	'replacetext_blankwarning' => '!!Uma vez que a "string" de novo texto foi deixada em branco, esta operação não será reversível. Prosseguir?',
	'replacetext_continue' => 'Prosseguir',
	'replacetext_editsummary' => "Substituindo texto '$1' por '$2'",
	'right-replacetext' => 'Faça substituições de cadeias de caracteres no wiki inteiro',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'replacetext' => 'Înlocuiește text',
	'replacetext_originaltext' => 'Text original:',
	'replacetext_optionalfilters' => 'Filtre opționale:',
	'replacetext_watchmovedpages' => 'Urmărește aceste pagini',
	'replacetext_replace' => 'Înlocuire',
	'replacetext_nomove' => "Nu a fost găsită nici o pagină al cărei titlu să conțină '$1'.",
	'replacetext_return' => 'Revenire la formular.',
	'replacetext_continue' => 'Continuare',
	'replacetext_editsummary' => "Înlocuire de text - '$1' în '$2'",
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'replacetext' => "Sostituisce 'u teste",
	'replacetext_originaltext' => 'Teste origgenale:',
	'replacetext_replace' => 'Sostituisce',
	'replacetext_continue' => 'Condinue',
);

/** Russian (Русский)
 * @author AlexSm
 * @author Ferrer
 * @author Kv75
 * @author Normalex
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'replacetext' => 'Заменить текст',
	'replacetext-desc' => 'Добавляет [[Special:ReplaceText|служебную страницу]], позволяющую администраторам осуществлять повсеместную замену указанного текста на всех обычных страницах вики',
	'replacetext_docu' => 'Для того, чтобы заменить один текст на другой на всех страницах вики, вам необходимо ввести здесь желаемый текст и нажать на кнопку «Продолжить». После этого вам будет предложен список всех страниц, содержащих заменяемый текст, и вы сможете выбрать из них те, в которых нужно произвести замены. В качестве лица, отвечающего за внесённые изменения, в истории правок страниц, в которых произойдёт замена текста, будете указаны вы.',
	'replacetext_originaltext' => 'Исходный текст:',
	'replacetext_replacementtext' => 'Текст для замены:',
	'replacetext_useregex' => 'Использовать регулярные выражения',
	'replacetext_regexdocu' => '(Например, выражения «a(.*)c» в поле «Исходный текст» и «ac$1» в поле «Текст для замены» приведут к замене «abc» на «acb».)',
	'replacetext_optionalfilters' => 'Необязательные фильтры:',
	'replacetext_categorysearch' => 'Заменить только в категории:',
	'replacetext_prefixsearch' => 'Заменить только в страницах с приставкой:',
	'replacetext_editpages' => 'Замена текста в содержимом страниц',
	'replacetext_movepages' => 'Заменить текст в названиях страниц, если это возможно',
	'replacetext_givetarget' => 'Вы должны указать строку, которую нужно заменить.',
	'replacetext_nonamespace' => 'Вы должны выбрать по крайней мере одно пространство имён.',
	'replacetext_editormove' => 'Вы должны выбрать по крайней мере, один из вариантов замены.',
	'replacetext_choosepagesforedit' => 'Пожалуйста, выберите {{PLURAL:$3|страницу, в которой|страницы, в которых}} вы хотите осуществить замену «$1» на «$2»:',
	'replacetext_choosepagesformove' => 'Заменить «$1» на «$2» в {{PLURAL:$3|названии следующей страницы|названиях следующих страниц}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Следующая страница не может быть переименована|Следующие страницы не могут быть переименованы}}:',
	'replacetext_formovedpages' => 'Для переименованных страниц:',
	'replacetext_savemovedpages' => 'Сохранить старые названия как перенаправления на новые',
	'replacetext_watchmovedpages' => 'Включить эти страницы в список наблюдения',
	'replacetext_invertselections' => 'Инвертировать выбор',
	'replacetext_replace' => 'Заменить',
	'replacetext_success' => '«$1» будет заменён на «$2» на $3 {{PLURAL:$3|странице|страницах|страницах}}.',
	'replacetext_noreplacement' => 'Не найдено ни одной страницы, содержащей «$1».',
	'replacetext_nomove' => 'Не удалось найти страницы, заголовок которых содержит «$1».',
	'replacetext_nosuchcategory' => 'Не существует категории с именем «$1».',
	'replacetext_return' => 'Вернуться к форме.',
	'replacetext_warning' => "'''Внимание.''' Найдена {{PLURAL:$1|$1 страница, содержащая|$1 страницы, содержащие|$1 страниц, содержащих}} текст для замены, «$2». Если вы продолжите операцию замены, то не сможете отделить уже существующие записи от тех, которые появятся после замены.",
	'replacetext_blankwarning' => 'Из-за того, что текст для замены пуст, операция по замене не сможет быть отменена.
Вы хотите продолжить?',
	'replacetext_continue' => 'Продолжить',
	'replacetext_editsummary' => 'Замена текста — «$1» на «$2»',
	'right-replacetext' => 'выполнение замен текста во всей вики',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'replacetext' => 'Nahradiť text',
	'replacetext-desc' => 'Poskytuje [[Special:ReplaceText|špeciálnu stránku]], ktorá správcom umožňuje globálne nájsť a nahradiť text na všetkých stránkach celej wiki.',
	'replacetext_docu' => 'Nájsť text na všetkých stránkach tejto wiki a nahradiť ho iným textom môžete tak, že sem napíšete texty a stlačíte „Pokračovať”. Potom sa vám zobrazí zoznam stránok obsahujúcich hľadaný text a môžete si zvoliť tie, na ktorých ho chcete nahradiť. V histórii úprav sa zaznamená vaše meno.',
	'replacetext_originaltext' => 'Pôvodný text:',
	'replacetext_replacementtext' => 'Nahradiť textom:',
	'replacetext_optionalfilters' => 'Nepovinné filtre:',
	'replacetext_categorysearch' => 'Nahradiť iba v kategórii:',
	'replacetext_prefixsearch' => 'Nahradiť iba v stránkach s predponou:',
	'replacetext_editpages' => 'Nahradiť text v obsahu stránok',
	'replacetext_movepages' => 'Nahradiť text v názvoch stránok, keď je to možné',
	'replacetext_givetarget' => 'Musíte zadať reťazec, ktorý sa má nahradiť.',
	'replacetext_nonamespace' => 'Musíte vybrať aspoň jeden menný priestor.',
	'replacetext_editormove' => 'Musíte vybrať aspoň jednu z volieb nahrádzania.',
	'replacetext_choosepagesforedit' => 'Prosím, vyberte {{PLURAL:$3|stránku, na ktorej|stránky, na ktorých}} chcete nahradiť „$1“ za „$2“:',
	'replacetext_choosepagesformove' => 'Nahradiť text „$1“ textom „$2“ v {{PLURAL:$3|názve nasledovnej stránky|názvoch nasledovných stránok}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Nasledovnú stránku|Nasledovné stránky}} nemožno presunúť:',
	'replacetext_formovedpages' => 'Pri presunutých stránkach:',
	'replacetext_savemovedpages' => 'Ukladať staré názvy ako presmerovania na nové názvy',
	'replacetext_watchmovedpages' => 'Sledovať tieto stránky',
	'replacetext_invertselections' => 'Invertovať výber',
	'replacetext_replace' => 'Nahradiť',
	'replacetext_success' => 'Text „$1” bude nahradený textom „$2” na $3 {{PLURAL:$3|stránke|stránkach}}.',
	'replacetext_noreplacement' => 'Nenašli sa žiadne stránky obsahujúce text „$1”.',
	'replacetext_nomove' => 'Neboli nájdené žiadne stránky, ktorých názov obsahuje „$1“.',
	'replacetext_nosuchcategory' => 'Žiadna kategória s názvom „$1“ neexistuje.',
	'replacetext_return' => 'Späť na formulár.',
	'replacetext_warning' => '$1 {{PLURAL:$1|stránka|stránok}} už obsahuje text „$2”, ktorým chcete text nahradiť; ak budete pokračovať a text nahradíte, nebudete môcť odlíšiť vaše nahradenia od existujúceho textu, ktorý tento reťazec už obsahuje. Pokračovať v nahradení?',
	'replacetext_blankwarning' => 'Pretože text, ktorým text chcete nahradiť je prázdny, operácia bude nevratná. Pokračovať?',
	'replacetext_continue' => 'Pokračovať',
	'replacetext_editsummary' => 'Nahradenie textu „$1” textom „$2”',
	'right-replacetext' => 'Vykonať náhradu reťazcov na celej wiki',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'replacetext' => 'Замена текста',
	'replacetext_originaltext' => 'Изворни текст:',
	'replacetext_replacementtext' => 'Нови текст:',
	'replacetext_optionalfilters' => 'Необавезни филтери:',
	'replacetext_categorysearch' => 'Замени само у категорији:',
	'replacetext_editpages' => 'Замени текст у садржају странице',
	'replacetext_movepages' => 'Замени текст у насловима страница, када је могуће',
	'replacetext_givetarget' => 'Морате навести ниску коју желите да замените.',
	'replacetext_nonamespace' => 'Морате изабрати барем један именски простор.',
	'replacetext_editormove' => 'Морате изабрати барем једну од могућности за замену.',
	'replacetext_choosepagesforedit' => 'Замени „$1“ са „$2“ у тексту {{PLURAL:$3|следеће странице|следећих страница}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Следећа страница не може бити премештена|Следеће странице не могу бити премештене}}:',
	'replacetext_formovedpages' => 'За премештене странице:',
	'replacetext_savemovedpages' => 'Сачувај старе наслове као преусмерења ка новим насловима',
	'replacetext_watchmovedpages' => 'Надгледај ове стране',
	'replacetext_invertselections' => 'Обрни избор',
	'replacetext_replace' => 'Замени',
	'replacetext_success' => "'$1' ће бити замењено са '$2' у $3 {{PLURAL:$3|страни|страна}}.",
	'replacetext_noreplacement' => "Није нађена ниједна страница која садржи стринг '$1'.",
	'replacetext_nomove' => 'Није нађена ниједна страница чији наслов садржи „$1“.',
	'replacetext_return' => 'Назад на образац.',
	'replacetext_continue' => 'Настави',
	'replacetext_editsummary' => "Замена текста - '$1' у '$2'",
	'right-replacetext' => 'замењивање ниски на целом викију',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'replacetext' => 'Zamena teksta',
	'replacetext_originaltext' => 'Izvorni tekst:',
	'replacetext_replacementtext' => 'Novi tekst:',
	'replacetext_optionalfilters' => 'Neobavezni filteri:',
	'replacetext_categorysearch' => 'Zameni samo u kategoriji:',
	'replacetext_editpages' => 'Zameni tekst u sadržaju stranice',
	'replacetext_movepages' => 'Zameni tekst u naslovima stranica, kada je moguće',
	'replacetext_givetarget' => 'Morate navesti nisku koju želite da zamenite.',
	'replacetext_nonamespace' => 'Morate izabrati barem jedan imenski prostor.',
	'replacetext_editormove' => 'Morate izabrati barem jednu od mogućnosti za zamenu.',
	'replacetext_choosepagesforedit' => 'Zameni „$1“ sa „$2“ u tekstu {{PLURAL:$3|sledeće stranice|sledećih stranica}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Sledeća stranica ne može biti premeštena|Sledeće stranice ne mogu biti premeštene}}:',
	'replacetext_formovedpages' => 'Za premeštene stranice:',
	'replacetext_savemovedpages' => 'Sačuvaj stare naslove kao preusmerenja ka novim naslovima',
	'replacetext_watchmovedpages' => 'Nadgledaj ove strane',
	'replacetext_invertselections' => 'Obrni izbor',
	'replacetext_replace' => 'Zameni',
	'replacetext_success' => "'$1' će biti zamenjeno sa '$2' u $3 {{PLURAL:$3|strani|strana}}.",
	'replacetext_noreplacement' => "Nije nađena nijedna stranica koja sadrži string '$1'.",
	'replacetext_nomove' => 'Nije nađena nijedna stranica čiji naslov sadrži „$1“.',
	'replacetext_return' => 'Nazad na obrazac.',
	'replacetext_continue' => 'Nastavi',
	'replacetext_editsummary' => "Zamena teksta - '$1' u '$2'",
	'right-replacetext' => 'zamenjivanje niski na celom vikiju',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author M.M.S.
 * @author Najami
 * @author Per
 * @author Rotsee
 */
$messages['sv'] = array(
	'replacetext' => 'Ersätt text',
	'replacetext-desc' => 'Låter administratörer [[Special:ReplaceText|ersätta text]] på alla innehållssidor på en wiki',
	'replacetext_docu' => 'För att ersätta en textträng med en annan på alla datasidor på den här wikin kan du skriva in de två texterna här och klicka på "Ersätt". Du kommer sedan att visas på en lista över sidor som innehåller söktexten, och du kan välja en av dom som du vill ersätta. Ditt namn kommer visas i sidhistoriken som den som är ansvarig för ändringarna.',
	'replacetext_originaltext' => 'Originaltext:',
	'replacetext_replacementtext' => 'Ersättningstext:',
	'replacetext_optionalfilters' => 'Valbara filter:',
	'replacetext_categorysearch' => 'Ersätt endast i kategori:',
	'replacetext_prefixsearch' => 'Ersätt endast sidor med prefixet:',
	'replacetext_editpages' => 'Ersätt text i sidinnehåll',
	'replacetext_movepages' => 'Ersätt text i sidtitlar när det är möjligt',
	'replacetext_givetarget' => 'Du måste ange en textsträng som ska ersättas.',
	'replacetext_nonamespace' => 'Du måste ange minst en namnrymd.',
	'replacetext_editormove' => 'Du måste ange minst ett alternativ för ersättning.',
	'replacetext_choosepagesforedit' => "Var god ange för {{PLURAL:$3|vilken sida|vilka sidor}} du vill ersätta '$1' med '$2':",
	'replacetext_choosepagesformove' => "Ersätt '$1' med '$2' i {{PLURAL:$3|namnet på den följande sidan|namnen på de följande sidorna}}:",
	'replacetext_cannotmove' => '{{PLURAL:$1|Den följande sidan|De följande sidorna}} kan inte flyttas:',
	'replacetext_formovedpages' => 'För flyttade sidor:',
	'replacetext_savemovedpages' => 'Spara de gamla artikeltitlarna som omdirigeringar till de nya',
	'replacetext_watchmovedpages' => 'Bevaka de här sidorna',
	'replacetext_invertselections' => 'Invertera val',
	'replacetext_replace' => 'Ersätt',
	'replacetext_success' => "'$1' kommer att ersättas med '$2' på $3 {{PLURAL:$3|sida|sidor}}.",
	'replacetext_noreplacement' => 'Inga sidor hittades med strängen "$1".',
	'replacetext_nomove' => 'Inga sidor hittades som innehåller "$1" i titeln.',
	'replacetext_nosuchcategory' => 'Det exisgterar inte någon kategori med namnet "$1".',
	'replacetext_return' => 'Tillbaka till formuläret.',
	'replacetext_warning' => '\'\'\'Varning:\'\'\' Det finns {{PLURAL:$1|$1 sida|$1 sidor}} som redan har ersättningssträngen "$2". Om du gör den här ersättningen kommer du inte kunna separera dina ersättningar från den här texten.',
	'replacetext_blankwarning' => 'Eftersom ersättningstexten är tom kommer den här handlingen inte kunna upphävas; vill du fortsätta?',
	'replacetext_continue' => 'Fortsätt',
	'replacetext_editsummary' => 'Textersättning - "$1" till "$2"',
	'right-replacetext' => 'Genomför textersättningar på hela wikin',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'replacetext_originaltext' => 'అసలు పాఠ్యం:',
	'replacetext_replacementtext' => 'మార్పిడి పాఠ్యం:',
	'replacetext_optionalfilters' => 'ఐచ్చిక వడపోతలు:',
	'replacetext_continue' => 'కొనసాగించు',
);

/** Thai (ไทย)
 * @author Ans
 * @author Passawuth
 */
$messages['th'] = array(
	'replacetext_originaltext' => 'ข้อความดั้งเดิม:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'replacetext' => 'Palitan ang teksto',
	'replacetext-desc' => 'Nagbibigay ng isang [[Special:ReplaceText|natatanging pahina]] upang mapahintulutan ang mga tagapangasiwa na makagawa ng isang baging na pandaidigang hanapin-at-palitan sa ibabaw ng lahat ng mga pahina ng nilalaman ng isang wiki',
	'replacetext_docu' => "Upang mapalitan ang isang bagting ng teksto ng iba pang nasa kahabaan ng lahat ng pangkaraniwang mga pahinang nasa ibabaw ng wiking ito, ipasok ang dalawang piraso ng teksto dito at pindutin pagkatapos ang 'Magpatuloy'. Susunod na ipapakita naman sa iyo ang isang talaan ng mga pahinang naglalaman ng teksto ng paghanap, at mapipili mo ang mga maaari mong ipamalit dito. Lilitaw ang pangalan mo sa mga kasaysayan ng pahina bilang tagagamit na umaako sa anumang mga pagbabago.",
	'replacetext_originaltext' => 'Orihinal na teksto:',
	'replacetext_replacementtext' => 'Pamalit na teksto:',
	'replacetext_useregex' => 'Gumamit ng pangkaraniwang mga paglalahad',
	'replacetext_regexdocu' => '(Halimbawa: mga halaga ng "isang (.*) c" para sa "Orihinal na teksto" at "ac $1 "para sa "Kapalit na teksto" na papalit sa "abc" na may "acb".)',
	'replacetext_optionalfilters' => 'Mga pansalang maaaring wala:',
	'replacetext_categorysearch' => 'Palitan lamang sa loob ng kategorya:',
	'replacetext_prefixsearch' => 'Palitan lamang sa loob ng mga pahina may unlapi:',
	'replacetext_editpages' => 'Palitan ang teksto sa loob ng mga nilalaman ng pahina',
	'replacetext_movepages' => 'Palitan ang tekstong nasa loob ng mga pamagat na pampahina, kapag maaari',
	'replacetext_givetarget' => 'Dapat mong tukuyin ang bagting na papalitan.',
	'replacetext_nonamespace' => 'Dapat kang pumili ng kahit na isang puwang na pampangalan.',
	'replacetext_editormove' => 'Dapat kang pumili ng kahit na isa sa mga mapipiling pagpapalit.',
	'replacetext_choosepagesforedit' => "Pakipili ang {{PLURAL:$3|pahina|mga pahina}} kung saan mo naisa na palitan ang '$1' ng '$2':",
	'replacetext_choosepagesformove' => 'Palitan ang "$1" ng "$2"  sa loob ng {{PLURAL:$3|pangalan ng sumusunod na pahina|mga pangalan ng sumusunod na mga pahina}}:',
	'replacetext_cannotmove' => 'Hindi maililipat ang sumusunod na {{PLURAL:$1|pahina|mga pahina}}:',
	'replacetext_formovedpages' => 'Para sa mga pahinang inilipat:',
	'replacetext_savemovedpages' => 'Sagipin ang lumang mga pamagat bilang mga pampunta patungo sa bagong mga pamagat',
	'replacetext_watchmovedpages' => 'Bantayan ang mga pahinang ito',
	'replacetext_invertselections' => 'Baligtarin ang mga pagpipilian',
	'replacetext_replace' => 'Palitan',
	'replacetext_success' => "Ang '$1' ay mapapalitan ng '$2' sa loob ng $3 {{PLURAL:$3|pahina|mga pahina}}.",
	'replacetext_noreplacement' => "Walang natagpuang mga pahinang naglalaman ng bagting na '$1'.",
	'replacetext_nomove' => 'Walang natagpuang mga pahina na naglalaman ang pamagat ng "$1".',
	'replacetext_nosuchcategory' => 'Walang kategoryang umiiral na may pangalang "$1".',
	'replacetext_return' => 'Bumalik sa pormularyo.',
	'replacetext_warning' => "'''Babala:''' Mayroong {{PLURAL:$1|$1 pahinang naglalaman na|$1 mga pahinang naglalaman na}} ng pamalit na bagting, '$2'.
Kapag ginawa mo ang pagpapalit na ito hindi mo na maihihiwalay ang mga pamalit mo mula sa mga bagting na ito.",
	'replacetext_blankwarning' => 'Dahil sa walang laman ang bagting ng pamalit, hindi na maibabalik pa sa dati ang gawaing ito/
Naisa mo bang magpatuloy pa?',
	'replacetext_continue' => 'Magpatuloy',
	'replacetext_editsummary' => "Palitan ang tekso - '$1' papunta sa '$2'",
	'right-replacetext' => 'Gumawa ng pagpapalit ng bagting sa buong wiki',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'replacetext' => 'Metni değiştir',
	'replacetext-desc' => 'Yöneticilere, bir vikideki tüm içerik sayfalarında bir küresel dizi bul-ve-değiştir yapmalarına izin veren bir [[Special:ReplaceText|özel sayfa]] sağlar',
	'replacetext_docu' => "Bu viki üzerindeki tüm sayfalarda bir metin dizgisini diğer bir dizgi ile değiştirmek için, iki metin parçasını girin ve 'Devam' seçeneğini seçin.
Sonrasında size arama metnini gösteren sayfaların bir listesi gösterilecek ve değiştirmek istediklerinizi seçebileceksiniz.
Adınız, değişiklikleri gerçekleştiren kullanıcı olarak sayfa geçmişlerinde görülecek.",
	'replacetext_originaltext' => 'Orijinal metin:',
	'replacetext_replacementtext' => 'Yerine konulacak metin:',
	'replacetext_optionalfilters' => 'Opsiyonel filtreler',
	'replacetext_categorysearch' => 'Sadece kategoride değiştir:',
	'replacetext_prefixsearch' => 'Sadece şu öneke sahip sayfalarda değiştir:',
	'replacetext_editpages' => 'Sayfa içeriklerindeki metinleri değiştir',
	'replacetext_movepages' => 'Sayfa başlıklarında metni değiştir, mümkün olduğunda',
	'replacetext_givetarget' => 'Değiştirilecek dizgiyi belirtmelisiniz.',
	'replacetext_nonamespace' => 'En az bir ad alanı seçmelisiniz.',
	'replacetext_editormove' => 'Değiştirme seçeneklerinden en az birini seçmelisiniz.',
	'replacetext_choosepagesforedit' => "Lütfen, '$1' yerine '$2' koymak istediğiniz {{PLURAL:$3|sayfayı|sayfaları}} seçin:",
	'replacetext_choosepagesformove' => 'Aşağıdaki {{PLURAL:$3|sayfanın adındaki|sayfaların adlarındaki}} "$1" bölümünü "$2" ile değiştir:',
	'replacetext_cannotmove' => 'Aşağıdaki {{PLURAL:$1|sayfa|sayfalar}} taşınamaz:',
	'replacetext_formovedpages' => 'Taşınan sayfalar için:',
	'replacetext_savemovedpages' => 'Eski başlıkları yeni başlıklara yönlendirmeler olarak sakla',
	'replacetext_watchmovedpages' => 'Bu sayfaları izle',
	'replacetext_invertselections' => 'Seçimleri ters çevir',
	'replacetext_replace' => 'Değiştir',
	'replacetext_success' => '$3 {{PLURAL:$3|sayfada|sayfada}} "$1" ile "$2" değiştirildi.',
	'replacetext_noreplacement' => '"$1" dizgisini içeren herhangi bir sayfa bulunamadı.',
	'replacetext_nomove' => '"$1" ibaresini içeren isimli sayfa bulunamadı.',
	'replacetext_nosuchcategory' => '"$1" adında bir kategori mevcut değil.',
	'replacetext_return' => 'Forma dön.',
	'replacetext_warning' => '"$2" değiştirme dizgisini halihazırda içeren {{PLURAL:$1|$1 sayfa|$1 sayfa}} mevcut.
Bu değişikliği yaparsanız değişikliklerinizi bu dizgilerden ayırma imkanınız olmayacak.
Değiştirme işlemine devam etmek ister misiniz?',
	'replacetext_blankwarning' => 'Değiştirme dizgisi boş olduğu için bu işlem geri alınamayacak.
Devam etmek istiyor musunuz?',
	'replacetext_continue' => 'Devam',
	'replacetext_editsummary' => 'Metin değiştir - "$1" yerine "$2"',
	'right-replacetext' => 'Vikinin tamamında dizgileri değiştirir',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'replacetext' => 'Заміна тексту',
	'replacetext-desc' => 'Додає [[Special:ReplaceText|спеціальну сторінку]], що дозволяє адміністраторам робити глобальну заміну зазначеного тексту на всіх звичайних сторінках вікі',
	'replacetext_docu' => "Для того, щоб замінити один текст на іншій на всіх сторінках вікі, вам треба ввести тут два фрагменти тексту і натиснути кнопку «Продовжити». Після цього вам буде запропонований список всіх сторінок, що містять замінюваний текст, і ви зможете вибрати ті, в яких потрібно виконати заміни. В історії редагувань сторінок, в яких відбудеться заміна тексту, буде вказане ваше ім'я.",
	'replacetext_originaltext' => 'Оригінальний текст:',
	'replacetext_replacementtext' => 'Замінити на:',
	'replacetext_optionalfilters' => 'Додаткові фільтри:',
	'replacetext_categorysearch' => 'Замінити тільки в категорії:',
	'replacetext_prefixsearch' => 'Замінити тільки на сторінках, чиї назви починаються на:',
	'replacetext_editpages' => 'Заміна тексту у вмісті сторінки',
	'replacetext_movepages' => 'Замінити текст у назвах сторінок, якщо можливо',
	'replacetext_givetarget' => 'Ви повинні вказати рядок, який потрібно замінити.',
	'replacetext_nonamespace' => 'Ви повинні вибрати принаймні один простір назв.',
	'replacetext_editormove' => 'Ви повинні вибрати принаймні один варіант заміни.',
	'replacetext_choosepagesforedit' => 'Будь ласка, виберіть {{PLURAL:$3|сторінку, в якій|сторінки, в яких}} ви хочете здійснити заміну «$1» на «$2»:',
	'replacetext_choosepagesformove' => 'Замінити «$1» на «$2» в {{PLURAL:$3|назві наступної сторінки|назвах наступних сторінок}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Наступна сторінка не може бути перейменована|Наступні сторінки не можуть бути перейменовані}}:',
	'replacetext_formovedpages' => 'Для перейменованих сторінок:',
	'replacetext_savemovedpages' => 'Зберегти старі назви як перенаправлення на нові',
	'replacetext_watchmovedpages' => 'Спостерігати за цими сторінками',
	'replacetext_invertselections' => 'Інвертувати виділення',
	'replacetext_replace' => 'Замінити',
	'replacetext_success' => '«$1» буде замінений на «$2» на $3 {{PLURAL:$3|сторінці|сторінках|сторінках}}.',
	'replacetext_continue' => 'Продовжити',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'replacetext_originaltext' => 'Originaline tekst',
	'replacetext_watchmovedpages' => 'Kacelta nened lehtpoled',
	'replacetext_return' => 'Pörtas formannoks.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'replacetext' => 'Thay thế văn bản',
	'replacetext-desc' => 'Cung cấp một [[Special:ReplaceText|trang đặc biệt]] để cho phép bảo quản viên thực hiện tìm-kiếm-và-thay-thế thống nhất trên tất cả các trang có nội dung tại một wiki',
	'replacetext_docu' => "Để thay thế một chuỗi ký tự bằng một chuỗi khác trên toàn bộ các trang thông thường tại wiki này, hãy gõ vào hai đoạn văn bản ở đây và sau đó nhấn 'Tiếp tục'. Khi đó bạn thấy một danh sách các trang có chứa đoạn ký tự được tìm, và bạn có thể chọn những trang mà bạn muốn thay thế. Tên của bạn sẽ xuất hiện trong lịch sử trang như một thành viên chịu trách nhiệm về bất kỳ thay đổi nào.",
	'replacetext_originaltext' => 'Văn bản nguồn:',
	'replacetext_replacementtext' => 'Văn bản thay thế:',
	'replacetext_useregex' => 'Sử dụng biểu thức chính quy',
	'replacetext_regexdocu' => '(Ví dụ: Văn bản gốc “a(.*)c” và văn bản thay thế “ac$1” sẽ thay thế “abc” bằng “acb”.)',
	'replacetext_optionalfilters' => 'Bộ lọc tùy ý:',
	'replacetext_categorysearch' => 'Chỉ thay trong thể loại:',
	'replacetext_prefixsearch' => 'Chỉ thay trong những trang với tiền tố:',
	'replacetext_editpages' => 'Thay thế văn bản trong nội dung trang',
	'replacetext_movepages' => 'Thay văn bản trong tên trang nếu có thể',
	'replacetext_givetarget' => 'Bạn cần phải định rõ văn bản để thay thế.',
	'replacetext_nonamespace' => 'Cần phải chọn ít nhất một không gian tên.',
	'replacetext_editormove' => 'Bạn cần phải chọn ít nhất một trong những tùy chọn thay thế.',
	'replacetext_choosepagesforedit' => 'Thay ‘$1’ bằng ‘$2’ trong nội dung của {{PLURAL:$3|trang|những trang}} sau:',
	'replacetext_choosepagesformove' => 'Thay “$1” bằng “$2” trong tên của {{PLURAL:$3|trang|các trang}} sau:',
	'replacetext_cannotmove' => 'Không có thể di chuyển {{PLURAL:$1|trang|các trang}} sau:',
	'replacetext_formovedpages' => 'Đối với trang đã di chuyển:',
	'replacetext_savemovedpages' => 'Lưu các tên cũ để đổi hướng đến tên mới',
	'replacetext_watchmovedpages' => 'Theo dõi các trang này',
	'replacetext_invertselections' => 'Đảo ngược các lựa chọn',
	'replacetext_replace' => 'Thay thế',
	'replacetext_success' => '“$1” sẽ được thay bằng “$2” trong $3 {{PLURAL:$3|trang|trang}}.',
	'replacetext_noreplacement' => 'Không tìm thấy trang nào có chứa chuỗi ‘$1’.',
	'replacetext_nomove' => 'Không tìm thấy trang nào với “$1” trong tên.',
	'replacetext_nosuchcategory' => 'Không có thể loại với tên “$1”.',
	'replacetext_return' => 'Trở lại biểu mẫu.',
	'replacetext_warning' => "'''Cảnh báo:''' {{PLURAL:$1|Một trang|$1 trang}} trong lựa chọn đã có chứa chuỗi thay thế, “$2”. Nếu bạn thực hiện thay thế này bạn sẽ không thể phân biệt sự thay thế của bạn với những chuỗi này.",
	'replacetext_blankwarning' => 'Vì chuỗi thay thế là khoảng trắng, tác vụ này sẽ không thể hồi lại được; tiếp tục?',
	'replacetext_continue' => 'Tiếp tục',
	'replacetext_editsummary' => 'Thay thế văn bản - ‘$1’ thành ‘$2’',
	'right-replacetext' => 'Thay thế chuỗi ở tất cả wiki',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'replacetext' => 'Plaädön vödemi',
	'replacetext-desc' => 'Jafön [[Special:ReplaceText|padi patik]] ad mögükön guvanes sukami e plaädami valöpikis, ninädapadis valik vüka seimik tefölis.',
	'replacetext_originaltext' => 'Rigavödem:',
	'replacetext_replacementtext' => 'Plaädamavödem:',
	'replacetext_movepages' => 'Plaädön vödemi i pö padatiäds, ven mögos',
	'replacetext_choosepagesforedit' => 'Välolös {{PLURAL:$3|padi, su kel|padis, su kels}} vilol plaädön vödemi: „$1“ me vödem: „$2“:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Pad|Pads}} fovik no kanons patopätükön:',
	'replacetext_replace' => 'Plaädön',
	'replacetext_success' => 'Vödem: „$1“ poplaädon dub vödem: „$2“ su {{PLURAL:$3|pad bal|pads $3}}.',
	'replacetext_noreplacement' => 'Pads nonik labü vödem: „$1“ petuvons.',
	'replacetext_blankwarning' => 'Bi plaädamavödem binon vägik, dun at no kanon pasädunön. Vilol-li fümiko ledunön plaädami?',
	'replacetext_continue' => 'Ledunön',
	'replacetext_editsummary' => 'Vödemiplaädam - „$1“ ad „$2“',
	'right-replacetext' => 'Ledunön vödemiplaädami in vük lölik',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author Onecountry
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'replacetext' => '替换文字',
	'replacetext-desc' => '提供[[Special:ReplaceText|特殊页面]]让管理员可以对wiki的所有页面内容执行查找和替换。',
	'replacetext_docu' => '要替换此维基内所有页面文字的字串，请将“原文字”及“替换文字”分别填入以下两个栏位之中，然后按“继续”。接下来会列出所有含原文字的页面供你选择在哪些页面进行替换。页面改动历史会显示你是进行此次改动的用户。',
	'replacetext_originaltext' => '原文字',
	'replacetext_replacementtext' => '替换文字',
	'replacetext_optionalfilters' => '可选过滤器：',
	'replacetext_categorysearch' => '仅替换该分类中的页面：',
	'replacetext_prefixsearch' => '仅替换带该前缀页面：',
	'replacetext_editpages' => '仅在页面内容中替换',
	'replacetext_movepages' => '可能的话，在页面名称中替换。',
	'replacetext_givetarget' => '必须指定查找的字符串',
	'replacetext_nonamespace' => '您必须选择至少一个名字空间。',
	'replacetext_editormove' => '必须选择至少一个替换选项。',
	'replacetext_choosepagesforedit' => '请选择想将“$1”替换成“$2”的{{PLURAL:$3|页面|页面}}。',
	'replacetext_choosepagesformove' => '将{{PLURAL:$3|以下页面|以下页面}}中的“$1”替换为“$2”：',
	'replacetext_cannotmove' => '无法移动以下{{PLURAL:$1|页面|页面}}：',
	'replacetext_formovedpages' => '对以下页面进行了移动：',
	'replacetext_savemovedpages' => '重定向至新标题时保留旧标题。',
	'replacetext_watchmovedpages' => '监视这些页面',
	'replacetext_invertselections' => '反选',
	'replacetext_replace' => '替换',
	'replacetext_success' => '已在$3个页面中将“$1”替换为“$2”。',
	'replacetext_noreplacement' => '无任何页面含有“$1”。',
	'replacetext_nomove' => '无任何页面标题含有“$1”。',
	'replacetext_nosuchcategory' => '无任何分类名为“$1”。',
	'replacetext_return' => '返回表单。',
	'replacetext_warning' => '有$1个页面已经包含文字「$2」。如果您执行了替换作业，被替代的文字会跟它们混在一起，变得难以分开原来的文字和被替代的文字。要继续执行替换作业吗？',
	'replacetext_blankwarning' => "'''警告：'''因为替换字串为空，这将导致操作无法复原！您要继续吗？",
	'replacetext_continue' => '继续',
	'replacetext_editsummary' => '替换文字 - 「$1」替换为「$2」',
	'right-replacetext' => '对整个维基进行文字替换。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Roc michael
 * @author Sheepy
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'replacetext' => '替換文字',
	'replacetext-desc' => '提供[[Special:ReplaceText|特殊頁面]]以利管理員以「尋找及替換」的方式更改所有文章頁面內的內容。',
	'replacetext_docu' => '要替換此維基內所有頁面文字的字串，請將「原始文字」及「替換的文字」分別填入下面的兩個欄位之中，然後按「繼續」。接下來所有內含原始文字的頁面會被列出，你可以選擇要在那一些頁面進行替換。頁面的改動歷史會顯示你是負責進行這次改動的用戶。',
	'replacetext_originaltext' => '原文字',
	'replacetext_replacementtext' => '替換文字',
	'replacetext_optionalfilters' => '可選過濾器：',
	'replacetext_categorysearch' => '僅當頁面在該分類中時替換：',
	'replacetext_prefixsearch' => '僅當頁面帶有該前綴時替換：',
	'replacetext_editpages' => '僅在頁面內容當中進行替換',
	'replacetext_movepages' => '如果可以的話，也替換頁面名稱的字串。',
	'replacetext_givetarget' => '必須指定尋找的字符串',
	'replacetext_nonamespace' => '您必須選擇最少一個名字空間。',
	'replacetext_editormove' => '必須選擇至少一個替換選項。',
	'replacetext_choosepagesforedit' => '請選擇想將“$1”替換成“$2”的{{PLURAL:$3|頁面|頁面}}。',
	'replacetext_choosepagesformove' => '將{{PLURAL:$3|以下頁面|以下頁面}}中的“$1”替換為“$2”：',
	'replacetext_cannotmove' => '無法移動以下{{PLURAL:$1|頁面|頁面}}：',
	'replacetext_formovedpages' => '對以下頁面進行了移動：',
	'replacetext_savemovedpages' => '重定向至新標題時保留舊標題。',
	'replacetext_watchmovedpages' => '監視這些頁面',
	'replacetext_invertselections' => '倒選',
	'replacetext_replace' => '替換',
	'replacetext_success' => '已將$3個頁面內的「$1」替換為「$2」。',
	'replacetext_noreplacement' => '因無任何頁面內含有「$1」。',
	'replacetext_nomove' => '無任何頁面標題含有“$1”。',
	'replacetext_nosuchcategory' => '無任何分類名為“$1”。',
	'replacetext_return' => '返回表格。',
	'replacetext_warning' => '有$1個頁面已經包含文字「$2」。如果您執行了替換作業，被替代的文字會跟它們混在一起，變得難以分開原來的文字和被替代的文字。要繼續執行替換作業嗎？',
	'replacetext_blankwarning' => '因為替換字串是空白的，這將造成難以復原的結果！您要繼續嗎？',
	'replacetext_continue' => '繼續',
	'replacetext_editsummary' => '替換文字 - 「$1」替換為「$2」',
	'right-replacetext' => '對整個維基進行文字替換。',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'replacetext' => '取代文字',
	'replacetext-desc' => '提供[[Special:ReplaceText|特殊頁面]]以利管理員以「尋找及取代」的方式更改所有文章頁面內的內容。',
	'replacetext_docu' => '取代儲存在此Wiki系統內所有頁面上的文字字串，請將「原始文字」及「取代的文字」分別填入下面的兩個欄位之中，按下「取代按鈕」後生效，您所作的修改會顯示在「歷史」頁面上，以對您自己編輯行為負責。',
	'replacetext_replace' => '取代',
	'replacetext_noreplacement' => '因無任何頁面內含有「$1」。',
	'replacetext_blankwarning' => '因為取代字串是空白的，這將造成難以復原的結果！您要繼續嗎？',
	'replacetext_continue' => '繼續',
	'replacetext_editsummary' => '取代文字 - 「$1」 取代為 「$2」',
);

