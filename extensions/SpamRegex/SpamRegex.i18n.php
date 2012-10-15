<?php
/**
 * Internationalisation file for SpamRegex extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 */
$messages['en'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => '[[Special:SpamRegex|Filter]] out unwanted phrases in edited pages, based on regular expressions',
	'spamregex-error-unblocking' => 'Error unblocking "$1". Probably there is no such pattern.',
	'spamregex-summary' => "The text was found in the page's summary.",
	'spamregex-intro' => 'Use this form to effectively block expressions from saving into a page\'s text.
If the text contains the given expression, change would not be saved and an explanation will be displayed to user that tried to save the page.
Caution advised, expressions should not be too short or too common.',
	'spamregex-page-title' => 'Spam regex unwanted expressions block',
	'spamregex-currently-blocked' => "'''Currently blocked phrases:'''",
	'spamregex-move' => 'The reason you entered contained a blocked phrase.',
	'spamregex-no-currently-blocked' => "'''There are no blocked phrases.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 remove]) added by $5 on $6 at $7",
	'spamregex-page-title-1' => 'Block phrase using regular expressions',
	'spamregex-unblock-success' => 'Unblock succedeed',
	'spamregex-unblock-message' => "Phrase '''$1''' has been unblocked from editing.",
	'spamregex-page-title-2' => 'Block phrases from saving using regular expressions',
	'spamregex-block-success' => 'Block succedeed',
	'spamregex-block-message' => "Phrase '''$1''' has been blocked.",
	'spamregex-warning-1' => 'Give a phrase to block.',
	'spamregex-error-1' => 'Invalid regular expression.',
	'spamregex-warning-2' => 'Please check at least one blocking mode.',
	'spamregex-already-blocked' => '"$1" is already blocked',
	'spamregex-phrase-block' => 'Phrase to block:',
	'spamregex-phrase-block-text' => 'block phrase in page text',
	'spamregex-phrase-block-summary' => 'block phrase in summary',
	'spamregex-block-submit' => 'Block&nbsp;this&nbsp;phrase',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Summary)',
	'right-spamregex' => 'Block spam phrases through [[Special:SpamRegex]]',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'spamregex-desc' => '{{desc}}',
	'spamregex-log' => 'Parameters:
* $1 is spam text
* $2 is a description
* $3 is an unblock link
* $4 is the IP address to be unblocked
* $5 is a username
* $6 is a date
* $7 is a time',
	'spamregex-already-blocked' => '{{Identical|$1 is already blocked}}',
	'spamregex-text' => '{{Identical|Text}}',
	'spamregex-summary-log' => '{{Identical|Summary}}',
	'right-spamregex' => '{{doc-right|spamregex}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'spamregex-summary-log' => '(Fakakatoakatoa)',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'spamregex-already-blocked' => '"$1" is reeds geblok',
	'spamregex-text' => '(Teks)',
	'spamregex-summary-log' => '(Opsomming)',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'spamregex-text' => '(ጽሕፈት)',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'spamregex-already-blocked' => '"$1" ya yera bloqueyato',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'spamregex' => 'تعبير منتظم لسبام',
	'spamregex-desc' => '[[Special:SpamRegex|مُرشّح]] العبارات غير المرغوب فيها في الصفحات المعدلة، بالاعتماد على التعبيرات المنتظمة',
	'spamregex-error-unblocking' => 'خطأ رفع منع "$1". على الأرجح لا يوجد نمط كهذا.',
	'spamregex-summary' => 'النص تم العثور عليه في ملخص الصفحة.',
	'spamregex-intro' => 'استخدم هذه الاستمارة لمنع تعبيرات من الحفظ في نص صفحة بكفاءة.
لو أن النص يحتوي على التعبير المعطى، لن يتم حفظ التغيير وسيتم عرض تفسير للمستخدم الذي حاول حفظ الصفحة.
ينصح بالحذر، التعبيرات لا ينبغي أن تكون قصيرة جدا أو شائعة جدا.',
	'spamregex-page-title' => 'منع تعبير منتظم لسبام التعبيرات غير المرغوب فيها',
	'spamregex-currently-blocked' => "'''العبارات الممنوعة حاليا:'''",
	'spamregex-move' => 'السبب الذي أدخلته يحتوي على عبارة ممنوعة.',
	'spamregex-no-currently-blocked' => "'''لا توجد عبارات ممنوعة.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 إزالة]) أضيف بواسطة $5 في $6 الساعة $7",
	'spamregex-page-title-1' => 'منع عبارة باستخدام التعبيرات المنتظمة',
	'spamregex-unblock-success' => 'رفع المنع نجح',
	'spamregex-unblock-message' => "العبارة '''$1''' تم رفع المنع عنها ضد التحرير.",
	'spamregex-page-title-2' => 'منع العبارات من الحفظ باستخدام التعبيرات المنتظمة',
	'spamregex-block-success' => 'المنع نجح',
	'spamregex-block-message' => "العبارة '''$1''' تم منعها.",
	'spamregex-warning-1' => 'أعط عبارة للمنع.',
	'spamregex-error-1' => 'تعبير منتظم غير صحيح.',
	'spamregex-warning-2' => 'من فضلك علم على نمط منع واحد على الأقل.',
	'spamregex-already-blocked' => '"$1" ممنوعة بالفعل',
	'spamregex-phrase-block' => 'العبارة للمنع:',
	'spamregex-phrase-block-text' => 'منع عبارة في نص صفحة',
	'spamregex-phrase-block-summary' => 'منع عبارة في ملخص',
	'spamregex-block-submit' => 'منع&nbsp;هذه&nbsp;العبارة',
	'spamregex-text' => '(نص)',
	'spamregex-summary-log' => '(ملخص)',
	'right-spamregex' => 'منع عبارات السبام من خلال [[Special:SpamRegex]]',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 ܠܚܝ]) ܐܬܬܘܣܦ ܒܝܕ $5 ܒ$6 ܫܥܬܐ $7",
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'spamregex' => 'تعبير منتظم لسبام',
	'spamregex-desc' => '[[Special:SpamRegex|فلتر]] العبارات غير المرغوب فيها فى الصفحات المعدلة، بالاعتماد على التعبيرات المنتظمة',
	'spamregex-error-unblocking' => 'خطأ رفع منع "$1". على الأرجح لا يوجد نمط كهذا.',
	'spamregex-summary' => 'النص تم العثور عليه فى ملخص الصفحة.',
	'spamregex-intro' => 'استخدم الاستمارة دى لمنع تعبيرات من الحفظ فى نص صفحة بكفاءة.
لو أن النص يحتوى على التعبير المعطى، مش هايتحفظ التغيير و هايتعرض تفسير لليوزر اللى حاول حفظ الصفحة.
ينصح بالحذر، التعبيرات لازم ماتكونش قصيرة جدا أو شائعة جدا.',
	'spamregex-page-title' => 'منع تعبير منتظم لسبام التعبيرات غير المرغوب فيها',
	'spamregex-currently-blocked' => "'''العبارات الممنوعة حاليا:'''",
	'spamregex-move' => 'السبب الذى أدخلته يحتوى على عبارة ممنوعة.',
	'spamregex-no-currently-blocked' => "'''لا توجد عبارات ممنوعة.'''",
	'spamregex-page-title-1' => 'منع عبارة باستخدام التعبيرات المنتظمة',
	'spamregex-unblock-success' => 'رفع المنع نجح',
	'spamregex-unblock-message' => "العبارة '''$1''' تم رفع المنع عنها ضد التحرير.",
	'spamregex-page-title-2' => 'منع العبارات من الحفظ باستخدام التعبيرات المنتظمة',
	'spamregex-block-success' => 'المنع نجح',
	'spamregex-block-message' => "العبارة '''$1''' تم منعها.",
	'spamregex-warning-1' => 'أعط عبارة للمنع.',
	'spamregex-error-1' => 'تعبير منتظم غير صحيح.',
	'spamregex-warning-2' => 'من فضلك علم على نمط منع واحد على الأقل.',
	'spamregex-already-blocked' => '"$1" ممنوعة بالفعل',
	'spamregex-phrase-block' => 'العبارة للمنع:',
	'spamregex-phrase-block-text' => 'منع عبارة فى نص صفحة',
	'spamregex-phrase-block-summary' => 'منع عبارة فى ملخص',
	'spamregex-block-submit' => 'منع&nbsp;هذه&nbsp;العبارة',
	'spamregex-text' => '(نص)',
	'spamregex-summary-log' => '(ملخص)',
	'right-spamregex' => 'منع عبارات السبام من خلال [[Special:SpamRegex]]',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'spamregex-text' => '(Mətn)',
	'spamregex-summary-log' => '(Xülasə)',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'spamregex-text' => '(Тэкст)',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'spamregex' => 'Рэгулярныя выразы для барацьбы са спамам',
	'spamregex-desc' => '[[Special:SpamRegex|Фільтраваньне]] нежаданых фразаў на рэдагуемых старонках з выкарыстаньнем рэгулярных выразаў',
	'spamregex-error-unblocking' => 'Памылка разблякаваньня «$1». Верагодна не існуе такога ўзору.',
	'spamregex-summary' => 'Тэкст быў знойдзены ў кароткім апісаньні зьменаў старонкі.',
	'spamregex-intro' => 'Карыстайцеся гэтай формай, каб эфэктыўна блякаваць фразы ад захаваньня ў тэксьце старонкі.
Калі тэкст утрымлівае пададзеныя выразы, зьмены ня будуць захаваныя і будзе паказанае тлумачэньне для ўдзельніка, які спрабаваў захаваць старонку.
Памятайце, што выразы не павінны быць занадта кароткімі ці агульна ўжываемымі.',
	'spamregex-page-title' => 'Блякаваньне спама з дапамогай непажаданых фразаў',
	'spamregex-currently-blocked' => "'''Цяперашнія выразы для блякаваньня:'''",
	'spamregex-move' => 'Прычына ў тым, што Вы ўвялі заблякаваную фразу.',
	'spamregex-no-currently-blocked' => "'''Няма заблякаваных фразаў.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 выдаліць]) дададзены $5 ў $6 $7",
	'spamregex-page-title-1' => 'Блякаваньне фразы з дапамогай рэгулярных выразаў',
	'spamregex-unblock-success' => 'Разблякавана',
	'spamregex-unblock-message' => "Фраза '''$1''' была разблякаваная для рэдагаваньня.",
	'spamregex-page-title-2' => 'Блякаваньне фразаў ад захаваньня з дапамогай рэгулярных выразаў',
	'spamregex-block-success' => 'Заблякавана',
	'spamregex-block-message' => "Фраза '''$1''' была заблякаваная.",
	'spamregex-warning-1' => 'Падайце фразу для блякаваньня.',
	'spamregex-error-1' => 'Няслушны рэгулярны выраз.',
	'spamregex-warning-2' => 'Калі ласка, праверце дзеяньне блякаваньня хаця б адзін раз.',
	'spamregex-already-blocked' => '«$1» ужо заблякаваны',
	'spamregex-phrase-block' => 'Фраза да блякаваньня:',
	'spamregex-phrase-block-text' => 'блякаваньне фразы ў тэксьце старонкі',
	'spamregex-phrase-block-summary' => 'блякаваньне фразы ў кароткім апісаньні зьменаў старонкі',
	'spamregex-block-submit' => 'Блякаваньне&nbsp;гэтага&nbsp;выразу',
	'spamregex-text' => '(Тэкст)',
	'spamregex-summary-log' => '(Кароткае апісаньне зьменаў старонкі)',
	'right-spamregex' => 'Блякаваньне спамавых фразаў з дапамогай [[Special:SpamRegex]]',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'spamregex-desc' => '[[Special:SpamRegex|Филтриране]] на нежелани фрази в редактираните страници с помощта на регулярни изрази',
	'spamregex-summary' => 'Текстът е намерен в резюмето на страницата.',
	'spamregex-currently-blocked' => "'''Текущо блокирани фрази:'''",
	'spamregex-move' => 'Въведената причина съдържа блокирана фраза.',
	'spamregex-no-currently-blocked' => "'''Няма блокирани фрази.'''",
	'spamregex-page-title-1' => 'Блокиране на фрази чрез регулярни изрази',
	'spamregex-unblock-success' => 'Успешно разблокиране',
	'spamregex-unblock-message' => "Фразата '''$1''' беше отблокирана за редактиране.",
	'spamregex-page-title-2' => 'Блокиране на съхранението на фраза посредством регулярни изрази',
	'spamregex-block-success' => 'Успешно блокиране',
	'spamregex-block-message' => "Фразата '''$1''' беше блокирана.",
	'spamregex-error-1' => 'Невалиден регулярен израз.',
	'spamregex-already-blocked' => '„$1“ е вече блокиран',
	'spamregex-phrase-block' => 'Фраза за блокиране:',
	'spamregex-phrase-block-text' => 'блокиране на фраза в текста на статията',
	'spamregex-phrase-block-summary' => 'блокиране на фраза в резюмето',
	'spamregex-block-submit' => 'Блокиране&nbsp;на&nbsp;фразата',
	'spamregex-text' => '(Текст)',
	'spamregex-summary-log' => '(Резюме)',
	'right-spamregex' => 'Блокиране на спам фрази чрез [[Special:SpamRegex]]',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'spamregex-text' => '(লেখা)',
	'spamregex-summary-log' => '(সারাংশ)',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'spamregex' => 'Strob regex (Spam regex)',
	'spamregex-desc' => "[[Special:SpamRegex|Sil]] ar frazennoù dic'hoantaus er pajennoù, diazezet war eztaoladennoù poellel",
	'spamregex-error-unblocking' => 'Fazi distankañ "$1". Sur a-walc\'h n\'eus ket a batrom.',
	'spamregex-summary' => 'Kavet eo bet an destenn e diverradur ar bajenn.',
	'spamregex-intro' => "Grit gant ar furmskrid-mañ da virout da vat ma vo lakaaet troiennoù zo e testenn ur bajenn.
