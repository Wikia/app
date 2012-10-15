<?php
/**
 * Internationalisation file for FlaggedRevs extension, section RatingHistory
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'ratinghistory'         => 'Page rating history',
	'ratinghistory-leg'     => 'Rating history data for [[:$1|$1]]',
	'ratinghistory-tab'     => 'rating',
	'ratinghistory-link'    => 'Page rating',
	'ratinghistory-thanks'  => '\'\'<span style="color:darkred;">Thank you for taking a moment to review this page!</span>\'\'',
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
	'ratinghistory-svg'    => 'View as SVG',
	'ratinghistory-table-rating' => 'Rating',
	'ratinghistory-table-votes'  => 'Votes',
	'ratinghistory-none'    => 'There is not enough reader feedback data available for graphs at this time.',
	'ratinghistory-ratings' => '\'\'\'Legend:\'\'\' \'\'\'(1)\'\'\' - Poor; \'\'\'(2)\'\'\' - Low; \'\'\'(3)\'\'\' - Fair; \'\'\'(4)\'\'\' - High; \'\'\'(5)\'\'\' - Excellent;',
	'ratinghistory-legend'  => 'The \'\'\'daily number of reviews\'\'\' <span style="color:red;">\'\'(red)\'\'</span>, \'\'\'daily average rating\'\'\' <span style="color:blue;">\'\'(blue)\'\'</span>,
	and \'\'\'running average rating\'\'\' <span style="color:green;">\'\'(green)\'\'</span> are graphed below, by date.
	The \'\'\'running average rating\'\'\' is simply the average of all the daily ratings \'\'within\'\' this time frame for each day.
	The ratings are as follows:
	
	\'\'\'(1)\'\'\' - Poor; \'\'\'(2)\'\'\' - Low; \'\'\'(3)\'\'\' - Fair; \'\'\'(4)\'\'\' - High; \'\'\'(5)\'\'\' - Excellent;',
	'ratinghistory-graph-scale' => '\'\'\'Reviews per day\'\'\' <span style="color:red;">\'\'(red)\'\'</span> shown on a \'\'1:$1\'\' scale.',
	'right-feedback' => 'Use the feedback form to rate a page',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Boivie
 * @author Byrial
 * @author EugeneZelenko
 * @author Hamilton Abreu
 * @author Purodha
 * @author Raymond
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'ratinghistory-ave' => 'Average',
	'ratinghistory-graph' => '$2 is a rating category (e.g. {{int:readerfeedback-reliability}}, {{int:readerfeedback-completeness}}, {{int:readerfeedback-npov}}, {{int:readerfeedback-presentation}}, or {{int:readerfeedback-overall}}).


$3 is the page name for the rated page.',
	'ratinghistory-table-rating' => '{{Identical|Rating}}',
	'ratinghistory-ratings' => "Must be consistent with:
*'''(1)''' {{msg-mw|readerfeedback-level-0}}
*'''(2)''' {{msg-mw|readerfeedback-level-1}}
*'''(3)''' {{msg-mw|readerfeedback-level-2}}
*'''(4)''' {{msg-mw|readerfeedback-level-3}}
*'''(5)''' {{msg-mw|readerfeedback-level-4}}
*{{msg-mw|ratinghistory-legend}}",
	'ratinghistory-legend' => "Must be consistent with:
*'''(1)''' {{msg-mw|readerfeedback-level-0}}
*'''(2)''' {{msg-mw|readerfeedback-level-1}}
*'''(3)''' {{msg-mw|readerfeedback-level-2}}
*'''(4)''' {{msg-mw|readerfeedback-level-3}}
*'''(5)''' {{msg-mw|readerfeedback-level-4}}
*{{msg-mw|ratinghistory-ratings}}",
	'right-feedback' => '{{doc-right|feedback}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'ratinghistory' => 'Geskiedenis van bladsygraderings',
	'ratinghistory-leg' => 'Historiese graderingsdata vir [[:$1|$1]]',
	'ratinghistory-tab' => 'gradering',
	'ratinghistory-link' => 'Bladsygradering',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Dankie vir u tyd en moeite om die bladsy te gradeer!</span>''",
	'ratinghistory-period' => 'Tydperk:',
	'ratinghistory-month' => 'afgelope maand',
	'ratinghistory-3months' => 'laaste 3 maande',
	'ratinghistory-year' => 'verlede jaar',
	'ratinghistory-3years' => 'afgelope 3 jaar',
	'ratinghistory-ave' => 'Gemiddeld: $1',
	'ratinghistory-chart' => 'Gradering van lesers oor tyd',
	'ratinghistory-purge' => 'maak kas skoon',
	'ratinghistory-table' => 'Oorsig van lesers se graderings',
	'ratinghistory-users' => 'Gebruikers wat graderings gedoen het',
	'ratinghistory-graph' => '$2 van "$3" ($1 {{PLURAL:$1|gradering|graderings}})',
	'ratinghistory-svg' => 'Wys as SVG',
	'ratinghistory-table-rating' => 'Gradering',
	'ratinghistory-table-votes' => 'Stemme',
	'ratinghistory-none' => "Daar is onvoldoende terugvoer van lesers om 'n grafiek op te trek.",
	'ratinghistory-ratings' => "'''Sleutel:''' '''(1)''' - Swak; '''(2)''' - Laag; '''(3)''' - Redelik; '''(4)''' - Hoog; '''(5)''' - Uitstekend;",
	'ratinghistory-legend' => "Die '''aantal daaglikse graderings''' <span style=\"color:red;\">''(rooi)''</span>, die '''daaglikse gemiddelde gradering''' <span style=\"color:blue;\">''(blou)''</span> en die '''gemiddelde gradering oor die aangegewe periode''' <span style=\"color:green;\">''(groen)''</span> word hieronder in die grafiek volgens datum vertoon.
Die '''gemiddelde gradering oor die aangegewe periode''' is die gemiddelde van alle daaglikse gemiddelde graderings ''binne'' die tydperk vir elke dag.

'''(1)''' - Swak; '''(2)''' - Laag; '''(3)''' - Redelik; '''(4)''' - Hoog; '''(5)''' - Uitstekend;",
	'ratinghistory-graph-scale' => "'''Waarderings per dag''' <span style=\"color:red;\">''(rooi)''</span> word weergegee op die skaal ''1:\$1''.",
	'right-feedback' => "Gebruik die terugvoervorm om 'n bladsy te waardeer",
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">شكرا لك لاستغراقك دقيقة لمراجعة هذه الصفحة!</span>''",
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
	'ratinghistory-svg' => 'عرض كإس في جي',
	'ratinghistory-table-rating' => 'تقييم',
	'ratinghistory-table-votes' => 'أصوات',
	'ratinghistory-none' => 'لا توجد بيانات كافية من القراء متوفرة للرسومات في هذا الوقت.',
	'ratinghistory-ratings' => "'''المفتاح:''' '''(1)''' - فقير; '''(2)''' - منخفض; '''(3)''' - معقول; '''(4)''' - مرتفع; '''(5)''' - ممتاز;",
	'ratinghistory-legend' => "'''عدد المراجعات اليومي''' <span style=\"color:red;\">''(أحمر)''</span>, '''التقييم اليومي المتوسط''' <span style=\"color:blue;\">''(أزرق)''</span>,
و '''التقييم التشغيلي المتوسط''' <span style=\"color:green;\">''(أخضر)''</span> مرسومون بالأسفل، حسب التاريخ.
'''التقييم التشغيلي المتوسط''' هو ببساطة متوسط كل التقييمات اليومية ''في'' هذا الإطار الزمني لكل يوم.
التقييمات هي كالتالي:

'''(1)''' - فقير; '''(2)''' - منخفض; '''(3)''' - معقول; '''(4)''' - مرتفع; '''(5)''' - ممتاز;",
	'ratinghistory-graph-scale' => "'''المراجعات لكل يوم''' <span style=\"color:red;\">''(أحمر)''</span> معروض على مقياس ''1:\$1''.",
	'right-feedback' => 'استخدام استمارة الآراء لتقييم صفحة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'ratinghistory-month' => 'ܝܪܚܐ ܐܚܪܝܐ',
	'ratinghistory-3months' => '3 ܝܪ̈ܚܐ ܐܚܪ̈ܝܐ',
	'ratinghistory-year' => 'ܫܢܬܐ  ܐܚܪܝܬܐ',
	'ratinghistory-3years' => '3 ܫܢܝ̈ܐ  ܐܚܪ̈ܝܬܐ',
	'ratinghistory-table-votes' => 'ܩܠ̈ܐ',
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">شكرا لك لاستغراقك دقيقة لمراجعة هذه الصفحة!</span>''",
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
	'ratinghistory-svg' => 'اعرض SVG',
	'ratinghistory-table-rating' => 'تقييم',
	'ratinghistory-table-votes' => 'الاصوات',
	'ratinghistory-none' => 'لا توجد بيانات كافية من القراء متوفرة للرسومات فى هذا الوقت.',
	'ratinghistory-legend' => "'''عدد المراجعات اليومي''' <span style=\"color:red;\">''(أحمر)''</span>, '''التقييم اليومى المتوسط''' <span style=\"color:blue;\">''(أزرق)''</span>,
و '''التقييم التشغيلى المتوسط''' <span style=\"color:green;\">''(أخضر)''</span> مرسومون بالأسفل، حسب التاريخ.
'''التقييم التشغيلى المتوسط''' هو ببساطة متوسط كل التقييمات اليومية ''في'' هذا الإطار الزمنى لكل يوم.
التقييمات هى كالتالي:

'''(1)''' - فقير; '''(2)''' - منخفض; '''(3)''' - معقول; '''(4)''' - مرتفع; '''(5)''' - ممتاز;",
	'right-feedback' => 'استخدام استمارة الآراء لتقييم صفحة',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'ratinghistory' => 'Historial de calificación de la páxina',
	'ratinghistory-leg' => 'Datos del historial de calificación pa [[:$1|$1]]',
	'ratinghistory-tab' => 'calificación',
	'ratinghistory-link' => 'Calificación de la páxina',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">¡Gracies por tomar un momentu para revisar esta páxina!</span>''",
	'ratinghistory-period' => 'Periodu de tiempu:',
	'ratinghistory-month' => 'caberu mes',
	'ratinghistory-3months' => 'caberos 3 meses',
	'ratinghistory-year' => 'caberu añu',
	'ratinghistory-3years' => 'caberos 3 años',
	'ratinghistory-ave' => 'Media: $1',
	'ratinghistory-chart' => 'Calificaciones de los llectores a lo llargo del tiempu',
	'ratinghistory-purge' => 'purgar cache',
	'ratinghistory-table' => 'Resume de les calificaciones de los llectores',
	'ratinghistory-users' => 'Usuarios que calificaron',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|revisión|revisiones}})',
	'ratinghistory-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Calificación',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Nun hai datos bastantes devueltos polos llectores pa crear gráfiques nesti momentu.',
	'ratinghistory-ratings' => "'''Lleenda:''' '''(1)''' - Probe; '''(2)''' - Baxa; '''(3)''' - Bona; '''(4)''' - Alta; '''(5)''' - Escelente;",
	'ratinghistory-legend' => "El '''númberu de calificaciones diaries''' <span style=\"color:red;\">''(bermeyu)''</span>, la '''calificación media diaria''' <span style=\"color:blue;\">''(azul)''</span> y la '''calificación media actual''' <span style=\"color:green;\">''(verde)''</span> tan na gráfica d'abaxo, por data.
La '''calificación media actual''' ye simplemente la media de toles calificaciones diaries ''dientro'' del periodu horariu de cada día.
Les calificaciones son como sigue:

'''(1)''' - Probe; '''(2)''' - Baxa; '''(3)''' - Bona; '''(4)''' - Alta; '''(5)''' - Escelente;",
	'ratinghistory-graph-scale' => "Les '''revisiones por día''' <span style=\"color:red;\">''(bermeyu)''</span> amosaes a escala ''1:\$1''.",
	'right-feedback' => "Usa'l formulariu de comentarios pa calificar una páxina",
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'ratinghistory-table-votes' => 'Səslər',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'ratinghistory' => 'Битте баһалау тарихы',
	'ratinghistory-leg' => '[[:$1|$1]] битен баһалау тарихы мәғлүмәте',
	'ratinghistory-tab' => 'баһа',
	'ratinghistory-link' => 'Бит баһаһы',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Был битте баһалауға ваҡыт табыуығыҙ өсөн рәхмәт!</span>''",
	'ratinghistory-period' => 'Ваҡыт:',
	'ratinghistory-month' => 'һуңғы ай',
	'ratinghistory-3months' => 'һуңғы 3 ай',
	'ratinghistory-year' => 'һуңғы йыл',
	'ratinghistory-3years' => 'һуңғы 3 йыл',
	'ratinghistory-ave' => 'Уртаса: $1',
	'ratinghistory-chart' => 'Бөтә ваҡыт эсендә уҡыусылар баһаһы',
	'ratinghistory-purge' => 'кэшты таҙартырға',
	'ratinghistory-table' => 'Уҡыусылар баһаһын байҡау',
	'ratinghistory-users' => 'Баһа биргән ҡатнашыусылар',
	'ratinghistory-graph' => '"$3" бите өсөн $2 ($1 {{PLURAL:$1|баһа}})',
	'ratinghistory-svg' => 'SVG итеп күрһәтелһен',
	'ratinghistory-table-rating' => 'Баһа',
	'ratinghistory-table-votes' => 'Тауыштар',
	'ratinghistory-none' => 'Әлеге ваҡытта рәсем төҙөү өсөн етәрлек уҡыусы баһалары йыйылмаған.',
	'ratinghistory-ratings' => "'''Баһалау:''' '''(1)''' — насар; '''(2)''' — түбән; '''(3)''' — уртаса; '''(4)''' — яҡшы; '''(5)''' — бик шәп;",
	'ratinghistory-legend' => "Түбәндә '''көнөнә баһалауҙар һаны''' <span style=\"color:red;\">''(ҡыҙыл)''</span>, '''уртаса көнөнә баһалауҙар һаны''' <span style=\"color:blue;\">''(күк)''</span> һәм
'''хәҙерге уртаса баһа''' <span style=\"color:green;\">''(йәшел)''</span> күрһәтелгән.
'''Хәҙерге уртаса баһа''' — ул бирелгән ваҡыт арауығында һәр көн өсөн бөтә баһалауҙарҙың уртаса һаны. Баһалау:

'''(1)''' — Насар; '''(2)''' — Түбән; '''(3)''' — Уртаса; '''(4)''' — Яҡшы; '''(5)''' — Бик шәп;",
	'ratinghistory-graph-scale' => "'''Көнөнә тикшереүҙәр һаны''' <span style=\"color:red;\">''(ҡыҙыл)''</span> ''1:\$1'' масштабында күрһәтелгән.",
	'right-feedback' => 'Биттәрҙе баһалау өсөн баһалама формаһын ҡулланыу',
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

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'ratinghistory' => 'Гісторыя адзнак старонкі',
	'ratinghistory-leg' => 'Зьвесткі па гісторыі адзнак для [[:$1|$1]]',
	'ratinghistory-tab' => 'адзнака',
	'ratinghistory-link' => 'Адзнака старонкі',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Дзякуй, за тое, што знайшлі час і адзначылі гэту старонку!</span>''",
	'ratinghistory-period' => 'Пэрыяд часу:',
	'ratinghistory-month' => 'апошні месяц',
	'ratinghistory-3months' => 'апошнія 3 месяцы',
	'ratinghistory-year' => 'апошні год',
	'ratinghistory-3years' => 'апошнія 3 гады',
	'ratinghistory-ave' => 'Сярэдняя: $1',
	'ratinghistory-chart' => 'Адзнакі чытачоў за ўвесь час',
	'ratinghistory-purge' => 'ачысьціць кэш',
	'ratinghistory-table' => 'Агляд адзнак чытачоў',
	'ratinghistory-users' => 'Удзельнікі, якія паставілі адзнакі',
	'ratinghistory-graph' => '$2 з «$3» ($1 {{PLURAL:$1|адзнака|адзнакі|адзнак}})',
	'ratinghistory-svg' => 'Паказаць у фармаце SVG',
	'ratinghistory-table-rating' => 'Адзнака',
	'ratinghistory-table-votes' => 'Галасы',
	'ratinghistory-none' => 'У гэты час недастаткова адзнак чытачоў для стварэньня графіка.',
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' — благая; '''(2)''' — нізкая; '''(3)''' — сярэдняя; '''(4)''' — высокая; '''(5)''' — выдатная;",
	'ratinghistory-legend' => "Ніжэй пададзеныя '''колькасьць праверак за дзень''' <span style=\"color:red;\">''(чырвоны)''</span>, '''сярэднесутачная''' <span style=\"color:blue;\">''(блакітны)''</span> і  
'''цяперашняя сярэдняя''' <span style=\"color:green;\">''(зялёны)''</span> адзнакі па датах.
'''Цяперашняя сярэдняя адзнака''' — сярэдняе значэньне ўсіх штодзённых адзнак ''за'' пэрыяд часу кожнага дня.
Выкарыстоўваюцца наступныя адзнакі:

'''(1)''' — благая; '''(2)''' — нізкая; '''(3)''' — сярэдняя; '''(4)''' — высокая; '''(5)''' — выдатная;",
	'ratinghistory-graph-scale' => "'''Колькасьць праверак за дзень''' <span style=\"color:red;\">''(чырвоны)''</span> паказана ў маштабе ''1:\$1''.",
	'right-feedback' => 'Выкарыстоўвайце форму зваротнай сувязі для адзнакі старонкі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Turin
 */
