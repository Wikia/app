<?php

/*Internationalizaton file of TodoTask extension*/

$messages = array();
$messages['en'] = array(
	'tasklist'                => 'Task list',
	'tasklist-parser-desc'    => 'adds <nowiki>{{#todo:}}</nowiki> parser function for assigning tasks',
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
	'tasklistnoprojects'      => "Error: It looks like you enabled '''\$wgUseProjects''', but did not create [[MediaWiki:TodoTasksValidProjects]]. See [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions] for more details.",
	'tasklistemailbody'       => ",

Someone has assigned a new Task for you on %s.

To see your complete Task List go to %s.

Your friendly %s notification system",
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
	'tasklistincorrectuser' => 'Foutiewe gebruikersnaam',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'tasklist'               => 'قائمة المهام',
	'tasklistbyproject'      => 'قائمة المهام حسب المشروع',
	'tasklistunknownproject' => 'مشروع غير معروف',
	'tasklistunspecuser'     => 'مستخدم غير محدد',
	'tasklistincorrectuser'  => 'اسم مستخدم غير صحيح',
	'tasklistemail'          => 'عزيزي %s',
	'tasklistemailsubject'   => 'التغيير في قائمة مهام [%s]',
	'tasklistmytasks'        => 'مهامي',
	'tasklistbyprojectbad'   => "المشروع '''%s''' ليس مشروعا صحيحا. لقائمة بالمشاريع الصحيحة، انظر [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "المهام الموكلة ل'''%s'''",
	'tasklistchooseproj'     => 'اختر المشروع:',
	'tasklistprojdisp'       => 'عرض',
	'tasklistbyname'         => '== قائمة العمل ل%s ==',
	'tasklistnoprojects'     => "خطأ: يبدو أنك فعلت '''\$wgUseProjects'''، لكن لم تنشيء [[MediaWiki:TodoTasksValidProjects]]. انظر [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 تعليمات التنصيب] لمزيد من التفاصيل.",
	'tasklistemailbody'      => '،

شخص ما أضاف مهمة جديدة لك في %s.

لرؤية قائمة مهامك الكاملة اذهب إلى %s.

نظام إخطار %s الصديق',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'tasklist'               => 'Списък със задачи',
	'tasklist-parser-desc'   => 'добавя функция на парсера <nowiki>{{#todo:}}</nowiki> за управление на задачи',
	'tasklist-special-desc'  => 'Добавя специална страница със [[Special:TaskList|списък със задачи]].',
	'tasklistbyproject'      => 'Списък със задачи по проект',
	'tasklistunknownproject' => 'Неизвестен проект',
	'tasklistincorrectuser'  => 'Невалидно потребителско име',
	'tasklistemail'          => 'Уважаеми %s',
	'tasklistemailsubject'   => '[%s] Промяна в списъка със задачи',
	'tasklistmytasks'        => 'Моите задачи',
	'tasklistbyprojectbad'   => "Проектът '''%s''' не е валиден проект. За списък с проекти, вижте [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistchooseproj'     => 'Избор на проект:',
	'tasklistprojdisp'       => 'Показване',
	'tasklistbyname'         => '== Списък със задачи за %s ==',
);

/** German (Deutsch) */
$messages['de'] = array(
	'tasklist'               => 'Aufgabenliste',
	'tasklistbyproject'      => 'Aufgabenliste pro Projekt',
	'tasklistunknownproject' => 'Unbekanntes Projekt',
	'tasklistunspecuser'     => 'Unbestimmter Benutzername',
	'tasklistincorrectuser'  => 'Falscher Benutzername',
	'tasklistemail'          => 'Hallo %s',
	'tasklistemailsubject'   => '[%s]-Aufgabenliste Änderungen',
	'tasklistmytasks'        => 'Meine Aufgaben',
	'tasklistbyprojectbad'   => "Projekt '''%s''' ist nicht vorhanden. Für eine Liste gültiger Projekt siehe [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Zugewiesene Aufgaben für '''%s'''",
	'tasklistchooseproj'     => 'Projekt: auswählen:',
	'tasklistprojdisp'       => 'Anzeigen',
	'tasklistbyname'         => '== Aufgabenliste für %s ==',
	'tasklistnoprojects'     => "Fehler: Es sieht so aus, als wenn '''\$wgUseProjects''' aktiviert wäre, aber es wurde keine Seiten [[MediaWiki:TodoTasksValidProjects]] erstellt. Siehe die [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installationsanweisungen] für weitere Details.",
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'tasklist'               => 'Tasklisto',
	'tasklistbyproject'      => 'Tasklisto Laŭ Projekto',
	'tasklistunknownproject' => 'Nekonata projekto',
	'tasklistincorrectuser'  => 'Malkorekta salutnomo',
	'tasklistemail'          => 'Kara %j',
	'tasklistmytasks'        => 'Miaj taskoj',
	'tasklistchooseproj'     => 'Selektu Projekton:',
);

