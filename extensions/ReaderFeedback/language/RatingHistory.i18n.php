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
	'ratinghistory-svg'    => 'View as SVG',
	'ratinghistory-table-rating' => 'Rating',
	'ratinghistory-table-votes'  => 'Votes',
	'ratinghistory-none'    => 'There is not enough reader feedback data available for graphs at this time.',
	'ratinghistory-ratings' => '\'\'\'Legend:\'\'\' \'\'\'(1)\'\'\' - Poor; \'\'\'(2)\'\'\' - Low; \'\'\'(3)\'\'\' - Fair; \'\'\'(4)\'\'\' - High; \'\'\'(5)\'\'\' - Excellent;',
	'ratinghistory-legend'  => 'The \'\'\'daily number of reviews\'\'\' <font color="red">\'\'(red)\'\'</font>, \'\'\'daily average rating\'\'\' <font color="blue">\'\'(blue)\'\'</font>,
	and \'\'\'running average rating\'\'\' <font color="green">\'\'(green)\'\'</font> are graphed below, by date.
	The \'\'\'running average rating\'\'\' is simply the average of all the daily ratings \'\'within\'\' this time frame for each day.
	The ratings are as follows:
	
	\'\'\'(1)\'\'\' - Poor; \'\'\'(2)\'\'\' - Low; \'\'\'(3)\'\'\' - Fair; \'\'\'(4)\'\'\' - High; \'\'\'(5)\'\'\' - Excellent;',
	'ratinghistory-graph-scale' => '\'\'\'Reviews per day\'\'\' <font color="red">\'\'(red)\'\'</font> shown on a \'\'1:$1\'\' scale.',
	'right-feedback' => 'Use the feedback form to rate a page',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Boivie
 * @author Byrial
 * @author Hamilton Abreu
 * @author Purodha
 * @author Raymond
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'ratinghistory-ave' => 'Average',
	'ratinghistory-graph' => '$2 is a rating category (e.g. {{int:readerfeedback-reliability}}, {{int:readerfeedback-completeness}}, {{int:readerfeedback-npov}}, {{int:readerfeedback-presentation}}, or {{int:readerfeedback-overall}}).


$3 is the page name for the rated page.',
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Dankie vir u tyd en moeite om die bladsy te gradeer!</font>''",
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
	'ratinghistory-legend' => "Die '''aantal daaglikse graderings''' <font color=\"red\">''(rooi)''</font>, die '''daaglikse gemiddelde gradering''' <font color=\"blue\">''(blou)''</font> en die '''gemiddelde gradering oor die aangegewe periode''' <font color=\"green\">''(groen)''</font> word hieronder in die grafiek volgens datum vertoon.
Die '''gemiddelde gradering oor die aangegewe periode''' is die gemiddelde van alle daaglikse gemiddelde graderings ''binne'' die tydperk vir elke dag.

'''(1)''' - Swak; '''(2)''' - Laag; '''(3)''' - Redelik; '''(4)''' - Hoog; '''(5)''' - Uitstekend;",
	'ratinghistory-graph-scale' => "'''Waarderings per dag''' <font color=\"red\">''(rooi)''</font> word weergegee op die skaal ''1:\$1''.",
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
	'ratinghistory-svg' => 'عرض كإس في جي',
	'ratinghistory-table-rating' => 'تقييم',
	'ratinghistory-table-votes' => 'أصوات',
	'ratinghistory-none' => 'لا توجد بيانات كافية من القراء متوفرة للرسومات في هذا الوقت.',
	'ratinghistory-ratings' => "'''المفتاح:''' '''(1)''' - فقير; '''(2)''' - منخفض; '''(3)''' - معقول; '''(4)''' - مرتفع; '''(5)''' - ممتاز;",
	'ratinghistory-legend' => "'''عدد المراجعات اليومي''' <font color=\"red\">''(أحمر)''</font>, '''التقييم اليومي المتوسط''' <font color=\"blue\">''(أزرق)''</font>,
و '''التقييم التشغيلي المتوسط''' <font color=\"green\">''(أخضر)''</font> مرسومون بالأسفل، حسب التاريخ.
'''التقييم التشغيلي المتوسط''' هو ببساطة متوسط كل التقييمات اليومية ''في'' هذا الإطار الزمني لكل يوم.
التقييمات هي كالتالي:

'''(1)''' - فقير; '''(2)''' - منخفض; '''(3)''' - معقول; '''(4)''' - مرتفع; '''(5)''' - ممتاز;",
	'ratinghistory-graph-scale' => "'''المراجعات لكل يوم''' <font color=\"red\">''(أحمر)''</font> معروض على مقياس ''1:\$1''.",
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
	'ratinghistory-svg' => 'اعرض SVG',
	'ratinghistory-table-rating' => 'تقييم',
	'ratinghistory-table-votes' => 'الاصوات',
	'ratinghistory-none' => 'لا توجد بيانات كافية من القراء متوفرة للرسومات فى هذا الوقت.',
	'ratinghistory-legend' => "'''عدد المراجعات اليومي''' <font color=\"red\">''(أحمر)''</font>, '''التقييم اليومى المتوسط''' <font color=\"blue\">''(أزرق)''</font>,
و '''التقييم التشغيلى المتوسط''' <font color=\"green\">''(أخضر)''</font> مرسومون بالأسفل، حسب التاريخ.
'''التقييم التشغيلى المتوسط''' هو ببساطة متوسط كل التقييمات اليومية ''في'' هذا الإطار الزمنى لكل يوم.
التقييمات هى كالتالي:

'''(1)''' - فقير; '''(2)''' - منخفض; '''(3)''' - معقول; '''(4)''' - مرتفع; '''(5)''' - ممتاز;",
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

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'ratinghistory' => 'Гісторыя адзнак старонкі',
	'ratinghistory-leg' => 'Зьвесткі па гісторыі адзнак для [[:$1|$1]]',
	'ratinghistory-tab' => 'адзнака',
	'ratinghistory-link' => 'Адзнака старонкі',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Дзякуй, за тое, што знайшлі час і адзначылі гэту старонку!</font>''",
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
	'ratinghistory-legend' => "Ніжэй пададзеныя '''колькасьць праверак за дзень''' <font color=\"red\">''(чырвоны)''</font>, '''сярэднесутачная''' <font color=\"blue\">''(блакітны)''</font> і  
'''цяперашняя сярэдняя''' <font color=\"green\">''(зялёны)''</font> адзнакі па датах.
'''Цяперашняя сярэдняя адзнака''' — сярэдняе значэньне ўсіх штодзённых адзнак ''за'' пэрыяд часу кожнага дня.
Выкарыстоўваюцца наступныя адзнакі:

'''(1)''' — благая; '''(2)''' — нізкая; '''(3)''' — сярэдняя; '''(4)''' — высокая; '''(5)''' — выдатная;",
	'ratinghistory-graph-scale' => "'''Колькасьць праверак за дзень''' <font color=\"red\">''(чырвоны)''</font> паказана ў маштабе ''1:\$1''.",
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
	'ratinghistory-period' => 'সময়:',
	'ratinghistory-month' => 'গত মাস',
	'ratinghistory-3months' => 'গত ৩ মাস',
	'ratinghistory-3years' => 'গত ৩ বছর',
	'ratinghistory-ave' => 'গড়: $1',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'ratinghistory' => 'Istor priziadenn ar bajenn',
	'ratinghistory-leg' => 'Roadennoù istor ar priziadennoù evit [[:$1|$1]]',
	'ratinghistory-tab' => 'istimadur',
	'ratinghistory-link' => 'Priziadenn ar bajenn',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Trugarez da vezañ kemmeret amzer evit adlenn ar bajenn !</font>''",
	'ratinghistory-period' => 'Prantad :',
	'ratinghistory-month' => 'miz diwezhañ',
	'ratinghistory-3months' => '3 miz diwezhañ',
	'ratinghistory-year' => 'bloaz tremenet',
	'ratinghistory-3years' => 'tri bloaz diwezhañ',
	'ratinghistory-ave' => 'Keidenn : $1',
	'ratinghistory-purge' => 'riñsañ ar grubuilh',
	'ratinghistory-users' => 'Implijerien o deus priziet traoù',
	'ratinghistory-graph' => '$2 war "$3" ($1 {{PLURAL:$1|adweladenn|adweladenn}})',
	'ratinghistory-svg' => 'Gwelet evel SVG',
	'ratinghistory-table-rating' => 'Priziañ',
	'ratinghistory-table-votes' => 'Mouezhioù',
	'ratinghistory-ratings' => "'''Alc'hwez :''' '''(1)''' - Fall ; '''(2)''' - Dister ; '''(3)''' - Etre ; '''(4)''' - Mat ; '''(5)''' - Dreist.",
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
	'ratinghistory-svg' => 'Pregledaj kao SVG',
	'ratinghistory-table-rating' => 'Rejting',
	'ratinghistory-table-votes' => 'Glasovi',
	'ratinghistory-none' => 'Trenutno nema dovoljno podataka povratne veze čitaoca za prikaz grafikonom.',
	'ratinghistory-ratings' => "'''Objašnjenje:''' '''(1)''' - Slabo; '''(2)''' - Nisko; '''(3)''' - Dobro; '''(4)''' - Visoko; '''(5)''' - Odlično;",
	'ratinghistory-legend' => "'''Broj pregleda po danu''' <font color=\"red\">''(crveno)''</font>, '''dnevni prosječni rejting''' <font color=\"blue\">''(plavo)''</font> i  