M'en em gav an troiennoù resisaet en destenn ne vo ket tu da enrollañ hag un displegadenn a vo diskouezet d'an implijer a glask saveteiñ ar bajenn.
Diwallit mat : arabat lakaat troiennoù re verr pe stank betek re.",
	'spamregex-page-title' => 'Stankadenn eztaoladennoù poellel ar stroboù',
	'spamregex-currently-blocked' => "'''Frazennoù stanket evit bremañ :'''",
	'spamregex-move' => "An abeg hoc'h eus ebarzhet a oa ennañ ur frazenn stanket.",
	'spamregex-no-currently-blocked' => "'''N'eus frazenn stanket ebet.'''",
	'spamregex-log' => "* '''$1''' $2  ([{{SERVER}}$3&text=$4 dilemel]) ouzhpennet gant $5 d'ar $6 da $7",
	'spamregex-page-title-1' => 'Stankadenn ur frazenn hag a implij eztaoladennoù poellel',
	'spamregex-unblock-success' => 'Distanket eo bet an implijer.',
	'spamregex-unblock-message' => "Distanket eo bet ar bajenn '''$1''' evit an embann.",
	'spamregex-page-title-2' => 'Stankadenn frazennoù en ur implijout eztaoladennoù poellel',
	'spamregex-block-success' => 'Graet eo ar stankadur',
	'spamregex-block-message' => "Stanket eo bet ar frazenn '''$1'''",
	'spamregex-warning-1' => 'Reiñ ur frazenn da stankañ.',
	'spamregex-error-1' => 'Eztaoladenn poellel direizh.',
	'spamregex-warning-2' => "Mar plij dibabit d'an nebeutañ un doare stankañ.",
	'spamregex-already-blocked' => '« $1 » zo stanket dija',
	'spamregex-phrase-block' => 'Frazenn da stankañ :',
	'spamregex-phrase-block-text' => 'stankañ ar frazenn e testenn ar bajenn',
	'spamregex-phrase-block-summary' => 'stankañ ar frazenn en evezhiadenn',
	'spamregex-block-submit' => 'Stankañ&nbsp;ar&nbsp;frazenn-se',
	'spamregex-text' => '(Testenn)',
	'spamregex-summary-log' => '(Diverradur)',
	'right-spamregex' => 'Stankañ stroboù dre [[Special:SpamRegex]]',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'spamregex' => 'Regularni izrazi spama',
	'spamregex-desc' => '[[Special:SpamRegex|Izdvajanje]] neželjenih fraza u uređenim stranicama, na osnovu regularnih izraza',
	'spamregex-error-unblocking' => 'Greška pri deblokadi "$1". Moguće je da nema takve šeme.',
	'spamregex-summary' => 'Tekst je pronađen u sažetku stranice',
	'spamregex-intro' => 'Koristite ovaj obrazac za efektivno blokiranje izraza od njihovog spremanja u tekst stranice.
Ako tekst sadrži dati izraz, izmjena se neće sačuvati i bit će prikazano obrazloženje korisniku koji pokušava spremiti stranicu.
Preporučuje se oprez, da izrazi ne budu previše kratki niti previše uobičajeni.',
	'spamregex-page-title' => 'Spam filter za blokiranje neželjenih izraza',
	'spamregex-currently-blocked' => "'''Trenutno blokirane fraze:'''",
	'spamregex-move' => 'Razlog koji ste unijeli sadrži blokiranu frazu.',
	'spamregex-no-currently-blocked' => "'''Nema blokiranih fraza.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 ukloni]) dodano od strane $5 dana $6 u $7",
	'spamregex-page-title-1' => 'Blokiranje fraze koristeći obične izraze',
	'spamregex-unblock-success' => 'Deblokada uspješna',
	'spamregex-unblock-message' => "Fraza '''$1''' je deblokirana za uređivanje.",
	'spamregex-page-title-2' => 'Blokiranje fraze od spremanja koristeći redovne izraze',
	'spamregex-block-success' => 'Blokada uspješna',
	'spamregex-block-message' => "Fraza '''$1''' je blokirana.",
	'spamregex-warning-1' => 'Navedite frazu za blokiranje.',
	'spamregex-error-1' => 'Nevaljan regularni izraz.',
	'spamregex-warning-2' => 'Molimo odaberite najmanje jedan način blokade',
	'spamregex-already-blocked' => '"$1" je već blokiran',
	'spamregex-phrase-block' => 'Fraza za blokadu:',
	'spamregex-phrase-block-text' => 'blokirana fraza u tekstu stranice',
	'spamregex-phrase-block-summary' => 'blokirana fraza u sažetku',
	'spamregex-block-submit' => 'Blokiraj&nbsp;ovu&nbsp;frazu',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Sažetak)',
	'right-spamregex' => 'Blokiranje spam fraza putem [[Special:SpamRegex]]',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'spamregex-already-blocked' => '«$1» ja està blocat',
	'right-spamregex' => 'Blocar frases de spam a través de [[Special:SpamRegex]]',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'spamregex-text' => '(دەق)',
	'spamregex-summary-log' => '(پوختە)',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'spamregex-text' => '(Tekst)',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Revolus
 * @author SVG
 * @author Umherirrender
 */
$messages['de'] = array(
	'spamregex' => 'Spam Regex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtert]] ungewollte Phrasen, basierend auf regulären Ausdrücken, aus geänderten Seiten aus',
	'spamregex-error-unblocking' => 'Konnte „$1“ nicht freigeben. Wahrscheinlich existiert kein solches Muster.',
	'spamregex-summary' => 'Der Text wurde in der Zusammenfassung gefunden.',
	'spamregex-intro' => 'Benutze dieses Formular, um effektiv zu verhindern, dass angegebene Phrasen in den Text einer Seite eingefügt werden.
Wenn der Text die angegebene Phrase enthält, wird die Änderung nicht gespeichert und ein Hinweis an den Benutzer ausgegeben, der versucht hat, die Seite zu speichern.
Sei aber vorsichtig, Phrasen sollten nicht zu kurz oder zu allgemein sein.',
	'spamregex-page-title' => 'Filtern ungewollter Ausdrücke',
	'spamregex-currently-blocked' => "'''Derzeit gesperrte Phrasen:'''",
	'spamregex-move' => 'Die Zusammenfassung, die du angabst, enthält eine gesperrte Phrase.',
	'spamregex-no-currently-blocked' => "'''Es gibt derzeit keine gesperrten Phrasen.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 entfernen]) hinzugefügt durch $5 am $6 um $7 Uhr",
	'spamregex-page-title-1' => 'Sperre Phrase als regulären Ausdruck',
	'spamregex-unblock-success' => 'Entsperrung erfolgreich',
	'spamregex-unblock-message' => "Phrase „'''$1'''“ wurde für Bearbeitungen entsperrt.",
	'spamregex-page-title-2' => 'Sperre das Speichern der Phrase als regulären Ausdruck',
	'spamregex-block-success' => 'Sperrung erfolgreich',
	'spamregex-block-message' => "Phrase „'''$1'''“ wurde gesperrt.",
	'spamregex-warning-1' => 'Phrase zum Sperren angeben',
	'spamregex-error-1' => 'Ungültiger regulärer Ausdruck.',
	'spamregex-warning-2' => 'Bitte wähle mindestens eine Sperrmethode aus.',
	'spamregex-already-blocked' => '„$1“ ist bereits gesperrt',
	'spamregex-phrase-block' => 'Zu sperrende Phrase:',
	'spamregex-phrase-block-text' => 'Phrase im Seitentext sperren',
	'spamregex-phrase-block-summary' => 'Phrase in der Zusammenfassung sperren',
	'spamregex-block-submit' => 'Phrase sperren',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Zusammenfassung)',
	'right-spamregex' => 'Ungewollte Phrasen über [[Special:SpamRegex]] blockieren',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 * @author Imre
 */
$messages['de-formal'] = array(
	'spamregex-intro' => 'Benutzen Sie dieses Formular, um effektiv zu verhindern, dass angegebene Phrasen in den Text einer Seite eingefügt werden.
Wenn der Text die angegebene Phrase enthält, wird die Änderung nicht gespeichert und ein Hinweis an den Benutzer ausgegeben, der versucht hat, die Seite zu speichern.
Seien Sie aber vorsichtig, Phrasen sollten nicht zu kurz oder zu allgemein sein.',
	'spamregex-move' => 'Die Zusammenfassung, die Sie angegeben haben, enthält eine gesperrte Phrase.',
	'spamregex-warning-2' => 'Bitte wählen Sie mindestens eine Sperrmethode aus.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => 'Njewitane fraze na wobźěłanych bokach z pomocu regularnych wurazow [[Special:SpamRegex|wufiltrowaś]]',
	'spamregex-error-unblocking' => 'Zmólka pśi pśipušćanju "$1". Nejskerjej taki muster njeeksistěrujo.',
	'spamregex-summary' => 'Tekst jo se namakał w zespominanju boka.',
	'spamregex-intro' => 'Wužyj toś ten formular, aby zajźował, až by se składowali wuraze do teksta boka.
Jolic tekst wopśimujo pódany wuraz, změna njeby se składowała a wujasnjenje pokažo se wužiwarjeju, kótaryž jo wopytał bok składowaś.
Buź pak wobglědniwy, wuraze njeby pśekrotke abo pśepowšykne byś.',
	'spamregex-page-title' => 'Njewitane wuraze z pomocu regularnych wurazow blokěrowaś',
	'spamregex-currently-blocked' => "'''Tuchylu blokěrowane fraze:'''",
	'spamregex-move' => 'Pśicyna, kótaruž sy zapódał, wopśimujo blokěrowanu frazu.',
	'spamregex-no-currently-blocked' => "'''Njejsu blokěrowane fraze.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 wótpóraś]) pśidany wót $5 $6 $7",
	'spamregex-page-title-1' => 'Frazu z pomocu regularnych wurazow blokěrowaś',
	'spamregex-unblock-success' => 'Pśipušćenje wuspěšne',
	'spamregex-unblock-message' => "Fraza '''$1''' jo se pśipušćiła za wobźěłanje.",
	'spamregex-page-title-2' => 'Fraze pśeśiwo składowanjeju z pomocu regularnych wurazow blokěrowaś',
	'spamregex-block-success' => 'Blokěrowanje wuspěšne',
	'spamregex-block-message' => "Fraza '''$1''' jo se blokěrowała.",
	'spamregex-warning-1' => 'Pódaj frazu za blokěrowanje.',
	'spamregex-error-1' => 'Njepłaśiwy regularny wuraz.',
	'spamregex-warning-2' => 'Pšosym wubjeŕ nanejmjenjej jaden blokěrowański modus.',
	'spamregex-already-blocked' => '"$1" jo južo blokěrowany.',
	'spamregex-phrase-block' => 'Fraza, kótaraž ma se blokěrowaś:',
	'spamregex-phrase-block-text' => 'Frazu w bokowem teksće blokěrowaś',
	'spamregex-phrase-block-summary' => 'frazu w zespominanju blokěrowaś',
	'spamregex-block-submit' => 'Toś&nbsp;tu&nbsp;frazu&nbsp;blokěrowaś',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Zespominanje)',
	'right-spamregex' => 'Njewitane fraze pśez [[Special:SpamRegex]] blokěrowaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Lou
 * @author ZaDiak
 */
$messages['el'] = array(
	'spamregex' => 'Τακτική έκφραση spam',
	'spamregex-summary' => 'Το κείμενο βρέθηκε στην περίληψη της σελίδας.',
	'spamregex-currently-blocked' => "'''Υπάρχουσες φραγμένες φράσεις:'''",
	'spamregex-no-currently-blocked' => "'''Δεν υπάρχουν φραγμένες φράσεις.'''",
	'spamregex-unblock-success' => 'Η απόφραξη ολοκληρώθηκε επιτυχώς.',
	'spamregex-block-success' => 'Η φραγή ήταν επιτυχής',
	'spamregex-block-message' => "Η φράση '''$1''' έχει φραγεί.",
	'spamregex-warning-1' => 'Δώστε μια φράση για φραγή.',
	'spamregex-warning-2' => 'Παρακαλώ ελέγξτε τουλάχιστον μια λειτουργία φραγής.',
	'spamregex-already-blocked' => 'Ο "$1" είναι ήδη φραγμένος',
	'spamregex-phrase-block' => 'Φράση για φραγή:',
	'spamregex-phrase-block-text' => 'γραφή φράσης στο κείμενο της σελίδας',
	'spamregex-phrase-block-summary' => 'φραγή φράση στη σύνοψη',
	'spamregex-block-submit' => 'Φραγή&nbsp;της&nbsp;φράσης',
	'spamregex-text' => '(κείμενο)',
	'spamregex-summary-log' => '(Περίληψη)',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'spamregex-summary' => 'La teksto estis trovita en la resumo de la paĝo.',
	'spamregex-currently-blocked' => "'''Nune forbaritaj frazeroj:'''",
	'spamregex-move' => 'La kialo kiun vi enigis enhavis forbaritajn frazeron.',
	'spamregex-no-currently-blocked' => "'''Ne estas iuj ajn forbaritaj vortaj kombinaĵoj.'''",
	'spamregex-page-title-1' => 'Forbari frazero uzante regularajn esprimojn',
	'spamregex-unblock-success' => 'Malforbaro sukcesis',
	'spamregex-unblock-message' => "Frazero '''$1''' estis malforbarita de redaktado.",
	'spamregex-page-title-2' => 'Malpermesigi frazerojn kontraŭ konservado per regularaj esprimoj',
	'spamregex-block-success' => 'Forbaro sukcesis',
	'spamregex-block-message' => "Frazero '''$1''' estis forbarita.",
	'spamregex-warning-1' => 'Eligi frazeron por forbari.',
	'spamregex-error-1' => 'Nevalida regula esprimo.',
	'spamregex-already-blocked' => '"$1" jam estas forbarita.',
	'spamregex-phrase-block' => 'Vorta kombinaĵo por forbari:',
	'spamregex-phrase-block-text' => 'forbari frazon en paĝa teksto',
	'spamregex-phrase-block-summary' => 'forbari frazeron en resumo',
	'spamregex-block-submit' => 'Forbari&nbsp;ĉi&nbsp;tiun&nbsp;frazeron',
	'spamregex-text' => '(Teksto)',
	'spamregex-summary-log' => '(Resumo)',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Dferg
 * @author Fitoschido
 * @author Imre
 */
$messages['es'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrar]] frases no deseadas en páginas editadas, basadas en expresiones regulares',
	'spamregex-error-unblocking' => 'Error al desbloquear «$1». Probablemente no exista tal ruta.',
	'spamregex-summary' => 'El texto fue encontrado en el resumen de la página.',
	'spamregex-intro' => 'Use este formulario para evitar la inclusión de expresiones en el texto de una página.
