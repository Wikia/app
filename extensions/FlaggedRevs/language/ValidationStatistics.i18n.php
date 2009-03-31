<?php
/**
 * Internationalisation file for FlaggedRevs extension, section ValidationStatistics
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'validationstatistics'        => 'Validation statistics',
	'validationstatistics-users'  => '\'\'\'{{SITENAME}}\'\'\' currently has \'\'\'$1\'\'\' {{PLURAL:$1|user|users}} with [[{{MediaWiki:Validationpage}}|Editor]] rights
and \'\'\'$2\'\'\' {{PLURAL:$2|user|users}} with [[{{MediaWiki:Validationpage}}|Reviewer]] rights.',
	'validationstatistics-table'  => "Statistics for each namespace are shown below, excluding redirects pages.

'''Note:''' the following data is cached for several hours and may not be up to date.",
	'validationstatistics-ns'     => 'Namespace',
	'validationstatistics-total'  => 'Pages',
	'validationstatistics-stable' => 'Reviewed',
	'validationstatistics-latest' => 'Latest reviewed',
	'validationstatistics-synced' => 'Synced/Reviewed',
	'validationstatistics-old'    => 'Outdated',
	'validationstatistics-nbr'    => '$1%', # only translate this message to other languages if you have to change it
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Raymond
 */
$messages['qqq'] = array(
	'validationstatistics-ns' => '{{Identical|Namespace}}',
	'validationstatistics-total' => '{{Identical|Pages}}',
	'validationstatistics-nbr' => 'Used for the percent numbers in the table of [http://en.wikinews.org/wiki/Special:ValidationStatistics Special:ValidationStatistics]',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'validationstatistics-ns' => 'ክፍለ-ዊኪ',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'validationstatistics' => 'إحصاءات التحقق',
	'validationstatistics-users' => "'''{{SITENAME}}''' لديه حاليا '''$1''' {{PLURAL:$1|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|محرر]]
و '''$2''' {{PLURAL:$2|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|مراجع]].",
	'validationstatistics-table' => "الإحصاءات لكل نطاق معروضة بالأسفل، لا يتضمن ذلك صفحات التحويل.

'''ملاحظة:''' البيانات التالية مخزنة لعدة ساعات وربما لا تكون محدثة.",
	'validationstatistics-ns' => 'النطاق',
	'validationstatistics-total' => 'الصفحات',
	'validationstatistics-stable' => 'مراجع',
	'validationstatistics-latest' => 'مراجع أخيرا',
	'validationstatistics-synced' => 'تم تحديثه/تمت مراجعته',
	'validationstatistics-old' => 'قديمة',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'validationstatistics' => 'إحصاءات التحقق',
	'validationstatistics-users' => "'''{{SITENAME}}''' لديه حاليا '''$1''' {{PLURAL:$1|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|محرر]]
و '''$2''' {{PLURAL:$2|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|مراجع]].",
	'validationstatistics-table' => "الإحصاءات لكل نطاق معروضة بالأسفل، لا يتضمن ذلك صفحات التحويل.

'''ملاحظة:''' البيانات التالية مخزنة لعدة ساعات وربما لا تكون محدثة.",
	'validationstatistics-ns' => 'النطاق',
	'validationstatistics-total' => 'الصفحات',
	'validationstatistics-stable' => 'مراجع',
	'validationstatistics-latest' => 'مراجع أخيرا',
	'validationstatistics-synced' => 'تم تحديثه/تمت مراجعته',
	'validationstatistics-old' => 'قديمة',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'validationstatistics-ns' => 'Espaciu de nomes',
	'validationstatistics-total' => 'Páxines',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'validationstatistics' => 'Статыстыка праверак',
	'validationstatistics-users' => "'''{{SITENAME}}''' цяпер налічвае '''$1''' {{PLURAL:$1|удзельніка|удзельнікі|удзельнікаў}} з правамі [[{{MediaWiki:Validationpage}}|«рэдактара»]] і '''$2'''  {{PLURAL:$2|удзельніка|удзельнікі|удзельнікаў}} з правамі [[{{MediaWiki:Validationpage}}|«правяраючага»]].",
	'validationstatistics-table' => "Статыстыка для кожнай прасторы назваў пададзеная ніжэй, за выключэньнем старонак-перанакіраваньняў.

'''Заўвага:''' наступныя зьвесткі кэшуюцца на некалькі гадзінаў і могуць не адпавядаць цяперашнім.",
	'validationstatistics-ns' => 'Прастора назваў',
	'validationstatistics-total' => 'Старонак',
	'validationstatistics-stable' => 'Правераных',
	'validationstatistics-latest' => 'Нядаўна правераных',
	'validationstatistics-synced' => 'Паўторна правераных',
	'validationstatistics-old' => 'Састарэлых',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'validationstatistics-ns' => 'Именно пространство',
	'validationstatistics-total' => 'Страници',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'validationstatistics-ns' => 'Imenski prostor',
	'validationstatistics-total' => 'Stranice',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'validationstatistics-total' => 'страни́цѧ',
);

/** German (Deutsch)
 * @author Melancholie
 */
