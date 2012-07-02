<?php
/**
 * Internationalisation file for extension CommentSpammer
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/* English
 * @author Nick Jenkins
 */
$messages['en'] = array(
	'commentspammer-save-blocked' => 'Your IP address is a suspected comment spammer, so the page has not been saved.
[[Special:UserLogin|Log in or create an account]] to avoid this.',
	'commentspammer-desc'         => 'Rejects edits from suspected comment spammers on a DNS blacklist',
	'commentspammer-log-msg'      => 'edit from [[Special:Contributions/$1|$1]] to [[:$2]].',
	'commentspammer-log-msg-info' => 'Last spammed $1 {{PLURAL:$1|day|days}} ago, threat level is $2, and offence code is $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 View details], or [[Special:Blockip/$4|block]].',
	'cspammerlogpagetext'         => 'Record of edits that have been allowed or denied based on whether the source was a known comment spammer.',
	'cspammer-log-page'           => 'Comment spammer log',
);

/** Message documentation (Message documentation)
 * @author Purodha
 */
$messages['qqq'] = array(
	'commentspammer-desc' => 'Shown in [[Special:Version]]',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'commentspammer-save-blocked' => 'عنوان الأيبي الخاص بك هو معلق سبام مشتبه، لذا لم يتم حفظ الصفحة.
[[Special:UserLogin|ادخل أو سجل حسابا]] لتجنب هذا.',
	'commentspammer-desc' => 'يرفض التعديلات من معلقي السبام المشتبه فيهم على قائمة DNS سوداء',
	'commentspammer-log-msg' => 'تعديل من [[Special:Contributions/$1|$1]] ل[[:$2]].',
	'commentspammer-log-msg-info' => 'آخر سبام كان قبل| {{PLURAL:$1|أقل من يوم|يوم واحد|يومين|$1 أيام|$1 يومًا|$1 يوم}}، مستوى التهديد $2، وكود الإساءة $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 اعرض التفاصيل] أو [[Special:Blockip/$4|امنع]].',
	'cspammerlogpagetext' => 'سجل التعديلات التي تم السماح بها أو رفضها بناء على ما إذا كان المصدر معلق سبام معروف.',
	'cspammer-log-page' => 'سجل تعليق السبام',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'commentspammer-save-blocked' => 'عنوان الأيبى الخاص بك هو معلق سبام مشتبه، لذا لم يتم حفظ الصفحة. [[Special:UserLogin|ادخل أو سجل حسابا]] لتجنب هذا.',
	'commentspammer-desc' => 'يرفض التعديلات من معلقى السبام المشتبه فيهم على قائمة DNS سوداء',
	'commentspammer-log-msg' => 'تعديل من [[Special:Contributions/$1|$1]] ل[[:$2]].',
	'commentspammer-log-msg-info' => 'آخر سبام منذ $1 {{PLURAL:$1|يوم|يوم}} ، مستوى التهديد هو $2، وكود الإساءة هو $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 عرض التفاصيل]، أو [[Special:Blockip/$4|منع]].',
	'cspammerlogpagetext' => 'سجل التعديلات التى تم السماح بها أو رفضها بناء على ما إذا كان المصدر معلق سبام معروف.',
	'cspammer-log-page' => 'سجل تعليق السبام',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'commentspammer-save-blocked' => 'Ваш IP-адрас падазраецца ў разьмяшчэньні спам-камэнтараў, таму старонка ня будзе захаваная.
[[Special:UserLogin|Увайдзіце ў сыстэму]], каб пазьбегнуць гэтага.',
	'commentspammer-desc' => 'Адхіляе рэдагаваньні ад падазроных спамэраў у камэнтатарах згодна чорнага сьпісу DNS',
	'commentspammer-log-msg' => 'рэдагаваньне [[Special:Contributions/$1|$1]] у [[:$2]].',
	'commentspammer-log-msg-info' => 'Апошні выпадак спаму $1 {{PLURAL:$1|дзень|дні|дзён}} таму, узровень пагрозы — $2, код парушэньня — $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Глядзіце падрабязнасьці] альбо [[Special:Blockip/$4|заблякуйце]].',
	'cspammerlogpagetext' => 'Сьпіс рэдагаваньняў, якія былі дазволеныя альбо адхіленыя на аснове таго, ці была крыніца вядома як спамэр у камэнтатарах.',
	'cspammer-log-page' => 'Журнал спамэраў у камэнтарах',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'commentspammer-log-msg' => 'редакция от [[Special:Contributions/$1|$1]] в [[:$2]].',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'cspammer-log-page' => 'মন্তব্য স্প্যামার লগ',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'commentspammer-save-blocked' => "Renablet eo ho chomlec'h IP evel hini unan a gas strob, se zo kaoz n'eo ket bet enrollet ar bajenn.
Evit renkañ an afer [[Special:UserLogin|en em lugit pe krouit ur gont]].",
	'commentspammer-desc' => 'Disteuler a ra ar kemmoù an implijerien zo disfiz warno da vezañ kaserien strob war ul listenn zu a zDNS',
	'commentspammer-log-msg' => 'degasadenn a-berzh [[Special:Contributions/$1|$1]] da [[:$2]].',
	'commentspammer-log-msg-info' => "$1 {{PLURAL:$1|deiz}} zo eo bet kaset ar strob diwezhañ, $2 eo al live diwall, ha $3 eo c'hod tagañ.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Gwelet ar munudoù], pe [[Special:Blockip/$4|ar stankadenn]].",
	'cspammerlogpagetext' => "Marilh ar c'hemmoù degemeret pe distaolet diouzh ma teuent a-berzh ur c'haser strob anavezet.",
	'cspammer-log-page' => 'Marilh ar gaserienn strob',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'commentspammer-save-blocked' => 'Vaša IP adresa je sumnjiva jer je koriste spameri komentara, tako da ova stranica nije sačuvana.
Da bi ovo izbjegli [[Special:UserLogin|prijavite se ili napravite račun]].',
	'commentspammer-desc' => 'Odbacuje izmjene od sumnjivih spamera sa komentarima sa DNS nepoželjnog spiska',
	'commentspammer-log-msg' => 'izmjena od [[Special:Contributions/$1|$1]] za [[:$2]].',
	'commentspammer-log-msg-info' => 'Zadnji put spamiran $1 prije {{PLURAL:$1|dan|dana}}, nivo opasnosti je $2 a kod napadnosti je $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Vidi detalje] ili [[Special:Blockip/$4|blokiraj]].',
	'cspammerlogpagetext' => 'Prati izmjene koje su dopuštene ili onemogućene na osnovu izvora koji je označen kao spamer komentara.',
	'cspammer-log-page' => 'Zapisnik spamerskih komentara',
);

