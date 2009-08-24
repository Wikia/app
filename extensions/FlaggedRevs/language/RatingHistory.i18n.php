<?php
/**
 * Internationalisation file for FlaggedRevs extension, section RatingHistory
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'ratinghistory'         => 'Page rating history',
	'ratinghistory-leg'     => 'Rating history data for [[:$1|$1]]',
	'ratinghistory-tab'     => 'rating',
	'ratinghistory-link'    => 'Page rating',
	'ratinghistory-thanks'  => '\'\'<font color="darkred">Thank you for taking a moment to review this page!</font>\'\'',
	'ratinghistory-period'  => 'Time period:',
	'ratinghistory-month'   => 'last month',
	'ratinghistory-3months' => 'last 3 months',
	'ratinghistory-year'    => 'last year',
	'ratinghistory-3years'  => 'last 3 years',
	'ratinghistory-ave'     => 'Avg: $1',
	'ratinghistory-chart'   => 'Reader ratings over time',
	'ratinghistory-purge'   => 'purge cache',
	'ratinghistory-table'   => 'Overview of reader ratings',
	'ratinghistory-users'   => 'Users who gave ratings',
	'ratinghistory-graph'   => '$2 of "$3" ($1 {{PLURAL:$1|review|reviews}})',
	'readerfeedback-svg'    => 'View as SVG',
	'ratinghistory-table-rating' => 'Rating',
	'ratinghistory-table-votes'  => 'Votes',
	'ratinghistory-none'    => 'There is not enough reader feedback data available for graphs at this time.',
	'ratinghistory-legend'  => 'The \'\'\'daily average rating\'\'\' <font color="blue">\'\'(blue)\'\'</font> and 
	\'\'\'running average rating\'\'\' <font color="green">\'\'(green)\'\'</font> are graphed below, by date. The 
	\'\'\'running average rating\'\'\' is simply the average of all the daily ratings \'\'within\'\' this time frame for each day.
	
Scale: \'\'\'[1]\'\'\' - Poor; \'\'\'[2]\'\'\' - Low; \'\'\'[3]\'\'\' - Fair; \'\'\'[4]\'\'\' - High; \'\'\'[5]\'\'\' - Excellent;

	The \'\'\'number of reviews per day\'\'\' <font color="red">\'\'(red)\'\'</font> is shown on the graphs below, on a \'\'1:$1\'\' scale.',
	'right-feedback' => 'Use the feedback form to rate a page',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Boivie
 */
