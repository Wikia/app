<?php
/**
 * Internationalisation file for extension TitleBlacklist.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'titleblacklist-desc'             => 'Allows to forbid creation of pages with specified titles: [[MediaWiki:Titleblacklist]] and [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => "# This is a title blacklist. Titles that match a regex here cannot be created.
# Use \"#\" for comments.",
	'titlewhitelist'                  => "# This is a title whitelist. Use \"#\" for comments.",
	'titleblacklist-forbidden-edit'   => 'The title "$2" has been banned from creation.
It matches the following blacklist entry: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" cannot be moved to "$3", because the title "$3" has been banned from creation.
It matches the following blacklist entry: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'The file name "$2" has been banned from creation.
It matches the following blacklist entry: <code>\$1</code>',
	'titleblacklist-invalid'          => 'The following {{PLURAL:$1|line|lines}} in the title blacklist {{PLURAL:$1|is|are}} invalid;
please correct {{PLURAL:$1|it|them}} before saving:',
	'right-tboverride'                => 'Override the title blacklist',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'titleblacklist-desc'             => 'Premite biedar a creyazión de pachinas con determinaus títols: [[MediaWiki:Titleblacklist]] y [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Ista ya una lista negra de títols. Os títols que concuerdan con una d\'as espresions regulars (regex) no se pueden creyar.
# Use "#" ta fer comentarios.',
	'titlewhitelist'                  => '# Ista ya una lista blanca de títols. Use "#" ta fer comentarios.',
	'titleblacklist-forbidden-edit'   => 'O títol "$2" ye biedato y no se puede creyar. Concuerda con a siguient dentrada d\'a lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" no se puede tresladar ta "$3", porque o títol "$3" ye biedato y no se puede creyar. Concuerda con a siguient dentrada d\'a lista negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'O nombre de fichero "$2" ye biedato y no se puede creyar. Concuerda con a siguient dentrada d\'a lista negra: <code>\\$1</code>',
	'titleblacklist-invalid'          => "{{PLURAL:$1|A siguient linia|As siguients linias}} d'a lista negra de títols {{PLURAL:$1|ye|son}} no son conformes; por fabor corricha-{{PLURAL:$1|la|las}} antes d'alzar:",
	'right-tboverride'                => 'Inorar a lista negra de títols',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'titleblacklist-desc'             => 'يسمح بمنع إنشاء الصفحات بعناوين محددة: [[MediaWiki:Titleblacklist]] و [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# هذه قائمة سوداء للعناوين. العناوين التي تطابق ريجيكس هنا لا يمكن إنشاؤها.
# استخدم "#" للتعليقات.',
	'titlewhitelist'                  => '# هذه قائمة بيضاء للعناوين. استخدم "#" للتعليقات',
	'titleblacklist-forbidden-edit'   => 'العنوان "$2" تم منعه من الإنشاء.  هو يطابق المدخلة التالية في القائمة السوداء: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" لا يمكن نقلها إلى "$3"، لأن العنوان "$3" تم منعه من الإنشاء. هو يطابق المدخلة التالية في القائمة السوداء : <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'اسم الملف "$2" تم منعه من الإنشاء. هو يطابق المدخلة التالية في القائمة السوداء: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|السطر|السطور}} التالية في قائمة العناوين السوداء {{PLURAL:$1|غير صحيح|غير صحيحة}}؛ من فضلك {{PLURAL:$1|صححه|صححهم}} قبل الحفظ:',
	'right-tboverride'                => 'تجاوز قائمة العناوين السوداء',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'titleblacklist-desc'             => 'اجازت دن بند کتن شرکنگ صفحاتی گون مشخصین عناوین:  [[MediaWiki:Titleblacklist]] و [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# شی یک عنوان لیست سیاهی انت. عناوینی که هم داب رجکس انت ادان شرکنگ نه بیت.
# استفاده کن"#" په نظرات',
	'titlewhitelist'                  => '#شی یک اسپیت لیستی عنوانیء. استفاده کن چه  "#" په نظر داتن',
	'titleblacklist-forbidden-edit'   => 'عنوان "$2" چه شر بیگ منع بوتت.
ایی هم داب جهلگی لیست سیاه یک ورودی انت: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'عنوان "$2" نه تونیت په "$3" جاه په جاه بیت، په چی که ایی چه شر بیگ منع بوتت.
ایی هم داب جهلگی لیست سیاه یک ورودی انت: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'فایل نام  "$2" چه شر بیگ منع بوتت.
ایی هم داب جهلگی لیست سیاه یک ورودی انت: <code>$1</code>',
	'right-tboverride'                => 'لیست سیاه عنوان لغو کن',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Borislav
 */
$messages['bg'] = array(
	'titleblacklist-desc'             => 'Позволява забраната за създаване на страници с указаните заглавия: [[MediaWiki:Titleblacklist]] и [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Страницата съдържа черен списък за заглавия на страници
# Страници, чиито заглавия съответстват с регулярните изрази в списъка, не могат да бъдат създавани или редактирани
# За коментари се използва символът "#"',
	'titleblacklist-forbidden-edit'   => 'Страницата "$2" не може да бъде създадена, тъй като съвпада със запис от черния списък: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Страницата "$2" не може да бъде преместена като "$3", тъй като съвпада със запис от черния списък: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Файлът "$2" не може да бъде качен, тъй като съвпада със запис от черния списък: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Следният ред|Следните редове}} от черния списък на заглавията {{PLURAL:$1|е невалиден|са невалидни}} и трябва да {{PLURAL:$1|бъде коригиран|бъдат коригирани}} преди съхранение:',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'titleblacklist'                  => '# এটি শিরোনাম কালোতালিকা। যেসব পাতার শিরোনাম এখানকার একটি রেগুলার এক্সপ্রেশনের সাথে মিলে যাবে, সেগুলি সৃষ্টি করা যাবে না।
# মন্তব্যের জন্য "#" ব্যবহার করুন।',
	'titlewhitelist'                  => '# এটি একটি শিরোনাম সাদাতালিকা। মন্তব্যের জন্য "#" ব্যবহার করুন',
	'titleblacklist-forbidden-edit'   => '"$2" শিরোনামটি সৃষ্টি করা নিষিদ্ধ করা হয়েছে। এটি কালোতালিকার এই ভুক্তিটির সাথে মিলে গেছে: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2"-কে "$3"-এ সরানো যাবে না, কারণ "$3" শিরোনামটি নিষিদ্ধ। শিরোনামটি এই কালোতালিকা ভুক্তিটির সাথে মিলে গেছে: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" ফাইলনামটি সৃষ্টি নিষিদ্ধ। নামটি এই কালোতালিকা ভুক্তিটির সাথে মিলে গেছে: <code>\\$1</code>',
	'titleblacklist-invalid'          => 'শিরোনাম কালোতালিকার এই {{PLURAL:$1|টি লাইন|টি লাইন}} অবৈধ; অনুগ্রহ করে সংরক্ষণ করার আগে  {{PLURAL:$1|এটি|এগুলি}} সংশোধন করুন:',
);

/** Catalan (Català)
 * @author SMP
 * @author Jordi Roqué
 */
