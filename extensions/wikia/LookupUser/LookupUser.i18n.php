<?php
/**
 * Internationalisation file for LookupUser extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Tim Starling
 */
$messages['en'] = array(
	'lookupuser' => 'Look up user info',
	'lookupuser-desc' => '[[Special:LookupUser|Retrieve information]] about a user such as e-mail address and ID',
	'lookupuser-intro' => 'Enter a username to view the preferences of that user.',
	'lookupuser-nonexistent' => 'Error: User does not exist',
	'lookupuser-nonexistent-id' => 'Error: User with ID #$1 does not exist',
	'lookupuser-authenticated' => 'authenticated on $1',
	'lookupuser-not-authenticated' => 'not authenticated',
	'lookupuser-id' => 'User ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'not provided',
	'lookupuser-email-change-requested' => 'User requested an email change via Preferences to $1.',
	'lookupuser-realname' => 'Real name: $1',
	'lookupuser-registration' => 'Registration date: $1',
	'lookupuser-no-registration' => 'not recorded',
	'lookupuser-touched' => 'User record last touched: $1',
	'lookupuser-info-authenticated' => 'E-mail authentication: $1',
	'lookupuser-useroptions' => 'User options:',
	'lookupuser-foundmoreusers'    => 'Found more than one\'s user',
	'right-lookupuser' => 'Look up user preferences',
	'lookupuser-toollinks' => '',
	'lookupuser-table-title' => 'Title',
	'lookupuser-table-url' => 'URL',
	'lookupuser-table-lastedited' => 'Last edited',
	'lookupuser-table-contribs' => 'contribs',
	'lookupuser-table-recordspager' => 'Showing \'\'\'$1\'\'\' to \'\'\'$2\'\'\' of \'\'\'$3\'\'\' records.',
	'lookupuser-table-editcount' => 'Edits',
	'lookupuser-table-userrights' => 'User rights',
	'lookupuser-table-blocked' => 'Blocked',
	'lookupuser-admin' => 'Admin',
	'lookupuser-bureaucrat' => 'Bureaucrat',
	'lookupuser-chatmoderator' => 'Chat moderator',
	'lookupuser-username-blocked-globally' => 'This username <strong>is</strong> blocked globally.',
	'lookupuser-username-not-blocked-globally' => 'This username <strong>is not</strong> blocked globally.',
	'lookupuser-user-allowed-adoption' => 'This user is allowed to auto-adopt.',
	'lookupuser-user-not-allowed-adoption' => 'This user is not allowed to auto-adopt.',
	'lookupuser-founder' => 'Founder',
	'lookupuser-table-cannot-be-displayed' => 'The contribution table cannot be displayed -- its extension seems to be disabled.',
	'lookupuser-account-status' => 'Account Status: ',
	'lookupuser-account-status-tempuser' => 'Temp User',
	'lookupuser-account-status-realuser' => 'Real User',
	'action-lookupuser' => 'lookup user information',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author Fryed-peach
 * @author Purodha
 * @author SVG
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'lookupuser' => 'Name of Special:LookupUser in Special:SpecialPages and title of Special:LookupUser page',
	'lookupuser-desc' => '{{desc}}',
	'lookupuser-intro' => 'Short howto use introduction',
	'lookupuser-nonexistent' => 'Error message which is shown when selected user does not exist',
	'lookupuser-authenticated' => '{{Identical|emailauthenticated}}',
	'lookupuser-not-authenticated' => '{{Identical|emailnotauthenticated}}',
	'lookupuser-id' => '{{Identical|User ID}}',
	'lookupuser-email' => 'Link to Email search on Zendesk. $1 is the user\'s email address, $2 is the URL encoded email address.',
	'lookupuser-no-email' => '{{Identical|Notprovided}}',
	'lookupuser-email-change-requested' => 'Text shown when user is in the process of changing their email address. $1 is the email address they are changing their registered email address to.',
	'lookupuser-realname' => 'Real name of the selected user',
	'lookupuser-registration' => '{{Identical|prefs-registration}}, {{Identical|prefs-registration-date-time}}',
	'lookupuser-no-registration' => 'If no registration date about the selected user is available',
	'lookupuser-touched' => 'Date of user’s last login',
	'lookupuser-info-authenticated' => 'E-mail authentication date and time',
	'lookupuser-useroptions' => 'User’s options',
	'lookupuser-foundmoreusers' => 'Message which will be shown when more than one user is found',
	'right-lookupuser' => '{{doc-right|lookupuser}}',
	'lookupuser-account-status' => 'The user\'s account status',
	'lookupuser-account-status-tempuser' => 'The status of a temporary user account that hasn\'t been confirmed yet',
	'lookupuser-account-status-realuser' => 'The status of a real user account',
	'action-lookupuser' => '{{doc-action|lookupuser}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'lookupuser' => 'Kyk gebruikersinliging op',
	'lookupuser-intro' => "Sleutel 'n gebruikersnaam in om die gebruiker se voorkeure te sien.",
	'lookupuser-nonexistent' => 'Fout: Gebruiker bestaan nie',
	'lookupuser-id' => 'Gebruiker-ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-posadres: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nie verskaf nie',
	'lookupuser-realname' => 'Regte naam: $1',
	'lookupuser-registration' => 'Registrasiedatum: $1',
	'lookupuser-no-registration' => 'nie aangeteken nie',
	'lookupuser-useroptions' => 'Gebruikersopsies:',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'lookupuser' => 'ابحث عن معلومات المستخدم',
	'lookupuser-desc' => '[[Special:LookupUser|يعرض معلومات]] عن المستخدم مثل عنوان البريد الإلكتروني والرقم',
	'lookupuser-intro' => 'أدخل اسم مستخدم لرؤية تفضيلات هذا المستخدم.',
	'lookupuser-nonexistent' => 'المستخدم غير موجود',
	'lookupuser-authenticated' => 'تأكيد البريد الإلكتروني: $1',
	'lookupuser-not-authenticated' => 'غير مرخص',
	'lookupuser-id' => 'رقم المستخدم: <tt>#$1</tt>',
	'lookupuser-email' => 'البريد الإلكتروني: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'غير موفر',
	'lookupuser-realname' => 'الاسم الحقيقي: $1',
	'lookupuser-registration' => 'تاريخ التسجيل: $1',
	'lookupuser-no-registration' => 'غير مسجل',
	'lookupuser-touched' => 'سجل المستخدم تم تعديله آخر مرة في: $1',
	'lookupuser-info-authenticated' => 'توكيد البريد الإلكتروني: $1',
	'lookupuser-useroptions' => 'خيارات المستخدم:',
	'right-lookupuser' => 'مطالعة تفضيلات المستخدم',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 * @author Michaelovic
 */
$messages['arc'] = array(
	'lookupuser-realname' => 'ܫܡܐ ܫܪܝܪܐ: $1',
	'lookupuser-useroptions' => 'ܓܒܝܬ̈ܐ ܕܡܦܠܚܢܐ:',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ouda
 */
$messages['arz'] = array(
	'lookupuser' => 'ابحث عن معلومات المستخدم',
	'lookupuser-desc' => '[[Special:LookupUser|يعرض معلومات]] عن المستخدم مثل عنوان البريد الإلكترونى والرقم',
	'lookupuser-intro' => 'أدخل اسم مستخدم لرؤية تفضيلات هذا المستخدم.',
	'lookupuser-nonexistent' => 'المستخدم غير موجود',
	'lookupuser-authenticated' => 'تأكيد البريد الإلكتروني: $1',
	'lookupuser-not-authenticated' => 'غير مرخص',
	'lookupuser-id' => 'رقم المستخدم: <tt>#$1</tt>',
	'lookupuser-email' => 'البريد الإلكتروني: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'غير موفر',
	'lookupuser-realname' => 'الاسم الحقيقي: $1',
	'lookupuser-registration' => 'تاريخ التسجيل: $1',
	'lookupuser-no-registration' => 'غير مسجل',
	'lookupuser-touched' => 'سجل المستخدم تم تعديله آخر مرة في: $1',
	'lookupuser-info-authenticated' => 'تأكيد البريد الإلكتروني: $1',
	'lookupuser-useroptions' => 'خيارات المستخدم:',
	'right-lookupuser' => 'مطالعة تفضيلات المستخدم',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'lookupuser' => 'Пошук зьвестак пра ўдзельніка',
	'lookupuser-desc' => '[[Special:LookupUser|Атрыманьне зьвестак]] пра удзельнікаў, такіх, як адрас электроннай пошты і ідэнтыфікатар',
	'lookupuser-intro' => 'Увядзіце імя ўдзельніка каб праглядзець яго налады. Можна ўвесьці адрас электроннай пошты — будуць паказаныя ўсе рахункі, якія выкарыстоўваюць гэты адрас.',
	'lookupuser-nonexistent' => 'Памылка: Удзельнік не існуе',
	'lookupuser-authenticated' => 'аўтэнтыфікаваны па $1',
	'lookupuser-not-authenticated' => 'не аўтэнтыфікаваны',
	'lookupuser-id' => 'Ідэнтыфікатар удзельніка: <tt>#$1</tt>',
	'lookupuser-email' => 'Электронная пошта: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'не пазначана',
	'lookupuser-realname' => 'Сапраўднае імя: $1',
	'lookupuser-registration' => 'Дата рэгістрацыі: $1',
	'lookupuser-no-registration' => 'не запісаны',
	'lookupuser-touched' => 'Апошнія абнаўленьні зьвестак пра удзельніка: $1',
	'lookupuser-info-authenticated' => 'Аўтэнтыфікацыя электроннай пошты: $1',
	'lookupuser-useroptions' => 'Налады ўдзельніка:',
	'lookupuser-foundmoreusers' => 'Знойдзена больш за аднаго ўдзельніка:',
	'right-lookupuser' => 'пошук зьвестак пра удзельнікаў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'lookupuser' => 'Извличане на потребителска информация',
	'lookupuser-desc' => '[[Special:LookupUser|Извлича информация]] за потребител - електронна поща, потребителски номер и др.',
	'lookupuser-intro' => 'Въведете потребителско име за да видите предпочитанията и настройките на потребителя.',
	'lookupuser-nonexistent' => 'Грешка: Потребителят не съществува',
	'lookupuser-authenticated' => 'Потвърждение на е-поща: $1',
	'lookupuser-id' => 'Потребителски номер: <tt>#$1</tt>',
	'lookupuser-email' => 'Е-поща: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-realname' => 'Име и фамилия: $1',
	'lookupuser-registration' => 'Дата на регистрация: $1',
	'lookupuser-touched' => 'Последна промяна на потребителските настройки: $1',
	'lookupuser-useroptions' => 'Потребителски настройки:',
	'right-lookupuser' => 'Изследване на потребителските предпочитания',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'lookupuser' => 'ব্যবহারকারী তথ্যাদি দেখুন',
	'lookupuser-intro' => 'কোনো ব্যবহারকারীর পছন্দ দেখতে ঐ ব্যবহারকারীর নাম প্রবেশ করান।',
	'lookupuser-nonexistent' => 'ত্রুটি: এই নামে কোনো ব্যবহারকারী নেই',
	'lookupuser-authenticated' => '$1-এ নিশ্চিতকৃত',
	'lookupuser-not-authenticated' => 'নিশ্চিতকৃত নয়',
	'lookupuser-id' => 'ব্যবহারকারী আইডি: <tt>#$1</tt>',
	'lookupuser-email' => 'ই-মেইল: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'দেয়া হয়নি',
	'lookupuser-realname' => 'প্রকৃত নাম: $1',
	'lookupuser-registration' => 'নিবন্ধনের তারিখ: $1',
	'lookupuser-no-registration' => 'রেকর্ডকৃত নয়',
	'lookupuser-info-authenticated' => 'ই-মেইল নিশ্চিতকরণ: $1',
	'lookupuser-useroptions' => 'ব্যবহারকারী অপশন:',
	'right-lookupuser' => 'ব্যবহারকারীর পছন্দ দেখুন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'lookupuser' => 'Sellet ouzh titouroù an implijer',
	'lookupuser-desc' => "[[Special:LookupUser|Adpakañ a ra an titouroù]] a denn d'un implijer bennak evel ar chomlec'h postel hag an niverenn ID",
	'lookupuser-intro' => "Merkañ un anv implijer da sellet ouzh e benndibaboù. Gallout a reer implijout ur chomlec'h postel ivez; diskouez a raio an holl gontoù stag ouzh ar postel-se.",
	'lookupuser-nonexistent' => "Fazi : n'eus ket eus an implijer-mañ",
	'lookupuser-authenticated' => 'Aotreet e $1',
	'lookupuser-not-authenticated' => "n'eo ket aotreet",
	'lookupuser-id' => 'ID an implijer : <tt>#$1</tt>',
	'lookupuser-email' => 'Postel : [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => "N'eo ket bet pourchaset",
	'lookupuser-realname' => 'Anv gwir : $1',
	'lookupuser-registration' => 'Deiziad enrollañ : $1',
	'lookupuser-no-registration' => "n'eo ket enrollet",
	'lookupuser-touched' => 'Enrolladenn an implijer bet tizhet da ziwezhañ : $1',
	'lookupuser-info-authenticated' => 'Gwiriañ ar postel : $1',
	'lookupuser-useroptions' => 'Dibarzhioù an implijer :',
	'lookupuser-foundmoreusers' => 'Kavet ez eus bet meur a implijer :',
	'right-lookupuser' => 'Sellet ouzh ar penndibaboù implijout',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'lookupuser' => 'Pretraga podataka o korisniku',
	'lookupuser-desc' => '[[Special:LookupUser|Traženje podataka]] o korisniku poput e-mail adresa i ID',
	'lookupuser-intro' => 'Unesite korisničko ime da biste vidjeli postavke tog korisnika.',
	'lookupuser-nonexistent' => 'Greška: Korisnik ne postoji',
	'lookupuser-authenticated' => 'potvrđeno $1',
	'lookupuser-not-authenticated' => 'nije potvrđeno',
	'lookupuser-id' => 'Korisnički ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nije naveden',
	'lookupuser-realname' => 'Pravo ime: $1',
	'lookupuser-registration' => 'Datum registracije: $1',
	'lookupuser-no-registration' => 'nije zabilježen',
	'lookupuser-touched' => 'Korisnički zapis posljednji pogledan: $1',
	'lookupuser-info-authenticated' => 'Potvrđen e-mailom: $1',
	'lookupuser-useroptions' => 'Korisničke postavke:',
	'right-lookupuser' => 'Pretraga korisničkih postavki',
);

/** Catalan (Català)
 * @author SMP
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'lookupuser-no-email' => 'no proporcionat',
	'lookupuser-realname' => 'Nom real: $1',
	'lookupuser-registration' => 'Data de registre: $1',
	'lookupuser-no-registration' => 'no guardat',
	'lookupuser-info-authenticated' => "Autenticació de l'adreça electrònica: $1",
	'lookupuser-useroptions' => "Opcions d'usuari:",
	'right-lookupuser' => "Consultar les preferències d'usuari",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'right-lookupuser' => 'лаха декъашхойн нисдарш',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'lookupuser' => 'Vyhledat informace o uživateli',
	'lookupuser-desc' => '[[Special:LookupUser|Získání informací]] o uživateli jako e-mailová adresa a ID',
	'lookupuser-intro' => 'Zadejte uživatelské jméno uživatele, kterého nastavení chcete zobrazit.',
	'lookupuser-nonexistent' => 'Chyba: Uživatel neexistuje',
	'lookupuser-authenticated' => 'Ověření e-mailu: $1',
	'lookupuser-not-authenticated' => 'neověřený',
	'lookupuser-id' => 'ID uživatele: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nebyl poskytnut',
	'lookupuser-realname' => 'Skutečné jméno: $1',
	'lookupuser-registration' => 'Datum registrace: $1',
	'lookupuser-no-registration' => 'nebyl zaznamenán',
	'lookupuser-touched' => 'Poslední záznam uživatele: $1',
	'lookupuser-info-authenticated' => 'Ověření emailu: $1',
	'lookupuser-useroptions' => 'Nastavení uživatele:',
	'right-lookupuser' => 'Prohlížení nastavení jiných uživatelů',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'lookupuser-email' => 'E-bost: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
);

/** German (Deutsch)
 * @author Kghbln
 * @author LWChris
 * @author Melancholie
 * @author SVG
 * @author Umherirrender
 */
$messages['de'] = array(
	'lookupuser' => 'Benutzerinformationen einsehen',
	'lookupuser-desc' => 'Ergänzt eine [[Special:LookupUser|Spezialseite]] mit der Informationen zu einem Benutzer eingesehen werden können',
	'lookupuser-intro' => 'Bitte einen Benutzernamen angeben, um die persönlichen Einstellungen des zugehörigen Benutzers anzusehen. Es kann auch eine E-Mail-Adresse angegeben werden, wobei dann alle Benutzerkonten angezeigt werden, die diese E-Mail-Adresse nutzen.',
	'lookupuser-nonexistent' => 'Fehler: Benutzer nicht vorhanden',
	'lookupuser-authenticated' => 'E-Mail-Bestätigung: $1',
	'lookupuser-not-authenticated' => 'nicht bestätigt',
	'lookupuser-id' => 'Benutzerkennung: <tt>#$1</tt>',
	'lookupuser-email' => 'E-Mail-Adresse: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nicht angegeben',
	'lookupuser-realname' => 'Bürgerlicher Name: $1',
	'lookupuser-registration' => 'Datum der Registrierung: $1',
	'lookupuser-no-registration' => 'nicht verzeichnet',
	'lookupuser-touched' => 'Letzte Aktualisierung der Benutzerdaten: $1',
	'lookupuser-info-authenticated' => 'E-Mail-Bestätigung: $1',
	'lookupuser-useroptions' => 'Einstellungen des Benutzerkontos:',
	'lookupuser-foundmoreusers' => 'Es wurde mehr als ein Benutzer gefunden:',
	'right-lookupuser' => 'Benutzereinstellungen anderer Benutzer einsehen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'lookupuser' => 'Wužywarske informacije póglědaś',
	'lookupuser-desc' => '[[Special:LookupUser|Informacije wó wužywarju]] kaž e-mailowu adresu a ID wótwołaś',
	'lookupuser-intro' => 'Zapódaj wužywarske mě, aby se nastajenja togo wužywarja woglědał. E-mailowa adresa dajo se teke wužywaś a wšykne konta, kótarež wužywaju toś tu e-mailowu adresu, b udu se pokazowaś.',
	'lookupuser-nonexistent' => 'Zmólka: Wužywaŕ njeeksistěrujo.',
	'lookupuser-authenticated' => 'E-mailowa awtentifikacija: $1',
	'lookupuser-not-authenticated' => 'njeawtentificěrowany',
	'lookupuser-id' => 'ID wužywarja: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'njepódany',
	'lookupuser-realname' => 'Napšawdne mě: $1',
	'lookupuser-registration' => 'Datum registrěrowanja: $1',
	'lookupuser-no-registration' => 'njenagrany',
	'lookupuser-touched' => 'Wužywarske daty slědny raz dotyknjone: $1',
	'lookupuser-info-authenticated' => 'E-mailowa awtentifikacija: $1',
	'lookupuser-useroptions' => 'Wužywarske nastajenja:',
	'lookupuser-foundmoreusers' => 'Jo se wěcej ako jaden wužywaŕ namakał:',
	'right-lookupuser' => 'Wužywarske nastajenja se woglědaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'lookupuser' => 'Αναζήτηση πληροφοριών για τον χρήστη',
	'lookupuser-desc' => '[[Special:LookupUser|Ανάκτηση πληροφοριών]] σχετικά με ένα χρήστη σαν την ηλεκτρονική του διεύθυνση και την ταυτότητα such as e-mail address and ID',
	'lookupuser-intro' => 'Εισάγετε ένα όνομα χρήστη για να εμφανιστούν οι προτιμήσεις αυτού του χρήστη.',
	'lookupuser-nonexistent' => 'Σφάλμα: Ο Χρήστης δεν υπάρχει',
	'lookupuser-authenticated' => 'επιβεβαιωμένο στο $1',
	'lookupuser-not-authenticated' => 'μη επικυρωμένος',
	'lookupuser-id' => 'Ταυτότητα χρήστη: <tt>#$1</tt>',
	'lookupuser-email' => 'Ηλεκτρονικό μήνυμα: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'μη διαθέσιμο',
	'lookupuser-realname' => 'Πραγματικό όνομα: $1',
	'lookupuser-registration' => 'Ημερομηνία εγγραφής: $1',
	'lookupuser-no-registration' => 'μη καταγεγραμμένο',
	'lookupuser-touched' => 'Το ρεκόρ χρήστη άλλαξε τελευταία: $1',
	'lookupuser-info-authenticated' => 'Επιβεβαίωση ηλεκτρονικής διεύθυνσης: $1',
	'lookupuser-useroptions' => 'Επιλογές χρήστη:',
	'right-lookupuser' => 'Δείτε τις προτιμήσεις χρήστη',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'lookupuser' => 'Konsulti informon pri uzanto',
	'lookupuser-desc' => '[[Special:LookupUser|Konsulti informon]] pri uzanto kiel retadreso kaj identigo',
	'lookupuser-intro' => 'Enigi salutnomo rigardi la preferojn de tiu uzanto.',
	'lookupuser-nonexistent' => 'Eraro: Tiu uzanto ne ekzistas',
	'lookupuser-authenticated' => 'retpoŝta aŭtentkontrolo: $1',
	'lookupuser-not-authenticated' => 'ne aŭtentita',
	'lookupuser-id' => 'Salutnomo: <tt>#$1</tt>',
	'lookupuser-email' => 'Retpoŝto: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'ne provizita',
	'lookupuser-realname' => 'Reala nomo: $1',
	'lookupuser-registration' => 'Dato de registrado: $1',
	'lookupuser-no-registration' => 'ne registrita',
	'lookupuser-touched' => 'Rikordo de uzanto estis laste ŝanĝita: $1',
	'lookupuser-info-authenticated' => 'Retpoŝta aŭtentokontrolo: $1',
	'lookupuser-useroptions' => 'Opcioj de uzanto:',
	'right-lookupuser' => 'Trarigardi agordojn de uzantoj',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 */
$messages['es'] = array(
	'lookupuser' => 'Ver información de usuario',
	'lookupuser-desc' => '[[Special:LookupUser|Recuperar información]] sobre un usuario tal como correo electrónico y ID',
	'lookupuser-intro' => 'Ingrese un nombre de usuario para ver las preferencias de ese usuario.',
	'lookupuser-nonexistent' => 'Error: Usuario no existe',
	'lookupuser-authenticated' => 'autenticado en $1',
	'lookupuser-not-authenticated' => 'no autenticado',
	'lookupuser-id' => 'ID de usuario: <tt>#$1</tt>',
	'lookupuser-email' => 'Correo electrónico: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'no proveído',
	'lookupuser-realname' => 'Nombre real: $1',
	'lookupuser-registration' => 'Fecha de registro: $1',
	'lookupuser-no-registration' => 'no grabado',
	'lookupuser-touched' => 'Registro de usuario tocado por último: $1',
	'lookupuser-info-authenticated' => 'Autenticación de correo electrónico: $1',
	'lookupuser-useroptions' => 'Opciones de usuario:',
	'right-lookupuser' => 'Ver preferencias de usuario',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'lookupuser-realname' => 'Õige nimi: $1',
	'lookupuser-registration' => 'Registreerimise kuupäev: $1',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'lookupuser-realname' => 'Benetako izena: $1',
	'lookupuser-registration' => 'Erregistratzeko unea: $1',
);

/** Persian (فارسی)
 * @author Huji
 * @author Persianizer
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'lookupuser' => 'نگاه کردن به اطلاعات کاربر',
	'lookupuser-desc' => '[[Special:LookupUser|به دست آوردن اطلاعات]] در مورد یک کاربر نظیر نشانی پست الکترونیکی و ID',
	'lookupuser-intro' => 'یک نام کاربری وارد کنید تا تنظیمات آن کاربر را ببینید.',
	'lookupuser-nonexistent' => 'خطا: کاربر وجود ندارد',
	'lookupuser-authenticated' => 'اعتبارداده‌شده روی $1',
	'lookupuser-not-authenticated' => 'فاقد اعتبار',
	'lookupuser-id' => 'نام کاربری: <tt>#$1</tt>',
	'lookupuser-email' => 'پست الکترونیکی: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'تامین نشده',
	'lookupuser-realname' => 'نام حقیقی: $1',
	'lookupuser-registration' => 'تاریخ ثبت‌نام: $1',
	'lookupuser-no-registration' => 'ثبت نشده',
	'lookupuser-touched' => 'آخرین دستکاری در اطلاعات کاربر: $1',
	'lookupuser-info-authenticated' => 'فعال‌سازی پست الکترونیکی: $1',
	'lookupuser-useroptions' => 'گزینه‌های کاربر:',
	'lookupuser-foundmoreusers' => 'بیش از یک کاربر یافت شد:',
	'right-lookupuser' => 'مراجعه به ترجیحات کاربر',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jaakonam
 * @author Nike
 * @author Tarmo
 */
$messages['fi'] = array(
	'lookupuser' => 'Katso käyttäjän tiedot',
	'lookupuser-desc' => '[[Special:LookupUser|Hakee tietoja]] käyttäjästä, kuten sähköpostiosoitteen ja tunnisteen.',
	'lookupuser-intro' => 'Anna käyttäjätunnus, jonka asetukset haluat nähdä.',
	'lookupuser-nonexistent' => 'Virhe: Käyttäjää ei ole olemassa',
	'lookupuser-authenticated' => 'tunnistettu osoite $1',
	'lookupuser-not-authenticated' => 'ei tunnistettu',
	'lookupuser-id' => 'Tunniste: <tt>#$1</tt>',
	'lookupuser-email' => 'Sähköposti: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'ei annettu',
	'lookupuser-realname' => 'Oikea nimi: $1',
	'lookupuser-registration' => 'Rekisteröitymispäivämäärä: $1',
	'lookupuser-no-registration' => 'ei tallennettu',
	'lookupuser-touched' => 'Käyttäjätietoja viimeksi muutettu: $1',
	'lookupuser-info-authenticated' => 'Sähköpostitunnistus: $1',
	'lookupuser-useroptions' => 'Käyttäjävalinnat:',
	'right-lookupuser' => 'Hakea käyttäjän asetuksia',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'lookupuser' => 'Parcourir les informations de l’usager',
	'lookupuser-desc' => 'Extrait les informations concernant un utilisateur telles qu’une adresse électronique et le numéro ID',
	'lookupuser-intro' => 'Entrez un nom d’utilisateur pour afficher ses préférences. Une adresse de courriel peut également être utilisée et affichera tous les comptes qui utilisent cette adresse.',
	'lookupuser-nonexistent' => 'Erreur : l’utilisateur n’existe pas',
	'lookupuser-authenticated' => 'Courriel d’identification : $1',
	'lookupuser-not-authenticated' => 'pas identifié',
	'lookupuser-id' => 'ID de l’utilisateur : <tt>#$1</tt>',
	'lookupuser-email' => 'Courriel : [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'non fourni',
	'lookupuser-realname' => 'Nom réel : $1',
	'lookupuser-registration' => 'Date d’enregistrement : $1',
	'lookupuser-no-registration' => 'non enregistré',
	'lookupuser-touched' => 'Enregistrement de l’utilisateur touché pour la dernière fois : $1',
	'lookupuser-info-authenticated' => 'Authentification du courriel : $1',
	'lookupuser-useroptions' => 'Options de l’utilisateur :',
	'lookupuser-foundmoreusers' => "Plus d'un utilisateur trouvé :",
	'right-lookupuser' => 'Visionner les préférences des utilisateurs',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'lookupuser' => 'Parcorir les enformacions a l’utilisator',
	'lookupuser-nonexistent' => 'Èrror : l’utilisator ègziste pas',
	'lookupuser-authenticated' => 'ôtenticâ dessus $1',
	'lookupuser-not-authenticated' => 'pas ôtenticâ',
	'lookupuser-id' => 'Numerô a l’utilisator : <tt>#$1</tt>',
	'lookupuser-email' => 'Mèl. : [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'pas balyê',
	'lookupuser-realname' => 'Veré nom : $1',
	'lookupuser-registration' => 'Dâta d’encartâjo : $1',
	'lookupuser-no-registration' => 'pas encartâ',
	'lookupuser-touched' => 'Encartâjo a l’utilisator tochiê por lo dèrriér côp : $1',
	'lookupuser-info-authenticated' => 'Ôtenticacion de l’adrèce èlèctronica : $1',
	'lookupuser-useroptions' => 'Chouèx a l’utilisator :',
	'right-lookupuser' => 'Vêre les prèferences ux utilisators',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'lookupuser' => 'Consultar a información do usuario',
	'lookupuser-desc' => '[[Special:LookupUser|Recuperar información]] sobre un usuario como o enderezo de correo electrónico e o ID',
	'lookupuser-intro' => 'Introduza un nome de usuario para ver as preferencias dese usuario. Tamén se poden usar enderezos de correo electrónico e aparecerán todas as contas que empregan ese enderezo.',
	'lookupuser-nonexistent' => 'Erro: O usuario non existe',
	'lookupuser-authenticated' => 'autenticado o $1',
	'lookupuser-not-authenticated' => 'sen autenticar',
	'lookupuser-id' => 'ID do usuario: <tt>nº$1</tt>',
	'lookupuser-email' => 'Correo electrónico: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'non proporcionado',
	'lookupuser-realname' => 'Nome real: $1',
	'lookupuser-registration' => 'Data de rexistro: $1',
	'lookupuser-no-registration' => 'non rexistrado',
	'lookupuser-touched' => 'Rexistro do usuario tocado por última vez: $1',
	'lookupuser-info-authenticated' => 'Autenticación por correo electrónico: $1',
	'lookupuser-useroptions' => 'Opcións do usuario:',
	'lookupuser-foundmoreusers' => 'Atopouse máis dun usuario:',
	'right-lookupuser' => 'Consultar as preferencias dun usuario',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'lookupuser' => 'Benutzerinformatione aaluege',
	'lookupuser-desc' => '[[Special:LookupUser|Informatione]] iber Benutzer iberchu, z. B. E-Mail-Adräss oder ID.',
	'lookupuser-intro' => 'Gib e Benutzername yy, go di persenlige Yystellige vu däm Benutzer aaluege. Es cha au e E-Mail-Adräss aagee werde, wo deno alli Chonte aazeigt, wo die E-Mail-Adräss bruuche.',
	'lookupuser-nonexistent' => 'Fähler: Benutzer git s nit',
	'lookupuser-authenticated' => 'E-Mail-Bstätigung: $1',
	'lookupuser-not-authenticated' => 'nit bstätigt',
	'lookupuser-id' => 'Benutzer-ID: <tt>$1</tt>',
	'lookupuser-email' => 'E-Mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'git s nit',
	'lookupuser-realname' => 'Wirklige Name: $1',
	'lookupuser-registration' => 'Datum vu dr Regischtrierig: $1',
	'lookupuser-no-registration' => 'nit verzeichnet',
	'lookupuser-touched' => 'Benutzerkonto s letscht Mol aaglängt: $1',
	'lookupuser-info-authenticated' => 'E-Mail-Bstätigung: $1',
	'lookupuser-useroptions' => 'Yystellige vum Benutzerkonto:',
	'lookupuser-foundmoreusers' => 'Es isch mee wie ei Benutzer gfunde worde:',
	'right-lookupuser' => 'Suech no Benutzer Yystellige',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'lookupuser-realname' => 'Feer-ennym: $1',
);

/** Hebrew (עברית)
 * @author Nirofir
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'lookupuser' => 'בדיקת נתוני משתמש',
	'lookupuser-desc' => '[[Special:LookupUser|בדיקת נתונים]] אודות משתמש כגון כתובת הדוא"ל ומספר המשתמש',
	'lookupuser-intro' => 'נא כתבו את שם המשתמש כדי לצפות בהעדפות שלו.',
	'lookupuser-nonexistent' => 'שגיאה: המשתמש אינו קיים',
	'lookupuser-authenticated' => 'אימות כתובת דוא"ל: $1',
	'lookupuser-not-authenticated' => 'לא מאומתת',
	'lookupuser-id' => 'מספר המשתמש: <tt>#$1</tt>',
	'lookupuser-email' => 'כתובת דוא"ל: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'לא סופקה',
	'lookupuser-realname' => 'שם אמיתי: $1',
	'lookupuser-registration' => 'תאריך ההרשמה: $1',
	'lookupuser-no-registration' => 'לא נשמר',
	'lookupuser-touched' => 'הפעם האחרונה בה ביצעו פעולה במידע המשתמש: $1',
	'lookupuser-info-authenticated' => 'אימות כתובת דוא"ל: $1',
	'lookupuser-useroptions' => 'אפשרויות המשתמש:',
	'lookupuser-foundmoreusers' => 'נמצאו יותר ממשתמש אחד:',
	'right-lookupuser' => 'בדיקת העדפות משתמש',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'lookupuser' => 'सदस्य ज़ानकारी खोजें',
	'lookupuser-desc' => 'एक सदस्यकी [[Special:LookupUser|अधिक ज़ानकारी खोजें]] उदा. इमेल एड्रेस और सदस्य क्रमांक',
	'lookupuser-intro' => 'एक सदस्यकी वरीयतायें देखने के लिये उसका नाम लिखें।',
	'lookupuser-nonexistent' => 'गलती: सदस्य अस्तित्वमें नहीं हैं',
	'lookupuser-authenticated' => 'इ-मेल प्रमाणिकरण: $1',
	'lookupuser-not-authenticated' => 'जाँच पूरी नहीं हुई हैं',
	'lookupuser-id' => 'सदस्य क्रमांक: <tt>#$1</tt>',
	'lookupuser-email' => 'इ-मेल: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'नहीं दिया हैं',
	'lookupuser-realname' => 'असली नाम: $1',
	'lookupuser-registration' => 'पंजिकरण तिथी: $1',
	'lookupuser-no-registration' => 'रेकार्डमें नहीं हैं',
	'lookupuser-touched' => 'देखी हुआ आखिरी सदस्य रेकार्ड: $1',
	'lookupuser-useroptions' => 'सदस्य विकल्प:',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Ex13
 */
$messages['hr'] = array(
	'lookupuser' => 'Pogledaj info suradnika',
	'lookupuser-desc' => '[[Special:LookupUser|Omogućava gledanje]] informacija o suradniku poput e-mail adrese ili ID broja',
	'lookupuser-intro' => 'Upišite suradničko ime da biste vidjeli njegove postavke.',
	'lookupuser-nonexistent' => 'Greška: Suradnik ne postoji',
	'lookupuser-authenticated' => 'E-mail potvrda: $1',
	'lookupuser-not-authenticated' => 'nije potvrđen',
	'lookupuser-id' => 'Suradnički ID-broj: <tt>#$1</tt>',
	'lookupuser-email' => 'Elektronička pošta: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nije upisana',
	'lookupuser-realname' => 'Pravo ime: $1',
	'lookupuser-registration' => 'Datum registracije: $1',
	'lookupuser-no-registration' => 'nije zabilježeno',
	'lookupuser-touched' => 'Suradnički račun zadnji put korišten: $1',
	'lookupuser-info-authenticated' => 'E-mail potvrda: $1',
	'lookupuser-useroptions' => 'Suradničke postavke:',
	'right-lookupuser' => 'Pogledaj suradničke postavke',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'lookupuser' => 'Wužiwarske informacije sej wobhladać',
	'lookupuser-desc' => '[[Special:LookupUser|Informacije wo wužiwarja wotwołać]], na přikład e-mejlowu adresu a ID',
	'lookupuser-intro' => 'Zapodaj wužiwarske mjeno, zo by nastajenja toho wužiwarja wobhladał. E-mejlowa adresa móže so tež wužiwać a budźe wšě konta pokazować, kotrež tutu e-mejlowu adresu wužiwaja.',
	'lookupuser-nonexistent' => 'Zmylk: Wužiwar njeeksistuje',
	'lookupuser-authenticated' => 'E-mejlowe awtentizowanje: $1',
	'lookupuser-not-authenticated' => 'njeawtentizowany',
	'lookupuser-id' => 'Wužiwarski ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mejl: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'njepodaty',
	'lookupuser-realname' => 'Woprawdźite mjeno: $1',
	'lookupuser-registration' => 'Datum registrowanja: $1',
	'lookupuser-no-registration' => 'njezapřijaty',
	'lookupuser-touched' => 'Posledni přistup na wužiwarske daty: $1',
	'lookupuser-info-authenticated' => 'E-mejlowa awtentifikacija: $1',
	'lookupuser-useroptions' => 'Wužiwarske opcije:',
	'lookupuser-foundmoreusers' => 'Je so wjace hač jedyn wužiwar namakał:',
	'right-lookupuser' => 'Wužiwarske nastajenja sej wobhladać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author Tgr
 */
$messages['hu'] = array(
	'lookupuser' => 'Felhasználói információ keresése',
	'lookupuser-desc' => '[[Special:LookupUser|Információ lekérése]] egy adott felhasználóról, például annak e-mail címe vagy azonosítója',
	'lookupuser-intro' => 'Add meg a felhasználó nevét, akinek meg szeretnéd nézni a beállításait.',
	'lookupuser-nonexistent' => 'Hiba: a felhasználó nem létezik',
	'lookupuser-authenticated' => 'Email megerősítés: $1',
	'lookupuser-not-authenticated' => 'nincs megerősítve',
	'lookupuser-id' => 'Azonosító: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nincs megadva',
	'lookupuser-realname' => 'Valódi név: $1',
	'lookupuser-registration' => 'Regisztráció időpontja: $1',
	'lookupuser-no-registration' => 'nincs feljegyezve',
	'lookupuser-touched' => 'Utolsó hozzáférés ideje: $1',
	'lookupuser-info-authenticated' => 'Megerősített e-mail cím: $1',
	'lookupuser-useroptions' => 'Beállításai:',
	'right-lookupuser' => 'felhasználó beállításainak megtekintése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'lookupuser' => 'Cercar info de usator',
	'lookupuser-desc' => '[[Special:LookupUser|Recupera informationes]] super un usator como adresse de e-mail e numero de ID',
	'lookupuser-intro' => 'Entra un nomine de usator pro vider le preferentias de ille usator. Un adresse de e-mail pote anque esser usate, e monstrara tote le contos que usa ille adresse.',
	'lookupuser-nonexistent' => 'Error: Usator non existe',
	'lookupuser-authenticated' => 'Authentication de e-mail: $1',
	'lookupuser-not-authenticated' => 'non authenticate',
	'lookupuser-id' => 'ID del usator: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'non fornite',
	'lookupuser-realname' => 'Nomine real: $1',
	'lookupuser-registration' => 'Data de registration: $1',
	'lookupuser-no-registration' => 'non disponibile',
	'lookupuser-touched' => 'Ultime alteration del informationes del usator: $1',
	'lookupuser-info-authenticated' => 'Authentication de e-mail: $1',
	'lookupuser-useroptions' => 'Optiones del usator:',
	'lookupuser-foundmoreusers' => 'Plure usatores trovate:',
	'right-lookupuser' => 'Consultar preferentias de usatores',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'lookupuser' => 'Mencari informasi pengguna',
	'lookupuser-desc' => '[[Special:LookupUser|Menampilkan informasi]] seorang pengguna seperti alamat surel dan ID',
	'lookupuser-intro' => 'Masukkan nama pengguna untuk melihat daftar preferensinya.',
	'lookupuser-nonexistent' => 'Galat: Pengguna tidak ditemukan',
	'lookupuser-authenticated' => 'di-otentifikasi pada $1',
	'lookupuser-not-authenticated' => 'tidak di-otentifikasi',
	'lookupuser-id' => 'ID Pengguna: <tt>#$1</tt>',
	'lookupuser-email' => 'Surel: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'tidak diberikan',
	'lookupuser-realname' => 'Nama asli: $1',
	'lookupuser-registration' => 'Tanggal pendaftaran: $1',
	'lookupuser-no-registration' => 'tidak dicatat',
	'lookupuser-touched' => 'Catatan pengguna terakhir dilihat: $1',
	'lookupuser-info-authenticated' => 'Otentifikasi surel: $1',
	'lookupuser-useroptions' => 'Pilihan pengguna:',
	'right-lookupuser' => 'Lihat preferensi pengguna',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'lookupuser-nonexistent' => 'Eroro: Uzanto ne existas',
	'lookupuser-realname' => 'Reala nomo: $1',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'lookupuser' => 'Guarda informazioni utente',
	'lookupuser-desc' => '[[Special:LookupUser|Recupera informazioni]] su un utente come indirizzo e-mail e ID',
	'lookupuser-intro' => 'Inserisci un nome utente per visualizzarne le preferenze.',
	'lookupuser-nonexistent' => "Errore: l'utente non esiste",
	'lookupuser-authenticated' => 'Conferma indirizzo e-mail: $1',
	'lookupuser-not-authenticated' => 'non confermato',
	'lookupuser-id' => 'ID utente: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'non fornito',
	'lookupuser-realname' => 'Nome vero: $1',
	'lookupuser-registration' => 'Data di registrazione: $1',
	'lookupuser-no-registration' => 'non disponibile',
	'lookupuser-touched' => "Ultima visita registrata dell'utente: $1",
	'lookupuser-info-authenticated' => 'Autenticazione e-mail: $1',
	'lookupuser-useroptions' => 'Opzioni utente:',
	'right-lookupuser' => 'Consulta le preferenze utente',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'lookupuser' => '利用者情報を調査',
	'lookupuser-desc' => '電子メールアドレスやIDなどの利用者に関する[[Special:LookupUser|情報を取得]]する',
	'lookupuser-intro' => '利用者名を入力して、その利用者の個人設定をみることができます。',
	'lookupuser-nonexistent' => 'エラー: 利用者は存在しません',
	'lookupuser-authenticated' => 'Eメール確認日: $1',
	'lookupuser-not-authenticated' => '確認されてません',
	'lookupuser-id' => '利用者ID: <tt>#$1</tt>',
	'lookupuser-email' => 'Eメール: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => '提供されてません',
	'lookupuser-realname' => '本名: $1',
	'lookupuser-registration' => '登録日: $1',
	'lookupuser-no-registration' => '記録がありません',
	'lookupuser-touched' => '利用者の最終記録: $1',
	'lookupuser-info-authenticated' => 'Eメール認証: $1',
	'lookupuser-useroptions' => '利用者オプション:',
	'right-lookupuser' => '利用者の個人設定を調べる',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'lookupuser-nonexistent' => 'Kaluputan: Panganggo ora ana',
	'lookupuser-authenticated' => 'Pamastèn e-mail: $1',
	'lookupuser-not-authenticated' => 'durung dipastèkaké',
	'lookupuser-id' => 'ID panganggo: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'ora diwènèhaké',
	'lookupuser-realname' => 'Jeneng asli: $1',
	'lookupuser-registration' => 'Tanggal didaftar: $1',
	'lookupuser-no-registration' => 'ora direkam',
	'lookupuser-useroptions' => 'Opsi panganggo:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'lookupuser' => 'រកមើល​ព័ត៌មាន​នៃ​អ្នកប្រើប្រាស់',
	'lookupuser-desc' => '[[Special:LookupUser|ដកស្រង់​ព័ត៌មាន]] អំពី​អ្នកប្រើប្រាស់ ដូចជា​អាសយដ្ឋានអ៊ីមែល និង​អត្តសញ្ញាណ',
	'lookupuser-intro' => 'បញ្ចូល​អត្តនាមអ្នកប្រើប្រាស់នោះ ដើម្បីមើលចំណូលចិត្តនានា​របស់គាត់។',
	'lookupuser-nonexistent' => 'កំហុស៖ អ្នកប្រើប្រាស់មិនមានទេ',
	'lookupuser-authenticated' => 'ភាពពិតប្រាកដនៃអ៊ីមែល៖ $1',
	'lookupuser-not-authenticated' => 'មិនបានស្គាល់ភិនភាគទេ',
	'lookupuser-id' => 'អត្តសញ្ញាណអ្នកប្រើប្រាស់៖<tt>#$1</tt>',
	'lookupuser-email' => 'អ៊ីមែល៖[https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'មិនត្រូវបានផ្តល់ឱ្យ',
	'lookupuser-realname' => 'ឈ្មោះពិត៖$1',
	'lookupuser-registration' => 'កាលបរិច្ឆេទចុះឈ្មោះ​៖ $1',
	'lookupuser-no-registration' => 'មិនបានកត់ត្រាទុកទេ',
	'lookupuser-touched' => 'រក្សាទុក​អ្នកប្រើប្រាស់ ដែលបានប៉ះ​ចុងក្រោយ​៖ $1',
	'lookupuser-info-authenticated' => 'ការពិនិត្យផ្ទៀងផ្ទាត់​អ៊ីមែល: $1',
	'lookupuser-useroptions' => 'ជម្រើសនៃអ្នកប្រើប្រាស់ ៖',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'lookupuser-realname' => '실명: $1',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'lookupuser' => 'Metmaacher-Enfommazjuhne zeije',
	'lookupuser-desc' => 'Donn [[Special:LookupUser|Enfommazjuhne övver ene Metmaacher]] aanzeije, esu jet wi de <i lang="en">e-mail</i> Address udder Metmacher-Nommer.',
	'lookupuser-intro' => 'JJivv enem Metmaacher singe Name aan, öm däm sing Enstellunge aanzeije ze lohße.
Jivv en Addräß för de <i lang="en">e-mail<i> aan, öm all de Metmaachere annzeije ze lohße, di di Addräß för de <i lang="en">e-mail<i> aanjejovve han.',
	'lookupuser-nonexistent' => 'Fähler, esu ene Metmaacher kenne mer nit',
	'lookupuser-authenticated' => 'E-mail bestätich: $1',
	'lookupuser-not-authenticated' => '–unbestätich–',
	'lookupuser-id' => 'Metmaacher-Nommer: <tt>$1</tt>',
	'lookupuser-email' => 'E-mail Address: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => '–nit&nbsp;aanjejovve–',
	'lookupuser-realname' => 'Rechteje Name: $1',
	'lookupuser-registration' => 'Et eets aanjemelldt om: $1',
	'lookupuser-no-registration' => '–nit&nbsp;faßjehallde–',
	'lookupuser-touched' => 'Letz Änderung am Metmaacher-Datesatz: $1',
	'lookupuser-info-authenticated' => 'Bestätesch övver <i lang="en">e-mail</i>: $1',
	'lookupuser-useroptions' => 'Enstellunge:',
	'lookupuser-foundmoreusers' => 'Mer han mieh wi eine Metmaacher jefonge:',
	'right-lookupuser' => 'Enem Metmaacher sing Enstellunge aankike',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'lookupuser' => 'Benotzerinformatiounen nokucken',
	'lookupuser-desc' => '[[Special:LookupUser|Informatioune vun engem Benotzer kréien]] wéi seng E-Mailadress a seng Idendifikatiounsnummer (ID)',
	'lookupuser-intro' => "Gitt e Benotzernumm a fir d'Astellunge vum Benotzer ze kucken. D'Mailadress kann och benotzt ginn a weist all Benotzerkonten déi déi Mailadress benotzen.",
	'lookupuser-nonexistent' => 'Feeler: De Benotzer gëtt et net',
	'lookupuser-authenticated' => 'E-Mail-Confirmatioun: $1',
	'lookupuser-not-authenticated' => 'net identifizéiert',
	'lookupuser-id' => 'Benotzer-Nummer: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'net uginn',
	'lookupuser-realname' => 'Richtegen Numm: $1',
	'lookupuser-registration' => 'Datum vun der Umeldung: $1',
	'lookupuser-no-registration' => 'net enregistréiert',
	'lookupuser-touched' => "Benotzerkont de fir d'lescht beréiert gouf: $1",
	'lookupuser-info-authenticated' => 'E-Mail Authentifikatioun: $1',
	'lookupuser-useroptions' => 'Astellunge vum Benotzer:',
	'lookupuser-foundmoreusers' => 'Méi wéi ee Benotzer fonnt:',
	'right-lookupuser' => 'Benotzerastellungen nokucken',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'lookupuser-email' => 'Eposta: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
);

/** Lumbaart (Lumbaart)
 * @author Dakrismeno
 */
$messages['lmo'] = array(
	'lookupuser' => 'Varda i infurmazión del druvadur',
	'lookupuser-intro' => 'Meta denter un suranom per vedè i sò preferenz.',
	'lookupuser-nonexistent' => "Erur: 'stu druvadur l'esist mía",
	'lookupuser-authenticated' => 'utenticaa del: $1',
	'lookupuser-not-authenticated' => 'mía utenticaa',
	'lookupuser-id' => 'ID del druvadur: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'mía furnii',
	'lookupuser-realname' => 'Nom vér: $1',
	'lookupuser-registration' => 'Registraa dal: $1',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'lookupuser-nonexistent' => 'Klaida: Naudotojo tokiu vardu nėra',
	'lookupuser-id' => 'Naudotojo ID: <tt>#$1</tt>',
	'lookupuser-realname' => 'Tikras vardas: $1',
	'lookupuser-registration' => 'Užsiregistravimo data: $1',
	'lookupuser-no-registration' => 'įrašų nėra',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'lookupuser' => 'Sameklēt informāciju par lietotāju',
	'lookupuser-desc' => '[[Special:LookupUser|Iegūt informāciju]] par lietotāju (piemēram, e-pasta adresi un ID)',
	'lookupuser-intro' => 'Ievadiet lietotājvārdu, lai apslatītu lietotāja uzstādījumus.',
	'lookupuser-nonexistent' => 'Kļūda: Šāda lietotāja nav',
	'lookupuser-authenticated' => 'autentificēts ar $1',
	'lookupuser-not-authenticated' => 'nav autentificēts',
	'lookupuser-id' => 'Lietotāja ID: <tt># $1</tt>',
	'lookupuser-email' => 'E-pasts: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nav sniegts',
	'lookupuser-realname' => 'Īstais vārds: $1',
	'lookupuser-registration' => 'Reģistrācijas datums: $1',
	'lookupuser-no-registration' => 'nav ierakstīts',
	'lookupuser-touched' => 'Lietotāja ierkasts pēdējoreiz pārbaudīts: $1',
	'lookupuser-info-authenticated' => 'E-pasta autentifikācija: $1',
	'lookupuser-useroptions' => 'Lietotājs iespējas:',
	'right-lookupuser' => 'Meklēt lietotāja uzstādījumus',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'lookupuser' => 'Провери кориснички информации',
	'lookupuser-desc' => '[[Special:LookupUser|Проверка на информации]] за корисник како е-поштенска адреса и ид. бр.',
	'lookupuser-intro' => 'Внесете корисничко име за да ги видите нагодувањата на тој корисник. Можете да употребите и е-пошта. Со тоа ќе се покажат сите сметки што ја користат таа е-поштенска адреса.',
	'lookupuser-nonexistent' => 'Грешка: Таков корисник не постои',
	'lookupuser-authenticated' => 'потврден на $1',
	'lookupuser-not-authenticated' => 'непотврден',
	'lookupuser-id' => 'Кориснички ид. бр.: <tt>#$1</tt>',
	'lookupuser-email' => 'Е-пошта: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'ненаведено',
	'lookupuser-realname' => 'Вистинско име: $1',
	'lookupuser-registration' => 'Датум на регистрација: $1',
	'lookupuser-no-registration' => 'незапишано',
	'lookupuser-touched' => 'Последна измена во записите на корисникот: $1',
	'lookupuser-info-authenticated' => 'Потврда по е-пошта: $1',
	'lookupuser-useroptions' => 'Кориснички прилагодувања:',
	'lookupuser-foundmoreusers' => 'Пронајдов повеќе од еден корисник:',
	'right-lookupuser' => 'Проверка на кориснички нагодувања',
);

/** Malayalam (മലയാളം)
 * @author Anoopan
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'lookupuser' => 'ഉപയോക്താവിന്റെ വിവരം തിരയുക',
	'lookupuser-desc' => 'ഒരു ഉപയോക്താവിന്റെ ഇമെയിൽ വിലാസം, ഐ.ഡി. തുടങ്ങിയ [[Special:LookupUser|വിവരങ്ങൾ ശേഖരിക്കുക]]',
	'lookupuser-intro' => 'ഒരു ഉപയോക്താവിന്റെ ക്രമീകരണങ്ങൾ നൽകാൻ ഉപയോക്തൃനാമം നൽകുക.',
	'lookupuser-nonexistent' => 'തെറ്റ്: ഉപയോക്താവ് നിലവിലില്ല',
	'lookupuser-authenticated' => 'ഇമെയിൽ സ്ഥിരീകരണം: $1',
	'lookupuser-not-authenticated' => 'സ്ഥിരീകരിച്ചിട്ടില്ല',
	'lookupuser-id' => 'ഉപയോക്തൃ ഐ.ഡി.: <tt>#$1</tt>',
	'lookupuser-email' => 'ഇമെയിൽ: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'നൽകിയിട്ടില്ല',
	'lookupuser-realname' => 'ശരിയായ പേര്: $1',
	'lookupuser-registration' => 'രജിസ്റ്റർ ചെയ്ത തീയതി: $1',
	'lookupuser-no-registration' => 'റെക്കോർഡ് ചെയ്തിട്ടില്ല',
	'lookupuser-touched' => 'ഉപയോക്താവിന്റെ വിവരങ്ങൾ അവസാനം തിരുത്തിയത്: $1',
	'lookupuser-info-authenticated' => 'ഇമെയിൽ സാധൂകരണം: $1',
	'lookupuser-useroptions' => 'ഉപയോക്തൃ ഐച്ഛികങ്ങൾ:',
	'right-lookupuser' => 'ഉപയോക്തൃ ഐച്ഛികങ്ങൾ നോക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'lookupuser' => 'सदस्य माहिती शोधा',
	'lookupuser-desc' => 'एखाद्या सदस्याची [[Special:LookupUser|अधिक माहिती मिळवा]] उदा. इमेल पत्ता व सदस्य क्रमांक',
	'lookupuser-intro' => 'एखाद्या सदस्याच्या पसंती पाहण्यासाठी त्याचे सदस्यनाव लिहा.',
	'lookupuser-nonexistent' => 'त्रुटी: सदस्य अस्तित्वात नाही',
	'lookupuser-authenticated' => 'इमेल तपासणी: $1',
	'lookupuser-not-authenticated' => 'तपासणी पूर्ण झालेली नाही',
	'lookupuser-id' => 'सदस्य क्रमांक: <tt>#$1</tt>',
	'lookupuser-email' => 'विपत्र: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'दिलेले नाही',
	'lookupuser-realname' => 'खरे नाव: $1',
	'lookupuser-registration' => 'नोंदणी दिनांक: $1',
	'lookupuser-no-registration' => 'नोंदलेले नाही',
	'lookupuser-touched' => 'बघितलेली शेवटची सदस्य नोंद: $1',
	'lookupuser-useroptions' => 'सदस्य विकल्प:',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'lookupuser' => 'Dapatkan maklumat pengguna',
	'lookupuser-desc' => '[[Special:LookupUser|Dapatkan maklumat]] mengenai seseorang pengguna sepreti alamat e-mel dan ID',
	'lookupuser-intro' => 'Isikan satu nama pengguna untuk melihat keutamaannya. Alamat e-mel juga boleh digunakan, dan akan memaparkan semua akaun yang menggunakan e-mel itu.',
	'lookupuser-nonexistent' => 'Ralat: Pengguna tidak wujud',
	'lookupuser-authenticated' => 'Pengesahan e-mel: $1',
	'lookupuser-not-authenticated' => 'belum disahkan',
	'lookupuser-id' => 'ID pengguna: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mel: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'tidak dibekalkan',
	'lookupuser-realname' => 'Nama sebenar: $1',
	'lookupuser-registration' => 'Tarikh pendaftaran: $1',
	'lookupuser-no-registration' => 'tidak direkodkan',
	'lookupuser-touched' => 'Kali terakhir rekod pengguna disentuh: $1',
	'lookupuser-info-authenticated' => 'Pengesahan e-mel: $1',
	'lookupuser-useroptions' => 'Pilihan pengguna:',
	'lookupuser-foundmoreusers' => 'Lebih seorang pengguna dijumpai:',
	'right-lookupuser' => 'Mencari keutamaan pengguna',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'lookupuser-realname' => 'Алкуксонь лемесь: $1',
	'lookupuser-no-registration' => 'апак сёрмадсто',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'lookupuser-id' => 'Tlatequitiltilīlli ID: <tt>#$1</tt>',
	'lookupuser-realname' => 'Melāhuac tōcāitl: $1',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 */
$messages['nb'] = array(
	'lookupuser' => 'Finn brukerinformasjon',
	'lookupuser-desc' => '[[Special:LookupUser|Innhent informasjon]] om en bruker, som f.eks. e-postadresse og ID',
	'lookupuser-intro' => 'Skriv inn et brukernavn for å vise brukerens innstillinger.',
	'lookupuser-nonexistent' => 'Feil: Brukeren eksisterer ikke',
	'lookupuser-authenticated' => 'E-postbekrefting: $1',
	'lookupuser-not-authenticated' => 'ikke bekreftet',
	'lookupuser-id' => 'Bruker-ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-post: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'ikke oppgitt',
	'lookupuser-realname' => 'Virkelig navn: $1',
	'lookupuser-registration' => 'Registrasjonsdato: $1',
	'lookupuser-no-registration' => 'ikke lagret',
	'lookupuser-touched' => 'Innstillinger sist endret: $1',
	'lookupuser-info-authenticated' => 'E-postverifisering: $1',
	'lookupuser-useroptions' => 'Brukervalg:',
	'right-lookupuser' => 'Se brukerinnstillinger',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'lookupuser' => 'Gebruikersinformatie opzoeken',
	'lookupuser-desc' => '[[Special:LookupUser|Informatie inzien]] van een gebruiker, zoals e-mailadres en gebruikersnummer',
	'lookupuser-intro' => 'Geef een gebruikersnaam in om de voorkeuren van die gebruiker te bekijken. Een e-mailadres kan ook gebruikt worden, en zal alle gebruikers die dat e-mailadres gebruiken weergeven.',
	'lookupuser-nonexistent' => 'Fout: Gebruiker bestaat niet',
	'lookupuser-authenticated' => 'E-mailbevestiging: $1',
	'lookupuser-not-authenticated' => 'niet bevestigd',
	'lookupuser-id' => 'Gebruikersnummer: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mailadres: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'niet opgegeven',
	'lookupuser-realname' => 'Echte naam: $1',
	'lookupuser-registration' => 'Registratiedatum: $1',
	'lookupuser-no-registration' => 'niet opgeslagen',
	'lookupuser-touched' => 'Gebruikersvoorkeuren laatst gewijzigd: $1',
	'lookupuser-info-authenticated' => 'E-mailbevestiging: $1',
	'lookupuser-useroptions' => 'Gebruikersopties:',
	'lookupuser-foundmoreusers' => 'Meer dan één gebruiker gevonden:',
	'right-lookupuser' => 'Gebruikersvoorkeuren bekijken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 */
$messages['nn'] = array(
	'lookupuser' => 'Finn brukarinformasjon',
	'lookupuser-desc' => '[[Special:LookupUser|Hent informasjon]] om ein brukar, som t.d. e-postadresse og ID',
	'lookupuser-intro' => 'Skriv inn eit brukarnamn for å vise innstillingane til brukaren.',
	'lookupuser-nonexistent' => 'Feil: Brukaren eksisterer ikkje',
	'lookupuser-authenticated' => 'E-poststadfesting: $1',
	'lookupuser-not-authenticated' => 'ikkje stadfesta',
	'lookupuser-id' => 'Brukar-ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-post: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'ikke oppgjeve',
	'lookupuser-realname' => 'Verkeleg namn: $1',
	'lookupuser-registration' => 'Registreringsdato: $1',
	'lookupuser-no-registration' => 'ikkje lagra',
	'lookupuser-touched' => 'Innstillingar sist endra: $1',
	'lookupuser-info-authenticated' => 'E-postverifisering: $1',
	'lookupuser-useroptions' => 'Brukarval:',
	'right-lookupuser' => 'Sjå brukarinnstillingar',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'lookupuser' => "Percórrer las entresenhas a prepaus de l'utilizaire",
	'lookupuser-desc' => 'Extracha las entresenhas concernent un utilizaire talas coma una adreça electronica e lo numèro ID',
	'lookupuser-intro' => "Picar un nom d'utilizaire per veire sas preferéncias",
	'lookupuser-nonexistent' => "Error : l'utilizaire existís pas",
	'lookupuser-authenticated' => "Corrièr electronic d'identificacion : $1",
	'lookupuser-not-authenticated' => 'pas identificat',
	'lookupuser-id' => "ID de l'utilizaire : <tt>#$1</tt>",
	'lookupuser-email' => 'Corrièr electronic : [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'pas provesit',
	'lookupuser-realname' => 'Nom vertadièr : $1',
	'lookupuser-registration' => "Data d'enregistrament : $1",
	'lookupuser-no-registration' => 'pas enregistrat',
	'lookupuser-touched' => "Enregistrament de l'utilizaire tocat pel darrièr còp : $1",
	'lookupuser-info-authenticated' => 'Autentificacion del corrièr electronic : $1',
	'lookupuser-useroptions' => "Opcions de l'utilizaire :",
	'right-lookupuser' => 'Visionar las preferéncias dels utilizaires',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author McMonster
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'lookupuser' => 'Wyszukiwanie informacji o użytkowniku',
	'lookupuser-desc' => '[[Special:LookupUser|Pobierz informacje]] dotyczące użytkownika, takie jak adres e‐mail i ID',
	'lookupuser-intro' => 'Wprowadź nazwę użytkownika, aby zobaczyć ustawienia jego preferencji. Możesz również podać adres e‐mail co spowoduje wyświetlenie wszystkich kont do niego przypisanych.',
	'lookupuser-nonexistent' => 'Błąd: użytkownik nie istnieje',
	'lookupuser-authenticated' => 'uwierzytelniono $1',
	'lookupuser-not-authenticated' => 'nie uwierzytelnione',
	'lookupuser-id' => 'ID użytkownika: <tt>$1</tt>',
	'lookupuser-email' => 'E‐mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nie podał adresu e‐mail',
	'lookupuser-realname' => 'Imię i nazwisko $1',
	'lookupuser-registration' => 'Zarejestrowany $1',
	'lookupuser-no-registration' => 'taki użytkownik nie istnieje',
	'lookupuser-touched' => 'Ostatnią aktywność użytkownika zanotowano $1',
	'lookupuser-info-authenticated' => 'Uwierzytelnienie e‐mailem: $1',
	'lookupuser-useroptions' => 'Opcje użytkownika:',
	'lookupuser-foundmoreusers' => 'Odnaleziono więcej niż jednego użytkownika:',
	'right-lookupuser' => 'Przeglądanie ustawień preferencji użytkowników',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'lookupuser' => 'Varda anformassion utent',
	'lookupuser-desc' => "[[Special:LookupUser|Treuva anformassion]] an s'un utent con st'adrëssa e-mail e ID-sì",
	'lookupuser-intro' => "Ch'a anserissa në stranòm për vëdde ij gust ëd col utent. N'adrëssa ëd pòsta eletrònica a peul ëdcò esse dovrà, e a smonrà tùit ij cont ch'a deuvro cola adrëssa.",
	'lookupuser-nonexistent' => "Eror: l'utent a esist pa",
	'lookupuser-authenticated' => 'Autenticà an dzora a $1',
	'lookupuser-not-authenticated' => 'pa autenticà',
	'lookupuser-id' => 'ID utent: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'pa dàit',
	'lookupuser-realname' => 'Nòm ver: $1',
	'lookupuser-registration' => "Data d'argistrassion: $1",
	'lookupuser-no-registration' => 'pa arcordà',
	'lookupuser-touched' => "Registr ëd l'ùltim click ëd l'utent: $1",
	'lookupuser-info-authenticated' => 'Autenticassion e-mail: $1',
	'lookupuser-useroptions' => "Opsion ëd l'utent:",
	'lookupuser-foundmoreusers' => 'Trovà pi che un utent:',
	'right-lookupuser' => 'Varda ij "mè gust" ëd l\'utent',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'lookupuser-nonexistent' => 'ستونزه: دا کارن نه شته',
	'lookupuser-email' => 'برېښليک: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-realname' => 'اصلي نوم: $1',
	'lookupuser-registration' => 'د نومليکنې نېټه: $1',
	'lookupuser-useroptions' => 'د کارن خوښنې:',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'lookupuser' => 'Procurar informação de utilizador',
	'lookupuser-desc' => '[[Special:LookupUser|Obter informação]] sobre um utilizador tal como o correio electrónico e a identificação (ID)',
	'lookupuser-intro' => 'Introduza um nome de utilizador para ver as preferências desse utilizador.',
	'lookupuser-nonexistent' => 'Erro: Utilizador não existe',
	'lookupuser-authenticated' => 'autenticado em $1',
	'lookupuser-not-authenticated' => 'não autenticado',
	'lookupuser-id' => 'ID de utilizador: <tt>#$1</tt>',
	'lookupuser-email' => 'Correio electrónico: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'não fornecido',
	'lookupuser-realname' => 'Nome real: $1',
	'lookupuser-registration' => 'Data de registo: $1',
	'lookupuser-no-registration' => 'não registado',
	'lookupuser-touched' => 'Registo de utilizador alterado pela última vez: $1',
	'lookupuser-info-authenticated' => 'Autenticação do correio electrónico: $1',
	'lookupuser-useroptions' => 'Opções do utilizador:',
	'right-lookupuser' => 'Consultar preferências de utilizador',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'lookupuser' => 'Procurar informação de usuário',
	'lookupuser-desc' => '[[Special:LookupUser|Retorna informação]] sobre um usuário tal como o endereço de email e o ID',
	'lookupuser-intro' => 'Introduza um nome de usuário para visualizar as preferências desse usuário.',
	'lookupuser-nonexistent' => 'Erro: Esse usuário não existe',
	'lookupuser-authenticated' => 'Autenticação por email: $1',
	'lookupuser-not-authenticated' => 'não autenticado',
	'lookupuser-id' => 'ID de usuário: <tt>#$1</tt>',
	'lookupuser-email' => 'Email: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'não fornecido',
	'lookupuser-realname' => 'Nome real: $1',
	'lookupuser-registration' => 'Data de registro: $1',
	'lookupuser-no-registration' => 'não registrado',
	'lookupuser-touched' => 'Registro de usuário alterado pela última vez: $1',
	'lookupuser-info-authenticated' => 'Autenticação de e-mail: $1',
	'lookupuser-useroptions' => 'Opções de usuário:',
	'right-lookupuser' => 'Consultar preferências de usuário',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'lookupuser-nonexistent' => 'Eroare: Utilizatorul nu există',
	'lookupuser-authenticated' => 'autentificat la $1',
	'lookupuser-not-authenticated' => 'neautentificat',
	'lookupuser-id' => 'ID utilizator: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-realname' => 'Nume real: $1',
	'lookupuser-registration' => 'Data înregistrării: $1',
	'lookupuser-info-authenticated' => 'Autentificare e-mail: $1',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'lookupuser-nonexistent' => "Errore: L'utende non g'esiste",
	'lookupuser-authenticated' => 'autendicate sus a $1',
	'lookupuser-not-authenticated' => 'non autendicate',
	'lookupuser-id' => "ID de l'utende: <tt>#$1</tt>",
	'lookupuser-no-email' => "non g'è previste",
	'lookupuser-realname' => 'Nome vere: $1',
	'lookupuser-registration' => 'Date de reggistrazione: $1',
	'lookupuser-no-registration' => 'no reggistrate',
	'lookupuser-info-authenticated' => "Autendicazione de l'e-mail: $1",
	'lookupuser-useroptions' => 'Opzione utende:',
);

/** Russian (Русский)
 * @author Adata80
 * @author Eleferen
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'lookupuser' => 'Показать сведения об участнике',
	'lookupuser-desc' => '[[Special:LookupUser|Получение сведений]] об участнике, таких как почтовый адрес и идентификатор',
	'lookupuser-intro' => 'Введите имя пользователя, чтобы просмотреть его настройки. Адрес электронной почты также может быть использован, и покажет все учетные записи использующие этот почтовый ящик.',
	'lookupuser-nonexistent' => 'Ошибка. Участника не существует',
	'lookupuser-authenticated' => 'Аутентификация по эл. почте: $1',
	'lookupuser-not-authenticated' => 'не аутентифицирован',
	'lookupuser-id' => 'ID участника: <tt>#$1</tt>',
	'lookupuser-email' => 'Эл. почта: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'не указан',
	'lookupuser-realname' => 'Настоящее имя: $1',
	'lookupuser-registration' => 'Дата регистрации: $1',
	'lookupuser-no-registration' => 'не записана',
	'lookupuser-touched' => 'Последнее обновление записи участника: $1',
	'lookupuser-info-authenticated' => 'Аутентификация по почте: $1',
	'lookupuser-useroptions' => 'Настройки участника:',
	'lookupuser-foundmoreusers' => 'Найдено более одного пользователя:',
	'right-lookupuser' => 'поиск настроек участников',
);

/** Sardinian (Sardu)
 * @author Marzedu
 */
$messages['sc'] = array(
	'lookupuser-id' => 'ID usuàriu: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-realname' => 'Nòmene beru: $1',
);

/** Sicilian (Sicilianu)
 * @author Melos
 * @author Santu
 */
$messages['scn'] = array(
	'lookupuser' => 'Talìa nfurmazzioni utenti',
	'lookupuser-desc' => "[[Special:LookupUser|Ricùpira nfurmazzioni]] supra a n'utenti comu ndirizzu e-mail e ID",
	'lookupuser-intro' => 'Nzirisci nu nomu utenti pi taliari li prifirenzi.',
	'lookupuser-nonexistent' => "Sbàgghiu: l'utenti non esisti",
	'lookupuser-authenticated' => 'Cunferma nnirizzu e-mail: $1',
	'lookupuser-not-authenticated' => 'no cunfirmatu',
	'lookupuser-id' => 'ID utenti: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'non privisti',
	'lookupuser-realname' => 'Nomu veru: $1',
	'lookupuser-registration' => 'Data di riggistrazzioni: $1',
	'lookupuser-no-registration' => 'non dispunìbbili',
	'lookupuser-touched' => 'Ùrtima visita riggistrata: $1',
	'lookupuser-info-authenticated' => 'Autenticazzioni e-mail: $1',
	'lookupuser-useroptions' => 'Prifirenzi utenti:',
	'right-lookupuser' => 'Talìa li prifirenzi utenti',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'lookupuser' => 'Vyhľadať informácie o používateľovi',
	'lookupuser-desc' => '[[Special:LookupUser|Získať informácií]] o používateľovi ako emailová adresa a ID',
	'lookupuser-intro' => 'Zadajte používateľské meno, ktorého nastavenia chcete zobraziť.',
	'lookupuser-nonexistent' => 'Chyba: Používateľ neexistuje',
	'lookupuser-authenticated' => 'Overenie emailu: $1',
	'lookupuser-not-authenticated' => 'neoverený',
	'lookupuser-id' => 'ID používateľa: <tt>#$1</tt>',
	'lookupuser-email' => 'Email: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nebol poskytnutý',
	'lookupuser-realname' => 'Skutočné meno: $1',
	'lookupuser-registration' => 'Dátum registrácie: $1',
	'lookupuser-no-registration' => 'nebol zaznamenaný',
	'lookupuser-touched' => 'Posledný záznam používateľa: $1',
	'lookupuser-info-authenticated' => 'Overenie emailu: $1',
	'lookupuser-useroptions' => 'Nastavenia používateľa:',
	'right-lookupuser' => 'Zistiť nastavenia používateľa',
);

/** Lower Silesian (Schläsch)
 * @author Schläsinger
 */
$messages['sli'] = array(
	'lookupuser-id' => 'Benutzer-ID: <tt>$1</tt>',
	'lookupuser-email' => 'E-Mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nee vurhanda',
	'lookupuser-realname' => 'Wirklicher Noame: $1',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 * @author Обрадовић Горан
 */
$messages['sr-ec'] = array(
	'lookupuser' => 'Погледај информације о кориснику',
	'lookupuser-nonexistent' => 'Грешка: Корисник не постоји',
	'lookupuser-authenticated' => 'ауторизација на $1',
	'lookupuser-not-authenticated' => 'није ауторизовано',
	'lookupuser-id' => 'Кориснички ID: <tt>#$1</tt>',
	'lookupuser-email' => 'Е-пошта: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'није приложено',
	'lookupuser-realname' => 'Право име: $1',
	'lookupuser-registration' => 'Датум регистрације: $1',
	'lookupuser-no-registration' => 'није забележено',
	'lookupuser-info-authenticated' => 'Потврда имејла: $1',
	'lookupuser-useroptions' => 'Корисничке опције:',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'lookupuser' => 'Pogledaj informacije o korisniku',
	'lookupuser-nonexistent' => 'Greška: Korisnik ne postoji',
	'lookupuser-authenticated' => 'autorizacija na $1',
	'lookupuser-not-authenticated' => 'nije autorizovano',
	'lookupuser-id' => 'Korisnički ID: <tt>#$1</tt>',
	'lookupuser-email' => 'Imejl: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nije priloženo',
	'lookupuser-realname' => 'Pravo ime: $1',
	'lookupuser-registration' => 'Datum registracije: $1',
	'lookupuser-no-registration' => 'nije zabeleženo',
	'lookupuser-info-authenticated' => 'Potvrda imejla: $1',
	'lookupuser-useroptions' => 'Korisničke opcije:',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'lookupuser' => 'Benutserinformatione ienkiekje',
	'lookupuser-desc' => '[[Special:LookupUser|Informatione]] uur Benutser kriege, as E-Mail-Adresse of ID.',
	'lookupuser-intro' => 'Reek n Benutsernoome ien, uum die do persöönelke Ienstaalengen fon n Benutser antoukiekjen.',
	'lookupuser-nonexistent' => 'Failer: Benutser bestoant nit',
	'lookupuser-authenticated' => 'E-Mail-Bestäätigenge: $1',
	'lookupuser-not-authenticated' => 'nit bestäätiged',
	'lookupuser-id' => 'Benutser-ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-Mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'nit deer',
	'lookupuser-realname' => 'Wuddelken Noome: $1',
	'lookupuser-registration' => 'Doatum fon ju Registrierenge: $1',
	'lookupuser-no-registration' => 'nit ferteekend',
	'lookupuser-touched' => 'Benutserkonto toulääst rööged: $1',
	'lookupuser-info-authenticated' => 'E-Mail-Bestäätigenge: $1',
	'lookupuser-useroptions' => 'Ienstaalengen fon dät Benutserkonto:',
	'right-lookupuser' => 'Sjuch do Benutserienstaalengen fon uur Benutsere',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'lookupuser' => 'Kolla upp användar info',
	'lookupuser-desc' => '[[Special:LookupUser|Hämta information]] om en användare, som t.ex. e-postadress och ID',
	'lookupuser-intro' => 'Skriv in ett användarnamn för att visa användarens inställningar.',
	'lookupuser-nonexistent' => 'Error: Användare existerar inte',
	'lookupuser-authenticated' => 'E-postbekräftning: $1',
	'lookupuser-not-authenticated' => 'inte bekräftad',
	'lookupuser-id' => 'Användar ID: <tt>#$1</tt>',
	'lookupuser-email' => 'E-post: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'inte uppgett',
	'lookupuser-realname' => 'Riktigt namn: $1',
	'lookupuser-registration' => 'Registrerings datum: $1',
	'lookupuser-no-registration' => 'inte lagrat',
	'lookupuser-touched' => 'Inställningar sist ändrat: $1',
	'lookupuser-info-authenticated' => 'E-postverifiering: $1',
	'lookupuser-useroptions' => 'Användarval:',
	'right-lookupuser' => 'Kolla användarpreferenser',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'lookupuser-realname' => 'Jina lako halisi:$1',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'lookupuser' => 'వాడుకరి సమాచారంలో వెతకండి',
	'lookupuser-intro' => 'ఒక వాడుకరి యొక్క అభిరుచులు చూడడానికి ఆ వాడుకరిపేరుని ఇవ్వండి.',
	'lookupuser-nonexistent' => 'పొరపాటు: వాడుకరి ఉనికిలో లేరు',
	'lookupuser-id' => 'వాడుకరి ID: <tt>#$1</tt>',
	'lookupuser-email' => 'ఈ-మెయిల్: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'ఇవ్వలేదు',
	'lookupuser-realname' => 'నిజమైన పేరు: $1',
	'lookupuser-registration' => 'నమోదైన తేదీ: $1',
	'lookupuser-useroptions' => 'వాడుకరి ఎంపికలు:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'lookupuser-nonexistent' => 'Хато: Корбар вуҷуд надорад',
	'lookupuser-email' => 'Фиристодани E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'пешниҳод нашудааст',
	'lookupuser-realname' => 'Номи аслӣ: $1',
	'lookupuser-registration' => 'Таърихи сабти ном: $1',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'lookupuser-nonexistent' => 'Xato: Korbar vuçud nadorad',
	'lookupuser-email' => 'Firistodani E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'peşnihod naşudaast',
	'lookupuser-realname' => 'Nomi aslī: $1',
	'lookupuser-registration' => "Ta'rixi sabti nom: $1",
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'lookupuser' => 'Hanapin at tingnan ang kabatirang pangtagagamit',
	'lookupuser-desc' => '[[Special:LookupUser|Kuhanin ang kabatirang]] hinggil sa isang tagagamit katulad ng adres ng e-liham at ID',
	'lookupuser-intro' => 'Maglagay/magpasok ng isang pangalan ng tagagamit upang matingnan ang mga kagustuhan ng tagagamit na iyan.',
	'lookupuser-nonexistent' => 'Kamalian: Hindi umiiral ang tagagamit',
	'lookupuser-authenticated' => 'napatunayan noong $1',
	'lookupuser-not-authenticated' => 'hindi pa napapatunayan',
	'lookupuser-id' => 'ID ng tagagamit: <tt>#$1</tt>',
	'lookupuser-email' => 'E-liham: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'hindi ibinigay',
	'lookupuser-realname' => 'Tunay na pangalan: $1',
	'lookupuser-registration' => 'Petsa ng pagpapatala: $1',
	'lookupuser-no-registration' => 'hindi nakatala',
	'lookupuser-touched' => 'Huling hinawakan/nagalaw ang talaang pangtagagamit noong: $1',
	'lookupuser-info-authenticated' => 'Pagpapatunay ng e-liham: $1',
	'lookupuser-useroptions' => 'Mga pagpipilian ng tagagamit:',
	'right-lookupuser' => 'Hanapin ang mga kagustuhan ng tagagamit',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Mach
 */
$messages['tr'] = array(
	'lookupuser' => 'Kullanıcı bilgisine bak',
	'lookupuser-desc' => 'Bir kullanıcı hakkında e-posta adresi ve ID gibi [[Special:LookupUser|bilgileri al]]',
	'lookupuser-intro' => 'Kullanıcıların tercihlerini görmek için bir kullanıcı adı girin.',
	'lookupuser-nonexistent' => 'Hata: Kullanıcı yok',
	'lookupuser-authenticated' => '$1 üzerinde denetlendi',
	'lookupuser-not-authenticated' => 'denetlenmedi',
	'lookupuser-id' => 'Kullanıcı IDsi: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'sağlanmamış',
	'lookupuser-realname' => 'Gerçek isim: $1',
	'lookupuser-registration' => 'Kayıt tarihi: $1',
	'lookupuser-no-registration' => 'kayıtlı değil',
	'lookupuser-touched' => 'Kullanıcı kaydı son dokunuldu: $1',
	'lookupuser-info-authenticated' => 'E-posta doğrulama: $1',
	'lookupuser-useroptions' => 'Kullanıcı seçenekleri:',
	'right-lookupuser' => 'Kullanıcı tercihlerine bak',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Aleksandrit
 */
$messages['uk'] = array(
	'lookupuser' => 'Показати відомості про користувача',
	'lookupuser-desc' => '[[Special:LookupUser|Отримання відомостей]] про користувача, таких як адреса Е-пошти та ідентифікатор',
	'lookupuser-intro' => "Введіть ім'я користувача, щоб переглянути налаштування цього користувача.",
	'lookupuser-nonexistent' => 'Помилка. Користувача не існує',
	'lookupuser-authenticated' => 'Аутентифікація ел. поштою: $1',
	'lookupuser-not-authenticated' => 'не аутентіфіцірован',
	'lookupuser-id' => 'ID користувача: <tt>#$1</tt>',
	'lookupuser-email' => 'Ел. пошта: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'не указан',
	'lookupuser-realname' => "Справжнє ім'я: $1",
	'lookupuser-registration' => 'Дата реєстрації: $1',
	'lookupuser-no-registration' => 'не записана',
	'lookupuser-touched' => 'Останнє оновлення запису користувача: $1',
	'lookupuser-info-authenticated' => 'Аутентифікація по пошті: $1',
	'lookupuser-useroptions' => 'Налаштування користувача:',
	'right-lookupuser' => 'Перегляд налаштувань користувачів',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'lookupuser' => "Varda informassion su l'utente",
	'lookupuser-desc' => '[[Special:LookupUser|Varda le informassion]] su un utente, tipo la so identità e el so indirisso e-mail',
	'lookupuser-intro' => 'Inserissi un nome utente par védarghine le preferense.',
	'lookupuser-nonexistent' => "Eròr: sto utente no l'esiste mia",
	'lookupuser-authenticated' => 'Conferma indirisso e-mail: $1',
	'lookupuser-not-authenticated' => 'mia confermà',
	'lookupuser-id' => 'ID utente: <tt>#$1</tt>',
	'lookupuser-email' => 'E-mail: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'mia fornìo',
	'lookupuser-realname' => 'Vero nome: $1',
	'lookupuser-registration' => 'Data de registrassion: $1',
	'lookupuser-no-registration' => 'mia disponibile',
	'lookupuser-touched' => "Ultima visita registrà de l'utente: $1",
	'lookupuser-info-authenticated' => 'Autenticassion de posta eletronica: $1',
	'lookupuser-useroptions' => 'Preferense utente:',
	'right-lookupuser' => "Varda le preferense de l'utente",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'lookupuser-realname' => 'Todesine nimi: $1',
	'lookupuser-useroptions' => 'Kävutajan järgendused:',
	'right-lookupuser' => 'Ectä kävutajan järgendused',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'lookupuser' => 'Tra thông tin thành viên',
	'lookupuser-desc' => '[[Special:LookupUser|Tra thông tin]] về một thành viên như địa chỉ thư điện tử và mã số',
	'lookupuser-intro' => 'Gõ tên người dùng để xem tùy chọn của thành viên đó.',
	'lookupuser-nonexistent' => 'Lỗi: Thành viên không tồn tại',
	'lookupuser-authenticated' => 'Xác nhận thư điện tử: $1',
	'lookupuser-not-authenticated' => 'chưa xác nhận',
	'lookupuser-id' => 'Mã số thành viên: <tt>#$1</tt>',
	'lookupuser-email' => 'Thư điện tử: [https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => 'không cung cấp',
	'lookupuser-realname' => 'Tên thật: $1',
	'lookupuser-registration' => 'Ngày đăng ký: $1',
	'lookupuser-no-registration' => 'không lưu trữ',
	'lookupuser-touched' => 'Bản ghi lại lần cuối truy cập: $1',
	'lookupuser-info-authenticated' => 'Xác nhận thư điện tử: $1',
	'lookupuser-useroptions' => 'Lựa chọn của thành viên:',
	'right-lookupuser' => 'Tra tùy chọn người dùng',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'lookupuser' => 'Sukön gebananünodis',
	'lookupuser-intro' => 'Penolös gebananami ad logön buükamis gebana at.',
	'lookupuser-nonexistent' => 'Pöl: Geban no dabinon',
	'lookupuser-id' => 'Dientifanüm gebana: <tt>#$1</tt>',
	'lookupuser-realname' => 'Nem jenöfik: $1',
	'lookupuser-registration' => 'Registaramadät: $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hydra
 * @author Kuailong
 * @author Wrightbus
 */
$messages['zh-hans'] = array(
	'lookupuser' => '查询用户信息',
	'lookupuser-desc' => '[[Special:LookupUser|检索信息]] 有关的用户 ID 的电子邮件地址等',
	'lookupuser-intro' => '输入用户名，查看该用户的参数设置',
	'lookupuser-nonexistent' => '错误：用户不存在',
	'lookupuser-not-authenticated' => '不进行身份验证',
	'lookupuser-id' => '用户ID: <tt>#$1</tt>',
	'lookupuser-email' => '电邮：[https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => '不提供',
	'lookupuser-realname' => '真实姓名：$1',
	'lookupuser-registration' => '注册日期：$1',
	'lookupuser-no-registration' => '不记录',
	'lookupuser-touched' => '最后触及的用户记录：$1',
	'lookupuser-info-authenticated' => '电子邮件验证：$1',
	'lookupuser-useroptions' => '用户选项：',
	'right-lookupuser' => '查看用户设置',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'lookupuser' => '查詢用戶資料',
	'lookupuser-desc' => '[[Special:LookupUser|檢索信息]] 有關的用戶 ID 的電子郵件地址等',
	'lookupuser-intro' => '輸入使用者名稱，檢視該用戶的偏好設定',
	'lookupuser-nonexistent' => '錯誤：使用者不存在',
	'lookupuser-not-authenticated' => '未驗證',
	'lookupuser-id' => '使用者 ID：<tt>#$1</tt>',
	'lookupuser-email' => '電郵：[https://wikia.zendesk.com/search?query=type:ticket%20requester:$2 $1]',
	'lookupuser-no-email' => '未提供',
	'lookupuser-realname' => '真實姓名：$1',
	'lookupuser-registration' => '註冊日期：$1',
	'lookupuser-no-registration' => '沒有記錄',
	'lookupuser-touched' => '最後觸及的用戶記錄：$1',
	'lookupuser-info-authenticated' => '電子郵件驗證：$1',
	'lookupuser-useroptions' => '使用者選擇：',
	'right-lookupuser' => '檢視用戶設定',
);