$messages['qqq'] = array(
	'ratinghistory-ave' => 'Average',
	'ratinghistory-legend' => "<pre>
'''[1]''' - {{int:readerfeedback-level-0}}
'''[2]''' - {{int:readerfeedback-level-1}}
'''[3]''' - {{int:readerfeedback-level-2}}
'''[4]''' - {{int:readerfeedback-level-3}}
'''[5]''' - {{int:readerfeedback-level-4}}
</pre>",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'ratinghistory' => 'Lehtpolen arvostelendoiden aigkirj',
	'ratinghistory-leg' => '[[:$1|$1]]-lehtpolen arvostelendistorijan andmused',
	'ratinghistory-tab' => 'arvoind',
	'ratinghistory-link' => 'Lehtpolen arvoind',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Kitäm, miše tö olet löudnu aigad necidä lehtpol't arvosteldes!</font>''",
	'ratinghistory-period' => 'Aigan pord:',
	'ratinghistory-month' => "jäl'gmäine ku",
	'ratinghistory-3months' => "3 jäl'gmäšt kud",
	'ratinghistory-year' => "jäl'gmäine voz'",
	'ratinghistory-3years' => "3 jäl'gmäšt vot",
	'ratinghistory-ave' => 'Keskmäine: $1',
	'ratinghistory-chart' => 'Lugijan arvsanad kaikes aigas',
	'ratinghistory-purge' => 'puhtastadud keš',
	'ratinghistory-table' => 'Lugijoiden arvoindoiden ümbrikacund',
	'ratinghistory-users' => 'Arvoinuded kävutajad',
	'ratinghistory-graph' => '$2 ühthižes luguspäi «$3» ($1 {{PLURAL:$1|arvsana|arvsanad}})',
	'readerfeedback-svg' => 'Kacta kut SVG',
	'ratinghistory-table-rating' => 'Arvoind',
	'ratinghistory-table-votes' => 'Äned',
	'ratinghistory-none' => 'Ei ulotu lugijoiden arvsanoid grafikan tehtes.',
	'ratinghistory-legend' => "Alemba oma ozutadud '''päivesenkeskmäine arvsana''' <font color=\"blue\">''(sinine)''</font> da '''nügüdläine keskmäine arvsana''' <font color=\"green\">''(vihand)''</font>.  
'''Nügüdläižeks keskmäižeks arvsanaks''' kuctas päivesen arvsanoiden keskmäine lugu, kudamban lugedas kaikuččen päivän märitud pordas aigad.

Pordhišt: '''[1]''' — hond; '''[2]''' — madal; '''[3]''' — keskmäine; '''[4]''' — hüvä; '''[5]''' — lujas hüvä;

'''Kodvindoiden lugu päiväs''' <font color=\"red\">''(rusked)''</font> om ozutadud masštabas ''1:\$1''.",
	'right-feedback' => 'Kävutagat arvostelendform lehtpoliden arvosteldes',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'ratinghistory' => 'تاريخ تقييم الصفحة',
	'ratinghistory-leg' => 'بيانات تاريخ التقييم ل[[:$1|$1]]',
	'ratinghistory-tab' => 'تقييم',
	'ratinghistory-link' => 'تقييم الصفحة',
	'ratinghistory-thanks' => "''<font color=\"darkred\">شكرا لك لاستغراقك دقيقة لمراجعة هذه الصفحة!</font>''",
	'ratinghistory-period' => 'فترة زمنية:',
	'ratinghistory-month' => 'آخر شهر',
	'ratinghistory-3months' => 'أخر 3 شهور',
	'ratinghistory-year' => 'آخر سنة',
	'ratinghistory-3years' => 'آخر 3 سنوات',
	'ratinghistory-ave' => 'المتوسط: $1',
	'ratinghistory-chart' => 'تقييمات القراء عبر الزمن',
	'ratinghistory-purge' => 'إفراغ الكاش',
	'ratinghistory-table' => 'عرض عام لتقييمات القراء',
	'ratinghistory-users' => 'المستخدمون الذين أعطوا تقييمات',
	'ratinghistory-graph' => '$2 من "$3" ($1 {{PLURAL:$1|مراجعة|مراجعة}})',
	'readerfeedback-svg' => 'عرض كإس في جي',
	'ratinghistory-table-rating' => 'تقييم',
	'ratinghistory-table-votes' => 'أصوات',
	'ratinghistory-none' => 'لا توجد بيانات كافية من القراء متوفرة للرسومات في هذا الوقت.',
	'ratinghistory-legend' => "'''التقيم المتوسط اليومي''' <font color=\"blue\">''(أزرق)''</font> و  
'''التقييم المتوسط العامل''' <font color=\"green\">''(أخضر)''</font> مرسومان بالأسفل, حسب التاريخ. 
'''التقييم المتوسط العامل''' هو ببساطة متوسط كل التقييمات اليومية ''بداخل'' هذا الإطار الزمني لكل يوم.

المقياس: '''[1]''' - فقير؛ '''[2]''' - منخفض؛ '''[3]''' - معقول؛ '''[4]''' - مرتفع؛ '''[5]''' - ممتاز؛

'''عدد المراجعات لكل يوم''' <font color=\"red\">''(أحمر)''</font> معروض على الرسومات بالأسفل، بمقياس ''1:\$1''.",
	'right-feedback' => 'استخدام استمارة الآراء لتقييم صفحة',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'ratinghistory' => 'تاريخ تقييم الصفحة',
	'ratinghistory-leg' => 'تقييم بيانات التاريخ بتاع [[:$1|$1]]',
	'ratinghistory-tab' => 'تقييم',
	'ratinghistory-link' => 'تقييم الصفحة',
	'ratinghistory-thanks' => "''<font color=\"darkred\">شكرا لك لاستغراقك دقيقة لمراجعة هذه الصفحة!</font>''",
	'ratinghistory-period' => 'فترة زمنية:',
	'ratinghistory-month' => 'آخر شهر',
	'ratinghistory-3months' => 'اخر 3 شهور',
	'ratinghistory-year' => 'آخر سنة',
	'ratinghistory-3years' => 'آخر 3 سنوات',
	'ratinghistory-ave' => 'Avg: $1',
	'ratinghistory-chart' => 'تقييمات القارئ على مر الزمن',
	'ratinghistory-table' => 'عرض لتقييمات القارئ',
	'ratinghistory-users' => 'اليوزرز اللى عملو تقييمات:',
	'ratinghistory-graph' => '$2 من "$3" ($1 {{PLURAL:$1|مراجعة|مراجعة}})',
	'readerfeedback-svg' => 'اعرض SVG',
	'ratinghistory-table-rating' => 'تقييم',
	'ratinghistory-table-votes' => 'الاصوات',
	'ratinghistory-none' => 'لا توجد بيانات كافية من القراء متوفرة للرسومات فى هذا الوقت.',
	'ratinghistory-legend' => "'''التقييم اليومى المتوسط''' <font color=\"blue\">''(ازرق)''</font> و  
'''التقييم المتوسط الجاري''' <font color=\"green\">''(اخضر)''</font> مرسومين تحت, على حسب التاريخ.   
'''التقييم المتوسط الجاري''' هوه ببساطه المتوسط بتاع كل التقييمات اليوميه ''فى'' فى الفترة دى من كل يوم.

المقاس: '''[1]''' - فقير; '''[2]''' - واطي; '''[3]''' - نص نص; '''[4]''' - عالى; '''[5]''' - ممتاز;

'''عدد المراجعات فى اليوم''' <font color=\"red\">''(احمر)''</font> معروضين فى الجرافات اللى تحت, بمقاس ''1:\$1''.",
	'right-feedback' => 'استخدام استمارة الآراء لتقييم صفحة',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'ratinghistory' => 'تاریح درجه بندی صفحه',
	'ratinghistory-leg' => 'درجه بندی دیتای تاریح',
	'ratinghistory-tab' => 'درجه',
	'ratinghistory-period' => 'مدت زمان:',
	'ratinghistory-month' => 'پیشگین ماه',
	'ratinghistory-year' => 'پار',
	'ratinghistory-3years' => '۳ سال پیسرتر',
	'ratinghistory-none' => 'نظرات کاربری کافی په شرکتن گراف تا ای زمان نیستن',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'ratinghistory-tab' => 'рейтинг',
	'ratinghistory-period' => 'Период от време:',
	'ratinghistory-month' => 'последния месец',
	'ratinghistory-year' => 'последната година',
	'ratinghistory-3years' => 'последните 3 години',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'ratinghistory' => 'Historija rejtinga stranice',
	'ratinghistory-leg' => 'Historijski pregled podataka rejtinga za [[:$1|$1]]',
	'ratinghistory-tab' => 'rejting',
	'ratinghistory-link' => 'Rejting stranice',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Hvala Vam što ste našli vremena da pregledate ovu stranicu!</font>''",
	'ratinghistory-period' => 'Vremenski period:',
	'ratinghistory-month' => 'zadnji mjesec',
	'ratinghistory-3months' => 'zadnja 3 mjeseca',
	'ratinghistory-year' => 'zadnja godina',
	'ratinghistory-3years' => 'zadnje 3 godine',
	'ratinghistory-ave' => 'Prosj: $1',
	'ratinghistory-chart' => 'Rejtinzi čitaoca po vremenu',
	'ratinghistory-purge' => 'očisti keš',
	'ratinghistory-table' => 'Pregled rejtinga čitaoca',
	'ratinghistory-users' => 'Korisnici koji su dodijelili rejtinge',
	'ratinghistory-graph' => '$2 od "$3" ($1 {{PLURAL:$1|pregled|pregleda}})',
	'readerfeedback-svg' => 'Pregledaj kao SVG',
	'ratinghistory-table-rating' => 'Rejting',
	'ratinghistory-table-votes' => 'Glasovi',
	'ratinghistory-none' => 'Trenutno nema dovoljno podataka povratne veze čitaoca za prikaz grafikonom.',
	'ratinghistory-legend' => "'''Dnevni prosječni rejting''' <font color=\"blue\">''(plavo)''</font> i  
'''tekući prosječni rejting''' <font color=\"green\">''(zeleno)''</font> je prikazan na grafikonu ispod, po datumu. 

'''Tekući prosječni rejting''' je jednostavni prosjek svih dnevnih rejtinga ''unutar'' ovog vremenskog perioda za svaki dan.

Skala: '''[1]''' - Slab; '''[2]''' - Loš; '''[3]''' - Solidan; '''[4]''' - Visok; '''[5]''' - odličan;

'''Broj pregleda po danu''' <font color=\"red\">''(crveno)''</font> je prikazan na grafikonu ispod, u projekciji ''1:\$1''.",
	'right-feedback' => 'Korištenje obrasca povratne veze za ocjenjivanje stranice',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author ChrisiPK
 * @author Pill
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'ratinghistory' => 'Verlauf der Seitenbewertung',
	'ratinghistory-leg' => 'Verlauf der Seitenbewertung für [[:$1|$1]]',
	'ratinghistory-tab' => 'Bewertung',
	'ratinghistory-link' => 'Seitenbewertung',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Danke, dass du dir für die Bewertung dieser Seite einen Moment Zeit genommen hast!</font>''",
	'ratinghistory-period' => 'Zeitraum:',
	'ratinghistory-month' => 'letzter Monat',
	'ratinghistory-3months' => 'letzte 3 Monate',
	'ratinghistory-year' => 'letztes Jahr',
	'ratinghistory-3years' => 'letzte 3 Jahre',
	'ratinghistory-ave' => 'Durchschnitt: $1',
	'ratinghistory-chart' => 'Leserbewertungen über die Zeit',
	'ratinghistory-purge' => 'Cache leeren',
	'ratinghistory-table' => 'Überblick über die Leserbewertungen',
	'ratinghistory-users' => 'Benutzer, die bewertet haben:',
	'ratinghistory-graph' => '$2 von „$3“ ($1 {{PLURAL:$1|Bewertung|Bewertungen}})',
	'readerfeedback-svg' => 'Als SVG ansehen',
	'ratinghistory-table-rating' => 'Bewertung',
	'ratinghistory-table-votes' => 'Stimmen',
	'ratinghistory-none' => 'Es gibt noch nicht genug Seitenbewertungen durch Leser, um eine Grafik zu erstellen.',
	'ratinghistory-legend' => "Der '''Bewertungs-Tagesdurchschnitt''' <font color=\"blue\">''(blau)''</font> und der '''Durchschnitt über den ausgewählten Zeitraum''' <font color=\"green\">''(grün)''</font> werden nachfolgend nach Datum sortiert angezeigt. Der '''Durchschnitt im ausgewählten Zeitraum''' ist der Durchschnitt aller Tagesbewertungen ''innerhalb'' dieser Zeitspanne.

Legende: '''[1]''' - Mangelhaft; '''[2]''' - Ausreichend; '''[3]''' - Befriedigend; '''[4]''' - Gut; '''[5]''' - Sehr gut;

In der folgenden Grafik wird die '''Anzahl Bewertungen pro Tag''' <font color=\"red\">''(rot)''</font> auf einer 1:\$1-Skala gezeigt.",
	'right-feedback' => 'Bewerten einer Seite',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'ratinghistory' => 'Stawizny pógódnośenja boka',
	'ratinghistory-leg' => 'Stawizny pógódnośenja za [[:$1|$1]]',
	'ratinghistory-tab' => 'pógódnośenje',
	'ratinghistory-link' => 'Pógódnośenje boka',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Wjeliki źěk, až sy se brał cas, aby pśeglědał toś ten bok!</font>''",
	'ratinghistory-period' => 'Cas:',
	'ratinghistory-month' => 'slědny mjasec',
	'ratinghistory-3months' => 'slědne 3 mjasece',
	'ratinghistory-year' => 'slědne lěto',
	'ratinghistory-3years' => 'slědne 3 lěta',
	'ratinghistory-ave' => 'Pśerězk; $1',
	'ratinghistory-chart' => 'Pógódnośenja cytarjow pśez cas',
	'ratinghistory-purge' => 'cache wuprozniś',
	'ratinghistory-table' => 'Pśeglěd pógódnośenjow cytarjow',
	'ratinghistory-users' => 'Wužywarje, kótarež su pógódnośili:',
	'ratinghistory-graph' => '$2 z "$3" ($1 {{PLURAL:$1|pógódnośenje|pógódnośeni|pógódnośenja|pógódnośenjow}})',
	'readerfeedback-svg' => 'Ako SVG zwobrazniś',
	'ratinghistory-table-rating' => 'Pógódnośenje',
	'ratinghistory-table-votes' => 'Głose',
	'ratinghistory-none' => 'Tuchylu njejo dosć pógódnośenjow wót cytarjow, aby napórało grafiku.',
	'ratinghistory-legend' => "'''Dnjowne pśerězne gódnośenje''' <font color=\"blue\">''(módry)''</font> a  
'''pśerězne gódnośenje za wubrany cas''' <font color=\"green\">''(zeleny)''</font> zwobraznjujotej se dołojce pó datumje. '''Pśerězne gódnośenje za wubrany cas''' jo jadnorje pśerězk wšych dnjownych pógódnośenjow ''w'' toś tom casowem wótrězku kuždego dnja.

Skala: '''[1]''' - Špatny; '''[2]''' - Niski; '''[3]''' - Spokojecy; '''[4]''' - Wusoki; '''[5]''' - Wuběrny;

'''Licba pógódnośenjow na źeń''' <font color=\"red\">''(cerwjeny)''</font> pokazujo se dołojce na grafice, w měritku ''1:\$1''.",
	'right-feedback' => 'Wužyj pógódnośeński formular, aby pógódnośił bok',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'ratinghistory' => 'Historio de paĝtaksado',
	'ratinghistory-leg' => 'Taksada historio por [[:$1|$1]]',
	'ratinghistory-tab' => 'taksado',
	'ratinghistory-link' => 'Taksado de paĝo',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Dankon pro via peno por kontroli ĉi tiun paĝon!</font>''",
	'ratinghistory-period' => 'Tempdaŭro:',
	'ratinghistory-month' => 'lasta monato',
	'ratinghistory-3months' => 'lastaj 3 monatoj',
	'ratinghistory-year' => 'lasta jaro',
	'ratinghistory-3years' => 'lastaj 3 jaroj',
	'ratinghistory-ave' => 'Avĝ: $1',
	'ratinghistory-chart' => 'Taksado de legantaro trans tempo',
	'ratinghistory-purge' => 'refreŝigi kaŝmemoron',
	'ratinghistory-table' => 'Superrigardo pri taksado de legantoj',
	'ratinghistory-users' => 'Uzantoj taksinte ĉi tiun paĝon:',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|kontrolo|kontroloj}})',
	'readerfeedback-svg' => 'Vidi kiel SVG',
	'ratinghistory-table-rating' => 'Takso',
	'ratinghistory-table-votes' => 'Voĉdonoj',
	'ratinghistory-none' => 'Ne sufiĉas datenoj de legintoj por grafeoj ĉi-momente.',
	'ratinghistory-legend' => "La '''tage averaĝa taksado''' <font color=\"blue\">''(blua)''</font> kaj 
'''intervalaveraĝa taksado''' <font color=\"green\">''(verda)''</font> estas montrita en la jena grafeo, laŭ dato. La
'''intervalaveraĝa taksado''' estas simiple la averaĝo de ĉiuj tagaj taksaĵoj ''inter'' ĉi tiu tempdaŭro por ĉiu tago.

'''[1]''' - Malbonega; '''[2]''' - Malbonkvalita; '''[3]''' - Mezkvalita; '''[4]''' - Bonkvalita; '''[5]''' - Bonega;

La '''nombro de kontrolo po tago''' <font color=\"red\">''(ruĝa)''</font> estas montrata en la jena grafeo, en ''1:\$1'' skalo.",
	'right-feedback' => 'Uzu la kontrolan sekcion por kontroli paĝon',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'ratinghistory' => 'Historial de valoración de página',
	'ratinghistory-leg' => 'Datos de historial de valoración para [[:$1|$1]]',
	'ratinghistory-tab' => 'rating',
	'ratinghistory-link' => 'Valoración de página',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Gracias por tomarte un momento para revisar esta página!</font>''",
	'ratinghistory-period' => 'Periodo de tiempo:',
	'ratinghistory-month' => 'último mes',
	'ratinghistory-3months' => 'últimos 3 meses',
	'ratinghistory-year' => 'último año',
	'ratinghistory-3years' => 'últimos 3 años',
	'ratinghistory-purge' => 'purgar cache',
	'ratinghistory-table' => 'vista general de valoraciones de los lectores',
	'ratinghistory-users' => 'Usuarios que dieron valoraciones',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|revisión|revisiones}})',
	'readerfeedback-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Rating',
	'ratinghistory-table-votes' => 'Votos',
	'right-feedback' => 'Usar el formulario de retroalimentación para valorar una página',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'ratinghistory-month' => 'azken hilabetea',
	'ratinghistory-3months' => 'azken 3 hilabeteak',
	'ratinghistory-year' => 'azken urtea',
	'ratinghistory-3years' => 'azken 3 urteak',
	'readerfeedback-svg' => 'SVG bezala bistaratu',
);

/** Persian (فارسی)
 * @author Huji
 * @author Mardetanha
 * @author Momeni
 */
