<?php
/**
 * Internationalisation file for extension SpamBlacklist.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'spam-blacklist' => ' # External URLs matching this list will be blocked when added to a page.
 # This list affects only this wiki; refer also to the global blacklist.
 # For documentation see https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside URLs

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# External URLs matching this list will *not* be blocked even if they would
# have been blocked by blacklist entries.
#
 #</pre> <!-- leave this line exactly as it is -->',
	'email-blacklist' => ' # E-mail addresses matching this list will be blocked from registering or sending e-mails
 # This list affects only this wiki; refer also to the global blacklist.
 # For documentation see https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside e-mail addresses

 #</pre> <!-- leave this line exactly as it is -->',
	'email-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# Email addresses matching this list will *not* be blocked even if they would
# have been blocked by blacklist entries.
#
 #</pre> <!-- leave this line exactly as it is -->
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside e-mail addresses',

	'spam-blacklisted-email' => 'Blacklisted e-mail address',
	'spam-blacklisted-email-text' => 'Your e-mail address is currently blacklisted from sending e-mails to other users.',
	'spam-blacklisted-email-signup' => 'The given e-mail address is currently blacklisted from use.',

	'spam-invalid-lines' =>	"The following spam blacklist {{PLURAL:$1|line is an|lines are}} invalid regular {{PLURAL:$1|expression|expressions}} and {{PLURAL:$1|needs|need}} to be corrected before saving the page:",
	'spam-blacklist-desc' => 'Regex-based anti-spam tool: [[MediaWiki:Spam-blacklist]] and [[MediaWiki:Spam-whitelist]]',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author SPQRobin
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'spam-blacklist' => "See also: [[MediaWiki:spam-whitelist]] and [[MediaWiki:captcha-addurl-whitelist]]. You can translate the text, including 'Leave this line exactly as it is'. Some lines of this messages have one (1) leading space.",
	'spam-whitelist' => "See also: [[MediaWiki:spam-blacklist]] and [[MediaWiki:captcha-addurl-whitelist]]. You can translate the text, including 'Leave this line exactly as it is'. Some lines of this messages have one (1) leading space.",
	'spam-blacklisted-email' => 'Title of errorpage when trying to send an email with a blacklisted e-mail address',
	'spam-blacklisted-email-text' => 'Text of errorpage when trying to send an e-mail with a blacklisted e-mail address',
	'spam-blacklisted-email-signup' => 'Error when trying to create an account with an invalid e-mail address',
	'spam-blacklist-desc' => '{{desc}}',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'spam-blacklist' => " # As URLs externas que concuerden con ista lista serán bloqueyatas quan s'encluyan en una pachina.
 # Ista lista afecta sólo ta ista wiki; mire-se tamién a lista negra global.
 # Más decumentación en https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# A sintaxi ye asinas:
#  * Tot o que bi ha dende un carácter \"#\" dica a fin d'a linia ye un comentario
#  * As linias no buedas son fragmentos d'expresions regulars que sólo concordarán con hosts adintro d'as URLs

 #</pre> <!-- leave this line exactly as it is -->",
	'spam-whitelist' => " #<!-- leave this line exactly as it is --> <pre>
# As URLs externas que concuerden con ista lista *no* serán bloqueyatas
# mesmo si han estato bloqueyatas por dentradas d'a lista negra.
#
#  A sintaxi ye asinas:
#  * Tot o que bi ha dende o carácter \"#\" dica a fin d'a linia ye un comentario
#  * As linias no buedas ye un fragmento d'expresión regular que sólo concordarán con hosts adintro d'as URLs

 #</pre> <!-- leave this line exactly as it is -->",
	'spam-invalid-lines' => "{{PLURAL:$1|A linia siguient ye una|As linias siguients son}} {{PLURAL:$1|expresión regular|expresions regulars}} y {{PLURAL:$1|ha|han}} d'estar correchitas antes d'alzar a pachina:",
	'spam-blacklist-desc' => 'Ferramienta anti-spam basata en expresions regulars (regex): [[MediaWiki:Spam-blacklist]] y [[MediaWiki:Spam-whitelist]]',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'spam-blacklist' => ' # الوصلات الخارجية التي تطابق هذه القائمة سيتم منعها عند إضافتها لصفحة.
 # هذه القائمة تؤثر فقط على هذه الويكي؛ ارجع أيضا للقائمة السوداء العامة.
 # للوثائق انظر https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- اترك هذا السطر تماما كما هو --> <pre>
#
# الصيغة كالتالي:
#   * كل شيء من علامة "#" إلى آخر السطر هو تعليق
#   * كل سطر غير فارغ هو تعبير منتظم يوافق فقط المضيفين داخل الوصلات الخارجية

 #</pre> <!-- اترك هذا السطر تماما كما هو -->',
	'spam-whitelist' => ' #<!-- اترك هذا السطر تماما كما هو --> <pre>
# الوصلات الخارجية التي تطابق هذه القائمة *لن* يتم منعها حتى لو
# كانت ممنوعة بواسطة مدخلات القائمة السوداء.
#
# الصيغة كالتالي:
#   * كل شيء من علامة "#" إلى آخر السطر هو تعليق
#   * كل سطر غير فارغ هو تعبير منتظم يطابق فقط المضيفين داخل الوصلات الخارجية

 #</pre> <!-- اترك هذا السطر تماما كما هو -->',
	'spam-invalid-lines' => '{{PLURAL:$1||السطر التالي|السطران التاليان|السطور التالية}} في قائمة السبام السوداء {{PLURAL:$1|ليس تعبيرًا منتظمًا صحيحًا|ليسا تعبيرين منتظمين صحيحين|ليست تعبيرات منتظمة صحيحة}}  و{{PLURAL:$1||يحتاج|يحتاجان|تحتاج}} إلى أن {{PLURAL:$1||يصحح|يصححان|تصحح}} قبل حفظ الصفحة:',
	'spam-blacklist-desc' => 'أداة ضد السبام تعتمد على التعبيرات المنتظمة: [[MediaWiki:Spam-blacklist]] و [[MediaWiki:Spam-whitelist]]',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'spam-blacklist' => ' # اللينكات الخارجية اللى بتطابق الليستة دى ح تتمنع لما تضاف لصفحة.
 # اللستة دى بتأثر بس على الويكى دى؛ ارجع كمان للبلاك ليست العامة.
 # للوثايق شوف https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- سيب السطر دا زى ما هو كدا بالظبط--> <pre>
#
# الصيغة كدا:
#  * كل حاجة من علامة "#" لحد آخر السطر هو تعليق
#  * كل سطر مش فاضى هو تعبير منتظم بيوافق بس المضيفين جوه الوصلات الخارجية

 #</pre> <!-- سيب السطر دا زى ما هو كدا بالظبط-->',
	'spam-whitelist' => ' #<!-- سيب السطر دا زى ما هو كدا بالظبط --> <pre>
# اللينكات الخارجية اللى بتطابق اللستة دى *مش* ح تتمنع حتى لو
# كانت ممنوعة بواسطة مدخلات البلاك ليست.
#
# الصيغة كدا:
#  * كل حاجة من علامة "#" لحد آخر السطر هو تعليق
#  * كل سطر مش فاضى هو تعبير منتظم بيطابق بس المضيفين جوه الوصلات الخارجية

 #</pre> <!-- سيب السطر دا زى ما هو كدا بالظبط-->',
	'spam-invalid-lines' => '{{PLURAL:$1|السطر دا|السطور دول}} اللى فى السبام بلاك ليست {{PLURAL:$1|هو تعبير منتظم |هى تعبيرات منتظمة}} مش صح و {{PLURAL:$1|محتاج|محتاجين}} تصليح قبل حفظ الصفحة:',
	'spam-blacklist-desc' => 'اداة انتي-سبام مبنية على اساس ريجيكس: [[MediaWiki:Spam-blacklist]] و [[MediaWiki:Spam-whitelist]]',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'spam-blacklist' => ' # Les URLs que casen con esta llista se bloquiarán cuando s\'añadan a una páxina.
 # Esta llista afeuta namái a esta wiki; mira tamién la llista negra global.
 # Pa ver la documentación visita https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- dexa esta llinia exautamente como ta --> <pre>
#
# La sintaxis ye ésta:
#  * Tol testu dende un caráuter "#" hasta lo cabero la llinia ye un comentariu
#  * Toa llinia non balera ye un fragmentu regex qu\'afeuta namái a los sirvidores de les URLs

 #</pre> <!-- dexa esta llinia exautamente como ta -->',
	'spam-whitelist' => " #<!-- dexa esta llinia exautamente como ta --> <pre>
# Les URLs esternes d'esta llista *nun* sedrán bloquiaes inda si lo fueron per aciu
# d'una entrada na llista negra.
#
# La sintaxis ye ésta:
#  * Tol testu dende un caráuter \"#\" hasta lo cabero la llina ye un comentariu
#  * Toa llinia non vacia ye un fragmentu regex qu'afeuta namái a les URLs especificaes

 #</pre> <!-- dexa esta llinia exautamente como ta -->",
	'email-blacklist' => ' # Los correos que casen con esta llista tendrán torgao rexistrase o unviar corréu.
 # Esta llista afeuta namái a esta wiki; mira tamién la llista negra global.
 # Pa ver la documentación visita https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- dexa esta llinia exautamente como ta --> <pre>
#
# La sintaxis ye esta:
#  * Tol testu dende un caráuter "#" hasta lo cabero la llinia ye un comentariu
#  * Toa llinia non balera ye un fragmentu regex qu\'afeuta namái a los sirvidores de corréu

 #</pre> <!-- dexa esta llinia exautamente como ta -->',
	'email-whitelist' => '#<!-- Dexa esta llinia tal y como ta --> <pre>
# Los correos que casen con esta llista *nun* se bloquiarán, incluío si
# los hubieren bloquiao entraes de la llista negra.
#
 #</pre> <!-- Dexa esta llinia tal y como ta -->
# La sintaxis ye esta:
#  * Tol testu dende un caráuter "#" hasta lo cabero la llinia ye un comentariu
#  * Toa llinia non balera ye un fragmentu regex qu\'afeuta namái a los sirvidores de corréu',
	'spam-blacklisted-email' => 'Corréu electrónicu de la llista negra',
	'spam-blacklisted-email-text' => 'El to corréu electrónicu anguaño ta na llista negra y nun pue unviar correos electrónicos a otros usuarios.',
	'spam-blacklisted-email-signup' => "La direición de corréu electrónicu que se dio tien torgáu l'usu por tar anguaño na llista negra.",
	'spam-invalid-lines' => '{{PLURAL:$1|La siguiente llinia|Les siguientes llinies}} de la llista negra de spam {{PLURAL:$1|ye una espresión regular non válida|son espresiones regulares non válides}} y {{PLURAL:$1|necesita ser correxida|necesiten ser correxíes}} enantes de guardar la páxina:',
	'spam-blacklist-desc' => "Ferramienta antispam basada n'espresiones regulares: [[MediaWiki:Spam-blacklist]] y [[MediaWiki:Spam-whitelist]]",
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'spam-blacklist' => ' # Был исемлеккә тап килгән тышҡы һылтанмаларҙы биттәргә өҫтәү тыйыласаҡ.
 # Был исемлек ошо вики өсөн генә ғәмәлгә эйә, шулай уҡ дөйөм ҡара исемлек бар.
 # Тулыраҡ мәғлүмәт өсөн https://www.mediawiki.org/wiki/Extension:SpamBlacklist ҡарағыҙ
 #<!-- был юлды үҙгәртмәгеҙ --><pre>
#
# Синтаксис:
# * # хәрефенән башлап юл аҙағына тиклем барыһы ла иҫкәрмә тип иҫәпләнә
# * Һәр буш булмаған юл URL эсендәге төйөнгә генә ҡулланылған регуляр аңлатманың өлөшө булып тора

 #</pre><!-- был юлды үҙгәртмәгеҙ -->',
	'spam-whitelist' => '#<!-- был юлды нисек бар, шулай ҡалдырығыҙ --> <pre>
# Был исемлеккә тап килгән тышҡы һылтанмаларҙы биттәргә өҫтәү, хатта улар ҡара исемлектә булһалар ҙа, *тыйылмаясаҡ*.
#
# Синтаксис:
# * # хәрефенән башлап юл аҙағына тиклем барыһы ла иҫкәрмә тип иҫәпләнә
# * Һәр буш булмаған юл URL эсендәге төйөнгә генә ҡулланылған регуляр аңлатманың өлөшө булып тора
#</pre> <!-- был юлды нисек бар, шулай ҡалдырығыҙ -->',
	'spam-invalid-lines' => 'Түбәндәге ҡара исемлек {{PLURAL:$1|юлында|юлдарында}} хаталы регуляр {{PLURAL:$1|аңлатма|аңлатмалар}} бар һәм {{PLURAL:$1|ул|улар}} битте һаҡлар алдынан төҙәтелергә тейеш:',
	'spam-blacklist-desc' => 'Регуляр аңлатмаларға нигеҙләнгән спамға ҡаршы ҡорал: [[MediaWiki:Spam-blacklist]] һәм [[MediaWiki:Spam-whitelist]]',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'spam-blacklist-desc' => 'وسیله په ضد اسپم په اساس عبارات منظم:  [[MediaWiki:Spam-blacklist]] و [[MediaWiki:Spam-whitelist]]',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'spam-blacklist' => ' # Вонкавыя спасылкі, якія будуць адпавядаць гэтаму сьпісу, будуць блякавацца пры 
 # спробе даданьня на старонку.
 # Гэты сьпіс будзе дзейнічаць толькі ў гэтай вікі; існуе таксама і глябальны чорны сьпіс.
 # Дакумэнтацыю гэтай функцыі глядзіце на https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- пакіньце гэты радок такім, які ён ёсьць --> <pre>
#
# Сынтаксіс наступны:
#  * Усё, што пачынаецца з «#» і да канца радку, зьяўляецца камэнтарам
#  * Усе непустыя радкі зьяўляюцца часткамі рэгулярнага выразу, які будзе выкарыстоўвацца толькі
# ў дачыненьні да назваў сэрвэраў у вонкавых спасылках

 #</pre> <!-- пакіньце гэты радок такім, які ён ёсьць -->',
	'spam-whitelist' => ' #<!-- пакіньце гэты радок такім, які ён ёсьць --> <pre>
# Вонкавыя спасылкі, якія будуць адпавядаць гэтаму сьпісу, *ня* будуць блякавацца, нават калі яны 
# будуць адпавядаць чорнаму сьпісу
#
# Сынтаксіс наступны:
#  * Усё, што пачынаецца з «#» і да канца радка, зьяўляецца камэнтарам
#  * Усе непустыя радкі зьяўляюцца часткамі рэгулярнага выразу, які будзе выкарыстоўвацца толькі
# ў дачыненьні да назваў сэрвэраў у вонкавых спасылках

 #</pre> <!-- пакіньце гэты радок такім, які ён ёсьць -->',
	'email-blacklist' => ' # Электронныя лісты, якія будуць адпавядаць гэтаму сьпісу, будуць блякавацца пры 
 # спробе адпраўкі.
 # Гэты сьпіс будзе дзейнічаць толькі ў гэтай вікі; існуе таксама і глябальны чорны сьпіс.
 # Дакумэнтацыю гэтай функцыі глядзіце на https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- пакіньце гэты радок такім, які ён ёсьць --> <pre>
#
# Сынтаксіс наступны:
#  * Усё, што пачынаецца з «#» і да канца радку, зьяўляецца камэнтарам
#  * Усе непустыя радкі зьяўляюцца часткамі рэгулярнага выразу, які будзе выкарыстоўвацца толькі
# ў дачыненьні да назваў сэрвэраў у электронных лістах

 #</pre> <!-- пакіньце гэты радок такім, які ён ёсьць -->',
	'email-whitelist' => ' #<!-- пакіньце гэты радок такім, які ён ёсьць --> <pre>
 # Электронныя лісты, якія будуць адпавядаць гэтаму сьпісу, ня будуць блякавацца, нават  
 # калі яны будуць у чорным сьпісе. 
 #
 #</pre> <!-- пакіньце гэты радок такім, які ён ёсьць -->
# Сынтаксіс наступны:
#  * Усё, што пачынаецца з «#» і да канца радку, зьяўляецца камэнтарам
#  * Усе непустыя радкі зьяўляюцца часткамі рэгулярнага выразу, які будзе выкарыстоўвацца толькі
# ў дачыненьні да назваў сэрвэраў у электронных лістах',
	'spam-blacklisted-email' => 'Адрасы электроннай пошты з чорнага сьпісу',
	'spam-blacklisted-email-text' => 'З Вашага адрасу электроннай пошты ў цяперашні момант забаронена дасылаць электронныя лісты іншым удзельнікам.',
	'spam-blacklisted-email-signup' => 'Пададзены Вамі адрас электроннай пошты ў цяперашні момант знаходзіцца ў чорным сьпісе.',
	'spam-invalid-lines' => '{{PLURAL:$1|Наступны радок чорнага сьпісу ўтрымлівае няслушны рэгулярны выраз|Наступныя радкі чорнага сьпісу ўтрымліваюць няслушныя рэгулярныя выразы}} і {{PLURAL:$1|павінен быць|павінныя быць}} выпраўлены перад захаваньнем старонкі:',
	'spam-blacklist-desc' => 'Антыспамавы інструмэнт, які базуецца на рэгулярных выразах: [[MediaWiki:Spam-blacklist]] і [[MediaWiki:Spam-whitelist]]',
);

/** Bulgarian (Български)
 * @author Spiritia
 */
$messages['bg'] = array(
	'spam-invalid-lines' => '{{PLURAL:$1|Следният запис|Следните записи}} от черния списък на спама {{PLURAL:$1|е невалиден регулярен израз|са невалидни регулярни изрази}} и  трябва да {{PLURAL:$1|бъде коригиран|бъдат коригирани}} преди съхраняване на страницата:',
	'spam-blacklist-desc' => 'Инструмент за защита от спам, използващ регулярни изрази: [[МедияУики:Spam-blacklist]] и [[МедияУики:Spam-whitelist]]',
);

/** Banjar (Bahasa Banjar)
 * @author Alamnirvana
 */
