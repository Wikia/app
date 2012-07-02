<?php
/**
 * Internationalisation for InlineCategorizer extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Nimish Gautam
 */
$messages['en'] = array(
	'inlinecategorizer-desc' => 'JavaScript module that enables changing, adding and removing categorylinks directly from a page',

	// Ajax interface
	'inlinecategorizer-add-category'             => 'Add category',
	'inlinecategorizer-add-category-submit'      => 'Add',
	'inlinecategorizer-add-category-summary'     => 'Add category "$1"',
	'inlinecategorizer-api-error'                => 'The API returned an error: $1: $2.',
	'inlinecategorizer-api-unknown-error'        => 'The API returned an unknown error.',
	'inlinecategorizer-cancel'                   => 'Cancel edit',
	'inlinecategorizer-cancel-all'               => 'Cancel all changes',
	'inlinecategorizer-category-already-present' => 'This page already belongs to the category "$1"',
	'inlinecategorizer-category-hook-error'      => 'A local function prevented the changes from being saved.',
	'inlinecategorizer-category-question'        => 'Why do you want to make the following changes:',
	'inlinecategorizer-confirm-ok'               => 'OK',
	'inlinecategorizer-confirm-save'             => 'Save',
	'inlinecategorizer-confirm-save-all'         => 'Save all changes',
	'inlinecategorizer-confirm-title'            => 'Confirm action',
	'inlinecategorizer-edit-category'            => 'Edit category',
	'inlinecategorizer-edit-category-error'      => 'It was not possible to edit category "$1".
This usually occurs when the category has been added to the page in a template.',
	'inlinecategorizer-edit-category-summary'    => 'Change category "$1" to "$2"',
	'inlinecategorizer-error-title'              => 'Error',
	'inlinecategorizer-remove-category'          => 'Remove category',
	'inlinecategorizer-remove-category-error'    => 'It was not possible to remove category "$1".
This usually occurs when the category has been added to the page in a template.',
	'inlinecategorizer-remove-category-summary'  => 'Remove category "$1"',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Lloffiwr
 */
$messages['qqq'] = array(
	'inlinecategorizer-desc' => '{{desc}}',
	'inlinecategorizer-add-category-submit' => '{{Identical|Add}}',
	'inlinecategorizer-add-category-summary' => 'See {{msg-mw|inlinecategorizer-category-question}}. $1 is a category name.',
	'inlinecategorizer-api-error' => 'API = [http://en.wikipedia.org/wiki/Application_programming_interface Application programming interface].

"returned" here means "reported".',
	'inlinecategorizer-category-already-present' => 'Error message. $1 is the category name',
	'inlinecategorizer-category-question' => "Question the user is asked before submit. It's followed by a list of the changes.",
	'inlinecategorizer-confirm-ok' => '{{Identical|OK}}',
	'inlinecategorizer-confirm-save' => 'Submit button {{Identical|Save}}',
	'inlinecategorizer-confirm-save-all' => 'Submit button to save all changes',
	'inlinecategorizer-confirm-title' => 'Title for a dialog box in which the user is asked for an edit summary',
	'inlinecategorizer-edit-category' => 'Tooltip for the edit link displayed after each category at the foot of a page. Refers to the specific category. "Edit this category" is also correct.',
	'inlinecategorizer-edit-category-summary' => 'See {{msg-mw|inlinecategorizer-category-question}}. $1 and $2 are both category names.',
	'inlinecategorizer-error-title' => '{{Identical|Error}}',
	'inlinecategorizer-remove-category' => 'Tooltip for link to remove a category from the page, displayed after each category at the foot of a page. Refers to the specific category. "Remove this category" is also correct.',
	'inlinecategorizer-remove-category-summary' => 'See {{msg-mw|inlinecategorizer-category-question}}. $1 is a category name.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'inlinecategorizer-add-category' => 'Voeg kategorie by',
	'inlinecategorizer-add-category-submit' => 'Byvoeg',
	'inlinecategorizer-add-category-summary' => 'Voeg kategorie "$1" by',
	'inlinecategorizer-api-error' => 'Die API gee fout: $1: $2.',
	'inlinecategorizer-api-unknown-error' => "Die API gee 'n onbekende fout.",
	'inlinecategorizer-cancel' => 'Kanselleer wysiging',
	'inlinecategorizer-cancel-all' => 'Kanselleer alle wysigings',
	'inlinecategorizer-category-already-present' => 'Hierdie bladsy behoort reeds tot die kategorie "$1"',
	'inlinecategorizer-category-hook-error' => "'n Lokale funksie het verhoed dat die veranderinge gestoor word.",
	'inlinecategorizer-category-question' => 'Hoekom wil u die volgende wysigings aanbring:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Stoor',
	'inlinecategorizer-confirm-save-all' => 'Stoor alle wysigings',
	'inlinecategorizer-confirm-title' => 'Bevestig aksie',
	'inlinecategorizer-edit-category' => 'Wysig kategorie',
	'inlinecategorizer-edit-category-error' => 'Dit was nie moontlik om kategorie "$1" te wysig nie.
Dit gebeur gewoonlik as die kategorie deur \'n sjabloon by die bladsy gevoeg is.',
	'inlinecategorizer-edit-category-summary' => 'Verander kategorie "$1" na "$2"',
	'inlinecategorizer-error-title' => 'Fout',
	'inlinecategorizer-remove-category' => 'Verwyder kategorie',
	'inlinecategorizer-remove-category-error' => 'Ongelukkig was nie moontlik om die kategorie "$1" te verwyder nie.
Dit gebeur gewoonlik as die kategorie via \'n sjabloon by die bladsy bygevoeg is.',
	'inlinecategorizer-remove-category-summary' => 'Verwyder kategorie "$1"',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'inlinecategorizer-add-category' => 'Adhibir categoría',
	'inlinecategorizer-add-category-submit' => 'Adhibir',
	'inlinecategorizer-add-category-summary' => 'Adhibir categoría "$1"',
	'inlinecategorizer-confirm-save' => 'Alzar',
	'inlinecategorizer-confirm-title' => 'Confirmar acción',
	'inlinecategorizer-error-title' => 'Error',
	'inlinecategorizer-remove-category-error' => "No s'ha puesto eliminar ista categoría. Isto gosa pasar, por un regular, quan a categoría ha estau adhibida por una plantilla.",
	'inlinecategorizer-remove-category-summary' => 'Sacar a categoría "$1"',
);

/** Old English (Ænglisc)
 * @author Wōdenhelm
 */
$messages['ang'] = array(
	'inlinecategorizer-add-category' => 'Flocc ēacian',
	'inlinecategorizer-add-category-submit' => 'Ēacian',
	'inlinecategorizer-add-category-summary' => 'Flocc "$1" ēacian',
	'inlinecategorizer-confirm-save' => 'Sparian',
	'inlinecategorizer-error-title' => 'Ƿōh',
	'inlinecategorizer-remove-category-summary' => 'Flocc "$1" forniman',
);

/** Arabic (العربية)
 * @author Alexknight12
 * @author Houcinee1
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'inlinecategorizer-add-category' => 'أضف تصنيفا',
	'inlinecategorizer-add-category-submit' => 'أضف',
	'inlinecategorizer-add-category-summary' => 'إضافة التصنيف "$1"',
	'inlinecategorizer-api-error' => 'API أرجعت خطأ: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API أرجعت خطأ غير معروف.',
	'inlinecategorizer-cancel' => 'إلغاء عمليات التحرير',
	'inlinecategorizer-cancel-all' => 'إلغاء جميع التغييرات',
	'inlinecategorizer-category-already-present' => 'هذه الصفحة بالفعل تنتمي إلى تصنيف "$1"',
	'inlinecategorizer-category-hook-error' => 'دالة محلية منعت التغييرات من أن يتم حفظها.',
	'inlinecategorizer-category-question' => 'لماذا تريد القيام بالتغييرات التالية:',
	'inlinecategorizer-confirm-ok' => 'موافق',
	'inlinecategorizer-confirm-save' => 'احفظ',
	'inlinecategorizer-confirm-save-all' => 'حفظ كافة التغييرات',
	'inlinecategorizer-confirm-title' => 'أكد الإجراء',
	'inlinecategorizer-edit-category' => 'عدل التصنيف',
	'inlinecategorizer-edit-category-error' => 'تعذر تعديل تصنيف "$1".
يحدث هذا عادة عندما يضاف التصنيف إلى الصفحة عبر قالب.',
	'inlinecategorizer-edit-category-summary' => 'تغيير التصنيف "$1" إلى "$2"',
	'inlinecategorizer-error-title' => 'خطأ',
	'inlinecategorizer-remove-category' => 'أزل التصنيف',
	'inlinecategorizer-remove-category-error' => 'تعذرت إزالة تصنيف "$1".
يحدث هذا عادة عندما يضاف التصنيف إلى الصفحة عبر قالب.',
	'inlinecategorizer-remove-category-summary' => 'إزالة التصنيف "$1"',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'inlinecategorizer-add-category' => 'ܐܘܣܦ ܣܕܪܐ',
	'inlinecategorizer-add-category-submit' => 'ܐܘܣܦ',
	'inlinecategorizer-confirm-save' => 'ܢܛܘܪ',
	'inlinecategorizer-error-title' => 'ܦܘܕܐ',
	'inlinecategorizer-remove-category-summary' => 'ܠܚܝ ܣܕܪܐ "$1"',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ramsis II
 */
$messages['arz'] = array(
	'inlinecategorizer-add-category' => 'ضيف تصنيف',
	'inlinecategorizer-add-category-submit' => 'ضيف',
	'inlinecategorizer-add-category-summary' => 'حط التصنيف "$1"',
	'inlinecategorizer-confirm-save' => 'سييف',
	'inlinecategorizer-confirm-title' => 'تأكيد العمليه',
	'inlinecategorizer-error-title' => 'غلط',
	'inlinecategorizer-remove-category-error' => 'مانفعش نشيل التصنيف دا.
دا بيحصل عادة لما التصنيف بيتحط فى الصفحه عن طريق القالب',
	'inlinecategorizer-remove-category-summary' => 'شيل التصنيف "$1"',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 * @author Gitartha.bordoloi
 */
$messages['as'] = array(
	'inlinecategorizer-add-category' => 'শ্ৰেণী সংযোগ কৰক',
	'inlinecategorizer-add-category-submit' => 'যোগ',
	'inlinecategorizer-add-category-summary' => 'শ্ৰেণী "$1" সংযোগ কৰক',
	'inlinecategorizer-api-error' => 'API-এ ত্ৰুটি দেখুৱাইছে: $1: $2 ।',
	'inlinecategorizer-api-unknown-error' => 'APIয়ে অজ্ঞাত ত্ৰুটি পঠিয়াইছে ।',
	'inlinecategorizer-cancel' => 'সম্পাদনা বাতিল কৰক',
	'inlinecategorizer-cancel-all' => 'সকলো সালসলনি বাতিল কৰক',
	'inlinecategorizer-category-already-present' => 'এই পৃষ্ঠাখন ইতিমধ্যে $1 শ্ৰেণীত আছে',
	'inlinecategorizer-category-hook-error' => 'এক স্থানীয় ফাংচনে সালসলনিবোৰ সাঁচি ৰখাত বাধা দিছে ।',
	'inlinecategorizer-category-question' => 'আপুনি তলৰ সালসলনিসমূহ কিয় কৰিবলৈ বিচাৰিছে:',
	'inlinecategorizer-confirm-ok' => "অ'কে",
	'inlinecategorizer-confirm-save' => 'সাঁচি থওক',
	'inlinecategorizer-confirm-save-all' => 'সকলো সালসলনি সাঁচি থওক',
	'inlinecategorizer-confirm-title' => 'কাৰ্য নিশ্চিত কৰক:',
	'inlinecategorizer-edit-category' => 'শ্ৰেণী সম্পাদনা কৰক',
	'inlinecategorizer-edit-category-error' => '"$1" শ্ৰেণীটো সম্পাদনা কৰা সম্ভৱ নহ\'ল ।
শ্ৰেনীটো সাঁচত ৰাখি পৃষ্ঠাত যোগ কৰিলে সাধাৰণতে এনে হয় ।',
	'inlinecategorizer-edit-category-summary' => '"$1" শ্ৰেণীক "$2" লৈ সলনি কৰক',
	'inlinecategorizer-error-title' => 'ভুল',
	'inlinecategorizer-remove-category' => 'শ্ৰেণী আঁতৰ কৰক',
	'inlinecategorizer-remove-category-error' => '"$1" শ্ৰেণীটো আঁতৰ কৰা সম্ভৱ নহ\'ল ।
শ্ৰেনীটো সাঁচত ৰাখি পৃষ্ঠাত যোগ কৰিলে সাধাৰণতে এনে হয় ।',
	'inlinecategorizer-remove-category-summary' => '"$1" শ্ৰেণীক আঁতৰ কৰক',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'inlinecategorizer-desc' => 'Módulu JavaScript que permite camudar, amestar y desaniciar enllaces de categoríes direutamente dende una páxina',
	'inlinecategorizer-add-category' => 'Amestar categoría',
	'inlinecategorizer-add-category-submit' => 'Amestar',
	'inlinecategorizer-add-category-summary' => 'Amestar la categoría "$1"',
	'inlinecategorizer-api-error' => 'La API devolvió un fallu: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'La API devolvió un fallu desconocíu.',
	'inlinecategorizer-cancel' => 'Encaboxar la edición',
	'inlinecategorizer-cancel-all' => 'Encaboxar tolos cambeos',
	'inlinecategorizer-category-already-present' => 'Esta páxina yá pertenez a la categoría "$1"',
	'inlinecategorizer-category-hook-error' => 'Una función llocal torgó que se guardaren los cambios',
	'inlinecategorizer-category-question' => 'Por qué quies facer los cambeos darréu:',
	'inlinecategorizer-confirm-ok' => 'Aceutar',
	'inlinecategorizer-confirm-save' => 'Guardar',
	'inlinecategorizer-confirm-save-all' => 'Guardar tolos cambeos',
	'inlinecategorizer-confirm-title' => "Confirmar l'aición",
	'inlinecategorizer-edit-category' => 'Editar categoría',
	'inlinecategorizer-edit-category-error' => 'Nun se pudo editar la categoría "$1".
Esto ocurre de vezu cuando la categoría s\'amestó a la páxina nuna plantía.',
	'inlinecategorizer-edit-category-summary' => 'Camudar la categoría "$1" a "$2"',
	'inlinecategorizer-error-title' => 'Error',
	'inlinecategorizer-remove-category' => 'Desaniciar categoría',
	'inlinecategorizer-remove-category-error' => 'Nun se pudo desaniciar la categoría "$1".
Esto ocurre de vezu cuando la categoría s\'amestó a la páxina nuna plantía.',
	'inlinecategorizer-remove-category-summary' => 'Desaniciar la categoría "$1"',
);

/** Azerbaijani (Azərbaycanca)
 * @author Gulmammad
 * @author Vugar 1981
 * @author Wertuose
 */
$messages['az'] = array(
	'inlinecategorizer-add-category' => 'Kateqoriya əlavə et',
	'inlinecategorizer-add-category-submit' => 'Əlavə et',
	'inlinecategorizer-add-category-summary' => '"$1" kateqoriyasını əlavə et',
	'inlinecategorizer-cancel' => 'Redaktəni ləğv et',
	'inlinecategorizer-cancel-all' => 'Bütün dəyişiklikləri ləğv et',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Qeyd et',
	'inlinecategorizer-confirm-save-all' => 'Bütün dəyişiklikləri yadda saxla',
	'inlinecategorizer-confirm-title' => 'Əməliyyatı təsdiq et',
	'inlinecategorizer-edit-category' => 'Kateqoriyanı redaktə et',
	'inlinecategorizer-error-title' => 'Xəta',
	'inlinecategorizer-remove-category' => 'Kateqoriyanı sil',
);

/** Bashkir (Башҡортса)
 * @author Рустам Нурыев
 */
$messages['ba'] = array(
	'inlinecategorizer-add-category-submit' => 'Өҫтәргә',
	'inlinecategorizer-add-category-summary' => 'Өҫтәлгән категориялар "$1"',
	'inlinecategorizer-confirm-save' => 'Һаҡларға',
	'inlinecategorizer-error-title' => 'Хата',
	'inlinecategorizer-remove-category-summary' => 'Категория «$1» юйылған',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'inlinecategorizer-error-title' => 'Feeler',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'inlinecategorizer-add-category-submit' => 'idúgang',
	'inlinecategorizer-confirm-save' => 'Itagáma',
	'inlinecategorizer-error-title' => 'Raót',
	'inlinecategorizer-remove-category-error' => 'Daí mahahálì iníng kategorya.
Nangyayári iní pag an kategorya ipigdúgang sa pahina sa saróng templato.',
);

/** Belarusian (Беларуская)
 * @author Yury Tarasievich
 */
$messages['be'] = array(
	'inlinecategorizer-add-category' => 'Дадаць катэгорыю',
	'inlinecategorizer-add-category-submit' => 'Дадаць',
	'inlinecategorizer-add-category-summary' => 'Дадаць катэгорыю "$1"',
	'inlinecategorizer-confirm-save' => 'Запісаць',
	'inlinecategorizer-confirm-title' => 'Пацверджанне',
	'inlinecategorizer-error-title' => 'Памылка',
	'inlinecategorizer-remove-category-error' => 'Не ўдалося сцерці катэгорыю.
Так звычайна бывае, калі катэгорыя дададзеная ў старонку праз шаблон.',
	'inlinecategorizer-remove-category-summary' => 'Сцерці катэгорыю "$1"',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'inlinecategorizer-desc' => 'Модуль JavaScript, які дазваляе рабіць зьмены, даданьні і выдаленьні спасылак на катэгорыі непасрэдна са старонкі',
	'inlinecategorizer-add-category' => 'Дадаць катэгорыю',
	'inlinecategorizer-add-category-submit' => 'Дадаць',
	'inlinecategorizer-add-category-summary' => 'Дададзеная катэгорыя «$1»',
	'inlinecategorizer-api-error' => 'API вярнуў памылку: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API вярнуў невядомую памылку.',
	'inlinecategorizer-cancel' => 'Скасаваць зьмены',
	'inlinecategorizer-cancel-all' => 'Скасаваць усе зьмены',
	'inlinecategorizer-category-already-present' => 'Гэтая старонка ўжо належыць катэгорыі $1',
	'inlinecategorizer-category-hook-error' => 'Лякальная функцыя перадухіліла захаваньне зьменаў',
	'inlinecategorizer-category-question' => 'Чаму Вы жадаеце зрабіць наступныя зьмены:',
	'inlinecategorizer-confirm-ok' => 'Добра',
	'inlinecategorizer-confirm-save' => 'Захаваць',
	'inlinecategorizer-confirm-save-all' => 'Захаваць усе зьмены',
	'inlinecategorizer-confirm-title' => 'Пацьвердзіць дзеяньне',
	'inlinecategorizer-edit-category' => 'Рэдагаваць катэгорыю',
	'inlinecategorizer-edit-category-error' => 'Немагчыма рэдагаваць катэгорыю «$1».
Звычайна падобная праблема ўзьнікае, калі катэгорыя была дададзеная на старонку праз шаблён.',
	'inlinecategorizer-edit-category-summary' => 'Зьмененая катэгорыя «$1» на «$2»',
	'inlinecategorizer-error-title' => 'Памылка',
	'inlinecategorizer-remove-category' => 'Выдаліць катэгорыю',
	'inlinecategorizer-remove-category-error' => 'Немагчыма выдаліць катэгорыю «$1».
Звычайна гэта здараецца, калі катэгорыя была дададзеная на старонку праз шаблён.',
	'inlinecategorizer-remove-category-summary' => 'Выдаленая катэгорыя «$1»',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'inlinecategorizer-add-category' => 'Добавяне на категория',
	'inlinecategorizer-add-category-submit' => 'Добавяне',
	'inlinecategorizer-add-category-summary' => 'Добавяне на категория „$1“',
	'inlinecategorizer-api-error' => 'API-то върна грешка: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API-то върна непозната грешка.',
	'inlinecategorizer-cancel' => 'Отказване на редакциите',
	'inlinecategorizer-cancel-all' => 'Отказване на всички промени',
	'inlinecategorizer-category-already-present' => 'Тази страница вече принадлежи към категорията $1',
	'inlinecategorizer-category-hook-error' => 'Локална функция предотврати записването на промените',
	'inlinecategorizer-category-question' => 'Какво налага следните промени:',
	'inlinecategorizer-confirm-ok' => 'Потвърждаване',
	'inlinecategorizer-confirm-save' => 'Съхраняване',
	'inlinecategorizer-confirm-save-all' => 'Съхраняване на всички промени',
	'inlinecategorizer-confirm-title' => 'Потвърждаване на действието',
	'inlinecategorizer-edit-category' => 'Редактиране на категория',
	'inlinecategorizer-edit-category-error' => 'Не е възможно редактирането на категория "$1".
Това често се случва, когато категорията е добавена в страницата чрез шаблон.',
	'inlinecategorizer-edit-category-summary' => 'Промяна на категорията "$1" на "$2"',
	'inlinecategorizer-error-title' => 'Грешка',
	'inlinecategorizer-remove-category' => 'Премахване на категория',
	'inlinecategorizer-remove-category-error' => 'Не може да бъде премахната категория "$1". 
Това обикновено се случва, когато категорията е била добавена в страницата индиректно чрез шаблон.',
	'inlinecategorizer-remove-category-summary' => 'Премахване на категория „$1“',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'inlinecategorizer-add-category' => 'বিষয়শ্রেণী যোগ',
	'inlinecategorizer-add-category-submit' => 'যোগ',
	'inlinecategorizer-add-category-summary' => '"$1" বিষয়শ্রেণী যোগ',
	'inlinecategorizer-confirm-save' => 'সংরক্ষণ',
	'inlinecategorizer-error-title' => 'ত্রুটি',
	'inlinecategorizer-remove-category-summary' => '"$1" বিষয়শ্রেণী অপসারণ',
);

/** Bishnupria Manipuri (ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী)
 * @author Usingha
 */
$messages['bpy'] = array(
	'inlinecategorizer-add-category' => 'বিষয়রথাক তিলকর',
	'inlinecategorizer-add-category-submit' => 'তিলকর',
	'inlinecategorizer-add-category-summary' => 'বিষয়থাক  "$1" থাক',
	'inlinecategorizer-confirm-save' => 'ইতুকর',
	'inlinecategorizer-confirm-title' => 'কামহান লেপকর',
	'inlinecategorizer-error-title' => 'লালুইসে',
	'inlinecategorizer-remove-category-error' => 'বিষয়রথাক এহান পুসানি নাইব।
এহান অরতা সাধারণত বিষয়রথাকহান পাতাহানর মডেলর মা মিহিলে।',
	'inlinecategorizer-remove-category-summary' => 'বিষয়থাক "$1" পুস',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'inlinecategorizer-add-category' => 'Ouzhpennañ ur rummad',
	'inlinecategorizer-add-category-submit' => 'Ouzhpennañ',
	'inlinecategorizer-add-category-summary' => 'Ouzhpennañ ar rummad "$1"',
	'inlinecategorizer-api-error' => 'Distroet ez eus ur fazi gant an API : $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'Distroet ez eus ur fazi dianav gant an API.',
	'inlinecategorizer-cancel' => "Nullañ ar c'hemmoù",
	'inlinecategorizer-cancel-all' => 'Nullañ an holl gemmoù',
	'inlinecategorizer-category-already-present' => 'Er rummad "$1" emañ ar bajenn-mañ c\'hoazh.',
	'inlinecategorizer-category-hook-error' => "Un arc'hwel lec'hel a vir ouzh ar c'hemmoù da vezañ enrollet.",
	'inlinecategorizer-category-question' => "Perak e fell deoc'h ober ar c'hemmoù da-heul :",
	'inlinecategorizer-confirm-ok' => 'Mat eo',
	'inlinecategorizer-confirm-save' => 'Enrollañ',
	'inlinecategorizer-confirm-save-all' => 'Enrollañ an holl gemmoù',
	'inlinecategorizer-confirm-title' => 'Kadarnaat an oberiadenn',
	'inlinecategorizer-edit-category' => 'Kemmañ ur rummad',
	'inlinecategorizer-edit-category-error' => 'N\'eus ket bet gallet degas kemmoù er rummad "$1". 
C\'hoarvezout a ra p\'eo bet ouzhpennet ar rummad er bajenn dre ur patrom',
	'inlinecategorizer-edit-category-summary' => 'Cheñch ar rummad eus "$1" da "$2"',
	'inlinecategorizer-error-title' => 'Fazi',
	'inlinecategorizer-remove-category' => 'Tennañ ar rummad kuit',
	'inlinecategorizer-remove-category-error' => 'N\'eus ket bet gallet diverkañ ar rummad "$1". 
C\'hoarvezout a ra p\'eo bet ouzhpennet ar rummad er bajenn dre ur patrom',
	'inlinecategorizer-remove-category-summary' => 'Diverkañ ar rummad "$1"',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'inlinecategorizer-add-category' => 'Dodaj kategoriju',
	'inlinecategorizer-add-category-submit' => 'Dodaj',
	'inlinecategorizer-add-category-summary' => 'Dodaj kategoriju "$1"',
	'inlinecategorizer-confirm-save' => 'Spremi',
	'inlinecategorizer-confirm-title' => 'Potvrdi akciju',
	'inlinecategorizer-error-title' => 'Greška',
	'inlinecategorizer-remove-category-error' => 'Nije bilo moguće ukloniti ovu kategoriju.
Ovo se obično dešava kada je kategorija dodana na stranicu preko šablona.',
	'inlinecategorizer-remove-category-summary' => 'Ukloni kategoriju "$1"',
);

/** Catalan (Català)
 * @author Ssola
 * @author Toniher
 */
$messages['ca'] = array(
	'inlinecategorizer-add-category' => 'Afegeix categoria',
	'inlinecategorizer-add-category-submit' => 'Afegeix',
	'inlinecategorizer-add-category-summary' => "Afageix la categoria ''$1''",
	'inlinecategorizer-confirm-save' => 'Desa',
	'inlinecategorizer-confirm-title' => "Confirma l'acció",
	'inlinecategorizer-error-title' => 'Error',
	'inlinecategorizer-remove-category-error' => "No ha estat possible eliminar aquesta categoria.
Això sol passar quan la categoria s'ha afegit a la pàgina en una plantilla.",
	'inlinecategorizer-remove-category-summary' => "Elimina la categoria ''$1''",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'inlinecategorizer-add-category' => 'Тlетоха кадегар',
	'inlinecategorizer-add-category-submit' => 'Тlетоха',
	'inlinecategorizer-add-category-summary' => 'Тlетоьхна кадегар «$1»',
	'inlinecategorizer-confirm-save' => 'lалашдан',
	'inlinecategorizer-confirm-title' => 'Тlечlагlде дийриг',
	'inlinecategorizer-error-title' => 'Гlалат',
	'inlinecategorizer-remove-category-summary' => 'ДIайакхина кадегар «$1»',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'inlinecategorizer-confirm-save' => 'پاشەکەوت',
);

/** Capiznon (Capiceño)
 * @author Oxyzen
 */
$messages['cps'] = array(
	'inlinecategorizer-add-category-summary' => 'Dugangan sang kategorya nga "$1"',
	'inlinecategorizer-confirm-save' => 'I-save',
	'inlinecategorizer-remove-category-summary' => 'Kwa-on ang kategorya nga  "$1"',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'inlinecategorizer-add-category' => 'Přidat kategorii',
	'inlinecategorizer-add-category-submit' => 'Přidat',
	'inlinecategorizer-add-category-summary' => 'Přidání kategorie „$1“',
	'inlinecategorizer-api-error' => 'API vrátilo chybu: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API vrátilo neznámou chybu.',
	'inlinecategorizer-cancel' => 'Stornovat změny',
	'inlinecategorizer-cancel-all' => 'Stornovat všechny změny',
	'inlinecategorizer-category-already-present' => 'Tato stránka již do kategorie $1 patří',
	'inlinecategorizer-category-hook-error' => 'Místní funkce zabránila uložení změn',
	'inlinecategorizer-category-question' => 'Proč chcete provést následující změny:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Uložit',
	'inlinecategorizer-confirm-save-all' => 'Uložit všechny změny',
	'inlinecategorizer-confirm-title' => 'Potvrdit změnu',
	'inlinecategorizer-edit-category' => 'Upravit kategorii',
	'inlinecategorizer-edit-category-error' => 'Nepodařilo se upravit kategorii „$1“.
To se obvykle stává v případě, že byla stránka do kategorie přidána prostřednictvím šablony.',
	'inlinecategorizer-edit-category-summary' => 'Změnit kategorii „$1“ na „$2“',
	'inlinecategorizer-error-title' => 'Chyba',
	'inlinecategorizer-remove-category' => 'Odebrat kategorii',
	'inlinecategorizer-remove-category-error' => 'Nepodařilo se odstranit kategorii „$1“.
To se obvykle stává v případě, že byla stránka do kategorie přidána prostřednictvím šablony.',
	'inlinecategorizer-remove-category-summary' => 'Odebrání kategorie „$1“',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'inlinecategorizer-desc' => "Modiwl JavaScript sy'n galluogi newid, ychwanegu a dileu cysylltiadau at gategorïau yn uniongyrchol o ryw dudalen",
	'inlinecategorizer-add-category' => 'Ychwanegu categori',
	'inlinecategorizer-add-category-submit' => 'Ychwanegu',
	'inlinecategorizer-add-category-summary' => 'Ychwanegu\'r categori "$1"',
	'inlinecategorizer-api-error' => 'Dychwelodd yr API wall: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'Dychwelodd yr API wall anhysbys.',
	'inlinecategorizer-cancel' => "Diddymu'r golygiadau",
	'inlinecategorizer-cancel-all' => 'Rhodder yr holl newidiadau heibio',
	'inlinecategorizer-category-already-present' => "Mae'r dudalen hon yn perthyn i'r categori $1 yn barod",
	'inlinecategorizer-category-hook-error' => 'Rhwystrodd ffwythiant lleol y newidiadau rhag cael eu rhoi ar gadw.',
	'inlinecategorizer-category-question' => "Pam ydych chi am wneud y newidiadau sy'n dilyn:",
	'inlinecategorizer-confirm-ok' => 'Iawn',
	'inlinecategorizer-confirm-save' => 'Cadwer',
	'inlinecategorizer-confirm-save-all' => 'Cadwer yr holl newidiadau',
	'inlinecategorizer-confirm-title' => "Cadarnhau'r weithred",
	'inlinecategorizer-edit-category' => "Golygu'r categori",
	'inlinecategorizer-edit-category-error' => 'Nid oedd modd golygu\'r categori "$1".
Mae hyn fel arfer yn golygu bod y categori wedi ei gynnwys yn y dudalen oddi mewn i nodyn.',
	'inlinecategorizer-edit-category-summary' => 'Newid y categori "$1" i "$2"',
	'inlinecategorizer-error-title' => 'Gwall',
	'inlinecategorizer-remove-category' => "Tynnu'r categori",
	'inlinecategorizer-remove-category-error' => 'Nid oedd yn bosibl tynnu\'r categori "$1" i ffwrdd.
Mae hyn fel arfer yn golygu bod y categori wedi ei gynnwys yn y dudalen oddi mewn i nodyn.',
	'inlinecategorizer-remove-category-summary' => 'Tynnu\'r categori "$1"',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Emilkris33
 * @author Peter Alberti
 */
$messages['da'] = array(
	'inlinecategorizer-add-category' => 'Tilføj kategori',
	'inlinecategorizer-add-category-submit' => 'Tilføj',
	'inlinecategorizer-add-category-summary' => 'Tilføj kategorien "$1"',
	'inlinecategorizer-api-error' => 'API gav en fejlbesked: $1: $2',
	'inlinecategorizer-api-unknown-error' => "API'en returnerede en ukendt fejl.",
	'inlinecategorizer-cancel' => 'Fortryd redigeringer',
	'inlinecategorizer-cancel-all' => 'Fortryd alle ændringer',
	'inlinecategorizer-category-already-present' => 'Denne side er allerede i kategorien $1',
	'inlinecategorizer-category-hook-error' => 'En lokal funktion forhindrede at ændringerne blev gemt',
	'inlinecategorizer-category-question' => 'Hvorfor ønsker du at foretage følgende ændringer:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Gem',
	'inlinecategorizer-confirm-save-all' => 'Gem alle ændringer',
	'inlinecategorizer-confirm-title' => 'Bekræft handling',
	'inlinecategorizer-edit-category' => 'Rediger kategori',
	'inlinecategorizer-edit-category-error' => 'Det var ikke muligt at redigere kategorien "$1".
Den mest almindelige grund til denne fejl er, at kategorien er blevet tilføjet til siden via en skabelon.',
	'inlinecategorizer-edit-category-summary' => 'Skift kategori "$1" til "$2"',
	'inlinecategorizer-error-title' => 'Fejl',
	'inlinecategorizer-remove-category' => 'Fjern kategori',
	'inlinecategorizer-remove-category-error' => 'Det var ikke muligt at fjerne kategorien "$1".
Det skyldes oftest at kategorien er blevet tilføjet til siden i en skabelon.',
	'inlinecategorizer-remove-category-summary' => 'Fjern kategorien "$1"',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 * @author Umherirrender
 */
$messages['de'] = array(
	'inlinecategorizer-desc' => 'Ermöglicht das direkte Hinzufügen, Ändern und Entfernen von Kategorien auf einer Wikiseite',
	'inlinecategorizer-add-category' => 'Kategorie hinzufügen',
	'inlinecategorizer-add-category-submit' => 'Hinzufügen',
	'inlinecategorizer-add-category-summary' => 'Kategorie „$1“ hinzufügen',
	'inlinecategorizer-api-error' => 'Die API hat einen Fehler zurückgegeben: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'Die API hat einen unbekannten Fehler ausgegeben.',
	'inlinecategorizer-cancel' => 'Bearbeitung abbrechen',
	'inlinecategorizer-cancel-all' => 'Alle Änderungen zurücknehmen',
	'inlinecategorizer-category-already-present' => 'Diese Seite gehört bereits zur Kategorie $1',
	'inlinecategorizer-category-hook-error' => 'Eine lokale Funktion verhindert, dass die Änderungen gespeichert werden',
	'inlinecategorizer-category-question' => 'Warum möchtest du die folgenden Änderungen durchführen:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Speichern',
	'inlinecategorizer-confirm-save-all' => 'Alle Änderungen speichern',
	'inlinecategorizer-confirm-title' => 'Aktion bestätigen',
	'inlinecategorizer-edit-category' => 'Kategorie bearbeiten',
	'inlinecategorizer-edit-category-error' => 'Es war nicht möglich, die Kategorie „$1“ zu bearbeiten.
Dies passiert normalerweise, wenn die Kategorie zur Seite in einer Vorlage hinzugefügt wurde.',
	'inlinecategorizer-edit-category-summary' => 'Kategorie „$1“ zu „$2“ ändern.',
	'inlinecategorizer-error-title' => 'Fehler',
	'inlinecategorizer-remove-category' => 'Kategorie entfernen',
	'inlinecategorizer-remove-category-error' => 'Es war nicht möglich, die Kategorie „$1“ zu entfernen.
Dies passiert normalerweise, wenn die Kategorie über eine Vorlage eingebunden ist.',
	'inlinecategorizer-remove-category-summary' => 'Kategorie „$1“ entfernen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'inlinecategorizer-category-question' => 'Warum möchten Sie die folgenden Änderungen durchführen:',
);

/** Zazaki (Zazaki)
 * @author Xoser
 */
$messages['diq'] = array(
	'inlinecategorizer-add-category' => 'Kategorî de bike',
	'inlinecategorizer-add-category-submit' => 'De bike',
	'inlinecategorizer-add-category-summary' => 'Kategorî de bike "$1"',
	'inlinecategorizer-confirm-save' => 'Qeyt bik',
	'inlinecategorizer-confirm-title' => 'Hereketî konfirme bike',
	'inlinecategorizer-error-title' => 'Xeta',
	'inlinecategorizer-remove-category-error' => 'Ma nieşkenî ena kategorî wedarne.
Çi wext yew kategorî yew template de ca geno, ena probelem bena.',
	'inlinecategorizer-remove-category-summary' => 'kategoriyê "$1"i biwedarne',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'inlinecategorizer-add-category' => 'Kategoriju pśidaś',
	'inlinecategorizer-add-category-submit' => 'Pśidaś',
	'inlinecategorizer-add-category-summary' => 'Kategoriju "$1" pśidaś',
	'inlinecategorizer-confirm-save' => 'Składowaś',
	'inlinecategorizer-confirm-title' => 'Akciju wobkšuśiś',
	'inlinecategorizer-error-title' => 'Zmólka',
	'inlinecategorizer-remove-category-error' => 'Njejo móžno było kategoriju "$1" wótpóraś.
To se zwětšego stawa, gaž kategorija jo se pśidała bokoju w pśedłoze.',
	'inlinecategorizer-remove-category-summary' => 'Kategoriju "$1" wótpóraś',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Kiolalis
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'inlinecategorizer-add-category' => 'Προσθήκη κατηγορίας',
	'inlinecategorizer-add-category-submit' => 'Προσθήκη',
	'inlinecategorizer-add-category-summary' => 'Προσθήκη κατηγορίας "$1"',
	'inlinecategorizer-api-error' => 'Το API επέστρεψε ένα σφάλμα:  $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'Το API επέστρεψε ένα άγνωστο σφάλμα.',
	'inlinecategorizer-cancel' => 'Ακύρωση επεξεργασίας',
	'inlinecategorizer-cancel-all' => 'Ακύρωση όλων των αλλαγών',
	'inlinecategorizer-category-already-present' => 'Η σελίδα αυτή ανήκει ήδη στην κατηγορία "$1"',
	'inlinecategorizer-category-hook-error' => 'Μια τοπική λειτουργία απέτρεψε την αποθήκευση των αλλαγών.',
	'inlinecategorizer-category-question' => 'Γιατί θέλετε να κάνετε τις ακόλουθες αλλαγές:',
	'inlinecategorizer-confirm-ok' => 'Εντάξει',
	'inlinecategorizer-confirm-save' => 'Αποθήκευση',
	'inlinecategorizer-confirm-save-all' => 'Αποθήκευση όλων των αλλαγών',
	'inlinecategorizer-confirm-title' => 'Επιβεβαίωση ενέργειας',
	'inlinecategorizer-edit-category' => 'Επεξεργασία κατηγορίας',
	'inlinecategorizer-edit-category-error' => 'Δεν ήταν δυνατή η επεξεργασία της κατηγορίας "$1".
Αυτό συμβαίνει συνήθως όταν η κατηγορία έχει προστεθεί στη σελίδα σε ένα πρότυπο.',
	'inlinecategorizer-edit-category-summary' => 'Αλλαγή κατηγορίας από "$1" σε "$2"',
	'inlinecategorizer-error-title' => 'Σφάλμα',
	'inlinecategorizer-remove-category' => 'Αφαίρεση κατηγορίας',
	'inlinecategorizer-remove-category-error' => 'Δεν ήταν δυνατή η αφαίρεση να αφαιρεθεί η κατηγορία "$1".
Αυτό συνήθως συμβαίνει όταν η κατηγορία έχει προστεθεί στη σελίδα από ένα πρότυπο.',
	'inlinecategorizer-remove-category-summary' => 'Αφαίρεση κατηγορίας "$1"',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'inlinecategorizer-add-category' => 'Aldoni kategorion',
	'inlinecategorizer-add-category-submit' => 'Aldoni',
	'inlinecategorizer-add-category-summary' => 'Aldoni kategorion "$1"',
	'inlinecategorizer-api-error' => 'La API raportis la eraron: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'La API raportis nekonatan eraron.',
	'inlinecategorizer-cancel' => 'Nuligi redakton',
	'inlinecategorizer-cancel-all' => 'Nuligi ĉiujn ŝanĝojn',
	'inlinecategorizer-category-already-present' => 'Ĉi tiu paĝo jam apartenas al la kategorio "$1"',
	'inlinecategorizer-category-hook-error' => 'Loka funkcio preventis konservadon de la ŝanĝoj.',
	'inlinecategorizer-category-question' => 'Kial vi volas fari la jenajn ŝanĝojn:',
	'inlinecategorizer-confirm-ok' => 'Ek!',
	'inlinecategorizer-confirm-save' => 'Konservi',
	'inlinecategorizer-confirm-save-all' => 'Konservi ĉiujn ŝanĝojn',
	'inlinecategorizer-confirm-title' => 'Konfirmi agon',
	'inlinecategorizer-edit-category' => 'Redakti kategorion',
	'inlinecategorizer-edit-category-error' => 'Ne eblas redakti kategorion "$1".
Ĉi tiel okazas kiam la kategorio estis aldonita al la paĝo per ŝablono.',
	'inlinecategorizer-edit-category-summary' => 'Ŝanĝi kategorion "$1" al "$2"',
	'inlinecategorizer-error-title' => 'Eraro',
	'inlinecategorizer-remove-category' => 'Forigi kategorion',
	'inlinecategorizer-remove-category-error' => 'Ne eblas forigi kategorion "$1".
Ĉi tiel okazas kiam la kategorio estis aldonita al la paĝo per ŝablono.',
	'inlinecategorizer-remove-category-summary' => 'Forigi kategorion "$1"',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Fitoschido
 * @author Manuelt15
 */
$messages['es'] = array(
	'inlinecategorizer-add-category' => 'Agregar categoría',
	'inlinecategorizer-add-category-submit' => 'Agregar',
	'inlinecategorizer-add-category-summary' => 'Añadir categoría «$1»',
	'inlinecategorizer-api-error' => 'La API ha devuelto un error:  $1 :  $2 .',
	'inlinecategorizer-api-unknown-error' => 'La API ha devuelto un error desconocido.',
	'inlinecategorizer-cancel' => 'Cancelar edición',
	'inlinecategorizer-cancel-all' => 'Cancelar todos los cambios',
	'inlinecategorizer-category-already-present' => 'Esta página ya pertenece a la categoría «$1»',
	'inlinecategorizer-category-hook-error' => 'Una función local impide que se guarden los cambios',
	'inlinecategorizer-category-question' => 'Por qué deseas realizar los siguientes cambios:',
	'inlinecategorizer-confirm-ok' => 'Aceptar',
	'inlinecategorizer-confirm-save' => 'Guardar',
	'inlinecategorizer-confirm-save-all' => 'Guardar todos los cambios',
	'inlinecategorizer-confirm-title' => 'Confirmar acción',
	'inlinecategorizer-edit-category' => 'Editar categoría',
	'inlinecategorizer-edit-category-error' => 'No fue posible editar la categoría «$1».
Esto suele ocurrir cuando la categoría se añadió a la página por una plantilla.',
	'inlinecategorizer-edit-category-summary' => 'Cambiar la categoría «$1» a «$2»',
	'inlinecategorizer-error-title' => 'Error',
	'inlinecategorizer-remove-category' => 'Quitar categoría',
	'inlinecategorizer-remove-category-error' => 'No fue posible quitar la categoría «$1».
Esto suele ocurrir cuando la categoría se añadió a la página por una plantilla.',
	'inlinecategorizer-remove-category-summary' => 'Quitar categoría «$1»',
);

/** Estonian (Eesti)
 * @author Oop
 * @author Pikne
 */
$messages['et'] = array(
	'inlinecategorizer-add-category' => 'Lisa kategooria',
	'inlinecategorizer-add-category-submit' => 'Lisa',
	'inlinecategorizer-add-category-summary' => 'Kategooria "$1" lisamine',
	'inlinecategorizer-api-error' => 'Rakendus andis veateate: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'Rakendus andis tundmatu veateate.',
	'inlinecategorizer-cancel' => 'Loobu muudatusest',
	'inlinecategorizer-cancel-all' => 'Loobu kõigist muudatustest',
	'inlinecategorizer-category-already-present' => 'See lehekülg on juba kategoorias $1.',
	'inlinecategorizer-category-question' => 'Miks tahad teha järgmisi muudatusi:',
	'inlinecategorizer-confirm-ok' => 'Sobib',
	'inlinecategorizer-confirm-save' => 'Salvesta',
	'inlinecategorizer-confirm-save-all' => 'Salvesta kõik muudatused',
	'inlinecategorizer-confirm-title' => 'Toimingu kinnitamine',
	'inlinecategorizer-edit-category' => 'Muuda kategooriat',
	'inlinecategorizer-edit-category-error' => 'Kategooriat "$1" pole võimalik muuta.
Harilikult juhtub nii, kui kategooria on lisatud malliga.',
	'inlinecategorizer-edit-category-summary' => 'Kategooria "$1" asendamine kategooriaga "$2"',
	'inlinecategorizer-error-title' => 'Tõrge',
	'inlinecategorizer-remove-category' => 'Eemalda kategooria',
	'inlinecategorizer-remove-category-error' => 'Kategooriat "$1" pole võimalik eemaldada.
Tõrge ilmneb harilikult siis, kui kategooria on lisatud malliga.',
	'inlinecategorizer-remove-category-summary' => 'Kategooria "$1" eemaldamine',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Unai Fdz. de Betoño
 */
$messages['eu'] = array(
	'inlinecategorizer-add-category' => 'Kategoria gehitu',
	'inlinecategorizer-add-category-submit' => 'Gehitu',
	'inlinecategorizer-add-category-summary' => '"$1" kategoria gehitu',
	'inlinecategorizer-confirm-save' => 'Gorde',
	'inlinecategorizer-confirm-title' => 'Ekintza egiaztatu',
	'inlinecategorizer-error-title' => 'Errorea',
	'inlinecategorizer-remove-category-error' => 'Ezin izan da kategoria ezabatu.
Arrazoia izan ohi da kategoria hori txantiloi batek erantsi diola orrialdera.',
	'inlinecategorizer-remove-category-summary' => '"$1" kategoria ezabatu',
);

/** Persian (فارسی)
 * @author Armandaneshjoo
 * @author Huji
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'inlinecategorizer-desc' => 'ماژول جاوااسکریپت که تغییر، افزودن و حذف‌کردن رده‌ها را مستقیماً از صفحه ممکن می‌کند',
	'inlinecategorizer-add-category' => 'افزودن رده',
	'inlinecategorizer-add-category-submit' => 'افزودن',
	'inlinecategorizer-add-category-summary' => 'افزودن رده «$1»',
	'inlinecategorizer-api-error' => 'API خطایی بازگرداند: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API یک خطای ناشناخته بازگرداند.',
	'inlinecategorizer-cancel' => 'لغو ویرایش‌ها',
	'inlinecategorizer-cancel-all' => 'لغو همه تغییرات',
	'inlinecategorizer-category-already-present' => 'این صحفه از قبل در رده $1 قرار دارد',
	'inlinecategorizer-category-hook-error' => 'یک تابع محلی از ذخیره تغییرات جلوگیری کرد.',
	'inlinecategorizer-category-question' => 'چرا می خواهید تغییرات زیر را ایجاد کنید:',
	'inlinecategorizer-confirm-ok' => 'تأیید',
	'inlinecategorizer-confirm-save' => 'ذخیره',
	'inlinecategorizer-confirm-save-all' => 'ذخیره کردن تمام تغییرات',
	'inlinecategorizer-confirm-title' => 'تأیید عمل',
	'inlinecategorizer-edit-category' => 'ویرایش رده',
	'inlinecategorizer-edit-category-error' => 'امکان ویرایش رده «$1» وجود نداشت.
این اتفاق معمولاً زمانی می‌افتد که رده از طریق یک الگو به صفحه اضافه شده باشد.',
	'inlinecategorizer-edit-category-summary' => 'تغییر رده «$1» به «$2»',
	'inlinecategorizer-error-title' => 'خطا',
	'inlinecategorizer-remove-category' => 'حذف رده',
	'inlinecategorizer-remove-category-error' => 'امکان حذف رده «$1» وجود نداشت.
این اتفاق معمولاً زمانی می‌افتد که رده از طریق یک الگو به صفحه اضافه شده باشد.',
	'inlinecategorizer-remove-category-summary' => 'حذف رده «$1»',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Olli
 * @author Silvonen
 */
$messages['fi'] = array(
	'inlinecategorizer-add-category' => 'Lisää luokka',
	'inlinecategorizer-add-category-submit' => 'Lisää',
	'inlinecategorizer-add-category-summary' => 'Lisää luokka ”$1”',
	'inlinecategorizer-api-error' => 'API palautti virheen: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API palautti tuntemattoman virheen.',
	'inlinecategorizer-cancel' => 'Peruuta muutokset',
	'inlinecategorizer-cancel-all' => 'Peruuta kaikki muutokset',
	'inlinecategorizer-category-already-present' => 'Tämä sivu kuuluu jo ennestään luokkaan $1',
	'inlinecategorizer-category-hook-error' => 'Paikallinen toiminto esti muutosten tallentamisen.',
	'inlinecategorizer-category-question' => 'Miksi haluat tehdä seuraavat muutokset:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Tallenna',
	'inlinecategorizer-confirm-save-all' => 'Tallenna kaikki muutokset',
	'inlinecategorizer-confirm-title' => 'Vahvista toiminto',
	'inlinecategorizer-edit-category' => 'Muokkaa luokkaa',
	'inlinecategorizer-edit-category-error' => 'Luokan $1 muokkaaminen ei onnistunut.
Yleensä näin käy, kun luokka on lisätty sivulle mallineen avulla.',
	'inlinecategorizer-edit-category-summary' => 'Luokka $1 muutetaan luokaksi $2',
	'inlinecategorizer-error-title' => 'Virhe',
	'inlinecategorizer-remove-category' => 'Poista luokka',
	'inlinecategorizer-remove-category-error' => 'Luokan $1 poistaminen ei onnistunut.
Yleensä näin käy, kun luokka on lisätty sivulle mallineen avulla.',
	'inlinecategorizer-remove-category-summary' => 'Luokan ”$1” poisto',
);

/** French (Français)
 * @author Gomoko
 * @author Hashar
 * @author Houcinee1
 * @author Jens Liebenau
 * @author Od1n
 * @author PieRRoMaN
 * @author Seb35
 */
$messages['fr'] = array(
	'inlinecategorizer-desc' => 'Module JavaScript qui permet de modifier, ajouter et supprimer des liens de catégorie directement depuis une page',
	'inlinecategorizer-add-category' => 'Ajouter une catégorie',
	'inlinecategorizer-add-category-submit' => 'Ajouter',
	'inlinecategorizer-add-category-summary' => 'Ajouter la catégorie « $1 »',
	'inlinecategorizer-api-error' => 'L’API a retourné une erreur : $1 : $2',
	'inlinecategorizer-api-unknown-error' => "L'API a retourné une erreur inconnue",
	'inlinecategorizer-cancel' => 'Annuler les modifications',
	'inlinecategorizer-cancel-all' => 'Annuler tous les changements',
	'inlinecategorizer-category-already-present' => 'Cette page appartient déjà à la catégorie $1',
	'inlinecategorizer-category-hook-error' => 'Une fonction locale a empêché d’enregistrer les changements',
	'inlinecategorizer-category-question' => 'Pourquoi voulez-vous faire les changements suivants :',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Publier',
	'inlinecategorizer-confirm-save-all' => 'Enregistrer toutes les modifications',
	'inlinecategorizer-confirm-title' => 'Confirmer l’action',
	'inlinecategorizer-edit-category' => 'Modifier une catégorie',
	'inlinecategorizer-edit-category-error' => 'Il n’a pas été possible de modifier la catégorie « $1 ».
Cela se produit généralement lorsque la catégorie a été ajoutée à la page via un modèle.',
	'inlinecategorizer-edit-category-summary' => 'Changer la catégorie « $1 » vers « $2 »',
	'inlinecategorizer-error-title' => 'Erreur',
	'inlinecategorizer-remove-category' => 'Supprimer la catégorie',
	'inlinecategorizer-remove-category-error' => 'Il n’a pas été possible de retirer la catégorie « $1 ».
Cela se produit généralement lorsque la catégorie a été ajoutée à la page via un modèle.',
	'inlinecategorizer-remove-category-summary' => 'Enlever la catégorie « $1 »',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'inlinecategorizer-add-category' => 'Apondre una catègorie',
	'inlinecategorizer-add-category-submit' => 'Apondre',
	'inlinecategorizer-add-category-summary' => 'Apondre la catègorie « $1 »',
	'inlinecategorizer-api-error' => 'L’API at retornâ una èrror : $1 : $2',
	'inlinecategorizer-api-unknown-error' => 'L’API at retornâ una èrror encognua',
	'inlinecategorizer-cancel' => 'Anular des changements',
	'inlinecategorizer-cancel-all' => 'Anular tôs los changements',
	'inlinecategorizer-category-already-present' => 'Ceta pâge est ja a la catègorie $1',
	'inlinecategorizer-category-hook-error' => 'Una fonccion locala at empachiê d’encartar los changements',
	'inlinecategorizer-category-question' => 'Porquè voléd-vos fâre cetos changements :',
	'inlinecategorizer-confirm-ok' => 'D’acôrd',
	'inlinecategorizer-confirm-save' => 'Sôvar',
	'inlinecategorizer-confirm-save-all' => 'Encartar tôs los changements',
	'inlinecategorizer-confirm-title' => 'Confirmar l’accion',
	'inlinecategorizer-edit-category' => 'Changiér la catègorie',
	'inlinecategorizer-edit-category-error' => 'O at pas étâ possiblo de changiér la catègorie « $1 ».
En g·ènèral, cen arreve quand la catègorie at étâ apondua a la pâge dens un modèlo.',
	'inlinecategorizer-edit-category-summary' => 'Changiér la catègorie « $1 » a « $2 »',
	'inlinecategorizer-error-title' => 'Èrror',
	'inlinecategorizer-remove-category' => 'Enlevar la catègorie',
	'inlinecategorizer-remove-category-error' => 'O at pas étâ possiblo d’enlevar la catègorie « $1 ».
En g·ènèral, cen arreve quand la catègorie at étâ apondua a la pâge avouéc un modèlo.',
	'inlinecategorizer-remove-category-summary' => 'Enlevar la catègorie « $1 »',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'inlinecategorizer-add-category' => 'Zonte categorie',
	'inlinecategorizer-add-category-submit' => 'Zonte',
	'inlinecategorizer-add-category-summary' => "Zonte la categorie ''$1''",
	'inlinecategorizer-confirm-save' => 'Salve',
	'inlinecategorizer-confirm-title' => "Conferme l'azion",
	'inlinecategorizer-error-title' => 'Erôr',
	'inlinecategorizer-remove-category-summary' => "Gjave la categorie ''$1''",
);

/** Irish (Gaeilge)
 * @author Kwekubo
 */
$messages['ga'] = array(
	'inlinecategorizer-confirm-save' => 'Sábháil',
);

/** Simplified Gan script (‪赣语(简体)‬) */
$messages['gan-hans'] = array(
	'inlinecategorizer-add-category-summary' => '添进分类「$1」',
	'inlinecategorizer-confirm-save' => '存到',
	'inlinecategorizer-error-title' => '错误',
	'inlinecategorizer-remove-category-error' => '搦个只分类不开。
通常发生嘚一只拕包入分类𠮶模板。',
	'inlinecategorizer-remove-category-summary' => '搦开分类「$1」',
);

/** Traditional Gan script (‪贛語(繁體)‬)
 * @author Symane
 */
$messages['gan-hant'] = array(
	'inlinecategorizer-add-category-summary' => '添進分類「$1」',
	'inlinecategorizer-confirm-save' => '存到',
	'inlinecategorizer-error-title' => '錯誤',
	'inlinecategorizer-remove-category-error' => '搦箇隻分類不開。
通常發生嘚一隻拕包入分類嗰模板。',
	'inlinecategorizer-remove-category-summary' => '搦開分類「$1」',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'inlinecategorizer-desc' => 'Módulo JavaScript que permite cambiar, engadir e eliminar categorías directamente nunha páxina',
	'inlinecategorizer-add-category' => 'Engadir unha categoría',
	'inlinecategorizer-add-category-submit' => 'Engadir',
	'inlinecategorizer-add-category-summary' => 'Engadir a categoría "$1"',
	'inlinecategorizer-api-error' => 'A API devolveu un erro: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'A API devolveu un erro descoñecido.',
	'inlinecategorizer-cancel' => 'Cancelar a edición',
	'inlinecategorizer-cancel-all' => 'Rexeitar todos os cambios',
	'inlinecategorizer-category-already-present' => 'Esta páxina xa pertence á categoría "$1"',
	'inlinecategorizer-category-hook-error' => 'Unha función local impediu que se gardasen os cambios.',
	'inlinecategorizer-category-question' => 'Por que quere facer as seguintes modificacións?:',
	'inlinecategorizer-confirm-ok' => 'Aceptar',
	'inlinecategorizer-confirm-save' => 'Gardar',
	'inlinecategorizer-confirm-save-all' => 'Gardar todos os cambios',
	'inlinecategorizer-confirm-title' => 'Confirmar a acción',
	'inlinecategorizer-edit-category' => 'Editar a categoría',
	'inlinecategorizer-edit-category-error' => 'Non se puido editar a categoría "$1".
Isto ocorre xeralmente cando a páxina está incluída na categoría a través dun modelo.',
	'inlinecategorizer-edit-category-summary' => 'Cambiar a categoría "$1" por "$2"',
	'inlinecategorizer-error-title' => 'Erro',
	'inlinecategorizer-remove-category' => 'Eliminar a categoría',
	'inlinecategorizer-remove-category-error' => 'Non se puido eliminar a categoría "$1".
Isto ocorre xeralmente cando a páxina está incluída na categoría a través dun modelo.',
	'inlinecategorizer-remove-category-summary' => 'Eliminar a categoría "$1"',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'inlinecategorizer-add-category' => 'Προστιθέναι κατηγορίαν',
	'inlinecategorizer-add-category-submit' => 'Προστιθέναι',
	'inlinecategorizer-add-category-summary' => 'Προστιθέναι κατηγορίαν "$1"',
	'inlinecategorizer-confirm-ok' => 'εἶεν',
	'inlinecategorizer-confirm-save' => 'Γράφειν',
	'inlinecategorizer-confirm-title' => 'Καταβεβαιοῦν δρᾶσιν',
	'inlinecategorizer-error-title' => 'Σφάλμα',
	'inlinecategorizer-remove-category-summary' => 'Ἀφαιρεῖν κατηγορίαν "$1"',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'inlinecategorizer-desc' => 'E JavaScript Modul, wo s mögli macht, Kategorilinks diräkt vunere Syte dezuezfiege, z ändre oder usseznee',
	'inlinecategorizer-add-category' => 'Kategorii zuefiege',
	'inlinecategorizer-add-category-submit' => 'Zuefiege',
	'inlinecategorizer-add-category-summary' => 'Kategorii „$1“ zuefiege',
	'inlinecategorizer-api-error' => 'D API het en Fääler gmolde: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'D API het en unbekannte Fääler gmolde.',
	'inlinecategorizer-cancel' => 'Bearbeitig abbräche',
	'inlinecategorizer-cancel-all' => 'Alli Änderige abbräche',
	'inlinecategorizer-category-already-present' => 'Die Syte ghört zur Kategori $1',
	'inlinecategorizer-category-hook-error' => 'E lokali Funktion verhindret, dass d Änderige gspyycheret werde',
	'inlinecategorizer-category-question' => 'Worum wottsch die Änderige mache:',
	'inlinecategorizer-confirm-ok' => 'In Ornig',
	'inlinecategorizer-confirm-save' => 'Spychere',
	'inlinecategorizer-confirm-save-all' => 'Alli Änderige spychere',
	'inlinecategorizer-confirm-title' => 'Aktion bstetige',
	'inlinecategorizer-edit-category' => 'Kategorie ändere',
	'inlinecategorizer-edit-category-error' => 'Es isch nit mögli gsi, d Kategori „$1“ z bearbeite.
Normalerwys passiert des, wänn d Kategori zur Syte vunere Vorlag dezuegfiegt worde isch.',
	'inlinecategorizer-edit-category-summary' => 'Kategori „$1“ zu „$2“ ändre.',
	'inlinecategorizer-error-title' => 'Fähler',
	'inlinecategorizer-remove-category' => 'Kategorii uuseneh',
	'inlinecategorizer-remove-category-error' => 'S isch nit megli gsi, d Kategorii „$1“ uusezneh. Normalerwys git s des, wänn d Kategorii iber e Vorlag yybunden isch.',
	'inlinecategorizer-remove-category-summary' => 'Kategorii „$1“ uuseneh',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'inlinecategorizer-desc' => 'מודול JavaScript שמפעיל שינוי, הוספה והסרה של קישורי קטגורי בתוך הדף',
	'inlinecategorizer-add-category' => 'הוספת קטגוריה',
	'inlinecategorizer-add-category-submit' => 'הוספה',
	'inlinecategorizer-add-category-summary' => 'הוספת הקטגוריה "$1"',
	'inlinecategorizer-api-error' => 'ה־API החזיר שגיאה: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'ה־API החזיר שגיאה לא ידועה.',
	'inlinecategorizer-cancel' => 'ביטול העריכה',
	'inlinecategorizer-cancel-all' => 'ביטול כל השינויים',
	'inlinecategorizer-category-already-present' => 'דף זה כבר שייך לקטגוריה $1',
	'inlinecategorizer-category-hook-error' => 'פונקציה מקומית מנעה את שמירת השינויים',
	'inlinecategorizer-category-question' => 'הסיבה לשינויים המוצגים להלן:',
	'inlinecategorizer-confirm-ok' => 'אישור',
	'inlinecategorizer-confirm-save' => 'שמירה',
	'inlinecategorizer-confirm-save-all' => 'שמירת כל השינויים',
	'inlinecategorizer-confirm-title' => 'אישור הפעולה',
	'inlinecategorizer-edit-category' => 'עריכת קטגוריה',
	'inlinecategorizer-edit-category-error' => 'לא ניתן היה את הקטגוריה "$1".
הסיבה לכך היא בדרך כלל שהקטגוריה נוספה לדף בתוך תבנית.',
	'inlinecategorizer-edit-category-summary' => 'שינוי הקטגוריה "$1" ל"$2"',
	'inlinecategorizer-error-title' => 'שגיאה',
	'inlinecategorizer-remove-category' => 'הסרת קטגוריה',
	'inlinecategorizer-remove-category-error' => 'לא ניתן היה להסיר את הקטגוריה "$1".
הסיבה לכך היא בדרך כלל שהקטגוריה נוספה לדף בתוך תבנית.',
	'inlinecategorizer-remove-category-summary' => 'הסרת הקטגוריה "$1"',
);

/** Hindi (हिन्दी)
 * @author आलोक
 */
$messages['hi'] = array(
	'inlinecategorizer-add-category' => 'श्रेणी जोड़ें',
	'inlinecategorizer-add-category-submit' => 'जोड़ें',
	'inlinecategorizer-add-category-summary' => 'श्रेणी "$1" जोड़ें',
	'inlinecategorizer-confirm-save' => 'सँजोएँ',
	'inlinecategorizer-confirm-title' => 'क्रिया की पुष्टि करें',
	'inlinecategorizer-error-title' => 'त्रुटि',
	'inlinecategorizer-remove-category-error' => 'यह श्रेणी हटाई नहीं जा सकी।
यह आमतौर पर तब होता है जब श्रेणी किसी साँचे के जरिए जोड़ी गई हो।',
	'inlinecategorizer-remove-category-summary' => 'श्रेणी "$1" हटाएँ',
);

/** Fiji Hindi (Latin script) (Fiji Hindi)
 * @author Girmitya
 * @author Thakurji
 */
$messages['hif-latn'] = array(
	'inlinecategorizer-add-category' => 'Vibhag jorro',
	'inlinecategorizer-add-category-submit' => 'Jorro',
	'inlinecategorizer-add-category-summary' => 'Vibhag "$1" ke jorro',
	'inlinecategorizer-confirm-save' => 'Bachao',
	'inlinecategorizer-error-title' => 'Galti',
	'inlinecategorizer-remove-category-summary' => 'Vibhag "$1" ke hatao',
);

/** Croatian (Hrvatski)
 * @author Ex13
 * @author Tivek
 */
$messages['hr'] = array(
	'inlinecategorizer-add-category' => 'Dodaj kategoriju',
	'inlinecategorizer-add-category-submit' => 'Dodaj',
	'inlinecategorizer-add-category-summary' => 'Dodaj kategoriju "$1"',
	'inlinecategorizer-api-error' => 'API je vratio pogrešku: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API je vratio nepoznatu pogrešku.',
	'inlinecategorizer-cancel' => 'Odustani od uređivanja',
	'inlinecategorizer-cancel-all' => 'Odustani od svih promjena',
	'inlinecategorizer-category-already-present' => 'Ova stranica već spada u kategoriju "$1"',
	'inlinecategorizer-category-hook-error' => 'Lokalna funkcija je spriječila spremanje promjena.',
	'inlinecategorizer-category-question' => 'Zašto želite sljedeće promjene:',
	'inlinecategorizer-confirm-ok' => 'U redu',
	'inlinecategorizer-confirm-save' => 'Spremi',
	'inlinecategorizer-confirm-save-all' => 'Sačuvaj sve promjene',
	'inlinecategorizer-confirm-title' => 'Potvrdi radnju',
	'inlinecategorizer-edit-category-error' => 'Nije bilo moguće urediti kategoriju "$1".
Ovo se obično događa kada je kategorija na stranicu dodana u predlošku.',
	'inlinecategorizer-edit-category-summary' => 'Promijeni kategoriju "$1" u "$2"',
	'inlinecategorizer-error-title' => 'Greška',
	'inlinecategorizer-remove-category-error' => 'Nije bilo moguće ukloniti kategoriju "$1".
Ovo se obično događa kada je kategorija na stranicu dodana u predlošku.',
	'inlinecategorizer-remove-category-summary' => 'Ukloni kategoriju "$1"',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'inlinecategorizer-desc' => 'JavaScriptowy modul, kotryž měnjenje, přidawanje a wotstronjenje kategorijow direktnje na stronje zmóžnja.',
	'inlinecategorizer-add-category' => 'Kategoriju přidać',
	'inlinecategorizer-add-category-submit' => 'Přidać',
	'inlinecategorizer-add-category-summary' => 'Kategoriju "$1" přidać',
	'inlinecategorizer-api-error' => 'API je zmylk wróćił: $1, $2.',
	'inlinecategorizer-api-unknown-error' => 'API je njeznaty zmylk wróćił.',
	'inlinecategorizer-cancel' => 'Změny anulować',
	'inlinecategorizer-cancel-all' => 'Wšě změny přetorhnyć',
	'inlinecategorizer-category-already-present' => 'Tuta strona hižo ke kategoriji $1 słuša',
	'inlinecategorizer-category-hook-error' => 'Lokalna funkcija zadźěwaše składowanju změnow.',
	'inlinecategorizer-category-question' => 'Čehodla chceš slědowace změny přewjesć:',
	'inlinecategorizer-confirm-ok' => 'W porjadku',
	'inlinecategorizer-confirm-save' => 'Składować',
	'inlinecategorizer-confirm-save-all' => 'Wšě změny składować',
	'inlinecategorizer-confirm-title' => 'Akciju wobkrućić',
	'inlinecategorizer-edit-category' => 'Kategoriju wobdźěłać',
	'inlinecategorizer-edit-category-error' => 'Njebě móžno kategoriju "$1" wobdźěłać.
To so zwjetša stawa, hdyž kategorija je so stronje w předłoze přidała.',
	'inlinecategorizer-edit-category-summary' => 'Kategoriju "$1" do "$2" změnić',
	'inlinecategorizer-error-title' => 'Zmylk',
	'inlinecategorizer-remove-category' => 'Kategoriju wotstronić',
	'inlinecategorizer-remove-category-error' => 'Njebě móžno kategoriju "$1" wotstronić.
To so zwjetša stawa, hdyž kategorija je so stronje w předłoze přidała.',
	'inlinecategorizer-remove-category-summary' => 'Kategoriju "$1" wotstronić',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'inlinecategorizer-add-category' => 'Kategória hozzáadása',
	'inlinecategorizer-add-category-submit' => 'Hozzáadás',
	'inlinecategorizer-add-category-summary' => '„$1” kategória hozzáadása',
	'inlinecategorizer-cancel' => 'Szerkesztések visszavonása',
	'inlinecategorizer-category-already-present' => 'Ez a lap már a(z) „$1” kategória tagja.',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Mentés',
	'inlinecategorizer-confirm-save-all' => 'Összes változtatás mentése',
	'inlinecategorizer-confirm-title' => 'Művelet megerősítése',
	'inlinecategorizer-edit-category' => 'Kategória szerkesztése',
	'inlinecategorizer-edit-category-error' => 'Nem lehet szerkeszteni a kategóriát.
Ez általában akkor fordul elő, ha a lapot egy sablon sorolja be az adott kategóriába.',
	'inlinecategorizer-edit-category-summary' => '„$1” kategória cseréje a következőre: „$2”',
	'inlinecategorizer-error-title' => 'Hiba',
	'inlinecategorizer-remove-category' => 'Kategória eltávolítása',
	'inlinecategorizer-remove-category-error' => 'Nem sikerült eltávolítani a kategóriát.
Ez általában akkor fordul elő, ha a kategóriát egy sablon adja hozzá a laphoz.',
	'inlinecategorizer-remove-category-summary' => '„$1” kategória eltávolítása',
);

/** Armenian (Հայերեն)
 * @author Xelgen
 */
$messages['hy'] = array(
	'inlinecategorizer-add-category' => 'Ավելացնել կատեգորիա',
	'inlinecategorizer-add-category-submit' => 'Ավելացնել',
	'inlinecategorizer-add-category-summary' => 'Ավելացնել «$1» կատեգորիան',
	'inlinecategorizer-confirm-save' => 'Հիշել',
	'inlinecategorizer-confirm-title' => 'Հաստատել գործողությունը',
	'inlinecategorizer-error-title' => 'Սխալ',
	'inlinecategorizer-remove-category-error' => 'Չհաջողվեց հեռացնել այս կատեգորիան։
Դա սովորաբար պատահում է, երբ կատեգորիան ավելացվում է կաղապարի միջից։',
	'inlinecategorizer-remove-category-summary' => 'Հեռացնել «$1» կատեգորիան',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'inlinecategorizer-desc' => 'Modulo JavaScript que permitte cambiar, adder e remover ligamines a categorias directemente ab un pagina',
	'inlinecategorizer-add-category' => 'Adder categoria',
	'inlinecategorizer-add-category-submit' => 'Adder',
	'inlinecategorizer-add-category-summary' => 'Adder categoria "$1"',
	'inlinecategorizer-api-error' => 'Le API retornava un error: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'Le API retornava un error incognite.',
	'inlinecategorizer-cancel' => 'Cancellar modificationes',
	'inlinecategorizer-cancel-all' => 'Cancellar tote le modificationes',
	'inlinecategorizer-category-already-present' => 'Iste pagina pertine jam al categoria $1',
	'inlinecategorizer-category-hook-error' => 'Un function local ha impedite le salveguarda del modificationes',
	'inlinecategorizer-category-question' => 'Proque vole tu facer le sequente modificationes:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Publicar',
	'inlinecategorizer-confirm-save-all' => 'Salveguardar tote le modificationes',
	'inlinecategorizer-confirm-title' => 'Confirmar action',
	'inlinecategorizer-edit-category' => 'Modificar categoria',
	'inlinecategorizer-edit-category-error' => 'Non esseva possibile modificar le categoria "$1".
sto occurre generalmente si le categoria ha essite addite al pagina per medio de un patrono.',
	'inlinecategorizer-edit-category-summary' => 'Cambiar le categoria "$1" a "$2"',
	'inlinecategorizer-error-title' => 'Error',
	'inlinecategorizer-remove-category' => 'Remover categoria',
	'inlinecategorizer-remove-category-error' => 'Il non esseva possibile remover le categoria "$1".
Isto occurre generalmente si le categoria ha essite addite al pagina per medio de un patrono.',
	'inlinecategorizer-remove-category-summary' => 'Remover categoria "$1"',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Irwangatot
 */
$messages['id'] = array(
	'inlinecategorizer-add-category' => 'Tambah kategori',
	'inlinecategorizer-add-category-submit' => 'Tambah',
	'inlinecategorizer-add-category-summary' => 'Tambah kategori "$1"',
	'inlinecategorizer-api-error' => 'API mengembalikan kesalahan : $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API mengembalikan kesalahan tak dikenal.',
	'inlinecategorizer-cancel' => 'Batalkan suntingan',
	'inlinecategorizer-cancel-all' => 'Batalkan semua perubahan',
	'inlinecategorizer-category-already-present' => 'Halaman ini sudah masuk dalam kategori "$1"',
	'inlinecategorizer-category-hook-error' => 'Fungsi setempat mencegah perubahan disimpan.',
	'inlinecategorizer-category-question' => 'Sebab Anda melakukan perubahan berikut:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Simpan',
	'inlinecategorizer-confirm-save-all' => 'Simpan semua perubahan',
	'inlinecategorizer-confirm-title' => 'Konfirmasi aksi',
	'inlinecategorizer-edit-category' => 'Sunting kategori',
	'inlinecategorizer-edit-category-error' => 'Tidak mungkin menyunting kategori "$1".
Ini biasanya terjadi ketika kategori ditambahkan ke halaman melalui templat.',
	'inlinecategorizer-edit-category-summary' => 'Ubah kategori "$1" menjadi "$2"',
	'inlinecategorizer-error-title' => 'Kesalahan',
	'inlinecategorizer-remove-category' => 'Hapus kategori',
	'inlinecategorizer-remove-category-error' => 'Tidak mungkin menghapus kategori "$1".
Ini biasanya terjadi ketika kategori ditambahkan ke halaman melalui templat.',
	'inlinecategorizer-remove-category-summary' => 'Hapus kategori "$1"',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'inlinecategorizer-add-category' => 'Tinyé ébéonọr',
	'inlinecategorizer-add-category-submit' => 'Tinyé kwa',
	'inlinecategorizer-add-category-summary' => "Tonyé ébéanọr ''$1''",
	'inlinecategorizer-confirm-save' => 'Domá',
	'inlinecategorizer-confirm-title' => 'Me mmèmé inábata',
	'inlinecategorizer-error-title' => 'Nsogbú',
	'inlinecategorizer-remove-category-summary' => "Wefu ébéanọr ''$1''",
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'inlinecategorizer-add-category' => 'Adjuntar kategorio',
	'inlinecategorizer-add-category-submit' => 'Adjuntar',
	'inlinecategorizer-add-category-summary' => 'Adjuntar kategorio "$1"',
	'inlinecategorizer-confirm-save' => 'Registragar',
	'inlinecategorizer-error-title' => 'Eroro',
	'inlinecategorizer-remove-category-summary' => 'Forigar kategorio "$1"',
);

/** Icelandic (Íslenska)
 * @author Jóna Þórunn
 * @author Maxí
 */
$messages['is'] = array(
	'inlinecategorizer-confirm-save' => 'Vista',
	'inlinecategorizer-error-title' => 'Villa',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 * @author Gianfranco
 */
$messages['it'] = array(
	'inlinecategorizer-add-category' => 'Aggiungi categoria',
	'inlinecategorizer-add-category-submit' => 'Aggiungi',
	'inlinecategorizer-add-category-summary' => 'aggiungere la categoria "$1"',
	'inlinecategorizer-api-error' => "L'API ha restituito un errore: $1: $2",
	'inlinecategorizer-api-unknown-error' => "L'API ha restituito un errore sconosciuto.",
	'inlinecategorizer-cancel' => 'Annulla le modifiche',
	'inlinecategorizer-cancel-all' => 'Annulla tutte le modifiche',
	'inlinecategorizer-category-already-present' => 'Questa pagina appartiene già alla categoria $1',
	'inlinecategorizer-category-hook-error' => 'Una funzione locale ha impedito che le modifiche vengano salvate',
	'inlinecategorizer-category-question' => 'Perché vuoi apportare le seguenti modifiche:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Salva',
	'inlinecategorizer-confirm-save-all' => 'Salva tutte le modifiche',
	'inlinecategorizer-confirm-title' => "Conferma l'azione",
	'inlinecategorizer-edit-category' => 'Modifica categoria',
	'inlinecategorizer-edit-category-error' => 'Non è stato possibile modificare la categoria "$1".
Di solito avviene quando la categoria è stata aggiunta alla pagina da un template.',
	'inlinecategorizer-edit-category-summary' => 'modificare la categoria "$1" in "$2"',
	'inlinecategorizer-error-title' => 'Errore',
	'inlinecategorizer-remove-category' => 'Elimina categoria',
	'inlinecategorizer-remove-category-error' => 'Non è stato possibile rimuovere la categoria "$1".
Ciò si verifica in genere quando la categoria è stata aggiunta alla pagina in un template.',
	'inlinecategorizer-remove-category-summary' => 'rimuovere la categoria "$1"',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Ohgi
 * @author Schu
 */
$messages['ja'] = array(
	'inlinecategorizer-desc' => 'ページから直接カテゴリーリンクを追加・削除・変更する事を可能にする JavaScript モジュール。',
	'inlinecategorizer-add-category' => 'カテゴリー追加',
	'inlinecategorizer-add-category-submit' => '追加',
	'inlinecategorizer-add-category-summary' => 'カテゴリー「$1」を追加',
	'inlinecategorizer-api-error' => 'APIがエラーを返しました: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'APIが不明なエラーを返しました。',
	'inlinecategorizer-cancel' => '編集をキャンセル',
	'inlinecategorizer-cancel-all' => 'すべての変更を保存',
	'inlinecategorizer-category-already-present' => 'このページにはすでにカテゴリー「$1」がついています',
	'inlinecategorizer-category-hook-error' => 'ローカル関数の変更は保存できません。',
	'inlinecategorizer-category-question' => 'なぜ、次のような変更が必要ですか：',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => '保存',
	'inlinecategorizer-confirm-save-all' => 'すべての変更を保存',
	'inlinecategorizer-confirm-title' => '操作確認',
	'inlinecategorizer-edit-category' => 'カテゴリーを編集',
	'inlinecategorizer-edit-category-error' => 'カテゴリー「$1」を編集することができませんでした。
このエラーは、主にカテゴリーがテンプレートによってページにつけられている場合に発生します。',
	'inlinecategorizer-edit-category-summary' => 'カテゴリを「$1」から「$2」に変更',
	'inlinecategorizer-error-title' => 'エラー',
	'inlinecategorizer-remove-category' => 'カテゴリーを除去',
	'inlinecategorizer-remove-category-error' => 'カテゴリー「$1」を除去することができませんでした。
このエラーは、主にカテゴリーがテンプレートによってページにつけられている場合に発生します。',
	'inlinecategorizer-remove-category-summary' => 'カテゴリー「$1」を除去',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'inlinecategorizer-add-category' => 'Tambah kategori',
	'inlinecategorizer-add-category-submit' => 'Tambah',
	'inlinecategorizer-confirm-save' => 'Simpen',
	'inlinecategorizer-error-title' => 'Kaluputan',
);

/** Georgian (ქართული)
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'inlinecategorizer-add-category' => 'კატეგორიის ჩამატება',
	'inlinecategorizer-add-category-submit' => 'ჩამატება',
	'inlinecategorizer-add-category-summary' => 'ჩაემატა კატეგორია "$1".',
	'inlinecategorizer-confirm-save' => 'შენახვა',
	'inlinecategorizer-confirm-title' => 'მოქმედების დადასტურება',
	'inlinecategorizer-error-title' => 'შეცდომა',
	'inlinecategorizer-remove-category-error' => 'ამ კატეგორიის შეკრება შეუძლებელია.
ხშირედ ეს ხდება მაშინ, როდესაც კატეგორია ჩამატებულია თარგიდან.',
	'inlinecategorizer-remove-category-summary' => 'წაიშალა კატეგორია "$1".',
);

/** Kalaallisut (Kalaallisut)
 * @author Aputtu
 */
$messages['kl'] = array(
	'inlinecategorizer-confirm-save' => 'Toqqoruk',
);

/** Khmer (ភាសាខ្មែរ)
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'inlinecategorizer-add-category' => 'បន្ថែម​ចំណាត់ថ្នាក់​ក្រុម​',
	'inlinecategorizer-add-category-submit' => 'បន្ថែម​',
	'inlinecategorizer-add-category-summary' => 'បន្ថែម​ចំណាត់ថ្នាក់​ក្រុម​ "$1"',
	'inlinecategorizer-confirm-save' => 'រក្សាទុក',
	'inlinecategorizer-confirm-title' => 'បញ្ជាក់​សកម្មភាព​',
	'inlinecategorizer-error-title' => 'កំហុស​',
	'inlinecategorizer-remove-category-summary' => 'ដកចេញ​​ចំណាត់ថ្នាក់​ក្រុម​ "$1"',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'inlinecategorizer-add-category-submit' => 'ಸೇರಿಸು',
	'inlinecategorizer-confirm-save' => 'ಉಳಿಸಿ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'inlinecategorizer-add-category' => '분류 추가',
	'inlinecategorizer-add-category-submit' => '추가',
	'inlinecategorizer-add-category-summary' => '"$1" 분류 더하기',
	'inlinecategorizer-confirm-save' => '저장',
	'inlinecategorizer-confirm-title' => '편집 확인',
	'inlinecategorizer-error-title' => '오류',
	'inlinecategorizer-remove-category-error' => '이 분류를 지울 수 없습니다.
분류가 틀로 추가되었을 수 있습니다.',
	'inlinecategorizer-remove-category-summary' => '"$1" 분류 지우기',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 * @author Къарачайлы
 */
$messages['krc'] = array(
	'inlinecategorizer-add-category' => 'Категория къош',
	'inlinecategorizer-add-category-submit' => 'Къош',
	'inlinecategorizer-add-category-summary' => '«$1» категория къошулду',
	'inlinecategorizer-confirm-save' => 'Сакълат',
	'inlinecategorizer-confirm-title' => 'Ишлеуню мюкюл эт',
	'inlinecategorizer-error-title' => 'Халат',
	'inlinecategorizer-remove-category-error' => 'Категория кетерилмейди.
Бу проблема кёбюсюне, категория шаблонну юсю бла бетге къошулса, болады.',
	'inlinecategorizer-remove-category-summary' => '«$1» категория кетерилди',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'inlinecategorizer-desc' => 'E javaSkrepp Projramm, wad-et müjjelesch määt, Lenks op Saachjroppe tiräk ob_ener Sigg enzejävve udder fott ze nämme.',
	'inlinecategorizer-add-category' => 'Saachjropp dobei donn',
	'inlinecategorizer-add-category-submit' => 'Lohß jonn!',
	'inlinecategorizer-add-category-summary' => 'Donn de Saachjropp „$1“ derbei.',
	'inlinecategorizer-api-error' => 'De <i lang="en"  title="Projammierschnettschtäll för Aanwendunge">API</i> hädd ene Fähler jemäldt: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'De <i lang="en"  title="Projammierschnettschtäll för Aanwendunge">API</i> hädd ene Fähler jemäldt, dä mer nit känne.',
	'inlinecategorizer-cancel' => 'Nix Ändere!',
	'inlinecategorizer-cancel-all' => 'Donn all di Änderunge wider verjäße',
	'inlinecategorizer-category-already-present' => 'Heh di Sigg es ald en dä Saachjropp „$1“dren.',
	'inlinecategorizer-category-hook-error' => 'En lokaale Funxjuhn löht di Änderonge nit zoh.',
	'inlinecategorizer-category-question' => 'Woröm wells De heh di Änderonge maache:',
	'inlinecategorizer-confirm-ok' => 'Lohß Jonn!',
	'inlinecategorizer-confirm-save' => 'Avshpeishere',
	'inlinecategorizer-confirm-save-all' => 'All di Änderunge faßhallde',
	'inlinecategorizer-confirm-title' => 'Akßjuhn beschtähtejje',
	'inlinecategorizer-edit-category' => 'Donn heh di Saachjropp tuusche',
	'inlinecategorizer-edit-category-error' => 'Mer kunnte di Saachjropp „$1“ nit ußtuusche.
Dat künnt dovun kumme, dat se övver en Schabloon enjedraare weed.',
	'inlinecategorizer-edit-category-summary' => 'Uß dä Saachjropp „$1“ eruß un en de Saachjropp „$2“ erin jedonn',
	'inlinecategorizer-error-title' => 'Fähler',
	'inlinecategorizer-remove-category' => 'Donn heh di Saachjrupp fottnämme',
	'inlinecategorizer-remove-category-error' => 'Et wohr nit müjjelesch, di Saachjropp „$1“ eruß ze nämme.
Dat es fö jewöhnlej_esu, wann di Saachjropp övver en Schabloon en di Sigg enjedraare es.',
	'inlinecategorizer-remove-category-summary' => 'Saachjropp „$1“ eruß nämme',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'inlinecategorizer-cancel' => 'Guhertinê betal bike',
	'inlinecategorizer-cancel-all' => 'Hemû guhertinan betal bike',
	'inlinecategorizer-confirm-save' => 'Tomar bike',
	'inlinecategorizer-confirm-save-all' => 'Hemû guhertinan tomar bike',
	'inlinecategorizer-edit-category' => 'Kategoriyê biguherîne',
	'inlinecategorizer-error-title' => 'Çewtî',
	'inlinecategorizer-remove-category' => 'Kategoriyê jê bibe',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'inlinecategorizer-desc' => "JavaScript deen et erlaabt fir Kategorien direkt op enger Säit z'änneren, derbäizesetzen oder erofzehuelen",
	'inlinecategorizer-add-category' => 'Kategorie derbäisetzen',
	'inlinecategorizer-add-category-submit' => 'Derbäisetzen',
	'inlinecategorizer-add-category-summary' => 'Kategorie "$1" derbäisetzen',
	'inlinecategorizer-api-error' => 'Den API huet e Feeler signaliséiert: $1: $2',
	'inlinecategorizer-api-unknown-error' => "D'API huet een onbekannte Feeler zréckgeschéckt.",
	'inlinecategorizer-cancel' => 'Ännerungen annuléieren',
	'inlinecategorizer-cancel-all' => 'All Ännerungen annulléieren',
	'inlinecategorizer-category-already-present' => 'Dës Säit ass schonn an der Kategorie $1',
	'inlinecategorizer-category-hook-error' => "Eng lokal Fonctioun huet verhënnert datt d'Ännerunge gespäichert goufen",
	'inlinecategorizer-category-question' => 'Firwat wëllt Dir dës Ännerunge maachen:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Späicheren',
	'inlinecategorizer-confirm-save-all' => 'All Ännerunge späicheren',
	'inlinecategorizer-confirm-title' => 'Aktioun confirméieren',
	'inlinecategorizer-edit-category' => 'Kategorie änneren',
	'inlinecategorizer-edit-category-error' => "Et war net méiglech d'Kategorie $1 z'änneren.
Dat geschitt gewéinlech wann d'Kategorie duerch eng Schabloun op d'Säit derbäigesat gouf.",
	'inlinecategorizer-edit-category-summary' => 'Kategorie "$1" op "$2" änneren',
	'inlinecategorizer-error-title' => 'Feeler',
	'inlinecategorizer-remove-category' => 'Kategorie ewechhuelen',
	'inlinecategorizer-remove-category-error' => "Et war net méiglech d'Kategorie $1 ewechzehuelen.
Dëst geschitt gewéinlech da wann eng Kategorie duerch eng Schabloun op d'Säit derbäi gesat gouf.",
	'inlinecategorizer-remove-category-summary' => 'Kategorie "$1" ewechhuelen',
);

/** Lithuanian (Lietuvių)
 * @author Garas
 * @author Homo
 * @author Ignas693
 * @author Matasg
 */
$messages['lt'] = array(
	'inlinecategorizer-add-category' => 'Pridėti kategoriją',
	'inlinecategorizer-add-category-submit' => 'Pridėti',
	'inlinecategorizer-add-category-summary' => 'Pridėti kategoriją „$1“',
	'inlinecategorizer-api-error' => 'API grąžino klaidą: $1 : $2 .',
	'inlinecategorizer-api-unknown-error' => 'API grąžino nežinomą klaidą.',
	'inlinecategorizer-cancel' => 'Atšaukti redagavimą',
	'inlinecategorizer-cancel-all' => 'Atšaukti visus pakeitimus',
	'inlinecategorizer-category-already-present' => 'Šis puslapis jau priskirtas kategorijai "$1"',
	'inlinecategorizer-category-hook-error' => 'Vietinė funkcija neleido išsaugoti pakeitimų.',
	'inlinecategorizer-category-question' => 'Kodėl jūs norite atlikti šiuos keitimus:',
	'inlinecategorizer-confirm-ok' => 'Gerai',
	'inlinecategorizer-confirm-save' => 'Išsaugoti',
	'inlinecategorizer-confirm-save-all' => 'Išsaugoti visus pakeitimus',
	'inlinecategorizer-confirm-title' => 'Patvirtinti veiksmą',
	'inlinecategorizer-edit-category' => 'Redaguoti kategoriją',
	'inlinecategorizer-edit-category-error' => 'Kategorijos "$1" nepavyko redaguoti.
Dažniausiai taip nutinka, kai kategorija būna pridėta į šabloną, kuris naudojamas puslapyje.',
	'inlinecategorizer-edit-category-summary' => 'Keisti kategoriją "$1" į "$2"',
	'inlinecategorizer-error-title' => 'Klaida',
	'inlinecategorizer-remove-category' => 'Pašalinti kategoriją',
	'inlinecategorizer-remove-category-error' => 'Nepavyko pašalinti kategorijos "$1".
Dažniausiai taip nutinka, kai kategorija būna pridėta į šabloną, kuris naudojamas puslapyje.',
	'inlinecategorizer-remove-category-summary' => 'Panaikinti kategoriją „$1“',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'inlinecategorizer-add-category' => 'Dalikt kategoreju',
	'inlinecategorizer-add-category-submit' => 'Dalikt',
	'inlinecategorizer-add-category-summary' => 'Dalikt kategoreju "$1"',
	'inlinecategorizer-confirm-save' => 'Izglobuot',
	'inlinecategorizer-error-title' => 'Klaida',
);

/** Latvian (Latviešu)
 * @author Dark Eagle
 */
$messages['lv'] = array(
	'inlinecategorizer-add-category' => 'Pievienot kategoriju',
	'inlinecategorizer-add-category-submit' => 'Pievienot',
	'inlinecategorizer-add-category-summary' => 'Pievienot kategoriju "$1"',
	'inlinecategorizer-confirm-save' => 'Saglabāt',
	'inlinecategorizer-error-title' => 'Kļūda (Error)',
);

/** Literary Chinese (文言) */
$messages['lzh'] = array(
	'inlinecategorizer-add-category' => '加類',
	'inlinecategorizer-add-category-submit' => '加',
	'inlinecategorizer-add-category-summary' => '加類「$1」',
	'inlinecategorizer-confirm-save' => '存',
	'inlinecategorizer-confirm-title' => '確',
	'inlinecategorizer-error-title' => '錯',
	'inlinecategorizer-remove-category-error' => '無取此類也。
常於一模入類。',
	'inlinecategorizer-remove-category-summary' => '取類「$1」',
);

/** Maithili (मैथिली)
 * @author Umeshberma
 */
$messages['mai'] = array(
	'inlinecategorizer-add-category' => 'संवर्ग जोड़ू',
	'inlinecategorizer-add-category-submit' => 'जोडू',
	'inlinecategorizer-add-category-summary' => 'जोड़ू संवर्ग "$1"',
	'inlinecategorizer-api-error' => 'ए.पी.आइ. सँ भ्रम आएल:: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'ए.पी.आइ. एकटा अनिश्चित भ्रम देलक।',
	'inlinecategorizer-cancel' => 'सम्पादन रद्द करू',
	'inlinecategorizer-cancel-all' => 'सभ परिवर्त्तनकेँ रद्द करू',
	'inlinecategorizer-category-already-present' => 'ई पन्ना पहिनहियेसँ संवर्ग "$1" मे अछि।',
	'inlinecategorizer-category-hook-error' => 'कोनो स्थानीय प्रकार्य ऐ परिवर्तन सभक सुरक्षामे बाधक बनल।',
	'inlinecategorizer-category-question' => 'अहाँ ई सभ परिवर्तन किए करए चाहै छी:',
	'inlinecategorizer-confirm-ok' => 'ठीक अछि',
	'inlinecategorizer-confirm-save' => 'सुरक्षित करू',
	'inlinecategorizer-confirm-save-all' => 'अपन सभ परिवर्त्तनकेँ सुरक्षित करू',
	'inlinecategorizer-confirm-title' => 'क्रिया संपुष्टि',
	'inlinecategorizer-edit-category' => 'संवर्ग सम्पादित करू',
	'inlinecategorizer-edit-category-error' => 'संवर्ग "$1" क सम्पादन सम्भव नै छल।
ई तखने होइए जखन कोनो नमूनामे संवर्ग जोड़ल जाइए।',
	'inlinecategorizer-edit-category-summary' => 'संवर्ग "$1" केँ "$2" मे बदलू',
	'inlinecategorizer-error-title' => 'भ्रम',
	'inlinecategorizer-remove-category' => 'संवर्ग हटाउ',
	'inlinecategorizer-remove-category-error' => 'संवर्ग "$1" केँ हटेनाइ सम्भव नै छल।
ई तखने होइए जखन कोनो नमूनामे संवर्ग जोड़ल जाइए।',
	'inlinecategorizer-remove-category-summary' => 'संवर्ग "$1" हटाउ',
);

/** Moksha (Мокшень)
 * @author Jarmanj Turtash
 */
$messages['mdf'] = array(
	'inlinecategorizer-confirm-save' => 'Ванфтомс',
	'inlinecategorizer-error-title' => 'Эльбятькс',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'inlinecategorizer-add-category' => 'Hanampy sokajy',
	'inlinecategorizer-add-category-submit' => 'Hanampy',
	'inlinecategorizer-add-category-summary' => 'Hanampy ny sokajy « $1 »',
	'inlinecategorizer-confirm-save' => 'Tehirizo',
	'inlinecategorizer-confirm-title' => 'Hanohy ilay tao',
	'inlinecategorizer-error-title' => 'Tsy fetezana',
	'inlinecategorizer-remove-category-summary' => 'Hanala ilay sokajy « $1 »',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'inlinecategorizer-desc' => 'JavaScript-модул што овозможува менување, додавање и отстранување на категориски врски непосредно од страницата',
	'inlinecategorizer-add-category' => 'Додај категорија',
	'inlinecategorizer-add-category-submit' => 'Додај',
	'inlinecategorizer-add-category-summary' => 'Додај категорија "$1"',
	'inlinecategorizer-api-error' => 'API врати грешка: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API врати непозната грешка.',
	'inlinecategorizer-cancel' => 'Откажи уредувања',
	'inlinecategorizer-cancel-all' => 'Откажи ги сите промени',
	'inlinecategorizer-category-already-present' => 'Страницава веќе ѝ припаѓа на категоријата $1',
	'inlinecategorizer-category-hook-error' => 'Локална функција го спречи зачувувањето на измените',
	'inlinecategorizer-category-question' => 'Зошто сакате да ги извршите следниве измени:',
	'inlinecategorizer-confirm-ok' => 'ОК',
	'inlinecategorizer-confirm-save' => 'Зачувај',
	'inlinecategorizer-confirm-save-all' => 'Зачувај ги сите промени',
	'inlinecategorizer-confirm-title' => 'Потврди дејство',
	'inlinecategorizer-edit-category' => 'Уреди категорија',
	'inlinecategorizer-edit-category-error' => 'Категоријата „$1“ не можеше да се уреди.
Ова обично се случува кога категоријата е додадена на страница преку некој шаблон.',
	'inlinecategorizer-edit-category-summary' => 'Замена на категоријата „$1“ со „$2“',
	'inlinecategorizer-error-title' => 'Грешка',
	'inlinecategorizer-remove-category' => 'Отстрани категорија',
	'inlinecategorizer-remove-category-error' => 'Не можев да ја отстранам категоријата „$1“.
Ова обично се случува кога категоријата е додадена на страница преку некој шаблон.',
	'inlinecategorizer-remove-category-summary' => 'Избриши категорија "$1"',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'inlinecategorizer-add-category' => 'വർഗ്ഗം കൂട്ടിച്ചേർക്കുക',
	'inlinecategorizer-add-category-submit' => 'കൂട്ടിച്ചേർക്കുക',
	'inlinecategorizer-add-category-summary' => 'വർഗ്ഗം "$1" കൂട്ടിച്ചേർക്കുക',
	'inlinecategorizer-api-error' => 'എ.പി.ഐ. പിഴവുണ്ടായതായി അറിയിച്ചിരിക്കുന്നു: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'എ.പി.ഐ. ഒരു തിരിച്ചറിയാത്ത പിഴവ് അയച്ചിരിക്കുന്നു.',
	'inlinecategorizer-cancel' => 'തിരുത്തലുകൾ റദ്ദാക്കുക',
	'inlinecategorizer-cancel-all' => 'എല്ലാ മാറ്റങ്ങളും റദ്ദ് ചെയ്യുക',
	'inlinecategorizer-category-already-present' => 'ഈ താൾ ഇപ്പോൾ തന്നെ $1 എന്ന വർഗ്ഗത്തിലുണ്ട്',
	'inlinecategorizer-category-hook-error' => 'ഒരു പ്രാദേശിക ഫങ്ഷൻ മാറ്റങ്ങൾ സേവ് ചെയ്യുന്നത് തടഞ്ഞിരിക്കുന്നു',
	'inlinecategorizer-category-question' => 'എന്തുകൊണ്ടാണ് താഴെക്കൊടുത്തിരിക്കുന്ന മാറ്റങ്ങൾ വേണ്ടത്:',
	'inlinecategorizer-confirm-ok' => 'ശരി',
	'inlinecategorizer-confirm-save' => 'സേവ് ചെയ്യുക',
	'inlinecategorizer-confirm-save-all' => 'എല്ലാ മാറ്റങ്ങളും സേവ് ചെയ്യുക',
	'inlinecategorizer-confirm-title' => 'പ്രവൃത്തി സ്ഥിരീകരിക്കുക',
	'inlinecategorizer-edit-category' => 'വർഗ്ഗം തിരുത്തുക',
	'inlinecategorizer-edit-category-error' => '"$1" എന്ന വർഗ്ഗത്തിൽ തിരുത്തലുകൾ സാദ്ധ്യമായില്ല.
താളിൽ ഫലകമുപയോഗിച്ചാണ് വർഗ്ഗം ചേർത്തിരിക്കുന്നതെങ്കിൽ ഇപ്രകാരം സംഭവിക്കാറുണ്ട്.',
	'inlinecategorizer-edit-category-summary' => '"$1" എന്ന വർഗ്ഗം "$2" എന്നാക്കി മാറ്റുക',
	'inlinecategorizer-error-title' => 'പിഴവ്',
	'inlinecategorizer-remove-category' => 'വർഗ്ഗം നീക്കംചെയ്യുക',
	'inlinecategorizer-remove-category-error' => '"$1" എന്ന വർഗ്ഗം നീക്കം ചെയ്യാൻ കഴിയില്ല.
ഫലകങ്ങളുപയോഗിച്ചാണ് വർഗ്ഗം ചേർത്തിരിക്കുന്നതെങ്കിൽ സാധാരണ ഇങ്ങനെ സംഭവിക്കാറുണ്ട്.',
	'inlinecategorizer-remove-category-summary' => 'വർഗ്ഗം "$1" നീക്കംചെയ്യുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'inlinecategorizer-add-category-submit' => 'Нэмэх',
);

/** Marathi (मराठी)
 * @author Htt
 */
$messages['mr'] = array(
	'inlinecategorizer-confirm-ok' => 'ठीक',
	'inlinecategorizer-confirm-save' => 'जतन करा',
	'inlinecategorizer-confirm-save-all' => 'सर्व बदल जतन करा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'inlinecategorizer-desc' => 'Modul JavaScript yang membolehkan pengubahan, penambahan dan penyingkiran pautan kategori secara terus dari laman',
	'inlinecategorizer-add-category' => 'Tambahkan kategori',
	'inlinecategorizer-add-category-submit' => 'Tambahkan',
	'inlinecategorizer-add-category-summary' => 'Tambahkan kategori "$1"',
	'inlinecategorizer-api-error' => 'API memulangkan ralat: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API memulangkan ralat yang tidak dikenali.',
	'inlinecategorizer-cancel' => 'Batalkan suntingan',
	'inlinecategorizer-cancel-all' => 'Batalkan semua perubahan',
	'inlinecategorizer-category-already-present' => 'Laman ini sudah tergolong dalam kategori $1',
	'inlinecategorizer-category-hook-error' => 'Fungsi setempat menghalang perubahan daripada disimpan',
	'inlinecategorizer-category-question' => 'Mengapakah anda ingin membuat perubahan-perubahan berikut:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Simpan',
	'inlinecategorizer-confirm-save-all' => 'Simpan semua perubahan',
	'inlinecategorizer-confirm-title' => 'Sahkan tindakan',
	'inlinecategorizer-edit-category' => 'Sunting kategori',
	'inlinecategorizer-edit-category-error' => 'Kategori "$1" tidak boleh disunting.
Ini biasanya berlaku apabila kategori ditambahkan pada laman dengan menggunakan templat.',
	'inlinecategorizer-edit-category-summary' => 'Tukar kategori "$1" ke "$2"',
	'inlinecategorizer-error-title' => 'Ralat',
	'inlinecategorizer-remove-category' => 'Buang kategori',
	'inlinecategorizer-remove-category-error' => 'Kategori "$1" tidak boleh dibuang.
Ini biasanya berlaku apabila kategori ditambahkan pada laman dengan menggunakan templat.',
	'inlinecategorizer-remove-category-summary' => 'Buang kategori "$1"',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'inlinecategorizer-add-category' => 'Żid kategorija',
	'inlinecategorizer-add-category-submit' => 'Żid',
	'inlinecategorizer-add-category-summary' => 'Żid il-kategorija "$1"',
	'inlinecategorizer-api-error' => 'L-API tat lura żball: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'L-API tat lura żball mhux magħruf.',
	'inlinecategorizer-cancel' => 'Annulla l-modifika',
	'inlinecategorizer-cancel-all' => 'Annulla kull tibdila',
	'inlinecategorizer-category-already-present' => 'Din il-paġna diġà tappartjeni għall-kategorija "$1"',
	'inlinecategorizer-category-hook-error' => 'Funzjoni lokali ma ħallietx li l-modifiki jiġu salvati.',
	'inlinecategorizer-category-question' => 'Għaliex tixtieq tagħmel dawn il-modifiki:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Salva',
	'inlinecategorizer-confirm-save-all' => 'Salva kull tibdila',
	'inlinecategorizer-confirm-title' => 'Ikkonferma l-azzjoni',
	'inlinecategorizer-edit-category' => 'Immodifika kategorija',
	'inlinecategorizer-edit-category-error' => 'Ma kienx possibbli li timmodifika l-kategorija "$1".
Dan ġeneralment jiġri meta l-kategorija ġiet miżjuda mal-paġna permezz ta\' mudell.',
	'inlinecategorizer-edit-category-summary' => 'Biddel kategorija minn "$1" għal "$2"',
	'inlinecategorizer-error-title' => 'Żball',
	'inlinecategorizer-remove-category' => 'Ħassar kategorija',
	'inlinecategorizer-remove-category-error' => 'Ma kienx possibbli li titneħħa l-kategorija "$1".
Dan ġeneralment jiġri meta l-kategorija ġiet miżjuda mal-paġna permezz ta\' mudell.',
	'inlinecategorizer-remove-category-summary' => 'Neħħi l-kategorija "$1"',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'inlinecategorizer-add-category' => 'Поладомс категория',
	'inlinecategorizer-add-category-submit' => 'Поладомс',
	'inlinecategorizer-add-category-summary' => 'Поладомс категориянть "$1"',
	'inlinecategorizer-cancel' => 'Саемс мекев мезе витнить-петнить',
	'inlinecategorizer-cancel-all' => 'Саемс мекев весе мезе лиякстомтыть',
	'inlinecategorizer-confirm-save' => 'Ванстомс',
	'inlinecategorizer-confirm-save-all' => 'Ванстомс весе мезе лиякстомтыть',
	'inlinecategorizer-confirm-title' => 'Кемекстамс мезе теить',
	'inlinecategorizer-edit-category' => 'Витнемс-петнемс категориянть',
	'inlinecategorizer-edit-category-summary' => 'Полавтомс "$1" категория "$2" категория лангс',
	'inlinecategorizer-error-title' => 'Ильведевкс',
	'inlinecategorizer-remove-category' => 'Нардамс категориянть',
	'inlinecategorizer-remove-category-summary' => 'Нардамс категориянть "$1"',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author EivindJ
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'inlinecategorizer-add-category' => 'Legg til kategori',
	'inlinecategorizer-add-category-submit' => 'Legg til',
	'inlinecategorizer-add-category-summary' => 'Legg til kategorien «$1»',
	'inlinecategorizer-api-error' => 'API-en returnerte en feilmelding: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API-et returnerte en ukjent feil.',
	'inlinecategorizer-cancel' => 'Avbryt redigeringer',
	'inlinecategorizer-cancel-all' => 'Avbryt alle endringer',
	'inlinecategorizer-category-already-present' => 'Denne siden tilhører allerede kategorien $1',
	'inlinecategorizer-category-hook-error' => 'En lokal funksjon hindret endringene fra å bli lagret',
	'inlinecategorizer-category-question' => 'Hvorfor ønsker du å gjøre følgende endringer:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Lagre',
	'inlinecategorizer-confirm-save-all' => 'Lagre alle endringer',
	'inlinecategorizer-confirm-title' => 'Bekreft handling',
	'inlinecategorizer-edit-category' => 'Rediger kategori',
	'inlinecategorizer-edit-category-error' => 'Det var ikke mulig å redigere kategorien «$1».
Dette skjer vanligvis når kategorien har blitt lagt til siden gjennom en mal.',
	'inlinecategorizer-edit-category-summary' => 'Endre kategori «$1» til «$2»',
	'inlinecategorizer-error-title' => 'Feil',
	'inlinecategorizer-remove-category' => 'Fjern kategori',
	'inlinecategorizer-remove-category-error' => 'Det var umulig å fjerne kategorien «$1».
Dette skjer som regel fordi kategorien har blitt lagt til via en mal.',
	'inlinecategorizer-remove-category-summary' => 'Fjern kategorien «$1»',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Purodha
 * @author Servien
 */
$messages['nds-nl'] = array(
	'inlinecategorizer-add-category' => 'Kategorie derbie zetten',
	'inlinecategorizer-add-category-submit' => 'Derbie zetten',
	'inlinecategorizer-add-category-summary' => 'Kategorie "$1" derbie doon',
	'inlinecategorizer-api-error' => 'De API gaf n foutmelding: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'De API gaf n onbekende foutmelding.',
	'inlinecategorizer-cancel' => 'Bewarkingen ofbreken',
	'inlinecategorizer-cancel-all' => 'Alle wiezigingen aofbreken',
	'inlinecategorizer-category-already-present' => 'Disse pagina steet al in de kategorie $1',
	'inlinecategorizer-category-hook-error' => 'n Lokale funksie verhinderden t opslaon van de wiezigingen',
	'inlinecategorizer-category-question' => "Waorumme wi'j de volgende wiezigingen anbrengen:",
	'inlinecategorizer-confirm-ok' => 'Oké',
	'inlinecategorizer-confirm-save' => 'Opslaon',
	'inlinecategorizer-confirm-save-all' => 'Alle wiezigingen opslaon',
	'inlinecategorizer-confirm-title' => 'Haandeling bevestigen',
	'inlinecategorizer-edit-category' => 'Bewark kategorie',
	'inlinecategorizer-edit-category-error' => 't Was niet meugelik um de kategorie "$1" te wiezigen.
Dit gebeurt meestentieds as de kategorie via n mal op de pagina ezet is.',
	'inlinecategorizer-edit-category-summary' => 'Wiezig kategorie "$1" naor "$2"',
	'inlinecategorizer-error-title' => 'Fout',
	'inlinecategorizer-remove-category' => 'Kategorie vortdoon',
	'inlinecategorizer-remove-category-error' => 'Kon de kategorie "$1" niet vortdoon.
Dit gebeurt meestentieds as de kategorie via n mal op de pagina ezet is.',
	'inlinecategorizer-remove-category-summary' => 'Kategorie "$1" vortdoon',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'inlinecategorizer-desc' => 'JavaScriptmodule die het toevoegen, verwijderen en wijzigen van categorieverwijzingen direct vanuit de pagina mogelijk maakt',
	'inlinecategorizer-add-category' => 'Categorie toevoegen',
	'inlinecategorizer-add-category-submit' => 'Toevoegen',
	'inlinecategorizer-add-category-summary' => 'categorie "$1" toevoegen',
	'inlinecategorizer-api-error' => 'De API gaf een foutmelding: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'De API gaf een onbekende foutmelding.',
	'inlinecategorizer-cancel' => 'Bewerkingen annuleren',
	'inlinecategorizer-cancel-all' => 'Alle wijzigingen annuleren',
	'inlinecategorizer-category-already-present' => 'Deze pagina behoort al tot categorie $1',
	'inlinecategorizer-category-hook-error' => 'Een lokale functie verhinderde het opslaan van de wijzigingen',
	'inlinecategorizer-category-question' => 'Waarom wilt u de volgende wijzigingen maken:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Opslaan',
	'inlinecategorizer-confirm-save-all' => 'Alle wijzigingen opslaan',
	'inlinecategorizer-confirm-title' => 'Handeling bevestigen',
	'inlinecategorizer-edit-category' => 'Categorie bewerken',
	'inlinecategorizer-edit-category-error' => '!Het was niet mogelijk om categorie "$1" te bewerken.
Dit gebeurt meestal wanneer de categorie is toegevoegd aan de pagina door een sjabloon.',
	'inlinecategorizer-edit-category-summary' => 'categorie "$1" naar "$2" wijzigen',
	'inlinecategorizer-error-title' => 'Fout',
	'inlinecategorizer-remove-category' => 'Categorie verwijderen',
	'inlinecategorizer-remove-category-error' => 'Het was niet mogelijk categorie "$1" te verwijderen.
Dit gebeurt meestal als de categorie via een sjabloon aan de pagina is toegevoegd.',
	'inlinecategorizer-remove-category-summary' => 'categorie "$1" verwijderen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Ranveig
 */
$messages['nn'] = array(
	'inlinecategorizer-add-category' => 'Legg til kategori',
	'inlinecategorizer-add-category-submit' => 'Legg til',
	'inlinecategorizer-add-category-summary' => 'Legg til kategorien "$1"',
	'inlinecategorizer-confirm-save' => 'Lagre',
	'inlinecategorizer-confirm-title' => 'Stadfest handling',
	'inlinecategorizer-error-title' => 'Feil',
	'inlinecategorizer-remove-category-error' => 'Det var ikkje mogleg å fjerna kategorien.
Det skuldast som oftast at kategorien er vorte lagd til i sida inni ein mal.',
	'inlinecategorizer-remove-category-summary' => 'Fjern kategorien "$1"',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'inlinecategorizer-add-category' => 'Apondre una categoria',
	'inlinecategorizer-add-category-submit' => 'Apondre',
	'inlinecategorizer-add-category-summary' => 'Apondre la categoria « $1 »',
	'inlinecategorizer-confirm-save' => 'Publicar',
	'inlinecategorizer-confirm-title' => "Confirmar l'accion",
	'inlinecategorizer-error-title' => 'Error',
	'inlinecategorizer-remove-category-error' => 'Es pas estat possible de levar aquesta categoria.
Aquò se produsís generalament quand la categoria es estada aponduda a la pagina via un modèl.',
	'inlinecategorizer-remove-category-summary' => 'Levar la categoria « $1 »',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'inlinecategorizer-add-category-submit' => 'ଯୋଡ଼ିବେ',
	'inlinecategorizer-confirm-ok' => 'ଠିକ ଅଛି',
	'inlinecategorizer-confirm-save' => 'ସାଇତିବେ',
	'inlinecategorizer-error-title' => 'ଭୁଲ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'inlinecategorizer-add-category' => 'Abdeeling dezu duh',
	'inlinecategorizer-add-category-submit' => 'Dezu duh',
	'inlinecategorizer-add-category-summary' => 'Abdeeling „$1“ dezu duh',
	'inlinecategorizer-confirm-ok' => 'OK',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'inlinecategorizer-desc' => 'Moduł JavaScript, który umożliwia zmianę, dodawanie i usuwanie linków do kategorii bezpośrednio na stronie',
	'inlinecategorizer-add-category' => 'Dodaj kategorię',
	'inlinecategorizer-add-category-submit' => 'Dodaj',
	'inlinecategorizer-add-category-summary' => 'Dodaj kategorię „$1”',
	'inlinecategorizer-api-error' => 'Interfejs API zwrócił błąd – $1: $2',
	'inlinecategorizer-api-unknown-error' => 'Interfejs API zwrócił nieznany błąd.',
	'inlinecategorizer-cancel' => 'Wycofaj zmiany',
	'inlinecategorizer-cancel-all' => 'Anuluj wszystkie zmiany',
	'inlinecategorizer-category-already-present' => 'Strona już jest w kategorii $1',
	'inlinecategorizer-category-hook-error' => 'Lokalna funkcja uniemożliwia zapisanie zmian',
	'inlinecategorizer-category-question' => 'Dlaczego chcesz wprowadzić następujące zmiany:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Zapisz',
	'inlinecategorizer-confirm-save-all' => 'Zapisz wszystkie zmiany',
	'inlinecategorizer-confirm-title' => 'Potwierdź',
	'inlinecategorizer-edit-category' => 'Edytuj kategorię',
	'inlinecategorizer-edit-category-error' => 'Zmiana kategorii „$1“ nie jest możliwa.
Ten problem zazwyczaj występuje, jeśli kategoria została dodana do strony przez szablon.',
	'inlinecategorizer-edit-category-summary' => 'Zmiana kategorii z „$1“ na „$2“',
	'inlinecategorizer-error-title' => 'Błąd',
	'inlinecategorizer-remove-category' => 'Usuń z kategorii',
	'inlinecategorizer-remove-category-error' => 'Usunięcie strony z kategorii „$1“ nie jest możliwe.
Problem zazwyczaj występuje, jeśli kategoria została dodana do strony przez szablon.',
	'inlinecategorizer-remove-category-summary' => 'Usuń kategorię „$1”',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'inlinecategorizer-add-category' => 'Gionta categorìa',
	'inlinecategorizer-add-category-submit' => 'Gionta',
	'inlinecategorizer-add-category-summary' => 'Gionta la categorìa "$1"',
	'inlinecategorizer-confirm-save' => 'Salva',
	'inlinecategorizer-confirm-title' => 'Conferma assion',
	'inlinecategorizer-error-title' => 'Eror',
	'inlinecategorizer-remove-category-error' => "A l'era pa possìbil gavé sta categorìa-sì.
Sòn-sì a càpita normalment quand la categorìa a l'é stàita giontà a la pàgina ant në stamp.",
	'inlinecategorizer-remove-category-summary' => 'Gava la categorìa "$1"',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'inlinecategorizer-add-category' => 'گٹھ رلاؤ',
	'inlinecategorizer-add-category-submit' => 'ملاؤ',
	'inlinecategorizer-add-category-summary' => 'گٹھ "$1" رلاؤ',
	'inlinecategorizer-api-error' => 'اے پی آئی نے اک غلطی ٹوری اے:$1: $2.',
	'inlinecategorizer-api-unknown-error' => 'اے پی آئی نے اک انجان غلطی ٹوری اے۔',
	'inlinecategorizer-cancel' => 'تبدیلیاں مکاؤ',
	'inlinecategorizer-cancel-all' => 'ساریاں تبدیلیاں مٹاؤ',
	'inlinecategorizer-category-already-present' => 'ایس صفے تے پہلے ای "$1" گٹھ دتی گئی اے۔',
	'inlinecategorizer-category-hook-error' => 'اک لوکل کم نے تبدیلیاں نوں بچان توں روک دتا اے۔',
	'inlinecategorizer-category-question' => 'تسیں تھلے دتیاں تبدیلیاں کیوں کرنا چاندے او:',
	'inlinecategorizer-confirm-ok' => 'اوکے',
	'inlinecategorizer-confirm-save' => 'بچاؤ',
	'inlinecategorizer-confirm-save-all' => 'ساریاں تبدیلیاں بچاؤ',
	'inlinecategorizer-confirm-title' => 'کم کنفرم کرو',
	'inlinecategorizer-edit-category' => 'گٹھ بدلو',
	'inlinecategorizer-edit-category-error' => 'ایہ ممکن نئیں جے گٹھ "$1". نوں بدلۓ۔
اے اودوں ہوندا اے جدوں گٹھ جوڑی دی صفے چ ٹمپلیٹ چ۔',
	'inlinecategorizer-edit-category-summary' => 'گٹھ "$1" نوں "$2" چ پرتو',
	'inlinecategorizer-error-title' => 'غلطی',
	'inlinecategorizer-remove-category' => 'گٹھ ہٹاؤ',
	'inlinecategorizer-remove-category-error' => 'اے نئیں ہوسکدا جے گٹھ "$1". نوں ہٹایا جاۓ۔
اے اودوں ہوندا اے جدوں گٹھ ٹمپلیٹ والے صفے تے جوڑی جاۓ۔',
	'inlinecategorizer-remove-category-summary' => 'گٹھ "$1" ہٹاؤ',
);

/** Prussian (Prūsiskan)
 * @author Nertiks
 */
$messages['prg'] = array(
	'inlinecategorizer-add-category' => 'Preidāis kategōrijan',
	'inlinecategorizer-add-category-submit' => 'Preidāis',
	'inlinecategorizer-add-category-summary' => 'Preidāis kategōrijan "$1"',
	'inlinecategorizer-confirm-save' => 'Enpeisāis',
	'inlinecategorizer-confirm-title' => 'Padruktinais dīlasenin',
	'inlinecategorizer-error-title' => 'Blānda',
	'inlinecategorizer-remove-category-summary' => 'Āupausinais kategōrijan "$1"',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'inlinecategorizer-add-category' => 'وېشنيزه ورګډول',
	'inlinecategorizer-add-category-submit' => 'ورګډول',
	'inlinecategorizer-add-category-summary' => 'د "$1" وېشنيزه ورګډول',
	'inlinecategorizer-confirm-save' => 'خوندي کول',
	'inlinecategorizer-error-title' => 'ستونزه',
	'inlinecategorizer-remove-category-summary' => 'د "$1" وېشنيزه ليرې کول',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'inlinecategorizer-add-category' => 'Adicionar categoria',
	'inlinecategorizer-add-category-submit' => 'Adicionar',
	'inlinecategorizer-add-category-summary' => 'adicionar a categoria "$1"',
	'inlinecategorizer-api-error' => 'A API retornou um erro: $1: $2',
	'inlinecategorizer-cancel' => 'Cancelar as edições',
	'inlinecategorizer-cancel-all' => 'Cancelar todas as alterações',
	'inlinecategorizer-category-already-present' => 'Esta página já está na categoria $1',
	'inlinecategorizer-category-hook-error' => 'Uma função local impediu que as alterações fossem gravadas',
	'inlinecategorizer-category-question' => 'Porque é que pretende fazer as seguintes alterações:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Gravar',
	'inlinecategorizer-confirm-save-all' => 'Gravar todas as alterações',
	'inlinecategorizer-confirm-title' => 'Confirme a operação',
	'inlinecategorizer-edit-category' => 'Editar categoria',
	'inlinecategorizer-edit-category-error' => 'Não foi possível editar a categoria "$1".
Isso normalmente ocorre quando a categoria foi adicionada à página através de uma predefinição.',
	'inlinecategorizer-edit-category-summary' => 'Alterar a categoria "$1" para "$2"',
	'inlinecategorizer-error-title' => 'Erro',
	'inlinecategorizer-remove-category' => 'Remover categoria',
	'inlinecategorizer-remove-category-error' => 'Não foi possível remover a categoria "$1".
Isto normalmente ocorre quando a categoria foi adicionada à página através de uma predefinição.',
	'inlinecategorizer-remove-category-summary' => 'remover a categoria "$1"',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Helder.wiki
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'inlinecategorizer-add-category' => 'Adicionar categoria',
	'inlinecategorizer-add-category-submit' => 'Adicionar',
	'inlinecategorizer-add-category-summary' => 'Adicionar categoria "$1"',
	'inlinecategorizer-api-error' => 'A API retornou um erro: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'A API retornou um erro desconhecido.',
	'inlinecategorizer-cancel' => 'Cancelar as edições',
	'inlinecategorizer-cancel-all' => 'Cancelar todas as alterações',
	'inlinecategorizer-category-already-present' => 'Esta página já está na categoria $1',
	'inlinecategorizer-category-hook-error' => 'Uma função local impediu que as alterações fossem salvas.',
	'inlinecategorizer-category-question' => 'Porque você pretende fazer as seguintes alterações:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Salvar',
	'inlinecategorizer-confirm-save-all' => 'Salvar todas as alterações',
	'inlinecategorizer-confirm-title' => 'Confirmar ação',
	'inlinecategorizer-edit-category' => 'Editar categoria',
	'inlinecategorizer-edit-category-error' => 'Não foi possível editar a categoria "$1".
Isso normalmente ocorre quando a categoria foi adicionada à página através de uma predefinição.',
	'inlinecategorizer-edit-category-summary' => 'Alterar a categoria "$1" para "$2"',
	'inlinecategorizer-error-title' => 'Erro',
	'inlinecategorizer-remove-category' => 'Remover categoria',
	'inlinecategorizer-remove-category-error' => 'Não foi possível remover a categoria "$1".
Isto normalmente ocorre quando a categoria foi adicionada à página através de uma predefinição.',
	'inlinecategorizer-remove-category-summary' => 'Remover categoria "$1"',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'inlinecategorizer-add-category' => 'Katiguriyata yapay',
	'inlinecategorizer-add-category-submit' => 'Yapay',
	'inlinecategorizer-add-category-summary' => '"$1" sutiyuq katiguriyata yapay',
	'inlinecategorizer-confirm-save' => 'Waqaychay',
	'inlinecategorizer-confirm-title' => 'Rurayta takyachiy',
	'inlinecategorizer-error-title' => 'Pantasqa',
	'inlinecategorizer-remove-category-error' => "Manam atinichu kay katiguriyata qichuyta.
Kay hina kanqaqa katiguriya plantillapi p'anqaman yapasqa kaptinchá.",
	'inlinecategorizer-remove-category-summary' => '"$1" sutiyuq katiguriyata qichuy',
);

/** Romansh (Rumantsch)
 * @author Gion-andri
 */
$messages['rm'] = array(
	'inlinecategorizer-add-category' => 'Agiuntar categoria',
	'inlinecategorizer-add-category-submit' => 'Agiuntar',
	'inlinecategorizer-add-category-summary' => 'Agiuntar la categoria "$1"',
	'inlinecategorizer-confirm-save' => 'Memorisar',
	'inlinecategorizer-error-title' => 'Errur',
	'inlinecategorizer-remove-category-error' => "I n'era betg pussaivel da stizzar questa categoria. 
Quai capita normalmain sche la categoria è vegnida integrada en in model.",
	'inlinecategorizer-remove-category-summary' => 'Allontanar la categoria "$1"',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'inlinecategorizer-desc' => 'Modul JavaScript care permite modificarea, adăugarea sau înlăturarea legăturilor către categorii direct dintr-o pagină',
	'inlinecategorizer-add-category' => 'Adaugă categorie',
	'inlinecategorizer-add-category-submit' => 'Adaugă',
	'inlinecategorizer-add-category-summary' => 'Adăugarea categoriei „$1”',
	'inlinecategorizer-api-error' => 'API a returnat o eroare: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API a returnat o eroare necunoscută.',
	'inlinecategorizer-cancel' => 'Anulează modificarea',
	'inlinecategorizer-cancel-all' => 'Anulează toate modificările',
	'inlinecategorizer-category-already-present' => 'Această pagină aparține deja categoriei $1',
	'inlinecategorizer-category-hook-error' => 'O funcție locală a împiedicat salvarea modificărilor',
	'inlinecategorizer-category-question' => 'De ce doriți să efectuați următoarele modificări:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Salvare',
	'inlinecategorizer-confirm-save-all' => 'Salvează toate schimbările',
	'inlinecategorizer-confirm-title' => 'Confirmați acțiunea',
	'inlinecategorizer-edit-category' => 'Modifică categoria',
	'inlinecategorizer-edit-category-error' => 'Modificarea categoriei „$1” nu a fost posibilă.
Acest lucru are loc de obicei atunci când categoria a fost adăugată în pagină printr-un format.',
	'inlinecategorizer-edit-category-summary' => 'Modificarea categoriei „$1” în „$2”',
	'inlinecategorizer-error-title' => 'Eroare',
	'inlinecategorizer-remove-category' => 'Elimină categoria',
	'inlinecategorizer-remove-category-error' => 'Eliminarea categoriei „$1” nu a fost posibilă.
Acest lucru are loc de obicei atunci când categoria a fost adăugată în pagină printr-un format.',
	'inlinecategorizer-remove-category-summary' => 'Eliminarea categoriei „$1”',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'inlinecategorizer-add-category' => "Aggiunge 'a categorije",
	'inlinecategorizer-add-category-submit' => 'Aggiunge',
	'inlinecategorizer-add-category-summary' => 'Aggiunge \'a categorije "$1"',
	'inlinecategorizer-api-error' => "L'API ha turnate 'n'errore: $1: $2",
	'inlinecategorizer-api-unknown-error' => "L'API ha turnate 'n'errore scanusciute",
	'inlinecategorizer-cancel' => "Annulle 'u cangiamende",
	'inlinecategorizer-cancel-all' => 'Annulle tutte le cangiaminde',
	'inlinecategorizer-category-already-present' => 'Sta pàgene già stè jndr\'à categorije "$1"',
	'inlinecategorizer-category-hook-error' => "'Na funziona locale non ge face fà le cangiaminde apprime de reggistrarle",
	'inlinecategorizer-category-question' => 'Purcè tu vuè ccu face ste cangiaminde:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Reggistre',
	'inlinecategorizer-confirm-save-all' => 'Reggistre tutte le cangiaminde',
	'inlinecategorizer-confirm-title' => "Conferme l'azione",
	'inlinecategorizer-edit-category' => "Cange 'a categorije",
	'inlinecategorizer-edit-category-error' => "Non g'è possibbele cangià 'a categorije \"\$1\".
Stu fatte normalmende succede quanne 'a categorije ha state aggiunde a 'a pàgene jndr'à 'nu template.",
	'inlinecategorizer-edit-category-summary' => 'Cange \'a categorije "$1" jndr\'à "$2"',
	'inlinecategorizer-error-title' => 'Errore',
	'inlinecategorizer-remove-category' => "Live 'a categorije",
	'inlinecategorizer-remove-category-error' => "Non g'è possibbele luà 'a categorije \"\$1\".
Stu fatte normalmende succede quanne 'a categorije ha state aggiunde a 'a pàgene jndr'à 'nu template.",
	'inlinecategorizer-remove-category-summary' => 'Live \'a categorije "$1"',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'inlinecategorizer-desc' => 'JavaScript-модуль, позволяющий изменять, добавлять и удалять ссылки на категории прямо со страницы',
	'inlinecategorizer-add-category' => 'Добавить категорию',
	'inlinecategorizer-add-category-submit' => 'Добавить',
	'inlinecategorizer-add-category-summary' => 'добавить категорию «$1»',
	'inlinecategorizer-api-error' => 'API возвратил ошибку: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API возвратил неизвестную ошибку.',
	'inlinecategorizer-cancel' => 'Отменить изменения',
	'inlinecategorizer-cancel-all' => 'Отменить все изменения',
	'inlinecategorizer-category-already-present' => 'Эта страница уже относится к данной категории $1',
	'inlinecategorizer-category-hook-error' => 'Локальная функция помешала сохранению изменений',
	'inlinecategorizer-category-question' => 'Почему вы хотите сделать следующие изменения:',
	'inlinecategorizer-confirm-ok' => 'ОК',
	'inlinecategorizer-confirm-save' => 'Сохранить',
	'inlinecategorizer-confirm-save-all' => 'Сохранить все изменения',
	'inlinecategorizer-confirm-title' => 'Подтвердить действие',
	'inlinecategorizer-edit-category' => 'Изменить категорию',
	'inlinecategorizer-edit-category-error' => 'Не удалось изменить категорию «$1».
Это обычно происходит, когда категория была добавлена на страницу с помощью шаблона.',
	'inlinecategorizer-edit-category-summary' => 'изменить категорию «$1» на «$2»',
	'inlinecategorizer-error-title' => 'Ошибка',
	'inlinecategorizer-remove-category' => 'Удалить категорию',
	'inlinecategorizer-remove-category-error' => 'Не удалось убрать категорию «$1».
Обычно это происходит в случае, когда категория была добавлена через шаблон.',
	'inlinecategorizer-remove-category-summary' => 'удалить категорию «$1»',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'inlinecategorizer-add-category' => 'Придати катеґорію',
	'inlinecategorizer-add-category-submit' => 'Придати',
	'inlinecategorizer-add-category-summary' => 'Придати катеґорію „$1“',
	'inlinecategorizer-api-error' => 'API вернуло хыбу: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API вернуло незнаму хыбу.',
	'inlinecategorizer-cancel' => 'Сторновати зміны',
	'inlinecategorizer-cancel-all' => 'Сторновати вшыткы зміны',
	'inlinecategorizer-category-already-present' => 'Тота сторінка уж належыть до катеґорії $1',
	'inlinecategorizer-category-hook-error' => 'Локална функція заборонила уложіню змін',
	'inlinecategorizer-category-question' => 'Чом хочете учінити наступны зміны:',
	'inlinecategorizer-confirm-ok' => 'ОК',
	'inlinecategorizer-confirm-save' => 'Уложыти',
	'inlinecategorizer-confirm-save-all' => 'Уложыти вшыткы зміны',
	'inlinecategorizer-confirm-title' => 'Підтвердити дїю',
	'inlinecategorizer-edit-category' => 'Управити катеґорію',
	'inlinecategorizer-edit-category-error' => 'Не подарило ся управити катеґорію „$1“.
Таке ся трафляtx звычайно тогды, qk катеґорія была додана до сторінкы через шаблону.',
	'inlinecategorizer-edit-category-summary' => 'Змінити катеґорію „$1“ на „$2“',
	'inlinecategorizer-error-title' => 'Хыба',
	'inlinecategorizer-remove-category' => 'Одстранити катеґорію',
	'inlinecategorizer-remove-category-error' => 'Не подарило ся одстранити катеґорію „$1“.
Таке ся трафляtx звычайно тогды, qk катеґорія была додана до сторінкы через шаблону.',
	'inlinecategorizer-remove-category-summary' => 'Одобрати катеґорію „$1“',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'inlinecategorizer-add-category' => 'Категория эбии',
	'inlinecategorizer-add-category-submit' => 'Эп',
	'inlinecategorizer-add-category-summary' => '«$1» категория эбилиннэ',
	'inlinecategorizer-api-error' => 'API алҕаһы төннөрдө (көрдөрдө): $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API биллибэт алҕаһы булла..',
	'inlinecategorizer-cancel' => 'Уларытыылары суох гын',
	'inlinecategorizer-cancel-all' => 'Уларытыылары барыларын суох гын',
	'inlinecategorizer-category-already-present' => 'Бу сирэй уруккуттан "$1" категорияҕа киирэр эбит',
	'inlinecategorizer-category-hook-error' => 'Уларытыы оҥоһулларыгар олохтоох (локал) функция мэһэй буолла.',
	'inlinecategorizer-category-question' => 'Бу уларытыылары тоҕо оҥороору гынаҕыный:',
	'inlinecategorizer-confirm-ok' => 'Сөп',
	'inlinecategorizer-confirm-save' => 'Бигэргэт',
	'inlinecategorizer-confirm-save-all' => 'Уларытыылары барыларын бигэргэт',
	'inlinecategorizer-confirm-title' => 'Дьайыыны бигэргэт',
	'inlinecategorizer-edit-category' => 'Категорияны уларыт',
	'inlinecategorizer-edit-category-error' => '«$1» категория сатаан уларыйбата.
Үксүгэр категория халыып көмөтүнэн эбиллибит буоллаҕына маннык буолар.',
	'inlinecategorizer-edit-category-summary' => '"$1" категорияны "$2" категорияҕа уларыт',
	'inlinecategorizer-error-title' => 'Алҕас',
	'inlinecategorizer-remove-category' => 'Категорияны сот',
	'inlinecategorizer-remove-category-error' => 'Бу "$1" категорияны сотор табыллыбата.
Үксүгэр категория халыып нөҥүө эбиллибит түгэнигэр итинник буолар.',
	'inlinecategorizer-remove-category-summary' => '«$1» категория сотулунна',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'inlinecategorizer-confirm-save' => 'Sarba',
	'inlinecategorizer-error-title' => 'Faddina',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'inlinecategorizer-add-category' => 'වර්ගයක් එකතු කරන්න',
	'inlinecategorizer-add-category-submit' => 'එකතු කරන්න',
	'inlinecategorizer-add-category-summary' => '"$1" වර්ගය ඇතුළත් කරන්න',
	'inlinecategorizer-confirm-save' => 'සුරකින්න',
	'inlinecategorizer-confirm-title' => 'ක්‍රියාව තහවුරු කරන්න',
	'inlinecategorizer-error-title' => 'දෝෂය',
	'inlinecategorizer-remove-category-error' => 'මෙම වර්ගය ඉවත් කිරීම කළ නොහැකි විය.
මෙය සාමාන්‍යයෙන් සිදු වන්නේ වර්ගය සැකිල්ලක ඇති පිටුවකට එකතු කර ඇති විටය.',
	'inlinecategorizer-remove-category-summary' => '"$1" වර්ගය ඉවත් කරන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'inlinecategorizer-add-category' => 'Pridať kategóriu',
	'inlinecategorizer-add-category-submit' => 'Pridať',
	'inlinecategorizer-add-category-summary' => 'Pridať kategóriu „$1“',
	'inlinecategorizer-confirm-save' => 'Uložiť',
	'inlinecategorizer-confirm-title' => 'Potvrdiť operáciu',
	'inlinecategorizer-error-title' => 'Chyba',
	'inlinecategorizer-remove-category-error' => 'Nebolo možné odstrániť túto kategóriu.
To sa zvyčajne stane, keď bola kategória pridaná na stránku v pomocou šablóny.',
	'inlinecategorizer-remove-category-summary' => 'Odstrániť kategóriu „$1“',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'inlinecategorizer-desc' => 'Modul JavaScript, ki omogoča spreminjanje, dodajanje in odstranjevanje povezav kategorij neposredno s strani',
	'inlinecategorizer-add-category' => 'Dodaj kategorijo',
	'inlinecategorizer-add-category-submit' => 'Dodaj',
	'inlinecategorizer-add-category-summary' => 'Dodati kategorijo »$1«',
	'inlinecategorizer-api-error' => 'API je vrnil napako: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API je vrnil neznano napako.',
	'inlinecategorizer-cancel' => 'Prekliči urejanja',
	'inlinecategorizer-cancel-all' => 'Prekliči vse spremembe',
	'inlinecategorizer-category-already-present' => 'Stran že pripada kategoriji $1',
	'inlinecategorizer-category-hook-error' => 'Lokalna funkcija je preprečila shranitev sprememb',
	'inlinecategorizer-category-question' => 'Zakaj želite narediti naslednje spremembe:',
	'inlinecategorizer-confirm-ok' => 'V redu',
	'inlinecategorizer-confirm-save' => 'Shrani',
	'inlinecategorizer-confirm-save-all' => 'Shrani vse spremembe',
	'inlinecategorizer-confirm-title' => 'Potrdi dejanje',
	'inlinecategorizer-edit-category' => 'Uredi kategorijo',
	'inlinecategorizer-edit-category-error' => 'Kategorije »$1« ni bilo mogoče urediti.
To se po navadi zgodi, ko je kategorija dodana strani preko predloge.',
	'inlinecategorizer-edit-category-summary' => 'Spremeniti kategorijo »$1« v »$2«',
	'inlinecategorizer-error-title' => 'Napaka',
	'inlinecategorizer-remove-category' => 'Odstrani kategorijo',
	'inlinecategorizer-remove-category-error' => 'Kategorije »$1« ni bilo mogoče odstraniti.
To se po navadi zgodi, ko je kategorija dodana strani v predlogi.',
	'inlinecategorizer-remove-category-summary' => 'Odstraniti kategorijo »$1«',
);

/** Lower Silesian (Schläsch)
 * @author Schläsinger
 */
$messages['sli'] = array(
	'inlinecategorizer-add-category' => 'Kategorie hinzufiega',
	'inlinecategorizer-add-category-submit' => 'Hinzufügen',
	'inlinecategorizer-add-category-summary' => 'Kategorie „$1“ hinzufiega',
	'inlinecategorizer-confirm-save' => 'Speichern',
	'inlinecategorizer-confirm-title' => 'Aksjonn bestätiga',
	'inlinecategorizer-error-title' => 'Fahler',
	'inlinecategorizer-remove-category-error' => 'Is woar ne meeglich, de Kategorie zu entferna.
Dies passiert normalerweise, wenn de Kategorie ieber anne Vurloage eingebunda ies.',
	'inlinecategorizer-remove-category-summary' => 'Kategorie „$1“ entferna',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Slaven Kosanovic
 */
$messages['sr-ec'] = array(
	'inlinecategorizer-add-category' => 'Додај категорију',
	'inlinecategorizer-add-category-submit' => 'Додај',
	'inlinecategorizer-add-category-summary' => 'Додај категорију "$1"',
	'inlinecategorizer-api-error' => 'АПИ је пријавио грешку: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'АПИ је пријавио непознату грешку.',
	'inlinecategorizer-cancel' => 'Откажи уређивање',
	'inlinecategorizer-cancel-all' => 'Откажи све измене',
	'inlinecategorizer-category-already-present' => 'Ова страница већ припада категорији „$1“',
	'inlinecategorizer-category-hook-error' => 'Локална функција је спречила да се измене сачувају.',
	'inlinecategorizer-category-question' => 'Разлог за стварање измена:',
	'inlinecategorizer-confirm-ok' => 'У реду',
	'inlinecategorizer-confirm-save' => 'Сачувај',
	'inlinecategorizer-confirm-save-all' => 'Сачувај све измене',
	'inlinecategorizer-confirm-title' => 'Потврди акцију',
	'inlinecategorizer-edit-category' => 'Уреди категорију',
	'inlinecategorizer-edit-category-error' => 'Не могу да променим категорију „$1“.
Ово се обично дешава када је категорија додата на страницу преко шаблона.',
	'inlinecategorizer-edit-category-summary' => 'Промени категорију „$1“ у „$2“',
	'inlinecategorizer-error-title' => 'Грешка',
	'inlinecategorizer-remove-category' => 'Уклони категорију',
	'inlinecategorizer-remove-category-error' => 'Не могу да уклоним категорију „$1“.
Ово се обично дешава када је категорија додата на страницу преко шаблона.',
	'inlinecategorizer-remove-category-summary' => 'Уклони категорију "$1"',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Liangent
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'inlinecategorizer-add-category' => 'Dodaj kategoriju',
	'inlinecategorizer-add-category-submit' => 'Dodaj',
	'inlinecategorizer-add-category-summary' => 'Dodaj kategoriju "$1"',
	'inlinecategorizer-api-error' => 'API je prijavio grešku: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API je prijavio nepoznatu grešku.',
	'inlinecategorizer-cancel' => 'Otkaži uređivanje',
	'inlinecategorizer-cancel-all' => 'Otkaži sve izmene',
	'inlinecategorizer-category-already-present' => 'Ova stranica već pripada kategoriji „$1“',
	'inlinecategorizer-category-hook-error' => 'Lokalna funkcija je sprečila da se izmene sačuvaju.',
	'inlinecategorizer-category-question' => 'Razlog za stvaranje izmena:',
	'inlinecategorizer-confirm-ok' => 'U redu',
	'inlinecategorizer-confirm-save' => 'Sačuvaj',
	'inlinecategorizer-confirm-save-all' => 'Sačuvaj sve izmene',
	'inlinecategorizer-confirm-title' => 'Potvrdi akciju',
	'inlinecategorizer-edit-category' => 'Uredi kategoriju',
	'inlinecategorizer-edit-category-error' => 'Ne mogu da promenim kategoriju „$1“.
Ovo se obično dešava kada je kategorija dodata na stranicu preko šablona.',
	'inlinecategorizer-edit-category-summary' => 'Promeni kategoriju „$1“ u „$2“',
	'inlinecategorizer-error-title' => 'Greška',
	'inlinecategorizer-remove-category' => 'Ukloni kategoriju',
	'inlinecategorizer-remove-category-error' => 'Ne mogu da uklonim kategoriju „$1“.
Ovo se obično dešava kada je kategorija dodata na stranicu preko šablona.',
	'inlinecategorizer-remove-category-summary' => 'Ukloni kategoriju "$1"',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'inlinecategorizer-add-category' => 'Kategorie bietouföigje',
	'inlinecategorizer-add-category-submit' => 'Bietouföigje',
	'inlinecategorizer-add-category-summary' => 'Kategorie „$1“ bietouföigje',
	'inlinecategorizer-confirm-save' => 'Spiekerje',
	'inlinecategorizer-confirm-title' => 'Aktion bestäätigje',
	'inlinecategorizer-error-title' => 'Failer',
	'inlinecategorizer-remove-category-error' => 'Dät waas nit muugelk, ju Kategorie wächtouhoaljen.
Dät passiert normoalerwiese, wan ju Kategorie uur ne Foarloage an ju Siede bietouföiged is',
	'inlinecategorizer-remove-category-summary' => 'Kategorie „$1“ wächhoalje',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'inlinecategorizer-add-category' => 'Tambah kategori',
	'inlinecategorizer-add-category-submit' => 'Tambah',
	'inlinecategorizer-add-category-summary' => 'Tambah kategori "$1"',
	'inlinecategorizer-cancel' => 'Bolaykeun éditan',
	'inlinecategorizer-cancel-all' => 'Bolaykeun sakabéh parobahan',
	'inlinecategorizer-category-already-present' => 'Ieu kaca geus diasupkeun kana katégori "$1"',
	'inlinecategorizer-confirm-ok' => 'Heug',
	'inlinecategorizer-confirm-save' => 'Simpen',
	'inlinecategorizer-confirm-save-all' => 'Simpen sakabéh parobahan',
	'inlinecategorizer-edit-category' => 'Édit katégori',
	'inlinecategorizer-error-title' => 'Éror',
	'inlinecategorizer-remove-category' => 'Hapus katégori',
	'inlinecategorizer-remove-category-error' => 'Ieu kategori teu mungkin dihapus.
Hal ieu ilaharna dilarapkeun kana kategori anu ditambahkeun kana citakan.',
	'inlinecategorizer-remove-category-summary' => 'Hapus kategori "$1"',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Poxnar
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'inlinecategorizer-add-category' => 'Lägg till kategori',
	'inlinecategorizer-add-category-submit' => 'Lägg till',
	'inlinecategorizer-add-category-summary' => 'Lägg till kategorin "$1"',
	'inlinecategorizer-api-error' => 'API rapporterade ett fel: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API returnerade ett okänt fel.',
	'inlinecategorizer-cancel' => 'Avbryt redigering',
	'inlinecategorizer-cancel-all' => 'Avbryt alla ändringar',
	'inlinecategorizer-category-already-present' => 'Denna sida tillhör redan kategorin $1',
	'inlinecategorizer-category-hook-error' => 'En lokal funktion förhindrade ändringarna från att sparas.',
	'inlinecategorizer-category-question' => 'Varför vill du göra följande ändringar:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Spara',
	'inlinecategorizer-confirm-save-all' => 'Spara alla ändringar',
	'inlinecategorizer-confirm-title' => 'Bekräfta handling',
	'inlinecategorizer-edit-category' => 'Redigera kategori',
	'inlinecategorizer-edit-category-error' => 'Det gick inte att redigera kategorin "$1".
Detta inträffar vanligen när kategorin har lagts till sidan i en mall.',
	'inlinecategorizer-edit-category-summary' => 'Ändra kategori "$1" till "$2"',
	'inlinecategorizer-error-title' => 'Fel',
	'inlinecategorizer-remove-category' => 'Ta bort kategori',
	'inlinecategorizer-remove-category-error' => 'Det var inte möjligt att ta bort kategorin "$1".
Oftast beror det på att kategorin har lagts till genom användande av en mall.',
	'inlinecategorizer-remove-category-summary' => 'Tag bort kategorin "$1"',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'inlinecategorizer-add-category' => 'Ongeza jamii',
	'inlinecategorizer-add-category-submit' => 'Ongeza',
	'inlinecategorizer-add-category-summary' => 'Ongeza jamii ya "$1"',
	'inlinecategorizer-api-error' => 'API iliripoti hitilafu: $1: $2.',
	'inlinecategorizer-api-unknown-error' => 'API iliripoti hitilafu isiyojulikana.',
	'inlinecategorizer-cancel' => 'Futa maharirio',
	'inlinecategorizer-cancel-all' => 'Futa mabadiliko yote',
	'inlinecategorizer-category-already-present' => 'Ukarasa huu tayari uko katika jamii ya $1',
	'inlinecategorizer-category-question' => 'Kwa nini unataka kufanya mabadiliko yafuatayo:',
	'inlinecategorizer-confirm-ok' => 'Sawa',
	'inlinecategorizer-confirm-save' => 'Hifadhi',
	'inlinecategorizer-confirm-save-all' => 'Hifadhi mabadiliko yote',
	'inlinecategorizer-confirm-title' => 'Uthibitishe kitendo',
	'inlinecategorizer-edit-category' => 'Hariri jamii',
	'inlinecategorizer-edit-category-error' => 'Ilikuwa si ​​rahisi kuhariri jamii ya "$1". 
Hii kwa kawaida hutokea wakati jamii imekuwa imeingizwa katika ukurasa ndani ya kigezo.',
	'inlinecategorizer-edit-category-summary' => 'Jamii ya "$1" imebadilishwa iwe "$2"',
	'inlinecategorizer-error-title' => 'Hitilafu',
	'inlinecategorizer-remove-category' => 'Ondoa jamii',
	'inlinecategorizer-remove-category-error' => ' Jamii "$1" haikuweza kuondolewa.
Huwa jamii haiwezi kuondolewa kwenye ukurasa wakati jamii imeingizwa ndani ya kigezo fulani.',
	'inlinecategorizer-remove-category-summary' => 'Ondoa jamii ya "$1"',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'inlinecategorizer-add-category' => 'వర్గాన్ని చేర్చండి',
	'inlinecategorizer-add-category-submit' => 'చేర్చు',
	'inlinecategorizer-add-category-summary' => '"$1" వర్గాన్ని చేర్చండి',
	'inlinecategorizer-cancel' => 'మార్పుని రద్దు చేయి',
	'inlinecategorizer-cancel-all' => 'అన్ని మార్పులను రద్దు చేయి',
	'inlinecategorizer-category-already-present' => 'ఈ పుట ఇప్పటికీ "$1" వర్గంలో ఉంది',
	'inlinecategorizer-category-question' => 'మీరు ఈ క్రింది మార్పులను ఎందుకు చేయాలనుకుంటున్నారు:',
	'inlinecategorizer-confirm-ok' => 'సరే',
	'inlinecategorizer-confirm-save' => 'భద్రపరచు',
	'inlinecategorizer-confirm-save-all' => 'అన్ని మార్పులను భద్రపరచు',
	'inlinecategorizer-confirm-title' => 'చర్యని నిర్ధారించండి',
	'inlinecategorizer-edit-category-summary' => 'వర్గాన్ని "$1" నుండి "$2"కి మార్చు',
	'inlinecategorizer-error-title' => 'పొరపాటు',
	'inlinecategorizer-remove-category' => 'వర్గాన్ని తొలగించు',
	'inlinecategorizer-remove-category-error' => '"$1" వర్గాన్ని తొలగించడం సాధ్యం కాలేదు.
పేజీకి ఆ వర్గం ఒక మూస ద్వారా చేరినప్పుడు సాధారణంగా ఇలా జరుగుతుంది.',
	'inlinecategorizer-remove-category-summary' => '"$1" వర్గాన్ని తొలగించండి',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'inlinecategorizer-add-category' => 'Илова кардани гурӯҳ',
	'inlinecategorizer-add-category-submit' => 'Илова кардан',
	'inlinecategorizer-add-category-summary' => 'Илова кардани гурӯҳи "$1"',
	'inlinecategorizer-confirm-save' => 'Захира',
	'inlinecategorizer-confirm-title' => 'Таъйиди амал',
	'inlinecategorizer-error-title' => 'Хато',
	'inlinecategorizer-remove-category-error' => 'Имкони ҳазви ин гурӯҳ вуҷуд надошт.
Ин иттифоқ маъмулан замоне меафтад, ки гурӯҳ аз тариқи як шаблон ба саҳифа изофа шуда бошад.',
	'inlinecategorizer-remove-category-summary' => 'Ҳазви гурӯҳӣ "$1"',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'inlinecategorizer-add-category' => 'Ilova kardani gurūh',
	'inlinecategorizer-add-category-submit' => 'Ilova kardan',
	'inlinecategorizer-add-category-summary' => 'Ilova kardani gurūhi "$1"',
	'inlinecategorizer-confirm-save' => 'Zaxira',
	'inlinecategorizer-confirm-title' => "Ta'jidi amal",
	'inlinecategorizer-error-title' => 'Xato',
	'inlinecategorizer-remove-category-error' => "Imkoni hazvi in gurūh vuçud nadoşt.
In ittifoq ma'mulan zamone meaftad, ki gurūh az tariqi jak şablon ba sahifa izofa şuda boşad.",
	'inlinecategorizer-remove-category-summary' => 'Hazvi gurūhī "$1"',
);

/** Thai (ไทย)
 * @author Ans
 * @author Octahedron80
 */
$messages['th'] = array(
	'inlinecategorizer-add-category' => 'เพิ่มหมวดหมู่',
	'inlinecategorizer-add-category-submit' => 'เพิ่ม',
	'inlinecategorizer-add-category-summary' => 'เพิ่มหมวดหมู่ "$1"',
	'inlinecategorizer-confirm-save' => 'บันทึก',
	'inlinecategorizer-confirm-title' => 'ยืนยันการกระทำ',
	'inlinecategorizer-error-title' => 'เกิดข้อผิดพลาด',
	'inlinecategorizer-remove-category-error' => 'ไม่สามารถลบหมวดหมู่นี้ได้
มักจะเกิดขึ้นอันเนื่องมาจากหมวดหมู่นี้ได้ถูกเพิ่มจากการเพิ่มแม่แบบเข้าไป',
	'inlinecategorizer-remove-category-summary' => 'นำหมวดหมู่ "$1" ออก',
);

/** Turkmen (Türkmençe)
 * @author Cekli829
 * @author Hanberke
 */
$messages['tk'] = array(
	'inlinecategorizer-add-category' => 'Kategoriýa goş',
	'inlinecategorizer-add-category-submit' => 'Goş',
	'inlinecategorizer-add-category-summary' => '"$1" kategoriýasyny goş',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Ýazdyr',
	'inlinecategorizer-confirm-title' => 'Işi tassykla',
	'inlinecategorizer-error-title' => 'Säwlik',
	'inlinecategorizer-remove-category-error' => 'Bu kategoriýany aýyryp bolmady.
Bu adatça kategoriýa sahypanyň içindäki bir şablona goşulgy bolsa ýüze çykýar.',
	'inlinecategorizer-remove-category-summary' => '"$1" kategoriýasyny aýyr',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 * @author Sky Harbor
 */
$messages['tl'] = array(
	'inlinecategorizer-add-category' => 'Magdagdag ng kategorya',
	'inlinecategorizer-add-category-submit' => 'Idagdag',
	'inlinecategorizer-add-category-summary' => 'Idagdag ang kategoryang "$1"',
	'inlinecategorizer-confirm-save' => 'Sagipin',
	'inlinecategorizer-confirm-title' => 'Tiyakin ang galaw',
	'inlinecategorizer-error-title' => 'Kamalian',
	'inlinecategorizer-remove-category-error' => 'Hindi naging maaari ang pagtanggal ng ganitong kategorya.
Karaniwang nagaganap ito kapag nadaragdag ang kategorya sa pahinang nasa loob ng isang suleras.',
	'inlinecategorizer-remove-category-summary' => 'Tanggalin ang kategoryang "$1"',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Srhat
 */
$messages['tr'] = array(
	'inlinecategorizer-add-category' => 'Kategori ekle',
	'inlinecategorizer-add-category-submit' => 'Ekle',
	'inlinecategorizer-add-category-summary' => '"$1" kategorisini ekle',
	'inlinecategorizer-cancel' => 'Düzenlemeyi iptal et',
	'inlinecategorizer-cancel-all' => 'Tüm değişiklikleri iptal et',
	'inlinecategorizer-confirm-ok' => 'TAMAM',
	'inlinecategorizer-confirm-save' => 'Kaydet',
	'inlinecategorizer-confirm-save-all' => 'Tüm değişiklikleri kaydet',
	'inlinecategorizer-confirm-title' => 'İşlemi onayla',
	'inlinecategorizer-edit-category' => 'Kategori düzenle',
	'inlinecategorizer-error-title' => 'Hata',
	'inlinecategorizer-remove-category' => 'Kategoriyi kaldır',
	'inlinecategorizer-remove-category-error' => 'Kategori silinemiyor. 
Bu genelde kategori sayfaya bir şablon aracılığıyla eklendiğinde meydana gelir.',
	'inlinecategorizer-remove-category-summary' => '"$1" kategorisini kaldır',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ajdar
 * @author Don Alessandro
 * @author KhayR
 */
$messages['tt-cyrl'] = array(
	'inlinecategorizer-add-category' => 'Бүлек өстәргә',
	'inlinecategorizer-add-category-submit' => 'Өстәргә',
	'inlinecategorizer-confirm-save' => 'Саклау',
	'inlinecategorizer-error-title' => 'Хата',
	'inlinecategorizer-remove-category-error' => 'Бу бүлекне алып ташлап булмады.
Гадәттә калып аша өстәлгән бүлекләрдә шушындый хаталар чыга.',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Sahran
 */
$messages['ug-arab'] = array(
	'inlinecategorizer-add-category' => 'تۈر قوش',
	'inlinecategorizer-add-category-submit' => 'قوش',
	'inlinecategorizer-add-category-summary' => '"$1" تۈرنى قوش',
	'inlinecategorizer-confirm-save' => 'ساقلا',
	'inlinecategorizer-confirm-title' => 'ھەرىكەت جەزملە',
	'inlinecategorizer-error-title' => 'خاتالىق',
	'inlinecategorizer-remove-category-error' => 'بۇ تۈرنى چىقىرىۋەتكىلى بولمايدۇ.
مەلۇم بىر قېلىپقا بۇ تۈر قوشۇلغان بولسا مۇشۇ خىل ئەھۋال يۈز بېرىدۇ.',
	'inlinecategorizer-remove-category-summary' => '"$1" تۈرنى چىقىرىۋەت',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Dim Grits
 * @author Тест
 */
$messages['uk'] = array(
	'inlinecategorizer-add-category' => 'Додати категорію',
	'inlinecategorizer-add-category-submit' => 'Додати',
	'inlinecategorizer-add-category-summary' => 'Додати категорію „$1“',
	'inlinecategorizer-api-error' => 'API повернув помилку: $1: $2 .',
	'inlinecategorizer-api-unknown-error' => 'API сповістив про невідому помилку.',
	'inlinecategorizer-cancel' => 'Скасувати правку',
	'inlinecategorizer-cancel-all' => 'Скасувати всі зміни',
	'inlinecategorizer-category-already-present' => 'Ця сторінка вже належить до категорії "$1"',
	'inlinecategorizer-category-hook-error' => 'Локальної функція перешкодила застосуванню змін.',
	'inlinecategorizer-category-question' => 'Чому ви хочете зробити наступні зміни:',
	'inlinecategorizer-confirm-ok' => 'Готово',
	'inlinecategorizer-confirm-save' => 'Зберегти',
	'inlinecategorizer-confirm-save-all' => 'Зберегти всі зміни',
	'inlinecategorizer-confirm-title' => 'Підтвердити дію',
	'inlinecategorizer-edit-category' => 'Змінити категорію',
	'inlinecategorizer-edit-category-error' => 'Не вдалося змінити категорію "$1".
Це зазвичай відбувається, коли категорію було додано до сторінки за допомогою шаблона.',
	'inlinecategorizer-edit-category-summary' => 'Змінити категорію "$1" на "$2"',
	'inlinecategorizer-error-title' => 'Помилка',
	'inlinecategorizer-remove-category' => 'Вилучити категорію',
	'inlinecategorizer-remove-category-error' => 'Не вдалося вилучити категорію "$1".
Таке трапляється зазвичай тоді, коли категорія додається в статтю через шаблон.',
	'inlinecategorizer-remove-category-summary' => 'Вилучити категорію „$1“',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'inlinecategorizer-add-category' => 'Zonta categoria',
	'inlinecategorizer-add-category-submit' => 'Zonta',
	'inlinecategorizer-add-category-summary' => 'Zonta categoria "$1"',
	'inlinecategorizer-confirm-save' => 'Salva',
	'inlinecategorizer-confirm-title' => "Conferma l'azion",
	'inlinecategorizer-error-title' => 'Eròr',
	'inlinecategorizer-remove-category-error' => 'No se gà podesto cavar sta categoria.
De solito questo el càpita co che la categoria la xe stà zontà a la pagina par via de un modèl.',
	'inlinecategorizer-remove-category-summary' => 'Cava categoria "$1"',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'inlinecategorizer-add-category' => 'Ližata kategorii',
	'inlinecategorizer-add-category-submit' => 'Ližata',
	'inlinecategorizer-add-category-summary' => 'Ližata "$1"-kategorii',
	'inlinecategorizer-confirm-save' => 'Panda muštho',
	'inlinecategorizer-confirm-title' => 'Vahvištoitta tegend',
	'inlinecategorizer-error-title' => 'Petuz',
	'inlinecategorizer-remove-category-error' => 'Ei voi čuta kategorijad poiš.
Nece voib olda, ku kategorii om ližatud šablonan turbiš.',
	'inlinecategorizer-remove-category-summary' => 'Čuta poiš "$1"-kategorii',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'inlinecategorizer-add-category' => 'Thêm thể loại',
	'inlinecategorizer-add-category-submit' => 'Thêm',
	'inlinecategorizer-add-category-summary' => 'Thêm thể loại “$1”',
	'inlinecategorizer-api-error' => 'API cho ra lỗi: $1: $2',
	'inlinecategorizer-api-unknown-error' => 'API cho ra một lỗi bất ngờ.',
	'inlinecategorizer-cancel' => 'Hủy bỏ các sửa đổi',
	'inlinecategorizer-cancel-all' => 'Hủy bỏ tất cả thay đổi',
	'inlinecategorizer-category-already-present' => 'Trang này đã nằm trong thể loại “$1”.',
	'inlinecategorizer-category-hook-error' => 'Một hàm địa phương năng đã chặn không lưu được những thay đổi',
	'inlinecategorizer-category-question' => 'Tại sao bạn muốn thực hiện những thay đổi sau:',
	'inlinecategorizer-confirm-ok' => 'OK',
	'inlinecategorizer-confirm-save' => 'Lưu',
	'inlinecategorizer-confirm-save-all' => 'Lưu tất cả thay đổi',
	'inlinecategorizer-confirm-title' => 'Xác nhận tác vụ',
	'inlinecategorizer-edit-category' => 'Sửa thể loại',
	'inlinecategorizer-edit-category-error' => 'Không thể sửa đổi thể loại “$1”.
Điều này thường xảy ra khi thể loại được thêm vào trang thông qua một bản mẫu.',
	'inlinecategorizer-edit-category-summary' => 'Thay thể loại “$1” bằng “$2”',
	'inlinecategorizer-error-title' => 'Lỗi',
	'inlinecategorizer-remove-category' => 'Gỡ thể loại',
	'inlinecategorizer-remove-category-error' => 'Không thể gỡ bỏ thể loại “$1”.
Điều này thường xảy ra khi thể loại được thêm vào trang thông qua một bản mẫu.',
	'inlinecategorizer-remove-category-summary' => 'Gỡ thể loại “$1”',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'inlinecategorizer-add-category-submit' => 'Läükön',
	'inlinecategorizer-add-category-summary' => 'Läükön kladi: "$1"',
	'inlinecategorizer-confirm-save' => 'Dakipön',
	'inlinecategorizer-confirm-save-all' => 'Dakipön votükamis valik',
	'inlinecategorizer-edit-category' => 'Redakön kladi',
	'inlinecategorizer-error-title' => 'Pöl',
	'inlinecategorizer-remove-category-summary' => 'Moükön kladi: "$1"',
);

/** Kalmyk (Хальмг)
 * @author Huuchin
 */
$messages['xal'] = array(
	'inlinecategorizer-add-category' => 'Әәшлиг немх',
	'inlinecategorizer-add-category-submit' => 'Немх',
	'inlinecategorizer-confirm-save' => 'Хадһлх',
	'inlinecategorizer-error-title' => 'Эндү',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'inlinecategorizer-add-category' => 'צולייגן קאַטעגאריע',
	'inlinecategorizer-add-category-submit' => 'צולייגן',
	'inlinecategorizer-add-category-summary' => 'צולייגן קאַטעגאריע "$1"',
	'inlinecategorizer-confirm-save' => 'אויפֿהיטן',
	'inlinecategorizer-error-title' => 'גרײַז',
	'inlinecategorizer-remove-category-summary' => 'אַוועקנעמען קאַטעגאריע "$1"',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'inlinecategorizer-add-category' => '加分類',
	'inlinecategorizer-add-category-submit' => '加',
	'inlinecategorizer-add-category-summary' => '加入分類「$1」',
	'inlinecategorizer-confirm-save' => '儲存',
	'inlinecategorizer-confirm-title' => '確認動作',
	'inlinecategorizer-error-title' => '錯誤',
	'inlinecategorizer-remove-category-error' => '唔能夠拎走呢個分類。
通常係發生響一個模度加入咗嗰個分類。',
	'inlinecategorizer-remove-category-summary' => '拎走分類「$1」',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author PhiLiP
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'inlinecategorizer-add-category' => '加入分类',
	'inlinecategorizer-add-category-submit' => '添加',
	'inlinecategorizer-add-category-summary' => '加入分类“$1”',
	'inlinecategorizer-api-error' => 'API返回了错误：$1：$2。',
	'inlinecategorizer-api-unknown-error' => 'API返回了未知错误。',
	'inlinecategorizer-cancel' => '取消编辑',
	'inlinecategorizer-cancel-all' => '取消所有更改',
	'inlinecategorizer-category-already-present' => '分类“$1”下已有该页面',
	'inlinecategorizer-category-hook-error' => '本地的一则函数阻止了保存更改的操作。',
	'inlinecategorizer-category-question' => '您为什么要进行以下修改：',
	'inlinecategorizer-confirm-ok' => '确定',
	'inlinecategorizer-confirm-save' => '保存',
	'inlinecategorizer-confirm-save-all' => '保存所有更改',
	'inlinecategorizer-confirm-title' => '确认动作',
	'inlinecategorizer-edit-category' => '编辑类别',
	'inlinecategorizer-edit-category-error' => '不能编辑分类“$1”。这通常是由于该分类是随模板加入页面的。',
	'inlinecategorizer-edit-category-summary' => '更改类别 "$1" 至 "$2"',
	'inlinecategorizer-error-title' => '错误',
	'inlinecategorizer-remove-category' => '删除类别',
	'inlinecategorizer-remove-category-error' => '不能移除分类“$1”。这通常是由于该分类是随模板加入页面的。',
	'inlinecategorizer-remove-category-summary' => '移除分类“$1”',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'inlinecategorizer-add-category' => '加入分類',
	'inlinecategorizer-add-category-submit' => '加入',
	'inlinecategorizer-add-category-summary' => '加入分類「$1」',
	'inlinecategorizer-api-error' => 'API返回了錯誤：$1：$2。',
	'inlinecategorizer-api-unknown-error' => 'API返回了未知錯誤。',
	'inlinecategorizer-cancel' => '取消編輯',
	'inlinecategorizer-cancel-all' => '取消所有更改',
	'inlinecategorizer-category-already-present' => '分類“$1”下已有該頁面',
	'inlinecategorizer-category-hook-error' => '本地的一則函數阻止了保存更改的操作。',
	'inlinecategorizer-category-question' => '您為什麼要進行以下修改：',
	'inlinecategorizer-confirm-ok' => '確定',
	'inlinecategorizer-confirm-save' => '儲存',
	'inlinecategorizer-confirm-save-all' => '保存所有更改',
	'inlinecategorizer-confirm-title' => '確認動作',
	'inlinecategorizer-edit-category' => '編輯類別',
	'inlinecategorizer-edit-category-error' => '不能編輯分類“$1”。這通常是由於該分類是隨模板加入頁面的。',
	'inlinecategorizer-edit-category-summary' => '更改類別 "$1" 至 "$2"',
	'inlinecategorizer-error-title' => '錯誤',
	'inlinecategorizer-remove-category' => '刪除類別',
	'inlinecategorizer-remove-category-error' => '不能移除分類“$1”。這通常是由於該分類是隨模板加入頁面的。',
	'inlinecategorizer-remove-category-summary' => '移除分類「$1」',
);