Si el texto contiene la expresion dada, no se grabará el cambio y se mostrará una explicación al usuario que intenta guardar la página.
Sea cuidadoso, las expresiones a prohibir no deberían ser muy cortas o muy comunes.',
	'spamregex-page-title' => 'Bloqueo de expresiones no deseadas spam regex',
	'spamregex-currently-blocked' => "'''Frases actualmente bloqueadas:'''",
	'spamregex-move' => 'La razón que ha ingresado contiene una frase bloqueada.',
	'spamregex-no-currently-blocked' => "'''No hay frases bloqueadas.'''",
	'spamregex-log' => " '''$1''' $2 ([{{SERVER}}$3&text=$4 borrado]) agregado por  $5 sobre $6 en $7",
	'spamregex-page-title-1' => 'Bloquear frase usando expresiones regulares',
	'spamregex-unblock-success' => 'Desbloqueo exitoso',
	'spamregex-unblock-message' => "La frase '''$1''' ha sido desbloqueada de la edición.",
	'spamregex-page-title-2' => 'Bloquear frases desde el grabado usando expresiones regulares',
	'spamregex-block-success' => 'Bloqueo exitoso',
	'spamregex-block-message' => "La frase '''$1''' ha sido bloqueada.",
	'spamregex-warning-1' => 'Proporcione una frase a bloquear.',
	'spamregex-error-1' => 'Expresión regular no válida.',
	'spamregex-warning-2' => 'Marque al menos un modo de bloqueo.',
	'spamregex-already-blocked' => '«$1» ya está bloqueado',
	'spamregex-phrase-block' => 'Frase a bloquear:',
	'spamregex-phrase-block-text' => 'bloquear frase en texto de página',
	'spamregex-phrase-block-summary' => 'bloquear frase en resumen',
	'spamregex-block-submit' => 'Bloquear&nbsp;esta&nbsp;frase',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Resumen)',
	'right-spamregex' => 'Bloquear frases spam a traves de [[Special:SpamRegex]]',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'spamregex-currently-blocked' => "'''Gaur egun blokeatutako esaldiak:'''",
	'spamregex-no-currently-blocked' => "'''Ez dago blokeatutako esaldirik.'''",
	'spamregex-warning-1' => 'Idatz ezazu blokeatzeko esaldi bat.',
	'spamregex-phrase-block' => 'Blokeatu beharreko esaldia:',
	'spamregex-block-submit' => 'Esaldi&nbsp;hau&nbsp;blokeatu',
	'spamregex-text' => '(Testu)',
	'spamregex-summary-log' => '(Laburpen)',
);

/** Finnish (Suomi)
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'spamregex-error-unblocking' => 'Ilmauksen ”$1” eston poisto ei onnistunut. Sitä ei todennäköisesti ole estetty.',
	'spamregex-summary' => 'Teksti löytyi sivun yhteenvedosta.',
	'spamregex-currently-blocked' => "'''Estetyt ilmaukset:'''",
	'spamregex-move' => 'Antamasi syy sisälsi estetyn ilmauksen.',
	'spamregex-no-currently-blocked' => "'''Estettyjä ilmauksia ei ole.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 poista]) lisäsi $5 $6 klo $7",
	'spamregex-page-title-1' => 'Estä ilmaus säännöllisten lausekkeiden avulla',
	'spamregex-unblock-success' => 'Eston poisto onnistui',
	'spamregex-unblock-message' => "Ilmauksen '''$1''' esto on poistettu.",
	'spamregex-page-title-2' => 'Estä ilmausten tallentaminen säännöllisten lausekkeiden avulla',
	'spamregex-block-success' => 'Esto onnistui',
	'spamregex-block-message' => "Ilmaus '''$1''' on estetty.",
	'spamregex-warning-1' => 'Anna estettävä ilmaus.',
	'spamregex-error-1' => 'Virheellinen säännöllinen lauseke.',
	'spamregex-warning-2' => 'Valitse ainakin yksi estotapa.',
	'spamregex-already-blocked' => '”$1” on jo estetty',
	'spamregex-phrase-block' => 'Estettävä ilmaus:',
	'spamregex-phrase-block-text' => 'estä ilmaus sivun tekstissä',
	'spamregex-phrase-block-summary' => 'estä ilmaus yhteenvedossa',
	'spamregex-block-submit' => 'Estä&nbsp;tämä&nbsp;ilmaus',
	'spamregex-text' => '(Teksti)',
	'spamregex-summary-log' => '(Yhteenveto)',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Meno25
 * @author Urhixidur
 */
$messages['fr'] = array(
	'spamregex' => 'Expressions rationnelles de pourriels',
	'spamregex-desc' => '[[Special:SpamRegex|Filtre]], dans les pages, les phrases ou mots indésirables, basé sur des expressions rationnelles',
	'spamregex-error-unblocking' => 'Erreur de déblocage de « $1 ». Il n’y a pas probablement aucun modèle.',
	'spamregex-summary' => 'Le texte en question a été détecté dans le commentaire de la page.',
	'spamregex-intro' => 'Utilisez ce formulaire pour bloquer effectivement les expressions pouvant être sauvegardées dans une page texte. Si le texte contient les expressions définies, les changements ne pourront être sauvegardés et un motif explicatif sera affiché à l’utilisateur qui a voulu sauvegarder la page. Il est important de prendre en considération que les expressions ne devront être ni trop longues ni trop courantes.',
	'spamregex-page-title' => 'Blocage des expressions rationnelles de pourriels',
	'spamregex-currently-blocked' => "'''Phrases actuellement bloquées :'''",
	'spamregex-move' => 'Le motif que vous avez inscrit contenait une phrase bloquée.',
	'spamregex-no-currently-blocked' => "'''Il n’y a aucune phrase bloquée.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 supprimer]) ajouté par $5 le $6 à $7",
	'spamregex-page-title-1' => 'Blocage d’une phrase utilisant des expressions rationnelles',
	'spamregex-unblock-success' => 'Le déblocage a réussi',
	'spamregex-unblock-message' => "La phrase '''$1''' a été débloquée à l’édition.",
	'spamregex-page-title-2' => 'Blocage des phrases en utilisant des expressions rationnelles',
	'spamregex-block-success' => 'Le blocage a réussi',
	'spamregex-block-message' => "La phrase '''$1''' a été bloquée.",
	'spamregex-warning-1' => 'Indiquez une phrase à bloquer.',
	'spamregex-error-1' => 'Expression rationnelle invalide.',
	'spamregex-warning-2' => 'Choisissez au moins un mode de blocage.',
	'spamregex-already-blocked' => '« $1 » est déjà bloqué',
	'spamregex-phrase-block' => 'Phrase à bloquer :',
	'spamregex-phrase-block-text' => 'bloquer la phrase dans le texte de la page',
	'spamregex-phrase-block-summary' => 'bloquer la phrase dans le commentaire',
	'spamregex-block-submit' => 'Bloquer&nbsp;cette&nbsp;phrase',
	'spamregex-text' => '(Texte)',
	'spamregex-summary-log' => '(Commentaire)',
	'right-spamregex' => 'Bloquer du spam depuis [[Special:SpamRegex]]',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'spamregex' => 'Èxprèssions racionèles de spames',
	'spamregex-currently-blocked' => "'''Frâses ora blocâs :'''",
	'spamregex-no-currently-blocked' => "'''Y at gins de frâsa blocâ.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 enlevar]) apondu per $5 lo $6 a $7",
	'spamregex-unblock-success' => 'Lo dèblocâjo at reussi',
	'spamregex-block-success' => 'Lo blocâjo at reussi',
	'spamregex-block-message' => "La frâsa '''$1''' at étâ blocâ.",
	'spamregex-error-1' => 'Èxprèssion racionèla fôssa.',
	'spamregex-already-blocked' => '« $1 » est ja blocâ',
	'spamregex-phrase-block' => 'Frâsa a blocar :',
	'spamregex-phrase-block-text' => 'blocar la frâsa dens lo tèxto de la pâge',
	'spamregex-phrase-block-summary' => 'blocar la frâsa dens lo rèsumâ',
	'spamregex-block-submit' => 'Blocar&nbsp;cela&nbsp;frâsa',
	'spamregex-text' => '(Tèxto)',
	'spamregex-summary-log' => '(Rèsumâ)',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'spamregex-already-blocked' => '"$1" is al útsluten',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtro]] de frases non desexadas nas páxinas editadas, baseado en expresións regulares',
	'spamregex-error-unblocking' => 'Erro ao desbloquear "$1". Probablemente non hai tal patrón.',
	'spamregex-summary' => 'O texto atopouse no resumo da páxina.',
	'spamregex-intro' => 'Use este formulario para bloquear de maneira efectiva expresións para que non se poidan gardar no texto dunha páxina.
Se o texto contén a expresión dada, o cambio non poderá ser gardado e unha explicación será amosada ao usuario que intentou gardar a páxina.
Teña en conta que as expresións non deberían ser moi curtas ou moi comúns.',
	'spamregex-page-title' => 'Bloqueo spam regex de expresións non desexadas',
	'spamregex-currently-blocked' => "'''Frases actualmente bloqueadas:'''",
	'spamregex-move' => 'O motivo que inseriu contén unha frase bloqueada.',
	'spamregex-no-currently-blocked' => "'''Non hai frases bloqueadas.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 eliminar]) engadido por $5 o $6 ás $7",
	'spamregex-page-title-1' => 'Bloquear frase usando expresións regulares',
	'spamregex-unblock-success' => 'Desbloqueo con éxito',
	'spamregex-unblock-message' => "A frase '''$1''' foi desbloqueada para a edición.",
	'spamregex-page-title-2' => 'Bloquear frases usando expresións regulares para que non poidan ser guardadas',
	'spamregex-block-success' => 'Bloqueo con éxito',
	'spamregex-block-message' => "A frase '''$1''' foi bloqueada.",
	'spamregex-warning-1' => 'Dar unha frase para bloquear.',
	'spamregex-error-1' => 'Expresión regular non válida.',
	'spamregex-warning-2' => 'Por favor, comprobe, polo menos, un modo de bloqueo.',
	'spamregex-already-blocked' => '"$1" xa está bloqueado',
	'spamregex-phrase-block' => 'Frase para bloquear:',
	'spamregex-phrase-block-text' => 'bloquear unha frase no texto da páxina',
	'spamregex-phrase-block-summary' => 'bloquear frase no resumo',
	'spamregex-block-submit' => 'Bloquear&nbsp;esta&nbsp;frase',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Resumo)',
	'right-spamregex' => 'Bloquear as frases de spam mediante [[Special:SpamRegex]]',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'spamregex-summary-log' => '(Σύνοψις)',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Melancholie
 */
