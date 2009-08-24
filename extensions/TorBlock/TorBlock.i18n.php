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
	'tag-tor-description' => 'If this tag is set, an edit was made from a Tor exit node.',
	'tag-tor' => 'Made through tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Whether or not the change was made through a tor exit node',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Mormegil
 * @author Purodha
 */
$messages['qqq'] = array(
	'torblock-desc' => 'Short description of the TorBlock extension, shown in [[Special:Version]]. Do not translate or change links.',
	'right-torunblocked' => '{{doc-right}}

Users with this right are not affected by automatic blocking by [[mw:Extension:TorBlock|Extension:TorBlock]] (and can therefore edit using tor).',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'torblock-desc' => 'Premite que os nodos de salida tor sían bloqueyatos ta editar una wiki',
	'torblock-blocked' => "A suya adreza IP, <tt>$1</tt>, s'ha identificato automaticament como un nodo de salida tor.
Ye bedato d'editar con tor ta pribar abusos.",
	'right-torunblocked' => "Pribar os bloqueyos automaticos d'os nodos tor",
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'torblock-desc' => 'يسمح بمنع عقد خروج التور من تعديل ويكي',
	'torblock-blocked' => 'عنوان الأيبي الخاص بك، <tt>$1</tt>، تم التعرف عليه تلقائيا كعقدة خروج تور.
التعديل من خلال التور ممنوع لمنع التخريب.',
	'right-torunblocked' => 'تفادي عمليات المنع التلقائية لعقد خروج التور',
	'tag-tor-description' => 'لو أن هذا الوسم مضبوط، فإن تعديلا قد حدث من عقدة خروج تور.',
	'tag-tor' => 'معمولة من خلال تور',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'ما إذا كان التعديل قد تم عمله من خلال عقدة خروج تور',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'torblock-desc' => 'بيسمح بمنع عقد خروج التور من تعديل ويكي',
	'torblock-blocked' => 'عنوان الاى بى بتاعك, <tt>$1</tt>, اتعرف عليه اوتوماتيكى كعقدة خروج تور.
التعديل عن طريق التور مقفول علشان نمنع اساءة الاستعمال.',
	'right-torunblocked' => 'اتفادى عمليات المنع الاوتوماتيكية لعقد خروج التور',
	'tag-tor-description' => 'اذا كان الوسم دا مظبوط ، ففى تعديل اتعمل من عقدة خروج Tor.',
	'tag-tor' => 'اتعمل من خلال tor',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'torblock-desc' => "Permite que los nodos de salida tor torguen la edición d'una wiki",
	'torblock-blocked' => "La to direición IP, <tt>$1</tt>, foi identificada automáticamente como un nodu de salida tor.
La edición al traviés de tor ta bloquiada pa prevenir l'abusu.",
	'right-torunblocked' => 'Evita los bloqueos automáticos de los nodos de salida tor',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'torblock-desc' => 'اجازت دن په در بیگ گرهنان په محدود بوتن چه اصلاح یک ویکیء',
	'torblock-blocked' => 'شمی آدرس آی پی, <tt>$1</tt>,اتوماتیکی په داب یک گرهن خروجی سنگ نشان بوتت.
اصلاح کتن چه طرق سنگ(tor) په خاطر جلوگرگ سوء استفاده بند بوتت.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author Cesco
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'torblock-desc' => 'Дазваляе блякаваць магчымасьць рэдагаваньняў для ананімных карыстальнікаў, якія карыстаюцца сеткай Tor',
	'torblock-blocked' => 'Ваш ІР-адрас <tt>$1</tt> быў аўтаматычна ідэнтыфікаваны як выхадны вузел сеткі Tor.
Рэдагаваньне праз Тor заблякаванае для прадухіленьня злоўжываньняў.',
	'right-torunblocked' => 'Абыход аўтаматычнага блякаваньня вузлоў сеткі Tor',
	'tag-tor-description' => 'Калі гэты тэг быў дададзены, рэдагаваньне было зроблена праз выходны вузел Tor.',
	'tag-tor' => 'Зроблена праз Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Ці рэдагаваньне адбылася праз вузел Tor',
);

/** Bulgarian (Български)
 * @author Spiritia
 */
