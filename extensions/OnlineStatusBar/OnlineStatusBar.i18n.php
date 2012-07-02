<?php
/**
 * Internationalisation file for Online status bar extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/**
 * English
 * @author Petr Bena
 * @author John Du Hart
 */
$messages['en'] = array(
	// Description 
	'onlinestatusbar-desc' => 'Status bar which shows whether a user is online, based on preferences, on their user page',
	// Status bar text line (User is now Offline) etc.
	'onlinestatusbar-line' => '$1 is now $2 $3',
	// Message in config asking user if they want to enable it
	'onlinestatusbar-used' => 'Display your online status on your user pages',
	// Message in config for amount of time after which user is away
	'onlinestatusbar-away-time' => 'How many minutes until you are marked as away:',
	// Message in config asking what status they want to use
	'onlinestatusbar-status' => 'What is the default status you wish to use:',
	// Message in config about away time
	'onlinestatusbar-away' => 'Treat as away automatically after defined interval',
	// Message in config asking if user wants to purge the user page
	'onlinestatusbar-purge' => 'Purge user page everytime when you login or logout',
	// Section for config
	'prefs-onlinestatus' => 'Online status',
	// Message in config
	'onlinestatusbar-hide' => 'Hide the status bar on user pages in order to use just the magic word (For advanced users)',
	'onlinestatusbar-status-online' => 'On-line',
	'onlinestatusbar-status-busy' => 'Busy',
	'onlinestatusbar-status-away' => 'Away',
	'onlinestatusbar-status-offline' => 'Offline',
	'onlinestatusbar-status-uknown' => 'status is unknown',
	'onlinestatusbar-status-hidden' => 'Hidden',
);

/** Message documentation (Message documentation)
 * @author John Du Hart
 * @author Petr Bena
 */
