<?php
/**
 * Internationalisation file for FlaggedRevs extension, section ValidationStatistics
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'validationstatistics'        => 'Validation statistics',
	'validationstatistics-users'  => '\'\'\'{{SITENAME}}\'\'\' currently has \'\'\'[[Special:ListUsers/editor|$1]]\'\'\' {{PLURAL:$1|user|users}} with [[{{MediaWiki:Validationpage}}|Editor]] rights
and \'\'\'[[Special:ListUsers/reviewer|$2]]\'\'\' {{PLURAL:$2|user|users}} with [[{{MediaWiki:Validationpage}}|Reviewer]] rights.',
	'validationstatistics-time'   => '\'\'The following data is cached and may not be up to date.\'\'

The average wait for edits by \'\'users that have not logged in\'\' to be reviewed is \'\'\'$1\'\'\'; the median is \'\'\'$3\'\'\'. 
$4
The average lag for [[Special:OldReviewedPages|pages with unreviewed edits pending]] is \'\'\'$2\'\'\'.
These pages are considered \'\'outdated\'\'. Likewise, pages are considered \'\'synchronized\'\' if the [[{{MediaWiki:Validationpage}}|stable version]] is also the current draft version.
Stable versions are revisions of pages checked by at least one established user.',
	'validationstatistics-table'  => "Statistics for each namespace are shown below, ''excluding'' redirect pages.",
	'validationstatistics-ns'     => 'Namespace',
	'validationstatistics-total'  => 'Pages',
	'validationstatistics-stable' => 'Reviewed',
	'validationstatistics-latest' => 'Synced',
	'validationstatistics-synced' => 'Synced/Reviewed',
	'validationstatistics-old'    => 'Outdated',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Raymond
 */