$messages['fa'] = array(
	'ratinghistory' => 'تاریخچهٔ ارزیابی صفحه',
	'ratinghistory-leg' => '[[:$1|$1]] داده‌های تاریخچهٔ ارزیابی',
	'ratinghistory-tab' => 'نمره',
	'ratinghistory-link' => 'درجهٔ مقاله',
	'ratinghistory-thanks' => "''<font color=\"darkred\">از این که فرصتی را صرف بازبینی این صفحه کردید متشکریم!</font>''",
	'ratinghistory-period' => 'بازه زمانی:',
	'ratinghistory-month' => 'ماه پیش',
	'ratinghistory-3months' => '۳ ماه اخیر',
	'ratinghistory-year' => 'سال پیش',
	'ratinghistory-3years' => 'سه سال پیش',
	'ratinghistory-chart' => 'ارزش‌دهی خوانندگان در طول زمان',
	'ratinghistory-table' => 'بررسی اجمالی ارزش‌دهی خوانندگان',
	'ratinghistory-users' => 'کاربرانی که درجه‌بندی کرده‌اند',
	'ratinghistory-graph' => 'داده‌های ارزیابی از $1 {{PLURAL:$1|خواننده|خواننده}}',
	'ratinghistory-table-rating' => 'ارزش‌دهی',
	'ratinghistory-none' => 'در حال حاضر بازخورد کافی از خوانندگان برای نمایش نمودار وجود ندارد.',
	'ratinghistory-legend' => "نمره متوسط روزانه <font color=\"blue\">''(آبی)''</font> و نمره متوسط برای بازهٔ زمانی انتخاب شده <font color=\"green\">''(سبز)''</font> در نمودار زیر، بر حسب تاریخ نشان داده شده‌اند. مقدار نمره‌ها به صورت زیر تعبیر می‌شود:

'''[۰]''' - ضعیف؛ '''[۱]''' - پایین؛ '''[۲]''' - متوسط؛ '''[۳]''' - بالا؛ '''[۴]''' - ممتاز؛",
	'right-feedback' => 'از فرم بازخورد برای نمره دادن به صفحه استفاده کنید',
);

/** Finnish (Suomi)
 * @author Str4nd
 */
$messages['fi'] = array(
	'readerfeedback-svg' => 'Näytä SVG-muodossa',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author PieRRoMaN
 * @author Zetud
 */
$messages['fr'] = array(
	'ratinghistory' => "Historique de l'évaluation de la page",
	'ratinghistory-leg' => 'Données de l’historique des évaluations pour [[:$1|$1]]',
	'ratinghistory-tab' => 'évaluation',
	'ratinghistory-link' => 'Évaluation de la page',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Merci d'avoir avoir consacré du temps pour relire cette page !</font>''",
	'ratinghistory-period' => 'Période :',
	'ratinghistory-month' => 'dernier mois',
	'ratinghistory-3months' => '3 derniers mois',
	'ratinghistory-year' => 'dernière année',
	'ratinghistory-3years' => '3 dernières années',
	'ratinghistory-ave' => 'Moyenne : $1',
	'ratinghistory-chart' => 'Évaluations par les lecteurs au cours du temps',
	'ratinghistory-purge' => 'purger le cache',
	'ratinghistory-table' => "Vue d'ensemble des évaluations par les lecteurs",
	'ratinghistory-users' => 'Utilisateurs qui ont fait des évaluations',
	'ratinghistory-graph' => '$2 sur « $3 » ($1 {{PLURAL:$1|relecture|relectures}})',
	'readerfeedback-svg' => 'Voir en SVG',
	'ratinghistory-table-rating' => 'Évaluation',
	'ratinghistory-table-votes' => 'Votes',
	'ratinghistory-none' => "Il n’y a pas suffisamment d'avis exprimés par des lecteurs pour établir des graphiques pour l'instant.",
	'ratinghistory-legend' => "L''''évaluation moyenne quotidienne''' <font color=\"blue\">''(bleu)''</font> et
l''''évaluation moyenne en cours''' <font color=\"green\">''(vert)''</font> sont représentées graphiquement ci-dessous, par date.
L''''évaluation moyenne en cours''' est simplement la moyenne de toutes les évaluations quotidiennes ''dans'' la période du jour choisie.

Échelle : '''[1]''' - Mauvais ; '''[2]''' - Médiocre ; '''[3]''' - Moyen ; '''[4]''' - Bon ; '''[5]''' - Excellent.

Le '''nombre de relectures par jour''' <font color=\"red\">''(rouge)''</font> est affiché sur le graphe ci-dessous, avec une échelle ''1:\$1''.",
	'right-feedback' => "Utiliser le formulaire de retour d'informations pour évaluer une page",
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'ratinghistory-month' => 'an mí seo caite',
	'ratinghistory-year' => 'an bhlian seo caite',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'ratinghistory' => 'Historial de valoracións da páxina',
	'ratinghistory-leg' => 'Historial de valoracións dos datos de "[[:$1|$1]]"',
	'ratinghistory-tab' => 'valoración',
	'ratinghistory-link' => 'Valoración da páxina',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Grazas por revisar esta páxina!</font>''",
	'ratinghistory-period' => 'Período de tempo:',
	'ratinghistory-month' => 'último mes',
	'ratinghistory-3months' => 'últimos 3 meses',
	'ratinghistory-year' => 'último ano',
	'ratinghistory-3years' => 'últimos 3 anos',
	'ratinghistory-ave' => 'Promedio: $1',
	'ratinghistory-chart' => 'Valoración do lector',
	'ratinghistory-purge' => 'limpar a caché',
	'ratinghistory-table' => 'Vista xeral das valoracións dos lectores',
	'ratinghistory-users' => 'Usuarios que valoraron páxinas',
	'ratinghistory-graph' => '$2 de "$3" ({{PLURAL:$1|unha revisión|$1 revisións}})',
	'readerfeedback-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Valoración',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Arestora non hai suficientes datos das reaccións dos lectores dispoñibles para as gráficas.',
	'ratinghistory-legend' => "A '''valoración do promedio diario''' <font color=\"blue\">''(azul)''</font> e
a '''valoración do promedio en curso''' <font color=\"green\">''(verde)''</font> están, por data, na gráfica de embaixo. A  
'''valoración do promedio en curso''' é simplemente a valoración de todas as valoracións diarias ''dentro'' do período de tempo de cada día.

Escala: '''[1]''' - Pobre; '''[2]''' - Baixo; '''[3]''' - Ben; '''[4]''' - Alto; '''[5]''' - Excelente;

O '''número de revisións ao día''' <font color=\"red\">''(vermello)''</font> móstrase embaixo, cunha escala de ''1:\$1''.",
	'right-feedback' => 'Usar o formulario de reacción para valorar unha páxina',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'ratinghistory' => 'Ἱστορικὸν βαθμώσεων δέλτου',
	'ratinghistory-leg' => 'Βάθμωσις δεδομένων προτέρων ἐκδόσεων [[:$1|$1]]',
	'ratinghistory-tab' => 'βάθμωσις',
	'ratinghistory-link' => 'Βάθμωσις δέλτου',
	'ratinghistory-period' => 'Περίοδος χρόνου:',
	'ratinghistory-month' => 'ὕστατος μήν',
	'ratinghistory-3months' => 'ὕστατοι 3 μῆνες',
	'ratinghistory-year' => 'ὕστατον ἔτος',
	'ratinghistory-3years' => 'ὕστατα 3 ἔτη',
	'readerfeedback-svg' => 'Ὁρᾶν ὡς SVG',
	'ratinghistory-table-rating' => 'Βάθμωσις',
	'ratinghistory-table-votes' => 'Ψῆφοι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'ratinghistory' => 'Verlauf vu dr Sytebewärtig',
	'ratinghistory-leg' => 'Verlauf vu dr Sytebewärtig fir [[:$1|$1]]',
	'ratinghistory-tab' => 'Bewärtig',
	'ratinghistory-link' => 'Sytebewärtig',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Dankschen, ass Du Dir e Momänt Zyt gnuh hesch go die Syte z bewärte!</font>''",
	'ratinghistory-period' => 'Zytruum',
	'ratinghistory-month' => 'letschte Monet',
	'ratinghistory-3months' => 'letschti drei Monet',
	'ratinghistory-year' => 'letscht Johr',
	'ratinghistory-3years' => 'letschte drei Johr',
	'ratinghistory-ave' => 'Durschnitt: $1',
	'ratinghistory-chart' => 'Bewärtige vu Läser im Zytruum',
	'ratinghistory-purge' => 'Cache lääre',
	'ratinghistory-table' => 'Iberblick iber Sytebewärtigen',
	'ratinghistory-users' => 'Benutzer, wu bewärtet hän:',
	'ratinghistory-graph' => '$2 vu „$3“ ($1 {{PLURAL:$1|Bewärtig|Bewärtige}})',
	'readerfeedback-svg' => 'As SVG aaluege',
	'ratinghistory-table-rating' => 'Bewärtig',
	'ratinghistory-table-votes' => 'Stimme',
	'ratinghistory-none' => 'S git nonig gnue Sytebewärtige dur Läser zum e Grafik aazlege.',
	'ratinghistory-legend' => "Dr '''Durchschnitt vu Bewärtige am Tag''' <font color=\"blue\">''(blau)''</font> un dr '''Durchschnitt iber dr usgwehlt Zytruum''' <font color=\"green\">''(grün)''</font> wäre do aazeigt no Datum sortiert.

'''[1]''' - isch Mangelhaft; '''[2]''' - Längt uus; '''[3]''' - Goht; '''[4]''' - isch Guet; '''[5]''' - isch Seli guet;

In däre Grafik wird d '''Aazahl vu Bewärtige am Tag''' <font color=\"red\">''(rot)''</font> uf ere ''1:\$1''-Skala zeigt.",
	'right-feedback' => 'E Syte bewärte',
);

/** Hebrew (עברית)
 * @author DoviJ
 * @author Rotemliss
 * @author דניאל ב.
 */
$messages['he'] = array(
	'ratinghistory' => 'היסטוריית דירוג הדף',
	'ratinghistory-leg' => 'נתוני היסטוריית הדירוג עבור [[:$1|$1]]',
	'ratinghistory-tab' => 'דירוג',
	'ratinghistory-link' => 'דירוג הדף',
	'ratinghistory-thanks' => "''<font color=\"darkred\">תודה על כך שהקדשתם מזמנכם לבדיקת דף זה!</font>''",
	'ratinghistory-period' => 'תקופת זמן:',
	'ratinghistory-month' => 'החודש האחרון',
	'ratinghistory-3months' => 'שלושת החודשים האחרונים',
	'ratinghistory-year' => 'השנה האחרונה',
	'ratinghistory-3years' => 'שלוש השנים האחרונות',
	'ratinghistory-ave' => 'ממוצע: $1',
	'ratinghistory-chart' => 'דירוגי קוראים לאורך זמן',
	'ratinghistory-purge' => 'ניקוי המטמון',
	'ratinghistory-table' => 'סיכום דירוגי הקוראים',
	'ratinghistory-users' => 'משתמשים שדירגו:',
	'ratinghistory-graph' => '$2 מתוך "$3" ({{PLURAL:$1|דירוג אחד|$1 דירוגים}})',
	'readerfeedback-svg' => 'הצגה כ־SVG',
	'ratinghistory-table-rating' => 'דירוג',
	'ratinghistory-table-votes' => 'הצבעות',
	'ratinghistory-none' => 'אין כרגע מספיק מידע זמין של משוב קוראים ליצירת תרשימים',
	'ratinghistory-legend' => "'''הדירוג הממוצע היומי''' <font color=\"blue\">'''(בכחול)'''</font> ו'''הדירוג הממוצע בתווך''' <font color=\"green\">'''(בירוק)'''</font> מוצגים בטבלאות למטה, לפי תאריך.
'''הדירוג הממוצע בתווך''' הוא פשוט הממוצע לכל הדירוגים ''בתוך'' התווך הזה לכל יום.

דירוג: '''[1]''' - גרוע; '''[2]''' - נמוך; '''[3]''' - בינוני; '''[4]''' - גבוה; '''[5]''' - מצוין;

'''מספר הביקורות ליום''' <font color=\"red\">'''(באדום)'''</font> מוצגים בטבלאות למטה, ביחס של ''1:\$1''.",
	'right-feedback' => 'השתמשו בטופס המשוב כדי לדרג דף',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'ratinghistory' => 'Stawizny hódnoćenja strony',
	'ratinghistory-leg' => 'Daty stawiznow hódnoćenja za [[:$1|$1]]',
	'ratinghistory-tab' => 'pohódnoćenje',
	'ratinghistory-link' => 'Pohódnoćenje strony',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Dźakujumy so ći, zo sy sej za hódnoćenje tuteje strony čas wzał!</font>''",
	'ratinghistory-period' => 'Doba:',
	'ratinghistory-month' => 'zańdźeny měsac',
	'ratinghistory-3months' => 'zańdźene 3 měsacy',
	'ratinghistory-year' => 'loni',
	'ratinghistory-3years' => 'zańdźene 3 lěta',
	'ratinghistory-ave' => 'Přerězk: $1',
	'ratinghistory-chart' => 'Pohódnoćenja čitarjow přez dobu',
	'ratinghistory-purge' => 'pufrowak wuprózdnić',
	'ratinghistory-table' => 'Přehlad wo pohódnoćenjach čitarjow',
	'ratinghistory-users' => 'Wužiwarjo, kotřiz su pohódnoćili:',
	'ratinghistory-graph' => '$2 z "$3" ($1 {{PLURAL:$1|kontrola|kontroli|kontrole|kontrolow}})',
	'readerfeedback-svg' => 'Jako SVG wobhladać',
	'ratinghistory-table-rating' => 'Pohodnoćenje',
	'ratinghistory-table-votes' => 'Hłosy',
	'ratinghistory-none' => 'Za grafiki hišće dosć pohódnoćenjow wot čitarjow k dispoziciji njesteji',
	'ratinghistory-legend' => "'''Dnjowe přerězne hódnoćenje''' <font color=\"blue\">''(módry)''</font> a '''běžne přerězne hódnoćenje''' <font color=\"green\">''(zeleny)''</font> stej deleka po datumje grafisce zwobraznjenej.

'''Běžne přerězne hódnoćenje''' je prosće přerězk wšěch dnjowych pohódnoćenjow ''znutřka'' tutoho časoweho wotrězka za kóždy dźeń.

Skala: '''[1]''' - Špatny; '''[2]''' - Niski; '''[3]''' - Spokojacy; '''[4]''' - Wysoki; '''[5]''' - Wuběrny;

'''Ličba pohódnoćenja wob dźeń''' <font color=\"red\">''(čerwjeny)''</font> pokazuje so na slědowacej grafice, w měritku ''1:\$1''.",
	'right-feedback' => 'Wužij wotmołwny formular, zo by stronu pohódnoćił',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Gondnok
 * @author Grin
 * @author Samat
 */
$messages['hu'] = array(
	'ratinghistory' => 'Értékelési történet',
	'ratinghistory-leg' => 'Értékelési előzmények adatai a(z) [[:$1|$1]] lapnál',
	'ratinghistory-tab' => 'értékelés',
	'ratinghistory-link' => 'Lap értékelése',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Köszönjük, hogy időt szántál az oldal értékelésére!</font>''",
	'ratinghistory-period' => 'Időszak:',
	'ratinghistory-month' => '1 hónap',
	'ratinghistory-3months' => 'utolsó 3 hónap',
	'ratinghistory-year' => '1 év',
	'ratinghistory-3years' => '3 év',
	'ratinghistory-ave' => 'Átlag: $1',
	'ratinghistory-chart' => 'Olvasói visszajelzések időrendben',
	'ratinghistory-table' => 'Olvasói értékelések áttekintése',
	'ratinghistory-users' => 'Szerkesztők, akik értékelték a lapot',
	'ratinghistory-graph' => '$2 a „$3” oldalon ($1 {{PLURAL:$1|értékelés|értékelés}})',
	'readerfeedback-svg' => 'Megtekintés SVG formátumban',
	'ratinghistory-table-rating' => 'Értékelés',
	'ratinghistory-table-votes' => 'Szavazatok',
	'ratinghistory-none' => 'Jelenleg még nem áll rendelkezésre elég visszajelzés a grafikonok elkészítéséhez.',
	'ratinghistory-legend' => "Alább a '''napi átlagos értékelés''' <font color=\"blue\">''(kék színnel)''</font> és a '''megadott időtartam alatti átlagos értékelés''' <font color=\"green\">''(zöld színnel)''</font> grafikonja látható, dátum szerint. A '''megadott időtartam alatti átlagos értékelés''' egyszerűen az összes napi értékelés átlaga a megadott időtartam '''alatt'''.

Értékek: '''[1]''' – rossz; '''[2]''' – gyenge; '''[3]''' – közepes; '''[4]''' – jó; '''[5]''' – kitűnő;

A '''naponkénti értékelések száma''' <font color=\"red\">''(piros színnel)''</font> látható a grafikonokon, ''1:\$1'' arányon.",
	'right-feedback' => 'oldalak értékelése a visszajelzés-űrlap segítségével',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'ratinghistory' => 'Historia de evalutationes de paginas',
	'ratinghistory-leg' => 'Datos historic de evalutationes pro [[:$1|$1]]',
	'ratinghistory-tab' => 'evalutation',
	'ratinghistory-link' => 'Evalutation del pagina',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Gratias pro haber dedicate un momento a evalutar iste pagina!</font>''",
	'ratinghistory-period' => 'Periodo de tempore:',
	'ratinghistory-month' => 'ultime mense',
	'ratinghistory-3months' => 'ultime 3 menses',
	'ratinghistory-year' => 'ultime anno',
	'ratinghistory-3years' => 'ultime 3 annos',
	'ratinghistory-ave' => 'Media: $1',
	'ratinghistory-chart' => 'Evalutationes del lectores in le curso del tempore',
	'ratinghistory-purge' => 'vacuar cache',
	'ratinghistory-table' => 'Summario del evalutationes del lectores',
	'ratinghistory-users' => 'Usatores qui ha facite evalutationes',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|evalutation|evalutationes}})',
	'readerfeedback-svg' => 'Vider como SVG',
	'ratinghistory-table-rating' => 'Evalutation',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Non es disponibile sufficiente datos de evalutationes de lectores pro poter facer graphicos al momento.',
	'ratinghistory-legend' => "Le '''evalutation medie de cata die''' <font color=\"blue\">''(blau)''</font> e  
