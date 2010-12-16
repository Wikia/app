<?php
/**
 * Internationalisation file for extension TitleBlacklist.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'titleblacklist-desc'             => 'Allows administrators to forbid creation of pages and user accounts per a [[MediaWiki:Titleblacklist|blacklist]] and [[MediaWiki:Titlewhitelist|whitelist]]',
	'titleblacklist'                  => "# This is a title blacklist. Titles and users that match a regular expression here cannot be created.
# Use \"#\" for comments.
# This is case insensitive by default",
	'titlewhitelist'                  => "# This is a title whitelist. Use \"#\" for comments. 
# This is case insensitive by default",
	'titleblacklist-forbidden-edit'   => 'The title "$2" has been banned from creation.
It matches the following blacklist entry: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" cannot be moved to "$3", because the title "$3" has been banned from creation.
It matches the following blacklist entry: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'The file name "$2" has been banned from creation.
It matches the following blacklist entry: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'The user name "$2" has been banned from creation.
It matches the following blacklist entry: <code>$1</code>',
	'titleblacklist-invalid'          => 'The following {{PLURAL:$1|line|lines}} in the title blacklist {{PLURAL:$1|is|are}} invalid;
please correct {{PLURAL:$1|it|them}} before saving:',
	'right-tboverride'                => 'Override the title blacklist',
);

/** Message documentation (Message documentation)
 * @author Beau
 * @author Purodha
 */
$messages['qqq'] = array(
	'titleblacklist-desc' => 'Short description of the Titleblacklist extension, shown in [[Special:Version]]. Do not translate or change links.',
	'right-tboverride' => '{{doc-right}}',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'titleblacklist-desc' => "Premite a os almenistradors de bedar a creyazión de pachinas y cuentas d'usuario con aduya d'una [[MediaWiki:Titleblacklist|lista negra]] y una [[MediaWiki:Titlewhitelist|lista blanca]]",
	'titleblacklist' => '# Ista ya una lista negra de títols. Os títols que concuerden con una d\'istas espresions regulars no se pueden creyar.
# Use "#" ta fer comentarios.',
	'titlewhitelist' => '# Ista ya una lista blanca de títols. Use "#" ta fer comentarios.',
	'titleblacklist-forbidden-edit' => 'O títol "$2" ye biedato y no se puede creyar. Concuerda con a siguient dentrada d\'a lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" no se puede tresladar ta "$3", porque o títol "$3" ye biedato y no se puede creyar. Concuerda con a siguient dentrada d\'a lista negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'O nombre de fichero "$2" ye biedato y no se puede creyar. Concuerda con a siguient dentrada d\'a lista negra: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'O nombre d\'usuario "$2" ye bedato y no se puede creyar. 
Concuerda con a dentrada <code>$1</code> d\'a lista negra.',
	'titleblacklist-invalid' => "{{PLURAL:$1|A siguient linia|As siguients linias}} d'a lista negra de títols {{PLURAL:$1|ye|son}} no son conformes; por fabor corricha-{{PLURAL:$1|la|las}} antes d'alzar:",
	'right-tboverride' => 'Inorar a lista negra de títols',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'titleblacklist-desc' => 'يسمح للإداريين بمنع إنشاء الصفحات وحسابات المستخدمين حسب [[MediaWiki:Titleblacklist|قائمة سوداء]] و [[MediaWiki:Titlewhitelist|قائمة بيضاء]]',
	'titleblacklist' => '# هذه قائمة سوداء للعناوين. العناوين والمستخدمون الذين يطابقون تعبيرا منتظما هنا لا يمكن إنشاؤهم.
# استخدم "#" للتعليقات.
# هذه لا تتأثر بحالة الحروف افتراضيا',
	'titlewhitelist' => '# هذه قائمة بيضاء للعناوين. استخدم "#" للتعليقات
# هذه لا تتأثر بحالة الحروف افتراضيا',
	'titleblacklist-forbidden-edit' => 'العنوان "$2" تم منعه من الإنشاء.
هو يطابق المدخلة التالية في القائمة السوداء: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" لا يمكن نقلها إلى "$3"، لأن العنوان "$3" تم منعه من الإنشاء.
هو يطابق المدخلة التالية في القائمة السوداء : <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'اسم الملف "$2" تم منعه من الإنشاء.
هو يطابق المدخلة التالية في القائمة السوداء: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'اسم المستخدم "$2" تم منعه من الإنشاء.
هو يطابق مدخلة القائمة السوداء التالية: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1||السطر التالي|السطران التاليان|السطور التالية}} في قائمة العناوين السوداء {{PLURAL:$1||غير صحيح|غير صحيحان|غير صحيحة}}؛ من فضلك {{PLURAL:$1||صححه|صححهما|صححهم}} قبل الحفظ:',
	'right-tboverride' => 'تجاوز قائمة العناوين السوداء',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'titleblacklist-desc' => 'بيسمح للاداريين انهم يمنعو انشاء الصفحات و حسابات اليوزرز  على حسب [[MediaWiki:Titleblacklist|البلاك ليست]] و [[MediaWiki:Titlewhitelist|اللستة المسموحة]]',
	'titleblacklist' => '# دى بلاك  ليست للعناوين. العناوين واليوزرز اللى بيطابقو نعبير عادى هنا مش ممكن إنشاؤهم.
# استعمل "#" للتعليقات.
# ما بتتأثرش بحاله الحروف',
	'titlewhitelist' => '# دى لستة بالعناوين المسموح بيها. استعمل "#" للتعليقات.
# ما بتتأثرش بحاله الحروف',
	'titleblacklist-forbidden-edit' => 'العنوان "$2" ممنوع من الانشاء.
لانه مطابق لمدخلة فى البلاك ليست دي: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" ماينفعش تتنقل لـ "$3", لان العنوان "$3" ممنوع من الانشاء.
لانه مطابق لمدخلة فى البلاك ليست دي: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'اسم الملف "$2" ممنوع من الانشاء.
لانه مطابق لمدخلة فى البلاك ليست دي: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'اسم اليوزر "$2" ممنوع من الانشاء.
لانه مطابق لمدخلة فى البلاك ليست دي: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|السطر دا|السطور دي}} اللى فى البلاك ليست بتاعة العناوين مش {{PLURAL:$1|صح|صح}} ;
لو سمحت تصلح {{PLURAL:$1|ـه|ـهم}} قبل الحفظ:',
	'right-tboverride' => 'اتجاوز البلاك ليست بتاعةالعناوين',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'titleblacklist-desc' => "Permite a los alministradores prohibir la creación de páxines y cuentes d'usuariu per aciu d'una [[MediaWiki:Titleblacklist|llista prieta]] y una [[MediaWiki:Titlewhitelist|llista blanca]]",
	'titleblacklist' => '# Esta ye una llista prieta de títulos. Los títulos y usuarios que concayen con dalguna de les expresiones regulares d\'equí nun puen ser creaos.
# Usa "#" pa los comentarios.',
	'titlewhitelist' => '# Esta ye una llista blanca de títulos. Usa "#" pa los comentarios.',
	'titleblacklist-forbidden-edit' => 'Torgóse la creación del títulu "$2".
Concueya cola siguiente entrada na llista prieta: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" nun pue ser treslladáu a "$3" porque\'l títulu "$3" ta prohibío crealu.
Concueya cola siguiente entrada na llista prieta: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Torgóse la creación del nome d\'archivu "$2".
Concueya cola siguiente entrada na llista prieta: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Torgóse la creación del nome d\'usuariu "$2".
Concueya cola siguiente entrada na llista prieta: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|La siguiente llinia|Les siguientes llinies}} de la llista prieta de títulos {{PLURAL:$1|nun ye válida|nun son válides}};
por favor {{PLURAL:$1|corríxila|corríxiles}} enantes de guardar:',
	'right-tboverride' => 'Inorar la llista prieta de títulos',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'titleblacklist-desc' => 'اجازت دن بند کتن شرکنگ صفحاتی گون مشخصین عناوین:  [[MediaWiki:Titleblacklist]] و [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# شی یک عنوان لیست سیاهی انت. عناوینی که هم داب رجکس انت ادان شرکنگ نه بیت.
# استفاده کن"#" په نظرات',
	'titlewhitelist' => '#شی یک اسپیت لیستی عنوانیء. استفاده کن چه  "#" په نظر داتن',
	'titleblacklist-forbidden-edit' => 'عنوان "$2" چه شر بیگ منع بوتت.
ایی هم داب جهلگی لیست سیاه یک ورودی انت: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'عنوان "$2" نه تونیت په "$3" جاه په جاه بیت، په چی که ایی چه شر بیگ منع بوتت.
ایی هم داب جهلگی لیست سیاه یک ورودی انت: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'فایل نام  "$2" چه شر بیگ منع بوتت.
ایی هم داب جهلگی لیست سیاه یک ورودی انت: <code>$1</code>',
	'right-tboverride' => 'لیست سیاه عنوان لغو کن',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'titleblacklist-desc' => 'Дазваляе адміністратарам забараняць стварэньне старонак і рахункаў удзельнікаў з дапамогай [[MediaWiki:Titleblacklist|чорнага]] і [[MediaWiki:Titlewhitelist|белага]] сьпісаў',
	'titleblacklist' => '# Гэта сьпіс забароненых назваў. Старонкі і рахункі, назвы якіх адпавядаюць гэтым выразам, ня могуць быць створаныя.
# Выкарыстоўвайце «#» для камэнтараў.
# Рэгістар сымбаляў ня ўлічваецца па змоўчваньні',
	'titlewhitelist' => '# Гэта сьпіс дазволеных назваў. Выкарыстоўвайце «#» для камэнтараў.
# Рэгістар сымбаляў ня ўлічваецца па змоўчваньні',
	'titleblacklist-forbidden-edit' => 'Назва «$2» забароненая для стварэньня.
Яна адпавядае наступнаму элемэнту чорнага сьпісу: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Старонка «$2» ня можа быць перанесеная ў «$3», таму што назва «$3» забароненая для стварэньня.
Яна адпавядае наступнаму элемэнту чорнага сьпісу: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Файл з назвай «$2» забаронены для стварэньня.
Яна адпавядае наступнаму элемэнту чорнага сьпісу: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Імя ўдзельніка «$2» было забаронена для стварэньня.
Яно адпавядае наступнаму элемэнту чорнага сьпісу: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Наступны радок у|Наступныя радкі ў}} сьпісе забароненых назваў — {{PLURAL:$1|няслушны|няслушныя}};
калі ласка, выпраўце {{PLURAL:$1|яго|іх}} перад захаваньнем:',
	'right-tboverride' => 'Ігнараваньне чорнага сьпісу назваў',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'titleblacklist-desc' => 'Позволява на администраторите да забраняват създаването на страници и потребителски сметки чрез [[MediaWiki:Titleblacklist|черен]] и [[MediaWiki:Titlewhitelist|бял списък]].',
	'titleblacklist' => '# Страницата съдържа черен списък за заглавия на страници
# Страници и потребители, чиито имена съответстват с регулярните изрази в списъка, не могат да бъдат създавани.
# За коментари се използва символът „#“.',
	'titlewhitelist' => '# Това е бял списък на заглавията. Използвайте "#" за въвеждане на коментари.
# По подразбиране списъкът е нечувствителен на малки и главни букви',
	'titleblacklist-forbidden-edit' => 'Страницата "$2" не може да бъде създадена, тъй като съвпада със запис от черния списък: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Страницата "$2" не може да бъде преместена като "$3", тъй като съвпада със запис от черния списък: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Файлът "$2" не може да бъде качен, тъй като съвпада със запис от черния списък: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Забранено е създаването на потребителско име „$2“.
То отговаря на следния запис от черния списък: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Следният ред|Следните редове}} от черния списък на заглавията {{PLURAL:$1|е невалиден|са невалидни}} и трябва да {{PLURAL:$1|бъде коригиран|бъдат коригирани}} преди съхранение:',
	'right-tboverride' => 'Презаписване върху черния списък на заглавията',
);

/** Bengali (বাংলা)
 * @author Abdullah Harun Jewel
 * @author Zaheen
 */
$messages['bn'] = array(
	'titleblacklist' => '# এটি শিরোনাম কালোতালিকা। যেসব পাতার শিরোনাম ও ব্যবহারকারীর নাম এখানকার একটি রেগুলার এক্সপ্রেশনের সাথে মিলে যাবে, সেগুলি সৃষ্টি করা যাবে না।
# মন্তব্যের জন্য "#" ব্যবহার করুন।',
	'titlewhitelist' => '# এটি একটি শিরোনাম সাদাতালিকা। মন্তব্যের জন্য "#" ব্যবহার করুন',
	'titleblacklist-forbidden-edit' => '"$2" শিরোনামটি সৃষ্টি করা নিষিদ্ধ করা হয়েছে। এটি কালোতালিকার এই ভুক্তিটির সাথে মিলে গেছে: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2"-কে "$3"-এ সরানো যাবে না, কারণ "$3" শিরোনামটি নিষিদ্ধ। শিরোনামটি এই কালোতালিকা ভুক্তিটির সাথে মিলে গেছে: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" ফাইলনামটি সৃষ্টি নিষিদ্ধ। নামটি এই কালোতালিকা ভুক্তিটির সাথে মিলে গেছে: <code>$1</code>',
	'titleblacklist-invalid' => 'শিরোনাম কালোতালিকার এই {{PLURAL:$1|টি লাইন|টি লাইন}} অবৈধ; অনুগ্রহ করে সংরক্ষণ করার আগে  {{PLURAL:$1|এটি|এগুলি}} সংশোধন করুন:',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'titleblacklist-desc' => "a ro tro d'ar verourien da verzañ krouiñ pajennoù ha kontoù implijerien hervez [[MediaWiki:Titleblacklist|listenn zu]] hag ur [[MediaWiki:Titlewhitelist|listenn wenn]]",
	'titleblacklist-forbidden-edit' => 'Difennet eo krouiñ an anv "$2".
Er roll du e klot gant ar kasadenn da heul : <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Ne c\'hell ket bezañ fiñvet "$2" davet "$3", peogwir eo bet nac\'het.
Klotañ a ran gant kasadenn da heul ar roll du : <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Skarzhet eo bet an anv restr "$2".
Klotañ a ran gant kasadenn da heul ar roll du : <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Skarzhet eo bet an anv implijer "$2".
Klotañ a ran gant kasadenn da heul ar roll du : <code>$1</code>',
	'titleblacklist-invalid' => 'Al {{PLURAL:$1|linenn|linennoù}} da heul a zo e-barzh roll du an titloù a zo fall ; 
mar plij reizhit {{PLURAL:$1|anezhi|anezho}} a-raok enrollañ.',
	'right-tboverride' => 'Dianavezout roll du an titloù',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'titleblacklist-desc' => 'Omogućuje administratorima da zabrane pravljenje stranica i korisničkih računa putem spiskova [[MediaWiki:Titleblacklist|zabranjenih]] i [[MediaWiki:Titlewhitelist|dopuštenih]] naslova',
	'titleblacklist' => '# Ovo je spisak zabranjenih naslova. Naslovi i korisnici koji se nalaze na ovom spisku neće moći biti napravljeni.
# Koristite "#" za komentare.
# Ovo ne razlikuje velika i mala slova po pretpostavljenom',
	'titlewhitelist' => '# Ovo je spisak dopuštenih naslova. Koristite "#" za komentare.
# Ovo ne razlikuje velika i mala slova po pretpostavljenom',
	'titleblacklist-forbidden-edit' => 'Naslov "$2" je zabranjen za pravljenje.
Nalazi se kao stavka na spisku zabranjenih naslova: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" ne može biti premješten na "$3", jer je naslov "$3" zabranjen za pravljenje.
Nalazi se kao slijedeća stavka spiska nepoželjnih naslova: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Datoteka sa imenom "$2" je zabranjena za postavljanje.
Nalazi se kao stavka na spisku zabranjenih naslova: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Korisničko ime "$2" je zabranjeno za pravljenje.
Ono se nalazi na spisku zabranjenih naslova pod stavkom: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Slijedeći red|Slijedeća $1 reda|Slijedećih $1 redova}} na spisku nepoželjnih naslova {{PLURAL:$1|je nevalidan|su nevalidna|je nevalidno}};
molimo da {{PLURAL:$1|ga|ih}} ispravite prije spremanja:',
	'right-tboverride' => 'Zaobilaženje spiska zabranjenih naslova',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author SMP
 * @author Vriullop
 */