$messages['qqq'] = array(
	'onlinestatusbar-desc' => '{{desc}}',
	'onlinestatusbar-line' => 'Status bar text line (User is now Offline), parameters:
* $1 is user
* $2 is a picture of status (small icon in color of status)
* $3 a status, it will appear in title bar of their user space pages',
	'onlinestatusbar-used' => 'Message in config asking user if they want to enable it, checkbox',
	'onlinestatusbar-away-time' => 'Question in preferences asking user how many minutes to wait until he would be flagged as away',
	'onlinestatusbar-status' => 'Message in config asking what status they want to use, option box',
	'onlinestatusbar-away' => 'Time in minutes how long to wait until user is flagged as away',
	'onlinestatusbar-purge' => 'Option to purge user page everytime they login so that magic word is updated',
	'prefs-onlinestatus' => 'Section for config, located in preferences - misc',
	'onlinestatusbar-hide' => 'Ask user if they want to hide status bar this is useful when they are using custom template but need to check if they are online',
	'onlinestatusbar-status-online' => 'Status for users who mark themselves as active',
	'onlinestatusbar-status-busy' => 'Status for users who mark themselves as busy',
	'onlinestatusbar-status-away' => 'Status for users who mark themselves as away',
	'onlinestatusbar-status-offline' => 'Status for users who are offline',
	'onlinestatusbar-status-unknown' => 'When error occur for instance you retrieve status of user who changed options to hide it',
	'onlinestatusbar-status-hidden' => 'Status for users who mark themselves as hidden (used on preferences only)',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'onlinestatusbar-line' => '$1 zo bremañ $2 $3',
	'prefs-onlinestatus' => 'Statud enlinenn',
	'onlinestatusbar-status-online' => 'Kevreet',
	'onlinestatusbar-status-busy' => 'Soulgarget',
	'onlinestatusbar-status-away' => 'Er-maez',
	'onlinestatusbar-status-offline' => 'Ezvezant',
	'onlinestatusbar-status-hidden' => 'Kuzhet',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'onlinestatusbar-desc' => 'Ermöglicht, abhängig von der Benutzereinstellung, die Anzeige des Onlinestatus eines Benutzers auf dessen Benutzerseite',
	'onlinestatusbar-line' => '$1 ist gerade $3 $2',
	'onlinestatusbar-used' => 'Deinen Online-Status auf deiner Benutzerseite anzeigen',
	'onlinestatusbar-away-time' => 'Minuten, die vergehen sollen, um als „abwesend“ eingestuft zu werden:',
	'onlinestatusbar-status' => 'Welchen Status möchtest du standardmäßig nutzen:',
	'onlinestatusbar-away' => 'Nach einem festgelegten Zeitraum automatisch als „abwesend“ einstufen',
	'onlinestatusbar-purge' => 'Den Cache der Benutzerseite jedes Mal leeren, wenn du dich an- oder abmeldest',
	'prefs-onlinestatus' => 'Onlinestatus',
	'onlinestatusbar-hide' => "Die Statusleiste auf Benutzerseiten ausblenden, um stattdessen lediglich das ''magische Wort'' zu nutzen? (Für fortgeschrittene Benutzer)",
	'onlinestatusbar-status-online' => 'Online',
	'onlinestatusbar-status-busy' => 'Beschäftigt',
	'onlinestatusbar-status-away' => 'Abwesend',
	'onlinestatusbar-status-offline' => 'Offline',
	'onlinestatusbar-status-uknown' => 'Status ist unbekannt',
	'onlinestatusbar-status-hidden' => 'Versteckt',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'onlinestatusbar-used' => 'Ihren Online-Status auf Ihrer Benutzerseite anzeigen',
	'onlinestatusbar-status' => 'Welchen Status möchten Sie standardmäßig nutzen:',
	'onlinestatusbar-purge' => 'Den Cache der Benutzerseite jedes Mal leeren, wenn Sie sich an- oder abmelden',
	'onlinestatusbar-hide' => "Möchten Sie die Statusleiste ausblenden, um stattdessen lediglich das ''magische Wort'' zu nutzen? (Für Fortgeschrittene)",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'onlinestatusbar-desc' => 'Statusowa kšoma, kótaraž pokazujo na zakłaźe nastajenjow na wužywarskem boku, lěc wužywaŕ jo online',
	'onlinestatusbar-line' => '$1 jo něnto $3 $2',
	'onlinestatusbar-used' => 'Twój onlinestatus na twójich wužywarskich bokach pokazaś',
	'onlinestatusbar-away-time' => 'Licba minutow, nježli až maš se ako "njepśibytny" markěrowaś:',
	'onlinestatusbar-status' => 'Standardny status, kótaryž coš wužywaś:',
	'onlinestatusbar-away' => 'Pó póstajonem interwalu awtomatiski za "njeśibytny" měś',
	'onlinestatusbar-purge' => 'Cache wužywarskego boka kuždy raz wuprozniś, gaž se pśizjawjaš abo wótzjawjaš',
	'prefs-onlinestatus' => 'Onlinestatus',
	'onlinestatusbar-hide' => 'Statusowu kšomu na wužywarskich bokach schowaś, aby se jano magiske słowo wužywało (za pókšacanych wužywarjow)',
	'onlinestatusbar-status-online' => 'Online',
	'onlinestatusbar-status-busy' => 'Zabrany',
	'onlinestatusbar-status-away' => 'Njepśibytny',
	'onlinestatusbar-status-offline' => 'Offline',
	'onlinestatusbar-status-uknown' => 'status jo njeznaty',
	'onlinestatusbar-status-hidden' => 'Schowany',
);

/** French (Français)
 * @author Crochet.david
 * @author DavidL
 * @author Gomoko
 * @author Verdy p
 * @author Zebulon84
 */