'''evalutation medie currente''' <font color=\"green\">''(verde)''</font> es representate infra, per data. Le  
'''evalutation medie currente''' es simplemente le media de tote le evalutationes de cata die ''intra'' iste periodo de tempore pro cata die.

Scala: '''[1]''' - Mal; '''[2]''' - Basse; '''[3]''' - Medie; '''[4]''' - Alte; '''[5]''' - Excellente;

Le '''numero de evalutationes per die''' <font color=\"red\">''(rubie)''</font> es monstrate in le graphicos infra, in scala ''1:\$1''.",
	'right-feedback' => 'Usa le formulario de reaction pro evalutar un pagina',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'ratinghistory' => 'Sejarah penilaian halaman',
	'ratinghistory-leg' => 'Data sejarah penilaian',
	'ratinghistory-tab' => 'penilaian',
	'ratinghistory-link' => 'Peringkat artikel',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Terima kasih Anda telah meninjau halaman ini!</font>''",
	'ratinghistory-period' => 'Periode waktu:',
	'ratinghistory-month' => 'bulan lalu',
	'ratinghistory-year' => 'tahun lalu',
	'ratinghistory-3years' => '3 tahun terakhir',
	'ratinghistory-chart' => 'Peringkat pembaca dari waktu ke waktu',
	'ratinghistory-users' => 'Pengguna yang meninjau halaman ini:',
	'ratinghistory-graph' => '$2 dari "$3" ($1 {{PLURAL:$1|tinjauan|tinjauan}})',
	'ratinghistory-none' => 'Belum ada cukup umpan balik pembaca tersedia untuk membuat grafik pada saat ini.',
	'ratinghistory-legend' => "'''Rata-rata peringkat harian''' <font color=\"blue\">''(biru)''</font> dan '''rata-rata peringkat interval''' <font color=\"green\">''(hijau)''</font> ditampilkan dalam grafik di bawah ini, menurut tanggal.

Skala: '''[1]''' - Buruk; '''[2]''' - Rendah; '''[3]''' - Cukup; '''[4]''' - Tinggi; '''[5]''' - Baik sekali;

'''Jumlah tinjauan per hari''' <font color=\"red\">''(merah)''</font> ditampilkan pada grafik berikut dengan skala ''1:\$1''.",
	'right-feedback' => 'Gunakan formulir umpan balik untuk memberikan peringkat halaman',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'ratinghistory' => 'Cronologia dei giudizi delle pagine',
	'ratinghistory-leg' => 'Dati della cronologia dei giudizi per [[:$1|$1]]',
	'ratinghistory-tab' => 'giudizio',
	'ratinghistory-link' => 'Giudizio pagina',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Grazie per aver dedicato un momento al giudizio di questa pagina!</font>''",
	'ratinghistory-period' => 'Periodo di tempo:',
	'ratinghistory-month' => 'ultimo mese',
	'ratinghistory-3months' => 'ultimi 3 mesi',
	'ratinghistory-year' => 'ultimo anno',
	'ratinghistory-3years' => 'ultimi 3 anni',
	'ratinghistory-ave' => 'Media: $1',
	'ratinghistory-chart' => 'Giudizi dei lettori nel corso del tempo',
	'ratinghistory-purge' => 'pulisci la cache',
	'ratinghistory-table' => 'Panoramica dei voti dei lettori',
	'ratinghistory-users' => 'Utenti che hanno dato un giudizio',
	'ratinghistory-graph' => '$2 di "$3" ($1 {{PLURAL:$1|revisione|revisioni}})',
	'readerfeedback-svg' => 'Visualizza come SVG',
	'ratinghistory-table-rating' => 'Giudizio',
	'ratinghistory-table-votes' => 'Voti',
	'ratinghistory-none' => 'Non sono disponibile sufficienti dati di feedback dei lettori per poter rappresentare dei grafici al momento.',
	'ratinghistory-legend' => "I '''giudizi medi giornalieri''' <font color=\"blue\">''(blu)''</font> e gli '''intervalli dei giudizi medi''' selezionati <font color=\"green\">''(verde)''</font> sono rappresentati di seguito, in ordine di data. Gli '''intervalli dei giudizi medi''' sono semplicemente la media di tutti i giudizi giornalieri ''dentro'' questa finestra temporale per ogni giorno.

