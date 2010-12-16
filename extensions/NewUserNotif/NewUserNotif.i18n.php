<?php
/**
 * Internationalisation file for the extension New User Email Notification
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

$messages = array();

/** English
 * @author Rob Church
 */
$messages['en'] = array(
	'newusernotifsubj'  => 'New user notification for $1',
	'newusernotif-desc' => 'Sends e-mail notification when user accounts are created',
	'newusernotifbody'  => "Hello $1,

A new user account, $2, has been created on $3 at $4.", # optional: $5 date, $6 time
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'newusernotifsubj' => 'This message contains the subject line for the email.
$1 is replaced with the wiki site name.',
	'newusernotif-desc' => 'Shown in [[Special:Version]] as a short description of this extension. Do not translate links.',
	'newusernotifbody' => "This file contains the body text for the e-mail.
* $1 is replaced with the username of the recipient;
* $2 is replaced with the username of the new user account;
* $3 is replaced with the wiki site;
* $4 is replaced with the time and date of the account's creation.
* $5 (optional) is replaced with the date of the account's creation.
* $6 (optional) is replaced with the time of the account's creation.",
);

/** Old English (Anglo-Saxon)
 * @author Wōdenhelm
 */
$messages['ang'] = array(
	'newusernotifbody' => 'Ēalā $1,

Nīƿe brūcendȝerād, $2, ƿæs on $3 macod, on $4.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'newusernotifsubj' => 'إخطار مستخدم جديد ل$1',
	'newusernotif-desc' => 'يرسل إخطار بريد إلكتروني عندما يتم إنشاء حسابات مستخدمين',
	'newusernotifbody' => 'مرحبا يا $1،

حساب مستخدم جديد، $2، تم إنشاؤه على $3 في $4.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'newusernotifsubj' => 'إخطار يوزر جديد ل$1',
	'newusernotif-desc' => 'يبعت إيميل لما يتم إنشاء حسابات يوزرز',
	'newusernotifbody' => 'اهلا و سهلا يا $1،

حساب يوزر  جديد، $2، إتفتح على $3 فى $4.',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'newusernotifsubj' => 'Gruyera wetce warzaf favesik pu $1',
	'newusernotifbody' => 'Va $1 kiavá,

$2 warzafa favesikpata su zo redur koe $3 ko $4.',
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'newusernotif-desc' => 'Vasendt E-Post-Benåchrichtigungen, wãun a neichs Benutzakonto ãnglegt wiad',
	'newusernotifbody' => 'Seavas $1!

Am $5 is um $6 auf $3 a neichs Benutzakonto ãnglegt woan: $2.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'newusernotifsubj' => 'Паведамленьне аб новым удзельніку для $1',
	'newusernotif-desc' => 'Дасылае паведамленьне па электроннай пошце пры стварэньні новых рахункаў',
	'newusernotifbody' => 'Прывітаньне, $1,

Новы рахунак, $2, быў створаны $3 $4.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'newusernotifsubj' => 'Съобщение за нов потребител в $1',
	'newusernotif-desc' => 'Изпраща оповестяване на електронна поща при създаване на нова потребителска сметка',
	'newusernotifbody' => 'Здравейте $1,

В $3 беше регистрирана нова потребителска сметка, $2, на $4.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'newusernotifsubj' => 'Kemenn un implijer nevez evit $1',
	'newusernotif-desc' => "Kas ur c'hemenn dre bostel pa vez krouet kontoù implijer",
	'newusernotifbody' => 'Salud $1,

Ur gont implijer nevez, $2, zo bet krouet war $3 da $4.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'newusernotifsubj' => 'Obavještenje o novom korisniku na $1',
	'newusernotif-desc' => 'Šalje obavještenje putem e-maila kada pri pravljenju novog korisničkog računa',
	'newusernotifbody' => 'Zdravo $1,

Novi korisnički račun, $2, je napravljen na $3 u $4.',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'newusernotifsubj' => 'Hysbysiad am ddefnyddiwr newydd ar $1',
	'newusernotif-desc' => 'Yn anfon e-bost yn hysbysu bod cyfrif defnyddiwr newydd wedi ei sefydlu',
	'newusernotifbody' => "Cyfarchion $1,

Mae cyfrif newydd o'r enw $2 wedi cael ei sefydlu ar $3 am $4.",
);

