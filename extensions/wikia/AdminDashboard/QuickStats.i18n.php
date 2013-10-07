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

/** Message documentation (Message documentation)
 * @author Shirayuki
 * @author 아라
 */
$messages['qqq'] = array(
	'quickstats-header-date' => '{{Identical|Date}}',
	'quickstats-header-views' => '{{Identical|View}}',
	'quickstats-header-edits' => '{{Identical|Edit}}',
	'quickstats-header-photos' => '{{Identical|Photo}}',
	'quickstats-header-likes' => '{{Identical|Like}}',
	'quickstats-date-format' => 'Follow this guide: http://php.net/manual/en/function.date.php.',
	'quickstats-totals-label' => '{{Identical|Total}}',
	'quickstats-number-shortening' => 'This is a shortend number abbreviation shown in a stats table. Number larger than 10.000 are rendered using this message (as thousands rounded up to the first decimal fraction). K stands for thousands (1.000)

{{Identical|$1k}}',
	'quickstats-number-shortening-millions' => 'This is a shortend number abbreviation shown in a stats table. Number between 1.000.000 and 999.999.999.999 are rendered using this message (as millions rounded up to the first decimal fraction). M stands for millions (1.000.000)',
	'quickstats-number-shortening-billions' => 'This is a shortend number abbreviation shown in a stats table. Number larger than 1.000.000.000 are rendered using this message (as billions rounded up to the first decimal fraction). B stands for billions (1.000.000.000)',
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
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|مشاهدة المزيد من الإحصائيات]]',
	'quickstats-number-shortening' => '$1 ألف',
	'quickstats-number-shortening-millions' => '$1 مليون',
	'quickstats-number-shortening-billions' => '$1 بليون',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'quickstats-header-date' => 'ܣܝܩܘܡܐ',
);

/** Assamese (অসমীয়া)
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

/** South Azerbaijani (تورکجه)
 * @author E THP
 * @author Mousa
 */
$messages['azb'] = array(
	'quickstats-header-date' => 'تاریخ',
	'quickstats-header-views' => 'گؤرونوشلر',
	'quickstats-header-edits' => 'دَییشدیرمه‌لر',
	'quickstats-header-photos' => 'شکیل‌لر',
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

/** Bavarian (Boarisch)
 * @author Bua333
 */
$messages['bar'] = array(
	'quickstats-header-label' => 'Ministatistik',
	'quickstats-header-date' => 'Datum',
);

/** Bikol Central (Bikol Central)
 * @author Geopoet
 */
$messages['bcl'] = array(
	'quickstats-header-label' => 'Hidaling Estadistika',
	'quickstats-header-date' => 'Petsa',
	'quickstats-header-views' => 'Mga Tanawon',
	'quickstats-header-edits' => 'Mga Pagliwat',
	'quickstats-header-photos' => 'Mga Litrato',
	'quickstats-header-likes' => 'Mga Kinamuyahan',
	'quickstats-totals-label' => 'Mga Kabilogan',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Hilngon an mga kadugangang mga estadistika]]',
	'quickstats-number-shortening' => '$1 na ribo',
	'quickstats-number-shortening-millions' => '$1 na milyon',
	'quickstats-number-shortening-billions' => '$1 na bilyon',
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

/** Bhojpuri (भोजपुरी)
 * @author Nepaboy
 */
$messages['bho'] = array(
	'quickstats-header-label' => 'त्वरित आँकड़े',
	'quickstats-header-date' => 'तिथि',
	'quickstats-header-views' => 'दृष्टिकोण',
	'quickstats-header-edits' => 'संपादन',
	'quickstats-header-photos' => 'तस्वीरें',
	'quickstats-header-likes' => 'पंसदें',
	'quickstats-totals-label' => 'योग',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|और आँकड़ा देखीं]]',
	'quickstats-number-shortening' => '$1के',
	'quickstats-number-shortening-millions' => '$1मिलियन',
	'quickstats-number-shortening-billions' => '$1बिलियन',
);

/** Bengali (বাংলা)
 * @author Aftab1995
 */
$messages['bn'] = array(
	'quickstats-header-date' => 'তারিখ',
	'quickstats-totals-label' => 'মোট',
);

/** Tibetan (བོད་ཡིག)
 * @author YeshiTuhden
 */
