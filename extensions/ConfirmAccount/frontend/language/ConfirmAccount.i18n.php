<?php
/**
 * Internationalisation file for ConfirmAccount extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	# Site message for admins
	'confirmaccount-newrequests' => '\'\'\'$1\'\'\' open e-mail confirmed [[Special:ConfirmAccounts|account {{PLURAL:$1|request is pending|requests are pending}}]]. \'\'\'Your attention is needed!\'\'\'',

	# Add to Special:Login
	'requestaccount-loginnotice' => 'To obtain a user account, you must \'\'\'[[Special:RequestAccount|request one]]\'\'\'.',

	# User rights descriptions
	'right-confirmaccount' => 'View the [[Special:ConfirmAccounts|queue with requested accounts]]',
	'right-requestips' => 'View requester\'s IP addresses while processing requested accounts',
	'right-lookupcredentials' => 'View [[Special:UserCredentials|user credentials]]',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Lejonel
 * @author McDutchie
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'right-confirmaccount' => '{{doc-right|confirmaccount}}',
	'right-requestips' => '{{doc-right|requestips}}',
	'right-lookupcredentials' => '{{doc-right|lookupcredentials}}',
);

/** Arabic (العربية)
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = array(
	'confirmaccount-newrequests' => "{{PLURAL:$1|يوجد|يوجد}} حاليا '''$1'''
{{PLURAL:$1|[[Special:ConfirmAccounts|طلب حساب]]|[[Special:ConfirmAccounts|طلب حساب]]}} مفتوح قيد الانتظار.",
	'requestaccount-loginnotice' => "للحصول على حساب، يجب عليك '''[[Special:RequestAccount|أن تطلب حسابًا]]'''.",
	'right-confirmaccount' => 'عرض [[Special:ConfirmAccounts|طابور الحسابات المطلوبة]]',
	'right-requestips' => 'عرض عنوان آيبي الطالب أثناء العمل على الحسابات المطلوبة',
	'right-lookupcredentials' => 'رؤية [[Special:UserCredentials|شهادات المستخدم]]',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'confirmaccount-newrequests' => "{{PLURAL:$1|يوجد|يوجد}} حاليا '''$1'''
{{PLURAL:$1|[[Special:ConfirmAccounts|طلب حساب]]|[[Special:ConfirmAccounts|طلب حساب]]}} مفتوح قيد الانتظار.",
	'requestaccount-loginnotice' => "للحصول على حساب، يجب عليك '''[[Special:RequestAccount|طلب واحد]]'''.",
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'confirmaccount-newrequests' => "Чакаецца апрацоўка '''$1'''
[[Special:ConfirmAccounts|{{PLURAL:$1|запыту на стварэньне рахунку|запытаў на стварэньне рахунку|запытаў на стварэньне рахунку}}]]. '''Зьвярніце Вашую ўвагу!'''",
	'requestaccount-loginnotice' => "Каб атрымаць рахунак, Вам неабходна '''[[Special:RequestAccount|падаць запыт]]'''.",
	'right-confirmaccount' => 'прагляд [[Special:ConfirmAccounts|запытаў на стварэньне рахункаў]]',
	'right-requestips' => 'прагляд IP-адрасоў з якіх паступалі запыты на стварэньне рахункаў',
	'right-lookupcredentials' => 'прагляд [[Special:UserCredentials|пасьведчаньняў ўдзельнікаў]]',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'requestaccount-loginnotice' => "За да получите потребителска сметка, необходимо е да '''[[Special:RequestAccount|изпратите заявка]]'''.",
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'confirmaccount-newrequests' => "Er mare-mañ ez eus '''$1''' [[Special:ConfirmAccounts|goulenn kont{{PLURAL:$1||}}]] o vont en-dro.",
	'requestaccount-loginnotice' => "Evit kaout ur gont implijer e rankit '''[[Special:RequestAccount|goulenn unan]]'''.",
	'right-confirmaccount' => "Gwelet [[Special:ConfirmAccounts|lostad ar c'hontoù goulennet]]",
	'right-requestips' => "Gwelet chomlec'hioù IP ar c'houlennerien pa vez pledet gant goulennoù krouiñ kontoù nevez.",
	'right-lookupcredentials' => 'Gwelet [[Special:UserCredentials|daveennoù an implijerien]]',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'requestaccount-loginnotice' => "Da biste korisnički račun, morate '''[[Special:RequestAccount|zahtijevati jedan]]'''.",
);

/** Czech (Česky)
 * @author Jkjk
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'requestaccount-loginnotice' => "Chcete-li získat uživatelský účet, je třeba o něj '''[[Special:RequestAccount|požádat]]'''.",
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Kghbln
 * @author Leithian
 * @author MF-Warburg
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking
 * @author Revolus
 * @author Rrosenfeld
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|offener, E-Mail bestätigter Benutzerkontenantrag wartet]]|[[Special:ConfirmAccounts|offene, E-Mail bestätigte Benutzerkontenanträge warten]]}} auf Bearbeitung. '''Bitte kümmere dich darum.'''",
	'requestaccount-loginnotice' => "Um ein neues Benutzerkonto zu erhalten, musst du es '''[[Special:RequestAccount|beantragen]]'''.",
	'right-confirmaccount' => 'Die [[Special:ConfirmAccounts|Warteschlange der angefragten Benutzerkonten]] sehen',
	'right-requestips' => 'Die IP-Adresse des Anfragers für ein Benutzerkonto sehen',
	'right-lookupcredentials' => '[[Special:UserCredentials|Benutzerempfehlungsschreiben]] sehen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|offener, E-Mail bestätigter Benutzerkontenantrag wartet]]|[[Special:ConfirmAccounts|offene, E-Mail bestätigte Benutzerkontenanträge warten]]}} auf Bearbeitung. '''Bitte kümmern Sie sich darum.'''",
	'requestaccount-loginnotice' => "Um ein neues Benutzerkonto zu erhalten, müssen Sie es '''[[Special:RequestAccount|beantragen]]'''.",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|pśez e-mail wobkšuśone|pśez e-mail wobkšuśonej|pśez e-mail wobkšuśone|pśez e-mail wobkšuśonych }} [[Special:ConfirmAccounts|{{PLURAL:$1|póžedanje na konto jo njedocynjone|póžedani na konśe stej njedocynjonej| póžedanja na konta su njedocynjone|póžedanjow na konta jo njedocynjone}}]]. '''Pšosym staraj wó to!'''",
	'requestaccount-loginnotice' => "Aby dostał wužywarske konto, musyš '''[[Special:RequestAccount|póžedanje na nje stajiś]]'''.",
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Cakański rěd z pominanymi kontami]] se woglědaś',
	'right-requestips' => 'IP-adrese póžadarja se woglědaś, mjaztym až se pominane konta pśeźěłuju',
	'right-lookupcredentials' => '[[Special:UserCredentials|Wužywarske wopšawnjeńki]] se woglědaś',
);

/** Esperanto (Esperanto)
 * @author Amikeco
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'requestaccount-loginnotice' => "Akiri uzanto-konton, vi devas '''[[Special:RequestAccount|peti ĝin]]'''.",
);

/** Spanish (Español)
 * @author BicScope
 * @author Crazymadlover
 * @author Fitoschido
 * @author Imre
 * @author Lin linao
 * @author Locos epraix
 * @author Pertile
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'confirmaccount-newrequests' => "'''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|solicitud pendiente|solicitudes pendientes de cuenta}}]] de correo electrónico confirmadas",
	'requestaccount-loginnotice' => "Para obtener una cuenta de usuario, debes '''[[Special:RequestAccount|solicitar una]]'''.",
	'right-confirmaccount' => 'Consulte la [[Special:ConfirmAccounts|cola de solicitudes de cuenta]]',
	'right-requestips' => 'Ver la dirección IP del solicitante mientras se procesan las solicitudes de cuenta',
	'right-lookupcredentials' => 'Ver las [[Special:UserCredentials|credenciales del usuario]]',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Mobe
 * @author Nike
 * @author Str4nd
 * @author Taleman
 * @author Varusmies
 */