$messages['ca'] = array(
	'titleblacklist-desc' => "Permet als administradors restringir la creació de pàgines i comptes d'usuari mitjançant una [[MediaWiki:Titleblacklist|llista negra]] i una [[MediaWiki:Titlewhitelist|llista blanca]]",
	'titleblacklist' => "# Açò és una llista negra de títols. Els títols i els usuaris que compleixin alguna expressió regular (''regex'') d'aquí no podran ser creats.
# Feu servir \"#\" per als comentaris.
# Per defecte, no distingeix majúscules de minúscules",
	'titlewhitelist' => '# Açò és una llista blanca de títols. Useu "#" pels comentaris.
# Per defecte, no distingeix majúscules de minúscules',
	'titleblacklist-forbidden-edit' => 'El títol «$2» està prohibit i no es pot crear. Concorda amb la següent entrada de la llista negra: <code>$1</code>',
	'titleblacklist-forbidden-move' => "No es pot moure «$2» a «$3», perquè el títol «$3» està prohibit. Concorda amb l'entrada de la llista negra següent: <code>$1</code>",
	'titleblacklist-forbidden-upload' => "El nom de fitxer «$2» ha estat prohibit i se n'impedeix la creació. Concorda amb la següent línia de la llista negra: <code>$1</code>",
	'titleblacklist-forbidden-new-account' => "No es pot crear el nom d'usuari «$2». Coincideix amb la següent entrada de la llista negra: <code>$1</code>",
	'titleblacklist-invalid' => '{{PLURAL:$1|La línia següent|Les línies següents}} de la llista negra no {{PLURAL:$1|és vàlida|són vàlides}}; heu de corregir-{{PLURAL:$1|la|les}} abans de guardar:',
	'right-tboverride' => 'Sobreescriure la llista negra',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'titleblacklist-desc' => 'Umožňuje správcům zakázat tvorbu stránek a uživatelských účtů na základě [[MediaWiki:Titleblacklist|černé listiny názvů]] a [[MediaWiki:Titlewhitelist|bílé listiny názvů]]',
	'titleblacklist' => '# Toto je černá listina názvů. Stránky a uživatelské účty, jejichž název odpovídá některému regulárnímu výrazu, nebude možné vytvořit.
# Komentáře začínají znakem „#“.
# Na velikosti písmen nezáleží.',
	'titlewhitelist' => '# Toto je bílá listina názvů stránek. Řádky komentářů začínají znakem „#“.
# Na velikosti písmen nezáleží.',
	'titleblacklist-forbidden-edit' => 'Je zakázáno vytvořit stránku s názvem „$2“. Odpovídá následujícímu záznamu na černé listině: <code>$1</code>',
	'titleblacklist-forbidden-move' => '„$2“ nelze přesunout na název „$3“, protože název „$3“ je zakázáno vytvářet. Odpovídá následujícímu záznamu na černé listině: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Soubor s jménem „$2“ je zakázáno vytvářet. Název odpovídá následujícímu záznamu na černé listině: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Není dovoleno zaregistrovat uživatelské jméno „$2“.
Odpovídá následující položce černé listiny: <code>$1</code>',
	'titleblacklist-invalid' => 'Na černé listině názvů {{PLURAL:$1|je následující řádka neplatný regulární výraz|jsou následující řádky neplatné regulární výrazy|jsou následující řádky regulární výrazy}} a je nutné {{PLURAL:$1|ji|je|je}} před uložením stránky opravit :',
	'right-tboverride' => 'Potlačení nepovolených názvů stránek',
);

/** German (Deutsch)
 * @author Giftpflanze
 * @author Imre
 * @author Metalhead64
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'titleblacklist-desc' => 'Ermöglicht Administratoren, die Erstellung unerwünschter Seiten- und Benutzernamen zu verhindern: [[MediaWiki:Titleblacklist]] und [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Dies ist eine Schwarze Liste.
# Jeder Seiten- und Benutzername, auf den die folgenden regulären Ausdrücke zutreffen, kann nicht erstellt werden.
# Text hinter einer Raute „#“ wird als Kommentar gesehen.
# Standardgemäß wird nicht zwischen Groß- und Kleinschreibung unterschieden',
	'titlewhitelist' => '# Dies ist die Ausnahmeliste von der Schwarzen Liste unerwünschter Seitennamen. Benutze „#“ für Kommentare
# Standardmäßig wird nicht zwischen Groß- und Kleinschreibung unterschieden',
	'titleblacklist-forbidden-edit' => "'''Eine Seite mit dem Titel „$2“ kann nicht erstellt werden.'''<br />Der Titel kollidiert mit diesem Sperrbegriff: '''''$1'''''",
	'titleblacklist-forbidden-move' => "'''Die Seite „$2“ kann nicht nach „$3“ verschoben werden.'''<br />Der Titel kollidiert mit diesem Sperrbegriff: '''''$1'''''",
	'titleblacklist-forbidden-upload' => "'''Eine Datei mit dem Namen „$2“ kann nicht hochgeladen werden.'''<br />Der Titel kollidiert mit diesem Sperrbegriff: '''''$1'''''",
	'titleblacklist-forbidden-new-account' => 'Die Registrierung des Benutzernames „$2“ ist nicht erwünscht.
Folgender Eintrag aus der Liste unerwünschter Benutzernamen führte zur Ablehnung: <code>$1</code>',
	'titleblacklist-invalid' => 'Die {{PLURAL:$1|folgende Zeile|folgenden Zeilen}} in der Sperrliste {{PLURAL:$1|ist|sind}} ungültig; bitte korrigiere diese vor dem Speichern:',
	'right-tboverride' => 'Außerkraftsetzen der schwarzen Liste unerwünschter Seitennamen',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 */
$messages['de-formal'] = array(
	'titlewhitelist' => '# Dies ist die Ausnahmeliste von der Schwarzen Liste unerwünschter Seitennamen. Benutzen Sie „#“ für Kommentare
# Standardmäßig wird nicht zwischen Groß- und Kleinschreibung unterschieden',
	'titleblacklist-invalid' => 'Die {{PLURAL:$1|folgende Zeile|folgenden Zeilen}} in der Sperrliste {{PLURAL:$1|ist|sind}} ungültig; bitte korrigieren Sie diese vor dem Speichern:',
);

/** Zazaki (Zazaki)
 * @author Aspar
 */
$messages['diq'] = array(
	'titleblacklist-desc' => 'serkaran re desturê vıraştışê pel u hesabê karberan dano, qey qedexekerdışi re yew [[MediaWiki:Titleblacklist|listeya risiyayan]] u [[MediaWiki:Titlewhitelist|listeya risıpiyan]] dano.',
	'titleblacklist' => '# no yew sernameyê qerelisteyo.
# qey mışorekerdışi "#" bıxulunê.
# no farazi herfa qıc u gırdi re hessas niyo',
	'titlewhitelist' => '# no yew sernameyê listeya risıpiyan o. qey mışorekerdışi "#" bışuxulnê.
# no farazi herfa qıc u gırdi re hessas niyo',
	'titleblacklist-forbidden-edit' => 'vıraştışê sernameyê "$2" i qedexe bı .
malumatê ey na listeyasiya de zepê ya: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'no "$2", "$3" pel re nêkırışiyeno çunke vıraştışê sernameyê "$3"i qedexe biyo. 
malumatê ey na listeyasiya de zepê ya: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'vıraştışê sernameyê dosyaya"$2"i qedexe bı.
malumatê ey na listeyasiya de zêpê ya: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'vıraştışê nameyê karberê"$2" i qedexe bı.
malumatê ey na listeyasiya de zêpê ya: <code>$1</code>',
	'titleblacklist-invalid' => 'nê {{PLURAL:$1|satır o ke|satır ê ke}} listeyasiyayi de qedexe yê;
kerem kerê verqeydkerdışi de raşt kerê:',
	'right-tboverride' => 'sernameyê listeya siyayi bloke bıker',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'titleblacklist-desc' => 'Zmóžnja administratoram napóranjeju bokow a wužywarskich kontow pó [[MediaWiki:Titleblacklist|cornej lisćinje]] a [[MediaWiki:Titlewhitelist|běłej lisćinje]] zajźowaś',
	'titleblacklist' => '# To jo corna lisćina titelow. Titele a wužywarje, kótarež pśitrjefiju na regularny wuraz, njedaju se napóraś.
# Wužyj "#" za komentary.
# Pó standarźe to njeźiwa na wjelikopisanje',
	'titlewhitelist' => '# To jo běła lisćina titelow. Wužyj "#" za komentary.
# Pó standarźe to njeźiwa na wjelikopisanje.',
	'titleblacklist-forbidden-edit' => 'Titel "$2" jo pśeśiwo napóranjeju blokěrowany.
Pśitrjefijo na slědujucy zapisk: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" njedajo se do "$3" pśesunuś, dokulaž titel "$3" pśeśiwo napóranjeju blokěrowany.
Pśetrjefijo na slědujucy zapisk corneje lisćiny: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Datajowe mě "$2" je so blokěrowało pśeśiwo napóranjeju.
Pśetrjefijo na slědujucy zapisk corneje lisćiny: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Wužywarske mě "$2" jo se blokěrowało pśeśiwo napóranjeju.
Pśetrjefijo na slědujucy zapisk corneje lisćiny: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Slědujuca smužka|Slědujucej smužce|slědujuce smužki|Slědujuce smužki}} w cornej lisćinje titelow {{PLURAL:$1|jo njepłaśiwa|stej njepłaśiwej|su njepłaśiwe |su njepłaśiwe}}; pšosym skorigěruj {{PLURAL:$1|ju|jej|je|je}} do składowanja:',
	'right-tboverride' => 'Płaśiwosć corneje lisćiny titelow wótpóraś',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 * @author Geraki
 */
$messages['el'] = array(
	'titleblacklist-desc' => 'Επιτρέπει στους διαχειριστές να απαγορέψουν την δημιουργία σελίδων και λογαριασμών χρηστών σύμφωνα με μία [[MediaWiki:Titleblacklist|μαύρη λίστα]] και μία [[MediaWiki:Titlewhitelist|άσπρη λίστα]]',
	'titleblacklist' => '# Αυτή είναι μία μαύρη λίστα για τίτλους σελίδων. Τίτλοι και χρήστες οι οποίοι ταιριάζουν με μια regular expression εδώ, δεν μπορούν να δημιουργηθούν.
# Χρησιμοποιήστε το σύμβολο «#» για σχόλια.
# Από προεπιλογή είναι χωρίς διάκριση πεζών/κεφαλαίων .',
	'titlewhitelist' => '# Αυτή είναι μία λευκή λίστα για τίτλους σελίδων. Χρησιμοποιήστε το σύμβολο «#» για σχόλια.
# Από προεπιλογή είναι χωρίς διάκριση πεζών/κεφαλαίων .',
	'titleblacklist-forbidden-edit' => 'Η δημιουργία του τίτλου "$2" έχει φραγεί.
Ταιριάζει στην ακόλουθη εγγραφή της μαύρης λίστας: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Η σελίδα «$2» δεν μπορεί να μετακινηθεί στην «$3», επειδή η δημιουργία του τίτλου «$3» έχει φραγεί.
Ταιριάζει στην ακόλουθη εγγραφή της μαύρης λίστας: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Η δημιουργία του ονόματος αρχείου «$2» έχει φραγεί.
Ταιριάζει στην ακόλουθη εγγραφή της μαύρης λίστας: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Η δημιουργία του ονόματος χρήστη/χρήστριας «$2» έχει φραγεί.
Ταιριάζει στην ακόλουθη εγγραφή της μαύρης λίστας: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Η ακόλουθη γραμμή|Οι ακόλουθες γραμμές}} στην μαύρη λίστα τίτλων είναι {{PLURAL:$1|άκυρη|άκυρες}}· παρακαλώ διορθώστε {{PLURAL:$1|την|τις}} πριν την αποθήκευση:',
	'right-tboverride' => 'Παράκαμψη της μαύρης λίστας τίτλων',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'titleblacklist-desc' => 'Rajtigas la adminstrantojn malpermesi kreadon de paĝoj kaj uzanto-kontoj per [[MediaWiki:Titleblacklist|nigralisto]] kaj [[MediaWiki:Titlewhitelist|blankalisto]]',
	'titleblacklist' => '# Jen titola nigralisto. Titoloj kaj uzantoj kiuj kongruas regulan esprimon ĉi tie ne povas esti kreitaj.
# Uzu "#" por komentoj.
# Ĉi tio estas usklecodistingiva defaŭlte.',
	'titlewhitelist' => '# Ĉi tio estas blanklisto por titoloj. Uzu "#" por komentoj.
# Ĉi tio estas defaŭlte uskleca maldistingiva.',
	'titleblacklist-forbidden-edit' => 'La titolo "$2" estis malpermesita de kreado.
Ĝi similas la jenan nigralistan listeron: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" ne povas esti alinomita al "$3", ĉar la titolo "$3" estis forbarita de kreado.
Ĝi kongruas la jenan nigralistanon: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'La dosiernomo "$2" estis forbarita de kreado.
Ĝi kongruas la jenan nigralistanon: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'La uzanto-nomo "$2" estis forbarita de kreado.
Ĝi kongruas la jenan nigralistano: <code>$1</code>',
	'titleblacklist-invalid' => 'La {{PLURAL:$1|jena linio|jenaj linioj}} en la titola nigralisto estas {{PLURAL:$1|nevalida|nevalidaj}}; 
bonvolu korekti {{PLURAL:$1|gxi|ilin}} antaŭ konservado:',
	'right-tboverride' => 'Anstataŭigi la titolan nigraliston',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Locos epraix
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'titleblacklist-desc' => 'Permite que los administradores prohíban la creación de páginas y cuentas de usuario mediante una [[MediaWiki:Titleblacklist|lista negra]] y una [[MediaWiki:Titlewhitelist|lista blanca]]',
	'titleblacklist' => '# Esta es una lista negra de títulos. No se pueden crear títulos o usuarios que coincidan con una de estas expresiones regulares.
# Use «#» para comentarios.
# Esta es insensible a las mayúsculas por defecto',
	'titlewhitelist' => '# Esta es una lista blanca de títulos. Use «#» para comentarios.
# Esta es insensible a las mayúsculas por defecto',
	'titleblacklist-forbidden-edit' => 'Se ha bloqueado la creación del título «$2».
Coincide con la siguiente entrada de lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move' => '«$2» no puede ser trasladado a «$3», porque se ha bloqueado la creación del título «$3».
Coincide con la siguiente entrada de lista negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Se ha bloqueado el nombre de archivo «$2».
Coincide con la entrada de lista negra <code>$1</code>.',
	'titleblacklist-forbidden-new-account' => 'Se prohibe crear el nombre de usuario «$2».
Coincide con la siguiente entrada de la lista negra: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|La siguiente línea|Las siguientes líneas}} de la lista negra no {{PLURAL:$1|es válida|son válidas}};
por favor corríge{{PLURAL:$1|la|las}} antes de grabar:',
	'right-tboverride' => 'Ignorar la lista negra de títulos',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'titleblacklist-desc' => 'Võimaldab ülematel vastavalt [[MediaWiki:Titleblacklist|mustale]] ja [[MediaWiki:Titlewhitelist|valgele nimekirjale]] keelata lehekülgede ja kasutajakontode loomise.',
	'titleblacklist' => '# See on pealkirjade must nimekiri. Siinsetele regulaaravaldistele vastavaid pealkirju ega kasutajaid ei saa luua.
# Kommentaariks kasuta märki "#".
# Vaikimisi on see tõstutundetu',
	'titlewhitelist' => '# See pealkiri on valges nimekirjas. Kommentaariks kasuta märki "#".  
# Vaikimisi on see tõstutundetu',
	'titleblacklist-forbidden-edit' => 'Lehekülje pealkirjaga "$2" loomine on keelatud.
See vastab järgnevale musta nimekirja sissekandele: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Lehekülge "$2" ei saa teisaldada pealkirja "$3" alla, sest lehekülgede pealkirjaga "$3" loomine on keelatud.
See vastab järgnevale musta nimekirja sissekandele: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Pealkirjaga "$2" on keelatud faili üles laadida.
See vastab järgnevale musta nimekirja sissekandele: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Kasutaja nimega "$2" loomine on keelatud.
See vastab järgnevale musta nimekirja sissekandele: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Järgnev|Järgnevad}} musta nimekirja {{PLURAL:$1|rida on vigane|read on vigased}}.
Palun paranda {{PLURAL:$1|see|need}} enne salvestamist:',
	'right-tboverride' => 'Eirata pealkirjade musta nimekirja',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'titleblacklist-desc' => 'امکان جلوگیری از ایجاد صفحه‌هایی با عنوان‌های خاص را می‌دهد: [[MediaWiki:Titleblacklist]] و [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# این یک فهرست سیاه عنوان‌ها است. عنوان‌هایی که با یک regex در این صفحه مطابقت کنند را نمی‌توان ایجاد کرد.
