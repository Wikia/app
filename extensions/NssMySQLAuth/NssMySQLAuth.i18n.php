<?php
/*
 * Internationalization for NssMySQLAuth extension.
 */

$messages = array();

/**
 * English
 * @author Bryan Tong Minh
 */
$messages['en'] = array(
	'accountmanager' => 'Account manager',
	
	'am-username' 	=> 'username',
	'am-email' => 'e-mail',
	'am-active' 	=> 'active',
	'am-updated' => 'Your changes have been saved successfully',

	'nss-desc' => 'A plugin to authenticate against a libnss-mysql database. Contains an [[Special:AccountManager|account manager]]',
	'nss-rights'	=>  'rights',
	'nss-save-changes'	=> 'Save changes',
	'nss-create-account-header'	=> 'Create new account',
	'nss-create-account'	=> 'Create account',
	'nss-no-mail'	=> 'Do not send email',
	'nss-welcome-mail'	=> 'An account with username $1 and password $2 has been created for you.',
	'nss-welcome-mail-subject' => 'Account creation',
	
	'nss-db-error' => 'Error reading from authentication database'
);

/** Message documentation (Message documentation)
 * @author Purodha
 */
$messages['qqq'] = array(
	'nss-desc' => 'Short desciption of this extension.
Shown in [[Special:Version]].
Do not translate or change tag names, or link anchors.',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'accountmanager' => 'مدير الحساب',
	'am-username' => 'اسم المستخدم',
	'am-email' => 'البريد الإلكتروني',
	'am-active' => 'نشط',
	'am-updated' => 'تغييراتك تم حفظها بنجاح',
	'nss-desc' => 'إضافة للتحقق ضد قاعدة بيانات libnss-mysql. يحتوي على [[Special:AccountManager|مدير حساب]]',
	'nss-rights' => 'صلاحيات',
	'nss-save-changes' => 'حفظ التغييرات',
	'nss-create-account-header' => 'إنشاء حساب جديد',
	'nss-create-account' => 'إنشاء الحساب',
	'nss-no-mail' => 'لا ترسل بريدا إلكترونيا',
	'nss-welcome-mail' => 'الحساب باسم المستخدم $1 وكلمة السر $2 تم إنشاؤه من أجلك.',
	'nss-welcome-mail-subject' => 'إنشاء الحساب',
	'nss-db-error' => 'خطأ قراءة من قاعدة بيانات التحقق.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ouda
 */
$messages['arz'] = array(
	'accountmanager' => 'مدير الحساب',
	'am-username' => 'اسم اليوزر',
	'am-email' => 'البريد الإلكترونى',
	'am-active' => 'نشط',
	'am-updated' => 'تغييراتك تم حفظها بنجاح',
	'nss-desc' => 'إضافة للتحقق ضد قاعدة بيانات libnss-mysql. يحتوى على [[Special:AccountManager|مدير حساب]]',
	'nss-rights' => 'صلاحيات',
	'nss-save-changes' => 'حفظ التغييرات',
	'nss-create-account-header' => 'إنشاء حساب جديد',
	'nss-create-account' => 'إنشاء الحساب',
	'nss-no-mail' => 'لا ترسل بريد إلكتروني',
	'nss-welcome-mail' => 'الحساب باسم اليوزر $1 وكلمة السر $2 تم إنشاؤه من أجلك.',
	'nss-welcome-mail-subject' => 'إنشاء الحساب',
	'nss-db-error' => 'خطأ قراءة من قاعدة بيانات التحقق.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'am-username' => 'потребителско име',
	'am-email' => 'е-поща',
	'am-updated' => 'Промените бяха съхранени успешно!',
	'nss-rights' => 'права',
	'nss-save-changes' => 'Съхраняване на промените',
	'nss-create-account-header' => 'Създаване на нова сметка',
	'nss-create-account' => 'Създаване на сметка',
	'nss-welcome-mail' => 'Беше ви създадена сметка с потребителско име $1 и парола $2.',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'accountmanager' => 'Správce účtů',
	'am-username' => 'uživatelské jméno',
	'am-email' => 'email',
	'am-active' => 'aktivní',
	'am-updated' => 'Vaše změny byly úspěšně uloženy',
	'nss-desc' => 'Zásuvný modul na ověřování vůči dtabázi libnss-mysql. Obsahuje [[Special:AccountManager|správce účtů]]',
	'nss-rights' => 'práva',
	'nss-save-changes' => 'Uložit změny',
	'nss-create-account-header' => 'Vytvořit nový účet',
	'nss-create-account' => 'Vytvořit účet',
	'nss-no-mail' => 'Neposílat email',
	'nss-welcome-mail' => 'Byl pro vás vytvořen účet s uživatelským jménem $1 a heslem $2.',
	'nss-welcome-mail-subject' => 'Vytvoření účtu',
	'nss-db-error' => 'Chyba při čtení z ověřovací databáze',
);

/** German (Deutsch) */
$messages['de'] = array(
	'accountmanager' => 'Benutzerkonten-Verwaltung',
	'am-username' => 'Benutzername',
	'am-email' => 'E-Mail',
	'am-active' => 'aktiv',
	'am-updated' => 'Die Änderungen wurden erfolgreich gespeichert',
	'nss-desc' => 'Eine Erweiterung, um gegen eine libnss-mysql-Datenbank zu authentifizieren. Inklusive einer [[Special:AccountManager|Benutzerkonten-Verwaltung]]',
	'nss-rights' => 'Rechte',
	'nss-save-changes' => 'Änderungen speichern',
	'nss-create-account-header' => 'Neues Benutzerkonto erstellen',
	'nss-create-account' => 'Benutzerkonto erstellen',
	'nss-no-mail' => 'Sende keine E-Mail',
	'nss-welcome-mail' => 'Ein Benutzerkonto mit dem Benutzernamen „$1“ und dem Passwort „$2“ wurde für dich erstellt.',
	'nss-welcome-mail-subject' => 'Benutzerkonto erstellen',
	'nss-db-error' => 'Fehler beim Lesen aus der Authentifizierungs-Datenbank',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'accountmanager' => 'Zastojnik kontow',
	'am-username' => 'wužywarske mě',
	'am-email' => 'e-mail',
	'am-active' => 'aktiwny',
	'am-updated' => 'Twóje změny su se wuspěšnje składowali.',
	'nss-desc' => 'Tykac, aby awtentificěrowało pśeśiwo datowej bance libnss-mysql. Wopśimujo [[Special:AccountManager|zastojnik kontow]]',
	'nss-rights' => 'pšawa',
	'nss-save-changes' => 'Změny składowaś',
	'nss-create-account-header' => 'Nowe konto załožyś',
	'nss-create-account' => 'Konto załožyś',
	'nss-no-mail' => 'Njepósćel e-mailku',
	'nss-welcome-mail' => 'Konto z wužywarskim mjenim $1 a gronidłom $2 jo se załožyło za tebje.',
	'nss-welcome-mail-subject' => 'Konto załožyś',
	'nss-db-error' => 'Zmólka pśi cytanju z awtenficěrowańskeje datoweje banki',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'accountmanager' => 'Konta administrilo',
	'am-username' => 'salutnomo',
	'am-email' => 'retpoŝto',
	'am-active' => 'aktiva',
	'am-updated' => 'Viaj ŝanĝoj estis sukcese ŝanĝitaj.',
	'nss-rights' => 'rajtoj',
	'nss-save-changes' => 'Konservi ŝanĝojn',
	'nss-create-account-header' => 'Krei novan konton',
	'nss-create-account' => 'Krei konton',
	'nss-no-mail' => 'Ne sendi retpoŝton',
	'nss-welcome-mail' => 'Konto kun salutnomo $1 kaj pasvorto $2 estis kreita por vi.',
	'nss-welcome-mail-subject' => 'Konta kreado',
	'nss-db-error' => 'Eraro legante de aŭtentokontrola datumbazo',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'am-username' => 'nombre de usuario',
	'am-active' => 'activo',
);

/** Finnish (Suomi)
 * @author Str4nd
 */
$messages['fi'] = array(
	'am-username' => 'käyttäjätunnus',
	'am-email' => 'sähköposti',
	'am-updated' => 'Muutokset tallennettiin onnistuneesti',
	'nss-save-changes' => 'Tallenna muutokset',
	'nss-create-account-header' => 'Luo uusi tunnus',
	'nss-create-account' => 'Luo tunnus',
	'nss-no-mail' => 'Älä lähetä sähköpostia',
	'nss-welcome-mail-subject' => 'Tunnuksen luonti',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 */
$messages['fr'] = array(
	'accountmanager' => 'Gestionnaire de comptes',
	'am-username' => "Nom d'utilisateur",
	'am-email' => 'Courriel',
	'am-active' => 'actif',
	'am-updated' => 'Vos modifications ont été sauvegardées avec succès',
	'nss-desc' => "Une extension qui permet d'authentifier au moyen d'une base de données libnss-mysql. Contient un [[Special:AccountManager|gestionnaire de comptes]]",
	'nss-rights' => 'droits',
	'nss-save-changes' => 'Sauvegarder les modifications',
	'nss-create-account-header' => 'Créer un nouveau compte',
	'nss-create-account' => 'Créer le compte',
	'nss-no-mail' => 'Ne pas envoyer de courriel',
	'nss-welcome-mail' => 'Un compte avec le nom $1 et le mot de passe $2 a été créé pour vous.',
	'nss-welcome-mail-subject' => 'Création de compte',
	'nss-db-error' => "Erreur pendant la lecture de la base de données d'authentification",
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'am-username' => 'ainm úsáideoir',
	'am-email' => 'ríomhphost',
	'nss-rights' => 'cearta',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'accountmanager' => 'Xestor de contas',
	'am-username' => 'nome de usuario',
	'am-email' => 'correo electrónico',
	'am-active' => 'activar',
	'am-updated' => 'Os seus cambios foron gardados con éxito',
	'nss-desc' => 'Un complemento para autenticar contra a base de datos libnss-mysql. Contén un [[Special:AccountManager|xestor de contas]]',
	'nss-rights' => 'dereitos',
	'nss-save-changes' => 'Gardar os cambios',
	'nss-create-account-header' => 'Crear unha conta nova',
	'nss-create-account' => 'Crear a conta',
	'nss-no-mail' => 'Non enviar o correo electrónico',
	'nss-welcome-mail' => 'Unha conta co nome de usuario "$1" e contrasinal "$2" foi creada para vostede.',
	'nss-welcome-mail-subject' => 'Creación de contas',
	'nss-db-error' => 'Erro ao ler a base de datos de autenticación',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'accountmanager' => 'מנהל החשבונות',
	'am-username' => 'שם משתמש',
	'am-email' => 'דוא"ל',
	'am-active' => 'פעיל',
	'am-updated' => 'השינויים שלכם נשמרו בהצלחה',
	'nss-desc' => 'תוסף להזדהות מול מסד נתונים מסוג libnss-mysql. כולל [[Special:AccountManager|מנהל חשבונות]]',
	'nss-rights' => 'הרשאות',
	'nss-save-changes' => 'שמירת השינויים',
	'nss-create-account-header' => 'יצירת חשבון חדש',
	'nss-create-account' => 'יצירת חשבון',
	'nss-no-mail' => 'ללא שליחת דוא"ל',
	'nss-welcome-mail' => 'נוצר עבורכם חשבון משתמש עם שם המשתמש $1 והסיסמה $2.',
	'nss-welcome-mail-subject' => 'יצירת חשבון',
	'nss-db-error' => 'שגיאה בקריאה מבסיס הנתונים של ההזדהות',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'accountmanager' => 'Zrjadowak kontow',
	'am-username' => 'wužiwarske mjeno',
	'am-email' => 'e-mejl',
	'am-active' => 'aktiwny',
	'am-updated' => 'Twoje změny su so wuspěšnje składowali',
	'nss-desc' => 'Tykač, zo by přećiwo datowej bance libnss-mysql awtentifikowało. Wobsahuje [[Special:AccountManager|zrjadowak kontow]]',
	'nss-rights' => 'prawa',
	'nss-save-changes' => 'Změny składować',
	'nss-create-account-header' => 'Nowe konto załožić',
	'nss-create-account' => 'Konto załožić',
	'nss-no-mail' => 'Njepósćel e-mejlku',
	'nss-welcome-mail' => 'Konto z wužiwarskim mjenom $1 a hesłom $2 je so za tebje załožiło.',
	'nss-welcome-mail-subject' => 'Konto załožić',
	'nss-db-error' => 'Zmylk při čitanju z awtentifikaciskeje datoweje banki',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'accountmanager' => 'Gestion de contos',
	'am-username' => 'nomine de usator',
	'am-email' => 'e-mail',
	'am-active' => 'active',
	'am-updated' => 'Tu modificationes ha essite confirmate con successo',
	'nss-desc' => 'Un extension pro authenticar contra un base de datos libnss-mysql. Contine un programma pro le [[Special:AccountManager|gestion de contos]]',
	'nss-rights' => 'derectos',
	'nss-save-changes' => 'Confirmar modificationes',
	'nss-create-account-header' => 'Crear nove conto',
	'nss-create-account' => 'Crear conto',
	'nss-no-mail' => 'Non inviar e-mail',
	'nss-welcome-mail' => 'Un conto con le nomine de usator $1 e contrasigno $2 ha essite create pro te.',
	'nss-welcome-mail-subject' => 'Creation de contos',
	'nss-db-error' => 'Error durante le lection del base de datos de authentication',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'accountmanager' => 'アカウントマネージャー',
	'am-active' => '有効',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'accountmanager' => 'អ្នកគ្រប់គ្រង​គណនី',
	'am-username' => 'ឈ្មោះអ្នកប្រើប្រាស់',
	'am-email' => 'អ៊ីមែល',
	'am-active' => 'សកម្ម',
	'am-updated' => 'បំលាស់ប្ដូរ​របស់​អ្នក ត្រូវ​បាន​រក្សាទុក​ដោយ​ជោគជ័យ​ហើយ',
	'nss-rights' => 'សិទ្ធិ',
	'nss-save-changes' => 'រក្សាទុក​បំលាស់ប្ដូរ',
	'nss-create-account-header' => 'បង្កើត​គណនី​ថ្មី',
	'nss-create-account' => 'បង្កើត​គណនី',
	'nss-no-mail' => 'មិន​ផ្ញើ​អ៊ីមែល',
	'nss-welcome-mail-subject' => 'ការបង្កើត​គណនី',
);

/** Kinaray-a (Kinaray-a)
 * @author Joebertj
 */
$messages['krj'] = array(
	'accountmanager' => 'Gadumala sa Account',
	'am-username' => 'username',
	'am-email' => 'e-mail',
	'am-active' => 'aktibo',
	'am-updated' => 'Ang imo mga gin-ilis nabaton run',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'accountmanager' => 'Metmaacher ier Aanmeldunge verwallde',
	'am-username' => 'Metmaachername',
	'am-email' => '<i lang="en">e-mail</i>',
	'am-active' => 'ne Aktive',
	'am-updated' => 'De Änderunge sen avjespeichert',
	'nss-desc' => 'Ene Zosatz, öm Metmaacher ier Annmeldunge övver en <i lang="en"><code>libnss-mysql</code></i> Datebangk pröve ze lohße. Met enem [[Special:AccountManager|Söndersigg för de Metmaacher ier Aanmeldunge zu verwallde]] dobei.',
	'nss-rights' => 'Rääschte',
	'nss-save-changes' => 'Änderunge avspeichere',
	'nss-create-account-header' => 'Ene neue Metmaacher aanlääje',
	'nss-create-account' => 'Aanlääje',
	'nss-no-mail' => 'Kein <i lang="en">e-mail</i> schecke',
	'nss-welcome-mail' => 'Ene Metmmacher met däm Name „$1“ un dämm Paßwoot „$2“ es för Desch opjesatz woode.',
	'nss-welcome-mail-subject' => 'Metmaacher neu aanmellde.',
	'nss-db-error' => 'Fähler beim Lesse uß dä Datebangk met dä Zohjangßdaate',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'accountmanager' => 'Gestionnaire vun de Benotzerkonten',
	'am-username' => 'Benotzernumm',
	'am-email' => 'E-Mail',
	'am-active' => 'aktiv',
	'am-updated' => 'är Ännerunge goufe gespäichert',
	'nss-desc' => "E Plugin fir sech an enger ''libnss-mysql'' anzeloggen, inlusiv engem [[Special:AccountManager|Gestionnaire vun de Benotzerkonten]]",
	'nss-rights' => 'Rechter',
	'nss-save-changes' => 'Ännerunge späicheren',
	'nss-create-account-header' => 'Een neie Benotzerkont opmaachen',
	'nss-create-account' => 'Benotzerkont opmaachen',
	'nss-no-mail' => 'Keng E-Mail schécken',
	'nss-welcome-mail' => 'E Benotzerkont mat dem Benotzernumm $1 an dem Passwuert $2 gouf fir Iech opgemaach.',
	'nss-welcome-mail-subject' => 'Benotzerkont opmaachen',
	'nss-db-error' => 'Feeler beim Liese vun der Datebank mat den Authentifikatiounen',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'am-email' => 'e-mail',
	'nss-create-account-header' => 'Ticchīhuāz yancuīc cuentah',
	'nss-create-account' => 'Ticchīhuāz cuentah',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'accountmanager' => 'Gebruikersbeheer',
	'am-username' => 'gebruikersnaam',
	'am-email' => 'e-mail',
	'am-active' => 'actief',
	'am-updated' => 'Uw wijzigingen zijn opgeslagen',
	'nss-desc' => 'Een plug-in om te authenticeren tegen een libnss-mysql database. Bevat [[Special:AccountManager|gebruikersbeheer]]',
	'nss-rights' => 'rechten',
	'nss-save-changes' => 'Wijzigingen opslaan',
	'nss-create-account-header' => 'Nieuwe gebruiker aanmaken',
	'nss-create-account' => 'Gebruiker aanmaken',
	'nss-no-mail' => 'Geen e-mail versturen',
	'nss-welcome-mail' => 'Er is een gebruiker met gebruikersnaam $1 en wachtwoord $2 voor u aangemaakt.',
	'nss-welcome-mail-subject' => 'Gebruiker aangemaakt',
	'nss-db-error' => 'Fout bij het lezen van de authenticatiedatabase',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'accountmanager' => 'Kontohandsamar',
	'am-username' => 'brukarnamn',
	'am-email' => 'e-post',
	'am-active' => 'aktiv',
	'am-updated' => 'Endringane dine vart lagra',
	'nss-desc' => 'Eit programtillegg for å identifisera mot ein libnss-mysql-database. Innheheld ein [[Special:AccountManager|kontohandsamar]]',
	'nss-rights' => 'rettar',
	'nss-save-changes' => 'Lagra endringar',
	'nss-create-account-header' => 'Opprett ny konto',
	'nss-create-account' => 'Opprett konto',
	'nss-no-mail' => 'Ikkje send e-post',
	'nss-welcome-mail' => 'Ein konto med brukarnamnet $1 og passordet $2 har vorten oppretta for deg.',
	'nss-welcome-mail-subject' => 'Kontooppretting',
	'nss-db-error' => 'Feil oppstod under lesing av identifiseringsdatabasen',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'accountmanager' => 'Gestionari de comptes',
	'am-username' => "Nom d'utilizaire",
	'am-email' => 'Corrièr electronic',
	'am-active' => 'actiu',
	'am-updated' => 'Vòstras modificacions son estadas salvadas amb succès',
	'nss-desc' => "Una extension que permet d'autentificar gràcias a una banca de donadas libnss-mysql. Conten un [[Special:AccountManager|gestionari de comptes]]",
	'nss-rights' => 'dreches',
	'nss-save-changes' => 'Enregistrar los cambiaments',
	'nss-create-account-header' => 'Crear un compte novèl',
	'nss-create-account' => 'Crear un compte',
	'nss-no-mail' => 'Mandar pas de corrièr electronic',
	'nss-welcome-mail' => 'Un compte amb lo nom $1 e lo senhal $2 es estat creat per vos.',
	'nss-welcome-mail-subject' => 'Creacion de compte',
	'nss-db-error' => "Error pendent la lectura de la banca de donadas d'autentificacion",
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 */
$messages['pl'] = array(
	'accountmanager' => 'Menedżer konta',
	'am-username' => 'nazwa użytkownika',
	'am-email' => 'e-mail',
	'am-active' => 'aktywny',
	'am-updated' => 'Wprowadzone zmiany zostały zapisane pomyślnie',
	'nss-desc' => 'Wtyczka do uwierzytelniania w bazie danych libnss-mysql. Zawiera [[Special:AccountManager|menedżer konta]]',
	'nss-rights' => 'uprawnienia',
	'nss-save-changes' => 'Zapisz zmiany',
	'nss-create-account-header' => 'Utwórz nowe konto',
	'nss-create-account' => 'Utwórz konto',
	'nss-no-mail' => 'Nie wysyłaj e-mailu',
	'nss-welcome-mail' => 'Zostało dla Ciebie utworzone konto z nazwą użytkownika $1 i hasłem $2.',
	'nss-welcome-mail-subject' => 'Utworzenie konta',
	'nss-db-error' => 'Błąd odczytu z uwierzytelniania bazy danych',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'accountmanager' => 'Gestor de contas',
	'am-username' => 'nome de utilizador',
	'am-email' => 'e-mail',
	'am-active' => 'activo',
	'am-updated' => 'As suas alterações foram gravadas com sucesso',
	'nss-desc' => 'Um "plugin" para autenticar numa base de dados libnss-mysql. Contém um [[Special:AccountManager|gestor de contas]]',
	'nss-rights' => 'permissões',
	'nss-save-changes' => 'Gravar alterações',
	'nss-create-account-header' => 'Criar nova conta',
	'nss-create-account' => 'Criar conta',
	'nss-no-mail' => 'Não enviar email',
	'nss-welcome-mail' => 'Uma conta com nome de utilizador $1 e palavra-chave $2 foi criada para si.',
	'nss-welcome-mail-subject' => 'Criação de conta',
	'nss-db-error' => 'Erro na leitura da base de dados de autenticação',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Silviubogan
 */
$messages['ro'] = array(
	'am-username' => 'nume de utilizator',
	'am-email' => 'e-mail',
	'am-active' => 'activ',
	'nss-save-changes' => 'Salvează modificările',
	'nss-create-account-header' => 'Creează cont nou',
	'nss-create-account' => 'Creează cont',
	'nss-welcome-mail-subject' => 'Crearea contului',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'accountmanager' => 'Управление учётными записями',
	'am-username' => 'имя участника',
	'am-email' => 'электронная почта',
	'nss-rights' => 'права',
	'nss-save-changes' => 'Сохранить изменения',
	'nss-create-account-header' => 'Создать новую учётную запись',
	'nss-create-account' => 'Создание учётной записи',
	'nss-welcome-mail' => 'Для вас создана учётная запись с именем $1 и паролем $2.',
	'nss-welcome-mail-subject' => 'Создание учётной записи',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'accountmanager' => 'Správca účtov',
	'am-username' => 'používateľské meno',
	'am-email' => 'email',
	'am-active' => 'aktívny',
	'am-updated' => 'Vaše zmeny boli úspešne uložené',
	'nss-desc' => 'Zásuvný modul na overovanie voči databáze libnss-mysql. Obsahuje [[Special:AccountManager|správcu účtov]].',
	'nss-rights' => 'práva',
	'nss-save-changes' => 'Uložiť zmeny',
	'nss-create-account-header' => 'Vytvoriť nový účet',
	'nss-create-account' => 'Vytvoriť účet',
	'nss-no-mail' => 'Neposielať email',
	'nss-welcome-mail' => 'Bol pre vás vytvorený účet s používateľským menom $1 a heslom $2.',
	'nss-welcome-mail-subject' => 'Vytvorenie účtu',
	'nss-db-error' => 'Chyba pri čítaní z overovacej databázy',
);

/** Swedish (Svenska)
 * @author Najami
 */
$messages['sv'] = array(
	'am-username' => 'användarnamn',
	'am-email' => 'e-post',
	'am-active' => 'aktiv',
	'am-updated' => 'Dina ändringar har sparats',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'am-username' => 'వాడుకరిపేరు',
	'am-email' => 'ఈ-మెయిల్',
	'nss-save-changes' => 'మార్పులను భద్రపరచు',
	'nss-create-account-header' => 'కొత్త ఖాతాని సృష్టించండి',
	'nss-welcome-mail-subject' => 'ఖాతా సృష్టింపు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'accountmanager' => 'Tagapamahala ng kuwenta',
	'am-username' => 'pangalan ng tagagamit',
	'am-email' => 'e-liham',
	'am-active' => 'masigla (aktibo)',
	'am-updated' => 'Matagumpay na nasagip ang iyong mga pagbabago',
	'nss-desc' => "Isang pampasak (''plug-in'') na makapagpapatunay laban sa isang kalipunan ng datong libnss-mysql.  Naglalaman ng isang [[Special:AccountManager|tagapamahala ng kuwenta]]",
	'nss-rights' => 'mga karapatan',
	'nss-save-changes' => 'Sagipin ang mga pagbabago',
	'nss-create-account-header' => 'Lumikha ng bagong kuwenta (akawnt)',
	'nss-create-account' => 'Likhain ang kuwenta (akawnt)',
	'nss-no-mail' => 'Huwag ipadala ang e-liham',
	'nss-welcome-mail' => 'Nilikha para sa iyo ang isang akawnt/kuwentang may pangalan ng tagagamit na $1 at hudyat na $2.',
	'nss-welcome-mail-subject' => 'Paglikha ng kuwenta',
	'nss-db-error' => 'Kamalian sa pagbasa mula sa kalipunan ng datong pampagpapatunay',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'accountmanager' => 'Trình quản lý tài khoản',
	'am-username' => 'tên người dùng',
	'am-email' => 'địa chỉ thư điện tử',
	'am-active' => 'tích cực',
	'am-updated' => 'Đã lưu các thay đổi của bạn thành công',
	'nss-desc' => 'Phần bổ trợ để xác nhận tính danh theo cơ sở dữ liệu libnss-mysql, bao gồm [[Special:AccountManager|trình quản lý tài khoản]]',
	'nss-rights' => 'quyền',
	'nss-save-changes' => 'Lưu các thay đổi',
	'nss-create-account-header' => 'Mở tài khoản mới',
	'nss-create-account' => 'Mở tài khoản',
	'nss-welcome-mail' => 'Bạn đã mở tài khoản với tên $1 và mật khẩu $2.',
	'nss-welcome-mail-subject' => 'Tài khoản mới',
	'nss-db-error' => 'Lỗi truy cập cơ sở dữ liệu tài khoản',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'accountmanager' => 'Kaliguvöm',
	'am-username' => 'gebananem',
	'am-email' => 'pot leäktronik',
	'am-active' => 'jäfedik',
	'am-updated' => 'Votükams olik pedakipons benosekiko',
	'nss-rights' => 'gitäts',
	'nss-save-changes' => 'Dakipön votükamis',
	'nss-create-account-header' => 'Jafön kali nulik',
	'nss-create-account' => 'Jafön kali',
	'nss-no-mail' => 'No sedolös poti leäktronik',
	'nss-welcome-mail' => 'Kal labü gebananem: $1 e letavöd: $2 pejafon ole.',
	'nss-welcome-mail-subject' => 'Kalijafam',
);