$messages['bo'] = array(
	'quickstats-header-label' => 'མགྱོགས་མྱུར་སྡོམ་རྩིས་',
	'quickstats-header-date' => 'ཟླ་ཚེས་',
	'quickstats-header-edits' => 'རྩོམ་སྒྲིག་',
	'quickstats-header-photos' => 'འདྲ་པར་',
	'quickstats-header-likes' => 'དགའ་',
	'quickstats-totals-label' => 'ཡོངས་བགྲང་',
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
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1Mrd',
);

/** Catalan (català)
 * @author CuBaN VeRcEttI
 * @author Solde
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
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '
$1B',
);

/** Sorani Kurdish (کوردی)
 * @author Calak
 */
$messages['ckb'] = array(
	'quickstats-header-date' => 'ڕێکەوت',
	'quickstats-header-edits' => 'دەستکارییەکان',
	'quickstats-header-photos' => 'وێنەکان',
	'quickstats-number-shortening' => '$1 ھەزار',
	'quickstats-number-shortening-millions' => '$1 میلیۆن',
	'quickstats-number-shortening-billions' => '$1 بیلیۆن',
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

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Thefartydoctor
 */
$messages['cy'] = array(
	'quickstats-header-label' => 'Ystadegau Chwim',
	'quickstats-header-date' => 'Dyddiad',
	'quickstats-header-views' => 'Golygon',
	'quickstats-header-edits' => 'Newidiadau',
	'quickstats-header-photos' => 'Lluniau',
	'quickstats-header-likes' => 'Hoffau',
	'quickstats-totals-label' => 'Cyfanswm',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Amlygu mwy ystadegau]]',
	'quickstats-number-shortening' => '$1,000',
	'quickstats-number-shortening-millions' => '$1 miliwn',
	'quickstats-number-shortening-billions' => '$1 biliwn',
);

/** Danish (dansk)
 * @author Christian List
 * @author Sarrus
 */
$messages['da'] = array(
	'quickstats-header-date' => 'Dato',
	'quickstats-header-views' => 'Visninger',
	'quickstats-header-edits' => 'Redigeringer',
	'quickstats-header-photos' => 'Billeder',
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

/** Greek (Ελληνικά)
 * @author Glavkos
 */
$messages['el'] = array(
	'quickstats-header-label' => 'Γρήγορα Στατιστικά',
	'quickstats-header-date' => 'Ημερομηνία',
	'quickstats-header-views' => 'Επισκέψεις',
	'quickstats-header-edits' => 'Επεξεργασίες',
	'quickstats-header-photos' => 'Φωτογραφίες',
	'quickstats-header-likes' => 'Αρέσει',
	'quickstats-totals-label' => 'Σύνολα',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Δείτε περισσότερα στατιστικά]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1δις',
);

/** Esperanto (Esperanto)
 * @author Objectivesea
 * @author Tradukisto
 */
$messages['eo'] = array(
	'quickstats-header-label' => 'Baldaŭa statistiko',
	'quickstats-header-date' => 'Dato',
	'quickstats-header-views' => 'Vidoj',
	'quickstats-header-edits' => 'Redaktoj',
	'quickstats-header-photos' => 'Fotoj',
	'quickstats-header-likes' => 'Ŝatoj',
	'quickstats-totals-label' => 'Sumoj',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Vidu pli da statistiko]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1 Mrd',
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
	'quickstats-header-label' => 'Lühi statistika',
	'quickstats-header-date' => 'Kuupäev',
	'quickstats-header-views' => 'Vaatamisi',
	'quickstats-header-edits' => 'Muudatusi',
	'quickstats-header-photos' => 'Fotod',
	'quickstats-header-likes' => 'Meeldib',
	'quickstats-totals-label' => 'Kokku',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Vaata rohkem statistikat]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Persian (فارسی)
 * @author Huji
 * @author Reza1615
 * @author جواد
 */