# از «#» برای توضیحات استفاده کنید.',
	'titlewhitelist' => '# این یک فهرست سفید برای عنوان‌ها است. از «#» برای افزودن توضیحات استفاده کنید.',
	'titleblacklist-forbidden-edit' => 'ایجاد عنوان «$2» ممنوع شده‌است. این عنوان با این دستور از فهرست سیاه مطابقت می‌کند: <code>$1</code>',
	'titleblacklist-forbidden-move' => '«$2» را نمی‌توان به «$3» انتقال داد. ایجاد «$3» ممنوع است. چون با این دستور از فهرست سیاه مطابقت می‌کند: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'ایجاد نام «$2» برای پرونده‌ها ممنوع است، زیرا با این دستور از فهرست سیاه مطابقت می‌کند: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'حساب کاربری «$2» در برابر ایجاد محافظت شده‌است.
این نام کاربری با این قسمت از فهرست سیاه مطابقت دارد: <code>$1</code>',
	'titleblacklist-invalid' => '
{{PLURAL:$1|سطر|سطرهای}} زیر در فهرست سیاه عنوان‌ها غیرمجاز {{PLURAL:$1|است|هستند}}؛ لطفاً {{PLURAL:$1|آن|آن‌ها}} را قبل از ذخیره کردن اصلاح کنید:',
	'right-tboverride' => 'گذر از فهرست سیاه عنوان‌ها',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'titleblacklist-desc' => 'Antaa ylläpitäjälle mahdollisuuden estää sivujen luonti nimen perusteella: [[MediaWiki:Titleblacklist|estolista]] ja [[MediaWiki:Titlewhitelist|poikkeuslista]].',
	'titleblacklist' => '# Tämä on nimien musta luettelo. Sivuja tai käyttäjiä, jotka vastaavat täällä määritettyihin säännöllisiin lausekkeisiin, ei voi luoda.
# Käytä #-merkkiä kommentointiin.
# Oletusarvoisesti tämä on riippuvainen kirjainkoosta',
	'titlewhitelist' => '# Tämä on nimien valkoinen luettelo. Käytä #-merkkiä kommentointiin.
# Oletusarvoisesti tämä on riippuvainen kirjainkoosta',
	'titleblacklist-forbidden-edit' => 'Sivun ”$2” luonti on estetty, koska se täsmää seuraavaan osaan estolistassa: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Sivua ”$2” ei voi siirtää nimelle ”$3”, koska sivun ”$3” luonti on estetty. Se täsmää seuraavaan osaan estolistassa: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Tiedoston ”$2” luonti on estetty, koska se täsmää seuraavaan osaan estolistassa: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Käyttäjätunnuksen ”$2” luonti on estetty.
Tunnus täsmää seuraavaan estolistan sääntöön: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Seuraava listan rivi ei ole kelvollinen|Seuraavat listan rivit eivät ole kelvollisia}}. Korjaa {{PLURAL:$1|se|ne}} ennen tallentamista.',
	'right-tboverride' => 'Ohittaa sivunimien mustalista',
);

/** French (Français)
 * @author Crochet.david
 * @author Elfix
 * @author Grondin
 * @author IAlex
 * @author Meithal
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Zetud
 */
$messages['fr'] = array(
	'titleblacklist-desc' => 'Permet aux administrateurs d’interdire la création de pages et de comptes utilisateur en fonction d’une [[MediaWiki:Titleblacklist|liste noire]] et d’une [[MediaWiki:Titlewhitelist|liste blanche]]',
	'titleblacklist' => '# Ceci est la liste noire des titres. Les titres et les utilisateurs qui correspondent à une expression rationnelle présente sur cette page ne peuvent pas être créés.
# Utilisez « # » pour insérer des commentaires.
# Par défaut, les entrées ne sont pas sensibles à la casse.',
	'titlewhitelist' => '# Ceci est la liste blanche des titres. Utilisez « # » pour insérer des commentaires.
# Les entrées ne sont pas sensibles à la casse par défaut.',
	'titleblacklist-forbidden-edit' => 'Le titre « $2 » est interdit à la création.
Dans la liste noire, il est détecté par l’entrée suivante : <code>$1</code>',
	'titleblacklist-forbidden-move' => 'La page intitulée « $2 » ne peut être déplacée vers « $3 » parce que cette dernière a été interdite à la création. Dans la liste noire, elle correspond à l’entrée : <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Le fichier intitulé « $2 » est interdit à la création. Dans la liste noire, il correspond à l’entrée : <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Le nom d’utilisateur « $2 » a été banni à la création.
Il correspond à l’entrée suivante de la liste noire : <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|La ligne suivante|Les lignes suivantes}} dans la liste noire des titres {{PLURAL:$1|est invalide. Veuillez la|sont invalides. Veuillez les}} corriger avant de publier.',
	'right-tboverride' => 'Ignorer la liste noire des titres',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'titleblacklist-desc' => 'Pèrmèt ux administrators de dèfendre la crèacion de pâges et de comptos utilisator d’aprés una [[MediaWiki:Titleblacklist|lista nêre]] et una [[MediaWiki:Titlewhitelist|lista blanche]].',
	'titleblacklist' => '# O est la lista nêre des titros. Los titros et los utilisators que corrèspondont a una èxprèssion racionèla presenta sur ceta pâge pôvont pas étre fêts.
# Utilisâd « # » por entrebetar des comentèros.
# Per dèfôt, les entrâs sont pas sensibles a la câssa.',
	'titlewhitelist' => '# O est la lista blanche des titros. Utilisâd « # » por entrebetar des comentèros.
# Per dèfôt, les entrâs sont pas sensibles a la câssa.',
	'titleblacklist-forbidden-edit' => 'Lo titro « $2 » at étâ dèfendu a la crèacion.
Dens la lista nêre, corrèspond a ceta entrâ : <code>$1</code>',
	'titleblacklist-forbidden-move' => 'La pâge « $2 » pôt pas étre renomâ en « $3 », perce que lo titro « $3 » at étâ dèfendu a la crèacion.
Dens la lista nêre, corrèspond a ceta entrâ : <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Lo nom de fichiér « $2 » at étâ dèfendu a la crèacion.
Dens la lista nêre, corrèspond a ceta entrâ : <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Lo nom d’utilisator « $2 » at étâ dèfendu a la crèacion.
Dens la lista nêre, corrèspond a ceta entrâ : <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Ceta legne|Cetes legnes}} dens la lista nêre des titros {{PLURAL:$1|est envalida. Volyéd la|sont envalides. Volyéd les}} corregiér devant que sôvar.',
	'right-tboverride' => 'Ignorar la lista nêre des titros',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'titleblacklist-desc' => 'Ceadaionn na riarthóirí coisc a chur faoi leathanaigh agus cuntais nua a chruthú, de réir [[MediaWiki:Titleblacklist|dúliosta teideail]] agus [[MediaWiki:Titlewhitelist|bánliosta teideail]]',
	'titleblacklist' => '# Seo é an dúliosta teideail. Ní féidir teideail ná úsáideoirí a chruthú atá meaitseáil slonn rialta anseo.
# Usáideann "#" mar nótaí tráchta.',
	'titlewhitelist' => '# Seo é an bánliosta teideail. Usáideann "#" mar nótaí tráchta.',
	'titleblacklist-forbidden-edit' => 'Tá toirmeasc ar an teideal "$2 a chruthú.<br />
Tá sé chomhoiriúna leis an iontráil dúliosta a leanas: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Ní féidir "$2" a athainmnigh go "$3", mar tá an teideal "$3" coiscthe faoi chruthú.
Tá sé chomhoiriúint leis an iontráil seo a leanas sa dúliosta teideail: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Tá an ainm comhaid "$2" coiscthe faoi chruthú.
Tá sé chomhoiriúint leis an iontráil seo a leanas sa dúliosta teideail: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Tá an ainm úsáideorá "$2" coiscthe faoi chruthú.
Tá sé chomhoiriúint leis an iontráil seo a leanas sa dúliosta teideail: <code>$1</code>',
	'titleblacklist-invalid' => "Tá {{PLURAL:$1|an|na}} {{PLURAL:$1|líne|líonta}} seo a leanas neamhbhailí sa dúliosta teideail;
ceartaigh {{PLURAL:$1|é|iad}} roimh shábháil, le d'thoil:",
	'right-tboverride' => 'Sáraíocht an dúliosta teideail',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'titleblacklist-desc' => 'Permítelle aos administradores prohibir a creación de páxinas e contas de usuario grazas a unha [[MediaWiki:Titleblacklist|lista negra]] e mais unha [[MediaWiki:Titlewhitelist|lista branca]] de títulos',
	'titleblacklist' => '# Esta é unha lista negra de títulos. Non se pode crear ningún título ou usuario que coincida cunha destas expresións regulares.
# Use "#" para os comentarios.
# Por defecto, diferencia entre maiúsculas e minúsculas',
	'titlewhitelist' => '# Este é un título da lista branca. Use "#" para os comentarios.  
# Por defecto, diferencia entre maiúsculas e minúsculas',
	'titleblacklist-forbidden-edit' => 'O título "$2" foi protexido fronte á súa creación. Coincide coa seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" non pode ser movido a "$3", porque o título "$3" foi protexido fronte á súa creación. Coincide coa seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'O nome do ficheiro "$2" foi protexido fronte á súa creación.
Coincide coa seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'O nome de usuario "$2" foi protexido fronte á súa creación.
Coincide coa seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|A seguinte liña|As seguintes liñas}} da lista negra {{PLURAL:$1|é inválida|son inválidas}}; por favor  {{PLURAL:$1|corríxaa|corríxaas}} antes de gardar:',
	'right-tboverride' => 'Ignorar os títulos da lista negra (blacklist)',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'titleblacklist-desc' => 'Macht s Ammanne megli, s Aalege vu nit gwinschte Syten- un Benutzernäme z verhindere: [[MediaWiki:Titleblacklist]] un [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Des isch e Schwarzi Lischt. Jede Syten- un Benutzername, wu die Uusdrick druf zueträffe, cha nit aagleit wäre.
# Täxt hinter ere Raute „#“ wird as Kommentar gsähne.
# Des isch standardmäßig nit abhängig vum Einzelfall.',
	'titlewhitelist' => '# Des isch d Usnahmelischt vu dr Schwarze Lischt vu nit gwinschte Sytenäme. Verwänd „#“ fir Kommentar.
# Des isch nit abhängig vum Einzelfall',
	'titleblacklist-forbidden-edit' => "'''E Syte mit em Titel „$2“ cha nit aagleit wäre.'''<br />Dr Titel kollidiert mit däm gsperrte Usdruck: '''''$1'''''",
	'titleblacklist-forbidden-move' => "'''D Syte „$2“ cha nit no „$3“ verschobe wäre.'''<br />Dr Titel kollidiert mit däm gsperrte Usdruck: '''''$1'''''",
	'titleblacklist-forbidden-upload' => "'''E Datei mit em Name „$2“ cha nit uffeglade wäre.'''<br />Dr Titel kollidiert mit däm gsperrte Usdruck: '''''$1'''''",
	'titleblacklist-forbidden-new-account' => 'D Regischtrierig vum Benutzername „$2“ isch nit gwinscht.
Dr Name kollidiert mit däm gsperrte Name: <code>$1</code>',
	'titleblacklist-invalid' => 'Die {{PLURAL:$1|Zyylete|Zyylete}} in dr Sperrlischt {{PLURAL:$1|isch|sin}} nit giltig; bitte korrigier si vor em Spychere:',
	'right-tboverride' => 'Di Schwarz Lischt vu nit gwinschte Sytennäme usser Chraft setze',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'titleblacklist-desc' => 'אפשרות למנהלים לאסור על יצירת דפים וחשבונות משתמש לפי [[MediaWiki:Titleblacklist|רשימה שחורה]] ו[[MediaWiki:Titlewhitelist|רשימה לבנה]]',
	'titleblacklist' => '# זוהי רשימת הכותרות האסורות. לא ניתן ליצור כותרות וחשבונות משתמש שמתאימים לביטוי רגולרי המופיע כאן.
# השתמשו בסימן "#" להערות.
#רשימה זו אינה תלויה ברישיות כברירת מחדל.',
	'titlewhitelist' => '# זוהי רשימת הכותרות המותרות. השתמשו בסימן "#" להערות.
#רשימה זו אינה תלויה ברישיות כברירת מחדל.',
	'titleblacklist-forbidden-edit' => 'הכותרת "$2" היא כותרת אסורה ליצירה.
היא מתאימה לערך הבא ברשימת הכותרות האסורות: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'לא ניתן להעביר את "$2" לשם "$3", כיוון שהכותרת "$3" אסורה ליצירה.
היא מתאימה לערך הבא ברשימה השחורה: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'שם הקובץ "$2" נאסר ליצירה.
הוא מתאים לערך הבא ברשימה השחורה: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'שם המשתמש "$2" נאסר ליצירה.
הוא מתאים לערך הבא ברשימה השחורה: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|השורה הבאה|השורות הבאות}} ברשימת הכותרות האסורות {{PLURAL:$1|אינה תקינה|אינם תקינים}};
אנא תקנו {{PLURAL:$1|אותה|אותן}} לפני השמירה:',
	'right-tboverride' => 'עקיפת רשימת הכותרות האסורות',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 * @author आलोक
 */
$messages['hi'] = array(
	'titleblacklist-desc' => 'विशिष्ठ नामपदों: [[MediaWiki:Titleblacklist]] और [[MediaWiki:Titlewhitelist]] के साथ वाले पृष्ठों के निर्माण अवरोधन में सहायक है',
	'titleblacklist' => '# यह एक ब्लैकलिस्ट नामपद है। नामपद जो ब्लैकलिस्ट सूची से मेल खाता है, निर्मित नहीं किए जा सकते।
# टिपण्णी के लिए "#" का प्रयोग करें।',
	'titlewhitelist' => '# यह टाईटल व्हाईटलिस्ट हैं। टिप्पणीयों के लिये "#" का इस्तेमाल करें।',
	'titleblacklist-forbidden-edit' => 'नामपद "$2" निर्मित करने से प्रतिबंधित है।
यह निम्नांकित ब्लैकलिस्ट प्रवेशिका से मेल खाता है: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" का नाम बदलकर "$3" नहीं किया जा सकता, क्योंकि "$3" को निर्माण करने से प्रतिबंधित किया गया है।
यह निम्नांकित ब्लैकलिस्ट प्रवेशिका से मेल खाता है: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'संचिका नाम "$2" निर्मित करने से प्रतिबंधित है।
यह निम्नांकित कालीसूची प्रविष्टि से मेल खाता है: <code>$1</code>',
	'titleblacklist-invalid' => 'ब्लैकलिस्ट नामपद में निम्नांकित {{PLURAL:$1|पंक्ति|पंक्तियाँ}} अमान्य {{PLURAL:$1|है|हैं}};
कृपया {{PLURAL:$1|इसे|इन्हें}} जमा करने से पहले ठीक करें:',
	'right-tboverride' => 'शीर्षक ब्लॅकलिस्ट को नजर अंदाज करें',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'titleblacklist-desc' => 'Omogućava administratorima postavljanje zabrane kreiranja stranica ili računa s [[MediaWiki:Titleblacklist|crnim popisom]] i [[MediaWiki:Titlewhitelist|bijelim popisom]]',
	'titleblacklist' => '# Ovo je popis zabranjenih naslova. Naslovi i računi koji se podudaraju s regularnim izrazom ne mogu se kreirati.
# Koristite "#" za komentare.
# Ovo je osjetljivo na velika slova',
	'titlewhitelist' => "# Ovo je tzv. ''bijela knjiga'' ili ''whitelist'' imena članaka. Rabite \"#\" za komentar
# Ovo je osjetljivo na velika slova",
	'titleblacklist-forbidden-edit' => 'Naslov "$2" je zabranjen za kreiranje.  Podudara se sa sljedećom stavkom popisa zabranjenih: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" ne može biti premješten na "$3", jer je naslov "$3" zabranjeno kreirati. Podudara se sa sljedećom stavkom popisa zabranjenih: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Ime datoteke "$2" je zabranjeno kreirati. Poklapa se sa stavkom popisa zabranjenih: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Suradnički račun "$2" je zabranjen za kreiranje.
Poklapa se sa sljedećim izrazom iz crnog popisa: <code>$1</code>',
	'titleblacklist-invalid' => 'Sljedeći {{PLURAL:$1|redak|redci}} u popisu zabranjenih naslova {{PLURAL:$1|je|su}} nedozvoljeni; molimo ispravite {{PLURAL:$1|ga|ih}} prije spremanja:',
	'right-tboverride' => 'Premošćivanje naslova u crnom popisu',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'titleblacklist-desc' => 'Dowola administratoram wutworjenje stronow a wužiwarskich kontow z pomocu [[MediaWiki:Titleblacklist|čorneje lisćiny]] a [[MediaWiki:Titlewhitelist|běłeje lisćiny]] zakazać',
	'titleblacklist' => '# To je čorna lisćina titulow. Titule a wužiwarjo, kotrež so na regularny wuraz hodźa, njehodźa so wutworić.
# Wužij "#" za komentary.
# Po standardźe to na wulkopisanje njedźiwa',
	'titlewhitelist' => '# To je běła lisćina titulow. Wužij "#" za komentary.
# Po standardźe to na wulkopisanje njedźiwa',
	'titleblacklist-forbidden-edit' => 'Strona z titulom "$2" njeda so wutworić. Wotpowěduje slědowacemu zapiskej čorneje lisćiny: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Strona z titulom "$2" njeda so do "$3" přesunyć, dokelž titul "$3" njesmě so wutworjeć.
Kryje so ze slědowacym zaspiskom čorneje lisćiny: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Dataja z mjenom "$2" njesmě so wutworjeć. Kryje so ze slědowacym zapiskom čorneje lisćiny: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Wužiwarske mjeno "$2" bu za registrowanje zawrjene.
Wotpowěduje slědowacemu zapiskej čorneje lisćiny: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Slědowaca linka|Slědowace linki}} w čornej lisćinje titulow {{PLURAL:$1|je njepłaćiwa|su njepłaćiwe}}; prošu skoriguj {{PLURAL:$1|ju|je}} před składowanjom:',
	'right-tboverride' => 'Płaćiwosć čorneje lisćiny nastawkow zběhnyć',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Tgr
 */
