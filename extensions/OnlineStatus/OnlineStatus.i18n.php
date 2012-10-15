<?php
/**
 * Internationalisation file for extension UserStatus.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'onlinestatus-desc' => 'Add a preference to show if the user is currently present or not on the wiki',
	'onlinestatus-js-anon' => 'Error: you must be logged in to use this feature',
	'onlinestatus-js-changed' => 'Your status has been changed to "$1"',
	'onlinestatus-js-error' => 'Impossible to change status, value "$1" is invalid',
	'onlinestatus-levels' => '* online
* offline', // Do not translate this message
	'onlinestatus-subtitle-offline' => 'This user is currently offline',
	'onlinestatus-subtitle-online' => 'This user is currently online',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Your status:',
	'onlinestatus-toggles-explain' => 'This allows you to show to other users if you are actually online or not by viewing your user page.',
	'onlinestatus-toggles-show' => 'Show online status on my user page',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Change my status to online when logging-in',
	'onlinestatus-pref-offlineonlogout' => 'Change my status to offline when logging-out',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author EugeneZelenko
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'onlinestatus-desc' => '{{desc}}',
	'onlinestatus-subtitle-offline' => 'Parameters:
* $1 can be used for GENDER support.',
	'onlinestatus-subtitle-online' => 'Parameters:
* $1 can be used for GENDER support.',
	'onlinestatus-tab' => '{{Identical|Status}}',
	'onlinestatus-toggles-desc' => '{{Identical|Status}}',
	'onlinestatus-toggles-show' => 'Toggle in [[Special:Preferences|preferences]]. {{Gender}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'onlinestatus-subtitle-offline' => 'Hierdie gebruiker is aflyn',
	'onlinestatus-subtitle-online' => 'Hierdie gebruiker is aanlyn',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'U status:',
	'onlinestatus-toggle-offline' => 'Aflyn',
	'onlinestatus-toggle-online' => 'Aanlyn',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'onlinestatus-desc' => 'Shto një preferencë për të treguar nëse përdoruesi është aktualisht i pranishëm ose jo në wiki',
	'onlinestatus-js-anon' => 'Gabim: ju duhet të keni hyrë brenda për të përdorur këtë veçori',
	'onlinestatus-js-changed' => 'Gjendja juaj është ndryshuar për "$1"',
	'onlinestatus-js-error' => 'Pamundur për të ndryshuar statusin, vlerë "$1" është i pavlefshëm',
	'onlinestatus-subtitle-offline' => 'Ky përdorues është offline',
	'onlinestatus-subtitle-online' => 'Ky përdorues është aktualisht online',
	'onlinestatus-tab' => 'Statusi',
	'onlinestatus-toggles-desc' => 'Statusi i juaj:',
	'onlinestatus-toggles-explain' => 'Kjo ju lejon të treguar përdoruesve të tjerë nëse jeni të vërtetë online apo jo duke shfletuar faqen tuaj të përdoruesit.',
	'onlinestatus-toggles-show' => 'Gjendja Trego online në faqen time përdorues',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Ndryshimi statusin tim në internet kur të hyni në',
	'onlinestatus-pref-offlineonlogout' => 'Ndryshimi statusin tim të fundit kur hyni-out',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'onlinestatus-desc' => 'يضيف تفضيلا لعرض ما إذا كان المستخدم موجود حاليا أم لا على الويكي',
	'onlinestatus-js-anon' => 'خطأ: يجب أن تكون مسجل الدخول لاستخدام هذه الميزة',
	'onlinestatus-js-changed' => 'حالتك تم تغييرها إلى "$1"',
	'onlinestatus-js-error' => 'مستحيل أن يتم تغيير الحالة، القيمة "$1" غير صحيحة',
	'onlinestatus-subtitle-offline' => 'هذا المستخدم غير متصل حاليا',
	'onlinestatus-subtitle-online' => 'هذا المستخدم متصل حاليا',
	'onlinestatus-tab' => 'حالة',
	'onlinestatus-toggles-desc' => 'حالتك:',
	'onlinestatus-toggles-explain' => 'هذا يسمح لك بالعرض للمستخدمين الآخرين إذا ما كنت موجودا أم لا بواسطة رؤية صفحة مستخدمك.',
	'onlinestatus-toggles-show' => 'اعرض حالتي على الإنترنت على صفحة مستخدمي',
	'onlinestatus-toggle-offline' => 'غير متصل',
	'onlinestatus-toggle-online' => 'متصل',
	'onlinestatus-pref-onlineonlogin' => 'غير حالتي إلى موجود عند تسجيل الدخول',
	'onlinestatus-pref-offlineonlogout' => 'غير حالتي إلى غير موجود عند تسجيل الخروج',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author 334a
 * @author Basharh
 */
