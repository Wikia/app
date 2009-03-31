<?php
/**
 * Internationalisation file for extension CategoryWatch.
 *
 * @addtogroup Extensions
*/

$messages = array();

/** English
 * @author Nad
 */
$messages['en'] = array(
	'categorywatch-desc' => 'Extends watchlist functionality to include notification about membership changes of watched categories',
	'categorywatch-emailbody' => "Hi $1, you have received this message because you are watching the \"$2\" category.
This message is to notify you that at $3 user $4 $5.",
	'categorywatch-emailsubject' => "Activity involving watched category \"$1\"",
	'categorywatch-catmovein' => "moved $1 into category $2 from $3",
	'categorywatch-catmoveout' => "moved $1 out of category $2 into $3",
	'categorywatch-catadd' => "added $1 to category $2",
	'categorywatch-catsub' => "removed $1 from category $2",
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'categorywatch-desc' => 'Short description of this extension, shown on [[Special:Version]]. Do not translate or change links.',
	'categorywatch-emailbody' => 'This is a tempate for the e-mails sent to the watching user.
* $1 is the name of the watching user,
* $2 is the name of the watched category,
* $3 is combined date and time of the change,
* $4 is the name of the user having made a change to the category,
* $5 is a text describing the change, it is one of {{msg-mw|categorywatch-catmovein}}, {{msg-mw|categorywatch-catmoveout}}, {{msg-mw|categorywatch-catadd}}, or {{msg-mw|categorywatch-catsub}},
* $6 is the date of the change,
* $7 is the time of the change.',
	'categorywatch-catmovein' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is the target category name
* $3 is the source category name',
	'categorywatch-catmoveout' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is the source category name
* $3 is the target category name',
	'categorywatch-catadd' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is a category name',
	'categorywatch-catsub' => 'Substituted as $5 in {{msg-mw|categorywatch-emailbody}}.
* $1 is a page name
* $2 is a category name',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'categorywatch-desc' => 'يمدد وظيفة قائمة المراقبة لتشمل الإخطارات حول تغييرات العضوية للتصنيفات المراقبة',
	'categorywatch-emailbody' => 'مرحبا $1، أنت تلقيت هذه الرسالة لأنك تراقب التصنيف "$2".
هذه الرسالة لإخطارك أنه في $3 المستخدم $4 $5.',
	'categorywatch-emailsubject' => 'النشاط الذي يشمل التصنيف المراقب "$1"',
	'categorywatch-catmovein' => 'نقل $1 إلى التصنيف $2 من $3',
	'categorywatch-catmoveout' => 'نقل $1 من التصنيف $2 إلى $3',
	'categorywatch-catadd' => 'أضاف $1 إلى التصنيف $2',
	'categorywatch-catsub' => 'أزال $1 من التصنيف $2',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'categorywatch-desc' => 'يمدد وظيفة قائمة المراقبة لتشمل الإخطارات حول تغييرات العضوية للتصنيفات المراقبة',
	'categorywatch-emailbody' => 'اهلا و سهلا $1، اتبعتتلك الرسالة دى لأنك بتراقب التصنيف "$2".
 الرساله دى لإخطارك أنه فى $3 اليوزر  $4 $5.',
	'categorywatch-emailsubject' => 'النشاط الذى يشمل التصنيف المراقب "$1"',
	'categorywatch-catmovein' => 'نقل $1 إلى التصنيف $2 من $3',
	'categorywatch-catmoveout' => 'نقل $1 من التصنيف $2 إلى $3',
	'categorywatch-catadd' => 'أضاف $1 إلى التصنيف $2',
	'categorywatch-catsub' => 'ازال $1 من التصنيف $2',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'categorywatch-desc' => 'Увеличава функционалността на списъка за наблюдение и включва оповестяване за промени в наблюдаваните категории',
	'categorywatch-emailbody' => 'Здравейте, $1, получавате това писмо, тъй като категория „$2“ е включена в списъка ви за наблюдение.
Целта на това писмо е да ви информира, че на $3 потребител $4 $5.',
	'categorywatch-catmovein' => 'премести $1 от категория $3 в $2',
	'categorywatch-catmoveout' => 'премести $1 от категория $2 в $3',
	'categorywatch-catadd' => 'добави $1 в категория $2',
	'categorywatch-catsub' => 'премахна $1 от категория $2',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'categorywatch-desc' => 'Proširena funkcionalnost spiska praćenja da se uključe obavijesti o promjena u članstvu praćenih kategorija',
	'categorywatch-emailbody' => 'Zdravo $1, dobili ste ovu poruku jer ste pratili "$2" kategoriju.
Ova poruka služi da Vas obavijesti da je dana $3 korisnik $4 $5.',
	'categorywatch-emailsubject' => 'Aktivnosti koje uključuju praćenje kategorije "$1"',
	'categorywatch-catmovein' => 'ubacio $1 u kategoriju $2 iz $3',
	'categorywatch-catmoveout' => 'premjestio $1 iz kategorije $2 u $3',
	'categorywatch-catadd' => 'dodao $1 u kategoriju $2',
	'categorywatch-catsub' => 'uklonio $1 iz kategorije $2',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'categorywatch-desc' => 'Rozšiřuje možnosti seznamu sledovaných stránek na upozornění o změně členství sledovaných kategorií',
	'categorywatch-emailbody' => 'Dobrá den, $1,

dostali jste tento email, protože sledujete kategorii „$2”.
Toto je oznámení, že $3 uživatel $4 $5.',
	'categorywatch-emailsubject' => 'Aktivita týkající se sledování kategorie „$1”',
	'categorywatch-catmovein' => 'přesunul $1 do kategorie $2 z $3',
	'categorywatch-catmoveout' => 'přesunul $1 z kategorie $2 do $3',
	'categorywatch-catadd' => 'přidal $1 do kategorie $2',
	'categorywatch-catsub' => 'odstranil $1 z kategorie $2',
);