$messages['bg'] = array(
	'ratinghistory' => 'История на оценката на страницата',
	'ratinghistory-leg' => 'Данни за историята на оценката на [[:$1|$1]]',
	'ratinghistory-tab' => 'рейтинг',
	'ratinghistory-link' => 'Оценка на страницата',
	'ratinghistory-period' => 'Период от време:',
	'ratinghistory-month' => 'последния месец',
	'ratinghistory-3months' => 'последни 3 месеца',
	'ratinghistory-year' => 'последната година',
	'ratinghistory-3years' => 'последните 3 години',
	'ratinghistory-ave' => 'Средно: $1',
	'ratinghistory-chart' => 'Читателската оценка през времето',
	'ratinghistory-purge' => 'изчистване на кеш-паметта',
	'ratinghistory-table' => 'Преглед на читателските оценки',
	'ratinghistory-users' => 'Потребители, които са дали оценка',
	'ratinghistory-svg' => 'Преглед като SVG',
	'ratinghistory-table-rating' => 'Оценка',
	'ratinghistory-table-votes' => 'Гласове',
	'ratinghistory-none' => 'В момента няма достатъчно читателска обратна връзка за графиките.',
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' - Много ниска; '''(2)''' - Ниска; '''(3)''' - Средна; '''(4)''' - Висока; '''(5)''' - Отлична;",
	'right-feedback' => 'Използвайте страницата за обратна връзка, за да оцените страница',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'ratinghistory' => 'পাতার রেটিংয়ের ইতিহাস',
	'ratinghistory-tab' => 'রেটিং',
	'ratinghistory-link' => 'পাতার রেটিং',
	'ratinghistory-period' => 'সময়:',
	'ratinghistory-month' => 'গত মাস',
	'ratinghistory-3months' => 'গত ৩ মাস',
	'ratinghistory-year' => 'বিগত বছর',
	'ratinghistory-3years' => 'গত ৩ বছর',
	'ratinghistory-ave' => 'গড়: $1',
	'ratinghistory-svg' => 'SVG হিসেবে দেখাও',
	'ratinghistory-table-rating' => 'রেটিং',
	'ratinghistory-table-votes' => 'ভোট',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'ratinghistory' => 'Istor priziadenn ar bajenn',
	'ratinghistory-leg' => 'Roadennoù istor ar priziadennoù evit [[:$1|$1]]',
	'ratinghistory-tab' => 'istimadur',
	'ratinghistory-link' => 'Priziadenn ar bajenn',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Trugarez da vezañ kemeret amzer da adlenn ar bajenn-mañ !</span>''",
	'ratinghistory-period' => 'Prantad :',
	'ratinghistory-month' => 'miz diwezhañ',
	'ratinghistory-3months' => '3 miz diwezhañ',
	'ratinghistory-year' => 'bloaz tremenet',
	'ratinghistory-3years' => 'tri bloaz diwezhañ',
	'ratinghistory-ave' => 'Keidenn : $1',
	'ratinghistory-chart' => 'Prizadurioù evit al lennerien a-hed an amzer',
	'ratinghistory-purge' => 'riñsañ ar grubuilh',
	'ratinghistory-table' => 'Gwel a-vras eus ar prizadurioù gant al lennerien',
	'ratinghistory-users' => 'Implijerien o deus priziet traoù',
	'ratinghistory-graph' => '$2 war "$3" ($1 {{PLURAL:$1|adweladenn|adweladenn}})',
	'ratinghistory-svg' => 'Gwelet evel SVG',
	'ratinghistory-table-rating' => 'Priziañ',
	'ratinghistory-table-votes' => 'Mouezhioù',
	'ratinghistory-none' => "Evit ar mare n'eus ket trawalc'h a lennerien o reiñ o reiñ o ali evit sevel grafikoù.",
	'ratinghistory-ratings' => "'''Alc'hwez :''' '''(1)''' - Fall ; '''(2)''' - Dister ; '''(3)''' - Etre ; '''(4)''' - Mat ; '''(5)''' - Dreist.",
	'ratinghistory-legend' => "
'''niver a brizadurioù dre zeiz''' <span style=\"color:red;\">''(ruz)''</span>, l’'''priziadur keitat dre zeiz''' <span style=\"color:blue;\">''(glas)''</span> et l’'''priziadur keitat war ober''' <span style=\"color:green;\">''(gwer)''</span> zo diskwelet war ar grafik amañ dindan, dre zeiz.
Keidenn an holl briziadurioù dre zeiz dibabet eo ar’'''priziadur keitat war ober''.
Alc'hwez :

'''(1)''' - Fall; '''(2)''' - Dister; '''(3)''' - Etre; '''(4)''' - Mat; '''(5)''' - Dreist.",
	'ratinghistory-graph-scale' => "'''Prizadurioù dre zeiz''' <span style=\"color:red;\">''(ruz)''</span> diskwelet er skeuliad ''1:\$1''.",
	'right-feedback' => 'Implijout ar furmskrid da reiñ keloù evit priziañ ur bajenn',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'ratinghistory' => 'Historija rejtinga stranice',
	'ratinghistory-leg' => 'Historijski pregled podataka rejtinga za [[:$1|$1]]',
	'ratinghistory-tab' => 'rejting',
	'ratinghistory-link' => 'Rejting stranice',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Hvala Vam što ste našli vremena da pregledate ovu stranicu!</span>''",
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
	'ratinghistory-svg' => 'Pregledaj kao SVG',
	'ratinghistory-table-rating' => 'Rejting',
	'ratinghistory-table-votes' => 'Glasovi',
	'ratinghistory-none' => 'Trenutno nema dovoljno podataka povratne veze čitaoca za prikaz grafikonom.',
	'ratinghistory-ratings' => "'''Objašnjenje:''' '''(1)''' - Slabo; '''(2)''' - Nisko; '''(3)''' - Dobro; '''(4)''' - Visoko; '''(5)''' - Odlično;",
	'ratinghistory-legend' => "'''Broj pregleda po danu''' <span style=\"color:red;\">''(crveno)''</span>, '''dnevni prosječni rejting''' <span style=\"color:blue;\">''(plavo)''</span> i  
'''tekući prosječni rejting''' <span style=\"color:green;\">''(zeleno)''</span> je prikazan na grafikonu ispod, po datumu.
'''Tekući prosječni rejting''' je jednostavni prosjek svih dnevnih rejtinga ''unutar'' ovog vremenskog perioda za svaki dan.

Rejtinzi su slijedeći:

'''[1]''' - Slab; '''[2]''' - Loš; '''[3]''' - Solidan; '''[4]''' - Visok; '''[5]''' - odličan;",
	'ratinghistory-graph-scale' => "'''Provjere po danu''' <span style=\"color:red;\">''(crveno)''</span> prikazano u razmjeri ''1:\$1''.",
	'right-feedback' => 'Korištenje obrasca povratne veze za ocjenjivanje stranice',
);

/** Catalan (Català)
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'ratinghistory-tab' => 'valoració',
	'ratinghistory-link' => 'Valoració de la pàgina',
	'ratinghistory-period' => 'Període de temps:',
	'ratinghistory-month' => 'últim mes',
	'ratinghistory-3months' => 'últims 3 mesos',
	'ratinghistory-year' => 'últim any',
	'ratinghistory-3years' => 'últims 3 anys',
	'ratinghistory-ave' => 'Mit: $1',
	'ratinghistory-table-rating' => 'Valoració',
	'ratinghistory-table-votes' => 'Vots',
	'right-feedback' => 'Utilitzar el formulari de comentaris per a valorar una pàgina',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'ratinghistory-3years' => 'тlяхьаралерачу 3 шарахь',
);

/** Czech (Česky)
 * @author Beren
 * @author Mormegil
 */
$messages['cs'] = array(
	'ratinghistory' => 'Historie hodnocení stránky',
	'ratinghistory-leg' => 'Časový průběh hodnocení stránky [[:$1|$1]]',
	'ratinghistory-tab' => 'hodnocení',
	'ratinghistory-link' => 'Hodnocení stránky',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Děkujeme, že jste {{GENDER:|věnoval|věnovala|věnovali}} čas hodnocení této stránky!</span>''",
	'ratinghistory-period' => 'Období:',
	'ratinghistory-month' => 'poslední měsíc',
	'ratinghistory-3months' => 'poslední 3 měsíce',
	'ratinghistory-year' => 'poslední rok',
	'ratinghistory-3years' => 'poslední 3 roky',
	'ratinghistory-ave' => 'Průměr: $1',
	'ratinghistory-chart' => 'Hodnocení čtenářů v průběhu času',
	'ratinghistory-purge' => 'aktualizovat',
	'ratinghistory-table' => 'Přehled hodnocení čtenáři',
	'ratinghistory-users' => 'Uživatelé, kteří hodnotili',
	'ratinghistory-graph' => '$2 stránky „$3“ ($1 {{PLURAL:$1|hodnocení|hodnocení}})',
	'ratinghistory-svg' => 'Zobrazit jako SVG',
	'ratinghistory-table-rating' => 'Hodnocení',
	'ratinghistory-table-votes' => 'Hlasů',
	'ratinghistory-none' => 'V současné chvíli není pro grafy k dispozici dostatek ohodnocení.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' – Slabé; '''(2)''' – Nízké; '''(3)''' – Dobré; '''(4)''' – Vysoké; '''(5)''' – Vynikající",
	'ratinghistory-legend' => "Následující graf zobrazuje '''počet hodnocení za den''' <span style=\"color:red;\">''(červeně)''</span>, '''průměrné hodnocení daný den''' <span style=\"color:blue;\">''(modře)''</span>
a '''klouzavý průměr hodnocení''' <span style=\"color:green;\">''(zeleně)''</span> podle data.
'''Klouzavý průměr hodnocení''' je jednoduše průměr všech denních hodnocení v rámci příslušného období pro každý den.
Hodnocení jsou:

'''(1)''' – Slabé; '''(2)''' – Nízké; '''(3)''' – Dobré; '''(4)''' – Vysoké; '''(5)''' – Vynikající",
	'ratinghistory-graph-scale' => "'''Počet hodnocení/den''' <span style=\"color:red;\">''(červeně)''</span> zobrazen v měřítku ''1:\$1''.",
	'right-feedback' => 'Hodnocení stránek prostřednictvím formuláře',
);

/** Danish (Dansk)
 * @author Byrial
 */
$messages['da'] = array(
	'ratinghistory' => 'Sidebedømmelseshistorik',
	'ratinghistory-leg' => 'Bedømmelseshistorikdata for [[:$1|$1]]',
	'ratinghistory-tab' => 'bedømmelse',
	'ratinghistory-link' => 'Sidebedømmelse',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Tak fordi at du brugte tid til at bedømme denne side!</span>''",
	'ratinghistory-period' => 'Periode:',
	'ratinghistory-month' => 'Seneste måned',
	'ratinghistory-3months' => 'seneste 3 måneder',
	'ratinghistory-year' => 'seneste år',
	'ratinghistory-3years' => 'seneste 3 år',
	'ratinghistory-ave' => 'Snit: $1',
	'ratinghistory-chart' => 'Læserbedømmelser over tid',
	'ratinghistory-purge' => 'opdatér cache',
	'ratinghistory-table' => 'Oversigt over læserbedømmelser',
	'ratinghistory-users' => 'Brugere som har bedømt siden',
	'ratinghistory-graph' => '$2 af "$3" ($1 {{PLURAL:$1|bedømmelse|bedømmelser}})',
	'ratinghistory-svg' => 'Vis som SVG',
	'ratinghistory-table-rating' => 'Bedømmelse',
	'ratinghistory-table-votes' => 'Stemmer',
	'ratinghistory-none' => 'Der er endnu ikke nok læserbedømmelser til at vise grafer.',
	'ratinghistory-ratings' => "'''Forklaring:''' '''(1)''' - Meget dårlig; '''(2)''' - Dårlig; '''(3)''' - Middel; '''(4)''' - God; '''(5)''' - Meget god;",
	'ratinghistory-legend' => "Det '''daglige antal bedømmelser''' <span style=\"color:red;\">''(rød)''</span>, den '''daglige gennemsnitsbedømmelse''' <span style=\"color:blue;\">''(blå)''</span>
og '''løbende gennemsnitsbedømmelse''' <span style=\"color:green;\">''(grøn)''</span> vises i grafen nedenfor efter dato.
Den '''løbende gennemsnitsbedømmelse''' er simpelthen gennemsnittet af alle de daglige bedømmelser ''inden for'' tidsperioden for hver dag.
Bedømmelserne er:

'''[1]''' - Meget dårlig; '''[2]''' - Dårlig; '''[3]''' - Middel; '''[4]''' - God; '''[5]''' - Meget god;",
	'ratinghistory-graph-scale' => "'''Bedømmelser per dag''' <span style=\"color:red;\">''(rød)''</span> vist i forholdet ''1:\$1''.",
	'right-feedback' => 'Brug tilbagemeldingsformularen til at bedømme en side',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author ChrisiPK
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'ratinghistory' => 'Verlauf der Seitenbewertung',
	'ratinghistory-leg' => 'Verlauf der Seitenbewertung für [[:$1|$1]]',
	'ratinghistory-tab' => 'Bewertung',
	'ratinghistory-link' => 'Seitenbewertung',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Danke, dass du dir für die Bewertung dieser Seite einen Moment Zeit genommen hast!</span>''",
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
	'ratinghistory-svg' => 'Als SVG ansehen',
	'ratinghistory-table-rating' => 'Bewertung',
	'ratinghistory-table-votes' => 'Stimmen',
	'ratinghistory-none' => 'Es gibt noch nicht genug Seitenbewertungen durch Leser, um eine Grafik zu erstellen.',
	'ratinghistory-ratings' => "'''Legende:''' '''(1)''' - {{int:readerfeedback-level-0}}; '''(2)''' - {{int:readerfeedback-level-1}}; '''(3)''' - {{int:readerfeedback-level-2}}; '''(4)''' - {{int:readerfeedback-level-3}}; '''(5)''' - {{int:readerfeedback-level-4}}",
	'ratinghistory-legend' => "Die '''tägliche Zahl an Sichtungen''' <span style=\"color:red;\">''(rot)''</span>, '''Bewertungs-Tagesdurchschnitt''' <span style=\"color:blue;\">''(blau)''</span>
und der '''Durchschnitt über den ausgewählten Zeitraum''' <span style=\"color:green;\">''(grün)''</span> werden nachfolgend nach Datum sortiert angezeigt.
Der '''Durchschnitt im ausgewählten Zeitraum''' ist der Durchschnitt aller Tagesbewertungen ''innerhalb'' dieser Zeitspanne.

Die Bewertung erfolgt nach:
'''(1)''' - {{int:readerfeedback-level-0}}; '''(2)''' - {{int:readerfeedback-level-1}}; '''(3)''' - {{int:readerfeedback-level-2}}; '''(4)''' - {{int:readerfeedback-level-3}}; '''(5)''' - {{int:readerfeedback-level-4}};",
	'ratinghistory-graph-scale' => "Die '''tägliche Zahl an Sichtungen''' <style=\"color:red\">''(rot)''</style> werden im Maßstab ''1:\$1'' angezeigt.",
	'right-feedback' => 'Das Feedback-Formular zur Bewertung einer Seite benutzen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Pill
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Danke, dass Sie sich für die Bewertung dieser Seite einen Moment Zeit genommen haben!</span>''",
);

/** Zazaki (Zazaki)
 * @author Aspar
 */
$messages['diq'] = array(
	'ratinghistory' => 'tarixê derecekerdışê peli',
	'ratinghistory-leg' => 'qey ıney [[:$1|$1]] tarixê datayê derecekerdışi',
	'ratinghistory-tab' => 'derecekerdış',
	'ratinghistory-link' => 'derecekerdışê peli',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">ma zaf tşk keni şıma çımçarna no pel!</span>''",
	'ratinghistory-period' => 'periyodê zemani:',
	'ratinghistory-month' => 'aşma peyin',
	'ratinghistory-3months' => 'hirê aşma peyin',
	'ratinghistory-year' => 'serra peyin',
	'ratinghistory-3years' => 'hirê serra peyin',
	'ratinghistory-ave' => 'Ort: $1',
	'ratinghistory-chart' => 'Zaman içindeki kullanıcı değerlendirmesi',
	'ratinghistory-purge' => 'hafızaya verıni veng ker',
	'ratinghistory-table' => 'Kullanıcı değerlendirmelerine genel bakış',
	'ratinghistory-users' => 'karberê ke derecekerdışi dayi',
	'ratinghistory-graph' => '"$3" de $2 ($1 {{PLURAL:$1|çımçarnayiş|çımçarnayiş}})',
	'ratinghistory-svg' => 'bı SVG ramocın',
	'ratinghistory-table-rating' => 'derecekerdışi',
	'ratinghistory-table-votes' => 'reyî',
	'ratinghistory-none' => 'qey grafiki nıka dataya feedback ê wendoxi çino.',
	'ratinghistory-ratings' => "'''qistas:''' '''(1)''' - zeyif; '''(2)''' - kêm; '''(3)''' - adil; '''(4)''' - berz; '''(5)''' - Mukemmel;",
	'ratinghistory-legend' => "'''bınızdi çımçarnayişê yew roci''' <span style=\"color:red;\">''(sûr)''</span>, '''bınızdî derecekerdışê yew roci''' <span style=\"color:blue;\">''(kewe)''</span>
u '''bınızdi derecekerdışê xebati''' <span style=\"color:green;\">''(kesk/aşıl)''</span> cêr de goreyê tarixi xet bı.
''''''bınızdi derecekerdışê xebati''', istatiskê derecekerdışê qey her yew roci yo.
Derecekerdış zey cêrın o:

'''(1)''' - zayif; '''(2)''' - kêm; '''(3)''' - adil; '''(4)''' - berz; '''(5)''' - mukemmel;",
	'ratinghistory-graph-scale' => "'''çımçarnayişê roceyi''' no qistas de <span style=\"color:red;\">''(sûr)''</span> ''1:\$1'' ramociyeno.",
	'right-feedback' => 'qey derecekerdışê yew peli formê cêrıni bışuxulnê',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'ratinghistory' => 'Stawizny pógódnośenja boka',
	'ratinghistory-leg' => 'Stawizny pógódnośenja za [[:$1|$1]]',
	'ratinghistory-tab' => 'pógódnośenje',
	'ratinghistory-link' => 'Pógódnośenje boka',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Wjeliki źěk, až sy se brał cas, aby pśeglědał toś ten bok!</span>''",
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
	'ratinghistory-svg' => 'Ako SVG zwobrazniś',
	'ratinghistory-table-rating' => 'Pógódnośenje',
	'ratinghistory-table-votes' => 'Głose',
	'ratinghistory-none' => 'Tuchylu njejo dosć pógódnośenjow wót cytarjow, aby napórało grafiku.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojecy; '''(4)''' - Wusoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-legend' => "'''Dnjowna licba pśeglědanjow''' <span style=\"color:red;\">''(cerwjeny)''</span>, '''dnjowne pśerězne gódnośenje''' <span style=\"color:blue;\">''(módry)''</span> a  
'''pśerězne gódnośenje za wubrany cas''' <span style=\"color:green;\">''(zeleny)''</span> zwobraznjuju se dołojce pó datumje. '''Pśerězne gódnośenje za wubrany cas''' jo jadnorje pśerězk wšych dnjownych pógódnośenjow ''w'' toś tom casowem wótrězku kuždego dnja.

Gódnośenja su ako slědujuce:

'''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojecy; '''(4)''' - Wusoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-graph-scale' => "'''Pśeglědanja na źeń''' <span style=\"color:red;\">''(cerwjeny)''</span> pokazujo se w měritku ''1:\$1''.",
	'right-feedback' => 'Wužyj pógódnośeński formular, aby pógódnośił bok',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'ratinghistory' => 'Ιστορικό βαθμολογίας σελίδας',
	'ratinghistory-tab' => 'βαθμολογία',
	'ratinghistory-link' => 'Σελίδα βαθμολογίας',
	'ratinghistory-period' => 'Χρονική περίοδος:',
	'ratinghistory-month' => 'τελευταίος μήνας',
	'ratinghistory-3months' => 'τελευταίοι 3 μήνες',
	'ratinghistory-year' => 'πέρυσι',
	'ratinghistory-3years' => 'τελευταία 3 έτη',
	'ratinghistory-ave' => 'Μ.Ο.: $1',
	'ratinghistory-purge' => 'εκκαθάριση λανθάνουσας μνήμης',
	'ratinghistory-table' => 'Περίληψη των βαθμολογιών των αναγνωστών',
	'ratinghistory-users' => 'Οι χρήστες που έδωσαν βαθμολογίες',
	'ratinghistory-graph' => '$2 από "$3" ($1 {{PLURAL:$1|επιθεώρηση|επιθεωρήσεις}})',
	'ratinghistory-svg' => 'Προβολή ως SVG',
	'ratinghistory-table-rating' => 'Βαθμολογία',
	'ratinghistory-table-votes' => 'Ψηφοφορίες',
	'ratinghistory-ratings' => "'''Λεζάντα:''' '''(1)''' - Κακό; '''(2)''' - Χαμηλό; '''(3)''' - Μέτριο; '''(4)''' - Υψηλό; '''(5)''' - Άριστο·",
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'ratinghistory' => 'Historio de paĝtaksado',
	'ratinghistory-leg' => 'Taksada historio por [[:$1|$1]]',
	'ratinghistory-tab' => 'taksado',
	'ratinghistory-link' => 'Taksado de paĝo',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Dankon pro via peno por kontroli ĉi tiun paĝon!</span>''",
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
	'ratinghistory-svg' => 'Vidi kiel SVG',
	'ratinghistory-table-rating' => 'Takso',
	'ratinghistory-table-votes' => 'Voĉdonoj',
	'ratinghistory-none' => 'Ne sufiĉas datenoj de legintoj por grafeoj ĉi-momente.',
	'ratinghistory-ratings' => "'''Klarigeto:''' '''(1)''' - Malbonega; '''(2)''' - Malbona; '''(3)''' - Mezgrada; '''(4)''' - Bona; '''(5)''' - Bonega;",
	'ratinghistory-legend' => "La '''tage averaĝa taksado''' <span style=\"color:blue;\">''(blua)''</span> kaj 
'''intervalaveraĝa taksado''' <span style=\"color:green;\">''(verda)''</span> estas montrita en la jena grafeo, laŭ dato. La
'''intervalaveraĝa taksado''' estas simiple la averaĝo de ĉiuj tagaj taksaĵoj ''inter'' ĉi tiu tempdaŭro por ĉiu tago.
Jen la taksada skalo:

'''[1]''' - Malbonega; '''[2]''' - Malbonkvalita; '''[3]''' - Mezkvalita; '''[4]''' - Bonkvalita; '''[5]''' - Bonega;",
	'ratinghistory-graph-scale' => "'''Kontroloj por tago''' <span style=\"color:red;\">''(red)''</span> montrata po ''1:\$1'' skalo.",
	'right-feedback' => 'Uzu la kontrolan sekcion por kontroli paĝon',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 */
$messages['es'] = array(
	'ratinghistory' => 'Historial de valoración de página',
	'ratinghistory-leg' => 'Datos de historial de valoración para [[:$1|$1]]',
	'ratinghistory-tab' => 'rating',
	'ratinghistory-link' => 'Valoración de página',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Gracias por tomarte un momento para revisar esta página!</span>''",
	'ratinghistory-period' => 'Periodo de tiempo:',
	'ratinghistory-month' => 'último mes',
	'ratinghistory-3months' => 'últimos 3 meses',
	'ratinghistory-year' => 'último año',
	'ratinghistory-3years' => 'últimos 3 años',
	'ratinghistory-ave' => 'Promedio: $1',
	'ratinghistory-chart' => 'Valoraciones de lectores a través del tiempo',
	'ratinghistory-purge' => 'purgar cache',
	'ratinghistory-table' => 'vista general de valoraciones de los lectores',
	'ratinghistory-users' => 'Usuarios que dieron valoraciones',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|revisión|revisiones}})',
	'ratinghistory-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Rating',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'No hay suficientes datos de retroalimentación de lector disponible para gráficos en este momento.',
	'ratinghistory-ratings' => "'''Nota:''' '''(1)''' - Pobre; '''(2)''' - Bajo; '''(3)''' - Aceptable; '''(4)''' - Alto; '''(5)''' - Excelente;",
	'ratinghistory-legend' => "El '''número de revisiones diarias''' <span style=\"color:red;\">''(rojo)''</span>, '''valoración promedio diaria''' <span style=\"color:blue;\">''(azul)''</span> y
'''valoración promedio de ejecución''' <span style=\"color:green;\">''(verde)''</span> están graficados abajo, por fecha. 
La  '''valoración promedio de ejecución''' es simplemente el promedio de todas las valoraciones diarias ''dentro'' de este marco temporal por cada día.
Las valoraciones son como siguen:

'''(1)''' - Pobre; '''(2)''' - Bajo; '''(3)''' - Regular; '''(4)''' - Alto; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "'''Revisiones por día''' <span style=\"color:red;\">''(rojo)''</span> mostradas en una escala de ''1:\$1''.",
	'right-feedback' => 'Usar el formulario de retroalimentación para valorar una página',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'ratinghistory' => 'Lehekülje hindamise ajalugu',
	'ratinghistory-leg' => 'Lehekülje [[:$1|$1]] hindamisajalugu',
	'ratinghistory-tab' => 'hindamine',
	'ratinghistory-link' => 'Lehekülje hindamine',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Aitäh, et leidsid aega selle lehekülje hindamiseks!</span>''",
	'ratinghistory-period' => 'Ajavahemik:',
	'ratinghistory-month' => 'viimane kuu',
	'ratinghistory-3months' => 'viimased 3 kuud',
	'ratinghistory-year' => 'viimane aasta',
	'ratinghistory-3years' => 'viimased 3 aastat',
	'ratinghistory-ave' => 'Keskmine: $1',
	'ratinghistory-chart' => 'Lugejate antud hinnangud',
	'ratinghistory-purge' => 'tühjenda vahemälu',
	'ratinghistory-table' => 'Lugejahinnangute ülevaade',
	'ratinghistory-users' => 'Hinnanud kasutajad',
	'ratinghistory-graph' => 'Lehekülje "$3" {{lcfirst:$2}} ($1 {{PLURAL:$1|hindamine|hindamist}})',
	'ratinghistory-svg' => 'Näita SVG-vormingus',
	'ratinghistory-table-rating' => 'Hinnang',
	'ratinghistory-table-votes' => 'Hääli',
	'ratinghistory-none' => 'Hetkel pole arvjoonise jaoks piisavalt lugejate tagasisidet.',
	'ratinghistory-ratings' => "'''Legend:''' '''(1)''' – {{int:readerfeedback-level-0}}; '''(2)''' – {{int:readerfeedback-level-1}}; '''(3)''' – {{int:readerfeedback-level-2}}; '''(4)''' – {{int:readerfeedback-level-3}}; '''(5)''' – {{int:readerfeedback-level-4}}",
	'right-feedback' => 'Kasutada lehekülje hindamiseks tagasisidevormi',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'ratinghistory-period' => 'Denbora-tartea:',
	'ratinghistory-month' => 'azken hilabetea',
	'ratinghistory-3months' => 'azken 3 hilabeteak',
	'ratinghistory-year' => 'azken urtea',
	'ratinghistory-3years' => 'azken 3 urteak',
	'ratinghistory-svg' => 'SVG bezala bistaratu',
	'ratinghistory-table-votes' => 'Bozkak',
	'ratinghistory-ratings' => "'''Legend:''' '''(1)''' - Txarra; '''(2)''' - Baxua; '''(3)''' - Bidezkoa; '''(4)''' - Altua; '''(5)''' - Bikaina;",
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Ladsgroup
 * @author Mardetanha
 * @author Momeni
 * @author Wayiran
 */
$messages['fa'] = array(
	'ratinghistory' => 'تاریخچهٔ ارزیابی صفحه',
	'ratinghistory-leg' => '[[:$1|$1]] داده‌های تاریخچهٔ ارزیابی',
	'ratinghistory-tab' => 'نمره',
	'ratinghistory-link' => 'نمرهٔ مقاله',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">از این که فرصتی را صرف بازبینی این صفحه کردید متشکریم!</span>''",
	'ratinghistory-period' => 'بازه زمانی:',
	'ratinghistory-month' => 'ماه پیش',
	'ratinghistory-3months' => '۳ ماه اخیر',
	'ratinghistory-year' => 'سال پیش',
	'ratinghistory-3years' => 'سه سال پیش',
	'ratinghistory-ave' => 'میانگین: $1',
	'ratinghistory-chart' => 'ارزش‌دهی خوانندگان در طول زمان',
	'ratinghistory-purge' => 'خالی‌کردن میانگیر',
	'ratinghistory-table' => 'بررسی اجمالی ارزش‌دهی خوانندگان',
	'ratinghistory-users' => 'کاربرانی که درجه‌بندی کرده‌اند',
	'ratinghistory-graph' => '$3 از $2($1 {{PLURAL:$1|خواننده|خواننده}})',
	'ratinghistory-svg' => 'نمایش به شکل SVG',
	'ratinghistory-table-rating' => 'ارزش‌دهی',
	'ratinghistory-table-votes' => 'آرا',
	'ratinghistory-none' => 'در حال حاضر بازخورد کافی از خوانندگان برای نمایش نمودار وجود ندارد.',
	'ratinghistory-ratings' => "'''شرح:''' '''(1)''' - ضعیف; '''(2)''' - پایین; '''(3)''' - متوسط; '''(4)''' - بالا; '''(5)''' - ممتاز;",
	'ratinghistory-legend' => "'''تعداد روزانهٔ بازبینی‌ها''' <span style=\"color:red;\">''(قرمز)''</span>، '''میانگین امتیازدهی روزانه''' <span style=\"color:blue;\">''(آبی)''</span>، و '''میانگین امتیازدهی جاری''' <span style=\"color:green;\">''(سبز)''</span> در زیر، همراه با تاریخ، گراف شده است.

'''میانگین امتیازدهی جاری''' میانگین همهٔ امتیازدهی‌های روزانه در درون این چارچوبهٔ زمانی برای هر روز است.
امتیازدهی‌ها به شرح زیر می‌باشند:
'''(۱)''' - ضعیف؛ '''(۲)''' - پایین؛ '''(۳)''' - متوسط؛ '''(۴)''' - بالا؛ '''(۵)''' - ممتاز؛",
	'ratinghistory-graph-scale' => "'''بازبینی‌ها در هر روز''' <span style=\"color:red;\">''(قرمز)''</span> در مقیاس''1:\$1'' نمایش داده شده‌اند.",
	'right-feedback' => 'از فرم بازخورد برای نمره دادن به صفحه استفاده کنید',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'ratinghistory' => 'Sivun arvosteluhistoria',
	'ratinghistory-leg' => 'Sivun [[:$1|$1]] arviointihistoria',
	'ratinghistory-tab' => 'arvostelu',
	'ratinghistory-link' => 'Sivun arvostelu',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Kiitos, että tarkistit tämän sivun!</span>''",
	'ratinghistory-period' => 'Aikajakso:',
	'ratinghistory-month' => 'viime kuu',
	'ratinghistory-3months' => 'viimeiset 3 kuukautta',
	'ratinghistory-year' => 'viime vuosi',
	'ratinghistory-3years' => 'viimeiset 3 vuotta',
	'ratinghistory-ave' => 'Keskiarvo: $1',
	'ratinghistory-chart' => 'Lukijoiden arviot tästä sivusta ajan suhteen taulukoituna',
	'ratinghistory-purge' => 'tyhjennä välimuisti',
	'ratinghistory-table' => 'Katsaus lukijoiden arvioinneista',
	'ratinghistory-users' => 'Käyttäjät, jotka esittivät arvionsa',
	'ratinghistory-graph' => 'Sivun $3 $2 ($1 {{PLURAL:$1|arvostelu|arvostelua}})',
	'ratinghistory-svg' => 'Näytä SVG-muodossa',
	'ratinghistory-table-rating' => 'Arvostelu',
	'ratinghistory-table-votes' => 'Äänet',
	'ratinghistory-none' => 'Ei ole tarpeeksi lukijapalautetta, jotta taulukko voitaisiin esittää.',
	'ratinghistory-ratings' => "'''Kuvaaja:''' '''(1)''' – {{int:readerfeedback-level-0}}; '''(2)''' – {{int:readerfeedback-level-1}}; '''(3)''' – {{int:readerfeedback-level-2}}; '''(4)''' – {{int:readerfeedback-level-3}}; '''(5)''' – {{int:readerfeedback-level-4}}",
	'ratinghistory-legend' => "'''Päivittäinen arviointimäärä''' <span style=\"color:red;\">''(punainen)''</span>, '''päivittäinen keskiarvo''' <span style=\"color:blue;\">''(sininen)''</span>
ja '''valitun ajanjakson keskiarvo''' <span style=\"color:green;\">''(vihreä)''</span> on listattu alla päivämäärän mukaan lajiteltuna.
'''Valitun ajanjakson arviointien keskiarvo''' on yksinkertaisesti kaikkien päivittäisten arvioiden keskiarvo tämän aikavälin ''sisällä'' joka päivältä.
Arvioinnit ovat seuraavia:

'''(1)''' – {{int:readerfeedback-level-0}}; '''(2)''' – {{int:readerfeedback-level-1}}; '''(3)''' – {{int:readerfeedback-level-2}}; '''(4)''' – {{int:readerfeedback-level-3}}; '''(5)''' – {{int:readerfeedback-level-4}}",
	'ratinghistory-graph-scale' => "'''Arvioita päivittäin''' <span style=\"color:red;\">''(punainen)''</span> näkyy ''1:\$1''-mittakaavassa.",
	'right-feedback' => 'Käyttää palautelomaketta sivujen arvosteluun',
);

/** French (Français)
 * @author ChrisPtDe
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Zetud
 */
$messages['fr'] = array(
	'ratinghistory' => 'Historique d’évaluation de la page',
	'ratinghistory-leg' => 'Données de l’historique des évaluations pour [[:$1|$1]]',
	'ratinghistory-tab' => 'évaluation',
	'ratinghistory-link' => 'Évaluation de la page',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Merci d’avoir pris le temps de relire cette page !</span>''",
	'ratinghistory-period' => 'Période :',
	'ratinghistory-month' => 'dernier mois',
	'ratinghistory-3months' => '3 derniers mois',
	'ratinghistory-year' => 'dernière année',
	'ratinghistory-3years' => '3 dernières années',
	'ratinghistory-ave' => 'Moyenne : $1',
	'ratinghistory-chart' => 'Évaluations par les lecteurs au cours du temps',
	'ratinghistory-purge' => 'purger le cache',
	'ratinghistory-table' => 'Vue d’ensemble des évaluations par les lecteurs',
	'ratinghistory-users' => 'Utilisateurs qui ont fait des évaluations',
	'ratinghistory-graph' => '$2 sur « $3 » ($1 relecture{{PLURAL:$1||s}})',
	'ratinghistory-svg' => 'Voir en SVG',
	'ratinghistory-table-rating' => 'Évaluation',
	'ratinghistory-table-votes' => 'Votes',
	'ratinghistory-none' => 'Pour l’instant, il n’y a pas suffisamment d’avis exprimés par des lecteurs pour établir des graphiques.',
	'ratinghistory-ratings' => "'''Légende :''' '''(1)''' - Mauvais ; '''(2)''' - Médiocre ; '''(3)''' - Moyen ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-legend' => "Le '''nombre d’évaluations par jour''' <span style=\"color:red;\">''(rouge)''</span>, l’'''évaluation moyenne par jour''' <span style=\"color:blue;\">''(bleu)''</span> et l’'''évaluation moyenne en cours''' <span style=\"color:green;\">''(vert)''</span> sont représentés graphiquement ci-dessous, par date.
L’'''évaluation moyenne en cours''' est simplement la moyenne de toutes les évaluations quotidiennes pour le jour choisi.
Les cotes sont les suivantes :

'''(1)''' - Mauvais ; '''(2)''' - Médiocre ; '''(3)''' - Moyen ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-graph-scale' => "'''Évaluations par jour''' <span style=\"color:red;\">''(rouge)''</span> affichées à l’échelle ''1:\$1''.",
	'right-feedback' => 'Utiliser le formulaire de rétroaction pour évaluer une page',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'ratinghistory' => 'Historico de l’èstimacion de la pâge.',
	'ratinghistory-leg' => 'Balyês de l’historico de les èstimacions por [[:$1|$1]]',
	'ratinghistory-tab' => 'èstimacion',
	'ratinghistory-link' => 'Èstimacion de la pâge',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Grant-marci d’avêr consacrâ de temps por revêre ceta pâge !</span>''",
	'ratinghistory-period' => 'Temps :',
	'ratinghistory-month' => 'mês passâ',
	'ratinghistory-3months' => '3 mês passâs',
	'ratinghistory-year' => 'an passâ',
	'ratinghistory-3years' => '3 ans passâs',
	'ratinghistory-ave' => 'Moyena : $1',
	'ratinghistory-chart' => 'Èstimacions per los liésors pendent lo temps',
	'ratinghistory-purge' => 'purgiér lo cache',
	'ratinghistory-table' => 'Apèrçu de les èstimacions per los liésors',
	'ratinghistory-users' => 'Utilisators qu’ont fêt des èstimacions',
	'ratinghistory-graph' => '$2 sur « $3 » ($1 rèvision{{PLURAL:$1||s}})',
	'ratinghistory-svg' => 'Vêre en SVG',
	'ratinghistory-table-rating' => 'Èstimacion',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Por lo moment, y at pas prod d’avis èxprimâs per des liésors por fâre vêre des diagramos.',
	'ratinghistory-ratings' => "'''Lègenda :''' '''(1)''' - Crouyo ; '''(2)''' - Prod moyen ; '''(3)''' - Moyen ; '''(4)''' - Bon ; '''(5)''' - Famox.",
	'ratinghistory-legend' => "Lo '''nombro de rèvisions per jorn''' <span style=\"color:red;\">''(rojo)''</span>, l’'''èstimacion moyena per jorn''' <span style=\"color:blue;\">''(blu)''</span>
et l’'''èstimacion moyena por lo temps chouèsi''' <span style=\"color:green;\">''(vèrd)''</span> sont reprèsentâs desot fôrma de diagramo ce-desot, per dâta.
L’'''èstimacion moyena por lo temps chouèsi''' est simplament la moyena de totes les èstimacions de tôs los jorns ''dedens'' lo temps chouèsi.
Les èstimacions sont cetes :

'''(1)''' - Crouyo ; '''(2)''' - Prod moyen ; '''(3)''' - Moyen ; '''(4)''' - Bon ; '''(5)''' - Famox.",
	'ratinghistory-graph-scale' => "'''Èstimacions per jorn''' <span style=\"color:red;\">''(rojo)''</span> montrâs a l’èchiéla ''1:\$1''.",
	'right-feedback' => 'Utilisar lo formulèro de retôrn d’enformacions por èstimar una pâge',
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Grazas por revisar esta páxina!</span>''",
	'ratinghistory-period' => 'Período de tempo:',
	'ratinghistory-month' => 'último mes',
	'ratinghistory-3months' => 'últimos 3 meses',
	'ratinghistory-year' => 'último ano',
	'ratinghistory-3years' => 'últimos 3 anos',
	'ratinghistory-ave' => 'Media: $1',
	'ratinghistory-chart' => 'Valoración do lector',
	'ratinghistory-purge' => 'limpar a caché',
	'ratinghistory-table' => 'Vista xeral das valoracións dos lectores',
	'ratinghistory-users' => 'Usuarios que valoraron páxinas',
	'ratinghistory-graph' => '$2 de "$3" ({{PLURAL:$1|unha revisión|$1 revisións}})',
	'ratinghistory-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Valoración',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Arestora non hai suficientes datos das reaccións dos lectores dispoñibles para as gráficas.',
	'ratinghistory-ratings' => "'''Lenda:''' '''(1)''' - Pobre; '''(2)''' - Baixa; '''(3)''' - Boa; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-legend' => "O '''número de revisións ao día''' <span style=\"color:red;\">''(vermello)''</span>, a '''valoración da media diario''' <span style=\"color:blue;\">''(azul)''</span> e a '''valoración da media en curso''' <span style=\"color:green;\">''(verde)''</span> están, por data, na gráfica de embaixo.
A '''valoración da media en curso''' é simplemente a valoración de todas as valoracións diarias ''dentro'' do período de tempo de cada día.
As valoracións son como segue:

'''(1)''' - Pobre; '''(2)''' - Baixa; '''(3)''' - Boa; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "As '''revisións por día''' <span style=\"color:red;\">''(vermello)''</span> móstranse cunha escala de ''1:\$1''.",
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
	'ratinghistory-svg' => 'Ὁρᾶν ὡς SVG',
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Dankschen, ass Du Dir e Momänt Zyt gnuh hesch go die Syte z bewärte!</span>''",
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
	'ratinghistory-svg' => 'As SVG aaluege',
	'ratinghistory-table-rating' => 'Bewärtig',
	'ratinghistory-table-votes' => 'Stimme',
	'ratinghistory-none' => 'S git nonig gnue Sytebewärtige dur Läser zum e Grafik aazlege.',
	'ratinghistory-ratings' => "'''Legänd:''' '''(1)''' - Mangelhaft; '''(2)''' - Längt uus; '''(3)''' - Mittel; '''(4)''' - Guet; '''(5)''' - Exzellänt;",
	'ratinghistory-legend' => "D '''täglig aazahl vu Bewärtige''' <span style=\"color:red;\">''(rot)''</span>, dr '''Durchschnitt vu Bewärtige am Tag''' <span style=\"color:blue;\">''(blau)''</span>,
un dr '''Durchschnitt iber dr usgwehlt Zytruum''' <span style=\"color:green;\">''(grün)''</span> wäre do aazeigt no Datum sortiert.
Dr '''Durchschnitt iber dr usgwehlt Zytruum''' isch eifach dr Durchschnitt vu Bewärtige vu allene täglige Bewärtige ''in'' däm Zytruum fir jede Tag.
Des sin d Bewärtige:

'''[1]''' - isch Mangelhaft; '''[2]''' - Längt uus; '''[3]''' - Goht; '''[4]''' - isch Guet; '''[5]''' - isch Seli guet;",
	'ratinghistory-graph-scale' => "'''Priefige am Tag''' <span style=\"color:red;\">''(red)''</span> uf ere ''1:\$1'' Skala.",
	'right-feedback' => 'E Syte bewärte',
);

/** Hebrew (עברית)
 * @author DoviJ
 * @author Rotemliss
 * @author YaronSh
 * @author דניאל ב.
 */
$messages['he'] = array(
	'ratinghistory' => 'היסטוריית דירוג הדף',
	'ratinghistory-leg' => 'נתוני היסטוריית הדירוג עבור [[:$1|$1]]',
	'ratinghistory-tab' => 'דירוג',
	'ratinghistory-link' => 'דירוג הדף',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">תודה על כך שהקדשתם מזמנכם לבדיקת דף זה!</span>''",
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
	'ratinghistory-svg' => 'הצגה כ־SVG',
	'ratinghistory-table-rating' => 'דירוג',
	'ratinghistory-table-votes' => 'הצבעות',
	'ratinghistory-none' => 'אין כרגע מספיק מידע זמין של משוב קוראים ליצירת תרשימים',
	'ratinghistory-ratings' => "'''מקרא:''' '''(1)''' - גרוע; '''(2)''' - נמוך; '''(3)''' - בינוני; '''(4)''' - גבוה; '''(5)''' - מצוין;",
	'ratinghistory-legend' => "'''המספר היומי של דירוגים''' <span style=\"color:red;\">''(אדום)''</span>, '''ממוצע הדירוגים היומי''' <span style=\"color:blue;\">''(כחול)''</span>,
	ו'''ממוצע הדירוגים לאורך זמן''' <span style=\"color:green;\">''(ירוק)''</span> מוצגים להלן בגרף, לפי תאריך.
	'''ממוצע הדירוגים לאורך זמן''' הוא פשוט הממוצע של כל הדירוגים היומיים ''בתוך'' מסגרת הזמן הזו לכל יום.
	הדירוגים הם כלהלן:
	
	'''(1)''' - גרוע; '''(2)''' - נמוך; '''(3)''' - בינוני; '''(4)''' - גבוה; '''(5)''' - מצוין;",
	'ratinghistory-graph-scale' => "'''סקירות ליום''' <span style=\"color:red;\">''(אדום)''</span> מופיעות ביחס של ''1:\$1''.",
	'right-feedback' => 'השתמשו בטופס המשוב כדי לדרג דף',
);

/** Hindi (हिन्दी)
 * @author Mayur
 * @author Vibhijain
 */
$messages['hi'] = array(
	'ratinghistory' => 'पेज रेटिंग इतिहास',
	'ratinghistory-leg' => 'रेटिंग के लिए इतिहास [[:$1|$1]]',
	'ratinghistory-tab' => 'मूल्यांकन',
	'ratinghistory-link' => 'पृष्ठ रेटिंग',
	'ratinghistory-thanks' => '\'<span style="color:darkred;">इस पृष्ठ की समीक्षा करने के लिए एक पल लेने के लिए धन्यवाद!</span>\'',
	'ratinghistory-period' => 'समय अवधि:',
	'ratinghistory-month' => 'पिछला माह',
	'ratinghistory-3months' => 'पिछले 3 माह',
	'ratinghistory-year' => 'पिछले साल',
	'ratinghistory-3years' => 'पिछले 3 वर्षों',
	'ratinghistory-ave' => 'औसत: $1',
	'ratinghistory-chart' => 'समय के साथ रीडर रेटिंग',
	'ratinghistory-purge' => 'कैशे साफ़ करें',
	'ratinghistory-table' => 'रीडर रेटिंग का ओवरव्यू',
	'ratinghistory-users' => 'वह सदस्य जिन्होनें आकलन किया',
	'ratinghistory-graph' => '$2 of "$3" ($1 {{PLURAL:$1|review|reviews}})',
	'ratinghistory-svg' => 'एसवीजी के रूप में देखें',
	'ratinghistory-table-rating' => 'मूल्यांकन',
	'ratinghistory-table-votes' => 'वोट',
	'ratinghistory-none' => 'इस समय वहाँ पर्याप्त पाठक प्रतिक्रिया डेटा रेखांकन के लिए उपलब्ध नहीं है.',
	'ratinghistory-ratings' => "' ' लेजेंड: ' ' ' '' (1) '' - अनुपयुक्त; ' '' (2) '' - कम; ' '' (3) '' - निष्पक्ष; ' '' (4) '' - उच्च; ' '' (5) '' - उत्कृष्ट;",
	'ratinghistory-legend' => "The '''daily number of reviews''' <span style=\"color:red;\">''(red)''</span>, '''daily average rating''' <span style=\"color:blue;\">''(blue)''</span>,
and '''running average rating''' <span style=\"color:green;\">''(green)''</span> are graphed below, by date.
The '''running average rating''' is simply the average of all the daily ratings ''within'' this time frame for each day.
The ratings are as follows:

'''(1)''' - Poor; '''(2)''' - Low; '''(3)''' - Fair; '''(4)''' - High; '''(5)''' - Excellent;",
	'ratinghistory-graph-scale' => "'''प्रति दिन समीक्षा''' <span style=\"color:red;\">''(लाल)''</span> ''1:\$1'' पैमाने.पर दिखाया",
	'right-feedback' => 'एक पन्ने का मूल्यांकन करने के लिए आकलन फार्म का उपयोग करें',
);

/** Croatian (Hrvatski)
 * @author Roberta F.
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'ratinghistory' => 'Povijest ocjenjivanja stranice',
	'ratinghistory-leg' => 'Povijest ocjena za [[:$1|$1]]',
	'ratinghistory-tab' => 'ocjena',
	'ratinghistory-link' => 'Ocjena stranice',
	'ratinghistory-thanks' => "<span style=\"color:darkred;\">''Hvala vam što ste našli vremena ocijeniti ovu stranicu!''</span>",
	'ratinghistory-period' => 'Razdoblje:',
	'ratinghistory-month' => 'prošli mjesec',
	'ratinghistory-3months' => 'protekla 3 mjeseca',
	'ratinghistory-year' => 'prošla godina',
	'ratinghistory-3years' => 'posljednje 3 godine',
	'ratinghistory-ave' => 'Prosjek: $1',
	'ratinghistory-chart' => 'Ocjene tijekom vremena',
	'ratinghistory-purge' => "očisti spremnik (''cache'')",
	'ratinghistory-table' => 'Pregled ocjena čitatelja',
	'ratinghistory-users' => 'Suradnici koji su ocjenjivali',
	'ratinghistory-graph' => '$2 od "$3" ($1 {{PLURAL:$1|recenzija|recenzije|recenzija}})',
	'ratinghistory-svg' => 'Prikaži kao SVG',
	'ratinghistory-table-rating' => 'Ocjena',
	'ratinghistory-table-votes' => 'Glasovi',
	'ratinghistory-none' => 'Nema dovoljno ocjena za crtanje grafova u ovom trenutku.',
	'ratinghistory-ratings' => "'''Legend:''' '''(1)''' - Loše i nedovoljno; '''(2)''' - Slabo ali dovoljno; '''(3)''' - Dobro; '''(4)''' - Vrlo dobro; '''(5)''' - Izvrsno;",
	'ratinghistory-legend' => "'''Dnevni broj ocjena''' <span style=\"color:red;\">''(crveno)''</span>, '''dnevni prosjek ocjena''' <span style=\"color:blue;\">''(plava)''</span>,
i '''prosječna ocjena <span style=\"color:green;\">''(zeleno)''</span> u nastavku su prikazani grafom, po datumu. 
'''Prosječna ocjena''' je prosjek svih dnevnih ocjene ''unutar'' vremenskog razdoblja za svaki dan. 
Ocjene su kako slijedi: 

'''(1)''' - Loše i nedovoljno; '''(2)''' - Slabo ali dovoljno; '''(3)''' - Dobro; '''(4)''' - Vrlo dobro; '''(5)''' - Izvrsno;",
	'ratinghistory-graph-scale' => "'''Ocjena dnevno''' <span style=\"color:red;\">''(red)''</span> prikazano u ''1:\$1'' mjerilu.",
	'right-feedback' => 'Rabite obrazac kako bi ocijenili stranicu',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'ratinghistory' => 'Stawizny hódnoćenja strony',
	'ratinghistory-leg' => 'Daty stawiznow hódnoćenja za [[:$1|$1]]',
	'ratinghistory-tab' => 'pohódnoćenje',
	'ratinghistory-link' => 'Pohódnoćenje strony',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Dźakujumy so ći, zo sy sej za hódnoćenje tuteje strony čas wzał!</span>''",
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
	'ratinghistory-svg' => 'Jako SVG wobhladać',
	'ratinghistory-table-rating' => 'Pohodnoćenje',
	'ratinghistory-table-votes' => 'Hłosy',
	'ratinghistory-none' => 'Za grafiki hišće dosć pohódnoćenjow wot čitarjow k dispoziciji njesteji',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojacy; '''(4)''' - Wysoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-legend' => "'''Dnjowa ličba pruwowanjow''' <span style=\"color:red;\">''(čerwjeny)''</span>, '''dnjowe přerězne hódnoćenje''' <span style=\"color:blue;\">''(módry)''</span> a '''běžne přerězne hódnoćenje''' <span style=\"color:green;\">''(zeleny)''</span> su deleka po datumje grafisce zwobraznjene.
'''Běžne přerězne hódnoćenje''' je prosće přerězk wšěch dnjowych hódnoćenjow ''znutřka'' tutoho časoweho wotrězka za kóždy dźeń.
Hódnoćenja su kaž tele:


'''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojacy; '''(4)''' - Wysoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-graph-scale' => "'''Pruwowanja na dźeń''' <span style=\"color:red;\">''(čerwjeny)''</span> pokazowane w měritku ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Köszönjük, hogy időt szántál az oldal értékelésére!</span>''",
	'ratinghistory-period' => 'Időszak:',
	'ratinghistory-month' => '1 hónap',
	'ratinghistory-3months' => 'utolsó 3 hónap',
	'ratinghistory-year' => '1 év',
	'ratinghistory-3years' => '3 év',
	'ratinghistory-ave' => 'Átlag: $1',
	'ratinghistory-chart' => 'Olvasói visszajelzések időrendben',
	'ratinghistory-purge' => 'gyorsítótár kiürítése',
	'ratinghistory-table' => 'Olvasói értékelések áttekintése',
	'ratinghistory-users' => 'Szerkesztők, akik értékelték a lapot',
	'ratinghistory-graph' => '$2 a „$3” oldalon ($1 {{PLURAL:$1|értékelés|értékelés}})',
	'ratinghistory-svg' => 'Megtekintés SVG formátumban',
	'ratinghistory-table-rating' => 'Értékelés',
	'ratinghistory-table-votes' => 'Szavazatok',
	'ratinghistory-none' => 'Jelenleg még nem áll rendelkezésre elég visszajelzés a grafikonok elkészítéséhez.',
	'ratinghistory-ratings' => "'''Magyarázat:''' '''[1]''' – rossz; '''[2]''' – gyenge; '''[3]''' – közepes; '''[4]''' – jó; '''[5]''' – kitűnő;",
	'ratinghistory-legend' => "Alább a '''napi értékelések száma ''' <span style=\"color:red;\">''(vörös)''</span>, a '''napi átlagos értékelés''' <span style=\"color:blue;\">''(kék)''</span> és a '''megadott időtartam alatti átlagos értékelés''' <span style=\"color:green;\">''(zöld)''</span> grafikonja látható, dátum szerint. A '''megadott időtartam alatti átlagos értékelés''' egyszerűen az összes napi értékelés átlaga a megadott időtartam '''alatt'''.

Az értékek a következők lehetnek:

'''[1]''' – rossz; '''[2]''' – gyenge; '''[3]''' – közepes; '''[4]''' – jó; '''[5]''' – kitűnő;",
	'ratinghistory-graph-scale' => "'''Visszajelzés / nap ''' <span style=\"color:red;\">''(vörös színnel)''</span> ''1:\$1'' skálán megjelenítve.",
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Gratias pro haber dedicate un momento a evalutar iste pagina!</span>''",
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
	'ratinghistory-svg' => 'Vider como SVG',
	'ratinghistory-table-rating' => 'Evalutation',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Non es disponibile sufficiente datos de evalutationes de lectores pro poter facer graphicos al momento.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Mal; '''(2)''' - Mediocre; '''(3)''' - Acceptabile; '''(4)''' - Bon; '''(5)''' - Excellente;",
	'ratinghistory-legend' => "Le '''numero de recensiones per die''' <span style=\"color:red;\">''(rubie)''</span>, '''evalutation medie per die''' <span style=\"color:blue;\">''(blau)''</span> e
'''evalutation medie currente''' <span style=\"color:green;\">''(verde)''</span> es representate infra, per data. Le  
'''evalutation medie currente''' es simplemente le media de tote le evalutationes per die ''intra'' iste periodo de tempore pro cata die.
Le evalutationes es como seque:

'''(1)''' - Mal; '''(2)''' - Mediocre; '''(3)''' - Acceptabile; '''(4)''' - Bon; '''(5)''' - Excellente;",
	'ratinghistory-graph-scale' => "Le '''numero de recensiones per die''' <span style=\"color:red;\">''(rubie)''</span> es monstrate in scala ''1:\$1''.",
	'right-feedback' => 'Usa le formulario de reaction pro evalutar un pagina',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Rex
 */
$messages['id'] = array(
	'ratinghistory' => 'Sejarah penilaian halaman',
	'ratinghistory-leg' => 'Data sejarah penilaian untuk [[:$1|$1]]',
	'ratinghistory-tab' => 'penilaian',
	'ratinghistory-link' => 'Peringkat halaman',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Terima kasih Anda telah meninjau halaman ini!</span>''",
	'ratinghistory-period' => 'Periode waktu:',
	'ratinghistory-month' => 'bulan lalu',
	'ratinghistory-3months' => '3 bulan terakhir',
	'ratinghistory-year' => 'tahun lalu',
	'ratinghistory-3years' => '3 tahun terakhir',
	'ratinghistory-ave' => 'Rata2: $1',
	'ratinghistory-chart' => 'Peringkat pembaca dari waktu ke waktu',
	'ratinghistory-purge' => 'purgasi kas',
	'ratinghistory-table' => 'Ikhtisar peringkat pengguna',
	'ratinghistory-users' => 'Pengguna yang memberi peringkat',
	'ratinghistory-graph' => '$2 dari "$3" ($1 {{PLURAL:$1|tinjauan|tinjauan}})',
	'ratinghistory-svg' => 'Lihat sebagai SVG',
	'ratinghistory-table-rating' => 'Peringkat',
	'ratinghistory-table-votes' => 'Suara',
	'ratinghistory-none' => 'Belum ada cukup umpan balik pembaca tersedia untuk membuat grafik pada saat ini.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Buruk; '''(2)''' - Rendah; '''(3)''' - Cukup; '''(4)''' - Tinggi; '''(5)''' - Baik sekali;",
	'ratinghistory-legend' => "'''Jumlah tinjauan harian''' <span style=\"color:red;\">''(merah)''</span>, '''Rata-rata peringkat harian''' <span style=\"color:blue;\">''(biru)''</span> dan '''rata-rata peringkat interval''' <span style=\"color:green;\">''(hijau)''</span> ditampilkan dalam grafik di bawah ini, menurut tanggal.

'''Rata-rata peringkat interval''' adalah rata-rata semua peringkat harian ''di antara'' jangka waktu tertentu setiap harinya.

Peringkatnya adalah sebagai berikut: 
'''[1]''' - Buruk; '''[2]''' - Rendah; '''[3]''' - Cukup; '''[4]''' - Tinggi; '''[5]''' - Baik sekali;",
	'ratinghistory-graph-scale' => "'''Tinjauan per hari''' <span style=\"color:red;\">''(merah)''</span> ditunjukkan dengan skala ''1:\$1''.",
	'right-feedback' => 'Gunakan formulir umpan balik untuk memberikan peringkat halaman',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'ratinghistory-period' => 'Ótù ógẹ:',
	'ratinghistory-month' => 'önwa gárá',
	'ratinghistory-3months' => 'önwa 3 nke gáráni',
	'ratinghistory-year' => 'afọr gáráni',
	'ratinghistory-3years' => 'afọr 3 nke gáráni',
	'ratinghistory-table-votes' => 'Votu',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Gianfranco
 * @author Pietrodn
 * @author Una giornata uggiosa '94
 */
$messages['it'] = array(
	'ratinghistory' => 'Cronologia dei giudizi delle pagine',
	'ratinghistory-leg' => 'Dati della cronologia dei giudizi per [[:$1|$1]]',
	'ratinghistory-tab' => 'giudizio',
	'ratinghistory-link' => 'Giudizio pagina',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Grazie per aver dedicato un momento al giudizio di questa pagina!</span>''",
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
	'ratinghistory-svg' => 'Visualizza come SVG',
	'ratinghistory-table-rating' => 'Giudizio',
	'ratinghistory-table-votes' => 'Voti',
	'ratinghistory-none' => 'Non sono disponibile sufficienti dati di feedback dei lettori per poter rappresentare dei grafici al momento.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Insufficiente; '''(2)''' - Mediocre; '''(3)''' - Discreto; '''(4)''' - Buono; '''(5)''' - Ottimo;",
	'ratinghistory-legend' => "Il '''numero giornaliero di valutazioni''' <span style=\"color:red;\">''(rosso)''</span>, il '''giudizio medio giornaliero''' <span style=\"color:blue;\">''(blu)''</span> ed i '''giudizi medi correnti''' <span style=\"color:green;\">''(verde)''</span> sono rappresentati graficamente di seguito, in ordine di data. I '''giudizi medi correnti''' sono semplicemente la media di tutti i giudizi giornalieri ''all'interno'' di questo arco temporale per ciascun giorno.
I giudizi sono i seguenti:

Scala: '''[1]''' - Insufficiente; '''[2]''' - Mediocre; '''[3]''' - Discreto; '''[4]''' - Buono; '''[5]''' - Eccellente;",
	'ratinghistory-graph-scale' => "'''Recensioni per giorno''' <span style=\"color: red\">''(rosso)''</span> mostrate in scala ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">時間を割いて、このページを評価していただきありがとうございます！</span>''",
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
	'ratinghistory-graph' => '「$3」の$2 ($1回の{{PLURAL:$1|評価}})',
	'ratinghistory-svg' => 'SVGとして表示',
	'ratinghistory-table-rating' => '評価',
	'ratinghistory-table-votes' => '票数',
	'ratinghistory-none' => '現時点ではグラフを表示するのに十分な読者評価データがありません。',
	'ratinghistory-ratings' => "'''凡例:''' '''(1)''' - ひどい; '''(2)''' - 低い; '''(3)''' - 可; '''(4)''' - 高い; '''(5)''' - すばらしい;",
	'ratinghistory-legend' => "日ごとの'''日間総評価数''' <span style=\"color:red;\">''(赤)''</span>、'''日間平均評価''' <span style=\"color:blue;\">''(青)''</span> 、'''連続平均評価''' <span style=\"color:green;\">''(緑)''</span> を以下のグラフに表示します。'''連続平均評価'''は、各日のこの時間帯の評価の平均です。
評価の尺度は以下の通りです。

'''[1]''' - {{int:readerfeedback-level-0}}、'''[2]''' - {{int:readerfeedback-level-1}}、'''[3]''' - {{int:readerfeedback-level-2}}、'''[4]''' - {{int:readerfeedback-level-3}}、'''[5]''' - {{int:readerfeedback-level-4}}",
	'ratinghistory-graph-scale' => "'''日あたりの評価数''' <span style=\"color:red;\">''(赤)''</span> を ''1:\$1'' の縮尺で表示しています。",
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

/** Georgian (ქართული)
 * @author BRUTE
 * @author Dawid Deutschland
 * @author ITshnik
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'ratinghistory' => 'გვერდის შეფასების ისტორია',
	'ratinghistory-tab' => 'შეფასება',
	'ratinghistory-link' => 'გვერდის შეფასება',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">გმადლობთ, რომ გამონახეთ დრო ამ გვერდის შესაფასებლად!</span>''",
	'ratinghistory-period' => 'დროის მონაკვეთი:',
	'ratinghistory-month' => 'ბოლო თვე',
	'ratinghistory-3months' => 'ბოლო 3 თვე',
	'ratinghistory-year' => 'ბოლო წელი',
	'ratinghistory-3years' => 'ბოლო 3 წელი',
	'ratinghistory-ave' => 'საშ: $1',
	'ratinghistory-chart' => 'ყველა დროის მკითხველთა შეფასებები',
	'ratinghistory-purge' => 'ქეშის გაწმენდა',
	'ratinghistory-table' => 'მკითხველთა აზრების შეფასება',
	'ratinghistory-users' => 'მომხმარებლები, რომელთაც შეაფასეს',
	'ratinghistory-svg' => 'იხილეთ როგორც SVG',
	'ratinghistory-table-rating' => 'შეფასება:',
	'ratinghistory-table-votes' => 'ხმები',
	'ratinghistory-legend' => "'''შემოწმებების დღიური რაოდენობა''' <span style=\"color:red;\">''(წითელი)''</span>, '''საშუალო დღიური შეფასება''' <span style=\"color:blue;\">''(ლურჯი)''</span>
და '''საშუალო არჩეული დროის მონაკვეთში''' <span style=\"color:green;\">''(მწვანე)''</span> ნაჩვენები იქნება ქრონოლოგიურად.
'''საშუალო  არჩეული დროის მონაკვეთში''' არის ყველა დღიური შეფასების საშუალო გარკვეულ პერიოდში. 

შეფასებები  შემდეგნაირია:
'''(1)''' - ცუდი; '''(2)''' - დამაკმაყოფილებელი; '''(3)''' - საშუალო; '''(4)''' - კარგი; '''(5)''' - საუკეთესო;",
	'ratinghistory-graph-scale' => "'''მიმოხილვები დღეების მიხედვით''' <span style=\"color:red;\">''(red)''</span> ნაჩვენებია ''1:\$1'' სკალაზე.",
	'right-feedback' => 'გამოიყენეთ უკუკავშირის ფორმა გვერდის შესაფასებლად.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'ratinghistory-period' => 'កំលុងពេល:',
	'ratinghistory-month' => 'ខែមុន',
	'ratinghistory-3months' => '៣ ខែ​ចុងក្រោយ',
	'ratinghistory-year' => 'ឆ្នាំមុន',
	'ratinghistory-3years' => '៣ឆ្នាំមុន',
	'ratinghistory-ave' => 'មធ្យម៖ $1',
	'ratinghistory-svg' => 'មើល​ជា SVG',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'ratinghistory' => '문서 평가 내력',
	'ratinghistory-leg' => '[[:$1|$1]] 문서에 대한 평가 내역',
	'ratinghistory-tab' => '평가',
	'ratinghistory-link' => '문서 평가',
	'ratinghistory-thanks' => "'''<span style=\"color:darkred;\">이 문서를 검토해 주셔서 감사합니다!</span>'''",
	'ratinghistory-period' => '기간:',
	'ratinghistory-month' => '지난 1개월',
	'ratinghistory-3months' => '지난 3개월',
	'ratinghistory-year' => '지난 1년',
	'ratinghistory-3years' => '지난 3년',
	'ratinghistory-ave' => '평균: $1',
	'ratinghistory-chart' => '시간에 따른 독자의 평가',
	'ratinghistory-purge' => '캐시 갱신하기',
	'ratinghistory-table' => '독자의 평가에 대한 개요',
	'ratinghistory-users' => '평가에 참여해 주신 사용자',
	'ratinghistory-graph' => '"$3" 문서의 $2 ($1명의 평가)',
	'ratinghistory-svg' => 'SVG로 보기',
	'ratinghistory-table-rating' => '평점',
	'ratinghistory-table-votes' => '투표',
	'ratinghistory-none' => '지금은 그래프를 만들 충분한 독자 평가 데이터가 없습니다.',
	'ratinghistory-ratings' => "'''범례:''' '''(1)''' - 최하, '''(2)''' - 낮음, '''(3)''' - 양호, '''(4)''' - 높음, '''(5)''' - 우수",
	'ratinghistory-legend' => "'''일간 평가 횟수''' <span style=\"color:red;\">''(빨강)''</span>, '''일간 평가 평균''' <span style=\"color:blue;\">''(파랑)''</span>, '''전체 평가 평균''' <span style=\"color:green;\">''(녹색)''</span>이 아래에 그래프로 표현되어 있습니다. '''전체 평가 평균'''은 그래프에 표현된 기간 안의 모든 일간 평가의 평균입니다.
평점은 다음과 같습니다:

'''(1)''' - 최하, '''(2)''' - 낮음, '''(3)''' - 양호, '''(4)''' - 높음, '''(5)''' - 우수",
	'ratinghistory-graph-scale' => "'''일간 평가 횟수'''<span style=\"color:red;\">''(빨강)''</span>는 ''1:\$1''의 비율로 보여지고 있습니다.",
	'right-feedback' => '문서를 평가하는 피드백 양식을 이용',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'ratinghistory' => 'Verlouf vun de Enschäzunge',
	'ratinghistory-leg' => 'Enschäzunge för de Sigg „[[:$1|$1]]“ en der Verjangeheit',
	'ratinghistory-tab' => 'Enschäzung',
	'ratinghistory-link' => 'Enschäzunge',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Ene schöne Dangk un märßie för et Nohkike!</span>''",
	'ratinghistory-period' => 'Der Berett en der Zick:',
	'ratinghistory-month' => 'letzt Mohnd',
	'ratinghistory-3months' => 'letzte drei Mohnd',
	'ratinghistory-year' => 'letz Johr',
	'ratinghistory-3years' => 'letz drei Johre',
	'ratinghistory-ave' => 'Dorschnett: $1',
	'ratinghistory-chart' => 'afjejovve Enschäzunge över di Zick',
	'ratinghistory-purge' => 'Donn der Zwescheshpeisher (der <i lang="en">cache</i>) leddisch maache',
	'ratinghistory-table' => 'Övverbleck övver de Lesser ier Enschäzunge',
	'ratinghistory-users' => 'Metmaacher, di Enschäzunge afjejovve udder Note för Sigge verdeilt han',
	'ratinghistory-graph' => '$2 vun „$3“ ({{PLURAL:$1|ein Enschäzung|$1 Enschäzunge|kein Enschäzung}})',
	'ratinghistory-svg' => 'Als en <code>SVG</code>-Dattei aanloore',
	'ratinghistory-table-rating' => 'Enschäzung',
	'ratinghistory-table-votes' => 'Shtemme',
	'ratinghistory-none' => 'Schad, mer han nit jenooch Enschäzunge vun de Metmaacher krääje, öm fö di Zick heh e Belldsche maache ze künne.',
	'ratinghistory-ratings' => "'''Lejend:''' fun de Enschäzunge: '''(1)''' = {{int:readerfeedback-level-0}}, '''(2)''' = {{int:readerfeedback-level-1}}, '''(3)''' = {{int:readerfeedback-level-2}}, '''(4)''' = {{int:readerfeedback-level-3}}, '''(5)''' = {{int:readerfeedback-level-4}}.",
	'ratinghistory-legend' => "Dä '''dääschlesche Dorschnett vun de Enschäzunge''' <span style=\"color:red;\">''(en ruhd)''</span> un dä 
'''loufende Dorschnett vun de Enschäzunge''' <span style=\"color:blue;\">''(en blou)''</span> sin unge opjemohlt, pro Dattum. Dä '''loufende Dorschnett''' es eijfach dä Dorschnett fun all dä dääschlesche Enschäzunge ''ennerhallef'' fun däm Zick_Afschnet för jeede Daach.

Lejend fun de Enschäzunge: '''(1)''' = {{int:readerfeedback-level-0}}, '''(2)''' = {{int:readerfeedback-level-1}}, '''(3)''' = {{int:readerfeedback-level-2}}, '''(4)''' = {{int:readerfeedback-level-3}}, '''(5)''' = {{int:readerfeedback-level-4}}.",
	'ratinghistory-graph-scale' => "'''Enschätzunge der Daach''', <style=\"color:red\">''(rud)''</style> aanjezeisch em Maaßschtaab ''1 zoh \$1''.",
	'right-feedback' => 'Enschäzunge afjevve un Note för Sigge verdeile',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'ratinghistory-month' => 'meha dawî',
	'ratinghistory-year' => 'sala dawî',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'ratinghistory' => 'Entwécklung vun der Bewäertung vun der Säit',
	'ratinghistory-leg' => 'Entwécklung vun der Bewäertung vun [[:$1|$1]] am Laf vun der Zäit',
	'ratinghistory-tab' => 'Bewäertung',
	'ratinghistory-link' => 'Bewäertung vun der Säit',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Merci datt Dir Iech en Ament Zäit huelt fir dës Säit nozekucken!</span>''",
	'ratinghistory-period' => 'Zäitraum:',
	'ratinghistory-month' => 'leschte Mount',
	'ratinghistory-3months' => 'lescht 3 Méint',
	'ratinghistory-year' => 'lescht Joer',
	'ratinghistory-3years' => 'lescht 3 Joer',
	'ratinghistory-ave' => 'Duerchschnëtt: $1',
	'ratinghistory-chart' => 'Bewäertunge vun de Lieser am Laf vun der Zäit',
	'ratinghistory-purge' => 'Tëschespäicher (Cache) eidelmaachen',
	'ratinghistory-table' => 'Iwwerbléck vun de Bewäertunge vu Lieser',
	'ratinghistory-users' => 'Benotzer, déi bewert hunn',
	'ratinghistory-graph' => '$2 vun "$3" ($1 {{PLURAL:$1|Bewäertung|Bewäertungen}})',
	'ratinghistory-svg' => 'Als SVG kucken',
	'ratinghistory-table-rating' => 'Bewäertung',
	'ratinghistory-table-votes' => 'Stëmmen',
	'ratinghistory-none' => 'Et gëtt zu dësem Zäitpunkt net genuch Bewäertunge vu Lieser fir eng Grafik opzestellen.',
	'ratinghistory-ratings' => "'''Skala:''' '''[1]''' - Aarmséileg; '''[2]''' - Niddreg; '''[3]''' - An der Rei; '''[4]''' - Héich; '''[5]''' - Exzellent;",
	'ratinghistory-legend' => "D''''Deeglech Zuel vun de Bewäertungen''' <span style=\"color:red;\">''(rout)''</span>, '''Duerchschnëtt vun der deeglecher Bewäertung''' <span style=\"color:blue;\">''(blo)''</span> 
an de '''momentanen Duerchschnëtt vun der Bewäertung''' <span style=\"color:green;\">''(gréng)''</span> sinn ënnendrënner grafesch pro Dag duergestallt.
De '''momentanen Duerchschnëtt vun der Bewäertung''' ass einfach den Duerchschnëtt vun allen deegleche Bewäertunge ''bannent'' dësem Zäitraum fir all Dag.

D'Bewäertung gouf esu gemaach:

'''[1]''' - Aarmséileg; '''[2]''' - Niddreg; '''[3]''' - An der Rei; '''[4]''' - Héich; '''[5]''' - Exzellent;",
	'ratinghistory-graph-scale' => "D''''Zuel vun de Bewäertunge pro Dag''' <span style=\"color:red;\">''(rout)''</span> gëtt an der Grafik ënnendrënner op enger ''1:\$1'' Skala gewisen.",
	'right-feedback' => 'De Feedback-Formulaire benotze fir eng Säit ze bewerten',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'ratinghistory' => 'Geschiedenis paginawaardering',
	'ratinghistory-leg' => 'Historische waarderingsgegaeves voor [[:$1|$1]]',
	'ratinghistory-tab' => 'waardering',
	'ratinghistory-link' => 'Paginawaardering',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Danke veure muite die se dich genomme haes dees paasj te waardere!</span>''",
	'ratinghistory-period' => 'Tiedsperiode:',
	'ratinghistory-month' => 'lèste maondj',
	'ratinghistory-3months' => 'lèste 3 maondj',
	'ratinghistory-year' => 'aafgeloupe jaor',
	'ratinghistory-3years' => 'aafgeloupe 3 jaor',
	'ratinghistory-ave' => 'Gemiddeld: $1',
	'ratinghistory-chart' => 'Laezerswaardering doren tied',
	'ratinghistory-purge' => 'laeg cache',
	'ratinghistory-table' => 'Euverzich van laezerswarderinge',
	'ratinghistory-users' => "Gebroekers die 'n waardering höbbe gegaeve",
	'ratinghistory-graph' => '$2 van "$3" ($1 {{PLURAL:$1|waardering|waarderinge}})',
	'ratinghistory-svg' => 'Bekiek es SVG',
	'ratinghistory-table-rating' => 'Waardering',
	'ratinghistory-table-votes' => 'Stömme',
	'ratinghistory-none' => "Neet zat feedback veur 'n grafiek te make.",
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Wórd; '''(2)''' - Lieëg; '''(3)''' - Good; '''(4)''' - Hoeag; '''(5)''' - Perfèk;",
	'ratinghistory-legend' => "'t '''Aantal dagelikse beoordeilinge''' <span style=\"color:red;\">''(rood)''</span>, de '''dagelikse gemiddelde waardering''' <span style=\"color:blue;\">''(blauw)''</span> en
de '''gemiddelde waardering van de aangegaeve periode''' <span style=\"color:green;\">''(groen)''</span> steit hieonger in 'ne grafiek op datum.
De '''gemiddelde waardering van de aangegaeve periode''' is 't gemiddelde van alle dagelikse gemiddelde waarderinge ''binne'' dit tiedvak veur ederen daag.

'''(1)''' - Wórd; '''(2)''' - Lieëg; '''(3)''' - Good; '''(4)''' - Hoeag; '''(5)''' - Perfèk;",
	'ratinghistory-graph-scale' => "'''Beoerdeilingen per daag''' <span style=\"color:red;\">''(roed)''</span> waere waergegaeve op de sjaol ''1:\$1''.",
	'right-feedback' => 'Gebroek feedback veur paginawaardering',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'ratinghistory' => 'Puslapio vertinimų istoriją',
	'ratinghistory-tab' => 'reitingas',
	'ratinghistory-link' => 'Puslapio reitingas',
	'ratinghistory-period' => 'Laikotarpis:',
	'ratinghistory-month' => 'Praeitas mėnuo',
	'ratinghistory-3months' => 'Praeiti 3 mėnesiai',
	'ratinghistory-year' => 'pernai',
	'ratinghistory-3years' => 'pastaruosius 3 metus',
	'ratinghistory-ave' => 'Vid: $1',
	'ratinghistory-users' => 'Vartotojai, kurie davė vertinimus',
	'ratinghistory-svg' => 'Žiūrėti kaip SVG',
	'ratinghistory-table-rating' => 'Reitingas',
	'ratinghistory-table-votes' => 'Balsai',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Prastas; '''(2)''' - Žemas; '''(3)''' - Geras; '''(4)''' - Aukštas; '''(5)''' - Puikus;",
);

