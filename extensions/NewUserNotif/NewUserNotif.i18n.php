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

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'newusernotifsubj' => 'Съобщение за нов потребител в $1',
	'newusernotif-desc' => 'Изпраща оповестяване на електронна поща при създаване на нова потребителска сметка',
	'newusernotifbody' => 'Здравейте $1,

В $3 беше регистрирана нова потребителска сметка, $2, на $4.',
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

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'newusernotifsubj' => 'Nova notigado de uzanto $1',
	'newusernotifbody' => 'Saluton $1,

Nova konto por uzanto, $2, estis kreita je $3 $4.',
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
	'newusernotifbody' => 'Ola $1,

Unha nova conta de usuario, $2, foi creada sobre $3 en $4.',
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
es aam $5 öm $6 Uhr en de $3 neu aanjemeldt woode.

Ene Jrooss vun de {{SITENAME}}',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'newusernotifsubj' => 'Informatioun iwwer e neie Benotzer op $1',
	'newusernotif-desc' => 'Schéckt eng Informatioun per e-Mail wann e neie Benotzerkont opgemaach gëtt',
	'newusernotifbody' => 'Bonjour $1,

E neie Benotzerkont, $2, gouf op $3 de(n) $4 opgemaach.',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'newusernotifsubj' => '$1 സം‌രംഭത്തിനു വേണ്ടിയുള്ള ഉപയോക്തൃഅറിയിപ്പ് സംവിധാനം.',
	'newusernotif-desc' => 'ഉപഭോക്തൃഅക്കൗണ്ടുകള്‍ ഉണ്ടാക്കി കഴിയുമ്പോള്‍ ഇമെയില്‍ വിജ്ഞാപനം അയക്കുന്നു',
	'newusernotifbody' => 'പ്രിയ $1,

$2 എന്ന ഒരു പുതിയ ഉപയോക്തൃഅക്കൗണ്ട്, $3 സം‌രംഭത്തില്‍ $4നു  സൃഷ്ടിക്കപ്പെട്ടിരിക്കുന്നു.',
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

/** Polish (Polski)
 * @author Derbeth
 */
$messages['pl'] = array(
	'newusernotifsubj' => 'Powiadamianie użytkownika $1 o nowych użytkownikach',
	'newusernotifbody' => 'Witaj $1, nowe konto użytkownika, $2, zostało stworzone w dniu $3 o $4.',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'newusernotifsubj' => "Notìfica d'utent neuv për $1",
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
 * @author Malafaya
 */
$messages['pt'] = array(
	'newusernotifsubj' => 'Nova Notificação de Utilizador para $1',
	'newusernotif-desc' => 'Envia uma notificação por e-mail quando uma conta de utilizador é criada',
	'newusernotifbody' => 'Olá, $1,

Uma nova conta de utilizador, $2, foi criada em $3 em $4.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Carla404
 */
$messages['pt-br'] = array(
	'newusernotifsubj' => 'Notificação de novo usuário para $1',
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

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'newusernotifsubj' => 'Нови корисник за $1',
	'newusernotifbody' => 'Здраво $1
Нови кориснички налог, $2, је направљен на $3 у $4.',
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
 * @author Veeven
 */
$messages['te'] = array(
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

/** Turkish (Türkçe)
 * @author Srhat
 */
$messages['tr'] = array(
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

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'newusernotifsubj' => '$1的新用戶通知',
	'newusernotifbody' => '你好 $1，

一個新的用戶帳號$2，已經在$4於$3創建。',
);