$messages['hu'] = array(
	'titleblacklist-desc' => 'Lehetővé teszi az adminisztrátorok számára, hogy letiltsák adott című lapok vagy nevű felhasználói fiókok készítését a [[MediaWiki:Titleblacklist]] és [[MediaWiki:Titlewhitelist]] alapján',
	'titleblacklist' => '# Ez a címek feketelistája. Azon címek, amelyek illeszkednek az itt található reguláris kifejezések valamelyikére, nem hozhatóak létre.
# Használd a „#” karaktert megjegyzések írásához.
# A sorok kis- és nagybetűérzékenyek alapértelmezettként',
	'titlewhitelist' => '# Ez egy engedélyező lista. A „#” karakterrel írhatsz megjegyzéseket.
# A sorok kis- és nagybetűérzékenyek alapértelmezettként',
	'titleblacklist-forbidden-edit' => '„$2” címmel tilos lapot készíteni, mert illeszkedik a feketelista <code>$1</code> bejegyzésére.',
	'titleblacklist-forbidden-move' => '„$2” nem nevezhető át „$3” névre, mert „$3” névvel tilos lapot készíteni. Illeszkedik a következő feketelistás bejegyzéssel: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '„$2” nevű fájlt tilos feltölteni, mert illeszkedik a feketelista <code>$1</code> bejegyzésére.',
	'titleblacklist-forbidden-new-account' => 'A(z) „$2” felhasználói név nem hozható létre.
Illeszkedik a következő feketelistás elemre: <code>$1</code>',
	'titleblacklist-invalid' => 'Az alábbi {{PLURAL:$1|sor hibás|sorok hibásak}} a lapcímek feketelistájában; {{PLURAL:$1|javítsd|javítsd őket}} mentés előtt:',
	'right-tboverride' => 'címek feketelistájának figyelmen kívül hagyása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'titleblacklist-desc' => 'Permitte al administratores prohibir le creation de paginas e contos de usator per medio de un [[MediaWiki:Titleblacklist|lista nigre]] e de un [[MediaWiki:Titlewhitelist|lista blanc]]',
	'titleblacklist' => '# Isto es un lista nigre de titulos. Le titulos e usatores que corresponde a un
# expression regular includite hic non pote esser create. Usa "#" pro commentos.
# Per predefinition, le differentia inter majusculas e minusculas non es significante.',
	'titlewhitelist' => '# Isto es un lista blanc de titulos. Usa "#" pro commentos.
# Per predefinition, le differentia inter majusculas e minusculas non es significante.',
	'titleblacklist-forbidden-edit' => 'Le creation del titulo "$2" ha essite prohibite.
Illo corresponde al sequente entrata del lista nigre: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" non pote esser renominate a "$3", proque le creation del titulo "$3" ha essite prohibite.
Illo corresponde al sequente entrata del lista nigre: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Le creation del nomine de file "$2" ha essite prohibite.
Illo corresponde al sequente entrata del lista nigre: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Le creation del nomine de usator "$2" ha essite prohibite.
Illo corresponde al sequente entrata del lista nigre: <code>$1</code>',
	'titleblacklist-invalid' => 'Le sequente {{PLURAL:$1|linea|lineas}} in le lista nigre de titulos es invalide; per favor corrige {{PLURAL:$1|lo|los}} ante de immagazinar:',
	'right-tboverride' => 'Ignorar le lista nigre de titulos',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'titleblacklist-desc' => 'Mengizinkan pencegahan pembuatan halaman dengan judul tertentu: [[MediaWiki:Titleblacklist]] dan [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Ini adalah daftar hitam judul. Judul dan nama pengguna yang berkesamaan dengan suatu regex berikut ini tidak dapat dibuat.
# Gunakan "#" untuk komentar.
# Daftar ini secara standar tidak memandang huruf besar-huruf kecil.',
	'titlewhitelist' => '# Ini adalah daftar putih judul. Gunakan "#" untuk komentar.
# Daftar ini secara standar tidak memandang huruf besar-huruf kecil.',
	'titleblacklist-forbidden-edit' => 'Judul "$2" telah dicekal untuk dibuat. Judul tersebut cocok dengan entri daftar hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" tak dapat dipindahkan ke "$3" karena judul "$3" telah dicekal untuk dibuat. Judul tersebut cocok dengan entri daftar hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Nama berkas "$2" telah dicekal untuk dibuat. Judul tersebut cocok dengan entri daftar hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Nama pengguna "$2" tidak diperbolehkan.
Nama ini sama dengan entri daftar hitam berikut: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Baris|Baris-baris}} dalam daftar hitam judul {{PLURAL:$1|berikut|berikut}} tak valid; silakan koreksi {{PLURAL:$1|item|item-item}} tersebut sebelum disimpan:',
	'right-tboverride' => 'Mengabaikan daftar hitam judul',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'titleblacklist-desc' => 'Consente di proibire la creazione di pagine e account utente con i titoli indicati in una [[MediaWiki:Titleblacklist|blacklist]] e una [[MediaWiki:Titlewhitelist|whitelist]]',
	'titleblacklist' => '# Lista dei titoli non consentiti.
# È impedita la creazione delle pagine e degli account il cui nome corrisponde a un\'espressione regolare indicata di seguito.
# Usare "#" per le righe di commento.
# Per default la differenza tra maiuscole e minuscole non è significativa',
	'titlewhitelist' => '# Questa è una whitelist dei titoli. Usare "#" per le righe di commento
# Per default la differenza tra maiuscole e minuscole non è significativa',
	'titleblacklist-forbidden-edit' => 'La creazione di pagine con titolo "$2" è stata impedita. La voce corrispondente nell\'elenco dei titoli non consentiti è la seguente: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Impossibile spostare la pagina "$2" al titolo "$3" in quanto la creazione di pagine con titolo "$3" è stata impedita. La voce corrispondente nell\'elenco dei titoli non consentiti è la seguente: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'La creazione di file con titolo "$2" è stato impedito. La voce corrispondente nell\'elenco dei titoli non consentiti è la seguente: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'La creazione di utenti con nome "$2" è stata impedita. La voce corrispondente nell\'elenco dei nomi non consentiti è la seguente: <code>$1</code>',
	'titleblacklist-invalid' => "{{PLURAL:$1|La seguente riga|Le seguenti righe}} dell'elenco dei titoli non consentiti {{PLURAL:$1|non è valida|non sono valide}}; si prega di correggere {{PLURAL:$1|l'errore|gli errori}} prima di salvare la pagina.",
	'right-tboverride' => 'Ignora la blacklist dei titoli',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author Marine-Blue
 * @author Muttley
 */
$messages['ja'] = array(
	'titleblacklist-desc' => '管理者が[[MediaWiki:Titleblacklist|ブラックリスト]] および [[MediaWiki:Titlewhitelist|ホワイトリスト]]を使ってページおよび利用者アカウントの新規作成を禁止できるようにする',
	'titleblacklist' => '# これは、ページ名のブラックリストです。正規表現に一致するページ名および利用者アカウントの新規作成を禁止します。
# "#" 以降はコメントとして扱われます。
# デフォルトでは大文字と小文字の区別はされません。',
	'titlewhitelist' => '# これは、ページ名のホワイトリストです。"#"以降はコメントとして扱われます。
# デフォルトでは大文字と小文字の区別はされません。',
	'titleblacklist-forbidden-edit' => '"$2" という名前での新規作成は禁止されています。これは以下のブラックリスト項目に一致します: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$3" という名前での新規作成は禁止されているため、"$2" を移動することはできません。これは以下のブラックリスト項目に一致します: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" というファイル名でのアップロードは禁止されています。これは以下のブラックリスト項目に一致します: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'ブラックリストエントリ:<code>$1</code>と一致したため、"$2" というアカウントは作成できませんでした。',
	'titleblacklist-invalid' => 'タイトルブラックリスト中の以下の{{PLURAL:$1|行}}は正しく記述できて{{PLURAL:$1|いません}}。保存する前に{{PLURAL:$1|修正して}}ください:',
	'right-tboverride' => 'タイトルブラックリストによる編集制限を受けない',
);

/** Jutish (Jysk)
 * @author Huslåke
 * @author Ælsån
 */
$messages['jut'] = array(
	'titleblacklist-desc' => 'Kan til førbæd skeppenge der pæger ve spæsifiærn titler: [[MediaWiki:Titleblacklist]] og [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Dett\'er en titel blackliste. Titler dette match en regex her ken ekke være skeppen.
# Brug "#" før bemærkenge.',
	'titlewhitelist' => '# Dett\'er en titel whiteliste. Brug "#" før bemærkenge',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'titleblacklist-desc' => 'Marengaké pangurus menggak wong nggawé kaca lan akun miturut [[MediaWiki:Titleblacklist|daftar-ireng]] lan [[MediaWiki:Titlewhitelist|daftar-putih]]',
	'titleblacklist' => '# Iki dhaptar-ireng irah-irahan. Irah-irahan lan panganggo sing cocog karo sawijining regex ing kéné ora bisa digawé.
# Anggonen "#" kanggo komentar.
# Dhaptar iki sacara baku ora mbédakaké aksara gedhé-cilik.',
	'titlewhitelist' => '# Dhaptar iki arupa dhaptar-putih irah-irahan. Anggonen "#" kanggo komentar.
# Dhaptar iki sacara baku ora mbédakaké aksara gedhé-cilik.',
	'titleblacklist-forbidden-edit' => 'Irah-irahan "$2" dilarang digawé.
Irah-irahan iki cocog karo èntri daftar ireng iki: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" ora bisa dipindhahaké menyang "$3", amerga irah-irahan iki "$3" dilarang ora olèh digawé.
Irah-irahan iki soalé cocog karo èntri daftar ireng iki: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Jeneng berkas "$2" wis dilarang kanggo digawé. 
Irah-irahan iku cocog karo èntri daftar ireng iki: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Jeneng panganggo "$2" wis dipenggak.
Iki cocog karo jeneng ing dhaptar-ireng: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Baris|Baris-baris}} ing daftar ireng irah-irahan (judhul) {{PLURAL:$1|ing ngisor|ing ngisor}} iki ora absah; mangga dikorèksi {{PLURAL:$1|item|item-item}} iku sadurungé disimpen:',
	'right-tboverride' => "''Override'' daftar ireng judhul",
);

/** Georgian (ქართული)
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'titleblacklist-desc' => 'აძლევს ადმინისტრატორებს უფლებას შექმნან ანგარიშები და გვერდები [[MediaWiki:Titleblacklist|შავი]] და [[MediaWiki:Titlewhitelist|თეთრი]] სიების მეშვეობით.',
	'titleblacklist' => '# ეს არის აკრძალულ სახელთა სია.გვერდები და ანგარიშები, რომლებიც ემთხვევა რეგულარულ სახელწოდებებს ვერ შეიქმნება. 
# გამოიყენეთ «#» კომენტარებისთვის
# არ არის გრძნობადბა რეგისტრისადმი',
	'titlewhitelist' => '# ეს არის სახელწოდებათა  «თეთრი სია». კომენტარებისთვის გამოიყენეთ «#»
# არ არის გრძნობადბა რეგისტრისადმი',
	'titleblacklist-forbidden-edit' => 'სათაური "$2" დაბლოკილი. ამ სათაურით გვერდის შექმნა აკრძალულია
იგი მსგავსია შავი სიიდან შემდეგ ჩანაწერს: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'შეუძლებელია გვერდ  «$2»-ის გადარქმევა «$3»-ად, რადგანაც ეს სათაური იმყოფება შავ სიაში: <code>$1</code>',
	'titleblacklist-forbidden-upload' => "'''ფაილი სახელით \"\$2\" არ შეიძლება იყოს ატვირთული''' <br />
იგი ექვემდებარება შემდეგ ჩანაწერს შავ სიაში: '''''\$1'''''",
	'titleblacklist-forbidden-new-account' => 'აკრძალულია სიტყვა «$2»-ის გამოყენება მომხმარებლის სახელად.
ეს სახელი ექვემდებარება შემდეგ ჩანაწერს შავი სიიდან: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|შემდეგი ხაზიа|შემდეგი ხაზები}} აკრძალულ სახელთა სიაში {{PLURAL:$1|არის არასწორი რეგულარული გამოთქმა|არის არასწორი რეგულარული გამოთქმები}}. გთხოვთ შეასწოროთ {{PLURAL:$1|ის|ისინი}} შენახვამდე:',
	'right-tboverride' => 'გვერდების სახელების შავი სიის იგნორირება',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'titleblacklist' => '# بۇل اتاۋلاردىڭ قارا ٴتىزىمى. جۇيەلى ايتىلىمدارعا (regex) سايكەس مىنداعى اتاۋلار جاراتىلمايدى.
ماندەمەلەر ٴۇشىن «#» نىشانىن قولدانىڭىز.',
	'titlewhitelist' => '# بۇل اتاۋلاردىڭ اق ٴتىزىمى. ماندەمەلەر ٴۇشىن «#» نىشانىن قولدانىڭىز',
	'titleblacklist-forbidden-edit' => '«$2» دەگەن اتاۋ جاراتۋى قۇلىپتالعان.  بۇل قارا ٴتىزىمنىڭ جازباسىنا سايكەس: <code>$1</code>',
	'titleblacklist-forbidden-move' => '«$2» دەگەن «$3» دەگەنگە جىلجىتىلمايدى, سەبەبى «$3» دەگەن اتاۋ جاراتۋى قۇلىپتالعان. بۇل قارا ٴتىزىمنىڭ جازباسىنا سايكەس: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '«$2» دەگەن فايل اتى جاراتۋى قۇلىپتالعان.  بۇل قارا ٴتىزىمنىڭ جازباسىنا سايكەس: <code>$1</code>',
	'titleblacklist-invalid' => 'اتاۋلاردىڭ قارا تىزىمىندەگى كەلەسى {{PLURAL:$1|جول|جولدار}} {{PLURAL:$1||}} جارامسىز; ساقتاۋ الدىندا {{PLURAL:$1|بۇنى|بۇلاردى}} دۇرىستاپ شىعىڭىز:',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic))
 * @author AlefZet
 */