$messages['ca'] = array(
	'titleblacklist-desc'             => 'Permet de restringir la creació de pàgines amb els títols indicats a [[MediaWiki:Titleblacklist]] i [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => "# Això és una llista negra de títols. Aquelles pàgines que compleixin alguna expressió regular (''regex'') d'aquí no podran ser creades.
# Les línies que començen per \"#\" són comentaris.",
	'titleblacklist-forbidden-edit'   => 'El títol «$2» està prohibit i no es pot crear. Concorda amb la següent entrada de la llista negra: <code>$1</code>',
	'titleblacklist-forbidden-move'   => "No es pot moure «$2» a «$3», perquè el títol «$3» està prohibit. Concorda amb l'entrada de la llista negra següent: <code>$1</code>",
	'titleblacklist-forbidden-upload' => "El nom de fitxer «$2» ha estat prohibit i se n'impedeix la creació. Concorda amb la següent línia de la llista negra: <code>\\$1</code>",
	'titleblacklist-invalid'          => '{{PLURAL:$1|La línia següent|Les línies següents}} de la llista negra no {{PLURAL:$1|és vàlida|són vàlides}}; heu de corregir-{{PLURAL:$1|la|les}} abans de guardar:',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Danny B.
 */
$messages['cs'] = array(
	'titleblacklist-desc'             => 'Umožňuje zakázat tvorbu stránek s určitými názvy: [[MediaWiki:Titleblacklist|Černá listina názvů]] a [[MediaWiki:Titlewhitelist|Bílá listina názvů]]',
	'titleblacklist'                  => '# Toto je černá listina názvů. Název, který bude odpovídat regulárnímu výrazu, nebude možné vytvořit.
# Používejte „#“ pro označení komentáře.',
	'titlewhitelist'                  => '# Toto je bílá listina názvů stránek. Řádky komentářů začínají znakem „#“',
	'titleblacklist-forbidden-edit'   => 'Název "$2" je zakázáno vytvářet. Odpovídá následujícímu záznamu na černé listině: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '„$2“ nelze přesunout na název „$3“, protože název „$3“ je zakázáno vytvářet. Odpovídá následujícímu záznamu na černé listině: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Soubor s jménem „$2“ je zakázáno vytvářet. Název odpovídá následujícímu záznamu na černé listině: <code>$1</code>',
	'titleblacklist-invalid'          => 'Na černé listině názvů {{PLURAL:$1|je následující řádka neplatný regulární výraz|jsou následující řádky neplatné regulární výrazy|jsou následující řádky regulární výrazy}} a je nutné {{PLURAL:$1|ji|je|je}} před uložením stránky opravit :',
	'right-tboverride'                => 'Potlačení nepovolených názvů stránek',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'titleblacklist-desc'             => 'Ergänzt eine schwarze Liste unerwünschter Seitennamen: [[MediaWiki:Titleblacklist]] und [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Dies ist die Schwarze Liste unerwünschter Seitennamen.
# Jeder Seitenname, auf den die folgenden regulären Ausdrücke zutreffen, kann nicht erstellt werden.
# Text hinter einer Raute „#“ wird als Kommentar gesehen.',
	'titlewhitelist'                  => '# Dies ist die Ausnahmeliste von der Schwarzen Liste unerwünschter Seitennamen. Benutze „#“ für Kommentare',
	'titleblacklist-forbidden-edit'   => "'''Eine Seite mit dem Titel „$2“ kann nicht erstellt werden.'''<br />Der Titel kollidiert mit diesem Sperrbegriff: '''''$1'''''",
	'titleblacklist-forbidden-move'   => "'''Die Seite „$2“ kann nicht nach „$3“ verschoben werden.'''<br />Der Titel kollidiert mit diesem Sperrbegriff: '''''$1'''''",
	'titleblacklist-forbidden-upload' => "'''Eine Datei mit dem Namen „$2“ kann nicht hochgeladen werden.'''<br />Der Titel kollidiert mit diesem Sperrbegriff: '''''$1'''''",
	'titleblacklist-invalid'          => 'Die {{PLURAL:$1|folgende Zeile|folgenden Zeilen}} in der Sperrliste {{PLURAL:$1|ist|sind}} ungültig; bitte korrigiere diese vor dem Speichern:',
	'right-tboverride'                => 'Außer Kraft setzen der schwarzen Liste unerwünschter Seitennamen',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'titleblacklist-desc'             => 'Permesas aŭ malpermesas kreadon de paĝoj kun specifaj titoloj: [[MediaWiki:Titleblacklist]] kaj [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Ĉi tiu estas titola nigralisto. Titoloj konguantaj regulan esprimon ĉi tie ne povas esti kreita.
# Uzu "#" por komentoj.',
	'titlewhitelist'                  => '# Ĉi tio estas blanklisto por titoloj. Uzu "#" por komentoj.',
	'titleblacklist-forbidden-edit'   => 'La titolo "$2" estis malpermesita de kreado.
Ĝi similas la jenan nigralistan listeron: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" ne povas esti alinomita al "$3", ĉar la titolo "$3" estis forbarita de kreado.
Ĝi kongruas la jenan nigralistanon: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'La dosiernomo "$2" estis forbarita de kreado.
Ĝi kongruas la jenan nigralistanon: <code>\\$1</code>',
	'titleblacklist-invalid'          => 'La {{PLURAL:$1|jena linio|jenaj linioj}} en la titola nigralisto estas {{PLURAL:$1|nevalida|nevalidaj}}; 
bonvolu korekti {{PLURAL:$1|gxi|ilin}} antaŭ konservado:',
	'right-tboverride'                => 'Anstataŭigi la titolan nigraliston',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'titleblacklist-desc'             => 'امکان جلوگیری از ایجاد صفحه‌هایی با عنوان‌های خاص را می‌دهد: [[MediaWiki:Titleblacklist]] و [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# این یک فهرست سیاه عنوان‌ها است. عنوان‌هایی که با یک regex در این صفحه مطابقت کنند را نمی‌توان ایجاد کرد.
# از «#» برای توضیحات استفاده کنید.',
	'titlewhitelist'                  => '# این یک فهرست سفید برای عنوان‌ها است. از «#» برای افزودن توضیحات استفاده کنید.',
	'titleblacklist-forbidden-edit'   => 'ایجاد عنوان «$2» ممنوع شده‌است. این عنوان با این دستور از فهرست سیاه مطابقت می‌کند: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '«$2» را نمی‌توان به «$3» انتقال داد. ایجاد «$3» ممنوع است. چون با این دستور از فهرست سیاه مطابقت می‌کند: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'ایجاد نام «$2» برای پرونده‌ها ممنوع است، زیرا با این دستور از فهرست سیاه مطابقت می‌کند: <code>\\$1</code>',
	'titleblacklist-invalid'          => '
{{PLURAL:$1|سطر|سطرهای}} زیر در فهرست سیاه عنوان‌ها غیرمجاز {{PLURAL:$1|است|هستند}}؛ لطفاً {{PLURAL:$1|آن|آن‌ها}} را قبل از ذخیره کردن اصلاح کنید:',
	'right-tboverride'                => 'گذر از فهرست سیاه عنوان‌ها',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Crt
 * @author Cimon Avaro
 */
$messages['fi'] = array(
	'titleblacklist-desc'             => 'Mahdollistaa sivujen luomisen estämisen nimen perusteella: [[MediaWiki:Titleblacklist|estolista]] ja [[MediaWiki:Titlewhitelist|poikkeuslista]].',
	'titleblacklist'                  => '# Tämä sivu sisältää sääntöjä, jotka estävät tietyn nimisten uusien sivujen luomisen.
# Estettyjä ovat sivut, joiden sivunimet vastaavat täällä määritettyjä säännöllisiä lausekkeita.
# Käytä #-merkkiä kommentointiin.',
	'titlewhitelist'                  => '# Tämä sivu sisältää sivujen sallittuja nimiä. Käytä #-merkkiä kommentointia varten.',
	'titleblacklist-forbidden-edit'   => 'Sivun ”$2” luonti on estetty, koska se täsmää seuraavaan osaan estolistassa: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Sivua ”$2” ei voi siirtää nimelle ”$3”, koska sivun ”$3” luonti on estetty. Se täsmää seuraavaan osaan estolistassa: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Tiedoston ”$2” luonti on estetty, koska se täsmää seuraavaan osaan estolistassa: <code>$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Seuraava listan rivi ei ole kelvollinen|Seuraavat listan rivit eivät ole kelvollisia}}. Korjaa {{PLURAL:$1|se|ne}} ennen tallentamista.',
	'right-tboverride'                => 'Ohittaa sivunimien mustalista',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Urhixidur
 * @author Meithal
 */
$messages['fr'] = array(
	'titleblacklist-desc'             => "Permet d'interdire la création de pages en fonction d'une [[MediaWiki:Titleblacklist|liste noire]] et d'une [[MediaWiki:Titlewhitelist|liste blanche]] de titres",
	'titleblacklist'                  => '# Ceci est un titre mis en liste noire
# Chaque titre qu’indique ici le code regex ne peut être créé.
# Utilisez « # » pour écrire des commentaires',
	'titlewhitelist'                  => '# Ceci est la liste blanche des titres. Utilisez « # » pour les commentaires.',
	'titleblacklist-forbidden-edit'   => "Le titre « $2 » est interdit à la création.
Dans la liste noire, il est détecté par l'entrée suivante : <code>$1</code>",
	'titleblacklist-forbidden-move'   => "La page intitulée « $2 » ne peut être déplacée vers « $3 » parce que cette dernière a été interdite à la création. Dans la liste noire, elle correspond à l'entrée : <code>$1</code>",
	'titleblacklist-forbidden-upload' => "Le fichier intitulé « $2 » est interdit à la création. Dans la liste noire, il correspond à l'entrée : <code>$1</code>",
	'titleblacklist-invalid'          => '{{PLURAL:$1|La ligne suivante|Les lignes suivantes}} dans la liste noire des titres {{PLURAL:$1|est invalide|sont invalides}} : vous êtes invité à {{PLURAL:$1|la|les}} corriger avant de sauvegarder.',
	'right-tboverride'                => 'Ignorer la liste noire des titres',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'titleblacklist-desc'             => 'Pèrmèt de dèfendre la crèacion de pâges d’aprés una [[MediaWiki:Titleblacklist|lista nêre]] et una [[MediaWiki:Titlewhitelist|lista blanche]] de titros.',
	'titleblacklist'                  => '# Cen est la lista nêre des titros. Châque titro qu’endique ique lo code RegEx pôt pas étre crèâ.
# Utilisâd « # » por los comentèros.',
	'titlewhitelist'                  => '# Cen est la lista blanche des titros. Utilisâd « # » por los comentèros.',
	'titleblacklist-forbidden-edit'   => 'Lo titro « $2 » est dèfendu a la crèacion.
Dens la lista nêre, corrèspond a l’entrâ siuventa : <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'La pâge avouéc lo titro « $2 » pôt pas étre dèplaciê vers « $3 » perce que ceti dèrriér at étâ dèfendu a la crèacion. Dens la lista nêre, corrèspond a l’entrâ siuventa : <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Lo fichiér avouéc lo titro « $2 » est dèfendu a la crèacion. Dens la lista nêre, corrèspond a l’entrâ siuventa : <code>$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|La legne siuventa|Les legnes siuventes}} dens la lista nêre des titros {{PLURAL:$1|est envalida|sont envalides}} : vos éte envitâ a {{PLURAL:$1|la|les}} corregiér devant que sôvar.',
);

/** Galician (Galego)
 * @author Toliño
 * @author Xosé
 * @author Alma
 */
$messages['gl'] = array(
	'titleblacklist-desc'             => 'Permite prohibir a creación de páxinas con títulos especificados: [[MediaWiki:Titleblacklist]] e [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Esta é unha listaxe negra de títulos. Non se pode crear ningún título que coincida cunha destas expresións regulares.
# Use "#" para os comentarios.',
	'titlewhitelist'                  => '# Este é un título da listaxe branca. Use "#" para os comentarios',
	'titleblacklist-forbidden-edit'   => 'O título "$2" foi protexido fronte á súa creación. Coincide coa seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" non pode ser movido a "$3", porque o título "$3" foi protexido fronte á súa creación. Coincide coa seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'O nome de arquivo "$2" foi protexido fronte á súa creación. Coincide coa seguinte entrada da lista negra: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|A seguinte liña|As seguintes liñas}} da lista negra {{PLURAL:$1|é inválida|son inválidas}}; por favor  {{PLURAL:$1|corríxaa|corríxaas}} antes de gardar:',
	'right-tboverride'                => 'Ignorar os títulos da listaxe negra (blacklist)',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'titleblacklist-desc'             => 'הוספת אפשרות לאיסור יצירת דפים עם הכותרות המצוינות: [[MediaWiki:Titleblacklist]] ו־[[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# זוהי רשימת הכותרות האסורות. לא ניתן ליצור כותרות שמתאימות לביטוי רגולרי המופיע כאן.
# השתמשו בסימן "#" להערות.',
	'titlewhitelist'                  => '# זוהי רשימת הכותרות המותרות. השתמשו בסימן "#" להערות.',
	'titleblacklist-forbidden-edit'   => 'הכותרת "$2" היא כותרת אסורה ליצירה.
היא מתאימה לערך הבא ברשימת הכותרות האסורות: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'לא ניתן להעביר את "$2" לשם "$3", כיוון שהכותרת "$3" אסורה ליצירה.
היא מתאימה לערך הבא ברשימת הכותרות האסורות: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'שם הקובץ "$2" נאסר ליצירה.
הוא מתאים לערך הבא ברשימת הכותרות האסורות: <code>$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|השורה הבאה|השורות הבאות}} ברשימת הכותרות האסורות {{PLURAL:$1|אינה תקינה|אינם תקינים}};
אנא תקנו {{PLURAL:$1|אותה|אותן}} לפני השמירה:',
	'right-tboverride'                => 'עקיפת רשימת הכותרות האסורות',
);