$messages['fa'] = array(
	'quickstats-header-date' => 'تاریخ',
	'quickstats-header-views' => 'بازدیدها',
	'quickstats-header-edits' => 'ویرایش‌ها',
	'quickstats-header-photos' => 'عکس‌ها',
	'quickstats-totals-label' => 'مجموع',
	'quickstats-number-shortening' => '$1 هزار',
	'quickstats-number-shortening-millions' => '$1 میلیون',
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
	'quickstats-header-views' => 'Sýningar',
	'quickstats-header-edits' => 'Rættingar',
	'quickstats-header-photos' => 'Myndir',
	'quickstats-header-likes' => 'Dámar',
	'quickstats-totals-label' => 'Tilsamans',
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

/** Hakka (客家語/Hak-kâ-ngî)
 * @author Anson2812
 */
$messages['hak'] = array(
	'quickstats-header-label' => '快速計數',
	'quickstats-header-date' => '日期',
	'quickstats-header-views' => '查看嘅數目',
	'quickstats-header-edits' => '編寫',
	'quickstats-header-photos' => '相片',
	'quickstats-header-likes' => '撳贊嘅數目',
	'quickstats-totals-label' => '共計',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|查看還加多統計]]',
	'quickstats-number-shortening' => '$1千',
	'quickstats-number-shortening-millions' => '$1百萬',
	'quickstats-number-shortening-billions' => '$10億',
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

/** Hindi (हिन्दी)
 * @author Kush rohra
 */
$messages['hi'] = array(
	'quickstats-header-label' => 'त्वरित आँकड़े',
	'quickstats-header-date' => 'तिथि',
	'quickstats-header-views' => '	
	
दृष्टिकोण',
	'quickstats-header-edits' => 'संपादन',
	'quickstats-header-photos' => 'तस्वीरें',
	'quickstats-header-likes' => 'हित',
	'quickstats-totals-label' => 'योग',
	'quickstats-see-more-stats-link' => '[[विशिष्ट:विकीआँकड़े|देखना अधिक आँकड़े]]', # Fuzzy
	'quickstats-number-shortening' => '$1के',
	'quickstats-number-shortening-millions' => '$1मिलियन',
	'quickstats-number-shortening-billions' => '$1बिलियन',
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
 * @author C5st4wr6ch
 */
$messages['id'] = array(
	'quickstats-header-label' => 'Statistik Cepat',
	'quickstats-header-date' => 'Tanggal',
	'quickstats-header-views' => 'Dilihat',
	'quickstats-header-edits' => 'Suntingan',
	'quickstats-header-photos' => 'Foto',
	'quickstats-header-likes' => 'Suka',
	'quickstats-totals-label' => 'Total',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Lihat lebih banyak statistik]]',
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
 * @author Hym411
 * @author 아라
 * @author 한글화담당
 */
$messages['ko'] = array(
	'quickstats-header-label' => '간단한 통계',
	'quickstats-header-date' => '날짜',
	'quickstats-header-views' => '보기',
	'quickstats-header-edits' => '편집',
	'quickstats-header-photos' => '사진',
	'quickstats-header-likes' => '좋아요',
	'quickstats-totals-label' => '합계',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|더 많은 통계 보기]]',
	'quickstats-number-shortening' => '$1천',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'quickstats-header-date' => 'Dattum',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'quickstats-header-date' => 'Dîrok',
	'quickstats-header-edits' => 'Guherandin',
	'quickstats-header-photos' => 'Wêne',
	'quickstats-totals-label' => 'Hemû',
);

/** Kyrgyz (Кыргызча)
 * @author Growingup
 */
$messages['ky'] = array(
	'quickstats-header-date' => 'Дата',
	'quickstats-header-views' => 'Көрүүлөр',
	'quickstats-header-edits' => 'Оңдоолор',
	'quickstats-header-photos' => 'Фото',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'quickstats-header-label' => 'Ministatistik',
	'quickstats-header-date' => 'Datum',
	'quickstats-header-views' => 'Säitenofruffer',
	'quickstats-header-edits' => 'Ännerungen',
	'quickstats-header-photos' => 'Fotoen',
	'quickstats-header-likes' => 'Hunn ech gär',
	'quickstats-totals-label' => 'Total',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Méi Statistiken]]',
	'quickstats-number-shortening' => '$1k',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1 Mrd',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 * @author Vilius
 */