$messages['bjn'] = array(
	'spam-invalid-lines' => 'Baris-baris nang maumpati ini manggunaakan ungkapan nalar nang kahada sah. Silakan dibaiki daptar hirang ini sabalum manyimpannya:',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'spam-blacklist' => '
 # এই তালিকার সাথে মিলে যায় এমন বহিঃসংযোগ URLগুলি পাতায় যোগ করতে বাধা দেয়া হবে।
 # এই তালিকাটি কেবল এই উইকির ক্ষেত্রে প্রযোজ্য; সামগ্রিক কালোতালিকাও দেখতে পারেন।
 # ডকুমেন্টেশনের জন্য https://www.mediawiki.org/wiki/Extension:SpamBlacklist দেখুন
 #<!-- leave this line exactly as it is --> <pre>
#
# সিনট্যাক্স নিচের মত:
#  * "#" ক্যারেক্টার থেকে শুরু করে লাইনের শেষ পর্যন্ত সবকিছু একটি মন্তব্য
#  * প্রতিটি অশূন্য লাইন একটি রেজেক্স খণ্ডাংশ যেটি কেবল URLগুলির ভেতরের hostগুলির সাথে মিলে যাবে

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' #<!-- এই লাইন যেমন আছে ঠিক তেমনই ছেড়ে দিন --> <pre>
# External URLs matching this list will *not* be blocked even if they would
# have been blocked by blacklist entries.
#
# Syntax is as follows:
#  * Everything from a "#" character to the end of the line is a comment
#  * Every non-blank line is a regex fragment which will only match hosts inside URLs

 #</pre> <!-- এই লাইন যেমন আছে ঠিক তেমনই ছেড়ে দিন -->',
	'spam-invalid-lines' => 'নিচের স্প্যাম কালোতালিকার {{PLURAL:$1|লাইন|লাইনগুলি}} অবৈধ রেগুলার {{PLURAL:$1|এক্সপ্রেশন|এক্সপ্রেশন}} ধারণ করছে এবং পাতাটি সংরক্ষণের আগে এগুলি ঠিক করা {{PLURAL:$1|প্রয়োজন|প্রয়োজন}}:',
	'spam-blacklist-desc' => 'রেজেক্স-ভিত্তিক স্প্যামরোধী সরঞ্জাম: [[MediaWiki:Spam-blacklist]] এবং [[MediaWiki:Spam-whitelist]]',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'spam-blacklist' => '  # Stanket e vo an URLoù diavaez a glot gant ar roll-mañ ma vezont ouzhpennet en ur bajenn.
  # Ne sell ar roll-mañ nemet ouzh ar wiki-mañ ; sellit ivez ouzh al listenn zu hollek.
  # Aze emañ an titouroù https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- leave this line exactly as it is --> <pre>
#
# Setu doare an ereadur :
#  * Pep tra adalek un arouezenn "#" betek dibenn al linenn zo un evezhiadenn
#  * Kement linenn anc\'houllo zo un darnad lavarenn reoliek na gloto nemet gant an ostizien el liammoù gourskrid

  #</pre> <!-- lezel al linenn-mañ tre evel m\'emañ -->',
	'spam-whitelist' => "  #<!-- lezel al linenn-mañ tre evel m'emañ --> <pre>
# *Ne vo ket* stanket al liammoù gourskrid a glot gant al listenn-mañ
# ha pa vijent bet stanket gant monedoù ar listenn zu.
#
# Setu an eredur :
#  * Pep tra adalek un arouezenn \"#\" betek dibenn al linenn zo un ev evezhiadenn
#  * Kement linenn anc'houllo zo un darnad skrid poellek na zielfennno nemet an ostizien el liammoù gourskrid

  #</pre> <!-- lezel al linenn-mañ tre evel m'emañ -->",
	'spam-blacklisted-email' => "Chomlec'hioù postel ha listenn zu",
	'spam-blacklisted-email-text' => "Evit ar mare emañ ho chomlec'h postel war ul listenn zu ha n'haller ket kas posteloù drezañ d'an implijerien all.",
	'spam-blacklisted-email-signup' => "War ul listenn zu emañ ar chomlec'h postel pourchaset. N'hall ket bezañ implijet.",
	'spam-invalid-lines' => '{{PLURAL:$1|Ul lavarenn|Lavarennoù}} reoliek direizh eo {{PLURAL:$1|al linenn|al linennoù}} da-heul eus roll du ar stroboù ha ret eo {{PLURAL:$1|he reizhañ|o reizhañ}} a-raok enrollañ ar bajenn :',
	'spam-blacklist-desc' => 'Ostilh enep-strob diazezet war lavarennoù reoliek (Regex) : [[MediaWiki:Spam-blacklist]] ha [[MediaWiki:Spam-whitelist]]',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'spam-blacklist' => '# Vanjski URLovi koji odgovaraju ovom spisku će biti blokirani ako se dodaju na stranicu.
 # Ovaj spisak će biti aktivan samo na ovoj wiki; a poziva se i na globalni zabranjeni spisak.
 # Za objašenjenja i dokumentaciju pogledajte https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- ostavite ovaj red tačno onako kakav je --> <pre>
#
# Sintaksa je slijedeća:
#  * Sve od znaka "#" do kraja reda je komentar
#  * Svi neprazni redovi su fragmenti regexa koji će odgovarati samo domaćinima unutar URLova

 #</pre> <!-- ostavite ovaj red tačno onako kakav je -->',
	'spam-whitelist' => '#<!-- ostavite ovaj red onakav kakav je --> <pre>
# Vanjski URLovi koji odgovaraju nekoj od stavki na ovom spisku *neće* biti blokirani čak iako
# budu blokirani preko spisak nepoželjnih stavki.
#
# Sintaksa je slijedeća:
#  * Sve od znaka "#" do kraja reda je komentar
#  * Svaki neprazni red je fragment regexa koji će odgovarati samo domaćinima unutar URLa

 #</pre> <!-- ostavite ovaj red onakav kakav je -->',
	'spam-invalid-lines' => 'Slijedeći {{PLURAL:$1|red|redovi}} u spisku spam nepoželjnih stavki {{PLURAL:$1|je nevalidan izraz|su nevalidni izrazi}} i {{PLURAL:$1|treba|trebaju}} se ispraviti prije spremanja stranice:',
	'spam-blacklist-desc' => 'Alati protiv spama zasnovani na regexu: [[MediaWiki:Spam-blacklist]] i [[MediaWiki:Spam-whitelist]]',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author SMP
 */
$messages['ca'] = array(
	'spam-blacklist' => ' # Les URLs externes coincidents amb aquesta llista seran bloquejades en ser afegides a una pàgina.
 # Aquesta llista afecta només a aquesta wiki; vegeu també la llista negra global.
 # Per a més informació vegeu https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- deixeu aquesta línia exactament com està --> <pre>
#
# La sintaxi és com segueix:
#  * Tot allò des d\'un caràcter "#" fins al final de la línia és un comentari
#  * Cada línia que no estigui en blanc és un fragment regex que només coincidirà amb amfitrions dintre d\'URLs

 #</pre> <!-- deixeu aquesta línia exactament com està -->',
	'spam-whitelist' => " #<!-- deixeu aquesta línia tal com està --> <pre>
# Les adreces URL externes que apareguin en aquesta llista no seran blocades
# fins i tot si haurien estat blocades per aparèixer a la llista negra.
#
# La sintaxi és la següent:
#   * Tot allò que hi hagi des d'un símbol '#' fins a la fi de línia és un comentari
#   * Cada línia no buida és un fragment d'expressió regular (regex) que només marcarà hosts dins les URL

 #</pre> <!-- deixeu aquesta línia tal com està -->",
	'spam-invalid-lines' => "{{PLURAL:$1|La línia següent no es considera una expressió correcta|Les línies següents no es consideren expressions correctes}} {{PLURAL:$1|perquè recull|perquè recullen}} SPAM que està vetat. Heu d'esmenar-ho abans de salvar la pàgina:",
	'spam-blacklist-desc' => 'Eina anti-spam basada en regexp: [[MediaWiki:Spam-blacklist]] i [[MediaWiki:Spam-whitelist]]',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'spam-blacklist' => ' # Externí URL odpovídající tomuto seznamu budou zablokovány při pokusu přidat je na stránku.
 # Tento seznam ovlivňuje jen tuto wiki; podívejte se také na globální černou listinu.
 # Dokumentaci najdete na https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Nechte tento řádek přesně tak jak je --> <pre>
#
# Syntaxe je následující:
#  * Všechno od znaku „#“ do konce řádku je komentář
#  * Každý neprázdný řádek je část regulárního výrazu, kterému budou odpovídat pouze domény z URL

 #</pre> <!-- Nechte tento řádek přesně tak jak je -->',
	'spam-whitelist' => ' #<!-- nechejte tento řádek přesně tak jak je --> <pre>
# Externí URL odpovídající výrazům v tomto seznamu *nebudou* zablokovány, ani kdyby
# je zablokovaly položky z černé listiny.
#
# Syntaxe je následující:
#  * Všechno od znaku „#“ do konce řádku je komentář
#  * Každý neprázdný řádek je část regulárního výrazu, kterému budou odpovídat pouze domény z URL

 #</pre> <!-- nechejte tento řádek přesně tak jak je -->',
	'email-blacklist' => ' # Z e-mailů vyhovujících tomuto seznamu nebude možno zaregistrovat účet ani odesílat e-mail.
 # Tento seznam ovlivňuje jen tuto wiki; vizte také globální černou listinu.
 # Dokumentaci najdete na https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- tuto řádku ponechte přesně tak, jak je --> <pre>
#
# Syntaxe je následující:
#  * Všechno od znaku „#“ do konce řádku je komentář
#  * Každý neprázdný řádek je část regulárního výrazu, kterému budou odpovídat pouze domény v e-mailových adresách

 #</pre> <!-- tuto řádku ponechte přesně tak, jak je -->',
	'email-whitelist' => ' #<!-- tuto řádku ponechte přesně tak, jak je --> <pre>
# E-maily vyhovující tomuto seznamu *nebudou* blokovány, i kdyby
# odpovídaly záznamům v černé listině.
#
# Syntaxe je následující:
#  * Všechno od znaku „#“ do konce řádku je komentář
#  * Každý neprázdný řádek je část regulárního výrazu, kterému budou odpovídat pouze domény v e-mailových adresách
 #</pre> <!-- tuto řádku ponechte přesně tak, jak je -->',
	'spam-blacklisted-email' => 'E-mail na černé listině',
	'spam-blacklisted-email-text' => 'Vaše e-mailová adresa je momentálně uvedena na černé listině, takže ostatním uživatelům nemůžete posílat e-maily.',
	'spam-blacklisted-email-signup' => 'Uvedená e-mailová adresa je v současné době na černé listině.',
	'spam-invalid-lines' => 'Na černé listině spamu {{PLURAL:$1|je následující řádka neplatný regulární výraz|jsou následující řádky neplatné regulární výrazy|jsou následující řádky regulární výrazy}} a je nutné {{PLURAL:$1|ji|je|je}} před uložením stránky opravit :',
	'spam-blacklist-desc' => 'Antispamový nástroj na základě regulárních výrazů: [[MediaWiki:Spam-blacklist]] a [[MediaWiki:Spam-whitelist]]',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'spam-blacklist' => "# Dyma restr o gyfeiriadau URL allanol; os osodir un o'r rhain ar dudalen fe gaiff ei flocio.
 # Ar gyfer y wici hwn yn unig mae'r rhestr hon; mae rhestr gwaharddedig led-led yr holl wicïau i'w gael.
 # Gweler https://www.mediawiki.org/wiki/Extension:SpamBlacklist am ragor o wybodaeth.
 #<!-- leave this line exactly as it is --> <pre>
#
# Dyma'r gystrawen:
#   * Mae popeth o nod \"#\" hyd at ddiwedd y llinell yn sylwad
#   * Mae pob llinell nad yw'n wag yn ddarn regex sydd ddim ond yn cydweddu 
#   * gwesteiwyr tu mewn i gyfeiriadau URL

 #</pre> <!-- leave this line exactly as it is -->",
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# *Ni fydd* cyfeiriadau URL allanol sydd ar y rhestr hon yn cael eu blocio
# hyd yn oed pan ydynt ar restr arall o gyfeiriadau URL gwaharaddedig.
#
# Dyma\'r gystrawen:
#   * Mae popeth o nod "#" hyd at ddiwedd y llinell yn sylwad
#   * Mae pob llinell nad yw\'n wag yn ddarn regex sydd ddim ond yn cydweddu 
#   * gwesteiwyr tu mewn i gyfeiriadau URL

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-invalid-lines' => "Mae'r {{PLURAL:$1|llinell|llinell|llinellau|llinellau|llinellau|llinellau}} canlynol ar y rhestr spam gwaharddedig yn {{PLURAL:$1|fynegiad|fynegiad|fynegiadau|fynegiadau|fynegiadau|fynegiadau}} rheolaidd annilys; rhaid {{PLURAL:ei gywiro|ei gywiro|eu cywiro|eu cywiro|eu cywiro|eu cywiro}} cyn rhoi'r dudalen ar gadw:",
	'spam-blacklist-desc' => 'Teclyn gwrth-spam yn seiliedig ar regex: [[MediaWiki:Spam-blacklist]] a [[MediaWiki:Spam-whitelist]]',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'spam-blacklist' => ' # Externe URLs, die in dieser Liste enthalten sind, blockieren das Speichern einer Seite.
 # Diese Liste hat nur Auswirkungen auf dieses Wiki. Siehe ggf. auch die globale Blockierliste.
 # Siehe auch https://www.mediawiki.org/wiki/Extension:SpamBlacklist für die Dokumentation dieser Funktion. 
 #<!-- Diese Zeile darf nicht verändert werden! --> <pre>
#
# Syntax:
#   * Alles ab dem „#“-Zeichen bis zum Ende der Zeile ist ein Kommentar
#   * Jede nicht-leere Zeile ist ein regulärer Ausdruck, der gegen die Host-Namen in den URLs geprüft wird.

 #</pre> <!-- Diese Zeile darf nicht verändert werden! -->',
	'spam-whitelist' => ' #<!-- Diese Zeile darf nicht verändert werden! --> <pre>
# Externe URLs, die in dieser Liste enthalten sind, blockieren das Speichern einer Seite nicht, 
# auch wenn sie in der lokalen oder ggf. globalen Blockierliste enthalten sind.
#
# Syntax:
#   * Alles ab dem „#“-Zeichen bis zum Ende der Zeile ist ein Kommentar
#   * Jede nicht-leere Zeile ist ein regulärer Ausdruck, der gegen die Host-Namen in den URLs geprüft wird.

 #</pre> <!-- Diese Zeile darf nicht verändert werden! -->',
	'email-blacklist' => ' # E-Mail-Adressen, die in dieser Liste enthalten sind, blockieren die Registrierung sowie das Senden von E-Mail-Nachrichten.
 # Diese Liste hat nur Auswirkungen auf dieses Wiki. Siehe ggf. auch die globale Blockierliste.
 # Siehe auch https://www.mediawiki.org/wiki/Extension:SpamBlacklist für die Dokumentation dieser Funktion.
 #<!-- Diese Zeile darf nicht verändert werden! --> <pre>
#
# Syntax:
#   * Alles ab dem „#“-Zeichen bis zum Ende der Zeile ist ein Kommentar
#   * Jede nicht-leere Zeile ist ein regulärer Ausdruck, der gegen die Host-Namen in den E-Mail-Adressen geprüft wird.

 #</pre> <!-- Diese Zeile darf nicht verändert werden! -->',
	'email-whitelist' => ' #<!-- Diese Zeile darf nicht verändert werden! --> <pre>
# E-Mail-Adressen, die sich in dieser Liste befinden, blockieren die Registrierung sowie
# das Senden von E-Mail-Nachrichten *nicht*, auch wenn sie in der 
# lokalen oder ggf. globalen Blockierliste enthalten sind.
#
 #</pre> <!-- Diese Zeile darf nicht verändert werden! -->',
	'spam-blacklisted-email' => 'Blockierte E-Mail-Adressen',
	'spam-blacklisted-email-text' => 'Deine E-Mail-Adresse ist derzeit für das Senden von E-Mail-Nachrichten an andere Benutzer blockiert.',
	'spam-blacklisted-email-signup' => 'Die angegebene E-Mail-Adresse ist derzeit für das Senden von E-Mail-Nachrichten an andere Benutzer blockiert.',
	'spam-invalid-lines' => 'Die {{PLURAL:$1|folgende Zeile|folgenden Zeilen}} in der Blockierliste {{PLURAL:$1|ist ein ungültiger regulärer Ausdruck|sind ungültige reguläre Ausdrücke}}. Sie {{PLURAL:$1|muss|müssen}} vor dem Speichern der Seite korrigiert werden:',
	'spam-blacklist-desc' => 'Ermöglicht ein, durch reguläre Ausdrücke gestütztes, Anti-Spam-Werkzeug: [[MediaWiki:Spam-blacklist]] und [[MediaWiki:Spam-whitelist]]',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'spam-blacklisted-email-text' => 'Ihre E-Mail-Adresse ist derzeit für das Senden von E-Mail-Nachrichten an andere Benutzer blockiert.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 */
$messages['diq'] = array(
	'spam-blacklist' => '  #gıreyê teber ê ke na liste de zêpi bi bloke beni.
  # na liste tena no wiki re tesir beno.
  # Dokümantasyon: https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- no satır zey xo verdê --> <pre>
#
# rêzvateyê ey zey cêr o.:
#  * "#" karakteri ra heta satıro peyin her çi mışoreyo
#  * Her satıro dekerde, pêşkeşwan ê ke zerreyê URLlyi de tena parçeyê regexê .

  #</pre> <!-- no satır zey xo verdê -->',
	'spam-whitelist' => '  #<!-- no satır zey xo verdê --> <pre>
# gıreyê teber ê ke na liste de zêpi yê *bloke nêbeni*,
# wazeno pê listeya siya zi bloke bıbo.
#
# rêzvate zey cêr o:
#  * "#" karakteri raheta satıro peyin her çi mışoreyo
#  * Her satıro dekerde, pêşkeşwan ê ke zerreyê URLlyi de tena parçeyê regexê .

  #</pre> <!--no satır zey xo verdê -->',
	'spam-invalid-lines' => 'na qerelisteya spami {{PLURAL:$1|satır|satıran}}  {{PLURAL:$1|nemeqbulo|nemeqbuli}};',
	'spam-blacklist-desc' => 'Regex-tabanlı anti-spam aracı: [[MediaWiki:Spam-blacklist]] ve [[MediaWiki:Spam-whitelist]]',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'spam-blacklist' => ' # Eksterne URL, kótarež su w toś tej lisćinje, blokěruju se, gaž pśidawaju se bokoju.
 # Toś ta lisćina nastupa jano toś ten wiki; glědaj teke globalnu cornu lisćinu.
 # Za dokumentaciju glědaj https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Wóstaj toś tu smužka rowno tak ako jo --><pre>
#
# Syntaksa jo ako slědujo:
#  * Wšykno wót znamuška "#" až ku kóńcoju smužki jo komentar
# Kužda smužka, kótaraž njejo prozna, jo fragment regularnego wuraza, kótaryž wótpowědujo hostam w URL

 #</pre> <!-- wóstaj toś tu smužku rowno ako jo -->',
	'spam-whitelist' => ' #<!-- wóstaj toś tu smužka rowno tak ako jo --> <pre>
 # Eksterne URL, kótarež sw toś tej lisćinje se *nje*blokěruju, samo jolic wone by
 # se blokěrowali pśez zapiski corneje lisćiny.
 #
 # Syntaksa jo ako slědujo:
 #  * Wšykno wót znamuška "#" ku kóńcoju smužki jo komentar
 #  * Kužda smužka, kótaraž njejo prozna, jo fragment regularanego wuraza, kótaryž wótpowědujo jano hostam w URL

 #</pre> <!-- wóstaj toś tu smužku rowno tak ako jo -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Slědujuca smužka|Slědujucej smužce|Slědujuce smužki|Slědujuce smužki}} corneje lisćiny spama {{PLURAL:$1|jo njepłaśiwy regularny wuraz|stej njepłaśiwej regularnej wuraza|su njepłaśiwe regularne wuraze|su njepłaśiwe regularne wuraze}} a {{PLURAL:$1|musy|musytej|muse|muse}} se korigěrowaś, pjerwjej až składujoš bok:',
	'spam-blacklist-desc' => 'Antispamowy rěd na zakłaźe regularnych wurazow: [[MediaWiki:Spam-blacklist]] a [[MediaWiki:Spam-whitelist]]',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 */
$messages['el'] = array(
	'spam-blacklist' => ' # Εξωτερικά URLs που ταιριάζουν σε αυτή τη λίστα θα φραγούν όταν προστίθενται σε μία σελίδα.
 # Αυτή η λίστα επηρεάζει μόνο αυτό το wiki· αναφερθείτε επίσης στην καθολική μαύρη λίστα.
 # Για τεκμηρίωση δείτε τον σύνδεσμο https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Η σύνταξη είναι ως ακολούθως:
#  * Οτιδήποτε από τον χαρακτήρα «#» μέχρι το τέλος της γραμμής είναι ένα σχόλιο
#  * Οποιαδήποτε μη κενή γραμμή είναι ένα κομμάτι κανονικής έκφρασης το οποίο θα ταιριάξει μόνο hosts
#    μέσα σε URLs

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# Εξωτερικά URLs που ταιριάζουν σε αυτή τη λίστα _δεν_ θα φραγούν ακόμα και αν είχαν
# φραγεί από εγγραφές της μαύρης λίστας.
#
# Η σύνταξη είναι ως ακολούθως:
#  * Οτιδήποτε από τον χαρακτήρα «#» μέχρι το τέλος της γραμμής είναι ένα σχόλιο
#  * Οποιαδήποτε μη κενή γραμμή είναι ένα κομμάτι κανονικής έκφρασης το οποίο θα ταιριάξει μόνο hosts
#    μέσα σε URLs

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Η ακόλουθη γραμμή|Οι ακόλουθες γραμμές}} της μαύρης λίστας spam είναι {{PLURAL:$1|άκυρη κανονική έκφραση|άκυρες κανονικές εκφράσεις}} και {{PLURAL:$1|χρειάζεται|χρειάζονται}} διόρθωση πριν την αποθήκευση της σελίδας:',
	'spam-blacklist-desc' => 'Εργαλείο anti-spam βασισμένο σε κανονικές εκφράσεις: [[MediaWiki:Spam-blacklist]] και [[MediaWiki:Spam-whitelist]]',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'spam-blacklist' => '
 #<!-- ne ŝanĝu ĉi tiun linion iel ajn --> <pre>
# Eksteraj URL-oj kongruante al ĉi tiuj listanoj estos forbarita kiam aldonita al paĝo.
# Ĉi tiu listo nur regnas ĉi tiun vikion; ankaux aktivas la ĝenerala nigralisto.
 # Por dokumentaro, rigardu https://www.mediawiki.org/wiki/Extension:SpamBlacklist
#
# Jen la sintakso:
#  * Ĉio ekde "#" signo al la fino de linio estas komento
#  * Ĉiu ne-malplena linio estas regex kodero kiu nur kongruas retnodojn ene de URL-oj

 #</pre> <!-- ne ŝanĝu ĉi tiun linion iel ajn -->',
	'spam-whitelist' => ' #<!-- ne ŝanĝu ĉi tiun linion iel ajn --> <pre>
# Eksteraj URL-oj kongruante al ĉi tiuj listanoj *NE* estos forbarita eĉ se ili estus
# forbarita de nigralisto
#
# Jen la sintakso:
#  * Ĉio ekde "#" signo al la fino de linio estas komento
#  * Ĉiu nemalplena linio estas regex kodero kiu nur kongruas retnodojn ene de URL-oj
 #</pre> <!-- ne ŝanĝu ĉi tiun linion iel ajn -->',
	'spam-invalid-lines' => 'La {{PLURAL:$1|jena linio|jenaj linioj}} de spama nigralisto estas {{PLURAL:$1|nevlidaj regularaj esprimoj|nevlidaj regularaj esprimoj}} kaj devas esti {{PLURAL:$1|korektigita|korektigitaj}} antaŭ savante la paĝon:',
	'spam-blacklist-desc' => 'Regex-bazita kontraŭspamilo: [[MediaWiki:Spam-blacklist]] kaj [[MediaWiki:Spam-whitelist]]',
);

/** Spanish (Español)
 * @author Armando-Martin
 * @author Drini
 * @author Sanbec
 */
$messages['es'] = array(
	'spam-blacklist' => ' # Enlaces externos que coincidan con esta lista serán bloqueados al añadirse a una página
 # Esta lista afecta sólo a esta wiki; 
 # Para documentación mire https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Deje esta línea exactamente como está --> <pre>
#
# La sintaxis es:
#  * Todo lo que aparezca desde un caracter "#" hasta el fin de la línea es un comentario
#  * Toda línea que no esté en blanco es una expresión regular que sólo se cotejará con URLs

 #</pre> <!-- Deje esta línea exactamente como está -->',
	'spam-whitelist' => ' #<!-- Deje esta línea exactamente como está --> <pre>
# URLs externas que coincidan con esta lista *no* serán bloqueadas incluso si coincidiesen
# con una entrada en la lista negra.
#
## La sintaxis es:
#  * Todo lo que aparezca desde un caracter "#" hasta el fin de la línea es un comentario
#  * Toda línea que no esté en blanco es una expresión regular que sólo se cotejará con URLs

 #</pre> <!-- Deje esta línea exactamente como está -->',
	'email-blacklist' => '# Las direcciones de correo electrónico que coincidan con esta lista serán bloqueadas para el registro o envío de e-mails!
# Esta lista afecta a sólo este wiki; Consulte también la lista negra global.
# Para documentación vea https://www.mediawiki.org/wiki/Extension:SpamBlacklist
#<!-- Deje esta línea exactamente como está --> <pre>
#
# La sintaxis es la siguiente:
 #   * Todo texto a la derecha del carácter "#" hasta el final de la línea es un comentario
 #   * Cada línea que no esté en blanco es un fragmento de código que sólo cotejarán los servidores (hosts) con las direcciones de correo electrónico
#</pre> <!-- Deje esta línea exactamente como está -->',
	'email-whitelist' => ' #<!-- Deje esta línea exactamente como está --> <pre>
# Las direcciones de correo electrónico que aparecen en esta lista*no* serán bloqueadas incluso si hubieran
# debido ser bloqueadas por aparecer en la lista negra.
#
 #</pre> <!-- Deje esta línea exactamente como está-->
# La sintaxis es la siguiente:
#  * Todo texto a la derecha del carácter "#" hasta el final de la línea es un comentario
#  * Cada línea que no esté en blanco es un fragmento de código que será cotejada por los servidores (hosts) con las direcciones de correo electrónico',
	'spam-blacklisted-email' => 'Dirección de correo electrónico de la lista negra',
	'spam-blacklisted-email-text' => 'Su dirección de correo electrónico está actualmente en la lista negra y no puede enviar e-mails a otros usuarios.',
	'spam-blacklisted-email-signup' => 'La dirección de correo electrónico dada está actualmente en la lista negra de uso.',
	'spam-invalid-lines' => '{{PLURAL:$1|La siguiente línea|Las siguientes líneas}} de la lista negra de spam {{PLURAL:$1|es una expresión regular inválida|son expresiones regulares inválidas}} y es necesario {{PLURAL:$1|corregirla|corregirlas}} antes de guardar la página:',
	'spam-blacklist-desc' => 'Herramienta anti-spam basada en expresiones regulares [[MediaWiki:Spam-blacklist]] y [[MediaWiki:Spam-whitelist]]',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'spam-blacklist' => ' # Sellele nimekirjale vastavad internetiaadressid blokeeritakse.
 # See nimekiri puudutab ainult seda vikit; uuri ka globaalse musta nimekirja kohta.
 # Dokumentatsioon on asukohas https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Jäta see rida muutmata kujule. --> <pre>
#
# Süntaks on järgmine:
#   * Kõik alates märgist "#" kuni rea lõpuni on kommentaar
#   * Iga rida, mis ei ole tühi, on regulaaravaldise osa, milleks sobib internetiaadressi osadest ainult hostinimi

 #</pre> <!-- Jäta see rida muutmata kujule. -->',
	'spam-whitelist' => ' #<!-- Jäta see rida muutmata kujule. --> <pre>
# Sellele nimekirjale vastavaid internetiaadresse *ei* blokeerita isegi mitte siis
# kui musta nimekirja sissekande järgi võiks nad olla blokeeritud.
#
# Süntaks on järgmine:
#   * Kõik alates märgist "#" kuni rea lõpuni on kommentaar
#   * Iga rida, mis ei ole tühi, on regulaaravaldise osa, milleks sobib internetiaadressi osadest ainult hostinimi

 #</pre> <!-- Jäta see rida muutmata kujule. -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Järgmine rida|Järgmised read}} rämpspostituste mustas nimekirjas on {{PLURAL:$1|vigane regulaaravaldis|vigased regulaaravaldised}} ja {{PLURAL:$1|see|need}} tuleb enne lehekülje salvestamist parandada:',
	'spam-blacklist-desc' => 'Regulaaravaldisel põhinev tööriist: [[MediaWiki:Spam-blacklist]] ja [[MediaWiki:Spam-whitelist]]',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Meisam
 */
$messages['fa'] = array(
	'spam-blacklist' => ' # از درج پیوندهای بیرونی که با این فهرست مطابقت کنند جلوگیری می‌شود.
 # این فهرست فقط روی همین ویکی اثر دارد؛ به فهرست سیاه سراسری نیز مراجعه کنید.
 # برای مستندات به https://www.mediawiki.org/wiki/Extension:SpamBlacklist مراجعه کنید
 #<!-- این سطر را همان‌گونه که هست رها کنید --> <pre>
# دستورات به این شکل هستند:
#  * همه چیز از «#» تا پایان سطر به عنوان توضیح در نظر گرفته می‌شود
#  * هر سطر از متن به عنوان یک دستور از نوع عبارت باقاعده در نظر گرفته می‌شود که فقط  با نام میزبان در نشانی اینترنتی مطابقت داده می‌شود

 #</pre> <!-- این سطر را همان‌گونه که هست رها کنید -->',
	'spam-whitelist' => ' #<!-- این سطر را همان‌گونه که هست رها کنید --> <pre>
# از درج پیوندهای بیرونی که با این فهرست مطابقت کنند جلوگیری نمی‌شود حتی اگر
# در فهرست سیاه قرار داشته باشند.
#
# دستورات به این شکل هستند:
#  * همه چیز از «#» تا پایان سطر به عنوان توضیح در نظر گرفته می‌شود
#  * هر سطر از متن به عنوان یک دستور از نوع عبارت باقاعده در نظر گرفته می‌شود که فقط  با نام میزبان در نشانی اینترنتی مطابقت داده می‌شود

 #</pre> <!-- این سطر را همان‌گونه که هست رها کنید -->',
	'spam-invalid-lines' => '{{PLURAL:$1|سطر|سطرهای}} زیر در فهرست سیاه هرزنگاری دستورات regular expression غیر مجاز {{PLURAL:$1|است|هستند}} و قبل از ذخیره کردن صفحه باید اصلاح {{PLURAL:$1|شود|شوند}}:',
	'spam-blacklist-desc' => 'ابزار ضد هرزنویسی مبتنی بر regular expressions: [[MediaWiki:Spam-blacklist]] و [[MediaWiki:Spam-whitelist]]',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Nike
 */
$messages['fi'] = array(
	'spam-blacklist' => ' # Tämän listan säännöillä voi estää ulkopuolisiin sivustoihin viittaavien osoitteiden lisäämisen.
 # Tämä lista koskee vain tätä wikiä. Tutustu myös globaaliin mustaan listaan.
 # Lisätietoja on osoitteessa https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Älä koske tähän riviin lainkaan --> <pre>
#
# Syntaksi on seuraavankaltainen:
#  * Kaikki #-merkistä lähtien rivin loppuun asti on kommenttia
#  * Jokainen ei-tyhjä rivi on säännöllisen lausekkeen osa, joka tunnistaa vain osoitteissa olevat verkkotunnukset.

 #</pre> <!-- Älä koske tähän riviin lainkaan -->',
	'spam-whitelist' => ' #<!-- älä koske tähän riviin --> <pre>
# Tällä sivulla on säännöt, joihin osuvia ulkoisia osoitteita ei estetä, vaikka ne olisivat estolistalla.
#
# Syntaksi on seuraava:
#  * Kommentti alkaa #-merkistä ja jatkuu rivin loppuun
#  * Muut ei-tyhjät rivit tulkitaan säännöllisen lausekkeen osaksi, joka tutkii vain osoitteissa olevia verkko-osoitteita.

 #</pre> <!-- älä koske tähän riviin -->',
	'spam-invalid-lines' => 'Listalla on {{PLURAL:$1|seuraava virheellinen säännöllinen lauseke, joka|seuraavat virheelliset säännölliset lausekkeet, jotka}} on korjattava ennen tallentamista:',
	'spam-blacklist-desc' => 'Säännöllisiä lausekkeita tukeva mainossuodatin: [[MediaWiki:Spam-blacklist|estolista]] ja [[MediaWiki:Spam-whitelist|poikkeuslista]].',
);

/** French (Français)
 * @author Gomoko
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'spam-blacklist' => ' # Les liens externes faisant partie de cette liste seront bloqués lors de leur insertion dans une page.
 # Cette liste n’affecte que ce wiki ; référez-vous aussi à la liste noire globale.
 # La documentation se trouve à l’adresse suivante : https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Laissez cette ligne telle quelle --><pre>
#
# La syntaxe est la suivante :
#  * tout texte qui suit un « # » est considéré comme un commentaire ;
#  * toute ligne non vide est un fragment d’expression rationnelle qui n’analysera que les hôtes dans les liens hypertextes.

 #</pre><!-- Laissez cette ligne telle quelle -->',
	'spam-whitelist' => ' #<!-- Laissez cette ligne telle quelle--><pre>
# Les liens hypertextes externes correspondant à cette liste ne seront *pas* bloqués
# même s’ils auraient été bloqués par les entrées de la liste noire.
#
# La syntaxe est la suivante :
#  * tout texte qui suit un « # » est considéré comme un commentaire ;
#  * toute ligne non vide est un fragment d’expression rationnelle qui n’analysera que les hôtes dans les liens hypertextes.

 #</pre> <!--Laissez cette ligne telle quelle -->',
	'email-blacklist' => "# Les adresses de courriel correspondant à cette liste seront bloquées lors l'enregistrement ou de l'envoi d'un courriel
 # Cette liste n’affecte que ce wiki ; référez-vous aussi à la liste noire globale.
 # La documentation se trouve à l’adresse suivante : https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Laissez cette ligne telle quelle --><pre>
#
# La syntaxe est la suivante :
#  * tout texte qui suit un \"#\" est considéré comme un commentaire
#  * toute ligne non vide est un fragment d’expression rationnelle qui n’analysera que les hôtes correspondant dans les URLs.

 #</pre><!-- Laissez cette ligne telle quelle -->",
	'email-whitelist' => "<!-- laissez cette ligne telle quelle --> <pre>
# Les adresses de courriels correspondant à cette liste ne seront *pas* bloqués même s'ils auraient
# dû l'être par les entrées de la liste noire.
#
 #</pre> <!-- laissez cette ligne telle quelle -->
# La syntaxe est comme suit :
#  * Tout texte à partir du caractère « # » jusqu'à la fin de la ligne est un commentaire.
#  * Chaque ligne non vide est un morceau de regex (expression rationnelle) qui sera mis en correspondance avec la partie « hosts » des adresses de courriels",
	'spam-blacklisted-email' => 'Adresses courriel et liste noire',
	'spam-blacklisted-email-text' => "Votre adresse de courriel est actuellement sur une liste noire d'envoi de courriel aux autres utilisateurs.",
	'spam-blacklisted-email-signup' => "L'adresse de courriel fournie est actuellement sur une liste noire d'utilisation.",
	'spam-invalid-lines' => '{{PLURAL:$1|La ligne suivante|Les lignes suivantes}} de la liste noire des polluriels {{PLURAL:$1|est une expression rationnelle invalide|sont des expressions rationnelles invalides}} et doi{{PLURAL:$1||ven}}t être corrigée{{PLURAL:$1||s}} avant d’enregistrer la page :',
	'spam-blacklist-desc' => "Outil anti-pourriel basé sur des expressions rationnelles : ''[[MediaWiki:Spam-blacklist]]'' et ''[[MediaWiki:Spam-whitelist]]''",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'spam-blacklist' => ' # Los lims hipèrtèxtos de defôr que sont dens ceta lista seront blocâs pendent lor entrebetâ dens una pâge.
 # Ceta lista afècte ren que ceti vouiqui ; refèrâd-vos asse-ben a la lista nêre globâla.
 # La documentacion sè trove a ceta adrèce : https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- lèssiéd ceta legne justo d’ense --> <pre>
#
# La sintaxa est ceta :
#  * Tot tèxto que siut un « # » est considèrâ coment un comentèro.
#  * Tota legne pas voueda est un bocon d’èxprèssion racionèla (*RegEx*) qu’analiserat ren que los hôtos dedens los lims hipèrtèxtos.

  #</pre> <!-- lèssiéd ceta legne justo d’ense -->',
	'spam-whitelist' => ' #<!-- lèssiéd ceta legne justo d’ense --> <pre>
# Los lims hipèrtèxtos de defôr que sont dens ceta lista seront *pas* blocâs mémo
# s’ils ariant étâ blocâs per les entrâs de la lista nêre.
#
# La sintaxa est ceta :
#  * Tot tèxto que siut un « # » est considèrâ coment un comentèro.
#  * Tota legne pas voueda est un bocon d’èxprèssion racionèla (*RegEx*) qu’analiserat ren que los hôtos dedens los lims hipèrtèxtos.

  #</pre> <!-- lèssiéd ceta legne justo d’ense -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Ceta legne|Cetes legnes}} de la lista nêre des spames {{PLURAL:$1|est una èxprèssion racionèla envalida|sont des èxprèssions racionèles envalides}} et dê{{PLURAL:$1||von}}t étre corregiê{{PLURAL:$1||s}} devant que sôvar la pâge :',
	'spam-blacklist-desc' => "Outil anti-spame basâ sur des èxprèssions racionèles (''RegEx'') : ''[[MediaWiki:Spam-blacklist]]'' et ''[[MediaWiki:Spam-whitelist]]''.",
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'spam-blacklist' => ' # As ligazóns externas que coincidan na súa totalidade ou en parte con algún rexistro desta lista serán bloqueadas cando se intenten engadir a unha páxina.
 # Esta lista afecta unicamente a este wiki; tamén existe unha lista global.
 # Para obter máis documentación vaia a https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Deixe esta liña tal e como está --> <pre>
#
# A sintaxe é a seguinte:
#   * Todo o que vaia despois dun carácter "#" ata o final da liña é un comentario
#   * Toda liña que non estea en branco é un fragmento de expresión regular que só coincide con dominios dentro de enderezos URL

 #</pre> <!-- Deixe esta liña tal e como está -->',
	'spam-whitelist' => ' #<!-- Deixe esta liña tal e como está --> <pre>
 # As ligazóns externas que coincidan con esta lista *non* serán bloqueadas mesmo se
 # fosen bloqueadas mediante entradas na lista negra.
#
# A sintaxe é a que segue:
#   * Todo o que vaia despois dun carácter "#" ata o final da liña é un comentario
#   * Toda liña que non estea en branco é un fragmento de expresión regular que só coincide con dominios dentro de enderezos URL

 #</pre> <!-- Deixe esta liña tal e como está -->',
	'email-blacklist' => ' # Os enderezos de correo electrónico que coincidan na súa totalidade ou en parte con algún rexistro desta lista serán bloqueadas cando se intenten rexistrar ou se intente enviar un correo desde eles.
 # Esta lista afecta unicamente a este wiki; tamén existe unha lista global.
 # Para obter máis documentación vaia a https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Deixe esta liña tal e como está --> <pre>
#
# A sintaxe é a seguinte:
#   * Todo o que vaia despois dun carácter "#" ata o final da liña é un comentario
#   * Toda liña que non estea en branco é un fragmento de expresión regular que só coincide con dominios dentro de enderezos de correo electrónico

 #</pre> <!-- Deixe esta liña tal e como está -->',
	'email-whitelist' => ' #<!-- Deixe esta liña tal e como está --> <pre>
# Os enderezos de correo electrónico que coincidan con algún desta lista *non* serán bloqueados,
# mesmo se foron bloqueados por entradas da lista negra.
#
 #</pre> <!-- Deixe esta liña tal e como está -->
#
# A sintaxe é a seguinte:
#   * Todo o que vaia despois dun carácter "#" ata o final da liña é un comentario
#   * Toda liña que non estea en branco é un fragmento de expresión regular que só coincide con dominios dentro de enderezos de correo electrónico',
	'spam-blacklisted-email' => 'Enderezo de correo electrónico presente na lista negra',
	'spam-blacklisted-email-text' => 'O seu enderezo de correo electrónico atópase na lista negra e non pode enviar correos electrónicos aos outros usuarios.',
	'spam-blacklisted-email-signup' => 'O enderezo de correo electrónico especificado está na lista negra e non se pode empregar.',
	'spam-invalid-lines' => '{{PLURAL:$1|A seguinte liña|As seguintes}} da lista negra de spam {{PLURAL:$1|é unha expresión regular inválida|son expresións regulares inválidas}} e {{PLURAL:$1|haina|hainas}} que corrixir antes de gardar a páxina:',
	'spam-blacklist-desc' => 'Ferramenta antispam baseada en expresións regulares: [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'spam-blacklist' => ' # Externi URL, wu in däre Lischt sin, blockiere s Spychere vu dr Syte.
 # Die Lischt giltet nume fir des Wiki; lueg au di wältwyt Blacklist.
 # Fir d Dokumentation lueg https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Die Zyylete derf nit gänderet wäre! --> <pre>
#
# Syntax:
#  * Alles ab em "#"-Zeiche bis zum Änd vu dr Zyylete isch e Kommentar
#  * Jede Zyylete, wu nit läär isch, isch e reguläre Usdruck, wu gege d Host-Näme in dr URL prieft wird.

 #</pre> <!-- Die Zyylete derf nit gänderet wäre! -->',
	'spam-whitelist' => ' #</pre> <!-- Die Zyylete derf nit gänderet wäre! -->
# Externi URL, wu in däre Lischt sin, blockiere s Spychere vu dr Syte nit, au wänn si in dr wältwyte oder lokale Schwarze Lischt din sin.
#
# Syntax:
#  * Alles ab em "#"-Zeiche bis zum Änd vu dr Zyylete isch e Kommentar
#  * Jede Zyylete, wu nit läär isch, isch e reguläre Usdruck, wu gege d Host-Näme in dr URL prieft wird.

 #</pre> <!-- Die Zyylete derf nit gänderet wäre! -->',
	'spam-invalid-lines' => 'Die {{PLURAL:$1|Zyylete|Zyylete}} in dr Spam-Blacklist {{PLURAL:$1|isch e nit giltige reguläre Usdruck|sin nit giltigi reguläri Usdrick}}. Si {{PLURAL:$1|muess|mien}} vor em Spychere vu dr Syte korrigiert wäre:',
	'spam-blacklist-desc' => 'Regex-basiert Anti-Spam-Wärchzyyg: [[MediaWiki:Spam-blacklist]] un [[MediaWiki:Spam-whitelist]]',
);

/** Gujarati (ગુજરાતી)
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'spam-blacklisted-email' => 'પ્રતિબંધિત ઈ-મેલ સરનામું',
	'spam-blacklisted-email-text' => 'તમારા ઈ-મેલ સરનામાં પર હાલમાં પ્રતિબંધ લગાડેલો છે આથી તમે ઈ-મેલ મોકલી  નહીં શકો.',
	'spam-blacklisted-email-signup' => 'આ ઈ-મેલ પર હાલમાં વપરાશ પ્રતિબંધ લાગેલો છે.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Ofekalef
 * @author Rotem Liss
 */
$messages['he'] = array(
	'spam-blacklist' => ' # כתובות URL חיצוניות התואמות לרשימה זו ייחסמו בעת הוספתן לדף.
 # רשימה זו משפיעה על אתר זה בלבד; שימו לב גם לרשימה הכללית.
 # לתיעוד ראו https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- נא להשאיר שורה זו בדיוק כפי שהיא --> <pre>
#
# התחביר הוא כדלקמן:
#   * כל דבר מתו "#" לסוף השורה הוא הערה
#   * כל שורה לא ריקה היא קטע מביטוי רגולרי שיתאים לשמות המתחם של כתובות URL

 #</pre> <!-- נא להשאיר שורה זו בדיוק כפי שהיא -->',
	'spam-whitelist' => ' #<!-- נא להשאיר שורה זו בדיוק כפי שהיא --> <pre>
# כתובות URL חיצוניות המופיעות ברשימה זו *לא* ייחסמו אפילו אם יש להן ערך ברשימת הכתובות האסורות.
#
# התחביר הוא כדלקמן:
#   * כל דבר מתו "#" לסוף השורה הוא הערה
#   * כל שורה לא ריקה היא קטע מביטוי רגולרי שיתאים לשמות המתחם של כתובות URL

 #</pre> <!-- נא להשאיר שורה זו בדיוק כפי שהיא -->',
	'email-blacklist' => ' # עבור כתובות הדואר האלקטרוני המתאימות לרשימה זו תיחסם האפשרות להירשם ולשלוח דואר אלקטרוני
 # רשימה זו משפיעה רק על ויקי זה; שימו לב גם לרשימה הגלובלית.
 # לתיעוד ראו https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# התחביר הוא כדלקמן:
# * הכול החל מהתו "#" עד סוף השורה הוא הערה
# * כל שורה לא ריקה היא ביטוי רגולרי חלקי שתתאים רק לשרתים בתוך הדואר האלקטרוני

 #</pre> <!-- leave this line exactly as it is -->',
	'email-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# כתובות הדואר האלקטרוני המתאימות לרשימה זו *לא* תיחסמנה אף אם הן מתאימות לרשימה השחורה.
#
 #</pre> <!-- leave this line exactly as it is -->
# התחביר הוא כדלקמן:
# * הכול החל מהתו "#" עד סוף השורה הוא הערה
# * כל שורה לא ריקה היא ביטוי רגולרי חלקי שתתאים רק לשרתים בתוך הדואר האלקטרוני',
	'spam-blacklisted-email' => 'כתובות דוא"ל ברשימה השחורה',
	'spam-blacklisted-email-text' => 'כתובת הדוא"ל שלך נמצאת כרגע ברשימה השחורה של כתובות שלא ניתן לשלוח מהן הודעות למשמתמשים אחרים.',
	'spam-blacklisted-email-signup' => 'כתובת הדוא"ל הזאת נמצאת כרגע ברשימה השחורה של כתובות אסורות לשימוש.',
	'spam-invalid-lines' => '{{PLURAL:$1|השורה הבאה|השורות הבאות}} ברשימת כתובות ה־URL האסורות
	{{PLURAL:$1|היא ביטוי רגולרי בלתי תקין ויש לתקנה|הן ביטויים רגולריים בלתי תקינים ויש לתקנן}} לפני שמירת הדף:',
	'spam-blacklist-desc' => 'כלי אנטי־ספאם מבוסס ביטוי רגולרי: [[MediaWiki:Spam-blacklist]] ו־[[MediaWiki:Spam-whitelist]]',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'spam-blacklist' => ' #इस सूची में मौजूद कडियाँ जब एक पृष्ठ में जोड़ी गई बाहरी URLs से मेल खाती है तब वह पृष्ठ संपादन से बाधित हो जायेगा।
 #यह सूची केवल इस विकी पर ही प्रभावी है, विश्वव्यापी ब्लैकलिस्ट को भी उद्धृत करें।
 #प्रलेखन के लिए https://www.mediawiki.org/wiki/Extension:SpamBlacklist देखें
 #<!-- इस पंक्तीं को ऐसे के ऐसे ही रहने दें --> <pre>
#
#वाक्य विश्लेषण निम्नांकित है:
#  * हर जगह "#" संकेत से लेकर पंक्ति के अंत तक एक ही टिपण्णी है
#  * प्रत्येक अरिक्त पंक्ति एक टुकडा है जो कि URLs के अंतर्गत केवल आयोजकों से मेल खाता है

 #</pre> <!-- इस पंक्तीं को ऐसे के ऐसे ही रहने दें -->',
	'spam-whitelist' => ' #<!-- इस पंक्तीं को ऐसे के ऐसे ही रहने दें --> <pre>
# बाहरी कडियाँ जो इस सूची से मेल खाती है, वह कभी भी बाधित *नहीं* होंगी
# ब्लैकलिस्ट प्रवेशिका द्वारा बाधित कि गई हैं।
#
# वाक्य विश्लेषण निम्नांकित है:
#  * हर जगह "#" संकेत से लेकर पंक्ति के अंत तक एक ही टिपण्णी है
#  * प्रत्येक अरिक्त पंक्ति एक टुकडा है जो कि URLs के अंतर्गत केवल आयोजकों से मेल खाता है

 #</pre> <!-- इस पंक्तीं को ऐसे के ऐसे ही रहने दें -->',
	'spam-invalid-lines' => 'निम्नांकित अवांछित ब्लैकलिस्ट {{PLURAL:$1|पंक्ति|पंक्तियाँ}} अमान्य नियमित {{PLURAL:$1|अभिव्यक्ति है|अभिव्यक्तियाँ हैं}} और पृष्ठ को जमा कराने से पहले ठीक करना चाहिए:',
	'spam-blacklist-desc' => 'रेजएक्स पर आधारित स्पॅम रोकनेवाला उपकरण:[[MediaWiki:Spam-blacklist]] और [[MediaWiki:Spam-whitelist]]',
);

/** Croatian (Hrvatski)
 * @author Dnik
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'spam-blacklist' => ' # Vanjske URLovi koji budu pronađeni pomoću ovog popisa nije moguće snimiti na stranicu wikija.
 # Ovaj popis utiče samo na ovaj wiki; provjerite globalnu "crnu listu".
 # Za dokumentaciju pogledajte https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Rabi se slijedeća sintaksa:
#   * Sve poslije "#" znaka do kraja linije je komentar
#   * svaki neprazni redak je dio regularnog izraza (\'\'regex fragment\'\') koji odgovara imenu poslužitelja u URL-u

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# Vanjski URLovi koji budu pronađeni pomoću ovog popisa nisu blokirani
# čak iako se nalaze na "crnom popisu".
#
# Rabi se slijedeća sintaksa:
#   * Sve poslije "#" znaka do kraja linije je komentar
#   * svaki neprazni redak je dio regularnog izraza (\'\'regex fragment\'\') koji odgovara imenu poslužitelja u URL-u

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Slijedeći redak|Slijedeći redovi|Slijedeći redovi}} "crnog popisa" spama {{PLURAL:$1|je|su}} nevaljani {{PLURAL:$1|regularan izraz|regularni izrazi|regularni izrazi}} i {{PLURAL:$1|mora|moraju|moraju}} biti ispravljeni prije snimanja ove stranice:',
	'spam-blacklist-desc' => 'Anti-spam alat zasnovan na reg. izrazima: [[MediaWiki:Spam-blacklist]] i [[MediaWiki:Spam-whitelist]]',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'spam-blacklist' => ' # Eksterne URL, kotrež su w lisćinje wobsahowane, blokuja składowanje strony.
 # Tuta lisćina nastupa jenož tutón Wiki; hlej tež globalnu čornu lisćinu.
 # Za dokumentaciju hlej https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Tuta linka njesmě so změnić! --> <pre>
#
# Syntaksa:
#   * Wšitko wot znamjenja "#" hač ke kóncej linki je komentar
#   * Kóžda njeprózdna linka je regularny wuraz, kotryž so přećiwo mjenu hosta w URL pruwuje.

 #</pre> <!-- Tuta linka njesmě so změnić! -->',
	'spam-whitelist' => ' #<!-- Tuta linka njesmě so změnić! --> <pre>
# Eksterne URL, kotrež su w tutej lisćinje wobsahowane, njeblokuja składowanje strony, byrnjež
# w globalnej abo lokalnej čornej lisćinje wobsahowane byli.
#
# Syntaksa:
#   * Wšitko wot znamjenja "#" hač ke kóncej linki je komentar
#   * Kóžda njeprózdna linka je regularny wuraz, kotryž so přećiwo mjenu hosta w URL pruwuje.

 #</pre> <!-- Tuta linka njesmě so změnić! -->',
	'email-blacklist' => '# E-mejlowe adresy, kotrež su w lisćinje wobsahowane, blokuja registrowanje a słanje e-mejlkow.
 # Tuta lisćina nastupa jenož tutón Wiki; hlej tež globalnu čornu lisćinu.
 # Za dokumentaciju hlej https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Tuta linka njesmě so změnić! --> <pre>
#
# Syntaksa:
#   * Wšitko wot znamjenja "#" hač ke kóncej linki je komentar
#   * Kóžda njeprózdna linka je regularny wuraz, kotryž so přećiwo mjenu hosta w e-mejlach pruwuje.

 #</pre> <!-- Tuta linka njesmě so změnić! -->',
	'email-whitelist' => '#<!-- Tuta linka njesmě so změnić! --> <pre>
# E-mejlowe adresy, kotrež su w tutej lisćinje, *nje*blokuja so, byrnjež so 
# přez zapiski čornje lisćiny blokowali.
#
 #</pre> <!-- Tuta linka njesmě so změnić! -->
# Syntaksa je slědowaca:
# * Wšitko wot znamješka "#" ke kóncej linki je komentar
# * Kóžda njeprózdna linka je regularny wuraz, kotryž jenož hostam znutřka e-mejlow wotpowěduje',
	'spam-blacklisted-email' => 'E-mejlowe adresy w čornej lisćinje',
	'spam-blacklisted-email-text' => 'Twoja e-mejlowa adresa je tuchwilu w čornej lisćinje a tohodla za słanje e-mejlow do druhich wužiwarjow zablokowana.',
	'spam-blacklisted-email-signup' => 'Podata e-mejlowa adresa je tuchwilu přećiwo wužiwanju zablokowana.',
	'spam-invalid-lines' => '{{PLURAL:$1|slědowaca linka je njepłaćiwy regularny wuraz|slědowacych linkow je regularny wuraz|slědowace linki su regularne wurazy|slědowacej lince stej regularnej wurazaj}} a {{PLURAL:$1|dyrbi|dyrbi|dyrbja|dyrbjetej}} so korigować, prjedy hač so strona składuje:',
	'spam-blacklist-desc' => 'Přećiwospamowy nastroj na zakładźe Regex: [[MediaWiki:Spam-blacklist]] a [[MediaWiki:Spam-whitelist]]',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'spam-blacklist' => ' # A lista elemeire illeszkedő külső hivatkozások blokkolva lesznek
 # A lista csak erre a wikire vonatkozik; a globális feketelistába is tedd bele.
 # Dokumentációhoz lásd a https://www.mediawiki.org/wiki/Extension:SpamBlacklist oldalt (angolul)
 #<!-- ezen a soron ne változtass --> <pre>
#
# A szintaktika a következő:
#  * Minden a „#” karaktertől a sor végéig megjegyzésnek számít
#  * Minden nem üres sor egy reguláris kifejezés darabja, amely csak az URL-ekben található kiszolgálókra illeszkedik',
	'spam-whitelist' => ' #<!-- ezen a soron ne változtass --> <pre>
# A lista elemeire illeszkedő külső hivatkozások *nem* lesznek blokkolva, még
# akkor sem, ha illeszkedik egy feketelistás elemre.
#
# A szintaktika a következő:
#  * Minden a „#” karaktertől a sor végéig megjegyzésnek számít
#  * Minden nem üres sor egy reguláris kifejezés darabja, amely csak az URL-ekben található kiszolgálókra illeszkedik

 #</pre> <!-- ezen a soron ne változtass -->',
	'spam-invalid-lines' => 'Az alábbi {{PLURAL:$1|sor hibás|sorok hibásak}} a spam elleni feketelistában; {{PLURAL:$1|javítsd|javítsd őket}} mentés előtt:',
	'spam-blacklist-desc' => 'Regex-alapú spamellenes eszköz: [[MediaWiki:Spam-blacklist]] és [[MediaWiki:Spam-whitelist]]',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'spam-blacklist' => ' # Le adresses URL externe correspondente a iste lista es blocate de esser addite a un pagina.
 # Iste lista ha effecto solmente in iste wiki; refere te etiam al lista nigre global.
 # Pro documentation vide https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- non modificar in alcun modo iste linea --> <pre>
#
# Le syntaxe es lo sequente:
#  * Toto a partir de un character "#" usque al fin del linea es un commento
#  * Cata linea non vacue es un fragmento de regex que se applica solmente al nomines de host intra adresses URL

 #</pre> <!-- non modificar in alcun modo iste linea -->',
	'spam-whitelist' => ' #<!-- non modificar in alcun modo iste linea --> <pre>
# Le adresses URL correspondente a iste lista *non* essera blocate mesmo si illos
# haberea essite blocate per entratas in le lista nigre.
#
# Le syntaxe es lo sequente:
#  * Toto a partir de un character "#" usque al fin del linea es un commento
#  * Omne linea non vacue es un fragmento de regex que se applica solmente al nomines de host intra adresses URL

 #</pre> <!-- non modificar in alcun modo iste linea -->',
	'email-blacklist' => ' # Le adresses de e-mail correspondente a iste lista es blocate de crear contos o inviar e-mail.
 # Iste lista ha effecto solmente in iste wiki; refere te etiam al lista nigre global.
 # Pro documentation vide https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- non modificar in alcun modo iste linea --> <pre>
#
# Le syntaxe es lo sequente:
#  * Toto a partir de un character "#" usque al fin del linea es un commento
#  * Cata linea non vacue es un fragmento de regex que se applica solmente al nomines de host in adresses de e-mail

 #</pre> <!-- non modificar in alcun modo iste linea -->',
	'email-whitelist' => ' #<!-- non modificar in alcun modo iste linea --> <pre>
# Le adresses de e-mail correspondente a iste lista *non* essera blocate
# mesmo si illos haberea essite blocate per entratas de lista nigre.
#
# Le syntaxe es lo sequente:
#  * Toto a partir de un character "#" usque al fin del linea es un commento
#  * Cata linea non vacue es un fragmento de regex que se applica solmente al nomines de host in adresses de e-mail
 #</pre> <!-- non modificar in alcun modo iste linea -->',
	'spam-blacklisted-email' => 'Adresse de e-mail in lista nigre',
	'spam-blacklisted-email-text' => 'Tu adresse de e-mail es actualmente blocate de inviar messages a altere usatores.',
	'spam-blacklisted-email-signup' => 'Le adresse de e-mail specificate es actualmente blocate per le lista nigre.',
	'spam-invalid-lines' => 'Le sequente {{PLURAL:$1|linea|lineas}} del lista nigre antispam es {{PLURAL:$1|un expression|expressiones}} regular invalide e debe esser corrigite ante que tu immagazina le pagina:',
	'spam-blacklist-desc' => 'Instrumento antispam a base de regex: [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Meursault2004
 */
$messages['id'] = array(
	'spam-blacklist' => '
 # URL eksternal yang cocok dengan daftar berikut akan diblokir jika ditambahkan pada suatu halaman.
 # Daftar ini hanya berpengaruh pada wiki ini; rujuklah juga daftar hitam global.
 # Untuk dokumentasi, lihat https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- biarkan baris ini seperti adanya --> <pre>
#
# Sintaksnya adalah sebagai berikut:
#   * Semua yang diawali dengan karakter "#" hingga akhir baris adalah komentar
#   * Semua baris yang tidak kosong adalah fragmen regex yang hanya akan dicocokkan dengan nama host di dalam URL

 #</pre> <!-- biarkan baris ini seperti adanya -->',
	'spam-whitelist' => ' #<!-- biarkan baris ini seperti adanya --> <pre>
 # URL eksternal yang cocok dengan daftar berikut *tidak* akan diblokir walaupun
# pasti akan diblokir oleh entri pada daftar hitam
#
# Sintaksnya adalah sebagai berikut:
#   * Semua yang diawali dengan karakter "#" hingga akhir baris adalah komentar
#   * Semua baris yang tidak kosong adalah fragmen regex yang hanya akan dicocokkan dengan nama host di dalam URL

 #</pre> <!-- biarkan baris ini seperti adanya -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Baris|Baris-baris}} daftar hitam spam berikut adalah {{PLURAL:$1|ekspresi|ekspresi}} regular yang tak valid dan {{PLURAL:$1|perlu|perlu}} dikoreksi sebelum disimpan:',
	'spam-blacklist-desc' => 'Perkakas anti-spam berbasis regex: [[MediaWiki:Spam-blacklist]] dan [[MediaWiki:Spam-whitelist]]',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'spam-blacklist' => ' # Dagiti akinruar a URL a maipada iti daytoy a listaan ket maserraan to no mainayon ditoy a panid.
 # Daytoy a listaan ket tignayen na laeng daytoy a wiki; kitaen pay ti sangalubongan a blacklist.
 # Para iti dokumentasion kitaen ti https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- baybayan daytoy a linia --> <pre>
#
# Ti gramatika ket kasla dagiti sumaganad:
#   * Amin manipud iti "#" a karakter iti gibus ti linia ket komentario
#   * Amin ti saan a blanko a linia ket regex a fragment a maipada laeng ti nagsangaili iti uneg dagiti URL

 #</pre> <!-- baybayan daytoy a linia -->',
	'spam-whitelist' => ' #<!-- baybayan daytoy a linia --> <pre>
# Dagiti akinruar a panilpo a maipada iti daytoy a listaan ket *saan* a maserraan uray no
# naseraanen babaen ti blacklista naikabil.
#
# Ti gramatika ket kasla dagitii sumaganad:
#   * Amin manipud iti  "#" a karakter iti gibus ti linia ket komentario
#   * Amin a saan a blanko a linia ket regex a fragment a maipada laeng ti nagsangaili ti uneg dagiti URL

 #</pre> <!-- baybayan daytoy a linia -->',
	'spam-invalid-lines' => 'Ti sumaganad a spam blacklist {{PLURAL:$1|linia ket|dagiti linia ket}} imbalido a kadawyan {{PLURAL:$1|panangisao|dagiti panangisao}} ken {{PLURAL:$1|masapsapol|masapol}} a mapudnuan sakbay nga idulin ti panid:',
	'spam-blacklist-desc' => 'Naibantay ti regex kontra-spam a ramit: [[MediaWiki:Spam-blacklist]] ken [[MediaWiki:Spam-whitelist]]',
);

/** Italian (Italiano)
 * @author BrokenArrow
 */
$messages['it'] = array(
	'spam-blacklist' => ' # Le URL esterne al sito che corrispondono alla lista seguente verranno bloccate.
 # La lista è valida solo per questo sito; fare riferimento anche alla blacklist globale.
 # Per la documentazione si veda https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- non modificare in alcun modo questa riga --> <pre>
# La sintassi è la seguente:
#  * Tutto ciò che segue un carattere "#" è un commento, fino al termine della riga
#  * Tutte le righe non vuote sono frammenti di espressioni regolari che si applicano al solo nome dell\'host nelle URL
 #</pre> <!-- non modificare in alcun modo questa riga -->',
	'spam-whitelist' => ' #<!-- non modificare in alcun modo questa riga --> <pre>
# Le URL esterne al sito che corrispondono alla lista seguente *non* verranno
# bloccate, anche nel caso corrispondano a delle voci della blacklist
#
# La sintassi è la seguente:
#  * Tutto ciò che segue un carattere "#" è un commento, fino al termine della riga
#  * Tutte le righe non vuote sono frammenti di espressioni regolari che si applicano al solo nome dell\'host nelle URL

 #</pre> <!-- non modificare in alcun modo questa riga -->',
	'spam-invalid-lines' => "{{PLURAL:$1|La seguente riga|Le seguenti righe}} della blacklist dello spam {{PLURAL:$1|non è un'espressione regolare valida|non sono espressioni regolari valide}}; si prega di correggere {{PLURAL:$1|l'errore|gli errori}} prima di salvare la pagina.",
	'spam-blacklist-desc' => 'Strumento antispam basato sulle espressioni regolari [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Marine-Blue
 */
$messages['ja'] = array(
	'spam-blacklist' => ' # この一覧に掲載されている外部URLをページに追加すると編集をブロックします。
 # この一覧はこのウィキでのみ有効です。グローバル・ブラックリストも参照してください。
 # 利用方法は https://www.mediawiki.org/wiki/Extension:SpamBlacklist/ja をご覧ください。
 #<!-- この行は変更しないでください --> <pre>
#
# 構文は以下のとおりです:
#  * "#"文字から行末まではコメントとして扱われます
#  * 空白を含んでいない行は、URLに含まれるホスト名との一致を検出する正規表現です

 #</pre> <!-- この行は変更しないでください -->',
	'spam-whitelist' => ' #<!-- この行は変更しないでください --> <pre>
# この一覧に掲載されている外部URLに一致する送信元からのページ編集は、
# 例えブラックリストに掲載されていたとしても、ブロック*されません*。
#
# 構文は以下のとおりです:
#  * "#"文字から行末まではコメントとして扱われます
#  * 空白を含んでいない行は、URLに含まれるホスト名との一致を検出する正規表現です

 #</pre> <!-- この行は変更しないでください -->',
	'spam-invalid-lines' => 'このスパムブラックリストには、不正な{{PLURAL:$1|正規表現}}の含まれている{{PLURAL:$1|行}}があります。保存する前に問題部分を修正してください:',
	'spam-blacklist-desc' => '正規表現を用いたスパム対策ツール: [[MediaWiki:Spam-blacklist|スパムブラックリスト]]および[[MediaWiki:Spam-whitelist|スパムホワイトリスト]]',
);

/** Jutish (Jysk)
 * @author Ælsån
 */
$messages['jut'] = array(
	'spam-blacklist-desc' => 'Regex-basærn anti-spem tø: [[MediaWiki:Spam-blacklist]] og [[MediaWiki:Spam-whitelist]]',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'spam-blacklist' => ' # URL eksternal sing cocog karo daftar iki bakal diblokir yèn ditambahaké ing sawijining kaca.
 # Daftar iki namung nduwé pangaruh ing wiki iki; ngrujuka uga daftar ireng global.
 # Kanggo dokumentasi, delengen https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- lirwakna baris iki apa anané --> <pre>
#
# Sintaksisé kaya mengkéné:
#  * Kabèh sing diawali mawa karakter "#" nganti tekaning akir baris iku komentar
#  * Kabèh baris sing ora kosong iku fragmèn regex sing namung bakal dicocogaké karo jeneng host sajroning URL-URL

 #</pre> <!-- lirwakna baris iki apa anané -->',
	'spam-whitelist' => ' #<!-- lirwakna baris iki apa anané --> <pre>
 # URL èksternal sing cocog karo daftar iki *ora* bakal diblokir senadyan
# bakal diblokir déning èntri ing daftar ireng
#
# Sintaksisé kaya mengkéné:
#  * Kabèh sing diawali mawa karakter "#" nganti tekaning akir baris iku komentar
#  * Kabèh baris sing ora kosong iku fragmèn regex sing namung bakal dicocogaké karo jeneng host sajroning URL-URL

 #</pre> <!-- lirwakna baris iki apa anané -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Baris|Baris-baris}} daftar ireng spam ing ngisor iki yaiku {{PLURAL:$1|èksprèsi|èksprèsi}} regulèr sing ora absah lan {{PLURAL:$1|perlu|perlu}} dikorèksi sadurungé disimpen:',
	'spam-blacklist-desc' => 'Piranti anti-spam adhedhasar regex: [[MediaWiki:Spam-blacklist]] lan [[MediaWiki:Spam-whitelist]]',
);

/** Georgian (ქართული)
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'spam-blacklist' => '  # ამ სიის შესაბამისი გარე ბმულები აიკრძალება გვერდებში შესატანად.
  # ეს სია მოქმედებს მარტო ამ ვიკისთვის, თუმცა არსებობს ასევე საერთო შავი სია.
  # დამატებით ინფორმაცია გვერდზე https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- არ შეასწოროთ ეს ხაზი --> <pre>
#
# სინტაქსისი:
#   * ყველაფერი დაწყებული სიმბოლოთი "#" ხაზის ბოლომდე კომენტარად ითვლება
#   * ყველა არაცარიელი ხაზო აროს რეგულარული გამოთქმის ფრაგმენტი, რომელიც მხოლოდ URL-თან ერთად გამოიყენება

  #</pre> <!-- არ შეასწოროთ ეს ხაზი -->',
	'spam-whitelist' => '  #<!-- არ შეასწოროთ ეს ხაზი --> <pre>
# ის გარე ბმულები, რომლებიც ამ სიაშია შეტანილი *არ დაიბლოკება* მაშინაც კი, თუ შავ სიაში მოხვდება
#
# სინტაქსი:
#  * ყველაფერი სიმბოლ "#" иდაწყებული ბოლომდე კომენტარად ითვლება
#  * ყველა არაცარიელი ხაზი არის რეგულარული გამოთქმის ნაწილი, რომელიც მხოლოდ URL-თან ერთად გამოიყენება

  #</pre> <!--არ შეასწოროთ ეს ხაზი-->',
	'spam-invalid-lines' => '{{PLURAL:$1|შავი სიის შემდეგმა ხაზმა შესაძლოა შეიცავდეს არასწორი რეგულარუსლი გამოთქმა და უნდა გასწორდეს|შავი სიის შემდეგმა ხაზებმა შესაძლოა შეიცავდეს არასწორი რეგულარუსლი გამოთქმები და უნდა გასწორდეს}} შენახვამდე:',
	'spam-blacklist-desc' => 'რეგულარულ გამოთქმებზე დაფუძნებული ანტი-სპამ ინსტრუმენტი[[MediaWiki:Spam-blacklist]] და [[MediaWiki:Spam-whitelist]]',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'spam-blacklist' => ' # وسى تىزىمگە سايكەس سىرتقى URL جايلار بەتكە ۇستەۋدەن بۇعاتتالادى.
 # بۇل ٴتىزىم تەك مىنداعى ۋىيكىيگە اسەر ەتەدى; تاعى دا عالامدىق قارا ٴتىزىمدى قاراپ شىعىڭىز.
 # قۇجاتتاما ٴۇشىن https://www.mediawiki.org/wiki/Extension:SpamBlacklist بەتىن قاراڭىز
 #<!-- بۇل جولدى بولعان جاعدايىمەن قالدىرىڭىز --> <pre>
#
# سىينتاكسىيسى كەلەسىدەي:
#  * «#» نىشانىنان باستاپ جول اياعىنا دەيىنگىلەرىنىڭ بۇكىلى ماندەمە دەپ سانالادى
#  * بوس ەمەس ٴار جول تەك URL جايلاردىڭ ىشىندەگى حوستتارعا سايكەس جۇيەلى ايتىلىمدىڭ (regex) بولىگى دەپ سانالادى

 #</pre> <!-- بۇل جولدى بولعان جاعدايىمەن قالدىرىڭىز -->',
	'spam-whitelist' => ' #<!-- بۇل جولدى بولعان جاعدايىمەن قالدىرىڭىز --> <pre>
# وسى تىزىمگە سايكەس سىرتقى URL جايلار *بۇعاتتالمايدى*,
# (قارا تىزىمدەگى جازبامەن بۇعاتتالعان بولسا دا).
#
# سىينتاكسىيسى كەلەسىدەي:
#  * «#» نىشانىنان باستاپ جول اياعىنا دەيىنگىلەرىنىڭ بۇكىلى ماندەمە دەپ سانالادى
#  * بوس ەمەس ٴار جول تەك URL جايلاردىڭ ىشىندەگى حوستتارعا سايكەس جۇيەلى ايتىلىمدىڭ (regex) بولىگى دەپ سانالادى

 #</pre> <!-- بۇل جولدى بولعان جاعدايىمەن قالدىرىڭىز -->',
	'spam-invalid-lines' => 'سپام قارا تىزىمىندەگى كەلەسى {{PLURAL:$1|جولدا|جولداردا}} جارامسىز جۇيەلى {{PLURAL:$1|ايتىلىم|ايتىلىمدار}} بار, جانە بەتتى ساقتاۋدىڭ {{PLURAL:$1|بۇنى|بۇلاردى}}  دۇرىستاۋ كەرەك.',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬)
 * @author AlefZet
 */
$messages['kk-cyrl'] = array(
	'spam-blacklist' => ' # Осы тізімге сәйкес сыртқы URL жайлар бетке үстеуден бұғатталады.
 # Бұл тізім тек мындағы уикиге әсер етеді; тағы да ғаламдық қара тізімді қарап шығыңыз.
 # Құжаттама үшін https://www.mediawiki.org/wiki/Extension:SpamBlacklist бетін қараңыз
 #<!-- бұл жолды болған жағдайымен қалдырыңыз --> <pre>
#
# Синтаксисі келесідей:
#  * «#» нышанынан бастап жол аяғына дейінгілерінің бүкілі мәндеме деп саналады
#  * Бос емес әр жол тек URL жайлардың ішіндегі хосттарға сәйкес жүйелі айтылымдың (regex) бөлігі деп саналады

 #</pre> <!-- бұл жолды болған жағдайымен қалдырыңыз -->',
	'spam-whitelist' => ' #<!-- бұл жолды болған жағдайымен қалдырыңыз --> <pre>
# Осы тізімге сәйкес сыртқы URL жайлар *бұғатталмайды*,
# (қара тізімдегі жазбамен бұғатталған болса да).
#
# Синтаксисі келесідей:
#  * «#» нышанынан бастап жол аяғына дейінгілерінің бүкілі мәндеме деп саналады
#  * Бос емес әр жол тек URL жайлардың ішіндегі хосттарға сәйкес жүйелі айтылымдың (regex) бөлігі деп саналады

 #</pre> <!-- бұл жолды болған жағдайымен қалдырыңыз -->',
	'spam-invalid-lines' => 'Спам қара тізіміндегі келесі {{PLURAL:$1|жолда|жолдарда}} жарамсыз жүйелі {{PLURAL:$1|айтылым|айтылымдар}} бар, және бетті сақтаудың {{PLURAL:$1|бұны|бұларды}}  дұрыстау керек.',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'spam-blacklist' => ' # Osı tizimge säýkes sırtqı URL jaýlar betke üstewden buğattaladı.
 # Bul tizim tek mındağı wïkïge äser etedi; tağı da ğalamdıq qara tizimdi qarap şığıñız.
 # Qujattama üşin https://www.mediawiki.org/wiki/Extension:SpamBlacklist betin qarañız
 #<!-- bul joldı bolğan jağdaýımen qaldırıñız --> <pre>
#
# Sïntaksïsi kelesideý:
#  * «#» nışanınan bastap jol ayağına deýingileriniñ bükili mändeme dep sanaladı
#  * Bos emes är jol tek URL jaýlardıñ işindegi xosttarğa säýkes jüýeli aýtılımdıñ (regex) böligi dep sanaladı

 #</pre> <!-- bul joldı bolğan jağdaýımen qaldırıñız -->',
	'spam-whitelist' => ' #<!-- bul joldı bolğan jağdaýımen qaldırıñız --> <pre>
# Osı tizimge säýkes sırtqı URL jaýlar *buğattalmaýdı*,
# (qara tizimdegi jazbamen buğattalğan bolsa da).
#
# Sïntaksïsi kelesideý:
#  * «#» nışanınan bastap jol ayağına deýingileriniñ bükili mändeme dep sanaladı
#  * Bos emes är jol tek URL jaýlardıñ işindegi xosttarğa säýkes jüýeli aýtılımdıñ (regex) böligi dep sanaladı

 #</pre> <!-- bul joldı bolğan jağdaýımen qaldırıñız -->',
	'spam-invalid-lines' => 'Spam qara tizimindegi kelesi {{PLURAL:$1|jolda|joldarda}} jaramsız jüýeli {{PLURAL:$1|aýtılım|aýtılımdar}} bar, jäne betti saqtawdıñ {{PLURAL:$1|bunı|bulardı}}  durıstaw kerek.',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Klutzy
 * @author Kwj2772
 */
$messages['ko'] = array(
	'spam-blacklist' => ' # 이 필터에 해당하는 URL을 문서에 넣을 경우 해당 편집의 저장을 자동으로 막습니다.
 # 이 필터는 여기 위키 내에서만 적용됩니다. 광역 블랙리스트 기능이 있을 경우 해당 목록도 작동합니다.
 # 자세한 내용은 https://www.mediawiki.org/wiki/Extension:SpamBlacklist (영어) 문서를 참고해 주세요.
 #<!-- 이 줄은 편집하지 말아 주세요. 문서 모양을 위한 줄입니다.--> <pre>
# 
# 문법은 다음과 같습니다.
#  * "#"은 주석 기호입니다. 줄에서 #가 있는 부분부터의 글자는 모두 무시됩니다.
#  * 각 줄은 정규 표현식으로, URL 문장 내부를 검사하는 데에 사용됩니다.

 #</pre> <!-- 이 줄은 편집하지 말아 주세요. 문서 모양을 위한 줄입니다. -->',
	'spam-whitelist' => ' # <!-- 이 부분은 편집하지 말아 주세요. --> <pre>
# 이 목록에 포함되는 URL은 블랙리스트에 있더라도 문서 편집이 제한되지 않습니다.
#
# 문법은 다음과 같습니다.
# * "#"에서 그 줄의 끝까지는 주석입니다.
# * 모든 줄은 URL의 호스트와 일치하는 정규 표현식의 일부분입니다.

 #</pre> <!-- 이 부분은 편집하지 말아 주세요. -->',
	'email-blacklist' => ' # 이 리스트와 일치하는 이메일 주소는 등록과 이메일 발송이 금지됩니다.
 # 이 리스트는 이 위키에만 적용됩니다; 글로벌 블랙리스트도 함께 참조하십시오.
 # 설명 문서를 보시려면 https://www.mediawiki.org/wiki/Extension:SpamBlacklist 를 방문해주세요.
 #<!-- 이 줄은 그대로 두십시오 --> <pre>
#
# 문법은 다음과 같습니다:
# * "#" 다음부터 줄의 끝까지는 주석으로 취급됩니다
# * 빈 줄이 아닌 모든 줄은 이메일 주소의 호스트만 검사하는 정규 표현식입니다.

 #<!-- 이 줄은 그대로 두십시오 --> </pre>',
	'email-whitelist' => ' #<!-- 이 줄은 그대로 두십시오 --> <pre>
 # 이 리스트와 일치하는 이메일 주소는 블랙리스트에 올라가 있을지라도
 # 사용이 금지되지 않습니다.
 #
 #<!-- 이 줄은 그대로 두십시오 --> </pre>
#
 # 문법은 다음과 같습니다:
 # * "#" 다음부터 줄의 끝까지는 주석으로 취급됩니다
 # * 빈 줄이 아닌 모든 줄은 이메일 주소의 호스트만 검사하는 정규 표현식입니다.',
	'spam-blacklisted-email' => '이메일 주소가 블랙리스트됨',
	'spam-blacklisted-email-text' => '당신의 이메일 주소는 다른 사용자가 이메일을 보내지 못하도록 블랙리스트에 올라와 있습니다.',
	'spam-blacklisted-email-signup' => '입력한 이메일 주소는 사용할 수 없도록 블랙리스트되어 있습니다.',
	'spam-invalid-lines' => '스팸 블랙리스트의 다음 {{PLURAL:$1|줄}}에 잘못된 정규 표현식이 사용되어 저장하기 전에 바르게 고쳐져야 합니다:',
	'spam-blacklist-desc' => '정규 표현식을 이용해 스팸을 막습니다: [[MediaWiki:Spam-blacklist]]와 [[MediaWiki:Spam-whitelist]]를 사용합니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'spam-blacklist' => ' # URLs noh ußerhallef uß dä Leß wäde nit zojelohße, wann se einer in en Sigg erin don well.
 # He di Liß eß bloß för dat Wiki joot. Loor Der och de jemeinsame „schwazze Leß“ aan.
 # Dokkementeet is dat op https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Loß di Reih hee jenou esu wi se es --> <pre>
# Dä Opbou es:
# * Alles fun enem #-Zeiche bes an et Engk fun ene Reih es ene Kommentaa för de Minsche
# * Jede Reih met jet dren es en Stöck regular Expression, wat alleins Domains en URLs treffe kann

 #</pre> <!-- Lohß di Reih he jenou esu wi se es -->',
	'spam-whitelist' => ' #<!-- Loß di Reih hee jenou esu wi se es --> <pre>
# URLs noh ußerhallef uß dä Leß wäde dorschjelohße,
# sellefts wann se op en „schwazze Leß“ shtonn
# Dä Opbou es:
# * Alles fun enem #-Zeiche bes an et Engk fun ene Reih es ene Kommentaa för de Minsche
# * Jede Reih met jet dren es en Stöck regular Expression, wat alleins Domains en URLs treffe kann
 #</pre> <!-- Lohß di Reih he jenou esu wi se es -->',
	'spam-invalid-lines' => 'Mer han Fääler en <i lang="en">regular expressions</i> jefonge.
{{PLURAL:$1|De Reih unge stemmp nit un moß|Di $1 Reije unge stimme nit un möße|Dat he sull}}
för em Afspeichere eets en Odenung jebraat wäde:',
	'spam-blacklist-desc' => 'Jäje SPAM met <i lang="en">regular expressions</i> — övver en [[MediaWiki:Spam-blacklist|„schwazze Leß“]] un en [[MediaWiki:Spam-whitelist|Leß met Ußnahme dofun]].',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'spam-blacklisted-email' => 'Gespaart Mail-Adressen',
	'spam-blacklisted-email-text' => 'Är Mailadress ass elo gespaart fir anere Benotzer Mailen ze schécken.',
	'spam-blacklisted-email-signup' => "D'Mailadress déi Dir uginn hutt ass elo gespaart fir anere Benotzer Mailen ze schécken.",
	'spam-blacklist-desc' => 'Op regulären Ausdréck (Regex) opgebauten Tool: [[MediaWiki:Spam-blacklist]] a [[MediaWiki:Spam-whitelist]]',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'spam-blacklist' => " # Externe URL's die voldoen aan deze lijst waere geweigerd bie 't
 # toevoege aan 'n pagina. Deze lijst haet allein invloed op deze wiki.
 # Er bestaot ouk 'n globale zwarte lijst.
 # Documentatie: https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- laot deze lien --> <pre>
#
# De syntax is as volg:
#  * Alles vanaaf 't karakter \"#\" tot 't einde van de regel is opmerking
#  * Iedere niet-lege regel is 'n fragment van 'n reguliere oetdrukking die
#    alleen van toepassing is op hosts binne URL's.

 #</pre> <!-- laot deze lien -->",
	'spam-whitelist' => " #<!-- laot deze lien --> <pre>
# Externe URL's die voldoen aan deze lijst, waere *nooit* geweigerd, al
# zoude ze geblokkeerd motte waere door regels oet de zwarte lijst.
#
# De syntaxis is es volg:
#  * Alles vanaaf 't karakter \"#\" tot 't einde van de regel is opmerking
#  * Iddere neet-lege regel is 'n fragment van 'n reguliere oetdrukking die
#    allein van toepassing is op hosts binne URL's.

 #</pre> <!-- laot deze lien -->",
	'spam-invalid-lines' => "De volgende {{PLURAL:$1|regel|regel}} van de zwarte lies {{PLURAL:$1|is 'n|zeen}} onzjuuste reguliere {{PLURAL:$1|oetdrukking|oetdrukkinge}}  en {{PLURAL:$1|mót|mótte}} verbaeterd waere alveures de pazjena kin waere opgeslage:",
	'spam-blacklist-desc' => 'Antispamfunctionaliteit via reguliere expressies: [[MediaWiki:Spam-blacklist]] en [[MediaWiki:Spam-whitelist]]',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'spam-blacklist' => '# Надворешните URL адреси кои одговараат на наведеното на овој список ќе бидат блокирани кога ќе се постават на страница.
  # Овој список важи само за ова вики; погледајте ја и глобалниот црн список.
  # За документација, видете https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- leave this line exactly as it is --> <pre>
#
# Синтаксата е следнава:
#  * Сè од знакот „#“ до крајот на редот е коментар
#  * Секој ред кој не е празен е фрагмент од регуларен израз кој се совпаѓа само со домаќини во URL адреси

  #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => '  #<!-- leave this line exactly as it is --> <pre>
# Надворешните URL адреси одговараат на списокот *нема* да бидат блокирани дури и во случај да
# се блокирани од ставки на црниот список.
#
# Синтаксата е следнава:
#  * Сè од знакот „#“ до крајот на редот е коментар
#  * Секој ред кој не е празен е фрагмент од регуларен израз кој се совпаѓа само со домаќини во URL адреси

  #</pre> <!-- leave this line exactly as it is -->',
	'email-blacklist' => '# На е-поштенските адреси што ќе се совпаднат со списоков *нема* ќе им биде забрането регистрирањето и испраќањето на пошта
# Списоков важи само за ова вики; погледајте го и глобалниот црн список.
# Документација ќе најдете на https://www.mediawiki.org/wiki/Extension:SpamBlacklist
#<!-- не менувајте го овој ред --> <pre>
#
# Синтаксата е следнава:
#   * Сето она што се наоѓа по знакот „#“ (па до крајот на редот) е коментар
#   * Секој непразен ред е извадок од регуларен израз кој одговара само на домаќини во е-пошта

 #</pre> <!-- не менувајте го овој ред -->',
	'email-whitelist' => '#<!-- не менувајте го овој ред --> <pre>
# Е-поштенските адреси што ќе се совпаднат со списоков *нема* да бидат блокирани, дури и 
# ако треба да се блокираат согласно записите во црниот список.
#
 #</pre> <!-- не менувајте го овој ред -->
# Синтаксата е следнава:
#  * Сето она што стои по знакот „#“ (па до крајот на редот) е коментар
#  * Секој непразен ред е извадок од регуларен израз кој одговара само на домаќини во е-пошта',
	'spam-blacklisted-email' => 'Забранета адреса',
	'spam-blacklisted-email-text' => 'На вашата адреса моментално не ѝ е дозволено за испраќа пошта.',
	'spam-blacklisted-email-signup' => 'Употребата на дадената адреса е моментално забранета.',
	'spam-invalid-lines' => '{{PLURAL:$1|Следниов ред во црниот список на спам е|Следниве редови во црниот список на спам се}} {{PLURAL:$1|погрешен регуларен израз|погрешни регуларни изрази}} и {{PLURAL:$1|треба да се поправи|треба да се поправат}} пред да се зачува страницата:',
	'spam-blacklist-desc' => 'Антиспам алатка на основа на регуларни изрази: [[MediaWiki:Spam-blacklist]] и [[MediaWiki:Spam-whitelist]]',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'spam-blacklist' => '# ഈ ലിസ്റ്റുമായി ഒത്തുപോകുന്ന പുറത്തേയ്ക്കുള്ള യൂ.ആർ.എല്ലുകൾ താളിൽ ചേർക്കപ്പെട്ടാൽ തടയുന്നതായിരിക്കും.
  # ഈ ലിസ്റ്റ് ഈ വിക്കിയ്ക്കു മാത്രം ബാധകമായ ഒന്നാണ്; ആഗോള കരിമ്പട്ടികയും പരിശോധിക്കുക.
  # ഉപയോഗ സഹായിയ്ക്കായി https://www.mediawiki.org/wiki/Extension:SpamBlacklist കാണുക
  #<!-- ഈ വരിയിൽ മാറ്റം വരുത്തരുത് --> <pre>
#
# എഴുതേണ്ട രീതി താഴെ കൊടുക്കുന്നു:
#  * "#" ലിപിയിൽ തുടങ്ങി വരിയുടെ അവസാനം വരെയുള്ള എന്തും കുറിപ്പ് (comment) ആയി കണക്കാക്കും
#  * Every non-blank line is a regex fragment which will only match hosts inside URLs

  #</pre> <!-- ഈ വരിയിൽ മാറ്റം വരുത്തരുത് -->',
	'spam-whitelist' => '  #<!-- ഈ വരി ഇതുപോലെ തന്നെ സൂക്ഷിക്കുക --> <pre>
# കരിമ്പട്ടികയിലെ ഉൾപ്പെടുത്തലുകളുമായി ഒത്തുപോയെങ്കിൽ കൂടി,
# ഈ ലിസ്റ്റുമായി ഒത്തുപോകുന്ന പുറത്തുനിന്നുള്ള യൂ.ആർ.എല്ലുകൾ തടയപ്പെടുക *ഇല്ല*
#
# എഴുത്തുരീതി താഴെ കൊടുക്കുന്നു:
#  * "#" അക്ഷരത്തിൽ തുടങ്ങി വരിയുടെ അവസാനം വരെയുള്ളതെന്തും കുറിപ്പായി കണക്കാക്കും
#  * റെജെക്സ് ഘടകത്തിലെ ശൂന്യമല്ലാത്ത വരികൾ എല്ലാം ആന്തരിക യൂ.ആർ.എല്ലുമായി ഒത്തു നോക്കുകയുള്ളു

  #</pre> <!-- ഈ വരി ഇതുപോലെ തന്നെ സൂക്ഷിക്കുക -->',
	'spam-blacklisted-email' => 'കരിമ്പട്ടികയിൽ പെട്ട ഇമെയിൽ',
	'spam-invalid-lines' => 'താഴെ കൊടുത്തിരിക്കുന്ന പാഴെഴുത്ത് കരിമ്പട്ടികയിലെ {{PLURAL:$1|വരി ഒരു|വരികൾ}} അസാധുവായ റെഗുലർ {{PLURAL:$1|എക്സ്‌‌പ്രെഷൻ|എക്സ്‌‌പ്രെഷനുകൾ}} ആണ്, താൾ സേവ് ചെയ്യുന്നതിനു മുമ്പ് {{PLURAL:$1|അത്|അവ}} ശരിയാക്കേണ്ടതുണ്ട്:',
	'spam-blacklist-desc' => 'റെജെക്സ്-അധിഷ്ഠിത പാഴെഴുത്ത് തടയൽ ഉപകരണം: [[MediaWiki:Spam-blacklist]] ഒപ്പം [[MediaWiki:Spam-whitelist]]',
);

/** Marathi (मराठी)
 * @author Hiteshgotarane
 * @author Kaustubh
 * @author Rahuldeshmukh101
 */
$messages['mr'] = array(
	'spam-blacklist' => ' # या यादीशी जुळणारे बाह्य दुवे एखाद्या पानावर दिल्यास ब्लॉक केले जातील.
 # ही यादी फक्त या विकिसाठी आहे, सर्व विकिंसाठीची यादी सुद्धा तपासा.
 # अधिक माहिती साठी पहा https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# रुपरेषा खालीलप्रमाणे:
#  * "#" ने सुरु होणारी ओळ शेरा आहे
#  * प्रत्येक रिकामी नसलेली ओळ अंतर्गत URL जुळविणारी regex फ्रॅगमेंट आहे

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' # या यादीशी जुळणारे बाह्य दुवे एखाद्या पानावर दिल्यास ब्लॉक केले *जाणार नाहीत*.
 # ही यादी फक्त या विकिसाठी आहे, सर्व विकिंसाठीची यादी सुद्धा तपासा.
 # अधिक माहिती साठी पहा http://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# रुपरेषा खालीलप्रमाणे:
#  * "#" ने सुरु होणारी ओळ शेरा आहे
#  * प्रत्येक रिकामी नसलेली ओळ अंतर्गत URL जुळविणारी regex फ्रॅगमेंट आहे

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-blacklisted-email' => 'प्रतिबंधित  विपत्र पत्ता',
	'spam-blacklisted-email-text' => 'तुमचा ई-पत्ता काळ्या यादीत समाविष्ट करण्यात आला आहे. इतर सदस्यांना संपर्क करणे शक्य नाही.',
	'spam-blacklisted-email-signup' => 'दिलेला विपत्र पत्ता सद्य वापरण्यास प्रतिबंधित केलेला आहे',
	'spam-invalid-lines' => 'हे पान जतन करण्यापूर्वी खालील {{PLURAL:$1|ओळ जी चुकीची|ओळी ज्या चुकीच्या}} एक्स्प्रेशन {{PLURAL:$1|आहे|आहेत}}, दुरुस्त करणे गरजेचे आहे:',
	'spam-blacklist-desc' => 'रेजएक्स वर चालणारे स्पॅम थांबविणारे उपकरण: [[MediaWiki:Spam-blacklist]] व [[MediaWiki:Spam-whitelist]]',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'spam-blacklist' => '# URL luar yang sepadan dengan mana-mana entri dalam senarai ini akan disekat daripada ditambah ke dalam sesebuah laman.
# Senarai ini melibatkan wiki ini sahaja; sila rujuk juga senarai hitam sejagat. 
# Sila baca dokumentasi di https://www.mediawiki.org/wiki/Extension:SpamBlacklist
#<!-- jangan ubah baris ini --> <pre>
#
# Sintaks adalah seperti berikut:
#  * Semuanya mulai aksara "#" hingga akhir baris merupakan komen
#  * Setiap baris yang tidak kosong meruakan pecahan ungkapan nalar yang hanya akan berpadan dengan hos-hos dalam alamat e-mel

 #</pre> <!-- jangan ubah baris ini -->',
	'spam-whitelist' => ' #<!-- jangan ubah baris ini --> <pre>
# URL luar yang sepadan dengan mana-mana entri dalam senarai ini tidak akan
# disekat walaupun terdapat juga dalam senarai hitam.
#
# Sintaks:
#  * Aksara "#" sampai akhir baris diabaikan
#  * Ungkapan nalar dibaca daripada setiap baris dan dipadankan dengan nama hos sahaja

 #</pre> <!-- jangan ubah baris ini -->',
	'email-blacklist' => ' # Alamat-alamat e-mel yang berpadanan dengan senarai ini akan disekat daripada mendaftar atau menghantar e-mel
 # Senarai ini melibatkan wiki ini sahaja; sila rujuk juga senarai hitam sejagat.
 # Untuk dokumentasi, rujuk https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- jangan ubah baris ini --> <pre>
#
# Sintaks adalah seperti berikut:
#   * Semuanya mulai aksara "#" hingga akhir baris merupakan komen
#   * Setiap baris yang tidak kosong meruakan pecahan ungkapan nalar yang hanya akan berpadan dengan hos-hos dalam alamat e-mel

 #</pre> <!-- jangan ubah baris ini -->',
	'email-whitelist' => ' #<!-- jangan ubah baris ini --> <pre>
# Alamat-alamat e-mel yang berpadanan dengan senarai ini *tidak* akan disekat sungguhpun boleh
# disekat oleh entri senarai hitam.
#
 #</pre> <!-- jangan ubah baris ini -->
# Sintaks adalah seperti berikut:
#   * Segalanya mulai aksara "#" hingga akhir baris ialah komen
#   * Setiap baris yang tidak kosong meruakan pecahan ungkapan nalar yang hanya akan berpadan dengan hos-hos dalam alamat e-mel',
	'spam-blacklisted-email' => 'E-mel yang Disenaraihitamkan',
	'spam-blacklisted-email-text' => 'Alamat e-mel anda kini disenaraihitamkan daripada menghantar e-mel kepada pengguna lain.',
	'spam-blacklisted-email-signup' => 'Alamat e-mel yang diberikan ini kini disenaraihitamkan.',
	'spam-invalid-lines' => '{{PLURAL:$1|Baris|Baris-baris}} berikut menggunakan ungkapan nalar yang tidak sah. Sila baiki senarai hitam ini sebelum menyimpannya:',
	'spam-blacklist-desc' => 'Alat anti-spam berdasarkan ungkapan nalar: [[MediaWiki:Spam-blacklist]] dan [[MediaWiki:Spam-whitelist]]',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'spam-blacklist' => ' # Eksterne URL-er som finnes på denne lista vil ikke kunne legges til på en side.
 # Denne listen gjelder kun denne wikien; se også den globale svartelistinga.
 # For dokumentasjon, se http://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- La denne linja være nøyaktig som den er --> <pre>
#
# Syntaksen er som følgende:
#  * Alle linjer som begynner med «#» er kommentarer
#  * Alle ikke-blanke linjer er et regex-fragment som kun vil passe med domenenavn i URL-er

 #</pre> <!-- la denne linja være nøyaktig som den er -->',
	'spam-whitelist' => ' #<!-- la denne linja være nøyaktig som den er --> <pre>
# Eksterne URL-er på denne lista vil *ikke* blokkeres, selv om
# de ellers ville vært blokkert av svartelista.
#
# Syntaksen er som følger:
#  * Alle linjer som begynner med «#» er kommentarer
#  * Alle ikke-blanke linjer er et regex-fragment som kun vil passe med domenenavn i URL-er

 #</pre> <!-- la denne linja være nøyaktig som den er -->',
	'spam-invalid-lines' => 'Følgende {{PLURAL:$1|linje|linjer}} i spamsvartelista er {{PLURAL:$1|et ugyldig regulært uttrykk|ugyldige regulære uttrykk}} og må rettes før lagring av siden:',
	'spam-blacklist-desc' => 'Antispamverktøy basert på regulære uttrykk: [[MediaWiki:Spam-blacklist]] og [[MediaWiki:Spam-whitelist]]',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'spam-blacklist' => '  # URLs na buten de Websteed in disse List stoppt dat Spiekern vun de Sied.
  # Disse List gellt blot för dit Wiki; kiek ok na de globale Swartlist.
  # För mehr Infos kiek op https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- Disse Reeg dröff nich ännert warrn! --> <pre>
#
# Syntax:
#  * Allens vun dat „#“-Teken af an bet to dat Enn vun de Reeg is en Kommentar
#  * Elkeen Reeg, de nich leddig is, is en regulären Utdruck, bi den nakeken warrt, wat he op de Host-Naams in de URLs passt

  #</pre> <!-- Disse Reeg dröff nich ännert warrn! -->',
	'spam-whitelist' => '  #<!-- Disse Reeg dröff nich ännert warrn! --> <pre>
# URLs na buten de Websteed in disse List stoppt dat Spiekern vun de Sied nich, ok wenn se
# in de globale oder lokale swarte List in sünd.
#
# Syntax:
#  * Allens vun dat „#“-Teken af an bet to dat Enn vun de Reeg is en Kommentar
#  * Elkeen Reeg, de nich leddig is, is en regulären Utdruck, bi den nakeken warrt, wat he op de Host-Naams in de URLs passt

  #</pre> <!-- Disse Reeg dröff nich ännert warrn! -->',
	'spam-invalid-lines' => 'Disse {{PLURAL:$1|Reeg|Regen}} in de Spam-Swartlist {{PLURAL:$1|is en ungülligen regulären Utdruck|sünd ungüllige reguläre Utdrück}}. De {{PLURAL:$1|mutt|mööt}} utbetert warrn, ehrdat de Sied spiekert warrn kann:',
	'spam-blacklist-desc' => 'Regex-baseert Anti-Spam-Warktüüch: [[MediaWiki:Spam-blacklist]] un [[MediaWiki:Spam-whitelist]]',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'spam-blacklist' => ' # Externe URL\'s die voldoen aan deze lijst worden geweigerd bij het
 # toevoegen aan een pagina. Deze lijst heeft alleen invloed op deze wiki.
 # Er bestaat ook een globale zwarte lijst.
 # Documentatie: https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- laat deze lijn zoals hij is --> <pre>
#
# De syntax is als volgt:
#   * Alles vanaf het karakter "#" tot het einde van de regel is opmerking
#   * Iedere niet-lege regel is een fragment van een reguliere uitdrukking die
#     alleen van toepassing is op hosts binnen URL\'s.

 #</pre> <!-- laat deze lijn zoals hij is -->',
	'spam-whitelist' => ' #<!-- laat deze lijn zoals hij is --> <pre>
# Externe URL\'s die voldoen aan deze lijst, worden *nooit* geweigerd, al
# zouden ze geblokkeerd moeten worden door regels uit de zwarte lijst.
#
# De syntaxis is als volgt:
#   * Alles vanaf het karakter "#" tot het einde van de regel is opmerking
#   * Iedere niet-lege regel is een fragment van een reguliere uitdrukking die
#     alleen van toepassing is op hosts binnen URL\'s.

 #</pre> <!-- laat deze lijn zoals hij is -->',
	'email-blacklist' => ' # E-mailadressen die voldoen aan deze lijst worden geblokkeerd bij het registreren of het verzenden van e-mails.
 # Deze lijst heeft alleen invloed op deze wiki. Er bestaat ook een globale zwarte lijst.
 # Documentatie: https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- laat deze lijn zoals hij is --> <pre>
#
# De syntax is als volgt:
#   * Alles vanaf het karakter "#" tot het einde van de regel is een opmerking
#   * Iedere niet-lege regel is een fragment van een reguliere uitdrukking die
#     alleen van toepassing is op hosts binnen e-mailadressen.

 #</pre> <!-- laat deze lijn zoals hij is -->',
	'email-whitelist' => ' #<!-- laat deze lijn zoals hij is --> <pre>
# E-mailadressen die voldoen aan deze lijst, worden *nooit* geweigerd, al
# zouden ze geblokkeerd moeten worden door regels uit de zwarte lijst.
#
# De syntaxis is als volgt:
#   * Alles vanaf het karakter "#" tot het einde van de regel is opmerking
#   * Iedere niet-lege regel is een fragment van een reguliere uitdrukking die
#     alleen van toepassing is op hosts binnen e-mailadressen.

 #</pre> <!-- laat deze lijn zoals hij is -->',
	'spam-blacklisted-email' => 'E-mailadres op de zwarte lijst',
	'spam-blacklisted-email-text' => 'Uw e-mailadres staat momenteel op de zwarte lijst waardoor u geen e-mails naar andere gebruikers kunt verzenden.',
	'spam-blacklisted-email-signup' => 'Het opgegeven e-mailadres staat momenteel op de zwarte lijst.',
	'spam-invalid-lines' => 'De volgende {{PLURAL:$1|regel|regels}} van de zwarte lijst {{PLURAL:$1|is een|zijn}} onjuiste reguliere {{PLURAL:$1|uitdrukking|uitdrukkingen}}  en {{PLURAL:$1|moet|moeten}} verbeterd worden alvorens de pagina kan worden opgeslagen:',
	'spam-blacklist-desc' => 'Antispamfunctionaliteit via reguliere expressies: [[MediaWiki:Spam-blacklist]] en [[MediaWiki:Spam-whitelist]]',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 */
$messages['nn'] = array(
	'spam-blacklist' => ' # Eksterne URL-ar som finnst på denne lista vil ikkje kunne leggast til på ei side.
 # Denne lista gjeld berre denne wikien; sjå òg den globale svartelistinga.
 # For dokumentasjon, sjå https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- La denne linja vere nøyaktig som ho er --> <pre>
#
# Syntaksen er som følgjer:
#  * Alle linjer som byrjar med «#» er kommentarar
#  * Alle ikkje-blanke linjer er eit regex-fragment som berre vil passe med domenenavn i URL-ar

 #</pre> <!-- la denne linja vere nøyaktig som ho er -->',
	'spam-whitelist' => ' #<!-- la denne linja vere nøyaktig som ho er --> <pre>
# Eksterne URL-ar på denne lista vil *ikkje* blokkerast, sjølv om
# dei elles ville vorte blokkert av svartelista.
#
# Syntaksen er som følgjer:
#  * Alle linjer som byrjar med «#» er kommentarar
#  * Alle ikkje-blanke linjer er eit regex-fragment som berre vil passe med domenenamn i URL-ar

 #</pre> <!-- la denne linja vere nøyaktig som ho er -->',
	'spam-invalid-lines' => 'Følgjande {{PLURAL:$1|linje|linjer}} i spamsvartelista er {{PLURAL:$1|eit ugyldig regulært uttrykk|ugyldige regulære uttrykk}} og må rettast før lagring av sida:',
	'spam-blacklist-desc' => 'Antispamverktøy basert på regulære uttrykk: [[MediaWiki:Spam-blacklist]] og [[MediaWiki:Spam-whitelist]]',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'spam-blacklist' => "# Los ligams extèrnes que fan partida d'aquesta lista seràn blocats al moment de lor insercion dins una pagina. # Aquesta lista concernís pas que Wikinews ; referissètz-vos tanben a la lista negra generala de Meta. # La documentacion se tròba a l’adreça seguenta : http://www.MediaWiki.org/wiki/Extension:SpamBlacklist # <!--Daissatz aquesta linha tala coma es --> <pre> # # La sintaxi es la seguenta # * Tot tèxte que seguís lo « # » es considerat coma un comentari. # * Tota linha pas voida es un fragment regex que concernís pas que los ligams ipertèxtes. #</pre> <!--Daissatz aquesta linha tala coma es -->",
	'spam-whitelist' => " #<!--Daissatz aquesta linha tala coma es --> <pre>
# Los ligams extèrnes que fan partida d'aquesta lista seràn blocas al moment de lor insercion dins una pagina. 
# Aquesta lista concernís pas que Wikinews ; referissetz-vos tanben a la lista negra generala de Meta. 
 # La documentacion se tròba a l’adreça seguenta : http://www.mediawiki.org/wiki/Extension:SpamBlacklist 
#
# La sintaxi es la seguenta :
# * Tot tèxte que seguís lo « # » es considerat coma un comentari.
# * Tota linha pas voida es un fragment regex que concernís pas que los ligams ipertèxtes.

 #</pre> <!--Daissatz aquesta linha tala coma es -->",
	'spam-invalid-lines' => "{{PLURAL:$1|La linha seguenta |Las linhas seguentas}} de la lista dels spams {{PLURAL:$1|es redigida|son redigidas}} d'un biais incorrècte e {{PLURAL:$1|necessita|necessitan}} las correccions necessàrias abans tot salvament de la pagina :",
	'spam-blacklist-desc' => "Aisina antispam basada sus d'expressions regularas : ''[[MediaWiki:Spam-blacklist]]'' et ''[[MediaWiki:Spam-whitelist]]''",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'spam-blacklist' => ' # ଏକ ଫୃଷ୍ଠାରେ ଯୋଡ଼ାଯାଉଥିବା ବାହାର URL ଏହି ତାଲିକା ସହ ମେଳ ଖାଇଲେ ତାହାକୁ ଅଟକାଇଦିଆଯିବ ।
 # ଏହି ତାଲିକା କେବଳ କେବଳ ଏହି ଉଇକିକୁ ପ୍ରଭାବିତ କରିଥାଏ; ଜଗତ ଅଟକତାଲିକା ମଧ୍ୟ ଦେଖିପାରନ୍ତି ।
 # ଦଲିଲକରଣ ନିମନ୍ତେ ଦୟାକରି https://www.mediawiki.org/wiki/Extension:SpamBlacklist ଦେଖନ୍ତୁ ।
 #<!-- ଏହି ଧାଡ଼ିଟି ଯେଉଁପରି ଅଛି ଅବିକଳ ସେହିପରି ଛାଡ଼ି ଦିଅନ୍ତୁ --> <pre>
#
# ସିଣ୍ଟାକ୍ସ:
#   * "#" ଚିହ୍ନ ଠାରୁ ଧାଡ଼ିର ଶେଷ ଯାଏଁ ଏକ ମତ
#   * ସବୁ ଅଣ-ଖାଲି ଧାଡ଼ି ଏକ regex ଖଣ୍ଡ ଯାହା କେବଳ URL ଭିତରେ ଥିବା ହୋଷ୍ଟ ସହ ମେଳନ କରିଥାଏ

 #</pre> <!-- ଏହି ଧାଡ଼ିଟି ଯେଉଁପରି ଅଛି ଅବିକଳ ସେହିପରି ଛାଡ଼ି ଦିଅନ୍ତୁ -->',
	'spam-whitelist' => ' #<!-- ଏହି ଧାଡ଼ିଟି ଯେଉଁପରି ଅଛି ଅବିକଳ ସେହିପରି ଛାଡ଼ି ଦିଅନ୍ତୁ --> <pre>
# ଯଦି ସେସବୁ ଅଟକତାଲିକାରେ ଥାଏ ତେବେ ମଧ୍ୟ
 # ଏକ ଫୃଷ୍ଠାରେ ଯୋଡ଼ାଯାଉଥିବା ବାହାର URL ଏହି ତାଲିକା ସହ ମେଳ ଖାଉଥିଲେ ତାହାକୁ ଅଟକାଇ ଦିଆଯିବ *ନାହିଁ*
#
# ସିଣ୍ଟାକ୍ସ:
#   * "#" ଚିହ୍ନ ଠାରୁ ଧାଡ଼ିର ଶେଷ ଯାଏଁ ଏକ ମତ
#   * ସବୁ ଅଣ-ଖାଲି ଧାଡ଼ି ଏକ regex ଖଣ୍ଡ ଯାହା କେବଳ URL ଭିତରେ ଥିବା ହୋଷ୍ଟ ସହ ମେଳନ କରିଥାଏ

 #</pre> <!-- ଏହି ଧାଡ଼ିଟି ଯେଉଁପରି ଅଛି ଅବିକଳ ସେହିପରି ଛାଡ଼ି ଦିଅନ୍ତୁ -->',
	'spam-invalid-lines' => 'ଏହି ସ୍ପାମ ଅଟକତାଲିକା {{PLURAL:$1|ଧାଡ଼ିଟି|ଧାଡ଼ିସବୁ}} ଅଚଳ ସାଧାରଣ {{PLURAL:$1|ପରିପ୍ରକାଶ|ପରିପ୍ରକାଶ}} ଓ ସାଇତିବା ଆଗରୁ  {{PLURAL:$1|ତାହାକୁ  ସୁଧାରିବା ଲୋଡ଼ା|ସେହିସବୁକୁ ସୁଧାରିବା ଲୋଡ଼ା}}:',
	'spam-blacklist-desc' => 'Regex-ଭିତ୍ତିକ ସ୍ପାମ-ବିରୋଧୀ ଉପକରଣ: [[MediaWiki:Spam-blacklist]] ଓ [[MediaWiki:Spam-whitelist]]',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'spam-blacklist' => '  # Dodawanie w treści stron linków zewnętrznych pasujących do tej listy będzie blokowane.
  # Lista dotyczy wyłącznie tej wiki; istnieje też globalna czarna lista.
  # Dokumentacja znajduje się na stronie https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- zostaw tę linię dokładnie tak, jak jest --> <pre>
#
# Składnia jest następująca:
#   * Wszystko od znaku „#” do końca linii jest komentarzem
#   * Każda niepusta linia jest fragmentem wyrażenia regularnego, które będzie dopasowywane jedynie do hostów wewnątrz linków

  #</pre> <!-- zostaw tę linię dokładnie tak, jak jest -->',
	'spam-whitelist' => ' #<!-- zostaw tę linię dokładnie tak, jak jest --> <pre>
# Linki zewnętrzne pasujące do tej listy *nie będą* blokowane nawet jeśli
# zostałyby zablokowane przez czarną listę.
#
# Składnia jest następująca:
#   * Wszystko od znaku „#” do końca linii jest komentarzem
#   * Każda niepusta linia jest fragmentem wyrażenia regularnego, które będzie dopasowywane jedynie do hostów wewnątrz linków

 #</pre> <!-- zostaw tę linię dokładnie tak, jak jest -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Następująca linia jest niepoprawnym wyrażeniem regularnym i musi być poprawiona przed zapisaniem strony:|Następujące linie są niepoprawnymi wyrażeniami regularnymi i muszą być poprawione przed zapisaniem strony:}}',
	'spam-blacklist-desc' => 'Narzędzie antyspamowe oparte o wyrażenia regularne: [[MediaWiki:Spam-blacklist|spam – lista zabronionych]] oraz [[MediaWiki:Spam-whitelist|spam – lista dozwolonych]]',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'spam-blacklist' => "# J'adrësse esterne ch'as treuva ant sta lista-sì a vniran blocà se cheidun a jë gionta ansima a na pàgina. # Sta lista a l'ha valor mach an sta wiki-sì; ch'a-j fasa arferiment ëdcò a la lista nèira global. # Për dla documentassion ch'a varda http://www.MediaWiki.org/wiki/Extension:SpamBlacklist #<!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é --> <pre> # # La sintassi a l'é: # * Tut lòn ch'as anandia con na \"#\" fin a la fin dla riga as ten coma coment # * Qualsëssìa riga nen veuja a resta un tòch d'espression regolar ch'as paragon-a a ij nòm ëd servent andrinta a j'adrësse #</pre> <!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é -->",
	'spam-whitelist' => "#<!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é --> <pre> # J'adrësse esterne coma cole dë sta lista a vniran NEN blocà, ëdcò fin-a # s'a fusso da bloché conforma a le régole dla lista nèira. # # La sintassi a l'é: # * Tut lòn ch'as anandia con na \"#\" fin a la fin dla riga as ten coma coment # * Qualsëssìa riga nen veuja a resta un tòch d'espression regolar ch'as paragon-a a ij nòm ëd servent andrinta a j'adrësse #</pre> <!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é -->",
	'email-blacklist' => "# J'adrësse e-mail ch'as treuva ant sta lista-sì a vniran blocà da registresse o mandé e-mai. 
# Sta lista a l'ha valor mach an sta wiki-sì; ch'a-j fasa arferiment ëdcò a la lista nèira global. 
# Për dla documentassion ch'a varda http://www.mediawiki.org/wiki/Extension:SpamBlacklist 
#<!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é --> <pre> 
# 
# La sintassi a l'é: 
# * Tut lòn ch'as anandia con na \"#\" fin a la fin dla riga as ten coma coment # 
* Qualsëssìa riga nen veujda a resta un tòch d'espression regolar ch'as paragon-a a ij nòm ëd servent andrinta a j'adrësse 

#</pre> <!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é -->",
	'email-whitelist' => "#<!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é --> <pre> 
# J'adrësse e-mail ch'as treuva ant sta lista-sì a vniran *pa* blocà combin ch'a sio
# stàite blocà da vos ëd lista nèira.
# 
#</pre> <!-- ch'a lassa sta riga-sì giusta 'me ch'a l'é -->
# La sintassi a l'é: 
# * Tut lòn ch'as anandia con na \"#\" fin a la fin dla riga as ten coma coment 
# * Qualsëssìa riga nen veujda a resta un tòch d'espression regolar ch'as paragon-a a ij nòm ëd servent andrinta a j'adrësse",
	'spam-blacklisted-email' => 'Adrëssa e-mail an lista nèira',
	'spam-blacklisted-email-text' => "Toa adrëssa e-mail a l'é al moment an lista nèira për mandé e-mail a àutri utent.",
	'spam-blacklisted-email-signup' => "L'adrëssa e-mail dàita a l'é a moment an ista nèira për l'usagi.",
	'spam-invalid-lines' => "{{PLURAL:$1|St'|Sti}} element dla lista nèira dla rumenta ëd reclam a {{PLURAL:$1|l'é|son}} {{PLURAL:$1|n'|dj'}}espression regolar nen {{PLURAL:$1|bon-a|bon-e}} e a l'{{PLURAL:$1|ha|han}} da manca d'esse coregiùe anans che salvé la pàgina:",
	'spam-blacklist-desc' => 'Strument anti-spam basà an dzora a Regex: [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'spam-blacklist' => '# بارلے یو آر ایل جیہڑے ایس لسٹ نال رلدے ہون جدوں اوناں ایس صفے نال جوڑیا جاۓ گا تے اوناں نوں روک دتا جاؤکا۔
# ایہ لسٹ صرف ایس وکی نال جڑی اے؛ جگت روکلسٹ نوں وی ویکھو۔
# ڈوکومنٹیشن ل‏ی ویکھو  https://www.mediawiki.org/wiki/Extension:SpamBlacklist
# <!-- ایس لین نوں اینج ای چھوڑ جنج اے ہے --> <pre>
#
# سینٹیکس ایہ اے:
# * ہرشے  "#" توںلے کے لین دے انت تک اک کومنٹ اے
# * ہر ناں خالی لین اک ریجیکس فریگمنٹ اے جیہڑی یو آر ایل دے اندر ہوسٹو نال رلے گی۔

#</pre> <!-- ایس لین نوں انج ای چھوڑ دیو جنج ایہ ہے -->',
	'spam-whitelist' => '# <!-- ایس لین نوں اینج ای چھوڑ جنج اے ہے --> <pre>
# بارلے یو آر ایل جیہڑے ایس لسٹ نال رلدے ہون جدوں اوناں ایس صفے نال جوڑیا جاۓ گا تے اوناں نوں نئیں روکیا جاویگا پاویں اوناں نوں بلیکلسٹ انٹریز چ روکیا گیا ہووے۔
#
# سینٹیکس ایہ اے:
# * ہرشے  "#" توںلے کے لین دے انت تک اک کومنٹ اے
# * ہر ناں خالی لین اک ریجیکس فریگمنٹ اے جیہڑی یو آر ایل دے اندر ہوسٹو نال رلے گی۔

#</pre> <!-- ایس لین نوں انج ای چھوڑ دیو جنج ایہ ہے -->',
	'spam-invalid-lines' => 'تھلے دتی گئی سپام کالیلسٹ {{انیک:$1|lلین|لیناں}} ناں منی جان والی ریگولر {{انیک:$1|ایکسپریشن|ایکسپریشناں}} تے {{انیک:$1|لوڑاں|لوڑ}} نوں ٹھیک کرنا ضروری صفہ بچان توں پہلے:',
	'spam-blacklist-desc' => 'ریجیکس تے بنیا سپام ویری اوزار: [[میڈیاوکی:سپام روک لسٹ]] تے [[میڈیاوکی:سپام چٹی لسٹ]]',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'spam-blacklist' => '  # URLs externas que coincidam com esta lista serão bloqueadas quando forem
  # adicionadas a uma página.
  # Esta lista aplica-se apenas a esta wiki. Consulte também a lista-negra global.
  # Veja a documentação em https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- mantenha esta linha exatamente assim --> <pre>
#
# A sintaxe é a seguinte:
#  * Tudo o que estiver após um "#" até o final de uma linha é um comentário
#  * Todas as linhas que não estiverem em branco são um fragmento de expressão regular
#    (regex) de busca, que só poderão coincidir com hosts na URL

  #</pre> <!-- mantenha esta linha exatamente assim -->',
	'spam-whitelist' => ' #<!-- mantenha esta linha exatamente assim --> <pre>
# URLs externas que coincidam com esta lista *não* serão bloqueadas mesmo
# se tiverem sido bloqueadas por entradas presentes nas listas negras.
#
# A sintaxe é a seguinte:
#  * Tudo o que estiver após um "#" até o final de uma linha será tido como um comentário
#  * Todas as linhas que não estiverem em branco são um fragmento de expressão regular (regex) que abrangem apenas a URL especificada

 #</pre> <!-- mantenha esta linha exatamente assim -->',
	'spam-invalid-lines' => "{{PLURAL:$1|A entrada|As entradas}} abaixo {{PLURAL:$1|é uma expressão regular|são expressões regulares}}  ''(regex)'' {{PLURAL:$1|inválida e precisa|inválidas e precisam}} de ser {{PLURAL:$1|corrigida|corrigidas}} antes de gravar a página:",
	'spam-blacklist-desc' => 'Ferramenta anti-"spam" baseada em Regex: [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'spam-blacklist' => '# URLs externas que coincidam com esta lista serão bloqueadas quando
 # quando alguém tentar adicioná-las em alguma página.
 # Esta lista refere-se apenas a este wiki. Consulte também a lista-negra global.
 # Veja a documentação em https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- mantenha esta linha exatamente assim --> <pre>
#
# A sintaxe é a seguinte:
#  * Tudo o que estiver após um "#" até o final de uma linha será tido como um comentário
#  * Todas as linhas que não estiverem em branco são um fragmento de expressão regular (regex) que abrangem apenas a URL especificada

 #</pre> <!-- mantenha esta linha exatamente assim -->',
	'spam-whitelist' => ' #<!-- mantenha esta linha exatamente assim --> <pre>
# URLs externas que coincidam com esta lista *não* serão bloqueadas mesmo
# se tiverem sido bloqueadas por entradas presentes nas listas negras.
#
# A sintaxe é a seguinte:
#  * Tudo o que estiver após um "#" até o final de uma linha será tido como um comentário
#  * Todas as linhas que não estiverem em branco são um fragmento de expressão regular (regex) que abrangem apenas a URL especificada

 #</pre> <!-- mantenha esta linha exatamente assim -->',
	'spam-invalid-lines' => '{{PLURAL:$1|A entrada|As entradas}} a seguir {{PLURAL:$1|é uma expressão regular|são expressões regulares}}  (regex) {{PLURAL:$1|inválida e precisa|inválidas e precisam}} ser {{PLURAL:$1|corrigida|corrigidas}} antes de salvar a página:',
	'spam-blacklist-desc' => 'Ferramenta anti-"spam" baseada em Regex: [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'spam-blacklist' => " # Le URL esterne ca se iacchiane jndr'à st'elenghe avènene bloccate quanne avènene aggiunde jndr'à 'na pàgene.
  # St'elenghe tène effette sulamende sus a sta Uicchi; se pò refèrì pure a 'a lista gnore globale.
  # Pe documendazione vide https://www.mediawiki.org/wiki/Extension:SpamBlacklist
  #<!-- leave this line exactly as it is --> <pre>
#
# 'A sindasse jè a cumme segue:
#  * Ognecose ca tène 'u carattere \"#\" 'mbonde a fine d'a linèe jè 'nu commende
#  * Ogne linèe ca non g'è vacande jè 'nu frammende de regex ca vè face le combronde cu le host jndr'à l'URL

  #</pre> <!-- leave this line exactly as it is -->",
	'spam-whitelist' => "  #<!-- leave this line exactly as it is --> <pre>
 # Le URL esterne ca se iacchiane jndr'à st'elenghe *non* g'avènene bloccate pure ca lore sonde mise 
 # jndr'à l'elenghe d'a lista gnore.
 #

#
# 'A sindasse jè a cumme segue:
#  * Ognecose ca tène 'u carattere \"#\" 'mbonde a fine d'a linèe jè 'nu commende
#  * Ogne linèe ca non g'è vacande jè 'nu frammende de regex ca vè face le combronde cu le host jndr'à l'URL

  #</pre> <!-- leave this line exactly as it is -->",
	'spam-invalid-lines' => "{{PLURAL:$1|'A seguende linèe d'a blacklist de spam jè|Le seguende linèe d'a blacklist de spam sonde}} {{PLURAL:$1|espressione|espressiune}} regolare invalide e {{PLURAL:$1|abbesogne|abbesognane}} de avenè corrette apprime de reggistrà 'a pàgene:",
	'spam-blacklist-desc' => "'U strumende andi-spam basate sus a le regex: [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]",
);

/** Russian (Русский)
 * @author Ahonc
 * @author HalanTul
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'spam-blacklist' => ' # Внешние ссылки, соответствующие этому списку, будут запрещены для внесения на страницы.
 # Этот список действует только для данной вики, существует также общий чёрный список.
 # Подробнее на странице https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- не изменяйте эту строку --> <pre>
#
# Синтаксис:
#   * Всё, начиная с символа "#" и до конца строки, считается комментарием
#   * Каждая непустая строка является фрагментом регулярного выражения, применяемого только к узлу в URL

 #</pre> <!-- не изменяйте эту строку -->',
	'spam-whitelist' => ' #<!-- не изменяйте эту строку --> <pre>
# Внешние ссылки, соответствующие этому списку, *не* будут блокироваться, даже если они попали в чёрный список.
#
# Синтаксис:
#   * Всё, начиная с символа "#" и до конца строки, считается комментарием
#   * Каждая непуская строка является фрагментом регулярного выражения, применяемого только к узлу в URL

 #</pre> <!-- не изменяйте эту строку -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Следующая строка чёрного списка ссылок содержит ошибочное регулярное выражение и должна быть исправлена|Следующие строки чёрного списка ссылок содержат ошибочные регулярные выражения и должны быть исправлены}} перед сохранением:',
	'spam-blacklist-desc' => 'Основанный на регулярных выражениях анти-спам инструмент: [[MediaWiki:Spam-blacklist]] и [[MediaWiki:Spam-whitelist]]',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'spam-blacklist' => ' # Екстерны URL одповідаючі тому списку будуть заблокованы при пробі придати їх на сторінку.
 # Тот список овпливнює лем тоту вікі; посмотьте ся тыж на ґлоналну чорну листину.
 # Документацію найдете на https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Охабте тот рядок точно як є --> <pre>
#
# Сінтаксіс є наступный:
#  * Вшытко од знаку „#“ до кінце рядку є коментарь
#  * Каждый непорожній рядок є часть реґуларного выразу, котрому будуть одповідати лем домены з URL

 #</pre> <!-- Охабте тот рядок точно як є -->',
	'spam-whitelist' => ' #<!-- Охабте тот рядок точно як є --> <pre>
# Екстерны URL одповідаючі выразам у тім списку *не будуть* заблокованы, ані кобы
# їх заблоковали положкы з чорной листины.
#
# Сінтаксіс є наступна:
#  * Вшытко од знаку „#“ до кінце рядку є коментарь
#  * каждый непорожній рядок є часть реґуларного выразу, котрому будурь одповідати лем домены з URL

 #</pre> <!-- Охабте тот рядок точно як є -->',
	'spam-invalid-lines' => 'На чорній листинї спаму {{PLURAL:$1|є наступный рядок неправилный реґуларный выраз|суть наступны рядкы неправилны реґуларны выразы|суть наступны рядкы неправилны реґуларны выразы}} і є треба {{PLURAL:$1|го|їх|їх}} перед уложінём сторінкы справити:',
	'spam-blacklist-desc' => 'Антіспамовый інштрумент на базї реґуларных выразів: [[MediaWiki:Spam-blacklist]] і [[MediaWiki:Spam-whitelist]]',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'spam-blacklist' => " # Бу испииһэккэ баар тас сигэлэр бобуллуохтара.
 # Бу испииһэк бу эрэ бырайыакка үлэлиир, уопсай ''хара испииһэк'' эмиэ баарын умнума.
 # Сиһилии манна көр https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- бу строканы уларытыма --> <pre>
#
# Синтаксис:
#  * Бу \"#\" бэлиэттэн саҕалаан строка бүтүөр дылы барыта хос быһаарыыннан ааҕыллар
#  * Каждая непустая строка является фрагментом регулярного выражения, применяемого только к узлу в URL

 #</pre> <!-- бу строканы уларытыма -->",
	'spam-whitelist' => ' #<!-- бу строканы уларытыма --> <pre>
# Манна киирбит тас сигэлэр хара испииһэккэ киирбит да буоллахтарына син биир *бобуллуохтара суоҕа*.
#
# Синтаксис:
#  * Бу "#" бэлиэттэн саҕалаан строка бүтүөр дылы барыта хос быһаарыыннан ааҕыллар
#  * Каждая непустая строка является фрагментом регулярного выражения, применяемого только к узлу в URL

 #</pre> <!-- бу строканы уларытыма -->',
	'spam-invalid-lines' => 'Хара испииһэк манна көрдөрүллүбүт {{PLURAL:$1|строкаата сыыһалаах|строкаалара сыыһалаахтар}}, уларытыах иннинэ ол көннөрүллүөхтээх:',
	'spam-blacklist-desc' => 'Анти-спам үстүрүмүөнэ: [[MediaWiki:Spam-blacklist]] уонна [[MediaWiki:Spam-whitelist]]',
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'spam-blacklist' => ' # Li URL fora dû sito ca currispùnnunu a la lista di sècutu vènunu bluccati.
 # La lista vali sulu pi stu situ; fari rifirimentu macari a la blacklist glubbali.
 # Pâ ducumentazzioni talìa https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- nun mudificari pi nenti chista riga --> <pre>
# La sintassi è  chista:
#  * Tuttu chiddu ca veni doppu nu caràttiri "#" è nu cummentu, nzinu ca finisci la riga
#  * Tutti li righi non vacanti sunnu frammenti di sprissioni riulari ca s\'àpplicanu sulu ô nomu di l\'host nti li URL
 #</pre> <!-- non mudificari nenti di sta riga -->',
	'spam-whitelist' => ' #<!-- non mudificari nta nudda manera sta riga --> <pre>
# Li URL fora ô situ ca currispùnninu a la lista ccà di sècutu *non* vèninu
# bluccati, macari ntô casu avìssiru a currispùnniri a arcuni vuci di la blacklist
#
# La sintassi è chista:
#  * Tuttu chiddu ca veni doppu un caràttiri "#" è nu cummentu, nzinu a la fini dâ riga
#  * Tutti li righi non vacanti sunnu frammenti di sprissioni riulari ca s\'applìcanu sulu  ô nomu di l\'host ntê URL

 #</pre> <!-- non mudificari nta nudda manera sta riga -->',
	'spam-invalid-lines' => '{{PLURAL:$1|La riga di sècutu|Li righi di sècutu}} di la blacklist dô spam {{PLURAL:$1|nun è na sprissioni riulari boni|nun sunnu sprissioni riulari boni}}; currèggiri {{PLURAL:$1|lu sbagghiu|li sbagghi}} prima di sarvari la pàggina.',
	'spam-blacklist-desc' => 'Strumentu antispam basatu supra li sprissioni riulari [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Sinhala (සිංහල)
 * @author Budhajeewa
 */
$messages['si'] = array(
	'spam-blacklist' => ' # External URLs matching this list will be blocked when added to a page.
 # This list affects only this wiki; refer also to the global blacklist.
 # For documentation see https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside URLs

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# External URLs matching this list will *not* be blocked even if they would
# have been blocked by blacklist entries.
#
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside URLs

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-invalid-lines' => 'පහත දැක්වෙන කළු ලයිස්තු {{PLURAL:$1|පේලිය|පේලි}} වැරදි regular {{PLURAL:$1|expression|expressions}} වන අතර, පිටුව සුරැකීමට පෙර නිවැරදි කළ යුතුය:',
	'spam-blacklist-desc' => 'Regex-පාදක ප්‍රති-ස්පෑම ආවුදය: [[MediaWiki:Spam-blacklist]] සහ [[MediaWiki:Spam-whitelist]]',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'spam-blacklist' => '# Externé URLs zodpovedajúce tomuto zoznamu budú zablokované pri pokuse pridať ich na stránku.
# Tento zoznam ovplyvňuje iba túto wiki; pozrite sa tiež na globálnu čiernu listinu.
 # Dokumentáciu nájdete na  https://www.mediawiki.org/wiki/Extension:SpamBlacklist
#<!-- nechajte tento riadok presne ako je --> <pre>
#
# Syntax je nasledovná:
#  * Všetko od znaku „#“ do konca riadka je komentár
#  * Každý neprázdny riadok je časť regulárneho výrazu, ktorému budú zodpovedať iba domény z URL

#</pre> <!-- nechajte tento riadok presne ako je -->',
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre> 
# Externé URL zodpovedajúce výrazom v tomto zozname *nebudú* zablokované, ani keby
# ich zablokovali položky z čiernej listiny.
#
# Syntax je nasledovná:
#   * Všetko od znaku "#" do konca riadka je komentár
#   * Každý neprázdny riadok je regulárny výraz, podľa ktorého sa budú kontrolovať názvy domén

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Nasledovný riadok|Nasledovné riadky}} čiernej listiny spamu {{PLURAL:$1|je neplatný regulárny výraz|sú neplatné regulárne výrazy}} a je potrebné {{PLURAL:$1|ho|ich}} opraviť pred uložením stránky:',
	'spam-blacklist-desc' => 'Antispamový nástroj na základe regulárnych výrazov: [[MediaWiki:Spam-blacklist|Čierna listina]] a [[MediaWiki:Spam-whitelist|Biela listina]]',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'spam-blacklist' => ' # Zunanji URL-ji, ki se ujemajo s tem seznamom, bodo blokirani, ko bodo dodani na stran.
 # Seznam vpliva samo na ta wiki; oglejte si tudi globalni črni seznam.
 # Za dokumentacijo si oglejte https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- pustite to vrstico takšno, kot je --> <pre>
#
# Skladnja je sledeča:
#   * Vse od znaka »#« do konca vrstice je pripomba
#   * Vsaka neprazna vrstica je delec regularnega izraza, ki se bo ujemal samo z gostitelji v URL-jih

 #</pre> <!-- pustite to vrstico takšno, kot je -->',
	'spam-whitelist' => ' #<!-- pustite to vrstico takšno, kot je --> <pre>
# Zunanji URL-ji, ki se ujemajo s tem seznamom, *ne* bodo blokirani,
# četudi bi bili blokirani z vnosi črnega seznama.
#
# Skladnja je sledeča:
#   * Vse od znaka »#« do konca vrstice je pripomba
#   * Vsaka neprazna vrstica je delec regularnega izraza, ki se bo ujemal samo z gostitelji v URL-jih

 #</pre> <!-- pustite to vrstico takšno, kot je -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Naslednja vrstica|Naslednji vrstici|Naslednje vrstice}} črnega seznama smetja {{PLURAL:$1|je neveljavni regularni izraz in ga|sta neveljavna regularna izraza in ju|so neveljavni regularni izrazi in jih}} je pred shranjevanjem strani potrebno popraviti:',
	'spam-blacklist-desc' => 'Orodje proti smetju, temelječe na regularnih izrazih: [[MediaWiki:Spam-blacklist]] in [[MediaWiki:Spam-whitelist]]',
);

/** Albanian (Shqip)
 * @author Olsi
 */
$messages['sq'] = array(
	'spam-blacklist' => ' # URL-të e jashtme që përputhen me këtë listë do të bllokohen kur shtohen tek një faqe.
 # Kjo listë ndikon vetëm në këtë wiki; referojuni gjithashtu listës së zezë globale.
 # Për dokumentacionin shiko https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Sintaksa është si më poshtë:
#  * Çdo gjë nga një karakter "#" në fund të rreshtit është një koment
#  * Çdo rresht jobosh është një fragment që do të përputhë vetëm hostet brenda URL-ve

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# URL-të e jashtme që përputhen më këtë listë *nuk* nuk do të bllokohen edhe nëse ato do të
# kishin qenë të bllokuara nga shënimet e listës së zezë.
#
# Sintaksa është si më poshtë:
#   * Çdo gjë nga një karakter "#" në fund të rreshtit është një koment
#   * Çdo rresht jobosh është një fragment që vetëm do të përputhë hostet brenda URL-ve

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-invalid-lines' => 'Lista e zezë e mëposhtme spam {{PLURAL:$1|rreshti është një|rreshtat janë}} {{PLURAL:$1|shprehje|shprehje}} të rregullta të pavlefshme dhe {{PLURAL:$1|nevojitet|nevojitet}} të korrigjohen përpara ruajtjes së faqes:',
	'spam-blacklist-desc' => 'Mjeti anti-spam regex i bazuar: [[MediaWiki:Spam-blacklist]] dhe [[MediaWiki:Spam-whitelist]]',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'spam-blacklist-desc' => 'Антиспам оруђе засновано на регуларним изразима: [[MediaWiki:Spam-blacklist]] и [[MediaWiki:Spam-whitelist]]',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'spam-blacklist-desc' => 'Antispam oruđe zasnovano na regularnim izrazima: [[MediaWiki:Spam-blacklist]] i [[MediaWiki:Spam-whitelist]]',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'spam-blacklist' => ' # Externe URLs, do der in disse Lieste äntheelden sunt, blokkierje dät Spiekerjen fon ju Siede.
 # Disse Lieste beträft bloot dit Wiki; sjuch uk ju globoale Blacklist.
 # Tou ju Dokumenation sjuch https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- Disse Riege duur nit ferannerd wäide! --> <pre>
#
# Syntax:
#   * Alles fon dät "#"-Teeken ou bit tou Eende fon ju Riege is n Kommentoar
#   * Älke nit-loose Riege is n regulären Uutdruk, ju der juun do Host-Noomen in do URLs wröiged wäd.

 #</pre> <!-- Disse Riege duur nit ferannerd wäide! -->',
	'spam-whitelist' => ' #<!-- Disse Riege duur nit ferannerd wäide! --> <pre>
# Externe URLs, do der in disse Lieste äntheelden sunt, blokkierje dät Spiekerjen fon ju Siede nit,
# uk wan jo in ju globoale of lokoale swotte Lieste äntheelden sunt.
#
# Syntax:
#  * Alles fon dät "#"-Teeken ou bit tou Eende fon ju Riege is n Kommentoar
#  * Älke nit-loose Riege is n regulären Uutdruk, die der juun do Host-Noomen in do URLs wröided wäd.

 #</pre> <!-- Disse Riege duur nit ferannerd wäide! -->',
	'spam-invalid-lines' => '{{PLURAL:$1
	| Ju foulgjende Siede in ju Spam-Blacklist is n uungultigen regulären Uutdruk. Ju mout foar dät Spiekerjen fon ju Siede korrigierd wäide
	| Do foulgjende Sieden in ju Spam-Blacklist sunt uungultige reguläre Uutdrukke. Do mouten foar dät Spiekerjen fon ju Siede korrigierd wäide}}:',
	'spam-blacklist-desc' => 'Regex-basierde Anti-Spam-Reewe: [[MediaWiki:Spam-blacklist]] un [[MediaWiki:Spam-whitelist]]',
);

/** Swedish (Svenska)
 * @author Lejonel
 */
$messages['sv'] = array(
	'spam-blacklist' => '
 # Den här listan stoppar matchande externa URL:er från att läggas till på sidor.
 # Listan påverkar bara den här wikin; se även den globala svarta listan för spam.
 # För dokumentation se https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- ändra inte den här raden --> <pre>
#
# Syntaxen är följande:
#   * All text från ett #-tecken till radens slut är en kommentar
#   * Alla icke-tomma rader används som reguljära uttryck för att matcha domännamn i URL:er

 #</pre> <!-- ändra inte den här raden -->',
	'spam-whitelist' => '
 #<!-- ändra inte den här raden --> <pre>
# Externa URL:er som matchar den här listan blockeras *inte*,
# inte ens om de är blockerade genom den svarta listan för spam.
#
# Syntaxen är följande:
#   * All text från ett #-tecken till radens slut är en kommentar
#   * Alla icke-tomma rader används som reguljära uttryck för att matcha domännamn i URL:er

 #</pre> <!-- ändra inte den här raden -->',
	'spam-invalid-lines' => 'Följande {{PLURAL:$1|rad|rader}} i svarta listan för spam innehåller inte något giltigt reguljärt uttryck  och måste rättas innan sidan sparas:',
	'spam-blacklist-desc' => 'Antispamverktyg baserat på reguljära uttryck: [[MediaWiki:Spam-blacklist]] och [[MediaWiki:Spam-whitelist]]',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'spam-blacklist' => '
 # ఓ పేజీకి చేర్చిన బయటి లింకులు గనక ఈ జాబితాతో సరిపోలితే వాటిని నిరోధిస్తాం.
 # ఈ జాబితా ఈ వికీకి మాత్రమే సంబంధించినది; మహా నిరోధపు జాబితాని కూడా చూడండి.
 # పత్రావళి కొరకు ఇక్కడ చూడండి: https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Syntax is as follows:
#  * "#" అన్న అక్షరం నుండి లైను చివరివరకూ ఉన్నదంతా వ్యాఖ్య
#  * ఖాళీగా లేని ప్రతీలైనూ URLలలోని హోస్ట్ పేరుని మాత్రమే సరిపోల్చే ఒక regex తునక

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => '
 #<!-- leave this line exactly as it is --> <pre>
# ఈ జాబితాకి సరిపోలిన బయటి లింకులని *నిరోధించము*,
# అవి నిరోధపు జాబితాలోని పద్దులతో సరిపోలినా గానీ.
#
# ఛందస్సు ఇదీ:
#  * "#" అక్షరం నుండి లైను చివరివరకూ ప్రతీదీ ఓ వ్యాఖ్యే
#  * ఖాళీగా లేని ప్రతీ లైనూ URLలలో హోస్ట్ పేరుని సరిపోల్చే regex తునక

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-invalid-lines' => 'స్పామ్ నిరోధపు జాబితాలోని క్రింద పేర్కొన్న {{PLURAL:$1|లైను|లైన్లు}} తప్పుగా {{PLURAL:$1|ఉంది|ఉన్నాయి}}, పేజీని భద్రపరిచేముందు {{PLURAL:$1|దాన్ని|వాటిని}} సరిదిద్దండి:',
	'spam-blacklist-desc' => 'Regex-ఆధారిత స్పామ్ నిరోధక పనిముట్టు: [[MediaWiki:Spam-blacklist]] మరియు [[MediaWiki:Spam-whitelist]]',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'spam-blacklist' => ' # Нишониҳои URL берунаи ба ин феҳрист мутобиқатшуда вақте, ки ба саҳифае илова мешаванд, 
 # баста хоҳанд шуд.
 # Ин феҳрист фақат рӯи ҳамин вики таъсир мекунад; ба феҳристи сиёҳи саросар низ муроҷиат кунед.
 # Барои мустанадот, нигаред ба https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!--  ин сатрро ҳамонгуна, ки ҳаст раҳо кунед --> <pre>
#
 # Дастурот ба ин шакл ҳастанд:
 #  * Ҳама чиз аз аломати "#" то поёни сатр ба унвони тавзеҳ ба назар гирифта мешавад
 #  * Ҳар сатр аз матн ба унвони як дастур regex ба назар гирифта мешавад, 
 #  ки фақат бо номи мизбон дар нишонии интернетии URL мутобиқат дода мешавад

 #</pre> <!-- ин сатрро ҳамонгуна, ки ҳаст раҳо кунед -->',
	'spam-whitelist' => ' #<!-- ин сатрро ҳамонгуна, ки ҳаст раҳо кунед --> <pre>
# Нишониҳои URL берунаи ба ин феҳрист мутобиқатбуда, баста нахоҳанд шуд, 
# ҳатто агар дар феҳристи сиёҳ қарор дошта бошад.
#
# Дастурот ба ин шакл ҳастанд:
#  * Ҳама чиз аз аломати "#" то поёни сатр ба унвони тавзеҳ ба назар гирифта мешавад
#  * Ҳар сатр аз матн ба унвони як дастур regex ба назар гирифта мешавад, ки фақат бо номи мизбон дар 
# нишонии интернетии URL мутобиқат дода мешавад
 #</pre> <!-- ин сатрро ҳамонгуна, ки ҳаст раҳо кунед -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Сатри|Сатрҳои}} зерин дар феҳристи сиёҳи ҳарзнигорӣ дастуроти ғайри миҷозе regular expressions  {{PLURAL:$1|аст|ҳастанд}} ва қабл аз захира кардани саҳифа ба ислоҳ кардан ниёз {{PLURAL:$1|дорад|доранд}}:',
	'spam-blacklist-desc' => 'Абзори зидди ҳарзнигорӣ дар асоси Regex: [[MediaWiki:Spam-blacklist]] ва [[MediaWiki:Spam-whitelist]]',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'spam-blacklist' => ' # Nişonihoi URL berunai ba in fehrist mutobiqatşuda vaqte, ki ba sahifae ilova meşavand, 
 # basta xohand şud.
 # In fehrist faqat rūi hamin viki ta\'sir mekunad; ba fehristi sijohi sarosar niz muroçiat kuned.
 # Baroi mustanadot, nigared ba https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!--  in satrro hamonguna, ki hast raho kuned --> <pre>
#
 # Dasturot ba in şakl hastand:
 #  * Hama ciz az alomati "#" to pojoni satr ba unvoni tavzeh ba nazar girifta meşavad
 #  * Har satr az matn ba unvoni jak dastur regex ba nazar girifta meşavad, 
 #  ki faqat bo nomi mizbon dar nişoniji internetiji URL mutobiqat doda meşavad

 #</pre> <!-- in satrro hamonguna, ki hast raho kuned -->',
	'spam-whitelist' => ' #<!-- in satrro hamonguna, ki hast raho kuned --> <pre>
# Nişonihoi URL berunai ba in fehrist mutobiqatbuda, basta naxohand şud, 
# hatto agar dar fehristi sijoh qaror doşta boşad.
#
# Dasturot ba in şakl hastand:
#  * Hama ciz az alomati "#" to pojoni satr ba unvoni tavzeh ba nazar girifta meşavad
#  * Har satr az matn ba unvoni jak dastur regex ba nazar girifta meşavad, ki faqat bo nomi mizbon dar 
# nişoniji internetiji URL mutobiqat doda meşavad
 #</pre> <!-- in satrro hamonguna, ki hast raho kuned -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Satri|Satrhoi}} zerin dar fehristi sijohi harznigorī dasturoti ƣajri miçoze regular expressions  {{PLURAL:$1|ast|hastand}} va qabl az zaxira kardani sahifa ba isloh kardan nijoz {{PLURAL:$1|dorad|dorand}}:',
	'spam-blacklist-desc' => 'Abzori ziddi harznigorī dar asosi Regex: [[MediaWiki:Spam-blacklist]] va [[MediaWiki:Spam-whitelist]]',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'spam-invalid-lines' => 'Aşakdaky spam gara sanawynyň {{PLURAL:$1|setiri|setiri}} nädogry regulýar {{PLURAL:$1|aňlatmadyr|aňlatmadyr}} we sahypa ýazdyrylmanka düzedilmelidir:',
	'spam-blacklist-desc' => 'Regulýar aňlatmalar esasynda anti-spam guraly: [[MediaWiki:Spam-blacklist]] we [[MediaWiki:Spam-whitelist]]',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'spam-blacklist' => " # Ang panlabas na mga URL na tumutugma sa talaang ito ay hahadlangan/haharangin kapag idinagdag sa isang pahina.
 # Nakakaapekto lamang ang talaang ito sa wiking ito; sumangguni rin sa pandaigdigang talaan ng pinagbabawalan.
 # Para sa kasulatan tingnan ang https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Ang palaugnayan ay ayon sa mga sumusunod:
#  * Lahat ng bagay mula sa isang \"#\" na panitik hanggang sa wakas ng isang guhit/hanay ay isang puna (kumento)
#  * Bawat hindi/walang patlang na guhit/hanay ay isang piraso ng karaniwang pagsasaad (''regex'') na tutugma lamang sa mga tagapagpasinaya sa loob ng mga URL

 #</pre> <!-- leave this line exactly as it is -->",
	'spam-whitelist' => " #<!-- leave this line exactly as it is --> <pre>
# Ang panlabas na mga URL na tumutugma sa talaang ito ay *hindi* hahadlangan kahit na sila ay
# hinarang ng mga ipinasok (entrada) sa talaan ng pinagbabawalan.
#
# Ang palaugnayan ay ayon sa mga sumusunod:
#  * Lahat ng bagay mula sa isang \"#\" na panitik hanggang sa wakas ng isang guhit/hanay ay isang puna (kumento)
#  * Bawat hindi/walang patlang na guhit/hanay ay isang piraso ng karaniwang pagsasaad (''regex'') na tutugma lamang sa mga tagapagpasinaya sa loob ng mga URL

 #</pre> <!-- leave this line exactly as it is -->",
	'spam-invalid-lines' => 'Ang sumusunod na {{PLURAL:$1|isang hanay/guhit|mga hanay/guhit}} ng talaan ng pinagbabawalang "manlulusob" (\'\'spam\'\') ay hindi tanggap na karaniwang {{PLURAL:$1|pagsasaad|mga pagsasaad}} at {{PLURAL:$1|kinakailangang|kinakailangang}} maitama muna bago sagipin ang pahina:',
	'spam-blacklist-desc' => "Kasangkapang panlaban sa \"manlulusob\" (''spam'') na nakabatay sa karaniwang pagsasaad (''regex''): [[MediaWiki:Spam-blacklist]] at [[MediaWiki:Spam-whitelist]]",
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'spam-blacklist' => ' # Bu listeyle eşleşen dış bağlantılar, bir sayfaya eklendiğinde engellenecektir. 
 # Bu liste sadece bu vikiyi etkiler; ayrıca küresel karalisteye de bakın.
 # Dokümantasyon için https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- bu satırı olduğu gibi bırakın --> <pre>
#
# Sözdizimi aşağıdaki gibidir:
#  * "#" karakterinden satır sonuna kadar her şey bir yorumdur
#  * Her boş olmayan satır, sadece URLlerin içindeki sunucularla eşleşen regex parçasıdır

 #</pre> <!-- bu satırı olduğu gibi bırakın -->',
	'spam-whitelist' => ' #<!-- bu satırı olduğu gibi bırakın --> <pre>
# Bu listeyle eşlenen dış bağlantılar *engellenmeyecektir*,
# karaliste girdileriyle engellenmiş olsalar bile.
#
# Sözdizimi aşağıdaki gibidir:
#  * "#" karakterinden satır sonuna kadar her şey bir yorumdur
#  * Her boş olmayan satır, sadece URLlerin içindeki sunucularla eşleşen regex parçasıdır

 #</pre> <!--bu satırı olduğu gibi bırakın -->',
	'spam-invalid-lines' => 'Şu spam karaliste {{PLURAL:$1|satırı|satırları}} geçersiz düzenli {{PLURAL:$1|tanımdır|tanımlardır}} ve sayfayı kaydetmeden düzeltilmesi gerekmektedir:',
	'spam-blacklist-desc' => 'Regex-tabanlı anti-spam aracı: [[MediaWiki:Spam-blacklist]] ve [[MediaWiki:Spam-whitelist]]',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'spam-blacklist' => '# Зовнішні посилання, що відповідають цьому списку, будуть заборонені для внесення на стоірнки.
 # Цей список діє лише для цієї вікі, існує також загальний чорний список.
 # Докладніше на сторінці https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- не змінюйте цей рядок --> <pre>
#
# Синтаксис:
#  * Все, починаючи із символу "#" і до кінця рядка, вважається коментарем
#  * Кожен непорожній рядок є фрагментом регулярного виразу, який застосовується тільки до вузла в URL

 #</pre> <!-- не змінюйте цей рядок -->',
	'spam-whitelist' => ' #<!-- не змінюйте це рядок --> <pre>
# Зовнішні посилання, що відповідають цьому списку, *не* будуть блокуватися, навіть якщо вони потрапили до чорного списку.
#
# Синтаксис:
#  * Усе, починаючи з символу "#" і до кінця рядка, вважається коментарем
#  * Кожен непорожній рядок є фрагментом регулярного виразу, який застосовується тільки до вузла в URL

 #</pre> <!-- не изменяйте эту строку -->',
	'spam-invalid-lines' => '{{PLURAL:$1|Наступний рядок із чорного списку посилань містить помилковий регулярний вираз і його треба виправити|Наступні рядки із чорного списку посилань містять помилкові регулярні вирази і їх треба виправити}} перед збереженням:',
	'spam-blacklist-desc' => 'Протиспамовий засіб, що базується на регулярних виразах: [[MediaWiki:Spam-blacklist]] та [[MediaWiki:Spam-whitelist]]',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'spam-blacklist' => ' # Le URL esterne al sito che corisponde a la lista seguente le vegnarà blocà.
 # La lista la xe valida solo par sto sito qua; far riferimento anca a la blacklist globale.
 # Par la documentazion vardar https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- no sta modificar in alcun modo sta riga --> <pre>
# La sintassi la xe la seguente:
#  * Tuto quel che segue un caràtere "#" el xe un comento, fin a la fine de la riga
#  * Tute le righe mìa vode le xe framenti de espressioni regolari che se àplica al solo nome de l\'host ne le URL
 #</pre> <!-- no sta modificar in alcun modo sta riga -->',
	'spam-whitelist' => ' #<!-- no sta modificar in alcun modo sta riga --> <pre>
# Le URL esterne al sito che corisponde a la lista seguente *no* le vegnarà
# mìa blocà, anca nel caso che le corisponda a de le voçi de la lista nera
#
# La sintassi la xe la seguente:
#  * Tuto quel che segue un caràtere "#" el xe un comento, fin a la fine de la riga
#  * Tute le righe mìa vode le xe framenti de espressioni regolari che se àplica al solo nome de l\'host ne le URL

 #</pre> <!-- no sta modificar in alcun modo sta riga -->',
	'spam-invalid-lines' => "{{PLURAL:$1|La seguente riga|Le seguenti righe}} de la lista nera del spam {{PLURAL:$1|no la xe na espression regolare valida|no le xe espressioni regolari valide}}; se prega de corègiar {{PLURAL:$1|l'eror|i erori}} prima de salvar la pagina.",
	'spam-blacklist-desc' => 'Strumento antispam basà su le espressioni regolari [[MediaWiki:Spam-blacklist]] e [[MediaWiki:Spam-whitelist]]',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'spam-blacklist' => ' # Các địa chỉ URL ngoài trùng với một khoản trong danh sách này bị cấm không được thêm vào trang nào.
 # Danh sách này chỉ có hiệu lực ở wiki này; hãy xem thêm “danh sách đen toàn cầu”.
 # Có tài liệu hướng dẫn tại https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Cú pháp:
#  * Các lời ghi chú bắt đầu với ký tự “#” và tiếp tục cho đến cuối dòng.
#  * Các dòng không để trống là một mảnh biểu thức chính quy, nó chỉ trùng với tên máy chủ trong địa chỉ URL.

 #</pre> <!-- leave this line exactly as it is -->',
	'spam-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# Các địa chỉ URL ngoài trùng với một khoản trong danh sách này *không* bị cấm, dù có nó trong danh sách đen.
#
# Cú pháp:
#  * Các lời ghi chú bắt đầu với ký tự “#” và tiếp tục cho đến cuối dòng.
#  * Các dòng không để trống là một mảnh biểu thức chính quy, nó chỉ trùng với tên máy chủ trong địa chỉ URL.

 #</pre> <!-- leave this line exactly as it is -->',
	'email-blacklist' => ' # Các địa chỉ thư điện tử trùng với danh sách này bị cấm không được đăng ký hoặc gửi thư điện tử.
 # Danh sách này chỉ có hiệu lực ở wiki này; hãy xem thêm “danh sách đen toàn cầu”.
 # Có tài liệu hướng dẫn tại https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- leave this line exactly as it is --> <pre>
#
# Cú pháp:
#   * Các lời ghi chú bắt đầu với ký tự “#” và tiếp tục cho đến cuối dòng.
#   * Các dòng không để trống là một mảnh biểu thức chính quy, nó chỉ trùng với tên máy chủ trong địa chỉ thư điện tử.

 #</pre> <!-- leave this line exactly as it is -->',
	'email-whitelist' => ' #<!-- leave this line exactly as it is --> <pre>
# Các địa chỉ thư điện tử trùng với danh sách này *không* bị cấm, dù có nó trong danh sách đen.
#
 #</pre> <!-- leave this line exactly as it is -->
# Cú pháp:
#   * Các lời ghi chú bắt đầu với ký tự “#” và tiếp tục cho đến cuối dòng.
#   * Các dòng không để trống là một mảnh biểu thức chính quy, nó chỉ trùng với tên máy chủ trong địa chỉ thư điện tử.',
	'spam-blacklisted-email' => 'Địa chỉ thư điện tử bị đưa vào danh sách đen',
	'spam-blacklisted-email-text' => 'Địa chỉ thư điện tử của bạn đã được đưa vào danh sách đen nên bị cấm không được gửi thư điện tử cho người dùng khác.',
	'spam-blacklisted-email-signup' => 'Địa chỉ thư điện tử được cung cấp đã được đưa vào danh sách đen nên bị cấm không được sử dụng.',
	'spam-invalid-lines' => '{{PLURAL:$1|Dòng|Những dòng}} sau đây trong danh sách đen về spam không hợp lệ; xin hãy sửa chữa {{PLURAL:$1|nó|chúng}} để tuân theo cú pháp biểu thức chính quy trước khi lưu trang:',
	'spam-blacklist-desc' => 'Công cụ dùng biểu thức chính quy để chống spam: [[MediaWiki:Spam-blacklist]] và [[MediaWiki:Spam-whitelist]]',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'spam-blacklist' => ' # 同呢個表合符嘅外部 URL 當加入嗰陣會被封鎖。
 # 呢個表只係會影響到呢個wiki；請同時參閱全域黑名單。
 # 要睇註解請睇 https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- 請完全噉留番呢行 --> <pre>
#
# 語法好似下面噉:
#   * 每一個由 "#" 字元開頭嘅行，到最尾係一個註解
#   * 每個非空白行係一個標準表示式碎片，只係會同入面嘅URL端核對

 #</pre> <!-- 請完全噉留番呢行 -->',
	'spam-whitelist' => ' #<!-- 請完全噉留番呢行 --> <pre>
# 同呢個表合符嘅外部 URL ，即使響黑名單項目度封鎖，
# 都*唔會*被封鎖。
#
# 語法好似下面噉:
#   * 每一個由 "#" 字元開頭嘅行，到最尾係一個註解
#   * 每個非空白行係一個標準表示式碎片，只係會同入面嘅URL端核對

 #</pre> <!-- 請完全噉留番呢行 -->',
	'spam-invalid-lines' => '下面響灌水黑名單嘅{{PLURAL:$1|一行|多行}}有無效嘅表示式，請響保存呢版之前先將{{PLURAL:$1|佢|佢哋}}修正:',
	'spam-blacklist-desc' => '以正規表達式為本嘅防灌水工具: [[MediaWiki:Spam-blacklist]] 同 [[MediaWiki:Spam-whitelist]]',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hzy980512
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'spam-blacklist' => ' # 跟这个表合符的外部 URL 当加入时会被封锁。
 # 这个表只是会影响到这个wiki；请同时参阅全域黑名单。
 # 要参看注解请看 https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- 请完全地留下这行 --> <pre>
#
# 语法像下面这样:
#   * 每一个由 "#" 字元开头的行，到结尾是一个注解
#   * 每个非空白行是一个标准表示式碎片，只是跟里面的URL端核对

 #</pre> <!-- 请完全地留下这行 -->',
	'spam-whitelist' => ' #<!-- 请完整地保留此行 --> <pre>
# 与本列表匹配的外部链接，即使已被黑名单的规则禁止
# 也*不会*被封锁。
#
# 语法如下:
#  * 由“#”字符开头的每行均为注释
#  * 非空白的每行则是正则表达式片段，将只与内含该URL的链接相匹配

 #</pre> <!-- 请完整地保留此行 -->',
	'spam-blacklisted-email' => '黑名单中的电邮地址',
	'spam-blacklisted-email-text' => '您的电子邮件地址目前已被列入黑名单以防止您发送邮件。',
	'spam-blacklisted-email-signup' => '所给电邮地址已被列入黑名单。',
	'spam-invalid-lines' => '下列垃圾链接黑名单有{{PLURAL:$1|一行|多行}}含有无效的正则表示式，请在保存该页前修正之：',
	'spam-blacklist-desc' => '基于正则表达式的反垃圾链接工具：[[MediaWiki:Spam-blacklist]]和[[MediaWiki:Spam-whitelist]]',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'spam-blacklist' => ' # 跟這個表符合的外部 URL 當加入時會被封鎖。
 # 這個表只是會影響到這個 wiki；請同時參閱全域黑名單。
 # 要參看註解請看 https://www.mediawiki.org/wiki/Extension:SpamBlacklist
 #<!-- 請完全地留下這行 --> <pre>
#
# 語法像下面這樣:
#   * 每一個由「#」字元開頭的行，到結尾是一個註解
#   * 每個非空白行是一個標準表示式碎片，只是跟裡面的 URL 端核對

 #</pre> <!-- 請完全地留下這行 -->',
	'spam-whitelist' => ' #<!-- 請完全地留下這行 --> <pre>
# 跟這個表符合的外部 URL ，即使在黑名單項目中封鎖，
# 都*不會*被封鎖。
#
# 語法像下面這樣:
#   * 每一個由「#」字元開頭的行，到結尾是一個註解
#   * 每個非空白行是一個標準表示式碎片，只是跟裡面的 URL 端核對

 #</pre> <!-- 請完全地留下這行 -->',
	'spam-invalid-lines' => '以下在灌水黑名單的{{PLURAL:$1|一行|多行}}有無效的表示式，請在儲存這頁前先將{{PLURAL:$1|它|它們}}修正：',
	'spam-blacklist-desc' => '以正則表達式為本的防灌水工具：[[MediaWiki:Spam-blacklist]] 與 [[MediaWiki:Spam-whitelist]]',
);

