<?php

$messages = array();

$messages['en'] = array(
	'comboajaxlogin-desc' => 'Dynamic box which allow users to login, remind password and register users',
	"comboajaxlogin-createlog" => "Log in or create an account",
	"comboajaxlogin-actionmsg" => "To perform this action you first need to log in or create an account",
	"comboajaxlogin-actionmsg-protected" => "To perform this action you first need to log in or create an account.",
	"comboajaxlogin-connectmarketing" => "<h1>Connect your accounts</h1>
<ul>
<li>Keep your current username, history, edits... nothing changes except how you log in</li>
<li>Share your activity on Wikia with your friends on Facebook</li>
<li>Complete control of what is published</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Log in with Facebook Connect</h1>',
	"comboajaxlogin-connectmarketing-oasis" => "<h1>Connect your Wikia account to Facebook</h1>
<ul>
<li>Keep your current username, history, edits... nothing changes except how you log in</li>
<li>Share your activity on Wikia with your friends on Facebook, with complete control of what is published</li>
</ul>",
	"comboajaxlogin-connectmarketing-back" => "« Back",
	"comboajaxlogin-connectmarketing-forward" => "Get started »",
	"comboajaxlogin-connectdirections" => "Enter your Wikia username and password here - we will magically connect your Wikia and Facebook accounts in the background.

Once you are done, you can log in easily using any Facebook Connect button.",
	"comboajaxlogin-post-not-understood" => "There was an error in the way this form was constructed.
Please try again or [[Special:Contact|report this]].",
	'comboajaxlogin-readonlytext' => "<h2>Sorry!</h2>
<p>You can't create an account at the moment - we should be up and running again shortly. Here's what's happening:<br /><em>$1</em></p>
<p>Please check <a href=\"http://twitter.com/wikia\">Twitter</a> or <a href=\"http://facebook.com/wikia\">Facebook</a> for more information.
<br />
(If you already have an account, you can <a href=\"#\">log in</a> as normal, but you won't be able to edit.)</p>",
	"comboajaxlogin-ajaxerror" => "Wikia is not responding. Please check your network connection.",
);

/** Message documentation (Message documentation)
 * @author Shirayuki
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'comboajaxlogin-createlog' => ' Prompts the user to log in order create an account to proceed. Appears to the user when they reach a page that requires a "user" or higher permission.',
	'comboajaxlogin-connectmarketing' => 'A message that appears on the login dialog which prompts the user to start the Facebook account connection process.',
	'comboajaxlogin-connectmarketing-oasis' => "A message that appears on the login dialog which prompts the user to start the Facebook account connection process.  Similar to {{msg-wikia|comboajaxlogin-connectmarketing|notext=yes}} except that it explicitly calls out that the connection is for Facebook Connect.  This is necessary because the login dialog box does not have other mentions of Facebook Connect on it, so it wouldn't be clear otherwise.",
	'comboajaxlogin-connectmarketing-back' => '{{Identical|Back}}',
	'comboajaxlogin-connectmarketing-forward' => '{{Identical|Get started}}',
	'comboajaxlogin-readonlytext' => 'Message that appears when database is in read-only mode and account creation can not be completed. Please keep the links to Wikia Twitter and Facebook pages in the message.

Parameters:
* $1 - is the specific reason given for the read-only mode',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Alexknight12
 */
$messages['ar'] = array(
	'comboajaxlogin-desc' => 'صندوق ديناميكي يسمح للمستخدمين بتسجيل الدخول كما يذكرهم بكلمة السر و المستخدمين المسجلين.',
	'comboajaxlogin-createlog' => 'تسجيل الدخول أو إنشاء حساب',
	'comboajaxlogin-actionmsg' => 'لكي تقوم بهذه العملية يجب عليك أولا تسجيل الدخول أو إنشاء حساب',
	'comboajaxlogin-actionmsg-protected' => 'لتنفيذ هذا الإجراء، تحتاج أولاً لتسجيل الدخول أو إنشاء حساب.',
	'comboajaxlogin-connectmarketing' => '<h1>اربط حساباتك</h1>
<ul>
<li>حافظ على اسم المستخدم الحالي, تاريخ المساهمات, التعديلات... لا شيء يتغير إلا كيفية تسجيل الدخول</li>
<li>شارك نشاطك في ويكيا مع أصدقائك في الفيسبوك</li>
<li>تحكم فيما ينشر على الفيسبوك الخاص بك</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>سجل الدخول عبر فيسبوك كونيكت</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>قم بربط حسابك في ويكيا مع حسابك في الفيسبوك</h1>
<ul>
<li>حافظ على اسم المستخدم الحالي, تاريخ المساهمات, التعديلات... لا شيء يتغير إلا كيفية تسجيل الدخول</li>
<li>شارك نشاطك في ويكيا مع أصدقائك في الفيسبوك، مع تحكم كامل في كل ما ينشر على فيسبوكك</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; العودة',
	'comboajaxlogin-connectmarketing-forward' => 'إبدأ »',
	'comboajaxlogin-connectdirections' => 'قم بإدخال اسم متخدمك وكلمة مرورك في ويكيا - سوف نقوم بربط حسابك في ويكيا مع الحساب في الفيسبوك سحريا.

عندما تنتهي، يمكنك الدخول بسهولة عبر زر "اتصال عبر الفيسبوك".',
	'comboajaxlogin-post-not-understood' => 'كان هناك خطأ في الطريقة التي أنشئ فيها هذا النموذج.
الرجاء المحاولة مرة أخرى أو [[Special:Contact|إرسال تقرير]].',
	'comboajaxlogin-readonlytext' => '<h2>عذراً!</h2>
<p>لا يمكنك إنشاء حساب في الوقت الراهن - سوف تتمكن من ذلك من المفروض بعد قليل، هذا ما حدث:<br /><em>$1</em></p>
<p>الرجاء التحقق من <a href="http://twitter.com/wikia">التويتر</a> أو <a href="http://facebook.com/wikia">الفيسبوك</a> للحصول على مزيد من المعلومات.
</br>
(إذا كان لديك حساب بالفعل، يمكنك <a href="#">تسجيل الدخول</a> بشكل طبيعي، إلا أنك لن تكون قادراً على التحرير.)</p>',
	'comboajaxlogin-ajaxerror' => 'ويكيا لا يمكنها الاستجابة لك. الرجاء التحقق من الشبكة الخاصة بك',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'comboajaxlogin-desc' => "Cuadru dinámicu que permite la entrada d'usuarios, recordar la conseña y rexistrar usuarios",
	'comboajaxlogin-createlog' => 'Entrar o crear una cuenta',
	'comboajaxlogin-actionmsg' => "Pa facer esta aición, primero tienes d'entrar o crear una cuenta",
	'comboajaxlogin-actionmsg-protected' => "Pa facer esta aición, primero tienes d'entrar o crear una cuenta.",
	'comboajaxlogin-connectmarketing' => "<h1>Coneuta les tos cuentes</h1>
<ul>
<li>Caltién el to nome d'usuariu actual, historial, ediciones... res nun camuda menos la manera d'entrar</li>
<li>Comparti la to actividá en Wikia colos amigos de Facebook</li>
<li>Control completu de lo que s'espubliza</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Coneutar con Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Coneuta la cuenta de Wikia con Facebook</h1>
<ul>
<li>Caltién el to nome d'usuariu actual, historial, ediciones... res nun camuda menos la manera d'entrar</li>
<li>Comparti la to actividá en Wikia colos amigos de Facebook, con control completu de lo que s'espubliza</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '&laquo; Atrás',
	'comboajaxlogin-connectmarketing-forward' => 'Primeros pasos &raquo;',
	'comboajaxlogin-connectdirections' => "Escribi equí el to nome d'usuariu y conseña de Wikia - en segundu planu coneutaremos máxicamente les tos cuentes de Wikia y Facebook.

Cuando acabes, podrás entrar fácilmente usando cualesquier botón de Facebook Connect.",
	'comboajaxlogin-post-not-understood' => "Hebo un fallu na manera en que taba construíu esti formulariu.
Téntalo otra vuelta o [[Special:Contact|informa d'ello]].",
	'comboajaxlogin-readonlytext' => '<h2>¡Lo sentimos!</h2>
<p>Nun pues crear una cuenta nesti momentu - tendríamos de volver a tar funcionando nun tris. Esto ye lo que ta pasando:<br /><em>$1</em></p>
<p>Por favor, visita <a href="http://twitter.com/wikia">Twitter</a> o <a href="http://facebook.com/wikia">Facebook</a> pa más información.
<br />
(Si yá tienes una cuenta, pues <a href="#">entrar</a> de mou normal, pero nun podrás editar.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia nun ta respondiendo. Por favor, comprueba la to conexón.',
);

/** Bashkir (башҡортса)
 * @author Ләйсән
 */
$messages['ba'] = array(
	'comboajaxlogin-createlog' => 'Танылыу йәки теркәлеү',
);

/** Bikol Central (Bikol Central)
 * @author Geopoet
 */
$messages['bcl'] = array(
	'comboajaxlogin-desc' => 'Dinamikong kahon na minatugot sa mga paragamit na maglaog, magpagiromdom kan pasa-taramon asin magrehistro nin mga paragamit',
	'comboajaxlogin-createlog' => 'Magloag o magmukna nin panindog',
	'comboajaxlogin-actionmsg' => 'Tanganing gibohon ining aksyon ika enot na kaipuhang maglaog o magmukna nin panindog',
	'comboajaxlogin-actionmsg-protected' => 'Tanganing gibohon ining aksyon ika enot na kaipuhang maglaog o magmukna nin panindog',
	'comboajaxlogin-connectmarketing' => '<h1>Ikonekta an saimong mga panindog</h1> <ul> <li>Sayudon an saimong pangaran nin paragamit ngunyan, historiya, mga pagliwat... mayong maliliwat laen lang kun paanuhon ka maglaog</li> <li>Iheras an saimong aktibidad sa Wikia kaiban an saimong mga kaaramigohan sa Facebook</li> <li>Kumpletong kontrol kun ano an pinagpublikar</li> </ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Maglaog na gamit an Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Ikonekta an saimong mga panindog</h1> 
<ul> 
<li>Sayudon an saimong pangaran nin paragamit ngunyan, historiya, mga pagliwat... mayong maliliwat laen lang kun paanuhon ka maglaog</li> 
<li>Iheras an saimong aktibidad sa Wikia kaiban an saimong mga kaaramigohan sa Facebook</li> <li>Kumpletong kontrol kun ano an pinagpublikar</li> </ul>',
	'comboajaxlogin-connectmarketing-back' => '<< Magbuwelta',
	'comboajaxlogin-connectmarketing-forward' => 'Magpoon ka na >>',
	'comboajaxlogin-connectdirections' => 'Ikaag an saimong pangaran nin paragamit sa Wikia asin pasa-taramon digde - samuyang makison na maikonekta sa saimong Wikia asin mga panindog sa Facebook na yaon sa kalikudan.',
	'comboajaxlogin-post-not-understood' => 'Igwa nin kasalaan sa paagi na ining porma pinaggibo.
Pakiprubar giraray o [[Special:Contact|ireport ini]].',
	'comboajaxlogin-readonlytext' => '<h2>Sori ha!</h2>
<p>Ika dae makakapagmukna nin panindog sa ngunyan - kami mabangon asin magdadalagan giraray sa dae mahaloy. Uya baya kun ano an nangyayari:<br /><em>$1</em></p> <p>Pakirikisa tabi sa <a href="http://twitter.com/wikia">Twitter</a> or <a href="http://facebook.com/wikia">Facebook</a> para sa dugang na mga impormasyon. <br />
(Kun igwa ka na nin panindog, ika <a href="#">maglaog</a> bilang normal, alagad ika dae tabi makakapagliwat.)</p>',
	'comboajaxlogin-ajaxerror' => 'An Wikia dae tabi nagsisimbag. Pakirikisaha tabi an saindong kabitanahang koneksyon.',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'comboajaxlogin-createlog' => 'Влизане или регистриране на нова сметка',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Влизане чрез Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Връщане',
);

/** Bhojpuri (भोजपुरी)
 * @author Nepaboy
 */
$messages['bho'] = array(
	'comboajaxlogin-desc' => 'गतिशील बाकस जउन सदस्य के खाता प्रवेश के अनुमति देवेला, गुप्तशब्द याद रखेला आ सदस्य के पंजीकरण करेला',
	'comboajaxlogin-createlog' => 'खाता प्रवेश या एगो खाता बनाईं',
	'comboajaxlogin-actionmsg' => 'इ क्रिया के पुरा करे खातिर रउआ पहिले एगो खाता में प्रवेश करे के पड़ी या एगो खाता बनावे के पड़ी',
	'comboajaxlogin-actionmsg-protected' => 'इ क्रिया के पुरा करे खातिर रउआ पहिले एगो खाता में प्रवेश करे के पड़ी या एगो खाता बनावे के पड़ी',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>फेसबुक कनेक्ट के साथ खाता में प्रवेश करीं</h1>',
	'comboajaxlogin-connectmarketing-back' => '«वापस',
	'comboajaxlogin-connectmarketing-forward' => 'शुरु करीं',
);

/** Bengali (বাংলা)
 * @author Aftab1995
 */
$messages['bn'] = array(
	'comboajaxlogin-connectmarketing-back' => '« পিছনে',
	'comboajaxlogin-connectmarketing-forward' => 'শুরু করুন »',
);

/** Tibetan (བོད་ཡིག)
 * @author YeshiTuhden
 */
$messages['bo'] = array(
	'comboajaxlogin-createlog' => 'ནང་འཛུལ་འམ་འཐོ་བཀོད།',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'comboajaxlogin-desc' => "Boest dinamek a dalvez d'an implijerien d'en em gevreañ, da gaout soñj eus o ger-tremen ha da enrollañ implijerien",
	'comboajaxlogin-createlog' => 'Krouiñ ur gont pe kevreañ',
	'comboajaxlogin-actionmsg' => 'Evit ober kement-mañ e rankit bezañ kevreet pe krouiñ ur gont a-raok',
	'comboajaxlogin-actionmsg-protected' => 'Evit ober kement-mañ e rankit bezañ kevreet pe krouiñ ur gont a-raok.',
	'comboajaxlogin-connectmarketing' => "<h1>Kevreit ho kontoù</h1>
<ul>
<li>Derc'hel a ra hoc'h anv implijer red, istor ar c'hemmoù... ne cheñch netra nemet evit an doare d'en em gevreañ</li>
<li>Rannit hoc'h obererezh war Wikia gant ho mignoned war Facebook</li>
<li>Kontroll klok war ar pezh a vez embannet</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Kevreañ gant Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Kevreit ho kont Wikia da Facebook</h1>
<ul>
<li>Derc'hel a ra hoc'h anv implijer red, istor ar c'hemmoù... ne cheñch netra nemet evit an doare d'en em gevreañ</li>
<li>Rannit hoc'h obererezh war Wikia gant ho mignoned war Facebook</li>
<li>Kontroll klok war ar pezh a vez embannet</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '&laquo; Distreiñ',
	'comboajaxlogin-connectmarketing-forward' => 'A-raok kregiñ &raquo;',
	'comboajaxlogin-connectdirections' => "Merkit hoc'h anv implijer hag ho ker-tremen evit Wikia amañ - gant un taol strobinellerezh e vo kevreet ho kontoù Facebook ha Wikia ganeomp en drekleur.

Ur wezh graet e c'hallot kevreañ aes en ur ober gant ne vern pe vouton Facebook Connect.",
	'comboajaxlogin-post-not-understood' => 'Ur fazi zo bet en doare ma oa bet savet ar furmskrid-mañ.
Klaskit en-dro pe [[Special:Contact|kasit keloù]].',
	'comboajaxlogin-readonlytext' => '<h2>Hon digarezit !</h2> <p>Ne c\'hallit krouiñ kont ebet er mare-mañ - Dibrez e rankfemp bezañ a-benn nebeut. Sed ar pezh a c\'hoarvez :<br /><em>$1</em></p> <p>Kit da sellet, mar plij, <a href="http://twitter.com/wikia">Twitter</a> pe <a href="http://facebook.com/wikia">Facebook</a> evit gouzout hiroc\'h. <br /> (M\'ho peus ur gont dija e c\'hallit <a href="#">bezañ anavezet</a> evel kustum, met ne c\'hallit kemmañ mann ebet.)</p>',
	'comboajaxlogin-ajaxerror' => 'Ne respont ket Wikipedia. Gwiriit ho kefluniadur rouedad, mar plij.',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author BroOk
 * @author Marcmpujol
 * @author Roxas Nobody 15
 */
$messages['ca'] = array(
	'comboajaxlogin-desc' => 'Caixa dinàmica que permet als usuaris connectar-se, recordar contrasenyes i registrar usuaris',
	'comboajaxlogin-createlog' => 'Iniciar sessió o crear un compte',
	'comboajaxlogin-actionmsg' => 'Per realitzar aquesta acció, primer cal iniciar sessió o crear un compte',
	'comboajaxlogin-actionmsg-protected' => 'Per dur a terme aquesta acció, primer cal iniciar sessió o crear un compte.',
	'comboajaxlogin-connectmarketing' => "<h1>Connectar els teus comptes</h1>
<ul>
<li>Mantenir el teu nom d'usuari actual, historial, edicions... no canvia res excepte la manera d'iniciar sessió</li>
<li>Comparteix la teva activitat que realitzes a Wikia amb els teus amics del Facebook</li>
<li>Controla completament el que publiques</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Inicia sessió amb Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1> Connecta el teu compte de Facebook amb Wikia </ h1>
<ul>
<li> Mantingui el seu nom d'usuari actual, història, edita ... res no canvia, excepte el que es connecti </ li>
<li> Comparteixi la seva activitat en Wikia amb els teus amics a Facebook, amb un control total del que es publica </li>",
	'comboajaxlogin-connectmarketing-back' => 'Tornar',
	'comboajaxlogin-connectmarketing-forward' => 'Començar»',
	'comboajaxlogin-connectdirections' => "Introduïu el vostre nom d'usuari de Wikia i contrasenya aquí - connectarem per art de màgia els comptes de Wikia i Facebook.

Una vegada ho facis, pots iniciar sessió fàcilment amb qualsevol botó Facebook Connect.",
	'comboajaxlogin-post-not-understood' => "Hi ha hagut un error en la forma com es va construir aquest formulari.
Si us plau, intenteu-ho de nou o [[Special:Contact|informeu d'aquest error]].",
	'comboajaxlogin-readonlytext' => '<h2>Ho sentim!</h2>
<p>No podeu crear un compte en aquest moment - hauríem d\'estar en línia i donant servei en breu. Això és el que està passant:<br /><em>$1</em></p>
<p>Si us plau, comprova a <a href="http://twitter.com/wikia">Twitter</a> o a <a href="http://facebook.com/wikia">Facebook</a> per a més informació.
<br />
(Si ja teniu un compte, podeu <a href="#">iniciar la sessió</a> com sempre, però no podreu editar.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia no està responent. Si us plau, comproveu la connexió de xarxa.',
);

/** Czech (česky)
 * @author Darth Daron
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'comboajaxlogin-desc' => 'Dynamické pole, které umožňuje uživatelům přihlášení, připomenutí hesla a registraci uživatelů',
	'comboajaxlogin-createlog' => 'Přihlásit se nebo vytvořit účet',
	'comboajaxlogin-actionmsg' => 'Chcete-li provést tuto akci, je nejprve nutné se přihlásit nebo vytvořit účet',
	'comboajaxlogin-actionmsg-protected' => 'Chcete-li provést tuto akci, je nejprve nutné přihlásit se nebo vytvořit účet.',
	'comboajaxlogin-connectmarketing' => '<h1>Propojte své účty</h1>
<ul>
<li>Ponechejte si svoje uživatelské jméno, editace, vše ... kromě toho, jak se přihlašujete</li>
<li>Sdílejte svou aktivitu z Wikia na Facebooku</li>
<li>Kompletní kontrola nad tím, co je zveřejněno</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Přihlásit se pomocí Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Propojte svůj účet Wikia s Facebookem</h1>
<ul>
<li>Ponechejte si svoje uživatelské jméno, editace, vše ... kromě toho, jak se přihlašujete</li>
<li>Sdílejte svou aktivitu z Wikia na Facebooku s kompletní kontrolou nad tím, co je zveřejněno</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Zpět',
	'comboajaxlogin-connectmarketing-forward' => 'Začínáme &raquo;',
	'comboajaxlogin-connectdirections' => 'Zadejte zde své uživatelské jméno a heslo Wikia - propojíme Vaše účty na pozadí automaticky.

Poté se budete moci přihlásit libovolným tlačítkem Facebook Connect.',
	'comboajaxlogin-post-not-understood' => 'Nastala chyba ve způsobu konstrukce tohoto formuláře.
Zkuste to znova nebo [[Special:Contact|nás kontaktujte]].',
	'comboajaxlogin-readonlytext' => '<h2>Omlouváme se!</h2>
<p>V tuto chvíli nemůžete vytvořit nový účet - tato služba bude zanedlouho opět v provozu.<br /><em>$1</em></p>
<p>Více informací: <a href="http://twitter.com/wikia">Twitter</a> nebo <a href="http://facebook.com/wikia">Facebook</a>
<br />
(pokud již máte účet, můžete se <a href="#">přihlásit</a> jako obvykle, ale nebudete moci editovat)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia neodpovídá. Zkontrolujte připojení k síti.',
);

/** Welsh (Cymraeg)
 * @author Thefartydoctor
 */
$messages['cy'] = array(
	'comboajaxlogin-desc' => "Mae'r 'Dymamic Box' yn helpu chi mewngofnodi, cofio eich cyfrinair a chofnodi defnyddiwyr",
	'comboajaxlogin-createlog' => 'Mewngofnodi neu creu cyfrif',
	'comboajaxlogin-actionmsg' => 'I gyflawnu y gweithrediad hwn, rhaid i chi mewngofnodi neu creu cyfrif',
	'comboajaxlogin-actionmsg-protected' => 'I gyflawnu y gweithrediad hwn, rhaid i chi mewngofnodi neu creu cyfrif',
	'comboajaxlogin-connectmarketing' => "<h1>Cysylltu eich cyfrifon</h1>
<ul>
<li>Cadwch eich enw defnyddiwr cyfredol, hanes, newidiadau... dim byd yn newid ac eithro sut ydych chi'n mewngofnodi</li>
<li>Rhannu eich actifedd ar Wikia gyda eich ffrindiau ar Facebook</li>
<li>Arolygu pob cyhoeddiad</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Mewngofnodi gyda Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Cysylltu eich cyfrif Wikia ar Facebook</h1>
<ul>
<li>Cadwch eich enw defnyddiwr cyfredol, hanes, newidiadau... dim byd yn newid ac eithro sut ydych chi'n  mewngofnodi</li>
<li>Rhannu eich actifedd ar Wiki gyfa eich ffrindiau ar Facebook ac arolygu pob cyhoeddiad</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '<< Yn ôl',
	'comboajaxlogin-connectmarketing-forward' => 'Dechreuwch! >>',
	'comboajaxlogin-connectdirections' => "Mewnosod eich enw defnyddiwr Wikia a chyfrinair yma - byddwn ni'n cysylltu eich cyfrifon Wikia a Facebook.

Wedyn, dych chi'n gallu mewngofnodi gyda botymau Facebook Connect.",
	'comboajaxlogin-post-not-understood' => "Roedd gwall yn yr adeiladaeth o'r fform hwn.
Treiwch eto neu [[Special:Contact|dywedwch rhywbeth]].",
	'comboajaxlogin-readonlytext' => '<h2>Mae ddrwg \'da ni!</h2>
<p>Dydych chi ddim yn creu cyfrif ar hyn o bryd - dylai\'n gwethio fel normal ar fyr o dro. Yma yw beth sy\'n bod:<br /><em>$1</em></p>
<p>Gwirio <a href="http://twitter.com/wikia">Twitter</a> new <a href="http://facebook.com/wikia>Facebook i ffeindio mwy o wybodaeth.
<br />
(Os mae cyfrif yn barod \'da chi, chi\'n gallu <a href="#">mewngofnodi</a> fel normal ond fyddwch chi ddim yn gallu gwneud newidiadau.)</p>',
	'comboajaxlogin-ajaxerror' => 'Dydy Wikia ddim yn ymateb. Gwiriwch eich cysylltiad rhyngrwyd.',
);

/** Danish (dansk)
 * @author Claus chr
 * @author Kaare
 * @author Sarrus
 */
$messages['da'] = array(
	'comboajaxlogin-createlog' => 'Log på eller opret en konto',
	'comboajaxlogin-actionmsg' => 'For at udføre denne handling, skal du først logge på eller oprette en konto',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Tilslut din Wikia konto til Facebook</h1>
<ul>
<li>Beholde dit nuværende brugernavn, historik, redigeringer... intet ændres bortset fra hvordan du logger ind</li>
<li>Dele din aktivitet på Wikia med dine venner på Facebook, med fuld kontrol over hvad der bliver offentliggjort</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '« Tilbage',
	'comboajaxlogin-connectmarketing-forward' => 'Kom i gang »',
	'comboajaxlogin-connectdirections' => 'Indtast dit Wikia-brugernavn og kodeord her - vi vil på magisk vis forbinde dine Wikia og Facebook konti i baggrunden.

Når du er færdig, kan du let logge ind med  enhver Facebook Connect-knap.',
	'comboajaxlogin-post-not-understood' => 'Der opstod en fejl i den måde denne formular blev konstrueret på.
Prøv igen eller [[Special: Contact|rapportér dette]].', # Fuzzy
	'comboajaxlogin-readonlytext' => '<h2>Beklager!</h2>
<p>Du kan ikke oprette en konto i øjeblikket - vi skulle være oppe og køre igen snart. Her er hvad der sker:<br><em>$1</em></p>
<p>Kontrollér <a href="http://twitter.com/wikia">Twitter</a> eller <a href="http://facebook.com/wikia">Facebook</a> for mere information.
<br>
(Hvis du allerede har en konto, kan du <a href="#">logge ind</a> som normalt, men du vil ikke kunne redigere).</p>', # Fuzzy
);

/** German (Deutsch)
 * @author Avatar
 * @author Das Schäfchen
 * @author Diebuche
 * @author Inkowik
 * @author LWChris
 * @author SVG
 * @author The Evil IP address
 */
$messages['de'] = array(
	'comboajaxlogin-desc' => 'Dynamische Box, die es Benutzern ermöglicht, sich anzumelden, Passwörter zu merken und Benutzer zu registrieren',
	'comboajaxlogin-createlog' => 'Anmelden oder Benutzerkonto erstellen',
	'comboajaxlogin-actionmsg' => 'Um diese Aktion auszuführen, musst du dich zuerst anmelden oder ein Benutzerkonto erstellen',
	'comboajaxlogin-actionmsg-protected' => 'Um diese geschützten Seite zu bearbeiten, musst du dich zunächst anmelden oder ein Konto anlegen.',
	'comboajaxlogin-connectmarketing' => '<h1>Verbinde deine Benutzerkonten</h1>
<ul>
<li>Behalte deinen momentanen Benutzernamen, Geschichte, Bearbeitungen … nichts ändert sich außer der Art und Weise, wie du dich einloggst</li>
<li>Teile deine Aktivität auf Wikia mit deinen Freunden auf Facebook</li>
<li>Komplette Kontrolle darüber, was veröffentlicht wird</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Mit Facebook Connect anmelden</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Verbinde dein Wikia-Benutzerkonto mit Facebook</h1>
<ul>
<li>Behalte deinen momentanen Benutzernamen, Geschichte, Bearbeitungen … nichts ändert sich außer der Art und Weise, wie du dich einloggst</li>
<li>Teile deine Aktivität auf Wikia mit deinen Freunden auf Facebook, mit kompletter Kontrolle darüber, was veröffentlicht wird</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '« Zurück',
	'comboajaxlogin-connectmarketing-forward' => 'Anfangen »',
	'comboajaxlogin-connectdirections' => 'Gib deinen Wikia-Benutzernamen und das Passwort hier ein - wir werden dann dein Wikia- und Facebook-Benutzerkonto im Hintergrund verknüpfen.

Sobald du fertig bist, kannst du dich einfach über den Facebook-Connect-Knopf anmelden.',
	'comboajaxlogin-post-not-understood' => 'Es gab einen Fehler beim Aufbau dieses Formulars.
Bitte versuche es erneut oder [[Special:Contact|melde es]].',
	'comboajaxlogin-readonlytext' => '<h2>Entschuldige!</h2>
<p>Du kannst momentan kein Benutzerkonto erstellen - wir sollten in Kürze wieder erreichbar sein. Sieh nach, was los ist:<br /><em>$1</em></p>
<p>Bitte schau bei <a href="http://twitter.com/wikia">Twitter</a> oder <a href="http://facebook.com/wikia">Facebook</a> für weitere Informationen. 
<br />
 (Wenn du bereits ein Benutzerkonto hast, kannst du dich <a href="#">einloggen</a> wie sonst auch, wirst aber nichts bearbeiten können.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia reagiert nicht. Bitte überprüfe deine Netzwerkverbindung.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'comboajaxlogin-createlog' => 'Cı kewe ya zi hesab vıraze',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Gıre dê Facebook ra deqew de</h1>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Peyd bê',
	'comboajaxlogin-connectmarketing-forward' => 'Seroknayen de &raquo;',
);

/** Greek (Ελληνικά)
 * @author Glavkos
 */
$messages['el'] = array(
	'comboajaxlogin-createlog' => 'Συνδεθείτε ή δημιουργήστε ένα λογαριασμό',
	'comboajaxlogin-actionmsg' => 'Για να εκτελέσετε αυτήν την ενέργεια, πρέπει πρώτα να συνδεθείτε ή να δημιουργήσετε ένα λογαριασμό',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Σύνδεση με το Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Πίσω',
	'comboajaxlogin-connectmarketing-forward' => 'Αρχίστε &raquo;',
	'comboajaxlogin-ajaxerror' => 'Η Wikia δεν ανταποκρίνεται. Παρακαλώ ελέγξτε τη σύνδεση δικτύου.',
);

/** Esperanto (Esperanto)
 * @author Objectivesea
 */
$messages['eo'] = array(
	'comboajaxlogin-createlog' => 'Ensaluti aŭ krei novan konton',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Reveni',
	'comboajaxlogin-connectmarketing-forward' => 'Komenci &raquo;',
);

/** Spanish (español)
 * @author Absay
 * @author Crazymadlover
 * @author VegaDark
 */
$messages['es'] = array(
	'comboajaxlogin-desc' => 'Cuadro dinámico que permite a los usuarios iniciar sesión,recordar contraseñas y registrar usuarios',
	'comboajaxlogin-createlog' => 'iniciar sesión o crear una cuenta',
	'comboajaxlogin-actionmsg' => 'Para realizar esta acción primero necesitas iniciar sesión o crear una cuenta',
	'comboajaxlogin-actionmsg-protected' => 'Para poder editar una página protegida primero necesitas iniciar sesión o crear una cuenta.',
	'comboajaxlogin-connectmarketing' => '<h1>Enlaza tus cuentas</h1>
<ul>
<li>Conserva tus datos actuales: nombre de usuario, historial, ediciones, etc. Nada cambia salvo la forma de iniciar sesión</li>
<li>Comparte con tus amigos en Facebook la actividad que realices en Wikia</li>
<li>Controla completamente qué cosas publicas</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Inicia sesión con Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Conecta tus cuentas</h1>
<ul>
<li>Conserva tus datos actuales: nombre de usuario, historial, ediciones, etc. Nada cambia salvo la forma de iniciar sesión</li>
<li>Comparte con tus amigos en Facebook la actividad que realices en Wikia</li>
<li>Ten completo control sobre lo que publicas</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Regresar',
	'comboajaxlogin-connectmarketing-forward' => 'Comenzar &raquo;',
	'comboajaxlogin-connectdirections' => 'Ingresar tu nombre de usuario Wikia y contraseña aquí - conectaremos mágicamente tus cuentas de Wikia y Facebook.

Una vez que lo hagas, puedes iniciar sesión fácilmente usando cualquier botón de conexión de Facebook.',
	'comboajaxlogin-post-not-understood' => 'Hubo un error en la forma en que este formulario fue construído.
Por favor intenta de nuevo o [[Special:Contact|reporta esto]].',
	'comboajaxlogin-readonlytext' => '<h2>¡Lo sentimos!</h2>
<p>No puedes crear una cuenta por el momento. Estaremos disponible nuevamente en breve. Esto es lo que está ocurriendo:<br /><em>$1</em></p>
<p>Por favor revisa en <a href="http://twitter.com/wikia">Twitter</a> o en <a herf="http://facebook.com/wikia">Facebook</a> para más información.<br />
(Si ya tienes una cuenta, puedes <a href="#">iniciar sesión</a> de forma normal, pero no serás capaz de editar.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia no responde. Por favor, comprueba tu conexión.',
);

/** Estonian (eesti)
 * @author KalmerE.
 */
$messages['et'] = array(
	'comboajaxlogin-createlog' => 'Logi sisse või loo kasutajakonto',
	'comboajaxlogin-actionmsg' => 'Selle toimingu sooritamiseks peate esmalt sisse logima või looma kasutajakonto',
	'comboajaxlogin-actionmsg-protected' => 'Selle toimingu sooritamiseks peate esmalt sisse logima või looma kasutajakonto.',
	'comboajaxlogin-connectmarketing' => '<h1>Ühenda kasutajakontod</h1>
<ul>
<li>Jäta oma praegune kasutajanimi, ajalugu, muudatused... ei muutu midagi sisse logimise järel</li>
<li>Jaga oma Wikia aktiivsust Facebooki sõpradega</li>
<li>Täielik kontroll avaldamise üle</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Logi sisse oma Facebook kasutajakontoga</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Ühenda Wikia kasutajakonto Facebook kasutajakontoga</h1>
<ul>
<li>Jäta oma praegune kasutajanimi, ajalugu, muudatused... ei muutu midagi sisse logimise järel</li>
<li>Jaga oma Wikia aktiivsust Facebooki sõpradega, täielik kontroll avaldamiste üle</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '« Tagasi',
	'comboajaxlogin-connectmarketing-forward' => 'Alustamine »',
	'comboajaxlogin-connectdirections' => 'Sisesta oma Wikia kasutajanimi ja parool siia - ühendame taustal sinu Wikia ja Facebooki kasutajakontod.

Seejärel saad kergesti sisse logida, kasutades mis tahes Facebook Connect nuppu.',
	'comboajaxlogin-post-not-understood' => 'Seal oli viga selles, kuidas see vorm oli ehitatud.
Palun proovige uuesti või [[Eri:Ilmuta|teavita sellest]].', # Fuzzy
);

/** Persian (فارسی)
 * @author Huji
 * @author پاناروما
 */
$messages['fa'] = array(
	'comboajaxlogin-createlog' => 'وارد شوید یا حساب کاربری ایجاد کنید',
	'comboajaxlogin-actionmsg' => 'برای انجام این کار، لازم است اول به سیستم وارد شوید یا حساب کاربری ایجاد کنید',
	'comboajaxlogin-actionmsg-protected' => 'برای انجام این عمل، لازم است اول به سامانه وارد شوید یا حساب کاربری ایجاد کنید.',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>وارد شدن از طریق فیس بوک</h1>',
	'comboajaxlogin-ajaxerror' => 'ویکی پاسخ نمی دهد. لطفاً اتصال شبکه خود را بررسی کنید.',
);

/** Finnish (suomi)
 * @author Nike
 * @author Tofu II
 * @author VezonThunder
 */
$messages['fi'] = array(
	'comboajaxlogin-desc' => 'Dynaaminen laatikko, jossa käyttäjät voivat kirjautua, selvittää salasanaansa ja rekisteröityä käyttäjäksi',
	'comboajaxlogin-createlog' => 'Kirjaudu sisään tai rekisteröidy',
	'comboajaxlogin-actionmsg' => 'Suorittaaksesi tämän toiminnon sinun on ensin kirjauduttava sisään tai luotava tunnus',
	'comboajaxlogin-actionmsg-protected' => 'Suorittaaksesi tämän toiminnon sinun on ensin kirjauduttava sisään tai luotava tunnus.',
	'comboajaxlogin-connectmarketing' => '<h1>Tilien yhdistäminen</h1>
<ul>
<li>Säilytä nykyinen käyttäjänimesi, historiasi, muokkaukset... mikään muu kuin kirjautumistapa ei muutu</li>
<li>Jaa Wikia-toimintasi ystävillesi Facebookissa</li>
<li>Hallitset täydellisesti sitä, mikä julkaistaan</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Kirjaudu sisään Facebook Connect -toiminnolla</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Tilien yhdistäminen</h1>
<ul>
<li>Säilytä nykyinen käyttäjänimesi, historiasi, muokkaukset... mikään muu kuin kirjautumistapa ei muutu</li>
<li>Jaa Wikia-toimintasi ystävillesi Facebookissa halliten täydellisesti sitä, mikä julkaistaan</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Edellinen',
	'comboajaxlogin-connectmarketing-forward' => 'Aloita &raquo;',
	'comboajaxlogin-connectdirections' => 'Syötä Wikia-käyttäjänimesi ja -salasanasi tähän – yhdistämme Wikia- ja Facebook-tunnuksesi automaattisesti.

Kun olet valmis, voit kirjautua sisään helposti käyttämällä kaikilla Facebook Connect -painikkeila.',
	'comboajaxlogin-post-not-understood' => 'Lomakkeen muodostustavassa oli ongelma.
Yritä uudelleen tai [[Special:Contact|tee tästä ilmoitus]].',
	'comboajaxlogin-readonlytext' => '<h2>Olemme pahoillamme!</h2>
<p>Et voi luoda tunnusta tällä hetkellä – sivuston tulisi olla pian toiminnassa jälleen. Kyse on seuraavasta:<br /><em>$1</em></p>
<p>Tarkista <a href="http://twitter.com/wikia">Twitter-</a> tai <a href="http://facebook.com/wikia">Facebook-sivumme</a> saadaksesi lisätietoa.
<br />
(Jos sinulla jo on tunnus, voit <a href="#">kirjautua sisään</a> kuten tavallisesti, mutta et voi muokata.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia ei vastaa. Tarkista verkkoyhteytesi.',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'comboajaxlogin-desc' => 'Ein dynamiskur kassi sum loyvir brúkarum at rita inn, fáa áminning um loyniorð og skráseta brúkarar',
	'comboajaxlogin-createlog' => 'Rita inn ella stovna eina konto',
	'comboajaxlogin-actionmsg' => 'Fyri at fremja hesa handling mást tú fyrst rita inn ella stovna eina konto',
	'comboajaxlogin-actionmsg-protected' => 'Fyri at fremja hesa handling mást tú fyrst rita inn ella stovna eina konto.',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Rita inn við Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-back' => '« Aftur',
	'comboajaxlogin-connectmarketing-forward' => 'Kom í gongd »',
	'comboajaxlogin-connectdirections' => 'Skriva títt Wikia brúkaranavn og loyniorð her - vi fara so á magiskan hátt at knýta tína Wikia og Facebook kontur saman í bakgrundini.

Tá tú ert liðug/ur, so kanst tú lættliga rita inn við at brúka einhvønn Facebook Connect knøtt.',
);

/** French (français)
 * @author Crochet.david
 * @author IAlex
 * @author Peter17
 * @author Wyz
 */
$messages['fr'] = array(
	'comboajaxlogin-desc' => "Boîte de dynamique qui permettent aux utilisateurs de se connecter, se rappeler de leur mot de passe et d'enregistrer des utilisateurs",
	'comboajaxlogin-createlog' => 'Se connecter ou créer un compte',
	'comboajaxlogin-actionmsg' => "Vous devez d'abord vous connecter ou créer un compte avant d'effectuer cette action",
	'comboajaxlogin-actionmsg-protected' => 'Pour modifier cette page protégée, vous devez d’abord vous connecter ou créer un compte.',
	'comboajaxlogin-connectmarketing' => '<h1>Reliez vos comptes</h1>
<ul>
<li>Conservez vos nom d’utilisateur, historique et modifications actuels... rien ne change, sauf votre manière de vous connecter</li>
<li>Partagez votre activité sur Wikia avec vos amis sur Facebook</li>
<li>Contrôlez parfaitement ce qui est publié</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Se connecter avec Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Reliez votre compte Wikia à Facebook</h1>
<ul>
<li>Conservez vos nom d’utilisateur, historique et modifications actuels... rien ne change, sauf votre manière de vous connecter</li>
<li>Partagez votre activité sur Wikia avec vos amis sur Facebook, en contrôlant complètement ce qui est publié</li>
<li>Contrôlez parfaitement ce qui est publié</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Retour',
	'comboajaxlogin-connectmarketing-forward' => 'Avant de commencer &raquo;',
	'comboajaxlogin-connectdirections' => "Entrez votre nom d'utilisateur et mot de passe Wikia - nous allons magiquement connecter vos comptes Wikia et Facebook en arrière plan. 

Une fois que vous avez terminé, vous pouvez vous connecter facilement à l'aide de n'importe quel bouton Facebook Connect.",
	'comboajaxlogin-post-not-understood' => 'Il y a eu une erreur dans la façon dont ce formulaire a été construit. 
Veuillez essayer à nouveau ou [[Special:Contact|le signaler]].',
	'comboajaxlogin-readonlytext' => '<h2>Désolé !</h2>
<p>Vous ne pouvez pas créer de compte actuellement - nous devrions être de nouveau disponibles dans peu de temps. Voici ce qui se passe :<br /><em>$1</em></p>
<p>Veuillez consulter <a href="http://twitter.com/wikia">Twitter</a> ou <a href="http://facebook.com/wikia">Facebook</a> pour plus d’informations.
<br />
(Si vous avez déjà un compte, vous pouvez <a href="#">vous identifier</a> comme d’habitude, mais vous ne pourrez rien modifier.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia ne répond pas. Veuillez vérifier votre connexion réseau.',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'comboajaxlogin-desc' => 'Caixa dinámica que permite aos usuarios acceder ao sistema, lembrar o contrasinal e rexistrar novas contas',
	'comboajaxlogin-createlog' => 'Iniciar a sesión ou crear unha conta',
	'comboajaxlogin-actionmsg' => 'Para realizar esta acción ten que primeiro acceder ao sistema ou crear unha conta',
	'comboajaxlogin-actionmsg-protected' => 'Para editar esta páxina protexida ten que primeiro acceder ao sistema ou crear unha conta.',
	'comboajaxlogin-connectmarketing' => '<h1>Conecte as súas contas</h1>
<ul>
<li>Manteña o seu nome de usuario actual, o historial, as edicións... Non cambia nada, agás o xeito de acceder ao sistema</li>
<li>Comparta a súa actividade en Wikia cos seus amigos do Facebook</li>
<li>Control total do que se publica</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Identificarse co Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Conecte a súa conta de Wikia coa do Facebook</h1>
<ul>
<li>Manteña o seu nome de usuario actual, o historial, as edicións... Non cambia nada, agás o xeito de acceder ao sistema</li>
<li>Comparta a súa actividade en Wikia cos seus amigos do Facebook, con control total do que se publica</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Volver',
	'comboajaxlogin-connectmarketing-forward' => 'Comezar »',
	'comboajaxlogin-connectdirections' => 'Escriba o seu nome de usuario e contrasinal de Wikia aquí. Nós encargámonos de conectar as contas de Wikia e mais Facebook.

Cando estea listo, pode acceder ao sistema facilmente usando calquera botón de conexión do Facebook.',
	'comboajaxlogin-post-not-understood' => 'Houbo un erro no xeito en que se construíu este formulario.
Inténteo de novo ou [[Special:Contact|informe do problema]].',
	'comboajaxlogin-readonlytext' => '<h2>Sentímolo!</h2>
<p>Nestes intres non pode crear unha conta; axiña estaremos de volta. Aquí está o que aconteceu:<br /><em>$1</em></p>
<p>Comprobe o <a href="http://twitter.com/wikia">Twitter</a> ou o <a href="http://facebook.com/wikia">Facebook</a> para obter máis información.
<br />
(Se xa ten unha conta, pode <a href="#">acceder ao sistema</a> como de costume, pero non poderá editar.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia non responde. Comprobe a súa conexión.',
);

/** Hakka (客家語/Hak-kâ-ngî)
 * @author Anson2812
 */
$messages['hak'] = array(
	'comboajaxlogin-desc' => '做得分用戶登入，提醒密碼撈註冊用戶嘅動態方框',
	'comboajaxlogin-createlog' => '登入或者建立新帳號',
	'comboajaxlogin-actionmsg' => '假使愛進行此操作，汝一定愛先登入或者建立一隻新帳號正做得',
	'comboajaxlogin-actionmsg-protected' => '假使愛進行此操作，汝一定愛先登入或者建立一隻新帳號正做得。',
	'comboajaxlogin-connectmarketing-back' => '« 轉頭',
	'comboajaxlogin-connectmarketing-forward' => '開始 »',
);

/** Hebrew (עברית)
 * @author Yova
 * @author פדיחה
 */
$messages['he'] = array(
	'comboajaxlogin-createlog' => 'התחבר או הירשם',
	'comboajaxlogin-actionmsg' => 'על מנת לבצע פעולה זו עליך קודם כל להתחבר או להרשם',
	'comboajaxlogin-actionmsg-protected' => 'על מנת לבצע פעולה זו עליך קודם כל להתחבר או להרשם',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>התחברות באמצעות חשבון Facebook</h1>',
);

/** Hindi (हिन्दी)
 * @author Kush rohra
 */
$messages['hi'] = array(
	'comboajaxlogin-desc' => 'गतिशील डिब्बा जो अनुमति देना उपयोगकर्ता से लॉगिन , याद दिलाना पासवर्ड और रजिस्टर्ड 	
प्रयोग करनेवाला',
	'comboajaxlogin-createlog' => 'सत्रारंभ / खाता खोलें',
	'comboajaxlogin-actionmsg' => 'से निष्पादन यह कार्य आप पहले ज़रूरत से लोगिन और बनाना कोए खाता',
	'comboajaxlogin-actionmsg-protected' => 'आप पहली बार में लॉग इन करें या एक खाता बनाने के लिए की जरूरत है इस क्रिया को निष्पादित करने के लिए।',
	'comboajaxlogin-connectmarketing' => '<h1>अपने खाते से कनेक्ट</h1>!एन!<ul>!एन!<li>रखने के अपने वर्तमान उपयोगकर्ता नाम, इतिहास, कुछ परिवर्तनों को छोड़कर कैसे आप में लॉग इन करें.. संपादित करता</li>!एन!<li>Wikia पर अपनी गतिविधि Facebook पर अपने दोस्तों के साथ साझा करें</li>!एन!<li>क्या प्रकाशित किया गया है के पूर्ण नियंत्रण</li>!एन!</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>लॉग इन करें Facebook के साथ कनेक्ट</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>अपने Wikia खाते से कनेक्ट करने के लिए Facebook</h1>!एन!<ul>!एन!<li>रखने के अपने वर्तमान उपयोगकर्ता नाम, इतिहास, कुछ परिवर्तनों को छोड़कर कैसे आप में लॉग इन करें.. संपादित करता</li>!एन!<li>Wikia पर अपनी गतिविधि जो प्रकाशित है के पूर्ण नियंत्रण के साथ Facebook पर अपने दोस्तों के साथ साझा करें</li>!एन!</ul>',
	'comboajaxlogin-connectmarketing-back' => '«वापस',
	'comboajaxlogin-connectmarketing-forward' => 'आरंभ करें»',
);

/** Hungarian (magyar)
 * @author Dani
 * @author TK-999
 */
$messages['hu'] = array(
	'comboajaxlogin-desc' => 'Bejelentkezésre, jelszóemlékeztető kérésére és regisztrációra alkalmas dinamikus doboz.',
	'comboajaxlogin-createlog' => 'Bejelentkezés vagy új felhasználói fiók létrehozása',
	'comboajaxlogin-actionmsg' => 'A művelet végrehajtásához először hozzon létre egy fiókot, vagy jelentkezzen be',
	'comboajaxlogin-actionmsg-protected' => 'A művelet végrehajtásához először hozzon létre egy fiókot, vagy jelentkezzen be.',
	'comboajaxlogin-connectmarketing' => '<h1>Felhasználói fiókok összekötése</h1>
<ul>
<li>Tartsd meg a jelenlegi felhasználói nevedet, történeted, szerkesztéseid&hellip; semmi sem változik, csak a bejelentkezés módja</li>
<li>Oszd meg a Wikián folytatott tevékenységedet ismerőseiddel a Facebookon</li>
<li>Teljes irányítás a kiadott információ felett</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Bejelentkezés a Facebook Connect használatával</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Wikia felhasználói fiókod összekötése a Facebookal</h1>
<ul>
<li>Tartsd meg a jelenlegi felhasználói nevedet, történeted, szerkesztéseid&hellip; semmi sem változik, csak a bejelentkezés módja</li>
<li>Oszd meg a Wikián folytatott tevékenységedet ismerőseiddel a Facebookon, teljes irányítással a kiadott információ felett</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Vissza',
	'comboajaxlogin-connectmarketing-forward' => 'Első lépések &raquo;',
	'comboajaxlogin-connectdirections' => 'Add meg a Wikia felhasználónevedet és jelszavadat itt&mdash;mi a háttérben összekötjük a Wikia és a Facebook fiókjaidat.

Miután végeztél, könnyedén bejelentkezhetsz minden Facebook Connect gomb segítségével.',
	'comboajaxlogin-post-not-understood' => 'Hiba történt az űrlap felépítésében.
Próbáld újra vagy [[Special:Contact|jelentsd a hibát]].',
	'comboajaxlogin-readonlytext' => '<h2>Elnézést!</h2>
<p>Pillanatnyilag nem hozhatsz létre felhasználói fiókot&mdash;hamarosan újra működőképesek leszünk. A probléma leírása a következő:<br /><em>$1</em></p>
<p>Megtekintheted a Wikia <a href="http://twitter.com/wikia">Twitter</a> vagy <a href="http://facebook.com/wikia">Facebook</a> profiljait további információért.
<br />
(Ha már van fiókod, <a href="#">bejelentkezhetsz</a>, de nem fogsz tudni szerkeszteni.)</p>',
	'comboajaxlogin-ajaxerror' => 'A Wikia nem válaszol. Kérjük, ellenőrizd a hálózati kapcsolatot.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'comboajaxlogin-desc' => 'Quadro dynamic que permitte al usatores de aperir session, rememorar le contrasigno e crear un conto',
	'comboajaxlogin-createlog' => 'Aperir session o crear conto',
	'comboajaxlogin-actionmsg' => 'Pro exequer iste action tu debe primo aperir un session o crear un conto',
	'comboajaxlogin-actionmsg-protected' => 'Pro modificar iste pagina protegite, tu debe primo aperir un session o crear un conto.',
	'comboajaxlogin-connectmarketing' => '<h1>Connecter tu contos</h1>
<ul>
<li>Mantene tu actual nomine de usator, historia, modificationes... Nihil cambia excepte como aperir un session</li>
<li>Reparti tu activitate in Wikia con tu amicos in Facebook</li>
<li>Controlo complete de lo que es publicate</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Aperir session con Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Connecter tu conto de Wikia a Facebook</h1>
<ul>
<li>Mantene tu actual nomine de usator, historia, modificationes... Nihil cambia excepte como aperir un session</li>
<li>Divide tu activitate in Wikia con tu amicos in Facebook, con controlo complete de lo que es publicate</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Retro',
	'comboajaxlogin-connectmarketing-forward' => 'Comenciar &raquo;',
	'comboajaxlogin-connectdirections' => 'Entra hic tu nomine de usator Wikia e tu contrasigno; nos connectera magicamente tu contos de Wikia e de Facebook detra le cortinas.

Quando tu ha finite, tu pote aperir un session facilemente usante qualcunque button Facebook Connect.',
	'comboajaxlogin-post-not-understood' => 'Il habeva un error in le modo del qual iste formulario ha essite construite.
Per favor tenta lo de novo o [[Special:Contact|reporta isto]].',
	'comboajaxlogin-readonlytext' => '<h2>Pardono!</h2>
<p>Tu non pote crear un conto a iste momento - iste problema technic deberea esser resolvite tosto. Ecce lo que occurre:<br /><em>$1</em></p>
<p>Reguarda <a href="http://twitter.com/wikia">Twitter</a> o <a href="http://facebook.com/wikia">Facebook</a> pro plus informationes.
<br />
(Si tu ha jam un conto, tu pote <a href="#">aperir session</a> como sempre, ma tu non potera modificar.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia non responde. Per favor verifica tu connexion al rete.',
);

/** Indonesian (Bahasa Indonesia)
 * @author C5st4wr6ch
 * @author Irwangatot
 */
$messages['id'] = array(
	'comboajaxlogin-desc' => 'kotak dinamis yang memungkinkan pengguna untuk masuk log, mengingatkan password dan pengguna mendaftar',
	'comboajaxlogin-createlog' => 'Masuk log atau buat akun',
	'comboajaxlogin-actionmsg' => 'Untuk melakukan tindakan ini pertama Anda harus masuk log atau membuat account',
	'comboajaxlogin-actionmsg-protected' => 'Untuk melakukan tindakan ini pertama Anda harus masuk log atau membuat akun.',
	'comboajaxlogin-connectmarketing' => '<h1>Hubungkan akun-akun Anda</h1>
<ul>
<li>Nama pengguna saat ini, riwayat, dan suntingan tetap tersimpan... tidak ada yang berubah kecuali cara Anda masuk log</li>
<li>Bagikan kegiatan Anda di Wikia dengan teman-teman Anda di Facebook</li>
<li>Kendali penuh akan apa yang dipublikasikan</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Masuk log dengan Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Hubungkan akun Wikia Anda dengan Facebook</h1>
<ul>
<li>Menjaga nama pengguna saat ini, riwayat, suntingan... tidak ada yang berubah kecuali cara Anda masuk log</li>
<li>Bagikan aktivitas Anda di Wikia dengan teman-teman Anda di Facebook, dengan kendali penuh atas apa yang dipublikasikan</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Kembali',
	'comboajaxlogin-connectmarketing-forward' => 'Persiapan &raquo;',
	'comboajaxlogin-connectdirections' => 'Masukkan nama pengguna dan kata sandi Wikia Anda - kami akan dengan ajaib menghubungkan akun Wikia dan Facebook Anda di belakangnya.

Sekali Anda selesai, Anda dapat masuk log dengan mudah menggunakan tombol Facebook Connect apapun.',
	'comboajaxlogin-post-not-understood' => 'Ada kesalahan dalam cara formulir ini dibangun.
Silakan coba lagi atau [[Special:Contact|laporkan ini]].',
	'comboajaxlogin-readonlytext' => '<h2>Maaf!</h2>
<p>Anda tidak dapat membuat akun saat ini - kami sebaiknya kembali berdiri dan berjalan segera. Ini adalah hal yang terjadi:<br /><em>$1</em></p>
<p>Silakan periksa <a href="http://twitter.com/wikia">Twitter</a> atau <a href="http://facebook.com/wikia">Facebook</a> untuk informasi lebih lanjut.
<br />
(Jika Anda telah mempunyai akun, Anda dapat <a href="#">masuk log</a> secara normal, namun Anda tidak akan bisa menyunting.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia tidak menanggapi. Mohon periksa koneksi jaringan Anda.',
);

/** Italian (italiano)
 * @author Gianfranco
 * @author RickyB98
 * @author Viscontino
 * @author Ximo17
 */
$messages['it'] = array(
	'comboajaxlogin-desc' => 'Campo dinamico che consente agli utenti di accedere, ricordare la password e registrare utenti',
	'comboajaxlogin-createlog' => 'Entra o crea un nuovo account',
	'comboajaxlogin-actionmsg' => 'Per eseguire questa operazione, è necessario innanzitutto accedere o creare un account',
	'comboajaxlogin-actionmsg-protected' => 'Per eseguire questa azione è prima necessario accedere o creare un account.',
	'comboajaxlogin-connectmarketing' => '<h1>Connetti i tuoi account</h1>
<ul>
<li>Mantieni il tuo nome utente, cronologia, contributi... non cambia niente tranne il modo in cui entri</li>
<li>Condividi le tue attività su Wikia con i tuoi amici su Facebook</li>
<li>Controllo completo su ciò che viene pubblicato</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Accedi con Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Unifica il tuo account Wikia con quello Facebook</h1>
<ul>
<li>Mantieni il tuo username, la storia, le modifiche... non cambia nulla, solo il modo in cui accedi!</li>
<li>Condividi la tua attività su Wikia con gli amici di Facebook, con il controllo totale di ciò che sarà pubblicato</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Indietro',
	'comboajaxlogin-connectmarketing-forward' => 'Inizia &raquo;',
	'comboajaxlogin-connectdirections' => 'Inserisci il tuo nome utente di Wikia e password qui - connetteremo magicamente i tuoi account di Wikia e di Facebook in background.

Appena hai finito, puoi entrare usando qualsiasi pulsante Facebook Connect.',
	'comboajaxlogin-post-not-understood' => "Si è verificato un errore durante la costruzione di questo modulo.
Per favore, riprova o [[Special:Contact|notifica l'accaduto]].",
	'comboajaxlogin-ajaxerror' => 'Wikia non risponde. Si prega di controllare la connessione di rete.',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'comboajaxlogin-desc' => 'ログインと利用者登録が行えるダイナミックボックス',
	'comboajaxlogin-createlog' => 'ログインもしくはアカウントの作成',
	'comboajaxlogin-actionmsg' => 'この操作を行うには、ログインするかアカウントを作成する必要があります。',
	'comboajaxlogin-actionmsg-protected' => 'この操作を行うには、ログインするかアカウントを作成する必要があります。',
	'comboajaxlogin-connectmarketing' => '<h1>アカウントを接続する</h1>
<ul>
<li>現在の利用者名や履歴、編集機能などは維持され、ログイン方法以外に変更されるものはありません。</li>
<li>ウィキア上でのあなたの活動を Facebook 上の友達と共有できます</li>
<li>どの情報を表示させるかは設定により指定できます</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Facebookコネクトを利用してログイン</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>ウィキアのアカウントを Facebook に接続する</h1>
<ul>
<li>現在の利用者名や履歴、編集機能などは維持され、ログイン方法以外に変更されるものはありません。</li>
<li>ウィキア上でのあなたの活動を Facebook 上の友達と共有できます</li>
<li>ウィキアでの活動を、Facebook 上で友達と共有できます。どの情報を表示させるかは設定で指定できます</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; 戻る',
	'comboajaxlogin-connectmarketing-forward' => '次へ &raquo;',
	'comboajaxlogin-connectdirections' => 'こちらにウィキアの利用者名とパスワードを入力してください。ウィキアと Facebook のアカウントが接続処理が行われます。

一度接続すれば、Facebookコネクトボタンを使って簡単にログインできるようになります。',
	'comboajaxlogin-post-not-understood' => 'フォームの構築でエラーが発生しました。

やり直すか、[[Special:Contact|このエラーを報告]]してください。',
	'comboajaxlogin-readonlytext' => '<h2>申し訳ありません</h2>
<p>現在、以下の理由によりアカウントを作成できなくなっています。<br /><em>$1</em></p>
<p>さらに詳しい情報については <a href="http://twitter.com/wikia">Twitter</a> や <a href="http://facebook.com/wikia">Facebook</a> をご覧ください。<br />
（既にアカウントをお持ちであれば、通常通り<a href="#">ログイン</a>はできますが、編集はできません。）</p>',
	'comboajaxlogin-ajaxerror' => 'ウィキアからの応答がありません。ネットワーク接続を確認してください。',
);

/** Korean (한국어)
 * @author Cafeinlove
 * @author 아라
 */
$messages['ko'] = array(
	'comboajaxlogin-createlog' => '로그인하거나 계정 만들기',
	'comboajaxlogin-actionmsg' => '이 행동을 수행하려면 먼저 로그인하거나 계정을 만들어야 합니다',
	'comboajaxlogin-actionmsg-protected' => '이 행동을 수행하려면 먼저 로그인하거나 계정을 만들어야 합니다.',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>페이스북에 연결해 로그인</h1>',
	'comboajaxlogin-connectmarketing-back' => '« 뒤로',
	'comboajaxlogin-connectmarketing-forward' => '시작하기 »',
	'comboajaxlogin-connectdirections' => '여기에 위키아 사용자 이름과 비밀번호를 입력하세요 - 위키아 계정과 페이스북 계정을 연결 처리해드립니다.

한 번 설정해두면, 페이스북 연결 버튼으로에서 쉽게 로그인할 수 있습니다.',
	'comboajaxlogin-ajaxerror' => '위키아가 응답하지 않습니다. 네트워크 연결을 확인하세요.',
);

/** Kyrgyz (Кыргызча)
 * @author Growingup
 */
$messages['ky'] = array(
	'comboajaxlogin-createlog' => 'Кирүү же эсеп жазуусун жаратуу',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'comboajaxlogin-createlog' => 'Loggt Iech an oder Maacht en neie Benotzerkont op',
	'comboajaxlogin-actionmsg' => "Fir dës Aktioun ze maache musst Dir Iech d'éischt aloggen oder e Benotzerkont opmaachen",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Mat Facebook Connect aloggen</h1>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Zréck',
	'comboajaxlogin-connectmarketing-forward' => 'Ufänken &raquo;',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 * @author Mantak111
 * @author Vilius
 */
$messages['lt'] = array(
	'comboajaxlogin-createlog' => 'Prisijungti arba sukurti sąskaitą',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Prisijungti su FaceBook Prisijungimu</h1>',
	'comboajaxlogin-connectmarketing-back' => '« Atgal',
	'comboajaxlogin-connectmarketing-forward' => 'Pradėti »',
	'comboajaxlogin-ajaxerror' => 'Wikia neatsako. Prašome patikrinti savo tinklo jungtį.',
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = array(
	'comboajaxlogin-createlog' => 'Mlebu log utawa gawe akun',
	'comboajaxlogin-actionmsg' => 'Kanggo nglakokna tindakan kiye Rika kudu mlebu log disit utawa gawe akun',
	'comboajaxlogin-actionmsg-protected' => 'Kanggo nglakokna tindakan kiye Rika kudu mlebu log disit utawa gawe akun',
	'comboajaxlogin-connectmarketing' => '<h1>Nyambungna akun-akune Rika</h1>
<ul>
<li>jeneng panganggo sekiye, riwayat, lan suntingan tetep disimpen... Ora ana sing owah mung carane Rika mlebu log thok</li>
<li>Sebarna aktivitase Rika nang Wikia maring kanca-kancane Rika nang Facebook</li>
<li>Kendali kabeh maring apa sing arep dipublikasikna</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Mlebu log nganggo Koneksi Facebook</h1>',
	'comboajaxlogin-connectmarketing-back' => '« Mbalik',
	'comboajaxlogin-connectmarketing-forward' => 'Molai »',
	'comboajaxlogin-ajaxerror' => 'Wikia ora nanggepi. Monggo dipriksa sambungan jaringane Rika.',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'comboajaxlogin-desc' => 'Динамичка кутија што им овозможува на корисниците да се најавуваат, ги потсетува на лозинката и регистрира корисници',
	'comboajaxlogin-createlog' => 'Најавете се или создајте сметка',
	'comboajaxlogin-actionmsg' => 'За да го извршите ова дејство прво треба да сте најавени или да создадете сметка',
	'comboajaxlogin-actionmsg-protected' => 'За да ја уредите оваа заштитена страница најпрвин ќе треба да се најавите или да создадете сметка.',
	'comboajaxlogin-connectmarketing' => '<h1>Поврзете си ги сметките</h1>
<ul>
<li>Задржете си го тековното корисничко име, историјата, уредувањата... Ништо не се менува, освен тоа како се најавувате</li>
<li>Споделете ги вашите активности на Викија со пријателите на Facebook</li>
<li>Целосна контрола врз она што се објавува</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Најава со Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Поврзете си ја сметката на Викија со Facebook</h1>
<ul>
<li>Го задржувате сегашното корисничко име, историјата, уредувањата... ништо нема да се смени, освен начинот на најава</li>
<li>Споделувајте ги вашите активности на Викија со пријателите на Facebook, со целосна контрола врз она што се објавува</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Назад',
	'comboajaxlogin-connectmarketing-forward' => 'Започнете &raquo;',
	'comboajaxlogin-connectdirections' => 'Тука внесете го вашето корисничко име и лозинка на Викија - а ние влошебно ќе ги поврземе вашите сметки на Викија и Facebook во позадината.

Кога сте готови, можете да се најавите користејќи било кое копче за поврзување на Facebook.',
	'comboajaxlogin-post-not-understood' => 'Има грешка во склопот на овој образец.
Обидете се повторно или [[Special:Contact|пријавете ја грешката]].',
	'comboajaxlogin-readonlytext' => '<h2>Жалиме!</h2>
<p>Моментално не можете да создадете сметка - но би требало набргу да проработиме. Еве што се случува:<br /><em>$1</em></p>
<p>За повеќе информации, погледајте на <a href="http://twitter.com/wikia">Twitter</a> или <a href="http://facebook.com/wikia">Facebook</a>.
<br />
(Ако веќе имате сметка, тогаш ќе можете да се <a href="#">најавите</a> како секогаш, но нема да можете да уредувате.)</p>',
	'comboajaxlogin-ajaxerror' => 'Викија не реагира. Проверете си ја мрежната врска.',
);

/** Malayalam (മലയാളം)
 * @author Kavya Manohar
 * @author Praveenp
 */
$messages['ml'] = array(
	'comboajaxlogin-createlog' => 'പ്രവേശിക്കുക / അംഗത്വമെടുക്കുക',
	'comboajaxlogin-actionmsg' => 'ഇക്കാര്യം ചെയ്യുന്നതിനായി താങ്കൾ ആദ്യം ലോഗിൻ ചെയ്യുക അല്ലെങ്കിൽ അംഗത്വമെടുക്കുക',
	'comboajaxlogin-actionmsg-protected' => 'ഇക്കാര്യം ചെയ്യുന്നതിനായി താങ്കൾ ആദ്യം ലോഗിൻ ചെയ്യുക അല്ലെങ്കിൽ അംഗത്വമെടുക്കുക',
	'comboajaxlogin-connectmarketing-back' => '« പുറകോട്ട്',
	'comboajaxlogin-connectmarketing-forward' => 'തുടങ്ങുക »',
	'comboajaxlogin-connectdirections' => 'താങ്കളുടെ വിക്കിയ ഉപയോക്തൃനാമവും രഹസ്യവാക്കും ഇവിടെ നൽകുക - താങ്കളുടെ വിക്കിയ ഫേസ്ബുക്ക് അക്കൗണ്ടുകളെ ഞങ്ങൾ ആന്തരികമായി ബന്ധിപ്പിക്കാം.

അതിനു ശേഷം, ഫേസ്ബുക്ക് കണക്റ്റ് ബട്ടൺ ഉപയോഗിച്ച് താങ്കൾക്ക് എളുപ്പം പ്രവേശനം സാധ്യമാകും.',
);

/** Marathi (मराठी)
 * @author V.narsikar
 */
$messages['mr'] = array(
	'comboajaxlogin-createlog' => 'सनोंद-प्रवेश करा किंवा सदस्यखाते उघडा',
	'comboajaxlogin-actionmsg' => 'ही क्रिया करण्यास आपणास एकतर सनोंद प्रवेश करावयास हवा किंवा खाते उघडावयास हवे',
	'comboajaxlogin-actionmsg-protected' => 'ही क्रिया करण्यास आपणास प्रथम सनोंद प्रवेश करावयास हवा किंवा खाते उघडावयास हवे',
	'comboajaxlogin-connectmarketing-back' => '« परत',
	'comboajaxlogin-connectmarketing-forward' => 'सुरुवात करा»',
	'comboajaxlogin-connectdirections' => 'आपले विकिया सदस्यनाव व परवलीचा शब्द येथे टाका - आम्ही जादुई-तऱ्हेने आपले विकिया व फेसबुकचे खाते पडद्याआड जोडु.

हे झाल्यावर आपण फेसबुकशी जोडा कळीवर टिचकुन सोप्या तऱ्हेने प्रवेशु शकता.',
	'comboajaxlogin-post-not-understood' => 'ह्या आवेदनाच्या भरण्याच्या दरम्यान चूक झाली.पुन्हा प्रयत्न करा किंवा [[Special:Contact|याचा अहवाल द्या]].',
	'comboajaxlogin-ajaxerror' => 'विकिया प्रत्युत्तर देत नाही. कृपया आपला इंटरनेट कनेक्शन तपासा.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'comboajaxlogin-desc' => 'Petak dinamik yang membolehkan pengguna log masuk, ingatkan kata laluan dan daftarkan pengguna',
	'comboajaxlogin-createlog' => 'Log masuk atau buka akaun',
	'comboajaxlogin-actionmsg' => 'Untuk melakukan tindakan ini, anda perlu log masuk atau membuka akaun terlebih dahulu.',
	'comboajaxlogin-actionmsg-protected' => 'Untuk melakukan tindakan ini, anda perlu log masuk atau membuka akaun terlebih dahulu.',
	'comboajaxlogin-connectmarketing' => '<h1>Sambungkan akaun-akaun anda</h1>
<ul>
<li>Simpan nama pengguna semasa, sejarah, suntingan anda dsb... tiada apa yang berubah selain cara anda log masuk</li>
<li>Kongsikan kegiatan anda di Wikia bersama rakan-rakan di Facebook</li>
<li>Anda boleh mengawal sepenuhnya apa yang diterbitkan</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Log masuk dengan Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Sambungkan akaun Wikia anda dengan Facebook</h1>
<ul>
<li>Simpan nama pengguna semasa, sejarah, suntingan anda dsb... tiada apa yang berubah selain cara anda log masuk</li>
<li>Kongsikan kegiatan anda di Wikia dengan rakan-rakan anda Facebook, dengan mengawal sepenuhnya apa yang diterbitkan</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Kembali',
	'comboajaxlogin-connectmarketing-forward' => 'Mulakan &raquo;',
	'comboajaxlogin-connectdirections' => 'Taipkan nama pengguna dan kata laluan Wikia anda di sini – kami akan menyambungkan akaun-akaun Wikia dan Facebook secara automatik.

Selepas siap, anda boleh log masuk dengan mudah dengan menekan mana-mana butang Facebook Connect.',
	'comboajaxlogin-post-not-understood' => 'Terdapat ralat dalam cara borang ini dibentuk.
Sila cuba lagi atau [[Special:Contact|laporkannya kepada kami]].',
	'comboajaxlogin-readonlytext' => '<h2>Harap maaf!</h2>
<p>Anda tidak boleh membuka akaun buat masa ini. Harap bersabar, kami akan kembali berfungsi tidak lama lagi. Sebabnya:<br /><em>$1</em></p>
<p>Sila rujuk <a href="http://twitter.com/wikia">Twitter</a> atau <a href="http://facebook.com/wikia">Facebook</a> untuk maklumat lanjut.
<br />
(Jika anda sudah ada akaun, anda boleh <a href="#">log masuk</a> seperti biasa, tetapi anda tidak boleh menyunting buat masa ini.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia tidak bertindak balas. Sila periksa sambungan rangkaian anda.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'comboajaxlogin-createlog' => 'Idħol jew oħloq kont',
	'comboajaxlogin-actionmsg' => 'Biex twettaq din l-azzjoni trid tkun dħalt fil-kont jew irreġistrajt.',
	'comboajaxlogin-actionmsg-protected' => 'Biex twettaq din l-azzjoni trid tkun dħalt fil-kont jew irreġistrajt.',
	'comboajaxlogin-connectmarketing-back' => '« Lura',
	'comboajaxlogin-connectmarketing-forward' => 'Ibda »',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'comboajaxlogin-desc' => 'Dynamisk boks som lar brukere logge inn, få påminnelse om passord og registrere brukere',
	'comboajaxlogin-createlog' => 'Logg inn eller opprett en konto',
	'comboajaxlogin-actionmsg' => 'For å utføre denne handlingen må du først logge inn eller opprette en konto',
	'comboajaxlogin-actionmsg-protected' => 'For å redigere denne beskyttede siden, må du først logge inn eller opprette en konto.',
	'comboajaxlogin-connectmarketing' => '<h1>Koble sammen kontoene dine</h1>
<ul>
<li>Behold ditt nåværende brukernavn, din historie, dine redigeringer... Ingenting endres bortsett fra hvordan du logger inn</li>
<li>Del aktiviteten din på Wikia med vennene dine på Facebook</li>
<li>Full kontroll over hva som publiseres</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Logg inn med Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Koble Wikia-kontoen din til Facebook</h1>
<ul>
<li>Behold nåværende brukernavn, historie, endringer... Ingenting forandres bortsett fra hvordan du logger inn</li>
<li>Del aktiviteten din på Wikia med vennene dine på Facebook, med full kontroll over hva som publiseres</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Tilbake',
	'comboajaxlogin-connectmarketing-forward' => 'Kom i gang &raquo;',
	'comboajaxlogin-connectdirections' => 'Skriv inn ditt Wikia-brukernavn og -passord her - vi vil på magisk vis koble sammen Wikia- og Facebook-kontoene dine i bakgrunnen.

Så fort du er ferdig, kan du enkelt logge inn med en hvilken som helst Facebook Connect-knapp.',
	'comboajaxlogin-post-not-understood' => 'Det er en feil i måten skjemaet ble bygget på.
Vennligst prøv igjen eller [[Special:Contact|rapporter dette]].',
	'comboajaxlogin-readonlytext' => '<h2>Beklager!</h2>
<p>Du kan ikke opprette en konto for øyeblikket - vi er sannsyneligvis oppe og går igjen om kort tid. Her er det som skjer:<br /><em>$1</em></p>
<p>Vennligst sjekk ut <a href="http://twitter.com/wikia">Twitter</a> eller <a href="http://facebook.com/wikia">Facebook</a> for mer informasjon.
<br />
(Hvis du allerede har en konto, kan du <a href="#">logge inn</a> som vanlig, men du vil ikke kunne redigere.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia svarer ikke. Kontroller nettverkstilkoblingen.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'comboajaxlogin-desc' => 'Dynamisch venster dat gebruikers laat aanmelden, een nieuw wachtwoord opvragen en registreren',
	'comboajaxlogin-createlog' => 'Meld u aan of maak een nieuwe gebruiker aan',
	'comboajaxlogin-actionmsg' => 'Om deze handeling uit te kunnen voeren moet u eerst aanmelden of een gebruiker registreren',
	'comboajaxlogin-actionmsg-protected' => 'U moet eerst aanmelden of een gebruiker aanmaken om deze beveiligde pagina te kunnen bewerken.',
	'comboajaxlogin-connectmarketing' => '<h1>Met andere websites verbinden</h1>
<ul>
<li>Behoud uw huidige gebruikersnaam, geschiedenis, bewerkingen, enzovoort. Niets wijzigt, behalve de manier waarop u aanmeldt</li>
<li>Deel uw activiteit bij Wikia met uw vrienden op Facebook</li>
<li>Volledige controle over wat wordt gepubliceerd</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Aanmelden via Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Uw Wikia-gebruiker met uw Facebook-gebruiker verbinden</h1>
<ul>
<li>Behoud uw huidige gebruikersnaam, geschiedenis, bewerkingen, enzovoort. Niets wijzigt, behalve de manier waarop u aanmeldt</li>
<li>Deel uw activiteit bij Wikia met uw vrienden op Facebook en behoud volledige controle over wat wordt gepubliceerd</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '« Terug',
	'comboajaxlogin-connectmarketing-forward' => 'Aan de slag »',
	'comboajaxlogin-connectdirections' => 'Voer hier uw gebruikersnaam en wachtwoord voor Wikia in, dan verbinden we op de achtergrond uw Wikia- en Facebookgebruikers.

Nadat u dit hebt uitgevoerd, kunt u eenvoudig aanmelden met de knop Facebook Connect.',
	'comboajaxlogin-post-not-understood' => 'Er is een fout opgetreden bij het samenstellen van dit formulier.
Probeer het nog een keer of [[Special:Contact|rapporteer dit]].',
	'comboajaxlogin-readonlytext' => '<h2>Storing</h2>
<p>U kunt op dit moment geen gebruiker aanmaken. Meestal is de site weer snel beschikbaar. Dit is wat er aan de hand is:<br /><em>$1</em></p>
<p>Kijk op <a href="http://twitter.com/wikia">Twitter</a> of <a href="http://facebook.com/wikia">Facebook</a> voor meer informatie.
<br />
Als u al een gebruiker hebt, kunt u <a href="#">aanmelden</a> zoals altijd, maar bewerken is op het moment niet mogelijk.</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia reageert niet. Controleer uw netwerkverbinding.',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'comboajaxlogin-actionmsg' => 'Om deze handeling uit te kunnen voeren moet je eerst aanmelden of een gebruiker registreren',
	'comboajaxlogin-actionmsg-protected' => 'Je moet eerst aanmelden of een gebruiker aanmaken om deze beveiligde pagina te kunnen bewerken.',
	'comboajaxlogin-connectmarketing' => '<h1>Met andere websites verbinden</h1>
<ul>
<li>Behoud je huidige gebruikersnaam, geschiedenis, bewerkingen, enzovoort. Niets wijzigt, behalve de manier waarop je aanmeld</li>
<li>Deel je activiteit bij Wikia met je vrienden op Facebook</li>
<li>Volledige controle over wat wordt gepubliceerd</li>
</ul>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Je Wikia-gebruiker met je Facebook-gebruiker verbinden</h1>
<ul>
<li>Behoud je huidige gebruikersnaam, geschiedenis, bewerkingen, enzovoort. Niets wijzigt, behalve de manier waarop je aanmeld</li>
<li>Deel je activiteit bij Wikia met je vrienden op Facebook en behoud volledige controle over wat wordt gepubliceerd</li>
</ul>',
	'comboajaxlogin-connectdirections' => 'Voer hier je gebruikersnaam en wachtwoord voor Wikia in, dan verbinden we op de achtergrond je Wikia- en Facebookgebruikers.

Nadat je dit hebt uitgevoerd, kan je eenvoudig aanmelden met de knop Facebook Connect.',
	'comboajaxlogin-readonlytext' => '<h2>Storing</h2>
<p>Je kunt op dit moment geen gebruiker aanmaken. Meestal is de site weer snel beschikbaar. Dit is wat er aan de hand is:<br /><em>$1</em></p>
<p>Kijk op <a href="http://twitter.com/wikia">Twitter</a> of <a href="http://facebook.com/wikia">Facebook</a> voor meer informatie.
<br />
Als je al een gebruiker hebt, kan je <a href="#">aanmelden</a> zoals altijd, maar bewerken is op het moment niet mogelijk.</p>',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'comboajaxlogin-desc' => "Bóstia de dinamica que permeton als utilizaires de se connectar, se rapelar de lor senhal e d'enregistrar d'utilizaires",
	'comboajaxlogin-createlog' => 'Se connectar o crear un compte',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Se connectar amb Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Retorn',
	'comboajaxlogin-connectmarketing-forward' => 'Abans de començar &raquo;',
);

/** Polish (polski)
 * @author Sovq
 */
$messages['pl'] = array(
	'comboajaxlogin-desc' => 'Dynamiczne okienko, umożliwiające użytkownikom na logowanie, rejestrację i przypomnienie hasła.',
	'comboajaxlogin-createlog' => 'Zaloguj się lub utwórz konto',
	'comboajaxlogin-actionmsg' => 'Aby wykonać tę czynność, musisz najpierw zalogować się lub utworzyć konto.',
	'comboajaxlogin-actionmsg-protected' => 'Aby wykonać tę czynność, musisz najpierw zalogować się lub utworzyć konto.',
	'comboajaxlogin-connectmarketing' => '<h1>Połącz swoje konta</h1>
<ul>
<li>Zachowaj swoją obecną nazwę użytkownika, historię, edycje... Nic się nie zmieni oprócz sposobu logowania.</li>
<li>Dziel się swoją aktywnością na Wikii z przyjaciółmi na Facebooku.</li>
<li>Będziesz mieć pełną kontrolę nad publikowanymi informacjami.</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Zaloguj się korzystając z „Facebook Connect”</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Przyłącz swoje konto na Wikii do tego na Facebooku</h1>
<ul>
<li>Zachowaj swoją obecną nazwę użytkownika, historię, edycje... Nic się nie zmieni oprócz sposobu logowania.</li>
<li>Dziel się swoją aktywnością na Wikii z przyjaciółmi na Facebooku, utrzymując pełną kontrolę nad publikowanymi informacjami.</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Wróć',
	'comboajaxlogin-connectmarketing-forward' => 'Rozpocznij &raquo;',
	'comboajaxlogin-connectdirections' => 'Wpisz tutaj swoją nazwę użytkownika i hasło na Wikii – połączymy w tle Twoje konta na Wikii i Facebooku.

Gdy skończysz, będziesz mógł się łatwo zalogować korzystając z każdego przycisku „Facebook Connect”.',
	'comboajaxlogin-post-not-understood' => 'Wystąpił błąd w sposobie, w jaki ten formularz został wypełniony.
Spróbuj ponownie lub [[Special:Contact|zgłoś problem]].',
	'comboajaxlogin-readonlytext' => '<h2>Przepraszamy!</h2>
<p>W tym momencie nie możesz utworzyć konta. Wkrótce wszystko ponownie wrócić do normy. Przyczyna problemu:<br /><em>$1</em></p>
<p>Więcej informacji odnajdziesz na stronach <a href="http://twitter.com/wikia">Twittera</a> lub <a href="http://facebook.com/wikia">Facebooka</a>.
<br />
(Jeśli już masz konto, możesz zwyczajnie <a href="#">zalogować się</a>, ale nie będziesz mógł edytować.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia nie odpowiada. Sprawdź swoje połączenie z siecią.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'comboajaxlogin-desc' => "Fnestra dinàmica che a përmët a j'utent d'intré, d'arcòrdé soa ciav e ëd registré dj'utent",
	'comboajaxlogin-createlog' => 'Intra o crea un cont',
	'comboajaxlogin-actionmsg' => "Për fé st'assion-si a dev prima intré ant ël sistema o creé un cont",
	'comboajaxlogin-actionmsg-protected' => "Për fé st'assion-sì a dev prima intré ant ël sistema o creé un cont.",
	'comboajaxlogin-connectmarketing' => "<h1>Ch'a colega ij sò cont</h1>
<ul>
<li>A manten sò nòm utent corent, stòria, modìfiche... a cangia gnente, gavà la fasson d'intré ant ël sistema</li>
<li>A partagia soa atività su Wikia con ij sò amis su Facebook</li>
<li>Contròl complet ëd lòn ch'a l'é publicà</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Intré an Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Ch'a colega sò cont Wikia a Facebook</h1>
<ul>
<li>Ch'a goerna sò stranòm utent corent, stòria, modìfiche... a cangia gnente gavà la fasson d'intré ant ël sistema</li>
<li>Ch'a condivida soa atività su Wikia con ij sò amis ëd Facebook, con contròl complet ëd lòn ch'a l'é publicà</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '&laquo; André',
	'comboajaxlogin-connectmarketing-forward' => 'Ancamin-a &raquo;',
	'comboajaxlogin-connectdirections' => "Ch'a anserissa sò nòm utent e soa ciav Wikia ambelessì - i colegheroma magicament ij sò cont Wikia e Facebook an slë sfond.

Na vira ch'a l'abia fàit, a peule intré facilment ant ël sistema an dovrand un boton Facebook Connect qualsëssìa.",
	'comboajaxlogin-post-not-understood' => "A-i é stàje n'eror ant la manera che cont formolari a l'é stàit fabricà.
Për piasì, ch'a preuva torna o [[Special:Contact|ch'a lo signala]].",
	'comboajaxlogin-readonlytext' => '<h2>An dëspias!</h2>
<p>A peul pa creé un cont al moment - i dovrìo torna esse bon a marcé da si \'n pòch. Ambelessì a-i é lòn ch\'a l\'é capitaje:<br /><em>$1</em></p>
<p>Për piasì, ch\'a contròla <a href="http://twitter.com/wikia">Twitter</a> o <a href="http://facebook.com/wikia">Facebook</a> për savèjne ëd pi.
<br />
(S\'a l\'ha già un cont, a peul <a href="#">intré ant ël sistema</a> coma al sòlit, ma a podrà pa fé \'d modìfiche.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia a arspond pa. Për piasì contròla toa conession ëd rej.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'comboajaxlogin-createlog' => 'ننوتل او يا يو گڼون جوړول',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>د فېسبوک له لارې ننوتل</h1>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; پر شا کېدل',
	'comboajaxlogin-connectmarketing-forward' => 'پيلول &raquo;',
);

/** Portuguese (português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Luckas
 */
$messages['pt'] = array(
	'comboajaxlogin-desc' => 'Caixa dinâmica que permite a autenticação e registo de utilizadores e relembrar a palavra-chave',
	'comboajaxlogin-createlog' => 'Entrar ou criar uma conta',
	'comboajaxlogin-actionmsg' => 'Para realizar esta operação, antes tem de autenticar-se ou registar uma conta',
	'comboajaxlogin-actionmsg-protected' => 'Para editar esta página protegida, precisa de autenticar-se ou criar uma conta.',
	'comboajaxlogin-connectmarketing' => '<h1>Ligue as suas contas</h1>
<ul>
<li>Mantenha o seu nome de utilizador, histórico e edições... nada muda, exceto a forma como se autentica</li>
<li>Partilhe a sua atividade na Wikia com os seus amigos no Facebook</li>
<li>Controlo total do que é publicado</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Autenticar-se com o Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Ligue a sua conta Wikia ao Facebook</h1>
<ul>
<li>Mantenha o seu nome de utilizador, histórico, edições... nada muda, exceto a forma como entra</li>
<li>Partilhe a sua atividade na Wikia com os amigos no Facebook com controlo total do que é publicado</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Voltar',
	'comboajaxlogin-connectmarketing-forward' => 'Começar &raquo;',
	'comboajaxlogin-connectdirections' => 'Introduza aqui o seu nome de utilizador e palavra-chave - por artes mágicas, ligaremos as suas contas Wikia e Facebook nos bastidores.

Quando acabar, poderá autenticar-se usando qualquer botão Ligação Facebook.',
	'comboajaxlogin-post-not-understood' => 'Foi detectado um erro na forma como este formulário foi construído.
Tente novamente ou [[Special:Contact|reporte este erro]], por favor.',
	'comboajaxlogin-readonlytext' => '<h2>Desculpe!</h2>
<p>Neste momento não pode criar uma conta - devemos estar novamente operacionais dentro de pouco tempo. O que está a acontecer é o seguinte:<br /><em>$1</em></p>
<p>Para mais informações, verifique o <a href="http://twitter.com/wikia">Twitter</a> ou o <a href="http://facebook.com/wikia">Facebook</a>, por favor.
<br />
(Se já tem uma conta, pode <a href="#">autenticar-se</a> normalmente, mas não poderá editar.)</p>',
	'comboajaxlogin-ajaxerror' => 'A Wikia não está a responder. Verifique a sua ligação de rede, por favor.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Giro720
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'comboajaxlogin-desc' => 'Caixa dinâmica que permite aos usuários a autenticação, recordação da senha e registração de usuários',
	'comboajaxlogin-createlog' => 'Entrar ou criar uma conta',
	'comboajaxlogin-actionmsg' => 'Para realizar esta operação, você deve antes autenticar-se ou registrar uma conta',
	'comboajaxlogin-actionmsg-protected' => 'Para realizar esta ação, você deve antes autenticar-se ou criar uma conta.',
	'comboajaxlogin-connectmarketing' => '<h1>Ligue as suas contas</h1>
<ul>
<li>Mantenha o seu nome de usuário, histórico e edições... Nada muda, exceto a forma como se autentica</li>
<li>Partilhe a sua atividade na Wikia com os seus amigos no Facebook</li>
<li>Controle total do que é publicado</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Autenticar-se com o Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Ligue a sua conta Wikia ao Facebook</h1>
<ul>
<li>Mantenha o seu nome de usuário, histórico, edições... nada muda, exceto a forma como você entra</li>
<li>Partilhe a sua atividade na Wikia com os amigos no Facebook com controle total do que é publicado</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Voltar',
	'comboajaxlogin-connectmarketing-forward' => 'Começar &raquo;',
	'comboajaxlogin-connectdirections' => 'Introduza aqui o seu nome de usuário e senha - nós magicamente conectaremos as suas contas Wikia e Facebook nos bastidores.

Quando acabar, poderá autenticar-se usando qualquer botão Conexão Facebook.',
	'comboajaxlogin-post-not-understood' => 'Foi detectado um erro na forma como este formulário foi construído.
Tente novamente ou [[Special:Contact|reporte este erro]], por favor.',
	'comboajaxlogin-readonlytext' => '<h2>Desculpe!</h2>
<p>Neste momento você não pode criar uma conta - devemos estar novamente operacionais dentro de pouco tempo. O que está acontecendo é o seguinte:<br /><em>$1</em></p>
<p>Para mais informações, verifique o <a href="http://twitter.com/wikia">Twitter</a> ou o <a href="http://facebook.com/wikia">Facebook</a>, por favor.
<br />
(Se já tem uma conta, pode <a href="#">autenticar-se</a> normalmente, mas não poderá editar.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia não responde. Por favor, cheque sua conexão.',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'comboajaxlogin-createlog' => 'Autentificaţi-vă sau creaţi un cont',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Autentificare cu Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Înapoi',
	'comboajaxlogin-connectmarketing-forward' => 'Începeţi &raquo;',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'comboajaxlogin-desc' => "Fenèstre denameche ca conzendone a l'utinde de trasère, arrecordare 'a passsuord e fàce ccu registre le utinde",
	'comboajaxlogin-createlog' => "Trase o ccreje 'nu cunde utende nuève",
	'comboajaxlogin-actionmsg' => "Ce vuè ccu fàce quiste cose tu hé ddà trasè o hé ddà crejà 'nu cunde",
	'comboajaxlogin-actionmsg-protected' => "Ce vuè ccu fàce quiste cose tu hé ddà trasè o hé ddà crejà 'nu cunde",
	'comboajaxlogin-connectmarketing' => "<h1>Colleghe le cunde tune</h1>
<ul>
<li>Mandìne 'u nome utende de mò tune, le cunde, le cangiaminde... nisciune cangiaminde apparte cumme tràse</li>
<li>Condivide l'attività tue sus a Uicchia cu l'amice tune sus a Feisbuc</li>
<li>Condrolle comblete de quidde ca pubbleche</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Tràse cu Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Colleghe 'u cunde tue de Uicchia a Feisbuc</h1>
<ul>
<li>Mandìne 'u nome utende tune de mò, 'a storie, le cangiaminde... nò cange ninde accume tràse</li>
<li>Condivide le attivitate tune sus a Uicchia cu le amice tue de Feisbuc, cu 'nu condrolle comblete de quidde ca ste pubbleche</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '&laquo; Rrète',
	'comboajaxlogin-connectmarketing-forward' => 'Ccu accumenze &raquo;',
	'comboajaxlogin-connectdirections' => "Mitte 'u nome utende tune de Uicchia e 'a passuord aqquà - nuje maggecamende te collegame le cunde de Uicchia e Feisbuc da rrete.

'Na vote ca è fatte, tu puè trasè facilmende ausanne ogne buttone de collegamende de Feisbuc.",
	'comboajaxlogin-post-not-understood' => "Stave 'n'errore jndr'à 'u mode jndr'à 'u quale 'u module ha state fatte.
Pe piacere pruève arrete o [[Special:Contact|segnalale]].",
	'comboajaxlogin-readonlytext' => '<h2>Ne despiace!</h2>
<p>Non ge puè ccrejà \'nu cunde utende jndr\'à stu mumende - nuje avessema funzionà arrete tra quacche mumende. Quiste jè quidde ca ha successe:<br /><em>$1</em></p>
<p>Pe piacere verifiche <a href="http://twitter.com/wikia">Tuitter</a> o <a href="http://facebook.com/wikia">Feisbuc</a> pe cchiù \'mbormaziune.
<br />
(Ce tu tìne ggià \'nu cunde, tu puè <a href="#">trasè</a> normalmende, ma non ge puè fà le cangiaminde.)</p>',
	'comboajaxlogin-ajaxerror' => "Uicchia non ge ste resppnne. Pe piacere condrolle 'a connessione d'a rezza toje.",
);

/** Russian (русский)
 * @author Eleferen
 * @author G0rn
 * @author Kuzura
 * @author MaxSem
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'comboajaxlogin-desc' => 'Динамические окна, которые позволяют пользователям представляться, напоминать пароль и регистрироваться',
	'comboajaxlogin-createlog' => 'Представиться системе или создать новую учётную запись',
	'comboajaxlogin-actionmsg' => 'Для выполнения этой операции необходимо сначала войти в систему или создать аккаунт',
	'comboajaxlogin-actionmsg-protected' => 'Чтобы изменить эту защищенную страницу, нужно сначала представиться системе или создать учётную запись.',
	'comboajaxlogin-connectmarketing' => '<h1>Соедините свои учётные записи</h1>
<ul>
<li>Сохраните своё имя пользователя, историю, правки… Ничего не изменится кроме того, как представляться системе</li>
<li>Делитесь своей активностью в Wikia с вашими друзьями в Facebook</li>
<li>Полный контроль над тем, что будет опубликовано</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Представиться системе с помощью Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Подключите свою учётную запись Wikia к Facebook</h1>
<ul>
<li>Сохраните имя пользователя, историю, правки… Ничего не изменится кроме входа в систему.</li>
<li>Делитесь своей активностью в Wikia с вашими друзьями в Facebook, сохраняя полный контроль над тем, что будет опубликовано.</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Назад',
	'comboajaxlogin-connectmarketing-forward' => 'Начало работы &raquo;',
	'comboajaxlogin-connectdirections' => 'Введите свои имя пользователя и пароль в Wikia и мы волшебным образом соединим ваши учётные записи в Wikia и Facebook.

После завершения вы сможете легко представляться системе с помощью любой из кнопок Facebook Connect.',
	'comboajaxlogin-post-not-understood' => 'Произошла ошибка при построении этой формы.
Пожалуйста, попробуйте снова или [[Special:Contact|сообщите об этом]].',
	'comboajaxlogin-readonlytext' => '<h2>Извините!</h2>
<p>Вы не можете создать учётную запись в данный момент. Мы должны скоро восстановить свою работу. Вот что происходит:<br /><em>$1</em></p>
<p>Подробности можно посмотреть в <a href="http://twitter.com/wikia">Twitter</a> или <a href="http://facebook.com/wikia">Facebook</a>.
<br />
(Если у вас уже есть учётная запись, вы можете <a href="#">войти</a> как обычно, но вы не сможете редактировать.)</p>',
	'comboajaxlogin-ajaxerror' => 'Викия не отвечает. Пожалуйста, проверьте подключение к сети.',
);

/** Somali (Soomaaliga)
 * @author Abshirdheere
 */
$messages['so'] = array(
	'comboajaxlogin-desc' => 'Qaanada dinamicada ee u suura galineeysa gadegaleyaasha isdiiwwn gelinta sidoo kale waxa uu xasuusinayaa ereysirta iyo gudageleyssha diiwaan gashan.',
	'comboajaxlogin-createlog' => 'Gudaha gal ama sameyso akoon',
	'comboajaxlogin-actionmsg' => 'Si aad hoowshaan uqabto waxaa lagaa doonayaa marka hore inaad gudegelaada isticmaasho ama aad sameeysato akoon cusub',
	'comboajaxlogin-actionmsg-protected' => 'Si aad howshaan usii wado waxaad ugu horayn ubaahanatahay inaad gudaha gashid ama aad sameeysid akoon cusub',
	'comboajaxlogin-connectmarketing' => '<h1>Ku xiriri akoonkaada</h1>
<ul>
<li>Ku ilaali magacaan aad adeegsato, Taariikhda, isbedelada... wax isbedel ah ma jiraan oo aan ka ahayn habka gudagalista</li>
<li>uga  qayb qal dhaqdhaqaada Wikiga asxaabtaada ee ku jirta Facebook</li>
<li>Ilaali waxa lagu soo bandhiyo Facebook aad isticmaasho</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Ku fur xiriirka facebook</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>isku xir labada akoon wikiga iyo Facebook</h1>
<ul>
<li>Ku ilaali magacaan aad adeegsato, Taariikhda, isbedelada... wax isbedel ah ma jiraan oo aan ka ahayn habka gudagalista</li>
<li>uga  qayb qal dhaqdhaqaada Wikiga asxaabtaada ee ku jirta Facebook, Ilaali waxa lagu soo bandhiyo Facebook aad isticmaasho</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Ka noqo',
	'comboajaxlogin-connectmarketing-forward' => 'Biloow &raquo;',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'comboajaxlogin-createlog' => 'Пријавите се или отворите налог',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Назад',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'comboajaxlogin-desc' => 'En dynamisk box som tillåter användare att logga in, påminna lösenord och registrera användare',
	'comboajaxlogin-createlog' => 'Logga in eller skapa ett konto',
	'comboajaxlogin-actionmsg' => 'För att utföra denna åtgärd måste du först logga in eller skapa ett konto',
	'comboajaxlogin-actionmsg-protected' => 'För att utföra denna åtgärd måste du först logga in eller skapa ett konto.',
	'comboajaxlogin-connectmarketing' => '<h1>Anslut dina konton</h1>
<ul>
<li>Behåll ditt nuvarande användarnamn, din historik, dina redigeringar... ingenting förändras förutom sättet du loggar in</li>
<li>Dela dina aktiviteter på Wikia med dina vänner på Facebook</li>
<li>Fullständig kontroll över vad som publiceras</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Logga in med Facebook Connect</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Anslut ditt Wikia konto till Facebook</h1>
<ul>
<li>Behåll ditt nuvarande användarnamn, din historik, dina redigeringar... ingenting förändras förutom sättet du loggar in</li>
<li>Dela dina aktiviteter på Wikia med dina vänner på Facebook, med fullständig kontroll över vad som publiceras</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Tillbaka',
	'comboajaxlogin-connectmarketing-forward' => 'Kom igång &raquo;',
	'comboajaxlogin-connectdirections' => 'Ange ditt användarnamn och lösenord på Wikia här - vi kommer magiskt ansluta ditt Wikia- och Facebook-konto i bakgrunden.

När du är klar, kan du logga in enkelt och snabbt med hjälp av någon Facebook Connect knapp.',
	'comboajaxlogin-post-not-understood' => 'Det uppstod ett fel i denna form.
Försök igen eller [[Special:Contact|anmäl det här]].',
	'comboajaxlogin-readonlytext' => '<h2>Tyvärr!</h2>
<p>Du kan inte skapa ett konto för tillfället - vi borde vara igång igen inom kort. Här är vad som händer:<br /><em>$1</em></p>
<p>Kolla in <a href="http://twitter.com/wikia">Twitter</a> eller <a href="http://facebook.com/wikia">Facebook</a> för mer information.
<br />
(Om du redan har ett konto kan du <a href="#">logga in</a> som vanligt, men du kommer inte kunna redigera.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia svarar inte. Var god kontrollera din nätverksanslutning.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'comboajaxlogin-connectmarketing-back' => '&laquo; వెనుకకు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'comboajaxlogin-desc' => 'Magilang kahon na nagpapahintulot ng mga tagagamit na lumagda, ipaalala ang hudyat at magtala ng mga tagagamit',
	'comboajaxlogin-createlog' => 'Lumagda o lumikha ng isang akawnt',
	'comboajaxlogin-actionmsg' => 'Upang maisagawa ang galaw na ito dapat kang lumagda muna o lumikha ng isang akawnt',
	'comboajaxlogin-actionmsg-protected' => 'Upang maisagawa ang galaw na ito kailangan mo munang lumagda o lumikha ng isang akawnt.',
	'comboajaxlogin-connectmarketing' => '<h1>Iugnay ang iyong mga akawnt</h1>
<ul>
<li>Panatilihin ang iyong pangkasalukuyang pangalan ng tagagamit, kasaysayan, mga pamamatnugot... walang mababago maliban sa kung paano lumalagda</li>
<li>Ipamahagi ang iyong mga ginagawa sa Wikia sa iyong mga kaibigang nasa Facebook</li>
<li>Buong pagtaban sa kung ano ang nailathala</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Lumagda sa pamamagitan ng Pang-ugnay ng Facebook</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Ikabit ang iyong akawnt ng Wikia sa Facebook</h1>
<ul>
<li>Panatilihin ang iyong pangkasalukuyang pangalan ng tagagamit, kasaysayan, mga pamamatnugot... walang mababago maliban sa kung paano ka lumalagdang papasok</li>
<li>Ibahagi ang gawain sa Wikia sa mga kaibigan mong nasa Facebook, na may buong pagtaban sa kung ano ang nailalathala</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '&laquo; Bumalik',
	'comboajaxlogin-connectmarketing-forward' => 'Magsimula &raquo;',
	'comboajaxlogin-connectdirections' => 'Ipasok ang iyong pangalan ng tagagamit sa Wikia at hudyat dito - masalamangka naming iuugnay ang iyong mga akawnt na pang-Wikia at pang-Facebook sa likuran.

Kapag natapos ka na, maginhawa kang makakalagda na ginagamit ang anumang pindutan ng Ugnay sa Facebook.',
	'comboajaxlogin-post-not-understood' => 'May kamalian sa paraan ng pagkakayari ng pormularyong ito.
Pakisubukan uli o [[Special:Contact|iulat ito]].',
	'comboajaxlogin-readonlytext' => '<h2>Paumanhin!</h2>
<p>Hindi ka makakalikha ng isang akawnt sa sandaling ito - babangon kami at tatakbong muli sa loob ng ilang saglit. Narito ang kung ano ang nagaganap:<br /><em>$1</em></p>
<p>Paki suriin ang <a href="http://twitter.com/wikia">Twitter</a> o ang <a href="http://facebook.com/wikia">Facebook</a> para sa mas marami pang kabatiran.
<br />
(Kung mayroon ka nang isang akawnt, maaari kang <a href="#">lumagdang papasok</a> ayon sa pangkaraniwan, subalit hindi mo magagawang makapamatnugot.)</p>',
	'comboajaxlogin-ajaxerror' => 'Hindi tumutugon ang Wikia. Paki suriin ang pagkakabit ng iyong lambat na panggawain.',
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 * @author Sabri Vatansever
 */
$messages['tr'] = array(
	'comboajaxlogin-desc' => 'Kullanıcılara girişi sağlayan dinamik kutu şifreyi hatırlar ve kullanıcıyı kaydeder',
	'comboajaxlogin-createlog' => 'Oturum açın ya da yeni hesap oluşturun',
	'comboajaxlogin-actionmsg' => 'Bu eylemi gerçekleştirmek için öncelikle oturumun açmanız veya hesap oluşturmanız gerekir',
	'comboajaxlogin-actionmsg-protected' => 'Bu eylemi gerçekleştirmek için öncelikle oturumun açmanız veya hesap oluşturmanız gerekir',
	'comboajaxlogin-connectmarketing' => "<h1>Hesaplarınızı bağlanın</h1>
<ul>
<li>Geçerli kullanıcı adınızı, tarihi, düzenlenenleri saklayın... giriş yapmanız dışında hiçbir şey değişmez</li>
<li>Wikia'daki etkinliklerinizi Facebook üzerinden arkadaşlarınızla paylaşın</li>
<li>Yayınların kontrolünü tamamlayın</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => "<h1>Facebook'a Bağlan ile oturum aç</h1>",
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Facebook ile Wikia hesabınıza bağlanın</h1>
<ul>
<li>Geçerli kullanıcı adınızı, tarihi, düzenlenenleri saklayın... giriş yapmanız dışında hiçbir şey değişmez</li>
<li>Yayınların kontrolünü tamamlayarak Wikia'daki etkinliklerinizi Facebook üzerinden arkadaşlarınızla paylaşın</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '« Geri',
	'comboajaxlogin-connectmarketing-forward' => 'Başla »',
	'comboajaxlogin-connectdirections' => "Wikia kullanıcı adınızı ve parolayı buraya girin - sihirli bir şekilde arka planda Wikia ve Facebook hesaplarınıza bağlanılacak.

Bir kez yaptığınızda kolayca herhangi bir Facebook'a Bağlan düğmesini kullanarak oturum açabilirsiniz.",
	'comboajaxlogin-post-not-understood' => 'Bu formun düzenlenmesinde bir hata oldu.
Lütfen yeniden deneyin veya [[Special:Contact|bunu rapor edin]].',
	'comboajaxlogin-ajaxerror' => 'Wikia yanıt vermiyor. Lütfen ağ bağlantınızı denetleyin.',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'comboajaxlogin-createlog' => 'Керү/теркәлү',
	'comboajaxlogin-actionmsg' => 'Бу гамәлне башкару өчен, башта системага керергә яки теркәлергә кирәк.',
	'comboajaxlogin-actionmsg-protected' => 'Бу якланган битне төзәтер өчен, башта системага керергә яки хисап язмасы төзергә кирәк.',
	'comboajaxlogin-connectmarketing' => "<h1>Хисап язмаларыгызны берләштерегез</h1>
<ul>
<li>Үзегезнең кулланучы исемен, тарихыгызны, төзәтмәләрне саклагыз... Сезнең системага керү рәвешеннән кала берни үзгәрмәячәк.</li>
<li>Дусларыгызны Wikia эшчәнлеге белән Facebook'та таныштырыгыз.</li>
<li>Нәшер ителәчәк һәрнәрсә өстеннән тулы контроль</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Системага Facebook Connect ярдәмендә керү</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Wikia хисап язмасын Facebook ка тоташтырыгыз</h1>
<ul>
<li>Үзегезне кулланучы исемен, тарихны, төзәтмәләрне һ.б. саклап калыгыз. Керү рәвешеннән кала берни дә үзгәрмәячәк</li>
<li>Wikia эшчәнлеге белән Facebook'та дусларыгызны таныштырып барыгыз һәм нәшер ителгән һәрнәрсә өстеннән идарәне саклагыз.</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '&laquo; Артка',
	'comboajaxlogin-connectmarketing-forward' => 'Эшне башлау &raquo;',
	'comboajaxlogin-ajaxerror' => 'Викия җавап бирми. Зинһар, пәрәвезгә керү мөмкинлеген тикшерегез.',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Ua2004
 * @author Тест
 */
$messages['uk'] = array(
	'comboajaxlogin-desc' => 'Динамічне вікно, яке дозволяє користувачам увійти, нагадати пароль та зареєструватись',
	'comboajaxlogin-createlog' => 'Увійти або створити обліковий запис',
	'comboajaxlogin-actionmsg' => 'Для виконання цієї дії вам необхідно спочатку увійти в систему або створити обліковий запис',
	'comboajaxlogin-actionmsg-protected' => 'Для виконання цієї дії вам необхідно спочатку увійти в систему або створити обліковий запис',
	'comboajaxlogin-connectmarketing' => "<h1>Підключіть свої облікові записи</h1>
<ul>
<li>Збережіть ваші поточні ім'я користувача, історію, редагування... Нічого не зміниться, крім способу вашого входу у систему</li>
<li>Діліться своєю діяльністю на Wikia зі своїми друзями на Facebook</li>
<li>Повний контроль над усім, що публікується</li>
</ul>",
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>Увійти у систему через Facebook</h1>',
	'comboajaxlogin-connectmarketing-oasis' => "<h1>Підключіть свій обліковий запис Wikia до Facebook</h1>
<ul>
<li>Збережіть ваші поточні ім'я користувача, історію, редагування... Нічого не зміниться, крім способу вашого входу у систему</li>
<li>Діліться своєю діяльністю з друзями на Facebook, маючи повний контроль над усіма публікаціями</li>
</ul>",
	'comboajaxlogin-connectmarketing-back' => '&laquo; Назад',
	'comboajaxlogin-connectmarketing-forward' => 'Початок роботи »',
	'comboajaxlogin-connectdirections' => "Введіть свої ім'я користувача та пароль у Wikia і ми чарівним чином з'єднаємо ваші облікові записи в Wikia і Facebook.

Після завершення ви зможете легко представлятися системі за допомогою будь-який з кнопок Facebook Connect.",
	'comboajaxlogin-post-not-understood' => 'Сталася помилка при побудові цієї форми.
Будь ласка, спробуйте ще раз або [[Special:Contact| повідомте про це]].',
	'comboajaxlogin-readonlytext' => '<h2>Вибачте!</h2>
<p>Ви не можете зараз створити обліковий запис. Ми швидко відновимо свою роботу. Ось що відбувається:<br /><em>$1</em></p>
<p>Подробиці можна подивитися у <a href="http://twitter.com/wikia">Twitter</a> або <a href="http://facebook.com/wikia">Facebook</a>.
<br />
(Якщо у вас вже є обліковий запис, то ви можете <a href="#">увійти</a> як звичайно, але ви не зможете редагувати.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia не відповідає. Будь ласка, Перевірте підключення до мережі.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = array(
	'comboajaxlogin-desc' => 'Hộp này cho phép người dùng đăng nhập, nhắc nhở mật khẩu và đăng ký người dùng',
	'comboajaxlogin-createlog' => 'Đăng nhập hay mở tài khoản mới',
	'comboajaxlogin-actionmsg' => 'Để thực hiện thao tác này trước tiên bạn cần phải đăng nhập hoặc tạo tài khoản',
	'comboajaxlogin-actionmsg-protected' => 'Để thực hiện thao tác này trước tiên bạn cần phải đăng nhập hoặc tạo tài khoản',
	'comboajaxlogin-connectmarketing' => '<h1>Kết nối tài khoản của bạn với Facebook</h1>
<ul>
<li>Giữ tên người dùng hiện tại, lịch sử sửa đổi... không có gì thay đổi ngoại trừ cách bạn đăng nhập như thế nào </li>
<li>Hoạt động của bạn trên Wikia chia sẻ với bạn bè trên Facebook</li>
<li>Kiểm soát hoàn toàn của những gì được công bố</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => 'Đăng nhập cùng với Facebook',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>Kết nối tài khoản của bạn với Facebook</h1>
<ul>
<li>Giữ tên người dùng hiện tại, lịch sử sửa đổi... không có gì thay đổi ngoại trừ cách bạn đăng nhập như thế nào</li>
<li>Hoạt động của bạn trên Wikia chia sẻ với bạn bè trên Facebook</li>
<li>Kiểm soát hoàn toàn của những gì được công bố</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '« Trở về',
	'comboajaxlogin-connectmarketing-forward' => 'Bắt đầu »',
	'comboajaxlogin-connectdirections' => 'Hãy nhập tên người dùng và mật khẩu vào đây. Các tài khoản Wikia và Facebook của bạn sẽ được nối với nhau ở hậu trường.

Sau đó, bạn có thể đặng nhập dễ dàng dùng bất cứ nút Facebook Connect nào.',
	'comboajaxlogin-post-not-understood' => 'Có lỗi khi xây dựng biểu mẫu này. Xin vui lòng thử lần nữa hay [[Special:Contact|báo cáo lỗi này]].',
	'comboajaxlogin-readonlytext' => '<h2>Chân thành xin lỗi!</h2>
<p>Bạn không thể tạo một tài khoản hiện nay - chúng tôi cần phải hoạt động và chạy lại một thời gian rất ngắn. Đây là những gì đang xảy ra:<br /><em>$1</em></p>
<p>Vui lòng kiểm tra <a href="http://twitter.com/wikia">Twitter</a> hay <a href="http://facebook.com/wikia">Facebook</a> để biết thêm thông tin.
<br />
(Nếu bạn có tài khoản, bạn có thể <a href="#">đăng nhập</a> như bình thường, nhưng có thể bạn không thể chỉnh sửa trong một thời gian ngắn.)</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia chưa trả lời. Xin vui lòng kiểm tra lại kết nối mạng của bạn.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hzy980512
 * @author Sam Wang
 * @author Wilsonmess
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'comboajaxlogin-desc' => '允许用户登录，提醒密码和注册用户的动态框',
	'comboajaxlogin-createlog' => '登录或创建新账号',
	'comboajaxlogin-actionmsg' => '若要执行此操作，您必须先登录或创建一个新帐号',
	'comboajaxlogin-actionmsg-protected' => '若执行此操作，您必须登录或创建一个新账户。',
	'comboajaxlogin-connectmarketing' => '<h1>连接您的帐户</h1>
<ul>
<li>保留您当前的用户名、历史、编辑记录，一切都不会变化，除了登录方式</li>
<li>在Facebook上与您的朋友分享您在Wikia上的活动</li>
<li>您可完全控制将要发布的内容</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>用Facebook Connect登入</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>连接您的Wikia到Facebook</h1>
<ul>
<li>保存除您登入记录外的用户名、历史记录、编辑等信息</li>
<li>和Facebook上的朋友分享您的活动，并且完全控制发布的内容</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '$laquo; 返回',
	'comboajaxlogin-connectmarketing-forward' => '开始 »',
	'comboajaxlogin-connectdirections' => '在此输入您的Wikia用户名和密码，我们将在后台把您的Wikia账户和Facebook帐户设置关联。 
设置完成后，您可以轻松使用任何Facebook关联按钮进行登录。',
	'comboajaxlogin-post-not-understood' => '构造此窗体时发生错误。
请重试或[[Special:Contact|报告此问题]]。',
	'comboajaxlogin-readonlytext' => '<h2>抱歉！</h2>
<p>您现在不能创建账户——我们将尽快上线并重新运行。在这里查看问题原因：<br /><em>$1</em></p>
<p>请查看<a href="http://twitter.com/wikia">Twitter</a> 或 <a href="http://facebook.com/wikia">Facebook</a> 了解更多信息。
<br />
（如果您已拥有一个账户，则可以正常<a href="#">登陆</a>，但不能做出任何编辑。）</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia没有响应。请检查您的网络连接。',
);

/** Chinese (Hong Kong) (中文（香港）‎)
 * @author Tcshek
 */
$messages['zh-hk'] = array(
	'comboajaxlogin-createlog' => '登入／創建帳戶',
	'comboajaxlogin-actionmsg' => '如要執行此動作，你需要先登入或建立帳戶',
	'comboajaxlogin-actionmsg-protected' => '如要執行此動作，你需要先登入或創建帳戶。',
	'comboajaxlogin-connectmarketing' => '<h1>連結你的帳戶</h1>
<ul>
<li>登入之後保留你現有的用戶名稱、編輯歷史，一切都不會改變。</li>
<li>在facebook和朋友分享你在Wikia的編輯記錄。</li>
<li>完全控制你想發佈的內容。</li>
</ul>',
	'comboajaxlogin-log-in-with-facebook-oasis' => '<h1>以facebook帳戶登入</h1>',
	'comboajaxlogin-connectmarketing-oasis' => '<h1>連結你的facebook帳戶</h1>
<ul>
<li>登入之後保留你現有的用戶名稱、編輯歷史，一切都不會改變。</li>
<li>在facebook和朋友分享你在Wikia的編輯記錄。</li>
<li>完全控制你想發佈的內容。</li>
</ul>',
	'comboajaxlogin-connectmarketing-back' => '« 返回',
	'comboajaxlogin-connectmarketing-forward' => '開始使用 »',
	'comboajaxlogin-connectdirections' => '請在此輸入你的Wikia用戶名稱及密碼──我們會在背後奇蹟般地把你的Wikia帳戶和你的facebook帳戶連結。

在完成之後，你便能輕易使用你的facebook帳戶登入Wikia。',
	'comboajaxlogin-post-not-understood' => '建立表單的方式導致錯誤發生。

請重試或[[Special:Contact|向我們匯報]]。',
	'comboajaxlogin-readonlytext' => '<h2>抱歉！</h2>
<p>閣下目前不能建立帳戶──我們將會在短期內回復正常。請參考以下連結，看看發生了甚麼事：<br /><em>$1</em></p>
<p>請查看Wikia的<a href="http://twitter.com/wikia">Twitter</a>或<a href="http://facebook.com/wikia">facebook</a>以獲取更多有關事件的詳情。
<br />
（如果你已經擁有帳戶，你可以如常<a href="#">登入</a>，但你將不能進行任何編輯動作。）</p>',
	'comboajaxlogin-ajaxerror' => 'Wikia沒有回應，請檢查你的網路連線。',
);