/** German (Deutsch)
 * @author Purodha
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'newusernotifsubj' => 'Benachrichtung von $1 über die Einrichtung eines neuen Benutzerskontos',
	'newusernotif-desc' => 'Versendet E-Mail-Benachrichtigungen bei Erstellung neuer Benutzerkonten',
	'newusernotifbody' => 'Hallo $1,

Ein neues Benutzerkonto, $2, wurde am $5, $6 Uhr auf $3 angelegt.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'newusernotifsubj' => 'Powěźeńka na nowego wužywarja za $1',
	'newusernotif-desc' => 'Sćelo e-mailowu powěźeńku, gaž se wužywarske konta napóraju',
	'newusernotifbody' => 'Halo $1,

Konto nowego wužywarja, $2, jo se załožyło $4 na $3 .',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'newusernotifsubj' => 'Νέα ειδοποίηση χρήστη για τον $1',
	'newusernotif-desc' => 'Αποστέλλει ειδοποίηση μέσω e-mail όταν δημιουργούνται λογαριασμοί χρηστών',
	'newusernotifbody' => 'Γεια $1,

Ένας νέος λογαριασμός, $2, δημιουργήθηκε στο $3 στις $4.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'newusernotifsubj' => 'Nova notigado de uzanto $1',
	'newusernotifbody' => 'Saluton $1,

Nova konto por uzanto, $2, estis kreita je $3 $4.',
);

/** Spanish (Español)
 * @author Sanbec
 */
$messages['es'] = array(
	'newusernotifsubj' => 'Notificación de un nuevo usuario en $1',
	'newusernotif-desc' => 'Envía un aviso por correo electrónico cuando se crean cuentas de usuario',
	'newusernotifbody' => 'Hola $1:

Ha sido creada una nueva cuenta de usuario, $2, en $3 a las $4',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'newusernotifbody' => 'Tere, $1!

Võrgukohas $3 loodi uus kasutajakonto $2.

Konto loomise aeg: $4',
);

/** Finnish (Suomi)
 * @author Jaakonam
 * @author Nike
 */