/** German (Deutsch)
 * @author ChrisiPK
 */
$messages['de'] = array(
	'categorywatch-desc' => 'Erweitert die Beobachtungsliste, sodass man Hinweise bekommt, wenn Seiten in beobachtete Kategorien eingetragen oder aus ihnen entfernt werden.',
	'categorywatch-emailbody' => 'Hallo $1, du erhältst diese Nachricht, weil du die Kategorie „$2“ beobachtest.
Diese Nachricht meldet dir, dass Benutzer $4 um $3 $5.',
	'categorywatch-emailsubject' => 'Bearbeitung betreffend beobachtete Kategorie „$1“',
	'categorywatch-catmovein' => '$1 in Kategorie $2 von $3 verschoben hat',
	'categorywatch-catmoveout' => '$1 von Kategorie $2 in $3 verschoben hat',
	'categorywatch-catadd' => '$1 zu Kategorie $2 hinzugefügt hat',
	'categorywatch-catsub' => '$1 aus Kategorie $2 entfernt hat',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'categorywatch-desc' => 'Rozšyrja funkcionalnosć woglědowańkow wó zdźělenje wó změnach cłonkojstwa woglědowanych kategorijow',
	'categorywatch-emailbody' => 'Halo $1, sy dostał toś tu powěsć, dokulaž wobglědujoš kategoriju "$2". Toś ta powěsć ma śi informěrowaś, až $3 wužywaŕ $4 $5.',
	'categorywatch-emailsubject' => 'Aktiwita inkluziwnje wobglědowaneje kategorije "$1"',
	'categorywatch-catmovein' => 'jo pśesunuł $1 z $3 do kategorije $2',
	'categorywatch-catmoveout' => 'jo pśesunuł $1 z kategorije $2 do $3',
	'categorywatch-catadd' => 'jo pśidał $1 ku kategoriji $2',
	'categorywatch-catsub' => 'jo wupórał $1 z kategorije $2',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'categorywatch-desc' => 'Etendas funkciadon de la atentaro por inkluzivi notigado pri ŝanĝoj de membreco de atentitaj kategorioj',
	'categorywatch-emailbody' => 'Saluton $1, vi recivis ĉi tiun mesaĝon ĉar vi atentas la kategorion "$2".
Ĉi tiu mesaĝo notigas vin ke je $3 uzanto $4 $5.',
	'categorywatch-emailsubject' => 'Aktiveco pri atentata kategorio "$1"',
	'categorywatch-catmovein' => 'movis $1 en kategorion $2 de $3',
	'categorywatch-catmoveout' => 'movis $1 el kategorio $2 en $3',
	'categorywatch-catadd' => 'aldonis $1 al kategorio $2',
	'categorywatch-catsub' => 'eligis $1 de kategorio $2',
);

