<?php
/**
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'filepage-desc' => 'Modification of the standard MediaWiki file page for video support',
	/* video page */
	'video-page-file-list-header' => 'Appears on these pages',
	'video-page-global-file-list-header' => 'Appears on these wikis',
	'video-page-from-provider' => 'From $1',
	'video-page-expires' => 'Content expires on $1',
	'video-page-views' => '$1 {{PLURAL:$1|View|Views}}',
	'video-page-see-more-info' => 'Show more info',
	'video-page-see-less-info' => 'Show less info',
	'video-page-description-heading' => 'Description',
	'video-page-description-zero-state' => 'There is no description yet.',
	'video-page-add-description-link-text' => 'Add a description.',
	'video-page-default-description-header-and-text' => '==Description==
Enter the description here.',
	'video-page-file-list-pagination' => '$1 of $2',

	/* file page */
	'file-page-replace-button' => 'Replace',
	'file-page-tab-about' => 'About',
	'file-page-tab-history' => 'File History',
	'file-page-tab-metadata' => 'Metadata',
	'file-page-more-links' => 'See full list',
);

/** Message documentation (Message documentation)
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = array(
	'filepage-desc' => '{{desc}}',
	'video-page-file-list-header' => 'Heading for file list on Video File Page',
	'video-page-global-file-list-header' => 'Heading for global usage list on Video File Page',
	'video-page-from-provider' => 'The provider is where we got the video content from.  Some current examples are IGN and Ooyala. Parameters:
* $1 is the provider name.',
	'video-page-expires' => 'After the date specified, the video content will no longer be available to view. Parameters:
* $1 is a date',
	'video-page-views' => 'Shows total number of views (plays) of the video. Parameters:
* $1 - a number of views (integer)
{{Identical|View}}',
	'video-page-see-more-info' => 'Label to uncollapse UI that shows more info',
	'video-page-see-less-info' => 'Label to collapse UI that shows more info',
	'video-page-description-heading' => 'Description heading',
	'video-page-description-zero-state' => 'Placeholder file page content that states there is no description',
	'video-page-add-description-link-text' => 'This is a link that takes you to the edit page where you can add a description for a video or image. The description, once added, will be a section in the file page content.',
	'video-page-file-list-pagination' => 'Pagination for file listing.  e.g. 1 of 2.  $1 is current page, $2 is total pages',
	'file-page-replace-button' => 'Replace button label, hidden in menu button',
	'file-page-tab-about' => 'Navigation tab label for the "about" section on a File Page.
{{Identical|About}}',
	'file-page-tab-history' => 'Navigation tab label for the "File History" section on a File Page.',
	'file-page-tab-metadata' => 'Navigation tab label for the "Metadata" section on a File Page.
{{Identical|Metadata}}',
	'file-page-more-links' => 'A link to the full list of pages that have links to the file on this file page',
);

/** Arabic (العربية)
 * @author Achraf94
 */
$messages['ar'] = array(
	'filepage-desc' => 'تعديل صفحة ملف ميدياويكي القياسية لدعم الفيديو',
	'video-page-file-list-header' => 'يظهر في هذه الصفحات',
	'video-page-global-file-list-header' => 'يظهر في هذه الويكيات',
	'video-page-from-provider' => 'من $1',
	'video-page-expires' => 'انتهاء صلاحية المحتوى في $1',
	'video-page-views' => '$1 {{PLURAL:$1|مشاهدة|عدد المشاهدات}}',
	'video-page-see-more-info' => 'إظهار المزيد من المعلومات',
	'video-page-see-less-info' => 'إظهار معلومات أقل',
	'video-page-description-heading' => 'الوصف',
	'video-page-description-zero-state' => 'لا يوجد وصف حتى الآن.',
	'video-page-add-description-link-text' => 'أضف وصفا.',
	'video-page-default-description-header-and-text' => '==الوصف==
أدخل الوصف هنا.',
	'video-page-file-list-pagination' => '$1 على $2',
	'file-page-replace-button' => 'استبدال',
	'file-page-tab-about' => 'معلومات حول الملف',
	'file-page-tab-history' => 'تاريخ الملف',
	'file-page-tab-metadata' => 'بيانات ميتا',
	'file-page-more-links' => 'انظر القائمة الكاملة',
);