$messages['kk-cyrl'] = array(
	'titleblacklist' => '# Бұл атаулардың қара тізімі. Жүйелі айтылымдарға (regex) сәйкес мындағы атаулар жаратылмайды.
Мәндемелер үшін «#» нышанын қолданыңыз.',
	'titlewhitelist' => '# Бұл атаулардың ақ тізімі. Мәндемелер үшін «#» нышанын қолданыңыз',
	'titleblacklist-forbidden-edit' => '«$2» деген атау жаратуы құлыпталған.  Бұл қара тізімнің жазбасына сәйкес: <code>$1</code>',
	'titleblacklist-forbidden-move' => '«$2» деген «$3» дегенге жылжытылмайды, себебі «$3» деген атау жаратуы құлыпталған. Бұл қара тізімнің жазбасына сәйкес: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '«$2» деген файл аты жаратуы құлыпталған.  Бұл қара тізімнің жазбасына сәйкес: <code>$1</code>',
	'titleblacklist-invalid' => 'Атаулардың қара тізіміндегі келесі {{PLURAL:$1|жол|жолдар}} {{PLURAL:$1||}} жарамсыз; сақтау алдында {{PLURAL:$1|бұны|бұларды}} дұрыстап шығыңыз:',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'titleblacklist' => '# Bul atawlardıñ qara tizimi. Jüýeli aýtılımdarğa (regex) säýkes mındağı atawlar jaratılmaýdı.
Mändemeler üşin «#» nışanın qoldanıñız.',
	'titlewhitelist' => '# Bul atawlardıñ aq tizimi. Mändemeler üşin «#» nışanın qoldanıñız',
	'titleblacklist-forbidden-edit' => '«$2» degen ataw jaratwı qulıptalğan.  Bul qara tizimniñ jazbasına säýkes: <code>$1</code>',
	'titleblacklist-forbidden-move' => '«$2» degen «$3» degenge jıljıtılmaýdı, sebebi «$3» degen ataw jaratwı qulıptalğan. Bul qara tizimniñ jazbasına säýkes: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '«$2» degen faýl atı jaratwı qulıptalğan.  Bul qara tizimniñ jazbasına säýkes: <code>$1</code>',
	'titleblacklist-invalid' => 'Atawlardıñ qara tizimindegi kelesi {{PLURAL:$1|jol|joldar}} {{PLURAL:$1||}} jaramsız; saqtaw aldında {{PLURAL:$1|bunı|bulardı}} durıstap şığıñız:',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'titleblacklist-desc' => '[[MediaWiki:Titleblacklist]], [[MediaWiki:Titlewhitelist]]를 통해서 특정 제목의 문서 생성을 막는 기능',
	'titleblacklist' => ' # 문서 이름 금지 목록을 적는 곳입니다. 정규 표현식과 일치하는 문서나 사용자명은 생성이 제한됩니다.
 # 규칙이 아닌 주석 내용에는 앞에 "#"을 붙여 주세요.
 # 기본적으로 규칙은 대소문자를 구별하지 않습니다.',
	'titlewhitelist' => ' # 생성 허용 규칙을 적는 곳입니다. 생성 금지 규칙에 포함되는 문서의 경우, 이 곳의 규칙에도 포함될 경우 생성이 가능해집니다. 규칙이 아닌 내용을 적을 때에는 앞에 "#"을 붙여 주세요.
 # 기본적으로 규칙은 대소문자를 구별하지 않습니다.',
	'titleblacklist-forbidden-edit' => '‘$2’ 문서는 생성 금지 목록에 포함되어 있습니다. 해당 생성 금지 조건은 <code>$1</code>입니다.',
	'titleblacklist-forbidden-move' => '‘$2’ 문서를 ‘$3’ 제목으로 이동할 수 없습니다. 문서 생성 금지 조건이 걸려 있습니다. 해당 금지 조건은 <code>$1</code>입니다.',
	'titleblacklist-forbidden-upload' => '‘$2’ 파일 이름을 만드는 것이 제한되어 있습니다.
파일 이름이 다음의 규칙에 해당됩니다: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => '‘$2’ 이름으로 계정을 만드는 것이 제한되어 있습니다.
계정 이름이 다음의 규칙에 해당됩니다: <code>$1</code>',
	'titleblacklist-invalid' => '제목 블랙리스트 목록에 잘못된 구문이 있습니다. 저장하기 전에 올바르게 수정해주세요.',
	'right-tboverride' => '문서 제목 블랙리스트 무시',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'titleblacklist-desc' => 'Määt et müjjelsch, bestemmpte neu Sigge un neu Metmaacher-Name övver en [[MediaWiki:Titleblacklist|„schwatze Leß“]] un en [[MediaWiki:Titlewhitelist|Leß met Ußnahme dofun]] ze verbeede.',
	'titleblacklist' => '# Dat hee eß en „schwatze Leß“ met verbodde Tittele för Sigge.
# Dä ier Enhallt sen <i lang="en">regular expressions</i>,
# wat do drop paß, kam_mer nit aanläje.
# Wam_mer et nit ömschtällt, es Jruß- un Kleinschrevv_ejaal.
# Donn „#“ aan der Aanfang fun en Reih, dann häß ene Kommentaa.',
	'titlewhitelist' => '# Dat hee eß en Leß met Ußnahme fun de „schwatze Leß“ met verbodde
# Tittele för Sigge. Dä ier Enhallt sen <i lang="en">regular expressions</i>,
# wat do drop paß, kam_mer aanläje.
# Wam_mer et nit ömschtällt, es Jruß- un Kleinschrevv_ejaal.
# Donn „#“ aan der Aanfang fun en Reih, dann häß ene Kommentaa.',
	'titleblacklist-forbidden-edit' => 'En Sigg met dämm Tittel „$2“ aanzelääje es verbodde per dämm Enndraach <code>$1</code> en de „schwazze Leß.“',
	'titleblacklist-forbidden-move' => 'Di Sigg met dämm Tittel „$2“ op dä Tittel „$3“ ömzenänne es verbodde per dämm Enndraach <code>$1</code> en de „schwazze Leß.“',
	'titleblacklist-forbidden-upload' => 'En Datei met dämm Tittel „$2“ huhzelade es verbodde per dämm Enndraach <code>$1</code> en de „schwazze Leß.“',
	'titleblacklist-forbidden-new-account' => 'Enne Metmaacher met dämm Name „$2“ aanzelääje es verbodde per dämm Enndraach <code>$1</code> en de „schwazze Leß.“',
	'titleblacklist-invalid' => '{{PLURAL:$1|De Reih unge stemmp nit un moß|De $1 Reije unge stimme nit un möße|Dat he sull}} för em Afspeichere eets en Odenung jebraat wäde:',
	'right-tboverride' => 'De Liss met verbodde Sigge-Name övverjonn',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'titleblacklist' => '# Hic est index titulorum prohibitorum. Tituli usoresque qui congruunt
# cum una ex expressionibus regularis sequentibus creari non possunt.
# Utere "#" pro commentariis.
# Litterae maiusculae ab litteris minusculis distingui non solent.',
	'titlewhitelist' => '# Hic est index titulorum permissorum. Utere "#" pro commentariis.
# Litterae maiusculae ab litteris minusculis distingui non solent.',
	'titleblacklist-forbidden-edit' => 'Pagina cum titulo "$2" creari non potest. Hic titulus congruit cum expressione regulari: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Pagina cum titulo "$2" non ad "$3" moveri potest, quia titulus "$3" prohibitus est ne pagina creetur. Hic titulus congruit cum expressione regulari: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Fasciculus cum titulo "$2" imponi non potest. Hic titulus congruit cum expressione regulari: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Ratio usoris "$2" creari non potest.
Hic titulus congruit cum expressione regulari: <code>$1</code>',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'titleblacklist-desc' => "Erlaabt den Administrateuren et d'Ulleeë vu Säiten a Benotzerkonte mat spezifischen Titelen iwwer eng [[MediaWiki:Titleblacklist|schwaarz Lëscht]] an eng [[MediaWiki:Titlewhitelist|wäiss Lëscht]] ze verbidden",
	'titleblacklist' => '# Dëst ass een Titel deen op enger schwaarzer Lëscht steet. Titelen a Benotzernimm op déi dës Ausdréck passe kann net ugeluecht ginn
# Benotzt "#" fir Bemierkungen
# Et gëtt tëschent groussen a klenge Buchstawen ënnerscheed',
	'titlewhitelist' => "# Dëst ass d'''Whitelist'' vun den Titelen. Benotzt \"#\" fir Bemierkungen.
# Et gëtt een Ënnerscheed tëschent groussen a klenge Buchstawe gemaach",
	'titleblacklist-forbidden-edit' => 'Den Titel "$2" dàerf net ugeluecht ginn.
En ass op der schwaarzer Lëscht wéint folgendem Begrëff: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" kann net op "$3" geréckelt ginn, well den Titel "$3" net däerf ugeluecht ginn.
En entsprécht dëser Rubrik vun der schwaarzr Lëscht: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'De Fichiersnumm "$2" kann net benotzt ginn.
Hien ass identesch mat dësem Numm vun der schwaarzer Lëscht (black list): <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'De Benotzermumm "$2" gouf gespaart fir benotzt ze ginn.
En ass esou op der \'\'schwaarzer Lëscht\'\': <code>$1</code>',
	'titleblacklist-invalid' => 'Dës {{PLURAL:$1|Linn|Linnen}} op der schwaarzer Lëscht vun den {{PLURAL:$1|Titelen ass|Titele sinn}} net valabel;
verbessert se virum späicheren:',
	'right-tboverride' => "Ignoréiert d'schwaarz Lëscht vun den Titelen",
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'titleblacklist-desc' => "Veurkömp het aanmake van pagina's èn gebroekers waenger 'ne [[MediaWiki:Titleblacklist|zwarte]] en [[MediaWiki:Titlewhitelist|witte]] lies.",
	'titleblacklist' => '# Dit is \'ne zjwarte lies veur paginaname. Paginaname en gebroekers die voldoon aan \'ne regex kinne neet aangemaak waere.
# Gebroek "#" veur opmerkinge.
# Dit is autematis huidlettergeveulig',
	'titlewhitelist' => '# Dit is \'ne witte lies veur paginaname. Gebroek "#" veur opmerkinge.
# Dit is autematis huidlettergeveulig',
	'titleblacklist-forbidden-edit' => 'Een pagina met de naam "$2" kan niet aangemaakt worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" kan niet hernoemd worden naar "$3", omdat pagina\'s met de naam "$3" niet aangemaakt kunnen worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Het bestand "$2" kan niet toegevoegd worden. Deze bestandsnaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'De gebroekersnaam "$2" kan neet aangemaak waere ómdet \'t voldeit aan de volgende beperking op de zwarte lies: <code>$1</code>',
	'titleblacklist-invalid' => 'De volgende {{PLURAL:$1|regel|regels}} in de zwarte lijst veur paginaname {{PLURAL:$1|is|zijn}} ongeldig. Verbeter die {{PLURAL:$1|regel|regels}} asjeblieft veurdat ge de lijst opslaat:',
	'right-tboverride' => 'De zwarte lies veur pazjenaname negere',
);

/** Lithuanian (Lietuvių)
 * @author Homo
 * @author Matasg
 */
$messages['lt'] = array(
	'titleblacklist-desc' => 'Leidžia administratoriams uždrausti kurti puslapius ir vartotojų sąskaitas pagal [[MediaWiki:Titleblacklist|juodąjį sąrašą]] ir [[MediaWiki:Titlewhitelist|baltąjį sąrašą]]',
	'titleblacklist' => '# Tai pavadinimų juodasis sąrašas. Pavadinimai ir vartotojai, kurie atitinka įrašus čia, negali būti sukuriami. 
# Naudokite "#" komentarams. 
# Pagal nutylėjimą nejautrus raidžių dydžiui',
	'titlewhitelist' => '# Tai pavadinimų baltasis sąrašas. Naudokite "#" komentarams. 
# Pagal nutylėjimą nejautrus raidžių dydžiui',
	'titleblacklist-forbidden-edit' => 'Pavadinimą "$2" buvo uždrausta sukurti.
Jis atitinką šį juodojo sąrašo įrašą: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" negali būti perkeltas į "$3", nes pavadinimą "$3" buvo uždrausta sukurti.
Jis atitinką šį juodojo sąrašo įrašą: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Failą "$2" buvo uždrausta sukurti.
Jis atitinką šį juodojo sąrašo įrašą: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Naudotojo vardą "$2" buvo uždrausta sukurti.
Jis atitinką šį juodojo sąrašo įrašą: <code>$1</code>',
	'titleblacklist-invalid' => 'Žemiau {{PLURAL:$1|esanti linija|esančios linijos}} juodajame sąraše {{PLURAL:$1|yra|yra}} netinkama;
prašome {{PLURAL:$1|ją|jas}} pataisyti prieš išsaugant:',
	'right-tboverride' => 'Nepaisyti juodojo sąrašo',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'titleblacklist-desc' => 'Им овозможува на администраторите да забранат создавање на страници и кориснички сметки со помош на [[MediaWiki:Titleblacklist|црна листа]] и [[MediaWiki:Titlewhitelist|бела листа]]',
	'titleblacklist' => '# Ова е црна листа на наслови. Насловите и корисниците кои се совпаѓаат со регуларните изрази на листата не можат да се создадат.
# За коментари користете го знакот „#“.
# Ова разликува мали и големи букви по основно',
	'titlewhitelist' => '# Ова е бела листа на наслови. За коментари користете го знакот „#“.  
# Ова разликува мали и големи букви по основно',
	'titleblacklist-forbidden-edit' => 'Насловот "$2" е забранет за создавање.
Се совпаѓа со следната ставка на црната листа: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" не може да се премести на "$3", бидејќи насловот "$3" е забранет за создавање.
Се совпаѓа со следнава ставка на црната листа: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Податотеката по име "$2" е забранета за создавање.
Се совпаѓа со следнава ставка на црната листа: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Корисничкото име "$2" е забрането за создавање.
Се совпаѓа со следнава ставка на црната листа: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Следниов ред|Следниве редови}} во црнната листа на наслови {{PLURAL:$1|е|се}} неважечки;
поправете {{PLURAL:$1|го|ги}} пред да зачувате:',
	'right-tboverride' => 'Игнорирање на црната листа на наслови',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'titleblacklist-desc' => '[[MediaWiki:Titleblacklist]], [[MediaWiki:Titlewhitelist]] എന്നിവയിൽ കൊടുത്തിരിക്കുന്ന അംഗത്വങ്ങളും താളുകളും സൃഷ്ടിക്കുന്നത് തടയാൻ  കാര്യനിർവാഹകരെ അനുവദിക്കുന്നു.',
	'titleblacklist' => '# ഇതു തലക്കെട്ടിന്റെ കരിമ്പട്ടികയാണ്‌. ഈ പട്ടികയിലുള്ള ഇനവുമായി  യോജിക്കുന്ന ലേഖനങ്ങളും ഉപയോക്തൃനാമങ്ങളും സൃഷ്ടിക്കാനാവില്ല. 
# അഭിപ്രായത്തിനു "#" ഉപയോഗിക്കുക.
# ഇതു സ്വതവേ കേസ് സെൻസിറ്റീവ് ആണ്.',
	'titlewhitelist' => '# ഇത് തലക്കെട്ടിന്റെ ശുദ്ധപട്ടികയാണ്. കുറിപ്പിടാനായി "#" ഉപയോഗിക്കുക.  
# ഇത് സ്വതവേ കേസ് സെൻസിറ്റീവ് ആണ്',
	'titleblacklist-forbidden-edit' => '"$2" എന്ന തലക്കെട്ട് സൃഷ്ടിക്കുന്നതു നിരോധിച്ചിട്ടുള്ളതാണ്‌. ആ തലക്കെട്ട് താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന കരിമ്പട്ടിക ഇനവുമായി യോജിക്കുന്നു: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$3" എന്ന തലക്കെട്ട് സൃഷ്ടിക്കുന്നതു നിരോധിച്ചിട്ടുള്ളതിനാല്‍, "$2" എന്ന താള്‍ "$3" എന്ന തലക്കെട്ടിലേക്കു മാറ്റാന്‍ പറ്റില്ല. ആ തലക്കെട്ട് താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന കരിമ്പട്ടിക ഇനവുമായി യോജിക്കുന്നു: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" എന്ന നാമം പ്രമാണത്തിനു കൊടുക്കുന്നത് നിരോധിച്ചിട്ടുള്ളതാണ്‌.
ആ നാമം താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന കരിമ്പട്ടിക ഇനവുമായി യോജിക്കുന്നു: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'ഉപയോക്തൃനാമം "$2" സൃഷ്ടിക്കുന്നതിൽ നിന്നും നിരോധിക്കപ്പെട്ടതാണ്.
കരിമ്പട്ടികയിൽ കൊടുത്തിരിക്കുന്ന ഇനിപ്പറയുന്നതുമായി അതു ഒത്തുപോകുന്നു: <code>$1</code>',
	'titleblacklist-invalid' => 'കരിമ്പട്ടികയിലെ താഴെ കൊടുത്തിരിക്കുന്ന  {{PLURAL:$1|വരി|വരികൾ}} അസാധുവാണ്.
ദയവായി {{PLURAL:$1|അത്|അവ}} ശരിയാക്കിയ ശേഷം സേവ് ചെയ്യുക:',
	'right-tboverride' => 'തലക്കെട്ടിന്റെ കരിമ്പട്ടികയെ അതിലംഘിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'titleblacklist-desc' => '[[MediaWiki:Titleblacklist]] व [[MediaWiki:Titlewhitelist]] मध्ये दिलेल्या शीर्षकांचे लेख बनविण्यापासून रोखा',
	'titleblacklist' => '# ही ब्लॉक केलेल्या शीर्षकांची यादी आहे. या यादीत असलेल्या शीर्षकांचे लेख लिहिता येणार नाहीत.
# शेरा देण्यासाठी "#" वापरा.',
	'titlewhitelist' => '# ही वापरू शकत असलेल्या शीर्षकांची यादी आहे. शेरा देण्यासाठी "#" वापरा',
	'titleblacklist-forbidden-edit' => '"$2" या शीर्षकाचा लेख बनवू शकत नाही. खाली ब्लॉक केलेल्या शीर्षकांच्या यादीतील नोंद आहे:
<code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" चे "$3" ला स्थानांतरण होऊ शकत नाही, कारण "$3" हे ब्लॉक केलेल्या शीर्षकांच्या यादीत आहे. खाली ब्लॉक केलेल्या शीर्षकांच्या यादीतील नोंद आहे: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" या शीर्षकाची संचिका बनवू शकत नाही. खाली ब्लॉक केलेल्या शीर्षकांच्या यादीतील नोंद आहे:
<code>$1</code>',
	'titleblacklist-invalid' => 'शीर्षक ब्लॉक यादीतील खालील {{PLURAL:$1|ओळ चुकीची आहे|ओळी चुकीच्या आहेत}}; कृपया जतन करण्यापूर्वी {{PLURAL:$1|ती|त्या}} दुरुस्त करा:',
	'right-tboverride' => 'शीर्षक ब्लॅकयादी कडे दुर्लक्ष करा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Izzudin
 */
$messages['ms'] = array(
	'titleblacklist-desc' => 'Membolehkan pentadbir mengawal penciptaan laman dan pengguna tertentu menggunakan [[MediaWiki:Titleblacklist|senarai hitam]] dan [[MediaWiki:Titlewhitelist|senarai putih]]',
	'titleblacklist' => '# Ini ialah senarai hitam tajuk. Tajuk atau pengguna yang sepadan dengan mana-mana ungkapan nalar di sini akan disekat daripada dicipta.
# Gunakan "#" untuk komen.
# Secara lalai ini tidak sensitif kepada atur huruf',
	'titlewhitelist' => '# This is a title whitelist. Use "#" for comments.  
# This is case insensitive by default
# Secara lalai ini tidak sensitif kepada atur huruf',
	'titleblacklist-forbidden-edit' => 'Tajuk "$2" telah diharamkan.
Tajuk tersebut sepadan dengan entri senarai hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" tidak boleh dipindahkan ke "$3" kerana tajuk "$3" telah diharamkan.
Tajuk tersebut sepadan dengan entri senarai hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Nama fail "$2" telah diharamkan.
Nama tersebut sepadan dengan entri senarai hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Nama pengguna "$2" telah diharamkan kerana sepadan dengan entri senarai hitam berikut: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Baris|Baris-baris}} berikut adalah tidak sah. Sila betulkannya sebelum menyimpan:',
	'right-tboverride' => 'Mengatasi senarai hitam tajuk',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'titleblacklist' => '# Inīn cateh ahcualli tōcāitl.  Ahmo huelīti tlachīhuāz tlatequitiltilīlli auh tōcāitl monēz nicān oppa.
# Xictequitiltia "#" ic tlahtoa.',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'titleblacklist-desc' => 'Verlöövt Administraters, dat Opstellen vun nich wünschte Sieden- un Brukernaams över en [[MediaWiki:Titleblacklist|Swartlist]] un [[MediaWiki:Titlewhitelist|Wittlist]] to verbeden',
	'titleblacklist' => '# Dit is de Swartlist vun Sieden- un Brukernaams, de nich opstellt warrn schöölt. Naams, op de disse regulären Utdrück todrepen doot, köönt nich opstellt warrn.
# Bruuk „#“ för Kommentaren.
# De List maakt keen Ünnerscheed bi grote un lütte Bookstaven',
	'titlewhitelist' => '# Dit is en Wittlist mit Utnahmen vun de Swartlist vun Siedennaams, de nich opstellt warrn schöölt. Bruuk „#“ för Kommentaren
# De List maakt keen Ünnerscheed bi grote un lütte Bookstaven',
	'titleblacklist-forbidden-edit' => 'De Siedennaam „$2“ is för dat nee Opstellen nich verlöövt.
Dat liggt an dissen Indrag in de Swartlist vun nich wünschte Siedennaams: <code>$1</code>',
	'titleblacklist-forbidden-move' => '„$2“ kann nich na „$3“ schaven warrn, de Siedennaam „$3“ is nich verlöövt.
Dat liggt an dissen Indrag in de Swartlist vun nich wünschte Siedennaams: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'De Dateinaam „$2“ is nich verlöövt.
Dat liggt an dissen Indrag in de Swartlist vun nich wünschte Dateinaams: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'De Brukernaam „$2“ is för dat nee Anmellen nich verlöövt.
Dat liggt an dissen Indrag in de Swartlist vun nich wünschte Brukernaams: <code>$1</code>',
	'titleblacklist-invalid' => 'Disse {{PLURAL:$1|Reeg|Regen}} in de Sperrlist {{PLURAL:$1|is|sünd}} ungüllig; verbeter {{PLURAL:$1|ehr|jem}}, ehrdat du spiekerst:',
	'right-tboverride' => 'De swarte List för Siedennaams ümgahn',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'titleblacklist-desc' => "Voorkomt het aanmaken van pagina's en gebruikers via een [[MediaWiki:Titleblacklist|zwarte lijst]] en een [[MediaWiki:Titlewhitelist|witte lijst]]",
	'titleblacklist' => '# Dit is een zwarte lijst voor paginanamen. Paginanamen en gebruikers die voldoen aan een reguliere expressie op deze paina kunnen niet aangemaakt worden.
# Gebruik "#" voor opmerkingen.
# Regels in de zwarte lijst zijn niet hoofdlettergevoelig.',
	'titlewhitelist' => '# Dit is een witte lijst voor paginanamen. Gebruik "#" voor opmerkingen.
# Regels in de witte lijst zijn niet hoofdlettergevoelig.',
	'titleblacklist-forbidden-edit' => 'Een pagina met de naam "$2" kan niet aangemaakt worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" kan niet hernoemd worden naar "$3", omdat pagina\'s met de naam "$3" niet aangemaakt kunnen worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Het bestand "$2" kan niet toegevoegd worden. Deze bestandsnaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'De gebruikersnaam "$2" kan niet aangemaakt worden omdat het voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-invalid' => 'De volgende {{PLURAL:$1|regel|regels}} in de zwarte lijst voor paginanamen {{PLURAL:$1|is|zijn}} ongeldig. Verbeter die {{PLURAL:$1|regel|regels}} alstublieft voordat u de lijst opslaat:',
	'right-tboverride' => 'De zwarte lijst voor paginanamen negeren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 */
$messages['nn'] = array(
	'titleblacklist-desc' => 'Gjev høve til å hindre at sider og brukarkontoar med visse titlar vert oppretta, ved å nytte [[MediaWiki:Titleblacklist]] og [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Dette er ei svartlisting for titlar. Titlar og brukernamn som passar med regulære uttrykk her kan ikkje opprettast.
# Bruk «#» for kommentarar.
# Det vert som standard ikkje skilt mellom små og store bokstavar',
	'titlewhitelist' => '# Dette er ei kvitelisting for titlar. Bruk «#» for kommentarar.
# Det vert som standard ikkje skilt mellom små og store bokstavar',
	'titleblacklist-forbidden-edit' => 'Tittelen «$2» er stengd for oppretting. Han er blokkert av følgjande svartelistingselement: <code>$1</code>',
	'titleblacklist-forbidden-move' => '«$2» kan ikkje flyttast til «$3» fordi tittelen «$3» er stengd for oppretting. Han svarar til følgjande element i svartelistinga: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Filnamnet «$2» er blokkert for oppretting. Det svarar til følgjande svartelisteelement: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Brukarnamnet «$2» kan ikkje opprettast. 
Det svarar til følgjande svartelisteelement: <code>$1</code>',
	'titleblacklist-invalid' => 'Følgjande {{PLURAL:$1|linje|linjer}} i tittelsvartelista er {{PLURAL:$1|ugyldig|ugyldige}}; ver venleg å rette {{PLURAL:$1|ho|dei}} før du lagrar:',
	'right-tboverride' => 'Overkøyre tittelsvartelista',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'titleblacklist-desc' => 'Gir muligheten til å forhindre at sider og brukerkontoer med visse titler opprettes, ved å bruke [[MediaWiki:Titleblacklist]] og [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Dette er en svartlisting for titler. Titler og brukernavn som passer med regulære uttrykk her kan ikke opprettes.
# Bruk «#» for kommentarer.
# Det skilles ikke mellom store og små bokstaver som standard',
	'titlewhitelist' => '# Dette er en hvitelisting for titler. Bruk «#» for kommentarer.
# Det skilles ikke mellom store og små bokstaver som standard',
	'titleblacklist-forbidden-edit' => 'Tittelen «$2» er stengt for oppretting. Den blokkeres av følgende svartelistingselement: <code>$1</code>',
	'titleblacklist-forbidden-move' => '«$2» kan ikke flyttes til «$3» fordi tittelen «$3» har blitt stengt for oppretting. Den tilsvarer følgende element i svartelistinga: <code>$1</code<',
	'titleblacklist-forbidden-upload' => 'Filnavnet «$2» er blokkert for oppretting. Den tilsvarer følgende svartelisteelement: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Brukernavnet «$2» kan ikke opprettes.
Det tilsvarer følgende svartelisteelement: <code>$1</code>',
	'titleblacklist-invalid' => 'Følgende {{PLURAL:$1|linje|linjer}} i tittelsvartelista er {{PLURAL:$1|ugyldig|ugyldige}}; vennligst korriger {{PLURAL:$1|den|dem}} før du lagrer:',
	'right-tboverride' => 'Overkjøre tittelsvartelisten',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'titleblacklist-desc' => "Permet als administrators d'interdire la creacion de paginas e de comptes d'utilizaires en foncion d'una [[MediaWiki:Titleblacklist|lista negra]] e d'una [[MediaWiki:Titlewhitelist|lista blanca]]",
	'titleblacklist' => '# Aquò es un títol mes en lista negra. Los títols e los utilizaires que correspondon aicí a una expression regulara pòdon pas èsser creats.
# Utilizatz "#" per escriure los comentaris.
# Las entradas son pas sensiblas a la cassa per defaut.',
	'titlewhitelist' => '# Aquò es la lista blanca dels títols. Utilizatz « # » per inserir de comentaris.
# Las entradas son pas sensiblas a la cassa per defaut.',
	'titleblacklist-forbidden-edit' => "La pagina intitolada « $2 » pòt pas èsser creada. Dins la lista negra, correspond a l'expression racionala : <code>$1</code>",
	'titleblacklist-forbidden-move' => 'La page intitolada "$2" pòt pas èsser renomenada "$3". Dins la lista negra, correspond a l\'expression racionala : <code>$1</code>',
	'titleblacklist-forbidden-upload' => "'''Un fichièr nomenat \"\$2\" pòt pas èsser telecargat.''' <br /> Dins la lista negra, correspond a l'expression racionala :  <code>\$1</code>",
	'titleblacklist-forbidden-new-account' => 'Lo nom d’utilizaire « $2 » es estat interdich a la creacion.
Correspond a l’entrada seguenta de la lista negra : <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|La linha seguenta|Las linhas seguentas}} dins la lista negra dels títols {{PLURAL:$1|es invalida|son invalidas}} : sètz convidat a {{PLURAL:$1|la|las}} corregir abans de salvar.',
	'right-tboverride' => 'Ignorar la lista negra dels títols',
);

