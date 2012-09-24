<?php
/**
* Internationalisation file for the AdminDashboard extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'quickstats-header-label' => 'Quick Stats',
	'quickstats-header-date' => 'Date',
	'quickstats-header-views' => 'Views',
	'quickstats-header-edits' => 'Edits',
	'quickstats-header-photos' => 'Photos',
	'quickstats-header-likes' => 'Likes',
	'quickstats-date-format' => 'M d',	// follow this guide: http://php.net/manual/en/function.date.php
	'quickstats-totals-label' => 'Totals',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|See more stats]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'quickstats-date-format' => 'Follow this guide: http://php.net/manual/en/function.date.php.',
	'quickstats-number-shortening' => 'This is a shortend number abbreviation shown in a stats table. Number larger than 10.000 are rendered using this message (as thousands rounded up to the first decimal fraction). K stands for thousands (1.000)',
	'quickstats-number-shortening-millions' => 'This is a shortend number abbreviation shown in a stats table. Number between 1.000.000 and 999.999.999.999 are rendered using this message (as millions rounded up to the first decimal fraction). M stands for millions (1.000.000)',
	'quickstats-number-shortening-billions' => 'This is a shortend number abbreviation shown in a stats table. Number larger than 1.000.000.000 are rendered using this message (as billions rounded up to the first decimal fraction). B stands for billions (1.000.000.000)',
);

/** Tati (Tati)
 * @author Erdemaslancan
 */
$messages['ttt'] = array(
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|istatistikan diyin]]',
);

/** Arabic (العربية)
 * @author Achraf94
 */
$messages['ar'] = array(
	'quickstats-header-label' => 'إحصائيات سريعة',
	'quickstats-header-date' => 'التاريخ',
	'quickstats-header-views' => 'المشاهدات',
	'quickstats-header-edits' => 'التعديلات',
	'quickstats-header-photos' => 'الصور',
	'quickstats-header-likes' => 'الإعجابات',
	'quickstats-totals-label' => 'المجموع',
	'quickstats-see-more-stats-link' => '[[خاص:WikiStats|شاهد المزيد من الإحصائيات]]',
	'quickstats-number-shortening' => '$1K',
);

/** Assamese (অসমীয়া)
 * @author Bishnu Saikia
 */
$messages['as'] = array(
	'quickstats-header-date' => 'তাৰিখ',
	'quickstats-header-edits' => 'সম্পাদনাসমূহ',
	'quickstats-header-photos' => 'চিত্ৰসমূহ',
	'quickstats-header-likes' => 'পছন্দসমূহ',
	'quickstats-totals-label' => 'মুঠ',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 * @author Melikov Memmed
 * @author Vago
 */
$messages['az'] = array(
	'quickstats-header-date' => 'Tarix',
	'quickstats-header-views' => 'Görünüş',
	'quickstats-header-edits' => 'Redaktələr',
	'quickstats-header-photos' => 'Şəkillər',
	'quickstats-totals-label' => 'Yekunu',
	'quickstats-number-shortening' => '$1K',
);

/** Bashkir (башҡортса)
 * @author ҒатаУлла
 */
$messages['ba'] = array(
	'quickstats-header-label' => 'Вики статистикаһы',
	'quickstats-header-date' => 'Дата',
	'quickstats-header-views' => 'Ҡарауҙар',
	'quickstats-header-edits' => 'Үҙгәртеүҙәр',
	'quickstats-header-photos' => 'Фото',
	'quickstats-header-likes' => 'Оҡшай',
	'quickstats-totals-label' => 'Барыһы',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Тағын статистика]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1милл.',
	'quickstats-number-shortening-billions' => '$1миллиард',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'quickstats-header-date' => 'Дата',
	'quickstats-header-edits' => 'Редакции',
	'quickstats-header-photos' => 'Снимки',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'quickstats-header-label' => 'Stadegoù prim',
	'quickstats-header-date' => 'Deiziad',
	'quickstats-header-views' => 'Gweladennoù',
	'quickstats-header-edits' => 'Kemmoù',
	'quickstats-header-photos' => "Luc'hskeudennoù",
	'quickstats-header-likes' => 'Plijout a ra din',
	'quickstats-totals-label' => 'Hollad',
	'quickstats-see-more-stats-link' => "[[Special:WikiStats|Gwelet muioc'h a stadegoù]]",
	'quickstats-number-shortening' => '$1K',
);