$messages['lt'] = array(
	'quickstats-header-label' => 'Greita statistika',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Peržiūros',
	'quickstats-header-edits' => 'Pakeitimai',
	'quickstats-header-photos' => 'Nuotraukos',
	'quickstats-header-likes' => 'Patinka',
	'quickstats-totals-label' => 'Viso',
	'quickstats-see-more-stats-link' => '[[Specialus:WikiStatistika|Pamatyti daugiau statistikų]]', # Fuzzy
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Latvian (latviešu)
 * @author Papuass
 */
$messages['lv'] = array(
	'quickstats-header-date' => 'Datums',
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author StefanusRA
 */
$messages['map-bms'] = array(
	'quickstats-header-label' => 'Statistik Banter',
	'quickstats-header-date' => 'Tanggal',
	'quickstats-header-views' => 'Dideleng',
	'quickstats-header-edits' => 'Suntingan',
	'quickstats-header-photos' => 'Foto',
	'quickstats-header-likes' => 'Seneng',
	'quickstats-totals-label' => 'Total',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Deleng lewih akeh maning statistike]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1Jt',
	'quickstats-number-shortening-billions' => '$1M',
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

/** Malayalam (മലയാളം)
 * @author Kavya Manohar
 * @author Praveenp
 */
$messages['ml'] = array(
	'quickstats-header-date' => 'തീയതി',
	'quickstats-header-edits' => 'തിരുത്തുകൾ',
	'quickstats-header-photos' => 'ചിത്രങ്ങൾ',
	'quickstats-totals-label' => 'ആകെ',
	'quickstats-number-shortening' => '$1 ആയിരം',
	'quickstats-number-shortening-millions' => '$1 ദശലക്ഷം',
	'quickstats-number-shortening-billions' => '$1 ആയിരം കോടി',
);

/** Marathi (मराठी)
 * @author V.narsikar
 */
$messages['mr'] = array(
	'quickstats-header-label' => 'जलद सांख्यिकी',
	'quickstats-header-date' => 'दिनांक',
	'quickstats-header-views' => 'दृष्ये',
	'quickstats-header-edits' => 'संपादने',
	'quickstats-header-photos' => 'छायाचित्रे',
	'quickstats-header-likes' => 'आवडीचे',
	'quickstats-totals-label' => 'एकूण',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|अधिक आकडेवारी बघा]]',
	'quickstats-number-shortening' => '$1के',
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
	'quickstats-date-format' => 'd M',
	'quickstats-totals-label' => 'Jumlah',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Lihat banyak lagi statistik]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1J',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'quickstats-header-label' => 'Statistiċi ħfief',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Dehriet',
	'quickstats-header-edits' => 'Modifiki',
	'quickstats-header-photos' => 'Ritratti',
	'quickstats-totals-label' => 'Total',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Aktar statistika]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Norwegian Bokmål (norsk bokmål)
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

/** Nepali (नेपाली)
 * @author Bhawani Gautam
 * @author सरोज कुमार ढकाल
 */
$messages['ne'] = array(
	'quickstats-header-date' => 'मिति',
	'quickstats-header-views' => 'अवलोकनहरू',
	'quickstats-header-edits' => 'सम्पादनहरु',
	'quickstats-header-photos' => 'चित्र',
	'quickstats-header-likes' => 'मनपर्दो',
	'quickstats-totals-label' => 'कुल',
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

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'quickstats-header-label' => 'Estat. rapidas',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Vistas',
	'quickstats-header-edits' => 'Modificacions',
	'quickstats-header-photos' => 'Imatges',
	'quickstats-header-likes' => "M'agrada",
	'quickstats-totals-label' => 'Totals',
	'quickstats-see-more-stats-link' => "[[Special:WikiStats|Veire mai d'estat.]]",
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1 M',
	'quickstats-number-shortening-billions' => '$1 Mrd',
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
 * @author Chrumps
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
	'quickstats-number-shortening' => '$1 tys.',
	'quickstats-number-shortening-millions' => '$1 mln',
	'quickstats-number-shortening-billions' => '$1 mld',
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
	'quickstats-header-label' => 'چټک شمار',
	'quickstats-header-date' => 'نېټه',
	'quickstats-header-views' => 'کتنې',
	'quickstats-header-edits' => 'سمونونه',
	'quickstats-header-photos' => 'انځورونه',
	'quickstats-header-likes' => 'خوښې',
	'quickstats-totals-label' => 'ټولټال',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|نورې شمارنې کتل]]',
	'quickstats-number-shortening' => '$1زر',
	'quickstats-number-shortening-millions' => '$1ميليون',
	'quickstats-number-shortening-billions' => '$1بيليون',
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
 * @author Luckas
 * @author Luckas Blade
 * @author Pedroca cerebral
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'quickstats-header-label' => 'Estatísticas rápidas',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visualizações',
	'quickstats-header-edits' => 'Edições',
	'quickstats-header-photos' => 'Fotos',
	'quickstats-header-likes' => 'Eu Gosto',
	'quickstats-totals-label' => 'Totais',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Ver mais estatísticas]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'quickstats-header-label' => 'Statisteche veloce',
	'quickstats-header-date' => 'Date',
	'quickstats-header-views' => 'Visite',
	'quickstats-header-edits' => 'Cangiaminde',
	'quickstats-header-photos' => 'Foto',
	'quickstats-header-likes' => 'Apprezzamènde',
	'quickstats-totals-label' => 'Totele',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Vide cchiù statisteche]]',
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
 * @author පසිඳු කාවින්ද
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
	'quickstats-number-shortening' => '$1K',
);

