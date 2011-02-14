<?php
/**
 * Internationalization file for the Semantic Result Formats extension
 *
 * @file
 * @ingroup Extensions
 */

// FIXME: Can be enabled when new style magic words are used (introduced in r52503)
// require_once( dirname( __FILE__ ) . '/SRF_Magic.php' );

$messages = array();

/** English
 */
$messages['en'] = array(
	'srf-desc' => 'Additional formats for Semantic MediaWiki inline queries', // FIXME: descmsg in extension credits should allow for parameter(s) so that $formats_list can be added

	// user messages
	'srf-name' => 'Semantic Result Formats', // name of extension, can be translated or not; used by Admin Links
	// format "calendar"
	'srfc_previousmonth' => 'Previous month',
	'srfc_nextmonth'     => 'Next month',
	'srfc_today'         => 'Today',
	'srfc_gotomonth'     => 'Go to month',
	'srf_printername_calendar' => 'Monthly calendar',
	'srf_paramdesc_calendarlang' => 'The code for the language in which to display the calendar',
	// format "vCard"
	'srf_vcard_link'     => 'vCard',
	'srf_printername_vcard' => 'vCard export',
	// format "iCalendar"
	'srf_icalendar_link' => 'iCalendar',
	'srf_printername_icalendar' => 'iCalendar export',
	'srf_paramdesc_icalendartitle' => 'The title of the calendar file',
	'srf_paramdesc_icalendardescription' => 'The description of the calendar file',
	// format "BibTeX"
	'srf_bibtex_link'    => 'BibTeX',
	'srf_printername_bibtex' => 'BibTeX export',
	// format "outline"
	'srf_outline_novalue' => 'No value',
	'srf_printername_outline' => 'Outline',
	'srf_paramdesc_outlineproperties' => 'The list of properties to be displayed as outline headers, separated by commas',
	// format "math"
	'srf_printername_sum' => 'Sum of numbers',
	'srf_printername_average' => 'Average of numbers',
	'srf_printername_max' => 'Maximum number',
	'srf_printername_min' => 'Minimum number',
	'srf_paramdesc_limit' => 'The maximum number of pages to query',
	// format "timeline"
	'srf_printername_timeline' => 'Timeline',
	'srf_printername_eventline' => 'Eventline',
	'srf_paramdesc_timelinebands' => 'Defines which bands are displayed in the result.',
	'srf_paramdesc_timelineposition' => 'Defines where the timeline initially focuses at.',
	'srf_paramdesc_timelinestart' => 'A property name used to define a first time point',
	'srf_paramdesc_timelineend' => 'A property name used to define a second time point',
	'srf_paramdesc_timelinesize' => 'The height of the timeline (default is 300px)',

	// format "Exhibit"
	'srf_paramdesc_views' => 'The views to be displayed',
	'srf_paramdesc_facets' => 'The set of properties to be displayed for each page',
	'srf_paramdesc_lens' => 'The name of a template with which to display page properties',
	// formats "googlebar" and "googlepie"
	'srf_printername_googlebar' => 'Google bar chart',
	'srf_printername_googlepie' => 'Google pie chart',
	'srf_printername_jqplotbar' => 'jqPlot bar chart',
	'srf_printername_jqplotpie' => 'jqPlot pie chart',
	'srf_paramdesc_chartheight' => 'The height of the chart, in pixels',
	'srf_paramdesc_chartwidth' => 'The width of the chart, in pixels',
	'srf_paramdesc_charttitle'  => 'The title of the chart',
	'srf_paramdesc_barcolor'   =>   'The color of the bars',
	'srf_paramdesc_bardirection'=>  'The direction of the bar chart',
	'srf_paramdesc_barnumbersaxislabel' => 'The label for the numbers axis',

	// "gallery" format
	'srf_printername_gallery' => 'Gallery',
	'srf_paramdesc_perrow' => 'The amount of images per row',
	'srf_paramdesc_widths' => 'The width of the images',
	'srf_paramdesc_heights' => 'The height of the images',
	'srf_paramdesc_autocaptions' => 'Use file name as caption when none is provided',

	// "tagcloud" format
	'srf_printername_tagcloud' => 'Tag cloud',
	'srf_paramdesc_includesubject' => 'If the names of the subjects themselves should be included',
	'srf_paramdesc_increase' => 'How to increase the size of tags',
	'srf_paramdesc_tagorder' => 'The order of the tags',
	'srf_paramdesc_mincount' => 'The minimum amount of times a value needs to occur to be listed',
	'srf_paramdesc_minsize' => 'The size of the smallest tags in percent (default: 77)',
	'srf_paramdesc_maxsize' => 'The size of the biggest tags in percent (default: 177)',
	'srf_paramdesc_maxtags' => 'The maximum amount of tags in the cloud',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'srf-desc' => '{{desc}}',
	'srf_vcard_link' => '{{optional}}',
	'srf_icalendar_link' => '{{optional}}',
	'srf_bibtex_link' => '{{optional}}',
	'srf_printername_outline' => 'This is the name of an output format. It is basically a list, or nested list, of topics, subtopics, subsubtopics, etc., as deeply stacked as defined by page editors in an inline query. 
There is an [http://discoursedb.org/wiki/Outline_example Outline example] ([http://semantic-mediawiki.org/wiki/Help:Outline_format more information]).',
	'srf_paramdesc_outlineproperties' => '"Outline" means the outline of text or document here.',
	'srf_paramdesc_timelinebands' => 'Available bands are DECADE, YEAR, MONTH, WEEK, and DAY. For details see http://semantic-mediawiki.org/wiki/Help:Timeline_format',
);

/** Afrikaans (Afrikaans)
 * @author SPQRobin
 */
$messages['af'] = array(
	'srfc_gotomonth' => 'Gaan na maand',
	'srf_icalendar_link' => 'iKalender',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'srfc_today' => 'ዛሬ',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'srf-desc' => 'صيغ إضافية لاستعلامات ميدياويكي الداخلية',
	'srf-name' => 'صيغ النتائج الدلالية',
	'srfc_previousmonth' => 'الشهر السابق',
	'srfc_nextmonth' => 'الشهر التالي',
	'srfc_today' => 'اليوم',
	'srfc_gotomonth' => 'اذهب إلى شهر',
	'srf_printername_calendar' => 'نتيجة شهرية',
	'srf_vcard_link' => 'في كارد',
	'srf_printername_vcard' => 'تصدير vCard',
	'srf_icalendar_link' => 'آي كالندر',
	'srf_printername_icalendar' => 'تصدير iCalendar',
	'srf_paramdesc_icalendartitle' => 'عنوان ملف النتيجة',
	'srf_paramdesc_icalendardescription' => 'وصف ملف النتيجة',
	'srf_bibtex_link' => 'بب تكس',
	'srf_printername_bibtex' => 'تصدير BibTeX',
	'srf_outline_novalue' => 'لا قيم',
	'srf_printername_outline' => 'إطار',
	'srf_paramdesc_outlineproperties' => 'قائمة الخصائص ليتم عرضها كعناوين عامة، مفصولة بواسطة فاصلات',
	'srf_printername_sum' => 'مجموع الأرقام',
	'srf_printername_average' => 'متوسط الأرقام',
	'srf_printername_max' => 'الرقم الأقصى',
	'srf_printername_min' => 'الرقم الأدنى',
	'srf_paramdesc_limit' => 'أقصى عدد من الصفحات للاستعلام',
	'srf_printername_timeline' => 'خط زمني',
	'srf_printername_eventline' => 'خط الأحداث',
	'srf_paramdesc_timelinebands' => 'يعرف أي الفرق يتم عرضها في هذه النتيجة.',
	'srf_paramdesc_timelineposition' => 'يعرف أين يركز الخط الزمني ابتداء.',
	'srf_paramdesc_timelinestart' => 'اسم خاصية تستخدم لتعريف نقطة أول مرة',
	'srf_paramdesc_timelineend' => 'اسم خاصية تستخدم لتعريف نقطة ثاني مرة',
	'srf_paramdesc_timelinesize' => 'ارتفاع الخط الزمني (افتراضيا 300px)',
	'srf_paramdesc_views' => 'عمليات الرؤية للعرض',
	'srf_paramdesc_facets' => 'مجموعة الخصائص للعرض لكل صفحة',
	'srf_paramdesc_lens' => 'اسم القالب لعرض خصائص الصفحة به',
	'srf_printername_googlebar' => 'رسم جوجل بالأعمدة',
	'srf_printername_googlepie' => 'رسم جوجل بالفطيرة',
	'srf_paramdesc_chartheight' => 'ارتفاع الرسم بالبكسل',
	'srf_paramdesc_chartwidth' => 'عرض الرسم بالبكسل',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'srfc_previousmonth' => 'ܝܪܚܐ ܕܕܥܒܪ',
	'srfc_nextmonth' => 'ܝܪܚܐ ܕܐܬܐ',
	'srfc_today' => 'ܝܘܡܢܐ',
	'srf_printername_calendar' => 'ܦܠܛܐ ܝܪܚܝܐ',
	'srf_printername_max' => 'ܡܬܚܐ ܥܠܝܐ ܕܡܢܝܢܐ',
	'srf_printername_min' => 'ܡܬܚܐ ܬܚܬܝܐ ܕܡܢܝܢܐ',
	'srf_printername_gallery' => 'ܒܝܬ ܓܠܚܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'srf-desc' => 'صيغ إضافيه لاستعلامات ميدياويكى الداخلية',
	'srf-name' => 'صيغ النتائج الدلالية',
	'srfc_previousmonth' => 'الشهر السابق',
	'srfc_nextmonth' => 'الشهر التالي',
	'srfc_today' => 'اليوم',
	'srfc_gotomonth' => 'اذهب إلى شهر',
	'srf_printername_calendar' => 'نتيجه شهرية',
	'srf_vcard_link' => 'فى كارد',
	'srf_printername_vcard' => 'تصدير vCard',
	'srf_icalendar_link' => 'آى كالندر',
	'srf_printername_icalendar' => 'تصدير iCalendar',
	'srf_paramdesc_icalendartitle' => 'عنوان ملف النتيجة',
	'srf_paramdesc_icalendardescription' => 'وصف ملف النتيجة',
	'srf_printername_bibtex' => 'تصدير BibTeX',
	'srf_outline_novalue' => 'لا قيم',
	'srf_printername_outline' => 'إطار',
	'srf_paramdesc_outlineproperties' => 'قائمه الخصائص ليتم عرضها كعناوين عامه، مفصوله بواسطه فاصلات',
	'srf_printername_sum' => 'مجموع الأرقام',
	'srf_printername_average' => 'متوسط الأرقام',
	'srf_printername_max' => 'الرقم الأقصى',
	'srf_printername_min' => 'الرقم الأدنى',
	'srf_paramdesc_limit' => 'أقصى عدد من الصفحات للاستعلام',
	'srf_printername_timeline' => 'خط زمني',
	'srf_printername_eventline' => 'خط الأحداث',
	'srf_paramdesc_timelinebands' => 'يعرف أى الفرق يتم عرضها فى هذه النتيجه.',
	'srf_paramdesc_timelineposition' => 'يعرف أين يركز الخط الزمنى ابتداء.',
	'srf_paramdesc_timelinestart' => 'اسم خاصيه تستخدم لتعريف نقطه أول مرة',
	'srf_paramdesc_timelineend' => 'اسم خاصيه تستخدم لتعريف نقطه ثانى مرة',
	'srf_paramdesc_timelinesize' => 'ارتفاع الخط الزمنى (افتراضيا 300px)',
	'srf_paramdesc_views' => 'عمليات الرؤيه للعرض',
	'srf_paramdesc_facets' => 'مجموعه الخصائص للعرض لكل صفحة',
	'srf_paramdesc_lens' => 'اسم القالب لعرض خصائص الصفحه به',
	'srf_printername_googlebar' => 'رسم جوجل بالأعمدة',
	'srf_printername_googlepie' => 'رسم جوجل بالفطيرة',
	'srf_paramdesc_chartheight' => 'ارتفاع الرسم بالبكسل',
	'srf_paramdesc_chartwidth' => 'عرض الرسم بالبكسل',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'srf-desc' => 'Дадатковыя фарматы для ўбудаваных запытаў Semantic MediaWiki',
	'srf-name' => 'Фарматы сэмантычных вынікаў',
	'srfc_previousmonth' => 'Папярэдні месяц',
	'srfc_nextmonth' => 'Наступны месяц',
	'srfc_today' => 'Сёньня',
	'srfc_gotomonth' => 'Перайсьці да месяца',
	'srf_printername_calendar' => 'Каляндар на месяц',
	'srf_paramdesc_calendarlang' => 'Код мовы, на якой паказваць каляндар',
	'srf_printername_vcard' => 'экспарт у фармаце vCard',
	'srf_printername_icalendar' => 'экспарт у фармаце iCalendar',
	'srf_paramdesc_icalendartitle' => 'Назва файла календара',
	'srf_paramdesc_icalendardescription' => 'Апісаньне файла календара',
	'srf_printername_bibtex' => 'экспарт у фармаце BibTeX',
	'srf_outline_novalue' => 'Няма значэньня',
	'srf_printername_outline' => 'Табліца',
	'srf_paramdesc_outlineproperties' => 'Сьпіс уласьцівасьцяў для паказу ў якасьці загалоўкаў, падзеленых коскамі',
	'srf_printername_sum' => 'Сума лікаў',
	'srf_printername_average' => 'Сярэдняе значэньне лікаў',
	'srf_printername_max' => 'Максымальны лік',
	'srf_printername_min' => 'Мінімальны лік',
	'srf_paramdesc_limit' => 'Максымальная колькасьць старонак для запыту',
	'srf_printername_timeline' => 'Храналёгія',
	'srf_printername_eventline' => 'Храналёгія падзеяў',
	'srf_paramdesc_timelinebands' => 'Вызначае, якія дыяпазоны будуць паказаныя ў выніку.',
	'srf_paramdesc_timelineposition' => 'Вызначае, якое месца шкалы часу будзе паказвацца спачатку.',
	'srf_paramdesc_timelinestart' => 'Назва ўласьцівасьці, якая выкарыстоўваецца як першы пункт часу',
	'srf_paramdesc_timelineend' => 'Назва ўласьцівасьці, якая выкарыстоўваецца для вызначэньня другога пункту часу',
	'srf_paramdesc_timelinesize' => 'Вышыня шкалы часу (па змоўчваньні 300пкс)',
	'srf_paramdesc_views' => 'Прагляды для паказу',
	'srf_paramdesc_facets' => 'Набор ўласьцівасьцяў для паказу на кожнай старонцы',
	'srf_paramdesc_lens' => 'Назва шаблёну для паказу ўласьцівасьцяў старонкі',
	'srf_printername_googlebar' => 'Слупковая дыяграма Google',
	'srf_printername_googlepie' => 'Кругавая дыяграма Google',
	'srf_printername_jqplotbar' => 'Слупковая дыяграма jqPlot',
	'srf_printername_jqplotpie' => 'Кругавая дыяграма jqPlot',
	'srf_paramdesc_chartheight' => 'Вышыня дыяграмы ў піксэлях',
	'srf_paramdesc_chartwidth' => 'Шырыня дыяграмы ў піксэлях',
	'srf_paramdesc_charttitle' => 'Назва дыяграмы',
	'srf_paramdesc_barcolor' => 'Колер слупкоў',
	'srf_paramdesc_bardirection' => 'Накіраваньне слупкоў дыяграмы',
	'srf_paramdesc_barnumbersaxislabel' => 'Надпісы для лічбавых восяў',
	'srf_printername_gallery' => 'Галерэя',
	'srf_printername_tagcloud' => 'Воблака тэгаў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'srfc_previousmonth' => 'Предходен месец',
	'srfc_nextmonth' => 'Следващ месец',
	'srfc_today' => 'Днес',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'srfc_previousmonth' => 'পূর্ববর্তী মাস',
	'srfc_nextmonth' => 'পরবর্তী মাস',
	'srfc_today' => 'আজ',
	'srfc_gotomonth' => 'যে মাসে যাবেন',
	'srf_printername_calendar' => 'মাসিক ক্যালেন্ডার',
	'srf_outline_novalue' => 'কোনো মান নাই',
	'srf_printername_sum' => 'সমষ্টি',
	'srf_printername_average' => 'গড়',
	'srf_printername_max' => 'সর্বোচ্চ',
	'srf_printername_min' => 'সর্বোনিম্ন',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwendal
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'srf-desc' => 'Furmadoù ouzhpenn evit ar rekedoù Semantic MediaWiki',
	'srf-name' => "Furmadoù an disoc'hoù semantek",
	'srfc_previousmonth' => 'Miz a-raok',
	'srfc_nextmonth' => 'Miz a zeu',
	'srfc_today' => 'Hiziv',
	'srfc_gotomonth' => "Mont d'ar miz",
	'srf_printername_calendar' => 'Deiziataer miziek',
	'srf_paramdesc_calendarlang' => 'Kod ar yezh a dalvez da ziskwel an deiziadur',
	'srf_printername_vcard' => 'ezporzhiañ vCard',
	'srf_printername_icalendar' => 'Enporzh e iCalendar',
	'srf_paramdesc_icalendartitle' => 'Titl ar restr deiziataer',
	'srf_paramdesc_icalendardescription' => 'Deskrivadur restr an deiziataer',
	'srf_printername_bibtex' => 'Enporzh e BibTeX',
	'srf_outline_novalue' => 'Talvoud ebet',
	'srf_printername_outline' => 'Trolinenn',
	'srf_paramdesc_outlineproperties' => 'Roll ar perzhioù da ziskwel evel talbennoù, dispartiet gant skejoù.',
	'srf_printername_sum' => 'Sammad niveroù',
	'srf_printername_average' => 'Keitad an niveroù',
	'srf_printername_max' => 'Niver uhelañ',
	'srf_printername_min' => 'Niver izelañ',
	'srf_paramdesc_limit' => "Niver brasañ a bajennoù da gerc'hat",
	'srf_printername_timeline' => 'Kronologiezh',
	'srf_printername_eventline' => 'Kronologiezh an darvoudoù',
	'srf_paramdesc_timelinebands' => "a zielfenn peseurt strolladoù zo diskwelet en disoc'hoù.",
	'srf_paramdesc_timelineposition' => 'a zielfenn takad ar frizenn a oa kreizennet da gentañ.',
	'srf_paramdesc_timelinestart' => "Un anv perzh implijet da dermeniñ ur poent loc'hañ en amzer",
	'srf_paramdesc_timelineend' => 'Un anv perzh implijet da dermeniñ un eil poent en amzer',
	'srf_paramdesc_timelinesize' => 'Uhelder ar frizenn (300px dre ziouer)',
	'srf_paramdesc_views' => 'Ar gweladennoù da ziskouez',
	'srf_paramdesc_facets' => 'An hollad perzhioù da ziskwel evit pep pajenn',
	'srf_paramdesc_lens' => 'Anv ar patrom implijet evit diskouez perzhioù ar bajenn',
	'srf_printername_googlebar' => 'Grafik barrennek Google',
	'srf_printername_googlepie' => 'Grafik dre lodennoù Google',
	'srf_printername_jqplotbar' => 'Grafik e barrennoù jqPlot',
	'srf_printername_jqplotpie' => 'Grafik kouign jqPlot',
	'srf_paramdesc_chartheight' => 'Uhelder an diagramm, e piksel',
	'srf_paramdesc_chartwidth' => 'Ledander an diagramm, e piksel',
	'srf_paramdesc_charttitle' => 'Titl ar grafik',
	'srf_paramdesc_barcolor' => 'Liv ar barrennoù',
	'srf_paramdesc_bardirection' => "Durc'hadur ar grafik e barrennoù",
	'srf_paramdesc_barnumbersaxislabel' => 'Tikedenn ahel an niveroù',
	'srf_printername_gallery' => 'Skeudennaoueg',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'srf-desc' => 'Dodatni formati za linijske upite na Semantic MediaWiki',
	'srf-name' => 'Formati semantičkih rezultata',
	'srfc_previousmonth' => 'Prethodni mjesec',
	'srfc_nextmonth' => 'Slijedeći mjesec',
	'srfc_today' => 'Danas',
	'srfc_gotomonth' => 'Idi na mjesec',
	'srf_printername_calendar' => 'Mjesečni kalendar',
	'srf_printername_vcard' => 'Izvoz u vCard',
	'srf_printername_icalendar' => 'Izvoz u iCalendar',
	'srf_paramdesc_icalendartitle' => 'Naslov datoteke kalendara',
	'srf_printername_bibtex' => 'Izvoz u BibTeX',
	'srf_outline_novalue' => 'Nema vrijednosti',
	'srf_printername_outline' => 'Kontura',
	'srf_printername_sum' => 'Zbir brojeva',
	'srf_printername_average' => 'Prosjek brojeva',
	'srf_printername_max' => 'Najveći broj',
	'srf_printername_min' => 'Najmanji broj',
	'srf_paramdesc_limit' => 'Najveći broj stranica za upit',
	'srf_printername_timeline' => 'Vremenska linija',
	'srf_printername_eventline' => 'Linija događaja',
	'srf_paramdesc_timelinesize' => 'Visina vremenske linije (pretpostavljeno je 300px)',
);

/** Catalan (Català)
 * @author Dvdgmz
 * @author Paucabot
 * @author Toniher
 */
$messages['ca'] = array(
	'srf-desc' => 'Formats addicionals per a les consultes en línia del Semantic MediaWiki.',
	'srfc_previousmonth' => 'Mes anterior',
	'srfc_nextmonth' => 'Mes posterior',
	'srfc_today' => 'Avui',
	'srfc_gotomonth' => 'Vés al mes',
	'srf_printername_calendar' => 'Calendari mensual',
	'srf_paramdesc_calendarlang' => 'El codi de la llengua en què es mostrarà el calendari',
	'srf_paramdesc_icalendartitle' => 'El títol del fitxer del calendari',
	'srf_paramdesc_icalendardescription' => 'La descripció del fitxer del calendari',
	'srf_printername_sum' => 'Suma dels nombres',
	'srf_printername_average' => 'Mitjana dels nombres',
	'srf_printername_max' => 'Nombre màxim',
	'srf_printername_min' => 'Nombre mínim',
	'srf_paramdesc_limit' => 'El nombre màxim de pàgines on fer la consulta',
	'srf_paramdesc_timelinesize' => 'La llargada de la línia de temps (per defecte són 300px)',
	'srf_printername_gallery' => 'Galeria',
);

/** German (Deutsch)
 * @author DaSch
 * @author Imre
 * @author Kghbln
 * @author Krabina
 * @author Purodha
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'srf-desc' => 'Stellt Semantic MediaWiki zusätzliche Ausgabeformate für eingebettete Abfragen zur Verfügung',
	'srf-name' => 'Semantische Ergebnisformate',
	'srfc_previousmonth' => 'Voriger Monat',
	'srfc_nextmonth' => 'Nächster Monat',
	'srfc_today' => 'Heute',
	'srfc_gotomonth' => 'Gehe zu Monat',
	'srf_printername_calendar' => 'Monatlicher Kalendar',
	'srf_paramdesc_calendarlang' => 'Der Code der Sprache in der der Kalender angezeigt werden soll',
	'srf_printername_vcard' => 'vCard-Export',
	'srf_printername_icalendar' => 'iCalendar-Export',
	'srf_paramdesc_icalendartitle' => 'Titel der Kalenderdatei',
	'srf_paramdesc_icalendardescription' => 'Beschreibung der Kalenderdatei',
	'srf_printername_bibtex' => 'BibTeX Export',
	'srf_outline_novalue' => 'Kein Wert',
	'srf_printername_outline' => 'Gliederung',
	'srf_paramdesc_outlineproperties' => 'Liste der mit Kommas voneinander getrennten Attribute, die in der Kopfzeile der Übersicht angezeigt werden sollen.',
	'srf_printername_sum' => 'Summe der Zahlen',
	'srf_printername_average' => 'Durchschnittliche Zahl',
	'srf_printername_max' => 'Maximale Zahl',
	'srf_printername_min' => 'Minimale Zahl',
	'srf_paramdesc_limit' => 'Die maximale Anzahl der abfragbaren Seiten',
	'srf_printername_timeline' => 'Zeitlinie',
	'srf_printername_eventline' => 'Eventlinie',
	'srf_paramdesc_timelinebands' => 'Legt fest, welche Bereiche im Ergebnis angezeigt werden.',
	'srf_paramdesc_timelineposition' => 'Legt fest, wo der Zeitstrahl anfänglich steht.',
	'srf_paramdesc_timelinestart' => 'Ein Eigenname, der einen ersten Zeitpunkt festlegt',
	'srf_paramdesc_timelineend' => 'Ein Eigenname, der einen zweiten Zeitpunkt festlegt',
	'srf_paramdesc_timelinesize' => 'Höhe der Zeitleiste (Standard ist 300px)',
	'srf_paramdesc_views' => 'Die anzuzeigenden Ansichten',
	'srf_paramdesc_facets' => 'Die Zusammenstellung der Eigenschaften die für jede Seite angezeigt werden',
	'srf_paramdesc_lens' => 'Der Name einer Vorlage um Seiteneigenschaften anzuzeigen',
	'srf_printername_googlebar' => 'Google Säulen-Diagramm',
	'srf_printername_googlepie' => 'Google Torten-Diagramm',
	'srf_printername_jqplotbar' => 'jqPlot Säulen- oder Balkendiagramm',
	'srf_printername_jqplotpie' => 'jqPlot Kreisdiagramm',
	'srf_paramdesc_chartheight' => 'Höhe des Diagramms (in Pixeln)',
	'srf_paramdesc_chartwidth' => 'Breite des Diagramms (in Pixeln)',
	'srf_paramdesc_charttitle' => 'Der Titel des Diagramms',
	'srf_paramdesc_barcolor' => 'Die Farbe der Balken',
	'srf_paramdesc_bardirection' => 'Ein Säulen- (vertikale Ausrichtung) oder Balkendiagramm (horizontale Ausrichtung)',
	'srf_paramdesc_barnumbersaxislabel' => 'Die Beschriftung der y-Achse',
	'srf_printername_gallery' => 'Galerie',
	'srf_printername_tagcloud' => 'Schlagwortwolke',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'srf-desc' => 'Pśidatne formaty za rědowe wótpšašanja Semantic MediaWiki',
	'srf-name' => 'Formaty semantiskich wuslědkow',
	'srfc_previousmonth' => 'Slědny mjasec',
	'srfc_nextmonth' => 'Pśiducy mjasec',
	'srfc_today' => 'Źinsa',
	'srfc_gotomonth' => 'Źi k mjasecoju',
	'srf_printername_calendar' => 'Mjasecny kalendaŕ',
	'srf_paramdesc_calendarlang' => 'Kode za toś tu rěc, w kótarejž kalendaŕ ma se zwobrazniś',
	'srf_printername_vcard' => 'vCard eksportěrowaś',
	'srf_printername_icalendar' => 'iCalendar eksportěrowaś',
	'srf_paramdesc_icalendartitle' => 'Titel kalendroweje dataje',
	'srf_paramdesc_icalendardescription' => 'Wopisanje kalendroweje dataje',
	'srf_printername_bibtex' => 'BibTeX eksportěrowaś',
	'srf_outline_novalue' => 'Žedna gódnota',
	'srf_printername_outline' => 'Kontura',
	'srf_paramdesc_outlineproperties' => 'Lisćina atributow, kótarež maju se ako rozrědowańske nadpisma zwobrazniś, pśez komy źělone',
	'srf_printername_sum' => 'Suma licbow',
	'srf_printername_average' => 'Pśerězk licbow',
	'srf_printername_max' => 'Maksimalna licba',
	'srf_printername_min' => 'Minimalna licba',
	'srf_paramdesc_limit' => 'Maksimalna licba bokow za napšašowanje',
	'srf_printername_timeline' => 'Casowy wótběg',
	'srf_printername_eventline' => 'Wótběg tšojenjow',
	'srf_paramdesc_timelinebands' => 'Definěruje, kótare smugi zwobraznjuju se we wuslědku.',
	'srf_paramdesc_timelineposition' => 'Definěruje, źož casowa linija ma fokus na zachopjeńku.',
	'srf_paramdesc_timelinestart' => 'Mě atributa, kótarež ma se wužywaś, aby definěrowało prědny casowy dypk',
	'srf_paramdesc_timelineend' => 'Mě atributa, kótarež ma se wužywaś, aby definěrowało drugi casowy dypk',
	'srf_paramdesc_timelinesize' => 'Wusokosć casoweje linije (standard jo 300 piks.)',
	'srf_paramdesc_views' => 'Naglědy, kótarež maju se zwobrazniś',
	'srf_paramdesc_facets' => 'Sajźba atributow, kótarež maju se zwobrazniś za kuždy bok',
	'srf_paramdesc_lens' => 'Mě pśedłogi, z kótarejuž maju se bokowe atributy zwobrazniś',
	'srf_printername_googlebar' => 'Google słupowy diagram',
	'srf_printername_googlepie' => 'Google tortowy diagram',
	'srf_printername_jqplotbar' => 'jqPlot słupowy diagram',
	'srf_printername_jqplotpie' => 'jqPlot tortowy diagram',
	'srf_paramdesc_chartheight' => 'Wusokosć diagrama, w pikselach',
	'srf_paramdesc_chartwidth' => 'Šyrokosć diagrama, w pikselach',
	'srf_paramdesc_charttitle' => 'Titel diagrama',
	'srf_paramdesc_barcolor' => 'Barwa słupow',
	'srf_paramdesc_bardirection' => 'Směr słupowego diagrama',
	'srf_paramdesc_barnumbersaxislabel' => 'Pópisanje za y-wósku',
	'srf_printername_gallery' => 'Galerija',
	'srf_printername_tagcloud' => 'Tafličkowa mróčel',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'srf-desc' => 'Πρόσθετα φορμά για τα inline αιτήματα της Σημασιολογικής MediaWiki',
	'srf-name' => 'Σημασιολογικά Αποτελέσματα Φορμά',
	'srfc_previousmonth' => 'Προηγούμενος μήνας',
	'srfc_nextmonth' => 'Επόμενος μήνας',
	'srfc_today' => 'Σήμερα',
	'srfc_gotomonth' => 'Μετάβαση στον μήνα',
	'srf_printername_calendar' => 'Μηνιαίο ημερολόγιο',
	'srf_printername_vcard' => 'Εξαγωγή vCard',
	'srf_printername_icalendar' => 'Εξαγωγή iCalendar',
	'srf_printername_bibtex' => 'Εξαγωγή BibTeX',
	'srf_outline_novalue' => 'Καμία τιμή',
	'srf_printername_outline' => 'Περίγραμμα',
	'srf_printername_sum' => 'Σύνοψη αριθμών',
	'srf_printername_average' => 'Μέσος όρος αριθμών',
	'srf_printername_max' => 'Μέγιστος αριθμός',
	'srf_printername_min' => 'Ελάχιστος αριθμός',
	'srf_printername_timeline' => 'Ζώνη ώρας',
	'srf_printername_eventline' => 'Ζώνη γεγονότων',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'srfc_previousmonth' => 'Antaŭa monato',
	'srfc_nextmonth' => 'Posta monato',
	'srfc_today' => 'Hodiaŭ',
	'srfc_gotomonth' => 'Iru al monato',
	'srf_printername_calendar' => 'Monata kalendaro',
	'srf_icalendar_link' => 'iKalendaro',
	'srf_outline_novalue' => 'Sen valoro',
	'srf_printername_sum' => 'Sumo de nombroj',
	'srf_printername_average' => 'Averaĝo de nombroj',
	'srf_printername_max' => 'Maksimuma nombro',
	'srf_printername_min' => 'Minimuma nombro',
	'srf_printername_timeline' => 'Templinio',
	'srf_printername_eventline' => 'Eventlinio',
	'srf_printername_gallery' => 'Galerio',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Imre
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'srf-desc' => 'Formatos adicionales para consultas en línea de Semantic MediaWiki',
	'srf-name' => 'Formatos de resultado semántico',
	'srfc_previousmonth' => 'Mes anterior',
	'srfc_nextmonth' => 'Próximo mes',
	'srfc_today' => 'Hoy',
	'srfc_gotomonth' => 'Ir al mes',
	'srf_printername_calendar' => 'Calendario mensual',
	'srf_paramdesc_calendarlang' => 'El código del idioma en el que se muestra el calendario',
	'srf_printername_vcard' => 'Exportar vCard',
	'srf_printername_icalendar' => 'Exportar iCalendar',
	'srf_paramdesc_icalendartitle' => 'El título del archivo de calendario',
	'srf_paramdesc_icalendardescription' => 'El descripción del archivo de calendario',
	'srf_printername_bibtex' => 'Exportar BibTeX',
	'srf_outline_novalue' => 'Sin valor',
	'srf_printername_outline' => 'Esquema',
	'srf_paramdesc_outlineproperties' => 'La lista de propiedades que se mostrará como encabezados de esquema, separadas por comas',
	'srf_printername_sum' => 'Suma de números',
	'srf_printername_average' => 'Promedio de números',
	'srf_printername_max' => 'Número máximo',
	'srf_printername_min' => 'Número mínimo',
	'srf_paramdesc_limit' => 'La cantidad máxima de páginas a consultar',
	'srf_printername_timeline' => 'Línea de tiempo',
	'srf_printername_eventline' => 'Línea de eventos',
	'srf_paramdesc_timelinebands' => 'PDF',
	'srf_paramdesc_timelineposition' => 'Define donde se fijará inicialmente la línea del tiempo.',
	'srf_paramdesc_timelinestart' => 'Un nombre de propiedad utilizado para definir un primer punto temporal',
	'srf_paramdesc_timelineend' => 'Un nombre de propiedad utilizado para definir un segundo punto temporal',
	'srf_paramdesc_timelinesize' => 'La altura de la línea de tiempo (por defecto 300px)',
	'srf_paramdesc_views' => 'Las vistas a mostrar',
	'srf_paramdesc_facets' => 'El grupo de propiedades a mostrar para cada página',
	'srf_paramdesc_lens' => 'El nombre de una plantilla con la que se muestra la propiedades de la página',
	'srf_printername_googlebar' => 'Gráfico de barras de Google',
	'srf_printername_googlepie' => 'Gráfica circular de Google',
	'srf_printername_jqplotbar' => 'Gráfico de barras jqPlot',
	'srf_printername_jqplotpie' => 'Gráfico circular jqPlot',
	'srf_paramdesc_chartheight' => 'La altura del gráfico, en píxeles',
	'srf_paramdesc_chartwidth' => 'La anchura del gráfico, en píxeles',
	'srf_paramdesc_charttitle' => 'El título del gráfico',
	'srf_paramdesc_barcolor' => 'El color de las barras',
	'srf_paramdesc_bardirection' => 'La dirección del gráfico de barras',
	'srf_paramdesc_barnumbersaxislabel' => 'La etiqueta del eje de los números',
	'srf_printername_gallery' => 'Galería',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'srfc_previousmonth' => 'Aurreko hilabetea',
	'srfc_nextmonth' => 'Hurrengo hilabetea',
	'srfc_today' => 'Gaur',
	'srfc_gotomonth' => 'Hilabetera joan',
	'srf_printername_timeline' => 'Denbora-lerroa',
	'srf_printername_eventline' => 'Gertakari-lerroa',
);

/** Persian (فارسی)
 * @author Tofighi
 */
$messages['fa'] = array(
	'srfc_previousmonth' => 'ماه گذشته',
	'srfc_nextmonth' => 'ماه آینده',
	'srfc_today' => 'امروز',
	'srfc_gotomonth' => 'برو به ماه',
);

/** Finnish (Suomi)
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'srfc_previousmonth' => 'Edellinen kuukausi',
	'srfc_nextmonth' => 'Seuraava kuukausi',
	'srfc_today' => 'Tänään',
	'srfc_gotomonth' => 'Siirry kuukauteen',
	'srf_printername_calendar' => 'Kuukausittainen kalenteri',
	'srf_printername_vcard' => 'vCard-vienti',
	'srf_printername_icalendar' => 'iCalendar-vienti',
	'srf_paramdesc_icalendardescription' => 'Kalenteritiedoston kuvaus',
	'srf_printername_bibtex' => 'BibTeX-vienti',
	'srf_outline_novalue' => 'Ei arvoa',
	'srf_printername_sum' => 'Lukujen summa',
	'srf_printername_average' => 'Lukujen keskiarvo',
	'srf_printername_max' => 'Korkein luku',
	'srf_printername_min' => 'Pienin luku',
	'srf_printername_timeline' => 'Aikajana',
	'srf_printername_eventline' => 'Tapahtumajana',
	'srf_paramdesc_views' => 'Näytettävät näkymät',
	'srf_printername_googlebar' => 'Googlen pylväskuvaaja',
	'srf_printername_googlepie' => 'Googlen piirakkakuvaaja',
	'srf_paramdesc_chartheight' => 'Kuvaajan korkeus pikseleinä',
	'srf_paramdesc_chartwidth' => 'Kuvaajan leveys pikseleinä',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Iluvalar
 * @author Peter17
 * @author PieRRoMaN
 * @author Urhixidur
 */
$messages['fr'] = array(
	'srf-desc' => 'Formats additionnels pour les requêtes de Semantic MediaWiki',
	'srf-name' => 'Formatage des résultats sémantiques',
	'srfc_previousmonth' => 'Mois précédent',
	'srfc_nextmonth' => 'Mois suivant',
	'srfc_today' => 'Aujourd’hui',
	'srfc_gotomonth' => 'Aller vers le mois',
	'srf_printername_calendar' => 'Calendrier mensuel',
	'srf_paramdesc_calendarlang' => 'Le code de la langue dans laquelle afficher le calendrier',
	'srf_vcard_link' => 'vCarte',
	'srf_printername_vcard' => 'export en vCard',
	'srf_icalendar_link' => 'iCalendrier',
	'srf_printername_icalendar' => 'export en iCalendar',
	'srf_paramdesc_icalendartitle' => 'Le titre du fichier calendrier',
	'srf_paramdesc_icalendardescription' => 'La description du fichier calendrier',
	'srf_printername_bibtex' => 'export en BibTeX',
	'srf_outline_novalue' => 'Aucune valeur',
	'srf_printername_outline' => 'esquisse',
	'srf_paramdesc_outlineproperties' => 'La liste des propriétés à afficher comme en-têtes, séparées par des virgules',
	'srf_printername_sum' => 'Somme de nombres',
	'srf_printername_average' => 'Moyenne des nombres',
	'srf_printername_max' => 'Nombre maximal',
	'srf_printername_min' => 'Nombre minimal',
	'srf_paramdesc_limit' => 'Le nombre maximum de pages à rechercher',
	'srf_printername_timeline' => 'Chronologie',
	'srf_printername_eventline' => 'Chronologie des événements',
	'srf_paramdesc_timelinebands' => 'Définit quels groupes sont affichées dans les résultats.',
	'srf_paramdesc_timelineposition' => 'Définit la zone de la frise initialement centrée.',
	'srf_paramdesc_timelinestart' => 'Un nom de propriété utilisé pour définir un point de démarrage',
	'srf_paramdesc_timelineend' => 'Un nom de propriété utilisé pour définir un point de seconde date',
	'srf_paramdesc_timelinesize' => 'La hauteur de la frise (300px par défaut)',
	'srf_paramdesc_views' => 'Les vues à afficher',
	'srf_paramdesc_facets' => 'L’ensemble des propriétés à afficher pour chaque page',
	'srf_paramdesc_lens' => 'Le nom du modèle utilisé pour afficher les propriétés de la page',
	'srf_printername_googlebar' => 'Diagramme à barres de Google',
	'srf_printername_googlepie' => 'Diagramme en camembert de Google',
	'srf_printername_jqplotbar' => 'Diagramme en barres jqPlot',
	'srf_printername_jqplotpie' => 'Diagramme camembert jqPlot',
	'srf_paramdesc_chartheight' => 'La hauteur du diagramme, en pixels',
	'srf_paramdesc_chartwidth' => 'La largeur du diagramme, en pixels',
	'srf_paramdesc_charttitle' => 'Le titre du graphique',
	'srf_paramdesc_barcolor' => 'La couleur des barres',
	'srf_paramdesc_bardirection' => 'Direction du diagramme en barres',
	'srf_paramdesc_barnumbersaxislabel' => 'Étiquette pour l’axe numérique',
	'srf_printername_gallery' => 'Galerie',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'srfc_previousmonth' => 'Mês devant',
	'srfc_nextmonth' => 'Mês aprés',
	'srfc_today' => 'Houé',
	'srfc_gotomonth' => 'Alar vers lo mês',
	'srf_printername_calendar' => 'Calendriér du mês',
	'srf_printername_vcard' => 'èxportacion en vCard',
	'srf_printername_icalendar' => 'èxportacion en iCalendar',
	'srf_paramdesc_icalendartitle' => 'Lo titro du fichiér calendriér',
	'srf_paramdesc_icalendardescription' => 'La dèscripcion du fichiér calendriér',
	'srf_printername_bibtex' => 'èxportacion en BibTeX',
	'srf_outline_novalue' => 'Gins de valor',
	'srf_printername_outline' => 'Començon',
	'srf_printername_sum' => 'Soma de nombros',
	'srf_printername_average' => 'Moyena des nombros',
	'srf_printername_timeline' => 'Diagramo cronologico',
	'srf_printername_eventline' => 'Diagramo cronologico des èvènements',
	'srf_printername_gallery' => 'Galerie',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'srf-desc' => 'Outros formatos para Semantic MediaWiki dentro das pescudas',
	'srf-name' => 'Formatos semánticos resultantes',
	'srfc_previousmonth' => 'Mes anterior',
	'srfc_nextmonth' => 'Mes seguinte',
	'srfc_today' => 'Hoxe',
	'srfc_gotomonth' => 'Ir ao mes',
	'srf_printername_calendar' => 'Calendario mensual',
	'srf_paramdesc_calendarlang' => 'O código da lingua na que mostrar o calendario',
	'srf_vcard_link' => 'vTarxeta',
	'srf_printername_vcard' => 'Exportación en vCard',
	'srf_icalendar_link' => 'iCalendario',
	'srf_printername_icalendar' => 'Exportación en iCalendar',
	'srf_paramdesc_icalendartitle' => 'O título do ficheiro de calendario',
	'srf_paramdesc_icalendardescription' => 'A descrición do ficheiro de calendario',
	'srf_printername_bibtex' => 'Exportación en BibTeX',
	'srf_outline_novalue' => 'Sen valor',
	'srf_printername_outline' => 'Esquema',
	'srf_paramdesc_outlineproperties' => 'A lista de propiedades a mostrar como cabeceiras de contorno, separadas por comas',
	'srf_printername_sum' => 'Suma dos números',
	'srf_printername_average' => 'Media dos números',
	'srf_printername_max' => 'Número máximo',
	'srf_printername_min' => 'Número mínimo',
	'srf_paramdesc_limit' => 'O número máximo de páxinas a pescudar',
	'srf_printername_timeline' => 'Liña do tempo',
	'srf_printername_eventline' => 'Liña do evento',
	'srf_paramdesc_timelinebands' => 'Define as bandas que se mostrarán no resultado.',
	'srf_paramdesc_timelineposition' => 'Define onde se fixará inicialmente a liña do tempo.',
	'srf_paramdesc_timelinestart' => 'Un nome de propiedade usado para definir un primeiro punto de tempo',
	'srf_paramdesc_timelineend' => 'Un nome de propiedade usado para definir un segundo punto de tempo',
	'srf_paramdesc_timelinesize' => 'A altura da liña do tempo (por defecto, 300px)',
	'srf_paramdesc_views' => 'As vistas a mostrar',
	'srf_paramdesc_facets' => 'O conxunto de propiedades a mostrar en cada páxina',
	'srf_paramdesc_lens' => 'O nome dun modelo co que mostrar as propiedades da páxina',
	'srf_printername_googlebar' => 'Gráfico de barras do Google',
	'srf_printername_googlepie' => 'Gráfico circular do Google',
	'srf_printername_jqplotbar' => 'Gráfico de barras jqPlot',
	'srf_printername_jqplotpie' => 'Gráfico circular jqPlot',
	'srf_paramdesc_chartheight' => 'A altura do gráfico, en píxeles',
	'srf_paramdesc_chartwidth' => 'O largo do gráfico, en píxeles',
	'srf_paramdesc_charttitle' => 'O título do gráfico',
	'srf_paramdesc_barcolor' => 'A cor das barras',
	'srf_paramdesc_bardirection' => 'A orientación do gráfico de barras',
	'srf_paramdesc_barnumbersaxislabel' => 'A etiqueta para o eixe numérico',
	'srf_printername_gallery' => 'Galería',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'srfc_today' => 'Σήμερον',
	'srf_printername_outline' => 'Περίγραμμα',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'srf-desc' => 'Zuesätzligi Format fir Semantic MediaWiki inline-Abfroge',
	'srf-name' => 'Semantisch Ergebnis-Format',
	'srfc_previousmonth' => 'Vorige Monet',
	'srfc_nextmonth' => 'Negschte Monet',
	'srfc_today' => 'Hit',
	'srfc_gotomonth' => 'Gang zum Monet',
	'srf_printername_calendar' => 'Monetlige Kaländer',
	'srf_paramdesc_calendarlang' => 'Dr Sprochcode fir d Sproch, wu dr Kaländer soll din aazeigt wäre',
	'srf_printername_vcard' => 'vCard-Export',
	'srf_printername_icalendar' => 'iCalendar-Export',
	'srf_paramdesc_icalendartitle' => 'Dr Titel vu dr Kaländerdatei',
	'srf_paramdesc_icalendardescription' => 'D Bschryybig vu dr Kaländerdatei',
	'srf_printername_bibtex' => 'BibTeX-Export',
	'srf_outline_novalue' => 'Kei Wärt',
	'srf_printername_outline' => 'Entwurf',
	'srf_paramdesc_outlineproperties' => 'D Lischt vu dr Eigeschafte, wu as Ibersichts-Chopftext aazeigt wird, dur Komma trännt',
	'srf_printername_sum' => 'Zahl vu Nummere',
	'srf_printername_average' => 'Durschnitt vu Nummere',
	'srf_printername_max' => 'Hegschti Nummere',
	'srf_printername_min' => 'Niderschti Nummere',
	'srf_paramdesc_limit' => 'Di maximal Sytezahl, wu abgfrogt wird',
	'srf_printername_timeline' => 'Zytlyschte',
	'srf_printername_eventline' => 'Ereignislyschte',
	'srf_paramdesc_timelinebands' => 'Definiert d Skalierig, wu d Ergebnis aazeigt wäre.',
	'srf_paramdesc_timelineposition' => 'Definiert dr Schwärpunkt vu dr Zytachse.',
	'srf_paramdesc_timelinestart' => 'Dr Name vu dr Eigeschaft, wu dr erscht Zytpunkt definiert',
	'srf_paramdesc_timelineend' => 'Dr Name vu dr Eigenschaft, wu dr zwet Zytpunkt definiert',
	'srf_paramdesc_timelinesize' => 'D Hechi vu dr Zytachse (Standard: 300 px)',
	'srf_paramdesc_views' => 'D Ibersichte, wu aazeigt wäre',
	'srf_paramdesc_facets' => 'D Eigeschafte, wu uf jedere Syte solle aazeigt wäre',
	'srf_paramdesc_lens' => 'Dr Name vu dr Vorlag, wu Syteneigeschafte dermit aazeigt wäre',
	'srf_printername_googlebar' => 'Google-Syylediagramm',
	'srf_printername_googlepie' => 'Google-Kreisdiagramm',
	'srf_printername_jqplotbar' => 'jqPlot Balkediagramm',
	'srf_printername_jqplotpie' => 'jqPlot Chreisdiagramm',
	'srf_paramdesc_chartheight' => 'D Hechi vum Diagramm, in Pixel',
	'srf_paramdesc_chartwidth' => 'D Breiti vum Diagramm, in Pixel',
	'srf_paramdesc_charttitle' => 'Dr Titel vum Diagramm',
	'srf_paramdesc_barcolor' => 'D Farb vu dr Balke',
	'srf_paramdesc_bardirection' => 'E Syyle- (sänkrächti Uusrichtig) oder Balkediagramm (woogrächti Uusrichtig)',
	'srf_paramdesc_barnumbersaxislabel' => 'D Bschryftig vu dr Zahle-Achs',
	'srf_printername_gallery' => 'Galeri',
	'srf_printername_tagcloud' => 'Schlagwortwulche',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'srfc_previousmonth' => 'Yn vee roish shen',
	'srfc_nextmonth' => 'Yn chied vee elley',
	'srfc_today' => 'Jiu',
);

/** Hebrew (עברית)
 * @author StuB
 * @author YaronSh
 */
$messages['he'] = array(
	'srfc_previousmonth' => 'החודש הקודם',
	'srfc_nextmonth' => 'החודש הבא',
	'srfc_today' => 'היום',
	'srfc_gotomonth' => 'מעבר לחודש',
	'srf_printername_calendar' => 'לוח חודשי',
	'srf_printername_vcard' => 'ייצוא vCard',
	'srf_printername_icalendar' => 'ייצוא iCalendar',
	'srf_paramdesc_icalendartitle' => 'כותרת קובץ לוח השנה',
	'srf_paramdesc_icalendardescription' => 'תיאור קובץ לוח השנה',
	'srf_printername_bibtex' => 'ייצוא BibTeX',
	'srf_outline_novalue' => 'אין ערך',
	'srf_printername_sum' => 'סכום של מספרים',
	'srf_printername_average' => 'ממוצע של מספרים',
	'srf_printername_max' => 'המספר המירבי',
	'srf_printername_min' => 'מספר מינימלי',
	'srf_paramdesc_limit' => 'מספר הדפים המרבי לתשאול',
	'srf_printername_timeline' => 'ציר זמן',
	'srf_printername_eventline' => 'ציר אירועים',
	'srf_paramdesc_timelinesize' => 'גובה ציר הזמן (ברירת המחדל היא 300 פיקסלים)',
	'srf_paramdesc_views' => 'התצוגות להצגה',
	'srf_paramdesc_lens' => 'שם התבנית שבאמצעותה יוצגו מאפייני הדף',
	'srf_printername_googlebar' => 'תרשים עמודות של Google',
	'srf_printername_googlepie' => 'דיאגרמת עוגה של גוגל',
	'srf_paramdesc_chartheight' => 'גובה התרשים, בפיקסלים',
	'srf_paramdesc_chartwidth' => 'רוחב התרשים, בפיקסלים',
	'srf_paramdesc_charttitle' => 'כותרת התרשים',
	'srf_paramdesc_barcolor' => 'צבע הפסים',
	'srf_printername_gallery' => 'גלריה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'srfc_previousmonth' => 'पिछला महिना',
	'srfc_nextmonth' => 'अगला महिना',
	'srfc_today' => 'आज़',
	'srfc_gotomonth' => 'महिनेपर चलें',
	'srf_icalendar_link' => 'आइकैलेंडर',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'srf-desc' => 'Přidatne formaty za rjadowe wotprašowanja Semantic MediaWiki',
	'srf-name' => 'Formaty semantiskich wuslědkow',
	'srfc_previousmonth' => 'Předchadny měsac',
	'srfc_nextmonth' => 'Přichodny měsac',
	'srfc_today' => 'Dźensa',
	'srfc_gotomonth' => 'Dźi k měsacej',
	'srf_printername_calendar' => 'Měsačna protyka',
	'srf_paramdesc_calendarlang' => 'Kod za rěč, w kotrejž protyka ma so zwobraznić',
	'srf_printername_vcard' => 'vCard eksportować',
	'srf_printername_icalendar' => 'iCalendar eksportować',
	'srf_paramdesc_icalendartitle' => 'Titul protykoweje dataje',
	'srf_paramdesc_icalendardescription' => 'Wopisanje protykoweje dataje',
	'srf_printername_bibtex' => 'BibTeX eksportować',
	'srf_outline_novalue' => 'Žana hódnota',
	'srf_printername_outline' => 'Kontura',
	'srf_paramdesc_outlineproperties' => 'Lisćina kajkosćow, kotryž maja so jako rozrjadowanske nadpisma, přez komy dźělene',
	'srf_printername_sum' => 'Suma ličbow',
	'srf_printername_average' => 'Přerězk ličbow',
	'srf_printername_max' => 'Maksimalna ličba',
	'srf_printername_min' => 'Minimalna ličba',
	'srf_paramdesc_limit' => 'Maksimalna ličba stronow za naprašowanje',
	'srf_printername_timeline' => 'Časowa wotběh',
	'srf_printername_eventline' => 'Wotběh podawkow',
	'srf_paramdesc_timelinebands' => 'Definuje, kotre smuhi so we wuslědku zwobraznjeja.',
	'srf_paramdesc_timelineposition' => 'Definuje, hdźež časowa linija na spočatku ma swój fokus.',
	'srf_paramdesc_timelinestart' => 'Mjeno atributa, kotrež so wužiwa, zo by prěni časowy dypk definowało',
	'srf_paramdesc_timelineend' => 'Mjeno atributa, kotrež so wužiwa, zo by druhi časowy dypk definowało',
	'srf_paramdesc_timelinesize' => 'Wysokosć časoweje linije (standard je 300 piks.)',
	'srf_paramdesc_views' => 'Napohlady, kotrež maja so zwobraznić',
	'srf_paramdesc_facets' => 'Sadźba atributow, kotrež maja so za kóždu stronu zwobraznić',
	'srf_paramdesc_lens' => 'Mjeno předłohi, z kotrejž atributy strony maja so zwobraznić',
	'srf_printername_googlebar' => 'Google hrjadowy diagram',
	'srf_printername_googlepie' => 'Google tortowy diagram',
	'srf_printername_jqplotbar' => 'Stołpowy abo hrjadowy diagram jgPlot',
	'srf_printername_jqplotpie' => 'Kružny diagram jqPlot',
	'srf_paramdesc_chartheight' => 'Wysokosć diagrama, w pikselach',
	'srf_paramdesc_chartwidth' => 'Šěrokosć diagrama, w pikselach',
	'srf_paramdesc_charttitle' => 'Titul diagrama',
	'srf_paramdesc_barcolor' => 'Barba hrjadow/stołpow',
	'srf_paramdesc_bardirection' => 'Stołpowy diagram abo hrjadowy diagram',
	'srf_paramdesc_barnumbersaxislabel' => 'Popisanje y-wóski',
	'srf_printername_gallery' => 'Galerija',
	'srf_printername_tagcloud' => 'Tafličkowa mróčel',
);

/** Haitian (Kreyòl ayisyen)
 * @author Jvm
 * @author Masterches
 */
$messages['ht'] = array(
	'srf_icalendar_link' => 'iKalandrye',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'srf-desc' => 'További formátumok a Szemantikus MediaWiki beépített lekérdezéseihez',
	'srf-name' => 'Szemantikus eredményformátumok',
	'srfc_previousmonth' => 'Előző hónap',
	'srfc_nextmonth' => 'Következő hónap',
	'srfc_today' => 'Ma',
	'srfc_gotomonth' => 'Ugrás hónapra',
	'srf_printername_calendar' => 'Havi naptár',
	'srf_printername_vcard' => 'vCard exportálás',
	'srf_printername_icalendar' => 'iCalendar exportálás',
	'srf_paramdesc_icalendartitle' => 'A naptárfájl címe',
	'srf_paramdesc_icalendardescription' => 'A naptárfájl leírása',
	'srf_printername_bibtex' => 'BibTeX exportálás',
	'srf_outline_novalue' => 'Nincs érték',
	'srf_printername_outline' => 'Tagolt',
	'srf_printername_sum' => 'A számok összege',
	'srf_printername_average' => 'A számok átlaga',
	'srf_printername_max' => 'Legnagyobb szám',
	'srf_printername_min' => 'Legkisebb szám',
	'srf_printername_timeline' => 'Idővonal',
	'srf_printername_eventline' => 'Eseményvonal',
	'srf_paramdesc_timelinesize' => 'Az idővonal magassága (alapértelmezetten 300 képpont)',
	'srf_paramdesc_views' => 'Megjelenített nézetek',
	'srf_printername_googlebar' => 'Google oszlopdiagram',
	'srf_printername_googlepie' => 'Google tortadiagram',
	'srf_printername_jqplotbar' => 'jpPlot oszlopdiagram',
	'srf_printername_jqplotpie' => 'jqPlot kördiagram',
	'srf_paramdesc_chartheight' => 'A diagram magassága, pixelben',
	'srf_paramdesc_chartwidth' => 'A diagram szélessége, pixelben',
	'srf_paramdesc_charttitle' => 'A diagram címe',
	'srf_paramdesc_barcolor' => 'Az oszlopok színe',
	'srf_paramdesc_bardirection' => 'Az oszlopdiagram iránya',
	'srf_paramdesc_barnumbersaxislabel' => 'A számtengely felirata',
	'srf_printername_gallery' => 'Galéria',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'srf-desc' => 'Formatos additional pro incorporar consultas de Semantic MediaWiki',
	'srf-name' => 'Formatos de resultatos semantic',
	'srfc_previousmonth' => 'Mense precedente',
	'srfc_nextmonth' => 'Mense sequente',
	'srfc_today' => 'Hodie',
	'srfc_gotomonth' => 'Ir al mense',
	'srf_printername_calendar' => 'Calendario mensual',
	'srf_paramdesc_calendarlang' => 'Le codice del lingua in le qual monstrar le calendario',
	'srf_printername_vcard' => 'Exportation in vCard',
	'srf_printername_icalendar' => 'Exportation in iCalendar',
	'srf_paramdesc_icalendartitle' => 'Le titulo del file del calendario',
	'srf_paramdesc_icalendardescription' => 'Le description del file del calendario',
	'srf_printername_bibtex' => 'Exportation in BibTeX',
	'srf_outline_novalue' => 'Nulle valor',
	'srf_printername_outline' => 'Schizzo',
	'srf_paramdesc_outlineproperties' => 'Le lista de proprietates a presentar como capites de structura, separate per commas',
	'srf_printername_sum' => 'Total del numeros',
	'srf_printername_average' => 'Media del numeros',
	'srf_printername_max' => 'Numero maxime',
	'srf_printername_min' => 'Numeros minime',
	'srf_paramdesc_limit' => 'Le numero maxime de paginas a consultar',
	'srf_printername_timeline' => 'Chronologia',
	'srf_printername_eventline' => 'Chronologia de eventos',
	'srf_paramdesc_timelinebands' => 'Defini qual bandas es monstrate in le resultato.',
	'srf_paramdesc_timelineposition' => 'Defini ubi le chronologia se concentra initialmente.',
	'srf_paramdesc_timelinestart' => 'Un nomine de proprietate usate pro definir un prime puncto de tempore',
	'srf_paramdesc_timelineend' => 'Un nomine de proprietate usate pro definir un secunde puncto de tempore',
	'srf_paramdesc_timelinesize' => 'Le altitude del chronologia (predefinition es 300px)',
	'srf_paramdesc_views' => 'Le vistas a monstrar',
	'srf_paramdesc_facets' => 'Le insimul de proprietates a monstrar pro cata pagina',
	'srf_paramdesc_lens' => 'Le nomine de un patrono con le qual monstrar le proprietates de pagina',
	'srf_printername_googlebar' => 'Diagramma a barras de Google',
	'srf_printername_googlepie' => 'Diagramma circular de Google',
	'srf_printername_jqplotbar' => 'Diagramma de barras jqPlot',
	'srf_printername_jqplotpie' => 'Diagramma circular jqPlot',
	'srf_paramdesc_chartheight' => 'Le altitude del diagramma, in pixeles',
	'srf_paramdesc_chartwidth' => 'Le latitude del diagramma, in pixeles',
	'srf_paramdesc_charttitle' => 'Le titulo del diagramma',
	'srf_paramdesc_barcolor' => 'Le color del barras',
	'srf_paramdesc_bardirection' => 'Le orientation del diagramma de barras',
	'srf_paramdesc_barnumbersaxislabel' => 'Le etiquetta pro le axe de numeros',
	'srf_printername_gallery' => 'Galeria',
	'srf_printername_tagcloud' => 'Etiquettario',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Kenrick95
 */
$messages['id'] = array(
	'srf-desc' => 'Format tambahan untuk kueri Semantik MediaWiki',
	'srf-name' => 'Format Hasil Semantik',
	'srfc_previousmonth' => 'Bulan lalu',
	'srfc_nextmonth' => 'Bulan depan',
	'srfc_today' => 'Hari ini',
	'srfc_gotomonth' => 'Pergi ke bulan',
	'srf_printername_calendar' => 'Kalender bulanan',
	'srf_paramdesc_calendarlang' => 'Kode untuk bahasa yang digunakan untuk menampilkan kalender',
	'srf_printername_vcard' => 'Ekspor vCard',
	'srf_printername_icalendar' => 'Ekspor iCalendar',
	'srf_paramdesc_icalendartitle' => 'Judul berkas kalender',
	'srf_paramdesc_icalendardescription' => 'Deskripsi berkas kalender',
	'srf_printername_bibtex' => 'Ekspor BibTeX',
	'srf_outline_novalue' => 'Tanpa nilai',
	'srf_printername_outline' => 'Ikhtisar',
	'srf_paramdesc_outlineproperties' => 'Daftar properti yang akan ditampilkan sebagai kepala luar, dipisah oleh koma',
	'srf_printername_sum' => 'Jumlah angka',
	'srf_printername_average' => 'Angka rata-rata',
	'srf_printername_max' => 'Angka maksimum',
	'srf_printername_min' => 'Angka minimum',
	'srf_paramdesc_limit' => 'Jumlah maksimal halaman yang dicari',
	'srf_printername_timeline' => 'Garis waktu',
	'srf_printername_eventline' => 'Garis kejadian',
	'srf_paramdesc_timelinebands' => 'Menetapkan tanda yang mana yang ditampilkan di hasil.',
	'srf_paramdesc_timelineposition' => 'Menetapkan tempat fokus awal garis waktu.',
	'srf_paramdesc_timelinestart' => 'Nama properti untuk menetapkan titik waktu pertama',
	'srf_paramdesc_timelineend' => 'Nama properti untuk menetapkan titik waktu kedua',
	'srf_paramdesc_timelinesize' => 'Tinggi garis waktu (umumnya 200px)',
	'srf_paramdesc_views' => 'Pandangan yang akan ditampilkan',
	'srf_paramdesc_facets' => 'Rangkaian properti untuk ditampilkan di setiap halaman',
	'srf_paramdesc_lens' => 'Nama templat untuk menampilkan properti halaman',
	'srf_printername_googlebar' => 'Grafik batang Google',
	'srf_printername_googlepie' => 'Grafik pai Google',
	'srf_printername_jqplotbar' => 'Grafik batang jqPlot',
	'srf_printername_jqplotpie' => 'Grafik pai jqPlot',
	'srf_paramdesc_chartheight' => 'Tinggi grafik, dalam piksel',
	'srf_paramdesc_chartwidth' => 'Lebar grafik, dalam piksel',
	'srf_paramdesc_charttitle' => 'Judul grafik',
	'srf_paramdesc_barcolor' => 'Warna batang',
	'srf_paramdesc_bardirection' => 'Arah grafik batang',
	'srf_paramdesc_barnumbersaxislabel' => 'Label untuk poros nomor',
	'srf_printername_gallery' => 'Galeri',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'srfc_gotomonth' => 'Ga na önwa',
	'srf_printername_timeline' => 'Ahiriogẹ',
	'srf_printername_eventline' => 'Ahiriomémé',
	'srf_printername_googlebar' => 'Ngwa nkuzie Google',
	'srf_printername_googlepie' => 'Orịrị nkuzie Google',
	'srf_paramdesc_chartheight' => 'Ógólógó ihü nkuzie, na ogụgụ pixel',
	'srf_paramdesc_chartwidth' => 'Íbụ ihü nkuzie, na ogụgụ pixel',
);

/** Italian (Italiano)
 * @author Civvì
 * @author Darth Kule
 */
$messages['it'] = array(
	'srf-desc' => 'Formati addizionali per le query di Semantic Mediawiki',
	'srf-name' => 'Formati di risultato semantici',
	'srfc_previousmonth' => 'Mese precedente',
	'srfc_nextmonth' => 'Mese successivo',
	'srfc_today' => 'Oggi',
	'srfc_gotomonth' => 'Vai al mese',
	'srf_printername_calendar' => 'Calendario mensile',
	'srf_paramdesc_calendarlang' => 'Il codice per la lingua in cui visualizzare il calendario',
	'srf_printername_vcard' => 'esportazione vCard',
	'srf_printername_icalendar' => 'esportazione iCalendar',
	'srf_paramdesc_icalendartitle' => 'Il titolo del file di calendario',
	'srf_paramdesc_icalendardescription' => 'La descrizione del file di calendario',
	'srf_printername_bibtex' => 'esportazione BibTeX',
	'srf_outline_novalue' => 'Nessun valore',
	'srf_printername_outline' => 'Contorno',
	'srf_paramdesc_outlineproperties' => "L'elenco delle proprietà, separate da virgola, da visualizzare come intestazioni di contorno",
	'srf_printername_sum' => 'Somma di numeri',
	'srf_printername_average' => 'Media dei numeri',
	'srf_printername_max' => 'Numero massimo',
	'srf_printername_min' => 'Numero minimo',
	'srf_paramdesc_limit' => 'Il numero massimo di pagine per eseguire una query',
	'srf_printername_timeline' => 'Linea del tempo (timeline)',
	'srf_printername_eventline' => 'Linea degli eventi',
	'srf_paramdesc_timelinebands' => 'Definisce quali bande temporali vengono visualizzati nel risultato',
	'srf_paramdesc_timelineposition' => 'Definisce in quale punto inizia la linea del tempo',
	'srf_paramdesc_timelinestart' => 'Il nome della proprietà usata per definire il primo punto temporale',
	'srf_paramdesc_timelineend' => 'Il nome della proprietà usata per definire il secondo punto temporale',
	'srf_paramdesc_timelinesize' => "L'altezza della linea temporale (il default è 300px)",
	'srf_paramdesc_views' => 'Le visualizzazioni da mostrare',
	'srf_paramdesc_facets' => "L'insieme di proprietà da visualizzare per ogni pagina",
	'srf_paramdesc_lens' => 'Il nome di un template con cui mostrare le proprietà della pagina',
	'srf_printername_googlebar' => 'Google bar chart',
	'srf_printername_googlepie' => 'Google grafico a torta',
	'srf_paramdesc_chartheight' => "L'altezza del grafico, in pixel",
	'srf_paramdesc_chartwidth' => 'La larghezza del grafico, in pixel',
	'srf_printername_gallery' => 'Galleria',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author Naohiro19
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'srf-desc' => 'Semantic MediaWiki のインラインクエリーのための追加的なフォーマット',
	'srf-name' => 'セマンティック・リザルト・フォーマット',
	'srfc_previousmonth' => '前の月',
	'srfc_nextmonth' => '次の月',
	'srfc_today' => '今日',
	'srfc_gotomonth' => 'この月を表示',
	'srf_printername_calendar' => '月毎のカレンダー',
	'srf_paramdesc_calendarlang' => 'カレンダーを表示するための言語コード',
	'srf_printername_vcard' => 'vCard形式で書き出し',
	'srf_printername_icalendar' => 'iCalender形式で書き出し',
	'srf_paramdesc_icalendartitle' => 'カレンダーファイルのタイトル',
	'srf_paramdesc_icalendardescription' => 'カレンダーファイルの説明',
	'srf_printername_bibtex' => 'BibTeX形式で書き出し',
	'srf_outline_novalue' => '値なし',
	'srf_printername_outline' => 'アウトライン',
	'srf_paramdesc_outlineproperties' => 'アウトラインの見出しとして表示されるプロパティーのリスト。コンマ区切り',
	'srf_printername_sum' => '数の合計',
	'srf_printername_average' => '数の平均',
	'srf_printername_max' => '最大数',
	'srf_printername_min' => '最小数',
	'srf_paramdesc_limit' => '問い合わせするページの最大数',
	'srf_printername_timeline' => '時系列',
	'srf_printername_eventline' => '事象系列',
	'srf_paramdesc_timelinebands' => '出力結果にどの時間単位を表示するか定義する。',
	'srf_paramdesc_timelineposition' => '初期状態でタイムラインがどこにフォーカスしているか定義する。',
	'srf_paramdesc_timelinestart' => '最初の時点を定義するプロパティーの名前',
	'srf_paramdesc_timelineend' => '2番目の時点を定義するプロパティーの名前',
	'srf_paramdesc_timelinesize' => 'タイムラインの縦幅 (既定では300ピクセル)',
	'srf_paramdesc_views' => '表示されるビュー',
	'srf_paramdesc_facets' => '各ページで表示するプロパティーの集合',
	'srf_paramdesc_lens' => 'ページのプロパティーとともに表示するテンプレートの名前',
	'srf_printername_googlebar' => 'Google 棒グラフ',
	'srf_printername_googlepie' => 'Google 円グラフ',
	'srf_printername_jqplotbar' => 'jqPlot棒グラフ',
	'srf_printername_jqplotpie' => 'jqPlot円グラフ',
	'srf_paramdesc_chartheight' => 'グラフの縦幅 (ピクセル単位)',
	'srf_paramdesc_chartwidth' => 'グラフの横幅 (ピクセル単位)',
	'srf_paramdesc_charttitle' => '図のタイトル',
	'srf_paramdesc_barcolor' => '棒の色',
	'srf_paramdesc_bardirection' => '棒グラフの方向',
	'srf_paramdesc_barnumbersaxislabel' => '数値軸のラベル',
	'srf_printername_gallery' => 'ギャラリー',
	'srf_printername_tagcloud' => 'タグクラウド',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'srfc_previousmonth' => 'Sasi sadurungé',
	'srfc_nextmonth' => 'Sasi sabanjuré',
	'srfc_today' => 'Dina iki',
	'srfc_gotomonth' => 'Tumuju menyang sasi',
	'srf_icalendar_link' => 'iKalèndher',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'srfc_previousmonth' => 'ខែមុន',
	'srfc_nextmonth' => 'ខែបន្ទាប់',
	'srfc_today' => 'ថ្ងៃនេះ',
	'srfc_gotomonth' => 'ទៅកាន់ខែ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'srf-desc' => 'Zohsäzlejje Fommaate för dem „Semantesch MediaWiki“ sing Froore em Täx vun Sigge.',
	'srf-name' => 'Fomaate för wat bei Semantesch Froore eruß kohm',
	'srfc_previousmonth' => 'Jangk nohm Moohnd dovör',
	'srfc_nextmonth' => 'Jangk nohm näkßte Moohnd',
	'srfc_today' => 'Hück',
	'srfc_gotomonth' => 'Jangk noh däm Moohnd',
	'srf_printername_calendar' => 'Dä Kaländer fum Mohnd',
	'srf_vcard_link' => '<i lang="en">vCard</i>',
	'srf_printername_vcard' => 'Expoot em <i lang="en">vCard</i>-Fommaat',
	'srf_icalendar_link' => '<i lang="en">iCalendar</i>',
	'srf_printername_icalendar' => 'Expoot em Fommaat vun <i lang="en">iCalendar</i>',
	'srf_paramdesc_icalendartitle' => 'Dä Tittel vun dä Datteij met däm Kalländer',
	'srf_paramdesc_icalendardescription' => 'Wi de Datteij met däm Kalländer beschrevve es',
	'srf_printername_bibtex' => 'Expoot em <i lang="en">BibTeX</i>-Fommaat',
	'srf_outline_novalue' => 'Keine Wäät',
	'srf_printername_outline' => 'Övverblecks_Leß',
	'srf_paramdesc_outlineproperties' => 'De Leß met Eijeschaffte, di als Övverschreffte för en Jlidderung aanjezeijsch wääde sulle, met Kommas dozwesche',
	'srf_printername_sum' => 'De Zahle zosammejetrocke',
	'srf_printername_average' => 'Der Schnett vun dä Zahle',
	'srf_printername_max' => 'De kleinßte Nommer',
	'srf_printername_min' => 'De jüüßte Nommer',
	'srf_paramdesc_limit' => 'De jrüüßte Zahl Sigge för dren ze söhke',
	'srf_printername_timeline' => 'De Reih noh de Zigk',
	'srf_printername_eventline' => 'De Reih noh dämm, wat vörjekumme es',
	'srf_paramdesc_timelinebands' => 'Jitt aan, wat för en Zickraster aanjezeijsch wääde sulle.',
	'srf_paramdesc_timelineposition' => 'Läät faß, woh de Zicklinnesch et eetz drop ußjereschdt es.',
	'srf_paramdesc_timelinestart' => 'Ene Eijeschaff iere Name, di jebruch weed, öm ene eezte Zickpungk faßzelääje',
	'srf_paramdesc_timelineend' => 'Ene Eijeschaff iere Name, di jebruch weed, öm ene zweijte Zickpungk faßzelääje',
	'srf_paramdesc_timelinesize' => 'De Hühde vun dä Zick-Linnesch — dä Schtandatt sėn 300 Pixelle',
	'srf_paramdesc_views' => 'De Aansėschte för aanzezeije',
	'srf_paramdesc_facets' => 'De Eijeschaffte, di för jeede Sigg annjezeijsch wääde sulle',
	'srf_paramdesc_lens' => 'Ene Schabloon iere Name, woh mer de Eijeschaffte vun ene Sigg aanzeije lohße kann',
	'srf_printername_googlebar' => 'E Balleke-Dijajramm vun <i lang="en">Google</i>',
	'srf_printername_googlepie' => 'E Kreijß-Dijajramm vun <i lang="en">Google</i>',
	'srf_paramdesc_chartheight' => 'Dämm Dijajramm sing Hühde en Pixelle',
	'srf_paramdesc_chartwidth' => 'Dämm Dijajramm sing Breedt en Pixelle',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'srfc_today' => 'Îro',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'srf-name' => 'Formate vu semantesche Resultater',
	'srfc_previousmonth' => 'Mount virdrun',
	'srfc_nextmonth' => 'Nächste Mount',
	'srfc_today' => 'Haut',
	'srfc_gotomonth' => 'Géi op de Mount',
	'srf_printername_calendar' => 'Monatleche Kalenner',
	'srf_paramdesc_calendarlang' => 'De Code vun der Sprooch an där de Kalenner gewise gëtt',
	'srf_printername_vcard' => 'Export als vCard',
	'srf_icalendar_link' => 'iKalenner',
	'srf_printername_icalendar' => 'Export als iCalendar',
	'srf_paramdesc_icalendartitle' => 'Den Titel vum Kalenner-Fichier',
	'srf_paramdesc_icalendardescription' => "D'Beschreiwung vum Kalenner-Fichier",
	'srf_printername_bibtex' => 'Export als BibTeX',
	'srf_outline_novalue' => 'Kee Wäert',
	'srf_printername_sum' => 'Total vun den Zuelen',
	'srf_printername_average' => 'Duerchschnëtt vun den Zuelen',
	'srf_printername_max' => 'Maximal Zuel',
	'srf_printername_min' => 'Minimal Zuel',
	'srf_paramdesc_limit' => "D'Maximal Zuel vu Säite fir ofzefroen",
	'srf_printername_timeline' => 'Chronologie',
	'srf_printername_eventline' => 'Chronologie vun den Evenementer',
	'srf_paramdesc_timelinesize' => "D'Héicht vun der Zäitläischt (Standard ass 300px)",
	'srf_paramdesc_views' => 'Déi Usiichten déi gewise solle ginn',
	'srf_paramdesc_lens' => 'Den Numm vun enger Schabloun mat där Säiteneegeschafte gewise  ginn',
	'srf_printername_googlebar' => 'Google-Sailen-Diagramm',
	'srf_printername_googlepie' => 'Google-Taarten-Diagramm',
	'srf_printername_jqplotbar' => 'jqPlot Sailen- oder Balkendiagramm',
	'srf_printername_jqplotpie' => 'jqPlot Taartendiagramm',
	'srf_paramdesc_chartheight' => "D'Héicht vun der Grafik, a Pixel",
	'srf_paramdesc_chartwidth' => "D'Breet vun der Grafik, a Pixel",
	'srf_paramdesc_charttitle' => 'Den Titel vum Diagramm',
	'srf_paramdesc_barcolor' => "D'Faarf vun de Balken",
	'srf_paramdesc_bardirection' => "D'Ausriichtung vum Balken-Diagramm",
	'srf_paramdesc_barnumbersaxislabel' => "D'Etiquette fir d'Achs vun den Zuelen",
	'srf_printername_gallery' => 'Gallerie',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'srfc_previousmonth' => 'Praeitas mėnuo',
	'srfc_nextmonth' => 'Ateinantis mėnuo',
	'srfc_today' => 'Šiandien',
	'srfc_gotomonth' => 'Eiti į mėnesį',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'srf-desc' => 'Дополнителни формати за барања од Semantic MediaWiki',
	'srf-name' => 'Семантички формати на резултати',
	'srfc_previousmonth' => 'Претходен месец',
	'srfc_nextmonth' => 'Следен месец',
	'srfc_today' => 'Денес',
	'srfc_gotomonth' => 'Оди на месецот',
	'srf_printername_calendar' => 'Месечен календар',
	'srf_paramdesc_calendarlang' => 'Кодот на јазикот на кој ќе се прикажува календарот',
	'srf_printername_vcard' => 'Извоз на vCard',
	'srf_icalendar_link' => 'iКалендар',
	'srf_printername_icalendar' => 'Извоз на iCalendar',
	'srf_paramdesc_icalendartitle' => 'Насловот на податотеката на календарот',
	'srf_paramdesc_icalendardescription' => 'Описот на податотеката на календарот',
	'srf_printername_bibtex' => 'Извоз на BibTeX',
	'srf_outline_novalue' => 'Нема вредност',
	'srf_printername_outline' => 'Преглед',
	'srf_paramdesc_outlineproperties' => 'Список на својствата за прикажување како заглавија, одделени со запирки',
	'srf_printername_sum' => 'Збир од броевите',
	'srf_printername_average' => 'Просек од броевите',
	'srf_printername_max' => 'Максимален број',
	'srf_printername_min' => 'Минимален број',
	'srf_paramdesc_limit' => 'Максимален број на страници кои можат да се пребараат',
	'srf_printername_timeline' => 'Хронологија',
	'srf_printername_eventline' => 'Преглед на настани',
	'srf_paramdesc_timelinebands' => 'Определува кои ленти ќе се прикажуваат во резултатот.',
	'srf_paramdesc_timelineposition' => 'Определува каде временската скала најпрвин ќе се фокусира.',
	'srf_paramdesc_timelinestart' => 'Име на својството кое се користи за определување на првата временска точка',
	'srf_paramdesc_timelineend' => 'Име на својството кое се користи за определување на втората временска точка',
	'srf_paramdesc_timelinesize' => 'Висината на временската скала (300px по посновно)',
	'srf_paramdesc_views' => 'Погледите за прикажување',
	'srf_paramdesc_facets' => 'Збирот својства кои ќе се прикажуваат на секоја страница',
	'srf_paramdesc_lens' => 'Името на шаблонот со кој ќе се прикажат својствата на страницата',
	'srf_printername_googlebar' => 'Столбен дијаграм од Google',
	'srf_printername_googlepie' => 'Кружен дијаграм од Google',
	'srf_printername_jqplotbar' => 'Столбен графикон jqPlot',
	'srf_printername_jqplotpie' => 'Кружен графикон jqPlot',
	'srf_paramdesc_chartheight' => 'Висината на дијаграмот, во пиксели',
	'srf_paramdesc_chartwidth' => 'Ширината на дијаграмот, во пиксели',
	'srf_paramdesc_charttitle' => 'Насловот на графиконот',
	'srf_paramdesc_barcolor' => 'Бојата на столбовите',
	'srf_paramdesc_bardirection' => 'Насока на столбниот графикон',
	'srf_paramdesc_barnumbersaxislabel' => 'Натпис за бројната оска',
	'srf_printername_gallery' => 'Галерија',
	'srf_printername_tagcloud' => 'Облак со ознаки',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'srfc_previousmonth' => 'കഴിഞ്ഞ മാസം',
	'srfc_nextmonth' => 'അടുത്ത മാസം',
	'srfc_today' => 'ഇന്ന്',
	'srfc_gotomonth' => 'മാസത്തിലേക്ക് പോവുക',
	'srf_icalendar_link' => 'iകലണ്ടർ',
);

/** Marathi (मराठी)
 * @author Mahitgar
 */
$messages['mr'] = array(
	'srfc_previousmonth' => 'मागचा महीना',
	'srfc_nextmonth' => 'पुढचा महीना',
	'srfc_today' => 'आज',
	'srfc_gotomonth' => 'महीन्याकडे चला',
	'srf_icalendar_link' => 'इ-कैलेंडर',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'srfc_previousmonth' => 'Йутазь ковсто',
	'srfc_nextmonth' => 'Сы ковсто',
	'srfc_today' => 'Течи',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'srfc_previousmonth' => 'Achto mētztli',
	'srfc_nextmonth' => 'Niman mētztli',
	'srfc_today' => 'Āxcān',
	'srfc_gotomonth' => 'Yāuh mētzhuīc',
);

/** Dutch (Nederlands)
 * @author GerardM
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'srf-desc' => 'Aanvullende formaten voor inline zoekopdrachten via Semantic MediaWiki',
	'srf-name' => 'Semantische resultaatformaten',
	'srfc_previousmonth' => 'Vorige maand',
	'srfc_nextmonth' => 'Volgende maand',
	'srfc_today' => 'Vandaag',
	'srfc_gotomonth' => 'Ga naar maand',
	'srf_printername_calendar' => 'Maandkalender',
	'srf_paramdesc_calendarlang' => 'De taalcode voor de taal waarin de kalender wordt weergegeven',
	'srf_printername_vcard' => 'Naar vCard exporteren',
	'srf_printername_icalendar' => 'Naar iCalendar exporteren',
	'srf_paramdesc_icalendartitle' => 'De titel van het kalenderbestand',
	'srf_paramdesc_icalendardescription' => 'De beschrijving van het kalenderbestand',
	'srf_printername_bibtex' => 'Naar BibTeX exporteren',
	'srf_outline_novalue' => 'Geen waarde',
	'srf_printername_outline' => 'Outline',
	'srf_paramdesc_outlineproperties' => 'De koomagescheiden lijst met eigenschappen die weergegeven moet worden als overzichtskoptekst',
	'srf_printername_sum' => 'Som van getallen',
	'srf_printername_average' => 'Gemiddelde van getallen',
	'srf_printername_max' => 'Hoogste getal',
	'srf_printername_min' => 'Laagste getal',
	'srf_paramdesc_limit' => "Het maximaal aantal op te vragen pagina's",
	'srf_printername_timeline' => 'Tijdlijn',
	'srf_printername_eventline' => 'Gebeurtenissenlijn',
	'srf_paramdesc_timelinebands' => 'Geeft aan welke banden in het resultaat weergegeven moeten worden.',
	'srf_paramdesc_timelineposition' => 'Geeft aan waar de tijdlijn zich aanvankelijk op richt.',
	'srf_paramdesc_timelinestart' => 'De naam van een eigenschap die wordt gebruikt om het eerst punt in de tijd te bepalen',
	'srf_paramdesc_timelineend' => 'De naam van een eigenschap die wordt gebruikt om het tweede punt in de tijd te bepalen',
	'srf_paramdesc_timelinesize' => 'De hoogte van de tijdlijn (standaard is 300 pixels)',
	'srf_paramdesc_views' => 'De weer te geven overzichten',
	'srf_paramdesc_facets' => 'De op iedere pagina weer te geven eigenschappen',
	'srf_paramdesc_lens' => 'De naam van het sjabloon waarmee de paginaeigenschappen weergegeven moeten worden',
	'srf_printername_googlebar' => 'Google staafgrafiek',
	'srf_printername_googlepie' => 'Google taartgrafiek',
	'srf_printername_jqplotbar' => 'jqPlot-staafdiagram',
	'srf_printername_jqplotpie' => 'jqPlot-circeldiagram',
	'srf_paramdesc_chartheight' => 'De hoogte van de grafiek (in pixels)',
	'srf_paramdesc_chartwidth' => 'De breedte van de grafiek (in pixels)',
	'srf_paramdesc_charttitle' => 'Grafiektitel',
	'srf_paramdesc_barcolor' => 'De kleur van de balken',
	'srf_paramdesc_bardirection' => 'De richting van de grafielbalken',
	'srf_paramdesc_barnumbersaxislabel' => 'Het lavel van de Y-as',
	'srf_printername_gallery' => 'Galerij',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Gunnernett
 */
$messages['nn'] = array(
	'srf-desc' => 'Fleire format for Semantic MediaWiki «inline»-spørjingar',
	'srf-name' => 'Semantisk resultatformat',
	'srfc_previousmonth' => 'Førre månad',
	'srfc_nextmonth' => 'Neste månad',
	'srfc_today' => 'I dag',
	'srfc_gotomonth' => 'Gå til månad',
	'srf_printername_calendar' => 'Månadleg kalender',
	'srf_printername_vcard' => 'vCard eksport',
	'srf_printername_icalendar' => 'iCalendar eksport',
	'srf_printername_bibtex' => 'BibTeX eksport',
	'srf_outline_novalue' => 'Ingen verdi',
	'srf_printername_sum' => 'Sum av tal',
	'srf_printername_average' => 'Gjennomsnitt av tal',
	'srf_printername_max' => 'Største tal',
	'srf_printername_min' => 'Minste tal',
	'srf_printername_timeline' => 'Tidsline',
	'srf_printername_eventline' => 'Tidsline for hendingar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'srf-desc' => 'Ytterligere format for Semantic MediaWiki «inline»-spørringer',
	'srf-name' => 'Semantisk resultatformat',
	'srfc_previousmonth' => 'Forrige måned',
	'srfc_nextmonth' => 'Neste måned',
	'srfc_today' => 'I dag',
	'srfc_gotomonth' => 'Gå til måned',
	'srf_printername_calendar' => 'Månedlig kalender',
	'srf_paramdesc_calendarlang' => 'Språkkoden for språket som kalenderen skal vises i',
	'srf_printername_vcard' => 'vCard-eksport',
	'srf_icalendar_link' => 'iKalender',
	'srf_printername_icalendar' => 'iCalendar-eksport',
	'srf_paramdesc_icalendartitle' => 'Tittelen på kalenderfilen',
	'srf_paramdesc_icalendardescription' => 'Beskrivelsen av kalenderfilen',
	'srf_printername_bibtex' => 'BibTeX-eksport',
	'srf_outline_novalue' => 'Ingen verdi',
	'srf_printername_outline' => 'Disposisjon',
	'srf_paramdesc_outlineproperties' => 'Listen over egenskaper som skal vises som disposisjonsoverskrifter, adskilt med komma',
	'srf_printername_sum' => 'Sum av tall',
	'srf_printername_average' => 'Gjennomsnitt av tall',
	'srf_printername_max' => 'Største tall',
	'srf_printername_min' => 'Minste tall',
	'srf_paramdesc_limit' => 'Maks antall sider å etterspørre',
	'srf_printername_timeline' => 'Tidslinje',
	'srf_printername_eventline' => 'Hendelseslinje',
	'srf_paramdesc_timelinebands' => 'Definerer hvilke bånd som vises i resultatet.',
	'srf_paramdesc_timelineposition' => 'Definerer hvor tidslinjen først fokuseres rundt.',
	'srf_paramdesc_timelinestart' => 'Et egenskapsnavn brukt for å definere et første tidspunkt',
	'srf_paramdesc_timelineend' => 'Et egenskapsnavn brukt for å definere et andre tidspunkt',
	'srf_paramdesc_timelinesize' => 'Høyden på tidslinjen (standard er 300px)',
	'srf_paramdesc_views' => 'Visninger som skal fremvises',
	'srf_paramdesc_facets' => 'Egenskapssettet som skal vises for hver side',
	'srf_paramdesc_lens' => 'Navnet på malen som skal vise frem sideegenskapene',
	'srf_printername_googlebar' => 'Google stolpediagram',
	'srf_printername_googlepie' => 'Google kakediagram',
	'srf_printername_jqplotbar' => 'jqPlot stolpediagram',
	'srf_printername_jqplotpie' => 'jqPlot sektordiagram',
	'srf_paramdesc_chartheight' => 'Høyden til diagrammet, i pixler',
	'srf_paramdesc_chartwidth' => 'Bredden til diagrammet, i pixler',
	'srf_paramdesc_charttitle' => 'Tittelen på diagrammet',
	'srf_paramdesc_barcolor' => 'Fargen på stolpene',
	'srf_paramdesc_bardirection' => 'Retningen på stolpediagrammet',
	'srf_paramdesc_barnumbersaxislabel' => 'Etiketten for tallaksen',
	'srf_printername_gallery' => 'Galleri',
	'srf_printername_tagcloud' => 'Tagg-sky',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'srf-desc' => 'Formats adicionals per las requèstas de Semantic MediaWiki',
	'srf-name' => 'Formatatge dels resultats semantics',
	'srfc_previousmonth' => 'Mes precedent',
	'srfc_nextmonth' => 'Mes seguent',
	'srfc_today' => 'Uèi',
	'srfc_gotomonth' => 'Anar cap al mes',
	'srf_printername_calendar' => 'Calendièr mesadièr',
	'srf_vcard_link' => 'vCarta',
	'srf_printername_vcard' => 'expòrt en vCard',
	'srf_icalendar_link' => 'iCalendièr',
	'srf_printername_icalendar' => 'expòrt en iCalendar',
	'srf_printername_bibtex' => 'expòrt en BibTeX',
	'srf_outline_novalue' => 'Pas cap de valor',
	'srf_printername_outline' => 'Esbòs',
	'srf_printername_sum' => 'Soma de nombres',
	'srf_printername_average' => 'Mejana dels nombres',
	'srf_printername_max' => 'Nombre maximal',
	'srf_printername_min' => 'Nombre minimal',
	'srf_printername_timeline' => 'Cronologia',
	'srf_printername_eventline' => 'Cronologia dels eveniments',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'srfc_previousmonth' => 'Letscht Munet',
	'srfc_nextmonth' => 'Neegscht Munet',
	'srfc_today' => 'Heit',
);

/** Polish (Polski)
 * @author Maire
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'srf-desc' => 'Dodatkowe formaty dla zapytań semantycznych MediaWiki z wiersza poleceń',
	'srf-name' => 'Formaty semantycznych wyników',
	'srfc_previousmonth' => 'Poprzedni miesiąc',
	'srfc_nextmonth' => 'Następny miesiąc',
	'srfc_today' => 'Dzisiaj',
	'srfc_gotomonth' => 'Idź do miesiąca',
	'srf_printername_calendar' => 'Kalendarz na miesiąc',
	'srf_paramdesc_calendarlang' => 'Kod języka, w którym jest wyświetlany kalendarz',
	'srf_printername_vcard' => 'eksport vCard',
	'srf_printername_icalendar' => 'eksport iCalendar',
	'srf_paramdesc_icalendartitle' => 'Nazwa pliku kalendarza',
	'srf_paramdesc_icalendardescription' => 'Opis pliku kalendarza',
	'srf_printername_bibtex' => 'eksport BibTeX',
	'srf_outline_novalue' => 'Brak wartości',
	'srf_printername_outline' => 'Szkic',
	'srf_paramdesc_outlineproperties' => 'Spis właściwości, które zostaną wyświetlone jako nagłówki konspektu, rozdzielone przecinkami',
	'srf_printername_sum' => 'Suma liczb',
	'srf_printername_average' => 'Średnia liczb',
	'srf_printername_max' => 'Maksymalna liczba',
	'srf_printername_min' => 'Minimalna liczba',
	'srf_paramdesc_limit' => 'Maksymalna liczba stron dla zapytania',
	'srf_printername_timeline' => 'Oś czasu',
	'srf_printername_eventline' => 'Oś wydarzeń',
	'srf_paramdesc_timelinebands' => 'Określa, które okresy są wyświetlane w wynikach.',
	'srf_paramdesc_timelineposition' => 'Określa, gdzie początkowo zaczyna się oś czasu.',
	'srf_paramdesc_timelinestart' => 'Nazwa własności używana do określenia pierwszego punktu w czasie.',
	'srf_paramdesc_timelineend' => 'Nazwa własności używana do określenia drugiego punktu w czasie.',
	'srf_paramdesc_timelinesize' => 'Wysokość osi czasu (domyślnie 300 pikseli)',
	'srf_paramdesc_views' => 'Widoki do wyświetlenia',
	'srf_paramdesc_facets' => 'Zestaw właściwości do wyświetlenia na każdej stronie',
	'srf_paramdesc_lens' => 'Nazwa szablonu, który zostanie użyty do wyświetlenia właściwości strony',
	'srf_printername_googlebar' => 'wykres słupkowy Google',
	'srf_printername_googlepie' => 'wykres kołowy Google',
	'srf_printername_jqplotbar' => 'wykres słupkowy jqPlot',
	'srf_printername_jqplotpie' => 'wykres kołowy jqPlot',
	'srf_paramdesc_chartheight' => 'Wysokość wykresu w pikselach',
	'srf_paramdesc_chartwidth' => 'Szerokość wykresu w pikselach',
	'srf_paramdesc_charttitle' => 'Tytuł wykresu',
	'srf_paramdesc_barcolor' => 'Kolory słupków',
	'srf_paramdesc_bardirection' => 'Ułożenie słupków',
	'srf_paramdesc_barnumbersaxislabel' => 'Etykieta wartości osi',
	'srf_printername_gallery' => 'Galeria',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'srf-desc' => 'Formà adissionaj për anterogassion an linia ëd Semantic MediaWiki',
	'srf-name' => "Formà dj'Arzultà Semàntich",
	'srfc_previousmonth' => 'Meis prima',
	'srfc_nextmonth' => 'Meis apress',
	'srfc_today' => 'Ancheuj',
	'srfc_gotomonth' => 'Va al meis',
	'srf_printername_calendar' => 'Armanach dël meis',
	'srf_paramdesc_calendarlang' => 'Ël còdes për la lenga ant la qual visualisé ël calendari',
	'srf_printername_vcard' => 'esportassion ëd vCard',
	'srf_printername_icalendar' => "esportassion d'iCalendar",
	'srf_paramdesc_icalendartitle' => "Ël tìtol ëd l'archivi dël calendari",
	'srf_paramdesc_icalendardescription' => "La descrission ëd l'achivi dël calendari",
	'srf_printername_bibtex' => 'esportassion BibTeX',
	'srf_outline_novalue' => 'Pa gnun valor',
	'srf_printername_outline' => 'Fòra linia',
	'srf_paramdesc_outlineproperties' => 'La lista ëd proprietà da visualisé com antestassion, separà da vìrgole',
	'srf_printername_sum' => 'Total dij nùmer',
	'srf_printername_average' => 'Media dij nùmer',
	'srf_printername_max' => 'Nùmer pì gròss',
	'srf_printername_min' => 'Nùmer pì cit',
	'srf_paramdesc_limit' => 'Ël nùmer màssim ëd pàgine da ciamé',
	'srf_printername_timeline' => 'Cronologìa',
	'srf_printername_eventline' => "Cronologìa dj'event",
	'srf_paramdesc_timelinebands' => "A definiss che partìe a son visualisà ant l'arzultà.",
	'srf_paramdesc_timelineposition' => 'A definiss andoa la cronologìa a part inissialment.',
	'srf_paramdesc_timelinestart' => 'Ël nòm ëd na proprietà dovrà për definì un prim pont ëd temp',
	'srf_paramdesc_timelineend' => 'Ël nòm ëd na proprietà dovrà për definì un secont pont ëd temp',
	'srf_paramdesc_timelinesize' => "L'autëssa dla cronologìa (lë stàndard a l'é 300px)",
	'srf_paramdesc_views' => 'Le viste da visualisé',
	'srf_paramdesc_facets' => "L'ansema ëd proprietà da visualisé për minca pàgina",
	'srf_paramdesc_lens' => 'Ël nòm ëd në stamp con ël qual visualisé le proprietà dle pàgine',
	'srf_printername_googlebar' => 'Ël diagrama a bare ëd Google',
	'srf_printername_googlepie' => 'Ël diagrama a torta ëd Google',
	'srf_printername_jqplotbar' => 'gràfich a bare jqPlot',
	'srf_printername_jqplotpie' => 'gràfich a torta jqPlot',
	'srf_paramdesc_chartheight' => "L'autëssa dël diagrama, an pontin",
	'srf_paramdesc_chartwidth' => 'La larghëssa dël diagrama, an pontin',
	'srf_paramdesc_charttitle' => 'Ël tìtol dël gràfich',
	'srf_paramdesc_barcolor' => 'Ël color ëd le bare',
	'srf_paramdesc_bardirection' => 'La diression dël gràfich a bare',
	'srf_paramdesc_barnumbersaxislabel' => "La tichëtta për l'ass dij nùmer",
	'srf_printername_gallery' => 'Galarìa',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'srfc_previousmonth' => 'پخوانۍ مياشت',
	'srfc_nextmonth' => 'راتلونکې مياشت',
	'srfc_today' => 'نن',
	'srfc_gotomonth' => 'مياشت ته ورځه',
	'srf_printername_gallery' => 'نندارتون',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'srf-desc' => "Formatos adicionais para consultas de incorporação dinâmica ''(inline queries)'' do MediaWiki Semântico",
	'srf-name' => 'Formatos dos Resultados Semânticos',
	'srfc_previousmonth' => 'Mês anterior',
	'srfc_nextmonth' => 'Mês seguinte',
	'srfc_today' => 'Hoje',
	'srfc_gotomonth' => 'Ir para mês',
	'srf_printername_calendar' => 'Calendário mensal',
	'srf_paramdesc_calendarlang' => 'O código da língua em que será apresentado o calendário',
	'srf_printername_vcard' => 'exportação vCard',
	'srf_icalendar_link' => 'iCalendário',
	'srf_printername_icalendar' => 'exportação iCalendar',
	'srf_paramdesc_icalendartitle' => 'O título do ficheiro do calendário',
	'srf_paramdesc_icalendardescription' => 'A descrição do ficheiro do calendário',
	'srf_printername_bibtex' => 'exportação BibTeX',
	'srf_outline_novalue' => 'Nenhum valor',
	'srf_printername_outline' => 'Lista estruturada',
	'srf_paramdesc_outlineproperties' => 'A lista das propriedades apresentadas como cabeçalhos das listas estruturadas, separadas por vírgulas',
	'srf_printername_sum' => 'Soma dos números',
	'srf_printername_average' => 'Média dos números',
	'srf_printername_max' => 'Número máximo',
	'srf_printername_min' => 'Número mínimo',
	'srf_paramdesc_limit' => 'O número máximo de páginas a consultar',
	'srf_printername_timeline' => 'Cronograma',
	'srf_printername_eventline' => 'Cronograma de eventos',
	'srf_paramdesc_timelinebands' => 'Define que bandas são apresentadas no resultado.',
	'srf_paramdesc_timelineposition' => 'Define onde é que o cronograma inicialmente está focado.',
	'srf_paramdesc_timelinestart' => 'Um nome de propriedade, usado para definir um primeiro ponto no tempo',
	'srf_paramdesc_timelineend' => 'Um nome de propriedade, usado para definir um segundo ponto no tempo',
	'srf_paramdesc_timelinesize' => 'A altura do cronograma (por omissão, 300 px)',
	'srf_paramdesc_views' => 'As vistas que serão apresentadas',
	'srf_paramdesc_facets' => 'O conjunto de propriedades que serão apresentadas para cada página',
	'srf_paramdesc_lens' => 'O nome de uma predefinição usada para apresentar as propriedades das páginas',
	'srf_printername_googlebar' => 'Gráfico de barras Google',
	'srf_printername_googlepie' => 'Gráfico circular Google',
	'srf_printername_jqplotbar' => 'Gráfico de barras jqPlot',
	'srf_printername_jqplotpie' => 'Gráfico circular jqPlot',
	'srf_paramdesc_chartheight' => 'A altura do gráfico, em pixels',
	'srf_paramdesc_chartwidth' => 'A largura do gráfico, em pixels',
	'srf_paramdesc_charttitle' => 'O título do gráfico',
	'srf_paramdesc_barcolor' => 'A cor das barras',
	'srf_paramdesc_bardirection' => 'A orientação do gráfico de barras',
	'srf_paramdesc_barnumbersaxislabel' => 'A legenda para o eixo dos números',
	'srf_printername_gallery' => 'Galeria',
	'srf_printername_tagcloud' => 'Nuvem de tags',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author GKnedo
 * @author Giro720
 */
$messages['pt-br'] = array(
	'srf-desc' => 'Formatos adicionais para consultas embutidas do Semantic MediaWiki',
	'srf-name' => 'Formatos de Resultados Semânticos',
	'srfc_previousmonth' => 'Mês anterior',
	'srfc_nextmonth' => 'Mês seguinte',
	'srfc_today' => 'Hoje',
	'srfc_gotomonth' => 'Ir para mês',
	'srf_printername_calendar' => 'Calendário mensal',
	'srf_paramdesc_calendarlang' => 'O código da língua em que será apresentado o calendário',
	'srf_printername_vcard' => 'Exportar vCard',
	'srf_printername_icalendar' => 'Exportar iCalendar',
	'srf_paramdesc_icalendartitle' => 'O título do arquivo do calendário',
	'srf_paramdesc_icalendardescription' => 'A descrição do arquivo do calendário',
	'srf_printername_bibtex' => 'Exportar BibTeX',
	'srf_outline_novalue' => 'Nenhum valor',
	'srf_printername_outline' => 'Outline',
	'srf_paramdesc_outlineproperties' => 'A lista das propriedades apresentadas como cabeçalhos das listas estruturadas, separadas por vírgulas',
	'srf_printername_sum' => 'Soma dos Números',
	'srf_printername_average' => 'Média dos números',
	'srf_printername_max' => 'Número máximo',
	'srf_printername_min' => 'Número mínimo',
	'srf_paramdesc_limit' => 'O número máximo de páginas a consultar',
	'srf_printername_timeline' => 'Linha do Tempo',
	'srf_printername_eventline' => 'Linha de Eventos',
	'srf_paramdesc_timelinebands' => 'Define quais grupos são apresentadas nos resultados.',
	'srf_paramdesc_timelineposition' => 'Define onde é que o cronograma inicialmente está focado.',
	'srf_paramdesc_timelinestart' => 'Um nome de propriedade, usado para definir um primeiro ponto no tempo.',
	'srf_paramdesc_timelineend' => 'Um nome de propriedade, usado para definir um segundo ponto no tempo',
	'srf_paramdesc_timelinesize' => 'A altura do cronograma (por padrão, 300 px)',
	'srf_paramdesc_views' => 'As vistas que serão apresentadas',
	'srf_paramdesc_facets' => 'O conjunto de propriedades que serão apresentadas para cada página',
	'srf_paramdesc_lens' => 'O nome de uma predefinição usada para apresentar as propriedades das páginas',
	'srf_printername_googlebar' => 'Gráfico de barras Google',
	'srf_printername_googlepie' => 'Gráfico de pizza Google',
	'srf_printername_jqplotbar' => 'Gráfico de barras jqPlot',
	'srf_printername_jqplotpie' => 'Gráfico circular jqPlot',
	'srf_paramdesc_chartheight' => 'A altura do gráfico, em pixels',
	'srf_paramdesc_chartwidth' => 'A largura do gráfico, em pixels',
	'srf_paramdesc_charttitle' => 'O título do gráfico',
	'srf_paramdesc_barcolor' => 'A cor das barras',
	'srf_paramdesc_bardirection' => 'A orientação do gráfico de barras',
	'srf_paramdesc_barnumbersaxislabel' => 'A legenda para o eixo dos números',
	'srf_printername_gallery' => 'Galeria',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'srfc_previousmonth' => 'Luna anterioară',
	'srfc_nextmonth' => 'Luna următoare',
	'srfc_today' => 'Astăzi',
	'srf_printername_calendar' => 'Calendar lunar',
	'srf_printername_bibtex' => 'Export BibTeX',
	'srf_outline_novalue' => 'Nici o valoare',
	'srf_printername_sum' => 'Suma numerelor',
	'srf_printername_average' => 'Media numerelor',
	'srf_printername_max' => 'Numărul maxim',
	'srf_printername_min' => 'Numărul minim',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'srfc_previousmonth' => 'Mese precedende',
	'srfc_nextmonth' => 'Mese successive',
	'srfc_today' => 'Osce',
	'srfc_gotomonth' => "Va a 'u mese",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'srf-desc' => 'Дополнительные форматы для запросов Semantic MediaWiki',
	'srf-name' => 'Форматы семантических результатов',
	'srfc_previousmonth' => 'Предыдущий месяц',
	'srfc_nextmonth' => 'Следующий месяц',
	'srfc_today' => 'Сегодня',
	'srfc_gotomonth' => 'Перейти к месяцу',
	'srf_printername_calendar' => 'Ежемесячный календарь',
	'srf_paramdesc_calendarlang' => 'Код языка, на котором отображать календарь',
	'srf_printername_vcard' => 'Экспорт vCard',
	'srf_icalendar_link' => 'iКалендарь',
	'srf_printername_icalendar' => 'Экспорт iCalendar',
	'srf_paramdesc_icalendartitle' => 'Название файла календаря',
	'srf_paramdesc_icalendardescription' => 'Описание файла календаря',
	'srf_printername_bibtex' => 'Экспорт BibTeX',
	'srf_outline_novalue' => 'Нет значений',
	'srf_printername_outline' => 'Наброски',
	'srf_paramdesc_outlineproperties' => 'Список свойств, отображающихся в виде заголовков, разделяется запятыми',
	'srf_printername_sum' => 'Сумма чисел',
	'srf_printername_average' => 'Среднее число',
	'srf_printername_max' => 'Максимальное число',
	'srf_printername_min' => 'Минимальное число',
	'srf_paramdesc_limit' => 'Максимальное количество страниц для выборки',
	'srf_printername_timeline' => 'Хронология',
	'srf_printername_eventline' => 'Список событий',
	'srf_paramdesc_timelinebands' => 'Определяет, какие полосы будут отображены.',
	'srf_paramdesc_timelineposition' => 'Определяет какое место временной шкалы будет отображаться первоначально',
	'srf_paramdesc_timelinestart' => 'Имя свойства, используемое для определения первой временной точки',
	'srf_paramdesc_timelineend' => 'Имя свойства, используемое для определения второй временной точки',
	'srf_paramdesc_timelinesize' => 'Высота временной шкалы (по умолчанию 300 пикс)',
	'srf_paramdesc_views' => 'Виды для отображения',
	'srf_paramdesc_facets' => 'Набор свойств, отображаемых на каждой странице',
	'srf_paramdesc_lens' => 'Название шаблона для отображения свойств страницы',
	'srf_printername_googlebar' => 'Столбчатая диаграмма Google',
	'srf_printername_googlepie' => 'Круговая диаграмма Google',
	'srf_printername_jqplotbar' => 'Столбчатая диаграмма jqPlot',
	'srf_printername_jqplotpie' => 'Круговая диаграмма jqPlot',
	'srf_paramdesc_chartheight' => 'Высота диаграммы в пикселях',
	'srf_paramdesc_chartwidth' => 'Ширина диаграммы в пикселях',
	'srf_paramdesc_charttitle' => 'Название диаграммы',
	'srf_paramdesc_barcolor' => 'Цвет столбцов',
	'srf_paramdesc_bardirection' => 'Направление столбцов',
	'srf_paramdesc_barnumbersaxislabel' => 'Надпись для числовых осей',
	'srf_printername_gallery' => 'Галерея',
	'srf_printername_tagcloud' => 'Облако меток',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'srfc_previousmonth' => 'Минулый місяць',
	'srfc_nextmonth' => 'Далшый місяць',
	'srfc_today' => 'Днесь',
	'srf_printername_gallery' => 'Ґалерія',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'srf-desc' => 'Ďalšie formáty inline požiadaviek Semantic MediaWiki',
	'srf-name' => 'Formáty sémantických výsledkov',
	'srfc_previousmonth' => 'Predošlý mesiac',
	'srfc_nextmonth' => 'Ďalší mesiac',
	'srfc_today' => 'Dnes',
	'srfc_gotomonth' => 'Prejsť na mesiac',
	'srf_printername_calendar' => 'Mesačný kalendár',
	'srf_printername_vcard' => 'export vCard',
	'srf_printername_icalendar' => 'export iCalendar',
	'srf_printername_bibtex' => 'export BibTeX',
	'srf_outline_novalue' => 'Žiadna hodnota',
	'srf_printername_outline' => 'Náčrt',
	'srf_printername_sum' => 'Suma čísiel',
	'srf_printername_average' => 'Priemer čísiel',
	'srf_printername_max' => 'Maximálne číslo',
	'srf_printername_min' => 'Minimálne číslo',
	'srf_printername_timeline' => 'Časová os',
	'srf_printername_eventline' => 'Os udalostí',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'srfc_previousmonth' => 'Претходни месец',
	'srfc_nextmonth' => 'Следећи месец',
	'srfc_today' => 'Данас',
	'srfc_gotomonth' => 'Пређи на месец',
	'srf_printername_calendar' => 'Месечни календар',
	'srf_outline_novalue' => 'Нема вредности',
	'srf_printername_sum' => 'Сума бројева',
	'srf_printername_average' => 'Средња вредност бројева',
	'srf_printername_max' => 'Највећи број',
	'srf_printername_min' => 'Најмањи број',
	'srf_printername_gallery' => 'Галерија',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'srfc_previousmonth' => 'Prethodni mesec',
	'srfc_nextmonth' => 'Sledeći mesec',
	'srfc_today' => 'Danas',
	'srfc_gotomonth' => 'Pređi na mesec',
	'srf_printername_calendar' => 'Mesečni kalendar',
	'srf_outline_novalue' => 'Nema vrednosti',
	'srf_printername_sum' => 'Suma brojeva',
	'srf_printername_average' => 'Srednja vrednost brojeva',
	'srf_printername_max' => 'Najveći broj',
	'srf_printername_min' => 'Najmanji broj',
	'srf_printername_gallery' => 'Galerija',
);

/** Swedish (Svenska)
 * @author Dafer45
 * @author M.M.S.
 * @author Per
 */
$messages['sv'] = array(
	'srfc_previousmonth' => 'Föregående månad',
	'srfc_nextmonth' => 'Nästa månad',
	'srfc_today' => 'Idag',
	'srfc_gotomonth' => 'Gå till månad',
	'srf_printername_calendar' => 'Månadskalender',
	'srf_paramdesc_calendarlang' => 'Språkkoden för det språk som kalendern skall visas med',
	'srf_printername_vcard' => 'vCard-export',
	'srf_icalendar_link' => 'iKalender',
	'srf_printername_icalendar' => 'iCalendar-export',
	'srf_paramdesc_icalendartitle' => 'Titeln på kalenderfilen',
	'srf_paramdesc_icalendardescription' => 'Beskrivningen av kalenderfilen',
	'srf_printername_bibtex' => 'BibTeX-export',
	'srf_outline_novalue' => 'Inget värde',
	'srf_printername_sum' => 'Summa av tal',
	'srf_printername_average' => 'Genomsnitt av tal',
	'srf_printername_max' => 'Största nummer',
	'srf_printername_min' => 'Minsta nummer',
	'srf_printername_timeline' => 'Tidslinje',
	'srf_printername_eventline' => 'Händelselinje',
	'srf_printername_googlebar' => 'Google stapeldiagram',
	'srf_printername_googlepie' => 'Google tårtdiagram',
	'srf_paramdesc_chartheight' => 'Höjden på diagrammet i pixlar',
	'srf_paramdesc_chartwidth' => 'Bredden på diagrammet i pixlar',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'srfc_previousmonth' => 'క్రితం నెల',
	'srfc_nextmonth' => 'తర్వాతి నెల',
	'srfc_today' => 'ఈరోజు',
	'srfc_gotomonth' => 'నెలకి వెళ్ళండి',
	'srf_outline_novalue' => 'విలువ లేదు',
	'srf_printername_sum' => 'సంఖ్యల మొత్తం',
	'srf_printername_average' => 'సంఖ్యల సగటు',
	'srf_printername_max' => 'గరిష్ఠ సంఖ్య',
	'srf_printername_min' => 'కనిష్ఠ సంఖ్య',
	'srf_printername_timeline' => 'కాలరేఖ',
	'srf_paramdesc_chartheight' => 'చార్టు యొక్క ఎత్తు, పిక్సెళ్ళలో',
	'srf_paramdesc_chartwidth' => 'చార్టు యొక్క వెడల్పు, పిక్సెళ్ళలో',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'srfc_previousmonth' => 'Моҳи қаблӣ',
	'srfc_nextmonth' => 'Моҳи баъдӣ',
	'srfc_today' => 'Имрӯз',
	'srfc_gotomonth' => 'Рафтан ба моҳ',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'srfc_previousmonth' => 'Mohi qablī',
	'srfc_nextmonth' => "Mohi ba'dī",
	'srfc_today' => 'Imrūz',
	'srfc_gotomonth' => 'Raftan ba moh',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'srf-desc' => 'Dagdag na mga anyo para sa nasa loob ng guhit na mga pagtatanong na pang-Semantikong MediaWiki',
	'srf-name' => 'Mga Anyo ng Resultang Semantiko',
	'srfc_previousmonth' => 'Nakaraang buwan',
	'srfc_nextmonth' => 'Susunod na buwan',
	'srfc_today' => 'Ngayong araw na ito',
	'srfc_gotomonth' => 'Pumunta sa buwan',
	'srf_printername_calendar' => 'Buwanang kalendaryo',
	'srf_paramdesc_calendarlang' => 'Ang kodigo para sa wika na pagpapakitaan ng kalendaryo',
	'srf_printername_vcard' => 'Luwas ng vCard',
	'srf_printername_icalendar' => 'Luwas ng iCalendar',
	'srf_paramdesc_icalendartitle' => 'Ang pamagat ng talaksan ng kalendaryo',
	'srf_paramdesc_icalendardescription' => 'Ang paglalarawan ng talaksan ng kalendaryo',
	'srf_printername_bibtex' => 'Luwas ng BibTeX',
	'srf_outline_novalue' => 'Walang halaga',
	'srf_printername_outline' => 'Banghay',
	'srf_paramdesc_outlineproperties' => 'Ang talaan ng mga pag-aaring ipapakita bilang mga paulong banghay, na pinaghihiwalay ng mga kuwit',
	'srf_printername_sum' => 'kabuuan ng mga bilang',
	'srf_printername_average' => 'Pinatakang halaga ng mga bilang',
	'srf_printername_max' => 'Pinakamataas na bilang',
	'srf_printername_min' => 'Pinakamababang bilang',
	'srf_paramdesc_limit' => 'Ang pinakamaraming bilang ng mga pahinang ipagtatanong',
	'srf_printername_timeline' => 'Guhit ng panahon',
	'srf_printername_eventline' => 'Guhit ng kaganapan',
	'srf_paramdesc_timelinebands' => 'Tumutukoy kung aling mga sintas ang ipapakita sa loob ng resulta.',
	'srf_paramdesc_timelineposition' => 'Tumutukoy kung saan unang tutuon ang guhit ng panahon.',
	'srf_paramdesc_timelinestart' => 'Isang pangalan ng pag-aaring ginamit upang tukuyin ang isang unang punto ng oras',
	'srf_paramdesc_timelineend' => 'Isang pangalan ng pag-aaring ginamit upang tukuyin ang isang pangalawang punto ng oras',
	'srf_paramdesc_timelinesize' => 'Ang taas ng guhit ng panahon (likas na nakatakda ay 300px)',
	'srf_paramdesc_views' => 'Mga tanawing ipapakita',
	'srf_paramdesc_facets' => 'Ang pangkat ng mga pag-aaring ipapakita para sa bawat pahina',
	'srf_paramdesc_lens' => 'Ang pangalan ng isang suleras na pagpapakitaan ng mga pag-aari ng pahina',
	'srf_printername_googlebar' => 'Baretang tsart ng Google',
	'srf_printername_googlepie' => 'Kakaning-tsart ng Google',
	'srf_printername_jqplotbar' => 'baretang talangguhit ng jqPlot',
	'srf_printername_jqplotpie' => 'kakaning-talangguhit ng jgPlot',
	'srf_paramdesc_chartheight' => 'Ang taas ng tsart, nasa mga piksel',
	'srf_paramdesc_chartwidth' => 'Ang lapad ng tsart, nasa mga piksel',
	'srf_paramdesc_charttitle' => 'Ang pamagat ng talangguhit',
	'srf_paramdesc_barcolor' => 'Ang kulay ng mga bareta',
	'srf_paramdesc_bardirection' => 'Ang kapupuntahan ng baretang talangguhit',
	'srf_paramdesc_barnumbersaxislabel' => 'Ang tatak para sa painugan ng mga bilang',
	'srf_printername_gallery' => 'Galerya',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'srf-name' => 'Anlamsal Sonuç Bilimleri',
	'srfc_previousmonth' => 'Önceki ay',
	'srfc_nextmonth' => 'Sonraki ay',
	'srfc_today' => 'Bugün',
	'srfc_gotomonth' => 'Aya git',
	'srf_printername_calendar' => 'Aylık takvim',
	'srf_printername_vcard' => 'vCard dışa aktarımı',
	'srf_printername_icalendar' => 'iCalendar dışa aktarımı',
	'srf_paramdesc_icalendartitle' => 'Takvim dosyasının başlığı',
	'srf_paramdesc_icalendardescription' => 'Takvim dosyasının tanımı',
	'srf_outline_novalue' => 'Değer yok',
	'srf_printername_sum' => 'Sayıların toplamı',
	'srf_printername_average' => 'Sayılan ortalaması',
	'srf_printername_max' => 'Azami sayı',
	'srf_printername_min' => 'Asgari sayı',
	'srf_paramdesc_limit' => 'Sorgulanacak azami sayfa sayısı',
	'srf_printername_timeline' => 'Zaman çizgisi',
	'srf_paramdesc_views' => 'Görüntülenecek görünümler',
	'srf_printername_googlebar' => 'Google çubuk çizelgesi',
	'srf_printername_googlepie' => 'Google dilim çizelgesi',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'srfc_previousmonth' => 'Mese preçedente',
	'srfc_nextmonth' => 'Mese sucessivo',
	'srfc_today' => 'Ancuó',
	'srfc_gotomonth' => 'Và al mese',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'srfc_previousmonth' => 'Edeline ku',
	'srfc_nextmonth' => "Jäl'ghine ku",
	'srfc_today' => 'Tämbei',
	'srfc_gotomonth' => 'Mända kunnoks',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'srf-desc' => 'Các định dạng bổ sung cho các câu truy vấn trong dòng lệnh của MediaWiki Ngữ Nghĩa',
	'srf-name' => 'Định dạng Kết quả Ngữ nghĩa',
	'srfc_previousmonth' => 'Tháng trước',
	'srfc_nextmonth' => 'Tháng sau',
	'srfc_today' => 'Hôm nay',
	'srfc_gotomonth' => 'Đến tháng',
	'srf_printername_calendar' => 'Lịch tháng',
	'srf_printername_vcard' => 'Xuất vCard',
	'srf_printername_icalendar' => 'Xuất iCalendar',
	'srf_printername_bibtex' => 'Xuất BibTeX',
	'srf_outline_novalue' => 'Vô giá trị',
	'srf_printername_outline' => 'Khái quát',
	'srf_printername_sum' => 'Tổng số',
	'srf_printername_average' => 'Trung bình số',
	'srf_printername_max' => 'Số lớn nhất',
	'srf_printername_min' => 'Số nhỏ nhất',
	'srf_printername_timeline' => 'Thời gian biểu',
	'srf_printername_eventline' => 'Sự kiện biểu',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'srfc_previousmonth' => 'Mul büik',
	'srfc_nextmonth' => 'Mul sököl',
	'srfc_today' => 'Adelo',
	'srfc_gotomonth' => 'Lü mul',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'srfc_previousmonth' => 'פֿאריגער חודש',
	'srfc_nextmonth' => 'נעקסטער חודש',
	'srfc_today' => 'הײַנט',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'srfc_previousmonth' => '上月',
	'srfc_nextmonth' => '下月',
	'srfc_today' => '今天',
	'srfc_gotomonth' => '跳至月份',
	'srf_printername_max' => '最大数目',
	'srf_printername_min' => '最小数目',
	'srf_printername_gallery' => '图库',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'srfc_previousmonth' => '上月',
	'srfc_nextmonth' => '下月',
	'srfc_today' => '今天',
	'srfc_gotomonth' => '跳至月份',
	'srf_printername_max' => '最大數目',
	'srf_printername_min' => '最小數目',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'srfc_previousmonth' => '前一月',
	'srfc_nextmonth' => '次一月',
	'srfc_today' => '今日',
	'srfc_gotomonth' => '前往',
);