/** Catalan (català)
 * @author CuBaN VeRcEttI
 */
$messages['ca'] = array(
	'quickstats-header-label' => 'Estadístiques ràpides',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visites',
	'quickstats-header-edits' => 'Edicions',
	'quickstats-header-photos' => 'Fotos',
	'quickstats-header-likes' => 'Gustos',
	'quickstats-totals-label' => 'Totals',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Veure més estadístiques]]',
	'quickstats-number-shortening' => '$1K',
);

/** Czech (česky)
 * @author Chmee2
 * @author Darth Daron
 */
$messages['cs'] = array(
	'quickstats-header-label' => 'Stručná statistika',
	'quickstats-header-date' => 'Datum',
	'quickstats-header-views' => 'Zobrazení',
	'quickstats-header-edits' => 'Úpravy',
	'quickstats-header-photos' => 'Fotografie',
	'quickstats-header-likes' => 'To se mi líbí',
	'quickstats-totals-label' => 'Celkem',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Další statistiky]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** German (Deutsch)
 * @author LWChris
 * @author PtM
 */
$messages['de'] = array(
	'quickstats-header-label' => 'Ministatistik',
	'quickstats-header-date' => 'Datum',
	'quickstats-header-views' => 'Aufrufe',
	'quickstats-header-edits' => 'Bearbeitungen',
	'quickstats-header-photos' => 'Fotos',
	'quickstats-header-likes' => 'Likes',
	'quickstats-totals-label' => 'Gesamt',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Weitere Statistiken]]',
	'quickstats-number-shortening' => '$1k',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'quickstats-header-label' => 'İstatıstike vistri',
	'quickstats-header-date' => 'Deme',
	'quickstats-header-views' => 'Bıvin',
	'quickstats-header-edits' => 'Bıvurne',
	'quickstats-header-photos' => 'Fotrafi',
	'quickstats-header-likes' => 'Rındeni',
	'quickstats-totals-label' => 'Pêro piya',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|istatistiki bıvin]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Esperanto (Esperanto)
 * @author Tradukisto
 */
$messages['eo'] = array(
	'quickstats-header-date' => 'Dato',
	'quickstats-header-edits' => 'Redaktoj',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Bola
 * @author VegaDark
 */
$messages['es'] = array(
	'quickstats-header-label' => 'Estadísticas rápidas',
	'quickstats-header-date' => 'Fecha',
	'quickstats-header-views' => 'Páginas vistas',
	'quickstats-header-edits' => 'Ediciones',
	'quickstats-header-photos' => 'Imágenes',
	'quickstats-header-likes' => 'Me gusta',
	'quickstats-totals-label' => 'Total',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Ver más estadísticas]]',
	'quickstats-number-shortening' => '$1m',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Estonian (eesti)
 * @author KalmerE.
 */
$messages['et'] = array(
	'quickstats-header-date' => 'Kuupäev',
	'quickstats-header-views' => 'Vaatamisi',
	'quickstats-header-edits' => 'Muudatusi',
	'quickstats-header-photos' => 'Fotod',
	'quickstats-totals-label' => 'Kokku',
);

/** Persian (فارسی)
 * @author Reza1615
 * @author جواد
 */
$messages['fa'] = array(
	'quickstats-header-date' => 'تاریخ',
	'quickstats-header-views' => 'بازدیدها',
	'quickstats-header-edits' => 'ویرایش‌ها',
	'quickstats-header-photos' => 'عکس‌ها',
	'quickstats-totals-label' => 'مجموع',
);

/** Finnish (suomi)
 * @author Ilkea
 * @author VezonThunder
 */
$messages['fi'] = array(
	'quickstats-header-label' => 'Pikatilastot',
	'quickstats-header-date' => 'Päivämäärä',
	'quickstats-header-views' => 'Latauksia',
	'quickstats-header-edits' => 'Muokkauksia',
	'quickstats-header-photos' => 'Kuvia',
	'quickstats-header-likes' => 'Tykkäyksiä',
	'quickstats-totals-label' => 'Yhteensä',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Katso lisää tilastoja]]',
	'quickstats-number-shortening' => '$1k',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'quickstats-header-label' => 'Skjót Hagtøl',
	'quickstats-header-date' => 'Dagur',
	'quickstats-header-edits' => 'Rættingar',
	'quickstats-header-photos' => 'Myndir',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Sí fleiri hagtøl]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** French (français)
 * @author Gomoko
 * @author Wyz
 */