$messages['gsw'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => '[[Special:SpamRegex|Filter]] nit gwinschti Phrasen us gänderete Syte uus, basiert uf reguläre Uusdrick',
	'spamregex-error-unblocking' => 'Het „$1“ nit chenne frejgee. Wahrschyyns git kei sonigs Muschter.',
	'spamregex-summary' => 'Dr Täxt isch in dr Zämmefassig gfunde wore.',
	'spamregex-intro' => 'Verwänd des Formular go effektiv verhindere, ass Phrase, wu aagee wore sin, in dr Täxt yygee wäre.
Wänn s im Täxt Phrase het, wu aagee sin, no wird d Änderig nit gspycheret un e Hiiwyys an de Benutzer uusgee, wu versuecht het, d Syte z spychere.
Bii aber vorsichtig, Phrase sotte nit z churz oder zue allgmein syy.',
	'spamregex-page-title' => 'Nit gwinschti Uusdrick filtere',
	'spamregex-currently-blocked' => "'''Im Momänt gsperrti Phrase:'''",
	'spamregex-move' => 'In dr Zämmefassig, wu Du aagee hesch, het s e gsperrti Phrase.',
	'spamregex-no-currently-blocked' => "'''S git im Momänt kei gsperrti Phrase.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 useneh]) zuegfiegt vu $5 am $6 am $7",
	'spamregex-page-title-1' => 'Sperr Phrase as reguläre Uusdruck',
	'spamregex-unblock-success' => 'Entsperrig erfolgryych',
	'spamregex-unblock-message' => "Phrase „'''$1'''“ isch fir Bearbeitige entsperrt.",
	'spamregex-page-title-2' => 'Sperr s Spychere vu dr Phrase as reguläre Uusdruck',
	'spamregex-block-success' => 'Sperrig erfolgryych',
	'spamregex-block-message' => "Phrase „'''$1'''“ isch gsperrt wore.",
	'spamregex-warning-1' => 'Phrase zum Sperren aagee',
	'spamregex-error-1' => 'Nit giltige reguläre Uusdruck.',
	'spamregex-warning-2' => 'Bitte wehl zmindescht ei Sperrmethod uus.',
	'spamregex-already-blocked' => '„$1“ isch scho gsperrt',
	'spamregex-phrase-block' => 'Phrase, wu soll gsperrt wäre:',
	'spamregex-phrase-block-text' => 'Phrase im Sytetäxt sperre',
	'spamregex-phrase-block-summary' => 'Phrase in dr Zämmefassig sperre',
	'spamregex-block-submit' => 'Phrase sperre',
	'spamregex-text' => '(Täxt)',
	'spamregex-summary-log' => '(Zämmefassig)',
	'right-spamregex' => 'Sperr nit gwinschti Phrase iber [[Special:SpamRegex]]',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'spamregex-summary-log' => '(Taƙaici)',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'spamregex' => 'ביטוי רגולרי לספאם',
	'spamregex-desc' => '[[Special:SpamRegex|סינון]] מונחים בלתי רצויים בדפים שנערכים, בהתבסס על ביטויים רגולריים',
	'spamregex-error-unblocking' => 'שגיאה בביטול חסימת "$1". ייתכן שלא קיימת תבנית כזו.',
	'spamregex-summary' => 'הטקסט נמצא בתקציר הדף.',
	'spamregex-intro' => 'השתמשו בטופס זה כדי לחסום באופן יעיל את אפשרות השמירה של ביטויים מסוימים לטקסט הדף.
אם הטקסט מכיל את הביטוי הנתון, השינוי לא יישמר, ובמקום זאת יופיע הסבר למשתמש שניסה לשמור את הדף.
שימו לב, מומלץ להימנע מביטויים קצרים מדי או נפוצים מדי.',
	'spamregex-page-title' => 'חסימת ביטויי ספאם בלתי רצויים',
	'spamregex-currently-blocked' => "'''מונחים הנחסמים נכון לעכשיו:'''",
	'spamregex-move' => 'הסיבה שכתבתם מכילה מונח שנחסם.',
	'spamregex-no-currently-blocked' => "'''אין מונחים חסומים.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 הסרה]) נוספה על ידי $5 ב־$7, $6",
	'spamregex-page-title-1' => 'חסימת ביטוי באמצעות ביטויים רגולריים',
	'spamregex-unblock-success' => 'הסרת החסימה הושלמה בהצלחה',
	'spamregex-unblock-message' => "הוסרה חסימת המונח '''$1''' מעריכה.",
	'spamregex-page-title-2' => 'חסימת מונחים משמירה באמצעות שימוש בביטויים רגולריים',
	'spamregex-block-success' => 'החסימה הושלמה בהצלחה',
	'spamregex-block-message' => "המונח '''$1''' נחסם.",
	'spamregex-warning-1' => 'הקלידו מונח לחסימה.',
	'spamregex-error-1' => 'הביטוי הרגולרי אינו תקין.',
	'spamregex-warning-2' => 'אנא סמנו לפחות מצב חסימה אחד.',
	'spamregex-already-blocked' => '"$1" כבר נחסם',
	'spamregex-phrase-block' => 'מונח לחסימה:',
	'spamregex-phrase-block-text' => 'חסימת המונח בטקסט שבדף',
	'spamregex-phrase-block-summary' => 'חסימת המונח בתקציר',
	'spamregex-block-submit' => 'חסימת&nbsp;מונח&nbsp;זה',
	'spamregex-text' => '(טקסט)',
	'spamregex-summary-log' => '(תקציר)',
	'right-spamregex' => 'חסימת מונחי ספאם דרך [[Special:SpamRegex]]',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'spamregex-already-blocked' => '"$1" को पहलेसे ब्लॉक किया हुआ हैं',
	'spamregex-summary-log' => '(संक्षिप्त ज़ानकारी)',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'spamregex-summary-log' => '(Kabilogan)',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'spamregex-summary-log' => '(Sažetak)',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => 'Njewitane frazy na wobdźěłanych stronach z pomocu regularnych wurazow [[Special:SpamRegex|wufiltrować]]',
	'spamregex-error-unblocking' => 'Zmylk při wotblokowanju "$1". Snano tajki muster njeeksistuje.',
	'spamregex-summary' => 'Tekst je so w zjeću strony namakał.',
	'spamregex-intro' => 'Wužij tutón formular, zo by wurazy skutkownje přećiwo składowanju w teksće strony blokował. Jel tekst daty wuraz wobsahuje, změna njeby so składowała a wujasnjenje so wužiwarjej, kiž je spytał stronu składować, pokaza. Jewi so warnowanje, zo wurazy njesmědźa překrótke abo přepowšitkowne być.',
	'spamregex-page-title' => 'Spam Regex Blokowanje njepožadanych wurazow',
	'spamregex-currently-blocked' => "'''Tuchwilu zablokowane frazy:'''",
	'spamregex-move' => 'Přičina, kotruž sy podał, je zablokowanu frazu wobsahowała.',
	'spamregex-no-currently-blocked' => "'''Zablokowane frazy njejsu.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 wotstronić]) přidaty wot $5 na $6 $7",
	'spamregex-page-title-1' => 'Frazu, kotraž regularne wurazy wužiwa, blokować',
	'spamregex-unblock-success' => 'Wotblokowanje wuspěšne',
	'spamregex-unblock-message' => "Fraza '''$1''' bu za wobdźěłowanje dopušćena.",
	'spamregex-page-title-2' => 'Frazy z pomocu regularnych wurazow za składowanje blokować',
	'spamregex-block-success' => 'Blokowanje wuspěšne',
	'spamregex-block-message' => "Fraza '''$1''' bu zablokowana.",
	'spamregex-warning-1' => 'Podaj frazu za blokowanje.',
	'spamregex-error-1' => 'Njepłaćiwy regularny wuraz.',
	'spamregex-warning-2' => 'Prošu přepruwuj znajmjeńša jedyn blokowanski modus.',
	'spamregex-already-blocked' => '"$1" je hižo zablokowany',
	'spamregex-phrase-block' => 'Fraza, kotraž ma so blokować:',
	'spamregex-phrase-block-text' => 'frazu w teksće stronya blokować',
	'spamregex-phrase-block-summary' => 'frazu w zjeću blokować',
	'spamregex-block-submit' => 'Tutu&nbsp;frazu&nbsp;blokować',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Zjeće)',
	'right-spamregex' => 'Spamowe wurazy přez [[Special:SpamRegex]] blokować',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'spamregex' => 'Spam reguláris kifejezés',
	'spamregex-desc' => 'Nemkívánatos kifejezések [[Special:SpamRegex|kiszűrése]] a szerkesztett lapokról, reguláris kifejezések alapján',
	'spamregex-error-unblocking' => 'Hiba a(z) „$1” blokkolásának feloldásakor. Valószínűleg nincs ilyen minta.',
	'spamregex-summary' => 'Szövegtalálat a lap összefoglalójában.',
	'spamregex-intro' => 'Használd ezt az űrlapot kifejezések lapszövegbe mentésének hatékony blokkolásához.
Ha a szöveg tartalmazza a megadott kifejezést, a változtatás nem kerül mentésre és egy magyarázat jelenik meg a felhasználónak, aki menteni próbálta a lapot.
Javasolt az óvatosság, a kifejezések nem lehetnek túl rövidek vagy túl gyakoriak.',
	'spamregex-page-title' => 'Nem kívánatos kifejezések blokkolása',
	'spamregex-currently-blocked' => "'''Jelenleg blokkolt kifejezések:'''",
	'spamregex-move' => 'A megadott indoklás blokkolt kifejezést tartalmazott.',
	'spamregex-no-currently-blocked' => "'''Nincsenek blokkolt kifejezések.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 eltávolítás]) hozzáadta $5 ekkor: $6 $7",
	'spamregex-page-title-1' => 'Kifejezés blokkolása reguláris kifejezések használatával',
	'spamregex-unblock-success' => 'A blokk feloldása sikerült',
	'spamregex-unblock-message' => "A(z) '''$1''' kifejezés blokkolása feloldva a szerkesztésből.",
	'spamregex-page-title-2' => 'Kifejezések blokkolása mentés előtt reguláris kifejezések használatával',
	'spamregex-block-success' => 'A blokkolás sikerült',
	'spamregex-block-message' => "A(z) '''$1''' kifejezés blokkolva.",
	'spamregex-warning-1' => 'Adj meg egy blokkolandó kifejezést.',
	'spamregex-error-1' => 'Érvénytelen reguláris kifejezés.',
	'spamregex-warning-2' => 'Kérlek válassz legalább egy blokkolási módot.',
	'spamregex-already-blocked' => '„$1” már blokkolva van',
	'spamregex-phrase-block' => 'Blokkolandó kifejezés:',
	'spamregex-phrase-block-text' => 'kifejezés blokklása a lap szövegében',
	'spamregex-phrase-block-summary' => 'kifejezés blokklása az összefoglalóban',
	'spamregex-block-submit' => 'Kifejezés blokkolása',
	'spamregex-text' => '(Szöveg)',
	'spamregex-summary-log' => '(Összefoglaló)',
	'right-spamregex' => 'Összetett spam kifejezések blokkolása a [[Special:SpamRegex]] lapon',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'spamregex' => 'Regex antispam',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrar]] phrases non desirabile in paginas modificate, a base de expressiones regular',
	'spamregex-error-unblocking' => 'Error durante le disblocada de "$1". Probabilemente non existe tal patrono.',
	'spamregex-summary' => 'Le texto esseva trovate in le summario del pagina.',
	'spamregex-intro' => 'Usa iste formulario pro effectivemente blocar certe expressiones de figurar in le texto de un pagina.
Si le texto de un modification contine un expression date hic, le modification non es immagazinate, e un explication se monstra al usator qui voleva publicar le pagina.
Caution avisate: le expressiones non debe esser troppo curte o troppo commun.',
	'spamregex-page-title' => 'Blocada de expressiones non desirate per medio de regex antispam',
	'spamregex-currently-blocked' => "'''Phrases actualmente blocate:'''",
	'spamregex-move' => 'Le motivo que tu entrava contineva un phrase blocate.',
	'spamregex-no-currently-blocked' => "'''Il non ha phrases blocate.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 disblocar]) addite per $5 le $6 a $7",
	'spamregex-page-title-1' => 'Blocar un phrase per medio de expressiones regular',
	'spamregex-unblock-success' => 'Disblocada succedite',
	'spamregex-unblock-message' => "Le phrase '''$1''' ha essite disblocate de figurar in modificationes.",
	'spamregex-page-title-2' => 'Blocar phrases de esser publicate per medio de expressiones regular',
	'spamregex-block-success' => 'Blocada succedite',
	'spamregex-block-message' => "Le phrase '''$1''' ha essite blocate.",
	'spamregex-warning-1' => 'Da un phrase a blocar.',
	'spamregex-error-1' => 'Expression regular invalide.',
	'spamregex-warning-2' => 'Per favor selige al minus un modo de blocada.',
	'spamregex-already-blocked' => '"$1" es ja blocate',
	'spamregex-phrase-block' => 'Phrase a blocar:',
	'spamregex-phrase-block-text' => 'blocar phrase in texto de pagina',
	'spamregex-phrase-block-summary' => 'blocar phrase in summario',
	'spamregex-block-submit' => 'Blocar&nbsp;iste&nbsp;phrase',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Summario)',
	'right-spamregex' => 'Blocar phrases de spam per medio de [[Special:SpamRegex]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 */
$messages['id'] = array(
	'spamregex' => 'Regex spam',
	'spamregex-desc' => '[[Special:SpamRegex|Menyaring]] frasa yang tak diinginkan di halaman yang disunting, didasarkan pada ekspresi regular (regex).',
	'spamregex-error-unblocking' => 'Kesalahan menghapus blokir "$1". Mungkin pola tersebut tak ditemukan.',
	'spamregex-summary' => 'Teks tersebut ditemukan di ringkasan halaman.',
	'spamregex-intro' => 'Gunakan isian ini untuk secara efektif memblokir penyimpanan ekspresi ke teks halaman.
Jika teks mengandung ekspresi tertentu, perubahan tidak akan disimpan dan penjelasan akan ditampilkan kepada pengguna yang mencoba untuk menyimpan halaman.
Disarankan agar ekspresi tidak terlalu pendek atau terlalu umum.',
	'spamregex-page-title' => 'Blok ekspresi yang tidak diinginkan spam regex',
	'spamregex-currently-blocked' => "'''Frasa yang sedang diblokir:'''",
	'spamregex-move' => 'Alasan yang Anda masukkan mengandung suatu frasa yang diblokir.',
	'spamregex-no-currently-blocked' => "''Tidak ada frasa yang diblokir.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 hapus]) ditambahkan oleh $5 pada $6 pukul $7",
	'spamregex-page-title-1' => 'Blokir frasa dengan menggunakan ekspresi reguler',
	'spamregex-unblock-success' => 'Pembukaan blokir berhasil',
	'spamregex-unblock-message' => "Frasa '''$1''' telah dibuka blokirnya.",
	'spamregex-page-title-2' => 'Blokir penyimpanan frasa dengan menggunakan ekspresi regular',
	'spamregex-block-success' => 'Pemblokir berhasil',
	'spamregex-block-message' => "Frasa '''$1''' telah diblokir.",
	'spamregex-warning-1' => 'Berikan suatu frasa untuk diblokir',
	'spamregex-error-1' => 'Ekspresi regular tidak valid.',
	'spamregex-warning-2' => 'Silakan pilih paling tidak satu mode blokir.',
	'spamregex-already-blocked' => '"$1" telah diblokir',
	'spamregex-phrase-block' => 'Frasa untuk diblokir:',
	'spamregex-phrase-block-text' => 'blokir frasa dalam teks halaman',
	'spamregex-phrase-block-summary' => 'blokir frasa dalam ringkasan',
	'spamregex-block-submit' => 'Blokirnbsp;frasa&nbsp;ini',
	'spamregex-text' => '(Teks)',
	'spamregex-summary-log' => '(Ringkasan)',
	'right-spamregex' => 'Blokir frasa spam melalui [[Special:SpamRegex]]',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'spamregex-already-blocked' => '„$1“ er nú þegar í banni',
);

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'spamregex-summary' => "Il testo è stato trovato nell'oggetto della pagina.",
	'spamregex-currently-blocked' => "'''Frasi attualmente bloccate:'''",
	'spamregex-no-currently-blocked' => "'''Non ci sono frasi bloccate.'''",
	'spamregex-unblock-success' => 'Sblocco eseguito',
	'spamregex-block-success' => 'Blocco eseguito',
	'spamregex-block-message' => "La frase '''$1''' è stata bloccata.",
	'spamregex-warning-1' => 'Inserisci una frase da bloccare.',
	'spamregex-error-1' => 'Espressione regolare non valida.',
	'spamregex-phrase-block' => 'Frase da bloccare:',
	'spamregex-phrase-block-text' => 'frase bloccata nel testo della pagina',
	'spamregex-phrase-block-summary' => "frase bloccata nell'oggetto",
	'spamregex-block-submit' => 'Blocca&nbsp;questa&nbsp;frase',
	'spamregex-text' => '(Testo)',
	'spamregex-summary-log' => '(Oggetto)',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author 青子守歌
 */
