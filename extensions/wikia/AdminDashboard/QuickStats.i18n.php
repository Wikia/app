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
    'quickstats-ga-broken-message' => "The views column is currently out of order.  We're working on bringing it back soon! [$1 More info]",
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'quickstats-date-format' => 'Follow this guide: http://php.net/manual/en/function.date.php.',
	'quickstats-number-shortening' => 'This is a shortend number abbreviation shown in a stats table. Number larger than 10.000 are rendered using this message (as thousands rounded up to the first decimal fraction). K stands for thousands (1.000)',
	'quickstats-number-shortening-millions' => 'This is a shortend number abbreviation shown in a stats table. Number between 1.000.000 and 999.999.999.999 are rendered using this message (as millions rounded up to the first decimal fraction). M stands for millions (1.000.000)',
	'quickstats-number-shortening-billions' => 'This is a shortend number abbreviation shown in a stats table. Number larger than 1.000.000.000 are rendered using this message (as billions rounded up to the first decimal fraction). B stands for billions (1.000.000.000)',
	'quickstats-ga-broken-message' => 'This is a message we display in Admin Dashboard above Quick Stats; It is temporary till we fix our Google Analytics issues',
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

/** Azerbaijani (Azərbaycanca)
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

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'quickstats-header-date' => 'Дата',
	'quickstats-header-edits' => 'Редакции',
	'quickstats-header-photos' => 'Снимки',
);

/** Breton (Brezhoneg)
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

/** Catalan (Català)
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

/** Czech (Česky)
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
);

/** German (Deutsch)
 * @author LWChris
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
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'quickstats-header-label' => 'İstatıstike vistri',
	'quickstats-header-photos' => 'Fotrafi',
	'quickstats-header-likes' => 'Rındeni',
	'quickstats-totals-label' => 'Pero piya',
);

/** Esperanto (Esperanto)
 * @author Tradukisto
 */
$messages['eo'] = array(
	'quickstats-header-date' => 'Dato',
	'quickstats-header-edits' => 'Redaktoj',
);

/** Spanish (Español)
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
	'quickstats-ga-broken-message' => 'La columna de las páginas vistas está actualmente fuera de servicio. ¡Estamos trabajando para su pronto restablecimiento! [$1  Más información]',
);

/** Persian (فارسی)
 * @author Reza1615
 */
$messages['fa'] = array(
	'quickstats-header-date' => 'تاریخ',
	'quickstats-header-photos' => 'عکس‌ها',
	'quickstats-totals-label' => 'مجموع',
);

/** Finnish (Suomi)
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
	'quickstats-ga-broken-message' => 'Näkymä-sarakkeet ei tällähetkellä ole järjestyksessä. Työskentelemme palauttaaksemme ne pian! [$1 Lisää tietoa]',
);

/** French (Français)
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
	'quickstats-ga-broken-message' => "La vue en colonnes est actuellement indisponible. Nous travaillons dessus pour la mettre à disposition bientôt! [$1 Plus d'info]",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'quickstats-header-label' => 'Estatísticas rápidas',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Visitas',
	'quickstats-header-edits' => 'Edicións',
	'quickstats-header-photos' => 'Fotos',
	'quickstats-header-likes' => 'Gústame',
	'quickstats-totals-label' => 'Totais',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Ollar máis estatísticas]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1M',
	'quickstats-number-shortening-billions' => '$1B',
	'quickstats-ga-broken-message' => 'A columna das visitas está fóra de servizo nestes intres. Estamos traballando para restablecela axiña! [$1 Máis información]',
);

/** Hebrew (עברית)
 * @author Deror avi
 */
$messages['he'] = array(
	'quickstats-header-label' => 'סטטיסטיקה מהירה',
	'quickstats-header-date' => 'תאריך',
	'quickstats-header-views' => 'צפיות',
	'quickstats-header-edits' => 'עריכות',
	'quickstats-header-photos' => 'תמונות',
	'quickstats-totals-label' => 'סה"כ',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|לצפיה בסטטיסטיקות נוספות]]',
);

/** Hungarian (Magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'quickstats-header-label' => 'Gyors statisztikák',
	'quickstats-header-date' => 'Dátum',
	'quickstats-header-views' => 'Megtekintések',
	'quickstats-header-edits' => 'Szerkesztések',
	'quickstats-header-photos' => 'Képek',
	'quickstats-totals-label' => 'Összesítés',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Részletes statisztika]]',
	'quickstats-number-shortening' => '$1,000',
);

/** Interlingua (Interlingua)
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
	'quickstats-ga-broken-message' => 'Le columna de vistas es temporarimente foras de servicio. Nos nos effortia a restabilir lo tosto! [$1 Plus info]',
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

/** Italian (Italiano)
 * @author Lexaeus 94
 */
