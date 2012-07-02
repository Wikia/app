<?php
$messages = array();

/** English
 * @author soxred93
 */
$messages['en'] = array (
	'toolbase-header-title' => "X!'s Tools (BETA)",
	'toolbase-header-bugs' => 'Bugs',
	'toolbase-header-twitter' => 'Twitter',
	'toolbase-header-sitenotice' => 'Global Toolserver Sitenotice: $1',

	'toolbase-replag' => 'Server lagged by $1',
	'toolbase-replag-years' => 'years',
	'toolbase-replag-months' => 'months',
	'toolbase-replag-weeks' => 'weeks',
	'toolbase-replag-days' => 'days',
	'toolbase-replag-hours' => 'hours',
	'toolbase-replag-minutes' => 'minutes',
	'toolbase-replag-seconds' => 'seconds',
	
	'toolbase-footer-exectime' => 'Executed in $1 seconds',
	'toolbase-footer-source' => 'View source',
	'toolbase-footer-language' => 'Change language',
	'toolbase-footer-translate' => 'Translate',
	
	'toolbase-navigation' => 'Navigation',
	'toolbase-navigation-homepage' => 'Homepage',
	'toolbase-navigation-api' => 'API',
	'toolbase-navigation-user_id' => 'Find user ID',
	'toolbase-navigation-autoedits' => 'Automated edit counter',
	
	'toolbase-userid-submit' => 'Get user ID',
	'toolbase-userid-title' => 'Find a user ID',
	'toolbase-userid-result' => 'The user ID for <b>$1</b> on <a href="$3"><b>$3</b></a> is <b>$2</b>.',
	
	'toolbase-autoedits-title' => 'Automated edit calculator',
	'toolbase-autoedits-submit' => 'Calculate',
	'toolbase-autoedits-approximate' => '<b>Approximate</b> number of edits using...',
	'toolbase-autoedits-totalauto' => 'Total number of automated edits',
	'toolbase-autoedits-totalall' => 'Total edit count',
	'toolbase-autoedits-pct' => 'Percentage of automated edits',

	'toolbase-main-title' => 'Welcome!',
	'toolbase-main-content' => 'Welcome to X!\'s tools! The tool suite is still in the process of being converted to the <a href="$1">Symfony</a> framework. This process will take a while, but it should be working now. 

For a list of tools that are currently running right now on this framework, see the sidebar to the right.

Bugs can be reported at <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'File not found',
	'toolbase-main-404-content' => 'Oops! No page was found!

Make sure that you typed the URL correctly.
If you followed a link from somewhere, please <a href="$1">report a bug</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	
	'toolbase-error-nouser' => '$1 is not a valid user',	
	'toolbase-error-nowiki' => '$1.$2.org is not a valid wiki',
	'toolbase-error-toomanyedits' => '$1 has $2 edits. This tool has a maximum of $3 edits.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Umherirrender
 * @author X!
 */
$messages['qqq'] = array(
	'toolbase-header-title' => 'Name of entire tool suite, used in titles and headers',
	'toolbase-header-bugs' => 'Text shown in link to bug reporter',
	'toolbase-header-twitter' => '{{optional}}',
	'toolbase-header-sitenotice' => 'Text shown when a global Toolserver sitenotice is issued',
	'toolbase-replag' => 'Text shown when there is server lag',
	'toolbase-footer-exectime' => 'Text shown in the footer. Used to show how many seconds were used in the loading of the page',
	'toolbase-footer-source' => 'Text used in the link to the source code',
	'toolbase-footer-language' => 'Text on the button that changes the interface language',
	'toolbase-footer-translate' => 'Text shown in the link to the translation page
{{Identical|Translate}}',
	'toolbase-navigation' => 'Text shown at the top of the navigation sidebar
{{Identical|Navigation}}',
	'toolbase-navigation-homepage' => 'Text shown in the nagivation link to the homepage
{{Identical|Homepage}}',
	'toolbase-navigation-api' => '{{optional}}',
	'toolbase-navigation-user_id' => 'Text shown in the nagivation link to the user_id tool',
	'toolbase-userid-submit' => 'Text on the submit button for the user_id tool',
	'toolbase-userid-title' => 'Header on the user_id tool',
	'toolbase-userid-result' => 'Message shown when someone gets the user id on the user_id tool',
	'toolbase-main-title' => 'General greeting, used on homepage
{{Identical|Welcome}}',
	'toolbase-main-content' => 'Content of the homepage',
	'toolbase-main-404' => 'Header shown for a 404 error',
	'toolbase-main-404-content' => 'Content of the 404 error page',
	'toolbase-form-wiki' => 'Text shown for the ___.___.org input field when specifying a wiki.',
	'toolbase-error-nouser' => 'Generic error when a user specified does not exist',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'toolbase-header-title' => 'X! se Gereedskapsboks',
	'toolbase-header-bugs' => 'Foute',
	'toolbase-header-sitenotice' => 'Globale Toolserver-kennisgewings: $1',
	'toolbase-replag' => 'Bediener is agter met $1',
	'toolbase-replag-years' => 'jare',
	'toolbase-replag-months' => 'maande',
	'toolbase-replag-weeks' => 'weke',
	'toolbase-replag-days' => 'dae',
	'toolbase-replag-hours' => 'ure',
	'toolbase-replag-minutes' => 'minute',
	'toolbase-replag-seconds' => 'sekondes',
	'toolbase-footer-exectime' => 'Uitgevoer in $1 sekondes',
	'toolbase-footer-source' => 'Wys bronteks',
	'toolbase-footer-language' => 'Verander taal',
	'toolbase-footer-translate' => 'Vertaal',
	'toolbase-navigation' => 'Navigasie',
	'toolbase-navigation-homepage' => 'Tuisblad',
	'toolbase-navigation-user_id' => 'Vind gebruikers-ID',
	'toolbase-userid-submit' => 'Kry gebruikers-ID',
	'toolbase-userid-title' => "Vind 'n gebruikers-ID",
	'toolbase-userid-result' => 'Die gebruikersnommer vir <b>$1</b> op <a href="$3"><b>$3</b></a> is <b>$2</b>.',
	'toolbase-main-title' => 'Welkom!',
	'toolbase-main-content' => 'Welkom by X! se gereedskapsboks! Ons is steeds besig om die gereedskap na die <a href="$1">Symfony</a>-raamwerk om te skakel. Hierdie proses sal \'n rukkie neem, maar dit behoort nou te werk.

Vir \'n lys van gereedskap wat tans beskikbaar is, sien die kantbalk aan die regterkant.

Foute kan by <a href="$2">Google-kode</a> gerapporteer word.',
	'toolbase-main-404' => 'Lêer nie gevind nie',
	'toolbase-main-404-content' => 'Oeps! Geen bladsy is gevind nie! 

Maak seker dat die URL korrek ingesleutel is.
As u \'n skakel vanaf elders gevolg het, <a href="$1">rapporteer \'n fout</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => "$1 is nie 'n geldige gebruiker nie",
);

/** Arabic (العربية)
 * @author Meno25
 * @author روخو
 */
$messages['ar'] = array(
	'toolbase-header-bugs' => 'علل',
	'toolbase-header-twitter' => 'تويتر',
	'toolbase-replag-years' => 'سنة',
	'toolbase-replag-months' => 'شهر',
	'toolbase-replag-weeks' => 'أسبوع',
	'toolbase-replag-days' => 'يوم',
	'toolbase-replag-hours' => 'ساعة',
	'toolbase-replag-minutes' => 'دقيقة',
	'toolbase-replag-seconds' => 'ثانية',
	'toolbase-footer-source' => 'عرض المصدر',
	'toolbase-footer-language' => 'تغيير اللغة',
	'toolbase-footer-translate' => 'ترجمة',
	'toolbase-navigation' => 'إبحار',
	'toolbase-navigation-homepage' => 'الصفحة الرئيسية',
	'toolbase-navigation-api' => 'إيه بي آي',
	'toolbase-navigation-user_id' => 'البحث عن معرف المستخدم',
	'toolbase-userid-submit' => 'الحصول على معرف المستخدم',
	'toolbase-userid-title' => 'البحث عن معرف المستخدم',
	'toolbase-autoedits-title' => 'تحرير الحساب آليا',
	'toolbase-autoedits-submit' => 'حساب',
	'toolbase-autoedits-totalall' => 'مجموع عدد التعديلات',
	'toolbase-main-title' => 'مرحبا!',
	'toolbase-main-404' => 'الملف غير موجود',
	'toolbase-form-wiki' => 'ويكي',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'toolbase-replag-years' => 'illər',
	'toolbase-replag-months' => 'aylar',
	'toolbase-replag-weeks' => 'həftələr',
	'toolbase-replag-days' => 'günlər',
	'toolbase-replag-minutes' => 'dəqiqələr',
	'toolbase-replag-seconds' => 'saniyələr',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'toolbase-header-title' => 'Інструмэнты X!',
	'toolbase-header-bugs' => 'Памылкі',
	'toolbase-header-sitenotice' => 'Глябальныя абвяшчэньні сайта сэрвэра інструмэнтаў: $1',
	'toolbase-replag' => 'Рэплікацыя базы зьвестак затрымліваецца на $1',
	'toolbase-replag-years' => 'гадоў',
	'toolbase-replag-months' => 'месяцы',
	'toolbase-replag-weeks' => 'тыдняў',
	'toolbase-replag-days' => 'дні',
	'toolbase-replag-hours' => 'гадзіны',
	'toolbase-replag-minutes' => 'хвілінаў',
	'toolbase-replag-seconds' => 'сэкунд',
	'toolbase-footer-exectime' => 'Выканана за $1 сэкундаў',
	'toolbase-footer-source' => 'Паказаць крынічны код',
	'toolbase-footer-language' => 'Зьмяніць мову',
	'toolbase-footer-translate' => 'Перакласьці',
	'toolbase-navigation' => 'Навігацыя',
	'toolbase-navigation-homepage' => 'Хатняя старонка',
	'toolbase-navigation-user_id' => 'Знайсьці ідэнтыфікатар удзельніка',
	'toolbase-navigation-autoedits' => 'Лічыльнік аўтаматычных рэдагаваньняў',
	'toolbase-userid-submit' => 'Атрымаць ідэнтыфікатар удзельніка',
	'toolbase-userid-title' => 'Знайсьці ідэнтыфікатар удзельніка',
	'toolbase-userid-result' => 'Ідэнтыфікатарам удзельніка <b>$1</b> на <a href="$3"><b>$3</b></a> зьяўляецца <b>$2</b>.',
	'toolbase-autoedits-title' => 'Лічыльнік аўтаматычных рэдагаваньняў',
	'toolbase-autoedits-submit' => 'Лічыць',
	'toolbase-autoedits-approximate' => '<b>Прыблізная</b> колькасьць рэдагаваньняў якія ўжываюць…',
	'toolbase-autoedits-totalauto' => 'Агульная колькасьць аўтаматычных рэдагаваньняў',
	'toolbase-autoedits-totalall' => 'Агульная колькасьць рэдагаваньняў',
	'toolbase-autoedits-pct' => 'Адсотак аўтаматычных рэдагаваньняў',
	'toolbase-main-title' => 'Вітаем!',
	'toolbase-main-content' => 'Вітаем у інструмэнтах X!! Набор інструмэнтаў яшчэ знаходзіцца ў працэсе канвэртацыі на базу <a href="$1">Symfony</a>. Гэта працэс яшчэ працягнецца некаторы час, яле ўсё павінна працаваць ужо зараз. 

Для таго, каб убачыць сьпіс інструмэнтаў, якія цяпер даступныя ў гэтай базе, глядзіце панэль справа.

Пра памылкі можна паведамляць на <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Файл ня знойдзены',
	'toolbase-main-404-content' => 'Старонка ня знойдзеная!

Упэўніцеся, што Вы ўвялі слушны URL-адрас.
Калі Вы перайшлі па нейкай спасылцы, калі ласка <a href="$1">паведаміце пра памылку</a>.
</ul>',
	'toolbase-form-wiki' => 'Вікі',
	'toolbase-error-nouser' => '«$1» не зьяўляецца слушнай назвай рахунку удзельніка',
	'toolbase-error-nowiki' => '$1.$2.org не зьяўляецца слушным адрасам вікі',
	'toolbase-error-toomanyedits' => '$1 мае $2 рэдагаваньняў. Гэты інструмэнт мае абмежаваньне ў $3 рэдагаваньняў.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'toolbase-header-title' => 'Ostilh X! (BETA)',
	'toolbase-header-bugs' => 'Drein',
	'toolbase-header-sitenotice' => "Kemenn lec'hienn a-berzh ar servijer ostilhoù hollek : $1",
	'toolbase-replag' => 'Servijer gant dale gant $1',
	'toolbase-replag-years' => 'bloavezhioù',
	'toolbase-replag-months' => 'miz',
	'toolbase-replag-weeks' => 'sizhunvezhioù',
	'toolbase-replag-days' => 'deiz',
	'toolbase-replag-hours' => 'eurvezh',
	'toolbase-replag-minutes' => 'munutenn',
	'toolbase-replag-seconds' => 'eilenn',
	'toolbase-footer-exectime' => 'Kaset da benn e $1 eilenn',
	'toolbase-footer-source' => 'Sellet ouzh tarzh an destenn',
	'toolbase-footer-language' => 'Cheñch yezh',
	'toolbase-footer-translate' => 'Treiñ',
	'toolbase-navigation' => 'Merdeiñ',
	'toolbase-navigation-homepage' => 'Pajenn degemer',
	'toolbase-navigation-user_id' => 'Kavout ID an implijer',
	'toolbase-navigation-autoedits' => 'Konter kemmoù emgefre',
	'toolbase-userid-title' => 'Kavout ID un implijer',
	'toolbase-autoedits-submit' => 'Jediñ',
	'toolbase-autoedits-totalauto' => ' Niver hollek a gemmoù emgefre',
	'toolbase-autoedits-totalall' => 'Niver hollek a gemmoù',
	'toolbase-autoedits-pct' => 'Dregantad a gemmoù emgefre',
	'toolbase-main-title' => 'Degemer mat !',
	'toolbase-main-404' => "N'eo ket bet kavet ar restr",
	'toolbase-main-404-content' => "Opala ! N'eus bet kavet pajenn ebet !

Bezit sur hoc'h eus skrivet un URL difazi.
Mard oc'h deuet eus lec'h all dre ul liamm, kasit <a href=\"\$1\">ur c'hemenn evit un draen</a>.
</ul>",
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '"$1" n’eo ket un implijer reizh.',
	'toolbase-error-nowiki' => "N'eo ket $1.$2.org ur wiki reizh",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'toolbase-header-title' => 'Alati od X-a!',
	'toolbase-header-bugs' => 'Greške',
	'toolbase-header-sitenotice' => 'Globalna poruka Toolservera: $1',
	'toolbase-replag' => 'Zastoj servera od $1',
	'toolbase-replag-years' => 'godine',
	'toolbase-replag-months' => 'mjeseci',
	'toolbase-replag-weeks' => 'sedmice',
	'toolbase-replag-days' => 'dani',
	'toolbase-replag-hours' => 'sati',
	'toolbase-replag-minutes' => 'minute',
	'toolbase-replag-seconds' => 'sekunde',
	'toolbase-footer-exectime' => 'Izvršeno za $1 sekundi',
	'toolbase-footer-source' => 'Pogledaj izvor',
	'toolbase-footer-language' => 'Promijeni jezik',
	'toolbase-footer-translate' => 'Prevedi',
	'toolbase-navigation' => 'Navigacija',
	'toolbase-navigation-homepage' => 'Glavna stranica',
	'toolbase-navigation-user_id' => 'Nađi korisnički ID',
	'toolbase-navigation-autoedits' => 'Automatizirani brojač izmjena',
	'toolbase-userid-submit' => 'Uzmi korisnički ID',
	'toolbase-userid-title' => 'Traženje korisničkog ID',
	'toolbase-userid-result' => 'Korisnički ID za <b>$1</b> na <a href="$3"><b>$3</b></a> je <b>$2</b>.',
	'toolbase-autoedits-title' => 'Automatizirani računar izmjena',
	'toolbase-autoedits-submit' => 'Izračunaj',
	'toolbase-autoedits-approximate' => '<b>Približan</b> broj izmjena koristeći...',
	'toolbase-autoedits-totalauto' => 'Ukupan broj automatiziranih izmjena',
	'toolbase-autoedits-totalall' => 'Ukupan broj izmjena',
	'toolbase-autoedits-pct' => 'Procenat automatskih izmjena',
	'toolbase-main-title' => 'Dobrodošli!',
	'toolbase-main-content' => 'Dobrodošli na alat X!a! Ovaj komplet alata je još uvijek u procesu pretvaranja u <a href="$1">Symfony</a> okvir. Ovaj proces će potrajati, ali bi zasad trebao raditi. 

Za spisak alata koji trenutno rade na ovom okviru, pogledajte alatnu traku s desne strane.

Greške možete prijaviti na <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Datoteka nije pronađena',
	'toolbase-main-404-content' => 'Ups! Stranica nije pronađena!

Provjerite da li ste unijeli pravilan URL.
Ako ste odnekud pratili link, molimo <a href="$1">prijavite grešku</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 nije valjan korisnik',
	'toolbase-error-nowiki' => '$1.$2.org nije valjana wiki',
	'toolbase-error-toomanyedits' => '$1 ima $2 izmjena. Ovaj alat ima najviše $3 izmjena.',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'toolbase-header-title' => "Eines X!'s (BETA)",
	'toolbase-header-bugs' => 'Errors',
	'toolbase-header-sitenotice' => 'Anunci global del toolserver: $1',
	'toolbase-replag' => 'Retard del servidor de $1',
	'toolbase-replag-years' => 'anys',
	'toolbase-replag-months' => 'mesos',
	'toolbase-replag-weeks' => 'setmanes',
	'toolbase-replag-days' => 'dies',
	'toolbase-replag-hours' => 'hores',
	'toolbase-replag-minutes' => 'minuts',
	'toolbase-replag-seconds' => 'segons',
	'toolbase-footer-exectime' => 'Executat en $1 segons',
	'toolbase-footer-source' => 'Mostra la font',
	'toolbase-footer-language' => "Canvia d'idioma",
	'toolbase-footer-translate' => 'Traducció',
	'toolbase-navigation' => 'Navegació',
	'toolbase-navigation-homepage' => "Pàgina d'inici",
	'toolbase-navigation-user_id' => "Cerca ID d'usuari",
	'toolbase-navigation-autoedits' => "Comptador automatitzat d'edicions",
	'toolbase-userid-submit' => "Obtingues la ID d'usuari",
	'toolbase-userid-title' => "Troba l'ID d'usuari",
	'toolbase-userid-result' => 'La ID d\'usuari de <b>$1</b> a <a href="$3"><b>$3</b></a> és <b>$2</b>.',
	'toolbase-autoedits-title' => "Calculadora d'edicions automatitzada",
	'toolbase-autoedits-submit' => 'Calcula',
	'toolbase-autoedits-approximate' => "Número <b>aproximat</b> d'edicions utilitzant...",
	'toolbase-autoedits-totalauto' => "Número total d'edicions automàtiques",
	'toolbase-autoedits-totalall' => "Recompte total d'edicions",
	'toolbase-autoedits-pct' => "Percentatge d'edicions automatitzades",
	'toolbase-main-title' => 'Benvingut!',
	'toolbase-main-content' => 'Benvingut a les eines X! La família d\'eines encara es troba en procés de ser convertit al framework <a href="$1">Symfony</a>. Aquest procés encara portarà temps, però hauria de funcionar. 

Per a una llista de les eines que actualment funcionen sota aquest framework, vegeu la llista de la barra dreta.

Podeu informar de qualsevol error a <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Fitxer no trobat',
	'toolbase-main-404-content' => "No s'ha trobat la pàgina.

Assegureu-vos d'haver escrit correctament l'adreça URL.
Si heu seguit un enllaç des d'algun lloc, si us plau <a href=\"\$1\">informeu aquest error</a>.
</ul>",
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 no és un usuari vàlid',
	'toolbase-error-nowiki' => '$1.$2.org no és un wiki vàlid',
	'toolbase-error-toomanyedits' => '$1 té $2 edicions. Aquesta eina té un màxim de $3 edicions.',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'toolbase-header-title' => 'X!s Tools',
	'toolbase-header-bugs' => 'Softwarefehler',
	'toolbase-header-sitenotice' => 'Zentrale Meldung des Toolservers: $1',
	'toolbase-replag' => 'Serververzögerung lag bei $1',
	'toolbase-replag-years' => 'Jahre',
	'toolbase-replag-months' => 'Monate',
	'toolbase-replag-weeks' => 'Wochen',
	'toolbase-replag-days' => 'Tage',
	'toolbase-replag-hours' => 'Stunden',
	'toolbase-replag-minutes' => 'Minuten',
	'toolbase-replag-seconds' => 'Sekunden',
	'toolbase-footer-exectime' => 'Binnen $1 Sekunden ausgeführt',
	'toolbase-footer-source' => 'Quelltext anzeigen',
	'toolbase-footer-language' => 'Sprache ändern',
	'toolbase-footer-translate' => 'Übersetzen',
	'toolbase-navigation' => 'Navigation',
	'toolbase-navigation-homepage' => 'Hauptseite',
	'toolbase-navigation-user_id' => 'Benutzerkennung suchen',
	'toolbase-navigation-autoedits' => 'Zähler automatisierter Bearbeitungen',
	'toolbase-userid-submit' => 'Benutzerkennung beantragen',
	'toolbase-userid-title' => 'Eine Benutzerkennung suchen',
	'toolbase-userid-result' => 'Die Benutzerkennung von <b>$1</b> auf <a href="$3"><b>$3</b></a> lautet <b>$2</b>.',
	'toolbase-autoedits-title' => 'Berechner automatisierter Bearbeitungen',
	'toolbase-autoedits-submit' => 'Berechnen',
	'toolbase-autoedits-approximate' => '<b>Ungefähre</b> Anzahl der Bearbeitungen mit …',
	'toolbase-autoedits-totalauto' => 'Gesamtzahl automatisierter Bearbeitung',
	'toolbase-autoedits-totalall' => 'Gesamtzahl der Bearbeitungen',
	'toolbase-autoedits-pct' => 'Prozentanteil automatisierter Bearbeitungen',
	'toolbase-main-title' => 'Willkommen!',
	'toolbase-main-content' => 'Willkommen bei X!s Tools!

Die Tools werden gerade für das <a href="$1">Symfony</a>-Framework lauffähig gemacht. Dies wird eine Weile dauern, allerdings sollten sie bereits jetzt funktionieren.

Eine Liste der Tools, die mit diesem Framework laufen, befindet sich in der rechten Seitenleiste.

Softwarefehler können bei <a href="$2">Google Code</a> gemeldet werden.',
	'toolbase-main-404' => 'Datei nicht gefunden',
	'toolbase-main-404-content' => 'Hoppla! Es wurde keine Webseite gefunden!

Es muss sichergestellt sein, dass die URL richtig angegeben wurde.
Sofern ein Link hierhergeführt hat, ist dies bitte <a href="$1">als Fehler zu melden</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => 'Den Benutzer $1 gibt es nicht',
	'toolbase-error-nowiki' => 'Das Wiki $1.$2.org gibt es nicht',
	'toolbase-error-toomanyedits' => 'Benutzer $1 hat $2 Bearbeitungen gemacht. Dieses Hilfsprogramm hat ein Maximum von $3 Bearbeitungen.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'toolbase-header-title' => "X!'s Tools (BETA)",
	'toolbase-header-bugs' => 'Programowe zmólki',
	'toolbase-header-sitenotice' => 'Globalna powěźeńka toolserwera: $1',
	'toolbase-replag' => 'Serwer jo se wó $1 wokomuźił',
	'toolbase-replag-years' => 'lět',
	'toolbase-replag-months' => 'mjasecow',
	'toolbase-replag-weeks' => 'tyźenjow',
	'toolbase-replag-days' => 'dnjow',
	'toolbase-replag-hours' => 'góźinow',
	'toolbase-replag-minutes' => 'minutow',
	'toolbase-replag-seconds' => 'sekundow',
	'toolbase-footer-exectime' => 'Za $1 sekundow wugbany',
	'toolbase-footer-source' => 'Žrědłowy tekst se woglědaś',
	'toolbase-footer-language' => 'Rěc změniś',
	'toolbase-footer-translate' => 'Pśełožyś',
	'toolbase-navigation' => 'Nawigacija',
	'toolbase-navigation-homepage' => 'Startowy bok',
	'toolbase-navigation-user_id' => 'Wužywarski ID pytaś',
	'toolbase-navigation-autoedits' => 'Licak awtomatizěrowanych změnow',
	'toolbase-userid-submit' => 'Wužywarski ID wobstaraś',
	'toolbase-userid-title' => 'Wužywarski ID pytaś',
	'toolbase-userid-result' => 'Wužywarski ID za <b>$1</b> na <a href="$3"><b>$3</b></a> jo <b>$2</b>.',
	'toolbase-autoedits-title' => 'Wulicak awtomatizěrowanych změnow',
	'toolbase-autoedits-submit' => 'Wulicyś',
	'toolbase-autoedits-approximate' => '<b>Pśibližna</b> licba změnow z...',
	'toolbase-autoedits-totalauto' => 'Cełkowna licba awtomatizěrowanych změnow',
	'toolbase-autoedits-totalall' => 'Cełkowna licba změnow',
	'toolbase-autoedits-pct' => 'Procentowa sajźba awtomatizěrowanych změnow',
	'toolbase-main-title' => 'Witaj!',
	'toolbase-main-content' => 'Witaj k X!\'s tools! Rědowy pakśik konwertěrujo se rowno hyšći do frameworka <a href="$1">Symfony</a>. Toś ten proces buźo chylku traś, ale by měł južo něnto funkcioněrowaś.

Za lisćinu rědow, kótarež južo funkcioněruju z toś tym frameworkom, glědaj bocnicu napšawo.

Programowe zmólki móžoš pśi <a href="$2">Google Code</a> k wěsći daś.',
	'toolbase-main-404' => 'Dataja njenamakana',
	'toolbase-main-404-content' => 'Ojejko! Žedne websedło njenamakane!

Pśekontrolěruj, lěc sy URL korektnje zapisał.
Jolic wótkaz jo śe zwótkul něźi sem wjadł, <a href="$1">daj pšosym programowu zmólku k wěsći</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 njejo płaśiwy wužywaŕ',
	'toolbase-error-nowiki' => '$1.$2.org njejo płaśiwy wiki',
	'toolbase-error-toomanyedits' => '$1 ma $2 změnow. Tós ten rěd ma maksimalnje $3 změnow.',
);

/** Greek (Ελληνικά)
 * @author Evropi
 */
$messages['el'] = array(
	'toolbase-header-title' => "X!'s Tools (BETA)",
	'toolbase-header-bugs' => 'Σφάλματα',
	'toolbase-replag-years' => 'χρόνια',
	'toolbase-replag-months' => 'μήνες',
	'toolbase-replag-weeks' => 'εβδομάδες',
	'toolbase-replag-days' => 'ημέρες',
	'toolbase-replag-hours' => 'ώρες',
	'toolbase-replag-minutes' => 'λεπτά',
	'toolbase-replag-seconds' => 'δευτερόλεπτα',
	'toolbase-footer-exectime' => 'Εκτελέθηκε σε $1 δευτερόλεπτα',
	'toolbase-footer-source' => 'Εμφάνιση κώδικα',
	'toolbase-footer-language' => 'Αλλαγή γλώσσας',
	'toolbase-footer-translate' => 'Μετάφραση',
	'toolbase-navigation' => 'Πλοήγηση',
	'toolbase-navigation-homepage' => 'Αρχική σελίδα',
	'toolbase-navigation-user_id' => 'Αναζήτηση λογαριασμού χρήστη',
	'toolbase-navigation-autoedits' => 'Αυτοματοποιημένος μετρητής επεξεργασιών',
	'toolbase-userid-submit' => 'Λήψη λογαριασμού χρήστη',
	'toolbase-userid-title' => 'Αναζήτηση λογαριασμού χρήστη',
	'toolbase-userid-result' => 'Ο λογαριασμός χρήστη για τον <b>$1</b> στο <a href="$3"><b>$3</b></a> είναι <b>$2</b>.',
	'toolbase-autoedits-title' => 'Αυτοματοποιημένη αριθμομηχανή επεξεργασιών',
	'toolbase-autoedits-submit' => 'Υπολογισμός',
	'toolbase-autoedits-approximate' => '<b>Προσέγγιση</b> αριθμού των επεξεργασιών που χρησιμοποιούν...',
	'toolbase-autoedits-totalauto' => 'Συνολικός αριθμός αυτοματοποιημένων επεξεργασιών',
	'toolbase-autoedits-totalall' => 'Συνολικός αριθμός επεξεργασιών',
	'toolbase-autoedits-pct' => 'Ποσοστό των αυτοματοποιημένων επεξεργασιών',
	'toolbase-main-title' => 'Καλός ήρθατε!',
	'toolbase-main-content' => 'Καλώς ήρθατε στο X!\'s tools! Η σουίτα εργαλειών είναι ακόμη στη διαδικασία μετατροπής προς το πλαίσιο <a href="$1">Symfony</a>. Η διαδικασία αυτή θα πάρει λίγο καιρό, αλλά θα πρέπει να λειτουργεί τώρα.

Για μια λίστα των εργαλείων που εκτελούνται αυτή τη στιγμή σε αυτό το πλαίσιο, κοιτάξτε τη πλευρική γραμμή στα δεξιά.

Μπορείτε να αναφέρετε σφάλματα στο <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Το αρχείο δεν βρέθηκε',
	'toolbase-main-404-content' => 'Ωχ! Η σελίδα δεν βρέθηκε!

Βεβαιωθείτε ότι έχετε πληκτρολογήσει σωστά τη διεύθυνση URL.
Εάν ήρθατε εδώ μέσω ενός συνδέσμου, παρακαλώ <a href="$1">αναφέρετε το σφάλμα</a>.
</ul>',
	'toolbase-form-wiki' => 'Βίκι',
	'toolbase-error-nouser' => 'Ο $1 δεν είναι έγκυρος χρήστης',
	'toolbase-error-nowiki' => 'Το $1.$2.org δεν είναι ένα έγκυρο βίκι',
);

/** Spanish (Español)
 * @author Fitoschido
 * @author Mor
 */
$messages['es'] = array(
	'toolbase-header-title' => 'Herramientas de X! (BETA)',
	'toolbase-header-bugs' => 'Bugs',
	'toolbase-header-sitenotice' => 'Mensaje global de Toolserver: $1',
	'toolbase-replag' => 'Servidor con un retraso de $1',
	'toolbase-replag-years' => 'años',
	'toolbase-replag-months' => 'meses',
	'toolbase-replag-weeks' => 'semanas',
	'toolbase-replag-days' => 'días',
	'toolbase-replag-hours' => 'horas',
	'toolbase-replag-minutes' => 'minutos',
	'toolbase-replag-seconds' => 'segundos',
	'toolbase-footer-exectime' => 'Ejecutado en $1 segundos',
	'toolbase-footer-source' => 'Ver código fuente',
	'toolbase-footer-language' => 'Cambiar idioma',
	'toolbase-footer-translate' => 'Traducir',
	'toolbase-navigation' => 'Navegación',
	'toolbase-navigation-homepage' => 'Página principal',
	'toolbase-navigation-user_id' => 'Encontrar el ID de usuario',
	'toolbase-navigation-autoedits' => 'Contador de ediciones automatizadas',
	'toolbase-userid-submit' => 'Obtener el ID de usuario',
	'toolbase-userid-title' => 'Encontrar un ID de usuario',
	'toolbase-userid-result' => 'El ID de usuario para <b>$1</b> en <a href="$3"><b>$3</b></a> es <b>$2</b>.',
	'toolbase-autoedits-title' => 'Calculadora de ediciones automatizada',
	'toolbase-autoedits-submit' => 'Calcular',
	'toolbase-autoedits-approximate' => 'Número <b>aproximado</b> de ediciones usando...',
	'toolbase-autoedits-totalauto' => 'Número total de ediciones automatizadas',
	'toolbase-autoedits-totalall' => 'Recuento total de ediciones',
	'toolbase-autoedits-pct' => 'Porcentaje de ediciones automatizadas',
	'toolbase-main-title' => '¡Bienvenidos!',
	'toolbase-main-content' => '¡Bienvenido a las herramientas de X! Esta suite de herramientas aún está en proceso de adaptarse al framework <a href="$1">Symfony</a>. Este proceso tomará un tiempo, pero debería funcionar ahora.

Para la lista de herramientas que están funcionando actualmente en este framework, ve la columna de la derecha.

Puedes informar de errores en <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Archivo no encontrado',
	'toolbase-main-404-content' => '¡Vaya, no se encontró la página!

Asegúrate de que escribiste la URL correctamente.
Si llegaste hasta aquí por medio de un enlace, por favor <a href="$1">informa del error</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 no es un usuario válido',
	'toolbase-error-nowiki' => '$1.$2.org no es un wiki válido',
	'toolbase-error-toomanyedits' => '$1 tiene $2 ediciones. Esta herramienta tiene un máximo de $3 ediciones.',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Olli
 */
$messages['fi'] = array(
	'toolbase-header-title' => 'X!:n työkalut (BETA)',
	'toolbase-header-bugs' => 'Ohjelmavirheet',
	'toolbase-header-sitenotice' => 'Toolserver-palvelimen yleishuomautus: $1',
	'toolbase-replag' => 'Palvelimen viive on $1',
	'toolbase-replag-years' => 'vuotta',
	'toolbase-replag-months' => 'kuukautta',
	'toolbase-replag-weeks' => 'viikkoa',
	'toolbase-replag-days' => 'päivää',
	'toolbase-replag-hours' => 'tuntia',
	'toolbase-replag-minutes' => 'minuuttia',
	'toolbase-replag-seconds' => 'sekuntia',
	'toolbase-footer-exectime' => 'Suoritettu $1 sekunnissa',
	'toolbase-footer-source' => 'Näytä lähdekoodi',
	'toolbase-footer-language' => 'Vaihda kieltä',
	'toolbase-footer-translate' => 'Käännä',
	'toolbase-navigation' => 'Valikko',
	'toolbase-navigation-homepage' => 'Kotisivu',
	'toolbase-navigation-user_id' => 'Etsi käyttäjän ID',
	'toolbase-navigation-autoedits' => 'Automaattinen muokkauslaskuri',
	'toolbase-userid-submit' => 'Hae käyttäjän ID',
	'toolbase-userid-title' => 'Etsi käyttäjän ID',
	'toolbase-userid-result' => 'Käyttäjän <b>$1</b> ID kohteessa <a href="$3"><b>$3</b></a> on <b>$2</b>.',
	'toolbase-autoedits-title' => 'Automaattinen muokkauslaskuri',
	'toolbase-autoedits-submit' => 'Laske',
	'toolbase-autoedits-approximate' => '<b>Arvioi</b> muokkausten määrää käyttäen...',
	'toolbase-autoedits-totalauto' => 'Automatisoitujen muokkausten kokonaismäärä',
	'toolbase-autoedits-totalall' => 'Muokkauksia yhteensä',
	'toolbase-autoedits-pct' => 'Automatisoitujen muokkausten osuus',
	'toolbase-main-title' => 'Tervetuloa!',
	'toolbase-main-content' => 'Tervetuloa X!:n työkaluihin! Tätä työkalukokoelmaa ollaan edelleen muuttamassa <a href="$1">Symfony</a>-ympäristöön. Tämä prosessi kestää jonkin aikaa, mutta sen pitäisi toimia nyt.

Oikealla olevassa sivupalkissa on luettelo tällä hetkellä toimivasta työkaluista-

Voit ilmoittaa ohjelmavirheistä <a href="$2">Google Code</a> -sivustolle.',
	'toolbase-main-404' => 'Tiedostoa ei löydy',
	'toolbase-main-404-content' => 'Hups! Sivua ei löytynyt!

Tarkista, että kirjoitit osoitteen oikein.
Jos napsautit linkkiä, <a href="$1">ilmoitathan virheestä</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 ei ole kelpaava käyttäjä',
	'toolbase-error-nowiki' => '$1.$2.org ei ole kelpaava wiki',
	'toolbase-error-toomanyedits' => 'Käyttäjällä $1 on $2 muokkausta. Tämä työkalu hallitsee enintään $3 muokkausta.',
);

/** French (Français)
 * @author Grondin
 * @author Hashar
 * @author IAlex
 * @author Sherbrooke
 * @author X!
 * @author Zetud
 */
$messages['fr'] = array(
	'toolbase-header-title' => 'Outils X! (BETA)',
	'toolbase-header-bugs' => 'Bugs',
	'toolbase-header-sitenotice' => "Avis de site du serveur d'outils global : $1",
	'toolbase-replag' => 'Serveur en retard de $1',
	'toolbase-replag-years' => 'années',
	'toolbase-replag-months' => 'mois',
	'toolbase-replag-weeks' => 'semaines',
	'toolbase-replag-days' => 'jours',
	'toolbase-replag-hours' => 'heures',
	'toolbase-replag-minutes' => 'minutes',
	'toolbase-replag-seconds' => 'secondes',
	'toolbase-footer-exectime' => 'Complété en $1 {{PLURAL:$1|seconde|secondes}}',
	'toolbase-footer-source' => 'Voir le texte source',
	'toolbase-footer-language' => 'Changer de langue',
	'toolbase-footer-translate' => 'Traduire',
	'toolbase-navigation' => 'Navigation',
	'toolbase-navigation-homepage' => "Page d'accueil",
	'toolbase-navigation-user_id' => "Trouver l'ID utilisateur",
	'toolbase-navigation-autoedits' => 'Compteur de modifications automatisé',
	'toolbase-userid-submit' => "Obtenir l'ID utilisateur",
	'toolbase-userid-title' => 'Trouver un ID utilisateur',
	'toolbase-userid-result' => 'L\'ID utilisateur pour <b>$1</b> sur <a href="$3"><b>$3</b></a> est <b>$2</b>.',
	'toolbase-autoedits-title' => 'Calculateur de modifications automatisé',
	'toolbase-autoedits-submit' => 'Calculer',
	'toolbase-autoedits-approximate' => 'Nombre <b>approximatif</b> de modifications en utilisant...',
	'toolbase-autoedits-totalauto' => 'Nombre total de modifications automatisées',
	'toolbase-autoedits-totalall' => 'Nombre total de modifications',
	'toolbase-autoedits-pct' => 'Pourcentage de modifications automatisées',
	'toolbase-main-title' => 'Bienvenue !',
	'toolbase-main-content' => 'Bienvenue sur la page d\'outils X ! Cette suite d\'outils est présentement en conversion vers le framework <a href="$1">Symfony</a>. Ce processus prendra un certain temps, mais les outils devraient fonctionner correctement dès maintenant. 

Pour obtenir une liste d\'outils qui sont fonctionnels sur ce framework, voir l\'encadré à droite. 

Les bugs peuvent être rapportés à <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Fichier introuvable',
	'toolbase-main-404-content' => 'Oups ! Aucune page n\'a été trouvée !

Assurez-vous que vous avez tapé l\'URL correctement.
Si vous avez suivi un lien, veuillez <a href="$1">rapporter le bug</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => "$1 n'est pas un utilisateur valide",
	'toolbase-error-nowiki' => "$1.$2.org n'est pas un wiki valide",
	'toolbase-error-toomanyedits' => '$1 a $2 modifications. Cet outil a un maximum de $3 modifications.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'toolbase-header-title' => 'Outils X! (BÈTA)',
	'toolbase-header-bugs' => 'Cofieries',
	'toolbase-header-sitenotice' => 'Avis du seto du sèrvor d’outils globâl : $1',
	'toolbase-replag' => 'Sèrvor en retârd de $1',
	'toolbase-replag-years' => 'ans',
	'toolbase-replag-months' => 'mês',
	'toolbase-replag-weeks' => 'semanes',
	'toolbase-replag-days' => 'jorns',
	'toolbase-replag-hours' => 'hores',
	'toolbase-replag-minutes' => 'menutes',
	'toolbase-replag-seconds' => 'secondes',
	'toolbase-footer-exectime' => 'Complètâ en $1 second{{PLURAL:$1|a|es}}',
	'toolbase-footer-source' => 'Vêre lo tèxto sôrsa',
	'toolbase-footer-language' => 'Changiér de lengoua',
	'toolbase-footer-translate' => 'Traduire',
	'toolbase-navigation' => 'Navigacion',
	'toolbase-navigation-homepage' => 'Pâge de reçua',
	'toolbase-navigation-user_id' => 'Trovar lo numerô usanciér',
	'toolbase-navigation-autoedits' => 'Comptor de changements ôtomatisâ',
	'toolbase-userid-submit' => 'Avêr lo numerô usanciér',
	'toolbase-userid-title' => 'Trovar un numerô usanciér',
	'toolbase-userid-result' => 'Lo numerô usanciér por <b>$1</b> dessus <a href="$3"><b>$3</b></a> est <b>$2</b>.',
	'toolbase-autoedits-title' => 'Calculator de changements ôtomatisâ',
	'toolbase-autoedits-submit' => 'Calcular',
	'toolbase-autoedits-approximate' => 'Nombro <b>a pou prés</b> de changements en utilisent...',
	'toolbase-autoedits-totalauto' => 'Nombro totâl de changements ôtomatisâs',
	'toolbase-autoedits-totalall' => 'Soma totâla de changements',
	'toolbase-autoedits-pct' => 'Porcentâjo de changements ôtomatisâs',
	'toolbase-main-title' => 'Benvegnua !',
	'toolbase-main-404' => 'Fichiér entrovâblo',
	'toolbase-form-wiki' => 'Vouiqui',
	'toolbase-error-nouser' => '$1 est pas un usanciér valido',
	'toolbase-error-nowiki' => '$1.$2.org est pas un vouiqui valido',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'toolbase-header-title' => 'Ferramentas de X! (BETA)',
	'toolbase-header-bugs' => 'Erros',
	'toolbase-header-sitenotice' => 'Anuncio global do servidor de ferramentas: $1',
	'toolbase-replag' => 'Servidor con atraso por $1',
	'toolbase-replag-years' => 'anos',
	'toolbase-replag-months' => 'meses',
	'toolbase-replag-weeks' => 'semanas',
	'toolbase-replag-days' => 'días',
	'toolbase-replag-hours' => 'horas',
	'toolbase-replag-minutes' => 'minutos',
	'toolbase-replag-seconds' => 'segundos',
	'toolbase-footer-exectime' => 'Executado en $1 segundos',
	'toolbase-footer-source' => 'Ver o código fonte',
	'toolbase-footer-language' => 'Cambiar a lingua',
	'toolbase-footer-translate' => 'Traducir',
	'toolbase-navigation' => 'Navegación',
	'toolbase-navigation-homepage' => 'Inicio',
	'toolbase-navigation-user_id' => 'Atopar o ID de usuario',
	'toolbase-navigation-autoedits' => 'Contador de edicións automático',
	'toolbase-userid-submit' => 'Obter o ID de usuario',
	'toolbase-userid-title' => 'Atopar o ID de usuario',
	'toolbase-userid-result' => 'O ID de usuario de <b>$1</b> en <a href="$3"><b>$3</b></a> é <b>$2</b>.',
	'toolbase-autoedits-title' => 'Contador de edicións automático',
	'toolbase-autoedits-submit' => 'Calcular',
	'toolbase-autoedits-approximate' => 'Número <b>aproximado</b> de edicións usando...',
	'toolbase-autoedits-totalauto' => 'Número total de edicións automáticas',
	'toolbase-autoedits-totalall' => 'Número total de edicións',
	'toolbase-autoedits-pct' => 'Porcentaxe de edicións automáticas',
	'toolbase-main-title' => 'Benvido!',
	'toolbase-main-content' => 'Benvido ás ferramentas de X! Este conxunto de ferramentas está aínda en proceso de conversión á estrutura <a href="$1">Symfony</a>. Este proceso tardará un tempo, pero as ferramentas debería funcionar.

Para ollar unha lista coas ferramentas executadas nestes intres, véxase a barra lateral dereita.

Pódese informar dos erros en <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Non se atopou o ficheiro',
	'toolbase-main-404-content' => 'Vaites! Non se atopou ningunha páxina!

Comprobe que escribiu o enderezo URL correctamente.
Se seguiu unha ligazón, <a href="$1">informe do erro</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '"$1" non é un usuario válido',
	'toolbase-error-nowiki' => '$1.$2.org non é un wiki válido',
	'toolbase-error-toomanyedits' => '$1 fixo $2 edicións. Esta ferramenta ten un máximo de $3 edicións.',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 */
$messages['gsw'] = array(
	'toolbase-header-title' => 'X!s Tools (BETA)',
	'toolbase-header-bugs' => 'Softwarefääler',
	'toolbase-header-sitenotice' => 'Zentrali Mäldig vum Toolserver: $1',
	'toolbase-replag' => 'Serververzögerig isch bi $1 glege',
	'toolbase-replag-years' => 'Joor',
	'toolbase-replag-months' => 'Monet',
	'toolbase-replag-weeks' => 'Wuche',
	'toolbase-replag-days' => 'Täg',
	'toolbase-replag-hours' => 'Stunde',
	'toolbase-replag-minutes' => 'Minute',
	'toolbase-replag-seconds' => 'Sekunde',
	'toolbase-footer-exectime' => 'Innerhalb vo $1 Sekunde ussgfiert worde',
	'toolbase-footer-source' => 'Quelltext aaluege',
	'toolbase-footer-language' => 'Sprooch wechsle',
	'toolbase-footer-translate' => 'Ibersetze',
	'toolbase-navigation' => 'Navigation',
	'toolbase-navigation-homepage' => 'Startsyte',
	'toolbase-navigation-user_id' => 'Benutzerkennig sueche',
	'toolbase-navigation-autoedits' => 'Automatische Bearbeitigszääler',
	'toolbase-userid-submit' => 'Benutzerkennig beantrage',
	'toolbase-userid-title' => 'Benutzerkennig sueche',
	'toolbase-userid-result' => 'D Benutzerkennig vo <b>$1</b> uff<a href="$3"><b>$3</b></a> luutet <b>$2</b>.',
	'toolbase-autoedits-title' => 'Automatische Bearbeitigszääler',
	'toolbase-autoedits-submit' => 'Berächne',
	'toolbase-autoedits-approximate' => '<b>Ungfääri</b> Aazaal vo Bearbeitige mit …',
	'toolbase-autoedits-totalauto' => 'Gsamti Aazaal vo automatische Bearbeitige',
	'toolbase-autoedits-totalall' => 'Gsamtzaal vo Bearbeitige',
	'toolbase-autoedits-pct' => 'Prozentaateil vo automatisierte Bearbeitige',
	'toolbase-main-title' => 'Willchu!',
	'toolbase-main-content' => 'Willchu bi X!s Tools!

Die Tools werde zur Zit für s <a href="$1">Symfony</a>-Framework parat gmacht. Des wird no es Wyyl goo, allerdings sötte si jetzt scho funktioniere.

E Lischt vo de Tools, wo mit däm Framework laufe, befindet sich in de rächte Syteleiste.

Softwarefääler chönne bi <a href="$2">Google Code</a> gmolde werde.',
	'toolbase-main-404' => 'Datei nit gfunde',
	'toolbase-main-404-content' => 'Hoppla! Es isch kei Websyte gfunde worde!

Lueg emool, ob du d URL richtig yygee hesch.
Wänn du über en Link doo ane cho bisch, no due des bitte <a href="$1">als Fääler mälde</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 isch kei giltige Benutzername.',
	'toolbase-error-nowiki' => "S Wiki $1.$2.org git's nit",
	'toolbase-error-toomanyedits' => 'Benutzer $1 het $2 Bearbeitige gmacht. Des Hilfsprogramm het e Maximum vo $3 Bearbeitige.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'toolbase-header-title' => 'הכלים של <span dir="ltr">X!</span> (בטא)',
	'toolbase-header-bugs' => 'באגים',
	'toolbase-header-sitenotice' => 'הודעה כללית ב־Toolserver&rlm;: $1',
	'toolbase-replag' => 'השרת פיגר ב־$1',
	'toolbase-replag-years' => 'שנים',
	'toolbase-replag-months' => 'חודשים',
	'toolbase-replag-weeks' => 'שבועות',
	'toolbase-replag-days' => 'ימים',
	'toolbase-replag-hours' => 'שעות',
	'toolbase-replag-minutes' => 'דקות',
	'toolbase-replag-seconds' => 'שניות',
	'toolbase-footer-exectime' => 'בוצע ב־$1 שניות',
	'toolbase-footer-source' => 'הצגת המקור',
	'toolbase-footer-language' => 'החלפת שפה',
	'toolbase-footer-translate' => 'תרגום',
	'toolbase-navigation' => 'ניווט',
	'toolbase-navigation-homepage' => 'דף הבית',
	'toolbase-navigation-user_id' => 'מציאת מזהה משתמש',
	'toolbase-navigation-autoedits' => 'מונה עריכות אוטומטיות',
	'toolbase-userid-submit' => 'לקבל מזהה משתמש',
	'toolbase-userid-title' => 'למצוא מזהה משתמש',
	'toolbase-userid-result' => 'מזהה המשתמש עבור <b>$1</b> ב־<a href="$3"><b>$3</b></a> הוא <b>$2</b>.',
	'toolbase-autoedits-title' => 'מחשבון עריכות אוטומטי',
	'toolbase-autoedits-submit' => 'לחשב',
	'toolbase-autoedits-approximate' => 'מספר <b>מקורב</b> של עריכות באמצעות...',
	'toolbase-autoedits-totalauto' => 'סך הכול עריכות אוטומטיות',
	'toolbase-autoedits-totalall' => 'מספר עריכות כולל:',
	'toolbase-autoedits-pct' => 'אחוז העריכות האוטומטיות',
	'toolbase-main-title' => 'ברוכים הבאים!',
	'toolbase-main-content' => 'ברוכים הבאים לכלים של <span dir="ltr">X!</span>! ערכת הכלים עדיין בתהליך המרה ל־<a href="$1">Symfony</a>. התהליך הזה עשוי לקחת זמן, אבל עכשיו היא אמורה לעבוד.

לרשימת כלים שכעת עובדים ב־Symphony, ר׳ את סרגל הצד.

אפשר לדווח באגים ב־<a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'הקובץ לא נמצא',
	'toolbase-main-404-content' => 'אוי! הדף לא נמצא!

נא לוודא שההקלדתם כתובת נכונה.
אם הגעתם הנה על־ידי לחיצה על קישור, אנא <a href="$1">דווחו באג</a>.
</ul>',
	'toolbase-form-wiki' => 'ויקי',
	'toolbase-error-nouser' => '$1 אינו משתמש תקין',
	'toolbase-error-nowiki' => '$1.$2.org אינו ויקי תקין',
	'toolbase-error-toomanyedits' => 'ל־$1 יש $2 עריכות. הכלי הזה יכול לטפל לכל היותר ב־$3 עריכות.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'toolbase-header-title' => "X!'s Tools (BETA)",
	'toolbase-header-bugs' => 'Programowe zmylki',
	'toolbase-header-sitenotice' => 'Globalna zdźělenka toolserwera: $1',
	'toolbase-replag' => 'Serwer komdźeše so wo $1',
	'toolbase-replag-years' => 'lět',
	'toolbase-replag-months' => 'měsacow',
	'toolbase-replag-weeks' => 'njedźelow',
	'toolbase-replag-days' => 'dnjow',
	'toolbase-replag-hours' => 'hodźin',
	'toolbase-replag-minutes' => 'mjeńšin',
	'toolbase-replag-seconds' => 'sekundow',
	'toolbase-footer-exectime' => 'Wob $1 sekundow wuwjedźeny',
	'toolbase-footer-source' => 'Žórło sej wobhladać',
	'toolbase-footer-language' => 'Rěč změnić',
	'toolbase-footer-translate' => 'Přełožić',
	'toolbase-navigation' => 'Nawigacija',
	'toolbase-navigation-homepage' => 'Startowa strona',
	'toolbase-navigation-user_id' => 'Wužiwarski ID pytać',
	'toolbase-navigation-autoedits' => 'Ličak awtomatizowanych změnow',
	'toolbase-userid-submit' => 'Wužiwarski ID wobstarać',
	'toolbase-userid-title' => 'Wužiwarski ID pytać',
	'toolbase-userid-result' => 'Wužiwarski ID za <b>$1</b> na <a href="$3"><b>$3</b></a> je <b>$2</b>.',
	'toolbase-autoedits-title' => 'Wobličowak awtomatizowanych změnow',
	'toolbase-autoedits-submit' => 'Wobličić',
	'toolbase-autoedits-approximate' => '<b>Přibližna</b> ličba změnow z...',
	'toolbase-autoedits-totalauto' => 'Cyłkowna ličba awtomatizowanych změnow',
	'toolbase-autoedits-totalall' => 'Cyłkowna ličba změnow',
	'toolbase-autoedits-pct' => 'Procentowa sadźba awtomatizowanych změnow',
	'toolbase-main-title' => 'Witaj!',
	'toolbase-main-content' => 'Witaj k X!\'s tools! Gratowy pakćik so runje hišće do frameworka <a href="$1">Symfony</a> konwertuje. Tutón proces budźe chwilku trać, ale měł hižo nětko fungować.

Za lisćinu gratow, kotrež hižo z tutym frameworkom funguja, hlej bóčnicu naprawo.

Programowe zmylki móžeš k <a href="$2">Google Code</a> zdźělić.',
	'toolbase-main-404' => 'Dataja njenamakana',
	'toolbase-main-404-content' => 'Ow jej! Žane websydło njenamakane!

Skontroluj, hač sy URL korektnje zapisał.
Jeli wotkaz je će wot něhdźe sem wjedł, <a href="$1">zdźěl prošu programowy zmylk</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 płaćiwy wužiwar njeje.',
	'toolbase-error-nowiki' => '$1.$2.org płaćiwy wiki njeje',
	'toolbase-error-toomanyedits' => '$1 ma $2 změnow. Tutón nastroj ma maksimalnje $3 změnow.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'toolbase-header-title' => "X!'s Tools (béta)",
	'toolbase-header-bugs' => 'Hibák',
	'toolbase-replag-years' => 'év',
	'toolbase-replag-months' => 'hónap',
	'toolbase-replag-weeks' => 'hét',
	'toolbase-replag-days' => 'nap',
	'toolbase-replag-hours' => 'óra',
	'toolbase-replag-minutes' => 'perc',
	'toolbase-replag-seconds' => 'másodperc',
	'toolbase-footer-exectime' => 'Végrehajtva $1 másodperc alatt',
	'toolbase-footer-source' => 'Forrás megtekintése',
	'toolbase-footer-language' => 'Nyelv módosítása',
	'toolbase-footer-translate' => 'Fordítás',
	'toolbase-navigation' => 'Navigáció',
	'toolbase-navigation-homepage' => 'Honlap',
	'toolbase-navigation-user_id' => 'Felhasználó azonosítójának megkeresése',
	'toolbase-navigation-autoedits' => 'Automatikus szerkesztésszámláló',
	'toolbase-main-404' => 'Fájl nem található',
	'toolbase-main-404-content' => 'Hoppá! A lap nem található!

Ellenőrizd, hogy helyesen írtad-e be az URL-címet.
Ha valahonnan egy linket követtél, <a href="$1">jelentsd a hibát</a>!
</ul>',
	'toolbase-form-wiki' => 'Wiki',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'toolbase-header-title' => 'Instrumentos de X!',
	'toolbase-header-bugs' => 'Faltas',
	'toolbase-header-sitenotice' => 'Notitia global de Toolserver: $1',
	'toolbase-replag' => 'Servitor retardate $1',
	'toolbase-replag-years' => 'annos',
	'toolbase-replag-months' => 'menses',
	'toolbase-replag-weeks' => 'septimanas',
	'toolbase-replag-days' => 'dies',
	'toolbase-replag-hours' => 'horas',
	'toolbase-replag-minutes' => 'minutas',
	'toolbase-replag-seconds' => 'secundas',
	'toolbase-footer-exectime' => 'Executate in $1 secundas',
	'toolbase-footer-source' => 'Vider codice-fonte',
	'toolbase-footer-language' => 'Cambiar de lingua',
	'toolbase-footer-translate' => 'Traducer',
	'toolbase-navigation' => 'Navigation',
	'toolbase-navigation-homepage' => 'Pagina initial',
	'toolbase-navigation-user_id' => 'Cercar ID de usator',
	'toolbase-navigation-autoedits' => 'Contator de modificationes automatisate',
	'toolbase-userid-submit' => 'Obtener ID',
	'toolbase-userid-title' => 'Cercar le ID de un usator',
	'toolbase-userid-result' => 'Le ID del usator <b>$1</b> in <a href="$3"><b>$3</b></a> es <b>$2</b>.',
	'toolbase-autoedits-title' => 'Calculator de modificationes automatisate',
	'toolbase-autoedits-submit' => 'Calcular',
	'toolbase-autoedits-approximate' => 'Numero <b>approximative</b> de modificationes usante…',
	'toolbase-autoedits-totalauto' => 'Numero total de modificationes automatisate',
	'toolbase-autoedits-totalall' => 'Numero total de modificationes',
	'toolbase-autoedits-pct' => 'Percentage de modificationes automatisate',
	'toolbase-main-title' => 'Benvenite!',
	'toolbase-main-content' => 'Benvenite al instrumentos de X!. Le instrumentario es ancora in le processo de conversion al quadro <a href="$1">Symfony</a>. Iste processo durara un tempore, ma deberea functionar ora.

Pro un lista de instrumentos que ora functiona sur iste quadro, vide le barra lateral al dextra.

Faltas pote esser reportate a <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'File non trovate',
	'toolbase-main-404-content' => 'Ups! Nulle pagina esseva trovate!

Assecura te de haber entrate le URL correctemente.
Si un ligamine te ha ducite hic, per favor <a href="$1">reporta un falta</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '"$1" non es un usator valide',
	'toolbase-error-nowiki' => '$1.$2.org non es un wiki valide',
	'toolbase-error-toomanyedits' => '$1 ha $2 modificationes. Iste instrumento ha un maximo de $3 modificationes.',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Kenrick95
 */
$messages['id'] = array(
	'toolbase-header-title' => 'Alat X! (BETA)',
	'toolbase-header-bugs' => 'Bug',
	'toolbase-header-sitenotice' => 'Pesan situs global Toolserver: $1',
	'toolbase-replag' => 'Server tertinggal selama $1',
	'toolbase-replag-years' => 'tahun',
	'toolbase-replag-months' => 'bulan',
	'toolbase-replag-weeks' => 'pekan',
	'toolbase-replag-days' => 'hari',
	'toolbase-replag-hours' => 'jam',
	'toolbase-replag-minutes' => 'menit',
	'toolbase-replag-seconds' => 'detik',
	'toolbase-footer-exectime' => 'Dilaksanakan dalam $1 detik',
	'toolbase-footer-source' => 'Lihat sumber',
	'toolbase-footer-language' => 'Ganti bahasa',
	'toolbase-footer-translate' => 'Terjemahkan',
	'toolbase-navigation' => 'Navigasi',
	'toolbase-navigation-homepage' => 'Beranda',
	'toolbase-navigation-user_id' => 'Cari ID pengguna',
	'toolbase-navigation-autoedits' => 'Penghitung suntingan otomatis',
	'toolbase-userid-submit' => 'Cari ID pengguna',
	'toolbase-userid-title' => 'Cari suatu ID pengguna',
	'toolbase-userid-result' => 'ID pengguna untuk <b>$1</b> pada <a href="$3"><b>$3</b></a> adalah <b>$2</b>.',
	'toolbase-autoedits-title' => 'Kalkulator suntingan otomatis',
	'toolbase-autoedits-submit' => 'Hitung',
	'toolbase-autoedits-approximate' => '<b>Perkiraan</b> jumlah suntingan yang menggunakan ...',
	'toolbase-autoedits-totalauto' => 'Jumlah suntingan otomatis',
	'toolbase-autoedits-totalall' => 'Total suntingan',
	'toolbase-autoedits-pct' => 'Persentase suntingan otomatis',
	'toolbase-main-title' => 'Selamat datang!',
	'toolbase-main-content' => 'Selamat datang di alat X! Perangkat alat ini masih dalam proses yang konversi ke kerangka kerja <a href="$1">Symfony</a>. Proses ini memerlukan waktu, tetapi sekarang telah dapat dipakai.

Untuk daftar alat yang saat ini berjalan pada kerangka kerja ini, lihat bilah sisi di sebelah kanan.

Bug dapat dilaporkan ke <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Berkas tidak ditemukan.',
	'toolbase-main-404-content' => 'Ups! Halaman tidak ditemukan! 

Pastikan bahwa Anda mengetik URL dengan benar.
Jika Anda mengikuti tautan dari tempat lain, silahkan <a href="$1">laporkan bug</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 bukan pengguna yang sah',
	'toolbase-error-nowiki' => '$1.$2.org bukan wiki yang sah',
	'toolbase-error-toomanyedits' => '$1 memiliki $2 suntingan. Peralatan ini memiliki batas maksimal $3 suntingan.',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Rippitippi
 */
$messages['it'] = array(
	'toolbase-header-title' => "X!'s Tools (BETA)",
	'toolbase-header-bugs' => 'Errori',
	'toolbase-replag-years' => 'anni',
	'toolbase-replag-months' => 'mesi',
	'toolbase-replag-weeks' => 'settimane',
	'toolbase-replag-days' => 'giorni',
	'toolbase-replag-hours' => 'ore',
	'toolbase-replag-minutes' => 'minuti',
	'toolbase-replag-seconds' => 'secondi',
	'toolbase-footer-exectime' => 'Eseguito in $1 secondi',
	'toolbase-footer-source' => 'Visualizza sorgente',
	'toolbase-footer-language' => 'Cambia lingua',
	'toolbase-footer-translate' => 'Traduci',
	'toolbase-navigation' => 'Navigazione',
	'toolbase-navigation-homepage' => 'Pagina principale',
	'toolbase-navigation-user_id' => 'Cercare un utente',
	'toolbase-navigation-autoedits' => 'Contatore di modifiche automatico',
	'toolbase-autoedits-totalall' => 'Totale delle modifiche',
	'toolbase-main-404' => 'File non trovato',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'toolbase-navigation' => 'ការណែនាំ',
);

/** Colognian (Ripoarisch)
 * @author Rentenirer
 */
$messages['ksh'] = array(
	'toolbase-main-title' => 'Wellkumme!',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'toolbase-replag-years' => 'sal',
	'toolbase-replag-months' => 'meh',
	'toolbase-replag-weeks' => 'hefte',
	'toolbase-replag-hours' => 'saet',
	'toolbase-replag-minutes' => 'xulek',
	'toolbase-replag-seconds' => 'çirke',
	'toolbase-footer-source' => 'Çavkaniyê bibîne',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'toolbase-header-title' => 'Dem X! seng Tools (BETA)',
	'toolbase-header-bugs' => 'Softwarefeeler (Bugs)',
	'toolbase-header-sitenotice' => "'Global Toolserver' Notiz vum Site: $1",
	'toolbase-replag' => 'De Retard vum Server ass $1',
	'toolbase-replag-years' => 'Joer',
	'toolbase-replag-months' => 'Méint',
	'toolbase-replag-weeks' => 'Wochen',
	'toolbase-replag-days' => 'Deeg',
	'toolbase-replag-hours' => 'Stonnen',
	'toolbase-replag-minutes' => 'Minutten',
	'toolbase-replag-seconds' => 'Sekonnen',
	'toolbase-footer-exectime' => 'A(n) $1 {{PLURAL:$1|Sekonn|Sekonnen}} ofgeschloss',
	'toolbase-footer-source' => 'Quellcode weisen',
	'toolbase-footer-language' => 'Sprooch wiesselen',
	'toolbase-footer-translate' => 'Iwwersetzen',
	'toolbase-navigation' => 'Navigatioun',
	'toolbase-navigation-homepage' => 'Haaptsäit',
	'toolbase-navigation-user_id' => 'Benotzer ID fannen',
	'toolbase-navigation-autoedits' => 'Automatesche Compteur vun Ännerungen',
	'toolbase-userid-submit' => 'Benotzer ID ufroen',
	'toolbase-userid-title' => 'Eng Benotzer ID fannen',
	'toolbase-userid-result' => 'D\'Benotzer ID fir <b>$1</b> op <a href="$3"><b>$3</b></a> ass <b>$2</b>.',
	'toolbase-autoedits-title' => 'Automatesch Rechemaschinn vun den Ännerungen',
	'toolbase-autoedits-submit' => 'Rechnen',
	'toolbase-autoedits-approximate' => '<b>Ongeféier</b> Zuel vun Ännerunge mat …',
	'toolbase-autoedits-totalauto' => 'Total vun den automateschen Ännerungen',
	'toolbase-autoedits-totalall' => 'Total vun den Ännerungen',
	'toolbase-autoedits-pct' => 'Prozentsaz vun den automateschen Ännerungen',
	'toolbase-main-title' => 'Wëllkomm!',
	'toolbase-main-content' => 'Wëllkomm beim X! sengen Toolen!

D\'Sammlung vun den Toole gi fir de <a href="$1">Symfony</a>-Framework adaptéiert. Dat dauert zwar e bësse, awer elo misst et goen!

Eng Lëscht vun den Toolen déi elo mat deem Framework fonctionnéieren, kuckt an déi riets Säiteläischt.

Feeler kënnen op <a href="$2">Google Code</a> gemellt ginn.',
	'toolbase-main-404' => 'Fichier gouf net fonnt',
	'toolbase-main-404-content' => 'Oups! Et gouf keng Säit fonnt!

Vergewëssert Iech datt Dir déi richteg URL aginn hutt.
Wann Dir op e Link geklickt hutt, da <a href="$1">mellt de Feeler</a> w.e.g.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '"$1" ass kee gültege Benotzernumm',
	'toolbase-error-nowiki' => '$1.$2.org ass keng valabel Wiki',
	'toolbase-error-toomanyedits' => 'De Benotzer $1 huet $2 Ännerungen. Dësen Tool huet maximal $3 Ännerungen.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'toolbase-header-title' => 'Алатки на X!',
	'toolbase-header-bugs' => 'Грешки',
	'toolbase-header-twitter' => 'Twitter',
	'toolbase-header-sitenotice' => 'Глобално известување на Toolserver: $1',
	'toolbase-replag' => 'Опслужувачот изостанува $1',
	'toolbase-replag-years' => 'години',
	'toolbase-replag-months' => 'месеци',
	'toolbase-replag-weeks' => 'недели',
	'toolbase-replag-days' => 'дена',
	'toolbase-replag-hours' => 'часа',
	'toolbase-replag-minutes' => 'минути',
	'toolbase-replag-seconds' => 'секунди',
	'toolbase-footer-exectime' => 'Извршено за $1 секунди',
	'toolbase-footer-source' => 'Извор',
	'toolbase-footer-language' => 'Смени јазик',
	'toolbase-footer-translate' => 'Преведи',
	'toolbase-navigation' => 'Навигација',
	'toolbase-navigation-homepage' => 'Домашна страница',
	'toolbase-navigation-api' => 'API',
	'toolbase-navigation-user_id' => 'Пронајди кориснички ID',
	'toolbase-navigation-autoedits' => 'Бројач на автоматизирани уредувања',
	'toolbase-userid-submit' => 'Дај кориснички ID',
	'toolbase-userid-title' => 'Пронаоѓање на кориснички ID',
	'toolbase-userid-result' => 'Корисничкиот ID за <b>$1</b> на <a href="$3"><b>$3</b></a> е <b>$2</b>.',
	'toolbase-autoedits-title' => 'Пресметувач на автоматизирани уредувања',
	'toolbase-autoedits-submit' => 'Пресметај',
	'toolbase-autoedits-approximate' => '<b>Приближен</b> број на уредувања со помош на....',
	'toolbase-autoedits-totalauto' => 'Вкупно автоматизирани уредувања',
	'toolbase-autoedits-totalall' => 'Вкупно уредувања',
	'toolbase-autoedits-pct' => 'Постоток на автоматизирани уредувања',
	'toolbase-main-title' => 'Добредојдовте!',
	'toolbase-main-content' => 'Добредојдовте на Алатките на X!! Овој комплет алатки е сè уште во фаза на претворање во склопот на <a href="$1">Symfony</a>. Оваа постапка може да потрае, но веќе би требало да работи. 

Ако сакате да погледате список на алатките што моментално работат во овој склоп, погледајте во алатникот десно.

Грешките можете да ги пријавувате на <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Податотеката не е пронајдена',
	'toolbase-main-404-content' => 'Упс! Не пронајдов ниедна страница!

Проверете дали исправно сте ја внеле URL-адресата.
Ако тука дојдовте преку врска од некое друго место, тогаш <a href="$1">пријавете ја оваа грешка</a>.
</ul>',
	'toolbase-form-wiki' => 'Вики',
	'toolbase-error-nouser' => 'Нема корисник по име $1',
	'toolbase-error-nowiki' => '$1.$2.org не претставува важечко вики',
	'toolbase-error-toomanyedits' => '$1 има $2 уредувања. Оваа алатка има максимум од $3 уредувања.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'toolbase-replag-years' => 'år',
	'toolbase-replag-months' => 'måneder',
	'toolbase-replag-weeks' => 'uker',
	'toolbase-replag-days' => 'dager',
	'toolbase-replag-hours' => 'timer',
	'toolbase-replag-minutes' => 'minutter',
	'toolbase-replag-seconds' => 'sekunder',
	'toolbase-footer-exectime' => 'Utført på $1 sekunder',
	'toolbase-footer-source' => 'Vis kilde',
	'toolbase-footer-language' => 'Endre språk',
	'toolbase-footer-translate' => 'Oversett',
	'toolbase-navigation' => 'Navigasjon',
	'toolbase-navigation-homepage' => 'Hjemmeside',
	'toolbase-navigation-user_id' => 'Finn bruker-ID',
	'toolbase-userid-submit' => 'Hent bruker-ID',
	'toolbase-userid-title' => 'Finn en bruker-ID',
	'toolbase-autoedits-submit' => 'Kalkuler',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 er ikke en gyldig bruker',
	'toolbase-error-nowiki' => '$1.$2.org er ikke en gyldig wiki',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'toolbase-header-title' => "Hulpprogramma's van X (beta)",
	'toolbase-header-bugs' => 'Bugs',
	'toolbase-header-sitenotice' => 'Globale sitenotice van toolserver: $1',
	'toolbase-replag' => 'Synchronisatieachterstand: $1',
	'toolbase-replag-years' => 'jaar',
	'toolbase-replag-months' => 'maanden',
	'toolbase-replag-weeks' => 'weken',
	'toolbase-replag-days' => 'dagen',
	'toolbase-replag-hours' => 'uur',
	'toolbase-replag-minutes' => 'minuten',
	'toolbase-replag-seconds' => 'seconden',
	'toolbase-footer-exectime' => 'Uitgevoerd in $1 seconden',
	'toolbase-footer-source' => 'Broncode bekijken',
	'toolbase-footer-language' => 'Taal wijzigen',
	'toolbase-footer-translate' => 'Vertalen',
	'toolbase-navigation' => 'Navigatie',
	'toolbase-navigation-homepage' => 'Startpagina',
	'toolbase-navigation-user_id' => 'Gebruikersnummer zoeken',
	'toolbase-navigation-autoedits' => 'Geautomatiseerde bewerkingsteller',
	'toolbase-userid-submit' => 'Gebruikersnummer ophalen',
	'toolbase-userid-title' => 'Gebruikersnummer zoeken',
	'toolbase-userid-result' => 'Het gebruikersnummer voor <b>$1</b> op <a href="$3"><b>$3</b></a> is <b>$2</b>.',
	'toolbase-autoedits-title' => 'Geautomatiseerde bewerkingsteller',
	'toolbase-autoedits-submit' => 'Berekenen',
	'toolbase-autoedits-approximate' => '<b>Benadering</b> van het aantal bewerkingen met...',
	'toolbase-autoedits-totalauto' => 'Totaal aantal geautomatiseerde bewerkingen',
	'toolbase-autoedits-totalall' => 'Totaal aantal bewerkingen',
	'toolbase-autoedits-pct' => 'Percentage geautomatiseerde bewerkingen',
	'toolbase-main-title' => 'Welkom!',
	'toolbase-main-content' => 'Welkom bij de hulpprogramma\'s van X. Deze verzameling hulpprogramma\'s wordt nog steeds omgezet naar het framework <a href="$1">Symfony</a>. Dit gaat nog enige tijd duren, maar alle programma\'s zouden nu moeten werken.

In de menubalk aan de rechterzijde ziet u een lijst met programma\'s die nu al van het framework gebruik maken.

U kunt problemen melden in <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Bestand niet gevonden',
	'toolbase-main-404-content' => 'De pagina is niet gevonden.

Zorg dat u een correcte URL hebt ingevoerd.
Als u een verwijzing ergens anders vandaan hebt gevolgd, <a href="$1">meld dan alstublieft een probleem aan</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 is geen geldige gebruiker',
	'toolbase-error-nowiki' => '$1.$2.org is geen geldige wiki',
	'toolbase-error-toomanyedits' => '$1 heeft $2 bewerkingen gemaakt. Dit hulpprogramma heeft een maximum van $3 bewerkingen.',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'toolbase-header-bugs' => 'ବଗସବୁ',
	'toolbase-replag-years' => 'ବର୍ଷ',
	'toolbase-replag-months' => 'ମାସ',
	'toolbase-replag-weeks' => 'ସପ୍ତାହ',
	'toolbase-replag-days' => 'ଦିନ',
	'toolbase-replag-hours' => 'ଘଣ୍ଟା',
	'toolbase-replag-minutes' => 'ମିନିଟ',
	'toolbase-replag-seconds' => 'ସେକେଣ୍ଡ',
	'toolbase-footer-language' => 'ଭାଷା ବଦଳାନ୍ତୁ',
	'toolbase-footer-translate' => 'ଅନୁବାଦ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'toolbase-header-title' => 'X!s Gscharr',
	'toolbase-replag-years' => 'Yaahre',
	'toolbase-replag-months' => 'Munete',
	'toolbase-replag-weeks' => 'Woche',
	'toolbase-replag-days' => 'Daage',
	'toolbase-replag-hours' => 'Schtunde',
	'toolbase-main-title' => 'Wilkum!',
	'toolbase-form-wiki' => 'Wiki',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'toolbase-header-title' => 'Narzędzia X! (BETA)',
	'toolbase-header-bugs' => 'Błędy',
	'toolbase-header-sitenotice' => 'Globalny komunikat serwera narzędziowego: $1',
	'toolbase-replag' => 'Serwer jest opóźniony o $1',
	'toolbase-replag-years' => 'lat',
	'toolbase-replag-months' => 'miesięcy',
	'toolbase-replag-weeks' => 'tygodni',
	'toolbase-replag-days' => 'dni',
	'toolbase-replag-hours' => 'godzin',
	'toolbase-replag-minutes' => 'minut',
	'toolbase-replag-seconds' => 'sekund',
	'toolbase-footer-exectime' => 'Wykonano w $1 {{PLURAL:$1|sekundę|sekundy|sekund}}',
	'toolbase-footer-source' => 'Tekst źródłowy',
	'toolbase-footer-language' => 'Zmień język',
	'toolbase-footer-translate' => 'Przetłumacz',
	'toolbase-navigation' => 'Nawigacja',
	'toolbase-navigation-homepage' => 'Strona domowa',
	'toolbase-navigation-user_id' => 'Znajdź identyfikator użytkownika',
	'toolbase-userid-submit' => 'Pobierz identyfikator użytkownika',
	'toolbase-userid-title' => 'Znajdź identyfikator użytkownika',
	'toolbase-userid-result' => 'Identyfikator użytkownika dla <b>$1</b> na <a href="$3"><b>$3</b></a> to <b>$2</b>.',
	'toolbase-autoedits-submit' => 'Oblicz',
	'toolbase-autoedits-totalall' => 'Łącznie wszystkich edycji',
	'toolbase-autoedits-pct' => 'Procent edycji automatycznych',
	'toolbase-main-title' => 'Witaj!',
	'toolbase-main-content' => 'Witamy w zestawie narzędzi X! Pakiet narzędzi jest nadal konwertowany do pracy w ramach <href="$1">Symfony</a>. Proces ten jest czasochłonny, ale narzędzia powinny działać już teraz.

Lista narzędzi, które są obecnie uruchomione dostępna jest w pasku bocznym po prawej.

Błędy można zgłaszać poprzez <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Nie odnaleziono pliku',
	'toolbase-main-404-content' => 'Oj! Nie odnaleziono strony!

Upewnij się, że wpisałeś poprawny adres URL.
Jeśli dotarłeś tu klikając jakiś link <a href="$1">zgłoś błąd</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '„$1” nie jest poprawną nazwą użytkownika',
	'toolbase-error-nowiki' => '$1.$2.org nie jest poprawnym adresem wiki',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'toolbase-replag-years' => 'کالونه',
	'toolbase-replag-months' => 'مياشتې',
	'toolbase-replag-weeks' => 'اونۍ',
	'toolbase-replag-days' => 'ورځې',
	'toolbase-replag-hours' => 'ساعتونه',
	'toolbase-replag-minutes' => 'دقيقې',
	'toolbase-replag-seconds' => 'ثانيې',
	'toolbase-footer-language' => 'ژبه بدلول',
	'toolbase-footer-translate' => 'ژباړل',
	'toolbase-navigation-homepage' => 'وېبپاڼه',
	'toolbase-autoedits-submit' => 'شمېرل',
	'toolbase-main-title' => 'ښه راغلاست!',
	'toolbase-form-wiki' => 'ويکي',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'toolbase-header-title' => "Ferramentas X!'s (BETA)",
	'toolbase-header-bugs' => 'Defeitos',
	'toolbase-header-sitenotice' => 'Anúncio Global do Servidor de Ferramentas: $1',
	'toolbase-replag' => 'Servidor com atraso de $1',
	'toolbase-replag-years' => 'anos',
	'toolbase-replag-months' => 'meses',
	'toolbase-replag-weeks' => 'semanas',
	'toolbase-replag-days' => 'dias',
	'toolbase-replag-hours' => 'horas',
	'toolbase-replag-minutes' => 'minutos',
	'toolbase-replag-seconds' => 'segundos',
	'toolbase-footer-exectime' => 'Executado em $1 segundos',
	'toolbase-footer-source' => 'Ver código fonte',
	'toolbase-footer-language' => 'Alterar língua',
	'toolbase-footer-translate' => 'Traduzir',
	'toolbase-navigation' => 'Navegação',
	'toolbase-navigation-homepage' => 'Início',
	'toolbase-navigation-user_id' => 'Pesquisar ID de utilizador',
	'toolbase-navigation-autoedits' => 'Contador de edições automatizadas',
	'toolbase-userid-submit' => 'Obter ID de utilizador',
	'toolbase-userid-title' => 'Pesquisar uma identificação de utilizador',
	'toolbase-userid-result' => 'A identificação de utilizador para <b>$1</b> em <a href="$3"><b>$3</b></a> é <b>$2</b>.',
	'toolbase-autoedits-title' => 'Calculadora de edições automatizadas',
	'toolbase-autoedits-submit' => 'Calcular',
	'toolbase-autoedits-approximate' => 'Número <b>aproximado</b> de edições usando...',
	'toolbase-autoedits-totalauto' => 'Número total de edições automatizadas',
	'toolbase-autoedits-totalall' => 'Número total de edições',
	'toolbase-autoedits-pct' => 'Percentagem de edições automatizadas',
	'toolbase-main-title' => 'Bem-vindo(a)!',
	'toolbase-main-content' => 'Bem-vindo às ferramentas X!\'s! Este conjunto de ferramentas ainda está a ser convertido para o modelo <a href="$1">Symfony</a>. O processo de conversão demorará algum tempo, mas já deve estar a funcionar.

Na barra lateral à direita encontra uma lista das ferramentas que já se encontram operacionais neste modelo.

Os defeitos podem ser reportados em <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'O ficheiro não foi encontrado',
	'toolbase-main-404-content' => 'A página não foi encontrada!

Certifique-se de que a URL está correcta.
Se chegou cá a partir de um link <a href="$1">reporte este defeito</a>, por favor.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 não é um utilizador válido',
	'toolbase-error-nowiki' => '$1.$2.org não é uma wiki válida',
	'toolbase-error-toomanyedits' => '$1 tem $2 edições. Esta ferramenta tem um máximo de $3 edições.',
);

/** Russian (Русский)
 * @author Askarmuk
 * @author Haffman
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'toolbase-header-bugs' => 'Ошибки',
	'toolbase-replag-years' => 'годы',
	'toolbase-replag-months' => 'месяцы',
	'toolbase-replag-weeks' => 'недели',
	'toolbase-replag-days' => 'дней',
	'toolbase-replag-hours' => 'часов',
	'toolbase-replag-minutes' => 'минут',
	'toolbase-replag-seconds' => 'секунд',
	'toolbase-footer-exectime' => 'Выполнено за $1 секунд',
	'toolbase-footer-source' => 'Исходный код',
	'toolbase-footer-language' => 'Изменить язык',
	'toolbase-footer-translate' => 'Перевести',
	'toolbase-navigation-homepage' => 'Домашняя страница',
	'toolbase-navigation-user_id' => 'Найти ID участника',
	'toolbase-userid-submit' => 'Получить ID участника',
	'toolbase-userid-title' => 'Найти ID участника',
	'toolbase-autoedits-totalauto' => 'Общее количество автоматизированных правок',
	'toolbase-autoedits-totalall' => 'Общее количество правок',
	'toolbase-autoedits-pct' => '% количества автоматизированных правок',
	'toolbase-main-title' => 'Добро пожаловать!',
	'toolbase-main-404' => 'Файл не найден',
	'toolbase-main-404-content' => 'Упс! Страница не найдена!

Проверьте, что вы правильно ввели адрес URL в адресной строке браузера.
Если вы перешли по ссылке с какого-то места, то, пожалуйста, <a href="$1">сообщите об ошибке</a>.
</ul>',
	'toolbase-form-wiki' => 'wiki',
	'toolbase-error-nouser' => 'Участник $1 не существует',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'toolbase-header-title' => 'Orodja X! (BETA)',
	'toolbase-header-bugs' => 'Hrošči',
	'toolbase-header-sitenotice' => 'Globalno obvestilo strani Toolserver: $1',
	'toolbase-replag' => 'Strežnik zaostaja za $1',
	'toolbase-replag-years' => 'let',
	'toolbase-replag-months' => 'mesecev',
	'toolbase-replag-weeks' => 'tednov',
	'toolbase-replag-days' => 'dni',
	'toolbase-replag-hours' => 'ur',
	'toolbase-replag-minutes' => 'minut',
	'toolbase-replag-seconds' => 'sekund',
	'toolbase-footer-exectime' => 'Izvedeno v $1 sekundah',
	'toolbase-footer-source' => 'Ogled izvorne kode',
	'toolbase-footer-language' => 'Spremeni jezik',
	'toolbase-footer-translate' => 'Prevedi',
	'toolbase-navigation' => 'Navigacija',
	'toolbase-navigation-homepage' => 'Domača stran',
	'toolbase-navigation-user_id' => 'Najdi ID uporabnika',
	'toolbase-navigation-autoedits' => 'Števec samodejnih urejanj',
	'toolbase-userid-submit' => 'Dobi ID uporabnika',
	'toolbase-userid-title' => 'Najdi ID uporabnika',
	'toolbase-userid-result' => 'ID uporabnika za <b>$1</b> na <a href="$3"><b>$3</b></a> je <b>$2</b>.',
	'toolbase-autoedits-title' => 'Računalo samodejnih urejanj',
	'toolbase-autoedits-submit' => 'Izračunaj',
	'toolbase-autoedits-approximate' => '<b>Oceni</b> število urejanj z uporabo ...',
	'toolbase-autoedits-totalauto' => 'Skupno število avtomatiziranih urejanj',
	'toolbase-autoedits-totalall' => 'Skupno število urejanj',
	'toolbase-autoedits-pct' => 'Odstotek avtomatiziranih urejanj',
	'toolbase-main-title' => 'Dobrodošli!',
	'toolbase-main-content' => 'Dobrodošli v orodjih X! Zbirka orodij je še vedno v postopku pretvorbe v ogrodje <a href="$1">Symfony</a>. Postopek bo trajal še nekaj časa, vendar bi zdaj orodja morala delovati.

Za seznam orodij, ki trenutno tečejo na tem ogrodju, si oglejte stransko vrstico na desni strani.

Poročila o hroščih lahko vložite v <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Datoteke ni mogoče najti',
	'toolbase-main-404-content' => 'Ups! Najdena ni bila nobena stran!

Prepričajte se, da ste pravilno vnesli URL.
Če ste od nekod sledili povezavi, prosimo, <a href="$1">vložite poročilo o hrošču</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 ni veljaven uporabnik',
	'toolbase-error-nowiki' => '$1.$2.org ni veljaven wiki',
	'toolbase-error-toomanyedits' => '$1 ima $2 urejanj. To orodje ima zgornjo mejo $3 urejanj.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'toolbase-header-twitter' => 'Твитер',
	'toolbase-navigation-api' => 'АПИ',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'toolbase-header-twitter' => 'Tviter',
	'toolbase-navigation-api' => 'API',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'toolbase-header-title' => 'X!s verktyg (BETA)',
	'toolbase-header-bugs' => 'Buggar',
	'toolbase-header-sitenotice' => 'Global Toolserver Sitenotice: $1',
	'toolbase-replag' => 'Server släpat med $1',
	'toolbase-replag-years' => 'år',
	'toolbase-replag-months' => 'månader',
	'toolbase-replag-weeks' => 'veckor',
	'toolbase-replag-days' => 'dagar',
	'toolbase-replag-hours' => 'timmar',
	'toolbase-replag-minutes' => 'minuter',
	'toolbase-replag-seconds' => 'sekunder',
	'toolbase-footer-exectime' => 'Utfördes på $1 sekunder',
	'toolbase-footer-source' => 'Visa källa',
	'toolbase-footer-language' => 'Ändra språk',
	'toolbase-footer-translate' => 'Översätt',
	'toolbase-navigation' => 'Navigation',
	'toolbase-navigation-homepage' => 'Hemsida',
	'toolbase-navigation-user_id' => 'Hitta användar-ID',
	'toolbase-navigation-autoedits' => 'Automatiserad redigeringsräknare',
	'toolbase-userid-submit' => 'Skaffa användar-ID',
	'toolbase-userid-title' => 'Hitta ett användar-ID',
	'toolbase-autoedits-title' => 'Automatiserad redigeringskalkylator',
	'toolbase-autoedits-submit' => 'Beräkna',
	'toolbase-autoedits-approximate' => '<b>Ungefärligt</b> antal ändringar med hjälp av ...',
	'toolbase-autoedits-totalauto' => 'Totalt antal automatiserade redigeringar',
	'toolbase-autoedits-totalall' => 'Totalt antal redigeringar',
	'toolbase-autoedits-pct' => 'Procent av automatiserade redigeringar',
	'toolbase-main-title' => 'Välkommen!',
	'toolbase-main-404' => 'Filen hittades inte',
	'toolbase-main-404-content' => 'Hoppsan! Ingen sida hittades!

Kontrollera att du skrivit in adressen korrekt.
Om du följde en länk från någonstans, var god <a href="$1">skicka en buggrapport</a>.',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '$1 är inte ett giltigt användarnamn',
	'toolbase-error-nowiki' => '$1.$2.org är inte en giltig wiki',
	'toolbase-error-toomanyedits' => '$1 har $2 redigeringar. Detta verktyg har ett maximum på $3 redigeringar.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'toolbase-replag-years' => 'సంవత్సరాలు',
	'toolbase-replag-months' => 'నెలలు',
	'toolbase-replag-weeks' => 'వారాలు',
	'toolbase-replag-days' => 'రోజులు',
	'toolbase-replag-hours' => 'గంటలు',
	'toolbase-replag-minutes' => 'నిమిషాలు',
	'toolbase-replag-seconds' => 'క్షణాలు',
	'toolbase-footer-language' => 'భాషని ఎంచుకోండి',
	'toolbase-footer-translate' => 'అనువదించండి',
	'toolbase-main-title' => 'స్వాగతం!',
	'toolbase-form-wiki' => 'వికీ',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'toolbase-header-title' => 'Mga Kasangkapan ng X! (BETA)',
	'toolbase-header-bugs' => 'Mga sira',
	'toolbase-header-sitenotice' => 'Pandaigdigang Pabatid Pampook ng Toolserver: $1',
	'toolbase-replag' => 'Pagkaiwan ng tagapaghain sa pamamagitan ng $1',
	'toolbase-replag-years' => 'mga taon',
	'toolbase-replag-months' => 'mga buwan',
	'toolbase-replag-weeks' => 'mga linggo',
	'toolbase-replag-days' => 'mga araw',
	'toolbase-replag-hours' => 'mga oras',
	'toolbase-replag-minutes' => 'mga minuto',
	'toolbase-replag-seconds' => 'mga segundo',
	'toolbase-footer-exectime' => 'Naisakatuparan sa loob ng $1 mga segundo',
	'toolbase-footer-source' => 'Tingnan ang pinagmulan',
	'toolbase-footer-language' => 'Baguhin ang wika',
	'toolbase-footer-translate' => 'Isalinwika',
	'toolbase-navigation' => 'Paglilibot',
	'toolbase-navigation-homepage' => 'Bahay-pahina',
	'toolbase-navigation-user_id' => 'Hanapin ang ID ng tagagamit',
	'toolbase-navigation-autoedits' => 'Kusang pambilang ng pamamatnugot',
	'toolbase-userid-submit' => 'Kuhanin ang ID ng tagagamit',
	'toolbase-userid-title' => 'Maghanap ng isang ID ng tagagamit',
	'toolbase-userid-result' => 'Ang ID ng tagagamit para sa <b>$1</b> sa <a href="$3"><b>$3</b></a> ay <b>$2</b>.',
	'toolbase-autoedits-title' => 'Kusang tagapagtuos ng pamamatnugot',
	'toolbase-autoedits-submit' => 'Tuusin',
	'toolbase-autoedits-approximate' => '<b>Tinatayang</b> bilang ng mga pamamatnugot na ginagamit ang...',
	'toolbase-autoedits-totalauto' => 'Kabuuang bilang ng kusang mga pamamatnugot',
	'toolbase-autoedits-totalall' => 'Kabuuang bilang ng pamamatnugot',
	'toolbase-autoedits-pct' => 'Bahagdan ng awtomatikong mga pamamatnugot',
	'toolbase-main-title' => 'Maligayang pagdating!',
	'toolbase-main-content' => 'Maligayang pagdating sa mga kasangkapan ng X! Ang silid ng kasangkapan ay nasa proseso pa rin ng pagiging pagpapalit papunta sa balangkas ng <a href="$1">Symfony</a>. Ang prosesong ito ay magiging may katagalan, subalit dapat na itong gumana.

Para sa isang talaan ng mga kasangkapan na pangkasalukuyang tumatakbo na ngayon sa balangkas na ito, tingnan ang ang panggilid na halang na nasa kanan.

Maiuulat ang mga sira doon sa <a href="$2">Kodigo ng Google</a>.',
	'toolbase-main-404' => 'Hindi natagpuan ang talaksan',
	'toolbase-main-404-content' => 'Naku! Walang natagpuang pahina!

Tiyaking tinipa mo ang tamang URL.
Kung sinundan mo ang isang kawing mula sa ibang lugar, mangyaring <a href="$1">mag-ulat ng isang sira</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => 'Hindi isang katanggap-tanggap na tagagamit si $1',
	'toolbase-error-nowiki' => 'Hindi katanggap-tanggap na wiki ang $1.$2.org',
	'toolbase-error-toomanyedits' => 'Si $1 ay may $2 mga pamamatnugot. Ang kasangkapang ito ay may pinakamataas na $3 ng mga pamamatnugot.',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'toolbase-header-bugs' => 'Помилки',
	'toolbase-replag-years' => 'роки',
	'toolbase-replag-months' => 'місяці',
	'toolbase-replag-weeks' => 'тижня',
	'toolbase-replag-days' => 'дні',
	'toolbase-replag-hours' => 'години',
	'toolbase-replag-minutes' => 'хвилин',
	'toolbase-replag-seconds' => 'секунд',
	'toolbase-footer-source' => 'Переглянути код',
	'toolbase-footer-language' => 'Змінити мову',
	'toolbase-footer-translate' => 'Перекласти',
	'toolbase-navigation' => 'Навігація',
	'toolbase-navigation-homepage' => 'Домашня сторінка',
	'toolbase-main-title' => 'Ласкаво просимо!',
	'toolbase-main-404' => 'Файл не знайдено',
	'toolbase-main-404-content' => 'Отакої! Сторінку не знайдено!

Переконайтеся, що ви набрали URL правильно.
Якщо ви перейшли за посиланням звідки-небудь, будь ласка, <a href="$1">повідомте про помилку</a>.
</ul>',
	'toolbase-form-wiki' => 'Вікі',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'toolbase-header-title' => 'Các công cụ của X (BETA)',
	'toolbase-header-bugs' => 'Lỗi',
	'toolbase-header-sitenotice' => 'Thông báo toàn cầu Toolserver: $1',
	'toolbase-replag' => 'Máy chủ chậm $1',
	'toolbase-replag-years' => 'năm',
	'toolbase-replag-months' => 'tháng',
	'toolbase-replag-weeks' => 'tuần',
	'toolbase-replag-days' => 'ngày',
	'toolbase-replag-hours' => 'giờ',
	'toolbase-replag-minutes' => 'phút',
	'toolbase-replag-seconds' => 'giây',
	'toolbase-footer-exectime' => 'Thực hiện trong $1 giây',
	'toolbase-footer-source' => 'Xem mã nguồn',
	'toolbase-footer-language' => 'Thay đổi ngôn ngữ',
	'toolbase-footer-translate' => 'Biên dịch',
	'toolbase-navigation' => 'Xem nhanh',
	'toolbase-navigation-homepage' => 'Trang đầu',
	'toolbase-navigation-user_id' => 'Tìm ID người dùng',
	'toolbase-navigation-autoedits' => 'Trình đếm sửa đổi tự động',
	'toolbase-userid-submit' => 'Tìm ID người dùng',
	'toolbase-userid-title' => 'Tìm ID người dùng',
	'toolbase-userid-result' => 'ID của người dùng <b>$1</b> tại <a href="$3"><b>$3</b></a> là <b>$2</b>.',
	'toolbase-autoedits-title' => 'Trình đếm sửa đổi tự động',
	'toolbase-autoedits-submit' => 'Tính',
	'toolbase-autoedits-approximate' => '<b>Ước tính</b> số lần sửa đổi dùng…',
	'toolbase-autoedits-totalauto' => 'Tổng số sửa đổi tự động',
	'toolbase-autoedits-totalall' => 'Tổng số sửa đổi',
	'toolbase-autoedits-pct' => 'Tỷ lệ sửa đổi tự động',
	'toolbase-main-title' => 'Hoan nghênh!',
	'toolbase-main-content' => 'Hoan nghênh bạn đã đến với các công cụ của X! Bộ công cụ này vẫn đang được chuyển qua khuôn khổ <a href="$1">Symfony</a>. Quá trình này chưa xong nhưng có lẽ đã hoạt động.

Xem các công cụ đang hoạt động tốt trên khuôn khổ này trong thanh bên.

Có thể báo cáo lỗi tại <a href="$2">Google Code</a>.',
	'toolbase-main-404' => 'Không tìm thấy tập tin',
	'toolbase-main-404-content' => 'Oái! Không tìm thấy tập tin!

Hãy xem lại URL có đúng hay không.
Nếu bạn theo một liên kết từ trang khác, xin vui lòng <a href="$1">báo cáo lỗi</a>.
</ul>',
	'toolbase-form-wiki' => 'Wiki',
	'toolbase-error-nouser' => '“$1” không phải là người dùng hợp lệ',
	'toolbase-error-nowiki' => '“$1.$2.org” không phải là wiki hợp lệ',
	'toolbase-error-toomanyedits' => '$1 đã sửa đổi $2 lần. Công cụ này chỉ có xử lý được tối đa $3 sửa đổi.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'toolbase-header-title' => 'X!的工具（测试版）',
	'toolbase-header-bugs' => '臭虫',
	'toolbase-header-sitenotice' => '全域Toolserver站点通告：$1',
	'toolbase-replag' => '服务器延迟$1',
	'toolbase-replag-years' => '年',
	'toolbase-replag-months' => '月',
	'toolbase-replag-weeks' => '周',
	'toolbase-replag-days' => '天',
	'toolbase-replag-hours' => '小时',
	'toolbase-replag-minutes' => '分钟',
	'toolbase-replag-seconds' => '秒',
	'toolbase-footer-exectime' => '在$1秒内执行完成',
	'toolbase-footer-source' => '查看源码',
	'toolbase-footer-language' => '选择语言',
	'toolbase-footer-translate' => '翻译',
	'toolbase-navigation' => '导航',
	'toolbase-navigation-homepage' => '首页',
	'toolbase-navigation-user_id' => '查找用户ID',
	'toolbase-navigation-autoedits' => '自动编辑计数器',
	'toolbase-userid-submit' => '获取用户ID',
	'toolbase-userid-title' => '查找用户ID',
	'toolbase-userid-result' => '<a href="$3"><b>$3</b></a>上的用户<b>$1</b>ID为<b>$2</b>。',
	'toolbase-autoedits-title' => '自动编辑计算器',
	'toolbase-autoedits-submit' => '计算',
	'toolbase-main-title' => '欢迎！',
	'toolbase-main-404' => '找不到档案',
	'toolbase-form-wiki' => '维基',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'toolbase-header-title' => 'X!的工具（測試版）',
	'toolbase-header-bugs' => '臭蟲',
	'toolbase-header-sitenotice' => '全域Toolserver站點通告：$1',
	'toolbase-replag' => '服務器延遲$1',
	'toolbase-replag-years' => '年',
	'toolbase-replag-months' => '月',
	'toolbase-replag-weeks' => '周',
	'toolbase-replag-days' => '天',
	'toolbase-replag-hours' => '小時',
	'toolbase-replag-minutes' => '分鐘',
	'toolbase-replag-seconds' => '秒',
	'toolbase-footer-exectime' => '在$1秒內執行完成',
	'toolbase-footer-source' => '檢視原始碼',
	'toolbase-footer-language' => '選擇語言',
	'toolbase-footer-translate' => '翻譯',
	'toolbase-navigation' => '導覽',
	'toolbase-navigation-homepage' => '首頁',
	'toolbase-navigation-user_id' => '尋找使用者 ID',
	'toolbase-navigation-autoedits' => '自動編輯計數器',
	'toolbase-userid-submit' => '取得使用者 ID',
	'toolbase-userid-title' => '尋找使用者 ID',
	'toolbase-userid-result' => '<a href="$3"><b>$3</b></a>上的用戶<b>$1</b>ID為<b>$2</b>。',
	'toolbase-autoedits-title' => '自動編輯計算器',
	'toolbase-autoedits-submit' => '計算',
	'toolbase-main-title' => '歡迎！',
	'toolbase-main-404' => '找不到檔案',
	'toolbase-form-wiki' => 'Wiki',
);

