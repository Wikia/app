<?php
/**
 * Internationalisation file for extension TorBlock.
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Andrew Garrett
 */
$messages['en'] = array(
	'torblock-desc'    => 'Allows tor exit nodes to be blocked from editing a wiki',
	'torblock-blocked' => 'Your IP address, <tt>$1</tt>, has been automatically identified as a tor exit node.
Editing through tor is blocked to prevent abuse.',
	'right-torunblocked' => 'Bypass automatic blocks of tor exit nodes',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'torblock-desc'      => 'Premite que os nodos de salida tor sían bloqueyatos ta editar una wiki',
	'torblock-blocked'   => "A suya adreza IP, <tt>$1</tt>, s'ha identificato automaticament como un nodo de salida tor.
Ye bedato d'editar con tor ta pribar abusos.",
	'right-torunblocked' => "Pribar os bloqueyos automaticos d'os nodos tor",
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'torblock-desc'      => 'يسمح بمنع عقد خروج التور من تعديل ويكي',
	'torblock-blocked'   => 'عنوان الأيبي الخاص بك، <tt>$1</tt>، تم التعرف عليه تلقائيا كعقدة خروج تور.
التعديل من خلال التور ممنوع لمنع التخريب.',
	'right-torunblocked' => 'تفادي عمليات المنع التلقائية لعقد خروج التور',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'torblock-desc'    => 'اجازت دن په در بیگ گرهنان په محدود بوتن چه اصلاح یک ویکیء',
	'torblock-blocked' => 'شمی آدرس آی پی, <tt>$1</tt>,اتوماتیکی په داب یک گرهن خروجی سنگ نشان بوتت.
اصلاح کتن چه طرق سنگ(tor) په خاطر جلوگرگ سوء استفاده بند بوتت.',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'torblock-blocked'   => "La vostra adreça IP <tt>$1</tt> ha estat identificada automàticament com un node de sortida de la xarxa Tor. L'edició a través de Tor està prohibida per a prevenir abusos.",
	'right-torunblocked' => 'Evitar els blocatges automàtics de nodes Tor',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'torblock-desc'      => 'Umožňuje blokovat editace pocházející z výstupních uzlů sítě Tor',
	'torblock-blocked'   => 'Vaše IP adresa (<tt>$1</tt>) byla automaticky rozpoznána jako výstupní uzel sítě Tor.
Editace prostřednictvím sítě Tor je kvůli prevenci zneužití zablokována.',
	'right-torunblocked' => 'Obcházení automatického blokování výstupních uzlů sítě Tor',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'torblock-desc'      => 'Ermöglicht die Schreibsperre für Tor-Ausgangsknoten',
	'torblock-blocked'   => 'Deine IP-Adresse <tt>$1</tt> wurde automatisch als Tor-Ausgangsknoten identifiziert. Die Seitenbearbeitung in Verbindung mit dem Tor-Netzwerk ist unerwünscht, da die Missbrauchsgefahr sehr hoch ist.',
	'right-torunblocked' => 'Umgehung der automatischen Sperre von Tor-Ausgangsknoten',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'torblock-desc'      => 'Permesas por elignodoj esti forbaritaj kontraŭ redaktado de vikio',
	'torblock-blocked'   => "Via IP-adreso, <tt>$1</tt> estis aŭtomate identigita kiel elignodo ''tor''.
Redaktado per ''tor'' estas forbarita por preventi misuzo.",
	'right-torunblocked' => "Preterpasi aŭtomatajn blokojn de elignodoj ''tor''.",
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'torblock-desc'      => 'قطع دسترسی خروجی‌های TOR از ویرایش در یک ویکی را ممکن می‌کند',
	'torblock-blocked'   => 'نشانی اینترنتی شما، <tt>$1</tt>، به طور خودکار به عنوان یک خروجی TOR شناسایی شده‌است. ویرایش از طریق این نشانی برای جلوگیری از سوء استفاده ممکن نیست.',
	'right-torunblocked' => 'گذر از قطع دسترسی خودکار خروجی‌های TOR',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 */
$messages['fi'] = array(
	'torblock-blocked'   => 'IP-osoitteesi <tt>$1</tt> on tunnistettu Tor-verkon poistumispisteeksi. Muokkaaminen Tor-verkon kautta on estetty väärinkäytösten välttämiseksi.',
	'right-torunblocked' => 'Ohittaa automaattiset Tor-poistumispisteiden estot',
);

/** French (Français)
 * @author Grondin
 * @author Verdy p
 */
$messages['fr'] = array(
	'torblock-desc'      => 'Permet de bloquer les modifications d’un wiki depuis les nœuds de sortie Tor',
	'torblock-blocked'   => 'Votre adresse ip, <tt>$1</tt>, a été identifiée automatiquement comme un nœud de sortie Tor.
L’édition par ce moyen est bloquée pour éviter des abus.',
	'right-torunblocked' => 'Contourner le blocage automatique des nœuds de sortie Tor.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'torblock-desc'      => 'Permite que os nodos de saída sexan bloqueados fronte á edición dun wiki',
	'torblock-blocked'   => 'O seu enderezo IP, <tt>$1</tt>, foi identificado automaticamente como un nodo de saída tor.
A edición a través disto está bloqueada para previr o abuso.',
	'right-torunblocked' => 'Esquivar os bloqueos automáticos dos nodos tor de saída',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'torblock-desc'      => 'אפשרות לחסימת נקודות יציאה של רשת TOR מעריכה בוויקי',
	'torblock-blocked'   => 'כתובת ה־IP שלכם, <tt>$1</tt>, זוהתה אוטומטית כנקודת יציאה של רשת TOR. עריכה דרך TOR חסומה כדי למנוע ניצול לרעה.',
	'right-torunblocked' => 'עקיפת חסימות אוטומטיות של נקודות יציאה ברשת TOR',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'torblock-desc'      => 'टॉर एक्झीट नोड्सको विकि संपादनसे ब्लॉक करने की अनुमति देता हैं',
	'torblock-blocked'   => 'आपका आईपी एड्रेस, <tt>$1</tt>, अपनेआप टॉर एक्झीट नोड करके पहचाना गया हैं।
गलत इस्तेमाल से बचने के लिये इसे अपनेआप ब्लॉक कर दिया गया हैं।',
	'right-torunblocked' => 'टॉर एक्झीट नोड्सके अपनेआप आये हुए प्रतिबंधोंको नजर अंदाज करें',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'torblock-desc'      => 'Permitte que le nodos de exito de Tor sia blocate de facer modificationes in un wiki',
	'torblock-blocked'   => 'Tu adresse IP, <tt>$1</tt>, ha essite automaticamente identificate como un nodo de exito de Tor.
Le modification via Tor es prohibite pro impedir le abuso.',
	'right-torunblocked' => 'Contornar le blocadas automatic de nodos de exito de Tor',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'torblock-desc'      => 'Memblokir titik alamat Tor untuk menyunting wiki',
	'torblock-blocked'   => 'Alamat IP Anda, <tt>$1</tt> telah diidentifikasi secara otomatis sebagai sebuah titik alamat Tor.
Penyuntingan melalui Tor diblokir untuk mencegah penyalahgunaan.',
	'right-torunblocked' => 'Mengabaikan pemblokiran otomatis terhadap alamat Tor',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'torblock-desc'      => 'Permette di bloccare in scrittura exit node tor su una wiki',
	'torblock-blocked'   => 'Il tuo indirizzo IP, <tt>$1</tt>, è stato automaticamente identificato come un exit node tor.
La possibilità di editare utilizzando tor è bloccata per impedire abusi.',
	'right-torunblocked' => 'Ignora i blocchi automatici degli exit node tor',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'torblock-desc'      => 'Kann et Ändere am Wiki ongerbenge för Metmaacher, di övver <tt>tor</tt> Ußjäng kumme',
	'torblock-blocked'   => 'Ding IP-Adress (<tt>$1</tt>) eß als_enne <tt>tor</tt> Ußjäng äkannt woode.
Änderunge aam Wiki dom_mer övver <tt>tor</tt> nit zolohße,
esu määt och Keiner Dreßß domet.',
	'right-torunblocked' => 'Et Ändere am Wiki övver <tt>tor</tt> Ußjäng zolohße',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'torblock-desc'      => 'Erméiglecht et Ännerungen vun enger Wiki iwwer Tor-Ausgangskniet (tor exit nodes) ze spären',
	'torblock-blocked'   => 'Är IP-Adress,  <tt>$1</tt>, gouf automatesch als Tor-ausgangsknuet erkannt.
Ännerungen iwwer Tor si gespaart fir Mëssbrauch ze verhënneren.',
	'right-torunblocked' => 'Automatesch Spär fir Tor-Ausgangskniet ëmgoen',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'torblock-desc'      => 'टॉर एक्झीट नोड्सना विकि संपादनापासून ब्लॉक करण्याची परवानगी देते',
	'torblock-blocked'   => 'तुमचा आयपी अंकपत्ता, <tt>$1</tt>, आपोआप टॉर एक्झीट नोड म्हणून ओळखला गेलेला आहे.
गैरवापर टाळण्यासाठी टॉर मधून संपादन करण्यावर बंदी घालण्यात आलेली आहे.',
	'right-torunblocked' => 'टॉर एक्झीट नोड्सच्या आपोआप आलेल्या प्रतिबंधांकडे दुर्लक्ष करा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'torblock-desc'      => 'Membolehkan sekatan terhadap nod keluar Tor',
	'torblock-blocked'   => 'Alamat IP anda, <tt>$1</tt>, telah dikenal pasti sebagai nod keluar Tor.
Penyuntingan melalui Tor disekat untuk mengelak penyalahgunaan.',
	'right-torunblocked' => 'Melepasi sekatan nod keluar Tor',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'torblock-desc'      => 'Maakt bewerken onmogelijk voor tor exitnodes',
	'torblock-blocked'   => 'Uw IP-adres, <tt>$1</tt>, is herkend als tor exitnode. Bewerken via tor is niet toegestaan om misbruik te voorkomen.',
	'right-torunblocked' => 'Automatische blokkades van tor exitnodes omzeilen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'torblock-desc'      => 'Gjør det mulig å blokkere Tors utgangsnoder fra å redigere en wiki',
	'torblock-blocked'   => 'Din IP-adresse, <tt>$1</tt>, har blitt automatisk identifisert som en utgangsnode fra TOR.
Redigering via TOR er blokkert for å forhindre misbruk.',
	'right-torunblocked' => 'Kan redigere fra automatisk blokkerte TOR-noder',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'torblock-desc'      => 'Permet als noses de sortida Tor d’èsser blocats en escritura sus un wiki',
	'torblock-blocked'   => "Vòstra adreça ip, <tt>$1</tt>, es estada identificada automaticament coma un nos de sortida Tor.
L’edicion per aqueste mejan es blocada per evitar d'abuses.",
	'right-torunblocked' => 'Passar al travèrs dels blocatges dels noses de sortida Tor.',
);

/** Polish (Polski)
 * @author Beau
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'torblock-desc'      => 'Blokuje możliwość edycji dla użytkowników anonimowych łączących się przez serwery wyjściowe sieci Tor',
	'torblock-blocked'   => 'Twój adres IP <tt>$1</tt> został automatycznie zidentyfikowany jako serwer wyjściowy sieci Tor.
Możliwość edycji z wykorzystaniem tej sieci jest zablokowana w celu zapobiegania nadużyciom.',
	'right-torunblocked' => 'Obejście automatycznych blokad zakładanych na serwery wyjściowe sieci Tor',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'torblock-desc' => 'Permite que nós de saída Tor sejam impedidos de editar um wiki',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'torblock-desc'      => 'Позволяет блокировать выходные узлы сети Tor',
	'torblock-blocked'   => 'Ваш IP-адрес, <tt>$1</tt>, был автоматически определён как выходной узел сети Tor.
Редактирование посредством Tor запрещено во избежание злоупотреблений.',
	'right-torunblocked' => 'обход автоматической блокировки узлов сети Tor',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'torblock-desc'      => 'Umožňuje bolovať úpravy pochádzajúce z výstupných uzlov siete TOR.',
	'torblock-blocked'   => 'Vaša IP adresa, <tt>$1</tt>, bola automaticky identifikovaná ako výstupný uzol siete TOR.
Aby sa zabránilo zneužitiu, úpravy zo siete TOR sú blokované.',
	'right-torunblocked' => 'Obísť automatické blokovanie výstupných uzlov siete TOR',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'torblock-desc'      => 'Омогућава блокирање измена на викију од стране излазних нодова тора.',
	'torblock-blocked'   => 'Твоја ИП адреса, <tt>$1</tt>, је аутоматски идентификована као излазни нод тора. Измене путем тора су онемогућене због могуће злоупотребе.',
	'right-torunblocked' => 'Прескочи аутоматске блокове излазних нодова тора.',
);

/** Swedish (Svenska)
 * @author Lejonel
 */
$messages['sv'] = array(
	'torblock-desc'      => 'Gör det möjligt att blockera Tors utgångsnoder från att redigera en wiki',
	'torblock-blocked'   => 'Din IP-adress, <tt>$1</tt>, har automatiskt identifierats som en utgångsnod från Tor.
Redigering via Tor är blockerad för att förhindra missbruk.',
	'right-torunblocked' => 'Får redigera från automatiskt blockerade Tor-noder',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'torblock-desc'      => 'Permeti de inpedirghe la modifica de la wiki ai nodi de uscita Tor',
	'torblock-blocked'   => 'El to indirisso IP, <tt>$1</tt>, el xe stà identificà automaticamente come un nodo de uscita Tor.
Le modifiche tramite Tor le xe blocà par evitar abusi.',
	'right-torunblocked' => 'Scavalca i blochi automatici dei nodi de uscita Tor',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'torblock-desc'      => 'Cho phép cấm các nút thoát tor sửa đổi wiki',
	'torblock-blocked'   => 'Địa chỉ IP của bạn, <tt>$1</tt>, đã bị xác định là một nút thoát tor.
Sửa đổi thông qua tor đã bị cấm để tránh lạm dụng.',
	'right-torunblocked' => 'Bỏ qua các lệnh cấm tự động các nút thoát tor',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'torblock-desc'      => '容許tor出口點封鎖響一個wiki嘅編輯',
	'torblock-blocked'   => '你嘅IP地址，<tt>$1</tt>已經被自動認定為一個tor嘅出口點。
經tor嘅編輯已經封鎖以防止濫用。',
	'right-torunblocked' => '繞過tor出口點嘅自動封鎖',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'torblock-desc'      => '容许tor出口点封锁在一个wiki中的编辑',
	'torblock-blocked'   => '您的IP地址，<tt>$1</tt>已经被自动认定为一个tor的出口点。
经tor的编辑已经封锁以防止滥用。',
	'right-torunblocked' => '绕过tor出口点的自动封锁',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Shinjiman
 * @author Alexsh
 */
$messages['zh-hant'] = array(
	'torblock-desc'      => '封鎖使用tor位址發出的匿名編輯',
	'torblock-blocked'   => '您的IP位址<tt>$1</tt>已被系統自動認定為tor的節點，為防止破壞，經由tor發出的匿名編輯已經被封鎖。',
	'right-torunblocked' => '自動繞過tor的節點',
);