/** Breton (brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'filepage-desc' => 'Kemmañ ar bajenn restr standard MediaWiki evit ar skor video',
	'video-page-file-list-header' => 'A zeus war wel war ar pajennoù-mañ',
	'video-page-global-file-list-header' => 'A zeu war wel war er wikioù-mañ',
	'video-page-from-provider' => 'Diwar $1',
	'video-page-expires' => "d'an $1 ne vo ket mui mat an endac'had",
	'video-page-views' => '$1 {{PLURAL:$1|selladenn|selladennoù}}',
	'video-page-see-more-info' => "Diskwel muioc'h a ditouroù",
	'video-page-see-less-info' => "Diskwel nebeutoc'h a ditouroù",
	'video-page-description-heading' => 'Deskrivadur',
	'video-page-description-zero-state' => "N'eus ket a zeskrivadur c'hoazh.",
	'video-page-add-description-link-text' => 'Ouzhpennañ un deskrivadur.',
	'video-page-default-description-header-and-text' => '==Deskrivadur==
Skrivit amañ an deskrivadur.',
	'video-page-file-list-pagination' => '$1 diwar $2',
	'file-page-replace-button' => "Erlec'hiañ",
	'file-page-tab-about' => 'Diwar-benn',
	'file-page-tab-history' => 'Istor a resr',
	'file-page-tab-metadata' => 'Metaroadennoù',
	'file-page-more-links' => 'Gwelet ar roll klok',
);

/** Catalan (català)
 * @author Luckas
 * @author Marcmpujol
 */
$messages['ca'] = array(
	'filepage-desc' => "Modificación de l'espai MediaWiki de fitxers per a suport de vídeo",
	'video-page-file-list-header' => 'Apareix en aquestes pàgines',
	'video-page-global-file-list-header' => 'Apareix en aquests wikis',
	'video-page-from-provider' => 'De $1',
	'video-page-expires' => 'Expira el $1',
	'video-page-views' => '$1 {{PLURAL:$1|Vista|Vistes}}',
	'video-page-see-more-info' => 'Mostrar més informació',
	'video-page-see-less-info' => 'Mostrar menys informació',
	'video-page-description-heading' => 'Descripció',
	'video-page-description-zero-state' => 'Encara no hi ha cap descripció.',
	'video-page-add-description-link-text' => 'Afegir una descripció.',
	'video-page-default-description-header-and-text' => '==Descripció==
Introdueix la descripció aquí.',
	'video-page-file-list-pagination' => '$1 de $2',
	'file-page-replace-button' => 'Substituir',
	'file-page-tab-about' => 'Sobre',
	'file-page-tab-history' => 'Historial del fitxer',
	'file-page-tab-metadata' => 'Metadades',
	'file-page-more-links' => 'Veure llista completa',
);

/** Danish (dansk)
 * @author Luckas
 */
$messages['da'] = array(
	'video-page-description-heading' => 'Beskrivelse',
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'filepage-desc' => 'Abwandlung der Standard-MediaWiki-Dateiseite für die Videounterstützung',
	'video-page-file-list-header' => 'Erscheint auf diesen Seiten',
	'video-page-global-file-list-header' => 'Erscheint auf diesen Wikis',
	'video-page-from-provider' => 'Von $1',
	'video-page-expires' => 'Inhalt läuft am $1 ab',
	'video-page-views' => '{{PLURAL:$1|Ein Aufruf|$1 Aufrufe}}',
	'video-page-see-more-info' => 'Mehr Informationen anzeigen',
	'video-page-see-less-info' => 'Weniger Informationen anzeigen',
	'video-page-description-heading' => 'Beschreibung',
	'video-page-description-zero-state' => 'Es ist noch keine Beschreibung vorhanden.',
	'video-page-add-description-link-text' => 'Eine Beschreibung hinzufügen.',
	'video-page-default-description-header-and-text' => '== Beschreibung ==
Hier die Beschreibung eingeben.',
	'video-page-file-list-pagination' => '$1 von $2',
	'file-page-replace-button' => 'Ersetzen',
	'file-page-tab-about' => 'Über',
	'file-page-tab-history' => 'Dateiversionen',
	'file-page-tab-metadata' => 'Metadaten',
	'file-page-more-links' => 'Siehe die vollständige Liste',
);

/** Esperanto (Esperanto)
 * @author Luckas
 */
$messages['eo'] = array(
	'video-page-description-heading' => 'Priskribo',
);

/** Spanish (español)
 * @author VegaDark
 */
