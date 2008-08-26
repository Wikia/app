<?php

/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) 2008, PediaPress GmbH
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

$messages = array();

$messages['en'] = array(
	'coll-desc'                       => '[[Special:Collection|Collect pages]], generate PDFs',
	'coll-collection'                 => 'Collection', # do not translate or duplicate this message to other languages
	'coll-collections'                => 'Collections',
	'coll-portlet_title'              => 'My collection',
	'coll-add_page'                   => 'Add page',
	'coll-remove_page'                => 'Remove page',
	'coll-add_category'               => 'Add category',
	'coll-load_collection'            => 'Load collection',
	'coll-show_collection'            => 'Show collection',
	'coll-help_collections'           => 'Collections help',
	'coll-empty'                      => 'empty',
	'coll-page'                       => 'page',
	'coll-pages'                      => 'pages',
	'coll-download_as'                => 'Download as $1',
	'coll-noscript_text'              => '<h1>JavaScript is required!</h1>
<strong>Your browser does not support JavaScript or JavaScript has been turned off.
This page will not work correctly, unless JavaScript is enabled.</strong>',
	'coll-intro_text'                 => "You can collect pages, generate and download a PDF file from page collections and save page collections for later use or to share them.

See the [[{{MediaWiki:Coll-helppage}}|help page about collections]] for more information.",
	'coll-helppage'                   => 'Help:Collections',
	'coll-too_big_cat'                => 'The category contains more than %PARAM% pages, only the first %PARAM% pages can be added to your collection.
Do you want to add them?',
	'coll-my_collection'              => 'My collection',
	'coll-download_title'             => 'Download collection',
	'coll-download_text'              => 'To download an automatically generated document of your page collection, choose a format and click the button.',
	'coll-download'                   => 'Download',
	'coll-format_label'               => 'Format:',
	'coll-remove'                     => 'Remove',
	'coll-move_to_top'                => 'Move to top',
	'coll-move_up'                    => 'Move up',
	'coll-move_down'                  => 'Move down',
	'coll-move_to_bottom'             => 'Move to bottom',
	'coll-title'                      => 'Title:',
	'coll-subtitle'                   => 'Subtitle:',
	'coll-contents'                   => 'Contents',
	'coll-create_chapter'             => 'Create new chapter',
	'coll-sort_alphabetically'        => 'Sort pages alphabetically',
	'coll-clear_collection'           => 'Clear collection',
	'coll-clear_confirm'              => 'Do you really want to clear your collection?',
	'coll-rename'                     => 'Rename',
	'coll-new_chapter'                => 'Enter name for new chapter',
	'coll-rename_chapter'             => 'Enter new name for chapter',
	'coll-no_such_category'           => 'No such category',
	'coll-notitle_title'              => 'Could not get page title',
	'coll-notitle_title'              => 'The title of the page could not be determined.',
	'coll-post_failed_title'          => 'POST request failed',
	'coll-post_failed_msg'            => 'The POST request to $1 failed ($2).',
	'coll-pdfserver_failed_title'     => 'PDF server error',
	'coll-pdfserver_failed_msg'       => 'An error occured on the PDF Server: $1',
	'coll-enter_title'                => 'Enter title for collection:',
	'coll-error_reponse'              => 'Error response from server',
	'coll-empty_collection'           => 'Empty collection',
	'coll-revision'                   => 'Revision: %PARAM%',
	'coll-save_collection_title'      => 'Save collection',
	'coll-save_collection_text'       => 'To save this collection for later use, choose a collection type and enter a page title:',
	'coll-login_to_save'              => 'If you want to save collections for later use, please [[Special:Userlogin|log in or create an account]].',
	'coll-personal_collection_label'  => 'Personal collection:',
	'coll-community_collection_label' => 'Community collection:',
	'coll-save_collection'            => 'Save collection',
	'coll-overwrite_title'            => 'Page exists.
Overwrite?',
	'coll-overwrite_text'             => 'A page with the name [[:$1]] already exists.
Do you want it to be replaced with your collection?',
	'coll-yes'                        => 'Yes',
	'coll-no'                         => 'No',
	'coll-load_overwrite_text'        => 'You already have some pages in your collection.
Do want to overwrite your current collection, append the new content or cancel?',
	'coll-overwrite'                  => 'Overwrite',
	'coll-append'                     => 'Append',
	'coll-cancel'                     => 'Cancel',
	'coll-limit_exceeded_title'       => 'Collection too big',
	'coll-limit_exceeded_text'        => 'Your page collection is too big.
No more pages can be added.',
	'coll-rendering_title'            => 'Rendering',
	'coll-rendering_text'             => "'''Please wait while the document is being generated.'''

Progress: '''$1%'''.

This page should automatically refresh every few seconds.
If this does not work, please press refresh button of your browser.",
	'coll-rendering_finished_title'   => 'Rendering finished',
	'coll-rendering_finished_text'    => "'''The document file has been generated.'''
[$1 Click here] to download it to your computer.

Not satisfied with the output?
See [[{{MediaWiki:Coll-helppage}}|the help page about collections]] for possibilities to improve it.",
	'coll-notfound_title'             => 'Collection not found',
	'coll-notfound_text'              => 'Could not find collection page.',
	'coll-return_to_collection'       => 'Return to <a href="$1">$2</a>',
	'coll-book_title'                 => 'Order printed book',
	'coll-book_text'                  => 'You can order a printed book containing your page collection by visiting one of the following print-on-demand partners:',
	'coll-order_from_pp'              => 'Order book from $1',
	'coll-about_pp'                   => 'About $1',
	'coll-invalid_podpartner_title'   => 'Invalid POD partner',
	'coll-invalid_podpartner_msg'     => 'The supplied POD partner is invalid.
Please contact your MediaWiki administrator.',
	'coll-license'                    => 'License',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'coll-cancel'   => "Mao'ạki",
	'coll-about_pp' => 'Hün se $1',
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'coll-cancel' => 'Keskevytä',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'coll-page'   => 'лаштык',
	'coll-cancel' => 'Чараш',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'coll-cancel' => 'Tiaki',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author SPQRobin
 * @author Naudefj
 */
$messages['af'] = array(
	'coll-collections'                => 'Versamelings',
	'coll-portlet_title'              => 'My versameling',
	'coll-add_page'                   => 'Voeg bladsy by',
	'coll-remove_page'                => 'Verwyder bladsy',
	'coll-add_category'               => 'Voeg kategorie by',
	'coll-load_collection'            => 'Laai versameling',
	'coll-show_collection'            => 'Wys versameling',
	'coll-help_collections'           => 'Versameling hulp',
	'coll-empty'                      => 'leeg',
	'coll-page'                       => 'bladsy',
	'coll-pages'                      => 'bladsye',
	'coll-my_collection'              => 'My Versameling',
	'coll-remove'                     => 'Skrap',
	'coll-move_to_top'                => 'Skuif tot bo',
	'coll-move_up'                    => 'Skuif op',
	'coll-move_down'                  => 'Skuif af',
	'coll-move_to_bottom'             => 'Skuif tot onder',
	'coll-title'                      => 'Titel:',
	'coll-subtitle'                   => 'Subtitel:',
	'coll-contents'                   => 'Inhoud',
	'coll-rename'                     => 'Hernoem',
	'coll-new_chapter'                => 'Voer naam vir nuwe hoofstuk in',
	'coll-rename_chapter'             => 'Voer nuwe naam vir hoofstuk in',
	'coll-no_such_category'           => "Geen so 'n kategorie",
	'coll-empty_collection'           => 'Lëe versameling',
	'coll-save_collection_title'      => 'Stoor versameling',
	'coll-personal_collection_label'  => 'Persoonlike versameling:',
	'coll-community_collection_label' => 'Gemeenskap versameling:',
	'coll-save_collection'            => 'Stoor versameling',
	'coll-yes'                        => 'Ja',
	'coll-no'                         => 'Nee',
	'coll-cancel'                     => 'Kanselleer',
	'coll-license'                    => 'Lisensie',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author Siebrand
 */
$messages['ar'] = array(
	'coll-desc'                       => '[[Special:Collection|صفحات مجموعة]]، تولد PDFs',
	'coll-collections'                => 'مجموعات',
	'coll-portlet_title'              => 'مجموعتي',
	'coll-add_page'                   => 'إضافة صفحة',
	'coll-remove_page'                => 'إزالة صفحة',
	'coll-add_category'               => 'إضافة تصنيف',
	'coll-load_collection'            => 'تحميل المجموعة',
	'coll-show_collection'            => 'عرض المجموعة',
	'coll-help_collections'           => 'مساعدة المجموعات',
	'coll-empty'                      => 'فارغ',
	'coll-page'                       => 'صفحة',
	'coll-pages'                      => 'صفحات',
	'coll-download_as_pdf'            => 'حمل ك PDF',
	'coll-download_as_odf'            => 'حمل كODF',
	'coll-noscript_text'              => '<h1>الجافاسكريبت مطلوب!</h1>
<strong>متصفحك لا يدعم جافاسكريبت جافاسكريبت أو الجافاسكريبت تم تعطيلها.
هذه الصفحة لن تعمل بطريقة صحيحة، إلا إذا تم تفعيل الجافاسكريبت.</strong>',
	'coll-intro_text'                 => 'يمكنك جمع الصفحات، توليد وتحميل ملف PDF من مجموعات الصفحة وحفظ مجموعات الصفحة للاستخدام فيما بعد أو لمشاركتها.

انظر [[{{MediaWiki:Coll-helppage}}|صفحة المساعدة حول المجموعات]] لمزيد من المعلومات.',
	'coll-helppage'                   => 'Help:مجموعات',
	'coll-too_big_cat'                => 'التصنيف يحتوي على أكثر من %PARAM% صفحة، فقط أول %PARAM% صفحة يمكن إضافتها إلى مجموعتك.
هل تريد إضافتها؟',
	'coll-my_collection'              => 'مجموعتي',
	'coll-download_title'             => 'حمل المجموعة ك PDF',
	'coll-download_text'              => 'لتحميل ملف PDF مولد تلقائيا من مجموعة صفحتك، اضغط الزر.',
	'coll-download_pdf'               => 'حمل PDF',
	'coll-remove'                     => 'إزالة',
	'coll-move_to_top'                => 'تحريك إلى الأعلى',
	'coll-move_up'                    => 'حرك إلى الأعلى',
	'coll-move_down'                  => 'حرك إلى الأسفل',
	'coll-move_to_bottom'             => 'تحريك إلى الأسفل',
	'coll-title'                      => 'العنوان:',
	'coll-subtitle'                   => 'العنوان الفرعي:',
	'coll-contents'                   => 'محتويات',
	'coll-create_chapter'             => 'إنشاء فرع جديد',
	'coll-sort_alphabetically'        => 'تصنيف الصفحات أبجديا',
	'coll-clear_collection'           => 'إفراغ المجموعة',
	'coll-clear_confirm'              => 'هل تريد فعلا إفراغ مجموعتك؟',
	'coll-rename'                     => 'إعادة تسمية',
	'coll-new_chapter'                => 'أدخل الاسم للفرع الجديد',
	'coll-rename_chapter'             => 'أدخل الاسم الجديد للفرع',
	'coll-no_such_category'           => 'لا تصنيف كهذا',
	'coll-notitle_title'              => 'عنوان الصفحة لم يمكن تحديده.',
	'coll-post_failed_title'          => 'طلب POST فشل',
	'coll-post_failed_msg'            => 'طلب POST إلى $1 فشل ($2).',
	'coll-pdfserver_failed_title'     => 'PDF خطأ خادم',
	'coll-pdfserver_failed_msg'       => 'حدث خطأ في خادم PDF: $1',
	'coll-enter_title'                => 'أدخل العنوان للمجموعة:',
	'coll-error_reponse'              => 'خطأ استجابة من الخادم',
	'coll-empty_collection'           => 'مجموعة فارغة',
	'coll-revision'                   => 'النسخة: %PARAM%',
	'coll-save_collection_title'      => 'حفظ المجموعة',
	'coll-save_collection_text'       => 'لحفظ هذه المجموعة للاستخدام المستقبلي، اختر نوع مجموعة وأدخل عنوان صفحة:',
	'coll-login_to_save'              => 'لو كنت تريد حفظ المجموعات من أجل الاستخدام فيما بعد، من فضلك [[Special:Userlogin|قم بتسجيل الدخول أو إنشاء حساب]].',
	'coll-personal_collection_label'  => 'مجموعة شخصية:',
	'coll-community_collection_label' => 'مجموعة مجتمع:',
	'coll-save_collection'            => 'حفظ المجموعة',
	'coll-overwrite_title'            => 'الصفحة موجودة. كتابة عليها؟',
	'coll-overwrite_text'             => 'صفحة بنفس الاسم [[:$1]] موجودة بالفعل.
هل تريد استبدالها بمجموعتك؟',
	'coll-yes'                        => 'نعم',
	'coll-no'                         => 'لا',
	'coll-load_overwrite_text'        => 'لديك بالفعل عدة صفحات في مجموعتك.
هل تريد الكتابة على مجموعتك الحالية، إضافة المحتوى الجديد أو الإلغاء؟',
	'coll-overwrite'                  => 'كتابة عليها',
	'coll-append'                     => 'انتظار',
	'coll-cancel'                     => 'إلغاء',
	'coll-limit_exceeded_title'       => 'المجموعة كبيرة جدا',
	'coll-limit_exceeded_text'        => 'مجموعة صفحتك كبيرة جدا.
لا مزيد من الصفحات يمكن إضافتها.',
	'coll-rendering_title'            => 'عرض',
	'coll-rendering_text'             => "'''من فضلك انتظر أثناء توليد الوثيقة.'''

التقدم: '''$1%'''.

هذه الصفحة ينبغي أن يتم تحديثها كل عدة ثوان.
لو أن هذا لا يعمل، من فضلك اضغط زر التحديث في متصفحك.",
	'coll-rendering_finished_title'   => 'العرض انتهى',
	'coll-rendering_finished_text'    => "'''ملف الوثيقة تم توليده.'''
[$1 اضغط هنا] لتنزيله إلى حاسوبك.

غير راض عن الخرج؟
انظر [[{{MediaWiki:Coll-helppage}}|صفحة المساعدة حول المجموعات]] للاحتمالات لتحسينه.",
	'coll-notfound_title'             => 'المجموعة غير موجودة',
	'coll-notfound_text'              => 'لم يمكن العثور على صفحة المجموعة.',
	'coll-return_to_collection'       => 'ارجع إلى <a href="$1">$2</a>',
	'coll-book_title'                 => 'طلب كتاب مطبوع',
	'coll-book_text'                  => 'يمكنك طلب كتاب مطبوع يحتوي على مجموعة صفحاتك بواسطة زيارة واحدا من شركاء الطباعة عند الطلب التاليين:',
	'coll-order_from_pp'              => 'طلب كتاب من $1',
	'coll-about_pp'                   => 'حول $1',
	'coll-invalid_podpartner_title'   => 'شريك POD غير صحيح',
	'coll-invalid_podpartner_msg'     => 'شريك POD الموفر غير صحيح.
من فضلك اتصل بإداري ميدياويكي الخاص بك.',
	'coll-license'                    => 'ترخيص',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Siebrand
 */
$messages['bg'] = array(
	'coll-add_page'              => 'Добавяне на страница',
	'coll-remove_page'           => 'Премахване на страница',
	'coll-add_category'          => 'Добавяне на категория',
	'coll-empty'                 => 'празна',
	'coll-page'                  => 'страница',
	'coll-pages'                 => 'страници',
	'coll-download_as_pdf'       => 'Изтегляне като PDF',
	'coll-download_as_odf'       => 'Изтегляне като ODF',
	'coll-noscript_text'         => '<h1>Изисква се Джаваскрипт!</h1>
<strong>Използваният браузър не поддържа Джаваскрипт или поддръжката на Джаваскрипт е изключена.
Тази страница не може да работи правилно докато Джаваскриптът не бъде активиран.</strong>',
	'coll-download_pdf'          => 'Изтегляне на PDF',
	'coll-remove'                => 'Премахване',
	'coll-move_to_top'           => 'Преместване в началото',
	'coll-move_up'               => 'Преместване нагоре',
	'coll-move_down'             => 'Преместване надолу',
	'coll-move_to_bottom'        => 'Преместване в края',
	'coll-title'                 => 'Заглавие:',
	'coll-subtitle'              => 'Подзаглавие:',
	'coll-contents'              => 'Съдържание',
	'coll-sort_alphabetically'   => 'Подреждане на страниците по азбучен ред',
	'coll-rename'                => 'Преименуване',
	'coll-no_such_category'      => 'Няма такава категория',
	'coll-revision'              => 'Версия: %PARAM%',
	'coll-save_collection_title' => 'Съхраняване',
	'coll-save_collection'       => 'Съхраняване',
	'coll-overwrite_title'       => 'Страницата съществува. Заместване?',
	'coll-yes'                   => 'Да',
	'coll-no'                    => 'Не',
	'coll-overwrite'             => 'Заместване',
	'coll-append'                => 'Добавяне',
	'coll-cancel'                => 'Отказване',
	'coll-return_to_collection'  => 'Връщане към <a href="$1">$2</a>',
	'coll-order_from_pp'         => 'Поръчване на книга от $1',
	'coll-about_pp'              => 'За $1',
	'coll-license'               => 'Лиценз',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author SMP
 * @author Siebrand
 */
$messages['ca'] = array(
	'coll-add_page'             => 'Afegir pàgina',
	'coll-remove_page'          => 'Treure pàgina',
	'coll-add_category'         => 'Afegir categoria',
	'coll-empty'                => 'buit',
	'coll-page'                 => 'pàgina',
	'coll-pages'                => 'pàgines',
	'coll-download_as_pdf'      => 'Baixa-ho com a PDF',
	'coll-noscript_text'        => "<h1>Es necessita el JavaScript!</h1>
<strong>El vostre navegador no suporta el JavaScript o aquest hi està blocat.
Aquesta pàgina no funcionarà correctament si no el poseu o l'activeu.</strong>",
	'coll-title'                => 'Títol:',
	'coll-subtitle'             => 'Subtítol:',
	'coll-contents'             => 'Contingut',
	'coll-create_chapter'       => 'Crear un nou capítol',
	'coll-sort_alphabetically'  => 'Ordenar les pàgines alfabèticament',
	'coll-rename'               => 'Reanomena',
	'coll-overwrite_title'      => 'La pàgina existeix. Voleu substituir-la?',
	'coll-yes'                  => 'S&iacute;',
	'coll-no'                   => 'No',
	'coll-return_to_collection' => 'Tornar a <a href="$1">$2</a>',
	'coll-book_title'           => 'Encarregar llibre imprès',
	'coll-about_pp'             => 'Quant a $1',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Siebrand
 * @author Mormegil
 */
$messages['cs'] = array(
	'coll-desc'                       => 'Vytváření [[Special:Collection|kolekce stránek]], tvorba PDF',
	'coll-collections'                => 'Kolekce',
	'coll-portlet_title'              => 'Moje kolekce',
	'coll-add_page'                   => 'Přidat stránku',
	'coll-remove_page'                => 'Odstranit stránku',
	'coll-add_category'               => 'Přidat kategorii',
	'coll-load_collection'            => 'Načíst kolekci',
	'coll-show_collection'            => 'Zobrazit kolekci',
	'coll-help_collections'           => 'Nápověda ke kolekcím',
	'coll-empty'                      => 'prázdná',
	'coll-page'                       => 'stránka',
	'coll-pages'                      => 'stránky',
	'coll-download_as_pdf'            => 'Stáhnout jako PDF',
	'coll-noscript_text'              => '<h1>Vyžaduje se JavaScript!</h1>
<strong>Váš prohlížeč nepodporuje JavaScript nebo máte JavaScript vypnutý.
Táto stránka nebude správně fungovat dokud nezapnete JavaScript.</strong>',
	'coll-intro_text'                 => 'Můžete vytvářet kolekce stránek, vytvářet a stahovat PDF soubory vytvořené z kolekce stránek a ukládat kolekce stránek pro pozdější využití nebo je sdílet

Pro další informace se podívejte na [[{{MediaWiki:Coll-helppage}}|stránku nápovědy ke kolekcím]].',
	'coll-helppage'                   => 'Help:Kolekce',
	'coll-my_collection'              => 'Moje kolekce',
	'coll-download_title'             => 'Stáhnout kolekci jako PDF',
	'coll-download_text'              => 'Stáhnout automaticky vytvořený PDF soubor vaší kolekce stránek. Klikněte na tlačítko.',
	'coll-download_pdf'               => 'Stáhnout PDF',
	'coll-remove'                     => 'Odstranit',
	'coll-move_to_top'                => 'Přesunout nahoru',
	'coll-move_up'                    => 'Přesunout výše',
	'coll-move_down'                  => 'Přesunout níže',
	'coll-move_to_bottom'             => 'Přesunout dolů',
	'coll-title'                      => 'Název:',
	'coll-subtitle'                   => 'Podtitul:',
	'coll-contents'                   => 'Obsah',
	'coll-create_chapter'             => 'Vytvořit novou kapitolu',
	'coll-sort_alphabetically'        => 'Seřadit stránky abecedně',
	'coll-clear_collection'           => 'Vyčistit kolekci',
	'coll-clear_confirm'              => 'Opravdu chcete vyčistit svoji kolekci?',
	'coll-rename'                     => 'Přejmenovat',
	'coll-new_chapter'                => 'Zadejte název nové kapitoly',
	'coll-rename_chapter'             => 'Zadejte nový název kapitoly',
	'coll-no_such_category'           => 'Taková kategorie neexistuje',
	'coll-notitle_title'              => 'Nebylo možné určit název stránky.',
	'coll-post_failed_title'          => 'Chyba požadavku POST',
	'coll-post_failed_msg'            => 'Chyba při požadavku POST na server $1 ($2).',
	'coll-enter_title'                => 'Zadejte název kolekce.',
	'coll-error_reponse'              => 'Chybná odpověď serveru',
	'coll-empty_collection'           => 'Prázdná kolekce',
	'coll-revision'                   => 'Revize: %PARAM%',
	'coll-save_collection_title'      => 'Uložit kolekci',
	'coll-save_collection_text'       => 'Tuto kolekci můžete uložit pro pozdější použití pro zadání typu kolekce a názvu stránky:',
	'coll-login_to_save'              => 'Pokud chcete ukládat kolekce pro pozdější použití, prosím, [[Special:Userlogin|přihlaste se nebo si vytvořte účet]].',
	'coll-personal_collection_label'  => 'Osobní kolekce:',
	'coll-community_collection_label' => 'Komunitní kolekce:',
	'coll-save_collection'            => 'Uložit kolekci',
	'coll-overwrite_title'            => 'Stránka existuje. Přepsat?',
	'coll-overwrite_text'             => 'Stránka s názvem [[:$1]] už existuje.
Chcete ji nahradit svojí kolekcí?',
	'coll-yes'                        => 'Ano',
	'coll-no'                         => 'Ne',
	'coll-load_overwrite_text'        => 'Ve vaší kolekci se už nacházejí stránky.
Chcete přepsat svoji existující kolekci, přidat do ní obsah nebo zrušit tuto operaci?',
	'coll-overwrite'                  => 'Přepsat',
	'coll-append'                     => 'Přidat',
	'coll-cancel'                     => 'Zrušit',
	'coll-limit_exceeded_title'       => 'Kolekce je příliš velká',
	'coll-limit_exceeded_text'        => 'Vaše kolekce stránek je příliš velká.
Není možné přidat další stránky.',
	'coll-notfound_title'             => 'Kolekce nenalezena',
	'coll-notfound_text'              => 'Nebylo možné najít stránku kolekce',
	'coll-return_to_collection'       => 'Vrátit se na <a href="$1">$2</a>',
	'coll-book_title'                 => 'Objednat tisknutou knihu',
	'coll-book_text'                  => 'Můžete se objednat tisknutou knihu obsahující vaši kolekci stránek. Navštivte jednoho z následujících partnerů, kteří Vám ji vytisknou na požádání:',
	'coll-order_from_pp'              => 'Objednat knihu od $1',
	'coll-about_pp'                   => 'O $1',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'coll-page' => 'страни́ца',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 * @author SPQRobin
 */
$messages['da'] = array(
	'coll-empty'  => 'tom',
	'coll-page'   => 'side',
	'coll-pages'  => 'sider',
	'coll-title'  => 'Titel:',
	'coll-yes'    => 'Ja',
	'coll-no'     => 'Nej',
	'coll-cancel' => 'Afbryd',
);

/** German (Deutsch)
 * @author Raimond Spekking
 * @author VolkerHaas
 * @author Siebrand
 */
$messages['de'] = array(
	'coll-desc'                       => '[[Special:Collection|Sammle Seiten]], erzeuge PDFs',
	'coll-collections'                => 'Kollektionen',
	'coll-portlet_title'              => 'Meine Kollektion',
	'coll-add_page'                   => 'Seite hinzufügen',
	'coll-remove_page'                => 'Seite entfernen',
	'coll-add_category'               => 'Kategorie hinzufügen',
	'coll-load_collection'            => 'Kollektion laden',
	'coll-show_collection'            => 'Kollektion zeigen',
	'coll-help_collections'           => 'Hilfe zu Kollektionen',
	'coll-empty'                      => 'leer',
	'coll-page'                       => 'Seite',
	'coll-pages'                      => 'Seiten',
	'coll-download_as_pdf'            => 'Als PDF herunterladen',
	'coll-noscript_text'              => '<h1>JavaScript wird benötigt!</h1>
<strong>Dein Browser unterstützt kein JavaScript oder JavaScript wurde deaktiviert.
Diese Seite wird nicht richtig funktionieren, solange JavaScript nicht verfügbar ist.</strong>',
	'coll-intro_text'                 => 'Du kannst Kollektionen von Seiten erstellen, daraus ein PDF erzeugen und herunterladen. Weiterhin können Kollektionen für die spätere Verwendung zwischengespeichert und mit anderen Benutzern geteilt werden.

Siehe auch die [[{{MediaWiki:Coll-helppage}}|Hilfe zu Kollektionen]] für weitere Informationen.',
	'coll-helppage'                   => 'Help:Kollektionen',
	'coll-my_collection'              => 'Meine Kollektion',
	'coll-download_title'             => 'Kollektion als PDF herunterladen',
	'coll-download_text'              => 'Um eine automatisch erstellte PDF-Datei deiner Kollektion herunterzuladen, klicke auf die Schaltfläche.',
	'coll-download_pdf'               => 'PDF herunterladen',
	'coll-remove'                     => 'Entfernen',
	'coll-move_to_top'                => 'an den Anfang',
	'coll-move_up'                    => 'hoch',
	'coll-move_down'                  => 'herunter',
	'coll-move_to_bottom'             => 'an das Ende',
	'coll-title'                      => 'Titel:',
	'coll-subtitle'                   => 'Untertitel:',
	'coll-contents'                   => 'Inhalt',
	'coll-create_chapter'             => 'Neues Kapitel erzeugen',
	'coll-sort_alphabetically'        => 'Seiten alphabetisch sortieren',
	'coll-clear_collection'           => 'Kollektion löschen',
	'coll-clear_confirm'              => 'Möchtest du deine Kollektion wirklich löschen?',
	'coll-rename'                     => 'Umbenennen',
	'coll-new_chapter'                => 'Gib einen Namen für ein neues Kapitel ein',
	'coll-rename_chapter'             => 'Gib einen neuen Namen für das Kapitel ein',
	'coll-no_such_category'           => 'Kategorie nicht vorhanden',
	'coll-notitle_title'              => 'Der Titel der Seite konnte nicht bestimmt werden.',
	'coll-post_failed_title'          => 'POST-Anfrage fehlgeschlagen',
	'coll-post_failed_msg'            => 'Die POST-Anfrage an $1 ist fehlgeschlagen ($2).',
	'coll-enter_title'                => 'Titel der Kollektion eingeben:',
	'coll-error_reponse'              => 'Fehlermeldung vom Server',
	'coll-empty_collection'           => 'Leere Kollektion',
	'coll-revision'                   => 'Version: %PARAM%',
	'coll-save_collection_title'      => 'Kollektion speichern',
	'coll-save_collection_text'       => 'Um diese Kollektion zu speichern, wähle einen Typ und gib einen Titel ein:',
	'coll-login_to_save'              => 'Wenn du Kollektionen speichern möchtest, [[Special:Userlogin|melde dich bitte an oder erstelle ein Benutzerkonto]].',
	'coll-personal_collection_label'  => 'Persönliche Kollektion:',
	'coll-community_collection_label' => 'Community Kollektion:',
	'coll-save_collection'            => 'Kollektion speichern',
	'coll-overwrite_title'            => 'Seite vorhanden, überschreiben?',
	'coll-overwrite_text'             => 'Eine Seite mit dem Namen [[:$1]] ist bereits vorhanden. Möchtest du sie durch deine Kollektion ersetzen?',
	'coll-yes'                        => 'Ja',
	'coll-no'                         => 'Nein',
	'coll-load_overwrite_text'        => 'Deine Kollektion enthält bereits Seiten. Möchtest du die aktuelle Kollektion überschreiben, die neuen Seiten anhängen oder abbrechen?',
	'coll-overwrite'                  => 'Überschreiben',
	'coll-append'                     => 'Anhängen',
	'coll-cancel'                     => 'Abbrechen',
	'coll-limit_exceeded_title'       => 'Kollektion zu groß',
	'coll-limit_exceeded_text'        => 'Deine Kollektion ist zu groß. Es können keine Seiten mehr hinzugefügt werden.',
	'coll-notfound_title'             => 'Kollektion nicht gefunden',
	'coll-notfound_text'              => 'Deine Kollektion konnte nicht gefunden werden.',
	'coll-return_to_collection'       => 'Zurück zu <a href="$1">$2</a>',
	'coll-book_title'                 => 'Druckausgabe bestellen',
	'coll-book_text'                  => "Du kannst bei den folgenden ''Print-on-Demand''-Partnern eine gedruckte Buchausgabe bestellen:",
	'coll-order_from_pp'              => 'Bestelle Buch bei $1',
	'coll-about_pp'                   => 'Über $1',
	'coll-invalid_podpartner_title'   => 'Ungültiger Print-on-Demand-Partner',
	'coll-invalid_podpartner_msg'     => 'Die Angaben zum Print-on-Demand-Partner sind fehlerhaft. Bitte kontaktiere den MediaWiki-Administrator.',
	'coll-license'                    => 'Lizenz',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'coll-collections'   => 'Συλλογές',
	'coll-portlet_title' => 'Η Συλλογή μου',
	'coll-page'          => 'σελίδα',
	'coll-pages'         => 'σελίδες',
	'coll-my_collection' => 'Η Συλλογή μου',
	'coll-title'         => 'Τίτλος:',
	'coll-subtitle'      => 'Υπότιτλος:',
	'coll-yes'           => 'Ναι',
	'coll-no'            => 'Όχι',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 * @author Siebrand
 * @author Amikeco
 */
$messages['eo'] = array(
	'coll-desc'                       => '[[Special:Collection|Kolekto-paĝoj]], generi PDF-ojn',
	'coll-collections'                => 'Kolektoj',
	'coll-portlet_title'              => 'Mia kolekto',
	'coll-add_page'                   => 'Aldoni paĝon',
	'coll-remove_page'                => 'Forigi paĝon',
	'coll-add_category'               => 'Aldoni kategorion',
	'coll-load_collection'            => 'Alŝuti kolekton',
	'coll-show_collection'            => 'Montri kolekton',
	'coll-help_collections'           => 'Helpo pri kolektoj',
	'coll-empty'                      => 'malplena',
	'coll-page'                       => 'paĝo',
	'coll-pages'                      => 'paĝoj',
	'coll-download_as_pdf'            => 'Alŝuti kiel PDF',
	'coll-download_as_odf'            => 'Elŝuti kiel ODF',
	'coll-helppage'                   => 'Help:Kolektoj',
	'coll-my_collection'              => 'Mia kolekto',
	'coll-download_title'             => 'Alŝutu kolekton kiel PDF-on',
	'coll-download_text'              => 'Alŝuti aŭtomate generitan PDF-dosieron de via paĝkolekto, klaku la butonon.',
	'coll-download_pdf'               => 'Alŝutu PDF',
	'coll-remove'                     => 'Forigi',
	'coll-move_to_top'                => 'Movi superen',
	'coll-move_up'                    => 'Movi supren',
	'coll-move_down'                  => 'Movi suben',
	'coll-move_to_bottom'             => 'Movi malsuperen',
	'coll-title'                      => 'Titolo:',
	'coll-subtitle'                   => 'Subtitolo:',
	'coll-contents'                   => 'Enhavaĵoj',
	'coll-create_chapter'             => 'Kreu novan ĉapitron',
	'coll-sort_alphabetically'        => 'Ordigi paĝojn laŭ alfabeto',
	'coll-clear_collection'           => 'Forviŝi kolekton',
	'coll-clear_confirm'              => 'Ĉu vi ja volas forviŝi vian kolekton?',
	'coll-rename'                     => 'Alinomigi',
	'coll-new_chapter'                => 'Enigi nomon por nova ĉapitro',
	'coll-rename_chapter'             => 'Enigi novan nomon por ĉapitro',
	'coll-no_such_category'           => 'Nenia kategorio',
	'coll-notitle_title'              => 'La titolo de la paĝo ne estis determinebla.',
	'coll-post_failed_title'          => 'POST-peto malsukcesis',
	'coll-post_failed_msg'            => 'La POST-peto por $1 malsukcesis ($2).',
	'coll-pdfserver_failed_title'     => 'Eraro de PDF-servilo',
	'coll-pdfserver_failed_msg'       => 'Eraro okazis en la PDF-servilo: $1',
	'coll-enter_title'                => 'Enigu titolon por kolekto:',
	'coll-error_reponse'              => 'Erara respondo de servilo',
	'coll-empty_collection'           => 'Malplena kolekto',
	'coll-revision'                   => 'Revizio: %PARAM%',
	'coll-save_collection_title'      => 'Konservu Kolekton',
	'coll-personal_collection_label'  => 'Propra kolekto:',
	'coll-community_collection_label' => 'Komuna kolekto:',
	'coll-save_collection'            => 'Konservu Kolekton',
	'coll-overwrite_title'            => 'Paĝo ekzistas. Ĉu anstataŭigi?',
	'coll-yes'                        => 'Jes',
	'coll-no'                         => 'Ne',
	'coll-overwrite'                  => 'Anstataŭigu',
	'coll-append'                     => 'Aldoni',
	'coll-cancel'                     => 'Nuligi',
	'coll-limit_exceeded_title'       => 'Kolekto Tro Granda',
	'coll-limit_exceeded_text'        => 'Via paĝa kolekto estas tro granda.
Neniom pluaj paĝoj ne povas esti aldonitaj.',
	'coll-rendering_title'            => 'Generante',
	'coll-rendering_text'             => "'''Bonvolu atendi dum la dokumento generiĝis.'''

Finita: '''$1 %'''.

Ĉi tiu paĝo aŭtomatike refreŝigu kelksekunde.
Se ne funkcias, bonvolu klaki refreŝigo-butonon de via retumilo.",
	'coll-rendering_finished_title'   => 'Generado finiĝis.',
	'coll-notfound_title'             => 'Kolekto Ne Trovita',
	'coll-notfound_text'              => 'Ne eblas trovi kolekto-paĝon.',
	'coll-return_to_collection'       => 'Reiru al <a href="$1">$2</a>',
	'coll-book_title'                 => 'Mendu Eldonitan Libron',
	'coll-order_from_pp'              => 'Mendi libron de $1',
	'coll-about_pp'                   => 'Pri $1',
	'coll-license'                    => 'Licenco',
);

/** Spanish (Español)
 * @author Jatrobat
 */
$messages['es'] = array(
	'coll-yes' => 'Sí',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 */
$messages['fi'] = array(
	'coll-overwrite_title' => 'Sivu on olemassa. Ylikirjoitetaanko?',
	'coll-yes'             => 'Kyllä',
	'coll-no'              => 'Ei',
);

/** French (Français)
 * @author Meithal
 * @author Grondin
 * @author Verdy p
 * @author Siebrand
 * @author IAlex
 */
$messages['fr'] = array(
	'coll-desc'                       => "[[Special:Collection|Compiler des pages]], générer des pdf's",
	'coll-collections'                => 'Compilations',
	'coll-portlet_title'              => 'Ma compilation',
	'coll-add_page'                   => 'Ajouter une page',
	'coll-remove_page'                => 'Enlever une page',
	'coll-add_category'               => 'Ajouter une catégorie',
	'coll-load_collection'            => 'Charger une compilation',
	'coll-show_collection'            => 'Afficher la compilation',
	'coll-help_collections'           => 'Aide sur les compilations',
	'coll-empty'                      => 'vide',
	'coll-page'                       => 'page',
	'coll-pages'                      => 'pages',
	'coll-download_as_pdf'            => 'Télécharger en PDF',
	'coll-download_as_odf'            => 'Télécharger en ODF',
	'coll-noscript_text'              => "<h1>Javascript est nécessaire !</h1>
<strong>Votre navigateur ne supporte pas Javascript ou bien l'a désactivé.
Cette page ne s'affichera pas correctement tant que javascript n'est pas activé.</strong>",
	'coll-intro_text'                 => "Vous pouvez collecter des pages, générer et télécharger des fichiers PDF depuis les collections de paéges ou des sauvegarde desdites collections pour un usage ultérieur ou pour les partager.

Voyez [[{{MediaWiki:Coll-helppage}}|les pages d'aides en matière de collections]] pour d'avantage d'informations.",
	'coll-helppage'                   => 'Help:Collections',
	'coll-too_big_cat'                => 'La catégorie contient plus de %PARAM% pages, seul les %PARAM% premières pages seront ajoutées à votre collection.',
	'coll-my_collection'              => 'Ma compilation',
	'coll-download_title'             => 'Télécharger la compilation en PDF',
	'coll-download_text'              => 'Pour télécharger un PDF généré automatiquement à partir de votre compilation, appuyez sur le bouton.',
	'coll-download_pdf'               => 'Télécharger le PDF',
	'coll-remove'                     => 'Enlever',
	'coll-move_to_top'                => 'Déplacer tout en haut',
	'coll-move_up'                    => 'Monter',
	'coll-move_down'                  => 'Descendre',
	'coll-move_to_bottom'             => 'Déplacer tout en bas',
	'coll-title'                      => 'Titre :',
	'coll-subtitle'                   => 'Sous-titre :',
	'coll-contents'                   => 'Contenu',
	'coll-create_chapter'             => 'Créer un nouveau chapitre',
	'coll-sort_alphabetically'        => 'Trier les pages par ordre alphabétique',
	'coll-clear_collection'           => 'Vider la compilation',
	'coll-clear_confirm'              => 'Voulez-vous vraiment vider votre compilation ?',
	'coll-rename'                     => 'Renommer',
	'coll-new_chapter'                => 'Enter le titre du nouveau chapitre',
	'coll-rename_chapter'             => 'Enter nouveau titre pour le chapitre',
	'coll-no_such_category'           => 'Pas de telle catégorie',
	'coll-notitle_title'              => 'Le titre de la page ne peut être déterminée.',
	'coll-post_failed_title'          => 'Échec de la requête POST',
	'coll-post_failed_msg'            => 'La requête POST vers $1 a échoué ($2).',
	'coll-pdfserver_failed_title'     => 'Erreur du serveur PDF',
	'coll-pdfserver_failed_msg'       => 'Une erreur est survenue sur le serveur PDF : $1',
	'coll-enter_title'                => 'Entrer un titre pour la compilation :',
	'coll-error_reponse'              => 'Le serveur a rencontré une erreur',
	'coll-empty_collection'           => 'Compilation vide',
	'coll-revision'                   => 'Version : %PARAM%',
	'coll-save_collection_title'      => 'Sauvegarder la compilation',
	'coll-save_collection_text'       => 'Pour sauvegarder la compilation, choisissez un type de compilation et entrez un titre de page :',
	'coll-login_to_save'              => 'Si vous voulez sauvegarder votre compilation, veuillez [[Special:Userlogin|vous connecter ou vous créer un compte]].',
	'coll-personal_collection_label'  => 'Compilation personnelle :',
	'coll-community_collection_label' => 'Compilation collective :',
	'coll-save_collection'            => 'Sauvegarder la compilation',
	'coll-overwrite_title'            => "La page existe. L'écraser ?",
	'coll-overwrite_text'             => 'Une page nommée [[:$1]] existe déjà.
Voulez-vous la remplacer par votre compilation ?',
	'coll-yes'                        => 'Oui',
	'coll-no'                         => 'Non',
	'coll-load_overwrite_text'        => 'Vous avez déjà des pages dans votre compilation.
Voulez vous écraser votre compilation actuelle, y rajouter le contenu ou bien annuler ?',
	'coll-overwrite'                  => 'Écraser',
	'coll-append'                     => 'Ajouter',
	'coll-cancel'                     => 'Annuler',
	'coll-limit_exceeded_title'       => 'Compilation trop grande',
	'coll-limit_exceeded_text'        => 'Votre compilation est trop grande.
Aucune page ne peut être ajoutée.',
	'coll-rendering_title'            => 'Rendu',
	'coll-rendering_text'             => "'''Veuillez patienter pendant que le document est en cours de création.'''

Progression : '''$1 %'''.

Cette page devrait s’actualiser régulièrement.
Si tel n'était pas le cas, veuillez cliquer sur le bouton d’actualisation de votre navigateur.",
	'coll-rendering_finished_title'   => 'Rendu terminé',
	'coll-rendering_finished_text'    => "'''Le fichier document a été créé.'''
[$1 Cliquez ici] pour le télécharger sur votre ordinateur.

Non satisfait de la sortie ?
Voyez [[{{MediaWiki:Coll-helppage}}|la page d’aide concernant les collections]] pour les possibilités d’amélioration.",
	'coll-notfound_title'             => 'Compilation non trouvée',
	'coll-notfound_text'              => 'Ne peut trouver la compilation.',
	'coll-return_to_collection'       => 'Revenir sur <a href="$1">$2</a>',
	'coll-book_title'                 => 'Commander un livre imprimé',
	'coll-book_text'                  => "Vous pouvez commander un livre imprimé contenant votre collection d'articles en visitant une demande d'impression de la part de partenaires :",
	'coll-order_from_pp'              => 'Commander le livre depuis $1',
	'coll-about_pp'                   => 'Au sujet de $1',
	'coll-invalid_podpartner_title'   => 'Partenaire POD incorrect.',
	'coll-invalid_podpartner_msg'     => 'Le partenaire POD indiqué est incorrect.
Veuillez contacter votre administrateur Mediawiki.',
	'coll-license'                    => 'Licence',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'coll-page' => 'side',
	'coll-yes'  => 'Ja',
);

/** Galician (Galego)
 * @author Toliño
 * @author Alma
 * @author Siebrand
 */
$messages['gl'] = array(
	'coll-desc'                       => '[[Special:Collection|Coleccionar páxinas]], xerar ficheiros PDF',
	'coll-collections'                => 'Coleccións',
	'coll-portlet_title'              => 'A miña colección',
	'coll-add_page'                   => 'Engadir páxina',
	'coll-remove_page'                => 'Eliminar páxina',
	'coll-add_category'               => 'Engadir categoría',
	'coll-load_collection'            => 'Cargar colección',
	'coll-show_collection'            => 'Mostrar colección',
	'coll-help_collections'           => 'Axuda coas coleccións',
	'coll-empty'                      => 'baleiro',
	'coll-page'                       => 'páxina',
	'coll-pages'                      => 'páxinas',
	'coll-download_as_pdf'            => 'Descargar como PDF',
	'coll-download_as_odf'            => 'Descargar como arquivo ODF',
	'coll-noscript_text'              => '<h1>Requírese o JavaScript!</h1>
<strong>O seu navegador non soporta o JavaScript ou o JavaScript foi deshabilitado.
Esta páxina non funcionará correctamente, polo menos ata que o JavaScript sexa habilitado.</strong>',
	'coll-intro_text'                 => 'Pode coleccionar páxinas, xerar e descargar ficheiros PDF das páxinas de coleccións e gardar as páxinas de coleccións para un uso posterior ou para compartilas.

Vexa a [[{{MediaWiki:Coll-helppage}}|páxina de axuda sobre as coleccións]] para máis información.',
	'coll-helppage'                   => 'Help:Collections',
	'coll-too_big_cat'                => 'A categoría contén máis de %PARAM% páxinas; só as primeiras %PARAM% páxinas poden ser engadidas á súa colección.
Quere engadilas?',
	'coll-my_collection'              => 'A miña colección',
	'coll-download_title'             => 'Descargar a colección como arquivo PDF',
	'coll-download_text'              => 'Para descargar un arquivo PDF xerado automaticamente da súa páxina de colección, faga clic no botón.',
	'coll-download_pdf'               => 'Descargar PDF',
	'coll-remove'                     => 'Eliminar',
	'coll-move_to_top'                => 'Ir arriba',
	'coll-move_up'                    => 'Mover arriba',
	'coll-move_down'                  => 'Mover abaixo',
	'coll-move_to_bottom'             => 'Ir abaixo',
	'coll-title'                      => 'Título:',
	'coll-subtitle'                   => 'Subtítulo:',
	'coll-contents'                   => 'Contidos',
	'coll-create_chapter'             => 'Crear un novo capítulo',
	'coll-sort_alphabetically'        => 'Ordenar as páxinas alfabeticamente',
	'coll-clear_collection'           => 'Borrar colección',
	'coll-clear_confirm'              => 'Seguro que desexa eliminar a súa colección?',
	'coll-rename'                     => 'Renomear',
	'coll-new_chapter'                => 'Insira un nome para o novo capítulo',
	'coll-rename_chapter'             => 'Insira un novo nome para o capítulo',
	'coll-no_such_category'           => 'Non existe tal categoría',
	'coll-notitle_title'              => 'O título da páxina non pode ser determinado.',
	'coll-post_failed_title'          => 'A solicitude do POST fallou',
	'coll-post_failed_msg'            => 'Fallou o POST solicitado a $1 ($2).',
	'coll-pdfserver_failed_title'     => 'Erro no servidor PDF',
	'coll-pdfserver_failed_msg'       => 'Ocorreu un erro no servidor PDF: $1',
	'coll-enter_title'                => 'Escriba un título para a colección:',
	'coll-error_reponse'              => 'Ocorreu un erro no servidor',
	'coll-empty_collection'           => 'Colección baleira',
	'coll-revision'                   => 'Revisión: %PARAM%',
	'coll-save_collection_title'      => 'Gardar a colección',
	'coll-save_collection_text'       => 'Para gardar esta colección para un uso posterior escolla un tipo de colección e insira un título para a páxina:',
	'coll-login_to_save'              => 'Se quere gardar coleccións para un uso posterior, por favor, [[Special:Userlogin|acceda ao sistema ou cree unha conta]].',
	'coll-personal_collection_label'  => 'Colección persoal:',
	'coll-community_collection_label' => 'Colección da comunidade:',
	'coll-save_collection'            => 'Gardar a colección',
	'coll-overwrite_title'            => 'A páxina existe. Desexa sobreescribir?',
	'coll-overwrite_text'             => 'Xa existe unha páxina chamada [[:$1]].
Quere reemprazala coa súa colección?',
	'coll-yes'                        => 'Si',
	'coll-no'                         => 'Non',
	'coll-load_overwrite_text'        => 'Xa ten algunhas páxinas na súa colección.
Desexa sobreescribir a súa colección actual, adxuntar o novo contido ou cancelar?',
	'coll-overwrite'                  => 'Sobreescribir',
	'coll-append'                     => 'Adxuntar',
	'coll-cancel'                     => 'Cancelar',
	'coll-limit_exceeded_title'       => 'Colección moi grande',
	'coll-limit_exceeded_text'        => 'A súa páxina de colección é moi grande.
Non se poden engadir máis páxinas.',
	'coll-rendering_title'            => 'Renderizando',
	'coll-rendering_text'             => "'''Por favor, agarde mentres o documento é xerado.'''

Progreso: '''\$1%'''.

Esta páxina refrescarase cada poucos segundos.
Se non vai, por favor, prema no botón \"Refrescar\" do seu navegador.",
	'coll-rendering_finished_title'   => 'Finalizou a renderización',
	'coll-rendering_finished_text'    => "'''O documento foi xerado.'''
[$1 Prema aquí] para descargalo no seu computador.

Non está satisfaito co ficheiro de saída?
Vexa [[{{MediaWiki:Coll-helppage}}|a páxina de axuda acerca das coleccións]] para comprobar as posibilidades de melloralo.",
	'coll-notfound_title'             => 'Non se pode atopar a colección',
	'coll-notfound_text'              => 'Non se pode atopar a páxina da colección.',
	'coll-return_to_collection'       => 'Voltar a <a href="$1">$2</a>',
	'coll-book_title'                 => 'Encargar un libro impreso',
	'coll-book_text'                  => 'Pode encargar un libro impreso que conteña a súa páxina de colección visitando un dos seguintes compañeiros de solicitudes de impresión:',
	'coll-order_from_pp'              => 'Encargar un libro a $1',
	'coll-about_pp'                   => 'Acerca de $1',
	'coll-invalid_podpartner_title'   => 'Compañeiro de solicitudes de impresión (POD) inválido',
	'coll-invalid_podpartner_msg'     => 'O compañeiro de solicitudes de impresión (POD) indicado é inválido.
Por favor, contacte co seu administrador MediaWiki.',
	'coll-license'                    => 'Licenza',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'coll-collections'                => 'Çhaglymyn',
	'coll-portlet_title'              => 'My haglym',
	'coll-empty'                      => 'follym',
	'coll-page'                       => 'duillag',
	'coll-pages'                      => 'duillagyn',
	'coll-helppage'                   => 'Cooney:Çhaglymyn',
	'coll-my_collection'              => 'My haglym',
	'coll-title'                      => 'Ard-ennym:',
	'coll-contents'                   => 'Cummal',
	'coll-create_chapter'             => 'Croo cabdil noa',
	'coll-sort_alphabetically'        => 'Sorçhaghey duillagyn rere lettyr',
	'coll-personal_collection_label'  => 'Çhaglym persoonagh:',
	'coll-community_collection_label' => 'Çhaglym y chohionnal:',
	'coll-yes'                        => 'Ta',
	'coll-no'                         => 'Cha',
	'coll-cancel'                     => 'Dolley magh',
	'coll-about_pp'                   => 'Mychione $1',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'coll-page'     => '‘ao‘ao',
	'coll-remove'   => 'Kāpae',
	'coll-contents' => 'Papa kuhikuhi',
	'coll-about_pp' => 'E pili ana iā $1',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Siebrand
 */
$messages['hi'] = array(
	'coll-desc'                       => '[[Special:Collection|पन्ने जमा करें]], पीडीएफ बनायें',
	'coll-collections'                => 'कलेक्शन',
	'coll-portlet_title'              => 'मेरा कलेक्शन',
	'coll-add_page'                   => 'पन्ना बढायें',
	'coll-remove_page'                => 'पन्ना हटायें',
	'coll-add_category'               => 'श्रेणी बढायें',
	'coll-load_collection'            => 'कलेक्शन लोड करें',
	'coll-show_collection'            => 'कलेक्शन दर्शायें',
	'coll-help_collections'           => 'कलेक्शन सहायता',
	'coll-empty'                      => 'खाली',
	'coll-page'                       => 'पन्ना',
	'coll-pages'                      => 'पन्ने',
	'coll-download_as_pdf'            => 'पीडिएफ डाउनलोड करें',
	'coll-helppage'                   => 'Help:कलेक्शन',
	'coll-my_collection'              => 'मेरे कलेक्शन',
	'coll-download_title'             => 'कलेक्शन पीडिएफ डाउनलोड करें',
	'coll-download_text'              => 'आपके कलेक्शनका पीडिएफ अवतरण डाउनलोड करने के लिये, दिये हुए बटन पर क्लिक करें।',
	'coll-download_pdf'               => 'पीडिएफ डाउनलोड करें',
	'coll-remove'                     => 'हटायें',
	'coll-move_to_top'                => 'सबसे उपर भेजें',
	'coll-move_up'                    => 'उपर भेजें',
	'coll-move_down'                  => 'नीचे भेजें',
	'coll-move_to_bottom'             => 'सबसे नीचे भेजें',
	'coll-title'                      => 'शीर्षक:',
	'coll-subtitle'                   => 'उपशीर्षक:',
	'coll-contents'                   => 'अनुक्रम',
	'coll-create_chapter'             => 'नया अध्याय बनायें',
	'coll-sort_alphabetically'        => 'अक्षरोंके अनुसार पन्ने लगायें',
	'coll-clear_collection'           => 'कलेक्शन खाली करें',
	'coll-clear_confirm'              => 'क्या आप सचमुच आपका कलेक्शन खाली करना चाहतें हैं?',
	'coll-rename'                     => 'नाम बदलें',
	'coll-new_chapter'                => 'नये अध्याय के लिये नाम दें',
	'coll-rename_chapter'             => 'नये अध्याय के लिये नाम दें',
	'coll-no_such_category'           => 'ऐसी श्रेणी नहीं हैं',
	'coll-notitle_title'              => 'इस पन्ने का शीर्षक निश्चित नहीं कर पा रहें हैं।',
	'coll-post_failed_title'          => 'POST माँग पूरी नहीं हुई हैं',
	'coll-post_failed_msg'            => 'POST माँग पूरी नहीं हुई हैं ($2)',
	'coll-enter_title'                => 'कलेक्शन का शीर्षक दें:',
	'coll-error_reponse'              => 'सर्वरसे गलत रिस्पॉन्स मिला हैं',
	'coll-empty_collection'           => 'खाली कलेक्शन',
	'coll-revision'                   => 'अवतरण: %PARAM%',
	'coll-save_collection_title'      => 'कलेक्शन संजोयें',
	'coll-save_collection_text'       => 'इस कलेक्शनको फिरसे इस्तेमाल में लाने के लिये इसे एक नाम दें और इसका प्रकार चुनकर इसे संजोयें:',
	'coll-login_to_save'              => 'अगर आप बादमें इस्तेमाल के लिये यह कलेक्शन संजोना चाहतें हैं, तो कृपया [[Special:Userlogin|लॉग इन करें या नया खाता खोलें]]।',
	'coll-personal_collection_label'  => 'वैयक्तिक कलेक्शन:',
	'coll-community_collection_label' => 'सामूहिक कलेक्शन:',
	'coll-save_collection'            => 'कलेक्शन संजोयें',
	'coll-overwrite_title'            => 'पन्ना अस्तित्व में हैं। पुनर्लेखन करें?',
	'coll-overwrite_text'             => '[[:$1]] नामका पन्ना पहले से अस्तित्वमें हैं।
क्या आप उसपर अपना कलेक्शन पुनर्लिखना चाहतें हैं?',
	'coll-yes'                        => 'हां',
	'coll-no'                         => 'नहीं',
	'coll-load_overwrite_text'        => 'आपके कलेक्शनमें पहले से कुछ पन्ने हैं।
क्या आप आपका कलेक्शन दुबारा बनाना चाहतें हैं, या यह पन्ने बढाना चाहतें हैं?',
	'coll-overwrite'                  => 'पुनर्लेखन करें',
	'coll-append'                     => 'बढायें',
	'coll-cancel'                     => 'रद्द करें',
	'coll-limit_exceeded_title'       => 'कलेक्शन बहुत बडा हुआ हैं',
	'coll-limit_exceeded_text'        => 'आपका कलेक्शन बहुत बडा हुआ हैं।
और पन्ने बढा नहीं सकतें।',
	'coll-notfound_title'             => 'कलेक्शन मिला नहीं',
	'coll-notfound_text'              => 'कलेक्शन पन्ना मिला नहीं।',
	'coll-return_to_collection'       => '<a href="$1">$2</a> पर वापस जायें',
	'coll-book_title'                 => 'छपा हुआ अवतरण माँगे',
	'coll-book_text'                  => 'आप नीचे दिये हुए प्रिन्ट-ऑन-डिमांड पार्टनर्ससे आपके कलेक्शनमें उपलब्ध पन्नोंका छपा हुआ अवतरण पा सकतें हैं:',
	'coll-order_from_pp'              => '$1 से बुक मंगायें',
	'coll-about_pp'                   => '$1 के बारे में',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'coll-cancel' => 'Kanselahon',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 * @author Siebrand
 */
$messages['hsb'] = array(
	'coll-desc'                      => '[[Special:Collection|Strony zběrać]], PDF wutworić',
	'coll-collections'               => 'Zběrki',
	'coll-portlet_title'             => 'Moja zběrka',
	'coll-add_page'                  => 'Stronu přidać',
	'coll-remove_page'               => 'Stronu wotstronić',
	'coll-add_category'              => 'Kategoriju přidać',
	'coll-load_collection'           => 'Zběrku začitać',
	'coll-show_collection'           => 'Zběrku pokazać',
	'coll-help_collections'          => 'Pomoc zběrkow',
	'coll-empty'                     => 'prózdna',
	'coll-page'                      => 'strona',
	'coll-pages'                     => 'strony',
	'coll-download_as_pdf'           => 'Jako PDF sćahnyć',
	'coll-helppage'                  => 'Help:Zběrki',
	'coll-my_collection'             => 'Moja zběrka',
	'coll-download_title'            => 'Zběrku jako PDF sćahnyć',
	'coll-download_pdf'              => 'PDF sćahnyć',
	'coll-remove'                    => 'Wotstronić',
	'coll-move_to_top'               => 'Cyle horje přesunyć',
	'coll-move_up'                   => 'Horje přesunyć',
	'coll-move_down'                 => 'Dele přesunyć',
	'coll-move_to_bottom'            => 'Cyle dele přesunyć',
	'coll-title'                     => 'Titul:',
	'coll-subtitle'                  => 'Podtitul:',
	'coll-contents'                  => 'Wobsah',
	'coll-create_chapter'            => 'Nowy kapitl wutworić',
	'coll-sort_alphabetically'       => 'Strony alfabetisce sortěrować',
	'coll-clear_collection'          => 'Zběrku wuprózdnić',
	'coll-clear_confirm'             => 'Chceš swoju zběrku woprawdźe wuprózdnić?',
	'coll-rename'                    => 'Přemjenować',
	'coll-new_chapter'               => 'Zapodaj mjeno za nowy kapitl',
	'coll-rename_chapter'            => 'Zapodaj nowe mjeno za kapitl',
	'coll-no_such_category'          => 'Žana tajka kategorija',
	'coll-notitle_title'             => 'Titul strony njeda so zwěsćić.',
	'coll-enter_title'               => 'Zapodaj titul za zběrku:',
	'coll-error_reponse'             => 'Serwer je zmylk zdźělił',
	'coll-empty_collection'          => 'Prózdna zběrka',
	'coll-revision'                  => 'Wersija: %PARAM%',
	'coll-save_collection_title'     => 'Zběrku składować',
	'coll-personal_collection_label' => 'Wosobinska zběrka:',
	'coll-save_collection'           => 'Zběrku składować',
	'coll-overwrite_title'           => 'Strona eksistuje. Přepisać?',
	'coll-yes'                       => 'Haj',
	'coll-no'                        => 'Ně',
	'coll-overwrite'                 => 'Přepisać',
	'coll-append'                    => 'Připójsnyć',
	'coll-cancel'                    => 'Přetorhnyć',
	'coll-limit_exceeded_title'      => 'Zběrka přewulka',
	'coll-notfound_title'            => 'zběrka njenamakana',
	'coll-notfound_text'             => 'Strona zběrki njebu namakana.',
	'coll-return_to_collection'      => 'Wróćo k <a href="$1">$2</a>',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'coll-title' => 'Cím:',
	'coll-yes'   => 'Igen',
	'coll-no'    => 'Nem',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'coll-empty' => 'vacue',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'coll-no'     => 'Tidak',
	'coll-cancel' => 'Batalkan',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author SPQRobin
 */
$messages['is'] = array(
	'coll-collections'          => 'Söfn',
	'coll-portlet_title'        => 'Safnið mitt',
	'coll-add_page'             => 'Bæta við síðu',
	'coll-remove_page'          => 'Fjarlægja síðu',
	'coll-add_category'         => 'Bæta við flokki',
	'coll-load_collection'      => 'Hlaða safn',
	'coll-show_collection'      => 'Sýna safn',
	'coll-help_collections'     => 'Safnhjálp',
	'coll-empty'                => 'tómur',
	'coll-page'                 => 'síða',
	'coll-pages'                => 'síður',
	'coll-download_as_pdf'      => 'Sækja sem PDF-skjal',
	'coll-my_collection'        => 'Mitt safn',
	'coll-download_pdf'         => 'Sækja PDF',
	'coll-remove'               => 'Fjarlægja',
	'coll-title'                => 'Titill:',
	'coll-rename'               => 'Endurnefna',
	'coll-new_chapter'          => 'Sláðu inn nafn á nýjum kafla',
	'coll-rename_chapter'       => 'Sláðu inn nýtt nafn fyrir kafla',
	'coll-no_such_category'     => 'Flokkur ekki til',
	'coll-save_collection'      => 'Vista safn',
	'coll-yes'                  => 'Já',
	'coll-no'                   => 'Nei',
	'coll-overwrite'            => 'Yfirrita',
	'coll-append'               => 'Auka við',
	'coll-cancel'               => 'Hætta við',
	'coll-limit_exceeded_title' => 'Safn of stórt',
	'coll-notfound_title'       => 'Safn fannst ekki',
	'coll-order_from_pp'        => 'Panta bók frá $1',
	'coll-about_pp'             => 'Um $1',
);

/** Italian (Italiano)
 * @author Pietrodn
 */
$messages['it'] = array(
	'coll-pages' => 'pagine',
);

/** Japanese (日本語)
 * @author JtFuruhata
 * @author Siebrand
 */
$messages['ja'] = array(
	'coll-desc'                       => 'PDFファイルを作成するための[[Special:Collection|ページコレクション]]',
	'coll-collections'                => 'コレクション',
	'coll-portlet_title'              => 'マイ・コレクション',
	'coll-add_page'                   => 'ページの追加',
	'coll-remove_page'                => 'ページの削除',
	'coll-add_category'               => 'カテゴリの追加',
	'coll-load_collection'            => 'コレクションの読み込み',
	'coll-show_collection'            => 'コレクションを見る',
	'coll-help_collections'           => 'コレクションのヘルプ',
	'coll-empty'                      => '何もありません',
	'coll-page'                       => 'ページ',
	'coll-pages'                      => 'ページ',
	'coll-download_as_pdf'            => 'PDF形式でダウンロード',
	'coll-noscript_text'              => '<h1>JavaScriptを利用しています！</h1>
<strong>ご利用のブラウザはJavaScriptをサポートしていないか、JavaScriptが無効になっています。
このページは、JavaScriptが有効になっていない場合、正しく動作しません。</strong>',
	'coll-intro_text'                 => 'ページコレクションを作成したり、そこからPDFファイルを作成しダウンロードしたり、後に参照したり共有するためにコレクションを保存することができます。

詳細は、[[{{MediaWiki:Coll-helppage}}|ページコレクションのヘルプ]]をご覧ください。',
	'coll-helppage'                   => 'Help:ページコレクション',
	'coll-my_collection'              => 'マイ・コレクション',
	'coll-download_title'             => 'PDF形式でコレクションをダウンロード',
	'coll-download_text'              => 'ページコレクションから自動生成されたPDFファイルをダウンロードするには、このボタンを押してください。',
	'coll-download_pdf'               => 'PDFファイルをダウンロード',
	'coll-remove'                     => '削除',
	'coll-move_to_top'                => '先頭へ',
	'coll-move_up'                    => '上へ',
	'coll-move_down'                  => '下へ',
	'coll-move_to_bottom'             => '最後尾へ',
	'coll-title'                      => 'タイトル:',
	'coll-subtitle'                   => 'サブタイトル:',
	'coll-contents'                   => '内容',
	'coll-create_chapter'             => '新しい章を作成',
	'coll-sort_alphabetically'        => 'ページを辞書順にソート',
	'coll-clear_collection'           => 'コレクションの消去',
	'coll-clear_confirm'              => '本当にあなたのコレクションを消去してもよろしいですか？',
	'coll-rename'                     => '名称変更',
	'coll-new_chapter'                => '新しい章見出しを入力',
	'coll-rename_chapter'             => '新しい章見出しを入力',
	'coll-no_such_category'           => '指定されたカテゴリは存在しません',
	'coll-notitle_title'              => 'ページタイトルが未設定です。',
	'coll-post_failed_title'          => 'POSTリクエストの失敗',
	'coll-post_failed_msg'            => 'このPOSTリクエストは失敗しました ($2)。',
	'coll-enter_title'                => 'コレクションのタイトルを入力:',
	'coll-error_reponse'              => 'サーバからのエラーレスポンス',
	'coll-empty_collection'           => '空のコレクション',
	'coll-revision'                   => '特定版: %PARAM%',
	'coll-save_collection_title'      => 'コレクションの保存',
	'coll-save_collection_text'       => '後に利用するためコレクションを保存するには、コレクションタイプを選択し、ページタイトルを入力してください:',
	'coll-login_to_save'              => '後に利用するためコレクションを保存するには、[[Special:Userlogin|ログインまたはアカウント作成]]を行ってください。',
	'coll-personal_collection_label'  => '個人的なコレクション:',
	'coll-community_collection_label' => '共有するコレクション:',
	'coll-save_collection'            => 'コレクションの保存',
	'coll-overwrite_title'            => '同名のページが存在します。上書きしますか？',
	'coll-overwrite_text'             => '[[:$1]] という名前のページが既に存在しています。
これをあなたのコレクションに置き換えますか？',
	'coll-yes'                        => 'はい',
	'coll-no'                         => 'いいえ',
	'coll-load_overwrite_text'        => 'あなたのコレクションには既に複数のページが存在しています。
現在のコレクションで上書きする、既存コレクションに追加する、キャンセルする、のいずれかを選択してください。',
	'coll-overwrite'                  => '上書き',
	'coll-append'                     => '追加',
	'coll-cancel'                     => 'キャンセル',
	'coll-limit_exceeded_title'       => 'コレクションが大きすぎます',
	'coll-limit_exceeded_text'        => 'あなたのページコレクションは大きすぎます。
これ以上のページを追加することはできません。',
	'coll-notfound_title'             => 'コレクションが見つかりません',
	'coll-notfound_text'              => 'コレクションの保存ページが見つかりませんでした。',
	'coll-return_to_collection'       => '<a href="$1">$2</a>に戻る',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Siebrand
 */
$messages['jv'] = array(
	'coll-desc'                       => '[[Special:Collection|Kolèksi kaca-kaca]], nggawé PDF',
	'coll-collections'                => 'Kolèksi-kolèksi',
	'coll-portlet_title'              => 'Kolèksiku',
	'coll-add_page'                   => 'Tambahna kaca',
	'coll-remove_page'                => 'Ilangana kaca',
	'coll-add_category'               => 'Tambah kategori',
	'coll-load_collection'            => 'Unggahna kolèksi',
	'coll-show_collection'            => 'Tuduhna kolèksi',
	'coll-help_collections'           => 'Pitulung kolèksi',
	'coll-empty'                      => 'kosong',
	'coll-page'                       => 'kaca',
	'coll-pages'                      => 'kaca-kaca',
	'coll-download_as_pdf'            => 'Undhuhen minangka PDF',
	'coll-helppage'                   => 'Help:Collections',
	'coll-my_collection'              => 'Kolèksiku',
	'coll-download_title'             => 'Undhuh Kolèksi minangka PDF',
	'coll-download_text'              => 'Kanggo ngundhuh berkas PDF sing digawé sacara otomatis saka kolèksi kaca panjenengan, mangga ngeklik tombolé.',
	'coll-download_pdf'               => 'Undhuh PDF',
	'coll-remove'                     => 'Ilangana',
	'coll-title'                      => 'Irah-irahan (judhul):',
	'coll-subtitle'                   => 'Subjudhul:',
	'coll-contents'                   => 'Isi',
	'coll-create_chapter'             => 'Nggawé bab anyar',
	'coll-sort_alphabetically'        => 'Sortir kaca-kaca sacara alfabètis',
	'coll-clear_collection'           => 'Kosongna kolèksi',
	'coll-clear_confirm'              => 'Apa panjenengan pancèn bener ngosongi kolèksi panjenengan?',
	'coll-rename'                     => 'Ganti jeneng',
	'coll-new_chapter'                => 'Lebokna jeneng anyar kanggo bab',
	'coll-rename_chapter'             => 'Lebokna jeneng anyar kanggo bab',
	'coll-no_such_category'           => 'Ora ana kategori kaya mengkono',
	'coll-notitle_title'              => 'Irah-irahan kaca iki ora bisa ditemtokaké.',
	'coll-enter_title'                => 'Lebokna irah-irahan (judhul) kanggo kolèksi:',
	'coll-empty_collection'           => 'Kolèksi kosong',
	'coll-revision'                   => 'Révisi: %PARAM%',
	'coll-save_collection_title'      => 'Simpen Kolèksi',
	'coll-personal_collection_label'  => 'Kolèksi pribadi:',
	'coll-community_collection_label' => 'Kolèksi komunitas:',
	'coll-save_collection'            => 'Simpen kolèksi',
	'coll-overwrite_title'            => 'Kaca wis ana. Ditimpa waé?',
	'coll-yes'                        => 'Iya',
	'coll-no'                         => 'Ora',
	'coll-overwrite'                  => 'Timpanen',
	'coll-append'                     => 'Lampirna',
	'coll-cancel'                     => 'Batal',
	'coll-limit_exceeded_title'       => 'Kolèksi Kegedhèn',
	'coll-limit_exceeded_text'        => 'Kolèksi kaca panjenengan iku kegedhèn.
Ora bisa nambah kaca-kaca liya manèh.',
	'coll-notfound_title'             => 'Kolèksi Ora Ditemokaké',
	'coll-notfound_text'              => 'Ora bisa nemokaké kaca kolèksi.',
	'coll-return_to_collection'       => 'Bali menyang <a href="$1">$2</a>',
	'coll-book_title'                 => 'Pesen Buku Cithak',
	'coll-order_from_pp'              => 'Pesen buku saka $1',
	'coll-about_pp'                   => 'Perkara $1',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author គីមស៊្រុន
 * @author Lovekhmer
 * @author Siebrand
 */
$messages['km'] = array(
	'coll-add_page'             => 'បន្ថែមទំព័រ',
	'coll-remove_page'          => 'ដកទំព័រចេញ',
	'coll-add_category'         => 'បន្ថែមចំណាត់ក្រុម',
	'coll-empty'                => 'ទទេ',
	'coll-page'                 => 'ទំព័រ',
	'coll-pages'                => 'ទំព័រ',
	'coll-download_as_pdf'      => 'ទាញយកជា​ PDF',
	'coll-my_collection'        => 'ការប្រមូលផ្តុំរបស់ខ្ញុំ',
	'coll-download_pdf'         => 'ទាញយក PDF',
	'coll-remove'               => 'ដកចេញ',
	'coll-move_to_top'          => 'ទៅ​លើគេបំផុត',
	'coll-move_up'              => 'រំកិលឡើង',
	'coll-move_down'            => 'រំកិលចុះ',
	'coll-move_to_bottom'       => 'ទៅក្រោមគេបំផុត',
	'coll-title'                => 'ចំណងជើង៖',
	'coll-subtitle'             => 'ចំណងជើងរង៖',
	'coll-contents'             => 'ខ្លឹមសារ',
	'coll-create_chapter'       => 'បង្កើតជំពូកថ្មី',
	'coll-sort_alphabetically'  => 'តំរៀប​ទំព័រ​តាម​អក្ខរក្រម',
	'coll-rename'               => 'ប្តូរឈ្មោះ',
	'coll-new_chapter'          => 'ដាក់ឈ្មោះអោយ ជំពូកថ្មី',
	'coll-rename_chapter'       => 'ដាក់ឈ្មោះថ្មី អោយជំពូក',
	'coll-no_such_category'     => 'គ្មានចំណាត់ក្រុម ដូចនេះទេ',
	'coll-notitle_title'        => 'មិន​អាចកំនត់​ចំនងជើង​នៃទំព័រ',
	'coll-overwrite_title'      => 'ទំព័រ​មានហើយ។ សរសេរ​ជាន់ពីលើ ?',
	'coll-yes'                  => 'បាទ / ចាស',
	'coll-no'                   => 'ទេ',
	'coll-overwrite'            => 'សរសេរជាន់ពីលើ',
	'coll-append'               => 'បន្ថែមនៅចុង',
	'coll-cancel'               => 'បោះបង់',
	'coll-return_to_collection' => 'ត្រលប់ទៅកាន់<a href="$1">$2</a>វិញ',
	'coll-book_title'           => 'ទិញសៀវភៅដែលបានបោះពុម្ព',
	'coll-order_from_pp'        => 'បញ្ជាទិញ​សៀវភៅពី $1',
	'coll-about_pp'             => 'អំពី$1',
	'coll-license'              => 'អាជ្ញាបណ្ណ',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'coll-page'     => 'pahina',
	'coll-contents' => 'Manga Sulud',
	'coll-cancel'   => 'Kanselar',
	'coll-about_pp' => 'Angut sa Iwan $1',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'coll-empty'    => 'leddich',
	'coll-cancel'   => 'Ophüre',
	'coll-about_pp' => 'Üvver $1',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 * @author Siebrand
 */
$messages['lb'] = array(
	'coll-desc'                       => "[[Special:Collection|Säiten zesummestellen]], PDF'e generéieren",
	'coll-collections'                => 'Sammlungen',
	'coll-portlet_title'              => 'Meng Sammlung',
	'coll-add_page'                   => 'Säit derbäisetzen',
	'coll-remove_page'                => 'Säit ewechhuelen',
	'coll-add_category'               => 'Kategorie derbäisetzen',
	'coll-load_collection'            => 'Sammlung lueden',
	'coll-show_collection'            => "D'Sammlung weisen",
	'coll-help_collections'           => "Hellëf iwwert d 'Sammlungen",
	'coll-empty'                      => 'eidel',
	'coll-page'                       => 'Säit',
	'coll-pages'                      => 'Säiten',
	'coll-download_as_pdf'            => 'Als PDF eroflueden',
	'coll-download_as_odf'            => 'Als ODF eroflueden',
	'coll-noscript_text'              => '<h1>JavaScript gëtt gebraucht!</h1>
<strong>Äre Browser ënnerstëtzt Java Script net oder JavaScript ass ausgeschalt.
Dës Säit fonctionnéiert net richteg, ausser wa JavaScript ageschalt ass</strong>',
	'coll-helppage'                   => 'Help:Kollektioun',
	'coll-my_collection'              => 'Meng Sammlung',
	'coll-download_title'             => 'Kollektioun als PDF eroflueden',
	'coll-download_pdf'               => 'PDF eroflueden',
	'coll-remove'                     => 'Ewechhuelen',
	'coll-move_to_top'                => 'No ganz uewe réckelen',
	'coll-move_up'                    => 'Eropréckelen',
	'coll-move_down'                  => 'Erofréckelen',
	'coll-move_to_bottom'             => 'No ganz ënne réckelen',
	'coll-title'                      => 'Titel:',
	'coll-subtitle'                   => 'Ënnertitel:',
	'coll-create_chapter'             => 'Een neit Kapitel maachen',
	'coll-sort_alphabetically'        => 'Säiten alphabetesch sortéieren',
	'coll-clear_collection'           => 'Sammlung eidel maachen',
	'coll-clear_confirm'              => 'Wëllt Dir äer Kollektioun wierklech eidel maachen?',
	'coll-rename'                     => 'Ëmbenennen',
	'coll-new_chapter'                => 'Gitt den Numm fir dat neit Kapitel un',
	'coll-rename_chapter'             => "Gitt een neie Numm fir d'Kapitel un",
	'coll-no_such_category'           => 'Keng esou Kategorie',
	'coll-notitle_title'              => 'Den Titel vun der Säit konnt net festgestallt ginn.',
	'coll-pdfserver_failed_title'     => 'PDF Server Feeler',
	'coll-pdfserver_failed_msg'       => 'Feeler um PDF-Server: $1',
	'coll-enter_title'                => 'Titel vun der Kollektioun uginn:',
	'coll-error_reponse'              => 'Feelermeldng vum Server',
	'coll-empty_collection'           => 'Eidel Sammlung',
	'coll-revision'                   => 'Versioun: %PARAM%',
	'coll-save_collection_title'      => 'Sammlung späicheren',
	'coll-personal_collection_label'  => 'Perséinlech Sammlung',
	'coll-community_collection_label' => 'Gemeinsam Kollektioun:',
	'coll-save_collection'            => 'Sammlung späicheren',
	'coll-overwrite_title'            => "D'Säit gëtt et. Iwwerschreiwen?",
	'coll-yes'                        => 'Jo',
	'coll-no'                         => 'Neen',
	'coll-overwrite'                  => 'Iwwerschreiwen',
	'coll-append'                     => 'Derbäisetzen',
	'coll-cancel'                     => 'Annulléieren',
	'coll-limit_exceeded_title'       => 'Sammlung ze grouss',
	'coll-limit_exceeded_text'        => 'Är Sammlung ass ze grouss.
Et kënne keng Säite méi derbäigesat ginn.',
	'coll-return_to_collection'       => 'Zréck op <a href="$1">$2</a>',
	'coll-book_title'                 => 'Gedréckte Buch bestellen',
	'coll-book_text'                  => 'Dir kënnt e Buch bestellen op enge vun dësen Internetsiten:',
	'coll-order_from_pp'              => "D'Buch bestelle bäi $1",
	'coll-about_pp'                   => 'Iwwer $1',
	'coll-license'                    => 'Lizenz',
);

/** Lao (ລາວ)
 * @author Passawuth
 */
$messages['lo'] = array(
	'coll-page'   => 'ໜ້າ',
	'coll-pages'  => 'ໜ້າ',
	'coll-remove' => 'ເອົາອອກ',
	'coll-yes'    => 'ໃຊ່',
	'coll-no'     => 'ບໍ່ໃຊ່',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 * @author Siebrand
 */
$messages['ml'] = array(
	'coll-desc'                       => '[[Special:Collection|താളുകളുടെ ശേഖരം]], PDF നിര്‍മ്മിക്കുക',
	'coll-collections'                => 'ശേഖരങ്ങള്‍',
	'coll-portlet_title'              => 'എന്റെ ശേഖരം',
	'coll-add_page'                   => 'താള്‍ ചേര്‍ക്കുക',
	'coll-remove_page'                => 'താള്‍ മാറ്റുക',
	'coll-add_category'               => 'വിഭാഗം ചേര്‍ക്കുക',
	'coll-load_collection'            => 'ശേഖരം ലോഡ് ചെയ്യുക',
	'coll-show_collection'            => 'ശേഖരം കാണിക്കുക',
	'coll-help_collections'           => 'ശേഖരങ്ങളുടെ സഹായം',
	'coll-empty'                      => 'ശൂന്യം',
	'coll-page'                       => 'താള്‍',
	'coll-pages'                      => 'താളുകള്‍',
	'coll-download_as_pdf'            => 'PDF ആയി ഡൗണ്‍ലോഡ് ചെയ്യുക',
	'coll-helppage'                   => 'Help:ശേഖരം',
	'coll-my_collection'              => 'എന്റെ ശേഖരം',
	'coll-download_title'             => 'ശേഖരം PDF ആയി ഡൗണ്‍ലോഡ് ചെയ്യുക.',
	'coll-download_text'              => 'താളുകളുടെ ശേഖരത്തിന്റെ യാന്ത്രികമായി നിര്‍മ്മിക്കപ്പെട്ട PDF ഡൗലോഡ് ചെയ്യുന്നതിനു ബട്ടണില്‍ ഞെക്കുക.',
	'coll-download_pdf'               => 'PDF ഡൗണ്‍ലോഡ് ചെയ്യുക',
	'coll-remove'                     => 'നീക്കം ചെയ്യുക',
	'coll-move_to_top'                => 'ഏറ്റവും മുകളിലേക്ക് നീങ്ങുക',
	'coll-move_up'                    => 'മുകളിലേക്കു നീങ്ങുക',
	'coll-move_down'                  => 'താഴേക്ക് നീങ്ങുക',
	'coll-move_to_bottom'             => 'ഏറ്റവും താഴേക്ക് നീങ്ങുക',
	'coll-title'                      => 'ശീര്‍ഷകം:',
	'coll-subtitle'                   => 'ഉപശീര്‍ഷകം:',
	'coll-contents'                   => 'ഉള്ളടക്കം',
	'coll-create_chapter'             => 'പുതിയ അദ്ധ്യായം സൃഷ്ടിക്കുക',
	'coll-sort_alphabetically'        => 'താളുകള്‍ അകാദാരിക്രമത്തില്‍ ക്രമീകരിക്കുക',
	'coll-clear_collection'           => 'ശേഖരം മായ്ക്കുക',
	'coll-clear_confirm'              => 'താങ്കളുടെ താളുകളുടെ ശേഖ്രം മായ്ക്കണമെന്നതു നിര്‍ബന്ധമാണോ?',
	'coll-rename'                     => 'പുനഃര്‍നാമകരണം ചെയ്യുക',
	'coll-new_chapter'                => 'പുതിയ അദ്ധ്യായത്തിനു ഒരു പേരു കൊടുക്കുക',
	'coll-rename_chapter'             => 'അദ്ധ്യായത്തിനു പുതിയൊരു പേരു കൊടുക്കുക',
	'coll-no_such_category'           => 'അങ്ങനെ ഒരു വിഭാഗം നിലവിലില്ല',
	'coll-notitle_title'              => 'താളിന്റെ തലക്കെട്ട് നിര്‍ണ്ണയിക്കുന്നതിനു കഴിഞ്ഞില്ല.',
	'coll-enter_title'                => 'ശേഖരത്തിനു ഒരു ശീര്‍ഷകം ചേര്‍ക്കുക:',
	'coll-error_reponse'              => 'സെര്‍‌വറില്‍ നിന്നു പിഴവാണെന്ന മറുപടി കിട്ടി.',
	'coll-empty_collection'           => 'ശൂന്യമായ ശേഖരം',
	'coll-revision'                   => 'പതിപ്പ്: %PARAM%',
	'coll-save_collection_title'      => 'ശേഖരം സേവ് ചെയ്യുക',
	'coll-save_collection_text'       => 'ഈ ശേഖരം പിന്നിടുള്ള ഉപയോഗത്തിനായി സൂക്ഷിക്കണമെങ്കില്‍ ശേഖര തരം തിരഞ്ഞെടുത്ത് ഒരു ശീര്‍ഷകം നല്‍കുക:',
	'coll-login_to_save'              => 'ശേഖരങ്ങള്‍ പിന്നീടുള്ള ഉപയോഗത്തിനായി സൂക്ഷിക്കണമെങ്കില്‍, ദയവായി [[Special:Userlogin|ലോഗിന്‍ ചെയ്യുകയോ പുതിയൊരു അക്കൗണ്ട് ഉണ്ടാക്കുകയോ ചെയ്യുക]].',
	'coll-personal_collection_label'  => 'സ്വകാര്യ ശേഖരം:',
	'coll-community_collection_label' => 'സമൂഹ ശേഖരം:',
	'coll-save_collection'            => 'ശേഖരം സേവ് ചെയ്യുക',
	'coll-overwrite_title'            => 'താള്‍ നിലവിലുണ്ട്. അതിനെ ഓവര്‍റൈറ്റ് ചെയ്യട്ടെ?',
	'coll-overwrite_text'             => '[[:$1]] എന്ന പേരില്‍ ഒരു താള്‍ നിലവിലുണ്ട്. താങ്കളുടെ ശേഖരം ആ താളിനു ബദലാക്കണോ?',
	'coll-yes'                        => 'ശരി',
	'coll-no'                         => 'ഇല്ല',
	'coll-load_overwrite_text'        => 'താങ്കളുടെ ശേഖരത്തില്‍ ഇപ്പോള്‍ തന്നെ കുറച്ചു താളുകള്‍ ഉണ്ട്.
താങ്കള്‍ക്കു നിലവിലുള്ള ശേഖരം മാറ്റണോ, പുതിയ താളുകള്‍ നിലവിലുള്ളതില്‍ ചേര്‍ക്കണോ, അതോ ഈ പ്രക്രിയ നിരാകരിക്കണോ?',
	'coll-overwrite'                  => 'ഓവര്‍റൈറ്റ്',
	'coll-append'                     => 'കൂട്ടിചേര്‍ക്കുക',
	'coll-cancel'                     => 'റദ്ദാക്കുക',
	'coll-limit_exceeded_title'       => 'ശേഖരത്തിന്റെ വലിപ്പം വളരെ കൂടുതലാണ്‌',
	'coll-limit_exceeded_text'        => 'താങ്കളുടെ ശേഖരം വളരെ വലുതാണ്‌. ഇനി കൂടുതല്‍ താളുകള്‍ ചേര്‍ക്കുന്നതിനു സാദ്ധ്യമല്ല.',
	'coll-notfound_title'             => 'ശേഖരം കണ്ടില്ല',
	'coll-notfound_text'              => 'ശേഖര താള്‍ കണ്ടെത്താന്‍ കഴിഞ്ഞില്ല.',
	'coll-return_to_collection'       => '<a href="$1">$2</a>-ലേക്കു തിരിച്ചു പോവുക',
	'coll-book_title'                 => 'അച്ചടിച്ച പുസ്തകം ഓര്‍ഡര്‍ ചെയ്യുക',
	'coll-book_text'                  => 'താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന സേവനദാതാക്കളെ സന്ദര്‍ശിച്ച് നിങ്ങളുടെ ശേഖരത്തിന്റെ അച്ചടി രൂപം ഓര്‍ഡര്‍ ചെയ്യാവുന്നതാണ്‌:',
	'coll-order_from_pp'              => '$1-ല്‍ നിന്നു പുസ്തകം ഓര്‍ഡര്‍ ചെയ്യുക',
	'coll-about_pp'                   => '$1-നെ കുറിച്ച്',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Siebrand
 * @author Mahitgar
 */
$messages['mr'] = array(
	'coll-desc'                       => '[[Special:Collection|पाने गोळा करा]], पीडीएफ तयार करा',
	'coll-collections'                => 'गोळा केलेली पाने',
	'coll-portlet_title'              => 'मी गोळा केलेली पाने',
	'coll-add_page'                   => 'पानाचा समावेश करा',
	'coll-remove_page'                => 'पान काढा',
	'coll-add_category'               => 'वर्गाचा समावेश करा',
	'coll-load_collection'            => 'गोळाकेलेली पाने दाखवा',
	'coll-show_collection'            => 'गोळा केलेली पाने दाखवा',
	'coll-help_collections'           => 'पाने गोळा करण्यासाठी मदत',
	'coll-empty'                      => 'रिकामे',
	'coll-page'                       => 'पान',
	'coll-pages'                      => 'पाने',
	'coll-download_as_pdf'            => 'पीडीएफ आवृत्ती उतरवा',
	'coll-noscript_text'              => '<h1>जावास्क्रीप्ट आवश्यक!</h1>
<strong>तुमचा ब्राउझार जावास्क्रीप्ट वापरू शकत नाही किंवा वापर बंद केलेला आहे.
जावास्क्रीप्ट चालू केल्याशिवाय हे पान व्यवस्थित काम करणार नाही.</strong>',
	'coll-intro_text'                 => 'तुम्ही काही पाने गोळा करू शकता, त्यांच्या पीडीएफ आवृत्त्या उतरवून घेऊ शकता किंवा गोळा केलेली पाने नंतर वापरण्यासाठी अथवा इतरांना देण्यासाठी जतन करून ठेऊ शकता.

अधिक माहितीसाठी [[{{MediaWiki:Coll-helppage}}|पाने गोळा करण्यासाठी मदत]] पहा.',
	'coll-helppage'                   => 'Help:गोळा केलेली पाने',
	'coll-my_collection'              => 'मी गोळा केलेली पाने',
	'coll-download_title'             => 'गोळा केलेल्या पानांची पीडीएफ आवृत्ती उतरवून घ्या',
	'coll-download_text'              => 'तुम्ही गोळा केलेल्या पानांच्या पीडीएफ आवृत्त्या गोळा करण्यासाठी, दिलेली कळ दाबा.',
	'coll-download_pdf'               => 'पीडीएफ उतरवा',
	'coll-remove'                     => 'वगळा',
	'coll-move_to_top'                => 'सर्वात वर हलवा',
	'coll-move_up'                    => 'वर हलवा',
	'coll-move_down'                  => 'खाली हलवा',
	'coll-move_to_bottom'             => 'सर्वात खाली हलवा',
	'coll-title'                      => 'शीर्षक:',
	'coll-subtitle'                   => 'उपशीर्षक:',
	'coll-contents'                   => 'अनुक्रमणिका',
	'coll-create_chapter'             => 'नवीन धडा बनवा',
	'coll-sort_alphabetically'        => 'अक्षरांप्रमाणे पानांचे वर्गीकरण करा',
	'coll-clear_collection'           => 'सर्व गोळा केलेली पाने पुसा',
	'coll-clear_confirm'              => 'तुम्ही खरोखर सर्व गोळा केलेली पाने काढून टाकू इच्छिता?',
	'coll-rename'                     => 'नाव बदला',
	'coll-new_chapter'                => 'नवीन धड्याचे नाव लिहा',
	'coll-rename_chapter'             => 'नवीन धड्याचे नाव लिहा',
	'coll-no_such_category'           => 'असा वर्ग अस्तित्वात नाही',
	'coll-notitle_title'              => 'या पानाचे शीर्षक ठरविता आलेले नाही.',
	'coll-post_failed_title'          => 'पोस्ट (POST) ची मागणी पूर्ण झालेली नाही',
	'coll-post_failed_msg'            => '$1 ची पोस्ट (POST) मागणी पूर्ण झालेली नाही ($2).',
	'coll-enter_title'                => 'कलेल्शनला शीर्षक द्या:',
	'coll-error_reponse'              => 'सर्व्हर कडून चुकीचा संदेश आलेला आहे',
	'coll-empty_collection'           => 'रिकामे कलेक्शन',
	'coll-revision'                   => 'आवृत्ती: %PARAM%',
	'coll-save_collection_title'      => 'कलेक्शन जतन करा',
	'coll-save_collection_text'       => 'हे कलेक्शन नंतर वापरण्यासाठी पानाला शीर्षक देउन तसेच कलेक्शनचा प्रकार निवडून जतन करा:',
	'coll-login_to_save'              => 'जर तुम्ही कलेक्शन नंतर वापरण्यासाठी जतन करू इच्छित असाल, तर कृपया [[Special:Userlogin|प्रवेश करा अथवा सदस्य नोंदणी करा]].',
	'coll-personal_collection_label'  => 'वैयक्तिक कलेक्शन:',
	'coll-community_collection_label' => 'सामुहिक कलेक्शन:',
	'coll-save_collection'            => 'कलेक्शन जतन करा',
	'coll-overwrite_title'            => 'पान अस्तित्वात आहे. पुनर्लेखन करायचे का?',
	'coll-overwrite_text'             => '[[:$1]] या नावाचे पान अगोदरच अस्तित्वात आहे.
तुम्ही त्यावर तुमचे कलेक्शन पुनर्लेखित करू इच्छिता का?',
	'coll-yes'                        => 'होय',
	'coll-no'                         => 'नाही',
	'coll-load_overwrite_text'        => 'तुमच्या कलेक्शन मध्ये अगोदरच काही पाने आहेत.
तुम्ही तुमचे कलेक्शन पुनर्लेखित करू इच्छिता, की पाने वाढवू इच्छिता की रद्द करु इच्छिता?',
	'coll-overwrite'                  => 'पुनर्लेखन करा',
	'coll-append'                     => 'वाढवा',
	'coll-cancel'                     => 'रद्द करा',
	'coll-limit_exceeded_title'       => 'कलेक्शन खूप मोठे झालेले आहे',
	'coll-limit_exceeded_text'        => 'तुमचे पानांचे कलेक्शन खूप मोठे झालेले आहे.
आणखी पाने वाढविता येणार नाहीत.',
	'coll-notfound_title'             => 'कलेक्शन सापडले नाही',
	'coll-notfound_text'              => 'कलेक्शन पान सापडले नाही.',
	'coll-return_to_collection'       => '<a href="$1">$2</a> कडे परत जा',
	'coll-book_title'                 => 'छापील आवृत्तीची मागणी नोंदवा',
	'coll-book_text'                  => 'तुम्ही खाली दिलेल्या मागणीनुसार छपाई करणार्‍या जोडीदारांच्या संकेतस्थळाला भेट देऊन तुमच्या कलेक्शन मधील पानांची छापील आवृत्ती मिळवू शकता:',
	'coll-order_from_pp'              => '$1 कडून छापील प्रत मागवा',
	'coll-about_pp'                   => '$1 बद्दल',
	'coll-invalid_podpartner_title'   => 'चुकीचा POD भागीदार',
	'coll-invalid_podpartner_msg'     => 'दिलेला POD भागीदार चुकीचा आहे.
कृपया मीडियाविकि प्रबंधकाशी संपर्क करा.',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'coll-page'   => 'zāzanilli',
	'coll-title'  => 'Tōcāitl:',
	'coll-yes'    => 'Quēmah',
	'coll-no'     => 'Ahmo',
	'coll-cancel' => 'Ticcuepāz',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 * @author Siebrand
 */
$messages['nds'] = array(
	'coll-add_page'             => 'Sied tofögen',
	'coll-remove_page'          => 'Sied rutnehmen',
	'coll-add_category'         => 'Kategorie tofögen',
	'coll-empty'                => 'leddig',
	'coll-page'                 => 'Sied',
	'coll-pages'                => 'Sieden',
	'coll-download_as_pdf'      => 'As PDF dalladen',
	'coll-download_pdf'         => 'PDF dalladen',
	'coll-remove'               => 'Rutnehmen',
	'coll-title'                => 'Titel:',
	'coll-subtitle'             => 'Ünnertitel:',
	'coll-sort_alphabetically'  => 'Sieden alphabeetsch sorteren',
	'coll-rename'               => 'Ne’en Naam geven',
	'coll-overwrite_title'      => 'Sied gifft dat al. Överschrieven?',
	'coll-yes'                  => 'Jo',
	'coll-no'                   => 'Nee',
	'coll-overwrite'            => 'Överschrieven',
	'coll-cancel'               => 'Afbreken',
	'coll-return_to_collection' => 'Trüch na <a href="$1">$2</a>',
	'coll-order_from_pp'        => 'Book bestellen bi $1',
	'coll-about_pp'             => 'Över $1',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 * @author GerardM
 */
$messages['nl'] = array(
	'coll-desc'                       => "[[Special:Collection|Pagina's verzamelen]], PDF's genereren",
	'coll-collections'                => 'Verzamelingen',
	'coll-portlet_title'              => 'Mijn verzameling',
	'coll-add_page'                   => 'Pagina toevoegen',
	'coll-remove_page'                => 'Pagina verwijderen',
	'coll-add_category'               => 'Categorie toevoegen',
	'coll-load_collection'            => 'Verzameling laden',
	'coll-show_collection'            => 'Verzameling weergeven',
	'coll-help_collections'           => 'Hulp bij verzamelingen',
	'coll-empty'                      => 'leeg',
	'coll-page'                       => 'pagina',
	'coll-pages'                      => "pagina's",
	'coll-download_as_pdf'            => 'Als PDF downloaden',
	'coll-download_as_odf'            => 'Als ODF downloaden',
	'coll-noscript_text'              => '<h1>JavaScript is vereist!</h1>
<strong>Uw browser understeunt geen JavaScript of JavaScript is uitgeschakeld.
Deze pagina werkt niet correct tenzij u JavaScript inschakelt.</strong>',
	'coll-intro_text'                 => "U kunt pagina's in een verzameling plaatsen, een PDF-bestand maken en downloaden van een paginaverzameling, en paginaverzameling opslaan voor later gebruik, of om ze te delen.

[[{{MediaWiki:Coll-helppage}}|Meer informatie over verzamelingen]].",
	'coll-helppage'                   => 'Help:Verzamelingen',
	'coll-too_big_cat'                => "Deze categorie bevat meer dan %PARAM% pagina's. Alleen de eerste %PARAM% pagina's worden aan uw collectie toegevoegd.
Wilt u ze toevoegen?",
	'coll-my_collection'              => 'Mijn verzameling',
	'coll-download_title'             => 'Verzameling als PDF downloaden',
	'coll-download_text'              => 'Klik op de knop om een automatisch gemaakt PDF-bestand van uw paginaverzameling te downloaden.',
	'coll-download_pdf'               => 'PDF downloaden',
	'coll-remove'                     => 'Verwijderen',
	'coll-move_to_top'                => 'Helemaal naar boven',
	'coll-move_up'                    => 'Naar boven',
	'coll-move_down'                  => 'Naar onderen',
	'coll-move_to_bottom'             => 'Helemaal naar onderen',
	'coll-title'                      => 'Titel:',
	'coll-subtitle'                   => 'Ondertitel:',
	'coll-contents'                   => 'Inhoud',
	'coll-create_chapter'             => 'Nieuw hoofdstuk maken',
	'coll-sort_alphabetically'        => "Pagina's alfabetisch sorteren",
	'coll-clear_collection'           => 'Verzameling leegmaken',
	'coll-clear_confirm'              => 'Weet u zeker dat u de verzameling leeg wilt maken?',
	'coll-rename'                     => 'Hernoemen',
	'coll-new_chapter'                => 'Voer de naam van het nieuwe hofdstuk in',
	'coll-rename_chapter'             => 'Voer een nieuwe naam in voor het hoofdstuk',
	'coll-no_such_category'           => 'De categorie bestaat niet',
	'coll-notitle_title'              => 'De titel van de pagina kon niet vastgesteld worden.',
	'coll-post_failed_title'          => 'POST-verzoek mislukt',
	'coll-post_failed_msg'            => 'Het POST-verzoek naar $1 is mislukt ($2).',
	'coll-pdfserver_failed_title'     => 'Fout in de PDF-server',
	'coll-pdfserver_failed_msg'       => 'De PDF-server geeft de volgende foutmelding: $1',
	'coll-enter_title'                => 'Voer een titel in voor de verzameling:',
	'coll-error_reponse'              => 'De server heeft een foutmelding teruggegeven',
	'coll-empty_collection'           => 'Lege verzameling',
	'coll-revision'                   => 'Versie: %PARAM%',
	'coll-save_collection_title'      => 'Verzameling opslaan',
	'coll-save_collection_text'       => 'Kies een verzamelingstype en voer een paginatitel in om deze verzameling op te slaan voor later gebruik:',
	'coll-login_to_save'              => 'Als u verzamelingen wil opslaan voor later gebruik, [[Special:Userlogin|meld u zich dan aan of maak een gebruiker aan]].',
	'coll-personal_collection_label'  => 'Persoonlijke verzameling:',
	'coll-community_collection_label' => 'Gemeenschappelijke verzameling:',
	'coll-save_collection'            => 'Verzameling opslaan',
	'coll-overwrite_title'            => 'De pagina bestaat al. Overschrijven?',
	'coll-overwrite_text'             => 'Er bestaat al een pagina met de naam [[:$1]].
Wil u die pagina vervangen door uw verzameling?',
	'coll-yes'                        => 'Ja',
	'coll-no'                         => 'Nee',
	'coll-load_overwrite_text'        => "U hebt al een aantal pagina's in uw verzameling.
Wil u de bestaande verzameling overschrijven, de nieuwe pagina's toevoegen, of annuleren?",
	'coll-overwrite'                  => 'Overschrijven',
	'coll-append'                     => 'Toevoegen',
	'coll-cancel'                     => 'Annuleren',
	'coll-limit_exceeded_title'       => 'Verzameling is te groot',
	'coll-limit_exceeded_text'        => "Uw paginaverzameling is te groot.
U kunt geen pagina's meer toevoegen.",
	'coll-rendering_title'            => 'Bezig met renderen',
	'coll-rendering_text'             => "'''Het document wordt aangemaakt.'''

Voortgang: '''\$1%'''.

Deze pagina wordt regelmatig bijgewerkt.
Als dit niet werkt, klik dan op de knop \"Vernieuwen\" in uw browser.",
	'coll-rendering_finished_title'   => 'Renderen afgerond',
	'coll-rendering_finished_text'    => "'''Het document is aangemaakt.'''
[$1 Klik hier] om het te downloaden.

Niet tevreden met de uitvoer?
Op de [[{{MediaWiki:Coll-helppage}}|hulppagina over collecties]] staan tips om deze te verbeteren.",
	'coll-notfound_title'             => 'Verzameling niet gevonden',
	'coll-notfound_text'              => 'De verzamelingspagina is niet gevonden.',
	'coll-return_to_collection'       => 'Teruggaan naar <a href="$1">$2</a>',
	'coll-book_title'                 => 'Gedrukt boek bestellen',
	'coll-book_text'                  => 'U kunt een gedrukt boek bestellen dat uw paginaverzameling bevat door een van de volgende print-on-demand-partners te bezoeken:',
	'coll-order_from_pp'              => 'Boek bij $1 bestellen',
	'coll-about_pp'                   => 'Over $1',
	'coll-invalid_podpartner_title'   => 'Ongeldige print on demand-partner',
	'coll-invalid_podpartner_msg'     => 'De opgegeven print on demand-partner is ongeldig.
Neem alstublieft contact op met uw MediaWiki-beheerder.',
	'coll-license'                    => 'Licentie',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'coll-empty'  => 'tom',
	'coll-page'   => 'side',
	'coll-pages'  => 'sider',
	'coll-remove' => 'Fjern',
	'coll-title'  => 'Tittel:',
	'coll-yes'    => 'Ja',
	'coll-no'     => 'Nei',
	'coll-cancel' => 'Avbryt',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Siebrand
 * @author H92
 */
$messages['no'] = array(
	'coll-desc'                       => 'Lag [[Special:Collection|sidesamlinger]] og generer PDF-filer',
	'coll-collections'                => 'Samlinger',
	'coll-portlet_title'              => 'Min samling',
	'coll-add_page'                   => 'Legg til side',
	'coll-remove_page'                => 'Fjern side',
	'coll-add_category'               => 'Legg til kategori',
	'coll-load_collection'            => 'Last samling',
	'coll-show_collection'            => 'Vis samling',
	'coll-help_collections'           => 'Hjelp for samlinger',
	'coll-empty'                      => 'tom',
	'coll-page'                       => 'side',
	'coll-pages'                      => 'sider',
	'coll-download_as_pdf'            => 'Last ned som PDF',
	'coll-download_as_odf'            => 'Last ned som ODF',
	'coll-noscript_text'              => '<h1>JavaScript er påkrevd!</h1>
<strong>Nettleseren din støtter ikke JavaScript, eller JavaScript har blitt slått av. Denne siden vil ikke fungere riktig med mindre JavaScript er slått på.</strong>',
	'coll-intro_text'                 => 'Du kan samle sider, generere og laste ned en PDF-fil fra sidesamlinger og lagre sidesamlinger for senere bruk eller for deling.',
	'coll-helppage'                   => 'Help:Samlinger',
	'coll-too_big_cat'                => 'Kategorien inneholder mer enn %PARAM% sider; kun de %PARAM% første sidene kan legges til i samlingen din.
Vil du legge dem til?',
	'coll-my_collection'              => 'Min samling',
	'coll-download_title'             => 'Last ned samling som PDF',
	'coll-download_text'              => 'Klikk på knappen for å laste ned en automatisk generert PDF-fil av sidesamlingen din.',
	'coll-download_pdf'               => 'Last ned PDF',
	'coll-remove'                     => 'Fjern',
	'coll-move_to_top'                => 'Flytt til toppen',
	'coll-move_up'                    => 'Flytt opp',
	'coll-move_down'                  => 'Flytt ned',
	'coll-move_to_bottom'             => 'Flytt til bunnen',
	'coll-title'                      => 'Tittel:',
	'coll-subtitle'                   => 'Undertittel:',
	'coll-contents'                   => 'Innhold',
	'coll-create_chapter'             => 'Opprett nytt kapittel',
	'coll-sort_alphabetically'        => 'Sorter sider alfabetisk',
	'coll-clear_collection'           => 'Tøm samling',
	'coll-clear_confirm'              => 'Vil du virkelig tømme samlingen?',
	'coll-rename'                     => 'Gi nytt navn',
	'coll-new_chapter'                => 'Skriv inn navn for det nye kapittelet',
	'coll-rename_chapter'             => 'Skriv inn kapittelets nye navn',
	'coll-no_such_category'           => 'Ingen kategori ved dette navnet',
	'coll-notitle_title'              => 'Fant ikke ut av sidens tittel.',
	'coll-post_failed_title'          => 'POST-forespørsel mislyktes',
	'coll-post_failed_msg'            => 'POST-forespørselen til $1 mislyktes ($2).',
	'coll-pdfserver_failed_title'     => 'Feil med PDF-tjeneren',
	'coll-pdfserver_failed_msg'       => 'En feil oppsto med PDF-tjeneren: $1',
	'coll-enter_title'                => 'Skriv inn samlingens navn:',
	'coll-error_reponse'              => 'Feilrespons fra tjeneren',
	'coll-empty_collection'           => 'Tom samling',
	'coll-revision'                   => 'Revisjon: %PARAM%',
	'coll-save_collection_title'      => 'Lagre samling',
	'coll-save_collection_text'       => 'Velg en samlingstype og skriv inn en sidetittel for å lagre denne samlingen for senere bruk.',
	'coll-login_to_save'              => 'Om du vil lagre samlingene for senere bruk, [[Special:Userlogin|logg inn eller opprett en konto]].',
	'coll-personal_collection_label'  => 'Personlig samling:',
	'coll-community_collection_label' => 'Fellesskapssamling:',
	'coll-save_collection'            => 'Lagre samling',
	'coll-overwrite_title'            => 'Siden finnes. Erstatte den?',
	'coll-overwrite_text'             => 'En side ved navn [[:$1]] finnes fra før. Vil du erstatte den med samlingen din?',
	'coll-yes'                        => 'Ja',
	'coll-no'                         => 'Nei',
	'coll-load_overwrite_text'        => 'Du har allerede noen sider i samlingen din. Vil du erstatte den eksisterende samlingen, legge til det nye innholdet eller avbryte?',
	'coll-overwrite'                  => 'Erstatte',
	'coll-append'                     => 'Legge til',
	'coll-cancel'                     => 'Avbryt',
	'coll-limit_exceeded_title'       => 'Samling for stor',
	'coll-limit_exceeded_text'        => 'Sidesamlingen din er for stor. Ingen flere sider kan legges til.',
	'coll-rendering_title'            => 'Oppretter',
	'coll-rendering_text'             => "'''Vent mens dokumentet opprettes.'''

Framskritt: '''$1&nbsp;%'''.

Denne siden skal oppfriskes automatisk med noen sekunders mellomrom.
Om den ikke gjør det, trykk på oppdateringsknappen i nettleseren din.",
	'coll-rendering_finished_title'   => 'Opprettet',
	'coll-rendering_finished_text'    => "'''Dokumentfilen har blitt opprettet.'''
[$1 Klikk her] for å laste den ned.

Misfornøyd med resultatet?
Se [[{{MediaWiki:Coll-helppage}}|hjelpesiden for samlinger]] for måter å forbedre den på.",
	'coll-notfound_title'             => 'Samling ikke funnet',
	'coll-notfound_text'              => 'Kunne ikke finne samlingsside.',
	'coll-return_to_collection'       => 'Tilbake til <a href="$1">$2</a>',
	'coll-book_title'                 => 'Bestilling av trykt bok',
	'coll-book_text'                  => 'Du kan bestille en trykt bok med artikkelsamlingen din ved å besøke en av følgende trykkerpartnere:',
	'coll-order_from_pp'              => 'Bestill bok fra $1',
	'coll-about_pp'                   => 'Om $1',
	'coll-invalid_podpartner_title'   => 'Ugyldig POD-partner',
	'coll-invalid_podpartner_msg'     => 'Den oppgitte POD-partneren er ugyldig.
Kontakt din MediaWiki-administrator.',
	'coll-license'                    => 'Lisens',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Siebrand
 */
$messages['oc'] = array(
	'coll-desc'                       => "[[Special:Collection|Compilar de paginas]], generar de pdf's",
	'coll-collections'                => 'Compilacions',
	'coll-portlet_title'              => 'Ma compilacion',
	'coll-add_page'                   => 'Apondre una pagina',
	'coll-remove_page'                => 'Levar una pagina',
	'coll-add_category'               => 'Apondre una categoria',
	'coll-load_collection'            => 'Cargar una compilacion',
	'coll-show_collection'            => 'Afichar la compilacion',
	'coll-help_collections'           => 'Ajuda sus las compilacions',
	'coll-empty'                      => 'void',
	'coll-page'                       => 'pagina',
	'coll-pages'                      => 'paginas',
	'coll-download_as_pdf'            => 'Telecargar en PDF',
	'coll-download_as_odf'            => 'Telecargar en ODF',
	'coll-noscript_text'              => "<h1>Javascript es necessari !</h1>
<strong>Vòstre navigador supòrta pas Javascript o se l'a desactivat.
Aquesta pagina s'aficharà pas corrèctament tant que javascript serà pas activat.</strong>",
	'coll-intro_text'                 => "Podètz collectar de paginas, generar e telecargar de fichièrs PDF dempuèi las colleccions de paginas o dels salvaments de las dichas colleccions per un usatge ulterior o per las partejar.

Vejatz [[{{MediaWiki:Coll-helppage}}|las paginas d'ajudas en matièra de colleccions]] per mai d'entresenhas.",
	'coll-helppage'                   => 'Help:Collections',
	'coll-too_big_cat'                => 'La categoria conten mai de %PARAM% paginas, sonque las %PARAM% primièras paginas seràn apondudas a vòstra colleccion.',
	'coll-my_collection'              => 'Ma compilacion',
	'coll-download_title'             => 'Telecargar la compilacion en PDF',
	'coll-download_text'              => 'Per telecargar un PDF generat automaticament a partir de vòstra compilacion, picatz sul boton.',
	'coll-download_pdf'               => 'Telecargar lo PDF',
	'coll-remove'                     => 'Levar',
	'coll-move_to_top'                => 'Desplaçar tot en naut',
	'coll-move_up'                    => 'Pujar',
	'coll-move_down'                  => 'Davalar',
	'coll-move_to_bottom'             => 'Desplaçar tot en bas',
	'coll-title'                      => 'Títol :',
	'coll-subtitle'                   => 'Sostítol :',
	'coll-contents'                   => 'Contengut',
	'coll-create_chapter'             => 'Crear un capitol novèl',
	'coll-sort_alphabetically'        => 'Triar las paginas per òrdre alfabetic',
	'coll-clear_collection'           => 'Voidar la compilacion',
	'coll-clear_confirm'              => 'Volètz vertadièrament voidar vòstra compilacion ?',
	'coll-rename'                     => 'Tornar nomenar',
	'coll-new_chapter'                => 'Entrar lo títol del capitol novèl',
	'coll-rename_chapter'             => 'Entrar lo títol novèl pel capitol',
	'coll-no_such_category'           => 'Pas de tala categoria',
	'coll-notitle_title'              => 'Lo títol de la pagina pòt pas èsser determinat.',
	'coll-post_failed_title'          => 'Fracàs de la requèsta POST',
	'coll-post_failed_msg'            => 'La requèsta POST vèrs $1 a pas capitat ($2).',
	'coll-pdfserver_failed_title'     => 'Error del servidor PDF',
	'coll-pdfserver_failed_msg'       => 'Una error es subrevenguda sul servidor PDF : $1',
	'coll-enter_title'                => 'Picar un títol per la compilacion :',
	'coll-error_reponse'              => 'Lo servidor a rencontrat una error',
	'coll-empty_collection'           => 'Compilacion voida',
	'coll-revision'                   => 'Version : %PARAM%',
	'coll-save_collection_title'      => 'Salvar la compilacion',
	'coll-save_collection_text'       => 'Per salvar la compilacion, causissètz un tipe de compilacion e picatz un títol de pagina :',
	'coll-login_to_save'              => 'Se volètz salvar vòstra compilacion, [[Special:Userlogin|vos cal vos connectar o vos crear un compte]].',
	'coll-personal_collection_label'  => 'Compilacion personala :',
	'coll-community_collection_label' => 'Compilacion collectiva :',
	'coll-save_collection'            => 'Salvar la compilacion',
	'coll-overwrite_title'            => "La pagina existís. L'espotir ?",
	'coll-overwrite_text'             => 'Una pagina amb lo títol [[:$1]] existís ja.
La volètz remplaçar per vòstra compilacion ?',
	'coll-yes'                        => 'Òc',
	'coll-no'                         => 'Non',
	'coll-load_overwrite_text'        => 'Ja avètz de paginas dins vòstra compilacion.
Volètz espotir vòstra compilacion actuala, i apondre lo contengut o alara anullar ?',
	'coll-overwrite'                  => 'Espotir',
	'coll-append'                     => 'Apondre',
	'coll-cancel'                     => 'Anullar',
	'coll-limit_exceeded_title'       => 'Compilacion tròp granda',
	'coll-limit_exceeded_text'        => 'Vòstra compilacion es tròp granda.
Cap de pagina pòt pas èsser ajustada.',
	'coll-rendering_title'            => 'Rendut',
	'coll-rendering_text'             => "'''Pacientatz pendent que lo document es en cors de creacion.'''

Progression : '''$1 %'''.

Aquesta pagina se deuriá actualizar regularament.
S'èra pas lo cas, clicatz sul boton d’actualizacion de vòstre navigador.",
	'coll-rendering_finished_title'   => 'Rendut acabat',
	'coll-rendering_finished_text'    => "'''Lo fichièr document es estat creat.'''
[$1 Clicatz aicí] per lo telecargar sus vòstre ordenador.

Pas satisfach(a) de la sortida ?
Vejatz [[{{MediaWiki:Coll-helppage}}|la pagina d’ajuda que concernís las colleccions]] per las possibilitats de melhorament.",
	'coll-notfound_title'             => 'Compilacion pas trobada',
	'coll-notfound_text'              => 'Pòt pas trobar la compilacion.',
	'coll-return_to_collection'       => 'Tornar a <a href="$1">$2</a>',
	'coll-book_title'                 => 'Comandar un libre imprimit',
	'coll-book_text'                  => "Podètz comandar un libre imprimit contenent vòstra colleccion d'articles en visitant una demanda d'impression de la part de partenaris :",
	'coll-order_from_pp'              => 'Comandar lo libre dempuèi $1',
	'coll-about_pp'                   => 'A prepaus de $1',
	'coll-invalid_podpartner_title'   => 'Partenari POD incorrècte.',
	'coll-invalid_podpartner_msg'     => 'Lo partenari POD indicat es incorrècte.
Contactatz vòstre administrator Mediawiki.',
	'coll-license'                    => 'Licéncia',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'coll-page'  => 'фарс',
	'coll-title' => 'Сæргонд:',
	'coll-yes'   => 'О',
	'coll-no'    => 'Нæ',
);

/** Polish (Polski)
 * @author Masti
 * @author McMonster
 * @author Sp5uhe
 * @author Derbeth
 * @author Siebrand
 * @author Wpedzich
 */
$messages['pl'] = array(
	'coll-desc'                       => 'Umożliwia [[Special:Collection|tworzenie kolekcji]] stron i zapisanie ich do pliku w formacie PDF',
	'coll-collections'                => 'Kolekcje',
	'coll-portlet_title'              => 'Moja kolekcja',
	'coll-add_page'                   => 'Dodaj stronę',
	'coll-remove_page'                => 'Usuń stronę',
	'coll-add_category'               => 'Dodaj kategorię',
	'coll-load_collection'            => 'Załaduj kolekcję',
	'coll-show_collection'            => 'Pokaż kolekcję',
	'coll-help_collections'           => 'Pomoc kolekcji',
	'coll-empty'                      => 'pusty',
	'coll-page'                       => 'strona',
	'coll-pages'                      => 'strony',
	'coll-download_as_pdf'            => 'Pobierz jako PDF',
	'coll-noscript_text'              => '<h1>Potrzebny JavaScript!</h1>
<strong>Twoja przeglądarka nie obsługuje JavaScript lub został on wyłączony.
Strona nie będzie działać poprawnie, dopóki JavaScript nie zostanie włączony.</strong>',
	'coll-intro_text'                 => 'Narzędzie umożliwia tworzenie kolekcji stron, z których można wygenerować plik PDF, jak też zapisać je w celu późniejszego wykorzystania lub udostępnienia.

Więcej informacji na [[{{MediaWiki:Coll-helppage}}|stronie pomocy dotyczącej kolekcji]].',
	'coll-helppage'                   => 'Help:Kolekcje',
	'coll-my_collection'              => 'Moja kolekcja',
	'coll-download_title'             => 'Pobierz kolekcję jako PDF',
	'coll-download_text'              => 'Naciśnij przycisk, by pobrać automatycznie wygenerowaną wersję PDF Twojej kolekcji stron',
	'coll-download_pdf'               => 'Pobierz PDF',
	'coll-remove'                     => 'Usuń',
	'coll-move_to_top'                => 'Przenieś na górę',
	'coll-move_up'                    => 'Przenieś w górę',
	'coll-move_down'                  => 'Przenieś w dół',
	'coll-move_to_bottom'             => 'Przenieś na dół',
	'coll-title'                      => 'Tytuł:',
	'coll-subtitle'                   => 'Podtytuł:',
	'coll-contents'                   => 'Spis treści',
	'coll-create_chapter'             => 'Utwórz nowy rozdział',
	'coll-sort_alphabetically'        => 'Sortuj strony alfabetycznie',
	'coll-clear_collection'           => 'Wyczyść kolekcję',
	'coll-clear_confirm'              => 'Na pewno chcesz wyczyścić kolekcję?',
	'coll-rename'                     => 'Zmień nazwę',
	'coll-new_chapter'                => 'Wprowadź nazwę dla nowego rozdziału',
	'coll-rename_chapter'             => 'Wprowadź nową nazwę dla rozdziału',
	'coll-no_such_category'           => 'Brak takiej kategorii',
	'coll-notitle_title'              => 'Tytuł strony nie może być określony.',
	'coll-post_failed_title'          => 'Żądanie POST nieudane',
	'coll-post_failed_msg'            => 'Żądanie POST do $1 nie powiodło się ($2).',
	'coll-pdfserver_failed_title'     => 'Błąd serwera plików PDF',
	'coll-pdfserver_failed_msg'       => 'Wystąpił błąd serwera plików PDF: $1',
	'coll-enter_title'                => 'Podaj tytuł kolekcji:',
	'coll-error_reponse'              => 'Błąd odpowiedzi serwera',
	'coll-empty_collection'           => 'Pusta kolekcja',
	'coll-revision'                   => 'Wersja: %PARAM%',
	'coll-save_collection_title'      => 'Zapisz kolekcję',
	'coll-save_collection_text'       => 'Aby zapisać kolekcję, wybierz jej rodzaj i tytuł:',
	'coll-login_to_save'              => 'Jeśli chcesz zapisać kolekcję, [[Special:Userlogin|zaloguj się lub utwórz konto]].',
	'coll-personal_collection_label'  => 'Kolekcja osobista:',
	'coll-community_collection_label' => 'Kolekcja społeczności:',
	'coll-save_collection'            => 'Zapisz kolekcję',
	'coll-overwrite_title'            => 'Strona już istnieje. Nadpisać?',
	'coll-overwrite_text'             => 'Strona pod tytułem [[:$1]] już istnieje.
Chcesz ją zastąpić swoją kolekcją?',
	'coll-yes'                        => 'Tak',
	'coll-no'                         => 'Nie',
	'coll-load_overwrite_text'        => 'Masz już strony w swojej kolekcji.
Czy chcesz nadpisać Twoją obecną kolekcję, dodać do niej strony czy anulować?',
	'coll-overwrite'                  => 'Nadpisz',
	'coll-append'                     => 'Dopisz',
	'coll-cancel'                     => 'Anuluj',
	'coll-limit_exceeded_title'       => 'Zbyt duża kolekcja',
	'coll-limit_exceeded_text'        => 'Twoja kolekcja stron jest zbyt duża.
Nie można dodać więcej stron.',
	'coll-notfound_title'             => 'Nie znaleziono kolekcji',
	'coll-notfound_text'              => 'Nie udało się znaleźć strony kolekcji.',
	'coll-return_to_collection'       => 'Powróć do <a href="$1">$2</a>',
	'coll-book_title'                 => 'Zamów wydrukowaną książkę',
	'coll-book_text'                  => 'Możesz zamówić drukowaną książkę zawierającą kolekcję wybranych przez Ciebie stron. Odwiedź jednego z partnerów realizujących usługę wydruku na żądanie:',
	'coll-order_from_pp'              => 'Zamów książkę z $1',
	'coll-about_pp'                   => 'O $1',
	'coll-invalid_podpartner_title'   => 'Niesprawny usługodawca wydruku na żądanie',
	'coll-invalid_podpartner_msg'     => 'Wybrany partner wydruku na żądanie nie funkcjonuje.
Skontaktuj się z administratorem tego serwisu MediaWiki.',
	'coll-license'                    => 'Licencja',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'coll-collections'           => 'غونډونه',
	'coll-portlet_title'         => 'زما غونډ',
	'coll-add_page'              => 'مخ ورګډول',
	'coll-add_category'          => 'وېشنيزه ورګډول',
	'coll-help_collections'      => 'د غونډونو لارښود',
	'coll-empty'                 => 'تش',
	'coll-page'                  => 'مخ',
	'coll-pages'                 => 'مخونه',
	'coll-download_as_pdf'       => 'د PDF په توګه راښکته کول',
	'coll-my_collection'         => 'زما غونډ',
	'coll-remove'                => 'غورځول',
	'coll-title'                 => 'سرليک:',
	'coll-subtitle'              => 'لمنليک:',
	'coll-contents'              => 'مينځپانګه',
	'coll-create_chapter'        => 'يو نوی څپرکی جوړول',
	'coll-rename'                => 'نوم بدلول',
	'coll-no_such_category'      => 'داسې هېڅ کومه وېشنيزه نشته',
	'coll-save_collection_title' => 'غونډ خوندي کول',
	'coll-yes'                   => 'هو',
	'coll-no'                    => 'نه',
	'coll-notfound_title'        => 'غونډ و نه موندلای شو',
	'coll-about_pp'              => 'د $1 په اړه',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Lijealso
 * @author Siebrand
 * @author 555
 * @author MF-Warburg
 */
$messages['pt'] = array(
	'coll-desc'                       => '[[Special:Collection|Colecciona páginas]], gera PDFs',
	'coll-collections'                => 'Colecções',
	'coll-portlet_title'              => 'Minha Colecção',
	'coll-add_page'                   => 'Adicionar página',
	'coll-remove_page'                => 'Remover página',
	'coll-add_category'               => 'Adicionar categoria',
	'coll-load_collection'            => 'Carregar colecção',
	'coll-show_collection'            => 'Mostrar colecção',
	'coll-help_collections'           => 'Ajuda de colecções',
	'coll-empty'                      => 'vazia',
	'coll-page'                       => 'página',
	'coll-pages'                      => 'páginas',
	'coll-download_as_pdf'            => 'Descarregar como PDF',
	'coll-noscript_text'              => '<h1>JavaScript é Requerido!</h1>
<strong>O seu "browser" não suporta JavaScript, ou o JavaScript foi desactivado.
Esta página não funcionará correctamente, excepto se o JavaScript for activado.</strong>',
	'coll-intro_text'                 => 'Você pode coleccionar páginas, gerar e descarregar um ficheiro PDF de colecções de páginas e gravar colecções de páginas para usar mais tarde ou partilhá-las.

Veja a [[{{MediaWiki:Coll-helppage}}|página de ajuda sobre colecções]] para mais informação.',
	'coll-helppage'                   => 'Help:Colecções',
	'coll-my_collection'              => 'Minha Colecção',
	'coll-download_title'             => 'Descarregar Colecção como PDF',
	'coll-download_text'              => 'Para descarregar um ficheiro PDF da sua colecção de páginas gerado automaticamente, carregue no botão.',
	'coll-download_pdf'               => 'Descarregar PDF',
	'coll-remove'                     => 'Remover',
	'coll-move_to_top'                => 'Mover para o topo',
	'coll-move_up'                    => 'Mover acima',
	'coll-move_down'                  => 'Mover abaixo',
	'coll-move_to_bottom'             => 'Mover para o fundo',
	'coll-title'                      => 'Título:',
	'coll-subtitle'                   => 'Subtítulo:',
	'coll-contents'                   => 'Conteúdo',
	'coll-create_chapter'             => 'Criar novo capítulo',
	'coll-sort_alphabetically'        => 'Ordenar páginas alfabeticamente',
	'coll-clear_collection'           => 'Limpar colecção',
	'coll-clear_confirm'              => 'De certeza que quer limpar a sua colecção?',
	'coll-rename'                     => 'Renomear',
	'coll-new_chapter'                => 'Introduza o nome do novo capítulo',
	'coll-rename_chapter'             => 'Introduza o nome do capítulo',
	'coll-no_such_category'           => 'Não existe essa categoria',
	'coll-notitle_title'              => 'Não foi possível determinar o título da página.',
	'coll-post_failed_title'          => 'Pedido POST falhou',
	'coll-post_failed_msg'            => 'O pedido POST feito à $1 falhou ($2).',
	'coll-enter_title'                => 'Introduza título para a colecção:',
	'coll-error_reponse'              => 'Resposta de erro do servidor',
	'coll-empty_collection'           => 'Colecção vazia',
	'coll-revision'                   => 'Revisão: %PARAM%',
	'coll-save_collection_title'      => 'Gravar Colecção',
	'coll-save_collection_text'       => 'Para guardar uma colecção para uso futuro, escolha um tipo de colecção e introduza o título da página:',
	'coll-login_to_save'              => 'Se pretende gravar colecções para mais tarde, por favor, [[Special:Userlogin|autentique-se ou crie uma conta]].',
	'coll-personal_collection_label'  => 'Colecção pessoal:',
	'coll-community_collection_label' => 'Colecção comunitária:',
	'coll-save_collection'            => 'Gravar Colecção',
	'coll-overwrite_title'            => 'A página existe. Escrever por cima?',
	'coll-overwrite_text'             => 'Um página com o nome [[:$1]] já existe.
Deseja substituí-la pela sua colecção?',
	'coll-yes'                        => 'Sim',
	'coll-no'                         => 'Não',
	'coll-load_overwrite_text'        => 'Já tem algumas páginas na sua colecção.
Pretende reescrever a sua colecção, adicionar o novo conteúdo or cancelar?',
	'coll-overwrite'                  => 'Reescrever',
	'coll-append'                     => 'Adicionar',
	'coll-cancel'                     => 'Cancelar',
	'coll-limit_exceeded_title'       => 'Colecção Demasiado Grande',
	'coll-limit_exceeded_text'        => 'A usa coleccção de página é demasiado grande.
Não poderão ser adicionadas mais páginas.',
	'coll-notfound_title'             => 'Colecção Não Encontrada',
	'coll-notfound_text'              => 'Não foi possível encontrar a página da colecção.',
	'coll-return_to_collection'       => 'Regressar a <a href="$1">$2</a>',
	'coll-book_title'                 => 'Encomendar Livro Impresso',
	'coll-book_text'                  => 'Você pode encomendar um livro impresso contendo a sua colecção de páginas visitando um dos seguintes parceiros de impressão a pedido:',
	'coll-order_from_pp'              => 'Encomendar o livro de $1',
	'coll-about_pp'                   => 'Sobre $1',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'coll-desc'                      => '[[Special:Collection|Colecţionează pagini]], generează fişiere PDF',
	'coll-collections'               => 'Colecţii',
	'coll-portlet_title'             => 'Colecţia mea',
	'coll-add_page'                  => 'Adaugă pagină',
	'coll-remove_page'               => 'Elimină pagină',
	'coll-add_category'              => 'Adaugă categorie',
	'coll-load_collection'           => 'Încarcă colecţie',
	'coll-show_collection'           => 'Arată colecţie',
	'coll-page'                      => 'pagină',
	'coll-pages'                     => 'pagini',
	'coll-download_as_pdf'           => 'Descarcă ca PDF',
	'coll-download_as_odf'           => 'Descarcă ca ODF',
	'coll-my_collection'             => 'Colecţia mea',
	'coll-download_pdf'              => 'Descarcă PDF',
	'coll-remove'                    => 'Elimină',
	'coll-title'                     => 'Titlu:',
	'coll-subtitle'                  => 'Subtitlu:',
	'coll-contents'                  => 'Cuprins',
	'coll-create_chapter'            => 'Creează capitol nou',
	'coll-sort_alphabetically'       => 'Ordonează paginile alfabetic',
	'coll-rename'                    => 'Redenumeşte',
	'coll-post_failed_title'         => 'Cerere POST eşuată',
	'coll-post_failed_msg'           => 'Cererea POST către $1 a eşuat ($2).',
	'coll-error_reponse'             => 'Răspuns de eroare de la server',
	'coll-empty_collection'          => 'Colecţie goală',
	'coll-revision'                  => 'Versiune: %PARAM%',
	'coll-save_collection_title'     => 'Salvează colecţia',
	'coll-personal_collection_label' => 'Colecţie personală:',
	'coll-save_collection'           => 'Salvează colecţia',
	'coll-overwrite_title'           => 'Pagina există.
Suprascrie?',
	'coll-yes'                       => 'Da',
	'coll-no'                        => 'Nu',
	'coll-overwrite'                 => 'Suprascrie',
	'coll-cancel'                    => 'Anulează',
	'coll-notfound_title'            => 'Colecţie negăsită',
	'coll-return_to_collection'      => 'Întoarcere la <a href="$1">$2</a>',
	'coll-order_from_pp'             => 'Comandă carte de la $1',
	'coll-about_pp'                  => 'Despre $1',
	'coll-license'                   => 'Licenţă',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Siebrand
 * @author Ahonc
 * @author MaxSem
 * @author Innv
 */
$messages['ru'] = array(
	'coll-desc'                       => '[[Special:Collection|Собирает коллекции страниц]], создаёт PDF',
	'coll-collections'                => 'Коллекции',
	'coll-portlet_title'              => 'Моя коллекция',
	'coll-add_page'                   => 'Добавить страницу',
	'coll-remove_page'                => 'Удалить страницу',
	'coll-add_category'               => 'Добавить категорию',
	'coll-load_collection'            => 'Загрузить коллекцию',
	'coll-show_collection'            => 'Показать коллекцию',
	'coll-help_collections'           => 'Справка по коллекциям',
	'coll-empty'                      => 'пустая',
	'coll-page'                       => 'страница',
	'coll-pages'                      => 'страницы',
	'coll-download_as_pdf'            => 'Скачать как PDF',
	'coll-download_as_odf'            => 'Загрузить как ODF',
	'coll-noscript_text'              => '<h1>Требуется JavaScript!</h1>
<strong>Ваш браузер не поддерживает JavaScript или данная поддержка была отключена.
Эта страница не будет работать правильно, если JavaScript не включен.</strong>',
	'coll-intro_text'                 => 'Вы можете объединить страницы в коллекцию, создать и скачать PDF-файл с набором страниц, или сохранить коллекцию страниц для последующей работы или обмена.

Подробности можно найти на [[{{MediaWiki:Coll-helppage}}|справочной странице о коллекциях]].',
	'coll-helppage'                   => 'Help:Коллекции',
	'coll-too_big_cat'                => 'Категория содержит более %PARAM% страниц, в коллекцию могут быть добавлены только первые %PARAM% страниц.
Желаете ли вы их добавить?',
	'coll-my_collection'              => 'Моя коллекция',
	'coll-download_title'             => 'Скачать коллекцию как PDF',
	'coll-download_text'              => 'Нажмите кнопку, чтобы скачать автоматически созданный PDF-файл с вашей коллекций страниц.',
	'coll-download_pdf'               => 'Скачать PDF',
	'coll-remove'                     => 'Удалить',
	'coll-move_to_top'                => 'Передвинуть наверх',
	'coll-move_up'                    => 'Передвинуть выше',
	'coll-move_down'                  => 'Передвинуть ниже',
	'coll-move_to_bottom'             => 'Передвинуть вниз',
	'coll-title'                      => 'Название:',
	'coll-subtitle'                   => 'Подзаголовок:',
	'coll-contents'                   => 'Содержание',
	'coll-create_chapter'             => 'Создать новую главу',
	'coll-sort_alphabetically'        => 'Упорядочивать страницы по алфавиту',
	'coll-clear_collection'           => 'Очистить коллекцию',
	'coll-clear_confirm'              => 'Вы действительно хотите очистить свою коллекцию?',
	'coll-rename'                     => 'Переименовать',
	'coll-new_chapter'                => 'Введите имя для новой главы',
	'coll-rename_chapter'             => 'Введите новое имя главы',
	'coll-no_such_category'           => 'Нет такой категории',
	'coll-notitle_title'              => 'Заголовок страницы не может быть определён.',
	'coll-post_failed_title'          => 'POST-запрос не выполнен',
	'coll-post_failed_msg'            => 'POST-запрос к $1 не выполнен ($2).',
	'coll-pdfserver_failed_title'     => 'ошибка PDF на сервере',
	'coll-pdfserver_failed_msg'       => 'На PDF-сервере произошла ошибка: $1',
	'coll-enter_title'                => 'Введите название коллекции:',
	'coll-error_reponse'              => 'Ошибка ответа сервера',
	'coll-empty_collection'           => 'Пустая коллекция',
	'coll-revision'                   => 'Версия: %PARAM%',
	'coll-save_collection_title'      => 'Сохранить коллекцию',
	'coll-save_collection_text'       => 'Чтобы сохранить коллекцию для дальнейшего использования, выберите тип коллекции и введите имя страницы:',
	'coll-login_to_save'              => 'Чтобы сохранить коллекцию для дальнейшего использования, пожалуйста, [[Special:Userlogin|представьтесь системе или создайте учётную запись]].',
	'coll-personal_collection_label'  => 'Личная коллекция:',
	'coll-community_collection_label' => 'Коллекция сообщества:',
	'coll-save_collection'            => 'Сохранить коллекцию',
	'coll-overwrite_title'            => 'Страница существует. Перезаписать?',
	'coll-overwrite_text'             => 'Страница с именем [[:$1]] уже существует.
Вы хотите чтобы она была заменена вашей коллекцией?',
	'coll-yes'                        => 'Да',
	'coll-no'                         => 'Нет',
	'coll-load_overwrite_text'        => 'У вас уже есть несколько страниц в коллекции.
Вы хотите перезаписать вашу текущею коллекцию, добавить новый материал или отменить действие?',
	'coll-overwrite'                  => 'Перезаписать',
	'coll-append'                     => 'Добавить',
	'coll-cancel'                     => 'Отменить',
	'coll-limit_exceeded_title'       => 'Коллекция слишком большая',
	'coll-limit_exceeded_text'        => 'Ваша коллекция слишком большая.
В неё нельзя больше добавлять страницы.',
	'coll-rendering_title'            => 'Создание',
	'coll-rendering_text'             => "'''Пожалуйста, подождите, идёт создание документа.'''

Ход работы: '''$1 %'''.

Эта страница должна обновляться раз в несколько секунд.
Если этого не происходит, пожалуйста, нажмите кнопку «обновить» браузера.",
	'coll-rendering_finished_title'   => 'Создание завершено',
	'coll-rendering_finished_text'    => "'''Файл документа создан.'''
[$1 Нажмите здесь], чтобы загрузить его на ваш компьютер.

Не удовлетворены результатом?
Возможности его улучшения описаны на [[{{MediaWiki:Coll-helppage}}|справочной странице о коллекциях]].",
	'coll-notfound_title'             => 'Коллекция не найдена',
	'coll-notfound_text'              => 'Невозможно найти страницу коллекции.',
	'coll-return_to_collection'       => 'Назад к <a href="$1">$2</a>',
	'coll-book_title'                 => 'Заказать печатную книгу',
	'coll-book_text'                  => 'Вы можете заказать печатную книгу, содержащую вашу коллекцию страниц, воспользовавшись одним из следующих предложений печати по запросу:',
	'coll-order_from_pp'              => 'Заказ книги в $1',
	'coll-about_pp'                   => 'О $1',
	'coll-invalid_podpartner_title'   => 'Недействительный POD-партнёр',
	'coll-invalid_podpartner_msg'     => 'Предоставляемый POD-партнёр недействителен.
Пожалуйста, свяжитесь с вашим администратором MediaWiki.',
	'coll-license'                    => 'Лицензия',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Siebrand
 */
$messages['sk'] = array(
	'coll-desc'                       => 'Vytváranie [[Special:Collection|kolekcie stránok]], tvorba PDF',
	'coll-collections'                => 'Kolekcie',
	'coll-portlet_title'              => 'Moja kolekcia',
	'coll-add_page'                   => 'Pridať stránku',
	'coll-remove_page'                => 'Odstrániť stránku',
	'coll-add_category'               => 'Pridať kategóriu',
	'coll-load_collection'            => 'Načítať kolekciu',
	'coll-show_collection'            => 'Zobraziť kolekciu',
	'coll-help_collections'           => 'Pomocník ku kolekciám',
	'coll-empty'                      => 'prázdna',
	'coll-page'                       => 'stránka',
	'coll-pages'                      => 'stránky',
	'coll-download_as_pdf'            => 'Stiahnuť ako PDF',
	'coll-download_as_odf'            => 'Stiahnuť ako ODF',
	'coll-noscript_text'              => '<h1>Vyžaduje sa JavaScript!</h1>
<strong>Váš prehliadač nepodporuje JavaScript alebo máte JavaScript vypnutý.
Táto stránka nebude správne fungovať ak nezapnete JavaScript.</strong>',
	'coll-intro_text'                 => 'Môžete vytvárať kolekcie stránok, vytvárať a stiahnuť PDF súbor z kolekcie stránok a ukladať kolekcie stránok pre neskoršie využitie alebo ich zdieľať.

Pozri ďalšie informácie na [[{{MediaWiki:Coll-helppage}}|stránke pomocníka o kolekciách]].',
	'coll-helppage'                   => 'Help:Kolekcie',
	'coll-too_big_cat'                => 'Vaša kateǵoria obsahuje viac ako %PARAM% stránok. Do kolekcie je možné pridať iba prvých %PARAM% stránok.
Chcete ich pridať?',
	'coll-my_collection'              => 'Moja kolekcia',
	'coll-download_title'             => 'Stiahnuť kolekciu ako PDF',
	'coll-download_text'              => 'Stiahnuť automaticky vytvorený PDF súbor vašej kolekcie stránok. Kliknite na tlačidlo.',
	'coll-download_pdf'               => 'Stiahnuť PDF',
	'coll-remove'                     => 'Odstrániť',
	'coll-move_to_top'                => 'Presunúť na vrch',
	'coll-move_up'                    => 'Presunúť vyššie',
	'coll-move_down'                  => 'Presunúť nižšie',
	'coll-move_to_bottom'             => 'Presunúť na spodok',
	'coll-title'                      => 'Názov:',
	'coll-subtitle'                   => 'Podnázov:',
	'coll-contents'                   => 'Obsah',
	'coll-create_chapter'             => 'Vytvoriť novú kapitolu',
	'coll-sort_alphabetically'        => 'Zoradiť stránky abecedne',
	'coll-clear_collection'           => 'Vyčistiť kolekciu',
	'coll-clear_confirm'              => 'Naozaj chcete vyčistiť svoju kolekciu?',
	'coll-rename'                     => 'Premenovať',
	'coll-new_chapter'                => 'Zadajte názov novej kapitoly',
	'coll-rename_chapter'             => 'Zadajte nový názov kapitoly',
	'coll-no_such_category'           => 'Taká kategória neexistuje',
	'coll-notitle_title'              => 'Názov stránky nebolo možné určiť.',
	'coll-post_failed_title'          => 'Chyba požiadavky POST',
	'coll-post_failed_msg'            => 'Chyba požiadavky POST na $1 ($2).',
	'coll-pdfserver_failed_title'     => 'Chyba PDF servera',
	'coll-pdfserver_failed_msg'       => 'Vyskytla sa chyba PDF servera: $1',
	'coll-enter_title'                => 'Zadajte názov kolekcie:',
	'coll-error_reponse'              => 'Chybná odpoveď servera',
	'coll-empty_collection'           => 'Prázdna kolekcia',
	'coll-revision'                   => 'Revízia: %PARAM%',
	'coll-save_collection_title'      => 'Uložiť kolekciu',
	'coll-save_collection_text'       => 'Túto kolekciu môžete uložiť pre neskoršie použitie po zadaní typu kolekcie a názvu stránky:',
	'coll-login_to_save'              => 'Ak chcete ukladať kolekcie pre neskoršie použitie, prosím, [[Special:Userlogin|prihláste sa alebo si vytvorte účet]].',
	'coll-personal_collection_label'  => 'Osobné kolekcie:',
	'coll-community_collection_label' => 'Komunitné kolekcie:',
	'coll-save_collection'            => 'Uložiť kolekciu',
	'coll-overwrite_title'            => 'Stránka existuje. Prepísať?',
	'coll-overwrite_text'             => 'Stránka s názvom [[:$1]] už existuje.
Chcete ju nahradiť svojou kolekciou?',
	'coll-yes'                        => 'Áno',
	'coll-no'                         => 'Nie',
	'coll-load_overwrite_text'        => 'Vo vašej kolekcii sa už nachádzajú stránky.
Chcete prepísať svoju existujúcu kolekciu, pridať do nej obsah alebo zrušiť túto operáciu?',
	'coll-overwrite'                  => 'Prepísať',
	'coll-append'                     => 'Pridať',
	'coll-cancel'                     => 'Zrušiť',
	'coll-limit_exceeded_title'       => 'Kolekcia je príliš veľká',
	'coll-limit_exceeded_text'        => 'Vaša kolekcia stránok je príliš veľká.
Nie je možné pridať ďalšie stránky.',
	'coll-rendering_title'            => 'Vykresľovanie',
	'coll-rendering_text'             => "'''Prosím, čakajte, kým sa vytvorí dokument.'''

Priebeh: '''$1 %'''.

Táto stránka by sa mala vždy po niekoľkých sekundách obnoviť.
Ak to nefunguje, stlačte prosím tlačidlo obnoviť vo vašom prehlidači.",
	'coll-rendering_finished_title'   => 'Vykresľovanie je dokončené',
	'coll-rendering_finished_text'    => "'''Súbor dokumentu bol vytvorený.'''
Môžete ho [$1 stiahnuť] na svoj počítač.

Nie ste spokojný s výstupom?
Spôsoby možnej nápravy nájdete na [[{{MediaWiki:Coll-helppage}}|stránke pomocníka o kolekciách]].",
	'coll-notfound_title'             => 'Kolekcia nenájdená',
	'coll-notfound_text'              => 'Nebolo možné nájsť stránku kolekcie',
	'coll-return_to_collection'       => 'Vrátiť sa na <a href="$1">$2</a>',
	'coll-book_title'                 => 'Objednať tlačenú knihu',
	'coll-book_text'                  => 'Môžete si objednať tlačenú knihu obsahujúcu vašu zbierku článkov. Navštívte jedného z nasledovných partnerov, ktorí tobia tlač na vyžiadanie:',
	'coll-order_from_pp'              => 'Objednať knihu od $1',
	'coll-about_pp'                   => 'O $1',
	'coll-invalid_podpartner_title'   => 'Neplatný POD partner',
	'coll-invalid_podpartner_msg'     => 'Zadaný POD partner je neplatný.
Prosím, kontaktujte svojho správcu MediaWiki.',
	'coll-license'                    => 'Licencia',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'coll-page'   => 'страна',
	'coll-remove' => 'Уклони',
	'coll-title'  => 'Наслов:',
	'coll-yes'    => 'Да',
	'coll-no'     => 'Не',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 * @author Siebrand
 */
$messages['stq'] = array(
	'coll-desc'                => '[[Special:Collection|Siedentouhoopestaalenge]], moak PDFs',
	'coll-collections'         => 'Touhoopestaalenge',
	'coll-portlet_title'       => 'Mien Touhoopestaalenge',
	'coll-add_page'            => 'Siede bietouföigje',
	'coll-remove_page'         => 'Siede wächhoalje',
	'coll-add_category'        => 'Kategorie bietouföigje',
	'coll-load_collection'     => 'Touhoopestaalenge leede',
	'coll-show_collection'     => 'Touhoopestaalenge wiese',
	'coll-help_collections'    => 'Hälpe tou Touhoopestaalengen',
	'coll-empty'               => 'loos',
	'coll-page'                => 'Siede',
	'coll-pages'               => 'Sieden',
	'coll-download_as_pdf'     => 'As PDF deelleede',
	'coll-noscript_text'       => '<h1>JavaScript is nöödich!</h1>
<strong>Dien Browser unnerstutset neen Javascript of Javascript wuude deaktivierd. Disse Siede däd nit gjucht funktionierje, soloange Javascript nit ferföigboar is.</strong>',
	'coll-intro_text'          => 'Du koast Sieden touhoopestaale, n PDF deerap moakje un deelleede as uk Touhoopestaalengen foar ne leetere Ferweendenge twiskespiekerje un mäd uur Benutsere deele.

Sjuch ju [[{{MediaWiki:Coll-helppage}}|Hälpe bie Touhoopestaalengen]] foar wiedere Informatione.',
	'coll-helppage'            => 'Help:Touhoopestaalengen',
	'coll-my_collection'       => 'Mien Touhoopestaalenge',
	'coll-download_title'      => 'Touhoopestaalenge as PDF deelleede',
	'coll-download_text'       => 'Uum ne automatisk moakede PDF-Doatäi fon dien Touhoopestaalenge deeltouleeden, klik ap ap ju Schaltfläche.',
	'coll-download_pdf'        => 'PDF deelleede',
	'coll-remove'              => 'Wächhoalje',
	'coll-move_to_top'         => 'ätter dän Ounfang',
	'coll-move_up'             => 'hooch',
	'coll-move_down'           => 'häärdeel',
	'coll-move_to_bottom'      => 'ätter dän Eend',
	'coll-title'               => 'Tittel:',
	'coll-subtitle'            => 'Unnertittel:',
	'coll-contents'            => 'Inhoold',
	'coll-create_chapter'      => 'Näi Kapittel moakje',
	'coll-sort_alphabetically' => 'Sieden alphabetisk sortierje',
	'coll-clear_collection'    => 'Touhoopestaalenge läskje',
	'coll-clear_confirm'       => 'Moatest du dien Touhoopestaalenge wuudelk läskje?',
	'coll-rename'              => 'Uumebenaame',
	'coll-new_chapter'         => 'Reek n Noome foar n näi Kapittel ien',
	'coll-rename_chapter'      => 'Reek n näien Noome foar dät Kapittel ien',
	'coll-no_such_category'    => 'Sun Kategorie rakt dät nit',
	'coll-notitle_title'       => 'Die Tittel fon ju Siede kuud nit bestimd wäide.',
	'coll-post_failed_title'   => 'POST-Anfroage failsloain',
	'coll-post_failed_msg'     => 'Ju POST-Anfroage is failsloain ($2).',
	'coll-enter_title'         => 'Tittel fon ju Touhoopestaalenge:',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Siebrand
 */
$messages['su'] = array(
	'coll-add_page'             => 'Nambah kaca',
	'coll-remove_page'          => 'Miceun kaca',
	'coll-add_category'         => 'Nambah kategori',
	'coll-empty'                => 'kosong',
	'coll-page'                 => 'kaca',
	'coll-pages'                => 'kaca',
	'coll-move_to_top'          => 'Mindahkeun ka luhur',
	'coll-move_up'              => 'Pindahkeun ka luhur',
	'coll-move_down'            => 'Mindahkeun ka handap',
	'coll-move_to_bottom'       => 'Mindahkeun ka handap',
	'coll-title'                => 'Judul:',
	'coll-contents'             => 'eusi',
	'coll-rename'               => 'Ganti ngaran',
	'coll-yes'                  => 'Enya',
	'coll-no'                   => 'Teu',
	'coll-append'               => 'Tambahkeun',
	'coll-cancel'               => 'Bolay',
	'coll-return_to_collection' => 'Balik deui ka <a href="$1">$2</a>',
	'coll-about_pp'             => 'Ngeunaan $1',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Siebrand
 * @author Sannab
 * @author H92
 * @author Boivie
 */
$messages['sv'] = array(
	'coll-desc'                       => '[[Special:Collection|Samla sidor]], generera PDF filer',
	'coll-collections'                => 'Samlingar',
	'coll-portlet_title'              => 'Min samling',
	'coll-add_page'                   => 'Lägg till sida',
	'coll-remove_page'                => 'Ta bort sida',
	'coll-add_category'               => 'Lägg till kategori',
	'coll-load_collection'            => 'Ladda samling',
	'coll-show_collection'            => 'Visa samling',
	'coll-help_collections'           => 'Hjälp för samlingar',
	'coll-empty'                      => 'tom',
	'coll-page'                       => 'sida',
	'coll-pages'                      => 'sidor',
	'coll-download_as_pdf'            => 'Ladda ner som PDF',
	'coll-download_as_odf'            => 'Ladda ner som ODF',
	'coll-noscript_text'              => '<h1>JavaScript är nödvändigt!</h1>
<strong>Din webbläsare stödjer inte JavaScript eller har JavaScript blivigt avslagen.
Denna sida kommer inte att fungera korrekt, tills JavaScript är tillgängligt.</strong>',
	'coll-intro_text'                 => 'Du kan samla sidor, generera och ladda ner en PDF fil från sid samlingar och spara sid samlingar för senare bruk eller för delning.

Se [[{{MediaWiki:Coll-helppage}}|hjälp sidan om samlingar]] för mer information.',
	'coll-helppage'                   => 'Help:Samlingar',
	'coll-too_big_cat'                => 'Kategorin innehåller mer än %PARAM% sidor, endast de %PARAM% första sidorna kan läggas till till din samling.
Vill du lägga till dem?',
	'coll-my_collection'              => 'Min samling',
	'coll-download_title'             => 'Ladda ner samling som PDF',
	'coll-download_text'              => 'För att ladda ner en automatisk genererad PDF-fil av din sidsamling, klicka på knappen.',
	'coll-download_pdf'               => 'Ladda ner PDF',
	'coll-remove'                     => 'Ta bort',
	'coll-move_to_top'                => 'Flytta till toppen',
	'coll-move_up'                    => 'Flytta upp',
	'coll-move_down'                  => 'Flytta ner',
	'coll-move_to_bottom'             => 'Flytta till botten',
	'coll-title'                      => 'Titel:',
	'coll-subtitle'                   => 'Undertitel:',
	'coll-contents'                   => 'Innehåll',
	'coll-create_chapter'             => 'Skapa nytt kapitel',
	'coll-sort_alphabetically'        => 'Sortera sidor alfabetiskt',
	'coll-clear_collection'           => 'Töm samling',
	'coll-clear_confirm'              => 'Vill du verkligen tömma din samling?',
	'coll-rename'                     => 'Byt name',
	'coll-new_chapter'                => 'Välj ett namn för det nya kapitlet',
	'coll-rename_chapter'             => 'Välj ett nytt namn för kapitlet',
	'coll-no_such_category'           => 'Ingen sådan kategori',
	'coll-notitle_title'              => 'Titeln av sidan kunde inte fastställas.',
	'coll-post_failed_title'          => 'POST-begäring avslagen',
	'coll-post_failed_msg'            => 'POST-begäringen till $1 avslagen ($2).',
	'coll-pdfserver_failed_title'     => 'Fel med PDF-servern',
	'coll-pdfserver_failed_msg'       => 'Ett fel uppstod med PDF-servern: $1',
	'coll-enter_title'                => 'Skriv in samlingens namn:',
	'coll-error_reponse'              => 'Felrespons från servern',
	'coll-empty_collection'           => 'Tom samling',
	'coll-revision'                   => 'Revision: %PARAM%',
	'coll-save_collection_title'      => 'Spara samling',
	'coll-save_collection_text'       => 'För att spara denna samling för senare bruk, välj en samlingstyp och skriv in en sidtitel:',
	'coll-login_to_save'              => 'Om du vill spara samlingar för senare bruk, var god [[Special:Userlogin|logga in eller skapa ett konto]].',
	'coll-personal_collection_label'  => 'Personlig samling:',
	'coll-community_collection_label' => 'Deltagarsamling:',
	'coll-save_collection'            => 'Spara samling',
	'coll-overwrite_title'            => 'Sidan existerar. Vill du skriva över den?',
	'coll-overwrite_text'             => 'En sida med namnet [[:$1]] finns redan.
Vill du ersätta den med din samling?',
	'coll-yes'                        => 'Ja',
	'coll-no'                         => 'Nej',
	'coll-load_overwrite_text'        => 'Du har redan några sidor i din samling.
Vill du ersätta din nuvarande samling, lägga till det nya innehållet eller avbryta?',
	'coll-overwrite'                  => 'Skriv över',
	'coll-append'                     => 'Lägga till',
	'coll-cancel'                     => 'Avbryt',
	'coll-limit_exceeded_title'       => 'Samlingen är för stor',
	'coll-limit_exceeded_text'        => 'Din sid samling är för stor.
Inga mer sidor kan läggas till.',
	'coll-rendering_title'            => 'Skapar',
	'coll-rendering_text'             => "'''Vänta medans dokumentet skapas.'''

Tillstånd: '''$1%'''.

Denna sida ska uppdateras automatisk med några sekunders mellanrum.
Om det inte fungerar, tryck på uppdateringsknappen i din webbläsare.",
	'coll-rendering_finished_title'   => 'Rendering avslutad',
	'coll-rendering_finished_text'    => "'''Dokumentfilen har skapats.'''
[$1 Klicka här] för att ladda ner det till din dator.

Inte nöjd med resultatet?
Se [[{{MediaWiki:Coll-helppage}}|hjälpsidan om samlingar]] för möjligheter att förbättra den.",
	'coll-notfound_title'             => 'Samling inte funnen',
	'coll-notfound_text'              => 'Kan inte hitta samlings sida',
	'coll-return_to_collection'       => 'Tillbaka till <a href="$1">$2</a>',
	'coll-book_title'                 => 'Beställ utskriven bok',
	'coll-book_text'                  => 'Du kan beställa en tryckt bok som rymmer din artikelsamling genom att besöka en av de samarbetspartners som utför behovstryckning:',
	'coll-order_from_pp'              => 'Beställ bok från $1',
	'coll-about_pp'                   => 'Om $1',
	'coll-invalid_podpartner_title'   => 'Ogiltig POD-partner',
	'coll-invalid_podpartner_msg'     => 'Den erbjudna POD-partnern är ogiltig.
Var god kontakta din MediaWiki-administratör.',
	'coll-license'                    => 'Licens',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'coll-page' => 'zajta',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author వైజాసత్య
 * @author Siebrand
 */
$messages['te'] = array(
	'coll-desc'                       => '[[Special:Collection|పేజీలను సేకరించండి]], PDFలను తయారుచేసుకోండి',
	'coll-collections'                => 'సేరకణలు',
	'coll-portlet_title'              => 'నా సేకరణ',
	'coll-add_page'                   => 'పేజీని చేర్చు',
	'coll-remove_page'                => 'పేజీని తొలగించు',
	'coll-add_category'               => 'వర్గాన్ని చేర్చు',
	'coll-show_collection'            => 'సేకరణని చూపించు',
	'coll-help_collections'           => 'సేకరణల సహాయం',
	'coll-empty'                      => 'ఖాళీ',
	'coll-page'                       => 'పేజీ',
	'coll-pages'                      => 'పేజీలు',
	'coll-download_as_pdf'            => 'PDFగా దిగుమతి చేసుకోండి',
	'coll-helppage'                   => 'Help:సేకరణలు',
	'coll-my_collection'              => 'నా సేకరణ',
	'coll-download_title'             => 'సేకరణని PDFగా దిగుమతి చేసుకోండి',
	'coll-download_text'              => 'మీ పేజీ సేకరణ నుండి ఆటోమెటిగ్గా తయారయిన PDF ఫైలుని దిగుమతిచేసుకోడానికి, ఈ బొత్తాన్ని నొక్కండి.',
	'coll-download_pdf'               => 'PDFని దిగుమతి చేసుకోండి',
	'coll-remove'                     => 'తొలగించు',
	'coll-move_up'                    => 'పైకి కదుపు',
	'coll-move_down'                  => 'క్రిందికి కదుపు',
	'coll-move_to_bottom'             => 'అడుగునకు కదుపు',
	'coll-title'                      => 'శీర్షిక:',
	'coll-subtitle'                   => 'ఉపశీర్షిక:',
	'coll-contents'                   => 'విషయాలు',
	'coll-create_chapter'             => 'కొత్త అధ్యాయాన్ని ప్రారంభించు',
	'coll-sort_alphabetically'        => 'పేజీలను అక్షరక్రమంలో అమర్చు',
	'coll-clear_collection'           => 'సేకరణని తుడిచివేయి',
	'coll-clear_confirm'              => 'మీరు నిజంగానే మీ సేకరణని తుడిచివేయాలనుకుంటున్నారా?',
	'coll-rename'                     => 'పేరుమార్చు',
	'coll-new_chapter'                => 'కొత్త అధ్యాయానికి పేరు సూచించండి',
	'coll-no_such_category'           => 'అటువంటి వర్గం లేదు',
	'coll-notitle_title'              => 'ఆ పేజీ యొక్క శీర్షికని నిర్ణయించలేకున్నాం.',
	'coll-post_failed_title'          => 'POST అభ్యర్థన విఫలమైంది',
	'coll-enter_title'                => 'సేకరణకి శీర్షిక ఇవ్వండి:',
	'coll-error_reponse'              => 'సర్వరునుండి పొరపాటు అని స్పందన వచ్చింది',
	'coll-empty_collection'           => 'ఖాళీ సేకరణ',
	'coll-revision'                   => 'కూర్పు: %PARAM%',
	'coll-save_collection_title'      => 'సేకరణని భద్రపరచండి',
	'coll-save_collection_text'       => 'ఈ సేకరణని తర్వాత వాడుకోడానికి భద్రపరచుకోవాలంటే, ఓ సేకరణ రకాన్ని ఎంచుకోండి మరియు పేజీ శీర్షిక ఇవ్వండి:',
	'coll-login_to_save'              => 'సేకరణలని మీరు తర్వాత వాడుకోవడానికి భద్రపరచుకోవాలనుకుంటే, [[Special:Userlogin|లోనికి ప్రవేశించండి లేదా ఖాతా సృష్టించుకోండి]].',
	'coll-personal_collection_label'  => 'వ్యక్తిగత సేరకణ:',
	'coll-community_collection_label' => 'సామూహిక సేకరణ:',
	'coll-save_collection'            => 'సేకరణని భద్రపరచు',
	'coll-overwrite_title'            => 'పేజీ ఉంది. దానిపైనే రాసేయాలా?',
	'coll-overwrite_text'             => '[[:$1]] అనే పేరుతో ఓ పేజీ ఇప్పటికే ఉంది.
దాని స్ధానంలో మీ సేకరణని ఉంచాలా?',
	'coll-yes'                        => 'అవును',
	'coll-no'                         => 'కాదు',
	'coll-append'                     => 'జతచేయి',
	'coll-cancel'                     => 'రద్దు',
	'coll-limit_exceeded_title'       => 'సేకరణ మరీ పెద్దగా ఉంది',
	'coll-limit_exceeded_text'        => 'మీ పేజీ సేకరణ చాలా పెద్దగా ఉంది.
మరిన్ని పేజీలు చేర్చలేము.',
	'coll-notfound_title'             => 'సేకరణ కనబడలేదు',
	'coll-notfound_text'              => 'సేకరణ పేజీ కనబడలేదు.',
	'coll-return_to_collection'       => 'తిరిగి <a href="$1">$2</a>కి',
	'coll-order_from_pp'              => '$1 నుండి పుస్తకాన్ని ఆర్డర్ చెయ్యండి',
	'coll-about_pp'                   => '$1 గురించి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'coll-empty'    => 'mamuk',
	'coll-page'     => 'pájina',
	'coll-yes'      => 'Sin',
	'coll-no'       => 'Lae',
	'coll-about_pp' => 'Kona-ba $1',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 * @author Siebrand
 */
$messages['tg-cyrl'] = array(
	'coll-desc'                       => '[[Special:Collection|Гирдоварии саҳифаҳо]], тавлиди PDFҳо',
	'coll-collections'                => 'Гирдовариҳо',
	'coll-portlet_title'              => 'Гирдоварии Ман',
	'coll-add_page'                   => 'Илова кардани саҳифа',
	'coll-remove_page'                => 'Пок кардани саҳифа',
	'coll-add_category'               => 'Илова кардани гурӯҳ',
	'coll-load_collection'            => 'Бор кардани гирдоварӣ',
	'coll-show_collection'            => 'Намоиши гирдоварӣ',
	'coll-help_collections'           => 'Роҳнамои гирдовариҳо',
	'coll-empty'                      => 'холӣ',
	'coll-page'                       => 'саҳифа',
	'coll-pages'                      => 'саҳифаҳо',
	'coll-download_as_pdf'            => 'Боргузорӣ ҳамчун PDF',
	'coll-noscript_text'              => '<h1>ҶаваСкрипт Лозим аст!</h1>
<strong>Мурургари шумо ҶаваСкриптро дастгирӣ намекунад ё ҶаваСкрипт хомӯш карда шудааст.
Ин саҳифа дуруст кор хоҳад карда, дар ҳолате, ки ҶаваСкрипт фаъол карда шуда бошад.</strong>',
	'coll-intro_text'                 => 'Шумо метавонед саҳифаҳоро гирдовари кунед, тавлид ва бор кардани парвандаҳои PDF аз саҳифаҳои гирдовариҳо ва захир кардани гирдовариҳо барои истифодаи баъдӣ ё бо ҳам дидани онҳо бо дигарон.

Барои иттилооти бештар нигаред ба [[{{MediaWiki:Coll-helppage}}|саҳифаи роҳнамо оиди гирдовариҳо]].',
	'coll-helppage'                   => 'Help:Гирдовариҳо',
	'coll-my_collection'              => 'Гирдоварии Ман',
	'coll-download_title'             => 'Бор кардани гирдовари ҳамчун PDF',
	'coll-download_text'              => 'Барои бор кардани парвандаи PDF саҳифаи гирдоварии худ, ки ба таври худкор ҳосил шудааст, тугмаро пахш кунед.',
	'coll-download_pdf'               => 'Боргузории PDF',
	'coll-remove'                     => 'Ҳазф',
	'coll-move_to_top'                => 'Ҳаракат бо боло',
	'coll-move_up'                    => 'Ба боло',
	'coll-move_down'                  => 'Ба поён',
	'coll-move_to_bottom'             => 'Ҳаракат ба поён',
	'coll-title'                      => 'Унвон:',
	'coll-subtitle'                   => 'Зерунвон:',
	'coll-contents'                   => 'Мундариҷа',
	'coll-create_chapter'             => 'Эҷоди фасли ҷадид',
	'coll-sort_alphabetically'        => 'Аз рӯи алифбо ба тартиб даровардани саҳифаҳо',
	'coll-clear_collection'           => 'Тоза кардани гирдовари',
	'coll-clear_confirm'              => 'Оё шумо дар ҳақиқат мехоҳед гирдоварии худро пок кунед?',
	'coll-rename'                     => 'Тағйири ном',
	'coll-new_chapter'                => 'Барои фасли ҷадид номеро ворид кунед',
	'coll-rename_chapter'             => 'Барои фасл номи ҷадидеро ворид кунед',
	'coll-no_such_category'           => 'Чунин гурӯҳ вуҷуд надорад',
	'coll-notitle_title'              => 'Унвони саҳифа мушаххас шуда наметавонад.',
	'coll-enter_title'                => 'Барои гирдовари унвонеро ворид кунед:',
	'coll-error_reponse'              => 'Посухи хатое аз хидматгузор',
	'coll-empty_collection'           => 'Холӣ кардани гирдовари',
	'coll-revision'                   => 'Нусха: %PARAM%',
	'coll-save_collection_title'      => 'Захира кардани гирдовари',
	'coll-save_collection_text'       => 'Барои захираи ин гирдовари барои истифодаи баъдӣ, навъи гирдовариро интихоб кунед ва унвони саҳифаро ворид кунед:',
	'coll-login_to_save'              => 'Агар майли захира кардани гирдовариҳоро барои истифодаи баъдӣ дошта бошед, лутфан [[Special:Userlogin|ба систем ворид шавед ё ҳисоби ҷадидиро эчод кунед]].',
	'coll-personal_collection_label'  => 'Гирдоварии шахсӣ:',
	'coll-community_collection_label' => 'Гирдоварии умум:',
	'coll-save_collection'            => 'Захираи Гирдовари',
	'coll-overwrite_title'            => 'Саҳифа вуҷуд дорад. Ба рӯи он аз навишта шавад?',
	'coll-overwrite_text'             => 'Саҳифае бо номи [[:$1]] аллакай вуҷуд дорад.
Оё шумо мехоҳед онро бо гирдоварии худ иваз кунед?',
	'coll-yes'                        => 'Бале',
	'coll-no'                         => 'Не',
	'coll-load_overwrite_text'        => 'Шумо аллакай якчанд саҳифаҳоеро дар гирдоварии худ доред.
Оё шумо мехоҳед рӯи гирдоварии кунуниатон нависед, мӯҳтавои ҷадидро пайваст ё лағв кунед?',
	'coll-overwrite'                  => 'Ба рӯй навиштан',
	'coll-append'                     => 'Афзудан',
	'coll-cancel'                     => 'Лағв',
	'coll-limit_exceeded_title'       => 'Гирдовари Хеле Бузург',
	'coll-limit_exceeded_text'        => 'Саҳифаи гирдоварии шумо хеле бузург аст.
Аз ин зиёд саҳифаҳо наметавонанд илова шаванд.',
	'coll-notfound_title'             => 'Гирдовари Ёфт Нашуд',
	'coll-notfound_text'              => 'Саҳифаи гирдоварӣ ёфт нашуд.',
	'coll-return_to_collection'       => 'Бозгашт ба <a href="$1">$2</a>',
	'coll-book_title'                 => 'Фармудани Китоби Чопӣ',
	'coll-book_text'                  => 'Шумо метавонед китоби ба табъ расидаро, ки саҳифаи гирдовариҳои шуморо дорост бо ташриф овардан ба яке аз ҳамкорони чоп-дархост фармоед:',
	'coll-order_from_pp'              => 'Фармудани китоб аз $1',
	'coll-about_pp'                   => 'Дар бораи $1',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Suelnur
 */
$messages['tr'] = array(
	'coll-collections'   => 'Koleksiyonlar',
	'coll-portlet_title' => 'Koleksiyonum',
	'coll-empty'         => 'boş',
	'coll-page'          => 'sayfa',
	'coll-pages'         => 'sayfalar',
	'coll-remove'        => 'Kaldır',
	'coll-title'         => 'Başlık:',
	'coll-yes'           => 'Evet',
	'coll-no'            => 'Hayır',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author Siebrand
 */
$messages['uk'] = array(
	'coll-desc'                       => '[[Special:Collection|Збирає колекції сторінок]], створює PDF',
	'coll-collections'                => 'Колекції',
	'coll-portlet_title'              => 'Моя колекція',
	'coll-add_page'                   => 'Додати сторінку',
	'coll-remove_page'                => 'Вилучити сторінку',
	'coll-add_category'               => 'Додати категорію',
	'coll-load_collection'            => 'Завантажити колекцію',
	'coll-show_collection'            => 'Показати колекцію',
	'coll-help_collections'           => 'Довідка про колекції',
	'coll-empty'                      => 'порожня',
	'coll-page'                       => 'сторінка',
	'coll-pages'                      => 'сторінки',
	'coll-download_as_pdf'            => 'Завантажити як PDF',
	'coll-noscript_text'              => '<h1>Потрібен JavaScript!</h1>
<strong>Ваш браузер не підтримує JavaScript або ця підтримка вимкнена.
Ця сторінка не буде працювати правильно, якщо JavaScript не ввімкнений.</strong>',
	'coll-intro_text'                 => "Ви можете об'єднати сторінки в колекцію, створити і завантажити PDF-файл з набором сторінок, або зберегти колекцію сторінок для наступної роботи або обміну.

Подробиці можна знайти на [[{{MediaWiki:Coll-helppage}}|довідковій сторінці про колекції]].",
	'coll-helppage'                   => 'Help:Колекції',
	'coll-my_collection'              => 'Моя колекція',
	'coll-download_title'             => 'Завантажити колекцію як PDF',
	'coll-download_text'              => 'Щоб завантажити автоматично створений PDF-файл з вашою колекцією сторінок, натисніть кнопку.',
	'coll-download_pdf'               => 'Завантажити PDF',
	'coll-remove'                     => 'Вилучити',
	'coll-move_to_top'                => 'Перемістити вгору',
	'coll-move_up'                    => 'Перемістити вище',
	'coll-move_down'                  => 'Перемістити нижче',
	'coll-move_to_bottom'             => 'Перемістити донизу',
	'coll-title'                      => 'Назва:',
	'coll-subtitle'                   => 'Підзаголовок:',
	'coll-contents'                   => 'Зміст',
	'coll-create_chapter'             => 'Створити новий розділ',
	'coll-sort_alphabetically'        => 'Сортувати сторінки за алфавітом',
	'coll-clear_collection'           => 'Очистити колекцію',
	'coll-clear_confirm'              => 'Ви дійсно хочете очистити вашу колекцію?',
	'coll-rename'                     => 'Перейменувати',
	'coll-new_chapter'                => 'Уведіть назву нового розділу',
	'coll-rename_chapter'             => 'Уведіть нову назву розділу',
	'coll-no_such_category'           => 'Нема такої категорії',
	'coll-notitle_title'              => 'Заголовок сторінки неможливо визначити.',
	'coll-post_failed_title'          => 'POST-запит не виконаний',
	'coll-post_failed_msg'            => 'POST-запит не виконаний ($2).',
	'coll-enter_title'                => 'Уведіть назву колекції:',
	'coll-error_reponse'              => 'Помилка відповіді сервера',
	'coll-empty_collection'           => 'Порожня колекція',
	'coll-revision'                   => 'Версія: %PARAM%',
	'coll-save_collection_title'      => 'Зберегти колекцію',
	'coll-save_collection_text'       => 'Щоб зберегти колекцію для подальшого використання, оберіть тип колекції і введіть назву сторінки:',
	'coll-login_to_save'              => 'Щоб зберегти колекцію для подальшого використання, будь ласка, [[Special:Userlogin|ввійдіть до системи або створить обліковий запис]].',
	'coll-personal_collection_label'  => 'Особиста колекція:',
	'coll-community_collection_label' => 'Колекція спільноти:',
	'coll-save_collection'            => 'Зберегти колекцію',
	'coll-overwrite_title'            => 'Сторінка існує. Перезаписати?',
	'coll-overwrite_text'             => 'Сторінка з назвою [[:$1]] вже існує.
Ви хочете, щоб вона була замінена вашою колекцією?',
	'coll-yes'                        => 'Так',
	'coll-no'                         => 'Ні',
	'coll-load_overwrite_text'        => 'У вас уже є кілька сторінок у колекції.
Ви хочете перезаписати вашу поточну колекцію, додати новий матеріал чи скасувати дію?',
	'coll-overwrite'                  => 'Перезаписати',
	'coll-append'                     => 'Додати',
	'coll-cancel'                     => 'Скасувати',
	'coll-limit_exceeded_title'       => 'Колекція дуже велика',
	'coll-limit_exceeded_text'        => 'Ваша колекція дуже велика.
До неї не можна більше додавати сторінок.',
	'coll-notfound_title'             => 'Колекція не знайдена',
	'coll-notfound_text'              => 'Неможливо знайти сторінку колекції.',
	'coll-return_to_collection'       => 'Назад до <a href="$1">$2</a>',
	'coll-book_title'                 => 'Замовити друковану книгу',
	'coll-book_text'                  => 'Ви можете замовити друковану книгу, що містить вашу колекцію сторінок, скориставшись однією з наступних пропозицій друку за запитом:',
	'coll-order_from_pp'              => 'Замовлення книги в $1',
	'coll-about_pp'                   => 'Про $1',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 * @author Siebrand
 */
$messages['vi'] = array(
	'coll-desc'                       => '[[Special:Collection|Tập hợp trang lại]], tạo thành tập tin PDF',
	'coll-collections'                => 'Tập hợp',
	'coll-portlet_title'              => 'Tập hợp của tôi',
	'coll-add_page'                   => 'Thêm trang',
	'coll-remove_page'                => 'Dời trang',
	'coll-add_category'               => 'Thêm thể loại',
	'coll-load_collection'            => 'Mở tập hợp',
	'coll-show_collection'            => 'Xem tập hợp',
	'coll-help_collections'           => 'Trợ giúp tập hợp',
	'coll-empty'                      => 'trống',
	'coll-page'                       => 'trang',
	'coll-pages'                      => 'trang',
	'coll-download_as_pdf'            => 'Tải xuống PDF',
	'coll-noscript_text'              => '<h1>Yêu cầu phải có JavaScript!</h1>
<strong>Trình duyệt của bạn không hỗ trợ JavaScript hoặc JavaScript đã bị tắt.
Trang này sẽ không hoạt động đúng, trừ khi bạn kích hoạt JavaScript.</strong>',
	'coll-intro_text'                 => 'Bạn có thể tập hợp các trang, tạo ra và tải về một tập tin PDF từ tập hợp trang đó và lưu tập hợp lại để dùng hoặc chia sẻ chúng về sau.

Mời xem [[{{MediaWiki:Coll-helppage}}|trang trợ giúp về tập hợp]] để biết thêm thông tin.',
	'coll-helppage'                   => 'Help:Tập hợp',
	'coll-my_collection'              => 'Tập hợp của tôi',
	'coll-download_title'             => 'Tải tập hợp về dưới dạng PDF',
	'coll-download_text'              => 'Để tải về một tập tin PDF được tự động tạo ra từ tập hợp trang của bạn, hãy nhấn nút.',
	'coll-download_pdf'               => 'Tải xuống PDF',
	'coll-remove'                     => 'Dời',
	'coll-move_to_top'                => 'Di chuyển lên đầu',
	'coll-move_up'                    => 'Chuyển lên',
	'coll-move_down'                  => 'Chuyển xuống',
	'coll-move_to_bottom'             => 'Di chuyển xuống dưới',
	'coll-title'                      => 'Tựa đề:',
	'coll-subtitle'                   => 'Phụ đề:',
	'coll-contents'                   => 'Nội dung',
	'coll-create_chapter'             => 'Tạo chương mới',
	'coll-sort_alphabetically'        => 'Sắp xếp trang theo vần',
	'coll-clear_collection'           => 'Xóa tập hợp',
	'coll-clear_confirm'              => 'Bạn có thực sự muốn xóa tập hợp của mình?',
	'coll-rename'                     => 'Đổi tên',
	'coll-new_chapter'                => 'Gõ vào tên chương mới',
	'coll-rename_chapter'             => 'Gõ vào tên chương mới',
	'coll-no_such_category'           => 'Không có thể loại như vậy',
	'coll-notitle_title'              => 'Không xác định được tựa đề của trang.',
	'coll-post_failed_title'          => 'Yêu cầu POST thất bại',
	'coll-post_failed_msg'            => 'Yêu cầu POST đến $1 thất bại ($2).',
	'coll-enter_title'                => 'Gõ vào tựa đề của tập hợp:',
	'coll-error_reponse'              => 'Máy chủ trả về lỗi',
	'coll-empty_collection'           => 'Tập hợp trống',
	'coll-revision'                   => 'Phiên bản: %PARAM%',
	'coll-save_collection_title'      => 'Lưu tập hợp',
	'coll-save_collection_text'       => 'Để lưu tập hợp này lại sau này dùng, hãy chọn một kiểu tập hợp và gõ vào tựa đề trang:',
	'coll-login_to_save'              => 'Nếu bạn muốn lưu tập hợp để sau này dùng, xin hãy [[Special:Userlogin|đăng nhập hoặc mở tài khoản]].',
	'coll-personal_collection_label'  => 'Tập hợp cá nhân:',
	'coll-community_collection_label' => 'Tập hợp cộng đồng:',
	'coll-save_collection'            => 'Lưu tập hợp',
	'coll-overwrite_title'            => 'Trang đã tồn tại. Ghi đè?',
	'coll-overwrite_text'             => 'Trang với tên [[:$1]] đã tồn tại.
Bạn có muốn thay thế nó bằng tập hợp của bạn?',
	'coll-yes'                        => 'Có',
	'coll-no'                         => 'Không',
	'coll-load_overwrite_text'        => 'Bạn đã có một số trang trong tập hợp của mình.
Bạn có muốn ghi đè tập hợp hiện tại, thêm nội dung mới hay hủy bỏ?',
	'coll-overwrite'                  => 'Ghi đè',
	'coll-append'                     => 'Thêm vào',
	'coll-cancel'                     => 'Bãi bỏ',
	'coll-limit_exceeded_title'       => 'Tập hợp quá lớn',
	'coll-limit_exceeded_text'        => 'Tập hợp các trang của bạn quá lớn.
Không thể thêm trang được nữa.',
	'coll-notfound_title'             => 'Không tìm thấy tập hợp',
	'coll-notfound_text'              => 'Không tìm thấy trang tập hợp.',
	'coll-return_to_collection'       => 'Quay trở về <a href="$1">$2</a>',
	'coll-book_title'                 => 'Đặt sách in',
	'coll-book_text'                  => 'Bạn có thể đặt một cuốn sách in có chứa tập hợp trang của bạn bằng cách ghét thăm mọt trong những bên cộng tác in-theo-yêu-cầu:',
	'coll-order_from_pp'              => 'Đặt sách từ $1',
	'coll-about_pp'                   => 'Giới thiệu $1',
	'coll-invalid_podpartner_title'   => 'Thành phần đi kèm POD không hợp lệ',
	'coll-invalid_podpartner_msg'     => 'Thành phần đi kèm POD đã cung cấp không hợp lệ.
Xin hãy liên hệ với quản trị viên MediaWiki của bạn.',
	'coll-license'                    => 'Giấy phép',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'coll-page'          => 'pad',
	'coll-pages'         => 'pads',
	'coll-helppage'      => 'Yuf:Konlets',
	'coll-my_collection' => 'Konlet Obik',
	'coll-title'         => 'Tiäd:',
	'coll-yes'           => 'Si',
	'coll-no'            => 'Nö',
);