/** Hindi (हिन्दी)
 * @author Shyam
 * @author Kaustubh
 */
$messages['hi'] = array(
	'titleblacklist-desc'             => 'विशिष्ठ नामपदों: [[MediaWiki:Titleblacklist]] और [[MediaWiki:Titlewhitelist]] के साथ वाले पृष्ठों के निर्माण अवरोधन में सहायक है',
	'titleblacklist'                  => '# यह एक ब्लैकलिस्ट नामपद है। नामपद जो ब्लैकलिस्ट सूची से मेल खाता है, निर्मित नहीं किए जा सकते।
# टिपण्णी के लिए "#" का प्रयोग करें।',
	'titlewhitelist'                  => '# यह टाईटल व्हाईटलिस्ट हैं। टिप्पणीयों के लिये "#" का इस्तेमाल करें।',
	'titleblacklist-forbidden-edit'   => 'नामपद "$2" निर्मित करने से प्रतिबंधित है।
यह निम्नांकित ब्लैकलिस्ट प्रवेशिका से मेल खाता है: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" का नाम बदलकर "$3" नहीं किया जा सकता, क्योंकि "$3" को निर्माण करने से प्रतिबंधित किया गया है।
यह निम्नांकित ब्लैकलिस्ट प्रवेशिका से मेल खाता है: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'फाइल नाम "$2" निर्मित करने से प्रतिबंधित है।
यह निम्नांकित ब्लैकलिस्ट प्रवेशिका से मेल खाता है: <code>$1</code>',
	'titleblacklist-invalid'          => 'ब्लैकलिस्ट नामपद में निम्नांकित {{PLURAL:$1|पंक्ति|पंक्तियाँ}} अमान्य {{PLURAL:$1|है|हैं}};
कृपया {{PLURAL:$1|इसे|इन्हें}} जमा करने से पहले ठीक करें:',
	'right-tboverride'                => 'शीर्षक ब्लॅकलिस्ट को नजर अंदाज करें',
);

/** Croatian (Hrvatski)
 * @author Dnik
 * @author SpeedyGonsales
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'titleblacklist-desc'             => 'Onemogućava stvaranje stranica s određenim naslovima: [[MediaWiki:Titleblacklist]] i [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Ovo je popis zabranjenih naslova. Naslovi koji se podudaraju s regularnim izrazom se ne mogu kreirati.
# Koristite "#" za komentare.',
	'titlewhitelist'                  => "# Ovo je tzv. ''bijela knjiga'' ili ''whitelist'' imena članaka. Rabite \"#\" za komentar",
	'titleblacklist-forbidden-edit'   => 'Naslov "$2" je zabranjen za kreiranje.  Podudara se sa sljedećom stavkom popisa zabranjenih: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" ne može biti premješten na "$3", jer je naslov "$3" zabranjeno kreirati. Podudara se sa sljedećom stavkom popisa zabranjenih: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Ime datoteke "$2" je zabranjeno kreirati. Poklapa se sa stavkom popisa zabranjenih: <code>\\$1</code>',
	'titleblacklist-invalid'          => 'Sljedeći {{PLURAL:$1|redak|redci}} u popisu zabranjenih naslova {{PLURAL:$1|je|su}} nedozvoljeni; molimo ispravite {{PLURAL:$1|ga|ih}} prije spremanja:',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'titleblacklist-desc'             => 'Dowola wutworjenje stronow z podatymi titulemi zakazać: [[MediaWiki:Titleblacklist]] a [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# To je čorna lisćina nastawkowych mjenow. Titule, kotrež so na regularny wuraz hodźa,  njehodźa so wutworjeć.
# Wužij "#" za komentary.',
	'titlewhitelist'                  => '# Tuta je běła lisćina titulow. Wužij "#" za komentary',
	'titleblacklist-forbidden-edit'   => 'Strona z titulom "$2" njeda so wutworić. Wotpowěduje slědowacemu zapiskej čorneje lisćiny: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Strona z titulom "$2" njeda so do "$3" přesunyć, dokelž titul "$3" njesmě so wutworjeć.
Kryje so ze slědowacym zaspiskom čorneje lisćiny: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Dataja z mjenom "$2" njesmě so wutworjeć. Kryje so ze slědowacym zapiskom čorneje lisćiny: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Slědowaca linka|Slědowace linki}} w čornej lisćinje titulow {{PLURAL:$1|je njepłaćiwa|su njepłaćiwe}}; prošu skoriguj {{PLURAL:$1|ju|je}} před składowanjom:',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Tgr
 */