/** Basque (Euskara)
 * @author Theklan
 */
$messages['eu'] = array(
	'categorywatch-desc' => 'Jarraipen zerrendaren funtzionalitatea areagotzen du jarraitutako kategorien kideen aldaketetaz ohartarezteko aukera gehituz.',
	'categorywatch-emailbody' => 'Kaixo $1, "$2" kategoria jarraitzen zaudelako mezu hau jaso duzu.
Mezu hau $4(e)k $3(e)tan $5 duela jakinarazteko da.',
	'categorywatch-emailsubject' => '"$1" kategoria ikusten sorturiko aktibitatea',
	'categorywatch-catmovein' => '$1 $3 kategoriatik $2(e)ra mugitu',
	'categorywatch-catmoveout' => '$1 $3 kategoriatik $2(e)ra atera',
	'categorywatch-catadd' => '$1 $2 kategoria gehitu',
	'categorywatch-catsub' => '$1 $2 kategoriatik kendu',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Vililikku
 */
$messages['fi'] = array(
	'categorywatch-desc' => 'Laajennettu seurantalistatoiminnallisuus, joka sisältää huomautukset seurattujen luokkien jäsenyysmuutoksista.',
	'categorywatch-catmovein' => 'siirrettiin $1 luokkaan $2 luokkaan $3',
	'categorywatch-catmoveout' => 'siirrettiin $1 luokasta $2 luokkaan $3',
	'categorywatch-catadd' => 'lisättiin sivu $1 luokkaan $2',
	'categorywatch-catsub' => 'poistettiin sivu $1 luokasta $2',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Zetud
 */
$messages['fr'] = array(
	'categorywatch-desc' => 'Étend la fonctionnalité de la liste de suivi pour inclure la notification des modifications des membres des catégories suivies.',
	'categorywatch-emailbody' => 'Bonjour $1, vous avez reçu ce message parce que vous êtes en train de suivre la catégorie « $2 ».
Ce message est destiné à vous informer que le $3 l’utilisateur $4 $5.',
	'categorywatch-emailsubject' => 'Activité comprenant la catégorie suivie « $1 »',
	'categorywatch-catmovein' => 'a déplacé $1 dans la catégorie $2 depuis $3',
	'categorywatch-catmoveout' => 'a déplacé $1 de la catégorie $2 vers $3',
	'categorywatch-catadd' => 'a ajouté $1 dans la catégorie $2',
	'categorywatch-catsub' => 'a retiré $1 de la catégorie $2',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'categorywatch-desc' => 'Extende unha función da lista de vixilancia para incluír notificación acerca dos cambios no número de membros e as categorías vixiadas',
	'categorywatch-emailbody' => 'Ola $1, recibiu esta mensaxe porque está a vixiar a categoría chamada "$2".
Esta mensaxe serve para notificarlle que o $3 o usuario $4 $5.',
	'categorywatch-emailsubject' => 'Actividade que envolve a categoría vixiada chamada "$1"',
	'categorywatch-catmovein' => 'moveu $1 á categoría $2 desde $3',
	'categorywatch-catmoveout' => 'moveu $1 desde a categoría $2 á $3',
	'categorywatch-catadd' => 'engadiu $1 á categoría $2',
	'categorywatch-catsub' => 'eliminou $1 da categoría $2',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'categorywatch-desc' => 'Rozšěrja funkcionalitu wobkedźbowanki wo zdźělenje wo změnach čłonstwa wobkedźbowanych kategorijow',
	'categorywatch-emailbody' => 'Witaj $1, sy tutu powěsć dóstał, dokelž wobkedźbuješ kategoriju "$2". Tuta powěsć ći zdźěli, zo dnja $3 wužiwar $4 $5.',
	'categorywatch-emailsubject' => 'Aktiwita inkluziwnje wobkedźbowaneje kategorije "$1"',
	'categorywatch-catmovein' => 'přesuny $1 do kategorije $2 z $3',
	'categorywatch-catmoveout' => 'přesuny $1 z kategorije $2 do $3',
	'categorywatch-catadd' => 'přida $1 kategoriji $2',
	'categorywatch-catsub' => 'wotstroni $1 z kategorije $2',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'categorywatch-desc' => 'Kiegészíti a figyelőlista képességeit egy figyelt kategória tagjaiban történt változásokkal.',
	'categorywatch-emailbody' => 'Szia $1! Ezt az üzenetet azért kapod, mert figyeled a(z) „$2” nevű kategóriát.
Értesítünk, hogy $4 $3-kor $5.',
	'categorywatch-emailsubject' => 'Változás a(z) "$1" nevű figyelt kategóriában',
	'categorywatch-catmovein' => 'áthelyezte a(z) $1 című lapot a(z) $3 kategóriából a(z) $2 kategóriába',
	'categorywatch-catmoveout' => 'áthelyezte a(z) $1 című lapot a(z) $2 kategóriából a(z) $3 kategóriába',
	'categorywatch-catadd' => 'hozzáadta a(z) $1 című lapot a(z) $2 kategóriához',
	'categorywatch-catsub' => 'eltávolította a(z) $1 című lapot a(z) $2 kategóriából',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'categorywatch-desc' => 'Extende le functionalitate del observatorio con le notification del modificationes in paginas que pertine al categorias observate',
	'categorywatch-emailbody' => 'Salute $1, tu ha recipite iste message proque tu observa le categoria "$2".
Iste message es pro notificar te que, le $3, le usator $4 $5.',
	'categorywatch-emailsubject' => 'Activitate involvente le categoria observate "$1"',
	'categorywatch-catmovein' => 'displaciava $1 in categoria $2 ex $3',
	'categorywatch-catmoveout' => 'displaciava $1 ex le categoria $2 in $3',
	'categorywatch-catadd' => 'addeva $1 al categoria $2',
	'categorywatch-catsub' => 'retirava $1 del categoria $2',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'categorywatch-desc' => 'Estende le funzioni degli osservati speciali includendo notifiche dei cambiamenti alle pagine appartenenti alle categorie osservate',
	'categorywatch-emailbody' => 'Ciao $1, hai ricevuto questo messaggio perché stai seguendo la categoria "$2".
Questo messaggio ti avverte che alle $3 l\'utente $4 $5.',
	'categorywatch-emailsubject' => 'Attività che coinvolge la categoria seguita "$1"',
	'categorywatch-catmovein' => 'ha spostato $1 nella categoria $2 da $3',
	'categorywatch-catmoveout' => 'ha spostato $1 dalla categoria $2 a $3',
	'categorywatch-catadd' => 'ha aggiunto $1 alla categoria $2',
	'categorywatch-catsub' => 'ha rimosso $1 dalla categoria $2',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'categorywatch-desc' => 'ウォッチリスト機能を拡張し、ウォッチしているカテゴリにおける所属構成の変更を通知するようにする',
	'categorywatch-emailbody' => 'こんにちは $1、あなたが「$2」カテゴリをウォッチしているため、このメッセージを受け取りました。$3に利用者 $4 が$5ことをお知らせします。',
	'categorywatch-emailsubject' => 'ウォッチしているカテゴリ「$1」に関する変更',
	'categorywatch-catmovein' => '$1をカテゴリ$2へ$3から移した',
	'categorywatch-catmoveout' => '$1をカテゴリ$2から$3へ移した',
	'categorywatch-catadd' => '$1をカテゴリ$2に加えた',
	'categorywatch-catsub' => '$1をカテゴリ$2から外した',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'categorywatch-emailbody' => '$1님 안녕하세요. 당신은 "$2" 분류를 주시하고 있기 때문에 이 메시지를 수신하였습니다.
이 메시지는 $3에 $4가 $5하였다는 것을 알리고자 전달되었습니다.',
	'categorywatch-emailsubject' => '주시된 분류 "$1"에 대한 바뀜',
	'categorywatch-catmovein' => '$1 문서를 $3에서 $2로 이동',
	'categorywatch-catmoveout' => '$1 문서를 분류 $2에서 $3으로 이동',
	'categorywatch-catadd' => '$1 문서를 $2 분류에 추가',
	'categorywatch-catsub' => '$1 문서를 $2 분류에서 제거',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'categorywatch-desc' => 'Deit aan de Oppassleß noch aanhange, dat mer övver Änderunge aan de Leß met Sigge en en Saachjrop Bescheid kritt.',
	'categorywatch-emailbody' => 'Daach $1,

aam $6 öm $7 Uhr hät uns Metmaacher "$4"
$5.

Dat kriss De jesaat, weil De op di Saachjropp "$2" am oppasse bess.

Ene Jrooss vun der {{SITENAME}}.',
	'categorywatch-emailsubject' => 'De Saachjrupp "$1"',
	'categorywatch-catmovein' => '"$1" uss de Saachjropp "$3" jenumme un en de Saachjropp "$2" jedonn.',
	'categorywatch-catmoveout' => '"$1" uss de Saachjropp "$2" erus jenomme un en de Saachjropp "$3" jedonn.',
	'categorywatch-catadd' => '"$1" en de Saachjropp "$2" jedonn.',
	'categorywatch-catsub' => '"$1" uss de Saachjropp "$2" eruss jenumme.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'categorywatch-desc' => "Erweidert d'Fonctionalitéite vun der Iwwerwwaachungslëscht op d'Notifikatioun iwwer déi Säiten déi an der iwwerwaachter Kategorie dr sinn.",
	'categorywatch-emailbody' => 'Bonjour $1, Dir kritt dëse Message well Dir d\'Kategorie "$2" iwwerwaacht.
Dëse Message informéiert iech datt den $3 Auer de Benotzer $4 $5.',
	'categorywatch-emailsubject' => 'Aktivitéit an der iwwerwaachter Kategorie "$1"',
	'categorywatch-catmovein' => "$1 aus der Kategorie $3 an d'Kategorie $2 geréckelt huet",
	'categorywatch-catmoveout' => "$1 aus der Kategorie $2 an d'Kategorie $3 geréckelt huet",
	'categorywatch-catadd' => "$1 an d'Kategorie $2 derbäigesat huet",
	'categorywatch-catsub' => '$1 aus der Kategorie $2 erausgeholl huet',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'categorywatch-desc' => 'Breidt de functie van de volglijst uit met meldingen over wijzigingen in categorielidmaatschap van categorieën op de volglijst',
	'categorywatch-emailbody' => 'Hallo $1.

U ontvangt dit bericht omdat u categorie "$2" op uw volglijst hebt staan.

Hierbij ontvangt u de melding dat gebruiker $4 op $6 om $7 $5.',
	'categorywatch-emailsubject' => 'Activiteit met betrekking tot categorie "$1" op volglijst',
	'categorywatch-catmovein' => '$1 van categorie $3 naar $2 heeft verplaatst',
	'categorywatch-catmoveout' => '$1 van categorie $2 naar $3 heeft verplaatst',
	'categorywatch-catadd' => '$1 aan categorie $2 heeft toegevoegd',
	'categorywatch-catsub' => '$1 uit categorie $2 heeft verwijderd.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'categorywatch-desc' => 'Utvider overvakingslista sin funksjonalitet til òg å gjelda innhaldet i kategoriar',
	'categorywatch-emailbody' => 'Hei, $1. Du mottek denne meldinga av di du overvaker kategorien «$2».
Denne meldinga kjem for å gjera deg merksam på at $3 brukar $4 $5.',
	'categorywatch-emailsubject' => 'Aktivitet i den overvaka kategorien «$1»',
	'categorywatch-catmovein' => 'flytta $1 til kategorien $2 frå $3',
	'categorywatch-catmoveout' => 'flytta $1 frå kategorien $2 til $3',
	'categorywatch-catadd' => 'la til $1 i kategori $2',
	'categorywatch-catsub' => 'fjerna $1 frå kategori $2',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'categorywatch-desc' => 'Utvider overvåkningslistens funsjonalitet til å også omfatte innholdet i kategorier',
	'categorywatch-emailbody' => 'Hei, $1. Du mottar denne beskjeden fordi du overvåker kategorier kategorien «$2».
Du mottar denne beskjeden fordi $4 $5 $3.',
	'categorywatch-emailsubject' => 'Aktivitet i den overvåkede kategorien «$1»',
	'categorywatch-catmovein' => 'flyttet $1 til kategorien $2 fra $3',
	'categorywatch-catmoveout' => 'flyttet $1 fra kategorien $2 til $3',
	'categorywatch-catadd' => 'la til $1 i kategori $2',
	'categorywatch-catsub' => 'fjernet $1 fra kategori $2',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'categorywatch-desc' => 'Espandís la foncionalitat de la lista de seguit per enclure la notificacion de las modificacions dels membres de las categorias seguidas.',
	'categorywatch-emailbody' => 'Adissiatz $1, avètz recebut aqueste messatge perque sètz a seguir la categoria « $2 ».
Aqueste messatge es destinat a vos far saber que lo $3 l’utilizaire $4 $5.',
	'categorywatch-emailsubject' => 'Activitat comprenent la categoria seguida « $1 »',
	'categorywatch-catmovein' => 'a desplaçat $1 dins la categoria $2 dempuèi $3',
	'categorywatch-catmoveout' => 'a desplaçat $1 de la categoria $2 cap a $3',
	'categorywatch-catadd' => 'a apondut $1 dins la categoria $2',
	'categorywatch-catsub' => 'a levat $1 de la categoria $2',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'categorywatch-desc' => 'Rozszerza funkcjonalność listy obserwowanych poprzez powiadamianie o zmianach, jakie zaszły w elementach należących do obserwowanej kategorii.',
	'categorywatch-emailbody' => 'Witaj $1, otrzymujesz tę wiadomość, ponieważ na liście obserwowanych masz kategorię „$2”.
$3 użytkownik $4 $5.',
	'categorywatch-emailsubject' => 'Powiadomienie związane z obserwowaną kategorią „$1”',
	'categorywatch-catmovein' => 'przeniósł $1 do kategorii $2 z $3',
	'categorywatch-catmoveout' => 'przeniósł $1 z kategorii $2 do $3',
	'categorywatch-catadd' => 'dodał $1 do kategorii $2',
	'categorywatch-catsub' => 'usunął $1 z kategorii $2',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'categorywatch-desc' => 'Estende a funcionalidade da lista de vigiados para incluir notificações sobre alterações nos membros de categorias vigiadas',
	'categorywatch-emailbody' => 'Olá, $1.
Você recebeu esta mensagem porque está a vigiar a categoria "$2".
Esta mensagem serve para o notificar de que, em $3, o utilizador $4 $5.',
	'categorywatch-emailsubject' => 'Actividade envolvendo a categoria vigiada "$1"',
	'categorywatch-catmovein' => 'moveu $1 para a categoria $2 a partir de $3',
	'categorywatch-catmoveout' => 'moveu $1 da categoria $2 para $3',
	'categorywatch-catadd' => 'adicionou $1 à categoria $2',
	'categorywatch-catsub' => 'removeu $1 da categoria $2',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'categorywatch-desc' => 'Extinde funcţionalitatea listei de urmărire pentru a include notifcări privind modificările categoriilor urmărite',
	'categorywatch-emailbody' => 'Bună $1, ai primit acest mesaj pentru că urmăreşti categoria "$2".
Prin acest mesaj te anunţăm că la $3 utilizatorul $4 $5.',
	'categorywatch-emailsubject' => 'Activitatea privind categoria urmărită "$1"',
	'categorywatch-catmovein' => 'a mutat $1 în categoria $2 din $3',
	'categorywatch-catmoveout' => 'a mutat $1 din categoria $2 în $3',
	'categorywatch-catadd' => 'a adăugat $1 în categoria $2',
	'categorywatch-catsub' => 'a eliminat $1 din categoria $2',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'categorywatch-desc' => "Stinne le funziune d'a liste de le pàggene condrollete pe includere le notifeche sus a le cangiaminde de le membre e sus a le categorije condrollete",
	'categorywatch-emailbody' => 'Cià $1, tu è ricevute stu mèssagge purcè tu ste condrolle \'a categorije "$2".
Stu mèssagge avène mannete pe notificà a te ca \'u $3 l\'utende $4 $5.',
	'categorywatch-emailsubject' => 'L\'attività include \'a categorija condrollete "$1"',
	'categorywatch-catmovein' => "spustete $1 jndr'à categorije $2 da $3",
	'categorywatch-catmoveout' => "spueste $1 fore d'a categorije $2 jndr'a $3",
	'categorywatch-catadd' => "aggiunge $1 jndr'à categorije $2",
	'categorywatch-catsub' => "live $1 da 'a categorije $2",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'categorywatch-desc' => 'Расширяет функциональность списка наблюдения возможностью уведомлений об изменениях в страницах, входящих в некоторую категорию',
	'categorywatch-emailbody' => 'Привет $1, вы получили это сообщение, потому что следите за категорией «$2»
Это сообщение уведомляет вас о $3 участника $4 $5.',
	'categorywatch-emailsubject' => 'Изменения, затрагивающие наблюдаемую категорию «$1»',
	'categorywatch-catmovein' => 'перенесён $1 в категорию $2 из $3',
	'categorywatch-catmoveout' => 'перенесён $1 из категории $2 в $3',
	'categorywatch-catadd' => 'добавлено $1 в категорию $2',
	'categorywatch-catsub' => 'удалено $1 из категории $2',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'categorywatch-desc' => 'Rozširuje funkcionality zoznamu sledovaných na upozornenia o zmene členstva sledovaných kategórií.',
	'categorywatch-emailbody' => 'Dobrý deň $1, dostali ste túto správu, pretože sledujete kategóriu „$2”.
Toto je oznam, že $3 používateľ $4 $5.',
	'categorywatch-emailsubject' => 'Aktivita týkajúca sa sledovanej kategórie „$1”',
	'categorywatch-catmovein' => 'presunul $1 do kategórie $2 z $3',
	'categorywatch-catmoveout' => 'presunul $1 z kategórie $2 do $3',
	'categorywatch-catadd' => 'pridal $1 do kategórie $2',
	'categorywatch-catsub' => 'odstránil $1 z kategórie $2',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Najami
 */
$messages['sv'] = array(
	'categorywatch-desc' => 'Utökar bevakningslistans funktion för att även meddela om ändringar av innehållet i bevakade kategorier',
	'categorywatch-emailbody' => 'Hej $1, du har fått det här meddelandet för att du bevakar kategorin "$2".
Detta meddelande meddelar dig att $3 användare $4 $5.',
	'categorywatch-emailsubject' => 'Aktivitet i bevakad kategori "$1"',
	'categorywatch-catmovein' => 'flyttade $1 till kategori $2 från $3',
	'categorywatch-catmoveout' => 'flyttade $1 från kategori $2 till $3',
	'categorywatch-catadd' => 'la till $1 i kategori $2',
	'categorywatch-catsub' => 'tog bort $1 från kategori $2',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'categorywatch-desc' => 'Nagpapalawak ng katungkulang pangtalaan ng binabantayan upang maisama ang pagpapahayag ng hinggil sa mga pagbabago sa kasapian ng pinagmamatyagang mga kaurian',
	'categorywatch-emailbody' => 'Kumusta ka $1, natanggap mo ang mensaheng ito dahil binabantayan mo ang kauriang "$2".
Ang mensaheng ito ay para ipagbigay-alam sa iyo na noong $3 si tagagamit $4 ang $5.',
	'categorywatch-emailsubject' => 'Galaw na kasangkot ang binabantayang kauriang "$1"',
	'categorywatch-catmovein' => 'inilipat ang $1 patungo sa kauriang $2 na nagmula sa $3',
	'categorywatch-catmoveout' => 'inilipat ang $1 palabas mula sa kauriang $2 patungo sa $3',
	'categorywatch-catadd' => 'idinagdag ang $1 patungo sa kauriang $2',
	'categorywatch-catsub' => 'tinanggal ang $1 magmula sa kauriang $2',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'categorywatch-desc' => 'Mở rộng chức năng của danh sách theo dõi để thêm thông báo về sự thay đổi trang thành viên của thể loại được theo dõi',
	'categorywatch-emailbody' => 'Xin chào $1, bạn nhận được thư này vì bạn đang theo dõi thể loại    	 	 	 	“$2”.
Chúng tôi muốn báo cho bạn biết là vào lúc $3, thành viên $4 $5.',
	'categorywatch-emailsubject' => 'Hoạt động liên quan đến thể loại đang được theo dõi “$1”',
	'categorywatch-catmovein' => 'đã di chuyển $1 vào thể loại $2 từ $3',
	'categorywatch-catmoveout' => 'đã di chuyển $1 ra khỏi thể loại $2 đến $3',
	'categorywatch-catadd' => 'đã thêm $1 vào thể loại $2',
	'categorywatch-catsub' => 'đã bỏ $1 ra khỏi thể loại $2',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'categorywatch-desc' => 'Mögükon sedi itjäfidik penedas leäktronik tefü votükams in klads pegalädöl.',
	'categorywatch-emailbody' => 'Glidis, o $1! Egetol penedi at bi galädol kladi: "$2". Tü $3, geban: $4 $5.',
	'categorywatch-emailsubject' => 'Jäfed tefü klad pegalädöl: "$1"',
	'categorywatch-catmovein' => 'ätopätükon padi: $1 ini klad: $2 se klad: $3',
	'categorywatch-catmoveout' => 'ätopätükon padi: $1 se klad: $2 ini klad: $3',
	'categorywatch-catadd' => 'äläükon padi: $1 klade: $2',
	'categorywatch-catsub' => 'ämoükon padi: $1 se klad: $2',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'categorywatch-catadd' => '已把$1新增至分类$2',
	'categorywatch-catsub' => '已把$1从分类$2移除',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'categorywatch-catadd' => '已把$1新增至分類$2',
	'categorywatch-catsub' => '已把$1從分類$2移除',
);