'''tekući prosječni rejting''' <font color=\"green\">''(zeleno)''</font> je prikazan na grafikonu ispod, po datumu.
'''Tekući prosječni rejting''' je jednostavni prosjek svih dnevnih rejtinga ''unutar'' ovog vremenskog perioda za svaki dan.

Rejtinzi su slijedeći:

'''[1]''' - Slab; '''[2]''' - Loš; '''[3]''' - Solidan; '''[4]''' - Visok; '''[5]''' - odličan;",
	'ratinghistory-graph-scale' => "'''Provjere po danu''' <font color=\"red\">''(crveno)''</font> prikazano u razmjeri ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Děkujeme, že jste {{GENDER:|věnoval|věnovala|věnovali}} čas hodnocení této stránky!</font>''",
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
	'ratinghistory-legend' => "Následující graf zobrazuje '''počet hodnocení za den''' <font color=\"red\">''(červeně)''</font>, '''průměrné hodnocení daný den''' <font color=\"blue\">''(modře)''</font>
a '''klouzavý průměr hodnocení''' <font color=\"green\">''(zeleně)''</font> podle data.
'''Klouzavý průměr hodnocení''' je jednoduše průměr všech denních hodnocení v rámci příslušného období pro každý den.
Hodnocení jsou:

'''(1)''' – Slabé; '''(2)''' – Nízké; '''(3)''' – Dobré; '''(4)''' – Vysoké; '''(5)''' – Vynikající",
	'ratinghistory-graph-scale' => "'''Počet hodnocení/den''' <font color=\"red\">''(červeně)''</font> zobrazen v měřítku ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Tak fordi at du brugte tid til at bedømme denne side!</font>''",
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
	'ratinghistory-legend' => "Det '''daglige antal bedømmelser''' <font color=\"red\">''(rød)''</font>, den '''daglige gennemsnitsbedømmelse''' <font color=\"blue\">''(blå)''</font>
og '''løbende gennemsnitsbedømmelse''' <font color=\"green\">''(grøn)''</font> vises i grafen nedenfor efter dato.
Den '''løbende gennemsnitsbedømmelse''' er simpelthen gennemsnittet af alle de daglige bedømmelser ''inden for'' tidsperioden for hver dag.
Bedømmelserne er:

'''[1]''' - Meget dårlig; '''[2]''' - Dårlig; '''[3]''' - Middel; '''[4]''' - God; '''[5]''' - Meget god;",
	'ratinghistory-graph-scale' => "'''Bedømmelser per dag''' <font color=\"red\">''(rød)''</font> vist i forholdet ''1:\$1''.",
	'right-feedback' => 'Brug tilbagemeldingsformularen til at bedømme en side',
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
	'ratinghistory-svg' => 'Als SVG ansehen',
	'ratinghistory-table-rating' => 'Bewertung',
	'ratinghistory-table-votes' => 'Stimmen',
	'ratinghistory-none' => 'Es gibt noch nicht genug Seitenbewertungen durch Leser, um eine Grafik zu erstellen.',
	'ratinghistory-ratings' => "'''Legende:''' '''(1)''' - {{int:readerfeedback-level-0}}; '''(2)''' - {{int:readerfeedback-level-1}}; '''(3)''' - {{int:readerfeedback-level-2}}; '''(4)''' - {{int:readerfeedback-level-3}}; '''(5)''' - {{int:readerfeedback-level-4}}",
	'ratinghistory-legend' => "Die '''tägliche Zahl an Sichtungen''' <font color=\"red\">''(rot)''</font>, '''Bewertungs-Tagesdurchschnitt''' <font color=\"blue\">''(blau)''</font>
und der '''Durchschnitt über den ausgewählten Zeitraum''' <font color=\"green\">''(grün)''</font> werden nachfolgend nach Datum sortiert angezeigt.
Der '''Durchschnitt im ausgewählten Zeitraum''' ist der Durchschnitt aller Tagesbewertungen ''innerhalb'' dieser Zeitspanne.

Die Bewertung erfolgt nach:
'''(1)''' - {{int:readerfeedback-level-0}}; '''(2)''' - {{int:readerfeedback-level-1}}; '''(3)''' - {{int:readerfeedback-level-2}}; '''(4)''' - {{int:readerfeedback-level-3}}; '''(5)''' - {{int:readerfeedback-level-4}};",
	'ratinghistory-graph-scale' => "Die '''tägliche Zahl an Sichtungen''' <font color=\"red\">''(rot)''</font> werden im Maßstab ''1:\$1'' angezeigt.",
	'right-feedback' => 'Das Feedback-Formular zur Bewertung einer Seite benutzen',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Pill
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'ratinghistory-thanks' => "''<font color=\"darkred\">Danke, dass Sie sich für die Bewertung dieser Seite einen Moment Zeit genommen haben!</font>''",
);

/** Zazaki (Zazaki)
 * @author Aspar
 */