$messages['fi'] = array(
	'newusernotifsubj' => 'Tiedote sivuston uudelle käyttäjälle $1',
	'newusernotif-desc' => 'Lähettää sähköpostiviestin, kun käyttäjätunnukset on luotu',
	'newusernotifbody' => 'Tervehdys $1,

Uusi käyttäjätunnus $2 on luotu $3 $4.',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'newusernotifsubj' => 'Notification d’un nouvel utilisateur pour $1',
	'newusernotif-desc' => 'Envoie une notification par courriel quand les comptes utilisateurs sont créés',
	'newusernotifbody' => 'Bonjour $1,

Un nouveau compte utilisateur, $2, a été créé sur $3 le $4.',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'newusernotifbody' => 'Haigh a $1,

Tá cuntas úsáideora nua, $2, cruthaigh ar $3, $4.',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'newusernotifsubj' => 'Notificación de novo usuario para $1',
	'newusernotif-desc' => 'Envía unha notificación por correo electrónico cando se crean contas de usuario',
	'newusernotifbody' => 'Ola $1:

Creouse unha nova conta de usuario, chamada $2, en $3 o $5 ás $6.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'newusernotifsubj' => 'Benochrichtung vu $1 iber e nej Benutzerskonto',
	'newusernotif-desc' => 'Verschickt E-Mail-Benochrichtigunge bim Aalege vu neje Benutzerkonte',
	'newusernotifbody' => 'Sali $1,

E nej Benutzerkonto, $2, isch am $4 uf $3 aagleit wore.',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'newusernotifsubj' => 'הודעת משתמש חדשה עבור $1',
	'newusernotif-desc' => 'שליחת הודעה בדוא"ל כאשר נוצרים חשבונות משתמש',
	'newusernotifbody' => 'שלום $1,

חשבון משתמש חדש, $2, נוצר באתר $3 ב־$4.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'newusernotifsubj' => '$1 का नये सदस्योंका निर्देशन',
	'newusernotif-desc' => 'नया खाता खुलने के बाद इ-मेल भेजता हैं',
	'newusernotifbody' => 'नमस्कार $1,

$3 पर एक नया सदस्य, $2, $4 को पंजिकृत हुआ हैं।',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'newusernotifsubj' => 'Zdźělenka za noweho wužiwarja $1',
	'newusernotif-desc' => 'Sćele e-mejlowe zdźělenje, hdyž so wužiwarske konta wutworja',
	'newusernotifbody' => 'Witaj $1,

Nowe wužiwarske konto, $2, bu dnja $4 na $3 wutworjene.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Tgr
 */
$messages['hu'] = array(
	'newusernotifsubj' => 'Értesítés új $1 felhasználóról',
	'newusernotif-desc' => 'E-mail üzeneteket küld, ha új felhasználói fiókok készülnek',
	'newusernotifbody' => 'Szia $1,

egy új felhasználói fiókot készítettek $2 névvel a(z) $3 wikin, $4-kor.',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'newusernotifsubj' => 'Նոր Մասնակցի Տեղեկացում $1 մասնակցի համար',
	'newusernotifbody' => 'Ողջո՜ւյն, $1։

$3 կայքում ստեղծվել է նոր մասնակցային հաշիվ՝ $2, $4-ին։',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'newusernotifsubj' => 'Notification de un nove usator in $1',
	'newusernotif-desc' => 'Invia un notification per e-mail quando un conto de usator es create',
	'newusernotifbody' => 'Salute $1,

Un nove conto de usator, $2, ha essite create in $3 le $4.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'newusernotifsubj' => 'Pemberitahuan pengguna baru untuk $1',
	'newusernotif-desc' => 'Mengirimkan pemberitahuan lewat surel pada saat akun pengguna dibuat',
	'newusernotifbody' => 'Halo $1,

Sebuah akun pengguna baru, $2, telah dibuat di $3 pada $4.',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'newusernotifsubj' => 'Notifica nuovo utente per $1',
	'newusernotif-desc' => 'Invia una e-mail di notifica quando vengono creati nuovi account',
	'newusernotifbody' => 'Ciao $1,

Un nuovo account, $2, è stato creato su $3 il $4.',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'newusernotifsubj' => '$1 利用者アカウント作成通知',
	'newusernotif-desc' => '利用者アカウントが作成されたときに電子メール通知を送る',
	'newusernotifbody' => 'ようこそ$1さん、

$4、$3上に$2で利用者アカウントを作成しました。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'newusernotifsubj' => 'Notifikasi panganggo anyar kanggo $1',
	'newusernotif-desc' => 'Kirim notifikasi e-mail menawa rékening-rékening panganggo digawé',
	'newusernotifbody' => 'Salam $1,

Sawijining rékening panganggo, $2, wis digawé ing $3 jam $4.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'newusernotifsubj' => 'ការផ្តល់ដំណឹង​ដល់​អ្នកប្រើប្រាស់ថ្មី ចំពោះ $1',
	'newusernotifbody' => 'សួស្តី $1,

គណនី​របស់​អ្នកប្រើប្រាស់ថ្មី, $2, បានត្រូវបង្កើត លើ $3 នៅ $4 ហើយ ។',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'newusernotifsubj' => 'Nohresch övver Ding neu Aanmeldung op $1',
	'newusernotif-desc' => 'Scheck en <i lang="en">e-mail</i> eruß, wann en neu Aanmeldung för ene neue Metmaacher kütt.',
	'newusernotifbody' => 'Jooden Daach $1,

Ene neue Metmaacher mem Name "$2"
es aam $5 öm $6 Uhr en de $3 neu aanjemeldt woode.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'newusernotifsubj' => 'Informatioun iwwer e neie Benotzer op $1',
	'newusernotif-desc' => 'Schéckt eng Informatioun per e-Mail wann e neie Benotzerkont opgemaach gëtt',
	'newusernotifbody' => 'Bonjour $1,

En neie Benotzerkont, $2, gouf op $3 de(n) $4 opgemaach.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'newusernotifsubj' => 'Известување за нов корисник на $1',
	'newusernotif-desc' => 'Испраќа известувања по е-пошта при создавање на кориснички сметки',
	'newusernotifbody' => 'Здраво $1,

На $3 е создадена е нова корисничка сметка по име $2 во $4.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'newusernotifsubj' => '$1 സം‌രംഭത്തിനു വേണ്ടിയുള്ള ഉപയോക്തൃഅറിയിപ്പ് സംവിധാനം.',
	'newusernotif-desc' => 'ഉപയോക്തൃ അംഗത്വങ്ങള്‍ ഉണ്ടാക്കി കഴിയുമ്പോള്‍ ഇമെയില്‍ വിജ്ഞാപനം അയക്കുന്നു',
	'newusernotifbody' => 'പ്രിയ $1,

$2 എന്ന ഒരു പുതിയ ഉപയോക്തൃഅംഗത്വം, $3 സം‌രംഭത്തില്‍ $4നു  സൃഷ്ടിക്കപ്പെട്ടിരിക്കുന്നു.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'newusernotifsubj' => '$1 साठीचे नवीन सदस्य निर्देशन',
	'newusernotif-desc' => 'नवीन सदस्य नोंदणी झाल्यानंतर इ-मेल पाठविते',
	'newusernotifbody' => 'नमस्कार $1,

$3 वर एक नवीन सदस्य नोंदणी, $2, $4 ला झालेली आहे.',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'newusernotifbody' => 'Niltze $1,

Cē yancuīc tlatequitiltilīlli cuentah, $2, ōmochīuh īpan $3 īpan $4.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'newusernotifsubj' => 'Melding van een nieuwe gebruiker op $1',
	'newusernotif-desc' => 'Stuurt een e-mail als nieuwe gebruikers worden aangemaakt',
	'newusernotifbody' => 'Hallo $1.

Er is een nieuwe gebruiker $2 aangemaakt op $3 op $5 om $6.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'newusernotifsubj' => 'Melding om ny brukar for $1',
	'newusernotif-desc' => 'Ein e-post blir sendt når nye brukarkontoar blir oppretta',
	'newusernotifbody' => 'Hei, $1. 

Ein ny brukarkonto, $2, blei oppretta på $3 $4.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'newusernotifsubj' => 'Beskjed om ny bruker for $1',
	'newusernotif-desc' => 'Sender beskjed på e-post når kontoer opprettes',
	'newusernotifbody' => 'Hei, $1. En ny brukerkonto, $2, ble opprettet på $3 $4.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'newusernotifsubj' => 'Notificacion d’un utilizaire novèl per $1',
	'newusernotif-desc' => "Manda una notificacion per corrièr electronic quand los comptes d'utilizaires son creats",
	'newusernotifbody' => "Adissiatz $1, Un compte novèl d'utilizaire, $2, es estat creat sus $3 lo $4.",
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'newusernotifbody' => 'Haiya $1,

uff $3 iss am $5, $6 Uhr en neier Yuuser, $2, komme.',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'newusernotifsubj' => 'Powiadamianie użytkownika $1 o nowych użytkownikach',
	'newusernotif-desc' => 'Wysyła powiadomienie e–mail o utworzeniu nowego konta użytkownika',
	'newusernotifbody' => 'Witaj $1, nowe konto użytkownika, $2, zostało stworzone w dniu $3 o $4.',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'newusernotifsubj' => "Notìfica d'utent neuv për $1",
	'newusernotif-desc' => "A manda n'e-mail ëd notìfica quand che ij cont utent a son creà",
	'newusernotifbody' => "Bondì $1, un neuv utent, $2, a l'é stait creà ansima a $3 dël $4.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'newusernotifsubj' => 'د $1 لپاره د نوي کارونکي يادونه',
	'newusernotifbody' => '$1، سلامونه!

د $2 په نوم يو نوی کارن-حساب په $4 نېټه $3 کې جوړ شوی.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'newusernotifsubj' => 'Nova Notificação de Utilizador para $1',
	'newusernotif-desc' => 'Envia notificações por correio electrónico quando são criadas contas de utilizador',
	'newusernotifbody' => 'Olá, $1,

Uma nova conta de utilizador, $2, foi criada em $3 em $4.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Carla404
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'newusernotifsubj' => 'Notificação de novo usuário para $1',
	'newusernotif-desc' => 'Envia uma notificação por e-mail quando uma conta de utilizador é criada',
	'newusernotifbody' => 'Olá, $1,

Uma nova conta de utilizador, $2, foi criada em $3 em $4.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'newusernotifsubj' => "Notifiche de 'n'utende nuève pe $1",
	'newusernotif-desc' => "Manne 'na mail de notifiche quanne avènene ccrejate le cunde utende",
	'newusernotifbody' => "Cià $1,

'Nu cunde utende nuève, $2, ha state ccrejate sus a $3 'u $4.",
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'newusernotifsubj' => 'Уведомление о новом участнике $1',
	'newusernotif-desc' => 'Отправляет уведомление по электронной почте, когда регистрируется новый участник',
	'newusernotifbody' => 'Привет, $1.

В проекте $3 в $4 была создана новая учётная запись — $2.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'newusernotifsubj' => 'Upozornenie na nových používateľov pre $1',
	'newusernotif-desc' => 'Posiela upozornenia emailom pri vytvorení používateľských účtov',
	'newusernotifbody' => 'Ahoj $1,

$3 na $4 bol vytvorený nový používateľský účet $2.',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'newusernotifsubj' => 'Нови корисник за $1',
	'newusernotif-desc' => 'Шаље мејл обавештења када се нови налог направи',
	'newusernotifbody' => 'Здраво $1
Нови кориснички налог, $2, је направљен на $3 у $4.',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'newusernotifsubj' => 'Novi korisnik za $1',
	'newusernotif-desc' => 'Šalje mejl obaveštenja kada se novi nalog napravi',
	'newusernotifbody' => 'Zdravo $1
Novi korisnički nalog, $2, je napravljen na $3 u $4.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'newusernotifsubj' => 'Bescheedtällen foar $1 uur ju Iengjuchtenge fon n näi Benutserkonto',
	'newusernotifbody' => 'Hallo $1,

N näi Benutserkonto, $2, wuude ap n $4 ap $3 anlaid.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'newusernotifsubj' => "'''Anyar''' ,béja pamaké pikeun $1",
	'newusernotif-desc' => 'Kirim béja ka surélék sabot pamaké anyar dijieun',
	'newusernotifbody' => 'Pikeun $1,

Aya pamaké anyar, $2, geus dijieun dina $3 , $4',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'newusernotifsubj' => 'Meddelande om ny användare för $1',
	'newusernotif-desc' => 'Skickar ett meddelande genom e-post när konton skapas',
	'newusernotifbody' => 'Hej $1,

Ett nytt användar konto, $2, har skapats på $3 som $4.',
);

/** Telugu (తెలుగు)
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'newusernotifsubj' => '$1 కోసం కొత్తవాడుకరి నోటిఫికేషన్',
	'newusernotif-desc' => 'వాడుకరి ఖాతాలను సృష్టించినప్పుడు ఈ-మెయిలు గమనింపులు పంపుతుంది',
	'newusernotifbody' => 'హలో $1,

$3లో $2 అనే కొత్త వాడుకరి ఖాతాని $4కి సృష్టించాం.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'newusernotifsubj' => "Mensajen kona-ba uza-na'in foun ba $1",
	'newusernotif-desc' => "Haruka korreiu eletróniku bainhira kria konta uza-na'in",
	'newusernotifbody' => "Olá $1,

uza-na'in foun ida, $2, naregistrar tiha iha $3 iha loron $4.",
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'newusernotifsubj' => 'Огоҳсозии корбарии ҷадид барои $1',
	'newusernotif-desc' => 'Дар ҳолат эҷод шудани ҳисобҳои корбарӣ паёми огоҳсозӣ тариқи почтаи электронӣ бифирист.',
	'newusernotifbody' => 'Салом $1,

Ҳисоби корбарии ҷадид, $2, дар $3 дар $4 эҷод шуд.',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'newusernotifsubj' => 'Ogohsoziji korbariji çadid baroi $1',
	'newusernotif-desc' => 'Dar holat eçod şudani hisobhoi korbarī pajomi ogohsozī tariqi poctai elektronī bifirist.',
	'newusernotifbody' => 'Salom $1,

Hisobi korbariji çadid, $2, dar $3 dar $4 eçod şud.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'newusernotifsubj' => 'Pabatid na pambagong tagagamit para kay $1',
	'newusernotif-desc' => 'Nagpapadala ng isang pabatid na pang-e-liham kapag nalikha ang bagong mga kuwenta ng tagagamit',
	'newusernotifbody' => 'Kumusta ka $1,

Isang bagong kuwenta/akawnt, $2, ang nalikha na sa $3 noong $4.',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Srhat
 */
$messages['tr'] = array(
	'newusernotifsubj' => '$1 için yeni kullanıcı bildirisi',
	'newusernotif-desc' => 'Kullanıcı hesapları oluşturulduğunda e-posta bildirisi yolla',
	'newusernotifbody' => "Merhaba $1

Yeni kullanıcı hesabı, $2,$3 üzerinde $4'te oluşturuldu.",
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'newusernotifsubj' => 'Nova notifica utente par $1',
	'newusernotif-desc' => 'Manda notifica par e-mail quando xe creà un account utente',
	'newusernotifbody' => 'Ciao $1,

Un novo account utente, $2, el xe stà creà su $3 in data $4.',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'newusernotifsubj' => 'Thông báo thành viên mới cho $1',
	'newusernotif-desc' => 'Gửi thông báo bằng e-mail khi có tài khoản thành viên được tạo',
	'newusernotifbody' => 'Xin chào $1,

Một tài khoản thành viên mới, $2, đã được tạo ra trên $3 lúc $4.',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'newusernotifsubj' => 'Nunod gebaan nulik demü $1',
	'newusernotif-desc' => 'Sedon nunodi leäktronik ven gebanakals pajafons',
	'newusernotifbody' => 'Glidis, o $1!

Gebanakal nulik: $2, pejafon su $3 tü $4.',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'newusernotifsubj' => '$1嘅新用戶通知',
	'newusernotifbody' => '你好 $1，

一個新嘅用戶戶口$2，已經響$4喺$3度開咗。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'newusernotifsubj' => '$1的新用户通知',
	'newusernotif-desc' => '当用户创建时，发送邮件确认电子邮件地址',
	'newusernotifbody' => '你好 $1，

一个新的用户账号$2，已经在$4于$3创建。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 */
$messages['zh-hant'] = array(
	'newusernotifsubj' => '$1的新用戶通知',
	'newusernotif-desc' => '當用戶創建時，發送郵件確認電子郵件地址',
	'newusernotifbody' => '你好 $1，

一個新的用戶帳號$2，已經在$4於$3創建。',
);