/** Polish (Polski)
 * @author Beau
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'titleblacklist-desc' => 'Pozwala na blokowanie tworzenia stron i kont użytkowników o określonych nazwach wykorzystując [[MediaWiki:Titleblacklist|czarną]] oraz [[MediaWiki:Titlewhitelist|białą]] listę',
	'titleblacklist' => '# Lista zabronionych nazw. Strony i konta o nazwach odpowiadających poniższym wyrażeniom regularnym, nie będą mogły zostać utworzone.
# Użyj znaku „#”, by utworzyć komentarz.
# Domyślnie we wpisach ma znaczenie wielkość znaków.',
	'titlewhitelist' => '# To jest lista dopuszczalnych nazw artykułów. Użyj znaku „#” by utworzyć komentarz.
# Domyślnie we wpisach ma znaczenie wielkość znaków.',
	'titleblacklist-forbidden-edit' => 'Utworzenie strony o nazwie „$2” nie jest możliwe.  
Nazwa ta pasuje do wpisu z czarnej listy: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Zmiana nazwy z „$2” na „$3” nie jest możliwa, ponieważ nie można utworzyć strony o nazwie „$3”.
Nazwa ta pasuje do wpisu z czarnej listy: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Utworzenie pliku o nazwie „$2” nie jest możliwe. 
Nazwa ta pasuje do wpisu z czarnej listy: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Utworzenie konta o nazwie „$2” nie jest możliwe.
Nazwa ta pasuje do wpisu z czarnej listy: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Następująca linia|Następujące linie}} na liście zabronionych tytułów stron {{PLURAL:$1|jest nieprawidłowa|są nieprawidłowe}}. Popraw {{PLURAL:$1|ją|je}} przed zapisaniem:',
	'right-tboverride' => 'Brak ograniczeń czarnej listy zabronionych tytułów stron',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'titleblacklist-desc' => "A përmëtt a j'aministrador ëd vieté la creassion ëd pàgine e ëd cont për na [[MediaWiki:Titleblacklist|blacklist]] e na [[MediaWiki:Titlewhitelist|whitelist]]",
	'titleblacklist' => '# Costa sì a l\'é na blacklist dij tìtoj. Tìtoj e stranòm che a corispondo a n\'espression regolar sì a peulo pa esse creà.
# Dòvra "$" për coment.
# Cost sì a l\'é pa case sensitive për default',
	'titlewhitelist' => '# Costa a l\'é na whitelist ëd tìtoj. Dòvra "$" për coment.
# Sòn sì a l\'é pa case sensitive për default',
	'titleblacklist-forbidden-edit' => 'Ël tìtol "$2" a l\'é stàit vietà.
A corispond a costa intrada dla blacklist: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" a peul pa esse tramudà a "$3", përchè ël tìtol "$3" a l\'é stàit vietà.
A corispond a costa intrada dla blacklist: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Ël nòm dël file "$2" a l\'é stàit vietà.
A corispond a costa intrada dla blacklist: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Lë stranòm "$2" a l\'é stàit vietà.
A corispond a costa intrada dla blacklist: <code>$1</code>',
	'titleblacklist-invalid' => "{{PLURAL:$1|La linia|Le linie}} sota ant la blacklist dij tìtoj {{PLURAL:$1|a l'é pa bon-a|a son pa bon-e}};
për piasì {{PLURAL:$1|coregg-la|coregg-je}} prima ëd salvé:",
	'right-tboverride' => 'Sàuta la blacklist dij tìtoj',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'titleblacklist-desc' => 'Permite a proibição da criação de páginas e contas de utilizadores com títulos específicos através de uma [[MediaWiki:Titleblacklist|lista negra]] e uma [[MediaWiki:Titlewhitelist|lista de exceções]]',
	'titleblacklist' => '# Esta é uma lista negra de títulos. Títulos de páginas e nomes de utilizadores que sejam filtrados por uma expressão regular desta lista não poderão ser criados.
# Use "#" para comentários.
# Por omissão, esta lista ignora diferenças entre maiúsculas e minúsculas',
	'titlewhitelist' => '# Esta é uma lista branca de títulos. Utilize "#" para fazer comentários
# Esta lista ignora maiúsculas e minúsculas por padrão',
	'titleblacklist-forbidden-edit' => 'O título "$2" foi impedido de ser criado. Ele se encaixa na seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" não pode ser movida para "$3" já que "$3" é um título impedido de ser criado. Se encaixa na seguinte entrada da lista-negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'O ficheiro "$2" foi impedido de ser criado. Ele se encaixa na seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'O nome de utilizador "$2" foi banido da criação de utilizadores.
O nome corresponde à seguinte entrada na lista negra: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|A seguinte linha|As seguintes linhas}} da lista negra {{PLURAL:$1|é inválida|são inválidas}}. Por favor, {{PLURAL:$1|corrija-a|corrija-as}} antes de gravar:',
	'right-tboverride' => 'Sobrepor a lista negra de títulos',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'titleblacklist-desc' => 'Permite a proibição da criação de páginas e contas de utilizadores com títulos específicos através de uma [[MediaWiki:Titleblacklist|lista negra]] e uma [[MediaWiki:Titlewhitelist|lista de exceções]]',
	'titleblacklist' => '# Esta é uma lista negra de títulos. Títulos de páginas e nomes de usuários que sejam filtrados por uma expressão regular desta lista não poderão ser criados.
# Utilize "#" para fazer comentários.
# Esta lista não é sensível á capitalização por padrão',
	'titlewhitelist' => '# Esta é uma lista branca de títulos. Utilize "#" para fazer comentários
# Esta lista não é sensível a capitalização por padrão',
	'titleblacklist-forbidden-edit' => 'O título "$2" foi impedido de ser criado. Ele se encaixa na seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" não pode ser movida para "$3" já que "$3" é um título impedido de ser criado. Se encaixa na seguinte entrada da lista-negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'O arquivo "$2" foi impedido de ser criado. Ele se encaixa na seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'O nome de utilizador "$2" foi banido da criação de utilizadores.
O nome corresponde à seguinte entrada na lista negra: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|A seguinte linha|As seguintes linhas}} da lista negra {{PLURAL:$1|é inválida|são inválidas}}. Por gentileza, {{PLURAL:$1|corrija-a|corrija-as}} antes de salvar:',
	'right-tboverride' => 'Sobrepor a lista negra de títulos',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'right-tboverride' => 'Înlocuiţi titlul listei negre',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'titleblacklist-desc' => "Permette a l'amministrature de vietà ccrejaziune de le pàggene e le cunde utinde pe 'na [[MediaWiki:Titleblacklist|lista gnore]] e [[MediaWiki:Titlewhitelist|lista vianghe]]",
	'titleblacklist' => '# Stu titele jè in lista gnore. Le titele e l\'utinde ca se ponne comborndà cu le espressiune regolare aqquà non ge ponne essere ccrejate.
# Ause "#" pe le commende.
# Quiste jè sensibbele a le maiuscole e le minuscole de partenze',
	'titlewhitelist' => '# Stu titele jè in lista vianghe.
# Ause "#" pe le commende.
# Quiste jè sensibbele a le maiuscole e le minuscole de partenze',
	'titleblacklist-forbidden-edit' => '\'U titele "$2" ha state mise fore da \'a ccrejazione.<br />
Jidde se combronde cu le seguende vosce d\'a lista gnore: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" non ge pò essere sustate sus a "$3", purcé \'u titele "$3" ha state escluse da \'a ccreiazione.<br />
Jidde se combronde cu le seguende vosce d\'a lista gnore: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '\'U nome d\'u file "$2" ha state escluse da \'a ccreiazione.<br />
Jidde se combronde cu le vosce d\'a lista gnore: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => '\'U nome de l\'utende "$2" ha state escluse da \'a ccreiazione.<br />
Jidde se combronde cu le vosce d\'a lista gnore: <code>$1</code>',
	'titleblacklist-invalid' => "{{PLURAL:$1|'A seguenda linèe|Le seguende linèe}} jndr'à lista gnore de le titele {{PLURAL:$1|jè|sonde}} invalide;
pe piacere corregge {{PLURAL:$1|jedde|lore}} apprime de reggistrà:",
	'right-tboverride' => "Sovrasrive 'a lista gnore de le titele",
);

/** Russian (Русский)
 * @author AlexSm
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'titleblacklist-desc' => 'Позволяет администраторам запретить создание страниц и учётных записей с помощью [[MediaWiki:Titleblacklist|чёрного]] и [[MediaWiki:Titlewhitelist|белого]] списков.',
	'titleblacklist' => '# Это список запрещённыx названий. Страницы и учётные записи, соответствующие указанным регулярным выражениям, не могут быть созданы.
# Используйте «#» для комментариев.
# по умолчанию не чувствительности к регистру',
	'titlewhitelist' => '# Это «белый список» названий. Для комментариев используйте «#»
# По умолчанию не чувствительности к регистру символов',
	'titleblacklist-forbidden-edit' => "
<div align=\"center\" style=\"border: 1px solid #f88; padding: 0.5em; margin-bottom: 3px; font-size: 95%; width: auto;\">
'''Страница с названием \"\$2\" не может быть создана''' <br />
Она попадает под следующую запись списка запрещенных названий: '''''\$1'''''
</div>",
	'titleblacklist-forbidden-move' => 'Невозможно переименовать страницу «$2» в «$3», так как новое название запрещено следующей записью в чёрном списке: <code>$1</code>',
	'titleblacklist-forbidden-upload' => "
'''Файл с названием \"\$2\" не может быть загружен''' <br />
Он попадает под следующую запись списка запрещенных названий: '''''\$1'''''",
	'titleblacklist-forbidden-new-account' => 'Запрещено использовать имя участника «$2».
Имя соответствует следующей записи из чёрного списка: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Следующая строка|Следующие строки}} в списке запрещённых названий {{PLURAL:$1|не является правильным регулярным выражением|не являются правильными регулярными выражениями}}. Пожалуйста, исправьте {{PLURAL:$1|её|их}} перед сохранением:',
	'right-tboverride' => 'игнорирование чёрного списка имён страниц',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'titleblacklist-desc' => '[[MediaWiki:Titleblacklist|Хара]] уонна [[MediaWiki:Titlewhitelist|Үрүҥ испииһэктэри]] туһанан сирэйдэри айары уонна саҥа дьону бэлиэтиири боборго аналлаах',
	'titleblacklist' => '# Бу бобуллубут ааттар "хара" испииһэктэрэ. Испииһэккэ киирбит ханнык баҕарар ыстатыйа оҥоһуллар кыаҕа суох.
# Быһаарыыны суруйарга "#" бэлиэни туһан.
# Эбии этиллибэтэҕинэ бэлиэ улахана-кырата оруолу оонньообот',
	'titlewhitelist' => '# Бу ааттар «үрүҥ испииһэктэрэ». Ырытарга «#» бэлиэни туһаныҥ.
# Эбии этиллибэтэҕинэ бэлиэ улахана-кырата оруолу оонньообот',
	'titleblacklist-forbidden-edit' => "<div align=\"center\" style=\"border: 1px solid #f88; padding: 0.5em; margin-bottom: 3px; font-size: 95%; width: auto;\">
'''Маннык ааттаах сирэй \"\$2\" кыайан оҥоһуллубат''' <br />
Бобуллубут ааттар испииһэктэригэр киирэр: '''''\$1'''''
</div>",
	'titleblacklist-forbidden-move' => "<span class=\"error\">
'''Маннык ааттаах сирэй \"\$2\" маннык ааттанар \"\$3\" кыаҕа суох, тоҕо диэтэххэ \"\$3\" оҥоһуллара бобуллубут''' <br />
Бобуллубут ааттар испииһэктэригэр киирэр: '''''\$1'''''
</span>",
	'titleblacklist-forbidden-upload' => "'''Маннык ааттаах билэ \"\$2\" кыстанар (киллэриллэр) кыаҕа суох''' <br />
Бобуллубут ааттар испииһэктэригэр киирэр: '''''\$1'''''",
	'titleblacklist-forbidden-new-account' => '«$2» ааты туттар сатаммат. Аат хара тиһик бу суругар сөп түбэһэр: $1',
	'titleblacklist-invalid' => 'Бобуллубут ааттар тиһиктэрин бу {{PLURAL:$1|строката|строкаалара}} {{PLURAL:$1|сыыһалаах|сыыһалаахтар}}. Бука диэн ону көннөр:',
	'right-tboverride' => 'Сирэйдэр ааттарын "хара тиһигин" туттума',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'titleblacklist-desc' => 'Umožňuje zakázať tvorbu stránok a používateľských účtov s určenými názvami na základe [[MediaWiki:Titleblacklist|čiernej listiny názvov]] a [[MediaWiki:Titlewhitelist|bielej listiny názvov]]',
	'titleblacklist' => '# Toto je čierna listina názvov stránok. Názvy stránok a účtov, ktoré zodpovedajú tu uvedenému regulárnemu výrazu nebude možné vytvoriť.
# Komentáre začínajú znakom „#“.
# Štandardne nezáleží na veľkosti písmen',
	'titlewhitelist' => '# Toto je biela listina názvov stránok. Riadky komentárov začínajú znakom „#“
# Štandardne nezáleží na veľkosti písmen',
	'titleblacklist-forbidden-edit' => 'Vytvorenie stránky z názovom „$2“ bolo zakázané. Zodpovedá tejto položke čiernej listiny: <code>$1</code>',
	'titleblacklist-forbidden-move' => '„$2“ nie je možné presunúť na „$3“, pretože vytvorenie stránky z názovom „$3“ bolo zakázané. Zodpovedá tejto položke čiernej listiny: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Bolo zakázané vytvorenie súboru s názvom „$2“. Zodpovedá tejto položke čiernej listiny: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Bolo zakázané vytvorenie používateľského mena „$2”.
Zodpovedá nasledovnej položke čiernej listiny: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Nasledovný riadok|Nasledovné riadky}} čiernej listiny názvov stránok {{PLURAL:$1|je neplatný|sú neplatné}} a je potrebné {{PLURAL:$1|ho|ich}} opraviť pred uložením stránky:',
	'right-tboverride' => 'Prekonať čiernu listinu názvov',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Millosh
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'titleblacklist-desc' => 'Допушта забрану стварања страна с одређеним насловима: [[MediaWiki:Titleblacklist|црна листа]] и [[MediaWiki:Titlewhitelist|бела листа]].',
	'titleblacklist' => '# Ово је наслов црног списка. Наслови који садрже регуларни израз из овог списка не могу бити направљени.
# Користи "#" за коментаре.',
	'titlewhitelist' => '# Ово је бели списак наслова. Користи "#" за коментаре.',
	'right-tboverride' => 'Преписује црни списак наслова.',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'titleblacklist-desc' => 'Dopušta zabranu stvaranja strana s određenim naslovima: [[MediaWiki:Titleblacklist|crna lista]] i [[MediaWiki:Titlewhitelist|bela lista]].',
	'right-tboverride' => 'Prepisuje crni spisak naslova.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'titleblacklist-desc' => 'Moaket dät Administratore muugelk, dät Moakjen fon nit wonskede Sieden- un Benutsernoomen tou ferhinnerjen: [[MediaWiki:Titleblacklist]] un [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Dit is ne Swotte Lieste.
# Älke Siede- un Benutsernoome, ap dän do foulgjende reguläre Uutdrukke touträffe, kon nit moaked wäide.
# Text bääte ne Ruute „#“ wäd as Kommentoar betrachted.
# Standoardmäitich wäd nit twiske Groot- un Littikschrieuwenge unnerschat.',
	'titlewhitelist' => '# Dit is ju Uutnoamelieste fon ju Swotte Lieste fon nit wonskede Siedennoomen. Benuts „#“ foar Kommentoare',
	'titleblacklist-forbidden-edit' => "'''Ne Siede mäd dän Tittel „$2“ kon nit moaked wäide.''' <br />
Die Tittel kollidiert mäd dissen Speerbegriep: '''''$1'''''",
	'titleblacklist-forbidden-move' => "'''Ju Siede „$2“ kon nit ätter „$3“ ferschäuwen wäide.''' <br />
Die Tittel kollidiert mäd dissen Speerbegriep: '''''$1'''''",
	'titleblacklist-forbidden-upload' => "'''Ne Doatäi mäd dän Noome „$2“ kon nit hoochleeden wäide.''' <br />
Die Tittel kollidiert mäd dissen Speerbegriep: <code>$1</code>",
	'titleblacklist-forbidden-new-account' => 'Ju Registrierenge fon dän Benutsernoome „$2“ is nit wonsked.
Ju foulgjende Iendraach uut ju Lieste fon nit wonskede Benutsernoomen fierde tou Oulienenge: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Ju foulgjende Riege|Do foulgjende Riegen}} in ju Speerlieste {{PLURAL:$1|is|sunt}} uungultich; korrigier do foar dät Spiekerjen:',
	'right-tboverride' => 'Buute Kraft sätten fon ju swotte Lieste fon nit wonskede Siedennoomen',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'titleblacklist-forbidden-edit' => 'Judul “$2” dicaram dijieun, luyu jeung éntri daptar hideung: <code>$1</code>',
	'titleblacklist-forbidden-move' => '“$2” teu bisa dipindahkeun ka “$3”, sababa judul “$3” dicaram dijieun, luyu jeung éntri daptar hideung: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Ngaran koropak “$2” dicaram dijieun, luyu jeung éntri daptar hideung: <code>$1</code>',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'titleblacklist-desc' => 'Låter administratörer förbjuda skapande av sidor och användarkonton genom en [[MediaWiki:Titleblacklist|svartlista]] och en [[MediaWiki:Titlewhitelist|vitlista]].',
	'titleblacklist' => '# Det här är en svartlista för titlar. Titlar och användarnamn som matchar ett reguljärt uttryck här kan inte skapas.
# Använd "#" för kommentarer.
# Detta är okänsligt för skiftläge som förval',
	'titlewhitelist' => '# Det är en lista över tillåtna sidtitlar. Använd "#" för att skriva kommentarer.
# Detta är okänsligt för skiftläge som förval',
	'titleblacklist-forbidden-edit' => 'Sidtiteln "$2" har stoppats från att skapas. Den matchar följande rad i svarta listan för sidtitlar: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Sidan "$2" kan inte flyttas till "$3", eftersom titeln "$3" har förbjudits att skapas. Titeln matchar följande rad i svarta listan för sidtitlar: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Filnamnet "$2" har stoppats från att skapas. Namnet matchar följande rad i svarta listan för sidtitlar: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Användarnamnet "$2" kan inte skapas.
Det matchar följande element i svartlistan: <code>$1</code>',
	'titleblacklist-invalid' => 'Följande {{PLURAL:$1|rad|rader}} i listan är {{PLURAL:$1|felaktig|felaktiga}}; {{PLURAL:$1|den|de}} måste rättas innan du kan spara:',
	'right-tboverride' => 'Upphäva den svarta listan över titlar',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'titleblacklist-desc' => '[[MediaWiki:Titleblacklist|నిరోధపుజాబితా]] మరియు [[MediaWiki:Titlewhitelist|శ్వేతజాబితా]]ల ప్రకారం ప్రత్యేకిత శీర్షికలతో పేజీలను మరియు వాడుకరి ఖాతాలను సృష్టించడాన్ని నిర్వాహకులు నిరోధించే వీలుకల్పిస్తుంది.',
	'titleblacklist' => '# ఇది శీర్షికల నిరోధపు జాబితా. ఇక్కడ ఉన్న రెగ్యులర్ ఎక్స్‌ప్రెషన్లకి సరిపోలే శీర్షికలు గల పేజీలను మరియు వాడుకరులను సృష్టించలేరు.
# వ్యాఖ్యానించడానికి "#"ని వాడండి.
# ఇది స్వతహాగా పెద్ద మరియు చిన్న అక్షరాలను ఒకలాగానే చూస్తుంది',
	'titlewhitelist' => '# ఇది అనుమతించే శీర్షికల జాబితా. వ్యాఖ్యానించడానికి "#"ని వాడండి.
# ఇది స్వతహాగా పెద్ద మరియు చిన్న అక్షరాలను ఒకలాగానే చూస్తుంది',
	'titleblacklist-forbidden-edit' => '"$2" అనే శీర్షిక గల పేజీలను సృష్టించడంపై నిషేధం విధించారు. ఇది నిరోధపు జాబితాలోని ఈ పద్దుకి సరిపోలింది: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2"ని "$3"కి తరలించలేము, ఎందుకంటే "$3" అన్న శీర్షికని సృష్టించడంపై నిషేధం ఉంది. ఇది నిరోధపు జాబితాలోని ఈ పద్దుకి సరిపోలుతుంది: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" అన్న పేరు గల ఫైలుని సృష్టించడాన్ని నిషేధించారు. ఇది నిషేధపు జాబితాలోని ఈ పద్దుకి సరిపోలుతుంది: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => '"$2" అన్న పేరు గల వాడుకరిని సృష్టించడాన్ని నిషేధించారు.
ఇది నిషేధపు జాబితాలోని ఈ పద్దుకి సరిపోలుతుంది: <code>$1</code>',
	'titleblacklist-invalid' => 'శీర్షికల నిరోధపు జాబితాలోని ఈ క్రింద పేర్కొన్న {{PLURAL:$1|లైను|లైన్లు}} తప్పుగా {{PLURAL:$1|ఉంది|ఉన్నాయి}}; భద్రపరిచేముందు {{PLURAL:$1|దాన్ని|వాటిని}} సరిదిద్దండి:',
	'right-tboverride' => 'శీర్షికల నిరోధపు జాబితాని  అధిగమించగలగడం',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'titleblacklist-desc' => 'Имкони пешгирӣ аз эҷоди саҳифахое бо унвонҳои хосро медиҳад: [[MediaWiki:Titleblacklist]] ва [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# Ин як феҳристи сиёҳ барои унвонҳо аст. Унвонҳое, ки бо як regex дар ин саҳифа мутобиқаткунандаро наметавон эчод кард.
# Барои илова кардани тавзеҳот аз "#" истифода кунед.',
	'titlewhitelist' => '# Ин як феҳристи сафед барои унвонҳо аст. Барои илова кардани тавзеҳот аз "#" истифода кунед',
	'titleblacklist-forbidden-edit' => 'Эҷоди унвони "$2" манъ шудааст.  Ин унвон бо ин дастур аз феҳристи сиёҳ мутобиқат мекунад: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" наметавонад ба "$3" кӯчонида шавад, зеро эҷоди унвони "$3" манъ шудааст. Чун бо ин дастур аз феҳристи сиёҳ мутобиқат мекунад: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Эҷоди номи "$2" барои парвандаҳо манъ аст. Он бо ин дастур аз фехристи сиёҳи зерин мутобиқат мекунад: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Сатри|Сатрҳои}} зерин дар феҳристи сиёҳи унвонҳо ғайримиҷоз {{PLURAL:$1|аст|ҳастанд}}; лутфан {{PLURAL:$1|он|онҳо}}ро қабл аз захира кардан, ислоҳ кунед:',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'titleblacklist-forbidden-edit' => 'Eçodi unvoni "$2" man\' şudaast.  In unvon bo in dastur az fehristi sijoh mutobiqat mekunad: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" nametavonad ba "$3" kūconida şavad, zero eçodi unvoni "$3" man\' şudaast. Cun bo in dastur az fehristi sijoh mutobiqat mekunad: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Eçodi nomi "$2" baroi parvandaho man\' ast. On bo in dastur az fexristi sijohi zerin mutobiqat mekunad: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Satri|Satrhoi}} zerin dar fehristi sijohi unvonho ƣajrimiçoz {{PLURAL:$1|ast|hastand}}; lutfan {{PLURAL:$1|on|onho}}ro qabl az zaxira kardan, isloh kuned:',
);

/** Thai (ไทย)
 * @author Horus
 * @author Manop
 */