$messages['fr'] = array(
	'quickstats-header-label' => 'Stats rapides',
	'quickstats-header-date' => 'Date',
	'quickstats-header-views' => 'Vues',
	'quickstats-header-edits' => 'Modifications',
	'quickstats-header-photos' => 'Images',
	'quickstats-header-likes' => 'J’aime',
	'quickstats-totals-label' => 'Totaux',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Voir plus de stats]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1 M',
	'quickstats-number-shortening-billions' => '$1 Mrd',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'quickstats-header-label' => 'Estatísticas rápidas',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visitas',
	'quickstats-header-edits' => 'Edicións',
	'quickstats-header-photos' => 'Fotos',
	'quickstats-header-likes' => 'Gústame',
	'quickstats-date-format' => 'd de M',
	'quickstats-totals-label' => 'Totais',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Ollar máis estatísticas]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Hebrew (עברית)
 * @author Deror avi
 * @author Yova
 */
$messages['he'] = array(
	'quickstats-header-label' => 'סטטיסטיקה מהירה',
	'quickstats-header-date' => 'תאריך',
	'quickstats-header-views' => 'צפיות',
	'quickstats-header-edits' => 'עריכות',
	'quickstats-header-photos' => 'תמונות',
	'quickstats-header-likes' => 'לייקים',
	'quickstats-totals-label' => 'סה"כ',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|לצפיה בסטטיסטיקות נוספות]]',
	'quickstats-number-shortening' => '$1 אלפים',
	'quickstats-number-shortening-millions' => '$1 מיליונים',
	'quickstats-number-shortening-billions' => '$1 מיליארדים',
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'quickstats-header-label' => 'Gyors statisztikák',
	'quickstats-header-date' => 'Dátum',
	'quickstats-header-views' => 'Megtekintések',
	'quickstats-header-edits' => 'Szerkesztések',
	'quickstats-header-photos' => 'Képek',
	'quickstats-header-likes' => 'kedvelés',
	'quickstats-totals-label' => 'Összesítés',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Részletes statisztika]]',
	'quickstats-number-shortening' => '$1,000',
	'quickstats-number-shortening-millions' => '$1 millió',
	'quickstats-number-shortening-billions' => '$1 mrd',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'quickstats-header-label' => 'Statistica rapide',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visitas',
	'quickstats-header-edits' => 'Modificationes',
	'quickstats-header-photos' => 'Photos',
	'quickstats-header-likes' => 'Me place',
	'quickstats-totals-label' => 'Totales',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Vider plus statisticas]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1mln',
	'quickstats-number-shortening-billions' => '$1mld',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 */
$messages['id'] = array(
	'quickstats-header-label' => 'Statistik Cepat',
	'quickstats-header-date' => 'Tanggal',
	'quickstats-header-views' => 'Dilihat',
	'quickstats-header-edits' => 'Suntingan',
	'quickstats-header-photos' => 'Foto',
	'quickstats-header-likes' => 'Suka',
	'quickstats-totals-label' => 'Total',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|See more stats]]',
	'quickstats-number-shortening' => '$1K',
);

/** Italian (italiano)
 * @author Lexaeus 94
 * @author Ximo17
 */
$messages['it'] = array(
	'quickstats-header-label' => 'Quick Stats - Statistiche',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visite',
	'quickstats-header-edits' => 'Modifiche',
	'quickstats-header-photos' => 'Foto',
	'quickstats-header-likes' => 'Mi Piace',
	'quickstats-totals-label' => 'Totale',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Visualizza statistiche complete]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1 mln',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'quickstats-header-label' => '簡易統計',
	'quickstats-header-date' => '日付',
	'quickstats-header-views' => '閲覧数',
	'quickstats-header-edits' => '編集数',
	'quickstats-header-photos' => '新規画像数',
	'quickstats-date-format' => 'n月j日',
	'quickstats-totals-label' => '合計',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|さらに詳しい統計をみる]]',
);

/** Korean (한국어)
 * @author Excalibur777
 * @author 아라
 */
