<?php
/**
 * Internationalisation file for extension CommentSpammer
 *
 * @addtogroup Extensions
 */

$messages = array();

/* English
 * @author Nick Jenkins
 */
$messages['en'] = array(
	'commentspammer-save-blocked' => 'Your IP address is a suspected comment spammer, so the page has not been saved.
[[Special:Userlogin|Log in or create an account]] to avoid this.',
	'commentspammer-desc'         => 'Rejects edits from suspected comment spammers on a DNS blacklist',
	'commentspammer-log-msg'      => 'edit from [[Special:Contributions/$1|$1]] to [[:$2]]. ',
	'commentspammer-log-msg-info' => 'Last spammed $1 {{PLURAL:$1|day|days}} ago, threat level is $2, and offence code is $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 View details], or [[Special:Blockip/$4|block]].',
	'cspammerlogpagetext'         => 'Record of edits that have been allowed or denied based on whether the source was a known comment spammer.',
	'cspammer-log-page'           => 'Comment spammer log',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Siebrand
 */
$messages['ar'] = array(
	'commentspammer-save-blocked' => 'عنوان الأيبي الخاص بك هو معلق سبام مشتبه، لذا لم يتم حفظ الصفحة. [[Special:Userlogin|ادخل أو سجل حسابا]] لتجنب هذا.',
	'commentspammer-desc'         => 'يرفض التعديلات من معلقي السبام المشتبه فيهم على قائمة DNS سوداء',
	'commentspammer-log-msg'      => 'تعديل من [[Special:Contributions/$1|$1]] ل[[:$2]].',
	'commentspammer-log-msg-info' => 'آخر سبام منذ $1 {{PLURAL:$1|يوم|يوم}} ، مستوى التهديد هو $2، وكود الإساءة هو $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 عرض التفاصيل]، أو [[Special:Blockip/$4|منع]].',
	'cspammerlogpagetext'         => 'سجل التعديلات التي تم السماح بها أو رفضها بناء على ما إذا كان المصدر معلق سبام معروف.',
	'cspammer-log-page'           => 'سجل تعليق السبام',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'commentspammer-log-msg' => 'редакция от [[Special:Contributions/$1|$1]] в [[:$2]].',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Siebrand
 */
$messages['cs'] = array(
	'commentspammer-save-blocked' => 'Existuje podezření, že vaše IP adresa je adresa podezřelého spammera obsahu, proto stránka nebyla uložena.
Vyhněte se tomu tím, že [[Special:Userlogin|se přihlásíte nebo si vytvoříte účet]].',
	'commentspammer-desc'         => 'Odmítá úpravy od podezřelých spamerů z černé listiny DNS',
	'commentspammer-log-msg'      => 'úprava [[:$2]] od [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Naposledy spamováno {{PLURAL:$1|včera|před $2 dny}}, úroveň ohrožení je $2 a kód prohřešku je $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Zobrazit podrobnosti] nebo [[Special:Blockip/$4|zablokovat]].',
	'cspammerlogpagetext'         => 'Záznam úprav, které byly povoleny nebo zamítnuty na základě toho, že zdroj byl známý spammer obsahu.',
	'cspammer-log-page'           => 'Záznam spamerů obsahu',
);

/** German (Deutsch) */
$messages['de'] = array(
	'commentspammer-save-blocked' => 'Deine IP-Adresse stammt mutmaßlich von einem Kommentar-Spammer. Die Seite wurde nicht gespeichert. [[Special:Userlogin|Melde dich an oder erstelle ein Benutzerkonto]], um diese Warnung zu unterbinden.',
	'commentspammer-log-msg'      => 'Bearbeitung von [[Special:Contributions/$1|$1]] für [[:$2]]. ',
	'commentspammer-log-msg-info' => 'Letztes Spamming vor $1 {{PLURAL:$1|Tag|Tagen}}, der "threat level" ist $2 und der and "offence code" is $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Details ansehen] oder [[Special:Blockip/$4|sperren]].',
	'cspammerlogpagetext'         => 'Liste der Bearbeitungen, die genehmigt oder abgelehnt wurden auf der Basis, ob die Quelle ein bekannter Kommentar-Spammer war.',
	'cspammer-log-page'           => 'Kommentar-Spammer Logbuch',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'commentspammer-log-msg' => 'redakto de [[Special:Contributions/$1|$1]] al [[:$2]].',
	'cspammer-log-page'      => 'Protokolo de komentaj spamistoj',
);

/** French (Français)
 * @author Sherbrooke
 * @author Grondin
 * @author Siebrand
 * @author Urhixidur
 */
$messages['fr'] = array(
	'commentspammer-save-blocked' => "Votre adresse IP est celle d'une personne suspectée de créer du pourriel : la page n'a donc pas été sauvegardée. Veuillez vous [[Special:Userlogin|connecter ou créer un compte]] pour contourner cette interdiction.",
	'commentspammer-desc'         => 'Rejette les modifications soupçonnées de pourriel à partir d’une liste noire figurant dans le projet HoneyPot DNS',
	'commentspammer-log-msg'      => 'Modifications de [[Special:Contributions/$1|$1]] à [[:$2]].',
	'commentspammer-log-msg-info' => "Le dernier pourriel remonte à {{PLURAL:$1|$1 jour|$1 jours}}, le niveau d'alerte est à $2 et le code d'attaque est $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Voir détails] ou [[Special:Blockip/$4|bloquer]].",
	'cspammerlogpagetext'         => 'Journal des modifications acceptées ou rejetées selon que la source était un créateur de pourriels connu.',
	'cspammer-log-page'           => 'Journal du créateur de pourriels',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 * @author Siebrand
 */
$messages['frp'] = array(
	'commentspammer-save-blocked' => 'Voutra adrèce IP est cela d’una pèrsona soupçonâ de crèar de spame, la pâge at pas étâ sôvâ. Volyéd vos [[Special:Userlogin|conèctar ou crèar un compto]] por contornar ceta dèfensa.',
	'commentspammer-log-msg'      => 'Modificacions de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Lo dèrriér spame remonte a {{PLURAL:$1|$1 jorn|$1 jorns}}, lo nivô d’alèrta est a $2 et lo code d’ataca est $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Vêre los dètalys] ou ben [[Special:Blockip/$4|blocar]].',
	'cspammerlogpagetext'         => 'Jornal de les modificacions accèptâs ou refusâs d’aprés que la sôrsa ére un crèator de spame cognu.',
	'cspammer-log-page'           => 'Jornal du crèator de spame',
);

/** Galician (Galego)
 * @author Alma
 * @author Siebrand
 * @author Xosé
 * @author Toliño
 */
$messages['gl'] = array(
	'commentspammer-save-blocked' => 'O seu enderezo IP é sospeitoso de facer comentarios spam, de maneira que non se gardou a páxina. [[Special:Userlogin|Rexístrese ou cree unha conta]] para evitalo.',
	'commentspammer-desc'         => 'Rexeita as edicións dos comentarios dos sospeitosos de ser spammers nunha listaxe negra (blacklist) DNS',
	'commentspammer-log-msg'      => 'editar de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Último correo spam $1 {{PLURAL:$1|día|días}} atrás, nivel de ameaza é de $2, e código de delito é de $3. 
[http://www.projecthoneypot.org/search_ip.php?ip=$4 ver detalles], ou [[Special:Blockip/$4|bloqueo]].',
	'cspammerlogpagetext'         => 'Historial das edicións que se permitiron ou denegaron sobre a base de si a fonte foi un coñecido comentario spam.',
	'cspammer-log-page'           => 'Rexistro dos comentarios Spam',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'commentspammer-desc'         => 'डीएनएस ब्लॅकलिस्टपर होनेवाले संशयित स्पॅमर्सके बदलाव रद्द कर देता हैं',
	'commentspammer-log-msg'      => '[[:$2]] पर किये हुए [[Special:Contributions/$1|$1]] के बदलाव।',
	'commentspammer-log-msg-info' => 'आखिरमें $1 {{PLURAL:$1|दिन पहले|दिनों पहले}} स्पॅम किया था, स्तर $2, और ऑफेन्स कोड $3 हैं। [http://www.projecthoneypot.org/search_ip.php?ip=$4 अधिक ज़ानकारी], या [[Special:Blockip/$4|ब्लॉक करें]]।',
	'cspammerlogpagetext'         => 'यह सूची ऐसे बदलाव दर्शाती हैं जो स्रोतके टिप्पणी स्पॅमर स्थितीके अनुसार रोके या स्वीकार किये गये हैं।',
	'cspammer-log-page'           => 'टिप्पणी स्पॅमर सूची',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 * @author Siebrand
 */
$messages['hsb'] = array(
	'commentspammer-save-blocked' => 'Twoja IP-adresa je podhladny komentarne spamowar - składowanje zablokowane. Wutwor konto, zo by to wobešoł.',
	'commentspammer-desc'         => 'Wotpokazuje změny wot podhladnych spamowarjow komentarow na čornej lisćinje DNS.',
	'commentspammer-log-msg'      => 'změna wot [[Special:Contributions/$1|$1]] k [[:$2]]',
	'commentspammer-log-msg-info' => 'Posledni spam před $1 {{PLURAL:$1|dnjom|dnjomaj|dnjemi|dnjemi}}, stopjeń hroženja je $2 a nadpadowy kod je $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Hlej podrobnosće] abo [[Special:Blockip/$4|blokowanje]].',
	'cspammerlogpagetext'         => 'Datowa sadźba změnow, kotrež buchu dowolene abo wotpokazane, po tym hač žórło je znaty spamowar abo nic.',
	'cspammer-log-page'           => 'Protokol komentarnych spamowarjow',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'commentspammer-save-blocked' => 'Az IP-címed feltételezett tartalomspammer, ezért az oldal nem lett elmentve. [[Special:Userlogin|Jelentkezz be]] ennek kiküszöböléséhez.',
	'commentspammer-log-msg'      => '[[Special:Contributions/$1|$1]] szerkesztése a(z) [[:$2]] lapon.',
	'commentspammer-log-msg-info' => 'Utoljára $1 napja spammelt, veszélyességi szintje $2, támadókódja $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Részletek megtekintése], vagy [[Special:Blockip/$4|blokkolás]].',
	'cspammerlogpagetext'         => 'Azon szerkesztések listája, melyek engedélyezve vagy tiltva lettek attól függően, hogy a szerző ismert tartalomspammer volt-e.',
	'cspammer-log-page'           => 'Tartalomspammer napló',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 */
$messages['it'] = array(
	'commentspammer-save-blocked' => 'Il tuo IP è quello di un utente sospettato di creazione di spam, così la pagina non è stata salvata. [[Special:Userlogin|Entra o crea un nuovo accesso]] per evitare questo.',
	'commentspammer-desc'         => 'Rifiuta le modifiche dagli utenti sospettati di creazione di spam su una blacklist DNS',
	'commentspammer-log-msg'      => 'modifica di [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => "L'ultimo spam è stato effettuato $1 {{PLURAL:$1|giorno|giorni}} fa, il livello della minaccia è $2 e il codice di attacco è $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Visualizza i dettagli] oppure [[Special:Blockip/$4|blocca]].",
	'cspammerlogpagetext'         => 'Registro delle modifiche che sono state permesse o negate a seconda che la fonte fosse uno spammer noto.',
);

/** Japanese (日本語)
 * @author JtFuruhata
 * @author Siebrand
 */
$messages['ja'] = array(
	'commentspammer-save-blocked' => 'あなたのIPアドレスはスパム投稿に用いられているとの疑いがあるため、ページは保存されませんでした。[[Special:Userlogin|ログインまたはアカウントの作成]]を行ってください。',
	'commentspammer-desc'         => 'DNSブラックリストに記載されたコメントスパム投稿容疑IPアドレスからの編集を拒絶する',
	'commentspammer-log-msg'      => '利用者 [[Special:Contributions/$1|$1]] による [[:$2]] の編集',
	'commentspammer-log-msg-info' => '最後のスパム行為は $1{{PLURAL:$1|日|日}}前 / 脅威レベル $2 / 防御コード $3 / [http://www.projecthoneypot.org/search_ip.php?ip=$4 詳細表示] / [[{{ns:Special}}:Blockip/$4|ブロック状況]]',
	'cspammerlogpagetext'         => 'この編集履歴は、判明しているコメントスパマーによる投稿の許可/拒否状況を示します。',
	'cspammer-log-page'           => 'スパム投稿ログ',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'commentspammer-save-blocked' => 'Alamat IP panjenengan iku dicurigani dienggo ngirim spam, dadi kaca iki ora disimpen.
Kanggo menggak iki, [[Special:Userlogin|mangga log mlebu utawa nggawé rékening (akun)]].',
	'commentspammer-log-msg'      => 'suntingan saka [[Special:Contributions/$1|$1]] menyang [[:$2]].',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'commentspammer-save-blocked' => "Är IP-Adress gëtt als Spammer verdächtegt, dofir gouf d'Säit net gespäichert.
[[Special:Userlogin|Loggt Iech an oder maacht e Benotzerkont op]] fir dëst ze verhënneren.",
	'commentspammer-desc'         => "Refuséiert Ännerunge vu verdächtege Spammeren vun enger ''Schwaarzer DNS-Lësch''",
	'commentspammer-log-msg'      => 'Ännerunge vun [[Special:Contributions/$1|$1]] fir [[:$2]].',
	'commentspammer-log-msg-info' => 'De leschte Spam war viru(n) $1 {{PLURAL:$1|Dag|Deeg}}, den Niveau vum Alarm ass $2 an den "offence code" ass $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Fir d\'Detailer ze kucken], oder [[Special:Blockip/$4|fir ze spären]].',
	'cspammerlogpagetext'         => "Lëscht vun den Ännerungen déi ugeholl oder refuséiert goufen je nodeem ob d'Quell als Spammer bekannt war oder net.",
	'cspammer-log-page'           => 'Bemierkung Spammer Logbuch',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'commentspammer-log-msg' => '[[Special:Contributions/$1|$1]]ല്‍ നിന്ന് [[:$2]]ല്‍ ഉള്ള തിരുത്തലുകള്‍.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'commentspammer-save-blocked' => 'तुमचा आंतरजाल अंकपत्ता (IP) स्पॅमर असल्याचा संशय आहे, त्यामुळे पान जतन करण्यात आलेले नाही.
हे टाळण्यासाठी [[Special:Userlogin|प्रवेश करा किंवा नवीन सदस्य नोंदणी करा]].',
	'commentspammer-desc'         => 'डीएनएस ब्लॅकलिस्टवर असणार्‍या संशयित स्पॅमर्सची संपादने रद्द करते',
	'commentspammer-log-msg'      => '[[:$2]] वर केलेली [[Special:Contributions/$1|$1]] ची संपादने',
	'commentspammer-log-msg-info' => 'शेवटी $1 {{PLURAL:$1|दिवसापूर्वी|दिवसांपूर्वी}} स्पॅम केले, पातळी $2, व ऑफेन्स कोड $3 आहे. [http://www.projecthoneypot.org/search_ip.php?ip=$4 अधिक माहिती], किंवा [[Special:Blockip/$4|ब्लॉक करा]].',
	'cspammerlogpagetext'         => 'ही सूची अश्या संपादनांची यादी आहे जी स्रोताच्या स्पॅमर स्थितीनुसार अडवली किंवा स्वीकारली गेलेली आहेत.',
	'cspammer-log-page'           => 'स्पॅमर सूची शेरा',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'commentspammer-save-blocked' => 'Uw IP-adres wordt verdacht van spammen - opslaan is geweigerd. Maak een gebruiker aan om dit te voorkomen.',
	'commentspammer-desc'         => 'Voorkomt bewerkingen van spammers via een DNS blacklist',
	'commentspammer-log-msg'      => 'bewerking van [[Special:Contributions/$1|$1]] aan [[:$2]].',
	'commentspammer-log-msg-info' => 'Spamde voor het laatst $1 {{PLURAL:$1|dag|dagen}} geleden. Dreigingsniveau is $2 en de overtredingscode is $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Details bekijken] of [[Special:Blockip/$4|blokkeren]].',
	'cspammerlogpagetext'         => 'Logboek met bewerkingen die toegestaan of geweigerd zijn omdat de bron een bekende spammer was.',
	'cspammer-log-page'           => 'Spamlogboek',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'commentspammer-save-blocked' => 'IP-adressa di mistenkes for å være en kommentarforsøpler, så siden kan ikke lagres. [[Special:Userlogin|Logg inn eller opprett en konto]] for å unngå dette.',
	'commentspammer-desc'         => 'Avviser endringer fra mistenkte spammere på en DNS-svarteliste.',
	'commentspammer-log-msg'      => 'redigering på [[:$2]] av [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Sist forsøplet for $1 {{PLURAL:$1|dag|dager}} siden, trusselnivået er $2, og fornærmelseskoden er $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Se detaljer] eller [[Special:Blockip/$4|blokkert]].',
	'cspammerlogpagetext'         => 'Register over redigeringer som har blitt godtatt eller nektet basert på hvorvidt kilden var en kjent kommentarforsøpler.',
	'cspammer-log-page'           => 'Kommentarforsøplerlogg',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Siebrand
 */
$messages['oc'] = array(
	'commentspammer-save-blocked' => "Vòstra adreça IP es la d'una persona sospechada de crear de spams, la pagina es pas estada salvada. [[Special:Userlogin|Conectatz-vos o creatz un compte]] per contornar aqueste interdich.",
	'commentspammer-desc'         => 'Regèta las modificacions suspectadas de spams a partir d’una lista negra figurant dins lo projècte HoneyPot DNS',
	'commentspammer-log-msg'      => 'Modificacions de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => "Lo darrièr spam remonta a {{PLURAL:$1|$1 jorn|$1 jorns}}, lo nivèl d'alèrta es a $2 e lo còde d'atac es $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Vejatz los detalhs] o [[Special:Blockip/$4|blocatz]].",
	'cspammerlogpagetext'         => 'Jornal de las modificacions acceptadas o rejetadas segon que la font èra un creator de spams conegut.',
	'cspammer-log-page'           => 'Jornal del creator de spams',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 * @author Siebrand
 */
$messages['pl'] = array(
	'commentspammer-save-blocked' => 'Twój adres IP jest podejrzewany o spamowanie – zapisywanie stron jest zablokowane.
[[Special:Userlogin|Zaloguj się lub utwórz konto]], aby uniknąć tego komunikatu.',
	'commentspammer-desc'         => 'Odrzuca podejrzane edycje komentarzy robione przez spamerów na podstawie listy zabronionych nazw DNS',
	'commentspammer-log-msg'      => 'edycja [[Special:Contributions/$1|$1]] w [[:$2]].',
	'commentspammer-log-msg-info' => 'Ostatni spam $1 {{PLURAL:$1|dzień|dni}} temu, poziom zagrożenia $2, kod naruszenia $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Zobacz szczegóły] lub [[Special:Blockip/$4|zablokuj]].',
	'cspammerlogpagetext'         => 'Zapis edycji, które zostały dozwolone lub zakazane na podstawie tego, czy dokonała ich osoba znana jako spammer.',
	'cspammer-log-page'           => 'Rejestr spammerów',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Siebrand
 */
$messages['pt'] = array(
	'commentspammer-save-blocked' => 'O seu endereço IP é um suspeito "spammer" de comentários, consequentemente a página não foi guardada.
[[Special:Userlogin|Autentique-se ou crie uma conta]] para evitar isto.',
	'commentspammer-desc'         => 'Rejeita edições de suspeitos "spammers" de comentários numa lista negra de DNS',
	'commentspammer-log-msg'      => 'edição de [[Special:Contributions/$1|$1]] a [[:$2]].',
	'commentspammer-log-msg-info' => 'Último "spam" $1 {{PLURAL:$1|dia|dias}} atrás, nível de ameaça é $2, e código de ofensa é $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Ver detalhes], ou [[Special:Blockip/$4|bloquear]].',
	'cspammerlogpagetext'         => 'Registo de edições que foram permitidas ou negadas baseado no facto de a fonte ser um "spammer" de comentários conhecido.',
	'cspammer-log-page'           => 'Registo de "Spammers" de Comentários',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Ahonc
 */
$messages['ru'] = array(
	'commentspammer-save-blocked' => 'Подозревается, что ваш IP-адрес использовался для размещения спам-комментариев. Страница не может быть сохранена. [[Special:Userlogin|Представьтесь системе]], чтобы продолжить работу.',
	'commentspammer-desc'         => 'Отвергает правки подозреваемых в спаме комментариев на основе чёрного списка DNS',
	'commentspammer-log-msg'      => 'правка с [[Special:Contributions/$1|$1]] [[:$2]].',
	'commentspammer-log-msg-info' => 'Последний случай спама $1 {{PLURAL:$1|день|дня|дней}} назад, уровень угрозы — $2, код нарушения — $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Подробности], [[Special:Blockip/$4|заблокировать]].',
	'cspammerlogpagetext'         => 'Запись правок, которые были разрешены или отклонены на основе того, был ли источник известен как спаммер комментариев.',
	'cspammer-log-page'           => 'Журнал спам-комментариев',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'commentspammer-save-blocked' => 'Existuje podozrenie, že vaša IP adresa je adresa podozrivého spammera obsahu, preto stránka nebola uložená. Vyhnete sa tomu tým, že [[Special:Userlogin|sa prihlásite alebo si vytvoríte učet]].',
	'commentspammer-desc'         => 'Odmieta úpravy od podozrivých spamerov z DNS blacklistu',
	'commentspammer-log-msg'      => 'Úprava [[:$2]] od [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Naposledy spamoval pred $1 {{PLURAL:$1|dňom|dňami}}, úroveň ohrozenia je $2 a kód prehrešku je $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Zobraziť podrobnosti] alebo [[Special:Blockip/$4|zablokovať]].',
	'cspammerlogpagetext'         => 'Záznam úprav, ktoré boli povolené alebo zamietnuté na základe toho, že zdroj bol známy spammer obsahu.',
	'cspammer-log-page'           => 'Záznam spammerov obsahu',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'commentspammer-save-blocked' => 'Dien IP-Adresse stamt fermoudelk fon n Kommentoar-Spammer. Ju Siede wuude nit spiekerd.
[[Special:Userlogin|Mäldje die an of moak n Benutserkonto]], uum disse Woarschauenge tou ferhinnerjen.',
	'commentspammer-log-msg'      => 'Beoarbaidenge fon [[Special:Contributions/$1|$1]] foar [[:$2]].',
	'commentspammer-log-msg-info' => 'Lääste Spammenge foar $1 {{PLURAL:$1|Dai|Deege}}, die "threat level" is $2 un die "offence code" is $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Details ankiekje] of [[Special:Blockip/$4|speere]].',
	'cspammerlogpagetext'         => 'Lieste fon Beoarbaidengen, do der ferlööwed of ouliend wuuden ap dän Gruund, of ju Wälle n bekoanden Kommentoar-Spammer waas.',
	'cspammer-log-page'           => 'Kommentoar-Spammer Logbouk',
);

/** Swedish (Svenska)
 * @author Lejonel
 */
$messages['sv'] = array(
	'commentspammer-save-blocked' => 'Din IP-adress misstänks vara en kommentarspammare. Därför har sidan inte sparats. [[Special:Userlogin|Logga in eller skapa ett användarkonto]] för att undvika detta.',
	'commentspammer-desc'         => 'Stoppar redigeringar som misstänks komma från kommentarspammare som finns på en svart lista',
	'commentspammer-log-msg'      => 'redigering av [[:$2]] från [[Special:Contributions/$1|$1]].',
	'commentspammer-log-msg-info' => 'Spammade senast för $1 {{PLURAL:$1|dag|dagar}} sedan, hotnivån är $2 och förbrytelsekoden är $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 Se mer information] eller [[Special:Blockip/$4|blockera]].',
	'cspammerlogpagetext'         => 'Det här är en logg över redigeringar som har tillåtits eller stoppats beroende på om källan är en känd kommentarspammare.',
	'cspammer-log-page'           => 'Kommentarspamslogg',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author వైజాసత్య
 * @author Veeven
 */
$messages['te'] = array(
	'commentspammer-save-blocked' => 'మీ IP చిరునామా ఓ అనుమానాస్పద వ్యాఖ్యా స్పామర్, కనుక పేజీని భద్రపరచలేదు. దీన్ని నివారించడానికి [[Special:Userlogin|లోనికి ప్రవేశించండి లేదా ఖాతా సృష్టించుకోండి]].',
	'commentspammer-desc'         => 'DNS నిరోధక జాబితాలో ఉన్న అనుమానాస్పద వ్యాఖ్యా స్పామర్ల దిద్దుబాట్లను తిరస్కరిస్తుంది',
	'commentspammer-log-msg'      => '[[:$2]] లో [[Special:Contributions/$1|$1]] చేసిన దిద్దుబాటు',
	'commentspammer-log-msg-info' => 'చివరగా స్పాము పంపినది $1 {{PLURAL:$1|రోజు|రోజుల}} కిందట, ప్రమాద స్థాయి $2, దుశ్చర్య కోడు $3. [http://www.projecthoneypot.org/search_ip.php?ip=$4 వివరాలు చూడండి], లేదా [[Special:Blockip/$4|నిరోధించండి]].',
	'cspammerlogpagetext'         => 'కారకులు, తెలిసిన స్పామరేనా కాదా అనేదాన్ని బట్టి గతంలో అనుమతించిన, తిరస్కరించిన దిద్దుబాట్ల నివేదిక',
	'cspammer-log-page'           => 'వ్యాఖ్యల స్పామింగు లాగ్',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'commentspammer-log-msg' => 'вироиш аз [[Special:Contributions/$1|$1]] ба [[:$2]].',
	'cspammer-log-page'      => 'Гузориши Ҳаразнигорро тавзеҳ диҳед',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'commentspammer-save-blocked' => 'Імовірно, що ваша IP-адреса використовувалася для розміщення спам-коментарів, тому сторінка не може бути збережена. [[Special:Userlogin|Увійдіть до системи або зареєструйтесь]], щоб продовжити роботу.',
	'commentspammer-desc'         => 'Відкидає редагування підозрілих на спам коментарів на основі чорного списку DNS',
	'commentspammer-log-msg'      => 'редагування з [[Special:Contributions/$1|$1]] [[:$2]].',
	'commentspammer-log-msg-info' => 'Останній випадок спаму $1 {{PLURAL:$1|день|дні|днів}} тому, рівень загрози — $2, код порушення — $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Подробиці], [[Special:Blockip/$4|заблокувати]].',
	'cspammerlogpagetext'         => "Запис редагувань, які були дозволені або відхилені у зв'язку з тим, чи було джерело відоме як спамер коментарів.",
	'cspammer-log-page'           => 'Журнал спам-коментарів',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'commentspammer-save-blocked' => 'Địa chỉ IP của bạn bị nghi ngờ là một spam chú thích, do đó trang này không được lưu.
[[Special:Userlogin|Hãy đăng nhập hoặc mở tài khoản]] để tránh điều này.',
	'commentspammer-desc'         => 'Từ chối sửa đổi từ những người tình nghi là spammer chú thích trên một danh sách đen DNS',
	'commentspammer-log-msg'      => 'sửa đổi từ [[Special:Contributions/$1|$1]] tại [[:$2]].',
	'commentspammer-log-msg-info' => 'Lần spam cuối cùng là $1 {{PLURAL:$1|ngày|ngày}} trước, mức độ đe dọa $2, và mã vi phạm là $3.
[http://www.projecthoneypot.org/search_ip.php?ip=$4 Xem chi tiết], hoặc [[Special:Blockip/$4|cấm]].',
	'cspammerlogpagetext'         => 'Bản lưu các sửa đổi đã được cho phép hoặc từ chối dựa trên nguồn đó có phải là một spammer chú thích đã biết hay không.',
	'cspammer-log-page'           => 'Nhật trình Spammer chú thích',
);