$messages['hu'] = array(
	'titleblacklist-desc'             => 'Lehetővé teszi adott címmel rendelkező lapok elkészítését: [[MediaWiki:Titleblacklist]] és [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Ez a címek feketelistája. Azon címek, amelyek illeszkednek az itt található reguláris kifejezésekre, nem hozhatóak létre.
# Használd a „#” karaktert megjegyzések írásához.',
	'titlewhitelist'                  => '# Ez egy engedélyező lista. A # karakterrel írhatsz megjegyzéseket.',
	'titleblacklist-forbidden-edit'   => '„$2” címmel tilos lapot készíteni, mert illeszkedik a feketelista <code>$1</code> bejegyzésére.',
	'titleblacklist-forbidden-move'   => '„$2” nem nevezhető át „$3” névre, mert „$3” névvel tilos lapot készíteni. Illeszkedik a következő feketelistás bejegyzéssel: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '„$2” nevű fájlt tilos feltölteni, mert illeszkedik a feketelista <code>$1</code> bejegyzésére.',
	'titleblacklist-invalid'          => 'Az alábbi {{PLURAL:$1|sor hibás|sorok hibásak}} a lapcímek feketelistájában; {{PLURAL:$1|javítsd|javítsd őket}} mentés előtt:',
	'right-tboverride'                => 'címek feketelistájának figyelmen kívül hagyása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'titleblacklist-desc'             => 'Permitte prohibir le creation de paginas con titulos specificate: [[MediaWiki:Titleblacklist]] e [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Isto es un lista nigre de titulos. Le titulos que corresponde a un regex
# includite hic non pote esser create. Usa "#" pro commentos.',
	'titlewhitelist'                  => '# Isto es un lista blanc de titulos. Usa "#" pro commentos.',
	'titleblacklist-forbidden-edit'   => 'Le creation del titulo "$2" ha essite prohibite.
Illo corresponde al sequente entrata del lista nigre: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" non pote esser renominate a "$3", proque le creation del titulo "$3" ha essite prohibite.
Illo corresponde al sequente entrata del lista nigre: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Le creation del nomine de file "$2" ha essite prohibite.
Illo corresponde al sequente entrata del lista nigre: <code>\\$1</code>',
	'titleblacklist-invalid'          => 'Le sequente {{PLURAL:$1|linea|lineas}} in le lista nigre de titulos es invalide; per favor corrige {{PLURAL:$1|lo|los}} ante de immagazinar:',
	'right-tboverride'                => 'Ultrapassar le lista nigre de titulos',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'titleblacklist-desc'             => 'Mengizinkan pencegahan pembuatan halaman dengan judul tertentu: [[MediaWiki:Titleblacklist]] dan [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Berikut adalah daftar hitam judul. Judul yang sesuai dengan suatu regex berikut tidak akan dibuat.
# Gunakan "#" untuk komentar.
',
	'titlewhitelist'                  => '# Ini adalah daftar putih. Gunakan "#" untuk komentar',
	'titleblacklist-forbidden-edit'   => 'Judul "$2" telah dicekal untuk dibuat. Judul tersebut cocok dengan entri daftar hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" tak dapat dipindahkan ke "$3" karena judul "$3" telah dicekal untuk dibuat. Judul tersebut cocok dengan entri daftar hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Nama berkas "$2" telah dicekal untuk dibuat. Judul tersebut cocok dengan entri daftar hitam berikut: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Baris|Baris-baris}} dalam daftar hitam judul {{PLURAL:$1|berikut|berikut}} tak valid; silakan koreksi {{PLURAL:$1|item|item-item}} tersebut sebelum disimpan:',
	'right-tboverride'                => 'Abaikan daftar hitam judul',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Siebrand
 */
$messages['it'] = array(
	'titleblacklist-desc'             => 'Consente di proibire la creazione di pagine con i titoli indicati in [[MediaWiki:Titleblacklist]] e [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Lista dei titoli non consentiti.
# È impedita la creazione delle pagine il cui titolo corrisponde a un\'espressione regolare indicata di seguito.
# Usare "#" per le righe di commento.',
	'titlewhitelist'                  => '# Questa è una whitelist dei titoli. Usare "#" per le righe di commento',
	'titleblacklist-forbidden-edit'   => 'La creazione di pagine con titolo "$2" è stata impedita. La voce corrispondente nell\'elenco dei titoli non consentiti è la seguente: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Impossibile spostare la pagina "$2" al titolo "$3" in quanto la creazione di pagine con titolo "$3" è stata impedita. La voce corrispondente nell\'elenco dei titoli non consentiti è la seguente: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'La creazione di file con titolo "$2" è stato impedito. La voce corrispondente nell\'elenco dei titoli non consentiti è la seguente: <code>$1</code>',
	'titleblacklist-invalid'          => "{{PLURAL:$1|La seguente riga|Le seguenti righe}} dell'elenco dei titoli non consentiti {{PLURAL:$1|non è valida|non sono valide}}; si prega di correggere {{PLURAL:$1|l'errore|gli errori}} prima di salvare la pagina.",
	'right-tboverride'                => 'Ignora la blacklist dei titoli',
);

/** Japanese (日本語)
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'titleblacklist-desc'             => '指定したページ名での新規作成を禁止する: [[MediaWiki:Titleblacklist|タイトルブラックリスト]] および [[MediaWiki:Titlewhitelist|タイトルホワイトリスト]]',
	'titleblacklist'                  => '# これは、タイトルブラックリストです。正規表現に一致するタイトルでの新規作成を禁止します。
# "#"以降はコメントとして扱われます。',
	'titlewhitelist'                  => '# これは、タイトルホワイトリストです。"#"以降はコメントとして扱われます。',
	'titleblacklist-forbidden-edit'   => '"$2" という名前での新規作成は禁止されています。これは以下のブラックリスト項目に一致します: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$3" という名前での新規作成は禁止されているため、"$2" を移動することはできません。これは以下のブラックリスト項目に一致します: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" というファイル名でのアップロードは禁止されています。これは以下のブラックリスト項目に一致します: <code>$1</code>',
	'titleblacklist-invalid'          => 'タイトルブラックリスト{{PLURAL:$1|に|に}}不正な{{PLURAL:$1|行が|行が複数}}存在します。保存する前に{{PLURAL:$1|これ|これら}}を修正してください:',
);

/** Jutish (Jysk)
 * @author Huslåke
 * @author Ælsån
 */
$messages['jut'] = array(
	'titleblacklist-desc' => 'Kan til førbæd skeppenge der pæger ve spæsifiærn titler: [[MediaWiki:Titleblacklist]] og [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'      => '# Dett\'er en titel blackliste. Titler dette match en regex her ken ekke være skeppen.
# Brug "#" før bemærkenge.',
	'titlewhitelist'      => '# Dett\'er en titel whiteliste. Brug "#" før bemærkenge',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'titleblacklist-desc'             => 'Marengaké pamenggakan nggawé kaca mawa irah-irahan tartamtu: [[MediaWiki:Titleblacklist]] lan [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Ing ngisor iki kapacak daftar ireng irah-irahan. Irah-irahan sing cocog karo sawijining regex ing kéné ora bisa digawé.
# Enggonen "#" kanggo komentar.',
	'titlewhitelist'                  => '# Daftar iki yaiku daftar putih irah-irahan. Enggonen "#" kanggo komentar',
	'titleblacklist-forbidden-edit'   => 'Irah-irahan "$2" dilarang digawé.
Irah-irahan iki cocog karo èntri daftar ireng iki: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" ora bisa dipindhahaké menyang "$3", amerga irah-irahan iki "$3" dilarang ora olèh digawé.
Irah-irahan iki soalé cocog karo èntri daftar ireng iki: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Jeneng berkas "$2" wis dilarang kanggo digawé. 
Irah-irahan iku cocog karo èntri daftar ireng iki: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Baris|Baris-baris}} ing daftar ireng irah-irahan (judhul) {{PLURAL:$1|ing ngisor|ing ngisor}} iki ora absah; mangga dikorèksi {{PLURAL:$1|item|item-item}} iku sadurungé disimpen:',
	'right-tboverride'                => "''Override'' daftar ireng judhul",
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'titleblacklist'                  => '# بۇل اتاۋلاردىڭ قارا ٴتىزىمى. جۇيەلى ايتىلىمدارعا (regex) سايكەس مىنداعى اتاۋلار جاراتىلمايدى.
ماندەمەلەر ٴۇشىن «#» نىشانىن قولدانىڭىز.',
	'titlewhitelist'                  => '# بۇل اتاۋلاردىڭ اق ٴتىزىمى. ماندەمەلەر ٴۇشىن «#» نىشانىن قولدانىڭىز',
	'titleblacklist-forbidden-edit'   => '«$2» دەگەن اتاۋ جاراتۋى قۇلىپتالعان.  بۇل قارا ٴتىزىمنىڭ جازباسىنا سايكەس: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '«$2» دەگەن «$3» دەگەنگە جىلجىتىلمايدى, سەبەبى «$3» دەگەن اتاۋ جاراتۋى قۇلىپتالعان. بۇل قارا ٴتىزىمنىڭ جازباسىنا سايكەس: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '«$2» دەگەن فايل اتى جاراتۋى قۇلىپتالعان.  بۇل قارا ٴتىزىمنىڭ جازباسىنا سايكەس: <code>$1</code>',
	'titleblacklist-invalid'          => 'اتاۋلاردىڭ قارا تىزىمىندەگى كەلەسى {{PLURAL:$1|جول|جولدار}} {{PLURAL:$1||}} جارامسىز; ساقتاۋ الدىندا {{PLURAL:$1|بۇنى|بۇلاردى}} دۇرىستاپ شىعىڭىز:',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic))
 * @author AlefZet
 */