$messages['fi'] = array(
	'confirmaccount-newrequests' => "Nyt on '''$1''' {{PLURAL:$1|avoin|avointa}} {{PLURAL:$1|[[Special:ConfirmAccounts|pyyntö]]|[[Special:ConfirmAccounts|pyyntöä]]}} käsiteltävänä.",
	'requestaccount-loginnotice' => "Saadaksesi käyttäjätunnuksen on tehtävä '''[[Special:RequestAccount|käyttäjätunnuspyyntö]]'''.",
	'right-confirmaccount' => 'Nähdä [[Special:ConfirmAccounts|listan pyydetyistä tunnuksista]]',
	'right-requestips' => 'Nähdä hakijan IP-osoitteet käyttäjätilejä käsiteltäessä',
	'right-lookupcredentials' => 'Nähdä [[Special:UserCredentials|käyttäjän luotettavuustiedot]]',
);

/** French (Français)
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Louperivois
 * @author McDutchie
 * @author Meithal
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 * @author Zetud
 */
$messages['fr'] = array(
	'confirmaccount-newrequests' => "Il y a actuellement '''$1''' [[Special:ConfirmAccounts|demande{{PLURAL:$1||s}} de compte]] en cours. '''Votre attention est nécessaire !'''",
	'requestaccount-loginnotice' => "Pour obtenir un compte utilisateur, vous devez en faire '''[[Special:RequestAccount|la demande]]'''.",
	'right-confirmaccount' => 'Voir la [[Special:ConfirmAccounts|file des demandes de compte]]',
	'right-requestips' => 'Voir les adresses IP des demandeurs lors du traitement des demandes de nouveau comptes',
	'right-lookupcredentials' => 'Voir les [[Special:UserCredentials|références des utilisateurs]]',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'confirmaccount-newrequests' => "Ora, y at '''$1''' [[Special:ConfirmAccounts|demand{{PLURAL:$1|a|es}} de compto usanciér]] en cors. '''Voutra atencion est nècèssèra !'''",
	'requestaccount-loginnotice' => "Por avêr un compto usanciér, vos en dête fâre la '''[[Special:RequestAccount|demanda]]'''.",
);