/** Somali (Soomaaliga)
 * @author Abshirdheere
 */
$messages['so'] = array(
	'quickstats-header-label' => 'Tirakoob degdeg ah',
	'quickstats-header-date' => 'Taariikh',
	'quickstats-header-views' => 'Muuqaalka',
	'quickstats-header-edits' => 'Isbedelada',
	'quickstats-header-photos' => 'Sawirro',
	'quickstats-header-likes' => 'Waan ka helay',
	'quickstats-totals-label' => 'Wadarta',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|sii eeg tirakoobyeda]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
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

/** Turkish (Türkçe)
 * @author Sabri Vatansever
 */
$messages['tr'] = array(
	'quickstats-header-label' => 'Hızlı istatistik',
	'quickstats-header-date' => 'Tarih',
	'quickstats-header-views' => 'Görüntülenme',
	'quickstats-header-edits' => 'Değişiklikler',
	'quickstats-header-photos' => 'Fotoğraflar',
	'quickstats-header-likes' => 'Beğeniler',
	'quickstats-totals-label' => 'Toplam',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Daha fazla istatislik gör]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
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

/** Tati (Tati)
 * @author Erdemaslancan
 */
$messages['ttt'] = array(
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|istatistikan diyin]]',
);

/** Central Atlas Tamazight (ⵜⴰⵎⴰⵣⵉⵖⵜ)
 * @author Tifinaghes
 */
$messages['tzm'] = array(
	'quickstats-header-date' => 'ⴰⴽⵓⴷ',
	'quickstats-header-photos' => 'ⵜⵉⵡⵍⴰⴼⵉⵏ',
	'quickstats-totals-label' => 'ⵎⴰⵕⵕⴰ',
);

/** Ukrainian (українська)
 * @author A1
 * @author Ua2004
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
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Більше статистики]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1 млн',
	'quickstats-number-shortening-billions' => '$1 млрд',
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

/** Chinese (中文)
 * @author Shangkuanlc
 */
$messages['zh'] = array(
	'quickstats-header-label' => '統計快訊',
	'quickstats-header-date' => '日期',
	'quickstats-header-views' => '點閱數',
	'quickstats-header-edits' => '編輯數',
	'quickstats-header-photos' => '照片',
	'quickstats-header-likes' => '按讚',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Dimension
 * @author Reasno
 */
$messages['zh-hans'] = array(
	'quickstats-header-label' => '简明统计',
	'quickstats-header-date' => '日期',
	'quickstats-header-views' => '浏览量',
	'quickstats-header-edits' => '编辑量',
	'quickstats-header-photos' => '照片',
	'quickstats-header-likes' => '喜欢数',
	'quickstats-totals-label' => '总计',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|查看更多统计]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1（百万）',
	'quickstats-number-shortening-billions' => '$10亿',
);

/** Traditional Chinese (中文（繁體）‎)
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

/** Chinese (Hong Kong) (中文（香港）‎)
 * @author Tcshek
 */
$messages['zh-hk'] = array(
	'quickstats-header-label' => '快速統計資訊',
	'quickstats-header-date' => '日期',
	'quickstats-header-views' => '瀏覽次數',
	'quickstats-header-edits' => '編輯次數',
	'quickstats-header-photos' => '圖片數',
	'quickstats-header-likes' => '讚好的數目',
	'quickstats-totals-label' => '總計',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|查看更多統計]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
);