/** French (Français)
 * @author Sherbrooke
 * @author Urhixidur
 * @author Grondin
 */
$messages['fr'] = array(
	'tasklist'               => 'Liste de tâches',
	'tasklist-parser-desc'   => 'Ajoute <nowiki>{{#todo:}}</nowiki> une fonction parseur pour assigner des tâches',
	'tasklist-special-desc'  => 'Ajoute une page spéciale pour réviser [[Special:TaskList|la liste des tâches assignées]]',
	'tasklistbyproject'      => 'Liste de tâches par projet',
	'tasklistunknownproject' => 'Projet inconnu',
	'tasklistunspecuser'     => 'Contributeur inconnu',
	'tasklistincorrectuser'  => 'Pseudonyme incorrect',
	'tasklistemail'          => 'Cher %s',
	'tasklistemailsubject'   => '[%s] Changement à la liste de tâches',
	'tasklistmytasks'        => 'Mes tâches',
	'tasklistbyprojectbad'   => "Le projet '''%s''' n'est pas valide. Consulter la [[MediaWiki:TodoTasksValidProjects|liste des projets]].",
	'tasklistbyprojname'     => "Tâches assignées pour '''%s'''.",
	'tasklistchooseproj'     => 'Projet sélectionné :',
	'tasklistprojdisp'       => 'Afficher',
	'tasklistbyname'         => '== Liste de tâches à faire pour %s ==',
	'tasklistnoprojects'     => "Erreur : il semble que vous ayez activé '''\$wgUseProjects''', mais sans avoir créé [[MediaWiki:TodoTasksValidProjects]]. Prière de lire les [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 instructions d'installation] pour plus de détails.",
	'tasklistemailbody'      => ',

Quelqu’un vous a assigné une nouvelle tâche sur %s.

Pour voir votre liste complète des tâches à effectuer, allez sur %s.

Votre bien aimable système de notification de %s',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'tasklist'               => 'Listaxe de Tarefas',
	'tasklist-parser-desc'   => 'engade a función de análise <nowiki>{{#todo:}}</nowiki> para asignar tarefas',
	'tasklist-special-desc'  => 'Engade unha páxina especial para revisar [[Special:TaskList|as tarefas asignadas]]',
	'tasklistbyproject'      => 'Listaxe de Tarefas por Proxecto',
	'tasklistunknownproject' => 'Proxecto descoñecido',
	'tasklistunspecuser'     => 'Usuario sen especificar',
	'tasklistincorrectuser'  => 'Nome de usuario incorrecto',
	'tasklistemail'          => 'Querido %s',
	'tasklistemailsubject'   => '[%s] Cambio na Listaxe de Tarefas',
	'tasklistmytasks'        => 'As miñas tarefas',
	'tasklistbyprojectbad'   => "O Proxecto '''%s''' non é un proxecto válido. Para unha listaxe de proxectos válidos, vexa
[[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Tarefas asignadas a '''%s'''",
	'tasklistchooseproj'     => 'Seleccionar Proxecto:',
	'tasklistprojdisp'       => 'Pantalla',
	'tasklistbyname'         => '== Lista de tarefas pendentes para %s ==',
	'tasklistnoprojects'     => "ERRO: parece que permitiu '''\$wgUseProjects''', pero non creou [[MediaWiki:TodoTasksValidProjects]]. Vexa [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 as instrucións da instalación] para máis detalles.",
	'tasklistemailbody'      => ',

Alguén asignoulle unha nova tarefa en %s.

Para ver a súa lista completa de tarefas vaia a %s.

O seu sistema agradable de notificacións %s',
);

/** Hebrew (עברית) */
$messages['he'] = array(
	'tasklist'               => 'רשימת מטלות',
	'tasklistbyproject'      => 'רשימת מטלות לפי פרוייקטים',
	'tasklistunknownproject' => 'פרוייקט לא ידוע',
	'tasklistunspecuser'     => 'משתמש לא מוגדר',
	'tasklistincorrectuser'  => 'משתמש לא נכון',
	'tasklistemail'          => '%s היקר והחביב',
	'tasklistemailsubject'   => '[%s] שיוני ברשימת המטלות',
	'tasklistmytasks'        => 'המטלות שלי',
	'tasklistbyprojectbad'   => "פרוייקט '''%s''' איננו קיים. לקבלת רשימת הפרוייקטים, צפה כאן [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "מטלה הוגדרה ל'''%s'''",
	'tasklistchooseproj'     => 'בחר פרוייקט:',
	'tasklistprojdisp'       => 'תצוגה',
	'tasklistbyname'         => '== רשימת מטלות עבור %s ==',
	'tasklistnoprojects'     => "שגיאה: נראה שאפשרת את '''\$wgUseProjects''', אבל לא יצרת [[MediaWiki:TodoTasksValidProjects]]. ראה [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions] for more details.",
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'tasklist'               => 'Lisćina nadawkow',
	'tasklist-parser-desc'   => 'přidawa <nowiki>{{#todo:}}</nowiki> parserowu funkciju za připokazowanje nadawkow',
	'tasklist-special-desc'  => 'Přidawa specialnu stronu za pruwowanje [[Special:TaskList|připokazanjow nadawkow]]',
	'tasklistbyproject'      => 'Lisćina nadawkow po projekće',
	'tasklistunknownproject' => 'Njeznaty projekt',
	'tasklistunspecuser'     => 'Wužiwar njepodaty',
	'tasklistincorrectuser'  => 'Njekorektne wužiwarske mjeno',
	'tasklistemail'          => 'Luby %s',
	'tasklistemailsubject'   => '[%s] Změna lisćiny nadawkow',
	'tasklistmytasks'        => 'Moje nadawki',
	'tasklistbyprojectbad'   => "Projekt '''%s''' płaćiwy projekt njeje. Za lisćinu płaćiwych projektow, hlej [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Nadawki so za '''%s''' připokazachu.",
	'tasklistchooseproj'     => 'Wubjer projekt:',
	'tasklistprojdisp'       => 'Pokazać',
	'tasklistbyname'         => '== Nadawkowa lisćina za %s ==',
	'tasklistnoprojects'     => "ZMYLK: Zda so, zo sy '''\$wgUseProjects''' aktiwizował, ale njejsy [[MediaWiki:TodoTasksValidProjects]] wutworił. Hlej [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions] za dalše podrobnosće.",
	'tasklistemailbody'      => ',

Něchtó je nowy nadawk za tebje na %s připokazal.

Zo by swoju dospołnu lisćinu nadawkow widźał, dźi k %s.

Twój přećelny zdźělenski system %s.',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'tasklist'               => 'Daftar Tugas',
	'tasklistbyproject'      => 'Daftar Tugas Per Proyèk',
	'tasklistunknownproject' => 'Proyèk ora ditepungi',
	'tasklistunspecuser'     => 'Panganggo ora dispésifikasi',
	'tasklistincorrectuser'  => 'Jeneng panganggo ora bener',
	'tasklistemail'          => '%s sing minulya',
	'tasklistemailsubject'   => '[%s] Owah-owahan ing Daftar Tugas',
	'tasklistmytasks'        => 'Tugas-tugasku',
	'tasklistbyprojectbad'   => "Proyèk '''%s''' iku dudu proyèk absah.
Kanggo daftar proyèk-proyèk sing absah, mangga mirsani [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Mènèhi Tugas-Tugas kanggo '''%s'''",
	'tasklistchooseproj'     => 'Pilihen Proyèk:',
	'tasklistprojdisp'       => 'Ndeleng',
	'tasklistbyname'         => '== Daftar Tugas kanggo %s ==',
	'tasklistnoprojects'     => "KALUPUTAN: Katoné panjenengan nyetèl '''\$wgUseProjects''', nanging ora nggawé [[MediaWiki:TodoTasksValidProjects]]. Delengen [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Instruksi Instalasi] kanggo détail sabanjuré.",
	'tasklistemailbody'      => ',

Sawijining wong mènèhi panjenengan Tugas anyar ing %s.

Kanggo niliki Daftar Tugas panjenengan sing pepak mangga lungaa menyang %s.

Sistém notifikasi panjenengan %s',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'tasklist'               => 'បញ្ជីពិភាក្សា',
	'tasklistbyproject'      => 'បញ្ជី​កិច្ចការ​តាម​គំរោង',
	'tasklistunknownproject' => 'គំរោង​មិនស្គាល់',
	'tasklistincorrectuser'  => 'ឈ្មោះអ្នកប្រើប្រាស់ មិនត្រឹមត្រូវ',
	'tasklistemail'          => 'ជូនចំពោះ %s',
	'tasklistmytasks'        => 'កិច្ចការ​របស់ខ្ញុំ',
	'tasklistchooseproj'     => 'ជ្រើសយក​គំរោង ៖',
	'tasklistprojdisp'       => 'បង្ហាញ',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'tasklistbyname' => '== Opjaveliss för %s ==',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'tasklist'               => 'Lëscht vun den Aufgaben',
	'tasklist-parser-desc'   => "setzt d'<nowiki>{{#todo:}}</nowiki> Parserfonctioun derbäi fir Aufgaben zouzedeelen",
	'tasklist-special-desc'  => 'Setzt eng Spezialsäit derbäi mat nger Iwwersiicht vun den [[Special:TaskList|zugdeelten Aufgaben]]',
	'tasklistbyproject'      => 'Lëscht vun den Aufgabe pro Projet',
	'tasklistunknownproject' => 'Onbekannte Projet',
	'tasklistunspecuser'     => 'Onbestemmte Benotzer',
	'tasklistincorrectuser'  => 'Falsche Benotzernumm',
	'tasklistemail'          => 'Léiwe %s',
	'tasklistemailsubject'   => '[%s] Ännerunge vun der Lëscht vun den Aufgaben',
	'tasklistmytasks'        => 'Meng Aufgaben',
	'tasklistbyprojectbad'   => "De Projet '''%s''' ass an dësem Kontext net disponibel.
Fir eng Lëschtvun den disponibele Projeten, kuckt w.e.g. [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Aufgaben déi dem '''%s''' zougedeelt sinn.",
	'tasklistchooseproj'     => 'Projet auswielen:',
	'tasklistprojdisp'       => 'Weisen',
	'tasklistbyname'         => '== Lëscht vun den Aufgabe fir %s ==',
	'tasklistnoprojects'     => "FEELER: Et gesäit esou aus wéi wann Dir '''\$wgUseProjects''' ageschalt hätt, mee Dir hutt [[MediaWiki:TodoTasksValidProjects]] net erstalt. Kuckt [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installatiouns Instructiounen] fir méi Informatiounen.",
	'tasklistemailbody'      => ',

Iergend een huet Iech op %s eng Aufgab zougedeelt.

Fir är komlett Aufgabelësch  ze gesinn, gitt w.e.g. op %s.

Äre frëndleche  %s Informatiounssystem',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'tasklistunknownproject' => 'അജ്ഞാതമായ സം‌രംഭം',
	'tasklistincorrectuser'  => 'തെറ്റായ ഉപയോക്തൃനാമം',
	'tasklistemail'          => 'നമസ്കാരം %s',
	'tasklistprojdisp'       => 'പ്രദര്‍ശിപ്പിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'tasklist'               => 'कार्य यादी',
	'tasklistbyproject'      => 'प्रकल्पानुसार कामांची यादी',
	'tasklistunknownproject' => 'अनोळखी प्रकल्प',
	'tasklistunspecuser'     => 'न दिलेला सदस्य',
	'tasklistincorrectuser'  => 'चुकीचे सदस्यनाव',
	'tasklistemail'          => 'प्रिय %s',
	'tasklistemailsubject'   => '[%s] कार्य यादी बदल',
	'tasklistmytasks'        => 'माझ्या जबाबदार्‍या',
	'tasklistchooseproj'     => 'प्रकल्प निवडा:',
	'tasklistprojdisp'       => 'दर्शवा',
	'tasklistbyname'         => '== %s साठीची करायच्या गोष्टींची यादी ==',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'tasklistunknownproject' => 'Unbekannt Projekt',
	'tasklistemail'          => 'Leve %s',
	'tasklistmytasks'        => 'Miene Opgaven',
	'tasklistchooseproj'     => 'Projekt utwählen:',
	'tasklistbyname'         => '== Opgavenlist för %s ==',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'tasklist'               => 'Takenlijst',
	'tasklist-parser-desc'   => 'voegt de parserfunctie <nowiki>{{#todo:}}</nowiki> toe om taken toe te wijzen',
	'tasklist-special-desc'  => 'Voegt een speciale pagina toe om [[Special:TaskList|takentoewijzingen]] na te kijken',
	'tasklistbyproject'      => 'Takenlijst per project',
	'tasklistunknownproject' => 'Onbekend project',
	'tasklistunspecuser'     => 'Gebruiker niet aangegeven',
	'tasklistincorrectuser'  => 'Gebruiker bestaat niet',
	'tasklistemail'          => 'Beste %s',
	'tasklistemailsubject'   => '[%s] verandering in takenlijst',
	'tasklistmytasks'        => 'Mijn taken',
	'tasklistbyprojectbad'   => "Project '''%s''' is geen geldige projectnaam. Een lijst met projecten is te vinden op [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Toegewezen taken voor '''%s'''",
	'tasklistchooseproj'     => 'Project selecteren:',
	'tasklistprojdisp'       => 'Bekijken',
	'tasklistbyname'         => '== Takenlijst voor %s ==',
	'tasklistnoprojects'     => "FOUT: het lijkt alsof u '''\$wgUseProjects''' hebt ingeschakeld, maar [[MediaWiki:TodoTasksValidProjects]] niet hebt aangemaakt. Zie de  [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 installatie-instructies] voor meer details.",
	'tasklistemailbody'      => ',

Iemand heeft een nieuwe taak aan u toegewezen op %s.

Op %s kunt u uw complete takenlijst bekijken.

Het waarschuwingssysteem',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'tasklist'               => 'Oppgaveliste',
	'tasklist-parser-desc'   => 'legger til <nowiki>{{#todo:}}</nowiki> for tildeling av oppgaver',
	'tasklist-special-desc'  => 'Legger til en spesialside for gjennomgang av [[Special:TaskList|oppgaver]]',
	'tasklistbyproject'      => 'Oppgaveliste etter prosjekt',
	'tasklistunknownproject' => 'Ukjent prosjekt',
	'tasklistunspecuser'     => 'Bruker ikke angitt',
	'tasklistincorrectuser'  => 'Ukorrekt brukernavn',
	'tasklistemail'          => 'Kjære %s',
	'tasklistemailsubject'   => '[%s] Oppgavelisteendring',
	'tasklistmytasks'        => 'Mine oppgaver',
	'tasklistbyprojectbad'   => "'''%s''' er ikke et gyldig prosjekt. For en liste over gyldige prosjekter, se [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Tildelte oppgaver for '''%s'''",
	'tasklistchooseproj'     => 'Velg prosjekt:',
	'tasklistprojdisp'       => 'Vis',
	'tasklistbyname'         => '== Oppgaveliste for %s ==',
	'tasklistnoprojects'     => "FEIL: Det ser ut som om du har slått på '''\$wgUseProjects''' uten å opprette [[MediaWiki:TodoTasksValidProjects]]. Se [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 installasjonsintruksjonene] for flere detaljer.",
	'tasklistemailbody'      => ',

Noen har gitt deg en ny oppgave på %s.

Gå til %s for å se den fullstendige oppgavelisten din.

Fra %ss varslingssystem',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'tasklist'               => 'Lista de prètzfaches',
	'tasklist-parser-desc'   => 'Apondís <nowiki>{{#todo:}}</nowiki> una foncion parser per assignar de prètzfaches',
	'tasklist-special-desc'  => 'Apondís una pagina especiala per revisar [[Special:TaskList|la lista dels prètzfaches assignats]]',
	'tasklistbyproject'      => 'Lista de prètzfaches per projècte',
	'tasklistunknownproject' => 'Projècte desconegut',
	'tasklistunspecuser'     => 'Contributor desconegut',
	'tasklistincorrectuser'  => 'Pseudonim incorrècte',
	'tasklistemail'          => 'Car(a) %s',
	'tasklistemailsubject'   => '[%s] Cambiament a la lista de prètzfaches',
	'tasklistmytasks'        => 'Mos prètzfaches',
	'tasklistbyprojectbad'   => "Lo projècte '''%s''' es pas valid. Consultatz la [[MediaWiki:TodoTasksValidProjects|lista dels projèctes]].",
	'tasklistbyprojname'     => "Prètzfaches assignats per '''%s'''.",
	'tasklistchooseproj'     => 'Projècte seleccionat :',
	'tasklistprojdisp'       => 'Afichar',
	'tasklistbyname'         => '== Lista de prètzfaches de far per %s ==',
	'tasklistnoprojects'     => "Error : sembla qu'avètz activat '''\$wgUseProjects''', mas sens aver creat [[MediaWiki:TodoTasksValidProjects]]. Legissètz las [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 instruccions d'installacion] per mai de detalhs.",
	'tasklistemailbody'      => ",

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
	'tasklist'               => 'Lista zadań',
	'tasklist-parser-desc'   => 'dodaje funkcję parsera <nowiki>{{#todo:}}</nowiki>, pozwalającą na przydzielanie zadań',
	'tasklist-special-desc'  => 'Dodaje stronę specjalną do przeglądania [[Special:TaskList|przydzielonych zadań]]',
	'tasklistbyproject'      => 'Listy zadań według projektu',
	'tasklistunknownproject' => 'Nieznany projekt',
	'tasklistunspecuser'     => 'Nie określono użytkownika',
	'tasklistincorrectuser'  => 'Niepoprawna nazwa użytkownika',
	'tasklistemail'          => '%s',
	'tasklistemailsubject'   => '[%s] Zmiana listy zadań',
	'tasklistmytasks'        => 'Moje zadania',
	'tasklistbyprojectbad'   => "'''%s''' nie jest poprawnym projektem.
Listę poprawnych projektów znajdziesz na stronie [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Przypisano zadania do '''%s'''",
	'tasklistchooseproj'     => 'Wybierz projekt:',
	'tasklistprojdisp'       => 'Wyświetl',
	'tasklistbyname'         => '== Lista zadań do wykonania dla %s ==',
	'tasklistnoprojects'     => "BŁĄD: Najprawdopodobniej włączono zmienną '''\$wgUseProjects''', lecz nie utworzono pliku [[MediaWiki:TodoTasksValidProjects]]. Szczegóły w pliku [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Instrukcja instalacji].",
	'tasklistemailbody'      => ',

Ktoś przydzielił Ci nowe zadanie w %s.

By zobaczyć kompletną listę zadań, przejdź do strony %s.

%s – automatyczny system informowania.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'tasklist'              => 'د دندو لړليک',
	'tasklistbyproject'     => 'د پروژې له مخې د دندو لړليک',
	'tasklistunspecuser'    => 'ناځانګړی کارونکی',
	'tasklistincorrectuser' => 'ناسم کارن-نوم',
	'tasklistmytasks'       => 'زما دندې',
	'tasklistchooseproj'    => 'پروژه ټاکل:',
	'tasklistprojdisp'      => 'ښکاره کول',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'tasklist'               => 'Lista de Tarefas',
	'tasklistbyproject'      => 'Lista de Tarefas por Projecto',
	'tasklistunknownproject' => 'projecto deconhecido',
	'tasklistunspecuser'     => 'Usuário não especificado',
	'tasklistincorrectuser'  => 'Nome de utilizador incorrecto',
	'tasklistemail'          => 'Caro %s',
	'tasklistmytasks'        => 'Minhas tarefas',
	'tasklistbyprojname'     => "Tarefas atribuídas a '''%s'''",
	'tasklistchooseproj'     => 'Seleccione Projecto:',
	'tasklistprojdisp'       => 'Mostrar',
	'tasklistbyname'         => '== Lista de tarefas de %s ==',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'tasklist'               => 'Zoznam úloh',
	'tasklist-parser-desc'   => 'pridáva funkciu syntaktického analyzátora <nowiki>{{#todo:}}</nowiki> na prideľovanie úloh',
	'tasklist-special-desc'  => 'Pridáva špeciálnu stránku na kontrolu [[Special:TaskList|pridelených úloh]]',
	'tasklistbyproject'      => 'Zoznam úloh podľa projektov',
	'tasklistunknownproject' => 'Neznámy projekt',
	'tasklistunspecuser'     => 'Nešpecifikovaný používateľ',
	'tasklistincorrectuser'  => 'Nesprávne používateľské meno',
	'tasklistemail'          => 'Milý %s',
	'tasklistemailsubject'   => '[%s] Zmena zoznamu úloh',
	'tasklistmytasks'        => 'Moje úlohy',
	'tasklistbyprojectbad'   => "Projekt '''%s''' nie je platný projekt. Zoznam platných projektov nájdete na [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Pridelené úlohy pre '''%s'''",
	'tasklistchooseproj'     => 'Vyberte projekt:',
	'tasklistprojdisp'       => 'Zobraziť',
	'tasklistbyname'         => '== Zoznam úloh pre %s ==',
	'tasklistnoprojects'     => "CHYBA: Zdá sa, že ste zapli  '''\$wgUseProjects''', ale nevytvorili ste [[MediaWiki:TodoTasksValidProjects]]. Pozri podrobnosti v [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Inštalačných inštrukciách].",
	'tasklistemailbody'      => ',

Niekto vám %s priradil novú úlohu.

Svoj kompletný Zoznam úloh si môžete pozrieť na %s.

Váš priateľský upozorňovací systém %s',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 * @author Siebrand
 */
$messages['stq'] = array(
	'tasklist'               => 'Apgoawenlieste',
	'tasklistbyproject'      => 'Apgoawenlieste pro  Projekt',
	'tasklistunknownproject' => 'Uunbekoand Projekt',
	'tasklistunspecuser'     => 'Uunbestimde Benutsernoome',
	'tasklistincorrectuser'  => 'Falsken Benutsernoome',
	'tasklistemail'          => 'Moin %s',
	'tasklistemailsubject'   => '[%s]-Apgoawenlieste Annerengen',
	'tasklistmytasks'        => 'Mien Apgoawen',
	'tasklistbyprojectbad'   => "Projekt '''%s''' is nit deer. Foar ne Lieste fon gultige Projekte sjuch [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Touwiesde Apgoawen foar '''%s'''",
	'tasklistchooseproj'     => 'Projekt uutwääle:',
	'tasklistprojdisp'       => 'Anwiese',
	'tasklistbyname'         => '== Apgoawenlieste foar %s ==',
	'tasklistnoprojects'     => "Failer: Dät sjucht so uut, as wan '''\$wgUseProjects''' aktivierd waas, man der wuuden neen Sieden [[MediaWiki:TodoTasksValidProjects]] moaked. Sjuch do
[http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installationsanwiesengen] foar wiedere Details.",
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Lejonel
 */
$messages['sv'] = array(
	'tasklist'               => 'Uppgiftslista',
	'tasklist-parser-desc'   => 'lägger till parser funktionen <nowiki>{{#todo:}}</nowiki för tilldelning av uppgifter',
	'tasklist-special-desc'  => 'Lägger till en specialsida för granskning av [[Special:TaskList|uppgifter]]',
	'tasklistbyproject'      => 'Uppgiftslista efter projekt',
	'tasklistunknownproject' => 'Okänt projekt',
	'tasklistunspecuser'     => 'Användare ej angiven',
	'tasklistincorrectuser'  => 'Felaktigt användarnamn',
	'tasklistemail'          => 'Kära %s',
	'tasklistemailsubject'   => '[%s] Uppgiftslistsändring',
	'tasklistmytasks'        => 'Mina uppgifter',
	'tasklistbyprojectbad'   => "'''%s''' är inte ett giltigt projekt.
För en lista över giltiga projekt, se [[MediaWiki:TodoTasksValidProjects]].",
	'tasklistbyprojname'     => "Tilldelade uppgifter för '''%s'''",
	'tasklistchooseproj'     => 'Välj projekt:',
	'tasklistprojdisp'       => 'Visa',
	'tasklistbyname'         => '== Uppgiftslista för %s ==',
	'tasklistnoprojects'     => "FEL: Det ser ut som om du har satt på '''\$wgUseProjects''' utan att skapa [[MediaWiki:TodoTasksValidProjects]]. Se [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 installationsinstruktionerna] för mer detaljer.",
	'tasklistemailbody'      => ',

Någon har givit dig en ny uppgift på %s.

Gå till %s för att se din fullständiga uppgiftslista.

Från %ss meddelningssystem.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'tasklist'              => 'పనుల జాబితా',
	'tasklistbyproject'     => 'ప్రాజెక్టులవారీగా పనుల జాబితా',
	'tasklistincorrectuser' => 'తప్పుడు వాడుకరిపేరు',
	'tasklistemail'         => 'ప్రియమైన %s',
	'tasklistmytasks'       => 'నా పనులు',
	'tasklistbyname'        => '== %s కొరకు చేయాల్సిన పనుల జాబితా ==',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'tasklist'               => 'Феҳристи Вазифа',
	'tasklistbyproject'      => 'Феҳристи Вазифа Тавассути Лоиҳа',
	'tasklistunknownproject' => 'Лоиҳаи ношинос',
	'tasklistunspecuser'     => 'Корбари мушаххаснашуда',
	'tasklistincorrectuser'  => 'Номи корбарии нодуруст',
	'tasklistemail'          => 'Мӯҳтарам %s',
	'tasklistmytasks'        => 'Вазифаҳои ман',
	'tasklistbyprojname'     => "Вазифаҳои таъйин шуда барои '''%s'''",
	'tasklistchooseproj'     => 'Интихоби Лоиҳа:',
	'tasklistprojdisp'       => 'Намоиш',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'tasklist'         => 'Görev listesi',
	'tasklistmytasks'  => 'Görevlerim',
	'tasklistprojdisp' => 'Gösteri',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'tasklistemail' => 'O %s löfik',
);

/** ‪中文(中国大陆)‬ (‪中文(中国大陆)‬) */
$messages['zh-cn'] = array(
	'tasklist'               => '任务列表',
	'tasklistbyproject'      => '依专案列出任务',
	'tasklistunknownproject' => '未知的专案',
	'tasklistunspecuser'     => '未指定用户',
	'tasklistincorrectuser'  => '用户名称错误',
	'tasklistemail'          => '%s您好',
	'tasklistemailsubject'   => '[%s] 任务列表变更',
	'tasklistmytasks'        => '我的任务',
	'tasklistbyprojectbad'   => "专案「'''%s'''」并非是个有效的专案项目.请参考[[MediaWiki:TodoTasksValidProjects]]页面以察看专案列表",
	'tasklistbyprojname'     => "'''%s'''项下的任务",
	'tasklistchooseproj'     => '选取专案：',
	'tasklistprojdisp'       => '显示',
	'tasklistbyname'         => '==  名称为「%s」的任务 ==',
);

/** Taiwan Chinese (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'tasklist'               => '任務清單',
	'tasklist-parser-desc'   => '新增 <nowiki>{{#todo:}}</nowiki> 擴充語法功能以指定任務',
	'tasklist-special-desc'  => '新增特殊頁面以利查看[[Special:TaskList|tasks assignments]]',
	'tasklistbyproject'      => '依專案列出任務',
	'tasklistunknownproject' => '未知的專案',
	'tasklistunspecuser'     => '未指定用戶',
	'tasklistincorrectuser'  => '用戶名稱錯誤',
	'tasklistemail'          => '%s您好',
	'tasklistemailsubject'   => '[%s] 任務清單變更',
	'tasklistmytasks'        => '我的任務',
	'tasklistbyprojectbad'   => "專案「'''%s'''」並非是個有效的專案項目.請參考[[MediaWiki:TodoTasksValidProjects]]頁面以察看專案清單",
	'tasklistbyprojname'     => "'''%s'''項下的任務",
	'tasklistchooseproj'     => '選取專案：',
	'tasklistprojdisp'       => '顯示',
	'tasklistbyname'         => '==  名稱為「%s」的任務 ==',
	'tasklistnoprojects'     => "錯誤：您似乎設定了使'''\$wgUseProjects'''生效，但卻尚未建立[[MediaWiki:TodoTasksValidProjects]]此一頁面，請參見 [http://www.mediawiki.org/wiki/Extension:Todo_Tasks#Step_8 Installation Instructions]此一頁面以獲得更詳細的說明。",
	'tasklistemailbody'      => ',

有人在%s指定了一項新任務給您。

您可前往%s查看所有任務的清單。

您最好的幫手 %s 任務通報系統',
);