$messages['ja'] = array(
	'spamregex' => 'スパム正規表現フィルター',
	'spamregex-desc' => '編集されたページから望まない語句を正規表現に基づいて[[Special:SpamRegex|除去する]]',
	'spamregex-error-unblocking' => '「$1」のブロック解除中にエラー。おそらく、そのようなパターンは存在しません。',
	'spamregex-summary' => 'その文字列はページの要約文で見つかりました。',
	'spamregex-intro' => 'このフォームを使うと、ある語句をページの文章に保存されないよう、効率的にブロックすることができます。文章が指定された語句を含む場合、変更は保存されず、ページを保存しようとした利用者に説明文が表示されます。注意としては、指定する語句には短すぎるものやあまりにありふれたものは避けてください。',
	'spamregex-page-title' => 'スパム正規表現フィルターによる望まない語句のブロック',
	'spamregex-currently-blocked' => "'''現在ブロックされている語句:'''",
	'spamregex-move' => 'あなたが入力した理由にはブロックされている語句が含まれていました。',
	'spamregex-no-currently-blocked' => "'''ブロックされている語句はありません。'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 除去]) が、$5 により $6 $7 に追加",
	'spamregex-page-title-1' => '正規表現を使って語句をブロック',
	'spamregex-unblock-success' => 'ブロック解除成功',
	'spamregex-unblock-message' => "「'''$1'''」という語句を使えるようブロック解除しました。",
	'spamregex-page-title-2' => '正規表現を使って語句を保存できないようブロック',
	'spamregex-block-success' => 'ブロックに成功しました',
	'spamregex-block-message' => "「'''$1'''」という語句をブロックしました。",
	'spamregex-warning-1' => 'ブロックする語句を指定してください。',
	'spamregex-error-1' => '正規表現が無効です。',
	'spamregex-warning-2' => '最低でも1つのブロック指定を選択してください。',
	'spamregex-already-blocked' => '「$1」は既にブロックされています',
	'spamregex-phrase-block' => 'ブロックする語句:',
	'spamregex-phrase-block-text' => '語句を本文中でブロック',
	'spamregex-phrase-block-summary' => '語句を要約文中でブロック',
	'spamregex-block-submit' => 'この語句をブロック',
	'spamregex-text' => '(本文)',
	'spamregex-summary-log' => '(要約)',
	'right-spamregex' => '[[Special:SpamRegex]] を使ってスパム語句をブロックする',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-block-message' => "Ukara '''$1''' wis diblokir.",
	'spamregex-warning-1' => 'Wènèhana ukara sing kudu diblokir.',
	'spamregex-already-blocked' => '"$1" wis diblokir',
	'spamregex-phrase-block' => 'Ukara sing diblokir:',
	'spamregex-text' => '(Tèks)',
	'spamregex-summary-log' => '(Ringkesan)',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬)
 * @author GaiJin
 */
$messages['kk-cyrl'] = array(
	'spamregex-summary-log' => '(Түйіндемесі)',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬)
 * @author GaiJin
 */
$messages['kk-latn'] = array(
	'spamregex-summary-log' => '(Tüýindemesi)',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'spamregex-summary' => 'អក្សរ​ត្រូវ​បាន​រកឃើញ​នៅក្នុង​សេចក្ដីសង្ខេប​នៃ​ទំព័រ​។',
	'spamregex-block-success' => 'ហាមឃាត់ដោយជោគជ័យ',
	'spamregex-block-message' => "ឃ្លា '''$1''' ត្រូវ​បាន​ទប់ស្កាត់​។",
	'spamregex-warning-1' => 'ផ្ដល់​ឃ្លា​មួយ​ដើម្បី​ទប់ស្កាត់​។',
	'spamregex-warning-2' => 'សូម​ពិនិត្យ​របៀប​ទប់ស្កាត់​យ៉ាងហោច​មួយ​។',
	'spamregex-already-blocked' => '"$1" ត្រូវ​បាន​ទប់ស្កាត់​ហើយ',
	'spamregex-phrase-block' => 'ឃ្លា​​ត្រូវ​ទប់ស្កាត់​៖',
	'spamregex-phrase-block-text' => 'ទប់ស្កាត់​ឃ្លា​នៅ​ក្នុង​អត្ថបទ​ទំព័រ',
	'spamregex-phrase-block-summary' => 'ទប់ស្កាត់​ឃ្លា​ជា​សង្ខេប',
	'spamregex-block-submit' => 'ទប់ស្កាត់&nbsp;ឃ្លា&nbsp;នេះ',
	'spamregex-text' => '(ឃ្លា)',
	'spamregex-summary-log' => '(សេចក្តីសង្ខេប)',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'spamregex-text' => '(ಪಠ್ಯ)',
	'spamregex-summary-log' => '(ಸಾರಾಂಶ)',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => 'Övver <i lang="en">regular expressions</i>, [[Special:SpamRegex|sök esu en Texstöcke eruß]] uß fresch jeänderte Sigge, di mer doh nit han welle.',
	'spamregex-error-unblocking' => 'Ene Fähler es opjetrodde: Mer kunnte „$1“ nit frei jevve. Wascheinlesch jit et esu e Dinge nit.',
	'spamregex-summary' => 'Dä Tex wood en dä Zosammefaßung för di Sigg jevonge.',
	'spamregex-intro' => "Övver dat Fommulaa hee kanns De Textstöcke un <i lang=\"en\">regular expressions</i>
sperre, dat se nit em Tex fun Sigge enjedrare wäde künne.
Wann esu jet en ener Sigg steiht, die eine avspeichere well, dann jeiht
dat nit, un dä kritt ene Fähler jemeldt.
<br />
'''Opjepaß:''' Maat Ühr jesperrte Ußdröck nit zo koot un nit zo jewöönlesch!",
	'spamregex-page-title' => 'Spam regex — Texshtöck sperre, die mer nit avspeichere wolle.',
	'spamregex-currently-blocked' => "'''De aktoäll jesperrte Texstöcke:'''",
	'spamregex-move' => 'Wat De unger „{{int:Summary}}“ enjejovve häß, dat jeiht esu nit,
do es e Stöck Tex dren, dä jesperrt es.',
	'spamregex-no-currently-blocked' => "'''Mer han_er kei jesperrt_Texstöck.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 fott domet!]) — dobei jedonn {{GENDER:$5|vum|vum|vum Metmaacher|vum|vun der}} $5 aam $6 öm $7 Uhr",
	'spamregex-page-title-1' => 'Als en <i lang="en">regular expression</i> sperre',
	'spamregex-unblock-success' => 'Frei jejovve',
	'spamregex-unblock-message' => 'Dat Textstöck „$1“ es frei jejovve.',
	'spamregex-page-title-2' => 'Texshtöck med <i lang="en">regular expressions</i> jäje et Avspeichere sperre',
	'spamregex-block-success' => 'Jesperrt',
	'spamregex-block-message' => "Dat Texstöck  „'''$1'''“ es jesperrt.",
	'spamregex-warning-1' => 'Wat sull dann nu jesperrt wäde? Jif do jet en!',
	'spamregex-error-1' => 'Dat es en kappodde <i lang="en">regular expression</i>.',
	'spamregex-warning-2' => 'Winnischßtens ein Aat ze Sperre bruch e Höksche!',
	'spamregex-already-blocked' => '„$1“ es ald jesperrt',
	'spamregex-phrase-block' => 'Dat Texstöck för zom Sperre',
	'spamregex-phrase-block-text' => 'esu e Texstöck em Tex fun en de Sigge sperre',
	'spamregex-phrase-block-summary' => 'esu e Texstöck en de Zosammefassung sperre',
	'spamregex-block-submit' => 'Dat&nbsp;Texstöck&nbsp;sperre',
	'spamregex-text' => '(Tex)',
	'spamregex-summary-log' => '(Zosammefaßung)',
	'right-spamregex' => '<i lang="en">SPAM</i>-Wööter övver <i lang="en">[[Special:SpamRegex]]</i> sperre',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'spamregex-text' => '(Nivîs)',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'spamregex-desc' => '[[Special:SpamRegex|Filter]] onerwënscht Setz aus geännerte Säiten eraus, op Basis vu regulären Ausdréck',
	'spamregex-error-unblocking' => 'Feeler bäim ophiewe vun der Spär: "$1". Et gëtt wahrscheinlech keen esou e Muster.',
	'spamregex-summary' => 'Dësen Text gouf am Resumé vun der Säit fonnt',
	'spamregex-currently-blocked' => "'''Sätz déi elo gespaart sinn:'''",
	'spamregex-no-currently-blocked' => "'''Et gëtt keng gespaarte Sätz.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 ewechhuelen]) derbäigesat vum $5 de(n) $6 ëm $7 Auer",
	'spamregex-unblock-success' => 'Spär ass opgehuewen',
	'spamregex-block-success' => 'Gespaart',
	'spamregex-block-message' => "De Saatz '''$1''' gouf gespaart.",
	'spamregex-already-blocked' => '"$1" ass scho gespaart',
	'spamregex-phrase-block' => 'Saatz fir ze spären',
	'spamregex-phrase-block-text' => 'Saatz am Text vun enger Säit spären',
	'spamregex-phrase-block-summary' => 'Saatz am Resumé spären',
	'spamregex-block-submit' => 'Spär&nbsp;dëse&nbsp;Saz',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Resumé)',
);

/** Moksha (Мокшень)
 * @author Jarmanj Turtash
 * @author Khazar II
 */