Scala: '''[1]''' - Insufficiente; '''[2]''' - Mediocre; '''[3]''' - Discreto; '''[4]''' - Buono; '''[5]''' - Ottimo;

Il '''numero di revisioni al giorno''' <font color=\"red\">''(rosso)''</font> è mostrato nel grafico di sotto, in scala ''1:\$1''.",
	'right-feedback' => 'Usa il modulo di feedback per giudicare una pagina',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'ratinghistory' => 'ページ評価履歴',
	'ratinghistory-leg' => '[[:$1|$1]] の評価履歴',
	'ratinghistory-tab' => '評価',
	'ratinghistory-link' => 'ページ評価',
	'ratinghistory-thanks' => "''<font color=\"darkred\">時間を割いて、このページを評価していただきありがとうございます！</font>''",
	'ratinghistory-period' => '期間:',
	'ratinghistory-month' => '過去1か月',
	'ratinghistory-3months' => '過去3か月',
	'ratinghistory-year' => '過去1年',
	'ratinghistory-3years' => '過去3年',
	'ratinghistory-ave' => '平均: $1',
	'ratinghistory-chart' => '期間中の読者評価',
	'ratinghistory-purge' => 'キャッシュ削除',
	'ratinghistory-table' => '読者評価の概観',
	'ratinghistory-users' => '評価を行った利用者',
	'ratinghistory-graph' => '「$3」の$2 ($1回の評価)',
	'readerfeedback-svg' => 'SVGとして表示',
	'ratinghistory-table-rating' => '評価',
	'ratinghistory-table-votes' => '票数',
	'ratinghistory-none' => '現時点ではグラフを表示するのに十分な読者評価データがありません。',
	'ratinghistory-legend' => "日ごとの'''日間平均評価''' <font color=\"blue\">''(青)''</font> と'''移動平均評価''' <font color=\"green\">''(緑)''</font> を以下のグラフに表示します。'''移動平均評価'''とは単にこの期間中のすべての日間評価の平均のことです。

目盛り: '''[1]''' - {{int:readerfeedback-level-0}}、'''[2]''' - {{int:readerfeedback-level-1}}、'''[3]''' - {{int:readerfeedback-level-2}}、'''[4]''' - {{int:readerfeedback-level-3}}、'''[5]''' - {{int:readerfeedback-level-4}}

'''日ごとの評価回数''' <font color=\"red\">''(赤)''</font> を以下のグラフに\$1分の1の縮尺で表示します。",
	'right-feedback' => 'ページを評価するためのフォームを使用する',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'ratinghistory-period' => 'Jangka wektu:',
	'ratinghistory-month' => 'sasi kapungkur',
	'ratinghistory-year' => 'taun kapungkur',
	'ratinghistory-3years' => '3 taun pungkasan',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'ratinghistory-period' => 'កំលុងពេល:',
	'ratinghistory-month' => 'ខែមុន',
	'ratinghistory-3months' => '៣ ខែ​ចុងក្រោយ',
	'ratinghistory-year' => 'ឆ្នាំមុន',
	'ratinghistory-3years' => '៣ឆ្នាំមុន',
	'readerfeedback-svg' => 'មើល​ជា SVG',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'ratinghistory-thanks' => "'''<font color=\"darkred\">이 문서를 검토해 주셔서 감사합니다!</font>'''",
	'ratinghistory-period' => '기간:',
	'ratinghistory-month' => '지난 1개월',
	'ratinghistory-3months' => '지난 3개월',
	'ratinghistory-year' => '지난 1년',
	'ratinghistory-3years' => '지난 3년',
	'readerfeedback-svg' => 'SVG로 보기',
	'right-feedback' => '문서를 평가하는 피드백 양식을 이용',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'ratinghistory-month' => 'letzt Mohnd',
	'ratinghistory-3months' => 'letzte drei Mohnd',
	'ratinghistory-year' => 'letz Johr',
	'ratinghistory-3years' => 'letz drei Johre',
	'ratinghistory-ave' => 'Dorschnett: $1',
	'ratinghistory-purge' => 'Donn der Zwescheshpeisher (der <i lang="en">cache</i>) leddisch maache',
	'readerfeedback-svg' => 'Als en <code>SVG</code>-Dattei aanloore',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'ratinghistory-thanks' => "''<font color=\"darkred\">Merci datt Dir Iech en Ament Zäit huelt fir dës Säit nozekucken!</font>''",
	'ratinghistory-period' => 'Zäitraum:',
	'ratinghistory-month' => 'leschte Mount',
	'ratinghistory-3months' => 'lescht 3 Méint',
	'ratinghistory-year' => 'lescht Joer',
	'ratinghistory-3years' => 'lescht 3 Joer',
	'ratinghistory-purge' => 'Tëschespäicher (Cache) eidelmaachen',
	'readerfeedback-svg' => 'Als SVG kucken',
	'ratinghistory-table-votes' => 'Stëmmen',
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'ratinghistory' => 'Историја на оценување на страница',
	'ratinghistory-leg' => 'Податоци за историјата на оценување за [[:$1|$1]]',
	'ratinghistory-tab' => 'оценка',
	'ratinghistory-link' => 'Оценка на страница',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Благодариме за вашето одвоено време за оценување на оваа страница!</font>''",
	'ratinghistory-period' => 'Временски период:',
	'ratinghistory-month' => 'последен месец',
	'ratinghistory-3months' => 'последни 3 месеци',
	'ratinghistory-year' => 'последна година',
	'ratinghistory-3years' => 'последни 3 години',
	'ratinghistory-users' => 'Корисници кои дале оценки',
	'ratinghistory-graph' => '$2 од "$3" ($1 {{PLURAL:$1|оценка|оценки}})',
	'readerfeedback-svg' => 'Поглед како SVG',
	'ratinghistory-none' => 'Нема доволно податоци од оценувачите за исцртување на графиконот во овој момент.',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'ratinghistory' => 'Sejarah penilaian laman',
	'ratinghistory-leg' => 'Data sejarah penilaian',
	'ratinghistory-tab' => 'penilaian',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Terima kasih kerana sudi meluangkan masa untuk memeriksa laman ini!</font>''",
	'ratinghistory-period' => 'Tempoh masa:',
	'ratinghistory-month' => 'bulan lepas',
	'ratinghistory-year' => 'tahun lepas',
	'ratinghistory-3years' => '3 tahun lepas',
	'ratinghistory-none' => 'Data maklum balas pembaca belum cukup untuk penghasilan graf.',
	'ratinghistory-legend' => "Berikut ialah graf penilaian purata harian <font color=\"blue\">''(biru)''</font> dan penilaian purata selang yang dipilih <font color=\"green\">''(hijau)''</font> mengikut tarikh. Jumlah pemeriksaan ditunjukkan di bucu kanan atas. Nilai tinggi menandakan data sampel yang lebih baik. Berikut ialah pentafsiran tahap penilaian:

'''[1]''' - Lemah, '''[2]''' - Rendah, '''[3]''' - Sederhana, '''[4]''' - Tinggi, '''[5]''' - Cemerlang",
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'ratinghistory-year' => 'мелять',
	'ratinghistory-3years' => 'меельсе 3 иеть',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'ratinghistory-period' => 'Cāhuitl:',
	'ratinghistory-month' => 'achto mētztli',
	'ratinghistory-3months' => 'achto 3 mētztli',
	'ratinghistory-year' => 'achto xihuitl',
	'ratinghistory-3years' => 'achto 3 xihuitl',
	'ratinghistory-graph' => '$2 īhuīcpa "$3" ($1 {{PLURAL:$1|tlachiyaliztli|tlachiyaliztli}})',
	'readerfeedback-svg' => 'Tiquittāz quemeh SVG',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'ratinghistory' => 'Geschiedenis paginawaardering',
	'ratinghistory-leg' => 'Historische waarderingsgegevens voor [[:$1|$1]]',
	'ratinghistory-tab' => 'waardering',
	'ratinghistory-link' => 'Paginawaardering',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Dank u wel voor de moeite die u hebt genomen om deze pagina te waarderen!</font>''",
	'ratinghistory-period' => 'Tijdsperiode:',
	'ratinghistory-month' => 'afgelopen maand',
	'ratinghistory-3months' => 'laatste 3 maanden',
	'ratinghistory-year' => 'afgelopen jaar',
	'ratinghistory-3years' => 'afgelopen 3 jaar',
	'ratinghistory-ave' => 'Gemiddeld: $1',
	'ratinghistory-chart' => 'Lezerswaardering in de tijd',
	'ratinghistory-purge' => 'cache legen',
	'ratinghistory-table' => 'Overzicht van de lezerswaarderingen',
	'ratinghistory-users' => 'Gebruikers die een waardering hebben gegeven',
	'ratinghistory-graph' => '$2 van "$3" ($1 {{PLURAL:$1|waardering|waarderingen}})',
	'readerfeedback-svg' => 'Als SVG bekijken',
	'ratinghistory-table-rating' => 'Waardering',
	'ratinghistory-table-votes' => 'Stemmen',
	'ratinghistory-none' => 'Er is onvoldoende terugkoppeling van lezers aanwezig om een grafiek te maken.',
	'ratinghistory-legend' => "De '''dagelijkse gemiddelde waardering''' <font color=\"blue\">''(blauw)''</font> en
de '''gemiddelde waardering van de aangegeven periode''' <font color=\"green\">''(groen)''</font> staan hieronder in een grafiek op datum.
De '''gemiddelde waardering van de aangegeven periode''' is het gemiddelde van alle dagelijkse gemiddelde waarderingen ''binnnen'' dit tijdvak voor iedere dag.

Schaal: '''[1]''' - Slecht; '''[2]''' - Laag; '''[3]''' - Redelijk; '''[4]''' - Hoog; '''[5]''' - Uitstekend;

