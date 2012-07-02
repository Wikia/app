<?php
/**
 * Internationalization file for the Data Transfer extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Yaron Koren
 */
$messages['en'] = array(
	'datatransfer-desc'           => 'Allows for importing and exporting data contained in template calls',
	'viewxml'                     => 'View XML',
	'dt_viewxml_docu'             => 'Please select among the following categories and namespaces to view in XML format.',
	'dt_viewxml_categories'       => 'Categories',
	'dt_viewxml_namespaces'       => 'Namespaces',
	'dt_viewxml_simplifiedformat' => 'Simplified format',
	'dt_xml_namespace'            => 'Namespace',
	'dt_xml_pages'                => 'Pages',
	'dt_xml_page'                 => 'Page',
	'dt_xml_template'             => 'Template',
	'dt_xml_field'                => 'Field',
	'dt_xml_name'                 => 'Name',
	'dt_xml_title'                => 'Title',
	'dt_xml_id'                   => 'ID',
	'dt_xml_freetext'             => 'Free Text',
	'importxml'                   => 'Import XML',
	'dt_import_selectfile'        => 'Please select the $1 file to import:',
	'dt_import_encodingtype'      => 'Encoding type:',
	'dt_import_forexisting'       => 'For pages that already exist:',
	'dt_import_overwriteexisting' => 'Overwrite existing content',
	'dt_import_skipexisting'      => 'Skip',
	'dt_import_appendtoexisting'  => 'Append to existing content',
	'dt_import_summarydesc'       => 'Summary of import:',
	'dt_import_editsummary'       => '$1 import',
	'dt_import_importing'         => 'Importing...',
	'dt_import_success'           => '$1 {{PLURAL:$1|page|pages}} will be created from the $2 file.',
	'importcsv'                   => 'Import CSV',
	'dt_importcsv_badheader'      => "Error: the column $1 header, '$2', must be either '$3', '$4' or of the form 'template_name[field_name]'",
	'right-datatransferimport'    => 'Import data',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'datatransfer-desc' => 'Extension description displayed on [[Special:Version]].',
	'dt_viewxml_categories' => '{{Identical|Categories}}',
	'dt_viewxml_namespaces' => '{{Identical|Namespaces}}',
	'dt_xml_namespace' => '{{Identical|Namespace}}
Used as XML tag name.',
	'dt_xml_pages' => '{{Identical|Pages}}

Used as XML tag name.',
	'dt_xml_page' => '{{Identical|Page}}
Used as XML tag name.',
	'dt_xml_template' => '{{Identical|Template}}
Used as XML tag name.',
	'dt_xml_field' => '{{Identical|Field}}
Used as XML tag name.',
	'dt_xml_name' => '{{Identical|Name}}

Used as XML tag name.',
	'dt_xml_title' => '{{Identical|Title}}
Used as XML tag name.',
	'dt_xml_id' => '{{Identical|ID}}

Used as XML tag name.',
	'dt_xml_freetext' => '{{Identical|Free text}}
Used as XML tag name.',
	'dt_import_selectfile' => '$1 is the file format: either CSV or XML',
	'dt_import_encodingtype' => 'The type of encoding for the file: either UTF-8 or UTF-16',
	'dt_import_skipexisting' => '{{Identical|Skip}}',
	'dt_import_editsummary' => '$1 is the file format: either CSV or XML',
	'dt_import_success' => 'Parameters:
* $1 is the number of pages
* $2 is the file format: either CSV or XML',
	'dt_importcsv_badheader' => 'The text "template_name[field_name]" can be translated.
*$1 is a column number in the first row of the CVS file
*$2 is the value found for the $1th colomn in the first line of the CSV file
*$3 is the title label
*$4 is a free text label',
	'right-datatransferimport' => '{{doc-right|datatransferimport}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'dt_viewxml_categories' => 'Katekori',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'datatransfer-desc' => 'Maak die laai en ontlaai van gestruktureerde gegewens in sjabloonaanroepe moontlik',
	'viewxml' => 'Sien XML',
	'dt_viewxml_docu' => 'Kies een van die volgende kategorieë en naamruimtes om in XML-formaat te sien.',
	'dt_viewxml_categories' => 'Ketagorieë',
	'dt_viewxml_namespaces' => 'Naamruimtes',
	'dt_viewxml_simplifiedformat' => 'Vereenvoudigde formaat',
	'dt_xml_namespace' => 'Naamruimte',
	'dt_xml_pages' => 'Bladsye',
	'dt_xml_page' => 'Bladsy',
	'dt_xml_template' => 'Sjabloon',
	'dt_xml_field' => 'Veld',
	'dt_xml_name' => 'Naam',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Vrye teks',
	'importxml' => 'Laai XML',
	'dt_import_selectfile' => 'Kies die $1 lêer om te laai:',
	'dt_import_encodingtype' => 'Enkoderingstipe:',
	'dt_import_skipexisting' => 'Slaan oor',
	'dt_import_editsummary' => '$1-laai',
	'dt_import_importing' => 'Besig om te laai...',
	'dt_import_success' => '$1 {{PLURAL:$1|bladsy|bladsye}} sal geskep word vanaf die lêer $2.',
	'importcsv' => 'Laai CSV',
	'dt_importcsv_badheader' => 'Fout: Die opskrif van kolom $1, "$2", moet "$3" of "$4" wees, of in die vorm "sjabloonnaam[veldnaam]" genoteer word.',
	'right-datatransferimport' => 'Laai data',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'datatransfer-desc' => 'Lejon për import dhe eksport të dhënave të përmbajtura në modelin e quan',
	'viewxml' => 'Shiko XML',
	'dt_viewxml_docu' => 'Ju lutem zgjidhni midis kategorive të mëposhtme dhe hapësira për të parë në formatin XML.',
	'dt_viewxml_categories' => 'Kategoritë',
	'dt_viewxml_namespaces' => 'Hapësira',
	'dt_viewxml_simplifiedformat' => 'Formati i thjeshtuar',
	'dt_xml_namespace' => 'Hapësira',
	'dt_xml_pages' => 'Faqet',
	'dt_xml_page' => 'Faqe',
	'dt_xml_template' => 'Shabllon',
	'dt_xml_field' => 'Fushë',
	'dt_xml_name' => 'Emër',
	'dt_xml_title' => 'Titull',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Free Tekst',
	'importxml' => 'Importi XML',
	'dt_import_selectfile' => 'Ju lutem përzgjidhni kartelën $1 për të importuar:',
	'dt_import_encodingtype' => 'Encoding lloj:',
	'dt_import_editsummary' => '$1 importit',
	'dt_import_importing' => 'Importimi ...',
	'dt_import_success' => '$1 {{PLURAL:$1|faqe|faqe}} do të krijohet nga file $2.',
	'importcsv' => 'Importi CSV',
	'dt_importcsv_badheader' => "Gabim: $1 column header, '$2', duhet të jenë ose '$3', '$4' ose të formës 'template_name [field_name]'",
	'right-datatransferimport' => 'Të dhënat e importit',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'dt_viewxml_categories' => 'መደቦች',
	'dt_viewxml_namespaces' => 'ክፍለ-ዊኪዎች',
	'dt_xml_namespace' => 'ክፍለ-ዊኪ',
	'dt_xml_name' => 'ስም',
	'dt_xml_title' => 'አርዕስት',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 * @author Remember the dot
 */
$messages['an'] = array(
	'dt_viewxml_namespaces' => 'Espacios de nombres',
	'dt_xml_namespace' => 'Espacio de nombres',
	'dt_xml_page' => 'Pachina',
	'dt_xml_template' => 'Plantilla',
	'dt_xml_name' => 'Nombre',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Mutarjem horr
 * @author OsamaK
 */
$messages['ar'] = array(
	'datatransfer-desc' => 'يسمح باستيراد وتصدير بيانات محتواة في استدعاءات قالب',
	'viewxml' => 'عرض XML',
	'dt_viewxml_docu' => 'من فضلك اختر من بين التصنيفات والنطاقات التالية للعرض في صيغة XML.',
	'dt_viewxml_categories' => 'تصنيفات',
	'dt_viewxml_namespaces' => 'نطاقات',
	'dt_viewxml_simplifiedformat' => 'صيغة مبسطة',
	'dt_xml_namespace' => 'نطاق',
	'dt_xml_pages' => 'صفحات',
	'dt_xml_page' => 'صفحة',
	'dt_xml_template' => 'قالب',
	'dt_xml_field' => 'حقل',
	'dt_xml_name' => 'اسم',
	'dt_xml_title' => 'عنوان',
	'dt_xml_id' => 'رقم',
	'dt_xml_freetext' => 'نص حر',
	'importxml' => 'استيراد XML',
	'dt_import_selectfile' => 'من فضلك اختر ملف $1 للاستيراد:',
	'dt_import_encodingtype' => 'نوع الترميز:',
	'dt_import_forexisting' => 'لصفحات موجودة مسبقاّ :',
	'dt_import_overwriteexisting' => 'أكتب على المحتوى الموجود',
	'dt_import_skipexisting' => 'أقفز',
	'dt_import_appendtoexisting' => 'إلحاق بالمحتوى الموجود',
	'dt_import_summarydesc' => 'موجز الاستيراد :',
	'dt_import_editsummary' => 'استيراد $1',
	'dt_import_importing' => 'جاري الاستيراد...',
	'dt_import_success' => 'سوف تُنشأ {{PLURAL:$1||صفحة واحدة|صفحتين|$1 صفحات|$1 صفحة}} من ملف $2.',
	'importcsv' => 'استورد CSV',
	'dt_importcsv_badheader' => "خطأ: عنوان العامود $1، '$2'، يجب أن يكون إما '$3'، '$4' أو من الصيغة 'template_name[field_name]'",
	'right-datatransferimport' => 'استورد بيانات',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'dt_viewxml_categories' => 'ܣܕܪ̈ܐ',
	'dt_viewxml_namespaces' => 'ܚܩܠܬ̈ܐ',
	'dt_xml_namespace' => 'ܚܩܠܐ',
	'dt_xml_pages' => 'ܕ̈ܦܐ',
	'dt_xml_page' => 'ܕܦܐ',
	'dt_xml_template' => 'ܩܠܒܐ',
	'dt_xml_name' => 'ܫܡܐ',
	'dt_xml_title' => 'ܟܘܢܝܐ',
	'dt_xml_id' => 'ܗܝܝܘܬܐ',
	'dt_import_summarydesc' => 'ܦܣܝܩܬ̈ܐ ܕܡܥܠܢܘܬܐ:',
	'right-datatransferimport' => 'ܡܥܠܢܘܬܐ ܕܓܠܝܬ̈ܐ',
);

/** Araucanian (Mapudungun)
 * @author Remember the dot
 */
$messages['arn'] = array(
	'dt_xml_page' => 'Pakina',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Dudi
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'datatransfer-desc' => 'بيسمح بـ import و export للداتا اللى جوّا القالب',
	'viewxml' => 'شوف XML',
	'dt_viewxml_docu' => 'لو سمحت اختار من التصانيف و اسامى المساحات الجايه علشان العرض فى XML format.',
	'dt_viewxml_categories' => 'تصانيف',
	'dt_viewxml_namespaces' => 'مساحات اسامى',
	'dt_viewxml_simplifiedformat' => 'format متبسطه',
	'dt_xml_namespace' => 'اسم مساحه',
	'dt_xml_pages' => 'صفح',
	'dt_xml_page' => 'صفحه',
	'dt_xml_template' => 'قالب',
	'dt_xml_field' => 'حقل',
	'dt_xml_name' => 'اسم',
	'dt_xml_title' => 'عنوان',
	'dt_xml_id' => 'رقم',
	'dt_xml_freetext' => 'نص حر',
	'dt_import_selectfile' => 'لو سمحت اختار فايل $1 علشان تعمل import:',
	'dt_import_editsummary' => 'استوراد $1',
	'dt_import_success' => '$1 {{PLURAL:$1|صفحه|صفحه}} ح يتعملو من الفايل $2.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'dt_viewxml_categories' => 'Kateqoriyalar',
	'dt_viewxml_namespaces' => 'Adlar fəzaları',
	'dt_xml_namespace' => 'Adlar fəzası',
	'dt_xml_pages' => 'Səhifələr',
	'dt_xml_page' => 'Səhifə',
	'dt_xml_template' => 'Şablon',
	'dt_xml_name' => 'Ad',
	'dt_xml_title' => 'Başlıq',
	'dt_xml_id' => 'ID',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'dt_viewxml_categories' => 'Катэгорыі',
	'dt_xml_template' => 'Шаблон',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'datatransfer-desc' => 'Дазваляе імпартаваць і экспартаваць зьвесткі, якія ўтрымліваюцца ў выкліках шаблёнах',
	'viewxml' => 'Паказаць XML',
	'dt_viewxml_docu' => 'Калі ласка, выберыце што праглядаць у фармаце XML сярод наступных катэгорыяў і прастораў назваў.',
	'dt_viewxml_categories' => 'Катэгорыі',
	'dt_viewxml_namespaces' => 'Прасторы назваў',
	'dt_viewxml_simplifiedformat' => 'Спрошчаны фармат',
	'dt_xml_namespace' => 'Прастора назваў',
	'dt_xml_pages' => 'Старонкі',
	'dt_xml_page' => 'Старонка',
	'dt_xml_template' => 'Шаблён',
	'dt_xml_field' => 'Поле',
	'dt_xml_name' => 'Назва',
	'dt_xml_title' => 'Назва',
	'dt_xml_id' => 'Ідэнтыфікатар',
	'dt_xml_freetext' => 'Вольны тэкст',
	'importxml' => 'Імпарт XML',
	'dt_import_selectfile' => 'Калі ласка, выберыце файл у фармаце $1 для імпарту:',
	'dt_import_encodingtype' => 'Тып кадыроўкі:',
	'dt_import_forexisting' => 'Для старонак якія ўжо існуюць:',
	'dt_import_overwriteexisting' => 'Перазапісваць існуючы зьмест',
	'dt_import_skipexisting' => 'Прапускаць',
	'dt_import_appendtoexisting' => 'Далучаць да існуючага зьместу',
	'dt_import_summarydesc' => 'Кароткае апісаньне імпарту:',
	'dt_import_editsummary' => 'імпарт $1',
	'dt_import_importing' => 'Імпартаваньне...',
	'dt_import_success' => '$1 {{PLURAL:$1|старонка будзе|старонкі будуць|старонак будзе}} створана з файла ў фармаце $2.',
	'importcsv' => 'Імпарт CSV',
	'dt_importcsv_badheader' => "Памылка: загаловак слупка $1, '$2', павінен быць адным з '$3', '$4' альбо у форме 'назва_шаблёну[назва_поля]'",
	'right-datatransferimport' => 'імпарт зьвестак',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'viewxml' => 'Преглед на XML',
	'dt_viewxml_categories' => 'Категории',
	'dt_viewxml_namespaces' => 'Именни пространства',
	'dt_viewxml_simplifiedformat' => 'Опростен формат',
	'dt_xml_namespace' => 'Именно пространство',
	'dt_xml_pages' => 'Страници',
	'dt_xml_page' => 'Страница',
	'dt_xml_template' => 'Шаблон',
	'dt_xml_field' => 'Поле',
	'dt_xml_name' => 'Име',
	'dt_xml_title' => 'Заглавие',
	'dt_xml_id' => 'Номер',
	'dt_xml_freetext' => 'Свободен текст',
	'importxml' => 'Внасяне на XML',
	'dt_import_importing' => 'Внасяне...',
	'importcsv' => 'Внасяне на CSV',
	'right-datatransferimport' => 'Внасяне на данни',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'viewxml' => 'এক্সএমএল দেখাও',
	'dt_viewxml_categories' => 'বিষয়শ্রেণীসমূহ',
	'dt_viewxml_namespaces' => 'নামস্থানসমূহ',
	'dt_viewxml_simplifiedformat' => 'সাধারণকৃত কাঠামো',
	'dt_xml_namespace' => 'নামস্থান',
	'dt_xml_pages' => 'পাতা',
	'dt_xml_page' => 'পাতা',
	'dt_xml_template' => 'টেম্পলেট',
	'dt_xml_field' => 'ফিল্ড',
	'dt_xml_name' => 'নাম',
	'dt_xml_title' => 'শিরোনাম',
	'dt_xml_id' => 'আইডি',
	'dt_xml_freetext' => 'মুক্ত লেখা',
	'importxml' => 'এক্সএমএল আমদানি',
	'dt_import_selectfile' => 'অনুগ্রহ করে আমদানির জন্য $1 ফাইল নির্বাচন করুন:',
	'dt_import_encodingtype' => 'এনকোডিংয়ের ধরন:',
	'dt_import_forexisting' => 'যে পাতাগুলো ইতিমধ্যেই আছে তার জন্য:',
	'dt_import_overwriteexisting' => 'বিদ্যমান বিষয়সমূহ প্রতিস্থাপন করো',
	'dt_import_skipexisting' => 'উপেক্ষা করো',
	'dt_import_summarydesc' => 'আমদানির সারাংশ',
	'dt_import_editsummary' => '$1 আমদানি',
	'dt_import_importing' => 'আমদানি হচ্ছে...',
	'dt_import_success' => '$2টি ফাইল থেকে $1টি {{PLURAL:$1|পাতা|পাতা}} তৈরি করা হবে।',
	'importcsv' => 'সিএসভি আমদানি',
	'right-datatransferimport' => 'উপাত্ত আমদানি',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'datatransfer-desc' => 'Aotreañ a ra da enporzhiañ hag ezporzhiañ roadennoù eus galvoù patromoù',
	'viewxml' => 'Gwelet XML',
	'dt_viewxml_docu' => 'Dibabit e-touez ar rummadoù hag an esaouennoù anv da heul evit gwelet er furmad XML.',
	'dt_viewxml_categories' => 'Rummadoù',
	'dt_viewxml_namespaces' => 'Esaouennoù anv',
	'dt_viewxml_simplifiedformat' => 'Furmad eeunaet',
	'dt_xml_namespace' => 'Esaouenn anv',
	'dt_xml_pages' => 'Pajennoù',
	'dt_xml_page' => 'Pajenn',
	'dt_xml_template' => 'Patrom',
	'dt_xml_field' => 'Maezienn',
	'dt_xml_name' => 'Anv',
	'dt_xml_title' => 'Titl',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Testenn dieub',
	'importxml' => 'Enporzhiañ  XML',
	'dt_import_selectfile' => 'Dibabit ar restr $1 da enporzhiañ :',
	'dt_import_encodingtype' => 'Seurt enkodadur :',
	'dt_import_forexisting' => 'Evit pajennoù zo anezho dija :',
	'dt_import_overwriteexisting' => "erlec'hiañ an endalc'had zo anezhañ dija",
	'dt_import_skipexisting' => 'Lezel a-gostez',
	'dt_import_appendtoexisting' => "Ouzhpennañ d'an endalc'had zo anezhañ dija",
	'dt_import_summarydesc' => 'Diverradenn an enporzh :',
	'dt_import_editsummary' => 'Enporzhiadur $1',
	'dt_import_importing' => "Oc'h enporzhiañ...",
	'dt_import_success' => '$1 {{PLURAL:$1|bajenn|pajenn}} a vo krouet diwar ar restr $2.',
	'importcsv' => 'Enporzh CSV',
	'dt_importcsv_badheader' => 'Fazi : titl ar bann $1, "$2", a rank bezañ "$3", "$4" pe gant ar stumm "anv_ar_patrom[anv_ar_vaezienn]"',
	'right-datatransferimport' => 'Enporzhiañ roadennoù',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'datatransfer-desc' => 'Omogućuje uvoz i izvoz podataka koji su sadržani u pozivima šablona',
	'viewxml' => 'Pregledaj XML',
	'dt_viewxml_docu' => 'Molimo Vas odaberite unutar slijedećih kategorija i imenskih prostora za pregled u XML formatu.',
	'dt_viewxml_categories' => 'Kategorije',
	'dt_viewxml_namespaces' => 'Imenski prostori',
	'dt_viewxml_simplifiedformat' => 'Pojednostavljeni format',
	'dt_xml_namespace' => 'Imenski prostor',
	'dt_xml_pages' => 'Stranice',
	'dt_xml_page' => 'Stranica',
	'dt_xml_template' => 'Šablon',
	'dt_xml_field' => 'Polje',
	'dt_xml_name' => 'Naziv',
	'dt_xml_title' => 'Naslov',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Slobodni tekst',
	'importxml' => 'Uvezi XML',
	'dt_import_selectfile' => 'Molimo odaberite $1 datoteku za uvoz:',
	'dt_import_encodingtype' => 'Tip šifriranja:',
	'dt_import_forexisting' => 'Za stranice koje već postoje:',
	'dt_import_overwriteexisting' => 'Piši preko postojećeg sadržaja',
	'dt_import_skipexisting' => 'Preskoči',
	'dt_import_appendtoexisting' => 'Dodaj na postojeći sadržaj',
	'dt_import_summarydesc' => 'Sažetak uvoza:',
	'dt_import_editsummary' => '$1 uvoz',
	'dt_import_importing' => 'Uvoz...',
	'dt_import_success' => '$1 {{PLURAL:$1|stranica|stranice|stranica}} će biti napravljeno iz $2 datoteke.',
	'importcsv' => 'Uvoz CSV',
	'dt_importcsv_badheader' => "Greška: zaglavlje $1 kolone, '$2', mora biti ili '$3', '$4' ili od obrasca 'template_name[field_name]'",
	'right-datatransferimport' => 'Uvoz podataka',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author SMP
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'datatransfer-desc' => 'Permet importar i exportar les dades que contenen les crides de les plantilles',
	'viewxml' => "Visualitza l'XML",
	'dt_viewxml_docu' => "Seleccioneu d'entre les següents categories i espais de noms per a veure'l en format XML.",
	'dt_viewxml_categories' => 'Categories',
	'dt_viewxml_namespaces' => 'Espais de noms',
	'dt_viewxml_simplifiedformat' => 'Format simplificat',
	'dt_xml_namespace' => 'Espai de noms',
	'dt_xml_pages' => 'Pàgines',
	'dt_xml_page' => 'Pàgina',
	'dt_xml_template' => 'Plantilla',
	'dt_xml_field' => 'Camp',
	'dt_xml_name' => 'Nom',
	'dt_xml_title' => 'Títol',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Text lliure',
	'importxml' => 'Importa un XML',
	'dt_import_selectfile' => 'Seleccioneu el fitxer $1 per importar:',
	'dt_import_encodingtype' => 'Joc de caràcters:',
	'dt_import_summarydesc' => 'Resum de la importació:',
	'dt_import_editsummary' => 'Importació $1',
	'dt_import_importing' => "S'està important...",
	'dt_import_success' => '$1 {{PLURAL:$1|pàgina|pàgines}} es crearan des del fitxer $2.',
	'importcsv' => 'Importa un CSV',
	'dt_importcsv_badheader' => "Error: la capçalera de la columna $1, '$2', ha de ser o bé '$3', '$4' o bé de la forma 'template_name[field_name]'",
	'right-datatransferimport' => 'Importar dades',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'dt_xml_template' => 'Куцкеп',
);

/** Czech (Česky)
 * @author Jkjk
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'datatransfer-desc' => 'Umožňuje import a export strukturovaných údajů v buňkách šablon.',
	'viewxml' => 'Zobrazit XML',
	'dt_viewxml_categories' => 'Kategorie',
	'dt_viewxml_namespaces' => 'Jmenné prostory',
	'dt_viewxml_simplifiedformat' => 'Zjednodušený formát',
	'dt_xml_namespace' => 'Jmenný prostor',
	'dt_xml_pages' => 'Stránky',
	'dt_xml_page' => 'Stránka',
	'dt_xml_template' => 'Šablona',
	'dt_xml_field' => 'Pole',
	'dt_xml_name' => 'Název',
	'dt_xml_title' => 'Název',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Libovolný text',
	'importxml' => 'Importovat XML',
	'dt_import_selectfile' => 'Prosím vyberte $1 soubor k importu:',
	'dt_import_encodingtype' => 'Typ kódování:',
	'dt_import_overwriteexisting' => 'Přepsat stávající obsah',
	'dt_import_skipexisting' => 'Přeskočit',
	'dt_import_appendtoexisting' => 'Připojit ke stávajícímu obsahu',
	'dt_import_summarydesc' => 'Shrnutí importu:',
	'dt_import_editsummary' => 'import $1',
	'dt_import_importing' => 'Probíhá import...',
	'dt_import_success' => ' $1 {{PLURAL:$1|stránky|stránky|stránek}} bude vytvořeno z $2 souboru.',
	'importcsv' => 'Import CSV',
	'right-datatransferimport' => 'Importovat data',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'dt_viewxml_categories' => 'Kategorier',
	'dt_xml_namespace' => 'Navnerum',
	'dt_xml_page' => 'Side',
	'dt_xml_name' => 'Navn',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'ID',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Kghbln
 * @author Krabina
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'datatransfer-desc' => 'Ermöglicht den Export von Daten im XML-Format sowie den Import von Daten im XML- und CSV-Format',
	'viewxml' => 'XML ansehen',
	'dt_viewxml_docu' => 'Bitte auswählen, welche Kategorien und Namensräume im XML-Format angezeigt werden sollen:',
	'dt_viewxml_categories' => 'Kategorien',
	'dt_viewxml_namespaces' => 'Namensräume',
	'dt_viewxml_simplifiedformat' => 'Vereinfachtes Format',
	'dt_xml_namespace' => 'Namensraum',
	'dt_xml_pages' => 'Seiten',
	'dt_xml_page' => 'Seite',
	'dt_xml_template' => 'Vorlage',
	'dt_xml_field' => 'Feld',
	'dt_xml_name' => 'Name',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'Kennung',
	'dt_xml_freetext' => 'Freitext',
	'importxml' => 'XML-Datei importieren',
	'dt_import_selectfile' => 'Bitte die zu importierende $1-Datei auswählen:',
	'dt_import_encodingtype' => 'Zeichenkodierung:',
	'dt_import_forexisting' => 'Im Fall von Seiten, die bereits vorhanden sind:',
	'dt_import_overwriteexisting' => 'Vorhandenen Inhalt überschreiben',
	'dt_import_skipexisting' => 'Seite nicht importieren',
	'dt_import_appendtoexisting' => 'Vorhandenen Inhalt ergänzen',
	'dt_import_summarydesc' => 'Zusammenfassung zum Import:',
	'dt_import_editsummary' => '$1-Import',
	'dt_import_importing' => 'Importiere …',
	'dt_import_success' => '$1 {{PLURAL:$1|Seite|Seiten}} werden aus der $2-Datei importiert.',
	'importcsv' => 'CSV-Datei importieren',
	'dt_importcsv_badheader' => "'''Fehler:''' Der Kopf der Spalte $1, „$2“, muss entweder „$3“, „$4“ oder im Format „Vorlagenname[Feldname]“ sein",
	'right-datatransferimport' => 'Daten importieren',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'datatransfer-desc' => 'Zmóžnja importěrowanje a eksportěrowanje datow w zawołanjach pśedłogow',
	'viewxml' => 'XML se woglědaś',
	'dt_viewxml_docu' => 'Pšosym wubjeŕ, kótare slědujucych kategorijow a mjenjowych rumow maju se pokazaś w formaśe XML.',
	'dt_viewxml_categories' => 'Kategorije',
	'dt_viewxml_namespaces' => 'Mjenjowe rumy',
	'dt_viewxml_simplifiedformat' => 'Zjadnorjony format',
	'dt_xml_namespace' => 'Mjenjowy rum',
	'dt_xml_pages' => 'Boki',
	'dt_xml_page' => 'Bok',
	'dt_xml_template' => 'Pśedłoga',
	'dt_xml_field' => 'Pólo',
	'dt_xml_name' => 'Mě',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Lichy tekst',
	'importxml' => 'XML importěrowaś',
	'dt_import_selectfile' => 'Pšosym wubjeŕ dataju $1 za importěrowanje:',
	'dt_import_encodingtype' => 'Typ znamuškowego koda:',
	'dt_import_forexisting' => 'Za boki, kótarež južo ekistěruju:',
	'dt_import_overwriteexisting' => 'Eksistěrujuce wopśimjeśe pśepisaś',
	'dt_import_skipexisting' => 'Pśeskócyś',
	'dt_import_appendtoexisting' => 'K eksistěrujucemu wopśimjeśoju pśipowjesyś',
	'dt_import_summarydesc' => 'Zespominanje importa:',
	'dt_import_editsummary' => 'Importěrowanje $1',
	'dt_import_importing' => 'Importěrujo se...',
	'dt_import_success' => '$1 {{PLURAL:$1|bok twóri|boka twóritej|boki twórje|bokow twóri}} se z dataje $2.',
	'importcsv' => 'Importěrowanje CSV',
	'dt_importcsv_badheader' => "Zmólka: głowa słupa $1, '$2', musy pak '$3', '$4' byś pak formu 'mě_pśedłogi[mě_póla]' měś",
	'right-datatransferimport' => 'Daty importěrowaś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'dt_xml_page' => 'Axa',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'viewxml' => 'Προβολή XML',
	'dt_viewxml_categories' => 'Κατηγορίες',
	'dt_viewxml_namespaces' => 'Περιοχές ονομάτων',
	'dt_xml_namespace' => 'Περιοχή ονομάτων',
	'dt_xml_pages' => 'Σελίδες',
	'dt_xml_page' => 'Σελίδα',
	'dt_xml_template' => 'Πρότυπο',
	'dt_xml_field' => 'Πεδίο',
	'dt_xml_name' => 'Όνομα',
	'dt_xml_title' => 'Τίτλος',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Ελεύθερο Κείμενο',
	'importxml' => 'Εισαγωγή σε XML',
	'dt_import_encodingtype' => 'Τύπος κωδικοποίησης',
	'dt_import_editsummary' => 'Εισαγωγή $1',
	'dt_import_importing' => 'Εισάγεται...',
	'importcsv' => 'Εισαγωγή CSV',
	'right-datatransferimport' => 'Εισαγωγή δεδομένων',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'datatransfer-desc' => 'Permesas importadon kaj eksportadon de datumoj enhave en ŝablonaj vokoj',
	'viewxml' => 'Rigardu XML-on',
	'dt_viewxml_docu' => 'Bonvolu elekti inter la subaj kategorioj kaj nomspacoj por rigardi en XML-formato.',
	'dt_viewxml_categories' => 'Kategorioj',
	'dt_viewxml_namespaces' => 'Nomspacoj',
	'dt_viewxml_simplifiedformat' => 'Simpligita formato',
	'dt_xml_namespace' => 'Nomspaco',
	'dt_xml_pages' => 'Paĝoj',
	'dt_xml_page' => 'Paĝo',
	'dt_xml_template' => 'Ŝablono',
	'dt_xml_field' => 'Kampo',
	'dt_xml_name' => 'Nomo',
	'dt_xml_title' => 'Titolo',
	'dt_xml_id' => 'identigo',
	'dt_xml_freetext' => 'Libera Teksto',
	'importxml' => 'Importi XML',
	'dt_import_editsummary' => '$1 importo',
	'dt_import_importing' => 'Importante...',
	'importcsv' => 'Importi CSV',
	'right-datatransferimport' => 'Importi datenojn',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Locos epraix
 * @author Peter17
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'datatransfer-desc' => 'Permite importar y exportar datos contenidos en llamadas de plantilla',
	'viewxml' => 'Ver XML',
	'dt_viewxml_docu' => 'Por favor seleccionar entre las siguientes categorías y nombres de espacio para ver en formato XML.',
	'dt_viewxml_categories' => 'Categorías',
	'dt_viewxml_namespaces' => 'Espacios de nombres',
	'dt_viewxml_simplifiedformat' => 'Formato simplificado',
	'dt_xml_namespace' => 'Espacio de nombres',
	'dt_xml_pages' => 'Páginas',
	'dt_xml_page' => 'Página',
	'dt_xml_template' => 'Plantilla',
	'dt_xml_field' => 'Campo',
	'dt_xml_name' => 'Nombre',
	'dt_xml_title' => 'Título',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Texto libre',
	'importxml' => 'Importar XML',
	'dt_import_selectfile' => 'Por favor seleccione el archivo $1 a importar:',
	'dt_import_encodingtype' => 'Tipo de codificación:',
	'dt_import_summarydesc' => 'Resumen de importación:',
	'dt_import_editsummary' => '$1 importación',
	'dt_import_importing' => 'Importando...',
	'dt_import_success' => '$1 {{PLURAL:$1|página|páginas}} serán creadas del archivo $2.',
	'importcsv' => 'Importar CSV',
	'dt_importcsv_badheader' => 'Error : el título de columna $1, "$2", tiene que ser "$3", "$4" o de la forma \'nombre_de_plantilla[nombre_del_campo]\'',
	'right-datatransferimport' => 'Importar datos',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'dt_viewxml_categories' => 'Kategooriad',
	'dt_viewxml_namespaces' => 'Nimeruumid',
	'dt_viewxml_simplifiedformat' => 'Lihtsustatud vorming',
	'dt_xml_namespace' => 'Nimeruum',
	'dt_xml_pages' => 'Leheküljed',
	'dt_xml_page' => 'Lehekülg',
	'dt_xml_template' => 'Mall',
	'dt_xml_name' => 'Nimi',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'viewxml' => 'XML ikusi',
	'dt_viewxml_categories' => 'Kategoriak',
	'dt_xml_pages' => 'Orrialdeak',
	'dt_xml_page' => 'Orrialdea',
	'dt_xml_template' => 'Txantiloia',
	'dt_xml_field' => 'Eremua',
	'dt_xml_name' => 'Izena',
	'dt_xml_title' => 'Izenburua',
	'importxml' => 'XML inportatu',
	'dt_import_selectfile' => 'Mesedez, aukera ezazu inportatzeko $1 fitxategia:',
	'dt_import_editsummary' => '$1 inportatu',
	'dt_import_importing' => 'Inportatzen...',
	'importcsv' => 'CSV inportatu',
	'right-datatransferimport' => 'Datuak inportatu',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'dt_xml_template' => 'الگو',
	'dt_xml_name' => 'نام',
	'dt_xml_title' => 'عنوان',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'datatransfer-desc' => 'Mahdollistaa tuoda ja viedä dataa, joka on mallinekutsuissa.',
	'viewxml' => 'Näytä XML',
	'dt_viewxml_docu' => 'Valitse yksi seuraavista luokista ja nimiavaruuksista tarkasteltavaksi XML-muodossa.',
	'dt_viewxml_categories' => 'Luokat',
	'dt_viewxml_namespaces' => 'Nimiavaruudet',
	'dt_viewxml_simplifiedformat' => 'Yksinkertaistettu muoto',
	'dt_xml_namespace' => 'Nimiavaruus',
	'dt_xml_pages' => 'Sivut',
	'dt_xml_page' => 'Sivu',
	'dt_xml_template' => 'Malline',
	'dt_xml_field' => 'Kenttä',
	'dt_xml_name' => 'Nimi',
	'dt_xml_title' => 'Otsikko',
	'dt_xml_id' => 'Tunnus',
	'dt_xml_freetext' => 'Vapaa teksti',
	'importxml' => 'XML-tuonti',
	'dt_import_selectfile' => 'Valitse $1-tiedosto tuotavaksi:',
	'dt_import_encodingtype' => 'Merkistötyyppi:',
	'dt_import_skipexisting' => 'Ohita',
	'dt_import_summarydesc' => 'Tuonnin yhteenveto',
	'dt_import_editsummary' => '$1-tuonti',
	'dt_import_importing' => 'Tuodaan...',
	'dt_import_success' => '$1 {{PLURAL:$1|sivu|sivua}} luodaan $2-tiedostosta.',
	'importcsv' => 'CSV-tuonti',
	'dt_importcsv_badheader' => "Virhe: sarake $1 otsake, '$2', on oltava joko '$3', '$4' tai muotoa 'mallinne_nimi[kenttä_nimi]'",
	'right-datatransferimport' => 'Tuoda tiedot',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Peter17
 * @author PieRRoMaN
 * @author Zetud
 */
$messages['fr'] = array(
	'datatransfer-desc' => 'Permet l’import et l’export de données contenues dans des appels de modèles',
	'viewxml' => 'Voir XML',
	'dt_viewxml_docu' => 'Veuillez sélectionner parmi les catégories et les espaces de noms suivants afin de visionner au format XML.',
	'dt_viewxml_categories' => 'Catégories',
	'dt_viewxml_namespaces' => 'Espaces de noms',
	'dt_viewxml_simplifiedformat' => 'Format simplifié',
	'dt_xml_namespace' => 'Espace de noms',
	'dt_xml_pages' => 'Pages',
	'dt_xml_page' => 'Page',
	'dt_xml_template' => 'Modèle',
	'dt_xml_field' => 'Champ',
	'dt_xml_name' => 'Nom',
	'dt_xml_title' => 'Titre',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Texte libre',
	'importxml' => 'Import en XML',
	'dt_import_selectfile' => 'Veuillez sélectionner le fichier $1 à importer :',
	'dt_import_encodingtype' => 'Type d’encodage:',
	'dt_import_forexisting' => 'Pour les pages qui existent déjà :',
	'dt_import_overwriteexisting' => 'Remplacer le contenu existant',
	'dt_import_skipexisting' => 'Passer',
	'dt_import_appendtoexisting' => 'Ajouter au contenu existant',
	'dt_import_summarydesc' => 'Résumé de l’import :',
	'dt_import_editsummary' => 'Import de $1',
	'dt_import_importing' => 'Import en cours...',
	'dt_import_success' => '$1 {{PLURAL:$1|page sera créée|pages seront créées}} depuis le fichier $2.',
	'importcsv' => 'Import CSV',
	'dt_importcsv_badheader' => 'Erreur : le titre de colonne $1, « $2 », doit être soit « $3 », « $4 » ou de la forme « nom_du_modèle[nom_du_champ] »',
	'right-datatransferimport' => 'Importer des données',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'viewxml' => 'Vêre XML',
	'dt_viewxml_categories' => 'Catègories',
	'dt_viewxml_namespaces' => 'Èspâços de noms',
	'dt_viewxml_simplifiedformat' => 'Format simplifiâ',
	'dt_xml_namespace' => 'Èspâço de noms',
	'dt_xml_pages' => 'Pâges',
	'dt_xml_page' => 'Pâge',
	'dt_xml_template' => 'Modèlo',
	'dt_xml_field' => 'Champ',
	'dt_xml_name' => 'Nom',
	'dt_xml_title' => 'Titro',
	'dt_xml_id' => 'Numerô',
	'dt_xml_freetext' => 'Tèxto libro',
	'importxml' => 'Importar un XML',
	'dt_import_selectfile' => 'Volyéd chouèsir lo fichiér $1 a importar :',
	'dt_import_encodingtype' => 'Tipo d’encodâjo :',
	'dt_import_forexisting' => 'Por les pâges qu’ègzistont ja :',
	'dt_import_overwriteexisting' => 'Ècllafar lo contegnu ègzistent',
	'dt_import_skipexisting' => 'Passar',
	'dt_import_appendtoexisting' => 'Apondre u contegnu ègzistent',
	'dt_import_summarydesc' => 'Rèsumâ de l’importacion :',
	'dt_import_editsummary' => 'Importacion de $1',
	'dt_import_importing' => 'Importacion en cors...',
	'dt_import_success' => '$1 {{PLURAL:$1|pâge serat fêta|pâges seront fêtes}} dês lo fichiér $2.',
	'importcsv' => 'Importar des balyês CSV',
	'right-datatransferimport' => 'Importar des balyês',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'dt_viewxml_namespaces' => 'Nammeromten',
	'dt_xml_page' => 'Side',
	'dt_xml_name' => 'Namme',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'dt_xml_namespace' => 'Ainmspás',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'datatransfer-desc' => 'Permite importar e exportar datos contidos en chamadas de modelos',
	'viewxml' => 'Ver XML',
	'dt_viewxml_docu' => 'Por favor seleccione entre as seguintes categorías e espazos de nomes para ver en formato XML.',
	'dt_viewxml_categories' => 'Categorías',
	'dt_viewxml_namespaces' => 'Espazos de nomes',
	'dt_viewxml_simplifiedformat' => 'Formato simplificado',
	'dt_xml_namespace' => 'Espazo de nomes',
	'dt_xml_pages' => 'Páxinas',
	'dt_xml_page' => 'Páxina',
	'dt_xml_template' => 'Modelo',
	'dt_xml_field' => 'Campo',
	'dt_xml_name' => 'Nome',
	'dt_xml_title' => 'Título',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Texto libre',
	'importxml' => 'Importar XML',
	'dt_import_selectfile' => 'Por favor, seleccione o ficheiro $1 a importar:',
	'dt_import_encodingtype' => 'Tipo de codificación:',
	'dt_import_forexisting' => 'Para páxinas que xa existen:',
	'dt_import_overwriteexisting' => 'Sobrescribir o contido existente',
	'dt_import_skipexisting' => 'Saltar',
	'dt_import_appendtoexisting' => 'Engadir ao contido existente',
	'dt_import_summarydesc' => 'Resumo da importación:',
	'dt_import_editsummary' => 'Importación en $1',
	'dt_import_importing' => 'Importando...',
	'dt_import_success' => '{{PLURAL:$1|Unha páxina será creada|$1 páxinas serán creadas}} a partir do ficheiro $2.',
	'importcsv' => 'Importación en CSV',
	'dt_importcsv_badheader' => 'Erro: a cabeceira da columna $1, "$2", debe ser un "$3", "$4" ou do formulario "template_name[field_name]"',
	'right-datatransferimport' => 'Importar datos',
);

/** Gothic (Gothic)
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'dt_xml_namespace' => 'Seidofera',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'dt_viewxml_categories' => 'Κατηγορίαι',
	'dt_viewxml_namespaces' => 'Ὀνοματεῖα',
	'dt_xml_namespace' => 'Ὀνοματεῖον',
	'dt_xml_pages' => 'Δέλτοι',
	'dt_xml_page' => 'Δέλτος',
	'dt_xml_template' => 'Πρότυπον',
	'dt_xml_field' => 'Πεδίον',
	'dt_xml_name' => 'Ὄνομα',
	'dt_xml_title' => 'Ἐπιγραφή',
	'dt_xml_freetext' => 'Ἐλεύθερον κείμενον',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author J. 'mach' wust
 */
$messages['gsw'] = array(
	'datatransfer-desc' => 'Macht dr Import un dr Export vu strukturierte Date megli, wu in Ufrief vu Vorlage bruucht wäre.',
	'viewxml' => 'XML aaluege',
	'dt_viewxml_docu' => 'Bitte wehl uus, weli Kategorien un Namensryym im XML-Format solle aazeigt wäre.',
	'dt_viewxml_categories' => 'Kategorie',
	'dt_viewxml_namespaces' => 'Namensryym',
	'dt_viewxml_simplifiedformat' => 'Vereifacht Format',
	'dt_xml_namespace' => 'Namensruum',
	'dt_xml_pages' => 'Syte',
	'dt_xml_page' => 'Syte',
	'dt_xml_template' => 'Vorlag',
	'dt_xml_field' => 'Fäld',
	'dt_xml_name' => 'Name',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Freje Täxt',
	'importxml' => 'XML importiere',
	'dt_import_selectfile' => 'Bitte wehl d $1-Datei zum importiere uus:',
	'dt_import_encodingtype' => 'Verschlisseligstyp:',
	'dt_import_forexisting' => 'Im Fall vu Syte, wu s scho git:',
	'dt_import_overwriteexisting' => 'Vorhandene Inhalt iberschryybe',
	'dt_import_skipexisting' => 'Ibergumpe',
	'dt_import_appendtoexisting' => 'Vorhandene Inhalt ergänze',
	'dt_import_summarydesc' => 'Zämmefassig vum Import:',
	'dt_import_editsummary' => '$1-Import',
	'dt_import_importing' => 'Am Importiere ...',
	'dt_import_success' => '$1 {{PLURAL:$1|Syte|Syte}} wäre us dr $2-Datei aagleit.',
	'importcsv' => 'CSV-Datei importiere',
	'dt_importcsv_badheader' => "Fähler: d Spalte $1 Iberschrift, '$2', muess entwäder '$3', '$4' syy oder us em Format  'template_name[field_name]'",
	'right-datatransferimport' => 'Date importiere',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'viewxml' => 'Jeeagh er XML',
	'dt_viewxml_categories' => 'Ronnaghyn',
	'dt_xml_page' => 'Duillag',
	'dt_xml_name' => 'Ennym',
	'dt_xml_title' => 'Ard-ennym',
	'dt_xml_freetext' => 'Teks seyr',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'dt_xml_namespace' => 'Sararin suna',
	'dt_xml_page' => 'Shafi',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'dt_xml_page' => '‘Ao‘ao',
	'dt_xml_name' => 'Inoa',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'datatransfer-desc' => 'אפשרות לייבא ולייצא נתונים בתבניות',
	'viewxml' => 'הצגת XML',
	'dt_viewxml_docu' => 'אנא בחרו את מרחבי השם והקטגוריות אותם תרצו להציג בפורמט XML.',
	'dt_viewxml_categories' => 'קטגוריות',
	'dt_viewxml_namespaces' => 'מרחבי שם',
	'dt_viewxml_simplifiedformat' => 'מבנה מפושט',
	'dt_xml_namespace' => 'מרחב שם',
	'dt_xml_pages' => 'דפים',
	'dt_xml_page' => 'דף',
	'dt_xml_template' => 'תבנית',
	'dt_xml_field' => 'שדה',
	'dt_xml_name' => 'שם',
	'dt_xml_title' => 'כותרת',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'טקסט חופשי',
	'importxml' => 'יבוא XML',
	'dt_import_selectfile' => 'אנא בחרו את קובץ ה־$1 ליבוא:',
	'dt_import_encodingtype' => 'סוג הקידוד:',
	'dt_import_forexisting' => 'עבור הדפים שכבר קיימים:',
	'dt_import_overwriteexisting' => 'לדרוס את התוכן הקיים',
	'dt_import_skipexisting' => 'לדלג',
	'dt_import_appendtoexisting' => 'לצרף את התוכן הקיים',
	'dt_import_summarydesc' => 'תקציר היבוא:',
	'dt_import_editsummary' => 'יבוא $1',
	'dt_import_importing' => 'מתבצע יבוא...',
	'dt_import_success' => '{{PLURAL:$1|דף אחד ייוצר|$1 דפים ייוצרו}} מקובץ ה־$2.',
	'importcsv' => 'יבוא CSV',
	'dt_importcsv_badheader' => "שגיאה: כותרת העמודה $1, '$2', חייבת להיות או '$3', '$4' או מהצורה 'שם_התבנית[שם_השדה]'",
	'right-datatransferimport' => 'יבוא נתונים',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'datatransfer-desc' => 'टेम्प्लेट कॉल में उपलब्ध डाटाकी आयात-निर्यात करने की अनुमति देता हैं',
	'viewxml' => 'XML देखें',
	'dt_viewxml_docu' => 'कॄपया XML में देखने के लिये श्रेणीयाँ और नामस्थान चुनें।',
	'dt_viewxml_categories' => 'श्रेणीयाँ',
	'dt_viewxml_namespaces' => 'नामस्थान',
	'dt_viewxml_simplifiedformat' => 'आसान फॉरमैट',
	'dt_xml_namespace' => 'नामस्थान',
	'dt_xml_page' => 'पन्ना',
	'dt_xml_field' => 'फिल्ड़',
	'dt_xml_name' => 'नाम',
	'dt_xml_title' => 'शीर्षक',
	'dt_xml_id' => 'आईडी',
	'dt_xml_freetext' => 'मुक्त पाठ',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'dt_viewxml_categories' => 'Kategorije',
	'dt_xml_namespace' => 'Imenski prostor',
	'dt_xml_page' => 'Stranica',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'datatransfer-desc' => 'Dowola importowanje a eksportowanje datow, kotrež su we wołanjach předłohow wobsahowane',
	'viewxml' => 'XML wobhladać',
	'dt_viewxml_docu' => 'Prošu wubjer ze slědowacych kategorijow a mjenowych rumow, zo by w XML-formaće wobhladał.',
	'dt_viewxml_categories' => 'Kategorije',
	'dt_viewxml_namespaces' => 'Mjenowe rumy',
	'dt_viewxml_simplifiedformat' => 'Zjednorjeny format',
	'dt_xml_namespace' => 'Mjenowy rum',
	'dt_xml_pages' => 'Strony',
	'dt_xml_page' => 'Strona',
	'dt_xml_template' => 'Předłoha',
	'dt_xml_field' => 'Polo',
	'dt_xml_name' => 'Mjeno',
	'dt_xml_title' => 'Titul',
	'dt_xml_id' => 'Id',
	'dt_xml_freetext' => 'Swobodny tekst',
	'importxml' => 'XML importować',
	'dt_import_selectfile' => 'Prošu wubjer dataju $1 za importowanje:',
	'dt_import_encodingtype' => 'Typ znamješkoweho koda:',
	'dt_import_forexisting' => 'Za strony, kotrež hižo eksistuja:',
	'dt_import_overwriteexisting' => 'Eksistowacy wobsah přepisać',
	'dt_import_skipexisting' => 'Přeskočić',
	'dt_import_appendtoexisting' => 'K eksistowacemu wobsahej připowěsnyć',
	'dt_import_summarydesc' => 'Zjeće importa:',
	'dt_import_editsummary' => 'Importowanje $1',
	'dt_import_importing' => 'Importuje so...',
	'dt_import_success' => '$1 {{PLURAL:$1|strona so z dataje $2 twori|stronje so z dataje $2 tworitej|strony so z dataje $2 tworja|stronow so z dataje $2 twori}}.',
	'importcsv' => 'Importowanje CSV',
	'dt_importcsv_badheader' => "Zmylk: hłowa špalty $1, '$2', dyrbi pak '$3', '$4' być pak formu 'mjeno_předłohi[mjeno_pola]' měć",
	'right-datatransferimport' => 'Daty importować',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'datatransfer-desc' => 'Lehetővé teszi a sablonhívásokban található adatok importálását és exportálását',
	'viewxml' => 'XML megtekintése',
	'dt_viewxml_docu' => 'Válaszd ki a kategóriák és a névterek közül azt, amelyiket meg akarod tekinteni XML formátumban.',
	'dt_viewxml_categories' => 'Kategóriák',
	'dt_viewxml_namespaces' => 'Névterek',
	'dt_viewxml_simplifiedformat' => 'Egyszerűsített formátum',
	'dt_xml_namespace' => 'Névtér',
	'dt_xml_pages' => 'Lapok',
	'dt_xml_page' => 'Lap',
	'dt_xml_template' => 'Sablon',
	'dt_xml_field' => 'Mező',
	'dt_xml_name' => 'Név',
	'dt_xml_title' => 'Cím',
	'dt_xml_id' => 'Azonosító',
	'dt_xml_freetext' => 'Szabad szöveg',
	'importxml' => 'XML importálás',
	'dt_import_selectfile' => 'Kérlek válaszd ki az importálandó $1 fájlt:',
	'dt_import_encodingtype' => 'Kódolás típusa:',
	'dt_import_summarydesc' => 'Az importálás összefoglalója:',
	'dt_import_editsummary' => '$1 importálás',
	'dt_import_importing' => 'Importálás…',
	'dt_import_success' => '{{PLURAL:$1|egy|$1}} lap fog készülni a(z) $2 fájlból.',
	'importcsv' => 'CSV importálása',
	'dt_importcsv_badheader' => 'Hiba: a(z) $1 oszlop fejlécének („$2”) vagy „$3”, „$4”, vagy pedig „sablonnév[mezőnév]” formátumúnak kell lennie',
	'right-datatransferimport' => 'Adatok importálása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'datatransfer-desc' => 'Permitte importar e exportar datos continite in appellos a patronos',
	'viewxml' => 'Vider XML',
	'dt_viewxml_docu' => 'Per favor selige inter le sequente categorias e spatios de nomines pro vider in formato XML.',
	'dt_viewxml_categories' => 'Categorias',
	'dt_viewxml_namespaces' => 'Spatios de nomines',
	'dt_viewxml_simplifiedformat' => 'Formato simplificate',
	'dt_xml_namespace' => 'Spatio de nomines',
	'dt_xml_pages' => 'Paginas',
	'dt_xml_page' => 'Pagina',
	'dt_xml_template' => 'Patrono',
	'dt_xml_field' => 'Campo',
	'dt_xml_name' => 'Nomine',
	'dt_xml_title' => 'Titulo',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Texto libere',
	'importxml' => 'Importar XML',
	'dt_import_selectfile' => 'Per favor selige le file $1 a importar:',
	'dt_import_encodingtype' => 'Typo de codification:',
	'dt_import_forexisting' => 'Pro paginas que ja existe:',
	'dt_import_overwriteexisting' => 'Superscriber le contento existente',
	'dt_import_skipexisting' => 'Saltar',
	'dt_import_appendtoexisting' => 'Adjunger al contento existente',
	'dt_import_summarydesc' => 'Summario de importation:',
	'dt_import_editsummary' => 'Importation de $1',
	'dt_import_importing' => 'Importation in curso…',
	'dt_import_success' => '$1 {{PLURAL:$1|pagina|paginas}} essera create ex le file $2.',
	'importcsv' => 'Importar CSV',
	'dt_importcsv_badheader' => "Error: le capite del columna $1, '$2', debe esser '$3', '$4' o in le forma 'nomine_de_patrono[nomine_de_campo]'",
	'right-datatransferimport' => 'Importar datos',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'datatransfer-desc' => 'Membolehkan untuk impor dan ekspor data diisikan pada pemangilan templat',
	'viewxml' => 'Tilik XML',
	'dt_viewxml_docu' => 'Silakan pilih di antara kategori dan ruang nama berikut untuk melihat dalam format XML',
	'dt_viewxml_categories' => 'Kategori',
	'dt_viewxml_namespaces' => 'Ruang nama',
	'dt_viewxml_simplifiedformat' => 'Penyederhanaan format',
	'dt_xml_namespace' => 'Ruang nama',
	'dt_xml_pages' => 'Halaman',
	'dt_xml_page' => 'Halaman',
	'dt_xml_template' => 'Templat',
	'dt_xml_field' => 'Ruas',
	'dt_xml_name' => 'Nama',
	'dt_xml_title' => 'Judul',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Teks Bebas',
	'importxml' => 'Impor XML',
	'dt_import_selectfile' => 'Pilih berkas $1 untuk di impor:',
	'dt_import_encodingtype' => 'Tipe penyandian:',
	'dt_import_forexisting' => 'Untuk halaman yang sudah ada:',
	'dt_import_overwriteexisting' => 'Menimpa konten yang ada',
	'dt_import_skipexisting' => 'Lewati',
	'dt_import_appendtoexisting' => 'Tambahkan kepada konten yang ada',
	'dt_import_summarydesc' => 'Ringkasan impor:',
	'dt_import_editsummary' => '$1 impor',
	'dt_import_importing' => 'Mengimpor...',
	'dt_import_success' => '$1 {{PLURAL:$1|halaman|halaman}} akan di buat dari  berkas $2.',
	'importcsv' => 'Impor CSV',
	'dt_importcsv_badheader' => "Kesalahan: kepala kolom $1, '$2', harus berupa '$3', '$4' atau bentuk 'template_name [field_name]'",
	'right-datatransferimport' => 'Impor data',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'dt_viewxml_categories' => 'Ébéanọr',
	'dt_xml_template' => 'Àtụ',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'dt_xml_template' => 'Shablono',
	'dt_xml_name' => 'Nomo',
	'dt_xml_title' => 'Titulo',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'dt_viewxml_namespaces' => 'Nafnrými',
	'dt_xml_page' => 'Síða',
);

/** Italian (Italiano)
 * @author Beta16
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'datatransfer-desc' => "Permette l'importazione e l'esportazione di dati strutturati contenuti in chiamate a template",
	'viewxml' => 'Vedi XML',
	'dt_viewxml_docu' => 'Selezionare tra le categorie e namespace indicati di seguito quelli da visualizzare in formato XML.',
	'dt_viewxml_categories' => 'Categorie',
	'dt_viewxml_namespaces' => 'Namespace',
	'dt_viewxml_simplifiedformat' => 'Formato semplificato',
	'dt_xml_namespace' => 'Namespace',
	'dt_xml_pages' => 'Pagine',
	'dt_xml_page' => 'Pagina',
	'dt_xml_template' => 'Template',
	'dt_xml_field' => 'Campo',
	'dt_xml_name' => 'Nome',
	'dt_xml_title' => 'Titolo',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Testo libero',
	'dt_import_encodingtype' => 'Tipo di codifica',
	'right-datatransferimport' => 'Importa dati',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Ohgi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'datatransfer-desc' => 'テンプレート呼び出しに関わるデータのインポートおよびエクスポートを可能にする',
	'viewxml' => 'XML表示',
	'dt_viewxml_docu' => 'XML形式で表示するカテゴリや名前空間を以下から選択してください。',
	'dt_viewxml_categories' => 'カテゴリ',
	'dt_viewxml_namespaces' => '名前空間',
	'dt_viewxml_simplifiedformat' => '簡易形式',
	'dt_xml_namespace' => '名前空間',
	'dt_xml_pages' => 'ページ群',
	'dt_xml_page' => 'ページ',
	'dt_xml_template' => 'テンプレート',
	'dt_xml_field' => 'フィールド',
	'dt_xml_name' => '名前',
	'dt_xml_title' => 'タイトル',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => '自由形式テキスト',
	'importxml' => 'XMLインポート',
	'dt_import_selectfile' => 'インポートする $1 ファイルを選択してください:',
	'dt_import_encodingtype' => 'エンコーディング方式:',
	'dt_import_forexisting' => 'すでに存在するページの場合：',
	'dt_import_overwriteexisting' => '既存の内容に上書き',
	'dt_import_skipexisting' => 'スキップ',
	'dt_import_appendtoexisting' => '既存の内容に追加',
	'dt_import_summarydesc' => '移入の概要：',
	'dt_import_editsummary' => '$1 のインポート',
	'dt_import_importing' => 'インポート中…',
	'dt_import_success' => '$2ファイルから$1{{PLURAL:$1|ページ}}がインポートされます。',
	'importcsv' => 'CSVのインポート',
	'dt_importcsv_badheader' => 'エラー: 列 $1 のヘッダ「$2」は、「$3」もしくは「$4」であるか、または「テンプレート名[フィールド名]」という形式になっていなければなりません。',
	'right-datatransferimport' => 'データをインポートする',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'viewxml' => 'Ndeleng XML',
	'dt_viewxml_categories' => 'Kategori-kategori',
	'dt_viewxml_simplifiedformat' => 'Format prasaja',
	'dt_xml_namespace' => 'Bilik nama',
	'dt_xml_page' => 'Kaca',
	'dt_xml_name' => 'Jeneng',
	'dt_xml_title' => 'Irah-irahan (judhul)',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Tèks Bébas',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'viewxml' => 'មើល XML',
	'dt_viewxml_docu' => 'ជ្រើសយកក្នុងចំណោមចំណាត់ថ្នាក់ក្រុមនិងលំហឈ្មោះដើម្បីមើលជាទម្រង់ XML ។',
	'dt_viewxml_categories' => 'ចំណាត់ថ្នាក់ក្រុម',
	'dt_viewxml_namespaces' => 'ប្រភេទ',
	'dt_viewxml_simplifiedformat' => 'ទម្រង់សាមញ្ញ',
	'dt_xml_namespace' => 'លំហឈ្មោះ',
	'dt_xml_pages' => 'ទំព័រ',
	'dt_xml_page' => 'ទំព័រ',
	'dt_xml_template' => 'ទំព័រគំរូ',
	'dt_xml_field' => 'ផ្នែក',
	'dt_xml_name' => 'ឈ្មោះ',
	'dt_xml_title' => 'ចំណងជើង',
	'dt_xml_id' => 'អត្តសញ្ញាណ',
	'dt_xml_freetext' => 'អត្ថបទសេរី',
	'importxml' => 'នាំចូល XML',
	'dt_import_selectfile' => 'សូម​ជ្រើស​រើស​ឯកសារ $1 ដើម្បី​នាំ​ចូល​៖',
	'dt_import_encodingtype' => 'ប្រភេទនៃការធ្វើកូដ៖',
	'dt_import_forexisting' => 'សំរាប់ទំព័រដែលមានរួចហើយ៖',
	'dt_import_overwriteexisting' => 'សរសេរជាន់ពីលើខ្លឹមសារដែលមានហើយ',
	'dt_import_skipexisting' => 'រំលង',
	'dt_import_appendtoexisting' => 'សរសេរបន្ថែមទៅលើខ្លឹមសារដែលមានហើយ',
	'dt_import_summarydesc' => 'ចំណារពន្យល់ស្ដីពីការនាំចូល៖',
	'dt_import_editsummary' => '$1 នាំចូល​',
	'dt_import_importing' => 'កំពុងនាំចូល​...',
	'dt_import_success' => 'ទំព័រចំនួន $1 នឹងត្រូវបានបង្កើតពីឯកសារ $2 នេះ។',
	'importcsv' => 'នាំចូល CSV',
	'right-datatransferimport' => 'នាំចូល​ទិន្នន័យ​',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'dt_viewxml_categories' => 'ವರ್ಗಗಳು',
	'dt_xml_namespace' => 'ನಾಮವರ್ಗ',
	'dt_xml_pages' => 'ಪುಟಗಳು',
	'dt_xml_page' => 'ಪುಟ',
	'dt_xml_template' => 'ಟೆಂಪ್ಲೇಟು',
	'dt_xml_name' => 'ಹೆಸರು',
	'dt_xml_title' => 'ಶೀರ್ಷಿಕೆ',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'dt_viewxml_categories' => 'Manga Kategorya',
	'dt_xml_page' => 'Pahina',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'datatransfer-desc' => 'Määt et müjjelesch, Date uß Schabloone ier Oproofe ze emporteere un ze exporteere.',
	'viewxml' => '<i lang="en">XML</i> beloore',
	'dt_viewxml_docu' => 'Don ußsöke, wat fö_n Saachjruppe un Appachtemangs De em <i lang="en">XML</i> Fommaat aanloore wells.',
	'dt_viewxml_categories' => 'Saachjroppe',
	'dt_viewxml_namespaces' => 'Appachtemangs',
	'dt_viewxml_simplifiedformat' => 'Em eijfachere Fommaat',
	'dt_xml_namespace' => 'Appachtemang',
	'dt_xml_pages' => 'Sigge',
	'dt_xml_page' => 'Sigg',
	'dt_xml_template' => 'Schablohn',
	'dt_xml_field' => 'Felldt',
	'dt_xml_name' => 'Name',
	'dt_xml_title' => 'Tėttel',
	'dt_xml_id' => 'Kännong',
	'dt_xml_freetext' => 'Freije Täx',
	'importxml' => '<i lang="en">XML</i> Empotteere',
	'dt_import_selectfile' => 'Söhk de <i lang="en">$1</i>-Dattei för zem Empotteere uß:',
	'dt_import_encodingtype' => 'Zoot Kodeerung för de Bohchshtahbe un Zeishe:',
	'dt_import_forexisting' => 'För Sigge, di et ald jitt:',
	'dt_import_overwriteexisting' => 'Övverschrieve, wat ald doh es',
	'dt_import_skipexisting' => 'Övverjonn',
	'dt_import_appendtoexisting' => 'An dat aanhange, wat ald doh es',
	'dt_import_summarydesc' => 'Zesammefassung vun däm Empoot:',
	'dt_import_editsummary' => 'uss ene <i lang="en">$1</i>-Datei empotteet',
	'dt_import_importing' => 'Ben aam Empotteere{{int:Ellipsis}}',
	'dt_import_success' => '{{PLURAL:$1|Ein Sigg weed_uß|$1 Sigge weede uß|Kein einzelne Sigg weed_uß}} dä <i lang="en">$2</i>-Dattei empotteet.',
	'importcsv' => '<i lang="en">CSV</i>-Dattei empoteere',
	'dt_importcsv_badheader' => 'Fähler: De Shpallde-Övverschreff för $1 es „$2“, mööt ävver „$3“ udder „$4“ sin, udder dat Fommaat „<code>Name_vun_ene_Schablohn[Name_vun_enem_Felldt]</code>“ han.',
	'right-datatransferimport' => 'Daate empoteere',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'dt_xml_page' => 'Rûpel',
	'dt_xml_name' => 'Nav',
	'dt_xml_title' => 'Sernav',
	'dt_import_summarydesc' => 'Kurteya împortê:',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'dt_viewxml_categories' => 'Classys',
	'dt_xml_page' => 'Folen',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'datatransfer-desc' => "Erlaabt et Daten déi an Opruffer vu schabloune benotzt ginn z'importéieren an z'exportéieren",
	'viewxml' => 'XML weisen',
	'dt_viewxml_docu' => 'Wielt w.e.g. ënnert dëse Kategorien an Nimmraim fir am XML-Format unzeweisen.',
	'dt_viewxml_categories' => 'Kategorien',
	'dt_viewxml_namespaces' => 'Nummraim',
	'dt_viewxml_simplifiedformat' => 'Vereinfachte Format',
	'dt_xml_namespace' => 'Nummraum',
	'dt_xml_pages' => 'Säiten',
	'dt_xml_page' => 'Säit',
	'dt_xml_template' => 'Schabloun',
	'dt_xml_field' => 'Feld',
	'dt_xml_name' => 'Numm',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'Nummer',
	'dt_xml_freetext' => 'Fräien Text',
	'importxml' => 'XML importéieren',
	'dt_import_selectfile' => "Sicht de(n) $1-Fichier eraus fir z'importéieren:",
	'dt_import_encodingtype' => 'Encoding-Typ:',
	'dt_import_forexisting' => 'Fir Säiten déi et scho gëtt:',
	'dt_import_overwriteexisting' => 'Den Inhalt den et gëtt iwwerschreiwen',
	'dt_import_skipexisting' => 'Iwwersprangen',
	'dt_import_appendtoexisting' => 'Bäi den Inhalt deen et gëtt derbäisetzen',
	'dt_import_summarydesc' => 'Resumé vum Import:',
	'dt_import_editsummary' => '$1 importéieren',
	'dt_import_importing' => 'Import am gaang ...',
	'dt_import_success' => '$1 {{PLURAL:$1|Säit gëtt|Säite ginn}} aus dem $2-Fichier ugeluecht.',
	'importcsv' => 'CSV importéieren',
	'dt_importcsv_badheader' => "Feeler: D'Iwwerschrëft vun der Kolonn $1, '$2', muss entweder '$3', '$4' oder am Format 'Numm_vun_der_Schabloun(Numm_vum_Feld)' sinn",
	'right-datatransferimport' => 'Donnéeën importéieren',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Remember the dot
 */
$messages['li'] = array(
	'dt_xml_page' => 'Pagina',
);

/** Lithuanian (Lietuvių)
 * @author Tomasdd
 */
$messages['lt'] = array(
	'dt_viewxml_categories' => 'Kategorijos',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'dt_viewxml_namespaces' => 'Vuordu pluoti',
	'dt_xml_namespace' => 'Vuordu pluots',
	'dt_xml_pages' => 'Puslopys',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'dt_viewxml_categories' => 'Kategorijas',
	'dt_viewxml_namespaces' => 'Vārdtelpas',
	'dt_viewxml_simplifiedformat' => 'Vienkāršots formāts',
	'dt_xml_namespace' => 'Vārdtelpa',
	'dt_xml_pages' => 'Lapas',
	'dt_xml_page' => 'Lapa',
	'dt_xml_template' => 'Veidne',
	'dt_xml_field' => 'Lauks',
	'dt_xml_name' => 'Vārds',
	'dt_xml_title' => 'Nosaukums',
	'dt_xml_id' => 'ID',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'dt_xml_namespace' => 'Лӱм-влакын кумдыкышт',
	'dt_xml_page' => 'Лаштык',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'datatransfer-desc' => 'Овозможува увоз и извоз на податоци содржани во повикувањата на шаблоните',
	'viewxml' => 'Преглед на XML',
	'dt_viewxml_docu' => 'Одберете од следиве категории и именски простори за преглед во XML формат.',
	'dt_viewxml_categories' => 'Категории',
	'dt_viewxml_namespaces' => 'Именски простори',
	'dt_viewxml_simplifiedformat' => 'Упростен формат',
	'dt_xml_namespace' => 'Именски простор',
	'dt_xml_pages' => 'Страници',
	'dt_xml_page' => 'Страница',
	'dt_xml_template' => 'Шаблон',
	'dt_xml_field' => 'Поле',
	'dt_xml_name' => 'Име',
	'dt_xml_title' => 'Наслов',
	'dt_xml_id' => 'Назнака',
	'dt_xml_freetext' => 'Слободен текст',
	'importxml' => 'Увоз на XML',
	'dt_import_selectfile' => 'Одберете ја $1 податотеката за увоз:',
	'dt_import_encodingtype' => 'Тип на кодирање:',
	'dt_import_forexisting' => 'За страници што веќе постојат:',
	'dt_import_overwriteexisting' => 'Презапиши врз постоечките содржини',
	'dt_import_skipexisting' => 'Прескокни',
	'dt_import_appendtoexisting' => 'Додај во постоечката содржина',
	'dt_import_summarydesc' => 'Опис на увозот:',
	'dt_import_editsummary' => 'Увоз на $1',
	'dt_import_importing' => 'Увезувам...',
	'dt_import_success' => '$1 {{PLURAL:$1|страница ќе биде создадена|страници ќе бидат создадени}} од $2 податотеката.',
	'importcsv' => 'Увоз на CSV',
	'dt_importcsv_badheader' => 'Грешка: насловот на колона $1, „$2“, мора да биде или „$3“, или „$4“, или пак од обликот „template_name[field_name]“',
	'right-datatransferimport' => 'Увезување податоци',
);

/** Malayalam (മലയാളം)
 * @author Junaidpv
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'viewxml' => 'XML കാണുക',
	'dt_viewxml_categories' => 'വർഗ്ഗങ്ങൾ',
	'dt_viewxml_namespaces' => 'നാമമേഖലകൾ',
	'dt_viewxml_simplifiedformat' => 'ലളിതവത്ക്കരിക്കപ്പെട്ട ഫോർമാറ്റ്',
	'dt_xml_namespace' => 'നാമമേഖല',
	'dt_xml_pages' => 'താളുകൾ',
	'dt_xml_page' => 'താൾ',
	'dt_xml_template' => 'ഫലകം',
	'dt_xml_field' => 'ഫീൽഡ്',
	'dt_xml_name' => 'പേര്‌',
	'dt_xml_title' => 'ശീർഷകം',
	'dt_xml_id' => 'ഐ.ഡി.',
	'dt_xml_freetext' => 'സ്വതന്ത്ര എഴുത്ത്',
	'importxml' => 'എക്സ്.എം.എൽ. ഇറക്കുമതി',
	'dt_import_selectfile' => 'ദയവായി ഇറക്കുമതിക്കായി $1 പ്രമാണം തിരഞ്ഞെടുക്കുക:',
	'dt_import_encodingtype' => 'എൻ‌കോഡിങ് തരം:',
	'dt_import_forexisting' => 'നിലവിലുള്ള താളുകൾക്ക് വേണ്ടി:',
	'dt_import_appendtoexisting' => 'നിലവിലുള്ള ഉള്ളടക്കത്തോട് കൂട്ടിച്ചേർക്കുക',
	'dt_import_summarydesc' => 'ഇറക്കുമതിയുടെ സംഗ്രഹം:',
	'dt_import_editsummary' => '$1 ഇറക്കുമതി',
	'dt_import_importing' => 'ഇറക്കുമതി ചെയ്യുന്നു...',
	'importcsv' => 'സി.എസ്.വി. ഇറക്കുമതി',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'dt_viewxml_categories' => 'Ангиллууд',
	'dt_viewxml_namespaces' => 'Нэрний зайнууд',
	'dt_xml_namespace' => 'Нэрний зай',
	'dt_xml_page' => 'Хуудас',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author V.narsikar
 */
$messages['mr'] = array(
	'datatransfer-desc' => 'साचा कॉल मध्ये असणार्‍या डाटाची आयात निर्यात करण्याची परवानगी देतो',
	'viewxml' => 'XML पहा',
	'dt_viewxml_docu' => 'कॄपया XML मध्ये पाहण्यासाठी खालीलपैकी वर्ग व नामविश्वे निवडा.',
	'dt_viewxml_categories' => 'वर्ग',
	'dt_viewxml_namespaces' => 'नामविश्वे',
	'dt_viewxml_simplifiedformat' => 'सोप्या प्रकारे',
	'dt_xml_namespace' => 'नामविश्व',
	'dt_xml_page' => 'पान',
	'dt_xml_field' => 'रकाना',
	'dt_xml_name' => 'नाव',
	'dt_xml_title' => 'शीर्षक',
	'dt_xml_id' => 'क्रमांक (आयडी)',
	'dt_xml_freetext' => 'मुक्त मजकूर',
	'importxml' => 'एक्सएमएल आयात करा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'dt_viewxml_categories' => 'Kategori',
	'dt_xml_page' => 'Laman',
	'dt_xml_template' => 'Templat',
	'dt_xml_name' => 'Nama',
	'dt_xml_title' => 'Tajuk',
	'dt_import_importing' => 'Sedang mengimport...',
	'importcsv' => 'Import CSV',
	'right-datatransferimport' => 'Mengimport data',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'dt_xml_page' => 'Páigina',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'dt_viewxml_categories' => 'Категорият',
	'dt_viewxml_namespaces' => 'Лем потмот',
	'dt_xml_namespace' => 'Лемпотмо',
	'dt_xml_page' => 'Лопа',
	'dt_xml_template' => 'Лопа парцун',
	'dt_xml_field' => 'Пакся',
	'dt_xml_name' => 'Лемезэ',
	'dt_xml_title' => 'Конякс',
);

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = array(
	'dt_viewxml_categories' => 'رج‌ئون',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'dt_viewxml_categories' => 'Tlaìxmatkàtlàlilòtl',
	'dt_viewxml_namespaces' => 'Tōcātzin',
	'dt_xml_namespace' => 'Tōcātzin',
	'dt_xml_page' => 'Zāzanilli',
	'dt_xml_name' => 'Tōcāitl',
	'dt_xml_title' => 'Tōcāitl',
	'dt_xml_id' => 'ID',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'datatransfer-desc' => 'Gjør det mulig å importere og eksportere data som finnes i maloppkallinger',
	'viewxml' => 'Se XML',
	'dt_viewxml_docu' => 'Velg blant følgende kategorier og navnerom for å se dem i XML-format',
	'dt_viewxml_categories' => 'Kategorier',
	'dt_viewxml_namespaces' => 'Navnerom',
	'dt_viewxml_simplifiedformat' => 'Forenklet format',
	'dt_xml_namespace' => 'Navnerom',
	'dt_xml_pages' => 'Sider',
	'dt_xml_page' => 'Side',
	'dt_xml_template' => 'Mal',
	'dt_xml_field' => 'Felt',
	'dt_xml_name' => 'Navn',
	'dt_xml_title' => 'Tittel',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Fritekst',
	'importxml' => 'Importer XML',
	'dt_import_selectfile' => 'Vennligst velg $1-filen som skal importeres:',
	'dt_import_encodingtype' => 'Tegnkodingstype:',
	'dt_import_forexisting' => 'For sider som allerede finnes:',
	'dt_import_overwriteexisting' => 'Skriv over eksisterende innhold',
	'dt_import_skipexisting' => 'Hopp over',
	'dt_import_appendtoexisting' => 'Tilføy til eksisterende innhold',
	'dt_import_summarydesc' => 'Importsammendrag:',
	'dt_import_editsummary' => '$1-importering',
	'dt_import_importing' => 'Importerer...',
	'dt_import_success' => '{{PLURAL:$1|Én side|$1 sider}} vil bli importert fra $2-filen.',
	'importcsv' => 'Importer CSV',
	'dt_importcsv_badheader' => "Feil: kolonneoverskriften $1, '$2', må være enten '$3', '$4' eller på formen 'malnavn[feltnavn]'",
	'right-datatransferimport' => 'Importer data',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'dt_xml_name' => 'Naam',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'datatransfer-desc' => 'Maakt het importeren en exporteren van gestructureerde gegevens in sjabloonaanroepen mogelijk',
	'viewxml' => 'XML bekijken',
	'dt_viewxml_docu' => 'Selecteer uit de volgende categorieën en naamruimten om in XML-formaat te bekijken.',
	'dt_viewxml_categories' => 'Categorieën',
	'dt_viewxml_namespaces' => 'Naamruimten',
	'dt_viewxml_simplifiedformat' => 'Vereenvoudigd formaat',
	'dt_xml_namespace' => 'Naamruimte',
	'dt_xml_pages' => "Pagina's",
	'dt_xml_page' => 'Pagina',
	'dt_xml_template' => 'Sjabloon',
	'dt_xml_field' => 'Veld',
	'dt_xml_name' => 'Naam',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Vrije tekst',
	'importxml' => 'XML importeren',
	'dt_import_selectfile' => 'Selecteer het te importeren bestand van het type $1:',
	'dt_import_encodingtype' => 'Coderingstype:',
	'dt_import_forexisting' => "Voor pagina's die al bestaan:",
	'dt_import_overwriteexisting' => 'Bestaande inhoud overschrijven',
	'dt_import_skipexisting' => 'Overslaan',
	'dt_import_appendtoexisting' => 'Toevoegen aan bestaande inhoud',
	'dt_import_summarydesc' => 'Samenvatting van de import:',
	'dt_import_editsummary' => '$1-import',
	'dt_import_importing' => 'Bezig met importeren…',
	'dt_import_success' => "Uit het $2-bestand {{PLURAL:$1|wordt één pagina|worden $1 pagina's}} geïmporteerd.",
	'importcsv' => 'CSV importeren',
	'dt_importcsv_badheader' => 'Fout: De kop van kolom $1, "$2", moet "$3" of "$4" zijn, of in de vorm "sjabloonnaam[veldnaam]" genoteerd worden.',
	'right-datatransferimport' => 'Gegevens importeren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'datatransfer-desc' => 'Gjer det mogleg å importera og eksportera data i maloppkallingar',
	'viewxml' => 'Syn XML',
	'dt_viewxml_docu' => 'Vel mellom følgjande kategoriar og namnerom for å syna dei i XML-format.',
	'dt_viewxml_categories' => 'Kategoriar',
	'dt_viewxml_namespaces' => 'Namnerom',
	'dt_viewxml_simplifiedformat' => 'Forenkla format',
	'dt_xml_namespace' => 'Namnerom',
	'dt_xml_pages' => 'Sider',
	'dt_xml_page' => 'Side',
	'dt_xml_template' => 'Mal',
	'dt_xml_field' => 'Felt',
	'dt_xml_name' => 'Namn',
	'dt_xml_title' => 'Tittel',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Fritekst',
	'importxml' => 'Importer XML',
	'dt_import_selectfile' => 'Ver venleg og vel $1-fila som skal verta importert:',
	'dt_import_encodingtype' => 'Teiknkodingstype:',
	'dt_import_editsummary' => '$1-importering',
	'dt_import_importing' => 'Importerer...',
	'dt_import_success' => '$1 {{PLURAL:$1|Éi side vil verta importert|$1 sider vil verta importerte}} frå $2-fila.',
	'importcsv' => 'Importer CSV',
	'dt_importcsv_badheader' => "Feil: kolonneoverskrifta $1, '$2', må vera anten '$3', '$4' eller på forma 'malnamn[feltnamn]'",
	'right-datatransferimport' => 'Importer data',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'datatransfer-desc' => "Permet l’impòrt e l’expòrt de donadas contengudas dins d'apèls de modèls",
	'viewxml' => 'Veire XML',
	'dt_viewxml_docu' => 'Seleccionatz demest las categorias e los espacis de nomenatges per visionar en format XML.',
	'dt_viewxml_categories' => 'Categorias',
	'dt_viewxml_namespaces' => 'Espacis de nomenatge',
	'dt_viewxml_simplifiedformat' => 'Format simplificat',
	'dt_xml_namespace' => 'Espaci de nom',
	'dt_xml_pages' => 'Paginas',
	'dt_xml_page' => 'Pagina',
	'dt_xml_template' => 'Modèl',
	'dt_xml_field' => 'Camp',
	'dt_xml_name' => 'Nom',
	'dt_xml_title' => 'Títol',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Tèxte Liure',
	'importxml' => 'Impòrt en XML',
	'dt_import_selectfile' => "Seleccionatz lo fichièr $1 d'importar :",
	'dt_import_encodingtype' => 'Tipe d’encodatge:',
	'dt_import_editsummary' => 'Importacion $1',
	'dt_import_importing' => 'Impòrt en cors...',
	'dt_import_success' => '$1 {{PLURAL:$1|pagina serà creada|paginas seràn creadas}} dempuèi lo fichièr $2.',
	'importcsv' => 'Impòrt CSV',
	'dt_importcsv_badheader' => 'Error : lo títol de colomna $1, « $2 », deu èsser siá « $3 », « $4 » o de la forma « nom_del_modèl[nom_del_camp] »',
	'right-datatransferimport' => 'Importar de donadas',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'dt_viewxml_categories' => 'ଶ୍ରେଣୀସମୂହ',
	'dt_xml_pages' => 'ପୃଷ୍ଠା',
	'dt_xml_page' => 'ପୃଷ୍ଠା',
	'dt_xml_template' => 'ଛାଞ୍ଚ',
	'dt_xml_field' => 'କ୍ଷେତ୍ର',
	'dt_xml_name' => 'ନାମ',
	'dt_xml_title' => 'ଶିରୋନାମା',
	'dt_xml_id' => 'ପରିଚୟ',
	'dt_import_editsummary' => '$1 ଆମଦାନୀ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'dt_xml_page' => 'Фарс',
	'dt_xml_template' => 'Шаблон',
	'dt_xml_title' => 'Сæргонд',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'dt_viewxml_categories' => 'Abdeelinge',
	'dt_viewxml_namespaces' => 'Blatznaame',
	'dt_xml_namespace' => 'Blatznaame',
	'dt_xml_pages' => 'Bledder',
	'dt_xml_page' => 'Blatt',
	'dt_xml_template' => 'Moddel',
	'dt_xml_name' => 'Naame',
	'dt_xml_title' => 'Titel',
);

/** Polish (Polski)
 * @author McMonster
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'datatransfer-desc' => 'Pozwala na importowanie i eksportowanie danych zawartych w wywołaniach szablonu',
	'viewxml' => 'Podgląd XML',
	'dt_viewxml_docu' => 'Wybierz, które spośród następujących kategorii i przestrzeni nazw chcesz podejrzeć w formacie XML.',
	'dt_viewxml_categories' => 'Kategorie',
	'dt_viewxml_namespaces' => 'Przestrzenie nazw',
	'dt_viewxml_simplifiedformat' => 'Format uproszczony',
	'dt_xml_namespace' => 'Przestrzeń nazw',
	'dt_xml_pages' => 'Strony',
	'dt_xml_page' => 'Strona',
	'dt_xml_template' => 'Szablon',
	'dt_xml_field' => 'Pole',
	'dt_xml_name' => 'Nazwa',
	'dt_xml_title' => 'Tytuł',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Dowolny tekst',
	'importxml' => 'Import XML',
	'dt_import_selectfile' => 'Wybierz plik $1 do zaimportowania',
	'dt_import_encodingtype' => 'Typ kodowania',
	'dt_import_forexisting' => 'Dla stron, które już istnieją:',
	'dt_import_overwriteexisting' => 'Zastąp istniejącą zawartość',
	'dt_import_skipexisting' => 'Pomiń',
	'dt_import_appendtoexisting' => 'Dołącz do istniejącej zawartości',
	'dt_import_summarydesc' => 'Podsumowanie importu',
	'dt_import_editsummary' => 'Import $1',
	'dt_import_importing' => 'Importowanie...',
	'dt_import_success' => '$1 {{PLURAL:$1|strona zostanie utworzona|strony zostaną utworzone|stron zostanie utworzonych}} z pliku $2.',
	'importcsv' => 'Import CSV',
	'dt_importcsv_badheader' => 'Błąd – w kolumnie $1 nagłówka jest „$2”, a powinno być: „$3”, „$4” lub „nazwa_szablonu[nazwa_pola]”',
	'right-datatransferimport' => 'Importowanie danych',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'datatransfer-desc' => "A përmëtt d'amporté e esporté ij dat contnù ant le ciamà a stamp",
	'viewxml' => 'Varda XML',
	'dt_viewxml_docu' => 'Për piasì selession-a an tra le categorìe sota e jë spassi nominaj për vëdde an formà XLM.',
	'dt_viewxml_categories' => 'Categorìe',
	'dt_viewxml_namespaces' => 'Spassi nominaj',
	'dt_viewxml_simplifiedformat' => 'Formà semplificà',
	'dt_xml_namespace' => 'Spassi nominal',
	'dt_xml_pages' => 'Pàgine',
	'dt_xml_page' => 'Pàgina',
	'dt_xml_template' => 'Stamp',
	'dt_xml_field' => 'Camp',
	'dt_xml_name' => 'Nòm',
	'dt_xml_title' => 'Tìtol',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Test lìber',
	'importxml' => 'Ampòrta XML',
	'dt_import_selectfile' => 'Për piasì selession-a ël file $1 da amporté:',
	'dt_import_encodingtype' => 'Tipo ëd codìfica:',
	'dt_import_forexisting' => "Për pàgine ch'a esisto già:",
	'dt_import_overwriteexisting' => 'Coaté ël contnù esistent',
	'dt_import_skipexisting' => 'Saoté',
	'dt_import_appendtoexisting' => 'Gionté al contnù esistent',
	'dt_import_summarydesc' => "Somari dj'amportassion:",
	'dt_import_editsummary' => '$1 ampòrta',
	'dt_import_importing' => "An camin ch'as ampòrta...",
	'dt_import_success' => "$1 {{PLURAL:$1|pàgina|pàgine}} a saran creà da l'archivi $2.",
	'importcsv' => 'Ampòrta CSV',
	'dt_importcsv_badheader' => "Eror: l'antestassion ëd la colòna $1, '$2', a deuv esse '$3', '$4' o ëd la forma 'template_name[field_name]'",
	'right-datatransferimport' => 'Ampòrta dat',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'viewxml' => 'XML کتل',
	'dt_viewxml_categories' => 'وېشنيزې',
	'dt_viewxml_namespaces' => 'نوم-تشيالونه',
	'dt_viewxml_simplifiedformat' => 'ساده بڼه',
	'dt_xml_namespace' => 'نوم-تشيال',
	'dt_xml_pages' => 'مخونه',
	'dt_xml_page' => 'مخ',
	'dt_xml_template' => 'کينډۍ',
	'dt_xml_name' => 'نوم',
	'dt_xml_title' => 'سرليک',
	'dt_xml_id' => 'پېژند',
	'dt_xml_freetext' => 'خپلواکه متن',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'datatransfer-desc' => 'Permite importação e exportação de dados contidos em chamadas de predefinições',
	'viewxml' => 'Ver XML',
	'dt_viewxml_docu' => 'Por favor, seleccione de entre as categorias e espaços nominais seguintes para ver em formato XML.',
	'dt_viewxml_categories' => 'Categorias',
	'dt_viewxml_namespaces' => 'Espaços nominais',
	'dt_viewxml_simplifiedformat' => 'Formato simplificado',
	'dt_xml_namespace' => 'Espaço nominal',
	'dt_xml_pages' => 'Páginas',
	'dt_xml_page' => 'Página',
	'dt_xml_template' => 'Predefinição',
	'dt_xml_field' => 'Campo',
	'dt_xml_name' => 'Nome',
	'dt_xml_title' => 'Título',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Texto Livre',
	'importxml' => 'Importar XML',
	'dt_import_selectfile' => 'Por favor, selecione o ficheiro $1 a importar:',
	'dt_import_encodingtype' => 'Tipo de codificação:',
	'dt_import_forexisting' => 'Para páginas que já existem:',
	'dt_import_overwriteexisting' => 'Sobrescrever o conteúdo existente',
	'dt_import_skipexisting' => 'Saltar',
	'dt_import_appendtoexisting' => 'Acrescentar ao conteúdo existente',
	'dt_import_summarydesc' => 'Resumo da importação:',
	'dt_import_editsummary' => 'Importação de $1',
	'dt_import_importing' => 'Importando...',
	'dt_import_success' => '{{PLURAL:$1|A página será importada|As páginas serão importadas}} a partir do ficheiro $2.',
	'importcsv' => 'Importar CSV',
	'dt_importcsv_badheader' => "Erro: o cabeçalho da coluna $1, '$2', deve ser '$3', '$4' ou ter a forma 'nome_da_predefinição[nome_do_campo]'",
	'right-datatransferimport' => 'Importar dados',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'datatransfer-desc' => 'Permite a importação e exportação de dados contidos em chamadas de predefinições',
	'viewxml' => 'Ver XML',
	'dt_viewxml_docu' => 'Por favor, selecione dentre as categorias e espaços nominais seguintes para ver em formato XML.',
	'dt_viewxml_categories' => 'Categorias',
	'dt_viewxml_namespaces' => 'Espaços nominais',
	'dt_viewxml_simplifiedformat' => 'Formato simplificado',
	'dt_xml_namespace' => 'Espaço nominal',
	'dt_xml_pages' => 'Páginas',
	'dt_xml_page' => 'Página',
	'dt_xml_template' => 'Predefinição',
	'dt_xml_field' => 'Campo',
	'dt_xml_name' => 'Nome',
	'dt_xml_title' => 'Título',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Texto Livre',
	'importxml' => 'Importar XML',
	'dt_import_selectfile' => 'Por favor selecione o arquivo $1 para importar:',
	'dt_import_encodingtype' => 'Codificação:',
	'dt_import_forexisting' => 'Para páginas que já existem:',
	'dt_import_overwriteexisting' => 'Sobrescrever o conteúdo existente',
	'dt_import_skipexisting' => 'Pular',
	'dt_import_appendtoexisting' => 'Adicionar ao conteúdo existente',
	'dt_import_summarydesc' => 'Resumo da importação:',
	'dt_import_editsummary' => 'Importação de $1',
	'dt_import_importing' => 'Importando...',
	'dt_import_success' => '$1 {{PLURAL:$1|página será importada|páginas serão importadas}} do arquivo $2.',
	'importcsv' => 'Importar CSV',
	'dt_importcsv_badheader' => "Erro: o cabeçalho da coluna $1, '$2', deve ser '$3', ou '$4' ou da forma 'nome_modelo[nome_campo]'",
	'right-datatransferimport' => 'Importar dados',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'viewxml' => 'Vizualizează XML',
	'dt_viewxml_categories' => 'Categorii',
	'dt_viewxml_namespaces' => 'Spații de nume',
	'dt_viewxml_simplifiedformat' => 'Format simplificat',
	'dt_xml_namespace' => 'Spațiu de nume',
	'dt_xml_pages' => 'Pagini',
	'dt_xml_page' => 'Pagină',
	'dt_xml_template' => 'Format',
	'dt_xml_field' => 'Câmp',
	'dt_xml_name' => 'Nume',
	'dt_xml_title' => 'Titlu',
	'dt_xml_id' => 'ID',
	'importxml' => 'Importă XML',
	'dt_import_summarydesc' => 'Descrierea importului:',
	'dt_import_importing' => 'Importare...',
	'importcsv' => 'Importă CSV',
	'right-datatransferimport' => 'Importă date',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'datatransfer-desc' => "Permètte de 'mbortà e esportà date strutturate ca stonne jndr'à le chiamate a le template",
	'viewxml' => "Vide l'XML",
	'dt_viewxml_docu' => "Pe piacere scacchie ìmbrà le categorije seguende e le namespace seguende pe vedè 'u formate XML.",
	'dt_viewxml_categories' => 'Categorije',
	'dt_viewxml_namespaces' => 'Namespace',
	'dt_viewxml_simplifiedformat' => 'Formate semblifichete',
	'dt_xml_namespace' => 'Namespace',
	'dt_xml_pages' => 'Pàggene',
	'dt_xml_page' => 'Pàgene',
	'dt_xml_template' => 'Template',
	'dt_xml_field' => 'Cambe',
	'dt_xml_name' => 'Nome',
	'dt_xml_title' => 'Titele',
	'dt_xml_id' => 'Codece (ID)',
	'dt_xml_freetext' => 'Teste libbere',
	'importxml' => "'Mborte XML",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'datatransfer-desc' => 'Позволяет импортировать и экспортировать данные, содержащиеся в вызовах шаблонов',
	'viewxml' => 'Просмотр XML',
	'dt_viewxml_docu' => 'Пожалуйста, выберите категории и пространства имён для просмотра в формате XML.',
	'dt_viewxml_categories' => 'Категории',
	'dt_viewxml_namespaces' => 'Пространства имён',
	'dt_viewxml_simplifiedformat' => 'Упрощённый формат',
	'dt_xml_namespace' => 'Пространство имён',
	'dt_xml_pages' => 'Страницы',
	'dt_xml_page' => 'Страница',
	'dt_xml_template' => 'Шаблон',
	'dt_xml_field' => 'Поле',
	'dt_xml_name' => 'Имя',
	'dt_xml_title' => 'Заголовок',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Свободный текст',
	'importxml' => 'Импорт XML',
	'dt_import_selectfile' => 'Пожалуйста, выберите файл $1 для импорта:',
	'dt_import_encodingtype' => 'Тип кодировки:',
	'dt_import_forexisting' => 'Для страниц, которые уже существуют:',
	'dt_import_overwriteexisting' => 'Переписать существующие данные',
	'dt_import_skipexisting' => 'Пропустить',
	'dt_import_appendtoexisting' => 'Добавить к существующим данным',
	'dt_import_summarydesc' => 'Описание импорта:',
	'dt_import_editsummary' => 'импорт $1',
	'dt_import_importing' => 'Импортирование...',
	'dt_import_success' => '$1 {{PLURAL:$1|страница была|страницы были|страниц были}} созданы из файла $2.',
	'importcsv' => 'Импорт CSV',
	'dt_importcsv_badheader' => 'Ошибка. Заголовок колонки №$1 «$2» должен быть или «$3», или «$4», или в форме «template_name[field_name]»',
	'right-datatransferimport' => 'импорт информации',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'dt_viewxml_categories' => 'Катеґорії',
	'dt_viewxml_namespaces' => 'Просторы назв',
	'dt_viewxml_simplifiedformat' => 'Простый формат',
	'dt_xml_namespace' => 'Простор назв',
	'dt_xml_pages' => 'Сторінкы',
	'dt_xml_page' => 'Сторінка',
	'dt_xml_template' => 'Шаблона',
	'dt_xml_field' => 'Поле',
	'dt_xml_name' => 'Назва',
	'dt_xml_title' => 'Надпис',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Вольный текст',
	'importxml' => 'Імпортовати XML',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'dt_xml_name' => 'Nomu',
	'dt_xml_id' => 'ID',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'datatransfer-desc' => 'Umožňuje import a export údajov obsiahnutých v bunkách šablón',
	'viewxml' => 'Zobraziť XML',
	'dt_viewxml_docu' => 'Prosím, vyberte ktorý spomedzi nasledovných kategórií a menných priestorov zobraziť vo formáte XML.',
	'dt_viewxml_categories' => 'Kategórie',
	'dt_viewxml_namespaces' => 'Menné priestory',
	'dt_viewxml_simplifiedformat' => 'Zjednodušený formát',
	'dt_xml_namespace' => 'Menný priestor',
	'dt_xml_pages' => 'Stránky',
	'dt_xml_page' => 'Stránka',
	'dt_xml_template' => 'Šablóna',
	'dt_xml_field' => 'Pole',
	'dt_xml_name' => 'Názov',
	'dt_xml_title' => 'Nadpis',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Voľný text',
	'importxml' => 'Importovať XML',
	'dt_import_selectfile' => 'Prosím, vyberte $1 súbor, ktorý chcete importovať:',
	'dt_import_encodingtype' => 'Typ kódovania:',
	'dt_import_editsummary' => 'Import $1',
	'dt_import_importing' => 'Prebieha import...',
	'dt_import_success' => 'Z $2 súboru sa {{PLURAL:$1|importuje $1 stránka|importujú $1 stránky|importuje $1 stránok}}.',
	'importcsv' => 'Import CSV',
	'dt_importcsv_badheader' => 'Chyba: stĺpec $1 hlavičky, „$2“ musí mať hodnotu buď „$3“, „$4“ alebo byť v tvare „názov_šablóny[názov_poľa]“',
	'right-datatransferimport' => 'Importovať údaje',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'datatransfer-desc' => 'Omogoča uvažanje in izvažanje podatkov iz klicev predlog',
	'viewxml' => 'Ogled XML',
	'dt_viewxml_docu' => 'Prosimo, izberite med naslednjimi kategorijami in imenskimi prostori za ogled v obliki XML.',
	'dt_viewxml_categories' => 'Kategorije',
	'dt_viewxml_namespaces' => 'Imenski prostori',
	'dt_viewxml_simplifiedformat' => 'Poenostavljena oblika',
	'dt_xml_namespace' => 'Imenski prostor',
	'dt_xml_pages' => 'Strani',
	'dt_xml_page' => 'Stran',
	'dt_xml_template' => 'Predloga',
	'dt_xml_field' => 'Polje',
	'dt_xml_name' => 'Ime',
	'dt_xml_title' => 'Naslov',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Prosto besedilo',
	'importxml' => 'Uvozi XML',
	'dt_import_selectfile' => 'Prosimo, izberite datoteko $1 za uvoz:',
	'dt_import_encodingtype' => 'Vrsta kodiranja:',
	'dt_import_forexisting' => 'Za že obstoječe strani:',
	'dt_import_overwriteexisting' => 'Prepiši obstoječo vsebino',
	'dt_import_skipexisting' => 'Preskoči',
	'dt_import_appendtoexisting' => 'Dodaj obstoječi vsebini',
	'dt_import_summarydesc' => 'Povzetek uvoza:',
	'dt_import_editsummary' => 'uvoz $1',
	'dt_import_importing' => 'Uvažanje ...',
	'dt_import_success' => 'Iz datoteke $2 bom ustvaril $1 {{PLURAL:$1|stran|strani}}.',
	'importcsv' => 'Uvozi CSV',
	'dt_importcsv_badheader' => "Napaka: glava stolpca $1, '$2', mora biti '$3', '$4' ali oblike 'template_name[field_name]'",
	'right-datatransferimport' => 'Uvoz podatkov',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'viewxml' => 'Види XML',
	'dt_viewxml_categories' => 'Категорије',
	'dt_viewxml_namespaces' => 'Именски простори',
	'dt_viewxml_simplifiedformat' => 'Поједностављени формат',
	'dt_xml_namespace' => 'Именски простор',
	'dt_xml_pages' => 'Странице',
	'dt_xml_page' => 'Страница',
	'dt_xml_template' => 'Шаблон',
	'dt_xml_field' => 'Поље',
	'dt_xml_name' => 'Име',
	'dt_xml_title' => 'Наслов',
	'dt_xml_id' => 'Назнака',
	'dt_xml_freetext' => 'Слободан текст',
	'importxml' => 'Увези XML',
	'dt_import_editsummary' => '$1 увоз',
	'dt_import_importing' => 'Увоз у току...',
	'importcsv' => 'Увези CSV',
	'right-datatransferimport' => 'Увези податке',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'viewxml' => 'Vidi XML',
	'dt_viewxml_categories' => 'Kategorije',
	'dt_viewxml_namespaces' => 'Imenski prostori',
	'dt_viewxml_simplifiedformat' => 'Pojednostavljeni format',
	'dt_xml_namespace' => 'Imenski prostor',
	'dt_xml_pages' => 'Članci',
	'dt_xml_page' => 'Stranica',
	'dt_xml_template' => 'Šablon',
	'dt_xml_field' => 'Polje',
	'dt_xml_name' => 'Ime',
	'dt_xml_title' => 'Naslov',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Slobodan tekst',
	'importxml' => 'Uvezi XML',
	'dt_import_editsummary' => '$1 uvoz',
	'dt_import_importing' => 'Uvoz u toku...',
	'importcsv' => 'Uvezi CSV',
	'right-datatransferimport' => 'Uvezi podatke',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'datatransfer-desc' => 'Ferlööwet dän Import un Export fon strukturierde Doaten, do der in Aproupen un Foarloagen ferwoand wäide.',
	'viewxml' => 'XML ankiekje',
	'dt_viewxml_docu' => 'Wääl uut, wäkke Kategorien in dät XML-Formoat anwiesd wäide skällen.',
	'dt_viewxml_categories' => 'Kategorien',
	'dt_viewxml_namespaces' => 'Noomensruume',
	'dt_viewxml_simplifiedformat' => 'Fereenfacht Formoat',
	'dt_xml_namespace' => 'Noomensruum',
	'dt_xml_page' => 'Siede',
	'dt_xml_field' => 'Fäild',
	'dt_xml_name' => 'Noome',
	'dt_xml_title' => 'Tittel',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'dt_viewxml_namespaces' => 'Ngaranspasi',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Gabbe.g
 * @author Lejonel
 * @author M.M.S.
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'datatransfer-desc' => 'Tillåter import och export av data som finns i mallanrop',
	'viewxml' => 'Visa XML',
	'dt_viewxml_docu' => 'Välj vilka av följande kategorier och namnrymder som ska visas i XML-format.',
	'dt_viewxml_categories' => 'Kategorier',
	'dt_viewxml_namespaces' => 'Namnrymder',
	'dt_viewxml_simplifiedformat' => 'Förenklat format',
	'dt_xml_namespace' => 'Namnrymd',
	'dt_xml_pages' => 'Sidor',
	'dt_xml_page' => 'Sida',
	'dt_xml_template' => 'Mall',
	'dt_xml_field' => 'Fält',
	'dt_xml_name' => 'Namn',
	'dt_xml_title' => 'Titel',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Fritext',
	'importxml' => 'Importera XML',
	'dt_import_selectfile' => 'Vänligen välj $1-filen som skall importeras:',
	'dt_import_encodingtype' => 'Teckenkodningstyp:',
	'dt_import_overwriteexisting' => 'Skriv över existerande innehåll',
	'dt_import_skipexisting' => 'Hoppa över',
	'dt_import_editsummary' => '$1-importering',
	'dt_import_importing' => 'Importerar...',
	'dt_import_success' => '$1 {{PLURAL:$1|sida|sidor}} kommer skapas från $2-filen.',
	'importcsv' => 'Importera CSV',
	'dt_importcsv_badheader' => "Fel: Titeln $2 för kolumnen $1 måste vara antingen $3, $4 eller på formen 'mallnamn[fältnamn]'",
	'right-datatransferimport' => 'Importera data',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'dt_xml_page' => 'Zajta',
	'dt_xml_name' => 'Mjano',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 * @author Ulmo
 */
$messages['ta'] = array(
	'dt_viewxml_categories' => 'பகுப்புகள்',
	'dt_viewxml_namespaces' => 'பெயர்வெளிகள்',
	'dt_viewxml_simplifiedformat' => 'எளிதாக்கப்பட்ட வடிவம்',
	'dt_xml_namespace' => 'பெயர்வெளி',
	'dt_xml_pages' => 'பக்கங்கள்',
	'dt_xml_page' => 'பக்கம்',
	'dt_xml_template' => 'வார்ப்புரு',
	'dt_xml_name' => 'பெயர்',
	'dt_xml_title' => 'தலைப்பு',
	'dt_xml_id' => 'அடையாளம்',
	'dt_xml_freetext' => 'எந்த கட்டுப்பாடும் இல்லா சொற்றொடர்',
	'dt_import_importing' => 'இறக்குமதியாகிறது...',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'viewxml' => 'XMLని చూడండి',
	'dt_viewxml_categories' => 'వర్గాలు',
	'dt_viewxml_namespaces' => 'పేరుబరులు',
	'dt_xml_namespace' => 'పేరుబరి',
	'dt_xml_pages' => 'పేజీలు',
	'dt_xml_page' => 'పేజీ',
	'dt_xml_template' => 'మూస',
	'dt_xml_name' => 'పేరు',
	'dt_xml_title' => 'శీర్షిక',
	'dt_xml_id' => 'ఐడీ',
	'dt_xml_freetext' => 'స్వేచ్ఛా పాఠ్యం',
	'dt_import_appendtoexisting' => 'ఈసరికే ఉన్న కంటెంటు వెనుక చేర్చు',
	'dt_import_summarydesc' => 'దిగుమతి సారాంశం:',
	'dt_import_editsummary' => '$1 దిగుమతి',
	'dt_import_importing' => 'దిగుమతి చేస్తున్నాం...',
	'dt_import_success' => 'ఫైలు $2 నుండి $1 {{PLURAL:$1|పేజీ|పేజీలు}} సృష్టించబడతాయి.',
	'importcsv' => 'CSV ని దిగుమతి చెయ్యి',
	'dt_importcsv_badheader' => "లోపం: నిలువు వరుస $1 శీర్షం, '$2', '$3' అయినా లేక  '$4' అయినా ఉండాలి. లేదా 'template_name[field_name]' రూపంలో అయినా ఉండాలి",
	'right-datatransferimport' => 'డేటాను దిగుమతి చెయ్యి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'dt_viewxml_categories' => 'Kategoria sira',
	'dt_xml_namespace' => 'Espasu pájina nian',
	'dt_xml_pages' => 'Pájina sira',
	'dt_xml_page' => 'Pájina',
	'dt_xml_name' => 'Naran',
	'dt_xml_title' => 'Títulu:',
	'dt_xml_id' => 'ID',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'dt_viewxml_categories' => 'Гурӯҳҳо',
	'dt_viewxml_namespaces' => 'Фазоҳои ном',
	'dt_xml_namespace' => 'Фазоином',
	'dt_xml_page' => 'Саҳифа',
	'dt_xml_name' => 'Ном',
	'dt_xml_title' => 'Унвон',
	'dt_xml_freetext' => 'Матни дилхоҳ',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'dt_viewxml_categories' => 'Gurūhho',
	'dt_viewxml_namespaces' => 'Fazohoi nom',
	'dt_xml_namespace' => 'Fazoinom',
	'dt_xml_page' => 'Sahifa',
	'dt_xml_name' => 'Nom',
	'dt_xml_title' => 'Unvon',
	'dt_xml_freetext' => 'Matni dilxoh',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'dt_viewxml_categories' => 'หมวดหมู่',
	'dt_viewxml_namespaces' => 'เนมสเปซ',
	'dt_xml_namespace' => 'เนมสเปซ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'dt_xml_page' => 'Sahypa',
	'dt_xml_name' => 'At',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'datatransfer-desc' => 'Nagpapahintulot sa pag-aangkat at pagluluwas ng mga datong nasa loob ng mga pagtawag sa suleras',
	'viewxml' => 'Tingnan ang XML',
	'dt_viewxml_docu' => 'Pumili po lamang mula sa sumusunod na mga kaurian at mga espasyo ng pangalan upang makita ang anyong XML.',
	'dt_viewxml_categories' => 'Mga kaurian',
	'dt_viewxml_namespaces' => 'Mga espasyo ng pangalan',
	'dt_viewxml_simplifiedformat' => 'Pinapayak na anyo',
	'dt_xml_namespace' => 'Espasyo ng pangalan',
	'dt_xml_pages' => 'Mga pahina',
	'dt_xml_page' => 'Pahina',
	'dt_xml_template' => 'Suleras',
	'dt_xml_field' => 'Hanay',
	'dt_xml_name' => 'Pangalan',
	'dt_xml_title' => 'Pamagat',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Malayang Teksto',
	'importxml' => 'Angkatin ang XML',
	'dt_import_selectfile' => 'Pakipili ang talaksang $1 na aangkatin:',
	'dt_import_encodingtype' => 'Uri ng pagkokodigo:',
	'dt_import_forexisting' => 'Para sa mga pahinang umiiral na:',
	'dt_import_overwriteexisting' => 'Patungan ang umiiral na nilalaman',
	'dt_import_skipexisting' => 'Laktawan',
	'dt_import_appendtoexisting' => 'Isugpong sa umiiral na nilalaman',
	'dt_import_summarydesc' => 'Buod ng pag-angkat:',
	'dt_import_editsummary' => 'Pag-angkat ng $1',
	'dt_import_importing' => 'Inaangkat...',
	'dt_import_success' => '$1 {{PLURAL:$1|pahina|mga pahina}} ang lilikhain mula sa talaksang $2.',
	'importcsv' => 'Angkatin ang CSV',
	'dt_importcsv_badheader' => "Kamalian: ang patayong hanay ng paulong $1, '$2', ay dapat na '$3', '$4' o nasa pormang 'template_name[field_name]'",
	'right-datatransferimport' => 'Angkatin ang dato',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Mach
 * @author Manco Capac
 * @author Srhat
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'datatransfer-desc' => 'Şablon çağrılarında içerilen verilerin içe ve dışa aktarımına izin verir',
	'viewxml' => "XML'i gör",
	'dt_viewxml_docu' => 'Lütfen, XML formatında görüntülemek için aşağıdaki kategori ve ad alanları arasından seçin.',
	'dt_viewxml_categories' => 'Kategoriler',
	'dt_viewxml_namespaces' => 'İsim alanları',
	'dt_viewxml_simplifiedformat' => 'Basitleştirilmiş format',
	'dt_xml_namespace' => 'Ad alanı',
	'dt_xml_pages' => 'Sayfalar',
	'dt_xml_page' => 'Sayfa',
	'dt_xml_template' => 'Şablon',
	'dt_xml_field' => 'Alan',
	'dt_xml_name' => 'İsim',
	'dt_xml_title' => 'Başlık',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Özgür Metin',
	'importxml' => 'XML içe aktar',
	'dt_import_selectfile' => 'Lütfen içe aktarmak için $1 dosyasını seçin:',
	'dt_import_encodingtype' => 'Kodlama türü:',
	'dt_import_summarydesc' => 'İçe aktarma özeti:',
	'dt_import_editsummary' => '$1 içe aktarımı',
	'dt_import_importing' => 'İçe aktarıyor...',
	'dt_import_success' => '$2 dosyasından $1 {{PLURAL:$1|sayfa|sayfa}} oluşturulacak.',
	'importcsv' => "CSV'yi içe aktar",
	'dt_importcsv_badheader' => "Hata: $1 kolonunun başlığı olan '$2', '$3', '$4' ya da 'şablon_adı[alan_adı]' şeklinde olmalıdır",
	'right-datatransferimport' => 'Verileri içe aktarır',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'dt_xml_page' => 'Bet',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Arturyatsko
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'datatransfer-desc' => 'Дозволяє імпортувати та експортувати дані, які містяться в викликах шаблонів',
	'viewxml' => 'Перегляд XML',
	'dt_viewxml_docu' => 'Будь ласка, виберіть одну з наступних категорій та імен для перегляду в форматі XML.',
	'dt_viewxml_categories' => 'Категорії',
	'dt_viewxml_namespaces' => 'Простори назв',
	'dt_viewxml_simplifiedformat' => 'Спрощений формат',
	'dt_xml_namespace' => 'Простір назв',
	'dt_xml_pages' => 'Сторінки',
	'dt_xml_page' => 'Сторінка',
	'dt_xml_template' => 'Шаблон',
	'dt_xml_field' => 'Поле',
	'dt_xml_name' => 'Назва',
	'dt_xml_title' => 'Заголовок',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Вільний текст',
	'importxml' => 'Імпорт XML',
	'dt_import_selectfile' => 'Будь ласка, виберіть файл $1 для імпорту:',
	'dt_import_encodingtype' => 'Тип кодування:',
	'dt_import_forexisting' => 'Для сторінок, які вже існують:',
	'dt_import_overwriteexisting' => 'Перезаписати існуючий вміст',
	'dt_import_skipexisting' => 'Пропустити',
	'dt_import_appendtoexisting' => 'Додати до існуючого вмісту',
	'dt_import_summarydesc' => 'Опис імпорту:',
	'dt_import_editsummary' => 'імпорт $1',
	'dt_import_importing' => 'Імпорт ...',
	'dt_import_success' => '$1 {{PLURAL:$1|сторінка була|сторінки було|сторінок було}} створено з файлу $2.',
	'importcsv' => 'Імпорт CSV',
	'dt_importcsv_badheader' => 'Помилка. Заголовок колонки №$1 «$2» повинен бути або «$3», або «$4», або у формі «template_name[field_name]»',
	'right-datatransferimport' => 'Імпорт даних',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'datatransfer-desc' => 'Cho phép nhập xuất dữ liệu có cấu trúc được chứa trong lời gọi bản mẫu',
	'viewxml' => 'Xem XML',
	'dt_viewxml_docu' => 'Xin hãy chọn trong những thể loại và không gian tên dưới đây để xem ở dạng XML.',
	'dt_viewxml_categories' => 'Thể loại',
	'dt_viewxml_namespaces' => 'Không gian tên',
	'dt_viewxml_simplifiedformat' => 'Định dạng đơn giản hóa',
	'dt_xml_namespace' => 'Không gian tên',
	'dt_xml_pages' => 'Trang',
	'dt_xml_page' => 'Trang',
	'dt_xml_template' => 'Bản mẫu',
	'dt_xml_field' => 'Trường',
	'dt_xml_name' => 'Tên',
	'dt_xml_title' => 'Tựa đề',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => 'Văn bản Tự do',
	'importxml' => 'Nhập XML',
	'dt_import_selectfile' => 'Xin hãy chọn tập tin $1 để nhập:',
	'dt_import_encodingtype' => 'Bảng mã:',
	'dt_import_editsummary' => 'Nhập $1',
	'dt_import_importing' => 'Đang nhập…',
	'dt_import_success' => '{{PLURAL:$1|Trang|$1 trang}} sẽ được nhập từ tập tin $2.',
	'importcsv' => 'Nhập CSV',
	'dt_importcsv_badheader' => 'Lỗi: tên của cột $1, “$2”, phải là “$3” hay “$4”, hoặc phải theo hình dạng “tên_tiêu_bản[tên_trường]”',
	'right-datatransferimport' => 'Nhập dữ liệu',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'datatransfer-desc' => 'Dälon nüveigi e seveigi nünodas peleodüköl in samafomotilüvoks paninädöls',
	'viewxml' => 'Logön eli XML',
	'dt_viewxml_docu' => 'Välolös bevü klads e nemaspads foviks utosi, kelosi vilol logön fomätü XML.',
	'dt_viewxml_categories' => 'Klads',
	'dt_viewxml_namespaces' => 'Nemaspads',
	'dt_viewxml_simplifiedformat' => 'Fomät pebalugüköl',
	'dt_xml_namespace' => 'Nemaspad',
	'dt_xml_page' => 'Pad',
	'dt_xml_field' => 'Fel',
	'dt_xml_name' => 'Nem',
	'dt_xml_title' => 'Tiäd',
	'dt_xml_id' => 'Dientifanüm',
	'dt_xml_freetext' => 'Vödem libik',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'dt_xml_name' => 'נאָמען',
	'dt_xml_title' => 'טיטל',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Hydra
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'datatransfer-desc' => '允许根据模板的要求导入导出结构化的数据',
	'viewxml' => '查看XML',
	'dt_viewxml_docu' => '请选择要使用XML格式查看的分类和名字空间。',
	'dt_viewxml_categories' => '分类',
	'dt_viewxml_namespaces' => '名字空间',
	'dt_viewxml_simplifiedformat' => '简化格式',
	'dt_xml_namespace' => '名字空间',
	'dt_xml_pages' => '页面',
	'dt_xml_page' => '页面',
	'dt_xml_template' => '模板',
	'dt_xml_field' => '事件',
	'dt_xml_name' => '名称',
	'dt_xml_title' => '标题',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => '自由文本',
	'importxml' => '导入 XML',
	'dt_import_selectfile' => '请选择 $1 要导入的文件：',
	'dt_import_encodingtype' => '编码类型：',
	'dt_import_forexisting' => '对于已经存在的页面：',
	'dt_import_overwriteexisting' => '覆盖现有内容',
	'dt_import_skipexisting' => '跳过',
	'dt_import_appendtoexisting' => '追加到现有内容',
	'dt_import_summarydesc' => '导入摘要：',
	'dt_import_editsummary' => '$1 导入',
	'dt_import_importing' => '正在导入...',
	'importcsv' => '导入 CSV',
	'right-datatransferimport' => '导入数据',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'datatransfer-desc' => '允許根據模板的要求導入導出結構化的數據',
	'viewxml' => '檢視XML',
	'dt_viewxml_docu' => '請在下列分類、名稱空間中選擇，以使用XML格式查看。',
	'dt_viewxml_categories' => '分類',
	'dt_viewxml_namespaces' => '名稱空間',
	'dt_viewxml_simplifiedformat' => '簡化格式',
	'dt_xml_namespace' => '名稱空間',
	'dt_xml_pages' => '頁面',
	'dt_xml_page' => '頁面',
	'dt_xml_template' => '模板',
	'dt_xml_field' => '事件',
	'dt_xml_name' => '名稱',
	'dt_xml_title' => '標題',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => '自由文字',
	'importxml' => '導入 XML',
	'dt_import_selectfile' => '請選擇 $1 要導入的文件：',
	'dt_import_encodingtype' => '編碼類型：',
	'dt_import_forexisting' => '對於已經存在的頁面：',
	'dt_import_overwriteexisting' => '覆蓋現有內容',
	'dt_import_skipexisting' => '跳過',
	'dt_import_appendtoexisting' => '追加到現有內容',
	'dt_import_summarydesc' => '導入摘要：',
	'dt_import_editsummary' => '$1 導入',
	'dt_import_importing' => '正在導入...',
	'importcsv' => '導入 CSV',
	'right-datatransferimport' => '導入數據',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Pbdragonwang
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'datatransfer-desc' => '允許匯入及匯出引用樣板(template calls)的結構性資料',
	'viewxml' => '查看 XML',
	'dt_viewxml_docu' => '請選取以下的分類及名字空間以查看其XML格式的資料',
	'dt_viewxml_categories' => '分類',
	'dt_viewxml_namespaces' => '名字空間',
	'dt_viewxml_simplifiedformat' => '簡化的格式',
	'dt_xml_namespace' => '名字空間',
	'dt_xml_pages' => '頁面',
	'dt_xml_page' => '頁面',
	'dt_xml_template' => '模板',
	'dt_xml_field' => '欄位',
	'dt_xml_name' => '名稱',
	'dt_xml_title' => '標題(Title)',
	'dt_xml_id' => 'ID',
	'dt_xml_freetext' => '隨意文字',
	'importxml' => '匯入XML',
	'dt_import_selectfile' => '請選取$1檔以供匯入',
	'dt_import_encodingtype' => '編碼類型',
	'dt_import_summarydesc' => '輸入的摘要',
	'dt_import_editsummary' => '匯入$1',
	'dt_import_importing' => '匯入中...',
	'dt_import_success' => '將從該$2檔匯入$1{{PLURAL:$1|頁面頁面}}。',
	'importcsv' => '匯入CSV檔',
	'dt_importcsv_badheader' => "錯誤：$1欄位的標題「$2」或必須為「$3」，「$4」或表單「模板名稱[欄位名稱]」<br />
Error: the column $1 header, '$2', must be either '$3', '$4' or of the form 'template_name[field_name]'",
	'right-datatransferimport' => '輸入資料',
);