$messages['mdf'] = array(
	'spamregex-already-blocked' => '"$1" сёлкфоль ни',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'spamregex-summary-log' => '(Чылаже)',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'spamregex' => 'Филтер за спам',
	'spamregex-desc' => '[[Special:SpamRegex|Филтрирање]] на непожелни фрази во уредуваните страници, засновано на регуларни изрази',
	'spamregex-error-unblocking' => 'Грешка при одблокирањето на „$1“. Веројатно нема таква шема.',
	'spamregex-summary' => 'Текстот е пронајден во описот на страницата.',
	'spamregex-intro' => 'Користете го овој образец за ефективно блокирање на изрази кои не сакате да можат да се зачувуваат во страници.
Ако текстот го содржи зададениот израз, промените нема да се зачуваат и на корисникот кој го внел изразот ќе му се појави образложение.
Бидете внимателни, зададените изрази не треба да бидат прекратки или пречести.',
	'spamregex-page-title' => 'Спам-филтер за блокирање на непожелни изрази',
	'spamregex-currently-blocked' => "'''Моментално блокирани фрази:'''",
	'spamregex-move' => 'Причината којашто ја внесовте содржеше блокирана фраза.',
	'spamregex-no-currently-blocked' => "'''Нема блокирани фрази.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 отстрани]) додадено од $5 на $6 во $7",
	'spamregex-page-title-1' => 'Блокирање на фраза со помош на регуларен израз',
	'spamregex-unblock-success' => 'Одблокирањето успеа',
	'spamregex-unblock-message' => "Фразата '''$1''' е одблокирана за уредување.",
	'spamregex-page-title-2' => 'Блокирање на зачувувањето на фрази со помош на регуларни изрази',
	'spamregex-block-success' => 'Блокирањето успеа',
	'spamregex-block-message' => "Фразата '''$1''' е блокирана.",
	'spamregex-warning-1' => 'Наведете фраза за блокирање.',
	'spamregex-error-1' => 'Неважечки регуларен израз.',
	'spamregex-warning-2' => 'Одберете барем еден режим на блокирање.',
	'spamregex-already-blocked' => '„$1“ е веќе блокирано',
	'spamregex-phrase-block' => 'Фраза за блокирање:',
	'spamregex-phrase-block-text' => 'блокирање на фраза во текстот на страницата',
	'spamregex-phrase-block-summary' => 'блокирање на фраза во описот на измени',
	'spamregex-block-submit' => 'Блокирај&nbsp;ја&nbsp;оваа&nbsp;фраза',
	'spamregex-text' => '(Текст)',
	'spamregex-summary-log' => '(Опис)',
	'right-spamregex' => 'Блокирање на спам-фрази со помош на [[Special:SpamRegex]]',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'spamregex-unblock-success' => 'സ്വതന്ത്രമാക്കൽ വിജയിച്ചിരിക്കുന്നു',
	'spamregex-block-success' => 'തടയൽ വിജയിച്ചിരിക്കുന്നു',
	'spamregex-already-blocked' => '"$1" ഇതിനകം തന്നെ തടയപ്പെട്ടിരിക്കുന്നു.',
	'spamregex-summary-log' => '(ചുരുക്കം)',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'spamregex-summary-log' => '(Товч агуулга)',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'spamregex' => 'स्पॅमरेजएक्स',
	'spamregex-desc' => 'संपादित पानांमधील नको असलेल्या नोंदी रेग्युलर एक्स्प्रेशन आधारित प्रणाली वापरून [[Special:SpamRegex|वेगळ्या करा]].',
	'spamregex-summary' => 'या पानाच्या सारांशामध्ये हा मजकूर सापडला.',
	'spamregex-intro' => 'एखाद्या पानाच्या मजकूरात काही फ्रेजेस जतन होण्यापासून पूर्णपणे थांबविण्यासाठी ह्या अर्जाचा वापर करा.
जर मजकूरा मध्ये दिलेले एक्स्प्रेशन आले तर बदल जतन होणार नाहीत, व जतन करु इच्छिणार्‍या सदस्याला कारण दर्शविले जाईल.
काळजी घ्या, एक्स्प्रेशन्स खूप छोटे किंवा नेहमीच्या वापरातले नकोत.',
	'spamregex-page-title' => 'स्पॅम रेजएक्स नको असलेल्या एक्स्प्रेशन्स ब्लॉक',
	'spamregex-currently-blocked' => "'''सध्या ब्लॉक केलेले फ्रेजेस:'''",
	'spamregex-no-currently-blocked' => "'''सध्या एकही ब्लॉक केलेला फ्रेज नाही.'''",
	'spamregex-page-title-1' => 'रेग्युलर एक्स्प्रेशन्स वापरून फ्रेज ब्लॉक करा',
	'spamregex-unblock-success' => 'अनब्लॉक यशस्वी',
	'spamregex-unblock-message' => "फ्रेज '''$1''' ला संपादित करण्यापासून अनब्लॉक केलेले आहे.",
	'spamregex-page-title-2' => 'रेग्युलर एक्स्प्रेशन्सचा वापर करून फ्रेजेस जतन होण्यापासून ब्लॉक करा',
	'spamregex-block-success' => 'ब्लॉक यशस्वी',
	'spamregex-block-message' => "फ्रेज '''$1''' ला ब्लॉक केलेले आहे.",
	'spamregex-warning-1' => 'ब्लॉक करण्यासाठी एक फ्रेज द्या.',
	'spamregex-error-1' => 'चुकीची रेग्युलर एक्स्प्रेशन्स.',
	'spamregex-warning-2' => 'कृपया कमीतकमी एक ब्लॉकिंग मोड तपासा.',
	'spamregex-already-blocked' => '"$1" ला अगोदरच ब्लॉक केलेले आहे',
	'spamregex-phrase-block' => 'ब्लॉक करण्यासाठी फ्रेज:',
	'spamregex-phrase-block-text' => 'पानाच्या मजकूरातून फ्रेज ब्लॉक करा',
	'spamregex-phrase-block-summary' => 'सारांशातून फ्रेज ब्लॉक करा',
	'spamregex-block-submit' => 'ही&nbsp;फ्रेज&nbsp;ब्लॉक&nbsp;करा',
	'spamregex-text' => '(मजकूर)',
	'spamregex-summary-log' => 'आढावा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'spamregex-summary-log' => '(Ringkasan)',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'spamregex-already-blocked' => '"$1" diġà bblokkjat',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'spamregex-already-blocked' => '"$1" уш саймас саезь',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'spamregex-summary-log' => '(Tlahcuilōltōn)',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 * @author Unhammer
 */
$messages['nb'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrer ut]] uønskede fraser i redigerte sider, basert på regulære uttrykk',
	'spamregex-error-unblocking' => 'Feil ved avblokkering av «$1». Det er nok ikke noe slikt mønster.',
	'spamregex-summary' => 'Teksten ble funnet i sidens sammendrag.',
	'spamregex-intro' => 'Bruk dette skjemaet for å effektivt blokkere uttrykk fra å bli lagret på sidene. Om teksten inneholder gitt uttrykk, vil endringen ikke bli lagret, og en forklaring vil vises til brukeren som prøvde å lagre siden. Vær obs på at uttrykk ikke bør være for korte eller for vanlige.',
	'spamregex-page-title' => 'Blokkering av uønskede uttrykk med regulære uttrykk',
	'spamregex-currently-blocked' => "'''Nåværende blokkerte fraser:'''",
	'spamregex-move' => 'Årsaken du skrev inn inneholdt en blokkert frase.',
	'spamregex-no-currently-blocked' => "'''Det er ingen blokkerte fraser.'''",
	'spamregex-log' => "'''$1''' $2 ([{{SERVER}}$3&text=$4 fjern]) lagt til av $5 den $6 klokka $7",
	'spamregex-page-title-1' => 'Blokker frase ved hjelp av regulære uttrykk',
	'spamregex-unblock-success' => 'Avblokkering lyktes',
	'spamregex-unblock-message' => "Frasen '''$1''' er ikke lenger blokkert.",
	'spamregex-page-title-2' => 'Blokker fraser fra å kunne lagres ved hjelp av regulære uttrykk.',
	'spamregex-block-success' => 'Blokkering lyktes',
	'spamregex-block-message' => "Frasen '''$1''' er blokkert.",
	'spamregex-warning-1' => 'Oppgi en frase å blokkere.',
	'spamregex-error-1' => 'Ugyldig regulært uttrykk.',
	'spamregex-warning-2' => 'Du må velge minst en blokkeringsmodus.',
	'spamregex-already-blocked' => '«$1» er allerede blokkert',
	'spamregex-phrase-block' => 'Frase å blokkere:',
	'spamregex-phrase-block-text' => 'blokker frase i sidetekst',
	'spamregex-phrase-block-summary' => 'blokker frase i sammendrag',
	'spamregex-block-submit' => 'Blokker&nbsp;denne&nbsp;frasen',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Sammendrag)',
	'right-spamregex' => 'Blokker spamfraser gjennom [[Special:SpamRegex]]',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'spamregex-text' => '(Text)',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => "Ongewilde zinnen [[Special:SpamRegex|uitfilteren]] in bewerkte pagina's, gebaseerd op reguliere expressies",
	'spamregex-error-unblocking' => 'Fout bij het opheffen van de blokkade van "$1". Wellicht bestaat het patroon niet.',
	'spamregex-summary' => 'De tekst is gevonden in de paginasamenvatting.',
	'spamregex-intro' => 'Gebruik dit formulier om doeltreffend te voorkomen dat uitdrukkingen worden opgeslagen in een paginatekst.
Als de tekst de gegeven uitdrukkingen bevat, dan wordt de wijziging niet opgeslagen en wordt een uitleg aan de gebruiker weergegeven die de pagina probeerde op te slaan.
Zorg dat de uitdrukkingen niet te kort of veelvoorkomend zijn.',
	'spamregex-page-title' => 'Blokkeren van uitdrukkingen met regex',
	'spamregex-currently-blocked' => "'''Huidig geblokkeerde zinnen:'''",
	'spamregex-move' => 'De opgegeven reden bevat een tekstdeel dat op de zwarte lijst staat.',
	'spamregex-no-currently-blocked' => "'''Er zijn geen geblokkeerde zinnen.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 verwijderen]) toegevoegd door $5 op $6 om $7",
	'spamregex-page-title-1' => 'Zinnen blokkeren met reguliere uitdrukkingen',
	'spamregex-unblock-success' => 'Deblokkade gelukt',
	'spamregex-unblock-message' => "Zin '''$1''' is gedeblokkeerd van bewerkingen.",
	'spamregex-page-title-2' => 'Zinnen blokkeren van opslaan met reguliere uitdrukkingen',
	'spamregex-block-success' => 'Blokkade gelukt.',
	'spamregex-block-message' => "Zin '''$1''' is geblokkeerd.",
	'spamregex-warning-1' => 'Geef een zin om te blokkeren.',
	'spamregex-error-1' => 'Ongeldige reguliere uitdrukking.',
	'spamregex-warning-2' => 'Gelieve tenminste één blokkeermogelijkheid aan te klikken.',
	'spamregex-already-blocked' => '"$1" is al geblokkeerd',
	'spamregex-phrase-block' => 'Zin om te blokkeren:',
	'spamregex-phrase-block-text' => 'zin blokkeren in paginatekst',
	'spamregex-phrase-block-summary' => 'zin blokkeren in samenvatting',
	'spamregex-block-submit' => 'Deze&nbsp;zin&nbsp;blokkeren',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Samenvatting)',
	'right-spamregex' => 'Spamwoorden blokkeren via [[Special:SpamRegex]]',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrer ut]] uønska fraser i endra sider, basert på regulære uttrykk',
	'spamregex-error-unblocking' => 'Feil ved avblokkering av «$1». Eit slikt mønster finst nok ikkje.',
	'spamregex-summary' => 'Teksten vart funne i samandraget til sida.',
	'spamregex-intro' => 'Bruk dette skjemaet for å effektivt blokkere uttrykk fra å bli lagra på sidene. Om teksten inneheld visse uttrykk, vil endringa ikke bli lagra, og ei forklaring vil visast til brukeren som prøvde å lagre sida. Ver obs på at uttrykk ikkje bør vere for korte eller for vanlege.',
	'spamregex-page-title' => 'Blokkering av uønska uttrykk med regulære uttrykk',
	'spamregex-currently-blocked' => "'''Noverande blokkerte uttrykk:'''",
	'spamregex-move' => 'Årsaka du skreiv inn inneheldt eit blokkert uttrykk.',
	'spamregex-no-currently-blocked' => "'''Det er ingen blokkerte uttrykk.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 fjern]) lagt til av $5 den $6 klokka $7",
	'spamregex-page-title-1' => 'Blokker uttrykk ved hjelp av regulære uttrykk',
	'spamregex-unblock-success' => 'Avblokkering utført',
	'spamregex-unblock-message' => "Uttrykket '''$1''' er ikkje lenger blokkert.",
	'spamregex-page-title-2' => 'Blokker uttrykk frå å kunne lagrast ved hjelp av regulære uttrykk.',
	'spamregex-block-success' => 'Blokkeringa er utførd',
	'spamregex-block-message' => "Uttrykket '''$1''' er blokkert.",
	'spamregex-warning-1' => 'Oppgje eit uttrykk som skal blokkerast.',
	'spamregex-error-1' => 'Ugyldig regulært uttrykk.',
	'spamregex-warning-2' => 'Du må velje minst ein blokkeringsmodus.',
	'spamregex-already-blocked' => '«$1» er alt blokkert',
	'spamregex-phrase-block' => 'Uttrykk å blokkere:',
	'spamregex-phrase-block-text' => 'blokker uttrykk i sidetekst',
	'spamregex-phrase-block-summary' => 'blokker uttrykk i samandrag',
	'spamregex-block-submit' => 'Blokker&nbsp;dette&nbsp;uttrykket',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Samandrag)',
	'right-spamregex' => 'Blokkera spamfrasar gjennom [[Special:SpamRegex]]',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'spamregex' => 'Expressions regularas de Spams',
	'spamregex-desc' => "[[Special:SpamRegex|Filtre]], dins las paginas, las frasas o mots indesirables, basat sus d'expressions regularas",
	'spamregex-error-unblocking' => 'Error de desblocatge de « $1 ». I a probablament pas cap de modèl.',
	'spamregex-summary' => 'Lo tèxte en question es estat detectat dins lo comentari de la pagina.',
	'spamregex-intro' => "Utilizatz aqueste formulari per blocar efièchament las expressions que pòdon èsser salvadas dins una pagina tèxte. Se lo tèxte conten las expressions definidas, los cambiaments poiràn pas èsser salvats e un motiu explicatiu serà afichat a l’utilizaire qu'a volgut salvar la pagina. Es important de prene en consideracion que las expressions deuràn pas èsser ni tròp longas ni tròp correntas.",
	'spamregex-page-title' => 'Blocatge de las expressions regularas de spams',
	'spamregex-currently-blocked' => "'''Frasas actualament blocadas :'''",
	'spamregex-move' => "Lo motiu qu'avètz inscrich conteniá una frasa blocada.",
	'spamregex-no-currently-blocked' => "'''I a pas cap de frasa blocada.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 suprimir]) apondut per $5 lo $6 a $7",
	'spamregex-page-title-1' => "Blocatge d’una frasa utilizant d'expressions regularas",
	'spamregex-unblock-success' => 'Lo desblocatge a capitat',
	'spamregex-unblock-message' => "La frasa '''$1''' es estada desblocada a l’edicion.",
	'spamregex-page-title-2' => "Blocatge de las frasas en utilizant d'expression regularas",
	'spamregex-block-success' => 'Lo blocatge a capitat',
	'spamregex-block-message' => "La frasa '''$1''' a estada blocada.",
	'spamregex-warning-1' => 'Indicatz una frasa de blocar.',
	'spamregex-error-1' => 'Expression regulara invalida.',
	'spamregex-warning-2' => 'Causissètz almens un mòde de blocatge.',
	'spamregex-already-blocked' => '« $1 » ja es blocat',
	'spamregex-phrase-block' => 'Frasa de blocar :',
	'spamregex-phrase-block-text' => 'blocar la frasa dins lo tèxte de l’article',
	'spamregex-phrase-block-summary' => 'blocar la frasa dins lo comentari',
	'spamregex-block-submit' => 'Blocar&nbsp;aquesta&nbsp;frasa',
	'spamregex-text' => '(Tèxte)',
	'spamregex-summary-log' => '(Comentari)',
	'right-spamregex' => 'Blocar de spam dempuèi [[Special:SpamRegex]]',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jose77
 */
$messages['or'] = array(
	'spamregex-summary-log' => '(ସାରକଥା)',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrowanie]] niepożądanych zwrotów na edytowanych stronach z użyciem wyrażeń regularnych',
	'spamregex-error-unblocking' => 'Błąd odblokowania „$1”. Prawdopodobnie nie ma takiego wzorca.',
	'spamregex-summary' => 'Tekst został odnaleziony w opisie zmian.',
	'spamregex-intro' => 'Formularz służy do skutecznego blokowania zapisu stron zawierających określone wyrażenie.