$messages['th'] = array(
	'titleblacklist-forbidden-edit' => 'ชื่อบทความ "$2" ถูกห้ามสร้างในระบบนี้

ชื่อหัวข้อนี้ตรงกับบัญชีดำในส่วนของ: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'ไฟล์ชื่อ "$2" ถูกห้ามจากการสร้าง
เนื่องจากตรงกับชื่อที่ปรากฎในบัญชีดำดังต่อไปนี้: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'ชื่อผู้ใช้ "$2" ถูกห้ามจากการสร้าง
เนื่องจากตรงกับชื่อที่ปรากฎในบัญชีดำดังต่อไปนี้: <code>$1</code>',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'titleblacklist-desc' => 'Administratorlara sahypalaryň we ulanyjy hasaplarynyň döredilmegini gadagan etmeklerine [[MediaWiki:Titleblacklist|gara sanaw]] ve [[MediaWiki:Titlewhitelist|ak sanaw]] arkaly rugsat berýär.',
	'titlewhitelist' => '# Bu bir atlaryň ak sanawydyr. Teswirler üçin "#" ulanyň.
# Bu gaýybana baş-setir harpa duýgur däldir.',
	'titleblacklist-forbidden-edit' => '"$2" adynyň döredilmegi gadagan edildi.
Şu gara sanaw girişina gabat gelýär: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" faýl adynyň döredilmegi gadagan edildi.
Şu gara sanaw girişina gabat gelýär: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => '"$2" ulanyjy adynyň döredilmegi gadagan edildi.
Şu gara sanaw girişina gabat gelýär: <code>$1</code>',
	'titleblacklist-invalid' => 'Gara sanawdaky şu {{PLURAL:$1|setir|setirler}} nädogry;
ýazdyrmankaňyz düzediň:',
	'right-tboverride' => 'At gara sanawyna pisint etme',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'titleblacklist-desc' => 'Nagpapahintulot sa mga tagapangasiwa na magbawal ng paglikha ng mga pahina at mga kuwenta ng tagagamit sa bawat isang [[MediaWiki:Titleblacklist|talaan ng pinagbabawal ("itim na talaan")]] at [[MediaWiki:Titlewhitelist|talaan ng mga pinapayagan ("puting talaan")]]',
	'titleblacklist' => '# Isa itong itim na talaan ng pamagat.  Hindi maaaring likhain ang mga pamagat at mga tagagamit na tumutugma sa isang pangkaraniwang pagsasaad na naririto.
# Gamitin ang "#" para sa mga puna.
# Likas na nakatakdang hindi ito maselan sa pagmamakinilya ng titik',
	'titlewhitelist' => '# Isa itong puting talaan ng pamagat.  Gamitin ang "#" para sa mga puna.
# Likas na nakatakdang hindi ito maselan sa pagmamakinilya ng titik',
	'titleblacklist-forbidden-edit' => 'Pinagbawalan sa paglikha ang pamagat na "$2".
Tumutugma ito sa sumusunod na entradang/ipinasok na nasa talaan ng mga pinagbabawal ("itim na talaan"): <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Hindi maililipat ang "$2" patungo sa "$3", dahil pinagbawal ang paglikha sa pamagat na "$3".
Tumutugma ito sa sumusunod na ipinasok/entradang nasa talaan ng mga pinagbabawal ("itim na talaan"): <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Pinagbawal ang paglikha sa pangalan ng talaksang "$2".
Tumutugma ito sa sumusunod na ipinasok/entradang nasa talaan ng mga pinagbabawalan ("itim na talaan"): <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Ipinagbawalan ang paglikha ng pangalan ng tagagamit na "$2".
Tumutugma ito sa sumusunod na entrada/ipinasok sa talaan ng mga pinagbabawalan ("itim na talaan"): <code>$1</code>',
	'titleblacklist-invalid' => 'Ang sumusunod na {{PLURAL:$1|hanay|mga hanay}} (guhit) na nasa loob ng talaan ng pinagbabawal na pamagat {{PLURAL:$1|ay|ay}} hindi tanggap;
pakitama lamang {{PLURAL:$1|ito|ang mga ito}} bago sagipin:',
	'right-tboverride' => 'Daigin (pangibabawan) ang talaan ng pinagbabawalang pamagat',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'titleblacklist-desc' => 'Yöneticilere, sayfaların ve kullanıcı hesaplarının oluşturulmasını yasaklamalarına bir [[MediaWiki:Titleblacklist|karaliste]] ve [[MediaWiki:Titlewhitelist|beyazliste]] ile izin verir.',
	'titleblacklist' => '# Bu bir başlık karalistesi. Buradaki düzenli ifadelerle eşleşen başlıklar ve kullanıcılar oluşturulamaz.
# Yorumlar için "#" kullanın.
# Bu varsayılan olarak büyük-küçük harf duyarsızdır',
	'titlewhitelist' => '# Bu bir başlık beyaz listesidir. Yorumlar için "#" kullanın.
# Varsayılan olarak büyük-küçük harfe duyarsızdır',
	'titleblacklist-forbidden-edit' => '"$2" başlığının oluşturulması engellendi.
Şu karaliste girdisiyle eşleşiyor: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2", "$3" sayfasına taşınamaz, çünkü "$3" başlığının oluşturulması yasaklanmış.
Şu karaliste girdisiyle eşleşiyor: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" dosya adının oluşturulması engellendi.
Şu karaliste girdisiyle eşleşiyor: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => '"$2" kullanıcı adının oluşturulması engellendi.
Şu karaliste girdisiyle eşleşiyor: <code>$1</code>',
	'titleblacklist-invalid' => 'Karalistedeki şu {{PLURAL:$1|satır|satırlar}} geçersiz;
lütfen kaydetmeden önce düzeltin:',
	'right-tboverride' => 'Başlık karalistesini geçersiz kıl',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'titleblacklist-desc' => 'Дає змогу адміністраторам заборонити створення певних сторінок та облікових записів за допомогою [[MediaWiki:Titleblacklist|чорного]] та [[MediaWiki:Titlewhitelist|білого]] списків.',
	'titleblacklist' => '# Це список заборонених назв. Сторінки і користувачі, назви яких підпадають під регулярні вирази з цього списку, не можуть бути створені.
# Використовуйте "#" для коментарів.
# Список за замовчуванням нечутливий до регістру',
	'titlewhitelist' => '# Це «білий список» назв. Використовуйте «#» для коментарів.
# Список за замовчуванням нечутливий до регістру',
	'titleblacklist-forbidden-edit' => 'Сторінку з назвою "$2" заборонено створювати. Вона підпадає під наступний запис із списку заборонених назв: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Не можна перейменувати "$2" на "$3", бо назва "$3" є забороненою.
Вона підпадає під наступний запис із списку заборонених назв: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Назва файлу "$2" є забороненою для створення.
Вона підпадає під наступний запис із списку заборонених назв: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => "Заборонено використовувати ім'я користувача «$2».
Ім'я відповідає наступному запису з чорного списку: <code>$1</code>",
	'titleblacklist-invalid' => '{{PLURAL:$1|Наступнинй рядок|Наступні рядки}} списку заборонених назв є {{PLURAL:$1|помилковим|помилковими}};
будь ласка, виправіть {{PLURAL:$1|його|їх}} перед збереженням:',
	'right-tboverride' => 'ігнорування чорного списку назв сторінок',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'titleblacklist-desc' => 'Consente ai aministradori de proibir la creazion de pagine con i titoli indicà su la [[MediaWiki:Titleblacklist|lista nera]] e su la [[MediaWiki:Titlewhitelist|lista bianca]]',
	'titleblacklist' => '# Lista dei titoli mìa consentìi. Xe inpedìa la creazion de le pagine el cui titolo el corisponde a na espression regolar indicà de seguito.
# Dòpara "#" par le righe de comento.
# De default no se tien conto del majuscolo/minuscolo',
	'titlewhitelist' => '# Sta qua la xe na lista bianca dei titoli. Dòpara "#" par le righe de comento.
# De default no se tien conto del majuscolo/minuscolo',
	'titleblacklist-forbidden-edit' => 'La creazion de pagine con titolo "$2" la xe stà inpedìa. La voçe corispondente ne l\'elenco dei titoli mìa consentìi la xe sta chì: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'No se pode spostar la pagina "$2" al titolo "$3" in quanto la creazion de pagine con titolo "$3" la xe stà inpedìa. La voçe corispondente ne l\'elenco dei titoli mìa consentìi la xe sta chì: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'La creazion de file con titolo "$2" la xe stà inpedìa. La voçe corispondente ne l\'elenco dei titoli mìa consentìi la xe sta chì: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'La creassion de utenti co\' nome "$2" la xe stà proibìa. La voçe corispondente in tel\'elenco dei nomi mìa consentìi la xe la seguente: <code>$1</code>',
	'titleblacklist-invalid' => "{{PLURAL:$1|La seguente riga|Le seguenti righe}} de l'elenco dei titoli mìa consentìi {{PLURAL:$1|no la xe valida|no le xe valide}}; se prega de corègiar {{PLURAL:$1|l'eror|i erori}} prima de salvar la pagina.",
	'right-tboverride' => 'Ignora la lista nera dei titoli',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'titleblacklist-desc' => 'Cho phép các quản lý viên cấm không được tạo ra trang có các tên, theo [[MediaWiki:Titleblacklist|danh sách đen]] và [[MediaWiki:Titlewhitelist|danh sách trắng]]',
	'titleblacklist' => '# Đây là danh sách đen về tựa đề. Tựa bài và tên thành viên trùng với biểu thức chính quy tại đây sẽ không thể tạo được.
# Hãy dùng “#” để ghi chú.
# Nội dung mặc định là không phân biệt chữ hoa chữ thường',
	'titlewhitelist' => '# Đây là danh sách trắng về tựa đề. Hãy sử dụng "#" cho lời chú thích.
# Nội dung theo mặc định không phân biệt chữ hoa chữ thường',
	'titleblacklist-forbidden-edit' => 'Không được tạo ra trang dưới tên “$2”.
Tên này trùng với mục sau trong danh sách đen: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Không được di chuyển “$2” đến “$3”, vì tựa đề “$3” bị cấm khởi tạo. 
Nó trùng với mục sau trong danh sách đen: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Không được tải lên tập tin dưới tên “$2”.
Tên này trùng với khoản sau trong danh sách đen: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Không được tạo ra tài khoản “$2”.
Nó trùng tên với một khoản mục trong danh sách đen: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Dòng|Những dòng}} sau đây trong danh sách đen về tên trang không hợp lệ; xin hãy sửa chữa {{PLURAL:$1|nó|chúng}} để tuân theo cú pháp biểu thức chính quy trước khi lưu trang:',
	'right-tboverride' => 'Bỏ qua danh sách các tựa trang bị cấm',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'titleblacklist-desc' => 'Dälon guvanes ad proibön padi- e kalijafi medü [[MediaWiki:Titleblacklist|blägalised]] e [[MediaWiki:Titlewhitelist|vietalised]].',
	'titlewhitelist' => '# Atos binon vietalised tiädas. Gebolös el „#“ pro küpets.',
	'titleblacklist-forbidden-edit' => 'Tiäd: „$2“ no dalon pajafön.
Tiäd at binon in blägalised as: <code>$1</code>',
	'titleblacklist-forbidden-move' => 'Pad: „$2“ no kanon topätükön sui pad: „$3“, bi tiäd: „$3“ no dalon pajafön. Tiäd at binon in blägalised as: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Ragivanem: „$2“ no dalon pajafön. Ragivanem at binon in blägalised as: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => 'Gebananem: „$2“ no dalon pajafön.
Gebananem at binon in blägalised as: <code>$1</code>',
	'titleblacklist-invalid' => '{{PLURAL:$1|Lien|Liens}} sököl in tiädablägalised no {{PLURAL:$1|lonöfon|lonöfons}}; gudükumolös {{PLURAL:$1|oni|onis}} bü dakip:',
	'right-tboverride' => 'Nedemön blägalisedi tiädas',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'titleblacklist-desc' => '容許禁止開指定標題嘅版: [[MediaWiki:Titleblacklist]] 同 [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# 呢個係一個標題黑名單。同呢度配合正規表達式嘅標題係唔可以新開嘅。
# 用 "#" 去做註解。',
	'titlewhitelist' => '# 呢個係一個標題白名單。 用 "#" 去做註解',
	'titleblacklist-forbidden-edit' => '個標題 "$2" 已經禁止咗去開版。佢同下面黑名單嘅項目配合: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" 唔可以搬到去 "$3"，由於個標題 "$3" 已經禁止咗去開。佢同下面黑名單嘅項目配合: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '個檔名 "$2" 已經禁止咗去開版。佢同下面黑名單嘅項目配合: <code>$1</code>',
	'titleblacklist-invalid' => '下面響標題黑名單嘅{{PLURAL:$1|一行|幾行}}無效；請響保存之前改正{{PLURAL:$1|佢|佢哋}}:',
	'right-tboverride' => '覆蓋標題黑名單',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Fdcn
 * @author Liangent
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'titleblacklist-desc' => '容许禁止建立指定标题的页面: [[MediaWiki:Titleblacklist]] 和 [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# 本页面为“标题黑名单”。任何匹配本名单正则表达式的标题会被阻止建立和编辑。
# 请使用"#"来添加注释。
# 默认忽略大小写',
	'titlewhitelist' => '# 本页面为“标题白名单”。 请使用"#"来添加注释。
# 本页默认不区分大小写',
	'titleblacklist-forbidden-edit' => '标题 "$2" 已经被禁止创建。它跟以下黑名单的项目配合: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" 不可以移动到 "$3"，由于该标题 "$3" 已经被禁止创建。它跟以下黑名单的项目配合: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '文件名称 "$2" 已经被禁止创建。它跟以下黑名单的项目配合: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => '用户名“$2”已被阻止创建。
它匹配以下黑名单项目：<code>$1</code>',
	'titleblacklist-invalid' => '以下在标题黑名单上的{{PLURAL:$1|一行|多行}}无效；请在保存前改正{{PLURAL:$1|它|它们}}:',
	'right-tboverride' => '覆盖标题黑名单',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Fdcn
 * @author Gaoxuewei
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'titleblacklist-desc' => '容許禁止建立指定標題的頁面: [[MediaWiki:Titleblacklist]] 與 [[MediaWiki:Titlewhitelist]]',
	'titleblacklist' => '# 本頁面為「標題黑名單」。任何匹配本名單正則表達式的標題會被阻止建立和編輯。
# 請使用"#"來添加註釋。
# 默認忽略大小寫',
	'titlewhitelist' => '# 本頁面為「標題白名單」。 請使用"#"來添加註釋。
# 本頁默認不區分大小寫',
	'titleblacklist-forbidden-edit' => '標題 "$2" 已經被禁止創建。它跟以下黑名單的項目配合: <code>$1</code>',
	'titleblacklist-forbidden-move' => '"$2" 不可以移動到 "$3"，由於該標題 "$3" 已經被禁止創建。它跟以下黑名單的項目配合: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '檔案名稱 "$2" 已經被禁止創建。它跟以下黑名單的項目配合: <code>$1</code>',
	'titleblacklist-forbidden-new-account' => '用戶名“$2”已被阻止創建。
它匹配以下黑名單項目：<code>$1</code>',
	'titleblacklist-invalid' => '以下在標題黑名單上的{{PLURAL:$1|一行|多行}}無效；請在保存前改正{{PLURAL:$1|它|它們}}:',
	'right-tboverride' => '覆蓋標題黑名單',
);