$messages['qqq'] = array(
	'validationstatistics-time' => '{{FlaggedRevs}}
This message is shown on [http://de.wikipedia.org/wiki/Spezial:Markierungsstatistik?uselang=en Special:ValidationStatistics].

* $1: the average time in hhmmss
* $2: average lag in hhmmss
* $3: the median in hhmmss
* $4: a table in HTML syntax.',
	'validationstatistics-ns' => '{{Identical|Namespace}}',
	'validationstatistics-total' => '{{Identical|Pages}}',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'validationstatistics' => 'Kodvindoiden statistik',
	'validationstatistics-users' => "{{SITENAME}}-projektas nügüd' '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|kävutajal|kävutajil}} 
oma [[{{MediaWiki:Validationpage}}|«redaktoran»]] oiktused, i '''$2''' {{plural:$1|kävutajal|kävutajil}} 
oma [[{{MediaWiki:Validationpage}}|«kodvijan»]] oiktused.",
	'validationstatistics-time' => "''Alemba anttud andmused oma keširuidud i sikš voidas olda vanhtunuzin.''

Keskvarastuz ''registriruimatomiden kävutajiden'' redakcijoiden täht om '''$1'''; median om'''$3'''.
$4
Keskpidestuz [[Special:OldReviewedPages|lehtpoliden kodvmatomiden redakcijoidenke]] täht om '''$2'''.",
	'validationstatistics-table' => "Alemba om anttud statistikad kaikuččen nimiavarusen täht. Läbioigendad oma heittud neciš statistikaspäi.
''Vanhtunuzikš'' kuctas lehtpolid, kudambad oma redaktiruidud jäl'ges stabilišt versijad.
Ku stabiline versii om jäl'gmäine, ka se kucuse ''sinhroniziruidud''.

'''Homičend.''' Nece lehtpol' keširuiše. Andmusiden nägu voib olda vanhtunuden.",
	'validationstatistics-ns' => 'Nimiavaruz',
	'validationstatistics-total' => "Lehtpol't",
	'validationstatistics-stable' => 'Kodvdud',
	'validationstatistics-latest' => 'Tantoi kodvdud',
	'validationstatistics-synced' => 'Kodvdud udes',
	'validationstatistics-old' => 'Vanhtunuded',
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
	'validationstatistics-users' => "'''{{SITENAME}}''' لديه حاليا '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|محرر]]
و '''$2''' {{PLURAL:$2|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|مراجع]].",
	'validationstatistics-time' => "''البيانات التالية مخزنة وربما لا تكون محدثة.''

الانتظار المتوسط للتعديلات بواسطة ''المستخدمين الذين لم يسجلوا الدخول'' هو '''$1'''؛ المتوسط العام هو '''$3'''.
$4
التأخر المتوسط [[Special:OldReviewedPages|للصفحات ذات التعديلات غير المراجعة قيد الانتظار]] هو '''$2'''.
هذه الصفحات تعتبر ''مخزنة''. وبالمثل، الصفحات تعتبر ''محدثة'' إذا كانت [[{{MediaWiki:Validationpage}}|النسخة المستقرة]] هي أيضا نسخة المسودة الحالية.
النسخ المستقرة هي نسخ الصفحات التي تم التحقق منها بواسطة مستخدم موثوق واحد على الأقل.",
	'validationstatistics-table' => "الإحصاءات لكل نطاق معروضة بالأسفل، ''ولا يشمل ذلك'' صفحات التحويل.",
	'validationstatistics-ns' => 'النطاق',
	'validationstatistics-total' => 'الصفحات',
	'validationstatistics-stable' => 'مراجع',
	'validationstatistics-latest' => 'محدث',
	'validationstatistics-synced' => 'تم تحديثه/تمت مراجعته',
	'validationstatistics-old' => 'قديمة',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'validationstatistics' => 'إحصاءات التحقق',
	'validationstatistics-users' => "'''{{SITENAME}}''' لديه حاليا '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|محرر]]
و '''$2''' {{PLURAL:$2|مستخدم|مستخدم}} بصلاحيات [[{{MediaWiki:Validationpage}}|مراجع]].",
	'validationstatistics-time' => "متوسط انتظار التعديلات لـ''اليوزرات اللى ماسجلوش دخولهم'' هو '''$1'''. 
متوسط التأخير لـ [[Special:OldReviewedPages|الصفحات القديمه]] هو '''$2'''.",
	'validationstatistics-table' => "الاحصائيات لكل نطاق معروضه تحت ، ''من غير'' صفحات التحويل.
الصفحات ''القديمه''  هى اللى بتبقا فيها تعديلات احدث من النسخه الثابته.
لو النسخه الثابته هى نفسها اخر نسخه ، ساعتها الصفحه دى بتبقا ''متحدثه''.

''خد بالك: البيانات اللى تحت دى بتبقا متخزنه كذا ساعه و ممكن ما تكونش متحدثه.''",
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
	'validationstatistics-users' => "'''{{SITENAME}}''' цяпер налічвае '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|удзельніка|удзельнікі|удзельнікаў}} з правамі [[{{MediaWiki:Validationpage}}|«рэдактара»]] і '''$2'''  {{PLURAL:$2|удзельніка|удзельнікі|удзельнікаў}} з правамі [[{{MediaWiki:Validationpage}}|«правяраючага»]].",
	'validationstatistics-table' => "Статыстыка для кожнай прасторы назваў пададзеная ніжэй, за ''выключэньнем'' старонак-перанакіраваньняў.",
	'validationstatistics-ns' => 'Прастора назваў',
	'validationstatistics-total' => 'Старонак',
	'validationstatistics-stable' => 'Правераных',
	'validationstatistics-latest' => 'Сынхранізаваных',
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

/** Catalan (Català)
 * @author Aleator
 */
$messages['ca'] = array(
	'validationstatistics-ns' => "Nom d'espai",
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'validationstatistics-total' => 'страни́цѧ',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Melancholie
 * @author Umherirrender
 */
$messages['de'] = array(
	'validationstatistics' => 'Markierungsstatistik',
	'validationstatistics-users' => "'''{{SITENAME}}''' hat '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Sichterrecht]]
und '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$2|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Prüferrecht]].",
	'validationstatistics-time' => "''Hinweis: Die folgenden Daten werden jeweils für mehrere Stunden zwischengespeichert und sind daher nicht immer aktuell.''

Die durchschnittliche Wartezeit für Bearbeitungen, die von nicht angemeldeten Benutzern stammen, beträgt '''$1'''; der Median beträgt '''$3'''.
$4
Der durchschnittliche Rückstand auf [[Special:OldReviewedPages|veraltete Seiten]] beträgt '''$2'''.
''Veraltete'' Seiten sind Seiten mit Bearbeitungen, die neuer als die markierte Version sind.
Wenn die markierte Version auch die letzte Version ist, ist die Seite ''synchronisiert''.",
	'validationstatistics-table' => "Statistiken für jeden Namensraum, ''ausgenommen'' sind Weiterleitungen.",
	'validationstatistics-ns' => 'Namensraum',
	'validationstatistics-total' => 'Seiten gesamt',
	'validationstatistics-stable' => 'Mindestens eine Version gesichtet',
	'validationstatistics-latest' => 'Anzahl Seiten, die in der aktuellen Version gesichtet sind',
	'validationstatistics-synced' => 'Prozentsatz an Seiten, die in der aktuellen Version gesichtet sind',
	'validationstatistics-old' => 'Seiten mit ungesichteten Versionen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'validationstatistics' => 'Pógódnośeńska statistika',
	'validationstatistics-users' => "'''{{SITENAME}}''' ma tuchylu '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|wužywarja|wužywarjowu|wužywarjow|wužywarjow}} z [[{{MediaWiki:Validationpage}}|pšawami wobźěłowarja]]
a '''$2''' {{PLURAL:$2|wužywarja|wužywarjowu|wužywarjow|wužywarjow}} z [[{{MediaWiki:Validationpage}}|pšawami pśeglědowarja]].",
	'validationstatistics-time' => "''Slědujuce daty pufruju se a mógu njeaktualne byś.''

Pśerězne cakanje za změny wót ''wužywarjow, kótarež njejsu pśizjawjone'', kótarež dej se pśeglědaś, jo '''$1'''; mediana gódnota jo '''$3'''.
$4
Pśerězne wokomuźenje za [[Special:OldReviewedPages|boki z njepśeglědanymi změnami]] jo '''$2'''.
Toś te boki maju se za ''zestarjone''. Teke boki maju se za ''synchronizěrowane'', jolic [[{{MediaWiki:Validationpage}}|stabilna wersija]] jo teke aktualna nacerjeńska wersija.
Stabilne wersije su wersije bokow, kótarež su wót nanejmjenjej jadnogo pśipóznatego wužywarja pśekontrolěrowane.",
	'validationstatistics-table' => "Slěduju statistiki za kuždy mjenjowy rum, ''bźez'' dalejpósrědnjenjow.",
	'validationstatistics-ns' => 'Mjenjowy rum',
	'validationstatistics-total' => 'Boki',
	'validationstatistics-stable' => 'Pśeglědane',
	'validationstatistics-latest' => 'Synchronizěrowany',
	'validationstatistics-synced' => 'Synchronizěrowane/Pśeglědane',
	'validationstatistics-old' => 'Zestarjone',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Dead3y3
 */
$messages['el'] = array(
	'validationstatistics' => 'Στατιστικά επικύρωσης',
	'validationstatistics-users' => "Ο ιστότοπος '''{{SITENAME}}''' αυτή τη στιγμή έχει '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|χρήστη|χρήστες}} με δικαιώματα [[{{MediaWiki:Validationpage}}|Συντάκτη]]
και '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$2|χρήστη|χρήστες}} με δικαιώματα [[{{MediaWiki:Validationpage}}|Κριτικού]].",
	'validationstatistics-time' => "Ο μέσος χρόνος αναμονής για επεξεργασίες από ''χρήστες που δεν έχουν συνδεθεί'' είναι '''$1'''· o διάμεσος είναι '''$3'''.
$4
Η μέση χρονική υστέρηση για [[Special:OldReviewedPages|σελίδες με επεξεργασίες που εκκρεμμούν κριτικής]] είναι '''$2'''.",
	'validationstatistics-table' => "Στατιστικά για κάθε περιοχή ονομάτων φαίνονται παρακάτω, ''εξαιρουμένων'' σελίδων ανακατεύθυνσης.
Οι ''παρωχημένες'' σελίδες είναι αυτές με επεξεργασίες νεότερες από την σταθερή έκδοση.
Αν η σταθερή έκδοση είναι επίσης η τελευταία έκδοση, τότε η σελίδα είναι ''συγχρονισμένη''.

''Σημείωση: τα ακόλουθα δεδομένα είναι αποθηκευμένα στην λανθάνουσα μνήμη για αρκετές ώρες και μπορεί να μην είναι ενημερωμένα.''",
	'validationstatistics-ns' => 'Περιοχή ονομάτων',
	'validationstatistics-total' => 'Σελίδες',
	'validationstatistics-stable' => 'Κρίθηκαν',
	'validationstatistics-latest' => 'Συγχρονισμένος',
	'validationstatistics-synced' => 'Συγχρονισμένες/Κρίθηκαν',
	'validationstatistics-old' => 'Παρωχημένες',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'validationstatistics' => 'Validigadaj statistikoj',
	'validationstatistics-users' => "'''{{SITENAME}}''' nun havas '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|uzanton|uzantojn}} kun
[[{{MediaWiki:Validationpage}}|Revizianto]]-rajtoj
kaj '''$2''' {{PLURAL:$2|uzanton|uzantojn}} kun [[{{MediaWiki:Validationpage}}|Kontrolanto]]-rajtoj.",
	'validationstatistics-time' => "'' La jena dateno estas en kaŝmemoro kaj eble ne estas ĝisdata.''

La averaĝa atendotempo por kontrolendaj redaktoj de ''nesalutita uzantoj'' estas '''$1'''; la mediano estas '''$3'''.
$4
La averaĝa atendotempo por [[Special:OldReviewedPages|paĝoj kun nekontrolitaj redaktoj farontaj]] estas '''$2'''.
Ĉi tiuj paĝoj estas konsiderataj kiel ''malfreŝaj''. Ankaŭ, paĝoj estas konsiderata ''sinkrona'' se la 
[[{{MediaWiki:Validationpage}}|stabila revizio]] ankaŭ estas la nuna netaĵo.
Stabilaj versioj estas revizioj de paĝoj kontrolita de almenaŭ unu establita uzanto.",
	'validationstatistics-table' => "Statistikoj por ĉiu nomspaco estas jene montritaj, ''krom'' alidirektiloj.",
	'validationstatistics-ns' => 'Nomspaco',
	'validationstatistics-total' => 'Paĝoj',
	'validationstatistics-stable' => 'Paĝoj kun almenaŭ unu revizio',
	'validationstatistics-latest' => 'Sinkronigita',
	'validationstatistics-synced' => 'Ĝisdatigitaj/Reviziitaj',
	'validationstatistics-old' => 'Malfreŝaj',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 */
$messages['es'] = array(
	'validationstatistics' => 'Estadísticas de validación',
	'validationstatistics-users' => "'''{{SITENAME}}''' actualmente hay '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|usuario|usuarios}} con derechos de [[{{MediaWiki:Validationpage}}|Editor]] y '''$2''' {{PLURAL:$2|usuario|usuarios}} con derechos de [[{{MediaWiki:Validationpage}}|Revisor]].",
	'validationstatistics-table' => "Estadísticas para cada nombre de sitio son mostradas debajo, ''excluyendo'' páginas de redireccionamiento.",
	'validationstatistics-ns' => 'Espacio de nombres',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Revisado',
	'validationstatistics-latest' => 'Sincronizado',
	'validationstatistics-synced' => 'Sincronizado/Revisado',
	'validationstatistics-old' => 'desactualizado',
);

/** Estonian (Eesti)
 * @author KalmerE.
 */
$messages['et'] = array(
	'validationstatistics' => 'Kinnitatud statistika',
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
	'validationstatistics-users' => "'''{{SITENAME}}''' در حال حاضر '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|کاربر|کاربر}} با اختیارات [[{{MediaWiki:Validationpage}}|ویرایشگر]] و '''$2''' {{PLURAL:$2|کاربر|کاربر}} با اختیارات[[{{MediaWiki:Validationpage}}|مرورگر]] دارد.",
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
 * @author IAlex
 * @author McDutchie
 * @author PieRRoMaN
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'validationstatistics' => 'Statistiques de validation',
	'validationstatistics-users' => "'''{{SITENAME}}''' dispose actuellement de '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utilisateur|utilisateurs}} avec les droits de [[{{MediaWiki:Validationpage}}|contributeur]] et de '''$2''' {{PLURAL:$2|utilisateur|utilisateurs}} avec les droits de [[{{MediaWiki:Validationpage}}|relecteur]].",
	'validationstatistics-time' => "''Les données suivantes sont en cache et peuvent ne pas être à jour.''

Le temps moyen de relecture des modifications par ''des utilisateurs non connectés'' est '''$1''' ; la valeur médiane est '''$3'''.
$4
Le délai moyen pour les [[Special:OldReviewedPages|pages qui contiennent des modifications non relues en cours]] est '''$2'''.
Ces pages sont considérées ''périmées''. De même, les pages sont déclarées ''synchronisées'' si la [[{{MediaWiki:Validationpage}}|version stable]] est aussi la version de brouillon courante.
Les versions stables sont des versions de pages vérifiées par au moins un utilisateur régulier.",
	'validationstatistics-table' => "Les statistiques pour chaque espace de noms sont affichées ci-dessous, à ''l’exclusion'' des pages de redirection.",
	'validationstatistics-ns' => 'Espace de noms',
	'validationstatistics-total' => 'Pages',
	'validationstatistics-stable' => 'Révisée',
	'validationstatistics-latest' => 'Synchronisée',
	'validationstatistics-synced' => 'Synchronisée/Révisée',
	'validationstatistics-old' => 'Périmée',
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
	'validationstatistics-users' => "Actualmente, '''{{SITENAME}}''' ten '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|usuario|usuarios}} con
dereitos de [[{{MediaWiki:Validationpage}}|editor]]
e '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$2|usuario|usuarios}} con dereitos de [[{{MediaWiki:Validationpage}}|revisor]].",
	'validationstatistics-time' => "''Os seguintes datos son da memoria caché e poden non estar actualizados.''

O promedio de espera de revisión para as edicións feitas polos ''usuarios que non accederon ao sistema'' é de '''$1'''; a media é de '''$3'''.  
$4
O promedio de retraso para as [[Special:OldReviewedPages|páxinas con edicións sen revisión]] é de '''$2'''.
Estas páxinas son consideradas ''obsoletas''. Do mesmo xeito, as páxinas son consideradas ''sincronizadas'' se a
[[{{MediaWiki:Validationpage}}|versión estable]] é tamén a versión do borrador actual.
As versións estables son revisións das páxinas comprobadas por, polo menos, un usuario autoconfirmado.",
	'validationstatistics-table' => "A continuación amósanse as estatísticas para cada espazo de nomes, ''excluíndo'' as páxinas de redirección.",
	'validationstatistics-ns' => 'Espazo de nomes',
	'validationstatistics-total' => 'Páxinas',
	'validationstatistics-stable' => 'Revisado',
	'validationstatistics-latest' => 'Sincronizado',
	'validationstatistics-synced' => 'Sincronizado/Revisado',
	'validationstatistics-old' => 'Obsoleto',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'validationstatistics' => 'Στατιστικὰ ἐπικυρώσεων',
	'validationstatistics-users' => "Τὸ '''{{SITENAME}}''' νῦν ἔχει '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|χρὠμενον|χρωμένους}} μετὰ δικαιωμάτων [[{{MediaWiki:Validationpage}}|μεταγραφέως]] καὶ '''$2''' {{PLURAL:$2|χρὠμενον|χρωμένους}} μετὰ δικαιωμάτων [[{{MediaWiki:Validationpage}}|ἐπιθεωρητοῦ]].",
	'validationstatistics-table' => "Στατιστικὰ δεδομένα διὰ πᾶν ὀνοματεῖον κάτωθι εἰσί, δέλτων ἀναδιευθύνσεως ''ἐξαιρουμένων''.",
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
	'validationstatistics-users' => "{{SITENAME}} het '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Sichterrächt]] un '''$2''' {{PLURAL:$2|Benutzer|Benutzer}} mit [[{{MediaWiki:Validationpage}}|Prieferrächt]].",
	'validationstatistics-time' => "''Die Date stammen us em Cache un s cha syy, ass si nit aktuäll sin.''

Di durschnittlig Wartezyt fir Bearbeitige vu ''Benutzer, wu nit aagmäldet sin'', wu no aagleugt sotte wäre, isch '''$1'''; dr Mittelwärt isch '''$3'''.
$4
Dr durschnittlig Ruckstand uf [[Special:OldReviewedPages|veralteti Syten]] isch '''$2'''.
Die Syte gälten as ''veraltet''. Ebeso gälte Syten as ''zytglych'' wänn di [[{{MediaWiki:Validationpage}}|aagluegt Version]] au di letscht Fassig isch.
Aagluegti Versione sin Versione vu Syte, wu vu zmindescht eim etablierte Benutzer aagluegt wore sin.",
	'validationstatistics-table' => "Statischtike fir jede Namensruum wäre do unter zeigt, dervu ''usgnuu'' sin Wyterleitige.",
	'validationstatistics-ns' => 'Namensruum',
	'validationstatistics-total' => 'Syte insgsamt',
	'validationstatistics-stable' => 'Zmindescht ei Version isch vum Fäldhieter gsäh.',
	'validationstatistics-latest' => 'Zytglychi',
	'validationstatistics-synced' => 'Prozäntsatz vu dr Syte, wu vum Fäldhieter gsäh sin.',
	'validationstatistics-old' => 'Syte mit Versione, wu nit vum Fäldhieter gsäh sin.',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author DoviJ
 * @author Erel Segal
 * @author Rotemliss
 */
$messages['he'] = array(
	'validationstatistics' => 'סטיסטיקת אישורים',
	'validationstatistics-users' => "'''יש כרגע {{PLURAL:$1|משתמש '''[[Special:ListUsers/editor|אחד]]'''|'''[[Special:ListUsers/editor|$1]]''' משתמשים}} ב{{SITENAME}} עם הרשאת [[{{MediaWiki:Validationpage}}|עורך]] ו{{PLURAL:$2|משתמש '''[[Special:ListUsers/reviewer|אחד]]'''|־'''[[Special:ListUsers/reviewer|$2]]''' משתמשים}} עם הרשאת [[{{MediaWiki:Validationpage}}|בודק דפים]].'''",
	'validationstatistics-time' => "'''המידע הבא הוא עותק שמור של המידע, ועשוי שלא להיות מעודכן.'''

ההמתנה הממוצעת עבור עריכות של ''משתמשים שלא נכנסו לחשבון'' היא '''$1'''; חציון ההמתנה הוא '''$3'''. 
$4
ההמתנה הממוצעת עבור [[Special:OldReviewedPages|דפים עם עריכות ממתינות שלא נבדקו]] היא '''$2'''.
דפים אלה נחשבים כ'''דפים ישנים'''. בדומה לכך, דפים נחשבים '''מסונכרנים''' אם ה[[{{MediaWiki:Validationpage}}|גרסה היציבה]] היא גם גרסת הטיוטה הנוכחית.
גרסאות יציבות הן גרסאות שנבדקו לפחות על ידי משתמש מורשה אחד.",
	'validationstatistics-table' => "סטטיסטיקות לכל מרחב שם מוצגות להלן, תוך '''התעלמות''' מדפי הפניה.",
	'validationstatistics-ns' => 'מרחב שם',
	'validationstatistics-total' => 'דפים',
	'validationstatistics-stable' => 'עבר ביקורת',
	'validationstatistics-latest' => 'מסונכרן',
	'validationstatistics-synced' => 'סונכרנו/נבדקו',
	'validationstatistics-old' => 'פג תוקף',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'validationstatistics' => 'Statistika pregledavanja',
	'validationstatistics-ns' => 'Imenski prostor',
	'validationstatistics-total' => 'Stranice',
	'validationstatistics-stable' => 'Ocijenjeno',
	'validationstatistics-latest' => 'Nedavno ocijenjeno',
	'validationstatistics-synced' => 'Usklađeno/Ocijenjeno',
	'validationstatistics-old' => 'Zastarjelo',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'validationstatistics' => 'Pohódnoćenska statistika',
	'validationstatistics-users' => "'''{{SITENAME}}''' ma tuchwilu '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|wužiwarja|wužiwarjow|wužiwarjow|wužiwarjow}} z [[{{MediaWiki:Validationpage}}|prawami wobdźěłowarja]]
a '''$2''' {{PLURAL:$2|wužiwarja|wužiwarjow|wužiwarjow|wužiwarjow}} z [[{{MediaWiki:Validationpage}}|prawami kontrolera]].",
	'validationstatistics-time' => "''Slědowace daty pufruja so a móža njeaktualne być.''

Přerězne čakanje za změny wot ''wužiwarjow, kotřiž njejsu přizjewjeni'', kotrež dyrbi so pruwować, je '''$1'''; srjedźna hódnota je '''$3'''.
$4
Přerězne komdźenje za [[Special:OldReviewedPages|strony z njepřepruwowanymi změnami]] je '''$2'''.
Tute strony maja so za ''zestarjene''. Tohorunja maja so strony za ''synchronizowane'', jeli [[{{MediaWiki:Validationpage}}|stabilna wersija]] je tež aktualna naćiskowa wersija.
Stabilne wersije su wersije stronow, kotrež su wot znajmjeńša jednoho připóznateho wužiwarja skontrolowane.",
	'validationstatistics-table' => "Slěduja statistiki za kóždy mjenowy rum ''bjez'' daleposrědkowanjow.",
	'validationstatistics-ns' => 'Mjenowy rum',
	'validationstatistics-total' => 'Strony',
	'validationstatistics-stable' => 'Skontrolowane',
	'validationstatistics-latest' => 'Synchronizowany',
	'validationstatistics-synced' => 'Synchronizowane/Skontrolowane',
	'validationstatistics-old' => 'Zestarjene',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Dorgan
 * @author Samat
 */
$messages['hu'] = array(
	'validationstatistics' => 'Ellenőrzési statisztika',
	'validationstatistics-users' => "A(z) '''{{SITENAME}}''' wikinek jelenleg '''{{PLURAL:$1|egy|$1}}''' [[{{MediaWiki:Validationpage}}|járőrjoggal]], valamint '''{{PLURAL:$2|egy|$2}}''' [[{{MediaWiki:Validationpage}}|lektorjoggal]] rendelkező szerkesztője van.",
	'validationstatistics-table' => "Ezen az oldalon a névterekre bontott statisztika látható, az átirányítások nélkül.

'''Megjegyzés:''' az adatokat néhány órás időközönként rögzíti a gyorsítótár, így nem feltétlenül pontosak.",
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
	'validationstatistics-users' => "'''{{SITENAME}}''' ha al momento '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|usator|usatores}} con privilegios de [[{{MediaWiki:Validationpage}}|Redactor]] e '''$2''' {{PLURAL:$2|usator|usatores}} con privilegios de [[{{MediaWiki:Validationpage}}|Revisor]].",
	'validationstatistics-time' => "''Le sequente datos ha essite recuperate del cache e pote esser obsolete.''

Le tempore medie de attender pro le modificationes facite per ''usatores non identificate'' es '''$1'''; le mediana es '''$3'''.
$4
Le tempore medie de retardo pro le [[Special:OldReviewedPages|paginas con modificationes attendente revision]] es '''$2'''.
Iste paginas es considerate ''obsolete''. Similarmente, le paginas es considerate ''synchronisate'' si le [[{{MediaWiki:Validationpage}}|version stabile]] es equalmente le version provisori actual.
Le veriones stabile es versiones de paginas verificate per al minus un usator de bon reputation.",
	'validationstatistics-table' => "Le statisticas pro cata spatio de nomines es monstrate infra, ''excludente'' le paginas de redirection.",
	'validationstatistics-ns' => 'Spatio de nomines',
	'validationstatistics-total' => 'Paginas',
	'validationstatistics-stable' => 'Revidite',
	'validationstatistics-latest' => 'Synchronisate',
	'validationstatistics-synced' => 'Synchronisate/Revidite',
	'validationstatistics-old' => 'Obsolete',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'validationstatistics' => 'Statistik validasi',
	'validationstatistics-users' => "'''{{SITENAME}}''' saat ini memiliki '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|pengguna|pengguna}} dengan hak akses [[{{MediaWiki:Validationpage}}|Editor]] dan
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
 * @author Pietrodn
 */
$messages['it'] = array(
	'validationstatistics' => 'Statistiche di convalidazione',
	'validationstatistics-users' => "Al momento, su '''{{SITENAME}}''' {{PLURAL:$1|c'è '''[[Special:ListUsers/editor|$1]]''' utente|ci sono '''[[Special:ListUsers/editor|$1]]''' utenti}} con i diritti di [[{{MediaWiki:Validationpage}}|Editore]] e '''$2''' {{PLURAL:$2|utente|utenti}} con i diritti di [[{{MediaWiki:Validationpage}}|Revisore]].",
	'validationstatistics-time' => "''I dati seguenti sono cachati e potrebbero non essere aggiornati.''

L'attesa media per le modifiche da parte degli ''utenti che non hanno fatto il login'' è '''$1'''; la mediana è '''$3'''.
$4
Il ritardo medio per le [[Special:OldReviewedPages|pagine con modifiche non revisionate pendenti]] è '''$2'''.
Queste pagine sono considerate ''obsolete''. Così pure, le pagine sono considerate ''sincronizzate'' se la [[{{MediaWiki:Validationpage}}|versione stabile]] è anche l'attuale versione di bozza.
Le versioni stabili sono le versioni delle pagine controllate da almeno un utente autorevole.",
	'validationstatistics-table' => "Le statistiche per ciascun namespace sono mostrate di seguito, ''a esclusione'' delle pagine di redirect.",
	'validationstatistics-ns' => 'Namespace',
	'validationstatistics-total' => 'Pagine',
	'validationstatistics-stable' => 'Revisionate',
	'validationstatistics-latest' => 'Sincronizzate',
	'validationstatistics-synced' => 'Sincronizzate/Revisionate',
	'validationstatistics-old' => 'Non aggiornate',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'validationstatistics' => '判定統計',
	'validationstatistics-users' => "'''{{SITENAME}}''' には現在、[[{{MediaWiki:Validationpage}}|編集者]]権限をもつ利用者が '''[[Special:ListUsers/editor|$1]]'''人、[[{{MediaWiki:Validationpage}}|査読者]]権限をもつ利用者が '''$2'''人います。",
	'validationstatistics-time' => "''以下の情報はキャッシュされたものであり、最新のものではない可能性があります。''

未登録利用者による編集の平均査読待ち時間は '''$1'''、中央値は '''$3'''です。
$4
[[Special:OldReviewedPages|未査読の編集が保留となっているページ]]の平均遅延時間は '''$2'''です。このようなページは「最新版未査読」とされています。[[{{MediaWiki:Validationpage}}|固定版]]がまた最新版である場合、そのページは「最新版査読済」となります。固定版とは、最低でも一人の信頼されている利用者によって検査された版のことです。",
	'validationstatistics-table' => '名前空間別の統計を以下に表示します。リダイレクトページは除いています。',
	'validationstatistics-ns' => '名前空間',
	'validationstatistics-total' => 'ページ数',
	'validationstatistics-stable' => '査読済',
	'validationstatistics-latest' => '最新版査読済',
	'validationstatistics-synced' => '最新版査読済/全査読済',
	'validationstatistics-old' => '最新版未査読',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'validationstatistics' => 'Statistik validasi',
	'validationstatistics-users' => "'''{{SITENAME}}''' wektu iki nduwé '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|panganggo|panganggo}} kanthi hak aksès [[{{MediaWiki:Validationpage}}|Editor]] lan '''$2''' {{PLURAL:$2|panganggo|panganggo}} kanthi hak aksès [[{{MediaWiki:Validationpage}}|Pamriksa]].",
	'validationstatistics-table' => "Statistik kanggo saben bilik jeneng ditampilaké ing ngisor, kajaba kaca pangalihan.

'''Cathetan''': Data ing ngisor dijupuk saka ''cache'' sawetara jam kapungkur lan mbokmanawa ora cocog manèh.",
	'validationstatistics-ns' => 'Bilik jeneng',
	'validationstatistics-total' => 'Kaca',
	'validationstatistics-stable' => 'Wis dipriksa',
	'validationstatistics-latest' => 'Pungkasan dipriksa',
	'validationstatistics-synced' => 'Wis disinkronaké/Wis dipriksa',
	'validationstatistics-old' => 'Lawas',
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
	'validationstatistics-table' => "넘겨주기 문서를 '''제외한''' 문서의 검토 통계가 이름공간별로 보여지고 있습니다.
'''오래 된 문서'''는 안정 버전 이후에 편집이 있는 문서를 의미합니다.
안정 버전이 마지막 버전이라면, 문서는 동기화될 것입니다.

'''참고:''' 다음 데이터는 몇 시간마다 캐시되며 최신이 아닐 수도 있습니다.",
	'validationstatistics-ns' => '이름공간',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'validationstatistics-users' => " De '''{{SITENAME}}''' hät em Momang {{PLURAL:$1|'''eine''' Metmaacher|'''$1''' Metmaachere|'''keine''' Metmaacher}} met Rääsch, ene [[{{MediaWiki:Validationpage}}|Editor]] ze maache, un {{PLURAL:$2|'''eine''' Metmaacher|'''$2''' Metmaacher|'''keine''' Metmaacher}} met däm [[{{MediaWiki:Validationpage}}|Reviewer]]-Rääsch.",
	'validationstatistics-time' => "Die Dorschnitt för de Zick op Änderunge vun Namelose ze Waade, es '''$1'''.
Der Dorschnitt vun de Zick, wo [[Special:OldReviewedPages|ahl Sigge]] hengerher hingke, es '''$2'''.",
	'validationstatistics-table' => "Statistike för jedes Appachtemang (oohne de Sigge met Ömleijdunge)

'''Opjepaß:''' De Date hee noh sen för e paa Stond zweschespeichert, se künnte alsu nit janz de neuste sin.",
	'validationstatistics-ns' => 'Appachtemang',
	'validationstatistics-total' => 'Sigge jesamp',
);

/** Cornish (Kernewek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'validationstatistics-total' => 'Folennow',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'validationstatistics' => 'Statistike vun de Validaiounen',
	'validationstatistics-users' => "''{{SITENAME}}''' huet elo '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|Benotzer|Benotzer}} mat [[{{MediaWiki:Validationpage}}|Editeursrechter]]
an '''$2''' {{PLURAL:$2|Benotzer|Benotzer}} mat [[{{MediaWiki:Validationpage}}|Validatiounsrechter]].",
	'validationstatistics-table' => 'Statistike fir jidfer Nummraum sinn hei ënnedrënner, Viruleedungssäite sinn net berücksichtegt.',
	'validationstatistics-ns' => 'Nummraum',
	'validationstatistics-total' => 'Säiten',
	'validationstatistics-stable' => 'Validéiert',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'validationstatistics-ns' => 'Лӱм-влакын кумдыкышт',
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'validationstatistics' => 'Валидациски статистики',
	'validationstatistics-users' => "'''{{SITENAME}}''' во моментов има '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|корисник|корисници}} со [[{{MediaWiki:Validationpage}}|уредувачки]] права и '''$2''' {{PLURAL:$2|корисник|корисници}} со [[{{MediaWiki:Validationpage}}|оценувачки]] права.",
	'validationstatistics-table' => "Статистики за секој именски простор се прикажани подолу (без страници за пренасочување).
'''Забелешка:''' следниве податоци се кеширани пред неколку часа и можеби не се баш најажурни.",
	'validationstatistics-ns' => 'Именски простор',
	'validationstatistics-total' => 'Страници',
	'validationstatistics-stable' => 'Прегледани',
	'validationstatistics-latest' => 'Последно прегледување',
	'validationstatistics-synced' => 'Синхронизирани/Прегледани',
	'validationstatistics-old' => 'Застарени',
);

/** Malayalam (മലയാളം)
 * @author Sadik Khalid
 */
$messages['ml'] = array(
	'validationstatistics' => 'സ്ഥിരീകരണ കണക്കുകള്‍',
	'validationstatistics-users' => "'''{{SITENAME}}''' പദ്ധതിയില്‍ '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|ഉപയോക്താവ്|ഉപയോക്താക്കള്‍}} [[{{MediaWiki:Validationpage}}|സംശോധകര്‍]] അധികാരമുള്ളവരും '''$2''' {{PLURAL:$2|ഉപയോക്താവ്|ഉപയോക്താക്കള്‍}} [[{{MediaWiki:Validationpage}}|പരിശോധകര്‍]] അധികാരമുള്ളവരും നിലവിലുണ്ട്.",
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
	'validationstatistics-users' => "'''{{SITENAME}}''' kini mempunyai {{PLURAL:$1|seorang|'''[[Special:ListUsers/editor|$1]]''' orang}} pengguna dengan hak [[{{MediaWiki:Validationpage}}|Penyunting]] dan {{PLURAL:$2|seorang|'''$2''' orang}} pengguna dengan hak [[{{MediaWiki:Validationpage}}|Pemeriksa]].",
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
	'validationstatistics-users' => "'''{{SITENAME}}''' heeft op het moment '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|gebruiker|gebruikers}} in de rol van [[{{MediaWiki:Validationpage}}|Redacteur]] en '''$2''' {{PLURAL:$2|gebruiker|gebruikers}} met de rol [[{{MediaWiki:Validationpage}}|Eindredacteur]].",
	'validationstatistics-time' => "''De volgende gegevens komen uit een cache en kunnen verouderd zijn.''

De gemiddelde wachttijd voor bewerkingen door ''gebruikers die niet aangemeld zijn'' is '''$1'''; de mediaan is '''$3'''.
$4
De gemiddelde achterstand voor [[Special:OldReviewedPages|verouderde pagina's]] is '''$2'''.
Deze pagina's worden beschouwd als ''verouderd''.
Pagina's worden beschouwd als ''gesynchroniseerd'' als de [[{{MediaWiki:Validationpage}}|stabiele versie]] ook de werkversie is.
Stabiele versies zijn versies van pagina's die tenminste door een eindredacteur zijn gekeurd.",
	'validationstatistics-table' => "Hieronder staan statistieken voor iedere naamruimte, ''exclusief'' doorverwijzingen.",
	'validationstatistics-ns' => 'Naamruimte',
	'validationstatistics-total' => "Pagina's",
	'validationstatistics-stable' => 'Eindredactie afgerond',
	'validationstatistics-latest' => 'Gesynchroniseerd',
	'validationstatistics-synced' => 'Gesynchroniseerd/Eindredactie',
	'validationstatistics-old' => 'Verouderd',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'validationstatistics' => 'Valideringsstatistikk',
	'validationstatistics-users' => "'''{{SITENAME}}''' har på noverande tidspunkt {{PLURAL:$1|'''éin''' brukar|'''[[Special:ListUsers/editor|$1]]''' brukarar}} med [[{{MediaWiki:Validationpage}}|skribentrettar]] og {{PLURAL:$1|'''éin''' brukar|'''$2''' brukarar}} med [[{{MediaWiki:Validationpage}}|meldarrettar]].",
	'validationstatistics-time' => "''Fylgjande data er mellomlagra og kan vera uaktuell.''

Gjennomsnittleg ventetid for endringar av ''uinnlogga brukarar'' til gjennomsyn er '''$1'''; medianen er '''$3'''.
$4
Gjennomsnittleg forseinking for [[Special:OldReviewedPages|sider med endringar som ikkje er sett gjennom]] er '''$2'''.

Desse sidene vert sett på som ''forelda''. På same vis vert sider rekna som ''synkronisert'' om den [[{{MediaWiki:Validationpage}}|stabile versjonen]] òg er den noverande utkast-versjonen.
Stabile versjonar er sideversjonar for sider som er sjekka av minst ein etablert brukar.",
	'validationstatistics-table' => "Statistikk for kvart namnerom er synt nedanfor, ''utanom'' omdirigeringssider.",
	'validationstatistics-ns' => 'Namnerom',
	'validationstatistics-total' => 'Sider',
	'validationstatistics-stable' => 'Vurdert',
	'validationstatistics-latest' => 'Synkronisert',
	'validationstatistics-synced' => 'Synkronisert/Vurdert',
	'validationstatistics-old' => 'Utdatert',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'validationstatistics' => 'Valideringsstatistikk',
	'validationstatistics-users' => "'''{{SITENAME}}''' har '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|bruker|brukere}} med [[{{MediaWiki:Validationpage}}|skribentrettigheter]] og '''$2''' {{PLURAL:$2|bruker|brukere}} med [[{{MediaWiki:Validationpage}}|anmelderrettigheter]].",
	'validationstatistics-table' => "Statistikk for hvert navnerom vises nedenfor, utenom omdirigeringssider. ''Utdaterte'' sider er sider som or blitt endret siden siste stabile versjon. Om siste endring også er stabil er siden ''à jour''.

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
	'validationstatistics-users' => "'''{{SITENAME}}''' dispausa actualament de '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utilizaire|utilizaires}} amb los dreches d’[[{{MediaWiki:Validationpage}}|editor]] e de '''$2''' {{PLURAL:$2|utilizaire|utilizaires}} amb los dreches de [[{{MediaWiki:Validationpage}}|relector]].",
	'validationstatistics-time' => "''Las donadas seguentas son en amagatal e benlèu son pas a jorn.''

Lo temps mejan per las modificacions fachas per ''d'utilizaires que son pas connectats'' es de '''$1'''; la mediana es '''$3'''.
$4
Lo temps de retard mejan per las [[Special:OldReviewedPages|paginas que contenon de modificacions pas relegidas en cors es '''$2'''.
Aquestas paginas son consideradas ''perimidas''. Parièrament, las paginas son declaradas ''sincronizadas'' se la [[{{MediaWiki:Validationpage}}|version establa]] tanben es la version de borrolhon correnta.
Las versions establas son de versions de paginas verificadas per al mens un utilizaire regular.",
	'validationstatistics-table' => "Las estatisticas per cada espaci de noms son afichadas çaijós, a ''l’exclusion'' de las paginas de redireccion.",
	'validationstatistics-ns' => 'Nom de l’espaci',
	'validationstatistics-total' => 'Paginas',
	'validationstatistics-stable' => 'Relegit',
	'validationstatistics-latest' => 'Sincronizada',
	'validationstatistics-synced' => 'Sincronizat/Relegit',
	'validationstatistics-old' => 'Desuet',
);

/** Polish (Polski)
 * @author Jwitos
 * @author Leinad
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'validationstatistics' => 'Statystyki oznaczania',
	'validationstatistics-users' => "W '''{{GRAMMAR:MS.lp|{{SITENAME}}}}''' zarejestrowanych jest obecnie  '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|użytkownik|użytkowników}} z uprawnieniami [[{{MediaWiki:Validationpage}}|redaktora]] oraz  '''[[Special:ListUsers/reviewer|$2]]''' {{PLURAL:$2|użytkownik|użytkowników}} z uprawnieniami [[{{MediaWiki:Validationpage}}|weryfikatora]].",
	'validationstatistics-time' => "''Dane są buforowane i mogą być nieaktualne.''

Średni czas oczekiwania na sprawdzenie edycji wykonanych przez ''niezalogowanych użytkowników'' wynosi '''$1''', a mediana '''$3'''.
$4
Średnie opóźnienie dla [[Special:OldReviewedPages|oczekujących na przejrzenie edycji]] wynosi '''$2'''.
Strony te uznawane są za ''zdezaktualizowane''. Podobnie za ''zsynchronizowane'' uznawane są strony jeśli ich [[{{MediaWiki:Validationpage}}|wersja przejrzana]] jest również aktualną wersją roboczą.
Wersjami przejrzanymi są wersje oznaczone przez co najmniej jednego zaufanego użytkownika.",
	'validationstatistics-table' => "Poniżej znajdują się statystyki dla każdej przestrzeni nazw, ''z wyłączeniem'' przekierowań.",
	'validationstatistics-ns' => 'Przestrzeń nazw',
	'validationstatistics-total' => 'Stron',
	'validationstatistics-stable' => 'Przejrzanych',
	'validationstatistics-latest' => 'Z ostatnią edycją oznaczoną jako przejrzana',
	'validationstatistics-synced' => 'Zsynchronizowanych lub przejrzanych',
	'validationstatistics-old' => 'Zdezaktualizowane',
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
 * @author Waldir
 */
$messages['pt'] = array(
	'validationstatistics' => 'Estatísticas de validações',
	'validationstatistics-users' => "'''{{SITENAME}}''' possui, no momento, '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utilizador|utilizadores}} com privilégios de [[{{MediaWiki:Validationpage}}|{{int:group-editor-member}}]] e '''$2''' {{PLURAL:$2|utilizador|utilizadores}} com privilégios de [[{{MediaWiki:Validationpage}}|{{int:group-reviewer-member}}]].",
	'validationstatistics-time' => "''Os dados seguintes estão em cache e podem não estar atualizados.''

O tempo médio de espera para edições feitas por ''utilizadores não autenticados'' serem revistas é '''$1'''; a mediana é '''$3'''.  
$4
O atraso médio para [[Special:OldReviewedPages|páginas com edições não revistas em espera]] é '''$2'''.
Estas páginas são consideradas ''desatualizadas''. Igualmente, as páginas são consideradas ''sincronizadas'' se a [[{{MediaWiki:Validationpage}}|versão estável]] é também a versão rascunho atual.
Versões estáveis são revisões de páginas verificadas por pelo menos um utilizador estabelecido.",
	'validationstatistics-table' => "As estatísticas de cada domínio são exibidas a seguir, '''excetuando-se''' as páginas de redirecionamento.",
	'validationstatistics-ns' => 'Espaço nominal',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Analisadas',
	'validationstatistics-latest' => 'Sincronizada',
	'validationstatistics-synced' => 'Sincronizadas/Analisadas',
	'validationstatistics-old' => 'Desactualizadas',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'validationstatistics' => 'Estatísticas de validações',
	'validationstatistics-users' => "'''{{SITENAME}}''' possui, no momento, '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utilizador|utilizadores}} com privilégios de [[{{MediaWiki:Validationpage}}|{{int:group-editor-member}}]] e '''$2''' {{PLURAL:$2|utilizador|utilizadores}} com privilégios de [[{{MediaWiki:Validationpage}}|{{int:group-reviewer-member}}]].",
	'validationstatistics-time' => "''Os dados seguintes estão em cache e podem não estar atualizados.''

O tempo médio de espera para edições feitas por ''utilizadores não autenticados'' serem revistas é '''$1'''; a mediana é '''$3'''.   
$4
O atraso médio para [[Special:OldReviewedPages|páginas com edições não revistas em espera]] é '''$2'''.
Estas páginas são consideradas ''desatualizadas''. Igualmente, as páginas são consideradas ''sincronizadas'' se a [[{{MediaWiki:Validationpage}}|versão estável]] é também a versão rascunho atual.
Versões estáveis são revisões de páginas verificadas por pelo menos um utilizador estabelecido.",
	'validationstatistics-table' => "As estatísticas de cada domínio são exibidas a seguir, '''excetuando-se''' as páginas de redirecionamento.",
	'validationstatistics-ns' => 'Espaço nominal',
	'validationstatistics-total' => 'Páginas',
	'validationstatistics-stable' => 'Analisadas',
	'validationstatistics-latest' => 'Sincronizada',
	'validationstatistics-synced' => 'Sincronizadas/Analisadas',
	'validationstatistics-old' => 'Desatualizadas',
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
	'validationstatistics-users' => "'''{{SITENAME}}''' jndr'à quiste mumende tène '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|utende|utinde}} cu le deritte de [[{{MediaWiki:Validationpage}}|cangiatore]] e '''$2''' {{PLURAL:$2|utende|utinde}} cu le deritte de[[{{MediaWiki:Validationpage}}|revisione]].",
	'validationstatistics-time' => "'''U seguende date stè jndr'à cache e non g'avène aggiornate.''

'A medie attese pe le cangiaminde da ''utinde ca non ge sonde colleghete'' jè '''$1'''; 'a medie jè '''$3'''.
$4
'U timbe medie pe le [[Special:OldReviewedPages|pàggene non aggiornete]] jè '''$2'''.
Ste pàggene sonde conziderete ''scadute''. Pò, stonne le pàggene ca sonde conziderete ''singronizzate'' ce 'a [[{{MediaWiki:Validationpage}}|versiona secure]]  jè ppure 'a versiona attuale a bozza.
Le versiune secure sonde revisiune de pàggene verificate da almene 'n'utende stabbilite.",
	'validationstatistics-table' => "Le statisteche pe ogne namespace sonde mostrete aqquà sotte, 'scludenne le pàggene de redirezionaminde.",
	'validationstatistics-ns' => 'Neimspeise',
	'validationstatistics-total' => 'Pàggene',
	'validationstatistics-stable' => 'Riviste',
	'validationstatistics-latest' => 'Singronizzate',
	'validationstatistics-synced' => 'Singronizzete/Riviste',
	'validationstatistics-old' => "Non g'è aggiornete",
);

/** Russian (Русский)
 * @author Ahonc
 * @author AlexSm
 * @author Ferrer
 * @author Putnik
 * @author Sergey kudryavtsev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'validationstatistics' => 'Статистика проверок',
	'validationstatistics-users' => "В проекте {{SITENAME}} на данный момент '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|участник|участника|участников}} имеют права [[{{MediaWiki:Validationpage}}|«редактора»]] и '''$2''' {{plural:$2|участник|участника|участников}} имеют права [[{{MediaWiki:Validationpage}}|«проверяющего»]].",
	'validationstatistics-time' => "Среднее ожидание для правок от ''неавторизовавшихся участников'' равно '''$1'''; медиана равна '''$3'''.
$4
Средняя задержка для [[Special:OldReviewedPages|страниц с недосмотренными правками]] равна '''$2'''.",
	'validationstatistics-table' => "Ниже представлена статистика по каждому пространству имён. Перенаправления из подсчётов исключены. 
''Устаревшими'' называются страницы, имеющие правки после стабильной версии.
Если стабильная версия является последней, то страница называется ''синхронизированной''.

'''Замечание.''' Страница кэшируется. Данные могут отставать на несколько часов.",
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
	'validationstatistics-users' => "'''{{SITENAME}}''' má momentálne '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|používateľa|používateľov}} s právami [[{{MediaWiki:Validationpage}}|redaktor]] a '''$2''' {{PLURAL:$2|používateľa|používateľov}} s právami [[{{MediaWiki:Validationpage}}|kontrolór]].",
	'validationstatistics-time' => "''Nasledovné údaje pochádzajú z vyrovnávacej pamäte a nemusia byť aktuálne.''

Priemerné čakanie na úpravy ''anonymných používateľov'' je '''$1'''; medián je '''$3'''.  
$4
Priemerné oneskorenie [[Special:OldReviewedPages|zastaralých stránok]] je '''$2'''.
Tieto stránky sa považujú za ''zastaralé''. Podobne, stránky sa považujú za ''synchronozované'' ak je [[{{MediaWiki:Validationpage}}|stabilná verzia]] zároveň súčasný návrh.
Stabilná verzia je revízia stránky, ktorú skontroloval aspoň jeden zo zavedených používateľov.",
	'validationstatistics-table' => "Dolu sú zobrazené štatistiky pre každý menný priestor ''okrem'' presmerovacích stránok.",
	'validationstatistics-ns' => 'Menný priestor',
	'validationstatistics-total' => 'Stránky',
	'validationstatistics-stable' => 'Skontrolované',
	'validationstatistics-latest' => 'Synchronizovaná',
	'validationstatistics-synced' => 'Synchronizované/skontrolované',
	'validationstatistics-old' => 'Zastaralé',
);

/** Albanian (Shqip)
 * @author Puntori
 */
$messages['sq'] = array(
	'validationstatistics-total' => 'Faqet',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 */
$messages['sv'] = array(
	'validationstatistics' => 'Valideringsstatistik',
	'validationstatistics-users' => "'''{{SITENAME}}''' har just nu '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|användare|användare}} med [[{{MediaWiki:Validationpage}}|redaktörsrättigheter]] och '''$2''' {{PLURAL:$2|användare|användare}} med [[{{MediaWiki:Validationpage}}|granskningsrättigheter]].",
	'validationstatistics-time' => "''Följande data är cachad och kan vara inaktuell.''

Genomsnittlig väntan för redigeringar av ''oinloggade användare'' för granskning är '''$1'''; medianen är '''$3'''.
$4
Genomsnittlig lag för [[Special:OldReviewedPages|Föråldrade granskade sidor]] är '''$2'''.
Dessa sidor anses ''föråldrade''. Likaså anses sidor ''synkade'' om den [[{{MediaWiki:Validationpage}}|stabila versionen]] också är den nuvarande draft-versionen.
Stabila versioner är sidversioner för sidor som kollats av minst en etablerad användare.",
	'validationstatistics-table' => "Statistik för varje namnrymd visas nedan, ''förutom'' omdirigeringssidor.",
	'validationstatistics-ns' => 'Namnrymd',
	'validationstatistics-total' => 'Sidor',
	'validationstatistics-stable' => 'Granskad',
	'validationstatistics-latest' => 'Synkad',
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
	'validationstatistics-users' => "Ang '''{{SITENAME}}''' ay  pangkasalukuyang may '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|tagagamit|mga tagagamit}} na may karapatan bilang [[{{MediaWiki:Validationpage}}|Patnugot]] 
at '''$2''' {{PLURAL:$2|tagagamit|mga tagagamit}} na may karapatan bilang [[{{MediaWiki:Validationpage}}|Tagapagsuri]].",
	'validationstatistics-time' => "''Ang sumusunod na dato ay nakatago at maaaring wala na sa panahon.''

Ang karaniwang panahon ng paghihintay para sa mga pagbabago ng ''mga tagagamit na hindi lumalagdang papasok'' na susuriin pa ay '''$1'''; ang panggitnaan ay '''$3'''. 
$4
Ang karaniwang panahon ng pagkakaiwan para sa [[Special:OldReviewedPages|mga pahinang may nakabinbing pagsusuri ng mga pagbabago]] ay '''$2'''.
Ang mga pahinang ito itinuturing na ''wala na sa panahon''. Gayun din, ang mga pahina ay itinuturing na ''naisabay na'' kapag ang [[{{MediaWiki:Validationpage}}|matatag na bersyon]] ay siya ring pangkasalukuyang balangkas na bersyon.
Ang matatatag na mga bersyon ay mga rebisyon ng mga pahinang nasuri ng kahit na isang kinikilalang tagagamit.",
	'validationstatistics-table' => "Ipinapakita sa ibaba ang mga estadistika para sa bawat espasyo ng pangalan, ''hindi kasama'' ang mga pahinang tumuturo papunta sa ibang pahina.",
	'validationstatistics-ns' => 'Espasyo ng pangalan',
	'validationstatistics-total' => 'Mga pahina',
	'validationstatistics-stable' => 'Nasuri na',
	'validationstatistics-latest' => 'Napagsabay na',
	'validationstatistics-synced' => 'Pinagsabay-sabay/Nasuri nang muli',
	'validationstatistics-old' => 'Wala na sa panahon (luma)',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'validationstatistics' => 'Doğrulama istatistikleri',
	'validationstatistics-users' => "'''{{SITENAME}}''' sitesinde şuanda [[{{MediaWiki:Validationpage}}|Editor]] yetkisine sahip '''[[Special:ListUsers/editor|$1]]''' {{PLURAL:$1|kullanıcı|kullanıcı}} ve [[{{MediaWiki:Validationpage}}|Reviewer]] yetkisine sahip '''$2''' {{PLURAL:$2|kullanıcı|kullanıcı}} bulunmaktadır.",
	'validationstatistics-time' => "''Aşağıdaki veri önbelleklenmiştir ve güncel olmayabilir.''

''Giriş yapmamış kullanıcılar'' tarafından yapılan gözden geçirilecek değişiklikler için ortalama bekleme süresi '''$1'''; orta değer '''$3'''.
$4
[[Special:OldReviewedPages|Gözden geçirilmemiş değişikliğe sahip sayfalar]] için ortalama gecikme '''$2'''.
Bu sayfalar ''eskimiş'' sayılırlar. Aynı şekilde, eğer [[{{MediaWiki:Validationpage}}|kararlı sürüm]] aynı zamanda güncel taslaksa, sayfa ''senkron'' sayılır.
Kararlı sürümler, sayfaların en az bir belirli kullanıcı tarafından kontrol edilmiş revizyonlarıdır.",
	'validationstatistics-table' => "Her bir ad alanı için istatistikler aşağıda gösterilmiştir, yönlendirme sayfaları ''hariç''.",
	'validationstatistics-ns' => 'Ad alanı',
	'validationstatistics-total' => 'Sayfalar',
	'validationstatistics-stable' => 'Gözden geçirilmiş',
	'validationstatistics-latest' => 'Senkronize edildi',
	'validationstatistics-synced' => 'Eşitlenmiş/Gözden geçirilmiş',
	'validationstatistics-old' => 'Eski',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'validationstatistics' => 'Статистика перевірок',
	'validationstatistics-users' => "У {{grammar:locative|{{SITENAME}}}} зараз '''[[Special:ListUsers/editor|$1]]''' {{plural:$1|користувач має|користувачі мають|користувачів мають}} права [[{{MediaWiki:Validationpage}}|«редактор»]] і '''$2''' {{plural:$2|користувач має|користувачі мають|користувачів мають}} права [[{{MediaWiki:Validationpage}}|«рецензент»]].",
	'validationstatistics-time' => "''Нижченаведені дані взяті з кешу і можуть бути застарілими.''

Середнє очікування редагувань від ''незареєстрованих користувачів'' рівне '''$1'''; медіана рівна '''$3'''.
$4
Середня затримка для [[Special:OldReviewedPages|сторінок з непереглянутими редагуваннями]] рівна '''$2'''.
Ці сторінки вважаються ''застарілими''. Так само, сторінка вважається ''синхронізованою'', якщо її
поточна версія є [[{{MediaWiki:Validationpage}}|стабільною]].
Стабільні версії — версії, перевірені принаймні одним користувачем.",
	'validationstatistics-table' => "Статистика для кожного простору назв показана нижче. ''Перенаправлення'' не враховані.",
	'validationstatistics-ns' => 'Простір назв',
	'validationstatistics-total' => 'Сторінок',
	'validationstatistics-stable' => 'Перевірені',
	'validationstatistics-latest' => 'Синхронізовані',
	'validationstatistics-synced' => 'Повторно перевірені',
	'validationstatistics-old' => 'Застарілі',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'validationstatistics' => 'Thống kê phê chuẩn',
	'validationstatistics-users' => "Hiện nay, '''[[Special:ListUsers/editor|$1]]''' thành viên tại '''{{SITENAME}}''' có quyền [[{{MediaWiki:Validationpage}}|Chủ bút]] và '''$2''' thành viên có quyền [[{{MediaWiki:Validationpage}}|Người duyệt]].",
	'validationstatistics-time' => "''Dữ liệu sau được lưu vào bộ đệm và có thể đã lỗi thời.''

Thời gian chờ duyệt trung bình cho sửa đổi của ''thành viên không đăng nhập'' là '''$1'''; trung vị là '''$3'''.
$4
Độ trễ trung bình đối với [[Special:OldReviewedPages|trang có sửa đổi chưa duyệt]] là '''$2'''.
Những trang sau được xem là ''lỗi thời''. Tương tự, những trang được xem là ''đã đồng bộ'' nếu
[[{{MediaWiki:Validationpage}}|phiên bản ổn định]] cũng là phiên bản nháp hiện tại.
Các bản ổn định là các phiên bản của trang đã được ít nhất một thành viên đầy đủ xem qua.",
	'validationstatistics-table' => "Đây có thống kê về các không gian tên, ''trừ'' các trang đổi hướng.",
	'validationstatistics-ns' => 'Không gian tên',
	'validationstatistics-total' => 'Số trang',
	'validationstatistics-stable' => 'Được duyệt',
	'validationstatistics-latest' => 'Đã đồng bộ',
	'validationstatistics-synced' => 'Cập nhật/Duyệt',
	'validationstatistics-old' => 'Lỗi thời',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'validationstatistics-ns' => 'Nemaspad',
	'validationstatistics-total' => 'Pads',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'validationstatistics-ns' => 'נאמענטייל',
	'validationstatistics-total' => 'בלעטער',
);

