<?php
/**
 * Internationalisation file for extension CategoryTree.
 *
 * @addtogroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2006-2008 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

$messages = array();

/** English
 * @author Daniel Kinzler, brightbyte.de
 */
$messages['en'] = array(
	'categorytree'                  => 'Category tree',
	'categorytree-portlet'          => 'Categories',
	'categorytree-legend'           => 'Show category tree',
	'categorytree-desc'             => 'Dynamically navigate the [[Special:CategoryTree|category structure]]',
	'categorytree-header'           => 'Enter a category name to see its contents as a tree structure.
Note that this requires advanced JavaScript functionality known as AJAX.
If you have a very old browser, or have JavaScript disabled, it will not work.',

	'categorytree-category'         => 'Category:',
	'categorytree-go'               => 'Show tree',
	'categorytree-parents'          => 'Parents',

	'categorytree-mode-categories'  => 'categories only',
	'categorytree-mode-pages'       => 'pages except files',
	'categorytree-mode-all'         => 'all pages',

	'categorytree-collapse'         => 'collapse',
	'categorytree-expand'           => 'expand',
	'categorytree-collapse-bullet'  => '[<b>−</b>]', # do not translate or duplicate this message to other languages
	'categorytree-expand-bullet'    => '[<b>+</b>]', # do not translate or duplicate this message to other languages
	'categorytree-empty-bullet'     => '[<b>×</b>]', # do not translate or duplicate this message to other languages
	'categorytree-page-bullet'      => '&nbsp;', # do not translate or duplicate this message to other languages

	'categorytree-member-counts'    => 'contains {{PLURAL:$1|1 subcategory|$1 subcategories}}, {{PLURAL:$2|1 page|$2 pages}}, and {{PLURAL:$3|1 file|$3 files}}', # $1=subcategories, $2=subpages, $3=files, $4=total, $5=shown-in-tree
	'categorytree-member-num'    => '($5)', # do not translate or duplicate this message to other languages

	'categorytree-load'             => 'load',
	'categorytree-loading'          => 'loading…',
	'categorytree-nothing-found'    => 'nothing found',
	'categorytree-no-subcategories' => 'no subcategories',
	'categorytree-no-parent-categories' => 'no parent categories',
	'categorytree-no-pages'         => 'no pages or subcategories',
	'categorytree-not-found'        => 'Category <i>$1</i> not found',
	'categorytree-error'            => 'Problem loading data.',
	'categorytree-retry'            => 'Please wait a moment and try again.',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Jon Harald Søby
 * @author Malafaya
 * @author Meno25
 * @author Raimond Spekking
 * @author Raymond
 * @author Siebrand
 * @author Александр Сигачёв
 * @author פוילישער
 */
$messages['qqq'] = array(
	'categorytree' => 'Title of [[Special:CategoryTree]]',
	'categorytree-portlet' => '{{Identical|Categories}}

Title for the CategoryPortlet, when shown in the side bar',
	'categorytree-legend' => 'Legend of the fieldset around the input form of [[Special:Categorytree]].',
	'categorytree-desc' => 'Short description of the CategoryTree extension, shown on [[Special:Version]]',
	'categorytree-header' => 'Header-text shown on [[Special:CategoryTree]]',
	'categorytree-category' => '{{Identical|Category}}

Label for the category input field on Special:CategoryTree',
	'categorytree-go' => 'Label for the submit button on [[Special:CategoryTree]]',
	'categorytree-parents' => 'Label for the list of parent categories on [[Special:CategoryTree]]',
	'categorytree-mode-categories' => 'Item for the mode choice on [[Special:CategoryTree]], indicating that only categories are listed',
	'categorytree-mode-pages' => 'Item for the mode choice on [[Special:CategoryTree]], indicating that no images in categories are listed',
	'categorytree-mode-all' => 'Item for the mode choice on [[Special:CategoryTree]], indicating that all pages are listed.

{{Identical|All pages}}',
	'categorytree-collapse' => 'Tooltip for the "collapse" button',
	'categorytree-expand' => 'Tooltip for the "expand" button',
	'categorytree-member-counts' => 'Tooltip showing a detailed summary of subcategory member counts. Parameters: 
* $1 = number of subcategories, 
* $2 = number of pages (without subcategories and files), 
* $3 = number of files, 
* $4 = total number of members, 
* $5 = members to be shown in the tree, depending on mode. 
Use with { {PLURAL} }',
	'categorytree-load' => '{{Identical|Load}}

Tooltip for the "expend" button, if the content was not yet loaded',
	'categorytree-loading' => '{{Identical|Loading}}

Status message shown while loading content',
	'categorytree-nothing-found' => 'Indicates items with matching criteria have been found',
	'categorytree-no-subcategories' => 'Indicates that there are no subcategories to be shown',
	'categorytree-no-parent-categories' => 'Indicates that there are no parent categories to be shown',
	'categorytree-no-pages' => 'Indicates that there are no pages or subcategories to be shown',
	'categorytree-not-found' => 'Indicates that the given category ($1) was not found',
	'categorytree-error' => "Indicates that an error has occurred while loading the node's content",
	'categorytree-retry' => 'Instruction to try again later',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'categorytree' => 'Kategorieboom',
	'categorytree-portlet' => 'Kategorieë',
	'categorytree-legend' => 'Wys kategorieboom',
	'categorytree-desc' => "Bekyk en navigeer deur die [[Special:CategoryTree|kategoriestruktuur]] van 'n wiki",
	'categorytree-header' => "Tik 'n kategorienaam om sy inhoud as 'n boomstruktuur te sien. Hierdie benodig gevorderde JavaScript-funksionaliteit bekend as AJAX. Met 'n baie ou blaaier, of as JavaScript gedeaktiveer is, sal dit nie werk nie.",
	'categorytree-category' => 'Kategorie:',
	'categorytree-go' => 'Wys boom',
	'categorytree-parents' => 'ouers',
	'categorytree-mode-categories' => 'slegs kategorieë',
	'categorytree-mode-pages' => 'bladsye met prentbladsye uitgesluit',
	'categorytree-mode-all' => 'alle bladsye',
	'categorytree-collapse' => 'vou toe',
	'categorytree-expand' => 'vou oop',
	'categorytree-member-counts' => 'bevat {{PLURAL:$1|een subkategorie|$1 subkategorieë}}, {{PLURAL:$2|een bladsy|$2 blaaie}} en {{PLURAL:$3|een lêer|$3 lêers}}',
	'categorytree-load' => 'laai',
	'categorytree-loading' => 'laai tans',
	'categorytree-nothing-found' => 'niks gevind nie',
	'categorytree-no-subcategories' => 'geen subkategorieë nie',
	'categorytree-no-parent-categories' => 'geen kategorieë boontoe',
	'categorytree-no-pages' => 'geen bladsye of subkategorieë nie',
	'categorytree-not-found' => 'Kategorie <i>$1</i> nie gevind nie',
	'categorytree-error' => 'Probleem met die laai van die data.',
	'categorytree-retry' => "Wag asseblief 'n rukkie en probeer weer.",
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 * @author Elfalem
 */
$messages['am'] = array(
	'categorytree' => 'የመደቦች ዛፍ',
	'categorytree-portlet' => 'መደቦች',
	'categorytree-legend' => 'የመደቦች ዛፍ ለማየት',
	'categorytree-header' => "[+] ተጭነው ንዑሱ-መደብ ይዘረጋል፣ [-] ተጭነው ደግሞ ይመልሳል። 

በግራ በኩል ባለው ሳጥን ውስጥ የመደቡን ስም ዝም ብለው መጻፍ ይችላሉ። (የዚሁ ዊኪ መደብ ስሞች ለመመልከት፣ [[Special:Mostlinkedcategories|እዚህ ይጫኑ]]።) ከዚያ፥ ምን ያሕል ንዑስ-መደቦች እንዳሉበት ለማየት «ዛፉ ይታይ» የሚለውን ይጫኑ። በቀኝ በኩል ካለው ሳጥን 'all pages' ከመረጡ፥ በየመደቡ ውስጥ ያሉት መጣጥፎች በተጨማሪ ይታያሉ።

''(ማስታወሻ: ይህ በኮምፒውተርዎ እንዲሠራ 'ጃቫ' የሚችል ዌብ-ብራውዘር ያስፈልጋል።)''",
	'categorytree-category' => 'የመደብ ስም፦',
	'categorytree-go' => 'ዛፉ ይታይ',
	'categorytree-parents' => 'ላዕላይ መደቦች',
	'categorytree-mode-categories' => 'መደቦች ብቻ',
	'categorytree-mode-all' => 'ሁሉም ገጾች',
	'categorytree-loading' => 'ሊመጣ ነው',
	'categorytree-nothing-found' => 'የለም',
	'categorytree-no-subcategories' => 'ንዑስ መደብ የለም',
	'categorytree-no-pages' => 'ምንም ገጾችና ንዑስ-መደቦች የሉም',
	'categorytree-not-found' => '«$1» የተባለ መደብ የለም።',
	'categorytree-retry' => 'ትንሽ ቆይተው እንደገና ይሞክሩ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'categorytree' => 'Árbol de categorías',
	'categorytree-portlet' => 'Categorías',
	'categorytree-legend' => "Amostar l'árbol de categorías",
	'categorytree-desc' => "Traste basato en AJAX t'amostrar a [[Special:CategoryTree|estrutura de categorías]] d'una wiki",
	'categorytree-header' => "Escriba un nombre de categoría ta beyer os suyos contenius en forma d'árbol. Pare cuenta que ista pachina requiere as funzions JavaScriptz abanzatas conoixitas como AJAX. Si tiene un nabegador antigo, u tiene desautibato JavaScript, a pachina no funzionará.",
	'categorytree-category' => 'Categoría:',
	'categorytree-go' => "Amostrar l'Árbol",
	'categorytree-parents' => 'Categorías mais',
	'categorytree-mode-categories' => 'amostrar nomás categorías',
	'categorytree-mode-pages' => 'pachinas pero no archibos',
	'categorytree-mode-all' => 'todas as pachinas',
	'categorytree-collapse' => 'amagar',
	'categorytree-expand' => 'amostrar',
	'categorytree-member-counts' => 'contiene {{PLURAL:$1|1 sucategoría|$1 subcategorías}}, {{PLURAL:$2|1 pachina|$2 pachinas}}, y {{PLURAL:$3|1 archibo|$3 archibos}}',
	'categorytree-load' => 'cargar',
	'categorytree-loading' => 'cargando',
	'categorytree-nothing-found' => "No s'ha trobato cosa",
	'categorytree-no-subcategories' => 'no bi ha subcategorías',
	'categorytree-no-parent-categories' => 'Garra categoría mai',
	'categorytree-no-pages' => 'No bi ha articlos ni subcategorías',
	'categorytree-not-found' => "Categoría ''$1'' no trobata",
	'categorytree-error' => 'Error en cargar os datos',
	'categorytree-retry' => 'Por fabor, aspere bels intes y prebe de nuebas.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'categorytree' => 'شجرة تصنيف',
	'categorytree-portlet' => 'تصنيفات',
	'categorytree-legend' => 'عرض شجرة التصنيف',
	'categorytree-desc' => 'إضافة معتمدة على الأجاكس لعرض [[Special:CategoryTree|هيكل التصنيف]] لويكي',
	'categorytree-header' => 'أدخل اسم تصنيف لترى محتوياته كتركيب شجري.
لاحظ أن هذا يتطلب خاصية جافاسكريبت متقدمة معروفة كأجاكس.
لو كنت تمتلك متصفحا قديما جدا، أو لديك الجافاسكريبت معطلة، فلن تعمل.',
	'categorytree-category' => ':تصنيف',
	'categorytree-go' => 'عرض الشجرة',
	'categorytree-parents' => 'مصنف تحت',
	'categorytree-mode-categories' => 'تصنيفات فقط',
	'categorytree-mode-pages' => 'الصفحات ماعدا الملفات',
	'categorytree-mode-all' => 'كل الصفحات',
	'categorytree-collapse' => 'ضغط',
	'categorytree-expand' => 'فرد',
	'categorytree-member-counts' => 'يحتوي على {{PLURAL:$1|1 تصنيف فرعي|$1 تصنيف فرعي}}، {{PLURAL:$2|1 صفحة|$2 صفحة}}، و {{PLURAL:$3|1 ملف|$3 ملف}}',
	'categorytree-load' => 'تحميل',
	'categorytree-loading' => 'جاري التحميل',
	'categorytree-nothing-found' => 'لم يتم العثور على شيء',
	'categorytree-no-subcategories' => 'لا تصنيفات فرعية',
	'categorytree-no-parent-categories' => 'لا تصنيفات أصلية',
	'categorytree-no-pages' => 'لا صفحات ولا تصنيفات فرعية',
	'categorytree-not-found' => 'التصنيف <i>$1</i> لم يتم العثور عليه',
	'categorytree-error' => 'مشكلة في تحميل البيانات.',
	'categorytree-retry' => 'من فضلك انتظر لحظة وحاول مرة أخرى.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'categorytree' => 'شجرة تصنيف',
	'categorytree-portlet' => 'تصنيفات',
	'categorytree-legend' => 'عرض شجرة التصنيف',
	'categorytree-desc' => 'ابحار بديناميكية فى  [[Special:CategoryTree|هيكل التصنيف]]',
	'categorytree-header' => 'دخل اسم التصنيف علشان تشوف المحتويات بتاعته على هيئة شجرة.
لاحظ ان دا بيعوز خاصية جافاسكريبت متقدمة اسمها اجاكس.
لو البراوز بتاعك قديم جدا،او الجافاسكريبت عندك متعطلة،دا مش ح يشتغل.',
	'categorytree-category' => 'تصنيف:',
	'categorytree-go' => 'عرض الشجره',
	'categorytree-parents' => 'متصنف تحت',
	'categorytree-mode-categories' => 'تصانيف بس',
	'categorytree-mode-pages' => 'الصفحات من غير الملفات',
	'categorytree-mode-all' => 'كل الصفحات',
	'categorytree-collapse' => 'اضغط',
	'categorytree-expand' => 'اتوسع',
	'categorytree-member-counts' => 'فيه {{PLURAL:$1|1 تصنيف فرعي|$1 تصنيف فرعي}}، {{PLURAL:$2|1 صفحة|$2 صفحة}}، و {{PLURAL:$3|1 ملف|$3 ملف}}',
	'categorytree-load' => 'تحميل',
	'categorytree-loading' => 'بيحمل',
	'categorytree-nothing-found' => 'مالقيناش حاجة',
	'categorytree-no-subcategories' => 'مافيش تصنيفات فرعية',
	'categorytree-no-parent-categories' => 'مافيش تصانيف أصلية',
	'categorytree-no-pages' => 'مافيش ولا فى صفحات ولا تصانيف فرعية',
	'categorytree-not-found' => 'التصنيف <i>$1</i> مش متلاقي',
	'categorytree-error' => 'مشكلة فى تحميل البيانات.',
	'categorytree-retry' => 'لو سمحت تستنا لحظة و بعدين حاول تاني',
);

/** Assamese (অসমীয়া)
 * @author Rajuonline
 */
$messages['as'] = array(
	'categorytree' => 'শ্রেণীবৃক্ষ্য',
	'categorytree-legend' => 'শ্রেণীবৃক্ষ্য দেখুৱাওক',
	'categorytree-category' => 'শ্রেণী',
	'categorytree-go' => 'বৃক্ষ্য দেখুৱাওক',
	'categorytree-parents' => 'পালক',
	'categorytree-mode-categories' => 'কেবল শ্রেণী',
	'categorytree-mode-pages' => 'চিত্রবিহীন পৃষ্ঠাসমুহ',
	'categorytree-mode-all' => 'সকলো পৃষ্ঠা',
	'categorytree-collapse' => 'সৰু কৰক',
	'categorytree-expand' => 'বহলাওক',
	'categorytree-load' => 'লোড কৰক',
	'categorytree-loading' => 'লোড কৰি থকা হৈছে...',
	'categorytree-nothing-found' => 'একো পোৱা নগল',
	'categorytree-no-subcategories' => 'কোনো উপশ্রেণী নাই',
	'categorytree-no-pages' => 'কোনো পৃষ্ঠা বা উপশ্রেণী নাই',
	'categorytree-not-found' => '<i>$1</i> শ্রেণীতো পোৱা নগল',
	'categorytree-error' => 'তথ্য জমাবলৈ সমস্যা হৈছে',
	'categorytree-retry' => 'অনুগ্রহ কৰি কিছু সময় অপেক্ষা কৰি তাৰ পিছত চেষ্টা কৰক।',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'categorytree' => 'Árbole de categoríes',
	'categorytree-portlet' => 'Categoríes',
	'categorytree-legend' => "Amosar l'árbole de categoríes",
	'categorytree-desc' => "Accesoriu basáu n'AJAX qu'amuesa la [[Special:CategoryTree|estructura de categoríes]] d'una wiki",
	'categorytree-header' => "Escribi un nome de categoría pa ver el so conteníu estructuráu en forma
d'árbole. Fíxate en qu'esto requier la erbía AJAX de JavaScript. Si tienes
un navegador mui antiguu o'l JavaScript desactiváu, nun va funcionar.",
	'categorytree-category' => 'Categoría:',
	'categorytree-go' => 'Amosar árbole',
	'categorytree-parents' => 'Categoríes superiores',
	'categorytree-mode-categories' => 'categoríes namái',
	'categorytree-mode-pages' => 'páxines sacante los archivos',
	'categorytree-mode-all' => 'toles páxines',
	'categorytree-collapse' => 'esconder',
	'categorytree-expand' => 'espandir',
	'categorytree-member-counts' => 'contién {{PLURAL:$1|1 subcategoría|$1 subcategoríes}}, {{PLURAL:$2|1 páxina|$2 páxines}} y {{PLURAL:$3|1 archivu|$3 archivos}}',
	'categorytree-load' => 'cargar',
	'categorytree-loading' => 'cargando',
	'categorytree-nothing-found' => "nun s'atopó nada",
	'categorytree-no-subcategories' => 'nun hai subcategoríes',
	'categorytree-no-parent-categories' => 'nun hai categoríes padre',
	'categorytree-no-pages' => 'ensin páxines nin subcategoríes',
	'categorytree-not-found' => "Nun s'atopó la categoría <i>$1</i>",
	'categorytree-error' => 'Hebo un problema al cargar los datos.',
	'categorytree-retry' => 'Por favor, espera unos momentos y inténtalo otra vuelta.',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'categorytree' => 'LomaAal',
	'categorytree-header' => 'Ta wira va aaldrekoraf cek va lomayolt bazel !
Stragal da batcoba va AJAX JavaScript fliaca kucilar.
Ede va guazafi exulesiki favel oke ede JavaScript fliaceem tir metegis, batcoba me guyundeter.',
	'categorytree-category' => 'Loma:',
	'categorytree-go' => 'Nedira va aal',
	'categorytree-parents' => 'Veylomeem',
	'categorytree-mode-categories' => 'Anton lomeem',
	'categorytree-mode-pages' => 'Bueem rade ewaveem',
	'categorytree-mode-all' => 'bueem',
	'categorytree-collapse' => 'koatcera',
	'categorytree-expand' => 'divatcera',
	'categorytree-load' => 'vajara',
	'categorytree-loading' => 'vajas',
	'categorytree-nothing-found' => 'mek trasiks',
	'categorytree-no-subcategories' => 'meka volveyloma',
	'categorytree-no-pages' => 'meku bu oku volveyloma',
	'categorytree-not-found' => '<i>$1</i> loma metrasiyina',
	'categorytree-error' => 'Zvak remi origvajara.',
	'categorytree-retry' => 'Vay kemel aze tolyawal !',
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'categorytree' => 'Kategorienbam',
	'categorytree-portlet' => 'Kategorien',
	'categorytree-legend' => 'in Kategorienbam ãnzoang',
	'categorytree-collapse' => 'eiklåppm',
	'categorytree-expand' => 'ausklåppm',
	'categorytree-load' => 'lådn',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 */
$messages['bat-smg'] = array(
	'categorytree' => 'Kateguorėju medis',
	'categorytree-category' => 'Kateguorėjė:',
	'categorytree-mode-all' => 'vėsė poslapē',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'categorytree' => 'درچک دسته',
	'categorytree-portlet' => 'دسته جات',
	'categorytree-legend' => 'پیش دار درچ دستهء',
	'categorytree-desc' => 'گجت آن آژاکسی په پیش دارگ [[Special:CategoryTree|شکل دسته]] یک ویکی',
	'categorytree-header' => 'یک نام دسته ای وارد کنیت تا شکل درچکی آییء پیش داریت.
توجه بیت که شی نیاز په پیشرپتگین عملگری جاوا اسکریپت په داب آژاکس داریت.
اگر شما را یک کهنه بروزر ای هستن یا جاوا اسکریپ غیر غعال انت آیی کار نه کنت.',
	'categorytree-category' => 'دسته:',
	'categorytree-go' => 'پیش دار درچکء',
	'categorytree-parents' => 'پت و مات آن',
	'categorytree-mode-categories' => 'فقط دسته جات',
	'categorytree-mode-pages' => 'صفحات بجر فایلان',
	'categorytree-mode-all' => 'کل صفحات',
	'categorytree-collapse' => 'سقوط',
	'categorytree-expand' => 'پچ',
	'categorytree-load' => 'لود',
	'categorytree-loading' => 'لودبیت...',
	'categorytree-nothing-found' => 'هچی در نه بوت',
	'categorytree-no-subcategories' => 'هچ زیر دسته ای',
	'categorytree-no-parent-categories' => 'دسته جات بی پت و مات',
	'categorytree-no-pages' => 'هچ صفحه یا زیر دسته',
	'categorytree-not-found' => 'دسته  <i>$1</i> در نه بوت',
	'categorytree-error' => 'مشکل لود دیتا',
	'categorytree-retry' => 'یک لحظه ای صبر کنیت و پدا دگه تلاش کن',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'categorytree-category' => 'Kategorya:',
	'categorytree-mode-all' => 'gabos na mga pahina',
	'categorytree-load' => 'ikarga',
	'categorytree-loading' => 'pigkakarga',
	'categorytree-nothing-found' => 'mayong nahanap',
	'categorytree-no-subcategories' => 'mayong mga sub-kategorya',
	'categorytree-no-pages' => 'mayong mga pahina o sub-kategorya',
	'categorytree-retry' => 'Paki halat mûna tapos probaran giraray.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author Cesco
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'categorytree' => 'Дрэва катэгорыяў',
	'categorytree-portlet' => 'Катэгорыі',
	'categorytree-legend' => 'Паказаць дрэва катэгорыяў',
	'categorytree-desc' => 'Заснаваная на AJAX прылада для паказу [[Special:CategoryTree|структуры катэгорыяў]] {{GRAMMAR:родны|{{SITENAME}}}}',
	'categorytree-header' => 'Увядзіце назву катэгорыі, каб пабачыць яе ў выглядзе дрэва.
Заўважце, што гэта патрабуе функцыянальнасьці JavaScript, вядомай як AJAX.
Калі ў Вас вельмі стары браўзэр, ці адключаны JavaScript, гэтая функцыя працаваць ня будзе.',
	'categorytree-category' => 'Катэгорыя:',
	'categorytree-go' => 'Паказаць дрэва',
	'categorytree-parents' => 'Продкі',
	'categorytree-mode-categories' => 'толькі катэгорыі',
	'categorytree-mode-pages' => 'старонкі за выключэньнем файлаў',
	'categorytree-mode-all' => 'усе старонкі',
	'categorytree-collapse' => 'згарнуць',
	'categorytree-expand' => 'разгарнуць',
	'categorytree-member-counts' => 'утрымлівае $1 {{PLURAL:$1|падкатэгорыю|падкатэгорыі|падкатэгорыяў}}, $2 {{PLURAL:$2|старонку|старонкі|старонак}} і $3 {{PLURAL:$3|файл|файлы|файлаў}}',
	'categorytree-load' => 'загрузіць',
	'categorytree-loading' => 'загрузка…',
	'categorytree-nothing-found' => 'нічога ня знойдзена',
	'categorytree-no-subcategories' => 'няма падкатэгорыяў',
	'categorytree-no-parent-categories' => 'няма бацькаўскіх катэгорыяў',
	'categorytree-no-pages' => 'няма старонак ці падкатэгорыяў',
	'categorytree-not-found' => 'Катэгорыя <i>$1</i> ня знойдзена',
	'categorytree-error' => 'Праблема загрузкі зьвестак.',
	'categorytree-retry' => 'Калі ласка, пачакайце і паспрабуйце яшчэ раз.',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'categorytree' => 'Дърво на категориите',
	'categorytree-portlet' => 'Категории',
	'categorytree-legend' => 'Показване на дървото с категориите',
	'categorytree-desc' => 'Инструмент на AJAX, който показва [[Special:CategoryTree|структурата на категориите]] в уикито',
	'categorytree-header' => 'Въведете категория, за да видите съдържанието й в дървовиден вид от категории. Имайте предвид, че това изисква допълнителна JavaScript-функционалност, позната като AJAX. Тази възможност не може да бъде използвана, ако използвате стар браузър или сте изключили поддържането на JavaScript.',
	'categorytree-category' => 'Категория',
	'categorytree-go' => 'Показване',
	'categorytree-parents' => 'Родителски категории',
	'categorytree-mode-categories' => 'само категории',
	'categorytree-mode-pages' => 'страници, без файлове',
	'categorytree-mode-all' => 'всички страници',
	'categorytree-collapse' => 'събиране',
	'categorytree-expand' => 'разпъване',
	'categorytree-member-counts' => 'съдържа {{PLURAL:$1|една подкатегория|$1 подкатегории}}, {{PLURAL:$2|една страница|$2 страници}} и {{PLURAL:$3|един файл|$3 файла}}',
	'categorytree-load' => 'зареждане',
	'categorytree-loading' => 'зареждане',
	'categorytree-nothing-found' => 'няма открити подкатегории',
	'categorytree-no-subcategories' => 'няма подкатегории',
	'categorytree-no-parent-categories' => 'няма родителски категории',
	'categorytree-no-pages' => 'няма страници или подкатегории',
	'categorytree-not-found' => 'Категорията <i>$1</i> не беше намерена',
	'categorytree-error' => 'Възникна проблем при зареждане на информацията.',
	'categorytree-retry' => 'Изчакайте малко и опитайте отново.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'categorytree' => 'বিষয়শ্রেণীবৃক্ষ',
	'categorytree-portlet' => 'বিষয়শ্রেণী',
	'categorytree-legend' => 'বিষয়শ্রেণীগুলো বৃক্ষ আকারে দেখাও',
	'categorytree-desc' => 'কোন উইকির [[Special:CategoryTree|বিষয়শ্রেণী কাঠামো]] প্রদর্শনের জন্য এজ্যাক্স-ভিত্তিক গ্যাজেট',
	'categorytree-header' => 'যে বিষয়শ্রেণীটির অন্তর্ভুক্ত বিষয়বস্তু বৃক্ষাকারে দেখতে চান, সেটির নাম প্রবেশ করান।
লক্ষ্য করুন এর জন্য এজ্যাক্স নামের একটি অগ্রসর জাভাস্ক্রিপ্ট কৌশল ব্যবহার করা হয়।
যদি আপনার ব্রাউজারটি খুব পুরনো হয়, বা যদি জাভাস্ক্রিপ্ট নিষ্ক্রিয় করা থাকে, তবে এটি কাজ করবে না।',
	'categorytree-category' => 'বিষয়শ্রেণী:',
	'categorytree-go' => 'বৃক্ষ দেখানো হোক',
	'categorytree-parents' => 'পিতামাতা',
	'categorytree-mode-categories' => 'শুধুমাত্র বিষয়শ্রেণী',
	'categorytree-mode-pages' => 'ফাইল ব্যতীত পাতাসমূহ',
	'categorytree-mode-all' => 'সব পাতা',
	'categorytree-collapse' => 'গুটিয়ে ফেলা হোক',
	'categorytree-expand' => 'প্রসারিত করা হোক',
	'categorytree-load' => 'নিয়ে আসা হোক',
	'categorytree-loading' => 'নিয়ে আসা হচ্ছে',
	'categorytree-nothing-found' => 'কিছু পাওয়া যায়নি',
	'categorytree-no-subcategories' => 'কোন উপ-বিষয়শ্রেণী নেই',
	'categorytree-no-parent-categories' => 'কোন মূল বিষয়শ্রেণী নাই',
	'categorytree-no-pages' => 'কোন পাতা বা উপ-বিষয়শ্রেণী নেই',
	'categorytree-not-found' => '<i>$1</i> বিষয়শ্রেণীটি খুঁজে পাওয়া যায়নি',
	'categorytree-error' => 'উপাত্ত নিয়ে আসতে সমস্যা।',
	'categorytree-retry' => 'অনুগ্রহ করে একটু অপেক্ষা করে আবার চেষ্টা করুন।',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'categorytree' => 'Gwezennadur ar rummadoù',
	'categorytree-portlet' => 'Rummadoù',
	'categorytree-legend' => 'Gwelet gwezennadur ar rummad',
	'categorytree-desc' => 'Bitrak diazezet war AJAX evit diskouez [[Special:CategoryTree|framm rummad]] ur wiki',
	'categorytree-header' => "Merkit anv ur rummad evit gwelet petra zo ennañ e stumm ur gwezennadur. 
Notit e rankit kaout an arc'hwelioù JavaScript araokaet anvet AJAX.
M'eo kozh-mat stumm ho merdeer pe m'eo diweredekaet JavaScript ganeoc'h, ne'z aio ket en-dro.",
	'categorytree-category' => 'Rummad:',
	'categorytree-go' => 'Diskouez ar gwezennadur',
	'categorytree-parents' => 'Usrummadoù',
	'categorytree-mode-categories' => 'Rummadoù hepken',
	'categorytree-mode-pages' => 'Pajennoù hep ar skeudennoù',
	'categorytree-mode-all' => 'an holl bajennoù',
	'categorytree-collapse' => 'Serriñ',
	'categorytree-expand' => 'Dispakañ',
	'categorytree-member-counts' => 'ennañ {{PLURAL:$1|1 isrummad|$1 isrummad}}, {{PLURAL:$2|1 bajenn|$2 pajenn}}, ha {{PLURAL:$3|1 restr|$3 restr}}',
	'categorytree-load' => 'kargañ',
	'categorytree-loading' => 'o kargañ',
	'categorytree-nothing-found' => 'Netra bet kavet',
	'categorytree-no-subcategories' => 'isrummad ebet',
	'categorytree-no-parent-categories' => 'Rummad kar ebet',
	'categorytree-no-pages' => 'Pennad ebet hag isrummad ebet',
	'categorytree-not-found' => "N'eo ket bet kavet ar rummad <i>$1</i>",
	'categorytree-error' => 'Ur gudenn zo bet e-ser kargañ ar roadennoù.',
	'categorytree-retry' => 'Gortozit un tamm ha klaskit en-dro.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author editors of bs.wikipedia
 */
$messages['bs'] = array(
	'categorytree' => 'Stablo kategorije',
	'categorytree-portlet' => 'Kategorije',
	'categorytree-legend' => 'Prikazuje stablo kategorija',
	'categorytree-desc' => 'Dinamičko pregledavanje [[Special:CategoryTree|strukture kategorija]]',
	'categorytree-header' => 'Unesite ime kategorije da vidite njen sadržaj kao strukturno stablo. Ovo zahtijeva proširenu JavaScript funkcionalnost kao AJAX. Ako imate neki stariji Internet preglednik, ili ste iskljucili JavaScript, ovo nece raditi.',
	'categorytree-category' => 'Kategorija',
	'categorytree-go' => 'Prikaži stablo',
	'categorytree-parents' => 'Nadkategorije',
	'categorytree-mode-categories' => 'samo kategorije',
	'categorytree-mode-pages' => 'stranice umjesto slika',
	'categorytree-mode-all' => 'sve stranice',
	'categorytree-collapse' => 'sakrij',
	'categorytree-expand' => 'proširi',
	'categorytree-member-counts' => 'sadrži {{PLURAL:$1|jednu podkategoriju|$1 podkategorije|$1 podkategorija}}, {{PLURAL:$2|jednu stranicu|$2 stranice|$2 stranica}} i {{PLURAL:$3|jednu datoteku|$3 datoteke|$3 datoteka}}',
	'categorytree-load' => 'ucitaj',
	'categorytree-loading' => 'ucitavam',
	'categorytree-nothing-found' => 'nema podkategorija',
	'categorytree-no-subcategories' => 'nema podkategorija',
	'categorytree-no-parent-categories' => 'nema nadređene kategorije',
	'categorytree-no-pages' => 'nema podkategorija ili clanaka',
	'categorytree-not-found' => 'Kategorija <i>$1</i> nije nađena',
	'categorytree-error' => 'Problem pri punjenju podataka.',
	'categorytree-retry' => 'Molimo pričekate trenutak i pokušajte ponovno.',
);

/** Catalan (Català)
 * @author Aleator
 * @author Paucabot
 * @author SMP
 * @author Vriullop
 */
$messages['ca'] = array(
	'categorytree' => 'Categories en arbre',
	'categorytree-portlet' => 'Categories',
	'categorytree-legend' => "Mostra l'arbre de categories",
	'categorytree-desc' => "Gadget fet amb AJAX per a mostrar l'[[Special:CategoryTree|estructura de les categories]] d'un wiki",
	'categorytree-header' => "Entreu el nom d'una categoria per a veure l'arbre del seu contingut. Aquesta pàgina utilitza una funcionalitat avançada del JavaScript coneguda com a AJAX, i no funciona en navegadors antics o que tinguin el JavaScript desactivat.",
	'categorytree-category' => 'Categoria:',
	'categorytree-go' => 'Carregueu',
	'categorytree-parents' => 'Categories pare',
	'categorytree-mode-categories' => 'mostra només categories',
	'categorytree-mode-pages' => 'mostra categories i pàgines',
	'categorytree-mode-all' => 'mostra categories, pàgines i imatges',
	'categorytree-collapse' => 'Tancar',
	'categorytree-expand' => 'Expandir',
	'categorytree-member-counts' => 'conté {{PLURAL:$1|1 subcategoria|$1 subcategories}}, {{PLURAL:$2|1 pàgina|$2 pàgines}}, i {{PLURAL:$3|1 fitxer|$3 fitxers}}',
	'categorytree-load' => 'Carrega',
	'categorytree-loading' => 'carregant',
	'categorytree-nothing-found' => 'no hi ha sub-categories',
	'categorytree-no-subcategories' => 'no hi ha subcategories.',
	'categorytree-no-parent-categories' => "No s'han trobat categories mare",
	'categorytree-no-pages' => 'no hi ha articles o subcategories.',
	'categorytree-not-found' => "No s'ha trobat la categoria ''$1''.",
	'categorytree-error' => 'Problema en la càrrega de dades.',
	'categorytree-retry' => 'Torneu-ho a intentar en uns moments.',
);

/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄)
 * @author GnuDoyng
 */
$messages['cdo'] = array(
	'categorytree' => 'Lôi-biék chéu',
	'categorytree-header' => 'Sṳ̆-ĭk lôi-biék miàng-chĭng, káng ĭ gì chéu-hìng giék-gáiu. Chiāng cé̤ṳ-é, ciā hiĕk-miêng sāi-ê̤ṳng siŏh cṳ̄ng gŏ̤-gék JavaScript gé-sŭk, giéu lō̤ AJAX. Nṳ̄ nâ sāi-ê̤ṳng guó-sì gì báuk-lāng-ké, hĕ̤k-ciā cĕk lâi JavaScript, cêu mâ̤ ciáng-siòng gĕ̤ng-cáuk.',
	'categorytree-category' => 'Hŭng-lôi',
	'categorytree-go' => 'Hiēng-sê chéu',
	'categorytree-mode-categories' => 'nâ ô lôi-biék',
	'categorytree-mode-pages' => 'dù-piéng ī-nguôi gì hiĕk-miêng',
	'categorytree-mode-all' => 'tĕ̤k-chṳ̄',
	'categorytree-loading' => 'tĕ̤k-chṳ̄',
	'categorytree-no-subcategories' => 'mò̤ cṳ̄-lôi-biék',
	'categorytree-no-pages' => 'mò̤ hiĕk-miêng hĕ̤k cṳ̄-lôi-biék',
	'categorytree-not-found' => 'Mò̤ tō̤ diŏh lôi-biék <i>$1</i>',
);

/** Cebuano (Cebuano)
 * @author Abastillas
 */
$messages['ceb'] = array(
	'categorytree-portlet' => 'Mga kategoriya',
	'categorytree-category' => 'Kategoriya:',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'categorytree-category' => 'Categuria:',
	'categorytree-mode-pages' => 'pagine senza imagin',
	'categorytree-mode-all' => 'tutte e pagine',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'categorytree' => 'Strom kategorií',
	'categorytree-portlet' => 'Kategorie',
	'categorytree-legend' => 'Zobrazí strom kategorie',
	'categorytree-desc' => 'Ajaxový nástroj zobrazující [[Special:CategoryTree|stromovou strukturu kategorií]] na této wiki',
	'categorytree-header' => 'Zadejte název kategorie k&nbsp;zobrazení jejího obsahu jako stromové struktury.

(Tato funkce vyžaduje pokročilé funkce JavaScriptu známé jako Ajax. Jestliže máte velmi starý prohlížeč nebo vypnutý JavaScript, nezobrazí se strom správně nebo vůbec.)',
	'categorytree-category' => 'Kategorie',
	'categorytree-go' => 'Zobrazit',
	'categorytree-parents' => 'Nadřazené kategorie',
	'categorytree-mode-categories' => 'pouze kategorie',
	'categorytree-mode-pages' => 'stránky kromě souborů',
	'categorytree-mode-all' => 'všechny stránky',
	'categorytree-collapse' => 'zavřít',
	'categorytree-expand' => 'otevřít',
	'categorytree-member-counts' => 'obsahuje {{PLURAL:$1|1 podkategorii|$1 podkategorie|$1 podkategorií}}, {{PLURAL:$2|1 stránku|$2 stránky|$2 stránek}} a {{PLURAL:$3|1 soubor|$3 soubory|$3 souborů}}',
	'categorytree-load' => 'načíst',
	'categorytree-loading' => 'načítá se',
	'categorytree-nothing-found' => 'nic nebylo nalezeno',
	'categorytree-no-subcategories' => 'žádné podkategorie.',
	'categorytree-no-parent-categories' => 'žádné nadřazené kategorie',
	'categorytree-no-pages' => 'žádné články ani podkategorie.',
	'categorytree-not-found' => 'Kategorie <em>$1</em> nenalezena',
	'categorytree-error' => 'Chyba při načítání dat.',
	'categorytree-retry' => 'Počkejte chvilku a zkuste to znova.',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'categorytree-portlet' => 'катигорі́ѩ',
	'categorytree-category' => 'катигорі́ꙗ :',
	'categorytree-mode-all' => 'вьсѩ́ страни́цѧ',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'categorytree' => 'CoedenGategori',
	'categorytree-portlet' => 'Categorïau',
	'categorytree-legend' => 'Dangos y goeden gategori',
	'categorytree-desc' => "Teclyn AJAX yn arddangos [[Special:CategoryTree|adeiledd categorïau]]'r wici",
	'categorytree-header' => "Teipiwch enw categori yn y blwch er mwyn gweld ei gynnwys ar lun coeden. 
Sylwer bod yn rhaid defnyddio offer uwch Sgript Java o'r enw AJAX er mwyn gwneud hyn. 
Ni lwydda'r gofyniad os yw'ch porwr yn hen iawn neu os nad yw Sgript Java wedi ei alluogi.",
	'categorytree-category' => 'Categori:',
	'categorytree-go' => 'Dangos y Goeden',
	'categorytree-parents' => 'Rhieni',
	'categorytree-mode-categories' => 'categorïau yn unig',
	'categorytree-mode-pages' => 'tudalennau ag eithrio ffeiliau',
	'categorytree-mode-all' => 'pob tudalen',
	'categorytree-collapse' => 'crebachu',
	'categorytree-expand' => 'ehangu',
	'categorytree-member-counts' => 'yn cynnwys y canlynol: {{PLURAL:$1|$1 is-gategori}}, $2 {{PLURAL:$2|tudalen|dudalen|dudalen|tudalen|thudalen|tudalen}}, {{PLURAL:$3|$3 ffeil}}',
	'categorytree-load' => 'llwytho',
	'categorytree-loading' => "wrthi'n llwytho...",
	'categorytree-nothing-found' => "dim i'w gael",
	'categorytree-no-subcategories' => 'dim is-gategorïau',
	'categorytree-no-parent-categories' => 'dim uwch-gategorïau',
	'categorytree-no-pages' => 'dim tudalennau nag is-gategorïau',
	'categorytree-not-found' => "Heb ddod o hyd i'r categori <i>$1</i>",
	'categorytree-error' => "Cafwyd problem wrth lwytho'r data.",
	'categorytree-retry' => 'Arhoswch ennyd, yna ceisiwch eto.',
);

/** Danish (Dansk)
 * @author Barklund
 * @author Byrial
 * @author Fredelige
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'categorytree' => 'Kategoritræ',
	'categorytree-portlet' => 'Kategorier',
	'categorytree-legend' => 'Vis kategoritræ',
	'categorytree-desc' => 'Dynamisk navigation i [[Special:CategoryTree|kategoristrukturen]]',
	'categorytree-header' => 'Indtast navnet på en kategori for at se indholdet som et træ. Bemærk at dette kræver avanceret JavaScript-funktionalitet kendt som AJAX, det virker ikke hvis du har en meget gammel browser eller hvis du har slået JavaScript fra.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Vis træ',
	'categorytree-parents' => 'Overkategorier',
	'categorytree-mode-categories' => 'kun kategorier',
	'categorytree-mode-pages' => 'sider med undtagelse af filer',
	'categorytree-mode-all' => 'alle sider',
	'categorytree-collapse' => 'fold sammen',
	'categorytree-expand' => 'fold ud',
	'categorytree-member-counts' => 'indeholder {{PLURAL:$1|én underkategori|$1 underkategorier}}, {{PLURAL:$2|én side|$2 sider}} og {{PLURAL:$3|én fil|$3 filer}}',
	'categorytree-load' => 'hent',
	'categorytree-loading' => 'indlæser',
	'categorytree-nothing-found' => 'intet fundet',
	'categorytree-no-subcategories' => 'ingen underkategorier',
	'categorytree-no-parent-categories' => 'ingen overkategorier',
	'categorytree-no-pages' => 'ingen artikler eller underkategorier',
	'categorytree-not-found' => "Kategorien ''$1'' blev ikke fundet",
	'categorytree-error' => 'Der opstod et problem under indlæsning af data.',
	'categorytree-retry' => 'Vent et øjeblik og prøv igen.',
);

/** German (Deutsch)
 * @author Daniel Kinzler, brightbyte.de
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'categorytree' => 'Kategorienbaum',
	'categorytree-portlet' => 'Kategorien',
	'categorytree-legend' => 'Zeige Kategorienbaum',
	'categorytree-desc' => 'Dynamische Navigation für die [[Special:CategoryTree|Kategorien-Struktur]]',
	'categorytree-header' => 'Zeigt für die angegebene Kategorie die Unterkategorien in einer Baumstruktur.
Diese Seite benötigt bestimmte JavaScript-Funktionen (Ajax) und funktioniert möglicherweise nicht, wenn JavaScript ausgeschaltet ist oder ein sehr alter Browser verwendet wird.',
	'categorytree-category' => 'Kategorie:',
	'categorytree-go' => 'Laden',
	'categorytree-parents' => 'Oberkategorien',
	'categorytree-mode-categories' => 'nur Kategorien',
	'categorytree-mode-pages' => 'Seiten außer Dateien',
	'categorytree-mode-all' => 'alle Seiten',
	'categorytree-collapse' => 'einklappen',
	'categorytree-expand' => 'ausklappen',
	'categorytree-member-counts' => 'enthält {{PLURAL:$1|1 Unterkategorie|$1 Unterkategorien}}, {{PLURAL:$2|1 Seite|$2 Seiten}} und {{PLURAL:$3|1 Datei|$3 Dateien}}',
	'categorytree-load' => 'laden',
	'categorytree-loading' => 'laden …',
	'categorytree-nothing-found' => 'Nichts gefunden',
	'categorytree-no-subcategories' => 'Keine Unterkategorien',
	'categorytree-no-parent-categories' => 'Keine Oberkategorien',
	'categorytree-no-pages' => 'Keine Seite oder Unterkategorien',
	'categorytree-not-found' => 'Kategorie „$1“ nicht gefunden',
	'categorytree-error' => 'Probleme beim Laden der Daten.',
	'categorytree-retry' => 'Bitte warte einen Moment und versuche es dann erneut.',
);

/** Swiss High German (Schweizer Hochdeutsch)
 * @author MichaelFrey
 */
$messages['de-ch'] = array(
	'categorytree-mode-pages' => 'Seiten ausser Dateien',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Raimond Spekking
 */
$messages['de-formal'] = array(
	'categorytree-retry' => 'Bitte warten Sie einen Moment und versuchen Sie es dann erneut.',
);

/** Zazaki (Zazaki) */
$messages['diq'] = array(
	'categorytree' => 'Dara Kategoriye',
	'categorytree-category' => 'Kategoriye:',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'categorytree' => 'Bom kategorijow',
	'categorytree-portlet' => 'Kategorije',
	'categorytree-legend' => 'Kategorijowy bom pokazaś',
	'categorytree-desc' => 'Dynamiski pśez [[Special:CategoryTree|kategorijowu strukturu]] nawigěrowaś',
	'categorytree-header' => 'Zapódaj mě kategorije, aby jeje wopśimjeśe ako bomowu strukturu wiźeł.
Glědaj, až se to wěste funkcije JavaScripta pomina, znate ako AJAX.
Jolic maš wjelgin stary browser abo jolic JavaScript jo wótšaltowane, toś ten bok ewentuelnje njefunkcioněrujo.',
	'categorytree-category' => 'Kategorija:',
	'categorytree-go' => 'Bom pokazaś',
	'categorytree-parents' => 'Wuše kategorije',
	'categorytree-mode-categories' => 'jano kategorije',
	'categorytree-mode-pages' => 'Boki mimo datajow',
	'categorytree-mode-all' => 'wšykne boki',
	'categorytree-collapse' => 'złožyś',
	'categorytree-expand' => 'rozłožyś',
	'categorytree-member-counts' => 'wopśimujo {{PLURAL:$1|1 pódkategoriju|$1 pódkategoriji|$1 pódkategorije|$1 pódkategorijow}}, {{PLURAL:$2|1 bok|$2 boka|$2 boki|$2 bokow}} a {{PLURAL:$3|1 dataju|$3 dataji|$3 dataje|$3 datajow}}',
	'categorytree-load' => 'lodowaś',
	'categorytree-loading' => 'lodujo se...',
	'categorytree-nothing-found' => 'Nic namakany',
	'categorytree-no-subcategories' => 'Žedne pódkategorije',
	'categorytree-no-parent-categories' => 'žedne wuše kategorije',
	'categorytree-no-pages' => 'Žedne boki abo pódkategorije',
	'categorytree-not-found' => 'Kategorija <i>$1</i> njenamakana',
	'categorytree-error' => 'Problem pśi lodowanju datow.',
	'categorytree-retry' => 'Pócakaj pšosym moment a wopytaj hyšći raz.',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'categorytree-mode-all' => 'axawo katã',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Dead3y3
 * @author ZaDiak
 */
$messages['el'] = array(
	'categorytree' => 'Δέντρο κατηγορίας',
	'categorytree-portlet' => 'Κατηγορίες',
	'categorytree-legend' => 'Εμφάνιση δέντρου κατηγορίας',
	'categorytree-desc' => 'Πλοηγηθείτε δυναμικά στη [[Special:CategoryTree|δομή της κατηγορίας]]',
	'categorytree-header' => 'Εισάγετε ένα όνομα κατηγορίας για να δείτε τα περιεχόμενά της ως δεντρική δομή.
Σημειώστε ότι αυτό απαιτεί προηγμένη λειτουργικότητα JavaScript, γνωστή ως AJAX.
Αν έχετε έναν πολύ παλιό browser ή την JavaScript απενεργοποιημένη, δεν θα δουλέψει.',
	'categorytree-category' => 'Κατηγορία:',
	'categorytree-go' => 'Εμφάνιση δέντρου',
	'categorytree-parents' => 'Γονείς',
	'categorytree-mode-categories' => 'μόνο κατηγορίες',
	'categorytree-mode-pages' => 'Σελίδες εξαιρουμένων αρχείων',
	'categorytree-mode-all' => 'όλες οι σελίδες',
	'categorytree-collapse' => 'κατάρρευση',
	'categorytree-expand' => 'επέκτεινε',
	'categorytree-member-counts' => 'περιέχει {{PLURAL:$1|1 υποκατηγορία|$1 υποκατηγορίες}}, {{PLURAL:$2|1 σελίδα|$2 σελίδες}} και {{PLURAL:$3|1 αρχείο|$3 αρχεία}}',
	'categorytree-load' => 'φορτώστε',
	'categorytree-loading' => 'φόρτωση',
	'categorytree-nothing-found' => 'δεν βρέθηκε τίποτα',
	'categorytree-no-subcategories' => 'καμία υποκατηγορία',
	'categorytree-no-parent-categories' => 'δεν υπάρχουν πατρικές κατηγορίες',
	'categorytree-no-pages' => 'καμία σελίδα ή υποκατηγορία',
	'categorytree-not-found' => 'Η κατηγορία <i>$1</i> δεν βρέθηκε',
	'categorytree-error' => 'Πρόβλημα φόρτωσης δεδομένων.',
	'categorytree-retry' => 'Παρακαλώ περιμένετε μια στιγμή και προσπαθήστε ξανά.',
);

/** Esperanto (Esperanto)
 * @author Tlustulimu
 * @author Yekrats
 */
$messages['eo'] = array(
	'categorytree' => 'Kategoriarbo',
	'categorytree-portlet' => 'Kategorioj',
	'categorytree-legend' => 'Montri kategorian arbon',
	'categorytree-desc' => 'AJAX-bazita aldonaĵo por montri la [[Special:CategoryTree|kategorian strukturon]] de vikio',
	'categorytree-header' => 'Tajpu kategorinomon por vidi ties entenon en arbforma strukturo. Notu ke tio postulas javaskripatajn funkciojn nomitajn AJAX. Se via foliumilo estas tre malnova au se Javaskripto estas malaktivigita, tio ne funkcios.',
	'categorytree-category' => 'Kategorio:',
	'categorytree-go' => 'Montri arbon',
	'categorytree-parents' => 'praul(ar)o',
	'categorytree-mode-categories' => 'nur kategorioj',
	'categorytree-mode-pages' => 'paĝoj krom dosieroj',
	'categorytree-mode-all' => 'ĉiuj paĝoj',
	'categorytree-collapse' => 'kunfaldi',
	'categorytree-expand' => 'etendi',
	'categorytree-member-counts' => 'enhavas {{PLURAL:$1|1 subkategorion|$1 subkategoriojn}}, {{PLURAL:$2|1 paĝon|$2 paĝojn}}, kaj {{PLURAL:$3|1 dosieron|$3 dosierojn}}',
	'categorytree-load' => 'elŝuti',
	'categorytree-loading' => 'elŝutante...',
	'categorytree-nothing-found' => 'nenio trovita',
	'categorytree-no-subcategories' => 'neniu subkategorio',
	'categorytree-no-parent-categories' => 'neniuj superaj kategorioj',
	'categorytree-no-pages' => 'neniu pago o subkategorio',
	'categorytree-not-found' => 'La kategorio <i>$1</i> ne estis trovita.',
	'categorytree-error' => 'Problemo ŝarĝante datenojn',
	'categorytree-retry' => 'Bonvolu atendi momenton kaj provi denove.',
);

/** Spanish (Español)
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 */
$messages['es'] = array(
	'categorytree' => 'Árbol de categorías (CategoryTree)',
	'categorytree-portlet' => 'Categorías',
	'categorytree-legend' => 'Mostrar el árbol de categorías',
	'categorytree-desc' => 'Navegar dinámicamente por la [[Special:CategoryTree|estructura de categorías]]',
	'categorytree-header' => 'Escribe un nombre de categoría para ver su contenido con una estructura en árbol.
Ten en cuenta que esto requiere funciones JavaScript avanzadas conocidas como AJAX.
Si tienes un navegador antiguo, o tienes deshabilitado el JavaScript, esto no funcionará.',
	'categorytree-category' => 'Categoría:',
	'categorytree-go' => 'Cargar',
	'categorytree-parents' => 'Categorías superiores',
	'categorytree-mode-categories' => 'mostrar sólo categorías',
	'categorytree-mode-pages' => 'páginas excepto imágenes',
	'categorytree-mode-all' => 'todas las páginas',
	'categorytree-collapse' => 'ocultar',
	'categorytree-expand' => 'mostrar',
	'categorytree-member-counts' => 'contiene {{PLURAL:$1|una subcategoría|$1 subcategorías}}, {{PLURAL:$2|una página|$2 páginas}}, y {{PLURAL:$3|un archivo|$3 archivos}}',
	'categorytree-load' => 'cargar',
	'categorytree-loading' => 'cargando',
	'categorytree-nothing-found' => 'Lo sentimos, no se ha encontrado nada',
	'categorytree-no-subcategories' => 'sin subcategorías.',
	'categorytree-no-parent-categories' => 'no hay categorías superiores',
	'categorytree-no-pages' => 'sin artículos ni subcategorías.',
	'categorytree-not-found' => "Categoría ''$1'' no encontrada",
	'categorytree-error' => 'Error al cargar los datos',
	'categorytree-retry' => 'Por favor, espera un momento y vuelve a intentarlo.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Jaan513
 */
$messages['et'] = array(
	'categorytree' => 'Kategooriapuu',
	'categorytree-portlet' => 'Kategooriad',
	'categorytree-legend' => 'Näita kategooriapuud',
	'categorytree-category' => 'Kategooria:',
	'categorytree-mode-categories' => 'ainult kategooriad',
	'categorytree-mode-pages' => 'leheküljed, välja arvatud pildid',
	'categorytree-mode-all' => 'kõik leheküljed',
	'categorytree-nothing-found' => 'ei leitud midagi',
	'categorytree-no-subcategories' => 'alamkategooriaid ei ole',
	'categorytree-not-found' => 'Kategooriat <i>$1</i> ei leitud.',
	'categorytree-retry' => 'Palun oota hetk ja proovi uuesti.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Theklan
 */
$messages['eu'] = array(
	'categorytree' => 'Kategoria Zuhaitza',
	'categorytree-portlet' => 'Kategoriak',
	'categorytree-legend' => 'Erakutsi kategoria zuhaitza',
	'categorytree-desc' => 'Dinamikoki nabigatu [[Special:CategoryTree|kategoria zuhaitza]]',
	'categorytree-header' => 'Idatzi kategoria baten izena bere edukia zuhaitz eran ikusteko. Kontuan izan horrek AJAX bezala ezagutzen diren JavaScript funtzio aurreratuen beharra duela. Nabigatzaile zahar bat erabiltzen baduzu, edo JavaScript ezgaituta badaukazu, ez du funtzionatuko.',
	'categorytree-category' => 'Kategoria',
	'categorytree-go' => 'Zuhaitza erakutsi',
	'categorytree-parents' => 'Gurasoak',
	'categorytree-mode-categories' => 'kategoriak bakarrik',
	'categorytree-mode-pages' => 'orrialdeak, irudiak ezik',
	'categorytree-mode-all' => 'orrialde guztiak',
	'categorytree-collapse' => 'itxi',
	'categorytree-expand' => 'zabaldu',
	'categorytree-member-counts' => '{{PLURAL:$1|azpikategoria 1|$1 azpikategoria}}, {{PLURAL:$2|orrialde 1|$2 orrialde}} eta {{PLURALK:$3|fitxategi 1|$3 fitxategi}} ditu',
	'categorytree-load' => 'kargatu',
	'categorytree-loading' => 'kargatzen',
	'categorytree-nothing-found' => 'ez da ezer aurkitu',
	'categorytree-no-subcategories' => 'ez dago azpikategoriarik',
	'categorytree-no-parent-categories' => 'ez dago kategoria gurasorik',
	'categorytree-no-pages' => 'ez dago orrialde edo azpikategoriarik',
	'categorytree-not-found' => 'Ez da <i>$1</i> kategoria aurkitu',
	'categorytree-error' => 'Arazoa datuak kargatzerakoan.',
	'categorytree-retry' => 'Itxaron pixka bat eta saiatu berriz.',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'categorytree' => 'Arbu e categorias',
	'categorytree-category' => 'Categoria:',
	'categorytree-load' => 'cargal',
	'categorytree-loading' => 'cargandu',
	'categorytree-no-pages' => 'nu ai ni páhinas ni sucategorias',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'categorytree' => 'درخت رده',
	'categorytree-portlet' => 'رده‌ها',
	'categorytree-legend' => 'نمایش درخت رده',
	'categorytree-desc' => 'ابزار مبتنی بر AJAX برای نمایش [[Special:CategoryTree|ساختار رده‌های]] یک ویکی',
	'categorytree-header' => 'نام یک رده را وارد کنید تا محتویات آن به صورت درخت نمایش یابد. توجه کنید که این کار نیاز به قابلیت‌های پیشرفتهٔ جاوااسکریپت موسوم به آژاکس دارد. اگر از مرورگری خیلی قدیمی استفاده می‌کنید یا جاوااسکریپت را غیرفعال کرده‌اید، کار نمی‌کند.',
	'categorytree-category' => 'رده',
	'categorytree-go' => 'نمايش درخت',
	'categorytree-parents' => 'والدین',
	'categorytree-mode-categories' => 'فقط رده‌ها',
	'categorytree-mode-pages' => 'صفحه‌های جز تصویر',
	'categorytree-mode-all' => 'همهٔ صفحه‌ها',
	'categorytree-collapse' => 'مچالش',
	'categorytree-expand' => 'گسترش',
	'categorytree-member-counts' => 'شامل {{PLURAL:$1|یک زیررده|$1 زیررده}}، {{PLURAL:$2|یک صفحه|$2 صفحه}} و {{PLURAL:$3|یک پرونده|$3 پرونده است}}',
	'categorytree-load' => 'بارکردن',
	'categorytree-loading' => 'در حال بارگیری',
	'categorytree-nothing-found' => 'هیچ‌چیز یافت نشد.',
	'categorytree-no-subcategories' => 'هیچ زیررده‌ای ندارد.',
	'categorytree-no-parent-categories' => 'فاقد ردهٔ بالاتر',
	'categorytree-no-pages' => 'هیچ صفحه یا زیررده‌ای ندارد.',
	'categorytree-not-found' => "ردهٔ  ''$1'' يافت نشد.",
	'categorytree-error' => 'اشکال در دریافت اطلاعات.',
	'categorytree-retry' => 'لطفاً چند لحظه صبر کنید و سپس دوباره امتحان کنید.',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'categorytree' => 'Luokkapuu',
	'categorytree-portlet' => 'Luokat',
	'categorytree-legend' => 'Näytä luokkapuu',
	'categorytree-desc' => 'AJAX-pohjainen laajennus, joka näyttää wikin [[Special:CategoryTree|luokkapuurakenteen]].',
	'categorytree-header' => 'Syötä alle luokka, jonka haluat nähdä puumuodossa. Tämä toiminnallisuus vaatii kehittyneen JavaScript-tuen, jota kutsutaan AJAXiksi. Jos sinulla on vanha selain, tai JavaScript ei ole päällä, tämä ominaisuus ei toimi.',
	'categorytree-category' => 'Luokka',
	'categorytree-go' => 'Näytä puu',
	'categorytree-parents' => 'Yläluokat',
	'categorytree-mode-categories' => 'vain luokat',
	'categorytree-mode-pages' => 'kaikki sivut kuvia lukuun ottamatta',
	'categorytree-mode-all' => 'kaikki sivut',
	'categorytree-collapse' => 'piilota',
	'categorytree-expand' => 'näytä',
	'categorytree-member-counts' => 'sisältää {{PLURAL:$1|1 alaluokan|$1 alaluokkaa}}, {{PLURAL:$2|1 sivun|$2 sivua}} ja {{PLURAL:$3|1 tiedoston|$3 tiedostoa}}',
	'categorytree-load' => 'näytä',
	'categorytree-loading' => 'etsitään',
	'categorytree-nothing-found' => 'ei alaluokkia',
	'categorytree-no-subcategories' => 'ei alaluokkia',
	'categorytree-no-parent-categories' => 'ei yläluokkia',
	'categorytree-no-pages' => 'ei sivuja eikä alaluokkia',
	'categorytree-not-found' => 'Luokkaa <i>$1</i> ei löytynyt',
	'categorytree-error' => 'Ongelma tietojen latauksessa.',
	'categorytree-retry' => 'Odota hetki ja yritä uudelleen.',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'categorytree' => 'BólkaTræ',
	'categorytree-category' => 'Bólkur:',
	'categorytree-go' => 'Vís træ',
	'categorytree-mode-all' => 'allar síður',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Meithal
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'categorytree' => 'Arborescence des catégories',
	'categorytree-portlet' => 'Catégories',
	'categorytree-legend' => 'Visionner l’arborescence de la catégorie',
	'categorytree-desc' => 'Gadget basé sur AJAX pour afficher la [[Special:CategoryTree|structure de la catégorie]] d’un wiki',
	'categorytree-header' => 'Entrez un nom de catégorie pour voir son contenu en structure arborescente. Ceci utilise des fonctionnalités JavaScript avancées connues sous le nom d’AJAX. Si vous avez un très vieux navigateur Web ou si vous n’avez pas activé la fonctionnalité JavaScript, cela ne fonctionnera pas.',
	'categorytree-category' => 'Catégorie',
	'categorytree-go' => 'voir l’arborescence',
	'categorytree-parents' => 'super-catégorie(s)',
	'categorytree-mode-categories' => 'seulement les catégories',
	'categorytree-mode-pages' => 'pages sans les images',
	'categorytree-mode-all' => 'toutes les pages',
	'categorytree-collapse' => 'Refermer',
	'categorytree-expand' => 'Développer',
	'categorytree-member-counts' => 'contient $1 sous-catégorie{{PLURAL:$1||s}}, $2 page{{PLURAL:$2||s}} et $3 fichier{{PLURAL:$3||s}}',
	'categorytree-load' => 'charger',
	'categorytree-loading' => 'chargement...',
	'categorytree-nothing-found' => 'Aucune trouvée',
	'categorytree-no-subcategories' => 'Aucune sous-catégorie',
	'categorytree-no-parent-categories' => 'Aucune catégorie parente',
	'categorytree-no-pages' => 'Aucune page ou sous-catégorie.',
	'categorytree-not-found' => 'Catégorie <tt>$1</tt> introuvable',
	'categorytree-error' => 'Problème de chargement des données.',
	'categorytree-retry' => 'Veuillez attendre un instant puis réessayer.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'categorytree' => 'Arborèscence de les catègories',
	'categorytree-desc' => 'Outil basâ dessus AJAX por afichiér la [[Special:CategoryTree|structura de la catègorie]] d’un vouiqui',
	'categorytree-header' => 'Entrâd un nom de catègorie por vêre son contegnu en structura arborèscenta.
Cen utilise des fonccionalitâts JavaScript avanciês cognues desot lo nom d’AJAX.
Se vos avéd un rudo viely navigator Malyâjo ou que vos éd pas activâ la fonccionalitât JavaScript, cen fonccionerat pas.',
	'categorytree-category' => 'Catègorie:',
	'categorytree-go' => 'Afichiér l’arborèscence',
	'categorytree-parents' => 'Sur-catègorie(s) ',
	'categorytree-mode-categories' => 'ren que les catègories',
	'categorytree-mode-pages' => 'pâges sen les émâges',
	'categorytree-mode-all' => 'totes les pâges',
	'categorytree-collapse' => 'Recllôre',
	'categorytree-expand' => 'Dèvelopar',
	'categorytree-load' => 'Uvrir',
	'categorytree-loading' => 'uvèrtura...',
	'categorytree-nothing-found' => 'Pas trovâ, dèsolâ.',
	'categorytree-no-subcategories' => 'Gins de sot-catègorie.',
	'categorytree-no-pages' => 'Gins d’articllo ou de sot-catègorie.',
	'categorytree-not-found' => 'La catègorie <tt>$1</tt> at pas étâ trovâ.',
	'categorytree-error' => 'Problèmo de chargement de les balyês.',
	'categorytree-retry' => 'Atendéd un moment et pués tornâd èprovar.',
);

/** Friulian (Furlan)
 * @author Klenje
 * @author MF-Warburg
 */
$messages['fur'] = array(
	'categorytree' => 'Arbul des categoriis',
	'categorytree-portlet' => 'Categoriis',
	'categorytree-legend' => 'Mostre arbul des categoriis',
	'categorytree-header' => 'Inserìs il non de categorie di cui tu vuelis viodi i siei contignûts intune struture a arbul.
Cheste funzion e à bisugne di funzions avanzadis JavaScript, cognossudis come AJAX.
Se tu âs un sgarfadôr a vonde vieri, o tu âs disativât JavaScript, cheste pagjine no funzionarà.',
	'categorytree-category' => 'Categorie:',
	'categorytree-go' => 'Mostre arbul',
	'categorytree-mode-categories' => 'mostre dome lis categoriis',
	'categorytree-mode-pages' => 'dutis lis pagjinis, fûr che i files',
	'categorytree-mode-all' => 'dutis lis pagjinis',
	'categorytree-collapse' => 'strenç',
	'categorytree-expand' => 'slargje',
	'categorytree-member-counts' => 'e à dentri {{PLURAL:$1|1 sotcategorie|$1 sotcategoriis}}, {{PLURAL:$2|1 pagjine|$2 pagjinis}} e {{PLURAL:$3|1 file|$3 files}}',
	'categorytree-load' => 'cjame',
	'categorytree-loading' => 'daûr a cjamâ',
	'categorytree-nothing-found' => 'nissun risultât',
	'categorytree-no-subcategories' => 'nissune sot categorie.',
	'categorytree-no-parent-categories' => 'nissune categorie parsore',
	'categorytree-no-pages' => 'nissune pagjine ni sotcategorie',
	'categorytree-not-found' => 'Categorie <i>$1</i> no cjatade',
	'categorytree-error' => 'Probleme dilunc la cjamade dai dâts.',
	'categorytree-retry' => 'Spiete un moment e torne a provâ.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'categorytree' => 'Kategorybeam',
	'categorytree-header' => 'Folje in kategorynamme yn om de ynhâld yn in beamstruktuer te sjen. Tink dêrom dat dit spesjale JavaScript funksjes brûkt bekend as AJAX. At jo in tige âlde blêdzjer hawwe of jo hawwe JavaScript net oan stean, dan wurket dit net.',
	'categorytree-category' => 'Kategory beam',
	'categorytree-go' => 'Los',
	'categorytree-mode-categories' => 'allinne kategoryen',
	'categorytree-mode-pages' => 'alle siden útsein ôfbylden',
	'categorytree-mode-all' => 'alle siden',
	'categorytree-collapse' => 'ticht',
	'categorytree-expand' => 'iepen',
	'categorytree-load' => 'ynlade',
	'categorytree-loading' => 'ynlade...',
	'categorytree-nothing-found' => 'neat fûn',
	'categorytree-no-subcategories' => 'gjin ûnderlizzende kategoryen',
	'categorytree-no-pages' => 'gjin siden of ûnderlizzende siden',
	'categorytree-not-found' => 'Kategory <i>$1</i> net fûn',
);

/** Irish (Gaeilge)
 * @author Alison
 * @author Alma
 * @author Moilleadóir
 * @author Spacebirdy
 * @author Xosé
 */
$messages['ga'] = array(
	'categorytree' => 'Crann na gCatagóirí',
	'categorytree-portlet' => 'Catagóirí',
	'categorytree-legend' => 'Taispeáin crann na gcatagóirí',
	'categorytree-desc' => 'Giuirléid AJAX a thaispeánann an [[Special:CategoryTree|struchtúr catagóirí]] i vicí',
	'categorytree-header' => 'Cuir isteach ainm catagóra chun a hinneachar a thaispeáint i struchtúr crainn.
Tabhair faoi deara gur riachtanach ardfheidhmiúlacht JavaScript (AJAX) a bheith agat.
Má tá do bhrabhsálaí róshean, nó má dhíchumasaigh tú JavaScript, ní oibreoidh sé.',
	'categorytree-category' => 'Catagóir',
	'categorytree-go' => 'Taispeán an Crann',
	'categorytree-parents' => 'Máthairnóid',
	'categorytree-mode-categories' => 'catagóirí amháin',
	'categorytree-mode-pages' => 'leathanaigh seachas comhaid',
	'categorytree-mode-all' => 'gach leathanach',
	'categorytree-collapse' => 'dún',
	'categorytree-expand' => 'oscail',
	'categorytree-member-counts' => 'tá {{PLURAL:$1|fo-chatagóir amháin|$1 fo-chatagóirí}}, {{PLURAL:$2|leathanach amháin|$2 leathanaigh}}, agus {{PLURAL:$3|comhad amháin|$3 comhaid}} laistigh',
	'categorytree-load' => 'lódáil',
	'categorytree-loading' => 'ag lódáil…',
	'categorytree-nothing-found' => 'Ní bhfuarthas dada',
	'categorytree-no-subcategories' => 'gan fho-chatagóir',
	'categorytree-no-parent-categories' => 'níl aon máthairchatagóirí',
	'categorytree-no-pages' => 'gan leathanach ná fo-chatagóir',
	'categorytree-not-found' => 'Ní bhfuarthas Catagóir <i>$1</i>',
	'categorytree-error' => 'Earráid agus sonraí dá lódáil.',
	'categorytree-retry' => 'Fan nóiméad, le do thoil, roimh triail eile a bhaint as.',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'categorytree' => 'Árbore de categorías',
	'categorytree-portlet' => 'Categorías',
	'categorytree-legend' => 'Amosar a árbore de categorías',
	'categorytree-desc' => 'Trebello baseado no AJAX para amosar a [[Special:CategoryTree|estrutura das categorías]] dun wiki',
	'categorytree-header' => 'Introduza o nome dunha categoría para ver o contido da estrutura da árbore.
Déase conta de que se require a funcionalidade avanzada do JavaScript, coñecida como AJAX.
Se ten un navegador moi vello, ou deshabilitado para o JavaScript, non vai funcionar.',
	'categorytree-category' => 'Categoría:',
	'categorytree-go' => 'Amosar a árbore',
	'categorytree-parents' => 'Categoría raíz',
	'categorytree-mode-categories' => 'só categorías',
	'categorytree-mode-pages' => 'páxinas agás ficheiros',
	'categorytree-mode-all' => 'todas as páxinas',
	'categorytree-collapse' => 'contraer',
	'categorytree-expand' => 'expandir',
	'categorytree-member-counts' => 'contén {{PLURAL:$1|unha subcategoría|$1 subcategorías}}, {{PLURAL:$2|unha páxina|$2 páxinas}} e mais {{PLURAL:$3|un ficheiro|$3 ficheiros}}',
	'categorytree-load' => 'cargar',
	'categorytree-loading' => 'cargando…',
	'categorytree-nothing-found' => 'non se atopou nada',
	'categorytree-no-subcategories' => 'non hai subcategorías',
	'categorytree-no-parent-categories' => 'non hai categorías superiores a esta',
	'categorytree-no-pages' => 'non hai páxinas nin subcategorías',
	'categorytree-not-found' => 'A categoría "<i>$1</i>" non foi atopada',
	'categorytree-error' => 'Problema da carga de datos.',
	'categorytree-retry' => 'Por favor, agarde un momento e ténteo de novo.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author LeighvsOptimvsMaximvs
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'categorytree' => 'Δένδρον κατηγοριῶν',
	'categorytree-portlet' => 'Κατηγορίαι',
	'categorytree-category' => 'Κατηγορία:',
	'categorytree-go' => 'Ἐμφανίζειν δένδρον',
	'categorytree-parents' => 'Γονεῖς',
	'categorytree-mode-categories' => 'Κατηγορίαι μόνον',
	'categorytree-mode-all' => 'πᾶσαι αἱ δέλτοι',
	'categorytree-collapse' => 'συστέλλειν',
	'categorytree-expand' => 'διαστέλλειν',
	'categorytree-load' => 'φορτίζειν',
	'categorytree-loading' => 'φορτίζειν...',
	'categorytree-nothing-found' => 'οὐδὲν εὑρεθέν',
	'categorytree-no-subcategories' => 'οὐδεμία ὑποκατηγορία',
	'categorytree-no-parent-categories' => 'οὐδεμία γονεικὴ κατηγορία',
	'categorytree-not-found' => 'Κατηγορία <i>$1</i> μὴ εὑρεθεῖσα',
	'categorytree-error' => 'Πρόβλημα τοῦ φορτίζειν δεδομένα',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Hendergassler
 */
$messages['gsw'] = array(
	'categorytree' => 'Kategoriebaum',
	'categorytree-portlet' => 'Kategori',
	'categorytree-legend' => 'Kategoriebaum aazeige',
	'categorytree-desc' => 'Dynamischi Navigation fir d [[Special:CategoryTree|Kategorie-Struktur]]',
	'categorytree-header' => 'Gib e Kategoriname yy zum dr Inhalt vun ere as Baumstruktur aazluege.
Des brucht fortgschritteneri JavaScript-Funktione (Ajax). Wänn JavaScript abgschalden isch oder e eltere Browser brucht wird, cha s syy, ass es nit goht.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Baum zeige',
	'categorytree-parents' => 'Iberkategorie',
	'categorytree-mode-categories' => 'Nume d Kategorie',
	'categorytree-mode-pages' => 'Syte user Dateie',
	'categorytree-mode-all' => 'Alli Syte',
	'categorytree-collapse' => 'zueklappe',
	'categorytree-expand' => 'ufklappe',
	'categorytree-member-counts' => 'het {{PLURAL:$1|1 Unterkategori|$1 Unterkategorie}}, {{PLURAL:$2|1 Syte|$2 Syte}}, un {{PLURAL:$3|1 Datei|$3 Dateie}}',
	'categorytree-load' => 'lade',
	'categorytree-loading' => 's isch am Laade ...',
	'categorytree-nothing-found' => 'nyt gfunde',
	'categorytree-no-subcategories' => 'Kaini Unterkategorie',
	'categorytree-no-parent-categories' => 'Kaini Iberkategorie',
	'categorytree-no-pages' => 'Kai Syte oder Unterkategorie',
	'categorytree-not-found' => 'Kategori <i>$1</i> nit gfunde',
	'categorytree-error' => 'Problem bim Lade vo dr Date',
	'categorytree-retry' => 'Wart e Rung un versuech s derno non emol.',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 */
$messages['gu'] = array(
	'categorytree-go' => 'વૃક્ષ બતાવો',
	'categorytree-parents' => 'પિતૃ',
	'categorytree-mode-all' => 'બધા પાનાં',
	'categorytree-nothing-found' => 'કઈ ન મળ્યું',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'categorytree' => 'BilleyRonnaghyn',
	'categorytree-portlet' => 'Ronnaghyn',
	'categorytree-legend' => 'Billey ronnaghyn y haishbyney',
	'categorytree-category' => 'Ronney:',
	'categorytree-go' => 'Billey y haishbyney',
	'categorytree-mode-categories' => 'ronnaghyn ynrican',
	'categorytree-mode-all' => 'dagh ooilley ghuillag',
	'categorytree-collapse' => 'filley',
	'categorytree-expand' => 'mooadaghey',
	'categorytree-load' => 'dy lughtaghey',
	'categorytree-loading' => 'lughtaghey...',
	'categorytree-no-subcategories' => 'gyn fo-ronnaghyn',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'categorytree' => 'Fûn-lui-su',
	'categorytree-category' => 'Fûn-lui:',
	'categorytree-expand' => 'Chán-khôi',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'categorytree-category' => 'Mahele:',
	'categorytree-load' => 'ho‘ouka',
	'categorytree-loading' => 'ke ho‘ouka nei…',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'categorytree' => 'עץ קטגוריות',
	'categorytree-portlet' => 'קטגוריות',
	'categorytree-legend' => 'הצגת עץ קטגוריות',
	'categorytree-desc' => 'כלי מבוסס AJAX להצגת [[Special:CategoryTree|מבנה הקטגוריות]] של אתר ויקי',
	'categorytree-header' => 'הקלידו שם קטגוריה כדי לראות את תכניה במבנה עץ. שימו לב שהדבר דורש תכונת JavaScript מתקדמת, הידועה בשם AJAX. אם יש לכם דפדפן ישן מאוד, או ש־JavaScript מנוטרלת אצלכם בדפדפן, הוא לא יעבוד.',
	'categorytree-category' => 'קטגוריה',
	'categorytree-go' => 'הצגת העץ',
	'categorytree-parents' => 'הורים',
	'categorytree-mode-categories' => 'קטגוריות בלבד',
	'categorytree-mode-pages' => 'דפים שאינם קבצים',
	'categorytree-mode-all' => 'כל הדפים',
	'categorytree-collapse' => 'כיווץ',
	'categorytree-expand' => 'הרחבה',
	'categorytree-member-counts' => 'כוללת {{PLURAL:$1|קטגוריית משנה אחת|$1 קטגוריות משנה}}, {{PLURAL:$2|דף אחד|$2 דפים}}, ו{{PLURAL:$3|קובץ אחד|־$3 קבצים}}',
	'categorytree-load' => 'טעינה',
	'categorytree-loading' => 'בטעינה',
	'categorytree-nothing-found' => 'לא נמצאו תוצאות',
	'categorytree-no-subcategories' => 'אין קטגוריות משנה',
	'categorytree-no-parent-categories' => 'אין קטגוריות הורה',
	'categorytree-no-pages' => 'אין דפים או קטגוריות משנה',
	'categorytree-not-found' => "הקטגוריה '''$1''' לא נמצאה",
	'categorytree-error' => 'בעיה בטעינת המידע.',
	'categorytree-retry' => 'אנא המתינו מעט ונסו שנית.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'categorytree' => 'श्रेणीवृक्ष',
	'categorytree-legend' => 'श्रेणीवृक्ष दिखायें',
	'categorytree-desc' => 'विकिकी [[Special:CategoryTree|श्रेणीयाँ]] दिखानेके लिये AJAX से बना औज़ार',
	'categorytree-header' => 'एक श्रेणीके कन्टेन्ट्स वृक्ष के रूपमें देखने के लिये उसका नाम दें।
इस सुविधाके लिये AJAX नाम के एक जावास्क्रीप्ट की जरुरत होती हैं, इसपर ध्यान दें।
अगर आपका ब्राउज़र बहुत पुराना हैं, या जावास्क्रीप्ट बंद रखी हुई हैं तो यह काम नहीं करेगा।',
	'categorytree-category' => 'श्रेणी:',
	'categorytree-go' => 'वृक्ष दिखायें',
	'categorytree-parents' => 'पालक',
	'categorytree-mode-categories' => 'सिर्फ श्रेणीयाँ',
	'categorytree-mode-pages' => 'चित्र ना होने वाले पन्ने',
	'categorytree-mode-all' => 'सभी पन्ने',
	'categorytree-collapse' => 'छोटा करें',
	'categorytree-expand' => 'बडा करें',
	'categorytree-load' => 'लोड करें',
	'categorytree-loading' => 'लोड कर रहें हैं...',
	'categorytree-nothing-found' => 'कुछ भी मिला नहीं',
	'categorytree-no-subcategories' => 'उपश्रेणीयाँ नहीं हैं',
	'categorytree-no-pages' => 'लेख या उपश्रेणीयाँ नहीं हैं',
	'categorytree-not-found' => 'श्रेणी <i>$1</i> मिली नहीं',
	'categorytree-error' => 'डाटा लोड करने में समस्या।',
	'categorytree-retry' => 'कृपया थोडे समय के बाद फिरसे यत्न करें।',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 * @author Suradnik13
 */
$messages['hr'] = array(
	'categorytree' => 'Stablasti prikaz hijerarhije kategorija',
	'categorytree-portlet' => 'Kategorije',
	'categorytree-legend' => 'Prikaži stablo kategorija',
	'categorytree-desc' => 'Dinamička navigacija kroz [[Special:CategoryTree|strukturu kategorija]]',
	'categorytree-header' => 'Upišite ime kategorije da biste vidjeli njen položaj u stablastom prikazu hijerarhije. Napomena: na strani klijenta (na Vašem računalu) potreban je web preglednik koji podržava napredni JavaScript, tj. AJAX. Ukoliko imate stari web preglednik, ili ste onemogućili izvođenje JavaScripta u njemu, neće Vam biti dostupan ovaj prikaz.',
	'categorytree-category' => 'Kategorija:',
	'categorytree-go' => 'Pokaži stablo',
	'categorytree-parents' => 'Više kategorije',
	'categorytree-mode-categories' => 'pokaži samo kategorije',
	'categorytree-mode-pages' => 'stranice bez datoteka',
	'categorytree-mode-all' => 'sve stranice',
	'categorytree-collapse' => 'sklopi stablo',
	'categorytree-expand' => 'raširi stablo',
	'categorytree-member-counts' => 'sadrži {{PLURAL:$1|1 podkategoriju|$1 podkategorija}}, {{PLURAL:$2|1 stranicu|$2 stranica}}, i {{PLURAL:$3|1 datoteku|$3 datoteka}}',
	'categorytree-load' => 'učitaj',
	'categorytree-loading' => 'učitavam',
	'categorytree-nothing-found' => 'Nije pronađena nijedna stavka.',
	'categorytree-no-subcategories' => 'Nema podkategorija.',
	'categorytree-no-parent-categories' => 'nema viših kategorija',
	'categorytree-no-pages' => 'Nema članaka ili podkategorija.',
	'categorytree-not-found' => 'Kategorija <i>$1</i> nije pronađena',
	'categorytree-error' => 'Problem s učitavanjem podataka.',
	'categorytree-retry' => 'Pričekajte trenutak pa pokušajte opet.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'categorytree' => 'Kategorijowy štom',
	'categorytree-portlet' => 'Kategorije',
	'categorytree-legend' => 'Kategorijowy štom pokazać',
	'categorytree-desc' => 'Přisłušk (gadget) na zakładźe AJAX za [[Special:CategoryTree|zwobraznjenje struktury]] wikija',
	'categorytree-header' => 'Zapisaj mjeno kategorije, zo by jeje wobsah jako štomowu strukturu widźał. Wobkedźbuj, zo su za to wěste JavaScriptowe funkcije (AJAX) trjeba. Jeli maš jara stary wobhladowak abo jeli JavaScript je wupinjeny, to snano njebudźe fungować.',
	'categorytree-category' => 'Kategorija',
	'categorytree-go' => 'Štom pokazać',
	'categorytree-parents' => 'Nadkategorije',
	'categorytree-mode-categories' => 'jenož kategorije',
	'categorytree-mode-pages' => 'strony nimo wobrazow',
	'categorytree-mode-all' => 'wšě strony',
	'categorytree-collapse' => 'schować',
	'categorytree-expand' => 'pokazać',
	'categorytree-member-counts' => 'wobsahuje {{PLURAL:$1|1 podkategoriju|$1 podkategoriji|$1 podkategorije|$1 podkategorijow}}, {{PLURAL:$2|1 stronu|$2 stronje|$2 strony|$2 stronow}} a {{PLURAL:$3|1 dataju|$3 dataji|$3 dataje|$3 datajow}}',
	'categorytree-load' => 'začitać',
	'categorytree-loading' => 'čita so…',
	'categorytree-nothing-found' => 'ničo namakane',
	'categorytree-no-subcategories' => 'žane podkategorije',
	'categorytree-no-parent-categories' => 'žane nadrjadowane kategorije',
	'categorytree-no-pages' => 'žane strony abo podkategorije',
	'categorytree-not-found' => "Kategorija ''$1'' njenamakana",
	'categorytree-error' => 'Problem při čitanju datow.',
	'categorytree-retry' => 'Prošu čakaj wokomik a spytaj potom hišće raz.',
);

/** Haitian (Kreyòl ayisyen)
 * @author Masterches
 */
$messages['ht'] = array(
	'categorytree' => 'Òganizasyon kategori yo',
	'categorytree-legend' => 'Montre òganizasyon pou kategori a',
	'categorytree-desc' => 'Jwèt, gadjèt sòti nan AJAX pou montre [[Special:CategoryTree|òganizasyon kategori ]] yon wiki.',
	'categorytree-header' => 'Antre non yon kategori pou wè sa l genyen anndan l, òganizasyon l.
Tande byen ke sa mande fonksyon JavaScript ki gen wo nivo tankou AJAX.
Si ou ta genyen yon vye navigatè (navigatè, bwozè entènèt), oubyen JavaScript pa aktive, li pe ke mache byen.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Montre òganizasyon, estrikti',
	'categorytree-parents' => 'Papa ak manman',
	'categorytree-mode-categories' => 'Kategori yo sèlman',
	'categorytree-mode-pages' => 'paj san imaj, retire tout imaj nan paj an',
	'categorytree-mode-all' => 'tout paj yo',
	'categorytree-collapse' => 'fème tout seksyon yo',
	'categorytree-expand' => 'Elaji seksyon an',
	'categorytree-load' => 'Chaje, ouvri',
	'categorytree-loading' => 'ap chaje...',
	'categorytree-nothing-found' => 'nou pa twouve anyen ki ap koresponn',
	'categorytree-no-subcategories' => 'kategori sa pa gen pitit, pa gen kategori pi ba.',
	'categorytree-no-pages' => 'pa gen paj oubyen atik oubyen kategori pi ba',
	'categorytree-not-found' => 'Nou pa twouve kategori <i>$1</i>',
	'categorytree-error' => 'Pwoblèm lè nou tap chaje, ouvri done yo.',
	'categorytree-retry' => 'Souple, rete yon enstan, yon moman epi eseye ankò.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 */
$messages['hu'] = array(
	'categorytree' => 'Kategóriafa',
	'categorytree-portlet' => 'Kategóriák',
	'categorytree-legend' => 'Mutatsd faként',
	'categorytree-desc' => 'AJAX alapú eszköz a wiki [[Special:CategoryTree|kategória-struktúrájának]] megjelenítéséhez',
	'categorytree-header' => 'Add meg annak a kategóriának a nevét, amelynek meg szeretnéd tekinteni
a fastruktúráját. Ehhez egy, AJAX nevű JavaScript-technológia szükséges.
Ha túlságosan régi böngésződ van, vagy a JavaScript le van tiltva, akkor nem fog működni.',
	'categorytree-category' => 'Kategória',
	'categorytree-go' => 'Mehet',
	'categorytree-parents' => 'Szülő kategóriák',
	'categorytree-mode-categories' => 'csak kategóriák',
	'categorytree-mode-pages' => 'lapok a fájlok nélkül',
	'categorytree-mode-all' => 'Az összes oldal',
	'categorytree-collapse' => 'összecsuk',
	'categorytree-expand' => 'kinyit',
	'categorytree-member-counts' => '{{PLURAL:$1|egy|$1}} alkategóriát, {{PLURAL:$2|egy|$2}} lapot, és {{PLURAL:$3|egy|$3}} fájlt tartalmaz',
	'categorytree-load' => 'Töltés',
	'categorytree-loading' => 'töltés',
	'categorytree-nothing-found' => 'nincs találat',
	'categorytree-no-subcategories' => 'nincs alkategória.',
	'categorytree-no-parent-categories' => 'nincsenek szülőkategóriái',
	'categorytree-no-pages' => 'nincs cikk vagy alkategória.',
	'categorytree-not-found' => 'Kategória <i>$1</i> nem található',
	'categorytree-error' => 'Probélma a betöltődő adattal',
	'categorytree-retry' => 'Kérlek várj egy pillanatot és próbáld újra.',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'categorytree' => 'Կատեգորիաների ծառ',
	'categorytree-portlet' => 'Կատեգորիաներ',
	'categorytree-legend' => 'Ցույց տալ կատեգորիաների ծառը',
	'categorytree-desc' => '[[Special:CategoryTree|Կատեգորիայի կառուցվծքի]] դինամիկ արտապատկերում',
	'categorytree-header' => 'Մուտքագրեք կատեգորիայի անունը` ծառի համակարգը տեսնելու համար։
Ի նկատի ունեցեք, որ սա հնարավոր է միայն ձեր բրաուզերի կողմից AJAX-ի ֆունկցիանալության դեպքում։
Եթե դուք աշխատում եք շատ հին բրաուզերով, կամ ձեր JavaScript-ը անջատված է` այն չի գործի։',
	'categorytree-category' => 'Կատեգորիա.',
	'categorytree-go' => 'Ցույց տալ ծառը',
	'categorytree-parents' => 'Ծնող-կատեգորիաներ',
	'categorytree-mode-categories' => 'միայն կատեգորիաները',
	'categorytree-mode-pages' => 'ֆայլերից բացի',
	'categorytree-mode-all' => 'բոլոր էջերը',
	'categorytree-collapse' => 'փակել',
	'categorytree-expand' => 'բացել',
	'categorytree-member-counts' => 'պարունակում է {{PLURAL:$1|1 ենթակատեգորիա|$1 ենթակատեգորիա}}, {{PLURAL:$2|1 էջ|$2 էջ}} և {{PLURAL:$3|1 ֆայլ|$3 ֆայլ}}',
	'categorytree-load' => 'բեռնել',
	'categorytree-loading' => 'բեռնվում է',
	'categorytree-nothing-found' => 'ոչինչ չի գտնվել',
	'categorytree-no-subcategories' => 'ենթակատեգորիաներ չկան',
	'categorytree-no-parent-categories' => 'ծնող-կատեգորիաներ չկան',
	'categorytree-no-pages' => 'ենթակատեգորիաներ և էջեր չկան',
	'categorytree-not-found' => '«<i>$1</i>» կատեգորիան չի գտնվել',
	'categorytree-error' => 'Տվյալների բեռնումը չհաջողվեց',
	'categorytree-retry' => 'Խնդրում ենք սպասել մեկ ակնթարթ և փորձել կրկին։',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'categorytree' => 'Arbore de categorias',
	'categorytree-portlet' => 'Categorias',
	'categorytree-legend' => 'Monstrar arbore de categorias',
	'categorytree-desc' => 'Navigar dynamicamente per le [[Special:CategoryTree|structura de categorias]]',
	'categorytree-header' => 'Entra le nomine de un categoria pro vider su contento como un structura arboree.
Nota que isto require un functionalitate de JavaScript avantiate cognoscite como AJAX.
Si tu ha un navigator multo vetule, o ha disactivate JavaScript, isto non functionara.',
	'categorytree-category' => 'Categoria:',
	'categorytree-go' => 'Monstrar arbore',
	'categorytree-parents' => 'Categorias superior',
	'categorytree-mode-categories' => 'categorias solmente',
	'categorytree-mode-pages' => 'paginas excepte files',
	'categorytree-mode-all' => 'tote le paginas',
	'categorytree-collapse' => 'collaber',
	'categorytree-expand' => 'expander',
	'categorytree-member-counts' => 'contine {{PLURAL:$1|1 subcategoria|$1 subcategorias}}, {{PLURAL:$2|1 pagina|$2 paginas}}, e {{PLURAL:$3|1 file|$3 files}}',
	'categorytree-load' => 'cargar',
	'categorytree-loading' => 'cargamento in curso…',
	'categorytree-nothing-found' => 'nihil trovate',
	'categorytree-no-subcategories' => 'nulle subcategorias',
	'categorytree-no-parent-categories' => 'nulle categorias superior',
	'categorytree-no-pages' => 'nulle paginas o subcategorias',
	'categorytree-not-found' => 'Categoria <i>$1</i> non trovate',
	'categorytree-error' => 'Problema al cargar le datos.',
	'categorytree-retry' => 'Per favor attende un momento e reprova.',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'categorytree' => 'Pohon kategori',
	'categorytree-portlet' => 'Kategori',
	'categorytree-legend' => 'Tampilkan pohon kategori',
	'categorytree-desc' => 'Gadget berbasis AJAX untuk menampilkan [[Special:CategoryTree|struktur kategori]] suatu wiki',
	'categorytree-header' => 'Masukkan suatu nama kategori untuk melihat isinya dalam bentuk pohon.
Harap diperhatikan bahwa fitur ini memerlukan dukungan JavaScript tingkat lanjut yang dikenal sebagai AJAX.
Jika Anda menggunakan penjelajah web lama, atau mematikan fungsi JavaScript Anda, fitur ini tidak dapat dijalankan.',
	'categorytree-category' => 'Kategori',
	'categorytree-go' => 'Tampilkan',
	'categorytree-parents' => 'Atasan',
	'categorytree-mode-categories' => 'hanya kategori',
	'categorytree-mode-pages' => 'halaman kecuali berkas',
	'categorytree-mode-all' => 'semua halaman',
	'categorytree-collapse' => 'tutup',
	'categorytree-expand' => 'buka',
	'categorytree-member-counts' => 'memiliki {{PLURAL:$1|1 subkategori|$1 subkategori}}, {{PLURAL:$2|1 halaman|$2 halaman}}, dan {{PLURAL:$3|1 berkas|$3 berkas}}',
	'categorytree-load' => 'muat',
	'categorytree-loading' => 'memuat…',
	'categorytree-nothing-found' => 'tidak ditemukan',
	'categorytree-no-subcategories' => 'tidak ada subkategori',
	'categorytree-no-parent-categories' => 'tidak ada kategori lebih tinggi',
	'categorytree-no-pages' => 'tidak ada halaman atau subkategori',
	'categorytree-not-found' => 'Kategori <i>$1</i> tidak ditemukan',
	'categorytree-error' => 'Problem memuat data.',
	'categorytree-retry' => 'Tunggulah sesaat dan coba lagi.',
);

/** Interlingue (Interlingue)
 * @author Malafaya
 */
$messages['ie'] = array(
	'categorytree-category' => 'Categorie:',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'categorytree-portlet' => 'Kategorii',
	'categorytree-category' => 'Kategorio:',
	'categorytree-go' => 'Montrar Arboro',
	'categorytree-mode-categories' => 'nur kategorii',
	'categorytree-mode-pages' => 'pagini ecepte arkivi',
	'categorytree-mode-all' => 'omna pagini',
	'categorytree-member-counts' => 'kontenas {{PLURAL:$1|1 subkategorio|$1 subkategorii}}, {{PLURAL:$2|1 pagino|$2 pagini}}, ed {{PLURAL:$3|1 arkivo|$3 arkivi}}',
	'categorytree-nothing-found' => 'nulo trovita',
	'categorytree-no-subcategories' => 'nula subkategorii',
	'categorytree-no-pages' => 'nula pagini o subkategorii',
	'categorytree-not-found' => 'Kategorio <i>$1</i> ne trovita',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Spacebirdy
 */
$messages['is'] = array(
	'categorytree' => 'Flokkatré',
	'categorytree-portlet' => 'Flokkar',
	'categorytree-legend' => 'Sýna flokkatré',
	'categorytree-header' => 'Sláðu inn heiti flokks til að sjá innihald hans sem tré.
Hafðu í huga að þetta krefst þróaðra virkni JavaScript sem nefnist AJAX.
Ef þú notast við gamlan vafra eða hefur slökkt á JavaScript mun þetta ekki virka.',
	'categorytree-category' => 'Flokkur:',
	'categorytree-go' => 'Sýna tré',
	'categorytree-parents' => 'Undirrætur',
	'categorytree-mode-categories' => 'bara flokka',
	'categorytree-mode-pages' => 'síður að myndum undanskildum',
	'categorytree-mode-all' => 'allar síður',
	'categorytree-collapse' => 'fela',
	'categorytree-expand' => 'sýna',
	'categorytree-load' => 'hlaða',
	'categorytree-loading' => 'hleð',
	'categorytree-nothing-found' => 'ekkert fannst',
	'categorytree-no-subcategories' => 'engir undirflokkar',
	'categorytree-no-pages' => 'engar síður eða undirflokkar',
	'categorytree-not-found' => 'Flokkurinn <i>$1</i> fannst ekki',
	'categorytree-error' => 'Villa við hleðslu gagna.',
	'categorytree-retry' => 'Gjörðu svo vel og reyndu síðar.',
);

/** Italian (Italiano)
 * @author .anaconda
 * @author BrokenArrow
 * @author Cruccone
 * @author Darth Kule
 * @author Gianfranco
 * @author Nemo bis
 */
$messages['it'] = array(
	'categorytree' => 'Albero delle categorie',
	'categorytree-portlet' => 'Categorie',
	'categorytree-legend' => "Mostra l'albero delle categorie",
	'categorytree-desc' => 'Accessorio AJAX per visualizzare la [[Special:CategoryTree|struttura delle categorie]] del sito',
	'categorytree-header' => 'Inserire il nome della categoria di cui si desidera vedere il contenuto sotto forma di struttura ad albero. Si noti che la pagina richiede le funzionalità avanzate di JavaScript chiamate AJAX; qualora si stia usando un browser molto vecchio o le funzioni JavaScript siano disabilitate, questa pagina non funzionerà.',
	'categorytree-category' => 'Categoria:',
	'categorytree-go' => 'Carica',
	'categorytree-parents' => 'Categorie superiori',
	'categorytree-mode-categories' => 'mostra solo le categorie',
	'categorytree-mode-pages' => 'tutte le pagine, escluse le immagini',
	'categorytree-mode-all' => 'tutte le pagine',
	'categorytree-collapse' => 'comprimi',
	'categorytree-expand' => 'espandi',
	'categorytree-member-counts' => 'contiene {{PLURAL:$1|1 sottocategoria|$1 sottocategorie}}, {{PLURAL:$2|1 pagina|$2 pagine}} e {{PLURAL:$3|1 file|$3 file}}',
	'categorytree-load' => 'carica',
	'categorytree-loading' => 'caricamento in corso',
	'categorytree-nothing-found' => 'nessun risultato',
	'categorytree-no-subcategories' => 'nessuna sottocategoria.',
	'categorytree-no-parent-categories' => 'nessuna categoria superiore',
	'categorytree-no-pages' => 'nessuna voce né sottocategoria.',
	'categorytree-not-found' => "Categoria  ''$1'' non trovata",
	'categorytree-error' => 'Problema nel caricamento dei dati.',
	'categorytree-retry' => 'Attendere un momento e riprovare.',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Broad-Sky
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Kahusi
 */
$messages['ja'] = array(
	'categorytree' => 'カテゴリツリー',
	'categorytree-portlet' => 'カテゴリ',
	'categorytree-legend' => 'カテゴリツリーを表示',
	'categorytree-desc' => 'ウィキの[[Special:CategoryTree|カテゴリの構造]]をツリー形式で表示する',
	'categorytree-header' => 'カテゴリの中身をツリー形式で表示するために、そのカテゴリ名を入力してください。この機能は Ajax という高度な JavaScript 機能を使用していることに注意してください。もしあなたが使っているブラウザが非常に古かったり、JavaScript を有効にしていないのであれば、動作しません。',
	'categorytree-category' => 'カテゴリ名:',
	'categorytree-go' => 'ツリーを見る',
	'categorytree-parents' => '上位カテゴリ',
	'categorytree-mode-categories' => 'カテゴリのみ',
	'categorytree-mode-pages' => 'ファイル以外の全ページ',
	'categorytree-mode-all' => '全ページ',
	'categorytree-collapse' => '下位カテゴリを非表示',
	'categorytree-expand' => '下位カテゴリを表示',
	'categorytree-member-counts' => '$1個のサブカテゴリ、$2件のページ、$3個のファイルを含んでいます',
	'categorytree-load' => '下位カテゴリを表示',
	'categorytree-loading' => '読み込み中…',
	'categorytree-nothing-found' => '存在しません',
	'categorytree-no-subcategories' => 'サブカテゴリはありません',
	'categorytree-no-parent-categories' => '親カテゴリなし',
	'categorytree-no-pages' => 'ページやサブカテゴリはありません',
	'categorytree-not-found' => 'カテゴリ " <i>$1</i> " はありません',
	'categorytree-error' => 'データの読み込み中に問題が発生しました',
	'categorytree-retry' => '暫く経った後に再度試してください。',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'categorytree' => 'Klyngetræ',
	'categorytree-desc' => 'AJAX based gadget til display a [[Special:CategoryTree|klynge struktur]] ener wiki',
	'categorytree-header' => "Indtast navnet på en kategori for at se indholdet som et træ. Bemærk at dette kræver avanceret JavaScript-funktionalitet kendt som AJAX, det verker ig'n hves du harst en meget gammel browser zller hves du harst slået JavaScript frå.",
	'categorytree-category' => 'Klynge:',
	'categorytree-go' => 'Henter',
	'categorytree-parents' => 'Åverklynger',
	'categorytree-mode-categories' => 'ves kun klynger',
	'categorytree-mode-pages' => 'sider undtaget billeter',
	'categorytree-mode-all' => 'ål sider',
	'categorytree-collapse' => 'fold sammen',
	'categorytree-expand' => 'fold ud',
	'categorytree-load' => 'hent',
	'categorytree-loading' => 'endlæser',
	'categorytree-nothing-found' => "Ig'n funder, desvære.",
	'categorytree-no-subcategories' => "Ig'n underklynger.",
	'categorytree-no-pages' => "Ig'n ertikler æller underklynger.",
	'categorytree-not-found' => "Æ klynge ''$1'' blev ekke fundet",
	'categorytree-error' => 'Der åpstød et pråblæm under endlæsnenge åf data.',
	'categorytree-retry' => 'Vent et øjeblek og prøv egen.',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'categorytree' => 'Uwit kategori',
	'categorytree-portlet' => 'Kategori-kategori',
	'categorytree-legend' => 'Tuduhna uwit kategori',
	'categorytree-desc' => 'Gadget adhedhasar AJAX kanggo nuduhaké [[Special:CategoryTree|struktur kategori]] sawijining wiki',
	'categorytree-header' => 'Lebokna sawijining jeneng kategori kanggo deleng isiné minangka sawijining wujud uwit.
Mangga diwigatèkaké yèn fitur iki merlokaké fungsionalitas JavaScript canggih sing diarani AJAX.
Menawa panjenengan panjlajah wèbé kalebu vèrsi lawa, utawa fitur JavaScript dipatèni, fungsi iki ora bisa dilakokaké.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Tuduhna uwit',
	'categorytree-parents' => 'Kategori sing luwih dhuwur',
	'categorytree-mode-categories' => 'kategori waé',
	'categorytree-mode-pages' => 'kaca kajaba berkas',
	'categorytree-mode-all' => 'kabèh kaca',
	'categorytree-collapse' => 'ciyutna',
	'categorytree-expand' => 'ambakna',
	'categorytree-member-counts' => 'ngandhut {{PLURAL:$1|1 subkategori|$1 subkategori}}, {{PLURAL:$2|1 kaca|$2 kaca}}, lan {{PLURAL:$3|1 berkas|$3 berkas}}',
	'categorytree-load' => 'unggah',
	'categorytree-loading' => 'ngunggahaké…',
	'categorytree-nothing-found' => 'ora ditemokaké',
	'categorytree-no-subcategories' => 'ora ana subkategori',
	'categorytree-no-parent-categories' => 'ora ana kategori indhuk',
	'categorytree-no-pages' => 'ora ana kaca utawa subkategori',
	'categorytree-not-found' => 'Kategori <i>$1</i> ora ditemokaké',
	'categorytree-error' => 'Ana masalah ngunggahaké data.',
	'categorytree-retry' => 'Tulung ditunggu sadélok lan dicoba manèh.',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'categorytree' => 'კატეგორიების სქემა',
	'categorytree-portlet' => 'კატეგორიები',
	'categorytree-legend' => 'კატეგორიების სქემის ჩვენება',
	'categorytree-category' => 'კატეგორია:',
	'categorytree-go' => 'სქემის ჩვენება',
	'categorytree-mode-categories' => 'მხოლოდ კატეგორიები',
	'categorytree-mode-pages' => 'გვერდები ფაილების გარდა',
	'categorytree-mode-all' => 'ყველა გვერდი',
	'categorytree-not-found' => 'კატეგორია <i>$1</i> არ არსებობს',
);

/** Kara-Kalpak (Qaraqalpaqsha)
 * @author AlefZet
 */
$messages['kaa'] = array(
	'categorytree' => 'Kategoriyalar teregi',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'categorytree' => 'سانات بۇتاقتارى',
	'categorytree-header' => 'سانات مازمۇنىڭ بۇتاقتار تۇردە كورۋ ٴۇشىن اتاۋىن ەنگىزىڭىز.
اڭعارپتا: بۇل ىسكە JavaScript قۇرالىنىڭ AJAX دەگەن كەڭەيتىلگەن قابىلەتى قاجەت بولادى.
ەگەر شولعىشىڭىز وتە ەسكى, نەمەسە JavaScript وشىرىلگەن بولسا, بۇل ىسكە اسىرىلمايدى.',
	'categorytree-category' => 'سانات',
	'categorytree-go' => 'بۇتاقتارىن كورسەت',
	'categorytree-parents' => 'جوعارعىلار',
	'categorytree-mode-categories' => 'تەك ساناتتار',
	'categorytree-mode-pages' => 'بەتتەر (سۋرەتتەردى ساناماي)',
	'categorytree-mode-all' => 'بارلىق بەت',
	'categorytree-collapse' => 'تارىلتۋ',
	'categorytree-expand' => 'كەڭەيتۋ',
	'categorytree-load' => 'جۇكتەۋ',
	'categorytree-loading' => 'جۇكتەۋدە',
	'categorytree-nothing-found' => 'ەشتەڭە تابىلمادى',
	'categorytree-no-subcategories' => 'ساناتشالارى جوق',
	'categorytree-no-pages' => 'بەتتەرى نە ساناتشالارى جوق',
	'categorytree-not-found' => '<i>$1</i> دەگەن سانات تابىلمادى',
	'categorytree-error' => 'دەرەكتەردى جۇكتەۋ كەزىندە شاتاق شىقتى.',
	'categorytree-retry' => 'ٴبىر ٴسات كۇتە تۇرىپ قايتالاڭىز.',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'categorytree' => 'Санат бұтақтары',
	'categorytree-header' => 'Санат мазмұның бұтақтар түрде көру үшін атауын енгізіңіз.
Аңғарпта: Бұл іске JavaScript құралының AJAX деген кеңейтілген қабілеті қажет болады.
Егер шолғышыңыз өте ескі, немесе JavaScript өшірілген болса, бұл іске асырылмайды.',
	'categorytree-category' => 'Санат',
	'categorytree-go' => 'Бұтақтарын көрсет',
	'categorytree-parents' => 'Жоғарғылар',
	'categorytree-mode-categories' => 'тек санаттар',
	'categorytree-mode-pages' => 'беттер (суреттерді санамай)',
	'categorytree-mode-all' => 'барлық бет',
	'categorytree-collapse' => 'тарылту',
	'categorytree-expand' => 'кеңейту',
	'categorytree-load' => 'жүктеу',
	'categorytree-loading' => 'жүктеуде',
	'categorytree-nothing-found' => 'ештеңе табылмады',
	'categorytree-no-subcategories' => 'санатшалары жоқ',
	'categorytree-no-pages' => 'беттері не санатшалары жоқ',
	'categorytree-not-found' => '<i>$1</i> деген санат табылмады',
	'categorytree-error' => 'Деректерді жүктеу кезінде шатақ шықты.',
	'categorytree-retry' => 'Бір сәт күте тұрып қайталаңыз.',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'categorytree' => 'Sanat butaqtarı',
	'categorytree-header' => 'Sanat mazmunıñ butaqtar türde körw üşin atawın engiziñiz.
Añğarpta: Bul iske JavaScript quralınıñ AJAX degen keñeýtilgen qabileti qajet boladı.
Eger şolğışıñız öte eski, nemese JavaScript öşirilgen bolsa, bul iske asırılmaýdı.',
	'categorytree-category' => 'Sanat',
	'categorytree-go' => 'Butaqtarın körset',
	'categorytree-parents' => 'Joğarğılar',
	'categorytree-mode-categories' => 'tek sanattar',
	'categorytree-mode-pages' => 'better (swretterdi sanamaý)',
	'categorytree-mode-all' => 'barlıq bet',
	'categorytree-collapse' => 'tarıltw',
	'categorytree-expand' => 'keñeýtw',
	'categorytree-load' => 'jüktew',
	'categorytree-loading' => 'jüktewde',
	'categorytree-nothing-found' => 'eşteñe tabılmadı',
	'categorytree-no-subcategories' => 'sanatşaları joq',
	'categorytree-no-pages' => 'betteri ne sanatşaları joq',
	'categorytree-not-found' => '<i>$1</i> degen sanat tabılmadı',
	'categorytree-error' => 'Derekterdi jüktew kezinde şataq şıqtı.',
	'categorytree-retry' => 'Bir sät küte turıp qaýtalañız.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'categorytree' => 'មែកធាងនៃចំណាត់ថ្នាក់ក្រុម',
	'categorytree-portlet' => 'ចំណាត់ថ្នាក់ក្រុម',
	'categorytree-legend' => 'បង្ហាញមែកធាងចំណាត់ថ្នាក់ក្រុម',
	'categorytree-category' => 'ចំណាត់ថ្នាក់ក្រុម:',
	'categorytree-go' => 'បង្ហាញមែកធាង',
	'categorytree-parents' => 'ចំណាត់ថ្នាក់ក្រុមកម្រិតខ្ពស់',
	'categorytree-mode-categories' => 'សម្រាប់តែចំណាត់ថ្នាក់ក្រុមប៉ុណ្ណោះ',
	'categorytree-mode-pages' => 'ទំព័រលើកលែងតែរូបភាព',
	'categorytree-mode-all' => 'គ្រប់ទំព័រ',
	'categorytree-collapse' => 'បង្រួម',
	'categorytree-expand' => 'ពន្លាត',
	'categorytree-member-counts' => 'មាន{{PLURAL:$1|១ចំណាត់ថ្នាក់ក្រុមរង|$1ចំណាត់ថ្នាក់ក្រុមរង}} {{PLURAL:$2|១ទំព័រ|$2ទំព័រ}} និង{{PLURAL:$3|១ឯកសារ|$3ឯកសារ}}',
	'categorytree-load' => 'ផ្ទុក',
	'categorytree-loading' => 'កំពុងផ្ទុក',
	'categorytree-nothing-found' => 'រកមិនឃើញអ្វីទេ',
	'categorytree-no-subcategories' => 'មិនមានចំណាត់ថ្នាក់ក្រុមរងទេ',
	'categorytree-no-parent-categories' => 'មិនមានចំណាត់ថ្នាក់ក្រុមមេទេ',
	'categorytree-no-pages' => 'មិនមានទំព័រឬចំណាត់ថ្នាក់ក្រុមរងទេ',
	'categorytree-not-found' => 'រកមិនឃើញចំណាត់ថ្នាក់ក្រុម <i>$1</i> ទេ',
	'categorytree-error' => 'មានបញ្ហាក្នុងផ្ទុកទិន្នន័យ។',
	'categorytree-retry' => 'សូម​រង់ចាំ​មួយភ្លែត​រួច​ព្យាយាម​ម្តងទៀត​។',
);

/** Korean (한국어)
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'categorytree' => '분류 트리',
	'categorytree-portlet' => '분류',
	'categorytree-legend' => '분류 트리 보기',
	'categorytree-desc' => '위키의 [[Special:CategoryTree|분류 구조]]를 볼 수 있는 AJAX 도구',
	'categorytree-header' => '트리 구조로 볼 분류 이름을 입력해주세요.
이 기능을 사용하려면 웹 브라우저에서 AJAX를 지원해야 합니다.
오래 된 브라우저를 사용하거나, 브라우저에서 자바스크립트를 사용하지 않도록 설정했다면 트리 기능이 동작하지 않습니다.',
	'categorytree-category' => '분류:',
	'categorytree-go' => '트리 보기',
	'categorytree-parents' => '상위 분류',
	'categorytree-mode-categories' => '분류 문서만 표시',
	'categorytree-mode-pages' => '파일을 제외한 모든 문서를 표시',
	'categorytree-mode-all' => '모든 문서를 표시',
	'categorytree-collapse' => '접기',
	'categorytree-expand' => '펼치기',
	'categorytree-member-counts' => '분류는 {{PLURAL:$1|1개의 하위 분류|$1개의 하위 분류}}와, {{PLURAL:$2|1개의 문서|$2개의 문서}}, 그리고 {{PLURAL:$3|1개의 파일|$3개의 파일}}을 포함하고 있습니다.',
	'categorytree-load' => '불러오기',
	'categorytree-loading' => '불러오는 중',
	'categorytree-nothing-found' => '결과 없음',
	'categorytree-no-subcategories' => '하위 분류 없음',
	'categorytree-no-parent-categories' => '상위 분류가 없습니다.',
	'categorytree-no-pages' => '문서/하위 분류 없음',
	'categorytree-not-found' => '‘$1’ 분류가 존재하지 않음',
	'categorytree-error' => '값을 불러오는 중 오류 발생',
	'categorytree-retry' => '잠시 후에 다시 시도해주세요.',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'categorytree-category' => 'Kategorya:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'categorytree' => 'Saachjruppe als Boum',
	'categorytree-portlet' => 'Saachjruppe',
	'categorytree-legend' => 'Zeich de Saachjruppe als ene Boum',
	'categorytree-desc' => 'Jangk dorsch der [[Special:CategoryTree|Saachjruppe-Boum]].',
	'categorytree-header' => "'''Opjepaßß:'''&nbsp;<small>Dat hee brurr_en JavaSkripp_Aadëijl, dä AJAX häijß. Wänn_De enne besöndoß aale Brauser häß, oddo wänn_De JavaSkripp affjeschalldt häß, dann dëijd_et nit.</small> Jivv_enne Saachjroppe_Name enn, dann krėßß_De fun dä Saachjropp dä iere Ennhalld_alls_enne Boum aanjezëijsch.",
	'categorytree-category' => 'Saachjrupp:',
	'categorytree-go' => 'dä Boum zeije',
	'categorytree-parents' => 'Övverjeoodnete Jruppe',
	'categorytree-mode-categories' => 'nor Saachjruppe',
	'categorytree-mode-pages' => 'nomaal Sigge un Saachjruppe, kein Medie',
	'categorytree-mode-all' => 'alles: nomaal Sigge, Saachjruppe, un Medije',
	'categorytree-collapse' => 'zosammefallde',
	'categorytree-expand' => 'opfallde',
	'categorytree-member-counts' => 'Do dren {{PLURAL:$1|{{PLURAL:$4|sin|es|es}} ein Ungerjrupp|sin $1 Ungerjruppe|es kein Ungerjrupp}}, {{PLURAL:$2|ein Sigg|$2 Sigge|kein Sigg}}, un {{PLURAL:$3|ein Datei|$3 Dateie|kein Dateie}}, zosamme {{PLURAL:$4|ein Saach|$4 Saache|och nix}}',
	'categorytree-load' => 'lade',
	'categorytree-loading' => 'am lade…',
	'categorytree-nothing-found' => 'nix jefonge',
	'categorytree-no-subcategories' => 'kein Ungerjruppe',
	'categorytree-no-parent-categories' => 'kein övverjeoodnete Saachjruppe',
	'categorytree-no-pages' => 'kein Sigge un kein Ungerjruppe',
	'categorytree-not-found' => 'Han die Saachjrupp „<strong>$1</strong>“ nit jefonge.',
	'categorytree-error' => 'Problem beim Date Lade',
	'categorytree-retry' => 'Bess_esu joot un donn et noh enem Moment norr_ens probeere',
);

/** Kurdish (Latin) (Kurdî / كوردی (Latin)) */
$messages['ku-latn'] = array(
	'categorytree-category' => 'Kategorî',
	'categorytree-load' => 'bar bike',
	'categorytree-loading' => 'tê barkirin',
	'categorytree-no-subcategories' => 'binekategorî tune',
);

/** Cornish (Kernewek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'categorytree-portlet' => 'Klasyansow',
	'categorytree-category' => 'Klasyans:',
	'categorytree-mode-all' => 'oll folennow',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'categorytree' => 'Categoriarum arbor',
	'categorytree-portlet' => 'Categoriae',
	'categorytree-legend' => 'Categoriarum arborem monstrare',
	'categorytree-header' => 'Titulum categoriae inscribe ad categoriam hanc quasi arborem videndum. JavaScript et AJAX necesse sunt. Si navigatrum veterrimum habes vel si JavaScript potestatem non fecisti, hac pagina non uti poteris.',
	'categorytree-category' => 'Categoria',
	'categorytree-go' => 'Arborem monstrare',
	'categorytree-parents' => 'Parentes',
	'categorytree-mode-categories' => 'modo categoriae',
	'categorytree-mode-pages' => 'paginae nisi fasciculi',
	'categorytree-mode-all' => 'omnes paginae',
	'categorytree-collapse' => 'collabi',
	'categorytree-expand' => 'dilatare',
	'categorytree-member-counts' => 'continet {{PLURAL:$1|1 subcategoriam|$1 subcategorias}}, {{PLURAL:$2|1 paginam|$2 paginas}} et {{PLURAL:$3|1 fasciculum|$3 fasciculos}}',
	'categorytree-load' => 'depromere',
	'categorytree-loading' => 'depromens…',
	'categorytree-nothing-found' => 'nullum inventum',
	'categorytree-no-subcategories' => 'nullae subcategoriae',
	'categorytree-no-parent-categories' => 'nullae supercategoriae',
	'categorytree-no-pages' => 'nec paginae nec subcategoriae',
	'categorytree-not-found' => 'Categoria <i>$1</i> non inventa',
);

/** Ladino (Ladino)
 * @author Runningfridgesrule
 */
$messages['lad'] = array(
	'categorytree-category' => 'Kategoría:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Kaffi
 * @author Robby
 */
$messages['lb'] = array(
	'categorytree' => 'Struktur vun de Kategorien',
	'categorytree-portlet' => 'Kategorien',
	'categorytree-legend' => 'Weis Kategoriestruktur',
	'categorytree-desc' => "Gadget deen op Ajax opgebaut ass fir d'[[Special:CategoryTree|Kategorie-Struktur]] vun enger Wiki duerzestellen",
	'categorytree-header' => 'Gitt den Numm vun enger Kategorie an, fir hiren Inhalt als Bam-Struktur ze gesinn.
Bedenkt, datt dës Fonctioun Java Script Funktioune benotzt, déi als AJAX bekannt sinn. 
Wann Dir ee ganz ale Browser hutt, oder wann Dir JavaScript ausgeschalt hutt, da fonktionnéiert dëst bei Iech net.',
	'categorytree-category' => 'Kategorie:',
	'categorytree-go' => 'Struktur weisen',
	'categorytree-parents' => 'Uewerkategorien',
	'categorytree-mode-categories' => 'nëmme Kategorien',
	'categorytree-mode-pages' => 'Säiten ausser Fichieren',
	'categorytree-mode-all' => 'all Säiten',
	'categorytree-collapse' => 'Verstoppen',
	'categorytree-expand' => 'Opklappen',
	'categorytree-member-counts' => 'besteet aus {{PLURAL:$1|1 Ënnerkategorie|$1 Ënnerkategorien}}, {{PLURAL:$2|1 Säit|$1 Säiten}}, an {{PLURAL:$3|1 Fichier|$3 Fichieren}}',
	'categorytree-load' => 'lueden',
	'categorytree-loading' => 'lueden …',
	'categorytree-nothing-found' => 'Näischt fonnt',
	'categorytree-no-subcategories' => 'Keng Ënnerkategorien',
	'categorytree-no-parent-categories' => 'Keng Iwwerkategorien',
	'categorytree-no-pages' => 'Keng Säiten oder Ënnerkategorien',
	'categorytree-not-found' => "Kategorie ''$1'' net fonnt",
	'categorytree-error' => 'Problem beim luede vun den Donneeën.',
	'categorytree-retry' => 'Waart w.e.g. een Ament a probéiert dann nach eng Kéier.',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'categorytree' => 'Arbor de categorias',
	'categorytree-portlet' => 'Categorias',
	'categorytree-category' => 'Categoria:',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'categorytree' => 'Categorieboum',
	'categorytree-portlet' => 'Categorië',
	'categorytree-legend' => 'Categorieboum laote zeen',
	'categorytree-desc' => "AJAX-gebaseerde oetbreijing óm de [[Special:CategoryTree|categoriestructuur]] van 'ne wiki te toeane",
	'categorytree-header' => "Gaef 'ne categorienaam in om de inhoud es 'ne boumstructuur te bekieke.
Let op: deze functie gebroek JavaScript-functionaliteit dae bekindj steit es AJAX.
Esse 'ne erg verajerdje browser höbs of JavaScript steit oet, den werk dees functie neet.",
	'categorytree-category' => 'Categorie:',
	'categorytree-go' => 'Laje',
	'categorytree-parents' => 'Baoveligkendje categorië',
	'categorytree-mode-categories' => 'allein categorië',
	'categorytree-mode-pages' => 'paazjes behaueve aafbeildinge',
	'categorytree-mode-all' => "alle pazjena's",
	'categorytree-collapse' => 'inklappe',
	'categorytree-expand' => 'oetklappe',
	'categorytree-member-counts' => "bevat {{PLURAL:$1|éin ondercategorie|$1 ondercategorië}}, {{PLURAL:$2|éin pagina|$2 pagina's}} en {{PLURAL:$3|éin bestand|$3 bestande}}",
	'categorytree-load' => 'laje',
	'categorytree-loading' => "aan 't laje",
	'categorytree-nothing-found' => 'Dees categorie haet gein subcategorië.',
	'categorytree-no-subcategories' => 'Gein subcategorië.',
	'categorytree-no-parent-categories' => 'gein baovecategorië',
	'categorytree-no-pages' => "Gein pazjena's of óngercategorië.",
	'categorytree-not-found' => "Categorie ''$1'' neet gevónje",
	'categorytree-error' => "Perbleem bie 't laje van de gegaeves.",
	'categorytree-retry' => "Wach estebleef effe en perbeer 't den opnuuj.",
);

/** Lao (ລາວ)
 * @author Passawuth
 */
$messages['lo'] = array(
	'categorytree' => 'ໂຄງສ້າງໝວດ',
	'categorytree-legend' => 'ສະແດງແຜນຜັງໝວດ',
	'categorytree-header' => 'ພິມຊື່ໝວດໃສ່ ເພື່ອເບິ່ງໂຄງສ້າງມັນ. ຟັງຊັງຕ້ອງການໃຊ້ AJAX ໃນ JavaScript. ຖ້າ ທ່ານ ໃຊ້ໂປຣແກຣມທ່ອງເວັບເກົ່າ ຫຼື ບໍ່ອະນຸຍາດ JavaScript, ມັນກໍ່ຈະບໍ່ເຮັດວຽກ.',
	'categorytree-category' => 'ໝວດ',
	'categorytree-go' => 'ສະແດງໂຄງສ້າງ',
	'categorytree-parents' => 'ໝວດແມ່',
	'categorytree-mode-categories' => 'ໝວດເທົ່ານັ້ນ',
	'categorytree-mode-pages' => 'ໜ້າ ນອກຈາກ ໜ້າຮູບ',
	'categorytree-mode-all' => 'ທຸກໆໜ້າ',
	'categorytree-collapse' => 'ຫຍໍ້ເຂົ້າ',
	'categorytree-expand' => 'ຂະຫຍາຍອອກ',
	'categorytree-load' => 'ໂຫຼດ',
	'categorytree-loading' => 'ພວມໂຫຼດ',
	'categorytree-nothing-found' => 'ບໍ່ພົບຫຍັງ',
	'categorytree-no-subcategories' => 'ບໍ່ມີໝວດຍ່ອຍ',
	'categorytree-no-pages' => 'ບໍ່ມີໜ້າ ຫຼື ໝວດຍ່ອຍ',
	'categorytree-not-found' => 'ບໍ່ເຫັນ',
	'categorytree-error' => 'ການໂຫຼດຂໍ້ມູນມີປັນຫາ',
	'categorytree-retry' => 'ກະລຸນາຮອສັກຄູ່ ແລ້ວລອງໂຫຼດໃໝ່',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'categorytree' => 'Kategorijų medis',
	'categorytree-legend' => 'Rodyti kategorijų medį',
	'categorytree-header' => 'Įveskite kategorijos pavadinimą, kad pamatytumėte jos turinį kaip medžio struktūrą.
Primename, kad tam reikia išplėstinis JavaScript fukcionalumas, kitaip žinomas kaip AJAX.
Jei turi labai seną naršyklę, arba esate išjungę JavaScript, tai neveiks.',
	'categorytree-category' => 'Kategorija',
	'categorytree-go' => 'Rodyti medį',
	'categorytree-parents' => 'Aukštesnio lygio kategorija',
	'categorytree-mode-categories' => 'tik kategorijos',
	'categorytree-mode-pages' => 'puslapiai išskyrus paveikslėlius',
	'categorytree-mode-all' => 'visi puslapiai',
	'categorytree-collapse' => 'suskleisti',
	'categorytree-expand' => 'išskleisti',
	'categorytree-load' => 'įkelti',
	'categorytree-loading' => 'įkeliama',
	'categorytree-nothing-found' => 'nieko nerasta',
	'categorytree-no-subcategories' => 'nėra jokių subkategorijų',
	'categorytree-no-pages' => 'jokių puslapių ar subkategorijų',
	'categorytree-not-found' => 'Kategorija <i>$1</i> nerasta',
	'categorytree-error' => 'Duomenų įkėlimo problema.',
	'categorytree-retry' => 'Palaukite šiek tiek, ir bandykite iš naujo.',
);

/** Latvian (Latviešu)
 * @author Xil
 * @author Yyy
 */
$messages['lv'] = array(
	'categorytree' => 'KategorijuKoks',
	'categorytree-portlet' => 'Kategorijas',
	'categorytree-legend' => 'Rādīt kategoriju koku',
	'categorytree-desc' => "AJAX bāzēts ''gadget'', kuru lieto lai attēlotu wiki [[Special:CategoryTree|kategoriju struktūru]]",
	'categorytree-header' => 'Ievadi kategorijas nosaukumu lai apskatītos tās saturu kā koka struktūru. 
Tam ir nepieciešama JavaScript (AJAX) funkcionalitāte. 
Ja tev ir veca interneta pārlūkprogramma, vai arī JavaScript ir atslēgts, šitas te nedarbosies.',
	'categorytree-category' => 'Kategorija:',
	'categorytree-go' => 'Parādīt koku',
	'categorytree-mode-categories' => 'tikai kategorijas',
	'categorytree-mode-pages' => 'lapas (bez attēlu lapām)',
	'categorytree-mode-all' => 'visas lapas',
	'categorytree-collapse' => 'sakļaut',
	'categorytree-expand' => 'izplest',
	'categorytree-loading' => 'ielādējas...',
	'categorytree-nothing-found' => 'neko neatrada',
	'categorytree-no-subcategories' => 'nav apakškategoriju',
	'categorytree-no-pages' => 'nav ne lapu, ne apakškategoriju',
	'categorytree-not-found' => 'Kategorija <i>$1</i> netika atrasta',
	'categorytree-error' => 'Problēma ar datu ielādi.',
	'categorytree-retry' => 'Pagaidi mazliet un mēģini vēlreiz.',
);

/** Macedonian (Македонски)
 * @author Brest
 * @author Brest2008
 */
$messages['mk'] = array(
	'categorytree' => 'Дрво на категории',
	'categorytree-portlet' => 'Категории',
	'categorytree-legend' => 'Прикажи дрво на категории',
	'categorytree-desc' => 'Динамичка навигација низ [[Special:CategoryTree|структурата на категории]]',
	'categorytree-header' => 'Внесете назив на категорија за да ја видите нејзината содржина во форма на дрво.
Да напоменеме дека оваа функција побарува JavaScript т.е. AJAX.
Ако имате доста стар прелистувач, или JavaScript функционалноста вие е стопирана, ова нема да функционира.',
	'categorytree-category' => 'Категорија:',
	'categorytree-go' => 'Прикажи дрво',
	'categorytree-parents' => 'Родители',
	'categorytree-mode-categories' => 'само категории',
	'categorytree-mode-pages' => 'страници без податотеки',
	'categorytree-mode-all' => 'сите страници',
	'categorytree-collapse' => 'затвори',
	'categorytree-expand' => 'отвори',
	'categorytree-member-counts' => 'содржи {{PLURAL:$1|една подкатегорија|$1 подкатегории}}, {{PLURAL:$2|една страница|$2 страници}} и {{PLURAL:$3|една податотека|$3 податотеки}}',
	'categorytree-load' => 'вчитување',
	'categorytree-loading' => 'вчитување...',
	'categorytree-nothing-found' => 'не е најдено ништо',
	'categorytree-no-subcategories' => 'нема подкатегории',
	'categorytree-no-parent-categories' => 'нема родителски категории',
	'categorytree-no-pages' => 'нема страници или подкатегории',
	'categorytree-not-found' => 'Не е пронајдена категорија <i>$1</i>',
	'categorytree-error' => 'Проблеми со вчитување на податоците.',
	'categorytree-retry' => 'Ве молиме почекајте неколку моменти и обидетесе повторно.',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'categorytree' => 'വര്‍ഗ്ഗവൃക്ഷം',
	'categorytree-legend' => 'വര്‍ഗ്ഗവൃക്ഷം പ്രദര്‍ശിപ്പിക്കുക',
	'categorytree-desc' => 'വിക്കിയിലെ [[Special:CategoryTree|വിഭാഗങ്ങളുടെ ഘടന]] പ്രദര്‍ശിപ്പിക്കുവാനുള്ള  AJAX സാങ്കേതികവിദ്യ ഉപയോഗിക്കുന്ന ഗാഡ്ജറ്റ്.',
	'categorytree-header' => 'വിഭാഗങ്ങളുടെ ഘടന വ്യക്ഷരൂപത്തില്‍ കാണുവാന്‍ ഒരു വിഭാഗത്തിന്റെ പേരു ചേര്‍ക്കുക.
ഇതു പ്രവര്‍ത്തിക്കണമെങ്കില്‍ AJAX എന്ന ചുരുക്കനാമത്തിലറിയപ്പെടുന്ന അഡ്‌വാന്‍സ്‌ഡ് ജാവാസ്ക്രിപ്റ്റ് സാങ്കേതികവിദ്യ ആവശ്യമാണ്‌.
താങ്കളുടെ ബ്രൗസറില്‍ ജാവാസ്ക്രിപ്റ്റ് പ്രവര്‍ത്തനരഹിതമാക്കിയതാണെങ്കിലോ അല്ലെങ്കില്‍ ബ്രൗസര്‍ കാലഹരണപ്പെട്ടതാണെങ്കിലോ ഇതു പ്രവര്‍ത്തിക്കില്ല.',
	'categorytree-category' => 'വര്‍ഗ്ഗം:',
	'categorytree-go' => 'വൃക്ഷം പ്രദര്‍ശിപ്പിക്കുക',
	'categorytree-mode-categories' => 'വിഭാഗങ്ങള്‍ മാത്രം',
	'categorytree-mode-pages' => 'ചിത്രങ്ങള്‍ ഒഴിച്ചുള്ള താളുകള്‍',
	'categorytree-mode-all' => 'എല്ലാ താളുകളും',
	'categorytree-collapse' => 'അടയ്ക്കുക',
	'categorytree-expand' => 'വികസിപ്പിക്കുക',
	'categorytree-load' => 'ലോഡ് ചെയ്യുക',
	'categorytree-loading' => 'ശേഖരിച്ചുകൊണ്ടിരിക്കുന്നു…',
	'categorytree-nothing-found' => 'ഒന്നും കണ്ടെത്തിയില്ല',
	'categorytree-no-subcategories' => 'ഉപവിഭാഗങ്ങളില്ല',
	'categorytree-no-pages' => 'താളുകളോ ഉപവിഭാഗങ്ങളോ ഇല്ല',
	'categorytree-not-found' => "''$1'' എന്ന വര്‍ഗ്ഗം കണ്ടില്ല",
	'categorytree-error' => 'ഡാറ്റ ലോഡ് ചെയ്യുന്നതില്‍ പിശക്.',
	'categorytree-retry' => 'കുറച്ചു നേരം കഴിഞ്ഞ് വീണ്ടും പരിശ്രമിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'categorytree' => 'वर्गवृक्ष',
	'categorytree-legend' => 'वर्गवृक्ष दाखवा',
	'categorytree-desc' => 'एखाद्या विकिची [[Special:CategoryTree|वर्गीकरण मांडणी]] दाखवण्याकरिता AJAX वापरून बनवलेले उपकरण',
	'categorytree-header' => 'एखाद्या वर्गीकरणातील मसुदा वृक्ष स्वरूपात पहाण्याकरिता  त्या वर्गाचे नाव भरा.
या सुविधेकरिता AJAX नावाची आधुनिक जावास्क्रीप्ट सुविधेची गरज भासते हे लक्षात घ्या.हि सुविधा,जर तुमचा विचरक खूप जुना असेल, अथवा त्यातील जावास्क्रीप्ट सुविधा अनुपलब्ध ठेवली असेल तर, काम करणार नाही.',
	'categorytree-category' => 'वर्ग:',
	'categorytree-go' => 'वृक्ष दाखवा',
	'categorytree-parents' => 'पालक',
	'categorytree-mode-categories' => 'केवळ वर्ग',
	'categorytree-mode-pages' => 'चित्रे नसलेली पाने',
	'categorytree-mode-all' => 'सर्व पाने',
	'categorytree-collapse' => 'कोलॅप्स',
	'categorytree-expand' => 'विस्तार',
	'categorytree-load' => 'चढवा',
	'categorytree-loading' => 'चढवत आहे',
	'categorytree-nothing-found' => 'काहीच गवसले नाही',
	'categorytree-no-subcategories' => 'उपवर्ग नाहीत',
	'categorytree-no-pages' => 'पाने अथवा उपवर्ग नाहीत',
	'categorytree-not-found' => 'वर्ग <i>$1</i> आढळला नाही',
	'categorytree-error' => 'विदा चढवताना त्रूटी.',
	'categorytree-retry' => 'कृपया,क्षणभर थांबा आणि पुन्हा प्रयत्न करा.',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'categorytree' => 'Salasilah kategori',
	'categorytree-portlet' => 'Kategori',
	'categorytree-legend' => 'Papar salasilah kategori',
	'categorytree-desc' => 'Alat berdasarkan AJAX yang memaparkan [[Special:CategoryTree|struktur kategori]] bagi sesebuah wiki',
	'categorytree-header' => 'Masukkan suatu nama kategori untuk melihat kandungannya dalam bentuk struktur salasilah.
Ciri ini memerlukan kefungsian JavaScript yang maju dikenali sebagai AJAX.
Jika anda menggunakan pelayar web yang sudah ketinggalan, atau mematikan JavaScript, ciri ini tidak akan menjadi.',
	'categorytree-category' => 'Kategori',
	'categorytree-go' => 'Tunjukkan salasilah',
	'categorytree-parents' => 'Induk',
	'categorytree-mode-categories' => 'kategori sahaja',
	'categorytree-mode-pages' => 'laman kecuali imej',
	'categorytree-mode-all' => 'semua laman',
	'categorytree-collapse' => 'lipat',
	'categorytree-expand' => 'bentang',
	'categorytree-member-counts' => 'mengandungi $1 subkategori, $1 laman, dan $3 fail',
	'categorytree-load' => 'muat',
	'categorytree-loading' => 'memuat…',
	'categorytree-nothing-found' => 'kosong',
	'categorytree-no-subcategories' => 'tiada subkategori',
	'categorytree-no-parent-categories' => 'tiada kategori induk',
	'categorytree-no-pages' => 'tiada laman atau subkategori',
	'categorytree-not-found' => 'Kategori <i>$1</i> tidak ditemui',
	'categorytree-error' => 'Masalah memuat data.',
	'categorytree-retry' => 'Sila tunggu sebentar dan cuba lagi.',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'categorytree' => 'Siġra tal-kategoriji',
	'categorytree-mode-all' => 'il-paġni kollha',
);

/** Erzya (Эрзянь)
 * @author Amdf
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'categorytree-portlet' => 'Категорият',
	'categorytree-category' => 'Категория:',
	'categorytree-mode-categories' => 'ансяк категорият',
	'categorytree-mode-all' => 'весе лопатне',
	'categorytree-collapse' => 'теингавтомс',
	'categorytree-expand' => 'келемтемс',
	'categorytree-no-subcategories' => 'алкс категорият арасть',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'categorytree-portlet' => 'Neneuhcāyōtl',
	'categorytree-category' => 'Neneuhcāyōtl:',
	'categorytree-loading' => 'tēmohua...',
	'categorytree-no-subcategories' => 'ahmo neneuhcāyōtl',
);

/** Min Nan Chinese (Bân-lâm-gú) */
$messages['nan'] = array(
	'categorytree-loading' => 'teh ji̍p',
	'categorytree-no-subcategories' => 'bô ē-lūi-pia̍t',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'categorytree' => 'Kategorie-Boom',
	'categorytree-portlet' => 'Kategorien',
	'categorytree-legend' => 'Kategorieboom wiesen',
	'categorytree-desc' => 'Dynaamsche Navigatschoon för de [[Special:CategoryTree|Kategorien-Struktur]]',
	'categorytree-header' => 'Kategorienaam ingeven, den Inholt as Boomstruktur to sehn. Schasst di bewusst wesen, dat Javascript un de AJAX-Funkschoon dor för bruukt warrt. Wenn dien Nettkieker to oolt is oder du keen Javascript hest, denn warrt dat nix.',
	'categorytree-category' => 'Kategorie:',
	'categorytree-go' => 'Boom wiesen',
	'categorytree-parents' => 'Öllernkategorien',
	'categorytree-mode-categories' => 'blot Kategorien',
	'categorytree-mode-pages' => 'Sieden, ahn Biller',
	'categorytree-mode-all' => 'all Sieden',
	'categorytree-collapse' => 'nich ganz wiesen',
	'categorytree-expand' => 'ganz wiesen',
	'categorytree-member-counts' => 'bargt {{PLURAL:$1|ene Ünnerkategorie|$1 Ünnerkategorien}}, {{PLURAL:$2|ene Sied|$2 Sieden}} un {{PLURAL:$3|ene Datei|$3 Datein}}',
	'categorytree-load' => 'laden',
	'categorytree-loading' => 'läädt',
	'categorytree-nothing-found' => 'nix funnen',
	'categorytree-no-subcategories' => 'kene Ünnerkategorien',
	'categorytree-no-parent-categories' => 'Kene Öllernkategorien',
	'categorytree-no-pages' => 'kene Sieden oder Ünnerkategorien',
	'categorytree-not-found' => 'Kategorie <i>$1</i> nich funnen',
	'categorytree-error' => 'Problem bi’t Laden vun de Daten',
	'categorytree-retry' => 'Tööv en beten un denn versöök dat noch wedder.',
);

/** Nepali (नेपाली) */
$messages['ne'] = array(
	'categorytree-category' => 'श्रेणी:',
	'categorytree-mode-categories' => 'श्रेणी मात्र',
	'categorytree-mode-pages' => 'तस्वीरहरू बाहेकका पृष्ठहरू',
	'categorytree-mode-all' => 'सबै पृष्ठहरु',
	'categorytree-collapse' => 'खुम्च्याउनु',
	'categorytree-expand' => 'फैलाउनु',
	'categorytree-nothing-found' => 'केहीपनि फेला परेन',
	'categorytree-no-subcategories' => 'उपश्रेणीहरू छैनन्',
	'categorytree-no-pages' => 'पृष्ठहरू वा उपश्रेणीहरू छैनन्',
	'categorytree-not-found' => 'श्रेणी <i>$1</i> फेला परेन',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'categorytree' => 'Categorieboom',
	'categorytree-portlet' => 'Categorieën',
	'categorytree-legend' => 'Categorieboom weergeven',
	'categorytree-desc' => 'AJAX-gebaseerde uitbreiding om de [[Special:CategoryTree|categoriestructuur]] van een wiki te bekijken',
	'categorytree-header' => 'Geef een categorienaam in om de inhoud als een boomstructuur te bekijken.
Let op: deze functie gebruikt JavaScript-functionaliteit die bekend staat als AJAX.
Als u een verouderde browser hebt of JavaScript uitgeschakeld is, dan werkt deze functie niet.',
	'categorytree-category' => 'Categorie',
	'categorytree-go' => 'Laden',
	'categorytree-parents' => 'Bovenliggende categorieën',
	'categorytree-mode-categories' => 'alleen categorieën',
	'categorytree-mode-pages' => 'geen afbeeldingen',
	'categorytree-mode-all' => "alle pagina's",
	'categorytree-collapse' => 'inklappen',
	'categorytree-expand' => 'uitklappen',
	'categorytree-member-counts' => "bevat {{PLURAL:$1|één ondercategorie|$1 ondercategorieën}}, {{PLURAL:$2|één pagina|$2 pagina's}} en {{PLURAL:$3|één bestand|$3 bestanden}}",
	'categorytree-load' => 'laden',
	'categorytree-loading' => 'aan het laden…',
	'categorytree-nothing-found' => 'niets gevonden',
	'categorytree-no-subcategories' => 'Geen ondercategorieën.',
	'categorytree-no-parent-categories' => 'geen bovencategorieën',
	'categorytree-no-pages' => "Geen pagina's of ondercategorieën.",
	'categorytree-not-found' => "Categorie ''$1'' niet gevonden",
	'categorytree-error' => 'Probleem bij het laden van de gegevens.',
	'categorytree-retry' => 'Wacht even en probeer het dan opnieuw.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Harald Khan
 */
$messages['nn'] = array(
	'categorytree' => 'Kategoritre',
	'categorytree-portlet' => 'Kategoriar',
	'categorytree-legend' => 'Vis kategoritre',
	'categorytree-desc' => 'AJAX-basert verktøy som viser [[Special:CategoryTree|kategoristrukturen]] til ein wiki',
	'categorytree-header' => 'Skriv inn eit kategorinamn for å sjå innhaldet som ein trestruktur. Merk at denne funksjonen nyttar avansert [[JavaScript]]-funksjonalitet ([[AJAX]]). Dersom du brukar ein veldig gammal nettlesar, eller har slått av JavaScript-støtte, vil dette ikkje fungere.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Vis kategoritre',
	'categorytree-parents' => 'Overkategoriar',
	'categorytree-mode-categories' => 'berre kategoriane',
	'categorytree-mode-pages' => 'sider med unntak av filer',
	'categorytree-mode-all' => 'alle sidene',
	'categorytree-collapse' => 'gøym',
	'categorytree-expand' => 'vis',
	'categorytree-member-counts' => 'inneheld {{PLURAL:$1|éin underkategori|$1 underkategoriar}}, {{PLURAL:$2|éi sida|$2 sider}} og {{PLURAL:$3|éi fil|$3 filer}}',
	'categorytree-load' => 'last inn',
	'categorytree-loading' => 'lastar inn',
	'categorytree-nothing-found' => 'fann ikkje noko',
	'categorytree-no-subcategories' => 'ingen underkategoriar',
	'categorytree-no-parent-categories' => 'ingen foreldrekategoriar',
	'categorytree-no-pages' => 'ingen sider eller underkategoriar',
	'categorytree-not-found' => 'Fann ikkje kategorien <i>$1</i>',
	'categorytree-error' => 'Problem med innlasting av data.',
	'categorytree-retry' => 'Ver venleg og vent litt før du prøver ein gong til.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'categorytree' => 'Kategoritre',
	'categorytree-portlet' => 'Kategorier',
	'categorytree-legend' => 'Vis kategoritre',
	'categorytree-desc' => 'AJAX-basert verktøy som viser [[Special:CategoryTree|kategoristrukturen]] til en wiki',
	'categorytree-header' => 'Skriv inn et kategorinavn for å se dens innhold som en trestruktur. Merk at dette trenger en avansert type Javascript-funksjonalitet kjent som AJAX. Dersom du har en gammel nettleser eller har slått av Javascript vil dette ikke fungere.

Enter a category name to see its contents as a tree structure. Note that this requires advanced JavaScript functionality known as AJAX. If you have a very old browser, or have JavaScript disabled, it will not work.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Vis',
	'categorytree-parents' => 'Overkategorier',
	'categorytree-mode-categories' => 'bare kategorier',
	'categorytree-mode-pages' => 'sider utenom bilder',
	'categorytree-mode-all' => 'alle sider',
	'categorytree-collapse' => 'skjul',
	'categorytree-expand' => 'vis',
	'categorytree-member-counts' => 'inneholder {{PLURAL:$1|én underkategori|$1 underkategorier}}, {{PLURAL:$2|én side|$2 sider}} og {{PLURAL:$3|én fil|$3 filer}}',
	'categorytree-load' => 'last',
	'categorytree-loading' => 'laster',
	'categorytree-nothing-found' => 'Ingen resultater funnet.',
	'categorytree-no-subcategories' => 'Ingen underkategorier.',
	'categorytree-no-parent-categories' => 'ingen foreldrekategorier',
	'categorytree-no-pages' => 'Ingen artikler eller underkategorier.',
	'categorytree-not-found' => 'Kategorien <i>$1</i> ikke funnet',
	'categorytree-error' => 'problem under datalasting.',
	'categorytree-retry' => 'Vent en stund og prøv igjen.',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'categorytree-category' => 'Sehlopha:',
	'categorytree-go' => 'Bontsha Sehlare',
	'categorytree-parents' => 'Batswadi',
	'categorytree-mode-all' => 'matlakala kamoka',
	'categorytree-collapse' => 'tswalela',
	'categorytree-expand' => 'bula',
	'categorytree-no-pages' => 'gago matlakala goba dihlophana',
	'categorytree-not-found' => 'Sehlopha <i>$1</i> ga se humanege',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'categorytree' => 'Arborescéncia de las categorias',
	'categorytree-portlet' => 'Categorias',
	'categorytree-legend' => 'Visionar l’arborescéncia de la categoria',
	'categorytree-desc' => "Gadget basat sus AJAX per afichar l'[[Special:CategoryTree|estructura de la categoria]] d’un wiki",
	'categorytree-header' => "Picatz un nom de categoria per veire son contengut en estructura arborescenta. Notatz qu'aquò utiliza de foncionalitats JavaScript avançadas conegudas jol nom d'AJAX. S'avètz un navigador fòrt ancian o qu'avètz pas activat lo JavaScript, aquò foncionarà pas.",
	'categorytree-category' => 'Categoria :',
	'categorytree-go' => "Mostrar l'arborescéncia",
	'categorytree-parents' => 'Subrecategoria(s)',
	'categorytree-mode-categories' => 'pas que las categorias',
	'categorytree-mode-pages' => 'paginas sens los imatges',
	'categorytree-mode-all' => 'totas las paginas',
	'categorytree-collapse' => 'Rebatre',
	'categorytree-expand' => 'Desplegar',
	'categorytree-member-counts' => 'conten {{PLURAL:$1|1 soscategoria|$1 soscategorias}}, {{PLURAL:$2|1 pagina|$2 paginas}}, e {{PLURAL:$3|1 fichièr|$3 fichièrs}}',
	'categorytree-load' => 'Dobrir',
	'categorytree-loading' => 'dobertura...',
	'categorytree-nothing-found' => 'Cap de soscategoria',
	'categorytree-no-subcategories' => 'Pas de soscategoria',
	'categorytree-no-parent-categories' => 'Cap de categoria parenta',
	'categorytree-no-pages' => 'Pas de pagina o de soscategoria',
	'categorytree-not-found' => 'La categoria <i>$1</i> es pas estada trobada.',
	'categorytree-error' => 'Problèma de cargament de las donadas.',
	'categorytree-retry' => 'Esperatz un moment puèi tornatz ensajar.',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'categorytree-portlet' => 'Категоритæ',
	'categorytree-category' => 'Категори:',
	'categorytree-go' => 'Равдис бæлас',
	'categorytree-mode-all' => 'æппæт фæрстæ',
	'categorytree-nothing-found' => 'Ацы категорийы мидæг дæлкатегоритæ нæ разынд',
	'categorytree-no-pages' => 'фæрстæ æмæ дæлкатегоритæ нæй',
	'categorytree-not-found' => 'Категори «$1» не ссардæуы.',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Gman124
 */
$messages['pa'] = array(
	'categorytree-category' => 'ਸ਼੍ਰੇਣੀ:',
	'categorytree-mode-pages' => 'ਤਸਵੀਰਾਂ ਦੇ ਇਲਾਵਾ ਪੇਜ',
	'categorytree-mode-all' => 'ਸਭ ਪੇਜ',
);

/** Pangasinan (Pangasinan) */
$messages['pag'] = array(
	'categorytree-mode-pages' => 'Saray bolobolong ya aga kaibay picture',
	'categorytree-mode-all' => 'Amin ya bolobolong',
	'categorytree-collapse' => 'isara',
	'categorytree-expand' => 'lukasan',
	'categorytree-load' => 'I-lugan',
	'categorytree-nothing-found' => 'anggapoy naanap',
	'categorytree-no-pages' => 'Anggapoy bolong odino subcategory',
);

/** Pampanga (Kapampangan) */
$messages['pam'] = array(
	'categorytree-mode-pages' => 'bulung liban kareng larawan',
	'categorytree-mode-all' => 'Eganaganang bulung',
	'categorytree-collapse' => 'ilati',
	'categorytree-expand' => 'paragulan',
	'categorytree-load' => 'lulan',
	'categorytree-loading' => 'Lululan',
	'categorytree-nothing-found' => 'alang meyakit',
);

/** Polish (Polski)
 * @author Airwolf
 * @author Derbeth
 * @author Matma Rex
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'categorytree' => 'Drzewo kategorii',
	'categorytree-portlet' => 'Kategorie',
	'categorytree-legend' => 'Pokaż drzewo kategorii',
	'categorytree-desc' => 'Gadżet oparty na technologii AJAX, wyświetlający [[Special:CategoryTree|drzewo kategorii]]',
	'categorytree-header' => 'Wpisz nazwę kategorii, by zobaczyć jej zawartość w postaci drzewa. Wymagana jest zaawansowana funkcjonalność JavaScriptu, znana jako AJAX. Jeśli masz bardzo starą przeglądarkę lub wyłączony JavaScript, ta funkcja nie zadziała.',
	'categorytree-category' => 'Kategoria',
	'categorytree-go' => 'Ładuj kategorię',
	'categorytree-parents' => 'Kategorie główne',
	'categorytree-mode-categories' => 'tylko kategorie',
	'categorytree-mode-pages' => 'strony oprócz plików',
	'categorytree-mode-all' => 'wszystkie strony',
	'categorytree-collapse' => 'zwiń',
	'categorytree-expand' => 'rozwiń',
	'categorytree-member-counts' => 'zawiera {{PLURAL:$1|1 podkategorię|$1 podkategorie|$1 podkategorii}}, {{PLURAL:$2|1 stronę|$2 strony|$2 stron}} oraz {{PLURAL:$3|1 plik|$3 pliki|$3 plików}}',
	'categorytree-load' => 'wczytaj',
	'categorytree-loading' => 'wczytywanie...',
	'categorytree-nothing-found' => 'nic nie znaleziono',
	'categorytree-no-subcategories' => 'brak podkategorii',
	'categorytree-no-parent-categories' => 'brak kategorii nadrzędnej',
	'categorytree-no-pages' => 'brak artykułów lub podkategorii.',
	'categorytree-not-found' => 'Kategoria <i>$1</i> nie została znaleziona',
	'categorytree-error' => 'Problem z ładowaniem danych.',
	'categorytree-retry' => 'Poczekaj chwilę i spróbuj ponownie – kliknij ten napis.',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'categorytree' => 'Erbo dle categorìe',
	'categorytree-header' => "Ch'a buta ël nòm ëd na categorìa për ës-ciairene ij contnù e la strutura. Ch'a ten-a present che përchè sòn a travaja a-i va na fonsion Javascript avansà ch'as ciama AJAX. Se un a l'ha un navigator vej ò pura a l'ha nen abilità Javascript sossì a travaja nen.",
	'categorytree-category' => 'Categorìa:',
	'categorytree-go' => "Deurbe l'erbo",
	'categorytree-parents' => 'Cé',
	'categorytree-mode-categories' => 'smon mach le categorìe',
	'categorytree-mode-pages' => 'mach le pàgine gavà le figure',
	'categorytree-mode-all' => 'tute le pàgine',
	'categorytree-collapse' => 'sëré',
	'categorytree-expand' => 'deurbe',
	'categorytree-load' => 'carié',
	'categorytree-loading' => "antramentr ch'as carìa",
	'categorytree-nothing-found' => 'pa trovà gnente',
	'categorytree-no-subcategories' => 'gnun-a sot-categorìa',
	'categorytree-no-pages' => 'pa ëd pàgine ò ëd sot-categorìe',
	'categorytree-not-found' => "A l'é pa trovasse la categorìa <i>$1</i>.",
	'categorytree-error' => 'Problema ën cariand ij dat',
	'categorytree-retry' => "Për piasì, ch'a speta na minuta e peuj ch'as preuva n'àutra vira.",
);

/** Pontic (Ποντιακά)
 * @author Sinopeus
 */
$messages['pnt'] = array(
	'categorytree-portlet' => 'Κατηγορίας',
	'categorytree-category' => 'Κατηγορία:',
	'categorytree-mode-all' => "ούλ' σελίδας",
	'categorytree-load' => 'φόρτωμαν',
	'categorytree-loading' => "φορτών'",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'categorytree' => 'د وېشنيزو ونه',
	'categorytree-portlet' => 'وېشنيزې',
	'categorytree-legend' => 'د وېشنيزې ونه ښکاره کول',
	'categorytree-category' => ':وېشنيزه',
	'categorytree-go' => 'ونه ښکاره کول',
	'categorytree-mode-categories' => 'يوازې وېشنيزې',
	'categorytree-mode-pages' => 'مخونه پرته د دوتنو نه',
	'categorytree-mode-all' => 'ټول مخونه',
	'categorytree-expand' => 'غځول',
	'categorytree-load' => 'برسېرول',
	'categorytree-loading' => 'د برسېرېدلو په حال کې...',
	'categorytree-nothing-found' => 'هېڅ هم و نه موندل شو',
	'categorytree-no-subcategories' => 'هېڅ وړې-وېشنيزې نشته',
	'categorytree-no-pages' => 'هېڅ مخ يا وړه-وېشنيزه نشته',
	'categorytree-not-found' => 'د <i>$1</i> وېشنيزه و نه موندل شوه',
	'categorytree-error' => 'د مالوماتو د برسېرېدلو ستونزه.',
	'categorytree-retry' => 'مهرباني وکړی لږ څه تم شی او بيا يې وآزمايۍ',
);

/** Portuguese (Português)
 * @author 555
 */
$messages['pt'] = array(
	'categorytree' => 'Árvore de categorias',
	'categorytree-portlet' => 'Categorias',
	'categorytree-legend' => 'Exibir a árvore de categorias',
	'categorytree-desc' => 'Acessório (gadget) baseado em AJAX que apresenta a [[Special:CategoryTree|estrutura]] de um wiki',
	'categorytree-header' => 'Insira o nome de uma categoria para ver seu conteúdo como uma estrutura de "árvore".
Note que isso requer funcionalidades avançadas de JavaScript (como, por exemplo, AJAX).
Caso o seu navegador seja razoavelmente antigo, ou, caso JavaScript esteja desabilitado em seu navegador, isto não funcionará.',
	'categorytree-category' => 'Categoria:',
	'categorytree-go' => 'Exibir Árvore',
	'categorytree-parents' => 'Categorias superiores',
	'categorytree-mode-categories' => 'mostrar apenas as categorias',
	'categorytree-mode-pages' => 'páginas, exceto imagens',
	'categorytree-mode-all' => 'todas as páginas',
	'categorytree-collapse' => 'ocultar',
	'categorytree-expand' => 'expandir',
	'categorytree-member-counts' => 'possui {{PLURAL:$1|uma subcategoria|$1 subcategorias}}, {{PLURAL:$2|uma página|$2 páginas}} e {{PLURAL:$3|um ficheiro|$3 ficheiros}}',
	'categorytree-load' => 'carregar',
	'categorytree-loading' => 'carregando',
	'categorytree-nothing-found' => 'Sentimos muito, não se encontrou nada',
	'categorytree-no-subcategories' => 'sem subcategorias',
	'categorytree-no-parent-categories' => 'não há categorias superiores',
	'categorytree-no-pages' => 'sem páginas nem subcategorias',
	'categorytree-not-found' => 'A categoria <i>$1</i> não foi encontrada',
	'categorytree-error' => 'Problema ao carregar os dados.',
	'categorytree-retry' => 'Por gentileza, aguarde um momento e tente novamente.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Carla404
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'categorytree' => 'Árvore de categorias',
	'categorytree-portlet' => 'Categorias',
	'categorytree-legend' => 'Exibir a árvore de categorias',
	'categorytree-desc' => 'Acessório (gadget) baseado em AJAX que apresenta a [[Special:CategoryTree|estrutura]] de um wiki',
	'categorytree-header' => 'Insira o nome de uma categoria para ver seu conteúdo como uma estrutura de "árvore".
Note que isso requer funcionalidades avançadas de JavaScript (como, por exemplo, AJAX).
Caso o seu navegador seja razoavelmente antigo, ou, caso JavaScript esteja desabilitado em seu navegador, isto não funcionará.',
	'categorytree-category' => 'Categoria:',
	'categorytree-go' => 'Exibir Árvore',
	'categorytree-parents' => 'Categorias superiores',
	'categorytree-mode-categories' => 'mostrar apenas as categorias',
	'categorytree-mode-pages' => 'páginas, exceto imagens',
	'categorytree-mode-all' => 'todas as páginas',
	'categorytree-collapse' => 'ocultar',
	'categorytree-expand' => 'expandir',
	'categorytree-member-counts' => 'contém {{PLURAL:$1|1 subcategoria|$1 subcategorias}}, {{PLURAL:$2|1 página|$2 páginas}} e {{PLURAL:$3|1 arquivo|$3 arquivos}}',
	'categorytree-load' => 'carregar',
	'categorytree-loading' => 'carregando',
	'categorytree-nothing-found' => 'Sentimos muito, não se encontrou nada',
	'categorytree-no-subcategories' => 'sem subcategorias',
	'categorytree-no-parent-categories' => 'não há categorias superiores',
	'categorytree-no-pages' => 'sem páginas nem subcategorias',
	'categorytree-not-found' => 'A categoria <i>$1</i> não foi encontrada',
	'categorytree-error' => 'Problema ao carregar os dados.',
	'categorytree-retry' => 'Por gentileza, aguarde um momento e tente novamente.',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'categorytree' => "Katiguriya sach'a (CategoryTree)",
	'categorytree-portlet' => 'Katiguriyakuna',
	'categorytree-legend' => "Katiguriya sach'ata rikuchiy",
	'categorytree-desc' => "[[Special:CategoryTree|Katiguriya sach'anta]] kuyuylla wamp'uy",
	'categorytree-header' => "Katiguriya sutita yaykuchiy samiqninta sach'a hinata rikunaykipaq.
Musyariy, kaytaqa AJAX nisqa sapaq JavaScript ruranallawanmi llamk'achiyta atinki. Mawk'a wamp'unawanqa icha JavaScript nisqaman ama nispaqa manam atinkichu.",
	'categorytree-category' => 'Katiguriya:',
	'categorytree-go' => "Sach'ata rikuchiy",
	'categorytree-parents' => 'Mama katiguriyakuna',
	'categorytree-mode-categories' => 'Katiguriyakunalla',
	'categorytree-mode-pages' => "p'anqakuna amataq rikchakuna",
	'categorytree-mode-all' => "tukuy p'anqakuna",
	'categorytree-collapse' => 'pakay',
	'categorytree-expand' => 'rikuchiy',
	'categorytree-member-counts' => "{{PLURAL:$1|huk urin katiguriyayuqmi|$1 urin katiguriyayuqmi}}, {{PLURAL:$2|huk p'anqayuqmi|$2 p'anqayuqmi}}, {{PLURAL:$3|huk willañiqiyuqmi|$3 willañiqiyuqmi}}",
	'categorytree-load' => 'chaqnay',
	'categorytree-loading' => 'chaqnaspa',
	'categorytree-nothing-found' => 'manam imapas tarisqachu',
	'categorytree-no-subcategories' => 'mana ima urin katiguriyapas',
	'categorytree-no-parent-categories' => 'manam kanchu mama katiguriyakuna',
	'categorytree-no-pages' => 'mana ima urin qillqapas ni katiguriyapas',
	'categorytree-not-found' => '<i>$1</i> sutiyuq katiguriyaqa manam tarisqachu',
	'categorytree-error' => 'Manam atinichu willakunata chaqnayta.',
	'categorytree-retry' => 'Asllata suyaspa musuqmanta ruraykachay.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'categorytree' => 'Arborele categoriilor',
	'categorytree-portlet' => 'Categorii',
	'categorytree-legend' => 'Arată arborele categoriilor',
	'categorytree-desc' => 'Navighează dinamic în [[Special:CategoryTree|stuctura categoriilor]]',
	'categorytree-header' => 'Introduceţi numele categoriei pentru vizualizarea conţinutului în structură arborescentă. Notaţi faptul că această operaţie necesită funcţionalităţi JavaScript avansate cunoscute sub numele de AJAX. Dacă aveţi un browser vechi sau nu aveţi activat JavaScript, nu va funcţiona.',
	'categorytree-category' => 'Categorie:',
	'categorytree-go' => 'Arată arborele',
	'categorytree-parents' => 'Părinţi',
	'categorytree-mode-categories' => 'doar categorii',
	'categorytree-mode-pages' => 'pagini fără imagini',
	'categorytree-mode-all' => 'toate paginile',
	'categorytree-collapse' => 'restrânge',
	'categorytree-expand' => 'extinde',
	'categorytree-member-counts' => 'conţine {{PLURAL:$1|1 subcategorie|$1 subcategorii}}, {{PLURAL:$2|1 pagină|$2 pagini}} şi {{PLURAL:$3|1 fişier|$3 fişiere}}',
	'categorytree-load' => 'încarcă',
	'categorytree-loading' => 'încărcare…',
	'categorytree-nothing-found' => 'fără subcategorii',
	'categorytree-no-subcategories' => 'nici o subcategorie',
	'categorytree-no-parent-categories' => 'nici o categorie părinte',
	'categorytree-no-pages' => 'nici o pagină sau subcategorie',
	'categorytree-not-found' => 'Categoria <i>$1</i> nu a fost găsită',
	'categorytree-error' => 'Problemă la încărcarea datelor',
	'categorytree-retry' => 'Vă rugăm să aşteptaţi câteva momente şi să încercaţi din nou.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'categorytree' => 'Arvule de le categorije',
	'categorytree-portlet' => 'Categorije',
	'categorytree-category' => 'Categorije:',
	'categorytree-go' => "Fa vedè l'arvule",
	'categorytree-mode-all' => 'tutte le pàggene',
	'categorytree-collapse' => 'achiude',
	'categorytree-expand' => 'spanne',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'categorytree' => 'Дерево категорий',
	'categorytree-portlet' => 'Категории',
	'categorytree-legend' => 'Показать дерево категорий',
	'categorytree-desc' => 'AJAX-компонент для отображения [[Special:CategoryTree|структуры категорий]] вики',
	'categorytree-header' => 'Введите имя категории, и она будет показана в виде дерева.
Эта возможность доступна, только если ваш браузер поддерживает AJAX.
Если у вас старая версия браузера или отключен JavaScript, показ подкатегорий в виде дерева недоступен.',
	'categorytree-category' => 'Категория:',
	'categorytree-go' => 'Загрузить',
	'categorytree-parents' => 'Родительские категории',
	'categorytree-mode-categories' => 'только категории',
	'categorytree-mode-pages' => 'кроме изображений',
	'categorytree-mode-all' => 'все страницы',
	'categorytree-collapse' => 'свернуть',
	'categorytree-expand' => 'развернуть',
	'categorytree-member-counts' => 'содержит $1 {{PLURAL:$1|подкатегорию|подкатегории|подкатегорий}}, $2 {{PLURAL:$2|страницу|страницы|страниц}} и $3 {{PLURAL:$3|файл|файла|файлов}}',
	'categorytree-load' => 'загрузить',
	'categorytree-loading' => 'загрузка…',
	'categorytree-nothing-found' => 'Данная категория не содержит подкатегорий.',
	'categorytree-no-subcategories' => 'нет подкатегорий.',
	'categorytree-no-parent-categories' => 'нет родительских категорий',
	'categorytree-no-pages' => 'нет статей и подкатегорий.',
	'categorytree-not-found' => 'Категория «$1» не найдена.',
	'categorytree-error' => 'Ошибка загрузки данных.',
	'categorytree-retry' => 'Пожалуйста, подождите и попробуйте ещё раз.',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'categorytree' => 'Категориялар мас курдук',
	'categorytree-portlet' => 'Категориялар',
	'categorytree-legend' => 'Категориялар тутулларын көрдөр',
	'categorytree-desc' => 'Биики [[Special:CategoryTree|категорияларын тутулун]] көрдөрөр AJAX-компонент',
	'categorytree-header' => 'Категория аатын киллэрдэххинэ мас курдук көстүөҕэ.
Бу кыаҕы браузерыҥ AJAX-ы туһанар эрэ буоллаҕына туттар кыахтааххын.
Браузерыҥ эргэ буоллаҕына эбэтэр JavaScript арахсыбыт буоллаҕына субкатегорийалары мас курдук көрөр сатаммат.',
	'categorytree-category' => 'Категория:',
	'categorytree-go' => 'Көрдөр',
	'categorytree-parents' => 'Төрөппүттэрэ',
	'categorytree-mode-categories' => 'категориялар эрэ',
	'categorytree-mode-pages' => 'билэттэн ураты (билэ буолбатах) сирэйдэр',
	'categorytree-mode-all' => 'бары сирэйдэр',
	'categorytree-collapse' => 'сап',
	'categorytree-expand' => 'тэнит',
	'categorytree-member-counts' => '$1 {{PLURAL:$1|субкатегориялаах|субкатегориялардаах}}, $2 {{PLURAL:$2|сирэйдээх|сирэйдэрдээх}} уонна $3 {{PLURAL:$3|билэлээх|билэлэрдээх}}',
	'categorytree-load' => 'киллэр',
	'categorytree-loading' => 'киллэрии',
	'categorytree-nothing-found' => 'бу категория подкатегорията суох',
	'categorytree-no-subcategories' => 'субкатегорията суох',
	'categorytree-no-parent-categories' => 'төрөппүт категорията суох',
	'categorytree-no-pages' => 'ыстатыйата эбэтэр субкатегорията суох',
	'categorytree-not-found' => '<i>$1</i> категория көстүбэтэ',
	'categorytree-error' => 'Билэни суруйарга алҕас таҕыста',
	'categorytree-retry' => 'Кыратык кэтэһэ түһэн баран өссө боруобалаа',
);

/** Sardinian (Sardu)
 * @author Marzedu
 */
$messages['sc'] = array(
	'categorytree-category' => 'Categoria:',
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'categorytree' => 'Àrvulu  di li catigurìi',
	'categorytree-portlet' => 'Catigurìi',
	'categorytree-legend' => "Ammustra l'àrvuru di li catigurìi",
	'categorytree-desc' => 'Accissòriu AJAX pi taliari la [[Special:CategoryTree|struttura di li catigurìi]] dû situ',
	'categorytree-header' => 'Nziriri lu nomu dâ catigirìa di unni si disìa taliari lu cuntinutu sutta furma di struttura a àrvulu. La pàggina addumanna li funziunalitati avanzati di JavaScript saputi sèntiri AJAX; si veni usatu nu browser  vecchiu assai o li funzioni JavaScript sunnu disabbilitati, sta pàggina non funziona.',
	'categorytree-category' => 'Catigurìa:',
	'categorytree-go' => 'Càrica',
	'categorytree-parents' => 'Catigurìi cchiù àuti',
	'categorytree-mode-categories' => 'ammustra sulu li catigurìi',
	'categorytree-mode-pages' => 'tutti li pàggini, lassannu fora li mmàggini',
	'categorytree-mode-all' => 'tutti li pàggini',
	'categorytree-collapse' => 'cumprimi',
	'categorytree-expand' => 'spanni',
	'categorytree-member-counts' => 'cunteni {{PLURAL:$1|1 suttacatigurìa|$1 suttacatigurìi}}, {{PLURAL:$2|1 pàggina|$2 pàggini}} e {{PLURAL:$3|1 file|$3 file}}',
	'categorytree-load' => 'càrica',
	'categorytree-loading' => 'sta caricannu...',
	'categorytree-nothing-found' => 'nuddu risurtatu',
	'categorytree-no-subcategories' => 'nudda suttacatigurìa.',
	'categorytree-no-parent-categories' => 'nudda catigurìa cchià àuta',
	'categorytree-no-pages' => 'nudda vuci e nudda suttacatigurìa.',
	'categorytree-not-found' => "Catigurìa  ''$1'' non attruvata",
	'categorytree-error' => 'Prubbrema nnô caricamentu dî dati.',
	'categorytree-retry' => "Aspittari tanticchia e appoi pruvari n'ùutra vota.",
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'categorytree' => "Sthruttura ad'àiburu di li categuri",
	'categorytree-header' => "Insirì l'innommu di la categuria di la quari si vó vidé lu cuntinuddu attrabessu la sthruttura ad'àiburu. Amminta chi la pàgina vó li funzionariddai abanzaddi di JavaScript ciamaddi AJAX; s'ài un nabiggddori vécciu o cu' li funzioni JavaScript disàbiritaddi, chistha pàgina nò funziunerà.",
	'categorytree-category' => 'Categuria:',
	'categorytree-go' => 'Carrigga',
	'categorytree-parents' => 'Categuri superiori',
	'categorytree-mode-categories' => 'musthra soru li categuri',
	'categorytree-mode-pages' => "tutti li pàgini, eschrusi l'immàgini",
	'categorytree-mode-all' => 'tutti li pàgini',
	'categorytree-collapse' => 'cumprimi',
	'categorytree-expand' => 'ippaglia',
	'categorytree-load' => 'carrigga',
	'categorytree-loading' => 'carrigghendi...',
	'categorytree-nothing-found' => 'nisciun risulthaddu',
	'categorytree-no-subcategories' => 'nisciuna sottucateguria.',
	'categorytree-no-pages' => 'nisciuna bozi ni sottucateguria.',
	'categorytree-not-found' => "Categuria ''$1'' nò acciappadda",
	'categorytree-error' => "Probrema i' lu carriggamentu di li dati.",
	'categorytree-retry' => "Pa piazeri aisetta un'àttimu e poi torra a prubà.",
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'categorytree' => 'ප්‍රවර්ග රුක',
	'categorytree-portlet' => 'ප්‍රවර්ග',
	'categorytree-legend' => 'ප්‍රවර්ග රුක පෙන්වන්න',
	'categorytree-desc' => '[[Special:CategoryTree|ප්‍රවර්ග ව්‍යුහය]] ගතික වශයෙන් සංචලනය කරන්න',
	'categorytree-header' => 'එහි අන්තර්ගතයන්  රුක් ව්‍යුවහයක් ලෙස නැරඹීම සඳහා ප්‍රවර්ග නාමයක් ඇතුලත් කරන්න.
AJAX නමින් හැඳින්වෙන ප්‍රගත ජාවාස්ක්‍රිප්ට් ශ්‍රීතියතායව මේ සඳහා අවශ්‍ය බව සටහන් කර ගන්න.
ඔබ සතුව ඇත්තේ ඉතා පැරණි බ්‍රවුසරයක් නම් හෝ ජාවාස්ක්‍රිප්ට් අක්‍රීය කොට තිබේ නම් මෙය ක්‍රි‍යාත්මක නොවනු ඇත.',
	'categorytree-category' => 'ප්‍රවර්ගය:',
	'categorytree-go' => 'රුක පෙන්වන්න',
	'categorytree-parents' => 'මාපියන්',
	'categorytree-mode-categories' => 'ප්‍රවර්ග පමණයි',
	'categorytree-mode-pages' => 'ගොනු හැර ඉතිරි පිටු',
	'categorytree-mode-all' => 'සියළු පිටු',
	'categorytree-collapse' => 'හකුලන්න',
	'categorytree-expand' => 'විදහන්න',
	'categorytree-member-counts' => '{{PLURAL:$1|එක් උපප්‍රවර්ගයක්|උපප්‍රවර්ග $1 ක්}}, {{PLURAL:$2|එක් පිටුවක්|පිටු $2 ක්}}, සහ {{PLURAL:$3|එක් ගොනුවක්|ගොනු $3 ක්}} අඩංගුය',
	'categorytree-load' => 'බාගන්න',
	'categorytree-loading' => 'බාගනිමින්…',
	'categorytree-nothing-found' => 'කිසිවක් හමුනොවිනි',
	'categorytree-no-subcategories' => 'උපප්‍රවර්ග නොමැත',
	'categorytree-no-parent-categories' => 'මාපිය උපප්‍රවර්ග නොමැත',
	'categorytree-no-pages' => 'පිටු හෝ උපප්‍රවර්ග නොමැත',
	'categorytree-not-found' => '<i>$1</i>  ප්‍රවර්ගය සොයාගත නොහැකි විය',
	'categorytree-error' => 'දත්ත බාගැනීමේ ගැටළු පැවතිණි.',
	'categorytree-retry' => 'කරුණාකර බිඳක් සිට යළි උත්සාහ කරන්න.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'categorytree' => 'Strom kategórií',
	'categorytree-portlet' => 'Kategórie',
	'categorytree-legend' => 'Zobraziť strom kategórií',
	'categorytree-desc' => 'AJAXový nástroj na zobrazovanie [[Special:CategoryTree|štruktúry kategórií]] wiki',
	'categorytree-header' => 'Zadajte názov kategórie, ktorej obsah sa má zobraziť ako stromová štruktúra.
Majte na pamäti, že táto funkcia vyžaduje JavaScriptovú funkcionalitu známu ako AJAX.
Ak máte veľmi starý prehliadač alebo máte vypnutý JavaScrpt, nebude fungovať.',
	'categorytree-category' => 'Kategória',
	'categorytree-go' => 'Zobraziť strom',
	'categorytree-parents' => 'Nadradené kategórie',
	'categorytree-mode-categories' => 'iba kategórie',
	'categorytree-mode-pages' => 'stránky okrem obrázkov',
	'categorytree-mode-all' => 'všetky stránky',
	'categorytree-collapse' => 'zbaliť',
	'categorytree-expand' => 'rozbaliť',
	'categorytree-member-counts' => 'obsahuje {{PLURAL:$1|1 podkategóriu|$1 podkategórie|$1 podkategórií}}, {{PLURAL:$2|1 stránku|$2 stránky|$2 stránok}} a {{PLURAL:$3|1 súbor|$3 súbory|$3 súborov}}',
	'categorytree-load' => 'načítať',
	'categorytree-loading' => 'načítava sa',
	'categorytree-nothing-found' => 'nebolo nič nájdené',
	'categorytree-no-subcategories' => 'žiadne podkategórie.',
	'categorytree-no-parent-categories' => 'nemá nadradené kategórie',
	'categorytree-no-pages' => 'žiadne stránky ani podkategórie.',
	'categorytree-not-found' => 'Kategória <i>$1</i> nenájdená',
	'categorytree-error' => 'Problém pri načítavaní údajov.',
	'categorytree-retry' => 'Prosím, chvíľu počkajte a skúste to znova.',
);

/** Slovenian (Slovenščina)
 * @author editors of sl.wikipedia
 */
$messages['sl'] = array(
	'categorytree' => 'Drevo kategorij',
	'categorytree-header' => 'Vnesite ime kategorije, katere vsebino želite videti kot drevesno strukturo. Upoštevajte, da je za to potreben AJAX, poseben nacin za delovanje JavaScripta. Ce je vaš brskalnik zelo star oziroma je JavaScript v njem onemogocen, drevo kategorij ne bo prikazano.',
	'categorytree-category' => 'Kategorija',
	'categorytree-go' => 'Pokaži drevo',
	'categorytree-parents' => 'Starši',
	'categorytree-mode-categories' => 'samo kategorije',
	'categorytree-mode-pages' => 'strani z izjemo slik',
	'categorytree-mode-all' => 'vse strani',
	'categorytree-collapse' => 'skrci',
	'categorytree-expand' => 'razširi',
	'categorytree-load' => 'naloži',
	'categorytree-loading' => 'nalagam',
	'categorytree-nothing-found' => 'ni zadetkov',
	'categorytree-no-subcategories' => 'ni podkategorij',
	'categorytree-no-pages' => 'ni strani ali podkategorij',
	'categorytree-not-found' => 'Kategorije <i>$1</i> ni moc najti',
);

/** Albanian (Shqip)
 * @author Eagleal
 */
$messages['sq'] = array(
	'categorytree' => 'Pema e kategorive',
	'categorytree-header' => 'Fusni emrin e Kategorisë për të parë Nënkategoritë si Pemë kategorish. Këtij funksioni i nevoiten JavaScript dhe AJAX për të funksionuar si duhet. Nëse keni një shfletues të vjetër, ose nëse i keni deaktivuar JavaScript kjo nuk do të funksionoj.',
	'categorytree-category' => 'Kategoria:',
	'categorytree-go' => 'Plotëso',
	'categorytree-parents' => 'Kryekategoritë',
	'categorytree-mode-categories' => 'vetëm kategoritë',
	'categorytree-mode-pages' => 'faqet pa figurat',
	'categorytree-mode-all' => 'të gjitha faqet',
	'categorytree-collapse' => 'mbylle',
	'categorytree-expand' => 'hape',
	'categorytree-load' => 'hape',
	'categorytree-loading' => 'duke plotësuar',
	'categorytree-nothing-found' => 'Ju kërkoj ndjesë, nuk u gjet asgjë.',
	'categorytree-no-subcategories' => 'Asnjë nënkategori.',
	'categorytree-no-pages' => 'Asnjë artikull ose nënkategori.',
	'categorytree-not-found' => 'Kategoria <i>$1</i> nuk u gjet',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Sasa Stefanovic
 * @author Slaven Kosanovic
 */
$messages['sr-ec'] = array(
	'categorytree' => 'Дрво категорија',
	'categorytree-portlet' => 'категорије',
	'categorytree-legend' => 'Прикажи дрво категорија',
	'categorytree-desc' => 'Динамичка навигација [[Special:CategoryTree|структуре категорија]].',
	'categorytree-header' => 'Унесите име категорији чији садржај желите да видите као дрво.
Ово захтева напредну ЈаваСкрип функцију познату као AJAX.
Уколико имате веома стари браузер, или се искључили ЈаваСкрипт, дрво категорија неће радити.',
	'categorytree-category' => 'Категорија:',
	'categorytree-go' => 'Прикажи дрво',
	'categorytree-parents' => 'надређене категорије',
	'categorytree-mode-categories' => 'само категорије',
	'categorytree-mode-pages' => 'странице изузев слика',
	'categorytree-mode-all' => 'све странице',
	'categorytree-collapse' => 'сакриј',
	'categorytree-expand' => 'прикажи',
	'categorytree-member-counts' => 'садржи {{PLURAL:$1|1 поткатегорију|$1 поткатегорија}}, {{PLURAL:$2|1 страницу|$2 страница}}, и {{PLURAL:$3|1 фајл|$3 фајлова}}',
	'categorytree-load' => 'учитај',
	'categorytree-loading' => 'учитавање',
	'categorytree-nothing-found' => 'ништа није пронађено',
	'categorytree-no-subcategories' => 'нема поткатегорија',
	'categorytree-no-parent-categories' => 'без наткатегорије',
	'categorytree-no-pages' => 'нема страница или поткатегорија',
	'categorytree-not-found' => 'Категорија <i>$1</i> није пронађена',
	'categorytree-error' => 'Проблем при учитавању података.',
	'categorytree-retry' => 'Молимо сачекајте тренутак и покушајте поново',
);

/** Southern Sotho (Sesotho) */
$messages['st'] = array(
	'categorytree' => 'Lenane le Mekga',
	'categorytree-category' => 'Mokga:',
	'categorytree-go' => 'Mpontshe lenane',
	'categorytree-mode-categories' => 'mekga feela',
	'categorytree-mode-pages' => 'maqephe ntle le ditshwantsho',
	'categorytree-collapse' => 'Nyenyefatsa',
	'categorytree-expand' => 'Hodisa',
	'categorytree-load' => 'jara',
	'categorytree-loading' => 'le ntse le jarwa',
	'categorytree-nothing-found' => 'Ha ho a fumanwa letho',
	'categorytree-no-subcategories' => 'ntle le mekgana',
	'categorytree-no-pages' => 'ntle le maqephe le mekgana',
	'categorytree-not-found' => 'Mokga wa <i>$1</i> ha o a fumanwa',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'categorytree' => 'Kategorieboom',
	'categorytree-portlet' => 'Kategorien',
	'categorytree-legend' => 'Wies Kategorienboom',
	'categorytree-desc' => 'AJAX-basierd Gadget uum ju [[Special:CategoryTree|Kategorien-Struktuur]] fon n Wiki antouwiesen',
	'categorytree-header' => 'Wiest foar ju anroate Kategorie do Unnerkategorien in n Boomstruktuur.
Disse Siede bruukt bestimde JavaScript-Funktione (AJAX).
In gjucht oolde Browsere, of wan Javascript ouschalted is, funktioniert disse Siede eventuell nit.',
	'categorytree-category' => 'Kategorie:',
	'categorytree-go' => 'Leede',
	'categorytree-parents' => 'Buppekategorien',
	'categorytree-mode-categories' => 'bloot Kategorien',
	'categorytree-mode-pages' => 'Sieden buute Doatäie',
	'categorytree-mode-all' => 'aal Sieden',
	'categorytree-collapse' => 'ienklappe',
	'categorytree-expand' => 'uutklappe',
	'categorytree-member-counts' => 'änthoalt {{PLURAL:$1|1 Unnerkategorie|$1 Unnerkategorien}}, {{PLURAL:$2|1 Siede|$2 Sieden}} un {{PLURAL:$3|1 Doatäi|$3 Doatäie}}',
	'categorytree-load' => 'leede',
	'categorytree-loading' => 'leede ...',
	'categorytree-nothing-found' => 'Niks fuunen',
	'categorytree-no-subcategories' => 'Neen Unnerkategorien',
	'categorytree-no-parent-categories' => 'Neen Buppekategorien',
	'categorytree-no-pages' => 'Neen Sieden of Unnerkategorien',
	'categorytree-not-found' => "Kategorie ''$1'' nit fuunen",
	'categorytree-error' => 'Probleme bie dät Leeden fon do Doaten.',
	'categorytree-retry' => 'Täif ieuwen un fersäik et dan fon näien.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'categorytree' => 'TangkalKategori',
	'categorytree-legend' => 'Témbongkeun tangkal kategori',
	'categorytree-desc' => 'Gajet AJAX pikeun némbongkeun [[Special:CategoryTree|wangun kategori]] dina hiji wiki',
	'categorytree-header' => 'Asupkeun hiji ngaran kategori pikeun nempo eusina dina wangun tangkal.
Perhatikeun yén fitur ieu merlukeun pangrojong Javascript tingkat tuluy anu dipikawanoh minangka AJAX.
Lamun Anjeun ngagunakeun panyungsi nu lila, atawa maehan fungsi Javascript Anjeun, fitur ieu henteu bisa dijalankeun.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Témbongkeun Tangkal',
	'categorytree-parents' => 'Luluhur',
	'categorytree-mode-categories' => 'kategori wungkul',
	'categorytree-mode-pages' => 'kaca iwal gambar',
	'categorytree-mode-all' => 'sadaya kaca',
	'categorytree-collapse' => 'tilep',
	'categorytree-expand' => 'buka',
	'categorytree-load' => 'muatkeun',
	'categorytree-loading' => 'ngamuat',
	'categorytree-nothing-found' => 'teu manggih nanaon',
	'categorytree-no-subcategories' => 'euweuh subkategori',
	'categorytree-no-pages' => 'euweuh kaca atawa subkategori',
	'categorytree-not-found' => 'Kategori <i>$1</i> teu kapanggih',
	'categorytree-error' => 'Aya masalah dina ngamuat data.',
	'categorytree-retry' => 'Dago sakedap, lajeng coba deui.',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 * @author Sannab
 */
$messages['sv'] = array(
	'categorytree' => 'Kategoriträd',
	'categorytree-portlet' => 'Kategorier',
	'categorytree-legend' => 'Visa kategoriträd',
	'categorytree-desc' => 'AJAX-baserat verktyg som visar [[Special:CategoryTree|kategoristrukturen]] på en wiki',
	'categorytree-header' => 'Fyll i ett kategorinamn för att se dess innehåll som en trädstruktur.
Notera att detta kräver stöd för AJAX, en avancerad form av JavaScript.
Därför fungerar funktionen inte i mycket gamla webbläsare eller om JavaScript är avaktiverat.',
	'categorytree-category' => 'Kategori:',
	'categorytree-go' => 'Visa träd',
	'categorytree-parents' => 'Föräldrakategorier',
	'categorytree-mode-categories' => 'visa bara kategorier',
	'categorytree-mode-pages' => 'sidor utom filer',
	'categorytree-mode-all' => 'alla sidor',
	'categorytree-collapse' => 'göm',
	'categorytree-expand' => 'expandera',
	'categorytree-member-counts' => 'innehåller {{PLURAL:$1|1 underkategori|$1 underkategorier}}, {{PLURAL:$2|1 sida|$2 sidor}}, och {{PLURAL:$3|1 fil|$3 filer}}',
	'categorytree-load' => 'ladda',
	'categorytree-loading' => 'laddar',
	'categorytree-nothing-found' => 'hittade inget',
	'categorytree-no-subcategories' => 'inga underkategorier',
	'categorytree-no-parent-categories' => 'inga föräldrakategorier',
	'categorytree-no-pages' => 'inga artiklar eller underkategorier',
	'categorytree-not-found' => "Kategori ''$1'' hittades ej",
	'categorytree-error' => 'Problem med att ladda data.',
	'categorytree-retry' => 'Vänta en stund och försök igen.',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 * @author Muddyb Blast Producer
 */
$messages['sw'] = array(
	'categorytree' => 'Mfumo wa jamii',
	'categorytree-portlet' => 'Jamii',
	'categorytree-legend' => 'Onyesha mfumo wa jamii',
	'categorytree-desc' => 'Chungulia kwenye [[Special:CategoryTree|mfumo wa jamii]]',
	'categorytree-header' => "Ingiza jina la jamii ili kuona yaliyomo kwenye mfumo wa jamii. '''Ilani''': hii itahitaji JavaScript ya kisasa ijulilkanayo kwa jina la AJAX. Endapo utakuwa na ya zamani, au JavaScript yako imezimwa, basi hii hatofanya kazi kabisa.",
	'categorytree-category' => 'Jamii',
	'categorytree-go' => 'Onyesha mfumo',
	'categorytree-parents' => 'Kuu',
	'categorytree-mode-categories' => 'jamii tu',
	'categorytree-mode-pages' => 'kurasa isipokuwa mafaili',
	'categorytree-mode-all' => 'kurasa zote',
	'categorytree-no-subcategories' => 'jamii ndogo zake hakuna',
	'categorytree-no-parent-categories' => 'jamii kuu hakuna',
	'categorytree-no-pages' => 'hakuna kurasa wala jamii ndogo zake',
	'categorytree-not-found' => 'Jamii inayoitwa $1 haikupatikana',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'categorytree' => 'பகுப்பு மரம்',
	'categorytree-category' => 'பகுப்பு:',
	'categorytree-go' => 'மரத்தைக் காட்டு',
	'categorytree-no-subcategories' => 'துணைப்பகுப்புகள் கிடையாது',
	'categorytree-no-pages' => 'பக்கங்களோ அல்லது துணைப்பகுப்புகளோ கிடையாது',
	'categorytree-not-found' => '<i>$1</i> பகுப்பு காணப்படவில்லை',
);

/** Telugu (తెలుగు)
 * @author C.Chandra Kanth Rao
 * @author Mpradeep
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'categorytree' => 'వర్గవృక్షం',
	'categorytree-portlet' => 'వర్గాలు',
	'categorytree-legend' => 'వర్గ వృక్షాన్ని చూపించు',
	'categorytree-desc' => 'వికీ యొక్క [[Special:CategoryTree|వర్గ వృక్షాన్ని]] చూపించడానికి AJAX ఆధారిత పరికరం',
	'categorytree-header' => 'ఒక వర్గంలోని అంశాలను వృక్షం లాగా చూసేందుకు ఆ వర్గం పేరును ఇక్కడ ఇవ్వండి. దీనికోసం AJAX అనే ఆధునిక జావాస్క్రిప్టు నైపుణ్యం కావాలి. మీ బ్రౌజరు బాగా పాతదయినా, లేక దానిలో జావాస్క్రిప్టు అశక్తంగా ఉన్నా ఇది పనిచెయ్యదు.',
	'categorytree-category' => 'వర్గం:',
	'categorytree-go' => 'వృక్షాన్ని చూపించు',
	'categorytree-parents' => 'మాతృవర్గాలు',
	'categorytree-mode-categories' => 'వర్గాలు మాత్రమే',
	'categorytree-mode-pages' => 'ఫైళ్ళను మినహాయించి మిగిలిన పేజీలు',
	'categorytree-mode-all' => 'అన్ని పేజీలు',
	'categorytree-collapse' => 'మూసివేయి',
	'categorytree-expand' => 'విస్తరించు',
	'categorytree-member-counts' => '{{PLURAL:$1|1 ఉపవర్గం|$1 ఉపవర్గాలూ}}, {{PLURAL:$2|1 పేజీ|$2 పేజీలూ}}, మరియు {{PLURAL:$3|1 ఫైలూ|$3 ఫైళ్ళూ}} ఉన్నాయి',
	'categorytree-load' => 'లోడు చెయ్యి',
	'categorytree-loading' => 'లోడవుతూంది',
	'categorytree-nothing-found' => 'ఏమీ లేవు',
	'categorytree-no-subcategories' => 'ఉపవర్గాలు లేవు',
	'categorytree-no-parent-categories' => 'మాతృవర్గం లేదు',
	'categorytree-no-pages' => 'పేజీలు గానీ, ఉపవర్గాలు గానీ లేవు',
	'categorytree-not-found' => '<i>$1</i> అనే వర్గం కనపడలేదు',
	'categorytree-error' => 'డేటా లోడు చెయ్యడంలో లోపం దొర్లింది',
	'categorytree-retry' => 'కాస్త ఆగి మళ్ళీ ప్రయత్నించండి.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'categorytree' => 'Ai-hun kategoria',
	'categorytree-portlet' => 'Kategoria sira',
	'categorytree-category' => 'Kategoria:',
	'categorytree-go' => 'Hatudu ai-hun',
	'categorytree-mode-categories' => "hatudu de'it kategoria",
	'categorytree-mode-all' => 'pájina hotu',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'categorytree' => 'ГурӯҳДарахт',
	'categorytree-portlet' => 'Гурӯҳҳо',
	'categorytree-legend' => 'Намоиши дарахти гурӯҳ',
	'categorytree-desc' => 'Абзоре дар асоси AJAX барои намоиши [[Special:CategoryTree|сохтори гурӯҳи]] вики.',
	'categorytree-header' => 'Номи як гурӯҳро ворид кунед, то мӯҳтавиёти он ба сурати дарахт намоиш ёбад.
Таваҷҷӯҳ кунед, ки ин кор ба қобилиятҳои пешрафтаи ҶаваСкрипт бо номи Аҷакс ниёз дорад.
Агар аз мурургари хеле кӯҳна истифода мекунед ё ҶаваСкриптро ғайрифаъол кардаед, дар ин ҳол он кор нахоҳад кард.',
	'categorytree-category' => 'Гурӯҳ:',
	'categorytree-go' => 'Намоиши дарахт',
	'categorytree-parents' => 'Волидайн',
	'categorytree-mode-categories' => 'Фақат гурӯҳҳо',
	'categorytree-mode-pages' => 'саҳифаҳо ғайр аз аксҳо',
	'categorytree-mode-all' => 'ҳамаи саҳифаҳо',
	'categorytree-collapse' => 'фурукаш',
	'categorytree-expand' => 'густариш',
	'categorytree-load' => 'бор кардан',
	'categorytree-loading' => 'дар ҳоли бор шудан…',
	'categorytree-nothing-found' => 'ҳеҷчиз ёфт нашуд',
	'categorytree-no-subcategories' => 'ҳеҷ зергурӯҳе надорад',
	'categorytree-no-parent-categories' => 'гурӯҳи болотаре нест',
	'categorytree-no-pages' => 'ҳеҷ саҳифае ё зергурӯҳе',
	'categorytree-not-found' => 'Гурӯҳи <i>$1</i> ёфт нашуд',
	'categorytree-error' => 'Ишкол дар дарёфти иттилоот',
	'categorytree-retry' => 'Лутфан чанд лаҳза сабр кунед ва дубора имтиҳон кунед.',
);

/** Thai (ไทย)
 * @author Manop
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'categorytree' => 'หมวดหมู่แบบผังต้นไม้',
	'categorytree-portlet' => 'หมวดหมู่',
	'categorytree-legend' => 'แสดงผังหมวดหมู่',
	'categorytree-desc' => 'สำรวจ[[Special:CategoryTree|โครงสร้างหมวดหมู่]]แบบผังต้นไม้',
	'categorytree-header' => 'ป้อนชื่อหมวดหมู่เพื่อดูเนื้อหาเป็นโครงสร้างผังต้นไม้
การทำงานนี้จำเป็นต้องใช้ความสามารถขั้นสูงของจาวาสคริปต์ที่เรียกว่า เอแจ็กซ์
หากคุณใช้เบราว์เซอร์รุ่นเก่า หรือปิดการใช้งานจาวาสคริปต์ ความสามารถนี้จะไม่ทำงาน',
	'categorytree-category' => 'หมวดหมู่',
	'categorytree-go' => 'โหลด',
	'categorytree-parents' => 'หมวดหมู่ใหญ่',
	'categorytree-mode-categories' => 'แสดงเฉพาะหมวดหมู่',
	'categorytree-mode-pages' => 'หน้าต่างๆ ยกเว้นไฟล์',
	'categorytree-mode-all' => 'หน้าทุกหน้า',
	'categorytree-collapse' => 'ย่อ',
	'categorytree-expand' => 'ขยาย',
	'categorytree-member-counts' => 'มี {{PLURAL:$1|1 หมวดหมู่ย่อย|$1 หมวดหมู่ย่อย}}, {{PLURAL:$2|1 หน้า|$2 หน้า}}, และ {{PLURAL:$3|1 ไฟล์|$3 ไฟล์}}',
	'categorytree-load' => 'โหลด',
	'categorytree-loading' => 'กำลังโหลด...',
	'categorytree-nothing-found' => 'ไม่พบที่ต้องการ',
	'categorytree-no-subcategories' => 'ไม่มีหมวดหมู่ย่อย',
	'categorytree-no-parent-categories' => 'ไม่มีหมวดหมู่ระดับบน',
	'categorytree-no-pages' => 'ไม่มีบทความหรือหมวดหมู่ย่อย',
	'categorytree-not-found' => 'ไม่พบหมวดหมู่ <i>$1</i>',
	'categorytree-error' => 'การโหลดข้อมูลมีปัญหา',
	'categorytree-retry' => 'กรุณารอสักครู่ แล้วลองโหลดใหม่อีกครั้ง',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'categorytree' => 'Puno ng kaurian',
	'categorytree-portlet' => 'Mga kaurian',
	'categorytree-legend' => 'Ipakita ang puno ng kaurian',
	'categorytree-desc' => 'Masiglang libutin ang [[Special:CategoryTree|kayarian ng kaurian]]',
	'categorytree-header' => "Maglagay (magpasok) ng isang pangalan ng kaurian upang makita ang nilalaman nito bilang isang kayarian ng isang puno.
Tandaan na nangangailangan ito ng mas masulong na tungkuling pang-JavaScript na kilala bilang AJAX.
Kapag mayroon kang isang napakatandang/napakalumang pantingin-tingin (''browser''), o hindi pinapagana ang JavaScript, hindi ito magagawa/walang mangyayari.",
	'categorytree-category' => 'Kaurian:',
	'categorytree-go' => 'Ipakita ang puno',
	'categorytree-parents' => 'Mga magulang',
	'categorytree-mode-categories' => 'mga kaurian lamang',
	'categorytree-mode-pages' => 'mga pahina maliban sa mga talaksan',
	'categorytree-mode-all' => 'lahat ng mga pahina',
	'categorytree-collapse' => 'tiklupin',
	'categorytree-expand' => 'palaparin',
	'categorytree-member-counts' => 'naglalaman ng {{PLURAL:$1|1 subcategory|$1 kabahaging mga kaurian}}, {{PLURAL:$2|1 pahina|$2 mga pahina}}, at {{PLURAL:$3|1 talaksan|$3 mga talaksan}}',
	'categorytree-load' => 'ikarga',
	'categorytree-loading' => 'ikinakarga…',
	'categorytree-nothing-found' => 'walang natagpuan',
	'categorytree-no-subcategories' => 'walang kabahaging mga kaurian',
	'categorytree-no-parent-categories' => 'walang magulang (pinagmulan) na mga kaurian',
	'categorytree-no-pages' => 'walang mga pahina o kabahaging mga kaurian/subkaurian (subkategorya)',
	'categorytree-not-found' => 'Hindi natagpuan ang kauriang <i>$1</i>',
	'categorytree-error' => 'May suliranin sa pagkakarga ng dato.',
	'categorytree-retry' => 'Maghintay lamang ng isang sandali at subuking muli.',
);

/** Tonga (faka-Tonga) */
$messages['to'] = array(
	'categorytree' => 'Fuʻuʻakau faʻahinga',
	'categorytree-category' => 'Faʻahinga:',
	'categorytree-go' => 'ʻAsi mai',
	'categorytree-collapse' => 'holo',
	'categorytree-expand' => 'fano',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Mach
 * @author Runningfridgesrule
 */
$messages['tr'] = array(
	'categorytree' => 'Kategori hiyerarşisi',
	'categorytree-portlet' => 'Kategoriler',
	'categorytree-legend' => 'Kategori ağacını göster',
	'categorytree-desc' => '[[Special:CategoryTree|Kategori yapısını]] dinamik olarak idare et',
	'categorytree-header' => 'Kategori ismini girip, içeriğini hiyerarşik şekilde görebilirsiniz. Bu özellik AJAX adıyla bilinen gelişmiş JavaScript ile çalışabilir. Eğer tarayıcınız eski ise ya da JavaScript kullanımı kapalı ise, çalışmaz.',
	'categorytree-category' => 'Kategori',
	'categorytree-go' => 'Yükle',
	'categorytree-parents' => 'Üst kategoriler',
	'categorytree-mode-categories' => 'sadece kategorileri göster',
	'categorytree-mode-pages' => 'dosyalar dışındaki sayfalar',
	'categorytree-mode-all' => 'tüm sayfalar',
	'categorytree-collapse' => 'aç/kapat',
	'categorytree-expand' => 'genişlet',
	'categorytree-member-counts' => '{{PLURAL:$1|1 altkategori|$1 altkategori}}, {{PLURAL:$2|1 sayfa|$2 sayfa}}, ve {{PLURAL:$3|1 dosya|$3 dosya}} içeriyor',
	'categorytree-load' => 'yükle',
	'categorytree-loading' => 'yükleniyor',
	'categorytree-nothing-found' => 'maalesef, sonuç yok',
	'categorytree-no-subcategories' => 'alt kategori yok.',
	'categorytree-no-parent-categories' => 'üst kategori yok',
	'categorytree-no-pages' => 'alt kategori veya madde yok.',
	'categorytree-not-found' => '<i>"$1"</i> isimli kategori bulunamadı',
	'categorytree-error' => 'Bilgi yüklenmesi ile bir problem var.',
	'categorytree-retry' => 'Lütfen kısa süre için bekleyin, sonra bir kere daha deneyin.',
);

/** Tsonga (Xitsonga)
 * @author Thuvack
 */
$messages['ts'] = array(
	'categorytree-portlet' => 'Swiyenge',
	'categorytree-legend' => 'Kombisa swi yenge',
	'categorytree-category' => 'Xiyenge:',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'categorytree' => 'Дерево категорій',
	'categorytree-portlet' => 'Категорії',
	'categorytree-legend' => 'Показати дерево категорій',
	'categorytree-desc' => 'AJAX-компонент для відображення [[Special:CategoryTree|структури категорій]] вікі',
	'categorytree-header' => 'Уведіть назву категорії, і вона буде показана у вигляді дерева.
Ця можливість доступна, тільки якщо ваш браузер підтримує AJAX.
Якщо у вас стара версія браузера або відключений JavaScript, відображення підкатегорій у вигляді дерева недоступне.',
	'categorytree-category' => 'Категорія:',
	'categorytree-go' => 'Показати дерево',
	'categorytree-parents' => 'Батьківські категорії',
	'categorytree-mode-categories' => 'тільки категорії',
	'categorytree-mode-pages' => 'окрім зображень',
	'categorytree-mode-all' => 'усі сторінки',
	'categorytree-collapse' => 'згорнути',
	'categorytree-expand' => 'розгорнути',
	'categorytree-member-counts' => 'містить $1 {{PLURAL:$1|підкатегорію|підкатегорії|підкатегорій}}, $2 {{PLURAL:$2|сторінку|сторінки|сторінок}} та $3 {{PLURAL:$3|файл|файли|файлів}}',
	'categorytree-load' => 'завантажити',
	'categorytree-loading' => 'завантаження…',
	'categorytree-nothing-found' => 'нема підкатегорій',
	'categorytree-no-subcategories' => 'нема підкатегорій',
	'categorytree-no-parent-categories' => 'нема батьківських категорій',
	'categorytree-no-pages' => 'нема статей і підкатегорій',
	'categorytree-not-found' => 'Категорія «$1» не знайдена.',
	'categorytree-error' => 'Помилка завантаження даних.',
	'categorytree-retry' => 'Будь ласка, зачекайте і спробуйте ще раз.',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'categorytree' => 'شجر ِزمرہ',
	'categorytree-category' => 'زمرہ',
	'categorytree-go' => 'بہ ترتیب شجر',
	'categorytree-mode-all' => 'تمام صفحات',
	'categorytree-load' => 'اثقال',
	'categorytree-loading' => 'دوران اثقال',
	'categorytree-nothing-found' => 'کچھ دستیاب نہیں',
	'categorytree-no-subcategories' => 'کوئی ذیلی زمرہ نہیں',
);

/** Uzbek (O'zbek)
 * @author Abdulla
 */
$messages['uz'] = array(
	'categorytree-category' => 'Turkum:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'categorytree' => 'Strutura ad àlbaro de le categorie',
	'categorytree-portlet' => 'Categorie',
	'categorytree-legend' => "Mostra l'àlbaro de le categorie",
	'categorytree-desc' => 'Acessorio AJAX par visualizar la [[Special:CategoryTree|strutura de le categorie]] del sito',
	'categorytree-header' => 'Inserissi el nome de la categoria de cui te vol védar el contenuto soto forma de strutura ad àlbaro. Nota che la pagina la richiede le funzionalità avanzade de JavaScript ciamà AJAX; se te stè doparando un browser vecio assè o le funzion JavaScript le xe disabilità, sta pagina no la funzionarà mìa.',
	'categorytree-category' => 'Categoria',
	'categorytree-go' => "Mostra l'àlbaro",
	'categorytree-parents' => 'Categorie superiori',
	'categorytree-mode-categories' => 'mostra solo le categorie',
	'categorytree-mode-pages' => 'tute le pagine, via de i file',
	'categorytree-mode-all' => 'tute le pagine',
	'categorytree-collapse' => 'conprimi',
	'categorytree-expand' => 'espandi',
	'categorytree-member-counts' => 'la contien {{PLURAL:$1|1 sotocategoria|$1 sotocategorie}}, {{PLURAL:$2|1 pagina|$2 pagine}} e {{PLURAL:$3|1 file|$3 file}}',
	'categorytree-load' => 'carga',
	'categorytree-loading' => 'sto cargando…',
	'categorytree-nothing-found' => 'nissun risultato',
	'categorytree-no-subcategories' => 'nissuna sotocategoria',
	'categorytree-no-parent-categories' => 'nissuna categoria superior',
	'categorytree-no-pages' => 'nissuna voçe né sotocategoria',
	'categorytree-not-found' => 'Categoria <i>$1</i> mìa catà',
	'categorytree-error' => 'Ghe xe un problema nel caricamento dei dati.',
	'categorytree-retry' => "Speta n'atimo e dopo próa de novo.",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'categorytree' => 'Cây thể loại',
	'categorytree-portlet' => 'Thể loại',
	'categorytree-legend' => 'Hiển thị cây thể loại',
	'categorytree-desc' => 'Công cụ AJAX để hiển thị [[Special:CategoryTree|cấu trúc thể loại]] của một wiki',
	'categorytree-header' => 'Gõ vào tên thể loại để xem nội dung của nó theo cấu trúc cây.
Chú ý rằng chức năng này sử dụng chức năng JavaScript, với tên AJAX.
Nếu bạn đang sử dụng trình duyệt rất cũ, hoặc đã tắt JavaScript, nó sẽ không hoạt động.',
	'categorytree-category' => 'Thể loại:',
	'categorytree-go' => 'Hiển thị',
	'categorytree-parents' => 'Các thể loại mẹ',
	'categorytree-mode-categories' => 'Chỉ liệt kê các thể loại',
	'categorytree-mode-pages' => 'các trang ngoại trừ trang tập tin',
	'categorytree-mode-all' => 'tất cả các trang',
	'categorytree-collapse' => 'đóng',
	'categorytree-expand' => 'mở',
	'categorytree-member-counts' => 'có $1 tiểu thể loại, $2 trang, và $3 tập tin',
	'categorytree-load' => 'tải',
	'categorytree-loading' => 'đang tải',
	'categorytree-nothing-found' => 'Không có gì.',
	'categorytree-no-subcategories' => 'Không có tiểu thể loại.',
	'categorytree-no-parent-categories' => 'không nằm trong thể loại nào',
	'categorytree-no-pages' => 'Không có trang hay tiểu thể loại.',
	'categorytree-not-found' => 'Không tìm thấy thể loại <i>$1</i>',
	'categorytree-error' => 'Có vấn đề khi tải dữ liệu.',
	'categorytree-retry' => 'Xin hãy chờ một chút rồi thử lại.',
);

/** West-Vlams (West-Vlams) */
$messages['vls'] = array(
	'categorytree-collapse' => 'toesmytn',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'categorytree' => 'KladaBim',
	'categorytree-portlet' => 'Klads',
	'categorytree-legend' => 'Jonolöd kladabimi',
	'categorytree-desc' => 'Jonön [[Special:CategoryTree|kladabimi]] e mufön ve on.',
	'categorytree-header' => 'Penolös kladanemi ad logön ninädi klada as bimabinod. Küpälolös, das atos flagon dili ela JavaScript labü nem: AJAX. No oplöpon if labol bevüresodanafömi vönädik, ud if enemogüköl eli JavaScript.',
	'categorytree-category' => 'Klad:',
	'categorytree-go' => 'Jonolöd Bimi',
	'categorytree-parents' => 'Pals',
	'categorytree-mode-categories' => 'te klads',
	'categorytree-mode-pages' => 'pads pläamü ragivs',
	'categorytree-mode-all' => 'pads valik',
	'categorytree-collapse' => 'brefükön',
	'categorytree-expand' => 'stäänükön',
	'categorytree-member-counts' => 'ninädon {{PLURAL:$1|donakladi 1|donakladis $1}}, {{PLURAL:$2|padi 1|padis $2}} e {{PLURAL:$3|ragivi 1|ragivis $3}}',
	'categorytree-load' => 'lodön',
	'categorytree-loading' => 'lodam',
	'categorytree-nothing-found' => 'nos petuvon',
	'categorytree-no-subcategories' => 'donaklads nonik',
	'categorytree-no-parent-categories' => 'palaklads nonik',
	'categorytree-no-pages' => 'pads e donaklads noniks',
	'categorytree-not-found' => 'Klad: <i>$1</i> no petuvöl',
	'categorytree-error' => 'No eplöpos ad lodön nünis.',
	'categorytree-retry' => 'Stebedolös, begö! timüli e steifülolös dönu.',
);

/** Wu (吴语)
 * @author Wtzdj
 */
$messages['wuu'] = array(
	'categorytree' => '分类树',
	'categorytree-category' => '分类',
	'categorytree-go' => '显示树形',
	'categorytree-mode-categories' => '仅分类',
	'categorytree-mode-pages' => '除脱图片以外个页面',
	'categorytree-mode-all' => '所有页面',
	'categorytree-collapse' => '抈出来',
	'categorytree-expand' => '放开来',
	'categorytree-nothing-found' => '一样也朆寻着',
	'categorytree-no-subcategories' => '呒拨子分类',
	'categorytree-no-pages' => '呒拨页面或者子分类',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'categorytree' => 'קאַטעגאריע בוים',
	'categorytree-portlet' => 'קאַטעגאריעס',
	'categorytree-legend' => 'ווײַזן קאַטעגאריע בוים',
	'categorytree-category' => 'קאטעגאריע:',
	'categorytree-go' => 'ווײַזן בוים',
	'categorytree-parents' => 'העכערע קאַטעגאריעס',
	'categorytree-mode-categories' => 'נאר קאַטעגאריעס',
	'categorytree-mode-pages' => 'בלעטער וואס זענען נישט טעקעס',
	'categorytree-mode-all' => 'אַלע בלעטער',
	'categorytree-collapse' => 'אײַנציען',
	'categorytree-expand' => 'פֿאַרברייטערן',
	'categorytree-nothing-found' => 'גארנישט געפֿונען',
	'categorytree-no-subcategories' => 'נישטא קיין אונטער-קאַטעגאריעס',
	'categorytree-no-pages' => 'נישטא קיין בלעטער אדער אונטער-קאַטעגאריעס',
	'categorytree-not-found' => "קאַטעגאריע '''$1''' נישט געפֿונען",
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'categorytree' => '分類樹',
	'categorytree-portlet' => '分類',
	'categorytree-legend' => '顯示分類樹',
	'categorytree-desc' => '一個以AJAX為主嘅小工具去顯示響一個wiki嘅[[Special:CategoryTree|分類架構]]',
	'categorytree-header' => '輸入分類名去睇佢嘅樹形結構內容。
請留意呢個係需要進階嘅JavaScript功能叫做AJAX。
如果你係有一個好舊嘅瀏覽器，又或者停用咗JavaScript，咁就會用唔到。',
	'categorytree-category' => '分類',
	'categorytree-go' => '載入',
	'categorytree-parents' => '父分類',
	'categorytree-mode-categories' => '只顯示分類',
	'categorytree-mode-pages' => '除咗圖像之外嘅版',
	'categorytree-mode-all' => '全版',
	'categorytree-collapse' => '收埋',
	'categorytree-expand' => '打開',
	'categorytree-member-counts' => '有$1個細分類、$2版同$3個檔案',
	'categorytree-load' => '載入',
	'categorytree-loading' => '載入緊…',
	'categorytree-nothing-found' => '搵唔到任何嘢',
	'categorytree-no-subcategories' => '冇細分類',
	'categorytree-no-parent-categories' => '冇父分類',
	'categorytree-no-pages' => '冇版或者細分類',
	'categorytree-not-found' => '搵唔到<i>$1</i>分類',
	'categorytree-error' => '載入資料嗰陣發生咗錯誤。',
	'categorytree-retry' => '請等多一陣再試過。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'categorytree' => '分类树',
	'categorytree-portlet' => '分类',
	'categorytree-legend' => '显示分类树',
	'categorytree-desc' => '以AJAX技术显示[[Special:CategoryTree|分类结构]]',
	'categorytree-header' => '在此可以查询以分类的树形结构。
注意： 本特殊页面使用AJAX技术。
如果您的浏览器非常老旧，或者是关闭了JavaScript，本页面将会无法正常运作。',
	'categorytree-category' => '分类',
	'categorytree-go' => '显示树形结构',
	'categorytree-parents' => '上级分类',
	'categorytree-mode-categories' => '只显示分类',
	'categorytree-mode-pages' => '除去图像页面',
	'categorytree-mode-all' => '所有页面',
	'categorytree-collapse' => '折叠',
	'categorytree-expand' => '展开',
	'categorytree-member-counts' => '含有$1个子分类、$2个页面和$3个文件',
	'categorytree-load' => '装载',
	'categorytree-loading' => '装载中…',
	'categorytree-nothing-found' => '搜索结果为空',
	'categorytree-no-subcategories' => '没有子分类',
	'categorytree-no-parent-categories' => '没有父分类',
	'categorytree-no-pages' => '没有文章或是子分类。',
	'categorytree-not-found' => '找不到分类<i>$1</i>',
	'categorytree-error' => '载入数据时发生错误。',
	'categorytree-retry' => '请稍候一会，然后再试。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'categorytree' => '分類樹',
	'categorytree-portlet' => '分類',
	'categorytree-legend' => '顯示分類樹',
	'categorytree-desc' => '以AJAX技術顯示[[Special:CategoryTree|分類結構]]',
	'categorytree-header' => '在此可以查詢以分類的樹狀結構。
注意： 本特殊頁面使用AJAX技術。
如果您的瀏覽器非常老舊，或者是關閉了JavaScript，本頁面將會無法正常運作。',
	'categorytree-category' => '分類',
	'categorytree-go' => '顯示樹狀結構',
	'categorytree-parents' => '父分類',
	'categorytree-mode-categories' => '只顯示分類',
	'categorytree-mode-pages' => '除去圖像頁面',
	'categorytree-mode-all' => '所有頁面',
	'categorytree-collapse' => '摺疊',
	'categorytree-expand' => '展開',
	'categorytree-member-counts' => '含有$1個子分類、$2個頁面和$3個檔案',
	'categorytree-load' => '載入',
	'categorytree-loading' => '載入中…',
	'categorytree-nothing-found' => '找不到任何項目',
	'categorytree-no-subcategories' => '沒有子分類',
	'categorytree-no-parent-categories' => '沒有父分類',
	'categorytree-no-pages' => '沒有頁面或子分類',
	'categorytree-not-found' => '找不到分類<i>$1</i>',
	'categorytree-error' => '載入資料時發生錯誤。',
	'categorytree-retry' => '請稍候一會，然後再試。',
);

/** Zulu (isiZulu) */
$messages['zu'] = array(
	'categorytree-collapse' => 'Nciphisa',
	'categorytree-expand' => 'Khulisa',
);

