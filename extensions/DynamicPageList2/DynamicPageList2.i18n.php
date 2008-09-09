<?php
/**
 * Internationalization file for DynamicPageList2 extension.
 *
 * @addtogroup Extensions
 * @author m:User:Dangerman <cyril.dangerville@gmail.com>
*/

$wgDPL2Messages = array();

/**
 * To translate messages into your language, create a $wgDPL2Messages['lang'] array where 'lang' is your language code and take $wgDPL2Messages['en'] as a model. Replace values with appropriate translations.
 */

$wgDPL2Messages['en'] = array(
	'dpl2-desc' => 'Hack of the original [http://www.mediawiki.org/wiki/Extension:DynamicPageList DynamicPageList] extension featuring many Improvements',
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "Error: Wrong '$0' parameter: '$1'! Help:  <code>$0= <i>empty string</i> (Main)$3</code>. (Equivalents with magic words are allowed too.)",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "Error: Wrong '$0' parameter: '$1'! Help:  <code>$0= <i>full pagename</i></code>. (Magic words are allowed.)",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'Error: Too many categories! Maximum: $0. Help: increase <code>$wgDPL2MaxCategoryCount</code> to specify more categories or set <code>$wgDPL2AllowUnlimitedCategories=true</code> for no limitation. (Set the variable in <code>LocalSettings.php</code>, after including <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'Error: Too few categories! Minimum: $0. Help: decrease <code>$wgDPL2MinCategoryCount</code> to specify fewer categories. (Set the variable preferably in <code>LocalSettings.php</code>, after including <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "Error: You need to include at least one category if you want to use 'addfirstcategorydate=true' or 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "Error: If you include more than one category, you cannot use 'addfirstcategorydate=true' or 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'Error: You cannot add more than one type of date at a time!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "Error: You can use '$0' with 'ordermethod=[...,]$1' only!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "Error: Cannot perform logical operations on the Uncategorized pages (e.g. with the 'category' parameter) because the $0 view does not exist on the database! Help: have the DB admin execute this query: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "Warning: Unknown parameter '$0' is ignored. Help: available parameters: <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "Warning: Wrong '$0' parameter: '$1'! Using default: '$2'. Help: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "Warning: Wrong '$0' parameter: '$1'! Using default: '$2' (no limit). Help: <code>$0= <i>empty string</i> (no limit) | n</code>, with <code>n</code> a positive integer.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'Warning: No results!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "Warning: Add* parameters ('adduser', 'addeditdate', etc.)' and 'includepage' have no effect with 'mode=category'. Only the page namespace/title can be viewed in this mode.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "Warning: 'headingmode=$0' has no effect with 'ordermethod' on a single component. Using: '$1'. Help: you can use not-$1 'headingmode' values with 'ordermethod' on multiple components. The first component is used for headings. E.g. 'ordermethod=category,<i>comp</i>' (<i>comp</i> is another component) for category headings.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "Warning: 'debug=$0' is not in first position in the DPL element. The new debug settings are not applied before all previous parameters have been parsed and checked.",
	/**
	 * $0: title of page that creates an infinite transclusion loop
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "Warning: An infinite transclusion loop is created by page '$0'.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'Query: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'There {{PLURAL:$1|is one article|are $1 articles}} in this heading.'
);

$wgDPL2Messages['ar'] = array(
	'dpl2-desc' => 'تعديل على امتداد [http://www.mediawiki.org/wiki/Extension:DynamicPageList DynamicPageList] الأصلي بالعديد من التحسينات',
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "خطأ: محدد '$0' خاطئ: '$1'! مساعدة:  <code>$0= <i>سلسلة فارغة</i> (رئيسي)$3</code>. (المساويات مع الكلمات السحرية مسموح بها أيضا.)",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "خطأ: محدد '$0' خاطئ: '$1'! مساعدة:  <code>$0= <i>اسم الصفحة الكامل</i></code>. (الكلمات السحرية مسموح بها.)",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'خطأ: تصنيفات كثيرة جدا! الحد الأقصى: $0. مساعدة: زد <code>$wgDPL2MaxCategoryCount</code> لتحديد المزيد من التصنيفات أو اضبط <code>$wgDPL2AllowUnlimitedCategories=true</code> للا حد. (اضبط المتغير في <code>LocalSettings.php</code>, بعد تضمين <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'خطأ: تصنيفات قليلة جدا! الحد الأدنى: $0. مساعدة: قلل <code>$wgDPL2MinCategoryCount</code> لتحديد عدد أقل من التصنيفات. (اضبط المتغير مفضلا في <code>LocalSettings.php</code>, بعد تضمين <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "خطأ: تحتاج إلى أن تضمن على الأقل تصنيفا واجدا إذا كنت تريد استخدام 'addfirstcategorydate=true' او 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "خطأ: إذا قمت بتضمين أكثر من تصنيف واحد, لا يمكنك استخدام 'addfirstcategorydate=true' أو 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'خطأ: لا يمكنك إضافة أكثر من نوع واحد من البيانات في المرة!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "خطأ: يمكنك استخدام '$0' مع 'ordermethod=[...,]$1' فقط!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "خطأ: لم يمكن عمل عمليات منطقية على الصفحات غير المصنفة (على سبيل المثال مع محدد 'category') لأن رؤية $0 غير موجودة في قاعدة البيانات! مساعدة: اجعل إداري قاعدة البيانات ينفذ هذا الاستعلام: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "تحذير: المحدد غير المعروف '$0' يتم تجاهله. مساعدة: المحددات المتوفرة: <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "تحذير: محدد '$0' خاطئ: '$1'! استخدام الافتراضي: '$2'. مساعدة: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "تحذير: محدد '$0' خاطئ: '$1'! استخدام الافتراضي: '$2' (لا حد). مساعدة: <code>$0= <i>سلسلة فارغة</i> (لا حد) | n</code>، مع <code>n</code> عدد صحيح موجب.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'تحذير: لا نتائج!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "تحذير: أضف المحددات ('adduser', 'addeditdate', إلى آخره)' و 'includepage' ليس لها تاثير مع 'mode=category'. فقط نظاق/عنوان الصفحة يمكن رؤيتها في هذا النمط.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "تحذير: 'headingmode=$0' ليس له تاثير مع 'ordermethod' على مكون واحد. استخدام قيم: '$1'. مساعدة: you can use not-$1 'headingmode' مع 'ordermethod' على مكونات متعددة. المكون الأول يتم استخدامه للعناوين. على سبيل المثال 'ordermethod=category,<i>comp</i>' (<i>comp</i> مكون آخر) لعناوين التصنيفات.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "تحذير: 'debug=$0' ليس في الموضع الأول في عنصر DPL. إعدادات التصحيح الجديدة لا يتم تطبيقها قبل أن يتم التحقق من كل المحددات السابقة.",
	/**
	 * $0: title of page that creates an infinite transclusion loop
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "تحذير: لفة تضمين لا نهائية تم إنشاؤها بواسطة الصفحة '$0'.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'استعلام: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'توجد {{PLURAL:$1|مقالة واحدة|$1 مقالة}} في هذا العنوان.'
);

$wgDPL2Messages['arz'] = array(
	'dpl2-desc' => 'تعديل على امتداد [http://www.mediawiki.org/wiki/Extension:DynamicPageList DynamicPageList] الأصلى بالعديد من التحسينات',
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "خطأ: محدد '$0' خاطئ: '$1'! مساعدة:  <code>$0= <i>سلسلة فارغة</i> (رئيسى)$3</code>. (المساويات مع الكلمات السحرية مسموح بها أيضا.)",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "خطأ: محدد '$0' خاطئ: '$1'! مساعدة:  <code>$0= <i>اسم الصفحة الكامل</i></code>. (الكلمات السحرية مسموح بها.)",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'خطأ: تصنيفات كتيرة أوى! الحد الأقصى: $0. مساعدة: زد <code>$wgDPL2MaxCategoryCount</code> لتحديد المزيد من التصنيفات أو اضبط <code>$wgDPL2AllowUnlimitedCategories=true</code> للا حد. (اضبط المتغير في <code>LocalSettings.php</code>, بعد تضمين <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'خطأ: تصنيفات قليلة أوى! الحد الأدنى: $0. مساعدة: قلل <code>$wgDPL2MinCategoryCount</code> لتحديد عدد أقل من التصنيفات. (اضبط المتغير مفضلا فى <code>LocalSettings.php</code>, بعد تضمين <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "خطأ: تحتاج إلى أن تضمن على الأقل تصنيفا واجدا إذا كنت تريد استخدام 'addfirstcategorydate=true' او 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "خطأ: إذا قمت بتضمين أكثر من تصنيف واحد، لا يمكنك استخدام 'addfirstcategorydate=true' أو 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'خطأ: لا يمكنك إضافة أكثر من نوع واحد من البيانات فى المرة!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "خطأ: يمكنك استخدام '$0' مع 'ordermethod=[...,]$1' فقط!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "خطأ: لم يمكن عمل عمليات منطقية على الصفحات غير المصنفة (على سبيل المثال مع محدد 'category') لأن رؤية $0 غير موجودة فى قاعدة البيانات! مساعدة: اجعل إدارى قاعدة البيانات ينفذ هذا الاستعلام: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "تحذير: المحدد غير المعروف '$0' يتم تجاهله. مساعدة: المحددات المتوفرة: <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "تحذير: محدد '$0' خاطئ: '$1'! استخدام الافتراضي: '$2'. مساعدة: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "تحذير: محدد '$0' خاطئ: '$1'! استخدام الافتراضي: '$2' (لا حد). مساعدة: <code>$0= <i>سلسلة فارغة</i> (لا حد) | n</code>، مع <code>n</code> عدد صحيح موجب.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'تحذير: لا نتائج!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "تحذير: أضف المحددات ('adduser', 'addeditdate', إلى آخره)' و 'includepage' ليس لها تاثير مع 'mode=category'. فقط نظاق/عنوان الصفحة يمكن رؤيتها فى هذا النمط.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "تحذير: 'headingmode=$0' ليس له تاثير مع 'ordermethod' على مكون واحد. استخدام قيم: '$1'. مساعدة: you can use not-$1 'headingmode' مع 'ordermethod' على مكونات متعددة. المكون الأول يتم استخدامه للعناوين. على سبيل المثال 'ordermethod=category,<i>comp</i>' (<i>comp</i> مكون آخر) لعناوين التصنيفات.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "تحذير: 'debug=$0' ليس فى الموضع الأول فى عنصر DPL. إعدادات التصحيح الجديدة لا يتم تطبيقها قبل أن يتم التحقق من كل المحددات السابقة.",
	/**
	 * $0: title of page that creates an infinite transclusion loop
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "تحذير: لفة تضمين لا نهائية تم إنشاؤها بواسطة الصفحة '$0'.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'استعلام: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'توجد {{PLURAL:$1|مقالة واحدة|$1 مقالة}} فى هذا العنوان.'
);

$wgDPL2Messages['de'] = array(
	'dpl2-desc' => 'Erweiterung der [http://www.mediawiki.org/wiki/Extension:DynamicPageList DynamicPageList] mit vielen Verbesserungen',
);

$wgDPL2Messages['fr'] = array(
	'dpl2-desc' => 'Reprise de l’extension originale [http://www.mediawiki.org/wiki/Extension:DynamicPageList DynamicPageList] avec des fonctionnalités supplémentaires.',
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "ERREUR : Mauvais paramètre '$0' : '$1'! Aide :  <code>$0= <i>chaîne vide</i> (Principal)$3</code>. (Les équivalents avec des mots magiques sont aussi autorisés.)",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "ERREUR : Mauvais paramètre '$0' : '$1'! Aide :  <code>$0= <i>Nom complet de la page</i></code>. (Les mots magiques sont autorisés.)",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'ERREUR : Trop de catégories ! Maximum : $0. Aide : accroître <code>$wgDPL2MaxCategoryCount</code> pour autoriser plus de catégories ou régler <code>$wgDPL2AllowUnlimitedCategories=true</code> pour aucune limite. (À régler dans <code>LocalSettings.php</code>, après avoir inclus <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'ERREUR : Pas assez de catégories ! Minimum : $0. Aide : décroître <code>$wgDPL2MinCategoryCount</code> pour autoriser moins de catégories. (À régler dans <code>LocalSettings.php</code> de préférence, après avoir inclus <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "ERREUR : Vous devez inclure au moins une catégorie si vous voulez utiliser 'addfirstcategorydate=true' ou 'ordermethod=categoryadd' !",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "ERREUR : Si vous incluez plus d’une catégorie, vous ne pouvez pas utiliser 'addfirstcategorydate=true' ou 'ordermethod=categoryadd' !",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'ERREUR : Vous ne pouvez pas utiliser plus d’un type de date à la fois !',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "ERREUR : Vous ne pouvez utiliser '$0' qu’avec 'ordermethod=[...,]$1' !",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "ERREUR : Ne peut pas effectuer d’opérations logiques sur les pages sans catégories (avec la paramètre 'category') car la vue $0 n’existe pas dans la base de données ! Aide : demander à un administrateur de la base de données d'effectuer : <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "AVERTISSEMENT : Le paramètre inconnu '$0' est ignoré. Aide : paramètres disponibles : <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "AVERTISSEMENT : Mauvais paramètre '$0' : '$1'! Utilisation de la valeur par défaut : '$2'. Aide : <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "AVERTISSEMENT : Mauvais paramètre '$0' : '$1'! Utilisattion de la valeur par défaut : '$2' (aucune limite). Aide : <code>$0= <i>chaîne vide</i> (aucune limite) | n</code>, avec <code>n</code> un entier positif.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'AVERTISSEMENT : Aucun résultat !',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "AVERTISSEMENT : Les paramètres Add* ('adduser', 'addeditdate', etc.)' et 'includepage' n’ont aucun effet avec 'mode=category'. Seuls l’espace de nom et le titre de la page peuvent être vus dans ce mode..",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "AVERTISSEMENT : 'headingmode=$0' n'a aucun effet avec 'ordermethod' sur une simple composante. Utiliser : '$1'. Aide : vous pouvez utiliser not-$1  sur les valeurs de 'headingmode' avec 'ordermethod' sur plusieurs composantes.  La première composante est utilisée pour les en-têtes. Exemple : 'ordermethod=category,<i>comp</i>' (<i>comp</i> est une autre composante) pour les en-têtes de catégorie.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "AVERTISSEMENT : 'debug=$0' n’est pas en première position dans l’élément DPL. Les nouveaux réglages de débogage ne seront appliqués qu’après que les paramètres précédents aient été vérifiés.",
	/**
	 * $0: title of page that creates an infinite transclusion loop
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "AVERTISSEMENT : Une boucle d’inclusion infinie est créée par la page '$0'.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'REQUÊTE : <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'Il y a {{PLURAL:$1|un article|$1 articles}} dans cette section.'
);
$wgDPL2Messages['he'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "שגיאה: פרמטר '$0' שגוי: '$1'! עזרה: <code>$0= <i>מחרוזת ריקה</i> (ראשי)$3</code>. (ניתן להשתמש גם בשווי ערך באמצעות מילות קסם.)",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "שגיאה: פרמטר '$0' שגוי: '$1'! עזרה: <code>$0= <i>שם הדף המלא</i></code>. (ניתן להשתמש במילות קסם.)",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'שגיאה: קטגוריות רבות מדי! מקסימום: $0. עזרה: העלו את <code>$wgDPL2MaxCategoryCount</code> כדי לציין עוד קטגוריות או הגדירו <code>$wgDPL2AllowUnlimitedCategories=true</code> כדי לבטל את ההגבלה. (הגידרו את המשתנה בקובץ <code>LocalSettings.php</code>, לאחר הכללת <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'שגיאה: קטגוריות מעטות מדי! מינימום: $0. עזרה: הורידו את <code>$wgDPL2MinCategoryCount</code> כדי לציין פחות קטגוריות. (הגידרו את המשתנה בקובץ <code>LocalSettings.php</code>, לאחר הכללת <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "שגיאה: עליכם להכליל לפחות קטגוריה אחת אם ברצונכם להשתמש ב־'addfirstcategorydate=true' או ב־'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "שגיאה: אם אתם מכלילים יותר מקטגוריה אחת, אינכם יכולים להשתמש ב־'addfirstcategorydate=true' או ב־'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'שגיאה: אינכם יכולים להוסיף יותר מסוג אחד של תאריך בו זמנית!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "שגיאה: באפשרותכם להשתמש ב־'$0' עם 'ordermethod=[...,]$1' בלבד!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "שגיאה: לא ניתן לבצע פעולות לוגיות על דפים ללא קטגוריות (למשל, עם הפרמטר 'קטגוריה') כיוון שתצוגת $0 אינה קיימת במסד הנתונים! עזרה: מנהל מסד הנתונים צריך להריץ את השאילתה: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "אזהרה: בוצעה התעלמות מהפרמטר הלא ידוע '$0'. עזרה: פרמטרים זמינים: <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "אזהרה: פרמטר '$0' שגוי: '$1'! משתמש בברירת המחדל: '$2'. עזרה: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "אזהרה: פרמטר '$0' שגוי: '$1'! משתמש בברירת המחדל: '$2' (ללא הגבלה). עזרה: <code>$0= <i>מחרוזת ריקה</i> (ללא הגבלה) | n</code>, עם <code>n</code> כמספר שלם וחיובי.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'אזהרה: אין תוצאות!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "אזהרה: להוספת* הפרמטרים ('adduser',‏ 'addeditdate' וכדומה) וכן ל־'includepage' אין השפעה עם 'mode=category'. ניתן לצפות רק במרחב השם או בכותרת הדף במצב זה.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "אזהרה: ל־'headingmode=$0' אין השפעה עם 'ordermethod' על פריט יחיד. משתמש ב: '$1'. עזרה: באפשרותכם להשתמש בערכים של 'headingmode' שאינם $1 עם 'ordermethod' על פריטים מרובים. משתמשים בפריט הראשון לכותרת. למשל, 'ordermethod=category,<i>comp</i>' (<i>comp</i> הוא פריט אחר) לכותרות הקטגוריה.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "אזהרה: 'debug=$0w הוא לא במקום הראשון ברכיב ה־DPL. הגדרות ניפוי השגיאות החדשות לא יחולו לפני שכל הפרמטרים הקודמים ינותחו וייבדקו.",
	/**
	 * $0: title of page that creates an infinite transclusion loop
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "אזהרה: לולאת הכללה אינסופית נוצרה בדף '$0'.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'שאילתה: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => '{{PLURAL:$1|ישנם $1 דפים|ישנו דף אחד}} תחת כותרת זו.'
);
$wgDPL2Messages['id'] = array(
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "KESALAHAN: Parameter '$0' salah: '$1'! Bantuan: <code>$0= <i>string kosong</i> (Utama)$3</code>. (Ekivalen kata kunci juga diizinkan.)",
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "KESALAHAN: Parameter '$0' salah: '$1'! Bantuan:  <code>$0= <i>nama lengkap halaman</i></code>. (Kata kunci diizinkan.)",
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'KESALAHAN: Kategori terlalu banyak! Maksimum: $0. Bantuan: perbesar <code>$wgDPL2MaxCategoryCount</code> untuk memberikan lebih banyak kategori atau atur  <code>$wgDPL2AllowUnlimitedCategories=true</code> untuk menghapus batasan. (Atur variabel tersebut di <code>LocalSettings.php</code>, setelah mencantumkan <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'KESALAHAN: Kategori terlalu sedikit! Minimum: $0. Bantuan: kurangi <code>$wgDPL2MinCategoryCount</code> untuk mengurangi kategori. (Atur variabel tersebut di <code>LocalSettings.php</code>, setelah mencantumkan <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "KESALAHAN: Anda harus memberikan paling tidak satu kategori jika menggunakan 'addfirstcategorydate=true' atau 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "KESALAHAN: Jika Anda memberikan lebih dari satu kategori, Anda tidak dapat menggunakan 'addfirstcategorydate=true' atau 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'KESALAHAN: Anda tidak dapat memberikan lebih dari satu jenis tanggal dalam satu waktu!',
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "KESALAHAN: Anda dapat menggunakan '$0' hanya dengan 'ordermethod=[...,]$1'!",
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "KESALAHAN: Tidak dapat melakukan operasi logika pada halaman yang tak terkategori (misalnya dengan parameter 'kategori') karena view $0 tidak ada di basis data! Bantuan: mintalah admin basis data untuk menjalankan kueri berikut: <code>$1</code>.",
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "KESALAHAN: Paramater yang tak dikenal '$0' diabaikan. Bantuan: parameter yang tersedia: <code>$1</code>.",
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "KESALAHAN: Parameter '$0' salah: '$1'! Menggunakan konfigurasi baku: '$2'. Bantuan: <code>$0= $3</code>.",
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "KESALAHAN: Parameter '$0' salah: '$1'! Menggunakan konfigurasi baku: '$2' (tanpa limitasi). Bantuan: <code>$0= <i>string kosong</i> (tanpa limitasi) | n</code>, dengan <code>n</code> suatu bilangan positif.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'KESALAHAN: Hasil tak ditemukan!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "KESALAHAN: Menambahkan * parameter ('adduser', 'addeditdate', dll.)' dan 'includepage' tidak berpengaruh pada 'mode=category'. Hanya ruang nama/judul halaman yang dapat ditampilkan dengan mode ini.",
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "KESALAHAN: 'headingmode=$0' tidak berpengaruh dengan 'ordermethod' pada suatu komponen tunggal. Menggunakan: '$1'. Bantuan: Anda dapat menggunakan nilai not-$1 'headingmode' dengan 'ordermethod' terhadap beberapa komponen. Komponen pertama digunakan sebagai judul. Misalnya 'ordermethod=category,<i>comp</i>' (<i>comp</i> adalah komponen lain) untuk judul kategori.",
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "KESALAHAN: 'debug=$0' tidak pada posisi pertama pada elemen DPL. Aturan debug tidak diterapkan sebelum semua variabel sebelumnya telah diparsing dan dicek.",
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "KESALAHAN: Suatu lingkaran transklusi tak hingga ditimbulkan oleh halaman '$0'.",
	'dpl2_debug_' . DPL2_QUERY => 'KUERI: <code>$0</code>',
	'dpl2_articlecount' => 'Terdapat {{PLURAL:$1|artikel|artikel}} dalam judul ini.'
);
$wgDPL2Messages['it'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "ERRORE nel parametro '$0': '$1'. Suggerimento:  <code>$0= <i>stringa vuota</i> (Principale)$3</code>. (Sono ammessi gli equivalenti con 'magic word'.)",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "ERRORE nel parametro '$0': '$1'. Suggerimento:  <code>$0= <i>nome completo della pagina</i></code>. (Sono ammesse le 'magic word'.)",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'ERRORE: Categorie sovrabbondanti (massimo $0). Suggerimento: aumentare il valore di <code>$wgDPL2MaxCategoryCount</code> per indicare un numero maggiore di categorie, oppure impostare <code>$wgDPL2AllowUnlimitedCategories=true</code> per non avere alcun limite. (Impostare le variabili nel file <code>LocalSettings.php</code>, dopo l\'inclusione di <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'ERRORE: Categorie insufficienti (minimo $0). Suggerimento: diminuire il valore di <code>$wgDPL2MinCategoryCount</code> per indicare un numero minore di categorie. (Impostare la variabile nel file <code>LocalSettings.php</code>, dopo l\'inclusione di <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "ERRORE: L'uso dei parametri 'addfirstcategorydate=true' e 'ordermethod=categoryadd' richiede l'inserimento di una o più categorie.",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "ERRORE: L'inserimento di più categorie impedisce l'uso dei parametri 'addfirstcategorydate=true' e 'ordermethod=categoryadd'.",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'ERRORE: Non è consentito l\'uso contemporaneo di più tipi di data.',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "ERRORE: L'uso del parametro '$0' è consentito unicamente con 'ordermethod=[...,]$1'.",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "ERRORE: Impossibile effettuare operazioni logiche sulle pagine prive di categoria (ad es. con il parametro 'category') in quanto il database non contiene la vista $0. Suggerimento: chiedere all'amministratore del database di eseguire la seguente query: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "ATTENZIONE: Il parametro non riconosciuto '$0' è stato ignorato. Suggerimento: i parametri disponibili sono: <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "ATTENZIONE: Errore nel parametro '$0': '$1'. È stato usato il valore predefinito '$2'. Suggerimento: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "ATTENZIONE: errore nel parametro '$0': '$1'. È stato usato il valore predefinito '$2' (nessun limite). Suggerimento: <code>$0= <i>stringa vuota</i> (nessun limite) | n</code>, con <code>n</code> intero positivo.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'ATTENZIONE: Nessun risultato.',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "ATTENZIONE: I parametri add* ('adduser', 'addeditdate', ecc.)' non hanno alcun effetto quando è specificato 'mode=category'. In tale modalità vengono visualizzati unicamente il namespace e il titolo della pagina.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "ATTENZIONE: Il parametro 'headingmode=$0' non ha alcun effetto quando è specificato 'ordermethod' su un solo componente. Verrà utilizzato il valore '$1'. Suggerimento: è posibile utilizzare i valori diversi da $1 per il parametro 'headingmode' nel caso di 'ordermethod' su più componenti. Il primo componente viene usato per generare i titoli di sezione. Ad es. 'ordermethod=category,<i>comp</i>' (dove <i>comp</i> è un altro componente) per avere titoli di sezione basati sulla categoria.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "ATTENZIONE: Il parametro 'debug=$0' non è il primo elemento della sezione DPL. Le nuove impostazioni di debug non verranno applicate prima di aver completato il parsing e la verifica di tutti i parametri che lo precedono.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'QUERY: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'Questa sezione contiene {{PLURAL:$1|una voce|$1 voci}}.'
);
$wgDPL2Messages['nl'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "FOUT: Verkeerde parameter '$0': '$1'! Hulp:  <code>$0= <i>lege string</i> (Main)$3</code>. Equivalenten met magic words zijn ook toegestaan.",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "FOUT: Verkeerde paramater'$0': '$1'! Help:  <code>$0= <i>full pagename</i></code>. Magic words zijn toegestaan.",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'FOUT: Te veel categoriën! Maximum: $0. Hulp: verhoog <code>$wgDPL2MaxCategoryCount</code> om meer categorieën op te kunnen geven of stel geen limiet in met <code>$wgDPL2AllowUnlimitedCategories=true</code>. (Neem deze variabele op in <code>LocalSettings.php</code>, na het toevoegen van <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'FOUT: Te weinig categorieën! Minimum: $0. Hulp: verlaag <code>$wgDPL2MinCategoryCount</code> om minder categorieën aan te hoeven geven. (Stel de variabele bij voorkeur in via <code>LocalSettings.php</code>, na het toevoegen van <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "FOUT: U dient tenminste één categorie op te nemen als u 'addfirstcategorydate=true' of 'ordermethod=categoryadd' wilt gebruiken!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "FOUT: Als u meer dan één categorie opneemt, kunt u 'addfirstcategorydate=true' of 'ordermethod=categoryadd' niet gebruiken!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'FOUT: U kunt niet meer dan één type of datum tegelijk gebruiken!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "FOUT: U kunt '$0' alleen met 'ordermethod=[...,]$1' gebruiken!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => $wgDPL2Messages['en']['dpl2_debug_' . DPL2_ERR_NOCLVIEW],

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => $wgDPL2Messages['en']['dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM],
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "WAARSCHUWING: Verkeerde parameter '$0': '$1'! Nu wordt de standaard gebruikt: '$2'. Hulp: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => $wgDPL2Messages['en']['dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT],
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'WAARSCHUWING: Geen resultaten!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "WAARSCHUWING: Add* parameters ('adduser', 'addeditdate', etc.)' en 'includepage' heeft geen effect bij 'mode=category'. Alleen de paginanaamruimte/titel is in deze modus te bekijken.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "WAARSCHUWING: 'headingmode=$0' heeft geen effect met 'ordermethod' op een enkele component. Nu wordt gebruikt: '$1'. Hulp: u kunt een niet-$1 'headingmode'-waarde gebruiken met 'ordermethod' op meerdere componenten. De eerste component wordt gebruikt als kop. Bijvoorbeeld 'ordermethod=category,<i>comp</i>' (<i>comp</i> is een ander component) voor categoriekoppen.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "WAARSCHUWING: 'debug=$0' is niet de eerste positie in het DPL-element. De nieuwe debuginstellingen zijn niet toegepast voor alle voorgaande parameters zijn verwerkt en gecontroleerd.",
	/**
	 * $0: title of page that creates an infinite transclusion loop
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "WAARSCHUWING: Pagina '$0' veroorzaakt een oneindige transclusie.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'QUERY: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'Er {{PLURAL:$1|is één pagina|zijn $1 pagina\'s}} onder deze kop.'
);
$wgDPL2Messages['ru'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespacenamespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "ОШИБКА: неправильный «$0»-параметр: «$1»! Подсказка:  <code>$0= <i>пустая строка</i> (Основное)$3</code>.",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'ОШИБКА: слишком много категорий! Максимум: $0. Подсказка: увеличте <code>$wgDPL2MaxCategoryCount</code> чтобы разрешить больше категорий или установите <code>$wgDPL2AllowUnlimitedCategories=true</code> для снятия ограничения. (Устанавливайте переменные в <code>LocalSettings.php</code>, после подключения <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'ОШИБКА: слишком мало категорий! Минимум: $0. Подсказка: уменьшите <code>$wgDPL2MinCategoryCount</code> чтобы разрешить меньше категорий. (Устанавливайте переменную в <code>LocalSettings.php</code>, после подключения <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "ОШИБКА: вы должны включить хотя бы одну категорию, если вы хотите использовать «addfirstcategorydate=true» или «ordermethod=categoryadd»!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "ОШИБКА: если вы включаете больше одной категории, то вы не можете использовать «addfirstcategorydate=true» или «ordermethod=categoryadd»!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'ОШИБКА: вы не можете добавить более одного типа данных за раз!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "ОШИБКА: вы можете использовать «$0» только с «ordermethod=[...,]$1»!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => $wgDPL2Messages['en']['dpl2_debug_' . DPL2_ERR_NOCLVIEW],

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "ПРЕДУПРЕЖДЕНИЕ: неизвестный параметр «$0» проигнорирован. Подсказка: доступные параметры: <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "ПРЕДУПРЕЖДЕНИЕ: неправильный параметр «$0»: «$1»! Использование параметра по умолчанию: «$2». Подсказка: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "ПРЕДУПРЕЖДЕНИЕ: неправильный параметр «$0»: «$1»! Использование параметра по умолчанию: «$2» (без ограничений). Подсказка: <code>$0= <i>пустая строка</i> (без ограничений) | n</code>, с <code>n</code> равным положительному целому числу.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'ПРЕДУПРЕЖДЕНИЕ: не найдено!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "ПРЕДУПРЕЖДЕНИЕ: Добавление* параметров («adduser», «addeditdate», и др.) не действительны с «mode=category». Только пространства имён или названия могут просматриваться в этом режиме.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "ПРЕДУПРЕЖДЕНИЕ: «headingmode=$0» не действителен с «ordermethod» в одном компоненте. Использование: «$1». Подсказка: вы можете использоватьe не-$1 «headingmode» значения с «ordermethod» во множестве компонентов. Первый компонент используется для заголовков. Например, «ordermethod=category,<i>comp</i>» (<i>comp</i> является другим компонентом) для заголовков категорий.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "ПРЕДУПРЕЖДЕНИЕ: «debug=$0» не находится на первом месте в DPL-элементе. Новые настройки отладки не будут применены пока все предыдущие параметры не будут разобраны и проверены.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'ЗАПРОС: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'В этом заголовке $1 {{PLURAL:$1|статья|статьи|статей}}.'
);
$wgDPL2Messages['sk'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "CHYBA: nesprávny parameter '$0': '$1'! Pomocník <code>$0= <i>prázdny reťazec</i> (Hlavný)$3<code>. (Ekvivalenty s magickými slovami sú tiež povolené.)",
	/**
	 * $0: 'linksto' (left as $0 just in case the parameter is renamed in the future)
	 * $1: wrong parameter given by user
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "CHYBA: Zlý parameter '$0': '$1'! Pomocník <code>$0= <i>plný názov stránky</i></code>. (Magické slová sú povolené.)",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'CHYBA: Príliš veľa kategórií! Maximum: $0. Pomocník: zväčšite <code>$wgDPL2MaxCategoryCount</code>, aby ste mohli špecifikovať viac kategórií alebo nastavte <code>$wgDPL2AllowUnlimitedCategories=true</code> pre vypnutie limitu. (Premennú nastatavte v <code>LocalSettings.php</code>, potom ako bol includovaný <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'CHYBA: Príliš málo kategórií! Minimum: $0. Pomocník: znížte <code>$wgDPL2MinCategoryCount</code>, aby ste mohli špecifikovať menej kategórií. (Premennú nastavte najlepšie v <code>LocalSettings.php</code> potom, ako v ňom bol includovaný <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "CHYBA: Musíte uviesť aspoň jednu kategóriu ak chcete použiť 'addfirstcategorydate=true' alebo 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "CHYBA: Ak zahrniete viac ako jednu kategóriu, nemôžete použiť 'addfirstcategorydate=true' alebo 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'CHYBA: Nemôžete naraz pridať viac ako jeden typ dátumu!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "CHYBA: '$0' môžete použiť iba s 'ordermethod=[...,]$1'!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "CHYBA: Nie je momožné vykonávať logické operácie na nekategorizovaných kategóriách (napr. s parametrom 'Kategória') lebo neexistuje na databázu pohľad $0! Pomocník: nech admin databázy vykoná tento dotaz: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "VAROVANIE: Neznámy parameter '$0' ignorovaný. Pomocník: dostupné parametre: <code>$1</code>.",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "VAROVANIE: Nesprávny '$0' parameter: '$1'! Používam štandardný '$2'. Pomocník: <code>$0= $3</code>.",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "VAROVANIE: Nesprávny parameter  '$0': '$1'! Používam štandardný: '$2' (bez obmedzenia). Pomocník: <code>$0= <i>prázdny reťazec</i> (bez obmedzenia) | n</code>, s kladným celým číslom <code>n</code>.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'VAROVANIE: No results!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "VAROVANIE: Parametre Add* ('adduser', 'addeditdate', atď' nepracujú s mode=category'. V tomto režime je možné prehliadať iba menný priestor/titulok stránky.",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "VAROVANIE: 'headingmode=$0' nepracuje s 'ordermethod' na jednom komponente. Použitie: '$1'. Pomocník: môžete použiť not-$1 hodnoty 'headingmode' s 'ordermethod' na viaceré komponenty. Prvý komponent sa používa na nadpisy. Napr. 'ordermethod=category,<i>comp</i>' (<i>comp</i> je iný komponent) pre nadpisy kategórií.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "VAROVANIE: 'debug=$0' nie je na prvej pozícii v prvku DPL. Nové ladiacie nastavenia nebudú použíté skôr než budú parsované a skontrolované všetky predchádzajúce.",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => 'DOTAZ: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => 'V tomto nadpise {{PLURAL:$1|je jeden článok|sú $1 články|je $1 článkov}}.'
);
$wgDPL2Messages['sr-ec'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' или 'notnamespace'
	 * $1: корисник је унео погрешан параметар
	 * $3: списак могућих наслова за именски простор (сем именских простора: Медија, Посебно)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "ГРЕШКА: Погреан '$0' параметар: '$1'! Помоћ:  <code>$0= <i>погрешан стринг</i> (Главно)$3</code>. (Еквиваленти са магичним речима су такође дозвољени.)",
	/**
	 * $0: 'linksto' (остављено као $0 у случају да се параметар промени у будућности)
	 * $1: корисник је унео погрешан параметар
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "ГРЕШКА: Погрешан '$0' параметар: '$1'! Помоћ:  <code>$0= <i>пуно име странице</i></code>. (Магичне речи су дозвољене.)",
	/**
	 * $0: максималан број категорија које се могу укључити
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'ГРЕШКА: Превише категорија! Максимум је: $0. Помоћ: повећајте <code>$wgDPL2MaxCategoryCount</code> како бисте поставили више категорија или промените <code>$wgDPL2AllowUnlimitedCategories=true</code> за без граница. (Подесите варијаблу у <code>LocalSettings.php</code>, након укључивања <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: минималан број категорија који се могу укључити
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'ГРЕШКА: Премало категорија! Минимум је: $0. Помоћ: повећајте <code>$wgDPL2MinCategoryCount</code> како бисте поставили мање категорија. (Подесите варијаблу у <code>LocalSettings.php</code>, након укључивања <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "ГРЕШКА: Морате укључити бар једну категорију уколико желите да користите 'addfirstcategorydate=true' или 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "ГРЕШКА: Уколико укључујете више од једне категорије, не можете користити 'addfirstcategorydate=true' или 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'ГРЕШКА: Не можете додати више од једног типа датума!',
	/**
	 * $0: param=val је могућ само са $1 на мање 'ordermethod' параметром
	 * $1: последњи 'ordermethod' параметар је потребан за $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "ГРЕШКА: Можете користити '$0' са 'ordermethod=[...,]$1' искључиво!",
	/**
	 * $0: prefix_dpl_clview где је 'prefix' префикс имена медијавики табела
	 * $1: SQL упит за креирање prefix_dpl_clview на бази података вашег МедијаВикија
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "ГРЕШКА: Немогуће извршити операцију на некатегоризованим страницама (нпр. са 'category' параметром) зато што $0 преглед не постоји у бази података! Помоћ: нека администратор базе изврши овај упит: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: корисник је унео непознат параметар
	 * $1: списак DPL2 могућих параметара одвојених са ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "ПАЖЊА: Непознат параметар '$0' је игнорисан. Помоћ: доступни параметри су: <code>$1</code>.",
	/**
	 * $3: списак валидних података параметара одвојених са ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "ПАЖЊА: Погрешан '$0' параметар: '$1'! Користи се основни: '$2'. Помоћ: <code>$0= $3</code>.",
	/**
	 * $0: име параметра
	 * $1: корисник је унео непознат параметар
	 * $2: користи се основни податак параметра уместо програмски
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "ПАЖЊА: Погрешан '$0' параметар: '$1'! Користи се основни: '$2' (без границе). Помоћ: <code>$0= <i>празан стринг</i> (без границе) | n</code>, с <code>n</code> је позитиван интегер.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'ПАЖЊА: Нема резултата!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "ПАЖЊА: Додавање* параметара ('adduser', 'addeditdate', итд.)' и 'includepage' нема ефекта са 'mode=category'. Искључиво име странице/именски простор могу да се виде у овом моду.",
	/**
	 * $0: 'headingmode' податак који је унео корисник
	 * $1: подаци кориштени уместо програма (што значи без наслова)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "ПАЖЊА: 'headingmode=$0' нема ефекта са 'ordermethod' на једној компоненти. Користи се: '$1'. Помоћ: не морате користити-$1 'headingmode' податке 'ordermethod' на више компоненти. Прва компонента се користи за наслов. Нпр. 'ordermethod=category,<i>компонента</i>' (<i>компонента</i> је друга компонента) за наслове категорија.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "ПАЖЊА: 'debug=$0' није на првом месту у DPL елементу. Нова дебаг подешавања нису примењена пре свих параметара који су проверени",
	/**
	 * $0: наслов странице која прави бесконачну петљу.
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "ПАЖЊА: Бесконачна петљаса странице '$0'.",

	// OTHERS
	/**
	 * $0: SQL упит за генерисање динамичног списка страница
	*/
	'dpl2_debug_' . DPL2_QUERY => 'УПИТ: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: број чланака
	*/
	'dpl2_articlecount' => 'У овом наслову се тренутно налази {{PLURAL:$1|један чланак|$1 чланка|$1 чланака}}.'
);
$wgDPL2Messages['sr-el'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' ili 'notnamespace'
	 * $1: korisnik je uneo pogrešan parametar
	 * $3: spisak mogućih naslova za imenski prostor (sem imenskih prostora: Medija, Posebno)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "GREŠKA: Pogrean '$0' parametar: '$1'! Pomoć:  <code>$0= <i>pogrešan string</i> (Glavno)$3</code>. (Ekvivalenti sa magičnim rečima su takođe dozvoljeni.)",
	/**
	 * $0: 'linksto' (ostavljeno kao $0 u slučaju da se parametar promeni u budućnosti)
	 * $1: korisnik je uneo pogrešan parametar
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGLINKSTO => "GREŠKA: Pogrešan '$0' parametar: '$1'! Pomoć:  <code>$0= <i>puno ime stranice</i></code>. (Magične reči su dozvoljene.)",
	/**
	 * $0: maksimalan broj kategorija koje se mogu uključiti
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => 'GREŠKA: Previše kategorija! Maksimum je: $0. Pomoć: povećajte <code>$wgDPL2MaxCategoryCount</code> kako biste postavili više kategorija ili promenite <code>$wgDPL2AllowUnlimitedCategories=true</code> za bez granica. (Podesite varijablu u <code>LocalSettings.php</code>, nakon uključivanja <code>DynamicPageList2.php</code>.)',
	/**
	 * $0: minimalan broj kategorija koji se mogu uključiti
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => 'GREŠKA: Premalo kategorija! Minimum je: $0. Pomoć: povećajte <code>$wgDPL2MinCategoryCount</code> kako biste postavili manje kategorija. (Podesite varijablu u <code>LocalSettings.php</code>, nakon uključivanja <code>DynamicPageList2.php</code>.)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "GREŠKA: Morate uključiti bar jednu kategoriju ukoliko želite da koristite 'addfirstcategorydate=true' ili 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "GREŠKA: Ukoliko uključujete više od jedne kategorije, ne možete koristiti 'addfirstcategorydate=true' ili 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => 'GREŠKA: Ne možete dodati više od jednog tipa datuma!',
	/**
	 * $0: param=val je moguć samo sa $1 na manje 'ordermethod' parametrom
	 * $1: poslednji 'ordermethod' parametar je potreban za $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "GREŠKA: Možete koristiti '$0' sa 'ordermethod=[...,]$1' isključivo!",
	/**
	 * $0: prefix_dpl_clview gde je 'prefix' prefiks imena medijaviki tabela
	 * $1: SQL upit za kreiranje prefix_dpl_clview na bazi podataka vašeg MedijaVikija
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => "GREŠKA: Nemoguće izvršiti operaciju na nekategorizovanim stranicama (npr. sa 'category' parametrom) zato što $0 pregled ne postoji u bazi podataka! Pomoć: neka administrator baze izvrši ovaj upit: <code>$1</code>.",

	// WARNINGS
	/**
	 * $0: korisnik je uneo nepoznat parametar
	 * $1: spisak DPL2 mogućih parametara odvojenih sa ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "PAŽNJA: Nepoznat parametar '$0' je ignorisan. Pomoć: dostupni parametri su: <code>$1</code>.",
	/**
	 * $3: spisak validnih podataka parametara odvojenih sa ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "PAŽNJA: Pogrešan '$0' parametar: '$1'! Koristi se osnovni: '$2'. Pomoć: <code>$0= $3</code>.",
	/**
	 * $0: ime parametra
	 * $1: korisnik je uneo nepoznat parametar
	 * $2: koristi se osnovni podatak parametra umesto programski
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "PAŽNJA: Pogrešan '$0' parametar: '$1'! Koristi se osnovni: '$2' (bez granice). Pomoć: <code>$0= <i>prazan string</i> (bez granice) | n</code>, s <code>n</code> je pozitivan integer.",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => 'PAŽNJA: Nema rezultata!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "PAŽNJA: Dodavanje* parametara ('adduser', 'addeditdate', itd.)' i 'includepage' nema efekta sa 'mode=category'. Isključivo ime stranice/imenski prostor mogu da se vide u ovom modu.",
	/**
	 * $0: 'headingmode' podatak koji je uneo korisnik
	 * $1: podaci korišteni umesto programa (što znači bez naslova)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "PAŽNJA: 'headingmode=$0' nema efekta sa 'ordermethod' na jednoj komponenti. Koristi se: '$1'. Pomoć: ne morate koristiti-$1 'headingmode' podatke 'ordermethod' na više komponenti. Prva komponenta se koristi za naslov. Npr. 'ordermethod=category,<i>komponenta</i>' (<i>komponenta</i> je druga komponenta) za naslove kategorija.",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "PAŽNJA: 'debug=$0' nije na prvom mestu u DPL elementu. Nova debag podešavanja nisu primenjena pre svih parametara koji su provereni",
	/**
	 * $0: naslov stranice koja pravi beskonačnu petlju.
	*/
	'dpl2_debug_' . DPL2_WARN_TRANSCLUSIONLOOP => "PAŽNJA: Beskonačna petljasa stranice '$0'.",

	// OTHERS
	/**
	 * $0: SQL upit za generisanje dinamičnog spiska stranica
	*/
	'dpl2_debug_' . DPL2_QUERY => 'UPIT: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: broj članaka
	*/
	'dpl2_articlecount' => 'U ovom naslovu se trenutno nalazi {{PLURAL:$1|jedan članak|$1 članka|$1 članaka}}.'
);
$wgDPL2Messages['sr'] = $wgDPL2Messages['sr-ec'];
$wgDPL2Messages['yue'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "錯誤: 錯嘅 '$0' 參數: '$1'! 幫助:  <code>$0= <i>空字串</i> (主)$3</code>。",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => '錯誤: 太多分類! 最大值: $0。 幫助: 增加 <code>$wgDPL2MaxCategoryCount</code> 嘅值去指定更多嘅分類或者設定 <code>$wgDPL2AllowUnlimitedCategories=true</code> 以解除限制。 (當加上 <code>DynamicPageList2.php</code>之後，響<code>LocalSettings.php</code>度設定變數。)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => '錯誤: 太少分類! 最小值: $0. 幫助: 減少 <code>$wgDPL2MinCategoryCount</code> 嘅值去指定更少嘅分類。 (當加上 <code>DynamicPageList2.php</code>之後，響<code>LocalSettings.php</code>度設定一個合適嘅變數。)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "錯誤: 如果你想去用 'addfirstcategorydate=true' 或者 'ordermethod=categoryadd' ，你需要包含最少一個分類!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "錯誤: 如果你包含多過一個分類，你唔可以用 'addfirstcategorydate=true' 或者 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => '錯誤: 你唔可以響一個時間度加入多個一種嘅日期!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "錯誤: 你只可以用 'ordermethod=[...,]$1' 響 '$0' 上!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => $wgDPL2Messages['en']['dpl2_debug_' . DPL2_ERR_NOCLVIEW],

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "警告: 不明嘅參數 '$0' 被忽略。 幫助: 可用嘅參數: <code>$1</code>。",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "警告: 錯誤嘅 '$0' 參數: '$1'! 用緊預設嘅: '$2'。 幫助: <code>$0= $3</code>。",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "警告: 錯誤嘅 '$0' 參數: '$1'! 用緊預設嘅: '$2' (冇上限)。 幫助: <code>$0= <i>空字串</i> (冇上限) | n</code>, <code>n</code>係一個正整數。",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => '警告: 無結果!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "警告: 加入* 參數 ('adduser', 'addeditdate', 等)' 係對 'mode=category' 冇作用嘅。只有頁空間名／標題至可以響呢個模式度睇到。",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "警告: 響單一部件中， 'ordermethod' 度用 'headingmode=$0' 係冇作用嘅。 用緊: '$1'。 幫助: 你可以用非$1 'headingmode' 數值，響多個部件中用 'ordermethod' 。第一個部件係用嚟做標題。例如響分類標題度用 'ordermethod=category,<i>comp</i>' (<i>comp</i>係另外一個部件) 。",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "警告: 'debug=$0' 唔係第一個響DPL元素嘅第一位。新嘅除錯設定響所有參數都能夠處理同檢查之前都唔會應用。",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => '查訽: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => '響呢個標題度有$1篇文。'
);
$wgDPL2Messages['zh-hans'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "错误: 错误的 '$0' 参数: '$1'! 帮助:  <code>$0= <i>空白字符串</i> (主)$3</code>。",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => '错误: 过多分类! 最大值: $0。 帮助: 增加 <code>$wgDPL2MaxCategoryCount</code> 的值去指定更多的分类或设定 <code>$wgDPL2AllowUnlimitedCategories=true</code> 以解除限制。 (当加上 <code>DynamicPageList2.php</code>后，在<code>LocalSettings.php</code>中设定变量。)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => '错误: 过少分类! 最小值: $0。 帮助: 减少 <code>$wgDPL2MinCategoryCount</code> 的值去指定更少的分类。 (当加上 <code>DynamicPageList2.php</code>后，在<code>LocalSettings.php</code>中设定一个合适的变量。)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "错误: 如果您想用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd' ，您需要包含最少一个分类!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "错误: 如果您包含多一个分类，您不可以用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => '错误: 您不可以在一个时间里加入多于一种嘅日期!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "错误: 你只可以用 'ordermethod=[...,]$1' 在 '$0' 上!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => $wgDPL2Messages['en']['dpl2_debug_' . DPL2_ERR_NOCLVIEW],

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "警告: 不明的参数 '$0' 被忽略。 帮助: 可用的参数: <code>$1</code>。",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "警告: 错误的 '$0' 参数: '$1'! 正在使用默认值: '$2'。 帮助: <code>$0= $3</code>。",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "警告: 错误的 '$0' 参数: '$1'! 正在使用默认值: '$2' (没有上限)。 帮助: <code>$0= <i>空白字符串</i> (没有上限) | n</code>, <code>n</code>是一个正整数。",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => '警告: 无结果!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "警告: 加入* 参数 ('adduser', 'addeditdate', 等)' 是对 'mode=category' 没有作用。只有页面空间名／标题才可以在这个模式度看到。",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "警告: 在单一部件中， 'ordermethod' 用 'headingmode=$0' 是没有作用的。 正在使用: '$1'。 帮助: 你可以用非$1 'headingmode' 数值，在多个部件中用 'ordermethod' 。第一个部是用来作标题。例如在分类标题中用 'ordermethod=category,<i>comp</i>' (<i>comp</i>是另外一个部件) 。",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "警告: 'debug=$0' 不是第一个在DPL元素嘅第一位置。新的除错设定在所有参数都能处理和检查前都不会应用。",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => '查訽: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => '在这个标题中有$1篇条目。'
);
$wgDPL2Messages['zh-hant'] = array(
	/*
		Debug
	*/
	// (FATAL) ERRORS
	/**
	 * $0: 'namespace' or 'notnamespace'
	 * $1: wrong parameter given by user
	 * $3: list of possible titles of namespaces (except pseudo-namespaces: Media, Special)
	 */
	'dpl2_debug_' . DPL2_ERR_WRONGNS => "錯誤: 錯誤的 '$0' 參數: '$1'! 說明:  <code>$0= <i>空白字串</i> (主)$3</code>。",
	/**
	 * $0: max number of categories that can be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOMANYCATS => '錯誤: 過多分類! 最大值: $0。 說明: 增加 <code>$wgDPL2MaxCategoryCount</code> 的值去指定更多的分類或設定 <code>$wgDPL2AllowUnlimitedCategories=true</code> 以解除限制。 (當加上 <code>DynamicPageList2.php</code>後，在<code>LocalSettings.php</code>中設定變數。)',
	/**
	 * $0: min number of categories that have to be included
	*/
	'dpl2_debug_' . DPL2_ERR_TOOFEWCATS => '錯誤: 過少分類! 最小值: $0。 說明: 減少 <code>$wgDPL2MinCategoryCount</code> 的值去指定更少的分類。 (當加上 <code>DynamicPageList2.php</code>後，在<code>LocalSettings.php</code>中設定一個合適的變數。)',
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTNOINCLUDEDCATS => "錯誤: 如果您想用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd' ，您需要包含最少一個分類!",
	'dpl2_debug_' . DPL2_ERR_CATDATEBUTMORETHAN1CAT => "錯誤: 如果您包含多一個分類，您不可以用 'addfirstcategorydate=true' 或 'ordermethod=categoryadd'!",
	'dpl2_debug_' . DPL2_ERR_MORETHAN1TYPEOFDATE => '錯誤: 您不可以在一個時間裡加入多於一種嘅日期!',
	/**
	 * $0: param=val that is possible only with $1 as last 'ordermethod' parameter
	 * $1: last 'ordermethod' parameter required for $0
	*/
	'dpl2_debug_' . DPL2_ERR_WRONGORDERMETHOD => "錯誤: 你只可以用 'ordermethod=[...,]$1' 在 '$0' 上!",
	/**
	 * $0: prefix_dpl_clview where 'prefix' is the prefix of your MediaWiki table names
	 * $1: SQL query to create the prefix_dpl_clview on your MediaWiki DB
	*/
	'dpl2_debug_' . DPL2_ERR_NOCLVIEW => $wgDPL2Messages['en']['dpl2_debug_' . DPL2_ERR_NOCLVIEW],

	// WARNINGS
	/**
	 * $0: unknown parameter given by user
	 * $1: list of DPL2 available parameters separated by ', '
	*/
	'dpl2_debug_' . DPL2_WARN_UNKNOWNPARAM => "警告: 不明的參數 '$0' 被忽略。 說明: 可用的參數: <code>$1</code>。",
	/**
	 * $3: list of valid param values separated by ' | '
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM => "警告: 錯誤的 '$0' 參數: '$1'! 正在使用預設值: '$2'。 說明: <code>$0= $3</code>。",
	/**
	 * $0: param name
	 * $1: wrong param value given by user
	 * $2: default param value used instead by program
	*/
	'dpl2_debug_' . DPL2_WARN_WRONGPARAM_INT => "警告: 錯誤的 '$0' 參數: '$1'! 正在使用預設值: '$2' (沒有上限)。 說明: <code>$0= <i>空白字串</i> (沒有上限) | n</code>, <code>n</code>是一個正整數。",
	'dpl2_debug_' . DPL2_WARN_NORESULTS => '警告: 無結果!',
	'dpl2_debug_' . DPL2_WARN_CATOUTPUTBUTWRONGPARAMS => "警告: 加入* 參數 ('adduser', 'addeditdate', 等)' 是對 'mode=category' 沒有作用。只有頁面空間名／標題才可以在這個模式度看到。",
	/**
	 * $0: 'headingmode' value given by user
	 * $1: value used instead by program (which means no heading)
	*/
	'dpl2_debug_' . DPL2_WARN_HEADINGBUTSIMPLEORDERMETHOD => "警告: 在單一部件中， 'ordermethod' 用 'headingmode=$0' 是沒有作用的。 正在使用: '$1'。 說明: 你可以用非$1 'headingmode' 數值，在多個部件中用 'ordermethod' 。第一個部是用來作標題。例如在分類標題中用 'ordermethod=category,<i>comp</i>' (<i>comp</i>是另外一個部件) 。",
	/**
	 * $0: 'debug' value
	*/
	'dpl2_debug_' . DPL2_WARN_DEBUGPARAMNOTFIRST => "警告: 'debug=$0' 不是第一個在DPL元素嘅第一位置。新的除錯設定在所有參數都能處理和檢查前都不會應用。",

	// OTHERS
	/**
	 * $0: SQL query executed to generate the dynamic page list
	*/
	'dpl2_debug_' . DPL2_QUERY => '查訽: <code>$0</code>',

	/*
	   Output formatting
	*/
	/**
	 * $1: number of articles
	*/
	'dpl2_articlecount' => '在這個標題中有$1篇條目。'
);
$wgDPL2Messages['zh'] = $wgDPL2Messages['zh-hans'];
$wgDPL2Messages['zh-cn'] = $wgDPL2Messages['zh-hans'];
$wgDPL2Messages['zh-hk'] = $wgDPL2Messages['zh-hant'];
$wgDPL2Messages['zh-sg'] = $wgDPL2Messages['zh-hans'];
$wgDPL2Messages['zh-tw'] = $wgDPL2Messages['zh-hant'];
$wgDPL2Messages['zh-yue'] = $wgDPL2Messages['yue'];