Jeżeli tekst zawiera zadane wyrażenie, zmiany nie zostaną zapisane, a użytkownikowi, który chciał zapisać stronę zostanie wyświetlone wyjaśnienie.
Należy zwrócić uwagę, by wyrażania nie były zbyt krótkie lub zbyt często występujące.',
	'spamregex-page-title' => 'Spam regex – blokada niepożądanych wyrażeń',
	'spamregex-currently-blocked' => "'''Aktualnie zablokowane wyrażenia:'''",
	'spamregex-move' => 'Powód który wpisałeś zawiera zabroniony zwrot.',
	'spamregex-no-currently-blocked' => "'''Nie ma zablokowanych wyrażeń.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 usuń]) dodane przez $5 dnia $6 o $7",
	'spamregex-page-title-1' => 'Blokuj frazę za pomocą wyrażenia regularnego',
	'spamregex-unblock-success' => 'Odblokowano',
	'spamregex-unblock-message' => "Edycja frazy '''$1''' została odblokowana.",
	'spamregex-page-title-2' => 'Blokuj zapis zwrotów z wykorzystaniem wyrażeń regularnych',
	'spamregex-block-success' => 'Zablokowano',
	'spamregex-block-message' => "Wyrażenie '''$1''' zostało zablokowane.",
	'spamregex-warning-1' => 'Podaj wyrażenie do zablokowania.',
	'spamregex-error-1' => 'Nieprawidłowe wyrażenie regularne.',
	'spamregex-warning-2' => 'Wybierz co najmniej jeden sposób blokowania.',
	'spamregex-already-blocked' => '„$1” jest już zablokowany',
	'spamregex-phrase-block' => 'Wyrażenie do zablokowania:',
	'spamregex-phrase-block-text' => 'blokuj zwrot w treści strony',
	'spamregex-phrase-block-summary' => 'blokuj zwrot w opisie zmian',
	'spamregex-block-submit' => 'Blokuj&nbsp;to&nbsp;wyrażenie',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Podsumowanie)',
	'right-spamregex' => 'Blokowanie spamu, przez blokowanie zwrotów na stronie [[Special:SpamRegex]]',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'spamregex' => 'Regex dë spam',
	'spamregex-desc' => '[[Special:SpamRegex|A filtra]] fras pa vorsùe an pàgine modificà, basà dzora a espression regolar',
	'spamregex-error-unblocking' => 'Eror an sblocand "$1". Probabilment col model a-i é pa.',
	'spamregex-summary' => "Ël test a l'é stàit trovà ant ël somari dla pàgina.",
	'spamregex-intro' => "Deuvra sta forma-sì për vieté efetivament ëd salvé j'espression ant ël test ëd na pàgina.
Se ël test a conten l'espression dàita, ël cambi a sarà pa salvà e na spiegassion a sarà visualisà a l'utent ch'a l'ha provà a salvé la pàgina.
As sugeriss che l'espression a dovrìa esse pa tròp curta o tròp comun-a.",
	'spamregex-page-title' => "Blocagi ëd j'espression pa vorsùe dë spam regex",
	'spamregex-currently-blocked' => "'''Fras blocà al moment:'''",
	'spamregex-move' => "La rason ch'it l'has anserì a contnìa na fras blocà.",
	'spamregex-no-currently-blocked' => "'''A-i é pa gnun-e fras blocà.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 gava]) giontà da $5 dzora $6 a $7",
	'spamregex-page-title-1' => "Blòca fras ch'a deuvra d'espression regolar",
	'spamregex-unblock-success' => 'Sblocagi andàit bin',
	'spamregex-unblock-message' => "La fras '''$1''' a l'é stàita sblocà e a peul esse modificà.",
	'spamregex-page-title-2' => 'Blòca le fras (a peulo pa esse salvà) an dovrand espression regolar',
	'spamregex-block-success' => 'Blocagi andàit bin',
	'spamregex-block-message' => "La fras '''$1''' a l'é stàita blocà.",
	'spamregex-warning-1' => 'Dà na fras da bloché.',
	'spamregex-error-1' => 'Espression regolar pa bon-a.',
	'spamregex-warning-2' => 'Për piasì contròla almanch na manera ëd bloché.',
	'spamregex-already-blocked' => '"$1" a l\'é già blocà.',
	'spamregex-phrase-block' => 'Fras da bloché:',
	'spamregex-phrase-block-text' => 'blòca fras ant ël test ëd pàgina',
	'spamregex-phrase-block-summary' => 'blòca fras ant ël resumé',
	'spamregex-block-submit' => 'Blòca&nbsp;sta&nbsp;fras',
	'spamregex-text' => '(Test)',
	'spamregex-summary-log' => '(Resumé)',
	'right-spamregex' => 'Blòca fras dë spam con [[Special:SpamRegex]]',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'spamregex-text' => '(متن)',
	'spamregex-summary-log' => '(لنډيز)',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'spamregex' => 'Expressão regular de spam',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrar]] frases indesejadas em páginas editadas, com base em expressões regulares',
	'spamregex-error-unblocking' => 'Erro ao desbloquear "$1". Provavelmente, não existe tal padrão.',
	'spamregex-summary' => 'O texto foi encontrado no resumo da página.',
	'spamregex-intro' => 'Use este formulário para efetivamente bloquear expressões de serem gravadas no texto de uma página.
Se o texto contém a dada expressão, as alterações não serão gravadas e uma explicação será apresentada ao utilizador que tentou gravar a página.
Pede-se atenção: as expressões não deverão ser demasiado curtas ou demasiado comuns.',
	'spamregex-page-title' => "Bloco de expressões regulares ''(regex)'' das expressões de ''spam'' indesejadas",
	'spamregex-currently-blocked' => "'''Frases presentemente bloqueadas:'''",
	'spamregex-move' => 'O motivo que introduziu continha uma frase bloqueada.',
	'spamregex-no-currently-blocked' => "'''Não há frases bloqueadas.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 remover]) adicionado por $5 em $6 em $7",
	'spamregex-page-title-1' => 'Bloquear frase usando expressões regulares',
	'spamregex-unblock-success' => 'Desbloqueio com sucesso',
	'spamregex-unblock-message' => "A frase '''$1''' foi desbloqueada da edição.",
	'spamregex-page-title-2' => 'Impedir páginas de serem gravadas usando expressões regulares',
	'spamregex-block-success' => 'Bloqueio bem sucedido',
	'spamregex-block-message' => "A frase '''$1''' foi bloqueada.",
	'spamregex-warning-1' => 'Forneça uma frase a bloquear.',
	'spamregex-error-1' => 'Expressão regular inválida.',
	'spamregex-warning-2' => 'Por favor selecione pelo menos um modo de bloqueio.',
	'spamregex-already-blocked' => '"$1" já está bloqueado',
	'spamregex-phrase-block' => 'Frase a bloquear:',
	'spamregex-phrase-block-text' => 'bloquear frase no texto da página',
	'spamregex-phrase-block-summary' => 'bloquear frase no resumo',
	'spamregex-block-submit' => 'Bloquear&nbsp;esta&nbsp;frase',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Resumo)',
	'right-spamregex' => 'Bloquear frases de spam através de [[Special:SpamRegex]]',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'spamregex' => 'Expressão regular de spam',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrar]] frases indesejadas em páginas editadas, com base em expressões regulares',
	'spamregex-error-unblocking' => 'Erro ao desbloquear "$1". Provavelmente, não existe tal padrão.',
	'spamregex-summary' => 'O texto foi encontrado no sumário da página.',
	'spamregex-intro' => 'Use este formulário para efetivamente bloquear expressões de serem gravadas no texto de uma página.
Se o texto contém a expressão dada, as alterações não serão gravadas e uma explicação será apresentada ao utilizador que tentou gravar a página.
Pede-se atenção: as expressões não deverão ser demasiado curtas ou demasiado comuns.',
	'spamregex-page-title' => 'Bloco de expressões indesejadas da expressão regular de spam',
	'spamregex-currently-blocked' => "'''Frases atualmente bloqueadas:'''",
	'spamregex-move' => 'O motivo que você introduziu contém uma frase bloqueada.',
	'spamregex-no-currently-blocked' => "'''Não há frases bloqueadas.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 remover]) adicionado por $5 em $6 em $7",
	'spamregex-page-title-1' => 'Bloquear frase usando expressões regulares',
	'spamregex-unblock-success' => 'Desbloqueio com sucesso',
	'spamregex-unblock-message' => "A frase '''$1''' foi desbloqueada de edições.",
	'spamregex-page-title-2' => 'Impedir páginas de serem gravadas usando expressões regulares',
	'spamregex-block-success' => 'Bloqueio bem sucedido',
	'spamregex-block-message' => "A frase '''$1''' foi bloqueada.",
	'spamregex-warning-1' => 'Forneça uma frase a bloquear.',
	'spamregex-error-1' => 'Expressão regular inválida.',
	'spamregex-warning-2' => 'Por favor selecione pelo menos um modo de bloqueio.',
	'spamregex-already-blocked' => '"$1" já está bloqueado',
	'spamregex-phrase-block' => 'Frase a bloquear:',
	'spamregex-phrase-block-text' => 'bloquear frase no texto da página',
	'spamregex-phrase-block-summary' => 'bloquear frase no sumário',
	'spamregex-block-submit' => 'Bloquear&nbsp;esta&nbsp;frase',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Sumário)',
	'right-spamregex' => 'Bloquear frases de spam através de [[Special:SpamRegex]]',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'spamregex-summary-log' => '(Asgbr)',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'spamregex-no-currently-blocked' => "'''Nu există expresii blocate.'''",
	'spamregex-unblock-success' => 'Deblocare cu succes',
	'spamregex-block-success' => 'Blocare cu succes',
	'spamregex-block-message' => "Expresia '''$1''' a fost blocată.",
	'spamregex-error-1' => 'Expresie regulată incorectă.',
	'spamregex-already-blocked' => '"$1" este deja blocat',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Rezumat)',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'spamregex-text' => '(Teste)',
	'spamregex-summary-log' => '(Riepileghe)',
);

/** Russian (Русский)
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'spamregex' => 'Спам-фильтр',
	'spamregex-desc' => '[[Special:SpamRegex|Фильтр]] нежелательных фраз при редактировании страниц, основанный на регулярных выражениях',
	'spamregex-error-unblocking' => 'Ошибка разблокирования «$1». Вероятно, такой шаблон отсутствует.',
	'spamregex-summary' => 'Текст был обнаружен в описании изменений.',
	'spamregex-intro' => 'Используйте эту форму чтобы эффективно блокировать появления в тексте страниц заданных фраз.
Ели текст содержит заданное выражение, правка не будет сохранена, а участнику, который её провёл, будет показано предупреждение.
Важное замечание, задаваемые выражения не должны быть слишком короткими или слишком часто встречающимися.',
	'spamregex-page-title' => 'Спам-фильтр нежелательных выражений',
	'spamregex-currently-blocked' => "'''В настоящий момент блокируются фразы:'''",
	'spamregex-move' => 'Причина, по которой вы добавляете эту фразу для блокировки.',
	'spamregex-no-currently-blocked' => "'''Нет заблокированных фраз.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 удалить]) добавлена $5 $6 $7",
	'spamregex-page-title-1' => 'Блокировка фразы с использованием регулярных выражений',
	'spamregex-unblock-success' => 'Разблокировка выполнена',
	'spamregex-unblock-message' => "Запрет на использование фразы '''$1''' снят.",
	'spamregex-page-title-2' => 'Блокировка использования фразы с помощью регулярных выражений',
	'spamregex-block-success' => 'Блокировка выполнена',
	'spamregex-block-message' => "Фраза '''$1''' запрещена для использования.",
	'spamregex-warning-1' => 'Укажите фразу для блокировки.',
	'spamregex-error-1' => 'Ошибочное регулярное выражение.',
	'spamregex-warning-2' => 'Пожалуйста, выберите хотя бы один режим блокирования.',
	'spamregex-already-blocked' => '«$1» уже заблокирована',
	'spamregex-phrase-block' => 'Блокировать фразу:',
	'spamregex-phrase-block-text' => 'блокировка фразы в тексте страницы',
	'spamregex-phrase-block-summary' => 'блокировка фразы в описании изменений',
	'spamregex-block-submit' => 'Блокировать эту фразу',
	'spamregex-text' => '(Текст)',
	'spamregex-summary-log' => '(описание)',
	'right-spamregex' => 'блокирование спам-фраз с помощью [[Special:SpamRegex]]',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'spamregex-text' => '(Текст)',
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'spamregex-already-blocked' => '"$1" è già broccaddu',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrovanie]] neželaných výrazov v upravovaných stránkach na základe regulárnych výrazov',
	'spamregex-error-unblocking' => 'Chyba pri odblokovaní „$1”. Taký vzor pravdepodobne neexistuje.',
	'spamregex-summary' => 'Text bol nájdený v zhrnutí úprav stránky.',
	'spamregex-intro' => 'Tento formulár slúži na efektívne zamedzenie ukladania nežiaduceho textu stránok. Ak text obsahuje uvedený výraz, zmeny nebude možné uložiť a používateľovi sa zobrazí upozornenie. Odporúča sa opatrnosť - výrazy by nemali byť príliš krátke ani bežne sa vyskytujúce.',
	'spamregex-page-title' => 'Blokovanie nežiaduceho spamu pomocou regulárnych výrazov',
	'spamregex-currently-blocked' => "'''Momentálne zablokované frázy.'''",
	'spamregex-move' => 'Dôvod, ktorý ste zadali, obsahoval zablokovaný výraz.',
	'spamregex-no-currently-blocked' => "'''Nie sú žiadne zablokované frázy.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 odstrániť]) pridal $5 $6 $7",
	'spamregex-page-title-1' => 'Zablokovať frázu pomocou regulárnych výrazov',
	'spamregex-unblock-success' => 'Odblokovanie úspešné',
	'spamregex-unblock-message' => 'Bol zrušený zákaz uložiť frázu „$1“.',
	'spamregex-page-title-2' => 'Blokovať ukladanie fráz pomocou regulárnych výrazov',
	'spamregex-block-success' => 'Blokovanie úspešné',
	'spamregex-block-message' => "Fráza '''$1''' bola zablokovaná.",
	'spamregex-warning-1' => 'Zadajte frázu, ktorú chcete blokovať.',
	'spamregex-error-1' => 'Neplatný regulárny výraz.',
	'spamregex-warning-2' => 'Prosím, označte aspoň jeden režim blokovania.',
	'spamregex-already-blocked' => '„$1“ je už blokované',
	'spamregex-phrase-block' => 'Blokovať frázu:',
	'spamregex-phrase-block-text' => 'blokovať frázu v texte stránky',
	'spamregex-phrase-block-summary' => 'blokovať frázu v zhrnutí úprav',
	'spamregex-block-submit' => 'Blokovať&nbsp;túto&nbsp;frázu',
	'spamregex-text' => '(v texte)',
	'spamregex-summary-log' => '(v zhrnutí)',
	'right-spamregex' => 'Blokovať spam v texte pomocou [[Special:SpamRegex]]',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'spamregex-summary-log' => '(Povzetek)',
);

/** Southern Sami (Åarjelsaemien)
 * @author M.M.S.
 */