Het '''aantal waarderingen per dag''' <font color=\"red\">''(rood)''</font> wordt hieronder weergegeven in de grafieken op een schaal van ''1:\$1''.",
	'right-feedback' => 'Het waarderingsformulier gebruiken om een pagina te waarderen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'ratinghistory' => 'Sidevurderingshistorikk',
	'ratinghistory-leg' => 'Vurderingshistorikkdata for [[:$1|$1]]',
	'ratinghistory-tab' => 'vurdering',
	'ratinghistory-link' => 'Sidevurdering',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Takk for at du tok deg tid til å vurdera sida!</font>''",
	'ratinghistory-period' => 'Tidsperiode:',
	'ratinghistory-month' => 'siste månaden',
	'ratinghistory-3months' => 'siste tre månader',
	'ratinghistory-year' => 'siste året',
	'ratinghistory-3years' => 'siste tre år',
	'ratinghistory-ave' => 'Snitt: $1',
	'ratinghistory-chart' => 'Lesarvurdering over tid',
	'ratinghistory-purge' => 'oppdater mellomlager',
	'ratinghistory-table' => 'Oversyn over lesarvurderingar',
	'ratinghistory-users' => 'Brukarar som vurderte sida',
	'ratinghistory-graph' => '$2 for «$3» ({{PLURAL:$1|éi vurdering|$1 vurderingar}})',
	'readerfeedback-svg' => 'Syn som SVG',
	'ratinghistory-table-rating' => 'Vurdering',
	'ratinghistory-table-votes' => 'Røyster',
	'ratinghistory-none' => 'Det finst på noverande tidspunkt ikkje nok lesarvurderingar til å teikna ein graf.',
	'ratinghistory-legend' => "Den '''daglege gjennomsnittsvurderinga''' <font color=\"blue\">''(blått)''</font> og  
'''gjennomsnittet for det valte intervallet''' per dag <font color=\"green\">''(grønt)''</font> er teikna inn på grafane under etter dato.

Skala: '''[1]''' - Sers dårleg; '''[2]''' - Dårleg; '''[3]''' - OK; '''[4]''' - Bra; '''[5]''' - Sers bra;

Talet på '''vurderingar per dag''' <font color=\"red\">''(raudt)''</font> er vist på grafane under med ein skala på  ''1:\$1''.",
	'right-feedback' => 'Nytta tilbakemeldingsskjemaet for å vurdera ei sida',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'ratinghistory' => 'Sidens vurderingshistorikk',
	'ratinghistory-leg' => 'Vurderingshistorikkdata',
	'ratinghistory-tab' => 'vurdering',
	'ratinghistory-link' => 'Artikkelvurdering',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Takk for at du tar deg tid til å anmelde denne siden!</font>''",
	'ratinghistory-period' => 'Tidsperiode:',
	'ratinghistory-month' => 'siste måned',
	'ratinghistory-year' => 'siste år',
	'ratinghistory-3years' => 'siste tre år',
	'ratinghistory-graph' => 'Gå gjennom data fra $1 {{PLURAL:$1|leser|lesere}}',
	'ratinghistory-none' => 'Det er ikke nok leservurderinger til å vise grafer ennå.',
	'ratinghistory-legend' => "Det daglige gjennomsnittet (<font color=\"blue\">''blå''</font>) og gjennomsnittet for valgte intervall (<font color=\"green\">''grønn''</font>) vil vises i grafen nedenfor, etter dato. Vurderingsverdiene tolkes slik:

'''[1]''' &ndash; Veldig dårlig; '''[2]''' &ndash; Dårlig; '''[3]''' &ndash; OK; '''[4]''' &ndash; Bra; '''[5]''' &ndash; Veldig bra;",
	'right-feedback' => 'Bruke tilbakemeldingsskjemaet for å vurdere en side',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'ratinghistory' => 'Istoric de la notacion de la pagina',
	'ratinghistory-leg' => 'Donadas de l’istoric de la notacion per [[:$1|$1]]',
	'ratinghistory-tab' => 'notacion',
	'ratinghistory-link' => 'Notacion de la pagina',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Mercés de nos aver consacrat de temps per tornar legir aquesta pagina !</font>''",
	'ratinghistory-period' => 'Periòde :',
	'ratinghistory-month' => 'darrièr mes',
	'ratinghistory-3months' => 'darrièrs 3 meses',
	'ratinghistory-year' => 'darrièra annada',
	'ratinghistory-3years' => 'las 3 darrièras annadas',
	'ratinghistory-ave' => 'Mejana : $1',
	'ratinghistory-chart' => 'Relector notant fòra relambi',
	'ratinghistory-purge' => "purgar l'amagatal",
	'ratinghistory-table' => "Vista d'ensemble de las notations dels lectors",
	'ratinghistory-users' => "Utilizaires qu'an fach de relecturas",
	'ratinghistory-graph' => '$2 sus « $3 » ($1 {{PLURAL:$1|relector|relectors}})',
	'readerfeedback-svg' => 'Veire en SVG',
	'ratinghistory-table-rating' => 'Notacion',
	'ratinghistory-table-votes' => 'Vòts',
	'ratinghistory-none' => 'En aqueste moment, i a pas pro de lectors de donadas de notacion pels grafics.',
	'ratinghistory-legend' => "Las quotacions jornalièras <font color=\"blue\">''(blau)''</font> e la '''mejana de quotacion en cors''' <font color=\"green\">''(verd)''</font> de la notacion son dessenhats çaijós, per data. La '''mejana de quotacion en cors''' es simplament la mejana de las qotacions de cada ''dins'' lo periòde de temps causit.

'''[1]''' - Marrit ; '''[2]''' - Mediòcre ; '''[3]''' - Mejan ; '''[4]''' - Bon ; '''[5]''' - Excellent ;

Lo '''nombre de verificacion per jorn''' <font color=\"red\">''(roge)''</font> es afichat sul grafic çaijós, amb una escala ''1:\$1''.",
	'right-feedback' => 'Utilizar lo formulari de somission per notar una pagina',
);