$messages['fr'] = array(
	'onlinestatusbar-desc' => "Barre d'état montrant si un utilisateur est en ligne, basé sur les préférences, sur leur page utilisateur",
	'onlinestatusbar-line' => '$1 est maintenant $2 $3',
	'onlinestatusbar-used' => 'Afficher votre statut en ligne sur vos pages utilisateur',
	'onlinestatusbar-away-time' => 'Combien minutes avant de changer le status en "absent" :',
	'onlinestatusbar-status' => 'Quel est le statut par défaut que vous souhaitez utiliser :',
	'onlinestatusbar-away' => 'Status "absent" automatique',
	'onlinestatusbar-purge' => 'Vider la page utilisateur chaque vous que vous vous connectez ou vous déconnectez',
	'prefs-onlinestatus' => 'État en ligne',
	'onlinestatusbar-hide' => "Masquer la barre d'état sur les pages d'utilisateur afin d'utiliser le mot magique seulement (pour les utilisateurs avancés)",
	'onlinestatusbar-status-online' => 'Présent',
	'onlinestatusbar-status-busy' => 'Occupé',
	'onlinestatusbar-status-away' => 'Parti',
	'onlinestatusbar-status-offline' => 'Absent',
	'onlinestatusbar-status-uknown' => 'statut inconnu',
	'onlinestatusbar-status-hidden' => 'Masqué',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'onlinestatusbar-line' => '$1 est ora $2 $3',
	'prefs-onlinestatus' => 'Ètat en legne',
	'onlinestatusbar-status-online' => 'Present',
	'onlinestatusbar-status-busy' => 'Ocupo',
	'onlinestatusbar-status-away' => 'Viâ',
	'onlinestatusbar-status-offline' => 'Absent',
	'onlinestatusbar-status-hidden' => 'Cachiê',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'onlinestatusbar-desc' => 'Barra de estado que mostra na páxina de usuario se un usuario está conectado',
	'onlinestatusbar-line' => '$1 está $2 $3 nestes intres',
	'onlinestatusbar-used' => 'Mostrar se está conectado nas súas páxinas de usuario',
	'onlinestatusbar-away-time' => 'Os minutos que deben pasar ata considerar que marchou:',
	'onlinestatusbar-status' => 'O estado por defecto que quere usar:',
	'onlinestatusbar-away' => 'Considerar automaticamente que marchou despois do intervalo definido',
	'onlinestatusbar-purge' => 'Purgar a páxina de usuario cada vez que se identifique ou saia do sistema',
	'prefs-onlinestatus' => 'Conectado',
	'onlinestatusbar-hide' => 'Agochar a barra de estado nas páxinas de usuario para usar unicamente a palabra máxica (para usuarios avanzados)',
	'onlinestatusbar-status-online' => 'Conectado',
	'onlinestatusbar-status-busy' => 'Ocupado',
	'onlinestatusbar-status-away' => 'Non dispoñible',
	'onlinestatusbar-status-offline' => 'Desconectado',
	'onlinestatusbar-status-uknown' => 'descoñécese o estado',
	'onlinestatusbar-status-hidden' => 'Agochado',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'onlinestatusbar-desc' => 'שורת מצב שמציגה בדף המשתמש אם המשתמש מקוון, בהתאם להעדפות',
	'onlinestatusbar-line' => '$1 $2 $3 עכשיו',
	'onlinestatusbar-used' => 'לאפשר לאחרים לראות שאתם מחוברים?',
	'onlinestatusbar-away-time' => 'אחרי כמה לסמך אותך בתור "לא נמצא":',
	'onlinestatusbar-status' => 'מהו המצב שתרצו להיות פה לפי בררת המחדל:',
	'onlinestatusbar-away' => 'להתייחס באופן אוטומטי כאלה "לא נמצא" אחרי פרק זמן מוגדר',
	'onlinestatusbar-purge' => 'לנקות את המטמון של דף המשתמש בכל פעם שאתם נכנסים או יוצאים',
	'prefs-onlinestatus' => 'מצב ההימצאות באתר',
	'onlinestatusbar-hide' => 'להסתיר את שורת המצב כדי להשתמש רק במילת הקסם (למשתמשים מתקדמים)',
	'onlinestatusbar-status-online' => 'באתר',
	'onlinestatusbar-status-busy' => 'עסוק',
	'onlinestatusbar-status-away' => 'לא ליד מחשב',
	'onlinestatusbar-status-offline' => 'לא באתר',
	'onlinestatusbar-status-uknown' => 'המצב אינו ידוע',
	'onlinestatusbar-status-hidden' => 'מוסתר',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'onlinestatusbar-desc' => 'Statusowa lajsta, kotraž na zakładźe nastajenjow pokazuje, hač wužiwar je na swojej wužiwarskej stronje online',
	'onlinestatusbar-line' => '$1 je nětko $3 $2',
	'onlinestatusbar-used' => 'Waš onlinestatus na wašich wužiwarskich stronach pokazać',
	'onlinestatusbar-away-time' => 'Ličba mjeńšin, prjedy hač maće so jako "njepřitomny" markěrować:',
	'onlinestatusbar-status' => 'Što je standardny status, kotryž chceće wužiwać:',
	'onlinestatusbar-away' => 'Po postajenym interwalu awtomatisce za "njepřitomny" měć',
	'onlinestatusbar-purge' => 'Pufrowak wužiwarskeje strony kóždy raz wuprózdnić, hdyž so přizjewješ abo wotzjewješ',
	'prefs-onlinestatus' => 'Onlinestatus',
	'onlinestatusbar-hide' => 'Statusowu lajstu na wužiwarskich stronach schować, zo by so jenož magiske słowo wužiwało (za pokročenych wužiwarjow)',
	'onlinestatusbar-status-online' => 'Online',
	'onlinestatusbar-status-busy' => 'Ma dźěło',
	'onlinestatusbar-status-away' => 'Preč',
	'onlinestatusbar-status-offline' => 'Offline',
	'onlinestatusbar-status-uknown' => 'status je njeznaty',
	'onlinestatusbar-status-hidden' => 'Schowany',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'onlinestatusbar-desc' => 'Barra de stato que monstra si un usator es in linea, dependente de su preferentias, in su pagina de usator',
	'onlinestatusbar-line' => '$1 es ora $2 $3',
	'onlinestatusbar-used' => 'Monstrar si tu es in linea in tu pagina de usator',
	'onlinestatusbar-away-time' => 'Quante minutas ante que tu es marcate como absente:',
	'onlinestatusbar-status' => 'Qual es le stato predefinite que tu vole usar:',
	'onlinestatusbar-away' => 'Tractar automaticamente como absente post un intervallo definite',
	'onlinestatusbar-purge' => 'Purgar le pagina de usator cata vice que tu aperi o claude session',
	'prefs-onlinestatus' => 'Stato in linea',
	'onlinestatusbar-hide' => 'Celar le barra de stato in paginas de usator pro usar solmente le parola magic (Pro usatores avantiate)',
	'onlinestatusbar-status-online' => 'In linea',
	'onlinestatusbar-status-busy' => 'Occupate',
	'onlinestatusbar-status-away' => 'Absente',
	'onlinestatusbar-status-offline' => 'Foras de linea',
	'onlinestatusbar-status-uknown' => 'stato es incognite',
	'onlinestatusbar-status-hidden' => 'Celate',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'onlinestatusbar-line' => '$1 ass elo $2 $3',
	'onlinestatusbar-used' => 'Ären online-Status op Ärer Benotzer-Säit weisen',
	'onlinestatusbar-away-time' => "Minutte bis Dir als 'net do' markéiert gitt:",
	'onlinestatusbar-status-busy' => 'Beschäftegt',
	'onlinestatusbar-status-away' => 'Net do',
	'onlinestatusbar-status-uknown' => 'Status onbekannt',
	'onlinestatusbar-status-hidden' => 'Verstoppt',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'onlinestatusbar-desc' => 'Статусник што прикажува дали корисникот е на линија, зависно од нагодувањата на корисничката страница',
	'onlinestatusbar-line' => '$1 сега е $2 $3',
	'onlinestatusbar-used' => 'Прикажувај на моите кориснички страници кога сум на линија',
	'onlinestatusbar-away-time' => 'По колку минути да се прикаже „отсутен“:',
	'onlinestatusbar-status' => 'Вашиот статус по основно:',
	'onlinestatusbar-away' => 'Сметај ме за отсутен по извесно зададено време',
	'onlinestatusbar-purge' => 'Пречисти го кешот на корисничката страница секојпат кога ќе се најавам или одјавам',
	'prefs-onlinestatus' => 'Вклученост',
	'onlinestatusbar-hide' => 'Скриј го статусникот за да го користам само волшебниот збор (за напредни корисници)',
	'onlinestatusbar-status-online' => 'Вклучен',
	'onlinestatusbar-status-busy' => 'Зафатен',
	'onlinestatusbar-status-away' => 'Отсутен',
	'onlinestatusbar-status-offline' => 'Исклучен',
	'onlinestatusbar-status-uknown' => 'статусот е непознат',
	'onlinestatusbar-status-hidden' => 'Скриен',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'onlinestatusbar-desc' => 'Palang status yang menunjukkan sama pengguna berada dalam talian atau tidak, berasaskan keutamaan pada laman penggunanya',
	'onlinestatusbar-line' => '$1 kini $2 $3',
	'onlinestatusbar-used' => 'Paparkan status online anda pada laman-laman pengguna anda',
	'onlinestatusbar-away-time' => 'Berapa minit sehingga anda dianggap tiada:',
	'onlinestatusbar-status' => 'Yang manakah status asali yang ingin anda gunakan:',
	'onlinestatusbar-away' => 'Anggap sebagai tiada sebagai automatik selepas tempoh yang ditetapkan',
	'onlinestatusbar-purge' => 'Singkirkan isi laman pengguna setiap kali ketika log masuk/keluar',
	'prefs-onlinestatus' => 'Status dalam talian',
	'onlinestatusbar-hide' => 'Sorokkan palang status di laman pengguna untuk menggunakan kata sakti sahaja (Untuk pengguna yang lebih berpengalaman)',
	'onlinestatusbar-status-online' => 'Dalam talian',
	'onlinestatusbar-status-busy' => 'Sibuk',
	'onlinestatusbar-status-away' => 'Tiada',
	'onlinestatusbar-status-offline' => 'Luar talian',
	'onlinestatusbar-status-hidden' => 'Tersorok',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'onlinestatusbar-desc' => 'Statusbalk die weergeeft of een gebruiker online is, op basis van voorkeuren, op zijn/haar gebruikerspagina',
	'onlinestatusbar-line' => '$1 is nu $2 $3',
	'onlinestatusbar-used' => "Uw onlinestatus weergeven op uw gebruikerspagina's",
	'onlinestatusbar-away-time' => 'Aantal minuten totdat u als weg gemarkeerd wordt:',
	'onlinestatusbar-status' => 'Welke standaard status wilt u gebruiken:',
	'onlinestatusbar-away' => 'Automatisch als weg markeren na een bepaalde interval',
	'onlinestatusbar-purge' => 'Uw gebruikerspagina bij aanmelden en afmelden uit de cache verwijderen',
	'prefs-onlinestatus' => 'Onlinestatus',
	'onlinestatusbar-hide' => "De statusbalk op gebruikerpagina's verbergen en alleen het magische woord gebruiken (voor geavanceerde gebruikers)",
	'onlinestatusbar-status-online' => 'Online',
	'onlinestatusbar-status-busy' => 'Druk',
	'onlinestatusbar-status-away' => 'Weg',
	'onlinestatusbar-status-offline' => 'Offline',
	'onlinestatusbar-status-uknown' => 'status is onbekend',
	'onlinestatusbar-status-hidden' => 'Verborgen',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author Vvk.pentapati
 */
$messages['te'] = array(
	'onlinestatusbar-line' => '$1 ippudu $2 $3',
	'onlinestatusbar-used' => 'మీరు ఆన్‌లైనులో ఉన్నట్టు ఇతరులుకు చూపించాలా?',
);