$messages['diq'] = array(
	'ratinghistory' => 'tarixê derecekerdışê peli',
	'ratinghistory-leg' => 'qey ıney [[:$1|$1]] tarixê datayê derecekerdışi',
	'ratinghistory-tab' => 'derecekerdış',
	'ratinghistory-link' => 'derecekerdışê peli',
	'ratinghistory-thanks' => "''<font color=\"darkred\">ma zaf tşk keni şıma çımçarna no pel!</font>''",
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
	'ratinghistory-legend' => "'''bınızdi çımçarnayişê yew roci''' <font color=\"red\">''(sûr)''</font>, '''bınızdî derecekerdışê yew roci''' <font color=\"blue\">''(kewe)''</font>
u '''bınızdi derecekerdışê xebati''' <font color=\"green\">''(kesk/aşıl)''</font> cêr de goreyê tarixi xet bı.
''''''bınızdi derecekerdışê xebati''', istatiskê derecekerdışê qey her yew roci yo.
Derecekerdış zey cêrın o:

'''(1)''' - zayif; '''(2)''' - kêm; '''(3)''' - adil; '''(4)''' - berz; '''(5)''' - mukemmel;",
	'ratinghistory-graph-scale' => "'''çımçarnayişê roceyi''' no qistas de <font color=\"red\">''(sûr)''</font> ''1:\$1'' ramociyeno.",
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
	'ratinghistory-svg' => 'Ako SVG zwobrazniś',
	'ratinghistory-table-rating' => 'Pógódnośenje',
	'ratinghistory-table-votes' => 'Głose',
	'ratinghistory-none' => 'Tuchylu njejo dosć pógódnośenjow wót cytarjow, aby napórało grafiku.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojecy; '''(4)''' - Wusoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-legend' => "'''Dnjowna licba pśeglědanjow''' <font color=\"red\">''(cerwjeny)''</font>, '''dnjowne pśerězne gódnośenje''' <font color=\"blue\">''(módry)''</font> a  
'''pśerězne gódnośenje za wubrany cas''' <font color=\"green\">''(zeleny)''</font> zwobraznjuju se dołojce pó datumje. '''Pśerězne gódnośenje za wubrany cas''' jo jadnorje pśerězk wšych dnjownych pógódnośenjow ''w'' toś tom casowem wótrězku kuždego dnja.

Gódnośenja su ako slědujuce:

'''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojecy; '''(4)''' - Wusoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-graph-scale' => "'''Pśeglědanja na źeń''' <font color=\"red\">''(cerwjeny)''</font> pokazujo se w měritku ''1:\$1''.",
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
	'ratinghistory-svg' => 'Vidi kiel SVG',
	'ratinghistory-table-rating' => 'Takso',
	'ratinghistory-table-votes' => 'Voĉdonoj',
	'ratinghistory-none' => 'Ne sufiĉas datenoj de legintoj por grafeoj ĉi-momente.',
	'ratinghistory-ratings' => "'''Klarigeto:''' '''(1)''' - Malbonega; '''(2)''' - Malbona; '''(3)''' - Mezgrada; '''(4)''' - Bona; '''(5)''' - Bonega;",
	'ratinghistory-legend' => "La '''tage averaĝa taksado''' <font color=\"blue\">''(blua)''</font> kaj 
'''intervalaveraĝa taksado''' <font color=\"green\">''(verda)''</font> estas montrita en la jena grafeo, laŭ dato. La
'''intervalaveraĝa taksado''' estas simiple la averaĝo de ĉiuj tagaj taksaĵoj ''inter'' ĉi tiu tempdaŭro por ĉiu tago.
Jen la taksada skalo:

'''[1]''' - Malbonega; '''[2]''' - Malbonkvalita; '''[3]''' - Mezkvalita; '''[4]''' - Bonkvalita; '''[5]''' - Bonega;",
	'ratinghistory-graph-scale' => "'''Kontroloj por tago''' <font color=\"red\">''(red)''</font> montrata po ''1:\$1'' skalo.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Gracias por tomarte un momento para revisar esta página!</font>''",
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
	'ratinghistory-legend' => "El '''número de revisiones diarias''' <font color=\"red\">''(rojo)''</font>, '''valoración promedio diaria''' <font color=\"blue\">''(azul)''</font> y
'''valoración promedio de ejecución''' <font color=\"green\">''(verde)''</font> están graficados abajo, por fecha. 
La  '''valoración promedio de ejecución''' es simplemente el promedio de todas las valoraciones diarias ''dentro'' de este marco temporal por cada día.
Las valoraciones son como siguen:

'''(1)''' - Pobre; '''(2)''' - Bajo; '''(3)''' - Regular; '''(4)''' - Alto; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "'''Revisiones por día''' <font color=\"red\">''(rojo)''</font> mostradas en una escala de ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Aitäh, et leidsid aega selle lehekülje hindamiseks!</font>''",
	'ratinghistory-period' => 'Ajavahemik:',
	'ratinghistory-month' => 'viimane kuu',
	'ratinghistory-3months' => 'viimased 3 kuud',
	'ratinghistory-year' => 'viimane aasta',
	'ratinghistory-3years' => 'viimased 3 aastat',
	'ratinghistory-ave' => 'Keskmine: $1',
	'ratinghistory-purge' => 'tühjenda vahemälu',
	'ratinghistory-table' => 'Lugejahinnangute ülevaade',
	'ratinghistory-users' => 'Hinnanud kasutajad',
	'ratinghistory-graph' => 'Lehekülje "$3" {{lcfirst:$2}} ($1 {{PLURAL:$1|arvustus|arvustust}})',
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
 * @author Huji
 * @author Ladsgroup
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
	'ratinghistory-graph' => '$3 از $2($1 {{PLURAL:$1|خواننده|خواننده}})',
	'ratinghistory-svg' => 'نمایش به شکل SVG',
	'ratinghistory-table-rating' => 'ارزش‌دهی',
	'ratinghistory-table-votes' => 'آرا',
	'ratinghistory-none' => 'در حال حاضر بازخورد کافی از خوانندگان برای نمایش نمودار وجود ندارد.',
	'ratinghistory-legend' => "نمره متوسط روزانه <font color=\"blue\">''(آبی)''</font> و نمره متوسط برای بازهٔ زمانی انتخاب شده <font color=\"green\">''(سبز)''</font> در نمودار زیر، بر حسب تاریخ نشان داده شده‌اند. مقدار نمره‌ها به صورت زیر تعبیر می‌شود:

'''[۰]''' - ضعیف؛ '''[۱]''' - پایین؛ '''[۲]''' - متوسط؛ '''[۳]''' - بالا؛ '''[۴]''' - ممتاز؛",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Kiitos, että tarkistit tämän sivun!</font>''",
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
	'ratinghistory-legend' => "'''Päivittäinen arviointimäärä''' <font color=\"red\">''(punainen)''</font>, '''päivittäinen keskiarvo''' <font color=\"blue\">''(sininen)''</font>
ja '''valitun ajanjakson keskiarvo''' <font color=\"green\">''(vihreä)''</font> on listattu alla päivämäärän mukaan lajiteltuna.
'''Valitun ajanjakson arviointien keskiarvo''' on yksinkertaisesti kaikkien päivittäisten arvioiden keskiarvo tämän aikavälin ''sisällä'' joka päivältä.
Arvioinnit ovat seuraavia:

'''(1)''' – {{int:readerfeedback-level-0}}; '''(2)''' – {{int:readerfeedback-level-1}}; '''(3)''' – {{int:readerfeedback-level-2}}; '''(4)''' – {{int:readerfeedback-level-3}}; '''(5)''' – {{int:readerfeedback-level-4}}",
	'ratinghistory-graph-scale' => "'''Arvioita päivittäin''' <font color=\"red\">''(punainen)''</font> näkyy ''1:\$1''-mittakaavassa.",
	'right-feedback' => 'Käyttää palautelomaketta sivujen arvosteluun',
);

/** French (Français)
 * @author ChrisPtDe
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Merci d'avoir consacré du temps pour relire cette page !</font>''",
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
	'ratinghistory-graph' => '$2 sur « $3 » ($1 relecture{{PLURAL:$1||s}})',
	'ratinghistory-svg' => 'Voir en SVG',
	'ratinghistory-table-rating' => 'Évaluation',
	'ratinghistory-table-votes' => 'Votes',
	'ratinghistory-none' => "Il n’y a pas suffisamment d'avis exprimés par des lecteurs pour établir des graphiques pour l'instant.",
	'ratinghistory-ratings' => "'''Légende :''' '''(1)''' - Mauvais ; '''(2)''' - Médiocre ; '''(3)''' - Moyen ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-legend' => "Le '''nombre d'évaluations par jour''' <font color=\"red\">''(rouge)''</font>, l''''évaluation moyenne par jour''' <font color=\"blue\">''(bleu)''</font> et l''''évaluation moyenne en cours''' <font color=\"green\">''(vert)''</font> sont représentées graphiquement ci-dessous, par date.
L''''évaluation moyenne en cours''' est simplement la moyenne de toutes les évaluations quotidiennes ''dans'' la période du jour choisie.
Les notations sont les suivantes :

'''(1)''' - Mauvais ; '''(2)''' - Médiocre ; '''(3)''' - Moyen ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-graph-scale' => "'''Évaluations par jour''' <font color=\"red\">''(rouge)''</font> affichées à l'échelle ''1:\$1''.",
	'right-feedback' => "Utiliser le formulaire de retour d'informations pour évaluer une page",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'ratinghistory' => 'Historico de l’èstimacion de la pâge.',
	'ratinghistory-leg' => 'Balyês de l’historico de les èstimacions por [[:$1|$1]]',
	'ratinghistory-tab' => 'èstimacion',
	'ratinghistory-link' => 'Èstimacion de la pâge',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Grant-marci d’avêr consacrâ de temps por revêre ceta pâge !</font>''",
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
	'ratinghistory-legend' => "Lo '''nombro de rèvisions per jorn''' <font color=\"red\">''(rojo)''</font>, l’'''èstimacion moyena per jorn''' <font color=\"blue\">''(blu)''</font>
et l’'''èstimacion moyena por lo temps chouèsi''' <font color=\"green\">''(vèrd)''</font> sont reprèsentâs desot fôrma de diagramo ce-desot, per dâta.
L’'''èstimacion moyena por lo temps chouèsi''' est simplament la moyena de totes les èstimacions de tôs los jorns ''dedens'' lo temps chouèsi.
Les èstimacions sont cetes :

'''(1)''' - Crouyo ; '''(2)''' - Prod moyen ; '''(3)''' - Moyen ; '''(4)''' - Bon ; '''(5)''' - Famox.",
	'ratinghistory-graph-scale' => "'''Èstimacions per jorn''' <font color=\"red\">''(rojo)''</font> montrâs a l’èchiéla ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Grazas por revisar esta páxina!</font>''",
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
	'ratinghistory-legend' => "O '''número de revisións ao día''' <font color=\"red\">''(vermello)''</font>, a '''valoración da media diario''' <font color=\"blue\">''(azul)''</font> e a '''valoración da media en curso''' <font color=\"green\">''(verde)''</font> están, por data, na gráfica de embaixo.
A '''valoración da media en curso''' é simplemente a valoración de todas as valoracións diarias ''dentro'' do período de tempo de cada día.
As valoracións son como segue:

'''(1)''' - Pobre; '''(2)''' - Baixa; '''(3)''' - Boa; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "As '''revisións por día''' <font color=\"red\">''(vermello)''</font> móstranse cunha escala de ''1:\$1''.",
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
	'ratinghistory-svg' => 'As SVG aaluege',
	'ratinghistory-table-rating' => 'Bewärtig',
	'ratinghistory-table-votes' => 'Stimme',
	'ratinghistory-none' => 'S git nonig gnue Sytebewärtige dur Läser zum e Grafik aazlege.',
	'ratinghistory-ratings' => "'''Legänd:''' '''(1)''' - Mangelhaft; '''(2)''' - Längt uus; '''(3)''' - Mittel; '''(4)''' - Guet; '''(5)''' - Exzellänt;",
	'ratinghistory-legend' => "D '''täglig aazahl vu Bewärtige''' <font color=\"red\">''(rot)''</font>, dr '''Durchschnitt vu Bewärtige am Tag''' <font color=\"blue\">''(blau)''</font>,
un dr '''Durchschnitt iber dr usgwehlt Zytruum''' <font color=\"green\">''(grün)''</font> wäre do aazeigt no Datum sortiert.
Dr '''Durchschnitt iber dr usgwehlt Zytruum''' isch eifach dr Durchschnitt vu Bewärtige vu allene täglige Bewärtige ''in'' däm Zytruum fir jede Tag.
Des sin d Bewärtige:

'''[1]''' - isch Mangelhaft; '''[2]''' - Längt uus; '''[3]''' - Goht; '''[4]''' - isch Guet; '''[5]''' - isch Seli guet;",
	'ratinghistory-graph-scale' => "'''Priefige am Tag''' <font color=\"red\">''(red)''</font> uf ere ''1:\$1'' Skala.",
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
	'ratinghistory-svg' => 'הצגה כ־SVG',
	'ratinghistory-table-rating' => 'דירוג',
	'ratinghistory-table-votes' => 'הצבעות',
	'ratinghistory-none' => 'אין כרגע מספיק מידע זמין של משוב קוראים ליצירת תרשימים',
	'ratinghistory-ratings' => "'''מקרא:''' '''(1)''' - גרוע; '''(2)''' - נמוך; '''(3)''' - בינוני; '''(4)''' - גבוה; '''(5)''' - מצוין;",
	'ratinghistory-legend' => "'''המספר היומי של דירוגים''' <font color=\"red\">''(אדום)''</font>, '''ממוצע הדירוגים היומי''' <font color=\"blue\">''(כחול)''</font>,
	ו'''ממוצע הדירוגים לאורך זמן''' <font color=\"green\">''(ירוק)''</font> מוצגים להלן בגרף, לפי תאריך.
	'''ממוצע הדירוגים לאורך זמן''' הוא פשוט הממוצע של כל הדירוגים היומיים ''בתוך'' מסגרת הזמן הזו לכל יום.
	הדירוגים הם כלהלן:
	
	'''(1)''' - גרוע; '''(2)''' - נמוך; '''(3)''' - בינוני; '''(4)''' - גבוה; '''(5)''' - מצוין;",
	'ratinghistory-graph-scale' => "'''סקירות ליום''' <font color=\"red\">''(אדום)''</font> מופיעות ביחס של ''1:\$1''.",
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
	'ratinghistory-svg' => 'Jako SVG wobhladać',
	'ratinghistory-table-rating' => 'Pohodnoćenje',
	'ratinghistory-table-votes' => 'Hłosy',
	'ratinghistory-none' => 'Za grafiki hišće dosć pohódnoćenjow wot čitarjow k dispoziciji njesteji',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojacy; '''(4)''' - Wysoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-legend' => "'''Dnjowa ličba pruwowanjow''' <font color=\"red\">''(čerwjeny)''</font>, '''dnjowe přerězne hódnoćenje''' <font color=\"blue\">''(módry)''</font> a '''běžne přerězne hódnoćenje''' <font color=\"green\">''(zeleny)''</font> su deleka po datumje grafisce zwobraznjene.
'''Běžne přerězne hódnoćenje''' je prosće přerězk wšěch dnjowych hódnoćenjow ''znutřka'' tutoho časoweho wotrězka za kóždy dźeń.
Hódnoćenja su kaž tele:


'''(1)''' - Špatny; '''(2)''' - Niski; '''(3)''' - Spokojacy; '''(4)''' - Wysoki; '''(5)''' - Ekscelentny;",
	'ratinghistory-graph-scale' => "'''Pruwowanja na dźeń''' <font color=\"red\">''(čerwjeny)''</font> pokazowane w měritku ''1:\$1''.",
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
	'ratinghistory-purge' => 'gyorsítótár kiürítése',
	'ratinghistory-table' => 'Olvasói értékelések áttekintése',
	'ratinghistory-users' => 'Szerkesztők, akik értékelték a lapot',
	'ratinghistory-graph' => '$2 a „$3” oldalon ($1 {{PLURAL:$1|értékelés|értékelés}})',
	'ratinghistory-svg' => 'Megtekintés SVG formátumban',
	'ratinghistory-table-rating' => 'Értékelés',
	'ratinghistory-table-votes' => 'Szavazatok',
	'ratinghistory-none' => 'Jelenleg még nem áll rendelkezésre elég visszajelzés a grafikonok elkészítéséhez.',
	'ratinghistory-ratings' => "'''Magyarázat:''' '''[1]''' – rossz; '''[2]''' – gyenge; '''[3]''' – közepes; '''[4]''' – jó; '''[5]''' – kitűnő;",
	'ratinghistory-legend' => "Alább a '''napi értékelések száma ''' <font color=\"red\">''(vörös)''</font>, a '''napi átlagos értékelés''' <font color=\"blue\">''(kék)''</font> és a '''megadott időtartam alatti átlagos értékelés''' <font color=\"green\">''(zöld)''</font> grafikonja látható, dátum szerint. A '''megadott időtartam alatti átlagos értékelés''' egyszerűen az összes napi értékelés átlaga a megadott időtartam '''alatt'''.

Az értékek a következők lehetnek:

'''[1]''' – rossz; '''[2]''' – gyenge; '''[3]''' – közepes; '''[4]''' – jó; '''[5]''' – kitűnő;",
	'ratinghistory-graph-scale' => "'''Visszajelzés / nap ''' <font color=\"red\">''(vörös színnel)''</font> ''1:\$1'' skálán megjelenítve.",
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
	'ratinghistory-svg' => 'Vider como SVG',
	'ratinghistory-table-rating' => 'Evalutation',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Non es disponibile sufficiente datos de evalutationes de lectores pro poter facer graphicos al momento.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Mal; '''(2)''' - Mediocre; '''(3)''' - Acceptabile; '''(4)''' - Bon; '''(5)''' - Excellente;",
	'ratinghistory-legend' => "Le '''numero de recensiones per die''' <font color=\"red\">''(rubie)''</font>, '''evalutation medie per die''' <font color=\"blue\">''(blau)''</font> e
'''evalutation medie currente''' <font color=\"green\">''(verde)''</font> es representate infra, per data. Le  
'''evalutation medie currente''' es simplemente le media de tote le evalutationes per die ''intra'' iste periodo de tempore pro cata die.
Le evalutationes es como seque:

'''(1)''' - Mal; '''(2)''' - Mediocre; '''(3)''' - Acceptabile; '''(4)''' - Bon; '''(5)''' - Excellente;",
	'ratinghistory-graph-scale' => "Le '''numero de recensiones per die''' <font color=\"red\">''(rubie)''</font> es monstrate in scala ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Terima kasih Anda telah meninjau halaman ini!</font>''",
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
	'ratinghistory-legend' => "'''Jumlah tinjauan harian''' <font color=\"red\">''(merah)''</font>, '''Rata-rata peringkat harian''' <font color=\"blue\">''(biru)''</font> dan '''rata-rata peringkat interval''' <font color=\"green\">''(hijau)''</font> ditampilkan dalam grafik di bawah ini, menurut tanggal.

'''Rata-rata peringkat interval''' adalah rata-rata semua peringkat harian ''di antara'' jangka waktu tertentu setiap harinya.

Peringkatnya adalah sebagai berikut: 
'''[1]''' - Buruk; '''[2]''' - Rendah; '''[3]''' - Cukup; '''[4]''' - Tinggi; '''[5]''' - Baik sekali;",
	'ratinghistory-graph-scale' => "'''Tinjauan per hari''' <font color=\"red\">''(merah)''</font> ditunjukkan dengan skala ''1:\$1''.",
	'right-feedback' => 'Gunakan formulir umpan balik untuk memberikan peringkat halaman',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Gianfranco
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
	'ratinghistory-svg' => 'Visualizza come SVG',
	'ratinghistory-table-rating' => 'Giudizio',
	'ratinghistory-table-votes' => 'Voti',
	'ratinghistory-none' => 'Non sono disponibile sufficienti dati di feedback dei lettori per poter rappresentare dei grafici al momento.',
	'ratinghistory-legend' => "Il '''numero giornaliero di valutazioni''' <font color=\"red\">''(rosso)''</font>, il '''giudizio medio giornaliero''' <font color=\"blue\">''(blu)''</font> ed i '''giudizi medi correnti''' <font color=\"green\">''(verde)''</font> sono rappresentati graficamente di seguito, in ordine di data. I '''giudizi medi correnti''' sono semplicemente la media di tutti i giudizi giornalieri ''all'interno'' di questo arco temporale per ciascun giorno.
I giudizi sono i seguenti:

Scala: '''[1]''' - Insufficiente; '''[2]''' - Mediocre; '''[3]''' - Discreto; '''[4]''' - Buono; '''[5]''' - Eccellente;",
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
	'ratinghistory-graph' => '「$3」の$2 ($1回の{{PLURAL:$1|評価}})',
	'ratinghistory-svg' => 'SVGとして表示',
	'ratinghistory-table-rating' => '評価',
	'ratinghistory-table-votes' => '票数',
	'ratinghistory-none' => '現時点ではグラフを表示するのに十分な読者評価データがありません。',
	'ratinghistory-ratings' => "'''凡例:''' '''(1)''' - ひどい; '''(2)''' - 低い; '''(3)''' - 可; '''(4)''' - 高い; '''(5)''' - すばらしい;",
	'ratinghistory-legend' => "日ごとの'''日間総評価数''' <font color=\"red\">''(赤)''</font>、'''日間平均評価''' <font color=\"blue\">''(青)''</font> 、'''連続平均評価''' <font color=\"green\">''(緑)''</font> を以下のグラフに表示します。'''連続平均評価'''は、各日のこの時間帯の評価の平均です。
評価の尺度は以下の通りです。

'''[1]''' - {{int:readerfeedback-level-0}}、'''[2]''' - {{int:readerfeedback-level-1}}、'''[3]''' - {{int:readerfeedback-level-2}}、'''[4]''' - {{int:readerfeedback-level-3}}、'''[5]''' - {{int:readerfeedback-level-4}}",
	'ratinghistory-graph-scale' => "'''日あたりの評価数''' <font color=\"red\">''(赤)''</font> を ''1:\$1'' の縮尺で表示しています。",
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
 */
$messages['ka'] = array(
	'ratinghistory-thanks' => "''<font color=\"darkred\">გმადლობთ, რომ გამონახეთ დრო ამ გვერდის შესაფასებლად!</font>''",
	'ratinghistory-period' => 'დროის მონაკვეთი:',
	'ratinghistory-month' => 'ბოლო თვე',
	'ratinghistory-3months' => 'ბოლო 3 თვე',
	'ratinghistory-year' => 'ბოლო წელი',
	'ratinghistory-3years' => 'ბოლო 3 წელი',
	'ratinghistory-ave' => 'საშ: $1',
	'ratinghistory-chart' => 'ყველა დროის მკითხველთა შეფასებები',
	'ratinghistory-purge' => 'ქეშის გაწმენდა',
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
	'ratinghistory-svg' => 'មើល​ជា SVG',
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
	'ratinghistory-ave' => '평균: $1',
	'ratinghistory-svg' => 'SVG로 보기',
	'ratinghistory-ratings' => "'''범례:''' '''(1)''' - 최하, '''(2)''' - 낮음, '''(3)''' - 양호, '''(4)''' - 높음, '''(5)''' - 우수",
	'right-feedback' => '문서를 평가하는 피드백 양식을 이용',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'ratinghistory' => 'Verlouf vun de Enschäzunge',
	'ratinghistory-leg' => 'Enschäzunge för de Sigg „[[:$1|$1]]“ en der Verjangeheit',
	'ratinghistory-tab' => 'Enschäzung',
	'ratinghistory-link' => 'Enschäzunge',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Ene schöne Dangk un märßie för et Nohkike!</font>''",
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
	'ratinghistory-legend' => "Dä '''dääschlesche Dorschnett vun de Enschäzunge''' <font color=\"red\">''(en ruhd)''</font> un dä 
'''loufende Dorschnett vun de Enschäzunge''' <font color=\"blue\">''(en blou)''</font> sin unge opjemohlt, pro Dattum. Dä '''loufende Dorschnett''' es eijfach dä Dorschnett fun all dä dääschlesche Enschäzunge ''ennerhallef'' fun däm Zick_Afschnet för jeede Daach.

Lejend fun de Enschäzunge: '''(1)''' = {{int:readerfeedback-level-0}}, '''(2)''' = {{int:readerfeedback-level-1}}, '''(3)''' = {{int:readerfeedback-level-2}}, '''(4)''' = {{int:readerfeedback-level-3}}, '''(5)''' = {{int:readerfeedback-level-4}}.",
	'ratinghistory-graph-scale' => "'''Enschätzunge der Daach''', <font color=\"red\">''(rud)''</font> aanjezeisch em Maaßschtaab ''1 zoh \$1''.",
	'right-feedback' => 'Enschäzunge afjevve un Note för Sigge verdeile',
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Merci datt Dir Iech en Ament Zäit huelt fir dës Säit nozekucken!</font>''",
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
	'ratinghistory-legend' => "D''''Deeglech Zuel vun de Bewäertungen''' <font color=\"red\">''(rout)''</font>, '''Duerchschnëtt vun der deeglecher Bewäertung''' <font color=\"blue\">''(blo)''</font> 
an de '''momentanen Duerchschnëtt vun der Bewäertung''' <font color=\"green\">''(gréng)''</font> sinn ënnendrënner grafesch pro Dag duergestallt.
De '''momentanen Duerchschnëtt vun der Bewäertung''' ass einfach den Duerchschnëtt vun allen deegleche Bewäertunge ''bannent'' dësem Zäitraum fir all Dag.

D'Bewäertung gouf esu gemaach:

'''[1]''' - Aarmséileg; '''[2]''' - Niddreg; '''[3]''' - An der Rei; '''[4]''' - Héich; '''[5]''' - Exzellent;",
	'ratinghistory-graph-scale' => "D''''Zuel vun de Bewäertunge pro Dag''' <font color=\"red\">''(rout)''</font> gëtt an der Grafik ënnendrënner op enger ''1:\$1'' Skala gewisen.",
	'right-feedback' => 'De Feedback-Formulaire benotze fir eng Säit ze bewerten',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'ratinghistory-3years' => 'aafgeloupe 3 jaor',
	'ratinghistory-graph' => '$2 van "$3" ($1 {{PLURAL:$1|waardering|waarderinge}})',
	'ratinghistory-svg' => 'Bekiek es SVG',
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Благодариме за вашето одвоено време за оценување на оваа страница!</font>''",
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
	'ratinghistory-svg' => 'Поглед како SVG',
	'ratinghistory-table-rating' => 'Оцена',
	'ratinghistory-table-votes' => 'Гласови',
	'ratinghistory-none' => 'Нема доволно податоци од оценувачите за исцртување на графиконот во овој момент.',
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' - Слабо; '''(2)''' - Ниско; '''(3)''' - Средно; '''(4)''' - Високо; '''(5)''' - Одлично;",
	'ratinghistory-legend' => "'''Дневниот број на оценки''' <font color=\"red\">''(црвено)''</font>, '''просечна дневна оценка''' <font color=\"blue\">''(сино)''</font>,
и '''тековна просечна оценка''' <font color=\"green\">''(green)''</font> се прикажани на графикот подолу, по датум.
'''Тековна просечна оценка''' е прост просек од сите дневни оценки ''во рамките на'' овој временски период за секој ден.
Еве ги оценките:

'''(1)''' - Слабо; '''(2)''' - Ниско; '''(3)''' - Средно; '''(4)''' - Високо; '''(5)''' - Одлично;",
	'ratinghistory-graph-scale' => "'''Бројот на оценки за еден ден''' <font color=\"red\">''(црвено)''</font> е прикажан во размер ''1:\$1''.",
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
	'ratinghistory-thanks' => '<font color="darkred">ഈ താൾ സംശോധനം ചെയ്യുവാൻ സമയം കണ്ടെത്തിയതിനു നന്ദി!</font>',
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
	'ratinghistory-legend' => "'''ദിവസേനയുള്ള സംശോധനങ്ങളുടെ എണ്ണം''' <font color=\"red\">''(ചുവപ്പ്)''</font>, '''ദിവസേനയുള്ള ശരാശരി മതിപ്പ്''' <font color=\"blue\">''(നീല)''</font>,
'''ഇപ്പോഴുള്ള ശരാശരി മതിപ്പ്''' <font color=\"green\">''(പച്ച)''</font> എന്നിവ തീയതിയനുസരിച്ച് താഴെ കൊടുത്തിരിക്കുന്നു.
'''ഇപ്പോഴുള്ള ശരാശരി മതിപ്പ്''' എന്നത് ദിവസംപ്രതി ''ഈ സമയത്തുള്ള'' നിലവാരമതിപ്പിന്റെ ശരാശരിയാണ്.
നിലവാര മതിപ്പുകൾ താഴെ കൊടുക്കുന്നു:

'''(1)''' - ദരിദ്രം; '''(2)''' - മോശം; '''(3)''' - കൊള്ളാം; '''(4)''' - ഉന്നതം; '''(5)''' - ഒന്നാന്തരം;",
	'ratinghistory-graph-scale' => "'''ദിവസവുമുള്ള സംശോധനങ്ങൾ''' <font color=\"red\">''(ചുവപ്പ്)''</font> ''1:\$1'' തോതിൽ കാട്ടുന്നു.",
	'right-feedback' => 'താളിനു നിലവാരമിടാനായി അഭിപ്രായമറിയിക്കാനുള്ള ഫോം ഉപയോഗിക്കുക',
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
	'ratinghistory-svg' => 'Tiquittāz quemeh SVG',
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
	'ratinghistory-svg' => 'Als SVG bekijken',
	'ratinghistory-table-rating' => 'Waardering',
	'ratinghistory-table-votes' => 'Stemmen',
	'ratinghistory-none' => 'Er is onvoldoende terugkoppeling van lezers aanwezig om een grafiek te maken.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Slecht; '''(2)''' - Laag; '''(3)''' - Redelijk; '''(4)''' - Hoog; '''(5)''' - Uitstekend;",
	'ratinghistory-legend' => "Het '''aantal dagelijkse beoordelingen''' <font color=\"red\">''(rood)''</font>, de '''dagelijkse gemiddelde waardering''' <font color=\"blue\">''(blauw)''</font> en
de '''gemiddelde waardering van de aangegeven periode''' <font color=\"green\">''(groen)''</font> staan hieronder in een grafiek op datum.
De '''gemiddelde waardering van de aangegeven periode''' is het gemiddelde van alle dagelijkse gemiddelde waarderingen ''binnnen'' dit tijdvak voor iedere dag.

'''(1)''' - Slecht; '''(2)''' - Laag; '''(3)''' - Redelijk; '''(4)''' - Hoog; '''(5)''' - Uitstekend;",
	'ratinghistory-graph-scale' => "'''Beoordelingen per dag''' <font color=\"red\">''(rood)''</font> worden weergegeven op de schaal ''1:\$1''.",
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
	'ratinghistory-svg' => 'Syn som SVG',
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
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'ratinghistory' => 'Sidens vurderingshistorikk',
	'ratinghistory-leg' => 'Vurderingshistorikkdata for [[:$1|$1]]',
	'ratinghistory-tab' => 'vurdering',
	'ratinghistory-link' => 'Sidevurdering',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Takk for at du tar deg tid til å anmelde denne siden!</font>''",
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
	'ratinghistory-legend' => "Det '''daglige antall vurderinger''' <font color=\"red\">''(rød)''</font>, den '''daglige gjennomsnittsvurderingen''' <font color=\"blue\">''(blå)''</font> og '''løpende gjennomsnittsvurdering''' <font color=\"green\">''(grønn)''</font> vises i grafen under etter dato.
Den '''løpende gjennomsnittsvurderingen''' er rett og slett gjennomsnittet av all de daglige vurderingene ''innen'' denne tidsperioden for hver dag.
Vurderingene er som følger:

'''[1]''' - Veldig dårlig; '''[2]''' - Dårlig; '''[3]''' - OK; '''[4]''' - Bra; '''[5]''' - Veldig bra;",
	'ratinghistory-graph-scale' => "'''Vurderinger per dag''' <font color=\"red\">''(rød)''</font> vist i forholdet ''1:\$1''.",
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
	'ratinghistory-svg' => 'Veire en SVG',
	'ratinghistory-table-rating' => 'Notacion',
	'ratinghistory-table-votes' => 'Vòts',
	'ratinghistory-none' => 'En aqueste moment, i a pas pro de lectors de donadas de notacion pels grafics.',
	'ratinghistory-ratings' => "'''Legenda :''' '''(1)''' - Marrit ; '''(2)''' - Mediòcre ; '''(3)''' - Mejan ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-legend' => "Lo '''nombre d'avaloracions per jorn''' <font color=\"red\">''(roge)''</font>, l''''avaloracion mejana per jorn''' <font color=\"blue\">''(blau)''</font> e l''''avaloracion mejana en cors''' <font color=\"green\">''(verd)''</font> son representadas graficament çaijós, per data.
L''''avaloracion mejana en cors''' es simplament la mejana de totas las avaloracions quotidianas ''dins'' lo periòde del jorn causit.
Las notacions son las seguentas :

'''(1)''' - Marrit ; '''(2)''' - Mediòcre ; '''(3)''' - Mejan ; '''(4)''' - Bon ; '''(5)''' - Excellent.",
	'ratinghistory-graph-scale' => "'''Evaluacions per jorn''' <font color=\"red\">''(roge)''</font> afichadas a l'escala ''1:\$1''.",
	'right-feedback' => 'Utilizar lo formulari de somission per notar una pagina',
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
	'ratinghistory-svg' => 'Zobacz jako SVG',
	'ratinghistory-table-rating' => 'Ocena',
	'ratinghistory-table-votes' => 'Głosy',
	'ratinghistory-none' => 'W tej chwil brak liczby ocen czytelników wystarczającej, by móc stworzyć wykresy.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - źle; '''(2)''' - słabo; '''(3)''' - średnio; '''(4)''' - dobrze; '''(5)''' - wspaniale;",
	'ratinghistory-legend' => "'''Liczba ocen w ciągu doby''' <font color=\"red\">''(czerwony)''</font>, '''dobowa średnia''' <font color=\"blue\">''(niebieski)''</font> i '''średnia ocena bieżąca''' <font color=\"green\">''(zielony)''</font> zostały przedstawione względem daty na poniższym wykresie.
'''Średnia ocena bieżąca''' to średnia dobowych ocen w tym czasie za każdy dzień.
Skala ocen: 

'''[1]''' – niedostatecznie, '''[2]''' – słabo, '''[3]''' – zadowalająco, '''[4]''' – dobrze, '''[5]''' – bardzo dobrze.",
	'ratinghistory-graph-scale' => "'''Liczba przeglądów na dzień''' <font color=\"red\">''(czerwona)''</font> pokazana w skali ''1:\$1''.",
	'right-feedback' => 'Użyj formularza, aby ocenić stronę',
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Mersì për pijé un moment e revisioné sta pàgina-sì!</font>''",
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
	'ratinghistory-legend' => "Ël '''nùmer ëd revision për di''' <font color=\"red\">''(ross)''</font>, '''pontegi medi për di''' <font color=\"blue\">''(bleu)''</font>,
e '''pontegi medi an cors''' <font color=\"green\">''(verd)''</font> a son an gràfich sota, për data.
Ël '''pontegi medi an cors''' a l'é semplicement la media ëd tùit ij pontegi giornalié ''an drinta'' sto perìod ëd temp për minca di.
Ij pontegi a son com sota:

'''(1)''' - Pòver; '''(2)''' - Bass; '''(3)''' - Mesan; '''(4)''' - Àut; '''(5)''' - Ecelent;",
	'ratinghistory-graph-scale' => "'''Revision për di''' <font color=\"red\">''(ross)''</font> mostrà su na scala ''1:\$1''.",
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
	'ratinghistory-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Avaliação',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Neste momento, ainda não há avaliações dos leitores suficientes para mostrar gráficos.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Razoável; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-legend' => "O '''número diário de revisões''' <font color=\"red\">''(vermelho)''</font>, a '''avaliação média diária''' <font color=\"blue\">''(azul)''</font> e a '''avaliação média acumulada''' <font color=\"green\">''(verde)''</font> estão apresentadas graficamente abaixo, por data. 
A '''avaliação média acumulada''' é apenas a média de todas as avaliações diárias ''dentro'' desta janela temporal em cada dia.
As avaliações são como se segue:

'''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Razoável; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "'''Número diário de revisões''' <font color=\"red\">''(red)''</font> apresentado na escala ''1:\$1''.",
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
	'ratinghistory-svg' => 'Ver como SVG',
	'ratinghistory-table-rating' => 'Avaliação',
	'ratinghistory-table-votes' => 'Votos',
	'ratinghistory-none' => 'Ainda não há dados suficientes de avaliações dos leitores para mostrar gráficos.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Média; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-legend' => "O '''número diário de avaliações''' <font color=\"red\">''(vermelho)''</font>, '''avaliação média diária''' <font color=\"blue\">''(azul)''</font>,
e '''avaliação média acumulada''' <font color=\"green\">''(verde)''</font> são apresentadas no gráfico abaixo, por data.
A '''avaliação média acumulada''' é apenas a média de todas as avaliações diárias ''dentro'' deste intervalo de tempo para cada dia.
As avaliações são as seguintes:

'''(1)''' - Péssima; '''(2)''' - Baixa; '''(3)''' - Média; '''(4)''' - Alta; '''(5)''' - Excelente;",
	'ratinghistory-graph-scale' => "'''Avaliações por dia''' <font color=\"red\">''(vermelho)''</font> exibidas em escala ''1:\$1''.",
	'right-feedback' => 'Use o formulário de feedback para avaliar uma página',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'ratinghistory' => 'Istoricul evaluării paginii',
	'ratinghistory-leg' => 'Informaţii despre istoricul evaluarii pentru [[:$1|$1]]',
	'ratinghistory-tab' => 'evaluare',
	'ratinghistory-link' => 'Evaluarea paginii',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Mulţumim pentru că aţi revizuit această pagină!</font>''",
	'ratinghistory-period' => 'Perioadă de timp:',
	'ratinghistory-month' => 'ultima lună',
	'ratinghistory-3months' => 'ultimele 3 luni',
	'ratinghistory-year' => 'ultimul an',
	'ratinghistory-3years' => 'ultimii 3 ani',
	'ratinghistory-ave' => 'Medie: $1',
	'ratinghistory-chart' => 'Evaluările cititorilor de-a lungul timpului',
	'ratinghistory-purge' => 'curăţa cache-ul',
	'ratinghistory-table' => 'Privire de ansamblu asupra evaluării cititorilor',
	'ratinghistory-users' => 'Utilizatori care şi-au exprimat opinia',
	'ratinghistory-svg' => 'Vizualizează drept SVG',
	'ratinghistory-table-rating' => 'Evaluare',
	'ratinghistory-table-votes' => 'Voturi',
	'ratinghistory-none' => 'Nu există suficiente date disponibile pentru a genera grafice în acest moment.',
	'right-feedback' => 'Folosiţi formularul de feedback-ul pentru a evalua o pagină',
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
	'ratinghistory-svg' => 'Vide cumme a SVG',
	'ratinghistory-table-rating' => 'Pundegge',
	'ratinghistory-table-votes' => 'Vote',
	'ratinghistory-none' => "Non ge stonne abbastanza lettore ca onne lassete 'u feedback pe ccrejà 'nu grafeche jndr'à stu timbe.",
	'ratinghistory-ratings' => "Scale: '''[1]''' - Povere; '''[2]''' - Vasce; '''[3]''' - Medie; '''[4]''' - Ierte; '''[5]''' - 'A uerre proprie;",
	'ratinghistory-legend' => "'U '''numere sciurnaliere de revisite''', <font color=\"red\">''(russe)''</font>, 'u '''pundégge medie sciurnaliere''' <font color=\"blue\">''(blu)''</font> e
'u '''pundégge medie corrende''' <font color=\"green\">''(verde)''</font> sonde disegnete aqquà sotte, pe date.
'U '''pundégge medie corrende''' jè semblicemende 'a medie de tutte le pundegge sciuraliere ''fine a'' osce.

Scale: '''[1]''' - Povere; '''[2]''' - Vasce; '''[3]''' - Medie; '''[4]''' - Ierte; '''[5]''' - 'A uerre proprie;",
	'ratinghistory-graph-scale' => "Le '''rivisite pe sciurne''' <font color=\"red\">''(russe)''</font> sonde visualizzate sus a 'na ''1:\$1'' scale.",
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
	'ratinghistory-purge' => 'очистить кеш',
	'ratinghistory-table' => 'Обзор оценок читателей',
	'ratinghistory-users' => 'Участники, которые дали оценку',
	'ratinghistory-graph' => '$2 из «$3» ($1 {{PLURAL:$1|оценка|оценки|оценок}})',
	'ratinghistory-svg' => 'Просмотреть как SVG',
	'ratinghistory-table-rating' => 'Оценка',
	'ratinghistory-table-votes' => 'Голоса',
	'ratinghistory-none' => 'В настоящее время набралось недостаточное количество читательских оценок для построения графика.',
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' — плохая; '''(2)''' — низкая; '''(3)''' — средняя; '''(4)''' — хорошая; '''(5)''' — отличная;",
	'ratinghistory-legend' => "Ниже показаны: '''число оценок в день''' <font color=\"red\">''(красный)''</font> '''среднесуточная оценка''' <font color=\"blue\">''(синий)''</font> и
'''текущая средняя оценка''' <font color=\"green\">''(зелёный)''</font>.
'''Текущая средняя оценка''' — это среднее всех суточных оценок для данного промежутка времени для каждого дня.
Шкала оценок:

'''[1]''' — плохая; '''[2]''' — низкая; '''[3]''' — средняя; '''[4]''' — хорошая; '''[5]''' — отличная.",
	'ratinghistory-graph-scale' => "'''Число проверок за день''' <font color=\"red\">''(красный)''</font> показано ниже в масштабе ''1:\$1''.",
	'right-feedback' => 'использование формы отзывов для оценки страниц',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'ratinghistory' => 'Сирэй сыаналааһынын устуоруйата',
	'ratinghistory-leg' => 'Сирэй сыаналааһынын туһунан дааннайдар [[:$1|$1]]',
	'ratinghistory-tab' => 'сыаналааһын',
	'ratinghistory-link' => 'Сирэйи сыаналааһын',
	'ratinghistory-thanks' => "''<font color=\"darkred\">Бу сирэйи сыаналаабыккар махтал!</font>''",
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
	'ratinghistory-legend' => "Аллара көрдөрүннүлэр: '''күҥҥэ хас сыанабыл биэриллэрэ''' <font color=\"red\">''(кыһыл)''</font> '''сууккаҕа орто сыана''' <font color=\"blue\">''(күөх)''</font> уонна
'''билиҥҥи орто сыана''' <font color=\"green\">''(чээл күөх)''</font>.
'''Билиҥҥи орто сыана''' — суукка бу быстах кэмигэр бары сууккалар орто сыаналарыттан ортотунан таһаарыллар сыана.
Сыанабыл шкалаата:

'''[1]''' — куһаҕан; '''[2]''' — мөлтөх; '''[3]''' — орто; '''[4]''' — үчүгэй; '''[5]''' — уһулуччу.",
	'ratinghistory-graph-scale' => "'''Күҥҥэ хас бэрэбиэркэ буолара''' <font color=\"red\">''(кыһыл)''</font> аллара маннык масштаабтаах көһүннэ ''1:\$1''.",
	'right-feedback' => 'Сирэйи сыаналыырга отзыв форматын туттуу',
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
	'ratinghistory-svg' => 'Zobraziť ako SVG',
	'ratinghistory-table-rating' => 'Hodnotenie',
	'ratinghistory-table-votes' => 'Hlasy',
	'ratinghistory-none' => 'Momentálne nie je dostupný dostatok údajov o spätnej väzbe používateľov nato, aby bolo možné vytvoriť grafy.',
	'ratinghistory-ratings' => "'''Legenda:''' '''(1)''' - Slabá; '''(2)''' - Nízka; '''(3)''' - Dobrá; '''(4)''' - Vysoká; '''(5)''' - Vynikajúca;",
	'ratinghistory-legend' => "Dolu je podľa dátumu zobrazené '''denné priemerné hodnotenie''' <font color=\"blue\">''(modrou)''</font> a '''priemer vybraného intervalu''' <font color=\"green\">''(zelenou)''</font>. '''Priemer vybraného intervalu''' je jednoducho priemer denných hodnotení ''v rámci'' tohto časového intervalu za každý deň. Hodnoty hodnotenia sa interpretujú nasledovne:

'''[1]''' - Slabé; '''[2]''' - Nízke; '''[3]''' - Dobré; '''[4]''' - Vysoké; '''[5]''' - Výborné;",
	'ratinghistory-graph-scale' => "'''Počet kontrol za deň''' <font color=\"red\">''(červenou)''</font> je zobrazený  v mierke ''1:\$1''.",
	'right-feedback' => 'Hodnotenie stránok prostredníctvom formulára',
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

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Millosh
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'ratinghistory' => 'Историја оцена стране.',
	'ratinghistory-leg' => 'Историја оцењивања за [[:$1|$1]]',
	'ratinghistory-tab' => 'оцена',
	'ratinghistory-period' => 'Раздобље:',
	'ratinghistory-month' => 'последњи месец',
	'ratinghistory-3months' => 'последња 3 месеца',
	'ratinghistory-year' => 'последња година',
	'ratinghistory-3years' => 'последње три године',
	'ratinghistory-ave' => 'Средње: $1',
	'ratinghistory-purge' => 'очисти кеш',
	'ratinghistory-svg' => 'Види као SVG',
	'ratinghistory-table-votes' => 'Гласови',
	'ratinghistory-none' => 'Још увек нема довољно мишљења читалаца да би се формирали графикони.',
);

/** Serbian Latin ekavian (Srpski (latinica))
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
	'ratinghistory-svg' => 'Visa som SVG',
	'ratinghistory-table-rating' => 'Betyg',
	'ratinghistory-table-votes' => 'Röster',
	'ratinghistory-none' => 'Det finns för närvarande inte tillräckligt med feedbackdata tillgängligt från läsarna för grafer.',
	'ratinghistory-ratings' => "'''Förklaring:''' '''(1)''' - Mycket dålig; '''(2)''' - Dålig; '''(3)''' - Okej; '''(4)''' - Bra; '''(5)''' - Mycket bra;",
	'ratinghistory-legend' => "'''Antalet granskningar per dag''' <font color=\"red\">''(röd)''</font>, '''dagliga genomsnittsbetyget''' <font color=\"blue\">''(blå)''</font> och '''löpande genomsnittsbetyg''' <font color=\"green\">''(grön)''</font> visas i grafform nedan, efter datum.
Det '''löpande genomsnittsbetyget''' är helt enkelt genomsnittet av alla dagliga betyg ''inom'' denna tidsperiod för varje dag.

Betygsskalan är enligt följande:
'''[1]''' - Mycket dålig; '''[2]''' - Dålig; '''[3]''' - Okej; '''[4]''' - Bra; '''[5]''' - Mycket bra;",
	'ratinghistory-graph-scale' => "'''Bedömningar per dag''' <font color=\"red\">''(röd)''</font> visas i skala ''1:\$1''.",
	'right-feedback' => 'Använd feedback-formuläret för att betygsätta en sida',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'ratinghistory' => 'పేజీ రేటింగు చరిత్ర',
	'ratinghistory-link' => 'పేజీ మూల్యాంకన',
	'ratinghistory-thanks' => "''<font color=\"darkred\">ఈ పేజీని సమీక్షించడానికి సమయం వెచ్చించినందుకు ధన్యవాదాలు!</font>''",
	'ratinghistory-period' => 'కాల వ్యవధి:',
	'ratinghistory-month' => 'గత నెల',
	'ratinghistory-3months' => 'గత 3 నెలలు',
	'ratinghistory-year' => 'గత సంవత్సరం',
	'ratinghistory-3years' => 'గత 3 సంవత్సరాలు',
	'ratinghistory-ave' => 'సగటు: $1',
	'ratinghistory-graph' => '"$3" యొక్క $2 ($1 {{PLURAL:$1|సమీక్ష|సమీక్షలు}})',
	'ratinghistory-svg' => 'SVGగా చూడండి',
	'ratinghistory-table-votes' => 'వోట్లు',
	'ratinghistory-ratings' => "'''సూచిక:''' '''(1)''' - అత్యల్పం; '''(2)''' - అల్పం; '''(3)''' - పర్లేదు; '''(4)''' - ఉత్తమం; '''(5)''' - అత్యుత్తమం;",
);

/** Thai (ไทย)
 * @author Ans
 */
$messages['th'] = array(
	'ratinghistory-month' => 'เดือนที่แล้ว',
	'ratinghistory-3months' => '3 เดือนที่แล้ว',
	'ratinghistory-year' => 'ปีที่แล้ว',
	'ratinghistory-3years' => '3 ปีที่แล้ว',
	'ratinghistory-ave' => 'เฉลี่ย: $1',
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Bu sahypany gözden geçirmek üçin wagt tapanyňyz üçin sag boluň!</font>''",
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
	'ratinghistory-legend' => "'''günlük ortaça gözden geçirme''' <font color=\"red\">''(gyzyl)''</font>, '''günlük ortaça derejelendirme''' <font color=\"blue\">''(gök)''</font>
we '''häzirki ortaça derejelendirme''' <font color=\"green\">''(ýaşyl)''</font> aşakda sene boýunça çyzyldy.
'''häzirki ortaça derejelendirme''' her bir gün üçin şu böleginiň ''dowamynda'' günlük derejelendirmeleriniň ortaça bahasydyr.
Derejelendirmeler aşakdaky ýalydyr:

'''(1)''' - Ýaramaz; '''(2)''' - Pes; '''(3)''' - Orta gürp; '''(4)''' - Ýagşy; '''(5)''' - Ajaýyp;",
	'ratinghistory-graph-scale' => "'''Günlük gözden geçirmeler''' <font color=\"red\">''(gyzyl)''</font> ''1:\$1'' masştabynda görkezilýär.",
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
	'ratinghistory-svg' => 'Tingnan bilang SVG',
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
	'ratinghistory-svg' => 'SVG olarak görüntüle',
	'ratinghistory-table-rating' => 'Derecelendirme',
	'ratinghistory-table-votes' => 'Oylar',
	'ratinghistory-none' => 'Grafikler için şuanda yeterince okuyucu dönüt verisi yok.',
	'ratinghistory-ratings' => "'''Ölçek:''' '''(1)''' - Zayıf; '''(2)''' - Düşük; '''(3)''' - Adil; '''(4)''' - Yüksek; '''(5)''' - Mükemmel;",
	'ratinghistory-legend' => "'''Günlük ortalama gözden geçirme''' <font color=\"red\">''(kırmızı)''</font>, '''Günlük ortalama derecelendirme''' <font color=\"blue\">''(mavi)''</font>
ve '''Çalışma ortalama derecelendirme''' <font color=\"green\">''(yeşil)''</font> aşağıda tarihe göre çizildi.
'''Çalışma ortalama derecelendirme''', herbir gün için bu zaman dilimi ''içinde'' günlük derecelendirmelerinin ortalamasıdır.
Derecelendirmeler aşağıdaki gibidir:

'''(1)''' - Zayıf; '''(2)''' - Düşük; '''(3)''' - Adil; '''(4)''' - Yüksek; '''(5)''' - Mükemmel;",
	'ratinghistory-graph-scale' => "'''Günlük gözden geçirmeler''' <font color=\"red\">''(kırmızı)''</font> ''1:\$1'' ölçeğinde gösterilmektedir.",
	'right-feedback' => 'Bir sayfayı derecelendirmek için dönüt formunu kullanın',
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
	'ratinghistory-svg' => 'Переглянути як SVG',
	'ratinghistory-table-rating' => 'Рейтинг',
	'ratinghistory-table-votes' => 'Голоси',
	'ratinghistory-none' => "Недостатньо даних зворотного зв'язку читачів для графіків на цей час.",
	'ratinghistory-ratings' => "'''Легенда:''' '''(1)''' — погана; '''(2)''' — низька; '''(3)''' — середня; '''(4)''' — висока; '''(5)''' — відмінна;",
	'ratinghistory-legend' => "'''Кількість оцінок за добу''' <font color=\"red\">''(red)''</font>,
'''середній рейтинг за добу''' <font color=\"blue\">''(синій)''</font> і  
'''середній рейтинг за період''' <font color=\"green\">''(зелений)''</font> показані нижче за датою.
'''Середній рейтинг за період''' — середнє значення всіх добових рейтингів ''за'' період для кожного дня.

Шкала якості: '''(1)''' - погана; '''(2)''' - низька; '''(3)''' — середня; '''(4)''' — висока; '''(5)''' — відмінна;",
	'ratinghistory-graph-scale' => "'''Кількість оцінок за добу''' <font color=\"red\">''(червоний)''</font> показано нижче в масштабі ''1:\$1''.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Grassie de ver speso calche momento a valutar sta pagina!</font>''",
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
	'ratinghistory-legend' => "Qua soto vien mostrà, par data, el '''nùmaro de valutassion al zorno''' <font color=\"red\">''(rosso)''</font>, la '''valutassion media par zorno''' <font color=\"blue\">''(blu)''</font>, e la '''valutassion media cumulà''' <font color=\"green\">''(verde)''</font>.
La '''valutassion media cumulà''' la xe senplisemente la media de tuti i giudissi ''drento'' de sta finestra de tenpo zorno par zorno.
Le valutassion le xe ste qua:

'''(1)''' - Tristo assè; '''(2)''' - Tristo; '''(3)''' - Cussì-cussì; '''(4)''' - Bon; '''(5)''' - Bon assè;",
	'ratinghistory-graph-scale' => "'''Revision par zorno'''  <font color=\"red\">''(rosso)''</font> mostrà in scala ''1:\$1''.",
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
	'ratinghistory-svg' => 'Kacta kut SVG',
	'ratinghistory-table-rating' => 'Arvoind',
	'ratinghistory-table-votes' => 'Äned',
	'ratinghistory-none' => 'Ei ulotu lugijoiden arvsanoid grafikan tehtes.',
	'ratinghistory-ratings' => "'''Legend:''' '''(1)''' - Hond; '''(2)''' - Madal; '''(3)''' - Keskmäine; '''(4)''' - Korged; '''(5)''' - Lujas hüvä;",
	'ratinghistory-legend' => "Alemba oma ozutadud '''arvsanoiden lugu päiväs''' <font color=\"red\">''(rusked)''</font>, '''päivesenkeskmäine arvsana''' <font color=\"blue\">''(sinine)''</font> da '''nügüdläine keskmäine arvsana''' <font color=\"green\">''(vihand)''</font>.  
'''Nügüdläižeks keskmäižeks arvsanaks''' kuctas päivesen arvsanoiden keskmäine lugu, kudamban lugedas kaikuččen päivän märitud pordas aigad.

Pordhišt: '''[1]''' — hond; '''[2]''' — madal; '''[3]''' — keskmäine; '''[4]''' — hüvä; '''[5]''' — lujas hüvä;",
	'ratinghistory-graph-scale' => "'''Arvostelendoiden lugu päiväs''' <font color=\"red\">''(red)''</font> ozutadas ''1:\$1''-masštabas.",
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">Cám ơn đã để dành một chút thời gian để duyệt trang này!</font>''",
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
	'ratinghistory-legend' => "Những biểu thị ở dưới trình bày '''số lần đánh giá hàng ngày''' <font color=\"red\">(đỏ)</font>,  '''đánh giá trung bình hàng ngày''' <font color=\"blue\">''(lam)''</font>, và '''đánh giá trung bình đương thời''' <font color=\"green\">''(lục)''</font>, theo thời gian. '''Đánh giá trung bình đương thời''' chỉ là trung bình các đánh giá hàng ngày ''tại giai đoạn này'' vào mỗi ngày. Giải thích các giá trị:

'''[1]''' – Tệ; '''[2]''' – Dở; '''[3]''' – Khá; '''[4]''' – Hay; '''[5]''' – Tuyệt",
	'ratinghistory-graph-scale' => "'''Số lần đánh giá trong ngày''' <font color=\"red\">''(đỏ)''</font> được trình bày với tỷ lệ ''1:\$1''.",
	'right-feedback' => 'Đánh giá trang',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
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
	'ratinghistory-thanks' => "''<font color=\"darkred\">谢谢您对本页的评论！</font>''",
	'ratinghistory-period' => '时间段：',
	'ratinghistory-month' => '上月',
	'ratinghistory-3months' => '过去3个月',
	'ratinghistory-year' => '去年',
	'ratinghistory-3years' => '过去3年',
	'ratinghistory-ave' => '平均： $1',
	'ratinghistory-purge' => '清除缓存',
	'ratinghistory-table' => '读者评论总览',
	'ratinghistory-users' => '给出评价的用户',
	'ratinghistory-graph' => '"$3" 的 $2 （$1 {{PLURAL:$1|复审|复审}}）',
	'ratinghistory-svg' => '作为SVG浏览',
	'ratinghistory-table-rating' => '评级',
	'ratinghistory-table-votes' => '投票',
	'ratinghistory-none' => '目前没有足够的读者反馈数据来制作图表。',
	'ratinghistory-ratings' => "'''图例：''' '''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4)''' - 好； '''(5)''' - 极好；",
	'ratinghistory-legend' => "逐日的'''每日审核数量'''<font color=\"red\">''（红色）''</font>，'''每日平均评级'''<font color=\"blue\">''（蓝色）''</font>，以及'''移动平均评级'''<font color=\"green\">''（绿色）''</font>如下图所示。
'''移动平均评级'''是在某一天前后一段时间''内''每日评级的平均数。
评级结果如下：

'''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4)''' - 好； '''(5)''' - 极好；",
	'ratinghistory-graph-scale' => "'''每日审核'''<font color=\"red\">''（红色）''</font>以''1:\$1''的比例显示。",
	'right-feedback' => '使用反馈表单来对页面评级',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gaoxuewei
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'ratinghistory' => '頁面評級歷史',
	'ratinghistory-leg' => '[[:$1|$1]]的評級歷史數據',
	'ratinghistory-tab' => '評分',
	'ratinghistory-link' => '頁面評分',
	'ratinghistory-thanks' => "''<font color=\"darkred\">謝謝您對本頁的評論！</font>''",
	'ratinghistory-period' => '時間段：',
	'ratinghistory-month' => '過去一個月',
	'ratinghistory-3months' => '過去三個月',
	'ratinghistory-year' => '過去一年',
	'ratinghistory-3years' => '過去三年',
	'ratinghistory-ave' => '平均：$1',
	'ratinghistory-purge' => '清空緩存',
	'ratinghistory-table' => '讀者評論總覽',
	'ratinghistory-users' => '給出評價的用戶',
	'ratinghistory-graph' => '"$3" 的 $2 （$1 {{PLURAL:$1|複審|複審}}）',
	'ratinghistory-svg' => '以SVG檢視',
	'ratinghistory-table-rating' => '評分',
	'ratinghistory-table-votes' => '投票',
	'ratinghistory-none' => '目前沒有足夠的讀者反饋數據來製作圖表。',
	'ratinghistory-ratings' => "'''圖例：''' '''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4 )''' - 好； '''(5)''' - 極好；",
	'ratinghistory-legend' => "'''每日評論數量'''<font color=\"red\">''（紅色）''</font>，'''每日平均評級'''<font color=\"blue\">'' （藍色）''</font>，以及'''移動平均評級'''<font color=\"green\">''（綠色）''</font>如下圖所示。
'''移動平均評級'''是在某一天前後一段時間''內''每日評級的平均數。
評級結果如下：

'''(1)''' - 差； '''(2)''' - 不好； '''(3)''' - 一般； '''(4)''' - 好； ' ''(5)''' - 極好；",
	'ratinghistory-graph-scale' => "'''每天評論'''<font color=\"red\">''（紅色）''</font>以''1:\$1''的比例顯示。",
	'right-feedback' => '使用反饋表單來對頁面評級',
);