/** Polish (Polski)
 * @author Holek
 * @author Jwitos
 * @author Leinad
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'ratinghistory' => 'Historia oceniania strony',
	'ratinghistory-leg' => 'Historia oceniania dla [[:$1|$1]]',
	'ratinghistory-tab' => 'ocena',
	'ratinghistory-link' => 'Ocena strony',
	'ratinghistory-thanks' => '\'\'<font color="darkred">Dziękujemy za poświęcony czas na ocenę tej strony!</font>',
	'ratinghistory-period' => 'Okres czasu:',
	'ratinghistory-month' => 'ostatni miesiąc',
	'ratinghistory-3months' => 'ostatnie 3 miesiące',
	'ratinghistory-year' => 'ostatni rok',
	'ratinghistory-3years' => 'ostatnie 3 lata',
	'ratinghistory-ave' => 'Średnia $1',
	'ratinghistory-chart' => 'Oceny czytelników w czasie',
	'ratinghistory-purge' => 'odśwież pamięć podręczną',
	'ratinghistory-table' => 'Przegląd ocen wystawionych przez czytelników',
	'ratinghistory-users' => 'Użytkownicy, którzy wystawili ocenę',
	'ratinghistory-graph' => '$2 strony „$3” ($1 {{PLURAL:$1|ocena|oceny|ocen}})',
	'readerfeedback-svg' => 'Zobacz jako SVG',
	'ratinghistory-table-rating' => 'Ocena',
	'ratinghistory-table-votes' => 'Głosy',
	'ratinghistory-none' => 'W tej chwil brak liczby ocen czytelników wystarczającej, by móc stworzyć wykresy.',
	'ratinghistory-legend' => "Średnia dzienna ocena <font color=\"blue\">''(na niebiesko)''</font> i średnia w wybranym przedziale czasowym <font color=\"green\">''(na zielono)''</font> są przedstawione na wykresie poniżej, w kolejności chronologicznej. Średnia w wybranym przedziale czasowym to średnia dziennych ocen w tym przedziale czasowym.

Skala: '''[1]''' – Niedostatecznie; '''[2]''' – Słabo; '''[3]''' – Zadowalająco; '''[4]''' – Dobrze; '''[5]''' – Bardzo dobrze;

'''Liczba ocen na dzień''' <font color=\"red\">''(na czerwono)''</font> jest pokazana poniżej wykresu w skali ''1:\$1''.",
	'right-feedback' => 'Użyj formularza, aby ocenić stronę',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'ratinghistory-period' => 'د وخت موده:',
	'ratinghistory-month' => 'تېره مياشت',
	'ratinghistory-3months' => 'تېرې ۳ مياشتې',
	'ratinghistory-year' => 'تېر کال',
	'ratinghistory-3years' => 'تېر ۳ کالونه',
	'readerfeedback-svg' => 'د SVG په توګه کتل',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'ratinghistory' => 'Histórico de avaliações da página',
	'ratinghistory-leg' => 'Histórico de dados de avaliações para [[:$1|$1]]',
	'ratinghistory-tab' => 'avaliação',
	'ratinghistory-link' => 'Avaliação da página',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Obrigado por reservar um momento para avaliar esta página!</font>''",
	'ratinghistory-period' => 'Período de tempo:',
	'ratinghistory-month' => 'último mês',
	'ratinghistory-3months' => 'últimos 3 meses',
	'ratinghistory-year' => 'último ano',
	'ratinghistory-3years' => 'últimos três anos',
	'ratinghistory-ave' => 'Média: $1',
	'ratinghistory-chart' => 'Avaliações do leitor ao longo do tempo',
	'ratinghistory-purge' => 'limpar cache',
	'ratinghistory-table' => 'Resumo das avaliações dos leitores',
	'ratinghistory-users' => 'Utilizadores que fizeram avaliações',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|avaliação|avaliações}})',
	'readerfeedback-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Avaliação',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Ainda não há dados suficientes de avaliações dos leitores para mostrar gráficos.',
	'ratinghistory-legend' => "A '''avaliação média diária''' <font color=\"blue\">''(azul)''</font> e a '''avaliação média acumulada''' <font color=\"green\">''(verde)''</font> estão apresentadas graficamente abaixo, por data. A '''avaliação média acumulada''' é apenas a média de todas as avaliações diárias ''dentro'' desta janela temporal para cada dia.

Escala: '''[1]''' - Péssima; '''[2]''' - Baixa; '''[3]''' - Razoável; '''[4]''' - Alta; '''[5]''' - Excelente;

O '''número de of análises por dia''' <font color=\"red\">''(vermelho)''</font> é mostrado nos gráficos abaixo, numa escala ''1:\$1''.",
	'right-feedback' => 'Use o formulário de feedback para avaliar uma página',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'ratinghistory' => 'Histórico de avaliações da página',
	'ratinghistory-leg' => 'Histórico de dados de avaliações para [[:$1|$1]]',
	'ratinghistory-tab' => 'avaliação',
	'ratinghistory-link' => 'Avaliação da página',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Obrigado por reservar um momento para avaliar esta página!</font>''",
	'ratinghistory-period' => 'Período de tempo:',
	'ratinghistory-month' => 'último mês',
	'ratinghistory-3months' => 'últimos 3 meses',
	'ratinghistory-year' => 'último ano',
	'ratinghistory-3years' => 'últimos três anos',
	'ratinghistory-ave' => 'Média: $1',
	'ratinghistory-chart' => 'Avaliações dos leitores ao longo do tempo',
	'ratinghistory-purge' => 'limpar cache',
	'ratinghistory-table' => 'Resumo das avaliações dos leitores',
	'ratinghistory-users' => 'Utilizadores que fizeram avaliações',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|avaliação|avaliações}})',
	'readerfeedback-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Avaliação',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Ainda não há dados suficientes de avaliações dos leitores para mostrar gráficos.',
	'ratinghistory-legend' => "A '''avaliação média diária''' <font color=\"blue\">''(azul)''</font> e a '''avaliação média acumulada''' <font color=\"green\">''(verde)''</font> estão apresentadas graficamente abaixo, por data. A '''avaliação média acumulada''' é apenas a média de todas as avaliações diárias ''dentro'' desta janela temporal para cada dia.

Escala: '''[1]''' - Péssima; '''[2]''' - Baixa; '''[3]''' - Razoável; '''[4]''' - Alta; '''[5]''' - Excelente;

O '''número de análises por dia''' <font color=\"red\">''(vermelho)''</font> é mostrado nos gráficos abaixo, numa escala ''1:\$1''.",
	'right-feedback' => 'Use o formulário de feedback para avaliar uma página',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'ratinghistory-month' => 'ultima lună',
	'ratinghistory-3months' => 'ultimele 3 luni',
	'ratinghistory-year' => 'ultimul an',
	'ratinghistory-3years' => 'ultimii 3 ani',
	'readerfeedback-svg' => 'Vizualizează drept SVG',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'ratinghistory' => "Storie de le pundegge d'a pàgene",
	'ratinghistory-leg' => 'Storie de le dete de le pundegge pe [[:$1|$1]]',
	'ratinghistory-tab' => 'pundegge',
	'ratinghistory-link' => "Pundegge d'a pàgene",
	'ratinghistory-thanks' => "''<font color=\"darkred\">Grazie 'mbà ca è perse doje menute pe recondrollà sta pàgene!</font>''",
	'ratinghistory-period' => 'Periode de timbe:',
	'ratinghistory-month' => 'urteme mese',
	'ratinghistory-3months' => 'urteme 3 mise',
	'ratinghistory-year' => 'urteme anne',
	'ratinghistory-3years' => 'urteme ttre anne',
	'ratinghistory-ave' => 'Medie: $1',
	'ratinghistory-chart' => 'Pundegge de le lettore fore timbe massime',
	'ratinghistory-purge' => "pulizze 'a cache",
	'ratinghistory-table' => 'Riepileghe de le pundegge de le lettore',
	'ratinghistory-users' => "Utinde ca onne date 'nu pundegge",
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|revisione|revisiune}})',
	'readerfeedback-svg' => 'Vide cumme a SVG',
	'ratinghistory-table-rating' => 'Pundegge',
	'ratinghistory-table-votes' => 'Vote',
	'ratinghistory-none' => "Non ge stonne abbastanza lettore ca onne lassete 'u feedback pe ccrejà 'nu grafeche jndr'à stu timbe.",
	'ratinghistory-legend' => "'U '''pundegge medie sciurnaliere''' <font color=\"blue\">''(blue)''</font> e
'u '''pundegge medie corrende''' <font color=\"green\">''(green)''</font> sonde disegnete aqquà sotte, pe date.
'U '''pundegge medie corrende''' jè semblicemende 'a medie de tutte le pundegge sciuraliere ''fine a'' osce.

Schele: '''[1]''' - Povere; '''[2]''' - Vasce; '''[3]''' - Medie; '''[4]''' - Ierte; '''[5]''' - 'A uerre proprie;

'Le '''numere de revisitaziune pe sciurne''' <font color=\"red\">''(red)''</font> sonde visualizzete sus a 'u grafeche aqquà sotte, sus a 'na ''1:\$1'' schele.",
	'right-feedback' => "Ause 'u form p'u feedback pe dà 'nu pundegge a 'na pàgene",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Putnik
 * @author Sergey kudryavtsev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'ratinghistory' => 'История оценок страницы',
	'ratinghistory-leg' => 'Данные по истории оценок страницы [[:$1|$1]]',
	'ratinghistory-tab' => 'оценка',
	'ratinghistory-link' => 'Оценка страницы',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Спасибо, что нашли время оценить эту страницу!</font>''",
	'ratinghistory-period' => 'Период времени:',
	'ratinghistory-month' => 'последний месяц',
	'ratinghistory-3months' => 'последние 3 месяца',
	'ratinghistory-year' => 'последний год',
	'ratinghistory-3years' => 'последние 3 года',
	'ratinghistory-ave' => 'Средняя: $1',
	'ratinghistory-chart' => 'Оценки читателей за всё время',
	'ratinghistory-table' => 'Обзор оценок читателей',
	'ratinghistory-users' => 'Участники, которые дали оценку',
	'ratinghistory-graph' => '$2 из «$3» ($1 {{PLURAL:$1|оценка|оценки|оценок}})',
	'readerfeedback-svg' => 'Просмотреть как SVG',
	'ratinghistory-table-rating' => 'Оценка',
	'ratinghistory-table-votes' => 'Голоса',
	'ratinghistory-none' => 'В настоящее время набралось недостаточное количество читательских оценок для построения графика.',
	'ratinghistory-legend' => "Ниже показаны '''среднесуточная оценка''' <font color=\"blue\">''(синий)''</font> и
'''текущая средняя оценка''' <font color=\"green\">''(зелёный)''</font>.  '''Текущая средняя оценка''' — это среднее всех суточных оценок для данного промежутка времени каждого дня.

Шкала: '''[1]''' — плохая; '''[2]''' — низкая; '''[3]''' — средняя; '''[4]''' — хорошая; '''[5]''' — отличная;

'''Число проверок за день''' <font color=\"red\">''(красный)''</font> показано ниже в масштабе ''1:\$1''.",
	'right-feedback' => 'использование формы отзывов для оценки страниц',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'ratinghistory' => 'História hodnotenia stránky',
	'ratinghistory-leg' => 'Údaje o hodnotení [[:$1|$1]] v čase',
	'ratinghistory-tab' => 'hodnotenie',
	'ratinghistory-link' => 'Hodnotenie stránky',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Ďakujeme, že ste si našli chvíľu na ohodnotenie tejto stránky!</font>''",
	'ratinghistory-period' => 'Časové obdobie:',
	'ratinghistory-month' => 'posledný mesiac',
	'ratinghistory-3months' => 'posledné 3 mesiace',
	'ratinghistory-year' => 'posledný rok',
	'ratinghistory-3years' => 'posledné 3 roky',
	'ratinghistory-ave' => 'Priem: $1',
	'ratinghistory-chart' => 'Hodnotenie čitateľov v čase',
	'ratinghistory-purge' => 'vyčistiť vyrovnávaciu pamäť',
	'ratinghistory-table' => 'Prehľad hodnotení čitateľmi',
	'ratinghistory-users' => 'Používatelia, ktorí ohodnotili stránku',
	'ratinghistory-graph' => '$2 článku „$3” ($1 {{PLURAL:$1|kontrola|kontroly|kontrol}})',
	'readerfeedback-svg' => 'Zobraziť ako SVG',
	'ratinghistory-table-rating' => 'Hodnotenie',
	'ratinghistory-table-votes' => 'Hlasy',
	'ratinghistory-none' => 'Momentálne nie je dostupný dostatok údajov o spätnej väzbe používateľov nato, aby bolo možné vytvoriť grafy.',
	'ratinghistory-legend' => "Dolu je podľa dátumu zobrazené '''denné priemerné hodnotenie''' <font color=\"blue\">''(modrou)''</font> a '''priemer vybraného intervalu''' <font color=\"green\">''(zelenou)''</font>. '''Priemer vybraného intervalu''' je jednoducho priemer denných hodnotení ''v rámci'' tohto časového intervalu za každý deň. Hodnoty hodnotenia sa interpretujú nasledovne:

Mierka: '''[1]''' - Slabé; '''[2]''' - Nízke; '''[3]''' - Dobré; '''[4]''' - Vysoké; '''[5]''' - Výborné;

Na grafe dolu je zobrazený '''počet kontrol za deň''' <font color=\"red\">''(červenou)''</font> v mierke ''1:\$1''.",
	'right-feedback' => 'Stránku ohodnotíte pomocou formulára spätnej väzby',
);

/** Albanian (Shqip)
 * @author Puntori
 */