$messages['kk-cyrl'] = array(
	'titleblacklist'                  => '# Бұл атаулардың қара тізімі. Жүйелі айтылымдарға (regex) сәйкес мындағы атаулар жаратылмайды.
Мәндемелер үшін «#» нышанын қолданыңыз.',
	'titlewhitelist'                  => '# Бұл атаулардың ақ тізімі. Мәндемелер үшін «#» нышанын қолданыңыз',
	'titleblacklist-forbidden-edit'   => '«$2» деген атау жаратуы құлыпталған.  Бұл қара тізімнің жазбасына сәйкес: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '«$2» деген «$3» дегенге жылжытылмайды, себебі «$3» деген атау жаратуы құлыпталған. Бұл қара тізімнің жазбасына сәйкес: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '«$2» деген файл аты жаратуы құлыпталған.  Бұл қара тізімнің жазбасына сәйкес: <code>$1</code>',
	'titleblacklist-invalid'          => 'Атаулардың қара тізіміндегі келесі {{PLURAL:$1|жол|жолдар}} {{PLURAL:$1||}} жарамсыз; сақтау алдында {{PLURAL:$1|бұны|бұларды}} дұрыстап шығыңыз:',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'titleblacklist'                  => '# Bul atawlardıñ qara tizimi. Jüýeli aýtılımdarğa (regex) säýkes mındağı atawlar jaratılmaýdı.
Mändemeler üşin «#» nışanın qoldanıñız.',
	'titlewhitelist'                  => '# Bul atawlardıñ aq tizimi. Mändemeler üşin «#» nışanın qoldanıñız',
	'titleblacklist-forbidden-edit'   => '«$2» degen ataw jaratwı qulıptalğan.  Bul qara tizimniñ jazbasına säýkes: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '«$2» degen «$3» degenge jıljıtılmaýdı, sebebi «$3» degen ataw jaratwı qulıptalğan. Bul qara tizimniñ jazbasına säýkes: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '«$2» degen faýl atı jaratwı qulıptalğan.  Bul qara tizimniñ jazbasına säýkes: <code>$1</code>',
	'titleblacklist-invalid'          => 'Atawlardıñ qara tizimindegi kelesi {{PLURAL:$1|jol|joldar}} {{PLURAL:$1||}} jaramsız; saqtaw aldında {{PLURAL:$1|bunı|bulardı}} durıstap şığıñız:',
);

/** Korean (한국어)
 * @author ToePeu
 */
$messages['ko'] = array(
	'titleblacklist-desc'           => '특정 제목의 문서를 만드는 것을 막습니다. 
[[MediaWiki:Titleblacklist]]과 [[MediaWiki:Titlewhitelist]]를 사용합니다.',
	'titleblacklist-forbidden-edit' => '"$2"는 만들기가 금지된 제목입니다.
다음과 일치합니다: <code>$1</code>',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'right-tboverride' => 'De Liss met verbodde Sigge-Name övverjonn',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'titleblacklist'                  => '# Hic est index titulorum prohibitorum. Tituli qui congruunt cum
# una ex expressionibus regularis sequentibus creari non possunt.
# Utere "#" pro commentariis.',
	'titlewhitelist'                  => '# Hic est index titulorum permissorum. Utere "#" pro commentariis',
	'titleblacklist-forbidden-edit'   => 'Pagina cum titulo "$2" creari non potest. Hic titulus congruit cum expressione regulari: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Pagina cum titulo "$2" non ad "$3" moveri potest, quia titulus "$3" prohibitus est ne pagina creetur. Hic titulus congruit cum expressione regulari: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Fasciculus cum titulo "$2" onerari non potest. Hic titulus congruit cum expressione regulari: <code>\\$1</code>',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'titleblacklist-desc'           => "Erlaabt et d'Ulleeë vu Säite mat spezifischen Titelen ze verbidden: [[MediaWiki:Titleblacklist]] and [[MediaWiki:Titlewhitelist]]",
	'titleblacklist'                => '# Dëst ass een Titel deen op enger schwaarzer Lëscht steet.
# All Titel op den dës Ausdréck passe kann net ugeluecht ginn
# Benotzt "#" fir Bemierkungen ze schreiwen',
	'titlewhitelist'                => "# Dëst ass d'''Whitelist'' vun den Titelen. Benotzt \"#\" fir Bemierkungen.",
	'titleblacklist-forbidden-edit' => 'Den Titel "$2" dàerf net ugeluecht ginn.
En ass op der schwaarzer Lëscht wéint folgendem Begrëff: <code>$1</code>',
	'right-tboverride'              => "Ignoréiert d'schwaarz Lëscht vun den Titelen",
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'titleblacklist-desc'             => "Voorkomt het aanmake van pagina's met aangegeve name: [[MediaWiki:Titleblacklist]] en [[MediaWiki:Titlewhitelist]]",
	'titleblacklist'                  => '# Dit is een zwarte lijst voor paginanamen. Iedere paginanaam die voldoet aan een regex kan niet aangemaakt en bewerkt worden.
# Gebruik "#" voor opmerkingen.',
	'titlewhitelist'                  => '# Dit is een witte lijst voor paginanamen. Gebruik "#" voor opmerkingen.',
	'titleblacklist-forbidden-edit'   => 'Een pagina met de naam "$2" kan niet aangemaakt worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" kan niet hernoemd worden naar "$3", omdat pagina\'s met de naam "$3" niet aangemaakt kunnen worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Het bestand "$2" kan niet toegevoegd worden. Deze bestandsnaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-invalid'          => 'De volgende {{PLURAL:$1|regel|regels}} in de zwarte lijst veur paginaname {{PLURAL:$1|is|zijn}} ongeldig. Verbeter die {{PLURAL:$1|regel|regels}} asjeblieft veurdat ge de lijst opslaat:',
	'right-tboverride'                => 'De zwarte lies veur pazjenaname negere',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'titleblacklist-desc'             => 'ചില പ്രത്യേക തലക്കെട്ടുള്ള താളുകള്‍ സൃഷ്ടിക്കുന്നത് തടയാന്‍ സഹായിക്കുന്നു: [[MediaWiki:Titleblacklist]], [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# ഇതു തലക്കെട്ടിന്റെ കരിമ്പട്ടികയാണ്‌. ഈ പട്ടികയിലുള്ള ഇനവുമായി  യോജിക്കുന്ന ലേഖനങ്ങള്‍ സൃഷ്ടിക്കാനാവില്ല. 
# അഭിപ്രായത്തിനു "#" ഉപയോഗിക്കുക.',
	'titleblacklist-forbidden-edit'   => '"$2" എന്ന തലക്കെട്ട് സൃഷ്ടിക്കുന്നതു നിരോധിച്ചിട്ടുള്ളതാണ്‌. ആ തലക്കെട്ട് താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന കരിമ്പട്ടിക ഇനവുമായി യോജിക്കുന്നു: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$3" എന്ന തലക്കെട്ട് സൃഷ്ടിക്കുന്നതു നിരോധിച്ചിട്ടുള്ളതിനാല്‍, "$2" എന്ന താള്‍ "$3" എന്ന തലക്കെട്ടിലേക്കു മാറ്റാന്‍ പറ്റില്ല. ആ തലക്കെട്ട് താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന കരിമ്പട്ടിക ഇനവുമായി യോജിക്കുന്നു: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" എന്ന നാമം പ്രമാണത്തിനു കൊടുക്കുന്നത് നിരോധിച്ചിട്ടുള്ളതാണ്‌.
ആ നാമം താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന കരിമ്പട്ടിക ഇനവുമായി യോജിക്കുന്നു: <code>\\$1</code>',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'titleblacklist-desc'             => '[[MediaWiki:Titleblacklist]] व [[MediaWiki:Titlewhitelist]] मध्ये दिलेल्या शीर्षकांचे लेख बनविण्यापासून रोखा',
	'titleblacklist'                  => '# ही ब्लॉक केलेल्या शीर्षकांची यादी आहे. या यादीत असलेल्या शीर्षकांचे लेख लिहिता येणार नाहीत.
# शेरा देण्यासाठी "#" वापरा.',
	'titlewhitelist'                  => '# ही वापरू शकत असलेल्या शीर्षकांची यादी आहे. शेरा देण्यासाठी "#" वापरा',
	'titleblacklist-forbidden-edit'   => '"$2" या शीर्षकाचा लेख बनवू शकत नाही. खाली ब्लॉक केलेल्या शीर्षकांच्या यादीतील नोंद आहे:
<code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" चे "$3" ला स्थानांतरण होऊ शकत नाही, कारण "$3" हे ब्लॉक केलेल्या शीर्षकांच्या यादीत आहे. खाली ब्लॉक केलेल्या शीर्षकांच्या यादीतील नोंद आहे: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" या शीर्षकाची संचिका बनवू शकत नाही. खाली ब्लॉक केलेल्या शीर्षकांच्या यादीतील नोंद आहे:
<code>$1</code>',
	'titleblacklist-invalid'          => 'शीर्षक ब्लॉक यादीतील खालील {{PLURAL:$1|ओळ चुकीची आहे|ओळी चुकीच्या आहेत}}; कृपया जतन करण्यापूर्वी {{PLURAL:$1|ती|त्या}} दुरुस्त करा:',
	'right-tboverride'                => 'शीर्षक ब्लॅकयादी कडे दुर्लक्ष करा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'titleblacklist-desc'             => 'Membolehkan pengharaman tajuk-tajuk laman tertentu: [[MediaWiki:Titleblacklist]] dan [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Ini ialah senarai hitam tajuk. Tajuk yang sepadan dengan mana-mana ungkapan nalar di sini akan disekat daripada dicipta.
# Gunakan "#" untuk komen.',
	'titlewhitelist'                  => '# Ini ialah senarai putih tajuk. Gunakan "#" untuk komen.',
	'titleblacklist-forbidden-edit'   => 'Tajuk "$2" telah diharamkan.
Tajuk tersebut sepadan dengan entri senarai hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" tidak boleh dipindahkan ke "$3" kerana tajuk "$3" telah diharamkan.
Tajuk tersebut sepadan dengan entri senarai hitam berikut: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Nama fail "$2" telah diharamkan.
Nama tersebut sepadan dengan entri senarai hitam berikut: <code>$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Baris|Baris-baris}} berikut adalah tidak sah. Sila betulkannya sebelum menyimpan:',
	'right-tboverride'                => 'Mengatasi senarai hitam tajuk',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'titleblacklist'   => '# Dit is de Swartlist vun Siedennaams, de nich opstellt warrn schöölt. Naams, op de disse regulären Utdrück todrepen doot, köönt nich opstellt warrn.