$messages['es'] = array(
	'filepage-desc' => 'Modificación del espacio MediaWiki de archivos para soporte de vídeo',
	'video-page-file-list-header' => 'Aparece en estas páginas',
	'video-page-global-file-list-header' => 'Aparece en estos wikis',
	'video-page-from-provider' => 'De $1',
	'video-page-expires' => 'Expira el $1',
	'video-page-views' => '$1 {{PLURAL:$1|Vista|Vistas}}',
	'video-page-see-more-info' => 'Mostrar más información',
	'video-page-see-less-info' => 'Mostrar menos información',
	'video-page-description-heading' => 'Descripción',
	'video-page-description-zero-state' => 'Todavía no hay ninguna descripción.',
	'video-page-add-description-link-text' => 'Añadir una descripción.',
	'video-page-default-description-header-and-text' => '==Descripción==
Escribe la descripción aquí.',
	'video-page-file-list-pagination' => '$1 de $2',
	'file-page-replace-button' => 'Reemplazar',
	'file-page-tab-about' => 'Acerca de',
	'file-page-tab-history' => 'Historial del archivo',
	'file-page-tab-metadata' => 'Metadatos',
	'file-page-more-links' => 'Ver lista completa',
);

/** Estonian (eesti)
 * @author KalmerE.
 * @author Luckas
 */
$messages['et'] = array(
	'video-page-file-list-header' => 'Esineb sellel lehel',
	'video-page-global-file-list-header' => 'Esineb selles vikis',
	'video-page-description-heading' => 'Kirjeldus',
	'file-page-more-links' => 'Vaata täielikku nimekirja',
);

/** Finnish (suomi)
 * @author Nike
 * @author Ville96
 */
$messages['fi'] = array(
	'video-page-description-heading' => 'Kuvaus',
	'video-page-description-zero-state' => 'Kuvausta ei ole vielä.',
	'video-page-add-description-link-text' => 'Lisää kuvaus.',
	'video-page-default-description-header-and-text' => '== Kuvaus ==
Lisää kuvaus tähän.',
	'file-page-replace-button' => 'Korvaa',
	'file-page-tab-about' => 'Tietoja',
	'file-page-tab-history' => 'Tiedoston historia',
	'file-page-tab-metadata' => 'Sisältökuvaukset',
	'file-page-more-links' => 'Katso koko lista',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'filepage-desc' => 'Broyting av standard MediaWiki fílusíðuni fyri video-hjálp',
	'video-page-file-list-header' => 'Verður víst á hesum síðum',
	'video-page-global-file-list-header' => 'Verður víst á hesum wikium',
	'video-page-from-provider' => 'Frá $1',
	'video-page-expires' => 'Innihaldið gongur út hin $1',
	'video-page-views' => '$1 {{PLURAL:$1|Sýning|Sýningar}}',
	'video-page-see-more-info' => 'Vís meira kunning',
	'video-page-see-less-info' => 'Vís minni kunning',
	'video-page-description-heading' => 'Frágreiðing',
	'video-page-description-zero-state' => 'Tað er ongin frágreiðing enn.',
	'video-page-add-description-link-text' => 'Skriva eina frágreiðing.',
	'video-page-default-description-header-and-text' => '==Frágreiðing==
Skriva eina frágreiðing her.',
	'video-page-file-list-pagination' => '$1 av $2',
	'file-page-replace-button' => 'Skift út',
	'file-page-tab-about' => 'Um',
	'file-page-tab-history' => 'Fílusøgan',
	'file-page-tab-metadata' => 'Metadáta',
	'file-page-more-links' => 'Sí allan listan',
);

/** French (français)
 * @author Metroitendo
 * @author Wyz
 * @author Y-M D
 */