$messages['ko'] = array(
	'quickstats-header-label' => '간단한 통계',
	'quickstats-header-date' => '날짜',
	'quickstats-header-views' => '보기',
	'quickstats-header-edits' => '편집',
	'quickstats-header-photos' => '사진',
	'quickstats-header-likes' => 'Facebook Likes',
	'quickstats-totals-label' => '합계',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|더 많은 통계 보기]]',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'quickstats-header-date' => 'Dîrok',
	'quickstats-header-photos' => 'Wêne',
	'quickstats-totals-label' => 'Hemû',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'quickstats-header-date' => 'Datum',
	'quickstats-header-edits' => 'Ännerungen',
	'quickstats-header-photos' => 'Fotoen',
	'quickstats-header-likes' => 'Hunn ech gär',
	'quickstats-totals-label' => 'Total',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'quickstats-header-label' => 'Greita statistika',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Peržiūros',
	'quickstats-header-edits' => 'Pakeitimai',
	'quickstats-header-photos' => 'Nuotraukos',
	'quickstats-header-likes' => 'Patinka',
	'quickstats-totals-label' => 'Viso',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'quickstats-header-label' => 'Статистики накратко',
	'quickstats-header-date' => 'Датум',
	'quickstats-header-views' => 'Посети',
	'quickstats-header-edits' => 'Уредувања',
	'quickstats-header-photos' => 'Слики',
	'quickstats-header-likes' => 'Бендисувања',
	'quickstats-date-format' => 'd M',
	'quickstats-totals-label' => 'Вкупно',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Повеќе статистики]]',
	'quickstats-number-shortening' => '$1 К',
	'quickstats-number-shortening-millions' => '$1 млн.',
	'quickstats-number-shortening-billions' => '$1 млд',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'quickstats-header-label' => 'Statistik Asas',
	'quickstats-header-date' => 'Tarikh',
	'quickstats-header-views' => 'Kunjungan',
	'quickstats-header-edits' => 'Suntingan',
	'quickstats-header-photos' => 'Gambar',
	'quickstats-header-likes' => 'Suka',
	'quickstats-totals-label' => 'Jumlah',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Lihat banyak lagi statistik]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1J',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Norwegian Bokmål (‪norsk (bokmål)‬)
 * @author Audun
 */
$messages['nb'] = array(
	'quickstats-header-label' => 'Hurtigstatistikk',
	'quickstats-header-date' => 'Dato',
	'quickstats-header-views' => 'Visninger',
	'quickstats-header-edits' => 'Redigeringer',
	'quickstats-header-photos' => 'Bilder',
	'quickstats-header-likes' => 'Liker',
	'quickstats-date-format' => 'M d',
	'quickstats-totals-label' => 'Totalt',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Se mer statistikk]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1 M',
	'quickstats-number-shortening-billions' => '$1 B',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'quickstats-header-label' => 'Snelle statistieken',
	'quickstats-header-date' => 'Datum',
	'quickstats-header-views' => 'Weergaven',
	'quickstats-header-edits' => 'Bewerkingen',
	'quickstats-header-photos' => 'Afbeeldingen',
	'quickstats-header-likes' => 'Vind ik leuks',
	'quickstats-date-format' => 'M d',
	'quickstats-totals-label' => 'Totalen',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Meer statistieken bekijken]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1*10ˆ6',
	'quickstats-number-shortening-billions' => '$1*10ˆ9',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'quickstats-header-label' => 'Koazi Schdadischdig',
	'quickstats-header-date' => 'Dadum',
	'quickstats-header-views' => 'Uffruf',
	'quickstats-header-edits' => 'Barwaidunge',
	'quickstats-header-photos' => 'Fodos',
	'quickstats-header-likes' => 'Gfalldma',
	'quickstats-totals-label' => 'Gsoamd',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Waidari Schdadischdige]]',
	'quickstats-number-shortening' => '$1k',
	'quickstats-number-shortening-millions' => '$1Mill.',
	'quickstats-number-shortening-billions' => '$1Mrd.',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Cloudissimo
 * @author Sovq
 * @author Woytecr
 */