$messages['bg'] = array(
	'torblock-desc' => 'Позволява да се блокира редактирането от изходни възли на TOR-мрежа',
	'torblock-blocked' => 'Вашият IP-адрес, <tt>$1</tt>, е бил автоматично идентифициран като изходен възел на TOR-мрежа.
Редактирането през такива адреси се ограничава с цел предотвратяване на евентуални злоупотреби.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'tag-tor' => 'Graet dre Tor',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'torblock-desc' => 'Omogućuje da se blokiraju tor izlazni čvorovi za uređivanje wikija',
	'torblock-blocked' => 'Vaša IP adresa, <tt>$1</tt>, je automatski otkrivena i označena kao tor izlazni čvor.
Uređivanje preko tora je blokirano da bi se spriječila zloupotreba.',
	'right-torunblocked' => 'Zaobilaženje automatskih blokada tor izlaznih čvorova',
	'tag-tor-description' => 'Ako je ova oznaka postavljenja, izmjena je načinjena od izlaznog Tor čvora.',
	'tag-tor' => 'Napravljeno kroz tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Da li je izmjena izvršena kroz tor izlazni čvor ili ne',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'torblock-blocked' => "La vostra adreça IP <tt>$1</tt> ha estat identificada automàticament com un node de sortida de la xarxa Tor. L'edició a través de Tor està prohibida per a prevenir abusos.",
	'right-torunblocked' => 'Evitar els blocatges automàtics de nodes Tor',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'torblock-desc' => 'Umožňuje blokovat editace pocházející z výstupních uzlů sítě Tor',
	'torblock-blocked' => 'Vaše IP adresa (<tt>$1</tt>) byla automaticky rozpoznána jako výstupní uzel sítě Tor.
Editace prostřednictvím sítě Tor je kvůli prevenci zneužití zablokována.',
	'right-torunblocked' => 'Obcházení automatického blokování výstupních uzlů sítě Tor',
	'tag-tor-description' => 'Pokud je nastavena tato značka, byla editace provedena z výstupního uzlu sítě Tor.',
	'tag-tor' => 'Prostřednictvím Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Zda byla tato editace provedena z výstupního uzlu sítě Tor',
);

/** German (Deutsch)
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'torblock-desc' => 'Ermöglicht die Schreibsperre für Tor-Ausgangsknoten',
	'torblock-blocked' => 'Deine IP-Adresse <tt>$1</tt> wurde automatisch als Tor-Ausgangsknoten identifiziert. Die Seitenbearbeitung in Verbindung mit dem Tor-Netzwerk ist unerwünscht, da die Missbrauchsgefahr sehr hoch ist.',
	'right-torunblocked' => 'Umgehung der automatischen Sperre von Tor-Ausgangsknoten',
	'tag-tor-description' => 'Wenn dieses Tag gesetzt ist, erfolgte die Bearbeitung durch einen Tor-Ausgangsknoten.',
	'tag-tor' => 'Durch einen Tor-Ausgangsknoten',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Änderung erfolgte durch einen Torausgangsknoten',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author MichaelFrey
 */