# Bruuk „#“ för Kommentaren.',
	'titlewhitelist'   => '# Dit is en Wittlist mit Utnahmen vun de Swartlist vun Siedennaams, de nich opstellt warrn schöölt. Bruuk „#“ för Kommentaren',
	'right-tboverride' => 'De swarte List för Siedennaams ümgahn',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'titleblacklist-desc'             => "Voorkomt het aanmaken van pagina's met aangegeven namen: [[MediaWiki:Titleblacklist]] en [[MediaWiki:Titlewhitelist]]",
	'titleblacklist'                  => '# Dit is een zwarte lijst voor paginanamen. Iedere paginanaam die voldoet aan een regex kan niet aangemaakt en bewerkt worden.
# Gebruik "#" voor opmerkingen.',
	'titlewhitelist'                  => '# Dit is een witte lijst voor paginanamen. Gebruik "#" voor opmerkingen.',
	'titleblacklist-forbidden-edit'   => 'Een pagina met de naam "$2" kan niet aangemaakt worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" kan niet hernoemd worden naar "$3", omdat pagina\'s met de naam "$3" niet aangemaakt kunnen worden. Deze paginanaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Het bestand "$2" kan niet toegevoegd worden. Deze bestandsnaam voldoet aan de volgende beperking op de zwarte lijst: <code>$1</code>',
	'titleblacklist-invalid'          => 'De volgende {{PLURAL:$1|regel|regels}} in de zwarte lijst voor paginanamen {{PLURAL:$1|is|zijn}} ongeldig. Verbeter die {{PLURAL:$1|regel|regels}} alstublieft voordat u de lijst opslaat:',
	'right-tboverride'                => 'De zwarte lijst voor paginanamen negeren',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'titleblacklist-desc'             => 'Gir muligheten til å forhindre at sider med visse titler opprettes, ved å bruke [[MediaWiki:Titleblacklist]] og [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Dette er en svartlisting for titler. Titler som passer med regulære uttrykk her kan ikke opprettes.
# Bruk «#» for kommentarer.',
	'titlewhitelist'                  => '# Dette er en hvitelisting for titler. Bruk «#» for kommentarer.',
	'titleblacklist-forbidden-edit'   => 'Tittelen «$2» er stengt for oppretting. Den blokkeres av følgende svartelistingselement: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '«$2» kan ikke flyttes til «$3» fordi tittelen «$3» har blitt stengt for oppretting. Den tilsvarer følgende element i svartelistinga: <code>$1</code<',
	'titleblacklist-forbidden-upload' => 'Filnavnet «$2» er blokkert for oppretting. Den tilsvarer følgende svartelisteelement: <code>\\$1</code>',
	'titleblacklist-invalid'          => 'Følgende {{PLURAL:$1|linje|linjer}} i tittelsvartelista er {{PLURAL:$1|ugyldig|ugyldige}}; vennligst korriger {{PLURAL:$1|den|dem}} før du lagrer:',
	'right-tboverride'                => 'Overkjøre tittelsvartelisten',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'titleblacklist-desc'             => "Permet d'interdire la creacion de paginas en foncion d'una [[MediaWiki:Titleblacklist|lista negra]] e d'una [[MediaWiki:Titlewhitelist|lista blanca]] de títols",
	'titleblacklist'                  => '# Aquò es un títol mes en lista negra. Cada títol qu\'indica aicí lo còde regex es interdich a la creacion e a l\'edicion.
# Utilizatz "#" per escriure de comentaris.',
	'titlewhitelist'                  => '# Aquò es la lista blanca dels títols. Utilizatz « # » pels comentaris.',
	'titleblacklist-forbidden-edit'   => "La pagina intitolada « $2 » pòt pas èsser creada. Dins la lista negra, correspon a l'expression racionala : <code>$1</code>",
	'titleblacklist-forbidden-move'   => 'La page intitolada "$2" pòt pas èsser renomenada "$3". Dins la lista negra, correspon a l\'expression racionala : <code>$1</code>',
	'titleblacklist-forbidden-upload' => "'''Un fichièr nomenat \"\$2\" pòt pas èsser telecargat.''' <br /> Dins la lista negra, correspon a l'expression racionala :  <code>\\\$1</code>",
	'titleblacklist-invalid'          => '{{PLURAL:$1|La linha seguenta|Las linhas seguentas}} dins la lista negra dels títols {{PLURAL:$1|es invalida|son invalidas}} : sètz convidat a {{PLURAL:$1|la|las}} corregir abans de salvar.',
	'right-tboverride'                => 'Ignorar la lista negra dels títols',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Beau
 */
$messages['pl'] = array(
	'titleblacklist-desc'             => 'Pozwala zabezpieczyć przed możliwością utworzenia stron o określonych tytułach: [[MediaWiki:Titleblacklist]] i [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# To jest lista zabronionych nazw artykułów. Artykuły o nazwach odpowiadających tym wzorcom, zapisanym wyrażeniami regularnymi, nie będą mogły zostać utworzone.
# Użyj znaku „#” by utworzyć komentarz.',
	'titlewhitelist'                  => '# To jest lista dopuszczalnych nazw artykułów.
# Użyj znaku „#” by utworzyć komentarz.',
	'titleblacklist-forbidden-edit'   => 'Nie wolno utworzyć artykułu o nazwie „$2”. Pasuje ona do następującego wzorca z listy nazw zabronionych: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Zmiana nazwy z „$2” na „$3” nie jest możliwa, ponieważ nazwa „$3” jest zabroniona. Pasuje ona do następującego wzorca z listy nazw zabronionych: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Utworzenie pliku o nazwie „$2” nie jest możliwe. Nazwa pasuje do następującego wzorca z listy nazw zabronionych: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Następująca linia|Następujące linie}} na liście zabronionych tytułów stron {{PLURAL:$1|jest nieprawidłowa|są nieprawidłowe}}. Popraw {{PLURAL:$1|ją|je}} przed zapisaniem:',
	'right-tboverride'                => 'Wyłącza ograniczenia nakładane przez rozszerzenie Title Blacklist, które blokuje tworzenie oraz edycję artykułów o nazwach pasujących do zdefiniowanych wzorców',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 */
$messages['pt'] = array(
	'titleblacklist-desc'             => 'Permite a proibição da criação de páginas com títulos específicos: [[MediaWiki:Titleblacklist]] e [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Esta é uma lista negra de títulos. Títulos que se encaixem em uma regex não poderão ser criados.
# Utilize "#" para fazer comentários.',
	'titlewhitelist'                  => '# Esta é uma lista branca de títulos. Utilize "#" para fazer comentários',
	'titleblacklist-forbidden-edit'   => 'O título "$2" foi impedido de ser criado. Ele se encaixa na seguinte entrada da lista negra: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" não pode ser movida para "$3" já que "$3" é um título impedido de ser criado. Se encaixa na seguinte entrada da lista-negra: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'O ficheiro "$2" foi impedido de ser criado. Ele se encaixa na seguinte entrada da lista negra: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|A seguinte linha|As seguintes linhas}} da lista negra {{PLURAL:$1|é inválida|são inválidas}}. Por gentileza, {{PLURAL:$1|corrija-a|corrija-as}} antes de salvar:',
	'right-tboverride'                => 'Sobrepor a lista negra de títulos',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'titleblacklist-desc'             => 'Позволяет запретить создание страниц с указанными названиями: [[MediaWiki:Titleblacklist]] и [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Это список запрещённый названий