/** Galician (Galego)
 * @author Alma
 * @author Elisardojm
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'confirmaccount-newrequests' => "Actualmente hai '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|solicitude de conta pendente|solicitudes de contas pendentes}}]]. '''Cómpre a súa atención!'''",
	'requestaccount-loginnotice' => "Para obter unha conta de usuario ten que '''[[Special:RequestAccount|solicitar unha]]'''.",
	'right-confirmaccount' => 'Ver a [[Special:ConfirmAccounts|cola coas solicitudes de contas]]',
	'right-requestips' => 'Ver os enderezos IP que solicitan contas',
	'right-lookupcredentials' => 'Ver os [[Special:UserCredentials|credenciais de usuario]]',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|ufige, E-Mail bstätigte Benutzerkontenaatrag wartet]]|[[Special:ConfirmAccounts|ufigi, E-Mail bstätigti Benutzerkontenaaträg warten]]}} uf Bearbeitig. '''Bitte due dich drum chümmre.'''",
	'requestaccount-loginnotice' => "Go ne nej Benutzerkonto iberchu muesch e '''[[Special:RequestAccount|Aatrag stelle]]'''.",
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Lischt mit beaatraite Benutzerkonte]] aaluege',
	'right-requestips' => 'D IP-Adräss vum Aatragsteller aaluege, derwylscht dr Aatrag bearbeitet wird',
	'right-lookupcredentials' => '[[Special:UserCredentials|Zyygnis vum Benutzer]] aaluege',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author StuB
 * @author YaronSh
 */
$messages['he'] = array(
	'confirmaccount-newrequests' => "יש {{PLURAL:$1|[[Special:ConfirmAccounts|בקשה פתוחה ממתינה '''אחת''' לפתוח חשבון]], עם כתובת דואר אלקטרוני מאושרת שממתינה|'''$1''' [[Special:ConfirmAccounts|בקשות פתוחות לפתוח חשבונות]], עם כתובות דואר אלקטרוני מאושרות שממתינות}} לאישור. ''תשומת לבך נדרשת!''",
	'requestaccount-loginnotice' => "כדי לקבל חשבון משתמש, עליכם '''[[Special:RequestAccount|לבקש אחד כזה]]'''.",
	'right-confirmaccount' => 'צפייה ב[[Special:ConfirmAccounts|תור עם החשבונות הדרושים]]',
	'right-requestips' => 'לצפות בכתובות IP של המבקשים בזמן עיבוד בקשות לפתוח חשבון',
	'right-lookupcredentials' => 'צפייה ב[[Special:UserCredentials|הרשאות המשתמש]]',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Kiranmayee
 * @author आलोक
 */
$messages['hi'] = array(
	'requestaccount-loginnotice' => "सदस्य खाता पाने के लिये आप अपनी '''[[Special:RequestAccount|माँग पंजिकृत करें]]'''।",
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'confirmaccount-newrequests' => "u tijeku '''$1''' e-mailom {{PLURAL:$1|potvrđen [[Special:ConfirmAccounts|zahtjev za računom]]|potvrđenih [[Special:ConfirmAccounts|zahtjeva za računom]]}}",
	'requestaccount-loginnotice' => "Da bi dobili suradnički račun, trebate ga '''[[Special:RequestAccount|zatražiti]]'''.",
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'confirmaccount-newrequests' => "{{PLURAL:$1|Čaka|Čakatej|Čakaja|Čaka}} tuchwilu '''$1''' přez e-mejlu [[Special:ConfirmAccounts|{{PLURAL:$1|wobkrućene kontowe požadanje|wobkrućenej kontowej požadani|wobkrućene kontowe požadanja|wobkrućenych kontowych požadanjow}}]]. '''Prošu staraj so wo to!'''",
	'requestaccount-loginnotice' => "Zo by wužiwarske konto dóstał, dyrbiš wo nje '''[[Special:RequestAccount|prosyć]]'''.",
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Čakanski rynk z požadanymi kontami]] sej wobhladać',
	'right-requestips' => 'IP-adresy požadarja sej wobhladać, mjeztym zo so požadane konta předźěłuja',
	'right-lookupcredentials' => '[[Special:UserCredentials|Wužiwarske woprawnjenki]] sej wobhladać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dj
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Tgr
 */
