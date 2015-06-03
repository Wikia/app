<?php
/**
 * Internationalization file for the Semantic Drilldown extension
 *
 * @ingroup Language
 * @ingroup I18n
 * @ingroup SDLanguage
*/

$messages = array();

/** English
 * @author Yaron Koren
 */
$messages['en'] = array(
	// user messages
	'semanticdrilldown-desc'		=> 'A drilldown interface for navigating through semantic data',
	'specialpages-group-sd_group'           => 'Semantic Drilldown',
	'browsedata'                            => 'Browse data',
	'sd_browsedata_choosecategory'          => 'Choose a category',
	'sd_browsedata_viewcategory'            => 'view category',
	'sd_browsedata_docu'                    => 'Click on one or more items below to narrow your results.',
	'sd_browsedata_subcategory'             => 'Subcategory',
	'sd_browsedata_other'                   => 'Other',
	'sd_browsedata_none'                    => 'None',
	'sd_browsedata_filterbyvalue'           => 'Filter by this value',
	'sd_browsedata_filterbysubcategory'     => 'Filter by this subcategory',
	'sd_browsedata_otherfilter'             => 'Show pages with another value for this filter',
	'sd_browsedata_nonefilter'              => 'Show pages with no value for this filter',
	'sd_browsedata_or'			=> 'or',
	'sd_browsedata_removefilter'            => 'Remove this filter',
	'sd_browsedata_removesubcategoryfilter' => 'Remove this subcategory filter',
	'sd_browsedata_resetfilters'            => 'Reset filters',
	'sd_browsedata_addanothervalue'		=> 'Click arrow to add another value',
	'sd_browsedata_daterangestart'		=> 'Start:',
	'sd_browsedata_daterangeend'		=> 'End:',
	'sd_browsedata_novalues'		=> 'There are no values for this filter',
	'filters'                               => 'Filters',
	'sd_filters_docu'                       => 'The following filters exist in {{SITENAME}}:',
	'createfilter'                          => 'Create a filter',
	'sd_createfilter_name'                  => 'Name:',
	'sd_createfilter_property'              => 'Property that this filter covers:',
	'sd_createfilter_usepropertyvalues'     => 'Use all values of this property for the filter',
	'sd_createfilter_usecategoryvalues'     => 'Get values for filter from this category:',
	'sd_createfilter_usedatevalues'         => 'Use date ranges for this filter with this time period:',
	'sd_createfilter_entervalues'           => 'Enter values for filter manually (values should be separated by commas - if a value contains a comma, replace it with "\,"):',
	'sd_createfilter_inputtype'		=> 'Input type for this filter:',
	'sd_createfilter_listofvalues'		=> 'list of values (default)',
	'sd_createfilter_requirefilter'         => 'Require another filter to be selected before this one is displayed:',
	'sd_createfilter_label'                 => 'Label for this filter (optional):',
	'sd_blank_error'                        => 'cannot be blank',
	'sd-pageschemas-filter'			=> 'Filter',
	'sd-pageschemas-values'			=> 'Values',

	// content messages
	'sd_filter_coversproperty'         => 'This filter covers the property $1.',
	'sd_filter_getsvaluesfromcategory' => 'It gets its values from the category $1.',
	'sd_filter_usestimeperiod'         => 'It uses $1 as its time period.',
	'sd_filter_year'                   => 'Year',
	'sd_filter_month'                  => 'Month',
	'sd_filter_hasvalues'              => 'It has the values $1.',
	'sd_filter_hasinputtype'           => 'It has the input type $1.',
	'sd_filter_combobox'               => 'combo box',
	'sd_filter_freetext'               => 'text',
	'sd_filter_daterange'              => 'date range',
	'sd_filter_requiresfilter'         => 'It requires the presence of the filter $1.',
	'sd_filter_haslabel'               => 'It has the label $1.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Purodha
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'semanticdrilldown-desc' => '{{desc}}',
	'sd_browsedata_other' => '{{Identical|Other}}',
	'sd_browsedata_none' => '{{Identical|None}}',
	'sd_browsedata_or' => '{{Identical|Or}}',
	'filters' => '{{Identical|Filter}}',
	'sd_createfilter_name' => 'The name that will be given to a filter',
	'sd_blank_error' => '{{Identical|Cannot be blank}}',
	'sd-pageschemas-filter' => 'A single filter',
	'sd-pageschemas-values' => 'The set of values for a filter',
	'sd_filter_year' => '{{Identical|Year}}',
	'sd_filter_month' => '{{Identical|Month}}',
	'sd_filter_combobox' => 'A specific type of interface input',
	'sd_filter_freetext' => 'A specific type of interface input',
	'sd_filter_daterange' => 'A specific type of interface input',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'browsedata' => 'Bekyk gegewens',
	'sd_browsedata_choosecategory' => "Kies 'n kategorie",
	'sd_browsedata_viewcategory' => 'wys kategorie',
	'sd_browsedata_subcategory' => 'Subkategorie',
	'sd_browsedata_other' => 'Ander',
	'sd_browsedata_none' => 'Geen',
	'sd_browsedata_filterbyvalue' => 'Filter op hierdie waarde',
	'sd_browsedata_filterbysubcategory' => 'Filter op hierdie subkategorie',
	'sd_browsedata_or' => 'of',
	'sd_browsedata_removefilter' => 'Verwyder hierdie filter',
	'sd_browsedata_removesubcategoryfilter' => 'Verwyder hierdie subkategorie-filter',
	'sd_browsedata_resetfilters' => 'Herstel filters',
	'sd_browsedata_addanothervalue' => "Kliek die pyltjie om nog 'n waarde by te voeg",
	'sd_browsedata_daterangestart' => 'Begin:',
	'sd_browsedata_daterangeend' => 'Einde:',
	'sd_browsedata_novalues' => 'Daar is geen waardes vir hierdie filter nie',
	'filters' => 'Filters',
	'sd_filters_docu' => 'Die volgende filters bestaan in {{SITENAME}}:',
	'createfilter' => "Skep 'n filter",
	'sd_createfilter_name' => 'Naam:',
	'sd_createfilter_listofvalues' => 'lys van waardes (standaard)',
	'sd_createfilter_label' => 'Etiket vir hierdie filter (opsioneel):',
	'sd_blank_error' => 'mag nie leeg wees nie',
	'sd_filter_year' => 'Jaar',
	'sd_filter_month' => 'Maand',
	'sd_filter_freetext' => 'teks',
	'sd_filter_daterange' => 'datumreeks',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'sd_createfilter_name' => 'ስም:',
	'sd_filter_month' => 'ወር',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'sd_browsedata_other' => 'Un atro',
	'sd_browsedata_none' => 'Garra',
	'filters' => 'Filtros',
	'sd_createfilter_name' => 'Nombre:',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'semanticdrilldown-desc' => 'واجهة نزول للإبحار خلال بيانات سيمانتيك',
	'specialpages-group-sd_group' => 'سيمانتيك دريل داون',
	'browsedata' => 'تصفح البيانات',
	'sd_browsedata_choosecategory' => 'اختر تصنيفا',
	'sd_browsedata_viewcategory' => 'عرض التصنيف',
	'sd_browsedata_docu' => 'اضغط على واحد أو أكثر من المدخلات بالأسفل لتضييق نتائجك.',
	'sd_browsedata_subcategory' => 'تصنيف فرعي',
	'sd_browsedata_other' => 'آخر',
	'sd_browsedata_none' => 'لا شيء',
	'sd_browsedata_filterbyvalue' => 'ترشيح بناءً هذه القيمة',
	'sd_browsedata_filterbysubcategory' => 'ترشيح بناءً على هذا التصنيف الفرعي',
	'sd_browsedata_otherfilter' => 'اعرض الصفحات بقيمة أخرى لهذا الفلتر',
	'sd_browsedata_nonefilter' => 'اعرض الصفحات التي هي بدون قيمة لهذا الفلتر',
	'sd_browsedata_or' => 'أو',
	'sd_browsedata_removefilter' => 'أزل هذا المُرشِّح',
	'sd_browsedata_removesubcategoryfilter' => 'أزل مُرشّح التصنيف الفرعي هذا',
	'sd_browsedata_resetfilters' => 'أعد ضبط المُرشِّحات',
	'sd_browsedata_addanothervalue' => 'اضغط على السهم لإضافة قيمة أخرى',
	'sd_browsedata_daterangestart' => 'البداية:',
	'sd_browsedata_daterangeend' => 'النهاية:',
	'sd_browsedata_novalues' => 'لا توجد قيم لهذا المرشح',
	'filters' => 'مُرشّحات',
	'sd_filters_docu' => 'المرشحات التالية موجودة في {{SITENAME}}:',
	'createfilter' => 'أنشئ مُرشِّحًا',
	'sd_createfilter_name' => 'الاسم:',
	'sd_createfilter_property' => 'الخاصية التي يغطيها هذا الفلتر:',
	'sd_createfilter_usepropertyvalues' => 'استخدم كل قيم هذه الخاصية للفلتر',
	'sd_createfilter_usecategoryvalues' => 'احصل على القيم للفلتر من هذا التصنيف:',
	'sd_createfilter_usedatevalues' => 'استخدم نطاقات زمنية لهذا الفلتر بهذه الفترة الزمنية:',
	'sd_createfilter_entervalues' => 'أدخل القيم للفلتر يدويا (القيم ينبغي أن يتم فصلها بواسطة فاصلات - لو أن قيمة ما تحتوي على فاصلة، استبدلها ب "\\,"):',
	'sd_createfilter_inputtype' => ': نوع المدخل للفلتر',
	'sd_createfilter_listofvalues' => 'قائمة القيم (أفتراضي)',
	'sd_createfilter_requirefilter' => 'يتطلب اختيار مُرشّح آخر قبل أن يتم عرض هذا:',
	'sd_createfilter_label' => 'علامة لهذا الفلتر (اختياري):',
	'sd_blank_error' => 'لا يمكن أن يكون فارغا',
	'sd_filter_coversproperty' => 'هذا الفلتر يغطي الخاصية $1.',
	'sd_filter_getsvaluesfromcategory' => 'يحصل على قيمه من التصنيف $1.',
	'sd_filter_usestimeperiod' => 'يستخدم $1 كفترته الزمنية.',
	'sd_filter_year' => 'عام',
	'sd_filter_month' => 'شهر',
	'sd_filter_hasvalues' => 'يمتلك القيم $1.',
	'sd_filter_hasinputtype' => 'لها نوع المدخل $1',
	'sd_filter_combobox' => 'صندوق كومبو',
	'sd_filter_freetext' => 'نص',
	'sd_filter_daterange' => 'معدل البيانات',
	'sd_filter_requiresfilter' => 'يتطلب وجود الفلتر $1.',
	'sd_filter_haslabel' => 'يمتلك العلامة $1.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'sd_browsedata_choosecategory' => 'ܓܒܝ ܣܕܪܐ',
	'sd_browsedata_viewcategory' => 'ܚܘܝ ܣܕܪܐ',
	'sd_browsedata_subcategory' => 'ܣܕܪ̈ܐ ܦܪ̈ܥܝܐ',
	'sd_browsedata_other' => 'ܐܚܪܢܐ',
	'sd_browsedata_none' => 'ܠܐ ܡܕܡ',
	'sd_browsedata_or' => 'ܐܘ',
	'sd_browsedata_daterangestart' => 'ܫܘܪܝܐ:',
	'sd_browsedata_daterangeend' => 'ܫܘܠܡܐ:',
	'createfilter' => 'ܒܪܝ ܡܨܦܝܢܝܬܐ',
	'sd_createfilter_name' => 'ܫܡܐ:',
	'sd_blank_error' => 'ܠܐ ܡܨܐ ܕܢܗܘܐ ܣܦܝܩܐ',
	'sd_filter_year' => 'ܫܢܬܐ',
	'sd_filter_month' => 'ܝܪܚܐ',
	'sd_filter_freetext' => 'ܟܬܒܬܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ouda
 * @author Ramsis II
 */
$messages['arz'] = array(
	'semanticdrilldown-desc' => 'واجهة نزول للإبحار خلال بيانات سيمانتيك',
	'specialpages-group-sd_group' => 'سيمانتيك دريل داون',
	'browsedata' => 'تصفح البيانات',
	'sd_browsedata_choosecategory' => 'اختر تصنيفا',
	'sd_browsedata_viewcategory' => 'عرض التصنيف',
	'sd_browsedata_docu' => 'اضغط على واحد أو أكثر من المدخلات بالأسفل لتضييق نتائجك.',
	'sd_browsedata_subcategory' => 'تصنيف فرعي',
	'sd_browsedata_other' => 'آخر',
	'sd_browsedata_none' => 'لا شيء',
	'sd_browsedata_filterbyvalue' => 'فلترة بواسطة هذه القيمة',
	'sd_browsedata_filterbysubcategory' => 'فلترة بواسطة هذا التصنيف الفرعي',
	'sd_browsedata_otherfilter' => 'اعرض الصفحات بقيمة أخرى لهذا الفلتر',
	'sd_browsedata_nonefilter' => 'اعرض الصفحات التى هى بدون قيمة لهذا الفلتر',
	'sd_browsedata_or' => 'أو',
	'sd_browsedata_removefilter' => 'أزل هذا الفلتر',
	'sd_browsedata_removesubcategoryfilter' => 'أزل فلتر التصنيف الفرعى هذا',
	'sd_browsedata_resetfilters' => 'أعد ضبط الفلاتر',
	'sd_browsedata_addanothervalue' => 'اضغط على السهم لإضافة قيمة أخرى',
	'sd_browsedata_daterangestart' => ':البداية',
	'sd_browsedata_daterangeend' => ':النهاية',
	'filters' => 'فلاتر',
	'sd_filters_docu' => 'الفلاتر التالية موجودة فى {{SITENAME}}:',
	'createfilter' => 'إنشاء فلتر',
	'sd_createfilter_name' => 'الاسم:',
	'sd_createfilter_property' => 'الخاصية التى يغطيها هذا الفلتر:',
	'sd_createfilter_usepropertyvalues' => 'استخدم كل قيم هذه الخاصية للفلتر',
	'sd_createfilter_usecategoryvalues' => 'احصل على القيم للفلتر من هذا التصنيف:',
	'sd_createfilter_usedatevalues' => 'استخدم نطاقات زمنية لهذا الفلتر بهذه الفترة الزمنية:',
	'sd_createfilter_entervalues' => 'أدخل القيم للفلتر يدويا (القيم ينبغى أن يتم فصلها بواسطة فاصلات - لو أن قيمة ما تحتوى على فاصلة، استبدلها ب "\\,"):',
	'sd_createfilter_inputtype' => ': نوع المدخل للفلتر',
	'sd_createfilter_listofvalues' => 'قائمة القيم (أفتراضي)',
	'sd_createfilter_requirefilter' => 'يتطلب اختيار فلتر آخر قبل أن يتم عرض هذا:',
	'sd_createfilter_label' => 'علامة لهذا الفلتر (اختياري):',
	'sd_blank_error' => 'لا يمكن أن يكون فارغا',
	'sd_filter_coversproperty' => 'هذا الفلتر يغطى الخاصية $1.',
	'sd_filter_getsvaluesfromcategory' => 'يحصل على قيمه من التصنيف $1.',
	'sd_filter_usestimeperiod' => 'يستخدم $1 كفترته الزمنية.',
	'sd_filter_year' => 'عام',
	'sd_filter_month' => 'شهر',
	'sd_filter_hasvalues' => 'يمتلك القيم $1.',
	'sd_filter_hasinputtype' => 'لها نوع المدخل $1',
	'sd_filter_freetext' => 'نص',
	'sd_filter_daterange' => 'مدى البيانات',
	'sd_filter_requiresfilter' => 'يتطلب وجود الفلتر $1.',
	'sd_filter_haslabel' => 'يمتلك العلامة $1.',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'semanticdrilldown-desc' => "Interfaz de ''drilldown'' pa navegar pelos datos semánticos.",
	'specialpages-group-sd_group' => 'Semantic Drilldown',
	'browsedata' => 'Navegar pelos datos',
	'sd_browsedata_choosecategory' => 'Escoyer una categoría',
	'sd_browsedata_viewcategory' => 'ver categoría',
	'sd_browsedata_docu' => "Calca nún o más elementos d'abaxo p'acotar los resultaos.",
	'sd_browsedata_subcategory' => 'Subcategoría',
	'sd_browsedata_other' => 'Otru',
	'sd_browsedata_none' => 'Dengún',
	'sd_browsedata_filterbyvalue' => 'Peñerar por esti valor',
	'sd_browsedata_filterbysubcategory' => 'Peñerar por esta subcategoría',
	'sd_browsedata_otherfilter' => 'Amosar páxines con otru valor pa esta peñera',
	'sd_browsedata_nonefilter' => 'Amosar páxines con dengún valor pa esta peñera',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Desaniciar esta peñera',
	'sd_browsedata_removesubcategoryfilter' => 'Desaniciar esta peñera de subcategoría',
	'sd_browsedata_resetfilters' => 'Reestablecer peñeres',
	'sd_browsedata_addanothervalue' => "Calca na flecha p'amestar otru valor",
	'sd_browsedata_daterangestart' => 'Aniciu:',
	'sd_browsedata_daterangeend' => 'Fin:',
	'sd_browsedata_novalues' => 'Nun hai valores pa esta peñera',
	'filters' => 'Peñeres',
	'sd_filters_docu' => 'En {{SITENAME}} esisten les siguientes peñeres:',
	'createfilter' => 'Crear una peñera',
	'sd_createfilter_name' => 'Nome:',
	'sd_createfilter_property' => 'Propiedá que cubre esta peñera:',
	'sd_createfilter_usepropertyvalues' => "Usar tolos valores d'esta propiedá pa la peñera",
	'sd_createfilter_usecategoryvalues' => "Sacar los valores pa la peñera d'esta categoría:",
	'sd_createfilter_usedatevalues' => 'Usar los rangos de data pa esta peñera con esti periodu de tiempu:',
	'sd_createfilter_entervalues' => 'Escribi manualmente los valores pa la peñera (los valores se tienen de separar con comes - si un valor contién una coma sustituyila por "\\,"):',
	'sd_createfilter_inputtype' => "Triba d'entrada pa esta peñera:",
	'sd_createfilter_listofvalues' => 'llista de valores (predeterminada)',
	'sd_createfilter_requirefilter' => "Otra peñera que se tien de seleicionar enantes d'amosar esta:",
	'sd_createfilter_label' => 'Etiqueta pa esta peñera (opcional):',
	'sd_blank_error' => 'nun pue tar balero',
	'sd-pageschemas-filter' => 'Peñera',
	'sd-pageschemas-values' => 'Valores',
	'sd_filter_coversproperty' => 'Esta peñera cubre la propiedá $1.',
	'sd_filter_getsvaluesfromcategory' => 'Saca los valores de la categoría $1.',
	'sd_filter_usestimeperiod' => 'Usa $1 como periodu de tiempu.',
	'sd_filter_year' => 'Añu',
	'sd_filter_month' => 'Mes',
	'sd_filter_hasvalues' => 'Tien los valores $1.',
	'sd_filter_hasinputtype' => "Tien como tipu d'entrada $1.",
	'sd_filter_combobox' => "caxa combinada (''combo box'')",
	'sd_filter_freetext' => 'testu',
	'sd_filter_daterange' => 'rangu de dates',
	'sd_filter_requiresfilter' => 'Se requier la presencia de la peñera $1.',
	'sd_filter_haslabel' => 'Tien la etiqueta $1.',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'browsedata' => 'Origwigara',
	'sd_browsedata_choosecategory' => 'Kiblara va loma',
	'sd_browsedata_viewcategory' => 'Wira va loma',
	'sd_browsedata_subcategory' => 'Volveyloma',
	'sd_browsedata_other' => 'Ar',
	'sd_browsedata_none' => 'Mek',
	'sd_browsedata_filterbyvalue' => 'Espara kan bata voda',
	'sd_browsedata_filterbysubcategory' => 'Espara kan bata volveyloma',
	'sd_browsedata_otherfilter' => 'Nedira va bueem vadjes va ara esparavoda',
	'sd_browsedata_nonefilter' => 'Nedira va bueem mevadjes va bata espara',
	'sd_browsedata_removefilter' => 'Tioltera va bata espara',
	'sd_browsedata_removesubcategoryfilter' => 'Tioltera va bata volveylomafa espara',
	'sd_browsedata_resetfilters' => 'Dimplekura va espara',
	'filters' => 'Espasikieem',
	'sd_filters_docu' => 'Bata espara se tid in {{SITENAME}} :',
	'createfilter' => 'Redura va espara',
	'sd_createfilter_name' => 'Yolt :',
	'sd_createfilter_property' => 'Pilkaca espanon skuna :',
	'sd_createfilter_usepropertyvalues' => 'Favera va vodeem ke bata esparapilkaca',
	'sd_createfilter_usecategoryvalues' => 'Plekura va esparavoda mal bata loma :',
	'sd_createfilter_label' => 'Kral tori bata espara (rotisa) :',
	'sd_blank_error' => 'me rotir vlardafa',
	'sd_filter_coversproperty' => 'Bata espara va $1 pilkaca skur.',
	'sd_filter_getsvaluesfromcategory' => 'Mal $1 loma in va voda plekur.',
	'sd_filter_usestimeperiod' => 'In wetce intaf ugalolk va $1 faver.',
	'sd_filter_year' => 'Ilana',
	'sd_filter_month' => 'Aksat',
	'sd_filter_hasvalues' => 'In va $1 voda se digir.',
	'sd_filter_requiresfilter' => 'Batcoba va tira ke $1 espasiki kucilar.',
	'sd_filter_haslabel' => 'In tir dem $1 kral.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'sd_browsedata_other' => 'Digər',
	'sd_browsedata_none' => 'Heç biri',
	'sd_browsedata_daterangestart' => 'Başla:',
	'sd_browsedata_daterangeend' => 'Son:',
	'sd_createfilter_name' => 'Ad:',
	'sd_filter_year' => 'İl',
	'sd_filter_month' => 'Ay',
	'sd_filter_freetext' => 'mətn',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'filters' => 'Фільтры',
	'sd_filter_freetext' => 'тэкст',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'semanticdrilldown-desc' => 'Інтэрфэйс для навігацыі па сэмантычным зьвесткам',
	'specialpages-group-sd_group' => 'Сэмантычная навігацыя',
	'browsedata' => 'Прагляд зьвестак',
	'sd_browsedata_choosecategory' => 'Выберыце катэгорыю',
	'sd_browsedata_viewcategory' => 'паказаць катэгорыю',
	'sd_browsedata_docu' => 'Пазначце адзін ці больш элемэнтаў для абмежаваньня Вашых вынікаў.',
	'sd_browsedata_subcategory' => 'Падкатэгорыя',
	'sd_browsedata_other' => 'Іншыя',
	'sd_browsedata_none' => 'Не',
	'sd_browsedata_filterbyvalue' => 'Фільтраваць па гэтаму значэньню',
	'sd_browsedata_filterbysubcategory' => 'Фільтраваць па гэтай падкатэгорыі',
	'sd_browsedata_otherfilter' => 'Паказваць старонкі зь іншымі значэньнямі па гэтаму фільтру',
	'sd_browsedata_nonefilter' => 'Паказваць старонкі без значэньняў па гэтаму фільтру',
	'sd_browsedata_or' => 'ці',
	'sd_browsedata_removefilter' => 'Выдаліць гэты фільтар',
	'sd_browsedata_removesubcategoryfilter' => 'Выдаліць гэты фільтар падкатэгорыі',
	'sd_browsedata_resetfilters' => 'Ачысьціць фільтры',
	'sd_browsedata_addanothervalue' => 'Націсьніце стрэлку каб дадаць іншае значэньне',
	'sd_browsedata_daterangestart' => 'Пачатак:',
	'sd_browsedata_daterangeend' => 'Канец:',
	'sd_browsedata_novalues' => 'Няма значэньняў для гэтага фільтру',
	'filters' => 'Фільтры',
	'sd_filters_docu' => 'У {{GRAMMAR:месны|{{SITENAME}}}} існуюць наступныя фільтры:',
	'createfilter' => 'Стварыць фільтар',
	'sd_createfilter_name' => 'Назва:',
	'sd_createfilter_property' => 'Уласьцівасьць, якую пакрывае гэты фільтар:',
	'sd_createfilter_usepropertyvalues' => 'Выкарыстоўваць усе значэньні гэтай ўласьцівасьці для фільтру',
	'sd_createfilter_usecategoryvalues' => 'Атрымаць значэньні для фільтру з гэтай катэгорыі:',
	'sd_createfilter_usedatevalues' => 'Выкарыстоўваць дыяпазон датаў для гэтага фільтру з гэтым пэрыядам часу:',
	'sd_createfilter_entervalues' => 'Увядзіце значэньне для фільтру ўручную (значэньні павінны быць падзелены коскамі, калі значэньне ўтрымлівае коску, замяніце яе на «\\,»):',
	'sd_createfilter_inputtype' => 'Выходны тып для гэтага фільтру:',
	'sd_createfilter_listofvalues' => 'сьпіс значэньняў (па змоўчваньні)',
	'sd_createfilter_requirefilter' => 'Патрабуецца выбар іншага фільтру перад тым, як будзе паказаны гэты:',
	'sd_createfilter_label' => 'Метка для гэтага фільтру (неабавязкова):',
	'sd_blank_error' => 'ня можа быць незапоўненым',
	'sd_filter_coversproperty' => 'Гэты фільтар хавае ўласьцівасьць $1.',
	'sd_filter_getsvaluesfromcategory' => 'Атрымлівае свае значэньні з катэгорыі $1.',
	'sd_filter_usestimeperiod' => 'Выкарыстоўвае $1 як пэрыяд часу.',
	'sd_filter_year' => 'Год',
	'sd_filter_month' => 'Месяц',
	'sd_filter_hasvalues' => 'Мае значэньне $1.',
	'sd_filter_hasinputtype' => 'Мае выходны тып $1.',
	'sd_filter_combobox' => 'выпадаючы сьпіс',
	'sd_filter_freetext' => 'тэкст',
	'sd_filter_daterange' => 'дыяпазон дат',
	'sd_filter_requiresfilter' => 'Патрабуе наяўнасьць фільтру $1.',
	'sd_filter_haslabel' => 'Мае метку $1.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'browsedata' => 'Разглеждане на данните',
	'sd_browsedata_choosecategory' => 'Избор на категория',
	'sd_browsedata_viewcategory' => 'преглед на категорията',
	'sd_browsedata_subcategory' => 'Подкатегория',
	'sd_browsedata_other' => 'Други',
	'sd_browsedata_none' => 'Няма',
	'sd_browsedata_filterbyvalue' => 'Филтриране по тази стойност',
	'sd_browsedata_filterbysubcategory' => 'Филтриране по тази подкатегория',
	'sd_browsedata_otherfilter' => 'Показване на страниците с други стойности за този филтър',
	'sd_browsedata_nonefilter' => 'Показване на страниците без стойности за този филтър',
	'sd_browsedata_removefilter' => 'Премахване на филтъра',
	'sd_browsedata_removesubcategoryfilter' => 'Премахване на филтъра за подкатегория',
	'sd_browsedata_resetfilters' => 'Изчистване на филтрите',
	'sd_browsedata_addanothervalue' => 'Добавяне на друга стойност',
	'filters' => 'Филтри',
	'sd_filters_docu' => 'В {{SITENAME}} съществуват следните филтри:',
	'createfilter' => 'Създаване на филтър',
	'sd_createfilter_name' => 'Име:',
	'sd_createfilter_requirefilter' => 'Изисква се да бъде избран друг филтър преди да може този да бъде показан:',
	'sd_createfilter_label' => 'Заглавие за този филтър (незадължително):',
	'sd_blank_error' => 'не може да бъде празно',
	'sd_filter_year' => 'Година',
	'sd_filter_month' => 'Месец',
	'sd_filter_hasvalues' => 'Има стойности $1.',
	'sd_filter_freetext' => 'текст',
	'sd_filter_requiresfilter' => 'Необходимо е наличието на филтър $1.',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'browsedata' => 'উপাত্ত পরিদর্শন',
	'sd_browsedata_choosecategory' => 'একটি বিষয়শ্রেণী পছন্দ করুন',
	'sd_browsedata_viewcategory' => 'বিষয়শ্রেণী প্রদর্শন করো',
	'sd_browsedata_subcategory' => 'উপবিষয়শ্রেণী',
	'sd_browsedata_other' => 'অন্যান্য',
	'sd_browsedata_none' => 'কোনটিই নয়',
	'sd_browsedata_filterbyvalue' => 'এই মান অনুসারে ফিল্টার করো',
	'sd_browsedata_filterbysubcategory' => 'এই উপবিষয়শ্রেণী অনুসারে ফিল্টার করো',
	'sd_browsedata_or' => 'অথবা',
	'sd_browsedata_removefilter' => 'এই ফিল্টারটি অপসারণ করো',
	'sd_browsedata_addanothervalue' => 'আরেকটি মান প্রবেশ করাতে তীর চিহ্নে ক্লিক করুন',
	'sd_browsedata_daterangestart' => 'শুরু:',
	'sd_browsedata_daterangeend' => 'শেষ:',
	'sd_browsedata_novalues' => 'এই ফিল্টারের জন্য কোনো মান নেই',
	'filters' => 'ফিল্টার',
	'sd_filters_docu' => '{{SITENAME}} সাইটে নিচের ফিল্টারগুলো রয়েছে:',
	'createfilter' => 'নতুন ফিল্টার তৈরি করুন',
	'sd_createfilter_name' => 'নাম:',
	'sd_filter_year' => 'বছর',
	'sd_filter_month' => 'মাস',
	'sd_filter_freetext' => 'লেখা',
	'sd_filter_daterange' => 'তারিখের পরিসীমা',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'semanticdrilldown-desc' => 'Un etrefas poelladennoù evit merdeiñ dre roadennoù ereadurel',
	'specialpages-group-sd_group' => 'Poelladenn semantek',
	'browsedata' => 'Furchal ar roadennoù',
	'sd_browsedata_choosecategory' => 'Dibab ur rummad',
	'sd_browsedata_viewcategory' => 'gwelet ar rummad',
	'sd_browsedata_docu' => "Klikit war unan pe meur a elfenn da-heul evit resisaat an disoc'hoù.",
	'sd_browsedata_subcategory' => 'Isrummad',
	'sd_browsedata_other' => 'Unan all',
	'sd_browsedata_none' => 'Hini ebet',
	'sd_browsedata_filterbyvalue' => 'Silañ war-bouez an talvoud-mañ',
	'sd_browsedata_filterbysubcategory' => 'Silañ gant an isrummad-mañ',
	'sd_browsedata_otherfilter' => 'Gwelet ar bajennoù gant un talvoud all evit ar sil-mañ',
	'sd_browsedata_nonefilter' => 'Gwelet ar pajennoù gant talvoud ebet evit ar sil-mañ',
	'sd_browsedata_or' => 'pe',
	'sd_browsedata_removefilter' => 'Lemel ar sil-mañ',
	'sd_browsedata_removesubcategoryfilter' => 'Tennañ an is-rummad a siloù',
	'sd_browsedata_resetfilters' => 'Adderaouekaat ar siloù',
	'sd_browsedata_addanothervalue' => 'Klikit war ar bir da ouzhpennañ un talvoud all',
	'sd_browsedata_daterangestart' => 'Penn kentañ :',
	'sd_browsedata_daterangeend' => 'Dibenn :',
	'sd_browsedata_novalues' => "N'eus talvoud ebet evit ar sil-mañ",
	'filters' => 'Siloù',
	'sd_filters_docu' => 'Bez ez eus eus ar siloù-mañ war {{SITENAME}} :',
	'createfilter' => 'Krouiñ ur sil',
	'sd_createfilter_name' => 'Anv :',
	'sd_createfilter_property' => "Perc'henniezh a vo goloet gant ar sil-mañ :",
	'sd_createfilter_usepropertyvalues' => "Implijout holl talvoudoù ar berc'henniezh evit ar sil-mañ",
	'sd_createfilter_usecategoryvalues' => 'Kaout an talvoudoù evit ar sil adalek ar rummad-mañ :',
	'sd_createfilter_usedatevalues' => "Implijout a ra bloc'hadoù deiziad evit ar sil-mañ gant an amzervezh-mañ :",
	'sd_createfilter_entervalues' => "Lakait c'hwi hoc'h-unan talvoudoù evit ar sil-mañ (gant skejoù e tle an talvoudoù bezañ dispartiet - ma vez ur skej en un talvoud, lakait ur \"\\,\" en e lec'h):",
	'sd_createfilter_inputtype' => 'Ar seurt moned e-barzh evit ar sil-mañ :',
	'sd_createfilter_listofvalues' => 'roll talvoudoù (dre ziouer)',
	'sd_createfilter_requirefilter' => 'Goulenn ma vo diuzet ur sil all a-raok na zeufe hemañ war wel :',
	'sd_createfilter_label' => 'Tiketenn evit ar sil-mañ (diret) :',
	'sd_blank_error' => "n'hall ket chom goullo",
	'sd-pageschemas-filter' => 'Sil',
	'sd-pageschemas-values' => 'Talvoudoù',
	'sd_filter_coversproperty' => "Ar sil-mañ a ra war-dro ar perc'henniezh $1.",
	'sd_filter_getsvaluesfromcategory' => 'E dalvoudoù en deus eus ar rummad $1.',
	'sd_filter_usestimeperiod' => 'Implijout a ra $1 evel padelezh ar prantad',
	'sd_filter_year' => 'Bloaz',
	'sd_filter_month' => 'Miz',
	'sd_filter_hasvalues' => 'An talvoud $1 en deus.',
	'sd_filter_hasinputtype' => 'Ar seurt moned e-barzh $1 en deus.',
	'sd_filter_combobox' => 'stern roll disachañ',
	'sd_filter_freetext' => 'testenn',
	'sd_filter_daterange' => 'emled an deiziad',
	'sd_filter_requiresfilter' => 'Ezhomm en deus eus bezañs ar sil $1.',
	'sd_filter_haslabel' => 'An tikedenn $1 en deus.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'semanticdrilldown-desc' => 'Interfejs za postupnu navigaciju kroz semantičke podatke',
	'specialpages-group-sd_group' => 'Semantičko istančavanje',
	'browsedata' => 'Pregledaj podatke',
	'sd_browsedata_choosecategory' => 'Izaberi kategoriju',
	'sd_browsedata_viewcategory' => 'pogledaj kategoriju',
	'sd_browsedata_docu' => 'Kliknite na jednu ili više stavki ispod za sužavanje vaših rezultata.',
	'sd_browsedata_subcategory' => 'Podkategorija',
	'sd_browsedata_other' => 'Ostalo',
	'sd_browsedata_none' => 'Ništa',
	'sd_browsedata_filterbyvalue' => 'Filter po ovoj vrijednosti',
	'sd_browsedata_filterbysubcategory' => 'Filter po ovoj podkategoriji',
	'sd_browsedata_otherfilter' => 'Prikaži stranice sa drugom vrijednošću za ovaj filter',
	'sd_browsedata_nonefilter' => 'Pokaži stranice bez vrijednosti za ovaj filter',
	'sd_browsedata_or' => 'ili',
	'sd_browsedata_removefilter' => 'Ukloni ovaj filter',
	'sd_browsedata_removesubcategoryfilter' => 'Ukloni ovaj filter podkategorije',
	'sd_browsedata_resetfilters' => 'Resetuj filtere',
	'sd_browsedata_addanothervalue' => 'Klikni na strelicu za dodavanje druge vrijednosti',
	'sd_browsedata_daterangestart' => 'Početak:',
	'sd_browsedata_daterangeend' => 'Kraj:',
	'sd_browsedata_novalues' => 'Nema vrijednosti za ovaj filter',
	'filters' => 'Filteri',
	'sd_filters_docu' => 'Na {{SITENAME}} postoje slijedeći filteri:',
	'createfilter' => 'Napravi filter',
	'sd_createfilter_name' => 'Ime:',
	'sd_createfilter_property' => 'Svojstvo koje ovaj filter pokriva:',
	'sd_createfilter_usepropertyvalues' => 'Koristi sve vrijednosti ovog svojstva za filter',
	'sd_createfilter_usecategoryvalues' => 'Preuzmi vrijednosti za filter iz ove kategorije:',
	'sd_createfilter_usedatevalues' => 'Koristite datumski period za ovaj filter za ovim vremenskim periodom:',
	'sd_createfilter_entervalues' => 'Unesite ručno vrijednosti za filter (vrijednosti se trebaju razdvojiti zarezima - ako vrijednost sadrži zarez, zamijenite ga sa "\\,"):',
	'sd_createfilter_inputtype' => 'Tip unosa za ovaj filter:',
	'sd_createfilter_listofvalues' => 'spisak vrijednosti (pretpostavljeno)',
	'sd_createfilter_requirefilter' => 'Zahtijeva drugi filter da bude odabran prije nego se ovaj prikaže:',
	'sd_createfilter_label' => 'Naslov za ovaj filter (opcija):',
	'sd_blank_error' => 'ne može biti prazno',
	'sd_filter_coversproperty' => 'Ovaj filter pokriva svojstvo $1.',
	'sd_filter_getsvaluesfromcategory' => 'Uzima svoje vrijednosti iz kategorije $1.',
	'sd_filter_usestimeperiod' => 'Koristi $1 kao svoj vremenski period.',
	'sd_filter_year' => 'Godina',
	'sd_filter_month' => 'mjesec',
	'sd_filter_hasvalues' => 'Ima vrijednosti $1.',
	'sd_filter_hasinputtype' => 'Ima vrstu ulaza $1.',
	'sd_filter_combobox' => 'rasklopna kutija',
	'sd_filter_freetext' => 'tekst',
	'sd_filter_daterange' => 'vremenski raspon',
	'sd_filter_requiresfilter' => 'Zahtjeva prisustvo filtera $1.',
	'sd_filter_haslabel' => 'Ima oznaku $1.',
);

/** Catalan (Català)
 * @author Dvdgmz
 * @author Jordi Roqué
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'semanticdrilldown-desc' => "Una interfície de ''drilldown'' per navegar a través de la informació semàntica",
	'specialpages-group-sd_group' => 'Semantic Drilldown',
	'browsedata' => 'Explorar dades',
	'sd_browsedata_choosecategory' => 'Esculli una categoria',
	'sd_browsedata_viewcategory' => 'veure la categoria',
	'sd_browsedata_docu' => 'Clica un o més ítems aquí sota per acotar els teus resultats.',
	'sd_browsedata_subcategory' => 'Subcategoria',
	'sd_browsedata_other' => 'Un altre',
	'sd_browsedata_none' => 'Cap',
	'sd_browsedata_filterbyvalue' => 'Filtra per aquest valor',
	'sd_browsedata_filterbysubcategory' => 'Filtra amb aquesta subcategoria',
	'sd_browsedata_otherfilter' => 'Mostra pàgines amb un altre valor per aquest filtre',
	'sd_browsedata_nonefilter' => 'Mostra les pàgines que no tenen cap valor per aquest filtre',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Elimina aquest filtre',
	'sd_browsedata_removesubcategoryfilter' => 'Elimina aquest filtre de subcategoria',
	'sd_browsedata_resetfilters' => 'Restaura filtres',
	'sd_browsedata_addanothervalue' => 'Feu clic sobre la fletxa per afegir un altre valor',
	'sd_browsedata_daterangestart' => 'Inici:',
	'sd_browsedata_daterangeend' => 'Fi:',
	'sd_browsedata_novalues' => "No s'han trobat valors per aquest filtre",
	'filters' => 'Filtres',
	'sd_filters_docu' => 'A {{SITENAME}} hi ha els filtres següents:',
	'createfilter' => 'Crea un filtre',
	'sd_createfilter_name' => 'Nom:',
	'sd_createfilter_property' => 'Propietat que cobreix aquest filtre:',
	'sd_createfilter_usepropertyvalues' => "Utilitza tots els valors d'aquesta propietat per el filtre",
	'sd_createfilter_usecategoryvalues' => "Pren els valors pel filtre d'aquesta categoria:",
	'sd_createfilter_usedatevalues' => 'Per aquest filtre fes servir rangs de data en aquest període de temps:',
	'sd_createfilter_entervalues' => 'Per filtrar manualment entra valors (els valors s\'han de separar per comes - si el valor conté una como substitueix-la per "\\,"):',
	'sd_createfilter_inputtype' => "Tipus d'entrada de dades per aquest filtre:",
	'sd_createfilter_listofvalues' => 'Llista de valors (per defecte)',
	'sd_createfilter_requirefilter' => 'Cal seleccionar un altre filtre abans de mostrar aquest:',
	'sd_createfilter_label' => 'Rètol per aquest filtre (opcional):',
	'sd_blank_error' => 'no es pot deixar buit',
	'sd-pageschemas-filter' => 'Filtre',
	'sd-pageschemas-values' => 'Valors',
	'sd_filter_coversproperty' => 'Aquest filtre cobreix la propietat $1',
	'sd_filter_getsvaluesfromcategory' => 'Pren els seus valors de la categoria $1',
	'sd_filter_usestimeperiod' => 'Utilitza $1 com a període de temps.',
	'sd_filter_year' => 'Any',
	'sd_filter_month' => 'Mes',
	'sd_filter_hasvalues' => 'Té els valors $1.',
	'sd_filter_hasinputtype' => "Té $1 com a tipus d'entrada.",
	'sd_filter_combobox' => "Caix combinada (''combo box'')",
	'sd_filter_freetext' => 'text',
	'sd_filter_daterange' => 'rang de dates',
	'sd_filter_requiresfilter' => 'Es requereix la presencia del filtre $1',
	'sd_filter_haslabel' => 'Té el ròtul $1.',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'sd_filter_year' => 'Шо',
);

/** Czech (Česky)
 * @author Juan de Vojníkov
 */
$messages['cs'] = array(
	'sd_browsedata_subcategory' => 'Podkategorie',
	'sd_browsedata_other' => 'Jiné',
	'sd_browsedata_none' => 'Nic',
	'sd_browsedata_daterangeend' => 'Konec:',
	'sd_createfilter_name' => 'Jméno:',
	'sd_filter_year' => 'Rok',
	'sd_filter_month' => 'Měsíc',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'filters' => 'Hidlau',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'sd_browsedata_none' => 'Ingen',
	'sd_createfilter_name' => 'Navn:',
	'sd_filter_year' => 'År',
	'sd_filter_month' => 'Måned',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author DaSch
 * @author Kghbln
 * @author Krabina
 * @author Lyzzy
 * @author Melancholie
 * @author MichaelFrey
 * @author MovGP0
 * @author Purodha
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'semanticdrilldown-desc' => 'Ermöglicht eine Benutzerschnittstelle für eine gestufte Navigation durch semantische Daten',
	'specialpages-group-sd_group' => 'Semantische gestufte Navigation',
	'browsedata' => 'Daten ansehen',
	'sd_browsedata_choosecategory' => 'Kategorie auswählen',
	'sd_browsedata_viewcategory' => 'Kategorie ansehen',
	'sd_browsedata_docu' => 'Klick auf einen oder mehrere der Filter um das Ergebnis einzuschränken.',
	'sd_browsedata_subcategory' => 'Unterkategorie',
	'sd_browsedata_other' => 'Anderes',
	'sd_browsedata_none' => 'Nichts',
	'sd_browsedata_filterbyvalue' => 'Filtere über diesen Wert',
	'sd_browsedata_filterbysubcategory' => 'Filtere über diese Unterkategorie',
	'sd_browsedata_otherfilter' => 'Zeige Seiten mit einem anderen Wert für diesen Filter',
	'sd_browsedata_nonefilter' => 'Zeige Seiten mit keinem Wert für diesen Filter',
	'sd_browsedata_or' => 'oder',
	'sd_browsedata_removefilter' => 'Lösche diesen Filter',
	'sd_browsedata_removesubcategoryfilter' => 'Lösche diesen Unterkategoriefilter',
	'sd_browsedata_resetfilters' => 'Filter zurücksetzen',
	'sd_browsedata_addanothervalue' => 'Klicke auf den Pfeil, um einen weiteren Wert hinzuzufügen',
	'sd_browsedata_daterangestart' => 'Anfang:',
	'sd_browsedata_daterangeend' => 'Ende:',
	'sd_browsedata_novalues' => 'Es sind keine Werte für diesen Filter vorhanden.',
	'filters' => 'Filter',
	'sd_filters_docu' => 'Die folgenden Filter sind in diesem Wiki vorhanden:',
	'createfilter' => 'Einen Filter erstellen',
	'sd_createfilter_name' => 'Name:',
	'sd_createfilter_property' => 'Attribut dieses Filters:',
	'sd_createfilter_usepropertyvalues' => 'Verwende alle Werte dieses Attributs für den Filter.',
	'sd_createfilter_usecategoryvalues' => 'Verwende die Werte dieser Kategorie für den Filter:',
	'sd_createfilter_usedatevalues' => 'Verwende folgende Zeitangabe für diesen Filter:',
	'sd_createfilter_entervalues' => 'Verwende diese Werte für den Filter (Werte durch Komma getrennt eingeben - Wenn ein Wert ein Komma enthält, mit „\\,“ ersetzen):',
	'sd_createfilter_inputtype' => 'Eingabetyp dieses Filters:',
	'sd_createfilter_listofvalues' => 'Liste von Werten (Standard)',
	'sd_createfilter_requirefilter' => 'Bevor dieser Filter angezeigt werden kann, muss folgender anderer Filter gesetzt sein:',
	'sd_createfilter_label' => 'Bezeichnung dieses Filters (optional):',
	'sd_blank_error' => 'darf nicht leer sein',
	'sd-pageschemas-filter' => 'Filter',
	'sd-pageschemas-values' => 'Werte',
	'sd_filter_coversproperty' => 'Dieser Filter betrifft das Attribut $1.',
	'sd_filter_getsvaluesfromcategory' => 'Er erhält seine Werte aus der Kategorie $1.',
	'sd_filter_usestimeperiod' => 'Er verwendet $1 als Zeitangabe.',
	'sd_filter_year' => 'Jahr',
	'sd_filter_month' => 'Monat',
	'sd_filter_hasvalues' => 'Er hat den Wert $1.',
	'sd_filter_hasinputtype' => 'Er hat den Eingabetypen $1.',
	'sd_filter_combobox' => 'Auswahlbox',
	'sd_filter_freetext' => 'Text',
	'sd_filter_daterange' => 'Zeitspanne',
	'sd_filter_requiresfilter' => 'Setzt den Filter $1 voraus.',
	'sd_filter_haslabel' => 'Er hat die Bezeichnung $1.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Dst
 * @author Imre
 */
$messages['de-formal'] = array(
	'sd_browsedata_docu' => 'Klicken Sie auf einen oder mehrere der Filter um das Ergebnis einzuschränken.',
	'sd_browsedata_addanothervalue' => 'Klicken Sie auf den Pfeil, um einen weiteren Wert hinzuzufügen',
	'sd_createfilter_entervalues' => 'Verwenden Sie diese Werte für den Filter (Werte durch Komma getrennt eingeben - Wenn ein Wert ein Komma enthält, mit „\\,“ ersetzen):',
);

/** Zazaki (Zazaki)
 * @author Belekvor
 */
$messages['diq'] = array(
	'sd_browsedata_none' => 'çino',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'semanticdrilldown-desc' => 'Interfejs za nawigaciju pśez semantiske daty',
	'specialpages-group-sd_group' => 'Semantiska nawigacija',
	'browsedata' => 'Daty se woglědaś',
	'sd_browsedata_choosecategory' => 'Kategoriju wubraś',
	'sd_browsedata_viewcategory' => 'kategoriju se woglědaś',
	'sd_browsedata_docu' => 'Klikni na jaden zapisk abo někotare zapiski, aby zwuscył swóje wuslědki.',
	'sd_browsedata_subcategory' => 'Pódkategorija',
	'sd_browsedata_other' => 'Druge',
	'sd_browsedata_none' => 'Žedne',
	'sd_browsedata_filterbyvalue' => 'Pó toś tej gódnośe filtrowaś',
	'sd_browsedata_filterbysubcategory' => 'Pó toś tej pódkategoriji filtrowaś',
	'sd_browsedata_otherfilter' => 'Boki z drugeju gódnotu za toś ten filter pokazaś',
	'sd_browsedata_nonefilter' => 'Boki bźez gódnoty za toś ten filter pokazaś',
	'sd_browsedata_or' => 'abo',
	'sd_browsedata_removefilter' => 'Toś ten filter wótpóraś',
	'sd_browsedata_removesubcategoryfilter' => 'Toś ten filter za pódkategorije wótpóraś',
	'sd_browsedata_resetfilters' => 'Filter slědk stajiś',
	'sd_browsedata_addanothervalue' => 'Na šypku kliknuś, aby se druga gódnota pśidał',
	'sd_browsedata_daterangestart' => 'Zachopjeńk:',
	'sd_browsedata_daterangeend' => 'Kóńc:',
	'sd_browsedata_novalues' => 'Za tós ten filter gódnoty njejsu',
	'filters' => 'Filtry',
	'sd_filters_docu' => 'Slědujuce filtry eksistěruju w {{GRAMMAR:lokatiw|{{SITENAME}}}}:',
	'createfilter' => 'Filter napóraś',
	'sd_createfilter_name' => 'Mě:',
	'sd_createfilter_property' => 'Kakosć, kótaruž toś ten filter wopśimujo:',
	'sd_createfilter_usepropertyvalues' => 'Wše gódnoty toś teje kakosći za filter wužywaś',
	'sd_createfilter_usecategoryvalues' => 'Gódnoty za filter z toś teje kategorije wobstaraś:',
	'sd_createfilter_usedatevalues' => 'Casowe wótrězki wobłuki za toś ten filter z toś teju casoweju periodu wužywaś:',
	'sd_createfilter_entervalues' => 'Zapódaj gódnoty za filter manuelnje (gódnoty by měli se pśez komy wótźěliś - jolic gódnota wopśimujo komu, wuměń ju pśez "\\,"):',
	'sd_createfilter_inputtype' => 'Typ zapódaśa za toś ten filter:',
	'sd_createfilter_listofvalues' => 'lisćina gódnotow (standardny)',
	'sd_createfilter_requirefilter' => 'Nježli toś ten filter dajo se zwobrazniś, musyš drugi filter wubraś:',
	'sd_createfilter_label' => 'Pomjenjenje za toś ten filter (opcionalny):',
	'sd_blank_error' => 'njesmějo prozny byś',
	'sd_filter_coversproperty' => 'Toś ten filter wopśimujo kakosć $1.',
	'sd_filter_getsvaluesfromcategory' => 'Dostawa swóje gódnoty z kategorije $1.',
	'sd_filter_usestimeperiod' => 'Wužywa $1 ako swój casowy wótrězk.',
	'sd_filter_year' => 'Lěto',
	'sd_filter_month' => 'Mjasec',
	'sd_filter_hasvalues' => 'Ma gódnoty $1.',
	'sd_filter_hasinputtype' => 'Ma typ zapódaśa $1.',
	'sd_filter_combobox' => 'kombinaciski kašćik',
	'sd_filter_freetext' => 'tekst',
	'sd_filter_daterange' => 'casowy wótrězk',
	'sd_filter_requiresfilter' => 'Filter $1 musy eksistěrowaś.',
	'sd_filter_haslabel' => 'Ma pomjenjenje $1.',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'browsedata' => 'Δεδομένα πλοήγησης',
	'sd_browsedata_choosecategory' => 'Επιλέξτε μια κατηγορία',
	'sd_browsedata_viewcategory' => 'προβολή κατηγορίας',
	'sd_browsedata_subcategory' => 'Υποκατηγορία',
	'sd_browsedata_other' => 'Άλλος',
	'sd_browsedata_none' => 'Κανένα',
	'sd_browsedata_filterbyvalue' => 'Φιλτράρισμα βάσει αυτής της αξίας',
	'sd_browsedata_filterbysubcategory' => 'Φιλτράρισμα βάσει αυτής της υποκατηγορίας',
	'sd_browsedata_or' => 'ή',
	'sd_browsedata_removefilter' => 'ΑΦαίρεσυ αυτού του φίλτρου',
	'sd_browsedata_resetfilters' => 'Επαναφορά φίλτρων',
	'sd_browsedata_addanothervalue' => 'Κάνετε κλικ στο τόξο για την προσθήκη και άλλης αξίας',
	'sd_browsedata_daterangestart' => 'Έναρξη:',
	'sd_browsedata_daterangeend' => 'Λήξη:',
	'filters' => 'Φίλτρα',
	'createfilter' => 'Δημιουργία ενός φίλτρου',
	'sd_createfilter_name' => 'Όνομα:',
	'sd_createfilter_inputtype' => 'Τύπος εισόδου για αυτό το φίλτρο:',
	'sd_createfilter_listofvalues' => 'λίστα αξιών (προεπιλεγμένο)',
	'sd_blank_error' => 'δεν γίνεται να εκκαθαριστεί',
	'sd_filter_year' => 'Χρόνος',
	'sd_filter_month' => 'Μήνας',
	'sd_filter_hasvalues' => 'Έχει τις τιμές $1.',
	'sd_filter_hasinputtype' => 'Έχει τον τύπο εισόδου $1.',
	'sd_filter_combobox' => 'συνεχόμενο κουτί',
	'sd_filter_freetext' => 'κείμενο',
	'sd_filter_daterange' => 'σειρά ημερομηνιών',
	'sd_filter_requiresfilter' => 'Απαιτεί τη παρουσία του φίλτρου $1.',
	'sd_filter_haslabel' => 'Έχει την ετικέτα $1.',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'browsedata' => 'Rigardu datenojn',
	'sd_browsedata_choosecategory' => 'Elektu kategorion',
	'sd_browsedata_viewcategory' => 'rigardu kategorion',
	'sd_browsedata_subcategory' => 'Subkategorio',
	'sd_browsedata_other' => 'Alia',
	'sd_browsedata_none' => 'Neniu',
	'sd_browsedata_filterbyvalue' => 'Filtru laŭ ĉi tiu valoro',
	'sd_browsedata_filterbysubcategory' => 'Filtru laŭ ĉi tiu subkategorio',
	'sd_browsedata_otherfilter' => 'Montru paĝojn kun alia valoro por ĉi tiu filtrilo',
	'sd_browsedata_nonefilter' => 'Montru paĝojn kun neniu valoro por ĉi tiu filtrilo',
	'sd_browsedata_or' => 'aŭ',
	'sd_browsedata_removefilter' => 'Forigu filtrilon',
	'sd_browsedata_removesubcategoryfilter' => 'Forigu ĉi tiun subkategorian filtrilon',
	'sd_browsedata_resetfilters' => 'Restarigu filtrilojn',
	'sd_browsedata_addanothervalue' => 'Alklaku sagon por aldoni plian valoron',
	'sd_browsedata_daterangestart' => 'Ekde:',
	'sd_browsedata_daterangeend' => 'Al:',
	'sd_browsedata_novalues' => 'Estas neniuj valoroj por ĉi tiu filtrilo',
	'filters' => 'Filtriloj',
	'sd_filters_docu' => 'La jenaj filtriloj ekzistas en {{SITENAME}}:',
	'createfilter' => 'Kreu filtrilon',
	'sd_createfilter_name' => 'Nomo:',
	'sd_createfilter_property' => 'Eco kovrita de ĉi tiu filtrilo:',
	'sd_createfilter_usepropertyvalues' => 'Uzu ĉiujn valorojn de ĉi tiu atributo por la filtrilo',
	'sd_createfilter_usecategoryvalues' => 'Akiru valorojn por filtrilo de ĉi tiu kategorio:',
	'sd_createfilter_usedatevalues' => 'Uzu dat-intervalojn por ĉi tiu filtrilo kun ĉi tiu tempo-periodo:',
	'sd_createfilter_entervalues' => 'Enigu valorojn por filtrilo permane (valoroj estu apartigitaj de komoj - se valoro enhavas komon, anstataŭigu ĝin per "\\,"):',
	'sd_createfilter_listofvalues' => 'listo de valoroj (defaŭltaj)',
	'sd_createfilter_requirefilter' => 'Devigu alian filtrilon esti selektita antaŭ ĉi tiu estas montrita:',
	'sd_createfilter_label' => 'Etikedo por ĉi tiu filtrilo (nedeviga):',
	'sd_blank_error' => 'ne povas esti malplena',
	'sd_filter_coversproperty' => 'Ĉi tiu filtrilo kovras la econ $1.',
	'sd_filter_getsvaluesfromcategory' => 'Ĝi akiras ties valorojn de la kategorio $1.',
	'sd_filter_usestimeperiod' => 'Ĝi uzas $1 kiel ies tempdaŭron.',
	'sd_filter_year' => 'Jaro',
	'sd_filter_month' => 'Monato',
	'sd_filter_hasvalues' => 'Ĝi havas valorojn $1.',
	'sd_filter_combobox' => 'falmenuo',
	'sd_filter_freetext' => 'teksto',
	'sd_filter_daterange' => 'tempospaco',
	'sd_filter_requiresfilter' => 'Ĝi devigas la eston de la filtrilo $1.',
	'sd_filter_haslabel' => 'Ĝi havas etikedon $1.',
);

/** Spanish (Español)
 * @author Bola
 * @author Crazymadlover
 * @author Dvdgmz
 * @author Imre
 * @author Mor
 * @author Sanbec
 */
$messages['es'] = array(
	'semanticdrilldown-desc' => "Una interfaz de ''drilldown'' para navegar a través de los datos semánticos.",
	'specialpages-group-sd_group' => 'Semantic Drilldown',
	'browsedata' => 'Datos de navegación',
	'sd_browsedata_choosecategory' => 'Escoger una categoría',
	'sd_browsedata_viewcategory' => 'Ver categoría',
	'sd_browsedata_docu' => 'Haz click en uno o más items de abajo para precisar tus resultados.',
	'sd_browsedata_subcategory' => 'Subcategoría',
	'sd_browsedata_other' => 'Otro',
	'sd_browsedata_none' => 'Ninguno',
	'sd_browsedata_filterbyvalue' => 'Filtrar por este valor',
	'sd_browsedata_filterbysubcategory' => 'Filtrar por esta subcategoría',
	'sd_browsedata_otherfilter' => 'Mostrar páginas con otro valor para este filtro',
	'sd_browsedata_nonefilter' => 'Mostrar páginas sin valores para este filtro',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Quitar este filtro',
	'sd_browsedata_removesubcategoryfilter' => 'Quitar este filtro de subcategoría',
	'sd_browsedata_resetfilters' => 'Reestablecer filtros',
	'sd_browsedata_addanothervalue' => 'Haga click en la flecha para agregar otro valor',
	'sd_browsedata_daterangestart' => 'Inicio:',
	'sd_browsedata_daterangeend' => 'Fin:',
	'sd_browsedata_novalues' => 'No hay valores para este filtro',
	'filters' => 'Filtros',
	'sd_filters_docu' => 'Los siguientes filtros existen en {{SITENAME}}:',
	'createfilter' => 'Crear un filtro',
	'sd_createfilter_name' => 'Nombre:',
	'sd_createfilter_property' => 'Propiedad que este filtro cubre:',
	'sd_createfilter_usepropertyvalues' => 'Usar todos los valores de esta propiedad para el filtro',
	'sd_createfilter_usecategoryvalues' => 'Obtenga valores para el filtro desde esta categoría:',
	'sd_createfilter_usedatevalues' => 'Usar rangos de fecha para este filtro con este periodo de tiempo:',
	'sd_createfilter_entervalues' => 'Ingresar valores para el filtro manualmente (valores deberían estar separados por comas - si un valor contiene una coma, reemplacela con "\\,"):',
	'sd_createfilter_inputtype' => 'Tipo de entrada de datos para este filtro:',
	'sd_createfilter_listofvalues' => 'lista de valores (por defecto)',
	'sd_createfilter_requirefilter' => 'Requiere otro filtro a ser seleccionado antes que este sea mostrado:',
	'sd_createfilter_label' => 'Etiqueta para este filtro (opcional):',
	'sd_blank_error' => 'No puede estar en blanco',
	'sd_filter_coversproperty' => 'Este filtro cubre la propiedad $1.',
	'sd_filter_getsvaluesfromcategory' => 'Obtiene sus valores de la categoría $1.',
	'sd_filter_usestimeperiod' => 'Usa $1 como su periodo de tiempo.',
	'sd_filter_year' => 'Año',
	'sd_filter_month' => 'Mes',
	'sd_filter_hasvalues' => 'Tiene los valores $1.',
	'sd_filter_hasinputtype' => 'Tiene como tipo de entrada $1.',
	'sd_filter_combobox' => "Caja combinada (''combo box'')",
	'sd_filter_freetext' => 'texto',
	'sd_filter_daterange' => 'rango de fechas',
	'sd_filter_requiresfilter' => 'Requiere la presencia del filtro $1.',
	'sd_filter_haslabel' => 'Tiene la etiqueta $1.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'browsedata' => 'Datuak arakatu',
	'sd_browsedata_choosecategory' => 'Kategoria aukeratu',
	'sd_browsedata_viewcategory' => 'kategoria ikusi',
	'sd_browsedata_subcategory' => 'Azpikategoria',
	'sd_browsedata_or' => 'edo',
	'sd_browsedata_removefilter' => 'Iragazki hau kendu',
	'sd_browsedata_resetfilters' => 'Iragazkiak berrezarri',
	'sd_browsedata_addanothervalue' => 'Gezian klikatu beste balio bat gehitzeko',
	'sd_browsedata_daterangestart' => 'Hasiera:',
	'sd_browsedata_daterangeend' => 'Amaiera:',
	'filters' => 'Iragazkiak',
	'createfilter' => 'Iragazki bat sortu',
	'sd_createfilter_name' => 'Izena:',
	'sd_filter_year' => 'Urtea',
	'sd_filter_month' => 'Hilabetea',
	'sd_filter_freetext' => 'testua',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Ibrahim
 * @author Tofighi
 */
$messages['fa'] = array(
	'browsedata' => 'نمایش اطلاعات',
	'sd_browsedata_choosecategory' => 'انتخاب یک رده',
	'sd_browsedata_viewcategory' => 'نمایش رده',
	'sd_browsedata_subcategory' => 'زیررده',
	'sd_browsedata_other' => 'دیگر',
	'sd_browsedata_none' => 'هیچکدام',
	'sd_browsedata_filterbyvalue' => 'فیلتر با این مقدار',
	'sd_browsedata_filterbysubcategory' => 'فیلتر با این زیر رده',
	'sd_browsedata_otherfilter' => 'نمایش صفحاتی با مقدار دیگر برای این فیلتر',
	'sd_browsedata_nonefilter' => 'نمایش صفحه‌های فاقد مقدار برای این فیلتر',
	'sd_browsedata_or' => 'یا',
	'sd_browsedata_removefilter' => 'حذف این فیلتر',
	'sd_browsedata_removesubcategoryfilter' => 'حذف این فیلتر زیر رده',
	'sd_browsedata_resetfilters' => 'تنظیم فیلترها از نو',
	'sd_browsedata_addanothervalue' => 'برای اضافه‌کردن مقداری دیگر بر روی پیکان کلیک کنید.',
	'sd_browsedata_daterangestart' => ':شروع',
	'filters' => 'پالایه‌ها',
	'sd_filters_docu' => 'فیلترهای زیر در این ویکی وجود دارد:',
	'createfilter' => 'پالایه‌ای بسازید',
	'sd_createfilter_name' => 'نام:',
	'sd_createfilter_property' => 'ویژگی که این فیلتر شامل آن می‌شود:',
	'sd_createfilter_usepropertyvalues' => 'همه مقادیر این ویژگی را برای این فیلتر به‌کار برید',
	'sd_createfilter_usecategoryvalues' => 'مقادیر فیلتر را از این رده بگیرید:',
	'sd_createfilter_usedatevalues' => 'بازه زمانی که به عنوان پریود زمانی این فیلتر به‌کار گرفته شود:',
	'sd_createfilter_entervalues' => 'مقادیر فیلتر را دستی وارد کنید (مقادیر باید با کاما جدا شوند، اگر یک مقدار کاما دارد، آن‌را با "\\،" جایگزین کنید):',
	'sd_createfilter_requirefilter' => 'قبل از نمایش این یکی، یک فیلتر دیگر باید انتخاب شود:',
	'sd_createfilter_label' => 'برچسب این فیلتر (دلخواه)',
	'sd_blank_error' => 'نمی‌تواند خالی باشد',
	'sd_filter_coversproperty' => 'این فیلتر ویژگی $1 را شامل می‌شود.',
	'sd_filter_getsvaluesfromcategory' => 'مقادیرش را از رده $1 می‌گیرد',
	'sd_filter_usestimeperiod' => '$1 را به عنوان پریود زمانی به‌کار می‌برد',
	'sd_filter_year' => 'سال',
	'sd_filter_month' => 'ماه',
	'sd_filter_hasvalues' => 'مقادیر $1 را دارد.',
	'sd_filter_requiresfilter' => 'به وجود فیلتر $1 احتیاج دارد.',
	'sd_filter_haslabel' => 'برچسب $1 دارد.',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'browsedata' => 'Datan selaus',
	'sd_browsedata_choosecategory' => 'Valitse luokka',
	'sd_browsedata_viewcategory' => 'näytä luokka',
	'sd_browsedata_docu' => 'Valitse yksi tai useampia kohteita alempaa lisärajataksesi tuloksia.',
	'sd_browsedata_subcategory' => 'Alaluokka',
	'sd_browsedata_other' => 'Muu',
	'sd_browsedata_none' => 'Ei mikään',
	'sd_browsedata_filterbyvalue' => 'Suodata tällä arvolla',
	'sd_browsedata_filterbysubcategory' => 'Suodata tämän alaluokan suhteen',
	'sd_browsedata_otherfilter' => 'Näytä sivut toisella arvolla tällä suodattimella',
	'sd_browsedata_nonefilter' => 'Näytä sivut ilman arvoa tällä suodattimella',
	'sd_browsedata_or' => 'tai',
	'sd_browsedata_removefilter' => 'Poista suodin',
	'sd_browsedata_removesubcategoryfilter' => 'Poista tämä alaluokka-suodatin',
	'sd_browsedata_resetfilters' => 'Nollaa suotimet',
	'sd_browsedata_addanothervalue' => 'Napsauta nuolta lisääksesi uuden arvon',
	'sd_browsedata_daterangestart' => 'Alku',
	'sd_browsedata_daterangeend' => 'Loppu',
	'sd_browsedata_novalues' => 'Tälle suodattimelle ei ole arvoja',
	'filters' => 'Suotimet',
	'sd_filters_docu' => 'Tässä wikissä on seuraavat suotimet:',
	'createfilter' => 'Luo suodin',
	'sd_createfilter_name' => 'Nimi',
	'sd_createfilter_usedatevalues' => 'Käytä päiväys-rajoituksia tämän suodattimen kanssa käyttäen tätä aikajaksoa:',
	'sd_createfilter_listofvalues' => 'luettelo arvoista (oletus)',
	'sd_createfilter_requirefilter' => 'Vaatii toisen suodattimen valinnan ennen kuin tämä näytetään:',
	'sd_blank_error' => 'ei voi olla tyhjä',
	'sd_filter_year' => 'Vuosi',
	'sd_filter_month' => 'Kuukausi',
	'sd_filter_hasvalues' => 'Sillä on arvot $1.',
	'sd_filter_freetext' => 'teksti',
	'sd_filter_daterange' => 'päiväväli',
	'sd_filter_requiresfilter' => 'Se edellyttää suodattimen $1.',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author IAlex
 * @author Jean-Frédéric
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'semanticdrilldown-desc' => 'Une interface d’exercice pour la navigation au travers de semantic data',
	'specialpages-group-sd_group' => 'Exercice de sémantique',
	'browsedata' => 'Chercher les données',
	'sd_browsedata_choosecategory' => 'Choisir une catégorie',
	'sd_browsedata_viewcategory' => 'Voir la catégorie',
	'sd_browsedata_docu' => 'Cliquer sur un ou plusieurs éléments pour resserrer vos résultats.',
	'sd_browsedata_subcategory' => 'Sous-catégorie',
	'sd_browsedata_other' => 'Autre',
	'sd_browsedata_none' => 'Néant',
	'sd_browsedata_filterbyvalue' => 'Filtré par valeur',
	'sd_browsedata_filterbysubcategory' => 'Filtrer par cette sous-catégorie',
	'sd_browsedata_otherfilter' => 'Voir les pages avec une autre valeur pour ce filtre',
	'sd_browsedata_nonefilter' => 'Voir les pages avec aucune valeur pour ce filtre',
	'sd_browsedata_or' => 'ou',
	'sd_browsedata_removefilter' => 'Retirer ce filtre',
	'sd_browsedata_removesubcategoryfilter' => 'Retirer cette sous-catégorie de filtre',
	'sd_browsedata_resetfilters' => 'Remise à zéro des filtres',
	'sd_browsedata_addanothervalue' => 'Cliquez sur la flèche pour ajouter une autre valeur',
	'sd_browsedata_daterangestart' => 'Début :',
	'sd_browsedata_daterangeend' => 'Fin :',
	'sd_browsedata_novalues' => 'Il n’existe pas de valeur pour ce filtre',
	'filters' => 'Filtres',
	'sd_filters_docu' => 'Le filtre suivant existe sur {{SITENAME}} :',
	'createfilter' => 'Créer un filtre',
	'sd_createfilter_name' => 'Nom :',
	'sd_createfilter_property' => 'Propriété que ce filtre couvrira :',
	'sd_createfilter_usepropertyvalues' => 'Utiliser, pour ce filtre, toutes les valeurs de cette propriété',
	'sd_createfilter_usecategoryvalues' => 'Obtenir les valeurs pour ce filtre à partir de cette catégorie :',
	'sd_createfilter_usedatevalues' => 'Utilise des blocs de date pour ce filtre avec cette période temporelle :',
	'sd_createfilter_entervalues' => 'Entrez manuellement les valeurs pour ce filtre (les valeurs devront être séparées par des virgules - si une valeur contient une virgule, remplacez-la par « \\, ») :',
	'sd_createfilter_inputtype' => 'Type d’entrée pour ce filtre :',
	'sd_createfilter_listofvalues' => 'Liste des valeurs (défaut)',
	'sd_createfilter_requirefilter' => 'Exiger qu’un autre filtre soit sélectionné avant que celui-ci ne soit affiché :',
	'sd_createfilter_label' => 'Étiquette pour ce filtre (facultatif) :',
	'sd_blank_error' => 'ne peut être laissé en blanc',
	'sd-pageschemas-filter' => 'Filtre',
	'sd-pageschemas-values' => 'Valeurs',
	'sd_filter_coversproperty' => 'Ce filtre couvre la propriété $1.',
	'sd_filter_getsvaluesfromcategory' => 'Il obtient ses valeurs à partir de la catégorie $1.',
	'sd_filter_usestimeperiod' => 'Il utilise $1 comme durée de sa période',
	'sd_filter_year' => 'Année',
	'sd_filter_month' => 'Mois',
	'sd_filter_hasvalues' => 'Il a $1 comme valeur',
	'sd_filter_hasinputtype' => 'Il a le type d’entrée $1.',
	'sd_filter_combobox' => 'Boîte combo',
	'sd_filter_freetext' => 'texte',
	'sd_filter_daterange' => 'Gamme de date',
	'sd_filter_requiresfilter' => 'Il nécessite la présence du filtre $1.',
	'sd_filter_haslabel' => 'Étiqueté $1.',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'specialpages-group-sd_group' => 'Ègzèrcice de sèmantica',
	'browsedata' => 'Navegar les balyês',
	'sd_browsedata_choosecategory' => 'Chouèsir una catègorie',
	'sd_browsedata_viewcategory' => 'vêre la catègorie',
	'sd_browsedata_subcategory' => 'Sot-catègorie',
	'sd_browsedata_other' => 'Ôtro',
	'sd_browsedata_none' => 'Nion',
	'sd_browsedata_filterbyvalue' => 'Filtrar per ceta valor',
	'sd_browsedata_filterbysubcategory' => 'Filtrar per ceta sot-catègorie',
	'sd_browsedata_otherfilter' => 'Fâre vêre les pâges avouéc una ôtra valor por ceti filtro',
	'sd_browsedata_nonefilter' => 'Fâre vêre les pâges avouéc gins de valor por ceti filtro',
	'sd_browsedata_or' => 'ou ben',
	'sd_browsedata_removefilter' => 'Enlevar ceti filtro',
	'sd_browsedata_removesubcategoryfilter' => 'Enlevar ceti filtro de sot-catègorie',
	'sd_browsedata_resetfilters' => 'Tornar inicialisar los filtros',
	'sd_browsedata_daterangestart' => 'Comencement :',
	'sd_browsedata_daterangeend' => 'Fin :',
	'filters' => 'Filtros',
	'sd_filters_docu' => 'Cetos filtros ègzistont dessus {{SITENAME}} :',
	'createfilter' => 'Fâre un filtro',
	'sd_createfilter_name' => 'Nom :',
	'sd_createfilter_inputtype' => 'Tipo d’entrâ por ceti filtro :',
	'sd_createfilter_listofvalues' => 'Lista de les valors (per dèfôt)',
	'sd_createfilter_label' => 'Ètiquèta por ceti filtro (u chouèx) :',
	'sd_blank_error' => 'pôt pas étre vouedo',
	'sd-pageschemas-filter' => 'Filtro',
	'sd-pageschemas-values' => 'Valors',
	'sd_filter_coversproperty' => 'Ceti filtro côvre la propriètât $1.',
	'sd_filter_getsvaluesfromcategory' => 'Il at ses valors dês la catègorie $1.',
	'sd_filter_year' => 'An',
	'sd_filter_month' => 'Mês',
	'sd_filter_hasvalues' => 'Il at les valors $1.',
	'sd_filter_hasinputtype' => 'Il at lo tipo d’entrâ $1.',
	'sd_filter_combobox' => 'Bouèta combô',
	'sd_filter_freetext' => 'tèxto',
	'sd_filter_daterange' => 'plage de dâtes',
	'sd_filter_haslabel' => 'Il at l’ètiquèta $1.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'sd_browsedata_other' => 'Oare',
	'sd_browsedata_none' => 'Gjin',
	'filters' => 'Filters',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'semanticdrilldown-desc' => 'Unha interface para navegar a través de datos semánticos',
	'specialpages-group-sd_group' => 'Exercicio de semántica',
	'browsedata' => 'Datos do navegador',
	'sd_browsedata_choosecategory' => 'Elixir unha categoría',
	'sd_browsedata_viewcategory' => 'ver categoría',
	'sd_browsedata_docu' => 'Prema nun ou máis elementos dos de embaixo para estreitar os seus resultados.',
	'sd_browsedata_subcategory' => 'Subcategoría',
	'sd_browsedata_other' => 'Outro',
	'sd_browsedata_none' => 'Ningún',
	'sd_browsedata_filterbyvalue' => 'Filtrar por este valor',
	'sd_browsedata_filterbysubcategory' => 'Filtrar por esta subcategoría',
	'sd_browsedata_otherfilter' => 'Mostrar páxinas con outro valor para este filtro',
	'sd_browsedata_nonefilter' => 'Mostrar páxinas con ningún valor para este filtro',
	'sd_browsedata_or' => 'ou',
	'sd_browsedata_removefilter' => 'Eliminar este filtro',
	'sd_browsedata_removesubcategoryfilter' => 'Eliminar este filtro de subcategorías',
	'sd_browsedata_resetfilters' => 'Eliminar filtros',
	'sd_browsedata_addanothervalue' => 'Prema na frecha para engadir outro valor',
	'sd_browsedata_daterangestart' => 'Comezo:',
	'sd_browsedata_daterangeend' => 'Fin:',
	'sd_browsedata_novalues' => 'Non hai valores para este filtro',
	'filters' => 'Filtros',
	'sd_filters_docu' => 'Os seguintes filtros existen en {{SITENAME}}:',
	'createfilter' => 'Crear un filtro',
	'sd_createfilter_name' => 'Nome:',
	'sd_createfilter_property' => 'Propiedade que o filtro inclúe:',
	'sd_createfilter_usepropertyvalues' => 'Usar todos os valores da propiedade para o filtro',
	'sd_createfilter_usecategoryvalues' => 'Obter os valores para o filtro desta categoría:',
	'sd_createfilter_usedatevalues' => 'Use rangos de data para este filtro con este período de tempo:',
	'sd_createfilter_entervalues' => 'Introduza valores para filtrar manualmente (os valores deben separarse por comas - se o valor contén unha coma, substitúaa por "\\,"):',
	'sd_createfilter_inputtype' => 'Tipo de entrada para este filtro:',
	'sd_createfilter_listofvalues' => 'lista de valores (por defecto)',
	'sd_createfilter_requirefilter' => 'Requírese que sexa seleccionado outro filtro antes de que este sexa amosado:',
	'sd_createfilter_label' => 'Lapela para este filtro (opcional):',
	'sd_blank_error' => 'non pode estar en branco',
	'sd-pageschemas-filter' => 'Filtro',
	'sd-pageschemas-values' => 'Valores',
	'sd_filter_coversproperty' => 'O filtro inclúe a propiedade $1.',
	'sd_filter_getsvaluesfromcategory' => 'Obtén os seus valores da categoría $1.',
	'sd_filter_usestimeperiod' => 'Usa $1 como o seu período de tempo.',
	'sd_filter_year' => 'Ano',
	'sd_filter_month' => 'Mes',
	'sd_filter_hasvalues' => 'Ten os valores $1.',
	'sd_filter_hasinputtype' => 'Ten o tipo de entrada $1.',
	'sd_filter_combobox' => 'Caixa combo',
	'sd_filter_freetext' => 'texto',
	'sd_filter_daterange' => 'gama de data',
	'sd_filter_requiresfilter' => 'Require a presenza do filtro $1.',
	'sd_filter_haslabel' => 'Ten a lapela $1.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'browsedata' => 'Δεδομένα πλοηγήσεως',
	'sd_browsedata_viewcategory' => 'ὁρᾶν κατηγορίαν',
	'sd_browsedata_subcategory' => 'Ὑποκατηγορία',
	'sd_browsedata_other' => 'Ἄλλον',
	'sd_browsedata_none' => 'Οὐδεμία',
	'sd_browsedata_or' => 'ἢ',
	'sd_browsedata_daterangestart' => 'Ἐκκινεῖν:',
	'sd_browsedata_daterangeend' => 'Τέλος:',
	'filters' => 'Διηθητήρια',
	'createfilter' => 'Ποιεῖν διηθητήριον',
	'sd_createfilter_name' => 'Ὄνομα:',
	'sd_filter_year' => 'Ἔτος',
	'sd_filter_month' => 'Μήν',
	'sd_filter_freetext' => 'κείμενον',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'semanticdrilldown-desc' => 'E Drilldown-Benutzerschnittstell go dur semantischi Date z navigiere',
	'specialpages-group-sd_group' => 'Semantisch Drilldown',
	'browsedata' => 'Date aaluege',
	'sd_browsedata_choosecategory' => 'Kategorii uuswehle',
	'sd_browsedata_viewcategory' => 'Kategorii aaluege',
	'sd_browsedata_docu' => 'Druck uf ein oder meh Filter go s Ergebnis yyschränke.',
	'sd_browsedata_subcategory' => 'Unterkategorii',
	'sd_browsedata_other' => 'Anders',
	'sd_browsedata_none' => 'Keis',
	'sd_browsedata_filterbyvalue' => 'Iber dää Wärt filtere',
	'sd_browsedata_filterbysubcategory' => 'Filter fir die Subkategorii',
	'sd_browsedata_otherfilter' => 'Zeig Syte mit eme andere Wärt fir dää Filter',
	'sd_browsedata_nonefilter' => 'Zeig Syte mit keim Wärt fir dää Filter',
	'sd_browsedata_or' => 'oder',
	'sd_browsedata_removefilter' => 'Dää Filter lesche',
	'sd_browsedata_removesubcategoryfilter' => 'Dää Subkategorii-Filter lesche',
	'sd_browsedata_resetfilters' => 'Filter zruggsetze',
	'sd_browsedata_addanothervalue' => 'Druck uf dr Pfyyl go ne andere Wärt zuefiege',
	'sd_browsedata_daterangestart' => 'Aafang:',
	'sd_browsedata_daterangeend' => 'Änd:',
	'sd_browsedata_novalues' => 'S het kei Wärt fir dää Filter',
	'filters' => 'Filter',
	'sd_filters_docu' => 'Die Filter git s in däm Wiki:',
	'createfilter' => 'E Filter aalege',
	'sd_createfilter_name' => 'Name:',
	'sd_createfilter_property' => 'Eigeschaft vu däm Filter:',
	'sd_createfilter_usepropertyvalues' => 'Alli Wärt vu däre Eigeschaft fir dr Filter bruuche.',
	'sd_createfilter_usecategoryvalues' => 'D Wärt fir dr Filter vu däre Kategorii verwände:',
	'sd_createfilter_usedatevalues' => 'Dää Zytruum fir dää Filter bruuche:',
	'sd_createfilter_entervalues' => 'Bruuch die Wärt fir dr Filter (Wärt dur Komma trännt yygee - Wänn s in eme Wärt e Komma het, ersetze dur „\\,“):',
	'sd_createfilter_inputtype' => 'Yygabtyp vu däm Filter:',
	'sd_createfilter_listofvalues' => 'Lischt vu Wärt (Standard)',
	'sd_createfilter_requirefilter' => 'Voreb dää Filter aazeigt wird, muess dää ander Filter gsetzt syy:',
	'sd_createfilter_label' => 'Bezeichnig vu däm Filter (optional):',
	'sd_blank_error' => 'derf nit läär syy',
	'sd-pageschemas-filter' => 'Filter',
	'sd-pageschemas-values' => 'Wärt',
	'sd_filter_coversproperty' => 'Dää Filter betrifft d Eigenschaft $1.',
	'sd_filter_getsvaluesfromcategory' => 'Är chunnt syni Wärt us dr Kategorii $1 iber.',
	'sd_filter_usestimeperiod' => 'Är bruucht $1 as Zytaagab.',
	'sd_filter_year' => 'Johr',
	'sd_filter_month' => 'Monet',
	'sd_filter_hasvalues' => 'Är het dr Wärt $1.',
	'sd_filter_hasinputtype' => 'Är het dr Yygabetyp $1.',
	'sd_filter_combobox' => 'Combo-Chaschte',
	'sd_filter_freetext' => 'Täxt',
	'sd_filter_daterange' => 'Zytruum',
	'sd_filter_requiresfilter' => 'Är setzt dr Filter $1 vorus.',
	'sd_filter_haslabel' => 'Är het d Bezeichnig $1.',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 */
$messages['gu'] = array(
	'filters' => 'ચાળણી',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'sd_browsedata_viewcategory' => 'jeeagh er ronney',
	'sd_browsedata_other' => 'Elley',
	'sd_createfilter_name' => 'Ennym:',
	'sd_filter_year' => 'Blein',
	'sd_filter_month' => 'Mee',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'sd_createfilter_name' => 'Inoa:',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'semanticdrilldown-desc' => 'ממשק מעבר מהיר לניווט במידע סמנטי',
	'specialpages-group-sd_group' => 'מעבר מהיר במידע סמנטי',
	'browsedata' => 'עיון בנתונים',
	'sd_browsedata_choosecategory' => 'בחירת קטגוריה',
	'sd_browsedata_viewcategory' => 'צפייה בקטגוריה',
	'sd_browsedata_docu' => 'לחצו על פריט אחד או יותר להלן כדי לצמצם את התוצאות.',
	'sd_browsedata_subcategory' => 'קטגוריית משנה',
	'sd_browsedata_other' => 'אחר',
	'sd_browsedata_none' => 'ללא',
	'sd_browsedata_filterbyvalue' => 'סינון לפי ערך זה',
	'sd_browsedata_filterbysubcategory' => 'סינון לפי קטגוריית משנה זו',
	'sd_browsedata_otherfilter' => 'הצגת דפים עם ערך אחר עבור מסנן זה',
	'sd_browsedata_nonefilter' => 'הצגת דפים ללא ערך עבור מסנן זה',
	'sd_browsedata_or' => 'או',
	'sd_browsedata_removefilter' => 'הסרת מסנן זה',
	'sd_browsedata_removesubcategoryfilter' => 'הסרת המסנן של קטגוריית משנה זו',
	'sd_browsedata_resetfilters' => 'איפוס המסננים',
	'sd_browsedata_addanothervalue' => 'יש ללחוץ על החץ כדי להוסיף ערך נוסף',
	'sd_browsedata_daterangestart' => 'התחלה:',
	'sd_browsedata_daterangeend' => 'סיום:',
	'sd_browsedata_novalues' => 'אין ערכים עבור מסנן זה',
	'filters' => 'מסננים',
	'sd_filters_docu' => 'המסננים הבאים קיימים ב{{grammar:תחילית|{{SITENAME}}}}:',
	'createfilter' => 'יצירת מסנן',
	'sd_createfilter_name' => 'שם:',
	'sd_createfilter_property' => 'המאפיין אותו מכסה מסנן זה:',
	'sd_createfilter_usepropertyvalues' => 'שימוש בכל הערכים של מאפיין זה עבור המסנן',
	'sd_createfilter_usecategoryvalues' => 'קבלת הערכים עבור המסנן מקטגוריה זו:',
	'sd_createfilter_usedatevalues' => 'שימוש בטווחי תאריכים עבור מסנן זה, עם משך הזמן הבא:',
	'sd_createfilter_entervalues' => 'כתבו ערכים ידנית עבור המסנן (הערכים אמורים להיות מופרדים בפסיקים - אם ערך מכיל פסיק, החליפו אותו ב־"\\,"):',
	'sd_createfilter_inputtype' => 'סוג הקלט עבור מסנן זה:',
	'sd_createfilter_listofvalues' => 'רשימת הערכים (ברירת מחדל)',
	'sd_createfilter_requirefilter' => 'הצבת דרישה לבחירת מסנן אחר לפני שזה יוצג:',
	'sd_createfilter_label' => 'תווית עבור מסנן זה (אופציונלי):',
	'sd_blank_error' => 'לא ניתן להשאיר ריק',
	'sd_filter_coversproperty' => 'מסנן זה מכסה את המאפיין $1.',
	'sd_filter_getsvaluesfromcategory' => 'קבלת הערכים עבורו נעשית מהקטגוריה $1.',
	'sd_filter_usestimeperiod' => 'נעשה שימוש ב־$1 כמשך הזמן שלו.',
	'sd_filter_year' => 'שנה',
	'sd_filter_month' => 'חודש',
	'sd_filter_hasvalues' => 'הוא מכיל את הערכים $1.',
	'sd_filter_hasinputtype' => 'הוא מכיל את סוג הקלט $1.',
	'sd_filter_combobox' => 'תיבה משולבת',
	'sd_filter_freetext' => 'טקסט',
	'sd_filter_daterange' => 'טווח תאריכים',
	'sd_filter_requiresfilter' => 'נדרשת עבורו נוכחות של המסנן $1.',
	'sd_filter_haslabel' => 'חלה עליו התווית $1.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'browsedata' => 'डाटा देखें',
	'sd_browsedata_choosecategory' => 'एक श्रेणी चुनें',
	'sd_browsedata_viewcategory' => 'श्रेणी देखें',
	'sd_browsedata_subcategory' => 'उपश्रेणी',
	'sd_browsedata_other' => 'अन्य',
	'sd_browsedata_none' => 'बिल्कुल नहीं',
	'sd_browsedata_filterbyvalue' => 'इस वैल्यू के अनुसार फ़िल्टर करें',
	'sd_browsedata_filterbysubcategory' => 'इस उपश्रेणी के अनुसार फ़िल्टर करें',
	'sd_browsedata_removefilter' => 'यह फ़िल्टर हटायें',
	'sd_browsedata_removesubcategoryfilter' => 'यह उपश्रेणी फ़िल्टर हटायें',
	'sd_browsedata_resetfilters' => 'फ़िल्टर रिसैट करें',
	'filters' => 'फ़िल्टर्स',
	'createfilter' => 'फ़िल्टर बनायें',
	'sd_createfilter_name' => 'नाम:',
	'sd_createfilter_property' => 'यह फ़िल्टर कौनसे गुणधर्मका इस्तेमाल करता हैं:',
	'sd_createfilter_usepropertyvalues' => 'इस फ़िल्टरके लिये इस गुणधर्मकी सभी वैल्यूओंका इस्तेमाल करें',
	'sd_createfilter_usecategoryvalues' => 'इस फ़िल्टरके लिये इस श्रेणी से वैल्यू लें:',
	'sd_createfilter_label' => 'इस फ़िल्टरका लेबल (वैकल्पिक):',
	'sd_blank_error' => 'खाली नहीं हो सकता',
	'sd_filter_year' => 'साल',
	'sd_filter_month' => 'महिना',
	'sd_filter_hasvalues' => 'इसमें $1 यह वैल्यू हैं।',
	'sd_filter_haslabel' => 'इसको $1 यह लेबल हैं।',
);

/** Croatian (Hrvatski)
 * @author Ex13
 */
$messages['hr'] = array(
	'filters' => 'Filteri',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'semanticdrilldown-desc' => 'Interfejs Drilldown za nawigaciju znutřka semantiskich datow',
	'specialpages-group-sd_group' => 'Semantiska nawigacija',
	'browsedata' => 'Daty přepytać',
	'sd_browsedata_choosecategory' => 'Wubjer kategoriju',
	'sd_browsedata_viewcategory' => 'Kategoriju wobhladać',
	'sd_browsedata_docu' => 'Klikń na jedyn zapisk abo na wjacore zapiski, zo by wuslědki zamjezował.',
	'sd_browsedata_subcategory' => 'Podkategorija',
	'sd_browsedata_other' => 'Druhe',
	'sd_browsedata_none' => 'Žane',
	'sd_browsedata_filterbyvalue' => 'Po tutej hódnoće filtrować',
	'sd_browsedata_filterbysubcategory' => 'Po tutej podkategoriji filtorwać',
	'sd_browsedata_otherfilter' => 'Strony z druhej hódnotu za tutón filter pokazać',
	'sd_browsedata_nonefilter' => 'Strony bjez hódnoty za tutón filter pokazać',
	'sd_browsedata_or' => 'abo',
	'sd_browsedata_removefilter' => 'Tutón filter wotstronić',
	'sd_browsedata_removesubcategoryfilter' => 'Tutón podkategorijny filter wotstronić',
	'sd_browsedata_resetfilters' => 'Filtry wróćo stajić',
	'sd_browsedata_addanothervalue' => 'Na šipk kliknyć, zo by so druha hódnota přidała',
	'sd_browsedata_daterangestart' => 'Spočatk:',
	'sd_browsedata_daterangeend' => 'Kónc:',
	'sd_browsedata_novalues' => 'Za tutón filter hódnoty njejsu',
	'filters' => 'Filtry',
	'sd_filters_docu' => 'Slědowace filtry we {{GRAMMAR:Lokatiw|{{SITENAME}}}} eksistuja:',
	'createfilter' => 'Wutwor filter',
	'sd_createfilter_name' => 'Mjeno:',
	'sd_createfilter_property' => 'Kajkosć tutho filtra:',
	'sd_createfilter_usepropertyvalues' => 'Wužij wšě hódnoty tuteje kajkosće za filter',
	'sd_createfilter_usecategoryvalues' => 'Wobstaraj hódnoty za filter z tuteje kategorije:',
	'sd_createfilter_usedatevalues' => 'Wužij datumowe wotrězk za tutón filter z tutej dobu:',
	'sd_createfilter_entervalues' => 'Zapodaj hódnoty za filter manuelnje (hódnoty měli so z komami rozdźělić  - jeli hódnota komu wobsahuje, narunaj ju přez "\\", "):',
	'sd_createfilter_inputtype' => 'Typ zapodaća za tutón filter:',
	'sd_createfilter_listofvalues' => 'lisćina hódnotow (standard)',
	'sd_createfilter_requirefilter' => 'Zo by tutón filter zwobrazniło, je druhi filter trjeba:',
	'sd_createfilter_label' => 'Mjeno tutoho filtra (opcionalny):',
	'sd_blank_error' => 'njesmě prózdny być',
	'sd-pageschemas-filter' => 'Filter',
	'sd-pageschemas-values' => 'Hódnoty',
	'sd_filter_coversproperty' => 'Tutón filter wobsahuje kajkosć $1.',
	'sd_filter_getsvaluesfromcategory' => 'Wobsahuje swoje hódnoty z kategorije $1.',
	'sd_filter_usestimeperiod' => 'Wužiwa $1 jako dobu.',
	'sd_filter_year' => 'Lěto',
	'sd_filter_month' => 'Měsac',
	'sd_filter_hasvalues' => 'Ma hódnoty $1.',
	'sd_filter_hasinputtype' => 'Ma typ zapodaća $1.',
	'sd_filter_combobox' => 'kombinaciski kašćik',
	'sd_filter_freetext' => 'tekst',
	'sd_filter_daterange' => 'rozsah datow',
	'sd_filter_requiresfilter' => 'Trjeba filter $1.',
	'sd_filter_haslabel' => 'Ma mjeno $1.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'semanticdrilldown-desc' => 'Adatlefúró felület a szemantikus adatokban való navigációhoz',
	'specialpages-group-sd_group' => 'Szemantikus adatlefúrás',
	'browsedata' => 'Adatok böngészése',
	'sd_browsedata_choosecategory' => 'Válassz egy kategóriát',
	'sd_browsedata_viewcategory' => 'kategória megtekintése',
	'sd_browsedata_docu' => 'Kattints egy vagy több elemre alább, hogy pontosítsd az eredményeket.',
	'sd_browsedata_subcategory' => 'Alkategória',
	'sd_browsedata_other' => 'Egyéb',
	'sd_browsedata_none' => 'Nincs',
	'sd_browsedata_filterbyvalue' => 'Szűrés ezen érték alapján',
	'sd_browsedata_filterbysubcategory' => 'Szűrés ezen alkategória alapján',
	'sd_browsedata_otherfilter' => 'Olyan lapok megjelenítése, melyeken ennek a szűrőnek más az értéke',
	'sd_browsedata_nonefilter' => 'Olyan lapok megjelenítése, melyeken ennek a szűrőnek nincs értéke',
	'sd_browsedata_or' => 'vagy',
	'sd_browsedata_removefilter' => 'Szűrő eltávolítása',
	'sd_browsedata_removesubcategoryfilter' => 'Alkategória szűrő törlése',
	'sd_browsedata_resetfilters' => 'Szűrő alaphelyzetbe állítása',
	'sd_browsedata_addanothervalue' => 'Kattints a nyílra másik érték hozzáadásához',
	'sd_browsedata_daterangestart' => 'Kezdődátum:',
	'sd_browsedata_daterangeend' => 'Végdátum:',
	'sd_browsedata_novalues' => 'Nincsenek ehhez a szűrőhöz tartozó értékek',
	'filters' => 'Szűrők',
	'sd_filters_docu' => 'A következő szűrők vannak a(z) {{SITENAME}} wikin:',
	'createfilter' => 'Szűrő létrehozása',
	'sd_createfilter_name' => 'Név:',
	'sd_createfilter_property' => 'Tulajdonság, amit ez a szűrő lefed:',
	'sd_createfilter_usepropertyvalues' => 'A tulajdonság összes értékének használata ennél a szűrőnél',
	'sd_createfilter_usecategoryvalues' => 'A szűrő értékeinek felvétele ebből a kategóriából:',
	'sd_createfilter_usedatevalues' => 'A szűrő a következő időtartamból vegye fel az értékeit:',
	'sd_createfilter_entervalues' => 'Add meg a szűrő értékeit kézzel (az értékeket vesszővel válaszd el; ha az érték vesszőt tartalmaz, akkor használd a „\\,” formát):',
	'sd_createfilter_inputtype' => 'Bevitel típusa ehhez a szűrőhöz:',
	'sd_createfilter_listofvalues' => 'értékek listája (alapértelmezett)',
	'sd_createfilter_requirefilter' => 'Egy másik szűrő legyen kiválasztva, mielőtt ez megjelenik:',
	'sd_createfilter_label' => 'Szűrő címkéje (nem kötelező):',
	'sd_blank_error' => 'nem lehet üres',
	'sd_filter_coversproperty' => 'Ez a szűrő lefedi a(z) $1 tulajdonságot.',
	'sd_filter_getsvaluesfromcategory' => 'Értékeit a következő kategóriából kapja: $1.',
	'sd_filter_usestimeperiod' => 'A(z) $1 adatot használja időintervallumként.',
	'sd_filter_year' => 'Év',
	'sd_filter_month' => 'Hónap',
	'sd_filter_hasvalues' => 'Az értékei: $1.',
	'sd_filter_hasinputtype' => 'A bemenet típusa: $1.',
	'sd_filter_combobox' => 'legördülő menü',
	'sd_filter_freetext' => 'szöveg',
	'sd_filter_daterange' => 'dátumtartomány',
	'sd_filter_requiresfilter' => 'Szükséges a(z) $1 szűrő megléte.',
	'sd_filter_haslabel' => 'A címkéje $1.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'semanticdrilldown-desc' => 'Un interfacie de exercitio pro navigar per datos semantic',
	'specialpages-group-sd_group' => 'Exercitio de semantica',
	'browsedata' => 'Percurrer datos',
	'sd_browsedata_choosecategory' => 'Selige un categoria',
	'sd_browsedata_viewcategory' => 'vider categoria',
	'sd_browsedata_docu' => 'Clicca super un o plus entratas in basso pro restringer tu resultatos.',
	'sd_browsedata_subcategory' => 'Subcategoria',
	'sd_browsedata_other' => 'Altere',
	'sd_browsedata_none' => 'Nulle',
	'sd_browsedata_filterbyvalue' => 'Filtrar per iste valor',
	'sd_browsedata_filterbysubcategory' => 'Filtrar per iste subcategoria',
	'sd_browsedata_otherfilter' => 'Monstrar paginas con un altere valor pro iste filtro',
	'sd_browsedata_nonefilter' => 'Monstrar paginas sin valor pro iste filtro',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Remover iste filtro',
	'sd_browsedata_removesubcategoryfilter' => 'Remover iste filtro de subcategoria',
	'sd_browsedata_resetfilters' => 'Reinitialisar filtros',
	'sd_browsedata_addanothervalue' => 'Clicca super le sagitta pro adder ancora un valor',
	'sd_browsedata_daterangestart' => 'Initio:',
	'sd_browsedata_daterangeend' => 'Fin:',
	'sd_browsedata_novalues' => 'Il non ha valores pro iste filtro',
	'filters' => 'Filtros',
	'sd_filters_docu' => 'Le sequente filtros existe in {{SITENAME}}:',
	'createfilter' => 'Crear un filtro',
	'sd_createfilter_name' => 'Nomine:',
	'sd_createfilter_property' => 'Le proprietate que iste filtro coperi:',
	'sd_createfilter_usepropertyvalues' => 'Usar tote le valores de iste proprietate pro le filtro',
	'sd_createfilter_usecategoryvalues' => 'Obtener valores pro filtro ab iste categoria:',
	'sd_createfilter_usedatevalues' => 'Usar intervallos de datas pro iste filtro con iste periodo de tempore:',
	'sd_createfilter_entervalues' => 'Entra valores pro le filtro manualmente (le valores debe esser separate per commas - si un valor contine un comma, reimplacia lo con "\\,"):',
	'sd_createfilter_inputtype' => 'Typo de input pro iste filtro:',
	'sd_createfilter_listofvalues' => 'lista de valores (predefinite)',
	'sd_createfilter_requirefilter' => 'Requirer que un altere filtro sia seligite ante que iste es monstrate:',
	'sd_createfilter_label' => 'Etiquetta pro iste filtro (optional):',
	'sd_blank_error' => 'non pote esser vacue',
	'sd-pageschemas-filter' => 'Filtro',
	'sd-pageschemas-values' => 'Valores',
	'sd_filter_coversproperty' => 'Iste filtro coperi le proprietate $1.',
	'sd_filter_getsvaluesfromcategory' => 'Illo obtene su valores ab le categoria $1.',
	'sd_filter_usestimeperiod' => 'Illo usa $1 como su periodo de tempore.',
	'sd_filter_year' => 'Anno',
	'sd_filter_month' => 'Mense',
	'sd_filter_hasvalues' => 'Illo ha le valores $1.',
	'sd_filter_hasinputtype' => 'Illo ha le typo de input $1.',
	'sd_filter_combobox' => 'quadro combinator',
	'sd_filter_freetext' => 'texto',
	'sd_filter_daterange' => 'gamma de datas',
	'sd_filter_requiresfilter' => 'Illo require le presentia del filtro $1.',
	'sd_filter_haslabel' => 'Illo ha le etiquetta $1.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'semanticdrilldown-desc' => 'Suatu antarmuka penelusuran untuk menyelami data semantik',
	'specialpages-group-sd_group' => 'Penelusuran Semantik',
	'browsedata' => 'Jelajahi data',
	'sd_browsedata_choosecategory' => 'Pilih kategori',
	'sd_browsedata_viewcategory' => 'lihat kategori',
	'sd_browsedata_docu' => 'Klik satu atau lebih butir di bawah untuk mempersempit hasil pencarian.',
	'sd_browsedata_subcategory' => 'Subkategori',
	'sd_browsedata_other' => 'Lain-lain',
	'sd_browsedata_none' => 'Tidak ada',
	'sd_browsedata_filterbyvalue' => 'Filter menurut nilai ini',
	'sd_browsedata_filterbysubcategory' => 'Filter menurut subkategori ini',
	'sd_browsedata_otherfilter' => 'Tampilkan halaman dengan nilai lain dari filter ini',
	'sd_browsedata_nonefilter' => 'Tampilkan halaman tanpa nilai dari filter ini',
	'sd_browsedata_or' => 'atau',
	'sd_browsedata_removefilter' => 'Hilangkan filter',
	'sd_browsedata_removesubcategoryfilter' => 'Hilangkan filter subkategori ini',
	'sd_browsedata_resetfilters' => 'Atur ulang filter',
	'sd_browsedata_addanothervalue' => 'Klik tanda panah untuk menambahkan nilai lain',
	'sd_browsedata_daterangestart' => 'Awal:',
	'sd_browsedata_daterangeend' => 'Akhir:',
	'sd_browsedata_novalues' => 'Tidak ada nilai untuk filter ini',
	'filters' => 'Penyaring',
	'sd_filters_docu' => 'Filter berikut ada di {{SITENAME}}:',
	'createfilter' => 'Buat filter',
	'sd_createfilter_name' => 'Nama:',
	'sd_createfilter_property' => 'Properti yang dicakup filter ini:',
	'sd_createfilter_usepropertyvalues' => 'Gunakan semua nilai dari properti ini untuk filter',
	'sd_createfilter_usecategoryvalues' => 'Dapatkan nilai untuk filter dari kategori ini:',
	'sd_createfilter_usedatevalues' => 'Gunakan rentang tanggal untuk filter dengan periode ini:',
	'sd_createfilter_entervalues' => 'Masukkan nilai filter secara manual (nilai harus dipisahkan oleh koma - jika suatu nilai mengandung koma, ganti dengan "\\,"):',
	'sd_createfilter_inputtype' => 'Tipe masukan untuk filter ini:',
	'sd_createfilter_listofvalues' => 'daftar nilai (baku)',
	'sd_createfilter_requirefilter' => 'Perlu memilih filter lain sebelum yang satu ini ditampilkan:',
	'sd_createfilter_label' => 'Label untuk filter ini (opsional):',
	'sd_blank_error' => 'tidak boleh kosong',
	'sd_filter_coversproperty' => 'Filter ini mencakup properti $1.',
	'sd_filter_getsvaluesfromcategory' => 'Ia mendapat nilainya dari kategori $1.',
	'sd_filter_usestimeperiod' => 'Ia menggunakan $1 sebagai periode waktunya.',
	'sd_filter_year' => 'Tahun',
	'sd_filter_month' => 'Bulan',
	'sd_filter_hasvalues' => 'Ia memiliki nilai $1.',
	'sd_filter_hasinputtype' => 'Ia memiliki tipe masukan $1.',
	'sd_filter_combobox' => 'kotak pilihan',
	'sd_filter_freetext' => 'teks',
	'sd_filter_daterange' => 'rentang tanggal',
	'sd_filter_requiresfilter' => 'Ia memerlukan keberadaan filter $1.',
	'sd_filter_haslabel' => 'Ia memiliki label $1.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'sd_browsedata_other' => 'Nke ozor',
	'sd_browsedata_or' => 'ma',
	'sd_createfilter_name' => 'Áhà:',
	'sd_filter_year' => 'Afọ',
	'sd_filter_month' => 'Önwa',
	'sd_filter_freetext' => 'mpkurụ edemede',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'filters' => 'Síur',
	'sd_createfilter_name' => 'Nafn:',
);

/** Italian (Italiano)
 * @author Civvì
 * @author Darth Kule
 * @author Gianfranco
 */
$messages['it'] = array(
	'semanticdrilldown-desc' => "Un'interfaccia drilldown per navigare attraverso dati semantici",
	'specialpages-group-sd_group' => 'Drilldown semantico',
	'browsedata' => 'Esplora i dati',
	'sd_browsedata_choosecategory' => 'Scegli una categoria',
	'sd_browsedata_viewcategory' => 'vedi categoria',
	'sd_browsedata_docu' => 'Clicca su uno o più fra gli elementi sottostanti per restringere i tuoi risultati.',
	'sd_browsedata_subcategory' => 'Sottocategoria',
	'sd_browsedata_other' => 'Altro',
	'sd_browsedata_none' => 'Nessuno',
	'sd_browsedata_filterbyvalue' => 'Filtra per questo valore',
	'sd_browsedata_filterbysubcategory' => 'Filtra per questa sottocategoria',
	'sd_browsedata_otherfilter' => 'Mostra pagine con un altro valore per questo filtro',
	'sd_browsedata_nonefilter' => 'Mostra pagine senza valori per questo filtro',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Rimuovi questo filtro',
	'sd_browsedata_removesubcategoryfilter' => 'Rimuovi questo filtro per sottocategoria',
	'sd_browsedata_resetfilters' => 'Azzera filtri',
	'sd_browsedata_addanothervalue' => 'Clicca la freccia per aggiungere un altro valore',
	'sd_browsedata_daterangestart' => 'Parti da:',
	'sd_browsedata_daterangeend' => 'Fino a:',
	'sd_browsedata_novalues' => 'Non ci sono valori per questo filtro',
	'filters' => 'Filtri',
	'sd_filters_docu' => 'In {{SITENAME}} ci sono i seguenti filtri:',
	'createfilter' => 'Crea un filtro',
	'sd_createfilter_name' => 'Nome:',
	'sd_createfilter_property' => 'Proprietà interessate da questo filtro:',
	'sd_createfilter_usepropertyvalues' => 'Usa tutti i valori di questa proprietà per il filtro',
	'sd_createfilter_usecategoryvalues' => 'Ottieni i valori per il filtro da questa categoria:',
	'sd_createfilter_usedatevalues' => 'Usa intervalli di date per questo filtro con questo periodo di tempo:',
	'sd_createfilter_entervalues' => 'Immetti manualmente i valori per il filtro (i valori dovrebbero essere separati da virgole - se un valore contiene una virgola, sostituisci la virgola stessa con "\\,"):',
	'sd_createfilter_inputtype' => 'Tipo di dato da immettere per questo filtro:',
	'sd_createfilter_listofvalues' => 'lista di valori (predefinita)',
	'sd_createfilter_requirefilter' => 'Richiedi la selezione di un altro filtro prima che questo sia visualizzato:',
	'sd_createfilter_label' => 'Etichetta per questo filtro (facoltativa):',
	'sd_blank_error' => 'non può essere vuoto',
	'sd_filter_coversproperty' => 'Questo filtro riguarda la proprietà $1.',
	'sd_filter_getsvaluesfromcategory' => 'Prende i suoi valori dalla categoria $1.',
	'sd_filter_usestimeperiod' => 'Usa $1 come suo intervallo di tempo.',
	'sd_filter_year' => 'Anno',
	'sd_filter_month' => 'Mese',
	'sd_filter_hasvalues' => 'Ha i valori $1.',
	'sd_filter_hasinputtype' => 'Ha il tipo di input $1.',
	'sd_filter_combobox' => 'combo box',
	'sd_filter_freetext' => 'testo',
	'sd_filter_daterange' => 'intervallo date',
	'sd_filter_requiresfilter' => 'Richiede la presenza del filtro $1.',
	'sd_filter_haslabel' => "Ha l'etichetta $1.",
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Whym
 */
$messages['ja'] = array(
	'semanticdrilldown-desc' => '意味的データを閲覧するための絞り込みインタフェース',
	'specialpages-group-sd_group' => 'セマンティック・ドリルダウン',
	'browsedata' => 'データ閲覧',
	'sd_browsedata_choosecategory' => 'カテゴリを選びます',
	'sd_browsedata_viewcategory' => 'カテゴリ表示',
	'sd_browsedata_docu' => '結果を絞り込むには、以下の項目を1つ以上クリックします。',
	'sd_browsedata_subcategory' => 'サブカテゴリ',
	'sd_browsedata_other' => 'その他',
	'sd_browsedata_none' => 'なし',
	'sd_browsedata_filterbyvalue' => 'この値で絞り込む',
	'sd_browsedata_filterbysubcategory' => 'このサブカテゴリで絞り込む',
	'sd_browsedata_otherfilter' => 'このフィルターの別の値をもつページを表示',
	'sd_browsedata_nonefilter' => 'このフィルターの値をもたないページを表示',
	'sd_browsedata_or' => 'または',
	'sd_browsedata_removefilter' => 'このフィルターを除去',
	'sd_browsedata_removesubcategoryfilter' => 'このサブカテゴリ条件を除去',
	'sd_browsedata_resetfilters' => 'フィルターをリセット',
	'sd_browsedata_addanothervalue' => '矢印をクリックして別の値を追加できます',
	'sd_browsedata_daterangestart' => '始まり:',
	'sd_browsedata_daterangeend' => '終わり:',
	'sd_browsedata_novalues' => 'このフィルターには値がありません',
	'filters' => 'フィルター一覧',
	'sd_filters_docu' => '{{SITENAME}} には次のフィルターが存在します:',
	'createfilter' => 'フィルター作成',
	'sd_createfilter_name' => '名前:',
	'sd_createfilter_property' => 'このフィルターが対象とするプロパティ:',
	'sd_createfilter_usepropertyvalues' => 'フィルターにこのプロパティのすべての値を用いる',
	'sd_createfilter_usecategoryvalues' => 'このカテゴリからフィルターの値を取得する:',
	'sd_createfilter_usedatevalues' => 'フィルターにこの単位の日付範囲を用いる:',
	'sd_createfilter_entervalues' => 'フィルターの値を手で入力する (各値はコンマで区切ります。値がコンマを含む場合は「\\,」で置換します):',
	'sd_createfilter_inputtype' => 'このフィルターの入力型:',
	'sd_createfilter_listofvalues' => '値の一覧 (デフォルト)',
	'sd_createfilter_requirefilter' => 'このフィルターが表示される前に、別のフィルターが選択されなければならないとする:',
	'sd_createfilter_label' => 'このフィルターのラベル (省略可能):',
	'sd_blank_error' => '空であってはならない',
	'sd_filter_coversproperty' => 'このフィルターはプロパティ $1 を対象とします。',
	'sd_filter_getsvaluesfromcategory' => '値をカテゴリ $1 から取得します。',
	'sd_filter_usestimeperiod' => '日付範囲の単位として$1を用いています。',
	'sd_filter_year' => '年',
	'sd_filter_month' => '月',
	'sd_filter_hasvalues' => '値 $1 をとります。',
	'sd_filter_hasinputtype' => '入力型 $1 をもちます。',
	'sd_filter_combobox' => 'コンボボックス',
	'sd_filter_freetext' => '文字列',
	'sd_filter_daterange' => '日付範囲',
	'sd_filter_requiresfilter' => 'フィルター $1 の存在を要求します。',
	'sd_filter_haslabel' => 'ラベル $1 をもちます。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'sd_browsedata_choosecategory' => 'Pilih kategori',
	'sd_browsedata_viewcategory' => 'ndeleng kategori',
	'sd_browsedata_subcategory' => 'Subkategori',
	'sd_browsedata_other' => 'Liyané',
	'sd_browsedata_none' => 'Ora ana',
	'sd_browsedata_or' => 'utawa',
	'sd_browsedata_removefilter' => 'Ilangana filter iki',
	'sd_browsedata_addanothervalue' => 'Tambahna biji liya',
	'filters' => 'Filter-filter',
	'createfilter' => 'Nggawé filter',
	'sd_createfilter_name' => 'Jeneng:',
	'sd_createfilter_property' => 'Sifat sing diliput filter iki:',
	'sd_createfilter_label' => 'Label kanggo filter (opsional):',
	'sd_blank_error' => 'ora bisa kosong',
	'sd_filter_year' => 'Taun',
	'sd_filter_month' => 'Sasi',
	'sd_filter_requiresfilter' => 'Merlokaké anané filter $1.',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'sd_createfilter_name' => 'სახელი:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'browsedata' => 'រាវរកទិន្នន័យ',
	'sd_browsedata_choosecategory' => 'ជ្រើសរើសចំណាត់ថ្នាក់ក្រុម',
	'sd_browsedata_viewcategory' => 'មើលចំណាត់ថ្នាក់ក្រុម',
	'sd_browsedata_subcategory' => 'ចំណាត់ក្រុមរង',
	'sd_browsedata_other' => 'ផ្សេងៗទៀត',
	'sd_browsedata_none' => 'ទទេ',
	'sd_browsedata_filterbyvalue' => 'តម្រង​តាមរយៈ​តម្លៃ​នេះ',
	'sd_browsedata_filterbysubcategory' => 'តម្រង​តាមរយៈ​ចំណាត់ថ្នាក់ក្រុម​នេះ',
	'sd_browsedata_otherfilter' => 'បង្ហាញ​ទំព័រ​ជាមួយ​តម្លៃ​ផ្សេង​សម្រាប់​តម្រង​នេះ',
	'sd_browsedata_nonefilter' => 'បង្ហាញ​ទំព័រ​ដោយ​គ្មាន​តម្លៃ​សម្រាប់​តម្រង​នេះ',
	'sd_browsedata_or' => 'ឬ',
	'sd_browsedata_removefilter' => 'ដក​តម្រង​នេះចេញ',
	'sd_browsedata_removesubcategoryfilter' => 'ដក​តម្រង​ចំណាត់ថ្នាក់ក្រុមរង​នេះ​ចេញ',
	'sd_browsedata_resetfilters' => 'កំណត់​តម្រង​ឡើងវិញ',
	'sd_browsedata_addanothervalue' => 'ចុចលើសញ្ញាព្រួញដើម្បីបន្ថែម​តម្លៃ​ផ្សេង',
	'sd_browsedata_daterangestart' => 'ចាប់ផ្ដើម:',
	'sd_browsedata_daterangeend' => 'បញ្ចប់:',
	'filters' => 'តម្រងការពារនានា',
	'sd_filters_docu' => 'តម្រង​ដូចតទៅនេះ​មាន​នៅក្នុង {{SITENAME}}:',
	'createfilter' => 'បង្កើត​តម្រង',
	'sd_createfilter_name' => 'ឈ្មោះ៖',
	'sd_createfilter_property' => 'លក្ខណៈសម្បត្តិ​ដែល​តម្រង​នេះ​គ្រប:',
	'sd_createfilter_usepropertyvalues' => 'តម្លៃ​ទាំងអស់​នៃលក្ខណៈសម្បត្តិ​នេះ​សម្រាប់​តម្រង',
	'sd_createfilter_usecategoryvalues' => 'ទទួល​តម្លៃ​សម្រាប់​តម្រង​ពី​ចំណាត់ថ្នាក់ក្រុម​នេះ:',
	'sd_createfilter_usedatevalues' => 'ប្រើប្រាស់​ជួរ​កាលបរិច្ឆេទ សម្រាប់​តម្រង​នេះ​ជាមួយ​កំលុងពេល​នេះ:',
	'sd_createfilter_entervalues' => 'បញ្ចូល​តម្លៃ​សម្រាប់​តម្រង​ដោយដៃ (តម្លៃ​គួរតែ​ត្រូវ​បាន​ខណ្ឌចែក​ដោយ​ចុល្លភាគ​នានា (commas)- ប្រសិនបើ​តម្លៃ​មាន​ចុល្លភាគ​មួយ ចូរ​ជំនួស​វា​ដោយ "\\,"):',
	'sd_createfilter_inputtype' => 'បញ្ចូល​គំរូ​សម្រាប់​តម្រង​នេះ:',
	'sd_createfilter_listofvalues' => 'បញ្ជី​នៃ​តម្លៃ (លំនាំដើម)',
	'sd_createfilter_requirefilter' => 'ទាមទារ​តម្រង​ផ្សេងទៀត​ដើម្បី​ធ្វើការ​ជ្រើសរើស មុនពេល​តម្រង​មួយនេះ​ត្រូវ​បាន​បង្ហាញ:',
	'sd_createfilter_label' => 'ស្លាក​សម្រាប់​តម្រង​នេះ (តាមបំណង):',
	'sd_blank_error' => 'មិន​អាច​ទទេ​បាន​ឡើយ',
	'sd_filter_coversproperty' => 'តម្រង​នេះ​គ្របដណ្ដប់​ចំណាត់ថ្នាក់ក្រុម $1 ។',
	'sd_filter_getsvaluesfromcategory' => 'វា​ទទួល​តម្លៃ​របស់​ខ្លួន​ពី​ចំណាត់ថ្នាក់ក្រុម $1 ។',
	'sd_filter_usestimeperiod' => 'វា​ប្រើប្រាស់ $1 ជា​កំលុងពេល​របស់​វា​។',
	'sd_filter_year' => 'ឆ្នាំ',
	'sd_filter_month' => 'ខែ',
	'sd_filter_hasvalues' => 'វា​មាន​តម្លៃ $1 ។',
	'sd_filter_freetext' => 'អក្សរ',
	'sd_filter_daterange' => 'ជួរ​កាលបរិច្ឆេទ',
	'sd_filter_requiresfilter' => 'វា​ទាមទារ​ឱ្យ​មាន​វត្តមាន​របស់​តម្រង $1 ។',
	'sd_filter_haslabel' => 'វា​មាន​ស្លាក $1 ។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'sd_browsedata_other' => 'ಇತರ',
	'sd_createfilter_name' => 'ಹೆಸರು:',
	'sd_filter_year' => 'ವರ್ಷ',
	'sd_filter_month' => 'ತಿಂಗಳು',
	'sd_filter_freetext' => 'ಪಠ್ಯ',
);

/** Korean (한국어)
 * @author Albamhandae
 */
$messages['ko'] = array(
	'filters' => '필터',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'semanticdrilldown-desc' => 'En Schnettshtell för der Metmaacher, öm sesh en einzel Schrette dorsch de semantische Date ze wöhle.',
	'specialpages-group-sd_group' => 'Semantsch Nohbohre',
	'browsedata' => 'En dä Date bläddere',
	'sd_browsedata_choosecategory' => 'Donn en Saachjrupp ußwähle',
	'sd_browsedata_viewcategory' => 'Saachjropp beloore',
	'sd_browsedata_docu' => 'Donn op eine, odder och ettlijje, fun dä Felltere unge klecke, öm dat wat erus kütt, jet kleiner ze maache.',
	'sd_browsedata_subcategory' => 'Ungerjrupp',
	'sd_browsedata_other' => 'Söns wat',
	'sd_browsedata_none' => 'Kei',
	'sd_browsedata_filterbyvalue' => 'Donn övver dä Wäät felltere',
	'sd_browsedata_filterbysubcategory' => 'Donn övver di Unger-Saachjropp felltere',
	'sd_browsedata_otherfilter' => 'Donn Sigge zeije met enem andere Wäät för hee dä Felter',
	'sd_browsedata_nonefilter' => 'Donn Sigge zeije oohne Wäät för hee dä Felter',
	'sd_browsedata_or' => 'udder',
	'sd_browsedata_removefilter' => 'Donn dä Felter hee fottschmiiße',
	'sd_browsedata_removesubcategoryfilter' => 'Donn dä Felter övver en Ungersaachjropp fott schmiiße',
	'sd_browsedata_resetfilters' => 'Donn de Feltere widder op Shtandat setze',
	'sd_browsedata_addanothervalue' => 'Donn op dä Piel klecke, öm noch ene Wäät dobei ze zälle',
	'sd_browsedata_daterangestart' => 'Aanfang:',
	'sd_browsedata_daterangeend' => 'Engk:',
	'sd_browsedata_novalues' => 'Et sin kein Wääte för dä Felter do',
	'filters' => 'Feltere',
	'sd_filters_docu' => 'Mer han hee di Feltere em Wiki;',
	'createfilter' => 'Ene Felter aanlääje',
	'sd_createfilter_name' => 'Name:',
	'sd_createfilter_property' => 'De Eijeschaff, die hee jefeltert weed:',
	'sd_createfilter_usepropertyvalues' => 'Donn all de Wääte us hee dä Eijeschaff för dä Felter bruche',
	'sd_createfilter_usecategoryvalues' => 'De müjjelesche Wääte för noh ze feltere kumme us dä Saachjrupp:',
	'sd_createfilter_usedatevalues' => 'Bruch ene Dattums-Berett för dö Felter mit däm Zick-Berett:',
	'sd_createfilter_entervalues' => 'Donn de Wääte för hee dä Felter vun Hand enjävve.
Donn emmer e Komma zwesche de einzel Wääte maache.
Wann e Komma en enem Wäät vörkütt, dann donn shtatt dämm Komma 
en däm Wäät <code>\\,</code> enjävve, domet et keine Dorjeneijn jitt.',
	'sd_createfilter_inputtype' => 'De Zoot Enjabe för hee dä Felter:',
	'sd_createfilter_listofvalues' => 'Leß met de Wääte (Shtandat)',
	'sd_createfilter_requirefilter' => 'Ih dat hee dä Felter aanjezeish weede kann, moß vörher ald ene andere Felter ußjesooht gewääse sin, un zwa dä:',
	'sd_createfilter_label' => 'Et Etikättsche för dä Felter (kam_mer fott lohße):',
	'sd_blank_error' => 'kann nit leddesch bliive',
	'sd-pageschemas-filter' => 'Fėlter',
	'sd-pageschemas-values' => 'Wääte',
	'sd_filter_coversproperty' => 'Dä Felter betref de Eijeschaff $1.',
	'sd_filter_getsvaluesfromcategory' => 'Hä kritt sing Wääte us de Saachjrupp $1.',
	'sd_filter_usestimeperiod' => 'Dä bruch $1 als sing Zick.',
	'sd_filter_year' => 'Johr',
	'sd_filter_month' => 'Mohnd',
	'sd_filter_hasvalues' => 'Dä hät dä Wäät $1.',
	'sd_filter_hasinputtype' => 'Dä kritt jet vun dä Zoot $1 enjejovve.',
	'sd_filter_combobox' => 'kombineete Kaste',
	'sd_filter_freetext' => 'Tex',
	'sd_filter_daterange' => 'Dattums-Berett',
	'sd_filter_requiresfilter' => 'Dä hät dä Felter $1 eets ens nüdesch.',
	'sd_filter_haslabel' => 'Däm sing Etikättsche es „$1“',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'semanticdrilldown-desc' => "En ''Drilldown''-Interface, fir duerch semantesch Daten ze navigéieren",
	'specialpages-group-sd_group' => "Semnateschen ''Drilldown''",
	'sd_browsedata_choosecategory' => 'Eng Kategorie wielen',
	'sd_browsedata_viewcategory' => 'Kategorie weisen',
	'sd_browsedata_docu' => 'Klickt op eent oder méi Elementer hei ënnendrënner fir Är Resultater anzegrenzen.',
	'sd_browsedata_subcategory' => 'Ënnerkategorie',
	'sd_browsedata_other' => 'Aner',
	'sd_browsedata_none' => 'Keen',
	'sd_browsedata_filterbyvalue' => 'Filter fir dëse Wäert',
	'sd_browsedata_filterbysubcategory' => 'No dëser Ënnerkategorie filteren',
	'sd_browsedata_otherfilter' => 'Säite weisen déi mat engem anere Wäert fir dëse Filter',
	'sd_browsedata_nonefilter' => 'Säite weisen déi kee Wäert fir dëse Filter hunn',
	'sd_browsedata_or' => 'oder',
	'sd_browsedata_removefilter' => 'Dëse filtr ewechhuelen',
	'sd_browsedata_removesubcategoryfilter' => 'Dëse Filter vun den Ënnerkategorien ewechhuelen',
	'sd_browsedata_resetfilters' => 'Filteren zrécksetzen',
	'sd_browsedata_addanothervalue' => 'Klickt op de Feil fir een anere Wäert derbäisetzen',
	'sd_browsedata_daterangestart' => 'Ufank:',
	'sd_browsedata_daterangeend' => 'Enn:',
	'sd_browsedata_novalues' => 'Et gëtt keng Wäerter fir dëse Filter',
	'filters' => 'Filteren',
	'sd_filters_docu' => 'Dës Filtere gëtt et op {{SITENAME}}:',
	'createfilter' => 'E Filter uleeën',
	'sd_createfilter_name' => 'Numm:',
	'sd_createfilter_usepropertyvalues' => 'All Wäerter vun dëser Eegeschaft fir de Filter benotzen',
	'sd_createfilter_usecategoryvalues' => 'Werter fir dëse Filter vun dëser Kategorie kréien:',
	'sd_createfilter_inputtype' => 'Gitt den Typ vun dësem Filter un.',
	'sd_createfilter_listofvalues' => 'Lëscht vun de Wäerter (Standard)',
	'sd_createfilter_requirefilter' => 'Verlaangen dat en anere Filter gewielt gëtt ier dësen ugewise gëtt:',
	'sd_createfilter_label' => 'Etiquette fir dëse Filter (fakultativ):',
	'sd_blank_error' => 'däerf net eidel sinn',
	'sd_filter_coversproperty' => "Dëse Filter betrefft d'Eegeschaft $1.",
	'sd_filter_getsvaluesfromcategory' => 'E kritt seng Werter aus der Kategorie $1.',
	'sd_filter_usestimeperiod' => 'E benotzt $1 als Zäitraum',
	'sd_filter_year' => 'Joer',
	'sd_filter_month' => 'Mount',
	'sd_filter_hasvalues' => 'En huet de Wäert $1.',
	'sd_filter_combobox' => 'Combinéiert Këscht (combo box)',
	'sd_filter_freetext' => 'Text',
	'sd_filter_daterange' => 'Datumsberäich',
	'sd_filter_requiresfilter' => "E verlaangt d'Presenz vum Filter $1.",
	'sd_filter_haslabel' => "en huet d'Etiquette $1.",
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'filters' => 'Фильтр-влак',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'semanticdrilldown-desc' => 'Посредник за истенчена навигација по семантички податоци',
	'specialpages-group-sd_group' => 'Семантичко истенчување',
	'browsedata' => 'Прелистај податоци',
	'sd_browsedata_choosecategory' => 'Одберете категорија',
	'sd_browsedata_viewcategory' => 'види категорија',
	'sd_browsedata_docu' => 'Кликнете на еден или повеќе елементи подолу за да ги истенчите резултатите.',
	'sd_browsedata_subcategory' => 'Поткатегорија',
	'sd_browsedata_other' => 'Други',
	'sd_browsedata_none' => 'Нема',
	'sd_browsedata_filterbyvalue' => 'Филтрирај по оваа вредност',
	'sd_browsedata_filterbysubcategory' => 'Филтрирај по оваа категорија',
	'sd_browsedata_otherfilter' => 'Прикажи страници со друга вредност за овој филтер',
	'sd_browsedata_nonefilter' => 'Прикажи страници без вредности за овој филтер',
	'sd_browsedata_or' => 'или',
	'sd_browsedata_removefilter' => 'Отстрани го филтерот',
	'sd_browsedata_removesubcategoryfilter' => 'Отстрани го овој филтер за поткатегории',
	'sd_browsedata_resetfilters' => 'Врати ги филтрите по основно',
	'sd_browsedata_addanothervalue' => 'Кликнете на стрелката за да додадете друга вредност',
	'sd_browsedata_daterangestart' => 'Почеток:',
	'sd_browsedata_daterangeend' => 'Крај:',
	'sd_browsedata_novalues' => 'Нема зададено вредности за овој филтер',
	'filters' => 'Филтри',
	'sd_filters_docu' => '{{SITENAME}} ги има следниве филтри:',
	'createfilter' => 'Создај филтер',
	'sd_createfilter_name' => 'Име:',
	'sd_createfilter_property' => 'Својство кое го покрива овој филтер:',
	'sd_createfilter_usepropertyvalues' => 'Користи ги сите вредности на ова својство за филтерот',
	'sd_createfilter_usecategoryvalues' => 'Преземи вредности за филтер од оваа категорија:',
	'sd_createfilter_usedatevalues' => 'Користи датумски опсези за овој филтер со овој временски период:',
	'sd_createfilter_entervalues' => 'Рачно внесете вредности за филтерот (вредностите треба да бидат одвоени со запирки - ако самата вредност содржи запирка, тогаш заменете ја со „\\,“):',
	'sd_createfilter_inputtype' => 'Тип на внос за овој филтер:',
	'sd_createfilter_listofvalues' => 'список на вредности (по основно)',
	'sd_createfilter_requirefilter' => 'Побарувај да биде избран друг филтер пред да се прикаже овој:',
	'sd_createfilter_label' => 'Наслов за овој филтер (незадолжително)',
	'sd_blank_error' => 'не може да стои празно',
	'sd-pageschemas-filter' => 'Филтер',
	'sd-pageschemas-values' => 'Вредности',
	'sd_filter_coversproperty' => 'Овој филтер го покрива својството $1.',
	'sd_filter_getsvaluesfromcategory' => 'Ги добива своите вредности од категоријата $1.',
	'sd_filter_usestimeperiod' => 'Користи $1 како временски период.',
	'sd_filter_year' => 'Година',
	'sd_filter_month' => 'Месец',
	'sd_filter_hasvalues' => 'Ги има вредностите $1.',
	'sd_filter_hasinputtype' => 'Има тип на внос $1.',
	'sd_filter_combobox' => 'расклопно мени',
	'sd_filter_freetext' => 'текст',
	'sd_filter_daterange' => 'датумски опсег',
	'sd_filter_requiresfilter' => 'Бара присуство на филтер $1.',
	'sd_filter_haslabel' => 'Има наслов $1.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'sd_browsedata_choosecategory' => 'ഒരു വർഗ്ഗം തിരഞ്ഞെടുക്കുക',
	'sd_browsedata_viewcategory' => 'വർഗ്ഗം കാണുക',
	'sd_browsedata_subcategory' => 'ഉപവർഗ്ഗം',
	'sd_browsedata_other' => 'മറ്റുള്ളവ',
	'sd_browsedata_none' => 'ഒന്നുമില്ല',
	'sd_browsedata_filterbyvalue' => 'ഈ മൂല്യം ഉപയോഗിച്ച് അരിക്കുക',
	'sd_browsedata_filterbysubcategory' => 'ഈ ഉപവർഗ്ഗം ഉപയോഗിച്ച് അരിക്കുക',
	'sd_browsedata_otherfilter' => 'ഈ ഫിൽറ്റർ ഉപയോഗിച്ച് മറ്റൊരു മൂല്യത്തിലുള്ള താളുകൾ കാണിക്കുക',
	'sd_browsedata_nonefilter' => 'മൂല്യമൊന്നും ചേർക്കാതെ ഈ ഫിൽറ്റർ ഉപയോഗിച്ച് താളുകൾ കാണിക്കുക',
	'sd_browsedata_or' => 'അല്ലെങ്കിൽ',
	'sd_browsedata_removefilter' => 'ഈ ഫിൽറ്റർ ഒഴിവാക്കുക',
	'sd_browsedata_removesubcategoryfilter' => 'ഈ ഉപവർഗ്ഗ ഫിൽറ്റർ ഒഴിവാക്കുക',
	'sd_browsedata_resetfilters' => 'അരിപ്പകൾ പുനഃക്രമീകരിക്കുക',
	'sd_browsedata_addanothervalue' => 'മറ്റൊരു മൂല്യം ചേർക്കുക',
	'filters' => 'അരിപ്പകൾ',
	'sd_filters_docu' => '{{SITENAME}} സം‌രംഭത്തിൽ താഴെ പ്രദർശിപ്പിച്ചിരിക്കുന്ന ഫിൽറ്ററുകൾ നിലവിലുണ്ട്:',
	'createfilter' => 'ഒരു ഫിൽറ്റർ സൃഷ്ടിക്കുക',
	'sd_createfilter_name' => 'പേര്‌:',
	'sd_blank_error' => 'ശൂന്യമാക്കിയിടുന്നത് അനുവദനീയമല്ല',
	'sd_filter_getsvaluesfromcategory' => '$1 എന്ന വർഗ്ഗത്തിൽ നിന്നാണ്‌ ഇതിനു മൂല്യങ്ങൾ കിട്ടുന്നത്.',
	'sd_filter_usestimeperiod' => 'ഇതു സമയ പരിധിയായി ഉപയോഗിക്കുന്നത് $1 ആണ്‌.',
	'sd_filter_year' => 'വർഷം',
	'sd_filter_month' => 'മാസം',
	'sd_filter_hasvalues' => 'ഇതിന്റെ മൂല്യങ്ങൾ $1 ആണ്‌.',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'sd_browsedata_other' => 'Бусад',
	'filters' => 'Шүүлтүүрүүд',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'browsedata' => 'डाटा न्याहाळा',
	'sd_browsedata_choosecategory' => 'एक वर्ग निवडा',
	'sd_browsedata_viewcategory' => 'वर्ग पहा',
	'sd_browsedata_subcategory' => 'उपवर्ग',
	'sd_browsedata_other' => 'इतर',
	'sd_browsedata_none' => '(काहीही नाही)',
	'sd_browsedata_filterbyvalue' => 'या किंमती प्रमाणे फिल्टर करा',
	'sd_browsedata_filterbysubcategory' => 'या उपवर्गा प्रमाणे फिल्टर करा',
	'sd_browsedata_otherfilter' => 'या फिल्टरच्या दुसर्‍या किंमतीसाठीची पाने दाखवा',
	'sd_browsedata_nonefilter' => 'या फिल्टरच्या शून्य किंमतीसाठीची पाने दाखवा',
	'sd_browsedata_or' => 'किंवा',
	'sd_browsedata_removefilter' => 'हा फिल्टर काढा',
	'sd_browsedata_removesubcategoryfilter' => 'हा उपवर्ग फिल्टर काढा',
	'sd_browsedata_resetfilters' => 'फिल्टर पूर्ववत करा',
	'sd_browsedata_addanothervalue' => 'दुसरी किंमत वाढवा',
	'filters' => 'फिल्टर्स',
	'sd_filters_docu' => '{{SITENAME}} वर खालील फिल्टर्स उपलब्ध आहेत:',
	'createfilter' => 'नवीन फिल्टर बनवा',
	'sd_createfilter_name' => 'नाव:',
	'sd_createfilter_property' => 'हा फिल्टर कुठल्या गुणधर्मासाठी वापरायचा आहे:',
	'sd_createfilter_usepropertyvalues' => 'या फिल्टरकरीता या गुणधर्माच्या सर्व किंमती वापरा',
	'sd_createfilter_usecategoryvalues' => 'या फिल्टरकरीता या वर्गातून किंमती मिळवा:',
	'sd_createfilter_usedatevalues' => 'या फिल्टरकरीता या कालावधीतील तारखा वापरा:',
	'sd_createfilter_entervalues' => 'फिल्टरसाठी स्वत: किंमती भरा (किंमती स्वल्पविराम "," वापरून लिहाव्या, जर एखाद्या किंमतीतच स्वल्पविराम येत असेल तर त्याजागी "\\," लिहा):',
	'sd_createfilter_requirefilter' => 'हा फिल्टर दर्शविण्याआधी जर दुसरा फिल्टर वापरायचा असेल तर त्याचे नाव:',
	'sd_createfilter_label' => 'या फिल्टरकरीत लेबल (वैकल्पिक):',
	'sd_blank_error' => 'रिकामे असू शकत नाही',
	'sd_filter_coversproperty' => 'हा फिल्टर $1 या गुणधर्मावर चालतो.',
	'sd_filter_getsvaluesfromcategory' => 'तो $1 या वर्गातून किंमती घेतो.',
	'sd_filter_usestimeperiod' => 'तो $1 कालावधी वापरतो.',
	'sd_filter_year' => 'वर्ष',
	'sd_filter_month' => 'महिना',
	'sd_filter_hasvalues' => 'त्यामध्ये $1 या किंमती आहेत.',
	'sd_filter_requiresfilter' => 'या साठी $1 हा फिल्टर असणे आवश्यक आहे.',
	'sd_filter_haslabel' => 'त्याला $1 हे लेबल आहे.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'sd_browsedata_none' => 'Tiada',
	'sd_browsedata_or' => 'atau',
	'sd_createfilter_name' => 'Nama:',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'sd_browsedata_subcategory' => 'Алкс категория',
	'sd_browsedata_other' => 'Лия',
	'sd_browsedata_or' => 'эли',
	'filters' => 'Сувтеметь',
	'createfilter' => 'Шкамс сувтеме',
	'sd_createfilter_name' => 'Лемезэ:',
	'sd_filter_year' => 'Иесь',
	'sd_filter_month' => 'Ковось',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'sd_browsedata_other' => 'Occē',
	'sd_browsedata_none' => 'Ahtlein',
	'sd_browsedata_or' => 'nozo',
	'sd_createfilter_name' => 'Tōcāitl:',
	'sd_filter_year' => 'Xihuitl',
	'sd_filter_month' => 'Mētztli',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'sd_createfilter_name' => 'Naam:',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'semanticdrilldown-desc' => 'Een drilldowninterface voor het navigeren door semantische gegevens',
	'specialpages-group-sd_group' => 'Semantic Drilldown',
	'browsedata' => 'Gegevens bekijken',
	'sd_browsedata_choosecategory' => 'Kies een categorie',
	'sd_browsedata_viewcategory' => 'categorie bekijken',
	'sd_browsedata_docu' => 'Selecteer een of meer van de onderstaande termen om het aantal resultaten te verkleinen.',
	'sd_browsedata_subcategory' => 'Ondercategorie',
	'sd_browsedata_other' => 'Andere',
	'sd_browsedata_none' => 'Geen',
	'sd_browsedata_filterbyvalue' => 'Op deze waarde filteren',
	'sd_browsedata_filterbysubcategory' => 'Op deze ondercategorie filteren',
	'sd_browsedata_otherfilter' => "Pagina's met een andere waarde voor deze filter bekijken",
	'sd_browsedata_nonefilter' => "Pagina's zonder waarde voor deze filter bekijken",
	'sd_browsedata_or' => 'of',
	'sd_browsedata_removefilter' => 'Deze filter verwijderen',
	'sd_browsedata_removesubcategoryfilter' => 'Deze ondercategoriefilter verwijderen',
	'sd_browsedata_resetfilters' => 'Filters opnieuw instellen',
	'sd_browsedata_addanothervalue' => 'Klik op de pijl om nog een waarde toe te voegen',
	'sd_browsedata_daterangestart' => 'Begin:',
	'sd_browsedata_daterangeend' => 'Einde:',
	'sd_browsedata_novalues' => 'Er zijn geen waarden voor dit filter',
	'filters' => 'Filters',
	'sd_filters_docu' => 'In {{SITENAME}} bestaan de volgende filters:',
	'createfilter' => 'Filter aanmaken',
	'sd_createfilter_name' => 'Naam:',
	'sd_createfilter_property' => 'Eigenschap voor deze filter:',
	'sd_createfilter_usepropertyvalues' => 'Alle waarden voor deze eigenschap voor deze filter gebruiken',
	'sd_createfilter_usecategoryvalues' => 'Waarden voor deze filter uit de volgende categorie halen:',
	'sd_createfilter_usedatevalues' => 'Gebruik voor deze filter de volgende datumreeks:',
	'sd_createfilter_entervalues' => 'Waarden voor de filter handmatig invoeren (waarden moeten gescheiden worden door komma\'s - als de waarde een komma bevast, vervang die dan door "\\,"):',
	'sd_createfilter_inputtype' => 'Invoertype voor deze filter:',
	'sd_createfilter_listofvalues' => 'lijst met waarden (standaard)',
	'sd_createfilter_requirefilter' => 'Selectie van een andere filter voor deze filter zichtbaar is vereisen:',
	'sd_createfilter_label' => 'Label voor deze filter (optioneel):',
	'sd_blank_error' => 'mag niet leeg blijven',
	'sd-pageschemas-filter' => 'Filter',
	'sd-pageschemas-values' => 'Waarden',
	'sd_filter_coversproperty' => 'Deze filter heeft betrekking op de eigenschap $1.',
	'sd_filter_getsvaluesfromcategory' => 'Het haalt de waarden van de categorie $1.',
	'sd_filter_usestimeperiod' => 'Het gebruikt $1 als de tijdsduur.',
	'sd_filter_year' => 'Jaar',
	'sd_filter_month' => 'Maand',
	'sd_filter_hasvalues' => 'Het heeft de waarden $1.',
	'sd_filter_hasinputtype' => 'Het heeft het invoertype $1.',
	'sd_filter_combobox' => 'keuzelijst',
	'sd_filter_freetext' => 'tekst',
	'sd_filter_daterange' => 'datumreeks',
	'sd_filter_requiresfilter' => 'De filter $1 moet aanwezig zijn.',
	'sd_filter_haslabel' => 'Het heeft het label $1.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'semanticdrilldown-desc' => 'Eit «drilldown»-brukargrensesnitt for navigering gjennom semantiske data',
	'specialpages-group-sd_group' => 'Semantisk «drilldown»',
	'browsedata' => 'Bla gjennom data',
	'sd_browsedata_choosecategory' => 'Vel ein kategori',
	'sd_browsedata_viewcategory' => 'sjå kategori',
	'sd_browsedata_docu' => 'Trykk på ein eller fleire einingar nedanfor for å avgrensa resultata.',
	'sd_browsedata_subcategory' => 'Underkategori',
	'sd_browsedata_other' => 'Annan',
	'sd_browsedata_none' => 'Ingen',
	'sd_browsedata_filterbyvalue' => 'Filtrer etter denne verdien',
	'sd_browsedata_filterbysubcategory' => 'Filtrer etter denne underkategorien',
	'sd_browsedata_otherfilter' => 'Syn sider med ein annan verdi for dette filteret',
	'sd_browsedata_nonefilter' => 'Syn sider med null verdi for dette fileteret',
	'sd_browsedata_or' => 'eller',
	'sd_browsedata_removefilter' => 'Fjern dette filteret',
	'sd_browsedata_removesubcategoryfilter' => 'Fjern dette underkategorifilteret',
	'sd_browsedata_resetfilters' => 'Nullstill filter',
	'sd_browsedata_addanothervalue' => 'Legg til ny verdi',
	'sd_browsedata_daterangestart' => 'Byrjing:',
	'sd_browsedata_daterangeend' => 'Slutt:',
	'filters' => 'Filter',
	'sd_filters_docu' => 'Følgjande filter finst på {{SITENAME}}:',
	'createfilter' => 'Opprett eit filter',
	'sd_createfilter_name' => 'Namn:',
	'sd_createfilter_property' => 'Eigenskap som dette fileteret dekkjer:',
	'sd_createfilter_usepropertyvalues' => 'Nytt alle verdiar av denne eigenskapen for filteret:',
	'sd_createfilter_usecategoryvalues' => 'Få verdiar for filteret frå denne kategorien:',
	'sd_createfilter_usedatevalues' => 'Nytt datoområde for dette filteret med denne tidsperioden:',
	'sd_createfilter_entervalues' => 'Skriv inn verdiar for filteret manuelt (verdiar burde vera skilde med komma, so om ein verdi inneheld eit komma, erstatt kommaet med «\\,»);',
	'sd_createfilter_inputtype' => 'Inndatatype for dette filteret:',
	'sd_createfilter_listofvalues' => 'lista over verdiar (standard)',
	'sd_createfilter_requirefilter' => 'Krev at eit anna filter blir valt før dette blir vist:',
	'sd_createfilter_label' => 'Merkelapp for dette filteret (valfritt):',
	'sd_blank_error' => 'kan ikkje vera tom',
	'sd_filter_coversproperty' => 'Dette filteret dekkjer eigenskapen $1.',
	'sd_filter_getsvaluesfromcategory' => 'Det får verdiane sine frå kategorien $1.',
	'sd_filter_usestimeperiod' => 'Det nyttar $1 som tidsperiode.',
	'sd_filter_year' => 'År',
	'sd_filter_month' => 'Månad',
	'sd_filter_hasvalues' => 'Det har verdiane $1.',
	'sd_filter_hasinputtype' => 'Det har inndatatypen $1.',
	'sd_filter_freetext' => 'tekst',
	'sd_filter_daterange' => 'datoområde',
	'sd_filter_requiresfilter' => 'Det krev at filteret $1 er til stades.',
	'sd_filter_haslabel' => 'Det har merkelappen $1.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'semanticdrilldown-desc' => 'Et «drilldown»-grensesnitt for navigering gjennom semantiske data',
	'specialpages-group-sd_group' => 'Semantisk «drilldown»',
	'browsedata' => 'Bla gjennom data',
	'sd_browsedata_choosecategory' => 'Velg en kategori',
	'sd_browsedata_viewcategory' => 'se kategori',
	'sd_browsedata_docu' => 'Klikk på en eller flere enheter nedenfor for å smalne inn søket.',
	'sd_browsedata_subcategory' => 'Underkategori',
	'sd_browsedata_other' => 'Annen',
	'sd_browsedata_none' => 'Ingen',
	'sd_browsedata_filterbyvalue' => 'Filtrer etter denne verdien',
	'sd_browsedata_filterbysubcategory' => 'Filtrer etter denne underkategorien',
	'sd_browsedata_otherfilter' => 'Vis sider med en annen verdi for dette filteret',
	'sd_browsedata_nonefilter' => 'Vis sider uten noen verdi for dette filteret',
	'sd_browsedata_or' => 'eller',
	'sd_browsedata_removefilter' => 'Fjern dette filteret',
	'sd_browsedata_removesubcategoryfilter' => 'Fjern dette underkategorifilteret',
	'sd_browsedata_resetfilters' => 'Resett filtre',
	'sd_browsedata_addanothervalue' => 'Klikk på pilen for å legge til enda en verdi',
	'sd_browsedata_daterangestart' => 'Start:',
	'sd_browsedata_daterangeend' => 'Slutt:',
	'sd_browsedata_novalues' => 'Det er ingen verdier for dette filteret',
	'filters' => 'Filtre',
	'sd_filters_docu' => 'Følgende filtre finnes på {{SITENAME}}:',
	'createfilter' => 'Opprett et filter',
	'sd_createfilter_name' => 'Navn:',
	'sd_createfilter_property' => 'Egenskap dette filteret dekker:',
	'sd_createfilter_usepropertyvalues' => 'Bruk alle verdier av denne egenskapen for filteret',
	'sd_createfilter_usecategoryvalues' => 'Få verdier for filteret fra denne kategorien:',
	'sd_createfilter_usedatevalues' => 'Bruk datoområder for dette filteret med denne tidsperioden:',
	'sd_createfilter_entervalues' => 'Skriv inn verdier for filteret manuelt (verdier burde adskilles med komma – om en verdi inneholder et komma, erstatt det med «\\,»);',
	'sd_createfilter_inputtype' => 'Inndatatype for dette filteret:',
	'sd_createfilter_listofvalues' => 'liste over verdier (standard)',
	'sd_createfilter_requirefilter' => 'Krev at et annet filter velges før dette vises:',
	'sd_createfilter_label' => 'Etikett for dette filteret (valgfritt):',
	'sd_blank_error' => 'kan ikke være blank',
	'sd-pageschemas-filter' => 'Filter',
	'sd-pageschemas-values' => 'Verdier',
	'sd_filter_coversproperty' => 'Dette filteret dekker egenskapen $1.',
	'sd_filter_getsvaluesfromcategory' => 'Det får verdiene sine fra kategorien $1.',
	'sd_filter_usestimeperiod' => 'Det bruker $1 som tidsperiode.',
	'sd_filter_year' => 'År',
	'sd_filter_month' => 'Måned',
	'sd_filter_hasvalues' => 'Den har verdiene $1.',
	'sd_filter_hasinputtype' => 'Det har inndatatypen $1.',
	'sd_filter_combobox' => 'kombinasjonsboks',
	'sd_filter_freetext' => 'tekst',
	'sd_filter_daterange' => 'datoområde',
	'sd_filter_requiresfilter' => 'Det krever at filteret $1 er til stede.',
	'sd_filter_haslabel' => 'Det har etiketten $1.',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'sd_browsedata_viewcategory' => 'Nyakorela sehlopha',
	'sd_browsedata_subcategory' => 'Sehlophana',
	'sd_createfilter_name' => 'Leina:',
	'sd_filter_year' => 'Ngwaga',
	'sd_filter_month' => 'Kgwedi',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'semanticdrilldown-desc' => 'Una interfàcia d’exercici per la navigacion a travèrs de semantic data',
	'specialpages-group-sd_group' => 'Exercici de semantica',
	'browsedata' => 'Cercar las donadas',
	'sd_browsedata_choosecategory' => 'Causir una categoria',
	'sd_browsedata_viewcategory' => 'Veire la categoria',
	'sd_browsedata_docu' => 'Clicar sus un o maites elements per resarrar vòstres resultats.',
	'sd_browsedata_subcategory' => 'Soscategoria',
	'sd_browsedata_other' => 'Autre',
	'sd_browsedata_none' => 'Nonrés',
	'sd_browsedata_filterbyvalue' => 'Filtrat per valor',
	'sd_browsedata_filterbysubcategory' => 'Filtrar per aquesta soscategoria',
	'sd_browsedata_otherfilter' => 'Veire las paginas amb una autra valor per aqueste filtre',
	'sd_browsedata_nonefilter' => 'Veire las paginas amb pas cap de valor per aqueste filtre',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Levar aqueste filtre',
	'sd_browsedata_removesubcategoryfilter' => 'Levar aquesta soscategoria de filtre',
	'sd_browsedata_resetfilters' => 'Remesa a zèro dels filtres',
	'sd_browsedata_addanothervalue' => 'Clicatz sus la sageta per apondre una autra valor',
	'sd_browsedata_daterangestart' => 'Començament :',
	'sd_browsedata_daterangeend' => 'Fin :',
	'sd_browsedata_novalues' => 'Existís pas de valor per aqueste filtre',
	'filters' => 'Filtres',
	'sd_filters_docu' => 'Lo filtre seguent existís sus {{SITENAME}} :',
	'createfilter' => 'Crear un filtre',
	'sd_createfilter_name' => 'Nom :',
	'sd_createfilter_property' => "Proprietat qu'aqueste filtre cobrirà :",
	'sd_createfilter_usepropertyvalues' => "Utilizar, per aqueste filtre, totas las valors d'aquesta proprietat",
	'sd_createfilter_usecategoryvalues' => "Obténer las valors per aqueste filtre a partir d'aquesta categoria :",
	'sd_createfilter_usedatevalues' => 'Utiliza de blòts de data per aqueste filtre amb aqueste periòde temporal :',
	'sd_createfilter_entervalues' => 'Entrar manualament las valors per aqueste filtre (las valors deuràn èsser separadas per de virgulas - se una valor conten una virgula, remplaçatz-la per « \\, ») :',
	'sd_createfilter_inputtype' => "Tipe d'entrada per aqueste filtre :",
	'sd_createfilter_listofvalues' => 'Lista de las valors (defaut)',
	'sd_createfilter_requirefilter' => "Necessita un filtre devent èsser seleccionat abans qu'aqueste siá afichat :",
	'sd_createfilter_label' => 'Etiqueta per aqueste filtre (facultatiu) :',
	'sd_blank_error' => 'pòt pas èsser daissat en blanc',
	'sd_filter_coversproperty' => 'Aqueste filtre cobrís la proprietat $1.',
	'sd_filter_getsvaluesfromcategory' => 'Obten sas valors a partir de la categoria $1.',
	'sd_filter_usestimeperiod' => 'Utiliza $1 coma durada de son periòde',
	'sd_filter_year' => 'Annada',
	'sd_filter_month' => 'Mes',
	'sd_filter_hasvalues' => 'A $1 coma valor',
	'sd_filter_hasinputtype' => "A lo tipe d'entrada $1.",
	'sd_filter_combobox' => 'Bóstia combo',
	'sd_filter_freetext' => 'tèxte',
	'sd_filter_daterange' => 'Gama de data',
	'sd_filter_requiresfilter' => 'Necessita la preséncia del filtre $1.',
	'sd_filter_haslabel' => 'Dispausa del labèl $1.',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'sd_browsedata_none' => 'Нæй',
	'sd_filter_year' => 'Аз',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'sd_browsedata_other' => 'Anneres',
	'sd_browsedata_none' => 'Ken',
	'sd_browsedata_or' => 'odder',
	'sd_createfilter_name' => 'Naame:',
	'sd_filter_year' => 'Yaahr',
	'sd_filter_month' => 'Munet',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'sd_browsedata_none' => 'Kääns',
);

/** Polish (Polski)
 * @author Airwolf
 * @author Maikking
 * @author Maire
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'semanticdrilldown-desc' => 'Interfejs umożliwiający zgłębianie danych semantycznych',
	'specialpages-group-sd_group' => 'Ćwiczenia semantyczne',
	'browsedata' => 'Przeglądaj dane',
	'sd_browsedata_choosecategory' => 'Wybierz kategorię',
	'sd_browsedata_viewcategory' => 'podgląd kategorii',
	'sd_browsedata_docu' => 'Kliknij jeden lub więcej z poniższych elementów, aby zawęzić wyniki.',
	'sd_browsedata_subcategory' => 'Kategoria podrzędna',
	'sd_browsedata_other' => 'Inne',
	'sd_browsedata_none' => 'Brak',
	'sd_browsedata_filterbyvalue' => 'Filtruj według tej wartości',
	'sd_browsedata_filterbysubcategory' => 'Filtruj według tej podkategorii',
	'sd_browsedata_otherfilter' => 'Wyświetla strony z innymi wartościami dla tego filtru',
	'sd_browsedata_nonefilter' => 'Pokaż strony bez wartości dla tego filtru',
	'sd_browsedata_or' => 'lub',
	'sd_browsedata_removefilter' => 'Usuń ten filtr',
	'sd_browsedata_removesubcategoryfilter' => 'Usuń ten filtr podkategorii',
	'sd_browsedata_resetfilters' => 'Wyzeruj filtry',
	'sd_browsedata_addanothervalue' => 'Kliknij strzałkę aby dodać inną wartość',
	'sd_browsedata_daterangestart' => 'Początek',
	'sd_browsedata_daterangeend' => 'Koniec',
	'sd_browsedata_novalues' => 'Nie ma żadnych wartości dla tego filtru',
	'filters' => 'Filtry',
	'sd_filters_docu' => 'Na {{GRAMMAR:MS.lp|{{SITENAME}}}} zdefiniowano następujące filtry:',
	'createfilter' => 'Utwórz filtr',
	'sd_createfilter_name' => 'Nazwa',
	'sd_createfilter_property' => 'Własność przesłonięta tym filtrem',
	'sd_createfilter_usepropertyvalues' => 'Użyj wszystkich wartości tej własności dla filtru',
	'sd_createfilter_usecategoryvalues' => 'Użyj wartości dla filtru z kategorii',
	'sd_createfilter_usedatevalues' => 'Użyj dla filtru przedziału czasu',
	'sd_createfilter_entervalues' => 'Wprowadź ręcznie wartości dla filtru (wartości powinny być rozdzielone przecinkami – jeśli wartości zawierają przecinki, zastąp je „\\,”):',
	'sd_createfilter_inputtype' => 'Podaj typ filtru',
	'sd_createfilter_listofvalues' => 'lista wartości (domyślna)',
	'sd_createfilter_requirefilter' => 'Wymagaj użycia innego filtru przed tym',
	'sd_createfilter_label' => 'Etykieta filtru (nieobowiązkowa)',
	'sd_blank_error' => 'nie może być puste',
	'sd_filter_coversproperty' => 'Ten filtr przesłania własność $1.',
	'sd_filter_getsvaluesfromcategory' => 'Otrzymuje wartości z kategorii $1.',
	'sd_filter_usestimeperiod' => 'Używa $1 jako swojego przedziału czasu.',
	'sd_filter_year' => 'Rok',
	'sd_filter_month' => 'Miesiąc',
	'sd_filter_hasvalues' => 'Ma wartości $1.',
	'sd_filter_hasinputtype' => 'Typ wejściowy – $1.',
	'sd_filter_combobox' => 'rozwijana lista',
	'sd_filter_freetext' => 'tekst',
	'sd_filter_daterange' => 'zakres dat',
	'sd_filter_requiresfilter' => 'Wymaga obecności filtru $1.',
	'sd_filter_haslabel' => 'Ma etykietę $1.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'semanticdrilldown-desc' => "N'antërfacia a cascada për esploré dat semàntich",
	'specialpages-group-sd_group' => 'Cascada Semàntica',
	'browsedata' => 'Sërché ij dat',
	'sd_browsedata_choosecategory' => 'Sern na categorìa',
	'sd_browsedata_viewcategory' => 'varda categorìa',
	'sd_browsedata_docu' => "Sgnaca su un o pi element sì-sota për strenze j'arzultà",
	'sd_browsedata_subcategory' => 'Sotcategorìa',
	'sd_browsedata_other' => 'Àutr',
	'sd_browsedata_none' => 'Gnun',
	'sd_browsedata_filterbyvalue' => 'Filtra për sto valor-sì',
	'sd_browsedata_filterbysubcategory' => 'Filtra për sta sotcategorìa-sì',
	'sd_browsedata_otherfilter' => "Mostra pàgine con n'àutr valor për sto filtr-sì",
	'sd_browsedata_nonefilter' => 'Mostra pàgine con gnun valor për sto filtr-sì',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Gava sto filtr-sì',
	'sd_browsedata_removesubcategoryfilter' => 'Gava sto filtr ëd sotcategorìa',
	'sd_browsedata_resetfilters' => 'Spian-a filtr',
	'sd_browsedata_addanothervalue' => "Sgnaca la flecia për gionté n'àutr valor",
	'sd_browsedata_daterangestart' => 'Prinsipi:',
	'sd_browsedata_daterangeend' => 'Fin:',
	'sd_browsedata_novalues' => 'A-i é pa gnun valor për sto filtr-sì',
	'filters' => 'Filtr',
	'sd_filters_docu' => 'I filtr sì-sota a esisto an {{SITENAME}}:',
	'createfilter' => 'Crea un filtr',
	'sd_createfilter_name' => 'Nòm:',
	'sd_createfilter_property' => 'Proprietà che sto filtr-sì a coata:',
	'sd_createfilter_usepropertyvalues' => 'Dovré tùit ij valor dë sta proprietà-sì për ël filtr',
	'sd_createfilter_usecategoryvalues' => 'Pija ij valor për filtr da sta categorìa-sì:',
	'sd_createfilter_usedatevalues' => "Dovré l'antërval ëd date për sto filtr-sì con sto antërval ëd temp-sì:",
	'sd_createfilter_entervalues' => 'Anseriss ij valor për filtr a man (ij valor a dovrìo esse separà da vìrgole - se un valor a conten na vìrgola, rimpiassla con "\\,"):',
	'sd_createfilter_inputtype' => 'Anseriss la sòrt dë sto filtr-sì:',
	'sd_createfilter_listofvalues' => 'lista ëd valor (stàndard)',
	'sd_createfilter_requirefilter' => "Ciama ëd selessioné n'àutr filtr prima che sto-sì a sia visualisà:",
	'sd_createfilter_label' => 'Tichëtta për sto filtr-sì (opsional):',
	'sd_blank_error' => 'a peul pa esse veuid',
	'sd-pageschemas-values' => 'Valor',
	'sd_filter_coversproperty' => 'Sto filtr-sì a coata la proprietà $1.',
	'sd_filter_getsvaluesfromcategory' => 'A pija ij sò valor da la categorìa $1.',
	'sd_filter_usestimeperiod' => 'A deuvra $1 com sò antërval ëd temp.',
	'sd_filter_year' => 'Ann',
	'sd_filter_month' => 'Mèis',
	'sd_filter_hasvalues' => "A l'ha ij valor $1.",
	'sd_filter_hasinputtype' => "A l'ha la sòrt ëd dàit d'intrada $1.",
	'sd_filter_combobox' => 'casela combo',
	'sd_filter_freetext' => 'test',
	'sd_filter_daterange' => 'antërval ëd date',
	'sd_filter_requiresfilter' => 'A veul la presensa dël filtr $1.',
	'sd_filter_haslabel' => "A l'ha l'etichëtta $1.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'browsedata' => 'مالومات سپړل',
	'sd_browsedata_choosecategory' => 'يوه وېشنيزه ټاکل',
	'sd_browsedata_viewcategory' => 'وېشنيزه ښکاره کول',
	'sd_browsedata_subcategory' => 'وړه-وېشنيزه',
	'sd_browsedata_other' => 'بل',
	'sd_browsedata_none' => 'هېڅ',
	'sd_browsedata_filterbysubcategory' => 'د همدې وړې-وېشنيزې له مخې چاڼول',
	'sd_browsedata_or' => 'يا',
	'sd_browsedata_removefilter' => 'همدا چاڼګر لرې کول',
	'sd_browsedata_daterangestart' => 'پيل:',
	'sd_browsedata_daterangeend' => 'پای:',
	'filters' => 'چاڼګرونه',
	'createfilter' => 'يو چاڼګر جوړول',
	'sd_createfilter_name' => 'نوم:',
	'sd_blank_error' => 'بايد تش نه وي',
	'sd_filter_year' => 'کال',
	'sd_filter_month' => 'مياشت',
	'sd_filter_freetext' => 'متن',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'semanticdrilldown-desc' => 'Uma interface de prospecção para navegar através de dados semânticos',
	'specialpages-group-sd_group' => 'Prospecção Semântica',
	'browsedata' => 'Navegar pelos dados',
	'sd_browsedata_choosecategory' => 'Escolha uma categoria',
	'sd_browsedata_viewcategory' => 'ver categoria',
	'sd_browsedata_docu' => 'Clique abaixo em um ou mais itens para restringir os seus resultados.',
	'sd_browsedata_subcategory' => 'subcategoria',
	'sd_browsedata_other' => 'Outro',
	'sd_browsedata_none' => 'Nenhum',
	'sd_browsedata_filterbyvalue' => 'Filtrar por este valor',
	'sd_browsedata_filterbysubcategory' => 'Filtrar por esta subcategoria',
	'sd_browsedata_otherfilter' => 'Apresentar páginas com outro valor para este filtro',
	'sd_browsedata_nonefilter' => 'Apresentar páginas sem valores para este filtro',
	'sd_browsedata_or' => 'ou',
	'sd_browsedata_removefilter' => 'Remover este filtro',
	'sd_browsedata_removesubcategoryfilter' => 'Remover esta subcategoria da função de filtro',
	'sd_browsedata_resetfilters' => 'Repor filtros',
	'sd_browsedata_addanothervalue' => 'Clique na seta para adicionar outro valor',
	'sd_browsedata_daterangestart' => 'Início:',
	'sd_browsedata_daterangeend' => 'Fim:',
	'sd_browsedata_novalues' => 'Não há valores para este filtro',
	'filters' => 'Filtros',
	'sd_filters_docu' => 'Na {{SITENAME}} existem os seguintes filtros:',
	'createfilter' => 'Criar um filtro',
	'sd_createfilter_name' => 'Nome:',
	'sd_createfilter_property' => 'Propriedades que este filtro abrange:',
	'sd_createfilter_usepropertyvalues' => 'Usar todos os valores desta propriedade no filtro',
	'sd_createfilter_usecategoryvalues' => 'Obter valores de filtro a partir desta categoria:',
	'sd_createfilter_usedatevalues' => 'Usar intervalos de datas para este filtro com este período de tempo:',
	'sd_createfilter_entervalues' => 'Introduza valores para o filtro manualmente (os valores devem ser separados por vírgulas - se um valor contém uma vírgula, substitua-a por "\\,"):',
	'sd_createfilter_inputtype' => 'Tipo de entrada para este filtro:',
	'sd_createfilter_listofvalues' => 'lista de valores (padrão)',
	'sd_createfilter_requirefilter' => 'Exigir que outro filtro seja seleccionado antes de apresentar este:',
	'sd_createfilter_label' => 'Etiqueta para este filtro (opcional):',
	'sd_blank_error' => 'não pode estar em branco',
	'sd_filter_coversproperty' => 'Este filtro abrange a propriedade $1.',
	'sd_filter_getsvaluesfromcategory' => 'Extrai os seus valores da categoria $1.',
	'sd_filter_usestimeperiod' => 'Utiliza $1 como seu período de tempo.',
	'sd_filter_year' => 'Ano',
	'sd_filter_month' => 'Mês',
	'sd_filter_hasvalues' => 'Tem os valores $1.',
	'sd_filter_hasinputtype' => 'Tem o tipo de entrada $1.',
	'sd_filter_combobox' => 'caixa de selecção',
	'sd_filter_freetext' => 'texto',
	'sd_filter_daterange' => 'intervalo de datas',
	'sd_filter_requiresfilter' => 'Requer a presença do filtro $1.',
	'sd_filter_haslabel' => 'Tem a etiqueta $1.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Enqd
 * @author Giro720
 */
$messages['pt-br'] = array(
	'semanticdrilldown-desc' => 'Uma interface de introspecção para navegar através de dados semânticos',
	'specialpages-group-sd_group' => 'Introspecção Semântica',
	'browsedata' => 'Navegar pelo dados',
	'sd_browsedata_choosecategory' => 'Escolha uma categoria',
	'sd_browsedata_viewcategory' => 'ver categoria',
	'sd_browsedata_docu' => 'Clique abaixo em um ou mais itens para restringir os seus resultados.',
	'sd_browsedata_subcategory' => 'Subcategoria',
	'sd_browsedata_other' => 'Outro',
	'sd_browsedata_none' => 'Nenhum',
	'sd_browsedata_filterbyvalue' => 'Filtrar por este valor',
	'sd_browsedata_filterbysubcategory' => 'Filtrar por esta subcategoria',
	'sd_browsedata_otherfilter' => 'Exibir páginas com outro valor para este filtro',
	'sd_browsedata_nonefilter' => 'Exibir páginas sem valores para este filtro',
	'sd_browsedata_or' => 'ou',
	'sd_browsedata_removefilter' => 'Remover este filtro',
	'sd_browsedata_removesubcategoryfilter' => 'Remover o filtro por esta subcategoria',
	'sd_browsedata_resetfilters' => 'Zerar filtros',
	'sd_browsedata_addanothervalue' => 'Clique na seta para adicionar outro valor',
	'sd_browsedata_daterangestart' => 'Início:',
	'sd_browsedata_daterangeend' => 'Fim:',
	'sd_browsedata_novalues' => 'Não há valores para este filtro',
	'filters' => 'Filtros',
	'sd_filters_docu' => '{{SITENAME}} possui os seguintes filtros:',
	'createfilter' => 'Criar um filtro',
	'sd_createfilter_name' => 'Nome:',
	'sd_createfilter_property' => 'Propriedades que este filtro abrange:',
	'sd_createfilter_usepropertyvalues' => 'Usar todos os valores desta propriedade no filtro',
	'sd_createfilter_usecategoryvalues' => 'Obter valores de filtro a partir desta categoria:',
	'sd_createfilter_usedatevalues' => 'Usar intervalos de datas para este filtro com este período de tempo:',
	'sd_createfilter_entervalues' => 'Introduza valores para o filtro manualmente (os valores devem ser separados por vírgulas - se um valor contém uma vírgula, substitua-a por "\\,"):',
	'sd_createfilter_inputtype' => 'Tipo de entrada para este filtro:',
	'sd_createfilter_listofvalues' => 'lista de valores (padrão)',
	'sd_createfilter_requirefilter' => 'Necessita de outro filtro selecionado antes deste ser exibido:',
	'sd_createfilter_label' => 'Etiqueta para este filtro (opcional):',
	'sd_blank_error' => 'não pode estar em branco',
	'sd_filter_coversproperty' => 'Este filtro abrange a propriedade $1.',
	'sd_filter_getsvaluesfromcategory' => 'Extrai os seus valores da categoria $1.',
	'sd_filter_usestimeperiod' => 'Utiliza $1 como seu período de tempo.',
	'sd_filter_year' => 'Ano',
	'sd_filter_month' => 'Mês',
	'sd_filter_hasvalues' => 'Possui os valores $1.',
	'sd_filter_hasinputtype' => 'Tem o tipo de entrada $1.',
	'sd_filter_combobox' => 'caixa de seleção',
	'sd_filter_freetext' => 'texto',
	'sd_filter_daterange' => 'intervalo de datas',
	'sd_filter_requiresfilter' => 'Requer a presença do filtro $1.',
	'sd_filter_haslabel' => 'Possui a etiqueta $1.',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'browsedata' => 'Răsfoiți data',
	'sd_browsedata_choosecategory' => 'Alegeți o categorie',
	'sd_browsedata_viewcategory' => 'vedeți categoria',
	'sd_browsedata_subcategory' => 'Subcategorie',
	'sd_browsedata_other' => 'Altul',
	'sd_browsedata_none' => 'Nimic',
	'sd_browsedata_filterbyvalue' => 'Filtrează după această valoare',
	'sd_browsedata_filterbysubcategory' => 'Filtrează după această subcategorie',
	'sd_browsedata_otherfilter' => 'Arată paginile cu o altă valoare pentru acest filtru',
	'sd_browsedata_nonefilter' => 'Arată paginile cu nicio valoare pentru acest filtru',
	'sd_browsedata_or' => 'sau',
	'sd_browsedata_removefilter' => 'Elimină acest filtru',
	'sd_browsedata_removesubcategoryfilter' => 'Elimină acest filtru de subcategorie',
	'sd_browsedata_resetfilters' => 'Resetați filtrele',
	'sd_browsedata_addanothervalue' => 'Adaugă altă valoare',
	'sd_browsedata_daterangestart' => 'Început:',
	'sd_browsedata_daterangeend' => 'Sfârșit:',
	'sd_browsedata_novalues' => 'Nu există valori pentru acest filtru',
	'filters' => 'Filtre',
	'sd_filters_docu' => 'Următoarele filtre există la {{SITENAME}}:',
	'createfilter' => 'Creați un filtru',
	'sd_createfilter_name' => 'Nume:',
	'sd_blank_error' => 'nu poate fi gol',
	'sd_filter_year' => 'An',
	'sd_filter_month' => 'Lună',
	'sd_filter_hasvalues' => 'Are valorile $1.',
	'sd_filter_freetext' => 'text',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'sd_browsedata_or' => 'o',
	'sd_browsedata_daterangestart' => 'Accumenze:',
	'sd_browsedata_daterangeend' => 'Spiccie:',
	'sd_filter_year' => 'Anne',
	'sd_filter_month' => 'Mese',
	'sd_filter_freetext' => 'teste',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'semanticdrilldown-desc' => 'Развёрнутый интерфейс для навигации в семантических данных',
	'specialpages-group-sd_group' => 'Развёрнутая семантика',
	'browsedata' => 'Обзор данных',
	'sd_browsedata_choosecategory' => 'Выберите категорию',
	'sd_browsedata_viewcategory' => 'просмотр категории',
	'sd_browsedata_docu' => 'Нажмите на одном или больше элементов для уменьшения ваших результатов.',
	'sd_browsedata_subcategory' => 'Подкатегория',
	'sd_browsedata_other' => 'Другие',
	'sd_browsedata_none' => 'Нет',
	'sd_browsedata_filterbyvalue' => 'Фильтр по этому значению',
	'sd_browsedata_filterbysubcategory' => 'Фильтр по этой подкатегории',
	'sd_browsedata_otherfilter' => 'Показать страницы с другими значениями по этому фильтру',
	'sd_browsedata_nonefilter' => 'Показать страницы без значений по этому фильтру',
	'sd_browsedata_or' => 'или',
	'sd_browsedata_removefilter' => 'Убрать этот фильтр',
	'sd_browsedata_removesubcategoryfilter' => 'Убрать этот фильтр по подкатегории',
	'sd_browsedata_resetfilters' => 'Сбросить фильтры',
	'sd_browsedata_addanothervalue' => 'Нажмите на стрелку, чтобы добавить другое значение',
	'sd_browsedata_daterangestart' => 'Начало:',
	'sd_browsedata_daterangeend' => 'Конец:',
	'sd_browsedata_novalues' => 'Нет значений для этого фильтра',
	'filters' => 'Фильтры',
	'sd_filters_docu' => '{{SITENAME}} содержит следующие фильтры:',
	'createfilter' => 'Создать фильтр',
	'sd_createfilter_name' => 'Имя:',
	'sd_createfilter_property' => 'Свойство, которое покрывает этот фильтр:',
	'sd_createfilter_usepropertyvalues' => 'Использовать все значения этого свойства для фильтра',
	'sd_createfilter_usecategoryvalues' => 'Получить значения для фильтра из этой категории:',
	'sd_createfilter_usedatevalues' => 'Использовать следующий диапазон дат для фильтра:',
	'sd_createfilter_entervalues' => 'Введите значения для фильтра вручную (значения должны разделяться запятыми, если значение содержит запятую, замените её на «\\,»):',
	'sd_createfilter_inputtype' => 'Тип ввода для этого фильтра:',
	'sd_createfilter_listofvalues' => 'список значений (по умолчанию)',
	'sd_createfilter_requirefilter' => 'Требовать выбора другого фильтра, перед тем, как отображать этот:',
	'sd_createfilter_label' => 'Пометка для этого фильтра (необязательно):',
	'sd_blank_error' => 'не может быть пустым',
	'sd-pageschemas-values' => 'Значения',
	'sd_filter_coversproperty' => 'Этот фильтр покрывает свойство $1.',
	'sd_filter_getsvaluesfromcategory' => 'Получает свои значения из категории $1.',
	'sd_filter_usestimeperiod' => 'Использует $1 как временной диапазон.',
	'sd_filter_year' => 'Год',
	'sd_filter_month' => 'Месяц',
	'sd_filter_hasvalues' => 'Имеет значения $1.',
	'sd_filter_hasinputtype' => 'Он имеет тип ввода $1.',
	'sd_filter_combobox' => 'выпадающий список',
	'sd_filter_freetext' => 'текст',
	'sd_filter_daterange' => 'диапазон дат',
	'sd_filter_requiresfilter' => 'Требует наличия фильтра $1.',
	'sd_filter_haslabel' => 'Имеет пометку $1.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'sd_browsedata_choosecategory' => 'Выбрати катеґорію',
	'sd_browsedata_viewcategory' => 'видїти катеґорію',
	'sd_browsedata_subcategory' => 'Підкатегорія',
	'sd_browsedata_other' => 'Інше',
	'sd_browsedata_none' => 'Жадне',
	'sd_filter_year' => 'Рік',
	'sd_filter_month' => 'Місяць',
	'sd_filter_freetext' => 'текст',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'semanticdrilldown-desc' => 'Rozhranie na navigáciu sémantickými údajmi',
	'specialpages-group-sd_group' => 'Sémantické operácie',
	'browsedata' => 'Prehliadať údaje',
	'sd_browsedata_choosecategory' => 'Vyberte kategóriu',
	'sd_browsedata_viewcategory' => 'zobraziť kategóriu',
	'sd_browsedata_docu' => 'Výsledky môžete zúžiť kliknutím na jednu alebo viac dolu uvedených položiek.',
	'sd_browsedata_subcategory' => 'Podkategória',
	'sd_browsedata_other' => 'Iné',
	'sd_browsedata_none' => 'Žiadne',
	'sd_browsedata_filterbyvalue' => 'Filtrovať podľa tejto hodnoty',
	'sd_browsedata_filterbysubcategory' => 'Filtrovať podľa tejto podkategórie',
	'sd_browsedata_otherfilter' => 'Zobraziť stránky s inou hodnotou tohto filtra',
	'sd_browsedata_nonefilter' => 'Zobraziť stránky s bez hodnoty tohto filtra',
	'sd_browsedata_or' => 'alebo',
	'sd_browsedata_removefilter' => 'Odstrániť tento filter',
	'sd_browsedata_removesubcategoryfilter' => 'Odstrániť tento filter podkategórie',
	'sd_browsedata_resetfilters' => 'Resetovať filtre',
	'sd_browsedata_addanothervalue' => 'Ďalšiu hodnotu pridáte kliknutím na šípku',
	'sd_browsedata_daterangestart' => 'Začiatok:',
	'sd_browsedata_daterangeend' => 'Koniec:',
	'sd_browsedata_novalues' => 'Pre tento filter nie sú žiadne hodnoty',
	'filters' => 'Filtre',
	'sd_filters_docu' => 'Na {{GRAMMAR:lokál|{{SITENAME}}}} existujú nasledovné filtre:',
	'createfilter' => 'Vytvoriť filter',
	'sd_createfilter_name' => 'Názov:',
	'sd_createfilter_property' => 'Vlastnosť, ktorú tento filter pokrýva:',
	'sd_createfilter_usepropertyvalues' => 'Použiť všetky hodnoty tejto vlastnosti pre tento filter',
	'sd_createfilter_usecategoryvalues' => 'Získať hodnoty filtra z tejto kategórie:',
	'sd_createfilter_usedatevalues' => 'Použiť rozsahy dátumov pre tento filter z tohoto časového intervalu:',
	'sd_createfilter_entervalues' => 'Zadajte hodnoty pre tento filter ručne (hodnoty by mali byť oddelené čiarkami - ak hodnota obsahuje čiarku, nahraďte ju „\\,“):',
	'sd_createfilter_inputtype' => 'Typ vstupu pre tento filter:',
	'sd_createfilter_listofvalues' => 'zoznam hodnôt (štandardné)',
	'sd_createfilter_requirefilter' => 'Vyžadovať, aby bol vybraný iný filter než sa zobrazí tento:',
	'sd_createfilter_label' => 'Označenie tohto filtra (voliteľné):',
	'sd_blank_error' => 'nemôže byť nevyplnené',
	'sd_filter_coversproperty' => 'Tento filter pokrýva vlastnosť $1.',
	'sd_filter_getsvaluesfromcategory' => 'Získava hodnoty z kategórie $1.',
	'sd_filter_usestimeperiod' => 'Používa ako časový interval $1.',
	'sd_filter_year' => 'Rok',
	'sd_filter_month' => 'Mesiac',
	'sd_filter_hasvalues' => 'Má hodnoty $1.',
	'sd_filter_hasinputtype' => 'Má typ vstupu $1.',
	'sd_filter_combobox' => 'roletová ponuka',
	'sd_filter_freetext' => 'text',
	'sd_filter_daterange' => 'rozsah dátumov',
	'sd_filter_requiresfilter' => 'Vyžaduje prítomnosť filtra $1.',
	'sd_filter_haslabel' => 'Má označenie $1.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'sd_filter_year' => 'Leto',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'sd_browsedata_choosecategory' => 'Изабери категорију',
	'sd_browsedata_viewcategory' => 'погледај категорију',
	'sd_browsedata_subcategory' => 'Поткатегорија',
	'sd_browsedata_other' => 'Друго',
	'sd_browsedata_none' => 'Нема',
	'sd_browsedata_or' => 'или',
	'sd_browsedata_daterangestart' => 'Почетак:',
	'sd_browsedata_daterangeend' => 'Крај:',
	'filters' => 'Филтери',
	'sd_createfilter_name' => 'Име:',
	'sd_filter_year' => 'Година',
	'sd_filter_month' => 'Месец',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'sd_browsedata_choosecategory' => 'Izaberi kategoriju',
	'sd_browsedata_viewcategory' => 'vidi kategoriju',
	'sd_browsedata_subcategory' => 'Podkategorija',
	'sd_browsedata_other' => 'Drugo',
	'sd_browsedata_none' => 'Nema',
	'sd_browsedata_or' => 'ili',
	'sd_browsedata_daterangestart' => 'Početak:',
	'sd_browsedata_daterangeend' => 'Kraj:',
	'filters' => 'Filteri',
	'sd_createfilter_name' => 'Ime:',
	'sd_filter_year' => 'Godina',
	'sd_filter_month' => 'Mesec',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'semanticdrilldown-desc' => 'Ne Drilldown-Benutsersnitsteede, uum truch semantiske Doaten tou navigierjen',
	'specialpages-group-sd_group' => 'Semantisk Drill-Down',
	'browsedata' => 'Doaten bekiekje',
	'sd_browsedata_choosecategory' => 'Wääl ne Kategorie',
	'sd_browsedata_viewcategory' => 'Kategorie bekiekje',
	'sd_browsedata_docu' => 'Klik ap een of moorere fon do Sieuwen uum dät Resultoat ientoutuunjen.',
	'sd_browsedata_subcategory' => 'Unnerkategorie',
	'sd_browsedata_other' => 'Uur',
	'sd_browsedata_none' => 'Neen',
	'sd_browsedata_filterbyvalue' => 'Sieuwe foar dissen Wäid',
	'sd_browsedata_filterbysubcategory' => 'Sieuwe foar disse Subkategorie',
	'sd_browsedata_otherfilter' => 'Wies Sieden mäd n uur Wäid foar disse Sieuwe',
	'sd_browsedata_nonefilter' => 'Wies Sieden mäd naan Wäid foar disse Sieuwe',
	'sd_browsedata_or' => 'of',
	'sd_browsedata_removefilter' => 'Läskje disse Sieuwe',
	'sd_browsedata_removesubcategoryfilter' => 'Läskje disse Subkategorie-Sieuwe',
	'sd_browsedata_resetfilters' => 'Sieuwen touräächsätte',
	'sd_browsedata_addanothervalue' => 'Uur Wäid bietouföigje',
	'sd_browsedata_daterangestart' => 'Ounfang:',
	'sd_browsedata_daterangeend' => 'Eende:',
	'filters' => 'Filter',
	'sd_filters_docu' => 'Do foulgjende Sieuwen existierje in disse Wiki:',
	'createfilter' => 'Moak ne Sieuwe',
	'sd_createfilter_name' => 'Noome:',
	'sd_createfilter_property' => 'Attribut fon disse Sieuwe:',
	'sd_createfilter_usepropertyvalues' => 'Ferweend aal Wäide fon dit Attribut foar ju Sieuwe.',
	'sd_createfilter_usecategoryvalues' => 'Ferweend do Wäide foar ju Sieuwe fon disse Kategorie:',
	'sd_createfilter_usedatevalues' => 'Ferweend foulgjende Tiedangoawe foar disse Sieuwe:',
	'sd_createfilter_entervalues' => 'Ferweend disse Wäide foar ju Sieuwe (Wäide truch Komma tränd ienreeke. Wan n Wäid n Komma änthaalt, mäd "\\,"ärsätte.):',
	'sd_createfilter_inputtype' => 'Iengoawetyp fon disse Sieuwe:',
	'sd_createfilter_listofvalues' => 'Lieste fon Wäide (Standoard)',
	'sd_createfilter_requirefilter' => 'Eer disse Sieuwe anwiesd wäd, mout foulgjende uur Sieuwe sät weese:',
	'sd_createfilter_label' => 'Beteekenge fon disse Sieuwe (optionoal):',
	'sd_blank_error' => 'duur nit loos weese',
	'sd_filter_coversproperty' => 'Disse Sieuwe beträft dät Attribut $1.',
	'sd_filter_getsvaluesfromcategory' => 'Hie kricht sien Wäide uut ju Kategorie $1.',
	'sd_filter_usestimeperiod' => 'Ferwoant $1 as Tiedangoawe.',
	'sd_filter_year' => 'Jier',
	'sd_filter_month' => 'Mound',
	'sd_filter_hasvalues' => 'Häd dän Wäid $1.',
	'sd_filter_hasinputtype' => 'Et häd dän Iengoawetyp $1.',
	'sd_filter_freetext' => 'Text',
	'sd_filter_daterange' => 'Tiedsponne',
	'sd_filter_requiresfilter' => 'Hie sät ju Sieuwe $1 foaruut.',
	'sd_filter_haslabel' => 'Häd ju Beteekenge $1.',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Per
 */
$messages['sv'] = array(
	'browsedata' => 'Bläddra genom data',
	'sd_browsedata_choosecategory' => 'Välj en kategori',
	'sd_browsedata_viewcategory' => 'visa kategori',
	'sd_browsedata_subcategory' => 'Subkategori',
	'sd_browsedata_other' => 'Andra',
	'sd_browsedata_none' => 'Ingen',
	'sd_browsedata_filterbyvalue' => 'Filtrera efter det här värdet',
	'sd_browsedata_filterbysubcategory' => 'Filtrera efter den här underkategorin',
	'sd_browsedata_otherfilter' => 'Visa sidor med ett annat värde för det här filtret',
	'sd_browsedata_nonefilter' => 'Visa sidor utan några värden för detta filter',
	'sd_browsedata_or' => 'eller',
	'sd_browsedata_removefilter' => 'Ta bort detta filter',
	'sd_browsedata_removesubcategoryfilter' => 'Ta bort detta underkategorifiltret',
	'sd_browsedata_resetfilters' => 'Återställ filter',
	'sd_browsedata_addanothervalue' => 'Klicka på pilen för att lägga till ytterligare värde',
	'sd_browsedata_daterangestart' => 'Start:',
	'sd_browsedata_daterangeend' => 'Slut:',
	'sd_browsedata_novalues' => 'Det finns inga värden för detta filter',
	'filters' => 'Filter',
	'sd_filters_docu' => 'Följande filter finns på {{SITENAME}}:',
	'createfilter' => 'Skapa ett filter',
	'sd_createfilter_name' => 'Namn:',
	'sd_createfilter_property' => 'Egenskaper som detta filter döljer:',
	'sd_createfilter_usepropertyvalues' => 'Använd alla värden av den här egenskapen för filtret',
	'sd_createfilter_usecategoryvalues' => 'Hämta värden för filtret från den här kategorin:',
	'sd_createfilter_usedatevalues' => 'Använd datumområden för det här filtret med den här tidsperioden:',
	'sd_createfilter_entervalues' => 'Skriv in värden för filtret manuellt (värdena ska separeras med komma - om ett värde innehåller ett komma, ersätt det med "\\,"):',
	'sd_createfilter_inputtype' => 'Indatatyp för detta filter:',
	'sd_createfilter_listofvalues' => 'lista över värden (standard)',
	'sd_createfilter_requirefilter' => 'Kräv att ett annat filter väljs före detta visas:',
	'sd_createfilter_label' => 'Etikett för det här filtret (valfritt):',
	'sd_blank_error' => 'kan inte vara tom',
	'sd_filter_coversproperty' => 'Detaa filter döljer egenskapen $1.',
	'sd_filter_getsvaluesfromcategory' => 'Det får sina värden från kategorin $1.',
	'sd_filter_usestimeperiod' => 'Det använder $1 som tidsperiod.',
	'sd_filter_year' => 'År',
	'sd_filter_month' => 'Månad',
	'sd_filter_hasvalues' => 'Det har värdena $1.',
	'sd_filter_hasinputtype' => 'Den har indatatypen $1.',
	'sd_filter_freetext' => 'text',
	'sd_filter_daterange' => 'datumintervall',
	'sd_filter_requiresfilter' => 'Det kräver att filtret $1 är på plats.',
	'sd_filter_haslabel' => 'Det har etiketten $1.',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'sd_createfilter_name' => 'Mjano:',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'browsedata' => 'భోగట్టాని చూడండి',
	'sd_browsedata_choosecategory' => 'ఓ వర్గాన్ని ఎంచుకోండి',
	'sd_browsedata_viewcategory' => 'వర్గాన్ని చూడండి',
	'sd_browsedata_subcategory' => 'ఉపవర్గం',
	'sd_browsedata_other' => 'ఇతర',
	'sd_browsedata_none' => 'ఏమీలేదు',
	'sd_browsedata_or' => 'లేదా',
	'sd_browsedata_removefilter' => 'ఈ వడపోతని తొలగించు',
	'sd_browsedata_addanothervalue' => 'మరో విలువని చేర్చండి',
	'sd_browsedata_daterangestart' => 'మొదలు:',
	'sd_browsedata_daterangeend' => 'ముగింపు:',
	'sd_browsedata_novalues' => 'ఈ వడపోతకి విలువలు ఏమీ లేవు',
	'filters' => 'వడపోతలు',
	'sd_filters_docu' => '{{SITENAME}}లో ఈ క్రింది వడపోతలు ఉన్నాయి:',
	'sd_createfilter_name' => 'పేరు:',
	'sd_createfilter_usecategoryvalues' => 'వడపోతకి విలువలని ఈ వర్గంనుండి తీసుకోవాలి:',
	'sd_createfilter_listofvalues' => 'విలువల జాబితా (అప్రమేయం)',
	'sd_blank_error' => 'ఖాళీగా ఉండకూడదు',
	'sd_filter_year' => 'సంవత్సరం',
	'sd_filter_month' => 'నెల',
	'sd_filter_freetext' => 'పాఠ్యం',
	'sd_filter_daterange' => 'తేదీ అవధి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'sd_browsedata_other' => 'Seluk',
	'sd_createfilter_name' => 'Naran:',
	'sd_filter_year' => 'Tinan',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'browsedata' => 'Мурури дода',
	'sd_browsedata_choosecategory' => 'Гурӯҳеро интихоб кунед',
	'sd_browsedata_viewcategory' => 'нигаристан гурӯҳ',
	'sd_browsedata_subcategory' => 'Зергурӯҳ',
	'sd_browsedata_other' => 'Дигар',
	'sd_browsedata_none' => 'Ҳеҷ',
	'sd_browsedata_or' => 'ё',
	'sd_browsedata_daterangestart' => 'Шурӯъ:',
	'sd_browsedata_daterangeend' => 'Охир:',
	'filters' => 'Филтрҳо',
	'sd_createfilter_name' => 'Ном:',
	'sd_createfilter_entervalues' => 'Миқдорҳоро барои филтр дастӣ ворид кунед (миқдорҳо бояд бо вергулҳо ҷудо шаванд - агар миқдор вергул дошта бошад, онро бо "\\," иваз кунед):',
	'sd_createfilter_requirefilter' => 'Қабл аз намоиши ин яке, филтри дигар бояд интихоб шавад:',
	'sd_createfilter_label' => 'Барчасб барои ин филтр (ихтиёрӣ):',
	'sd_blank_error' => 'наметавонад холӣ бошад',
	'sd_filter_coversproperty' => 'Ин филтр вижагии $1-ро шомил мешавад.',
	'sd_filter_getsvaluesfromcategory' => 'Миқдорҳояшро аз гурӯҳи $1 мегирад.',
	'sd_filter_usestimeperiod' => '$1-ро ба унвони давраи вақти худ ба кор мебарад.',
	'sd_filter_year' => 'Сол',
	'sd_filter_month' => 'Моҳ',
	'sd_filter_hasvalues' => 'Миқдорҳои $1-ро дорад.',
	'sd_filter_requiresfilter' => 'Ба вуҷуди филтри $1 эҳтиёҷ дорад.',
	'sd_filter_haslabel' => 'Ин барчасби $1 дорад.',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'browsedata' => 'Mururi doda',
	'sd_browsedata_choosecategory' => 'Gurūhero intixob kuned',
	'sd_browsedata_viewcategory' => 'nigaristan gurūh',
	'sd_browsedata_subcategory' => 'Zergurūh',
	'sd_browsedata_other' => 'Digar',
	'sd_browsedata_none' => 'Heç',
	'sd_browsedata_or' => 'jo',
	'sd_browsedata_daterangestart' => "Şurū':",
	'sd_browsedata_daterangeend' => 'Oxir:',
	'filters' => 'Filtrho',
	'sd_createfilter_name' => 'Nom:',
	'sd_createfilter_entervalues' => 'Miqdorhoro baroi filtr dastī vorid kuned (miqdorho bojad bo vergulho çudo şavand - agar miqdor vergul doşta boşad, onro bo "\\," ivaz kuned):',
	'sd_createfilter_requirefilter' => 'Qabl az namoişi in jake, filtri digar bojad intixob şavad:',
	'sd_createfilter_label' => 'Barcasb baroi in filtr (ixtijorī):',
	'sd_blank_error' => 'nametavonad xolī boşad',
	'sd_filter_coversproperty' => 'In filtr viƶagiji $1-ro şomil meşavad.',
	'sd_filter_getsvaluesfromcategory' => 'Miqdorhojaşro az gurūhi $1 megirad.',
	'sd_filter_usestimeperiod' => '$1-ro ba unvoni davrai vaqti xud ba kor mebarad.',
	'sd_filter_year' => 'Sol',
	'sd_filter_month' => 'Moh',
	'sd_filter_hasvalues' => 'Miqdorhoi $1-ro dorad.',
	'sd_filter_requiresfilter' => 'Ba vuçudi filtri $1 ehtijoç dorad.',
	'sd_filter_haslabel' => 'In barcasbi $1 dorad.',
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'sd_browsedata_none' => 'ไม่มี',
	'filters' => 'ตัวกรอง',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'filters' => 'Filtrler',
	'sd_createfilter_name' => 'At:',
	'sd_filter_freetext' => 'tekst',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'semanticdrilldown-desc' => 'Isang pambutas ("pambarena") na ugnayang-hangganan para sa paglilibot sa kahabaan ng datong semantiko (hinggil sa kahulugan ng salita)',
	'specialpages-group-sd_group' => 'Semantikong Pababang Pagbubutas ("Pagbabarena")',
	'browsedata' => 'Tumingin-tingin sa dato',
	'sd_browsedata_choosecategory' => 'Pumili ng isang kaurian (kategorya)',
	'sd_browsedata_viewcategory' => 'tingnan ang kaurian',
	'sd_browsedata_docu' => 'Pindutin ang isa o mahigit pang mga bagay na nasa ibaba upang mapakipot/mapakaunti pa ang mga kinalabasan.',
	'sd_browsedata_subcategory' => 'Kabahaging kaurian',
	'sd_browsedata_other' => 'Iba pa',
	'sd_browsedata_none' => 'Wala',
	'sd_browsedata_filterbyvalue' => 'Salain sa pamamagitan ng ganitong halaga',
	'sd_browsedata_filterbysubcategory' => 'Salain sa pamamagitan ng ganitong kabahaging kaurian',
	'sd_browsedata_otherfilter' => 'Ipakita ang mga pahinang may iba pang halaga para sa ganitong pansala',
	'sd_browsedata_nonefilter' => 'Ipakita ang mga pahinang walang halaga para sa pansalang ito',
	'sd_browsedata_or' => 'o',
	'sd_browsedata_removefilter' => 'Tanggalin ang pansalang ito',
	'sd_browsedata_removesubcategoryfilter' => 'Tanggalin ang ganitong pansala ng kabahaging kaurian',
	'sd_browsedata_resetfilters' => 'Muling itakda ang mga pansala',
	'sd_browsedata_addanothervalue' => 'Pindutin ang palaso upang makapagdagdag ng ibang halaga',
	'sd_browsedata_daterangestart' => 'Simula:',
	'sd_browsedata_daterangeend' => 'Wakas:',
	'sd_browsedata_novalues' => 'Walang mga halaga para sa pansalang ito',
	'filters' => 'Mga pansala',
	'sd_filters_docu' => 'Umiiral ang sumusunod na mga pansala sa loob ng {{SITENAME}}:',
	'createfilter' => 'Lumikha ng isang pansala',
	'sd_createfilter_name' => 'Pangalan:',
	'sd_createfilter_property' => 'Pag-aaring nasasakop ng pansalang ito:',
	'sd_createfilter_usepropertyvalues' => 'Gamitin ang lahat ng mga halaga ng pag-aaring ito para sa pansalang ito',
	'sd_createfilter_usecategoryvalues' => 'Kumuha ng mga halaga para sa pansala mula sa kauriang ito:',
	'sd_createfilter_usedatevalues' => 'Gamitin ang mga saklaw ng petsa para sa pansalang ito na may ganitong sakop ng kapanahunan:',
	'sd_createfilter_entervalues' => 'Kinakamay na ipasok ang mga halaga para sa pansala (dapat na pinaghihiwahiwalay ng mga kuwit ang mga halaga - kung naglalaman ng kuwit ang isang halaga, palitan ito ng "\\,"):',
	'sd_createfilter_inputtype' => 'Uri ng pampasok/pinapasok para sa pansalang ito:',
	'sd_createfilter_listofvalues' => 'talaan ng mga halaga (likas na nakatakda)',
	'sd_createfilter_requirefilter' => 'Pilitin ang iba pang pansala na mapili bago ipakita ang isang ito:',
	'sd_createfilter_label' => 'Tatak para pansalang ito (maaaring wala nito):',
	'sd_blank_error' => 'hindi maaaring walang laman/patlang',
	'sd_filter_coversproperty' => 'Nasasakop ng pansalang ito ang ari-ariang $1.',
	'sd_filter_getsvaluesfromcategory' => 'Kumukuha ito ng sarili niyang mga halaga mula sa kauriang $1.',
	'sd_filter_usestimeperiod' => 'Ginagamit nito ang $1 bilang saklaw ng kapanahunan.',
	'sd_filter_year' => 'Taon',
	'sd_filter_month' => 'Buwan',
	'sd_filter_hasvalues' => 'Mayroon itong mga halagang $1.',
	'sd_filter_hasinputtype' => 'Mayroon itong uri ng pagpasok/ipinasok na $1.',
	'sd_filter_combobox' => 'kahong pangkombo',
	'sd_filter_freetext' => 'teksto',
	'sd_filter_daterange' => 'saklaw ng petsa',
	'sd_filter_requiresfilter' => 'Kinakailangan nito ang pagkakaroon ng pansalang $1.',
	'sd_filter_haslabel' => 'Mayroon itong tatak na $1.',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'browsedata' => 'Verilere gözat',
	'sd_browsedata_choosecategory' => 'Bir kategori seç',
	'sd_browsedata_viewcategory' => 'kategoriyi gör',
	'sd_browsedata_subcategory' => 'Alt kategori',
	'sd_browsedata_other' => 'Diğer',
	'sd_browsedata_none' => 'Hiçbiri',
	'sd_browsedata_removesubcategoryfilter' => 'Bu alt kategori filtresini kaldır',
	'sd_browsedata_resetfilters' => 'Filtreleri sıfırla',
	'sd_browsedata_daterangestart' => 'Başlangıç:',
	'sd_browsedata_daterangeend' => 'Bitiş:',
	'sd_browsedata_novalues' => 'Bu filtre için değer yok',
	'filters' => 'Filtreler',
	'createfilter' => 'Bir filtre oluştur',
	'sd_createfilter_name' => 'İsim:',
	'sd_createfilter_property' => 'Bu filtrenin kapsadığı özellik:',
	'sd_createfilter_inputtype' => 'Bu filtre için girdi türü:',
	'sd_createfilter_label' => 'Bu filtre için etiket (opsiyonel):',
	'sd_filter_year' => 'Yıl',
	'sd_filter_month' => 'Ay',
	'sd_filter_combobox' => 'kombo kutu',
	'sd_filter_freetext' => 'metin',
	'sd_filter_daterange' => 'tarih aralığı',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'sd_browsedata_choosecategory' => 'Виберіть категорію',
	'sd_browsedata_viewcategory' => 'перегляд категорії',
	'sd_browsedata_subcategory' => 'Підкатегорія',
	'sd_browsedata_other' => 'Інші',
	'sd_browsedata_or' => 'або',
	'sd_browsedata_addanothervalue' => 'Натисніть на стрілку, щоб додати інше значення',
	'sd_browsedata_daterangestart' => 'Початок:',
	'sd_browsedata_daterangeend' => 'Кінець:',
	'filters' => 'Фільтри',
	'createfilter' => 'Створити фільтр',
	'sd_createfilter_name' => 'Назва:',
	'sd_blank_error' => 'не може бути порожнім',
	'sd_filter_year' => 'Рік',
	'sd_filter_month' => 'Місяць',
	'sd_filter_freetext' => 'текст',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'sd_browsedata_viewcategory' => 'nähta kategorii',
	'sd_browsedata_other' => 'Toižed',
	'sd_browsedata_none' => 'Ei ole',
	'sd_browsedata_or' => 'vai',
	'sd_browsedata_daterangestart' => 'Aug:',
	'sd_browsedata_daterangeend' => 'Lop:',
	'filters' => "Fil'trad",
	'sd_filters_docu' => "{{SITENAME}}-wikiš om ningoižed fil'troid:",
	'createfilter' => "Säta fil'tr",
	'sd_createfilter_name' => 'Nimi:',
	'sd_filter_year' => "Voz'",
	'sd_filter_month' => 'Ku',
	'sd_filter_freetext' => 'tekst',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'browsedata' => 'Duyệt dữ liệu',
	'sd_browsedata_choosecategory' => 'Chọn một thể loại',
	'sd_browsedata_viewcategory' => 'xem thể loại',
	'sd_browsedata_subcategory' => 'Tiểu thể loại',
	'sd_browsedata_other' => 'Khác',
	'sd_browsedata_none' => 'Không có',
	'sd_browsedata_filterbyvalue' => 'Lọc theo giá trị này',
	'sd_browsedata_filterbysubcategory' => 'Lọc theo tiểu thể loại này',
	'sd_browsedata_otherfilter' => 'Hiển thị trang với giá trị khác cho bộ lọc này',
	'sd_browsedata_nonefilter' => 'Hiển thị không có giá trị nào đối với bộ lọc này',
	'sd_browsedata_or' => 'hoặc',
	'sd_browsedata_removefilter' => 'Bỏ bộ lọc này',
	'sd_browsedata_removesubcategoryfilter' => 'Bỏ bộ lọc tiểu thể loại này',
	'sd_browsedata_resetfilters' => 'Tái tạo bộ lọc',
	'sd_browsedata_addanothervalue' => 'Nhấn chuột vào tên mũi để thêm giá trị khác',
	'sd_browsedata_daterangestart' => 'Bắt đầu:',
	'sd_browsedata_daterangeend' => 'Kết thúc:',
	'filters' => 'Bộ lọc',
	'sd_filters_docu' => 'Bộ lọc sau tồn tại trong {{SITENAME}}:',
	'createfilter' => 'Tạo bộ lọc',
	'sd_createfilter_name' => 'Tên:',
	'sd_createfilter_property' => 'Tính chất bộ lọc này bao phủ:',
	'sd_createfilter_usepropertyvalues' => 'Sử dụng tất cả các giá trị của thuộc tính này cho bộ lọc',
	'sd_createfilter_usecategoryvalues' => 'Lấy giá trị cho bộ lọc từ thể loại này:',
	'sd_createfilter_usedatevalues' => 'Sử dụng khoảng ngày cho bộ lọc này với khoảng thời gian này:',
	'sd_createfilter_entervalues' => 'Nhập bằng tay giá trị cho bộ lọc (giá trị nên được phân tách bằng dấu phẩy - nếu một giá trị có chứa dấu phẩy, hãy thay nó bằng "\\,"):',
	'sd_createfilter_listofvalues' => 'danh sách giá trị (mặc định)',
	'sd_createfilter_requirefilter' => 'Cần bộ lọc khác được chọn trước khi hiển thị cái này:',
	'sd_createfilter_label' => 'Đánh nhãn cho bộ lọc này (tùy chọn):',
	'sd_blank_error' => 'không được để trống',
	'sd_filter_coversproperty' => 'Bộ lọc này bao phủ thuộc tính $1.',
	'sd_filter_getsvaluesfromcategory' => 'Nó có giá trị từ thể loại $1.',
	'sd_filter_usestimeperiod' => 'Nó sử dụng $1 làm khoảng thời gian.',
	'sd_filter_year' => 'Năm',
	'sd_filter_month' => 'Tháng',
	'sd_filter_hasvalues' => 'Nó có giá trị $1.',
	'sd_filter_freetext' => 'văn bản',
	'sd_filter_requiresfilter' => 'Nó yêu cầu sự hiện diện của bộ lọc $1.',
	'sd_filter_haslabel' => 'Nó có nhãn $1.',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'browsedata' => 'Padön da nünods',
	'sd_browsedata_choosecategory' => 'Välön kladi',
	'sd_browsedata_viewcategory' => 'logön kladi',
	'sd_browsedata_subcategory' => 'Donaklad',
	'sd_browsedata_other' => 'Votik',
	'sd_browsedata_none' => 'Nonik',
	'sd_browsedata_filterbyvalue' => 'Sulön ma völad at',
	'sd_browsedata_filterbysubcategory' => 'Sulön ma donaklad at',
	'sd_browsedata_otherfilter' => 'Jonön padis labü völadi votik tefü sul at',
	'sd_browsedata_nonefilter' => 'Jonön padis labü völad nonik tefü sul at',
	'sd_browsedata_or' => 'u',
	'sd_browsedata_removefilter' => 'Moükön suli at',
	'sd_browsedata_removesubcategoryfilter' => 'Moükön donakladasuli at',
	'sd_browsedata_resetfilters' => 'Geükön sulis ad stad kösömik',
	'sd_browsedata_addanothervalue' => 'Läükön völadi votik',
	'sd_browsedata_daterangestart' => 'Prim:',
	'sd_browsedata_daterangeend' => 'Fin:',
	'filters' => 'Suls',
	'sd_filters_docu' => 'Suls sököl dabinons in {{SITENAME}}:',
	'createfilter' => 'Jafön suli',
	'sd_createfilter_name' => 'Nem:',
	'sd_createfilter_property' => 'Patöf fa sul at pageböl:',
	'sd_createfilter_usepropertyvalues' => 'Gebön völadis valik patöfa at pro sul.',
	'sd_createfilter_usecategoryvalues' => 'Tuvön völadis pro sul in klad at:',
	'sd_createfilter_entervalues' => 'Penön me nams völadis pro sul (völads mutons pateilön fa liunüls - if völad semik ninädon liunüli, plaädolös oni me "\\,"):',
	'sd_createfilter_listofvalues' => 'völadalised (kösömik)',
	'sd_createfilter_requirefilter' => 'Flagön, das sul votik puvälon büä sul at pojonon:',
	'sd_createfilter_label' => 'Nem sula at (no paflagöl):',
	'sd_blank_error' => 'no dalon vagön',
	'sd_filter_coversproperty' => 'Sul at tefon patöfi: $1.',
	'sd_filter_getsvaluesfromcategory' => 'Tuvon völadis okik in klad: $1.',
	'sd_filter_usestimeperiod' => 'Gebon $1 as timadul okik.',
	'sd_filter_year' => 'Yel',
	'sd_filter_month' => 'Mul',
	'sd_filter_hasvalues' => 'Labon völadis: $1.',
	'sd_filter_freetext' => 'vödem',
	'sd_filter_requiresfilter' => 'Flagon komi sula: $1.',
	'sd_filter_haslabel' => 'Labon nemi: $1.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'sd_browsedata_other' => 'אנדער',
	'sd_browsedata_none' => 'קיין',
	'sd_createfilter_name' => 'נאָמען:',
	'sd_filter_freetext' => 'טעקסט',
);

/** Chinese (China) (‪中文(中国大陆)‬)
 * @author Roc Michael
 */
$messages['zh-cn'] = array(
	'browsedata' => '查看资料',
	'sd_browsedata_choosecategory' => '选取某项分类(category)',
	'sd_browsedata_viewcategory' => '查看分类页面',
	'sd_browsedata_subcategory' => '子分类',
	'sd_browsedata_other' => '其他的',
	'sd_browsedata_none' => '无',
	'filters' => '筛选器',
	'sd_filters_docu' => '此wiki系统内已设有如下的筛选器(filters)',
	'createfilter' => '建立筛选器',
	'sd_createfilter_name' => '名称：',
	'sd_createfilter_property' => '此一筛选器所涵盖的性质：',
	'sd_createfilter_usepropertyvalues' => '将此一性质的值设给筛选器所用',
	'sd_createfilter_usecategoryvalues' => '从此分类中为筛选器取得筛选值：',
	'sd_createfilter_usedatevalues' => '以此一期间为此筛选器设置日期范围值：',
	'sd_createfilter_entervalues' => '以手工的方式键入筛选器的筛选值(其值必须以半型逗号","分隔，如果您的输入值内包含半型逗号则须则"\\,"取代):',
	'sd_createfilter_requirefilter' => '在此一筛选器展示其作用之前要求须选取其他的筛选器：',
	'sd_createfilter_label' => '为此一筛选选器设置标签(选择性的)：',
	'sd_blank_error' => '不得为空白',
	'sd_filter_coversproperty' => '此筛选器涵盖了$1性质。',
	'sd_filter_getsvaluesfromcategory' => '其从$1分类取得它的值。',
	'sd_filter_usestimeperiod' => '其使用「$1」做为时间期限值',
	'sd_filter_year' => '年',
	'sd_filter_month' => '月',
	'sd_filter_hasvalues' => '其有着$1的这些值。',
	'sd_filter_requiresfilter' => '其以$1筛选器为基础。',
	'sd_filter_haslabel' => '其有着此一$1标签',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'browsedata' => '浏览数据',
	'sd_browsedata_other' => '其他',
	'sd_browsedata_none' => '无',
	'sd_browsedata_or' => '或',
	'sd_browsedata_daterangestart' => '开始：',
	'sd_browsedata_daterangeend' => '结束：',
	'filters' => '过滤器',
	'sd_createfilter_name' => '名称：',
	'sd_blank_error' => '不可留空',
	'sd_filter_year' => '年',
	'sd_filter_month' => '月',
	'sd_filter_freetext' => '文字',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'browsedata' => '瀏覽數據',
	'sd_browsedata_choosecategory' => '選擇一個分類',
	'sd_browsedata_viewcategory' => '檢視分類',
	'sd_browsedata_docu' => '點擊下面的一個或多個項目來縮小您的結果。',
	'sd_browsedata_other' => '其他',
	'sd_browsedata_none' => '無',
	'sd_browsedata_or' => '或',
	'sd_browsedata_daterangestart' => '開始：',
	'sd_browsedata_daterangeend' => '結束：',
	'filters' => '過濾器',
	'sd_createfilter_name' => '名稱：',
	'sd_blank_error' => '不可留空',
	'sd_filter_year' => '年',
	'sd_filter_month' => '月',
	'sd_filter_freetext' => '文字',
	'sd_filter_daterange' => '日期範圍',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'browsedata' => '瀏覽資料',
	'sd_browsedata_choosecategory' => '選取某項分類(category)',
	'sd_browsedata_viewcategory' => '查看分類頁面',
	'sd_browsedata_docu' => '選取1項或多項以限制輸出的結果',
	'sd_browsedata_subcategory' => '子分類',
	'sd_browsedata_other' => '其他的',
	'sd_browsedata_none' => '無',
	'sd_browsedata_filterbyvalue' => '依此值設置篩選器',
	'sd_browsedata_filterbysubcategory' => '依此子分類(subcategory)設置篩選器',
	'sd_browsedata_otherfilter' => '查看屬於此篩選器中其他值的頁面，',
	'sd_browsedata_nonefilter' => '查看此篩選器設置條件中無任何值的頁面',
	'sd_browsedata_or' => '或',
	'sd_browsedata_removefilter' => '移除此篩選器',
	'sd_browsedata_removesubcategoryfilter' => '移除此子分類(subcategory)篩選器',
	'sd_browsedata_resetfilters' => '重置篩選器',
	'sd_browsedata_addanothervalue' => '增加其他值',
	'sd_browsedata_daterangestart' => '起始於：',
	'sd_browsedata_daterangeend' => '結束於：',
	'filters' => '篩選器',
	'sd_filters_docu' => '此wiki系統內已設有如下的篩選器(filters)',
	'createfilter' => '建立篩選器',
	'sd_createfilter_name' => '名稱：',
	'sd_createfilter_property' => '此一篩選器所涵蓋的性質：',
	'sd_createfilter_usepropertyvalues' => '將此一性質的值設給篩選器所用',
	'sd_createfilter_usecategoryvalues' => '從此分類中為篩選器取得篩選值：',
	'sd_createfilter_usedatevalues' => '以此一期間為此篩選器設置日期範圍值：',
	'sd_createfilter_entervalues' => '以手工的方式鍵入篩選器的篩選值(其值必須以半型逗號","分隔，如果您的輸入值內包含半型逗號則須則"\\,"取代):',
	'sd_createfilter_inputtype' => '為此篩選器輸入型態：',
	'sd_createfilter_listofvalues' => '列出值(預設)',
	'sd_createfilter_requirefilter' => '在此一篩選器展示其作用之前要求須選取其他的篩選器(即此一篩選器的作用係以另一篩選器為其基礎)：',
	'sd_createfilter_label' => '為此一篩選選器設定標籤(選擇性的)：',
	'sd_blank_error' => '不得為空白',
	'sd_filter_coversproperty' => '此篩選器涵蓋了$1性質。',
	'sd_filter_getsvaluesfromcategory' => '其從$1分類取得它的值。',
	'sd_filter_usestimeperiod' => '其使用「$1」做為時間期限值',
	'sd_filter_year' => '年',
	'sd_filter_month' => '月',
	'sd_filter_hasvalues' => '其有著$1的這些值。',
	'sd_filter_hasinputtype' => '其已有「$1」的輸入的型態了。',
	'sd_filter_freetext' => '文字',
	'sd_filter_daterange' => '資料範圍',
	'sd_filter_requiresfilter' => '其以$1篩選器為基礎。',
	'sd_filter_haslabel' => '其有著此一$1標籤',
);