$messages['fr'] = array(
	'filepage-desc' => 'Modification de la page de fichier standard de MediaWiki pour le support des vidéos',
	'video-page-file-list-header' => 'Apparaît sur ces pages',
	'video-page-global-file-list-header' => 'Apparaît sur ces wikis',
	'video-page-from-provider' => 'De $1',
	'video-page-expires' => 'Le contenu expire le $1',
	'video-page-views' => '$1 {{PLURAL:$1|vue|vues}}',
	'video-page-see-more-info' => "Afficher plus d'informations",
	'video-page-see-less-info' => "Afficher moins d'informations",
	'video-page-description-heading' => 'Description',
	'video-page-description-zero-state' => "Il n'y a pas encore de description.",
	'video-page-add-description-link-text' => 'Ajouter une description.',
	'video-page-default-description-header-and-text' => '==Description==
Saisissez la description ici.',
	'video-page-file-list-pagination' => '$1 sur $2',
	'file-page-replace-button' => 'Remplacer',
	'file-page-tab-about' => 'À propos',
	'file-page-tab-history' => 'Historique du fichier',
	'file-page-tab-metadata' => 'Métadonnées',
	'file-page-more-links' => 'Afficher la liste',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'filepage-desc' => 'Modificación da páxina de ficheiro estándar de MediaWiki para o soporte de vídeo',
	'video-page-file-list-header' => 'Aparece nestas páxinas',
	'video-page-global-file-list-header' => 'Aparece nestes wikis',
	'video-page-from-provider' => 'De $1',
	'video-page-expires' => 'O contido caduca o $1',
	'video-page-views' => '$1 {{PLURAL:$1|visita|visitas}}',
	'video-page-see-more-info' => 'Mostrar máis información',
	'video-page-see-less-info' => 'Mostrar menos información',
	'video-page-description-heading' => 'Descrición',
	'video-page-description-zero-state' => 'Aínda non hai ningunha descrición.',
	'video-page-add-description-link-text' => 'Engada unha descrición.',
	'video-page-default-description-header-and-text' => '==Descrición==
Insira aquí a descrición.',
	'video-page-file-list-pagination' => '$1 de $2',
	'file-page-replace-button' => 'Substituír',
	'file-page-tab-about' => 'Acerca de',
	'file-page-tab-history' => 'Historial do ficheiro',
	'file-page-tab-metadata' => 'Metadatos',
	'file-page-more-links' => 'Ollar a lista completa',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author ExampleTomer
 */
$messages['he'] = array(
	'video-page-description-heading' => 'תיאור',
	'video-page-add-description-link-text' => 'הוספת תיאור.',
	'file-page-tab-about' => 'אודות',
	'file-page-more-links' => 'רשימה מלאה',
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'filepage-desc' => 'A MediaWiki standard fájl-lapjainak módosítása a videók támogatása végett',
	'video-page-file-list-header' => 'Ezeken a lapokon jelenik meg',
	'video-page-global-file-list-header' => 'Ezeken a wikiken jelenik meg',
	'video-page-from-provider' => 'A(z) $1 szolgáltatótól',
	'video-page-expires' => 'A tartalom lejárati dátuma $1',
	'video-page-views' => '{{PLURAL:$1|egy|$1}} megtekintés',
	'video-page-see-more-info' => 'További információk megjelenítése',
	'video-page-see-less-info' => 'Kevesebb információ megjelenítése',
	'video-page-description-heading' => 'Leírás',
	'video-page-description-zero-state' => 'Még nincs külön leírás.',
	'video-page-file-list-pagination' => '$1. (összesen: $2)',
	'file-page-replace-button' => 'Csere',
	'file-page-tab-about' => 'Névjegy',
	'file-page-tab-history' => 'Fájltörténet',
	'file-page-tab-metadata' => 'Metaadatok',
	'file-page-more-links' => 'Teljes lista megtekintése',
);

/** Indonesian (Bahasa Indonesia)
 * @author C5st4wr6ch
 */
$messages['id'] = array(
	'filepage-desc' => 'Modifikasi dari halaman berkas MediaWiki standar untuk dukungan video',
	'video-page-file-list-header' => 'Muncul pada halaman-halaman ini',
	'video-page-global-file-list-header' => 'Muncul pada wiki ini',
	'video-page-from-provider' => 'Dari $1',
	'video-page-description-heading' => 'Deskripsi',
	'video-page-add-description-link-text' => 'Tambahkan deskripsi.',
	'video-page-default-description-header-and-text' => '==Deskripsi==
Masukkan deskripsi di sini.',
	'video-page-file-list-pagination' => '$1 dari $2',
	'file-page-tab-metadata' => 'Metadata',
	'file-page-more-links' => 'Lihat daftar lengkap',
);

/** Italian (italiano)
 * @author Luckas
 */
$messages['it'] = array(
	'video-page-description-heading' => 'Descrizione',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'video-page-from-provider' => 'Vu(n) $1',
	'video-page-see-more-info' => 'Méi Informatioune weisen',
	'video-page-description-heading' => 'Beschreiwung',
	'video-page-description-zero-state' => 'Et ass nach keng Beschreiwung do.',
	'video-page-add-description-link-text' => 'Eng Beschreiwung derbäisetzen.',
	'video-page-default-description-header-and-text' => "== Beschreiwung ==
Gitt d'Beschreiwung hei an.",
	'video-page-file-list-pagination' => '$1 vu(n) $2',
	'file-page-replace-button' => 'Ersetzen',
	'file-page-tab-about' => 'Iwwer',
	'file-page-more-links' => 'Ganz Lëscht weisen',
);

/** Lithuanian (lietuvių)
 * @author Mantak111
 */
$messages['lt'] = array(
	'video-page-description-heading' => 'Aprašymas',
	'video-page-description-zero-state' => 'Čia nėra aprašymo kol kas.',
	'video-page-add-description-link-text' => 'Pridėti aprašymą.',
	'video-page-default-description-header-and-text' => '==Aprašymas==
Įveskite aprašymą čia.',
	'video-page-file-list-pagination' => '$1 iš $2',
	'file-page-replace-button' => 'Pakeisti',
	'file-page-tab-about' => 'Apie',
	'file-page-tab-history' => 'Failų istorija',
	'file-page-tab-metadata' => 'Metaduomenys',
	'file-page-more-links' => 'Žiūrėti visą sąrašą',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 * @author M4r51n
 */
$messages['mk'] = array(
	'filepage-desc' => 'Измена на стандардната податотечна страница за видеоподдршка',
	'video-page-file-list-header' => 'Се јавува на следниве страници',
	'video-page-global-file-list-header' => 'Се јавува на следниве викија',
	'video-page-from-provider' => 'Од $1',
	'video-page-expires' => 'Содржината истекува на $1',
	'video-page-views' => '$1 {{PLURAL:$1|преглед|прегледи}}',
	'video-page-see-more-info' => 'Прикажи повеќе информации',
	'video-page-see-less-info' => 'Помалку информации',
	'video-page-description-heading' => 'Опис',
	'video-page-description-zero-state' => 'Сè уште нема опис',
	'video-page-add-description-link-text' => 'Дајте опис.',
	'video-page-default-description-header-and-text' => '==Опис==
Тука внесете го описот.',
	'video-page-file-list-pagination' => '$1 од $2',
	'file-page-replace-button' => 'Замени',
	'file-page-tab-about' => 'За програмот',
	'file-page-tab-history' => 'Историја на податотеката',
	'file-page-tab-metadata' => 'Метаподатоци',
	'file-page-more-links' => 'Целосен список',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'filepage-desc' => 'Pengubahsuaian halaman fail MediaWiki yang piawai untuk menyokong video',
	'video-page-file-list-header' => 'Muncul di halaman-halaman ini',
	'video-page-global-file-list-header' => 'Muncul di wiki-wiki ini',
	'video-page-from-provider' => 'Daripada $1',
	'video-page-expires' => 'Kandungan luput pada $1',
	'video-page-views' => '$1 Tontonan',
	'video-page-see-more-info' => 'Tunjukkan maklumat lanjut',
	'video-page-see-less-info' => 'Tutup maklumat lanjut',
	'video-page-description-heading' => 'Keterangan',
	'video-page-description-zero-state' => 'Belum ada keterangan.',
	'video-page-add-description-link-text' => 'Berikan keterangan.',
	'video-page-default-description-header-and-text' => '==Keterangan==
Berikan keterangan di sini.',
	'video-page-file-list-pagination' => '$1/$2',
	'file-page-replace-button' => 'Ganti',
	'file-page-tab-about' => 'Perihal',
	'file-page-tab-history' => 'Sejarah Fail',
	'file-page-tab-metadata' => 'Metadata',
	'file-page-more-links' => 'Lihat senarai penuh',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Event
 * @author Laaknor
 */
$messages['nb'] = array(
	'filepage-desc' => 'Modifisering av standard MediaWiki-filside for videostøtte.',
	'video-page-file-list-header' => 'Vises på disse sidene',
	'video-page-global-file-list-header' => 'Vises på disse wikiene',
	'video-page-from-provider' => 'Fra $1',
	'video-page-expires' => 'Innhold går ut på $1',
	'video-page-views' => '$1 {{PLURAL:$1|visning|visninger}}',
	'video-page-see-more-info' => 'Vis mer informasjon',
	'video-page-see-less-info' => 'Vis mindre informasjon',
	'video-page-description-heading' => 'Beskrivelse',
	'video-page-description-zero-state' => 'Det er ingen beskrivelse ennå.',
	'video-page-add-description-link-text' => 'Legg til en beskrivelse.',
	'video-page-default-description-header-and-text' => '== Beskrivelse ==
Legg inn beskrivelse her.',
	'video-page-file-list-pagination' => '$1 av $2',
	'file-page-replace-button' => 'Erstatt',
	'file-page-tab-about' => 'Om',
	'file-page-tab-history' => 'Filhistorikk',
	'file-page-tab-metadata' => 'Metadata',
	'file-page-more-links' => 'Se fullstendig liste',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'filepage-desc' => 'Wijziging van de standaard bestandspagina van MediaWiki voor ondersteuning voor video',
	'video-page-file-list-header' => "Gebruikt op deze pagina's",
	'video-page-global-file-list-header' => "Gebruikt op deze wiki's",
	'video-page-from-provider' => 'Van provider $1',
	'video-page-expires' => 'Inhoud verloopt op $1',
	'video-page-views' => '$1 {{PLURAL:$1|keer}} bekeken',
	'video-page-see-more-info' => 'Meer informatie weergeven',
	'video-page-see-less-info' => 'Minder informatie weergeven',
	'video-page-description-heading' => 'Beschrijving',
	'video-page-description-zero-state' => 'Er is nog geen beschrijving.',
	'video-page-add-description-link-text' => 'Voeg een beschrijving toe.',
	'video-page-default-description-header-and-text' => '== Beschrijving ==

Voeg hier een beschrijving toe.',
	'video-page-file-list-pagination' => '$1 van $2',
	'file-page-replace-button' => 'Vervangen',
	'file-page-tab-about' => 'Over',
	'file-page-tab-history' => 'Bestandsgeschiedenis',
	'file-page-tab-metadata' => 'Metadata',
	'file-page-more-links' => 'Volledige lijst bekijken',
);

/** Polish (polski)
 * @author Sovq
 */
$messages['pl'] = array(
	'filepage-desc' => 'Zmodyfikowana strona pliku dla filmów',
	'video-page-file-list-header' => 'Wykorzystanie na stronach',
	'video-page-global-file-list-header' => 'Wykorzystanie na innych wiki',
	'video-page-from-provider' => 'Od $1',
	'video-page-expires' => 'Wygasa $1',
	'video-page-views' => '$1 {{PLURAL:$1|Wyświetlenie|Wyświetlenia|Wyświetleń}}',
	'video-page-see-more-info' => 'Więcej informacji',
	'video-page-see-less-info' => 'Mniej informacji',
	'video-page-description-heading' => 'Opis',
	'video-page-description-zero-state' => 'Dla tego pliku nie dodano jeszcze opisu.',
	'video-page-add-description-link-text' => 'Dodaj opis',
	'video-page-default-description-header-and-text' => '== Opis ==
Wprowadź opis tutaj.',
	'video-page-file-list-pagination' => '$1 z $2',
	'file-page-replace-button' => 'Zastąp',
	'file-page-tab-about' => 'Opis',
	'file-page-tab-history' => 'Historia pliku',
	'file-page-tab-metadata' => 'Metadane',
	'file-page-more-links' => 'Zobacz pełną listę',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'file-page-tab-about' => 'په اړه',
	'file-page-tab-history' => 'د دوتنې پېښليک',
	'file-page-tab-metadata' => 'مېټاډاټا',
	'file-page-more-links' => 'بشپړ لړليک کتل',
);

/** Portuguese (português)
 * @author Luckas
 */
$messages['pt'] = array(
	'video-page-from-provider' => 'De $1',
	'video-page-description-heading' => 'Descrição',
	'video-page-file-list-pagination' => '$1 de $2',
	'file-page-replace-button' => 'Substituir',
	'file-page-tab-about' => 'Sobre',
	'file-page-tab-history' => 'Histórico do arquivo',
	'file-page-tab-metadata' => 'Metadados',
	'file-page-more-links' => 'Ver lista completa',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Luckas
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'filepage-desc' => 'Modificação da página do arquivo MediaWiki padrão para suporte de vídeo',
	'video-page-file-list-header' => 'Aparece nestas páginas',
	'video-page-global-file-list-header' => 'Aparece nestas wikis',
	'video-page-from-provider' => 'De $1',
	'video-page-expires' => 'Conteúdo expirará em $1',
	'video-page-views' => '$1 {{PLURAL:$1|visualização|visualizações}}',
	'video-page-see-more-info' => 'Mostrar mais informações',
	'video-page-see-less-info' => 'Mostrar menos informações',
	'video-page-description-heading' => 'Descrição',
	'video-page-description-zero-state' => 'Ainda não há uma descrição.',
	'video-page-add-description-link-text' => 'Adicionar uma descrição.',
	'video-page-default-description-header-and-text' => '==Descrição==
Insira a descrição aqui.',
	'video-page-file-list-pagination' => '$1 de $2',
	'file-page-replace-button' => 'Substituir',
	'file-page-tab-about' => 'Sobre',
	'file-page-tab-history' => 'Histórico do arquivo',
	'file-page-tab-metadata' => 'Metadados',
	'file-page-more-links' => 'Ver lista completa',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'filepage-desc' => "Cangiaminde d'a pàgene d'u file standàrd de MediaUicchi pe supportà le video",
	'video-page-file-list-header' => 'Iesse sus a aste pàggene',
	'video-page-global-file-list-header' => 'Iesse sus a ste uicchi',
	'video-page-from-provider' => 'Da $1',
	'video-page-expires' => "Condenute ca scade 'u $1",
	'video-page-views' => '$1 {{PLURAL:$1|Viste}}',
	'video-page-see-more-info' => "Fà vedè cchiù 'mbormaziune",
	'video-page-see-less-info' => "Fà vedè mene 'mbormaziune",
	'video-page-description-heading' => 'Descrizione',
	'video-page-description-zero-state' => "Non ge stè angore 'na descrizione.",
	'video-page-add-description-link-text' => "Aggiunge 'na descrizione.",
	'video-page-default-description-header-and-text' => "== Descrizione ==
Mitte 'a descrizione aqquà.",
	'video-page-file-list-pagination' => '$1 de $2',
	'file-page-replace-button' => 'Sostituisce',
	'file-page-tab-about' => 'Sus a',
	'file-page-tab-history' => 'Cunde',
	'file-page-tab-metadata' => 'Metadata',
	'file-page-more-links' => "'Ndruche l'elenghe comblete",
);

/** Russian (русский)
 * @author Lunacy1911
 * @author Okras
 */
$messages['ru'] = array(
	'filepage-desc' => 'Модификация стандартной файловой страницы MediaWiki для поддержки видео',
	'video-page-file-list-header' => 'Присутствует на этих страницах',
	'video-page-global-file-list-header' => 'Появляется в следующих проектах',
	'video-page-from-provider' => 'Из $1',
	'video-page-expires' => 'Содержимое истекает $1',
	'video-page-views' => '$1 {{PLURAL:$1|просмотр|просмотров}}',
	'video-page-see-more-info' => 'Показать подробнее',
	'video-page-see-less-info' => 'Показать меньше',
	'video-page-description-heading' => 'Описание',
	'video-page-description-zero-state' => 'Описание пока отсутствует.',
	'video-page-add-description-link-text' => 'Добавить описание.',
	'video-page-default-description-header-and-text' => '== Описание ==
Введите описание здесь.',
	'video-page-file-list-pagination' => '$1 из $2',
	'file-page-replace-button' => 'Заменить',
	'file-page-tab-about' => 'О приложении',
	'file-page-tab-history' => 'Посмотреть историю',
	'file-page-tab-metadata' => 'Метаданные',
	'file-page-more-links' => 'Просмотреть полный список',
);

/** Slovenian (slovenščina)
 * @author Eleassar
 */
$messages['sl'] = array(
	'video-page-add-description-link-text' => 'Dodajte opis.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Milicevic01
 */
$messages['sr-ec'] = array(
	'video-page-add-description-link-text' => 'Додајте опис',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'filepage-desc' => 'Ändring av MediaWikis standardfilsida för videostöd',
	'video-page-file-list-header' => 'Visas på dessa sidor',
	'video-page-global-file-list-header' => 'Visas på dessa wikis',
	'video-page-from-provider' => 'Från $1',
	'video-page-expires' => 'Innehållet upphör den $1',
	'video-page-views' => '$1 {{PLURAL:$1|visning|visningar}}',
	'video-page-see-more-info' => 'Visa mer information',
	'video-page-see-less-info' => 'Visa mindre information',
	'video-page-description-heading' => 'Beskrivning',
	'video-page-description-zero-state' => 'Det finns ingen beskrivning ännu.',
	'video-page-add-description-link-text' => 'Lägg till en beskrivning.',
	'video-page-default-description-header-and-text' => '== Beskrivning ==
Ange en beskrivning här.',
	'video-page-file-list-pagination' => '$1 av $2',
	'file-page-replace-button' => 'Ersätt',
	'file-page-tab-about' => 'Om',
	'file-page-tab-history' => 'Filhistorik',
	'file-page-tab-metadata' => 'Metadata',
	'file-page-more-links' => 'Se hela listan',
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 */
$messages['tr'] = array(
	'filepage-desc' => 'Video desteği için standart MediaWiki dosya sayfasının modifikasyonu',
	'video-page-file-list-header' => 'Bu sayfalarda görüntülenir',
	'video-page-global-file-list-header' => 'Bu wiki üzerinde görünür',
	'video-page-from-provider' => 'Gönderen $1',
	'video-page-expires' => 'İçeriğin son kullanma tarihi $1',
	'video-page-views' => '$1 {{PLURAL:$1|Görünüm|Görünümler}}',
	'video-page-see-more-info' => 'Daha fazla bilgi göster',
	'video-page-see-less-info' => 'Daha az bilgi göster',
	'video-page-description-heading' => 'Açıklama',
	'video-page-description-zero-state' => 'Henüz hiçbir açıklama yoktur.',
	'video-page-add-description-link-text' => 'Bir açıklama ekleyin.',
	'video-page-default-description-header-and-text' => '== Açıklama ==
Açıklamasını buraya girin.',
	'video-page-file-list-pagination' => "$1, $2'de",
	'file-page-replace-button' => 'Değiştir',
	'file-page-tab-about' => 'Hakkında',
	'file-page-tab-history' => 'Dosya Geçmişi',
	'file-page-tab-metadata' => 'Metaveri',
	'file-page-more-links' => 'Tam listesine bakın',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Ата
 */
$messages['uk'] = array(
	'filepage-desc' => 'Модифікація стандартної MediaWiki-сторінки файлу для підтримки відео',
	'video-page-file-list-header' => "З'являється на цих сторінках",
	'video-page-global-file-list-header' => "З'являється на цих вікі",
	'video-page-from-provider' => 'З $1',
	'video-page-expires' => 'Вміст закінчується на $1',
	'video-page-views' => '$1 {{PLURAL:$1|перегляд|перегляди|переглядів}}',
	'video-page-see-more-info' => 'Показати додаткову інформацію',
	'video-page-see-less-info' => 'Показати менше інформації',
	'video-page-description-heading' => 'Опис',
	'video-page-description-zero-state' => 'Ще немає опису.',
	'video-page-add-description-link-text' => 'Додати опис',
	'video-page-default-description-header-and-text' => '= = Опис = =
Введіть опис тут.',
	'video-page-file-list-pagination' => '$1 з $2',
	'file-page-replace-button' => 'Замінити',
	'file-page-tab-about' => 'Про файл',
	'file-page-tab-history' => 'Історія файлу',
	'file-page-tab-metadata' => 'Метадані',
	'file-page-more-links' => 'Див. повний список',
);

/** Urdu (اردو)
 * @author Noor2020
 */
$messages['ur'] = array(
	'filepage-desc' => 'تبدیلی برائے ویڈیو کی سہولت کے لیے معیاری ویکی میڈیا صفحہ',
	'video-page-file-list-header' => 'ان صفحات پر ظاہر ہوتا ہے',
	'video-page-global-file-list-header' => 'ان وکیات پر ظاہر ہوتا ہے',
	'video-page-from-provider' => 'از $1',
	'video-page-expires' => 'اختتام مدت مواد بر$1',
	'video-page-views' => '$1 {{PLURAL:$1|View|خیالات}}',
	'video-page-see-more-info' => 'مزید معلومات نمایش کریں',
	'video-page-see-less-info' => 'معلومات نمائش مختصر کریں',
	'video-page-description-heading' => 'تفصیل',
	'video-page-description-zero-state' => 'ابھی تک کوئی تفصیل دستیاب نہیں ہے ۔',
	'video-page-file-list-pagination' => '$1 کا $2',
	'file-page-replace-button' => 'بدل دو',
	'file-page-tab-about' => 'بابت',
	'file-page-tab-history' => 'ملف کی تاریخ',
	'file-page-tab-metadata' => 'میٹا ڈیٹا',
	'file-page-more-links' => 'مکمل فہرست دیکھیں',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Hzy980512
 * @author Kuailong
 * @author Liuxinyu970226
 * @author Qiyue2001
 */
$messages['zh-hans'] = array(
	'filepage-desc' => '为了支持视频而修改标准MediaWiki文件页面',
	'video-page-file-list-header' => '出现在这些页面上',
	'video-page-from-provider' => '来自$1',
	'video-page-views' => '$1次浏览',
	'video-page-see-more-info' => '显示更多信息',
	'video-page-see-less-info' => '显示较少信息',
	'video-page-description-heading' => '描述',
	'video-page-description-zero-state' => '现在还没有描述。',
	'video-page-add-description-link-text' => '添加说明。',
	'video-page-default-description-header-and-text' => '==说明==
在这里输入说明。',
	'video-page-file-list-pagination' => '$2的$1',
	'file-page-replace-button' => '取代',
	'file-page-tab-about' => '关于',
	'file-page-tab-history' => '文件历史',
	'file-page-tab-metadata' => '元数据',
	'file-page-more-links' => '查看完整列表',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Simon Shek
 */
$messages['zh-hant'] = array(
	'video-page-from-provider' => '出自$1',
	'video-page-description-heading' => '描述',
	'video-page-add-description-link-text' => '添加說明。',
	'file-page-replace-button' => '取代',
	'file-page-tab-about' => '關於',
	'file-page-more-links' => '查看完整清單',
);

/** Chinese (Hong Kong) (中文（香港）‎)
 * @author Tcshek
 */
$messages['zh-hk'] = array(
	'video-page-file-list-header' => '在以下頁面中出現',
	'file-page-tab-history' => '檔案歷史',
);
