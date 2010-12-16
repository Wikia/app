<?php
/**
 * Internationalisation file for extension ProofreadPage
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'indexpages'                      => 'List of index pages',
	'proofreadpage_desc'              => 'Allow easy comparison of text to the original scan',
	'proofreadpage_namespace'         => 'Page',
	'proofreadpage_index_namespace'   => 'Index',
	'proofreadpage_image'             => 'image',
	'proofreadpage_index'             => 'Index',
	'proofreadpage_index_expected'    => 'Error: index expected',
	'proofreadpage_nosuch_index'      => 'Error: no such index',
	'proofreadpage_nosuch_file'       => 'Error: no such file',
	'proofreadpage_badpage'           => 'Wrong Format',
	'proofreadpage_badpagetext'       => 'The format of the page you attempted to save is incorrect.',
	'proofreadpage_indexdupe'         => 'Duplicate link',
	'proofreadpage_indexdupetext'     => 'Pages cannot be listed more than once on an index page.',
	'proofreadpage_nologin'           => 'Not logged in',
	'proofreadpage_nologintext'       => 'You must be [[Special:UserLogin|logged in]] to modify the proofreading status of pages.',
	'proofreadpage_notallowed'        => 'Change not allowed',
	'proofreadpage_notallowedtext'    => 'You are not allowed to change the proofreading status of this page.',
	'proofreadpage_number_expected'   => 'Error: numeric value expected',
	'proofreadpage_interval_too_large'=> 'Error: interval too large',
	'proofreadpage_invalid_interval'  => 'Error: invalid interval',
	'proofreadpage_nextpage'          => 'Next page',
	'proofreadpage_prevpage'          => 'Previous page',
	'proofreadpage_header'            => 'Header (noinclude):',
	'proofreadpage_body'              => 'Page body (to be transcluded):',
	'proofreadpage_footer'            => 'Footer (noinclude):',
	'proofreadpage_toggleheaders'     => 'toggle noinclude sections visibility',
	'proofreadpage_quality0_category' => 'Without text',
	'proofreadpage_quality1_category' => 'Not proofread',
	'proofreadpage_quality2_category' => 'Problematic',
	'proofreadpage_quality3_category' => 'Proofread',
	'proofreadpage_quality4_category' => 'Validated',
	'proofreadpage_quality0_message'  => 'This page does not need to be proofread',
	'proofreadpage_quality1_message'  => 'This page has not been proofread',
	'proofreadpage_quality2_message'  => 'There was a problem when proofreading this page',
	'proofreadpage_quality3_message'  => 'This page has been proofread',
	'proofreadpage_quality4_message'  => 'This page has been validated',
	'proofreadpage_index_listofpages' => 'List of pages',
	'proofreadpage_image_message'     => 'Link to the index page',
	'proofreadpage_page_status'       => 'Page status',
	'proofreadpage_js_attributes'     => 'Author Title Year Publisher',
	'proofreadpage_index_attributes'  => 'Author
Title
Year|Year of publication
Publisher
Source
Image|Cover image
Pages||20
Remarks||10',
	'proofreadpage_default_header'        => '<div class="pagetext">',
	'proofreadpage_default_footer'        => '<references/></div>',
	'proofreadpage_quality_message'       => "<table style=\"line-height:40%;\" border=0 cellpadding=0 cellspacing=0 ><tr>
<td align=center >&nbsp;</td>
<td align=center class='quality4' width=\"$5\"></td>
<td align=center class='quality3' width=\"$4\"></td>
<td align=center class='quality2' width=\"$3\"></td>
<td align=center class='quality1' width=\"$2\"></td>
<td align=center class='quality0' width=\"$1\"></td>
<td ><span id=pr_index style=\"visibility:hidden;\">$7</span></td>
</tr></table>",
	'proofreadpage_pages'        => "{{PLURAL:$1|page|pages}}",
	'proofreadpage_specialpage_text'       => '',
	'proofreadpage_specialpage_legend'     => 'Search index pages',
	'proofreadpage_source'         => 'Source',
	'proofreadpage_source_message' => 'Scanned edition used to establish this text',
);

/** Message documentation (Message documentation)
 * @author Aleator
 * @author EugeneZelenko
 * @author IAlex
 * @author Jon Harald Søby
 * @author McDutchie
 * @author Mormegil
 * @author Purodha
 * @author Siebrand
 * @author Yknok29
 */