$messages['pl'] = array(
	'quickstats-header-label' => 'Statystyki',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Odwiedziny',
	'quickstats-header-edits' => 'Edycje',
	'quickstats-header-photos' => 'Obrazy',
	'quickstats-header-likes' => 'Polubienia',
	'quickstats-date-format' => 'M d',
	'quickstats-totals-label' => 'Łącznie',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Więcej statystyk]]',
	'quickstats-number-shortening' => '$1 tys',
	'quickstats-number-shortening-millions' => '$1mln',
	'quickstats-number-shortening-billions' => '$1mlrd',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'quickstats-header-label' => 'Statìstiche Leste',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Vìsite',
	'quickstats-header-edits' => 'Modìfiche',
	'quickstats-header-photos' => 'Fòto',
	'quickstats-header-likes' => 'Com',
	'quickstats-totals-label' => 'Totaj',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Varda pi statìstiche]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1Mrd',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'quickstats-header-date' => 'نېټه',
	'quickstats-header-views' => 'کتنې',
	'quickstats-header-edits' => 'سمونونه',
	'quickstats-header-photos' => 'انځورونه',
	'quickstats-header-likes' => 'خوښې',
	'quickstats-totals-label' => 'ټولټال',
);

/** Portuguese (português)
 * @author Malafaya
 * @author SandroHc
 */
$messages['pt'] = array(
	'quickstats-header-label' => 'Estatísticas Rápidas',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visualizações',
	'quickstats-header-edits' => 'Edições',
	'quickstats-header-photos' => 'Imagens',
	'quickstats-header-likes' => 'Gostos',
	'quickstats-totals-label' => 'Totais',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Ver mais estatísticas]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Giro720
 * @author Luckas Blade
 * @author Pedroca cerebral
 */
$messages['pt-br'] = array(
	'quickstats-header-label' => 'Estatísticas rápidas',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visualizações',
	'quickstats-header-edits' => 'Edições',
	'quickstats-header-photos' => 'Fotos',
	'quickstats-totals-label' => 'Totais',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Ver mais estatísticas]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'quickstats-header-date' => 'Date',
	'quickstats-header-edits' => 'Cangiaminde',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Russian (русский)
 * @author Kuzura
 */
$messages['ru'] = array(
	'quickstats-header-label' => 'Статистика Вики',
	'quickstats-header-date' => 'Дата',
	'quickstats-header-views' => 'Просмотров',
	'quickstats-header-edits' => 'Правок',
	'quickstats-header-photos' => 'Фото',
	'quickstats-header-likes' => 'Нравится',
	'quickstats-totals-label' => 'Итого',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Ещё статистика]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1милл.',
	'quickstats-number-shortening-billions' => '$1миллиард',
);

/** Serbo-Croatian (srpskohrvatski / српскохрватски)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'quickstats-header-label' => 'Kratke statistike',
	'quickstats-header-date' => 'Datum',
	'quickstats-header-views' => 'Pregleda',
	'quickstats-header-edits' => 'Izmjena',
	'quickstats-header-photos' => 'Fotografija',
	'quickstats-header-likes' => 'Likeova',
	'quickstats-totals-label' => 'Ukupno',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Pogledajte još statistika]]',
);

/** Sinhala (සිංහල)
 * @author බිඟුවා
 */
$messages['si'] = array(
	'quickstats-header-label' => 'ඉක්මන් තොරතුර',
	'quickstats-header-date' => 'දිනය',
	'quickstats-header-views' => 'නැරඹුම්',
	'quickstats-header-edits' => 'සංස්කරණ',
	'quickstats-header-photos' => 'රූප',
	'quickstats-header-likes' => 'වගේ',
	'quickstats-totals-label' => 'සියල්ල',
);