$messages['de-formal'] = array(
	'torblock-blocked' => 'Ihre IP-Adresse <tt>$1</tt> wurde automatisch als Tor-Ausgangsknoten identifiziert. Die Seitenbearbeitung in Verbindung mit dem Tor-Netzwerk ist unerwünscht, da die Missbrauchsgefahr sehr hoch ist.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'torblock-desc' => 'Zajźujo, aby wuchadne suki TOR wobźěłowali wiki',
	'torblock-blocked' => 'Twója IP-adresa, <tt>$1</tt>, jo se awtomatiski awtentificěrowała ako wuchadny suk TOR.
Wobźěłowanje pśez TOR jo blokěrowane, aby zajźowało znjewužiwanju.',
	'right-torunblocked' => 'Awtomatiske blokěrowanja wuchadnych sukow TOR sw wobinuś',
	'tag-tor-description' => 'Jolic toś ta toflicka jo stajona, jo se změna z wuchadnego modusa TOR pśewjadła.',
	'tag-tor' => 'Pśez TOR pśewjeźony',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Lěc změna jo se cyniła pśez wuchadny suk TOR abo nic',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 */
$messages['el'] = array(
	'torblock-desc' => 'Επιτρέπει να φραγούν κόμβοι εξόδου tor από το να επεξεργράζονται ένα wiki',
	'torblock-blocked' => 'Η διεύθυνση IP σας, <tt>$1</tt>, ταυτοποιήθηκε αυτόματα ως ένας κόμβος εξόδου tor. Η επεξεργασία μέσω tor έχει φραγεί για την αποτροπή κατάχρησης.',
	'right-torunblocked' => 'Παράκαμψη αυτομάτων φραγών για κόμβους εξόδου tor',
	'tag-tor-description' => 'Αν αυτή η ετικέτα έχει τεθεί, μια επεξεργασία έγινε από έναν κόμβο εξόδου Tor.',
	'tag-tor' => 'Έγινε μέσω Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Ανεξάρτητα από το αν η αλλαγή έγινε διαμέσου ενός κόμβου εξόδου tor',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'torblock-desc' => 'Permesas por elignodoj esti forbaritaj kontraŭ redaktado de vikio',
	'torblock-blocked' => "Via IP-adreso, <tt>$1</tt> estis aŭtomate identigita kiel elignodo ''tor''.
Redaktado per ''tor'' estas forbarita por preventi misuzo.",
	'right-torunblocked' => "Preterpasi aŭtomatajn blokojn de elignodoj ''tor''.",
	'tag-tor-description' => 'Se ĉi tiu etikedo estas ŝalta, redakto estis farita de Tor-a elira nodo.',
	'tag-tor' => 'Farita per tor',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'torblock-desc' => 'Permite bloquear nodos de salida tor',
	'torblock-blocked' => 'Su dirección IP, <tt>$1</tt>, ha sido identificada automáticamente como un nodo de salida tor.
Se bloquea editar por tor para prevenir abusos.',
	'right-torunblocked' => "Eludir bloqueos automáticos de nodos de salida ''tor''",
	'tag-tor-description' => 'Si esta marca está presente, una edición ha sido realizada por un nodo de salida Tor.',
	'tag-tor' => 'Hecho por medio de tor',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'torblock-desc' => 'قطع دسترسی خروجی‌های TOR از ویرایش در یک ویکی را ممکن می‌کند',
	'torblock-blocked' => 'نشانی اینترنتی شما، <tt>$1</tt>، به طور خودکار به عنوان یک خروجی TOR شناسایی شده‌است. ویرایش از طریق این نشانی برای جلوگیری از سوء استفاده ممکن نیست.',
	'right-torunblocked' => 'گذر از قطع دسترسی خودکار خروجی‌های TOR',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'torblock-desc' => 'Mahdollistaa tor-poistumissolmujen estämisen.',
	'torblock-blocked' => 'IP-osoitteesi <tt>$1</tt> on tunnistettu Tor-verkon poistumispisteeksi. Muokkaaminen Tor-verkon kautta on estetty väärinkäytösten välttämiseksi.',
	'right-torunblocked' => 'Ohittaa automaattiset Tor-poistumispisteiden estot',
	'tag-tor-description' => 'Jos tämä tägi on asetettu, muokkaus on tehty Tor exit noden kautta.',
	'tag-tor' => 'Tehty torin kautta',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'torblock-desc' => 'Permet de bloquer les modifications d’un wiki depuis les nœuds de sortie Tor',
	'torblock-blocked' => 'Votre adresse IP, <tt>$1</tt>, a été détectée automatiquement comme un nœud de sortie Tor.
Les modifications via Tor sont bloquées pour éviter les abus.',
	'right-torunblocked' => 'Contourner le blocage automatique des nœuds de sortie Tor',
	'tag-tor-description' => 'Si cette balise est activée, une modification a été effectuée depuis un nœud de sortie Tor.',
	'tag-tor' => 'Effectué via Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Si la modification a été faite via un nœud de sortie de Tor',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'torblock-desc' => 'Permite que os nodos de saída Tor sexan bloqueados fronte á edición nun wiki',
	'torblock-blocked' => 'O seu enderezo IP, <tt>$1</tt>, foi identificado automaticamente como un nodo de saída tor.
A edición a través disto está bloqueada para previr o abuso.',
	'right-torunblocked' => 'Esquivar os bloqueos automáticos dos nodos tor de saída',
	'tag-tor-description' => 'Se a etiqueta está fixada é que unha edición foi feita desde un nodo de saída Tor.',
	'tag-tor' => 'Feito a través do Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Pode ser, ou non, que o cambio fose feito a través dun nodo tor de saída',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'torblock-desc' => 'Macht d Schryybsperri fir Tor-Usgangs-Chnote megli',
	'torblock-blocked' => 'Dyyni IP-Adräss <tt>$1</tt> isch automatisch as Tor-Usgangs-Chnote identifiziert wore. D Sytebearbeitig in Verbindig mit em Tor-Netzwärch isch nit gwinscht, wel d Gfohr vun eme Missbruuch seli hoch isch.',
	'right-torunblocked' => 'Di automatisch Sperri vu Tor-Usgangs-Chnote umgoh',
	'tag-tor-description' => 'Wänn des Tag gsetzt wird, isch e Bearbeitig gmacht wore vun eme Tor-Exit-Chnote.',
	'tag-tor' => 'Gmacht dur Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Eb d Änderig dur e TorExit-Chnote gmacht woren isch',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'torblock-desc' => 'אפשרות לחסימת נקודות יציאה של רשת TOR מעריכה בוויקי',
	'torblock-blocked' => 'כתובת ה־IP שלכם, <tt>$1</tt>, זוהתה אוטומטית כנקודת יציאה של רשת TOR. עריכה דרך TOR חסומה כדי למנוע ניצול לרעה.',
	'right-torunblocked' => 'עקיפת חסימות אוטומטיות של נקודות יציאה ברשת TOR',
	'tag-tor-description' => 'אם תגית זו מוגדרת, בוצעה עריכה מנקודת יציאה של רשת TOR',
	'tag-tor' => 'בוצעה דרך רשת TOR',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'האם השינוי בוצע דרך נקודת יציאה של רשת TOR או לא',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'torblock-desc' => 'टॉर एक्झीट नोड्सको विकि संपादनसे ब्लॉक करने की अनुमति देता हैं',
	'torblock-blocked' => 'आपका आईपी एड्रेस, <tt>$1</tt>, अपनेआप टॉर एक्झीट नोड करके पहचाना गया हैं।
गलत इस्तेमाल से बचने के लिये इसे अपनेआप ब्लॉक कर दिया गया हैं।',
	'right-torunblocked' => 'टॉर एक्झीट नोड्सके अपनेआप आये हुए प्रतिबंधोंको नजर अंदाज करें',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'torblock-desc' => 'Omogućava blokiranje tor izlaznih servera od uređivanja na wiki',
	'torblock-blocked' => 'Vaša IP adresa, <tt>$1</tt>, je automatski prepoznata kao tor izlaznog servera.
Uređivanje kroz tor je onemogućeno kako bi se spriječila zloupotreba.',
	'right-torunblocked' => 'Premošćivanje automatskih blokiranja tor izlaznih servera',
	'tag-tor-description' => 'Ukoliko je ova kartica označena, uređivanje je vršeno s Tor mreže.',
	'tag-tor' => 'Uređivano preko tor-mreže',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Bez obzira je li uređivanje učinjeno preko Tor izlaznog čvora',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'torblock-desc' => 'Blokuje wobdźěłanje wikija přez wuchadne suki TOR',
	'torblock-blocked' => 'Twoja IP-adresa, <tt>$1</tt>, je so awtomatisce jako wuchadny suk TOR identifikowała.
Wobdźěłanje přez TOR bu zablokowane, zo by znjewužiću zadźěwało.',
	'right-torunblocked' => 'Awtomatiske blokowanja wuchadnych sukow TOR wobeńć',
	'tag-tor-description' => 'Jeli tuta taflička je stajeny, je so změna z wuchadneho suka Tor činiła.',
	'tag-tor' => 'Přez TOR sčinjeny',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Hač změna je so přez wuchadny suk TOR činiła abo nic',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'torblock-desc' => 'Lehetővé teszi a tor kilépési csomópontokról való szerkesztés blokkolását',
	'torblock-blocked' => 'Az IP-címed (<tt>$1</tt>) automatikusan blokkolva lett, mivel tor végpontként azonosítottuk.
Toron keresztül nem lehet szerkeszteni a visszaélések megakadályozása céljából.',
	'right-torunblocked' => 'bejelentkezés automatikusan blokkolt torvégpontokról',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'torblock-desc' => 'Permitte que le nodos de exito de Tor sia blocate de facer modificationes in un wiki',
	'torblock-blocked' => 'Tu adresse IP, <tt>$1</tt>, ha essite automaticamente identificate como un nodo de exito de Tor.
Le modification via Tor es prohibite pro impedir le abuso.',
	'right-torunblocked' => 'Contornar le blocadas automatic de nodos de exito de Tor',
	'tag-tor-description' => 'Si iste etiquetta es presente, un modification esseva facite ab un nodo de exito de Tor.',
	'tag-tor' => 'Facite via tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Si le modification ha essite facite via un nodo de exito de Tor',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'torblock-desc' => 'Memblokir titik alamat Tor untuk menyunting wiki',
	'torblock-blocked' => 'Alamat IP Anda, <tt>$1</tt> telah diidentifikasi secara otomatis sebagai sebuah titik alamat Tor.
Penyuntingan melalui Tor diblokir untuk mencegah penyalahgunaan.',
	'right-torunblocked' => 'Mengabaikan pemblokiran otomatis terhadap alamat Tor',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'torblock-desc' => 'Permette di bloccare in scrittura exit node tor su una wiki',
	'torblock-blocked' => 'Il tuo indirizzo IP, <tt>$1</tt>, è stato automaticamente identificato come un exit node tor.
La possibilità di editare utilizzando tor è bloccata per impedire abusi.',
	'right-torunblocked' => 'Ignora i blocchi automatici degli exit node tor',
	'tag-tor-description' => 'Se questo tag è impostato, la modifica è stata effettuata da un nodo di uscita della rete Tor.',
	'tag-tor' => 'Effettuato tramite tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Indica se la modifica è stata fatta da un nodo di uscita TOR o meno',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Muttley
 */
$messages['ja'] = array(
	'torblock-desc' => 'Tor の末端ノードからのウィキの編集をブロックできるようにする',
	'torblock-blocked' => 'あなたのIPアドレス <tt>$1</tt> は、Tor の末端ノードであると自動的に認識されました。不正な利用を防止するため、Tor を通しての編集は禁止されています。',
	'right-torunblocked' => 'Tor 末端ノードの自動ブロックを回避する',
	'tag-tor-description' => 'このタグが設定されている場合、Tor 末端ノードから編集がなされました。',
	'tag-tor' => 'Tor を通じてなされた',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'その変更が Tor 末端ノードを通じてなされたかどうか',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'torblock-desc' => "Mblokir titik alamat ''tor'' kanggo nyunting kaca wiki",
	'torblock-blocked' => "Alamat IP panjenengan, <tt>$1</tt> wis diidhèntifikasi sacara otomatis minangka sawijining titik alamat ''tor''.
Panyuntingan liwat ''tor'' diblokir kanggo nyegah salahguna.",
	'right-torunblocked' => "Lirwakna pamblokiran otomatis marang alamat ''tor''",
);

/** Korean (한국어)
 * @author Ilovesabbath
 * @author Kwj2772
 */
$messages['ko'] = array(
	'torblock-desc' => '토르를 이용하는 사용자가 편집하는 것을 차단합니다.',
	'torblock-blocked' => '당신의 IP 주소 <tt>$1</tt>는 자동적으로 토르임이 밝혀졌습니다.
토르를 사용한 편집은 악용을 방지하기 위해 차단되어 있습니다.',
	'right-torunblocked' => '토르 자동 차단을 무시',
	'tag-tor-description' => '이 태그가 설정되어 있으면, 토르를 통해 편집된 것입니다.',
	'tag-tor' => '토르 사용',
	'abusefilter-edit-builder-vars-tor-exit-node' => '토르 출구노드를 통한 변형 여부에 무관하게',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'torblock-desc' => 'Kann et Ändere am Wiki ongerbenge för Metmaacher, di övver <tt>tor</tt> Ußjäng kumme.',
	'torblock-blocked' => 'Ding IP-Adress (<tt>$1</tt>) eß als_enne <tt>tor</tt> Ußjäng äkannt woode.
Änderunge aam Wiki dom_mer övver <tt>tor</tt> nit zolohße,
esu määt och Keiner Dreßß domet.',
	'right-torunblocked' => 'Et Ändere am Wiki övver <tt>tor</tt> Ußjäng zolohße',
	'tag-tor-description' => 'Wann dat Zeijshe jesaz es, kohm die Änderung övver ene <tt>tor</tt> Ußjang.',
	'tag-tor' => 'Övver <tt>tor</tt> Ußjang jemaat',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Of en Änderung övver ene <i lang="en">tor</i>-Ußjang jemaat woode es',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'torblock-desc' => 'Erméiglecht et Ännerunge vun enger Wiki iwwer Tor-Ausgangskniet (tor exit nodes) ze spären',
	'torblock-blocked' => 'Är IP-Adress,  <tt>$1</tt>, gouf automatesch als Tor-ausgangsknuet erkannt.
Ännerungen iwwer Tor si gespaart fir Mëssbrauch ze verhënneren.',
	'right-torunblocked' => 'Automatesch Spär fir Tor-Ausgangskniet ëmgoen',
	'tag-tor-description' => 'Wann dësen Tag gesat ass da gouf eng Ännerung vun engm Tor-Ausgangsknuet gemaach.',
	'tag-tor' => "Duech ''Tor'' gemaach",
	'abusefilter-edit-builder-vars-tor-exit-node' => "Ob d'Ännerungen iwwer en Tor-Ausgangsknuet gemaach goufen",
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'torblock-desc' => 'Maakt bewerke onmeugelik veur tor exitnodes',
	'torblock-blocked' => 'Oew IP-adres, <tt>$1</tt>, is herkend as tor exitnode. Bewerke via tor es niet toegestaon om misbroek te veurkomme.',
	'right-torunblocked' => 'Automatische blokkades van tor exitnodes omzeile',
	'tag-tor-description' => "Es dit label is ingesteldj, is de bewèrking gemaak via 'ne Tor exitnode.",
	'tag-tor' => 'Gemaak mid tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => "Óf de-n angering waal ódder neet is gemaak waenger 'ne tor exitnode",
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'torblock-desc' => 'टॉर एक्झीट नोड्सना विकि संपादनापासून ब्लॉक करण्याची परवानगी देते',
	'torblock-blocked' => 'तुमचा आयपी अंकपत्ता, <tt>$1</tt>, आपोआप टॉर एक्झीट नोड म्हणून ओळखला गेलेला आहे.
गैरवापर टाळण्यासाठी टॉर मधून संपादन करण्यावर बंदी घालण्यात आलेली आहे.',
	'right-torunblocked' => 'टॉर एक्झीट नोड्सच्या आपोआप आलेल्या प्रतिबंधांकडे दुर्लक्ष करा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Izzudin
 */
$messages['ms'] = array(
	'torblock-desc' => 'Membolehkan sekatan terhadap nod keluar Tor',
	'torblock-blocked' => 'Alamat IP anda, <tt>$1</tt>, telah dikenal pasti sebagai nod keluar Tor.
Penyuntingan melalui Tor disekat untuk mengelak penyalahgunaan.',
	'right-torunblocked' => 'Melepasi sekatan nod keluar Tor',
	'tag-tor-description' => 'Label ini menandakan sebuah suntingan dibuat melalui nod keluar Tor.',
	'tag-tor' => 'Dibuat melalui tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Sama ada atau tidak perubahan dibuat melalui buku keluar tor',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'torblock-desc' => 'Verlöövt dat Sperren vun Tor-Utgangsknütten',
	'torblock-blocked' => 'Diene IP-Adress <tt>$1</tt> is automaatsch as Tor-Utgangsknütten kennt worrn. Dat Ännern vun Sieden över en Tor-Nettwark is sperrt, de Gefohr vun Missbruuk is to groot.',
	'right-torunblocked' => 'Ümgahn vun de automaatsche Sperr vun Tor-Utgangsknütten',
	'tag-tor-description' => 'Wenn disse Tag sett is, is de Ännern von en Tor-Utgangsknütten maakt worrn.',
	'tag-tor' => 'Maakt dör Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Wat de Ännern över en Tor-Utgangsknütten maakt worrn is',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'torblock-desc' => 'Maakt bewerken onmogelijk voor tor exitnodes',
	'torblock-blocked' => 'Uw IP-adres, <tt>$1</tt>, is herkend als tor exitnode. Bewerken via tor is niet toegestaan om misbruik te voorkomen.',
	'right-torunblocked' => 'Automatische blokkades van tor exitnodes omzeilen',
	'tag-tor-description' => 'Als dit label is ingesteld, is de bewerking gemaakt via een Tor exitnode.',
	'tag-tor' => 'Gemaakt via tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Of de wijziging wel of niet is gemaakt via een tor exitnode',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 */
$messages['nn'] = array(
	'torblock-desc' => 'Gjer det mogeleg å blokkere Tor-utgangsnodar frå å gjere endringar i ein wiki',
	'torblock-blocked' => 'IP-adressa di, <tt>$1</tt>, har blitt automatisk identifisert som eit utgangsnode frå TOR.
Redigering via TOR er blokkert for å hindre misbruk.',
	'right-torunblocked' => 'Kan redigere frå automatisk blokkerte TOR-nodar',
	'tag-tor-description' => 'Om dette merket er på, vart endringa gjort frå eit Tor-utgangs-knutepunkt.',
	'tag-tor' => 'Gjord gjennom tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Om endringa vart gjord gjennom eit Tor-utgangsknutepunkt.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'torblock-desc' => 'Gjør det mulig å blokkere Tors utgangsnoder fra å redigere en wiki',
	'torblock-blocked' => 'Din IP-adresse, <tt>$1</tt>, har blitt automatisk identifisert som en utgangsnode fra TOR.
Redigering via TOR er blokkert for å forhindre misbruk.',
	'right-torunblocked' => 'Kan redigere fra automatisk blokkerte TOR-noder',
	'tag-tor-description' => 'Om denne taggen er på, ble redigeringen gjort via en Tor-node.',
	'tag-tor' => 'Gjort via tor',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'torblock-desc' => 'Permet als noses de sortida Tor d’èsser blocats en escritura sus un wiki',
	'torblock-blocked' => "Vòstra adreça ip, <tt>$1</tt>, es estada identificada automaticament coma un nos de sortida Tor.
L’edicion per aqueste mejan es blocada per evitar d'abuses.",
	'right-torunblocked' => 'Passar al travèrs dels blocatges dels noses de sortida Tor.',
	'tag-tor-description' => 'Se aquesta balisa es utilizada, alara la modificacion es estada escafada dempuèi un nos de sortida de Tor.',
	'tag-tor' => 'Fach dempuèi tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Se la modificacion es estada facha via un nos de sortida de Tor',
);

/** Polish (Polski)
 * @author Beau
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'torblock-desc' => 'Blokuje możliwość edycji dla użytkowników anonimowych łączących się przez serwery wyjściowe sieci Tor',
	'torblock-blocked' => 'Twój adres IP <tt>$1</tt> został automatycznie zidentyfikowany jako serwer wyjściowy sieci Tor.
Możliwość edycji z wykorzystaniem tej sieci jest zablokowana w celu zapobiegania nadużyciom.',
	'right-torunblocked' => 'Obejście automatycznych blokad zakładanych na serwery wyjściowe sieci Tor',
	'tag-tor-description' => 'Jeżeli ten znacznik jest ustawiony, edycja została wykonana poprzez węzeł wyjściowy sieci TOR.',
	'tag-tor' => 'zrobione poprzez sieć TOR',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Czy zmiana została wprowadzona przez węzeł wyjściowy sieci tor',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'torblock-desc' => 'Permite que nós de saída Tor sejam impedidos de editar um wiki',
	'torblock-blocked' => 'O seu endereço IP, <tt>$1</tt>, foi automaticamente identificado como um nó de saída Tor.
A edição através de Tor está bloqueada para prevenir abusos.',
	'right-torunblocked' => 'Ultrapassar bloqueios automáticos de nós de saída Tor',
	'tag-tor-description' => 'Se esta marca estiver presente, uma edição foi feita de um nó de saída Tor.',
	'tag-tor' => 'Feita através de Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Se mudança foi feita ou não através de um nodo de saída Tor',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'torblock-desc' => 'Permite que nós de saída Tor sejam impedidos de editar um wiki',
	'torblock-blocked' => 'O seu endereço IP, <tt>$1</tt>, foi automaticamente identificado como um nó de saída Tor.
A edição através de Tor está bloqueada para prevenir abusos.',
	'right-torunblocked' => 'Ultrapassar bloqueios automáticos de nós de saída Tor',
	'tag-tor-description' => 'Se esta marca estiver presente, uma edição foi feita de um nó de saída Tor.',
	'tag-tor' => 'Feita através de Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Se a mudança foi feita ou não através de um nó de saída Tor.',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'torblock-desc' => 'Позволяет блокировать выходные узлы сети Tor',
	'torblock-blocked' => 'Ваш IP-адрес, <tt>$1</tt>, был автоматически определён как выходной узел сети Tor.
Редактирование посредством Tor запрещено во избежание злоупотреблений.',
	'right-torunblocked' => 'обход автоматической блокировки узлов сети Tor',
	'tag-tor-description' => 'Если данная метка установлена, значит правка была сделана с выходного узла сети Tor.',
	'tag-tor' => 'Сделано через Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Была ли правка сделана через выходной узел сети Tor',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'torblock-desc' => 'Tor-ситим таһаарар түмүктэрин (выходные узлы) бүөлүүргэ туттуллар',
	'torblock-blocked' => '<tt>$1</tt>, Эн IP-аадырыһыҥ Tor-ситим таһаарар түмүгүн (выходной узел) курдук көстүбүт.
Tor-ситими туһанан уларытыы манна бобуллар.',
	'right-torunblocked' => 'Tor-ситим түмүктэрин аптамаатынан бобууну тумнуу',
	'tag-tor-description' => 'Бу бэлиэ турбут буоллаҕына уларытыы Tor ситимтэн оҥоһуллубут эбит.',
	'tag-tor' => 'Tor нөҥүө оҥоһуллубут',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Көннөрүү Tor ситим нөҥүө оҥоһуллубут дуу суох дуу',
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'torblock-desc' => "Pirmetti di bluccari 'n scrittura exit node tor sù na wiki",
	'torblock-blocked' => 'Lu tò nnirizzu IP, <tt>$1</tt>, vinni ricanusciutu autumaticamenti comu nu exit node tor.
La pussibbilitati di scrìviri utilizzannu tor è bluccata pi non putiri fari abbusi.',
	'right-torunblocked' => "Non pigghiari 'n cunziddirazzioni li blocchi automàtichi di li exit node tor",
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'torblock-desc' => 'Umožňuje bolovať úpravy pochádzajúce z výstupných uzlov siete TOR.',
	'torblock-blocked' => 'Vaša IP adresa, <tt>$1</tt>, bola automaticky identifikovaná ako výstupný uzol siete TOR.
Aby sa zabránilo zneužitiu, úpravy zo siete TOR sú blokované.',
	'right-torunblocked' => 'Obísť automatické blokovanie výstupných uzlov siete TOR',
	'tag-tor-description' => 'Ak je táto značka nastavená, úprava bola vykonaná z výstupného uzla Tor.',
	'tag-tor' => 'Prostredníctvom Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Či bola alebo nebola úprava vykonaná z koncového uzla TOR',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'torblock-desc' => 'Омогућава блокирање измена на викију од стране излазних нодова тора.',
	'torblock-blocked' => 'Твоја ИП адреса, <tt>$1</tt>, је аутоматски идентификована као излазни нод тора. Измене путем тора су онемогућене због могуће злоупотребе.',
	'right-torunblocked' => 'Прескочи аутоматске блокове излазних нодова тора.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'torblock-desc' => 'Moaket ju Schrieuwspeere foar Poute-Uutgongsknätte muugelk',
	'torblock-blocked' => 'Dien IP-Adresse <tt>$1</tt> wuud automatisk as Poute-Uutgongsknät identifizierd. Ju Siedenbeoarbaidenge in Ferbiendenge mäd dät Poute-Nätwierk is nit wonsked, deer ju Misbruuksgefoar gjucht hooch is.',
	'right-torunblocked' => 'Uumgungen fon ju automatiske Speere fon Poute-Uutgongknätte',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 */
$messages['sv'] = array(
	'torblock-desc' => 'Gör det möjligt att blockera Tors utgångsnoder från att redigera en wiki',
	'torblock-blocked' => 'Din IP-adress, <tt>$1</tt>, har automatiskt identifierats som en utgångsnod från Tor.
Redigering via Tor är blockerad för att förhindra missbruk.',
	'right-torunblocked' => 'Får redigera från automatiskt blockerade Tor-noder',
	'tag-tor-description' => 'Om denna taggen är på, så är en redigering gjord från en Tor-nod.',
	'tag-tor' => 'Gjord genom tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Huruvida ändringen gjordes genom en tor utgångsnod',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'torblock-desc' => "Nagpapahintulot na hadlangan/harangin ang labasan ng mga bugkol/alimpuso (''node'') ng bunton ng mga nakikipagugnayang hindi nagpapakilala (mga ''tor'') mula sa paggawa ng pagbabago sa isang wiki",
	'torblock-blocked' => "Ang adres ng IP mo, <tt>$1</tt>, ay kusang nakilala bilang isang bugkol/alimpuso (''node'') ng bunton ng mga nakikipagugnayang hindi nagpapakilala (mga ''tor'') .
Ang paggawa ng pagbabago mula sa isang bunton ng mga nakikipagugnayang hindi nagpapakilala ay hinadlangan upang maiwasan ang pangaabuso.",
	'right-torunblocked' => "Laktawan ang kusang mga paghahadlang ng mga bugkol/alimpuso (''node'') ng bunton ng mga nakikipagugnayang hindi nagpapakilala (mga ''tor'').",
	'tag-tor-description' => 'Kapag nakatakda ang tatak na ito, may isang pagbabagong ginawa mula sa labasang bugkol ng isang Tor.',
	'tag-tor' => 'Ginawa sa pamamagitan ng Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Kung ang pagbabago ay nagawa o hindi sa pamamagitan ng isang labasang bugkol na tor',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'torblock-desc' => 'Tor çıkış nodlarının bir vikiyi değiştirmesinin engellemesini sağlar',
	'torblock-blocked' => 'IP adresiniz, <tt>$1</tt>, otomatik olarak bir tor çıkış nodu olarak algılandı.
Suistimali önlemek için tor üzerinden değişiklik engellendi.',
	'right-torunblocked' => 'Tor çıkış nodlarının otomatik engelini atla',
	'tag-tor-description' => 'Eğer bu etiket ayarlanmışsa, bir Tor çıkış nodundan bir değişiklik yapılmıştır.',
	'tag-tor' => 'Tor üzerinden yapılmıştır',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Değişikliğin bir tor çıkış nodundan yapılıp yapılmadığı',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'torblock-desc' => 'Дозволяє блокувати вихідні вузли мережі Tor',
	'torblock-blocked' => 'Ваша IP-адреса, <tt>$1</tt>, була автоматично визначена як вихідний вузол мережі Tor.
Редагування шляхом Tor заборонене з метою уникнення зловживань.',
	'right-torunblocked' => 'Обхід автоматичного блокування вузлів мережі Tor',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'torblock-desc' => 'Permeti de inpedirghe la modifica de la wiki ai nodi de uscita Tor',
	'torblock-blocked' => 'El to indirisso IP, <tt>$1</tt>, el xe stà identificà automaticamente come un nodo de uscita Tor.
Le modifiche tramite Tor le xe blocà par evitar abusi.',
	'right-torunblocked' => 'Scavalca i blochi automatici dei nodi de uscita Tor',
	'tag-tor-description' => 'Se sto tag el xe presente, vol dir che xe stà fato na modifica atravero un nodo de uscita de Tor.',
	'tag-tor' => 'Fato via Tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Indica se la modifica la xe stà fata da un nodo de uscita TOR opure no',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'torblock-desc' => 'Cho phép cấm các nút thoát tor sửa đổi wiki',
	'torblock-blocked' => 'Địa chỉ IP của bạn, <tt>$1</tt>, đã bị xác định là một nút thoát tor.
Sửa đổi thông qua tor đã bị cấm để tránh lạm dụng.',
	'right-torunblocked' => 'Bỏ qua các lệnh cấm tự động các nút thoát tor',
	'tag-tor-description' => 'Nếu thẻ này được thiết lập, sửa đổi do một nút thoát Tor thực hiện.',
	'tag-tor' => 'Thực hiện nhờ tor',
	'abusefilter-edit-builder-vars-tor-exit-node' => 'Có thay đổi nào thực hiện qua nút thoát tor hay không',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'torblock-desc' => '容許tor出口點封鎖響一個wiki嘅編輯',
	'torblock-blocked' => '你嘅IP地址，<tt>$1</tt>已經被自動認定為一個tor嘅出口點。
經tor嘅編輯已經封鎖以防止濫用。',
	'right-torunblocked' => '繞過tor出口點嘅自動封鎖',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'torblock-desc' => '容许tor出口点封锁在一个wiki中的编辑',
	'torblock-blocked' => '您的IP地址，<tt>$1</tt>已经被自动认定为一个tor的出口点。
经tor的编辑已经封锁以防止滥用。',
	'right-torunblocked' => '绕过tor出口点的自动封锁',
	'tag-tor-description' => '如果这个标签已标记，一个编辑从一个Tor节点中制造。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'torblock-desc' => '封鎖使用tor位址發出的匿名編輯',
	'torblock-blocked' => '您的IP位址<tt>$1</tt>已被系統自動認定為tor的節點，為防止破壞，經由tor發出的匿名編輯已經被封鎖。',
	'right-torunblocked' => '自動繞過tor的節點',
);