$messages['hu'] = array(
	'confirmaccount-newrequests' => "'''$1''' e-mail megerősített [[Special:ConfirmAccounts| fiók kérés van függőben]]. '''Figyelmet igényel!'''",
	'requestaccount-loginnotice' => "Ha felhasználói fiókot szeretnél, akkor '''[[Special:RequestAccount|kérned kell egyet]]'''.",
	'right-confirmaccount' => '[[Special:ConfirmAccounts|kért felhasználói fiókok várakozási sorának]] megtekintése',
	'right-requestips' => 'az igénylők IP-címeinek megtekintése a kért fiókok feldolgozása közben',
	'right-lookupcredentials' => '[[Special:UserCredentials|felhasználói azonosító információk]] megjelenítése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'confirmaccount-newrequests' => "Es pendente '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|requesta|requestas}} de conto]] aperte e confirmate via e-mail. '''Tu attention es necessari!'''",
	'requestaccount-loginnotice' => "Pro obtener un conto de usator, tu debe '''[[Special:RequestAccount|requestar un]]'''.",
	'right-confirmaccount' => 'Vider le [[Special:ConfirmAccounts|cauda con requestas de conto]]',
	'right-requestips' => 'Vider le adresses IP del requestatores durante le tractamento de requestas de conto',
	'right-lookupcredentials' => 'Vider le [[Special:UserCredentials|credentiales de usatores]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Rex
 */