/** Catalan (Català)
 * @author Paucabot
 * @author Ssola
 */
$messages['ca'] = array(
	'commentspammer-log-msg' => 'modificació de [[Special:Contributions/$1|$1]] a [[:$2]].',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'commentspammer-save-blocked' => 'Existuje podezření, že vaše IP adresa je adresa podezřelého spammera obsahu, proto stránka nebyla uložena.
Vyhněte se tomu tím, že [[Special:UserLogin|se přihlásíte nebo si vytvoříte účet]].',
	'commentspammer-desc' => 'Odmítá úpravy od podezřelých spamerů z černé listiny DNS',
	'commentspammer-log-msg' => 'úprava [[:$2]] od [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Naposledy spamováno {{PLURAL:$1|včera|před $2 dny}}, úroveň ohrožení je $2 a kód prohřešku je $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Zobrazit podrobnosti] nebo [[Special:Blockip/$4|zablokovat]].',
	'cspammerlogpagetext' => 'Záznam úprav, které byly povoleny nebo zamítnuty na základě toho, že zdroj byl známý spammer obsahu.',
	'cspammer-log-page' => 'Záznam spamerů obsahu',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Umherirrender
 */
$messages['de'] = array(
	'commentspammer-save-blocked' => 'Deine IP-Adresse stammt mutmaßlich von einem Kommentar-Spammer.
Die Seite wurde nicht gespeichert.
[[Special:UserLogin|Melde dich an oder erstelle ein Benutzerkonto]], um diese Warnung zu unterbinden.',
	'commentspammer-desc' => 'Unterbindet Bearbeitungen durch vermutliche Kommentarspammer auf einer DNS-Blacklist',
	'commentspammer-log-msg' => 'Bearbeitung von [[Special:Contributions/$1|$1]] für [[:$2]].',
	'commentspammer-log-msg-info' => 'Letztes Spamming vor $1 {{PLURAL:$1|Tag|Tagen}}, der „threat level“ ist $2 und der „offence code“ ist $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Details ansehen] oder [[Special:Blockip/$4|sperren]].',
	'cspammerlogpagetext' => 'Liste der Bearbeitungen, die genehmigt oder abgelehnt wurden auf der Basis, ob die Quelle ein bekannter Kommentar-Spammer war.',
	'cspammer-log-page' => 'Kommentar-Spammer Logbuch',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 */
$messages['de-formal'] = array(
	'commentspammer-save-blocked' => 'Ihre IP-Adresse stammt mutmaßlich von einem Kommentar-Spammer.
Die Seite wurde nicht gespeichert.
[[Special:UserLogin|Melden Sie sich an oder erstellen Sie ein Benutzerkonto]], um diese Warnung zu unterbinden.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'commentspammer-save-blocked' => 'Twója IP-adresa jo pódglědny spamowaŕ komentarow, togodla bok njejo se składował.
[[Special:UserLogin|Pśizjaw se abo załož konto]], aby se to wobinuł.',
	'commentspammer-desc' => 'Zajźujo změnam wót nejskerjejšych spamowarjow komentarow na cornej lisćinje DNS',
	'commentspammer-log-msg' => 'Změna wót [[Special:Contributions/$1|$1]] na [[:$2]].',
	'commentspammer-log-msg-info' => 'Slědne spamowanje pśed $1 {{PLURAL:$1|dnjom|dnjoma|dnjami|dnjami}}, wobgrozeński stopjeń jo $2 a napadowy kod jo $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Drobnostki se woglědaś] abo [[Special:Blockip/$4|blokěrowaś]].',
	'cspammerlogpagetext' => 'Lisćina změnow, kótarež su se dowólili abo wótpokazali, za tym lěc žrědło jo znaty spamowaŕ komentarow było.',
	'cspammer-log-page' => 'Protokol wó spamowarjach komentarow',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 */
$messages['el'] = array(
	'cspammer-log-page' => 'Ημερολόγιο δημιουργών σπαμ',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'commentspammer-save-blocked' => 'Via IP-adreso estas suspekta koment-spamisto, do la paĝo ne estis konservita.
[[Special:UserLogin|Ensaluti aŭ krei konton]] por eviti ĉi tiel.',
	'commentspammer-desc' => 'Malpermesas redaktojn de suspektaj koment-spamistoj en DNS-nigralisto',
	'commentspammer-log-msg' => 'redakto de [[Special:Contributions/$1|$1]] al [[:$2]].',
	'commentspammer-log-msg-info' => 'Laste spamis $1 antaŭ {{PLURAL:$1|tago|tagoj}}, minaca nivelo estas $2, kaj kulpa kodo estas $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Vidi detalojn], aŭ [[Special:Blockip/$4|forbari]].',
	'cspammerlogpagetext' => 'Registro de redaktojn kiuj estis permesitaj aŭ malpermesitaj laŭ ĉu la IP-fonto estis konata koment-spamisto.',
	'cspammer-log-page' => 'Protokolo de komentaj spamistoj',
);

/** Spanish (Español)
 * @author Baiji
 * @author Crazymadlover
 */
$messages['es'] = array(
	'commentspammer-save-blocked' => 'Tu dirección IP es un comentador spammer sospechoso. Por tanto la página no ha sido grabada.
[[Special:UserLogin|Inicie sesión o cree una cuenta]] para evitar esto.',
	'commentspammer-desc' => 'Rechaza ediciones de comentadores spammer sospechosos en una lista negra DNS',
	'commentspammer-log-msg' => 'edición de [[Special:Contributions/$1|$1]] en [[:$2]].',
	'commentspammer-log-msg-info' => 'Último spam enviado hace $1 {{PLURAL:$1|día|días}}, nivel de riesgo es $2, y código de ofensa es $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Ver detalles], o [[Special:Blockip/$4|bloquear]].',
	'cspammerlogpagetext' => 'Registro de ediciones que han sido permitidas o denegadas basados en si la fuente fue un conocido comentador spammer.',
	'cspammer-log-page' => 'Registro de comentadores spammer',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'commentspammer-save-blocked' => 'Zure IP helbidea spam egile batena den susmoa hartu diogu eta ondorioz, orrialdean egindako aldaketak ez dira gorde. [[Special:UserLogin|Saioa hasi edo kontu bat sortu]] hau ekiditeko.',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Nike
 * @author Vililikku
 */
$messages['fi'] = array(
	'commentspammer-save-blocked' => 'IP-osoitteesi epäillään olevan kommenttispämmeri, joten sivua ei ole tallennettu.
[[Special:UserLogin|Kirjaudu sisään tai luo käyttäjätunnus]], jos haluat välttää tämän.',
	'commentspammer-desc' => 'Hylkää muokkaukset epäillyltä DNS-mustalistan kommenttiroskapostittajilta.',
	'commentspammer-log-msg' => 'Muokkaaja: [[Special:Contributions/$1|$1]], kohde: [[:$2]].',
	'commentspammer-log-msg-info' => 'Lähetti roskapostia viimeksi $1 {{PLURAL:$1|päivä|päivää}} sitten, uhkataso on $2, ja rikkomuskoodi on $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Katso lisätietoja] tai [[Special:Blockip/$4|estä]].',
	'cspammerlogpagetext' => 'Tietue muokkauksista, jotka on sallittu tai evätty sen perusteella onko lähde tunnettu kommenttiroskapostittaja.',
	'cspammer-log-page' => 'Kommenttiroskapostittajaloki',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'commentspammer-save-blocked' => 'Votre adresse IP est celle d’une personne suspectée de créer du pourriel : la page n’a donc pas été sauvegardée. Veuillez [[Special:UserLogin|vous identifier ou créer un compte]] pour contourner cette interdiction.',
	'commentspammer-desc' => 'Rejette les modifications par des auteurs soupçonnés de pollupostage à partir d’une liste noire DNS',
	'commentspammer-log-msg' => 'Modifications de [[Special:Contributions/$1|$1]] à [[:$2]].',
	'commentspammer-log-msg-info' => 'Le dernier pourriel remonte à $1 jour{{PLURAL:$1||s}}, le niveau d’alerte est à $2 et le code d’attaque est $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Voir les détails] ou [[Special:Blockip/$4|le bloquage]].',
	'cspammerlogpagetext' => 'Journal des modifications acceptées ou rejetées selon que la source était un auteur connu de pourriels.',
	'cspammer-log-page' => 'Journal des auteurs de pourriels',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'commentspammer-save-blocked' => 'Voutra adrèce IP est cela d’una pèrsona soupçonâ de fâre de spame, donc la pâge at pas étâ sôvâ.
Vos volyéd [[Special:UserLogin|branchiér ou ben fâre un compto]] por contornar ceta dèfensa.',
	'commentspammer-log-msg' => 'Changements de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Lo dèrriér spame remonte a {{PLURAL:$1|$1 jorn|$1 jorns}}, lo nivô d’alèrta est a $2 et lo code d’ataca est $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Vêre los dètalys] ou ben [[Special:Blockip/$4|blocar]].',
	'cspammerlogpagetext' => 'Jornal des changements accèptâs ou ben refusâs d’aprés que la sôrsa ére un ôtor de spame cognu.',
	'cspammer-log-page' => 'Jornal du crèator de spame',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'commentspammer-save-blocked' => 'O seu enderezo IP é sospeitoso de facer comentarios con spam, de maneira que a páxina non foi gardada.
[[Special:UserLogin|Rexístrese ou cree unha conta]] para evitalo.',
	'commentspammer-desc' => 'Rexeita as edicións dos comentarios dos sospeitosos de ser spammers nunha lista negra (blacklist) DNS',
	'commentspammer-log-msg' => 'editar de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Último correo spam $1 {{PLURAL:$1|día|días}} atrás, nivel de ameaza é de $2, e código de delito é de $3. 
[http://www.projecthoneypot.org/search_ip.php?ip=$4 ver detalles], ou [[Special:Blockip/$4|bloqueo]].',
	'cspammerlogpagetext' => 'Historial das edicións que se permitiron ou denegaron sobre a base de si a fonte foi un coñecido comentario spam.',
	'cspammer-log-page' => 'Rexistro dos comentarios Spam',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'commentspammer-save-blocked' => 'Dyy IP-Adräss stammt wahrschyns vun eme Kommentar-Spammer.
D Syten isch nit gspycheret wore.
[[Special:UserLogin|Mäld Diaa oder leg e Benutzerkonto aa]] go die Warnig z vermyyde.',
	'commentspammer-desc' => 'Verhinderet Bearbeitige dur vermueteti Kommentarspammer uf ere DNS-Blacklist',
	'commentspammer-log-msg' => 'Bearbeitig vu [[Special:Contributions/$1|$1]] fir [[:$2]].',
	'commentspammer-log-msg-info' => 'S letscht Spamming vor $1 {{PLURAL:$1|Tag|Täg}}, dr „threat level“ isch $2 un dr „offence code“ isch $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Detail aaluege] oder [[Special:Blockip/$4|sperre]].',
	'cspammerlogpagetext' => 'Lischt vu dr Bearbeitige, wu gnähmigt oder abglähnt wore sin uf dr Grundlag, eb d Quälle ne bekannte Kommentar-Spammer gsi isch.',
	'cspammer-log-page' => 'Kommentar-Spammer-Logbuech',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'commentspammer-save-blocked' => 'כתובת ה־IP שלכם נחשדת כספאמר, לכן העמוד לא נשמר.
באפשרותכם [[Special:UserLogin|להיכנס לחשבון או ליצור אחד]] כדי למנוע זאת.',
	'commentspammer-desc' => 'דחיית עריכות ממשתמשים החשודים כספאמרים באמצעות רשימה שחורה של DNS',
	'commentspammer-log-msg' => 'עריכה של [[Special:Contributions/$1|$1]] ל[[:$2]].',
	'commentspammer-log-msg-info' => 'נשלח זבל לפני {{PLURAL:$1|יום אחד|$1 ימים}}, רמת האיום היא $2, וקוד הפגיעה הוא $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 צפייה בפרטים]; [[Special:Blockip/$4|חסימה]].',
	'cspammerlogpagetext' => 'יומן העריכות שמתקבלות או נדחות בהתאם לזיהוי המקור כספאמר.',
	'cspammer-log-page' => 'יומן ספאמרים',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'commentspammer-desc' => 'डीएनएस ब्लॅकलिस्टपर होनेवाले संशयित स्पॅमर्सके बदलाव रद्द कर देता हैं',
	'commentspammer-log-msg' => '[[:$2]] पर किये हुए [[Special:Contributions/$1|$1]] के बदलाव।',
	'commentspammer-log-msg-info' => 'आखिरमें $1 {{PLURAL:$1|दिन पहले|दिनों पहले}} स्पॅम किया था, स्तर $2, और ऑफेन्स कोड $3 हैं। [http://www.projecthoneypot.org/search_ip.php?ip=$4 अधिक ज़ानकारी], या [[Special:Blockip/$4|ब्लॉक करें]]।',
	'cspammerlogpagetext' => 'यह सूची ऐसे बदलाव दर्शाती हैं जो स्रोतके टिप्पणी स्पॅमर स्थितीके अनुसार रोके या स्वीकार किये गये हैं।',
	'cspammer-log-page' => 'टिप्पणी स्पॅमर सूची',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'commentspammer-save-blocked' => 'Twoja IP-adresa je podhladny komentarny spamowar, tohodla strona njebu składowana. [[Special:UserLogin|Přizjew so abo wutwor konto]], zo by to wobešoł.',
	'commentspammer-desc' => 'Wotpokazuje změny wot podhladnych spamowarjow komentarow na čornej lisćinje DNS.',
	'commentspammer-log-msg' => 'změna wot [[Special:Contributions/$1|$1]] k [[:$2]]',
	'commentspammer-log-msg-info' => 'Posledni spam před $1 {{PLURAL:$1|dnjom|dnjomaj|dnjemi|dnjemi}}, stopjeń hroženja je $2 a nadpadowy kod je $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Hlej podrobnosće] abo [[Special:Blockip/$4|blokowanje]].',
	'cspammerlogpagetext' => 'Datowa sadźba změnow, kotrež buchu dowolene abo wotpokazane, po tym hač žórło je znaty spamowar abo nic.',
	'cspammer-log-page' => 'Protokol komentarnych spamowarjow',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'commentspammer-save-blocked' => 'Az IP-címed feltételezett tartalomspammer, ezért az oldal nem lett elmentve. [[Special:UserLogin|Jelentkezz be]] ennek kiküszöböléséhez.',
	'commentspammer-desc' => 'DNS feketelista alapján visszautasítja a spamgyanús szerkesztéseket.',
	'commentspammer-log-msg' => '[[Special:Contributions/$1|$1]] szerkesztése a(z) [[:$2]] lapon.',
	'commentspammer-log-msg-info' => 'Utoljára $1 napja spammelt, veszélyességi szintje $2, támadókódja $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Részletek megtekintése], vagy [[Special:Blockip/$4|blokkolás]].',
	'cspammerlogpagetext' => 'Azon szerkesztések listája, melyek engedélyezve vagy tiltva lettek attól függően, hogy a szerző ismert tartalomspammer volt-e.',
	'cspammer-log-page' => 'Tartalomspammer napló',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'commentspammer-save-blocked' => 'Tu adresse IP es un origine suspectate de commentos spam; ergo le pagina non ha essite publicate.
[[Special:UserLogin|Aperi un session o crea un conto]] pro evitar isto.',
	'commentspammer-desc' => 'Rejecta modificationes ab origines de spam de commentos suspectate per un lista nigre in DNS',
	'commentspammer-log-msg' => 'modification de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Ultime spam $1 {{PLURAL:$1|die|dies}} retro, nivello de menacia es $2, e codice de offensa es $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Vider detalios], o [[Special:Blockip/$4|blocar]].',
	'cspammerlogpagetext' => 'Registro de modificationes que ha essite permittite o refusate a base de si le origine esseva un cognoscite spammator de commentos.',
	'cspammer-log-page' => 'Registro de spammatores de commentos',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'commentspammer-save-blocked' => 'Alamat IP dicurigai sebagai alamat spammer, maka halaman ini tidak disimpan.
[[Special:UserLogin|Masuk log atau buat akun]] untuk menghindari hal ini.',
	'commentspammer-desc' => 'Menolak suntingan dari alamat yang dicurigasi sebagai spammer atau berada di daftar hitam DNS',
	'commentspammer-log-msg' => 'suntingan dari [[Special:Contributions/$1|$1]] ke [[:$2]].',
	'commentspammer-log-msg-info' => 'Terakhir dispam pada $1 {{PLURAL:$1|hari|hari}} yang lalu, tingkat ancaman adalah $2, dan kode serangan adalah $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Lihat rincian], atau [[Special:Blockip/$4|blok]].',
	'cspammerlogpagetext' => 'Catatan suntingan yang telah diperbolehkan atau ditolak berdasarkan sumber alamat mereka dicurigai sebagai alamat spammer atau bukan.',
	'cspammer-log-page' => 'Log spammer',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'commentspammer-save-blocked' => 'Il tuo IP è quello di un utente sospettato di creazione di spam, così la pagina non è stata salvata. [[Special:UserLogin|Entra o crea un nuovo accesso]] per evitare questo.',
	'commentspammer-desc' => 'Rifiuta le modifiche dagli utenti sospettati di creazione di spam su una blacklist DNS',
	'commentspammer-log-msg' => 'modifica di [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => "L'ultimo spam è stato effettuato $1 {{PLURAL:$1|giorno|giorni}} fa, il livello della minaccia è $2 e il codice di attacco è $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Visualizza i dettagli] oppure [[Special:Blockip/$4|blocca]].",
	'cspammerlogpagetext' => 'Registro delle modifiche che sono state permesse o negate a seconda che la fonte fosse uno spammer noto.',
	'cspammer-log-page' => 'Registro dello spam sui commenti',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'commentspammer-save-blocked' => 'あなたのIPアドレスはスパム投稿に用いられているとの疑いがあるため、ページは保存されませんでした。[[Special:UserLogin|ログインまたはアカウントの作成]]を行ってください。',
	'commentspammer-desc' => 'DNSブラックリストに記載されたコメントスパム投稿容疑IPアドレスからの編集を拒絶する',
	'commentspammer-log-msg' => '利用者 [[Special:Contributions/$1|$1]] による [[:$2]] の編集',
	'commentspammer-log-msg-info' => '最後のスパム行為は$1{{PLURAL:$1|日前}}に行われ、脅威レベルは$2、違反コードは$3です。 [http://www.projecthoneypot.org/search_ip.php?ip=$4 詳細を確認する]か[[Special:Blockip/$4|ブロック]]してください。',
	'cspammerlogpagetext' => 'コメントスパマーとしての登録の有無によって判定された投稿の許可/拒否状況の記録',
	'cspammer-log-page' => 'スパム投稿記録',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'commentspammer-save-blocked' => 'Alamat IP panjenengan iku dicurigani dienggo ngirim spam, dadi kaca iki ora disimpen.
Kanggo menggak iki, [[Special:UserLogin|mangga log mlebu utawa nggawé rékening (akun)]].',
	'commentspammer-log-msg' => 'suntingan saka [[Special:Contributions/$1|$1]] menyang [[:$2]].',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'commentspammer-save-blocked' => 'Ding IP-Address es schwer verdäschtesch, dat se enem Kommenta-SPAMmer jehööt.
Dröm ham mer Ding Änderung nit faßjehallde.
Don [[Special:UserLogin|enlogge udder Desch aanmellde]] domet dat nit widder passeet.',
	'commentspammer-desc' => 'Hält Änderunge fun bekannte Kommenta-SPAMmere op, opjrond fun ene „schwaze Leß“ met DNS-Date.',
	'commentspammer-log-msg' => 'Änderunge fun [[Special:Contributions/$1|$1]] aan dä Sigg „[[:$2]]“.',
	'commentspammer-log-msg-info' => 'Zoletz jeSPAMt för {{PLURAL:$1|einem Dach|$1 Dare|nit ens einem Daach}}, de Drohstuuf es „$2“, un dä Stüürungs-Kood es „$3“. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Einzeheite aanloore] udder [[Special:Blockip/$4|Metmaacher sperre]].',
	'cspammerlogpagetext' => 'Leß met de Änderunge, di zojelohße udder verbodde woode sin, weil dä se jemaat hät, ene bekannt Kommenta-SPAMmer wohr.',
	'cspammer-log-page' => 'Logbooch met Kommenta-SPAMmere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'commentspammer-save-blocked' => "Är IP-Adress gëtt als Spammer verdächtegt, dofir gouf d'Säit net gespäichert.
[[Special:UserLogin|Loggt Iech an oder maacht e Benotzerkont op]] fir dëst ze verhënneren.",
	'commentspammer-desc' => "Refuséiert Ännerunge vu verdächtege Spammeren vun enger ''Schwaarzer DNS-Lësch''",
	'commentspammer-log-msg' => 'Ännerunge vun [[Special:Contributions/$1|$1]] fir [[:$2]].',
	'commentspammer-log-msg-info' => 'De leschte Spam war viru(n) $1 {{PLURAL:$1|Dag|Deeg}}, den Niveau vum Alarm ass $2 an den "offence code" ass $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Fir d\'Detailer ze kucken], oder [[Special:Blockip/$4|fir ze spären]].',
	'cspammerlogpagetext' => "Lëscht vun den Ännerungen déi ugeholl oder refuséiert goufen je nodeem ob d'Quell als Spammer bekannt war oder net.",
	'cspammer-log-page' => 'Bemierkung Spammer Logbuch',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'commentspammer-save-blocked' => "An'olona mety mpanao spam ny adiresy IP anao : tsy notehirizina ilay pejy.
[[Special:UserLogin|Midira na manokafa kaonty]] mba manodina io fandraràna io.",
	'commentspammer-log-msg' => "Fanovana nataon'i [[Special:Contributions/$1|$1]] tamin'ny [[:$2]].",
	'cspammerlogpagetext' => "Tatitra momban'ny fanovana nekena na nolavina, mifototra amin'ny mpikambana mpanao spam fantatra.",
	'cspammer-log-page' => 'Tatitry ny mpanao spam',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'commentspammer-save-blocked' => 'Вашата IP-адреса е осомничена како спамер на коментари, и затоа оваа страница не беше зачувана.
[[Special:UserLogin|Најавете се или создајте сметка]] за да го избегнете ова.',
	'commentspammer-desc' => 'Одбива уредувања од осомничени спамери на коментари кои се на DNS-црниот список',
	'commentspammer-log-msg' => 'уредување од [[Special:Contributions/$1|$1]] на [[:$2]].',
	'commentspammer-log-msg-info' => 'Последен пат спамирано пред $1 {{PLURAL:$1|ден|дена}}, нивото на загрозеност е $2, а кодот на прекршокот е $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Погледајте детали], или [[Special:Blockip/$4|блокирајте]].',
	'cspammerlogpagetext' => 'Евиденција на уредувања кои биле дозволени или одбиени зависно од тоа дали нивниот избвор бил познат како спамер на коментари.',
	'cspammer-log-page' => 'Дневник на спамери на коментари',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'commentspammer-log-msg' => '[[Special:Contributions/$1|$1]]ൽ നിന്ന് [[:$2]]ൽ ഉള്ള തിരുത്തലുകൾ.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'commentspammer-save-blocked' => 'तुमचा आंतरजाल अंकपत्ता (IP) स्पॅमर असल्याचा संशय आहे, त्यामुळे पान जतन करण्यात आलेले नाही.
हे टाळण्यासाठी [[Special:UserLogin|प्रवेश करा किंवा नवीन सदस्य नोंदणी करा]].',
	'commentspammer-desc' => 'डीएनएस ब्लॅकलिस्टवर असणार्‍या संशयित स्पॅमर्सची संपादने रद्द करते',
	'commentspammer-log-msg' => '[[:$2]] वर केलेली [[Special:Contributions/$1|$1]] ची संपादने',
	'commentspammer-log-msg-info' => 'शेवटी $1 {{PLURAL:$1|दिवसापूर्वी|दिवसांपूर्वी}} स्पॅम केले, पातळी $2, व ऑफेन्स कोड $3 आहे. [http://www.projecthoneypot.org/search_ip.php?ip=$4 अधिक माहिती], किंवा [[Special:Blockip/$4|ब्लॉक करा]].',
	'cspammerlogpagetext' => 'ही सूची अश्या संपादनांची यादी आहे जी स्रोताच्या स्पॅमर स्थितीनुसार अडवली किंवा स्वीकारली गेलेली आहेत.',
	'cspammer-log-page' => 'स्पॅमर सूची शेरा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'commentspammer-save-blocked' => 'Alamat IP anda disyarki merupakan spammer komen, jadi laman ini tidak disimpan.
Sila [[Special:UserLogin|log masuk atau buka akaun]] untuk mengelakkan perkara begini.',
	'commentspammer-desc' => 'Menolak suntingan daripada spammer komen yang disyaki dalam senarai hitam DNS',
	'commentspammer-log-msg' => 'suntingan daripada [[Special:Contributions/$1|$1]] kepada [[:$2]].',
	'commentspammer-log-msg-info' => 'Kali terakhir dispam $1 hari lalu, tahap ancaman adalah $2, dan kanun kesalahan ialah $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Lihat butiran], atau [[Special:Blockip/$4|sekat]] sahaja.',
	'cspammerlogpagetext' => 'Rekod suntingan yang dibenarkan atau ditolak berasaskan sama ada puncanya merupakan spammer komen yang dikenali.',
	'cspammer-log-page' => 'Log spammer komen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'commentspammer-save-blocked' => 'IP-adressa di mistenkes for å være en kommentarforsøpler, så siden kan ikke lagres. [[Special:UserLogin|Logg inn eller opprett en konto]] for å unngå dette.',
	'commentspammer-desc' => 'Avviser endringer fra mistenkte spammere på en DNS-svarteliste.',
	'commentspammer-log-msg' => 'redigering på [[:$2]] av [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Sist forsøplet for $1 {{PLURAL:$1|dag|dager}} siden, trusselnivået er $2, og fornærmelseskoden er $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Se detaljer] eller [[Special:Blockip/$4|blokkert]].',
	'cspammerlogpagetext' => 'Register over redigeringer som har blitt godtatt eller nektet basert på hvorvidt kilden var en kjent kommentarforsøpler.',
	'cspammer-log-page' => 'Kommentarforsøplerlogg',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'commentspammer-save-blocked' => 'Uw IP-adres wordt verdacht van spammen - opslaan is geweigerd.
[[Special:UserLogin|Maak een gebruiker aan of meld u aan]] om dit te voorkomen.',
	'commentspammer-desc' => 'Voorkomt bewerkingen van spammers via een DNS-blacklist',
	'commentspammer-log-msg' => 'bewerking van [[Special:Contributions/$1|$1]] aan [[:$2]].',
	'commentspammer-log-msg-info' => 'Spamde voor het laatst $1 {{PLURAL:$1|dag|dagen}} geleden. Dreigingsniveau is $2 en de overtredingscode is $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Details bekijken] of [[Special:Blockip/$4|blokkeren]].',
	'cspammerlogpagetext' => 'Logboek met bewerkingen die toegestaan of geweigerd zijn omdat de bron een bekende spammer was.',
	'cspammer-log-page' => 'Spamlogboek',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'commentspammer-save-blocked' => 'Di IP-adressa er mistenkt for å vera ein kommentarspammar, so sida kan ikkje verta lagra.
[[Special:UserLogin|Logg inn eller opprett ein konto]] for å unngå dette.',
	'commentspammer-desc' => 'Avviser endringar frå mistenkte spammarar på ei DNS-svartelista.',
	'commentspammer-log-msg' => 'endring på [[:$2]] av [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Sist spamma for {{PLURAL:$1|éin dag|$1 dagar}} sia, trusselnivået er $2, og krenkjekoden $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Sjå detaljar] eller [[Special:Blockip/$4|blokker]].',
	'cspammerlogpagetext' => 'Register over endringar som har blitt godtekne eller nekta bastert på kor vidt kjelda var ein kjent kommentarspammar.',
	'cspammer-log-page' => 'Kommentarspammarlogg',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'commentspammer-save-blocked' => "Vòstra adreça IP es la d'una persona sospechada de crear de spams, la pagina es pas estada salvada. [[Special:UserLogin|Conectatz-vos o creatz un compte]] per contornar aqueste interdich.",
	'commentspammer-desc' => 'Regèta las modificacions suspectadas de spams a partir d’una lista negra figurant dins lo projècte HoneyPot DNS',
	'commentspammer-log-msg' => 'Modificacions de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => "Lo darrièr spam remonta a {{PLURAL:$1|$1 jorn|$1 jorns}}, lo nivèl d'alèrta es a $2 e lo còde d'atac es $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Vejatz los detalhs] o [[Special:Blockip/$4|blocatz]].",
	'cspammerlogpagetext' => 'Jornal de las modificacions acceptadas o rejetadas segon que la font èra un creator de spams conegut.',
	'cspammer-log-page' => 'Jornal del creator de spams',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'commentspammer-save-blocked' => 'Twój adres IP jest podejrzewany o spamowanie – zapisywanie stron jest zablokowane.
[[Special:UserLogin|Zaloguj się lub utwórz konto]], aby uniknąć tego komunikatu.',
	'commentspammer-desc' => 'Odrzuca podejrzane edycje komentarzy robione przez spamerów na podstawie listy zabronionych nazw DNS',
	'commentspammer-log-msg' => 'edycja [[Special:Contributions/$1|$1]] w [[:$2]].',
	'commentspammer-log-msg-info' => 'Ostatni spam $1 {{PLURAL:$1|dzień|dni}} temu, poziom zagrożenia $2, kod naruszenia $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Zobacz szczegóły] lub [[Special:Blockip/$4|zablokuj]].',
	'cspammerlogpagetext' => 'Zapis edycji, które zostały dozwolone lub zakazane na podstawie tego, czy dokonała ich osoba znana jako spammer.',
	'cspammer-log-page' => 'Rejestr spammerów',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'commentspammer-save-blocked' => "Toa adrëssa IP a l'é un sospet spammer ëd coment, parèj la pàgina a l'é pa stàita salvà.
[[Special:UserLogin|Intra o crea un cont]] për evité sòn-sì.",
	'commentspammer-desc' => "Arfuda le modìfiche dai sospet spammer ëd coment ch'a son an dzora ëd na lista nèira dël DNS",
	'commentspammer-log-msg' => 'modìfica da [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => "Ùltim spam $1 {{PLURAL:$1|di|di}} fa, ël livel ëd mnassa a l'é $2, e ël còdes d'atach a l'é $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Varda ij detaj], o [[Special:Blockip/$4|blòca]].",
	'cspammerlogpagetext' => 'Registr ëd le modìfiche përmëttùe o vietà a second che la sorziss a fussa në spammer conossù.',
	'cspammer-log-page' => 'Registr djë spammer ëd coment',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'commentspammer-save-blocked' => 'O seu endereço IP é um suspeito "spammer" de comentários, consequentemente a página não foi guardada.
[[Special:UserLogin|Autentique-se ou crie uma conta]] para evitar isto.',
	'commentspammer-desc' => 'Rejeita edições dos suspeitos de spamming que constem de uma lista negra de DNS',
	'commentspammer-log-msg' => 'edição de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Último "spam" $1 {{PLURAL:$1|dia|dias}} atrás, nível de ameaça é $2, e código de ofensa é $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Ver detalhes], ou [[Special:Blockip/$4|bloquear]].',
	'cspammerlogpagetext' => 'Registo de edições que foram permitidas ou negadas baseado no facto de a fonte ser um "spammer" de comentários conhecido.',
	'cspammer-log-page' => 'Registo de "Spammers" de Comentários',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'commentspammer-save-blocked' => 'O seu endereço IP é um suspeito "spammer" de comentários, consequentemente a página não foi gravada.
[[Special:UserLogin|Autentique-se ou crie uma conta]] para evitar isto.',
	'commentspammer-desc' => 'Rejeita edições de suspeitos "spammers" de comentários numa lista negra de DNS',
	'commentspammer-log-msg' => 'edição de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Último "spam" $1 {{PLURAL:$1|dia|dias}} atrás, nível de ameaça é $2, e código de ofensa é $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Ver detalhes], ou [[Special:Blockip/$4|bloquear]].',
	'cspammerlogpagetext' => 'Registo de edições que foram permitidas ou negadas baseado no fato de a fonte ser um "spammer" de comentários conhecido.',
	'cspammer-log-page' => 'Registro de "Spammers" de Comentários',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'commentspammer-log-msg' => 'cangiaminde da [[Special:Contributions/$1|$1]] a [[:$2]].',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'commentspammer-save-blocked' => 'Есть подозрение, что ваш IP-адрес использовался для размещения спам-комментариев. Страница не может быть сохранена. [[Special:UserLogin|Представьтесь системе]], чтобы продолжить работу.',
	'commentspammer-desc' => 'Отвергает правки подозреваемых в спаме комментариев на основе чёрного списка DNS',
	'commentspammer-log-msg' => 'правка с [[Special:Contributions/$1|$1]] [[:$2]].',
	'commentspammer-log-msg-info' => 'Последний случай спама $1 {{PLURAL:$1|день|дня|дней}} назад, уровень угрозы — $2, код нарушения — $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Подробности], [[Special:Blockip/$4|заблокировать]].',
	'cspammerlogpagetext' => 'Запись правок, которые были разрешены или отклонены на основе того, был ли источник известен как спаммер комментариев.',
	'cspammer-log-page' => 'Журнал спам-комментариев',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'cspammer-log-page' => 'Спам-комментарийдар сурунааллара',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'commentspammer-save-blocked' => 'Existuje podozrenie, že vaša IP adresa je adresa podozrivého spammera obsahu, preto stránka nebola uložená. Vyhnete sa tomu tým, že [[Special:UserLogin|sa prihlásite alebo si vytvoríte učet]].',
	'commentspammer-desc' => 'Odmieta úpravy od podozrivých spamerov z DNS blacklistu',
	'commentspammer-log-msg' => 'Úprava [[:$2]] od [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Naposledy spamoval pred $1 {{PLURAL:$1|dňom|dňami}}, úroveň ohrozenia je $2 a kód prehrešku je $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Zobraziť podrobnosti] alebo [[Special:Blockip/$4|zablokovať]].',
	'cspammerlogpagetext' => 'Záznam úprav, ktoré boli povolené alebo zamietnuté na základe toho, že zdroj bol známy spammer obsahu.',
	'cspammer-log-page' => 'Záznam spammerov obsahu',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'commentspammer-save-blocked' => 'Dien IP-Adresse stamt fermoudelk fon n Kommentoar-Spammer. Ju Siede wuude nit spiekerd.
[[Special:UserLogin|Mäldje die an of moak n Benutserkonto]], uum disse Woarskauenge tou ferhinnerjen.',
	'commentspammer-log-msg' => 'Beoarbaidenge fon [[Special:Contributions/$1|$1]] foar [[:$2]].',
	'commentspammer-log-msg-info' => 'Lääste Spammenge foar $1 {{PLURAL:$1|Dai|Deege}}, die "threat level" is $2 un die "offence code" is $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Details ankiekje] of [[Special:Blockip/$4|speere]].',
	'cspammerlogpagetext' => 'Lieste fon Beoarbaidengen, do der ferlööwed of ouliend wuuden ap dän Gruund, of ju Wälle n bekoanden Kommentoar-Spammer waas.',
	'cspammer-log-page' => 'Kommentoar-Spammer Logbouk',
);

/** Swedish (Svenska)
 * @author Lejonel
 */
$messages['sv'] = array(
	'commentspammer-save-blocked' => 'Din IP-adress misstänks vara en kommentarspammare. Därför har sidan inte sparats. [[Special:UserLogin|Logga in eller skapa ett användarkonto]] för att undvika detta.',
	'commentspammer-desc' => 'Stoppar redigeringar som misstänks komma från kommentarspammare som finns på en svart lista',
	'commentspammer-log-msg' => 'redigering av [[:$2]] från [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Spammade senast för $1 {{PLURAL:$1|dag|dagar}} sedan, hotnivån är $2 och förbrytelsekoden är $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Se mer information] eller [[Special:Blockip/$4|blockera]].',
	'cspammerlogpagetext' => 'Det här är en logg över redigeringar som har tillåtits eller stoppats beroende på om källan är en känd kommentarspammare.',
	'cspammer-log-page' => 'Kommentarspamslogg',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'commentspammer-save-blocked' => 'మీ IP చిరునామా ఓ అనుమానాస్పద వ్యాఖ్యా స్పామర్, కనుక పేజీని భద్రపరచలేదు. దీన్ని నివారించడానికి [[Special:UserLogin|లోనికి ప్రవేశించండి లేదా ఖాతా సృష్టించుకోండి]].',
	'commentspammer-desc' => 'DNS నిరోధక జాబితాలో ఉన్న అనుమానాస్పద వ్యాఖ్యా స్పామర్ల దిద్దుబాట్లను తిరస్కరిస్తుంది',
	'commentspammer-log-msg' => '[[:$2]] లో [[Special:Contributions/$1|$1]] చేసిన దిద్దుబాటు',
	'commentspammer-log-msg-info' => 'చివరగా స్పాము పంపినది $1 {{PLURAL:$1|రోజు|రోజుల}} కిందట, ప్రమాద స్థాయి $2, దుశ్చర్య కోడు $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 వివరాలు చూడండి], లేదా [[Special:Blockip/$4|నిరోధించండి]].',
	'cspammerlogpagetext' => 'కారకులు, తెలిసిన స్పామరేనా కాదా అనేదాన్ని బట్టి గతంలో అనుమతించిన, తిరస్కరించిన దిద్దుబాట్ల నివేదిక',
	'cspammer-log-page' => 'వ్యాఖ్యల స్పామర్ల చిట్టా',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'commentspammer-log-msg' => 'вироиш аз [[Special:Contributions/$1|$1]] ба [[:$2]].',
	'cspammer-log-page' => 'Гузориши Ҳаразнигорро тавзеҳ диҳед',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'commentspammer-log-msg' => 'viroiş az [[Special:Contributions/$1|$1]] ba [[:$2]].',
	'cspammer-log-page' => 'Guzorişi Haraznigorro tavzeh dihed',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'commentspammer-save-blocked' => "Ang iyong adres ng IP ay isang pinaghihinalaang manlulusob na may dalang kumento, kaya't hindi sinagip ang pahina.
[[Special:UserLogin|Lumagda o lumikha ng akawnt]] upang maiwasan ito.",
	'commentspammer-desc' => 'Tinatanggihan ang mga pagbabago mula sa mga manlulusob na may dalang kumento na nasa isang talaan ng mga pinagbabawalan ng DNS',
	'commentspammer-log-msg' => 'pamamatnugot mula [[Special:Contributions/$1|$1]] hanggang [[:$2]].',
	'commentspammer-log-msg-info' => 'Huling nilusob ang $1 noong nakaraang huling {{PLURAL:$1|araw|mga araw}}, ang antas ng pagbabanta ay $2, at ang kodigo ng kasalanan ay $3. 
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Tingnan ang mga detalye], o [[Special:Blockip/$4|hadlangan]].',
	'cspammerlogpagetext' => 'Tala ng mga pagbabagong pinahintulutan o tinanggihan batay sa kung ang pinagmulan ay isang kilalang manlulusob na may kumento.',
	'cspammer-log-page' => 'Talaan ng manlulusob na may dalang kumento',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'commentspammer-save-blocked' => 'IP adresinizin yorum reklamı için kullanılmasından şüphelenildiği için sayfa kaydedilmedi.
Bunun önüne geçmek için [[Special:UserLogin|oturum açın ya da hesap oluşturun]].',
	'commentspammer-desc' => 'DNS kara listesindeki şüphelenilen yorum reklamcılarının değişikliklerini reddeder',
	'commentspammer-log-msg' => '[[Special:Contributions/$1|$1]] ile [[:$2]] arasındaki değişiklikler.',
	'commentspammer-log-msg-info' => 'En son reklam $1 {{PLURAL:$1|gün|gün}} önce eklendi, tehdit seviyesi $2, saldırı kodu $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Detayları gör] veya [[Special:Blockip/$4|engelle]].',
	'cspammerlogpagetext' => 'Kaynağın bilinen bir yorum reklamcısı olup olmamasına dayanılarak izin verilen ya da reddedilen değişikliklerin kaydı.',
	'cspammer-log-page' => 'Yorum reklamcısı kaydı',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'commentspammer-save-blocked' => 'Імовірно, що ваша IP-адреса використовувалася для розміщення спам-коментарів, тому сторінка не може бути збережена. [[Special:UserLogin|Увійдіть до системи або зареєструйтесь]], щоб продовжити роботу.',
	'commentspammer-desc' => 'Відкидає редагування підозрілих на спам коментарів на основі чорного списку DNS',
	'commentspammer-log-msg' => 'редагування з [[Special:Contributions/$1|$1]] [[:$2]].',
	'commentspammer-log-msg-info' => 'Останній випадок спаму $1 {{PLURAL:$1|день|дні|днів}} тому, рівень загрози — $2, код порушення — $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Подробиці], [[Special:Blockip/$4|заблокувати]].',
	'cspammerlogpagetext' => "Запис редагувань, які були дозволені або відхилені у зв'язку з тим, чи було джерело відоме як спамер коментарів.",
	'cspammer-log-page' => 'Журнал спам-коментарів',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'commentspammer-save-blocked' => 'Địa chỉ IP của bạn bị nghi ngờ là một spam chú thích, do đó trang này không được lưu.
[[Special:UserLogin|Hãy đăng nhập hoặc mở tài khoản]] để tránh điều này.',
	'commentspammer-desc' => 'Từ chối sửa đổi từ những người tình nghi là spammer chú thích trên một danh sách đen DNS',
	'commentspammer-log-msg' => 'sửa đổi từ [[Special:Contributions/$1|$1]] tại [[:$2]].',
	'commentspammer-log-msg-info' => 'Lần spam cuối cùng là $1 {{PLURAL:$1|ngày|ngày}} trước, mức độ đe dọa $2, và mã vi phạm là $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Xem chi tiết], hoặc [[Special:Blockip/$4|cấm]].',
	'cspammerlogpagetext' => 'Bản lưu các sửa đổi đã được cho phép hoặc từ chối dựa trên nguồn đó có phải là một spammer chú thích đã biết hay không.',
	'cspammer-log-page' => 'Nhật trình Spammer chú thích',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'commentspammer-save-blocked' => 'Ladet-IP olik paniludon as küpetaspaman; kodü atos, pad no pedakipon.
[[Special:UserLogin|Nunädolös oli u jafolös kali]] ad vitön atosi.',
	'commentspammer-desc' => 'Refudon votükamis de küpetaspamans peniludöl in blägalised-DNS.',
	'commentspammer-log-msg' => 'votükam de [[Special:Contributions/$1|$1]] ad [[:$2]].',
	'cspammerlogpagetext' => 'Lised votükamas, kels pezepons u perefudons stabü sev, das fonät äbinon (u no) küpetaspaman sevädik',
	'cspammer-log-page' => 'Jenotalised tefü küpetaspamans',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'commentspammer-save-blocked' => '您的 IP 地址疑为评论垃圾制造者，该页面未保存。
[[Special:UserLogin|登录或创建帐户]]可避免这种情况。',
	'commentspammer-desc' => '拒绝从怀疑的评论垃圾邮件制造者在黑名单上的编辑',
	'commentspammer-log-msg' => '编辑从 [[Special:Contributions/$1|$1]] 至 [[:$2]]。',
	'cspammerlogpagetext' => '记录的编辑将被允许或拒绝基于源是否是一个已知的评论垃圾邮件制造者。',
	'cspammer-log-page' => '注释垃圾邮件制造者日志',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'commentspammer-save-blocked' => '您的 IP 地址疑為評論垃圾製造者，該頁面未保存。
[[Special:UserLogin|登錄或創建帳戶]]可避免這種情況。',
	'commentspammer-desc' => '拒絕從懷疑的評論垃圾郵件製造者在黑名單上的編輯',
	'commentspammer-log-msg' => '編輯從 [[Special:Contributions/$1|$1]] 至 [[:$2]]。',
	'cspammerlogpagetext' => '記錄的編輯將被允許或拒絕基於源是否是一個已知的評論垃圾郵件製造者。',
	'cspammer-log-page' => '注釋垃圾郵件製造者日誌',
);