/** Latvian (Latviešu)
 * @author Papuass
 */
$messages['lv'] = array(
	'ratinghistory-period' => 'Laika periods:',
	'ratinghistory-month' => 'pēdējais mēnesis',
	'ratinghistory-3months' => 'pēdējie 3 mēneši',
	'ratinghistory-year' => 'pēdējais gads',
	'ratinghistory-3years' => 'pēdējie 3 gadi',
	'ratinghistory-ave' => 'Vidēji: $1',
	'ratinghistory-chart' => 'Lasītāju vērtējumi laika gaitā',
	'ratinghistory-table' => 'Lasītāju vērtējumu pārskats',
	'ratinghistory-svg' => 'Skatīt kā SVG',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'ratinghistory' => 'Историја на оценување на страница',
	'ratinghistory-leg' => 'Податоци за историјата на оценување за [[:$1|$1]]',
	'ratinghistory-tab' => 'оценка',
	'ratinghistory-link' => 'Оценка на страница',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Благодариме за вашето одвоено време за оценување на оваа страница!</span>''",
	'ratinghistory-period' => 'Временски период:',
	'ratinghistory-month' => 'последен месец',
	'ratinghistory-3months' => 'последни 3 месеци',
	'ratinghistory-year' => 'последна година',
	'ratinghistory-3years' => 'последни 3 години',
	'ratinghistory-ave' => 'Просеч: $1',
	'ratinghistory-chart' => 'Оценки од читателите низ времето',
	'ratinghistory-purge' => 'исчисти кеш',
	'ratinghistory-table' => 'Преглед на оценки од читателите',
	'ratinghistory-users' => 'Корисници кои дале оценки',
	'ratinghistory-graph' => '$2 од "$3" ($1 {{PLURAL:$1|оценка|оценки}})',
	'ratinghistory-svg' => 'Преглед како SVG',
	'ratinghistory-table-rating' => 'Оценка',
	'ratinghistory-table-votes' => 'Гласови',
	'ratinghistory-none' => 'Нема доволно податоци од оценувачите за исцртување на графиконот во овој момент.',
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' - Слабо; '''(2)''' - Ниско; '''(3)''' - Средно; '''(4)''' - Високо; '''(5)''' - Одлично;",
	'ratinghistory-legend' => "'''Дневниот број на оценки''' <span style=\"color:red;\">''(црвено)''</span>, '''просечна дневна оценка''' <span style=\"color:blue;\">''(сино)''</span>,
и '''тековна просечна оценка''' <span style=\"color:green;\">''(green)''</span> се прикажани на графикот подолу, по датум.
'''Тековна просечна оценка''' е прост просек од сите дневни оценки ''во рамките на'' овој временски период за секој ден.
Еве ги оценките:

'''(1)''' - Слабо; '''(2)''' - Ниско; '''(3)''' - Средно; '''(4)''' - Високо; '''(5)''' - Одлично;",
	'ratinghistory-graph-scale' => "'''Бројот на оценки за еден ден''' <span style=\"color:red;\">''(црвено)''</span> е прикажан во размер ''1:\$1''.",
	'right-feedback' => 'Користете го образецот за повратни информации за да оцените страница',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'ratinghistory' => 'താളിന്റെ നിലവാരമളക്കലിന്റെ നാൾവഴി',
	'ratinghistory-leg' => '[[:$1|$1]] താളിലെ വിവരങ്ങൾക്ക് നൽകിയ നിലവാര മതിപ്പിന്റെ ചരിത്രം',
	'ratinghistory-tab' => 'നിലവാരമളക്കൽ',
	'ratinghistory-link' => 'താളിന്റെ നിലവാരം',
	'ratinghistory-thanks' => '<span style="color:darkred;">ഈ താൾ സംശോധനം ചെയ്യുവാൻ സമയം കണ്ടെത്തിയതിനു നന്ദി!</span>',
	'ratinghistory-period' => 'കാലയളവ്:',
	'ratinghistory-month' => 'കഴിഞ്ഞ മാസം',
	'ratinghistory-3months' => 'കഴിഞ്ഞ 3 മാസം',
	'ratinghistory-year' => 'കഴിഞ്ഞ വർഷം',
	'ratinghistory-3years' => 'കഴിഞ്ഞ 3 വർഷം',
	'ratinghistory-ave' => 'ശരാശരി: $1',
	'ratinghistory-chart' => 'സമയാസമയങ്ങളിൽ വായനക്കാർ നൽകുന്ന നിലവാരമിടൽ',
	'ratinghistory-purge' => 'കാഷെ ശുദ്ധമാക്കുക',
	'ratinghistory-table' => 'വായനക്കാർ നൽകിയ മതിപ്പ് നിലവാരത്തിന്റെ പൊതു അവലോകനം',
	'ratinghistory-users' => 'നിലവാരമിട്ട ഉപയോക്താക്കൾ',
	'ratinghistory-graph' => '$2 ഗണത്തിലെ "$3" ({{PLURAL:$1|ഒരു സംശോധനം|$1 സംശോധനങ്ങൾ}})',
	'ratinghistory-svg' => 'എസ്.വി.ജി. ആയി പ്രദർശിപ്പിക്കുക',
	'ratinghistory-table-rating' => 'നിലവാരം കണ്ടെത്തൽ',
	'ratinghistory-table-votes' => 'വോട്ടുകൾ',
	'ratinghistory-none' => 'ഒരു ഗ്രാഫ് വരയ്ക്കാനാവശ്യമായത്ര വിവരങ്ങൾ ഇപ്പോൾ വായനക്കാരുടെ പക്കൽ നിന്ന് ലഭിച്ചിട്ടില്ല.',
	'ratinghistory-ratings' => "'''സൂചന:''' '''(1)''' - ദരിദ്രം; '''(2)''' - മോശം; '''(3)''' - കൊള്ളാം; '''(4)''' - ഉന്നതം; '''(5)''' - ഒന്നാന്തരം;",
	'ratinghistory-legend' => "'''ദിവസേനയുള്ള സംശോധനങ്ങളുടെ എണ്ണം''' <span style=\"color:red;\">''(ചുവപ്പ്)''</span>, '''ദിവസേനയുള്ള ശരാശരി മതിപ്പ്''' <span style=\"color:blue;\">''(നീല)''</span>,
'''ഇപ്പോഴുള്ള ശരാശരി മതിപ്പ്''' <span style=\"color:green;\">''(പച്ച)''</span> എന്നിവ തീയതിയനുസരിച്ച് താഴെ കൊടുത്തിരിക്കുന്നു.
'''ഇപ്പോഴുള്ള ശരാശരി മതിപ്പ്''' എന്നത് ദിവസംപ്രതി ''ഈ സമയത്തുള്ള'' നിലവാരമതിപ്പിന്റെ ശരാശരിയാണ്.
നിലവാര മതിപ്പുകൾ താഴെ കൊടുക്കുന്നു:

'''(1)''' - ദരിദ്രം; '''(2)''' - മോശം; '''(3)''' - കൊള്ളാം; '''(4)''' - ഉന്നതം; '''(5)''' - ഒന്നാന്തരം;",
	'ratinghistory-graph-scale' => "'''ദിവസവുമുള്ള സംശോധനങ്ങൾ''' <span style=\"color:red;\">''(ചുവപ്പ്)''</span> ''1:\$1'' തോതിൽ കാട്ടുന്നു.",
	'right-feedback' => 'താളിനു നിലവാരമിടാനായി അഭിപ്രായമറിയിക്കാനുള്ള ഫോം ഉപയോഗിക്കുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'ratinghistory' => 'Sejarah penilaian laman',
	'ratinghistory-leg' => 'Data sejarah penilaian untuk [[:$1|$1]]',
	'ratinghistory-tab' => 'penilaian',
	'ratinghistory-link' => 'Penilaian laman',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Terima kasih kerana sudi meluangkan masa untuk memeriksa laman ini!</span>''",
	'ratinghistory-period' => 'Tempoh masa:',
	'ratinghistory-month' => 'bulan lepas',
	'ratinghistory-3months' => '3 bulan lepas',
	'ratinghistory-year' => 'tahun lepas',
	'ratinghistory-3years' => '3 tahun lepas',
	'ratinghistory-ave' => 'Purata: $1',
	'ratinghistory-chart' => 'Penilaian oleh pembaca sepanjang masa',
	'ratinghistory-purge' => 'kosongkan cache',
	'ratinghistory-table' => 'Gambaran keseluruhan penilaian oleh pembaca',
	'ratinghistory-users' => 'Pengguna yang memberikan penilaian',
	'ratinghistory-graph' => '$2 "$3" ($1 ulasan)',
	'ratinghistory-svg' => 'Lihat dalam bentuk SVG',
	'ratinghistory-table-rating' => 'Penilaian',
	'ratinghistory-table-votes' => 'Undian',
	'ratinghistory-none' => 'Data maklum balas pembaca belum cukup untuk penghasilan graf.',
	'ratinghistory-ratings' => "'''Petunjuk:''' '''(1)''' - Lemah; '''(2)''' - Rendah; '''(3)''' - Sederhana; '''(4)''' - Tinggi; '''(5)''' - Cemerlang;",
	'ratinghistory-legend' => "'''Jumlah ulasan harian''' <span style=\"color:red;\">''(merah)''</span>, '''purata penilaian harian''' <span style=\"color:blue;\">''(biru)''</span>,
	dan '''purata penilaian berturut-turut''' <span style=\"color:green;\">''(hijau)''</span> digrafkan di bawah, mengikut tarikh.
	'''Purata penilaian berturut-turut''' ialah purata bagi semua penilaian harian ''di dalam'' rangka masa ini untuk setiap hari.
	Penilaiannya adalah seperti berikut:
	
	'''(1)''' - Lemah; '''(2)''' - Rendah; '''(3)''' - Sederhana; '''(4)''' - Tinggi; '''(5)''' - Cemerlang;",
	'ratinghistory-graph-scale' => "'''Ulasan sehari''' <span style=\"color:red;\">''(red)''</span> ditunjukkan pada skala ''1:\$1''.",
	'right-feedback' => 'Menggunakan borang maklum balas untuk menilai laman',
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
	'ratinghistory-svg' => 'Tiquittāz quemeh SVG',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'ratinghistory' => 'Sidens vurderingshistorikk',
	'ratinghistory-leg' => 'Vurderingshistorikkdata for [[:$1|$1]]',
	'ratinghistory-tab' => 'vurdering',
	'ratinghistory-link' => 'Sidevurdering',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Takk for at du tar deg tid til å anmelde denne siden!</span>''",
	'ratinghistory-period' => 'Tidsperiode:',
	'ratinghistory-month' => 'siste måned',
	'ratinghistory-3months' => 'siste 3 måneder',
	'ratinghistory-year' => 'siste år',
	'ratinghistory-3years' => 'siste tre år',
	'ratinghistory-ave' => 'Snitt: $1',
	'ratinghistory-chart' => 'Leservurderinger over tid',
	'ratinghistory-purge' => 'oppdater mellomlager',
	'ratinghistory-table' => 'Oversikt over leservurderinger',
	'ratinghistory-users' => 'Brukere som vurderte siden',
	'ratinghistory-graph' => '$2 av «$3» ({{PLURAL:$1|én vurdering|$1 vurderinger}})',
	'ratinghistory-svg' => 'Vis som SVG',
	'ratinghistory-table-rating' => 'Vurdering',
	'ratinghistory-table-votes' => 'Stemmer',
	'ratinghistory-none' => 'Det er ikke nok leservurderinger til å vise grafer ennå.',
	'ratinghistory-ratings' => "'''Forklaring:''' '''(1)''' – dårlig; '''(2)''' – lav; '''(3)''' – middels; '''(4)''' – høy; '''(5)''' – meget god;",
	'ratinghistory-legend' => "Det '''daglige antall vurderinger''' <span style=\"color:red;\">''(rød)''</span>, den '''daglige gjennomsnittsvurderingen''' <span style=\"color:blue;\">''(blå)''</span> og '''løpende gjennomsnittsvurdering''' <span style=\"color:green;\">''(grønn)''</span> vises i grafen under etter dato.
Den '''løpende gjennomsnittsvurderingen''' er rett og slett gjennomsnittet av all de daglige vurderingene ''innen'' denne tidsperioden for hver dag.
Vurderingene er som følger:

'''[1]''' - Veldig dårlig; '''[2]''' - Dårlig; '''[3]''' - OK; '''[4]''' - Bra; '''[5]''' - Veldig bra;",
	'ratinghistory-graph-scale' => "'''Vurderinger per dag''' <span style=\"color:red;\">''(rød)''</span> vist i forholdet ''1:\$1''.",
	'right-feedback' => 'Bruke tilbakemeldingsskjemaet for å vurdere en side',
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Dank u wel voor de moeite die u hebt genomen om deze pagina te waarderen!</span>''",
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
	'ratinghistory-svg' => 'Als SVG bekijken',
	'ratinghistory-table-rating' => 'Waardering',
	'ratinghistory-table-votes' => 'Stemmen',
	'ratinghistory-none' => 'Er is onvoldoende terugkoppeling van lezers aanwezig om een grafiek te maken.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Slecht; '''(2)''' - Laag; '''(3)''' - Redelijk; '''(4)''' - Hoog; '''(5)''' - Uitstekend;",
	'ratinghistory-legend' => "Het '''aantal dagelijkse beoordelingen''' <span style=\"color:red;\">''(rood)''</span>, de '''dagelijkse gemiddelde waardering''' <span style=\"color:blue;\">''(blauw)''</span> en
de '''gemiddelde waardering van de aangegeven periode''' <span style=\"color:green;\">''(groen)''</span> staan hieronder in een grafiek op datum.
De '''gemiddelde waardering van de aangegeven periode''' is het gemiddelde van alle dagelijkse gemiddelde waarderingen ''binnnen'' dit tijdvak voor iedere dag.

'''(1)''' - Slecht; '''(2)''' - Laag; '''(3)''' - Redelijk; '''(4)''' - Hoog; '''(5)''' - Uitstekend;",
	'ratinghistory-graph-scale' => "'''Beoordelingen per dag''' <span style=\"color:red;\">''(rood)''</span> worden weergegeven op de schaal ''1:\$1''.",
	'right-feedback' => 'Het waarderingsformulier gebruiken om een pagina te waarderen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Ranveig
 */
$messages['nn'] = array(
	'ratinghistory' => 'Sidevurderingshistorikk',
	'ratinghistory-leg' => 'Vurderingshistorikkdata for [[:$1|$1]]',
	'ratinghistory-tab' => 'vurdering',
	'ratinghistory-link' => 'Sidevurdering',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Takk for at du tok deg tid til å vurdera sida!</span>''",
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
	'ratinghistory-svg' => 'Syn som SVG',
	'ratinghistory-table-rating' => 'Vurdering',
	'ratinghistory-table-votes' => 'Røyster',
	'ratinghistory-none' => 'Det finst nett no ikkje nok lesarvurderingar til å teikna ein graf.',
	'ratinghistory-legend' => "Den '''daglege gjennomsnittsvurderinga''' <span style=\"color:blue;\">''(blått)''</span> og  
'''gjennomsnittet for det valte intervallet''' per dag <span style=\"color:green;\">''(grønt)''</span> er teikna inn på grafane under etter dato.

Skala: '''[1]''' - Sers dårleg; '''[2]''' - Dårleg; '''[3]''' - OK; '''[4]''' - Bra; '''[5]''' - Sers bra;

Talet på '''vurderingar per dag''' <span style=\"color:red;\">''(raudt)''</span> er vist på grafane under med ein skala på  ''1:\$1''.",
	'right-feedback' => 'Nytta tilbakemeldingsskjemaet for å vurdera ei sida',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'ratinghistory' => 'Istoric de la notacion de la pagina',
	'ratinghistory-leg' => 'Donadas de l’istoric de la notacion per [[:$1|$1]]',
	'ratinghistory-tab' => 'notacion',
	'ratinghistory-link' => 'Notacion de la pagina',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Mercés de nos aver consacrat de temps per tornar legir aquesta pagina !</span>''",
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
	'ratinghistory-svg' => 'Veire en SVG',
	'ratinghistory-table-rating' => 'Notacion',
	'ratinghistory-table-votes' => 'Vòts',
	'ratinghistory-none' => 'En aqueste moment, i a pas pro de lectors de donadas de notacion pels grafics.',
	'ratinghistory-ratings' => "'''Legenda :''' '''(1)''' - Marrit ; '''(2)''' - Mediòcre ; '''(3)''' - Mejan ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-legend' => "Lo '''nombre d'avaloracions per jorn''' <span style=\"color:red;\">''(roge)''</span>, l''''avaloracion mejana per jorn''' <span style=\"color:blue;\">''(blau)''</span> e l''''avaloracion mejana en cors''' <span style=\"color:green;\">''(verd)''</span> son representadas graficament çaijós, per data.
L''''avaloracion mejana en cors''' es simplament la mejana de totas las avaloracions quotidianas ''dins'' lo periòde del jorn causit.
Las notacions son las seguentas :

'''(1)''' - Marrit ; '''(2)''' - Mediòcre ; '''(3)''' - Mejan ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-graph-scale' => "'''Evaluacions per jorn''' <span style=\"color:red;\">''(roge)''</span> afichadas a l'escala ''1:\$1''.",
	'right-feedback' => 'Utilizar lo formulari de somission per notar una pagina',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'ratinghistory-period' => 'ସମୟ ଅବଧି:',
	'ratinghistory-month' => 'ପୂର୍ବ ମାସ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'ratinghistory-month' => 'letscht Munet',
	'ratinghistory-3months' => 'letscht 3 Munede',
	'ratinghistory-year' => 'letscht Yaahr',
	'ratinghistory-3years' => 'letscht 3 Yaahre',
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
	'ratinghistory-thanks' => '\'\'<span style="color:darkred;">Dziękujemy za poświęcony czas na ocenę tej strony!</span>',
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
	'ratinghistory-svg' => 'Zobacz jako SVG',
	'ratinghistory-table-rating' => 'Ocena',
	'ratinghistory-table-votes' => 'Głosy',
	'ratinghistory-none' => 'W tej chwil brak liczby ocen czytelników wystarczającej, by móc stworzyć wykresy.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' – źle; '''(2)''' – słabo; '''(3)''' – średnio; '''(4)''' – dobrze; '''(5)''' – wspaniale;",
	'ratinghistory-legend' => "'''Liczba ocen w ciągu doby''' <span style=\"color:red;\">''(czerwony)''</span>, '''dobowa średnia''' <span style=\"color:blue;\">''(niebieski)''</span> i '''średnia ocena bieżąca''' <span style=\"color:green;\">''(zielony)''</span> zostały przedstawione względem daty na poniższym wykresie.
'''Średnia ocena bieżąca''' to średnia dobowych ocen w tym czasie za każdy dzień.
Skala ocen: 

'''[1]''' – niedostatecznie, '''[2]''' – słabo, '''[3]''' – zadowalająco, '''[4]''' – dobrze, '''[5]''' – bardzo dobrze.",
	'ratinghistory-graph-scale' => "'''Liczba przeglądów na dzień''' <span style=\"color:red;\">''(czerwona)''</span> pokazana w skali ''1:\$1''.",
	'right-feedback' => 'Korzystanie z formularza opinii do oceniania strony',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'ratinghistory' => 'Stòria dij pontegi dle pàgine',
	'ratinghistory-leg' => 'Dat ëd la stòria dij pontegi për [[:$1|$1]]',
	'ratinghistory-tab' => 'pontegi',
	'ratinghistory-link' => 'Pontegi dla pàgina',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Mersì për pijé un moment e revisioné sta pàgina-sì!</span>''",
	'ratinghistory-period' => 'Perìod ëd temp:',
	'ratinghistory-month' => 'ùltim meis',
	'ratinghistory-3months' => 'ùltim 3 meis',
	'ratinghistory-year' => 'ùltim ann',
	'ratinghistory-3years' => 'ùltim 3 agn',
	'ratinghistory-ave' => 'Media: $1',
	'ratinghistory-chart' => 'Pontegi dij letor ant ël temp',
	'ratinghistory-purge' => 'Polida la cache',
	'ratinghistory-table' => 'Vista general dij pontegi dij letor',
	'ratinghistory-users' => "Utent che a l'han dàit pontegi",
	'ratinghistory-graph' => '$2 ëd "$3" ($1 {{PLURAL:$1|revisin|revision}})',
	'ratinghistory-svg' => 'Varda com SVG',
	'ratinghistory-table-rating' => 'Pontegi',
	'ratinghistory-table-votes' => 'Vot',
	'ratinghistory-none' => 'A-i é pa basta dat ëd feedback dij letor për dij gràfich al moment.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Pòver; '''(2)''' - Bass; '''(3)''' - Mesan; '''(4)''' - Àut; '''(5)''' - Ecelent;",
	'ratinghistory-legend' => "Ël '''nùmer ëd revision për di''' <span style=\"color:red;\">''(ross)''</span>, '''pontegi medi për di''' <span style=\"color:blue;\">''(bleu)''</span>,
e '''pontegi medi an cors''' <span style=\"color:green;\">''(verd)''</span> a son an gràfich sota, për data.
Ël '''pontegi medi an cors''' a l'é semplicement la media ëd tùit ij pontegi giornalié ''an drinta'' sto perìod ëd temp për minca di.
Ij pontegi a son com sota:

'''(1)''' - Pòver; '''(2)''' - Bass; '''(3)''' - Mesan; '''(4)''' - Àut; '''(5)''' - Ecelent;",
	'ratinghistory-graph-scale' => "'''Revision për di''' <span style=\"color:red;\">''(ross)''</span> mostrà su na scala ''1:\$1''.",
	'right-feedback' => 'Deuvra la forma ëd feedback për voté na pàgina',
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
	'ratinghistory-svg' => 'د SVG په توګه کتل',
	'ratinghistory-table-votes' => 'رايې',
);

/** Portuguese (Português)
 * @author 555
 * @author Crazymadlover
 * @author Hamilton Abreu
 * @author Indech
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'ratinghistory' => 'Histórico de avaliações da página',
	'ratinghistory-leg' => 'Histórico de dados de avaliação para [[:$1|$1]]',
	'ratinghistory-tab' => 'avaliação',
	'ratinghistory-link' => 'Avaliação da página',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Obrigado por reservar um momento para avaliar esta página!</span>''",
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
	'ratinghistory-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Avaliação',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Neste momento, ainda não há avaliações dos leitores suficientes para mostrar gráficos.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Razoável; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-legend' => "O '''número diário de revisões''' <span style=\"color:red;\">''(vermelho)''</span>, a '''avaliação média diária''' <span style=\"color:blue;\">''(azul)''</span> e a '''avaliação média acumulada''' <span style=\"color:green;\">''(verde)''</span> estão apresentadas graficamente abaixo, por data. 
A '''avaliação média acumulada''' é apenas a média de todas as avaliações diárias ''dentro'' desta janela temporal em cada dia.
As avaliações são como se segue:

'''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Razoável; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "'''Número diário de revisões''' <span style=\"color:red;\">''(red)''</span> apresentado na escala ''1:\$1''.",
	'right-feedback' => 'Use o formulário de avaliação para avaliar uma página',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'ratinghistory' => 'Histórico de avaliações da página',
	'ratinghistory-leg' => 'Histórico de dados de avaliações para [[:$1|$1]]',
	'ratinghistory-tab' => 'avaliação',
	'ratinghistory-link' => 'Avaliação da página',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Obrigado por reservar um momento para avaliar esta página!</span>''",
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
	'ratinghistory-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Avaliação',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Ainda não há dados suficientes de avaliações dos leitores para mostrar gráficos.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Média; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-legend' => "O '''número diário de avaliações''' <span style=\"color:red;\">''(vermelho)''</span>, '''avaliação média diária''' <span style=\"color:blue;\">''(azul)''</span>,
e '''avaliação média acumulada''' <span style=\"color:green;\">''(verde)''</span> são apresentadas no gráfico abaixo, por data.
A '''avaliação média acumulada''' é apenas a média de todas as avaliações diárias ''dentro'' deste intervalo de tempo para cada dia.
As avaliações são as seguintes:

'''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Média; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "'''Avaliações por dia''' <span style=\"color:red;\">''(vermelho)''</span> exibidas em escala ''1:\$1''.",
	'right-feedback' => 'Use o formulário de feedback para avaliar uma página',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 */
$messages['ro'] = array(
	'ratinghistory' => 'Istoric evaluare pagină',
	'ratinghistory-leg' => 'Informații istoric evaluare pentru [[:$1|$1]]',
	'ratinghistory-tab' => 'evaluare',
	'ratinghistory-link' => 'Evaluarea paginii',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Mulțumim pentru că ați revizuit această pagină!</span>''",
	'ratinghistory-period' => 'Perioadă de timp:',
	'ratinghistory-month' => 'ultima lună',
	'ratinghistory-3months' => 'ultimele 3 luni',
	'ratinghistory-year' => 'ultimul an',
	'ratinghistory-3years' => 'ultimii 3 ani',
	'ratinghistory-ave' => 'Medie: $1',
	'ratinghistory-chart' => 'Evaluările cititorilor de-a lungul timpului',
	'ratinghistory-purge' => 'curăță memoria cache',
	'ratinghistory-table' => 'Privire de ansamblu asupra evaluării cititorilor',
	'ratinghistory-users' => 'Utilizatori care și-au exprimat opinia',
	'ratinghistory-graph' => 'Parametrul $2 pentru „$3” ($1 {{PLURAL:$1|evaluare|evaluări}})',
	'ratinghistory-svg' => 'Vizualizare ca SVG',
	'ratinghistory-table-rating' => 'Evaluare',
	'ratinghistory-table-votes' => 'Voturi',
	'ratinghistory-none' => 'Nu există suficiente date disponibile pentru a genera grafice în acest moment.',
	'ratinghistory-ratings' => "'''Legendă:''' '''(1)''' - Slab; '''(2)''' - Redus; '''(3)''' - Mediu; '''(4)''' - Ridicat; '''(5)''' - Excelent;",
	'ratinghistory-graph-scale' => "'''Evaluări pe zi''' <span style=\"color:red;\">''(roșu)''</span> afișate la o scară de ''1:\$1''.",
	'right-feedback' => 'Folosiți formularul de feedback pentru a evalua o pagină',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'ratinghistory' => "Storie de le pundegge d'a pàgene",
	'ratinghistory-leg' => 'Storie de le dete de le pundegge pe [[:$1|$1]]',
	'ratinghistory-tab' => 'pundegge',
	'ratinghistory-link' => "Pundegge d'a pàgene",
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Grazie 'mbà ca è perse doje menute pe recondrollà sta pàgene!</span>''",
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
	'ratinghistory-svg' => 'Vide cumme a SVG',
	'ratinghistory-table-rating' => 'Pundegge',
	'ratinghistory-table-votes' => 'Vote',
	'ratinghistory-none' => "Non ge stonne abbastanza lettore ca onne lassete 'u feedback pe ccrejà 'nu grafeche jndr'à stu timbe.",
	'ratinghistory-ratings' => "Scale: '''[1]''' - Povere; '''[2]''' - Vasce; '''[3]''' - Medie; '''[4]''' - Ierte; '''[5]''' - 'A uerre proprie;",
	'ratinghistory-legend' => "'U '''numere sciurnaliere de revisite''', <span style=\"color:red;\">''(russe)''</span>, 'u '''pundégge medie sciurnaliere''' <span style=\"color:blue;\">''(blu)''</span> e
'u '''pundégge medie corrende''' <span style=\"color:green;\">''(verde)''</span> sonde disegnete aqquà sotte, pe date.
'U '''pundégge medie corrende''' jè semblicemende 'a medie de tutte le pundegge sciuraliere ''fine a'' osce.

Scale: '''[1]''' - Povere; '''[2]''' - Vasce; '''[3]''' - Medie; '''[4]''' - Ierte; '''[5]''' - 'A uerre proprie;",
	'ratinghistory-graph-scale' => "Le '''rivisite pe sciurne''' <span style=\"color:red;\">''(russe)''</span> sonde visualizzate sus a 'na ''1:\$1'' scale.",
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Спасибо, что нашли время оценить эту страницу!</span>''",
	'ratinghistory-period' => 'Период времени:',
	'ratinghistory-month' => 'последний месяц',
	'ratinghistory-3months' => 'последние 3 месяца',
	'ratinghistory-year' => 'за последний год',
	'ratinghistory-3years' => 'последние 3 года',
	'ratinghistory-ave' => 'Средняя: $1',
	'ratinghistory-chart' => 'Оценки читателей за всё время',
	'ratinghistory-purge' => 'очистить кеш',
	'ratinghistory-table' => 'Обзор оценок читателей',
	'ratinghistory-users' => 'Участники, которые дали оценку',
	'ratinghistory-graph' => '$2 из «$3» ($1 {{PLURAL:$1|оценка|оценки|оценок}})',
	'ratinghistory-svg' => 'Просмотреть как SVG',
	'ratinghistory-table-rating' => 'Оценка',
	'ratinghistory-table-votes' => 'Голоса',
	'ratinghistory-none' => 'В настоящее время набралось недостаточное количество читательских оценок для построения графика.',
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' — плохая; '''(2)''' — низкая; '''(3)''' — средняя; '''(4)''' — хорошая; '''(5)''' — отличная;",
	'ratinghistory-legend' => "Ниже показаны: '''число оценок в день''' <span style=\"color:red;\">''(красный)''</span> '''среднесуточная оценка''' <span style=\"color:blue;\">''(синий)''</span> и
'''текущая средняя оценка''' <span style=\"color:green;\">''(зелёный)''</span>.
'''Текущая средняя оценка''' — это среднее всех суточных оценок для данного промежутка времени для каждого дня.
Шкала оценок:

'''[1]''' — плохая; '''[2]''' — низкая; '''[3]''' — средняя; '''[4]''' — хорошая; '''[5]''' — отличная.",
	'ratinghistory-graph-scale' => "'''Число проверок за день''' <span style=\"color:red;\">''(красный)''</span> показано ниже в масштабе ''1:\$1''.",
	'right-feedback' => 'использование формы отзывов для оценки страниц',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'ratinghistory' => 'Історія оцінёваня сторінкы',
	'ratinghistory-leg' => 'Часы про рейтінґ сторінкы про [[:$1|$1]]',
	'ratinghistory-tab' => 'рейтінґ',
	'ratinghistory-link' => 'Рейтінґ сторінкы',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Дякуєме, же вы нашли минутку жебы перевірити тоту сторінку!</span>''",
	'ratinghistory-period' => 'Період часу:',
	'ratinghistory-month' => 'послїднїй місяць',
	'ratinghistory-3months' => 'послїднї 3 місяцї',
	'ratinghistory-year' => 'послїднїй рік',
	'ratinghistory-3years' => 'послїднї 3 рокы',
	'ratinghistory-ave' => 'Середня годнота: $1',
	'ratinghistory-chart' => 'Оцінка чітателїв за час',
	'ratinghistory-purge' => 'очістити кеш',
	'ratinghistory-table' => 'Перегляд оцінок чітателїв',
	'ratinghistory-users' => 'Хоснователї, котры оцінёвали',
	'ratinghistory-graph' => '$2 з "$3" ($1 {{PLURAL:$1|перегляд|перегляды|переглядів}})',
	'ratinghistory-svg' => 'Зобразити як SVG',
	'ratinghistory-table-rating' => 'Рейтінґ',
	'ratinghistory-table-votes' => 'Голосы',
	'ratinghistory-none' => 'В сучасности не є про ґрафы к діспозіції достаток оцїнїня чітателїв.',
	'ratinghistory-ratings' => "'''Леґенда:''' '''(1)''' — слаба; '''(2)''' — низка; '''(3)''' — середня; '''(4)''' — высока; '''(5)''' — выняткова;",
	'ratinghistory-legend' => "Наступный ґраф указує ''чісло оцїнок на день''' <span style=\"color:red;\">''(червено)''</span>, '''середня оцїнка даный день''' <span style=\"color:blue;\">''(синё)''</span>
і '''слизка середня годнота оцїнїня''' <span style=\"color:green;\">''(зелено)''</span> подля датуму.
'''Слизка середня годнота оцїнїня''' є просто середня годнота вшыткых денных оцїнїнь в рамках приналежного часу про каждый  день.
Оцїнкы суть:

'''(1)''' – Слабы; '''(2)''' – Низкы; '''(3)''' – Добры; '''(4)''' – Высокы; '''(5)''' – Вынятковы",
	'ratinghistory-graph-scale' => "'''Чісло оцїнок/день''' <span style=\"color:red;\">''(червено)''</span> указаный в мірцї ''1:\$1''.",
	'right-feedback' => 'Оцїнёваня сторінок средством формуларя',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'ratinghistory-table-votes' => 'मत',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'ratinghistory' => 'Сирэй сыаналааһынын устуоруйата',
	'ratinghistory-leg' => 'Сирэй сыаналааһынын туһунан дааннайдар [[:$1|$1]]',
	'ratinghistory-tab' => 'сыаналааһын',
	'ratinghistory-link' => 'Сирэйи сыаналааһын',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Бу сирэйи сыаналаабыккар махтал!</span>''",
	'ratinghistory-period' => 'Кэм устата:',
	'ratinghistory-month' => 'бүтэһик ый',
	'ratinghistory-3months' => 'бүтэһик 3 ый',
	'ratinghistory-year' => 'бүтэһик сыл',
	'ratinghistory-3years' => 'бүтэһик 3 сыл',
	'ratinghistory-ave' => 'Ортотунан: $1',
	'ratinghistory-chart' => 'Ааҕааччылар сыаналара барыта, саҕаланыаҕыттан',
	'ratinghistory-purge' => 'Кээһи ыраастаа',
	'ratinghistory-table' => 'Ааҕааччылар сыаналарын сүнньүнэн көрүү',
	'ratinghistory-users' => 'Сыана быспыт кыттааччылар',
	'ratinghistory-graph' => '"$3" сыанабылтан $2 сыаната ($1)',
	'ratinghistory-svg' => 'SVG курдук көрүү',
	'ratinghistory-table-rating' => 'Сыанабыл',
	'ratinghistory-table-votes' => 'Куоластааһын',
	'ratinghistory-none' => 'График оҥорорго тиийэр куолас өссө да бэриллэ илик эбит.',
	'ratinghistory-ratings' => "'''Легендата:''' '''(1)''' — куһаҕан; '''(2)''' — мөлтөх; '''(3)''' — орто; '''(4)''' — үчүгэй; '''(5)''' — бэртээхэй;",
	'ratinghistory-legend' => "Аллара көрдөрүннүлэр: '''күҥҥэ хас сыанабыл биэриллэрэ''' <span style=\"color:red;\">''(кыһыл)''</span> '''сууккаҕа орто сыана''' <span style=\"color:blue;\">''(күөх)''</span> уонна
'''билиҥҥи орто сыана''' <span style=\"color:green;\">''(чээл күөх)''</span>.
'''Билиҥҥи орто сыана''' — суукка бу быстах кэмигэр бары сууккалар орто сыаналарыттан ортотунан таһаарыллар сыана.
Сыанабыл шкалаата:

'''[1]''' — куһаҕан; '''[2]''' — мөлтөх; '''[3]''' — орто; '''[4]''' — үчүгэй; '''[5]''' — уһулуччу.",
	'ratinghistory-graph-scale' => "'''Күҥҥэ хас бэрэбиэркэ буолара''' <span style=\"color:red;\">''(кыһыл)''</span> аллара маннык масштаабтаах көһүннэ ''1:\$1''.",
	'right-feedback' => 'Сирэйи сыаналыырга отзыв форматын туттуу',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'ratinghistory' => 'පිටු තරාතිරම් ඉතිහාසය',
	'ratinghistory-leg' => '[[:$1|$1]] සඳහා තරාතිරම් ඉතිහාස දත්ත',
	'ratinghistory-tab' => 'තරාතිරම',
	'ratinghistory-link' => 'පිටු තරාතිරම',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">මෙම පිටුව නිරීක්ෂණය කිරීමට මොහොතක් ගත කලාට තුති!</span>''",
	'ratinghistory-period' => 'කාලපරිච්ඡේදය:',
	'ratinghistory-month' => 'පසුගිය මාසය',
	'ratinghistory-3months' => 'පසුගිය මාස 3',
	'ratinghistory-year' => 'පසුගිය වර්ෂය',
	'ratinghistory-3years' => 'පසුගිය වර්ෂ 3',
	'ratinghistory-ave' => 'සාමාන්‍ය: $1',
	'ratinghistory-chart' => 'සෑම වේලාවෙහිම පාඨක තරාතිරම්',
	'ratinghistory-purge' => 'කෑෂය විමෝචනය කරන්න',
	'ratinghistory-table' => 'පාඨක තරාතිරම්වල දල විශ්ලේෂණය',
	'ratinghistory-users' => 'තරාතිරම් ලබාදුන් පරිශීලකයෝ',
	'ratinghistory-svg' => 'SVG ලෙස නරඹන්න',
	'ratinghistory-table-rating' => 'තරාතිරම',
	'ratinghistory-table-votes' => 'මනාප',
	'ratinghistory-none' => 'මෙම අවස්ථාවේදී ප්‍රස්ථාර සඳහා පාඨක ප්‍රතිචාර දත්ත ලබා ගැනීමට නොමැත.',
	'ratinghistory-ratings' => "'''ප්‍රබන්ධය:''' '''(1)''' - දුර්වල; '''(2)''' - අවම; '''(3)''' - සතුටුදායක; '''(4)''' - ඉහළ; '''(5)''' - අති විශිෂ්ට;",
	'ratinghistory-graph-scale' => "'''දිනකට නිරීක්ෂණ''' <span style=\"color:red;\">''(රතු)''</span> ''1:\$1'' පරිමාණයෙන් දක්වා ඇත.",
	'right-feedback' => 'පිටුවක් තරාතිරම් කිරීමට ප්‍රතිචාර ෆෝරමය භාවිතා කරන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Mormegil
 * @author Rudko
 */
$messages['sk'] = array(
	'ratinghistory' => 'História hodnotenia stránky',
	'ratinghistory-leg' => 'Údaje o hodnotení [[:$1|$1]] v čase',
	'ratinghistory-tab' => 'hodnotenie',
	'ratinghistory-link' => 'Hodnotenie stránky',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Ďakujeme, že ste si našli chvíľu na ohodnotenie tejto stránky!</span>''",
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
	'ratinghistory-svg' => 'Zobraziť ako SVG',
	'ratinghistory-table-rating' => 'Hodnotenie',
	'ratinghistory-table-votes' => 'Hlasy',
	'ratinghistory-none' => 'Momentálne nie je dostupný dostatok údajov o spätnej väzbe používateľov nato, aby bolo možné vytvoriť grafy.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Slabá; '''(2)''' - Nízka; '''(3)''' - Dobrá; '''(4)''' - Vysoká; '''(5)''' - Vynikajúca;",
	'ratinghistory-legend' => "Dolu je podľa dátumu zobrazené '''denné priemerné hodnotenie''' <span style=\"color:blue;\">''(modrou)''</span> a '''priemer vybraného intervalu''' <span style=\"color:green;\">''(zelenou)''</span>. '''Priemer vybraného intervalu''' je jednoducho priemer denných hodnotení ''v rámci'' tohto časového intervalu za každý deň. Hodnoty hodnotenia sa interpretujú nasledovne:

'''[1]''' - Slabé; '''[2]''' - Nízke; '''[3]''' - Dobré; '''[4]''' - Vysoké; '''[5]''' - Výborné;",
	'ratinghistory-graph-scale' => "'''Počet kontrol za deň''' <span style=\"color:red;\">''(červenou)''</span> je zobrazený  v mierke ''1:\$1''.",
	'right-feedback' => 'Ohodnoťte stránku prostredníctvom formulára',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'ratinghistory' => 'Zgodovina ocen strani',
	'ratinghistory-leg' => 'Podatki zgodovine ocen za [[:$1|$1]]',
	'ratinghistory-tab' => 'ocenjevanje',
	'ratinghistory-link' => 'Ocenjevanje strani',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Hvala, ker ste si vzeli trenutek in ocenili to stran!</span>''",
	'ratinghistory-period' => 'Časovno obdobje:',
	'ratinghistory-month' => 'zadnji mesec',
	'ratinghistory-3months' => 'zadnje tri mesece',
	'ratinghistory-year' => 'zadnje leto',
	'ratinghistory-3years' => 'zadnja tri leta',
	'ratinghistory-ave' => 'Povp.: $1',
	'ratinghistory-chart' => 'Ocene bralcev skozi čas',
	'ratinghistory-purge' => 'počisti predpomnilnik',
	'ratinghistory-table' => 'Pregled ocen bralcev',
	'ratinghistory-users' => 'Uporabniki, ki so ocenili',
	'ratinghistory-graph' => '$2 »$3« ($1 {{PLURAL:$1|pregled|pregleda|pregledi|pregledov}})',
	'ratinghistory-svg' => 'Prikaži kot SVG',
	'ratinghistory-table-rating' => 'Ocena',
	'ratinghistory-table-votes' => 'Glasovi',
	'ratinghistory-none' => 'V tem trenutku ni dovolj podatkov o povratnih informacijah bralcev, da bi bilo mogoče izrisati graf.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' – Slabo; '''(2)''' – Nizko; '''(3)''' – Pošteno; '''(4)''' – Visoko; '''(5)''' – Izvrstno;",
	'ratinghistory-legend' => "'''Dnevno število ocen''' <span style=\"color:red;\">''(rdeče)''</span>, '''dnevna povprečna ocena''' <span style=\"color:blue;\">''(modro)''</span> in '''tekoče povprečje ocen''' <span style=\"color:green;\">''(zeleno)''</span> je prikazano v grafu spodaj, po datumu.
'''Tekoče povprečje ocen''' je preprosto povprečje vseh dnevnih ocen ''v tem'' časovnem obdobju za vsak dan.
Ocene so naslednje:

'''(1)''' – Slabo; '''(2)''' – Nizko; '''(3)''' – Pošteno; '''(4)''' – Visoko; '''(5)''' – Izvrstno;",
	'ratinghistory-graph-scale' => "'''Dnevne ocene''' <span style=\"color:red;\">''(rdeče)''</span>, prikazane v merilu ''1:\$1''.",
	'right-feedback' => 'Uporaba obrazca za povratne informacije za ocenjevanje strani',
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

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'ratinghistory' => 'Историја оцена стране.',
	'ratinghistory-leg' => 'Историја оцењивања за [[:$1|$1]]',
	'ratinghistory-tab' => 'оцена',
	'ratinghistory-link' => 'Оцена странице',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Хвала вам што сте одвојили време да прегледате ову страницу!</span>''",
	'ratinghistory-period' => 'Раздобље:',
	'ratinghistory-month' => 'последњи месец',
	'ratinghistory-3months' => 'последња 3 месеца',
	'ratinghistory-year' => 'последња година',
	'ratinghistory-3years' => 'последње три године',
	'ratinghistory-ave' => 'Средње: $1',
	'ratinghistory-chart' => 'Оцене читалаца низ време',
	'ratinghistory-purge' => 'очисти кеш',
	'ratinghistory-table' => 'Преглед оцена читалаца',
	'ratinghistory-users' => 'Корисници који су оценили',
	'ratinghistory-graph' => '$2 од „$3“ ($1 {{PLURAL:$1|оцена|оцене|оцена}})',
	'ratinghistory-svg' => 'Види као SVG',
	'ratinghistory-table-votes' => 'Гласови',
	'ratinghistory-none' => 'Још увек нема довољно мишљења читалаца да би се формирали графикони.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'ratinghistory' => 'Istorija ocena strane.',
	'ratinghistory-leg' => 'Istorija ocenjivanja za [[:$1|$1]]',
	'ratinghistory-tab' => 'ocena',
	'ratinghistory-period' => 'Razdoblje:',
	'ratinghistory-month' => 'poslednji mesec',
	'ratinghistory-3months' => 'poslednja 3 meseca',
	'ratinghistory-year' => 'poslednja godina',
	'ratinghistory-3years' => 'poslednje tri godine',
	'ratinghistory-ave' => 'Srednje: $1',
	'ratinghistory-purge' => 'očisti keš',
	'ratinghistory-svg' => 'Vidi kao SVG',
	'ratinghistory-table-votes' => 'Glasovi',
	'ratinghistory-none' => 'Još uvek nema dovoljno mišljenja čitalaca da bi se formirali grafikoni.',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 * @author Najami
 * @author Per
 */
$messages['sv'] = array(
	'ratinghistory' => 'Sidans betygshistorik',
	'ratinghistory-leg' => 'Betygshistorikdata för [[:$1|$1]]',
	'ratinghistory-tab' => 'betyg',
	'ratinghistory-link' => 'Sidrating',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Tack för att du tog dig tid att granska den här sidan!</span>''",
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
	'ratinghistory-svg' => 'Visa som SVG',
	'ratinghistory-table-rating' => 'Betyg',
	'ratinghistory-table-votes' => 'Röster',
	'ratinghistory-none' => 'Det finns för närvarande inte tillräckligt med feedbackdata tillgängligt från läsarna för grafer.',
	'ratinghistory-ratings' => "'''Förklaring:''' '''(1)''' - Mycket dålig; '''(2)''' - Dålig; '''(3)''' - Okej; '''(4)''' - Bra; '''(5)''' - Mycket bra;",
	'ratinghistory-legend' => "'''Antalet granskningar per dag''' <span style=\"color:red;\">''(röd)''</span>, '''dagliga genomsnittsbetyget''' <span style=\"color:blue;\">''(blå)''</span> och '''löpande genomsnittsbetyg''' <span style=\"color:green;\">''(grön)''</span> visas i grafform nedan, efter datum.
Det '''löpande genomsnittsbetyget''' är helt enkelt genomsnittet av alla dagliga betyg ''inom'' denna tidsperiod för varje dag.

Betygsskalan är enligt följande:
'''[1]''' - Mycket dålig; '''[2]''' - Dålig; '''[3]''' - Okej; '''[4]''' - Bra; '''[5]''' - Mycket bra;",
	'ratinghistory-graph-scale' => "'''Bedömningar per dag''' <span style=\"color:red;\">''(röd)''</span> visas i skala ''1:\$1''.",
	'right-feedback' => 'Använd feedback-formuläret för att betygsätta en sida',
);

/** Tamil (தமிழ்)
 * @author Mahir78
 * @author TRYPPN
 */
$messages['ta'] = array(
	'ratinghistory' => 'பக்க படிநிலை வரலாறு',
	'ratinghistory-leg' => '[[:$1|$1]] க்கான படிநிலை வரலாற்றுத் தகவல்',
	'ratinghistory-tab' => 'படிநிலை',
	'ratinghistory-link' => 'பக்க படிநிலை',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">சிறிது அவகாசம் எடுத்து இந்தப் பக்கத்தை மீளாய்வு செய்தமைக்கு நன்றி!</span>''",
	'ratinghistory-period' => 'நேர காலம்:',
	'ratinghistory-month' => 'கடந்த மாதம்',
	'ratinghistory-3months' => 'கடந்த 3 மாதங்கள்',
	'ratinghistory-year' => 'சென்ற வருடம்',
	'ratinghistory-3years' => 'கடந்த 3 ஆண்டுகள்',
	'ratinghistory-ave' => 'சராசரி: $1',
	'ratinghistory-chart' => 'கால ஓட்டத்தில் வாசகர் அளவீடு',
	'ratinghistory-purge' => 'மிகவேக சேமிப்புமீள்ப்பகத்தை மீதமில்லாமல் நீக்கு',
	'ratinghistory-table' => 'வாசகர்களின் மதிப்பீடு - ஒரு கண்ணோட்டம்',
	'ratinghistory-users' => 'அளவீடு செய்த பயனர்கள்',
	'ratinghistory-graph' => '"$3" உடைய $2 ($1 {{PLURAL:$1|review|reviews}})',
	'ratinghistory-svg' => 'SVGயாக பார்க்க',
	'ratinghistory-table-rating' => 'அளவீடு',
	'ratinghistory-table-votes' => 'ஓட்டெடுப்புகள்',
	'ratinghistory-none' => 'வரைபடம் வரைவதற்குத் தேவையான அளவு வாசகர்களின் கருத்துக்கள் தற்போது இல்லை.',
	'ratinghistory-ratings' => "'''கதை:''' '''(1)''' - மிக மோசம்; '''(2)''' - மோசம்; '''(3)''' - பரவாயில்லை; '''(4)''' - நன்றாகவுள்ளது; '''(5)''' - பிரமாதம்;",
	'ratinghistory-legend' => "The '''daily number of reviews''' <span style=\"color:red;\">''(red)''</span>, '''daily average rating''' <span style=\"color:blue;\">''(blue)''</span>,
and '''running average rating''' <span style=\"color:green;\">''(green)''</span> are graphed below, by date.
The '''running average rating''' is simply the average of all the daily ratings ''within'' this time frame for each day.
The ratings are as follows:

'''(1)''' - மிக மோசம்; '''(2)''' - மோசம்; '''(3)''' - பரவாயில்லை; '''(4)''' - நன்றாகவுள்ளது; '''(5)''' - பிரமாதம்;",
	'ratinghistory-graph-scale' => "'''தினசரி மதிப்பீடுகள்''' <span style=\"color:red;\">''(சிவப்பு)''</span>  ''1:\$1'' இந்த அளவில் காண்பிக்கப்பட்டுள்ளது.",
	'right-feedback' => 'பக்கத்தின் தரம் பற்றிய கருத்தை தெரிவிக்க பின்னூட்டப் படிவத்தை பயன்படுத்தவும்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'ratinghistory' => 'పేజీ రేటింగు చరిత్ర',
	'ratinghistory-tab' => 'మూల్యాంకన',
	'ratinghistory-link' => 'పుట మూల్యాంకన',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">ఈ పేజీని సమీక్షించడానికి సమయం వెచ్చించినందుకు ధన్యవాదాలు!</span>''",
	'ratinghistory-period' => 'కాల వ్యవధి:',
	'ratinghistory-month' => 'గత నెల',
	'ratinghistory-3months' => 'గత 3 నెలలు',
	'ratinghistory-year' => 'గత సంవత్సరం',
	'ratinghistory-3years' => 'గత 3 సంవత్సరాలు',
	'ratinghistory-ave' => 'సగటు: $1',
	'ratinghistory-users' => 'మూల్యాంకన చేసిన వాడుకరులు',
	'ratinghistory-graph' => '"$3" యొక్క $2 ($1 {{PLURAL:$1|సమీక్ష|సమీక్షలు}})',
	'ratinghistory-svg' => 'SVGగా చూడండి',
	'ratinghistory-table-rating' => 'మూల్యాంకనం',
	'ratinghistory-table-votes' => 'వోట్లు',
	'ratinghistory-ratings' => "'''సూచిక:''' '''(1)''' - అత్యల్పం; '''(2)''' - అల్పం; '''(3)''' - పర్లేదు; '''(4)''' - ఉత్తమం; '''(5)''' - అత్యుత్తమం;",
);

/** Thai (ไทย)
 * @author Ans
 * @author Horus
 */
$messages['th'] = array(
	'ratinghistory-month' => 'เดือนที่แล้ว',
	'ratinghistory-3months' => '3 เดือนที่แล้ว',
	'ratinghistory-year' => 'ปีที่แล้ว',
	'ratinghistory-3years' => '3 ปีที่แล้ว',
	'ratinghistory-ave' => 'เฉลี่ย: $1',
	'ratinghistory-purge' => 'ล้างแคช',
	'ratinghistory-users' => 'ผู้ใช้ที่มีส่วนร่วมจัดอันดับ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'ratinghistory' => 'Sahypa derejelendirme geçmişi',
	'ratinghistory-leg' => '[[:$1|$1]] üçin derejelendirme geçmişi maglumaty',
	'ratinghistory-tab' => 'derejelendirme',
	'ratinghistory-link' => 'Sahypa derejelendirmesi',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Bu sahypany gözden geçirmek üçin wagt tapanyňyz üçin sag boluň!</span>''",
	'ratinghistory-period' => 'Wagt periody:',
	'ratinghistory-month' => 'geçen aý',
	'ratinghistory-3months' => 'geçen 3 aý',
	'ratinghistory-year' => 'geçen ýyl',
	'ratinghistory-3years' => 'geçen 3 ýyl',
	'ratinghistory-ave' => 'Ort: $1',
	'ratinghistory-chart' => 'Ähli wagtky okyjy derejelendirmeleri',
	'ratinghistory-purge' => 'keşi boşat',
	'ratinghistory-table' => 'Okyjy derejelendirmelerine umumy syn',
	'ratinghistory-users' => 'Derejelendirme beren ulanyjylar',
	'ratinghistory-graph' => '"$3" sahypasynda $2 ($1 {{PLURAL:$1|gözden geçirme|gözden geçirme}})',
	'ratinghistory-svg' => 'SVG edip görkez',
	'ratinghistory-table-rating' => 'Derejelendirme',
	'ratinghistory-table-votes' => 'Sesler',
	'ratinghistory-none' => 'Grafikalar üçin häzirki wagtda ýeterlik mukdarda okyjy seslenmesi ýok.',
	'ratinghistory-ratings' => "'''Şertli belgi:''' '''(1)''' - Ýaramaz; '''(2)''' - Pes; '''(3)''' - Orta gürp; '''(4)''' - Ýagşy; '''(5)''' - Ajaýyp;",
	'ratinghistory-legend' => "'''günlük ortaça gözden geçirme''' <span style=\"color:red;\">''(gyzyl)''</span>, '''günlük ortaça derejelendirme''' <span style=\"color:blue;\">''(gök)''</span>
we '''häzirki ortaça derejelendirme''' <span style=\"color:green;\">''(ýaşyl)''</span> aşakda sene boýunça çyzyldy.
'''häzirki ortaça derejelendirme''' her bir gün üçin şu böleginiň ''dowamynda'' günlük derejelendirmeleriniň ortaça bahasydyr.
Derejelendirmeler aşakdaky ýalydyr:

'''(1)''' - Ýaramaz; '''(2)''' - Pes; '''(3)''' - Orta gürp; '''(4)''' - Ýagşy; '''(5)''' - Ajaýyp;",
	'ratinghistory-graph-scale' => "'''Günlük gözden geçirmeler''' <span style=\"color:red;\">''(gyzyl)''</span> ''1:\$1'' masştabynda görkezilýär.",
	'right-feedback' => 'Sahypa derejelendirmek üçin seslenme formuny ulanyň',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'ratinghistory' => 'Kasaysayan ng pagaantas/pagraranggo ng pahina',
	'ratinghistory-leg' => 'Dato ng pagbibigay ng antas (ranggo) para sa [[:$1|$1]]',
	'ratinghistory-tab' => 'halagang pangkaantasan (ranggo)',
	'ratinghistory-link' => 'Halagang pangkaantasan (ranggo) ng pahina',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Salamat sa pagbibigay mo ng panahon upang suriing muli ang pahinang ito!</span>''",
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
	'ratinghistory-svg' => 'Tingnan bilang SVG',
	'ratinghistory-table-rating' => 'Kaantasan',
	'ratinghistory-table-votes' => 'Mga boto',
	'ratinghistory-none' => 'Sa ngayon, walang makukuhang sapat na datong pambalik-pahayag para sa mga talangguhit (grap) mula sa mambabasa.',
	'ratinghistory-ratings' => "'''Kahulugan:''' '''(1)''' - Mahina; '''(2)''' - Mababa; '''(3)''' - Patas; '''(4)''' - Mataas; '''(5)''' - Mahusay;",
	'ratinghistory-legend' => "Ang '''pang-araw-araw na bilang ng mga pagsuri''' <span style=\"color:red;\">''(pula)''</span>,  
'''pang-araw-araw na pangkaraniwang kaantasan''' <span style=\"color:blue;\">''(bughaw)''</span>, at '''tumatakbong pangkaraniwang kaantasan''' <span style=\"color:green;\">''(lunti)''</span> ay nakatalangguhit sa ibaba, ayon sa petsa.
Ang '''tumatakbong pangkaraniwang kaantasan''' ay payak na ang pangkaraniwang kaantasan ng lahat ng mga pang-araw-araw ng mga kaantasan ''sa loob'' ng saklaw ng panahong ito para sa bawat araw.
Ang mga sumusunod ay ang mga kaantasan:
 
'''(1)''' - Mahina; '''(2)''' - Mababa; '''(3)''' - Patas; '''(4)''' - Mataas; '''(5)''' - Mahusay;",
	'ratinghistory-graph-scale' => "'''Mga pagsusuri sa bawat araw''' <span style=\"color:red;\">''(pula)''</span> ipinapakita sa tumbasang ''1:\$1''.",
	'right-feedback' => "Gamitin ang pormularyong pangpagbibigay ng balik-pahayag (''feedback'') upang mabigyan ng kaantasan/halaga ang isang pahina",
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'ratinghistory' => 'Sayfa derecelendirme geçmişi',
	'ratinghistory-leg' => '[[:$1|$1]] için derecelendirme geçmişi verisi',
	'ratinghistory-tab' => 'derecelendirme',
	'ratinghistory-link' => 'Sayfa derecelendirmesi',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Bu sayfayı gözden geçirmek için zamanınızı ayırdığınız için teşekkürler!</span>''",
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
	'ratinghistory-graph' => '"$3" sayfası için $2 ($1 inceleme)',
	'ratinghistory-svg' => 'SVG olarak görüntüle',
	'ratinghistory-table-rating' => 'Derecelendirme',
	'ratinghistory-table-votes' => 'Oylar',
	'ratinghistory-none' => 'Grafikler için şuanda yeterince okuyucu dönüt verisi yok.',
	'ratinghistory-ratings' => "'''Ölçek:''' '''(1)''' - Zayıf; '''(2)''' - Düşük; '''(3)''' - Adil; '''(4)''' - Yüksek; '''(5)''' - Mükemmel;",
	'ratinghistory-legend' => "'''Günlük ortalama gözden geçirme''' <span style=\"color:red;\">''(kırmızı)''</span>, '''Günlük ortalama derecelendirme''' <span style=\"color:blue;\">''(mavi)''</span>
ve '''Çalışma ortalama derecelendirme''' <span style=\"color:green;\">''(yeşil)''</span> aşağıda tarihe göre çizildi.
'''Çalışma ortalama derecelendirme''', herbir gün için bu zaman dilimi ''içinde'' günlük derecelendirmelerinin ortalamasıdır.
Derecelendirmeler aşağıdaki gibidir:

'''(1)''' - Zayıf; '''(2)''' - Düşük; '''(3)''' - Adil; '''(4)''' - Yüksek; '''(5)''' - Mükemmel;",
	'ratinghistory-graph-scale' => "'''Günlük gözden geçirmeler''' <span style=\"color:red;\">''(kırmızı)''</span> ''1:\$1'' ölçeğinde gösterilmektedir.",
	'right-feedback' => 'Bir sayfayı derecelendirmek için dönüt formunu kullanın',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'ratinghistory-ratings' => "'''Махсус тамгалар:''' '''(1)''' — начар; '''(2)''' — түбән; '''(3)''' — уртача; '''(4)''' — яхшы; '''(5)''' — бик әйбәт;",
	'ratinghistory-legend' => "Аста: '''бер көнгә бирелүче билгеләр''' күрсәтелгән <span style=\"color:red;\">''(кызыл)''</span> '''уртача билге''' <span style=\"color:blue;\">''(зәңгәр)''</span> и
'''хәзерге уртача билге''' <span style=\"color:green;\">''(яшел)''</span>.
'''Хәзерге уртача билге''' — әлегә бирелгән көннәр өчен уртача билге.
Билгеләр шкаласы:

'''(1)''' — начар; '''(2)''' — түбән; '''(3)''' — уртача; '''(4)''' — яхшы; '''(5)''' — бик әйбәт;.",
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'ratinghistory' => 'Історія оцінювання сторінки',
	'ratinghistory-leg' => 'Дані про рейтинг сторінки для [[:$1|$1]]',
	'ratinghistory-tab' => 'рейтинг',
	'ratinghistory-link' => 'Рейтинг сторінки',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Дякуємо, що знайшли хвилинку щоб перевірити цю сторінку!</span>''",
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
	'ratinghistory-svg' => 'Переглянути як SVG',
	'ratinghistory-table-rating' => 'Рейтинг',
	'ratinghistory-table-votes' => 'Голоси',
	'ratinghistory-none' => "Недостатньо даних зворотного зв'язку читачів для графіків на цей час.",
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' — погана; '''(2)''' — низька; '''(3)''' — середня; '''(4)''' — висока; '''(5)''' — відмінна;",
	'ratinghistory-legend' => "'''Кількість оцінок за добу''' <span style=\"color:red;\">''(red)''</span>,
'''середній рейтинг за добу''' <span style=\"color:blue;\">''(синій)''</span> і  
'''середній рейтинг за період''' <span style=\"color:green;\">''(зелений)''</span> показані нижче за датою.
'''Середній рейтинг за період''' — середнє значення всіх добових рейтингів ''за'' період для кожного дня.

Шкала якості: '''(1)''' - погана; '''(2)''' - низька; '''(3)''' — середня; '''(4)''' — висока; '''(5)''' — відмінна;",
	'ratinghistory-graph-scale' => "'''Кількість оцінок за добу''' <span style=\"color:red;\">''(червоний)''</span> показано нижче в масштабі ''1:\$1''.",
	'right-feedback' => "використання форми зворотного зв'язку для оцінювання сторінки",
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'ratinghistory' => 'Stòrico de le valutassion de le pagine',
	'ratinghistory-leg' => 'Dati del stòrico de le valutassion par [[:$1|$1]]',
	'ratinghistory-tab' => 'valutassion',
	'ratinghistory-link' => 'Valutassion de la pagina',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Grassie de ver speso calche momento a valutar sta pagina!</span>''",
	'ratinghistory-period' => 'Periodo de tenpo:',
	'ratinghistory-month' => 'ultimo mese',
	'ratinghistory-3months' => 'ultimi 3 mesi',
	'ratinghistory-year' => 'ultimo ano',
	'ratinghistory-3years' => 'ultimi 3 ani',
	'ratinghistory-ave' => 'Media: $1',
	'ratinghistory-chart' => 'Valutassion dei letori col passar del tenpo',
	'ratinghistory-purge' => 'neta la cache',
	'ratinghistory-table' => 'Panoràmega de le valutassion dei letori',
	'ratinghistory-users' => 'Utenti che ga dato na valutassion',
	'ratinghistory-graph' => '$2 de "$3" ($1 {{PLURAL:$1|revision|revision}})',
	'ratinghistory-svg' => 'Varda come SVG',
	'ratinghistory-table-rating' => 'Valutassion',
	'ratinghistory-table-votes' => 'Voti',
	'ratinghistory-none' => 'Par desso i dati de riscontro dai letori no i xe in bisogno par poder mostrar dei grafici.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Tristo assè; '''(2)''' - Tristo; '''(3)''' - Cussì-cussì; '''(4)''' - Bon; '''(5)''' - Bon assè;",
	'ratinghistory-legend' => "Qua soto vien mostrà, par data, el '''nùmaro de valutassion al zorno''' <span style=\"color:red;\">''(rosso)''</span>, la '''valutassion media par zorno''' <span style=\"color:blue;\">''(blu)''</span>, e la '''valutassion media cumulà''' <span style=\"color:green;\">''(verde)''</span>.
La '''valutassion media cumulà''' la xe senplisemente la media de tuti i giudissi ''drento'' de sta finestra de tenpo zorno par zorno.
Le valutassion le xe ste qua:

'''(1)''' - Tristo assè; '''(2)''' - Tristo; '''(3)''' - Cussì-cussì; '''(4)''' - Bon; '''(5)''' - Bon assè;",
	'ratinghistory-graph-scale' => "'''Revision par zorno'''  <span style=\"color:red;\">''(rosso)''</span> mostrà in scala ''1:\$1''.",
	'right-feedback' => 'Dopara sto modulo par valutar na pagina',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'ratinghistory' => 'Lehtpolen arvostelendoiden aigkirj',
	'ratinghistory-leg' => '[[:$1|$1]]-lehtpolen arvostelendistorijan andmused',
	'ratinghistory-tab' => 'arvoind',
	'ratinghistory-link' => 'Lehtpolen arvoind',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Kitäm, miše tö olet löudnu aigad necidä lehtpol't arvosteldes!</span>''",
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
	'ratinghistory-svg' => 'Kacta kut SVG',
	'ratinghistory-table-rating' => 'Arvoind',
	'ratinghistory-table-votes' => 'Äned',
	'ratinghistory-none' => 'Ei ulotu lugijoiden arvsanoid grafikan tehtes.',
	'ratinghistory-ratings' => "'''Legend:''' '''(1)''' - Hond; '''(2)''' - Madal; '''(3)''' - Keskmäine; '''(4)''' - Korged; '''(5)''' - Lujas hüvä;",
	'ratinghistory-legend' => "Alemba oma ozutadud '''arvsanoiden lugu päiväs''' <span style=\"color:red;\">''(rusked)''</span>, '''päivesenkeskmäine arvsana''' <span style=\"color:blue;\">''(sinine)''</span> da '''nügüdläine keskmäine arvsana''' <span style=\"color:green;\">''(vihand)''</span>.  
'''Nügüdläižeks keskmäižeks arvsanaks''' kuctas päivesen arvsanoiden keskmäine lugu, kudamban lugedas kaikuččen päivän märitud pordas aigad.

Pordhišt: '''[1]''' — hond; '''[2]''' — madal; '''[3]''' — keskmäine; '''[4]''' — hüvä; '''[5]''' — lujas hüvä;",
	'ratinghistory-graph-scale' => "'''Arvostelendoiden lugu päiväs''' <span style=\"color:red;\">''(red)''</span> ozutadas ''1:\$1''-masštabas.",
	'right-feedback' => 'Kävutagat arvostelendform lehtpoliden arvosteldes',
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
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">Cám ơn đã để dành một chút thời gian để duyệt trang này!</span>''",
	'ratinghistory-period' => 'Thời gian:',
	'ratinghistory-month' => 'tháng trước',
	'ratinghistory-3months' => '3 tháng qua',
	'ratinghistory-year' => 'năm ngoái',
	'ratinghistory-3years' => 'ba năm trước',
	'ratinghistory-ave' => 'Trung bình: $1',
	'ratinghistory-chart' => 'Đánh giá của độc giả qua thời gian',
	'ratinghistory-purge' => 'tẩy sạch vùng nhớ đệm',
	'ratinghistory-table' => 'Tóm tắt đánh giá của độc giả',
	'ratinghistory-users' => 'Các thành viên đánh giá:',
	'ratinghistory-graph' => '$2 của bài “$3” (theo $1 {{PLURAL:$1|độc giả|độc giả}})',
	'ratinghistory-svg' => 'Xem bản SVG',
	'ratinghistory-table-rating' => 'Đánh giá',
	'ratinghistory-table-votes' => 'Số phiếu',
	'ratinghistory-none' => 'Hiện chưa có đủ dữ liệu đánh giá của độc giả để vẽ biểu thị.',
	'ratinghistory-ratings' => "'''Giải thích:''' '''(1)''' - Kém; '''(2)''' - Thấp; '''(3)''' - Trung bình; '''(4)''' - Cao; '''(5)''' - Tuyệt vời;",
	'ratinghistory-legend' => "Những biểu thị ở dưới trình bày '''số lần đánh giá hàng ngày''' <span style=\"color:red;\">(đỏ)</span>,  '''đánh giá trung bình hàng ngày''' <span style=\"color:blue;\">''(lam)''</span>, và '''đánh giá trung bình đương thời''' <span style=\"color:green;\">''(lục)''</span>, theo thời gian. '''Đánh giá trung bình đương thời''' chỉ là trung bình các đánh giá hàng ngày ''tại giai đoạn này'' vào mỗi ngày. Giải thích các giá trị:

'''[1]''' – Tệ; '''[2]''' – Dở; '''[3]''' – Khá; '''[4]''' – Hay; '''[5]''' – Tuyệt",
	'ratinghistory-graph-scale' => "'''Số lần đánh giá trong ngày''' <span style=\"color:red;\">''(đỏ)''</span> được trình bày với tỷ lệ ''1:\$1''.",
	'right-feedback' => 'Đánh giá trang',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'ratinghistory-month' => 'mul lätik',
	'ratinghistory-3months' => 'muls lätik 3',
	'ratinghistory-year' => 'yel lätik',
	'ratinghistory-3years' => 'yels lätik 3',
	'ratinghistory-ave' => 'Zäned: $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'ratinghistory' => '页面评级历史',
	'ratinghistory-leg' => '[[:$1|$1]]的评级历史数据',
	'ratinghistory-tab' => '评分',
	'ratinghistory-link' => '页面评分',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">谢谢您对本页的评论！</span>''",
	'ratinghistory-period' => '时间段：',
	'ratinghistory-month' => '上月',
	'ratinghistory-3months' => '过去3个月',
	'ratinghistory-year' => '去年',
	'ratinghistory-3years' => '过去3年',
	'ratinghistory-ave' => '平均： $1',
	'ratinghistory-chart' => '读者评分随着时间的推移',
	'ratinghistory-purge' => '清除缓存',
	'ratinghistory-table' => '读者评论总览',
	'ratinghistory-users' => '给出评价的用户',
	'ratinghistory-graph' => '"$3" 的 $2 （$1 {{PLURAL:$1|复审|复审}}）',
	'ratinghistory-svg' => '作为SVG浏览',
	'ratinghistory-table-rating' => '评级',
	'ratinghistory-table-votes' => '投票',
	'ratinghistory-none' => '目前没有足够的读者反馈数据来制作图表。',
	'ratinghistory-ratings' => "'''图例：''' '''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4)''' - 好； '''(5)''' - 极好；",
	'ratinghistory-legend' => "逐日的'''每日审核数量'''<span style=\"color:red;\">''（红色）''</span>，'''每日平均评级'''<span style=\"color:blue;\">''（蓝色）''</span>，以及'''移动平均评级'''<span style=\"color:green;\">''（绿色）''</span>如下图所示。
'''移动平均评级'''是在某一天前后一段时间''内''每日评级的平均数。
评级结果如下：

'''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4)''' - 好； '''(5)''' - 极好；",
	'ratinghistory-graph-scale' => "'''每日审核'''<span style=\"color:red;\">''（红色）''</span>以''1:\$1''的比例显示。",
	'right-feedback' => '使用反馈表单来对页面评级',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gaoxuewei
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Waihorace
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'ratinghistory' => '頁面評級歷史',
	'ratinghistory-leg' => '[[:$1|$1]] 的評級歷史數據',
	'ratinghistory-tab' => '評分',
	'ratinghistory-link' => '頁面評分',
	'ratinghistory-thanks' => "''<span style=\"color:darkred;\">謝謝您對本頁的評論！</span>''",
	'ratinghistory-period' => '時間段：',
	'ratinghistory-month' => '過去一個月',
	'ratinghistory-3months' => '過去三個月',
	'ratinghistory-year' => '過去一年',
	'ratinghistory-3years' => '過去三年',
	'ratinghistory-ave' => '平均：$1',
	'ratinghistory-chart' => '讀者評分隨著時間的推移',
	'ratinghistory-purge' => '清理快取',
	'ratinghistory-table' => '讀者評論總覽',
	'ratinghistory-users' => '給出評價的用戶',
	'ratinghistory-graph' => '「$3」的 $2 （$1 {{PLURAL:$1|複審|複審}}）',
	'ratinghistory-svg' => '以 SVG 檢視',
	'ratinghistory-table-rating' => '評分',
	'ratinghistory-table-votes' => '投票',
	'ratinghistory-none' => '目前沒有足夠的讀者回饋數據來製作圖表。',
	'ratinghistory-ratings' => "'''圖例：''' '''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4 )''' - 好； '''(5)''' - 極好；",
	'ratinghistory-legend' => "'''每日評論數量'''<span style=\"color:red;\">''（紅色）''</span>，'''每日平均評級'''<span style=\"color:blue;\">'' （藍色）''</span>，以及'''移動平均評級'''<span style=\"color:green;\">''（綠色）''</span>如下圖所示。
'''移動平均評級'''是在某一天前後一段時間''內''每日評級的平均數。
評級結果如下：

'''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4)''' - 好； ' ''(5)''' - 極好；",
	'ratinghistory-graph-scale' => "'''每天評論'''<span style=\"color:red;\">''（紅色）''</span>以 ''1:\$1'' 的比例顯示。",
	'right-feedback' => '使用回饋意見表單來對頁面評級',
);