$messages['arc'] = array(
	'onlinestatus-subtitle-offline' => 'ܡܦܠܚܢܐ ܗܢܐ ܠܐ ܨܡܝܕܐ ܗܘ ܗܫܐ',
	'onlinestatus-subtitle-online' => 'ܡܦܠܚܢܐ ܗܢܐ ܨܡܝܕܐ ܗܘ ܗܫܐ',
	'onlinestatus-tab' => 'ܐܝܟܢܝܘܬܐ',
	'onlinestatus-toggles-desc' => 'ܐܝܟܢܝܘܬܐ ܕܝܠܟ:',
	'onlinestatus-toggle-offline' => 'ܠܐ ܨܡܝܕܐ',
	'onlinestatus-toggle-online' => 'ܨܡܝܕܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'onlinestatus-desc' => 'يضيف تفضيلا لعرض ما إذا كان المستخدم موجود حاليا أم لا على الويكي',
	'onlinestatus-js-anon' => 'خطأ: يجب أن تكون مسجل الدخول لاستخدام هذه الميزة',
	'onlinestatus-js-changed' => 'حالتك تم تغييرها إلى "$1"',
	'onlinestatus-js-error' => 'مستحيل أن يتم تغيير الحالة، القيمة "$1" غير صحيحة',
	'onlinestatus-subtitle-offline' => 'هذا المستخدم غير متصل حاليا',
	'onlinestatus-subtitle-online' => 'هذا المستخدم متصل حاليا',
	'onlinestatus-tab' => 'حالة',
	'onlinestatus-toggles-desc' => 'حالتك:',
	'onlinestatus-toggles-explain' => 'ده يسمح لك بالعرض لليوزرز التانين إذا ما كنت موجود أو مش موجود بواسطة رؤية صفحة يوزرك.',
	'onlinestatus-toggles-show' => 'اعرض حالتى على الإنترنت على صفحة يوزرى',
	'onlinestatus-toggle-offline' => 'غير متصل',
	'onlinestatus-toggle-online' => 'متصل',
	'onlinestatus-pref-onlineonlogin' => 'غير حالتى إلى موجود عند تسجيل الدخول',
	'onlinestatus-pref-offlineonlogout' => 'غير حالتى إلى غير موجود عند تسجيل الخروج',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'onlinestatus-tab' => 'Status',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'onlinestatus-desc' => 'Дадае налады для паказу, ці прысутнічае ўдзельнік у {{GRAMMAR:месны|{{SITENAME}}}}, ці не',
	'onlinestatus-js-anon' => 'Памылка: Вам неабходна увайсьці ў сыстэму, каб выкарыстоўваць гэтую магчымасьць',
	'onlinestatus-js-changed' => 'Ваш статус быў зьменены на «$1»',
	'onlinestatus-js-error' => 'Немагчыма зьмяніць статус, няслушнае значэньне «$1»',
	'onlinestatus-subtitle-offline' => 'Гэтага ўдзельніка зараз няма ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'onlinestatus-subtitle-online' => 'Гэты ўдзельнік зараз у {{GRAMMAR:месны|{{SITENAME}}}}',
	'onlinestatus-tab' => 'Статус',
	'onlinestatus-toggles-desc' => 'Ваш статус:',
	'onlinestatus-toggles-explain' => 'Дазваляе іншым удзельнікам, якія наведваюць Вашу старонку, даведацца, ці Вы зараз у {{GRAMMAR:месны|{{SITENAME}}}} ці не.',
	'onlinestatus-toggles-show' => 'Паказаць маю прысутнасьць на маёй старонцы ўдзельніка',
	'onlinestatus-toggle-offline' => 'Няма ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'onlinestatus-toggle-online' => 'У {{GRAMMAR:месны|{{SITENAME}}}}',
	'onlinestatus-pref-onlineonlogin' => 'Зьмяняць мой статус на «у {{GRAMMAR:месны|{{SITENAME}}}}» пры ўваходзе ў сыстэму',
	'onlinestatus-pref-offlineonlogout' => 'Зьмяняць мой статус на «няма ў {{GRAMMAR:месны|{{SITENAME}}}}» пры выхадзе з сыстэмы',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'onlinestatus-desc' => 'Добавя настройка, която показва дали потребителят е на линия или не в уикито',
	'onlinestatus-js-anon' => 'Грешка: за използване на тази възможност е необходимо влизане в системата',
	'onlinestatus-subtitle-offline' => 'Този потребител в момента не е на линия',
	'onlinestatus-subtitle-online' => 'Този потребител в момента е на линия',
	'onlinestatus-tab' => 'Статут',
	'onlinestatus-toggles-desc' => 'Вашият статут:',
	'onlinestatus-toggles-explain' => 'Това позволява да показвате на другите потребители, които разглеждат потребителската ви страница, дали сте действително на линия или не.',
	'onlinestatus-toggles-show' => 'Показване на статута ми на потребителската ми страница',
	'onlinestatus-toggle-offline' => 'Извън линия',
	'onlinestatus-toggle-online' => 'На линия',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'onlinestatus-subtitle-online' => 'এই ব্যবহারকারী বর্তমানে অনলাইনে আছেন',
	'onlinestatus-tab' => 'অবস্থা',
	'onlinestatus-toggles-desc' => 'আপনার অবস্থান:',
	'onlinestatus-toggle-offline' => 'অফলাইন',
	'onlinestatus-toggle-online' => 'অনলাইন',
	'onlinestatus-pref-onlineonlogin' => 'প্রবেশের পর আমার অবস্থা অনলাইনে পরিবর্তন করো',
	'onlinestatus-pref-offlineonlogout' => 'প্রস্থানের পর আমার অবস্থা অফলাইনে পরিবর্তন করো',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'onlinestatus-desc' => 'Ouzhpennañ a ra un arventenn da ziskouez hag-eñ emañ kevreet an implijer pe get',
	'onlinestatus-js-anon' => "Fazi : ret eo deoc'h bezañ kevreet evit gellout implijout an arc'hweladur-mañ",
	'onlinestatus-js-changed' => 'Cheñchet eo bet ho statud da « $1 »',
	'onlinestatus-js-error' => 'Diposupl eo cheñch ar statud, n\'eo ket mat an dalvoudenn "$1"',
	'onlinestatus-subtitle-offline' => 'Ezlinenn eo an implijer-mañ evit bremañ',
	'onlinestatus-subtitle-online' => 'Enlinenn eo an implijer-mañ evit bremañ',
	'onlinestatus-tab' => 'Statud',
	'onlinestatus-toggles-desc' => 'Ho statud :',
	'onlinestatus-toggles-explain' => "Talvezout a ra deoc'h da ziskouez d'an implijerien all hag-eñ emaoc'h enlinenn pe get en ur sellet ouzh ho pajenn implijer.",
	'onlinestatus-toggles-show' => 'Diskouez ma statud war ma fajenn implijer',
	'onlinestatus-toggle-offline' => 'Ezvezant',
	'onlinestatus-toggle-online' => 'Kevreet',
	'onlinestatus-pref-onlineonlogin' => 'Kemmañ ma statud da enlinenn pa gevrean',
	'onlinestatus-pref-offlineonlogout' => 'Kemmañ ma statud da ezlinenn pa zigevrean',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'onlinestatus-desc' => 'Dodaje preference za prikaz da li je korisnik trenutno prijavljen na wiki ili ne',
	'onlinestatus-js-anon' => 'Greška: morate biti prijavljeni da bi ste koristili ovu mogućnost',
	'onlinestatus-js-changed' => 'Vaš status je promijenjen na "$1"',
	'onlinestatus-js-error' => 'Nemoguće je promijeniti status, vrijednost "$1" nije valjana',
	'onlinestatus-subtitle-offline' => '{{GENDER:|Ovaj korisnik|Ova korisnica}} je trenutno van mreže',
	'onlinestatus-subtitle-online' => '{{GENDER:|Ovaj korisnik|Ova korisnica}} je trenutno na mreži',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Vaš status:',
	'onlinestatus-toggles-explain' => 'Ovo Vam omogućuje da na Vašoj korisničkoj stranici prikaže drugim korisnicima da li ste prijavljeni ili ne.',
	'onlinestatus-toggles-show' => 'Prikaži status na mreži na mojoj korisničkoj stranici',
	'onlinestatus-toggle-offline' => 'Van mreže',
	'onlinestatus-toggle-online' => 'Na mreži',
	'onlinestatus-pref-onlineonlogin' => "Promijeni moj status na ''na mreži'' pri prijavi",
	'onlinestatus-pref-offlineonlogout' => "Promijeni moj status na ''van mreže'' pri odjavi",
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'onlinestatus-desc' => "Afegeix una preferència per a mostrar si l'usuari actualment està present al wiki o no ho està",
	'onlinestatus-js-anon' => "Error: cal que tingueu un compte d'usuari per a utilitzar aquesta funció",
	'onlinestatus-js-changed' => "El vostre estat s'ha canviat a «$1»",
	'onlinestatus-js-error' => "Impossible canviar d'estat, el valor «$1» no és vàlid",
	'onlinestatus-subtitle-offline' => 'Actualment aquest usuari no està connectat',
	'onlinestatus-subtitle-online' => 'Actualment aquest usuari està connectat',
	'onlinestatus-tab' => 'Estatus',
	'onlinestatus-toggles-desc' => 'El vostre estat:',
	'onlinestatus-toggles-explain' => "Us permet mostrar a la resta d'usuaris si us trobeu connectats al wiki.",
	'onlinestatus-toggles-show' => "Mostra l'estat de connexió a la pàgina d'usuari",
	'onlinestatus-toggle-offline' => 'Desconnectat',
	'onlinestatus-toggle-online' => 'Connectat',
	'onlinestatus-pref-onlineonlogin' => 'Canvia el meu estat a «en línia» en iniciar sessió',
	'onlinestatus-pref-offlineonlogout' => 'Canvia el meu estat a «fora de línia» quan finalitzi la sessió',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'onlinestatus-desc' => 'Přidá možnost zobrazovat, zda je uživatel na wiki momentálně přítomný nebo ne',
	'onlinestatus-js-anon' => 'Chyba: K využívání této funkce musíte být přihlášeni',
	'onlinestatus-js-changed' => 'Váš stav byl změněn na „$1“',
	'onlinestatus-js-error' => 'Nebylo možné změnit stav, hodnota „$1“ je neplatná',
	'onlinestatus-subtitle-offline' => 'Tento uživatel je momentálně odpojený',
	'onlinestatus-subtitle-online' => 'Tento uživatel je momentálně připojený',
	'onlinestatus-tab' => 'Stav',
	'onlinestatus-toggles-desc' => 'Váš stav:',
	'onlinestatus-toggles-explain' => 'Toto Vám umožní zobrazovat na vaší uživatelské stránce ostatním uživatelům, zda jste ve skutečnosti připojen nebo ne.',
	'onlinestatus-toggles-show' => 'Zobrazovat můj stav na mojí uživatelské stránce',
	'onlinestatus-toggle-offline' => 'Odpojený',
	'onlinestatus-toggle-online' => 'Připojený',
	'onlinestatus-pref-onlineonlogin' => 'Změnit po přihlášení můj stav na „online“',
	'onlinestatus-pref-offlineonlogout' => 'Změnit po odhlášení můj stav na „offline“',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'onlinestatus-desc' => "Yn gosod dewisiad i arddangos a yw defnyddiwr wedi mewngofnodi i'r wici ar hyn o bryd ai pheidio",
	'onlinestatus-js-anon' => "Gwall: rhaid mewngofnodi cyn gallu defnyddio'r nodwedd hon",
	'onlinestatus-js-changed' => 'Mae\'ch cyflwr wedi ei newid i "$1"',
	'onlinestatus-js-error' => 'Nid yw\'n bosib newid cyflwr, mae\'r gwerth "$1" yn annilys',
	'onlinestatus-subtitle-offline' => "Nid yw'r defnyddiwr hwn ar-lein ar hyn o bryd",
	'onlinestatus-subtitle-online' => "Mae'r defnyddiwr hwn ar-lein ar hyn o bryd",
	'onlinestatus-tab' => 'Cyflwr',
	'onlinestatus-toggles-desc' => 'Eich cyflwr:',
	'onlinestatus-toggles-explain' => "Mae hwn yn rhoi'r gallu i chi i arddangos ar eich tudalen defnyddiwr eich cyflwr arlein/all-lein.",
	'onlinestatus-toggles-show' => 'Dangos fy nghylwr ar/all-lein ar fy nhudalen defnyddiwr',
	'onlinestatus-toggle-offline' => 'All-lein',
	'onlinestatus-toggle-online' => 'Ar-lein',
	'onlinestatus-pref-onlineonlogin' => 'Newid nodyn fy nghyflwr i ar-lein wrth fewngofnodi',
	'onlinestatus-pref-offlineonlogout' => 'Newid nodyn fy nghyflwr i all-lein wrth allgofnodi',
);

/** Danish (Dansk)
 * @author Amjaabc
 */