# Любая статья, название которой попадает под этот список, не может быть создана
# Используйте « # » для комментариев',
	'titlewhitelist'                  => '# Это «белый список» названий. Для комментариев используйте «#»',
	'titleblacklist-forbidden-edit'   => "
<div align=\"center\" style=\"border: 1px solid #f88; padding: 0.5em; margin-bottom: 3px; font-size: 95%; width: auto;\">
'''Страница с названием \"\$2\" не может быть создана''' <br />
Она попадает под следующую запись списка запрещенных названий: '''''\$1'''''
</div>",
	'titleblacklist-forbidden-move'   => 'Невозможно переименовать страницу «$2» в «$3». Запрещено создавать статьи с заголовком «$3».
Запрет соответствует следующей записи в чёрном списке: <code>$1</code>',
	'titleblacklist-forbidden-upload' => "
'''Файл с названием \"\$2\" не может быть загружен''' <br />
Он попадает под следующую запись списка запрещенных названий: '''''\$1'''''",
	'titleblacklist-invalid'          => '{{PLURAL:$1|Следующая строка|Следующие строки}} в списке запрещенный названий {{PLURAL:$1|не является правильным регулярным выражением|не являются правильными регулярными выражениями}}. Пожалуйста, исправьте {{PLURAL:$1|её|их}} перед сохранением:',
	'right-tboverride'                => 'игнорирование чёрного списка имён страниц',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'titleblacklist-desc'             => 'Манна ааттаммыт сирэйдэри айыыны/оҥорууну бобор: [[MediaWiki:Titleblacklist]] уонна [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Бу бобуллубут ааттар испииһэктэрэ. Бу испииһэккэ киирбит ханнык баҕарар ыстатыйа оҥоһуллар кыаҕа суох.
# Ырытарга « # » бэлиэни туһаныҥ.',
	'titlewhitelist'                  => '# Бу ааттар «үрүҥ испииһэктэрэ». Ырытарга «#» бэлиэни туһаныҥ.',
	'titleblacklist-forbidden-edit'   => "<div align=\"center\" style=\"border: 1px solid #f88; padding: 0.5em; margin-bottom: 3px; font-size: 95%; width: auto;\">
'''Маннык ааттаах сирэй \"\$2\" кыайан оҥоһуллубат''' <br />
Бобуллубут ааттар испииһэктэригэр киирэр: '''''\$1'''''
</div>",
	'titleblacklist-forbidden-move'   => "<span class=\"error\">
'''Маннык ааттаах сирэй \"\$2\" маннык ааттанар \"\$3\" кыаҕа суох, тоҕо диэтэххэ \"\$3\" оҥоһуллара бобуллубут''' <br />
Бобуллубут ааттар испииһэктэригэр киирэр: '''''\$1'''''
</span>",
	'titleblacklist-forbidden-upload' => "'''Маннык ааттаах билэ \"\$2\" кыстанар (киллэриллэр) кыаҕа суох''' <br />
Бобуллубут ааттар испииһэктэригэр киирэр: '''''\$1'''''",
	'titleblacklist-invalid'          => 'Бобуллубут ааттар испииһэктэрин бу {{PLURAL:$1|строката|строкаалара}} {{PLURAL:$1|сыыһалаах|сыыһалаахтар}}. Бука диэн ону көннөр:',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'titleblacklist-desc'             => 'Umožňuje zakázať tvorbu stránok s určenými názvami: [[MediaWiki:Titleblacklist|Čierna listina názvov]] a [[MediaWiki:Titlewhitelist|Biela listina názvov]]',
	'titleblacklist'                  => '# Toto je čierna listina názvov stránok. Názvy, ktoré zodpovedajú tu uvedenému regulárnemu výrazu nebude možné vytvoriť.
# Komentáre začínajú znakom „#“.',
	'titlewhitelist'                  => '# Toto je biela listina názvov stránok. Riadky komentárov začínajú znakom „#“',
	'titleblacklist-forbidden-edit'   => 'Vytvorenie stránky z názovom „$2“ bolo zakázané. Zodpovedá tejto položke čiernej listiny: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '„$2“ nie je možné presunúť na „$3“, pretože vytvorenie stránky z názovom „$3“ bolo zakázané. Zodpovedá tejto položke čiernej listiny: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Bolo zakázané vytvorenie súboru s názvom „$2“. Zodpovedá tejto položke čiernej listiny: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Nasledovný riadok|Nasledovné riadky}} čiernej listiny názvov stránok {{PLURAL:$1|je neplatný|sú neplatné}} a je potrebné {{PLURAL:$1|ho|ich}} opraviť pred uložením stránky:',
	'right-tboverride'                => 'Prekonať čiernu listinu názvov',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'titleblacklist-desc' => 'Допушта забрану стварања страна с одређеним насловима: [[MediaWiki:Titleblacklist]] и [[MediaWiki:Titlewhitelist]].',
	'titleblacklist'      => '# Ово је наслов црног списка. Наслови који садрже регуларни израз из овог списка не могу бити направљени.
# Користи "#" за коментаре.',
	'titlewhitelist'      => '# Ово је бели списак наслова. Користи "#" за коментаре.',
	'right-tboverride'    => 'Преписује црни списак наслова.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'titleblacklist'                  => '# Dit is ju Swotte Lieste fon nit wonskede Siedennoomen.
# Älke Siedennoome, ap dän do foulgjende reguläre Uutdrukke touträffe, kon nit moaked wäide.
# Text bääte ne Ruute „#“ wäd as Kommentoar betrachted.',
	'titleblacklist-forbidden-edit'   => "'''Ne Siede mäd dän Tittel „$2“ kon nit moaked wäide.''' <br />
Die Tittel kollidiert mäd dissen Speerbegriep: '''''$1'''''",
	'titleblacklist-forbidden-move'   => "'''Ju Siede „$2“ kon nit ätter „$3“ ferschäuwen wäide.''' <br />
Die Tittel kollidiert mäd dissen Speerbegriep: '''''$1'''''",
	'titleblacklist-forbidden-upload' => "'''Ne Doatäi mäd dän Noome „$2“ kon nit hoochleeden wäide.''' <br />
