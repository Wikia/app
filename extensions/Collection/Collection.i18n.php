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
	'coll-desc'                       => '[[Special:Book|Create books]]',
	'coll-collection'                 => 'Book',
	'coll-collections'                => 'Books',
	'coll-exclusion_category_title'   => 'Exclude in print',
	'coll-template_blacklist_title'   => 'MediaWiki:PDF Template Blacklist', # do not translate or duplicate this message to other languages
	'coll-print_template_prefix'      => 'Print',
	'coll-print_template_pattern'     => '$1/Print',
	'coll-create_a_book'              => 'Create a book',
	'coll-add_page'                   => 'Add wiki page',
	'coll-add_page_tooltip'           => 'Add the current wiki page to your book',
	'coll-remove_page'                => 'Remove wiki page',
	'coll-remove_page_tooltip'        => 'Remove the current wiki page from your book',
	'coll-add_category'               => 'Add category',
	'coll-add_category_tooltip'       => 'Add all wiki pages in this category to your book',
	'coll-load_collection'            => 'Load book',
	'coll-load_collection_tooltip'    => 'Load this book as your current book',
	'coll-show_collection'            => 'Show book',
	'coll-show_collection_tooltip'    => 'Click to edit/download/order your book',
	'coll-help_collections'           => 'Books help',
	'coll-help_collections_tooltip'   => 'Show help about the book tool',
	'coll-n_pages'                    => '$1 {{PLURAL:$1|page|pages}}',
	'coll-unknown_subpage_title'      => 'Unknown subpage',
	'coll-unknown_subpage_text'       => 'This subpage of [[Special:Book|Book]] does not exist',
	'coll-printable_version_pdf'      => 'PDF version',
	'coll-download_as'                => 'Download as $1',
	'coll-noscript_text'              => '<h1>JavaScript is required!</h1>
<strong>Your browser does not support JavaScript or JavaScript has been turned off.
This page will not work correctly, unless JavaScript is enabled.</strong>',
	'coll-intro_text'                 => "Create and manage your individual selection of wiki pages.<br />See [[{{MediaWiki:Coll-helppage}}]] for more information.",
	'coll-helppage'                   => 'Help:Books',
	'coll-bookscategory'              => 'Books',
	'coll-savedbook_template'         => 'saved_book',
	'coll-your_book'                  => 'Your book',
	'coll-download_title'             => 'Download',
	'coll-download_text'              => 'To download a version choose a format and click the button.',
	'coll-download_as_text'           => 'To download a version in $1 format click the button.',
	'coll-download'                   => 'Download',
	'coll-format_label'               => 'Format:',
	'coll-remove'                     => 'Remove',
	'coll-show'                       => 'Show',
	'coll-move_to_top'                => 'Move to top',
	'coll-move_up'                    => 'Move up',
	'coll-move_down'                  => 'Move down',
	'coll-move_to_bottom'             => 'Move to bottom',
	'coll-title'                      => 'Title:',
	'coll-subtitle'                   => 'Subtitle:',
	'coll-contents'                   => 'Contents',
	'coll-drag_and_drop'              => 'Use drag & drop to reorder wiki pages and chapters',
	'coll-create_chapter'             => 'Create chapter',
	'coll-sort_alphabetically'        => 'Sort alphabetically',
	'coll-clear_collection'           => 'Clear book',
	'coll-clear_collection_tooltip'   => 'Remove all wiki pages from your current book',
	'coll-clear_collection_confirm'   => 'Do you really want to completely clear your book?',
	'coll-rename'                     => 'Rename',
	'coll-new_chapter'                => 'Enter name for new chapter',
	'coll-rename_chapter'             => 'Enter new name for chapter',
	'coll-no_such_category'           => 'No such category',
	'coll-notitle_title'              => 'Could not get page title',
	'coll-notitle_title'              => 'The title of the page could not be determined.',
	'coll-post_failed_title'          => 'POST request failed',
	'coll-post_failed_msg'            => 'The POST request to $1 failed ($2).',
	'coll-mwserve_failed_title'       => 'Render server error',
	'coll-mwserve_failed_msg'         => 'An error occured on the render server: <nowiki>$1</nowiki>',
	'coll-error_reponse'              => 'Error response from server',
	'coll-empty_collection'           => 'Empty book',
	'coll-revision'                   => 'Revision: $1',
	'coll-save_collection_title'      => 'Save and share your book',
	'coll-save_collection_text'       => 'Choose a storage location for your book:',
	'coll-login_to_save'              => 'If you want to save books for later use, please [[Special:UserLogin|log in or create an account]].',
	'coll-personal_collection_label'  => 'Personal book:',
	'coll-community_collection_label' => 'Community book:',
	'coll-save_collection'            => 'Save book',
	'coll-save_category'              => 'All books are saved in the category [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title'            => 'Page exists.
Overwrite?',
	'coll-overwrite_text'             => 'A page with the name [[:$1]] already exists.
Do you want it to be replaced with your book?',
	'coll-yes'                        => 'Yes',
	'coll-no'                         => 'No',
	'coll-load_overwrite_text'        => 'You already have some pages in your book.
Do you want to overwrite your current book, append the new content, or cancel loading this book?',
	'coll-overwrite'                  => 'Overwrite',
	'coll-append'                     => 'Append',
	'coll-cancel'                     => 'Cancel',
	'coll-update'                     => 'Update',
	'coll-limit_exceeded_title'       => 'Book too big',
	'coll-limit_exceeded_text'        => 'Your book is too big.
No more pages can be added.',
	'coll-rendering_title'            => 'Rendering',
	'coll-rendering_text'             => "<p><strong>Please wait while the document is being generated.</strong></p>

<p><strong>Progress:</strong> <span id=\"renderingProgress\">$1</span>% <span id=\"renderingStatus\">$2</span></p>

<p>This page should automatically refresh every few seconds.
If this does not work, please press refresh button of your browser.</p>",
	'coll-rendering_status'           => "<strong>Status:</strong> $1",
	'coll-rendering_article'          => '(wiki page: $1)',
	'coll-rendering_page'             => '(page: $1)',
	'coll-rendering_finished_title'   => 'Rendering finished',
	'coll-rendering_finished_text'    => "<strong>The document file has been generated.</strong>
<strong>[$1 Download the file]</strong> to your computer.

Notes:
* Not satisfied with the output? See [[{{MediaWiki:Coll-helppage}}|the help page about books]] for possibilities to improve it.",
	'coll-notfound_title'             => 'Book not found',
	'coll-notfound_text'              => 'Could not find book page.',
	'coll-is_cached'                  => '<ul><li>A cached version of the document has been found, so no rendering was necessary. <a href="$1">Force re-rendering.</a></li></ul>',
	'coll-excluded-templates'         => '* Templates in category [[:Category:$1|$1]] have been excluded.',
	'coll-blacklisted-templates'      => '* Templates on blacklist [[:$1]] have been excluded.',
	'coll-return_to_collection'       => '<p>Return to <a href="$1">$2</a></p>',
	'coll-book_title'                 => 'Order as a printed book',
	'coll-book_text'                  => 'Get a printed book from our print-on-demand partner:',
	'coll-order_from_pp'              => 'Order book from $1',
	'coll-about_pp'                   => 'About $1',
	'coll-invalid_podpartner_title'   => 'Invalid POD partner',
	'coll-invalid_podpartner_msg'     => 'The supplied POD partner is invalid.
Please contact your MediaWiki administrator.',
	'coll-license'                    => 'License',
	'coll-license_url'                => '-',
	'coll-return_to'                  => "Return to [[:$1]]",
);

/** Message documentation (Message documentation)
 * @author Aleator
 * @author Aotake
 * @author Darth Kule
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Mormegil
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author Wmr89502270
 */
$messages['qqq'] = array(
	'coll-desc' => 'Short description of this extension, shown in [[Special:Version]]. Do not translate or change links.',
	'coll-collection' => '{{Identical|Book}}',
	'coll-collections' => '{{Identical|Book}}',
	'coll-exclusion_category_title' => 'The message text is the name of a category.',
	'coll-print_template_prefix' => 'Prefix added to the templates name if you want to get a special for-print version of the template. So in a page instead of Template:Foo Template:PrintFoo is used if it exists.',
	'coll-print_template_pattern' => 'Use print templates being subpages of regular templates.

$1 is a placeholder and will be replaced by content during the rendering process.',
	'coll-create_a_book' => '{{Identical|Books}}',
	'coll-printable_version_pdf' => 'Caption of a link in the [[mw:Help:Navigation#Toolbox|toolbox]] leading to the PDF version of the current page',
	'coll-download_as' => '{{Identical|Download}}',
	'coll-helppage' => "Used as a link to the help page for this extension's functionality on a wiki. '''Do not translate ''Help:''.'''
{{Identical|Book}}",
	'coll-bookscategory' => '{{Identical|Book}}',
	'coll-your_book' => '{{Identical|Books}}',
	'coll-download_title' => '{{Identical|Download}}',
	'coll-download' => '{{Identical|Download}}',
	'coll-remove' => '{{Identical|Remove}}',
	'coll-show' => '{{Identical|Show}}',
	'coll-title' => '{{Identical|Title}}',
	'coll-contents' => '{{Identical|Contents}}',
	'coll-clear_collection_confirm' => 'Message box when pressed "Clear book".',
	'coll-save_category' => 'Do not change <nowiki>{{MediaWiki:Coll-bookscategory}}</nowiki>. The link and category name should be in the content language.',
	'coll-yes' => '{{Identical|Yes}}',
	'coll-no' => '{{Identical|No}}',
	'coll-cancel' => '{{Identical|Cancel}}',
	'coll-rendering_status' => '{{Identical|Status}}',
	'coll-order_from_pp' => '* $1 is the name of a print provider (a company name)',
	'coll-about_pp' => '{{Identical|About}}',
	'coll-return_to' => '{{Identical|Return to $1}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'coll-cancel' => "Mao'ạki",
	'coll-about_pp' => 'Hün se $1',
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'coll-cancel' => 'Keskevytä',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'coll-cancel' => 'Tiaki',
);

/** Goanese Konkani (Latin) (कोंकणी/Konknni  (Latin))
 * @author Deepak D'Souza
 */
$messages['gom-latn'] = array(
	'coll-return_to' => '[[:$1]] ak patim vos',
);

/** Afrikaans (Afrikaans)
 * @author Anrie
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'coll-collection' => 'Versameling',
	'coll-collections' => 'Versamelings',
	'coll-exclusion_category_title' => 'Laat weg met afdrukke',
	'coll-print_template_prefix' => 'Afdruk',
	'coll-create_a_book' => 'My versameling',
	'coll-add_page' => 'Voeg bladsy by',
	'coll-remove_page' => 'Verwyder bladsy',
	'coll-add_category' => 'Voeg kategorie by',
	'coll-load_collection' => 'Laai versameling',
	'coll-show_collection' => 'Wys versameling',
	'coll-help_collections' => 'Versamelinghulp',
	'coll-n_pages' => '$1 {{PLURAL:$1|bladsy|bladsye}}',
	'coll-unknown_subpage_title' => 'Onbekende subbladsy',
	'coll-unknown_subpage_text' => 'Hierdie subbladsy van [[Special:Book|Boek]] bestaan nie.',
	'coll-printable_version_pdf' => 'PDF-weergawe',
	'coll-download_as' => 'Laaf as $1 af',
	'coll-noscript_text' => '<h1>JavaScript word benodig!</h1>
<strong>U blaaier ondersteun nie JavaScript of JavaScript is uitgeskakel.
Hierdie bladsy sal nie korrek werk tensy JavaScript aangeskakel word nie.</strong>',
	'coll-intro_text' => 'Stel u eie versameling wikibladsye saam.<br />
[[{{MediaWiki:Coll-helppage}}|Meer inligting]].',
	'coll-helppage' => 'Help:Boeke',
	'coll-bookscategory' => 'Boeke',
	'coll-your_book' => 'U boek',
	'coll-remove' => 'Skrap',
	'coll-move_to_top' => 'Skuif tot bo',
	'coll-move_up' => 'Skuif op',
	'coll-move_down' => 'Skuif af',
	'coll-move_to_bottom' => 'Skuif tot onder',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Subtitel:',
	'coll-contents' => 'Inhoud',
	'coll-rename' => 'Hernoem',
	'coll-new_chapter' => 'Voer naam vir nuwe hoofstuk in',
	'coll-rename_chapter' => 'Voer nuwe naam vir hoofstuk in',
	'coll-no_such_category' => "Geen so 'n kategorie",
	'coll-empty_collection' => 'Lëe versameling',
	'coll-save_collection_title' => 'Stoor versameling',
	'coll-personal_collection_label' => 'Persoonlike versameling:',
	'coll-community_collection_label' => 'Gemeenskap versameling:',
	'coll-save_collection' => 'Stoor versameling',
	'coll-yes' => 'Ja',
	'coll-no' => 'Nee',
	'coll-cancel' => 'Kanselleer',
	'coll-license' => 'Lisensie',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'coll-title' => 'አርዕስት፡',
	'coll-yes' => 'አዎ',
);

/** Arabic (العربية)
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'coll-desc' => '[[Special:Book|ينشيء كتبا]]',
	'coll-collection' => 'كتاب',
	'coll-collections' => 'كتب',
	'coll-exclusion_category_title' => 'استثن في الطباعة',
	'coll-print_template_prefix' => 'طباعة',
	'coll-print_template_pattern' => '$1/طبع',
	'coll-create_a_book' => 'إنشاء كتاب',
	'coll-add_page' => 'إضافة صفحة ويكي',
	'coll-remove_page' => 'إزالة صفحة ويكي',
	'coll-add_category' => 'إضافة تصنيف',
	'coll-load_collection' => 'تحميل الكتاب',
	'coll-show_collection' => 'عرض الكتاب',
	'coll-help_collections' => 'مساعدة الكتب',
	'coll-n_pages' => '$1 {{PLURAL:$1|صفحة|صفحة}}',
	'coll-unknown_subpage_title' => 'صفحة فرعية غير معروفة',
	'coll-unknown_subpage_text' => 'هذه الصفحة الفرعية [[Special:Book|للكتاب]] غير موجودة',
	'coll-printable_version_pdf' => 'نسخة PDF',
	'coll-download_as' => 'تحميل ك$1',
	'coll-noscript_text' => '<h1>الجافاسكريبت مطلوب!</h1>
<strong>متصفحك لا يدعم جافاسكريبت جافاسكريبت أو الجافاسكريبت تم تعطيلها.
هذه الصفحة لن تعمل بطريقة صحيحة، إلا إذا تم تفعيل الجافاسكريبت.</strong>',
	'coll-intro_text' => 'أنشئ وتحكم بمجموعتك الفردية من صفحات الويكي.<br />انظر [[{{MediaWiki:Coll-helppage}}]] لمزيد من المعلومات.',
	'coll-helppage' => 'Help:كتب',
	'coll-bookscategory' => 'كتب',
	'coll-savedbook_template' => 'كتاب_محفوظ',
	'coll-your_book' => 'كتابك',
	'coll-download_title' => 'تنزيل',
	'coll-download_text' => 'لتنزيل نسخة بدون اتصال اختر نسقا وانقر الزر.',
	'coll-download_as_text' => 'لتنزيل نسخة بصيغة $1 اضغط الزر.',
	'coll-download' => 'تحميل',
	'coll-format_label' => 'الصيغة:',
	'coll-remove' => 'إزالة',
	'coll-show' => 'عرض',
	'coll-move_to_top' => 'حرك إلى الأعلى',
	'coll-move_up' => 'حرك إلى الأعلى',
	'coll-move_down' => 'حرك إلى الأسفل قليلا',
	'coll-move_to_bottom' => 'حرك إلى الأسفل',
	'coll-title' => 'العنوان:',
	'coll-subtitle' => 'العنوان الفرعي:',
	'coll-contents' => 'محتويات',
	'coll-drag_and_drop' => 'استخدم السحب والإلقاء لطلب صفحات وفصول ويكي',
	'coll-create_chapter' => 'إنشاء الفصل',
	'coll-sort_alphabetically' => 'رتب أبجديا',
	'coll-clear_collection' => 'إفراغ الكتاب',
	'coll-clear_collection_confirm' => 'هل تريد حقا إفراغ كتابك بالكامل؟',
	'coll-rename' => 'إعادة تسمية',
	'coll-new_chapter' => 'أدخل الاسم للفرع الجديد',
	'coll-rename_chapter' => 'أدخل الاسم الجديد للفرع',
	'coll-no_such_category' => 'لا تصنيف كهذا',
	'coll-notitle_title' => 'عنوان الصفحة لم يمكن تحديده.',
	'coll-post_failed_title' => 'طلب POST فشل',
	'coll-post_failed_msg' => 'طلب POST إلى $1 فشل ($2).',
	'coll-mwserve_failed_title' => 'خطأ عرض من الخادم',
	'coll-mwserve_failed_msg' => 'حدث خطأ في خادم العرض: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'خطأ استجابة من الخادم',
	'coll-empty_collection' => 'كتاب فارغ',
	'coll-revision' => 'النسخة: $1',
	'coll-save_collection_title' => 'حفظ ومشاركة كتابك',
	'coll-save_collection_text' => 'اختر موقعا:',
	'coll-login_to_save' => 'لو كنت تريد حفظ الكتب من أجل الاستخدام فيما بعد، من فضلك [[Special:UserLogin|قم بتسجيل الدخول أو إنشاء حساب]].',
	'coll-personal_collection_label' => 'كتاب شخصي:',
	'coll-community_collection_label' => 'كتاب مجتمع:',
	'coll-save_collection' => 'حفظ الكتاب',
	'coll-save_category' => 'الكتب يتم حفظها في التصنيف [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'الصفحة موجودة.
كتابة عليها؟',
	'coll-overwrite_text' => 'صفحة بنفس الاسم [[:$1]] موجودة بالفعل.
هل تريد استبدالها بمجموعتك؟',
	'coll-yes' => 'نعم',
	'coll-no' => 'لا',
	'coll-load_overwrite_text' => 'لديك بالفعل عدة صفحات في كتابك.
هل تريد الكتابة على كتابك الحالي، إضافة المحتوى الجديد أو إلغاء تحميل هذا الكتاب؟',
	'coll-overwrite' => 'كتابة عليها',
	'coll-append' => 'انتظار',
	'coll-cancel' => 'إلغاء',
	'coll-update' => 'حدّث',
	'coll-limit_exceeded_title' => 'الكتاب كبير جدا',
	'coll-limit_exceeded_text' => 'كتابك كبير جدا.
لا مزيد من الصفحات يمكن إضافتها.',
	'coll-rendering_title' => 'عرض',
	'coll-rendering_text' => '<p><strong>من فضلك انتظر أثناء توليد الوثيقة.</strong></p>

<p><strong>التقدم:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>هذه الصفحة ينبغي أن يتم تحديثها كل عدة ثوان.
لو أن هذا لا يعمل، من فضلك اضغط زر التحديث في متصفحك.</p>',
	'coll-rendering_status' => '<strong>الحالة:</strong> $1',
	'coll-rendering_article' => '(المقالة: $1)',
	'coll-rendering_page' => '(الصفحة: $1)',
	'coll-rendering_finished_title' => 'العرض انتهى',
	'coll-rendering_finished_text' => '<strong>ملف الوثيقة تم توليده.</strong>
<strong>[$1 نزل الملف]</strong> إلى حاسوبك.

ملاحظات:
* غير راض عن الخرج؟ انظر [[{{MediaWiki:Coll-helppage}}|صفحة المساعدة حول المجموعات]] للاحتمالات لتحسينه.',
	'coll-notfound_title' => 'الكتاب غير موجود',
	'coll-notfound_text' => 'لم يمكن العثور على صفحة الكتاب.',
	'coll-is_cached' => '<ul><li>نسخة مخزنة من الوثيقة تم العثور عليها، لذا لا تحديث كان ضروريا. <a href="$1">إجبار على إعادة التحديث.</a></li></ul>',
	'coll-excluded-templates' => '* القوالب في التصنيف [[:Category:$1|$1]] تم إقصاؤها.',
	'coll-blacklisted-templates' => '* القوالب في القائمة السوداء [[:$1]] تم إقصاؤها.',
	'coll-return_to_collection' => '<p>ارجع إلى <a href="$1">$2</a></p>',
	'coll-book_title' => 'طلب ككتاب مطبوع',
	'coll-book_text' => 'احصل على كتاب مطبوع من شريكنا للطباعة عند الطلب:',
	'coll-order_from_pp' => 'طلب كتاب من $1',
	'coll-about_pp' => 'حول $1',
	'coll-invalid_podpartner_title' => 'شريك POD غير صحيح',
	'coll-invalid_podpartner_msg' => 'شريك POD الموفر غير صحيح.
من فضلك اتصل بإداري ميدياويكي الخاص بك.',
	'coll-license' => 'ترخيص',
	'coll-return_to' => 'رجوع إلى [[:$1]]',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'coll-desc' => '[[Special:Book|بيعمل كتب]]',
	'coll-collection' => 'كتاب',
	'coll-collections' => 'كتب',
	'coll-exclusion_category_title' => 'استبعد من  الطبع',
	'coll-print_template_prefix' => 'اطبع',
	'coll-create_a_book' => 'إنشاء كتاب',
	'coll-add_page' => 'إضافة صفحة ويكى',
	'coll-remove_page' => 'إزالة صفحة ويكى',
	'coll-add_category' => 'إضافة تصنيف',
	'coll-load_collection' => 'تحميل كتاب',
	'coll-show_collection' => 'عرض الكتاب',
	'coll-help_collections' => 'مساعدة الكتب',
	'coll-n_pages' => '$1 {{PLURAL:$1|صفحة|صفحة}}',
	'coll-unknown_subpage_title' => 'صفحة فرعية مش معروفة',
	'coll-unknown_subpage_text' => 'صفحة ال [[Special:Book|كتاب]] الفرعيه دى مش موجوده',
	'coll-printable_version_pdf' => 'نسخة PDF',
	'coll-download_as' => 'تحميل ك$1',
	'coll-noscript_text' => '<h1>الجافاسكريبت مطلوب!</h1>
<strong>متصفحك لا يدعم جافاسكريبت جافاسكريبت أو الجافاسكريبت تم تعطيلها.
هذه الصفحة لن تعمل بطريقة صحيحة، إلا إذا تم تفعيل الجافاسكريبت.</strong>',
	'coll-intro_text' => 'يمكنك جمع الصفحات، توليد وتحميل ملف PDF من مجموعات الصفحة وحفظ مجموعات الصفحة للاستخدام بعدين أو لمشاركتها.

انظر [[{{MediaWiki:Coll-helppage}}|صفحة المساعدة حول المجموعات]] لمزيد من المعلومات.',
	'coll-helppage' => 'Help:كتب',
	'coll-bookscategory' => 'كتب',
	'coll-savedbook_template' => 'كتاب_محفوظ',
	'coll-your_book' => 'كتابك',
	'coll-download_title' => 'حمل المجموعة على PDF',
	'coll-download_text' => 'لتحميل ملف PDF مولد تلقائى من مجموعة صفحتك، اضغط زر.',
	'coll-download_as_text' => 'عشان تنزل نسخة بصيغة $1 دوس ع الزرار.',
	'coll-download' => 'تحميل',
	'coll-format_label' => 'الصيغة:',
	'coll-remove' => 'إزالة',
	'coll-show' => 'اعرض',
	'coll-move_to_top' => 'حرك لفوق',
	'coll-move_up' => 'حرك لفوق',
	'coll-move_down' => 'حرك إلى الأسفل قليلا',
	'coll-move_to_bottom' => 'حرك إلى الأسفل',
	'coll-title' => 'العنوان:',
	'coll-subtitle' => 'العنوان الفرعي:',
	'coll-contents' => 'محتويات',
	'coll-drag_and_drop' => 'استخدم جر و  لزق لإعادة ترتيب مواد و فصول الويكى',
	'coll-create_chapter' => 'ابتدى فرع جديد',
	'coll-sort_alphabetically' => 'تصنيف أبجدى للصفحات',
	'coll-clear_collection' => 'فضى الكتاب',
	'coll-clear_collection_confirm' => 'انتا بجد عايز تفضى الكتاب بالكامل؟',
	'coll-rename' => 'إعادة تسمية',
	'coll-new_chapter' => 'أدخل الاسم للفرع الجديد',
	'coll-rename_chapter' => 'أدخل الاسم الجديد للفرع',
	'coll-no_such_category' => 'لا تصنيف كهذا',
	'coll-notitle_title' => 'عنوان الصفحة لم يمكن تحديده.',
	'coll-post_failed_title' => 'طلب POST فشل',
	'coll-post_failed_msg' => 'طلب POST إلى $1 فشل ($2).',
	'coll-mwserve_failed_title' => 'خطأ عرض من الخادم',
	'coll-mwserve_failed_msg' => 'حدث خطأ فى خادم العرض: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'خطأ استجابة من الخادم',
	'coll-empty_collection' => 'كتاب فاضى',
	'coll-revision' => 'النسخة: $1',
	'coll-save_collection_title' => 'احفظ وشارك بالكتاب بتاعك',
	'coll-save_collection_text' => 'لحفظ المجموعة للاستخدام المستقبلي، اختار نوع مجموعة ودخل عنوان صفحة:',
	'coll-login_to_save' => 'لو كنت عايز تحفظ الكتب عشان تستعملها قدام،لو سمحت [[Special:UserLogin|تسجل دخولك او تفتحلك حساب]].',
	'coll-personal_collection_label' => 'كتاب شخصى:',
	'coll-community_collection_label' => 'كتاب مجتمع:',
	'coll-save_collection' => 'حفظ الكتاب',
	'coll-save_category' => 'كل الكتب بتتسيف فى التصنيف [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'الصفحة موجودة.
كتابة عليها؟',
	'coll-overwrite_text' => 'صفحة بنفس الاسم [[:$1]] موجودة بالفعل.
هل تريد استبدالها بمجموعتك؟',
	'coll-yes' => 'نعم',
	'coll-no' => 'لا',
	'coll-load_overwrite_text' => 'انتا عندك بالفعل شوية صفحات فى الكتاب بتاعك.
انتا عايز تكتب فوق الكتاب الحالى ، تضيف محتوى جديد ، و لا تلغى تحميل الكتاب دا ؟',
	'coll-overwrite' => 'كتابة عليها',
	'coll-append' => 'انتظار',
	'coll-cancel' => 'إلغاء',
	'coll-update' => 'تحديث',
	'coll-limit_exceeded_title' => 'الكتاب اكبر م اللازم',
	'coll-limit_exceeded_text' => 'الكتاب بتاعك اكبر م اللازم.
ما ينفعش تضيف اى صفحات زياده.',
	'coll-rendering_title' => 'عرض',
	'coll-rendering_text' => "'''من فضلك استنى  توليد الوثيقة.'''

'''التقدم:''' $1% $2

الصفحه دى لازم تتحدث كل عدة ثوان.
لو ده لا يعمل، من فضلك اضغط زر التحديث فى متصفحك.",
	'coll-rendering_status' => '<strong>الحالة:</strong> $1',
	'coll-rendering_article' => '(المقالة: $1)',
	'coll-rendering_page' => '(الصفحة: $1)',
	'coll-rendering_finished_title' => 'العرض انتهى',
	'coll-rendering_finished_text' => '<strong>ملف الوثيقة تم توليده.</strong>
<strong>[$1 اضغط هنا]</strong> لتنزيله للكمبيوتر بتاعك.

ملاحظات:
* مش راضى على النتيجه؟ بص  [[{{MediaWiki:Coll-helppage}}|صفحة المساعدة عن المجموعات]] للاحتمالات لتحسينه.',
	'coll-notfound_title' => 'الكتاب مالوش وجود',
	'coll-notfound_text' => 'ماقدرناش نلاقى صفحة الكتاب.',
	'coll-is_cached' => '<ul><li>نسخة مخزنة من الوثيقة تم العثور عليها، لذا لا تحديث كان ضروريا. <a href="$1">إجبار على إعادة التحديث.</a></li></ul>',
	'coll-excluded-templates' => '* القوالب فى التصنيف [[:Category:$1|$1]] تم إقصاؤها.',
	'coll-blacklisted-templates' => '* القوالب فى القائمة السوداء [[:$1]] تم إقصاؤها.',
	'coll-return_to_collection' => '<p>ارجع إلى <a href="$1">$2</a></p>',
	'coll-book_title' => 'اطلب كتاب مطبوع',
	'coll-book_text' => 'ممكن طلب كتاب مطبوع يحتوى على مجموعة صفحاتك بواسطة زيارة واحد من شركاء الطباعة عند الطلب الجاى:',
	'coll-order_from_pp' => 'طلب كتاب من $1',
	'coll-about_pp' => 'حول $1',
	'coll-invalid_podpartner_title' => 'شريك POD غير صحيح',
	'coll-invalid_podpartner_msg' => 'شريك POD الموفر غير صحيح.
من فضلك اتصل بإدارى ميدياويكى الخاص بك.',
	'coll-license' => 'ترخيص',
	'coll-return_to' => 'رجوع إلى [[:$1]]',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'coll-collection' => 'Coleición',
	'coll-collections' => 'Coleiciones',
	'coll-create_a_book' => 'Crear un llibru',
	'coll-add_page' => 'Añader páxina wiki',
	'coll-remove_page' => 'Eliminar páxina wiki',
	'coll-add_category' => 'Añader categoría',
	'coll-load_collection' => 'Cargar coleición',
	'coll-show_collection' => 'Amosar coleición',
	'coll-help_collections' => 'Aida de les coleiciones',
	'coll-n_pages' => '$1 {{PLURAL:$1|páxina|páxines}}',
	'coll-download_as' => 'Descargar como $1',
	'coll-helppage' => 'Aida:Coleiciones',
	'coll-download_title' => 'Descargar coleición',
	'coll-download' => 'Descargar',
	'coll-format_label' => 'Formatu:',
	'coll-remove' => 'Eliminar',
	'coll-title' => 'Títulu:',
	'coll-subtitle' => 'Subtítulu:',
	'coll-create_chapter' => 'Crear capítulu nuevu',
	'coll-sort_alphabetically' => 'Ordenar páxines alfabéticamente',
	'coll-rename' => 'Renomar',
	'coll-yes' => 'Sí',
	'coll-no' => 'Non',
	'coll-about_pp' => 'Tocante a $1',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'coll-desc' => '[[Special:Book|Стварэньне кніг]]',
	'coll-collection' => 'Кніга',
	'coll-collections' => 'Кнігі',
	'coll-exclusion_category_title' => 'Выключэньні з друку',
	'coll-print_template_prefix' => 'Друк',
	'coll-print_template_pattern' => '$1/Для друку',
	'coll-create_a_book' => 'Стварыць кнігу',
	'coll-add_page' => 'Дадаць вікі-старонку',
	'coll-add_page_tooltip' => 'Дадаць цяперашнюю вікі-старонку ў Вашую кнігу',
	'coll-remove_page' => 'Выдаліць вікі-старонку',
	'coll-remove_page_tooltip' => 'Выдаліць цяперашнюю вікі-старонку з Вашай кнігі',
	'coll-add_category' => 'Дадаць катэгорыю',
	'coll-add_category_tooltip' => 'Дадаць усе старонкі з гэтай катэгорыі ў Вашую кнігу',
	'coll-load_collection' => 'Загрузіць кнігу',
	'coll-load_collection_tooltip' => 'Загрузіць гэтую кнігу як Вашую цяперашнюю кнігу',
	'coll-show_collection' => 'Паказаць кнігу',
	'coll-show_collection_tooltip' => 'Націсьніце для рэдагаваньня/загрузкі/заказу Вашай кнігі',
	'coll-help_collections' => 'Даведка пра кнігі',
	'coll-help_collections_tooltip' => 'Паказаць даведку пра інструмэнты стварэньня кніг',
	'coll-n_pages' => '$1 {{PLURAL:$1|старонка|старонкі|старонак}}',
	'coll-unknown_subpage_title' => 'Невядомая падстаронка',
	'coll-unknown_subpage_text' => 'Гэтай падстаронкі [[Special:Book|кнігі]] не існуе',
	'coll-printable_version_pdf' => 'PDF-вэрсія',
	'coll-download_as' => 'Загрузіць як $1',
	'coll-noscript_text' => '<h1>Патрэбны JavaScript!</h1>
<strong>Ваш браўзэр не падтрымлівае JavaScript альбо падтрымка JavaScript была адключаная.
Гэтая старонка ня будзе працаваць правільна, калі JavaScript адключаны.</strong>',
	'coll-intro_text' => 'Стварэньне і кіраваньне Вашай індывідуальнай калекцыяй вікі-старонак. <br />Падрабязнасьці глядзіце на [[{{MediaWiki:Coll-helppage}}]].',
	'coll-helppage' => 'Help:Кнігі',
	'coll-bookscategory' => 'Кнігі',
	'coll-savedbook_template' => 'захаваныя_кнігі',
	'coll-your_book' => 'Ваша кніга',
	'coll-download_title' => 'Загрузіць',
	'coll-download_text' => 'Каб загрузіць аўтаномную вэрсію, выберыце фармат і націсьніце кнопку.',
	'coll-download_as_text' => 'Націсьніце кнопку, каб загрузіць вэрсію ў фармаце $1.',
	'coll-download' => 'Загрузіць',
	'coll-format_label' => 'Фармат:',
	'coll-remove' => 'Выдаліць',
	'coll-show' => 'Паказаць',
	'coll-move_to_top' => 'Перанесьці ўверх',
	'coll-move_up' => 'Перанесьці вышэй',
	'coll-move_down' => 'Перанесьці ніжэй',
	'coll-move_to_bottom' => 'Перанесьці ўніз',
	'coll-title' => 'Назва:',
	'coll-subtitle' => 'Падзагаловак:',
	'coll-contents' => 'Зьмест',
	'coll-drag_and_drop' => 'Карыстайся мышкай, каб зьмяніць пасьлядоўнасьць вікі-старонак і разьдзелаў',
	'coll-create_chapter' => 'Стварыць разьдзел',
	'coll-sort_alphabetically' => 'Сартаваць па альфабэце',
	'coll-clear_collection' => 'Ачысьціць кнігу',
	'coll-clear_collection_tooltip' => 'Выдаліць усе старонкі з Вашай цяперашняй кнігі',
	'coll-clear_collection_confirm' => 'Вы сапраўды жадаеце поўнасьцю ачысьціць Вашую кнігу?',
	'coll-rename' => 'Перайменаваць',
	'coll-new_chapter' => 'Увядзіце назву для новага разьдзелу',
	'coll-rename_chapter' => 'Увядзіце новую назву разьдзелу',
	'coll-no_such_category' => 'Няма такой катэгорыі',
	'coll-notitle_title' => 'Назва старонкі ня можа быць вызначана.',
	'coll-post_failed_title' => 'POST-запыт ня выкананы',
	'coll-post_failed_msg' => 'POST-запыт да $1 ня выкананы ($2).',
	'coll-mwserve_failed_title' => 'Памылка сэрвэра адлюстраваньня',
	'coll-mwserve_failed_msg' => 'На сэрвэры адлюстраваньня ўзьнікла памылка: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Памылка адказу сэрвэра',
	'coll-empty_collection' => 'Пустая кніга',
	'coll-revision' => 'Вэрсія: $1',
	'coll-save_collection_title' => 'Захаваць Вашую кнігу і адкрыць да яе доступ',
	'coll-save_collection_text' => 'Выберыце месцазнаходжаньне:',
	'coll-login_to_save' => 'Калі Вы жадаеце захаваць кнігу для далейшага карыстаньня, калі ласка, [[Special:UserLogin|увайдзіце ў сыстэму альбо стварыце рахунак]].',
	'coll-personal_collection_label' => 'Асабістая кніга:',
	'coll-community_collection_label' => 'Кніга супольнасьці:',
	'coll-save_collection' => 'Захаваць кнігу',
	'coll-save_category' => 'Кнігі захаваныя ў катэгорыі [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Старонка ўжо існуе. 
Перазапісаць?',
	'coll-overwrite_text' => 'Старонка з назвай [[:$1]] ужо існуе.
Вы жадаеце, каб яна была перазапісана Вашай калекцыяй?',
	'coll-yes' => 'Так',
	'coll-no' => 'Не',
	'coll-load_overwrite_text' => 'У Вашай кнізе ўжо існуе некалькі старонак.
Вы жадаеце перазапісаць Вашу цяперашнюю кнігу, дадаць новы зьмест альбо адмяніць загрузку гэтай кнігі?',
	'coll-overwrite' => 'Перазапісаць',
	'coll-append' => 'Дадаць',
	'coll-cancel' => 'Адмяніць',
	'coll-update' => 'Абнавіць',
	'coll-limit_exceeded_title' => 'Кніга занадта вялікая',
	'coll-limit_exceeded_text' => 'Ваша кніга занадта вялікая.
Да яе болей немагчыма дадаваць старонкі.',
	'coll-rendering_title' => 'Адлюстраваньне',
	'coll-rendering_text' => '<p><strong>Пачакайце, пакуль ствараецца дакумэнт.</strong></p>

<p><strong>Прагрэс:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Гэта старонка павінна аўтаматычна абнаўляцца кожныя некалькі сэкундаў.
Калі гэтага не адбываецца, калі ласка, націсьніце кнопку «Абнавіць» у Вашым браўзэры.</p>',
	'coll-rendering_status' => '<strong>Статус:</strong> $1',
	'coll-rendering_article' => '(вікі-старонка: $1)',
	'coll-rendering_page' => '(старонка: $1)',
	'coll-rendering_finished_title' => 'Адлюстраваньне скончана',
	'coll-rendering_finished_text' => '<strong>Файл дакумэнту быў створаны.</strong>
<strong>[$1 Загрузіць файл]</strong> на Ваш кампутар.

Заўвага:
* Не задаволены створаным дакумэнтам? Глядзіце [[{{MediaWiki:Coll-helppage}}|старонку дапамогі па калекцыі]], каб даведацца, як яго палепшыць.',
	'coll-notfound_title' => 'Кніга ня знойдзеная',
	'coll-notfound_text' => 'Немагчыма знайсьці старонку кнігі.',
	'coll-is_cached' => '<ul><li>Была знойдзеная кэшаваная вэрсія гэтага дакумэнта, таму перамалёўка не спатрэбілася. <a href="$1">Запусьціць прымусовую перамалёўку.</a></li></ul>',
	'coll-excluded-templates' => '* Шаблёны ў катэгорыі [[:Category:$1|$1]] былі выключаны.',
	'coll-blacklisted-templates' => '* Шаблёны ў чорным сьпісе [[:$1]] былі выключаны.',
	'coll-return_to_collection' => '<p>Вярнуцца да <a href="$1">$2</a></p>',
	'coll-book_title' => 'Замовіць як друкаваную кнігу',
	'coll-book_text' => 'Атрымаць друкаваную кнігу ад нашага партнэра, які займаецца паслугамі друкаваньня па замове:',
	'coll-order_from_pp' => 'Замовіць кнігу ў $1',
	'coll-about_pp' => 'Пра $1',
	'coll-invalid_podpartner_title' => 'Нядзейны партнэр, які друкуе па замове',
	'coll-invalid_podpartner_msg' => 'Выбраны партнэр, які друкуе па замове, нядзейны.
Калі ласка, зьвяжыцеся з Вашым адміністратарам MediaWiki.',
	'coll-license' => 'Ліцэнзія',
	'coll-return_to' => 'Вярнуцца да [[:$1]]',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'coll-desc' => 'Добавя възможност за [[Special:Collection|събиране на страници]] и преобразуването им в PDF',
	'coll-print_template_prefix' => 'Отпечатване',
	'coll-add_page' => 'Добавяне на уики-страница',
	'coll-remove_page' => 'Премахване на уики-страница',
	'coll-add_category' => 'Добавяне на категория',
	'coll-n_pages' => '$1 {{PLURAL:$1|страница|страници}}',
	'coll-printable_version_pdf' => 'PDF версия',
	'coll-download_as' => 'Изтегляне като $1',
	'coll-noscript_text' => '<h1>Изисква се Джаваскрипт!</h1>
<strong>Използваният браузър не поддържа Джаваскрипт или поддръжката на Джаваскрипт е изключена.
Тази страница не може да работи правилно докато Джаваскриптът не бъде активиран.</strong>',
	'coll-download_title' => 'Изтегляне',
	'coll-download' => 'Изтегляне',
	'coll-format_label' => 'Формат:',
	'coll-remove' => 'Премахване',
	'coll-show' => 'Показване',
	'coll-move_to_top' => 'Преместване в началото',
	'coll-move_up' => 'Преместване нагоре',
	'coll-move_down' => 'Преместване надолу',
	'coll-move_to_bottom' => 'Преместване в края',
	'coll-title' => 'Заглавие:',
	'coll-subtitle' => 'Подзаглавие:',
	'coll-contents' => 'Съдържание',
	'coll-sort_alphabetically' => 'Подреждане по азбучен ред',
	'coll-rename' => 'Преименуване',
	'coll-no_such_category' => 'Няма такава категория',
	'coll-revision' => 'Версия: $1',
	'coll-save_collection_title' => 'Съхраняване и споделяне',
	'coll-save_collection' => 'Съхраняване',
	'coll-overwrite_title' => 'Страницата съществува. Заместване?',
	'coll-yes' => 'Да',
	'coll-no' => 'Не',
	'coll-overwrite' => 'Заместване',
	'coll-append' => 'Добавяне',
	'coll-cancel' => 'Отказване',
	'coll-update' => 'Актуализиране',
	'coll-rendering_status' => '<strong>Статут:</strong> $1',
	'coll-rendering_article' => '(уики-страница: $1)',
	'coll-rendering_page' => '(страница: $1)',
	'coll-excluded-templates' => '* Шаблоните в категория [[:Category:$1|$1]] бяха изключени.',
	'coll-return_to_collection' => '<p>Връщане към <a href="$1">$2</a></p>',
	'coll-order_from_pp' => 'Поръчване на книга от $1',
	'coll-about_pp' => 'За $1',
	'coll-license' => 'Лиценз',
	'coll-return_to' => 'Връщане към [[:$1]]',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'coll-desc' => '[[Special:Collection|Napravite knjige]]',
	'coll-collection' => 'Knjiga',
	'coll-collections' => 'Knjige',
	'coll-exclusion_category_title' => 'Isključivanja pri štampanju',
	'coll-print_template_prefix' => 'Štampanje',
	'coll-print_template_pattern' => '$1/Štampaj',
	'coll-create_a_book' => 'Napravi knjigu',
	'coll-add_page' => 'Dodaj wiki stranicu',
	'coll-add_page_tooltip' => 'Dodaj trenutnu wiki stranicu u Vašu knjigu',
	'coll-remove_page' => 'Ukloni wiki stranicu',
	'coll-remove_page_tooltip' => 'Ukloni trenutnu wiki stranicu iz Vaše knjige',
	'coll-add_category' => 'Dodaj kategoriju',
	'coll-add_category_tooltip' => 'Dodaj sve wiki članke iz ove kategorije u Vašu knjigu',
	'coll-load_collection' => 'Učitaj knjigu',
	'coll-load_collection_tooltip' => 'Učitaj ovu knjigu kao Vašu trenutnu knjigu',
	'coll-show_collection' => 'Prikaži knjigu',
	'coll-show_collection_tooltip' => 'Kliknite za uređivanje/download/naručivanje Vaše knjige',
	'coll-help_collections' => 'Pomoć pri knjigama',
	'coll-help_collections_tooltip' => 'Prikaži pomoć o ovom alatu za knjige',
	'coll-n_pages' => '$1 {{PLURAL:$1|stranica|stranice|stranica}}',
	'coll-unknown_subpage_title' => 'Nepoznata podstranica',
	'coll-unknown_subpage_text' => 'Ova podstranica [[Special:Book|knjige]] ne postoji',
	'coll-printable_version_pdf' => 'PDF verzija',
	'coll-download_as' => 'Učitaj kao $1',
	'coll-noscript_text' => '<h1>JavaScript je neophodan!</h1>
<strong>Vaš preglednik ne podržava JavaScript ili je JavaScript isključen.
Ova stranica se neće pravilno prikazati, sve dok se JavaScript ne omogući.</strong>',
	'coll-intro_text' => 'Napravite i uredite Vaš lični odabir wiki stranica.<br />Pogledajte [[{{MediaWiki:Coll-helppage}}]] za više informacija.',
	'coll-helppage' => 'Help:Knjige',
	'coll-bookscategory' => 'Knjige',
	'coll-savedbook_template' => 'spremljena_knjiga',
	'coll-your_book' => 'Vaša knjiga',
	'coll-download_title' => 'Učitavanje',
	'coll-download_text' => 'Da bi ste preuzeli offline verziju odaberite format i kliknite dugme.',
	'coll-download_as_text' => 'Da bi ste preuzeli vanmrežnu verziju u formatu $1 kliknite na dugme.',
	'coll-download' => 'Učitavanje',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Ukloni',
	'coll-show' => 'Prikaži',
	'coll-move_to_top' => 'Pomjeri na vrh',
	'coll-move_up' => 'Premjesti gore',
	'coll-move_down' => 'Premjesti dole',
	'coll-move_to_bottom' => 'Premjesti na dno',
	'coll-title' => 'Naslov:',
	'coll-subtitle' => 'Podnaslov:',
	'coll-contents' => 'Sadržaj',
	'coll-drag_and_drop' => 'Koristi mogućnost povuci-i-spusti za preuređenje wiki stranica i poglavlja',
	'coll-create_chapter' => 'Napravi poglavlje',
	'coll-sort_alphabetically' => 'Poredaj po abecedi',
	'coll-clear_collection' => 'Očisti knjigu',
	'coll-clear_collection_tooltip' => 'Ukloni sve wiki članke iz Vaše trenutne knjige',
	'coll-clear_collection_confirm' => 'Da li zaista želite da potpuno očistite Vašu knjigu?',
	'coll-rename' => 'Promijeni ime',
	'coll-new_chapter' => 'Unesi ime za novo poglavlje',
	'coll-rename_chapter' => 'Unesite novo ime za poglavlje',
	'coll-no_such_category' => 'Nema takve kategorije',
	'coll-notitle_title' => 'Naslov ove stranice nije mogao biti određen.',
	'coll-post_failed_title' => 'POST zahtjev nije uspio',
	'coll-post_failed_msg' => 'POST zahtjev za $1 nije uspio ($2).',
	'coll-mwserve_failed_title' => 'Serverska greška pri iscrtavanju',
	'coll-mwserve_failed_msg' => 'Desila se greška pri iscrtavanju na serveru: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Greška pri odgovoru sa servera',
	'coll-empty_collection' => 'Prazna knjiga',
	'coll-revision' => 'Revizija: $1',
	'coll-save_collection_title' => 'Spremanje i dijeljenje vlastite knjige',
	'coll-save_collection_text' => 'Odaberi lokaciju:',
	'coll-login_to_save' => 'Ako želite spremiti knjige za kasniju upotrebu molimo Vas [[Special:UserLogin|prijavite se ili napravite račun]].',
	'coll-personal_collection_label' => 'Lična knjiga:',
	'coll-community_collection_label' => 'Knjiga zajednice:',
	'coll-save_collection' => 'Sačuvaj knjigu',
	'coll-save_category' => 'Knjige su spremljene u kategoriju [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Stranica postoji.
Prepiši preko postojeće?',
	'coll-overwrite_text' => 'Stranica pod imenom [[:$1]] već postoji.
Da li želite da je zamijenite sa Vašom kolekcijom?',
	'coll-yes' => 'Da',
	'coll-no' => 'Ne',
	'coll-load_overwrite_text' => 'Već imate neke stranice u Vašoj knjizi.
Da li želite prepisati preko Vaše postojeće knjige, primjenite novi sadržaj ili odustanete od punjenja ove knjige?',
	'coll-overwrite' => 'Prepisati',
	'coll-append' => 'Prispoji',
	'coll-cancel' => 'Odustani',
	'coll-update' => 'Ažuriranje',
	'coll-limit_exceeded_title' => 'Knjiga prevelika',
	'coll-limit_exceeded_text' => 'Vaša knjiga je prevelika.
Ne može se dodati ni jedna stranica.',
	'coll-rendering_title' => 'Iscrtavanje',
	'coll-rendering_text' => '<p><strong>Molimo pričekajte dok se dokument generiše.</strong></p>

<p><strong>Izvršeno:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Ova stranica bi se trebala osvježiti svakih par sekundi.
Ukoliko se to ne desi, molimo kliknite dugme za osvježavanje u Vašem pregledniku.</p>',
	'coll-rendering_status' => '<strong>Stanje:</strong> $1',
	'coll-rendering_article' => '(wiki stranica: $1)',
	'coll-rendering_page' => '(stranica: $1)',
	'coll-rendering_finished_title' => 'Iscrtavanje završeno',
	'coll-rendering_finished_text' => '<strong>Datoteka dokumenta je generisana.</strong>
<strong>[$1 Spremite datoteku]</strong> na Vaš računar.

Napomene:
* Da li ste zadovoljni sa rezultatom? Pogledajte [[{{MediaWiki:Coll-helppage}}|stranicu pomoći kod kolekcija]] za moguća poboljšanja rezultata.',
	'coll-notfound_title' => 'Knjiga nije pronađena',
	'coll-notfound_text' => 'Nije moguće pronaći stranicu knjige.',
	'coll-is_cached' => '<ul><li>Pronađena je keširana verzija dokumenta, tako da je ponovno iscrtavanje nepotrebno. <a href="$1">Traži ponovno iscrtavanje.</a></li></ul>',
	'coll-excluded-templates' => '* Šabloni u kategoriji [[:Category:$1|$1]] su isključeni.',
	'coll-blacklisted-templates' => '* Šabloni sa spiska nepoželjnih [[:$1]] su isključeni.',
	'coll-return_to_collection' => '<p>Povratak na <a href="$1">$2</a></p>',
	'coll-book_title' => 'Naruči kao štampanu knjigu',
	'coll-book_text' => 'Preuzmite štampanu knjigu od našeg print-on-demand partnera:',
	'coll-order_from_pp' => 'Naruči knjigu od $1',
	'coll-about_pp' => 'O $1',
	'coll-invalid_podpartner_title' => 'POD partner nije validan',
	'coll-invalid_podpartner_msg' => 'Pruženi POD partner nije validan.
Molimo da kontaktirate Vašeg MediaWiki administratora.',
	'coll-license' => 'Licenca',
	'coll-return_to' => 'Vrati na [[:$1]]',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author SMP
 * @author Vriullop
 */
$messages['ca'] = array(
	'coll-desc' => '[[Special:Book|Crear llibres]]',
	'coll-collection' => 'Llibre',
	'coll-collections' => 'Llibres',
	'coll-exclusion_category_title' => 'Excloure en imprimir',
	'coll-print_template_prefix' => 'Imprimir',
	'coll-create_a_book' => 'Crear llibre',
	'coll-add_page' => 'Afegir pàgina wiki',
	'coll-remove_page' => 'Esborrar pàgina wiki',
	'coll-add_category' => 'Afegir categoria',
	'coll-load_collection' => 'Carregar llibre',
	'coll-show_collection' => 'Mostrar llibre',
	'coll-help_collections' => 'Ajuda (llibres)',
	'coll-n_pages' => '$1 {{PLURAL:$1|pàgina|pàgines}}',
	'coll-unknown_subpage_title' => 'Subpàgina desconeguda',
	'coll-unknown_subpage_text' => 'No existeix aquesta subpàgina de [[Special:Book|Llibre]]',
	'coll-printable_version_pdf' => 'Versió en PDF',
	'coll-download_as' => 'Descarregar com $1',
	'coll-noscript_text' => "<h1>Es necessita el JavaScript!</h1>
<strong>El vostre navegador no suporta el JavaScript o aquest hi està blocat.
Aquesta pàgina no funcionarà correctament si no el poseu o l'activeu.</strong>",
	'coll-intro_text' => 'Creeu i gestioneu la vostra selecció personal de pàgines wiki.<br />Vegeu [[{{MediaWiki:Coll-helppage}}]] per a més informació.',
	'coll-helppage' => 'Help:Llibres',
	'coll-bookscategory' => 'Llibres',
	'coll-your_book' => 'El vostre llibre',
	'coll-download_title' => 'Descarrega',
	'coll-download_text' => 'Per a descarregar una versió escull el format i clica el botó.',
	'coll-download_as_text' => 'Per a descarregar una versió en format $1 clica el botó.',
	'coll-download' => 'Descarregar',
	'coll-remove' => 'Eliminar',
	'coll-show' => 'Mostrar',
	'coll-move_to_top' => 'Moure al principi',
	'coll-move_up' => 'Pujar',
	'coll-move_down' => 'Baixar',
	'coll-move_to_bottom' => 'Moure al final',
	'coll-title' => 'Títol:',
	'coll-subtitle' => 'Subtítol:',
	'coll-contents' => 'Contingut',
	'coll-drag_and_drop' => 'Feu servir el mètode de drag and drop per reordenar les pàgines wiki i els capítols',
	'coll-create_chapter' => 'Crear un nou capítol',
	'coll-sort_alphabetically' => 'Ordena alfabèticament',
	'coll-clear_collection' => 'Buidar llibre',
	'coll-clear_collection_confirm' => 'Esteu segur de voler buidar el vostre llibre?',
	'coll-rename' => 'Reanomena',
	'coll-new_chapter' => 'Introduïu un nom per al nou capítol',
	'coll-rename_chapter' => 'Introduïu un nou nom per al capítol',
	'coll-no_such_category' => 'No existeix tal categoria',
	'coll-notitle_title' => "No s'ha pogut determinar el títol de la pàgina.",
	'coll-post_failed_title' => 'La petició POST ha fallat',
	'coll-post_failed_msg' => 'La petició POST a $1 ha fallat ($2).',
	'coll-mwserve_failed_title' => 'Error en el servidor de renderització',
	'coll-mwserve_failed_msg' => "S'ha produït un error al servidor de renderització: <nowiki>$1</nowiki>",
	'coll-error_reponse' => "Resposta d'error del servidor",
	'coll-empty_collection' => 'Llibre buit',
	'coll-revision' => 'Revisió: $1',
	'coll-save_collection_title' => 'Deseu i compartiu el vostre llibre',
	'coll-save_collection_text' => 'Escolliu on desar el vostre llibre:',
	'coll-login_to_save' => 'Si voleu desar un llibre per a ús posterior, si us plau [[Special:UserLogin|iniciï la sessió o crei un compte]]',
	'coll-personal_collection_label' => 'Llibre personal:',
	'coll-community_collection_label' => 'Llibre de la comunitat:',
	'coll-save_collection' => 'Desar llibre',
	'coll-save_category' => 'Tots els llibres queden desats en la categoria [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'La pàgina existeix. Voleu substituir-la?',
	'coll-overwrite_text' => 'Ja existeix una pàgina amb el mateix nom [[:$1]].
Voleu substituir-la amb el vostre llibre?',
	'coll-yes' => 'S&iacute;',
	'coll-no' => 'No',
	'coll-load_overwrite_text' => "Ja teniu algunes pàgines al vostre llibre.
Voleu sobreescriure el vostre llibre actual, annexar el nou contingut, o canceŀlar la càrrega d'aquest llibre?",
	'coll-overwrite' => 'Sobreescriu',
	'coll-append' => 'Annexar',
	'coll-cancel' => 'Canceŀla',
	'coll-update' => 'Actualitza',
	'coll-limit_exceeded_title' => 'Llibre massa gran',
	'coll-limit_exceeded_text' => 'El vostre llibre és massa gran.
No es poden afegir més pàgines.',
	'coll-rendering_title' => 'Renderització',
	'coll-rendering_text' => '<p><strong>Si us plau, esperi mentre es genera el document.</strong></p>

<p><strong>Progrés:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Aquesta pàgina es refresca cada pocs segons.
Si no és així, premi el botó de refresc del vostre navegador.</p>',
	'coll-rendering_status' => '<strong>Estat:</strong> $1',
	'coll-rendering_article' => '(pàgina wiki: $1)',
	'coll-rendering_page' => '(pàgina: $1)',
	'coll-rendering_finished_title' => 'Renderització finalitzada',
	'coll-rendering_finished_text' => "<strong>S'ha generat l'arxiu.</strong>
<strong>[$1 Descarregueu l'arxiu]</strong> al vostre ordinador.

Notes:
* No esteu satisfet amb el resultat? Vegeu [[{{MediaWiki:Coll-helppage}}|la pàgina d'ajuda sobre llibres]] per a conéixer més opcions per millorar-lo.",
	'coll-notfound_title' => 'Llibre no trobat',
	'coll-notfound_text' => "No s'ha pogut trobar la pàgina del llibre.",
	'coll-is_cached' => '<ul><li>S\'ha trobat una versió del document en la memòria cau i per tant no ha estat necessària cap renderització. <a href="$1">Forçar renderització.</a></li></ul>',
	'coll-excluded-templates' => "* No s'han inclós les plantilles de la categoria [[:Categoria:$1|$1]].",
	'coll-blacklisted-templates' => "* S'han exclòs les plantilles de la llista negra [[:$1]].",
	'coll-return_to_collection' => '<p>Tornar a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Encarregar llibre imprès',
	'coll-book_text' => "Obtenir el llibre imprès del nostre soci de peticions d'impressió:",
	'coll-order_from_pp' => 'Sol·licitar llibre a $1',
	'coll-about_pp' => 'Quant a $1',
	'coll-invalid_podpartner_title' => "Soci de peticions d'impressió no vàlid",
	'coll-invalid_podpartner_msg' => "El soci de peticions d'impressió indicat no és vàlid.
Si us plau, contacteu amb el vostre administrador de MediaWiki.",
	'coll-license' => 'Llicència',
	'coll-return_to' => 'Tornar a [[:$1]]',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'coll-desc' => '[[Special:Book|Vytváření knih]]',
	'coll-collection' => 'Kniha',
	'coll-collections' => 'Knihy',
	'coll-exclusion_category_title' => 'Netisknout',
	'coll-print_template_prefix' => 'Tisk',
	'coll-print_template_pattern' => '$1/Tisk',
	'coll-create_a_book' => 'Vytvořit knihu',
	'coll-add_page' => 'Přidat tuto stránku',
	'coll-remove_page' => 'Odebrat tuto stránku',
	'coll-add_category' => 'Přidat kategorii',
	'coll-load_collection' => 'Načíst knihu',
	'coll-show_collection' => 'Zobrazit knihu',
	'coll-help_collections' => 'Nápověda ke knihám',
	'coll-n_pages' => '$1 {{PLURAL:$1|stránka|stránky|stránek}}',
	'coll-unknown_subpage_title' => 'Neznámá podstránka',
	'coll-unknown_subpage_text' => 'Tato podstránka [[Special:Book|knihy]] neexistuje',
	'coll-printable_version_pdf' => 'PDF verze',
	'coll-download_as' => 'Stáhnout jako $1',
	'coll-noscript_text' => '<h1>Je vyžadován JavaScript!</h1>
<strong>Váš prohlížeč nepodporuje JavaScript nebo máte JavaScript vypnutý.
Tato stránka nebude správně fungovat, dokud JavaScript nezapnete.</strong>',
	'coll-intro_text' => 'Zde můžete vytvářet a spravovat své osobní výběry stránek wiki.<br />Další informace najdete v [[{{MediaWiki:Coll-helppage}}|nápovědě ke kolekcím]].',
	'coll-helppage' => 'Help:Knihy',
	'coll-bookscategory' => 'Knihy',
	'coll-savedbook_template' => 'uložená_kniha',
	'coll-your_book' => 'Vaše kniha',
	'coll-download_title' => 'Stáhnout',
	'coll-download_text' => 'Pokud si chcete stáhnout offline verzi, zvolte si formát a klikněte na tlačítko.',
	'coll-download_as_text' => 'Verzi ve formátu $1 si můžete stáhnout kliknutím na tlačítko.',
	'coll-download' => 'Stáhnout',
	'coll-format_label' => 'Formát:',
	'coll-remove' => 'Odstranit',
	'coll-show' => 'Zobrazit',
	'coll-move_to_top' => 'Přesunout nahoru',
	'coll-move_up' => 'Přesunout výše',
	'coll-move_down' => 'Přesunout níže',
	'coll-move_to_bottom' => 'Přesunout dolů',
	'coll-title' => 'Název:',
	'coll-subtitle' => 'Podtitul:',
	'coll-contents' => 'Obsah',
	'coll-drag_and_drop' => 'Pořadí článků a kapitol můžete změnit přetáhnutím myší',
	'coll-create_chapter' => 'Vytvořit kapitolu',
	'coll-sort_alphabetically' => 'Seřadit abecedně',
	'coll-clear_collection' => 'Vyčistit knihu',
	'coll-clear_collection_confirm' => 'Skutečně chcete úplně vyčistit tuto knihu?',
	'coll-rename' => 'Přejmenovat',
	'coll-new_chapter' => 'Zadejte název nové kapitoly',
	'coll-rename_chapter' => 'Zadejte nový název kapitoly',
	'coll-no_such_category' => 'Taková kategorie neexistuje',
	'coll-notitle_title' => 'Nebylo možné určit název stránky.',
	'coll-post_failed_title' => 'Chyba požadavku POST',
	'coll-post_failed_msg' => 'Chyba při požadavku POST na server $1 ($2).',
	'coll-mwserve_failed_title' => 'Chyba vykreslovacího serveru',
	'coll-mwserve_failed_msg' => 'Na vykreslovacím serveru došlo k chybě: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Chybná odpověď serveru',
	'coll-empty_collection' => 'Prázdná kniha',
	'coll-revision' => 'Revize: $1',
	'coll-save_collection_title' => 'Uložit a sdílet tuto knihu',
	'coll-save_collection_text' => 'Zvolte si umístění:',
	'coll-login_to_save' => 'Pokud chcete ukládat knihy pro pozdější použití, prosím, [[Special:UserLogin|přihlaste se nebo si vytvořte účet]].',
	'coll-personal_collection_label' => 'Osobní kniha:',
	'coll-community_collection_label' => 'Komunitní kniha:',
	'coll-save_collection' => 'Uložit knihu',
	'coll-save_category' => 'Knihy se ukládají do kategorie [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Stránka existuje. Přepsat?',
	'coll-overwrite_text' => 'Stránka s názvem [[:$1]] už existuje.
Chcete ji nahradit svojí kolekcí?',
	'coll-yes' => 'Ano',
	'coll-no' => 'Ne',
	'coll-load_overwrite_text' => 'Ve vaší knize se už nacházejí nějaké stránky.
Chcete přepsat svoji existující knihu, přidat do ní obsah nebo zrušit operaci s touto knihou?',
	'coll-overwrite' => 'Přepsat',
	'coll-append' => 'Přidat',
	'coll-cancel' => 'Zrušit',
	'coll-update' => 'Aktualizovat',
	'coll-limit_exceeded_title' => 'Kniha je příliš velká',
	'coll-limit_exceeded_text' => 'Vaše kniha je příliš velká.
Není možné přidat další stránky.',
	'coll-rendering_title' => 'Vykreslování',
	'coll-rendering_text' => '<p><strong>Prosím čekejte, dokument se připravuje.</strong></p>

<p><strong>Dokončeno:</strong> <span id="renderingProgress">$1</span> % <span id="renderingStatus">$2</span></p>

<p>Tato stránka se každých několik sekund automaticky obnoví.
Pokud to nefunguje, stiskněte v prohlížeči tlačítko <i>obnovit</i>.</p>',
	'coll-rendering_status' => '<strong>Stav:</strong> $1',
	'coll-rendering_article' => '(článek: $1)',
	'coll-rendering_page' => '(stránka: $1)',
	'coll-rendering_finished_title' => 'Vykreslování dokončeno',
	'coll-rendering_finished_text' => '<strong>Soubor s dokumentem byl vytvořen.</strong>
Můžete si ho <strong>[$1 stáhnout do svého počítače]</strong>.

Poznámky:
* Nejste spokojeni s výsledkem? Podívejte se na [[{{MediaWiki:Coll-helppage}}|stránku s nápovědou ke kolekcím]], jak ho vylepšit.',
	'coll-notfound_title' => 'Kniha nenalezena',
	'coll-notfound_text' => 'Nebylo možné najít stránku knihy.',
	'coll-is_cached' => '<ul><li>Byla nalezena cachovaná verze tohoto dokumentu, takže nebylo třeba vykreslovat. <a href="$1">Vynutit nové vykreslení.</a></li></ul>',
	'coll-excluded-templates' => '* Šablony v kategorii [[:Category:$1|$1]] byly vynechány.',
	'coll-blacklisted-templates' => '* Šablony na černé listině [[:$1]] byly vynechány.',
	'coll-return_to_collection' => '<p>Vrátit se na <a href="$1">$2</a></p>',
	'coll-book_title' => 'Objednat jako tištěnou knihu',
	'coll-book_text' => 'Od našeho partnera pro tisk na vyžádání můžete získat tištěnou knihu:',
	'coll-order_from_pp' => 'Objednat knihu od {{grammar:2sg|$1}}',
	'coll-about_pp' => 'O {{grammar:7sg|$1}}',
	'coll-invalid_podpartner_title' => 'Neplatný partner pro tisk na vyžádání',
	'coll-invalid_podpartner_msg' => 'Zvolený partner pro tisk na vyžádání není platný.
Kontaktujte svého správce MediaWiki.',
	'coll-license' => 'Licence',
	'coll-return_to' => 'Návrat na stránku „[[:$1]]“.',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'coll-title' => 'Titel:',
	'coll-yes' => 'Ja',
	'coll-no' => 'Nej',
	'coll-cancel' => 'Afbryd',
);

/** German (Deutsch)
 * @author Heuler06
 * @author Jbeigel
 * @author Melancholie
 * @author Metalhead64
 * @author Raimond Spekking
 * @author Revolus
 * @author Umherirrender
 * @author VolkerHaas
 */
$messages['de'] = array(
	'coll-desc' => '[[Special:Book|Erstelle Bücher]]',
	'coll-collection' => 'Buch',
	'coll-collections' => 'Bücher',
	'coll-exclusion_category_title' => 'Vom Druck ausschließen',
	'coll-print_template_prefix' => 'Drucken',
	'coll-print_template_pattern' => '$1/Druck',
	'coll-create_a_book' => 'Buch erstellen',
	'coll-add_page' => 'Wikiseite hinzufügen',
	'coll-add_page_tooltip' => 'Die aktuelle Wikiseite deinem Buch hinzufügen',
	'coll-remove_page' => 'Wikiseite entfernen',
	'coll-remove_page_tooltip' => 'Die aktuelle Wikiseite aus deinem Buch entfernen',
	'coll-add_category' => 'Kategorie hinzufügen',
	'coll-add_category_tooltip' => 'Alle Wikiseiten dieser Kategorie deinem Buch hinzufügen',
	'coll-load_collection' => 'Buch laden',
	'coll-load_collection_tooltip' => 'Dieses Buch als dein aktuelles Buch laden',
	'coll-show_collection' => 'Buch zeigen',
	'coll-show_collection_tooltip' => 'Klicken, um dein Buch zu bearbeiten/herunterzuladen/bestellen',
	'coll-help_collections' => 'Hilfe zu Büchern',
	'coll-help_collections_tooltip' => 'Hilfe über das Buchwerkzeug zeigen',
	'coll-n_pages' => '$1 {{PLURAL:$1|Wikiseite|Wikiseiten}}',
	'coll-unknown_subpage_title' => 'Unbekannte Unterseite',
	'coll-unknown_subpage_text' => 'Diese Unterseite von [[Special:Book|Buch]] existiert nicht',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-download_as' => 'Als $1 herunterladen',
	'coll-noscript_text' => '<h1>JavaScript wird benötigt!</h1>
<strong>Dein Browser unterstützt kein JavaScript oder JavaScript wurde deaktiviert.
Diese Seite wird nicht richtig funktionieren, solange JavaScript nicht verfügbar ist.</strong>',
	'coll-intro_text' => 'Erstelle und verwalte deine individuelle Sammlung von Wikiseiten.<br />Siehe die [[{{MediaWiki:Coll-helppage}}|Hilfe zu Büchern]] für weitere Informationen.',
	'coll-helppage' => 'Help:Bücher',
	'coll-bookscategory' => 'Bücher',
	'coll-savedbook_template' => 'Gespeichertes Buch',
	'coll-your_book' => 'Dein Buch',
	'coll-download_title' => 'Herunterladen',
	'coll-download_text' => 'Um eine Offline-Version herunterzuladen, wähle ein Format und klicke auf die Schaltfläche.',
	'coll-download_as_text' => 'Um eine Offline-Version im Format $1 herunterzuladen, klicke auf die Schaltfläche.',
	'coll-download' => 'Herunterladen',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Entfernen',
	'coll-show' => 'Zeigen',
	'coll-move_to_top' => 'an den Anfang',
	'coll-move_up' => 'hoch',
	'coll-move_down' => 'herunter',
	'coll-move_to_bottom' => 'an das Ende',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Untertitel:',
	'coll-contents' => 'Inhalt',
	'coll-drag_and_drop' => 'Mit der Maus kannst du Wikiseiten und Kapitel verschieben, um die Reihenfolge zu ändern',
	'coll-create_chapter' => 'Kapitel erzeugen',
	'coll-sort_alphabetically' => 'Alphabetisch sortieren',
	'coll-clear_collection' => 'Buch löschen',
	'coll-clear_collection_tooltip' => 'Alle Wikiseiten aus deinem aktuellen Buch entfernen',
	'coll-clear_collection_confirm' => 'Möchtest du wirklich dein Buch löschen?',
	'coll-rename' => 'Umbenennen',
	'coll-new_chapter' => 'Gib einen Namen für ein neues Kapitel ein',
	'coll-rename_chapter' => 'Gib einen neuen Namen für das Kapitel ein',
	'coll-no_such_category' => 'Kategorie nicht vorhanden',
	'coll-notitle_title' => 'Der Titel der Seite konnte nicht bestimmt werden.',
	'coll-post_failed_title' => 'POST-Anfrage fehlgeschlagen',
	'coll-post_failed_msg' => 'Die POST-Anfrage an $1 ist fehlgeschlagen ($2).',
	'coll-mwserve_failed_title' => 'Serverfehler',
	'coll-mwserve_failed_msg' => 'Auf dem Render-Server ist ein Fehler aufgetreten: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Fehlermeldung vom Server',
	'coll-empty_collection' => 'Leeres Buch',
	'coll-revision' => 'Version: $1',
	'coll-save_collection_title' => 'Dein Buch speichern und teilen',
	'coll-save_collection_text' => 'Wähle einen Speicherort für dein Buch:',
	'coll-login_to_save' => 'Wenn du Bücher speichern möchtest, [[Special:UserLogin|melde dich bitte an oder erstelle ein Benutzerkonto]].',
	'coll-personal_collection_label' => 'Persönliches Buch:',
	'coll-community_collection_label' => 'Gemeinschaftliches Buch:',
	'coll-save_collection' => 'Buch speichern',
	'coll-save_category' => 'Alle Bücher werden der Kategorie [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] zugeordnet.',
	'coll-overwrite_title' => 'Seite vorhanden, überschreiben?',
	'coll-overwrite_text' => 'Eine Seite mit dem Namen [[:$1]] ist bereits vorhanden. Möchtest du sie durch dein Buch ersetzen?',
	'coll-yes' => 'Ja',
	'coll-no' => 'Nein',
	'coll-load_overwrite_text' => 'Dein Buch enthält bereits Seiten.
Möchtest du das aktuelle Buch überschreiben, die neuen Seiten anhängen oder das Laden dieses Buches abbrechen?',
	'coll-overwrite' => 'Überschreiben',
	'coll-append' => 'Anhängen',
	'coll-cancel' => 'Abbrechen',
	'coll-update' => 'Aktualisieren',
	'coll-limit_exceeded_title' => 'Buch zu groß',
	'coll-limit_exceeded_text' => 'Dein Buch ist zu groß. Es können keine Seiten mehr hinzugefügt werden.',
	'coll-rendering_title' => 'Beim Erstellen',
	'coll-rendering_text' => '<p><strong>Bitte habe Geduld, während das Dokument erstellt wird.</strong></p>

<p><strong>Fortschritt:</strong> <span id="renderingProgress">$1</span> % <span id="renderingStatus">$2</span></p>

<p>Diese Seite sollte sich alle paar Sekunden von selbst aktualisieren.
Wenn das jedoch nicht geschieht, drücke bitte den „Aktualisieren“-Knopf (meist F5) deines Browsers.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(Wikiseite: $1)',
	'coll-rendering_page' => '(Seite: $1)',
	'coll-rendering_finished_title' => 'Fertig erstellt',
	'coll-rendering_finished_text' => '<strong>Die Datei wurde erfolgreich erstellt.</strong>
<strong>[$1 Dokument herunterladen]</strong>.

Hinweise:
* Bist du mit dem Ergebnis nicht zufrieden? Möglichkeiten zur Verbesserung der Ausgabe findest du auf der [[{{MediaWiki:Coll-helppage}}|Hilfeseite über Bücher]].',
	'coll-notfound_title' => 'Buch nicht gefunden',
	'coll-notfound_text' => 'Dein Buch konnte nicht gefunden werden.',
	'coll-is_cached' => '<ul><li>Es ist eine zwischengespeicherte Version des Dokumentes vorhanden, so dass kein Rendern notwendig war. <a href="$1">Neurendern erzwingen.</a></li></ul>',
	'coll-excluded-templates' => '* Vorlagen aus der Kategorie [[:Category:$1|$1]] wurden ausgeschlossen.',
	'coll-blacklisted-templates' => '* Vorlagen von der Schwarzen Liste [[:$1]] wurden ausgeschlossen.',
	'coll-return_to_collection' => 'Zurück zu <a href="$1">$2</a>',
	'coll-book_title' => 'Als gedrucktes Buch bestellen',
	'coll-book_text' => 'Bestelle eine gedruckte Buchausgabe bei unserem Print-on-Demand-Partner:',
	'coll-order_from_pp' => 'Buch bei $1 bestellen',
	'coll-about_pp' => 'Über $1',
	'coll-invalid_podpartner_title' => 'Ungültiger Print-on-Demand-Partner',
	'coll-invalid_podpartner_msg' => 'Die Angaben zum Print-on-Demand-Partner sind fehlerhaft. Bitte kontaktiere den MediaWiki-Administrator.',
	'coll-license' => 'Lizenz',
	'coll-return_to' => 'Zurück zu [[:$1]]',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author MichaelFrey
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'coll-add_page_tooltip' => 'Die aktuelle Wikiseite Ihrem Buch hinzufügen',
	'coll-remove_page_tooltip' => 'Die aktuelle Wikiseite aus Ihrem Buch entfernen',
	'coll-add_category_tooltip' => 'Alle Wikiseiten dieser Kategorie Ihrem Buch hinzufügen',
	'coll-load_collection_tooltip' => 'Dieses Buch als Ihr aktuelles Buch laden',
	'coll-show_collection_tooltip' => 'Klicken, um Ihr Buch zu bearbeiten/herunterzuladen/bestellen',
	'coll-noscript_text' => '<h1>JavaScript wird benötigt!</h1>
<strong>Ihr Browser unterstützt kein JavaScript oder JavaScript wurde deaktiviert.
Diese Seite wird nicht richtig funktionieren, solange JavaScript nicht verfügbar ist.</strong>',
	'coll-intro_text' => 'Erstellen und verwalten Sie Ihre individuelle Sammlung von Wikiseiten.<br />Siehe die [[{{MediaWiki:Coll-helppage}}|Hilfe zu Büchern]] für weitere Informationen.',
	'coll-your_book' => 'Ihr Buch',
	'coll-drag_and_drop' => 'Mit der Maus können Sie Wikiseiten und Kapitel verschieben, um die Reihenfolge zu ändern',
	'coll-clear_collection_tooltip' => 'Alle Wikiseiten aus Ihrem aktuellen Buch entfernen',
	'coll-clear_collection_confirm' => 'Möchten Sie wirklich Ihr Buch löschen?',
	'coll-new_chapter' => 'Geben Sie einen Namen für ein neues Kapitel ein',
	'coll-rename_chapter' => 'Geben Sie einen neuen Namen für das Kapitel ein',
	'coll-save_collection_title' => 'Ihr Buch speichern und teilen',
	'coll-save_collection_text' => 'Wählen Sie einen Speicherort für Ihr Buch:',
	'coll-login_to_save' => 'Wenn Sie Bücher speichern möchten, [[Special:UserLogin|melden Sie sich bitte an oder erstellen ein Benutzerkonto]].',
	'coll-overwrite_text' => 'Eine Seite mit dem Namen [[:$1]] ist bereits vorhanden. Möchten Sie diese durch Ihr Buch ersetzen?',
	'coll-load_overwrite_text' => 'Ihr Buch enthält bereits Seiten.
Möchten Sie das aktuelle Buch überschreiben, die neuen Seiten anhängen oder das Laden dieses Buches abbrechen?',
	'coll-limit_exceeded_text' => 'Ihr Buch ist zu groß. Es können keine Seiten mehr hinzugefügt werden.',
	'coll-rendering_text' => '<p><strong>Bitte haben Sie Geduld, während das Dokument erstellt wird.</strong></p>

<p><strong>Fortschritt:</strong> <span id="renderingProgress">$1</span> % <span id="renderingStatus">$2</span></p>

<p>Diese Seite sollte sich alle paar Sekunden von selbst aktualisieren.
Wenn das jedoch nicht geschieht, drücke bitte den „Aktualisieren“-Knopf (meist F5) Ihres Browsers.</p>',
	'coll-rendering_finished_text' => '<strong>Die Datei wurde erfolgreich erstellt.</strong>
<strong>[$1 Dokument herunterladen]</strong>.

Hinweise:
* Sind Sie mit dem Ergebnis nicht zufrieden? Möglichkeiten zur Verbesserung der Ausgabe finden Sie auf der [[{{MediaWiki:Coll-helppage}}|Hilfeseite über Bücher]].',
	'coll-notfound_text' => 'Ihr Buch konnte nicht gefunden werden.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'coll-desc' => '[[Special:Book|Knigły napóraś]]',
	'coll-collection' => 'Knigły',
	'coll-collections' => 'Knigły',
	'coll-exclusion_category_title' => 'Wót śišća wuzamknuś',
	'coll-print_template_prefix' => 'Śišćaś',
	'coll-print_template_pattern' => '$1/Śišćaś',
	'coll-create_a_book' => 'Knigły napóraś',
	'coll-add_page' => 'Wikijowy bok pśidaś',
	'coll-add_page_tooltip' => 'Aktualny wikibok twójim knigłam pśidaś',
	'coll-remove_page' => 'Wikijowy bok wótwónoźeś',
	'coll-remove_page_tooltip' => 'Aktualny wikibok z twójich knigłow wótpóraś',
	'coll-add_category' => 'Kategoriju pśidaś',
	'coll-add_category_tooltip' => 'Wšě nastawki w toś tej kategoriji twójim knigłam pśidaś',
	'coll-load_collection' => 'Knigły zacytaś',
	'coll-load_collection_tooltip' => 'Toś te knigły ako twóje aktualne knigły zacytaś',
	'coll-show_collection' => 'Knigły pokazaś',
	'coll-show_collection_tooltip' => 'Klikni, aby wobźěłał/ześěgnuł/skazał swóje knigły',
	'coll-help_collections' => 'Pomoc ku knigłam',
	'coll-help_collections_tooltip' => 'Pomoc wó funkciji knigłow pokazaś',
	'coll-n_pages' => '$1 {{PLURAL:$1|bok|boka|boki|bokow}}',
	'coll-unknown_subpage_title' => 'Njeznaty pódbok',
	'coll-unknown_subpage_text' => 'Toś ten pódbok [[Special:Book|knigłow]] njeeksistěrujo',
	'coll-printable_version_pdf' => 'PDF-wersija',
	'coll-download_as' => 'Ako $1 ześěgnuś',
	'coll-noscript_text' => '<h1>JavaScript jo trěbny!</h1>
<strong>Twój wobglědowak njepódpěrujo JavaScript abo JavaScript jo znjemóžnjony.
Toś ten bok njebuźo pšawje funkcioněrowaś, tak dłujko až JavaScript njejo zmóžnjony.</strong>',
	'coll-intro_text' => 'Napóraj a zastoj swój indiwiduelny wuběrk wikijowych bokow.<br />Glědaj [[{{MediaWiki:Coll-helppage}}]] ta dalšne informacije.',
	'coll-helppage' => 'Help:Knigły',
	'coll-bookscategory' => 'Knigły',
	'coll-savedbook_template' => 'składowane_knigły',
	'coll-your_book' => 'Twóje knigły',
	'coll-download_title' => 'Ześěgnuś',
	'coll-download_text' => 'Aby ześěgnuł wersiju offline, wubjeŕ format a klikni na tłocašk.',
	'coll-download_as_text' => 'Aby ześěgnuł wersiju offline w formaś $1, klikni na tłocašk.',
	'coll-download' => 'Ześěgnuś',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Wótwónoźeś',
	'coll-show' => 'Pokazaś',
	'coll-move_to_top' => 'Górjej',
	'coll-move_up' => 'Górjej',
	'coll-move_down' => 'Dołoj',
	'coll-move_to_bottom' => 'Dołoj',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Pódtitel:',
	'coll-contents' => 'Wopśimjeśe',
	'coll-drag_and_drop' => 'Pśesuni z myšku, aby pśerědował wikijowe boki a kapitle',
	'coll-create_chapter' => 'Kapitel napóraś',
	'coll-sort_alphabetically' => 'Alfabetiski sortěrowaś',
	'coll-clear_collection' => 'Knigły wuprozniś',
	'coll-clear_collection_tooltip' => 'Wše nastawki z twójich aktualnych knigłow wótpóraś',
	'coll-clear_collection_confirm' => 'Coš napšawdu swóje knigły dopołnje wuprozniś?',
	'coll-rename' => 'Pśemjeniś',
	'coll-new_chapter' => 'Zapódaj mě za nowy kapitel',
	'coll-rename_chapter' => 'Zapódaj nowe mě za kapitel',
	'coll-no_such_category' => 'Njejo taka kategorija',
	'coll-notitle_title' => 'Titel boka njejo se dał zwěsćiś.',
	'coll-post_failed_title' => 'POST-napšašanje jo se njeraźiło',
	'coll-post_failed_msg' => 'POST-napšašanje do $1 jo se njeraźiło ($2).',
	'coll-mwserve_failed_title' => 'Zmólka kresleńskego serwera',
	'coll-mwserve_failed_msg' => 'Na kresleńskem serwerje jo zmólka nastała: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Powěźeńka zmólki wót serwera',
	'coll-empty_collection' => 'Prozne knigły',
	'coll-revision' => 'Wersija: $1',
	'coll-save_collection_title' => 'Twóje knigły składowaś a źěliś',
	'coll-save_collection_text' => 'Wubjeŕ městno:',
	'coll-login_to_save' => 'Jolic coš knigły za póznjejše wužywanje składowaś, [[Special:UserLogin|pśizjaw se abo załož konto]].',
	'coll-personal_collection_label' => 'Wósobinske knigły:',
	'coll-community_collection_label' => 'Knigły zgromaźeństwa:',
	'coll-save_collection' => 'Knigły składowaś',
	'coll-save_category' => 'Knigły składuju se w kategoriji [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Bok eksistěrujo.
Pśepisaś?',
	'coll-overwrite_text' => 'Bok z mjenim [[:$1]] južo eksistěrujo.
Coš jen pśez swóju zběrku wuměniś?',
	'coll-yes' => 'Jo',
	'coll-no' => 'Ně',
	'coll-load_overwrite_text' => 'Maš južo někotare boki w swójich knigłach.
Coš swóje aktualne knigły pśepisaś, nowe wopśimjeśe pśipowjesyś abo zacytowanje toś tych knigłow pśetergnuś?',
	'coll-overwrite' => 'Pśepisaś',
	'coll-append' => 'Pśipowjesyś',
	'coll-cancel' => 'Pśetergnuś',
	'coll-update' => 'Aktualizěrowaś',
	'coll-limit_exceeded_title' => 'Knigły pśewjelike',
	'coll-limit_exceeded_text' => 'Twóje knigły su pśewjelike.
Njedaju se boki pśidaś.',
	'coll-rendering_title' => 'Kreslenje',
	'coll-rendering_text' => '<p><strong>Pšosym pócakaj, mjaztym až se dokument napórajo.</strong></p>

<p><strong>Póstup:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Toś ten bok by se dejał kuždy pór sekundow wótnowiś.
Jolic to njefunkcioněrujo, klikni pšosym tłocašk "Znowego" swójogo wobglědowaka.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wikijowy bok: $1)',
	'coll-rendering_page' => '(bok: $1)',
	'coll-rendering_finished_title' => 'Kreslenje dokóńcone',
	'coll-rendering_finished_text' => '<strong>Dokumentowa dataja jo se napórała.</strong>
<strong>[$1 Ześěgni dataju]</strong> do swójogo licadła.

Pśispomnjeśa:
* Njespokojom z wudaśim? Glědaj [[{{MediaWiki:Coll-helppage}}|bok pomocy wó zběrkach]] za móžnosći, jo  pólěpšyś.',
	'coll-notfound_title' => 'Knigły njenamakane',
	'coll-notfound_text' => 'Bok knigłow njejo se dał namakaś.',
	'coll-is_cached' => '<ul><li>Mjazyskładowana wersija dokumenta jo se namakała, tak až kreslenje njejo było trěbne. <a href="$1">Kreslenje wunuziś.</a></li></ul>',
	'coll-excluded-templates' => '* Pśedłogi w kategoriji [[:Category:$1|$1]] su se wuzamknuli.',
	'coll-blacklisted-templates' => '* Pśedłogi na cornej lisćinje [[:$1]] su se wuzamknuli.',
	'coll-return_to_collection' => '<p>Slědk k <a href="$1">$2</a></p>',
	'coll-book_title' => 'Ako wuśišćane knigły skazaś',
	'coll-book_text' => 'Wuśišćane knigły wót našogo parnera za śišć na pominanje skazaś:',
	'coll-order_from_pp' => 'Knigły wót $1 skazaś',
	'coll-about_pp' => 'Wó $1',
	'coll-invalid_podpartner_title' => 'Njepłaśiwy partner za śišć na pominanje',
	'coll-invalid_podpartner_msg' => 'Pódany partner za śišć na pominanje jo njepłaśiwy.
Skontaktuj pšosym swójogo administratora MediaWiki',
	'coll-license' => 'Licenca',
	'coll-return_to' => 'Slědk k [[:$1]]',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'coll-contents' => 'Emenyawo',
	'coll-notfound_title' => 'Womekpɔ agbalẽa o',
	'coll-license' => 'Mɔɖeɖe',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Geraki
 * @author Omnipaedista
 */
$messages['el'] = array(
	'coll-desc' => '[[Special:Book|Δημιουργία βιβλίων]]',
	'coll-collection' => 'Βιβλίο',
	'coll-collections' => 'Βιβλία',
	'coll-exclusion_category_title' => 'Εξαίρεση στην εκτύπωση',
	'coll-print_template_prefix' => 'Εκτύπωση',
	'coll-print_template_pattern' => '$1/Εκτύπωση',
	'coll-create_a_book' => 'Δημιουργία βιβλίου',
	'coll-add_page' => 'Προσθήκη σελίδας wiki',
	'coll-remove_page' => 'Αφαίρεση σελίδας wiki',
	'coll-add_category' => 'Προσθήκη κατηγορίας',
	'coll-load_collection' => 'Φόρτωση βιβλίου',
	'coll-show_collection' => 'Εμφάνιση βιβλίου',
	'coll-help_collections' => 'Βοήθεια βιβλίων',
	'coll-n_pages' => '$1 {{PLURAL:$1|σελίδα|σελίδες}}',
	'coll-unknown_subpage_title' => 'Άγνωστη υποσελίδα',
	'coll-unknown_subpage_text' => 'Αυτή η υποσελίδα [[Special:Book|Βιβλίου]] δεν υπάρχει',
	'coll-printable_version_pdf' => 'έκδοση PDF',
	'coll-download_as' => 'Κατέβασμα ως $1',
	'coll-noscript_text' => '<h1>Χρειάζεται JavaScript!</h1>
<strong>Ο περιηγητής σας δεν υποστηρίζει JavaScript ή η JavaScript έχει απενεργοποιηθεί.
Αυτή η σελίδα δεν θα λειτουργεί κανονικά, εκτός και αν ενεργοποιηθεί η JavaScript.</strong>',
	'coll-intro_text' => 'Δημιουργήστε και διαχειριστείτε την δική σας επιλογή σελίδων wiki.<br />Δείτε την [[{{MediaWiki:Coll-helppage}}|σελίδα βοήθειας για συλλογές]] για περισσότερες πληροφορίες.',
	'coll-helppage' => 'Help:Βιβλία',
	'coll-bookscategory' => 'Βιβλία',
	'coll-savedbook_template' => 'αποθηκευμένο_βιβλίο',
	'coll-your_book' => 'Το βιβλίο σας',
	'coll-download_title' => 'Κατέβασμα',
	'coll-download_text' => 'Για να κατεβάσετε μια έκδοση επιλέξτε την μορφή και πατήστε το κουμπί.',
	'coll-download_as_text' => 'Για να κατεβάσετε μια έκδοση σε μορφή $1 πατήστε το κουμπί.',
	'coll-download' => 'Κατέβασμα',
	'coll-format_label' => 'Μορφή:',
	'coll-remove' => 'Αφαίρεση',
	'coll-show' => 'Εμφάνιση',
	'coll-move_to_top' => 'Μετακίνηση στην κορυφή',
	'coll-move_up' => 'Μετακίνηση επάνω',
	'coll-move_down' => 'Μετακίνηση κάτω',
	'coll-move_to_bottom' => 'Μετακίνηση στον πάτο',
	'coll-title' => 'Τίτλος:',
	'coll-subtitle' => 'Υπότιτλος:',
	'coll-contents' => 'Περιεχόμενα',
	'coll-drag_and_drop' => 'Χρησιμοποιήστε drag & drop για να ταξινομήσετε σελίδες wiki και κεφάλαια',
	'coll-create_chapter' => 'Δημιουργία κεφαλαίου',
	'coll-sort_alphabetically' => 'Ταξινόμηση αλφαβητικά',
	'coll-clear_collection' => 'Εκκαθάριση βιβλίου',
	'coll-clear_collection_confirm' => 'Αλήθεια θέλετε να καθαρίσετε εντελώς το βιβλίο σας;',
	'coll-rename' => 'Μετονομασία',
	'coll-new_chapter' => 'Γράψτε όνομα για το νέο κεφάλαιο',
	'coll-rename_chapter' => 'Γράψτε νέο όνομα για το κεφάλαιο',
	'coll-no_such_category' => 'Δεν υπάρχει τέτοια κατηγορία',
	'coll-notitle_title' => 'Ο τίτλος της σελίδας δεν μπόρεσε να προσδιοριστεί.',
	'coll-post_failed_title' => 'Η αίτηση POST απέτυχε',
	'coll-post_failed_msg' => 'Το αίτημα POST στο  $1 απέτυχε ($2).',
	'coll-mwserve_failed_title' => 'Σφάλμα διακομιστή μορφοποίησης',
	'coll-mwserve_failed_msg' => 'Ένα σφάλμα συνέβη στον διακομιστή μορφοποίησης: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Σφάλμα απάντησης από τον διακομιστή',
	'coll-empty_collection' => 'Άδειο βιβλίο',
	'coll-revision' => 'Έκδοση: $1',
	'coll-save_collection_title' => 'Αποθήκευση και μοίρασμα του βιβλίου σας',
	'coll-save_collection_text' => 'Επιλογή μιας τοποθεσίας αποθήκευσης για το βιβλίο σας:',
	'coll-login_to_save' => 'Αν θέλετε να αποθηκεύσετε βιβλία για μεταγενέστερη χρήση, παρακαλούμε [[Special:UserLogin|συνδεθείτε ή δημιουργήστε ένα λογαριασμό]].',
	'coll-personal_collection_label' => 'Προσωπικό βιβλίο:',
	'coll-community_collection_label' => 'Κοινοτικό βιβλίο:',
	'coll-save_collection' => 'Αποθήκευση βιβλίου',
	'coll-save_category' => 'Όλα τα βιβλία αποθηκεύονται στην κατηγορία [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Η σελίδα υπάρχει.
Επικάλυψη;',
	'coll-overwrite_text' => 'Μια σελίδα με το όνομα [[:$1]] υπάρχει ήδη.
Θέλετε να αντικατασταθεί με το βιβλίο σας;',
	'coll-yes' => 'Ναι',
	'coll-no' => 'Όχι',
	'coll-load_overwrite_text' => 'Έχετε ήδη ορισμένες σελίδες στο βιβλίο σας.
Θέλετε να επικαλύψετε το τρέχον βιβλίο σας, να προσθέσετε νέο περιεχόμενο, ή να ακυρώσετε το φόρτωμα αυτού του βιβλίου;',
	'coll-overwrite' => 'Επικάλυψη',
	'coll-append' => 'Προσθήκη',
	'coll-cancel' => 'Ακύρωση',
	'coll-update' => 'Ενημέρωση',
	'coll-limit_exceeded_title' => 'Το βιβλίο είναι πολύ μεγάλο',
	'coll-limit_exceeded_text' => 'Το βιβλίο σας είναι πολύ μεγάλο.
Δεν μπορούν να προστεθούν άλλες σελίδες.',
	'coll-rendering_title' => 'Μορφοποίηση',
	'coll-rendering_text' => '<p><strong>Παρακαλούμε περιμένετε όσο το έγγραφό σας δημιουργείται.</strong></p>

<p><strong>Πρόοδος:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Αυτή η σελίδα θα πρέπει να ανανεώνεται αυτόματα κάθε λίγα δευτερόλεπτα. 
Αν δεν δουλεύει, παρακαλούμε πατήστε το κουμπί ανανέωσης στον περιηγητή σας.</p>',
	'coll-rendering_status' => '<strong>Πρόοδος:</strong> $1',
	'coll-rendering_article' => '(σελίδα wiki: $1)',
	'coll-rendering_page' => '(σελίδα: $1)',
	'coll-rendering_finished_title' => 'Η μορφοποίηση ολοκληρώθηκε',
	'coll-rendering_finished_text' => '<strong>Το αρχείο εγγράφου έχει δημιουργηθεί.</strong>
<strong>[$1 Κατεβάστε το αρχείο]</strong> στον υπολογιστή σας.

Σημειώσεις:
* Δεν είστε ικανοποιημένος με το αποτέλεσμα; Δείτε την [[{{MediaWiki:Coll-helppage}}|σελίδα βοήθειας για τα βιβλία]] για πιθανούς τρόπους να το βελτιώσετε.',
	'coll-notfound_title' => 'Το βιβλίο δεν βρέθηκε',
	'coll-notfound_text' => 'Δεν βρέθηκε η σελίδα βιβλίου.',
	'coll-is_cached' => '<ul><li>Μια αποθηκευμένη έκδοση του εγγράφου έχει βρεθεί, οπότε καμία μορφοποίηση δεν ήταν απαραίτητη. <a href="$1">Επιβολή επαναμορφοποίησης .</a></li></ul>',
	'coll-excluded-templates' => '* Πρότυπα στην κατηγορία [[:Category:$1|$1]] έχουν εξαιρεθεί.',
	'coll-blacklisted-templates' => '* Πρότυπα στην μαύρη λίστα [[:$1]] έχουν εξαιρεθεί.',
	'coll-return_to_collection' => '<p>Επιστροφή στο <a href="$1">$2</a></p>',
	'coll-book_title' => 'Παραγγελία ως εκτυπωμένο βιβλίο',
	'coll-book_text' => 'Πάρτε ένα τυπωμένο βιβλίο από τον συνεργάτη μας εκτύπωσης-κατά-παραγγελία:',
	'coll-order_from_pp' => 'Παραγγελία βιβλίου από το $1',
	'coll-about_pp' => 'Σχετικά με το $1',
	'coll-invalid_podpartner_title' => 'Ανύπαρκτος συνεργάτης ΕΚΠ',
	'coll-invalid_podpartner_msg' => 'Ο ζητούμενος συνεργάτης ΕΚΠ δεν υπάρχει.
Παρακαλούμε επικοινωνήστε με ένα διαχειριστή του MediaWiki.',
	'coll-license' => 'Άδεια',
	'coll-return_to' => 'Επιστροφή στο [[:$1]]',
);

/** Esperanto (Esperanto)
 * @author Amikeco
 * @author Yekrats
 */
$messages['eo'] = array(
	'coll-desc' => '[[Special:Book|Krei librojn]]',
	'coll-collection' => 'Libro',
	'coll-collections' => 'Libroj',
	'coll-exclusion_category_title' => 'Ekskludi de printado',
	'coll-print_template_prefix' => 'Printi',
	'coll-print_template_pattern' => '$1/Printi',
	'coll-create_a_book' => 'Krei libron',
	'coll-add_page' => 'Aldoni vikipaĝon',
	'coll-remove_page' => 'Forigi vikipaĝon',
	'coll-add_category' => 'Aldoni kategorion',
	'coll-load_collection' => 'Alŝuti libron',
	'coll-show_collection' => 'Montri libron',
	'coll-help_collections' => 'Helpo pri libroj',
	'coll-n_pages' => '$1 {{PLURAL:$1|paĝo|paĝoj}}',
	'coll-unknown_subpage_title' => 'Nekonata subpaĝo',
	'coll-unknown_subpage_text' => 'Ĉi tiu subpaĝo de [[Special:Book:Libro]] ne ekzistas',
	'coll-printable_version_pdf' => 'PDF-versio',
	'coll-download_as' => 'Elŝuti kiel $1',
	'coll-noscript_text' => '<h1>JavaScript-o estas deviga!<h1>
<strong>Via retumilo ne subtenas JavaScript-on aŭ JavaScript-o estis malŝaltita.
Ĉi tiu paĝo ne funkcius bone, ĝis JavaScript-o estas ŝaltita.</strong>',
	'coll-intro_text' => 'Krei kaj administri individuan selektaĵon de vikiaj paĝoj.<br />Vidu [[{{MediaWiki:Coll-helppage}}]] por plua informo.',
	'coll-helppage' => 'Help:Libroj',
	'coll-bookscategory' => 'Libroj',
	'coll-savedbook_template' => 'konservita_libro',
	'coll-your_book' => 'Via libro',
	'coll-download_title' => 'Elŝuti',
	'coll-download_text' => 'Por elŝuti malkonektan version, elektu formato kaj klaku la butonon.',
	'coll-download_as_text' => 'Por elŝuti version en formato $1, klaku la butonon.',
	'coll-download' => 'Elŝuto',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Forigi',
	'coll-show' => 'Montri',
	'coll-move_to_top' => 'Movi superen',
	'coll-move_up' => 'Movi supren',
	'coll-move_down' => 'Movi suben',
	'coll-move_to_bottom' => 'Movi malsuperen',
	'coll-title' => 'Titolo:',
	'coll-subtitle' => 'Subtitolo:',
	'coll-contents' => 'Enhavaĵoj',
	'coll-drag_and_drop' => 'Uzu musan tren-kaj-maltenon por reordigi vikiajn paĝojn kaj ĉapitrojn',
	'coll-create_chapter' => 'Krei ĉapitron',
	'coll-sort_alphabetically' => 'Ordigi laŭ alfabeto',
	'coll-clear_collection' => 'Forviŝi libron',
	'coll-clear_collection_confirm' => 'Ĉu vi ja volas plene forviŝi vian libron?',
	'coll-rename' => 'Alinomigi',
	'coll-new_chapter' => 'Enigi nomon por nova ĉapitro',
	'coll-rename_chapter' => 'Enigi novan nomon por ĉapitro',
	'coll-no_such_category' => 'Nenia kategorio',
	'coll-notitle_title' => 'La titolo de la paĝo ne estis determinebla.',
	'coll-post_failed_title' => 'POST-peto malsukcesis',
	'coll-post_failed_msg' => 'La POST-peto por $1 malsukcesis ($2).',
	'coll-mwserve_failed_title' => 'Eraro kun montrada servilo',
	'coll-mwserve_failed_msg' => 'Eraro okazis en la montrada servilo: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Erara respondo de servilo',
	'coll-empty_collection' => 'Malplena libro',
	'coll-revision' => 'Versio: $1',
	'coll-save_collection_title' => 'Konservi kaj permesigi vian libron',
	'coll-save_collection_text' => 'Elektu konservlokon por via libro:',
	'coll-login_to_save' => 'Se vi volas konservi librojn por posta uzo, bonvolu [[Special:UserLogin|ensaluti aŭ krei novan konton]].',
	'coll-personal_collection_label' => 'Propra libro:',
	'coll-community_collection_label' => 'Komuna libro:',
	'coll-save_collection' => 'Konservi libron',
	'coll-save_category' => 'Ĉiuj libroj estas konservitaj en la [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Paĝo ekzistas. Ĉu anstataŭigi?',
	'coll-overwrite_text' => 'Paĝo kun la nomo [[:$1]] jam ekzistas.
Ĉu vi volas anstatŭigi ĝin kun via kolekto?',
	'coll-yes' => 'Jes',
	'coll-no' => 'Ne',
	'coll-load_overwrite_text' => 'Vi jam havas iujn paĝojn en via libro.
Ĉu vi volas anstataŭigi vian nunan libron, aldoni la novan enhavon, aŭ nuligi ŝarĝadon de ĉi tiu libro?',
	'coll-overwrite' => 'Anstataŭigu',
	'coll-append' => 'Aldoni',
	'coll-cancel' => 'Nuligi',
	'coll-update' => 'Ĝisdatigi',
	'coll-limit_exceeded_title' => 'Libro tro granda',
	'coll-limit_exceeded_text' => 'Via libro estas tro granda.
Neniom da pliaj paĝoj estas aldoneblaj.',
	'coll-rendering_title' => 'Generante',
	'coll-rendering_text' => '<p><strong>Bonvolu atendi dum la dokumento generiĝis.</strong></p>

<p><strong>Progreso:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Ĉi tiu paĝo aŭtomatike refreŝigu kelksekunde.
Se ne funkcias, bonvolu klaki refreŝigo-butonon de via retumilo.</p>',
	'coll-rendering_status' => '<strong>Statuso:</strong> $1',
	'coll-rendering_article' => '(vikipaĝo: $1)',
	'coll-rendering_page' => '(paĝo: $1)',
	'coll-rendering_finished_title' => 'Generado finiĝis.',
	'coll-rendering_finished_text' => '<strong>La dokumento estis generita.</strong>
<strong>[$1 Elŝuti la dosieron]</strong> al via komputilo.

Notoj:
* Ĉu la eligo ne plaĉus al vi? Vidu [[{{MediaWiki:Coll-helppage}}|la helpan paĝon pri kolektoj]] por fojoj por plibonigi ĝin.',
	'coll-notfound_title' => 'Libro ne trovita',
	'coll-notfound_text' => 'Ne eblas trovi libran paĝon.',
	'coll-is_cached' => '<ul><li>Kaŝmemora versio de la dokumento estis trovita, tial bildigado ne bezonis.<a href="$1">Devigi re-bildigadon.</a></li></ul>',
	'coll-excluded-templates' => '* Ŝablonoj en kategorio [[:Category:$1|$1]] estis ekskluzivita.',
	'coll-blacklisted-templates' => '* Ŝablonoj en nigralisto [[:$1]] estis malebligitaj.',
	'coll-return_to_collection' => '<p>Reiru al <a href="$1">$2</a></p>',
	'coll-book_title' => 'Mendi kiel presitan libron',
	'coll-book_text' => 'Akiri presitan libron de nia ek-eldoneja partnero:',
	'coll-order_from_pp' => 'Mendi libron de $1',
	'coll-about_pp' => 'Pri $1',
	'coll-invalid_podpartner_title' => 'Nevalida ek-eldoneja partnero',
	'coll-invalid_podpartner_msg' => 'La donita ek-eldoneja partnero estas nevalida.
Bonvolu kontakti vian administranton de MediaWiki.',
	'coll-license' => 'Licenco',
	'coll-return_to' => 'Reiri al [[:$1]]',
);

/** Spanish (Español)
 * @author Baiji
 * @author Crazymadlover
 * @author Dferg
 * @author Imre
 * @author Jatrobat
 * @author Lin linao
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'coll-desc' => '[[Special:Book|Crear libros]]',
	'coll-collection' => 'Libro',
	'coll-collections' => 'Libros',
	'coll-exclusion_category_title' => 'Excluir al imprimir',
	'coll-print_template_prefix' => 'Imprimir',
	'coll-print_template_pattern' => '$1/Imprimir',
	'coll-create_a_book' => 'Crear un libro',
	'coll-add_page' => 'Añadir página wiki',
	'coll-remove_page' => 'Quitar página wiki',
	'coll-add_category' => 'Añadir categoría',
	'coll-load_collection' => 'Cargar libro',
	'coll-show_collection' => 'Mostrar libro',
	'coll-help_collections' => 'Ayuda de libros',
	'coll-n_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'coll-unknown_subpage_title' => 'Subpágina desconocida',
	'coll-unknown_subpage_text' => 'Esta subpágina del [[Special:Book|libro]] no existe',
	'coll-printable_version_pdf' => 'Versión PDF',
	'coll-download_as' => 'Descargar como $1',
	'coll-noscript_text' => '<h1>¡Se necesita JavaScript!</h1>
<strong>Tu navegador no permite JavaScript o está deshabilitado.
Esta página no funcionará correctamente mientras no esté habilitado.</strong>',
	'coll-intro_text' => 'Crear y gestionar tu selección individual de páginas wiki.<br />Lee [[{{MediaWiki:Coll-helppage}}]] para más información.',
	'coll-helppage' => 'Help:Libros',
	'coll-bookscategory' => 'Libros',
	'coll-savedbook_template' => 'libro_guardado',
	'coll-your_book' => 'Tu libro',
	'coll-download_title' => 'Descargar',
	'coll-download_text' => 'Para descargar una versión fuera de línea, elige un formato y pulsa el botón.',
	'coll-download_as_text' => 'Oprimir el botón para obtener una versión en formato $1.',
	'coll-download' => 'Descargar',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Quitar',
	'coll-show' => 'Mostrar',
	'coll-move_to_top' => 'Mover al principio',
	'coll-move_up' => 'Mover arriba',
	'coll-move_down' => 'Mover abajo',
	'coll-move_to_bottom' => 'Mover al final',
	'coll-title' => 'Título:',
	'coll-subtitle' => 'Subtítulo:',
	'coll-contents' => 'Contenidos',
	'coll-drag_and_drop' => "Usa arrastrar y soltar (''drag & drop'') para reordenar capítulos y páginas wiki",
	'coll-create_chapter' => 'Crear capítulo',
	'coll-sort_alphabetically' => 'Ordenar alfabéticamente',
	'coll-clear_collection' => 'Vaciar libro',
	'coll-clear_collection_confirm' => '¿Realmente quieres borrar completamente su libro?',
	'coll-rename' => 'Renombrar',
	'coll-new_chapter' => 'Introducir nombre del capítulo nuevo',
	'coll-rename_chapter' => 'Introducir un nombre nuevo para el capítulo',
	'coll-no_such_category' => 'No existe tal categoría',
	'coll-notitle_title' => 'No se puede determinar el título de la página.',
	'coll-post_failed_title' => 'Falló la solicitud POST',
	'coll-post_failed_msg' => 'La solicitud POST  a $1 ha fallado ($2).',
	'coll-mwserve_failed_title' => 'Error del servidor de procesado',
	'coll-mwserve_failed_msg' => 'Ha ocurrido un error en el servidor de procesado: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Respuesta de error del servidor',
	'coll-empty_collection' => 'libro vacío',
	'coll-revision' => 'Revisión: $1',
	'coll-save_collection_title' => 'Guardar y compartir tu libro',
	'coll-save_collection_text' => 'Escoger una localización:',
	'coll-login_to_save' => 'Si quieres guardar libros para uso posterior, por favor [[Special:UserLogin|identifícate o crea una cuenta]].',
	'coll-personal_collection_label' => 'libro personal:',
	'coll-community_collection_label' => 'libro de la comunidad:',
	'coll-save_collection' => 'Guardar libro',
	'coll-save_category' => 'Los libros están guardadas en la categoría [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'La página ya existe.
¿Sobreescribir?',
	'coll-overwrite_text' => 'Ya existe una página con el nombre [[:$1]].
¿Quieres reemplazarla con tu compilación?',
	'coll-yes' => 'Sí',
	'coll-no' => 'No',
	'coll-load_overwrite_text' => 'Ya tienes algunas páginas en tu libro.
¿Quieres sobreescribir tu libro actual, añadir el nuevo contenido o cancelar la carga de este libro?',
	'coll-overwrite' => 'Sobrescribir',
	'coll-append' => 'Anexar',
	'coll-cancel' => 'Cancelar',
	'coll-update' => 'Actualizar',
	'coll-limit_exceeded_title' => 'libro demasiado grande',
	'coll-limit_exceeded_text' => 'Tu libro de páginas es demasiado grande.
No se pueden añadir más páginas.',
	'coll-rendering_title' => 'Procesando',
	'coll-rendering_text' => '<p><strong>Por favos, espera mientras se genera el documento.</strong></p>

<p><strong>Avance:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Esta página se refrescará automáticamente cada pocos segundos.
Si no funciona, pulsa el botón de refrescar de tu navegador.</p>',
	'coll-rendering_status' => '<strong>Estatus:</strong> $1',
	'coll-rendering_article' => '(página wiki: $1)',
	'coll-rendering_page' => '(página: $1)',
	'coll-rendering_finished_title' => 'Proceso finalizado',
	'coll-rendering_finished_text' => '<strong>Se ha generado el documento.</strong>
<strong>[$1 Baja el archivo]</strong> a tu ordenador.

Notas:
* ¿No estás satisfecho con el resultado? Mira [[{{MediaWiki:Coll-helppage}}|la página de ayuda sobre compilaciones]] para ver las  posibilidades de mejorarlo.',
	'coll-notfound_title' => 'No se encuentra el libro',
	'coll-notfound_text' => 'No se encuentra la página de libro.',
	'coll-is_cached' => '<ul><li>Se ha encontrado una versión procesada del documento, por lo que no es necesario procesarlo. <a href="$1">Forzar reprocesado.</a></li></ul>',
	'coll-excluded-templates' => '* Se han excluido las plantillas de la categoría [[:Category:$1|$1]].',
	'coll-blacklisted-templates' => '* Se han excluido las plantillas [[:$1]] por estar en la lista negra.',
	'coll-return_to_collection' => '<p>Volver a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Solicitar el libro impreso',
	'coll-book_text' => 'Obtener un libro impreso de uno de nuestros socios para solicitudes de impresión:',
	'coll-order_from_pp' => 'Solicitar libro a $1',
	'coll-about_pp' => 'Acerca de $1',
	'coll-invalid_podpartner_title' => 'Socio de solicitudes de impresión (POD) no válido',
	'coll-invalid_podpartner_msg' => 'El socio para solicitudes de impresión (POD) indicado no es válido.
Por favor, contacta con tu administrador MediaWiki.',
	'coll-license' => 'Licencia',
	'coll-return_to' => 'Volver a [[:$1]].',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'coll-print_template_prefix' => 'Prindi',
	'coll-create_a_book' => 'Loo raamat',
	'coll-add_page' => 'Lisa wiki lehekülg',
	'coll-add_category' => 'Lisa kategooria',
	'coll-download' => 'Laadi alla',
	'coll-format_label' => 'Formaat:',
	'coll-remove' => 'Eemalda',
	'coll-show' => 'Näita',
	'coll-move_to_top' => 'Liiguta üles',
	'coll-title' => 'Pealkiri:',
	'coll-subtitle' => 'Alapealkiri:',
	'coll-sort_alphabetically' => 'Sorteeri tähestiku järjekorras',
	'coll-rename' => 'Nimeta ümber',
	'coll-no_such_category' => 'Sellist kategooriat ei ole',
	'coll-overwrite_title' => 'Lehekülg eksisteerib.
Kas kirjutada üle?',
	'coll-yes' => 'Jah',
	'coll-no' => 'Ei',
	'coll-overwrite' => 'Kirjuta üle',
	'coll-append' => 'Lisa',
	'coll-cancel' => 'Tühista',
	'coll-update' => 'Uuenda',
	'coll-license' => 'Litsents',
	'coll-return_to' => 'Naase [[:$1]]',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Theklan
 */
$messages['eu'] = array(
	'coll-desc' => '[[Special:Book|Liburuak sortu]]',
	'coll-collection' => 'Liburua',
	'coll-collections' => 'Liburuak',
	'coll-exclusion_category_title' => 'Inprimatzerakoan ez bildu',
	'coll-print_template_prefix' => 'Inprimatu',
	'coll-create_a_book' => 'Liburu bat sortu',
	'coll-add_page' => 'Wiki orrialdea gehitu',
	'coll-remove_page' => 'Wiki orrialdea ezabatu',
	'coll-add_category' => 'Kategoria gehitu',
	'coll-load_collection' => 'Liburua kargatu',
	'coll-show_collection' => 'Liburua erakutsi',
	'coll-help_collections' => 'Liburuen laguntza',
	'coll-n_pages' => '{{PLURAL:$1|Orrialde 1|$1 orrialde}}',
	'coll-unknown_subpage_title' => 'Azpiorrialde ezezaguna',
	'coll-unknown_subpage_text' => '[[Special:Book|Liburu]] honen azpiorrialde hau ez da existitzen',
	'coll-printable_version_pdf' => 'PDF bertsioa',
	'coll-download_as' => '$1 gisa jaitsi',
	'coll-noscript_text' => '<h1>JavaScript beharrezkoa da!</h1>
<strong>Zure nabigatzaileak ezin du JavaScripteduki edo JavaScript itzalita du.
Orrialde honek ez du egoki funtzionatuko JavaScript pizten ez den bitartean.</strong>',
	'coll-intro_text' => 'Sortu eta kudeatu wiki orrialdeen aukeraketa indibidueal bat. <br />Ikus [[{{MediaWiki:Coll-helppage}}]] informazio gehiagorako.',
	'coll-helppage' => 'Help:Liburuak',
	'coll-bookscategory' => 'Liburuak',
	'coll-savedbook_template' => 'gordetako_liburua',
	'coll-your_book' => 'Zure liburua',
	'coll-download_title' => 'Jaitsi',
	'coll-download_text' => 'Sarean ez dagoen bertsio bat jaisteko formatu bat aukeratu eta botoian klik egin.',
	'coll-download_as_text' => '$1 formatuan dagoen bertsioa jaisteko botoia sakatu',
	'coll-download' => 'Jaitsi',
	'coll-format_label' => 'Formatua:',
	'coll-remove' => 'Ezabatu',
	'coll-show' => 'Erakutsi',
	'coll-move_to_top' => 'Gora igo',
	'coll-move_up' => 'Gora igo',
	'coll-move_down' => 'Behera jaitsi',
	'coll-move_to_bottom' => 'Beheraino jaitsi',
	'coll-title' => 'Izenburua:',
	'coll-subtitle' => 'Azpititulua:',
	'coll-contents' => 'Edukiak',
	'coll-drag_and_drop' => 'Wiki orrialdeak eta atalak ordenatzeko drag & drop erabili',
	'coll-create_chapter' => 'Atala sortu',
	'coll-sort_alphabetically' => 'Alfabetikoki ordenatu',
	'coll-clear_collection' => 'Liburua ezabatu',
	'coll-clear_collection_confirm' => 'Benetan ezabatu nahi al duzu zure liburu osoa?',
	'coll-rename' => 'Izena aldatu',
	'coll-new_chapter' => 'Atal berriarentzat izena sartu',
	'coll-rename_chapter' => 'Atalarentzat izen berria sartu',
	'coll-no_such_category' => 'Ez dago horrelako atalik',
	'coll-notitle_title' => 'Orrialdearen izenburua ezin izan da determinatu.',
	'coll-post_failed_title' => 'POST eskariak huts egin du',
	'coll-post_failed_msg' => '$1(r)i eginiko POST eskariak huts eign du ($2).',
	'coll-mwserve_failed_title' => 'Render zerbitzariaren akatsa',
	'coll-mwserve_failed_msg' => 'Akats bat suertatu da render zerbitzarian: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Zerbitzariaren erantzun akatsa',
	'coll-empty_collection' => 'Liburu hutsa',
	'coll-revision' => 'Berrikuspena: $1',
	'coll-save_collection_title' => 'Gorde eta partekatu zure liburua',
	'coll-save_collection_text' => 'Kokapen bat aukeratu:',
	'coll-login_to_save' => 'Beranduago erabiltzeko liburuak gorde nahi badituzu erabil ezazu [[Special:UserLogin|saioa hasi edo kontua sortu]].',
	'coll-personal_collection_label' => 'Norberaren liburua:',
	'coll-community_collection_label' => 'Komunitatearen liburua:',
	'coll-save_collection' => 'Liburua gorde',
	'coll-save_category' => '[[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] kategorian gordetzen dira liburuak.',
	'coll-overwrite_title' => 'Orrialdea bada.
Gainetik idatzi?',
	'coll-overwrite_text' => '[[:$1]] izena duen orrialde bat badago dagoeneko.
Nahi al duzu zure bildumarekin aldatzea?',
	'coll-yes' => 'Bai',
	'coll-no' => 'Ez',
	'coll-load_overwrite_text' => 'Dagoeneko orri batzuk dituzu zure liburuan.
Nahi al duzu zure liburuaren gainetik idaztea, eduki berriak zerrendatzea edo liburu honen kargatzea ezeztatzea?',
	'coll-overwrite' => 'Gainetik idatzi',
	'coll-append' => 'Zerrendatu',
	'coll-cancel' => 'Ezeztatu',
	'coll-update' => 'Berritu',
	'coll-limit_exceeded_title' => 'Liburua handiegia da',
	'coll-limit_exceeded_text' => 'Zure liburua handiegia da.
Ezin dira orri gehiago gehitu.',
	'coll-rendering_title' => 'Renderizatzen',
	'coll-rendering_text' => '<p><strong>Itxoin dokumentua sortzen den artean, mesedez.</strong></p>

<p><strong>Garapena:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Orrialde hau automatikoki berrituko da segundu gutxiro.
Horrela ez bada zure nabigatzailean berritu botoiari eman.</p>',
	'coll-rendering_status' => '<strong>Egoera:</strong> $1',
	'coll-rendering_article' => '(wiki orrialdea: $1)',
	'coll-rendering_page' => '(orrialdea: $1)',
	'coll-rendering_finished_title' => 'Renderizazioa bukatu da',
	'coll-rendering_finished_text' => '<strong>Dokumentuaren fitxategia sortu da.</strong>
<strong>[$1 Jaitsi fitxategia]</strong> zure ordenagailuan.

Oharrak:
* Ez zaizu emaitza gustatu? Ikus [[{{MediaWiki:Coll-helppage}}|bildumen inguruko laguntza orrialdea]] berau hobetzeko aukerak ikusteko.',
	'coll-notfound_title' => 'Liburua ez da aurkitu',
	'coll-notfound_text' => 'Ezin izan da liburuko orria aurkitu.',
	'coll-is_cached' => '<ul><li>Katxean dokumentuaren bertsio bat aurktiu da, beraz renderizatzea ez da beharrezkoa izan. <a href="$1">Berriro renderizatzera derrigortu.</a></li></ul>',
	'coll-excluded-templates' => '* [[:Category:$1|$1]] kategorian dauden txantiloiak ez dira sartu.',
	'coll-blacklisted-templates' => '* [[:$1]] zerrenda beltzeko txantiloiak ez dira sartu.',
	'coll-return_to_collection' => '<p><a href="$1">$2</a>(e)ra itzuli</p>',
	'coll-book_title' => 'Inprimatutako liburu gisa eskatu',
	'coll-book_text' => 'Eska iezaiozu inprimatutako liburu bat gure eskatutakoa-inprimatu kideari:',
	'coll-order_from_pp' => '$1(e)tik liburua eskatu',
	'coll-about_pp' => '$1(r)i buruz',
	'coll-invalid_podpartner_title' => 'EI kide ez baliagarria',
	'coll-invalid_podpartner_msg' => 'Jarritako EI kidea ez da baliagarria.
Kontakta ezazu, mesedez MediaWiki administratzailea.',
	'coll-license' => 'Lizentzia',
	'coll-return_to' => '[[:$1]]era itzuli',
);

/** Persian (فارسی)
 * @author Huji
 * @author Komeil 4life
 * @author Spacebirdy
 */
$messages['fa'] = array(
	'coll-desc' => '[[Special:Book|ایجاد کتاب]]',
	'coll-collection' => 'کتاب',
	'coll-collections' => 'کتاب‌ها',
	'coll-exclusion_category_title' => 'صرف نظر در چاپ',
	'coll-print_template_prefix' => 'چاپ',
	'coll-create_a_book' => 'ایجاد کتاب',
	'coll-add_page' => 'افزودن این صفحه',
	'coll-remove_page' => 'حذف این صفحه',
	'coll-add_category' => 'اضافه کردن رده',
	'coll-load_collection' => 'بارکردن کتاب',
	'coll-show_collection' => 'نمایش کتاب',
	'coll-help_collections' => 'راهنمای کتاب‌ها',
	'coll-n_pages' => '$1 {{PLURAL:$1|صفحه|صفحه}}',
	'coll-unknown_subpage_title' => 'زیرصفحهٔ ناشناس',
	'coll-unknown_subpage_text' => 'این زیرصفحه از [[Special:Book|کتاب]] وجود ندارد',
	'coll-printable_version_pdf' => 'نسخهٔ پی‌دی‌اف',
	'coll-download_as' => 'بارگیری با عنوان $1',
	'coll-noscript_text' => '<h1>جاوااسکریپت لازم دارید!</h1>
<strong>مرورگر شما جاوا اسکریپت را پشتیبانی نمی‌کند یا جاوا اسکیریپت شما خاموش است.
این صفحه به طور صحیح عمل نخواهد کرد، مگر اینکه جاوااسکیریپت فعال شود.</strong>',
	'coll-intro_text' => 'صفحه‌های انتخابی خود از ویکی را ایجاد و مدیریت کنید.<br />برای کسب اطلاعات بیشتر [[{{MediaWiki:Coll-helppage}}]] را بخوانید.',
	'coll-helppage' => 'Help:کتاب‌ها',
	'coll-bookscategory' => 'کتاب‌ها',
	'coll-your_book' => 'کتاب شما',
	'coll-download_title' => 'دریافت',
	'coll-download_text' => 'برای بارگیری یک نسخهٔ غیر برخط یک قالب برگزینید و دکمه را بزنید.',
	'coll-download' => 'دریافت',
	'coll-format_label' => 'قالب:',
	'coll-remove' => 'حذف',
	'coll-show' => 'نمایش',
	'coll-move_to_top' => 'حرکت به ابتدا',
	'coll-move_up' => 'حرکت به بالا',
	'coll-move_down' => 'حرکت به پایین',
	'coll-move_to_bottom' => 'حرکت به انتها',
	'coll-title' => 'عنوان:',
	'coll-subtitle' => 'زیرعنوان:',
	'coll-contents' => 'مندرجات',
	'coll-drag_and_drop' => 'از کشیدن و رها کردن برای مرتب کردن صفحه‌های ویکی و فصل‌ها استفاده کنید',
	'coll-create_chapter' => 'ایجاد فصل',
	'coll-sort_alphabetically' => 'مرتب‌سازی الفبایی',
	'coll-clear_collection' => 'پاک کردن کتاب',
	'coll-clear_collection_confirm' => 'آیا واقعاً می‌خواهید که کتاب خود را به طور کامل پاک کنید؟',
	'coll-rename' => 'تغيير نام',
	'coll-new_chapter' => 'برای بخش جدید یک نام وارد کنید',
	'coll-rename_chapter' => 'برای بخش یک نام جدید وارد کنید',
	'coll-no_such_category' => 'چنین رده‌ای وجود ندارد',
	'coll-notitle_title' => 'عنوان صفحه قابل تشخیص نبود.',
	'coll-post_failed_title' => 'خطا در درخواست POST',
	'coll-post_failed_msg' => 'درخواست POST به $1 شکست خورد ($2).',
	'coll-mwserve_failed_title' => 'خطا در کارگزار ترجمه‌کننده',
	'coll-mwserve_failed_msg' => 'خطایی در کارگزار ترجمه‌کننده رخ داد: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'پیغام خطا از طرف کارگزار',
	'coll-empty_collection' => 'کتاب خالی',
	'coll-revision' => 'نسخه: $1',
	'coll-save_collection_title' => 'کتابتان را ذخیره کنید و به اشتراک بگذارید',
	'coll-save_collection_text' => 'انتخاب یک مکان:',
	'coll-login_to_save' => 'اگر می‌خواهید کتاب‌ها را برای کاربران بعدی ذخیره کنید، لطفا [[Special:UserLogin|به سیستم وارد شوید یا یک حساب کاربری بسازید]].',
	'coll-personal_collection_label' => 'کتاب شخصی:',
	'coll-community_collection_label' => 'کتاب عمومی:',
	'coll-save_collection' => 'ذخیره کردن کتاب',
	'coll-save_category' => 'کتاب‌ها در ردهٔ [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] ذخیره شده‌اند.',
	'coll-overwrite_title' => 'صفحه وجود دارد.
رونویسی شود؟',
	'coll-overwrite_text' => 'یک صفحه با نام [[:$1]] در حال حاضر موجود است.

آیا می‌خواهید این صفحه جایگزین صفحه موجود شود؟',
	'coll-yes' => 'بله',
	'coll-no' => 'خیر',
	'coll-load_overwrite_text' => 'شما همینک صفحه‌هایی در کتاب خود دارید.
آیا می‌خواهید کتاب فعلی را رونویسی کنید، محتوای جدید را به آن بیفزایید یا بارگیری این کتاب را متوقف کنید؟',
	'coll-overwrite' => 'رونویسی',
	'coll-append' => 'افزودن',
	'coll-cancel' => 'لغو',
	'coll-update' => 'به روز کردن',
	'coll-limit_exceeded_title' => 'کتاب بیش از اندازه بزرگ است',
	'coll-limit_exceeded_text' => 'کتاب شما بیش از اندازه بزرگ است است.
امکان افزودن صفحهٔ جدیدی را ندارید.',
	'coll-rendering_title' => 'در حال ترجمه دادن',
	'coll-rendering_text' => '<p><strong>لطفاً در مدتی که سند در حال ایجاد است شکیبا باشید.</strong></p>

<p><strong>پیشرفت:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>این صفحه باید به طور خودکار هر چند ثانیه یکبار تازه شود.
اگر این کار صورت نمی‌گیرد، لطفاً دکمهٔ تازه کردن صفحه را در مرورگر خود بزنید.</p>',
	'coll-rendering_status' => '<strong>وضعیت:</strong> $1',
	'coll-rendering_article' => '(صفحهٔ ویکی: $1)',
	'coll-rendering_page' => '(صفحه: $1)',
	'coll-rendering_finished_title' => 'پایان ترجمه',
	'coll-rendering_finished_text' => '<strong>پروندهٔ سند ایجاد شده‌است.</strong>
آن را به روی رایانهٔ خود <strong>[$1 بارگیری کنید]</strong>.

نکته:
* از خروجی راضی نیستید؟ [[{{MediaWiki:Coll-helppage}}|صفحهٔ راهنمای مجموعه‌ها]] را ببینید تا از امکان بهبود آن با خبر شوید.',
	'coll-notfound_title' => 'کتاب پیدا نشد',
	'coll-notfound_text' => 'صفحهٔ کتاب پیدا نشد.',
	'coll-is_cached' => '<ul><li>یک نسخهٔ کاشه‌گیری شده از این سند پیدا شد، به همین خاطر ترجمه لازم نبود. <a href="$1">ترجمهٔ اجباری.</a></li></ul>',
	'coll-excluded-templates' => '* از الگوهای رده [[:Category:$1|$1]] صرف نظر شد.',
	'coll-blacklisted-templates' => '* از الگوهای فهرست سیاه [[:$1]] صرف نظر شد.',
	'coll-return_to_collection' => '<p>بازگشت به <a href="$1">$2</a></p>',
	'coll-book_title' => 'سفارش به صورت کتاب چاپ شده',
	'coll-book_text' => 'با مراجعه به این شرکای چاپ-با-درخواست یک کتاب چاپ شده تهیه کنید:',
	'coll-order_from_pp' => 'سفارش کتاب از $1',
	'coll-about_pp' => 'دربارهٔ $1',
	'coll-invalid_podpartner_title' => 'شریک چاپ-با-درخواست غیر مجاز',
	'coll-invalid_podpartner_msg' => 'شریک چاپ-با-درخواست تعیین شده غیر مجاز است.
لطفاً با مدیر مدیاویکی خود تماس بگیرید.',
	'coll-license' => 'اجازه‌نامه',
	'coll-return_to' => 'بازگشت به [[:$1]]',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Tarmo
 */
$messages['fi'] = array(
	'coll-desc' => '[[Special:Book|Laadi kirjoja]].',
	'coll-collection' => 'Kirja',
	'coll-collections' => 'Kirjat',
	'coll-exclusion_category_title' => 'Tulosteesta poisjätettävät',
	'coll-print_template_prefix' => 'Tulosta',
	'coll-create_a_book' => 'Luo kirja',
	'coll-add_page' => 'Lisää wikisivu',
	'coll-remove_page' => 'Poista wikisivu',
	'coll-add_category' => 'Lisää luokkaan',
	'coll-load_collection' => 'Lataa kirja',
	'coll-show_collection' => 'Näytä kirja',
	'coll-help_collections' => 'Ohje kirjoille',
	'coll-n_pages' => '$1 {{PLURAL:$1|sivu|sivua}}',
	'coll-unknown_subpage_title' => 'Tuntematon alasivu',
	'coll-unknown_subpage_text' => 'Tätä [[Special:Book|kirjan]] alasivua ei ole olemassa',
	'coll-printable_version_pdf' => 'PDF-versio',
	'coll-download_as' => 'Lataa $1-tiedostona',
	'coll-noscript_text' => '<h1>Vaatii toimiakseen JavaScriptin</h1>
<strong>Selaimesi ei tue JavaScriptiä tai JavaScript on poistettu käytöstä.
Tämä sivu ei toimi oikein, ellei JavaScript ole käytössä.</strong>',
	'coll-intro_text' => 'Laadi ja hallinnoi omia henkilökohtaisia wikisivujen valikoimiasi.<br />Lisätietoja sivulla [[{{MediaWiki:Coll-helppage}}]].',
	'coll-helppage' => 'Help:Kirjat',
	'coll-bookscategory' => 'Kirjat',
	'coll-your_book' => 'Sinun kirjasi',
	'coll-download_title' => 'Lataa',
	'coll-download_text' => 'Jos haluat tallentaa kirjan omalle koneellesi, valitse tiedostomuoto ja napsauta painiketta.',
	'coll-download' => 'Lataa',
	'coll-format_label' => 'Muoto:',
	'coll-remove' => 'Poista',
	'coll-show' => 'Näytä',
	'coll-move_to_top' => 'Siirrä alkuun',
	'coll-move_up' => 'Siirrä ylös',
	'coll-move_down' => 'Siirrä alas',
	'coll-move_to_bottom' => 'Siirrä loppuun',
	'coll-title' => 'Otsikko:',
	'coll-subtitle' => 'Alaotsikko:',
	'coll-contents' => 'Sisältö',
	'coll-drag_and_drop' => 'Raahaa wikisivut ja luvut haluamaasi järjestykseen.',
	'coll-create_chapter' => 'Luo luku',
	'coll-sort_alphabetically' => 'Lajittele aakkosjärjestykseen',
	'coll-clear_collection' => 'Tyhjennä kirja',
	'coll-clear_collection_confirm' => 'Haluatko varmasti tyhjentää kirjasi?',
	'coll-rename' => 'Vaihda nimeä',
	'coll-new_chapter' => 'Anna uuden luvun nimi',
	'coll-rename_chapter' => 'Anna uuden luvun nimi',
	'coll-no_such_category' => 'Luokkaa ei ole',
	'coll-notitle_title' => 'Sivun otsikkoa ei voitu päätellä.',
	'coll-post_failed_title' => 'POST-pyyntö epäonnistui',
	'coll-post_failed_msg' => 'POST-pyyntö palvelimelle $1 epäonnistui ($2).',
	'coll-mwserve_failed_title' => 'Virhe renderöintipalvelimella',
	'coll-mwserve_failed_msg' => 'Renderöintipalvelimella tapahtui virhe: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Palvelin antoi virheilmoituksen',
	'coll-empty_collection' => 'Tyhjä kirja',
	'coll-revision' => 'Versio: $1',
	'coll-save_collection_title' => 'Tallenna ja jaa kirja',
	'coll-save_collection_text' => 'Valitse sijainti:',
	'coll-login_to_save' => 'Jos haluat tallentaa kirjat myöhempää käyttöä varten, [[Special:UserLogin|kirjaudu sisään tai luo tunnus]].',
	'coll-personal_collection_label' => 'Henkilökohtainen kirja:',
	'coll-community_collection_label' => 'Yhteinen kirja:',
	'coll-save_collection' => 'Tallenna kirja',
	'coll-save_category' => 'Kirjat lisätään luokkaan [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Sivu on olemassa. Ylikirjoitetaanko?',
	'coll-overwrite_text' => 'Sivu nimellä [[:$1]] on jo olemassa.
Haluatko korvata sen kokoelmallasi?',
	'coll-yes' => 'Kyllä',
	'coll-no' => 'Ei',
	'coll-load_overwrite_text' => 'Sinulla on jo joitain sivuja kirjassasi.
Haluatko korvata nykyisen kirjasi, lisätä uuden sisällön, vai peruuttaa tämän kirjan sisällön lataamisen?',
	'coll-overwrite' => 'Korvaa',
	'coll-append' => 'Lisää perään',
	'coll-cancel' => 'Peruuta',
	'coll-update' => 'Päivitä',
	'coll-limit_exceeded_title' => 'Kirja on liian suuri',
	'coll-limit_exceeded_text' => 'Kirjasi on liian suuri.
Sivuja ei voi lisätä enempää.',
	'coll-rendering_title' => 'Renderöidään',
	'coll-rendering_text' => '<p><strong>Ole hyvä ja odota, kun dokumenttiasi valmistellaan.</strong></p>

<p><strong>Eteneminen:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Tämän sivun pitäisi päivittyä muutaman sekunnin välein.
Jos näin ei käy, paina selaimesi päivityspainiketta.</p>',
	'coll-rendering_status' => '<strong>Tila:</strong> $1',
	'coll-rendering_article' => '(wikisivu: $1)',
	'coll-rendering_page' => '(sivu: $1)',
	'coll-rendering_finished_title' => 'Renderöinti valmis',
	'coll-rendering_finished_text' => '<strong>Tiedosto on generoitu.</strong>
<strong>[$1 Lataa tiedosto]</strong> tietokoneellesi.

Huomautuksia:
* Etkö ole tyytyväinen lopputulokseen? Katso [[{{MediaWiki:Coll-helppage}}|kirjojen ohjesivulta]] mahdollisuuksista parantaa sitä.',
	'coll-notfound_title' => 'Kirjaa ei löydy',
	'coll-notfound_text' => 'Kirjan sivua ei löydy.',
	'coll-is_cached' => '<ul><li>Dokumentti löytyi välimuistista, joten renderöintiä ei tarvittu. <a href="$1">Pakota uudelleenrenderöinti.</a></li></ul>',
	'coll-excluded-templates' => '* Mallineet luokassa [[:Category:$1|$1]] on ohitettu.',
	'coll-blacklisted-templates' => '* Mallineet sulkulistalla [[:$1]] on ohitettu.',
	'coll-return_to_collection' => '<p>Palaa takaisin sivulle <a href="$1">$2</a></p>',
	'coll-book_title' => 'Tilaa painettuna kirjana',
	'coll-book_text' => 'Hanki painettuna kirjana pikapainosta:',
	'coll-order_from_pp' => 'Tilaa kirja kohteesta $1',
	'coll-about_pp' => 'Tietoja kohteesta $1',
	'coll-invalid_podpartner_title' => 'Epäkelpo POD-partneri',
	'coll-invalid_podpartner_msg' => 'Annettu POD-partneri ei kelpaa.
Ota yhteys MediaWiki-ylläpitäjääsi.',
	'coll-license' => 'Lisenssi',
	'coll-return_to' => 'Palaa sivulle [[:$1]]',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author Guillom
 * @author IAlex
 * @author Korrigan
 * @author McDutchie
 * @author Meithal
 * @author PieRRoMaN
 * @author Verdy p
 */
$messages['fr'] = array(
	'coll-desc' => 'Permet de [[Special:Book|créer des livres]]',
	'coll-collection' => 'Livre',
	'coll-collections' => 'Livres',
	'coll-exclusion_category_title' => "Exclure lors de l'impression",
	'coll-print_template_prefix' => 'Imprimer',
	'coll-print_template_pattern' => '$1/Print',
	'coll-create_a_book' => 'Créer un livre',
	'coll-add_page' => 'Ajouter une page wiki',
	'coll-add_page_tooltip' => 'Ajouter la page courante à votre livre',
	'coll-remove_page' => 'Enlever une page wiki',
	'coll-remove_page_tooltip' => 'Retirer la page courante de votre livre',
	'coll-add_category' => 'Ajouter une catégorie',
	'coll-add_category_tooltip' => 'Ajouter tous les articles de cette catégorie à votre livre',
	'coll-load_collection' => 'Charger un livre',
	'coll-load_collection_tooltip' => 'Charger ce livre en tant que votre livre actuel',
	'coll-show_collection' => 'Afficher le livre',
	'coll-show_collection_tooltip' => 'Cliquez pour modifier / télécharger / commander votre livre',
	'coll-help_collections' => 'Aide sur les livres',
	'coll-help_collections_tooltip' => "Afficher l'aide sur les outils des livres",
	'coll-n_pages' => '$1 page{{PLURAL:$1||s}}',
	'coll-unknown_subpage_title' => 'Sous-page inconnue',
	'coll-unknown_subpage_text' => "Cette sous-page de [[Special:Book|livre]] n'existe pas",
	'coll-printable_version_pdf' => 'Version PDF',
	'coll-download_as' => 'Télécharger comme $1',
	'coll-noscript_text' => '<h1>Javascript est nécessaire !</h1>
<strong>Votre navigateur ne supporte pas Javascript ou bien vous l’avez désactivé.
Cette page ne fonctionnera pas correctement tant que Javascript n’est pas activé.</strong>',
	'coll-intro_text' => "Créez et gérez votre sélection individuelle de pages wiki.<br />Consultez la [[{{MediaWiki:Coll-helppage}}|page d'aide sur les collections]] pour plus d’informations.",
	'coll-helppage' => 'Help:Livres',
	'coll-bookscategory' => 'Livres',
	'coll-savedbook_template' => 'livre_enregistré',
	'coll-your_book' => 'Votre livre',
	'coll-download_title' => 'Télécharger',
	'coll-download_text' => 'Pour télécharger une version hors-ligne, choisissez un format et cliquez sur le bouton.',
	'coll-download_as_text' => 'Pour télécharger une version hors-ligne au format $1, cliquez sur le bouton.',
	'coll-download' => 'Télécharger',
	'coll-format_label' => 'Format :',
	'coll-remove' => 'Enlever',
	'coll-show' => 'Visionner',
	'coll-move_to_top' => 'Déplacer tout en haut',
	'coll-move_up' => 'Monter',
	'coll-move_down' => 'Descendre',
	'coll-move_to_bottom' => 'Déplacer tout en bas',
	'coll-title' => 'Titre :',
	'coll-subtitle' => 'Sous-titre :',
	'coll-contents' => 'Contenus',
	'coll-drag_and_drop' => 'Utiliser le glisser-déposer pour réordonner les pages et chapitres wiki.',
	'coll-create_chapter' => 'Créer un chapitre',
	'coll-sort_alphabetically' => 'Trier alphabétiquement',
	'coll-clear_collection' => 'Vider le livre',
	'coll-clear_collection_tooltip' => 'Retirer tous les articles de votre livre actuel',
	'coll-clear_collection_confirm' => 'Voulez-vous réellement effacer l’intégralité de votre livre ?',
	'coll-rename' => 'Renommer',
	'coll-new_chapter' => 'Entrer le titre du nouveau chapitre',
	'coll-rename_chapter' => 'Entrer le nouveau titre de ce chapitre',
	'coll-no_such_category' => 'Catégorie introuvable',
	'coll-notitle_title' => 'Le titre de la page n’a pas pu être déterminé.',
	'coll-post_failed_title' => 'La requête POST a échoué',
	'coll-post_failed_msg' => 'La requête POST vers $1 a échoué ($2).',
	'coll-mwserve_failed_title' => 'Erreur du serveur de rendu',
	'coll-mwserve_failed_msg' => 'Une erreur est survenue sur le serveur de rendu : <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Réponse d’erreur retournée par le serveur',
	'coll-empty_collection' => 'Livre vide',
	'coll-revision' => 'Version : $1',
	'coll-save_collection_title' => 'Sauvegarder et partager votre livre',
	'coll-save_collection_text' => 'Choisissez un emplacement de stockage pour votre livre :',
	'coll-login_to_save' => 'Si vous voulez sauvegarder des livres pour une utilisation ultérieure, veuillez [[Special:UserLogin|vous connecter ou créer un compte]].',
	'coll-personal_collection_label' => 'Livre personnel :',
	'coll-community_collection_label' => 'Livre collectif :',
	'coll-save_collection' => 'Sauvegarder le livre',
	'coll-save_category' => 'Les livres sont sauvegardés dans la catégorie [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'La page existe déjà.
L’écraser ?',
	'coll-overwrite_text' => 'Une page nommée [[:$1]] existe déjà.
Voulez-vous la remplacer par votre livre ?',
	'coll-yes' => 'Oui',
	'coll-no' => 'Non',
	'coll-load_overwrite_text' => 'Vous avez déjà des pages dans votre livre.
Voulez-vous écraser votre livre actuel, y ajouter le nouveau contenu ou bien annuler le chargement de ce livre ?',
	'coll-overwrite' => 'Écraser',
	'coll-append' => 'Ajouter',
	'coll-cancel' => 'Annuler',
	'coll-update' => 'Mettre à jour',
	'coll-limit_exceeded_title' => 'Livre trop grand',
	'coll-limit_exceeded_text' => 'Votre livre est trop grand.
Plus aucune page ne peut y être ajoutée.',
	'coll-rendering_title' => 'Rendu',
	'coll-rendering_text' => '<p><strong>Veuillez patienter pendant la génération du document.</strong></p>

<p><strong>Progression :</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Cette page devrait s’actualiser automatiquement par intervalles réguliers de quelques secondes.
Si tel n’était pas le cas, veuillez cliquer sur le bouton Actualiser de votre navigateur.</p>',
	'coll-rendering_status' => '<strong>État :</strong> $1',
	'coll-rendering_article' => '(page wiki : $1)',
	'coll-rendering_page' => '(page : $1)',
	'coll-rendering_finished_title' => 'Rendu terminé',
	'coll-rendering_finished_text' => '<strong>Le fichier document a été généré.</strong>
<strong>[$1 Télécharger le fichier]</strong> sur votre ordinateur.

Notes :
* Vous n’êtes pas satisfait du résultat ? Consultez [[{{MediaWiki:Coll-helppage}}|la page d’aide des livres]] pour les façons possibles de l’améliorer.',
	'coll-notfound_title' => 'Livre non trouvé',
	'coll-notfound_text' => 'La page du livre n’a pas pu être trouvée.',
	'coll-is_cached' => '<ul><li>Une version en cache du document a été trouvée, aussi aucun rendu n’était nécessaire. <a href="$1">Forcer un nouveau rendu.</a></li></ul>',
	'coll-excluded-templates' => '* Des modèles de la catégorie [[:Category:$1|$1]] ont été exclus.',
	'coll-blacklisted-templates' => '* Des modèles de la liste noire ([[:$1]]) ont été exclus.',
	'coll-return_to_collection' => '<p>Revenir à la page <a href="$1">$2</a></p>',
	'coll-book_title' => 'Commander sous la forme d‘un livre imprimé',
	'coll-book_text' => 'Obtenez un livre imprimé par notre partenaire d’impression à la demande :',
	'coll-order_from_pp' => 'Commander le livre à $1',
	'coll-about_pp' => 'À propos de $1',
	'coll-invalid_podpartner_title' => 'Partenaire d’impression à la demande incorrect.',
	'coll-invalid_podpartner_msg' => 'Le partenaire d’impression à la demande indiqué est incorrect.
Veuillez contacter votre administrateur MediaWiki.',
	'coll-license' => 'Licence',
	'coll-return_to' => 'Retourner vers [[:$1]]',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'coll-yes' => 'Ja',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'coll-desc' => '[[Special:Book|Crear libros]]',
	'coll-collection' => 'Libro',
	'coll-collections' => 'Libros',
	'coll-exclusion_category_title' => 'Excluír na impresión',
	'coll-print_template_prefix' => 'Imprimir',
	'coll-print_template_pattern' => '$1/Imprimir',
	'coll-create_a_book' => 'Crear un libro',
	'coll-add_page' => 'Engadir a páxina',
	'coll-add_page_tooltip' => 'Engadir a páxina wiki actual ao seu libro',
	'coll-remove_page' => 'Eliminar a páxina',
	'coll-remove_page_tooltip' => 'Eliminar a páxina wiki actual do seu libro',
	'coll-add_category' => 'Engadir categoría',
	'coll-add_category_tooltip' => 'Engadir todos os artigos desta categoría ao seu libro',
	'coll-load_collection' => 'Cargar un libro',
	'coll-load_collection_tooltip' => 'Cargar este libro como o seu libro actual',
	'coll-show_collection' => 'Mostrar o libro',
	'coll-show_collection_tooltip' => 'Prema para editar/descargar/pedir o seu libro',
	'coll-help_collections' => 'Axuda cos libros',
	'coll-help_collections_tooltip' => 'Mostrar a axuda sobre a ferramenta de libros',
	'coll-n_pages' => '$1 {{PLURAL:$1|páxina|páxinas}}',
	'coll-unknown_subpage_title' => 'Subpáxina descoñecida',
	'coll-unknown_subpage_text' => 'Esta subpáxina de [[Special:Book|Libro]] non existe',
	'coll-printable_version_pdf' => 'Versión PDF',
	'coll-download_as' => 'Descargar como $1',
	'coll-noscript_text' => '<h1>Requírese o JavaScript!</h1>
<strong>O seu navegador non soporta o JavaScript ou o JavaScript foi deshabilitado.
Esta páxina non funcionará correctamente, polo menos ata que o JavaScript sexa habilitado.</strong>',
	'coll-intro_text' => 'Cree e xestione a súa escolla individual de páxinas wiki.<br />Bótelle unha ollada a [[{{MediaWiki:Coll-helppage}}]] para máis información.',
	'coll-helppage' => 'Help:Libros',
	'coll-bookscategory' => 'Libros',
	'coll-savedbook_template' => 'libro_gardado',
	'coll-your_book' => 'O seu libro',
	'coll-download_title' => 'Descargar',
	'coll-download_text' => 'Para descargar sen conexión unha versión vella do ficheiro, escolla un formato e faga clic no botón.',
	'coll-download_as_text' => 'Para descargar unha versión en formato $1, prema no botón.',
	'coll-download' => 'Descargar',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Eliminar',
	'coll-show' => 'Mostrar',
	'coll-move_to_top' => 'Ir arriba',
	'coll-move_up' => 'Mover arriba',
	'coll-move_down' => 'Mover abaixo',
	'coll-move_to_bottom' => 'Ir abaixo',
	'coll-title' => 'Título:',
	'coll-subtitle' => 'Subtítulo:',
	'coll-contents' => 'Contidos',
	'coll-drag_and_drop' => 'Use amosar e agochar para reordenar as páxinas e os capítulos wiki',
	'coll-create_chapter' => 'Crear un capítulo',
	'coll-sort_alphabetically' => 'Ordenar alfabeticamente',
	'coll-clear_collection' => 'Borrar o libro',
	'coll-clear_collection_tooltip' => 'Eliminar todos os artigos do seu libro actual',
	'coll-clear_collection_confirm' => 'Realmente quere eliminar por completo o seu libro?',
	'coll-rename' => 'Renomear',
	'coll-new_chapter' => 'Insira un nome para o novo capítulo',
	'coll-rename_chapter' => 'Insira un novo nome para o capítulo',
	'coll-no_such_category' => 'Non existe tal categoría',
	'coll-notitle_title' => 'O título da páxina non pode ser determinado.',
	'coll-post_failed_title' => 'A solicitude do POST fallou',
	'coll-post_failed_msg' => 'Fallou o POST solicitado a $1 ($2).',
	'coll-mwserve_failed_title' => 'Erro no servidor de renderización',
	'coll-mwserve_failed_msg' => 'Produciuse un erro no servidor de renderización: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Ocorreu un erro no servidor',
	'coll-empty_collection' => 'Libro baleiro',
	'coll-revision' => 'Revisión: $1',
	'coll-save_collection_title' => 'Gardar e compartir o seu libro',
	'coll-save_collection_text' => 'Escolla unha localización:',
	'coll-login_to_save' => 'Se quere gardar os libros para un uso posterior, por favor, [[Special:UserLogin|acceda ao sistema ou cree unha conta]].',
	'coll-personal_collection_label' => 'Libro persoal:',
	'coll-community_collection_label' => 'Libro da comunidade:',
	'coll-save_collection' => 'Gardar o libro',
	'coll-save_category' => 'Os libros son gardados na categoría [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'A páxina existe. Desexa sobreescribir?',
	'coll-overwrite_text' => 'Xa existe unha páxina chamada [[:$1]].
Quere reemprazala coa súa colección?',
	'coll-yes' => 'Si',
	'coll-no' => 'Non',
	'coll-load_overwrite_text' => 'Xa ten algunhas páxinas no seu libro.
Desexa sobreescribir o seu libro actual, adxuntar o novo contido ou cancelar a carga deste libro?',
	'coll-overwrite' => 'Sobreescribir',
	'coll-append' => 'Adxuntar',
	'coll-cancel' => 'Cancelar',
	'coll-update' => 'Actualizar',
	'coll-limit_exceeded_title' => 'Libro moi grande',
	'coll-limit_exceeded_text' => 'O seu libro é moi grande.
Non se poden engadir máis páxinas.',
	'coll-rendering_title' => 'Renderizando',
	'coll-rendering_text' => '<p><strong>Por favor, agarde mentres o documento é xerado.</strong></p>

<p><strong>Progreso:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Esta páxina debería refrescarse cada poucos segundos.
Se non vai, por favor, prema no botón "Refrescar" do seu navegador.</p>',
	'coll-rendering_status' => '<strong>Estado:</strong> $1',
	'coll-rendering_article' => '(páxina wiki: $1)',
	'coll-rendering_page' => '(páxina: $1)',
	'coll-rendering_finished_title' => 'Finalizou a renderización',
	'coll-rendering_finished_text' => '<strong>O ficheiro do documento foi xerado.</strong>
<strong>[$1 Descargue o ficheiro]</strong> no seu ordenador.

Notas:
*Non está satisfeito co ficheiro obtido? Vexa [[{{MediaWiki:Coll-helppage}}|a páxina de axuda acerca das coleccións]] para comprobar as posibilidades de melloralo.',
	'coll-notfound_title' => 'Non se pode atopar o libro',
	'coll-notfound_text' => 'Non se pode atopar a páxina do libro.',
	'coll-is_cached' => '<ul><li>Atopouse unha versión do documento na memoria caché, polo que non vai ser necesaria a renderización. <a href="$1">Forzala.</a></li></ul>',
	'coll-excluded-templates' => '* O modelos que están na categoría "[[:Category:$1|$1]]" foron excluídos.',
	'coll-blacklisted-templates' => '* O modelos da lista negra "[[:$1]]" foron excluídos.',
	'coll-return_to_collection' => '<p>Voltar a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Encargar como un libro impreso',
	'coll-book_text' => 'Obteña un libro impreso desde un dos nosos seguintes compañeiros de solicitudes de impresión:',
	'coll-order_from_pp' => 'Encargar un libro a $1',
	'coll-about_pp' => 'Acerca de $1',
	'coll-invalid_podpartner_title' => 'Compañeiro de solicitudes de impresión (POD) inválido',
	'coll-invalid_podpartner_msg' => 'O compañeiro de solicitudes de impresión (POD) indicado é inválido.
Por favor, contacte co seu administrador MediaWiki.',
	'coll-license' => 'Licenza',
	'coll-return_to' => 'Voltar a "[[:$1]]"',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'coll-download' => 'Καταφόρτισις',
	'coll-remove' => 'Άφαιρεῖν',
	'coll-show' => 'Δεικνύναι',
	'coll-title' => 'Ἐπιγραφή:',
	'coll-subtitle' => 'Ὑποεπιγραφή:',
	'coll-contents' => 'Περιεχόμενα',
	'coll-yes' => 'Ναί',
	'coll-no' => 'Οὐ',
	'coll-cancel' => 'Ἀκυροῦν',
	'coll-rendering_title' => 'Ἀπόδοσις',
	'coll-about_pp' => 'Περὶ $1',
	'coll-license' => 'Ἄδεια',
	'coll-return_to' => 'Ἐπανιέναι εἰς [[:$1]]',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author J. 'mach' wust
 * @author Melancholie
 */
$messages['gsw'] = array(
	'coll-desc' => '[[Special:Book|Leg Biecher aa]]',
	'coll-collection' => 'Buech',
	'coll-collections' => 'Biecher',
	'coll-exclusion_category_title' => 'Vum Druck usschließe',
	'coll-print_template_prefix' => 'Drucke',
	'coll-print_template_pattern' => '$1/Druck',
	'coll-create_a_book' => 'Buech aalege',
	'coll-add_page' => 'Artikel zuefiege',
	'coll-add_page_tooltip' => 'Di aktuäll Wikisyte zue Dyynem Buech zuefiege',
	'coll-remove_page' => 'Artikel useneh',
	'coll-remove_page_tooltip' => 'Di aktuäll Wikisyte us Dyynem Buech uuseneh',
	'coll-add_category' => 'Kategorii zuefiege',
	'coll-add_category_tooltip' => 'Alli Wikisyte in däre Kategorii in Dyy Buech yyfiege',
	'coll-load_collection' => 'Buech lade',
	'coll-load_collection_tooltip' => 'Des Buech as Dyy aktuäll Buech lade',
	'coll-show_collection' => 'Buech zeige',
	'coll-show_collection_tooltip' => 'Druck do go Dyy Buech bearbeite/abelade/bstelle',
	'coll-help_collections' => 'Hilf zue Biecher',
	'coll-help_collections_tooltip' => 'D Hilf zum Buech-Tool aazeige',
	'coll-n_pages' => '$1 {{PLURAL:$1|Syte|Syte}}',
	'coll-unknown_subpage_title' => 'Nit bekannti Untersyte',
	'coll-unknown_subpage_text' => 'Die Untersyte vu dr [[Special:Book|Buech]] git s nit',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-download_as' => 'As $1 abelade',
	'coll-noscript_text' => '<h1>S brucht JavaScript!</h1>
<strong>Dyy Browser unterstitzt kei JavaScript oder s JavaScript isch deaktiviert.
Die Syte funktioniert eso lang nit richtig, solang JavaScript nit verfiegbar isch.</strong>',
	'coll-intro_text' => 'Leg Dyyni individuäll Sammlig vu Syte aa un verwalt si.<br />Lueg d [[{{MediaWiki:Coll-helppage}}|Hilf zue Sammlige]] fir wyteri Informatione.',
	'coll-helppage' => 'Help:Biecher',
	'coll-bookscategory' => 'Biecher',
	'coll-savedbook_template' => 'gspycheret_buech',
	'coll-your_book' => 'Dyy Buech',
	'coll-download_title' => 'Abelade',
	'coll-download_text' => 'Go ne Offline-Version abelade, wehl e Format un druck uf d Schaltflächi.',
	'coll-download_as_text' => 'Go ne Offline-Version im Format $1 abezlade, druck uf d Schaltflächi.',
	'coll-download' => 'Abelade',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Useneh',
	'coll-show' => 'Zeige',
	'coll-move_to_top' => 'an dr Aafang',
	'coll-move_up' => 'ufe',
	'coll-move_down' => 'abe',
	'coll-move_to_bottom' => 'an s Änd',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Untertitel:',
	'coll-contents' => 'Inhalt',
	'coll-drag_and_drop' => 'Mit dr Muus chasch Syten un Kapitel verschiebe go d Reihefolg ändere',
	'coll-create_chapter' => 'Kapitel aalege',
	'coll-sort_alphabetically' => 'Noch em Alfabet sortiere',
	'coll-clear_collection' => 'Buech lesche',
	'coll-clear_collection_tooltip' => 'Alli Wikisyte us Dyynem aktuälle Buech useneh',
	'coll-clear_collection_confirm' => 'Mechtsch Dyy Buech ächt lesche?',
	'coll-rename' => 'Umnänne',
	'coll-new_chapter' => 'Gib e Name fir e nej Kapitel yy',
	'coll-rename_chapter' => 'Gib e neije Name fir s Kapitel yy',
	'coll-no_such_category' => 'Kategorii git s nit',
	'coll-notitle_title' => 'Dr Titel vu dr Syte het nit chenne bstimmt wäre.',
	'coll-post_failed_title' => 'POST-Aafrog isch fählgschlage',
	'coll-post_failed_msg' => 'D POST-Aafrog an $1 isch fählgschlage ($2).',
	'coll-mwserve_failed_title' => 'Serverfähler',
	'coll-mwserve_failed_msg' => 'Uf em Renderer-Server het s e Fähler gee: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Fählermäldig vum Server',
	'coll-empty_collection' => 'Leers Buech',
	'coll-revision' => 'Version: $1',
	'coll-save_collection_title' => 'Spychere un teil Dyy Buech',
	'coll-save_collection_text' => 'Wehl e Ort:',
	'coll-login_to_save' => 'Wänn Du mechtsch Biecher spychere, no [[Special:UserLogin|mäld Di bitte aa oder leg e Benutzerkonto aa]].',
	'coll-personal_collection_label' => 'Persenlig Buech:',
	'coll-community_collection_label' => 'Community-Buech:',
	'coll-save_collection' => 'Buech spychere',
	'coll-save_category' => 'Biecher wäre in dr Kategorii [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] gspycheret.',
	'coll-overwrite_title' => 'Syte git s scho, iberschryybe?',
	'coll-overwrite_text' => 'E Syte mit em Name [[:$1]] git s scho. Mechtsch si dur Dyyni Sammlig ersetze?',
	'coll-yes' => 'Jo',
	'coll-no' => 'Nei',
	'coll-load_overwrite_text' => 'In Dyym Buech het s scho Syte.
Mechtsch di aktuäll Buech iberschryybe, di neije Syte aahänke oder s Lade vu däm Buech abbräche?',
	'coll-overwrite' => 'Iberschryybe',
	'coll-append' => 'Aahänke',
	'coll-cancel' => 'Abbräche',
	'coll-update' => 'Aktualisiere',
	'coll-limit_exceeded_title' => 'Buech z groß',
	'coll-limit_exceeded_text' => 'Dyy Buech isch z groß. S chenne kei Syte meh zuegfiegt wäre',
	'coll-rendering_title' => 'Am Aalege',
	'coll-rendering_text' => '<p><strong>Bitte haa Geduld, derwylscht s Dokumänt aagleit wird.</strong></p>

<p><strong>Fortschritt:</strong> <span id="renderingProgress">$1</span> % <span id="renderingStatus">$2</span></p>

<p>Die Syte sott si alli paar Sekunde vu sälber aktualisiere.
Wänn des aber nit gschiht, no druck bitte dr „Aktualisiere“-Chnopf (meischt F5) vu Dyynem Browser.</p>',
	'coll-rendering_status' => 'strong>Status:</strong> $1',
	'coll-rendering_article' => '(Artikel: $1)',
	'coll-rendering_page' => '(Syte: $1)',
	'coll-rendering_finished_title' => 'Fertig aagleit',
	'coll-rendering_finished_text' => '<strong>D Datei isch mit Erfolg aagleit wore.</strong>
<strong>[$1 Dokument abelade]</strong>.

Hiiwyys:
* Bisch mit em Ergebnis nit zfride? Megligkeite d Uusgab z verbessere findsch uf dr [[{{MediaWiki:Coll-helppage}}|Hilfsyte iber d Sammlige]].',
	'coll-notfound_title' => 'Buech nit gfunde',
	'coll-notfound_text' => 'Dyyni Buech het nit chenne gfunde wäre.',
	'coll-is_cached' => '<ul><li>S git e Version vum Dokumänt, wu zwischegspycheret isch, so dass kein Rendering notwändig gsi isch. <a href="$1">Nej-Rendering erzwinge.</a></li></ul>',
	'coll-excluded-templates' => '* Vorlage us dr Kategorii [[:Category:$1|$1]] sin usgschlosse wore.',
	'coll-blacklisted-templates' => '* Vorlage vu dr Schwarze Lischt [[:$1]] sin usgschlosse wore.',
	'coll-return_to_collection' => 'Zruck zue <a href="$1">$2</a>',
	'coll-book_title' => 'As druckts Buech bstelle',
	'coll-book_text' => 'Bstell e druckti Buechusgab bi unserem Print-on-Demand-Partner:',
	'coll-order_from_pp' => 'Bstell Buech bi $1',
	'coll-about_pp' => 'Iber $1',
	'coll-invalid_podpartner_title' => 'Nit giltige Print-on-Demand-Partner',
	'coll-invalid_podpartner_msg' => 'In dr Aagabe zum Print-on-Demand-Partner het s Fähler. Bitte nimm Kontakt uf zu MediaWiki-Administrator.',
	'coll-license' => 'Lizänz',
	'coll-return_to' => 'Zruck zue [[:$1]]',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'coll-collection' => 'Çhaglym',
	'coll-collections' => 'Çhaglymyn',
	'coll-create_a_book' => 'My haglym',
	'coll-helppage' => 'Cooney:Çhaglymyn',
	'coll-title' => 'Ard-ennym:',
	'coll-contents' => 'Cummal',
	'coll-create_chapter' => 'Croo cabdil noa',
	'coll-sort_alphabetically' => 'Sorçhaghey duillagyn rere lettyr',
	'coll-personal_collection_label' => 'Çhaglym persoonagh:',
	'coll-community_collection_label' => 'Çhaglym y chohionnal:',
	'coll-yes' => 'Ta',
	'coll-no' => 'Cha',
	'coll-cancel' => 'Dolley magh',
	'coll-about_pp' => 'Mychione $1',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'coll-remove' => 'Kāpae',
	'coll-contents' => 'Papa kuhikuhi',
	'coll-about_pp' => 'E pili ana iā $1',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 * @author YaronSh
 */
$messages['he'] = array(
	'coll-desc' => '[[Special:Book|איסוף דפים לספר]], יצירת קובצי PDF',
	'coll-collection' => 'ספר',
	'coll-collections' => 'ספרים',
	'coll-exclusion_category_title' => 'דפים שאינם להדפסה',
	'coll-print_template_prefix' => 'הדפסה',
	'coll-print_template_pattern' => '$1/הדפסה',
	'coll-create_a_book' => 'יצירת ספר',
	'coll-add_page' => 'הוספת דף ויקי',
	'coll-add_page_tooltip' => 'הוספת דף הוויקי הנוכחי לספר שלך',
	'coll-remove_page' => 'הסרת דף ויקי',
	'coll-remove_page_tooltip' => 'הסרת דף הוויקי הנוכחי מהספר שלך',
	'coll-add_category' => 'הוספת קטגוריה',
	'coll-add_category_tooltip' => 'הוספת כל הדפים בקטגוריה זו לספר שלך',
	'coll-load_collection' => 'פתיחת ספר',
	'coll-load_collection_tooltip' => 'פתיחת הספר הזה כספר הנוכחי שלך',
	'coll-show_collection' => 'הצגת ספר',
	'coll-show_collection_tooltip' => 'עריכת/הורדת/הזמנת הספר שלך',
	'coll-help_collections' => 'עזרה לספרים',
	'coll-help_collections_tooltip' => 'הצגת עזרה על כלי הספרים',
	'coll-n_pages' => '{{PLURAL:$1|דף אחד|$1 דפים}}',
	'coll-unknown_subpage_title' => 'דף משנה בלתי ידוע',
	'coll-unknown_subpage_text' => 'דף משנה זה של ה[[Special:Book|ספר]] אינו קיים',
	'coll-printable_version_pdf' => 'גרסת PDF',
	'coll-download_as' => 'הורדה בפורמט $1',
	'coll-noscript_text' => '<h1>JavaScript נדרש!</h1>
<strong>הדפדפן שלכם אינו תומך ב־JavaScript או שביטלתם את JavaScript בדפדפן זה.
דף זה לא יעבוד כדרוש, אלא אם כן JavaScript יופעל.</strong>',
	'coll-intro_text' => 'באפשרותכם ליצור ולנהל אוספים של דפי ויקי שבחרתם.<br />ראו [[{{MediaWiki:Coll-helppage}}]] למידע נוסף.',
	'coll-helppage' => 'Help:ספרים',
	'coll-bookscategory' => 'ספרים',
	'coll-savedbook_template' => 'ספר_שמור',
	'coll-your_book' => 'הספר שלכם',
	'coll-download_title' => 'הורדה',
	'coll-download_text' => 'להורדת גרסה, בחרו פורמט ולחצו על הכפתור.',
	'coll-download_as_text' => 'להורדת גרסה בפורמט $1, לחצו על הכפתור.',
	'coll-download' => 'הורדה',
	'coll-format_label' => 'פורמט:',
	'coll-remove' => 'הסרה',
	'coll-show' => 'הצגה',
	'coll-move_to_top' => 'העברה לראש',
	'coll-move_up' => 'העברה למעלה',
	'coll-move_down' => 'העברה למטה',
	'coll-move_to_bottom' => 'העברה לתחתית',
	'coll-title' => 'כותרת:',
	'coll-subtitle' => 'כותרת משנה:',
	'coll-contents' => 'תכנים',
	'coll-drag_and_drop' => 'השתמשו בגרירה ושחרור כדי לסדר מחדש את הערכים ואת הפרקים',
	'coll-create_chapter' => 'פרק חדש',
	'coll-sort_alphabetically' => 'סידור אלפביתי',
	'coll-clear_collection' => 'ניקוי הספר',
	'coll-clear_collection_tooltip' => 'הסרת כל הדפים מהספר הנוכחי שלך',
	'coll-clear_collection_confirm' => 'האם אתם בטוחים שברצונכם לנקות לגמרי את הספר שלכם?',
	'coll-rename' => 'שינוי שם',
	'coll-new_chapter' => 'הקלידו שם לפרק החדש',
	'coll-rename_chapter' => 'הקלידו שם חדש לפרק',
	'coll-no_such_category' => 'אין קטגוריה כזו',
	'coll-notitle_title' => 'לא ניתן היה לבדוק מהי כותרת הדף.',
	'coll-post_failed_title' => 'בקשת ה־POST נכשלה',
	'coll-post_failed_msg' => 'בקשת ה־POST ל־$1 נכשלה ($2).',
	'coll-mwserve_failed_title' => 'שגיאה בשרת היצירה',
	'coll-mwserve_failed_msg' => 'אירעה שגיאה בשרת יצירת המסמכים: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'שגיאה בשרת',
	'coll-empty_collection' => 'ספר ריק',
	'coll-revision' => 'גרסה: $1',
	'coll-save_collection_title' => 'שמירת ושיתוף הספר',
	'coll-save_collection_text' => 'בחרו מקום לאיחסון הספר שלכם:',
	'coll-login_to_save' => 'אם ברצונכם לשמור ספרים לשימוש מאוחר יותר, אנא [[Special:UserLogin|היכנסו לחשבון או צרו חשבון]].',
	'coll-personal_collection_label' => 'ספר פרטי:',
	'coll-community_collection_label' => 'ספר קהילתי:',
	'coll-save_collection' => 'שמירת הספר',
	'coll-save_category' => 'כל הספרים נשמרים בקטגוריה [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-collections}}]].',
	'coll-overwrite_title' => 'הדף כבר קיים.
האם לדרוס אותו?',
	'coll-overwrite_text' => 'דף בשם [[:$1]] כבר קיים.
האם ברצונכם להחליף אותו עם הספר שלכם?',
	'coll-yes' => 'כן',
	'coll-no' => 'לא',
	'coll-load_overwrite_text' => 'כבר יש לכם מספר דפים בספר שלכם.
האם ברצונכם לדרוס את הספר הנוכחי שלכם, להוסיף את התוכן החדש או לבטל את פתיחת הספר הזה?',
	'coll-overwrite' => 'דריסה',
	'coll-append' => 'הוספת התוכן',
	'coll-cancel' => 'ביטול',
	'coll-update' => 'עדכון',
	'coll-limit_exceeded_title' => 'הספר גדול מדי',
	'coll-limit_exceeded_text' => 'הספר שלכם גדול מדי.
לא ניתן להוסיף דפים נוספים.',
	'coll-rendering_title' => 'ביצירה',
	'coll-rendering_text' => '<p><strong>אנא המתינו בעת יצירת המסמך.</strong></p>

<p><strong>התקדמות התהליך:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>הדפדפן אמור לבצע ריענון אוטומטי לדף זה כל מספר שניות.
אם זה לא עובד, אנא לחצו על כפתור הריענון בדפדפן שלכם.</p>',
	'coll-rendering_status' => '<strong>מצב:</strong> $1',
	'coll-rendering_article' => '(דף תוכן: $1)',
	'coll-rendering_page' => '(דף: $1)',
	'coll-rendering_finished_title' => 'היצירה הסתיימה',
	'coll-rendering_finished_text' => '<strong>קובץ המסמך נוצר.</strong>
<strong>[$1 הורדת הקובץ]</strong> למחשבכם.

הערות:
* אינכם מרוצים מהפלט? ב[[{{MediaWiki:Coll-helppage}}|דף העזרה על ספרים]] תוכלו למצוא אפשרויות לשיפורו.',
	'coll-notfound_title' => 'הספר לא נמצא',
	'coll-notfound_text' => 'לא ניתן למצוא את דף הספר.',
	'coll-is_cached' => '<ul><li>גרסה שמורה של המסמך נמצאה, כך שאין צורך ביצירתו. <a href="$1">יצירה מחדש.</a></li></ul>',
	'coll-excluded-templates' => '* תבניות בקטגוריה [[:Category:$1|$1]] אינן כלולות.',
	'coll-blacklisted-templates' => '* תבניות ברשימה השחורה [[:$1]] אינן כלולות.',
	'coll-return_to_collection' => '<p>חזרה ל<a href="$1">$2</a></p>',
	'coll-book_title' => 'הזמנה כספר מודפס',
	'coll-book_text' => 'קבלת ספר מודפס משירות ההדפסה לפי דרישה:',
	'coll-order_from_pp' => 'הזמנת ספר מ־$1',
	'coll-about_pp' => 'אודות $1',
	'coll-invalid_podpartner_title' => 'שירות שגוי',
	'coll-invalid_podpartner_msg' => 'שירות ההדפסה לפי דרישה שהוזן שגוי.
אנא צרו קשר עם מנהל של מדיה־ויקי.',
	'coll-license' => 'רישיון',
	'coll-return_to' => 'חזרה ל[[:$1]]',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'coll-desc' => '[[Special:Collection|पन्ने जमा करें]], पीडीएफ बनायें',
	'coll-collection' => 'कलेक्शन',
	'coll-collections' => 'कलेक्शन',
	'coll-create_a_book' => 'मेरा कलेक्शन',
	'coll-add_page' => 'पन्ना बढायें',
	'coll-remove_page' => 'पन्ना हटायें',
	'coll-add_category' => 'श्रेणी बढायें',
	'coll-load_collection' => 'कलेक्शन लोड करें',
	'coll-show_collection' => 'कलेक्शन दर्शायें',
	'coll-help_collections' => 'कलेक्शन सहायता',
	'coll-helppage' => 'Help:कलेक्शन',
	'coll-download_title' => 'कलेक्शन पीडिएफ डाउनलोड करें',
	'coll-download_text' => 'आपके कलेक्शनका पीडिएफ अवतरण डाउनलोड करने के लिये, दिये हुए बटन पर क्लिक करें।',
	'coll-remove' => 'हटायें',
	'coll-move_to_top' => 'सबसे उपर भेजें',
	'coll-move_up' => 'उपर भेजें',
	'coll-move_down' => 'नीचे भेजें',
	'coll-move_to_bottom' => 'सबसे नीचे भेजें',
	'coll-title' => 'शीर्षक:',
	'coll-subtitle' => 'उपशीर्षक:',
	'coll-contents' => 'अनुक्रम',
	'coll-create_chapter' => 'नया अध्याय बनायें',
	'coll-sort_alphabetically' => 'अक्षरोंके अनुसार पन्ने लगायें',
	'coll-clear_collection' => 'कलेक्शन खाली करें',
	'coll-rename' => 'नाम बदलें',
	'coll-new_chapter' => 'नये अध्याय के लिये नाम दें',
	'coll-rename_chapter' => 'नये अध्याय के लिये नाम दें',
	'coll-no_such_category' => 'ऐसी श्रेणी नहीं हैं',
	'coll-notitle_title' => 'इस पन्ने का शीर्षक निश्चित नहीं कर पा रहें हैं।',
	'coll-post_failed_title' => 'POST माँग पूरी नहीं हुई हैं',
	'coll-post_failed_msg' => 'POST माँग पूरी नहीं हुई हैं ($2)',
	'coll-error_reponse' => 'सर्वरसे गलत रिस्पॉन्स मिला हैं',
	'coll-empty_collection' => 'खाली कलेक्शन',
	'coll-revision' => 'अवतरण: $1',
	'coll-save_collection_title' => 'कलेक्शन संजोयें',
	'coll-save_collection_text' => 'इस कलेक्शनको फिरसे इस्तेमाल में लाने के लिये इसे एक नाम दें और इसका प्रकार चुनकर इसे संजोयें:',
	'coll-login_to_save' => 'अगर आप बादमें इस्तेमाल के लिये यह कलेक्शन संजोना चाहतें हैं, तो कृपया [[Special:UserLogin|लॉग इन करें या नया खाता खोलें]]।',
	'coll-personal_collection_label' => 'वैयक्तिक कलेक्शन:',
	'coll-community_collection_label' => 'सामूहिक कलेक्शन:',
	'coll-save_collection' => 'कलेक्शन संजोयें',
	'coll-overwrite_title' => 'पन्ना अस्तित्व में हैं। पुनर्लेखन करें?',
	'coll-overwrite_text' => '[[:$1]] नामका पन्ना पहले से अस्तित्वमें हैं।
क्या आप उसपर अपना कलेक्शन पुनर्लिखना चाहतें हैं?',
	'coll-yes' => 'हां',
	'coll-no' => 'नहीं',
	'coll-load_overwrite_text' => 'आपके कलेक्शनमें पहले से कुछ पन्ने हैं।
क्या आप आपका कलेक्शन दुबारा बनाना चाहतें हैं, या यह पन्ने बढाना चाहतें हैं?',
	'coll-overwrite' => 'पुनर्लेखन करें',
	'coll-append' => 'बढायें',
	'coll-cancel' => 'रद्द करें',
	'coll-limit_exceeded_title' => 'कलेक्शन बहुत बडा हुआ हैं',
	'coll-limit_exceeded_text' => 'आपका कलेक्शन बहुत बडा हुआ हैं।
और पन्ने बढा नहीं सकतें।',
	'coll-notfound_title' => 'कलेक्शन मिला नहीं',
	'coll-notfound_text' => 'कलेक्शन पन्ना मिला नहीं।',
	'coll-return_to_collection' => '<p><a href="$1">$2</a></p> पर वापस जायें',
	'coll-book_title' => 'छपा हुआ अवतरण माँगे',
	'coll-book_text' => 'आप नीचे दिये हुए प्रिन्ट-ऑन-डिमांड पार्टनर्ससे आपके कलेक्शनमें उपलब्ध पन्नोंका छपा हुआ अवतरण पा सकतें हैं:',
	'coll-order_from_pp' => '$1 से बुक मंगायें',
	'coll-about_pp' => '$1 के बारे में',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'coll-cancel' => 'Kanselahon',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 * @author Suradnik13
 */
$messages['hr'] = array(
	'coll-desc' => '[[Special:Book|Stvori zbirku]]',
	'coll-collection' => 'Zbirka',
	'coll-collections' => 'Zbirke',
	'coll-exclusion_category_title' => 'Izuzmi u ispisu',
	'coll-print_template_prefix' => 'Ispiši',
	'coll-create_a_book' => 'Napravi knjigu',
	'coll-add_page' => 'Dodaj wiki stranicu',
	'coll-remove_page' => 'Ukloni wiki stranicu',
	'coll-add_category' => 'Dodaj kategoriju',
	'coll-load_collection' => 'Učitaj zbirku',
	'coll-show_collection' => 'Pokaži zbirku',
	'coll-help_collections' => 'Zbirke pomoć',
	'coll-n_pages' => '$1 {{PLURAL:$1|stranica|stranice|stranica}}',
	'coll-unknown_subpage_title' => 'Nepoznata podstranica',
	'coll-unknown_subpage_text' => 'Ova podstranica [[Special:Book|zbirke]] ne postoji',
	'coll-printable_version_pdf' => 'PDF inačica',
	'coll-download_as' => 'Preuzmi kao $1',
	'coll-noscript_text' => '<h1>Potreban je JavaScript!</h1>
<strong>Vaš preglednik nema podršku za JavaScript ili je isključena. Ova stranica neće raditi ispravno, ako JavaScript nije omogućen.</strong>',
	'coll-intro_text' => 'Napravite i uređujte svoj osobni odabir wiki stranica.<br />Vidi [[{{MediaWiki:Coll-helppage}}|stranicu za pomoć o zbirkama]] za više obavijesti.',
	'coll-helppage' => 'Help:Zbirke',
	'coll-bookscategory' => 'Zbirke',
	'coll-savedbook_template' => 'snimljena_zbirka',
	'coll-your_book' => 'Vaša knjiga',
	'coll-download_title' => 'Preuzmi',
	'coll-download_text' => 'Za preuzimanje izvanmrežne inačice, odaberite format i kliknite tipku.',
	'coll-download_as_text' => 'Za preuzimanje inačice u $1 formatu kliknite na gumb.',
	'coll-download' => 'Preuzmi',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Ukloni',
	'coll-show' => 'Pokaži',
	'coll-move_to_top' => 'Premjesti na vrh',
	'coll-move_up' => 'Premjesti gore',
	'coll-move_down' => 'Premjesti dolje',
	'coll-move_to_bottom' => 'Premjesti na dno',
	'coll-title' => 'Naslov:',
	'coll-subtitle' => 'Podnaslov:',
	'coll-contents' => 'Sadržaj',
	'coll-drag_and_drop' => 'Koristite "povuci i stavi" za preslagivanje wiki stranica i poglavlja.',
	'coll-create_chapter' => 'Napravi poglavlje',
	'coll-sort_alphabetically' => 'Rasporedi abecedno',
	'coll-clear_collection' => 'Očisti zbirku',
	'coll-clear_collection_confirm' => 'Želite li stvarno očistiti svoju cijelu zbirku?',
	'coll-rename' => 'Preimenuj',
	'coll-new_chapter' => 'Upišite ime za novo poglavlje',
	'coll-rename_chapter' => 'Upišite novo ime za poglavlje',
	'coll-no_such_category' => 'Nema takve kategorije',
	'coll-notitle_title' => 'Naslov stranice nije mogao biti određen',
	'coll-post_failed_title' => 'POST zahtjev je neuspješan',
	'coll-post_failed_msg' => 'POST zahtjev za $1 je neuspješan ($2).',
	'coll-mwserve_failed_title' => 'Greška na serveru za izvođenje zahtjeva',
	'coll-mwserve_failed_msg' => 'Dogodila se greška na serveru za izvođenje zahtijeva: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Greška u odgovoru sa servera',
	'coll-empty_collection' => 'Prazna zbirka',
	'coll-revision' => 'Izmjena: $1',
	'coll-save_collection_title' => 'Spremi i dijeli svoju zbirku',
	'coll-save_collection_text' => 'Odaberite lokaciju:',
	'coll-login_to_save' => 'Ako želite spremiti knjige za kasniju uporabu, molimo [[Special:UserLogin|prijavite se ili napravite suradnički račun]].',
	'coll-personal_collection_label' => 'Osobna knjiga:',
	'coll-community_collection_label' => 'Zajednička knjiga:',
	'coll-save_collection' => 'Spremi knjigu',
	'coll-save_category' => 'Sve knjige su spremljene u kategoriju [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Stranica postoji.
Prepisati preko?',
	'coll-overwrite_text' => 'Stranica s nazivom [[:$1]] već postoji.
Želite li da bude zamijenjena s vašom zbirkom?',
	'coll-yes' => 'Da',
	'coll-no' => 'Ne',
	'coll-load_overwrite_text' => 'Već imate neke stranice u svojoj knjizi.
Želite li prepisati svoju trenutačnu knjigu novom, samo dodati novi sadržaj ili zaustaviti učitavanje ove knjige?',
	'coll-overwrite' => 'Prepisati preko',
	'coll-append' => 'Nadodaj',
	'coll-cancel' => 'Zaustavi',
	'coll-update' => 'Ažuriranje',
	'coll-limit_exceeded_title' => 'Knjiga je prevelika',
	'coll-limit_exceeded_text' => 'Vaša knjiga je prevelika.
Nove stranice ne mogu biti dodane.',
	'coll-rendering_title' => 'Izvođenje',
	'coll-rendering_text' => '<p><strong>Molimo pričekajte dok se dokument radi.</strong></p>

<p><strong>Razvoj:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Ova stranice bi se trebala automatski osvježiti svakih par sekundi.
Ako ovo ne radi, molimo pritisnite tipku za osvježavanje u svom pregledniku.</p>',
	'coll-rendering_status' => '<strong>Stanje:</strong> $1',
	'coll-rendering_article' => '(wiki stranica: $1)',
	'coll-rendering_page' => '(stranica: $1)',
	'coll-rendering_finished_title' => 'Izvođenje završeno',
	'coll-rendering_finished_text' => '<strong>Datoteka dokumenta je stvorena.</strong>
<strong>[$1 Preuzmite datoteku]</strong> na svoje računalo.

Napomene:
* Niste zadovoljni dobivenim rezultatom? Pogledajte [[{{MediaWiki:Coll-helppage}}|
stranicu za pomoć o zbirkama]] za mogućnosti njegovog poboljšanja.',
	'coll-notfound_title' => 'Knjiga nije nađena',
	'coll-notfound_text' => 'Ne mogu pronaći stranicu knjige.',
	'coll-is_cached' => '<ul><li>Pronađena je verzija datoteke u pričuvnoj memoriji, stoga izvođenje datoteke nije potrebno.. <a href="$1">Zahtijevaj ponovno izvođenje.</a></li></ul>',
	'coll-excluded-templates' => '* Predlošci u kategoriji [[:Category:$1|$1]] su ostali isključeni.',
	'coll-blacklisted-templates' => '* Predlošci na crnoj listi [[:$1]] su ostali isključeni.',
	'coll-return_to_collection' => '<p>Vrati se na <a href="$1">$2</a></p>',
	'coll-book_title' => 'Naručite kao ispisanu knjigu',
	'coll-book_text' => 'Naručiti ispisanu knjigu od slijedećih partnera za ispisivanje na zahtjev (POD):',
	'coll-order_from_pp' => 'Naručite knjigu od $1',
	'coll-about_pp' => 'O $1',
	'coll-invalid_podpartner_title' => 'Neispravan POD partner',
	'coll-invalid_podpartner_msg' => 'Ponuđeni POD partner nije valjan.
Molimo kontaktirajte svog MediaWiki administratora.',
	'coll-license' => 'Licencija',
	'coll-return_to' => 'Vrati se na [[:$1]]',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'coll-desc' => '[[Special:Book|Knihi wutworić]]',
	'coll-collection' => 'Kniha',
	'coll-collections' => 'Knihi',
	'coll-exclusion_category_title' => 'Wot ćišćenja wuzamknyć',
	'coll-print_template_prefix' => 'Ćišćeć',
	'coll-print_template_pattern' => '$1/Ćišćeć',
	'coll-create_a_book' => 'Knihu wutworić',
	'coll-add_page' => 'Wikijowu stronu přidać',
	'coll-add_page_tooltip' => 'Aktualnu wikijowu stronu twojej knize přidać',
	'coll-remove_page' => 'Wikijowu stronu wotstronić',
	'coll-remove_page_tooltip' => 'Aktualnu wikijowu stronu z twojeje knihi wotstronić',
	'coll-add_category' => 'Kategoriju přidać',
	'coll-add_category_tooltip' => 'Wšě nastawki w tutej kategoriji twojej knize přidać',
	'coll-load_collection' => 'Knihu začitać',
	'coll-load_collection_tooltip' => 'Tutu knihu jako twoju aktualnu knihu začitać',
	'coll-show_collection' => 'Knihu pokazać',
	'coll-show_collection_tooltip' => 'Klikń, zo by swoju knihu wobdźěłał/sćahnył/skazał',
	'coll-help_collections' => 'Pomoc ke kniham',
	'coll-help_collections_tooltip' => 'Pomoc wo knižnej funkciji pokazać',
	'coll-n_pages' => '$1 {{PLURAL:$1|strona|stronje|strony|stronow}}',
	'coll-unknown_subpage_title' => 'Njeznata podstrona',
	'coll-unknown_subpage_text' => 'Tuta podstrona [[Special:Book|knihi]] njeeksistuje',
	'coll-printable_version_pdf' => 'PDF-wersija',
	'coll-download_as' => 'Jako $1 sćahnyć',
	'coll-noscript_text' => '<h1>JavaScript je trěbny!</h1>
<strong>Twój wobhladowak njepodpěruje JavaScript abo JavaScript je wupinjeny.
Tuta strona njebudźe prawje fungować, doniž JavaScript zmóžnjeny njeje.</strong>',
	'coll-intro_text' => 'Wutwor a zrjaduj swój indiwiduelny wuběr wikijowych stronow.<br />Hlej [[{{MediaWiki:Coll-helppage}}|Pomoc wo zběrkach]] za dalše informacije.',
	'coll-helppage' => 'Help:Knihi',
	'coll-bookscategory' => 'Knihi',
	'coll-savedbook_template' => 'składowana_kniha',
	'coll-your_book' => 'Twoja kniha',
	'coll-download_title' => 'Sćahnyć',
	'coll-download_text' => 'Zo by wersiju offline sćahnył, wubjer format a klikń na tłóčatko.',
	'coll-download_as_text' => 'Zo by wersiju offline w formaće $1 sćahnył, klikń na tłóčatko.',
	'coll-download' => 'Sćahnyć',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Wotstronić',
	'coll-show' => 'Pokazać',
	'coll-move_to_top' => 'Cyle horje přesunyć',
	'coll-move_up' => 'Horje přesunyć',
	'coll-move_down' => 'Dele přesunyć',
	'coll-move_to_bottom' => 'Cyle dele přesunyć',
	'coll-title' => 'Titul:',
	'coll-subtitle' => 'Podtitul:',
	'coll-contents' => 'Wobsah',
	'coll-drag_and_drop' => 'Přez přesunjenje z myšu móžeš wikijowe strony a kapitle přerjadować',
	'coll-create_chapter' => 'Kapitl wutworić',
	'coll-sort_alphabetically' => 'Alfabetisce sortěrować',
	'coll-clear_collection' => 'Knihu wuprózdnić',
	'coll-clear_collection_tooltip' => 'Wšě nastawki z twojeje aktualneje knihi wotstronić',
	'coll-clear_collection_confirm' => 'Chceš woprawdźe swoju knihu dospołnje wuprózdnić?',
	'coll-rename' => 'Přemjenować',
	'coll-new_chapter' => 'Zapodaj mjeno za nowy kapitl',
	'coll-rename_chapter' => 'Zapodaj nowe mjeno za kapitl',
	'coll-no_such_category' => 'Žana tajka kategorija',
	'coll-notitle_title' => 'Titul strony njeda so zwěsćić.',
	'coll-post_failed_title' => 'Naprašowanje POST njeporadźiło',
	'coll-post_failed_msg' => 'Naprašowanje POST do $1 je so njeporadźiło ($2).',
	'coll-mwserve_failed_title' => 'Zmylk tworjenskeho serwera',
	'coll-mwserve_failed_msg' => 'Zmylk je na serwerje tworjenja wustupił: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Serwer je zmylk zdźělił',
	'coll-empty_collection' => 'Prózdna kniha',
	'coll-revision' => 'Wersija: $1',
	'coll-save_collection_title' => 'Twoju knihu składować a dźělić',
	'coll-save_collection_text' => 'Wubjer městno:',
	'coll-login_to_save' => 'Jeli chceš knihi za pozdźiše wužiwanje składować, [[Special:UserLogin|přizjew so abo wutwor konto]].',
	'coll-personal_collection_label' => 'Wosobinska kniha:',
	'coll-community_collection_label' => 'Kniha zhromadźenstwa:',
	'coll-save_collection' => 'Knihu składować',
	'coll-save_category' => 'Knihi składuja so w kategoriji [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Strona eksistuje. Přepisać?',
	'coll-overwrite_text' => 'Strona z mjenom [[:$1]] hižo eksistuje.
Chceš ju přez swoju zběrku narunać?',
	'coll-yes' => 'Haj',
	'coll-no' => 'Ně',
	'coll-load_overwrite_text' => 'Maš hižo někotre strony w swojej knize.
Chceš swoju aktualnu knihu přepisać, nowy wobsah přidać abo začitanje tuteje knihi přetorhnyć?',
	'coll-overwrite' => 'Přepisać',
	'coll-append' => 'Připójsnyć',
	'coll-cancel' => 'Přetorhnyć',
	'coll-update' => 'Aktualizować',
	'coll-limit_exceeded_title' => 'Kniha přewulka',
	'coll-limit_exceeded_text' => 'Twoja kniha je přewulka.
Njadadźa so hižo žane strony přidać.',
	'coll-rendering_title' => 'Tworjenje',
	'coll-rendering_text' => '<p><strong>Prošu počakń trochu, doniž dokument njeje so wutworjeny.</strong></p>

<p><strong>Postup:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Tuta strona dyrbjała so awtomatisce kóžde por sekundow aktualizować.
Jeli so to njestawa, klikń prošu na tłóčatko "Znowa" swojeho wobhladowaka.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wikijowa strona: $1)',
	'coll-rendering_page' => '(strona: $1)',
	'coll-rendering_finished_title' => 'Tworjenje dokónčene',
	'coll-rendering_finished_text' => '<strong>Dokumentowa dataja je so wuspěšnje wutworiła.</strong>
<strong>[$1 Dataju na twój ličak sćahnyć]</strong>.

Přispomnjenka:
* Njejsy spokojny z wudaćom? Hlej [[{{MediaWiki:Coll-helppage}}|stronu pomocy wo zběrkach]] za móžnosće je polěpšić.',
	'coll-notfound_title' => 'Kniha njenamakana',
	'coll-notfound_text' => 'Strona knihi njebu namakana.',
	'coll-is_cached' => '<ul><li>Pufrowana wersija dokumenta bu namakana, tohodla tworjenje njeje trěbne było. <a href="$1">Znowatworjenje wunuzować.</a></li></ul>',
	'coll-excluded-templates' => '* Předłohi w kategoriji [[:Category:$1|$1]] buchu wuzamknjene.',
	'coll-blacklisted-templates' => '* Předłohi na čornej lisćinje [[:$1]] buchu wuzamknjene.',
	'coll-return_to_collection' => '<p>Wróćo k <a href="$1">$2</a></p>',
	'coll-book_title' => 'Jako wućišćanu knihu skazać',
	'coll-book_text' => 'Wućišćanu knihu wot našeho partnera za ćišćenje na žadanje:',
	'coll-order_from_pp' => 'Knihu pola $1 skazać',
	'coll-about_pp' => 'Wo $1',
	'coll-invalid_podpartner_title' => 'Njepłaćiwy partner za ćišć na žadanje',
	'coll-invalid_podpartner_msg' => 'Podaty partner za ćišć na žadanje je njepłaćiwy.
Skontaktuj prošu swojeho administratora MediaWiki.',
	'coll-license' => 'Licenca',
	'coll-return_to' => 'Wróćo k [[:$1]]',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 */
$messages['hu'] = array(
	'coll-desc' => '[[Special:Book|Készíts könyveket!]]',
	'coll-collection' => 'Könyv',
	'coll-collections' => 'Könyvek',
	'coll-exclusion_category_title' => 'Nyomtatásban kihagyandó',
	'coll-print_template_prefix' => 'Nyomtatott',
	'coll-create_a_book' => 'Készíts egy könyvet',
	'coll-add_page' => 'Wiki oldal hozzáadása',
	'coll-remove_page' => 'Wiki oldal eltávolítása',
	'coll-add_category' => 'Kategória hozzáadása',
	'coll-load_collection' => 'Könyv betöltése',
	'coll-show_collection' => 'Könyv mutatása',
	'coll-help_collections' => 'Könyvek segítség',
	'coll-n_pages' => '$1 oldal',
	'coll-unknown_subpage_title' => 'Ismeretlen aloldal',
	'coll-unknown_subpage_text' => 'A [[Special:Book|könyv]] ezen allapja nem létezik.',
	'coll-printable_version_pdf' => 'PDF változat',
	'coll-download_as' => 'Letöltés mint $1',
	'coll-noscript_text' => '<h1>JavaScript szüséges!</h1>
<strong>A böngésződ nem támogatja a JavaScriptet, vagy az ki lett kapcsolva.
Ez az oldal nem működik megfelelően amíg a JavaScript nincs bekapcsolva.</strong>',
	'coll-intro_text' => 'Készíts és kezelj saját wiki oldal gyűjteményeket.<br />Lásd [[{{MediaWiki:Coll-helppage}}]] oldalt további információkért.',
	'coll-helppage' => 'Segítség:Könyvek',
	'coll-bookscategory' => 'Könyvek',
	'coll-savedbook_template' => 'elmentett_könyv',
	'coll-your_book' => 'A Te könyved',
	'coll-download_title' => 'Letöltés',
	'coll-download_text' => 'Egy változat letöltéséhez válaszd ki a formátumot és nyomd meg a gombot!',
	'coll-download_as_text' => '$1 formátumú változat letöltéséhez nyomd meg a gombot!',
	'coll-download' => 'Letöltés',
	'coll-format_label' => 'Formátum:',
	'coll-remove' => 'Eltávolítás',
	'coll-show' => 'Mutat',
	'coll-move_to_top' => 'Tetejére mozgat',
	'coll-move_up' => 'Feljebb mozgat',
	'coll-move_down' => 'Lejjebb mozgat',
	'coll-move_to_bottom' => 'Alulra mozgat',
	'coll-title' => 'Cím:',
	'coll-subtitle' => 'Alcím:',
	'coll-contents' => 'Tartalomjegyzék',
	'coll-drag_and_drop' => 'Fogd és vidd módszerrel rendezd át a wiki oldalak és fejezetek sorrendjét',
	'coll-create_chapter' => 'Fejezet készítése',
	'coll-sort_alphabetically' => 'Rendezés ábécésorrend szerint',
	'coll-clear_collection' => 'Könyv törlése',
	'coll-clear_collection_confirm' => 'Valóban törölni szeretnéd a könyved?',
	'coll-rename' => 'Átnevezés',
	'coll-new_chapter' => 'Írd be az új fejezet címét',
	'coll-rename_chapter' => 'Add meg a fejezet új címét',
	'coll-no_such_category' => 'Nincs ilyen kategória',
	'coll-notitle_title' => 'Az oldal címe nem volt megállapítható.',
	'coll-post_failed_title' => 'POST kérés sikertelen',
	'coll-post_failed_msg' => 'A $1-nak küldött POST kérés sikertelen ($2).',
	'coll-mwserve_failed_title' => 'A renderelő szerver hibát észlelt',
	'coll-mwserve_failed_msg' => 'Hiba történt a renderelő szerveren: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Hibaüzenet érkezett a szervertől',
	'coll-empty_collection' => 'Üres könyv',
	'coll-revision' => 'Változat: $1',
	'coll-save_collection_title' => 'Mentsd el és oszd meg a könyved',
	'coll-save_collection_text' => 'Válassz egy tárolási helyet a könyvednek:',
	'coll-login_to_save' => 'Amennyiben elszeretnéd menteni a könyved későbbi használatra, kérlek [[Special:UserLogin|jelentkezz be vagy készíts egy felhasználói fiókot]].',
	'coll-personal_collection_label' => 'Személyes könyv:',
	'coll-community_collection_label' => 'Közösségi könyv:',
	'coll-save_collection' => 'Könyv mentése',
	'coll-save_category' => 'A könyvek a [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] kategóriába mentődnek.',
	'coll-overwrite_title' => 'Az oldal már létezik.
Felülírjam?',
	'coll-overwrite_text' => '„[[:$1]]” nevű oldal már létezik.
Szeretnéd lecserélni a saját könyvedre?',
	'coll-yes' => 'Igen',
	'coll-no' => 'Nem',
	'coll-load_overwrite_text' => 'Már van néhány oldal a könyvedben.
Szeretnéd felülírni, az új tartalommal kiegészíteni a könyved vagy abbahagyni e könyv betöltését?',
	'coll-overwrite' => 'Felülír',
	'coll-append' => 'Hozzáad',
	'coll-cancel' => 'Mégse',
	'coll-update' => 'Frissít',
	'coll-limit_exceeded_title' => 'A könyv túl nagy',
	'coll-limit_exceeded_text' => 'A könyved túl nagy.
Nem lehet több oldalt hozzáadni.',
	'coll-rendering_title' => 'Renderelés',
	'coll-rendering_text' => '<p><strong>Kérlek várj amíg a dokumentum elkészül!</strong></p>

<p><strong>Készültség:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Ez az oldal automatikusan frissül pár másodpercenként.
Ha ez nem történik meg, kérlek nyomd meg a böngésződ frissítés gombját!</p>',
	'coll-rendering_status' => '<strong>Állapot:</strong> $1',
	'coll-rendering_article' => '(wiki oldal: $1)',
	'coll-rendering_page' => '(oldal: $1)',
	'coll-rendering_finished_title' => 'A renderelés befejeződött',
	'coll-rendering_finished_text' => '<strong>A dokumentum ekészült.</strong>
<strong>[$1 Töltsd le a fájlt]</strong> a számítógépedre.

Megjegyzés:
* Nem vagy elégedett az eredménnyel? Lásd a  [[{{MediaWiki:Coll-helppage}}|könyvekről szóló segítség oldalt]] a javítási lehetőségekről.',
	'coll-notfound_title' => 'A könyv nem található',
	'coll-notfound_text' => 'A könyvoldal nem található.',
	'coll-is_cached' => '<ul><li>A dokumentum egy gyorsítótárazott változata megtalálható volt így nem volt szükség renderelésre.<a href="$1">Újra renderelés kényszerítése.</a></li></ul>',
	'coll-excluded-templates' => 'A(z) [[:Category:$1|$1]] kategóriában lévő sablonok figyelmen kívül lettek hagyva.',
	'coll-blacklisted-templates' => '* A(z) [[:$1]] feketelistán található sablonok figyelmen kívül lettek hagyva.',
	'coll-return_to_collection' => '<p>Visszatérés ide: <a href="$1">$2</a></p>',
	'coll-book_title' => 'Megrendelés nyomtatott könyvként',
	'coll-book_text' => 'Nyomtatott könyv rendelése a kérésre nyomtató partnerünktől:',
	'coll-order_from_pp' => 'Könyv rendelése a következőtől: $1',
	'coll-about_pp' => 'A $1ről',
	'coll-invalid_podpartner_title' => 'Érvénytelen nyomdai partner',
	'coll-invalid_podpartner_msg' => 'A megadott nyomdai partner érvénytelen.
Kérlek lépj kapcsolatba a MediaWiki adminisztrátoroddal.',
	'coll-license' => 'Licenc',
	'coll-return_to' => 'Visszatérés a(z) [[:$1]] laphoz',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'coll-desc' => '[[Special:Book|Ստեղծել գրքեր]]',
	'coll-collection' => 'Գիրք',
	'coll-collections' => 'Գրքեր',
	'coll-exclusion_category_title' => 'Չընդգրկել տպագրման մեջ',
	'coll-print_template_prefix' => 'Տպման',
	'coll-print_template_pattern' => '$1/Տպման',
	'coll-create_a_book' => 'Ստեղծել գիրք',
	'coll-add_page' => 'Ավելացնել էջը',
	'coll-remove_page' => 'Ջնջել էջը',
	'coll-add_category' => 'Ավելացնել կատեգորիան',
	'coll-load_collection' => 'Բեռնել գիրքը',
	'coll-show_collection' => 'Ցույց տալ գիրքը',
	'coll-help_collections' => 'Գրքի օգնություն',
	'coll-n_pages' => '$1 {{PLURAL:$1|էջ|էջ}}',
	'coll-unknown_subpage_title' => 'Անհայտ ենթաէջ',
	'coll-unknown_subpage_text' => '[[Special:Book|Գրքի]] այս ենթաէջը գոյություն չունի',
	'coll-printable_version_pdf' => 'PDF-տարբերակ',
	'coll-download_as' => 'Քաշել որպես $1',
	'coll-noscript_text' => '<h1>Պահանջո՜ւմ է JavaScript։</h1>
<strong>Ձեր բրաուզերը չունի JavaScript հնարավորություն կամ JavaScript-ը անջատած է։
Այս էջը ճիշտ չի գործի, եթե JavaScript-ը միացված չէ։</strong>',
	'coll-intro_text' => 'Ստեղծեք և կառավարեք վիքի էջերի ձեր անջնական հավաքածուն։<br />Մանրամասների համար տես [[{{MediaWiki:Coll-helppage}}]]։',
	'coll-helppage' => 'Help:Գրքեր',
	'coll-bookscategory' => 'Գրքեր',
	'coll-savedbook_template' => 'պահպանված_գիրք',
	'coll-your_book' => 'Ձեր գիրքը',
	'coll-download_title' => 'Քաշել',
	'coll-download_text' => 'Որևէ տարբերակ քաշելու համար ընտրեք ֆորմատը և սեղմեք կոճակը։',
	'coll-download_as_text' => '$1 ֆորմատով տարբերակը քաշելու համար սեղմեք կոճակը։',
	'coll-download' => 'Քաշել',
	'coll-format_label' => 'Ֆորմատ.',
	'coll-remove' => 'Ջնջել',
	'coll-show' => 'Ցույց տալ',
	'coll-move_to_top' => 'Տեղափոխել ամենավերև',
	'coll-move_up' => 'Տեղափոխել վերև',
	'coll-move_down' => 'Տեղափոխել ներքև',
	'coll-move_to_bottom' => 'Տեղափոխել ամենատակը',
	'coll-title' => 'Վերնագիր.',
	'coll-subtitle' => 'Ենթավերնագիր.',
	'coll-contents' => 'Բովանդակություն',
	'coll-drag_and_drop' => 'Վիքի էջերը և գլուխները վերադասավորելու համար քաշեք-տարեք մկնիկով',
	'coll-create_chapter' => 'Ստեղծել նոր գլուխ',
	'coll-sort_alphabetically' => 'Դասավորել այբուբենով',
	'coll-clear_collection' => 'Ջնջել գիրքը',
	'coll-clear_collection_confirm' => 'Դուք իսկապես ցանկանում եք ամբողջությամբ ջնջե՞լ ձեր գիրքը։',
	'coll-rename' => 'Վերանվանել',
	'coll-new_chapter' => 'Մուտքագրեք նոր գլխի վերնագիրը',
	'coll-rename_chapter' => 'Մուտքագրեք գլխի նոր վերնագիրը',
	'coll-no_such_category' => 'Այդպիսի կատեգորիա չկա',
	'coll-notitle_title' => 'Էջի անվանումը հնարավոր չէ որոշել։',
	'coll-post_failed_title' => 'POST հայցումը ձախողվեց',
	'coll-post_failed_msg' => 'POST հայցումը $1-ին ձախողվեց ($2)։',
	'coll-mwserve_failed_title' => 'Ստեղծման սերվերի սխալ',
	'coll-mwserve_failed_msg' => 'Ստեղծման սերվերի վրա սխալ է տեղի ունեցել. <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Սխալ պատասխան սերվերից',
	'coll-empty_collection' => 'Դատարկ գիրք',
	'coll-revision' => 'Տարբերակ. $1',
	'coll-save_collection_title' => 'Պահպանել գիրքը և կիսել ուրիշների հետ',
	'coll-save_collection_text' => 'Ընտրեք ձեր գրքի պահպանման վայրը.',
	'coll-login_to_save' => 'Եթե դուք ուզում եք պահպանել գիրքը հետագա օգտագործման համար, ապապ խնդրում ենք [[Special:UserLogin|մտնել համակարգ կամ գրանցվել]]։',
	'coll-personal_collection_label' => 'Անձնական գիրք.',
	'coll-community_collection_label' => 'Համայնքի գիրք.',
	'coll-save_collection' => 'Պահպանել գիրքը',
	'coll-save_category' => 'Բոլոր գրքերը պահպանված են [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] կատեգորիայում։',
	'coll-overwrite_title' => 'Այդպիսի էջ գոյություն ունի։
Վերգրե՞լ։',
	'coll-overwrite_text' => '[[:$1]] էջը արդեն գոյություն ունի։
Ցանկանո՞ւմ եք այն փոխարինել ձեր գրքով։',
	'coll-yes' => 'Այո',
	'coll-no' => 'Ոչ',
	'coll-load_overwrite_text' => 'Դուք արդեն ունեք որոշ էջեր ձեր գրքում։
Ցանկանում եք վերգրե՞լ ընթացիք գիրքը, ավելացնե՞լ նոր նյութը, թե բեկանե՞լ գրքի բեռնումը։',
	'coll-overwrite' => 'Վերգրել',
	'coll-append' => 'Ավելացնել',
	'coll-cancel' => 'Բեկանել',
	'coll-update' => 'Թարմացնել',
	'coll-limit_exceeded_title' => 'Գիրքը շատ մեծ է',
	'coll-limit_exceeded_text' => 'Ձեր գիրքը շատ մեծ է։
Նոր էջեր չեն կարող ավելացվել։',
	'coll-rendering_title' => 'Ստեղծում',
	'coll-rendering_text' => '<p><strong>Խնդրում ենք սպասել մինչև ֆայլը ստեղծվում է։</strong></p>

<p><strong>Ընթացքը.</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Այս էջը պետք է ավտոմատիկ թարմացվի վայրկյանում մի քանի անգամ։
Եթե դա տեղի չի ունենում, ապա խնդրում ենք սեղմել ձեր բրաուզերի «թարմացնել» կոճակը։</p>',
	'coll-rendering_status' => '<strong>Կարգավիճակ.</strong> $1',
	'coll-rendering_article' => '(վիքի էջ. $1)',
	'coll-rendering_page' => '(էջ. $1)',
	'coll-rendering_finished_title' => 'Ստեղծումն ավարտված է',
	'coll-rendering_finished_text' => '<strong>Ֆայլը ստեղծված է։</strong>
<strong>[$1 Քաշել ֆայլը]</strong> ձեր համակարգչի մեջ։

Նշում.
* Բավարարված չե՞ք արդյունքով։ Տես [[{{MediaWiki:Coll-helppage}}|գրքերի մասին օգնության էջը]] այն լավացնելու հնարավորությունների համար։',
	'coll-notfound_title' => 'Գիրքը չգտնվեց',
	'coll-notfound_text' => 'Հնարավոր չէ գտնել գրքի էջը։',
	'coll-is_cached' => '<ul><li>Այս ֆայլի պատճենը կա քեշում, ուստի ստեղծում չի պահանջվում։ <a href="$1">Հարկադրել վերստեղծում։</a></li></ul>',
	'coll-excluded-templates' => '* [[:Category:$1|$1]] կատեգորիայի կաղապարները չեն ընդգրկվել։',
	'coll-blacklisted-templates' => '* [[:$1]] սև ցուցակի կաղապարները չեն ընդգրկվել։',
	'coll-return_to_collection' => '<p>Վերադառնալ <a href="$1">$2</a></p>',
	'coll-book_title' => 'Պատվիրել որպես տպագիր գիրք',
	'coll-book_text' => 'Ստանալ տպագիր գիրքը մեր գործակցից.',
	'coll-order_from_pp' => 'Պատվիրել գիրքը $1-ից',
	'coll-about_pp' => '$1-ի մասին',
	'coll-invalid_podpartner_title' => 'Չգործող POD գործընկեր',
	'coll-invalid_podpartner_msg' => 'Առաջարկված POD գործընկերը չի գործում։
Խնդրում ենք կապնվել ձեր MediaWiki ադմինիստրատորի հետ։',
	'coll-license' => 'Լիցենզիա',
	'coll-return_to' => 'Վերադառնալ [[:$1]]',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'coll-desc' => '[[Special:Book|Crear libros]]',
	'coll-collection' => 'Libro',
	'coll-collections' => 'Libros',
	'coll-exclusion_category_title' => 'Excluder del impression',
	'coll-print_template_prefix' => 'Imprimer',
	'coll-print_template_pattern' => '$1/Imprimer',
	'coll-create_a_book' => 'Crear un libro',
	'coll-add_page' => 'Adder un pagina wiki',
	'coll-remove_page' => 'Remover pagina wiki',
	'coll-add_category' => 'Adder categoria',
	'coll-load_collection' => 'Cargar libro',
	'coll-show_collection' => 'Monstrar libro',
	'coll-help_collections' => 'Adjuta super le libros',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagina|paginas}}',
	'coll-unknown_subpage_title' => 'Subpagina incognite',
	'coll-unknown_subpage_text' => 'Iste subpagina de [[Special:Book|Libro]] non existe',
	'coll-printable_version_pdf' => 'Version PDF',
	'coll-download_as' => 'Discargar como $1',
	'coll-noscript_text' => '<h1>JavaScript es requirite!</h1>
<strong>Tu navigator non supporta JavaScript o JavaScript ha essite disactivate.
Iste pagina non functionara correctemente si JavaScript non es activate.</strong>',
	'coll-intro_text' => 'Crea e gere tu selection personal de paginas wiki.<br />Vide [[{{MediaWiki:Coll-helppage}}]] pro ulterior informationes.',
	'coll-helppage' => 'Help:Libros',
	'coll-bookscategory' => 'Libros',
	'coll-savedbook_template' => 'libro_immagazinate',
	'coll-your_book' => 'Tu libro',
	'coll-download_title' => 'Discargar',
	'coll-download_text' => 'Pro discargar un version foras linea, selige un formato e clicca super le button.',
	'coll-download_as_text' => 'Pro discargar un version in le formatio $1 clicca super le button.',
	'coll-download' => 'Discargar',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Remover',
	'coll-show' => 'Monstrar',
	'coll-move_to_top' => 'Displaciar al initio',
	'coll-move_up' => 'Displaciar in alto',
	'coll-move_down' => 'Displaciar a basso',
	'coll-move_to_bottom' => 'Displaciar al fin',
	'coll-title' => 'Titulo:',
	'coll-subtitle' => 'Subtitulo:',
	'coll-contents' => 'Contento',
	'coll-drag_and_drop' => 'Usa "traher & lassar cader" pro reordinar le paginas wiki e le capitulos',
	'coll-create_chapter' => 'Crear capitulo',
	'coll-sort_alphabetically' => 'Ordinar alphabeticamente',
	'coll-clear_collection' => 'Vacuar libro',
	'coll-clear_collection_confirm' => 'Esque tu realmente vole vacuar completemente tu libro?',
	'coll-rename' => 'Renominar',
	'coll-new_chapter' => 'Entra nomine pro nove capitulo',
	'coll-rename_chapter' => 'Entra nove nomine pro capitulo',
	'coll-no_such_category' => 'Categoria non existe',
	'coll-notitle_title' => 'Le titulo del pagina non poteva esser determinate.',
	'coll-post_failed_title' => 'Requesta POST fallite',
	'coll-post_failed_msg' => 'Le requesta POST a $1 falleva ($2).',
	'coll-mwserve_failed_title' => 'Error del servitor de renditiones',
	'coll-mwserve_failed_msg' => 'Un error ha occurrite in le servitor de renditiones: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Responsa de error ab servitor',
	'coll-empty_collection' => 'Libro vacue',
	'coll-revision' => 'Version: $1',
	'coll-save_collection_title' => 'Immagazinar tu libro pro uso in commun',
	'coll-save_collection_text' => 'Selige un location:',
	'coll-login_to_save' => 'Si tu vole immagazinar libros pro uso futur, per favor [[Special:UserLogin|aperi un session o crea un conto]].',
	'coll-personal_collection_label' => 'Libro personal:',
	'coll-community_collection_label' => 'Libro communitari:',
	'coll-save_collection' => 'Immagazinar libro',
	'coll-save_category' => 'Le libros es immagazinate in le categoria [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Le pagina existe ja.
Superscriber lo?',
	'coll-overwrite_text' => 'Existe ja un pagina con le nomine [[:$1]].
Esque tu vole reimplaciar lo con tu collection?',
	'coll-yes' => 'Si',
	'coll-no' => 'No',
	'coll-load_overwrite_text' => 'Tu ha ja alcun paginas in tu libro.
Esque tu vole superscriber tu libro actual, adjunger le nove contento, o cancellar le cargamento de iste libro?',
	'coll-overwrite' => 'Superscriber',
	'coll-append' => 'Appender',
	'coll-cancel' => 'Cancellar',
	'coll-update' => 'Actualisar',
	'coll-limit_exceeded_title' => 'Libro troppo grande',
	'coll-limit_exceeded_text' => 'Tu libro es troppo grande.
Non es possibile adder plus paginas.',
	'coll-rendering_title' => 'Rendition',
	'coll-rendering_text' => '<p><strong>Per favor attende durante le generation del documento.</strong></p>

<p><strong>Progresso:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Iste pagina deberea refrescar se automaticamente cata pauc secundas.
Si isto non functiona, per favor preme le button de refrescar in tu navigator.</p>',
	'coll-rendering_status' => '<strong>Stato:</strong> $1',
	'coll-rendering_article' => '(pagina wiki: $1)',
	'coll-rendering_page' => '(pagina: $1)',
	'coll-rendering_finished_title' => 'Rendition finite',
	'coll-rendering_finished_text' => '<strong>Le file del documento ha essite generate.</strong>
<strong>[$1 Discarga le file]</strong> verso tu computator.

Notas:
* Non satisfacite con le resultato? Vide [[{{MediaWiki:Coll-helppage}}|le pagina de adjuta super le libros]] pro possibilitates de meliorar lo.',
	'coll-notfound_title' => 'Libro non trovate',
	'coll-notfound_text' => 'Non poteva trovar le pagina del libro.',
	'coll-is_cached' => '<ul><li>Un version del documento ha essite trovate in le cache, ergo non esseva necessari facer un altere rendition. <a href="$1">Fortiar le re-rendition.</a></li></ul>',
	'coll-excluded-templates' => '* Le patronos in le categoria [[:Category:$1|$1]] ha essite excludite.',
	'coll-blacklisted-templates' => '* Le patronos in le lista nigre [[:$1]] ha essite excludite.',
	'coll-return_to_collection' => '<p>Retornar a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Commandar como libro imprimite',
	'coll-book_text' => 'Obtene un libro imprimite de nostre partenario de impression a requesta (print on demand):',
	'coll-order_from_pp' => 'Commandar libro ab $1',
	'coll-about_pp' => 'A proposito de $1',
	'coll-invalid_podpartner_title' => 'Partenario de impression a requesta (POD) non valide',
	'coll-invalid_podpartner_msg' => 'Le partenario indicate de impression a requesta (POD) non es valide.
Per favor contacta tu administrator de MediaWiki.',
	'coll-license' => 'Licentia',
	'coll-return_to' => 'Retornar a [[:$1]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'coll-title' => 'Judul:',
	'coll-yes' => 'Ya',
	'coll-no' => 'Tidak',
	'coll-cancel' => 'Batalkan',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'coll-desc' => '[[Special:Book|Kreez libri]]',
	'coll-collection' => 'Libro',
	'coll-collections' => 'Libri',
	'coll-print_template_prefix' => 'Imprimar',
	'coll-create_a_book' => 'Kreez un libro',
	'coll-add_category' => 'Adjuntar kategorio',
	'coll-load_collection' => 'Kargar libro',
	'coll-show_collection' => 'Montrar libro',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagino|pagini}}',
	'coll-printable_version_pdf' => 'Versiono PDF',
	'coll-helppage' => 'Help:Libri',
	'coll-bookscategory' => 'Libri',
	'coll-your_book' => 'Vua libro',
	'coll-format_label' => 'Formato:',
	'coll-show' => 'Montrez',
	'coll-title' => 'Titulo:',
	'coll-contents' => 'Kontenajo',
	'coll-rename' => 'Rinomar',
	'coll-empty_collection' => 'Vakua libro',
	'coll-save_collection' => 'Registragar libro',
	'coll-yes' => 'Yes',
	'coll-no' => 'No',
	'coll-limit_exceeded_title' => 'Libro tro granda',
	'coll-rendering_status' => '<strong>Stando:</strong> $1',
	'coll-rendering_page' => '(pagino: $1)',
	'coll-about_pp' => 'Pri $1',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'coll-collection' => 'Safn',
	'coll-collections' => 'Söfn',
	'coll-create_a_book' => 'Safnið mitt',
	'coll-add_page' => 'Bæta við síðu',
	'coll-remove_page' => 'Fjarlægja síðu',
	'coll-add_category' => 'Bæta við flokki',
	'coll-load_collection' => 'Hlaða safn',
	'coll-show_collection' => 'Sýna safn',
	'coll-help_collections' => 'Safnhjálp',
	'coll-remove' => 'Fjarlægja',
	'coll-title' => 'Titill:',
	'coll-rename' => 'Endurnefna',
	'coll-new_chapter' => 'Sláðu inn nafn á nýjum kafla',
	'coll-rename_chapter' => 'Sláðu inn nýtt nafn fyrir kafla',
	'coll-no_such_category' => 'Flokkur ekki til',
	'coll-save_collection' => 'Vista safn',
	'coll-yes' => 'Já',
	'coll-no' => 'Nei',
	'coll-overwrite' => 'Yfirrita',
	'coll-append' => 'Auka við',
	'coll-cancel' => 'Hætta við',
	'coll-limit_exceeded_title' => 'Safn of stórt',
	'coll-notfound_title' => 'Safn fannst ekki',
	'coll-order_from_pp' => 'Panta bók frá $1',
	'coll-about_pp' => 'Um $1',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
 */
$messages['it'] = array(
	'coll-desc' => '[[Special:Book|Crea libri]]',
	'coll-collection' => 'Libro',
	'coll-collections' => 'Libri',
	'coll-exclusion_category_title' => 'Escludi dalla stampa',
	'coll-print_template_prefix' => 'Stampa',
	'coll-print_template_pattern' => '$1/Stampa',
	'coll-create_a_book' => 'Crea un libro',
	'coll-add_page' => 'Aggiungi pagina wiki',
	'coll-remove_page' => 'Rimuovi pagina wiki',
	'coll-add_category' => 'Aggiungi categoria',
	'coll-load_collection' => 'Carica libro',
	'coll-show_collection' => 'Mostra libro',
	'coll-help_collections' => 'Aiuto sui libri',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagina|pagine}}',
	'coll-unknown_subpage_title' => 'Sottopagina sconosciuta',
	'coll-unknown_subpage_text' => 'Questa sottopagina di [[Special:Book|Libro]] non esiste',
	'coll-printable_version_pdf' => 'Versione PDF',
	'coll-download_as' => 'Scarica come $1',
	'coll-noscript_text' => '<h1>È necessario avere JavaScript!</h1>
<strong>Il tuo browser non supporta JavaScript oppure JavaScript è stato disattivato.
La pagina non funzionerà correttamente se non verrà attivato JavaScript.</strong>',
	'coll-intro_text' => 'Crea e gestisci le tue selezioni personali di pagine wiki.<br />Leggi [[{{MediaWiki:Coll-helppage}}]]',
	'coll-helppage' => 'Help:Libri',
	'coll-bookscategory' => 'Libri',
	'coll-savedbook_template' => 'libro_salvato',
	'coll-your_book' => 'Il tuo libro',
	'coll-download_title' => 'Scarica',
	'coll-download_text' => 'Per scaricare una versione offline scegli un formato e fai clic sul pulsante.',
	'coll-download_as_text' => 'Per scaricare una versione nel formato $1 fare clic sul pulsante.',
	'coll-download' => 'Scarica',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Rimuovi',
	'coll-show' => 'Mostra',
	'coll-move_to_top' => "Sposta all'inizio",
	'coll-move_up' => 'Sposta più su',
	'coll-move_down' => 'Sposta più giù',
	'coll-move_to_bottom' => 'Sposta in fondo',
	'coll-title' => 'Titolo:',
	'coll-subtitle' => 'Sottotitolo:',
	'coll-contents' => 'Indice',
	'coll-drag_and_drop' => 'Usa il drag and drop per riordinare le pagine wiki e i capitoli',
	'coll-create_chapter' => 'Crea capitolo',
	'coll-sort_alphabetically' => 'Ordina alfabeticamente',
	'coll-clear_collection' => 'Svuota libro',
	'coll-clear_collection_confirm' => 'Si desidera veramente pulire completamente il proprio libro?',
	'coll-rename' => 'Rinomina',
	'coll-new_chapter' => 'Inserisci il nome per il nuovo capitolo',
	'coll-rename_chapter' => 'Inserisci un nuovo nome per il capitolo',
	'coll-no_such_category' => 'Nessuna categoria',
	'coll-notitle_title' => 'Non è stato possibile determinare il titolo della pagina.',
	'coll-post_failed_title' => 'Richiesta POST fallita',
	'coll-post_failed_msg' => 'La richiesta POST a $1 è fallita ($2).',
	'coll-mwserve_failed_title' => 'Errore server conversione',
	'coll-mwserve_failed_msg' => 'Si è verificato un errore sul server di conversione: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Errore risposta dal server',
	'coll-empty_collection' => 'Libro vuoto',
	'coll-revision' => 'Revisione: $1',
	'coll-save_collection_title' => 'Salva e condividi il tuo libro',
	'coll-save_collection_text' => 'Scegli una locazione:',
	'coll-login_to_save' => 'Se vuoi salvare il libro per utilizzarlo in seguito, [[Special:UserLogin|entra o crea un nuovo accesso]].',
	'coll-personal_collection_label' => 'Libro personale:',
	'coll-community_collection_label' => 'Libro della comunità:',
	'coll-save_collection' => 'Salva libro',
	'coll-save_category' => 'I libri sono salvati nella categoria [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'La pagina esiste già.
Sovrascriverla?',
	'coll-overwrite_text' => 'Una pagina con il nome [[:$1]] esiste già.
Si desidera che sia sostituita con la raccolta?',
	'coll-yes' => 'Sì',
	'coll-no' => 'No',
	'coll-load_overwrite_text' => 'Il libro contiene già delle pagine.
Si desidera sovrascrivere il libro corrente, aggiungere il nuovo contenuto o annullare il caricamento di questo libro?',
	'coll-overwrite' => 'Sovrascrivi',
	'coll-append' => 'Aggiungi',
	'coll-cancel' => 'Annulla',
	'coll-update' => 'Aggiorna',
	'coll-limit_exceeded_title' => 'Libro troppo grande',
	'coll-limit_exceeded_text' => 'Il tuo libro è troppo grande. Non è più possibile aggiungervi pagine.',
	'coll-rendering_title' => 'Conversione',
	'coll-rendering_text' => '<p><strong>Attendere mentre il documento viene generato.</strong></p>

<p><strong>Avanzamento:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Questa pagina dovrebbe aggiornarsi automaticamente ogni pochi secondi.
Se questo non funziona, premi il pulsante di aggiornamento del tuo browser.</p>',
	'coll-rendering_status' => '<strong>Stato:</strong> $1',
	'coll-rendering_article' => '(pagina wiki: $1)',
	'coll-rendering_page' => '(pagina: $1)',
	'coll-rendering_finished_title' => 'Conversione terminata',
	'coll-rendering_finished_text' => '<strong>Il documento è stato generato.</strong>
<strong>[$1 Scarica il file]</strong> sul tuo computer.

Note:
* Non sei soddisfatto del risultato? Leggi [[{{MediaWiki:Coll-helppage}}|la pagina di aiuto sulle raccolte]] riguardo alle possibilità per migliorarlo.',
	'coll-notfound_title' => 'Libro non trovato',
	'coll-notfound_text' => 'Non è possibile trovare la pagina del libro.',
	'coll-is_cached' => '<ul><li>Una versione del documento è stata trovata nella cache; la conversione non è stata necessaria. <a href="$1">Forza la ri-conversione.</a></li></ul>',
	'coll-excluded-templates' => '* I template nella categoria [[:Category:$1|$1]] sono stati esclusi.',
	'coll-blacklisted-templates' => '* I template nella blacklist [[:$1]] sono stati esclusi.',
	'coll-return_to_collection' => '<p>Torna a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Ordina come libro stampato',
	'coll-book_text' => 'Ottieni un libro stampato da uno dei nostri partner di stampa su richiesta (print-on-demand):',
	'coll-order_from_pp' => 'Ordina libro da $1',
	'coll-about_pp' => 'Informazioni su $1',
	'coll-invalid_podpartner_title' => 'Partner POD non valido',
	'coll-invalid_podpartner_msg' => 'Il partner POD fornito non è valido. Contatta il tuo amministratore MediaWiki.',
	'coll-license' => 'Licenza',
	'coll-return_to' => 'Torna a [[:$1]]',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'coll-desc' => '[[Special:Book|ブックを作成する]]',
	'coll-collection' => 'ブック',
	'coll-collections' => 'ブック',
	'coll-exclusion_category_title' => '印刷から除外',
	'coll-print_template_prefix' => '印刷用',
	'coll-print_template_pattern' => '$1/印刷用',
	'coll-create_a_book' => 'ブックを新規作成',
	'coll-add_page' => 'ウィキページの追加',
	'coll-add_page_tooltip' => '現在のページをあなたのブックに追加する',
	'coll-remove_page' => 'ウィキページの削除',
	'coll-remove_page_tooltip' => '現在のページをあなたのブックから削除する',
	'coll-add_category' => 'カテゴリの追加',
	'coll-add_category_tooltip' => 'このカテゴリ中のすべてのページをあなたのブックに追加する',
	'coll-load_collection' => 'ブックの読み込み',
	'coll-load_collection_tooltip' => 'このブックをあなたの現在のブックとして読み込む',
	'coll-show_collection' => 'ブックを表示',
	'coll-show_collection_tooltip' => 'クリックしてあなたのブックを編集、ダウンロード、または注文する',
	'coll-help_collections' => 'ブックのヘルプ',
	'coll-help_collections_tooltip' => 'ブック作成ツールについてのヘルプを表示する',
	'coll-n_pages' => '$1ページ',
	'coll-unknown_subpage_title' => '不明なサブページ',
	'coll-unknown_subpage_text' => 'この[[Special:Book|ブック]]のサブページは存在しません',
	'coll-printable_version_pdf' => 'PDF版',
	'coll-download_as' => '$1としてダウンロード',
	'coll-noscript_text' => '<h1>JavaScriptを利用しています！</h1>
<strong>ご利用のブラウザは JavaScript をサポートしていないか、JavaScript が無効になっています。このページは、JavaScript が有効になっていない場合、正しく動作しません。</strong>',
	'coll-intro_text' => 'あなただけのウィキページのコレクションを作成・管理できます。<br />詳細は[[{{MediaWiki:Coll-helppage}}]]をご覧ください。',
	'coll-helppage' => 'Help:ブック',
	'coll-bookscategory' => 'ブック',
	'coll-savedbook_template' => '保存済みブック',
	'coll-your_book' => 'あなたのブック',
	'coll-download_title' => 'ダウンロード',
	'coll-download_text' => 'オフライン版をダウンロードするには、形式を選択してボタンをクリックしてください。',
	'coll-download_as_text' => '$1形式のオフライン版をダウンロードするにはボタンをクリックしてください。',
	'coll-download' => 'ダウンロード',
	'coll-format_label' => '形式:',
	'coll-remove' => '削除',
	'coll-show' => '表示',
	'coll-move_to_top' => '先頭へ',
	'coll-move_up' => '上へ',
	'coll-move_down' => '下へ',
	'coll-move_to_bottom' => '最後尾へ',
	'coll-title' => 'タイトル:',
	'coll-subtitle' => 'サブタイトル:',
	'coll-contents' => '内容',
	'coll-drag_and_drop' => 'ドラッグ・アンド・ドロップでウィキページや章を並べ換えます',
	'coll-create_chapter' => '新しい章を作成',
	'coll-sort_alphabetically' => 'ページを辞書順にソート',
	'coll-clear_collection' => 'ブックを消去',
	'coll-clear_collection_tooltip' => 'あなたの現在のブックからすべてのウィキページを削除する',
	'coll-clear_collection_confirm' => '本当にブックを完全に消去しますか？',
	'coll-rename' => '改名',
	'coll-new_chapter' => '新しい章見出しを入力',
	'coll-rename_chapter' => '新しい章見出しを入力',
	'coll-no_such_category' => '指定されたカテゴリは存在しません',
	'coll-notitle_title' => 'ページタイトルが未設定です。',
	'coll-post_failed_title' => 'POST要求の失敗',
	'coll-post_failed_msg' => '$1へのPOST要求は失敗しました ($2)。',
	'coll-mwserve_failed_title' => 'レンダリングサーバーのエラー',
	'coll-mwserve_failed_msg' => 'レンダリングサーバーでエラーが発生しました: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'サーバからのエラー応答',
	'coll-empty_collection' => '空のブック',
	'coll-revision' => '特定版: $1',
	'coll-save_collection_title' => 'ブックを保存して共有する',
	'coll-save_collection_text' => '保存先の選択:',
	'coll-login_to_save' => '後の利用のためブックを保存するには、[[Special:UserLogin|ログインまたはアカウント作成]]を行ってください。',
	'coll-personal_collection_label' => '個人的なブック:',
	'coll-community_collection_label' => '共有するブック:',
	'coll-save_collection' => 'ブックを保存',
	'coll-save_category' => 'ブックはカテゴリ [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] に保存されました。',
	'coll-overwrite_title' => '同名のページが存在します。上書きしますか？',
	'coll-overwrite_text' => '[[:$1]] という名前のページが既に存在しています。これをあなたのブックに置き換えますか？',
	'coll-yes' => 'はい',
	'coll-no' => 'いいえ',
	'coll-load_overwrite_text' => 'あなたのブックには既にページがいくつかあります。現在のブックを上書きする、ブックに追加する、このブックの読み込みを中止する、のいずれかを選択してください。',
	'coll-overwrite' => '上書き',
	'coll-append' => '追加',
	'coll-cancel' => '中止',
	'coll-update' => '更新',
	'coll-limit_exceeded_title' => 'ブックが大きすぎます',
	'coll-limit_exceeded_text' => 'あなたのブックは大きすぎます。これ以上のページを追加することはできません。',
	'coll-rendering_title' => 'レンダリング中',
	'coll-rendering_text' => '<p><strong>ドキュメントが生成されるあいだ、しばらくお待ちください。</strong></p>

<p><strong>進捗:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>このページは数秒毎に自動的に更新されます。更新されない場合は、ブラウザの更新ボタンを押してください。</p>',
	'coll-rendering_status' => '<strong>状況:</strong> $1',
	'coll-rendering_article' => '(ウィキページ: $1)',
	'coll-rendering_page' => '(ページ: $1)',
	'coll-rendering_finished_title' => 'レンダリング完了',
	'coll-rendering_finished_text' => '<strong>ドキュメントファイルは生成されました。</strong>
あなたのコンピュータに<strong>[$1 ファイルをダウンロード]</strong>してください。

注:
* 出力に満足できませんか？改善が可能か、[[{{MediaWiki:Coll-helppage}}|コレクションについてのヘルプページ]]をご覧ください。',
	'coll-notfound_title' => 'ブックが見つかりません',
	'coll-notfound_text' => 'ブックの保存ページが見つかりませんでした。',
	'coll-is_cached' => '<ul><li>ドキュメントのキャッシュ済み版がみつかりましたので、レンダリングは必要ありません。<a href="$1">強制的に再レンダリングする。</a></li></ul>',
	'coll-excluded-templates' => '* カテゴリ [[:Category:$1|$1]] にあるテンプレートは除外されています。',
	'coll-blacklisted-templates' => '* ブラックリスト [[:$1]] にあるテンプレートは除外されています。',
	'coll-return_to_collection' => '<p><a href="$1">$2</a></p>に戻る',
	'coll-book_title' => '印刷済みの本として注文',
	'coll-book_text' => '印刷済みの本をわれわれのオンデマンド印刷パートナーから入手:',
	'coll-order_from_pp' => '$1に本を注文',
	'coll-about_pp' => '$1について',
	'coll-invalid_podpartner_title' => '無効なオンデマンド印刷パートナー',
	'coll-invalid_podpartner_msg' => '提供されたオンデマンド印刷パートナーは無効です。MediaWiki の管理者に連絡してください。',
	'coll-license' => 'ライセンス',
	'coll-return_to' => '[[:$1]]に戻る',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'coll-desc' => '[[Special:Collection|Kolèksi kaca-kaca]], nggawé PDF',
	'coll-collection' => 'Kolèksi',
	'coll-collections' => 'Kolèksi-kolèksi',
	'coll-exclusion_category_title' => 'Ora mèlu dicithak',
	'coll-print_template_prefix' => 'Cithak',
	'coll-create_a_book' => 'Gawé buku',
	'coll-add_page' => 'Tambah kaca wiki',
	'coll-remove_page' => 'Busak kaca wiki',
	'coll-add_category' => 'Tambah kategori',
	'coll-load_collection' => 'Unggahna kolèksi',
	'coll-show_collection' => 'Tuduhna kolèksi',
	'coll-help_collections' => 'Pitulung kolèksi',
	'coll-n_pages' => '$1 {{PLURAL:$1|kaca|kaca}}',
	'coll-unknown_subpage_title' => 'Anak-kaca sing ora dikenal',
	'coll-unknown_subpage_text' => 'Anak-kaca saka [[Special:Book|Kolèksi]] iki ora ana',
	'coll-printable_version_pdf' => 'Vèrsi PDF',
	'coll-download_as' => 'Undhuh minangka $1',
	'coll-noscript_text' => '<h1>JavaScript diperlokaké!</h1>
<strong>Browser panjenengan ora ndhukung JavaScript utawa JavaScript wis dipatèni.
Kaca iki ora bakal tampil kanthi bener, kajaba JavaScript di aktifaké.</strong>',
	'coll-intro_text' => 'Gawé lan tata pilihan kaca wiki panjenengan.<br />Pirsani [[{{MediaWiki:Coll-helppage}}]] kanggo informasi luwih cetha.',
	'coll-helppage' => 'Help:Collections',
	'coll-your_book' => 'Buku panjenengan',
	'coll-download_title' => 'Undhuh',
	'coll-download_text' => "Kanggo ngundhuh vèrsi jaba-jaring (''offline'') pilih siji format lan klik tombolé.",
	'coll-download' => 'Undhuh',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Ilangana',
	'coll-show' => 'Tuduhaké',
	'coll-move_to_top' => 'Pindhah menyang ndhuwur',
	'coll-move_up' => 'Munggah',
	'coll-move_down' => 'Mudhun',
	'coll-move_to_bottom' => 'Pindhah menyang dhasar ngisor',
	'coll-title' => 'Irah-irahan (judhul):',
	'coll-subtitle' => 'Subjudhul:',
	'coll-contents' => 'Isi',
	'coll-drag_and_drop' => "Gunakaké ''drag & drop'' kanggo nata kaca lan bab ing wiki",
	'coll-create_chapter' => 'Gawé bab',
	'coll-sort_alphabetically' => 'Sortir miturut abjad',
	'coll-clear_collection' => 'Kosongna kolèksi',
	'coll-clear_collection_confirm' => 'Panjenengan pancèn arep mbusak kalèksi panjenengan?',
	'coll-rename' => 'Ganti jeneng',
	'coll-new_chapter' => 'Lebokna jeneng anyar kanggo bab',
	'coll-rename_chapter' => 'Lebokna jeneng anyar kanggo bab',
	'coll-no_such_category' => 'Ora ana kategori kaya mengkono',
	'coll-notitle_title' => 'Irah-irahan kaca iki ora bisa ditemtokaké.',
	'coll-post_failed_title' => 'Panyuwunan POST gagal',
	'coll-post_failed_msg' => 'Panyuwunan POST menyang $1 gagal ($2).',
	'coll-mwserve_failed_title' => 'Ana kasalahan server',
	'coll-mwserve_failed_msg' => 'Ana kasalahan ing server: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Rèspon kasalahan saka server',
	'coll-empty_collection' => 'Kolèksi kosong',
	'coll-revision' => 'Révisi: $1',
	'coll-save_collection_title' => 'Simpen lan tuduhaké kolèksi panjenengan',
	'coll-save_collection_text' => 'Pilih lokasi',
	'coll-login_to_save' => 'Yèn panjenengan arep nyimpen kolèksi kanggo kaperluan mangsa ngarep, mangga[[Special:UserLogin|mlebu log utawa gawé akun]].',
	'coll-personal_collection_label' => 'Kolèksi pribadi:',
	'coll-community_collection_label' => 'Kolèksi komunitas:',
	'coll-save_collection' => 'Simpen kolèksi',
	'coll-save_category' => 'Kolèksi disimpen ing kategori [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Kaca wis ana. Ditindhes waé?',
	'coll-overwrite_text' => 'Kaca kanthi jeneng [[:$1]] wis ana.
Apa arep diganti nganggo kolèksi panjenengan?',
	'coll-yes' => 'Iya',
	'coll-no' => 'Ora',
	'coll-load_overwrite_text' => 'Panjenengan wis duwé sawetara kaca jroning kolèksi panjenengan.
Apa arep nindhes kolèksi panjenengan, nambah isi anyar, utawa mbatalaké ngunggah kolèksi iki?',
	'coll-overwrite' => 'Timpanen',
	'coll-append' => 'Lampirna',
	'coll-cancel' => 'Batal',
	'coll-update' => 'Mutakir',
	'coll-limit_exceeded_title' => 'Kolèksi Kegedhèn',
	'coll-limit_exceeded_text' => 'Kolèksi kaca panjenengan iku kegedhèn.
Ora bisa nambah kaca-kaca liya manèh.',
	'coll-rendering_title' => 'Nggawé/ngowahi',
	'coll-rendering_text' => "<p><strong>Mangga ditunggu sauntara dokumèn lagi digawé.</strong></p>

<p><strong>Kamajuan:</strong> <span id=\"renderingProgress\">\$1</span>% <span id=\"renderingStatus\">\$2</span></p>

<p>Kaca iki samesthiné ''refresh'' sacara otomatis saben sawetara detik.
Yèn ora mangkono, mangga pencèt tombol ''refresh'' ing ''browser'' panjenengan.</p>",
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(kaca wiki: $1)',
	'coll-rendering_page' => '(kaca: $1)',
	'coll-rendering_finished_title' => 'Rampung ngowahi/gawé',
	'coll-rendering_finished_text' => "<strong>Berkas dokumèn wis digawé.</strong>
<strong>[$1 Undhuh berkas]</strong> menyang komputer panjenengan.

Cathetan:
* Kurang rena karo wetonan (''output'')é? Pirsani [[{{MediaWiki:Coll-helppage}}|kaca pitulung bab kolèksi]] kanggo kamungkinan ningkataké.",
	'coll-notfound_title' => 'Kolèksi ora ditemokaké',
	'coll-notfound_text' => 'Ora bisa nemokaké kaca kolèksi.',
	'coll-is_cached' => "<ul><li>Dokumèn vèrsi ''cache'' wis ditemokaké, mula ora perlu ana pangowahan (''rendering''). <a href=\"\$1\">Peksa ''re-rendering''.</a></li></ul>",
	'coll-excluded-templates' => '* Cithakan-cithakan ing kategori [[:Category:$1|$1]] wis di wetokaké.',
	'coll-blacklisted-templates' => '* Cithakan-cithakan ing dhaptar-ireng [[:$1]] wis diwetokaké.',
	'coll-return_to_collection' => '<p>Bali menyang <a href="$1">$2</a></p>',
	'coll-book_title' => 'Urut kaya buku cithakan',
	'coll-book_text' => "Jupuken buku cithakan saka partner ''print-on-demand'' kita:",
	'coll-order_from_pp' => 'Pesen buku saka $1',
	'coll-about_pp' => 'Perkara $1',
	'coll-invalid_podpartner_title' => 'Partner POD ora sah',
	'coll-invalid_podpartner_msg' => 'Partner POD sing disadiyakaké ora sah.
Mangga hubungi pangurus MediaWiki panjenengan.',
	'coll-license' => 'Lisènsi',
	'coll-return_to' => 'Bali menyang [[:$1]]',
);

/** Georgian (ქართული)
 * @author Malafaya
 * @author Sopho
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'coll-collection' => 'წიგნი',
	'coll-collections' => 'წიგნები',
	'coll-create_a_book' => 'წიგნის შექმნა',
	'coll-add_category' => 'კატეგორიის დამატება',
	'coll-n_pages' => '$1 გვერდი',
	'coll-printable_version_pdf' => 'PDF ვერსია',
	'coll-helppage' => 'Help:წიგნები',
	'coll-your_book' => 'თქვენი წიგნი',
	'coll-download_title' => 'ჩამოტვირთვა',
	'coll-download' => 'ჩამოტვირთვა',
	'coll-format_label' => 'ფორმატი:',
	'coll-show' => 'ჩვენება',
	'coll-title' => 'სათაური:',
	'coll-no' => 'არა',
	'coll-about_pp' => '$1-ის შესახებ',
	'coll-license' => 'ლიცენზია',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'coll-desc' => '[[Special:Collection|ចងក្រងទំព័រ]]រួចបង្កើតឯកសារ PDF',
	'coll-collection' => 'សៀវភៅ',
	'coll-collections' => 'សៀវភៅ',
	'coll-print_template_prefix' => 'បោះពុម្ព',
	'coll-create_a_book' => 'កំរងឯកសារ',
	'coll-add_page' => 'បន្ថែមទំព័រវិគី',
	'coll-remove_page' => 'ដកទំព័រវិគីចេញ',
	'coll-add_category' => 'បន្ថែមចំណាត់ថ្នាក់ក្រុម',
	'coll-load_collection' => 'ផ្ទុកសៀវភៅ',
	'coll-show_collection' => 'បង្ហាញ​សៀវភៅ',
	'coll-help_collections' => 'ជំនួយ​អំពី​សៀវភៅ',
	'coll-n_pages' => '$1 {{PLURAL:$1|ទំព័រ|ទំព័រ}}',
	'coll-printable_version_pdf' => 'កំណែ PDF',
	'coll-download_as' => 'ទាញយកជា $1',
	'coll-noscript_text' => '<h1>ត្រូវការ JavaScript!</h1>
<strong>ឧបករណ៍រាវរក (browser) របស់អ្នកមិនគាំទ្រ JavaScript ឬ JavaScript ត្រូវបានបិទ។
ទំព័រនេះមិនអាចដំណើរការបានត្រឹមត្រូវទេ លុះត្រាតែអ្នកបើកឱ្យ JavaScript ដើរ។</strong>',
	'coll-intro_text' => 'អ្នកអាចចងក្រងទំព័រ បង្កើត និង ទាញយកឯកសារ PDF ពីទំព័រកម្រងឯកសារ និងអាចរក្សាទុកកម្រងឯកសារសម្រាប់ប្រើលើកក្រោយឬដាក់ហ៊ុនជាមួយអ្នកដទៃ។

សូមមើល[[{{MediaWiki:Coll-helppage}}|ទំព័រជំនួយពីកម្រងឯកសារ]]សម្រាប់ព័ត៌មានបន្ថែម។',
	'coll-helppage' => 'Help:សៀវភៅ',
	'coll-your_book' => 'សៀវភៅ​របស់អ្នក',
	'coll-download_title' => 'ទាញយក',
	'coll-download' => 'ទាញយក',
	'coll-format_label' => 'ទម្រង់:',
	'coll-remove' => 'ដកចេញ',
	'coll-show' => 'បង្ហាញ',
	'coll-move_to_top' => 'ទៅ​លើគេបំផុត',
	'coll-move_up' => 'រំកិលឡើង',
	'coll-move_down' => 'រំកិលចុះ',
	'coll-move_to_bottom' => 'ទៅក្រោមគេបំផុត',
	'coll-title' => 'ចំណងជើង៖',
	'coll-subtitle' => 'ចំណងជើងរង៖',
	'coll-contents' => 'ខ្លឹមសារ',
	'coll-create_chapter' => 'បង្កើត​ជំពូកថ្មី',
	'coll-sort_alphabetically' => 'តម្រៀប​ទំព័រ​​តាម​អក្ខរក្រម',
	'coll-clear_collection' => 'សំអាត​សៀវភៅ',
	'coll-clear_collection_confirm' => 'តើ​អ្នក​ពិតជា​ចង់​ជម្រះ​សៀវភៅ​របស់​អ្នក​ទាំងស្រុង​ឬ​?',
	'coll-rename' => 'ប្តូរឈ្មោះ',
	'coll-new_chapter' => 'ដាក់ឈ្មោះឱ្យ ជំពូកថ្មី',
	'coll-rename_chapter' => 'ដាក់ឈ្មោះថ្មី ឱ្យជំពូក',
	'coll-no_such_category' => 'គ្មានចំណាត់ថ្នាក់ក្រុមបែបនេះទេ',
	'coll-notitle_title' => 'មិន​អាចកំណត់​ចំណងជើង​នៃទំព័រ',
	'coll-empty_collection' => 'សៀវភៅទទេ',
	'coll-save_collection_title' => 'រក្សាទុក​និង​ចែករំលែក​សៀវភៅ',
	'coll-save_collection_text' => 'ជ្រើសរើស​តំបន់៖',
	'coll-login_to_save' => 'ប្របើសិនបើ​អ្នក​ចង់​រក្សាទុក​សៀវភៅ​សម្រាប់​ប្រើប្រាស់​លើកក្រោយ សូម​[[Special:UserLogin|ឡុកអ៊ីន​ឬ​បង្កើត​គណនី]]​។',
	'coll-personal_collection_label' => 'សៀវភៅ​ផ្ទាល់ខ្លួន៖',
	'coll-community_collection_label' => 'សៀវភៅ​សហគមន៍៖',
	'coll-save_collection' => 'រក្សាទុកសៀវភៅ',
	'coll-overwrite_title' => 'ទំព័រ​មានហើយ។ សរសេរ​ជាន់ពីលើ ?',
	'coll-overwrite_text' => 'ទំព័រដែលមានឈ្មោះ [[:$1]] មានរួចហើយ។ តើអ្នកចង់ជំនួសវាដោយកម្រងឯកសាររបស់អ្នកឬ?',
	'coll-yes' => 'បាទ / ចាស',
	'coll-no' => 'ទេ',
	'coll-load_overwrite_text' => 'អ្នក​មាន​ទំព័រ​ខ្លះនៅក្នុង​សៀវភៅ​នេះ​រួចហើយ​។ តើ​អ្នក​ចង់​សរសេរ​ជាន់ពីលើ​សៀវភៅ​បច្ចុប្បន្ន​របស់​អ្នក ដោយ​បន្ថែម​មាតិកា​ថ្មី ឬក៏​ច្រានចោល​ការផ្ទុក​សៀវភៅនេះ​?',
	'coll-overwrite' => 'សរសេរជាន់ពីលើ',
	'coll-append' => 'បន្ថែមនៅចុង',
	'coll-cancel' => 'បោះបង់',
	'coll-update' => 'ធ្វើឱ្យទាន់សម័យ',
	'coll-limit_exceeded_title' => 'សៀវភៅ​ធំជ្រុល',
	'coll-limit_exceeded_text' => 'សៀវភៅ​របស់អ្នក​ធំជ្រុលពេកហើយ​។ អ្នក​មិន​អាច​បន្ថែម​ទំព័រ​ទៅក្នុង​វា​ទៀតទេ​។',
	'coll-rendering_status' => '<strong>ស្ថាបភាព៖</strong> $1',
	'coll-rendering_article' => '(ទំព័រវិគី៖ $1)',
	'coll-rendering_page' => '(ទំព័រ៖ $1)',
	'coll-notfound_title' => 'រកមិនឃើញ​សៀវភៅ',
	'coll-notfound_text' => 'រកមិនឃើញសៀវភៅទេ។',
	'coll-return_to_collection' => '<p>ត្រឡប់ទៅកាន់<a href="$1">$2</a></p>វិញ',
	'coll-book_title' => 'ទិញសៀវភៅដែលបានបោះពុម្ព',
	'coll-order_from_pp' => 'បញ្ជាទិញ​សៀវភៅពី $1',
	'coll-about_pp' => 'អំពី$1',
	'coll-license' => 'អាជ្ញាប័ណ្ណ',
	'coll-return_to' => 'ត្រឡប់ទៅកាន់ [[:$1]]',
);

/** Korean (한국어)
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'coll-desc' => '[[Special:Book|책 만들기]]',
	'coll-collection' => '책',
	'coll-collections' => '책들',
	'coll-exclusion_category_title' => '인쇄시 제외할 문서',
	'coll-print_template_prefix' => '인쇄',
	'coll-print_template_pattern' => '$1/인쇄',
	'coll-create_a_book' => '책 만들기',
	'coll-add_page' => '문서 추가',
	'coll-remove_page' => '문서 제거',
	'coll-add_category' => '분류 추가하기',
	'coll-load_collection' => '책 불러오기',
	'coll-show_collection' => '책 보여주기',
	'coll-n_pages' => '$1개의 문서',
	'coll-unknown_subpage_title' => '알 수 없는 하위 문서',
	'coll-printable_version_pdf' => 'PDF 버전',
	'coll-download_as' => '$1로 다운로드',
	'coll-noscript_text' => '<h1>자바스크립트가 필요합니다!</h1>
<strong>당신의 브라우저는 자바스크립트를 지원하지 않거나 비활성화되어 있습니다.
자바스크립트가 활성화되지 않으면 이 문서는 제대로 동작하지 않을 수 있습니다.</strong>',
	'coll-helppage' => 'Help:책 만들기',
	'coll-bookscategory' => '책들',
	'coll-your_book' => '당신의 책',
	'coll-download_title' => '다운로드',
	'coll-download' => '다운로드',
	'coll-format_label' => '포맷:',
	'coll-remove' => '제거',
	'coll-show' => '보이기',
	'coll-move_to_top' => '맨 위로 이동',
	'coll-move_up' => '위로 옮기기',
	'coll-move_down' => '아래로 옮기기',
	'coll-move_to_bottom' => '맨 아래로 이동',
	'coll-title' => '제목:',
	'coll-subtitle' => '부제목:',
	'coll-contents' => '내용',
	'coll-create_chapter' => '새로운 장 만들기',
	'coll-sort_alphabetically' => '알파벳순으로 정렬',
	'coll-clear_collection_confirm' => '정말로 책에 있는 내용을 완전히 삭제하길 원하세요?',
	'coll-rename' => '이름 바꾸기',
	'coll-no_such_category' => '이런 분류는 없습니다.',
	'coll-post_failed_title' => 'POST 요청에 실패하였습니다.',
	'coll-post_failed_msg' => '$1로의 POST 요청 실패 ($2)',
	'coll-mwserve_failed_title' => '렌더 서버 오류',
	'coll-empty_collection' => '비어있는 책',
	'coll-revision' => '판: $1',
	'coll-login_to_save' => '나중에 사용하기 위해 책을 저장하길 원하신다면 [[Special:UserLogin|로그인하거나 계정을 생성]]해 주세요.',
	'coll-personal_collection_label' => '개인 책:',
	'coll-save_collection' => '책 저장',
	'coll-overwrite_title' => '문서가 존재합니다.
덮어쓰시겠습니까?',
	'coll-overwrite_text' => '[[:$1]]이라는 이름을 가진 문서가 이미 존재합니다.
정말로 당신의 책을 바꾸시겠습니까?',
	'coll-yes' => '예',
	'coll-no' => '아니오',
	'coll-overwrite' => '덮어쓰기',
	'coll-append' => '더하기',
	'coll-cancel' => '취소',
	'coll-update' => '업데이트',
	'coll-limit_exceeded_title' => '책이 너무 큽니다.',
	'coll-rendering_title' => '렌더링',
	'coll-rendering_text' => '<p><strong>문서가 생성될 때까지 잠시 기다려주십시오.</strong></p>

<p><strong>진행률:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>이 문서는 몇 초마다 새로고쳐져야 합니다.
만약 제대로 동작하지 않는다면, 브라우저를 새로고침하십시오.</p>',
	'coll-rendering_status' => '<strong>상태:</strong> $1',
	'coll-rendering_article' => '(문서: $1)',
	'coll-rendering_page' => '(페이지: $1)',
	'coll-rendering_finished_title' => '렌더링 완료',
	'coll-rendering_finished_text' => '<strong>문서 파일이 생성되었습니다.</strong>
이 파일을 당신의 컴퓨터로 <strong>[$1 다운로드]</strong>하십시오.

참고:
* 출력 결과에 만족하지 않으신가요? 이 기능을 향상시킬 수 있도록 [[{{MediaWiki:Coll-helppage}}|책에 대한 도움말 문서]]를 참고해 주세요.',
	'coll-notfound_title' => '책을 찾을 수 없음',
	'coll-is_cached' => '<ul><li>이 문서의 캐시된 버전이 발견되었습니다. 따라서 다시 렌더링하지 않으셔도 됩니다. <a href="$1">다시 렌더링하기</a></li></ul>',
	'coll-excluded-templates' => '[[:Category:$1|$1]] 분류에 속한 틀은 제외되었습니다.',
	'coll-blacklisted-templates' => '틀 블랙리스트 [[:$1]]에 있는 틀은 제외되었습니다.',
	'coll-return_to_collection' => '<p><a href="$1">$2</a>로 돌아갑니다</p>',
	'coll-book_title' => '인쇄된 책으로 주문',
	'coll-order_from_pp' => '$1에서 책 주문하기',
	'coll-about_pp' => '$1에 대하여',
	'coll-license' => '라이선스',
	'coll-return_to' => '[[:$1]]으로 돌아갑니다.',
);

/** Krio (Krio)
 * @author Protostar
 */
$messages['kri'] = array(
	'coll-collection' => 'Buk',
	'coll-collections' => 'Buk-dèm',
	'coll-exclusion_category_title' => 'Nò put dis-ya da di print',
	'coll-print_template_prefix' => 'Print',
	'coll-create_a_book' => 'Mek buk',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'coll-contents' => 'Manga Sulud',
	'coll-cancel' => 'Kanselar',
	'coll-about_pp' => 'Angut sa Iwan $1',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'coll-desc' => '[[Special:Book|Böösher ußjäve]]',
	'coll-collection' => 'Booch',
	'coll-collections' => 'Bööscher',
	'coll-exclusion_category_title' => 'Nit met drokke',
	'coll-print_template_prefix' => 'Dröcke',
	'coll-print_template_pattern' => '$1/Dröcke',
	'coll-create_a_book' => 'E Booch zesamme_ställe',
	'coll-add_page' => 'En Sigg dobei donn',
	'coll-add_page_tooltip' => '!!FUZZY!Donn de aktoälle Wiki-Sigg en Ding Sammlong erin',
	'coll-remove_page' => 'En Sigg eruß nämme',
	'coll-remove_page_tooltip' => 'Schmiiß hee di Sigg fum Wiki uß Dingem Booch eruß',
	'coll-add_category' => 'En Saachjrupp dobei donn',
	'coll-add_category_tooltip' => 'Dat deiht all de Atikelle en dä {{NS:Category}} en Ding Booch erin.',
	'coll-load_collection' => 'Booch lade',
	'coll-load_collection_tooltip' => 'Deiht dat Booch hee als Ding aktoälles Booch laade.',
	'coll-show_collection' => 'Booch zeije',
	'coll-show_collection_tooltip' => 'He met kanns De Ding Boch ändere, de zosamme jeshtalle Sigge erunger laade, un jedröck beshtelle.',
	'coll-help_collections' => 'Hölp üvver Bööscher',
	'coll-help_collections_tooltip' => 'Hölp övver et Werkzüch zum Bööscher maache',
	'coll-n_pages' => '{{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigge}}',
	'coll-unknown_subpage_title' => 'Unbekannte Ungersigg',
	'coll-unknown_subpage_text' => 'Di Ungersigg fun „[[Special:Book|Booch]]“ jidd_et nit',
	'coll-printable_version_pdf' => 'PDF Version',
	'coll-download_as' => 'Als $1 eronger laade',
	'coll-noscript_text' => '<h1>Bruch JavaSkripp!</h1>
<strong>Dinge Brauser kann kei JavaSkripp udder et es affjeschalldt.
Di Sigg hee weed oohne JavaSkripp nit donn.</strong>',
	'coll-intro_text' => 'Do kanns Sammlonge vun Sigge zusamme ställe, beärrbeide, un för shpääder affspeijschere.<br />
Loor Der de ußföhrlesche [[{{MediaWiki:Coll-helppage}}|Hölp övver Sammlonge]] aan,
wann de noch mieh wesse wells.',
	'coll-helppage' => 'Help:Bööscher',
	'coll-bookscategory' => 'Bööscher',
	'coll-savedbook_template' => 'Avjespeichert_Booch',
	'coll-your_book' => 'Ding Boch',
	'coll-download_title' => 'Eronger laade',
	'coll-download_text' => 'Öm en automattesch jemaate Datei met Dinge Sammlong eronger ze laade,
sök Der e Fommaat uß, un donn op dat Knöppsche klecke.',
	'coll-download_as_text' => 'Öm en Version em $1-Fommaat erunger ze laade, donn dä Knopp dröcke.',
	'coll-download' => 'Eronger Laade',
	'coll-format_label' => 'Fommaat:',
	'coll-remove' => 'Fott lohße',
	'coll-show' => 'Zeich',
	'coll-move_to_top' => 'aan der Aanfang donn',
	'coll-move_up' => 'Erop schuve',
	'coll-move_down' => 'Eronger schuve',
	'coll-move_to_bottom' => 'An et Engk donn',
	'coll-title' => 'Tittel:',
	'coll-subtitle' => 'Ongertittel:',
	'coll-contents' => 'Enhallt',
	'coll-drag_and_drop' => 'Donn de Sigge un Kapittelle met de Muuß aan Dingem Kompjuter eröm trekke un schuve, wann De se en en ander Reijefollesch han wells.',
	'coll-create_chapter' => 'Kapittel neu aanlääje',
	'coll-sort_alphabetically' => 'Noh_m Allfabeet zoteere',
	'coll-clear_collection' => 'Dat Booch leddisch maache',
	'coll-clear_collection_tooltip' => 'Hee met schmiiß De alle Sigge fum Wiki uß Dingem aktoälle Booch eruß, un deihs et leddisch maache.',
	'coll-clear_collection_confirm' => 'Wells De werklesch Ding Booch jannz fott schmieße?',
	'coll-rename' => 'Ömnänne',
	'coll-new_chapter' => 'Jif ene Name för e neu Kapittel aan',
	'coll-rename_chapter' => 'Jif ene neu Name för dat Kapittel en',
	'coll-no_such_category' => 'Di Saachjrupp jidd_et nit',
	'coll-notitle_title' => 'Mer kunnte dä Tittel för di Sigg nit erus fenge.',
	'coll-post_failed_title' => 'Dä Oproof es donevve jejange (POST)',
	'coll-post_failed_msg' => "Dä Oproof es donevve jejange (POST noh $1 — ''$2'')",
	'coll-mwserve_failed_title' => 'Fähler en dämm Server för et Darstelle',
	'coll-mwserve_failed_msg' => 'En dämm Server för et Darstelle es ene Fähler opjetrodde: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Dä Server meldt ene Fähler',
	'coll-empty_collection' => 'En däm Booch es nix dren',
	'coll-revision' => 'Version: $1',
	'coll-save_collection_title' => 'Et Booch öffentlesch afspeichere',
	'coll-save_collection_text' => 'Sök ene Plaz uß:',
	'coll-login_to_save' => 'Wann De Bööscher afspeichere wells, för se spääder noch ens ze bruche,
donn [[Special:UserLogin|enlogge, udder Desch aanmelde]].',
	'coll-personal_collection_label' => 'Ding persöönlesh Booch:',
	'coll-community_collection_label' => 'En öffentlesch Booch:',
	'coll-save_collection' => 'Dat Booch avspeichere',
	'coll-save_category' => 'Böösher wäde en dä {{int:Category}} [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] jesammt.',
	'coll-overwrite_title' => 'Die Sigg jidd et ald. Överschrieve?',
	'coll-overwrite_text' => 'En Sigg met dämm Name [[:$1]] jidd_et alld.
Wells De se met Dinge Sammlong övverschriive?',
	'coll-yes' => 'Jo',
	'coll-no' => 'Nä',
	'coll-load_overwrite_text' => 'En Dingem Booch sinn_er ald Sigge dren.
Wells de dat Booch övverschrieve, di neu Saache dran 
aanhänge, udder wells de dat Booch lever doch nit laade?',
	'coll-overwrite' => 'Ußtuusche',
	'coll-append' => 'Aanhänge',
	'coll-cancel' => 'Ophüre',
	'coll-update' => 'De Änderunge fasshallde',
	'coll-limit_exceeded_title' => 'Dat Booch es zo jruhß',
	'coll-limit_exceeded_text' => 'Ding Booch es zo jrooß jewoode.
Mer künne kein Sigge mieh do_bei donn.',
	'coll-rendering_title' => 'Am Ußjävve',
	'coll-rendering_text' => '<p><strong>Donn e Momäntsche waade bes de Datei paraat jemaat es.</strong></p>

<p><strong>Jedonn:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Di Sigg hee sullt alle paa Sekunde neu aanjezeisch wääde. Wann dat nit klapp, donn eijach op Dingem Brauser singe passende Knopp klikke, zom neu Aanzeije!</p>',
	'coll-rendering_status' => '<strong>Shtattus:</strong> $1',
	'coll-rendering_article' => '(Wiki-Sigge-Tittel: $1)',
	'coll-rendering_page' => '(Sigg Nommer: $1)',
	'coll-rendering_finished_title' => 'Et Ußjävve eß jedonn',
	'coll-rendering_finished_text' => '<strong>De Datei es paraat jestallt. [$1 Donn se erunger lade].</strong>

Opjepaß:
* Wann De nit zefredde beß, met dämm, wat eruß jekumme eß, dann loor Der op dä [[{{MediaWiki:Coll-helppage}}|Hölpsigg övver Sammlonge]] aan, wat mer velleisch besser maache künnt.',
	'coll-notfound_title' => 'Booch nit jefonge',
	'coll-notfound_text' => 'Mer kunnte de Sigg för dat Booch nit fenge.',
	'coll-is_cached' => '<ul><li>Mer han en Version fun dämm Dokkemänt em ZwescheShpeicher, et moot nit widder neu ußjejovve wääde. <a href="$1">Doch neu widder ußjevve.</a></li></ul>',
	'coll-excluded-templates' => '* De Schablone us dä Saachjropp [[:Category:$1|$1]] wore ußjeschloße.',
	'coll-blacklisted-templates' => '* Schabloone en de „Schwatze Leß“ ([[:$1]]) sin nit met dobei.',
	'coll-return_to_collection' => '<p>Jangk Retur noh <a href="$1">$2</a></p>',
	'coll-book_title' => 'Donn der Drock vun däm Booch beshtälle',
	'coll-book_text' => 'Donn e Booch bestelle en de Drockerei:',
	'coll-order_from_pp' => 'Donn dat Booch bei $1 beshtälle',
	'coll-about_pp' => 'Üvver $1',
	'coll-invalid_podpartner_title' => 'Verkeehte Aajabe zom Drocke udder Drockerei',
	'coll-invalid_podpartner_msg' => 'De Aajabe zom Drocke un wä dat maache sull sin verkeeht.
Don dat enem Wikki-Köbes obb et Bruut schmiere.',
	'coll-license' => 'Lizänz',
	'coll-return_to' => 'Jangk zerök noh [[:$1]]',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'coll-desc' => '[[Special:Book|Bicher uleeën]]',
	'coll-collection' => 'Buch',
	'coll-collections' => 'Bicher',
	'coll-exclusion_category_title' => 'Net mat drécken',
	'coll-print_template_prefix' => 'Drécken',
	'coll-print_template_pattern' => '$1/Drock',
	'coll-create_a_book' => 'E Buch uleeën',
	'coll-add_page' => 'Wiki-Säit derbäisetzen',
	'coll-add_page_tooltip' => 'Déi aktuell Wiki-Säit an Ärt Buch derbäisetzen',
	'coll-remove_page' => 'Wiki-Säit ewechhuelen',
	'coll-remove_page_tooltip' => 'Dës Wiki-Säit aus Ärem buch eraushuelen',
	'coll-add_category' => 'Kategorie derbäisetzen',
	'coll-add_category_tooltip' => 'All Wiki-Säiten aus dëser Kategorie an Ärt Buch derbäisetzen',
	'coll-load_collection' => 'Buch lueden',
	'coll-load_collection_tooltip' => 'Dëst Buch als Ärt aktuellt Buch lueden',
	'coll-show_collection' => "D'Buch weisen",
	'coll-show_collection_tooltip' => "Klickt fir Ärt Buch z'änneren/erofzeluede/ze bestellen",
	'coll-help_collections' => "Hellëf iwwert d'Bicher",
	'coll-help_collections_tooltip' => 'Hëllef vun der Buch-Fonctioun weisen',
	'coll-n_pages' => '$1 {{PLURAL:$1|Säit|Säiten}}',
	'coll-unknown_subpage_title' => 'Onbekannten Ënnersäit',
	'coll-unknown_subpage_text' => 'Dës Ënnersäit vum [[Special:Book|Buch]] gëtt et net',
	'coll-printable_version_pdf' => 'PDF-Versioun',
	'coll-download_as' => 'Als $1 eroflueden',
	'coll-noscript_text' => '<h1>JavaScript gëtt gebraucht!</h1>
<strong>Äre Browser ënnerstëtzt Java Script net oder JavaScript ass ausgeschalt.
Dës Säit fonctionnéiert net richteg, ausser wa JavaScript ageschalt ass</strong>',
	'coll-intro_text' => 'Uleeën a geréieren vun ärer individueller Auswiel vu Wiki-Säiten.<br />Kuckt [[{{MediaWiki:Coll-helppage}}]] fir méi Informatiounen.',
	'coll-helppage' => 'Help:Bicher',
	'coll-bookscategory' => 'Bicher',
	'coll-savedbook_template' => 'gespäichert_buch',
	'coll-your_book' => 'Ärt Buch',
	'coll-download_title' => 'Eroflueden',
	'coll-download_text' => 'Fir eng offline Versioun erofzelueden, wielt w.e.g. e Format a klickt op de Knäppchen.',
	'coll-download_as_text' => 'Fir eng Offline-Versioun am Format $1 erofzelueden, klickt w.e.g. op de Knäppchen.',
	'coll-download' => 'Eroflueden',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Ewechhuelen',
	'coll-show' => 'Weisen',
	'coll-move_to_top' => 'No ganz uewe réckelen',
	'coll-move_up' => 'Eropréckelen',
	'coll-move_down' => 'Erofréckelen',
	'coll-move_to_bottom' => 'No ganz ënne réckelen',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Ënnertitel:',
	'coll-contents' => 'Inhalter',
	'coll-create_chapter' => 'E Kapitel maachen',
	'coll-sort_alphabetically' => 'Alphabetesch sortéieren',
	'coll-clear_collection' => 'Buch eidel maachen',
	'coll-clear_collection_tooltip' => 'All Wiki-Säiten aus ärem aktuelle Buch eraushuelen',
	'coll-clear_collection_confirm' => 'Wëllt Dir Ärt Buch wierklech ganz läschen?',
	'coll-rename' => 'Ëmbenennen',
	'coll-new_chapter' => 'Gitt den Numm fir dat neit Kapitel un',
	'coll-rename_chapter' => "Gitt een neie Numm fir d'Kapitel un",
	'coll-no_such_category' => 'Keng esou Kategorie',
	'coll-notitle_title' => 'Den Titel vun der Säit konnt net festgestallt ginn.',
	'coll-mwserve_failed_title' => 'Feeler vum Server',
	'coll-mwserve_failed_msg' => 'Op dem Render-Server ass e Feeler geschitt: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Feelermeldng vum Server',
	'coll-empty_collection' => 'Eidelt Buch',
	'coll-revision' => 'Versioun: $1',
	'coll-save_collection_title' => 'Buch späicheren an deelen',
	'coll-save_collection_text' => 'Wielt eng Plaz:',
	'coll-login_to_save' => 'Wann Dir Bicher fir de spéidere Gebrauch späichere wëllt, da [[Special:UserLogin|loggt Iech an oder maacht e Benotzerkont op]].',
	'coll-personal_collection_label' => 'Perséinlecht Buch',
	'coll-community_collection_label' => 'Kollektiv-Buch:',
	'coll-save_collection' => 'Buch späicheren',
	'coll-save_category' => 'Bicher ginn an der Kategorie [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] gespäichert.',
	'coll-overwrite_title' => "D'Säit gëtt et. Iwwerschreiwen?",
	'coll-overwrite_text' => 'Et gëtt schonn eng Säit mam Numm [[:$1]].
Wëllt Dir déi duerch är Sammlung ersetzen?',
	'coll-yes' => 'Jo',
	'coll-no' => 'Neen',
	'coll-load_overwrite_text' => 'Dir hutt schon e puer Säiten an Ärem Buch.
Wëllt Dir Ärt aktuellt Buch iwwerschreiwen, den nien Inhalt hanndrun hänken, oder luede vun dësm Buch ofbriechen?',
	'coll-overwrite' => 'Iwwerschreiwen',
	'coll-append' => 'Derbäisetzen',
	'coll-cancel' => 'Annulléieren',
	'coll-update' => 'Aktualiséieren',
	'coll-limit_exceeded_title' => 'Buch ze grouss',
	'coll-limit_exceeded_text' => 'Ärt Buch ass ze grouss.
Et kënne keng Säite méi derbäigesat ginn.',
	'coll-rendering_title' => 'Maachen',
	'coll-rendering_text' => '<p><strong>Gedëllegt Iech w.e.g. bis d\'Dokument zesummegestallt ass.</strong></p>

<p><strong>Fortschrëtt:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Dës Säit gëtt normalerweis automatesch aktualiséiert.
Wann dat net sollt de fall sinn, da klickt w.e.g. op den Aktualiséieren/Refresh Knäppche vun ärem Browser.</p>',
	'coll-rendering_status' => '<strong>Statut :</strong> $1',
	'coll-rendering_article' => '(Wiki Säit: $1)',
	'coll-rendering_page' => '(Säit: $1)',
	'coll-rendering_finished_title' => 'Fäerdeg gemaach',
	'coll-notfound_title' => 'Buch net fonnt',
	'coll-notfound_text' => "D'Buch-Säit konnt net fonnt ginn.",
	'coll-excluded-templates' => '* Schablounen aus der Kategorie [[:Category:$1|$1]] goufen ausgeschloss',
	'coll-blacklisted-templates' => '* Schablounen op der schwaarzer Lëscht (blacklist) [[:$1]] goufen ausgeschloss.',
	'coll-return_to_collection' => '<p>Zréck op <a href="$1">$2</a></p>',
	'coll-book_title' => 'Als gedréckte Buch bestellen',
	'coll-book_text' => 'Bestellt e gedréckte Buch vun eisem Print-On-Demand Partner:',
	'coll-order_from_pp' => "D'Buch bestelle bäi $1",
	'coll-about_pp' => 'Iwwer $1',
	'coll-invalid_podpartner_title' => 'Ongëltege Print-On-Demand (POD) Partner',
	'coll-license' => 'Lizenz',
	'coll-return_to' => 'Zréck op [[:$1]]',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'coll-desc' => '[[Special:Book|Maak book]]',
	'coll-collection' => 'Book',
	'coll-collections' => 'Beuk',
	'coll-exclusion_category_title' => "Laot eweg bie 't oetdrejje",
	'coll-print_template_prefix' => 'Oetdrej',
	'coll-print_template_pattern' => '$1/Oetdrej',
	'coll-create_a_book' => "Maak 'n book",
	'coll-add_page' => 'Wikipaasj bievoge',
	'coll-remove_page' => 'Wikipaasj wösje',
	'coll-add_category' => 'Zeukgroop bievoge',
	'coll-load_collection' => 'Laaj book',
	'coll-show_collection' => 'Toean book',
	'coll-help_collections' => 'Hölp bie beuk',
	'coll-n_pages' => "$1 {{PLURAL:$1|pazjena|pazjena's}}",
	'coll-unknown_subpage_title' => 'Ónbekèndje óngerpaasj',
	'coll-unknown_subpage_text' => 'Dees óngerpaasj ven [[Sprecial:Book|Book]] besteit neet',
	'coll-printable_version_pdf' => 'PDF-gaedering',
	'coll-download_as' => 'Óphaole es $1',
	'coll-noscript_text' => "<h1JavaScript is beneudj!</h1>
<strong>Diene toeaner óngerstäöntj gènne JavaScript ódder 't is aafgezatj.
Dees paasj wèrk neet goed, bezieje-s doe JavaScript aanzèts.</strong>",
	'coll-intro_text' => "Maak dien eige seleksje ven wikipazjena's.<br />
[[{{MediaWiki:Coll-helppage}}|Mieë-r weitesjap]].",
	'coll-helppage' => 'Help:Beuk',
	'coll-bookscategory' => 'Beuk',
	'coll-savedbook_template' => 'vasgezatj_book',
	'coll-your_book' => 'Dien book',
	'coll-download_title' => 'Haol óp',
	'coll-download_text' => "Drök óppe knoep óm 'n gaedering ven dien boke óp tö haole.",
	'coll-download_as_text' => "Drök óppe knoep veur 't óphaole ven 'ner offline gaedering in g'm fórmaat $1.",
	'coll-download' => 'Haol óp',
	'coll-format_label' => 'Fórmaat:',
	'coll-remove' => 'Wösje',
	'coll-show' => 'Toean',
	'coll-move_to_top' => 'Gans euveróppes',
	'coll-move_up' => 'Euveróppes',
	'coll-move_down' => 'Óngeróppes',
	'coll-move_to_bottom' => 'Gans óngeróppes',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Óngertitel:',
	'coll-contents' => 'Inhawd',
	'coll-drag_and_drop' => "De kins de wikipazjena's en huidstukke sleipe óm ze te ordene",
	'coll-create_chapter' => 'Huidstök make',
	'coll-sort_alphabetically' => 'Alfabetisch sortere',
	'coll-clear_collection' => 'Laeg book',
	'coll-clear_collection_confirm' => 'Wils se dien book èch laege?',
	'coll-rename' => 'Hèrnömme',
	'coll-new_chapter' => "Veur de naam ven 't nuuj huidstök inne",
	'coll-rename_chapter' => "Veur 'ne nuuje naam in veur 't huidstök",
	'coll-no_such_category' => 'De kattegorie besteit neet',
	'coll-notitle_title' => "De titel ven g'r pazjena kós neet vasgesteldj waere.",
	'coll-post_failed_title' => 'POST-verzeuk mislök',
	'coll-post_failed_msg' => "'t POS-verzeuk göch $1 is mislók ($2).",
	'coll-mwserve_failed_title' => 'Fout inne renderserver',
	'coll-mwserve_failed_msg' => 'De renderserver goof de vólgendje foutmèljing: <nowiki>$1</nowiki>',
	'coll-error_reponse' => "De server haet 'n foutmèljing trökgegaeve",
	'coll-empty_collection' => 'Laeg book',
	'coll-revision' => 'Versie: $1',
	'coll-save_collection_title' => 'Dien book ópslaon èn deile',
	'coll-save_collection_text' => "Kees 'n lokaasje:",
	'coll-login_to_save' => "Es se beuk wils ópslaon veur later gebroek, [[Special:UserLogin|mèlj öch den aaf óf maak 'ne gebroeker aan]].",
	'coll-personal_collection_label' => 'Perseunlik book:',
	'coll-community_collection_label' => 'Gemeinsjappelik book:',
	'coll-save_collection' => 'Slaon book óp',
	'coll-save_category' => 'Beuk waere ópslaon inne kattegorie [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'De paasj besteit al. Euversjrieve?',
	'coll-overwrite_text' => "D'r besteit al 'n pazjena mitte naam [[:$1]].
Wils se daen pazjena vervange doear öch kolleksje?",
	'coll-yes' => 'Jao',
	'coll-no' => 'Nae',
	'coll-load_overwrite_text' => "De höbs al 'n aantal paazjes in dien book.
Wils se dien hujig book euversjrieve, de nuuj paazjes d'raanzètte óf 't laaje ven dit book aafbraeke?",
	'coll-overwrite' => 'Euversjrieve',
	'coll-append' => "D'raanzètte",
	'coll-cancel' => 'Aafbraeke',
	'coll-update' => 'Vervèrse',
	'coll-limit_exceeded_title' => 'Book is tö groeat',
	'coll-limit_exceeded_text' => "Dien book is tö groeat.
De kins gein paazjes mieë d'raanzètte.",
	'coll-rendering_title' => 'Renderendj',
	'coll-rendering_text' => '<p><strong>Het document wörd aangemaak.</strong></p>

<p><strong>Voortgang:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Deze pazjena wörd regelmatig biegewerk.
As dit neet werk, klik dan op de knoep "Vernuuje" in diene browser.</p>',
	'coll-rendering_status' => '<strong>Staat:</strong> $1',
	'coll-rendering_article' => '(wikipaasj: $1)',
	'coll-rendering_page' => '(paasj: $1)',
	'coll-rendering_finished_title' => 'Rendere aafgeröndj',
	'coll-rendering_finished_text' => '<strong>Het document is aangemaak.</strong>
<strong>[$1 t bestandj downloade]</strong>.

Opmerkinge:
* Neet tevrede mit de oetveur? Op de [[{{MediaWiki:Coll-helppage}}|hulppagina euver collecties]] staon tips om deze te verbaetere.',
	'coll-notfound_title' => 'Book neet gevónje',
	'coll-notfound_text' => 'Bookpaasj is neet gevónje.',
	'coll-is_cached' => '<ul><li>d\'r Is \'n versje ven \'t dokument besjikber inne cache, dös opnuuj rendere woor neet neudig.
<a href="$1">Opnuuj rendere.</a></li></ul>',
	'coll-excluded-templates' => '* Sjebloeaner inne kattegorie [[:Category:$1|$1]] waere genegeerdj.',
	'coll-blacklisted-templates' => '* Sjebloeaner óppe zwarte lies [[:$1]] waere genegeerdj.',
	'coll-return_to_collection' => '<p>Trökgaon nao <a href="$1">$2</a></p>',
	'coll-book_title' => 'Bestèl es gedrök book',
	'coll-book_text' => "De kins 'n gedrök book bestèlle bie 'ne print-on-demandpartner:",
	'coll-order_from_pp' => 'Bestèl book bie $1',
	'coll-about_pp' => 'Euver $1',
	'coll-invalid_podpartner_title' => 'Óngèljige print-on-demandpartner',
	'coll-invalid_podpartner_msg' => "D'n ópgegaeve print-on-demandpartner is óngèljig.
Nöm kóntak óp mid öche MediaWikiadmin.",
	'coll-license' => 'Lisens',
	'coll-return_to' => 'Trök göch [[:$1]]',
);

/** Lao (ລາວ)
 * @author Passawuth
 */
$messages['lo'] = array(
	'coll-remove' => 'ເອົາອອກ',
	'coll-yes' => 'ໃຊ່',
	'coll-no' => 'ບໍ່ໃຊ່',
);

/** Lithuanian (Lietuvių)
 * @author Homo
 */
$messages['lt'] = array(
	'coll-collection' => 'Knyga',
	'coll-collections' => 'Knygos',
	'coll-print_template_prefix' => 'Spausdinti',
	'coll-create_a_book' => 'Kurti knygą',
	'coll-add_category' => 'Pridėti kategoriją',
	'coll-printable_version_pdf' => 'PDF versija',
	'coll-download_title' => 'Atsisiųsti',
	'coll-remove' => 'Pašalinti',
	'coll-rename' => 'Pervadinti',
	'coll-no_such_category' => 'Nėra tokios kategorijos',
	'coll-yes' => 'Taip',
	'coll-no' => 'Ne',
	'coll-cancel' => 'Atšaukti',
	'coll-update' => 'Atnaujinti',
	'coll-notfound_title' => 'Knyga nerasta',
	'coll-about_pp' => 'Apie',
	'coll-license' => 'Licencija',
	'coll-return_to' => 'Grįžti į [[:$1]]',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'coll-contents' => 'Вуйлымаш',
	'coll-cancel' => 'Чараш',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'coll-desc' => '[[Special:Collection|താളുകളുടെ ശേഖരം]], PDF നിര്‍മ്മിക്കുക',
	'coll-collection' => 'ശേഖരം',
	'coll-collections' => 'ശേഖരങ്ങള്‍',
	'coll-create_a_book' => 'എന്റെ ശേഖരം',
	'coll-add_page' => 'താള്‍ ചേര്‍ക്കുക',
	'coll-remove_page' => 'താള്‍ മാറ്റുക',
	'coll-add_category' => 'വര്‍ഗ്ഗം ചേര്‍ക്കുക',
	'coll-load_collection' => 'ശേഖരം ലോഡ് ചെയ്യുക',
	'coll-show_collection' => 'ശേഖരം കാണിക്കുക',
	'coll-help_collections' => 'ശേഖരങ്ങളുടെ സഹായം',
	'coll-helppage' => 'Help:ശേഖരം',
	'coll-download_title' => 'ശേഖരം PDF ആയി ഡൗണ്‍ലോഡ് ചെയ്യുക.',
	'coll-download_text' => 'താളുകളുടെ ശേഖരത്തിന്റെ യാന്ത്രികമായി നിര്‍മ്മിക്കപ്പെട്ട PDF ഡൗലോഡ് ചെയ്യുന്നതിനു ബട്ടണില്‍ ഞെക്കുക.',
	'coll-remove' => 'നീക്കം ചെയ്യുക',
	'coll-move_to_top' => 'ഏറ്റവും മുകളിലേക്ക് നീങ്ങുക',
	'coll-move_up' => 'മുകളിലേക്കു നീങ്ങുക',
	'coll-move_down' => 'താഴേക്ക് നീങ്ങുക',
	'coll-move_to_bottom' => 'ഏറ്റവും താഴേക്ക് നീങ്ങുക',
	'coll-title' => 'ശീര്‍ഷകം:',
	'coll-subtitle' => 'ഉപശീര്‍ഷകം:',
	'coll-contents' => 'ഉള്ളടക്കം',
	'coll-create_chapter' => 'പുതിയ അദ്ധ്യായം സൃഷ്ടിക്കുക',
	'coll-sort_alphabetically' => 'താളുകള്‍ അകാദാരിക്രമത്തില്‍ ക്രമീകരിക്കുക',
	'coll-clear_collection' => 'ശേഖരം മായ്ക്കുക',
	'coll-rename' => 'പുനഃര്‍നാമകരണം ചെയ്യുക',
	'coll-new_chapter' => 'പുതിയ അദ്ധ്യായത്തിനു ഒരു പേരു കൊടുക്കുക',
	'coll-rename_chapter' => 'അദ്ധ്യായത്തിനു പുതിയൊരു പേരു കൊടുക്കുക',
	'coll-no_such_category' => 'അങ്ങനെ ഒരു വര്‍ഗ്ഗം നിലവിലില്ല',
	'coll-notitle_title' => 'താളിന്റെ തലക്കെട്ട് നിര്‍ണ്ണയിക്കുന്നതിനു കഴിഞ്ഞില്ല.',
	'coll-error_reponse' => 'സെര്‍‌വറില്‍ നിന്നു പിഴവാണെന്ന മറുപടി കിട്ടി.',
	'coll-empty_collection' => 'ശൂന്യമായ ശേഖരം',
	'coll-revision' => 'പതിപ്പ്: $1',
	'coll-save_collection_title' => 'ശേഖരം സേവ് ചെയ്യുക',
	'coll-save_collection_text' => 'ഈ ശേഖരം പിന്നിടുള്ള ഉപയോഗത്തിനായി സൂക്ഷിക്കണമെങ്കില്‍ ശേഖര തരം തിരഞ്ഞെടുത്ത് ഒരു ശീര്‍ഷകം നല്‍കുക:',
	'coll-login_to_save' => 'ശേഖരങ്ങള്‍ പിന്നീടുള്ള ഉപയോഗത്തിനായി സൂക്ഷിക്കണമെങ്കില്‍, ദയവായി [[Special:UserLogin|ലോഗിന്‍ ചെയ്യുകയോ പുതിയൊരു അക്കൗണ്ട് ഉണ്ടാക്കുകയോ ചെയ്യുക]].',
	'coll-personal_collection_label' => 'സ്വകാര്യ ശേഖരം:',
	'coll-community_collection_label' => 'സമൂഹ ശേഖരം:',
	'coll-save_collection' => 'ശേഖരം സേവ് ചെയ്യുക',
	'coll-overwrite_title' => 'താള്‍ നിലവിലുണ്ട്. അതിനെ ഓവര്‍റൈറ്റ് ചെയ്യട്ടെ?',
	'coll-overwrite_text' => '[[:$1]] എന്ന പേരില്‍ ഒരു താള്‍ നിലവിലുണ്ട്. താങ്കളുടെ ശേഖരം ആ താളിനു ബദലാക്കണോ?',
	'coll-yes' => 'ശരി',
	'coll-no' => 'ഇല്ല',
	'coll-load_overwrite_text' => 'താങ്കളുടെ ശേഖരത്തില്‍ ഇപ്പോള്‍ തന്നെ കുറച്ചു താളുകള്‍ ഉണ്ട്.
താങ്കള്‍ക്കു നിലവിലുള്ള ശേഖരം മാറ്റണോ, പുതിയ താളുകള്‍ നിലവിലുള്ളതില്‍ ചേര്‍ക്കണോ, അതോ ഈ പ്രക്രിയ നിരാകരിക്കണോ?',
	'coll-overwrite' => 'ഓവര്‍റൈറ്റ്',
	'coll-append' => 'കൂട്ടിചേര്‍ക്കുക',
	'coll-cancel' => 'റദ്ദാക്കുക',
	'coll-limit_exceeded_title' => 'ശേഖരത്തിന്റെ വലിപ്പം വളരെ കൂടുതലാണ്‌',
	'coll-limit_exceeded_text' => 'താങ്കളുടെ ശേഖരം വളരെ വലുതാണ്‌. ഇനി കൂടുതല്‍ താളുകള്‍ ചേര്‍ക്കുന്നതിനു സാദ്ധ്യമല്ല.',
	'coll-notfound_title' => 'ശേഖരം കണ്ടില്ല',
	'coll-notfound_text' => 'ശേഖര താള്‍ കണ്ടെത്താന്‍ കഴിഞ്ഞില്ല.',
	'coll-return_to_collection' => '<p><a href="$1">$2</a></p>-ലേക്കു തിരിച്ചു പോവുക',
	'coll-book_title' => 'അച്ചടിച്ച പുസ്തകം ഓര്‍ഡര്‍ ചെയ്യുക',
	'coll-book_text' => 'താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന സേവനദാതാക്കളെ സന്ദര്‍ശിച്ച് നിങ്ങളുടെ ശേഖരത്തിന്റെ അച്ചടി രൂപം ഓര്‍ഡര്‍ ചെയ്യാവുന്നതാണ്‌:',
	'coll-order_from_pp' => '$1-ല്‍ നിന്നു പുസ്തകം ഓര്‍ഡര്‍ ചെയ്യുക',
	'coll-about_pp' => '$1-നെ കുറിച്ച്',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'coll-desc' => '[[Special:Collection|पाने गोळा करा]], पीडीएफ तयार करा',
	'coll-collection' => 'गोळा केलेली पाने',
	'coll-collections' => 'गोळा केलेली पाने',
	'coll-create_a_book' => 'मी गोळा केलेली पाने',
	'coll-add_page' => 'पानाचा समावेश करा',
	'coll-remove_page' => 'पान काढा',
	'coll-add_category' => 'वर्गाचा समावेश करा',
	'coll-load_collection' => 'गोळाकेलेली पाने दाखवा',
	'coll-show_collection' => 'गोळा केलेली पाने दाखवा',
	'coll-help_collections' => 'पाने गोळा करण्यासाठी मदत',
	'coll-noscript_text' => '<h1>जावास्क्रीप्ट आवश्यक!</h1>
<strong>तुमचा ब्राउझार जावास्क्रीप्ट वापरू शकत नाही किंवा वापर बंद केलेला आहे.
जावास्क्रीप्ट चालू केल्याशिवाय हे पान व्यवस्थित काम करणार नाही.</strong>',
	'coll-intro_text' => 'तुम्ही काही पाने गोळा करू शकता, त्यांच्या पीडीएफ आवृत्त्या उतरवून घेऊ शकता किंवा गोळा केलेली पाने नंतर वापरण्यासाठी अथवा इतरांना देण्यासाठी जतन करून ठेऊ शकता.

अधिक माहितीसाठी [[{{MediaWiki:Coll-helppage}}|पाने गोळा करण्यासाठी मदत]] पहा.',
	'coll-helppage' => 'Help:गोळा केलेली पाने',
	'coll-download_title' => 'गोळा केलेल्या पानांची पीडीएफ आवृत्ती उतरवून घ्या',
	'coll-download_text' => 'तुम्ही गोळा केलेल्या पानांच्या पीडीएफ आवृत्त्या गोळा करण्यासाठी, दिलेली कळ दाबा.',
	'coll-remove' => 'वगळा',
	'coll-move_to_top' => 'सर्वात वर हलवा',
	'coll-move_up' => 'वर हलवा',
	'coll-move_down' => 'खाली हलवा',
	'coll-move_to_bottom' => 'सर्वात खाली हलवा',
	'coll-title' => 'शीर्षक:',
	'coll-subtitle' => 'उपशीर्षक:',
	'coll-contents' => 'अनुक्रमणिका',
	'coll-create_chapter' => 'नवीन धडा बनवा',
	'coll-sort_alphabetically' => 'अक्षरांप्रमाणे पानांचे वर्गीकरण करा',
	'coll-clear_collection' => 'सर्व गोळा केलेली पाने पुसा',
	'coll-rename' => 'नाव बदला',
	'coll-new_chapter' => 'नवीन धड्याचे नाव लिहा',
	'coll-rename_chapter' => 'नवीन धड्याचे नाव लिहा',
	'coll-no_such_category' => 'असा वर्ग अस्तित्वात नाही',
	'coll-notitle_title' => 'या पानाचे शीर्षक ठरविता आलेले नाही.',
	'coll-post_failed_title' => 'पोस्ट (POST) ची मागणी पूर्ण झालेली नाही',
	'coll-post_failed_msg' => '$1 ची पोस्ट (POST) मागणी पूर्ण झालेली नाही ($2).',
	'coll-error_reponse' => 'सर्व्हर कडून चुकीचा संदेश आलेला आहे',
	'coll-empty_collection' => 'रिकामे कलेक्शन',
	'coll-revision' => 'आवृत्ती: $1',
	'coll-save_collection_title' => 'कलेक्शन जतन करा',
	'coll-save_collection_text' => 'हे कलेक्शन नंतर वापरण्यासाठी पानाला शीर्षक देउन तसेच कलेक्शनचा प्रकार निवडून जतन करा:',
	'coll-login_to_save' => 'जर तुम्ही कलेक्शन नंतर वापरण्यासाठी जतन करू इच्छित असाल, तर कृपया [[Special:UserLogin|प्रवेश करा अथवा सदस्य नोंदणी करा]].',
	'coll-personal_collection_label' => 'वैयक्तिक कलेक्शन:',
	'coll-community_collection_label' => 'सामुहिक कलेक्शन:',
	'coll-save_collection' => 'कलेक्शन जतन करा',
	'coll-overwrite_title' => 'पान अस्तित्वात आहे. पुनर्लेखन करायचे का?',
	'coll-overwrite_text' => '[[:$1]] या नावाचे पान अगोदरच अस्तित्वात आहे.
तुम्ही त्यावर तुमचे कलेक्शन पुनर्लेखित करू इच्छिता का?',
	'coll-yes' => 'होय',
	'coll-no' => 'नाही',
	'coll-load_overwrite_text' => 'तुमच्या कलेक्शन मध्ये अगोदरच काही पाने आहेत.
तुम्ही तुमचे कलेक्शन पुनर्लेखित करू इच्छिता, की पाने वाढवू इच्छिता की रद्द करु इच्छिता?',
	'coll-overwrite' => 'पुनर्लेखन करा',
	'coll-append' => 'वाढवा',
	'coll-cancel' => 'रद्द करा',
	'coll-limit_exceeded_title' => 'कलेक्शन खूप मोठे झालेले आहे',
	'coll-limit_exceeded_text' => 'तुमचे पानांचे कलेक्शन खूप मोठे झालेले आहे.
आणखी पाने वाढविता येणार नाहीत.',
	'coll-notfound_title' => 'कलेक्शन सापडले नाही',
	'coll-notfound_text' => 'कलेक्शन पान सापडले नाही.',
	'coll-return_to_collection' => '<p><a href="$1">$2</a></p> कडे परत जा',
	'coll-book_title' => 'छापील आवृत्तीची मागणी नोंदवा',
	'coll-book_text' => 'तुम्ही खाली दिलेल्या मागणीनुसार छपाई करणार्‍या जोडीदारांच्या संकेतस्थळाला भेट देऊन तुमच्या कलेक्शन मधील पानांची छापील आवृत्ती मिळवू शकता:',
	'coll-order_from_pp' => '$1 कडून छापील प्रत मागवा',
	'coll-about_pp' => '$1 बद्दल',
	'coll-invalid_podpartner_title' => 'चुकीचा POD भागीदार',
	'coll-invalid_podpartner_msg' => 'दिलेला POD भागीदार चुकीचा आहे.
कृपया मीडियाविकि प्रबंधकाशी संपर्क करा.',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'coll-desc' => '[[Special:Book|Mencipta buku]]',
	'coll-collection' => 'Buku',
	'coll-collections' => 'Buku',
	'coll-exclusion_category_title' => 'Tidak dicetak',
	'coll-print_template_prefix' => 'Cetak',
	'coll-create_a_book' => 'Cipta buku',
	'coll-add_page' => 'Tambah laman wiki',
	'coll-remove_page' => 'Buang laman wiki',
	'coll-add_category' => 'Tambah kategori',
	'coll-load_collection' => 'Muat buku',
	'coll-show_collection' => 'Papar buku',
	'coll-help_collections' => 'Bantuan buku',
	'coll-n_pages' => '$1 laman',
	'coll-unknown_subpage_title' => 'Sublaman tidak dikenali',
	'coll-unknown_subpage_text' => 'Sublaman [[Special:Book|Buku]] ini tidak wujud',
	'coll-printable_version_pdf' => 'Versi PDF',
	'coll-download_as' => 'Muat turun $1',
	'coll-noscript_text' => '<h1>JavaScript diperlukan!</h1>
<strong>JavaScript tidak disokong oleh pelayan anda atau telah dilumpuhkan. Laman ini tidak dapat berfungsi sekiranya ciri JavaScript tidak diaktifkan.</strong>',
	'coll-intro_text' => 'Cipta dan urus koleksi laman wiki untuk kegunaan persendirian.<br />Lihat [[{{MediaWiki:Coll-helppage}}]] untuk maklumat lanjut.',
	'coll-helppage' => 'Help:Buku',
	'coll-bookscategory' => 'Buku',
	'coll-your_book' => 'Buku anda',
	'coll-download_title' => 'Muat turun',
	'coll-download_text' => 'Untuk memuat turun versi luar talian, sila pilih format dan klik butang yang berkenaan.',
	'coll-download_as_text' => 'Untuk memuat turun versi luar talian dalam format $1, sila klik butang berikut.',
	'coll-download' => 'Muat turun',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Buang',
	'coll-show' => 'Papar',
	'coll-move_to_top' => 'Naikkan ke puncak',
	'coll-move_up' => 'Naikkan',
	'coll-move_down' => 'Turunkan',
	'coll-move_to_bottom' => 'Turunkan ke dasar',
	'coll-title' => 'Tajuk:',
	'coll-subtitle' => 'Tajuk kecil:',
	'coll-contents' => 'Kandungan',
	'coll-drag_and_drop' => 'Seret dan letak untuk menyusun semula laman dan bab',
	'coll-create_chapter' => 'Cipta bab',
	'coll-sort_alphabetically' => 'Susun mengikut tertib abjad',
	'coll-clear_collection' => 'Kosongkan buku',
	'coll-clear_collection_confirm' => 'Betul anda mahu mengosongkan buku anda?',
	'coll-rename' => 'Tukar nama',
	'coll-new_chapter' => 'Masukkan nama untuk bab baru',
	'coll-rename_chapter' => 'Masukkan nama baru untuk bab',
	'coll-no_such_category' => 'Kategori tidak wujud',
	'coll-notitle_title' => 'Tajuk laman tidak dapat dipastikan.',
	'coll-post_failed_title' => 'Permintaan POST gagal',
	'coll-post_failed_msg' => 'Permintaan POST terhadap $1 gagal ($2).',
	'coll-mwserve_failed_title' => 'Ralat pelayan jana',
	'coll-mwserve_failed_msg' => 'Terdapat ralat pada pelayan jana: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Jawapan ralat daripada pelayan',
	'coll-empty_collection' => 'Buku kosong',
	'coll-revision' => 'Semakan: $1',
	'coll-save_collection_title' => 'Simpan dan kongsi buku anda',
	'coll-save_collection_text' => 'Pilih lokasi:',
	'coll-login_to_save' => 'Jika anda mahu menyimpan buku anda untuk kegunaan masa depan, sila [[Special:UserLogin|log masuk atau buka akaun baru]].',
	'coll-personal_collection_label' => 'Buku peribadi:',
	'coll-community_collection_label' => 'Buku komuniti:',
	'coll-save_collection' => 'Simpan buku',
	'coll-save_category' => 'Semua buku disimpan dalam kategori [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Laman telah pun wujud. Tulis ganti?',
	'coll-overwrite_text' => 'Laman dengan nama [[:$1]] telah pun wujud. Adakah anda mahu menggantikannya dengan koleksi anda?',
	'coll-yes' => 'Ya',
	'coll-no' => 'Tidak',
	'coll-load_overwrite_text' => 'Buku anda telah pun mengandungi beberapa laman. Adakah anda mahu menulis ganti buku anda, menambah kandungan baru tersebut, atau batal?',
	'coll-overwrite' => 'Tulis ganti',
	'coll-append' => 'Tambah',
	'coll-cancel' => 'Batal',
	'coll-update' => 'Kemas kini',
	'coll-limit_exceeded_title' => 'Buku terlalu besar',
	'coll-limit_exceeded_text' => 'Buku anda terlalu besar dan laman tidak boleh ditambah lagi.',
	'coll-rendering_title' => 'Menjana',
	'coll-rendering_text' => '<p><strong>Sila tunggu sementara dokumen tersebut dijana.</strong></p>

<p><strong>Perkembangan:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Laman ini akan disegarkan semula secara automatik dalam beberapa saat.
Jika tidak, sila tekan butang \'\'refresh\'\' di pelayar web anda.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(laman wiki: $1)',
	'coll-rendering_page' => '(laman: $1)',
	'coll-rendering_finished_title' => 'Penjanaan selesai',
	'coll-rendering_finished_text' => '<strong>Fail dokumen tersebut telah dijana.</strong>
<strong>[$1 Muat turun fail ini]</strong> ke dalam komputer anda.

Catatan:
* Tidak berpuas hati dengan output yang dihasilkan? Lihat [[{{MediaWiki:Coll-helppage}}|laman bantuan mengenai koleksi]] untuk mengetahui bagaimana anda boleh memperbaikinya lagi.',
	'coll-notfound_title' => 'Buku tidak dijumpai',
	'coll-notfound_text' => 'Laman buku tidak dapat dijumpai.',
	'coll-is_cached' => '<ul><li>Versi simpanan (cache) bagi dokumen itu telah pun dijumpai, oleh itu penjanaan tidak diperlukan. <a href="$1">Arahkan penjanaan semula.</a></li></ul>',
	'coll-excluded-templates' => '* Templat-templat dalam kategori [[:Category:$1|$1]] telah dikecualikan.',
	'coll-blacklisted-templates' => '* Templat-templat dalam senarai hitam [[:$1]] telah dikecualikan.',
	'coll-return_to_collection' => '<p>Kembali ke <a href="$1">$2</a></p>',
	'coll-book_title' => 'Tempah buku bercetak',
	'coll-book_text' => 'Dapatkan buku bercetak daripada rakan percetakan kami:',
	'coll-order_from_pp' => 'Tempah buku daripada $1',
	'coll-about_pp' => 'Perihal $1',
	'coll-invalid_podpartner_title' => 'Rakan POD tidak sah',
	'coll-invalid_podpartner_msg' => 'Rakan POD yang dibekalkan tidak sah. Sila hubungi pentadbir MediaWiki anda.',
	'coll-license' => 'Lesen',
	'coll-return_to' => 'Kembali ke [[:$1]]',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'coll-cancel' => 'Annulla',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'coll-add_page' => 'Поладомс лопа',
	'coll-add_category' => 'Поладомс категория',
	'coll-download' => 'Таргамс',
	'coll-remove' => 'Нардык',
	'coll-title' => 'Коняксозо:',
	'coll-rename' => 'Лемдемс одов',
	'coll-no_such_category' => 'Истямо категория арась',
	'coll-save_collection_title' => 'Ванстомс пурнавксонть',
	'coll-community_collection_label' => 'Вейтьсэнь пурнавксось:',
	'coll-yes' => 'Истя',
	'coll-no' => 'Арась',
	'coll-notfound_title' => 'Пурнавксось а муеви',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'coll-print_template_prefix' => 'Tictepoztlahcuilōz',
	'coll-show' => 'Tiquittāz',
	'coll-title' => 'Tōcāitl:',
	'coll-revision' => 'Tlachiyaliztli: $1',
	'coll-yes' => 'Quēmah',
	'coll-no' => 'Ahmo',
	'coll-cancel' => 'Ticcuepāz',
	'coll-update' => 'Tiquiyancuīyāz',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'coll-desc' => '[[Special:Book|Böker opstellen]]',
	'coll-collection' => 'Book',
	'coll-collections' => 'Böker',
	'coll-exclusion_category_title' => 'Bi’t Drucken weglaten',
	'coll-print_template_prefix' => 'Drucken',
	'coll-print_template_pattern' => '$1/Drucken',
	'coll-create_a_book' => 'Book opstellen',
	'coll-add_page' => 'Wikisied tofögen',
	'coll-remove_page' => 'Wikisied rutnehmen',
	'coll-add_category' => 'Kategorie tofögen',
	'coll-load_collection' => 'Book laden',
	'coll-show_collection' => 'Book wiesen',
	'coll-help_collections' => 'Help to Böker',
	'coll-n_pages' => '$1 {{PLURAL:$1|Sied|Sieden}}',
	'coll-unknown_subpage_title' => 'Unbekannt Ünnersied',
	'coll-unknown_subpage_text' => 'Disse Ünnersied vun dat [[Special:Book|Book]] gifft dat nich',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-download_as' => 'As $1 dalladen',
	'coll-noscript_text' => '<h1>Javascript nödig!</h1>
<strong>Dien Browser ünnerstütt keen Javascript oder Javascript is utschalt.
Disse Sied löppt blot richtig, wenn Javascript an is.</strong>',
	'coll-intro_text' => 'Stell dien egen Utwahl an Sieden tohoop un verwalt jem.<br />Kiek na de [[{{MediaWiki:Coll-helppage}}|Help to Böker]] för mehr Infos.',
	'coll-helppage' => 'Help:Böker',
	'coll-bookscategory' => 'Böker',
	'coll-savedbook_template' => 'Spiekert Book',
	'coll-your_book' => 'Dien Book',
	'coll-download_title' => 'Dalladen',
	'coll-download_text' => 'En Offline-Version daltoladen, wähl en Format un klick op den Knoop.',
	'coll-download_as_text' => 'Üm en Version in Format $1 daltoladen, klick op den Knopp.',
	'coll-download' => 'Dalladen',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Rutnehmen',
	'coll-show' => 'Wiesen',
	'coll-move_to_top' => 'ganz na baven',
	'coll-move_up' => 'na baven',
	'coll-move_down' => 'dal',
	'coll-move_to_bottom' => 'ganz dal',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Ünnertitel:',
	'coll-contents' => 'Inholt',
	'coll-drag_and_drop' => 'Mit de Muus kannst du Sieden un Kapittels schuven un ümsorteren',
	'coll-create_chapter' => 'Kapittel opstellen',
	'coll-sort_alphabetically' => 'Alphabeetsch sorteren',
	'coll-clear_collection' => 'Book leddigmaken',
	'coll-clear_collection_confirm' => 'Wullt du dien Book worraftig leddig maken?',
	'coll-rename' => 'Ne’en Naam geven',
	'coll-new_chapter' => 'Ne’en Naam för dat ne’e Kapittel angeven',
	'coll-rename_chapter' => 'Ne’en Naam för dat Kapittel angeven',
	'coll-no_such_category' => 'So’n Kategorie gifft dat nich',
	'coll-notitle_title' => 'De Titel vun de Sied kunn nich faststellt warrn.',
	'coll-post_failed_title' => 'POST-Anfraag hett nich klappt',
	'coll-post_failed_msg' => 'POST-Anfraag an $1 hett nich klappt ($2).',
	'coll-mwserve_failed_title' => 'Render-Serverfehler',
	'coll-mwserve_failed_msg' => 'Op’n Render-Server hett dat en Fehler geven: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Fehlernaricht vun’n Server',
	'coll-empty_collection' => 'Leddig Book',
	'coll-revision' => 'Version: $1',
	'coll-save_collection_title' => 'Spieker un deel dien Book',
	'coll-save_collection_text' => 'En Oort wählen:',
	'coll-login_to_save' => 'Wenn du Böker för later spiekern wullt, denn [[Special:UserLogin|mell di an oder stell en Brukerkonto op]].',
	'coll-personal_collection_label' => 'Persöönlich Book:',
	'coll-community_collection_label' => 'Gemeenschopsbook:',
	'coll-save_collection' => 'Book spiekern',
	'coll-save_category' => 'All Böker warrt in de Kategorie [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] insorteert.',
	'coll-overwrite_title' => 'Sied gifft dat al. Överschrieven?',
	'coll-overwrite_text' => 'Dat gifft al en Sied mit’n Naam [[:$1]]. Wullt du ehr gegen dien Sammlung utwesseln?',
	'coll-yes' => 'Jo',
	'coll-no' => 'Nee',
	'coll-load_overwrite_text' => 'In dien Book sünd al welk Sieden in.
Wullt du dat aktuelle Book överschrieven, de ne’en Sieden achtern ranhängen oder dat Laden vun dit Book afbreken?',
	'coll-overwrite' => 'Överschrieven',
	'coll-append' => 'Tofögen',
	'coll-cancel' => 'Afbreken',
	'coll-update' => 'Opfrischen',
	'coll-limit_exceeded_title' => 'Book to groot',
	'coll-limit_exceeded_text' => 'Dien Book is to groot.
Köönt keen Sieden mehr toföögt warrn.',
	'coll-rendering_title' => 'An’t Rendern',
	'coll-rendering_text' => '<p><strong>Wees gedüllig, solang de Datei opstellt warrt.</strong></p>

<p><strong>Foortgang:</strong> <span id="renderingProgress">$1</span> % <span id="renderingStatus">$2</span></p>

<p>Disse Sied schull sik normalerwies alle poor Sekunnen sülvst opfrischen.
Wenn dat aver nich so is, denn kannst du op den „Opfrischen“-Knopp vun dien Browser klicken.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(Wikisied: $1)',
	'coll-rendering_page' => '(Sied: $1)',
	'coll-rendering_finished_title' => 'Rendern trech',
	'coll-rendering_finished_text' => '<strong>De Datei is nu opstellt.</strong>
<strong>[$1 Datei dalladen]</strong>.

Henwiesen:
* Büst du nich tofreden mit de Datei? De Utgaav to verbetern, gifft dat Tipps bi de [[{{MediaWiki:Coll-helppage}}|Help to Böker]].',
	'coll-notfound_title' => 'Book nich funnen',
	'coll-notfound_text' => 'Booksied kunn nich funnen warrn.',
	'coll-is_cached' => '<ul><li>Dat geev en twischenspiekert Version vun dat Dokument, nee Rendern weer nich nödig. <a href="$1">Nu nee rendern.</a></li></ul>',
	'coll-excluded-templates' => '* Vörlagen ut de Kategorie [[:Category:$1|$1]] sünd utslaten bleven.',
	'coll-blacklisted-templates' => '* Vörlagen vun de Swarte List [[:$1]] sünd utslaten bleven.',
	'coll-return_to_collection' => '<p>Trüch na <a href="$1">$2</a></p>',
	'coll-book_title' => 'As druckt Book bestellen',
	'coll-book_text' => 'Bestell en druckt Book bi een vun uns Print-on-Demand-Partners:',
	'coll-order_from_pp' => 'Book bestellen bi $1',
	'coll-about_pp' => 'Över $1',
	'coll-invalid_podpartner_title' => 'Ungülligen Print-on-Demand-Partner',
	'coll-invalid_podpartner_msg' => 'De Angaven to’n Print-on-Demand-Partner sünd verkehrt. Neem Kuktakt op mit den MediaWiki-Administrater.',
	'coll-license' => 'Lizenz',
	'coll-return_to' => 'Trüch na [[:$1]]',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'coll-desc' => '[[Special:Book|Boeken maken]]',
	'coll-collection' => 'Boek',
	'coll-collections' => 'Boeken',
	'coll-exclusion_category_title' => "Vortlaoten bie 't ofdrokken",
	'coll-print_template_prefix' => 'Ofdrokken',
	'coll-print_template_pattern' => '$1/Ofdrokken',
	'coll-create_a_book' => 'Boek maken',
	'coll-add_page' => 'Wikipagina derbie',
	'coll-remove_page' => 'Wikipagina deruut',
	'coll-add_category' => 'Kattegerie derbie',
	'coll-load_collection' => 'Boek laojen',
	'coll-show_collection' => 'Boek laoten zien',
	'coll-help_collections' => 'Hulpe bie boeken',
	'coll-n_pages' => "$1 {{PLURAL:$1|pagina|pagina's}}",
	'coll-unknown_subpage_title' => 'Onbekende subpagina',
	'coll-unknown_subpage_text' => 'Disse subpagina van [[Special:Book|Boek]] besteet neet',
	'coll-printable_version_pdf' => 'PDF-versie',
	'coll-download_as' => 'Oflaojen as $1',
	'coll-intro_text' => "Stel joew eigen selectie van wikipagina's samen en beheer 't.<br />Zie [[{{MediaWiki:Coll-helppage}}]] veur meer infermasie.",
	'coll-helppage' => 'Help:Boeken',
	'coll-bookscategory' => 'Boeken',
	'coll-savedbook_template' => 'op-esleugen_boek',
	'coll-your_book' => 'Joew boek',
	'coll-download_title' => 'Oflaojen',
	'coll-download_text' => 'Um een versie van joew boek of te laojen, kies een fermaot en klik op de knoppe.',
);

/** Dutch (Nederlands)
 * @author Erwin85
 * @author GerardM
 * @author McDutchie
 * @author Mwpnl
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'coll-desc' => '[[Special:Book|Boeken maken]]',
	'coll-collection' => 'Boek',
	'coll-collections' => 'Boeken',
	'coll-exclusion_category_title' => 'Weglaten bij afdrukken',
	'coll-print_template_prefix' => 'Afdruk',
	'coll-print_template_pattern' => '$1/Afdrukken',
	'coll-create_a_book' => 'Boek maken',
	'coll-add_page' => 'Wikipagina toevoegen',
	'coll-add_page_tooltip' => 'De huidige wikipagina aan uw boek toevoegen',
	'coll-remove_page' => 'Wikipagina verwijderen',
	'coll-remove_page_tooltip' => 'De huidige wikipagina uit uw boek verwijderen',
	'coll-add_category' => 'Categorie toevoegen',
	'coll-add_category_tooltip' => "Alle pagina's in deze categorie aan uw boek toevoegen",
	'coll-load_collection' => 'Boek laden',
	'coll-load_collection_tooltip' => 'Dit boek als uw huidige boek laden',
	'coll-show_collection' => 'Boek weergeven',
	'coll-show_collection_tooltip' => 'Klik om ow boek te bewerken/downloaden/bestellen',
	'coll-help_collections' => 'Hulp bij boeken',
	'coll-help_collections_tooltip' => 'De hulppagina voor boeken weergeven',
	'coll-n_pages' => "$1 {{PLURAL:$1|pagina|pagina's}}",
	'coll-unknown_subpage_title' => 'Onbekende subpagina',
	'coll-unknown_subpage_text' => 'Deze subpagina van [[Special:Book|Boek]] bestaat niet',
	'coll-printable_version_pdf' => 'PDF-versie',
	'coll-download_as' => 'Downloaden als $1',
	'coll-noscript_text' => '<h1>JavaScript is vereist!</h1>
<strong>Uw browser understeunt geen JavaScript of JavaScript is uitgeschakeld.
Deze pagina werkt niet correct tenzij u JavaScript inschakelt.</strong>',
	'coll-intro_text' => "Maak uw eigen selectie van wikipagina's.<br />
[[{{MediaWiki:Coll-helppage}}|Meer informatie]].",
	'coll-helppage' => 'Help:Boeken',
	'coll-bookscategory' => 'Boeken',
	'coll-savedbook_template' => 'opgeslagen_boek',
	'coll-your_book' => 'Uw boek',
	'coll-download_title' => 'Downloaden',
	'coll-download_text' => 'Klik op de knop om een versie van uw boek te downloaden.',
	'coll-download_as_text' => 'Klik op de knop voor het downloaden van een offline versie in het formaat $1.',
	'coll-download' => 'Downloaden',
	'coll-format_label' => 'Formaat:',
	'coll-remove' => 'Verwijderen',
	'coll-show' => 'Weergeven',
	'coll-move_to_top' => 'Helemaal naar boven',
	'coll-move_up' => 'Naar boven',
	'coll-move_down' => 'Naar onderen',
	'coll-move_to_bottom' => 'Helemaal naar onderen',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Ondertitel:',
	'coll-contents' => 'Inhoud',
	'coll-drag_and_drop' => "U kunt de wikipagina's en hoofstukken slepen om ze te ordenen",
	'coll-create_chapter' => 'Hoofdstuk maken',
	'coll-sort_alphabetically' => 'Alfabetisch sorteren',
	'coll-clear_collection' => 'Boek leegmaken',
	'coll-clear_collection_tooltip' => "Alle pagina's uit uw huidige boek verwijderen",
	'coll-clear_collection_confirm' => 'Wilt u uw boek werkelijk leegmaken?',
	'coll-rename' => 'Hernoemen',
	'coll-new_chapter' => 'Voer de naam van het nieuwe hoofdstuk in',
	'coll-rename_chapter' => 'Voer een nieuwe naam in voor het hoofdstuk',
	'coll-no_such_category' => 'De categorie bestaat niet',
	'coll-notitle_title' => 'De titel van de pagina kon niet vastgesteld worden.',
	'coll-post_failed_title' => 'POST-verzoek mislukt',
	'coll-post_failed_msg' => 'Het POST-verzoek naar $1 is mislukt ($2).',
	'coll-mwserve_failed_title' => 'Fout in de renderserver',
	'coll-mwserve_failed_msg' => 'De renderserver gaf de volgende foutmelding: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'De server heeft een foutmelding teruggegeven',
	'coll-empty_collection' => 'Leeg boek',
	'coll-revision' => 'Versie: $1',
	'coll-save_collection_title' => 'Uw boek opslaan en delen',
	'coll-save_collection_text' => 'Kies een locatie:',
	'coll-login_to_save' => 'Indien u boeken wilt opslaan voor later gebruik, [[Special:UserLogin|meldt u zich dan aan of maak een gebruiker aan]].',
	'coll-personal_collection_label' => 'Persoonlijk boek:',
	'coll-community_collection_label' => 'Gemeenschappelijk boek:',
	'coll-save_collection' => 'Boek opslaan',
	'coll-save_category' => 'Boeken worden opgeslagen in de categorie [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'De pagina bestaat al. Overschrijven?',
	'coll-overwrite_text' => 'Er bestaat al een pagina met de naam [[:$1]].
Wil u die pagina vervangen door uw collectie?',
	'coll-yes' => 'Ja',
	'coll-no' => 'Nee',
	'coll-load_overwrite_text' => "U hebt al een aantal pagina's in uw boek.
Wilt u uw huidige boek overschrijven, de nieuwe pagina's toevoegen óf het laden van dit boek annuleren?",
	'coll-overwrite' => 'Overschrijven',
	'coll-append' => 'Toevoegen',
	'coll-cancel' => 'Annuleren',
	'coll-update' => 'Verversen',
	'coll-limit_exceeded_title' => 'Boek is te groot',
	'coll-limit_exceeded_text' => "Uw boek is te groot.
U kunt geen pagina's meer toevoegen.",
	'coll-rendering_title' => 'Bezig met renderen',
	'coll-rendering_text' => '<p><strong>Het document wordt aangemaakt.</strong></p>

<p><strong>Voortgang:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Deze pagina wordt regelmatig bijgewerkt.
Als dit niet werkt, klik dan op de knop "Vernieuwen" in uw browser.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wikipagina: $1)',
	'coll-rendering_page' => '(pagina: $1)',
	'coll-rendering_finished_title' => 'Renderen afgerond',
	'coll-rendering_finished_text' => '<strong>Het document is aangemaakt.</strong>
<strong>[$1 Het bestand downloaden]</strong>.

Opmerkingen:
* Niet tevreden met de uitvoer? Op de [[{{MediaWiki:Coll-helppage}}|hulppagina over collecties]] staan tips om deze uitvoer te verbeteren.',
	'coll-notfound_title' => 'Boek niet gevonden',
	'coll-notfound_text' => 'Boekpagina is niet gevonden.',
	'coll-is_cached' => '<ul><li>Er is een versie van het document beschikbaar in de cache, dus opnieuw renderen was niet nodig.
<a href="$1">Opnieuw renderen.</a></li></ul>',
	'coll-excluded-templates' => '* Sjablonen in de categorie [[:Category:$1|$1]] worden genegeerd.',
	'coll-blacklisted-templates' => '* Sjablonen op de zwarte lijst [[:$1]] worden genegeerd.',
	'coll-return_to_collection' => '<p>Teruggaan naar <a href="$1">$2</a></p>',
	'coll-book_title' => 'Als gedrukt boek bestellen',
	'coll-book_text' => 'U kunt een gedrukt boek bestellen bij een print-on-demand-partner:',
	'coll-order_from_pp' => 'Boek bij $1 bestellen',
	'coll-about_pp' => 'Over $1',
	'coll-invalid_podpartner_title' => 'Ongeldige print on demand-partner',
	'coll-invalid_podpartner_msg' => 'De opgegeven print on demand-partner is ongeldig.
Neem contact op met uw MediaWiki-beheerder.',
	'coll-license' => 'Licentie',
	'coll-return_to' => 'Terug naar [[:$1]]',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'coll-desc' => '[[Special:Book|Opprett bøker]]',
	'coll-collection' => 'Bok',
	'coll-collections' => 'Bøker',
	'coll-exclusion_category_title' => 'Ekskluder ved utskrift',
	'coll-print_template_prefix' => 'Skriv ut',
	'coll-print_template_pattern' => '$1/Skriv ut',
	'coll-create_a_book' => 'Opprett ei bok',
	'coll-add_page' => 'Legg til wikisida',
	'coll-remove_page' => 'Fjern wikisida',
	'coll-add_category' => 'Legg til kategori',
	'coll-load_collection' => 'Last bok',
	'coll-show_collection' => 'Vis bok',
	'coll-help_collections' => 'Bokhjelp',
	'coll-n_pages' => '{{PLURAL:$1|éi sida|$1 sider}}',
	'coll-unknown_subpage_title' => 'Ukjend undersida',
	'coll-unknown_subpage_text' => 'Denne undersida av [[Special:Book|Bok]] finst ikkje',
	'coll-printable_version_pdf' => 'PDF-versjon',
	'coll-download_as' => 'Last ned som $1',
	'coll-noscript_text' => '<h1>JavaScript er påkravd!</h1>
<strong>Nettlesaren din støttar ikkje JavaScript, eller JavaScript har blitt slege av. 
Denne sida vil ikkje fungera på rett måte med mindre JavaScript er slege på.</strong>',
	'coll-intro_text' => 'Lag og administrer di eiga samling av wikisider.<br /> Sjå [[{{MediaWiki:Coll-helppage}}]] for meir informasjon.',
	'coll-helppage' => 'Help:Bøker',
	'coll-bookscategory' => 'Bøker',
	'coll-savedbook_template' => 'lagra_bok',
	'coll-your_book' => 'Boka di',
	'coll-download_title' => 'Last ned',
	'coll-download_text' => 'For å lasta ned ein fråkopla versjon, vel eit format og trykk på knappen.',
	'coll-download_as_text' => 'For å lasta ned ein versjon i $1-format, trykk på knappen.',
	'coll-download' => 'Last ned',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Fjern',
	'coll-show' => 'Vis',
	'coll-move_to_top' => 'Flytt til toppen',
	'coll-move_up' => 'Flytt opp',
	'coll-move_down' => 'Flytt ned',
	'coll-move_to_bottom' => 'Flytt til botnen',
	'coll-title' => 'Tittel:',
	'coll-subtitle' => 'Undertittel:',
	'coll-contents' => 'Innhald',
	'coll-drag_and_drop' => 'Nytt dra og slepp for å endra på rekkjefølgja på wikisider og kapittel',
	'coll-create_chapter' => 'Opprett kapittel',
	'coll-sort_alphabetically' => 'Sorter alfabetisk',
	'coll-clear_collection' => 'Tøm bok',
	'coll-clear_collection_confirm' => 'Vil du verkeleg fjerna alle sidene i boka di?',
	'coll-rename' => 'Gje nytt namn',
	'coll-new_chapter' => 'Skriv inn namn for det nye kapittelet',
	'coll-rename_chapter' => 'Skriv inn det nye namnet til kapittelet',
	'coll-no_such_category' => 'Ingen kategori ved dette namnet',
	'coll-notitle_title' => 'Fann ikkje ut tittelen på sida.',
	'coll-post_failed_title' => 'POST-førespurnaden mislukkast',
	'coll-post_failed_msg' => 'POST-førespurnaden til $1 mislukkast ($2).',
	'coll-mwserve_failed_title' => 'Renderingstenarfeil',
	'coll-mwserve_failed_msg' => 'Ein feil oppstod på renderingstenaren: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Feilrespons frå tenaren',
	'coll-empty_collection' => 'Tom bok',
	'coll-revision' => 'Versjon: $1',
	'coll-save_collection_title' => 'Lagra og del boka di',
	'coll-save_collection_text' => 'Vel ei plassering:',
	'coll-login_to_save' => 'Om du vil lagra bøkene for seinare bruk, [[Special:UserLogin|logg inn eller opprett ein konto]].',
	'coll-personal_collection_label' => 'Personleg bok:',
	'coll-community_collection_label' => 'Fellesskapsbok:',
	'coll-save_collection' => 'Lagra bok',
	'coll-save_category' => 'Bøker er lagra i kategorien [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Sida finst.
Skriva over ho?',
	'coll-overwrite_text' => 'Ei sida med namnet [[:$1]] finst frå før. 
Vil du at ho skal verta erstatta med boka di?',
	'coll-yes' => 'Ja',
	'coll-no' => 'Nei',
	'coll-load_overwrite_text' => 'Du har allereie nokre sider i boka di.
Vil du erstatta den noverande boka di, leggja til det nye innhaldet eller avbryta lastinga av boka?',
	'coll-overwrite' => 'Erstatta',
	'coll-append' => 'Leggja til',
	'coll-cancel' => 'Avbryta',
	'coll-update' => 'Oppdater',
	'coll-limit_exceeded_title' => 'Boka er for stor',
	'coll-limit_exceeded_text' => 'Boka di er for stor.
Fleire sider kan ikkje verta lagt til.',
	'coll-rendering_title' => 'Opprettar',
	'coll-rendering_text' => '<p><strong>Ver venleg og vent medan dokumentet blir oppretta.</strong></p>

<p><strong>Framsteg:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Denne sida bør automatisk verta lasta inn på nytt med eit par sekunds mellomrom. Om dette ikkje fungerer, trykk på oppdateringsknappen i nettlesaren din.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wikisida: $1)',
	'coll-rendering_page' => '(sida: $1)',
	'coll-rendering_finished_title' => 'Oppretta',
	'coll-rendering_finished_text' => '<strong>Dokumentfila har vorte oppretta.</strong>
<strong>[$1 Last ned fila]</strong> til datamaskina di.

Merk:
* Ikkje nøgd med resultatet? Sjå [[{{Mediawiki:Coll-helppage}}|hjelpesida om samlingar]] for moglegheiter til å forbetra det.',
	'coll-notfound_title' => 'Boka vart ikkje funnen',
	'coll-notfound_text' => 'Kunne ikkje finna boksida.',
	'coll-is_cached' => '<ul><li>Ein mellomlagra versjon av dokumentet vart funnen, so ingen rendrering var naudsynleg. <a href="$1">Tving ny rendrering.</a></li></ul>',
	'coll-excluded-templates' => '* Malar i kategorien [[:Category:$1|$1]] har vortne utelatne.',
	'coll-blacklisted-templates' => '* Malar på svartelista ([[:$1]]) har vortne utelatne.',
	'coll-return_to_collection' => '<p>Attende til <a href="$1">$2</a></p>',
	'coll-book_title' => 'Ting som ei trykt bok',
	'coll-book_text' => 'Få ei printa bok frå vår print-på-tinging-partnar:',
	'coll-order_from_pp' => 'Ting bok frå $1',
	'coll-about_pp' => 'Om $1',
	'coll-invalid_podpartner_title' => 'Ikkje gyldig POD-partnar',
	'coll-invalid_podpartner_msg' => 'Den oppgjevne POD-partneran er ugyldig.
Kontakt MediaWiki-administratoren din.',
	'coll-license' => 'Lisens',
	'coll-return_to' => 'Attende til [[:$1]]',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Boivie
 * @author H92
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Laaknor
 */
$messages['no'] = array(
	'coll-desc' => '[[Special:Book|Lag bøker]]',
	'coll-collection' => 'Bok',
	'coll-collections' => 'Bøker',
	'coll-exclusion_category_title' => 'Ekskluder ved utskrift',
	'coll-print_template_prefix' => 'Skriv ut',
	'coll-create_a_book' => 'Opprett en bok',
	'coll-add_page' => 'Legg til wikiside',
	'coll-remove_page' => 'Fjern wikiside',
	'coll-add_category' => 'Legg til kategori',
	'coll-load_collection' => 'Last bok',
	'coll-show_collection' => 'Vis bok',
	'coll-help_collections' => 'Bokhjelp',
	'coll-n_pages' => '$1 {{PLURAL:$1|side|sider}}',
	'coll-unknown_subpage_title' => 'Ukjent underside',
	'coll-unknown_subpage_text' => "Denne undersiden av ''[[Special:Book|Bok]]'' finnes ikke",
	'coll-printable_version_pdf' => 'PDF-versjon',
	'coll-download_as' => 'Last ned som $1',
	'coll-noscript_text' => '<h1>JavaScript er påkrevd!</h1>
<strong>Nettleseren din støtter ikke JavaScript, eller JavaScript har blitt slått av. Denne siden vil ikke fungere riktig med mindre JavaScript er slått på.</strong>',
	'coll-intro_text' => 'Lag og administrer din egen samling av wikisider.<br /> Se [[{{MediaWiki:Coll-helppage}}]] for mer informasjon.',
	'coll-helppage' => 'Help:Bøker',
	'coll-bookscategory' => 'Bøker',
	'coll-savedbook_template' => 'lagret_bok',
	'coll-your_book' => 'Din bok',
	'coll-download_title' => 'Last ned',
	'coll-download_text' => 'For å laste ned en offline-versjon velg et format og trykk på knappen.',
	'coll-download_as_text' => 'For å laste ned en versjon i $1-format, trykk på knappen.',
	'coll-download' => 'Last ned',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Fjern',
	'coll-show' => 'Vis',
	'coll-move_to_top' => 'Flytt til toppen',
	'coll-move_up' => 'Flytt opp',
	'coll-move_down' => 'Flytt ned',
	'coll-move_to_bottom' => 'Flytt til bunnen',
	'coll-title' => 'Tittel:',
	'coll-subtitle' => 'Undertittel:',
	'coll-contents' => 'Innhold',
	'coll-drag_and_drop' => 'For å bruke dra og slipp for å endre på wikisider og kapitler',
	'coll-create_chapter' => 'Opprett kapittel',
	'coll-sort_alphabetically' => 'Sorter alfabetisk',
	'coll-clear_collection' => 'Tøm bok',
	'coll-clear_collection_confirm' => 'Vil du virkelig tømme boka?',
	'coll-rename' => 'Gi nytt navn',
	'coll-new_chapter' => 'Skriv inn navn for det nye kapittelet',
	'coll-rename_chapter' => 'Skriv inn kapittelets nye navn',
	'coll-no_such_category' => 'Ingen kategori ved dette navnet',
	'coll-notitle_title' => 'Fant ikke ut av sidens tittel.',
	'coll-post_failed_title' => 'POST-forespørsel mislyktes',
	'coll-post_failed_msg' => 'POST-forespørselen til $1 mislyktes ($2).',
	'coll-mwserve_failed_title' => 'Rendreringsserverfeil',
	'coll-mwserve_failed_msg' => 'En feil oppsto på rendreringsserveren: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Feilrespons fra tjeneren',
	'coll-empty_collection' => 'Tom bok',
	'coll-revision' => 'Revisjon: $1',
	'coll-save_collection_title' => 'Lagre og del boka',
	'coll-save_collection_text' => 'Velg en plassering:',
	'coll-login_to_save' => 'Om du vil lagre bøker for senere bruk, [[Special:UserLogin|logg inn eller opprett en konto]].',
	'coll-personal_collection_label' => 'Personlig bok:',
	'coll-community_collection_label' => 'Fellesskapsbok:',
	'coll-save_collection' => 'Lagre bok',
	'coll-save_category' => 'Bøker lagres i kategorien [[:Category:{{MediaWiki:Coll-collection}}|{{MediaWiki:Coll-collection}}]].',
	'coll-overwrite_title' => 'Siden finnes. Erstatte den?',
	'coll-overwrite_text' => 'En side ved navn [[:$1]] finnes fra før. Vil du erstatte den med samlingen din?',
	'coll-yes' => 'Ja',
	'coll-no' => 'Nei',
	'coll-load_overwrite_text' => 'Du har allerede noen sider i boka di.
Vil du erstatte den eksisterende boka, legge til det nye innholdet eller avbryte lasting av boka?',
	'coll-overwrite' => 'Erstatte',
	'coll-append' => 'Legge til',
	'coll-cancel' => 'Avbryt',
	'coll-update' => 'Oppdater',
	'coll-limit_exceeded_title' => 'Boka er for stor',
	'coll-limit_exceeded_text' => 'Boka er for stor.
Ingen flere sider kan legges til.',
	'coll-rendering_title' => 'Oppretter',
	'coll-rendering_text' => '<p><strong>Venligst vent mens dokumentet genereres.</strong></p>

<p><strong>Fremskritt:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Denne siden bør automatisk lastes på nytt med et par sekunders mellomrom. Hvis dette ikke fungerer, trykk på oppdateringsknappen i din nettleser.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wikiside: $1)',
	'coll-rendering_page' => '(side: $1)',
	'coll-rendering_finished_title' => 'Opprettet',
	'coll-rendering_finished_text' => '<strong>Dokumentfilen har blitt laget.</strong>
<strong>[$1 Last ned filen]</strong> til din datamaskin.

Merk:
* Ikke fornøyd med resultatet? Se [[{{MediaWiki:Coll-helppage}}|hjelpsiden om samlinger]] for muligheter til å forbedre den.',
	'coll-notfound_title' => 'Bok ikke funnet',
	'coll-notfound_text' => 'Kunne ikke finne bokside.',
	'coll-is_cached' => '<ul><li>En mellomlagret versjon av dokumentet ble funnet, så ingen rendrering var nødvendig. <a href="$1">Tving ny rendrering.</a></li></ul>',
	'coll-excluded-templates' => '* Maler i kategorien [[:Category:$1|$1]] har blitt utelatt.',
	'coll-blacklisted-templates' => '* Maler på svartelisten ([[:$1]]) har blitt utelatt.',
	'coll-return_to_collection' => '<p>Tilbake til <a href="$1">$2</a></p>',
	'coll-book_title' => 'Bestill som en trykket bok',
	'coll-book_text' => 'Få en printet bok fra vår print-på-bestilling-partner:',
	'coll-order_from_pp' => 'Bestill bok fra $1',
	'coll-about_pp' => 'Om $1',
	'coll-invalid_podpartner_title' => 'Ugyldig POD-partner',
	'coll-invalid_podpartner_msg' => 'Den oppgitte POD-partneren er ugyldig.
Kontakt din MediaWiki-administrator.',
	'coll-license' => 'Lisens',
	'coll-return_to' => 'Tilbake til [[:$1]]',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'coll-desc' => '[[Special:Book|Crear de libres]]',
	'coll-collection' => 'Libre',
	'coll-collections' => 'Libres',
	'coll-exclusion_category_title' => "Exclaure al moment de l'estampatge",
	'coll-print_template_prefix' => 'Estampar',
	'coll-print_template_pattern' => '$1/Print',
	'coll-create_a_book' => 'Crear un libre',
	'coll-add_page' => 'Apondre una pagina wiki',
	'coll-remove_page' => 'Levar una pagina wiki',
	'coll-add_category' => 'Apondre una categoria',
	'coll-load_collection' => 'Cargar un libre',
	'coll-show_collection' => 'Afichar lo libre',
	'coll-help_collections' => 'Ajuda suls libres',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagina|paginas}}',
	'coll-unknown_subpage_title' => 'Sospagina desconeguda',
	'coll-unknown_subpage_text' => 'Aquesta sospagina de [[Special:Book|libre]] existís pas',
	'coll-printable_version_pdf' => 'Version del PDF',
	'coll-download_as' => 'Telecargat coma $1',
	'coll-noscript_text' => "<h1>Javascript es necessari !</h1>
<strong>Vòstre navigador supòrta pas Javascript o se l'a desactivat.
Aquesta pagina s'aficharà pas corrèctament tant que javascript serà pas activat.</strong>",
	'coll-intro_text' => "Crear e gerir vòstra seleccion individuala de paginas wiki..<br />Vejatz [[{{MediaWiki:Coll-helppage}}|la pagina d'ajuda sus las colleccions]] per mai d'informacions.",
	'coll-helppage' => 'Help:Libres',
	'coll-bookscategory' => 'Libres',
	'coll-savedbook_template' => 'libre_salvat',
	'coll-your_book' => 'Vòstre libre',
	'coll-download_title' => 'Telecargar',
	'coll-download_text' => 'Per telecargar una version fòra de linha causissètz un format e picatz sul boton.',
	'coll-download_as_text' => 'Per telecargar una version fòra-linha dins lo format $1 clicatz sul boton.',
	'coll-download' => 'Telecargar',
	'coll-format_label' => 'Format :',
	'coll-remove' => 'Levar',
	'coll-show' => 'Visionar',
	'coll-move_to_top' => 'Desplaçar tot en naut',
	'coll-move_up' => 'Pujar',
	'coll-move_down' => 'Davalar',
	'coll-move_to_bottom' => 'Desplaçar tot en bas',
	'coll-title' => 'Títol :',
	'coll-subtitle' => 'Sostítol :',
	'coll-contents' => 'Contengut',
	'coll-drag_and_drop' => 'Utilizar lissar-depausar per reordenar las paginas e los capítols wiki.',
	'coll-create_chapter' => 'Crear un capítol',
	'coll-sort_alphabetically' => 'Triar per òrdre alfabetic',
	'coll-clear_collection' => 'Voidar lo libre',
	'coll-clear_collection_confirm' => 'Volètz vertadièrament escafar l’integralitat de vòstre libre ?',
	'coll-rename' => 'Tornar nomenar',
	'coll-new_chapter' => 'Entrar lo títol del capitol novèl',
	'coll-rename_chapter' => 'Entrar lo títol novèl pel capitol',
	'coll-no_such_category' => 'Pas de tala categoria',
	'coll-notitle_title' => 'Lo títol de la pagina pòt pas èsser determinat.',
	'coll-post_failed_title' => 'Fracàs de la requèsta POST',
	'coll-post_failed_msg' => 'La requèsta POST cap a $1 a pas capitat ($2).',
	'coll-mwserve_failed_title' => 'Error del servidor del rendut',
	'coll-mwserve_failed_msg' => 'Una error es intervenguda sul servidor balhant lo rendut : <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Lo servidor a rencontrat una error',
	'coll-empty_collection' => 'Libre void',
	'coll-revision' => 'Version : $1',
	'coll-save_collection_title' => 'Salvar e partejar vòstre libre',
	'coll-save_collection_text' => 'Causissètz un emplaçament :',
	'coll-login_to_save' => 'Se volètz salvar vòstre libre, [[Special:UserLogin|vos cal vos connectar o vos crear un compte]].',
	'coll-personal_collection_label' => 'Libre personal :',
	'coll-community_collection_label' => 'Libre collectiu :',
	'coll-save_collection' => 'Salvar lo libre',
	'coll-save_category' => 'Los libres son salvats dins la categoria [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => "La pagina existís. L'espotir ?",
	'coll-overwrite_text' => 'Una pagina amb lo títol [[:$1]] existís ja.
La volètz remplaçar per vòstra compilacion ?',
	'coll-yes' => 'Òc',
	'coll-no' => 'Non',
	'coll-load_overwrite_text' => "Ja avètz de paginas dins vòstre libre.
Volètz espotir vòstre libre actual, i apondre lo contengut o alara anullar lo cargament d'aqueste ?",
	'coll-overwrite' => 'Espotir',
	'coll-append' => 'Apondre',
	'coll-cancel' => 'Anullar',
	'coll-update' => 'Metre a jorn',
	'coll-limit_exceeded_title' => 'Libre tròp grand',
	'coll-limit_exceeded_text' => 'Vòstre libre es tròp grand.
Cap de pagina pòt pas èsser aponduda.',
	'coll-rendering_title' => 'Rendut',
	'coll-rendering_text' => '<p><strong>Pacientatz pendent que lo document es en cors de creacion.</strong></p>

<p><strong>Progression :</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Aquesta pagina se deuriá actualizar automaticament per intervals regulars de qualques segondas.
S\'èra pas lo cas, clicatz sul boton d’actualizacion de vòstre navigador.</p>',
	'coll-rendering_status' => '<strong>Estatut :</strong> $1',
	'coll-rendering_article' => '(pagina wiki : $1)',
	'coll-rendering_page' => '(pagina : $1)',
	'coll-rendering_finished_title' => 'Rendut acabat',
	'coll-rendering_finished_text' => '<strong>Lo fichièr document es estat creat.</strong>
<strong>[$1 Telecargatz-lo]</strong> sus vòstre ordenador.

Nòtas :
* Pas satisfach(a) de la sortida ? Vejatz [[{{MediaWiki:Coll-helppage}}|la pagina d’ajuda que concernís las colleccions]] per las possibilitats de melhorament.',
	'coll-notfound_title' => 'Libre pas trobat',
	'coll-notfound_text' => 'Pòt pas trobar lo libre.',
	'coll-is_cached' => '<ul><li>Una version en amagatal del document es estada trobada, cap de rendut èra pas necessari. <a href="$1">Forçar lo rendut un còp de mai.</a></li></ul>',
	'coll-excluded-templates' => '* De modèls dins la categoria [[:Category:$1|$1]] son estats excluts.',
	'coll-blacklisted-templates' => '* De modèls dins la tièra negra [[:$1]] son estats excluts.',
	'coll-return_to_collection' => '<p>Tornar a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Comandar tal coma un libre estampat',
	'coll-book_text' => 'Obtenètz un libre estampat a partir de vòstre partenari d’estampatge a la demanda :',
	'coll-order_from_pp' => 'Comandar lo libre dempuèi $1',
	'coll-about_pp' => 'A prepaus de $1',
	'coll-invalid_podpartner_title' => 'Partenari POD incorrècte.',
	'coll-invalid_podpartner_msg' => 'Lo partenari POD indicat es incorrècte.
Contactatz vòstre administrator MediaWiki.',
	'coll-license' => 'Licéncia',
	'coll-return_to' => 'Tornar cap a [[:$1]]',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'coll-download_as' => 'Æрбавгæн куыд $1',
	'coll-download_title' => 'Æрбавгæн',
	'coll-download' => 'Æрбавгæн',
	'coll-title' => 'Сæргонд:',
	'coll-yes' => 'О',
	'coll-no' => 'Нæ',
	'coll-cancel' => 'Нæ бæззы',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Jwitos
 * @author Leinad
 * @author Masti
 * @author McMonster
 * @author Qblik
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'coll-desc' => '[[Special:Book|Utworzenie książki]]',
	'coll-collection' => 'Książka',
	'coll-collections' => 'Książki',
	'coll-exclusion_category_title' => 'Omiń w druku',
	'coll-print_template_prefix' => 'Drukuj',
	'coll-print_template_pattern' => '$1/Wydruk',
	'coll-create_a_book' => 'Utwórz książkę',
	'coll-add_page' => 'Dodaj stronę',
	'coll-add_page_tooltip' => 'Dodaj bieżącą stronę wiki do książki',
	'coll-remove_page' => 'Usuń stronę',
	'coll-remove_page_tooltip' => 'Usuń bieżącą stronę wiki z książki',
	'coll-add_category' => 'Dodaj kategorię',
	'coll-add_category_tooltip' => 'Dodaj wszystkie strony wiki znajdujące się w tej kategorii do książki',
	'coll-load_collection' => 'Załaduj książkę',
	'coll-load_collection_tooltip' => 'Załaduj tę książkę jako bieżącą',
	'coll-show_collection' => 'Pokaż książkę',
	'coll-show_collection_tooltip' => 'Kliknij aby edytować, pobrać lub zamówić książkę',
	'coll-help_collections' => 'Książki – pomoc',
	'coll-help_collections_tooltip' => 'Pokaż pomoc dla narzędzia tworzenia książek',
	'coll-n_pages' => '$1 {{PLURAL:$1|strona|strony|stron}}',
	'coll-unknown_subpage_title' => 'Nieznana podstrona',
	'coll-unknown_subpage_text' => 'Podstrona należąca do [[Special:Book|książki]] nie istnieje',
	'coll-printable_version_pdf' => 'Wersja PDF',
	'coll-download_as' => 'Pobierz jako $1',
	'coll-noscript_text' => '<h1>Potrzebny JavaScript!</h1>
<strong>Twoja przeglądarka nie obsługuje JavaScriptu lub został on wyłączony.
Strona nie będzie działać poprawnie, dopóki JavaScript nie zostanie włączony.</strong>',
	'coll-intro_text' => 'Utwórz i zarządzaj swoimi indywidualnie wybranymi stronami wiki.<br />Więcej informacji na [[{{MediaWiki:Coll-helppage}}|stronie pomocy dotyczącej kolekcji]].',
	'coll-helppage' => 'Help:Książki',
	'coll-bookscategory' => 'Książki',
	'coll-savedbook_template' => 'zapisane_książki',
	'coll-your_book' => 'Twoja książka',
	'coll-download_title' => 'Pobierz',
	'coll-download_text' => 'By pobrać wersję offline wybierz format i naciśnij przycisk.',
	'coll-download_as_text' => 'Aby ściągnąć wersję w formacie $1 naciśnij przycisk.',
	'coll-download' => 'Pobierz',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Usuń',
	'coll-show' => 'Pokaż',
	'coll-move_to_top' => 'Przenieś na górę',
	'coll-move_up' => 'Przenieś w górę',
	'coll-move_down' => 'Przenieś w dół',
	'coll-move_to_bottom' => 'Przenieś na dół',
	'coll-title' => 'Tytuł:',
	'coll-subtitle' => 'Podtytuł:',
	'coll-contents' => 'Spis treści',
	'coll-drag_and_drop' => 'Przeciągnij i upuść, by zmienić kolejność stron i rozdziałów',
	'coll-create_chapter' => 'Utwórz rozdział',
	'coll-sort_alphabetically' => 'Sortuj alfabetycznie',
	'coll-clear_collection' => 'Wyczyść książkę',
	'coll-clear_collection_tooltip' => 'Usuń wszystkie strony wiki z bieżącej książki',
	'coll-clear_collection_confirm' => 'Czy jesteś pewien, że chcesz wyczyścić całą zawartość książki?',
	'coll-rename' => 'Zmień nazwę',
	'coll-new_chapter' => 'Wprowadź nazwę dla nowego rozdziału',
	'coll-rename_chapter' => 'Wprowadź nową nazwę dla rozdziału',
	'coll-no_such_category' => 'Brak takiej kategorii',
	'coll-notitle_title' => 'Tytuł strony nie może być określony.',
	'coll-post_failed_title' => 'Nieudane żądanie POST',
	'coll-post_failed_msg' => 'Żądanie POST do $1 nie powiodło się ($2).',
	'coll-mwserve_failed_title' => 'Błąd serwera w renderowaniu',
	'coll-mwserve_failed_msg' => 'W serwerze renderującym wystąpił błąd <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Błąd odpowiedzi serwera',
	'coll-empty_collection' => 'Książka jest pusta',
	'coll-revision' => 'Wersja $1',
	'coll-save_collection_title' => 'Zapisz i udostępnij książkę',
	'coll-save_collection_text' => 'Wybierz lokalizację:',
	'coll-login_to_save' => 'Jeśli chcesz zapisać książkę, [[Special:UserLogin|zaloguj się lub utwórz konto]].',
	'coll-personal_collection_label' => 'Książka osobista:',
	'coll-community_collection_label' => 'Ksiązka społeczności:',
	'coll-save_collection' => 'Zapisz książkę',
	'coll-save_category' => 'Książki zapisywane są w kategorii [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Strona już istnieje. Nadpisać?',
	'coll-overwrite_text' => 'Strona pod tytułem [[:$1]] już istnieje.
Chcesz ją zastąpić swoją kolekcją?',
	'coll-yes' => 'Tak',
	'coll-no' => 'Nie',
	'coll-load_overwrite_text' => 'Masz już strony w swojej książce.
Czy chcesz nadpisać swoją obecną książkę, dodać do niej nowe strony czy anulować ładowanie tej książki?',
	'coll-overwrite' => 'Nadpisz',
	'coll-append' => 'Dopisz',
	'coll-cancel' => 'Anuluj',
	'coll-update' => 'Uaktualnij',
	'coll-limit_exceeded_title' => 'Zbyt duża książka',
	'coll-limit_exceeded_text' => 'Twoja książka jest zbyt duża.
Nie można dodać więcej stron.',
	'coll-rendering_title' => 'Renderowanie',
	'coll-rendering_text' => '<p><strong>Proszę czekać, trwa generowanie dokumentu.</strong></p>

<p><strong>Postęp:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Strona powinna automatycznie odświeżać się co kilka sekund.
Jeśli tak nie jest, proszę wymusić odświeżenie w przeglądarce.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wiki strona: $1)',
	'coll-rendering_page' => '(strona: $1)',
	'coll-rendering_finished_title' => 'Renderowanie zakończone',
	'coll-rendering_finished_text' => '<strong>Dokument został wygenerowany.</strong>
<strong>[$1 Pobierz plik]</strong> na swój komputer.

Uwaga:
* Nie jesteś zadowolony z wygenerowanego dokumentu? Zajrzyj na [[{{MediaWiki:Coll-helppage}}|stronę pomocy dotyczącą kolekcji]], aby dowiedzieć się jakie są możliwości poprawy dokumentu.',
	'coll-notfound_title' => 'Książki nie odnaleziono',
	'coll-notfound_text' => 'Nie udało się odnaleźć strony z ksiązki.',
	'coll-is_cached' => '<ul><li>Dokument został odnaleziono w pamięci podręcznej, więc nie ma potrzeby renderowania. <a href="$1">Wymuś ponowne renderowanie.</a></li></ul>',
	'coll-excluded-templates' => '* Szablony w kategorii [[:Category:$1|$1]] zostały pominięte.',
	'coll-blacklisted-templates' => '* Szablony z czarnej listy [[:$1]] zostały pominięte.',
	'coll-return_to_collection' => '<p>Powróć do <a href="$1">$2</a></p>',
	'coll-book_title' => 'Zamów w formie wydrukowanej książki',
	'coll-book_text' => 'Zamów wydrukowaną książkę od jednego z naszych partnerów realizujących usługę wydruku na żądanie:',
	'coll-order_from_pp' => 'Zamów książkę z $1',
	'coll-about_pp' => 'O $1',
	'coll-invalid_podpartner_title' => 'Niesprawny usługodawca wydruku na żądanie',
	'coll-invalid_podpartner_msg' => 'Wybrany partner wydruku na żądanie nie funkcjonuje.
Skontaktuj się z administratorem tego serwisu MediaWiki.',
	'coll-license' => 'Licencja',
	'coll-return_to' => 'Powrót do [[:$1]]',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'coll-collection' => 'غونډ',
	'coll-collections' => 'غونډونه',
	'coll-create_a_book' => 'يو کتاب جوړول',
	'coll-add_page' => 'د ويکي مخ ورګډول',
	'coll-add_category' => 'وېشنيزه ورګډول',
	'coll-help_collections' => 'د غونډونو لارښود',
	'coll-your_book' => 'ستاسو کتاب',
	'coll-remove' => 'غورځول',
	'coll-show' => 'ښکاره کول',
	'coll-title' => 'سرليک:',
	'coll-subtitle' => 'لمنليک:',
	'coll-contents' => 'مينځپانګه',
	'coll-create_chapter' => 'څپرکی جوړول',
	'coll-rename' => 'نوم بدلول',
	'coll-no_such_category' => 'داسې هېڅ کومه وېشنيزه نشته',
	'coll-save_collection_title' => 'خپل غونډ خوندي او شريک کول',
	'coll-yes' => 'هو',
	'coll-no' => 'نه',
	'coll-notfound_title' => 'غونډ و نه موندلای شو',
	'coll-about_pp' => 'د $1 په اړه',
);

/** Portuguese (Português)
 * @author 555
 * @author Heldergeovane
 * @author Lijealso
 * @author MF-Warburg
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'coll-desc' => '[[Special:Book|Cria livros]]',
	'coll-collection' => 'Livro',
	'coll-collections' => 'Livros',
	'coll-exclusion_category_title' => 'Excluir da impressão',
	'coll-print_template_prefix' => 'Imprime',
	'coll-print_template_pattern' => '$1/Imprimir',
	'coll-create_a_book' => 'Criar um livro',
	'coll-add_page' => 'Adicionar página wiki',
	'coll-remove_page' => 'Remover página wiki',
	'coll-add_category' => 'Adicionar categoria',
	'coll-load_collection' => 'Carregar livro',
	'coll-show_collection' => 'Mostrar livro',
	'coll-help_collections' => 'Ajuda sobre livros',
	'coll-n_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'coll-unknown_subpage_title' => 'Sub-página desconhecida',
	'coll-unknown_subpage_text' => 'Não existe esta sub-página do [[Special:Book|Livro]]',
	'coll-printable_version_pdf' => 'Versão em PDF',
	'coll-download_as' => 'Descarregar como $1',
	'coll-noscript_text' => '<h1>JavaScript é Requerido!</h1>
<strong>O seu "browser" não suporta JavaScript, ou o JavaScript foi desactivado.
Esta página não funcionará correctamente, excepto se o JavaScript for activado.</strong>',
	'coll-intro_text' => 'Crie e manipule sua selecção individual de páginas wiki.<br />Veja [[{{MediaWiki:Coll-helppage}}]] para mais detalhes.',
	'coll-helppage' => 'Help:Livros',
	'coll-bookscategory' => 'Livros',
	'coll-savedbook_template' => 'livro_gravado',
	'coll-your_book' => 'Seu livro',
	'coll-download_title' => 'Download',
	'coll-download_text' => 'Para descarregar uma versão offline, seleccione um formato e pressione o botão correspondente.',
	'coll-download_as_text' => "Para descarregar uma versão 'offline' em formato $1, clique no botão.",
	'coll-download' => 'Descarregar',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Remover',
	'coll-show' => 'Exibir',
	'coll-move_to_top' => 'Mover para o topo',
	'coll-move_up' => 'Mover acima',
	'coll-move_down' => 'Mover abaixo',
	'coll-move_to_bottom' => 'Mover para o fundo',
	'coll-title' => 'Título:',
	'coll-subtitle' => 'Subtítulo:',
	'coll-contents' => 'Conteúdo',
	'coll-drag_and_drop' => 'Arraste-e-solte para re-ordenar as páginas wiki e capítulos',
	'coll-create_chapter' => 'Criar capítulo',
	'coll-sort_alphabetically' => 'Ordenar alfabeticamente',
	'coll-clear_collection' => 'Esvaziar livro',
	'coll-clear_collection_confirm' => 'Deseja realmente limpar completamente o seu livro?',
	'coll-rename' => 'Renomear',
	'coll-new_chapter' => 'Introduza o nome do novo capítulo',
	'coll-rename_chapter' => 'Introduza o nome do capítulo',
	'coll-no_such_category' => 'Não existe essa categoria',
	'coll-notitle_title' => 'Não foi possível determinar o título da página.',
	'coll-post_failed_title' => 'Pedido POST falhou',
	'coll-post_failed_msg' => 'O pedido POST feito à $1 falhou ($2).',
	'coll-mwserve_failed_title' => 'Erro no servidor de renderização',
	'coll-mwserve_failed_msg' => 'Ocorreu um erro no servidor de renderização: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Resposta de erro do servidor',
	'coll-empty_collection' => 'Livro vazio',
	'coll-revision' => 'Revisão: $1',
	'coll-save_collection_title' => 'Grave e partilhe o seu livro',
	'coll-save_collection_text' => 'Defina a localização:',
	'coll-login_to_save' => 'Se pretende gravar livros para usar mais tarde, por favor, [[Special:UserLogin|autentique-se ou crie uma conta]].',
	'coll-personal_collection_label' => 'Livro pessoal:',
	'coll-community_collection_label' => 'Livro comunitário:',
	'coll-save_collection' => 'Gravar livro',
	'coll-save_category' => 'Todos os livros são gravados na categoria [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'A página existe. Escrever por cima?',
	'coll-overwrite_text' => 'Um página com o nome [[:$1]] já existe.
Deseja substituí-la pela sua colecção?',
	'coll-yes' => 'Sim',
	'coll-no' => 'Não',
	'coll-load_overwrite_text' => 'Você já possui algumas páginas no seu livro.
Pretende reescrever o seu livro atual, adicionando o novo conteúdo, ou cancelar o carregamento deste livro?',
	'coll-overwrite' => 'Reescrever',
	'coll-append' => 'Adicionar',
	'coll-cancel' => 'Cancelar',
	'coll-update' => 'Actualizar',
	'coll-limit_exceeded_title' => 'Livro demasiado grande',
	'coll-limit_exceeded_text' => 'O seu livro é demasiado grande.
Não poderão ser adicionadas mais páginas.',
	'coll-rendering_title' => 'Renderizando',
	'coll-rendering_text' => '<p><strong>Por favor, aguarde enquanto o documento é gerado.</strong></p>

<p><strong>Progresso:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Este página deverá atualizar automaticamente após alguns segundos.
Se isto não funcionar, por favor utilize o botão "atualizar" ("refresh") do seu navegador.</p>',
	'coll-rendering_status' => '<strong>Estado:</strong> $1',
	'coll-rendering_article' => '(página wiki: $1)',
	'coll-rendering_page' => '(página: $1)',
	'coll-rendering_finished_title' => 'Renderização concluída',
	'coll-rendering_finished_text' => '<strong>O ficheiro foi gerado.</strong>
<strong>[$1 Transfira o ficheiro]</strong> para o seu computador.

Notas:
* Não está satisfeito com o resultado? Veja [[{{MediaWiki:Coll-helppage}}|a página de ajuda sobre coleções]] para possibilidades de aprimoramentos.',
	'coll-notfound_title' => 'Livro não encontrado',
	'coll-notfound_text' => 'Não foi possível encontrar a página do livro.',
	'coll-is_cached' => '<ul><li>Foi encontrada uma versão deste documento em cache, dispensando a renderização. <a href="$1"> Forçar nova renderização.</a></li></ul>',
	'coll-excluded-templates' => '* As predefinições na categoria [[:Category:$1|$1]] foram excluídas.',
	'coll-blacklisted-templates' => '* As predefinições na lista negra [[:$1]] foram excluídas.',
	'coll-return_to_collection' => '<p>Regressar a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Encomendar como livro impresso',
	'coll-book_text' => 'Adquira um livro impresso do nosso parceiro de impressão-a-pedido:',
	'coll-order_from_pp' => 'Encomendar o livro de $1',
	'coll-about_pp' => 'Sobre $1',
	'coll-invalid_podpartner_title' => 'Parceiro POD inválido',
	'coll-invalid_podpartner_msg' => 'O parceiro POD é inválido.
Por favor, contacte o seu administrador MediaWiki.',
	'coll-license' => 'Licença',
	'coll-return_to' => 'Voltar para [[:$1]]',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Heldergeovane
 * @author Jorge Morais
 */
$messages['pt-br'] = array(
	'coll-desc' => '[[Special:Book|Criar livros]]',
	'coll-collection' => 'Livro',
	'coll-collections' => 'Livros',
	'coll-exclusion_category_title' => 'Excluir da impressão',
	'coll-print_template_prefix' => 'Imprime',
	'coll-print_template_pattern' => '$1/Imprimir',
	'coll-create_a_book' => 'Criar um livro',
	'coll-add_page' => 'Adicionar página wiki',
	'coll-remove_page' => 'Remover página wiki',
	'coll-add_category' => 'Adicionar categoria',
	'coll-load_collection' => 'Carregar livro',
	'coll-show_collection' => 'Mostrar livro',
	'coll-help_collections' => 'Ajuda sobre livros',
	'coll-n_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'coll-unknown_subpage_title' => 'Sub-página desconhecida',
	'coll-unknown_subpage_text' => 'Esta subpágina do [[Special:Book|Livro]] não existe',
	'coll-printable_version_pdf' => 'Versão em PDF',
	'coll-download_as' => 'Baixar como $1',
	'coll-noscript_text' => '<h1>JavaScript é requerido!</h1>
<strong>O seu navegador não suporta JavaScript, ou o JavaScript foi desactivado.
Esta página não funcionará corretamente, a menos que o JavaScript seja ativado.</strong>',
	'coll-intro_text' => 'Crie e manipule sua seleção individual de páginas wiki.<br />Veja [[{{MediaWiki:Coll-helppage}}]] para mais detalhes.',
	'coll-helppage' => 'Help:Livros',
	'coll-bookscategory' => 'Livros',
	'coll-savedbook_template' => 'livro_gravado',
	'coll-your_book' => 'Seu livro',
	'coll-download_title' => 'Baixar',
	'coll-download_text' => "Para baixar uma versão ''offline'', selecione um formato e pressione o botão correspondente.",
	'coll-download_as_text' => "Para descarregar uma versão 'offline' em formato $1, clique no botão.",
	'coll-download' => 'Baixar',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Remover',
	'coll-show' => 'Exibir',
	'coll-move_to_top' => 'Mover para o topo',
	'coll-move_up' => 'Mover acima',
	'coll-move_down' => 'Mover abaixo',
	'coll-move_to_bottom' => 'Mover para o fundo',
	'coll-title' => 'Título:',
	'coll-subtitle' => 'Subtitle:',
	'coll-contents' => 'Conteúdo',
	'coll-drag_and_drop' => 'Arraste-e-solte para re-ordenar as páginas wiki e os capítulos',
	'coll-create_chapter' => 'Criar capítulo',
	'coll-sort_alphabetically' => 'Ordenar alfabeticamente',
	'coll-clear_collection' => 'Esvaziar livro',
	'coll-clear_collection_confirm' => 'Realmente deseja esvaziar completamente o seu livro?',
	'coll-rename' => 'Renomear',
	'coll-new_chapter' => 'Introduza o nome para um novo capítulo',
	'coll-rename_chapter' => 'Introduza um novo nome para o capítulo',
	'coll-no_such_category' => 'Não existe esta categoria',
	'coll-notitle_title' => 'Não foi possível determinar o título da página.',
	'coll-post_failed_title' => 'Pedido POST falhou',
	'coll-post_failed_msg' => 'O pedido POST feito em $1 falhou ($2).',
	'coll-mwserve_failed_title' => 'Erro no servidor de renderização',
	'coll-mwserve_failed_msg' => 'Ocorreu um erro no servidor de renderização: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Resposta de erro do servidor',
	'coll-empty_collection' => 'Livro vazio',
	'coll-revision' => 'Revisão: $1',
	'coll-save_collection_title' => 'Salvar e partilhar o seu livro',
	'coll-save_collection_text' => 'Defina a localização:',
	'coll-login_to_save' => 'Se pretende salvar livros para uso posterior, por favor, [[Special:UserLogin|autentique-se ou crie uma conta]].',
	'coll-personal_collection_label' => 'Livro pessoal:',
	'coll-community_collection_label' => 'Livro comunitário:',
	'coll-save_collection' => 'Salvar livro',
	'coll-save_category' => 'Os livros são salvos na categoria [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'A página já existe.
Sobrescrever?',
	'coll-overwrite_text' => 'Um página com o nome [[:$1]] já existe.
Deseja substituí-la pela sua coleção?',
	'coll-yes' => 'Sim',
	'coll-no' => 'Não',
	'coll-load_overwrite_text' => 'Você já possui algumas páginas no seu livro.
Pretende sobrescrever a sua coleção atual, adicionar o novo conteúdo, ou cancelar o carregamento desta coleção?',
	'coll-overwrite' => 'Sobrescrever',
	'coll-append' => 'Adicionar',
	'coll-cancel' => 'Cancelar',
	'coll-update' => 'Atualizar',
	'coll-limit_exceeded_title' => 'Livro grande demais',
	'coll-limit_exceeded_text' => 'O seu livro é grande demais.
Não é possível adicionar mais páginas.',
	'coll-rendering_title' => 'Renderizando',
	'coll-rendering_text' => '<p><strong>Por favor, aguarde enquanto o documento é gerado.</strong></p>

<p><strong>Progresso:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Este página deverá se atualizar automaticamente a cada poucos segundos.
Se isto não funcionar, por favor utilize o botão atualizar do seu navegador.</p>',
	'coll-rendering_status' => '<strong>Estado:</strong> $1',
	'coll-rendering_article' => '(página wiki: $1)',
	'coll-rendering_page' => '(página: $1)',
	'coll-rendering_finished_title' => 'Renderização concluída',
	'coll-rendering_finished_text' => '<strong>O arquivo foi gerado.</strong>
<strong>[$1 Baixe o arquivo]</strong> para o seu computador.

Notas:
* Não está satisfeito com o resultado? Veja [[{{MediaWiki:Coll-helppage}}|a página de ajuda sobre coleções]] para possibilidades de aprimoramentos.',
	'coll-notfound_title' => 'Livro não encontrado',
	'coll-notfound_text' => 'Não foi possível encontrar a página do livro.',
	'coll-is_cached' => '<ul><li>Foi encontrada uma versão deste documento em cache, de modo que não foi necessária uma renderização. <a href="$1">Forçar nova renderização.</a></li></ul>',
	'coll-excluded-templates' => '* Predefinições na categoria [[:Category:$1|$1]] foram excluídas.',
	'coll-blacklisted-templates' => '* Predefinições na lista negra [[:$1]] foram excluídas.',
	'coll-return_to_collection' => '<p>Retornar para <a href="$1">$2</a></p>',
	'coll-book_title' => 'Encomendar como livro impresso',
	'coll-book_text' => 'Adquira um livro impresso de nosso parceiro de impressão-sob-demanda (POD):',
	'coll-order_from_pp' => 'Encomendar o livro de $1',
	'coll-about_pp' => 'Sobre $1',
	'coll-invalid_podpartner_title' => 'Parceiro POD inválido',
	'coll-invalid_podpartner_msg' => 'O parceiro POD fornecido é inválido.
Por favor, contate o seu administrador MediaWiki.',
	'coll-license' => 'Licença',
	'coll-return_to' => 'Voltar para [[:$1]]',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'coll-desc' => '[[Special:Collection|Colecţionează pagini]], generează fişiere PDF',
	'coll-collection' => 'Colecţie',
	'coll-collections' => 'Colecţii',
	'coll-create_a_book' => 'Creează o carte',
	'coll-add_page' => 'Adaugă pagină wiki',
	'coll-remove_page' => 'Şterge pagină wiki',
	'coll-add_category' => 'Adaugă categorie',
	'coll-load_collection' => 'Încarcă colecţie',
	'coll-show_collection' => 'Arată colecţie',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagină|pagini}}',
	'coll-your_book' => 'Cartea ta',
	'coll-remove' => 'Elimină',
	'coll-show' => 'Arată',
	'coll-title' => 'Titlu:',
	'coll-subtitle' => 'Subtitlu:',
	'coll-contents' => 'Cuprins',
	'coll-create_chapter' => 'Creează capitol',
	'coll-sort_alphabetically' => 'Ordonează alfabetic',
	'coll-rename' => 'Redenumeşte',
	'coll-post_failed_title' => 'Cerere POST eşuată',
	'coll-post_failed_msg' => 'Cererea POST către $1 a eşuat ($2).',
	'coll-error_reponse' => 'Răspuns de eroare de la server',
	'coll-empty_collection' => 'Colecţie goală',
	'coll-revision' => 'Versiune: $1',
	'coll-save_collection_title' => 'Salvează şi împarte colecţia',
	'coll-personal_collection_label' => 'Colecţie personală:',
	'coll-save_collection' => 'Salvează colecţia',
	'coll-overwrite_title' => 'Pagina există.
Suprascrie?',
	'coll-yes' => 'Da',
	'coll-no' => 'Nu',
	'coll-overwrite' => 'Suprascrie',
	'coll-cancel' => 'Anulează',
	'coll-notfound_title' => 'Colecţie negăsită',
	'coll-return_to_collection' => '<p>Întoarcere la <a href="$1">$2</a></p>',
	'coll-order_from_pp' => 'Comandă carte de la $1',
	'coll-about_pp' => 'Despre $1',
	'coll-license' => 'Licenţă',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'coll-desc' => '[[Special:Book|Ccreje le libbre]]',
	'coll-collection' => 'Libbre',
	'coll-collections' => 'Libbre',
	'coll-exclusion_category_title' => 'Esclude in stambe',
	'coll-print_template_prefix' => 'Stambe',
	'coll-create_a_book' => "Ccreje 'nu libbre",
	'coll-add_page' => "Aggiunge 'na pàgene de Uicchi",
	'coll-remove_page' => "Live 'na pàgene de Uicchi",
	'coll-add_category' => "Aggiunge 'na categorije",
	'coll-load_collection' => "Careche 'nu libbre",
	'coll-show_collection' => "Fà vedè 'nu libbre",
	'coll-help_collections' => "Aiute sus a 'u libbre",
	'coll-n_pages' => '$1 {{PLURAL:$1|pàgene|pàggene}}',
	'coll-unknown_subpage_title' => 'Sottopàgene scanusciute',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Aleksandrit
 * @author EugeneZelenko
 * @author Ferrer
 * @author Innv
 * @author Kaganer
 * @author MaxSem
 * @author Sergey kudryavtsev
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'coll-desc' => '[[Special:Book|Создаёт книги]]',
	'coll-collection' => 'Книга',
	'coll-collections' => 'Книги',
	'coll-exclusion_category_title' => 'Исключения из печати',
	'coll-print_template_prefix' => 'Печать',
	'coll-print_template_pattern' => '$1/Печать',
	'coll-create_a_book' => 'Создать книгу',
	'coll-add_page' => 'Добавить страницу',
	'coll-add_page_tooltip' => 'Добавить текущую вики-страницу в книгу',
	'coll-remove_page' => 'Удалить страницу',
	'coll-remove_page_tooltip' => 'Удалить текущую вики-страницу из книги',
	'coll-add_category' => 'Добавить категорию',
	'coll-add_category_tooltip' => 'Добавить все статьи этой категории в книгу',
	'coll-load_collection' => 'Загрузить книгу',
	'coll-load_collection_tooltip' => 'Загрузить эту книгу как вашу текущую книгу',
	'coll-show_collection' => 'Показать книгу',
	'coll-show_collection_tooltip' => 'Нажмите для редактирования/загрузки/заказа книги',
	'coll-help_collections' => 'Справка по книгам',
	'coll-help_collections_tooltip' => 'Показать справку о «книжных» инструментах',
	'coll-n_pages' => '$1 {{PLURAL:$1|страница|страницы|страниц}}',
	'coll-unknown_subpage_title' => 'Неизвестная подстраница',
	'coll-unknown_subpage_text' => 'Этой подстраницы [[Special:Book|книги]] не существует',
	'coll-printable_version_pdf' => 'PDF-версия',
	'coll-download_as' => 'Загрузить как $1',
	'coll-noscript_text' => '<h1>Требуется JavaScript!</h1>
<strong>Ваш браузер не поддерживает JavaScript или данная поддержка была отключена.
Эта страница не будет работать правильно, если JavaScript не включен.</strong>',
	'coll-intro_text' => 'Создание и управление вашей персональной коллекцией вики-страниц.<br />Подробнее см. на [[{{MediaWiki:Coll-helppage}}]].',
	'coll-helppage' => 'Help:Книги',
	'coll-bookscategory' => 'Книги',
	'coll-savedbook_template' => 'сохранённая_книга',
	'coll-your_book' => 'Ваша книга',
	'coll-download_title' => 'Загрузить',
	'coll-download_text' => 'Чтобы загрузить автономную версию, выберите формат и нажмите кнопку.',
	'coll-download_as_text' => 'Нажмите кнопку, чтобы загрузить версию в формате $1.',
	'coll-download' => 'Загрузить',
	'coll-format_label' => 'Формат:',
	'coll-remove' => 'Удалить',
	'coll-show' => 'Показать',
	'coll-move_to_top' => 'Передвинуть наверх',
	'coll-move_up' => 'Передвинуть выше',
	'coll-move_down' => 'Передвинуть ниже',
	'coll-move_to_bottom' => 'Передвинуть вниз',
	'coll-title' => 'Название:',
	'coll-subtitle' => 'Подзаголовок:',
	'coll-contents' => 'Содержание',
	'coll-drag_and_drop' => 'Чтобы упорядочить вики-страницы и главы, перетаскивайте их мышкой',
	'coll-create_chapter' => 'Создать главу',
	'coll-sort_alphabetically' => 'Упорядочивать по алфавиту',
	'coll-clear_collection' => 'Очистить книгу',
	'coll-clear_collection_tooltip' => 'Удалите все статьи из текущей книги',
	'coll-clear_collection_confirm' => 'Вы действительно желаете полностью очистить вашу книгу?',
	'coll-rename' => 'Переименовать',
	'coll-new_chapter' => 'Введите имя для новой главы',
	'coll-rename_chapter' => 'Введите новое имя главы',
	'coll-no_such_category' => 'Нет такой категории',
	'coll-notitle_title' => 'Заголовок страницы не может быть определён.',
	'coll-post_failed_title' => 'POST-запрос не выполнен',
	'coll-post_failed_msg' => 'POST-запрос к $1 не выполнен ($2).',
	'coll-mwserve_failed_title' => 'Ошибка сервера отрисовки',
	'coll-mwserve_failed_msg' => 'На сервере отрисовки произошла ошибка: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Ошибка ответа сервера',
	'coll-empty_collection' => 'Пустая книга',
	'coll-revision' => 'Версия: $1',
	'coll-save_collection_title' => 'Сохранить книгу и открыть к ней доступ',
	'coll-save_collection_text' => 'Выберите местоположение:',
	'coll-login_to_save' => 'Чтобы сохранить книгу для дальнейшего использования, пожалуйста, [[Special:UserLogin|представьтесь системе или создайте учётную запись]].',
	'coll-personal_collection_label' => 'Личная книга:',
	'coll-community_collection_label' => 'Книга сообщества:',
	'coll-save_collection' => 'Сохранить книгу',
	'coll-save_category' => 'Книги сохранены в категории [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Страница существует. Перезаписать?',
	'coll-overwrite_text' => 'Страница с именем [[:$1]] уже существует.
Вы хотите чтобы она была заменена вашей коллекцией?',
	'coll-yes' => 'Да',
	'coll-no' => 'Нет',
	'coll-load_overwrite_text' => 'У вас уже есть несколько страниц в книге.
Вы хотите перезаписать вашу текущую книгу, добавить новый материал или отменить загрузку этой книги?',
	'coll-overwrite' => 'Перезаписать',
	'coll-append' => 'Добавить',
	'coll-cancel' => 'Отменить',
	'coll-update' => 'Обновить',
	'coll-limit_exceeded_title' => 'Слишком большая книга',
	'coll-limit_exceeded_text' => 'Книга имеет слишком большой размер.
В неё больше нельзя добавлять страницы.',
	'coll-rendering_title' => 'Создание',
	'coll-rendering_text' => '<p><strong>Пожалуйста, подождите, идёт создание документа.</strong></p>

<p><strong>Ход работы:</strong> <span id="renderingProgress">$1</span> % <span id="renderingStatus">$2</span></p>

<p>Эта страница должна обновляться раз в несколько секунд.
Если этого не происходит, пожалуйста, нажмите кнопку «обновить» браузера.</p>',
	'coll-rendering_status' => '<strong>Статус:</strong> $1',
	'coll-rendering_article' => '(статья: $1)',
	'coll-rendering_page' => '(страница: $1)',
	'coll-rendering_finished_title' => 'Создание завершено',
	'coll-rendering_finished_text' => '<strong>Файл документа создан.</strong>
<strong>[$1 Загрузить файл]</strong> на свой компьютер.

Замечание:
* Не удовлетворены результатом? Возможности его улучшения описаны на [[{{MediaWiki:Coll-helppage}}|справочной странице о книгах]].',
	'coll-notfound_title' => 'Книга не найдена',
	'coll-notfound_text' => 'Невозможно найти страницу книги.',
	'coll-is_cached' => '<ul><li>Найдена закэшированная версия этого документа, отрисовка не потребовалась. <a href="$1">Всё-таки запустить отрисовку.</a></li></ul>',
	'coll-excluded-templates' => '* Шаблоны из категории [[:Category:$1|$1]] были исключены.',
	'coll-blacklisted-templates' => '* Шаблоны из чёрного списка [[:$1]] были исключены.',
	'coll-return_to_collection' => '<p>Назад к <a href="$1">$2</a></p>',
	'coll-book_title' => 'Заказать печатную книгу',
	'coll-book_text' => 'Получить печатную книгу от нашего партнёра:',
	'coll-order_from_pp' => 'Заказ книги в $1',
	'coll-about_pp' => 'О $1',
	'coll-invalid_podpartner_title' => 'Недействительный POD-партнёр',
	'coll-invalid_podpartner_msg' => 'Предоставляемый POD-партнёр недействителен.
Пожалуйста, свяжитесь с вашим администратором MediaWiki.',
	'coll-license' => 'Лицензия',
	'coll-return_to' => 'Возврат к [[:$1]]',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'coll-desc' => '[[Special:Book|Кинигэлэри айар]]',
	'coll-collection' => 'Кинигэ',
	'coll-collections' => 'Кинигэлэр',
	'coll-exclusion_category_title' => 'Бэчээккэ ыытыллыбат',
	'coll-print_template_prefix' => 'Бэчээт',
	'coll-print_template_pattern' => '$1/Бэчээт',
	'coll-create_a_book' => 'Кинигэни айарга',
	'coll-add_page' => 'Сирэйи эбии',
	'coll-remove_page' => 'Сирэйи сотуу',
	'coll-add_category' => 'Категория эбии',
	'coll-load_collection' => 'Кинигэни (атын сиртэн ылан) суруттар',
	'coll-show_collection' => 'Кинигэни көрдөр',
	'coll-help_collections' => 'Кинигэ туһунан ыйытыылар',
	'coll-n_pages' => '$1 {{PLURAL:$1|сирэй|сирэйдээх}}',
	'coll-unknown_subpage_title' => 'Биллибэт алын сирэй (подстраница)',
	'coll-unknown_subpage_text' => '[[Special:Book|Кинигэҕэ]] бу сирэй суох',
	'coll-printable_version_pdf' => 'PDF-барыла',
	'coll-download_as' => 'Маннык $1 киллэр',
	'coll-noscript_text' => '<h1>JavaScript ирдэнэр!</h1>
<strong>Эн брааузерыҥ JavaScript`ы өйөөбөт эбит эбэтэр JavaScript араарыллыбыт. Бу сирэй JavaScript холбоммотох буоллаҕына сөпкө үлэлиэ уонна көстүө суоҕа.</strong>',
	'coll-intro_text' => 'Биики-сирэйдэр тустаах, эйиэхэ бэйэҕэр эрэ аналлаах, хомуурунньуктарын оҥоруу уонна ону салайыы.<br />Сиһилии манна көр [[{{MediaWiki:Coll-helppage}}]].',
	'coll-helppage' => 'Help:Кинигэлэр',
	'coll-bookscategory' => 'Кинигэлэр',
	'coll-savedbook_template' => 'уларытыыта_бигэргэтиллибит_кинигэ',
	'coll-your_book' => 'Эн кинигэҥ',
	'coll-download_title' => 'Хачайдаа',
	'coll-download_text' => 'Оффлайн барылын көрөргө формаатын ый уонна анал тимэҕи баттаа.',
	'coll-download_as_text' => '$1 форматтаах барылы хачайдыырга тимэҕи баттаа.',
	'coll-download' => 'Хачайдаа',
	'coll-format_label' => 'Формаата:',
	'coll-remove' => 'Сот',
	'coll-show' => 'Көрдөр',
	'coll-move_to_top' => 'Үөһэ таһаар',
	'coll-move_up' => 'Арыый үөһэ таһаар',
	'coll-move_down' => 'Арыый аллара түһэр',
	'coll-move_to_bottom' => 'Олох аллара түһэр',
	'coll-title' => 'Аата:',
	'coll-subtitle' => 'Аатын быһаарыы:',
	'coll-contents' => 'Иһинээҕитэ',
	'coll-drag_and_drop' => 'Сирэйдэри уонна сирэйдэр бөлөхтөрүн бэрээдэктииргэ мышканнан туһан',
	'coll-create_chapter' => 'Баһы (главааны) оҥоруу',
	'coll-sort_alphabetically' => 'Алпабыытынан наардааһын',
	'coll-clear_collection' => 'Кинигэни ыраастаа',
	'coll-clear_collection_confirm' => 'Кырдьык кинигэҕин ыраастаары гынаҕын дуо?',
	'coll-rename' => 'Аатын уларытыы',
	'coll-new_chapter' => 'Саҥа бас (глава) аатын киллэр',
	'coll-rename_chapter' => 'Түһүмэх (глава) саҥа аатын киллэрии',
	'coll-no_such_category' => 'Маннык категория суох',
	'coll-notitle_title' => 'Сирэй аата кыайан биллибэтэ.',
	'coll-post_failed_title' => 'POST-ыйытык толоруллубата',
	'coll-post_failed_msg' => 'Манна $1 анаммыт POST-ыйытык толоруллубата ($2).',
	'coll-mwserve_failed_title' => 'Render сиэрбэрэ сыыһалаах',
	'coll-mwserve_failed_msg' => 'Отрисовка сиэрбэригэр алҕас таҕыста: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Сиэрбэр эппиэтин алҕаһа',
	'coll-empty_collection' => 'Кураанах кинигэ',
	'coll-revision' => 'Барыл: $1',
	'coll-save_collection_title' => 'Кинигэни бигэргэтэргэ уонна дьоҥҥо көстөр гынарга',
	'coll-save_collection_text' => 'Кинигэҥ миэстэтин тал:',
	'coll-login_to_save' => 'Кинигэни кэлин туһанаары гынар буоллаххына, бука диэн, [[Special:UserLogin|ааккын эт эбэтэр саҥа аатта бэлиэтээ]].',
	'coll-personal_collection_label' => 'Тус бэйэ кинигэтэ:',
	'coll-community_collection_label' => 'Бөлөх кинигэтэ:',
	'coll-save_collection' => 'Уларытыыларын бигэргэт',
	'coll-save_category' => 'Кинигэлэр бу категорияҕа баар буоллулар: [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Маннык сирэй баар эбит.
Хос суруттараҕын дуо?',
	'coll-overwrite_text' => 'Маннык [[:$1]] ааттаах сирэй баар эбит.
Ол эн кинигэҕинэн солбуллуон баҕараҕын дуо?',
	'coll-yes' => 'Сөп',
	'coll-no' => 'Суох',
	'coll-load_overwrite_text' => 'Кинигэҕэр хас да сирэй баар эбит.
Баар кинигэни хос суруттараары, саҥа матырыйаалы эбээри гвнаҕын дуу, эбэтэр кинигэни сурутууну тохтотоҕун дуу?',
	'coll-overwrite' => 'Хос суруттар',
	'coll-append' => 'Эбэн биэр',
	'coll-cancel' => 'Тохтот',
	'coll-update' => 'Саҥардан биэр',
	'coll-limit_exceeded_title' => 'Наһаа улахан эбит',
	'coll-limit_exceeded_text' => 'Кинигэ наһаа улахан.
Сирэй эбэр сатаммат.',
	'coll-rendering_title' => 'Оҥоруу',
	'coll-rendering_text' => '<p><strong>Бука диэн кэтэс, оҥоһулла турар.</strong></p>

<p><strong>Үлэ хаамыыта:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Бу сирэй аҕыйах сөкүүндэҕэ биирдэ уларыйыахтаах.
Уларыйбат буоллаҕына брааузерыҥ "саҥардыы" тимэҕин баттаа.</p>',
	'coll-rendering_status' => '<strong>Стаатуһа:</strong> $1',
	'coll-rendering_article' => '(ыстатыйа: $1)',
	'coll-rendering_page' => '(сирэй: $1)',
	'coll-rendering_finished_title' => 'Оҥоһулунна',
	'coll-rendering_finished_text' => '<strong>Дөкүмүөн билэтэ оҥоһулунна.</strong>
Бэйэ көмпүүтэригэр <strong>[$1 билэни хачайдаа]</strong>.

Биллэрии:
* Оччото суох дуо? [[{{MediaWiki:Coll-helppage}}|Кинигэлэри оҥорорго көмөҕө]] тупсарыы туһунан суруллубут.',
	'coll-notfound_title' => 'Кинигэ көстүбэтэ',
	'coll-notfound_text' => 'Кинигэ сирэйин булар табыллыбата.',
	'coll-is_cached' => '<ul><li>Бу дөкүмүөн кээштэммит барыла баар эбит, отрисовка наадата суох буолан оҥоһуллубата. <a href="$1">Ол да буоллар отрисовканы оҥорорго.</a></li></ul>',
	'coll-excluded-templates' => '* [[:Категория:$1|$1]] категорияттан халыыптар сотулуннулар.',
	'coll-blacklisted-templates' => 'Халыыптар [[:$1]] хара тиһиктэн (чёрный список) сотулуннулар.',
	'coll-return_to_collection' => '<p>Манна төнүн <a href="$1">$2</a></p>',
	'coll-book_title' => 'Бэчээттэммит кинигэни сакаастааһын',
	'coll-book_text' => 'Бэчээттэммит кинигэни биһиги партнербутуттан ылыы:',
	'coll-order_from_pp' => 'Кинигэни манна сакаастааһын: $1',
	'coll-about_pp' => '$1 туһунан',
	'coll-invalid_podpartner_title' => 'Дьиҥэ суох POD-партнёр',
	'coll-invalid_podpartner_msg' => 'Дьиҥэ суох POD-партнёр эбит.
Бука диэн MediaWiki дьаһабылын кытта кэпсэт.',
	'coll-license' => 'Лицензия',
	'coll-return_to' => 'Манна төннүү: [[:$1]]',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Mormegil
 */
$messages['sk'] = array(
	'coll-desc' => '[[Special:Book|Tvorba kníh]]',
	'coll-collection' => 'Kniha',
	'coll-collections' => 'Knihy',
	'coll-exclusion_category_title' => 'Pri tlačení vynechať',
	'coll-print_template_prefix' => 'Tlačiť',
	'coll-print_template_pattern' => '$1/Tlač',
	'coll-create_a_book' => 'Vytvoriť knihu',
	'coll-add_page' => 'Pridať wiki stránku',
	'coll-add_page_tooltip' => 'Pridať aktuálnu wiki stránku do vašej knihy',
	'coll-remove_page' => 'Odstrániť wiki stránku',
	'coll-remove_page_tooltip' => 'Odstrániť aktuálnu wiki stránku z vašej knihy',
	'coll-add_category' => 'Pridať kategóriu',
	'coll-add_category_tooltip' => 'Pridať všetky stránky wiki v tejto kategórii do vašej knihy',
	'coll-load_collection' => 'Načítať knihu',
	'coll-load_collection_tooltip' => 'Načítať túto knihu ako vašu aktuálnu knihu',
	'coll-show_collection' => 'Zobraziť knihu',
	'coll-show_collection_tooltip' => 'Kliknutím môžete upraviť/stiahnuť/objednať knihu',
	'coll-help_collections' => 'Pomocník ku knihám',
	'coll-help_collections_tooltip' => 'Zobraziť pomocníka ku knižnému nástroju',
	'coll-n_pages' => '$1 {{PLURAL:$1|stránka|stránky|stránok}}',
	'coll-unknown_subpage_title' => 'Neznáma podstránka',
	'coll-unknown_subpage_text' => 'Táto podstránka [[Special:Book|Knihy]] neexistuje',
	'coll-printable_version_pdf' => 'PDF verzia',
	'coll-download_as' => 'Stiahnuť ako $1',
	'coll-noscript_text' => '<h1>Vyžaduje sa JavaScript!</h1>
<strong>Váš prehliadač nepodporuje JavaScript alebo máte JavaScript vypnutý.
Táto stránka nebude správne fungovať ak nezapnete JavaScript.</strong>',
	'coll-intro_text' => 'Môžete vytvárať vlastné výbery wiki stránok.<br />Pozri ďalšie informácie na [[{{MediaWiki:Coll-helppage}}|stránke pomocníka o kolekciách]].',
	'coll-helppage' => 'Help:Knihy',
	'coll-bookscategory' => 'Knihy',
	'coll-savedbook_template' => 'uložená_kniha',
	'coll-your_book' => 'Vaša kniha',
	'coll-download_title' => 'Stiahnuť',
	'coll-download_text' => 'Po zvolení formátu a kliknutí na tlačidlo môžete stiahnuť offline verziu.',
	'coll-download_as_text' => 'Verziu pre čítanie offline vo formáte $1 môžete stiahnuť kliknutím na tlačidlo.',
	'coll-download' => 'Stiahnuť',
	'coll-format_label' => 'Formát:',
	'coll-remove' => 'Odstrániť',
	'coll-show' => 'Zobraziť',
	'coll-move_to_top' => 'Presunúť na vrch',
	'coll-move_up' => 'Presunúť vyššie',
	'coll-move_down' => 'Presunúť nižšie',
	'coll-move_to_bottom' => 'Presunúť na spodok',
	'coll-title' => 'Názov:',
	'coll-subtitle' => 'Podnázov:',
	'coll-contents' => 'Obsah',
	'coll-drag_and_drop' => 'Zmeniť poradie článkov a kapitol môžete pomocou ťahaj&pusť.',
	'coll-create_chapter' => 'Vytvoriť kapitolu',
	'coll-sort_alphabetically' => 'Zoradiť abecedne',
	'coll-clear_collection' => 'Vyčistiť knihu',
	'coll-clear_collection_tooltip' => 'Odstrániť všetky stránky wiki z vašej aktuálnej knihy',
	'coll-clear_collection_confirm' => 'Skutočne chcete celkom vyčistiť svoju knihu?',
	'coll-rename' => 'Premenovať',
	'coll-new_chapter' => 'Zadajte názov novej kapitoly',
	'coll-rename_chapter' => 'Zadajte nový názov kapitoly',
	'coll-no_such_category' => 'Taká kategória neexistuje',
	'coll-notitle_title' => 'Názov stránky nebolo možné určiť.',
	'coll-post_failed_title' => 'Chyba požiadavky POST',
	'coll-post_failed_msg' => 'Chyba požiadavky POST na $1 ($2).',
	'coll-mwserve_failed_title' => 'Chyba vykresľovacieho servera',
	'coll-mwserve_failed_msg' => 'Vyskytla sa chyba vykresľovacieho servera: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Chybná odpoveď servera',
	'coll-empty_collection' => 'Prázdna kniha',
	'coll-revision' => 'Revízia: $1',
	'coll-save_collection_title' => 'Uložiť a zdieľať svoju knihu',
	'coll-save_collection_text' => 'Vyberte umiestnenie:',
	'coll-login_to_save' => 'Ak chcete ukladať knihy pre neskoršie použitie, prosím, [[Special:UserLogin|prihláste sa alebo si vytvorte účet]].',
	'coll-personal_collection_label' => 'Osobná kniha:',
	'coll-community_collection_label' => 'Komunitná kniha:',
	'coll-save_collection' => 'Uložiť knihu',
	'coll-save_category' => 'Knihy sa ukladajú v kategórii [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Stránka existuje. Prepísať?',
	'coll-overwrite_text' => 'Stránka s názvom [[:$1]] už existuje.
Chcete ju nahradiť svojou kolekciou?',
	'coll-yes' => 'Áno',
	'coll-no' => 'Nie',
	'coll-load_overwrite_text' => 'Vo vašej knihe sa už nachádzajú stránky.
Chcete prepísať svoju existujúcu knihu, pridať do nej obsah alebo zrušiť načítanie tejto knihy?',
	'coll-overwrite' => 'Prepísať',
	'coll-append' => 'Pridať',
	'coll-cancel' => 'Zrušiť',
	'coll-update' => 'Aktualizovať',
	'coll-limit_exceeded_title' => 'Kniha je príliš veľká',
	'coll-limit_exceeded_text' => 'Vaša kniha je príliš veľká.
Nie je možné pridať ďalšie stránky.',
	'coll-rendering_title' => 'Vykresľovanie',
	'coll-rendering_text' => '<p><strong>Prosím, čakajte, kým sa vytvorí dokument.</strong></p>

<p><strong>Priebeh:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Táto stránka by sa mala vždy po niekoľkých sekundách obnoviť.
Ak to nefunguje, stlačte prosím tlačidlo obnoviť vo vašom prehlidači.</p>',
	'coll-rendering_status' => '<strong>Stav:</strong> $1',
	'coll-rendering_article' => '(wiki stránka: $1)',
	'coll-rendering_page' => '(stránka: $1)',
	'coll-rendering_finished_title' => 'Vykresľovanie je dokončené',
	'coll-rendering_finished_text' => '<strong>Súbor dokumentu bol vytvorený.</strong>
Môžete ho <strong>[$1 stiahnuť]</strong> na svoj počítač.

Poznámky:
* Nie ste spokojný s výstupom? Spôsoby možnej nápravy nájdete na [[{{MediaWiki:Coll-helppage}}|stránke pomocníka o kolekciách]].',
	'coll-notfound_title' => 'Kniha nenájdená',
	'coll-notfound_text' => 'Nebolo možné nájsť stránku knihy.',
	'coll-is_cached' => '<ul><li>Bola nájdená verzia dokumentu vo vyrovnávacej pamäti, takže vykresľovanie nebolo potrebné. <a href="$1">Vynútiť opätovné vykreslenie.</a></li></ul>',
	'coll-excluded-templates' => '* Boli vynechané šablóny v kategórii [[:Category:$1|$1]].',
	'coll-blacklisted-templates' => '* Boli vynechané šablóny na čiernej listine [[:$1]].',
	'coll-return_to_collection' => '<p>Vrátiť sa na <a href="$1">$2</a></p>',
	'coll-book_title' => 'Objednať ako tlačenú knihu',
	'coll-book_text' => 'Môžete si objednať tlačenú knihu od jedného z našich partnerov, ktorí robia tlač na vyžiadanie:',
	'coll-order_from_pp' => 'Objednať knihu od $1',
	'coll-about_pp' => 'O $1',
	'coll-invalid_podpartner_title' => 'Neplatný POD partner',
	'coll-invalid_podpartner_msg' => 'Zadaný POD partner je neplatný.
Prosím, kontaktujte svojho správcu MediaWiki.',
	'coll-license' => 'Licencia',
	'coll-return_to' => 'Návrat na [[:$1]]',
);

/** Slovenian (Slovenščina)
 * @author Smihael
 */
$messages['sl'] = array(
	'coll-desc' => '[[Special:Book|Ustvari e-knjige]]',
	'coll-collection' => 'Knjiga',
	'coll-collections' => 'Knjige',
	'coll-exclusion_category_title' => 'Izključi v tiskovini',
	'coll-print_template_prefix' => 'Natisni',
	'coll-print_template_pattern' => '$1/Natisni',
	'coll-create_a_book' => 'Ustvari e-knjigo',
	'coll-add_page' => 'Dodaj wiki-stran',
	'coll-remove_page' => 'Odstrani wiki-stran',
	'coll-add_category' => 'Dodaj kategorijo',
	'coll-load_collection' => 'Naloži knjige',
	'coll-show_collection' => 'Prikaži knjige',
	'coll-help_collections' => 'Pomoč za knjige',
	'coll-n_pages' => '$1 {{PLURAL:$1|stran|strani|strani|strani|strani}}',
	'coll-unknown_subpage_title' => 'Neznana podstran',
	'coll-unknown_subpage_text' => 'Ta podstran [[Special:Book|knjige]] ne obstaja',
	'coll-printable_version_pdf' => 'Različica PDF',
	'coll-download_as' => 'Prenesi kot $1',
	'coll-noscript_text' => '<h1>Zahtevan je JavaScript!</h1>
<strong>Vaš brskalnik ne podpira JavaScripta ali je podpora zanj izključena.
Ta stran ne bo delovala pravilno bren omogočenega JavaScripta.</strong>',
	'coll-intro_text' => 'Ustvarite in urejajte svoje individualno izbiro wiki-strani.<br />Glej [[{{MediaWiki:Coll-helppage}}]] za več informacij.',
	'coll-helppage' => 'Help:Knjige',
	'coll-bookscategory' => 'Knjige',
	'coll-savedbook_template' => 'shranjena_knjiga',
	'coll-your_book' => 'Vaša knjiga',
	'coll-download_title' => 'Prenesi',
	'coll-download_text' => 'Če želite naložiti različico, izberite obliko in kliknite na gumb.',
	'coll-download_as_text' => 'Za prenos različice v obliki $1 kliknite na gumb.',
	'coll-download' => 'Prenesi',
	'coll-format_label' => 'Oblika:',
	'coll-remove' => 'Odstrani',
	'coll-show' => 'Pokaži',
	'coll-move_to_top' => 'Premakni na vrh',
	'coll-move_up' => 'Premakni gor',
	'coll-move_down' => 'Premakni dol',
	'coll-move_to_bottom' => 'Premakni na dno',
	'coll-title' => 'Naslov:',
	'coll-subtitle' => 'Podnaslov:',
	'coll-contents' => 'Vsebina',
	'coll-drag_and_drop' => 'Uporabite metodo povleci in spusti, da preuredite vrstni red wiki-strani in poglavij',
	'coll-create_chapter' => 'Ustvari poglavje',
	'coll-sort_alphabetically' => 'Razvrsti po abecedi',
	'coll-clear_collection' => 'Zbriši knjigo',
	'coll-clear_collection_confirm' => 'Ali res želite popolnoma izbrisati vašo knjigo?',
	'coll-rename' => 'Preimenuj',
	'coll-new_chapter' => 'Vnesite ime za novo poglavje',
	'coll-rename_chapter' => 'Vnesite novo ime za poglavje',
	'coll-no_such_category' => 'Ne obstaja nobena taka kategorija',
	'coll-notitle_title' => 'Naslov strani ni bi bilo mogoče določiti.',
	'coll-post_failed_title' => 'POST-zahteva ni uspela',
	'coll-empty_collection' => 'Prazna knjiga',
	'coll-revision' => 'Redakcija: $ 1',
	'coll-save_collection_title' => 'Shranite in delite vaše knjige',
	'coll-save_collection_text' => 'Izberite mesto za shranjevanje vaše knjige:',
	'coll-login_to_save' => 'Če želite shraniti knjige za kasnejšo uporabo, se prosimo [[Special:Userlogin|prijavite ali ustvarite račun]].',
	'coll-personal_collection_label' => 'Osebna knjiga:',
	'coll-community_collection_label' => 'Skupna knjiga:',
	'coll-save_collection' => 'Shrani knjigo',
	'coll-save_category' => 'Vse knjige so shranjene v kategoriji [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]]',
	'coll-overwrite_title' => 'Stran obstaja.
Jo prepišem?',
	'coll-overwrite_text' => 'Stran z imenom [[:$1]] že obstaja. 
Ali želite, da se nadomesti z vašo knjigo?',
	'coll-yes' => 'Da',
	'coll-no' => 'Ne',
	'coll-overwrite' => 'Prepiši',
	'coll-append' => 'Pripni',
	'coll-cancel' => 'Prekliči',
	'coll-update' => 'Posodobi',
	'coll-limit_exceeded_title' => 'Knjiga je prevelika',
	'coll-limit_exceeded_text' => 'Vaša knjiga je prevelika.
Ne morete dodati več strani.',
	'coll-rendering_title' => 'Upodabljanje',
	'coll-rendering_text' => '<p><strong>Prosimo, počakajte, da se dokument pripravi.</strong></p>

<p><strong>Napredek:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p> 

<p>Ta stran se samodejno osveži vsakih nekaj sekund.
Če se ne, prosimo, pritisnite gumb za osvežitev znotraj brskalnika.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wiki-stran: $1)',
	'coll-rendering_page' => '(stran: $1)',
	'coll-rendering_finished_title' => 'Upodabljanje končano',
	'coll-rendering_finished_text' => '<strong>Datoteka je bila ustvarjena. [$1 Prenesi datoteko]</strong> na vaš računalnik.

Opombe:
* Niste zadovoljni z ustvarjeno datoteko? Glej [[{{MediaWiki:Coll-helppage}}|stran s pomočjo za razširitev Knjige]] za možnosti izboljšav.',
	'coll-notfound_title' => 'Knjiga ni bila najdena',
	'coll-notfound_text' => 'Stran v knjigi ni bila najdena.',
	'coll-is_cached' => '<ul><li>Najdena je bila shranjena različica tega dokumenta, zato upodabljanje ni bilo potrebno. <a href="$1">Vsili ponovno upodabljanje.</a></li></ul>',
	'coll-excluded-templates' => '* Predloge v kategoriji [[:Category:$1|$1]], so bile izključene.',
	'coll-blacklisted-templates' => '* Predloge na črnem seznamu [[:$1]], so bile izključene.',
	'coll-return_to_collection' => '<p>Vrnitev na: <a href="$1">$2</a></p>',
	'coll-book_title' => 'Naroči kot tiskano knjigo',
	'coll-book_text' => 'Naroči tiskano knjigo od našega partnerja za tisk na zahtevo:',
	'coll-order_from_pp' => 'Naroči knjigo od $1',
	'coll-about_pp' => 'O $1',
	'coll-invalid_podpartner_title' => 'Neveljaven partner TNZ',
	'coll-license' => 'Licenca',
	'coll-return_to' => 'Nazaj na [[:$1]]',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 * @author Јованвб
 */
$messages['sr-ec'] = array(
	'coll-add_category' => 'Додај категорију',
	'coll-printable_version_pdf' => 'PDF верзија',
	'coll-remove' => 'Уклони',
	'coll-title' => 'Наслов:',
	'coll-revision' => 'Ревизија: $1',
	'coll-yes' => 'Да',
	'coll-no' => 'Не',
	'coll-cancel' => 'Прекини',
	'coll-update' => 'Апдејтуј',
	'coll-rendering_article' => '(вики страница: $1)',
	'coll-rendering_page' => '(страница: $1)',
	'coll-order_from_pp' => 'Наручи књигу са $1',
	'coll-license' => 'Лиценца',
	'coll-return_to' => 'Врати на [[:$1]]',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'coll-desc' => '[[Special:Collection|Siedentouhoopestaalenge]], moak PDFs',
	'coll-collection' => 'Touhoopestaalenge',
	'coll-collections' => 'Touhoopestaalenge',
	'coll-create_a_book' => 'Kollektion',
	'coll-add_page' => 'Siede bietouföigje',
	'coll-remove_page' => 'Siede wächhoalje',
	'coll-add_category' => 'Kategorie bietouföigje',
	'coll-load_collection' => 'Touhoopestaalenge leede',
	'coll-show_collection' => 'Touhoopestaalenge wiese',
	'coll-help_collections' => 'Hälpe tou Touhoopestaalengen',
	'coll-n_pages' => '$1 {{PLURAL:$1|Siede|Sieden}}',
	'coll-download_as' => 'As $1 deelleede',
	'coll-noscript_text' => '<h1>JavaScript is nöödich!</h1>
<strong>Dien Browser unnerstutset neen Javascript of Javascript wuude deaktivierd. Disse Siede däd nit gjucht funktionierje, soloange Javascript nit ferföigboar is.</strong>',
	'coll-intro_text' => 'Du koast Sieden touhoopestaale, n PDF deerap moakje un deelleede as uk Touhoopestaalengen foar ne leetere Ferweendenge twiskespiekerje un mäd uur Benutsere deele.

Sjuch ju [[{{MediaWiki:Coll-helppage}}|Hälpe bie Touhoopestaalengen]] foar wiedere Informatione.',
	'coll-helppage' => 'Help:Touhoopestaalengen',
	'coll-download_title' => 'Touhoopestaalenge as PDF deelleede',
	'coll-download_text' => 'Uum ne automatisk moakede PDF-Doatäi fon dien Touhoopestaalenge deeltouleeden, klik ap ap ju Schaltfläche.',
	'coll-download' => 'Deelleede',
	'coll-format_label' => 'Formoat:',
	'coll-remove' => 'Wächhoalje',
	'coll-move_to_top' => 'ätter dän Ounfang',
	'coll-move_up' => 'hooch',
	'coll-move_down' => 'häärdeel',
	'coll-move_to_bottom' => 'ätter dän Eend',
	'coll-title' => 'Tittel:',
	'coll-subtitle' => 'Unnertittel:',
	'coll-contents' => 'Inhoold',
	'coll-create_chapter' => 'Näi Kapittel moakje',
	'coll-sort_alphabetically' => 'Sieden alphabetisk sortierje',
	'coll-clear_collection' => 'Touhoopestaalenge läskje',
	'coll-rename' => 'Uumebenaame',
	'coll-new_chapter' => 'Reek n Noome foar n näi Kapittel ien',
	'coll-rename_chapter' => 'Reek n näien Noome foar dät Kapittel ien',
	'coll-no_such_category' => 'Sun Kategorie rakt dät nit',
	'coll-notitle_title' => 'Die Tittel fon ju Siede kuud nit bestimd wäide.',
	'coll-post_failed_title' => 'POST-Anfroage failsloain',
	'coll-post_failed_msg' => 'Ju POST-Anfroage an $1 is failsloain ($2).',
	'coll-mwserve_failed_title' => 'Serverfailer',
	'coll-mwserve_failed_msg' => 'Ap dän Renderer-Server is n Failer aptreeden: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Failermäldenge fon dän Server',
	'coll-empty_collection' => 'Loose Kollektion',
	'coll-revision' => 'Version: $1',
	'coll-save_collection_title' => 'Kollektion spiekerje',
	'coll-save_collection_text' => 'Uum disse Kollektion tou spiekerjen, wääl n Typ un reek n Tittel ien:',
	'coll-login_to_save' => 'Wan du Kollektione spiekerje moatest, [[Special:UserLogin|mäld die an of moak n Benutserkonto]].',
	'coll-personal_collection_label' => 'Persöönelke Kollektion:',
	'coll-community_collection_label' => 'Community Kollektion:',
	'coll-save_collection' => 'Kollektion spiekerje',
	'coll-overwrite_title' => 'Siede bestoant. Uurschrieuwe?',
	'coll-overwrite_text' => 'Ne Siede mäd dän Noome [[:$1]] bestoant al.
Moatest du ju truch dien Kollektion ärsätte?',
	'coll-yes' => 'Jee',
	'coll-no' => 'Noa',
	'coll-load_overwrite_text' => 'Dien Kollektion änthaalt al wäkke Sieden.
Moatest du ju aktuelle Kollektion uurschrieuwe, do näie Sieden anhongje of dät Leeden fon disse Kollektion oubreeke?',
	'coll-overwrite' => 'Uurschrieuwe',
	'coll-append' => 'Anhongje',
	'coll-cancel' => 'Oubreeke',
	'coll-limit_exceeded_title' => 'Kollektion tou groot',
	'coll-limit_exceeded_text' => 'Dien Kollektion is tou groot.
Deer konnen neen Sieden moor bietouföiged wäide.',
	'coll-rendering_title' => 'An t Moakjen',
	'coll-rendering_text' => "'''Täif, bit dät Dokument moaked wuuden is.'''

Foutschrit: '''$1 %'''.

Disse Siede schuul sik älke poor Sekunden fonsälwen aktualisierje.
Fals dit daach nit geböärt, druk dan dän „Aktualisierje“-Knoop (maast F5) fon dien Browser.",
	'coll-rendering_finished_title' => 'Kloor moaked',
	'coll-rendering_finished_text' => '</strong>Ju Doatäi wuud mäd Ärfoulch moaked.</strong>
<strong>[$1 Klik hier],</strong> uum ju Doatäi deeltouleeden.

Bäst du nit mäd dät Resultoat toufree?
Muugelkhaide tou ju Ferbeeterenge fon ju Uutgoawe finst du ap ju [[{{MediaWiki:Coll-helppage}}|Hälpesiede uur do Siedenkollektione]].',
	'coll-notfound_title' => 'Kollektion nit fuunen',
	'coll-notfound_text' => 'Dien Kollektion kuud nit fuunen wäide.',
	'coll-is_cached' => '<ul><li>Der is ne twiskespiekerde Version fon dät Dokument foarhounden, so dät neen Renderjen nöödich waas. <a href="$1">Näiränderjen outwinge.</a></li></ul>',
	'coll-excluded-templates' => '* Foarloagen uut ju Kategorie [[:Category:$1|$1]] wuuden uutsleeten.',
	'coll-blacklisted-templates' => '* Foarloagen fon ju swotte Lieste [[:$1]] wuuden uutsleeten.',
	'coll-return_to_collection' => 'Tourääch tou <a href="$1">$2</a>',
	'coll-book_title' => 'Drukuutgoawe bestaale',
	'coll-book_text' => "Du koast bie do foulgjende ''Print-on-Demand''-Partnere ne drukte Boukuutgoawe bestaale:",
	'coll-order_from_pp' => 'Bestaal Bouk bie $1',
	'coll-about_pp' => 'Uur $1',
	'coll-invalid_podpartner_title' => 'Uungultiger Print-on-Demand-Paatender',
	'coll-invalid_podpartner_msg' => 'Do Angoawen tou dän Print-on-Demand-Paatender sunt failerhaft.
Kontaktier dän MediaWiki-Administrator.',
	'coll-license' => 'Lizenz',
	'coll-return_to' => 'Tourääch tou [[:$1]]',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'coll-add_page' => 'Nambah kaca',
	'coll-remove_page' => 'Miceun kaca',
	'coll-add_category' => 'Nambah kategori',
	'coll-move_to_top' => 'Mindahkeun ka luhur',
	'coll-move_up' => 'Pindahkeun ka luhur',
	'coll-move_down' => 'Mindahkeun ka handap',
	'coll-move_to_bottom' => 'Mindahkeun ka handap',
	'coll-title' => 'Judul:',
	'coll-contents' => 'eusi',
	'coll-rename' => 'Ganti ngaran',
	'coll-yes' => 'Enya',
	'coll-no' => 'Teu',
	'coll-append' => 'Tambahkeun',
	'coll-cancel' => 'Bolay',
	'coll-return_to_collection' => '<p>Balik deui ka <a href="$1">$2</a></p>',
	'coll-about_pp' => 'Ngeunaan $1',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author H92
 * @author Jon Harald Søby
 * @author M.M.S.
 * @author Najami
 * @author Sannab
 */
$messages['sv'] = array(
	'coll-desc' => '[[Special:Book|Skapa böcker]]',
	'coll-collection' => 'Bok',
	'coll-collections' => 'Böcker',
	'coll-exclusion_category_title' => 'Uteslut vid utskrift',
	'coll-print_template_prefix' => 'Utskrift',
	'coll-print_template_pattern' => '$1/Skriv ut',
	'coll-create_a_book' => 'Skapa en bok',
	'coll-add_page' => 'Lägg till wikisida',
	'coll-remove_page' => 'Ta bort wikisida',
	'coll-add_category' => 'Lägg till kategori',
	'coll-load_collection' => 'Hämta bok',
	'coll-show_collection' => 'Visa bok',
	'coll-help_collections' => 'Hjälp för böcker',
	'coll-n_pages' => '$1 {{PLURAL:$1|sida|sidor}}',
	'coll-unknown_subpage_title' => 'Okänd undersida',
	'coll-unknown_subpage_text' => 'Denna undersida till [[Special:Book|Bok]] existerar inte',
	'coll-printable_version_pdf' => 'PDF-version',
	'coll-download_as' => 'Hämta som $1',
	'coll-noscript_text' => '<h1>JavaScript är nödvändigt!</h1>
<strong>Din webbläsare stödjer inte JavaScript eller så har JavaScript stängts av.
Denna sida kommer inte att fungera korrekt innan JavaScript finns tillgängligt.</strong>',
	'coll-intro_text' => 'Skapa och hantera din egna samling av wikisidor.<br />Se [[{{MediaWiki:Coll-helppage}}]] för mer information.',
	'coll-helppage' => 'Help:Böcker',
	'coll-bookscategory' => 'Böcker',
	'coll-savedbook_template' => 'sparad_bok',
	'coll-your_book' => 'Din bok',
	'coll-download_title' => 'Hämta',
	'coll-download_text' => 'För att hämta en offline-version välj ett format och klicka på knappen.',
	'coll-download_as_text' => 'För att ladda ner en version i formatet $1, klicka på knappen.',
	'coll-download' => 'Hämta',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Ta bort',
	'coll-show' => 'Visa',
	'coll-move_to_top' => 'Flytta till toppen',
	'coll-move_up' => 'Flytta upp',
	'coll-move_down' => 'Flytta ner',
	'coll-move_to_bottom' => 'Flytta till botten',
	'coll-title' => 'Titel:',
	'coll-subtitle' => 'Undertitel:',
	'coll-contents' => 'Innehåll',
	'coll-drag_and_drop' => 'Använd dra & släpp för att ändra ordning på wikisidor och kapitel',
	'coll-create_chapter' => 'Skapa kapitel',
	'coll-sort_alphabetically' => 'Sortera alfabetiskt',
	'coll-clear_collection' => 'Töm bok',
	'coll-clear_collection_confirm' => 'Vill du verkligen helt tömma din bok?',
	'coll-rename' => 'Byt name',
	'coll-new_chapter' => 'Välj ett namn för det nya kapitlet',
	'coll-rename_chapter' => 'Välj ett nytt namn för kapitlet',
	'coll-no_such_category' => 'Ingen sådan kategori',
	'coll-notitle_title' => 'Titeln av sidan kunde inte fastställas.',
	'coll-post_failed_title' => 'POST-begäran avslagen',
	'coll-post_failed_msg' => 'POST-begäran till $1 avslagen ($2).',
	'coll-mwserve_failed_title' => 'Render-serverfel',
	'coll-mwserve_failed_msg' => 'Ett fel uppstod på renderservern: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Felrespons från servern',
	'coll-empty_collection' => 'Tom bok',
	'coll-revision' => 'Revision: $1',
	'coll-save_collection_title' => 'Spara och dela din bok',
	'coll-save_collection_text' => 'Välj en plats:',
	'coll-login_to_save' => 'Om du vill spara böcker för senare bruk, var god [[Special:UserLogin|logga in eller skapa ett konto]].',
	'coll-personal_collection_label' => 'Personlig bok:',
	'coll-community_collection_label' => 'Gemensam bok:',
	'coll-save_collection' => 'Spara bok',
	'coll-save_category' => 'Böcker sparas i kategorin [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Sidan existerar. 
Vill du skriva över den?',
	'coll-overwrite_text' => 'En sida med namnet [[:$1]] finns redan.
Vill du ersätta den med din samling?',
	'coll-yes' => 'Ja',
	'coll-no' => 'Nej',
	'coll-load_overwrite_text' => 'Du har redan några sidor i din bok.
Vill du ersätta din nuvarande bok, lägga till det nya innehållet eller avbryta hämtningen av denna bok?',
	'coll-overwrite' => 'Skriv över',
	'coll-append' => 'Lägga till',
	'coll-cancel' => 'Avbryt',
	'coll-update' => 'Uppdatera',
	'coll-limit_exceeded_title' => 'För stor bok',
	'coll-limit_exceeded_text' => 'Din bok är för stor.
Inga mer sidor kan läggas till.',
	'coll-rendering_title' => 'Skapar',
	'coll-rendering_text' => '<p><strong>Var god vänta under tiden dokumentet skapas.</strong></p>

<p><strong>Tillstånd:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Denna sida ska automatiskt uppdateras med några sekunders mellanrum.
Om det inte fungerar, var god tryck på uppdateringsknappen i din webbläsare.</p>',
	'coll-rendering_status' => '<strong>Status:</strong> $1',
	'coll-rendering_article' => '(wikisida: $1)',
	'coll-rendering_page' => '(sida: $1)',
	'coll-rendering_finished_title' => 'Rendering avslutad',
	'coll-rendering_finished_text' => '<strong>Dokumentfilen har skapats.</strong>
<strong>[$1 Hämta filen]</strong> till din dator.

Noter:
* Inte nöjd med resultatet? Se [[{{MediaWiki:Coll-helppage}}|hjälpsidan om samlingar]] för möjligheter att förbättra det.',
	'coll-notfound_title' => 'Bok inte funnen',
	'coll-notfound_text' => 'Kunde inte hitta boksida.',
	'coll-is_cached' => '<ul><li>En cachad version av dokumentet har hittats, så ingen rendering behövdes. <a href="$1">Framtvinga omrendering.</a></li></ul>',
	'coll-excluded-templates' => '* Mallar i kategorin [[:Category:$1|$1]] har uteslutits.',
	'coll-blacklisted-templates' => '* Mallar på svartalistan [[:$1]] har uteslutits.',
	'coll-return_to_collection' => '<p>Tillbaka till <a href="$1">$2</a></p>',
	'coll-book_title' => 'Beställ som en utskriven bok',
	'coll-book_text' => 'Få en tryckt bok från vår print-on-demand partner:',
	'coll-order_from_pp' => 'Beställ bok från $1',
	'coll-about_pp' => 'Om $1',
	'coll-invalid_podpartner_title' => 'Ogiltig POD-partner',
	'coll-invalid_podpartner_msg' => 'Den erbjudna POD-partnern är ogiltig.
Var god kontakta din MediaWiki-administratör.',
	'coll-license' => 'Licens',
	'coll-return_to' => 'Tillbaka till [[:$1]]',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'coll-desc' => '[[Special:Book|పుస్తకాలను తయారుచేసుకోండి]]',
	'coll-collection' => 'పుస్తకం',
	'coll-collections' => 'పుస్తకాలు',
	'coll-create_a_book' => 'ఓ పుస్తకాన్ని సృష్టించండి',
	'coll-add_page' => 'వికీ పేజీని చేర్చు',
	'coll-remove_page' => 'వికీ పేజీని తొలగించు',
	'coll-add_category' => 'వర్గాన్ని చేర్చు',
	'coll-show_collection' => 'సేకరణని చూపించు',
	'coll-help_collections' => 'పుస్తకాల సహాయం',
	'coll-n_pages' => '$1 {{PLURAL:$1|పేజీ|పేజీలు}}',
	'coll-printable_version_pdf' => 'PDF కూర్పు',
	'coll-helppage' => 'Help:పుస్తకాలు',
	'coll-bookscategory' => 'పుస్తకాలు',
	'coll-your_book' => 'మీ పుస్తకం',
	'coll-download_title' => 'సేకరణని PDFగా దిగుమతి చేసుకోండి',
	'coll-download_text' => 'మీ పేజీ సేకరణ నుండి ఆటోమెటిగ్గా తయారయిన PDF ఫైలుని దిగుమతిచేసుకోడానికి, ఈ బొత్తాన్ని నొక్కండి.',
	'coll-download' => 'దిగుమతి',
	'coll-remove' => 'తొలగించు',
	'coll-move_up' => 'పైకి కదుపు',
	'coll-move_down' => 'క్రిందికి కదుపు',
	'coll-move_to_bottom' => 'అడుగునకు కదుపు',
	'coll-title' => 'శీర్షిక:',
	'coll-subtitle' => 'ఉపశీర్షిక:',
	'coll-contents' => 'విషయాలు',
	'coll-create_chapter' => 'కొత్త అధ్యాయాన్ని ప్రారంభించు',
	'coll-sort_alphabetically' => 'పేజీలను అక్షరక్రమంలో అమర్చు',
	'coll-clear_collection' => 'సేకరణని తుడిచివేయి',
	'coll-rename' => 'పేరుమార్చు',
	'coll-new_chapter' => 'కొత్త అధ్యాయానికి పేరు సూచించండి',
	'coll-no_such_category' => 'అటువంటి వర్గం లేదు',
	'coll-notitle_title' => 'ఆ పేజీ యొక్క శీర్షికని నిర్ణయించలేకున్నాం.',
	'coll-post_failed_title' => 'POST అభ్యర్థన విఫలమైంది',
	'coll-error_reponse' => 'సర్వరునుండి పొరపాటు అని స్పందన వచ్చింది',
	'coll-empty_collection' => 'ఖాళీ పుస్తకం',
	'coll-revision' => 'కూర్పు: $1',
	'coll-save_collection_title' => 'సేకరణని భద్రపరచండి',
	'coll-save_collection_text' => 'ఈ సేకరణని తర్వాత వాడుకోడానికి భద్రపరచుకోవాలంటే, ఓ సేకరణ రకాన్ని ఎంచుకోండి మరియు పేజీ శీర్షిక ఇవ్వండి:',
	'coll-login_to_save' => 'సేకరణలని మీరు తర్వాత వాడుకోవడానికి భద్రపరచుకోవాలనుకుంటే, [[Special:UserLogin|లోనికి ప్రవేశించండి లేదా ఖాతా సృష్టించుకోండి]].',
	'coll-personal_collection_label' => 'వ్యక్తిగత సేరకణ:',
	'coll-community_collection_label' => 'సామూహిక పుస్తకం:',
	'coll-save_collection' => 'సేకరణని భద్రపరచు',
	'coll-overwrite_title' => 'పేజీ ఉంది. దానిపైనే రాసేయాలా?',
	'coll-overwrite_text' => '[[:$1]] అనే పేరుతో ఓ పేజీ ఇప్పటికే ఉంది.
దాని స్ధానంలో మీ సేకరణని ఉంచాలా?',
	'coll-yes' => 'అవును',
	'coll-no' => 'కాదు',
	'coll-append' => 'జతచేయి',
	'coll-cancel' => 'రద్దు',
	'coll-limit_exceeded_title' => 'పుస్తకం మరీ పెద్దగా ఉంది',
	'coll-limit_exceeded_text' => 'మీ పేజీ సేకరణ చాలా పెద్దగా ఉంది.
మరిన్ని పేజీలు చేర్చలేము.',
	'coll-rendering_status' => '<strong>స్థితి:</strong> $1',
	'coll-rendering_article' => '(వికీ పేజీ: $1)',
	'coll-rendering_page' => '  (పేజీ: $1)',
	'coll-notfound_title' => 'సేకరణ కనబడలేదు',
	'coll-notfound_text' => 'సేకరణ పేజీ కనబడలేదు.',
	'coll-return_to_collection' => '<p>తిరిగి <a href="$1">$2</a></p>కి',
	'coll-order_from_pp' => '$1 నుండి పుస్తకాన్ని ఆర్డర్ చెయ్యండి',
	'coll-about_pp' => '$1 గురించి',
	'coll-license' => 'లైసెన్సు',
	'coll-return_to' => 'తిరిగి [[:$1]]కి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'coll-create_a_book' => 'Kria livru ida',
	'coll-your_book' => 'Ó-nia livru',
	'coll-title' => 'Títulu:',
	'coll-contents' => 'Konteúdu',
	'coll-yes' => 'Sin',
	'coll-no' => 'Lae',
	'coll-cancel' => 'Para',
	'coll-about_pp' => 'Kona-ba $1',
	'coll-return_to' => 'Fali ba [[:$1]]',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'coll-desc' => '[[Special:Collection|Гирдоварии саҳифаҳо]], тавлиди PDFҳо',
	'coll-collection' => 'Гирдоварӣ',
	'coll-collections' => 'Гирдовариҳо',
	'coll-print_template_prefix' => 'Чоп',
	'coll-create_a_book' => 'Эҷоди як китоб',
	'coll-add_page' => 'Илова кардани вики саҳифа',
	'coll-remove_page' => 'Пок кардани вики саҳифа',
	'coll-add_category' => 'Илова кардани гурӯҳ',
	'coll-load_collection' => 'Бор кардани гирдоварӣ',
	'coll-show_collection' => 'Намоиши гирдоварӣ',
	'coll-help_collections' => 'Роҳнамои гирдовариҳо',
	'coll-n_pages' => '$1 {{PLURAL:$1|саҳифа|саҳифаҳо}}',
	'coll-unknown_subpage_title' => 'Зерсаҳифаи ношинос',
	'coll-printable_version_pdf' => 'Нусхаи PDF',
	'coll-download_as' => 'Дарёфтан чун $1',
	'coll-noscript_text' => '<h1>ҶаваСкрипт Лозим аст!</h1>
<strong>Мурургари шумо ҶаваСкриптро дастгирӣ намекунад ё ҶаваСкрипт хомӯш карда шудааст.
Ин саҳифа дуруст кор хоҳад карда, дар ҳолате, ки ҶаваСкрипт фаъол карда шуда бошад.</strong>',
	'coll-intro_text' => 'Шумо метавонед саҳифаҳоро гирдовари кунед, тавлид ва бор кардани парвандаҳои PDF аз саҳифаҳои гирдовариҳо ва захир кардани гирдовариҳо барои истифодаи баъдӣ ё бо ҳам дидани онҳо бо дигарон.

Барои иттилооти бештар нигаред ба [[{{MediaWiki:Coll-helppage}}|саҳифаи роҳнамо оиди гирдовариҳо]].',
	'coll-helppage' => 'Help:Гирдовариҳо',
	'coll-your_book' => 'Китоби шумо',
	'coll-download_title' => 'Дарёфт',
	'coll-download_text' => 'Барои бор кардани нусхаи бурунхатии як қолаберо интихоб карда тугмаро пахш кунед.',
	'coll-download' => 'Дарёфт',
	'coll-format_label' => 'Қолаб:',
	'coll-remove' => 'Ҳазф',
	'coll-show' => 'Намоиш',
	'coll-move_to_top' => 'Ҳаракат бо боло',
	'coll-move_up' => 'Ба боло',
	'coll-move_down' => 'Ба поён',
	'coll-move_to_bottom' => 'Ҳаракат ба поён',
	'coll-title' => 'Унвон:',
	'coll-subtitle' => 'Зерунвон:',
	'coll-contents' => 'Мундариҷа',
	'coll-create_chapter' => 'Эҷоди фасл',
	'coll-sort_alphabetically' => 'Ба тартиб даровардан аз рӯи алифбо',
	'coll-clear_collection' => 'Тоза кардани гирдовари',
	'coll-rename' => 'Тағйири ном',
	'coll-new_chapter' => 'Барои фасли ҷадид номеро ворид кунед',
	'coll-rename_chapter' => 'Барои фасл номи ҷадидеро ворид кунед',
	'coll-no_such_category' => 'Чунин гурӯҳ вуҷуд надорад',
	'coll-notitle_title' => 'Унвони саҳифа мушаххас шуда наметавонад.',
	'coll-mwserve_failed_title' => 'Хато дар коргузори тарҷумакунанда',
	'coll-error_reponse' => 'Посухи хатое аз хидматгузор',
	'coll-empty_collection' => 'Холӣ кардани гирдовари',
	'coll-revision' => 'Нусха: $1',
	'coll-save_collection_title' => 'Захира ва бо ҳам дидани гирдовариатон',
	'coll-save_collection_text' => 'Интихоби як макон:',
	'coll-login_to_save' => 'Агар майли захира кардани гирдовариҳоро барои истифодаи баъдӣ дошта бошед, лутфан [[Special:UserLogin|ба систем ворид шавед ё ҳисоби ҷадидиро эчод кунед]].',
	'coll-personal_collection_label' => 'Гирдоварии шахсӣ:',
	'coll-community_collection_label' => 'Гирдоварии умум:',
	'coll-save_collection' => 'Захираи Гирдовари',
	'coll-overwrite_title' => 'Саҳифа вуҷуд дорад. Ба рӯи он аз навишта шавад?',
	'coll-overwrite_text' => 'Саҳифае бо номи [[:$1]] аллакай вуҷуд дорад.
Оё шумо мехоҳед онро бо гирдоварии худ иваз кунед?',
	'coll-yes' => 'Бале',
	'coll-no' => 'Не',
	'coll-load_overwrite_text' => 'Шумо аллакай якчанд саҳифаҳоеро дар гирдоварии худ доред.
Оё шумо мехоҳед рӯи гирдоварии кунуниатон нависед, мӯҳтавои ҷадидро пайваст ё лағв кунед?',
	'coll-overwrite' => 'Ба рӯй навиштан',
	'coll-append' => 'Афзудан',
	'coll-cancel' => 'Лағв',
	'coll-update' => 'Барӯз кардан',
	'coll-limit_exceeded_title' => 'Гирдовари Хеле Бузург',
	'coll-limit_exceeded_text' => 'Саҳифаи гирдоварии шумо хеле бузург аст.
Аз ин зиёд саҳифаҳо наметавонанд илова шаванд.',
	'coll-rendering_title' => 'Дар ҳоли тарҷума додан',
	'coll-rendering_status' => '<strong>Вазъият:</strong> $1',
	'coll-rendering_article' => '(саҳифаи вики: $1)',
	'coll-rendering_page' => '(саҳифа: $1)',
	'coll-notfound_title' => 'Гирдовари Ёфт Нашуд',
	'coll-notfound_text' => 'Саҳифаи гирдоварӣ ёфт нашуд.',
	'coll-return_to_collection' => '<p>Бозгашт ба <a href="$1">$2</a></p>',
	'coll-book_title' => 'Фармудани Китоби Чопӣ',
	'coll-book_text' => 'Шумо метавонед китоби ба табъ расидаро, ки саҳифаи гирдовариҳои шуморо дорост бо ташриф овардан ба яке аз ҳамкорони чоп-дархост фармоед:',
	'coll-order_from_pp' => 'Фармудани китоб аз $1',
	'coll-about_pp' => 'Дар бораи $1',
	'coll-invalid_podpartner_title' => 'Шарики Чоп-бо-дархости номӯътабар',
	'coll-license' => 'Иҷозатнома',
	'coll-return_to' => 'Бозгашт ба [[:$1]]',
);

/** Thai (ไทย)
 * @author Ans
 * @author Manop
 */
$messages['th'] = array(
	'coll-desc' => '[[Special:Book|สร้างหนังสือ]]',
	'coll-collection' => 'หนังสือ',
	'coll-collections' => 'หนังสือ',
	'coll-exclusion_category_title' => 'ไม่รวมในส่วนพิมพ์',
	'coll-print_template_prefix' => 'พิมพ์',
	'coll-print_template_pattern' => '$1/พิมพ์',
	'coll-create_a_book' => 'สร้างหนังสือ',
	'coll-add_page' => 'เพิ่มหน้าวิกิ',
	'coll-remove_page' => 'ลบหน้าวิกิ',
	'coll-add_category' => 'เพิ่มหมวดหมู่',
	'coll-load_collection' => 'โหลดหนังสือ',
	'coll-show_collection' => 'แสดงหนังสือ',
	'coll-help_collections' => 'ความช่วยเหลือในส่วนหนังสือ',
	'coll-n_pages' => '$1 หน้า',
	'coll-unknown_subpage_title' => 'หน้าย่อยที่ไม่รู้จัก',
	'coll-unknown_subpage_text' => '[[Special:Book|หนังสือ]] ไม่มีหน้าย่อยนี้',
	'coll-printable_version_pdf' => 'รุ่น PDF',
	'coll-download_as' => 'ดาวน์โหลดในชื่อ $1',
	'coll-noscript_text' => '<h1>จำเป็นต้องใช้จาวาสคริปต์!</h1>
<strong>เบราว์เซอร์ของคุณไม่รองรับจาวาสคริปต์หรือจาวาสคริปต์ถูกปิดการใช้งาน
หน้านี้จะไม่สามารถทำงานได้อย่างถูกต้อง ถ้าไม่มีการเปิดใช้จาวาสคริปต์</strong>',
	'coll-helppage' => 'Help:หนังสือ',
	'coll-bookscategory' => 'หนังสือ',
	'coll-savedbook_template' => 'หนังสือที่ถูกบันทึกไว้ก่อนหน้า',
	'coll-your_book' => 'หนังสือของคุณ',
	'coll-download_title' => 'ดาวน์โหลด',
	'coll-download_text' => 'เลือกรูปแบบและกดที่ปุ่มเพื่อดาวน์โหลด',
	'coll-download_as_text' => 'กดที่ปุ่มเพื่อดาวน์โหลดในรูปแบบ $1',
	'coll-download' => 'ดาวน์โหลด',
	'coll-format_label' => 'รูปแบบ:',
	'coll-remove' => 'ลบออก',
	'coll-show' => 'แสดง',
	'coll-move_to_top' => 'ย้ายไปบนสุด',
	'coll-move_up' => 'ย้ายขึ้น',
	'coll-move_down' => 'ย้ายลง',
	'coll-move_to_bottom' => 'ย้ายไปล่างสุด',
	'coll-contents' => 'เนื้อหา',
	'coll-drag_and_drop' => 'ใช้การลากและปล่อย เพื่อจัดลำดับบทและหน้าวิกิ',
	'coll-create_chapter' => 'สร้างบท',
	'coll-sort_alphabetically' => 'เรียงตามลำดับตัวอักษร',
	'coll-rename' => 'เปลี่ยนชื่อ',
	'coll-new_chapter' => 'ใส่ชื่อสำหรับบทใหม่',
	'coll-rename_chapter' => 'ใส่ชื่อใหม่สำหรับบทนี้',
	'coll-no_such_category' => 'ไม่มีหมวดหมู่ดังกล่าว',
	'coll-post_failed_title' => 'คำสั่ง POST ผิดพลาด',
	'coll-post_failed_msg' => 'คำสั่ง POST ไปที่ $1 ผิดพลาด ($2)',
	'coll-mwserve_failed_title' => 'ความผิดพลาดของเซิร์ฟเวอร์เรนเดอร์',
	'coll-error_reponse' => 'มีความผิดพลาดตอบกลับมาจากเซิร์ฟเวอร์',
	'coll-revision' => 'รุ่น: $1',
	'coll-save_collection_title' => 'บันทึกและแบ่งปันหนังสือของคุณ',
	'coll-save_collection_text' => 'เลือกตำแหน่งที่จะเก็บสำหรับหนังสือของคุณ:',
	'coll-personal_collection_label' => 'หนังสือส่วนตัว:',
	'coll-community_collection_label' => 'หนังสือชุมชน:',
	'coll-save_collection' => 'บันทึกหนังสือ',
	'coll-overwrite_title' => 'มีหน้านี้แล้ว
เขียนทับ?',
	'coll-overwrite_text' => 'หน้าที่อยู่ภายใต้ชื่อ [[:$1]] มีอยู่แล้ว
คุณต้องการแทนที่หน้านั้นด้วยหนังสือคุณหรือไม่',
	'coll-yes' => 'ใช่',
	'coll-no' => 'ไม่ใช่',
	'coll-load_overwrite_text' => 'หนังสือของคุณพอมีหน้าบรรจุอยู่บ้างแล้ว
คุณต้องการจะทำสิ่งไหนระหว่าง เขียนทับลงในหนังสือของคุณ เพิ่มเนื้อหาต่อท้าย หรือยกเลิกการโหลดหนังสือนี้',
	'coll-overwrite' => 'เขียนทับ',
	'coll-append' => 'เพิ่มต่อท้าย',
	'coll-cancel' => 'ยกเลิก',
	'coll-update' => 'อัปเดต',
	'coll-limit_exceeded_title' => 'หนังสือใหญ่เกินไป',
	'coll-limit_exceeded_text' => 'หนังสือของคุณใหญ่เกินไป
ไม่สามารถเพิ่มหน้าใดเข้าไปได้อีก',
	'coll-rendering_title' => 'กำลังเรนเดอร์',
	'coll-rendering_status' => '<strong>สถานะ:</strong> $1',
	'coll-rendering_article' => '(หน้าวิกิ: $1)',
	'coll-rendering_page' => '(หน้า: $1)',
	'coll-rendering_finished_title' => 'การเรนเดอร์เสร็จสิ้น',
	'coll-notfound_title' => 'ไม่พบหนังสือที่ต้องการ',
	'coll-notfound_text' => 'ไม่สามารถค้นหาหน้าหนังสือ',
	'coll-blacklisted-templates' => '* แม่แบบในบัญชีดำ [[:$1]] ไม่ได้ถูกรวมไว้',
	'coll-return_to_collection' => '<p>กลับไปที่ <a href="$1">$2</a></p>',
	'coll-book_title' => 'สั่งหนังสือเป็นรูปเล่ม',
	'coll-order_from_pp' => 'สั่งหนังสือจาก $1',
	'coll-about_pp' => 'เกี่ยวกับ $1',
	'coll-license' => 'สัญญาอนุญาต (license)',
	'coll-return_to' => 'กลับไปที่ [[:$1]]',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'coll-desc' => '[[Special:Book|Lumikha ng mga aklat]]',
	'coll-collection' => 'Aklat',
	'coll-collections' => 'Mga aklat',
	'coll-exclusion_category_title' => 'Huwag isama sa paglimbag',
	'coll-print_template_prefix' => 'Ilimbag',
	'coll-print_template_pattern' => '$1/Limbag',
	'coll-create_a_book' => 'Lumikha ng isang aklat',
	'coll-add_page' => 'Magdagdag ng pahinang wiki',
	'coll-remove_page' => 'Tanggalin ang pahinang wiki',
	'coll-add_category' => 'Magdagdag ng kaurian',
	'coll-load_collection' => 'Ikarga ang aklat',
	'coll-show_collection' => 'Ipakita ang aklat',
	'coll-help_collections' => 'Tulong na pang-aklat',
	'coll-n_pages' => '$1 {{PLURAL:$1|pahina|mga pahina}}',
	'coll-unknown_subpage_title' => 'Hindi nalalamang kabahaging pahina',
	'coll-unknown_subpage_text' => 'Hindi umiiral ang kabahaging pahinang ito ng [[Special:Book|Aklat]]',
	'coll-printable_version_pdf' => 'Bersyong PDF',
	'coll-download_as' => 'Ikargang-pakuha bilang $1',
	'coll-noscript_text' => "<h1>Kailangan ang JavaScript!</h1>
<strong>Hindi sinusuportan ng iyong pantingin-tingin (''browser'') ang JavaScript o nakapatay ang JavaScript.
Hindi aandar ng tama ang pahinang ito, maliban na lamang kung bubuhayin ang JavaScript.</strong>",
	'coll-intro_text' => 'Likhain at pamahalaan ang iyong pansariling pilian ng mga pahina ng wiki.<br />Tingnan ang [[{{MediaWiki:Coll-helppage}}]] para sa mas maraming kabatiran.',
	'coll-helppage' => 'Help:Mga Aklat',
	'coll-bookscategory' => 'Mga aklat',
	'coll-savedbook_template' => 'sinagip_na_aklat',
	'coll-your_book' => 'Aklat mo',
	'coll-download_title' => 'Ikargang-pakuha',
	'coll-download_text' => "Upang makapagkargang-pakuha ng isang bersyong hindi-nakakonekta sa kompyuter (''offline'') pumili ng isang anyo/pormat at pindutin ang pindutan.",
	'coll-download_as_text' => 'Upang makapagkargang pababa ng isang bersyong nasa pormat na $1 pindutin ang pindutan.',
	'coll-download' => 'Ikargang-pakuha',
	'coll-format_label' => 'Pormat (anyo):',
	'coll-remove' => 'Tanggalin',
	'coll-show' => 'Ipakita',
	'coll-move_to_top' => 'Ilipat sa itaas',
	'coll-move_up' => 'Ilipat sa itaas',
	'coll-move_down' => 'Ilipat sa ibaba',
	'coll-move_to_bottom' => 'Ilipat sa ilalim',
	'coll-title' => 'Pamagat:',
	'coll-subtitle' => 'Kabahaging pamagat:',
	'coll-contents' => 'Mga nilalaman',
	'coll-drag_and_drop' => 'Gamitin ang "kaladkarin at ibagsak" upang muling maiayos ang mga pahina at mga kabanata ng wiki',
	'coll-create_chapter' => 'Lumikha ng kabanata',
	'coll-sort_alphabetically' => 'Ayusing ayon sa abakada (alpabeto)',
	'coll-clear_collection' => 'Hawiin ang aklat',
	'coll-clear_collection_confirm' => 'Talaga bang nais mong hawiin ng lubusan ang aklat mo?',
	'coll-rename' => 'Pangalanang muli',
	'coll-new_chapter' => 'Maglagay ng pangalan para sa bagong kabanata',
	'coll-rename_chapter' => 'Maglagay ng bagong pangalan para sa kabanata',
	'coll-no_such_category' => 'Walang ganyang kaurian',
	'coll-notitle_title' => 'Hindi matukoy ang pamagat ng pahina.',
	'coll-post_failed_title' => 'Nabigo ang kahilingang ITALA',
	'coll-post_failed_msg' => 'Nabigo ang kahilingang ITALA sa $1 ($2).',
	'coll-mwserve_failed_title' => 'Kamalian sa naghahaing serbidor',
	'coll-mwserve_failed_msg' => 'Naganap ang isang kamalian sa naghahaing serbidor: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'May kamalian sa tugon ng serbidor',
	'coll-empty_collection' => 'Aklat na walang laman',
	'coll-revision' => 'Pagbabago: $1',
	'coll-save_collection_title' => 'Sagipin at ipamahagi ang aklat mo',
	'coll-save_collection_text' => 'Pumili ng isang pook (lokasyon):',
	'coll-login_to_save' => 'Kung nais mong magsagip ng mga aklat para gamitin sa ibang pagkakataon, mangyaring [[Special:UserLogin|lumagda o lumikha ng akawnt]].',
	'coll-personal_collection_label' => 'Pansariling aklat:',
	'coll-community_collection_label' => 'Aklat ng pamayanan:',
	'coll-save_collection' => 'Sagipin ang aklat',
	'coll-save_category' => 'Nakasagip ang mga aklat sa loob ng kauriang [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Umiiral ang pahina.
Patungan?',
	'coll-overwrite_text' => 'Umiiral na ang isang pahinang may pangalang [[:$1]].
Nais mo bang palitan ito ng iyong kalipunan?',
	'coll-yes' => 'Oo',
	'coll-no' => 'Hindi',
	'coll-load_overwrite_text' => 'Mayroon ka nang ilang mga pahina sa loob ng aklat mo.
Nais mo bang patungan ang iyong pangkasalukuyang aklat, ikabit ang bagong nilalaman, o huwag ituloy ang pagkakarga ng aklat na ito?',
	'coll-overwrite' => 'Patungan',
	'coll-append' => 'Ikabit',
	'coll-cancel' => 'Huwag ituloy',
	'coll-update' => 'Isapanahon',
	'coll-limit_exceeded_title' => 'Napakalaki ng aklat',
	'coll-limit_exceeded_text' => 'Napakalaki ng aklat mo.
Wala nang maidaragdag pang mga pahina.',
	'coll-rendering_title' => 'Naghahain',
	'coll-rendering_text' => "<p><strong>Mangyaring maghintay lamang habang ginagawa ang kasulatan (dokumento).</strong></p>

<p><strong>Katayuan ng pagsulong:</strong> <span id=\"renderingProgress\">\$1</span>% <span id=\"renderingStatus\">\$2</span></p>

<p>Dapat na kusang sumariwa ang pahinang ito sa bawat mangilan-ngilang mga segundo.
Kung hindi ito mangyari, pakipindot ang pindutang panariwa (''refresh'') ng iyong pantingin-tingin (''browser'').</p>",
	'coll-rendering_status' => '<strong>Kalagayan:</strong> $1',
	'coll-rendering_article' => '(pahinang wiki: $1)',
	'coll-rendering_page' => '(pahina: $1)',
	'coll-rendering_finished_title' => 'Tapos na ang paghahain',
	'coll-rendering_finished_text' => '<strong>Nagawa na ang talaksang pangkasulatan (dokumento).</strong>
<strong>[$1 Ikargang-pakuha ang talaksan]</strong> papunta sa iyong kompyuter.

Mga tala:
* Hindi ka ba nasiyahan sa kinalabasan? Tingnan [[{{MediaWiki:Coll-helppage}}|ang pahina ng tulong hinggil sa mga kalipunan]] para sa mga bagay-bagay na maaaring gawin (posibilidad) upang mapainam pa ito.',
	'coll-notfound_title' => 'Hindi natagpuan ang aklat',
	'coll-notfound_text' => 'Hindi matagpuan ang pahina ng aklat.',
	'coll-is_cached' => '<ul><li>Natagpuan ang isang nakatagong bersyon ng kasulatan (dokumento), kaya\'t hindi na kailangan pa ang "paghahain". <a href="$1">Pilitin ang muling paghahain.</a></li></ul>',
	'coll-excluded-templates' => '* Hindi isinali ang mga suleras na nasa kauriang [[:Category:$1|$1]].',
	'coll-blacklisted-templates' => '* Hindi isinali ang mga suleras na nasa talaan ng mga pinagbabawalan [[:$1]]',
	'coll-return_to_collection' => '<p>Magbalik sa <a href="$1">$2</a></p>',
	'coll-book_title' => 'Orderin bilang isang nakalimbag na aklat',
	'coll-book_text' => 'Kumuha ng isang nakalimbag na aklat mula sa aming kasosyo sa "ilimbag-kapag-hiniling" (IKH):',
	'coll-order_from_pp' => 'Umorder ng aklat mula sa $1',
	'coll-about_pp' => 'Mga $1',
	'coll-invalid_podpartner_title' => 'Hindi tanggap na kasosyo/kawaksing pang-IKH ("ilimbag-kapag-hiniling")',
	'coll-invalid_podpartner_msg' => 'Hindi tanggap ang ibinigay na kawaksi/kasosyong pang-IKH ("ilimbag-kapag-hiniling").
Makipagugnayan sa iyong tagapangasiwa ng MediaWiki.',
	'coll-license' => 'Pahintulot (lisensya)',
	'coll-return_to' => 'Bumalik sa [[:$1]]',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Mach
 * @author Srhat
 * @author Suelnur
 */
$messages['tr'] = array(
	'coll-desc' => '[[Special:Book|Kitap oluştur]]',
	'coll-collection' => 'Kitap',
	'coll-collections' => 'Kitaplar',
	'coll-exclusion_category_title' => 'Yazdırırken hariç tut',
	'coll-print_template_prefix' => 'Yazdır',
	'coll-print_template_pattern' => '$1/Yazdır',
	'coll-create_a_book' => 'Bir kitap oluştur',
	'coll-add_page' => 'Sayfa ekle',
	'coll-add_page_tooltip' => 'Bu sayfayı koleksiyonunuza ekleyin',
	'coll-remove_page' => 'Sayfayı çıkar',
	'coll-remove_page_tooltip' => 'Bu sayfayı koleksiyonunuzdan çıkarın',
	'coll-add_category' => 'Kategori ekle',
	'coll-add_category_tooltip' => 'Bu kategorideki tüm viki sayfalarını koleksiyonunuza ekleyin',
	'coll-load_collection' => 'Koleksiyonu yükle',
	'coll-load_collection_tooltip' => 'Bu koleksiyonu varsayılan koleksiyonunuz olarak yükleyin',
	'coll-show_collection' => 'Koleksiyonu göster',
	'coll-show_collection_tooltip' => 'Tıklayıp koleksiyonunuzu düzenleyin/indirin/sipariş edin',
	'coll-help_collections' => 'Koleksiyon yardımı',
	'coll-help_collections_tooltip' => 'Koleksiyon aracı hakkında yardım',
	'coll-n_pages' => '$1 {{PLURAL:$1|sayfa|sayfa}}',
	'coll-unknown_subpage_title' => 'Bilinmeyen altsayfa',
	'coll-unknown_subpage_text' => '[[Special:Book|Koleksiyonun]] bu altsayfası mevcut değil',
	'coll-printable_version_pdf' => 'PDF sürümü',
	'coll-download_as' => '$1 olarak indir',
	'coll-noscript_text' => '<h1>JavaScript gerekli!</h1>
<strong>Tarayıcınız JavaScript desteklemiyor ya da JavaScript kapalı.
JavaScript devreye sokulmadıkça bu sayfa doğru çalışmayacaktır.</strong>',
	'coll-intro_text' => 'Viki sayfalarının kişisel seçiminizi oluşturun ve yönetin<br />Daha fazla bilgi için [[{{MediaWiki:Coll-helppage}}]] sayfasına bakın.',
	'coll-helppage' => 'Help:Koleksiyonlar',
	'coll-bookscategory' => 'Koleksiyonlar',
	'coll-savedbook_template' => 'kaydedilmiş_kitap',
	'coll-your_book' => 'Koleksiyonunuz',
	'coll-download_title' => 'İndir',
	'coll-download_text' => 'Çevrimdışı bir sürüm indirmek için bir format seçin ve düğmeye tıklayın.',
	'coll-download_as_text' => '$1 formatında bir sürümü indirmek için tıklayın.',
	'coll-download' => 'İndir',
	'coll-format_label' => 'Format:',
	'coll-remove' => 'Kaldır',
	'coll-show' => 'Göster',
	'coll-move_to_top' => 'En üste taşı',
	'coll-move_up' => 'Yukarı taşı',
	'coll-move_down' => 'Aşağı taşı',
	'coll-move_to_bottom' => 'En alta taşı',
	'coll-title' => 'Başlık:',
	'coll-subtitle' => 'Altbaşlık:',
	'coll-contents' => 'İçerik',
	'coll-drag_and_drop' => "Viki sayfalarını ve bölümleri yeniden sıralamak için sürükle & bırak'ı kullanın",
	'coll-create_chapter' => 'Bölüm oluştur',
	'coll-sort_alphabetically' => 'Alfabetik olarak sırala',
	'coll-clear_collection' => 'Kitabı temizle',
	'coll-clear_collection_tooltip' => 'Mevcut koleksiyonunuzdaki tüm viki sayfalarını silin',
	'coll-clear_collection_confirm' => 'Koleksiyonunuzu tamamen temizlemeyi istiyor musunuz?',
	'coll-rename' => 'Yeniden adlandır',
	'coll-new_chapter' => 'Yeni bölüm için isim girin',
	'coll-rename_chapter' => 'Bölüm için yeni isim girin',
	'coll-no_such_category' => 'Böyle bir kategori bululnmamaktadır',
	'coll-notitle_title' => 'Sayfanın başlığı belirlenemiyor.',
	'coll-post_failed_title' => 'POST isteği başarısız',
	'coll-post_failed_msg' => '$1 için POST isteği başarısız ($2).',
	'coll-mwserve_failed_title' => 'İşlem sunucusu hatası',
	'coll-mwserve_failed_msg' => 'İşlem sunucusunda bir hata oluştu: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Sunucudan hata cevabı',
	'coll-empty_collection' => 'Boş koleksiyon',
	'coll-revision' => 'Revizyon: $1',
	'coll-save_collection_title' => 'Koleksiyonunuzu kaydedip paylaşın',
	'coll-save_collection_text' => 'Bir konum seçin:',
	'coll-login_to_save' => 'Koleksiyonlarınızı daha sonra kullanmak için kaydetmek istiyorsanız, lütfen [[Special:UserLogin|giriş yapın ya da bir hesap oluşturun]].',
	'coll-personal_collection_label' => 'Kişisel koleksiyon:',
	'coll-community_collection_label' => 'Topluluk koleksiyonu:',
	'coll-save_collection' => 'Koleksiyonu kaydet',
	'coll-save_category' => 'Koleksiyonlar [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]] kategorisinde kaydedildi.',
	'coll-overwrite_title' => 'Sayfa zaten mevcut.
Üzerine yazmak ister misiniz?',
	'coll-overwrite_text' => '[[:$1]] adında bir sayfa zaten mevcut.
Koleksiyonunuzla beraber değiştirilmesini istiyor musunuz?',
	'coll-yes' => 'Evet',
	'coll-no' => 'Hayır',
	'coll-load_overwrite_text' => 'Koleksiyonunuzda birkaç sayfa zaten var.
Şu anki koleksiyonunuzun üzerine yazmak mı, yeni içeriği eklemek mi, veya bu kitabı yüklemeyi iptal etmek mi istiyorsunuz?',
	'coll-overwrite' => 'Üzerine yaz',
	'coll-append' => 'Ekle',
	'coll-cancel' => 'İptal',
	'coll-update' => 'Güncelle',
	'coll-limit_exceeded_title' => 'Koleksiyon çok büyük',
	'coll-limit_exceeded_text' => 'Koleksiyonunuz çok büyük.
Daha fazla sayfa eklenememektedir.',
	'coll-rendering_title' => 'Oluşturuluyor',
	'coll-rendering_text' => '<p><strong>Lütfen belge oluşturulurken bekleyin.</strong></p>

<p><strong>İlerleme:</strong> %<span id="renderingProgress">$1</span> <span id="renderingStatus">$2</span></p>

<p>Bu sayfa birkaç saniyede bir otomatik yenilenmelidir.
Eğer çalışmıyorsa, lütfen tarayıcınızın yenileme tuşuna basın.</p>',
	'coll-rendering_status' => '<strong>Durum:</strong> $1',
	'coll-rendering_article' => '(viki sayfası: $1)',
	'coll-rendering_page' => '(sayfa: $1)',
	'coll-rendering_finished_title' => 'Oluşturma tamamlandı',
	'coll-rendering_finished_text' => '<strong>Belge oluşturuldu.</strong>
Dosyayı bilgisayarınıza <strong>[$1 indirin]</strong>.

Not:
* Çıktıdan memnun değil misiniz? Geliştirme olanakları için [[{{MediaWiki:Coll-helppage}}|koleksiyonlar hakkındaki yardım sayfalarına]] bakın.',
	'coll-notfound_title' => 'Koleksiyon bulunamadı',
	'coll-notfound_text' => 'Koleksiyon sayfası bulunamadı.',
	'coll-is_cached' => '<ul><li>Belgenin önbellekteki bir sürümü bulundu, bu yüzden oluşturmaya gerekmemektedir. <a href="$1">Yeniden oluşturmaya zorla.</a></li></ul>',
	'coll-excluded-templates' => '* [[:Category:$1|$1]] kategorisindeki şablonlar hariç tutuldu.',
	'coll-blacklisted-templates' => '* [[:$1]] kara listesindeki şablonlar hariç tutuldu.',
	'coll-return_to_collection' => '<p><a href="$1">$2</a> koleksiyonuna geri dön</p>',
	'coll-book_title' => 'Basılı bir kitap olarak sipariş et',
	'coll-book_text' => 'Talebe-göre-basım ortağımızdan basılı bir kitap al:',
	'coll-order_from_pp' => '$1 firmasından kitap sipariş et',
	'coll-about_pp' => '$1 hakkında',
	'coll-invalid_podpartner_title' => 'Geçersiz POD ortağı',
	'coll-invalid_podpartner_msg' => 'Sağlanan POD ortağı geçersiz.
Lütfen MedyaViki yöneticinizle irtibat kurun.',
	'coll-license' => 'Lisans',
	'coll-return_to' => '[[:$1]] sayfasına geri dön',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Aleksandrit
 */
$messages['uk'] = array(
	'coll-desc' => '[[Special:Book|Створює книги]]',
	'coll-collection' => 'Книга',
	'coll-collections' => 'Книги',
	'coll-exclusion_category_title' => 'Виключення з друку',
	'coll-print_template_prefix' => 'Друк',
	'coll-create_a_book' => 'Створення книги',
	'coll-add_page' => 'Додати вікі-сторінку',
	'coll-remove_page' => 'Вилучити вікі-сторінку',
	'coll-add_category' => 'Додати категорію',
	'coll-load_collection' => 'Завантажити книгу',
	'coll-show_collection' => 'Показати книгу',
	'coll-help_collections' => 'Довідка про книги',
	'coll-n_pages' => '$1 {{PLURAL:$1|сторінка|сторінки|сторінок}}',
	'coll-unknown_subpage_title' => 'Невідома підсторінка',
	'coll-unknown_subpage_text' => 'Ця підсторінка [[Special:Book|книги]] не існує',
	'coll-printable_version_pdf' => 'PDF-версія',
	'coll-download_as' => 'Завантажити як $1',
	'coll-noscript_text' => '<h1>Потрібен JavaScript!</h1>
<strong>Ваш браузер не підтримує JavaScript або ця підтримка вимкнена.
Ця сторінка не буде працювати правильно, якщо JavaScript не ввімкнений.</strong>',
	'coll-intro_text' => 'Створення і керування вашою персональною колекцією вікі-сторінок.<br />Для додаткової інформації див. [[{{MediaWiki:Coll-helppage/uk}}]].',
	'coll-helppage' => 'Help:Книги',
	'coll-bookscategory' => 'Книги',
	'coll-savedbook_template' => 'збережена_книга',
	'coll-your_book' => 'Ваша книга',
	'coll-download_title' => 'Завантажити',
	'coll-download_text' => 'Щоб завантажити автономну версію, оберіть формат і натисніть кнопку.',
	'coll-download_as_text' => 'Клацніть кнопку, щоб завантажити версію у форматі $1.',
	'coll-download' => 'Завантажити',
	'coll-format_label' => 'Формат:',
	'coll-remove' => 'Вилучити',
	'coll-show' => 'Показати',
	'coll-move_to_top' => 'Перемістити нагору',
	'coll-move_up' => 'Перемістити вище',
	'coll-move_down' => 'Перемістити нижче',
	'coll-move_to_bottom' => 'Перемістити донизу',
	'coll-title' => 'Назва:',
	'coll-subtitle' => 'Підзаголовок:',
	'coll-contents' => 'Зміст',
	'coll-drag_and_drop' => 'Щоб упорядкувати вікі-сторінки і розділи, перетягуйте їх мишкою',
	'coll-create_chapter' => 'Створити розділ',
	'coll-sort_alphabetically' => 'Сортувати за алфавітом',
	'coll-clear_collection' => 'Очистити книгу',
	'coll-clear_collection_confirm' => 'Ви дійсно бажаєте повністю очистити вашу книгу?',
	'coll-rename' => 'Перейменувати',
	'coll-new_chapter' => 'Уведіть назву нового розділу',
	'coll-rename_chapter' => 'Уведіть нову назву розділу',
	'coll-no_such_category' => 'Нема такої категорії',
	'coll-notitle_title' => 'Заголовок сторінки неможливо визначити.',
	'coll-post_failed_title' => 'POST-запит не виконаний',
	'coll-post_failed_msg' => 'POST-запит до $1 не виконаний ($2).',
	'coll-mwserve_failed_title' => 'Помилка сервера відображення',
	'coll-mwserve_failed_msg' => 'На сервері відображення трапилася помилка: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Помилка відповіді сервера',
	'coll-empty_collection' => 'Порожня книга',
	'coll-revision' => 'Версія: $1',
	'coll-save_collection_title' => 'Зберегти книгу і відкрити доступ до неї',
	'coll-save_collection_text' => 'Оберіть розташування:',
	'coll-login_to_save' => 'Щоб зберегти книгу для подальшого використання, будь ласка, [[Special:UserLogin|ввійдіть до системи або створить обліковий запис]].',
	'coll-personal_collection_label' => 'Особиста книга:',
	'coll-community_collection_label' => 'Книга спільноти:',
	'coll-save_collection' => 'Зберегти книгу',
	'coll-save_category' => 'Книги збережено у категорії [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Сторінка існує. Перезаписати?',
	'coll-overwrite_text' => 'Сторінка з назвою [[:$1]] вже існує.
Ви хочете, щоб вона була замінена вашою колекцією?',
	'coll-yes' => 'Так',
	'coll-no' => 'Ні',
	'coll-load_overwrite_text' => 'У вас уже є кілька сторінок у книзі.
Ви хочете перезаписати вашу поточну книгу, додати новий матеріал чи скасувати відкриття цієї книги?',
	'coll-overwrite' => 'Перезаписати',
	'coll-append' => 'Додати',
	'coll-cancel' => 'Скасувати',
	'coll-update' => 'Оновити',
	'coll-limit_exceeded_title' => 'Книга надто велика',
	'coll-limit_exceeded_text' => 'Ваша книга надто велика.
До неї не можна більше додавати сторінок.',
	'coll-rendering_title' => 'Створення',
	'coll-rendering_text' => '<p><strong>Будь ласка, зачекайте поки триває створення документа.</strong></p>

<p><strong>Хід роботи:</strong> <span id="renderingProgress">$1</span> % <span id="renderingStatus">$2</span></p>

<p>Ця сторінка повинна автоматично оновлюватися кожні кілька секунд.
Якщо цього не відбувається, оновіть цю сторінку у вашому браузері.</p>',
	'coll-rendering_status' => '<strong>Статус:</strong> $1',
	'coll-rendering_article' => '(сторінка: $1)',
	'coll-rendering_page' => '(сторінка: $1)',
	'coll-rendering_finished_title' => 'Створення завершено',
	'coll-rendering_finished_text' => "<strong>Файл документа був створений.</strong>
<strong>[$1 Завантажити файл]</strong> на свій комп'ютер.

Зауваження:
* Не задоволені результатом? Можливості його поліпшення описані на [[{{MediaWiki:Coll-helppage}}|довідковій сторінці про колекції]].",
	'coll-notfound_title' => 'Книга не знайдена',
	'coll-notfound_text' => 'Неможливо знайти сторінку книги.',
	'coll-is_cached' => '<ul><li>Знайдена закешована версія документу, тому перемалювання не знадобилося. <a href="$1">Примусове перемалювання.</a></li></ul>',
	'coll-excluded-templates' => '* Шаблони в категорії [[:Категорія:$1|$1]] були виключені.',
	'coll-blacklisted-templates' => '* Шаблони в чорному списку [[:$1]] були виключені.',
	'coll-return_to_collection' => '<p>Назад до <a href="$1">$2</a></p>',
	'coll-book_title' => 'Замовити як друковану книгу',
	'coll-book_text' => 'Отримати друковану книгу від нашого партнера:',
	'coll-order_from_pp' => 'Замовлення книги в $1',
	'coll-about_pp' => 'Про $1',
	'coll-invalid_podpartner_title' => 'Недійсний POD-партнер',
	'coll-invalid_podpartner_msg' => "POD-партнер, що надається, недійсний. 
Будь-ласка, зв'яжіться з вашим адміністратором MediaWiki.",
	'coll-license' => 'Ліцензія',
	'coll-return_to' => 'Повернення до [[:$1]]',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'coll-desc' => '[[Special:Book|Crea libri]]',
	'coll-collection' => 'Libro',
	'coll-collections' => 'Libri',
	'coll-exclusion_category_title' => 'Escludi da la stanpa',
	'coll-print_template_prefix' => 'Stanpa',
	'coll-print_template_pattern' => '$1/Stanpa',
	'coll-create_a_book' => 'Crea un libro',
	'coll-add_page' => 'Zonta pàxena wiki',
	'coll-remove_page' => 'Cava pàxena wiki',
	'coll-add_category' => 'Zonta na categoria',
	'coll-load_collection' => 'Carga libro',
	'coll-show_collection' => 'Mostra libro',
	'coll-help_collections' => 'Ajuto sui libri',
	'coll-n_pages' => '$1 {{PLURAL:$1|pàxena|pàxene}}',
	'coll-unknown_subpage_title' => 'Sotopàxena sconossiùa',
	'coll-unknown_subpage_text' => 'Sta sotopàxena de [[Special:Book|Libro]] no la esiste mia',
	'coll-printable_version_pdf' => 'Versiòn PDF',
	'coll-download_as' => 'Descarga come $1',
	'coll-noscript_text' => "<h1>Ghe vole el JavaScript!</h1>
<strong>El to browser no'l suporta JavaScript opure JavaScript el xe stà disativà.
La pàxena no la funsionrà mia coretamente se no vegnarà ativà JavaScript.</strong>",
	'coll-intro_text' => 'Crea e gestissi le to selession personali de pàxene wiki.<br />Lèxi [[{{MediaWiki:Coll-helppage}}]] par savérghene piessè.',
	'coll-helppage' => 'Help:Libri',
	'coll-bookscategory' => 'Libri',
	'coll-savedbook_template' => 'libro_salvà',
	'coll-your_book' => 'El to libro',
	'coll-download_title' => 'Descarga',
	'coll-download_text' => 'Par trar xo na versiòn siegli un formado e struca el botòn.',
	'coll-download_as_text' => 'Par descargar na version in tel formato $1 struca el boton.',
	'coll-download' => 'Descarga',
	'coll-format_label' => 'Formato:',
	'coll-remove' => 'Cava',
	'coll-show' => 'Mostra',
	'coll-move_to_top' => 'Sposta insima',
	'coll-move_up' => 'Sposta piassè in alto',
	'coll-move_down' => 'Sposta piassè zo',
	'coll-move_to_bottom' => 'Sposta in fondo',
	'coll-title' => 'Titolo:',
	'coll-subtitle' => 'Sototitolo:',
	'coll-contents' => 'Indice',
	'coll-drag_and_drop' => 'Strassìna e mòla col mouse par riordinar le pàxene wiki e i capitoli',
	'coll-create_chapter' => 'Crea capitolo novo',
	'coll-sort_alphabetically' => 'Meti in ordine alfabétego',
	'coll-clear_collection' => 'Desvòda libro',
	'coll-clear_collection_confirm' => 'Vuto dalbòn netar conpletamente el to libro?',
	'coll-rename' => 'Canbia nome',
	'coll-new_chapter' => 'Inserissi el nome del capitolo novo',
	'coll-rename_chapter' => 'Inserissi el nome novo del capitolo',
	'coll-no_such_category' => 'Nissuna categoria',
	'coll-notitle_title' => "No s'à podesto determinar el titolo de sta pàxena.",
	'coll-post_failed_title' => 'Richiesta POST mia riussìa',
	'coll-post_failed_msg' => 'La richiesta POST a $1 no la xe mia riussìa ($2).',
	'coll-mwserve_failed_title' => 'Eròr sul server de conversion',
	'coll-mwserve_failed_msg' => 'Xe capità un eròr sul server de conversion: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Risposta de eròr dal server',
	'coll-empty_collection' => 'Libro vòdo',
	'coll-revision' => 'Revision: $1',
	'coll-save_collection_title' => 'Salva e condividi el to libro',
	'coll-save_collection_text' => 'Siegli un posto:',
	'coll-login_to_save' => 'Se te voli salvar el libro par dopararlo piassè avanti, [[Special:UserLogin|entra o crea na utensa nova]].',
	'coll-personal_collection_label' => 'Libro personal:',
	'coll-community_collection_label' => 'Libro de la comunità:',
	'coll-save_collection' => 'Salva libro',
	'coll-save_category' => 'I libri i vien salvà in te la categoria [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'La pàxena la esiste de zà.
Vuto che ghe scriva insima?',
	'coll-overwrite_text' => 'Na pàxena col nome [[:$1]] la esiste de zà.
Vuto che la vegna rinpiazà co la to colezion?',
	'coll-yes' => 'Sì',
	'coll-no' => 'No',
	'coll-load_overwrite_text' => 'Nel to libro ghe xe xà dele pàxene.
Vuto sorascrìvar el libro esistente, opure zontarghe el contenuto novo, opure anular el caricamento de sto libro?',
	'coll-overwrite' => 'Sorascrivi',
	'coll-append' => 'Zonta',
	'coll-cancel' => 'Annulla',
	'coll-update' => 'Ajorna',
	'coll-limit_exceeded_title' => 'Libro massa grando',
	'coll-limit_exceeded_text' => 'El to libro el xe massa grando. No se pode zontarghe altre pàxene.',
	'coll-rendering_title' => 'Conversion',
	'coll-rendering_text' => '<p><strong>Par piaser, speta n\'atimo che el documento el vegna generà.</strong></p>

<p><strong>Avansamento:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Sta pàxena la dovarìa ajornarse da par ela ogni póchi secondi.
Se questo no sucede, struca el boton de ajornamento del to browser.</p>',
	'coll-rendering_status' => '<strong>Stato:</strong> $1',
	'coll-rendering_article' => '(pàxena wiki: $1)',
	'coll-rendering_page' => '(pàxena: $1)',
	'coll-rendering_finished_title' => 'Conversion finìa',
	'coll-rendering_finished_text' => '<strong>El documento el xe stà generà.</strong>
<strong>[$1 Descàrghelo]</strong> sul to computer.

Note:
* Sito mia contento del risultato? Lèzi [[{{MediaWiki:Coll-helppage}}|la pàxena de ajuto su le colezion]] par saver come mejorarlo.',
	'coll-notfound_title' => 'Libro mia catà',
	'coll-notfound_text' => 'No se cata da nissuna parte la pàxena del libro.',
	'coll-is_cached' => '<ul><li>In te la cache xe stà catà na version del documento, quindi no ghè stà bisogno de far la conversion. <a href="$1">Forza la ri-conversion.</a></li></ul>',
	'coll-excluded-templates' => '* I modèi in te la categoria [[:Category:$1|$1]] i xe stà esclusi.',
	'coll-blacklisted-templates' => '* I modèi in te la lista nera [[:$1]] i xe stà esclusi.',
	'coll-return_to_collection' => '<p>Torna indrìo a <a href="$1">$2</a></p>',
	'coll-book_title' => 'Ordina come libro stanpà',
	'coll-book_text' => 'Otien un libro stanpà da uno dei nostri soci che i te lo stanpa su richiesta:',
	'coll-order_from_pp' => 'Ordina libro da $1',
	'coll-about_pp' => 'Informassion su $1',
	'coll-invalid_podpartner_title' => 'Partner POD mia valido',
	'coll-invalid_podpartner_msg' => "El socio POD fornìo no'l xe mia valido. Contata el to aministrador MediaWiki.",
	'coll-license' => 'Licensa',
	'coll-return_to' => 'Torna indrìo a [[:$1]]',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'coll-desc' => '[[Special:Book|Tạo sách vở]]',
	'coll-collection' => 'Sách',
	'coll-collections' => 'Sách vở',
	'coll-exclusion_category_title' => 'Ẩn khi in',
	'coll-print_template_prefix' => 'In',
	'coll-print_template_pattern' => '$1/Print',
	'coll-create_a_book' => 'Tạo một quyển sách',
	'coll-add_page' => 'Thêm trang wiki',
	'coll-remove_page' => 'Xóa trang wiki',
	'coll-add_category' => 'Thêm thể loại',
	'coll-load_collection' => 'Mở sách',
	'coll-show_collection' => 'Xem sách',
	'coll-help_collections' => 'Trợ giúp sách',
	'coll-n_pages' => '$1 trang',
	'coll-unknown_subpage_title' => 'Trang phụ không tìm được',
	'coll-unknown_subpage_text' => 'Trang phụ của [[Special:Book|Sách]] này không tồn tại',
	'coll-printable_version_pdf' => 'Bản PDF',
	'coll-download_as' => 'Tải về dưới dạng $1',
	'coll-noscript_text' => '<h1>Yêu cầu phải có JavaScript!</h1>
<strong>Trình duyệt của bạn không hỗ trợ JavaScript hoặc JavaScript đã bị tắt.
Trang này sẽ không hoạt động đúng, trừ khi bạn kích hoạt JavaScript.</strong>',
	'coll-intro_text' => 'Tạo và quản lý bộ sưu tập trang wiki của riêng bạn.<br/>Xem [[{{MediaWiki:Coll-helppage}}]] để biết thêm thông tin.',
	'coll-helppage' => 'Help:Sách vở',
	'coll-bookscategory' => 'Sách vở',
	'coll-savedbook_template' => 'sách_đã_lưu',
	'coll-your_book' => 'Sách của bạn',
	'coll-download_title' => 'Tải về',
	'coll-download_text' => 'Để tải về một phiên bản ngoại tuyến, hãy chọn định dạng rồi nhấn nút.',
	'coll-download_as_text' => 'Để tải phiên bản ở dạng $1 hãy nhấn nút.',
	'coll-download' => 'Tải về',
	'coll-format_label' => 'Định dạng:',
	'coll-remove' => 'Dời',
	'coll-show' => 'Hiện',
	'coll-move_to_top' => 'Di chuyển lên đầu',
	'coll-move_up' => 'Chuyển lên',
	'coll-move_down' => 'Chuyển xuống',
	'coll-move_to_bottom' => 'Di chuyển xuống dưới',
	'coll-title' => 'Tựa đề:',
	'coll-subtitle' => 'Phụ đề:',
	'coll-contents' => 'Nội dung',
	'coll-drag_and_drop' => 'Kéo thả để sắp xếp các trang wiki và chương sách',
	'coll-create_chapter' => 'Tạo chương',
	'coll-sort_alphabetically' => 'Sắp xếp theo thứ tự ABC',
	'coll-clear_collection' => 'Xóa sách',
	'coll-clear_collection_confirm' => 'Bạn có chắc muốn xóa hẳn sách của bạn?',
	'coll-rename' => 'Đổi tên',
	'coll-new_chapter' => 'Gõ vào tên chương mới',
	'coll-rename_chapter' => 'Gõ vào tên chương mới',
	'coll-no_such_category' => 'Không có thể loại như vậy',
	'coll-notitle_title' => 'Không xác định được tựa đề của trang.',
	'coll-post_failed_title' => 'Yêu cầu POST thất bại',
	'coll-post_failed_msg' => 'Yêu cầu POST đến $1 thất bại ($2).',
	'coll-mwserve_failed_title' => 'Lỗi chương trình kết xuất',
	'coll-mwserve_failed_msg' => 'Chương trình kết xuất gặp lỗi: <nowiki>$1</nowiki>',
	'coll-error_reponse' => 'Máy chủ trả về lỗi',
	'coll-empty_collection' => 'Sách trống',
	'coll-revision' => 'Phiên bản: $1',
	'coll-save_collection_title' => 'Lưu và chia sẻ sách của bạn',
	'coll-save_collection_text' => 'Chọn một vị trí:',
	'coll-login_to_save' => 'Nếu bạn muốn lưu sách để sau này dùng, xin hãy [[Special:UserLogin|đăng nhập hoặc mở tài khoản]].',
	'coll-personal_collection_label' => 'Sách cá nhân:',
	'coll-community_collection_label' => 'Sách cộng đồng:',
	'coll-save_collection' => 'Lưu sách',
	'coll-save_category' => 'Các cuốn sách được xếp trong thể loại [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Trang đã tồn tại. Ghi đè?',
	'coll-overwrite_text' => 'Trang với tên [[:$1]] đã tồn tại.
Bạn có muốn thay thế nó bằng tập hợp của bạn?',
	'coll-yes' => 'Có',
	'coll-no' => 'Không',
	'coll-load_overwrite_text' => 'Bạn đã có một số trang trong sách của mình.
Bạn có muốn ghi đè sách hiện tại, thêm nội dung mới, hay hủy việc tải sách này?',
	'coll-overwrite' => 'Ghi đè',
	'coll-append' => 'Thêm vào',
	'coll-cancel' => 'Bãi bỏ',
	'coll-update' => 'Cập nhật',
	'coll-limit_exceeded_title' => 'Sách quá lớn',
	'coll-limit_exceeded_text' => 'Sách của bạn quá lớn.
Không thể thêm trang được nữa.',
	'coll-rendering_title' => 'Đang kết xuất',
	'coll-rendering_text' => '<p><strong>Xin hãy chờ xong kết xuất tài liệu.</strong></p>

<p><strong>Tiến độ:</strong> <span id="renderingProgress">$1</span>% <span id="renderingStatus">$2</span></p>

<p>Trình duyệt sẽ làm tươi trang này vài giây một lần.
Nếu không thấy thay đổi gì, xin hãy bấm nút Refresh hoặc Reload trong trình duyệt.</p>',
	'coll-rendering_status' => '<strong>Trạng thái:</strong> $1',
	'coll-rendering_article' => '(trang wiki: $1)',
	'coll-rendering_page' => '(trang: $1)',
	'coll-rendering_finished_title' => 'Kết xuất xong',
	'coll-rendering_finished_text' => '<strong>Xong kết xuất tập tin tài liệu.</strong>
<strong>[$1 Tải nó về]</strong> máy tính của mình.

Chú ý:
* Không vừa lòng với bản kết xuất này? Hãy đọc [[{{MediaWiki:Coll-helppage}}|trợ giúp về tập hợp]] để biết về những cách để cải tiến nó.',
	'coll-notfound_title' => 'Không tìm thấy sách',
	'coll-notfound_text' => 'Không tìm thấy trang sách.',
	'coll-is_cached' => '<ul><li>Không cần kết xuất mới vì đã tìm thấy phiên bản trong bộ nhớ. <a href="$1">Kết xuất lại.</a></li></ul>',
	'coll-excluded-templates' => '* Các tiêu bản trong thể loại [[:Category:$1|$1]] được bỏ qua.',
	'coll-blacklisted-templates' => '* Các tiêu bản trùng với danh sách đen [[:$1]] được bỏ qua.',
	'coll-return_to_collection' => '<p>Quay trở về <a href="$1">$2</a></p>',
	'coll-book_title' => 'Đặt sách in',
	'coll-book_text' => 'Mua một cuốn sách in từ bên cộng tác in-theo-yêu-cầu:',
	'coll-order_from_pp' => 'Đặt sách từ $1',
	'coll-about_pp' => 'Giới thiệu $1',
	'coll-invalid_podpartner_title' => 'Thành phần đi kèm POD không hợp lệ',
	'coll-invalid_podpartner_msg' => 'Thành phần đi kèm POD đã cung cấp không hợp lệ.
Xin hãy liên hệ với quản trị viên MediaWiki của bạn.',
	'coll-license' => 'Giấy phép',
	'coll-return_to' => 'Quay lại [[:$1]]',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'coll-desc' => '[[Special:Book|Jafolöd bukis]]',
	'coll-collection' => 'Buk',
	'coll-collections' => 'Buks',
	'coll-exclusion_category_title' => 'Fakipön dü dabükam',
	'coll-print_template_prefix' => 'Dabükön',
	'coll-create_a_book' => 'Jafön buki',
	'coll-add_page' => 'Läükön padi vüke',
	'coll-remove_page' => 'Moükön padi se vük',
	'coll-add_category' => 'Läükön kladi',
	'coll-load_collection' => 'Lodön buki',
	'coll-show_collection' => 'Jonön buki',
	'coll-help_collections' => 'Yuf tefü buks',
	'coll-n_pages' => '{{PLURAL:$1|pad|pads}} $1',
	'coll-unknown_subpage_title' => 'Donapad nesevädik',
	'coll-unknown_subpage_text' => 'Donapad at [[Special:Book|Buka]] no dabinon.',
	'coll-printable_version_pdf' => 'fomam-PDF',
	'coll-download_as' => 'Donükön as $1',
	'coll-noscript_text' => '<h1>El JavaScript paflagon!</h1>
<strong>Bevüresodanaföm olik no stüton eli JavaScript, ud el JavaScript pesekurbon. Pad at no ojäfidon verätiko, if el JavaScript no ponikurbon.</strong>',
	'coll-helppage' => 'Help:Buks',
	'coll-bookscategory' => 'Buks',
	'coll-your_book' => 'Buk olik',
	'coll-download_title' => 'Donükön',
	'coll-download' => 'Donükön',
	'coll-format_label' => 'Fomät:',
	'coll-remove' => 'Moükön',
	'coll-show' => 'Jonön',
	'coll-title' => 'Tiäd:',
	'coll-subtitle' => 'Donatiäd:',
	'coll-contents' => 'Ninäd',
	'coll-create_chapter' => 'Jafön kapiti',
	'coll-sort_alphabetically' => 'Lafabön',
	'coll-clear_collection' => 'Vagükön buki',
	'coll-clear_collection_confirm' => 'Vilol-li jenöfo vagükön buki olik lölöfiko?',
	'coll-rename' => 'Votanemön',
	'coll-new_chapter' => 'Penolös nemi kapita nulik',
	'coll-rename_chapter' => 'Penolös nemi nulik kapita',
	'coll-no_such_category' => 'Klad at no dabinon',
	'coll-notitle_title' => 'No eplöpos ad fümetön padatiädi.',
	'coll-post_failed_title' => 'Beg-POST no eplöpon',
	'coll-post_failed_msg' => 'Beg-POST lü $1 no eplöpon ($2).',
	'coll-empty_collection' => 'Buk vagik',
	'coll-revision' => 'Revid: $1',
	'coll-save_collection_title' => 'Dakipön e dilön buki olik',
	'coll-login_to_save' => 'If vilol dakipön bukis pro geb posik, [[Special:UserLogin|nunädolös oli u jafolös kali]].',
	'coll-personal_collection_label' => 'Buk privatik:',
	'coll-community_collection_label' => 'Buk kobädik:',
	'coll-save_collection' => 'Dakipön buki',
	'coll-save_category' => 'Buks valik padakipons in klad: [[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]].',
	'coll-overwrite_title' => 'Pad ya dabinon.
Plaädön-li?',
	'coll-overwrite_text' => 'Pad labü nem: [[:$1]] ya dabinon.
Vilol-li plaädön padi at me konlet olik?',
	'coll-yes' => 'Si',
	'coll-no' => 'Nö',
	'coll-load_overwrite_text' => 'Ya labol padis anik in buk olik.
Vilol-li plaädön buki anuik ola, lenlägön ninädi nulik, u stöpädön lodami buka at?',
	'coll-overwrite' => 'Plaädön',
	'coll-append' => 'Lenlägön',
	'coll-cancel' => 'Stöpädön',
	'coll-limit_exceeded_title' => 'Buk tu gretik',
	'coll-limit_exceeded_text' => 'Buk olik binon tu gretik.
Pads pluik nonik kanons paläükön.',
	'coll-rendering_status' => '<strong>Stad:</strong> $1',
	'coll-rendering_article' => '(vükapad: $1)',
	'coll-rendering_page' => '(pad: $1)',
	'coll-notfound_title' => 'Buk no petuvon',
	'coll-notfound_text' => 'No eplöpos ad tuvön bukapadi.',
	'coll-excluded-templates' => '* Samafomots in klad: [[:Category:$1|$1]] pefakipons.',
	'coll-blacklisted-templates' => '* Samafomots blägaliseda: [[:$1]] pefakipons.',
	'coll-about_pp' => 'Tefü $1',
	'coll-return_to' => 'Geikön lü [[:$1]]',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'coll-update' => 'דערהײַנטיקן',
	'coll-rendering_status' => '<strong>סטאַטוס:</strong> $1',
	'coll-rendering_article' => '(וויקי בלאַט: $1)',
	'coll-rendering_page' => '(בלאַט: $1)',
);

/** Cantonese (‪廣東話‬)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'coll-desc'                       => '[[Special:Book|整書]]',
	'coll-collection'                 => '書',
	'coll-collections'                => '書',
	'coll-exclusion_category_title'   => '響打印版度排除',
	'coll-print_template_prefix'      => '打印',
	'coll-print_template_pattern'     => '$1/打印',
	'coll-create_a_book'              => '整一本書',
	'coll-add_page'                   => '加入wiki版',
	'coll-remove_page'                => '拎走wiki版',
	'coll-add_category'               => '加分類',
	'coll-load_collection'            => '載入書',
	'coll-show_collection'            => '顯示書',
	'coll-help_collections'           => '書幫手',
	'coll-n_pages'                    => '$1版',
	'coll-unknown_subpage_title'      => '未知嘅細頁',
	'coll-unknown_subpage_text'       => '呢本[[Special:Book|Book]]書嘅細頁唔存在',
	'coll-printable_version_pdf'      => 'PDF版',
	'coll-download_as'                => '下載做$1',
	'coll-noscript_text'              => '<h1>需要JavaScript!</h1>
<strong>你嘅瀏覽器唔支援JavaScript或者JavaScript閂咗。
呢一版唔會正常噉運行，除非開咗JavaScript。</strong>',
	'coll-intro_text'                 => "開同埋管理響wiki版度你嘅個人選擇。<br />睇[[{{MediaWiki:Coll-helppage}}]]有更多嘅資料。",
	'coll-helppage'                   => 'Help:書',
	'coll-bookscategory'              => '書',
	'coll-savedbook_template'         => '保存咗嘅書',
	'coll-your_book'                  => '你嘅書',
	'coll-download_title'             => '下載',
	'coll-download_text'              => '要下載一個版本，揀一種格式，然後再撳個掣。',
	'coll-download_as_text'           => '要下載做$1格式，撳個掣。',
	'coll-download'                   => '下載',
	'coll-format_label'               => '格式:',
	'coll-remove'                     => '拎走',
	'coll-show'                       => '顯示',
	'coll-move_to_top'                => '移到最頂',
	'coll-move_up'                    => '移上',
	'coll-move_down'                  => '移落',
	'coll-move_to_bottom'             => '移到最底',
	'coll-title'                      => '標題:',
	'coll-subtitle'                   => '細標題:',
	'coll-contents'                   => '內容',
	'coll-drag_and_drop'              => '用拖放去重排wiki版同章',
	'coll-create_chapter'             => '開章',
	'coll-sort_alphabetically'        => '按字母排',
	'coll-clear_collection'           => '清書',
	'coll-clear_collection_confirm'   => '你係咪真係想完全噉清晒你本書？',
	'coll-rename'                     => '改名',
	'coll-new_chapter'                => '輸入新章嘅名',
	'coll-rename_chapter'             => '輸入章嘅名',
	'coll-no_such_category'           => '無呢個分類',
	'coll-notitle_title'              => '唔可以拎到頁標題',
	'coll-notitle_title'              => '唔能夠決定嗰版嘅標題。',
	'coll-post_failed_title'          => 'POST請求失敗',
	'coll-post_failed_msg'            => 'POST請求 $1 失敗 ($2)。',
	'coll-mwserve_failed_title'       => '生成伺服器錯誤',
	'coll-mwserve_failed_msg'         => '生成伺服器發生錯誤: <nowiki>$1</nowiki>',
	'coll-error_reponse'              => '伺服器回應錯誤',
	'coll-empty_collection'           => '空書',
	'coll-revision'                   => '修訂: $1',
	'coll-save_collection_title'      => '保存同分享你嘅書',
	'coll-save_collection_text'       => '揀你本書嘅保存位置:',
	'coll-login_to_save'              => '如果你想保存以供之後使用，請[[Special:UserLogin|登入或開個新戶口]]。',
	'coll-personal_collection_label'  => '個人書:',
	'coll-community_collection_label' => '社群書:',
	'coll-save_collection'            => '存書',
	'coll-save_category'              => '全部書保存咗到[[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]]分類度。',
	'coll-overwrite_title'            => '版已經存在。
覆蓋？',
	'coll-overwrite_text'             => '用[[:$1]]名嘅版已經存在。
你係咪想用你本書換咗佢？',
	'coll-yes'                        => '係',
	'coll-no'                         => '唔係',
	'coll-load_overwrite_text'        => '響你本書度已經有一啲版。
你係咪想覆蓋你現有嘅書，加插新內容，或者係取消載入呢本書？',
	'coll-overwrite'                  => '覆蓋',
	'coll-append'                     => '加插',
	'coll-cancel'                     => '取消',
	'coll-update'                     => '更新',
	'coll-limit_exceeded_title'       => '書太大',
	'coll-limit_exceeded_text'        => '你本書太大。
無新版加入。',
	'coll-rendering_title'            => '生成緊',
	'coll-rendering_text'             => "<p><strong>響文件生成緊嗰陣請等一陣。</strong></p>

<p><strong>進度:</strong> <span id=\"renderingProgress\">$1</span>% <span id=\"renderingStatus\">$2</span></p>

<p>呢一版應該會響每幾秒度自動更新一次。
如果無動作嘅話，請撳你瀏覽器嘅重載掣。</p>",
	'coll-rendering_status'           => "<strong>進度:</strong> $1",
	'coll-rendering_article'          => '(wiki版: $1)',
	'coll-rendering_page'             => '(頁: $1)',
	'coll-rendering_finished_title'   => '生成好晒',
	'coll-rendering_finished_text'    => "<strong>個文件檔已經生成好。</strong>
<strong>[$1 下載個檔案]</strong>到你嘅電腦。

留意:
* 對個輸出唔滿意？睇[[{{MediaWiki:Coll-helppage}}|書幫手版]]去改善佢。",
	'coll-notfound_title'             => '搵唔到書',
	'coll-notfound_text'              => '搵唔到書版。',
	'coll-is_cached'                  => '<ul><li>搵到個文件嘅快取版，唔需要重新生成過。<a href="$1">強制重新生成。</a></li></ul>',
	'coll-excluded-templates'         => '* 響[[:Category:$1|$1]]分類上面嘅模已經排除。',
	'coll-blacklisted-templates'      => '* 響[[:$1]]黑名單上面嘅嘢已經排除。',
	'coll-return_to_collection'       => '<p>返去<a href="$1">$2</a></p>',
	'coll-book_title'                 => '柯打一本印刷書',
	'coll-book_text'                  => '響印刷需求拍擋拎一本印刷書:',
	'coll-order_from_pp'              => '響$1柯打書',
	'coll-about_pp'                   => '關於$1',
	'coll-invalid_podpartner_title'   => '無效嘅POD拍擋',
	'coll-invalid_podpartner_msg'     => '提供嘅POD拍擋無效。
請聯絡你嘅MediaWiki管理員。',
	'coll-license'                    => '牌照',
	'coll-return_to'                  => "返去[[:$1]]",
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenzw
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'coll-desc' => '[[Special:Book|创建图书]]',
	'coll-collection' => '图书',
	'coll-collections' => '图书',
	'coll-exclusion_category_title' => '在打印中排除',
	'coll-print_template_prefix' => '打印',
	'coll-create_a_book' => '创建一本图书',
	'coll-add_page' => '添加页面',
	'coll-remove_page' => '移除维基页面',
	'coll-add_category' => '添加分类',
	'coll-load_collection' => '载入图书',
	'coll-show_collection' => '显示书',
	'coll-help_collections' => '图书帮助',
	'coll-n_pages' => '$1 {{PLURAL:$1|page|pages}}',
	'coll-unknown_subpage_title' => '未知子页',
	'coll-unknown_subpage_text' => '这个[[Special:Book|图书]]的子页面不存在',
	'coll-printable_version_pdf' => 'PDF 版本',
	'coll-download_as' => '下载为 $1',
	'coll-noscript_text' => '<h1>JavaScript是必需的！</h1>
<strong>您的浏览器不支持JavaScript或JavaScript未开启。

除非您开启JavaScript，此页无法工作。</strong>',
	'coll-intro_text' => '创建和管理您自己的维基页面。<br />查看[[{{MediaWiki:Coll-helppage}}]]以获知更多信息。',
	'coll-helppage' => 'Help:图书',
	'coll-bookscategory' => '图书',
	'coll-savedbook_template' => '已保存的书',
	'coll-your_book' => '您的书籍',
	'coll-download_title' => '下载',
	'coll-download_text' => '选择一种格式后点击按钮就可下载。',
	'coll-download_as_text' => '点这个按钮下载$1格式。',
	'coll-download' => '下载',
	'coll-format_label' => '格式类型：',
	'coll-remove' => '移除',
	'coll-show' => '展开',
	'coll-move_to_top' => '移动至顶',
	'coll-move_up' => '向上移动',
	'coll-move_down' => '向下移动',
	'coll-move_to_bottom' => '移动到按钮',
	'coll-title' => '标题：',
	'coll-subtitle' => '副标题：',
	'coll-contents' => '目录',
	'coll-drag_and_drop' => '通过拖放重新排列维基页面和章节',
	'coll-create_chapter' => '创建章节',
	'coll-sort_alphabetically' => '按字母排序',
	'coll-clear_collection' => '清除记录',
	'coll-rename' => '更名',
	'coll-new_chapter' => '输入新章节的名称',
	'coll-rename_chapter' => '输入章节的新名称',
	'coll-no_such_category' => '无分类',
	'coll-notitle_title' => '无法确定此页标题。',
	'coll-post_failed_msg' => '发送到$1的请求失败（$2）。',
	'coll-error_reponse' => '服务器错误响应',
	'coll-revision' => '修订： $1',
	'coll-save_collection_title' => '保存和共享您的图书',
	'coll-save_collection_text' => '选择您图书的储藏位置：',
	'coll-login_to_save' => '如果您想让保存的图书为以后所用，请[[Special:UserLogin|登录或创建账户]]。',
	'coll-personal_collection_label' => '个人图书：',
	'coll-community_collection_label' => '公有图书：',
	'coll-yes' => '是',
	'coll-no' => '否',
	'coll-load_overwrite_text' => '您的图书中已经有一些网页。
是否要覆盖您目前的图书，或添加新内容，或取消载入？',
	'coll-append' => '附加',
	'coll-cancel' => '取消',
	'coll-update' => '更新',
	'coll-limit_exceeded_text' => '您的图书太大。
禁止新增更多的页面。',
	'coll-rendering_status' => '<strong>状态：</strong> $1',
	'coll-rendering_article' => '（维基页面：$1）',
	'coll-rendering_finished_text' => '<strong>文件已生成。</strong>
<strong>[$1 下载]</strong>到您的电脑。

注释:
* 对输出效果不满意？查看[[{{MediaWiki:Coll-helppage}}|帮助]]以学习如何改善它。',
	'coll-notfound_text' => '未找到。',
	'coll-is_cached' => '<ul><li>一个缓存版本被发现，所以没有必要重新渲染。<a href="$1">强制重新渲染。</a></li></ul>',
	'coll-excluded-templates' => '* [[:Category:$1|$1]]分类下的页面被排除',
	'coll-return_to_collection' => '<p>返回到<a href="$1">$2</a></p>',
	'coll-book_title' => '印刷成一本纸制书',
	'coll-book_text' => '从我们的合作伙伴中获得已打印您选择的维基页面的纸质书籍：',
	'coll-order_from_pp' => '从$1的图书订单',
	'coll-about_pp' => '关于$1',
	'coll-invalid_podpartner_msg' => '合作伙伴无效。
请联系系统管理员。',
	'coll-license' => '许可协议',
	'coll-return_to' => '返回到[[:$1]]',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Skjackey tse
 * @author Wmr89502270
 * @author Wong128hk
 */
$messages['zh-hant'] = array(
	'coll-desc' => '[[Special:Book|建立圖書]]',
	'coll-collection' => '圖書',
	'coll-collections' => '圖書',
	'coll-mwserve_failed_msg' => '服务器渲染错误：<nowiki>$1</nowiki>',
	'coll-save_category' => '所有图书都保存在分类[[:Category:{{MediaWiki:Coll-bookscategory}}|{{MediaWiki:Coll-bookscategory}}]]中。',
	'coll-overwrite' => '覆寫',
	'coll-cancel' => '取消',
	'coll-blacklisted-templates' => '* 由于模板[[:$1]]在黑名单之中所以它被排除。',
);

