<?php
/**
 * Internationalisation file for the extension PageBy
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

$messages = array();

/** English
 * @author Daniel Kinzler, brightbyte.de
 */
$messages['en'] = array(
	'pageby-desc'         => 'Shows contributors inline on a wiki page using the tag <code><nowiki><pageby></nowiki></code>',
	'pageby-first'        => 'Page created by $1, $2',
	'pageby-last'         => 'Last <a href="$3">modified</a> by $1, $2',
	'pageby-contributors' => 'Contributors:',
	'pageby-anon'         => '<i>anonymous</i>',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 * @author Тест
 */
$messages['qqq'] = array(
	'pageby-desc' => '{{desc}}',
	'pageby-first' => '* $1 link to user page
* $2 timeanddate
* $3 (optional) link to initial version of page',
	'pageby-last' => '* $1 link to user page
* $2 timeanddate
* $3 link to diff (or first revision of page)',
	'pageby-contributors' => '{{Identical|Contributors}}',
	'pageby-anon' => '{{Identical|Anonymous}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'pageby-first' => 'Bladsy geskep deur $1, $2',
	'pageby-last' => 'Laaste <a href="$3">gewysig</a> deur $1, $2',
	'pageby-contributors' => 'Bydraers:',
	'pageby-anon' => '<i>anoniem</i>',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'pageby-desc' => 'يعرض المساهمين في صفحة ويكي متجاورين باستخدام الوسم <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'الصفحة تم إنشاؤها بواسطة $1، $2',
	'pageby-last' => 'تم <a href="$3">تعديلها</a> آخر مرة بواسطة $1، $2',
	'pageby-contributors' => 'مساهمون:',
	'pageby-anon' => '<i>مجهول</i>',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'pageby-first' => 'ܕܦܐ ܐܬܒܪܝܬ ܒܝܕ $1, $2',
	'pageby-contributors' => 'ܫܘܬܦܢ̈ܐ:',
	'pageby-anon' => '<i>ܠܐ ܝܕܝܥܐ</i>',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'pageby-desc' => 'يعرض المساهمين فى صفحة ويكى متجاورين باستخدام الوسم <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'الصفحة تم إنشاؤها بواسطة $1، $2',
	'pageby-last' => 'تم <a href="$3">تعديلها</a> آخر مرة بواسطة $1، $2',
	'pageby-contributors' => 'مساهمون:',
	'pageby-anon' => '<i>مجهول</i>',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'pageby-desc' => 'Паказвае аўтараў у вікі-старонцы з выкарыстаньнем тэга <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Старонка створана {{GENDER:$1|ўдзельнікам|ўдзельніцай}} $1, $2',
	'pageby-last' => 'Апошняе <a href="$3">рэдагаваньне </a> зробленае {{GENDER:$1|ўдзельнікам|ўдзельніцай}} $1, $2',
	'pageby-contributors' => 'Аўтары:',
	'pageby-anon' => '<i>ананім</i>',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'pageby-first' => 'Страницата е създадена от $1, $2',
	'pageby-last' => 'Последно <a href="$3">редактирана</a> от $1, $2',
	'pageby-contributors' => 'Редактори:',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'pageby-contributors' => 'অবদানকারী:',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'pageby-desc' => 'Diskouez a ra an aozerien enlinenn war ur bajenn wiki a ra gant ar valizenn <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Pajenn savet gant $1, $2',
	'pageby-last' => '<a href="$3">Kemmet</a> da ziwezhañ gant $1, $2',
	'pageby-contributors' => 'Aozerien :',
	'pageby-anon' => '<i>dizanv</i>',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'pageby-desc' => 'Prikazuje urednike wiki stranice koristeći oznaku <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Stranicu je napravio $1, dana $2',
	'pageby-last' => 'Zadnji put <a href="$3">izmijenio</a> {{GENDER:$1|korisnik|korisnica}} $1, dana $2',
	'pageby-contributors' => 'Urednici:',
	'pageby-anon' => '<i>anonimni</i>',
);

/** Danish (Dansk)
 * @author Byrial
 */
$messages['da'] = array(
	'pageby-desc' => 'Viser bidragsydere på en wikiside med koden <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Siden er oprettet af $1 $2',
	'pageby-last' => 'Sidst <a href="$3">ændret</a> af $1 $2',
	'pageby-contributors' => 'Bidragsydere:',
	'pageby-anon' => '<i>anonym</i>',
);

/** German (Deutsch)
 * @author Daniel Kinzler
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'pageby-desc' => 'Zeigt die Autoren innerhalb einer Wikiseite. Syntax: <tt><nowiki><pageby></nowiki></tt>',
	'pageby-first' => 'Seite angelegt von $1, $2',
	'pageby-last' => 'Zuletzt <a href="$3">geändert</a> von $1, $2',
	'pageby-contributors' => 'Beiträge:',
	'pageby-anon' => '<i>anonym</i>',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'pageby-desc' => 'Pokazujo awtorow na wikijowem boku z pomocu toflicku <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Bok napórany wót $1, $2',
	'pageby-last' => 'Slědny raz <a href="$3">změnjony</a> wót $1, $2',
	'pageby-contributors' => 'Pśinosowarje:',
	'pageby-anon' => '<i>anonymny</i>',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'pageby-desc' => 'Δείχνει τους συνεισφέροντες σε γραμμή σε μία βικισελίδα χρησιμοποιώντας την ετικέτα <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Η σελίδα δημιουργήθηκε από τον $1, $2',
	'pageby-last' => 'Τελευταία <a href="$3">επεξεργασία</a> από $1, $2',
	'pageby-contributors' => 'Συνεισφέροντες:',
	'pageby-anon' => '<i>ανώνυμος</i>',
);

/** Esperanto (Esperanto)
 * @author Petrus Adamus
 * @author Yekrats
 */
$messages['eo'] = array(
	'pageby-desc' => 'Montras kontribuantojn enlinie en vikia paĝo uzante la etikedon <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Paĝo kreiita de $1, $2',
	'pageby-last' => 'Laste <a href="$3">ŝanĝita</a> de $1, $2',
	'pageby-contributors' => 'Kontribuintoj:',
	'pageby-anon' => '<i>anonima</i>',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Sanbec
 */
$messages['es'] = array(
	'pageby-desc' => 'Muestra las contribuciones hechas en una página usando la etiqueta <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Página creada por $1, $2',
	'pageby-last' => 'ültimo <a href="$3">modificado</a> por $1, $2',
	'pageby-contributors' => 'Contribuyentes:',
	'pageby-anon' => '<i>anónimo</i>',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'pageby-first' => '$1 erabiltzaileak sortutako orrialdea, $2',
	'pageby-last' => 'Azken <a href="$3">aldaketa</a> $1 erabiltzaileak egin zuen, $2',
	'pageby-contributors' => 'Lankideak:',
	'pageby-anon' => '<i>egile ezezaguna</i>',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'pageby-desc' => 'Näyttää muokkaajat wikisivun sisällössä käyttäen tagia <code><nowiki><pageby></nowiki></code>.',
	'pageby-first' => 'Sivun loi $1 $2',
	'pageby-last' => 'Viimeksi <a href="$3">muokannut</a> käyttäjä $1 $2',
	'pageby-contributors' => 'Osallistujat:',
	'pageby-anon' => '<i>nimetön</i>',
);

/** French (Français)
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'pageby-desc' => 'Affiche les contributeurs en ligne sur une page wiki utilisant la balise <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Page créée par $1, $2',
	'pageby-last' => 'Dernière <a href="$3">modification</a> le $1, $2',
	'pageby-contributors' => 'Contributeurs :',
	'pageby-anon' => "''anonymes''",
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 */
$messages['frp'] = array(
	'pageby-contributors' => 'Contributors :',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'pageby-desc' => 'Amosa as contribucións feitas nunha páxina do wiki usando a etiqueta <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Páxina creada por $1, $2',
	'pageby-last' => 'Última  <a href="$3">modificación</a> por $1, $2',
	'pageby-contributors' => 'Colaboradores:',
	'pageby-anon' => '<i>anónimo</i>',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'pageby-desc' => 'Zeigt d Autoren innerhalb vun ere Wikisyte. Syntax: <tt><nowiki><pageby></nowiki></tt>',
	'pageby-first' => 'Syte aagleit vu $1, $2',
	'pageby-last' => 'Zletscht <a href="$3">gänderet</a> von $1, $2',
	'pageby-contributors' => 'Byyträg:',
	'pageby-anon' => '<i>anonym</i>',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'pageby-contributors' => 'Cohoyrtee:',
	'pageby-anon' => '<i>neuenmyssit</i>',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author דניאל ב.
 */
$messages['he'] = array(
	'pageby-desc' => 'הצגת תורמים בתוך דף ויקי באמצעות התג <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'הדף נוצר על ידי $1, $2',
	'pageby-last' => '<a href="$3">השינוי</a> האחרון בוצע על ידי $1, $2',
	'pageby-contributors' => 'תורמים:',
	'pageby-anon' => '<i>אנונימי</i>',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'pageby-first' => '$1 ने पन्ना बनाया, $2',
	'pageby-last' => 'आखिरी <a href="$3">बदलाव</a> $1, $2 ने',
	'pageby-contributors' => 'योगदानकर्ता:',
	'pageby-anon' => '<i>अनामक</i>',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'pageby-desc' => 'Pokazuje přinošowarjow znutřka wikijoweje strony z pomocu taflički <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Strona wutworjena wot $1, $2',
	'pageby-last' => 'Posledni raz <a href="$3">změnjeny</a> wot $1, $2',
	'pageby-contributors' => 'Přinoški:',
	'pageby-anon' => '<i>anonymny</i>',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'pageby-desc' => 'Megjeleníti a közreműködőket a wiki lapon belül a <code><nowiki><pageby></nowiki></code> tag használatával',
	'pageby-first' => 'Az oldalt $1 készítette, $2-kor',
	'pageby-last' => 'Legutoljára $1 <a href="$3">módosította</a>, $2-kor',
	'pageby-contributors' => 'Szerkesztők:',
	'pageby-anon' => '<i>névtelen</i>',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'pageby-first' => 'Էջը ստեղծել է՝',
	'pageby-last' => 'Վերջին <a href="$3">փոփոխության</a> հեղինակն է՝ $1, $2',
	'pageby-contributors' => 'Հեղինակներ.',
	'pageby-anon' => '<i>անանուն</i>',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'pageby-desc' => 'Monstra le contributores de un pagina wiki in le pagina mesme per medio del etiquetta <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Pagina create per $1, $2',
	'pageby-last' => 'Ultime <a href="$3">modification</a> per $1, $2',
	'pageby-contributors' => 'Contributores:',
	'pageby-anon' => '<i>anonyme</i>',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'pageby-desc' => 'Menampilkan kontributor secara transklusi pada sebuah halaman wiki dengan menggunakan tag <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Halaman dibuat oleh $1 pada $2',
	'pageby-last' => '<a href="$3">Diubah</a> terakhir oleh $1 pada $2',
	'pageby-contributors' => 'Kontributor:',
	'pageby-anon' => '<i>anonim</i>',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'pageby-desc' => 'Mostra i contributori su una pagina wiki usando il tag <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Pagina creata da $1 ($2)',
	'pageby-last' => 'Ultima <a href="$3">modifica</a> da parte di $1 ($2)',
	'pageby-contributors' => 'Autori:',
	'pageby-anon' => '<i>anonimo</i>',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Mizusumashi
 */
$messages['ja'] = array(
	'pageby-desc' => '<code><nowiki><pageby></nowiki></code>タグを使って、wikiページに投稿者をインラインで表示する',
	'pageby-first' => '$2に$1により作成されたページ',
	'pageby-last' => '最後の<a href="$3">変更</a>は$2、$1による',
	'pageby-contributors' => '投稿者:',
	'pageby-anon' => '<i>匿名</i>',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'pageby-first' => 'Kaca digawé déning $1, $2',
	'pageby-last' => 'Ing pungkasan <a href="$3">dimodifikasi</a> déning $1, $2',
	'pageby-contributors' => 'Para kontributor:',
	'pageby-anon' => '<i>anonim</i>',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'pageby-desc' => 'បង្ហាញអ្នកចូលរួមចំណែកក្នុងបន្ទាត់នៅលើទំព័រវិគីដោយប្រើប្រាស់ប្លាក<code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'ទំព័រត្រូវបានបង្កើតឡើងដោយ $1, $2',
	'pageby-last' => '<a href="$3">បានកែ</a>ចុងក្រោយ $1, $2',
	'pageby-contributors' => 'អ្នករួមចំណែក៖',
	'pageby-anon' => '<i>អនាមិក</i>',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'pageby-desc' => 'Zeich de Schriever en de Wikisigge aan met <code><nowiki><pageby></nowiki></code>.',
	'pageby-first' => 'Aanjelaat vum $1 ($2)',
	'pageby-last' => 'Zeläz <a href="$3">beärbeidt</a> vum $1 ($2)',
	'pageby-contributors' => 'Beidrähsch:',
	'pageby-anon' => '<i>ne namelose Metmaacher</i>',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'pageby-desc' => "Weist d'Auteuren op enger Wikisäit mat Hëllef vum Tag <code><nowiki><pageby></nowiki></code>",
	'pageby-first' => 'Säit ugefaang vum $1, $2',
	'pageby-last' => 'Lescht <a href="$3">Ännerung</a> vum $1, $2',
	'pageby-contributors' => 'Kontributioune vum:',
	'pageby-anon' => '<i>anonym Benotzer</i>',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'pageby-desc' => 'Прикажува уредувачи на самата вики страница со користење на ознаката <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Страницата е создадена од $1, $2',
	'pageby-last' => 'Последната <a href="$3">измена</a> ја извршил $1, $2',
	'pageby-contributors' => 'Уредувачи:',
	'pageby-anon' => '<i>анонимни</i>',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'pageby-first' => '$1, $2 നാണ്‌ താൾ സൃഷ്ടിച്ചത്',
	'pageby-last' => '$1, $2 നാണ്‌ അവസാനമായി <a href="$3">തിരുത്തിയത്</a>',
	'pageby-contributors' => 'സംഭാവന ചെയ്തവർ:',
	'pageby-anon' => '<i>അജ്ഞാതർ</i>',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'pageby-desc' => '<code><nowiki><pageby></nowiki></code>खूण वापरून योगदानकर्ते एका पानावर क्रमवार दाखवा',
	'pageby-first' => '$1 ने पान निर्माण केले, $2',
	'pageby-last' => 'शेवटचा <a href="$3">बदल</a> $1, $2 ने',
	'pageby-contributors' => 'योगदानकर्ते :',
	'pageby-anon' => '<i>अनामिक</i>',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'pageby-desc' => 'Voegt de tag <code><nowiki><pageby></nowiki></code> toe voor het weergeven van de auteurs van een wikipagina op de pagina zelf',
	'pageby-first' => 'Pagina gemaakt door $1, $2',
	'pageby-last' => 'Laatste <a href="$3">wijziging</a> door $1, $2',
	'pageby-contributors' => 'Redacteuren:',
	'pageby-anon' => '<i>anoniem</i>',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'pageby-desc' => 'Viser forfattarar på innhaldssider med merket <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Sida oppretta av $1 $2',
	'pageby-last' => 'Sist <a href="$3">endra</a> av $1 $2',
	'pageby-contributors' => 'Forfattarar:',
	'pageby-anon' => '<i>anonym</i>',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'pageby-desc' => 'Viser bidragsytere på innholdssider med taggen <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Side opprettet av $1 $2',
	'pageby-last' => 'Sist <a href="$3">endret</a> av $1 $2',
	'pageby-contributors' => 'Bidragsytere:',
	'pageby-anon' => '<i>anonym</i>',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'pageby-desc' => 'Aficha los contributors en linha sus una pagina wiki utilizant la balisa <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Pagina creada per $1, $2',
	'pageby-last' => 'Darrièr <a href="$3">cambiament</a> lo $1, $2',
	'pageby-contributors' => 'Contributors :',
	'pageby-anon' => "''anonims''",
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'pageby-desc' => 'Pokazuje w treści strony jej autorów, wykorzystując do tego znacznik <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Strona utworzona przez $1, $2',
	'pageby-last' => 'Ostatnia <a href="$3">modyfikacja</a> wykonana przez $1, $2',
	'pageby-contributors' => 'Autorzy:',
	'pageby-anon' => '<i>anonimowy</i>',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'pageby-desc' => 'A mosta i contribudor an linia ans na pàgina wiki an dovrand ël tag <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Pàgina creà da $1, $2',
	'pageby-last' => 'Ùltima <a href="$3">modìfica</a> faita da $1, $2',
	'pageby-contributors' => "A l'han contribuì:",
	'pageby-anon' => '<i>anònim</i>',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'pageby-contributors' => 'ونډه وال:',
	'pageby-anon' => '<i>ورکنومی</i>',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'pageby-desc' => 'Mostra os contribuidores de uma página wiki usando o elemento <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Página criada por $1, $2',
	'pageby-last' => '<a href="$3">Modificado</a> pela última vez por $1, $2',
	'pageby-contributors' => 'Contribuidores:',
	'pageby-anon' => '<i>anónimo</i>',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'pageby-desc' => 'Mostra contribuidores dentro de uma página wiki usando a marca <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Página criada por $1, $2',
	'pageby-last' => '<a href="$3">Modificado</a> pela última vez por $1, $2',
	'pageby-contributors' => 'Contribuidores:',
	'pageby-anon' => '<i>anônimo</i>',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'pageby-first' => 'Pagină creată de $1, $2',
	'pageby-last' => 'Utlima dată <a href="$3">modificat</a> de $1, $2',
	'pageby-contributors' => 'Contribuitori:',
	'pageby-anon' => '<i>anonim</i>',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'pageby-desc' => "Face vedè le condrebbutore sus a linèe sus a 'na pàgene de Uicchi ausanne 'u tag <code><nowiki><pageby></nowiki></code>",
	'pageby-first' => 'Vosce ccrejate da $1, $2',
	'pageby-last' => 'Urteme <a href="$3">cangiamende</a> de $1, $2',
	'pageby-contributors' => 'Condrebbutore:',
	'pageby-anon' => '<i>anoneme</i>',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'pageby-desc' => 'Показывает авторов на вики-странице, если на ней указан тег <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Страница создана участником $1, $2',
	'pageby-last' => 'Последнее <a href="$3">изменение</a> сделанно участником $1, $2',
	'pageby-contributors' => 'Внесли вклад:',
	'pageby-anon' => '<i>неизвестный</i>',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'pageby-desc' => 'Zobrazuje prispievateľov priamo na wiki stránke pomocou značky <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Stránku vytvoril $1, $2',
	'pageby-last' => 'Naposledy <a href="$3">zmenil</a> $1, $2',
	'pageby-contributors' => 'Prispievatelia:',
	'pageby-anon' => '<i>anonymní</i>',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'pageby-contributors' => 'Прилози:',
	'pageby-anon' => '<i>анонимно</i>',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'pageby-contributors' => 'Doprinosi:',
	'pageby-anon' => '<i>anonimno</i>',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'pageby-desc' => 'Wiest do Autore binne ne Wikisiede. Syntax: <tt><nowiki><pageby></nowiki></tt>',
	'pageby-first' => 'Siede anlaid fon $1, $2',
	'pageby-last' => 'Toulääst <a href="$3">annerd</a> fon $1, $2',
	'pageby-contributors' => 'Biedraage:',
	'pageby-anon' => '<i>anonym</i>',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'pageby-desc' => 'Visar bidragsgivare på innehållssidor med <code><nowiki><pageby></nowiki></code>-taggen',
	'pageby-first' => 'Sida skapad av $1, $2',
	'pageby-last' => 'Sist <a href="$3">modifierad</a> av $1, $2',
	'pageby-contributors' => 'Bidragsgivare:',
	'pageby-anon' => '<i>anonym</i>',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'pageby-desc' => '<code><nowiki><pageby></nowiki></code> అన్న టాగుని వాడటం ద్వారా ఒక వికీ పేజీలో ఆ పేజీకి తోడ్పడినవారి పేర్లని చూపిస్తుంది',
	'pageby-first' => 'పేజీని సృష్టించినది $1, $2',
	'pageby-last' => 'చివరగా <a href="$3">మార్చినది</a> $1, $2',
	'pageby-contributors' => 'రచయితలు:',
	'pageby-anon' => '<i>అనామకులు</i>',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'pageby-first' => 'Саҳифаи эҷодшуда тавассути $1, $2',
	'pageby-contributors' => 'Ҳиссагузорон:',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'pageby-first' => 'Sahifai eçodşuda tavassuti $1, $2',
	'pageby-contributors' => 'Hissaguzoron:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'pageby-desc' => 'Nagpapakita ng mga tagapag-ambag sa loob ng kahanayan sa ibabaw ng isang pahina ng wiki na gumagamit ng tatak na <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Pahinang nilikha ni $1, $2',
	'pageby-last' => 'Huling <a href="$3">binago</a> ni $1, $2',
	'pageby-contributors' => 'Mga tagapag-ambag:',
	'pageby-anon' => '<i>hindi nagpapakilala</i>',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'pageby-desc' => 'Kullanıcıları <code><nowiki><pageby></nowiki></code> etiketini kullanarak bir viki sayfasında satıriçinde gösterir',
	'pageby-first' => '$1 tarafından oluşturulan sayfa, $2',
	'pageby-last' => 'En son $1 tarafından <a href="$3">değiştirildi</a>, $2',
	'pageby-contributors' => 'Katkıda bulunanlar',
	'pageby-anon' => '<i>anonim</i>',
);

/** ئۇيغۇرچە (ئۇيغۇرچە)
 * @author Sahran
 */
$messages['ug-arab'] = array(
	'pageby-first' => 'بەت قۇرغۇچى $1, $2',
	'pageby-last' => 'ئاخىرقى <a href="$3">ئۆزگەرتكۈچى</a> $1, $2',
	'pageby-contributors' => 'تۆھپىكارلار',
	'pageby-anon' => '<i>ئاتسىز</i>',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'pageby-desc' => 'Показує учасників редагування безпосередньо на вікі-сторінці за допомогою тегу <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Сторінка створена $1 $2',
	'pageby-last' => 'Востаннє <a href="$3">змінювалась</a> $1 $2',
	'pageby-contributors' => 'Автори:',
	'pageby-anon' => '<i>анонім</i>',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'pageby-desc' => "Mostra i contribudori a l'interno de na pagina wiki doparando el tag <code><nowiki><pageby></nowiki></code>",
	'pageby-first' => 'Pagina creà da $1 ($2)',
	'pageby-last' => 'Modificà <a href="$3">l\'ultima olta</a> da $1 ($2)',
	'pageby-contributors' => 'Contribudori:',
	'pageby-anon' => '<i>anonimo</i>',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'pageby-desc' => 'Hiển thị những người đóng góp vào một trang wiki bằng cách sử dụng thẻ <code><nowiki><pageby></nowiki></code>',
	'pageby-first' => 'Trang được tạo ra bởi $1, $2',
	'pageby-last' => '<a href="$3">Sửa đổi</a> lần cuối bởi $1, $2',
	'pageby-contributors' => 'Những người đóng góp:',
	'pageby-anon' => '<i>vô danh</i>',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'pageby-first' => 'Pad pejafon fa geban: $1 tü $2',
	'pageby-last' => '<a href="$3">Votükam</a> lätik fa geban: $1 tü $2',
	'pageby-contributors' => 'Keblünans:',
	'pageby-anon' => '<i>nennemik</i>',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'pageby-first' => 'בלאַט באַשאַפֿן דורך $1, $2',
	'pageby-last' => 'צו לעצט <a href="$3">מאדיפיצירט</a> דורך $1, $2',
	'pageby-contributors' => 'בײַשטײַערער:',
	'pageby-anon' => 'אַנאנים',
);

/** Cantonese (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'pageby-first' => '頁面由$1，響$2創建',
	'pageby-last' => '上次響$2，由$1<a href="$3">修改</a>',
	'pageby-contributors' => '貢獻者:',
	'pageby-anon' => '<i>匿名</i>',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'pageby-first' => '页面由$1，在$2创建',
	'pageby-last' => '上次在$2，由$1<a href="$3">修改</a>',
	'pageby-contributors' => '贡献者:',
	'pageby-anon' => '<i>匿名</i>',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'pageby-first' => '頁面由 $1，在 $2 建立',
	'pageby-last' => '上次在 $2，由 $1 <a href=「$3」>修改</a>',
	'pageby-contributors' => '貢獻者：',
	'pageby-anon' => '<i>匿名</i>',
);