$messages['da'] = array(
	'onlinestatus-desc' => "Angiver ønsker til visning, hvis brugeren for øjeblikket er til stede eller ikke på wiki'en",
	'onlinestatus-js-anon' => 'Fejl: Du skal være logget ind for at bruge denne facilitet',
	'onlinestatus-js-changed' => 'Din status er skiftet til "$1"',
	'onlinestatus-js-error' => 'Ikke muligt at skifte tilstand, værdien "$1" er ikke gyldig',
	'onlinestatus-subtitle-offline' => 'Brugeren er ikke logget ind i øjeblikket',
	'onlinestatus-subtitle-online' => 'Brugeren er logget ind',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Din status:',
	'onlinestatus-toggles-explain' => 'Dette gør det muligt for dig at tillade andre brugere at se, om du er logget ind eller ikke, ved at se på din brugerside.',
	'onlinestatus-toggles-show' => 'Vis på min brugerside, om jeg er logget ind eller ikke',
	'onlinestatus-toggle-offline' => 'Ikke logget ind',
	'onlinestatus-toggle-online' => 'Logget ind',
	'onlinestatus-pref-onlineonlogin' => 'Skift min status til logget ind, når jeg logger ind',
	'onlinestatus-pref-offlineonlogout' => 'Skift min status til ikke logget ind, når jeg logger ud',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'onlinestatus-desc' => 'Ergänzt eine Option zur Anzeige des Online-Status in den persönlichen Einstellungen',
	'onlinestatus-js-anon' => 'Fehler: Du musst angemeldet sein, um diese Funktion nutzen zu können',
	'onlinestatus-js-changed' => 'Dein Status wurde in „$1“ geändert',
	'onlinestatus-js-error' => 'Statusänderung nicht möglich, der Wert „$1“ ist ungültig',
	'onlinestatus-subtitle-offline' => 'Dieser Benutzer ist gegenwärtig offline',
	'onlinestatus-subtitle-online' => 'Dieser Benutzer ist gegenwärtig online',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Dein Status:',
	'onlinestatus-toggles-explain' => 'Diese Einstellung ermöglicht dir, anderen Benutzern auf deiner Benutzerseite zu zeigen, ob du online oder offline bist.',
	'onlinestatus-toggles-show' => 'Zeige Onlinestatus auf meiner Benutzerseite',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Status auf online ändern, sobald ich mich anmelde',
	'onlinestatus-pref-offlineonlogout' => 'Status auf offline ändern, wenn ich mich abmelde',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 */
$messages['de-formal'] = array(
	'onlinestatus-js-anon' => 'Fehler: Sie müssen angemeldet sein, um diese Funktion nutzen zu können',
	'onlinestatus-js-changed' => 'Ihr Status wurde in „$1“ geändert',
	'onlinestatus-toggles-desc' => 'Ihr Status:',
	'onlinestatus-toggles-explain' => 'Diese Einstellung ermöglicht Ihnen, anderen Benutzern auf Ihrer Benutzerseite zu zeigen, ob Sie online oder offline sind.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'onlinestatus-desc' => 'Preferencu pśidaś, aby se pokazało, jolic wužywaŕ jo tuchylu na wikiju pśibytny abo nic',
	'onlinestatus-js-anon' => 'Zmólka: musyš byś píszjawjony, aby wužywał toś tu funkciju',
	'onlinestatus-js-changed' => 'Twój status jo se změnił do "$1"',
	'onlinestatus-js-error' => 'Změnjenje statusa njejo móžno, gódnota "$1" jo njepłaśiwa',
	'onlinestatus-subtitle-offline' => 'Toś ten wužywaŕ jo tuchylu offline',
	'onlinestatus-subtitle-online' => 'Toś ten wužywaŕ jo tuchylu online',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Twój status:',
	'onlinestatus-toggles-explain' => 'Toś to nastajenje śi dowólujo, drugim wužywarjam na twójom wužywarskim boku pokazaś, lěc sy tuchylu online abo nic.',
	'onlinestatus-toggles-show' => 'Status online na mójom wužywarskim boku pokazaś',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Status pśi pśizjawjenju do online změniś',
	'onlinestatus-pref-offlineonlogout' => 'Status pśi wótzjawjenju do offline změniś',
);

/** Greek (Ελληνικά)
 * @author Dada
 * @author ZaDiak
 */
$messages['el'] = array(
	'onlinestatus-js-anon' => 'Σφάλμα: πρέπει να είστε συνδεδεμένοι για να χρησιμοποιήσετε αυτή τη δυνατότητα',
	'onlinestatus-js-changed' => 'Η κατάστασή σας έχει αλλάξει σε "$1"',
	'onlinestatus-subtitle-offline' => 'Αυτός ο χρήστης είναι τώρα εκτός σύνδεσης',
	'onlinestatus-subtitle-online' => 'Αυτός ο χρηστής είναι εντός σύνδεσης',
	'onlinestatus-tab' => 'Κατάσταση',
	'onlinestatus-toggles-desc' => 'Η κατάστασή σας:',
	'onlinestatus-toggles-show' => 'Εμφάνιση online κατάστασης στη σελίδα χρήστη μου',
	'onlinestatus-toggle-offline' => 'Αποσυνδεδεμένος',
	'onlinestatus-toggle-online' => 'Συνδεδεμένος',
	'onlinestatus-pref-onlineonlogin' => 'Αλλαγή της κατάστασης μου συνδεδεμένος όταν συνδέομαι',
	'onlinestatus-pref-offlineonlogout' => 'Αλλαγή της κατάστασής μου σε αποσυνδεδεμένος όταν αποσυνδέομαι',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'onlinestatus-desc' => 'Aldonas preferon por montri se la uzanto estas nune ensalutita aŭ ne en la vikio',
	'onlinestatus-js-anon' => 'Eraro: Vi devas ensaluti por uzi ĉi tiun etendilon',
	'onlinestatus-js-changed' => 'Via statuso estis ŝanĝita al "$1"',
	'onlinestatus-js-error' => 'Neeblas ŝanĝi statuson, valoro "$1" estas nevalida',
	'onlinestatus-subtitle-offline' => 'Ĉi tiu uzanto estas nune nekonektita',
	'onlinestatus-subtitle-online' => 'Ĉi tiu uzanto estas nune konektita',
	'onlinestatus-tab' => 'Statuso',
	'onlinestatus-toggles-desc' => 'Via statuso:',
	'onlinestatus-toggles-explain' => 'Ĉi tiu permesas al vi montri al aliaj uzantoj se vi estas aktuale retkonektita per vizitante vian uzanto-paĝon.',
	'onlinestatus-toggles-show' => 'Montru retkonektan statuson en mia uzanto-paĝo',
	'onlinestatus-toggle-offline' => 'Nekonektita',
	'onlinestatus-toggle-online' => 'Konektita',
);

/** Spanish (Español)
 * @author Cojoilustrado
 * @author Crazymadlover
 * @author Imre
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'onlinestatus-desc' => 'Crea una preferencia para mostrar si el usuario está conectado al wiki',
	'onlinestatus-js-anon' => 'Error: tienes que iniciar sesión para usar esta característica',
	'onlinestatus-js-changed' => 'Tu status ha sido cambiado a "$1"',
	'onlinestatus-js-error' => 'Imposible cambiar status, valor "$1" es inválido',
	'onlinestatus-subtitle-offline' => 'Este usuario se encuentra desconectado',
	'onlinestatus-subtitle-online' => 'Este usuario se encuentra conectado',
	'onlinestatus-tab' => 'Estado',
	'onlinestatus-toggles-desc' => 'Tu estatus:',
	'onlinestatus-toggles-explain' => 'Esto te permite mostrar a otros usuarios si estás conectado en tu página de usuario.',
	'onlinestatus-toggles-show' => 'Muestra mi status en mi página de usuario',
	'onlinestatus-toggle-offline' => 'Desconectado',
	'onlinestatus-toggle-online' => 'Conectado',
	'onlinestatus-pref-onlineonlogin' => 'Cambiar mi status a en línea cuando inicie sesión',
	'onlinestatus-pref-offlineonlogout' => 'Cambiar mi estado a desconectado cuando inicie sesión',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'onlinestatus-js-anon' => 'Errorea: aplikazio hau erabiltzeko saioa irekita eduki behar duzu',
	'onlinestatus-js-changed' => 'Zure egoera "$1" egoerara aldatu da',
	'onlinestatus-js-error' => 'Ezinezkoa da egoera aldatzea, "$1" parametroa ez da baliozkoa',
	'onlinestatus-subtitle-offline' => 'Erabiltzaile hau deskonektatuta dago orain',
	'onlinestatus-subtitle-online' => 'Erabiltzaile hau konektatuta dago orain',
	'onlinestatus-tab' => 'Egoera',
	'onlinestatus-toggles-desc' => 'Zure egoera:',
	'onlinestatus-toggles-show' => 'Erakutsi konexio egoera nire erabiltzaile orrialdean',
	'onlinestatus-toggle-offline' => 'Deskonektatuta',
	'onlinestatus-toggle-online' => 'Konektatuta',
	'onlinestatus-pref-onlineonlogin' => 'Saioa hastean nire konexio-egoera konektatua jarri',
	'onlinestatus-pref-offlineonlogout' => 'Saioa ixtean nire konexio-egoera deskonektatua jarri',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Nike
 * @author Vililikku
 */
$messages['fi'] = array(
	'onlinestatus-desc' => 'Lisää asetuksen, joka näyttää onko käyttäjä kirjautunut sisään vai ei',
	'onlinestatus-js-anon' => 'Et voi käyttää tätä ominaisuutta ennen kirjautumista sisään.',
	'onlinestatus-js-changed' => 'Tilasi on nyt ”$1”',
	'onlinestatus-js-error' => 'Tilan muuttaminen on mahdotonta, sillä arvo ”$1” on epäkelpo',
	'onlinestatus-subtitle-offline' => 'Tämä käyttäjä ei ole kirjautunut sisään nyt',
	'onlinestatus-subtitle-online' => 'Tämä käyttäjä on kirjautunut sisään',
	'onlinestatus-tab' => 'Tila',
	'onlinestatus-toggles-desc' => 'Tilasi:',
	'onlinestatus-toggles-show' => 'Näytä sisäänkirjautumisen tila käyttäjäsivullani',
	'onlinestatus-toggle-offline' => 'Ei kirjautuneena',
	'onlinestatus-toggle-online' => 'Kirjautuneena',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Zetud
 */
$messages['fr'] = array(
	'onlinestatus-desc' => 'Ajoute une préférence pour montrer si l’utilisateur est présent ou non',
	'onlinestatus-js-anon' => 'Erreur : vous devez être connecté pour utiliser cette fonctionnalité',
	'onlinestatus-js-changed' => 'Votre statut a été changé à « $1 »',
	'onlinestatus-js-error' => 'Impossible de changer le statut, la valeur « $1 » est invalide',
	'onlinestatus-subtitle-offline' => 'Cet utilisateur est actuellement hors ligne',
	'onlinestatus-subtitle-online' => 'Cet utilisateur est actuellement en ligne',
	'onlinestatus-tab' => 'Statut',
	'onlinestatus-toggles-desc' => 'Votre statut&nbsp;:',
	'onlinestatus-toggles-explain' => 'Ceci permet aux autres utilisateurs de savoir si vous êtes actuellement présent{{GENDER:||e|(e)}} en regardant votre page utilisateur.',
	'onlinestatus-toggles-show' => 'Montrer mon statut sur ma page utilisateur',
	'onlinestatus-toggle-offline' => 'Absent',
	'onlinestatus-toggle-online' => 'Présent',
	'onlinestatus-pref-onlineonlogin' => 'Changer mon statut à en ligne quand je me connecte',
	'onlinestatus-pref-offlineonlogout' => 'Changer mon statut à hors ligne quand je me déconnecte',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'onlinestatus-subtitle-offline' => 'Ceti usanciér est ora en defôr de legne',
	'onlinestatus-subtitle-online' => 'Ceti usanciér est ora en legne',
	'onlinestatus-tab' => 'Statut',
	'onlinestatus-toggles-desc' => 'Voutron statut :',
	'onlinestatus-toggle-offline' => 'Absent',
	'onlinestatus-toggle-online' => 'Present',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'onlinestatus-desc' => 'Engade unha preferencia para mostrar se o usuario está actualmente conectado ou non no wiki',
	'onlinestatus-js-anon' => 'Erro: debe acceder ao sistema para usar esta característica',
	'onlinestatus-js-changed' => 'O seu status foi cambiado a "$1"',
	'onlinestatus-js-error' => 'É imposible cambiar o status; o valor "$1" é inválido',
	'onlinestatus-subtitle-offline' => 'Este usuario está actualmente desconectado',
	'onlinestatus-subtitle-online' => 'Este usuario está actualmente conectado',
	'onlinestatus-tab' => 'Estado',
	'onlinestatus-toggles-desc' => 'O seu estado:',
	'onlinestatus-toggles-explain' => 'Isto permítelle ensinar aos demais usuarios se está actualmente conectado ou non vendo a súa páxina de usuario.',
	'onlinestatus-toggles-show' => 'Mostrar o meu estado na miña páxina de usuario',
	'onlinestatus-toggle-offline' => 'Desconectado',
	'onlinestatus-toggle-online' => 'Conectado',
	'onlinestatus-pref-onlineonlogin' => 'Cambiar o meu status a "conectado" cando acceda ao sistema',
	'onlinestatus-pref-offlineonlogout' => 'Cambiar o meu status a "desconectado" cando saia do sistema',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'onlinestatus-tab' => 'Καθεστώς',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'onlinestatus-desc' => 'Ergänzt e Option zum Aazeige vum Online-Status in dr persenligen Yystelligen',
	'onlinestatus-js-anon' => 'Fähler: Du muesch aagmäldet syy, ass Du die Funtion chasch verwände',
	'onlinestatus-js-changed' => 'Dyy Status isch in „$1“ gänderet wore',
	'onlinestatus-js-error' => 'Statusänderig nit megli, dr Wärt „$1“ isch nit giltig',
	'onlinestatus-subtitle-offline' => 'Dää Benutzer isch zur Zyt offline',
	'onlinestatus-subtitle-online' => 'Dää Benutzer isch zur Zyt online',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Dyy Status:',
	'onlinestatus-toggles-explain' => 'Die Yystellig macht s Dir megli, andere Benutzer uf Dyynere Benutzersyte z zeige, eb Du online oder offline bisch.',
	'onlinestatus-toggles-show' => 'Zeig Onlinestatus uf myynere Benutzersyte',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Status uf online ändere, wänn i mi aamäld',
	'onlinestatus-pref-offlineonlogout' => 'Status uf offline ändere, wänn i mi abmäld',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'onlinestatus-desc' => 'הוספת העדפה להצגה האם המשתמש עדיין פעיל בוויקי או לא',
	'onlinestatus-js-anon' => 'שגיאה: עליכם להיכנס לחשבון כדי להשתמש בתכונה זו',
	'onlinestatus-js-changed' => 'מצבכם שונה ל"$1"',
	'onlinestatus-js-error' => 'לא ניתן לשנות את המצב, הערך "$1" אינו תקין',
	'onlinestatus-subtitle-offline' => 'משתמש זה אינו מקוון כרגע',
	'onlinestatus-subtitle-online' => 'משתמש זה מקוון כרגע',
	'onlinestatus-tab' => 'מצב',
	'onlinestatus-toggles-desc' => 'המצב שלכם:',
	'onlinestatus-toggles-explain' => 'הרחבה זו מאפשרת לכם להראות למשתמשים אחרים האם אתם מקוונים באותו הרגע או שלא על ידי בדיקת דף המשתמש שלכם.',
	'onlinestatus-toggles-show' => 'הצגת מצב הנוכחות בדף המשתמש שלכם',
	'onlinestatus-toggle-offline' => 'מנותק',
	'onlinestatus-toggle-online' => 'מקוון',
	'onlinestatus-pref-onlineonlogin' => 'שינוי המצב שלכם למקוון בעת הכניסה לחשבון',
	'onlinestatus-pref-offlineonlogout' => 'שינוי המצב שלכם למנותק בעת היציאה מהחשבון',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'onlinestatus-subtitle-offline' => 'यह सदस्य अभी ओफ़लाइन हैं',
	'onlinestatus-subtitle-online' => 'यह सदस्य अभी ओनलाइन हैं',
	'onlinestatus-toggles-desc' => 'आपकी स्थिती:',
	'onlinestatus-toggles-show' => 'मेरे सदस्य पृष्ठ पर ओनलाइन स्थिती दर्शायें',
	'onlinestatus-toggle-offline' => 'ओफ़लाइन',
	'onlinestatus-toggle-online' => 'ओनलाइन',
);

/** Croatian (Hrvatski)
 * @author Ex13
 */
$messages['hr'] = array(
	'onlinestatus-desc' => 'Omogućuje postavku prikazivanja suradnikove prisutnosti na wiki',
	'onlinestatus-subtitle-offline' => 'Ovaj suradnik trenutačno nije spojen',
	'onlinestatus-subtitle-online' => 'Ovaj je suradnik trenutačno spojen',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Tvoj status:',
	'onlinestatus-toggles-explain' => 'Ovo omogućava da drugi suradnici uoče tvoju prisutnost kada gledaju tvoju suradničku stranicu.',
	'onlinestatus-toggles-show' => 'Prikaži da sam spojen na mojoj suradničkoj stranici',
	'onlinestatus-toggle-offline' => 'Nije spojen',
	'onlinestatus-toggle-online' => 'Spojen',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'onlinestatus-desc' => 'Preferencu přidać, zo by so pokazało, hač wužiwar je tuchwilu we wikiju přitomny abo nic',
	'onlinestatus-js-anon' => 'Zmylk: Dyrbiš přizjawjeny być, zo by tutu funkciju wužiwał',
	'onlinestatus-js-changed' => 'Twój status je so do "$1" změnił',
	'onlinestatus-js-error' => 'Njemóžno status změnić, hódnota "$1" je njepłaćiwa',
	'onlinestatus-subtitle-offline' => 'Tutón wužiwar je tuchwilu offline',
	'onlinestatus-subtitle-online' => 'Tutón wužiwar je tuchwilu online',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Twój status:',
	'onlinestatus-toggles-explain' => 'Tute nastajenje ći dowoluje druhim wužiwarjam na twojej wužiwarskej stronje pokazać, zo sy tuchwilu online abo nic.',
	'onlinestatus-toggles-show' => 'Status online na mojej wužiwarskej stronje pokazać',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Při přizjewjenju status do online změnić',
	'onlinestatus-pref-offlineonlogout' => 'Při wotzjewjenju status do offline změnić',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'onlinestatus-desc' => 'Beállítás, amivel a szerkesztő jelezheti, hogy online van-e egy adott időpontban a wikin.',
	'onlinestatus-js-anon' => 'Hiba: be kell jelentkezned a funkció használatához',
	'onlinestatus-js-changed' => 'Állapotod megváltoztatva a(z) „$1” értékre',
	'onlinestatus-js-error' => 'Nem sikerült megváltoztatni az állapotot, a(z) „$1” érték érvénytelen',
	'onlinestatus-subtitle-offline' => 'A szerkesztő nincs wikiközelben',
	'onlinestatus-subtitle-online' => 'A szerkesztő jelenleg itt van',
	'onlinestatus-tab' => 'Állapot',
	'onlinestatus-toggles-desc' => 'Állapotod:',
	'onlinestatus-toggles-explain' => 'Lehetővé teszi számodra, hogy a szerkesztői lapodon jelezd más szerkesztők számára, hogy wikiközelben vagy-e vagy sem.',
	'onlinestatus-toggles-show' => 'Elérhetőségi állapotom mutatása a szerkesztői lapomon',
	'onlinestatus-toggle-offline' => 'Kijelentkezett',
	'onlinestatus-toggle-online' => 'Elérhető',
	'onlinestatus-pref-onlineonlogin' => 'Változtassa az állapotomat elérhetőre, ha bejelentkezek',
	'onlinestatus-pref-offlineonlogout' => 'Kilépéskor változtassa az állapotomat „Kijelentkezett”-re',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'onlinestatus-desc' => 'Adde un preferentia pro monstrar si le usator al momento es presente in le wiki o non',
	'onlinestatus-js-anon' => 'Error: tu debe aperir un session pro poter usar iste function',
	'onlinestatus-js-changed' => 'Tu stato ha essite cambiate a "$1"',
	'onlinestatus-js-error' => 'Impossibile cambiar de stato, le valor "$1" es invalide',
	'onlinestatus-subtitle-offline' => 'Iste usator es actualmente foras de linea',
	'onlinestatus-subtitle-online' => 'Iste usator es actualmente in linea',
	'onlinestatus-tab' => 'Stato',
	'onlinestatus-toggles-desc' => 'Tu stato:',
	'onlinestatus-toggles-explain' => 'Isto te permitte monstrar a altere usatores si tu es in linea in tu pagina de usator.',
	'onlinestatus-toggles-show' => 'Monstrar mi stato de connexion in mi pagina de usator',
	'onlinestatus-toggle-offline' => 'Foras de linea',
	'onlinestatus-toggle-online' => 'In linea',
	'onlinestatus-pref-onlineonlogin' => 'Cambiar mi stato a in linea quando io aperi un session',
	'onlinestatus-pref-offlineonlogout' => 'Cambiar mi stato a foras de linea quando io claude mi session',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'onlinestatus-desc' => 'Menambahkan preferensi untuk menunjukkan pengguna ini sedang hadir atau tidak di wiki',
	'onlinestatus-js-anon' => 'Galat: Anda harus masuk log untuk menggunakan fitur ini',
	'onlinestatus-js-changed' => 'Status Anda telah diganti menjadi "$1"',
	'onlinestatus-js-error' => 'Tidak dapat mengganti status, nilai "$1" tidak sah',
	'onlinestatus-subtitle-offline' => 'Pengguna ini sedang luring',
	'onlinestatus-subtitle-online' => 'Pengguna ini sedang daring',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Status Anda:',
	'onlinestatus-toggles-explain' => 'Fitur ini mengijinkan pengguna lain untuk mengetahui status daring atau luring Anda dengan melihat halaman pengguna Anda.',
	'onlinestatus-toggles-show' => 'Tunjukkan status daring pada halaman pengguna saya',
	'onlinestatus-toggle-offline' => 'Luring',
	'onlinestatus-toggle-online' => 'Daring',
	'onlinestatus-pref-onlineonlogin' => 'Ganti status saya menjadi daring (di dalam jaringan) jika masuk log',
	'onlinestatus-pref-offlineonlogout' => 'Ganti status saya menjadi luring (di luar jaringan) jika keluar log',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 */
$messages['it'] = array(
	'onlinestatus-desc' => "Aggiungi una preferenza per mostrare se l'utente è al momento presente o meno sul sito",
	'onlinestatus-js-anon' => "Errore: è necessario effettuare l'accesso per utilizzare questa funzione",
	'onlinestatus-js-changed' => 'Il tuo stato è stato cambiato in "$1"',
	'onlinestatus-js-error' => 'Impossibile modificare lo stato, il valore "$1" non è valido',
	'onlinestatus-subtitle-offline' => 'Questo utente non è attualmente connesso',
	'onlinestatus-subtitle-online' => 'Questo utente è attualmente connesso',
	'onlinestatus-tab' => 'Stato',
	'onlinestatus-toggles-desc' => 'Proprio stato:',
	'onlinestatus-toggles-explain' => 'Questo permette di mostrare ad altri utenti se si è attualmente in linea o meno visualizzando la propria pagina utente.',
	'onlinestatus-toggles-show' => 'Visualizza lo stato di connessione sulla propria pagina utente',
	'onlinestatus-toggle-offline' => 'Non connesso',
	'onlinestatus-toggle-online' => 'Connesso',
	'onlinestatus-pref-onlineonlogin' => 'Cambia lo stato in connesso al momento del login',
	'onlinestatus-pref-offlineonlogout' => 'Cambia lo stato in non connesso al momento del logout',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'onlinestatus-desc' => '利用者が現在そのウィキ上にいるかどうかを表示できるように、{{int:preferences}}に設定項目を追加する',
	'onlinestatus-js-anon' => 'エラー: この機能を利用するにはログインしている必要があります',
	'onlinestatus-js-changed' => 'あなたの状態が「$1」に変更されました',
	'onlinestatus-js-error' => '状態を変更できません。値「$1」は不正です',
	'onlinestatus-subtitle-offline' => '現在、この利用者はオフラインです',
	'onlinestatus-subtitle-online' => '現在、この利用者はオンラインです',
	'onlinestatus-tab' => '状態',
	'onlinestatus-toggles-desc' => 'あなたの状態:',
	'onlinestatus-toggles-explain' => 'これによって、他の利用者があなたの利用者ページを見た際に、あなたがオンラインであるかどうか伝えることができます。',
	'onlinestatus-toggles-show' => '自分の利用者ページでオンライン状態を表示する',
	'onlinestatus-toggle-offline' => 'オフライン',
	'onlinestatus-toggle-online' => 'オンライン',
	'onlinestatus-pref-onlineonlogin' => 'ログイン時に、自分の状態をオンラインに変更する',
	'onlinestatus-pref-offlineonlogout' => 'ログアウト時に、自分の状態をオフラインに変更する',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'onlinestatus-subtitle-offline' => "Panganggo iki saiki lagi ana sajabaning jaringan (''offline'')",
	'onlinestatus-subtitle-online' => "Panganggo iki saiki lagi ana sajroning jaringan (''online'')",
	'onlinestatus-toggles-desc' => 'Status panjenengan:',
	'onlinestatus-toggles-show' => "Tuduhna status \"sajroning jaringan\" (''online'') ing kaca panganggoku",
	'onlinestatus-toggle-offline' => "Sajabaning jaringan (''offline'')",
	'onlinestatus-toggle-online' => "Sajroning jaringan (''online'')",
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'onlinestatus-js-anon' => 'កំហុស​៖ អ្នក​ត្រូវតែ​កត់ឈ្មោះចូល ដើម្បី​ប្រើប្រាស់​មុខងារពិសេស​នេះ',
	'onlinestatus-js-changed' => 'ស្ថានភាព​របស់​អ្នក ត្រូវ​បាន​ប្ដូរទៅ "$1"',
	'onlinestatus-js-error' => 'មិន​អាច​ផ្លាស់ប្ដូរ​ស្ថានភាព​បាន​ទេ, តម្លៃ "$1" មិនត្រឹមត្រូវ',
	'onlinestatus-subtitle-offline' => 'អ្នកប្រើប្រាស់​នេះ​កំពុង​ស្ថិតនៅ​ក្រៅបណ្ដាញ',
	'onlinestatus-subtitle-online' => 'អ្នកប្រើប្រាស់​នេះ​កំពុង​ស្ថិតនៅ​លើបណ្ដាញ',
	'onlinestatus-tab' => 'ស្ថានភាព',
	'onlinestatus-toggles-desc' => 'ស្ថានភាព​របស់​អ្នក',
	'onlinestatus-toggles-show' => 'បង្ហាញ​ស្ថានភាព​លើបណ្ដាញ​នៅ​លើ​ទំព័រ​អ្នកប្រើប្រាស់​របស់​ខ្ញុំ',
	'onlinestatus-toggle-offline' => 'ក្រៅបណ្ដាញ',
	'onlinestatus-toggle-online' => 'លើបណ្ដាញ',
	'onlinestatus-pref-onlineonlogin' => 'ផ្លាស់ប្ដូរ​ស្ថានភាព​របស់​ខ្ញុំ​ទៅជា​លើបណ្ដាញ នៅពេល​កត់ឈ្មោះចូល',
	'onlinestatus-pref-offlineonlogout' => 'ផ្លាស់ប្ដូរ​ស្ថានភាព​របស់​ខ្ញុំ​ទៅជា​ក្រៅបណ្ដាញ នៅពេល​កត់ឈ្មោះចេញ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'onlinestatus-tab' => 'ಸ್ಥಾನಮಾನ',
	'onlinestatus-toggles-desc' => 'ನಿಮ್ಮ ಸ್ಥಾನಮಾನ:',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'onlinestatus-desc' => 'Erlaub en de Enstellunge för de Metmaacher e Krützje, öm op de Metmaachersigg ze zeije, of mer Online es odder nit.',
	'onlinestatus-js-anon' => 'Fähler: Do moß ald ennjelogg sin, öm dat maache ze künne',
	'onlinestatus-js-changed' => 'Dinge Stattus es op „$1“ jeändert.',
	'onlinestatus-js-error' => 'Et wohr nit müjjelesch, dä Stattus ze änderer, „$1“ es nit jöltesch.',
	'onlinestatus-subtitle-offline' => 'Dä Metmaacher is em Momang nit doh',
	'onlinestatus-subtitle-online' => 'Dä Metmaacher is jrad online',
	'onlinestatus-tab' => 'Stattus',
	'onlinestatus-toggles-desc' => 'Dinge Online-Stattus:',
	'onlinestatus-toggles-explain' => 'Dat hee määt et müjjelich, dat ander Metmaacher om Dinge Metmaachersigg nohloore künne, of De online bes odder nit.',
	'onlinestatus-toggles-show' => 'Zeich minge Online-Stattus op minge Metmachersigg',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Donn minge Stattuß op „onlain“ saze, wann esch ennlogg',
	'onlinestatus-pref-offlineonlogout' => 'Donn minge Stattuß op „offlain“ saze, wann esch ußlogg',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'onlinestatus-desc' => 'Setzt eng Astellung derbäi fir ze weisen ob de Benotzer op dëser Wiki zur Zäit online ass',
	'onlinestatus-js-anon' => 'Feeler: Dir musst ageloggt si fir dës Fonctioun ze benotzen',
	'onlinestatus-js-changed' => 'Äre Statut gouf op "$1" geännert',
	'onlinestatus-js-error' => 'Et ass net méiglech de Statut z\'änneren, de Wäert "$1" ass net valabel',
	'onlinestatus-subtitle-offline' => 'Dëse Benotzer ass zur Zäit offline',
	'onlinestatus-subtitle-online' => 'Dëse Benotzer ass zur Zäit online',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Äre Status:',
	'onlinestatus-toggles-explain' => 'Dëst erlaabt et fir anere Benotzer ze weisen ob Dir zur Zäit online sidd wann si är Benotzersäit kucken.',
	'onlinestatus-toggles-show' => 'Online-Status op menger Benotzersäit weisen',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Mäi Statut op online änneren esoubal ech mech aloggen',
	'onlinestatus-pref-offlineonlogout' => 'Mäi Statut op offline änneren esoubal ech mech ausloggen',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'onlinestatus-toggles-desc' => 'Jūsų statusas:',
	'onlinestatus-toggle-offline' => 'Neprisijungęs',
	'onlinestatus-toggle-online' => 'Prisijungęs',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'onlinestatus-toggle-offline' => 'Bezsaiste',
	'onlinestatus-toggle-online' => 'Tiešsaiste',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'onlinestatus-desc' => 'Додава прилагодување кое прикажува дали корисникот е моментално присутен на викито',
	'onlinestatus-js-anon' => 'Грешка: морате да сте најавени за да ја користите оваа можност',
	'onlinestatus-js-changed' => 'Вашиот статус е променет на „$1“',
	'onlinestatus-js-error' => 'Невозможно е да се измени статусот, вредноста „$1“ е погрешна',
	'onlinestatus-subtitle-offline' => 'Овој корисник е моментално исклучен',
	'onlinestatus-subtitle-online' => 'Овој корисник е моментално вклучен',
	'onlinestatus-tab' => 'Статус',
	'onlinestatus-toggles-desc' => 'Вашиот статус:',
	'onlinestatus-toggles-explain' => 'Со ова другите корисници на вашата страница можат да видат дали сте всушност на линија.',
	'onlinestatus-toggles-show' => 'Прикажувај дали сум на линија на мојата корисничка страница',
	'onlinestatus-toggle-offline' => 'Вонмрежно',
	'onlinestatus-toggle-online' => 'Вклучен',
	'onlinestatus-pref-onlineonlogin' => 'Промени ми го статусот во „вклучен“ кога се најавувам',
	'onlinestatus-pref-offlineonlogout' => 'Промени ми го статусот во „исклучен“ кога се одјавувам',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'onlinestatus-subtitle-offline' => 'ഈ ഉപയോക്താവ് നിലവിൽ ഓഫ്‌ലൈൻ ആണ്‌',
	'onlinestatus-subtitle-online' => 'ഈ ഉപയോക്താവ് നിലവിൽ ഓഫ്‌ലൈൻ ആണ്‌',
	'onlinestatus-tab' => 'സ്ഥിതി',
	'onlinestatus-toggles-desc' => 'താങ്കളുടെ സ്ഥിതി:',
	'onlinestatus-toggles-explain' => 'താങ്കളുടെ ഉപയോക്തൃതാൾ കാണുമ്പോൾ താങ്കൾ ഓൺലൈൻ ആണോ അല്ലയോ എന്നു മറ്റുള്ളവർക്ക് മനസ്സിലാക്കാൻ ഈ സം‌വിധാനം സഹായിക്കുന്നു.',
	'onlinestatus-toggles-show' => 'ഓൺ‌ലൈൻ സ്ഥിതി എന്റെ ഉപയോക്തൃതാളിൽ പ്രദർശിപ്പിക്കുക',
	'onlinestatus-toggle-offline' => 'ഓഫ്‌ലൈൻ',
	'onlinestatus-toggle-online' => 'ഓൺലൈൻ',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'onlinestatus-desc' => 'पसंती मध्ये एक नवीन गुणधर्म वाढवितो ज्याद्वारे एखादा सदस्य विकिवर उपस्थित आहे का ते दिसते',
	'onlinestatus-subtitle-offline' => 'हा सदस्य अनुपस्थित आहे',
	'onlinestatus-subtitle-online' => 'हा सदस्य उपस्थित आहे',
	'onlinestatus-toggles-desc' => 'तुमची स्थिती:',
	'onlinestatus-toggles-explain' => 'तुमचे सदस्य पान पाहून इतर सदस्यांना तुम्ही उपस्थित आहात का नाही ते याच्यामुळे कळते.',
	'onlinestatus-toggles-show' => 'माझ्या सदस्य पानावर उपस्थिती दाखवा',
	'onlinestatus-toggle-offline' => 'अनुपस्थित',
	'onlinestatus-toggle-online' => 'उपस्थित',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'onlinestatus-desc' => 'Voegt een voorkeur toe om aan te kunnen geven of een gebruiker aanwezig is op de wiki of niet',
	'onlinestatus-js-anon' => 'Fout: u moet aangemeld zijn om deze optie te kunnen gebruiken',
	'onlinestatus-js-changed' => 'Uw status is gewijzigd naar "$1"',
	'onlinestatus-js-error' => 'De status kan niet gewijzigd worden. Waarde "$1" is ongeldig',
	'onlinestatus-subtitle-offline' => 'Deze gebruiker is offline',
	'onlinestatus-subtitle-online' => 'Deze gebruiker is online',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Uw status:',
	'onlinestatus-toggles-explain' => 'Hiermee kunt u andere gebruikers op uw gebruikerspagina aangeven of u online of offline bent.',
	'onlinestatus-toggles-show' => 'Onlinestatus weergeven op mijn gebruikerspagina',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Mijn status naar online wijzigen als ik me aanmeld',
	'onlinestatus-pref-offlineonlogout' => 'Mijn status naar offline wijzigen als ik me afmeld',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'onlinestatus-desc' => 'Legg til eit val som gjer det mogleg å visa om brukaren er pålogga eller ikkje',
	'onlinestatus-js-anon' => 'Feil: du må vera innlogga for å nytta denne funksjonen',
	'onlinestatus-js-changed' => 'Statusen din er endra til «$1»',
	'onlinestatus-js-error' => 'Kunne ikkje endra status, verdien «$1» er ugyldig',
	'onlinestatus-subtitle-offline' => 'Denne brukaren er ikkje pålogga',
	'onlinestatus-subtitle-online' => 'Denne brukaren er pålogga',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Din status:',
	'onlinestatus-toggles-explain' => 'Dette lèt deg visa andre brukarar om du er pålogga eller ikkje ved at dei vitjar brukarsida di.',
	'onlinestatus-toggles-show' => 'Vis påloggingsstatus på brukarsida mi',
	'onlinestatus-toggle-offline' => 'Ikkje pålogga',
	'onlinestatus-toggle-online' => 'Logga på',
	'onlinestatus-pref-onlineonlogin' => 'Endra statusen min til pålogga når eg loggar inn',
	'onlinestatus-pref-offlineonlogout' => 'Endra statusen min til ikkje pålogga når eg loggar ut',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'onlinestatus-desc' => 'Legger til en innstilling for å vise om brukeren er logget på wikien eller ikke',
	'onlinestatus-js-anon' => 'Feil: du må være logget inn for å bruke denne funksjonen',
	'onlinestatus-js-changed' => 'Statusen din er endret til «$1»',
	'onlinestatus-js-error' => 'Kunne ikke endre status, verdien «$1» er ugyldig',
	'onlinestatus-subtitle-offline' => 'Denne brukeren er ikke logget på',
	'onlinestatus-subtitle-online' => 'Denne brukeren er logget på',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Din status:',
	'onlinestatus-toggles-explain' => 'Dette viser brukere om du er logget på eller ikke ved å se brukersiden din.',
	'onlinestatus-toggles-show' => 'Vis innloggingsstatus på brukersiden min',
	'onlinestatus-toggle-offline' => 'Ikke logget på',
	'onlinestatus-toggle-online' => 'Logget på',
	'onlinestatus-pref-onlineonlogin' => 'Endre statusen min til pålogget når jeg logger inn',
	'onlinestatus-pref-offlineonlogout' => 'Endre statusen min til avlogget når jeg logger ut',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'onlinestatus-desc' => "Apond una preferéncia per mostrar se l'utilizaire es present o pas",
	'onlinestatus-js-anon' => 'Error : vos cal èsser connectat per utilizar aquesta foncionalitat',
	'onlinestatus-js-changed' => 'Vòstre estatut es estat cambiat a « $1 »',
	'onlinestatus-js-error' => "Impossible de cambiar l'estatut, la valor « $1 » es invalida",
	'onlinestatus-subtitle-offline' => 'Aqueste utilizaire es actualament fòra de linha',
	'onlinestatus-subtitle-online' => 'Aqueste utilizaire actualament es en linha',
	'onlinestatus-tab' => 'Estatut',
	'onlinestatus-toggles-desc' => 'Vòstre estatut :',
	'onlinestatus-toggles-explain' => "Aquò permet als autres utilizaires de saber se actualament sètz present en agachant vòstra pagina d'utilizaire.",
	'onlinestatus-toggles-show' => "Far veire mon estatut sus ma pagina d'utilizaire",
	'onlinestatus-toggle-offline' => 'Absent',
	'onlinestatus-toggle-online' => 'Present',
	'onlinestatus-pref-onlineonlogin' => 'Cambiar mon estatut a en linha quand me connècti',
	'onlinestatus-pref-offlineonlogout' => 'Cambiar mon estatut a fòra linha quand me desconnècti',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'onlinestatus-tab' => 'Статус',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'onlinestatus-desc' => 'Umożliwia prezentację aktualnej dostępności użytkownika na wiki',
	'onlinestatus-js-anon' => 'Błąd – musisz być zalogowany, aby korzystać z tej funkcji',
	'onlinestatus-js-changed' => 'Twój status został zmieniony na „$1”',
	'onlinestatus-js-error' => 'Nie można zmienić statusu, wartość „$1” jest nieprawidłowa',
	'onlinestatus-subtitle-offline' => 'Użytkownik jest w tej chwili niedostępny',
	'onlinestatus-subtitle-online' => 'Użytkownik jest w tej chwili dostępny',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Twój status:',
	'onlinestatus-toggles-explain' => 'Umożliwia Ci prezentowanie innym użytkownikom na Twojej stronie użytkownika czy jesteś aktualnie dostępny.',
	'onlinestatus-toggles-show' => 'Pokaż moją dostępność na mojej stronie użytkownika',
	'onlinestatus-toggle-offline' => 'Niedostępny',
	'onlinestatus-toggle-online' => 'Dostępny',
	'onlinestatus-pref-onlineonlogin' => 'Zmień mój status na dostępny gdy jestem zalogowany',
	'onlinestatus-pref-offlineonlogout' => 'Zmień mój status na niedostępny gdy nie jestem zalogowany',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'onlinestatus-desc' => 'Gionta un "mè gust" për mosté se l\'utent al moment a l\'é present o no an sla wiki',
	'onlinestatus-js-anon' => 'Eror: it deuve esse intrà për dovré sta funsion-sì',
	'onlinestatus-js-changed' => 'Tò stat a l\'é cambià a "$1"',
	'onlinestatus-js-error' => 'Ampossìbil cambié stat, ël valor "$1" a l\'é pa bon',
	'onlinestatus-subtitle-offline' => "St'utent-sì al moment a l'é fòra linia",
	'onlinestatus-subtitle-online' => "St'utent-sì al moment a l'é fòra linia",
	'onlinestatus-tab' => 'Stat',
	'onlinestatus-toggles-desc' => 'Tò stat:',
	'onlinestatus-toggles-explain' => "Sòn sì at përmëtt ëd mosté a autri utent s'it ses al moment an linia o no an vardand toa pàgina utent.",
	'onlinestatus-toggles-show' => 'Mosta lë stat an linia an mia pàgina utent',
	'onlinestatus-toggle-offline' => 'Fòra linia',
	'onlinestatus-toggle-online' => 'Fòra linia',
	'onlinestatus-pref-onlineonlogin' => 'Cambia mè stat a "an linia" quand i intro',
	'onlinestatus-pref-offlineonlogout' => 'Cambia mè stat a "fòra linia" quand i seurto',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'onlinestatus-subtitle-offline' => 'دم مهال دا کارن بې ليکه دی',
	'onlinestatus-subtitle-online' => 'دم مهال دا کارن پر ليکه دی',
	'onlinestatus-tab' => 'دريځ',
	'onlinestatus-toggles-desc' => 'ستاسې دريځ:',
	'onlinestatus-toggles-show' => 'زما په کارن-مخ زما دريځ پرليکه ښکاره کول',
	'onlinestatus-toggle-offline' => 'بې ليکه',
	'onlinestatus-toggle-online' => 'پر ليکه',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'onlinestatus-desc' => 'Adiciona uma preferência para mostrar se o utilizador está ligado à wiki ou não',
	'onlinestatus-js-anon' => 'Erro: tem que estar autenticado para usar esta funcionalidade',
	'onlinestatus-js-changed' => 'O seu estado foi alterado para "$1"',
	'onlinestatus-js-error' => 'Impossível alterar estado, o valor "$1" é inválido',
	'onlinestatus-subtitle-offline' => 'Este utilizador encontra-se offline',
	'onlinestatus-subtitle-online' => 'Este utilizador encontra-se online',
	'onlinestatus-tab' => 'Estado',
	'onlinestatus-toggles-desc' => 'O seu estado:',
	'onlinestatus-toggles-explain' => 'Isto permite-lhe mostrar a quem consulte a sua página de utilizador se está, ou não, ligado.',
	'onlinestatus-toggles-show' => 'Mostrar o estado da minha ligação na minha página de utilizador',
	'onlinestatus-toggle-offline' => 'Desligado',
	'onlinestatus-toggle-online' => 'Ligado',
	'onlinestatus-pref-onlineonlogin' => 'Alterar o meu estado para ligado, quando me autenticar',
	'onlinestatus-pref-offlineonlogout' => 'Alterar o meu estado para desligado, quando me desautenticar',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'onlinestatus-desc' => 'Adiciona uma preferência para mostrar se o utilizador está atualmente presente no wiki ou não',
	'onlinestatus-js-anon' => 'Erro: você tem que estar autenticado para usar esta funcionalidade',
	'onlinestatus-js-changed' => 'O seu estado foi alterado para "$1"',
	'onlinestatus-js-error' => 'Impossível alterar estado, o valor "$1" é inválido',
	'onlinestatus-subtitle-offline' => 'Este utilizador não encontra-se autenticado',
	'onlinestatus-subtitle-online' => 'Este utilizador encontra-se autenticado',
	'onlinestatus-tab' => 'Estado',
	'onlinestatus-toggles-desc' => 'O seu estado:',
	'onlinestatus-toggles-explain' => 'Permite que seja exibido a outros utilizadores, através de sua página de utilizador, se você se encontra autenticado ou não.',
	'onlinestatus-toggles-show' => 'Exibir o estado da minha ligação na minha página de utilizador',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Alterar o meu estado para online quando me autenticar',
	'onlinestatus-pref-offlineonlogout' => 'Alterar o meu estado para offline quando me desautenticar',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'onlinestatus-subtitle-offline' => 'Kay ruraqqa manam llikapi kachkanchu',
	'onlinestatus-subtitle-online' => 'Kay ruraqqa llikapim kachkan',
	'onlinestatus-toggles-show' => "Llikapi kachkayta ruraqpa p'anqaypi rikuchiy",
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'onlinestatus-js-changed' => 'Starea dvs. a fost schimbată în „$1”',
	'onlinestatus-subtitle-offline' => 'Acest utilizator este momentan offline',
	'onlinestatus-subtitle-online' => 'Acest utilizator este momentan online',
	'onlinestatus-tab' => 'Statut',
	'onlinestatus-toggles-desc' => 'Starea dvs.:',
	'onlinestatus-toggles-show' => 'Arată starea online pe pagina mea de utilizator',
	'onlinestatus-toggle-offline' => 'Offline',
	'onlinestatus-toggle-online' => 'Online',
	'onlinestatus-pref-onlineonlogin' => 'Schimbă-mi starea la online când mă autentific',
	'onlinestatus-pref-offlineonlogout' => 'Schimbă-mi starea la offline când mă dezautentific',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'onlinestatus-tab' => 'State',
	'onlinestatus-toggles-desc' => "'U state tue:",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'onlinestatus-desc' => 'Добавляет настройку, определяющую присутствие участника на сайте в данный момент',
	'onlinestatus-js-anon' => 'Ошибка. Вы должны представиться системе для использования этой возможности.',
	'onlinestatus-js-changed' => 'Ваш статус был изменён на «$1»',
	'onlinestatus-js-error' => 'Невозможно изменить статус, значение «$1» является неверным',
	'onlinestatus-subtitle-offline' => 'Этого участника сейчас нет на сайте',
	'onlinestatus-subtitle-online' => 'Этот участник сейчас на сайте',
	'onlinestatus-tab' => 'Статус',
	'onlinestatus-toggles-desc' => 'Ваш статус:',
	'onlinestatus-toggles-explain' => 'Позволяет другим участникам, просматривающим вашу страницу, увидеть присутствуете ли вы сейчас на сайте',
	'onlinestatus-toggles-show' => 'Показывать присутствие на сайте на моей странице учасника',
	'onlinestatus-toggle-offline' => 'Нет на сайте',
	'onlinestatus-toggle-online' => 'На сайте',
	'onlinestatus-pref-onlineonlogin' => 'Изменить мой статус на «online» при входе в систему',
	'onlinestatus-pref-offlineonlogout' => 'Изменить мой статус на «offline» при завершении сеанса',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'onlinestatus-desc' => 'Pridá možnosť zobrazovať, či je používateľ momentálne prítomný na wiki alebo nie',
	'onlinestatus-js-anon' => 'Chyba: aby ste mohli vytužívať túto funkciu, musíte byť prihlásený',
	'onlinestatus-js-changed' => 'Váš stav sa zmenil na „$1”',
	'onlinestatus-js-error' => 'Nebolo možné zmeniť stav, hodnota „$1” nie je platná',
	'onlinestatus-subtitle-offline' => 'Tento používateľ je momentálne odpojený',
	'onlinestatus-subtitle-online' => 'Tento používateľ je momentálne pripojený',
	'onlinestatus-tab' => 'Stav',
	'onlinestatus-toggles-desc' => 'Váš stav:',
	'onlinestatus-toggles-explain' => 'Toto vám umožní zobrazovať na vašej používateľskej stránke ostatným používateľom, či ste v skutočnosti pripojený alebo nie.',
	'onlinestatus-toggles-show' => 'Zobrazovať stav pripojenia na mojej používateľskej stránke',
	'onlinestatus-toggle-offline' => 'Odpojený',
	'onlinestatus-toggle-online' => 'Pripojený',
	'onlinestatus-pref-onlineonlogin' => 'Zmeniť môj stav na online počas prihlasovania',
	'onlinestatus-pref-offlineonlogout' => 'Zmeniť môj stav na offline počas odhlasovania',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'onlinestatus-tab' => 'Stanje',
	'onlinestatus-toggles-desc' => 'Vaše stanje:',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'onlinestatus-desc' => 'Додаје подешавања да би се показивало да ли је корисник трентно присутан на викију или не.',
	'onlinestatus-js-anon' => 'Грешка: морате бити улоговани да бисте користили ову погодност.',
	'onlinestatus-js-changed' => 'Ваш статус је промењен на „$1“',
	'onlinestatus-js-error' => 'Не могу да променим статус. Вредност „$1“ је неисправна',
	'onlinestatus-subtitle-offline' => 'Овај корисник је тренутно ван мреже',
	'onlinestatus-subtitle-online' => 'Овај корисник је тренутно на мрежи',
	'onlinestatus-tab' => 'Статус',
	'onlinestatus-toggles-desc' => 'Ваш статус:',
	'onlinestatus-toggles-explain' => 'Уз помоћ овога, други корисници на вашој страници могу да виде да ли сте тренутно на мрежи.',
	'onlinestatus-toggles-show' => 'Приказуј присутност на мојој корисничкој страници',
	'onlinestatus-toggle-offline' => 'Ван мреже',
	'onlinestatus-toggle-online' => 'На мрежи',
	'onlinestatus-pref-onlineonlogin' => 'Промени ми статус на „на мрежи“ када се пријавим',
	'onlinestatus-pref-offlineonlogout' => 'Промени ми статус на „ван мреже“ када се одјавим',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'onlinestatus-desc' => 'Dodaje podešavanja da bi se pokazivalo da li je korisnik trentno prisutan na vikiju ili ne.',
	'onlinestatus-js-anon' => 'Greška: morate biti ulogovani da biste koristili ovu pogodnost.',
	'onlinestatus-js-changed' => 'Vaš status je promenjen na "$1"',
	'onlinestatus-js-error' => 'Nemoguće promeniti status, vrednost "$1" je neispravna',
	'onlinestatus-subtitle-offline' => 'Ovaj korisnik je trenutno odsutan',
	'onlinestatus-subtitle-online' => 'Ovaj korisnik je trenutno prisutan',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Vaš status:',
	'onlinestatus-toggles-explain' => 'Ovo Vam omogućava da pokažete drugim korisnicima da na vašoj strani vide da li ste trenutno prisutni ili ne.',
	'onlinestatus-toggles-show' => 'Pokazuj prisutnost na mojoj korisničkoj strani',
	'onlinestatus-toggle-offline' => 'Odsutan',
	'onlinestatus-toggle-online' => 'Prisutan',
	'onlinestatus-pref-onlineonlogin' => 'Promeni moj status na onlajn kada se ulogujem',
	'onlinestatus-pref-offlineonlogout' => 'Promeni moj status na oflajn kada se izlogujem',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'onlinestatus-desc' => 'Lägger till en inställning för att visa om användaren är ansluten eller ej på wikin',
	'onlinestatus-js-anon' => 'Fel: du måste vara inloggad för att använda denna funktionen',
	'onlinestatus-js-changed' => 'Din status har ändrats till "$1"',
	'onlinestatus-js-error' => 'Kunde inte ändra status, värdet "$1" är ogiltigt',
	'onlinestatus-subtitle-offline' => 'Denna användare är ej ansluten',
	'onlinestatus-subtitle-online' => 'Denna användare är ansluten',
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Din status:',
	'onlinestatus-toggles-explain' => 'Detta låter dig visa andra användare om du är ansluten just nu eller inte genom visning av din användarsida.',
	'onlinestatus-toggles-show' => 'Visa anslutningsstatus på min användarsida',
	'onlinestatus-toggle-offline' => 'Ej ansluten',
	'onlinestatus-toggle-online' => 'Ansluten',
	'onlinestatus-pref-onlineonlogin' => 'Ändra min status till online när jag loggar in',
	'onlinestatus-pref-offlineonlogout' => 'Ändra min status till offline när jag loggar ut',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 */
$messages['ta'] = array(
	'onlinestatus-desc' => 'பயனர் இணைப்பில் உள்ளாரா இல்லையா என்பதைக் காட்ட விருப்பத்தேர்வு இணைக்கப்படுகிறது',
	'onlinestatus-js-anon' => 'தவறு(பிழை): இந்த அம்சத்தை பயன்படுத்த, தாங்கள் புகுபதிகை செய்திருக்க வேண்டும்',
	'onlinestatus-js-changed' => 'தங்களது தொடர்நிலை, இதற்கு மாற்றப்பட்டுள்ளது: "$1"',
	'onlinestatus-js-error' => '("$1") - இதன் உட்பொருள் ஒத்தவரவில்லை. ஆகவே நிலைமையை மாற்றம் செய்யமுடியாது.',
	'onlinestatus-subtitle-offline' => 'இந்தப் பயனர் தற்போது இணைப்பிலில்லை',
	'onlinestatus-subtitle-online' => 'இந்தப் பயனர் தற்போது இணைப்பிலுள்ளார்',
	'onlinestatus-tab' => 'நிலைமை',
	'onlinestatus-toggles-desc' => 'உங்களது நிலை:',
	'onlinestatus-toggles-explain' => 'இது நீங்கள் இணைப்பில் உள்ளீர்களா இல்லையா என்பதை உங்கள் பயனர் பக்கத்தைப் பார்பதன் மூல்ம் ஏனைய பயனர்களுக்கு காட்ட உதவும்.',
	'onlinestatus-toggles-show' => 'நான் இணைப்பில் உள்ளேனா இல்லையா என்பதை பயனர் பக்கத்தில் காட்டுக',
	'onlinestatus-toggle-offline' => 'இணைப்பிலில்லை',
	'onlinestatus-toggle-online' => 'இணைப்பில்',
	'onlinestatus-pref-onlineonlogin' => 'புகுபதிகை செய்தபின் எனது நிலைமையை இணைப்பில் உள்ளது என்று மாற்றவும்',
	'onlinestatus-pref-offlineonlogout' => 'விடுபதிகை செய்யும்போது எனது நிலைமையை இணைப்பில்லாநிலை என்று மாற்றவும்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'onlinestatus-js-changed' => 'మీ స్థితిని "$1"కి మార్చాం',
	'onlinestatus-tab' => 'స్థితి',
	'onlinestatus-toggles-desc' => 'మీ స్థితి:',
	'onlinestatus-toggles-explain' => 'మీరు ఆన్‌లైనులో ఉన్నారో లేదో ఇతర వాడుకరులకు మీ వాడుకరి పుటలో చూపించే అవకాశాన్ని కల్పిస్తుంది.',
	'onlinestatus-toggles-show' => 'నా వాడుకరి పుటలో ఆన్‌లైన్ స్థితిని చూపించు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'onlinestatus-desc' => 'Magdagdag ng isang kagustuhan upang maipakita kung pangkasalukuyang nasa wiki ba o hindi ang tagagamit',
	'onlinestatus-js-anon' => 'Kamalian: dapat kang nakalagda muna upang magamit ang kasangkapang-katangiang ito',
	'onlinestatus-js-changed' => 'Pinalitan ang iyong kalagayan na naging "$1"',
	'onlinestatus-js-error' => 'Imposibleng mabago ang kalagayan, hindi tanggap ang halagang "$1"',
	'onlinestatus-subtitle-offline' => 'Kasalukuyang hindi nakaugnay sa internet ang tagagamit na ito',
	'onlinestatus-subtitle-online' => 'Kasalukuyang nakaugnay sa internet ang tagagamit na ito',
	'onlinestatus-tab' => 'Kalagayan',
	'onlinestatus-toggles-desc' => 'Kalagayan mo:',
	'onlinestatus-toggles-explain' => 'Nagpapahintulot ito sa iyong maipakita sa ibang mga tagagamit kung talagang nakaugnay ka sa internet o hindi sa pamamagitan ng pagtingin sa pahina mo.',
	'onlinestatus-toggles-show' => 'Ipakita sa ibabaw ng aking pahina ng tagagamit ang aking katayuan ng pagkakaugnay sa internet',
	'onlinestatus-toggle-offline' => 'Hindi nakaugnay sa internet',
	'onlinestatus-toggle-online' => 'Nakaugnay sa internet',
	'onlinestatus-pref-onlineonlogin' => 'Palitan ang katayuan ko bilang nakakunekta sa internet kapag lumalagda',
	'onlinestatus-pref-offlineonlogout' => 'Palitan ang katayuan ko bilang hindi nakakunekta sa internet kapag umaalis sa pagkakalagda',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'onlinestatus-desc' => 'Kullanıcının halihazırda vikide olup olmadığını göstermesi için bir tercih ekler',
	'onlinestatus-js-anon' => 'Hata: bu özelliği kullanabilmeniz için oturum açmış olmanız gerekiyor',
	'onlinestatus-js-changed' => 'Durumunuz "$1" olarak değiştirildi',
	'onlinestatus-js-error' => 'Durumun değiştirilmesi mümkün değl, "$1" değeri geçersiz',
	'onlinestatus-subtitle-offline' => 'Bu kullanıcı şu an çevrimdışı',
	'onlinestatus-subtitle-online' => 'Bu kullanıcı şu an çevrimiçi',
	'onlinestatus-tab' => 'Durum',
	'onlinestatus-toggles-desc' => 'Durumunuz:',
	'onlinestatus-toggles-explain' => 'Bu, diğer kullanıcıların kullanıcı sayfanızı görüntüleyerek çevrimiçi olup olmadığınızı görmesini sağlar',
	'onlinestatus-toggles-show' => 'Çevrimiçi durumunu kullanıcı sayfamda görüntüle',
	'onlinestatus-toggle-offline' => 'Çevrimdışı',
	'onlinestatus-toggle-online' => 'Çevrimiçi',
	'onlinestatus-pref-onlineonlogin' => 'Oturum açtığımda durumumu çevrimiçi olarak değiştir',
	'onlinestatus-pref-offlineonlogout' => 'Oturumu kapadığımda durumumu çevrimdışı olarak değiştir',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'onlinestatus-desc' => "Zonta na preferensa par mostrar se l'utente el xe presente in sto momento su la wiki",
	'onlinestatus-js-anon' => 'Eròr: te devi aver fato el login par doparar sta funsion',
	'onlinestatus-js-changed' => 'El to stato el xe stà canbià a "$1"',
	'onlinestatus-js-error' => 'No se pol canbiar el stato, el valor "$1" no\'l xe vàlido',
	'onlinestatus-subtitle-offline' => "Sto utente desso no'l xe mìa in linea",
	'onlinestatus-subtitle-online' => 'Sto utente desso el xe in linea',
	'onlinestatus-tab' => 'Stato',
	'onlinestatus-toggles-desc' => 'El to stato:',
	'onlinestatus-toggles-explain' => 'Sta roba la te permete de mostrar ai altri utenti, vardando la to pagina utente, se te sì in linea o no in sto momento.',
	'onlinestatus-toggles-show' => 'Mostra se son in linea o no su la me pagina utente',
	'onlinestatus-toggle-offline' => 'Mìa in linea',
	'onlinestatus-toggle-online' => 'In linea',
	'onlinestatus-pref-onlineonlogin' => 'Canbia el me stato a "online" co fasso el login',
	'onlinestatus-pref-offlineonlogout' => 'Canbia el me stato a "offline" co me desconéto',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'onlinestatus-tab' => 'Status',
	'onlinestatus-toggles-desc' => 'Teiden status:',
	'onlinestatus-toggle-online' => 'Saital',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'onlinestatus-desc' => 'Thêm tùy chọn để hiển thị xem một thành viên hiện có đang trực tuyến tại wiki hay không',
	'onlinestatus-js-anon' => 'Lỗi: bạn phải đăng nhập để sử dụng tính năng này',
	'onlinestatus-js-changed' => 'Trạng thái của bạn đã được đổi thành “$1”',
	'onlinestatus-js-error' => 'Không thể thay đỏi trạng thái, giá trị “$1” không hợp lệ',
	'onlinestatus-subtitle-offline' => 'Thành viên này hiện đang ngoại tuyến',
	'onlinestatus-subtitle-online' => 'Thành viên này hiện đang trực tuyến',
	'onlinestatus-tab' => 'Trạng thái',
	'onlinestatus-toggles-desc' => 'Trạng thái của bạn:',
	'onlinestatus-toggles-explain' => 'Lựa chọn này cho phép bạn tùy chọn để người khác thấy bạn trực tuyến hay không khi xem trang cá nhân của bạn.',
	'onlinestatus-toggles-show' => 'Hiển thị trạng thái trực tuyến trên trang cá nhân của tôi',
	'onlinestatus-toggle-offline' => 'Ngoại tuyến',
	'onlinestatus-toggle-online' => 'Trực tuyến',
	'onlinestatus-pref-onlineonlogin' => 'Thay đổi trạng thái của tôi sang đang trực tuyến khi tôi đăng nhập',
	'onlinestatus-pref-offlineonlogout' => 'Thay đổi trạng thái của tôi sang đang ngoại tuyến khi tôi đăng xuất',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'onlinestatus-desc' => 'Läükon buükami ad jonön if geban anu komon u no komon in vük',
	'onlinestatus-js-anon' => 'Pöl: mutol nunädön oli büä gebol mögi at',
	'onlinestatus-js-changed' => 'Stad olik pevotükon ad „$1“',
	'onlinestatus-js-error' => 'Stadivotükam nemögon, völad: „$1“ no lonöfon',
	'onlinestatus-tab' => 'Stad',
	'onlinestatus-toggles-desc' => 'Stad olik:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'onlinestatus-subtitle-offline' => '这个用户当前离线',
	'onlinestatus-subtitle-online' => '这个用户当前在线',
	'onlinestatus-tab' => '状态',
	'onlinestatus-toggles-desc' => '您的状态：',
	'onlinestatus-toggles-show' => '在我的用户页显示在线状态',
	'onlinestatus-toggle-offline' => '离线',
	'onlinestatus-toggle-online' => '在线',
	'onlinestatus-pref-onlineonlogin' => '当登入时把我的状态设为在线',
	'onlinestatus-pref-offlineonlogout' => '当登出时把我的状态设为离线',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'onlinestatus-subtitle-offline' => '這用戶現正離線',
	'onlinestatus-subtitle-online' => '這用戶目前在線上',
	'onlinestatus-tab' => '狀態',
	'onlinestatus-toggles-desc' => '您的狀態：',
	'onlinestatus-toggles-show' => '在我的用戶頁面顯示線上狀態',
	'onlinestatus-toggle-offline' => '離線',
	'onlinestatus-toggle-online' => '線上',
	'onlinestatus-pref-onlineonlogin' => '當登入時把我的狀態設為線上',
	'onlinestatus-pref-offlineonlogout' => '當登出時把我的狀態設為離線',
);