Die Tittel kollidiert mäd dissen Speerbegriep: <code>\\$1</code>",
	'titleblacklist-invalid'          => '{{PLURAL:$1|Ju foulgjende Riege|Do foulgjende Riegen}} in ju Speerlieste {{PLURAL:$1|is|sunt}} uungultich; korrigier do foar dät Spiekerjen:',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'titleblacklist-forbidden-edit'   => 'Judul “$2” dicaram dijieun, luyu jeung éntri daptar hideung: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '“$2” teu bisa dipindahkeun ka “$3”, sababa judul “$3” dicaram dijieun, luyu jeung éntri daptar hideung: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Ngaran koropak “$2” dicaram dijieun, luyu jeung éntri daptar hideung: <code>\\$1</code>',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'titleblacklist-desc'             => 'Ger möjlighet att förhindra att sidor med vissa titlar skapas, genom att använda  [[MediaWiki:Titleblacklist]] och [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Det här är en lista över förbjudna sidtitlar. Titlar som matchar ett reguljärt uttryck här kan inte skapas.
# Använd "#" för kommentarer.',
	'titlewhitelist'                  => '# Det är en lista över tillåtna sidtitlar. Använd "#" för att skriva kommentarer.',
	'titleblacklist-forbidden-edit'   => 'Sidtiteln "$2" har stoppats från att skapas. Den matchar följande rad i svarta listan för sidtitlar: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Sidan "$2" kan inte flyttas till "$3", eftersom titeln "$3" har förbjudits att skapas. Titeln matchar följande rad i svarta listan för sidtitlar: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Filnamnet "$2" har stoppats från att skapas. Namnet matchar följande rad i svarta listan för sidtitlar: <code>$1</code>',
	'titleblacklist-invalid'          => 'Följande {{PLURAL:$1|rad|rader}} i listan är {{PLURAL:$1|felaktig|felaktiga}}; {{PLURAL:$1|den|de}} måste rättas innan du kan spara:',
	'right-tboverride'                => 'Upphäva den svarta listan över titlar',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'titleblacklist-desc'             => 'ప్రత్యేకిత శీర్షికలతో పేజీలు తయారుచేయడాన్ని నిరోధించే వీలుకల్పిస్తుంది: [[MediaWiki:Titleblacklist]] మరియు [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# ఇది శీర్షికల నిరోధపు జాబితా. ఇక్కడ ఉన్న regexకి సరిపోలే శీర్షికలు గల పేజీలను సృష్టించలేరు.
# వ్యాఖ్యానించడానికి "#"ని వాడండి.',
	'titlewhitelist'                  => '# ఇది అనుమతించే శీర్షికల జాబితా. వ్యాఖ్యానించడానికి "#"ని వాడండి',
	'titleblacklist-forbidden-edit'   => '"$2" అనే శీర్షిక గల పేజీలను సృష్టించడంపై నిషేధం విధించారు. ఇది నిరోధపు జాబితాలోని ఈ పద్దుకి సరిపోలింది: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2"ని "$3"కి తరలించలేము, ఎందుకంటే "$3" అన్న శీర్షికని సృష్టించడంపై నిషేధం ఉంది. ఇది నిరోధపు జాబితాలోని ఈ పద్దుకి సరిపోలుతుంది: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '"$2" అన్న పేరు గల ఫైలుని సృష్టించడాన్ని నిషేధించారు. ఇది నిషేధపు జాబితాలోని ఈ పద్దుకి సరిపోలుతుంది: <code>\\$1</code>',
	'titleblacklist-invalid'          => 'శీర్షికల నిరోధపు జాబితాలోని ఈ క్రింద పేర్కొన్న {{PLURAL:$1|లైను|లైన్లు}} తప్పుగా {{PLURAL:$1|ఉంది|ఉన్నాయి}}; భద్రపరిచేముందు {{PLURAL:$1|దాన్ని|వాటిని}} సరిదిద్దండి:',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'titleblacklist-desc'             => 'Имкони пешгирӣ аз эҷоди саҳифахое бо унвонҳои хосро медиҳад: [[MediaWiki:Titleblacklist]] ва [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Ин як феҳристи сиёҳ барои унвонҳо аст. Унвонҳое, ки бо як regex дар ин саҳифа мутобиқаткунандаро наметавон эчод кард.
# Барои илова кардани тавзеҳот аз "#" истифода кунед.',
	'titlewhitelist'                  => '# Ин як феҳристи сафед барои унвонҳо аст. Барои илова кардани тавзеҳот аз "#" истифода кунед',
	'titleblacklist-forbidden-edit'   => 'Эҷоди унвони "$2" манъ шудааст.  Ин унвон бо ин дастур аз феҳристи сиёҳ мутобиқат мекунад: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" наметавонад ба "$3" кӯчонида шавад, зеро эҷоди унвони "$3" манъ шудааст. Чун бо ин дастур аз феҳристи сиёҳ мутобиқат мекунад: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Эҷоди номи "$2" барои парвандаҳо манъ аст. Он бо ин дастур аз фехристи сиёҳи зерин мутобиқат мекунад: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Сатри|Сатрҳои}} зерин дар феҳристи сиёҳи унвонҳо ғайримиҷоз {{PLURAL:$1|аст|ҳастанд}}; лутфан {{PLURAL:$1|он|онҳо}}ро қабл аз захира кардан, ислоҳ кунед:',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'right-tboverride' => 'ігнорування чорного списку назв сторінок',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'titleblacklist-desc'             => 'Consente de proibir la creazion de pagine con i titoli indicà in [[MediaWiki:Titleblacklist]] e [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Lista dei titoli mìa consentìi.
# Xe inpedìa la creazion de le pagine el cui titolo el corisponde a na espression regolar indicà de seguito.
# Dòpara "#" par le righe de comento.',
	'titlewhitelist'                  => '# Sta qua la xe na lista bianca dei titoli. Dòpara "#" par le righe de comento',
	'titleblacklist-forbidden-edit'   => 'La creazion de pagine con titolo "$2" la xe stà inpedìa. La voçe corispondente ne l\'elenco dei titoli mìa consentìi la xe sta chì: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'No se pode spostar la pagina "$2" al titolo "$3" in quanto la creazion de pagine con titolo "$3" la xe stà inpedìa. La voçe corispondente ne l\'elenco dei titoli mìa consentìi la xe sta chì: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'La creazion de file con titolo "$2" la xe stà inpedìa. La voçe corispondente ne l\'elenco dei titoli mìa consentìi la xe sta chì: <code>$1</code>',
	'titleblacklist-invalid'          => "{{PLURAL:$1|La seguente riga|Le seguenti righe}} de l'elenco dei titoli mìa consentìi {{PLURAL:$1|no la xe valida|no le xe valide}}; se prega de corègiar {{PLURAL:$1|l'eror|i erori}} prima de salvar la pagina.",
	'right-tboverride'                => 'Ignora la lista nera dei titoli',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'titleblacklist-desc'             => 'Cấm không được tạo ra trang có các tên được định rõ: [[MediaWiki:Titleblacklist]] và [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# Đây là danh sách đen về tên trang. Không được tạo ra các trang trùng với một biểu thức chính quy ở đây.
# Hãy bắt đầu lời ghi chú với “#”.',
	'titlewhitelist'                  => '# Đây là “danh sách trắng” về tên trang. Hãy bắt đầu lời ghi chú với “#”.',
	'titleblacklist-forbidden-edit'   => 'Không được tạo ra trang dưới tên “$2”.
Tên này trùng với mục sau trong danh sách đen: <code>$1</code>',
	'titleblacklist-forbidden-move'   => 'Không được di chuyển “$2” đến “$3”, vì tựa đề “$3” bị cấm khởi tạo. 
Nó trùng với mục sau trong danh sách đen: <code>$1</code>',
	'titleblacklist-forbidden-upload' => 'Không được tải lên tập tin dưới tên “$2”.
Tên này trùng với khoản sau trong danh sách đen: <code>\\$1</code>',
	'titleblacklist-invalid'          => '{{PLURAL:$1|Dòng|Những dòng}} sau đây trong danh sách đen về tên trang không hợp lệ; xin hãy sửa chữa {{PLURAL:$1|nó|chúng}} để tuân theo cú pháp biểu thức chính quy trước khi lưu trang:',
	'right-tboverride'                => 'Bỏ qua danh sách các tựa trang bị cấm',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'titleblacklist-desc'             => '容許禁止開指定標題嘅版: [[MediaWiki:Titleblacklist]] 同 [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# 呢個係一個標題黑名單。同呢度配合正規表達式嘅標題係唔可以新開嘅。
# 用 "#" 去做註解。
',
	'titlewhitelist'                  => '# 呢個係一個標題白名單。 用 "#" 去做註解',
	'titleblacklist-forbidden-edit'   => '個標題 "$2" 已經禁止咗去開版。佢同下面黑名單嘅項目配合: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" 唔可以搬到去 "$3"，由於個標題 "$3" 已經禁止咗去開。佢同下面黑名單嘅項目配合: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '個檔名 "$2" 已經禁止咗去開版。佢同下面黑名單嘅項目配合: <code>\\$1</code>',
	'titleblacklist-invalid'          => '下面響標題黑名單嘅{{PLURAL:$1|一行|幾行}}無效；請響保存之前改正{{PLURAL:$1|佢|佢哋}}:',
	'right-tboverride'                => '覆蓋標題黑名單',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Fdcn
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'titleblacklist-desc'             => '容许禁止建立指定标题的页面: [[MediaWiki:Titleblacklist]] 和 [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# 本页面为“标题黑名单”。任何匹配本名单正则表达式的标题会被阻止建立和编辑。
# 请使用"#"来添加注释。',
	'titlewhitelist'                  => '# 本页面为“标题白名单”。 请使用"#"来添加注释。',
	'titleblacklist-forbidden-edit'   => '标题 "$2" 已经被禁止创建。它跟以下黑名单的项目配合: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" 不可以移动到 "$3"，由于该标题 "$3" 已经被禁止创建。它跟以下黑名单的项目配合: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '文件名称 "$2" 已经被禁止创建。它跟以下黑名单的项目配合: <code>\\$1</code>',
	'titleblacklist-invalid'          => '以下在标题黑名单上的{{PLURAL:$1|一行|多行}}无效；请在保存前改正{{PLURAL:$1|它|它们}}:',
	'right-tboverride'                => '覆盖标题黑名单',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Fdcn
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'titleblacklist-desc'             => '容許禁止建立指定標題的頁面: [[MediaWiki:Titleblacklist]] 與 [[MediaWiki:Titlewhitelist]]',
	'titleblacklist'                  => '# 本頁面為「標題黑名單」。任何匹配本名單正則表達式的標題會被阻止建立和編輯。
# 請使用"#"來添加註釋。',
	'titlewhitelist'                  => '# 本頁面為「標題白名單」。 請使用"#"來添加註釋。',
	'titleblacklist-forbidden-edit'   => '標題 "$2" 已經被禁止創建。它跟以下黑名單的項目配合: <code>$1</code>',
	'titleblacklist-forbidden-move'   => '"$2" 不可以移動到 "$3"，由於該標題 "$3" 已經被禁止創建。它跟以下黑名單的項目配合: <code>$1</code>',
	'titleblacklist-forbidden-upload' => '檔案名稱 "$2" 已經被禁止創建。它跟以下黑名單的項目配合: <code>\\$1</code>',
	'titleblacklist-invalid'          => '以下在標題黑名單上的{{PLURAL:$1|一行|多行}}無效；請在保存前改正{{PLURAL:$1|它|它們}}:',
	'right-tboverride'                => '覆蓋標題黑名單',
);