$messages['sma'] = array(
	'spamregex-text' => '(Tjaalege)',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'spamregex' => 'Регуларни изрази за спам',
	'spamregex-desc' => '[[Special:SpamRegex|Филтрирајте]] нежељене фразе у измењеним страницама, помоћу регуларних израза',
	'spamregex-error-unblocking' => 'Грешка приликом деблокирања „$1”. Вероватно та фраза и није блокирана.',
	'spamregex-summary' => 'Текст се нашао у опису странице.',
	'spamregex-currently-blocked' => "'''Забрањене фразе:'''",
	'spamregex-move' => 'Разлог који сте навели је садржао блокирану фразу.',
	'spamregex-no-currently-blocked' => "'''Нема блокираних фраза.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 уклони]) додат са $5 на $6 у $7",
	'spamregex-page-title-1' => 'Блокирај фразе користећи регуларне изразе',
	'spamregex-unblock-success' => 'Приступ је враћен',
	'spamregex-unblock-message' => "Фраза '''$1''' је била деблокирана за измене.",
	'spamregex-block-success' => 'Блокирање је успело',
	'spamregex-block-message' => "Фраза '''$1''' је сада блокирана.",
	'spamregex-warning-1' => 'Унесите фразу коју желите да забраните.',
	'spamregex-error-1' => 'Невалидан регуларни израз.',
	'spamregex-warning-2' => 'Молимо Вас да означите макар један начин блокирања.',
	'spamregex-already-blocked' => '„$1“ је већ блокиран',
	'spamregex-phrase-block' => 'Забрањена фраза:',
	'spamregex-phrase-block-text' => 'блокирајте фразу у тексту странице',
	'spamregex-phrase-block-summary' => 'блокирајте фразу у опису измене',
	'spamregex-block-submit' => 'Блокирајте&nbsp;ову&nbsp;фразу',
	'spamregex-text' => '(Текст)',
	'spamregex-summary-log' => '(опис)',
	'right-spamregex' => 'Блокирајте спам-фразе помоћу [[Special:SpamRegex]]',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'spamregex' => 'Regularni izrazi za spam',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrirajte]] neželjene fraze u izmenjenim stranicama, pomoću regularnih izraza',
	'spamregex-error-unblocking' => 'Greška prilikom deblokiranja „$1”. Verovatno ta fraza i nije blokirana.',
	'spamregex-summary' => 'Tekst se našao u opisu stranice.',
	'spamregex-currently-blocked' => "'''Zabranjene fraze:'''",
	'spamregex-move' => 'Razlog koji ste naveli je sadržao blokiranu frazu.',
	'spamregex-no-currently-blocked' => "'''Nema blokiranih fraza.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 ukloni]) dodat sa $5 na $6 u $7",
	'spamregex-page-title-1' => 'Blokiraj fraze koristeći regularne izraze',
	'spamregex-unblock-success' => 'Pristup je vraćen',
	'spamregex-unblock-message' => "Fraza '''$1''' je bila deblokirana za izmene.",
	'spamregex-block-success' => 'Blokiranje je uspelo',
	'spamregex-block-message' => "Fraza '''$1''' je sada blokirana.",
	'spamregex-warning-1' => 'Unesite frazu koju želite da zabranite.',
	'spamregex-error-1' => 'Nevalidan regularni izraz.',
	'spamregex-warning-2' => 'Molimo Vas da označite makar jedan način blokiranja.',
	'spamregex-already-blocked' => '"$1" je već blokirana',
	'spamregex-phrase-block' => 'Zabranjena fraza:',
	'spamregex-phrase-block-text' => 'blokirajte frazu u tekstu stranice',
	'spamregex-phrase-block-summary' => 'blokirajte frazu u opisu izmene',
	'spamregex-block-submit' => 'Blokirajte&nbsp;ovu&nbsp;frazu',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(opis)',
	'right-spamregex' => 'Blokirajte spam-fraze pomoću [[Special:SpamRegex]]',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'spamregex-already-blocked' => '"$1" geus dipeungpeuk',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrera ut]] oönskade fraser i redigerade sidor, baserade på reguljära uttryck',
	'spamregex-error-unblocking' => 'Fel vid avblockering av "$1". Förmodligen finns det inget sådand mönster.',
	'spamregex-summary' => 'Texten hittades i sidans sammanfattning.',
	'spamregex-intro' => 'Använd det här formuläret för att effektivt blockera uttryck från att sparas på sidorna.
Om texten innehåller det angivna uttrycket, kommer ändringen inte att sparas, och en förklaring kommer visas för användaren som försökte att spara sidan.
Var observant på att uttryck inte bör vara för korta eller för vanliga.',
	'spamregex-page-title' => 'Blockering av oönskade uttryck med reguljära uttryck',
	'spamregex-currently-blocked' => "'''Nuvarande blockerade fraser:'''",
	'spamregex-move' => 'Anledningen du skrev in innehöll en blockerad fras.',
	'spamregex-no-currently-blocked' => "'''Det finns inga blockerade fraser.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 ta bort]) lagd till av $5 den $6 kl $7",
	'spamregex-page-title-1' => 'Blockera fras med hjälp av reguljära uttryck',
	'spamregex-unblock-success' => 'Avblockering lyckades',
	'spamregex-unblock-message' => "Frasen '''$1''' är inte längre blockerad.",
	'spamregex-page-title-2' => 'Blockera fraser från att kunna sparas med hjälp av reguljära uttryck',
	'spamregex-block-success' => 'Blockering lyckades',
	'spamregex-block-message' => "Frasen '''$1''' har blockerats.",
	'spamregex-warning-1' => 'Ange en fras att blockera.',
	'spamregex-error-1' => 'Ogiltigt reguljärt uttryck.',
	'spamregex-warning-2' => 'Du måste välja minst en blockeringsmetod.',
	'spamregex-already-blocked' => '"$1" är redan blockerad',
	'spamregex-phrase-block' => 'Fras att blockera:',
	'spamregex-phrase-block-text' => 'blockera fras i sidtext',
	'spamregex-phrase-block-summary' => 'blockera fras i sammanfattning',
	'spamregex-block-submit' => 'Blockera&nbsp;den&nbsp;här&nbsp;frasen',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Sammanfattning)',
	'right-spamregex' => 'Blockera spamfraser genom [[Special:SpamRegex]]',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'spamregex-text' => '(உரை)',
	'spamregex-summary-log' => '(சுருக்கம்)',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'spamregex-summary' => 'పేజీ యొక్క సంగ్రహంలో ఆ పాఠ్యం కనబడింది.',
	'spamregex-currently-blocked' => "'''ప్రస్తుతం నిరోధంలో ఉన్న పదబంధాలు:'''",
	'spamregex-unblock-success' => 'నిరోధం ఎత్తివేత విజయవంతం',
	'spamregex-block-success' => 'నిరోధం విజయవంతమయ్యింది',
	'spamregex-error-1' => 'తప్పుడు రెగ్యులర్ ఎక్స్&zwnj;ప్రెషన్.',
	'spamregex-warning-2' => 'కనీసం ఒక్క నిరోధపు పద్ధతినైనా ఎంచుకోండి.',
	'spamregex-already-blocked' => '"$1"ని ఈసరికే నిరోధించాం',
	'spamregex-phrase-block' => 'నిరోధించాల్సిన పదబంధం:',
	'spamregex-phrase-block-text' => 'పదబంధాన్ని పేజీ పాఠ్యంలో ఉంటే నిరోధించు',
	'spamregex-phrase-block-summary' => 'పదబంధాన్ని సంగ్రహంలో ఉంటే నిరోధించు',
	'spamregex-block-submit' => 'ఈ&nbsp;పదబంధాన్ని&nbsp;నిరోధించండి',
	'spamregex-text' => '(పాఠ్యం)',
	'spamregex-summary-log' => '(సంగ్రహం)',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'spamregex-text' => '(Testu)',
	'spamregex-summary-log' => '(Rezumu)',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'spamregex-error-1' => 'Ибораи оддии номӯътабар',
	'spamregex-already-blocked' => '"$1" аллакай баста шудааст',
	'spamregex-text' => '(Матн)',
	'spamregex-summary-log' => '(Хулоса)',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'spamregex-error-1' => "Iborai oddiji nomū'tabar",
	'spamregex-already-blocked' => '"$1" allakaj basta şudaast',
	'spamregex-text' => '(Matn)',
	'spamregex-summary-log' => '(Xulosa)',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'spamregex-text' => '(Tekst)',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'spamregex' => "Pangkaraniwang pagsasaad na pang-\"manlulusob\" (''spam'')",
	'spamregex-desc' => '[[Special:SpamRegex|Salain]]g tinatanggal ang hindi ninanais na mga parirala sa loob ng mga pahinang binago, batay sa pangkaraniwang mga pagsasaad',
	'spamregex-error-unblocking' => 'Kamalian sa pagtatanggal ng hadlang sa "$1".  Marahil walang ganyang gayahan (parisan/padron).',
	'spamregex-summary' => 'Natagpuan ang teksto mula sa loob ng buod ng pahina.',
	'spamregex-intro' => 'Gamitin ang pormularyong ito upang ganap na mahadlangan ang mga pagsasaad mula sa pagsasagip patungo sa teksto ng isang pahina.
Kung naglalaman ang teksto ng ibinigay na pagsasaad, hindi masasagip ang pagbabago at ipapakita sa tagagamit na sumubok na magsagip ng pahina ang isang paliwanag.
Imimungkahi ang pagiingat, hindi dapat na napakaiksi o napakapangkaraniwan ang mga pagsasaad.',
	'spamregex-page-title' => "Paghahadlang sa hindi ninanais na mga pagpapahayag ng pangkaraniwang pagsasaad ng \"manlulusob\" (''spam'')",
	'spamregex-currently-blocked' => "'''Pangkasalukuyang hinahadlangang mga parirala:'''",
	'spamregex-move' => 'Naglalaman ng isang hinadlangang parirala ang ipinasok/inilagay mong dahilan.',
	'spamregex-no-currently-blocked' => "'''Walang hinahadlangang mga parirala.'''",
	'spamregex-log' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 tanggalin]) idinagdag ni $5 noong $6 noong $7",
	'spamregex-page-title-1' => 'Hinadlangang parirala na gumagamit ng pangkaraniwang mga pagsasaad',
	'spamregex-unblock-success' => 'Nagtagumpay ang pagtanggal ng paghadlang/pagharang',
	'spamregex-unblock-message' => "Tinanggal ang pagkakaharang mula sa pamamatnugot (paggawa ng pagbabago) ang pariralang '''$1'''.",
	'spamregex-page-title-2' => 'Hadlangan ang pagsasagip ng mga parirala na ginagamitan ng pangkaraniwang mga pagsasaad',
	'spamregex-block-success' => 'Nagtagumpay ang paghadlang',
	'spamregex-block-message' => "Hinadlangan na ang pariralang '''$1'''.",
	'spamregex-warning-1' => 'Magbigay ng isang pariralang hahadlangan.',
	'spamregex-error-1' => 'Hindi tanggap na pangkaraniwang pagsasaad.',
	'spamregex-warning-2' => 'Pakilagyan ng tsek ang kahit na isang modalidad ng paghahadlang.',
	'spamregex-already-blocked' => 'Nahadlangan na ang "$1"',
	'spamregex-phrase-block' => 'Pariralang hahadlangan:',
	'spamregex-phrase-block-text' => 'hadlangan ang pariralang nasa teksto ng pahina',
	'spamregex-phrase-block-summary' => 'hadlangan ang pariralang nasa buod',
	'spamregex-block-submit' => 'Hadlangan&nbsp;ang&nbsp;pariralang&nbsp;ito',
	'spamregex-text' => '(Teksto)',
	'spamregex-summary-log' => '(Buod)',
	'right-spamregex' => 'Hadlangan ang mga pariralang manlulusob sa pamamagitan ng [[Special:SpamRegex]]',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'spamregex' => 'Reklam regexi',
	'spamregex-unblock-success' => 'Engel kaldırma işlemi başarılı',
	'spamregex-error-1' => 'Geçersiz kurallı ifade.',
	'spamregex-text' => '(Metin)',
	'spamregex-summary-log' => '(Özet)',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'spamregex-already-blocked' => '"$1" вже заблокований',
	'spamregex-text' => '(Текст)',
	'spamregex-summary-log' => '(опис)',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'spamregex-text' => '(Tekst)',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'spamregex-page-title-1' => 'Cấm cụm từ dùng biểu thức chính quy',
	'spamregex-unblock-success' => 'Bỏ cấm thành công',
	'spamregex-block-success' => 'Cấm thành công',
	'spamregex-block-message' => "Cụm từ '''$1''' đã bị cấm.",
	'spamregex-error-1' => 'Biểu thức chính quy không hợp lệ.',
	'spamregex-already-blocked' => '“$1” đã bị cấm rồi',
	'spamregex-phrase-block' => 'Cụm từ để cấm:',
	'spamregex-phrase-block-text' => 'cấm cụm từ trong nội dung trang',
	'spamregex-phrase-block-summary' => 'cấm cụm từ trong tóm lược',
	'spamregex-block-submit' => 'Cấm&nbsp;cụm&nbsp;từ&nbsp;này',
	'spamregex-text' => '(Văn bản)',
	'spamregex-summary-log' => '(Tóm lược)',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'spamregex-text' => '(Vödem)',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'spamregex-text' => '(טעקסט)',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'spamregex-text' => '（文字）',
	'spamregex-summary-log' => '（摘要）',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 */
$messages['zh-hant'] = array(
	'spamregex-text' => '（文字）',
	'spamregex-summary-log' => '（摘要）',
);