$messages['id'] = array(
	'confirmaccount-newrequests' => "Terdapat '''$1''' antrean [[Special:ConfirmAccounts|{{PLURAL:$1|permintaan|permintaan}} akun]] yang surelnya telah dikonfirmasi.",
	'requestaccount-loginnotice' => "Untuk mendapatkan sebuah akun pengguna, Anda harus '''[[Special:RequestAccount|mengajukannya]]'''.",
	'right-confirmaccount' => 'Lihat [[Special:ConfirmAccounts|antrean peminta akun]]',
	'right-requestips' => 'Lihat Alamat IP pemohon selama proses permohonan akun',
	'right-lookupcredentials' => 'Lihat [[Special:UserCredentials|pengguna  Kredensial]]',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Ævar Arnfjörð Bjarmason
 */
$messages['is'] = array(
	'confirmaccount-newrequests' => "'''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|notandabeðni|notandabeðnir}}]] {{PLURAL:$1|með staðfest netfang bíður samþykkis|með staðfest netföng bíða samþykkis}}",
	'requestaccount-loginnotice' => "Ef þú ert ekki þegar með aðgang verður þú að '''[[Special:RequestAccount|sækja um einn slíkan]]'''.",
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
 * @author Stefano-c
 */
$messages['it'] = array(
	'confirmaccount-newrequests' => "'''$1''' e-mail {{PLURAL:$1|[[Special:ConfirmAccounts|confermata richiesta account aperta]]|[[Special:ConfirmAccounts|confermate richieste account aperte]]}} in attesa",
	'requestaccount-loginnotice' => "Per ottenere un account utente, è necessario '''[[Special:RequestAccount|richiederne uno]]'''.",
	'right-confirmaccount' => 'Visualizza la [[Special:ConfirmAccounts|coda gli account richiesti]]',
	'right-requestips' => 'Visualizza gli indirizzi IP del richiedente mentre processa gli account richiesti',
	'right-lookupcredentials' => 'Visualizza [[Special:UserCredentials|credenziali utente]]',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Schu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'confirmaccount-newrequests' => "現在、'''$1個'''のメール認証済み{{PLURAL:$1|[[Special:ConfirmAccounts|アカウント申請]]}}が承認待ちになっています。",
	'requestaccount-loginnotice' => "利用者アカウントの取得は、'''[[Special:RequestAccount|アカウント登録申請]]'''から行ってください。",
	'right-confirmaccount' => '[[Special:ConfirmAccounts|アカウント申請キュー]]を見る',
	'right-requestips' => 'アカウント申請の処理中に申請者のIPアドレスを見る',
	'right-lookupcredentials' => '[[Special:UserCredentials|利用者信頼情報]]を見る',
);

/** Jamaican Creole English (Patois)
 * @author Yocahuna
 */
$messages['jam'] = array(
	'confirmaccount-newrequests' => "'''$1''' opn e-miel-kanfoerm [[Special:ConfirmAccounts|akount {{PLURAL:$1|rikwes|rikwes}}]] pendin",
	'requestaccount-loginnotice' => "Fi abtien a yuuza akount, yu fi '''[[Special:RequestAccount|rikwes wan]]'''.",
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'requestaccount-loginnotice' => "Supaya bisa olèh rékening panganggo, panjenengan kudu '''[[Special:RequestAccount|nyuwun iku]]'''.",
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Sovichet
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'requestaccount-loginnotice' => "ដើម្បីទទួលបានគណនីអ្នកប្រើប្រាស់ អ្នកត្រូវតែ'''[[Special:RequestAccount|ស្នើសុំគណនី]]'''។",
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'confirmaccount-newrequests' => "'''\$1''' unjedonn [[Special:ConfirmAccounts|{{PLURAL:\$1|Aanfrooch|Aanfroore|Aanfroore}}]] met beschtääteschte <i lang=\"en\">e-mail</i>-Addräß {{PLURAL:\$1|es|sin|sin}} am waade.",
	'requestaccount-loginnotice' => "Öm ene Zohjang ze krijje, donn '''[[Special:RequestAccount|noh einem froore]]'''.",
	'right-confirmaccount' => 'De [[Special:ConfirmAccounts|Schlang met de aanjefroochte Zohjäng]] beloore',
	'right-requestips' => 'De jewönschte Neu_Metmaacher ier <code lang="en">IP-</code>Addräß aanloore beim Aanfroore beärbeede',
	'right-lookupcredentials' => 'De [[Special:UserCredentials|Nohwiise]] för Metmaacher aanloore',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'confirmaccount-newrequests' => "'''$1''' open, per E-Mail confirméiert, [[Special:ConfirmAccounts|account {{PLURAL:$1|Ufro|Ufroen}}]] déi drop {{PLURAL:$1|waart|waarden}} beäntwert ze ginn. '''Är Mataarbecht gëtt gebraucht!'''",
	'requestaccount-loginnotice' => "Fir e Benotzerkont ze kréien, musst Dir '''[[Special:RequestAccount|een ufroen]]'''.",
	'right-confirmaccount' => "D'[[Special:ConfirmAccounts|Queue mat den ugefrote Benotzerkonte]] kucken",
	'right-requestips' => "D'IP-Adress vun där d'Ufro koum uweise wann d'Ufro fir e Benotzerkont verschafft gëtt",
	'right-lookupcredentials' => '[[Special:UserCredentials|Referenze vun de Benotzer]] kucken',
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'confirmaccount-newrequests' => "Dao {{PLURAL:$1|steit|stoon}} '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|gebroekersaanvraog|gebroekersaanvraoge}}]] aope. '''Dien aandach is nujig!'''",
	'requestaccount-loginnotice' => "Um 'n gebroekersaccount te kriege mós te '''[[Special:RequestAccount|'ne aanvraog doon]]'''",
	'right-confirmaccount' => '[[Special:CorfirmAccounts|Wachrie mit gebroekersaanvraoge]] betrachte',
	'right-requestips' => "De IP-adresse van aanvraogers betrachte bie 't verwirke van gebroekersaanvraage",
	'right-lookupcredentials' => '[[Special:UserCredentials|Gebroekersreferenties]] betrachte',
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = array(
	'confirmaccount-newrequests' => "Ana '''$1''' antrean [[Special:ConfirmAccounts|{{PLURAL:$1|penjalukan|penjalukan}} akun]] sing imel-e uwis dikonfirmasi. '''Gageyan diproses!'''",
	'requestaccount-loginnotice' => "Ben teyeng nduwe akun panganggo, Rika kudu '''[[Special:RequestAccount|njaluk akun]]'''.",
	'right-confirmaccount' => 'Deleng [[Special:ConfirmAccounts|antrean penjalukan akun]]',
	'right-requestips' => 'Deleng Alamat IP-ne sing njaluk akun selama proses penjalukan akun',
	'right-lookupcredentials' => 'Deleng [[Special:UserCredentials|panganggo Kredensial]]',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'confirmaccount-newrequests' => "Има '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|отворено барање за сметка|отворени барања за сметка}}]] во исчекување. '''Потребно е вашето внимание!'''",
	'requestaccount-loginnotice' => "За да добиете корисничка сметка, морате да '''[[Special:RequestAccount|поднесете барање]]'''.",
	'right-confirmaccount' => 'Погледајте ја [[Special:ConfirmAccounts|редицата со побарани сметки]]',
	'right-requestips' => 'Прегледување на IP-адресите на барателот при работата на побарани сметки',
	'right-lookupcredentials' => 'Погледајте ги [[Special:UserCredentials|препораките за корисникот]]',
);

/** Malayalam (മലയാളം)
 * @author Jacob.jose
 * @author Junaidpv
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'confirmaccount-newrequests' => "ഇമെയിൽ വിലാസം സ്ഥിരീകരിക്കപ്പെട്ട '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|അംഗത്വത്തിനായുള്ള അഭ്യർത്ഥന]]|[[Special:ConfirmAccounts|അംഗത്വത്തിനായുള്ള അഭ്യർത്ഥനകൾ]]}} പെൻ‌ഡിംങ്ങാണ്‌.",
	'requestaccount-loginnotice' => "ഉപയോക്തൃ അംഗത്വം ലഭിക്കുന്നതിനായി താങ്കൾ '''[[Special:RequestAccount|ഉപയോക്തൃഅംഗത്വത്തിനായി അഭ്യർത്ഥിക്കണം]]'''.",
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'confirmaccount-newrequests' => "'''$1''' इमेल पत्ता तपासलेला आहे {{PLURAL:$1|[[Special:ConfirmAccounts|खात्याची मागणी]]|[[Special:ConfirmAccounts|खात्यांची मागणी]]}} शिल्लक",
	'requestaccount-loginnotice' => "सदस्य खाते मिळविण्यासाठी तुम्ही तुमची '''[[Special:RequestAccount|मागणी नोंदवा]]'''.",
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'confirmaccount-newrequests' => "'''$1''' [[Special:ConfirmAccounts|permintaan akaun]] yang disahkan oleh pembukaan e-mel sedang menunggu. '''Perhatian anda diperlukan!'''",
	'requestaccount-loginnotice' => "Untuk memperoleh akaun pengguna, anda mesti '''[[Special:RequestAccount|membuat permohonan]]'''.",
	'right-confirmaccount' => 'Melihat [[Special:ConfirmAccounts|baris gilir dengan akaun-akaun yang dimohon]]',
	'right-requestips' => 'Melihat alamat-alamat IP pemohon ketika memproseskan akaun-akaun yang dimohon',
	'right-lookupcredentials' => 'Melihat [[Special:UserCredentials|kelayakan pengguna]]',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'confirmaccount-newrequests' => "Det er foreløpig '''$1''' {{PLURAL:$1|åpen [[Special:ConfirmAccounts|kontoforespørsel]]|åpne [[Special:ConfirmAccounts|kontoforespørsler]]}}.",
	'requestaccount-loginnotice' => "For å få en brukerkonto må du '''[[Special:RequestAccount|etterspørre en]]'''.",
	'right-confirmaccount' => 'Vis [[Special:ConfirmAccounts|køen av kontosøknader]]',
	'right-requestips' => 'Vis søkerenes IP-adresser mens man behandler kontosøknadene',
	'right-lookupcredentials' => 'Vis [[Special:UserCredentials|brukerattester]]',
);

/** Dutch (Nederlands)
 * @author Annabel
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'confirmaccount-newrequests' => "Er {{PLURAL:$1|staat|staan}} '''$1''' [[Special:ConfirmAccounts|{{PLURAL:$1|gebruikersaanvraag|gebruikersaanvragen}}]] open. '''Uw aandacht is nodig!'''",
	'requestaccount-loginnotice' => "Om een gebruiker te krijgen, moet u '''[[Special:RequestAccount|een aanvraag doen]]'''.",
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Wachtrij met gebruikersaanvragen]] bekijken',
	'right-requestips' => 'De IP-adressen van aanvragers bekijken bij het verwerken bij het verwerken van gebruikersaanvragen',
	'right-lookupcredentials' => '[[Special:UserCredentials|gebruikersreferenties]] bekijken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'confirmaccount-newrequests' => "Det finst for tida {{PLURAL:$1|'''éin''' open [[Special:ConfirmAccounts|kontoførespurnad]]|'''$1''' opne [[Special:ConfirmAccounts|kontoførespurnader]]}}.",
	'requestaccount-loginnotice' => "For å få ein brukarkonto må du '''[[Special:RequestAccount|be om ein]]'''.",
	'right-confirmaccount' => 'Vis [[Special:ConfirmAccounts|køen av kontosøknader]]',
	'right-requestips' => 'Vis søkjaren sine IP-adresser medan kontosøknadene er til handsaming',
	'right-lookupcredentials' => 'Vis [[Special:UserCredentials|brukarattestar]]',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'confirmaccount-newrequests' => "Actualament i a '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|demanda de compte]]|[[Special:ConfirmAccounts|demandas de compte]]}} en cors.",
	'requestaccount-loginnotice' => "Per obténer un compte d'utilizaire, vos ne cal far '''[[Special:RequestAccount|la demanda]]'''.",
	'right-confirmaccount' => 'Vejatz la [[Special:ConfirmAccounts|fila de las demandas de compte]]',
	'right-requestips' => 'Vejatz las adreças IP dels demandaires al moment del tractament de las demandas de comptes novèls',
	'right-lookupcredentials' => 'Vejatz las [[Special:UserCredentials|referéncias dels utilizaires]]',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Equadus
 * @author Leinad
 * @author Maikking
 * @author Masti
 * @author McMonster
 * @author Sp5uhe
 * @author ToSter
 * @author Wpedzich
 */
$messages['pl'] = array(
	'confirmaccount-newrequests' => "{{PLURAL:$1|Jest '''$1''' [[Special:ConfirmAccounts|oczekujący wniosek]]|Są '''$1''' [[Special:ConfirmAccounts|oczekujące wnioski]]|Jest '''$1''' [[Special:ConfirmAccounts|oczekujących wniosków]]}}, z potwierdzonym adresem e‐mail. '''Konieczna jest Twoja ingerencja!'''",
	'requestaccount-loginnotice' => "By uzyskać konto użytkownika musisz '''[[Special:RequestAccount|złożyć wniosek]]'''.",
	'right-confirmaccount' => 'Przeglądanie [[Special:ConfirmAccounts|kolejki z wnioskami o założenie konta]]',
	'right-requestips' => 'Przeglądanie adresów IP wnioskodawców podczas przetwarzania ich wniosków o założenie konta',
	'right-lookupcredentials' => 'Przeglądanie [[Special:UserCredentials|referencji użytkowników]]',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'confirmaccount-newrequests' => "'''$1''' mëssagi ch'a speto [[Special:ConfirmAccounts|{{PLURAL:$1|d'arcesta ëd cont confermà|d'arceste ëd cont confermà}}]]. '''A-i é dabzògn ëd soa atension!'''",
	'requestaccount-loginnotice' => "Për deurb-se un sò cont utent, a venta '''[[Special:RequestAccount|ch<nowiki>'</nowiki>a në ciama un]]'''.",
	'right-confirmaccount' => 'Vardé la [[Special:ConfirmAccounts|coa con ij cont ciamà]]',
	'right-requestips' => "Vardé j'adrësse IP dël ciamant durant ël tratament dij cont ciamà",
	'right-lookupcredentials' => 'Visualisa [[Special:UserCredentials|credensiaj utent]]',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'confirmaccount-newrequests' => "Há actualmente {{PLURAL:$1|'''um''' [[Special:ConfirmAccounts|pedido de conta]] em aberto, confirmado|'''$1''' [[Special:ConfirmAccounts|pedidos de conta]] em aberto, confirmados}} por correio electrónico, {{PLURAL:$1|pendente|pendentes}}.",
	'requestaccount-loginnotice' => "Para obter uma conta de utilizador, deverá '''[[Special:RequestAccount|pedi-la]]'''.",
	'right-confirmaccount' => 'Ver a [[Special:ConfirmAccounts|fila de contas pedidas]]',
	'right-requestips' => 'Ver os endereços IP do requerente ao processar contas pedidas',
	'right-lookupcredentials' => 'Ver [[Special:UserCredentials|credenciais de utilizador]]',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'confirmaccount-newrequests' => "Há atualmente '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|requisições de conta]] aberto pendente|[[Special:ConfirmAccounts|requisições de conta]] abertos pendentes}}.",
	'requestaccount-loginnotice' => "Para obter uma conta de utilizador, deverá '''[[Special:RequestAccount|requisitá-la]]'''.",
	'right-confirmaccount' => 'Visualizar a [[Special:ConfirmAccounts|fila com contas requisitadas]]',
	'right-requestips' => 'Visualizar os endereços de IP durante o processamento das contas pedidas.',
	'right-lookupcredentials' => 'Visualizar [[Special:UserCredentials|credenciais de usuário]]',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Kaganer
 * @author Kv75
 * @author Lockal
 * @author MaxSem
 * @author Rubin
 * @author Sasha Blashenkov
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'confirmaccount-newrequests' => "Ожидается обработка '''$1'''
{{PLURAL:$1|[[Special:ConfirmAccounts|запроса на учётную запись]]|[[Special:ConfirmAccounts|запросов на учётные записи]]|[[Special:ConfirmAccounts|запросов на учётные записи]]}}.",
	'requestaccount-loginnotice' => 'Чтобы получить учётную запись, вы должны её [[Special:RequestAccount|запросить]].',
	'right-confirmaccount' => 'просмотр [[Special:ConfirmAccounts|запросов на создание учётных записей]]',
	'right-requestips' => 'Просмотр IP-адресов авторов запросов на создание учётных записей',
	'right-lookupcredentials' => 'просмотр [[Special:UserCredentials|удостоверяющей информации об участниках]]',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'confirmaccount-newrequests' => "Momentálne {{PLURAL:$1|je jedna otvorená|sú '''$1''' otvorené|je '''$1''' otvorených}} 
[[Special:ConfirmAccounts|{{PLURAL:$1|žiadosť o účet|žiadosti o účet|žiadostí o účet}}]].",
	'requestaccount-loginnotice' => "Aby ste dostali používateľský účet, musíte '''[[Special:RequestAccount|oň požiadať]]'''.",
	'right-confirmaccount' => 'Zobraziť [[Special:ConfirmAccounts|front žiadostí o účet]]',
	'right-requestips' => 'Zobraziť IP adresu žiadateľa pri spracovaní žiadostí o účet',
	'right-lookupcredentials' => 'Zobraziť [[Special:UserCredentials|údaje používateľa]]',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'confirmaccount-newrequests' => "'''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|eepenen, E-Mail bestäätigden Benutserkontenandraach täift]]|[[Special:ConfirmAccounts|eepene, E-Mail bestäätigde Benutserkontenandraage täiwe]]}} ap Beoarbaidenge.",
	'requestaccount-loginnotice' => "Uum n näi Benutserkonto tou kriegen, moast du
der uum '''[[{{ns:special}}:RequestAccount|fräigje]]'''.",
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'requestaccount-loginnotice' => "Pikeun miboga rekening pamaké, anjeun kudu '''[[Special:RequestAccount|daptar heula]]'''.",
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Diupwijk
 * @author Fluff
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'confirmaccount-newrequests' => "'''$1''' öppnade e-post bekräftade att [[Special:ConfirmAccounts|{{PLURAL:$1|kontoansökning väntar på att behandlas|kontoansökningar väntar på att behandlas}}]]. '''Din uppmärksamhet krävs!'''",
	'requestaccount-loginnotice' => "För att få ett användarkonto måste du '''[[Special:RequestAccount|ansöka om det]]'''.",
	'right-confirmaccount' => 'Visa [[Special:ConfirmAccounts|kön av kontoansökningar]]',
	'right-requestips' => 'Visa sökandens IP-adress vid behandling av kontoansökningar',
	'right-lookupcredentials' => 'Visa [[Special:UserCredentials|användaruppgifter]]',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'confirmaccount-newrequests' => "ప్రస్తుతం '''$1''' {{PLURAL:$1|[[Special:ConfirmAccounts|ఖాతా అభ్యర్థన]]|[[Special:ConfirmAccounts|ఖాతా అభ్యర్థనలు]]}} వేచి{{PLURAL:$1|వుంది|వున్నాయి}}.",
	'requestaccount-loginnotice' => "ఖాతా పొందడానికి, మీరు తప్పనిసరిగా '''[[Special:RequestAccount|అభ్యర్థించాలి]]'''.",
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'requestaccount-loginnotice' => "Барои дастрас кардани ҳисоби корбарӣ, шумо бояд '''[[Special:RequestAccount|дархост]]''' кунед.",
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'requestaccount-loginnotice' => "Baroi dastras kardani hisobi korbarī, şumo bojad '''[[Special:RequestAccount|darxost]]''' kuned.",
);

/** Thai (ไทย)
 * @author Ans
 * @author Harley Hartwell
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'requestaccount-loginnotice' => "เพื่อที่จะได้มาซึ่งบัญชีผู้ใช้ใหม่ คุณต้อง'''[[Special:RequestAccount|ทำการขอบัญชีผู้ใช้]]'''",
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'confirmaccount-newrequests' => "'''$1''' naghihintay na bukas pang {{PLURAL:$1|[[Special:ConfirmAccounts|account request]]|[[Special:ConfirmAccounts|mga paghiling ng akawnt]]}} na natiyak na ng e-liham",
	'requestaccount-loginnotice' => "Upang makatanggap ng isang akawnt ng tagagamit, dapat kang '''[[Special:RequestAccount|humiling ng isa]]'''.",
	'right-confirmaccount' => 'Tingnan ang [[Special:ConfirmAccounts|pila na may hinihiling na mga akawnt]]',
	'right-requestips' => 'Tingnan ang mga adres ng IP ng humihiling habang isinasagawa ang hinihiling na mga akawnt',
	'right-lookupcredentials' => 'Tingnan ang [[Special:UserCredentials|mga kredensyal ng tagagamit]]',
);

/** Turkish (Türkçe)
 * @author Homonihilis
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'confirmaccount-newrequests' => "'''$1''' açık e-postası doğrulanmış [[Special:ConfirmAccounts|hesap {{PLURAL:$1|istek|istek}}]] beklemede",
	'requestaccount-loginnotice' => "Bir kullanıcı hesabı almak için, '''[[Special:RequestAccount|istekte bulunmanız]]''' gerekmektedir.",
	'right-confirmaccount' => '[[Special:ConfirmAccounts|Hesap istekleri grubunu]] görür',
	'right-requestips' => 'İstenen hesaplarla ilgili işlem yaparken istek sahibinin IP adresini görür',
	'right-lookupcredentials' => '[[Special:UserCredentials|Kullanıcı referanslarını]] görür',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'requestaccount-loginnotice' => "要拎一個用戶戶口，你一定要'''[[Special:RequestAccount|請求一個]]'''。",
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenxiaoqino
 * @author Hydra
 * @author Kuailong
 * @author Mark85296341
 * @author Wilsonmess
 */
$messages['zh-hans'] = array(
	'requestaccount-loginnotice' => "要取得个用户账户，您一定要'''[[Special:RequestAccount|请求一个]]'''。",
	'right-confirmaccount' => '查看 [[Special:ConfirmAccounts|请求帐户的队列]]',
	'right-requestips' => '在处理请求的帐户查看请求者的 IP 地址',
	'right-lookupcredentials' => '查看 [[Special:UserCredentials|用户凭据]]',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'confirmaccount-newrequests' => "'''$1'''開啟電郵確認[[Special:ConfirmAccounts|{{PLURAL:$1|帳戶請求|多個帳戶請求}}]]待審中",
	'requestaccount-loginnotice' => "要取得個使用者帳號，您一定要'''[[Special:RequestAccount|請求一個]]'''。",
	'right-confirmaccount' => '查看[[Special:ConfirmAccounts|待審帳戶隊列]]',
	'right-requestips' => '在處理帳戶請求時查看請求者的IP地址',
	'right-lookupcredentials' => '查看[[Special:UserCredentials|用戶憑據]]',
);