/** Serbian (Cyrillic script) (‪српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'quickstats-header-label' => 'Статистике накратко',
	'quickstats-header-date' => 'Датум',
	'quickstats-header-views' => 'Прегледи',
	'quickstats-header-edits' => 'Измене',
	'quickstats-header-photos' => 'Слике',
	'quickstats-header-likes' => 'Свиђања',
	'quickstats-date-format' => 'd M',
	'quickstats-totals-label' => 'Укупно',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Више статистика]]',
	'quickstats-number-shortening' => '$1 K',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'quickstats-header-label' => 'Snabbstatistik',
	'quickstats-header-date' => 'Datum',
	'quickstats-header-views' => 'Visningar',
	'quickstats-header-edits' => 'Redigeringar',
	'quickstats-header-photos' => 'Foton',
	'quickstats-header-likes' => 'Gilla',
	'quickstats-date-format' => 'd M',
	'quickstats-totals-label' => 'Totalt',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Se mer statistik]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'quickstats-header-date' => 'தேதி',
	'quickstats-header-views' => 'பார்வைகள்',
	'quickstats-header-edits' => 'தொகுப்புகள்',
	'quickstats-header-photos' => 'புகைப்படங்கள்',
	'quickstats-header-likes' => 'விருப்பங்கள்',
	'quickstats-totals-label' => 'மொத்தம்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'quickstats-header-label' => 'త్వరిత గణాంకాలు',
	'quickstats-header-date' => 'తేదీ',
	'quickstats-header-views' => 'వీక్షణలు',
	'quickstats-header-edits' => 'మార్పులు',
	'quickstats-header-photos' => 'ఫోటోలు',
	'quickstats-header-likes' => 'మెచ్చుకోళ్ళు',
	'quickstats-totals-label' => 'మొత్తాలు',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|మరిన్ని గణాంకాలను చూడండి]]',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'quickstats-header-label' => 'Mabilisang Estadistika',
	'quickstats-header-date' => 'Petsa',
	'quickstats-header-views' => 'Mga pagtanaw',
	'quickstats-header-edits' => 'Mga pagpatnugot',
	'quickstats-header-photos' => 'Mga larawan',
	'quickstats-header-likes' => 'Mga pagnais',
	'quickstats-date-format' => 'B a',
	'quickstats-totals-label' => 'Mga kabuoan',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Tumingin ng marami pang estadistika]]',
	'quickstats-number-shortening' => '$1,000',
	'quickstats-number-shortening-millions' => '$1 Milyon',
	'quickstats-number-shortening-billions' => '$1 Bilyon',
);

/** толышә зывон (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'quickstats-header-date' => 'Тарых',
	'quickstats-header-views' => 'Тәмшо кардеј',
	'quickstats-header-edits' => 'Дәгишон',
	'quickstats-header-photos' => 'Шикилон',
	'quickstats-header-likes' => 'Хош омејдә',
	'quickstats-number-shortening' => '$1K',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'quickstats-header-label' => 'Вики статистикасы',
	'quickstats-header-date' => 'Вакыт',
	'quickstats-header-views' => 'караулар',
	'quickstats-header-edits' => 'төзәтмә',
	'quickstats-header-photos' => 'Рәсем',
	'quickstats-header-likes' => 'Ошый',
	'quickstats-date-format' => 'M d',
	'quickstats-totals-label' => 'Барысы',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Тагын статистика...]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1милл.',
	'quickstats-number-shortening-billions' => '$1миллиард',
);

/** Ukrainian (українська)
 * @author A1
 * @author Vox
 */
$messages['uk'] = array(
	'quickstats-header-label' => 'Стисла статистика',
	'quickstats-header-date' => 'Дата',
	'quickstats-header-views' => 'Переглядів',
	'quickstats-header-edits' => 'редагувань',
	'quickstats-header-photos' => 'Фото',
	'quickstats-header-likes' => 'Подобається',
	'quickstats-totals-label' => 'Загалом',
	'quickstats-see-more-stats-link' => '[[Спеціальна:WikiStats|Див. більше статистики]]',
	'quickstats-number-shortening' => '$1K',
);

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'quickstats-header-date' => 'Dat',
	'quickstats-header-photos' => 'Fotokuvad',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'quickstats-header-label' => 'Thống kê nhanh',
	'quickstats-header-date' => 'Ngày',
	'quickstats-header-views' => 'Lượt xem',
	'quickstats-header-edits' => 'Sửa đổi',
	'quickstats-header-photos' => 'Hình ảnh',
	'quickstats-header-likes' => 'Thích',
	'quickstats-totals-label' => 'Tổng cộng',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Xem thêm các số liệu thống kê]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Simplified Chinese (‪中文（简体）‬)
 * @author Anakmalaysia
 * @author Dimension
 */
$messages['zh-hans'] = array(
	'quickstats-header-date' => '日期',
	'quickstats-header-views' => '浏览量',
	'quickstats-header-edits' => '编辑量',
	'quickstats-header-photos' => '照片',
	'quickstats-header-likes' => '喜欢数',
	'quickstats-totals-label' => '总计',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|查看更多统计]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1（百万）',
);

/** Traditional Chinese (‪中文（繁體）‬)
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'quickstats-header-label' => '快速統計資訊',
	'quickstats-header-date' => '日期',
	'quickstats-header-views' => '瀏覽次數',
	'quickstats-header-edits' => '編輯次數',
	'quickstats-header-photos' => '圖片數',
	'quickstats-header-likes' => '按讚的數目',
	'quickstats-totals-label' => '總計',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|查看更多統計]]',
	'quickstats-number-shortening' => '$1K',
);