$messages['it'] = array(
	'quickstats-header-views' => 'Visite',
	'quickstats-header-edits' => 'Modifiche',
	'quickstats-header-photos' => 'Foto',
	'quickstats-header-likes' => 'Mi Piace',
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
 */
$messages['ko'] = array(
	'quickstats-header-label' => '간단한 통계',
	'quickstats-header-date' => '날짜',
	'quickstats-header-views' => '페이지뷰',
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

/** Lithuanian (Lietuvių)
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
);

/** Macedonian (Македонски)
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
	'quickstats-ga-broken-message' => 'Колоната за посети моментално не функционира. Работиме на тоа да проработи набргу! [$1 Повеќе инфо]',
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
	'quickstats-ga-broken-message' => 'Kolum kunjungan (views) sekarang tidak boleh digunakan. Kami sedang berusaha untuk membaikinya secepat mungkin! [$1 Maklumat lanjut]',
);

/** Norwegian Bokmål (‪Norsk (bokmål)‬)
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
	'quickstats-ga-broken-message' => 'Visningskolonnen er for øyeblikket ute av funksjon. Vi arbeider med å få den tilbake snarest! [$1 Mer info]',
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
	'quickstats-ga-broken-message' => 'De weergavekolom is momenteel buiten gebruik. We zijn bezig om hem snel terug te brengen! [$1 Meer informatie].',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'quickstats-header-date' => 'Dadum',
	'quickstats-header-views' => 'Uffruf',
	'quickstats-header-edits' => 'Bearwaidunge',
	'quickstats-header-photos' => 'Fodos',
	'quickstats-totals-label' => 'Gsoamd',
);

/** Polish (Polski)
 * @author BeginaFelicysym
 * @author Cloudissimo
 * @author Sovq
 * @author Woytecr
 */
$messages['pl'] = array(
	'quickstats-header-label' => 'Szybkie statystyki',
	'quickstats-header-date' => 'Data',
	'quickstats-header-views' => 'Odwiedziny',
	'quickstats-header-edits' => 'Edycje',
	'quickstats-header-photos' => 'Obrazy',
	'quickstats-header-likes' => 'Polubienia',
	'quickstats-date-format' => 'M d',
	'quickstats-totals-label' => 'Łącznie',
	'quickstats-see-more-stats-link' => '[[Special:WikiStats|Więcej statystyk]]',
	'quickstats-number-shortening' => '$1K',
	'quickstats-number-shortening-millions' => '$1mln',
	'quickstats-number-shortening-billions' => '$1mlrd',
	'quickstats-ga-broken-message' => 'Kolumna z licznikiem odwiedzin obecnie nie działa. Ciężko pracujemy aby przywrócić jej sprawność. [$1  Więcej...]',
);

/** Piedmontese (Piemontèis)
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
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'quickstats-header-date' => 'نېټه',
	'quickstats-header-views' => 'کتنې',
	'quickstats-header-edits' => 'سمونونه',
	'quickstats-header-photos' => 'انځورونه',
	'quickstats-totals-label' => 'ټولټال',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'quickstats-header-date' => 'Data',
	'quickstats-totals-label' => 'Totais',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
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
);

/** Russian (Русский)
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
	'quickstats-ga-broken-message' => 'Статистика просмотров страниц вики в настоящее время недоступна. Мы работаем над тем, чтобы исправить это! [$1 Подробнее]',
);

/** Serbo-Croatian (Srpskohrvatski)
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

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
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

/** Swedish (Svenska)
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
	'quickstats-ga-broken-message' => 'Visningskolumnen är för tillfället ur funktion. Vi arbetar på att få tillbaka den snart! [$1 Mer info]',
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

/** Толышә зывон (Толышә зывон)
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

/** Tatar (Cyrillic script) (Татарча)
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
	'quickstats-ga-broken-message' => 'Вики битләрен карау статистикасына керү мөмкинлеге әлегә юк. Без моны төзәтү өстендә эшлибез! [$1 тулырак]',
);

/** Ukrainian (Українська)
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

/** Veps (Vepsän kel’)
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
);

/** Simplified Chinese (‪中文(简体)‬)
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

/** Traditional Chinese (‪中文(繁體)‬)
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