$messages['qqq'] = array(
	'indexpages' => 'Title of [[Special:IndexPages]]',
	'proofreadpage_desc' => 'Short description of the Proofreadpage extension, shown in [[Special:Version]]. Do not translate or change links.',
	'proofreadpage_namespace' => '{{Identical|Page}}',
	'proofreadpage_index_namespace' => '{{Identical|Index}}',
	'proofreadpage_image' => '{{Identical|Image}}',
	'proofreadpage_index' => '{{Identical|Index}}',
	'proofreadpage_indexdupe' => 'Meaning: "This is a duplicate link"',
	'proofreadpage_notallowed' => '"Making a change is not allowed" would be the verbose way to paraphrase the message.',
	'proofreadpage_nextpage' => '{{Identical|Next page}}',
	'proofreadpage_prevpage' => '{{Identical|Previous page}}',
	'proofreadpage_toggleheaders' => 'Tooltip at right "+" button, at Wikisources, at namespace "Page".',
	'proofreadpage_quality0_category' => '{{Identical|Empty}}',
	'proofreadpage_js_attributes' => 'Names of the variables on index pages, separated by spaces.',
	'proofreadpage_source' => '{{Identical|Source}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'indexpages' => 'Lys van indeks-bladsye',
	'proofreadpage_desc' => 'Maak dit moontlik om teks maklik met die oorspronklike skandering te vergelyk',
	'proofreadpage_namespace' => 'Bladsye',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'beeld',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Fout: indeks verwag',
	'proofreadpage_nosuch_index' => 'Fout: die indeks bestaan nie',
	'proofreadpage_nosuch_file' => 'Fout: die lêer bestaan nie',
	'proofreadpage_badpage' => 'Verkeerde formaat',
	'proofreadpage_badpagetext' => 'Die formaat van die bladsy wat u probeer stoor is verkeerd.',
	'proofreadpage_indexdupe' => 'Dubbele skakel',
	'proofreadpage_indexdupetext' => "Bladsye kan nie meer as een keer op 'n indeksbladsy gelys word nie.",
	'proofreadpage_nologin' => 'Nie aangeteken nie',
	'proofreadpage_nologintext' => 'U moet [[Special:UserLogin|aanteken]] om die proeflees-status van bladsye te kan wysig.',
	'proofreadpage_notallowed' => 'Wysiging is nie toegelaat nie',
	'proofreadpage_notallowedtext' => 'U mag nie die proeflees-status van hierdie bladsy wysig nie.',
	'proofreadpage_number_expected' => 'Fout: numeriese waarde verwag',
	'proofreadpage_interval_too_large' => 'Fout: die interval is te groot',
	'proofreadpage_invalid_interval' => 'Fout: die interval is ongeldig',
	'proofreadpage_nextpage' => 'Volgende bladsy',
	'proofreadpage_prevpage' => 'Vorige bladsy',
	'proofreadpage_header' => 'Opskrif (geen inklusie):',
	'proofreadpage_body' => 'Bladsyteks (vir transklusie):',
	'proofreadpage_footer' => 'Voetteks (geen inklusie):',
	'proofreadpage_toggleheaders' => 'wysig sigbaarheid van afdelings sonder transklusie',
	'proofreadpage_quality0_category' => 'Geen teks nie',
	'proofreadpage_quality1_category' => 'Nie geproeflees nie',
	'proofreadpage_quality2_category' => 'Onvolledig',
	'proofreadpage_quality3_category' => 'Proeflees',
	'proofreadpage_quality4_category' => 'Gekontroleer',
	'proofreadpage_quality0_message' => 'Hierdie bladsy hoef nie geproeflees te word nie',
	'proofreadpage_quality1_message' => 'Hierdie bladsy is nie geproeflees nie',
	'proofreadpage_quality2_message' => "Daar was 'n probleem tydens die proeflees van hierdie bladsy",
	'proofreadpage_quality3_message' => 'Hierdie bladsy is geproeflees',
	'proofreadpage_quality4_message' => 'Hierdie bladsy is gekontroleer',
	'proofreadpage_index_listofpages' => 'Lys van bladsye',
	'proofreadpage_image_message' => 'Skakel na die indeksblad',
	'proofreadpage_page_status' => 'Bladsystatus',
	'proofreadpage_js_attributes' => 'Outeur Titel Jaar Uitgewer',
	'proofreadpage_index_attributes' => 'Outeur
Titel
Jaar|Jaar van publikasie
Uitgewer
Bron
Beeld|Omslag
Bladsye||20
Opmerkings||10',
	'proofreadpage_pages' => '{{PLURAL:$1|bladsy|bladsye}}',
	'proofreadpage_specialpage_legend' => 'Deursoek indeks-bladsye',
	'proofreadpage_source' => 'Bron',
	'proofreadpage_source_message' => 'Geskandeerde uitgawe waarop hierdie teks gebaseer is',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'proofreadpage_nextpage' => 'የሚቀጥለው ገጽ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'proofreadpage_desc' => 'Premite contimparar de trazas simples o testo con o escaneyo orichinal',
	'proofreadpage_namespace' => 'Pachina',
	'proofreadpage_index_namespace' => 'Endize',
	'proofreadpage_image' => 'Imachen',
	'proofreadpage_index' => 'Endize',
	'proofreadpage_nextpage' => 'Pachina siguient',
	'proofreadpage_prevpage' => 'Pachina anterior',
	'proofreadpage_header' => 'Cabezera (noinclude):',
	'proofreadpage_body' => "Cuerpo d'a pachina (to be transcluded):",
	'proofreadpage_footer' => 'Piet de pachina (noinclude):',
	'proofreadpage_toggleheaders' => "cambiar a bisibilidat d'as sezions noinclude",
	'proofreadpage_quality1_category' => 'Pachina no correchita',
	'proofreadpage_quality2_category' => 'Pachina problematica',
	'proofreadpage_quality3_category' => 'Pachina correchita',
	'proofreadpage_quality4_category' => 'Pachina balidata',
	'proofreadpage_index_listofpages' => 'Lista de pachinas',
	'proofreadpage_image_message' => "Binclo t'a pachina d'endize",
	'proofreadpage_page_status' => "Estau d'a pachina",
	'proofreadpage_js_attributes' => 'Autor Títol Año Editorial',
	'proofreadpage_index_attributes' => 'Autor
Títol
Año|Año de publicazión
Editorial
Fuent
Imachen|Imachen de portalada
Pachinas||20
Notas||10',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Orango
 * @author OsamaK
 */
$messages['ar'] = array(
	'indexpages' => 'قائمة صفحات الفهرس',
	'proofreadpage_desc' => 'يسمح بمقارنة سهلة للنص مع المسح الأصلي',
	'proofreadpage_namespace' => 'صفحة',
	'proofreadpage_index_namespace' => 'فهرس',
	'proofreadpage_image' => 'صورة',
	'proofreadpage_index' => 'فهرس',
	'proofreadpage_index_expected' => 'خطأ: فهرس تم توقعه',
	'proofreadpage_nosuch_index' => 'خطأ: لا فهرس كهذا',
	'proofreadpage_nosuch_file' => 'خطأ: لا ملف كهذا',
	'proofreadpage_badpage' => 'تنسيق خاطئ',
	'proofreadpage_badpagetext' => 'تنسيق الصفحة التي تحاول حفظها غير صحيح.',
	'proofreadpage_indexdupe' => 'رابط نظير',
	'proofreadpage_indexdupetext' => 'لا يمكن سرد الصفحة أكثر من في صفحة الفهرس.',
	'proofreadpage_nologin' => 'غير مسجل الدخول',
	'proofreadpage_nologintext' => 'يجب أن تكون [[Special:UserLogin|مُسجلًا الدخول]] لتعدّل حالة تدقيق الصفحات.',
	'proofreadpage_notallowed' => 'التغيير غير مسموح به',
	'proofreadpage_notallowedtext' => 'لا يسمح لك بتغيير حالة تدقيق هذه الصفحة.',
	'proofreadpage_number_expected' => 'خطأ: قيمة عددية تم توقعها',
	'proofreadpage_interval_too_large' => 'خطأ: الفترة كبيرة جدا',
	'proofreadpage_invalid_interval' => 'خطأ: فترة غير صحيحة',
	'proofreadpage_nextpage' => 'الصفحة التالية',
	'proofreadpage_prevpage' => 'الصفحة السابقة',
	'proofreadpage_header' => 'العنوان (غير مضمن):',
	'proofreadpage_body' => 'جسم الصفحة (للتضمين):',
	'proofreadpage_footer' => 'ذيل (غير مضمن):',
	'proofreadpage_toggleheaders' => 'تغيير رؤية أقسام noinclude',
	'proofreadpage_quality0_category' => 'بدون نص',
	'proofreadpage_quality1_category' => 'ليست مُدقّقة',
	'proofreadpage_quality2_category' => 'به مشاكل',
	'proofreadpage_quality3_category' => 'مُدقّقة',
	'proofreadpage_quality4_category' => 'مُصحّحة',
	'proofreadpage_quality0_message' => 'لا تحتاج هذه الصفحة إلى تدقيق',
	'proofreadpage_quality1_message' => 'لم تدقّق هذه الصفحة',
	'proofreadpage_quality2_message' => 'ثمة مشكلة عند تدقيق هذه الصفحة',
	'proofreadpage_quality3_message' => 'دُقّقت هذه الصفحة',
	'proofreadpage_quality4_message' => 'صُحّحت هذه الصفحة',
	'proofreadpage_index_listofpages' => 'قائمة الصفحات',
	'proofreadpage_image_message' => 'وصلة إلى صفحة الفهرس',
	'proofreadpage_page_status' => 'حالة الصفحة',
	'proofreadpage_js_attributes' => 'المؤلف العنوان السنة الناشر',
	'proofreadpage_index_attributes' => 'المؤلف
العنوان
السنة|سنة النشر
الناشر
المصدر
الصورة|صورة الغلاف
الصفحات||20
الملاحظات||10',
	'proofreadpage_pages' => '{{PLURAL:$1|صفحة|صفحات}}',
	'proofreadpage_specialpage_legend' => 'بحث صفحات الفهرس',
	'proofreadpage_source' => 'المصدر',
	'proofreadpage_source_message' => 'الإصدارة المفحوصة المستخدمة لإنشاء هذا النص',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'proofreadpage_namespace' => 'ܦܐܬܐ',
	'proofreadpage_image' => 'ܨܘܪܬܐ',
	'proofreadpage_indexdupe' => 'ܐܣܘܪܐ ܥܦܝܦܐ',
	'proofreadpage_nologin' => 'ܠܐ ܥܠܝܠܐ',
);

/** Araucanian (Mapudungun)
 * @author Remember the dot
 */
$messages['arn'] = array(
	'proofreadpage_namespace' => 'Pakina',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'proofreadpage_desc' => 'بيسمح بمقارنة سهلة للنص مع المسح الأصلي',
	'proofreadpage_namespace' => 'صفحه',
	'proofreadpage_index_namespace' => 'فهرس',
	'proofreadpage_image' => 'صوره',
	'proofreadpage_index' => 'فهرس',
	'proofreadpage_nextpage' => 'الصفحة الجاية',
	'proofreadpage_prevpage' => 'الصفحة اللى فاتت',
	'proofreadpage_header' => 'الراس(مش متضمن):',
	'proofreadpage_body' => 'جسم الصفحة (للتضمين):',
	'proofreadpage_footer' => 'ديل(مش متضمن):',
	'proofreadpage_toggleheaders' => 'تغيير رؤية أقسام noinclude',
	'proofreadpage_quality1_category' => 'مش مثبت قراية',
	'proofreadpage_quality2_category' => 'بيعمل مشاكل',
	'proofreadpage_quality3_category' => 'مثبت قراية',
	'proofreadpage_quality4_category' => 'متصحح',
	'proofreadpage_index_listofpages' => 'لستة الصفحات',
	'proofreadpage_image_message' => 'لينك لصفحة الفهرس',
	'proofreadpage_page_status' => 'حالة الصفحة',
	'proofreadpage_js_attributes' => 'المؤلف العنوان السنة الناشر',
	'proofreadpage_index_attributes' => 'المؤلف
العنوان
السنة|سنة النشر
الناشر
المصدر
الصورة|صورة الغلاف
الصفحات||20
الملاحظات||10',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'proofreadpage_desc' => 'Permite una comparanza cenciella del testu col escaniáu orixinal',
	'proofreadpage_namespace' => 'Páxina',
	'proofreadpage_index_namespace' => 'Índiz',
	'proofreadpage_image' => 'imaxe',
	'proofreadpage_index' => 'Índiz',
	'proofreadpage_nextpage' => 'Páxina siguiente',
	'proofreadpage_prevpage' => 'Páxina anterior',
	'proofreadpage_header' => 'Cabecera (noinclude):',
	'proofreadpage_body' => 'Cuerpu de la páxina (pa trescluyir):',
	'proofreadpage_footer' => 'Pie de páxina (noinclude):',
	'proofreadpage_toggleheaders' => 'activar/desactivar la visibilidá de les seiciones noinclude',
	'proofreadpage_quality1_category' => 'Non correxida',
	'proofreadpage_quality2_category' => 'Problemática',
	'proofreadpage_quality3_category' => 'Correxida',
	'proofreadpage_quality4_category' => 'Validada',
	'proofreadpage_index_listofpages' => 'Llista de páxines',
	'proofreadpage_image_message' => 'Enllaciar a la páxina índiz',
	'proofreadpage_page_status' => 'Estatus de la páxina',
	'proofreadpage_js_attributes' => 'Autor Títulu Añu Editor',
	'proofreadpage_index_attributes' => 'Autor
Títulu
Añu|Añu de publicación
Editor
Fonte
Imaxe|Imaxe de la cubierta
Páxines||20
Comentarios||10',
);

/** Kotava (Kotava)
 * @author Sab
 */
$messages['avk'] = array(
	'proofreadpage_namespace' => 'Bu',
	'proofreadpage_image' => 'ewava',
	'proofreadpage_nextpage' => 'Radimebu',
	'proofreadpage_prevpage' => 'Abduebu',
	'proofreadpage_header' => 'Kroj (noinclude) :',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'proofreadpage_desc' => 'اجازه دن مقایسه متن گون اصلی اسکن',
	'proofreadpage_namespace' => 'صفحه',
	'proofreadpage_index_namespace' => 'ایندکس',
	'proofreadpage_image' => 'عکس',
	'proofreadpage_index' => 'ایندکس',
	'proofreadpage_nextpage' => 'صفحه بعدی',
	'proofreadpage_prevpage' => 'پیشگین صفحه',
	'proofreadpage_header' => 'سرتاک(شامل نه):',
	'proofreadpage_body' => 'بدنه صفحه (به ):',
	'proofreadpage_footer' => 'جهل نوشت (شامل نه):',
	'proofreadpage_toggleheaders' => 'عوض کن ظاهربیگ بخشانی که هور نهنت',
	'proofreadpage_quality1_category' => 'آزمایش نه بیتت',
	'proofreadpage_quality2_category' => 'مشکل دار',
	'proofreadpage_quality3_category' => 'آماده آزمایش',
	'proofreadpage_quality4_category' => 'معتبر',
	'proofreadpage_index_listofpages' => 'لیست صفحات',
	'proofreadpage_image_message' => 'لینک په صفحه اول',
	'proofreadpage_page_status' => 'وضعیت صفحه',
	'proofreadpage_js_attributes' => 'نویسوک عنوان سال ناشر کنوک',
	'proofreadpage_index_attributes' => 'نویسوک
عنوان
سال|سال انتشار
نشار
منبع
عکس|عکس پوش
صفحات||20
نشانان||',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'proofreadpage_namespace' => 'Pahina',
	'proofreadpage_index_namespace' => 'Indeks',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'indexpages' => 'Сьпіс індэксных старонак',
	'proofreadpage_desc' => 'Дазваляе ў зручным выглядзе параўноўваць тэкст і адсканаваны арыгінал',
	'proofreadpage_namespace' => 'Старонка',
	'proofreadpage_index_namespace' => 'Індэкс',
	'proofreadpage_image' => 'выява',
	'proofreadpage_index' => 'Індэкс',
	'proofreadpage_index_expected' => 'Памылка: чакаецца індэкс',
	'proofreadpage_nosuch_index' => 'Памылка: няма такога індэксу',
	'proofreadpage_nosuch_file' => 'Памылка: няма такога файла',
	'proofreadpage_badpage' => 'Няслушны фармат',
	'proofreadpage_badpagetext' => 'Няслушны фармат старонкі, якую Вы спрабуеце захаваць.',
	'proofreadpage_indexdupe' => 'Спасылка-дублікат',
	'proofreadpage_indexdupetext' => 'Старонкі ня могуць быць ў сьпісе на індэкснай старонцы болей аднаго разу.',
	'proofreadpage_nologin' => 'Вы не ўвайшлі ў сыстэму',
	'proofreadpage_nologintext' => 'Вы павінны [[Special:UserLogin|ўвайсьці ў сыстэму]], каб зьмяняць статус праверкі старонкі.',
	'proofreadpage_notallowed' => 'Зьмена не дазволеная',
	'proofreadpage_notallowedtext' => 'Вам не дазволена зьмяняць статус праверкі гэтай старонкі.',
	'proofreadpage_number_expected' => 'Памылка: чакаецца лічбавае значэньне',
	'proofreadpage_interval_too_large' => 'Памылка: занадта вялікі інтэрвал',
	'proofreadpage_invalid_interval' => 'Памылка: няслушны інтэрвал',
	'proofreadpage_nextpage' => 'Наступная старонка',
	'proofreadpage_prevpage' => 'Папярэдняя старонка',
	'proofreadpage_header' => 'Загаловак (не ўключаецца):',
	'proofreadpage_body' => 'Зьмест старонкі (уключаецца):',
	'proofreadpage_footer' => 'Ніжні калянтытул (не ўключаецца):',
	'proofreadpage_toggleheaders' => 'зьмяніць бачнасьць ня ўключаных сэкцыяў',
	'proofreadpage_quality0_category' => 'Бяз тэксту',
	'proofreadpage_quality1_category' => 'Не правераная',
	'proofreadpage_quality2_category' => 'Праблематычная',
	'proofreadpage_quality3_category' => 'Вычытаная',
	'proofreadpage_quality4_category' => 'Правераная',
	'proofreadpage_quality0_message' => 'Гэта старонка не патрабуе вычыткі',
	'proofreadpage_quality1_message' => 'Гэта старонка не была вычытаная',
	'proofreadpage_quality2_message' => 'Узьнікла праблема ў вычытцы гэтай старонкі',
	'proofreadpage_quality3_message' => 'Гэта старонка была вычытаная',
	'proofreadpage_quality4_message' => 'Гэта старонка была правераная',
	'proofreadpage_index_listofpages' => 'Сьпіс старонак',
	'proofreadpage_image_message' => 'Спасылка на старонку індэксу',
	'proofreadpage_page_status' => 'Статус старонкі',
	'proofreadpage_js_attributes' => 'Аўтар Назва Год Выдавецтва',
	'proofreadpage_index_attributes' => 'Аўтар
Назва
Год|Год выданьня
Выдавецтва
Крыніца
Выява|Выява вокладкі
Старонак||20
Заўвагаў||10',
	'proofreadpage_pages' => '{{PLURAL:$1|старонка|старонкі|старонак}}',
	'proofreadpage_specialpage_legend' => 'Пошук індэксных старонак',
	'proofreadpage_source' => 'Крыніца',
	'proofreadpage_source_message' => 'Сканаваная вэрсія, якая выкарыстоўвалася для стварэньня гэтага тэксту',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'indexpages' => 'Списък на индексните страници',
	'proofreadpage_desc' => 'Позволява лесно сравнение на текст с оригинален сканиран документ',
	'proofreadpage_namespace' => 'Страница',
	'proofreadpage_index_namespace' => 'Показалец',
	'proofreadpage_image' => 'картинка',
	'proofreadpage_index' => 'Показалец',
	'proofreadpage_index_expected' => 'Грешка: очаква се индекс',
	'proofreadpage_nosuch_index' => 'Грешка: няма такъв индекс',
	'proofreadpage_nosuch_file' => 'Грешка: няма такъв файл',
	'proofreadpage_badpage' => 'Неправилен формат',
	'proofreadpage_badpagetext' => 'Форматът на страницата, която опитвате да запазите, е неправилен.',
	'proofreadpage_indexdupetext' => 'Страниците не могат да се изписват повече от веднъж на индексната страница.',
	'proofreadpage_nologin' => 'Не сте влезли',
	'proofreadpage_notallowed' => 'Промяната не е позволена',
	'proofreadpage_number_expected' => 'Грешка: очаква се цифрова стойност',
	'proofreadpage_interval_too_large' => 'Грешка: обхватът е твърде голям',
	'proofreadpage_invalid_interval' => 'Грешка: недопустим интервал',
	'proofreadpage_nextpage' => 'Следваща страница',
	'proofreadpage_prevpage' => 'Предишна страница',
	'proofreadpage_body' => 'Тяло на страницата (за вграждане):',
	'proofreadpage_toggleheaders' => 'превключване на видимостта на разделите с „noinclude“',
	'proofreadpage_quality0_category' => 'Без текст',
	'proofreadpage_quality1_category' => 'Некоригирана',
	'proofreadpage_quality2_category' => 'Проблематична',
	'proofreadpage_quality3_category' => 'Коригирана',
	'proofreadpage_quality4_category' => 'Одобрена',
	'proofreadpage_index_listofpages' => 'Списък на страниците',
	'proofreadpage_image_message' => 'Препратка към индексната страница',
	'proofreadpage_page_status' => 'Статут на страницата',
	'proofreadpage_js_attributes' => 'Автор Заглавие Година Издател',
	'proofreadpage_index_attributes' => 'Автор
Заглавие
Година|Година на публикация
Издател
Източник
Изображение|Изображение на корицата
Страници||20
Забележки||10',
	'proofreadpage_pages' => '{{PLURAL:$1|страница|страници}}',
	'proofreadpage_specialpage_legend' => 'Търсене в индексните страници',
	'proofreadpage_source' => 'Източник',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'proofreadpage_namespace' => 'পাতা',
	'proofreadpage_index_namespace' => 'সূচী',
	'proofreadpage_image' => 'চিত্র',
	'proofreadpage_index' => 'সূচী',
	'proofreadpage_badpage' => 'ভুল বিন্যাস',
	'proofreadpage_nologin' => 'লগইন করা হয়নি',
	'proofreadpage_nextpage' => 'পরবর্তী পাতা',
	'proofreadpage_prevpage' => 'পূর্ববর্তী পাতা',
	'proofreadpage_header' => 'শিরোনাম (noinclude):',
	'proofreadpage_body' => 'পাতার প্রধান অংশ (to be transcluded):',
	'proofreadpage_footer' => 'পাদটীকা (noinclude):',
	'proofreadpage_quality1_category' => 'মুদ্রণ সংশোধন করা হয়নি',
	'proofreadpage_quality2_category' => 'সমস্যাসঙ্কুল',
	'proofreadpage_quality3_category' => 'মুদ্রণ সংশোধন',
	'proofreadpage_quality4_category' => 'বৈধকরণ',
	'proofreadpage_index_listofpages' => 'পাতাসমূহের তালিকা',
	'proofreadpage_image_message' => 'সূচী পাতায় লিঙ্ক করো',
	'proofreadpage_page_status' => 'পাতার অবস্থা',
	'proofreadpage_js_attributes' => 'লেখক শিরোনাম বছর প্রকাশক',
	'proofreadpage_index_attributes' => 'লেখক
শিরোনাম
বছর|প্রকাশনার বছর
প্রকাশক
উৎস
চিত্র|প্রচ্ছদ
পাতা||20
মন্তব্য||10',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'indexpages' => 'Roll ar pajennoù meneger',
	'proofreadpage_desc' => "Aotreañ a ra ur c'heñveriadur aes etre an destenn hag he nivereladur orin",
	'proofreadpage_namespace' => 'Pajenn',
	'proofreadpage_index_namespace' => 'Meneger',
	'proofreadpage_image' => 'skeudenn',
	'proofreadpage_index' => 'Meneger',
	'proofreadpage_index_expected' => 'Fazi : ur meneger a oa gortozet',
	'proofreadpage_nosuch_index' => "Fazi : n'eus ket eus ar meneger-se",
	'proofreadpage_nosuch_file' => "Fazi : n'eus restr ebet evel-se",
	'proofreadpage_badpage' => 'Furmad fall',
	'proofreadpage_badpagetext' => "N'eo ket reizh furmad ar bajenn ho peus klasket embann.",
	'proofreadpage_indexdupe' => 'Liamm e doubl',
	'proofreadpage_indexdupetext' => "Ne c'hell ket ar pajennoù bezañ listennet muioc'h evit ur wech war ur bajenn meneger.",
	'proofreadpage_nologin' => "N'eo ket kevreet",
	'proofreadpage_nologintext' => "Rankout a reoc'h bezañ [[Special:UserLogin|luget]] evit kemmañ statud reizhañ ar pajennoù.",
	'proofreadpage_notallowed' => "N'eo ket ar c'hemm-se",
	'proofreadpage_notallowedtext' => "Noc'h ket aotreet da gemmañ ar statud reizhañ ar bajenn-mañ.",
	'proofreadpage_number_expected' => 'Fazi : gortozet e vez un dalvoud niverel',
	'proofreadpage_interval_too_large' => 'Fazi : re vras eo an esaouenn',
	'proofreadpage_invalid_interval' => "Fazi : n'eo ket mat an esaouenn",
	'proofreadpage_nextpage' => "Pajenn war-lerc'h",
	'proofreadpage_prevpage' => 'Pajenn a-raok',
	'proofreadpage_header' => 'Penn uhelañ ar bajenn (noinclude) :',
	'proofreadpage_body' => 'Danvez (dre dreuzklozadur) :',
	'proofreadpage_footer' => 'Traoñ ar bajenn (noinclude) :',
	'proofreadpage_toggleheaders' => 'kuzhat/diskouez ar rannoù noinclude',
	'proofreadpage_quality0_category' => 'Hep testenn',
	'proofreadpage_quality1_category' => 'Da wiriañ',
	'proofreadpage_quality2_category' => 'Kudennek',
	'proofreadpage_quality3_category' => 'Reizhet',
	'proofreadpage_quality4_category' => 'Gwiriekaet',
	'proofreadpage_quality0_message' => "Ar bajenn-mañ n'he deus ket ezhomm da vezañ adlennet",
	'proofreadpage_quality1_message' => "Ar bajenn-mañ n'eo ket bet adlennet",
	'proofreadpage_quality2_message' => "Ur gudenn 'zo bet pa oa ar bajenn o vezañ reizhet",
	'proofreadpage_quality3_message' => 'Adlennet eo bet ar bajenn-mañ',
	'proofreadpage_quality4_message' => 'Gwiriekaet eo bet ar bajenn-mañ',
	'proofreadpage_index_listofpages' => 'Roll ar pajennoù',
	'proofreadpage_image_message' => 'Liamm war-du ar meneger',
	'proofreadpage_page_status' => 'Statud ar bajenn',
	'proofreadpage_js_attributes' => 'Aozer Titl Bloaz Embanner',
	'proofreadpage_index_attributes' => 'Aozer
titl
Bloaz|Bloavezh embann
Embanner
Mammenn
Skeudenn|Skeudenn ar golo
Pajennoù||20
Notennoù||10',
	'proofreadpage_pages' => '{{PLURAL:$1|bajenn|pajenn}}',
	'proofreadpage_specialpage_legend' => 'Klask e pajennoù ar merdeer',
	'proofreadpage_source' => 'Mammenn',
	'proofreadpage_source_message' => 'Embannadurioù bet niverelaet implijet evit sevel an destenn-mañ',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'indexpages' => 'Spisak stranica indeksa',
	'proofreadpage_desc' => 'Omogućuje jednostavnu usporedbu teksta sa originalnim',
	'proofreadpage_namespace' => 'Stranica',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'slika',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Greška: očekivan indeks',
	'proofreadpage_nosuch_index' => 'Greška: nema takvog indeksa',
	'proofreadpage_nosuch_file' => 'Greška: nema takve datoteke',
	'proofreadpage_badpage' => 'Pogrešan Format',
	'proofreadpage_badpagetext' => 'Format stranice koju pokušavate spremiti nije validan.',
	'proofreadpage_indexdupe' => 'Duplicirani link',
	'proofreadpage_indexdupetext' => 'Stranice ne mogu biti prikazane više od jednog puta na stranici indeksa.',
	'proofreadpage_nologin' => 'Niste prijavljeni',
	'proofreadpage_nologintext' => 'Morate biti [[Special:UserLogin|prijavljeni]] da biste mogli mijenati status lektorisanja stranica.',
	'proofreadpage_notallowed' => 'Izmjene nisu dopuštene',
	'proofreadpage_notallowedtext' => 'Nije Vam dopušteno da mijenjate status lektorisanja ove stranice.',
	'proofreadpage_number_expected' => 'Greška: očekivana brojna vrijednost',
	'proofreadpage_interval_too_large' => 'Greška: interval je prevelik',
	'proofreadpage_invalid_interval' => 'Greška: nevaljan interval',
	'proofreadpage_nextpage' => 'Slijedeća stranica',
	'proofreadpage_prevpage' => 'Prethodna stranica',
	'proofreadpage_header' => 'Zaglavlje (bez uključivanja):',
	'proofreadpage_body' => 'Tijelo stranice (koje će biti uključeno):',
	'proofreadpage_footer' => 'Podnožje (neuključuje):',
	'proofreadpage_toggleheaders' => 'pokaži/sakrij vidljivost sekcija koje se ne uključuju',
	'proofreadpage_quality0_category' => 'Bez teksta',
	'proofreadpage_quality1_category' => 'Nije provjerena',
	'proofreadpage_quality2_category' => 'Problematično',
	'proofreadpage_quality3_category' => 'Provjereno',
	'proofreadpage_quality4_category' => 'Provjereno',
	'proofreadpage_quality0_message' => 'Ova stranica ne treba biti lektorisana',
	'proofreadpage_quality1_message' => 'Ova stranica nije bila lektorisana',
	'proofreadpage_quality2_message' => 'Dogodio se problem pri lektorisanju ove stranice',
	'proofreadpage_quality3_message' => 'Ova stranice je bila lektorisana',
	'proofreadpage_quality4_message' => 'Ova stranice je bila provjerena',
	'proofreadpage_index_listofpages' => 'Spisak stranica',
	'proofreadpage_image_message' => 'Link na stranicu indeksa',
	'proofreadpage_page_status' => 'Status stranice',
	'proofreadpage_js_attributes' => 'Autor Naslov Godina Izdavač',
	'proofreadpage_index_attributes' => 'Autor
Naslov
Godina|Godina izdavanja
Izdavač
Izvor
Slika|Naslovna slika
Stranica||20
Napomene||10',
	'proofreadpage_pages' => '{{PLURAL:$1|stranica|stranice|stranica}}',
	'proofreadpage_specialpage_legend' => 'Ptretraga indeksnih stranica',
	'proofreadpage_source' => 'Izvor',
	'proofreadpage_source_message' => 'Skenirana varijanta korištena za nastanak ovog teksta',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author Paucabot
 * @author Qllach
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'indexpages' => "Llista de pàgines d'índex",
	'proofreadpage_desc' => "Permetre una fàcil comparació d'un text amb l'escanejat original",
	'proofreadpage_namespace' => 'Pàgina',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'imatge',
	'proofreadpage_index' => 'Índex',
	'proofreadpage_index_expected' => "Error: s'esperava un índex",
	'proofreadpage_nosuch_index' => "Error: no existeix l'índex",
	'proofreadpage_nosuch_file' => 'Error: no existeix el fitxer',
	'proofreadpage_badpage' => 'Format erroni',
	'proofreadpage_badpagetext' => 'El format de la pàgina que heu intentat desar és incorrecte.',
	'proofreadpage_indexdupe' => 'Enllaç duplicat',
	'proofreadpage_indexdupetext' => "Les pàgines no es poden llistar més d'una vegada a una pàgina d'índex.",
	'proofreadpage_nologin' => 'No heu iniciat la sessió',
	'proofreadpage_nologintext' => "Heu d'estar [[Special:UserLogin|registrat]] per a modificar l'estat de revisió de les pàgines.",
	'proofreadpage_notallowed' => 'Canvi no permès',
	'proofreadpage_notallowedtext' => "No esteu autoritzat per a canviar l'estat de revisió d'aquesta pàgina.",
	'proofreadpage_number_expected' => "Error: s'esperava un valor numèric",
	'proofreadpage_interval_too_large' => 'Error: interval massa ampli',
	'proofreadpage_invalid_interval' => 'Error: interval no vàlid',
	'proofreadpage_nextpage' => 'Pàgina següent',
	'proofreadpage_prevpage' => 'Pàgina anterior',
	'proofreadpage_header' => 'Capçalera (noinclude):',
	'proofreadpage_body' => 'Cos de la pàgina (per a ser transclós):',
	'proofreadpage_footer' => 'Peu de pàgina (noinclude):',
	'proofreadpage_toggleheaders' => "Visualitzar seccions ''noinclude''",
	'proofreadpage_quality0_category' => 'Sense text',
	'proofreadpage_quality1_category' => 'Sense revisar',
	'proofreadpage_quality2_category' => 'Problemàtica',
	'proofreadpage_quality3_category' => 'Revisada',
	'proofreadpage_quality4_category' => 'Validada',
	'proofreadpage_quality0_message' => 'Aquesta pàgina no necessita ser revisada.',
	'proofreadpage_quality1_message' => "Aquesta pàgina no s'ha revisat",
	'proofreadpage_quality2_message' => "Hi ha un problema amb la revisió d'aquesta pàgina.",
	'proofreadpage_quality3_message' => 'Aquesta pàgina ha estat revisada.',
	'proofreadpage_quality4_message' => 'Aquesta pàgina ha estat validada',
	'proofreadpage_index_listofpages' => 'Llista de pàgines',
	'proofreadpage_image_message' => "Enllaç a la pàgina d'índex",
	'proofreadpage_page_status' => 'Status de la pàgina',
	'proofreadpage_js_attributes' => 'Autor Títol Any Editorial',
	'proofreadpage_index_attributes' => "Títol
Autor
Editor
Lloc|Lloc d'edició
Any|Any de publicació
Clau
Font|Facsímils
Imatge
Pàgines||20
Sumari||15",
	'proofreadpage_pages' => '{{PLURAL:$1|pàgina|pàgines}}',
	'proofreadpage_specialpage_legend' => "Cerca a les pàgines d'índex",
	'proofreadpage_source' => 'Font',
	'proofreadpage_source_message' => "Edició digitalitzada d'on s'ha extret aquest text",
);

/** Cebuano (Cebuano)
 * @author Abastillas
 */
$messages['ceb'] = array(
	'proofreadpage_nextpage' => 'Sunod nga panid',
	'proofreadpage_prevpage' => 'Miaging panid',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'indexpages' => 'Seznam indexových stránek',
	'proofreadpage_desc' => 'Umožňuje jednoduché porovnání textu s předlohou',
	'proofreadpage_namespace' => 'Stránka',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'soubor',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Chyba: očekáván index',
	'proofreadpage_nosuch_index' => 'Chyba: takový index neexistuje',
	'proofreadpage_nosuch_file' => 'Chyba: takový soubor neexistuje',
	'proofreadpage_badpage' => 'Nesprávný formát',
	'proofreadpage_badpagetext' => 'Formát stránky, kterou jste se pokusili uložit, není správný.',
	'proofreadpage_indexdupe' => 'Duplicitní odkaz',
	'proofreadpage_indexdupetext' => 'Stránky mohou být v indexu uvedeny maximálně jednou.',
	'proofreadpage_nologin' => 'Nejste přihlášeni',
	'proofreadpage_nologintext' => 'Pokud chcete změnit stav zkontrolování stránky, musíte se [[Special:UserLogin|přihlásit]].',
	'proofreadpage_notallowed' => 'Změna není povolena',
	'proofreadpage_notallowedtext' => 'Nemáte povoleno měnit stav zkontrolování této stránky.',
	'proofreadpage_number_expected' => 'Chyba: očekávána číselná hodnota',
	'proofreadpage_interval_too_large' => 'Chyba: příliš velký interval',
	'proofreadpage_invalid_interval' => 'Chyba: nesprávný interval',
	'proofreadpage_nextpage' => 'Další stránka',
	'proofreadpage_prevpage' => 'Předchozí stránka',
	'proofreadpage_header' => 'Hlavička (noinclude):',
	'proofreadpage_body' => 'Tělo stránky (pro transkluzi):',
	'proofreadpage_footer' => 'Patička (noinclude):',
	'proofreadpage_toggleheaders' => 'přepnout viditelnost sekcí noinclude',
	'proofreadpage_quality0_category' => 'Bez textu',
	'proofreadpage_quality1_category' => 'Nebylo zkontrolováno',
	'proofreadpage_quality2_category' => 'Problematické',
	'proofreadpage_quality3_category' => 'Zkontrolováno',
	'proofreadpage_quality4_category' => 'Ověřeno',
	'proofreadpage_quality0_message' => 'Tuto stránku není potřeba kontrolovat',
	'proofreadpage_quality1_message' => 'Tato stránka nebyla zkontrolována',
	'proofreadpage_quality2_message' => 'Při kontrole této stránky se objevil problém',
	'proofreadpage_quality3_message' => 'Tato stránka byla zkontrolována',
	'proofreadpage_quality4_message' => 'Tato stránka byla ověřena',
	'proofreadpage_index_listofpages' => 'Seznam stránek',
	'proofreadpage_image_message' => 'Odkaz na úvodní stránku',
	'proofreadpage_page_status' => 'Stav stránky',
	'proofreadpage_js_attributes' => 'Autor Název Rok Vydavatel',
	'proofreadpage_index_attributes' => 'Autor
Název
Rok|Rok vydání
Vydavatelství
Obrázek|Obálka
Stran||20
Poznámky||10',
	'proofreadpage_pages' => '{{PLURAL:$1|stránka|stránky|stránek}}',
	'proofreadpage_specialpage_legend' => 'Hledat na indexových stránkách',
	'proofreadpage_source' => 'Zdroj',
	'proofreadpage_source_message' => 'Naskenovaná verze použitá k vypracování tohoto textu',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'proofreadpage_namespace' => 'Side',
	'proofreadpage_nextpage' => 'Næste side',
	'proofreadpage_prevpage' => 'Forrige side',
);

/** German (Deutsch)
 * @author Imre
 * @author Metalhead64
 * @author Raimond Spekking
 * @author Tbleher
 * @author ThomasV
 */
$messages['de'] = array(
	'indexpages' => 'Liste von Indexseiten',
	'proofreadpage_desc' => 'Ermöglicht das bequeme Vergleichen von Text mit dem Originalscan',
	'proofreadpage_namespace' => 'Seite',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'Scan',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Fehler: Index erwartet',
	'proofreadpage_nosuch_index' => 'Fehler: Kein entsprechender Index',
	'proofreadpage_nosuch_file' => 'Fehler: Keine entsprechende Datei',
	'proofreadpage_badpage' => 'Falsches Format',
	'proofreadpage_badpagetext' => 'Das Format der Seite, die du versuchst zu speichern, ist falsch.',
	'proofreadpage_indexdupe' => 'Doppelter Link',
	'proofreadpage_indexdupetext' => 'Seiten können nicht mehr als einmal auf einer Indexseite aufgelistet werden.',
	'proofreadpage_nologin' => 'Nicht angemeldet',
	'proofreadpage_nologintext' => 'Du musst [[Special:UserLogin|angemeldet sein]], um den Korrekturlesungsstatus von Seiten zu ändern.',
	'proofreadpage_notallowed' => 'Änderung nicht erlaubt',
	'proofreadpage_notallowedtext' => 'Du bist nicht berechtigt, den Korrekturlesungsstatus dieser Seite zu ändern.',
	'proofreadpage_number_expected' => 'Fehler: Numerischer Wert erwartet',
	'proofreadpage_interval_too_large' => 'Fehler: Intervall zu groß',
	'proofreadpage_invalid_interval' => 'Fehler: ungültiges Intervall',
	'proofreadpage_nextpage' => 'Nächste Seite',
	'proofreadpage_prevpage' => 'Vorherige Seite',
	'proofreadpage_header' => 'Kopfzeile (noinclude):',
	'proofreadpage_body' => 'Textkörper (Transklusion):',
	'proofreadpage_footer' => 'Fußzeile (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude-Abschnitte ein-/ausblenden',
	'proofreadpage_quality0_category' => 'Ohne Text',
	'proofreadpage_quality1_category' => 'Unkorrigiert',
	'proofreadpage_quality2_category' => 'Korrekturproblem',
	'proofreadpage_quality3_category' => 'Korrigiert',
	'proofreadpage_quality4_category' => 'Fertig',
	'proofreadpage_quality0_message' => 'Diese Seite muss nicht korrekturgelesen werden.',
	'proofreadpage_quality1_message' => 'Diese Seite wurde noch nicht korrekturgelesen.',
	'proofreadpage_quality2_message' => 'Dieser Text wurde korrekturgelesen, enthält aber noch Problemfälle. Nähere Informationen zu den Problemen finden sich möglicherweise auf der Diskussionsseite.',
	'proofreadpage_quality3_message' => 'Dieser Text wurde anhand der angegebenen Quelle einmal korrekturgelesen. Die Schreibweise sollte dem Originaltext folgen. Es ist noch ein weiterer Korrekturdurchgang nötig.',
	'proofreadpage_quality4_message' => 'Fertig. Dieser Text wurde zweimal anhand der Quelle korrekturgelesen. Die Schreibweise folgt dem Originaltext.',
	'proofreadpage_index_listofpages' => 'Seitenliste',
	'proofreadpage_image_message' => 'Link zur Indexseite',
	'proofreadpage_page_status' => 'Seitenstatus',
	'proofreadpage_js_attributes' => 'Autor Titel Jahr Verlag',
	'proofreadpage_index_attributes' => 'Autor
Titel
Jahr|Erscheinungsjahr
Verlag
Quelle
Bild|Titelbild
Seiten||20
Bemerkungen||10',
	'proofreadpage_pages' => '{{PLURAL:$1|Seite|Seiten}}',
	'proofreadpage_specialpage_legend' => 'Indexseiten durchsuchen',
	'proofreadpage_source' => 'Quelle',
	'proofreadpage_source_message' => 'Zur Erstellung dieses Texts wurde die gescannte Ausgabe benutzt.',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 */
$messages['de-formal'] = array(
	'proofreadpage_badpagetext' => 'Das Format der Seite, die Sie versuchen zu speichern, ist falsch.',
	'proofreadpage_nologintext' => 'Sie müssen [[Special:UserLogin|angemeldet sein]], um den Korrekturlesungsstatus von Seiten zu ändern.',
	'proofreadpage_notallowedtext' => 'Sie sind nicht berechtigt, den Korrekturlesungsstatus dieser Seite zu ändern.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Mirzali
 */
$messages['diq'] = array(
	'indexpages' => 'listeya pelê endeksi',
	'proofreadpage_desc' => "Destur bıd' wa metın pê cıgerayişê orjinali rehet u asan têver şan",
	'proofreadpage_namespace' => 'pel',
	'proofreadpage_index_namespace' => 'endeks',
	'proofreadpage_image' => 'resım',
	'proofreadpage_index' => 'indeks',
	'proofreadpage_index_expected' => 'xeta: paweyê endeksibi',
	'proofreadpage_nosuch_index' => 'xeta: hina yew endeks çino',
	'proofreadpage_nosuch_file' => 'xeta: hina yew dosya çina.',
	'proofreadpage_badpage' => 'foramto/fesalo şaş',
	'proofreadpage_badpagetext' => 'pelo ke şıma qeyd keni formatê ey şaşo',
	'proofreadpage_indexdupe' => 'gıreyo ke reyna reyna tesel beno, tekrar beno',
	'proofreadpage_indexdupetext' => 'no pelê indeksi de peli yew ra zêd liste nıbeni',
	'proofreadpage_nologin' => 'cı nıkewiyo.',
	'proofreadpage_nologintext' => 'qey vurnayişê halê raştkerdışê pelan gani şıma [[Special:UserLogin|cı kewiyi]].',
	'proofreadpage_notallowed' => 'vurnayiş re destur çino',
	'proofreadpage_notallowedtext' => 'vurnayişê halê raştkerdışê peli re destur nêdano',
	'proofreadpage_number_expected' => 'Error: numeric value expected',
	'proofreadpage_interval_too_large' => 'xeta: benate/mabên zaf hêrayo',
	'proofreadpage_invalid_interval' => 'xeta: benateyo nemeqbul',
	'proofreadpage_nextpage' => 'pelo ke yeno',
	'proofreadpage_prevpage' => 'pelo ke pey de mend',
	'proofreadpage_header' => 'sername (ihtiwa)',
	'proofreadpage_body' => 'miyaneyê peli (çepraşt têarê beno):',
	'proofreadpage_footer' => 'Footer (ihtiwa):',
	'proofreadpage_toggleheaders' => 'asayişê qısmi yê ke ihtiwa nıbeni bıvurn',
	'proofreadpage_quality0_category' => 'metn tede çino',
	'proofreadpage_quality1_category' => 'raşt nıbiyo',
	'proofreadpage_quality2_category' => 'problemın',
	'proofreadpage_quality3_category' => 'raşt ker',
	'proofreadpage_quality4_category' => 'raşt/tesdiq biyo',
	'proofreadpage_quality0_message' => 'no pel re raştkerdış luzûm nıkeno',
	'proofreadpage_quality1_message' => 'no pel de reaştkerdış nıbı',
	'proofreadpage_quality2_message' => 'wexta no pel de raştkerdış bêne xeta vıraziya',
	'proofreadpage_quality3_message' => 'no pel de raştkerdış bı',
	'proofreadpage_quality4_message' => 'no pel raşt/tesdiq biyo',
	'proofreadpage_index_listofpages' => 'listeya pelan',
	'proofreadpage_image_message' => 'gıreyo ke erziyayo pelê endeksi',
	'proofreadpage_page_status' => 'halê peli',
	'proofreadpage_js_attributes' => 'nuştox/e sername serre weşanger',
	'proofreadpage_index_attributes' => 'nuştox/e
sername
serre|serrê weşanayişi/neşri
weşanger
çıme
Resım|resmê qapaxi
peli||20
beyanati||10',
	'proofreadpage_pages' => '{{PLURAL:$1|pel|pel}}',
	'proofreadpage_specialpage_legend' => 'bıgêr pelê indeksan',
	'proofreadpage_source' => 'Çıme',
	'proofreadpage_source_message' => 'Versiyono kopyakerde gurêna ke nê meqaley rono',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'indexpages' => 'Lisćina indeksowych bokow',
	'proofreadpage_desc' => 'Zmóžnja lažke pśirownowanje teksta z originalnym skanom',
	'proofreadpage_namespace' => 'Bok',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'wobraz',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Zmólka: indeks wócakowany',
	'proofreadpage_nosuch_index' => 'Zmólka: taki indeks njejo',
	'proofreadpage_nosuch_file' => 'Zmólka: taka dataja njejo',
	'proofreadpage_badpage' => 'Wopacny format',
	'proofreadpage_badpagetext' => 'Format boka, kótaryž sy wopytał składowaś, jo wopaki.',
	'proofreadpage_indexdupe' => 'Dwójny wótkaz',
	'proofreadpage_indexdupetext' => 'Boki njedaju se wěcej ako jaden raz na indeksowem boku nalicyś.',
	'proofreadpage_nologin' => 'Njejsy se pśizjawił',
	'proofreadpage_nologintext' => 'Musyš [[Special:UserLogin|pśizjawjony]] byś, aby status kontrolnego cytanja bokow změnił.',
	'proofreadpage_notallowed' => 'Změna njedowólona',
	'proofreadpage_notallowedtext' => 'Njesmějoš status kontrolnego cytanja toś togo boka změniś.',
	'proofreadpage_number_expected' => 'Zmólka: numeriska gódnota wócakowana',
	'proofreadpage_interval_too_large' => 'Zmólka: interwal pśewjeliki',
	'proofreadpage_invalid_interval' => 'Zmólka: njepłaśiwy interwal',
	'proofreadpage_nextpage' => 'Pśiducy bok',
	'proofreadpage_prevpage' => 'Slědny bok',
	'proofreadpage_header' => 'Głowowa smužka (noinclude)',
	'proofreadpage_body' => 'Tekstowe śěło',
	'proofreadpage_footer' => 'Nogowa smužka (noinclude):',
	'proofreadpage_toggleheaders' => 'wótrězki noinclude pokazaś/schowaś',
	'proofreadpage_quality0_category' => 'Bźez teksta',
	'proofreadpage_quality1_category' => 'Njekontrolěrowany',
	'proofreadpage_quality2_category' => 'Problematiski',
	'proofreadpage_quality3_category' => 'Pśekontrolěrowany',
	'proofreadpage_quality4_category' => 'Wobwěsćony',
	'proofreadpage_quality0_message' => 'Toś ten bok jo se skorigěrował',
	'proofreadpage_quality1_message' => 'Toś ten bok njejo se skorigěrował',
	'proofreadpage_quality2_message' => 'Pśi korigěrowanju toś togo boka jo se problem nastał',
	'proofreadpage_quality3_message' => 'Toś ten bok jo se skorigěrował',
	'proofreadpage_quality4_message' => 'Toś ten bok jo se pśekontrolěrował',
	'proofreadpage_index_listofpages' => 'Lisćina bokow',
	'proofreadpage_image_message' => 'Wótkaz k indeksowemu bokoju',
	'proofreadpage_page_status' => 'Bokowy status',
	'proofreadpage_js_attributes' => 'Awtor Titel Lěto Wudawaŕ',
	'proofreadpage_index_attributes' => 'Awtor
Titel
Lěto|Lěto wózjawjenja
Wudawaŕ
Žrědło
Wobraz|Titelowy wobraz
Boki||20
Pśispomnjeśa||10',
	'proofreadpage_pages' => '{{PLURAL:$1|bok|boka|boki|bokow}}',
	'proofreadpage_specialpage_legend' => 'Indeksowe boki pśepytaś',
	'proofreadpage_source' => 'Žrědło',
	'proofreadpage_source_message' => 'Skanowane wudaśe wužyte za napóranje toś togo teksta',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'proofreadpage_namespace' => 'Nuŋɔŋlɔ',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Dead3y3
 * @author Konsnos
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'indexpages' => 'Κατάλογος σελίδων ευρετηρίου',
	'proofreadpage_desc' => 'Επίτρεψε εύκολη σύγκριση κειμένου με την πρωτότυπη σάρωση',
	'proofreadpage_namespace' => 'Σελίδα',
	'proofreadpage_index_namespace' => 'Ευρετήριο',
	'proofreadpage_image' => 'εικόνα',
	'proofreadpage_index' => 'Ευρετήριο',
	'proofreadpage_index_expected' => 'Σφάλμα: αναμενόταν δείκτης',
	'proofreadpage_nosuch_index' => 'Σφάλμα: δεν υπάρχει αυτός ο δείκτης',
	'proofreadpage_nosuch_file' => 'Σφάλμα: δεν υπάρχει αυτό το αρχείο',
	'proofreadpage_badpage' => 'Λάθος Φορμά',
	'proofreadpage_badpagetext' => 'Η μορφοποίηση της σελίδας που αποπειραθήκατε να αποθηκεύσετε είναι λανθασμένη.',
	'proofreadpage_indexdupe' => 'Διπλότυπος σύνδεσμος',
	'proofreadpage_indexdupetext' => 'Οι σελίδες δεν μπορούν περιλαμβάνονται στο ευρετήριο περισσότερες από μία φορές.',
	'proofreadpage_nologin' => 'Δεν έχετε συνδεθεί',
	'proofreadpage_nologintext' => 'Πρέπει να είστε [[Special:UserLogin|συνδεδεμένος]] για να αλλάξετε την κατάσταση επαλήθευσης σελίδων.',
	'proofreadpage_notallowed' => 'Αλλαγή δεν επιτρέπεται',
	'proofreadpage_notallowedtext' => 'Δεν επιτρέπεται να αλλάξετε την κατάσταση διόρθωσης κειμένου αυτής της σελίδας.',
	'proofreadpage_number_expected' => 'Σφάλμα: αναμενόταν αριθμητικό μέγεθος',
	'proofreadpage_interval_too_large' => 'Σφάλμα: υπερβολικά μεγάλο διάστημα',
	'proofreadpage_invalid_interval' => 'Σφάλμα: άκυρο διάστημα',
	'proofreadpage_nextpage' => 'Επόμενη σελίδα',
	'proofreadpage_prevpage' => 'Προηγούμενη σελίδα',
	'proofreadpage_header' => 'Επικεφαλίδα (noinclude):',
	'proofreadpage_body' => 'Σώμα σελίδας (προς εσωκλεισμό):',
	'proofreadpage_footer' => 'Κατακλείδα (noinclude):',
	'proofreadpage_toggleheaders' => 'ενάλλαξε την ορατότητα των τμημάτων noinclude',
	'proofreadpage_quality0_category' => 'Χωρίς κείμενο',
	'proofreadpage_quality1_category' => 'Δεν έχει γίνει proofreading',
	'proofreadpage_quality2_category' => 'Προβληματική',
	'proofreadpage_quality3_category' => 'Έχει γίνει proofreading',
	'proofreadpage_quality4_category' => 'Εγκρίθηκε',
	'proofreadpage_quality0_message' => 'Αυτή η σελίδα δεν χρειάζεται να ελεγχθεί για πιθανά λάθη',
	'proofreadpage_quality1_message' => 'Αυτή η σελίδα δεν έχει ελεγχθεί ακόμη για πιθανά λάθη',
	'proofreadpage_quality2_message' => 'Υπήρξε ένα πρόβλημα στον έλεγχο για πιθανά λάθη αυτής της σελίδας',
	'proofreadpage_quality3_message' => 'Η σελίδα αυτή έχει ελεγθεί για πιθανά λάθη',
	'proofreadpage_quality4_message' => 'Αυτή η σελίδα έχει εγκριθεί',
	'proofreadpage_index_listofpages' => 'Κατάλογος σελίδων',
	'proofreadpage_image_message' => 'Σύνδεσμος προς τη σελίδα ευρετηρίου',
	'proofreadpage_page_status' => 'Κατάσταση σελίδας',
	'proofreadpage_js_attributes' => 'Συγγραφέας Τίτλος Έτος Εκδότης',
	'proofreadpage_index_attributes' => 'Συγγραφέας

Τίτλος

Έτος|Έτος έκδοσης

Εκδότης

Πηγή

Εικόνα|Εξώφυλλο

Σελίδες||20

Σχόλια||10',
	'proofreadpage_pages' => '{{PLURAL:$1|σελίδα|σελίδες}}',
	'proofreadpage_specialpage_legend' => 'Αναζήτηση σελίδων ευρετηρίου',
	'proofreadpage_source' => 'Πηγή',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'indexpages' => 'Listo de indeksaj paĝoj',
	'proofreadpage_desc' => 'Permesas facilan komparon de teksto al la originala skanitaĵo.',
	'proofreadpage_namespace' => 'Paĝo',
	'proofreadpage_index_namespace' => 'Indekso',
	'proofreadpage_image' => 'bildo',
	'proofreadpage_index' => 'Indekso',
	'proofreadpage_index_expected' => 'Eraro: indekso atentita',
	'proofreadpage_nosuch_index' => 'Eraro: nenia indekso',
	'proofreadpage_nosuch_file' => 'Eraro: nenia dosiero',
	'proofreadpage_badpage' => 'Malbona Formato',
	'proofreadpage_badpagetext' => 'La formato de la paĝo kiun vi provis konservi estas malĝusta.',
	'proofreadpage_indexdupe' => 'Duplikata ligilo',
	'proofreadpage_indexdupetext' => 'Paĝoj ne povas esti listigataj pli ol unu fojo sur indekspaĝo.',
	'proofreadpage_nologin' => 'Ne ensalutita',
	'proofreadpage_nologintext' => 'Vi devas [[Special:UserLogin|ensaluti]] por modifi la provlegan statuson de paĝojn.',
	'proofreadpage_notallowed' => 'Ŝanĝo ne permesiĝis',
	'proofreadpage_notallowedtext' => 'Vi ne estas permesata ŝanĝi la pruvlegadan statuson de ĉi tiu paĝo.',
	'proofreadpage_number_expected' => 'Eraro: numera valoro atentita',
	'proofreadpage_interval_too_large' => 'Eraro: intervalo tro granda',
	'proofreadpage_invalid_interval' => 'Eraro: malvalida intervalo',
	'proofreadpage_nextpage' => 'Sekva paĝo',
	'proofreadpage_prevpage' => 'Antaŭa paĝo',
	'proofreadpage_header' => 'Supra titolo (ne inkluzivu):',
	'proofreadpage_body' => 'Paĝa korpo (esti transinkluzivita):',
	'proofreadpage_footer' => 'Suba paĝtitolo (neinkluzive):',
	'proofreadpage_toggleheaders' => 'baskulo neinkluzivu sekcioj videbleco',
	'proofreadpage_quality0_category' => 'Sen teksto',
	'proofreadpage_quality1_category' => 'Ne provlegita',
	'proofreadpage_quality2_category' => 'Problema',
	'proofreadpage_quality3_category' => 'Provlegita',
	'proofreadpage_quality4_category' => 'Validigita',
	'proofreadpage_quality0_message' => 'La paĝo ne bezonas esti provlegata',
	'proofreadpage_quality1_message' => 'Ĉi tiu paĝo ne estis pruvlegita',
	'proofreadpage_quality2_message' => 'Estis problemo pruvlegante ĉi tiun paĝon',
	'proofreadpage_quality3_message' => 'Ĉi tiu paĝo estis pruvlegita',
	'proofreadpage_quality4_message' => 'Ĉi tiu paĝo estis validigita',
	'proofreadpage_index_listofpages' => 'Listo de paĝoj',
	'proofreadpage_image_message' => 'Ligilo al la indekspaĝo',
	'proofreadpage_page_status' => 'Statuso de paĝo',
	'proofreadpage_js_attributes' => 'Aŭtoro Titolo Jaro Eldonejo',
	'proofreadpage_index_attributes' => 'Aŭtoro
Titolo
Jaro|Jaro de eldonado
Eldonejo
Fonto
Bildo|Bildo de kovrilo
Paĝoj||20
Rimarkoj||10',
	'proofreadpage_pages' => '{{PLURAL:$1|paĝo|paĝoj}}',
	'proofreadpage_specialpage_legend' => 'Serĉi indeksajn paĝojn',
	'proofreadpage_source' => 'Fonto',
	'proofreadpage_source_message' => 'Skanita eldono uzata establi ĉi tiu teksto',
);

/** Spanish (Español)
 * @author Aleator
 * @author Barcex
 * @author Crazymadlover
 * @author Locos epraix
 * @author Remember the dot
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'indexpages' => 'Lista de páginas indexadas',
	'proofreadpage_desc' => 'Permitir una fácil comparación de un texto con el escaneado original',
	'proofreadpage_namespace' => 'Página',
	'proofreadpage_index_namespace' => 'Índice',
	'proofreadpage_image' => 'imagen',
	'proofreadpage_index' => 'Índice',
	'proofreadpage_index_expected' => 'Error: se esperaba un índice',
	'proofreadpage_nosuch_index' => 'Error: no hay tal índice',
	'proofreadpage_nosuch_file' => 'Error: no existe el archivo',
	'proofreadpage_badpage' => 'Formato erróneo',
	'proofreadpage_badpagetext' => 'El formato de la página que intestaste grabar es incorrecto.',
	'proofreadpage_indexdupe' => 'Vínculo duplicado',
	'proofreadpage_indexdupetext' => 'Las páginas no pueden ser listadas más de una vez en una página índice.',
	'proofreadpage_nologin' => 'No ha iniciado sesión',
	'proofreadpage_nologintext' => 'Debes haber [[Special:UserLogin|iniciado sesión]]para modificar el status de corrección de las páginas.',
	'proofreadpage_notallowed' => 'Cambio no permitido',
	'proofreadpage_notallowedtext' => 'No estás permitido de cambiar el estatus corregido de esta página.',
	'proofreadpage_number_expected' => 'Error: se esperaba un valor numérico',
	'proofreadpage_interval_too_large' => 'Error: intervalo demasiado grande',
	'proofreadpage_invalid_interval' => 'Error: intervalo inválido',
	'proofreadpage_nextpage' => 'Página siguiente',
	'proofreadpage_prevpage' => 'Página anterior',
	'proofreadpage_header' => 'Encabezado (noinclude):',
	'proofreadpage_body' => 'Cuerpo de la página (para ser transcluido):',
	'proofreadpage_footer' => 'Pie de página (noinclude):',
	'proofreadpage_toggleheaders' => 'cambiar la visibilidad de las secciones noinclude',
	'proofreadpage_quality0_category' => 'Sin texto',
	'proofreadpage_quality1_category' => 'No corregido',
	'proofreadpage_quality2_category' => 'Problemática',
	'proofreadpage_quality3_category' => 'Corregido',
	'proofreadpage_quality4_category' => 'Validada',
	'proofreadpage_quality0_message' => 'Esta página no necesita ser corregida',
	'proofreadpage_quality1_message' => 'Esta página no ha sido corregida',
	'proofreadpage_quality2_message' => 'Hubo un problema cuando se corregía esta página',
	'proofreadpage_quality3_message' => 'Esta página ha sido corregida',
	'proofreadpage_quality4_message' => 'Esta página ha sido validada',
	'proofreadpage_index_listofpages' => 'Lista de páginas',
	'proofreadpage_image_message' => 'Enlace a la página de índice',
	'proofreadpage_page_status' => 'Estatus de página',
	'proofreadpage_js_attributes' => 'Autor Título Año Editor',
	'proofreadpage_index_attributes' => 'Autor
Título
Año|Año de publicación
Editor
Fuente
Imagen|Imagen de cubierta
Páginas||20
Comentarios||10',
	'proofreadpage_pages' => '{{PLURAL:$1|página|páginas}}',
	'proofreadpage_specialpage_legend' => 'Buscar en páginas de índice',
	'proofreadpage_source' => 'Fuente',
	'proofreadpage_source_message' => 'Edición escaneada usada para establecer este texto',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author WikedKentaur
 */
$messages['et'] = array(
	'indexpages' => 'Registrilehtede loetelu',
	'proofreadpage_desc' => 'Võimaldab teksti kõrvutada skannitud lehega.',
	'proofreadpage_namespace' => 'Lehekülg',
	'proofreadpage_index_namespace' => 'Register',
	'proofreadpage_image' => 'pilt',
	'proofreadpage_index' => 'Register',
	'proofreadpage_index_expected' => 'Viga: register puudub',
	'proofreadpage_nosuch_index' => 'Viga: küsitud registrit pole',
	'proofreadpage_nosuch_file' => 'Viga: faili ei leitud',
	'proofreadpage_badpage' => 'Vale vorming',
	'proofreadpage_badpagetext' => 'Salvestatava lehe vorming on vigane.',
	'proofreadpage_indexdupe' => 'Kahekordne link',
	'proofreadpage_indexdupetext' => 'Lehekülge saab registris loetleda vaid ühe korra.',
	'proofreadpage_nologin' => 'Ei ole sisse logitud',
	'proofreadpage_nologintext' => 'Pead lehekülje tõendusoleku muutmiseks [[Special:UserLogin|sisse logima]].',
	'proofreadpage_notallowed' => 'Muudatus ei ole lubatud',
	'proofreadpage_notallowedtext' => 'Sul pole lubatud lehekülje tõendusolekut muuta.',
	'proofreadpage_number_expected' => 'Viga: sisesta arv',
	'proofreadpage_interval_too_large' => 'Viga: vahemik on liiga suur',
	'proofreadpage_invalid_interval' => 'Viga: vigane vahemik',
	'proofreadpage_nextpage' => 'Järgmine lehekülg',
	'proofreadpage_prevpage' => 'Eelmine lehekülg',
	'proofreadpage_header' => 'Päis (ei sisaldu):',
	'proofreadpage_body' => 'Tekstiosa (sisaldub):',
	'proofreadpage_footer' => 'Jalus (ei sisaldu):',
	'proofreadpage_toggleheaders' => 'Näita või peida sisaldamata osad',
	'proofreadpage_quality0_category' => 'Ilma tekstita',
	'proofreadpage_quality1_category' => 'Õigsus tõendamata',
	'proofreadpage_quality2_category' => 'Problemaatiline',
	'proofreadpage_quality3_category' => 'Õigsus tõendatud',
	'proofreadpage_quality4_category' => 'Heakskiidetud',
	'proofreadpage_quality0_message' => 'Selle lehekülje õigsus ei vaja tõendamist',
	'proofreadpage_quality1_message' => 'Selle lehekülje õigsus on tõendamata',
	'proofreadpage_quality2_message' => 'Selle lehekülje õigsuse tõendamisel ilmnes probleem',
	'proofreadpage_quality3_message' => 'Selle lehekülje õigsus on tõendatud',
	'proofreadpage_quality4_message' => 'See lehekülg on heakskiidetud',
	'proofreadpage_index_listofpages' => 'Lehekülgede loend',
	'proofreadpage_image_message' => 'Link registrilehele',
	'proofreadpage_page_status' => 'Lehekülje olek',
	'proofreadpage_js_attributes' => 'Autor Pealkiri Aasta Väljaandja',
	'proofreadpage_index_attributes' => 'Autor
Pealkiri
Aasta|Väljaandmise aasta
Väljaandja
Päritolu
Pilt|Kaanepilt
Leheküljed||20
Märkused||10',
	'proofreadpage_pages' => '{{PLURAL:$1|lehekülg|lehekülge}}',
	'proofreadpage_specialpage_legend' => 'Otsi registrilehtedelt',
	'proofreadpage_source' => 'Allikas',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Unai Fdz. de Betoño
 */
$messages['eu'] = array(
	'proofreadpage_namespace' => 'Orria',
	'proofreadpage_index_namespace' => 'Aurkibidea',
	'proofreadpage_image' => 'irudi',
	'proofreadpage_index' => 'Aurkibidea',
	'proofreadpage_badpage' => 'Formatu Okerra',
	'proofreadpage_indexdupe' => 'Bikoiztutako lotura',
	'proofreadpage_notallowed' => 'Aldaketa ez baimendua',
	'proofreadpage_nextpage' => 'Hurrengo orria',
	'proofreadpage_prevpage' => 'Aurreko orria',
	'proofreadpage_quality0_category' => 'Testurik gabe',
	'proofreadpage_index_listofpages' => 'Orri zerrenda',
	'proofreadpage_image_message' => 'Aurkibide orrira lotu',
	'proofreadpage_page_status' => 'Orriaren egoera',
	'proofreadpage_js_attributes' => 'Egilea Izenburua Urtea Argitaratzailea',
	'proofreadpage_index_attributes' => 'Egilea
Izenburua
Urtea|Argitalpen urtea
Argitaratzailea
Iturria
Irudia|estalki irudia
Orriak||20
Oharrak||10',
	'proofreadpage_source' => 'Jatorria',
);

/** Persian (فارسی)
 * @author Huji
 * @author Mardetanha
 */
$messages['fa'] = array(
	'proofreadpage_desc' => 'امکان مقایسهٔ آسان متن با نسخهٔ اصلی پویش شده را فراهم می‌آورد',
	'proofreadpage_namespace' => 'صفحه',
	'proofreadpage_index_namespace' => 'اندیس',
	'proofreadpage_image' => 'تصویر',
	'proofreadpage_index' => 'اندیس',
	'proofreadpage_nextpage' => 'صفحهٔ بعدی',
	'proofreadpage_prevpage' => 'صفحهٔ قبلی',
	'proofreadpage_header' => 'عنوان (noinclude):',
	'proofreadpage_body' => 'متن صفحه (برای گنجانده شدن):',
	'proofreadpage_footer' => 'پانویس (noinclude):',
	'proofreadpage_toggleheaders' => 'تغییر پدیداری بخش‌های noinclude:',
	'proofreadpage_quality0_category' => 'بدون متن',
	'proofreadpage_quality1_category' => 'بازبینی‌نشده',
	'proofreadpage_quality2_category' => 'مشکل‌دار',
	'proofreadpage_quality3_category' => 'بازبینی‌شده',
	'proofreadpage_quality4_category' => 'تاییدشده',
	'proofreadpage_index_listofpages' => 'فهرست صفحه‌ها',
	'proofreadpage_image_message' => 'پیوند به صفحهٔ اندیس',
	'proofreadpage_page_status' => 'وضعیت صفحه',
	'proofreadpage_js_attributes' => 'نویسنده عنوان سال ناشر',
	'proofreadpage_index_attributes' => 'نویسنده
عنوان
سال|سال انتشار
ناشر
منبع
تصویر|تصویر روی جلد
صفحه||20
ملاحظات||10',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Nike
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'indexpages' => 'Luettelo hakemistosivuista',
	'proofreadpage_desc' => 'Mahdollistaa helpon vertailun tekstin ja alkuperäisen skannauksen välillä.',
	'proofreadpage_namespace' => 'Sivu',
	'proofreadpage_index_namespace' => 'Hakemisto',
	'proofreadpage_image' => 'kuva',
	'proofreadpage_index' => 'Hakemisto',
	'proofreadpage_index_expected' => 'Virhe: täsmennysosiota odotetaan',
	'proofreadpage_nosuch_index' => 'Virhe: Kyseistä indeksiä ei ole',
	'proofreadpage_nosuch_file' => 'Virhe: tiedostoa ei löydy',
	'proofreadpage_badpage' => 'Väärä muoto',
	'proofreadpage_badpagetext' => 'Sivu, jota yritit tallentaa on virheellisessä muodossa.',
	'proofreadpage_indexdupe' => 'Kaksoiskappalelinkki',
	'proofreadpage_indexdupetext' => 'Sivuja ei voida listata useammin kuin kerran hakemistosivulla.',
	'proofreadpage_nologin' => 'Et ole kirjautunut sisään',
	'proofreadpage_nologintext' => 'Sinun täytyy olla [[Special:UserLogin|kirjautunut sisään]] muuttaaksesi sivun oikolukutilaa.',
	'proofreadpage_notallowed' => 'Muutos ei ole sallittu',
	'proofreadpage_notallowedtext' => 'Sinulla ei ole oikeuksia muuttaa tämän sivun oikoluku-tilaa.',
	'proofreadpage_number_expected' => 'Virhe: odotettiin numeerista arvoa',
	'proofreadpage_interval_too_large' => 'Virhe: Väli liian suuri',
	'proofreadpage_invalid_interval' => 'Virhe: Väli ei toimi',
	'proofreadpage_nextpage' => 'Seuraava sivu',
	'proofreadpage_prevpage' => 'Edellinen sivu',
	'proofreadpage_header' => 'Ylätunniste (ei sisällytetä):',
	'proofreadpage_body' => 'Sivun runko (sisällytetään):',
	'proofreadpage_footer' => 'Alatunniste (ei sisällytetä):',
	'proofreadpage_toggleheaders' => 'vaihtaa sisällyttämättömien osioiden näkyvyyttä',
	'proofreadpage_quality0_category' => 'Ilman tekstiä',
	'proofreadpage_quality1_category' => 'Korjauslukematon',
	'proofreadpage_quality2_category' => 'Ongelmallinen',
	'proofreadpage_quality3_category' => 'Korjausluettu',
	'proofreadpage_quality4_category' => 'Hyväksytty',
	'proofreadpage_quality0_message' => 'Tätä sivua ei tarvitse oikolukea',
	'proofreadpage_quality1_message' => 'Tätä sivua ei ole oikoluettu',
	'proofreadpage_quality2_message' => 'Tämän sivun oikoluvussa oli ongelmia',
	'proofreadpage_quality3_message' => 'Tämä sivu on oikoluettu',
	'proofreadpage_quality4_message' => 'Tämä sivu on vahvistettu',
	'proofreadpage_index_listofpages' => 'Sivuluettelo',
	'proofreadpage_image_message' => 'Linkki hakemistosivuun',
	'proofreadpage_page_status' => 'Sivun tila',
	'proofreadpage_js_attributes' => 'Tekijä Nimike Vuosi Julkaisija',
	'proofreadpage_index_attributes' => 'Tekijä
Nimike
Vuosi|Julkaisuvuosi
Julkaisija
Lähde
Kuva|Kansikuva
Sivuja||20
Huomautuksia||10',
	'proofreadpage_pages' => '{{PLURAL:$1|sivu|sivua}}',
	'proofreadpage_specialpage_legend' => 'Hae indeksisivuilta',
	'proofreadpage_source' => 'Lähde',
	'proofreadpage_source_message' => 'Skannattua versiota on käytetty tämän tekstin muodostamiseen',
);

/** French (Français)
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Jean-Frédéric
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'indexpages' => "Liste des pages d'index",
	'proofreadpage_desc' => 'Permet une comparaison facile entre le texte et sa numérisation originale',
	'proofreadpage_namespace' => 'Page',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'image',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Erreur : un index est attendu',
	'proofreadpage_nosuch_index' => "Erreur : l'index n'a pas été trouvé",
	'proofreadpage_nosuch_file' => "Erreur : le fichier n'a pas été trouvé",
	'proofreadpage_badpage' => 'Mauvais format',
	'proofreadpage_badpagetext' => 'Le format de la page que vous essayez de publier est incorrect.',
	'proofreadpage_indexdupe' => 'Lien en double',
	'proofreadpage_indexdupetext' => "Les pages ne peuvent pas être listées plus d'une fois sur une page d'index.",
	'proofreadpage_nologin' => 'Non connecté',
	'proofreadpage_nologintext' => 'Vous devez être [[Special:UserLogin|connecté]] pour modifier le statut de correction des pages.',
	'proofreadpage_notallowed' => 'Modification non autorisée',
	'proofreadpage_notallowedtext' => "Vous n'êtes pas autorisé à modifier le statut de correction de cette page.",
	'proofreadpage_number_expected' => 'Erreur : une valeur numérique est attendue',
	'proofreadpage_interval_too_large' => 'Erreur : intervalle trop grand',
	'proofreadpage_invalid_interval' => 'Erreur : intervalle invalide',
	'proofreadpage_nextpage' => 'Page suivante',
	'proofreadpage_prevpage' => 'Page précédente',
	'proofreadpage_header' => 'En-tête (noinclude) :',
	'proofreadpage_body' => 'Contenu (par transclusion) :',
	'proofreadpage_footer' => 'Pied de page (noinclude) :',
	'proofreadpage_toggleheaders' => 'masquer/montrer les sections noinclude',
	'proofreadpage_quality0_category' => 'Sans texte',
	'proofreadpage_quality1_category' => 'Non corrigée',
	'proofreadpage_quality2_category' => 'Problématique',
	'proofreadpage_quality3_category' => 'Corrigée',
	'proofreadpage_quality4_category' => 'Validée',
	'proofreadpage_quality0_message' => 'Cette page n’est pas destinée à être corrigée.',
	'proofreadpage_quality1_message' => 'Cette page n’a pas encore été corrigée.',
	'proofreadpage_quality2_message' => 'Cette page n’a pas pu être corrigée, à cause d’un problème décrit en page de discussion.',
	'proofreadpage_quality3_message' => 'Cette page a été corrigée et est conforme au fac-similé.',
	'proofreadpage_quality4_message' => 'Cette page a été validée par deux contributeurs.',
	'proofreadpage_index_listofpages' => 'Liste des pages',
	'proofreadpage_image_message' => 'Lien vers la page d’index',
	'proofreadpage_page_status' => 'État de la page',
	'proofreadpage_js_attributes' => 'Auteur Titre Année Éditeur',
	'proofreadpage_index_attributes' => 'Auteur
Titre
Année|Année de publication
Éditeur
Source
Image|Image en couverture
Pages||20
Remarques||10',
	'proofreadpage_pages' => '{{PLURAL:$1|page|pages}}',
	'proofreadpage_specialpage_legend' => 'Rechercher dans les pages d’index',
	'proofreadpage_source' => 'Source',
	'proofreadpage_source_message' => 'Édition scannée dont est issu ce texte',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'indexpages' => 'Lista de les pâges d’endèxe',
	'proofreadpage_desc' => 'Pèrmèt una comparèson ésiê entre lo tèxto et sa numerisacion originâla.',
	'proofreadpage_namespace' => 'Pâge',
	'proofreadpage_index_namespace' => 'Endèxe',
	'proofreadpage_image' => 'émâge',
	'proofreadpage_index' => 'Endèxe',
	'proofreadpage_index_expected' => 'Èrror : un endèxe est atendu',
	'proofreadpage_nosuch_index' => 'Èrror : l’endèxe at pas étâ trovâ',
	'proofreadpage_nosuch_file' => 'Èrror : lo fichiér at pas étâ trovâ',
	'proofreadpage_badpage' => 'Crouyo format',
	'proofreadpage_badpagetext' => 'Lo format de la pâge que vos tâchiéd de sôvar est fôx.',
	'proofreadpage_indexdupe' => 'Lim en doblo',
	'proofreadpage_indexdupetext' => 'Les pâges pôvont pas étre listâs més d’un côp sur una pâge d’endèxe.',
	'proofreadpage_nologin' => 'Pas branchiê',
	'proofreadpage_nologintext' => 'Vos dête étre [[Special:UserLogin|branchiê]] por changiér lo statut de corrèccion de les pâges.',
	'proofreadpage_notallowed' => 'Changement pas ôtorisâ',
	'proofreadpage_notallowedtext' => 'Vos éte pas ôtorisâ a changiér lo statut de corrèccion de ceta pâge.',
	'proofreadpage_number_expected' => 'Èrror : una valor numerica est atendua',
	'proofreadpage_interval_too_large' => 'Èrror : entèrvalo trop grant',
	'proofreadpage_invalid_interval' => 'Èrror : entèrvalo envalido',
	'proofreadpage_nextpage' => 'Pâge aprés',
	'proofreadpage_prevpage' => 'Pâge devant',
	'proofreadpage_header' => 'En-téta (noinclude) :',
	'proofreadpage_body' => 'Contegnu (per transcllusion) :',
	'proofreadpage_footer' => 'Pied de pâge (noinclude) :',
	'proofreadpage_toggleheaders' => 'fâre vêre / cachiér les sèccions noinclude',
	'proofreadpage_quality0_category' => 'Sen tèxto',
	'proofreadpage_quality1_category' => 'Pas corregiê',
	'proofreadpage_quality2_category' => 'Pas de sûr',
	'proofreadpage_quality3_category' => 'Corregiê',
	'proofreadpage_quality4_category' => 'Validâ',
	'proofreadpage_quality0_message' => 'Ceta pâge at pas fôta d’étre corregiê.',
	'proofreadpage_quality1_message' => 'Ceta pâge at p’oncor étâ corregiê.',
	'proofreadpage_quality2_message' => 'Y at avu un problèmo pendent la corrèccion de ceta pâge.',
	'proofreadpage_quality3_message' => 'Ceta pâge at étâ corregiê.',
	'proofreadpage_quality4_message' => 'Ceta pâge at étâ validâ.',
	'proofreadpage_index_listofpages' => 'Lista de les pâges',
	'proofreadpage_image_message' => 'Lim de vers la pâge d’endèxe',
	'proofreadpage_page_status' => 'Ètat de la pâge',
	'proofreadpage_js_attributes' => 'Ôtor Titro An Èditor',
	'proofreadpage_index_attributes' => 'Ôtor
Titro
An|An de publecacion
Èditor
Sôrsa
Émâge|Émâge en cuvèrta
Pâges||20
Comentèros||10',
	'proofreadpage_pages' => 'pâge{{PLURAL:$1||s}}',
	'proofreadpage_specialpage_legend' => 'Rechèrchiér dens les pâges d’endèxe',
	'proofreadpage_source' => 'Sôrsa',
	'proofreadpage_source_message' => 'Èdicion scanâ que vint de cél tèxto',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'proofreadpage_index_listofpages' => 'Liste des pagjinis',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'proofreadpage_namespace' => 'Side',
	'proofreadpage_nextpage' => 'Folgjende side',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'proofreadpage_index_attributes' => 'Údar
Teideal
Blian|Blian foilseacháin
Foilsitheoir
Foinse
Íomhá|Íomhá clúdaigh
Leathanaigh||20
Nótaí',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'indexpages' => 'Lista de páxinas índice',
	'proofreadpage_desc' => 'Permite a comparación sinxela do texto coa dixitalización orixinal',
	'proofreadpage_namespace' => 'Páxina',
	'proofreadpage_index_namespace' => 'Índice',
	'proofreadpage_image' => 'imaxe',
	'proofreadpage_index' => 'Índice',
	'proofreadpage_index_expected' => 'Erro: agardábase un índice',
	'proofreadpage_nosuch_index' => 'Erro: non existe tal índice',
	'proofreadpage_nosuch_file' => 'Erro: non existe tal ficheiro',
	'proofreadpage_badpage' => 'Formato incorrecto',
	'proofreadpage_badpagetext' => 'O formato da páxina que intentou gardar é incorrecto.',
	'proofreadpage_indexdupe' => 'Ligazón duplicada',
	'proofreadpage_indexdupetext' => 'Non se poden listar as páxinas máis dunha vez nunha páxina índice.',
	'proofreadpage_nologin' => 'Non accedeu ao sistema',
	'proofreadpage_nologintext' => 'Debe [[Special:UserLogin|acceder ao sistema]] para modificar o estado de corrección das páxinas.',
	'proofreadpage_notallowed' => 'Cambio non autorizado',
	'proofreadpage_notallowedtext' => 'Non ten os permisos necesarios para cambiar o estado de corrección desta páxina.',
	'proofreadpage_number_expected' => 'Erro: agardábase un valor numérico',
	'proofreadpage_interval_too_large' => 'Erro: intervalo moi grande',
	'proofreadpage_invalid_interval' => 'Erro: intervalo inválido',
	'proofreadpage_nextpage' => 'Páxina seguinte',
	'proofreadpage_prevpage' => 'Páxina anterior',
	'proofreadpage_header' => 'Cabeceira (noinclude):',
	'proofreadpage_body' => 'Corpo da páxina (para ser transcluído)',
	'proofreadpage_footer' => 'Pé de páxina (noinclude):',
	'proofreadpage_toggleheaders' => 'alternar a visibilidade das seccións noinclude',
	'proofreadpage_quality0_category' => 'Sen texto',
	'proofreadpage_quality1_category' => 'Non corrixido',
	'proofreadpage_quality2_category' => 'Problemático',
	'proofreadpage_quality3_category' => 'Corrixido',
	'proofreadpage_quality4_category' => 'Validado',
	'proofreadpage_quality0_message' => 'Esta páxina non necesita corrección',
	'proofreadpage_quality1_message' => 'Esta páxina non foi corrixida',
	'proofreadpage_quality2_message' => 'Houbo un problema ao corrixir esta páxina',
	'proofreadpage_quality3_message' => 'Esta páxina foi corrixida',
	'proofreadpage_quality4_message' => 'Esta páxina foi validada',
	'proofreadpage_index_listofpages' => 'Lista de páxinas',
	'proofreadpage_image_message' => 'Ligazón á páxina índice',
	'proofreadpage_page_status' => 'Estado da páxina',
	'proofreadpage_js_attributes' => 'Autor Título Ano Editor',
	'proofreadpage_index_attributes' => 'Autor
Título
Ano|Ano de publicación
Editor
Orixe
Imaxe|Imaxe da cuberta
Páxinas||20
Comentarios||10',
	'proofreadpage_pages' => '{{PLURAL:$1|páxina|páxinas}}',
	'proofreadpage_specialpage_legend' => 'Procurar nas páxinas de índice',
	'proofreadpage_source' => 'Orixe',
	'proofreadpage_source_message' => 'Edición dixitalizada utilizada para establecer este texto',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'proofreadpage_namespace' => 'Δέλτος',
	'proofreadpage_index_namespace' => 'Δείκτης',
	'proofreadpage_image' => 'εἰκών',
	'proofreadpage_index' => 'Δείκτης',
	'proofreadpage_nextpage' => 'ἡ δέλτος ἡ ἑπομένη',
	'proofreadpage_prevpage' => 'ἡ δέλτος ἡ προτέρα',
	'proofreadpage_quality1_category' => 'Μὴ ἠλεγμένη',
	'proofreadpage_quality2_category' => 'Προβληματική',
	'proofreadpage_index_listofpages' => 'Καταλογὴ δέλτων',
	'proofreadpage_page_status' => 'Κατάστασις δέλτου',
	'proofreadpage_pages' => '{{PLURAL:$1|δέλτος|δέλτοι}}',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author J. 'mach' wust
 */
$messages['gsw'] = array(
	'indexpages' => 'Lischte vu Indexsyte',
	'proofreadpage_desc' => 'Macht e eifache Verglyych vu Täxt mit em Originalscan megli',
	'proofreadpage_namespace' => 'Syte',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'Scan',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Fähler: Index erwartet',
	'proofreadpage_nosuch_index' => 'Fähler: Kei sonige Index',
	'proofreadpage_nosuch_file' => 'Fähler: Kei sonigi Datei',
	'proofreadpage_badpage' => 'Falsch Format',
	'proofreadpage_badpagetext' => 'S Format vu dr Syte, wu du versuecht hesch z spychere, isch falsch.',
	'proofreadpage_indexdupe' => 'Gleich (Link) dupliziere',
	'proofreadpage_indexdupetext' => 'Syte chenne nit meh wie eimol ufglischtet wäre uf ere Indexsyte',
	'proofreadpage_nologin' => 'Nit aagmäldet',
	'proofreadpage_nologintext' => 'Du muesch [[Special:UserLogin|aagmäldet syy]] go dr Korrekturläsigs-Status vu Syte ändere.',
	'proofreadpage_notallowed' => 'Änderig nit erlaubt',
	'proofreadpage_notallowedtext' => 'Du derfsch dr Korrektur-Läsigs-Status vu däre Syte nit ändere.',
	'proofreadpage_number_expected' => 'Fähler: Numerische Wärt erwartet',
	'proofreadpage_interval_too_large' => 'Fähler: Intervall z groß',
	'proofreadpage_invalid_interval' => 'Fähler: nit giltig Intervall',
	'proofreadpage_nextpage' => 'Negschti Syte',
	'proofreadpage_prevpage' => 'Vorderi Syte',
	'proofreadpage_header' => 'Chopfzyylete (noinclude):',
	'proofreadpage_body' => 'Täxtlyyb (Transklusion):',
	'proofreadpage_footer' => 'Fueßzyylete (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude-Abschnit yy-/uusblände',
	'proofreadpage_quality0_category' => 'Ohni Tekscht',
	'proofreadpage_quality1_category' => 'Nit korrigiert',
	'proofreadpage_quality2_category' => 'Korrekturprobläm',
	'proofreadpage_quality3_category' => 'Korrigiert',
	'proofreadpage_quality4_category' => 'Fertig',
	'proofreadpage_quality0_message' => 'Die Syte brucht nit Korrektur gläse wäre.',
	'proofreadpage_quality1_message' => 'Die Syte isch nit Korrektur gläse wore',
	'proofreadpage_quality2_message' => 'S het e Probläm gee bim Korrektur läse vu däre Syte',
	'proofreadpage_quality3_message' => 'Die Syte isch Korrektur gläse wore',
	'proofreadpage_quality4_message' => 'Die Syte isch validiert wore',
	'proofreadpage_index_listofpages' => 'Sytelischt',
	'proofreadpage_image_message' => 'Gleich zue dr Indexsyte',
	'proofreadpage_page_status' => 'Sytestatus',
	'proofreadpage_js_attributes' => 'Autor Titel Johr Verlag',
	'proofreadpage_index_attributes' => 'Autor
Titel
Johr|Johr vu dr Vereffetlichung
Verlag
Quälle
Bild|Titelbild
Syte||20
Aamerkige||10',
	'proofreadpage_pages' => '{{PLURAL:$1|Syte|Syte}}',
	'proofreadpage_specialpage_legend' => 'Indexsyte dursueche',
	'proofreadpage_source' => 'Quälle',
	'proofreadpage_source_message' => 'Gscannti Uusgab, wu brucht wird go dää Text erarbeite',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'proofreadpage_namespace' => 'Duillag',
	'proofreadpage_nextpage' => 'Yn chied duillag elley',
	'proofreadpage_prevpage' => 'Yn duillag roish shen',
	'proofreadpage_index_listofpages' => 'Rolley duillagyn',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'proofreadpage_namespace' => '‘Ao‘ao',
	'proofreadpage_nextpage' => 'Mea aʻe',
	'proofreadpage_prevpage' => 'Mea ma mua aʻe',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'indexpages' => 'רשימת דפי אינדקס',
	'proofreadpage_desc' => 'השוואה קלה של טקסט לסריקה המקורית שלו',
	'proofreadpage_namespace' => 'דף',
	'proofreadpage_index_namespace' => 'אינדקס',
	'proofreadpage_image' => 'תמונה',
	'proofreadpage_index' => 'אינדקס',
	'proofreadpage_index_expected' => 'שגיאה: נדרש אינדקס',
	'proofreadpage_nosuch_index' => 'שגיאה: אין אינדקס כזה',
	'proofreadpage_nosuch_file' => 'שגיאה: אין קובץ כזה',
	'proofreadpage_badpage' => 'מבנה שגוי',
	'proofreadpage_badpagetext' => 'מבנה הדף אותו ניסיתם לשמור אינו נכון.',
	'proofreadpage_indexdupe' => 'קישור כפול',
	'proofreadpage_indexdupetext' => 'לא ניתן להציג את הדפים יותר מפעם אחת בדף אינדקס.',
	'proofreadpage_nologin' => 'לא נכנסתם לאתר',
	'proofreadpage_nologintext' => 'עליכם [[Special:UserLogin|להיכנס לחשבון]] כדי לשנות את מצב ההגהה של דפים.',
	'proofreadpage_notallowed' => 'לא ניתן לבצע השינוי',
	'proofreadpage_notallowedtext' => 'אינכם מורשים לשנות את מצב ההגהה של דף זה.',
	'proofreadpage_number_expected' => 'שגיאה: נדרש ערך מספרי',
	'proofreadpage_interval_too_large' => 'שגיאה: המרווח גדול מדי',
	'proofreadpage_invalid_interval' => 'שגיאה: מרווח בלתי תקין',
	'proofreadpage_nextpage' => 'הדף הבא',
	'proofreadpage_prevpage' => 'הדף הקודם',
	'proofreadpage_header' => 'כותרת (לא להכללה):',
	'proofreadpage_body' => 'גוף הדף (להכללה):',
	'proofreadpage_footer' => 'כותרת תחתונה (לא להכללה):',
	'proofreadpage_toggleheaders' => 'הצגת או הסתרת החלקים שאינם להכללה',
	'proofreadpage_quality0_category' => 'ללא טקסט',
	'proofreadpage_quality1_category' => 'לא בוצעה הגהה',
	'proofreadpage_quality2_category' => 'בעייתי',
	'proofreadpage_quality3_category' => 'בוצעה הגהה',
	'proofreadpage_quality4_category' => 'מאומת',
	'proofreadpage_quality0_message' => 'לדף זה לא נדרשת בדיקת הגהה',
	'proofreadpage_quality1_message' => 'דף זה לא עבר בדיקת הגהה',
	'proofreadpage_quality2_message' => 'הייתה בעיה בעת ביצוע בדיקת הגהה לדף זה',
	'proofreadpage_quality3_message' => 'דף זה עבר הגהה',
	'proofreadpage_quality4_message' => 'דף זה עבר אימות',
	'proofreadpage_index_listofpages' => 'רשימת דפים',
	'proofreadpage_image_message' => 'קישור לדף האינדקס',
	'proofreadpage_page_status' => 'מצב הדף',
	'proofreadpage_js_attributes' => 'מחבר כותרת שנה מוציא לאור',
	'proofreadpage_index_attributes' => 'מחבר
כותרת
שנה|שנת פרסום
מוציא לאור
מקור
תמונה|תמונת עטיפה
דפים||20
הערות||10',
	'proofreadpage_pages' => '{{PLURAL:$1|דף|דפים}}',
	'proofreadpage_specialpage_legend' => 'חיפוש בדפי האינדקס',
	'proofreadpage_source' => 'מקור',
	'proofreadpage_source_message' => 'הגרסה הסרוקה ששימשה להכנת טקסט זה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'proofreadpage_desc' => 'मूल पाठ और सद्य पाठ में फर्क आसानी से दर्शाती हैं',
	'proofreadpage_namespace' => 'पन्ना',
	'proofreadpage_index_namespace' => 'अनुक्रम',
	'proofreadpage_image' => 'चित्र',
	'proofreadpage_index' => 'अनुक्रम',
	'proofreadpage_nextpage' => 'अगला पन्ना',
	'proofreadpage_prevpage' => 'पिछला पन्ना',
	'proofreadpage_header' => 'पन्ने का उपरी पाठ (noinclude):',
	'proofreadpage_body' => 'पन्ने का मुख्य पाठ (जो इस्तेमाल में आयेगा):',
	'proofreadpage_footer' => 'पन्ने का निचला पाठ (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude विभांगोंका दृष्य स्तर बदलें',
	'proofreadpage_quality1_category' => 'परिक्षण हुआ नहीं',
	'proofreadpage_quality2_category' => 'समस्याकारक',
	'proofreadpage_quality3_category' => 'परिक्षण करें',
	'proofreadpage_quality4_category' => 'प्रमाणित',
	'proofreadpage_index_listofpages' => 'पन्नों की सूची',
	'proofreadpage_image_message' => 'अनुक्रम पन्ने के लिये कड़ी',
	'proofreadpage_page_status' => 'पन्नेकी स्थिती',
	'proofreadpage_js_attributes' => 'लेखक शीर्षक वर्ष प्रकाशक',
	'proofreadpage_index_attributes' => 'लेखक
शीर्षक
वर्ष|प्रकाशन वर्ष
प्रकाशक
स्रोत
चित्र|मुखपृष्ठ चित्र
पन्ने||२०
टिप्पणी||१०',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'indexpages' => 'Popis sadržaja stranica',
	'proofreadpage_desc' => 'Omogućava jednostavnu usporedbu teksta i izvornog skena',
	'proofreadpage_namespace' => 'Stranica',
	'proofreadpage_index_namespace' => 'Sadržaj',
	'proofreadpage_image' => 'slika',
	'proofreadpage_index' => 'Sadržaj',
	'proofreadpage_index_expected' => 'Progreška: očekivan je sadržaj',
	'proofreadpage_nosuch_index' => 'Pogreška: nema takvog sadržaja',
	'proofreadpage_nosuch_file' => 'Pogreška: nema takve datoteke',
	'proofreadpage_badpage' => 'Pogrešan format',
	'proofreadpage_badpagetext' => 'Format stranice koju ste pokušali spremiti je neispravan.',
	'proofreadpage_indexdupe' => 'Duplicirana poveznica',
	'proofreadpage_indexdupetext' => 'Stranice ne mogu biti iszlistane više od jednom na stranici sadržaja.',
	'proofreadpage_nologin' => 'Niste prijavljeni',
	'proofreadpage_nologintext' => 'Morate biti [[Special:UserLogin|prijavljeni]] za izmjenu statusa provjerenosti na stranicama.',
	'proofreadpage_notallowed' => 'Izmjena nije dozvoljena',
	'proofreadpage_notallowedtext' => 'Nije Vam dozvoljeno mijenjati status ispravljenosti ove stranice.',
	'proofreadpage_number_expected' => 'Pogreška: očekivana je brojčana vrijednost',
	'proofreadpage_interval_too_large' => 'Pogreška: interval je prevelik',
	'proofreadpage_invalid_interval' => 'Pogreška: interval nije valjan',
	'proofreadpage_nextpage' => 'Slijedeća stranica',
	'proofreadpage_prevpage' => 'Prethodna stranica',
	'proofreadpage_header' => "Zaglavlje (''noinclude''):",
	'proofreadpage_body' => 'Tijelo stranice (bit će uključeno):',
	'proofreadpage_footer' => "Podnožje (''footer noinclude''):",
	'proofreadpage_toggleheaders' => "promijeni vidljivost ''noinclude'' odlomaka",
	'proofreadpage_quality0_category' => 'Bez teksta',
	'proofreadpage_quality1_category' => 'Nije ispravljeno',
	'proofreadpage_quality2_category' => 'Problematično',
	'proofreadpage_quality3_category' => 'Ispravljeno',
	'proofreadpage_quality4_category' => 'Provjereno',
	'proofreadpage_quality0_message' => 'Ovu stranicu nije potrebno ispravljati',
	'proofreadpage_quality1_message' => 'Ova stranica nije ispravljena',
	'proofreadpage_quality2_message' => 'Došlo je do problema prilikom ispravljanja ove stranice',
	'proofreadpage_quality3_message' => 'Ova stranica je ispravljena',
	'proofreadpage_quality4_message' => 'Ova stranica je potvrđena',
	'proofreadpage_index_listofpages' => 'Popis stranica',
	'proofreadpage_image_message' => 'Poveznica na stranicu sa sadržajem',
	'proofreadpage_page_status' => 'Status stranice',
	'proofreadpage_js_attributes' => 'Autor Naslov Godina Izdavač',
	'proofreadpage_index_attributes' => 'Autor
Naslov
Godina|Godina izdavanja
Izdavač
Izvor
Slika|Naslovnica
Stranica||20
Napomene||10',
	'proofreadpage_pages' => '{{PLURAL:$1|stranica|stranice}}',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 */
$messages['hsb'] = array(
	'indexpages' => 'Lisćina indeksowych stronow',
	'proofreadpage_desc' => 'Lochke přirunanje teksta z originalnym skanom dowolić',
	'proofreadpage_namespace' => 'Strona',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'Wobraz',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Zmylk: indeks wočakowany',
	'proofreadpage_nosuch_index' => 'Zmylk: tajki indeks njeje',
	'proofreadpage_nosuch_file' => 'Zmylk: tajka dataja njeje',
	'proofreadpage_badpage' => 'Wopačny format',
	'proofreadpage_badpagetext' => 'Format strony, kotruž sy spytał składować, je wopak.',
	'proofreadpage_indexdupe' => 'Dwójny wotkaz',
	'proofreadpage_indexdupetext' => 'Strony njedadźa so wjace hač jedyn raz na indeksowej stronje nalistować.',
	'proofreadpage_nologin' => 'Njejsy so přizjewił',
	'proofreadpage_nologintext' => 'Dyrbiš [[Special:UserLogin|přizjewjeny]] być, zo by status kontrolneho čitanja stronow změnił.',
	'proofreadpage_notallowed' => 'Změna njedowolena',
	'proofreadpage_notallowedtext' => 'Njesměš status kontrolneho čitanja tutej strony změnić.',
	'proofreadpage_number_expected' => 'Zmylk: numeriska hódnota wočakowana',
	'proofreadpage_interval_too_large' => 'Zmylk: interwal přewulki',
	'proofreadpage_invalid_interval' => 'Zmylk: njepłaćiwy interwal',
	'proofreadpage_nextpage' => 'Přichodna strona',
	'proofreadpage_prevpage' => 'Předchadna strona',
	'proofreadpage_header' => 'Hłowowa linka (noinclude)',
	'proofreadpage_body' => 'Tekstowy ćěleso (transkluzija):',
	'proofreadpage_footer' => 'Nohowa linka (noinclude):',
	'proofreadpage_toggleheaders' => 'wotrězki noinclude pokazać/schować',
	'proofreadpage_quality0_category' => 'Bjez teksta',
	'proofreadpage_quality1_category' => 'Njeskorigowany',
	'proofreadpage_quality2_category' => 'Njedospołny',
	'proofreadpage_quality3_category' => 'Skorigowany',
	'proofreadpage_quality4_category' => 'Hotowy',
	'proofreadpage_quality0_message' => 'Tuta strona njetrjeba so skorigować',
	'proofreadpage_quality1_message' => 'Tut strona njeje so skorigowała',
	'proofreadpage_quality2_message' => 'Při korigowanju tuteje strony je problem wustupił',
	'proofreadpage_quality3_message' => 'Tuta strona je so skorigowała',
	'proofreadpage_quality4_message' => 'Tuta strona je so přepruwowała',
	'proofreadpage_index_listofpages' => 'Lisćina stronow',
	'proofreadpage_image_message' => 'Wotkaz k indeksowej stronje',
	'proofreadpage_page_status' => 'Status strony',
	'proofreadpage_js_attributes' => 'Awtor Titul Lěto Wudawaćel',
	'proofreadpage_index_attributes' => 'Awtor
Titul
Lěto|Lěto publikowanja
Wudawaćel
Žórło
Wobraz|Wobraz titloweje strony
Strony||20
Přispomnjenki||10',
	'proofreadpage_pages' => '{{PLURAL:$1|strona|stronje|strony|stronow}}',
	'proofreadpage_specialpage_legend' => 'Indeksowe strony přepytać',
	'proofreadpage_source' => 'Žórło',
	'proofreadpage_source_message' => 'Skanowane wudaće wužite za wutworjenje tutoho teksta',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 * @author KossuthRad
 */
$messages['hu'] = array(
	'indexpages' => 'Indexlapok listája',
	'proofreadpage_desc' => 'Lehetővé teszi a szöveg és az eredeti szkennelt változat egyszerű összehasonlítását',
	'proofreadpage_namespace' => 'Oldal',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'Kép',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Hiba: indexet vártam',
	'proofreadpage_nosuch_index' => 'Hiba: nincs ilyen index',
	'proofreadpage_nosuch_file' => 'Hiba: nincs ilyen fájl',
	'proofreadpage_badpage' => 'Hibás formátum',
	'proofreadpage_badpagetext' => 'A lap formátuma, amit menteni próbáltál rossz.',
	'proofreadpage_indexdupe' => 'Hivatkozás megkettőzése',
	'proofreadpage_indexdupetext' => 'A lapok nem szerepelhetnek egynél többször egy indexlapon.',
	'proofreadpage_nologin' => 'Nem vagy bejelentkezve',
	'proofreadpage_nologintext' => '[[Special:UserLogin|Be kell jelentkezned]], hogy módosítani tudd a lapok korrektúrázási állapotát.',
	'proofreadpage_notallowed' => 'A változtatás nincs engedélyezve',
	'proofreadpage_notallowedtext' => 'Nincs jogosultságod megváltoztatni a lap korrektúrázási állapotát.',
	'proofreadpage_number_expected' => 'Hiba: numerikus értéket vártam',
	'proofreadpage_interval_too_large' => 'Hiba: az intervallum túl nagy',
	'proofreadpage_invalid_interval' => 'Hiba: érvénytelen intervallum',
	'proofreadpage_nextpage' => 'Következő oldal',
	'proofreadpage_prevpage' => 'Előző oldal',
	'proofreadpage_header' => 'Fejléc (noinclude):',
	'proofreadpage_body' => 'Oldal (be lesz illesztve):',
	'proofreadpage_footer' => 'Lábléc (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude részek láthatóságának váltása',
	'proofreadpage_quality0_category' => 'Szöveg nélkül',
	'proofreadpage_quality1_category' => 'Nincs korrektúrázva',
	'proofreadpage_quality2_category' => 'Problematikus',
	'proofreadpage_quality3_category' => 'Korrektúrázva',
	'proofreadpage_quality4_category' => 'Jóváhagyva',
	'proofreadpage_quality0_message' => 'A lapot nem szükséges korrektúrázni',
	'proofreadpage_quality1_message' => 'A lap nincsen korrektúrázva',
	'proofreadpage_quality2_message' => 'Probléma történt a lap korrektúrázása közben',
	'proofreadpage_quality3_message' => 'A lap korrektúrázva van',
	'proofreadpage_quality4_message' => 'A lap jóváhagyva',
	'proofreadpage_index_listofpages' => 'Oldalak listája',
	'proofreadpage_image_message' => 'Csatolni az index oldalhoz',
	'proofreadpage_page_status' => 'Oldal állapota',
	'proofreadpage_js_attributes' => 'Szerző Cím Év Kiadó',
	'proofreadpage_index_attributes' => 'Szerző
Cím
Év|Kiadás éve
Kiadó
Forrás
Kép|Borító
Oldalak||20
Megjegyzések||10',
	'proofreadpage_pages' => '{{PLURAL:$1|lap|lap}}',
	'proofreadpage_specialpage_legend' => 'Indexlapok keresése',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'indexpages' => 'Ինդեքս էջերի ցանկ',
	'proofreadpage_desc' => 'Թույլ է տալիս տեքստի և բնօրինակի տեսածրված պատկերի հեշտ համեմատում',
	'proofreadpage_namespace' => 'Էջ',
	'proofreadpage_index_namespace' => 'Ինդեքս',
	'proofreadpage_image' => 'պատկեր',
	'proofreadpage_index' => 'Ինդեքս',
	'proofreadpage_index_expected' => 'Սխալ. ինդեքս չհայտնաբերվեց',
	'proofreadpage_nosuch_index' => 'Սխալ. այդպիսի ինդեքս չկա',
	'proofreadpage_nosuch_file' => 'Սխալ. այդպիսի ֆայլ չկա',
	'proofreadpage_badpage' => 'Սխալ ֆորմատ',
	'proofreadpage_badpagetext' => 'Հիշվող էջի սխալ ֆորմատ։',
	'proofreadpage_indexdupe' => 'Կրկնակի հղում',
	'proofreadpage_indexdupetext' => 'Էջերը չեն կարող ներառվել ինդեքս էջում մեկից ավել անգամ։',
	'proofreadpage_nologin' => 'Չեք մտել համակարգ',
	'proofreadpage_nologintext' => 'Էջերի սրբագրման կարգավիճակը փոխելու համար անհրաժեշտ է [[Special:UserLogin|մտնել համակարգ]]։',
	'proofreadpage_notallowed' => 'Փոփոխությունը չի թույլատրվում',
	'proofreadpage_notallowedtext' => 'Դուք չեք կարող փոխել այս էջի սրբագրման կարգավիճակը։',
	'proofreadpage_number_expected' => 'Սխալ. սպասվում է թվային արժեք',
	'proofreadpage_interval_too_large' => 'Սխալ. չափից մեծ միջակայք',
	'proofreadpage_invalid_interval' => 'Սխալ. անվավեր միջակայք',
	'proofreadpage_nextpage' => 'Հաջորդ էջ',
	'proofreadpage_prevpage' => 'Նախորդ էջ',
	'proofreadpage_header' => 'Վերնագիր (չի ներառվում).',
	'proofreadpage_body' => 'Էջի մարմին (ներառվելու է).',
	'proofreadpage_footer' => 'Ստորագիր (չի ներառվում)',
	'proofreadpage_toggleheaders' => 'ցուցադրել չներառվող բաժինները',
	'proofreadpage_quality0_category' => 'Առանց տեքստ',
	'proofreadpage_quality1_category' => 'Չսրբագրված',
	'proofreadpage_quality2_category' => 'Խնդրահարույց',
	'proofreadpage_quality3_category' => 'Սրբագրված',
	'proofreadpage_quality4_category' => 'Հաստատված',
	'proofreadpage_quality0_message' => 'Այս էջը սրբագրման կարիք չունի',
	'proofreadpage_quality1_message' => 'Այս էջը սրբագրված չէ',
	'proofreadpage_quality2_message' => 'Սխալ առաջացավ էջը սրբագրելիս',
	'proofreadpage_quality3_message' => 'Այս էջը սրբագրված է',
	'proofreadpage_quality4_message' => 'Այս էջը հաստատված է',
	'proofreadpage_index_listofpages' => 'Էջերի ցանկ',
	'proofreadpage_image_message' => 'Հղում ինդեքսի էջին',
	'proofreadpage_page_status' => 'Էջի կարգավիճակ',
	'proofreadpage_js_attributes' => 'Հեղինակ Անվանում Տարի Հրատարակություն',
	'proofreadpage_index_attributes' => 'Author|Հեղինակ
Title|Անվանում
Year|Հրատարակման տարեթիվ
Publisher|Հրատարակություն
Source|Աղբյուր
Image|Կազմի պատկեր
Pages|Էջեր|20
Remarks|Նշումներ|10',
	'proofreadpage_pages' => '{{PLURAL:$1|էջ|էջ}}',
	'proofreadpage_specialpage_legend' => 'Որոնել ինդեքս էջեր',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'indexpages' => 'Lista de paginas indice',
	'proofreadpage_desc' => 'Facilita le comparation inter un texto e su scan original',
	'proofreadpage_namespace' => 'Pagina',
	'proofreadpage_index_namespace' => 'Indice',
	'proofreadpage_image' => 'imagine',
	'proofreadpage_index' => 'Indice',
	'proofreadpage_index_expected' => 'Error: indice expectate',
	'proofreadpage_nosuch_index' => 'Error: non existe tal indice',
	'proofreadpage_nosuch_file' => 'Error: non existe tal file',
	'proofreadpage_badpage' => 'Formato incorrecte',
	'proofreadpage_badpagetext' => 'Le formato del pagina que tu tentava immagazinar es incorrecte.',
	'proofreadpage_indexdupe' => 'Ligamine duplicate',
	'proofreadpage_indexdupetext' => 'Paginas non pote figurar plus de un vice in un pagina de indice.',
	'proofreadpage_nologin' => 'Non identificate',
	'proofreadpage_nologintext' => 'Tu debe [[Special:UserLogin|aperir un session]] pro modificar le stato de correction de paginas.',
	'proofreadpage_notallowed' => 'Cambio non permittite',
	'proofreadpage_notallowedtext' => 'Tu non ha le permission de cambiar le stato de correction de iste pagina.',
	'proofreadpage_number_expected' => 'Error: valor numeric expectate',
	'proofreadpage_interval_too_large' => 'Error: intervallo troppo grande',
	'proofreadpage_invalid_interval' => 'Error: intervallo invalide',
	'proofreadpage_nextpage' => 'Pagina sequente',
	'proofreadpage_prevpage' => 'Pagina precedente',
	'proofreadpage_header' => 'Capite (noinclude):',
	'proofreadpage_body' => 'Corpore del pagina (pro esser transcludite):',
	'proofreadpage_footer' => 'Pede (noinclude):',
	'proofreadpage_toggleheaders' => 'cambiar le visibilitate del sectiones noinclude',
	'proofreadpage_quality0_category' => 'Sin texto',
	'proofreadpage_quality1_category' => 'Non corrigite',
	'proofreadpage_quality2_category' => 'Problematic',
	'proofreadpage_quality3_category' => 'Corrigite',
	'proofreadpage_quality4_category' => 'Validate',
	'proofreadpage_quality0_message' => 'Iste pagina non ha besonio de esser corrigite',
	'proofreadpage_quality1_message' => 'Iste pagina non ha essite corrigite',
	'proofreadpage_quality2_message' => 'Il habeva un problema durante le correction de iste pagina',
	'proofreadpage_quality3_message' => 'Iste pagina ha essite corrigite',
	'proofreadpage_quality4_message' => 'Iste pagina ha essite validate',
	'proofreadpage_index_listofpages' => 'Lista de paginas',
	'proofreadpage_image_message' => 'Ligamine verso le pagina de indice',
	'proofreadpage_page_status' => 'Stato del pagina',
	'proofreadpage_js_attributes' => 'Autor Titulo Anno Editor',
	'proofreadpage_index_attributes' => 'Autor
Titulo
Anno|Anno de publication
Editor
Origine
Imagine|Imagine de copertura
Paginas||20
Notas||10',
	'proofreadpage_pages' => '{{PLURAL:$1|pagina|paginas}}',
	'proofreadpage_specialpage_legend' => 'Cercar in paginas de indice',
	'proofreadpage_source' => 'Fonte',
	'proofreadpage_source_message' => 'Le original scannate usate pro crear iste texto',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'indexpages' => 'Daftar dari halaman indeks',
	'proofreadpage_desc' => 'Memungkinkan perbandingan mudah teks dengan hasil pemindaian orisinal',
	'proofreadpage_namespace' => 'Halaman',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'gambar',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Kesalahan : diperlukan indeks',
	'proofreadpage_nosuch_index' => 'Kesalahan: tidak ada indeks',
	'proofreadpage_nosuch_file' => 'Kesalahan: tidak ada file',
	'proofreadpage_badpage' => 'Kesalahan Format',
	'proofreadpage_badpagetext' => 'Format halaman yang akan anda simpan, salah.',
	'proofreadpage_indexdupe' => 'Gandakan pranala',
	'proofreadpage_indexdupetext' => 'Halaman tidak dapat di daftarkan lebih dari sekali di halaman indek.',
	'proofreadpage_nologin' => 'Belum masuk log',
	'proofreadpage_nologintext' => 'Anda harus [[Special:UserLogin|masuk log]] untuk mengubah status koreksi halaman.',
	'proofreadpage_notallowed' => 'Perubahan tidak diperbolehkan',
	'proofreadpage_notallowedtext' => 'Anda tidak diperbolehkan untuk mengubah status koreksi di halaman ini.',
	'proofreadpage_number_expected' => 'Kesalahan: nilai angka diharapkan',
	'proofreadpage_interval_too_large' => 'Kesalahan:Interval terlalu besar',
	'proofreadpage_invalid_interval' => 'Kesalahan: Interval tidak sah',
	'proofreadpage_nextpage' => 'Halaman selanjutnya',
	'proofreadpage_prevpage' => 'Halaman sebelumnya',
	'proofreadpage_header' => 'Kepala (noinclude):',
	'proofreadpage_body' => 'Badan halaman (untuk ditransklusikan):',
	'proofreadpage_footer' => 'Kaki (noinclude):',
	'proofreadpage_toggleheaders' => 'ganti keterlihatan bagian noinclude',
	'proofreadpage_quality0_category' => 'Tanpa teks',
	'proofreadpage_quality1_category' => 'Belum diuji-baca',
	'proofreadpage_quality2_category' => 'Bermasalah',
	'proofreadpage_quality3_category' => 'Diuji-baca',
	'proofreadpage_quality4_category' => 'Divalidasi',
	'proofreadpage_quality0_message' => 'Halaman ini tidak perlu dikoreksi',
	'proofreadpage_quality1_message' => 'Halaman ini belum dikoreksi',
	'proofreadpage_quality2_message' => 'Ada masalah ketika mengoreksi halaman ini',
	'proofreadpage_quality3_message' => 'Halaman ini telah dikoreksi',
	'proofreadpage_quality4_message' => 'Halaman ini telah divalidasi',
	'proofreadpage_index_listofpages' => 'Daftar halaman',
	'proofreadpage_image_message' => 'Pranala ke halaman indeks',
	'proofreadpage_page_status' => 'Status halaman',
	'proofreadpage_js_attributes' => 'Pengarang Judul Tahun Penerbit',
	'proofreadpage_index_attributes' => 'Pengarang
Judul
Tahun|Tahun penerbitan
Penerbit
Sumber
Gambar|Gambar sampul
Halaman||20
Catatan||10',
	'proofreadpage_pages' => '{{PLURAL:$1|halaman|halaman}}',
	'proofreadpage_specialpage_legend' => 'Pencarian halaman indek',
	'proofreadpage_source' => 'Sumber',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'proofreadpage_namespace' => 'Pagino',
	'proofreadpage_index_namespace' => 'Indexo',
	'proofreadpage_image' => 'imajo',
	'proofreadpage_index' => 'Indexo',
	'proofreadpage_nextpage' => 'Sequanta pagino',
	'proofreadpage_prevpage' => 'Antea pagino',
	'proofreadpage_index_listofpages' => 'Pagino-listo',
	'proofreadpage_page_status' => 'Stando di pagino',
	'proofreadpage_pages' => '{{PLURAL:$1|pagino|pagini}}',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'proofreadpage_namespace' => 'Síða',
	'proofreadpage_image' => 'mynd',
	'proofreadpage_nextpage' => 'Næsta síða',
	'proofreadpage_prevpage' => 'Fyrri síða',
	'proofreadpage_index_listofpages' => 'Listi yfir síður',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Gianfranco
 * @author Stefano-c
 */
$messages['it'] = array(
	'indexpages' => 'Elenco delle pagine di indice',
	'proofreadpage_desc' => 'Consente un facile confronto tra un testo e la sua scansione originale',
	'proofreadpage_namespace' => 'Pagina',
	'proofreadpage_index_namespace' => 'Indice',
	'proofreadpage_image' => 'immagine',
	'proofreadpage_index' => 'Indice',
	'proofreadpage_index_expected' => 'Errore: previsto indice',
	'proofreadpage_nosuch_index' => 'Errore: indice non presente',
	'proofreadpage_nosuch_file' => 'Errore: file non presente',
	'proofreadpage_badpage' => 'Formato errato',
	'proofreadpage_badpagetext' => 'Il formato della pagina che si è tentato di salvare non è corretto.',
	'proofreadpage_indexdupe' => 'Collegamento duplicato',
	'proofreadpage_indexdupetext' => 'Le pagine non possono essere elencate più di una volta su una pagina di indice.',
	'proofreadpage_nologin' => 'Accesso non effettuato',
	'proofreadpage_nologintext' => "Per modificare lo stato di verifica delle pagine, è necessario aver effettuato [[Special:UserLogin|l'accesso]].",
	'proofreadpage_notallowed' => 'Modifica non consentita',
	'proofreadpage_notallowedtext' => 'Non sei autorizzato a modificare lo stato di verifica di questa pagina.',
	'proofreadpage_number_expected' => 'Errore: previsto valore numerico',
	'proofreadpage_interval_too_large' => 'Errore: intervallo troppo ampio',
	'proofreadpage_invalid_interval' => 'Errore: intervallo non valido',
	'proofreadpage_nextpage' => 'Pagina successiva',
	'proofreadpage_prevpage' => 'Pagina precedente',
	'proofreadpage_header' => 'Intestazione (non inclusa):',
	'proofreadpage_body' => 'Corpo della pagina (da includere):',
	'proofreadpage_footer' => 'Piè di pagina (non incluso)',
	'proofreadpage_toggleheaders' => 'attiva/disattiva la visibilità delle sezioni non incluse',
	'proofreadpage_quality0_category' => 'Senza testo',
	'proofreadpage_quality1_category' => 'Da correggere',
	'proofreadpage_quality2_category' => 'Da rivedere',
	'proofreadpage_quality3_category' => 'Corretta',
	'proofreadpage_quality4_category' => 'Verificata',
	'proofreadpage_quality4_message' => 'Questa pagina è stata convalidata',
	'proofreadpage_index_listofpages' => 'Lista delle pagine',
	'proofreadpage_image_message' => 'Collegamento alla pagina indice',
	'proofreadpage_page_status' => 'Status della pagina',
	'proofreadpage_js_attributes' => 'Autore Titolo Anno Editore',
	'proofreadpage_index_attributes' => 'Autore
Titolo
Anno|Anno di pubblicazione
Editore
Fonte
Immagine|Immagine di copertina
Pagine||20
Note||10',
	'proofreadpage_pages' => '{{PLURAL:$1|pagina|pagine}}',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author JtFuruhata
 * @author 青子守歌
 */
$messages['ja'] = array(
	'indexpages' => '文献概要ページの一覧',
	'proofreadpage_desc' => 'オリジナルのスキャン画像とテキストとの比較を容易にする',
	'proofreadpage_namespace' => 'ページ',
	'proofreadpage_index_namespace' => '文献概要',
	'proofreadpage_image' => 'スキャン画像',
	'proofreadpage_index' => '文献概要',
	'proofreadpage_index_expected' => 'エラー: 文献概要があるべきです',
	'proofreadpage_nosuch_index' => 'エラー: そのような文献概要はありません',
	'proofreadpage_nosuch_file' => 'エラー: そのようなファイルはありません',
	'proofreadpage_badpage' => '不正な形式',
	'proofreadpage_badpagetext' => '保存しようとしたページの形式が正しくありません。',
	'proofreadpage_indexdupe' => '重複したリンク',
	'proofreadpage_indexdupetext' => '文献概要ページ上にページを複数回載せることはできません。',
	'proofreadpage_nologin' => 'ログインしていない',
	'proofreadpage_nologintext' => 'ページの校正状況を修正するためには[[Special:UserLogin|ログイン]]しなければなりません。',
	'proofreadpage_notallowed' => '変更が許可されていません',
	'proofreadpage_notallowedtext' => 'あなたにはこのページの校正状況を変更することが許可されていません。',
	'proofreadpage_number_expected' => 'エラー: 数値がくるべきです',
	'proofreadpage_interval_too_large' => 'エラー: 間隔が大きすぎます',
	'proofreadpage_invalid_interval' => 'エラー: 間隔が無効です',
	'proofreadpage_nextpage' => '次のページ',
	'proofreadpage_prevpage' => '前のページ',
	'proofreadpage_header' => 'ヘッダ(埋め込み対象外):',
	'proofreadpage_body' => 'ページ本体(埋め込み参照の対象):',
	'proofreadpage_footer' => 'フッタ(埋め込み対象外):',
	'proofreadpage_toggleheaders' => '埋め込み対象外項目の表示切替',
	'proofreadpage_quality0_category' => '文章なし',
	'proofreadpage_quality1_category' => '未校正',
	'proofreadpage_quality2_category' => '問題あり',
	'proofreadpage_quality3_category' => '校正済',
	'proofreadpage_quality4_category' => '検証済',
	'proofreadpage_quality0_message' => 'このページは校正する必要がありません',
	'proofreadpage_quality1_message' => 'このページはまだ校正されていません',
	'proofreadpage_quality2_message' => 'このページを校正するときに問題が発生しました',
	'proofreadpage_quality3_message' => 'このページは校正済みです',
	'proofreadpage_quality4_message' => 'このページは検証済みです',
	'proofreadpage_index_listofpages' => 'ページの一覧',
	'proofreadpage_image_message' => '文献概要ページへ',
	'proofreadpage_page_status' => '校正状況',
	'proofreadpage_js_attributes' => '著者 書名 出版年 出版元',
	'proofreadpage_index_attributes' => '著者
書名
出版年|出版年
出版元
引用元
画像|表紙画像
ページ||20
注釈||10',
	'proofreadpage_pages' => '{{PLURAL:$1|ページ|ページ}}',
	'proofreadpage_specialpage_legend' => '文献概要ページを検索',
	'proofreadpage_source' => '引用元',
	'proofreadpage_source_message' => 'このテキストを構築するのに使用したスキャン元の版',
);

/** Jutish (Jysk)
 * @author Huslåke
 * @author Ælsån
 */
$messages['jut'] = array(
	'proofreadpage_desc' => 'Kan semple ándrenger der tekst til æ original sken',
	'proofreadpage_namespace' => 'Ertikel',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'billet',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_nextpage' => 'Følgende pæge',
	'proofreadpage_prevpage' => 'Førge pæge',
	'proofreadpage_header' => 'Åverskreft (noinclude):',
	'proofreadpage_body' => 'Pæge kåm (til være transkluded):',
	'proofreadpage_footer' => 'Fåt (noinclude):',
	'proofreadpage_toggleheaders' => 'toggle noinclude seksje sænhvårdeghed',
	'proofreadpage_quality1_category' => 'Ekke sæn',
	'proofreadpage_quality2_category' => 'Pråblæmåtisk',
	'proofreadpage_quality3_category' => 'Sæn',
	'proofreadpage_quality4_category' => 'Vålidærn',
	'proofreadpage_index_listofpages' => 'Liste der pæger',
	'proofreadpage_image_message' => 'Link til æ indeks pæge',
	'proofreadpage_page_status' => 'Pægeståt',
	'proofreadpage_js_attributes' => 'Skrever Titel År Udgæver',
	'proofreadpage_index_attributes' => 'Skrever
Titel
År|År der publikåsje
Udgæver
Sårs
Billet|Førkåntsbillet
Strøk||20
Anmarker||10',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'proofreadpage_desc' => "Supaya prabandhingan karo asliné sing di-''scan'' luwih gampang",
	'proofreadpage_namespace' => 'Kaca',
	'proofreadpage_index_namespace' => 'Indèks',
	'proofreadpage_image' => 'gambar',
	'proofreadpage_index' => 'Indèks',
	'proofreadpage_nextpage' => 'Kaca sabanjuré',
	'proofreadpage_prevpage' => 'Kaca sadurungé',
	'proofreadpage_header' => 'Sesirah (noinclude):',
	'proofreadpage_body' => 'Awak kaca (kanggo transklusi):',
	'proofreadpage_footer' => 'Tulisan sikil (noinclude):',
	'proofreadpage_toggleheaders' => 'ganti visibilitas (kakatonan) bagéyan noinclude',
	'proofreadpage_quality1_category' => 'Durung dikorèksi tulisané',
	'proofreadpage_quality2_category' => 'Problématis',
	'proofreadpage_quality3_category' => 'Korèksi tulisan',
	'proofreadpage_quality4_category' => 'Diabsahaké',
	'proofreadpage_index_listofpages' => 'Daftar kaca',
	'proofreadpage_image_message' => 'Pranala menyang kaca indèks',
	'proofreadpage_page_status' => 'Status kaca',
	'proofreadpage_js_attributes' => 'Pangripta Irah-irahan Taun Panerbit',
	'proofreadpage_index_attributes' => 'Pangripta
Irah-irahan
Taun|Taun olèhe mbabar
Panerbit
Sumber
Gambar|Gambar samak
Kaca||20
Cathetan||10',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Malafaya
 * @author Sopho
 */
$messages['ka'] = array(
	'proofreadpage_namespace' => 'გვერდი',
	'proofreadpage_index_namespace' => 'ინდექსი',
	'proofreadpage_image' => 'სურათი',
	'proofreadpage_index' => 'ინდექსი',
	'proofreadpage_badpage' => 'არასწორი ფორმატი',
	'proofreadpage_indexdupe' => 'დუბლიკატი ბმული',
	'proofreadpage_nologin' => 'შესვლა არ მომხდარა',
	'proofreadpage_notallowed' => 'ცვლილებები არაა დაშვებული',
	'proofreadpage_nextpage' => 'შემდეგი გვერდი',
	'proofreadpage_prevpage' => 'წინა გვერდი',
	'proofreadpage_quality0_category' => 'ტექსტის გარეშე',
	'proofreadpage_quality2_category' => 'პრობლემატური',
	'proofreadpage_index_listofpages' => 'გვერდების სია',
	'proofreadpage_page_status' => 'გვერდის სტატუსი',
	'proofreadpage_index_attributes' => 'ავტორი
სათაური
წელი|გამოცემის წელი
გამომცემელი
წყარო
გამოსახულება|ყდის გამოსახულება
გვერდები||20
შენიშვნები||10',
	'proofreadpage_pages' => '{{PLURAL:$1|გვერდი|გვერდები}}',
	'proofreadpage_source' => 'წყარო',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'proofreadpage_namespace' => 'ទំព័រ',
	'proofreadpage_index_namespace' => 'លិបិក្រម',
	'proofreadpage_image' => 'រូបភាព',
	'proofreadpage_index' => 'លិបិក្រម',
	'proofreadpage_badpage' => 'ទម្រង់​/ប្រភេទ មិនត្រឹមត្រូវ​​',
	'proofreadpage_indexdupe' => 'ចម្លងស្ទួន តំណ​ភ្ជាប់',
	'proofreadpage_nextpage' => 'ទំព័របន្ទាប់',
	'proofreadpage_prevpage' => 'ទំព័រមុន',
	'proofreadpage_header' => 'បឋមកថា(មិនរួមបញ្ចូល)៖',
	'proofreadpage_footer' => 'បាតកថា(មិនរួមបញ្ចូល)៖',
	'proofreadpage_quality0_category' => 'ដោយ​មិន​មាន​អក្សរ​',
	'proofreadpage_quality1_category' => 'មិន​មើលកែ',
	'proofreadpage_quality2_category' => 'មានបញ្ហា',
	'proofreadpage_quality3_category' => 'មើលកែ',
	'proofreadpage_quality4_category' => 'បាន​ធ្វើឱ្យមានសុពលភាព',
	'proofreadpage_index_listofpages' => 'បញ្ជីទំព័រ',
	'proofreadpage_image_message' => 'ភ្ជាប់ទៅទំព័រលិបិក្រម',
	'proofreadpage_page_status' => 'ស្ថានភាព ទំព័រ',
	'proofreadpage_js_attributes' => 'អ្នកនិពន្ធ ចំណងជើង ឆ្នាំបោះពុម្ព រោងពុម្ព',
	'proofreadpage_index_attributes' => 'អ្នកនិពន្ឋ
ចំណងជើង
ឆ្នាំ|ឆ្នាំបោះពុម្ព
គ្រឹះស្ថានបោះពុម្ព
ប្រភព
រូបភាព|រូបភាពលើក្រប
ទំព័រ||២០
កំណត់សម្គាល់||១០',
);

/** Korean (한국어)
 * @author Ilovesabbath
 * @author Klutzy
 * @author Kwj2772
 * @author Pakman
 * @author ToePeu
 * @author Yknok29
 */
$messages['ko'] = array(
	'proofreadpage_desc' => '최초 스캔과 텍스트를 쉽게 비교할 수 있게 함',
	'proofreadpage_namespace' => '문서',
	'proofreadpage_index_namespace' => '목차',
	'proofreadpage_image' => '그림',
	'proofreadpage_index' => '목차',
	'proofreadpage_nosuch_file' => '오류: 해당 파일이 없습니다.',
	'proofreadpage_badpage' => '잘못된 형식',
	'proofreadpage_indexdupe' => '중복된 링크',
	'proofreadpage_nologin' => ' 로그인된 상태가 아닙니다.',
	'proofreadpage_nologintext' => '문서의 검토 상태를 변경하려면 [[Special:UserLogin|로그인]]해야 합니다.',
	'proofreadpage_notallowed' => '이 문서는 변경이 불가능합니다.',
	'proofreadpage_notallowedtext' => '이 문서의 교정 상태를 바꿀 수 없습니다.',
	'proofreadpage_nextpage' => '다음 페이지',
	'proofreadpage_prevpage' => '이전 페이지',
	'proofreadpage_header' => '머리말 (표시안함):',
	'proofreadpage_body' => '본문 (트랜스클루전):',
	'proofreadpage_footer' => '꼬리말 (표시안함):',
	'proofreadpage_toggleheaders' => '표시안함 부분의 표시 여부 선택',
	'proofreadpage_quality0_category' => '비었음',
	'proofreadpage_quality1_category' => '교정 안됨',
	'proofreadpage_quality2_category' => '문제 있음',
	'proofreadpage_quality3_category' => '교정',
	'proofreadpage_quality4_category' => '확인됨',
	'proofreadpage_quality0_message' => '이 페이지는 교정할 필요가 없습니다.',
	'proofreadpage_index_listofpages' => '문서 목록',
	'proofreadpage_image_message' => '목차 페이지로',
	'proofreadpage_page_status' => '문서 상태',
	'proofreadpage_js_attributes' => '저자 제목 출판년도 출판사',
	'proofreadpage_index_attributes' => '저자
제목
연도|출판년도
출판사
출처
그림|표지 그림
쪽수||20
주석||10',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'proofreadpage_namespace' => 'Pahina',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'indexpages' => 'Leß met de Verzeischneß_Sigge',
	'proofreadpage_desc' => 'Määt et müjjelesch, bequem der Täx mem enjeskännte Ojinaal ze verjliische.',
	'proofreadpage_namespace' => 'Sigg',
	'proofreadpage_index_namespace' => 'Enhallt',
	'proofreadpage_image' => 'Beld',
	'proofreadpage_index' => 'Verzeischneß',
	'proofreadpage_index_expected' => 'Fähler: En Enndraachsnummer (ene Indäx) weet jebruch',
	'proofreadpage_nosuch_index' => 'Fähler: Esu en Enndraachsnummer (esu ene Indäx) jidd_et nit',
	'proofreadpage_nosuch_file' => 'Fähler: esu en Dattei ham_mer nit',
	'proofreadpage_badpage' => 'Verhiehrt Fommaat',
	'proofreadpage_badpagetext' => 'Dat Fommaat vun dä Sigg, di De jrahdt afzeshpeischere versöhk häß, eß verkiehert.',
	'proofreadpage_indexdupe' => 'Dubbelte Lengk',
	'proofreadpage_indexdupetext' => 'Sigge künne nit mieh wi eijmohl en en Verzeischneß_Sigg opdouche.',
	'proofreadpage_nologin' => 'Nit enjelogk',
	'proofreadpage_nologintext' => 'Do möötß ald [[Special:UserLogin|enjelogg]] sin, öm dä {{int:proofreadpage_page_status}} hee ze ändere.',
	'proofreadpage_notallowed' => 'Dat Ändere es nit zohjelohße',
	'proofreadpage_notallowedtext' => 'Do häs nit et Rääsch, heh dä {{int:proofreadpage_page_status}} ze ändere.',
	'proofreadpage_number_expected' => 'Fähler: En Zahl weet jebruch',
	'proofreadpage_interval_too_large' => 'Fähler: Dä Affschtand es zoh jruuß',
	'proofreadpage_invalid_interval' => 'Fähler: Dä Afshtand es nit jöltesch',
	'proofreadpage_nextpage' => 'Näx Sigg',
	'proofreadpage_prevpage' => 'Vörije Sigg',
	'proofreadpage_header' => 'Sigge-Kopp (<i lang="en">noinclude</i>):',
	'proofreadpage_body' => 'Tex op dä Sigg (för enzfööje):',
	'proofreadpage_footer' => 'Sigge-Fohß (<i lang="en">noinclude</i>):',
	'proofreadpage_toggleheaders' => '<i lang="en">Noinclude</i>-Afschnedde en- un ußblende',
	'proofreadpage_quality0_category' => 'Leddisch',
	'proofreadpage_quality1_category' => 'Unjeprööf',
	'proofreadpage_quality2_category' => 'Problemscher',
	'proofreadpage_quality3_category' => 'Nohjelässe',
	'proofreadpage_quality4_category' => 'Fäädesch jepröhf',
	'proofreadpage_quality0_message' => 'Heh di Sigg moß nit jeääjejelässe wääde',
	'proofreadpage_quality1_message' => 'Heh di Sigg woodt nit jeääjejelässe',
	'proofreadpage_quality2_message' => 'Beim Jeääjelässe för heh di Sigg eß jät opjevalle',
	'proofreadpage_quality3_message' => 'Heh di Sigg woodt jeääjejelässe',
	'proofreadpage_quality4_message' => 'Heh di Sigg es jeääjejelässe un joot',
	'proofreadpage_index_listofpages' => 'SiggeLeß',
	'proofreadpage_image_message' => 'Lengk op en Verzeischneß_Sigg',
	'proofreadpage_page_status' => 'Siggestattus',
	'proofreadpage_js_attributes' => 'Schriver Tittel Johr Verlaach',
	'proofreadpage_index_attributes' => 'Schriver
Tittel
Johr|ÄscheinungsJohr
Verlaach
Quell
Beld|Beld om Ömschlach
Sigge||20
Aanmerkunge||10',
	'proofreadpage_pages' => '{{PLURAL:$1|Ei&nbsp;Sigg|$1&nbsp;Sigge|Kei&nbsp;Sigg}}',
	'proofreadpage_specialpage_legend' => 'Op dä Verzeischneßsigg söhke',
);

/** Cornish (Kernowek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'proofreadpage_namespace' => 'Folen',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'proofreadpage_namespace' => 'Pagina',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'indexpages' => 'Lëscht vun Index-Säiten',
	'proofreadpage_desc' => 'Erlaabt et op eng einfach Manéier den Text mat der Originalscan ze vergLäichen',
	'proofreadpage_namespace' => 'Säit',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'Bild',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Feeler: Index erwaart',
	'proofreadpage_nosuch_index' => 'Feeler: et gëtt keen esou een Index',
	'proofreadpage_nosuch_file' => 'Feeler: de Fichier gëtt et net',
	'proofreadpage_badpage' => 'Falsche Format',
	'proofreadpage_badpagetext' => "De Format vun der Säit déi Dir versicht hutt z'änneren ass net korrekt.",
	'proofreadpage_indexdupe' => 'Duebele Link',
	'proofreadpage_indexdupetext' => 'Säite kënnen net méi wéi eemol op eng Index-Säit gesat ginn.',
	'proofreadpage_nologin' => 'Net ageloggt',
	'proofreadpage_nologintext' => "Dir musst [[Special:UserLogin|ageloggt]] si fir de Status vum Iwwerliese vu Säiten z'änneren.",
	'proofreadpage_notallowed' => 'Ännerung net erlaabt',
	'proofreadpage_notallowedtext' => "Dir sidd net berechtigt de Status vum Iwwerliese vun dëser Säit z'änneren.",
	'proofreadpage_number_expected' => 'Feeler: et gof en numerische Wert erwaart',
	'proofreadpage_interval_too_large' => 'Feeler: Intervall ze ze grouss',
	'proofreadpage_invalid_interval' => 'Feeler: net valabelen Intervall',
	'proofreadpage_nextpage' => 'Nächst Säit',
	'proofreadpage_prevpage' => 'Säit virdrun',
	'proofreadpage_header' => 'Entête (noinclude):',
	'proofreadpage_body' => 'Inhalt vun der Säit (Transklusioun):',
	'proofreadpage_footer' => 'Foussnote (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude-Abschnitter an- resp. ausblenden',
	'proofreadpage_quality0_category' => 'Ouni Text',
	'proofreadpage_quality1_category' => 'Net verbessert',
	'proofreadpage_quality2_category' => 'Problematesch',
	'proofreadpage_quality3_category' => 'Verbessert',
	'proofreadpage_quality4_category' => 'Validéiert',
	'proofreadpage_quality0_message' => 'Dës Säit brauch net iwwerliest ze ginn',
	'proofreadpage_quality1_message' => 'Dës Säit gouf net iwwerliest',
	'proofreadpage_quality2_message' => 'Et gouf e Problem beim iwwereliese vun dëser Säit',
	'proofreadpage_quality3_message' => 'Dës Säit gouf iwwerliest',
	'proofreadpage_quality4_message' => 'Dës Säit gouf validéiert',
	'proofreadpage_index_listofpages' => 'Säitelëscht',
	'proofreadpage_image_message' => "Link op d'Indexsäit",
	'proofreadpage_page_status' => 'Status vun der Säit',
	'proofreadpage_js_attributes' => 'Auteur Titel Joer Editeur',
	'proofreadpage_index_attributes' => 'Auteur
Titel
Joer|Joer vun der Publikatioun
Eiteur
Quell
Bild|Titelbild
Säiten||20
Bemierkungen||10',
	'proofreadpage_pages' => '{{PLURAL:$1|Säit|Säiten}}',
	'proofreadpage_specialpage_legend' => 'An den Index-Säite sichen',
	'proofreadpage_source' => 'Quell',
	'proofreadpage_source_message' => 'Gescannten Editioun déi benotzt gouf fir dësen Text ze schreiwen',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'proofreadpage_namespace' => 'Paje',
	'proofreadpage_image' => 'imaje',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'proofreadpage_desc' => "Maak 't meugelik teks eenvoudig te vergelieke mit de oorsjpronkelike scan",
	'proofreadpage_namespace' => 'Pazjena',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'aafbeilding',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_nextpage' => 'Volgendje pazjena',
	'proofreadpage_prevpage' => 'Vörge pazjena',
	'proofreadpage_header' => 'Kopteks (gein inclusie):',
	'proofreadpage_body' => 'Broeadteks (veur transclusie):',
	'proofreadpage_footer' => 'Vootteks (gein inclusie):',
	'proofreadpage_toggleheaders' => 'zichbaarheid elemente zónger transclusie wiezige',
	'proofreadpage_quality1_category' => 'Ónbewèrk',
	'proofreadpage_quality2_category' => 'Ónvolledig',
	'proofreadpage_quality3_category' => 'Proofgelaeze',
	'proofreadpage_quality4_category' => 'Gekonterleerdj',
	'proofreadpage_index_listofpages' => "Lies van pazjena's",
	'proofreadpage_image_message' => 'Verwieziging nao de indekspaasj',
	'proofreadpage_page_status' => 'Pazjenastatus',
	'proofreadpage_js_attributes' => 'Auteur Titel Jaor Oetgaever',
	'proofreadpage_index_attributes' => "Auteur
Titel
Jaor|Jaor van publicatie
Oetgaever
Brón
Aafbeilding|Ómslaag
Pazjena's||20
Opmèrkinge||10",
);

/** Lumbaart (Lumbaart)
 * @author Dakrismeno
 */
$messages['lmo'] = array(
	'proofreadpage_nextpage' => 'Pagina inanz',
	'proofreadpage_prevpage' => 'Pagina indree',
	'proofreadpage_header' => 'Intestazion (minga inclüsa)',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'indexpages' => 'Indeksuotų puslapių sąrašas',
	'proofreadpage_desc' => 'Galima lengvai palyginti tekstą su originaliu',
	'proofreadpage_namespace' => 'Puslapis',
	'proofreadpage_index_namespace' => 'Indeksas',
	'proofreadpage_image' => 'paveikslėlis',
	'proofreadpage_index' => 'Indeksas',
	'proofreadpage_index_expected' => 'Klaida: indeksas laukiamas',
	'proofreadpage_nosuch_index' => 'Klaida: nėra tokio indekso',
	'proofreadpage_nosuch_file' => 'Klaida: nėra tokio failo',
	'proofreadpage_badpage' => 'Neteisingas formatas',
	'proofreadpage_badpagetext' => 'Puslapio, kurį bandėte išsaugoti, formatas yra neteisingas.',
	'proofreadpage_indexdupe' => 'Dublikuoti nuorodą',
	'proofreadpage_indexdupetext' => 'Puslapiai negali būti pateikiami daugiau kaip kartą pagrindiniame puslapyje.',
	'proofreadpage_nologin' => 'Neprisijungta',
	'proofreadpage_nologintext' => 'Jūs turite būti [[Special:UserLogin|prisijungęs]], norėdamas keisti puslapių statusą.',
	'proofreadpage_notallowed' => 'Keisti neleidžiama',
	'proofreadpage_notallowedtext' => 'Jums neleidžiama pakeisti šio puslapio statuso.',
	'proofreadpage_number_expected' => 'Klaida: tikėtasi skaitinės vertės',
	'proofreadpage_interval_too_large' => 'Klaida: intervalas per didelis',
	'proofreadpage_invalid_interval' => 'Klaida: neteisingas intervalas',
	'proofreadpage_nextpage' => 'Kitas puslapis',
	'proofreadpage_prevpage' => 'Ankstesnis puslapis',
	'proofreadpage_header' => 'Antraštė (neįskaitoma):',
	'proofreadpage_body' => 'Puslapio pagrindas (perkeliamas):',
	'proofreadpage_footer' => 'Poraštė (neįskaitoma):',
	'proofreadpage_toggleheaders' => 'įjungti neįskaitytų sekcijų matomumą',
	'proofreadpage_quality0_category' => 'Be teksto',
	'proofreadpage_quality1_category' => 'Neperžiūrėtas',
	'proofreadpage_quality2_category' => 'Problemiškas',
	'proofreadpage_quality3_category' => 'Peržiūrėtas',
	'proofreadpage_quality4_category' => 'Patvirtintas',
	'proofreadpage_quality0_message' => 'Šis puslapis neturi būti peržiūrėtas',
	'proofreadpage_quality1_message' => 'Šis puslapis nebuvo peržiūrėtas',
	'proofreadpage_quality2_message' => 'Iškilo problema kai buvo peržiūrimas šis puslapis',
	'proofreadpage_quality3_message' => 'Šis puslapis buvo peržiūrėtas',
	'proofreadpage_quality4_message' => 'Šis puslapis buvo patvirtintas',
	'proofreadpage_index_listofpages' => 'Puslapių sąrašas',
	'proofreadpage_image_message' => 'Nuoroda į pagrindinį puslapį',
	'proofreadpage_page_status' => 'Puslapio statusas',
	'proofreadpage_js_attributes' => 'Autorius Pavadinimas Metai Publikuotojas',
	'proofreadpage_index_attributes' => 'Autorius
Pavadinimas
Metai|Išleidimo metai
Leidėjas
Šaltinis
Paveikslėlis|Viršelis
Puslapiai||20
Pastabos||10',
);

/** Latvian (Latviešu)
 * @author Xil
 * @author Yyy
 */
$messages['lv'] = array(
	'proofreadpage_namespace' => 'Lapa',
	'proofreadpage_index_namespace' => 'Saturs',
	'proofreadpage_image' => 'Attēls',
	'proofreadpage_index' => 'Saturs',
	'proofreadpage_nextpage' => 'Nākamā lapa',
	'proofreadpage_prevpage' => 'Iepriekšējā lapa',
	'proofreadpage_quality1_category' => 'Nav pārlasīts',
	'proofreadpage_quality2_category' => 'Problemātisks',
	'proofreadpage_quality3_category' => 'Pārlasīts',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'proofreadpage_namespace' => 'Лаштык',
	'proofreadpage_nextpage' => 'Вес лаштык',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'indexpages' => 'Листа на индексни страници',
	'proofreadpage_desc' => 'Овозможува едноставна споредба на текстот со скенираниот оригинал',
	'proofreadpage_namespace' => 'Страница',
	'proofreadpage_index_namespace' => 'Индекс',
	'proofreadpage_image' => 'слика',
	'proofreadpage_index' => 'Индекс',
	'proofreadpage_index_expected' => 'Грешка: се очекува индекс',
	'proofreadpage_nosuch_index' => 'Грешка: нема таков индекс',
	'proofreadpage_nosuch_file' => 'Грешка: нема таква податотека',
	'proofreadpage_badpage' => 'Погрешен формат',
	'proofreadpage_badpagetext' => 'Форматот на страницата што сакате да ја зачувате е погрешен.',
	'proofreadpage_indexdupe' => 'Дупликат врска',
	'proofreadpage_indexdupetext' => 'Страниците не можат да се наведуваат на индексот повеќе од еднаш по страница',
	'proofreadpage_nologin' => 'Не сте најавени',
	'proofreadpage_nologintext' => 'Морате да бидете [[Special:UserLogin|најавени]] за да можете да го менувате статусот на коректурата на страници.',
	'proofreadpage_notallowed' => 'Менувањето не е дозволено',
	'proofreadpage_notallowedtext' => 'Не ви е дозволено да го менувате статусот на коректурата на оваа страница.',
	'proofreadpage_number_expected' => 'Грешка: се очекува бројчена вредност',
	'proofreadpage_interval_too_large' => 'Грешка: растојанието е преголемо',
	'proofreadpage_invalid_interval' => 'Грешка: погрешно растојание',
	'proofreadpage_nextpage' => 'Следна страница',
	'proofreadpage_prevpage' => 'Претходна страница',
	'proofreadpage_header' => 'Заглавие (без вклучување):',
	'proofreadpage_body' => 'Содржина на страница (се трансклудира):',
	'proofreadpage_footer' => 'Долна колон цифра (noinclude):',
	'proofreadpage_toggleheaders' => 'превклучи ја видливоста на noinclude пасусите',
	'proofreadpage_quality0_category' => 'Без текст',
	'proofreadpage_quality1_category' => 'Непрегледана',
	'proofreadpage_quality2_category' => 'Проблематично',
	'proofreadpage_quality3_category' => 'Прегледано',
	'proofreadpage_quality4_category' => 'Потврдено',
	'proofreadpage_quality0_message' => 'Оваа страница нема потреба од преглед',
	'proofreadpage_quality1_message' => 'Оваа страница е непрегледана',
	'proofreadpage_quality2_message' => 'Се јави проблем при прегледувањето на оваа страница',
	'proofreadpage_quality3_message' => 'Оваа страница е прегледана',
	'proofreadpage_quality4_message' => 'Оваа страница е потврдена',
	'proofreadpage_index_listofpages' => 'Листа на страници',
	'proofreadpage_image_message' => 'Врска до индекс страницата',
	'proofreadpage_page_status' => 'Статус на страница',
	'proofreadpage_js_attributes' => 'Автор Наслов Година Издавач',
	'proofreadpage_index_attributes' => 'Автор
Наслов
Година|Година на издавање
Издавач
Извор
Слика|Корица
Страници||20
Белешки||10',
	'proofreadpage_pages' => '{{PLURAL:$1|страница|страници}}',
	'proofreadpage_specialpage_legend' => 'Пребарување на индексни страници',
	'proofreadpage_source' => 'Извор',
	'proofreadpage_source_message' => 'Скенирано издание за востановување на овој текст',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'indexpages' => 'സൂചികാ താളുകളുടെ പട്ടിക',
	'proofreadpage_desc' => 'യഥാർത്ഥ സ്കാനും എഴുത്തും തമ്മിലുള്ള ലളിതമായ ഒത്തുനോക്കൽ അനുവദിക്കുക',
	'proofreadpage_namespace' => 'താള്‍',
	'proofreadpage_index_namespace' => 'ഇന്‍ഡെക്സ്',
	'proofreadpage_image' => 'ചിത്രം',
	'proofreadpage_index' => 'ഇന്‍ഡെക്സ്',
	'proofreadpage_index_expected' => 'പിഴവ്: സൂചിക വേണം',
	'proofreadpage_nosuch_index' => 'പിഴവ്: അത്തരത്തിലൊരു സൂചിക ഇല്ല',
	'proofreadpage_nosuch_file' => 'പിഴവ്: അത്തരത്തിലൊരു പ്രമാണം ഇല്ല',
	'proofreadpage_badpage' => 'തെറ്റായ തരം',
	'proofreadpage_badpagetext' => 'താങ്കൾ സേവ് ചെയ്യാൻ ശ്രമിച്ച താളിന്റെ തരം (ഫോർമാറ്റ്) ശരിയല്ല.',
	'proofreadpage_indexdupe' => 'കണ്ണിയുടെ പകർപ്പ്',
	'proofreadpage_indexdupetext' => 'ഒരു സൂചികാ താളിൽ ഒന്നിലധികം പ്രാവശ്യം ഒരു താൾ തന്നെ ചേർക്കാൻ കഴിയില്ല.',
	'proofreadpage_nologin' => 'ലോഗിൻ ചെയ്തിട്ടില്ല',
	'proofreadpage_nologintext' => 'താളുകളുടെ തെറ്റുതിരുത്തൽ വായനയുടെ സ്ഥിതിയിൽ മാറ്റം വരുത്താൻ താങ്കൾ [[Special:UserLogin|പ്രവേശിച്ചിരിക്കേണ്ടതാണ്]].',
	'proofreadpage_notallowed' => 'മാറ്റങ്ങൾ അനുവദനീയമല്ല',
	'proofreadpage_notallowedtext' => 'ഈ താളിന്റെ തെറ്റുതിരുത്തൽ വായനയുടെ സ്ഥിതിയിൽ മാറ്റം വരുത്താൻ താങ്കൾക്ക് അനുമതിയില്ല.',
	'proofreadpage_number_expected' => 'പിഴവ്: സംഖ്യയായുള്ള മൂല്യമാണ് പ്രതീക്ഷിക്കുന്നത്',
	'proofreadpage_interval_too_large' => 'പിഴവ്: വളരെ വലിയ ഇടവേള',
	'proofreadpage_invalid_interval' => 'പിഴവ്: അസാധുവായ ഇടവേള',
	'proofreadpage_nextpage' => 'അടുത്ത താള്‍',
	'proofreadpage_prevpage' => 'മുന്‍പത്തെ താള്‍',
	'proofreadpage_header' => 'തലവാചകം (noinclude):',
	'proofreadpage_body' => 'താളിന്റെ ഉള്ളടക്കം (transclude ചെയ്യാനുള്ളത്):',
	'proofreadpage_footer' => 'പാദവാചകം (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude വിഭാഗങ്ങളുടെ പ്രദര്‍ശനം ടോഗിള്‍ ചെയ്യുക',
	'proofreadpage_quality0_category' => 'എഴുത്ത് ഇല്ലാതെ',
	'proofreadpage_quality1_category' => 'തെറ്റുതിരുത്തൽ വായന നടന്നിട്ടില്ല',
	'proofreadpage_quality2_category' => 'പ്രശ്നമുള്ളതാണ്‌',
	'proofreadpage_quality3_category' => 'തെറ്റുതിരുത്തൽ വായന',
	'proofreadpage_quality4_category' => 'സാധുകരിച്ചതാണ്‌',
	'proofreadpage_quality0_message' => 'ഈ താളിൽ തെറ്റുതിരുത്തൽ വായന ആവശ്യമില്ല',
	'proofreadpage_quality1_message' => 'ഈ താളിൽ തെറ്റുതിരുത്തൽ വായന ഉണ്ടായിട്ടില്ല',
	'proofreadpage_quality2_message' => 'ഈ താളിന്റെ തെറ്റുതിരുത്തൽ വായനയിൽ ഒരു പിഴവുണ്ടായിരിക്കുന്നു',
	'proofreadpage_quality3_message' => 'ഈ താളിൽ തെറ്റുതിരുത്തൽ വായന നടന്നിരിക്കുന്നു',
	'proofreadpage_quality4_message' => 'ഈ താളിന്റെ സാധുത തെളിയിക്കപ്പെട്ടതാണ്',
	'proofreadpage_index_listofpages' => 'താളുകളുടെ പട്ടിക',
	'proofreadpage_image_message' => 'സൂചിക താളിലേക്കുള്ള കണ്ണി',
	'proofreadpage_page_status' => 'താളിന്റെ തല്‍സ്ഥിതി',
	'proofreadpage_js_attributes' => 'ലേഖകന്‍ കൃതിയുടെപേര്‌ വര്‍ഷം പ്രസാധകര്‍',
	'proofreadpage_index_attributes' => 'ലേഖകന്‍ 
കൃതിയുടെപേര്‌ 
വര്‍ഷം|പ്രസിദ്ധീകരിച്ച വര്‍ഷം 
പ്രസാധകര്‍
ഉറവിടം
ചിത്രം|മുഖച്ചിത്രം
താളുകള്‍||20
കുറിപ്പുകള്‍||10',
	'proofreadpage_pages' => '{{PLURAL:$1|താൾ|താളുകൾ}}',
	'proofreadpage_specialpage_legend' => 'സൂചികാ താളുകൾ തിരയുക',
	'proofreadpage_source' => 'സ്രോതസ്സ്',
	'proofreadpage_source_message' => 'ഈ എഴുത്ത് സ്ഥാപിക്കാൻ സ്കാൻ ചെയ്തെടുത്ത പ്രസിദ്ധീകരണമാണുപയോഗിച്ചത്',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'proofreadpage_desc' => 'मूळ प्रतीशी मजकूराची छाननी करण्याची सोपी पद्धत',
	'proofreadpage_namespace' => 'पान',
	'proofreadpage_index_namespace' => 'अनुक्रमणिका',
	'proofreadpage_image' => 'चित्र',
	'proofreadpage_index' => 'अनुक्रमणिका',
	'proofreadpage_nextpage' => 'पुढील पान',
	'proofreadpage_prevpage' => 'मागील पान',
	'proofreadpage_header' => 'पानाच्या वरील मजकूर (noinclude):',
	'proofreadpage_body' => 'पानाचा मुख्य मजकूर (जो वापरायचा आहे):',
	'proofreadpage_footer' => 'पानाच्या खालील मजकूर (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude विभांगांची दृष्य पातळी बदला',
	'proofreadpage_quality1_category' => 'तपासलेले नाही',
	'proofreadpage_quality2_category' => 'समस्या करणारे',
	'proofreadpage_quality3_category' => 'मजकूर तपासा',
	'proofreadpage_quality4_category' => 'प्रमाणित',
	'proofreadpage_index_listofpages' => 'पानांची यादी',
	'proofreadpage_image_message' => 'अनुक्रमणिका असणार्‍या पानाशी दुवा द्या',
	'proofreadpage_page_status' => 'पानाची स्थिती',
	'proofreadpage_js_attributes' => 'लेखक शीर्षक वर्ष प्रकाशक',
	'proofreadpage_index_attributes' => 'लेखक
शीर्षक
वर्ष|प्रकाशन वर्ष
प्रकाशक
स्रोत
चित्र|मुखपृष्ठ चित्र
पाने||२०
शेरा||१०',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'proofreadpage_desc' => 'Membolehkan perbandingan mudah bagi teks dengan imbasan asal',
	'proofreadpage_namespace' => 'Halaman',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'imej',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_nextpage' => 'Halaman berikutnya',
	'proofreadpage_prevpage' => 'Halaman sebelumnya',
	'proofreadpage_header' => 'Pengatas (tidak dimasukkan):',
	'proofreadpage_body' => 'Isi halaman (untuk dimasukkan):',
	'proofreadpage_footer' => 'Pembawah (tidak dimasukkan):',
	'proofreadpage_toggleheaders' => 'tukar kebolehnampakan bahagian yang tidak dimasukkan',
	'proofreadpage_quality1_category' => 'Belum dibaca pruf',
	'proofreadpage_quality2_category' => 'Bermasalah',
	'proofreadpage_quality3_category' => 'Dibaca pruf',
	'proofreadpage_quality4_category' => 'Disahkan',
	'proofreadpage_index_listofpages' => 'Senarai halaman',
	'proofreadpage_image_message' => 'Pautan ke halaman indeks',
	'proofreadpage_page_status' => 'Status halaman',
	'proofreadpage_js_attributes' => 'Pengarang Judul Tahun Penerbit',
	'proofreadpage_index_attributes' => 'Pengarang
Judul
Tahun|Tahun diterbitkan
Penerbit
Sumber
Imej|Imej kulit
Jumlah halaman||20
Catatan||10',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'proofreadpage_namespace' => 'Páigina',
);

/** Erzya (Эрзянь)
 * @author Amdf
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'proofreadpage_namespace' => 'Лопа',
	'proofreadpage_nextpage' => 'Седе тов ве лопа',
	'proofreadpage_index_attributes' => 'Сёрмадыцясь
Конаксось
Иесь|Нолдавкс иесь
Нолдыцясь
Лисьмапрясь
Неевтесь|Лангаксонь неевтесь
Лопатне||20
Мельть-арьсемат||10',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'proofreadpage_namespace' => 'Zāzanilli',
	'proofreadpage_image' => 'īxiptli',
	'proofreadpage_nextpage' => 'Niman zāzanilli',
	'proofreadpage_prevpage' => 'Achto zāzanilli',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'proofreadpage_desc' => 'Verlöövt dat bequeme Verglieken vun Text mit’n Original-Scan',
	'proofreadpage_namespace' => 'Siet',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'Bild',
	'proofreadpage_index' => 'Index',
	'proofreadpage_nextpage' => 'Nächste Siet',
	'proofreadpage_prevpage' => 'Vörige Siet',
	'proofreadpage_header' => 'Koppreeg (noinclude):',
	'proofreadpage_body' => 'Hööfttext (warrt inbunnen):',
	'proofreadpage_footer' => 'Footreeg (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude-Afsneed in-/utblennen',
	'proofreadpage_quality0_category' => 'Ahn Text',
	'proofreadpage_quality1_category' => 'nich korrekturleest',
	'proofreadpage_quality2_category' => 'problemaatsch',
	'proofreadpage_quality3_category' => 'korrekturleest',
	'proofreadpage_quality4_category' => 'Fertig',
	'proofreadpage_index_listofpages' => 'Siedenlist',
	'proofreadpage_image_message' => 'Lenk na de Indexsiet',
	'proofreadpage_page_status' => 'Siedenstatus',
	'proofreadpage_js_attributes' => 'Schriever Titel Johr Verlag',
	'proofreadpage_index_attributes' => 'Schriever
Titel
Johr|Johr, dat dat rutkamen is
Verlag
Born
Bild|Titelbild
Sieden||20
Anmarkungen||10',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'indexpages' => "Lijst van index-pagina's",
	'proofreadpage_desc' => 'Maakt het mogelijk teksten eenvoudig te vergelijken met de oorspronkelijke scan',
	'proofreadpage_namespace' => 'Pagina',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'afbeelding',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Fout: er werd een index verwacht',
	'proofreadpage_nosuch_index' => 'Fout: de index bestaat niet',
	'proofreadpage_nosuch_file' => 'Fout: het aangegeven bestand bestaat niet',
	'proofreadpage_badpage' => 'Verkeerde formaat',
	'proofreadpage_badpagetext' => 'Het formaat van de pagina die u probeerde op te slaan is onjuist.',
	'proofreadpage_indexdupe' => 'Dubbele verwijzing',
	'proofreadpage_indexdupetext' => "Pagina's kunnen niet meer dan één keer op een indexpagina weergegeven worden.",
	'proofreadpage_nologin' => 'Niet aangemeld',
	'proofreadpage_nologintext' => "U moet [[Special:UserLogin|aanmelden]] om de proefleesstatus van pagina's te kunnen wijzigen.",
	'proofreadpage_notallowed' => 'Wijzigen is niet toegestaan',
	'proofreadpage_notallowedtext' => 'U mag de proefleesstatus van deze pagina niet wijzigen.',
	'proofreadpage_number_expected' => 'Fout: er werd een numerieke waarde verwacht',
	'proofreadpage_interval_too_large' => 'Fout: het interval is te groot',
	'proofreadpage_invalid_interval' => 'Fout: er is een ongeldige interval opgegeven',
	'proofreadpage_nextpage' => 'Volgende pagina',
	'proofreadpage_prevpage' => 'Vorige pagina',
	'proofreadpage_header' => 'Koptekst (geen inclusie):',
	'proofreadpage_body' => 'Broodtekst (voor transclusie):',
	'proofreadpage_footer' => 'Voettekst (geen inclusie):',
	'proofreadpage_toggleheaders' => 'zichtbaarheid elementen zonder transclusie wijzigen',
	'proofreadpage_quality0_category' => 'Geen tekst',
	'proofreadpage_quality1_category' => 'Onbewerkt',
	'proofreadpage_quality2_category' => 'Onvolledig',
	'proofreadpage_quality3_category' => 'Proefgelezen',
	'proofreadpage_quality4_category' => 'Gecontroleerd',
	'proofreadpage_quality0_message' => 'Deze pagina hoeft niet te worden proefgelezen',
	'proofreadpage_quality1_message' => 'Deze pagina is niet proefgelezen',
	'proofreadpage_quality2_message' => 'Er was een probleem bij het proeflezen van deze pagina',
	'proofreadpage_quality3_message' => 'Deze pagina is proefgelezen',
	'proofreadpage_quality4_message' => 'Deze pagina is gecontroleerd',
	'proofreadpage_index_listofpages' => 'Paginalijst',
	'proofreadpage_image_message' => 'Verwijziging naar de indexpagina',
	'proofreadpage_page_status' => 'Paginastatus',
	'proofreadpage_js_attributes' => 'Auteur Titel Jaar Uitgever',
	'proofreadpage_index_attributes' => "Auteur
Titel
Jaar|Jaar van publicatie
Uitgever
Bron
Afbeelding|Omslag
Pagina's||20
Opmerkingen||10",
	'proofreadpage_pages' => "{{PLURAL:$1|pagina|pagina's}}",
	'proofreadpage_specialpage_legend' => "Indexpagina's doorzoeken",
	'proofreadpage_source' => 'Bron',
	'proofreadpage_source_message' => 'Gescande versie waarop deze tekst is gebaseerd',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'proofreadpage_desc' => 'Tillèt enkel samanlikning av tekst med originalskanning.',
	'proofreadpage_namespace' => 'Side',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'bilete',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Feil: Indeks forventa',
	'proofreadpage_nosuch_index' => 'Feil: ingen slik indeks',
	'proofreadpage_nosuch_file' => 'Feil: inga slik fil',
	'proofreadpage_number_expected' => 'Feil: Talverdi forventa',
	'proofreadpage_interval_too_large' => 'Feil: for stort intervall',
	'proofreadpage_invalid_interval' => 'Feil: ugyldig intervall',
	'proofreadpage_nextpage' => 'Neste side',
	'proofreadpage_prevpage' => 'Førre side',
	'proofreadpage_header' => 'Hovudseksjon (ikkje inkludert):',
	'proofreadpage_body' => 'Hovuddel (inkludert):',
	'proofreadpage_footer' => 'Fotseksjon (ikkje inludert):',
	'proofreadpage_toggleheaders' => 'syna/ikkje syna seksjonar ikkje inkluderte på sida',
	'proofreadpage_quality0_category' => 'Utan tekst',
	'proofreadpage_quality1_category' => 'Ikkje korrekturlest',
	'proofreadpage_quality2_category' => 'Problematisk',
	'proofreadpage_quality3_category' => 'Korrekturlest',
	'proofreadpage_quality4_category' => 'Validert',
	'proofreadpage_index_listofpages' => 'Lista over sider',
	'proofreadpage_image_message' => 'Lenkja til indekssida',
	'proofreadpage_page_status' => 'Sidestatus',
	'proofreadpage_js_attributes' => 'Forfattar Tittel År Utgjevar',
	'proofreadpage_index_attributes' => 'Forfattar
Tittel
År|Utgjeve år
Utgjevar
Kjelda
Bilete|Omslagsbilete
Sider||20
Merknader||10',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 * @author Simny
 */
$messages['no'] = array(
	'indexpages' => 'Liste over innholdsfortegnelser',
	'proofreadpage_desc' => 'Tillat lett sammenligning av tekst med originalskanningen',
	'proofreadpage_namespace' => 'Side',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'bilde',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Feil: Indeks forventet',
	'proofreadpage_nosuch_index' => 'Feil: ingen slik indeks',
	'proofreadpage_nosuch_file' => 'Feil: ingen slik fil',
	'proofreadpage_badpage' => 'Feil format',
	'proofreadpage_badpagetext' => 'Siden du prøver å lagre har galt format.',
	'proofreadpage_indexdupe' => 'Duplikat lenke',
	'proofreadpage_indexdupetext' => 'Sider kan ikke listes mer enn en gang på en indeksside.',
	'proofreadpage_nologin' => 'Ikke innlogget',
	'proofreadpage_nologintext' => 'Du må være [[Special:UserLogin|innlogget]] for å kunne forandre status på korrekturlesningen på sider.',
	'proofreadpage_notallowed' => 'Å gjøre en forandring er ikke lov',
	'proofreadpage_notallowedtext' => 'Du har ikke rettigheter til å endre korrekturlesningen på denne siden.',
	'proofreadpage_number_expected' => 'Feil: Numerisk verdi forventet',
	'proofreadpage_interval_too_large' => 'Feil: Intervall for stort',
	'proofreadpage_invalid_interval' => 'Feil: ugyldig intervall',
	'proofreadpage_nextpage' => 'Neste side',
	'proofreadpage_prevpage' => 'Forrige side',
	'proofreadpage_header' => 'Hodeseksjon (inkluderes ikke):',
	'proofreadpage_body' => 'Hoveddel (skal inkluderes):',
	'proofreadpage_footer' => 'Fotseksjon (inkluderes ikke):',
	'proofreadpage_toggleheaders' => 'slå av/på synlighet for ikke-inkluderte seksjoner',
	'proofreadpage_quality0_category' => 'Uten tekst',
	'proofreadpage_quality1_category' => 'Rå',
	'proofreadpage_quality2_category' => 'Ufullstendig',
	'proofreadpage_quality3_category' => 'Korrekturlest',
	'proofreadpage_quality4_category' => 'Validert',
	'proofreadpage_quality0_message' => 'Denne siden trenger ikke korrekturleses',
	'proofreadpage_quality1_message' => 'Denne siden er ikke korrekturlest',
	'proofreadpage_quality2_message' => 'Det oppsto et problem når denne siden skulle korrekturleses',
	'proofreadpage_quality3_message' => 'Denne siden er korrekturlest',
	'proofreadpage_quality4_message' => 'Denne siden er godkjent',
	'proofreadpage_index_listofpages' => 'Liste over sider',
	'proofreadpage_image_message' => 'Lenke til indekssiden',
	'proofreadpage_page_status' => 'Sidestatus',
	'proofreadpage_js_attributes' => 'Forfatter Tittel År Utgiver',
	'proofreadpage_index_attributes' => 'Forfatter
Tittel
År|Utgivelsesår
Utgiver
Kilde
Bilde|Omslagsbilde
Sider||20
Merknader||10',
	'proofreadpage_pages' => '{{PLURAL:$1|side|sider}}',
	'proofreadpage_specialpage_legend' => 'Søk i indekssider',
	'proofreadpage_source' => 'Kilde',
	'proofreadpage_source_message' => 'Scannet utgave brukt for å etablere denne teksten',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'proofreadpage_namespace' => 'Letlakala',
	'proofreadpage_nextpage' => 'Letlakala lago latela',
	'proofreadpage_prevpage' => 'Letlaka lago feta',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'indexpages' => "Lista de las paginas d'indèx",
	'proofreadpage_desc' => 'Permet una comparason aisida entre lo tèxte e la numerizacion originala',
	'proofreadpage_namespace' => 'Pagina',
	'proofreadpage_index_namespace' => 'Indèx',
	'proofreadpage_image' => 'imatge',
	'proofreadpage_index' => 'Indèx',
	'proofreadpage_index_expected' => 'Error : un indèx es esperat',
	'proofreadpage_nosuch_index' => "Error : l'indèx es pas estat trobat",
	'proofreadpage_nosuch_file' => 'Error : lo fichièr es pas estat trobat',
	'proofreadpage_badpage' => 'Format marrit',
	'proofreadpage_badpagetext' => "Lo format de la pagina qu'ensajatz de publicar es incorrècte.",
	'proofreadpage_indexdupe' => 'Ligam en doble',
	'proofreadpage_indexdupetext' => "Las paginas pòdon pas èsser listadas mai d'un còp sus una pagina d'indèx.",
	'proofreadpage_nologin' => 'Pas connectat',
	'proofreadpage_nologintext' => "Vos cal èsser [[Special:UserLogin|connectat]] per modificar l'estatut de correccion de las paginas.",
	'proofreadpage_notallowed' => 'Cambiament pas autorizat.',
	'proofreadpage_notallowedtext' => "Sètz pas autorizat(ada) a modificar l'estatut de correccion d'aquesta pagina.",
	'proofreadpage_number_expected' => 'Error : una valor numerica es esperada',
	'proofreadpage_interval_too_large' => 'Error : interval tròp grand',
	'proofreadpage_invalid_interval' => 'Error : interval invalid',
	'proofreadpage_nextpage' => 'Pagina seguenta',
	'proofreadpage_prevpage' => 'Pagina precedenta',
	'proofreadpage_header' => 'Entèsta (noinclude) :',
	'proofreadpage_body' => 'Contengut (transclusion) :',
	'proofreadpage_footer' => 'Pè de pagina (noinclude) :',
	'proofreadpage_toggleheaders' => 'amagar/far veire las seccions noinclude',
	'proofreadpage_quality0_category' => 'Sens tèxte',
	'proofreadpage_quality1_category' => 'Pagina pas corregida',
	'proofreadpage_quality2_category' => 'Pagina amb problèma',
	'proofreadpage_quality3_category' => 'Pagina corregida',
	'proofreadpage_quality4_category' => 'Pagina validada',
	'proofreadpage_quality0_message' => 'Aquesta pagina a pas besonh d’èsser relegida',
	'proofreadpage_quality1_message' => 'Aquesta pagina es pas estada relegida',
	'proofreadpage_quality2_message' => "I a agut un problèma al moment de la relectura d'aquesta pagina",
	'proofreadpage_quality3_message' => 'Aquesta pagina es estada relegida',
	'proofreadpage_quality4_message' => 'Aquesta pagina es estada validada',
	'proofreadpage_index_listofpages' => 'Lista de las paginas',
	'proofreadpage_image_message' => "Ligam cap a l'indèx",
	'proofreadpage_page_status' => 'Estat de la pagina',
	'proofreadpage_js_attributes' => 'Autor Títol Annada Editor',
	'proofreadpage_index_attributes' => 'Autor
Títol
Annada|Annada de publicacion
Editor
Font
Imatge|Imatge en cobertura
Paginas||20
Comentaris||10',
	'proofreadpage_pages' => '{{PLURAL:$1|pagina|paginas}}',
	'proofreadpage_specialpage_legend' => 'Recercar dins las paginas d’indèx',
	'proofreadpage_source' => 'Font',
	'proofreadpage_source_message' => "Edicion numerizada d'ont es eissit aqueste tèxte",
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'proofreadpage_namespace' => 'Фарс',
	'proofreadpage_image' => 'ныв',
	'proofreadpage_nextpage' => 'Фæдылдзог фарс',
	'proofreadpage_prevpage' => 'Раздæры фарс',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'proofreadpage_namespace' => 'Blatt',
	'proofreadpage_image' => 'Bild',
	'proofreadpage_nextpage' => 'Neegscht Blatt',
	'proofreadpage_prevpage' => 'Letscht Blatt',
	'proofreadpage_index_listofpages' => 'Lischt vun Bledder',
	'proofreadpage_pages' => '{{PLURAL:$1|Blatt|Bledder}}',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'indexpages' => 'Spis stron indeksów',
	'proofreadpage_desc' => 'Umożliwia łatwe porównanie treści ze skanem oryginału',
	'proofreadpage_namespace' => 'Strona',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'Grafika',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Błąd – oczekiwano indeksu',
	'proofreadpage_nosuch_index' => 'Błąd – nie ma takiego indeksu',
	'proofreadpage_nosuch_file' => 'Błąd – nie ma takiego pliku',
	'proofreadpage_badpage' => 'Zły format',
	'proofreadpage_badpagetext' => 'Format strony którą próbujesz zapisać jest nieprawidłowy.',
	'proofreadpage_indexdupe' => 'Zdublowany link',
	'proofreadpage_indexdupetext' => 'Strony nie mogą być wymienione więcej niż jeden raz na stronie indeksu.',
	'proofreadpage_nologin' => 'Niezalogowany',
	'proofreadpage_nologintext' => 'Musisz [[Special:UserLogin|zalogować się]], aby zmienić status proofreading strony.',
	'proofreadpage_notallowed' => 'Zmiana niedozwolona',
	'proofreadpage_notallowedtext' => 'Zmiana statusu proofreeding tej strony przez Ciebie jest niedozwolona.',
	'proofreadpage_number_expected' => 'Błąd – oczekiwano liczby',
	'proofreadpage_interval_too_large' => 'Błąd – zbyt duży odstęp',
	'proofreadpage_invalid_interval' => 'Błąd – nieprawidłowy odstęp',
	'proofreadpage_nextpage' => 'Następna strona',
	'proofreadpage_prevpage' => 'Poprzednia strona',
	'proofreadpage_header' => 'Nagłówek (noinclude):',
	'proofreadpage_body' => 'Treść strony (załączany fragment):',
	'proofreadpage_footer' => 'Stopka (noinclude):',
	'proofreadpage_toggleheaders' => 'zmień widoczność sekcji noinclude',
	'proofreadpage_quality0_category' => 'Bez treści',
	'proofreadpage_quality1_category' => 'Nieskorygowana',
	'proofreadpage_quality2_category' => 'Problemy',
	'proofreadpage_quality3_category' => 'Skorygowana',
	'proofreadpage_quality4_category' => 'Uwierzytelniona',
	'proofreadpage_quality0_message' => 'Ta strona nie wymaga korekty',
	'proofreadpage_quality1_message' => 'Ta strona nie została skorygowana',
	'proofreadpage_quality2_message' => 'Wystąpił problem przy korekcie tej stronie',
	'proofreadpage_quality3_message' => 'Ta strona została skorygowana',
	'proofreadpage_quality4_message' => 'Ta strona została zatwierdzona',
	'proofreadpage_index_listofpages' => 'Spis stron',
	'proofreadpage_image_message' => 'Link do strony indeksowej',
	'proofreadpage_page_status' => 'Status strony',
	'proofreadpage_js_attributes' => 'Autor Tytuł Rok Wydawca',
	'proofreadpage_index_attributes' => 'Autor
Tytuł
Rok|Rok publikacji
Wydawca
Źródło
Ilustracja|Okładka
Strony||20
Uwagi||10',
	'proofreadpage_pages' => '{{PLURAL:$1|strona|strony|stron}}',
	'proofreadpage_specialpage_legend' => 'Szukaj stron indeksowych',
	'proofreadpage_source' => 'Źródło',
	'proofreadpage_source_message' => 'Zeskanowane wydanie wykorzystane do przygotowania tego tekstu',
);

/** Piedmontese (Piemontèis)
 * @author 555
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'indexpages' => 'Lista dle pàgine ëd tàula',
	'proofreadpage_desc' => 'A rend bel fé confronté ëd test con la scansion original',
	'proofreadpage_namespace' => 'Pàgina',
	'proofreadpage_index_namespace' => 'Ìndess',
	'proofreadpage_image' => 'figura',
	'proofreadpage_index' => 'Ìndess',
	'proofreadpage_index_expected' => 'Eror: a së spetava na tàula',
	'proofreadpage_nosuch_index' => 'Eror: tàula pa esistenta',
	'proofreadpage_nosuch_file' => "Eror: l'archivi a-i é pa",
	'proofreadpage_badpage' => 'Formà pa bon',
	'proofreadpage_badpagetext' => "Ël formà dla pàgina ch'a ha sërcà ëd salvé a l'é pa bon.",
	'proofreadpage_indexdupe' => 'Colegament duplicà',
	'proofreadpage_indexdupetext' => "Le pàgine a peulo pa esse listà pi 'd na vòta an sna pàgina ëd tàula.",
	'proofreadpage_nologin' => 'Pa rintrà ant ël sistema',
	'proofreadpage_nologintext' => 'It deve [[Special:UserLogin|intré ant ël sistema]] për modifiché lë stat ëd verifìca ëd le pàgine.',
	'proofreadpage_notallowed' => 'Cangiament pa possìbil',
	'proofreadpage_notallowedtext' => 'It peule pa cambié lë stat ëd verìfica dë sta pàgina-sì.',
	'proofreadpage_number_expected' => 'Eror: valor numérich spetà',
	'proofreadpage_interval_too_large' => 'Eror: antërval tròp largh',
	'proofreadpage_invalid_interval' => 'Eror: antërval pa bon',
	'proofreadpage_nextpage' => 'Pàgina anans',
	'proofreadpage_prevpage' => 'Pàgina andré',
	'proofreadpage_header' => 'Testà (da nen anclude):',
	'proofreadpage_body' => 'Còrp dla pàgina (da transclude):',
	'proofreadpage_footer' => 'Pè (da nen anclude)',
	'proofreadpage_toggleheaders' => 'smon/stërma le part da nen anclude',
	'proofreadpage_quality0_category' => 'Sensa test',
	'proofreadpage_quality1_category' => 'Pa passà an verìfica',
	'proofreadpage_quality2_category' => 'Problemàtich',
	'proofreadpage_quality3_category' => 'Verificà',
	'proofreadpage_quality4_category' => 'Validà',
	'proofreadpage_quality0_message' => "Sta pàgina-sì a l'ha pa dabzògn ëd la revision",
	'proofreadpage_quality1_message' => "Sta pàgina-sì a l'é pa stàita revisionà",
	'proofreadpage_quality2_message' => 'A-i é stàje un problema an revisionand sta pàgina-sì',
	'proofreadpage_quality3_message' => "Sta pàgina-sì a l'é stàita revisionà",
	'proofreadpage_quality4_message' => "Sta pàgina-sì a l'é stàita validà",
	'proofreadpage_index_listofpages' => 'Lista ëd le pàgine',
	'proofreadpage_image_message' => 'Colegament a la pàgina ëd tàula',
	'proofreadpage_page_status' => 'Stat ëd la pàgina',
	'proofreadpage_js_attributes' => 'Autor Tìtol Ann Editor',
	'proofreadpage_index_attributes' => 'Autor
Tìtol
Ann|Ann ëd publicassion
Editor
Sorgiss
Figura|Figura ëd coertin-a
Pàgine||20
Nòte||10',
	'proofreadpage_pages' => '{{PLURAL:$1|pàgina|pàgine}}',
	'proofreadpage_specialpage_legend' => 'Sërca ant le pàgine ëd tàula',
	'proofreadpage_source' => 'Sorgiss',
	'proofreadpage_source_message' => 'Edission digitalisà dovrà për stabilì sto test-sì',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'proofreadpage_namespace' => 'مخ',
	'proofreadpage_index_namespace' => 'ليکلړ',
	'proofreadpage_image' => 'انځور',
	'proofreadpage_index' => 'ليکلړ',
	'proofreadpage_nextpage' => 'بل مخ',
	'proofreadpage_prevpage' => 'تېر مخ',
	'proofreadpage_index_listofpages' => 'د مخونو لړليک',
	'proofreadpage_image_message' => 'د ليکلړ مخ ته تړنه',
	'proofreadpage_page_status' => 'د مخ دريځ',
	'proofreadpage_js_attributes' => 'ليکوال سرليک کال خپرونکی',
	'proofreadpage_index_attributes' => 'ليکوال
سرليک
کال|د خپرېدو کال
خپرونکی
سرچينه
انځور|د پښتۍ انځور
مخونه||20
تبصرې||10',
);

/** Portuguese (Português)
 * @author 555
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'indexpages' => 'Lista de páginas de índice',
	'proofreadpage_desc' => 'Permite a comparação fácil de um texto com a sua digitalização original',
	'proofreadpage_namespace' => 'Página',
	'proofreadpage_index_namespace' => 'Índice',
	'proofreadpage_image' => 'imagem',
	'proofreadpage_index' => 'Índice',
	'proofreadpage_index_expected' => 'Erro: índice esperado',
	'proofreadpage_nosuch_index' => 'Erro: índice não existe',
	'proofreadpage_nosuch_file' => 'Erro: ficheiro não existe',
	'proofreadpage_badpage' => 'Formato Errado',
	'proofreadpage_badpagetext' => 'O formato da página que tentou gravar é incorrecto.',
	'proofreadpage_indexdupe' => 'Ligação duplicada',
	'proofreadpage_indexdupetext' => 'As páginas não podem ser listadas mais do que uma vez numa página de índice.',
	'proofreadpage_nologin' => 'Não se encontra autenticado',
	'proofreadpage_nologintext' => 'Precisa de estar [[Special:UserLogin|autenticado]] para alterar o estado de revisão das páginas.',
	'proofreadpage_notallowed' => 'Mudança não permitida',
	'proofreadpage_notallowedtext' => 'Não lhe é permitido alterar o estado de revisão desta página.',
	'proofreadpage_number_expected' => 'Erro: valor numérico esperado',
	'proofreadpage_interval_too_large' => 'Erro: intervalo demasiado grande',
	'proofreadpage_invalid_interval' => 'Erro: intervalo inválido',
	'proofreadpage_nextpage' => 'Página seguinte',
	'proofreadpage_prevpage' => 'Página anterior',
	'proofreadpage_header' => "Cabeçalho (em modo ''noinclude''):",
	'proofreadpage_body' => 'Corpo de página (em modo de transclusão):',
	'proofreadpage_footer' => "Rodapé (em modo ''noinclude''):",
	'proofreadpage_toggleheaders' => "inverter a visibilidade das secções ''noinclude''",
	'proofreadpage_quality0_category' => 'Sem texto',
	'proofreadpage_quality1_category' => 'Não revistas',
	'proofreadpage_quality2_category' => 'Problemáticas',
	'proofreadpage_quality3_category' => 'Revistas e corrigidas',
	'proofreadpage_quality4_category' => 'Validadas',
	'proofreadpage_quality0_message' => 'Esta página não necessita de ser revista',
	'proofreadpage_quality1_message' => 'Esta página não foi ainda revista',
	'proofreadpage_quality2_message' => 'Ocorreu um problema ao fazer a revisão desta página',
	'proofreadpage_quality3_message' => 'Esta página foi revista',
	'proofreadpage_quality4_message' => 'Esta página foi validada',
	'proofreadpage_index_listofpages' => 'Lista de páginas',
	'proofreadpage_image_message' => 'Ligação para a página de índice',
	'proofreadpage_page_status' => 'Estado da página',
	'proofreadpage_js_attributes' => 'Autor Título Ano Editora',
	'proofreadpage_index_attributes' => 'Autor
Título
Ano|Ano de publicação
Editora
Fonte
Imagem|Imagem de capa
Páginas||20
Notas||10',
	'proofreadpage_pages' => '{{PLURAL:$1|página|páginas}}',
	'proofreadpage_specialpage_legend' => 'Pesquisar nas páginas de índice',
	'proofreadpage_source' => 'Fonte',
	'proofreadpage_source_message' => 'Edição digitalizada usada para criar este texto',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'proofreadpage_desc' => 'Permite a comparação fácil de um texto com a sua digitalização original',
	'proofreadpage_namespace' => 'Página',
	'proofreadpage_index_namespace' => 'Índice',
	'proofreadpage_image' => 'imagem',
	'proofreadpage_index' => 'Índice',
	'proofreadpage_notallowed' => 'Alteração não permitida',
	'proofreadpage_nextpage' => 'Próxima página',
	'proofreadpage_prevpage' => 'Página anterior',
	'proofreadpage_header' => 'Cabeçalho (em modo noinclude):',
	'proofreadpage_body' => 'Corpo de página (em modo de transclusão):',
	'proofreadpage_footer' => 'Rodapé (em modo noinclude):',
	'proofreadpage_toggleheaders' => 'tornar as seções noinclude visíveis',
	'proofreadpage_quality0_category' => 'Sem texto',
	'proofreadpage_quality1_category' => 'Não revistas',
	'proofreadpage_quality2_category' => 'Problemáticas',
	'proofreadpage_quality3_category' => 'Revistas e corrigidas',
	'proofreadpage_quality4_category' => 'Validadas',
	'proofreadpage_quality4_message' => 'Esta página foi validada',
	'proofreadpage_index_listofpages' => 'Lista de páginas',
	'proofreadpage_image_message' => 'Link para a página de índice',
	'proofreadpage_page_status' => 'Estado da página',
	'proofreadpage_js_attributes' => 'Autor Título Ano Editora',
	'proofreadpage_index_attributes' => 'Autor
Título
Ano|Ano de publicação
Editora
Fonte
Imagem|Imagem de capa
Páginas||20
Notas||10',
	'proofreadpage_pages' => '{{PLURAL:$1|página|páginas}}',
	'proofreadpage_source' => 'Fonte',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'proofreadpage_namespace' => "P'anqa",
	'proofreadpage_index_namespace' => 'Yuyarina',
	'proofreadpage_image' => 'rikcha',
	'proofreadpage_index' => 'Yuyarina',
	'proofreadpage_nextpage' => "Qatiq p'anqa",
	'proofreadpage_prevpage' => "Ñawpaq p'anqa",
	'proofreadpage_header' => "Uma siq'i (mana ch'aqtana):",
	'proofreadpage_body' => "P'anqa kurku (ch'aqtanapaq):",
	'proofreadpage_footer' => "Chaki siq'i (mana ch'aqtana):",
	'proofreadpage_index_attributes' => "Qillqaq
Qillqa suti
Wata|Liwruchasqap watan
Liwruchaq
Pukyu
Rikcha|Qata rikcha
P'anqakuna||20
Willapusqakuna||10",
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'indexpages' => 'Lista paginilor index',
	'proofreadpage_desc' => 'Permiteţi compararea cu uşurinţă a textului faţă de scanarea originală',
	'proofreadpage_namespace' => 'Pagină',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'imagine',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Eroare: index aşteptat',
	'proofreadpage_nosuch_index' => 'Eroare: index inexistent',
	'proofreadpage_nosuch_file' => 'Eroare: fişier inexistent',
	'proofreadpage_badpage' => 'Format greşit',
	'proofreadpage_badpagetext' => 'Formatul paginii în care se doreşte salvarea este incorect.',
	'proofreadpage_indexdupe' => 'Legătură duplicat',
	'proofreadpage_indexdupetext' => 'Paginile nu pot fi afişate de mai multe ori într-o pagină index.',
	'proofreadpage_nologin' => 'Nu sunteţi autentificat',
	'proofreadpage_nologintext' => 'Trebuie să fii [[Special:UserLogin|logat]] pentru a modifica statutul de verificare a paginilor.',
	'proofreadpage_notallowed' => 'Schimbare nepermisă',
	'proofreadpage_notallowedtext' => 'Nu vi se permite să schimbaţi statutul de vericare al acestei pagini.',
	'proofreadpage_number_expected' => 'Eroare: valoare numerică aşteptată',
	'proofreadpage_interval_too_large' => 'Eroare: interval prea mare',
	'proofreadpage_invalid_interval' => 'Eroare: interval incorect',
	'proofreadpage_nextpage' => 'Pagina următoare',
	'proofreadpage_prevpage' => 'Pagina anterioară',
	'proofreadpage_header' => 'Antet (nu include):',
	'proofreadpage_body' => 'Corp-mesaj (pentru a fi introdus):',
	'proofreadpage_footer' => 'Coloncifru (nu include):',
	'proofreadpage_quality0_category' => 'Fără text',
	'proofreadpage_quality1_category' => 'Neverificat',
	'proofreadpage_quality2_category' => 'Problematic',
	'proofreadpage_quality3_category' => 'Verificat',
	'proofreadpage_quality4_category' => 'Validat',
	'proofreadpage_quality0_message' => 'Această pagină nu necesită să fie verificată',
	'proofreadpage_quality1_message' => 'Această pagină n-a fost verificată',
	'proofreadpage_quality2_message' => 'Aici a fost o problemă când verifica această pagină',
	'proofreadpage_quality3_message' => 'Această pagină a fost verificată',
	'proofreadpage_quality4_message' => 'Această pagină a fost validată',
	'proofreadpage_index_listofpages' => 'Lista paginilor',
	'proofreadpage_image_message' => 'Legătură către pagina index',
	'proofreadpage_page_status' => 'Pagina status',
	'proofreadpage_js_attributes' => 'Autor Titlu An Editor',
	'proofreadpage_index_attributes' => 'Autor
Titlu
An|Anul publicării
Editură
Sursă
Imagine|Imagine copertă
Pagini||20
Comentarii||10',
	'proofreadpage_specialpage_legend' => 'Căutaţi paginile de index',
	'proofreadpage_source' => 'Sursă',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'indexpages' => 'Elenghe de le pàggene de indice',
	'proofreadpage_desc' => "Permette combronde facele de teste cu 'a scanzione origgenale",
	'proofreadpage_namespace' => 'Pàgene',
	'proofreadpage_index_namespace' => 'Indice',
	'proofreadpage_image' => 'immaggine',
	'proofreadpage_index' => 'Indice',
	'proofreadpage_index_expected' => 'Errore: previste indice',
	'proofreadpage_nosuch_index' => 'Errore: nisciune indice',
	'proofreadpage_nosuch_file' => 'Errore: nisciune file',
	'proofreadpage_badpage' => 'Formate sbagliate',
	'proofreadpage_badpagetext' => "'U formate d'a pàgene ca tu ste pruève a reggistrà non g'è corrette.",
	'proofreadpage_indexdupe' => 'Collegamende duplicate',
	'proofreadpage_indexdupetext' => "Le pàggene non ge ponne essere elengate cchiù de 'na vote jndr'à 'na pàgene de indice.",
	'proofreadpage_nologin' => 'Non ge sì collegate',
	'proofreadpage_nologintext' => "Tu a essere [[Special:UserLogin|collegate]] pe cangià 'u state de verifiche de le pàggene.",
	'proofreadpage_notallowed' => 'Cangiamende none consendite',
	'proofreadpage_notallowedtext' => "Non ge t'è permesse cangià 'u state de verifiche de sta pàgene.",
	'proofreadpage_number_expected' => "Errore: aspettamme 'nu valore numereche",
	'proofreadpage_interval_too_large' => 'Errore: indervalle troppe larije',
	'proofreadpage_invalid_interval' => 'Errore: indervalle invalide',
	'proofreadpage_nextpage' => 'Pàgena successive',
	'proofreadpage_prevpage' => 'Pàgena precedende',
	'proofreadpage_header' => 'Testate (none ingluse):',
	'proofreadpage_body' => "Cuerpe d'a pàgene (da ingludere):",
	'proofreadpage_footer' => "Fine d'a pàgene (none ingluse):",
	'proofreadpage_toggleheaders' => "abbilite/disabbilite 'a visibbeletà de le seziune none ingluse",
	'proofreadpage_quality0_category' => 'Senza teste',
	'proofreadpage_quality1_category' => 'Da correggere',
	'proofreadpage_quality2_category' => 'Probblemateche',
	'proofreadpage_quality3_category' => 'Corrette',
	'proofreadpage_quality4_category' => 'Validate',
	'proofreadpage_quality0_message' => "Sta pàgene none g'abbesogne de essere corrette",
	'proofreadpage_quality1_message' => "Sta pàgene none g'à state corrette",
	'proofreadpage_quality2_message' => 'Ha state quacche probbleme quanne è corrette sta pàgene',
	'proofreadpage_quality3_message' => 'Sta pàgene ha state corrette',
	'proofreadpage_quality4_message' => 'Sta pàgene ha state validate',
	'proofreadpage_index_listofpages' => 'Elenghe de le pàggene',
	'proofreadpage_image_message' => "Colleghe a 'a pàgene de indice",
	'proofreadpage_page_status' => "State d'a pàgene",
	'proofreadpage_js_attributes' => 'Autore Titele Anne Pubblicatore',
	'proofreadpage_index_attributes' => "Autore
Titele
Anne|Anne de pubblicazione
Pubblicatore
Sorgende
Immaggine|Immaggine d'a coprtine
Paggène||20
Note||10",
	'proofreadpage_pages' => '{{PLURAL:$1|pàgene|pàggene}}',
	'proofreadpage_specialpage_legend' => 'Cirche le pàggene de indice',
	'proofreadpage_source' => 'Sorgende',
	'proofreadpage_source_message' => 'Edizione scanzionate ausate pe definì stu teste',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'indexpages' => 'Список индексных страниц',
	'proofreadpage_desc' => 'Позволяет в удобном виде сравнивать текст и отсканированное изображение оригинала',
	'proofreadpage_namespace' => 'Страница',
	'proofreadpage_index_namespace' => 'Индекс',
	'proofreadpage_image' => 'изображение',
	'proofreadpage_index' => 'индекс',
	'proofreadpage_index_expected' => 'Ошибка. Индекс не обнаружен.',
	'proofreadpage_nosuch_index' => 'Ошибка. Нет такого индекса.',
	'proofreadpage_nosuch_file' => 'Ошибка: нет такого файла',
	'proofreadpage_badpage' => 'Неправильный формат',
	'proofreadpage_badpagetext' => 'Ошибочный формат записываемой страницы.',
	'proofreadpage_indexdupe' => 'Ссылка-дубликат',
	'proofreadpage_indexdupetext' => 'Страницы не могут быть перечислены на индексной странице более одного раза.',
	'proofreadpage_nologin' => 'Не выполнен вход',
	'proofreadpage_nologintext' => 'Вы должны [[Special:UserLogin|представиться системе]] для изменения статуса вычитки страниц.',
	'proofreadpage_notallowed' => 'Изменение не допускается',
	'proofreadpage_notallowedtext' => 'Вы не можете изменить статус вычитки этой страницы.',
	'proofreadpage_number_expected' => 'Ошибка. Ожидается числовое значение.',
	'proofreadpage_interval_too_large' => 'Ошибка. Слишком большой промежуток.',
	'proofreadpage_invalid_interval' => 'Ошибка: неправильный интервал',
	'proofreadpage_nextpage' => 'следующая страница',
	'proofreadpage_prevpage' => 'предыдущая страница',
	'proofreadpage_header' => 'Заголовок (не включается):',
	'proofreadpage_body' => 'Тело страницы (будет включаться):',
	'proofreadpage_footer' => 'Нижний колонтитул (не включается):',
	'proofreadpage_toggleheaders' => 'показывать невключаемые разделы',
	'proofreadpage_quality0_category' => 'Без текста',
	'proofreadpage_quality1_category' => 'Не вычитана',
	'proofreadpage_quality2_category' => 'Проблемная',
	'proofreadpage_quality3_category' => 'Вычитана',
	'proofreadpage_quality4_category' => 'Проверена',
	'proofreadpage_quality0_message' => 'Эта страница не требует вычитки',
	'proofreadpage_quality1_message' => 'Эта страница не была вычитана',
	'proofreadpage_quality2_message' => 'Есть проблемы при вычитке этой страницы',
	'proofreadpage_quality3_message' => 'Эта страница была вычитана',
	'proofreadpage_quality4_message' => 'Эта страница выверена',
	'proofreadpage_index_listofpages' => 'Список страниц',
	'proofreadpage_image_message' => 'Ссылка на страницу индекса',
	'proofreadpage_page_status' => 'Статус страницы',
	'proofreadpage_js_attributes' => 'Автор Название Год Издательство',
	'proofreadpage_index_attributes' => 'Автор
Заголовок
Год|Год публикации
Издатель
Источник
Изображение|Изображение обложки
Страниц||20
Примечания||10',
	'proofreadpage_pages' => '{{PLURAL:$1|страница|страницы|страниц}}',
	'proofreadpage_specialpage_legend' => 'Поиск индексных страниц',
	'proofreadpage_source' => 'Источник',
	'proofreadpage_source_message' => 'Для создания электронной версии текста использовались отсканированные материалы',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'indexpages' => 'Индекс сирэйдэрин тиһигэ',
	'proofreadpage_desc' => 'Оригинаалы уонна скаанердаммыт ойууну тэҥнээн көрөр кыаҕы биэрэр',
	'proofreadpage_namespace' => 'Сирэй',
	'proofreadpage_index_namespace' => 'Индекс',
	'proofreadpage_image' => 'ойуу',
	'proofreadpage_index' => 'индекс',
	'proofreadpage_index_expected' => 'Алҕас: Индекс көстүбэтэ',
	'proofreadpage_nosuch_index' => 'Алҕас: Маннык индекс суох',
	'proofreadpage_nosuch_file' => 'Алҕас: маннык билэ суох',
	'proofreadpage_badpage' => 'Сыыһа формаат',
	'proofreadpage_badpagetext' => 'Суруллар сирэй атын формааттаах.',
	'proofreadpage_indexdupe' => 'Хос сигэ',
	'proofreadpage_indexdupetext' => 'Сирэй индекс сирэйигэр хаста да суруллубат.',
	'proofreadpage_nologin' => 'Киирии сатаммата (сатамматах)',
	'proofreadpage_nologintext' => 'Сирэйи бэрэбиэркэлээһин туругун уларытарга [[Special:UserLogin|бэлиэтэммит ааккын этиэхтээххин]].',
	'proofreadpage_notallowed' => 'Уларытар сатаммат',
	'proofreadpage_notallowedtext' => 'Бу сирэйи бэрэбиэркэлээһин туругун уларытар кыаҕыҥ суох.',
	'proofreadpage_number_expected' => 'Алҕас: Чыыһыла наада',
	'proofreadpage_interval_too_large' => 'Алҕас: наһаа улахан кээмэйи эппиккин',
	'proofreadpage_invalid_interval' => 'Алҕас: сыыһа интервал',
	'proofreadpage_nextpage' => 'Аныгыскы сирэй',
	'proofreadpage_prevpage' => 'Иннинээҕи сирэй',
	'proofreadpage_header' => 'Аата (киллэриллибэт):',
	'proofreadpage_body' => 'Сирэй иһэ (холбонуо):',
	'proofreadpage_footer' => 'Аллараа колонтитул (киллэриллибэт):',
	'proofreadpage_toggleheaders' => 'киллэриллибэт разделлары көрдөр',
	'proofreadpage_quality0_category' => 'Кураанах',
	'proofreadpage_quality1_category' => 'Ааҕыллыбатах',
	'proofreadpage_quality2_category' => 'Моһоллоох',
	'proofreadpage_quality3_category' => 'Ааҕыллыбыт',
	'proofreadpage_quality4_category' => 'Бэрэбиэркэлэммит',
	'proofreadpage_quality0_message' => 'Бу сирэй бэрэбиэркэлэнэрэ ирдэммэт',
	'proofreadpage_quality1_message' => 'Бу сирэй тургутуллубатах',
	'proofreadpage_quality2_message' => 'Бу сирэйи тургутарга туох эрэ моһол үөскээбит',
	'proofreadpage_quality3_message' => 'Бу сирэй тургутуллубут',
	'proofreadpage_quality4_message' => 'Бу сирэй бэрэбиэкэлэммит (выверка)',
	'proofreadpage_index_listofpages' => 'Сирэйдэр испииһэктэрэ',
	'proofreadpage_image_message' => 'Индекс сирэйигэр ыйынньык',
	'proofreadpage_page_status' => 'Сирэй статуһа',
	'proofreadpage_js_attributes' => 'Ааптар Айымньы Сыла Кыһата',
	'proofreadpage_index_attributes' => 'Ааптар
Айымньы аата
Сыла|Бэчээттэммит сыла
Кыһа аата
Источник
Ойуу|Таһын ойуута
Сирэйин ахсаана||20
Хос быһаарыылара||10',
	'proofreadpage_pages' => '{{PLURAL:$1|сирэй|сирэйдээх}}',
	'proofreadpage_specialpage_legend' => 'Индекстаммыт сирэйдэри көрдөөһүн',
	'proofreadpage_source' => 'Хантан ылыллыбыта',
);

/** Sardinian (Sardu)
 * @author Marzedu
 */
$messages['sc'] = array(
	'proofreadpage_namespace' => 'Pàgina',
	'proofreadpage_index_listofpages' => 'Lista de is pàginas',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'indexpages' => 'Zoznam indexových stránok',
	'proofreadpage_desc' => 'Umožňuje jednoduché porovnanie textu s originálnym skenom',
	'proofreadpage_namespace' => 'Stránka',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'obrázok',
	'proofreadpage_index' => 'Index',
	'proofreadpage_index_expected' => 'Chyba: očakával sa index',
	'proofreadpage_nosuch_index' => 'Chyba: taký index neexistuje',
	'proofreadpage_nosuch_file' => 'Chyba: Taký súbor neexistuje',
	'proofreadpage_badpage' => 'Nesprávny formát',
	'proofreadpage_badpagetext' => 'Formát stránky, ktorú ste sa pokúsili uložiť nie je správny.',
	'proofreadpage_indexdupe' => 'Duplicitný odkaz',
	'proofreadpage_indexdupetext' => 'Stránky nemožno na indexovej stránke uviesť viac ako raz.',
	'proofreadpage_nologin' => 'Nie ste prihlásený',
	'proofreadpage_nologintext' => 'Ak chcete meniť stav skontrolovania stránky, musíte sa [[Special:UserLogin|prihlásiť]].',
	'proofreadpage_notallowed' => 'Zmena nie je dovolená',
	'proofreadpage_notallowedtext' => 'Nemáte dovolené zmeniť stav skontrolovania tejto stránky.',
	'proofreadpage_number_expected' => 'Chyba: očakávala sa číselná hodnota',
	'proofreadpage_interval_too_large' => 'Chyba: interval je príliš veľký',
	'proofreadpage_invalid_interval' => 'Chyba: neplatný interval',
	'proofreadpage_nextpage' => 'Ďalšia stránka',
	'proofreadpage_prevpage' => 'Predošlá stránka',
	'proofreadpage_header' => 'Hlavička (noinclude):',
	'proofreadpage_body' => 'Telo stránky (pre transklúziu):',
	'proofreadpage_footer' => 'Pätka (noinclude):',
	'proofreadpage_toggleheaders' => 'prepnúť viditeľnosť sekcií noinclude',
	'proofreadpage_quality0_category' => 'Bez textu',
	'proofreadpage_quality1_category' => 'Nebolo skontrolované',
	'proofreadpage_quality2_category' => 'Problematické',
	'proofreadpage_quality3_category' => 'Skontrolované',
	'proofreadpage_quality4_category' => 'Overené',
	'proofreadpage_quality0_message' => 'Túto stránku netreba kontrolovať',
	'proofreadpage_quality1_message' => 'Táto stránka nebola skontrolovaná',
	'proofreadpage_quality2_message' => 'Nastal problém pri kontrolovaní tejto stránky',
	'proofreadpage_quality3_message' => 'Táto stránka bola skontrolovaná',
	'proofreadpage_quality4_message' => 'Táto stránka bola overená',
	'proofreadpage_index_listofpages' => 'Zoznam stránok',
	'proofreadpage_image_message' => 'Odkaz na stránku index',
	'proofreadpage_page_status' => 'Stav stránky',
	'proofreadpage_js_attributes' => 'Autor Názov Rok Vydavateľ',
	'proofreadpage_index_attributes' => 'Autor
Názov
Rok|Rok vydania
Vydavateľstvo
Zdroj
Obrázok|Obálka
Strán||20
Poznámky||10',
	'proofreadpage_pages' => '{{PLURAL:$1|stránka|stránky|stránok}}',
	'proofreadpage_specialpage_legend' => 'Hľadať v stránkach indexu',
	'proofreadpage_source' => 'Zdroj',
	'proofreadpage_source_message' => 'Naskenované vydanie použité pri vzniku tohto textu',
);

/** Slovenian (Slovenščina) */
$messages['sl'] = array(
	'proofreadpage_namespace' => 'Stran',
	'proofreadpage_quality1_category' => 'Nekorigirano',
	'proofreadpage_quality2_category' => 'Problematične strani',
	'proofreadpage_quality3_category' => 'Korigirano',
	'proofreadpage_quality4_category' => 'Potrjeno',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Millosh
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'proofreadpage_desc' => 'Омогући лако упоређивање текста и оригиналног скена.',
	'proofreadpage_namespace' => 'Страна',
	'proofreadpage_index_namespace' => 'индекс',
	'proofreadpage_image' => 'слика',
	'proofreadpage_index' => 'индекс',
	'proofreadpage_nextpage' => 'Следећа страна',
	'proofreadpage_prevpage' => 'Претходна страна',
	'proofreadpage_header' => 'Заглавље (без укључивања):',
	'proofreadpage_body' => 'Тело стране (за укључивање):',
	'proofreadpage_footer' => 'Подножје (без укључивања):',
	'proofreadpage_toggleheaders' => 'управљање видљивошћу делова који се не укључују',
	'proofreadpage_quality0_category' => 'Без текста',
	'proofreadpage_quality1_category' => 'Непрегледано',
	'proofreadpage_quality2_category' => 'Проблематично',
	'proofreadpage_quality3_category' => 'Прегледано',
	'proofreadpage_quality4_category' => 'Оверено',
	'proofreadpage_index_listofpages' => 'Списак страна',
	'proofreadpage_image_message' => 'Веза ка индексу стране.',
	'proofreadpage_page_status' => 'Статус стране',
	'proofreadpage_js_attributes' => 'аутор наслов година издавач',
	'proofreadpage_index_attributes' => 'аутор
наслов
година|година публикације
издавач
извор
слика|насловна страна
страна||20
примедбе||10',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'proofreadpage_desc' => 'Omogući lako upoređivanje teksta i originalnog skena.',
	'proofreadpage_namespace' => 'Strana',
	'proofreadpage_index_namespace' => 'indeks',
	'proofreadpage_image' => 'slika',
	'proofreadpage_index' => 'indeks',
	'proofreadpage_nextpage' => 'Sledeća strana',
	'proofreadpage_prevpage' => 'Prethodna strana',
	'proofreadpage_header' => 'Zaglavlje (bez uključivanja):',
	'proofreadpage_body' => 'Telo strane (za uključivanje):',
	'proofreadpage_footer' => 'Podnožje (bez uključivanja):',
	'proofreadpage_toggleheaders' => 'upravljanje vidljivošću delova koji se ne uključuju',
	'proofreadpage_quality0_category' => 'Bez teksta',
	'proofreadpage_quality1_category' => 'Nepregledano',
	'proofreadpage_quality2_category' => 'Problematično',
	'proofreadpage_quality3_category' => 'Pregledano',
	'proofreadpage_quality4_category' => 'Overeno',
	'proofreadpage_index_listofpages' => 'Spisak strana',
	'proofreadpage_image_message' => 'Veza ka indeksu strane.',
	'proofreadpage_page_status' => 'Status strane',
	'proofreadpage_js_attributes' => 'autor naslov godina izdavač',
	'proofreadpage_index_attributes' => 'autor
naslov
godina|godina publikacije
izdavač
izvor
slika|naslovna strana
strana||20
primedbe||10',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'proofreadpage_desc' => 'Moaket dät mäkkelk Ferglieken muugelk fon Text mäd dän Originoalscan',
	'proofreadpage_namespace' => 'Siede',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'Scan',
	'proofreadpage_index' => 'Index',
	'proofreadpage_nextpage' => 'Naiste Siede',
	'proofreadpage_prevpage' => 'Foarige Siede',
	'proofreadpage_header' => 'Kopriege (noinclude):',
	'proofreadpage_body' => 'Textköärper (Transklusion):',
	'proofreadpage_footer' => 'Foutriege (noinclude):',
	'proofreadpage_toggleheaders' => 'noinclude-Ousnitte ien-/uutbländje',
	'proofreadpage_quality1_category' => 'Uunkorrigierd',
	'proofreadpage_quality2_category' => 'Nit fulboodich',
	'proofreadpage_quality3_category' => 'Korrigierd',
	'proofreadpage_quality4_category' => 'Kloor',
	'proofreadpage_index_listofpages' => 'Siedenlieste',
	'proofreadpage_image_message' => 'Ferbiendenge tou ju Indexsiede',
	'proofreadpage_page_status' => 'Siedenstoatus',
	'proofreadpage_js_attributes' => 'Autor Tittel Jier Ferlaach',
	'proofreadpage_index_attributes' => 'Autor
Tittel
Jier|Ärschienengsjier
Ferlaach
Wälle
Bielde|Tittelbielde
Sieden||20
Bemäärkengen||10',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'proofreadpage_namespace' => 'Kaca',
	'proofreadpage_index_namespace' => 'Béréndélan',
	'proofreadpage_image' => 'gambar',
	'proofreadpage_index' => 'Béréndélan',
	'proofreadpage_nextpage' => 'Kaca salajengna',
	'proofreadpage_prevpage' => 'Kaca saméméhna',
	'proofreadpage_index_listofpages' => 'Béréndélan kaca',
	'proofreadpage_image_message' => 'Tumbu ka kaca béréndélan',
	'proofreadpage_page_status' => 'Status kaca',
	'proofreadpage_js_attributes' => 'Pangarang Judul Taun Pamedal',
	'proofreadpage_index_attributes' => 'Pangarang
Judul
Taun|Taun medal
Pamedal
Sumber
Gambar|Gambar jilid
Kaca||20
Catetan||10',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 * @author Rotsee
 */
$messages['sv'] = array(
	'indexpages' => 'Lista över indexsidor',
	'proofreadpage_desc' => 'Ger möjlighet att korrekturläsa texter mot scannade original',
	'proofreadpage_namespace' => 'Sida',
	'proofreadpage_index_namespace' => 'Index',
	'proofreadpage_image' => 'bild',
	'proofreadpage_index' => 'Indexsida',
	'proofreadpage_index_expected' => 'Fel: index förväntades',
	'proofreadpage_nosuch_index' => 'Fel: index saknas',
	'proofreadpage_nosuch_file' => 'Fel: fil saknas',
	'proofreadpage_badpage' => 'Fel format',
	'proofreadpage_badpagetext' => 'Sidan du försöker spara har ett felaktigt format.',
	'proofreadpage_indexdupe' => 'Dubblett av länk',
	'proofreadpage_indexdupetext' => 'Sidor kan inte listas mer än en gång på en index-sida.',
	'proofreadpage_nologin' => 'Ej inloggad',
	'proofreadpage_nologintext' => 'Du måste vara [[Special:UserLogin|inloggad]] för att förändra status på korrekturläsningen av sidor.',
	'proofreadpage_notallowed' => 'Förändring är inte tillåten',
	'proofreadpage_notallowedtext' => 'Du har inte rättigheter att ändra status på korrekturläsningen av den här sidan.',
	'proofreadpage_number_expected' => 'Fel: ett numeriskt värde förväntades',
	'proofreadpage_interval_too_large' => 'Fel: ett för stort intervall',
	'proofreadpage_invalid_interval' => 'Fel: ogiltigt intervall',
	'proofreadpage_nextpage' => 'Nästa sida',
	'proofreadpage_prevpage' => 'Föregående sida',
	'proofreadpage_header' => 'Sidhuvud (inkluderas ej):',
	'proofreadpage_body' => 'Sidinnehåll (som ska inkluderas):',
	'proofreadpage_footer' => 'Sidfot (inkluderas ej):',
	'proofreadpage_toggleheaders' => 'visa/dölj sidhuvud',
	'proofreadpage_quality0_category' => 'Utan text',
	'proofreadpage_quality1_category' => 'Ej korrekturläst',
	'proofreadpage_quality2_category' => 'Ofullständigt',
	'proofreadpage_quality3_category' => 'Korrekturläst',
	'proofreadpage_quality4_category' => 'Validerat',
	'proofreadpage_quality0_message' => 'Den här sidan behöver inte korrekturläsas',
	'proofreadpage_quality1_message' => 'Den här sidan har inte korrekturlästs',
	'proofreadpage_quality2_message' => 'Ett problem uppstod när den här sidan skulle korrekturläsas',
	'proofreadpage_quality3_message' => 'Den här sidan har korrekturlästs',
	'proofreadpage_quality4_message' => 'Den här sidan har godkänts',
	'proofreadpage_index_listofpages' => 'Lista över sidor',
	'proofreadpage_image_message' => 'Länk till indexsidan',
	'proofreadpage_page_status' => 'Sidans status',
	'proofreadpage_js_attributes' => 'Författare Titel År Utgivare',
	'proofreadpage_index_attributes' => 'Upphovsman
Titel
År|Utgivningsår
Utgivare
Källa
Bild|Omslagsbild
Sidor||20
Anmärkningar||10',
	'proofreadpage_pages' => '{{PLURAL:$1|sida|sidor}}',
	'proofreadpage_specialpage_legend' => 'Sök i indexsidorna',
	'proofreadpage_source' => 'Källa',
	'proofreadpage_source_message' => 'Scannat orginal använt för att skapa denna text',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'proofreadpage_namespace' => 'Zajta',
	'proofreadpage_image' => 'uobrozek',
	'proofreadpage_nextpage' => 'Nostympno zajta',
	'proofreadpage_prevpage' => 'Popředńo zajta',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Mpradeep
 * @author Veeven
 * @author రాకేశ్వర
 */
$messages['te'] = array(
	'indexpages' => 'సూచిక పుటల జాబితా',
	'proofreadpage_desc' => 'గద్యానికీ అసలు బొమ్మకు (స్కాన్) మధ్యన తేలికగా పోల్చిచూపడాన్ని అనుమతించు',
	'proofreadpage_namespace' => 'పుట',
	'proofreadpage_index_namespace' => 'సూచిక',
	'proofreadpage_image' => 'బొమ్మ',
	'proofreadpage_index' => 'సూచిక',
	'proofreadpage_index_expected' => 'పొరపాటు: సూచిక వుండవలసినది',
	'proofreadpage_nosuch_index' => 'పొరపాటు: అటువంటి సూచిక లేదు',
	'proofreadpage_nosuch_file' => 'పొరపాటు: అటువంటి దస్త్రం లేదు',
	'proofreadpage_badpage' => 'తప్పుడు రూపము(format)',
	'proofreadpage_badpagetext' => 'మీరు భద్రపరచడానికి ప్రయత్నించిన పుట యొక్క రూపం చెల్లదు.',
	'proofreadpage_indexdupe' => 'నకిలీ లంకె',
	'proofreadpage_indexdupetext' => 'ఒక సూచికలో ఒక పుటను ఒక్క సారి కంటే ఎక్కువ ఎక్కించరాదు.',
	'proofreadpage_nologin' => 'లోనికి ప్రవేశించిలేరు',
	'proofreadpage_nologintext' => 'పుట అచ్చుదిద్దుస్థితి మార్చడానికి మీరు [[ప్రత్యేక:వాడుకరిప్రవేశం|లోనికి ప్రవేశించి]] వుండాలి.',
	'proofreadpage_notallowed' => 'మార్పడానికి అనుమతి లేదు',
	'proofreadpage_notallowedtext' => 'ఈ పుటయొక్క అచ్చుదిద్దుస్థితిని మార్చడానికి మీరు తగరు.',
	'proofreadpage_number_expected' => 'పొరబాటు: సంఖ్య వుండవలెను',
	'proofreadpage_interval_too_large' => 'పొరబాటు: గడువు మఱీ ఎక్కువగా వున్నది',
	'proofreadpage_invalid_interval' => 'పొరబాటు: గడువు చెల్లదు',
	'proofreadpage_nextpage' => 'తరువాతి పుట',
	'proofreadpage_prevpage' => 'క్రిత పుట',
	'proofreadpage_header' => 'శీర్షిక (కలుపకు):',
	'proofreadpage_body' => 'పుటావస్తువు (పుట నుండి లాక్కోబడవలసిన వస్తువు):',
	'proofreadpage_footer' => 'పాదము (కలుపకు):',
	'proofreadpage_toggleheaders' => 'చూపించకూడని భాగాలను(noinclude sections) చూపించడం లేదా చూపించకపోవడాన్ని మార్చండి',
	'proofreadpage_quality0_category' => 'పాఠ్యం లేనివి',
	'proofreadpage_quality1_category' => 'అచ్చుదిద్దబడలేదు.',
	'proofreadpage_quality2_category' => 'అచ్చుదిద్దుడు సమస్యాత్మకం',
	'proofreadpage_quality3_category' => 'అచ్చుదిద్దబడినవి',
	'proofreadpage_quality4_category' => 'ఆమోదించబడ్డవి',
	'proofreadpage_quality0_message' => 'ఈ పుటను అచ్చుదిద్దనక్కరలేదు',
	'proofreadpage_quality1_message' => 'ఈ పుట అచ్చుదిద్దబడలేదు',
	'proofreadpage_quality2_message' => 'ఈ పుటను అచ్చుదిద్దుతున్నప్పుడు తెలియని సమస్య ఎదురైనది',
	'proofreadpage_quality3_message' => 'ఈ పుట అచ్చుదిద్దబడ్డది',
	'proofreadpage_quality4_message' => 'ఈ పుట ఆమోదించబడ్డది',
	'proofreadpage_index_listofpages' => 'పుటల జాబితా',
	'proofreadpage_image_message' => 'సూచిక పుటకు లంకె',
	'proofreadpage_page_status' => 'పుట స్థితి',
	'proofreadpage_js_attributes' => 'రచయిత శీర్షిక సంవత్సరం ప్రచురణకర్త',
	'proofreadpage_index_attributes' => 'రచయిత
శీర్షిక
సంవత్సరం|ప్రచురణ సంవత్సరం
ప్రచురణకర్త
మూలం
బొమ్మ|ముఖచిత్రం
పుటలు||20
వ్యాఖ్యలు||10',
	'proofreadpage_pages' => '{{PLURAL:$1|పుట|పుటలు}}',
	'proofreadpage_specialpage_legend' => 'సూచీపుటలు వెదకు',
	'proofreadpage_source' => 'మూలము',
	'proofreadpage_source_message' => 'ఈ పాఠ్య నిర్ధారణకు ఛాయాచిత్రసంగ్రహణకూర్పు(scanned edition) వాడబడ్డది.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'proofreadpage_namespace' => 'Pájina',
	'proofreadpage_nextpage' => 'Pájina oinmai',
	'proofreadpage_prevpage' => 'Pájina molok',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'proofreadpage_desc' => 'Имкони муқоисаи осони матн бо нусхаи аслии пӯйишшударо фароҳам меоварад',
	'proofreadpage_namespace' => 'Саҳифа',
	'proofreadpage_index_namespace' => 'Индекс',
	'proofreadpage_image' => 'акс',
	'proofreadpage_index' => 'Индекс',
	'proofreadpage_nextpage' => 'Саҳифаи баъдӣ',
	'proofreadpage_prevpage' => 'Саҳифаи қаблӣ',
	'proofreadpage_header' => 'Унвон (noinclude):',
	'proofreadpage_body' => 'Тани саҳифа (барои ғунҷонида шудан):',
	'proofreadpage_footer' => 'Понавис (noinclude):',
	'proofreadpage_toggleheaders' => 'тағйири намоёнии бахшҳои noinclude',
	'proofreadpage_quality1_category' => 'Бозбинӣ нашуда',
	'proofreadpage_quality2_category' => 'Мушкилдор',
	'proofreadpage_quality3_category' => 'Бозбинишуда',
	'proofreadpage_quality4_category' => 'Таъйидшуда',
	'proofreadpage_index_listofpages' => 'Феҳристи саҳифаҳо',
	'proofreadpage_image_message' => 'Пайванд ба саҳифаи индекс',
	'proofreadpage_page_status' => 'Вазъияти саҳифа',
	'proofreadpage_js_attributes' => 'Муаллиф Унвон Сол Нашриёт',
	'proofreadpage_index_attributes' => 'Муаллиф
Унвон
Сол|Соли интишор
Нашриёт
Манбаъ
Акс|Акси рӯи ҷилд
Саҳифаҳо||20
Мулоҳизот||10',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'proofreadpage_desc' => 'Imkoni muqoisai osoni matn bo nusxai asliji pūjişşudaro faroham meovarad',
	'proofreadpage_namespace' => 'Sahifa',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'aks',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_nextpage' => "Sahifai ba'dī",
	'proofreadpage_prevpage' => 'Sahifai qablī',
	'proofreadpage_header' => 'Unvon (noinclude):',
	'proofreadpage_body' => 'Tani sahifa (baroi ƣunçonida şudan):',
	'proofreadpage_footer' => 'Ponavis (noinclude):',
	'proofreadpage_toggleheaders' => 'taƣjiri namojoniji baxşhoi noinclude',
	'proofreadpage_quality1_category' => 'Bozbinī naşuda',
	'proofreadpage_quality2_category' => 'Muşkildor',
	'proofreadpage_quality3_category' => 'Bozbinişuda',
	'proofreadpage_quality4_category' => "Ta'jidşuda",
	'proofreadpage_index_listofpages' => 'Fehristi sahifaho',
	'proofreadpage_image_message' => 'Pajvand ba sahifai indeks',
	'proofreadpage_page_status' => "Vaz'ijati sahifa",
	'proofreadpage_js_attributes' => 'Muallif Unvon Sol Naşrijot',
	'proofreadpage_index_attributes' => "Muallif
Unvon
Sol|Soli intişor
Naşrijot
Manba'
Aks|Aksi rūi çild
Sahifaho||20
Mulohizot||10",
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'proofreadpage_desc' => 'สามารถเปรียบเทียบข้อความกับข้อความต้นฉบับที่สแกนมาได้',
	'proofreadpage_namespace' => 'หน้า',
	'proofreadpage_index_namespace' => 'ดัชนี',
	'proofreadpage_image' => 'ภาพ',
	'proofreadpage_index' => 'ดัชนี',
	'proofreadpage_nextpage' => 'หน้าต่อไป',
	'proofreadpage_prevpage' => 'หน้าก่อนหน้านี้',
	'proofreadpage_header' => 'หัวเรื่อง (noinclude) :',
	'proofreadpage_body' => 'เนื้อหาของหน้า (จะถูกรวมไปด้วย):',
	'proofreadpage_footer' => 'ส่วนท้าย (noinclude):',
	'proofreadpage_toggleheaders' => 'ซ่อนส่วน noinclude',
	'proofreadpage_quality1_category' => 'ยังไม่ได้ตรวจสอบ',
	'proofreadpage_quality2_category' => 'มีปัญหา',
	'proofreadpage_quality3_category' => 'พิสูจน์อักษร',
	'proofreadpage_quality4_category' => 'ยืนยัน',
	'proofreadpage_index_listofpages' => 'รายชื่อหน้า',
	'proofreadpage_image_message' => 'ลิงก์ไปยังหน้าดัชนี',
	'proofreadpage_page_status' => 'สถานะของหน้า',
	'proofreadpage_js_attributes' => 'ผู้แต่ง หัวเรื่อง ปี ผู้พิมพ์',
	'proofreadpage_index_attributes' => 'ผู้แต่ง
ชื่อเรื่อง
ปี|ปีที่พิมพ์
สำนักพิมพ์
แหล่งที่มา
ภาพ|ภาพหน้าปก
หน้า||20
หมายเหตุ||10',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'indexpages' => 'Indeks sahypalarynyň sanawy',
	'proofreadpage_desc' => 'Original skanirleme bilen tekstiň aňsat deňedirilmegine rugsat berýär',
	'proofreadpage_namespace' => 'Sahypa',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'surat',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_index_expected' => 'Säwlik: indekse garaşylýardy',
	'proofreadpage_nosuch_index' => 'Säwlik: beýle indeks ýok',
	'proofreadpage_nosuch_file' => 'Säwlik: beýle faýl ýok',
	'proofreadpage_badpage' => 'Ýalňyş format',
	'proofreadpage_badpagetext' => 'Ýazdyrjak bolan sahypaňyzyň formaty nädogry',
	'proofreadpage_indexdupe' => 'Dublikat çykgyt',
	'proofreadpage_indexdupetext' => 'Sahypalar bir indeks sahypasynda birden artykmaç sanawlanyp bilmeýär.',
	'proofreadpage_nologin' => 'Sessiýa açylmadyk',
	'proofreadpage_nologintext' => 'Sahypalryň okap düzetmek statusyny üýtgetmek üçin [[Special:UserLogin|sessiýa açmaly]].',
	'proofreadpage_notallowed' => 'Üýtgeşmä rugsat berilmeýär',
	'proofreadpage_notallowedtext' => 'Bu sahypanyň okap görmek statusyny üýtgetmäge rugsadyňyz ýok.',
	'proofreadpage_number_expected' => 'Säwlik: san bahasyna garaşylýar',
	'proofreadpage_interval_too_large' => 'Säwlik: aralyk örän giň',
	'proofreadpage_invalid_interval' => 'Säwlik: nädogry aralyk',
	'proofreadpage_nextpage' => 'Indiki sahypa',
	'proofreadpage_prevpage' => 'Öňki sahypa',
	'proofreadpage_header' => 'At (degişli däl):',
	'proofreadpage_body' => 'Sahypa göwresi (atanaklaýyn girizilmeli):',
	'proofreadpage_footer' => 'Futer (goşma):',
	'proofreadpage_toggleheaders' => 'degişli däl bölümleriň görkezilişini üýtget',
	'proofreadpage_quality0_category' => 'Tekstsiz',
	'proofreadpage_quality1_category' => 'Okalyp barlanmadyk',
	'proofreadpage_quality2_category' => 'Problemaly',
	'proofreadpage_quality3_category' => 'Okap barla',
	'proofreadpage_quality4_category' => 'Barlanan',
	'proofreadpage_quality0_message' => 'Bu sahypany okap barlamak gerek däl',
	'proofreadpage_quality1_message' => 'Bu sahypa okalyp barlanylmandyr',
	'proofreadpage_quality2_message' => 'Bu sahypa okalyp barlananda bir problema çykdy',
	'proofreadpage_quality3_message' => 'Bu sahypa okalyp barlandy',
	'proofreadpage_quality4_message' => 'Bu sahypa barlanan',
	'proofreadpage_index_listofpages' => 'Sahypalaryň sanawy',
	'proofreadpage_image_message' => 'Indeks sahypasyna çykgyt',
	'proofreadpage_page_status' => 'Sahypanyň statusy',
	'proofreadpage_js_attributes' => 'Awtor At Ýyl Neşirýat',
	'proofreadpage_index_attributes' => 'Awtor
At
Ýyl|Neşir edilen ýyly
Neşirýat
Çeşme
Surat|Sahap suraty
Sahypa||20
Bellikler||10',
	'proofreadpage_pages' => '{{PLURAL:$1|sahypa|sahypa}}',
	'proofreadpage_specialpage_legend' => 'Indeks sahypalaryny gözle',
	'proofreadpage_source' => 'Çeşme',
	'proofreadpage_source_message' => 'Bu teksti döretmek üçin ulanylan skanirlenen wersiýa',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'proofreadpage_desc' => 'Pahintulutan ang madaling paghahambing ng teksto sa orihinal na kuha (iskan) ng larawan',
	'proofreadpage_namespace' => 'Pahina',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'larawan',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_nextpage' => 'Susunod na pahina',
	'proofreadpage_prevpage' => 'Sinundang pahina',
	'proofreadpage_header' => 'Paulo (huwagisama):',
	'proofreadpage_body' => 'Katawan ng pahina (ililipat-sama):',
	'proofreadpage_footer' => 'Talababa (huwagisama):',
	'proofreadpage_toggleheaders' => 'pindutin-palitan huwagibilang mga seksyon antas ng pagkanatatanaw',
	'proofreadpage_quality1_category' => 'Hindi pa nababasa, napaghahambing, at naiwawasto ang mga mali',
	'proofreadpage_quality2_category' => 'May suliranin',
	'proofreadpage_quality3_category' => 'Basahin, paghambingin, at magwasto ng kamalian',
	'proofreadpage_quality4_category' => 'Napatotohanan na',
	'proofreadpage_index_listofpages' => 'Talaan ng mga pahina',
	'proofreadpage_image_message' => 'Kawing patungo sa pahina ng pagpapaksa (indeks)',
	'proofreadpage_page_status' => 'Kalagayan ng pahina',
	'proofreadpage_js_attributes' => 'May-akda Pamagat Taon Tapaglathala',
	'proofreadpage_index_attributes' => 'May-akda
Pamagat
Taon|Taon ng paglalathala
Tagapaglathala
Pinagmulan
Larawan|Pabalat na larawan
Mga pahina||20
Mga puna||10',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Mach
 * @author Runningfridgesrule
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'indexpages' => 'Endeks sayfalarının listesi',
	'proofreadpage_desc' => 'Orijinal taramayla metnin kolayca karşılaştırılmasına izin verir',
	'proofreadpage_namespace' => 'Sayfa',
	'proofreadpage_index_namespace' => 'Endeks',
	'proofreadpage_image' => 'resim',
	'proofreadpage_index' => 'Dizin',
	'proofreadpage_index_expected' => 'Hata: dizin bekleniyordu',
	'proofreadpage_nosuch_index' => 'Hata: böyle bir dizin yok',
	'proofreadpage_nosuch_file' => 'Hata: Böyle bir dosya yok',
	'proofreadpage_badpage' => 'Yanlış Biçim',
	'proofreadpage_badpagetext' => 'Kaydetmeye çalıştığınız sayfanın biçimi yanlış.',
	'proofreadpage_indexdupe' => 'Yinelenen bağlantı',
	'proofreadpage_indexdupetext' => 'Bir dizin sayfasında, sayfalar birden fazla listelenemez.',
	'proofreadpage_nologin' => 'Giriş yapılmamış',
	'proofreadpage_nologintext' => 'Sayfaların düzeltme durumunu değiştirmek için [[Special:UserLogin|giriş yapmış]] olmalısınız.',
	'proofreadpage_notallowed' => 'Değişikliğe izin verilmiyor',
	'proofreadpage_notallowedtext' => 'Bu sayfanın düzeltme durumunu değiştirmenize izin verilmiyor.',
	'proofreadpage_number_expected' => 'Hata: sayısal değer bekleniyordu',
	'proofreadpage_interval_too_large' => 'Hata: aralık çok büyük',
	'proofreadpage_invalid_interval' => 'Hata: geçersiz aralık',
	'proofreadpage_nextpage' => 'Gelecek sayfa',
	'proofreadpage_prevpage' => 'Önceki sayfa',
	'proofreadpage_header' => 'Başlık (içerme):',
	'proofreadpage_body' => 'Sayfa gövdesi (çapraz eklenecek):',
	'proofreadpage_footer' => 'Alt bilgi (içerme):',
	'proofreadpage_toggleheaders' => 'içerilmeyen bölümlerinin görünürlüğünü değiştir',
	'proofreadpage_quality0_category' => 'Metinsiz',
	'proofreadpage_quality1_category' => 'Düzeltilmemiş',
	'proofreadpage_quality2_category' => 'Sorunlu',
	'proofreadpage_quality3_category' => 'Düzelt',
	'proofreadpage_quality4_category' => 'Doğrulanmış',
	'proofreadpage_quality0_message' => 'Bu sayfada düzeltme yapılması gerekmez',
	'proofreadpage_quality1_message' => 'Bu sayfada düzeltme yapılmadı',
	'proofreadpage_quality2_message' => 'Bu sayfada düzeltme yapılırken bir sorun oluştu',
	'proofreadpage_quality3_message' => 'Bu sayfada düzeltme yapıldı',
	'proofreadpage_quality4_message' => 'Bu sayfa doğrulanmış',
	'proofreadpage_index_listofpages' => 'Sayfalar listesi',
	'proofreadpage_image_message' => 'Endeks sayfasına bağlantı',
	'proofreadpage_page_status' => 'Sayfa durumu',
	'proofreadpage_js_attributes' => 'Yazar Başlık Yıl Yayımcı',
	'proofreadpage_index_attributes' => 'Yazar
Başlık
Yıl|Yayım yılı
Yayımcı
Kaynak
Resim|Kapak resmi
Sayfalar||20
Açıklamalar||10',
	'proofreadpage_pages' => '{{PLURAL:$1|sayfa|sayfa}}',
	'proofreadpage_specialpage_legend' => 'Dizin sayfalarını ara',
	'proofreadpage_source' => 'Kaynak',
	'proofreadpage_source_message' => 'Bu metni oluşturmak için kullanılan taranmış sürüm',
);

/** Tsonga (Xitsonga)
 * @author Thuvack
 */
$messages['ts'] = array(
	'proofreadpage_namespace' => 'Tluka',
	'proofreadpage_index_namespace' => 'Nxaxamelo',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Timming
 */
$messages['tt-cyrl'] = array(
	'proofreadpage_nextpage' => 'алдагы бит',
);

/** Uighur (Latin) (Uyghurche‎ / ئۇيغۇرچە (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'proofreadpage_namespace' => 'Bet',
	'proofreadpage_nextpage' => 'Kéyinki bet',
	'proofreadpage_prevpage' => 'Aldinqi bet',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'indexpages' => 'Список індексових сторінок',
	'proofreadpage_desc' => 'Дозволяє легко порівнювати текст і відскановане зображення оригіналу',
	'proofreadpage_namespace' => 'Сторінка',
	'proofreadpage_index_namespace' => 'Індекс',
	'proofreadpage_image' => 'зображення',
	'proofreadpage_index' => 'Індекс',
	'proofreadpage_index_expected' => 'Помилка: очікувано індексу.',
	'proofreadpage_nosuch_index' => 'Помилка: нема такого індексу',
	'proofreadpage_nosuch_file' => 'Помилка: нема такого файлу',
	'proofreadpage_badpage' => 'Неправильний формат',
	'proofreadpage_badpagetext' => 'Формат сторінки, яку ви хочете зберегти, неправильний.',
	'proofreadpage_indexdupe' => 'Посилання-дублікат',
	'proofreadpage_indexdupetext' => 'Сторінки не можуть бути перелічені в списку на сторінці індексації більше одного разу.',
	'proofreadpage_nologin' => 'Не виконаний вхід',
	'proofreadpage_nologintext' => 'Ви повинні [[Special:UserLogin|увійти в систему]], щоб змінити статус коректури сторінок.',
	'proofreadpage_notallowed' => 'Зміна не дозволена',
	'proofreadpage_notallowedtext' => 'Ви не можете змінити статус коректури цієї сторінки.',
	'proofreadpage_number_expected' => 'Помилка: потрібне числове значення',
	'proofreadpage_interval_too_large' => 'Помилка: інтервал занадто великий',
	'proofreadpage_invalid_interval' => 'Помилка: неправильній інтервал',
	'proofreadpage_nextpage' => 'Наступна сторінка',
	'proofreadpage_prevpage' => 'Попередня сторінка',
	'proofreadpage_header' => 'Заголовок (не включається):',
	'proofreadpage_body' => 'Тіло сторінки (буде включатися):',
	'proofreadpage_footer' => 'Нижній колонтитул (не включається):',
	'proofreadpage_toggleheaders' => 'показувати невключені розділи',
	'proofreadpage_quality0_category' => 'Без тексту',
	'proofreadpage_quality1_category' => 'Не вичитана',
	'proofreadpage_quality2_category' => 'Проблематична',
	'proofreadpage_quality3_category' => 'Вичитана',
	'proofreadpage_quality4_category' => 'Перевірена',
	'proofreadpage_quality0_message' => 'Ця сторінка не потребує коректури',
	'proofreadpage_quality1_message' => 'Ця сторінка ще не пройшла коректури',
	'proofreadpage_quality2_message' => 'Виникла проблема з коректурою цієї сторінки',
	'proofreadpage_quality3_message' => 'Ця сторінка пройшла коректуру',
	'proofreadpage_quality4_message' => 'Ця сторінка була затверджена',
	'proofreadpage_index_listofpages' => 'Список сторінок',
	'proofreadpage_image_message' => 'Посилання на сторінку індексу',
	'proofreadpage_page_status' => 'Стан сторінки',
	'proofreadpage_js_attributes' => 'Автор Назва Рік Видавництво',
	'proofreadpage_index_attributes' => 'Автор
Назва
Рік|Рік видання
Видавництво
Джерело
Зображення|Зображення обкладинки
Сторінок||20
Приміток||10',
	'proofreadpage_pages' => '{{PLURAL:$1|сторінка|сторінки|сторінок}}',
	'proofreadpage_specialpage_legend' => 'Пошук сторінок індексації',
	'proofreadpage_source' => 'Джерело',
	'proofreadpage_source_message' => 'Для створення цього тексту використані відскановані видання',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'indexpages' => 'Elenco de le pagine de indice',
	'proofreadpage_desc' => 'Parméte un façile confronto tra un testo e la so scansion original',
	'proofreadpage_namespace' => 'Pagina',
	'proofreadpage_index_namespace' => 'Indice',
	'proofreadpage_image' => 'imagine',
	'proofreadpage_index' => 'Indice',
	'proofreadpage_index_expected' => 'Eròr: indice mancante',
	'proofreadpage_nosuch_index' => "Eròr: sto indice no'l xe presente",
	'proofreadpage_nosuch_file' => 'Eròr: file mia catà',
	'proofreadpage_badpage' => 'Formato sbalià',
	'proofreadpage_badpagetext' => "El formato de la pagina che te ghe sercà de salvar no'l xe giusto.",
	'proofreadpage_indexdupe' => 'Colegamento dopio',
	'proofreadpage_indexdupetext' => 'Le pagine no se pol elencarle pi de na olta su na pagina de indice.',
	'proofreadpage_nologin' => 'Acesso mia efetuà',
	'proofreadpage_nologintext' => 'Te ghè da èssar [[Special:UserLogin|autenticà]] par canbiar el stato de revision de le pagine.',
	'proofreadpage_notallowed' => 'Canbiamento mia parmesso',
	'proofreadpage_notallowedtext' => 'No te ghè el parmesso de canbiar el stato de revision de le pagine.',
	'proofreadpage_number_expected' => 'Eròr: me spetavo un valor numerico',
	'proofreadpage_interval_too_large' => 'Eròr: intervalo massa grando',
	'proofreadpage_invalid_interval' => 'Eròr: intervalo mia valido',
	'proofreadpage_nextpage' => 'Pagina sucessiva',
	'proofreadpage_prevpage' => 'Pagina precedente',
	'proofreadpage_header' => 'Intestazion (mìa inclusa):',
	'proofreadpage_body' => 'Corpo de la pagina (da inclùdar):',
	'proofreadpage_footer' => 'Pié de pagina (mìa incluso)',
	'proofreadpage_toggleheaders' => 'ativa/disativa la visibilità de le sezioni mìa incluse',
	'proofreadpage_quality0_category' => 'Sensa testo',
	'proofreadpage_quality1_category' => 'Da corègiar',
	'proofreadpage_quality2_category' => 'Da rivédar',
	'proofreadpage_quality3_category' => 'Corèta',
	'proofreadpage_quality4_category' => 'Verificà',
	'proofreadpage_quality0_message' => 'Sta pagina no serve corègerla',
	'proofreadpage_quality1_message' => 'Sta pagina no la xe mia stà ricontrolà',
	'proofreadpage_quality2_message' => 'Ghe xe stà un problema durante la corezion de sta pagina',
	'proofreadpage_quality3_message' => 'Sta pagina la xe stà controlà e corèta',
	'proofreadpage_quality4_message' => 'Sta pagina la xe stà validà',
	'proofreadpage_index_listofpages' => 'Lista de le pagine',
	'proofreadpage_image_message' => 'Colegamento a la pagina indice',
	'proofreadpage_page_status' => 'Status de la pagina',
	'proofreadpage_js_attributes' => 'Autor Titolo Ano Editor',
	'proofreadpage_index_attributes' => 'Autor
Titolo
Ano|Ano de pubblicazion
Editor
Fonte
Imagine|Imagine de copertina
Pagine||20
Note||10',
	'proofreadpage_pages' => '{{PLURAL:$1|pagina|pagine}}',
	'proofreadpage_specialpage_legend' => 'Serca in te le pagine de indice',
	'proofreadpage_source' => 'Fonte',
	'proofreadpage_source_message' => 'Edission scanerizà doparà par inserir sto testo',
);

/** Veps (Vepsan kel')
 * @author Triple-ADHD-AS
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'proofreadpage_namespace' => 'Lehtpol’',
	'proofreadpage_index_namespace' => 'Indeks',
	'proofreadpage_image' => 'kuva',
	'proofreadpage_index' => 'Indeks',
	'proofreadpage_nosuch_index' => 'Petuz: ei ole mugošt indeksad',
	'proofreadpage_nosuch_file' => 'Petuz: ei ole mugošt failad',
	'proofreadpage_badpage' => 'Vär format',
	'proofreadpage_indexdupe' => 'Kaksitadud kosketuz',
	'proofreadpage_invalid_interval' => 'Petuz: vär interval',
	'proofreadpage_nextpage' => "Jäl'ghine lehtpol'",
	'proofreadpage_prevpage' => "Edeline lehtpol'",
	'proofreadpage_header' => 'Pälkirjutez (ei ele mülütadud)',
	'proofreadpage_body' => 'Lehtpolen tüvi (mülütadas):',
	'proofreadpage_quality0_category' => 'Tekstata',
	'proofreadpage_quality1_category' => 'Ei ole lugetud kodvaks',
	'proofreadpage_quality2_category' => 'Problematine',
	'proofreadpage_quality3_category' => 'Om lugetud kodvaks',
	'proofreadpage_quality4_category' => 'Kodvdud da hüvästadud',
	'proofreadpage_index_listofpages' => 'Lehtpoliden nimikirjutez',
	'proofreadpage_page_status' => 'Lehtpolen status',
	'proofreadpage_index_attributes' => "Avtor
Pälkirjutez
Voz'|Pästandvoz'
Pästai
Purde
Kuva|Kirjankoren kuva
Lehtpol't||20
Homaičendad||10",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'indexpages' => 'Danh sách các trang mục lục',
	'proofreadpage_desc' => 'Cho phép dễ dàng so sánh văn bản với hình quét gốc',
	'proofreadpage_namespace' => 'Trang',
	'proofreadpage_index_namespace' => 'Mục lục',
	'proofreadpage_image' => 'hình',
	'proofreadpage_index' => 'Mục lục',
	'proofreadpage_index_expected' => 'Lỗi: cần mục lục',
	'proofreadpage_nosuch_index' => 'Lỗi: không có mục lục như vậy',
	'proofreadpage_nosuch_file' => 'Lỗi: không có tập tin như vậy',
	'proofreadpage_badpage' => 'Định dạng sai',
	'proofreadpage_badpagetext' => 'Định dạng của trang bạn đang cố lưu là không đúng.',
	'proofreadpage_indexdupe' => 'Liên kết lặp lại',
	'proofreadpage_indexdupetext' => 'Không thể liệt kê trang quá một lần tại một trang mục lục.',
	'proofreadpage_nologin' => 'Chưa đăng nhập',
	'proofreadpage_nologintext' => 'Bạn phải [[Special:UserLogin|đăng nhập]] để sửa đổi tình trạng hiệu đính của trang.',
	'proofreadpage_notallowed' => 'Không được phép thay đổi',
	'proofreadpage_notallowedtext' => 'Bạn không được phép thay đổi tình trạng hiệu đính của trang này.',
	'proofreadpage_number_expected' => 'Lỗi: cần giá trị số',
	'proofreadpage_interval_too_large' => 'Lỗi: khoảng thời gian quá lớn',
	'proofreadpage_invalid_interval' => 'Lỗi: khoảng thời gian không hợp lệ',
	'proofreadpage_nextpage' => 'Trang sau',
	'proofreadpage_prevpage' => 'Trang trước',
	'proofreadpage_header' => 'Tiêu đề (noinclude):',
	'proofreadpage_body' => 'Nội dung trang (sẽ được nhúng vào):',
	'proofreadpage_footer' => 'Phần cuối (noinclude):',
	'proofreadpage_toggleheaders' => 'thay đổi độ khả kiến của đề mục noinclude',
	'proofreadpage_quality0_category' => 'Không có nội dung',
	'proofreadpage_quality1_category' => 'Chưa hiệu đính',
	'proofreadpage_quality2_category' => 'Có vấn đề',
	'proofreadpage_quality3_category' => 'Đã hiệu đính',
	'proofreadpage_quality4_category' => 'Đã phê chuẩn',
	'proofreadpage_quality0_message' => 'Trang này không cần phải hiệu đính',
	'proofreadpage_quality1_message' => 'Trang này chưa được hiệu đính',
	'proofreadpage_quality2_message' => 'Có vấn đề khi hiệu đính trang này',
	'proofreadpage_quality3_message' => 'Trang này đã được duyệt lại',
	'proofreadpage_quality4_message' => 'Trang này đã được phê chuẩn',
	'proofreadpage_index_listofpages' => 'Danh sách các trang',
	'proofreadpage_image_message' => 'Liên kết trang mục lục',
	'proofreadpage_page_status' => 'Tình trạng của trang',
	'proofreadpage_js_attributes' => 'Tác giả Tựa đề Năm Nhà xuất bản',
	'proofreadpage_index_attributes' => 'Tác giả
Tựa đề
Năm|Năm xuất bản
Nhà xuất bản
Nguồn
Hình|Hình bìa
Các trang||20
Ghi chú||10',
	'proofreadpage_pages' => '{{PLURAL:$1|trang|trang}}',
	'proofreadpage_specialpage_legend' => 'Tìm kiếm trong các trang mục lục',
	'proofreadpage_source' => 'Nguồn',
	'proofreadpage_source_message' => 'Bản quét được dùng để tạo ra văn bản này',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'proofreadpage_namespace' => 'Pad',
	'proofreadpage_image' => 'magod',
	'proofreadpage_nextpage' => 'Pad sököl',
	'proofreadpage_prevpage' => 'Pad büik',
	'proofreadpage_quality0_category' => 'Nen vödem',
	'proofreadpage_quality2_category' => 'Säkädik',
	'proofreadpage_index_listofpages' => 'Padalised',
	'proofreadpage_page_status' => 'Stad pada',
	'proofreadpage_js_attributes' => 'Lautan Tiäd Yel Püban',
	'proofreadpage_index_attributes' => 'Lautan
Tiäd
Yel|Pübayel
Püban
Fonät
Magod|Magod tegoda
Pads|20
Küpets|10',
	'proofreadpage_pages' => '{{PLURAL:$1|pad|pads}}',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'proofreadpage_desc' => '容許簡易噉去比較原掃瞄同埋文字',
	'proofreadpage_namespace' => '頁',
	'proofreadpage_index_namespace' => '索引',
	'proofreadpage_image' => '圖像',
	'proofreadpage_index' => '索引',
	'proofreadpage_nextpage' => '下一版',
	'proofreadpage_prevpage' => '上一版',
	'proofreadpage_header' => '頭 (唔包含):',
	'proofreadpage_body' => '頁身 (去包含):',
	'proofreadpage_footer' => '尾 (唔包含):',
	'proofreadpage_toggleheaders' => '較唔包含小節可見性',
	'proofreadpage_quality1_category' => '未校對',
	'proofreadpage_quality2_category' => '有問題',
	'proofreadpage_quality3_category' => '已校對',
	'proofreadpage_quality4_category' => '已認證',
	'proofreadpage_index_listofpages' => '頁一覽',
	'proofreadpage_image_message' => '連到索引頁嘅連結',
	'proofreadpage_page_status' => '頁狀態',
	'proofreadpage_js_attributes' => '作者 標題 年份 出版者',
	'proofreadpage_index_attributes' => '作者
標題
年份|出版年份
出版者
來源
圖像|封面照
頁數||20
備註||10',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Jimmy xu wrk
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'indexpages' => '索引页列表',
	'proofreadpage_desc' => '容许简易地比较原扫描和文字',
	'proofreadpage_namespace' => '页面',
	'proofreadpage_index_namespace' => '索引',
	'proofreadpage_image' => '图像',
	'proofreadpage_index' => '索引',
	'proofreadpage_index_expected' => '错误：需要索引',
	'proofreadpage_nosuch_index' => '错误：没有此类索引',
	'proofreadpage_nosuch_file' => '错误：没有这种文件',
	'proofreadpage_badpage' => '错误的格式',
	'proofreadpage_badpagetext' => '您试图保存的页面的格式不正确。',
	'proofreadpage_indexdupe' => '重复链接',
	'proofreadpage_indexdupetext' => '在索引页中，页面不会被重复列出。',
	'proofreadpage_nologin' => '没有登录',
	'proofreadpage_nologintext' => '您必须[[Special:UserLogin|先登录]]才能修改页面的校对状态。',
	'proofreadpage_notallowed' => '不允许修改',
	'proofreadpage_notallowedtext' => '您没有获得修改这个页面校对状态的许可。',
	'proofreadpage_number_expected' => '错误：不为数值',
	'proofreadpage_interval_too_large' => '错误：间隔过大',
	'proofreadpage_invalid_interval' => '错误：无法识别间隔',
	'proofreadpage_nextpage' => '下一页',
	'proofreadpage_prevpage' => '上一页',
	'proofreadpage_header' => '首 （不包含）:',
	'proofreadpage_body' => '页身 （包含）:',
	'proofreadpage_footer' => '尾 （不包含）:',
	'proofreadpage_toggleheaders' => '调整不包含段落之可见性',
	'proofreadpage_quality0_category' => '没有文字',
	'proofreadpage_quality1_category' => '未校对',
	'proofreadpage_quality2_category' => '有问题',
	'proofreadpage_quality3_category' => '已校对',
	'proofreadpage_quality4_category' => '已认证',
	'proofreadpage_quality0_message' => '本页面不需要校对',
	'proofreadpage_quality1_message' => '本页面还没有被校对',
	'proofreadpage_quality2_message' => '校对本页时出现了一个问题',
	'proofreadpage_quality3_message' => '本页已经被校对',
	'proofreadpage_quality4_message' => '本页已经被认证',
	'proofreadpage_index_listofpages' => '页面列表',
	'proofreadpage_image_message' => '连到索引页的链接',
	'proofreadpage_page_status' => '页面状态',
	'proofreadpage_js_attributes' => '作者 标题 年份 出版者',
	'proofreadpage_index_attributes' => '作者
标题
年份|出版年份
出版者
来源
图像|封面照
页数||20
备注||10',
	'proofreadpage_pages' => '{{PLURAL:$1|页|页}}',
	'proofreadpage_specialpage_legend' => '搜索索引页',
	'proofreadpage_source' => '来源',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gaoxuewei
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'indexpages' => '索引頁列表',
	'proofreadpage_desc' => '容許簡易地去比較原掃瞄和文字',
	'proofreadpage_namespace' => '頁面',
	'proofreadpage_index_namespace' => '索引',
	'proofreadpage_image' => '圖片',
	'proofreadpage_index' => '索引',
	'proofreadpage_index_expected' => '錯誤：需要索引',
	'proofreadpage_nosuch_index' => '錯誤：沒有此類索引',
	'proofreadpage_nosuch_file' => '錯誤：沒有這種文件',
	'proofreadpage_badpage' => '格式錯誤',
	'proofreadpage_badpagetext' => '您試圖保存的頁面的格式不正確。',
	'proofreadpage_indexdupe' => '重複鏈接',
	'proofreadpage_indexdupetext' => '在索引頁中，頁面不會被重複列出。',
	'proofreadpage_nologin' => '未登入',
	'proofreadpage_nologintext' => '您必须[[Special:UserLogin|先登录]]才能修改页面的校对状态。',
	'proofreadpage_notallowed' => '不允許修改',
	'proofreadpage_notallowedtext' => '您沒有獲得修改這個頁面校對狀態的許可。',
	'proofreadpage_number_expected' => '錯誤：不為數值',
	'proofreadpage_interval_too_large' => '錯誤：間隔過大',
	'proofreadpage_invalid_interval' => '錯誤：無法識別間隔',
	'proofreadpage_nextpage' => '下一頁',
	'proofreadpage_prevpage' => '上一頁',
	'proofreadpage_header' => '首 （不包含）:',
	'proofreadpage_body' => '頁身 （包含）:',
	'proofreadpage_footer' => '尾 （不包含）:',
	'proofreadpage_toggleheaders' => '調整不包含段落之可見性',
	'proofreadpage_quality0_category' => '沒有文字',
	'proofreadpage_quality1_category' => '未校對',
	'proofreadpage_quality2_category' => '有問題',
	'proofreadpage_quality3_category' => '已校對',
	'proofreadpage_quality4_category' => '已認證',
	'proofreadpage_quality0_message' => '本頁不需要校對',
	'proofreadpage_quality1_message' => '本頁面尚未進行校對',
	'proofreadpage_quality2_message' => '校對本頁時出現了一個問題',
	'proofreadpage_quality3_message' => '本頁已經被校對',
	'proofreadpage_quality4_message' => '本頁已經被認證',
	'proofreadpage_index_listofpages' => '頁面清單',
	'proofreadpage_image_message' => '連到索引頁的連結',
	'proofreadpage_page_status' => '頁面狀態',
	'proofreadpage_js_attributes' => '作者 標題 年份 出版者',
	'proofreadpage_index_attributes' => '作者
標題
年份|出版年份
出版者
來源
圖片|封面照
頁數||20
備註||10',
	'proofreadpage_pages' => '{{PLURAL:$1|頁|頁}}',
	'proofreadpage_specialpage_legend' => '搜索索引頁',
	'proofreadpage_source' => '來源',
);