$messages['de'] = array(
	'validationstatistics' => 'Markierungsstatistik',
	'validationstatistics-users' => "{{SITENAME}} hat '''$1''' {{PLURAL:$1|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Sichterrecht]] und '''$2''' {{PLURAL:$2|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Prüferrecht]].",
	'validationstatistics-table' => "Statistiken für jeden Namensraum, ausgenommen sind Weiterleitungen.

'''Bitte beachten:''' Die folgenden Daten werden jeweils für mehrere Stunden zwischengespeichert und sind daher nicht immer aktuell.",
	'validationstatistics-ns' => 'Namensraum',
	'validationstatistics-total' => 'Seiten gesamt',
	'validationstatistics-stable' => 'Mindestens eine Version gesichtet',
	'validationstatistics-latest' => 'Anzahl Seiten, die in der aktuellen Version gesichtet sind',
	'validationstatistics-synced' => 'Prozentsatz an Seiten, die in der aktuellen Version gesichtet sind',
	'validationstatistics-old' => 'Seiten mit ungesichteten Versionen',
	'validationstatistics-nbr' => '$1&nbsp;%',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'validationstatistics' => 'Pógódnośeńska statistika',
	'validationstatistics-users' => "'''{{SITENAME}}''' ma tuchylu '''$1''' {{PLURAL:$1|wužywarja|wužywarjowu|wužywarjow|wužywarjow}} z [[{{MediaWiki:Validationpage}}|pšawami wobźěłowarja]]
a '''$2''' {{PLURAL:$2|wužywarja|wužywarjowu|wužywarjow|wužywarjow}} z [[{{MediaWiki:Validationpage}}|pšawami pśeglědowarja]].",
	'validationstatistics-table' => "Slědujo statistika za kuždy mjenjowy rum, mimo dalejpósrědnjenjow.

'''Glědaj:''' slědujuce daty pufruju se na někotare goźiny a mógu togodla njeaktualne byś.",
	'validationstatistics-ns' => 'Mjenjowy rum',
	'validationstatistics-total' => 'Boki',
	'validationstatistics-stable' => 'Pśeglědane',
	'validationstatistics-latest' => 'Tuchylu pśeglědane',
	'validationstatistics-synced' => 'Synchronizěrowane/Pśeglědane',
	'validationstatistics-old' => 'Zestarjone',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'validationstatistics' => 'Validigadaj statistikoj',
	'validationstatistics-users' => "'''{{SITENAME}}''' nun havas '''$1''' {{PLURAL:$1|uzanton|uzantojn}} kun
[[{{MediaWiki:Validationpage}}|Revizianto]]-rajtoj
kaj '''$2''' {{PLURAL:$2|uzanton|uzantojn}} kun [[{{MediaWiki:Validationpage}}|Kontrolanto]]-rajtoj.",
	'validationstatistics-table' => "Statistikoj por ĉiu nomspaco estas jene montritaj, krom alidirektiloj.

'''Notu:''' la jenaj datenoj estas en kaŝmemoro dum multaj horoj kaj eble ne estas ĝisdataj.",
	'validationstatistics-ns' => 'Nomspaco',
	'validationstatistics-total' => 'Paĝoj',
	'validationstatistics-stable' => 'Paĝoj kun almenaŭ unu revizio',
	'validationstatistics-latest' => 'Laste reviziita',
	'validationstatistics-synced' => 'Ĝisdatigitaj/Reviziitaj',
	'validationstatistics-old' => 'Malfreŝaj',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 */
$messages['es'] = array(
	'validationstatistics-ns' => 'Espacio de nombres',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Revisado',
	'validationstatistics-latest' => 'El último revisado',
	'validationstatistics-old' => 'desactualizado',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'validationstatistics' => 'Balioztatzeko estatistikak',
	'validationstatistics-total' => 'Orrialdeak',
	'validationstatistics-old' => 'Deseguneratua',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'validationstatistics' => 'آمار معتبرسازی',
	'validationstatistics-users' => "'''{{SITENAME}}''' در حال حاضر '''$1''' {{PLURAL:$1|کاربر|کاربر}} با اختیارات [[{{MediaWiki:Validationpage}}|ویرایشگر]] و '''$2''' {{PLURAL:$2|کاربر|کاربر}} با اختیارات[[{{MediaWiki:Validationpage}}|مرورگر]] دارد.",
	'validationstatistics-table' => "'''نکته:''' داده‌هایی که در ادامه می‌آید برای چندین ساعت در میان‌گیر ذخیره شده‌اند و ممکن است به روز نباشند.",
	'validationstatistics-ns' => 'فضای نام',
	'validationstatistics-total' => 'صفحه‌ها',
	'validationstatistics-stable' => 'بازبینی شده',
	'validationstatistics-latest' => 'آخرین بازبینی',
	'validationstatistics-synced' => 'به روز شده/بازبینی شده',
	'validationstatistics-old' => 'تاریخ گذشته',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'validationstatistics' => 'Validointitilastot',
	'validationstatistics-ns' => 'Nimiavaruus',
	'validationstatistics-total' => 'Sivut',
	'validationstatistics-stable' => 'Arvioitu',
	'validationstatistics-old' => 'Vanhentunut',
);

/** French (Français)
 * @author Grondin
 * @author McDutchie
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'validationstatistics' => 'Statistiques de validation',
	'validationstatistics-users' => "'''{{SITENAME}}''' dispose actuellement de '''$1''' {{PLURAL:$1|utilisateur|utilisateurs}} avec les droits d’[[{{MediaWiki:Validationpage}}|éditeur]] et de '''$2''' {{PLURAL:$2|utilisateur|utilisateurs}} avec les droits de [[{{MediaWiki:Validationpage}}|relecteur]].",
	'validationstatistics-table' => "Les statistiques pour chaque espace de nom sont affichées ci-dessous, à l’exclusion des pages de redirection.

'''Note :''' les données suivantes sont cachées pendant plusieurs heures et ne peuvent pas être mises à jour.",
	'validationstatistics-ns' => 'Espace de noms',
	'validationstatistics-total' => 'Pages',
	'validationstatistics-stable' => 'Relu',
	'validationstatistics-latest' => 'Relu en tout dernier lieu',
	'validationstatistics-synced' => 'Synchronisé/Relu',
	'validationstatistics-old' => 'Désuet',
	'validationstatistics-nbr' => '$1&nbsp;%',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'validationstatistics-ns' => 'Ainmspás',
	'validationstatistics-total' => 'Leathanaigh',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'validationstatistics' => 'Estatísticas de validación',
	'validationstatistics-users' => "Actualmente, '''{{SITENAME}}''' ten '''$1''' {{PLURAL:$1|usuario|usuarios}} con dereitos de [[{{MediaWiki:Validationpage}}|editor]] e '''$2''' {{PLURAL:$2|usuario|usuarios}} con dereitos de [[{{MediaWiki:Validationpage}}|revisor]].",
	'validationstatistics-table' => "As estatísticas para cada espazo de nomes son amosadas embaixo, excluíndo as páxinas de redirección.

'''Nota:''' os seguintes datos están na memoria caché durante varias horas e poden non estar actualizados.",
	'validationstatistics-ns' => 'Espazo de nomes',
	'validationstatistics-total' => 'Páxinas',
	'validationstatistics-stable' => 'Revisado',
	'validationstatistics-latest' => 'Última revisión',
	'validationstatistics-synced' => 'Sincronizado/Revisado',
	'validationstatistics-old' => 'Anticuado',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'validationstatistics' => 'Στατιστικὰ ἐπικυρώσεων',
	'validationstatistics-ns' => 'Ὀνοματεῖον',
	'validationstatistics-total' => 'Δέλτοι',
	'validationstatistics-stable' => 'Ἀναθεωρημένη',
	'validationstatistics-latest' => 'Ὑστάτη ἀναθεωρημένη',
	'validationstatistics-synced' => 'Συγχρονισμένη/Ἐπιθεωρημένη',
	'validationstatistics-old' => 'Ἀπηρχαιωμένη',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'validationstatistics' => 'Markierigsstatischtik',
	'validationstatistics-users' => "{{SITENAME}} het '''$1''' {{PLURAL:$1|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Sichterrächt]] un '''$2''' {{PLURAL:$2|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Prieferrächt]].",
	'validationstatistics-table' => "Statischtike fir jede Namensruum, dervu usgnuu sin Wyterleitige.

'''Wichtig:''' Die Date wäre als fir e paar Stund in Zwischespicher abglait und sin wäg däm vilicht nid alliwyl aktuäll.",
	'validationstatistics-ns' => 'Namensruum',
	'validationstatistics-total' => 'Syte insgsamt',
	'validationstatistics-stable' => 'Zmindescht ei Version isch gsichtet.',
	'validationstatistics-latest' => 'Syte, wu di letscht Version vun ene gsichtet isch.',
	'validationstatistics-synced' => 'Prozäntsatz vu dr Syte, wu gsichtet sin.',
	'validationstatistics-old' => 'Syte mit Versione, wu nid gsichtet sin.',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author DoviJ
 * @author Erel Segal
 * @author Rotemliss
 */
$messages['he'] = array(
	'validationstatistics' => 'סטיסטיקת אישורים',
	'validationstatistics-users' => "'''יש כרגע {{PLURAL:$1|משתמש '''אחד'''|'''$1''' משתמשים}} ב{{SITENAME}} עם הרשאת [[{{MediaWiki:Validationpage}}|עורך]] ו{{PLURAL:$2|משתמש '''אחד'''|־'''$2''' משתמשים}} עם הרשאת [[{{MediaWiki:Validationpage}}|בודק דפים]].'''",
	'validationstatistics-table' => "סטטיסטיקות לכל מרחב שם מוצגות להלן, תוך התעלמות מדפי הפניה.

'''הערה:''' הנתונים הבאים נשמרים למשך כמה שעות, וייתכן שאינם עדכניים.",
	'validationstatistics-ns' => 'מרחב שם',
	'validationstatistics-total' => 'דפים',
	'validationstatistics-stable' => 'עבר ביקורת',
	'validationstatistics-latest' => 'בדיקות אחרונות',
	'validationstatistics-synced' => 'סונכרנו/נבדקו',
	'validationstatistics-old' => 'פג תוקף',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'validationstatistics-ns' => 'Imenski prostor',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'validationstatistics' => 'Pohódnoćenska statistika',
	'validationstatistics-users' => "'''{{SITENAME}}''' ma tuchwilu '''$1''' {{PLURAL:$1|wužiwarja|wužiwarjow|wužiwarjow|wužiwarjow}} z [[{{MediaWiki:Validationpage}}|prawami wobdźěłowarja]]
a '''$2''' {{PLURAL:$2|wužiwarja|wužiwarjow|wužiwarjow|wužiwarjow}} z [[{{MediaWiki:Validationpage}}|prawami kontrolera]].",
	'validationstatistics-table' => "Slěduje statistika za kóždy mjenowy rum, z wuwzaćom daleposrědkowanjow.

'''Kedźbu:''' Slědowace daty budu na wjacore hodźiny w pufrowaku a móža njeaktualne być.",
	'validationstatistics-ns' => 'Mjenowy rum',
	'validationstatistics-total' => 'Strony',
	'validationstatistics-stable' => 'Skontrolowane',
	'validationstatistics-latest' => 'Poslednje skontrolowane',
	'validationstatistics-synced' => 'Synchronizowane/Skontrolowane',
	'validationstatistics-old' => 'Zestarjene',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Samat
 */
$messages['hu'] = array(
	'validationstatistics' => 'Ellenőrzési statisztika',
	'validationstatistics-users' => "A(z) '''{{SITENAME}}''' wikinek jelenleg '''{{PLURAL:$1|egy|$1}}''' [[{{MediaWiki:Validationpage}}|járőrjoggal]], valamint '''{{PLURAL:$2|egy|$2}}''' [[{{MediaWiki:Validationpage}}|lektorjoggal]] rendelkező szerkesztője van.",
	'validationstatistics-table' => "Lent a névterekre bontott statisztika látható, az átirányítások nincsenek beleszámolva.

'''Megjegyzés:''' az adatok néhány órás időközönként gyorsítótárazva vannak, így nem feltétlenül pontosak.",
	'validationstatistics-ns' => 'Névtér',
	'validationstatistics-total' => 'Oldalak',
	'validationstatistics-stable' => 'Ellenőrzött',
	'validationstatistics-latest' => 'Legutóbb ellenőrzött',
	'validationstatistics-synced' => 'Szinkronizálva/ellenőrizve',
	'validationstatistics-old' => 'Elavult',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'validationstatistics' => 'Statisticas de validation',
	'validationstatistics-users' => "'''{{SITENAME}}''' ha al momento '''$1''' {{PLURAL:$1|usator|usatores}} con derectos de [[{{MediaWiki:Validationpage}}|Contributor]] e '''$2''' {{PLURAL:$2|usator|usatores}} con derectos de [[{{MediaWiki:Validationpage}}|Revisor]].",
	'validationstatistics-table' => "Le statisticas pro cata spatio de nomines es monstrate infra, excludente le paginas de redirection.

'''Nota:''' le sequente datos es extrahite de un copia ''cache'' del base de datos, non actualisate in tempore real.",
	'validationstatistics-ns' => 'Spatio de nomines',
	'validationstatistics-total' => 'Paginas',
	'validationstatistics-stable' => 'Revidite',
	'validationstatistics-latest' => 'Ultime revidite',
	'validationstatistics-synced' => 'Synchronisate/Revidite',
	'validationstatistics-old' => 'Obsolete',
	'validationstatistics-nbr' => '$1%',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'validationstatistics' => 'Statistik validasi',
	'validationstatistics-users' => "'''{{SITENAME}}''' saat ini memiliki '''$1''' {{PLURAL:$1|pengguna|pengguna}} dengan hak akses [[{{MediaWiki:Validationpage}}|Editor]] dan
'''$2''' {{PLURAL:$2|pengguna|pengguna}} dengan hak akses [[{{MediaWiki:Validationpage}}|Peninjau]].",
	'validationstatistics-table' => "Statistik untuk setiap ruang nama ditampilkan di bawah ini, kecuali halaman pengalihan.

'''Catatan''': Data di bawah ini diambil dari tembolok beberapa jam yang lalu dan mungkin belum mencakup data terbaru.",
	'validationstatistics-ns' => 'Ruang nama',
	'validationstatistics-total' => 'Halaman',
	'validationstatistics-stable' => 'Telah ditinjau',
	'validationstatistics-latest' => 'Terakhir ditinjau',
	'validationstatistics-synced' => 'Sinkron/Tertinjau',
	'validationstatistics-old' => 'Usang',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'validationstatistics' => 'Statistiche di convalidazione',
	'validationstatistics-users' => "Al momento, su '''{{SITENAME}}''' {{PLURAL:$1|c'è '''$1''' utente|ci sono '''$1''' utenti}} con i diritti di [[{{MediaWiki:Validationpage}}|Editore]] e '''$2''' {{PLURAL:$2|utente|utenti}} con i diritti di [[{{MediaWiki:Validationpage}}|Revisore]].",
	'validationstatistics-table' => "Le statistiche per ciascun namaspace sono mostrate di seguito, a esclusione dei redirect.

'''Nota:''' i dati che seguono sono estratti da una copia ''cache'' del database, non aggiornati in tempo reale.",
	'validationstatistics-ns' => 'Namespace',
	'validationstatistics-total' => 'Pagine',
	'validationstatistics-stable' => 'Revisionate',
	'validationstatistics-latest' => 'Ultime revisionate',
	'validationstatistics-old' => 'Non aggiornate',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'validationstatistics-ns' => '名前空間',
	'validationstatistics-total' => 'ページ',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'validationstatistics' => 'Statistik validasi',
	'validationstatistics-users' => "'''{{SITENAME}}''' wektu iki nduwé '''$1''' {{PLURAL:$1|panganggo|panganggo}} kanthi hak aksès [[{{MediaWiki:Validationpage}}|Editor]] lan '''$2''' {{PLURAL:$2|panganggo|panganggo}} kanthi hak aksès [[{{MediaWiki:Validationpage}}|Pamriksa]].",
	'validationstatistics-table' => "Statistik kanggo saben bilik jeneng ditampilaké ing ngisor, kajaba kaca pangalihan.

'''Cathetan''': Data ing ngisor dijupuk saka ''cache'' sawetara jam kapungkur lan mbokmanawa ora cocog manèh.",
	'validationstatistics-ns' => 'Bilik jeneng',
	'validationstatistics-total' => 'Kaca',
	'validationstatistics-stable' => 'Wis dipriksa',
	'validationstatistics-latest' => 'Pungkasan dipriksa',
	'validationstatistics-synced' => 'Wis disinkronaké/Wis dipriksa',
	'validationstatistics-old' => 'Lawas',
	'validationstatistics-nbr' => '$1%',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'validationstatistics-ns' => 'លំហឈ្មោះ',
	'validationstatistics-total' => 'ទំព័រ',
	'validationstatistics-old' => 'ហួសសម័យ',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'validationstatistics-users' => "'''{{SITENAME}}'''에는 $1명의 [[{{MediaWiki:Validationpage}}|편집자]] 권한을 가진 사용자와 $2명의 [[{{MediaWiki:Validationpage}}|평론가]] 권한을 가진 사용자가 있습니다.",
	'validationstatistics-ns' => '이름공간',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'validationstatistics-users' => " De '''{{SITENAME}}''' hät em Momang {{PLURAL:$1|'''eine''' Metmaacher|'''$1''' Metmaachere|'''keine''' Metmaacher}} met Rääsch, ene [[{{MediaWiki:Validationpage}}|Editor]] ze maache, un {{PLURAL:$2|'''eine''' Metmaacher|'''$2''' Metmaacher|'''keine''' Metmaacher}} met däm [[{{MediaWiki:Validationpage}}|Reviewer]]-Rääsch.",
	'validationstatistics-table' => "Statistike för jedes Appachtemang (oohne de Sigge met Ömleijdunge)

'''Opjepaß:''' De Date hee noh sen för e paa Stond zweschespeichert, se künnte alsu nit janz de neuste sin.",
	'validationstatistics-ns' => 'Appachtemang',
	'validationstatistics-total' => 'Sigge jesamp',
	'validationstatistics-nbr' => '$1%',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'validationstatistics' => 'Statistike vun de Validaiounen',
	'validationstatistics-users' => "''{{SITENAME}}''' huet elo '''$1''' {{PLURAL:$1|Benotzer|Benotzer}} mat [[{{MediaWiki:Validationpage}}|Editeursrechter]]
an '''$2''' {{PLURAL:$2|Benotzer|Benotzer}} mat [[{{MediaWiki:Validationpage}}|Validatiounsrechter]].",
	'validationstatistics-ns' => 'Nummraum',
	'validationstatistics-total' => 'Säiten',
	'validationstatistics-stable' => 'Validéiert',
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'validationstatistics-ns' => 'Именски простор',
	'validationstatistics-total' => 'Страници',
	'validationstatistics-stable' => 'Прегледување',
	'validationstatistics-latest' => 'Последно прегледување',
);

/** Malayalam (മലയാളം)
 * @author Sadik Khalid
 */
$messages['ml'] = array(
	'validationstatistics' => 'സ്ഥിരീകരണ കണക്കുകള്‍',
	'validationstatistics-users' => "'''{{SITENAME}}''' പദ്ധതിയില്‍ '''$1''' {{PLURAL:$1|ഉപയോക്താവ്|ഉപയോക്താക്കള്‍}} [[{{MediaWiki:Validationpage}}|സംശോധകര്‍]] അധികാരമുള്ളവരും '''$2''' {{PLURAL:$2|ഉപയോക്താവ്|ഉപയോക്താക്കള്‍}} [[{{MediaWiki:Validationpage}}|പരിശോധകര്‍]] അധികാരമുള്ളവരും നിലവിലുണ്ട്.",
	'validationstatistics-ns' => 'നാമമേഖല',
	'validationstatistics-total' => 'താളുകള്‍',
	'validationstatistics-stable' => 'പരിശോധിച്ചവ',
	'validationstatistics-latest' => 'ഒടുവില്‍ പരിശോധിച്ചവ',
	'validationstatistics-synced' => 'ഏകകാലികമാക്കിയവ/പരിശോധിച്ചവ',
	'validationstatistics-old' => 'കാലഹരണപ്പെട്ടവ',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'validationstatistics' => 'Statistik pengesahan',
	'validationstatistics-users' => "'''{{SITENAME}}''' kini mempunyai {{PLURAL:$1|seorang|'''$1''' orang}} pengguna dengan hak [[{{MediaWiki:Validationpage}}|Penyunting]] dan {{PLURAL:$2|seorang|'''$2''' orang}} pengguna dengan hak [[{{MediaWiki:Validationpage}}|Pemeriksa]].",
	'validationstatistics-table' => "Yang berikut ialah statistik bagi setiap ruang nama, tidak termasuk laman lencongan.

'''Catatan:''' data berikut diambil daripada cache yang disimpan sejak beberapa jam yang lalu dan kemungkinan besar bukan yang terkini.",
	'validationstatistics-ns' => 'Ruang nama',
	'validationstatistics-total' => 'Laman',
	'validationstatistics-stable' => 'Diperiksa',
	'validationstatistics-latest' => 'Pemeriksaan terakhir',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'validationstatistics-ns' => 'Лем потмо',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'validationstatistics' => 'Eindredactiestatistieken',
	'validationstatistics-users' => "'''{{SITENAME}}''' heeft op het moment '''$1''' {{PLURAL:$1|gebruiker|gebruikers}} in de rol van [[{{MediaWiki:Validationpage}}|Redacteur]] en '''$2''' {{PLURAL:$2|gebruiker|gebruikers}} met de rol [[{{MediaWiki:Validationpage}}|Eindredacteur]].",
	'validationstatistics-table' => "Hieronder staan statistieken voor iedere naamruimte, exclusief doorverwijzingen.

'''Let op:''' de onderstaande gegevens komen uit een cache, en kunnen tot enkele uren oud zijn.",
	'validationstatistics-ns' => 'Naamruimte',
	'validationstatistics-total' => "Pagina's",
	'validationstatistics-stable' => 'Eindredactie afgerond',
	'validationstatistics-latest' => 'Meest recente eindredacties',
	'validationstatistics-synced' => 'Gesynchroniseerd/Eindredactie',
	'validationstatistics-old' => 'Verouderd',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'validationstatistics-ns' => 'Namnerom',
	'validationstatistics-total' => 'Sider',
	'validationstatistics-old' => 'Utdatert',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'validationstatistics' => 'Valideringsstatistikk',
	'validationstatistics-users' => "'''{{SITENAME}}''' har '''$1''' {{PLURAL:$1|bruker|brukere}} med [[{{MediaWiki:Validationpage}}|skribentrettigheter]] og '''$2''' {{PLURAL:$2|bruker|brukere}} med [[{{MediaWiki:Validationpage}}|anmelderrettigheter]].",
	'validationstatistics-table' => "Statistikk for hvert navnerom vises nedenfor, utenom omdirigeringssider.

'''Merk:''' Følgende data mellomlagres i flere timer og kan være foreldet.",
	'validationstatistics-ns' => 'Navnerom',
	'validationstatistics-total' => 'Sider',
	'validationstatistics-stable' => 'Anmeldt',
	'validationstatistics-latest' => 'Sist anmeldt',
	'validationstatistics-synced' => 'Synkronisert/Anmeldt',
	'validationstatistics-old' => 'Foreldet',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'validationstatistics' => 'Estatisticas de validacion',
	'validationstatistics-users' => "'''{{SITENAME}}''' dispausa actualament de '''$1''' {{PLURAL:$1|utilizaire|utilizaires}} amb los dreches d’[[{{MediaWiki:Validationpage}}|editor]] e de '''$2''' {{PLURAL:$2|utilizaire|utilizaires}} amb los dreches de [[{{MediaWiki:Validationpage}}|relector]].",
	'validationstatistics-table' => "Las estatisticas per cada espaci de nom son afichadas çaijós, a l’exclusion de las paginas de redireccion.

'''Nòta :''las donadas seguentas son amagadas pendent maitas oras e pòdon pas èsser mesas a jorn.",
	'validationstatistics-ns' => 'Nom de l’espaci',
	'validationstatistics-total' => 'Paginas',
	'validationstatistics-stable' => 'Relegit',
	'validationstatistics-latest' => 'Relegit en tot darrièr luòc',
	'validationstatistics-synced' => 'Sincronizat/Relegit',
	'validationstatistics-old' => 'Desuet',
);

/** Polish (Polski)
 * @author Jwitos
 * @author Leinad
 * @author Wpedzich
 */
$messages['pl'] = array(
	'validationstatistics' => 'Statystyki oznaczania',
	'validationstatistics-users' => "W serwisie '''{{SITENAME}}''' aktualnie zarejestrowanych jest '''$1''' {{PLURAL:$1|użytkownik|użytkowników}} z uprawnieniami [[{{MediaWiki:Validationpage}}|redaktora]] oraz  '''$2''' {{PLURAL:$2|użytkownik|użytkowników}} z uprawnieniami [[{{MediaWiki:Validationpage}}|weryfikatora]].",
	'validationstatistics-table' => "Poniżej znajdują się statystyki dla każdej przestrzeni nazw, z wyłączeniem przekierowań.

'''Uwaga:''' poniższe dane są kopią z pamięci podręcznej sprzed nawet kilku godzin, mogą więc być nieaktualne.",
	'validationstatistics-ns' => 'Przestrzeń nazw',
	'validationstatistics-total' => 'Stron',
	'validationstatistics-stable' => 'Przejrzanych',
	'validationstatistics-latest' => 'Z ostatnią edycją oznaczoną jako przejrzana',
	'validationstatistics-synced' => 'Zsynchronizowana/przejrzana',
	'validationstatistics-old' => 'Wymagające ponownego oznaczenia jako przejrzane',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'validationstatistics-ns' => 'نوم-تشيال',
	'validationstatistics-total' => 'مخونه',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 */
$messages['pt'] = array(
	'validationstatistics' => 'Estatísticas de validações',
	'validationstatistics-users' => "'''{{SITENAME}}''' possui, no momento, '''$1''' {{PLURAL:$1|utilizador|utilizadores}} com privilégios de [[{{MediaWiki:Validationpage}}|{{int:group-editor-member}}]] e '''$2''' {{PLURAL:$2|utilizador|utilizadores}} com privilégios de [[{{MediaWiki:Validationpage}}|{{int:group-reviewer-member}}]].",
	'validationstatistics-table' => "As estatísticas de cada espaço nominal são exibidas a seguir, exceptuando-se as páginas de redireccionamentos.

'''Nota:''' os dados a seguir estão armazenados em cache e podem não estar atualizados.",
	'validationstatistics-ns' => 'Espaço nominal',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Analisadas',
	'validationstatistics-latest' => 'Mais recente analisada',
	'validationstatistics-synced' => 'Sincronizadas/Analisadas',
	'validationstatistics-old' => 'Desactualizadas',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'validationstatistics-ns' => 'Spaţiu de nume',
	'validationstatistics-total' => 'Pagini',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'validationstatistics' => 'Statisteche de validazione',
	'validationstatistics-users' => "'''{{SITENAME}}''' jndr'à quiste mumende tène '''$1''' {{PLURAL:$1|utende|utinde}} cu le deritte de [[{{MediaWiki:Validationpage}}|cangiatore]] e '''$2''' {{PLURAL:$2|utende|utinde}} cu le deritte de[[{{MediaWiki:Validationpage}}|revisione]].",
	'validationstatistics-table' => "Le statisteche pe ogne niemspeise sonde mostrete aqquà sotte, 'scludenne le pàggene de redirezionaminde.

'''Vide Bbuene:''' 'u date seguende jè chesciete pe quacche ore e non ge se pò aggiornà a 'na certa date.",
	'validationstatistics-ns' => 'Neimspeise',
	'validationstatistics-total' => 'Pàggene',
	'validationstatistics-stable' => 'Riviste',
	'validationstatistics-latest' => 'Urtema revisione',
	'validationstatistics-synced' => 'Singronizzete/Riviste',
	'validationstatistics-old' => "Non g'è aggiornete",
);

/** Russian (Русский)
 * @author Ahonc
 * @author AlexSm
 * @author Ferrer
 * @author Putnik
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'validationstatistics' => 'Статистика проверок',
	'validationstatistics-users' => "В проекте {{SITENAME}} на данный момент '''$1''' {{plural:$1|участник|участника|участников}} имеют права [[{{MediaWiki:Validationpage}}|«редактора»]] и '''$2''' {{plural:$2|участник|участника|участников}} имеют права [[{{MediaWiki:Validationpage}}|«проверяющего»]].",
	'validationstatistics-table' => "Ниже представлена статистика по каждому пространству имён. Перенаправления из подсчётов исключены. 

'''Внимание!''' Страница кэшируется. Данные могут отставать на несколько часов.",
	'validationstatistics-ns' => 'Пространство',
	'validationstatistics-total' => 'Страниц',
	'validationstatistics-stable' => 'Проверенные',
	'validationstatistics-latest' => 'Недавно проверенные',
	'validationstatistics-synced' => 'Перепроверенные',
	'validationstatistics-old' => 'Устаревшие',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'validationstatistics' => 'Štatistiky overenia',
	'validationstatistics-users' => "'''{{SITENAME}}''' má momentálne '''$1''' {{PLURAL:$1|používateľa|používateľov}} s právami [[{{MediaWiki:Validationpage}}|redaktor]] a '''$2''' {{PLURAL:$2|používateľa|používateľov}} s právami [[{{MediaWiki:Validationpage}}|kontrolór]].",
	'validationstatistics-table' => "Dolu sú zobrazené štatistiky pre každý menný priestor okrem presmerovacích stránok.

'''Pozn.:''' nasledujúce údaje pochádzajú z vyrovnávacej pamäte a môžu byť niekoľko hodín staré.",
	'validationstatistics-ns' => 'Menný priestor',
	'validationstatistics-total' => 'Stránky',
	'validationstatistics-stable' => 'Skontrolované',
	'validationstatistics-latest' => 'Posledné skontrolované',
	'validationstatistics-synced' => 'Synchronizované/skontrolované',
	'validationstatistics-old' => 'Zastaralé',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'validationstatistics' => 'Valideringsstatistik',
	'validationstatistics-users' => "'''{{SITENAME}}''' har just nu '''$1''' {{PLURAL:$1|användare|användare}} med [[{{MediaWiki:Validationpage}}|redaktörsrättigheter]] och '''$2''' {{PLURAL:$2|användare|användare}} med [[{{MediaWiki:Validationpage}}|granskningsrättigheter]].",
	'validationstatistics-table' => "Statistik för varje namnrymd visas nedan, förutom omdirigeringssidor.

'''Notera:''' följande data är cachad för flera timmar och kan vara föråldrad.",
	'validationstatistics-ns' => 'Namnrymd',
	'validationstatistics-total' => 'Sidor',
	'validationstatistics-stable' => 'Granskad',
	'validationstatistics-latest' => 'Senast granskad',
	'validationstatistics-synced' => 'Synkad/Granskad',
	'validationstatistics-old' => 'Föråldrad',
);

/** Tamil (தமிழ்)
 * @author Ulmo
 */
$messages['ta'] = array(
	'validationstatistics-ns' => 'பெயர்வெளி',
	'validationstatistics-total' => 'பக்கங்கள்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'validationstatistics' => 'సరిచూత గణాంకాలు',
	'validationstatistics-total' => 'పేజీలు',
	'validationstatistics-old' => 'పాతవి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'validationstatistics-ns' => 'Espasu pájina nian',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'validationstatistics-ns' => 'เนมสเปซ',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'validationstatistics' => 'Mga estadistika ng pagpapatunay (balidasyon)',
	'validationstatistics-users' => "Ang '''{{SITENAME}}''' ay  pangkasalukuyang may '''$1''' {{PLURAL:$1|tagagamit|mga tagagamit}} na may karapatan bilang [[{{MediaWiki:Validationpage}}|Patnugot]] 
at '''$2''' {{PLURAL:$2|tagagamit|mga tagagamit}} na may karapatan bilang [[{{MediaWiki:Validationpage}}|Tagapagsuri]].",
	'validationstatistics-table' => "Ipinapakita sa ibaba ang mga estadistika (palaulatan) para sa bawat espasyo ng pangalan, hindi kasama ang mga pahina ng mga panuto/panturo.

'''Paunawa:''' ang sumusunod na mga dato ay itinago (naka-''cache'') ng ilang mga oras at maaaring hindi nasasapanahon.",
	'validationstatistics-ns' => 'Espasyo ng pangalan',
	'validationstatistics-total' => 'Mga pahina',
	'validationstatistics-stable' => 'Nasuri na',
	'validationstatistics-latest' => 'Pinakahuling nasuri',
	'validationstatistics-synced' => 'Pinagsabay-sabay/Nasuri nang muli',
	'validationstatistics-old' => 'Wala na sa panahon (luma)',
	'validationstatistics-nbr' => '$1%',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'validationstatistics' => 'Doğrulama istatistikleri',
	'validationstatistics-users' => "'''{{SITENAME}}''' sitesinde şuanda [[{{MediaWiki:Validationpage}}|Editor]] yetkisine sahip '''$1''' {{PLURAL:$1|kullanıcı|kullanıcı}} ve [[{{MediaWiki:Validationpage}}|Reviewer]] yetkisine sahip '''$2''' {{PLURAL:$2|kullanıcı|kullanıcı}} bulunmaktadır.",
	'validationstatistics-table' => "Her bir ad alanı için istatistikler aşağıda gösterilmiştir, yönlendirme sayfaları hariç.

'''Not:''' aşağıdaki veri birkaç saat için önbellektedir ve güncel olmayabilir.",
	'validationstatistics-ns' => 'Ad alanı',
	'validationstatistics-total' => 'Sayfalar',
	'validationstatistics-stable' => 'Gözden geçirilmiş',
	'validationstatistics-latest' => 'En son gözden geçirilmiş',
	'validationstatistics-synced' => 'Eşitlenmiş/Gözden geçirilmiş',
	'validationstatistics-old' => 'Eski',
	'validationstatistics-nbr' => '%$1',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'validationstatistics' => 'Статистика перевірок',
	'validationstatistics-users' => "У {{grammar:locative|{{SITENAME}}}} зараз '''$1''' {{plural:$1|користувач має|користувачі мають|користувачів мають}} права [[{{MediaWiki:Validationpage}}|«редактор»]] і '''$2''' {{plural:$2|користувач має|користувачі мають|користувачів мають}} права [[{{MediaWiki:Validationpage}}|«рецензент»]].",
	'validationstatistics-table' => "Нижче наведена статистика по кожному простору назв. Перенаправлення не враховані.

'''Увага!''' Сторінка кешуються. Дані можуть відставати на кілька годин.",
	'validationstatistics-ns' => 'Простір назв',
	'validationstatistics-total' => 'Сторінок',
	'validationstatistics-stable' => 'Перевірені',
	'validationstatistics-latest' => 'Нещодавно перевірені',
	'validationstatistics-synced' => 'Повторно перевірені',
	'validationstatistics-old' => 'Застарілі',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'validationstatistics' => 'Thống kê phê chuẩn',
	'validationstatistics-users' => "Hiện nay, '''$1''' thành viên tại '''{{SITENAME}}''' có quyền [[{{MediaWiki:Validationpage}}|Chủ bút]] và '''$2''' thành viên có quyền [[{{MediaWiki:Validationpage}}|Người duyệt]].",
	'validationstatistics-table' => "Đây có thống kê về các không gian tên, trừ các trang đổi hướng.

'''Chú ý:''' Dữ liệu sau được nhớ đệm vài tiếng đồng hồ và có thể lỗi thời.",
	'validationstatistics-ns' => 'Không gian tên',
	'validationstatistics-total' => 'Số trang',
	'validationstatistics-stable' => 'Được duyệt',
	'validationstatistics-latest' => 'Được duyệt gần đây',
	'validationstatistics-synced' => 'Cập nhật/Duyệt',
	'validationstatistics-old' => 'Lỗi thời',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'validationstatistics-ns' => 'נאמענטייל',
	'validationstatistics-total' => 'בלעטער',
);