$messages['sq'] = array(
	'ratinghistory-tab' => 'vlerësimi',
	'ratinghistory-link' => 'Vlerësimi i faqes',
	'ratinghistory-month' => 'muajin e fundit',
	'ratinghistory-3months' => '3 muajt e fundit',
	'ratinghistory-year' => 'vitin e fundit',
	'ratinghistory-3years' => '3 vitet e fundit',
	'ratinghistory-table-rating' => 'Vlerësimi',
	'ratinghistory-table-votes' => 'Votat',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'ratinghistory' => 'Историја оцена стране.',
	'ratinghistory-leg' => 'Историја оцењивања.',
	'ratinghistory-tab' => 'оцена',
	'ratinghistory-period' => 'Раздобље:',
	'ratinghistory-month' => 'последњи месец',
	'ratinghistory-year' => 'последња година',
	'ratinghistory-3years' => 'последње три године',
	'ratinghistory-none' => 'Не постоје доступне оцене читалаца у овом тренутку.',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'ratinghistory' => 'Sidans betygshistorik',
	'ratinghistory-leg' => 'Betygshistorikdata för [[:$1|$1]]',
	'ratinghistory-tab' => 'betyg',
	'ratinghistory-link' => 'Sidrating',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Tack för att du tog dig tid att granska den här sidan!</font>''",
	'ratinghistory-period' => 'Tidsperiod:',
	'ratinghistory-month' => 'senaste månaden',
	'ratinghistory-3months' => 'senaste 3 månader',
	'ratinghistory-year' => 'senaste året',
	'ratinghistory-3years' => 'senaste 3 åren',
	'ratinghistory-ave' => 'Snitt: $1',
	'ratinghistory-chart' => 'Läsarbetyg över tiden',
	'ratinghistory-purge' => 'uppdatera cache',
	'ratinghistory-table' => 'Översyn av läsarbetyg',
	'ratinghistory-users' => 'Användare som gav betyg',
	'ratinghistory-graph' => '$2 av "$3" ($1 {{PLURAL:$1|granskning|granskningar}})',
	'readerfeedback-svg' => 'Visa som SVG',
	'ratinghistory-table-rating' => 'Betyg',
	'ratinghistory-table-votes' => 'Röster',
	'ratinghistory-none' => 'Det finns för närvarande inte tillräckligt med feedbackdata tillgängligt från läsarna för grafer.',
	'ratinghistory-legend' => "'''Dagliga genomsnittsbetyget''' <font color=\"blue\">''(blå)''</font> och '''löpande genomsnittsbetyg''' <font color=\"green\">''(grön)''</font> visas i grafform nedan, efter datum.
Det '''löpande genomsnittsbetyget''' är helt enkelt genomsnittet av alla dagliga betyg ''inom'' denna tidsperiod för varje dag.

Skala: '''[1]''' - Mycket dålig; '''[2]''' - Dålig; '''[3]''' - Okej; '''[4]''' - Bra; '''[5]''' - Mycket bra;

'''Antalet granskningar per dag''' <font color=\"red\">''(röd)''</font> visas på grafen nedan, med skalan ''1:\$1''.",
	'right-feedback' => 'Använd feedback-formuläret för att betygsätta en sida',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'ratinghistory' => 'పేజీ రేటింగు చరిత్ర',
	'ratinghistory-month' => 'గత నెల',
	'ratinghistory-3months' => 'గత 3 నెలలు',
	'ratinghistory-year' => 'గత సంవత్సరం',
	'ratinghistory-3years' => 'గత 3 సంవత్సరాలు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'ratinghistory' => 'Kasaysayan ng pagaantas/pagraranggo ng pahina',
	'ratinghistory-leg' => 'Dato ng pagbibigay ng antas (ranggo) para sa [[:$1|$1]]',
	'ratinghistory-tab' => 'halagang pangkaantasan (ranggo)',
	'ratinghistory-link' => 'Halagang pangkaantasan (ranggo) ng pahina',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Salamat sa pagbibigay mo ng panahon upang suriing muli ang pahinang ito!</font>''",
	'ratinghistory-period' => 'Saklaw na panahon:',
	'ratinghistory-month' => 'nakaraang buwan',
	'ratinghistory-3months' => 'huling 3 mga buwan',
	'ratinghistory-year' => 'nakaraang taon',
	'ratinghistory-3years' => 'huling 3 mga taon',
	'ratinghistory-ave' => 'Karaniwan: $1',
	'ratinghistory-chart' => 'Mga pagaantas ng mambabasa sa paglipas ng panahon',
	'ratinghistory-purge' => 'dalisayin ang nakakubling taguan',
	'ratinghistory-table' => 'Paglalarawan ng mga kaantasang bigay ng mambabasa',
	'ratinghistory-users' => 'Mga tagagamit na nagbigay ng pagaantas',
	'ratinghistory-graph' => '$2 ng "$3" ($1 {{PLURAL:$1|pagsusuri|mga pagsusuri}})',
	'readerfeedback-svg' => 'Tingnan bilang SVG',
	'ratinghistory-table-rating' => 'Kaantasan',
	'ratinghistory-table-votes' => 'Mga boto',
	'ratinghistory-none' => 'Sa ngayon, walang makukuhang sapat na datong pambalik-pahayag para sa mga talangguhit (grap) mula sa mambabasa.',
	'ratinghistory-legend' => "Ang '''pangaraw-araw na pangkaraniwang kaantasan''' <font color=\"blue\">''(bughaw)''</font> at  
'''tumatakbong pangkaraniwang kaantasan''' <font color=\"green\">''(lunti)''</font> ay nakatalangguhit sa ibaba, ayon sa petsa. Ang  
'''tumatakbong pangkaraniwang kaantasan''' ay payak na pinagsamasamang pangkaraniwang halaga ng lahat ng mga pangaraw-araw na kaantasang ''nasa loob'' ng saklaw ng kapanahunang ito para sa bawat araw.

Sukat: '''[1]''' - Walang kuwenta; '''[2]''' - Mababa; '''[3]''' - Patas; '''[4]''' - Mataas; '''[5]''' - Mahusay;

Ang '''bilang ng mga pagsusuri sa bawat araw''' <font color=\"red\">''(pula)''</font> ay ipinapakita sa mga talangguhit sa ibaba, sa isang sukat na ''1:\$1''.",
	'right-feedback' => "Gamitin ang pormularyong pangpagbibigay ng balik-pahayag (''feedback'') upang mabigyan ng kaantasan/halaga ang isang pahina",
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'ratinghistory' => 'Sayfa derecelendirme geçmişi',
	'ratinghistory-leg' => '[[:$1|$1]] için derecelendirme geçmişi verisi',
	'ratinghistory-tab' => 'derecelendirme',
	'ratinghistory-link' => 'Sayfa derecelendirmesi',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Bu sayfayı gözden geçirmek için zamanınızı ayırdığınız için teşekkürler!</font>''",
	'ratinghistory-period' => 'Zaman süreci:',
	'ratinghistory-month' => 'son ay',
	'ratinghistory-3months' => 'son 3 ay',
	'ratinghistory-year' => 'son yıl',
	'ratinghistory-3years' => 'son 3 yıl',
	'ratinghistory-ave' => 'Ort: $1',
	'ratinghistory-chart' => 'Zaman içindeki kullanıcı değerlendirmesi',
	'ratinghistory-purge' => 'önbelleği boşalt',
	'ratinghistory-table' => 'Kullanıcı değerlendirmelerine genel bakış',
	'ratinghistory-users' => 'Derecelendirme veren kullanıcılar',
	'ratinghistory-graph' => '"$3" de $2 ($1 {{PLURAL:$1|gözden geçirme|gözden geçirme}})',
	'readerfeedback-svg' => 'SVG olarak görüntüle',
	'ratinghistory-table-rating' => 'Derecelendirme',
	'ratinghistory-table-votes' => 'Oylar',
	'ratinghistory-none' => 'Grafikler için şuanda yeterince okuyucu dönüt verisi yok.',
	'ratinghistory-legend' => "'''Günlük ortalama derecelendirme''' <font color=\"blue\">''(mavi)''</font> ve
'''Çalışma ortalama derecelendirme''' <font color=\"green\">''(yeşil)''</font> aşağıda tarihe göre çizildi.
'''Çalışma ortalama derecelendirme''', herbir gün için bu zaman dilimi ''içinde'' günlük derecelendirmelerinin ortalamasıdır.

Ölçek: '''[1]''' - Zayıf; '''[2]''' - Düşük; '''[3]''' - Adil; '''[4]''' - Yüksek; '''[5]''' - Mükemmel;

'''Günlük gözden geçirme sayısı''' <font color=\"red\">''(kırmızı)''</font> aşağıdaki grafiklerde gösterilmektedir, ''1:\$1'' ölçeği ile.",
	'right-feedback' => 'Bir sayfayı derecelendirmek için dönüt formunu kullanın',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'ratinghistory' => 'Історія оцінювання сторінки',
	'ratinghistory-leg' => 'Дані про рейтинг сторінки для [[:$1|$1]]',
	'ratinghistory-tab' => 'рейтинг',
	'ratinghistory-link' => 'Рейтинг сторінки',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Дякуємо, що знайшли хвилинку щоб перевірити цю сторінку!</font>''",
	'ratinghistory-period' => 'Період часу:',
	'ratinghistory-month' => 'останній місяць',
	'ratinghistory-3months' => 'останні 3 місяці',
	'ratinghistory-year' => 'останній рік',
	'ratinghistory-3years' => 'останні 3 роки',
	'ratinghistory-ave' => 'Сер: $1',
	'ratinghistory-chart' => 'Оцінки читачів за весь час',
	'ratinghistory-purge' => 'очистити кеш',
	'ratinghistory-table' => 'Огляд оцінок читачів',
	'ratinghistory-users' => 'Оцінювачі',
	'ratinghistory-graph' => '$2 з "$3" ($1 {{PLURAL:$1|перегляд|перегляди|переглядів}})',
	'readerfeedback-svg' => 'Переглянути як SVG',
	'ratinghistory-table-rating' => 'Рейтинг',
	'ratinghistory-table-votes' => 'Голоси',
	'ratinghistory-none' => "Недостатньо даних зворотного зв'язку читачів для графіків на цей час.",
	'ratinghistory-legend' => "'''Середній рейтинг за добу''' <font color=\"blue\">''(синій)''</font> і  
'''середній рейтинг за період''' <font color=\"green\">''(зелений)''</font> показані нижче за датою.
'''Середній рейтинг за період''' — середнє значення всіх добових рейтингів ''за'' період для кожного дня.

Шкала якості: '''[1]''' - Погана; '''[2]''' - Низька; '''[3]''' — Середня; '''[4]''' — Висока; '''[5]''' — Відмінна;

'''Кількість перевірок за добу''' <font color=\"red\">''(червоний)''</font> показана нижче, у масштабі ''1:\$1''.",
	'right-feedback' => "використання форми зворотного зв'язку для оцінювання сторінки",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'ratinghistory' => 'Lịch sử đánh giá trang',
	'ratinghistory-leg' => 'Dữ liệu lịch sử đánh giá của [[:$1|$1]]',
	'ratinghistory-tab' => 'đánh giá',
	'ratinghistory-link' => 'Đánh giá của trang',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Cám ơn đã để dành một chút thời gian để duyệt trang này!</font>''",
	'ratinghistory-period' => 'Thời gian:',
	'ratinghistory-month' => 'tháng trước',
	'ratinghistory-3months' => '3 tháng qua',
	'ratinghistory-year' => 'năm ngoái',
	'ratinghistory-3years' => 'ba năm trước',
	'ratinghistory-chart' => 'Đánh giá của độc giả qua thời gian',
	'ratinghistory-users' => 'Các thành viên đánh giá:',
	'ratinghistory-graph' => '$2 của bài “$3” (theo $1 độc giả)',
	'readerfeedback-svg' => 'Xem bản SVG',
	'ratinghistory-none' => 'Hiện chưa có đủ dữ liệu đánh giá của độc giả để vẽ biểu thị.',
	'ratinghistory-legend' => "Những biểu thị ở dưới trình bày '''đánh giá trung bình hàng ngày''' <font color=\"blue\">''(lam)''</font> và '''đánh giá trung bình đương thời''' <font color=\"green\">''(lục)''</font>, theo thời gian. '''Đánh giá trung bình đương thời''' chỉ là trung bình các đánh giá hàng ngày ''tại giai đoạn này'' vào mỗi ngày.

Giải thích các giá trị: '''[1]''' – Tệ; '''[2]''' – Dở; '''[3]''' – Khá; '''[4]''' – Hay; '''[5]''' – Tuyệt

Những biểu thị cũng trình bày '''số lần đánh giá trong ngày''' <font color=\"red\">''(đỏ)''</font> với tỷ lệ ''1:\$1''.",
	'right-feedback' => 'Đánh giá trang',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'ratinghistory-tab' => '评分',
	'ratinghistory-link' => '页面评分',
	'ratinghistory-period' => '时间段：',
	'ratinghistory-month' => '上月',
	'ratinghistory-3months' => '过去3个月',
	'ratinghistory-year' => '去年',
	'ratinghistory-3years' => '过去3年',
	'ratinghistory-users' => '给出评价的用户',
	'readerfeedback-svg' => '作为SVG浏览',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'ratinghistory-tab' => '評分',
	'ratinghistory-link' => '頁面評分',
	'readerfeedback-svg' => '以SVG檢視',
);

