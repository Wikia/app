<?php

/*Internationalizaton file of TodoTask extension*/

$messages = array();

$messages['en'] = array(
	'tasklist'                => 'Task list',
	'tasklist-parser-desc'    => 'Adds <nowiki>{{#todo:}}</nowiki> parser function for assigning tasks',
	'tasklist-special-desc'   => 'Adds a special page for reviewing [[Special:TaskList|tasks assignments]]',
	'tasklistbyproject'       => 'Task list by project',
	'tasklistunknownproject'  => 'Unknown project',
	'tasklistunspecuser'      => 'Unspecified user',
	'tasklistincorrectuser'   => 'Incorrect username',
	'tasklistemail'           => 'Dear %s',
	'tasklistemailsubject'    => '[%s] Task list change',
	'tasklistmytasks'         => 'My tasks',
	'tasklistbyprojectbad'    => "Project '''%s''' is not a valid project.
For a list of valid projects, see [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'      => "Assigned tasks for '''%s'''",
	'tasklistchooseproj'      => 'Select project:',
	'tasklistprojdisp'        => 'Display',
	'tasklistbyname'          => '== Todo list for %s ==',
	'tasklistnowguseprojects' => 'You have set $wgUseProjects to "false" and cannot use this page.',
	'tasklistnoprojects'      => "Error: It looks like you enabled '''\$wgUseProjects''', but did not create [[MediaWiki:TodoTasksValidProjects]]. See [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions] for more details.",
	'tasklistemailbody'       => ",

Someone has assigned a new Task for you on %s.

To see your complete Task List go to %s.

Your friendly %s notification system",
	'todoTasksValidProjects' => '', # Do not translate this message.
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'tasklist-parser-desc' => '{{desc}}',
	'tasklist-special-desc' => '{{desc}}',
	'tasklistincorrectuser' => '{{Identical|Incorrect username}}',
	'tasklistprojdisp' => '{{Identical|Display}}',
	'tasklistbyname' => '{{Identical|Todo list for}}',
	'tasklistemailbody' => "* 1st %s is the URL of the page a task is created for
* 2nd %s is the URL of the user's task list page
* 3rd %s is the site name",
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'tasklistincorrectuser' => 'Seseva',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'tasklist' => 'Taaklys',
	'tasklistincorrectuser' => 'Foutiewe gebruikersnaam',
	'tasklistemail' => 'Beste %s',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'tasklist' => 'قائمة المهام',
	'tasklist-parser-desc' => 'يضيف دالة محلل <nowiki>{{#todo:}}</nowiki> لتولية المهام',
	'tasklist-special-desc' => 'يضيف صفحة خاصة لمراجعة [[Special:TaskList|توليات المهام]]',
	'tasklistbyproject' => 'قائمة المهام حسب المشروع',
	'tasklistunknownproject' => 'مشروع غير معروف',
	'tasklistunspecuser' => 'مستخدم غير محدد',
	'tasklistincorrectuser' => 'اسم مستخدم غير صحيح',
	'tasklistemail' => 'عزيزي %s',
	'tasklistemailsubject' => 'التغيير في قائمة مهام [%s]',
	'tasklistmytasks' => 'مهامي',
	'tasklistbyprojectbad' => "المشروع '''%s''' ليس مشروعا صحيحا.
لقائمة بالمشاريع الصحيحة، انظر [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "المهام الموكلة ل'''%s'''",
	'tasklistchooseproj' => 'اختر المشروع:',
	'tasklistprojdisp' => 'اعرض',
	'tasklistbyname' => '== قائمة العمل ل%s ==',
	'tasklistnowguseprojects' => 'أنت ضبطت $wgUseProjects ك"false" ولا يمكنك استخدام هذه الصفحة.',
	'tasklistnoprojects' => "خطأ: يبدو أنك فعلت '''\$wgUseProjects'''، لكن لم تنشيء [[MediaWiki:TodoTasksValidProjects]]. انظر [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 تعليمات التنصيب] لمزيد من التفاصيل.",
	'tasklistemailbody' => '،

شخص ما أضاف مهمة جديدة لك في %s.

لرؤية قائمة مهامك الكاملة اذهب إلى %s.

نظام إخطار %s الصديق',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'tasklist' => 'قائمة المهام',
	'tasklist-parser-desc' => 'يضيف دالة محلل <nowiki>{{#todo:}}</nowiki> لتولية المهام',
	'tasklist-special-desc' => 'يضيف صفحة خاصة لمراجعة [[Special:TaskList|توليات المهام]]',
	'tasklistbyproject' => 'قائمة المهام حسب المشروع',
	'tasklistunknownproject' => 'مشروع مش معروف',
	'tasklistunspecuser' => 'يوزر مش  محدد',
	'tasklistincorrectuser' => 'اسم يوزر مش صحيح',
	'tasklistemail' => 'عزيزى %s',
	'tasklistemailsubject' => 'التغيير فى قائمة مهام [%s]',
	'tasklistmytasks' => 'مهامي',
	'tasklistbyprojectbad' => "المشروع '''%s''' مش  مشروع صحيح.
لقائمة بالمشاريع الصحيحة، شوف [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "المهام الموكلة ل'''%s'''",
	'tasklistchooseproj' => 'اختر المشروع:',
	'tasklistprojdisp' => 'عرض',
	'tasklistbyname' => '== قائمة العمل ل%s ==',
	'tasklistnoprojects' => "خطأ: يبدو أنك فعلت '''\$wgUseProjects'''، لكن لم تنشيء [[MediaWiki:TodoTasksValidProjects]]. انظر [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 تعليمات التنصيب] لمزيد من التفاصيل.",
	'tasklistemailbody' => '،

شخص ما أضاف مهمة جديدة لك فى %s.

لرؤية قائمة مهامك الكاملة اذهب إلى %s.

نظام إخطار %s الصديق',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'tasklist' => 'Сьпіс заданьняў',
	'tasklist-parser-desc' => 'Дадае функцыю парсэра <nowiki>{{#todo:}}</nowiki> для прызначэньня заданьняў',
	'tasklist-special-desc' => 'Дадае спэцыяльную старонку для прагляду [[Special:TaskList|прызначаных заданьняў]]',
	'tasklistbyproject' => 'Сьпіс заданьняў па праектах',
	'tasklistunknownproject' => 'Невядомы праект',
	'tasklistunspecuser' => 'Непазначаны ўдзельнік',
	'tasklistincorrectuser' => 'Няслушнае імя ўдзельніка',
	'tasklistemail' => 'Паважаны %s',
	'tasklistemailsubject' => '[%s] Зьмена сьпісу заданьняў',
	'tasklistmytasks' => 'Мае заданьні',
	'tasklistbyprojectbad' => "Няслушны праект '''%s'''.
Сьпіс слушных праектаў глядзіце на [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Прызначана заданьне для '''%s'''",
	'tasklistchooseproj' => 'Выберыце праект:',
	'tasklistprojdisp' => 'Паказаць',
	'tasklistbyname' => '== Сьпіс заданьняў для %s ==',
	'tasklistnowguseprojects' => 'Вы устанавілі $wgUseProjects як «false» і ня можаце выкарыстоўваць гэтую старонку.',
	'tasklistnoprojects' => "Памылка: верагодна Вы ўключылі '''\$wgUseProjects''', але яшчэ не стварылі [[MediaWiki:TodoTasksValidProjects]]. Глядзіце падрабязнасьці ў [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 інструкцыях па ўсталёўцы].",
	'tasklistemailbody' => ',

Нехта прызначыў Вам новае заданьне ў %s.

Каб паглядзець поўны сьпіс заданьняў, перайдзіце на %s.

Ваша сыстэма паведамленьняў %s',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'tasklist' => 'Списък със задачи',
	'tasklist-parser-desc' => 'добавя функция на парсера <nowiki>{{#todo:}}</nowiki> за управление на задачи',
	'tasklist-special-desc' => 'Добавя специална страница със [[Special:TaskList|списък със задачи]].',
	'tasklistbyproject' => 'Списък със задачи по проект',
	'tasklistunknownproject' => 'Неизвестен проект',
	'tasklistincorrectuser' => 'Невалидно потребителско име',
	'tasklistemail' => 'Уважаеми %s',
	'tasklistemailsubject' => '[%s] Промяна в списъка със задачи',
	'tasklistmytasks' => 'Моите задачи',
	'tasklistbyprojectbad' => "Проектът '''%s''' не е валиден проект. За списък с проекти, вижте [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistchooseproj' => 'Избор на проект:',
	'tasklistprojdisp' => 'Показване',
	'tasklistbyname' => '== Списък със задачи за %s ==',
	'tasklistnoprojects' => "Грешка: Изглежда сте включили '''\$wgUseProjects''', но не сте създали [[MediaWiki:TodoTasksValidProjects]]. За повече информация, прегледайте [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 инструкциите за инсталация].",
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'tasklist' => 'কর্মতালিকা',
	'tasklistunknownproject' => 'অজানা প্রকল্প',
	'tasklistincorrectuser' => 'ভুল ব্যবহারকারী নাম',
	'tasklistemail' => 'সুপ্রিয় %s',
	'tasklistmytasks' => 'আমার কর্ম',
	'tasklistchooseproj' => 'প্রকল্প নির্বাচন:',
	'tasklistprojdisp' => 'প্রদর্শন',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'tasklist' => 'Roll trevelloù',
	'tasklist-parser-desc' => 'Ouzhpennañ a ra <nowiki>{{#todo:}}</nowiki> ur fonksion parser evit deverkañ trevelloù',
	'tasklist-special-desc' => 'Ouzhpennañ a ra ur bajenn dibar evit adwelet an [[Special:TaskList|trevelloù deverket]]',
	'tasklistbyproject' => 'Roll trevelloù dre raktres',
	'tasklistunknownproject' => 'Raktres dianav',
	'tasklistunspecuser' => "N'eo ket diferet an implijer",
	'tasklistincorrectuser' => 'Anv implijer direizh',
	'tasklistemail' => '%s ker',
	'tasklistemailsubject' => '[%s] Kemmoù e roll an trevelloù',
	'tasklistmytasks' => 'Ma zrevelloù',
	'tasklistbyprojectbad' => "N'eus ket eus ar raktres '''%s'''.
Evit kaout ur roll eus ar raktresoù zo anezho, sellit ouzh [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Trevelloù deverket evit '''%s'''.",
	'tasklistchooseproj' => 'Diuzañ ur raktres :',
	'tasklistprojdisp' => 'Diskwel',
	'tasklistbyname' => '== Roll an traoù da ober gant $s ==',
	'tasklistnowguseprojects' => 'Termenet hoc\'h eus $wgUseProjects da "false", dre-se n\'hallit ket implijout ar bajenn-mañ.',
	'tasklistnoprojects' => "Fazi : Evit doare eo bet gweredekaet '''\$wgUseProjects''' ganeoc'h, met n'eo ket bet krouet [[MediaWiki:TodoTasksValidProjects]]. Kit da welet  [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 ar C'hemennadennoù staliañ] evit kaout muioc'h a ditouroù.",
	'tasklistemailbody' => ",

Unan bennak en deus deverket deoc'h un trevell nevez war %s.

Evit gwelet roll klok ho trevelloù, kit war %s.

Ho reizhiad kemennoù %s muiañ-karet",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'tasklist' => 'Spisak zadataka',
	'tasklist-parser-desc' => 'Dodaje parsersku funkciju <nowiki>{{#todo:}}</nowiki> za dodjelu zadataka',
	'tasklist-special-desc' => 'Dodaje posebnu stranicu za pregled [[Special:TaskList|dodjele zadataka]]',
	'tasklistbyproject' => 'Spisak zadataka po projektima',
	'tasklistunknownproject' => 'Nepoznat projekt',
	'tasklistunspecuser' => 'Neodređen korisnik',
	'tasklistincorrectuser' => 'Netačno korisničko ime',
	'tasklistemail' => 'Poštovani %s',
	'tasklistemailsubject' => '[%s] Spisak izmjena zadatka',
	'tasklistmytasks' => 'Moji zadaci',
	'tasklistbyprojectbad' => "Projekat '''s%''' nije valjan projekat.
Za spisak valjanih projekata, pogledajte [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Dodijeljeni zadaci za '''%s'''",
	'tasklistchooseproj' => 'Odaberite projekat:',
	'tasklistprojdisp' => 'Prikaz',
	'tasklistbyname' => '== Spisak za uraditi za %s ==',
	'tasklistnowguseprojects' => 'Postavili ste $wgUseProjects na "false" i ne možete koristiti ovu stranicu.',
	'tasklistnoprojects' => "Greška: Izgleda da ste omogućili '''\$wgUseProjects''', ali niste napravili [[MediaWiki:TodoTasksValidProjects]]. Pogledajte [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 objašnjenja za instalaciju] za više detalja.",
	'tasklistemailbody' => ',

Neko je postavio za Vas novi zadatak na %s.

Da pogledate Vaš cijeli spisak zadataka idite na %s.

Vaš prijateljski %s sistem obavijesti',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'tasklist' => 'Llista de tasques',
	'tasklistunknownproject' => 'Projecte desconegut',
	'tasklistincorrectuser' => "Nom d'usuari incorrecte",
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'tasklistprojdisp' => 'پیشاندان',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'tasklist' => 'Seznam úkolů',
	'tasklist-parser-desc' => 'Přidává funkci syntaktického analyzátoru <tt>{{&#35;todo:}}</tt> pro přidělování úkolů',
	'tasklist-special-desc' => 'Přidává speciální stránku pro kontrolu [[Special:TaskList|přidělených úkolů]]',
	'tasklistbyproject' => 'Seznam úkolů podle projektů',
	'tasklistunknownproject' => 'Neznámý projekt',
	'tasklistunspecuser' => 'Nespecifikovaný uživatel',
	'tasklistincorrectuser' => 'Nesprávné uživatelské jméno',
	'tasklistemail' => 'Vážený %s',
	'tasklistemailsubject' => '[%s] Změna seznamu úkolů',
	'tasklistmytasks' => 'Moje úkoly',
	'tasklistbyprojectbad' => "Projekt '''%s''' není platný projekt. Seznam platných projektů najdete na [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Přidělené úkoly pro '''%s'''",
	'tasklistchooseproj' => 'Vyberte projekt:',
	'tasklistprojdisp' => 'Zobrazit',
	'tasklistbyname' => '== Seznam úkolů pro %s ==',
	'tasklistnowguseprojects' => 'Máte $wgUseProjects nastaveno na „false“, takže tuto stránku nemůžete používat.',
	'tasklistnoprojects' => "Chyba: Zdá se, že jste zapnuli '''\$wgUseProjects''', ale nevytvořili jste [[MediaWiki:TodoTasksValidProjects]]. Podívejte se na podrobnosti v [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 instalačních instrukcích].",
	'tasklistemailbody' => ',

Někdo vám přiřadil nový úkol na %s.

Svůj úplný seznam úkolů si můžete prohlédnout na %s.

Váš přátelský upozorňovací systém %s',
);

/** German (Deutsch)
 * @author Imre
 * @author Melancholie
 * @author Purodha
 * @author Revolus
 * @author The Evil IP address
 */
$messages['de'] = array(
	'tasklist' => 'Aufgabenliste',
	'tasklist-parser-desc' => 'Fügt die Parserfunktion <nowiki>{{#todo:}}</nowiki> zum Zuordnen von Aufgaben hinzu',
	'tasklist-special-desc' => 'Fügt eine Spezialseite für die Nachprüfung von [[Special:TaskList|Aufgabenzuteilungen]] hinzu',
	'tasklistbyproject' => 'Aufgabenliste pro Projekt',
	'tasklistunknownproject' => 'Unbekanntes Projekt',
	'tasklistunspecuser' => 'Unbestimmter Benutzername',
	'tasklistincorrectuser' => 'Falscher Benutzername',
	'tasklistemail' => 'Hallo %s',
	'tasklistemailsubject' => '[%s]-Aufgabenliste Änderungen',
	'tasklistmytasks' => 'Meine Aufgaben',
	'tasklistbyprojectbad' => "Projekt '''%s''' ist nicht vorhanden. Für eine Liste gültiger Projekt siehe [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Zugewiesene Aufgaben für '''%s'''",
	'tasklistchooseproj' => 'Projekt auswählen:',
	'tasklistprojdisp' => 'Anzeigen',
	'tasklistbyname' => '== Aufgabenliste für %s ==',
	'tasklistnowguseprojects' => 'Du hast $wgUseProjects auf „false“ gesetzt und kannst diese Seite nicht benutzen.',
	'tasklistnoprojects' => "Fehler: Es sieht so aus, als wenn '''\$wgUseProjects''' aktiviert wäre, aber es wurde keine Seiten [[MediaWiki:TodoTasksValidProjects]] erstellt. Siehe die [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installationsanweisungen] für weitere Details.",
	'tasklistemailbody' => ',

Jemand hat dir eine neue Aufgabe bei %s zugeordnet.

Zum Anschauen deiner kompletten Aufgabenliste siehe %s.

Dein freundliches %s-Benachrichtungssystem',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'tasklistnowguseprojects' => 'Sie haben $wgUseProjects auf „false“ gesetzt und können diese Seite nicht benutzen.',
	'tasklistemailbody' => ',

Jemand hat Ihnen eine neue Aufgabe bei %s zugeordnet.

Zum Anschauen Ihrer kompletten Aufgabenliste siehe %s.

Ihr freundliches %s-Benachrichtungssystem',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'tasklist' => 'Lisćina nadawkow',
	'tasklist-parser-desc' => 'Pśidawa parserowu funkciju <nowiki>{{#todo:}}</nowiki> za pśipokazanje nadawkow',
	'tasklist-special-desc' => 'Pśidawa specialny bok za pśeglědowanje  [[Special:TaskList|pśipokazanjow nadawkow]]',
	'tasklistbyproject' => 'Lisćina nadawkow za projekt',
	'tasklistunknownproject' => 'Njeznaty projekt',
	'tasklistunspecuser' => 'Wužywaŕ njepódaty',
	'tasklistincorrectuser' => 'Wopacne wužywarske mě',
	'tasklistemail' => 'Witaj %s',
	'tasklistemailsubject' => '[%s] Změny lisćiny nadawkow',
	'tasklistmytasks' => 'Móje nadawki',
	'tasklistbyprojectbad' => "Projekt '''%s''' njejo płaśiwy projekt.
Za lisćinu płaśiwych projektow glědaj [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Za '''%s''' pśipokazane nadawki",
	'tasklistchooseproj' => 'Projekt wubraś:',
	'tasklistprojdisp' => 'Zwobrazniś',
	'tasklistbyname' => '== Lisćina nadawkow za %s ==',
	'tasklistnowguseprojects' => 'Sy $wgUseProjects na "false" stajił a njamóžoš toś ten bok wužywaś.',
	'tasklistnoprojects' => "Zmólka: Wuglěda, ako by ty zaktiwěrował '''\$wgUseProjects''', ale njeby napórał boki [[MediaWiki:TodoTasksValidProjects]]. Glědaj [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 instalaciske wukazanja] za dalšne drobnostki.",
	'tasklistemailbody' => ',

Něchten jo pśipokazał nowy nadawk za tebje na %s.

Aby wiźeł swóju dopołnu lisćinu nadawkow, źi k %s.

Twój pśijaśelny informěrowański system {{GRAMMAR:genitiw|%s}}',
);

/** Greek (Ελληνικά)
 * @author ZaDiak
 */
$messages['el'] = array(
	'tasklist' => 'Λίστα εργασιών',
	'tasklistbyproject' => 'Λίστα εργασιών βάσει εγχειρήματος',
	'tasklistunknownproject' => 'Άγνωστο εγχείρημα',
	'tasklistunspecuser' => 'Απροσδιόριστος χρήστης',
	'tasklistincorrectuser' => 'Λάθος όνομα χρήστη',
	'tasklistemail' => 'Αγαπητέ %s',
	'tasklistemailsubject' => '[%s] Αλλαγή λίστας εργασιών',
	'tasklistmytasks' => 'Οι εργασίες μου',
	'tasklistbyprojname' => "Ανατεθειμένες εργασίες για '''%s'''",
	'tasklistchooseproj' => 'Επιλογή εγχειρήματος:',
	'tasklistprojdisp' => 'Ανάλυση',
	'tasklistbyname' => '== Λίστα todo για το %s ==',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'tasklist' => 'Tasklisto',
	'tasklist-parser-desc' => 'Aldonas sintaksan funkcion <nowiki>{{#todo:}}</nowiki> por asigni taskojn',
	'tasklist-special-desc' => 'Aldonas specialan paĝon por kontroli [[Special:TaskList|taskajn asignojn]]',
	'tasklistbyproject' => 'Tasklisto Laŭ Projekto',
	'tasklistunknownproject' => 'Nekonata projekto',
	'tasklistunspecuser' => 'Nespecifa uzanto',
	'tasklistincorrectuser' => 'Malkorekta salutnomo',
	'tasklistemail' => 'Kara %j',
	'tasklistemailsubject' => '[%s] Ŝanĝo de tasklisto',
	'tasklistmytasks' => 'Miaj taskoj',
	'tasklistbyprojectbad' => "Projekto '''%s''' ne estas valida projekto.
Por listo de validaj projektoj, vidu [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Asignitaj taskoj por '''%s'''",
	'tasklistchooseproj' => 'Selektu Projekton:',
	'tasklistprojdisp' => 'Montri',
	'tasklistbyname' => '== Farenda listo por $s ==',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'tasklist' => 'Lista de tareas',
	'tasklist-parser-desc' => 'Agrega <nowiki>{{#todo:}}</nowiki> funciones de analizador para tareas asignadas',
	'tasklist-special-desc' => 'Agrega una página especial para revisar [[Special:TaskList|asignamientos de tareas]]',
	'tasklistbyproject' => 'Lista de tareas por proyecto',
	'tasklistunknownproject' => 'Proyecto desconocido',
	'tasklistunspecuser' => 'Usuario no especificado',
	'tasklistincorrectuser' => 'Nombre de usuario incorrecto',
	'tasklistemail' => 'Querido %s',
	'tasklistemailsubject' => '[%s] Cambio de lista de tareas',
	'tasklistmytasks' => 'Mis tareas',
	'tasklistbyprojectbad' => "Proyecto '''%s''' no es un proyecto válido.
Para una lista de proyectos válido, vea [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tareas asignadas para '''%s'''",
	'tasklistchooseproj' => 'Seleccionar proyecto:',
	'tasklistprojdisp' => 'Exhibir',
	'tasklistbyname' => '== Lista de quehaceres para %s ==',
	'tasklistnowguseprojects' => 'Has seleccionado el valor "falso" para $wgUseProjects y por lo tanto, no puedes usar esta página.',
	'tasklistnoprojects' => "Error: Parece que tu habilitaste '''\$wgUseProjects''', pero no creaste [[MediaWiki:TodoTasksValidProjects]]. Mira 
[http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Instrucciones de instalación] para más detalles.",
	'tasklistemailbody' => ',

Alguien ha asignado una nueva Tarea para usted en %s.

Para ver su lista completa de Tareas vaya a %s.

Su sistema de notificación amigable %s',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'tasklistunknownproject' => 'Tundmatu projekt',
	'tasklistincorrectuser' => 'Vigane kasutajanimi',
	'tasklistchooseproj' => 'Vali projekt:',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'tasklist' => 'Egitekoen zerrenda',
	'tasklistbyproject' => 'Egitekoen zerrenda proiektuen arabera',
	'tasklistunknownproject' => 'Proiektu ezezaguna',
	'tasklistunspecuser' => 'Zehaztugabeko lankidea',
	'tasklistincorrectuser' => 'Lankide izen okerra',
	'tasklistemail' => '%s estimatua',
	'tasklistmytasks' => 'Nire eginkizunak',
	'tasklistchooseproj' => 'Proiektua hautatu:',
	'tasklistprojdisp' => 'Erakutsi',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'tasklist' => 'Tehtävälista',
	'tasklistbyproject' => 'Projektikohtainen tehtävälista',
	'tasklistunknownproject' => 'Tuntematon projekti',
	'tasklistunspecuser' => 'Määrittelemätön käyttäjä',
	'tasklistincorrectuser' => 'Virheellinen käyttäjätunnus',
	'tasklistemail' => 'Hyvä %s',
	'tasklistemailsubject' => '[%s] Tehtäväluettelon muutos',
	'tasklistmytasks' => 'Omat tehtävät',
	'tasklistbyprojname' => "Käyttäjälle '''%s''' osoitetut tehtävät",
	'tasklistchooseproj' => 'Valitse projekti',
	'tasklistprojdisp' => 'Näytä',
	'tasklistbyname' => '== Tehtävälista käyttäjälle %s ==',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author McDutchie
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'tasklist' => 'Liste de tâches',
	'tasklist-parser-desc' => 'Ajoute <nowiki>{{#todo:}}</nowiki> une fonction parseur pour assigner des tâches',
	'tasklist-special-desc' => 'Ajoute une page spéciale pour réviser les [[Special:TaskList|tâches assignées]]',
	'tasklistbyproject' => 'Liste de tâches par projet',
	'tasklistunknownproject' => 'Projet inconnu',
	'tasklistunspecuser' => 'Utilisateur non spécifié',
	'tasklistincorrectuser' => 'Nom d’utilisateur incorrect',
	'tasklistemail' => 'Cher %s',
	'tasklistemailsubject' => '[%s] Modification dans la liste de tâches',
	'tasklistmytasks' => 'Mes tâches',
	'tasklistbyprojectbad' => "Le projet '''%s''' n’est pas valide. Pour une liste des projets valides, voir [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tâches assignées pour '''%s'''.",
	'tasklistchooseproj' => 'Sélectionner un projet :',
	'tasklistprojdisp' => 'Afficher',
	'tasklistbyname' => '== Liste de tâches pour %s ==',
	'tasklistnowguseprojects' => 'Vous avez défini $wgUseProjects à « false » et ne pouvez donc pas utiliser cette page.',
	'tasklistnoprojects' => "Erreur : il semble que vous ayez activé '''\$wgUseProjects''', mais sans avoir créé [[MediaWiki:TodoTasksValidProjects]]. Consultez les [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 instructions d’installation] pour plus de détails.",
	'tasklistemailbody' => ',

Quelqu’un vous a assigné une nouvelle tâche sur %s.

Pour voir la liste complète de vos tâches, allez sur %s.

Votre bien aimable système de notification de %s',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'tasklist' => 'Lista de travâlys',
	'tasklist-parser-desc' => 'Apond <nowiki>{{#todo:}}</nowiki> una fonccion du parsor por assignér des travâlys.',
	'tasklist-special-desc' => 'Apond una pâge spèciâla por revêre los [[Special:TaskList|travâlys assignês]].',
	'tasklistbyproject' => 'Lista de travâlys per projèt',
	'tasklistunknownproject' => 'Projèt encognu',
	'tasklistunspecuser' => 'Usanciér pas spècefiâ',
	'tasklistincorrectuser' => 'Nom d’utilisator fôx',
	'tasklistemail' => 'Chier %s',
	'tasklistemailsubject' => '[%s] Changement dens la lista de travâlys',
	'tasklistmytasks' => 'Mos travâlys',
	'tasklistbyprojectbad' => "Lo projèt '''%s''' est pas un projèt valido.
Por una lista des projèts validos, vêde [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Travâlys assignês por '''%s'''",
	'tasklistchooseproj' => 'Chouèsir un projèt :',
	'tasklistprojdisp' => 'Fâre vêre',
	'tasklistbyname' => '== Lista de travâlys por %s ==',
	'tasklistnowguseprojects' => 'Vos éd dèfeni $wgUseProjects a « fôx » et pués pouede vêr pas utilisar ceta pâge.',
	'tasklistnoprojects' => "Èrror : semble que vos èyâd activâ '''\$wgUseProjects''', mas sen avêr fêt [[MediaWiki:TodoTasksValidProjects]]. Vêde les [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 enstruccions d’enstalacion] por més de dètalys.",
	'tasklistemailbody' => ',

Quârqu’un vos at assignê un travâly novél dessus %s.

Por vêre la lista complèta de voutros travâlys, alâd dessus %s.

Voutron bien amâblo sistèmo de notificacion de %s',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'tasklist' => 'Lista de tarefas',
	'tasklist-parser-desc' => 'Engade a función de análise <nowiki>{{#todo:}}</nowiki> para asignar tarefas',
	'tasklist-special-desc' => 'Engade unha páxina especial para revisar [[Special:TaskList|as tarefas asignadas]]',
	'tasklistbyproject' => 'Lista de tarefas por proxecto',
	'tasklistunknownproject' => 'Proxecto descoñecido',
	'tasklistunspecuser' => 'Usuario sen especificar',
	'tasklistincorrectuser' => 'Nome de usuario incorrecto',
	'tasklistemail' => 'Estimado %s',
	'tasklistemailsubject' => '[%s] Cambio na lista de tarefas',
	'tasklistmytasks' => 'As miñas tarefas',
	'tasklistbyprojectbad' => "O proxecto '''%s''' non é un proxecto válido.
Para ollar unha lista cos proxectos válidos, véxase [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tarefas asignadas a '''%s'''",
	'tasklistchooseproj' => 'Seleccionar un proxecto:',
	'tasklistprojdisp' => 'Mostrar',
	'tasklistbyname' => '== Lista de tarefas pendentes de %s ==',
	'tasklistnowguseprojects' => 'Ten definido $wgUseProjects en "falso", polo que non pode empregar esta páxina.',
	'tasklistnoprojects' => "Erro: semella que activou '''\$wgUseProjects''', pero non creou [[MediaWiki:TodoTasksValidProjects]]. Olle [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 as instrucións de instalación] para obter máis detalles.",
	'tasklistemailbody' => ':

Alguén asignoulle unha nova tarefa en %s.

Para ver a súa lista completa de tarefas vaia a %s.

O sistema de notificacións de %s',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'tasklist' => 'Ufgabelischt',
	'tasklist-parser-desc' => 'Fiegt d Parserfunktion <nowiki>{{#todo:}}</nowiki> zum Zueordne vu Ufgabe zue',
	'tasklist-special-desc' => 'Fiegt e Spezialsyte fir d Nochpriefig vu [[Special:TaskList|Ufgabezueteilige]] zue',
	'tasklistbyproject' => 'Ufgabelischt pro Projäkt',
	'tasklistunknownproject' => 'Nit bekannt Projäkt',
	'tasklistunspecuser' => 'Uubstimmter Benutzername',
	'tasklistincorrectuser' => 'Falscher Benutzername',
	'tasklistemail' => 'Sali %s',
	'tasklistemailsubject' => '[%s]-Ufgabelischt Änderige',
	'tasklistmytasks' => 'Myyni Ufgabe',
	'tasklistbyprojectbad' => "Projäkt '''%s''' git s nit. Fir e Lischt vu giltige Projäkt lueg [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Zuegwiseni Ufgabe fir '''%s'''",
	'tasklistchooseproj' => 'Projäkt uswehle:',
	'tasklistprojdisp' => 'Aazeige',
	'tasklistbyname' => '== Ufgabelischt fir %s ==',
	'tasklistnowguseprojects' => 'Du hesch $wgUseProjects uf „falsch“ gsetzt, wäge däm cha s nit brucht.',
	'tasklistnoprojects' => "Fähler: S siht eso uus wie wänn '''\$wgUseProjects''' aktiviert wär, aber d Syte [[MediaWiki:TodoTasksValidProjects]] sin nit aagleit. Lueg d [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installationsaawyysige] fir meh Detail.",
	'tasklistemailbody' => ',

Eber het Dir e neji Ufgab bi %s zuegordnet.

Go Dyy komplett Ufgabelischt bschaue lueg %s.

Dyy fryndli %s-Benochrichtungssyschtem',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'tasklist' => 'רשימת מטלות',
	'tasklist-parser-desc' => 'הוספת תגית הוויקי <nowiki>{{#todo:}}</nowiki> להקצאת מטלות',
	'tasklist-special-desc' => 'הוספת דף מיוחד לסקירת [[Special:TaskList|הקצאות המטלות]]',
	'tasklistbyproject' => 'רשימת מטלות לפי מיזמים',
	'tasklistunknownproject' => 'מיזם בלתי ידוע',
	'tasklistunspecuser' => 'משתמש בלתי מוגדר',
	'tasklistincorrectuser' => 'שם המשתמש שגוי',
	'tasklistemail' => '%s היקר',
	'tasklistemailsubject' => '[%s] שינוי ברשימת המטלות',
	'tasklistmytasks' => 'המטלות שלי',
	'tasklistbyprojectbad' => "המיזם '''%s''' איננו קיים. לקבלת רשימת המיזמים, ראו [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "המטלה הוגדרה ל'''%s'''",
	'tasklistchooseproj' => 'בחירת מיזם:',
	'tasklistprojdisp' => 'תצוגה',
	'tasklistbyname' => '== רשימת מטלות עבור %s ==',
	'tasklistnowguseprojects' => 'הגדרת את $wgUseProjects ל־"false" ולא ניתן להשתמש בדף זה.',
	'tasklistnoprojects' => "שגיאה: נראה שהפעלתם את '''\$wgUseProjects''', אבל לא יצרתם את [[MediaWiki:TodoTasksValidProjects]]. ראו את [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 הוראות ההתקנה] לפרטים נוספים.",
	'tasklistemailbody' => ',

מישהו הקצה מטלה חדשה עבורכם ב־%s.

על מנת לצפות ברשימת המטלות המלאה, אנא עברו לדף %s.

מערכת התראות ה%s הידידותית שלכם',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'tasklist' => 'Lisćina nadawkow',
	'tasklist-parser-desc' => 'přidawa <nowiki>{{#todo:}}</nowiki> parserowu funkciju za připokazowanje nadawkow',
	'tasklist-special-desc' => 'Přidawa specialnu stronu za pruwowanje [[Special:TaskList|připokazanjow nadawkow]]',
	'tasklistbyproject' => 'Lisćina nadawkow po projekće',
	'tasklistunknownproject' => 'Njeznaty projekt',
	'tasklistunspecuser' => 'Wužiwar njepodaty',
	'tasklistincorrectuser' => 'Njekorektne wužiwarske mjeno',
	'tasklistemail' => 'Luby %s',
	'tasklistemailsubject' => '[%s] Změna lisćiny nadawkow',
	'tasklistmytasks' => 'Moje nadawki',
	'tasklistbyprojectbad' => "Projekt '''%s''' płaćiwy projekt njeje. Za lisćinu płaćiwych projektow, hlej [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Nadawki so za '''%s''' připokazachu.",
	'tasklistchooseproj' => 'Wubjer projekt:',
	'tasklistprojdisp' => 'Pokazać',
	'tasklistbyname' => '== Nadawkowa lisćina za %s ==',
	'tasklistnowguseprojects' => 'Sy $wgUseProjects na "false" stajił a njemóžeš tutu stronu wužiwać.',
	'tasklistnoprojects' => "ZMYLK: Zda so, zo sy '''\$wgUseProjects''' aktiwizował, ale njejsy [[MediaWiki:TodoTasksValidProjects]] wutworił. Hlej [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions] za dalše podrobnosće.",
	'tasklistemailbody' => ',

Něchtó je nowy nadawk za tebje na %s připokazal.

Zo by swoju dospołnu lisćinu nadawkow widźał, dźi k %s.

Twój přećelny zdźělenski system %s.',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'tasklist' => 'Feladatlista',
	'tasklist-parser-desc' => '<nowiki>{{#todo:}}</nowiki> elemzőfüggvény feladatok hozzárendeléséhez',
	'tasklist-special-desc' => 'Speciális lap a [[Special:TaskList|feladatok kiosztásának]] nyomonkövetésére',
	'tasklistbyproject' => 'Feladatok listája projektek szerint',
	'tasklistunknownproject' => 'Ismeretlen projekt',
	'tasklistunspecuser' => 'Felhasználó nincs meghatározva',
	'tasklistincorrectuser' => 'Helytelen felhasználói név',
	'tasklistemail' => 'Kedves %s',
	'tasklistemailsubject' => '[%s] feladatlista változás',
	'tasklistmytasks' => 'Feladataim',
	'tasklistbyprojectbad' => "A(z) '''%s''' nem egy érvényes projekt.
Az érvényes projektek listáját a [[MediaWiki:TodoTasksValidProjects]] lapon találod.",
	'tasklistbyprojname' => "'''%s''' kiosztott feladatai",
	'tasklistchooseproj' => 'Projekt kiválasztása:',
	'tasklistprojdisp' => 'Megjelenítés',
	'tasklistbyname' => '== %s feladatlistája ==',
	'tasklistnowguseprojects' => 'A $wgUseProjects változót „false”-ra állítottad, és nem használhatod ezt a lapot.',
	'tasklistnoprojects' => "Hiba: úgy tűnik, hogy bekapcsoltad a '''\$wgUseProjects'''-et, de nem hoztad létre a [[MediaWiki:TodoTasksValidProjects]] lapot. Lásd a [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 telepítési utasításokat] további részletekért.",
	'tasklistemailbody' => '!

Valaki kiosztott neked egy új feladatot a(z) %s lapon.

A teljes feladatlistádat lásd itt: %s.

Üdvözlettel,
a(z) %s értesítő rendszere',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'tasklist' => 'Lista de cargas',
	'tasklist-parser-desc' => 'Adde le function <nowiki>{{#todo:}}</nowiki> al analysator syntactic pro assignar cargas',
	'tasklist-special-desc' => 'Adde un pagina special pro revider [[Special:TaskList|le lista de cargas assignate]]',
	'tasklistbyproject' => 'Lista de cargas per projecto',
	'tasklistunknownproject' => 'Projecto incognite',
	'tasklistunspecuser' => 'Usator non specificate',
	'tasklistincorrectuser' => 'Nomine de usator incorrecte',
	'tasklistemail' => 'Car %s',
	'tasklistemailsubject' => '[%s] Cambiamento al lista de cargas',
	'tasklistmytasks' => 'Mi cargas',
	'tasklistbyprojectbad' => "Le projecto '''%s''' non es valide.
Pro un lista de projectos valide, consulta [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Cargas assignate pro '''%s'''",
	'tasklistchooseproj' => 'Selige projecto:',
	'tasklistprojdisp' => 'Presentar',
	'tasklistbyname' => '== Lista de cargas a facer pro %s ==',
	'tasklistnowguseprojects' => 'Tu ha definite $wgUseProjects a "false" e non pote usar iste pagina.',
	'tasklistnoprojects' => "Error: Pare que tu ha activate '''\$wgUseProjects''' sin crear [[MediaWiki:TodoTasksValidProjects]]. Vide le [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 instructiones de installation] pro ulterior detalios.",
	'tasklistemailbody' => ',

Alcuno te ha assignate un nove carga in %s.

Pro vider tu lista integre de cargas a facer, visita %s.

Amicalmente,
Le systema de notification de %s',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'tasklist' => 'Daftar tugas',
	'tasklist-parser-desc' => 'Menambahkan fungsi parser (parser functions) <nowiki>{{#todo:}}</nowiki> untuk memberikan tugas',
	'tasklist-special-desc' => 'Menambah halaman istimewa untuk meninjau [[Special:TaskList|pemberian tugas]]',
	'tasklistbyproject' => 'Daftar tugas menurut proyek',
	'tasklistunknownproject' => 'Proyek tak dikenal',
	'tasklistunspecuser' => 'Pengguna tak ditentukan',
	'tasklistincorrectuser' => 'Nama pengguna salah',
	'tasklistemail' => 'Dear %s',
	'tasklistemailsubject' => '[%s] Perubahan daftar tugas',
	'tasklistmytasks' => 'Tugas saya',
	'tasklistbyprojectbad' => "Proyek '''%s''' bukanlah proyek yang valid.
Untuk melihat daftar proyek yang valid, gunakan [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Penugasan untuk '''%s'''",
	'tasklistchooseproj' => 'Pilih proyek:',
	'tasklistprojdisp' => 'Tayangan',
	'tasklistbyname' => '== Daftar tugas untuk %s ==',
	'tasklistnowguseprojects' => 'Anda telah mengatur $wgUseProjects menjadi "false" dan tidak dapat menggunakan halaman ini.',
	'tasklistnoprojects' => "Kesalahan: Tampaknya Anda mengaktifkan '''\$wgUseProjects''', tapi tidak membuat [[MediaWiki:TodoTasksValidProjects]]. Lihat [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Petunjuk Instalasi] untuk detail lebih lanjut.",
	'tasklistemailbody' => ',

Seseorang telah memberikan suatu Tugas baru untuk Anda di %s.

Untuk melihat Daftar Tugas lengkap Anda, tuju ke %s.

Sistem notifikasi %s Anda yang bersahabat',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 */
$messages['it'] = array(
	'tasklist' => 'Elenco compiti',
	'tasklist-parser-desc' => 'Aggiunge la funzione del parser <nowiki>{{#todo:}}</nowiki> per assegnare compiti',
	'tasklist-special-desc' => "Aggiunge una pagina speciale per la revisione dell'[[Special:TaskList|assegnazione di compiti]]",
	'tasklistbyproject' => 'Elenco compiti per progetto',
	'tasklistunknownproject' => 'Progetto sconosciuto',
	'tasklistunspecuser' => 'Utente non specificato',
	'tasklistincorrectuser' => 'Nome utente errato',
	'tasklistemail' => 'Gentile %s',
	'tasklistemailsubject' => '[%s] Cambiamento elenco compiti',
	'tasklistmytasks' => 'I propri compiti',
	'tasklistbyprojectbad' => "Il progetto '''%s''' non è un progetto valido.
Per un elenco dei progetti validi consultare [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Compiti assegnati per '''%s'''",
	'tasklistchooseproj' => 'Seleziona progetto:',
	'tasklistprojdisp' => 'Visualizzare',
	'tasklistbyname' => '== Elenco delle cose da fare per %s ==',
	'tasklistnowguseprojects' => 'È stata impostata $wgUseProjects a "false" e non è possibile utilizzare questa pagina.',
	'tasklistnoprojects' => "Errore: sembra che sia stato attivato '''\$wgUseProjects''' ma non è stato creato [[MediaWiki:TodoTasksValidProjects]]. Consultare le [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 istruzioni di installazione] per maggiori dettagli.",
	'tasklistemailbody' => ",

Qualcuno ha assegnato un nuovo compito per te su %s.

Per vedere l'elenco completo dei propri compiti andare su %s.

Il sistema di notifica di %s, al tuo servizio",
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'tasklist' => '課題一覧',
	'tasklist-parser-desc' => '課題割り当てのための <nowiki>{{#todo:}}</nowiki> パーサー関数を加える',
	'tasklist-special-desc' => '[[Special:TaskList|課題割り当て]]を見直すための特別ページを追加する',
	'tasklistbyproject' => 'プロジェクト別課題一覧',
	'tasklistunknownproject' => '不明なプロジェクト',
	'tasklistunspecuser' => '利用者未指定',
	'tasklistincorrectuser' => '不正確な利用者名',
	'tasklistemail' => '%s さんへ',
	'tasklistemailsubject' => '[%s] 課題リストの変更',
	'tasklistmytasks' => '自分の課題',
	'tasklistbyprojectbad' => "プロジェクト「'''%s'''」は有効なプロジェクトではありません。有効なプロジェクトの一覧は、[[MediaWiki:TodoTasksValidProjects]]をご覧ください。",
	'tasklistbyprojname' => "'''%s''' の割り当て済み課題",
	'tasklistchooseproj' => 'プロジェクトを選択:',
	'tasklistprojdisp' => '表示',
	'tasklistbyname' => '== %s の ToDo 一覧==',
	'tasklistnowguseprojects' => '$wgUseProjects が「偽」(false) に設定されているため、このページを使うことはできません。',
	'tasklistnoprojects' => "エラー: あなたは '''\$wgUseProjects''' を有効にしているようですが、[[MediaWiki:TodoTasksValidProjects]] を作成していません。詳細は[http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 インストール手順]をご覧ください。",
	'tasklistemailbody' => '
どなたかがあなたに %s での新しい課題を割り当てました。

あなたに割り当てられている課題一覧は %s で確認できます。

%s 通知システムより',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'tasklist' => 'Daftar Tugas',
	'tasklist-parser-desc' => "Nambahaké <nowiki>{{#todo:}}</nowiki> fungsi parser kanggo nemtokaké tugas-tugas (''tasks'')",
	'tasklist-special-desc' => 'Nambah kaca istiméwa kanggo ninjo [[Special:TaskList|dhpatar tugas]]',
	'tasklistbyproject' => 'Daftar Tugas Per Proyèk',
	'tasklistunknownproject' => 'Proyèk ora ditepungi',
	'tasklistunspecuser' => 'Panganggo ora dispésifikasi',
	'tasklistincorrectuser' => 'Jeneng panganggo ora bener',
	'tasklistemail' => '%s sing minulya',
	'tasklistemailsubject' => '[%s] Owah-owahan ing Daftar Tugas',
	'tasklistmytasks' => 'Tugas-tugasku',
	'tasklistbyprojectbad' => "Proyèk '''%s''' iku dudu proyèk absah.
Kanggo daftar proyèk-proyèk sing absah, mangga mirsani [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Mènèhi Tugas-Tugas kanggo '''%s'''",
	'tasklistchooseproj' => 'Pilihen Proyèk:',
	'tasklistprojdisp' => 'Ndeleng',
	'tasklistbyname' => '== Daftar Tugas kanggo %s ==',
	'tasklistnoprojects' => "KALUPUTAN: Katoné panjenengan nyetèl '''\$wgUseProjects''', nanging ora nggawé [[MediaWiki:TodoTasksValidProjects]]. Delengen [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Instruksi Instalasi] kanggo détail sabanjuré.",
	'tasklistemailbody' => ',

Sawijining wong mènèhi panjenengan Tugas anyar ing %s.

Kanggo niliki Daftar Tugas panjenengan sing pepak mangga lungaa menyang %s.

Sistém notifikasi panjenengan %s',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'tasklist' => 'បញ្ជីពិភាក្សា',
	'tasklistbyproject' => 'បញ្ជី​កិច្ចការ​តាម​គម្រោង',
	'tasklistunknownproject' => 'គម្រោង​មិនស្គាល់',
	'tasklistunspecuser' => 'អ្នកប្រើប្រាស់​ដែល​មិន​ត្រូវ​បាន​បញ្ជាក់',
	'tasklistincorrectuser' => 'អត្តនាមមិនត្រឹមត្រូវ',
	'tasklistemail' => 'ជូនចំពោះ %s',
	'tasklistemailsubject' => '[%s] បំលាស់ប្ដូរ​បញ្ជី​ភារកិច្ច',
	'tasklistmytasks' => 'ភារកិច្ច​របស់ខ្ញុំ',
	'tasklistbyprojname' => "បាន​ផ្ដល់តម្លៃ​ភារកិច្ច​នានា​ជា '''%s'''",
	'tasklistchooseproj' => 'ជ្រើសយក​គម្រោង ៖',
	'tasklistprojdisp' => 'បង្ហាញ',
	'tasklistbyname' => '== បញ្ជី​កិច្ចការ​ដែលត្រូវ​ធ្វើ​ សម្រាប់​ %s ==',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'tasklist' => 'Öpjave-Leß',
	'tasklist-parser-desc' => 'Deit en Fungxjohn <code><nowiki>{{#todo:}}</nowiki></code> em Wiki dobei, öm Opjave verdeile ze künne.',
	'tasklist-special-desc' => 'Deit en [[Special:TaskList|Opjave-Leß]] als Söndersigg em Wiki dobei.',
	'tasklistbyproject' => 'Opjave pro Projek',
	'tasklistunknownproject' => 'Dat Projek kenne mer nit',
	'tasklistunspecuser' => 'Unklohre Metmaacher-Name',
	'tasklistincorrectuser' => 'Verkehte Metmaacher-Name',
	'tasklistemail' => 'Tach %s',
	'tasklistemailsubject' => '[%s]-Opjave-Leß Änderunge',
	'tasklistmytasks' => 'Ming Opjave',
	'tasklistbyprojectbad' => "Dat Projek '''%s''' jit et nit.
Loor op [[MediaWiki:TodoTasksValidProjects]] noh de Projekte.",
	'tasklistbyprojname' => "Opjave för '''%s'''",
	'tasklistchooseproj' => 'Projekt ußwähle:',
	'tasklistprojdisp' => 'Zeije',
	'tasklistbyname' => '== Opjaveliss för %s ==',
	'tasklistnowguseprojects' => 'Heh em Wiki es <code lang="en">$wgUseProjects</code> op „verkeeht“ jesaz, dröm kanns De heh di Sigg och nit bruche.',
	'tasklistnoprojects' => "'''Fähler:''' Et süht us, wi wann De <code>\$wgUseProjects</code>
aanjeschalldt häts, ävver [[MediaWiki:TodoTasksValidProjects]]
nit opjesatz häts. Loor Der op de
[http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Aanleidungssigge]
aan, wi et jenou jemaat weed.",
	'tasklistemailbody' => ',

Op %s hät Der einer en Opjav zojedeilt.

Ding Opjaveleß kanns De Der op %s aanloore.

Ding fründlesch %s Süstem för Bescheid ze sare.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'tasklist' => 'Lëscht vun den Aufgaben',
	'tasklist-parser-desc' => "setzt d'<nowiki>{{#todo:}}</nowiki> Parserfonctioun derbäi fir Aufgaben zouzedeelen",
	'tasklist-special-desc' => 'Setzt eng Spezialsäit derbäi mat nger Iwwersiicht vun den [[Special:TaskList|zugdeelten Aufgaben]]',
	'tasklistbyproject' => 'Lëscht vun den Aufgabe pro Projet',
	'tasklistunknownproject' => 'Onbekannte Projet',
	'tasklistunspecuser' => 'Onbestemmte Benotzer',
	'tasklistincorrectuser' => 'Falsche Benotzernumm',
	'tasklistemail' => 'Léiwe %s',
	'tasklistemailsubject' => '[%s] Ännerunge vun der Lëscht vun den Aufgaben',
	'tasklistmytasks' => 'Meng Aufgaben',
	'tasklistbyprojectbad' => "De Projet '''%s''' ass an dësem Kontext net disponibel.
Fir eng Lëschtvun den disponibele Projeten, kuckt w.e.g. [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Aufgaben déi dem '''%s''' zougedeelt sinn.",
	'tasklistchooseproj' => 'Projet auswielen:',
	'tasklistprojdisp' => 'Weisen',
	'tasklistbyname' => '== Lëscht vun den Aufgabe fir %s ==',
	'tasklistnowguseprojects' => 'Dir hutt $wgUseProjects op "false" gesat a kënnt dës Säit net benotzen.',
	'tasklistnoprojects' => "FEELER: Et gesäit esou aus wéi wann Dir '''\$wgUseProjects''' ageschalt hätt, mee Dir hutt [[MediaWiki:TodoTasksValidProjects]] net erstalt. Kuckt [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installatiouns Instructiounen] fir méi Informatiounen.",
	'tasklistemailbody' => ',

Iergend een huet Iech op %s eng Aufgab zougedeelt.

Fir är komplett Aufgabelëscht ze gesinn, gitt w.e.g. op %s.

Äre frëndleche  %s Informatiounssystem',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'tasklist' => 'Список на задачи',
	'tasklist-parser-desc' => 'Додава парерска функција <nowiki>{{#todo:}}</nowiki> за доделување на задачи',
	'tasklist-special-desc' => 'Додава специјална страница за прегледување на [[Special:TaskList|доделени задачи]]',
	'tasklistbyproject' => 'Список на задачи по проект',
	'tasklistunknownproject' => 'Непознат проект',
	'tasklistunspecuser' => 'Неназначен корисник',
	'tasklistincorrectuser' => 'Погрешно корисничко име',
	'tasklistemail' => 'Почитуван(a) %s',
	'tasklistemailsubject' => '[%s] Промена на список на задачи',
	'tasklistmytasks' => 'Мои задачи',
	'tasklistbyprojectbad' => "Проектот '''%s''' не е важечки проект.
За список на важечки проекти, погледајте [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Доделени задачи за '''%s'''",
	'tasklistchooseproj' => 'Изберете проект:',
	'tasklistprojdisp' => 'Прикажи',
	'tasklistbyname' => '== Список на задачи за %s ==',
	'tasklistnowguseprojects' => 'Го имате наместено $wgUseProjects на „false“ и затоа не можете да ја користите оваа страница.',
	'tasklistnoprojects' => "Грешка: Изгледа сте овозможиле '''\$wgUseProjects''', но не сте создале [[MediaWiki:TodoTasksValidProjects]]. Видете [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Напатствија за инсталирање] за повеќе детали.",
	'tasklistemailbody' => 'Некој ви доделил нова Задача на %s.

За да ја видите вашиот полн Список на задачи, одете на %s.

Вашиот систем известување на %s',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'tasklistunknownproject' => 'അജ്ഞാതമായ സം‌രംഭം',
	'tasklistincorrectuser' => 'തെറ്റായ ഉപയോക്തൃനാമം',
	'tasklistemail' => 'നമസ്കാരം %s',
	'tasklistprojdisp' => 'പ്രദർശിപ്പിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'tasklist' => 'कार्य यादी',
	'tasklistbyproject' => 'प्रकल्पानुसार कामांची यादी',
	'tasklistunknownproject' => 'अनोळखी प्रकल्प',
	'tasklistunspecuser' => 'न दिलेला सदस्य',
	'tasklistincorrectuser' => 'चुकीचे सदस्यनाव',
	'tasklistemail' => 'प्रिय %s',
	'tasklistemailsubject' => '[%s] कार्य यादी बदल',
	'tasklistmytasks' => 'माझ्या जबाबदार्‍या',
	'tasklistchooseproj' => 'प्रकल्प निवडा:',
	'tasklistprojdisp' => 'दर्शवा',
	'tasklistbyname' => '== %s साठीची करायच्या गोष्टींची यादी ==',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'tasklistincorrectuser' => 'Ahcualli tlatequitiltilīltōcāitl',
	'tasklistemail' => 'Mahuizoh %',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'tasklist' => 'Oppgaveliste',
	'tasklist-parser-desc' => 'legger til <nowiki>{{#todo:}}</nowiki> for tildeling av oppgaver',
	'tasklist-special-desc' => 'Legger til en spesialside for gjennomgang av [[Special:TaskList|oppgaver]]',
	'tasklistbyproject' => 'Oppgaveliste etter prosjekt',
	'tasklistunknownproject' => 'Ukjent prosjekt',
	'tasklistunspecuser' => 'Bruker ikke angitt',
	'tasklistincorrectuser' => 'Ukorrekt brukernavn',
	'tasklistemail' => 'Kjære %s',
	'tasklistemailsubject' => '[%s] Oppgavelisteendring',
	'tasklistmytasks' => 'Mine oppgaver',
	'tasklistbyprojectbad' => "'''%s''' er ikke et gyldig prosjekt. For en liste over gyldige prosjekter, se [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tildelte oppgaver for '''%s'''",
	'tasklistchooseproj' => 'Velg prosjekt:',
	'tasklistprojdisp' => 'Vis',
	'tasklistbyname' => '== Oppgaveliste for %s ==',
	'tasklistnowguseprojects' => 'Du har satt $wgUseProjects til «false» og kan ikke bruke denne siden.',
	'tasklistnoprojects' => "FEIL: Det ser ut som om du har slått på '''\$wgUseProjects''' uten å opprette [[MediaWiki:TodoTasksValidProjects]]. Se [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 installasjonsintruksjonene] for flere detaljer.",
	'tasklistemailbody' => ',

Noen har gitt deg en ny oppgave på %s.

Gå til %s for å se den fullstendige oppgavelisten din.

Fra %ss varslingssystem',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'tasklistunknownproject' => 'Unbekannt Projekt',
	'tasklistemail' => 'Leve %s',
	'tasklistmytasks' => 'Miene Opgaven',
	'tasklistchooseproj' => 'Projekt utwählen:',
	'tasklistbyname' => '== Opgavenlist för %s ==',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'tasklist' => 'Takenlijst',
	'tasklist-parser-desc' => 'Voegt de parserfunctie <nowiki>{{#todo:}}</nowiki> toe om taken toe te wijzen',
	'tasklist-special-desc' => 'Voegt een speciale pagina toe om [[Special:TaskList|takentoewijzingen]] na te kijken',
	'tasklistbyproject' => 'Takenlijst per project',
	'tasklistunknownproject' => 'Onbekend project',
	'tasklistunspecuser' => 'Gebruiker niet aangegeven',
	'tasklistincorrectuser' => 'Gebruiker bestaat niet',
	'tasklistemail' => 'Beste %s',
	'tasklistemailsubject' => '[%s] verandering in takenlijst',
	'tasklistmytasks' => 'Mijn taken',
	'tasklistbyprojectbad' => "Project '''%s''' is geen geldige projectnaam. Een lijst met projecten is te vinden op [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Toegewezen taken voor '''%s'''",
	'tasklistchooseproj' => 'Project selecteren:',
	'tasklistprojdisp' => 'Bekijken',
	'tasklistbyname' => '== Takenlijst voor %s ==',
	'tasklistnowguseprojects' => 'U hebt $wgUseProjects ingesteld op "false" en kunt deze pagina niet gebruiken.',
	'tasklistnoprojects' => "FOUT: het lijkt alsof u '''\$wgUseProjects''' hebt ingeschakeld, maar [[MediaWiki:TodoTasksValidProjects]] niet hebt aangemaakt. Zie de  [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 installatie-instructies] voor meer details.",
	'tasklistemailbody' => ',

Iemand heeft een nieuwe taak aan u toegewezen op %s.

Op %s kunt u uw complete takenlijst bekijken.

Het waarschuwingssysteem',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 */
$messages['nn'] = array(
	'tasklist' => 'Oppgåveliste',
	'tasklist-parser-desc' => 'legg til <nowiki>{{#todo:}}</nowiki> for tildeling av oppgåver',
	'tasklist-special-desc' => 'Legg til ei spesialside for gjennomgang av [[Special:TaskList|oppgåver]]',
	'tasklistbyproject' => 'Oppgåveliste etter prosjekt',
	'tasklistunknownproject' => 'Ukjend prosjekt',
	'tasklistunspecuser' => 'Brukar ikkje gjeve',
	'tasklistincorrectuser' => 'Ukorrekt brukarnamn',
	'tasklistemail' => 'Kjære %s',
	'tasklistemailsubject' => '[%s] Oppgåvelisteendring',
	'tasklistmytasks' => 'Mine oppgåver',
	'tasklistbyprojectbad' => "'''%s''' er ikkje eit gyldig prosjekt. For ei liste over gyldige prosjekt, sjå [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tildelte oppgåver for '''%s'''",
	'tasklistchooseproj' => 'Velg prosjekt:',
	'tasklistprojdisp' => 'Vis',
	'tasklistbyname' => '== Oppgåveliste for %s ==',
	'tasklistnoprojects' => "FEIL: Det ser ut som om du har slått på '''\$wgUseProjects''' utan å opprette [[MediaWiki:TodoTasksValidProjects]]. Sjå [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 installasjonsintruksjonane] for fleire detaljar.",
	'tasklistemailbody' => ',

Noko har gjeve deg ei ny oppgåve på %s.

Gå til %s for å sjå den fullstendige oppgåvelista da.

Frå %ss varslingssystem',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'tasklist' => 'Lista de prètzfaches',
	'tasklist-parser-desc' => 'Apond <nowiki>{{#todo:}}</nowiki> una foncion parser per assignar de prètzfaches',
	'tasklist-special-desc' => 'Apond una pagina especiala per revisar [[Special:TaskList|la lista dels prètzfaches assignats]]',
	'tasklistbyproject' => 'Lista de prètzfaches per projècte',
	'tasklistunknownproject' => 'Projècte desconegut',
	'tasklistunspecuser' => 'Contributor desconegut',
	'tasklistincorrectuser' => 'Pseudonim incorrècte',
	'tasklistemail' => 'Car(a) %s',
	'tasklistemailsubject' => '[%s] Cambiament a la lista de prètzfaches',
	'tasklistmytasks' => 'Mos prètzfaches',
	'tasklistbyprojectbad' => "Lo projècte '''%s''' es pas valid. Consultatz la [[MediaWiki:TodoTasksValidProjects|lista dels projèctes]].",
	'tasklistbyprojname' => "Prètzfaches assignats per '''%s'''.",
	'tasklistchooseproj' => 'Projècte seleccionat :',
	'tasklistprojdisp' => 'Afichar',
	'tasklistbyname' => '== Lista de prètzfaches de far per %s ==',
	'tasklistnowguseprojects' => 'Avètz definit $wgUseProjects a « false » e doncas, podètz pas utilizar aquesta pagina.',
	'tasklistnoprojects' => "Error : sembla qu'avètz activat '''\$wgUseProjects''', mas sens aver creat [[MediaWiki:TodoTasksValidProjects]]. Legissètz las [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 instruccions d'installacion] per mai de detalhs.",
	'tasklistemailbody' => ",

Qualqu'un vos a assignat un prètzfach novèl sus %s.

Per veire vòstra lista completa dels prètzfaches d'efectuar, anatz sus %s.

Vòstre plan amable sistèma de notificacion de %s",
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'tasklist' => 'Lista zadań',
	'tasklist-parser-desc' => 'Dodaje funkcję parsera <nowiki>{{#todo:}}</nowiki>, pozwalającą na przydzielanie zadań',
	'tasklist-special-desc' => 'Dodaje stronę specjalną do przeglądania [[Special:TaskList|przydzielonych zadań]]',
	'tasklistbyproject' => 'Listy zadań według projektu',
	'tasklistunknownproject' => 'Nieznany projekt',
	'tasklistunspecuser' => 'Nie określono użytkownika',
	'tasklistincorrectuser' => 'Niepoprawna nazwa użytkownika',
	'tasklistemail' => '%s',
	'tasklistemailsubject' => '[%s] Zmiana listy zadań',
	'tasklistmytasks' => 'Moje zadania',
	'tasklistbyprojectbad' => "'''%s''' nie jest poprawnym projektem.
Listę poprawnych projektów znajdziesz na stronie [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Przypisano zadania do '''%s'''",
	'tasklistchooseproj' => 'Wybierz projekt:',
	'tasklistprojdisp' => 'Wyświetl',
	'tasklistbyname' => '== Lista zadań do wykonania dla %s ==',
	'tasklistnowguseprojects' => 'Nie możesz korzystać z tej strony ponieważ opcja $wgUseProjects została ustawiona na „false“.',
	'tasklistnoprojects' => "BŁĄD: Najprawdopodobniej włączono zmienną '''\$wgUseProjects''', lecz nie utworzono pliku [[MediaWiki:TodoTasksValidProjects]]. Szczegóły w pliku [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Instrukcja instalacji].",
	'tasklistemailbody' => ',

Ktoś przydzielił Ci nowe zadanie w %s.

By zobaczyć kompletną listę zadań, przejdź do strony %s.

%s – automatyczny system informowania.',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'tasklist' => 'Lista dij travaj',
	'tasklist-parser-desc' => 'A gionta la funsion dël parser <nowiki>{{#todo:}}</nowiki> për assigné ëd travaj',
	'tasklist-special-desc' => "A gionta na pàgina special për revisioné [[Special:TaskList|l'assegnassion ëd travaj]]",
	'tasklistbyproject' => 'Lista ëd travaj për proget',
	'tasklistunknownproject' => 'Proget pa conossù',
	'tasklistunspecuser' => 'Utent pa spessifià',
	'tasklistincorrectuser' => 'Nòm utent pa giust',
	'tasklistemail' => 'Gentil %s',
	'tasklistemailsubject' => '[%s] Cambi dla lista dij travaj',
	'tasklistmytasks' => 'Ij mè travaj',
	'tasklistbyprojectbad' => "Ël proget '''%s''' a l'é pa un proget bon.
Për na lista ëd proget bon, varda [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Travaj assignà për '''%s'''",
	'tasklistchooseproj' => 'Proget selessionà:',
	'tasklistprojdisp' => 'Visualisa',
	'tasklistbyname' => '== Lista da fé për %s ==',
	'tasklistnowguseprojects' => 'It l\'has ampostà $wgUseProjects a "fàuss" e it peule pa dovré sta pàgina-sì.',
	'tasklistnoprojects' => "Eror: A smija ch'it l'abie ativà '''\$wgUseProjects''', ma it l'abie pa creà [[MediaWiki:TodoTasksValidProjects]]. varda [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Istrussion d'Instalassion] për savèjne ëd pì.",
	'tasklistemailbody' => ",

Cheidun a l'ha assignà un neuv travaj për ti an %s.

Për vëdde la Lista completa dij tò Travaj va a %s.

Ël to sistema amis ëd notificassion",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'tasklist' => 'د دندو لړليک',
	'tasklistbyproject' => 'د پروژې له مخې د دندو لړليک',
	'tasklistunspecuser' => 'ناځانګړی کارن',
	'tasklistincorrectuser' => 'ناسم کارن-نوم',
	'tasklistmytasks' => 'زما دندې',
	'tasklistchooseproj' => 'پروژه ټاکل:',
	'tasklistprojdisp' => 'ښکاره کول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'tasklist' => 'Lista de Tarefas',
	'tasklist-parser-desc' => 'Adiciona a função <nowiki>{{#todo:}}</nowiki> ao analisador sintáctico, para atribuição de tarefas',
	'tasklist-special-desc' => '[[Special:TaskList|Página especial]] para a revisão de tarefas atribuídas',
	'tasklistbyproject' => 'Lista de Tarefas por Projecto',
	'tasklistunknownproject' => 'projecto deconhecido',
	'tasklistunspecuser' => 'Utilizador não especificado',
	'tasklistincorrectuser' => 'Nome de utilizador incorrecto',
	'tasklistemail' => 'Caro %s',
	'tasklistemailsubject' => '[%s] Mudança na lista de tarefas',
	'tasklistmytasks' => 'Minhas tarefas',
	'tasklistbyprojectbad' => "Projecto '''%s''' não é um projecto válido.
Para uma lista de projectos válidos, ver [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tarefas atribuídas a '''%s'''",
	'tasklistchooseproj' => 'Seleccione Projecto:',
	'tasklistprojdisp' => 'Mostrar',
	'tasklistbyname' => '== Lista de tarefas de %s ==',
	'tasklistnowguseprojects' => 'Definiu $wgUseProjects como "falso" e não pode usar esta página.',
	'tasklistnoprojects' => "Erro: Aparentement activou '''\$wgUseProjects''', mas não criou [[MediaWiki:TodoTasksValidProjects]]. Veja as [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Instruções de Instalação] para mais detalhes.",
	'tasklistemailbody' => ',

Alguém lhe atribuiu uma nova Tarefa em %s.

Para ver a sua Lista de Tarefas completa, vá a %s.

O seu sistema de notificação amigável da %s',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'tasklist' => 'Lista de Tarefas',
	'tasklist-parser-desc' => 'Adiciona a função do analisador (parser) <nowiki>{{#todo:}}</nowiki> para a atribuição de tarefas',
	'tasklist-special-desc' => 'Adiciona uma página especial para a revisão de [[Special:TaskList|atribuições de tarefas]]',
	'tasklistbyproject' => 'Lista de Tarefas por Projeto',
	'tasklistunknownproject' => 'Projeto deconhecido',
	'tasklistunspecuser' => 'Utilizador não especificado',
	'tasklistincorrectuser' => 'Nome de utilizador incorreto',
	'tasklistemail' => 'Caro %s',
	'tasklistemailsubject' => '[%s] Mudança na lista de tarefas',
	'tasklistmytasks' => 'Minhas tarefas',
	'tasklistbyprojectbad' => "Projeto '''%s''' não é um projeto válido.
Para uma lista de projetos válidos, ver [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tarefas atribuídas a '''%s'''",
	'tasklistchooseproj' => 'Selecione Projeto:',
	'tasklistprojdisp' => 'Mostrar',
	'tasklistbyname' => '== Lista de tarefas de %s ==',
	'tasklistnowguseprojects' => 'Definiu $wgUseProjects como "falso" e não pode usar esta página.',
	'tasklistnoprojects' => "Erro: Aparentemente você ativou '''\$wgUseProjects''', mas não criou [[MediaWiki:TodoTasksValidProjects]]. Veja as [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Instruções de Instalação] para mais detalhes.",
	'tasklistemailbody' => ',

Alguém atribuiu-lhe uma nova Tarefa em %s.

Para ver a sua Lista de Tarefas completa, vá a %s.

O seu sistema de notificação amigável de %s',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'tasklist' => 'Listă de sarcini',
	'tasklistbyproject' => 'Lista de sarcini după proiect',
	'tasklistunknownproject' => 'Proiect necunoscut',
	'tasklistunspecuser' => 'Utilizator nespecificat',
	'tasklistincorrectuser' => 'Nume de utilizator incorect',
	'tasklistemail' => 'Dragă %s',
	'tasklistmytasks' => 'Sarcinile mele',
	'tasklistchooseproj' => 'Alegeți proiectul:',
	'tasklistprojdisp' => 'Afișare',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'tasklist' => 'Liste de le combete',
	'tasklistunknownproject' => 'Pruggette scanusciute',
	'tasklistemail' => '%s Belle mie',
	'tasklistchooseproj' => "Scacchie 'u pruggette:",
	'tasklistprojdisp' => 'Fa vedè',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Rubin
 * @author Александр Сигачёв
 * @author Сrower
 */
$messages['ru'] = array(
	'tasklist' => 'Список задач',
	'tasklist-parser-desc' => 'Добавляет функцию парсера <nowiki>{{#todo:}}</nowiki> для назначения задач',
	'tasklist-special-desc' => 'Добавляет служебную страницу для просмотра [[Special:TaskList|назначенных задач]]',
	'tasklistbyproject' => 'Список задач по проектам',
	'tasklistunknownproject' => 'Неизвестный проект',
	'tasklistunspecuser' => 'Неизвестный участник',
	'tasklistincorrectuser' => 'Неправильное имя участника',
	'tasklistemail' => 'Уважаемый(ая) %s',
	'tasklistemailsubject' => '[%s] Изменение списка задач',
	'tasklistmytasks' => 'Мои задачи',
	'tasklistbyprojectbad' => "Проект '''%s''' не является корректным.
Список действующих проектов можно посмотреть на [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Назначенный задачи для '''%s'''",
	'tasklistchooseproj' => 'Выберите проект:',
	'tasklistprojdisp' => 'Показать',
	'tasklistbyname' => '== Список задач для %s ==',
	'tasklistnowguseprojects' => 'Вы установили $wgUseProjects в значение «false» и не можете использовать эту страницу.',
	'tasklistnoprojects' => "Ошибка. Похоже, что вы включили '''\$wgUseProjects''', но не создали [[MediaWiki:TodoTasksValidProjects]]. Подробнее см. в [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Руководстве по установке].",
	'tasklistemailbody' => ',

Кто-то назначил для вас новую задачу в %s.

Что просмотреть весь список задач, обратитесь к %s.

Ваша система уведомления %s.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'tasklist' => 'Zoznam úloh',
	'tasklist-parser-desc' => 'pridáva funkciu syntaktického analyzátora <nowiki>{{#todo:}}</nowiki> na prideľovanie úloh',
	'tasklist-special-desc' => 'Pridáva špeciálnu stránku na kontrolu [[Special:TaskList|pridelených úloh]]',
	'tasklistbyproject' => 'Zoznam úloh podľa projektov',
	'tasklistunknownproject' => 'Neznámy projekt',
	'tasklistunspecuser' => 'Nešpecifikovaný používateľ',
	'tasklistincorrectuser' => 'Nesprávne používateľské meno',
	'tasklistemail' => 'Milý %s',
	'tasklistemailsubject' => '[%s] Zmena zoznamu úloh',
	'tasklistmytasks' => 'Moje úlohy',
	'tasklistbyprojectbad' => "Projekt '''%s''' nie je platný projekt. Zoznam platných projektov nájdete na [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Pridelené úlohy pre '''%s'''",
	'tasklistchooseproj' => 'Vyberte projekt:',
	'tasklistprojdisp' => 'Zobraziť',
	'tasklistbyname' => '== Zoznam úloh pre %s ==',
	'tasklistnoprojects' => "CHYBA: Zdá sa, že ste zapli  '''\$wgUseProjects''', ale nevytvorili ste [[MediaWiki:TodoTasksValidProjects]]. Pozri podrobnosti v [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Inštalačných inštrukciách].",
	'tasklistemailbody' => ',

Niekto vám %s priradil novú úlohu.

Svoj kompletný Zoznam úloh si môžete pozrieť na %s.

Váš priateľský upozorňovací systém %s',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'tasklist' => 'Списак послова',
	'tasklist-parser-desc' => 'Додаје рашчлањивачку функцију <nowiki>{{#todo:}}</nowiki> за додељивање задатака',
	'tasklist-special-desc' => 'Додаје посебну страницу за преглед [[Special:TaskList|додељених задатака]]',
	'tasklistbyproject' => 'Списак задатака по пројекту',
	'tasklistunknownproject' => 'Непознати пројекат',
	'tasklistunspecuser' => 'Неодређени корисник',
	'tasklistincorrectuser' => 'Неисправно корисничко име',
	'tasklistemail' => 'Драги %s',
	'tasklistemailsubject' => '[%s] Промена списка задатака',
	'tasklistmytasks' => 'Моји задаци',
	'tasklistchooseproj' => 'Изабери пројекат:',
	'tasklistprojdisp' => 'Прикажи',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'tasklist' => 'Spisak poslova',
	'tasklist-parser-desc' => 'Dodaje raščlanjivačku funkciju <nowiki>{{#todo:}}</nowiki> za dodeljivanje zadataka',
	'tasklist-special-desc' => 'Dodaje posebnu stranicu za pregled [[Special:TaskList|dodeljenih zadataka]]',
	'tasklistbyproject' => 'Spisak zadataka po projektu',
	'tasklistunknownproject' => 'Nepoznati projekat',
	'tasklistunspecuser' => 'Neodređeni korisnik',
	'tasklistincorrectuser' => 'Neispravno korisničko ime',
	'tasklistemail' => 'Dragi %s',
	'tasklistemailsubject' => '[%s] Promena spiska zadataka',
	'tasklistmytasks' => 'Moji zadaci',
	'tasklistchooseproj' => 'Izaberi projekat:',
	'tasklistprojdisp' => 'Prikaži',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'tasklist' => 'Apgoawenlieste',
	'tasklist-parser-desc' => 'Föiget ju Parserfunktion <nowiki>{{#todo:}}</nowiki> toun Tou-oardenjen fon Apgoawen bietou',
	'tasklist-special-desc' => 'Föiget ne Spezioalsiede foar ju Ätterpröiwenge fon [[Special:TaskList|Apgoawentoudeelengen]] bietou',
	'tasklistbyproject' => 'Apgoawenlieste pro  Projekt',
	'tasklistunknownproject' => 'Uunbekoand Projekt',
	'tasklistunspecuser' => 'Uunbestimde Benutsernoome',
	'tasklistincorrectuser' => 'Falsken Benutsernoome',
	'tasklistemail' => 'Moin %s',
	'tasklistemailsubject' => '[%s]-Apgoawenlieste Annerengen',
	'tasklistmytasks' => 'Mien Apgoawen',
	'tasklistbyprojectbad' => "Projekt '''%s''' is nit deer. Foar ne Lieste fon gultige Projekte sjuch [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Touwiesde Apgoawen foar '''%s'''",
	'tasklistchooseproj' => 'Projekt uutwääle:',
	'tasklistprojdisp' => 'Anwiese',
	'tasklistbyname' => '== Apgoawenlieste foar %s ==',
	'tasklistnoprojects' => "Failer: Dät sjucht so uut, as wan '''\$wgUseProjects''' aktivierd waas, man der wuuden neen Sieden [[MediaWiki:TodoTasksValidProjects]] moaked. Sjuch do
[http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installationsanwiesengen] foar wiedere Details.",
	'tasklistemailbody' => ',

Wäl häd die ne näie Apgoawe bie %s tou-oardend.

Toun Bekiekjen fon dien komplette Apgoawenlieste sjuch %s.

Dien früntelk %s-Beskeed-täl-System',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Per
 * @author Reedy
 */
$messages['sv'] = array(
	'tasklist' => 'Uppgiftslista',
	'tasklist-parser-desc' => 'lägger till parser funktionen <nowiki>{{#todo:}}</nowiki> för tilldelning av uppgifter',
	'tasklist-special-desc' => 'Lägger till en specialsida för granskning av [[Special:TaskList|uppgifter]]',
	'tasklistbyproject' => 'Uppgiftslista efter projekt',
	'tasklistunknownproject' => 'Okänt projekt',
	'tasklistunspecuser' => 'Användare ej angiven',
	'tasklistincorrectuser' => 'Felaktigt användarnamn',
	'tasklistemail' => 'Kära %s',
	'tasklistemailsubject' => '[%s] Uppgiftslistsändring',
	'tasklistmytasks' => 'Mina uppgifter',
	'tasklistbyprojectbad' => "'''%s''' är inte ett giltigt projekt.
För en lista över giltiga projekt, se [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname' => "Tilldelade uppgifter för '''%s'''",
	'tasklistchooseproj' => 'Välj projekt:',
	'tasklistprojdisp' => 'Visa',
	'tasklistbyname' => '== Uppgiftslista för %s ==',
	'tasklistnowguseprojects' => 'Du har satt $wgUseProjects till «false» och kan inte använda denna sidan.',
	'tasklistnoprojects' => "FEL: Det ser ut som om du har satt på '''\$wgUseProjects''' utan att skapa [[MediaWiki:TodoTasksValidProjects]]. Se [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 installationsinstruktionerna] för mer detaljer.",
	'tasklistemailbody' => ',

Någon har givit dig en ny uppgift på %s.

Gå till %s för att se din fullständiga uppgiftslista.

Från %ss meddelningssystem.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'tasklist' => 'పనుల జాబితా',
	'tasklist-special-desc' => '[[Special:TaskList|పనుల అప్పగింతలను]] సమీక్షించడానికి ఒక ప్రత్యేక పేజీని చేరుస్తుంది',
	'tasklistbyproject' => 'ప్రాజెక్టులవారీగా పనుల జాబితా',
	'tasklistunknownproject' => 'తెలియని ప్రాజెక్టు',
	'tasklistincorrectuser' => 'తప్పుడు వాడుకరిపేరు',
	'tasklistemail' => 'ప్రియమైన %s',
	'tasklistemailsubject' => '[%s] పనుల జాబితా మార్పు',
	'tasklistmytasks' => 'నా పనులు',
	'tasklistchooseproj' => 'ప్రాజెక్టుని ఎంచుకోండి:',
	'tasklistprojdisp' => 'చూపించు',
	'tasklistbyname' => '== %s కొరకు చేయాల్సిన పనుల జాబితా ==',
	'tasklistemailbody' => ',

%s లో మీకు ఎవరో ఒక కొత్త పనిని అప్పగించారు.

మీ పూర్తి పనుల జాబితాని చూడటానికి %s కి వెళ్ళండి.

మీ స్నేహపూర్వక %s గమనింపు వ్యవస్థ',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'tasklist' => 'Феҳристи Вазифа',
	'tasklistbyproject' => 'Феҳристи Вазифа Тавассути Лоиҳа',
	'tasklistunknownproject' => 'Лоиҳаи ношинос',
	'tasklistunspecuser' => 'Корбари мушаххаснашуда',
	'tasklistincorrectuser' => 'Номи корбарии нодуруст',
	'tasklistemail' => 'Мӯҳтарам %s',
	'tasklistmytasks' => 'Вазифаҳои ман',
	'tasklistbyprojname' => "Вазифаҳои таъйин шуда барои '''%s'''",
	'tasklistchooseproj' => 'Интихоби Лоиҳа:',
	'tasklistprojdisp' => 'Намоиш',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'tasklist' => 'Fehristi Vazifa',
	'tasklistbyproject' => 'Fehristi Vazifa Tavassuti Loiha',
	'tasklistunknownproject' => 'Loihai noşinos',
	'tasklistunspecuser' => 'Korbari muşaxxasnaşuda',
	'tasklistincorrectuser' => 'Nomi korbariji nodurust',
	'tasklistemail' => 'Mūhtaram %s',
	'tasklistmytasks' => 'Vazifahoi man',
	'tasklistbyprojname' => "Vazifahoi ta'jin şuda baroi '''%s'''",
	'tasklistchooseproj' => 'Intixobi Loiha:',
	'tasklistprojdisp' => 'Namoiş',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'tasklist' => 'Talaan ng gawain',
	'tasklist-parser-desc' => 'Nagdaragdag ng tungkuling pambanghay na <nowiki>{{#mgagagawin:}}</nowiki> para sa pagtatakda ng mga gawain',
	'tasklist-special-desc' => 'Nagdaragdag ng isang natatanging pahina para sa muling pagsusuri ng [[Special:TaskList|mga pagtatakda ng mga gawain]]',
	'tasklistbyproject' => 'Talaan ng gawain ayon sa proyekto',
	'tasklistunknownproject' => 'Hindi nalalamang proyekto',
	'tasklistunspecuser' => 'Hindi natukoy na tagagamit',
	'tasklistincorrectuser' => 'Hindi tamang pangalan ng tagagamit',
	'tasklistemail' => 'Mahal na %s',
	'tasklistemailsubject' => '[%s] Pagbabago sa talaan ng gawain',
	'tasklistmytasks' => 'Mga gawain ko',
	'tasklistbyprojectbad' => "Hindi isang tanggap na proyekto ang '''%s'''.
Para sa isang talaan ng tanggap na mga proyekto, tingnan ang [[MediaWiki:TodoTasksValidProjects|MediaWiki:GagawingMgaGawainTanggapNaMgaProyekto]].",
	'tasklistbyprojname' => "Nakatakdang mga gawain para kay '''%s'''",
	'tasklistchooseproj' => 'Pumili ng proyekto:',
	'tasklistprojdisp' => 'Palitawin',
	'tasklistbyname' => '== Talaan ng gagawin para kay %s ==',
	'tasklistnowguseprojects' => 'Itinakda mo ang $wgUseProjects sa "mali" at hindi magagamit ang pahinang ito.',
	'tasklistnoprojects' => "Kamalian: Tila mukhang pinaandar mo ang '''\$wgGamitinMgaProyekto''', ngunit hindi lumikha ng [[MediaWiki:TodoTasksValidProjects]]. Tingnan ang  [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Mga Panuto Hinggil sa Pagluluklok (Instalasyon)] para sa mas marami pang mga detalye.",
	'tasklistemailbody' => ',

Mayroong isang tao na nagtakda sa iyo ng isang bagong Gawain sa %s.

Upang tingnan ang kabuoan ng Talaan ng Gawain mo pumunta sa %s.

Ang iyong palakaibigang sistemang tagapagbigay ng ulat ng %s',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'tasklist' => 'Görev listesi',
	'tasklistbyproject' => 'Projeye göre görev listesi',
	'tasklistunknownproject' => 'Bilinmeyen proje',
	'tasklistunspecuser' => 'Belirtilmemiş kullanıcı',
	'tasklistincorrectuser' => 'Yanlış kullanıcı adı',
	'tasklistemail' => 'Sayın %s',
	'tasklistmytasks' => 'Görevlerim',
	'tasklistchooseproj' => 'Proje seçin:',
	'tasklistprojdisp' => 'Gösteri',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'tasklist' => 'Список завдань',
	'tasklistbyproject' => 'Список завдань по проектах',
	'tasklistunknownproject' => 'Невідомий проект',
	'tasklistunspecuser' => 'Невизначений користувач',
	'tasklistincorrectuser' => "Неправильне ім'я користувача",
	'tasklistmytasks' => 'Мої завдання',
	'tasklistchooseproj' => 'Оберіть проект:',
	'tasklistprojdisp' => 'Показати',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'tasklistunknownproject' => 'Tundmatoi proekt',
	'tasklistunspecuser' => 'Tundmatoi kävutai',
	'tasklistincorrectuser' => 'Vär kävutajan nimi',
	'tasklistemail' => 'Kalliž %s',
	'tasklistmytasks' => 'Minun metod',
	'tasklistchooseproj' => 'Valiče projekt:',
	'tasklistprojdisp' => 'Ozutada',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'tasklist' => 'Danh sách công việc',
	'tasklistbyproject' => 'Danh sách công việc theo dự án',
	'tasklistemail' => 'Chào %s',
	'tasklistmytasks' => 'Công việc của tôi',
	'tasklistchooseproj' => 'Chọn dự án:',
	'tasklistprojdisp' => 'Hiển thị',
	'tasklistbyname' => '== Danh sách công việc của %s ==',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'tasklist' => 'Vobodalised',
	'tasklistunknownproject' => 'Proyeg nesevädik',
	'tasklistincorrectuser' => 'Gebananem neverätik',
	'tasklistemail' => 'O %s löfik',
	'tasklistmytasks' => 'Vobods obik',
	'tasklistbyprojectbad' => "Proyeg: '''%s''' no lonöfon.
Kanol tuvön lisedi proyegas lonöföl su pad: [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistchooseproj' => 'Välön proyega:',
);

/** Chinese (China) (‪中文(中国大陆)‬) */
$messages['zh-cn'] = array(
	'tasklist' => '任务列表',
	'tasklistbyproject' => '依专案列出任务',
	'tasklistunknownproject' => '未知的专案',
	'tasklistunspecuser' => '未指定用户',
	'tasklistincorrectuser' => '用户名称错误',
	'tasklistemail' => '%s您好',
	'tasklistemailsubject' => '[%s] 任务列表变更',
	'tasklistmytasks' => '我的任务',
	'tasklistbyprojectbad' => "专案「'''%s'''」并非是个有效的专案项目.请参考[[MediaWiki:TodoTasksValidProjects]]页面以察看专案列表",
	'tasklistbyprojname' => "'''%s'''项下的任务",
	'tasklistchooseproj' => '选取专案：',
	'tasklistprojdisp' => '显示',
	'tasklistbyname' => '==  名称为「%s」的任务 ==',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Gzdavidwong
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'tasklist' => '任务列表',
	'tasklist-parser-desc' => '添加<nowiki>{{#todo:}}</nowiki>分析器功能以分配任务',
	'tasklist-special-desc' => '添加特殊页面以查看[[Special:TaskList|任务分配]]',
	'tasklistbyproject' => '项目任务列表',
	'tasklistunknownproject' => '未知项目',
	'tasklistunspecuser' => '未指定用户',
	'tasklistincorrectuser' => '错误用户名',
	'tasklistemail' => '亲爱的%s',
	'tasklistemailsubject' => '[%s]任务列表更改',
	'tasklistmytasks' => '我的任务',
	'tasklistbyprojectbad' => "无法识别'''%s'''项目。
如要查看有效项目列表，请见[[MediaWiki:TodoTasksValidProjects]]。",
	'tasklistbyprojname' => "'''%s'''的分配任务",
	'tasklistchooseproj' => '选择项目：',
	'tasklistprojdisp' => '显示',
	'tasklistbyname' => '== %s的工作备忘 ==',
	'tasklistnowguseprojects' => '你已把$wgUseProjects设为"停用"，不能使用本页面。',
	'tasklistnoprojects' => "错误：你启用了'''\$wgUseProjects'''，但没有创建[[MediaWiki:TodoTasksValidProjects]]。详情请见[http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 安装说明]。",
	'tasklistemailbody' => '，

某人在%s上给你分配了新任务。

如要查看你的完整任务列表，请至%s。

%s通知系统敬上',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'tasklist' => '任務清單',
	'tasklist-parser-desc' => '增加了<nowiki>{{#todo:}}</nowiki>語句，用來分配任務',
	'tasklist-special-desc' => '增加了一個特殊頁面，用以檢視[[Special:TaskList|分配到的任務]]',
	'tasklistbyproject' => '項目任務列表',
	'tasklistunknownproject' => '未知的項目',
	'tasklistunspecuser' => '未認證用戶',
	'tasklistincorrectuser' => '使用者名稱錯誤',
	'tasklistemail' => '親愛的 %s',
	'tasklistemailsubject' => '[%s] 任務列表有變化',
	'tasklistmytasks' => '我的任務',
	'tasklistbyprojectbad' => "任務 '''%s''' 無法識別。
如要檢視可執行的任務，請參閱 [[MediaWiki:TodoTasksValidProjects]]。",
	'tasklistbyprojname' => "'''%s''' 的指定任務",
	'tasklistchooseproj' => '選擇項目：',
	'tasklistprojdisp' => '顯示',
	'tasklistbyname' => '== %s 的任務列表 ==',
	'tasklistnowguseprojects' => '你已把$wgUseProjects設為"停用"，不能使用本頁面。',
	'tasklistnoprojects' => "錯誤：您啟動了 '''\$wgUseProjects'''，但是沒有建立 [[MediaWiki:TodoTasksValidProjects]]。參見 [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions] 以取得更多資訊。",
	'tasklistemailbody' => '，

某人在 %s 上給您指定了新的任務。

如要檢視您的完整任務列表，請到 %s。

%s 提示系統敬上',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'tasklist' => '任務清單',
	'tasklist-parser-desc' => '新增 <nowiki>{{#todo:}}</nowiki> 擴充語法功能以指定任務',
	'tasklist-special-desc' => '新增特殊頁面以利查看[[Special:TaskList|tasks assignments]]',
	'tasklistbyproject' => '依專案列出任務',
	'tasklistunknownproject' => '未知的專案',
	'tasklistunspecuser' => '未指定用戶',
	'tasklistincorrectuser' => '用戶名稱錯誤',
	'tasklistemail' => '%s您好',
	'tasklistemailsubject' => '[%s] 任務清單變更',
	'tasklistmytasks' => '我的任務',
	'tasklistbyprojectbad' => "專案「'''%s'''」並非是個有效的專案項目.請參考[[MediaWiki:TodoTasksValidProjects]]頁面以察看專案清單",
	'tasklistbyprojname' => "'''%s'''項下的任務",
	'tasklistchooseproj' => '選取專案：',
	'tasklistprojdisp' => '顯示',
	'tasklistbyname' => '==  名稱為「%s」的任務 ==',
	'tasklistnoprojects' => "錯誤：您似乎設定了使'''\$wgUseProjects'''生效，但卻尚未建立[[MediaWiki:TodoTasksValidProjects]]此一頁面，請參見 [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions]此一頁面以獲得更詳細的說明。",
	'tasklistemailbody' => ',

有人在%s指定了一項新任務給您。

您可前往%s查看所有任務的清單。

您最好的幫手 %s 任務通報系統',
);

