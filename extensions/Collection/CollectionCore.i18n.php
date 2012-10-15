<?php

/**
 * Collection Extension for MediaWiki
 * For performance reasons, this file only contains the extension messages
 * that are used from hooks that are almost always loaded.
 *
 * Copyright (C) PediaPress GmbH
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
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

$messages = array();

$messages['en'] = array(
	'coll-print_export'             => 'Print/export',
	'coll-create_a_book'            => 'Create a book',
	'coll-create_a_book_tooltip'    => 'Create a book or page collection',
	'coll-book_creator'             => 'Book creator',
	'coll-download_as'              => 'Download as $1',
	'coll-download_as_tooltip'      => 'Download a $1 version of this wiki page',
	'coll-disable'                  => 'disable',
	'coll-book_creator_disable'     => 'Disable book creator',
	'coll-book_creator_disable_tooltip' => 'Stop using the book creator',
	'coll-add_linked_article'       => 'Add linked wiki page to your book',
	'coll-remove_linked_article'    => 'Remove linked wiki page from your book',
	'coll-add_category'             => 'Add this category to your book',
	'coll-add_category_tooltip'     => 'Add all wiki pages in this category to your book',
	'coll-add_this_page'            => 'Add this page to your book',
	'coll-add_page_tooltip'         => 'Add the current wiki page to your book',
	'coll-bookscategory'            => 'Books',
	'coll-clear_collection'         => 'Clear book',
	'coll-clear_collection_confirm' => 'Do you really want to completely clear your book?',
	'coll-clear_collection_tooltip' => 'Remove all wiki pages from your current book',
	'coll-help'                     => 'Help',
	'coll-help_tooltip'             => 'Show help about creating books',
	'coll-helppage'                 => 'Help:Books',
	'coll-load_collection'          => 'Load book',
	'coll-load_collection_tooltip'  => 'Load this book as your current book',
	'coll-n_pages'                  => '$1 {{PLURAL:$1|page|pages}}',
	'coll-printable_version_pdf'    => 'PDF version',
	'coll-remove_this_page'         => 'Remove this page from your book',
	'coll-remove_page_tooltip'      => 'Remove the current wiki page from your book',
	'coll-show_collection'          => 'Show book',
	'coll-show_collection_tooltip'  => 'Click to edit/download/order your book',
	'coll-not_addable'              => 'This page cannot be added',
	'coll-make_suggestions'         => 'Suggest pages',
	'coll-make_suggestions_tooltip' => 'Show suggestions based on the pages in your book',
	'coll-suggest_enabled'          => '1',
	'coll-suggest_empty'            => 'empty',
	'coll-user_book_prefix'         => '-',
	'coll-community_book_prefix'    => '-',
);

/** Message documentation (Message documentation)
 * @author Aleator
 * @author Amire80
 * @author Aotake
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Lloffiwr
 * @author Mormegil
 * @author Siebrand
 * @author Teak
 */
$messages['qqq'] = array(
	'coll-print_export' => 'Caption of a frame in the toolbar (on the left-hand side of the screen), similar to {{msg-mw|toolbox}} or {{msg-mw|otherlanguages}}.',
	'coll-create_a_book' => '{{Identical|Books}}',
	'coll-download_as' => '$1 is a file format.

{{Identical|Download}}',
	'coll-download_as_tooltip' => '* $1 is some file format(s)',
	'coll-disable' => 'Stop using the book creator',
	'coll-bookscategory' => '{{Identical|Book}}',
	'coll-clear_collection' => '',
	'coll-clear_collection_confirm' => 'Message box when pressed "Clear book".',
	'coll-help' => '{{Identical|Help}}',
	'coll-helppage' => "Used as a link to the help page for this extension's functionality on a wiki. '''Do not translate ''Help:''.'''
{{Identical|Book}}",
	'coll-n_pages' => '{{Identical|Page}}',
	'coll-printable_version_pdf' => 'Caption of a link in the [[mw:Help:Navigation#Toolbox|toolbox]] leading to the PDF version of the current page',
	'coll-suggest_empty' => '{{Identical|Empty}}',
);

/** Afrikaans (Afrikaans)
 * @author Anrie
 * @author Arnobarnard
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'coll-print_export' => 'Druk/eksporteer',
	'coll-create_a_book' => "Skep 'n boek",
	'coll-create_a_book_tooltip' => "Skep 'n boek of versameling van bladsye",
	'coll-book_creator' => 'Boekmaker',
	'coll-download_as' => 'Laai af as $1',
	'coll-download_as_tooltip' => "Laai 'n $1-weergawe van die wikibladsy af",
	'coll-disable' => 'deaktiveer',
	'coll-book_creator_disable' => 'Boek skepper afskakel',
	'coll-book_creator_disable_tooltip' => 'Hou op om met behulp van die boek outeur',
	'coll-add_linked_article' => 'Voeg gekoppel wiki bladsy aan jou boek',
	'coll-remove_linked_article' => 'Verwyder gekoppel wiki bladsy van jou boek',
	'coll-add_category' => 'Voeg die kategorie by jou boek',
	'coll-add_category_tooltip' => 'Voeg al die wikiblaaie in hierdie kategorie by u boek',
	'coll-add_this_page' => 'Voeg hierdie bladsy by u boek',
	'coll-add_page_tooltip' => 'Voeg die huidige wikiblad by u boek',
	'coll-bookscategory' => 'Boeke',
	'coll-clear_collection' => 'Maak boek leeg',
	'coll-clear_collection_confirm' => 'Wil jy regtig jou boek heeltemal duidelik?',
	'coll-clear_collection_tooltip' => 'Verwyder alle wiki-bladsye uit jou huidige boek',
	'coll-help' => 'Help',
	'coll-help_tooltip' => 'Wys help oor die skep van boeke',
	'coll-helppage' => 'Help:Boeke',
	'coll-load_collection' => 'Laai boek',
	'coll-load_collection_tooltip' => 'Laai hierdie boek as jou huidige boek',
	'coll-n_pages' => '$1 {{PLURAL:$1|bladsy|bladsye}}',
	'coll-printable_version_pdf' => 'PDF-weergawe',
	'coll-remove_this_page' => 'Verwyder hierdie bladsy uit u boek',
	'coll-remove_page_tooltip' => 'Verwyder die huidige wiki bladsy van jou boek',
	'coll-show_collection' => 'Wys boek',
	'coll-not_addable' => 'Hierdie bladsy kan nie bygevoeg word nie',
	'coll-make_suggestions' => 'Stel bladsye voor',
	'coll-make_suggestions_tooltip' => 'Wys voorstelle wat gebaseer is op die bladsye in jou boek',
	'coll-suggest_empty' => 'leegmaak',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'coll-print_export' => 'Imprentar/exportar',
	'coll-create_a_book' => 'Creyar un libro',
	'coll-create_a_book_tooltip' => 'Creyar un libro u replega de pachinas',
	'coll-book_creator' => 'Creyador de libros',
	'coll-download_as' => 'Descargar como $1',
	'coll-download_as_tooltip' => "Descargar una versión $1 d'ista pachina wiki",
	'coll-disable' => 'Desactivar',
	'coll-book_creator_disable' => 'Desactivar o creyador de libros',
	'coll-book_creator_disable_tooltip' => "Deixar d'usar o creyador de libros",
	'coll-add_linked_article' => 'Adhibir una pachina wiki vinculada a o tuyo libro',
	'coll-remove_linked_article' => "Eliminar una pachina wiki vinculada d'o tuyo libro",
	'coll-add_category' => 'Adhibir ista categoría a o tuyo libro',
	'coll-add_category_tooltip' => 'Adhibir todas as pachinas wiki en ista categoría a o tuyo libro',
	'coll-add_this_page' => 'Adhibir ista pachina a o suyo libro',
	'coll-add_page_tooltip' => 'Adhibir a pachina wiki actual a o tuyo libro',
	'coll-bookscategory' => 'Libros',
	'coll-clear_collection' => 'Borrar libro',
	'coll-clear_collection_confirm' => 'De verdat quiere borrar de tot iste libro?',
	'coll-clear_collection_tooltip' => "Sacar todas as pachinas wiki d'o suyo libro actual",
	'coll-help' => 'Aduya',
	'coll-help_tooltip' => 'Amostrar aduya sobre a creyación de libros',
	'coll-helppage' => 'Help:Libros',
	'coll-load_collection' => 'Cargar libro',
	'coll-load_collection_tooltip' => 'Cargar iste libro como o suyo libro actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|pachina|pachinas}}',
	'coll-printable_version_pdf' => 'Versión PDF',
	'coll-remove_this_page' => "Sacar ista pachina d'o suyo libro",
	'coll-remove_page_tooltip' => "Sacar a pachina wiki actual d'o suyo libro",
	'coll-show_collection' => 'Amostrar libro',
	'coll-show_collection_tooltip' => 'Faiga click ta editar/descargar/encargar o suyo libro',
	'coll-not_addable' => 'Ista pachina no se i puede adhibir',
	'coll-make_suggestions' => 'Sucherir pachinas',
	'coll-make_suggestions_tooltip' => "Amostrar sucherencias basadas en as pachinas d'o suyo libro",
	'coll-suggest_empty' => 'vuedo',
);

/** Arabic (العربية)
 * @author Antime
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 * @author Prof.Sherif
 * @author Samer
 * @author زكريا
 */
$messages['ar'] = array(
	'coll-print_export' => 'طباعة وتصدير',
	'coll-create_a_book' => 'إنشاء كتاب',
	'coll-create_a_book_tooltip' => 'أنشئ كتابًا أو صفحة مجموعة',
	'coll-book_creator' => 'منشئ الكتب',
	'coll-download_as' => 'تحميل ب$1',
	'coll-download_as_tooltip' => 'تحميل نسخة $1 من صفحة الويكي هذه.',
	'coll-disable' => 'عطّل',
	'coll-book_creator_disable' => 'عطّل منشئ الكتب',
	'coll-book_creator_disable_tooltip' => 'أوقف استخدام منشئ الكتب',
	'coll-add_linked_article' => 'أضف صفحة ويكي مربوطة إلى كتابك',
	'coll-remove_linked_article' => 'أزل صفحة ويكي مربوطة من كتابك',
	'coll-add_category' => 'إضافة هذا التصنيف إلى كتابك',
	'coll-add_category_tooltip' => 'أضف كل صفحات الويكي في هذا التصنيف لكتابك',
	'coll-add_this_page' => 'أضف هذه الصفحة إلى كتابك',
	'coll-add_page_tooltip' => 'أضف صفحة الويكي الحالية إلى كتابك',
	'coll-bookscategory' => 'كتب',
	'coll-clear_collection' => 'إفراغ الكتاب',
	'coll-clear_collection_confirm' => 'هل تريد حقا إفراغ كتابك بالكامل؟',
	'coll-clear_collection_tooltip' => 'أزل كل صفحات الويكي من كتابك الحالي',
	'coll-help' => 'مساعدة',
	'coll-help_tooltip' => 'أظهر مساعدة عن كيفية إنشاء الكتب',
	'coll-helppage' => 'Help:كتب',
	'coll-load_collection' => 'تحميل الكتاب',
	'coll-load_collection_tooltip' => 'حمل هذا الكتاب ككتابك الحالي',
	'coll-n_pages' => '{{PLURAL:$1||صفحة واحدة|صفحتان|$1 صفحات|$1 صفحة}}',
	'coll-printable_version_pdf' => 'نسخة صيغة المستندات المحمولة',
	'coll-remove_this_page' => 'أزل هذه الصفحة من كتابك',
	'coll-remove_page_tooltip' => 'أزل صفحة الويكي الحالية من كتابك',
	'coll-show_collection' => 'عرض الكتاب',
	'coll-show_collection_tooltip' => 'اضغط لتعديل/تنزيل/طلب كتابك',
	'coll-not_addable' => 'لا يمكن إضافة هذه الصفحة',
	'coll-make_suggestions' => 'اقترح صفحات',
	'coll-make_suggestions_tooltip' => 'أظهر التعديلات بناءً على صفحات كتابك',
	'coll-suggest_empty' => 'فارغ',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'coll-print_export' => 'ܛܒܘܥ/ܐܦܩ',
	'coll-create_a_book' => 'ܒܪܝ ܟܬܒܐ',
	'coll-book_creator' => 'ܒܪܘܝܐ ܕܟܬܒܐ',
	'coll-download_as' => 'ܐܚܬ ܐܝܟ $1',
	'coll-bookscategory' => 'ܟܬܒ̈ܐ',
	'coll-help' => 'ܥܘܕܪܢܐ',
	'coll-helppage' => 'Help:ܟܬܒ̈ܐ',
	'coll-n_pages' => '$1 {{PLURAL:$1|ܕܦܐ|ܕܦ̈ܐ}}',
	'coll-printable_version_pdf' => 'ܨܚܚܐ ܕPDF',
	'coll-show_collection' => 'ܚܘܝ ܟܬܒܐ',
	'coll-suggest_empty' => 'ܣܦܝܩܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Dudi
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'coll-print_export' => 'اطبع/صدّر',
	'coll-create_a_book' => 'إعمل كتاب',
	'coll-create_a_book_tooltip' => 'إعمل كتاب او مجموعة صفح',
	'coll-book_creator' => 'صاحب الكتاب',
	'coll-download_as' => 'Download as $1',
	'coll-download_as_tooltip' => 'Download a $1 version of this wiki page',
	'coll-disable' => 'disable',
	'coll-book_creator_disable' => 'Disable الاوپشن بتاع خلق الكتب',
	'coll-book_creator_disable_tooltip' => 'وقّف استعمال الاوپشن بتاع خلق الكتب',
	'coll-add_linked_article' => 'زوّد لينك صفحة الwiki فى الكتاب بتاعك',
	'coll-remove_linked_article' => 'إمسح لينك صفحة الwiki من الكتاب بتاعك',
	'coll-add_category' => 'زودّ التصنيف ده على الكتاب بتاعك',
	'coll-add_category_tooltip' => 'زوّد كل صفح الwiki فى التصنيف ده فى كتابك',
	'coll-add_this_page' => 'زوّد الصفحه دى فى الكتاب بتاعك',
	'coll-add_page_tooltip' => 'زوّد صفحة الwiki بتاعة دلوقتى فى الكتاب بتاعك',
	'coll-bookscategory' => 'كتب',
	'coll-clear_collection' => 'فضّى الكتاب',
	'coll-clear_collection_confirm' => 'هو انت فعلا عاوز تفضّى الكتاب بتاعك خالص؟',
	'coll-clear_collection_tooltip' => 'شيل كل صفح الwiki من الكتاب بتاعك بتاع دلوقتى',
	'coll-help' => 'مساعده',
	'coll-help_tooltip' => 'بيّن المساعده بتاعة خلق الكتب',
	'coll-helppage' => 'Help:كتب',
	'coll-load_collection' => 'Load book',
	'coll-load_collection_tooltip' => 'إعمل load للكتاب ده علشان يبقى الكتاب بتاعك بتاع دلوقتى',
	'coll-n_pages' => '$1 {{PLURAL:$1|صفحه|صفحه}}',
	'coll-printable_version_pdf' => 'نسخه PDF',
	'coll-remove_this_page' => 'إمسح الصفحه دى من الكتاب بتاعك',
	'coll-remove_page_tooltip' => 'إمسح صفحة الwiki بتاعة دلوقتى من الكتاب بتاعك',
	'coll-show_collection' => 'إعرض الكتاب',
	'coll-show_collection_tooltip' => 'دوس على تعديل/download/‏order الكتاب بتاعك',
	'coll-not_addable' => 'الصفحه دى مش نافعه تتزوّد',
	'coll-make_suggestions' => 'إقترح صفح',
	'coll-make_suggestions_tooltip' => 'إعرض الإقتراحات على اساس صفح الكتاب بتاعك',
	'coll-suggest_empty' => 'فاضى',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'coll-print_export' => 'Imprentar/esportar',
	'coll-create_a_book' => 'Crear un llibru',
	'coll-create_a_book_tooltip' => 'Crear un llibru o coleición de páxines',
	'coll-book_creator' => 'Creador de llibros',
	'coll-download_as' => 'Descargar como $1',
	'coll-download_as_tooltip' => "Descargar una versión $1 d'esta páxina wiki",
	'coll-disable' => 'desactivar',
	'coll-book_creator_disable' => 'Desactivar el creador de llibros',
	'coll-book_creator_disable_tooltip' => "Dexar d'usar el creador de llibros",
	'coll-add_linked_article' => 'Amestar páxina wiki enllazada al to llibru',
	'coll-remove_linked_article' => 'Desaniciar páxina wiki enllazada del to llibru',
	'coll-add_category' => 'Amestar esta categoría al to llibru',
	'coll-add_category_tooltip' => "Amestar toles páxines wiki d'esta categoría al to llibru",
	'coll-add_this_page' => 'Amestar esta páxina al to llibru',
	'coll-add_page_tooltip' => 'Amestar la páxina wiki actual al to llibru',
	'coll-bookscategory' => 'Llibros',
	'coll-clear_collection' => 'Llimpiar llibru',
	'coll-clear_collection_confirm' => "¿De xuro quies llimpiar dafechu'l to llibru?",
	'coll-clear_collection_tooltip' => 'Desaniciar toles páxines wiki del llibru actual',
	'coll-help' => 'Ayuda',
	'coll-help_tooltip' => "Amosar l'ayuda tocante a crear llibros",
	'coll-helppage' => 'Help:Llibros',
	'coll-load_collection' => 'Cargar llibru',
	'coll-load_collection_tooltip' => "Cargar esti llibru como'l to llibru actual",
	'coll-n_pages' => '$1 {{PLURAL:$1|páxina|páxines}}',
	'coll-printable_version_pdf' => 'Versión PDF',
	'coll-remove_this_page' => 'Desaniciar esta páxina del to llibru',
	'coll-remove_page_tooltip' => 'Desaniciar la páxina wiki actual del to llibru',
	'coll-show_collection' => 'Amosar llibru',
	'coll-show_collection_tooltip' => 'Calca pa editar/descargar/pidir el to llibru',
	'coll-not_addable' => 'Esta páxina nun se pue amestar',
	'coll-make_suggestions' => 'Suxerir páxines',
	'coll-make_suggestions_tooltip' => 'Amosar suxerencies basándose nes páxines del to llibru',
	'coll-suggest_empty' => 'balero',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'coll-bookscategory' => 'Kitablar',
	'coll-help' => 'Kömək',
	'coll-helppage' => 'Kömək:Kitablar',
	'coll-suggest_empty' => 'boş',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'coll-print_export' => 'Баҫтырырға/сығарырға',
	'coll-create_a_book' => 'Китап булдырырға',
	'coll-create_a_book_tooltip' => 'Китап йәки биттәр йыйынтығын булдырырға',
	'coll-book_creator' => 'Китап оҫтаһы',
	'coll-download_as' => '$1 форматында күсереп алырға',
	'coll-download_as_tooltip' => 'Был вики-биттең $1 өлгөһөн күсереп алырға',
	'coll-disable' => 'һүндерергә',
	'coll-book_creator_disable' => 'Китап оҫтаһын һүндерергә',
	'coll-book_creator_disable_tooltip' => 'Китап оҫтаһын ҡүлланыуҙы туҡтатырға',
	'coll-add_linked_article' => 'Бәйле вики-битте китабығыҙға өҫтәргә',
	'coll-remove_linked_article' => 'Бәйле вики-битте китабығыҙҙан юйырға',
	'coll-add_category' => 'Был категорияны китабығыҙға өҫтәргә',
	'coll-add_category_tooltip' => 'Был категорияның вики-биттәрен китабығыҙға өҫтәргә',
	'coll-add_this_page' => 'Был битте китабығыҙға өҫтәргә',
	'coll-add_page_tooltip' => 'Ағымдағы вики-битте китабығыҙға өҫтәргә',
	'coll-bookscategory' => 'Китаптар',
	'coll-clear_collection' => 'Китапты таҙартырға',
	'coll-clear_collection_confirm' => 'Һеҙ ысынлап та китабығыҙҙы тулыһынса таҙартырға теләйһегеҙме?',
	'coll-clear_collection_tooltip' => 'Бөтә вики-биттәрҙе ағымдағы китабығыҙҙан юйырға',
	'coll-help' => 'Белешмә',
	'coll-help_tooltip' => 'Китап булдырыу тураһында белешмә күрһәтергә',
	'coll-helppage' => 'Help:Китаптар',
	'coll-load_collection' => 'Китап тейәргә',
	'coll-load_collection_tooltip' => 'Был китапты ағымдағы китабығыҙ рәүешендә тейәргә',
	'coll-n_pages' => '$1 {{PLURAL:$1|бит}}',
	'coll-printable_version_pdf' => 'PDF өлгөһө',
	'coll-remove_this_page' => 'Был битте китабығыҙҙан сығарығыҙ',
	'coll-remove_page_tooltip' => 'Ағымдағы вики-битте китабығыҙҙан сығарырға',
	'coll-show_collection' => 'Китапты күрһәтергә',
	'coll-show_collection_tooltip' => 'Китапты мөхәррирләү/тейәү/заказ биреү өсөн баҫығыҙ',
	'coll-not_addable' => 'Был битте өҫтәп булмай',
	'coll-make_suggestions' => 'Тәҡдим ителгән биттәр',
	'coll-make_suggestions_tooltip' => 'Китабығыҙҙа булған биттәргә таянып һөйләмдәрҙе күрһәт',
	'coll-suggest_empty' => 'буш',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'coll-print_export' => 'Durcka/exportiarn',
	'coll-create_a_book' => 'Buach erstöin',
	'coll-create_a_book_tooltip' => 'A Buach oder a Artikesåmmlung erstöin',
	'coll-book_creator' => 'Buachgenarator',
	'coll-download_as' => 'Ois $1 owerloon',
	'coll-download_as_tooltip' => 'A $1-Version vo derer Wikisaiten owerloon',
	'coll-disable' => 'deaktiviarn',
	'coll-book_creator_disable' => 'Buachgenarator deaktiviarn',
	'coll-book_creator_disable_tooltip' => 'Buachgenaraor ned vawenden',
	'coll-add_linked_article' => 'Fiag de valinkte Wikisaiten daim Buach zua',
	'coll-remove_linked_article' => 'Entfern de valinkte Wikisaiten aus daim Buach',
	'coll-add_category' => 'Olle Saiten aus derer Kategorii daim Buach dazuafyng',
	'coll-add_category_tooltip' => 'Olle Wikisaiten vo derer Kategorii daim Buach dazuafyng',
	'coll-add_this_page' => 'De Saiten do ua daim Buach dazuafyng',
	'coll-add_page_tooltip' => 'De aktuöie Wikisaiten daim Buach dazuafyng',
	'coll-bookscategory' => 'Biacher',
	'coll-clear_collection' => 'Buach leschen',
	'coll-clear_collection_confirm' => 'Mechadst wirkle dai Buach leschen?',
	'coll-clear_collection_tooltip' => 'Olle Wikisaiten aus daim aktuöin Buach entferna',
	'coll-help' => 'Hüif',
	'coll-help_tooltip' => 'Hüif zum Erstöin vo Biacher åzoang',
	'coll-helppage' => 'Help:Biacher',
	'coll-load_collection' => 'Buach loon',
	'coll-load_collection_tooltip' => 'Des Buach dodan ois dai aktuöis Buach loon',
	'coll-n_pages' => '$1 {{PLURAL:$1|Wikisaiten|Wikisaiten}}',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-remove_this_page' => 'De Saitn aus daim Buach entferna',
	'coll-remove_page_tooltip' => 'De aktuöie Wikisaiten aus daim Buach entferna',
	'coll-show_collection' => 'Buach zoang',
	'coll-show_collection_tooltip' => "Durcka, um dai Buach z' beorwaiten/ower z' loon/z' bstöin",
	'coll-not_addable' => 'De Saiten do kå ned dazuagfygt wern',
	'coll-make_suggestions' => 'Saiten vurschlong',
	'coll-make_suggestions_tooltip' => 'Vurschläg basiarnd auf de Saiten in daim Buach åzoang',
	'coll-suggest_empty' => 'laar',
);

/** Belarusian (Беларуская)
 * @author Тест
 * @author Хомелка
 */
$messages['be'] = array(
	'coll-print_export' => 'Друк/экспарт',
	'coll-create_a_book' => 'Стварыць кнігу',
	'coll-create_a_book_tooltip' => 'Стварыць кнігу альбо калекцыю артыкулаў',
	'coll-book_creator' => 'Майстар стварэння кнігі',
	'coll-download_as' => 'Загрузіць як $1',
	'coll-download_as_tooltip' => 'Загрузіць версію $1 гэтай вікі-старонкі',
	'coll-disable' => 'выключыць',
	'coll-book_creator_disable' => 'Выключыць майстра стварэння кнігі',
	'coll-book_creator_disable_tooltip' => 'Спыніць выкарыстанне майстра стварэння кнігі',
	'coll-add_linked_article' => 'Дадаць звязаную вікі-старонку ў Вашу кнігу',
	'coll-remove_linked_article' => 'Выдаліць звязаную вікі-старонку з Вашай кнігі',
	'coll-add_category' => 'Дадаць гэтую катэгорыю ў Вашую кнігу',
	'coll-add_category_tooltip' => 'Дадаць усе старонкі з гэтай катэгорыі ў Вашую кнігу',
	'coll-add_this_page' => 'Дадаць гэтую старонку ў Вашую кнігу',
	'coll-add_page_tooltip' => 'Дадаць цяперашнюю вікі-старонку ў Вашую кнігу',
	'coll-bookscategory' => 'Кнігі',
	'coll-clear_collection' => 'Ачысціць кнігу',
	'coll-clear_collection_confirm' => 'Вы сапраўды жадаеце поўнасцю ачысціць Вашую кнігу?',
	'coll-clear_collection_tooltip' => 'Выдаліць усе старонкі з Вашай цяперашняй кнігі',
	'coll-help' => 'Даведка',
	'coll-help_tooltip' => 'Паказаць дапамогу па стварэнню кніг',
	'coll-helppage' => 'Help:Кнігі',
	'coll-load_collection' => 'Загрузіць кнігу',
	'coll-load_collection_tooltip' => 'Загрузіць гэтую кнігу як Вашую цяперашнюю кнігу',
	'coll-n_pages' => '$1 {{PLURAL:$1|старонка|старонкі|старонак}}',
	'coll-printable_version_pdf' => 'PDF-версія',
	'coll-remove_this_page' => 'Выдаліць гэтую старонку з Вашай кнігі',
	'coll-remove_page_tooltip' => 'Выдаліць цяперашнюю вікі-старонку з Вашай кнігі',
	'coll-show_collection' => 'Паказаць кнігу',
	'coll-show_collection_tooltip' => 'Націсніце для рэдагавання/загрузкі/заказу Вашай кнігі',
	'coll-not_addable' => 'Гэтая старонка не можа быць дададзеная',
	'coll-make_suggestions' => 'Прапанаваць старонкі',
	'coll-make_suggestions_tooltip' => 'Паказаць прапановы заснаваныя на старонках у Вашай кнізе',
	'coll-suggest_empty' => 'пуста',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'coll-print_export' => 'Друк/экспарт',
	'coll-create_a_book' => 'Стварыць кнігу',
	'coll-create_a_book_tooltip' => 'Стварыць кнігу альбо калекцыю артыкулаў',
	'coll-book_creator' => 'Майстар стварэньня кнігі',
	'coll-download_as' => 'Загрузіць як $1',
	'coll-download_as_tooltip' => 'Загрузіць вэрсію $1 гэтай вікі-старонкі',
	'coll-disable' => 'выключыць',
	'coll-book_creator_disable' => 'Выключыць майстра стварэньня кнігі',
	'coll-book_creator_disable_tooltip' => 'Спыніць выкарыстаньне майстра стварэньня кнігі',
	'coll-add_linked_article' => 'Дадаць зьвязаную вікі-старонку ў Вашу кнігу',
	'coll-remove_linked_article' => 'Выдаліць зьвязаную вікі-старонку з Вашай кнігі',
	'coll-add_category' => 'Дадаць гэтую катэгорыю ў Вашую кнігу',
	'coll-add_category_tooltip' => 'Дадаць усе старонкі з гэтай катэгорыі ў Вашую кнігу',
	'coll-add_this_page' => 'Дадаць гэтую старонку ў Вашую кнігу',
	'coll-add_page_tooltip' => 'Дадаць цяперашнюю вікі-старонку ў Вашую кнігу',
	'coll-bookscategory' => 'Кнігі',
	'coll-clear_collection' => 'Ачысьціць кнігу',
	'coll-clear_collection_confirm' => 'Вы сапраўды жадаеце поўнасьцю ачысьціць Вашую кнігу?',
	'coll-clear_collection_tooltip' => 'Выдаліць усе старонкі з Вашай цяперашняй кнігі',
	'coll-help' => 'Дапамога',
	'coll-help_tooltip' => 'Паказаць дапамогу па стварэньню кніг',
	'coll-helppage' => 'Help:Кнігі',
	'coll-load_collection' => 'Загрузіць кнігу',
	'coll-load_collection_tooltip' => 'Загрузіць гэтую кнігу як Вашую цяперашнюю кнігу',
	'coll-n_pages' => '$1 {{PLURAL:$1|старонка|старонкі|старонак}}',
	'coll-printable_version_pdf' => 'PDF-вэрсія',
	'coll-remove_this_page' => 'Выдаліць гэтую старонку з Вашай кнігі',
	'coll-remove_page_tooltip' => 'Выдаліць цяперашнюю вікі-старонку з Вашай кнігі',
	'coll-show_collection' => 'Паказаць кнігу',
	'coll-show_collection_tooltip' => 'Націсьніце для рэдагаваньня/загрузкі/заказу Вашай кнігі',
	'coll-not_addable' => 'Гэтая старонка ня можа быць дададзеная',
	'coll-make_suggestions' => 'Прапанаваць старонкі',
	'coll-make_suggestions_tooltip' => 'Паказаць прапановы заснаваныя на старонках у Вашай кнізе',
	'coll-suggest_empty' => 'пуста',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Turin
 */
$messages['bg'] = array(
	'coll-print_export' => 'Отпечатване/изнасяне',
	'coll-create_a_book' => 'Създаване на книга',
	'coll-create_a_book_tooltip' => 'Създаване на книга или колекция от страници',
	'coll-download_as' => 'Изтегляне като $1',
	'coll-disable' => 'изключване',
	'coll-add_category' => 'Добавяне на тази категория към книгата ви',
	'coll-add_category_tooltip' => 'Добавяне на всички уики-страници в тази категория към книгата ви',
	'coll-add_this_page' => 'Добавяне на тази страница към книгата ви',
	'coll-add_page_tooltip' => 'Добавяне на текущата уики-страница към книгата ви',
	'coll-bookscategory' => 'Книги',
	'coll-clear_collection' => 'Изчистване на книгата',
	'coll-clear_collection_confirm' => 'Наистина ли искате напълно да изчистите вашата книга?',
	'coll-clear_collection_tooltip' => 'Премахване на всички уики-страници от текущата книга',
	'coll-help' => 'Помощ',
	'coll-help_tooltip' => 'Показване на помощ за създаването на книги',
	'coll-helppage' => 'Help:Книги',
	'coll-load_collection' => 'Зареждане на книга',
	'coll-load_collection_tooltip' => 'Зареждане на тази книга като ваша текуща книга',
	'coll-n_pages' => '$1 {{PLURAL:$1|страница|страници}}',
	'coll-printable_version_pdf' => 'PDF версия',
	'coll-remove_this_page' => 'Премахване на тази страница от книгата ви',
	'coll-remove_page_tooltip' => 'Премахване на текущата уики-страница от книгата ви',
	'coll-show_collection' => 'Показване на книгата',
	'coll-not_addable' => 'Тази страница не може да бъде добавена',
	'coll-make_suggestions' => 'Предлагане на страници',
	'coll-make_suggestions_tooltip' => 'Показване на предложения въз основа на страниците в книгата ви',
	'coll-suggest_empty' => 'празно',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Jayantanth
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'coll-print_export' => 'মুদ্রণ/এক্সপোর্ট',
	'coll-create_a_book' => 'বই তৈরি করো',
	'coll-create_a_book_tooltip' => 'পাতার সংকলন বা বই তৈরি করো',
	'coll-book_creator' => 'বই প্রস্তুতকারক',
	'coll-download_as' => '$1 ডাউনলোড',
	'coll-download_as_tooltip' => 'এই উইকি পাতার $1 সংস্করণটি ডাউনলোড করো',
	'coll-disable' => 'নিস্ক্রিয়',
	'coll-book_creator_disable' => 'বই প্রস্তুতকারক নিস্ক্রিয় করো',
	'coll-book_creator_disable_tooltip' => 'বই প্রস্তুতকারক ব্যবহার বন্ধ করুন',
	'coll-add_linked_article' => 'আপনার বইয়ে উইকি পাতার সংযোগ দিন',
	'coll-remove_linked_article' => 'আপনার বই থেকে উইকি পাতার সংযোগ অপসারণ করুন',
	'coll-add_category' => 'এই বিষয়শ্রেণীটি আপনার বইয়ে যোগ করুন',
	'coll-add_category_tooltip' => 'এই বিষয়শ্রেণীর সমস্ত উইকি পাতাগুলো আপনার বইয়ে যোগ করুন',
	'coll-add_this_page' => 'এই পাতাটি আপনার বইয়ে যোগ করুন।',
	'coll-add_page_tooltip' => 'বর্তমান পাতাটি আপনার বইয়ে যোগ করুন',
	'coll-bookscategory' => 'বইসমূহ',
	'coll-clear_collection' => 'বই পরিষ্কার করো',
	'coll-clear_collection_confirm' => 'আপনি কি আসলেই আপনার বই পরিষ্কার করতে চান?',
	'coll-clear_collection_tooltip' => 'বর্তমান বই থেকে সকল উইকি পাতাগুলো অপসারণ করো',
	'coll-help' => 'সহায়িকা',
	'coll-help_tooltip' => 'বই তৈরি সংক্রান্ত সহায়তা দেখাও',
	'coll-helppage' => 'Help:বই',
	'coll-load_collection' => 'বই লোড করো',
	'coll-load_collection_tooltip' => 'বর্তমান বই হিসেবে এই বইটি লোড করুন',
	'coll-n_pages' => '$1 {{PLURAL:$1|পাতাট|পাতাগুলো}}',
	'coll-printable_version_pdf' => 'পিডিএফ সংস্করণ',
	'coll-remove_this_page' => 'এই পাতাটি আপনার বই থেকে অপসারণ করুন',
	'coll-remove_page_tooltip' => 'আপনার বই থেকে বর্তমান উইকি পাতা অপসারণ করুন',
	'coll-show_collection' => 'বই দেখাও',
	'coll-show_collection_tooltip' => 'আপনার বই সম্পাদনা/ডাউনলোড/অর্ডার দিতে ক্লিক করুন',
	'coll-not_addable' => 'এই পাতাটি যোগ করা যাবে না',
	'coll-make_suggestions' => 'পরামর্শ পাতা',
	'coll-make_suggestions_tooltip' => 'বইয়ের পাতার উপর ভিত্তি করে পরামর্শগুলো দেখাও',
	'coll-suggest_empty' => 'খালি',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'coll-print_export' => 'Moullañ / ezporzhiañ',
	'coll-create_a_book' => 'Sevel ul levr',
	'coll-create_a_book_tooltip' => 'Sevel ul levr pe un torkad pennadoù',
	'coll-book_creator' => 'Saver levrioù',
	'coll-download_as' => 'Pellgargañ evel $1',
	'coll-download_as_tooltip' => 'Pellgargañ ur stumm $1 eus ar bajenn wiki-mañ',
	'coll-disable' => 'diweredekaat',
	'coll-book_creator_disable' => 'Diweredekaat ar saver levrioù',
	'coll-book_creator_disable_tooltip' => "Paouez d'ober gant ar saver levrioù",
	'coll-add_linked_article' => 'Ouzhpennañ ar bajenn wiki liammet gant ho levr',
	'coll-remove_linked_article' => "Tennañ ar bajenn wiki liammet d'ho levr",
	'coll-add_category' => "Ouzhpennañ ar rummad-mañ d'ho levr",
	'coll-add_category_tooltip' => "Ouzhpennañ an holl pajennoù wiki er rummad-mañ d'ho levr",
	'coll-add_this_page' => "Ouzhpennañ ar bajenn-mañ d'ho levr",
	'coll-add_page_tooltip' => "Ouzhpennañ ar bajenn wiki-mañ d'ho levr",
	'coll-bookscategory' => 'Levrioù',
	'coll-clear_collection' => 'Goullonderiñ al levr',
	'coll-clear_collection_confirm' => "Ha sur oc'h e fell deoc'h riñsañ ho levr penn-da-benn ?",
	'coll-clear_collection_tooltip' => 'Tennañ kuit an holl bajennoù wiki eus ho levr a-vremañ',
	'coll-help' => 'Skoazell',
	'coll-help_tooltip' => 'Diskouez ar skoazell diwar-benn ar sevel levrioù',
	'coll-helppage' => 'Help:Levrioù',
	'coll-load_collection' => 'Kargañ ul levr',
	'coll-load_collection_tooltip' => 'Kargañ al levr-mañ evel ho levr a-vremañ',
	'coll-n_pages' => '$1 {{PLURAL:$1|pajenn|pajenn}}',
	'coll-printable_version_pdf' => 'Stumm PDF',
	'coll-remove_this_page' => 'Tennañ ar bajenn-mañ eus ho levr',
	'coll-remove_page_tooltip' => 'Tennañ ar bajenn red eus ho levr',
	'coll-show_collection' => 'Diskouez al levr',
	'coll-show_collection_tooltip' => 'Klikañ evit aozañ/pellgargañ/urzhiañ ho levr',
	'coll-not_addable' => "N'haller ket ouzhpennañ ar bajenn-mañ",
	'coll-make_suggestions' => 'Kinnig pajennoù',
	'coll-make_suggestions_tooltip' => "Diskouez ar c'hinnigoù diazezet war pajennoù ho levr",
	'coll-suggest_empty' => 'goullo',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Smooth O
 */
$messages['bs'] = array(
	'coll-print_export' => 'Štampaj/izvezi',
	'coll-create_a_book' => 'Napravi knjigu',
	'coll-create_a_book_tooltip' => 'Napravi knjigu ili kolekciju članaka',
	'coll-book_creator' => 'Pravljenje knjiga',
	'coll-download_as' => 'Učitaj kao $1',
	'coll-download_as_tooltip' => 'Skinite $1 verziju ove wiki stranice',
	'coll-disable' => 'isključena',
	'coll-book_creator_disable' => 'Onemogući pravljenje knjiga',
	'coll-book_creator_disable_tooltip' => 'Prestani koristiti pravljenje knjiga',
	'coll-add_linked_article' => 'Dodaj povezanu wiki stranicu u vašu knjigu',
	'coll-remove_linked_article' => 'Ukloni povezanu wiki stranicu iz Vaše knjige',
	'coll-add_category' => 'Dodaj ovu kategoriju u Vašu knjigu',
	'coll-add_category_tooltip' => 'Dodaj sve wiki članke iz ove kategorije u Vašu knjigu',
	'coll-add_this_page' => 'Dodajte ovu stranicu u Vašu knjigu',
	'coll-add_page_tooltip' => 'Dodaj trenutnu wiki stranicu u Vašu knjigu',
	'coll-bookscategory' => 'Knjige',
	'coll-clear_collection' => 'Očisti knjigu',
	'coll-clear_collection_confirm' => 'Da li zaista želite da potpuno očistite Vašu knjigu?',
	'coll-clear_collection_tooltip' => 'Ukloni sve wiki članke iz Vaše trenutne knjige',
	'coll-help' => 'Pomoć',
	'coll-help_tooltip' => 'Prikaži pomoć za pravljenje knjiga',
	'coll-helppage' => 'Help:Knjige',
	'coll-load_collection' => 'Učitaj knjigu',
	'coll-load_collection_tooltip' => 'Učitaj ovu knjigu kao Vašu trenutnu knjigu',
	'coll-n_pages' => '$1 {{PLURAL:$1|stranica|stranice|stranica}}',
	'coll-printable_version_pdf' => 'PDF verzija',
	'coll-remove_this_page' => 'Ukloni ovu stranicu iz Vaše knjige',
	'coll-remove_page_tooltip' => 'Ukloni trenutnu wiki stranicu iz Vaše knjige',
	'coll-show_collection' => 'Prikaži knjigu',
	'coll-show_collection_tooltip' => 'Kliknite za uređivanje/download/naručivanje Vaše knjige',
	'coll-not_addable' => 'Ova stranica se ne može dodati',
	'coll-make_suggestions' => 'Predloži stranice',
	'coll-make_suggestions_tooltip' => 'Prikaži prijedloge zasnovane na stranicama iz Vaše knjige',
	'coll-suggest_empty' => 'prazno',
);

/** Catalan (Català)
 * @author Aleator
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Vriullop
 */
$messages['ca'] = array(
	'coll-print_export' => 'Imprimeix/exporta',
	'coll-create_a_book' => 'Crea un llibre',
	'coll-create_a_book_tooltip' => 'Crea un llibre o una col·lecció de pàgines',
	'coll-book_creator' => 'Creador de llibres',
	'coll-download_as' => 'Descarrega com $1',
	'coll-download_as_tooltip' => "Descarrega una versió $1 d'aquesta pàgina wiki",
	'coll-disable' => 'Inhabilita',
	'coll-book_creator_disable' => 'Desactiva el creador de llibres',
	'coll-book_creator_disable_tooltip' => "Deixa d'usar el creador de llibres",
	'coll-add_linked_article' => "Afegeix la pàgina de l'enllaç al vostre llibre",
	'coll-remove_linked_article' => "Treu del llibre la pàgina de l'enllaç",
	'coll-add_category' => 'Afegiu aquesta categoria al vostre llibre',
	'coll-add_category_tooltip' => "Afegeix al llibre totes les pàgines d'aquesta categoria",
	'coll-add_this_page' => 'Afegiu aquesta pàgina al vostre llibre',
	'coll-add_page_tooltip' => 'Afegeix la pàgina wiki actual al llibre',
	'coll-bookscategory' => 'Llibres',
	'coll-clear_collection' => 'Buida llibre',
	'coll-clear_collection_confirm' => 'Esteu segurs de buidar completament el vostre llibre?',
	'coll-clear_collection_tooltip' => 'Esborra totes les pàgines wiki del llibre actual',
	'coll-help' => 'Ajuda',
	'coll-help_tooltip' => "Mostra l'ajuda sobre la creació de llibres",
	'coll-helppage' => 'Help:Llibres',
	'coll-load_collection' => 'Carrega llibre',
	'coll-load_collection_tooltip' => 'Carrega aquest llibre com el vostre llibre actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|pàgina|pàgines}}',
	'coll-printable_version_pdf' => 'Versió en PDF',
	'coll-remove_this_page' => 'Eliminau aquesta pàgina del vostre llibre',
	'coll-remove_page_tooltip' => 'Treu la pàgina wiki actual del llibre',
	'coll-show_collection' => 'Mostra llibre',
	'coll-show_collection_tooltip' => 'Feu clic per a editar/descarregar/demanar el vostre llibre',
	'coll-not_addable' => 'No es pot afegir aquesta pàgina',
	'coll-make_suggestions' => 'Suggereix pàgines',
	'coll-make_suggestions_tooltip' => 'Mostra suggeriments basats en les pàgines del vostre llibre',
	'coll-suggest_empty' => 'buit',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'coll-bookscategory' => 'Жайнаш',
	'coll-help' => 'Нисвохаам',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'coll-print_export' => 'Tisk/export',
	'coll-create_a_book' => 'Vytvořit knihu',
	'coll-create_a_book_tooltip' => 'Vytvoření knihy nebo kolekce stránek',
	'coll-book_creator' => 'Editor knih',
	'coll-download_as' => 'Stáhnout jako $1',
	'coll-download_as_tooltip' => 'Stáhnout tuto stránku wiki jako $1',
	'coll-disable' => 'vypnout',
	'coll-book_creator_disable' => 'Vypnout editor knih',
	'coll-book_creator_disable_tooltip' => 'Přestane s používáním editoru knih',
	'coll-add_linked_article' => 'Přidat odkazovanou stránku wiki do knihy',
	'coll-remove_linked_article' => 'Odebrat odkazovanou stránku wiki z knihy',
	'coll-add_category' => 'Přidat tuto kategorii do vaší knihy',
	'coll-add_category_tooltip' => 'Přidá všechny stránky wiki v této kategorii do vaší knihy',
	'coll-add_this_page' => 'Přidat tuto stránku do vaší knihy',
	'coll-add_page_tooltip' => 'Přidá aktuální stránku wiki do vaší knihy',
	'coll-bookscategory' => 'Knihy',
	'coll-clear_collection' => 'Vyčistit knihu',
	'coll-clear_collection_confirm' => 'Skutečně chcete úplně vyčistit tuto knihu?',
	'coll-clear_collection_tooltip' => 'Odstraní z aktuální knihy všechny stránky wiki',
	'coll-help' => 'Nápověda',
	'coll-help_tooltip' => 'Zobrazit nápovědu k tvorbě knih',
	'coll-helppage' => 'Help:Knihy',
	'coll-load_collection' => 'Načíst knihu',
	'coll-load_collection_tooltip' => 'Zvolí tuto knihu jako aktuální',
	'coll-n_pages' => '$1 {{PLURAL:$1|stránka|stránky|stránek}}',
	'coll-printable_version_pdf' => 'PDF verze',
	'coll-remove_this_page' => 'Odstranit tuto stránku z vaší knihy',
	'coll-remove_page_tooltip' => 'Odstraní aktuální stránku wiki z vaší knihy',
	'coll-show_collection' => 'Zobrazit knihu',
	'coll-show_collection_tooltip' => 'Kliknutím si můžete knihu upravit/stáhnout/objednat',
	'coll-not_addable' => 'Tuto stránku nelze přidat',
	'coll-make_suggestions' => 'Doporučit stránky',
	'coll-make_suggestions_tooltip' => 'Zobrazí návrhy podle stránek přidaných do vaší knihy',
	'coll-suggest_empty' => 'prázdné',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'coll-print_export' => 'Argraffu/allforio',
	'coll-create_a_book' => 'Llunio llyfr',
	'coll-create_a_book_tooltip' => 'Llunio llyfr neu gasgliad o dudalennau',
	'coll-book_creator' => 'Lluniwr llyfrau',
	'coll-download_as' => 'Islwytho ar ffurf $1',
	'coll-download_as_tooltip' => "Islwytho fersiwn $1 o'r dudalen wici hon",
	'coll-disable' => 'anablu',
	'coll-book_creator_disable' => "Analluogi'r lluniwr llyfrau",
	'coll-book_creator_disable_tooltip' => "Rhoi'r gorau i ddefnyddio'r lluniwr llyfrau",
	'coll-add_linked_article' => 'Ychwanegu tudalen wici gysylltiedig at eich llyfr',
	'coll-remove_linked_article' => "Tynnu'r dudalen wici gysylltiedig oddi ar eich llyfr",
	'coll-add_category' => "Ychwanegu'r holl dudalennau yn y categori hwn at eich llyfr",
	'coll-add_category_tooltip' => 'Ychwanegu holl dudalennau wici y categori hwn at eich llyfr',
	'coll-add_this_page' => "Ychwanegu'r dudalen hon at eich llyfr",
	'coll-add_page_tooltip' => "Ychwanegu'r dudalen wici presennol at eich llyfr",
	'coll-bookscategory' => 'Llyfrau',
	'coll-clear_collection' => "Clirio'r llyfr",
	'coll-clear_collection_confirm' => "Ydych chi wir am glirio'ch llyfr yn llwyr?",
	'coll-clear_collection_tooltip' => "Clirio'r holl dudalennau wici o'ch llyfr presennol",
	'coll-help' => 'Cymorth',
	'coll-help_tooltip' => 'Dangos y cymorth am lunio llyfr',
	'coll-helppage' => 'Help:Llyfrau',
	'coll-load_collection' => 'Llwytho llyfr',
	'coll-load_collection_tooltip' => "Llwytho'r llyfr hwn fel eich llyfr cyfredol",
	'coll-n_pages' => '$1 {{PLURAL:$1|tudalen|dudalen|dudalen|tudalen|thudalen|o dudalennau}}',
	'coll-printable_version_pdf' => 'Fersiwn PDF',
	'coll-remove_this_page' => "Tynnu'r dudalen hon o'ch llyfr",
	'coll-remove_page_tooltip' => "Tynnu'r dudalen wici presennol o'ch llyfr",
	'coll-show_collection' => 'Dangos y llyfr',
	'coll-show_collection_tooltip' => 'Cliciwch er mwyn golygu/islwytho/archebu eich llyfr',
	'coll-not_addable' => "Ni ellir ychwanegu'r dudalen hon",
	'coll-make_suggestions' => 'Awgrymu tudalennau',
	'coll-make_suggestions_tooltip' => 'Dangos awgrymiadau wedi eu seilio ar y tudalennau yn eich llyfr',
	'coll-suggest_empty' => 'gwag',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Peter Alberti
 * @author Thomas81
 */
$messages['da'] = array(
	'coll-print_export' => 'Udskriv/eksportér',
	'coll-create_a_book' => 'Lav en bog',
	'coll-create_a_book_tooltip' => 'Lav en bog eller samling af sider',
	'coll-book_creator' => 'Bogværktøjslinien',
	'coll-download_as' => 'Download som $1',
	'coll-download_as_tooltip' => 'Download en $1-version af denne wikiside',
	'coll-disable' => 'slå fra',
	'coll-book_creator_disable' => 'Slå bogværktøjslinien fra',
	'coll-book_creator_disable_tooltip' => 'Stop brugen af bogværktøjslinien',
	'coll-add_linked_article' => 'Tilføj den linkede wikiside til din bog',
	'coll-remove_linked_article' => 'Fjern den linkede wikiside fra din bog',
	'coll-add_category' => 'Tilføj denne kategori til din bog',
	'coll-add_category_tooltip' => 'Tilføj alle wikisider i kategorien til din bog',
	'coll-add_this_page' => 'Tilføj denne side til din bog',
	'coll-add_page_tooltip' => 'Tilføj den nuværende wikiside til din bog',
	'coll-bookscategory' => 'Bøger',
	'coll-clear_collection' => 'Tøm bogen',
	'coll-clear_collection_confirm' => 'Vil du virkelig tømme din bog helt?',
	'coll-clear_collection_tooltip' => 'Fjern alle wikisider fra din nuværende bog',
	'coll-help' => 'Hjælp',
	'coll-help_tooltip' => 'Få hjælp til at lave bøger',
	'coll-helppage' => 'Help:Bøger',
	'coll-load_collection' => 'Hent bog',
	'coll-load_collection_tooltip' => 'Hent denne bog som din nuværende bog',
	'coll-n_pages' => '$1 {{PLURAL:$1|side|sider}}',
	'coll-printable_version_pdf' => 'PDF-version',
	'coll-remove_this_page' => 'Fjern denne side fra din bog',
	'coll-remove_page_tooltip' => 'Fjern den nuværende wikiside fra din bog',
	'coll-show_collection' => 'Vis bog',
	'coll-show_collection_tooltip' => 'Klik for at redigere, downloade eller bestille din bog',
	'coll-not_addable' => 'Denne side kan ikke tilføjes',
	'coll-make_suggestions' => 'Foreslå sider',
	'coll-make_suggestions_tooltip' => 'Vis forslag baseret på siderne i din bog',
	'coll-suggest_empty' => 'tom',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Pill
 * @author Umherirrender
 */
$messages['de'] = array(
	'coll-print_export' => 'Drucken/exportieren',
	'coll-create_a_book' => 'Buch erstellen',
	'coll-create_a_book_tooltip' => 'Ein Buch oder eine Artikelsammlung erstellen',
	'coll-book_creator' => 'Buchgenerator',
	'coll-download_as' => 'Als $1 herunterladen',
	'coll-download_as_tooltip' => 'Eine $1-Version dieser Wikiseite herunterladen',
	'coll-disable' => 'deaktivieren',
	'coll-book_creator_disable' => 'Buchgenerator deaktivieren',
	'coll-book_creator_disable_tooltip' => 'Buchgenerator nicht verwenden',
	'coll-add_linked_article' => 'Füge die verlinkte Wikiseite deinem Buch hinzu',
	'coll-remove_linked_article' => 'Entferne die verlinkte Wikiseite aus deinem Buch',
	'coll-add_category' => 'Alle Seiten aus dieser Kategorie deinem Buch hinzufügen',
	'coll-add_category_tooltip' => 'Alle Wikiseiten dieser Kategorie deinem Buch hinzufügen',
	'coll-add_this_page' => 'Diese Seite zu deinem Buch hinzufügen',
	'coll-add_page_tooltip' => 'Die aktuelle Wikiseite deinem Buch hinzufügen',
	'coll-bookscategory' => 'Bücher',
	'coll-clear_collection' => 'Buch löschen',
	'coll-clear_collection_confirm' => 'Möchtest du wirklich dein Buch löschen?',
	'coll-clear_collection_tooltip' => 'Alle Wikiseiten aus deinem aktuellen Buch entfernen',
	'coll-help' => 'Hilfe',
	'coll-help_tooltip' => 'Hilfe zum Erstellen von Büchern anzeigen',
	'coll-helppage' => 'Help:Bücher',
	'coll-load_collection' => 'Buch laden',
	'coll-load_collection_tooltip' => 'Dieses Buch als dein aktuelles Buch laden',
	'coll-n_pages' => '$1 {{PLURAL:$1|Wikiseite|Wikiseiten}}',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-remove_this_page' => 'Diese Seite aus deinem Buch entfernen',
	'coll-remove_page_tooltip' => 'Die aktuelle Wikiseite aus deinem Buch entfernen',
	'coll-show_collection' => 'Buch zeigen',
	'coll-show_collection_tooltip' => 'Klicken, um dein Buch zu bearbeiten/herunterzuladen/bestellen',
	'coll-not_addable' => 'Diese Seite kann nicht hinzugefügt werden',
	'coll-make_suggestions' => 'Seiten vorschlagen',
	'coll-make_suggestions_tooltip' => 'Vorschläge basierend auf den Seiten in deinem Buch anzeigen',
	'coll-suggest_empty' => 'leer',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Dst
 * @author MichaelFrey
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'coll-add_category' => 'Alle Seiten aus dieser Kategorie Ihrem Buch hinzufügen',
	'coll-add_category_tooltip' => 'Alle Wikiseiten dieser Kategorie Ihrem Buch hinzufügen',
	'coll-add_this_page' => 'Diese Seite zu Ihrem Buch hinzufügen',
	'coll-add_page_tooltip' => 'Die aktuelle Wikiseite Ihrem Buch hinzufügen',
	'coll-clear_collection_confirm' => 'Möchten Sie wirklich Ihr Buch löschen?',
	'coll-clear_collection_tooltip' => 'Alle Wikiseiten aus Ihrem aktuellen Buch entfernen',
	'coll-load_collection_tooltip' => 'Dieses Buch als Ihr aktuelles Buch laden',
	'coll-remove_this_page' => 'Diese Seite aus Ihrem Buch entfernen',
	'coll-remove_page_tooltip' => 'Die aktuelle Wikiseite aus Ihrem Buch entfernen',
	'coll-show_collection_tooltip' => 'Klicken, um Ihr Buch zu bearbeiten/herunterzuladen/bestellen',
	'coll-make_suggestions_tooltip' => 'Vorschläge basierend auf den Seiten in Ihrem Buch anzeigen',
);

/** Zazaki (Zazaki)
 * @author Xoser
 */
$messages['diq'] = array(
	'coll-print_export' => 'Çap bike/export bike',
	'coll-create_a_book' => 'Yew kitab biviraze',
	'coll-create_a_book_tooltip' => 'Yew koleksiyonê pelî ya zi kitab biviraze',
	'coll-book_creator' => 'Kitab viraştoğ',
	'coll-download_as' => 'Ze $1 bar bike',
	'coll-download_as_tooltip' => 'Yew versiyonê $1 yê ena pel bar bike',
	'coll-disable' => 'bikefilne',
	'coll-book_creator_disable' => 'Viraştoğ kitabî bikefilne',
	'coll-book_creator_disable_tooltip' => 'Viraştoğ kitabî kefilne',
	'coll-add_linked_article' => 'Kitabê xo rê cimeyê wikiyi de bike',
	'coll-remove_linked_article' => 'Kitabê xo rê cimeyê wikiyi wedarne',
	'coll-add_category' => 'Ena kategorî kitabê xo rê de bike',
	'coll-add_category_tooltip' => 'Pelê wîkîyî ena kategorî de înan kitabê xo rê de bike',
	'coll-add_this_page' => 'Ena pelê kitabê xo rê de bike',
	'coll-add_page_tooltip' => 'Pelê wîkî yê penî kitabê xo rê de bike',
	'coll-bookscategory' => 'Kitaban',
	'coll-clear_collection' => 'Kitaban wedarne',
	'coll-clear_collection_confirm' => 'Ti raştî kitabê xo wazeno wedarne?',
	'coll-clear_collection_tooltip' => 'Wîkîyanê hemî kitabê xo de wedarne',
	'coll-help' => 'Yardim',
	'coll-help_tooltip' => 'Ser bar kerdişê kitabî rê yardim bimucne',
	'coll-helppage' => 'Help:Kitaban',
	'coll-load_collection' => 'Kitab bar bike',
	'coll-load_collection_tooltip' => 'Ena kitab bar bike',
	'coll-n_pages' => '$1 {{PLURAL:$1|pel|pelan}}',
	'coll-printable_version_pdf' => 'Versiyonê PDFî',
	'coll-remove_this_page' => 'Ena pelê kitabê xo de wedarne',
	'coll-remove_page_tooltip' => 'Pelê wîkî yê penî ke kitabê tu de ey wedarne',
	'coll-show_collection' => 'Kitab bimucne',
	'coll-show_collection_tooltip' => 'Klik bike ke kitabê xo bivurne/bar bike/sipariş bike',
	'coll-not_addable' => 'Ena pel nişkeno de biyo',
	'coll-make_suggestions' => 'Pelan ke tevsiye biyê',
	'coll-make_suggestions_tooltip' => 'Ser pelan ke zerre kitabê tu de înan ra tevsiye bike',
	'coll-suggest_empty' => 'veng',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Derbeth
 * @author Michawiki
 */
$messages['dsb'] = array(
	'coll-print_export' => 'Śišćaś/eksport',
	'coll-create_a_book' => 'Knigły napóraś',
	'coll-create_a_book_tooltip' => 'Knigły abo zběrku nastawkow napóraś',
	'coll-book_creator' => 'Funkcija knigłow',
	'coll-download_as' => 'Ako $1 ześěgnuś',
	'coll-download_as_tooltip' => 'Wersiju $1 toś togo wikijowego boka ześěgnuś',
	'coll-disable' => 'znjemóžniś',
	'coll-book_creator_disable' => 'Funkciju knigłow znjemóžniś',
	'coll-book_creator_disable_tooltip' => 'Wužywanje funkcije knigłow zastajiś',
	'coll-add_linked_article' => 'Wótkazany wikibok wašim knigłam pśidaś',
	'coll-remove_linked_article' => 'Wótkazany wikibok z wašich knigłow wótpóraś',
	'coll-add_category' => 'Toś tu kategoriju twójim knigłam pśidaś',
	'coll-add_category_tooltip' => 'Wšě wikiboki w toś tej kategoriji twójim knigłam pśidaś',
	'coll-add_this_page' => 'Toś ten bok twójim knigłam pśidaś',
	'coll-add_page_tooltip' => 'Aktualny wikibok twójim knigłam pśidaś',
	'coll-bookscategory' => '{{SITENAME}}:Knigły',
	'coll-clear_collection' => 'Knigły wuprozniś',
	'coll-clear_collection_confirm' => 'Coš napšawdu swóje knigły dopołnje wuprozniś?',
	'coll-clear_collection_tooltip' => 'Wše wikiboki z twójich aktualnych knigłow wótpóraś',
	'coll-help' => 'Pomoc',
	'coll-help_tooltip' => 'Pomoc wó napóranju knigłow pokazaś',
	'coll-helppage' => 'Help:Knigły',
	'coll-load_collection' => 'Knigły zacytaś',
	'coll-load_collection_tooltip' => 'Toś te knigły ako twóje aktualne knigły zacytaś',
	'coll-n_pages' => '$1 {{PLURAL:$1|bok|boka|boki|bokow}}',
	'coll-printable_version_pdf' => 'PDF-wersija',
	'coll-remove_this_page' => 'Toś ten bok z twójich knigłow wótpóraś',
	'coll-remove_page_tooltip' => 'Aktualny wikibok z twójich knigłow wótpóraś',
	'coll-show_collection' => 'Knigły pokazaś',
	'coll-show_collection_tooltip' => 'Klikni, aby wobźěłał/ześěgnuł/skazał swóje knigły',
	'coll-not_addable' => 'Toś ten bok njedajo se pśidaś',
	'coll-make_suggestions' => 'Boki naraźiś',
	'coll-make_suggestions_tooltip' => 'Naraźenja pokazaś, kótarež bazěruju na bokach w twójich knigłach',
	'coll-suggest_empty' => 'prozny',
);

/** Greek (Ελληνικά)
 * @author Geraki
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'coll-print_export' => 'Εκτύπωση/εξαγωγή',
	'coll-create_a_book' => 'Δημιουργία βιβλίου',
	'coll-create_a_book_tooltip' => 'Δημιουργία μιας συλλογής βιβλίων ή σελίδων',
	'coll-book_creator' => 'Δημιουργός βιβλίων',
	'coll-download_as' => 'Κατέβασμα ως $1',
	'coll-download_as_tooltip' => 'Λήψη μιας $1 έκδοσης αυτής της σελίδας βίκι',
	'coll-disable' => 'απενεργοποίηση',
	'coll-book_creator_disable' => 'Απενεργοποίηση του δημιουργού βιβλίων',
	'coll-book_creator_disable_tooltip' => 'Παύση χρήσης του δημιουργού βιβλίων',
	'coll-add_linked_article' => 'Προσθήκη συνδεμένης σελίδας wiki στο βιβλίο σας',
	'coll-remove_linked_article' => 'Αφαίρεση της συνδεμένης σελίδας από το βιβλίο σας',
	'coll-add_category' => 'Προσθήκη αυτής της κατηγορίας στο βιβλίο σας',
	'coll-add_category_tooltip' => 'Προσθήκη όλων των σελίδων της συνδεδεμένης κατηγορίας στο βιβλίο σας',
	'coll-add_this_page' => 'Προσθήκη αυτής της σελίδας στο βίβλιο σας',
	'coll-add_page_tooltip' => 'Προσθήκη της παρούσας σελίδας στο βιβλίο σας',
	'coll-bookscategory' => 'Βιβλία',
	'coll-clear_collection' => 'Εκκαθάριση βιβλίου',
	'coll-clear_collection_confirm' => 'Αλήθεια θέλετε να καθαρίσετε εντελώς το βιβλίο σας;',
	'coll-clear_collection_tooltip' => 'Αφαίρεση όλων των σελίδων από το παρόν βιβλίο σας',
	'coll-help' => 'Βοήθεια',
	'coll-help_tooltip' => 'Εμφάνιση βοήθειας για τη δημιουργία βιβλίων',
	'coll-helppage' => 'Help:Βιβλία',
	'coll-load_collection' => 'Φόρτωση βιβλίου',
	'coll-load_collection_tooltip' => 'Επιφόρτωση αυτού του βιβλίου ως του τρέχοντός σας βιβλίου',
	'coll-n_pages' => '$1 {{PLURAL:$1|σελίδα|σελίδες}}',
	'coll-printable_version_pdf' => 'έκδοση PDF',
	'coll-remove_this_page' => 'Αφαίρεση αυτής της σελίδα από το βιβλίο σας',
	'coll-remove_page_tooltip' => 'Αφαίρεση της παρούσας σελίδας από το βιβλίο σας',
	'coll-show_collection' => 'Εμφάνιση βιβλίου',
	'coll-show_collection_tooltip' => 'Κάνετε κλικ για να επεξεργαστείτε/κατεβάσετε/παραγγείλετε το βιβλίο σας',
	'coll-not_addable' => 'Αυτή η σελίδα δεν μπορεί να προτεθεί',
	'coll-make_suggestions' => 'Πρόταση σελίδων',
	'coll-make_suggestions_tooltip' => 'Προβολή υποδείξεων βασισμένων πάνω στις σελίδες μέσα στο βιβλίο σας',
	'coll-suggest_empty' => 'άδειο',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'coll-print_export' => 'Printi/eksporti',
	'coll-create_a_book' => 'Krei libron',
	'coll-create_a_book_tooltip' => 'Krei libran aŭ paĝan kolekton',
	'coll-book_creator' => 'Libra kreilo',
	'coll-download_as' => 'Elŝuti kiel $1',
	'coll-download_as_tooltip' => 'Elŝuti $1-version de ĉi tiu vikia paĝo',
	'coll-disable' => 'malŝalti',
	'coll-book_creator_disable' => 'Malŝalti libran kreilon',
	'coll-book_creator_disable_tooltip' => 'Halti uzante la libran kreilon',
	'coll-add_linked_article' => 'Aldoni ligitan vikipaĝon al via libro',
	'coll-remove_linked_article' => 'Forigi ligitan vikipaĝon de via libro',
	'coll-add_category' => 'Aldoni ĉi tiun kategorion al via libro',
	'coll-add_category_tooltip' => 'Aldoni ĉiujn vikiajn paĝojn en ĉi tiu kategorio al via libro',
	'coll-add_this_page' => 'Aldoni ĉi tiun paĝon al via libro',
	'coll-add_page_tooltip' => 'Aldoni la nunan vikian paĝon al via libro',
	'coll-bookscategory' => 'Libroj',
	'coll-clear_collection' => 'Forviŝi libron',
	'coll-clear_collection_confirm' => 'Ĉu vi ja volas plene forviŝi vian libron?',
	'coll-clear_collection_tooltip' => 'Forigi ĉiujn vikiajn paĝojn de via nuna libro',
	'coll-help' => 'Helpo',
	'coll-help_tooltip' => 'Montri helpon pri kreante librojn',
	'coll-helppage' => 'Help:Libroj',
	'coll-load_collection' => 'Alŝuti libron',
	'coll-load_collection_tooltip' => 'Ŝarĝi ĉi tiun libron kiel vian nunan libron',
	'coll-n_pages' => '$1 {{PLURAL:$1|paĝo|paĝoj}}',
	'coll-printable_version_pdf' => 'PDF-versio',
	'coll-remove_this_page' => 'Forigi ĉi tiun paĝon de via libro',
	'coll-remove_page_tooltip' => 'Forigi la nunan vikian paĝon de via libro',
	'coll-show_collection' => 'Montri libron',
	'coll-show_collection_tooltip' => 'Klaku redakti/elŝuti/mendi vian libron',
	'coll-not_addable' => 'Ĉi tiu paĝo ne povas esti aldonata.',
	'coll-make_suggestions' => 'Sugesti paĝojn',
	'coll-make_suggestions_tooltip' => 'Montri sugestojn bazitajn de la paĝoj en via libro',
	'coll-suggest_empty' => 'malplena',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Locos epraix
 * @author Mor
 * @author Omnipaedista
 * @author Remember the dot
 * @author Sanbec
 */
$messages['es'] = array(
	'coll-print_export' => 'Imprimir/exportar',
	'coll-create_a_book' => 'Crear un libro',
	'coll-create_a_book_tooltip' => 'Crear un libro o colección de página',
	'coll-book_creator' => 'Creador de libro',
	'coll-download_as' => 'Descargar como $1',
	'coll-download_as_tooltip' => 'Descargar una versión $1 de esta página wiki',
	'coll-disable' => 'deshabilitar',
	'coll-book_creator_disable' => 'Deshabilitar creador de libro',
	'coll-book_creator_disable_tooltip' => 'Dejar de usar el creador de libro',
	'coll-add_linked_article' => 'Agregar página wiki vinculada a tu libro',
	'coll-remove_linked_article' => 'Eliminar página wiki vinculada de tu libro',
	'coll-add_category' => 'Añadir esta categoría a tu libro',
	'coll-add_category_tooltip' => 'Agregar todas las páginas wiki en esta categoría a tu libro',
	'coll-add_this_page' => 'Añadir esta página a su libro',
	'coll-add_page_tooltip' => 'Agregar la página wiki actual a tu libro',
	'coll-bookscategory' => 'Libros',
	'coll-clear_collection' => 'Vaciar libro',
	'coll-clear_collection_confirm' => '¿Realmente quieres borrar completamente tu libro?',
	'coll-clear_collection_tooltip' => 'Quitar todas las páginas wiki de su libro actual',
	'coll-help' => 'Ayuda',
	'coll-help_tooltip' => 'Mostrar ayuda acerca de la creación de libros',
	'coll-helppage' => 'Help:Libros',
	'coll-load_collection' => 'Cargar libro',
	'coll-load_collection_tooltip' => 'Cargar este libro como su libro actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'coll-printable_version_pdf' => 'Versión PDF',
	'coll-remove_this_page' => 'Quitar esta página de tu libro',
	'coll-remove_page_tooltip' => 'Quitar la página wiki actual de tu libro',
	'coll-show_collection' => 'Mostrar libro',
	'coll-show_collection_tooltip' => 'Haz click para editar/descargar/ordenar tu libro',
	'coll-not_addable' => 'esta página no puede ser agregada',
	'coll-make_suggestions' => 'Sugerir páginas',
	'coll-make_suggestions_tooltip' => 'Mostrar sugerencias basadas en las páginas de su libro',
	'coll-suggest_empty' => 'vacío',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'coll-print_export' => 'Trüki või ekspordi',
	'coll-create_a_book' => 'Loo raamat',
	'coll-create_a_book_tooltip' => 'Loo raamat või lehekülgede kogu',
	'coll-book_creator' => 'Raamatulooja',
	'coll-download_as' => 'Laadi alla $1-failina',
	'coll-download_as_tooltip' => 'Laadi see lehekülg alla $1-vormingus',
	'coll-disable' => 'keela',
	'coll-book_creator_disable' => 'Keela raamatulooja',
	'coll-book_creator_disable_tooltip' => 'Lõpeta raamatulooja kasutamine',
	'coll-add_linked_article' => 'Lisa lingitud lehekülg oma raamatusse',
	'coll-remove_linked_article' => 'Eemalda lingitud lehekülg oma raamatust',
	'coll-add_category' => 'Lisa see kategooria oma raamatusse',
	'coll-add_category_tooltip' => 'Lisa kõik selle kategooria vikileheküljed loodavasse raamatusse',
	'coll-add_this_page' => 'Lisa see lehekülg oma raamatusse',
	'coll-add_page_tooltip' => 'Lisa käesolev lehekülg loodavasse raamatusse',
	'coll-bookscategory' => 'Raamatud',
	'coll-clear_collection' => 'Tühjenda raamat',
	'coll-clear_collection_confirm' => 'Kas soovid tõesti kogu raamatu tühjendada?',
	'coll-clear_collection_tooltip' => 'Võta kõik leheküljed loodavast raamatust välja',
	'coll-help' => 'Abi',
	'coll-help_tooltip' => 'Näita raamatu loomise abi',
	'coll-helppage' => 'Help:Raamatud',
	'coll-load_collection' => 'Lae raamat',
	'coll-load_collection_tooltip' => 'Laadi see raamat praeguse raamatuna',
	'coll-n_pages' => '$1 {{PLURAL:$1|lehekülg|lehekülge}}',
	'coll-printable_version_pdf' => 'PDF-versioon',
	'coll-remove_this_page' => 'Eemalda see lehekülg oma raamatust',
	'coll-remove_page_tooltip' => 'Võta käesolev lehekülg loodavast raamatust välja',
	'coll-show_collection' => 'Näita raamatut',
	'coll-show_collection_tooltip' => 'Redigeeri, laadi alla või telli',
	'coll-not_addable' => 'Seda lehekülge ei saa lisada',
	'coll-make_suggestions' => 'Paku lehekülgi',
	'coll-make_suggestions_tooltip' => 'Näitab raamatusse lisatud lehekülgedel põhinevaid soovitusi',
	'coll-suggest_empty' => 'tühi',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Theklan
 */
$messages['eu'] = array(
	'coll-print_export' => 'Inprimatu/esportatu',
	'coll-create_a_book' => 'Liburu bat sortu',
	'coll-create_a_book_tooltip' => 'Sortu liburu edo orrialde bilduma bat',
	'coll-book_creator' => 'Liburu sortzailea',
	'coll-download_as' => '$1 gisa jaitsi',
	'coll-download_as_tooltip' => 'Jaitsi wiki orrialde honen $1 bertsioa',
	'coll-disable' => 'ezgaitu',
	'coll-book_creator_disable' => 'Ezgaitu liburu sortzailea',
	'coll-book_creator_disable_tooltip' => 'Utzi liburu sortzailea erabiltzeari',
	'coll-add_linked_article' => 'Gehitu lotutako wiki orrialdea zure liburuan',
	'coll-remove_linked_article' => 'Ezabatu lotutako wiki orrialdea zure liburutik',
	'coll-add_category' => 'Kategoria hau gehitu zure liburura gehitu',
	'coll-add_category_tooltip' => 'Gehitu kategoria honetako orrialde guztiak zure liburura',
	'coll-add_this_page' => 'Gehitu orrialde hau zure liburura',
	'coll-add_page_tooltip' => 'Gehitu orrialde hau zure liburura',
	'coll-bookscategory' => 'Liburuak',
	'coll-clear_collection' => 'Liburua ezabatu',
	'coll-clear_collection_confirm' => 'Benetan ezabatu nahi al duzu zure liburu osoa?',
	'coll-clear_collection_tooltip' => 'Kendu wiki orrialde guztiak zure liburutik',
	'coll-help' => 'Laguntza',
	'coll-help_tooltip' => 'Eraktusi liburu sorrerarako laguntza',
	'coll-helppage' => 'Help:Liburuak',
	'coll-load_collection' => 'Liburua kargatu',
	'coll-load_collection_tooltip' => 'Liburu hau kargatu zure liburu gisa',
	'coll-n_pages' => '{{PLURAL:$1|Orrialde 1|$1 orrialde}}',
	'coll-printable_version_pdf' => 'PDF bertsioa',
	'coll-remove_this_page' => 'Kendu orrialde hau zure liburutik',
	'coll-remove_page_tooltip' => 'Kendu orrialde hau zure liburutik',
	'coll-show_collection' => 'Liburua erakutsi',
	'coll-show_collection_tooltip' => 'Zure liburua editatzeko/deskargatzeko/eskatzeko egizu klik',
	'coll-not_addable' => 'Orrialde hau ezin da gehitu',
	'coll-make_suggestions' => 'Orrialdeak proposatu',
	'coll-make_suggestions_tooltip' => 'Erakutsi gomendioak liburu honetako orrialdeak kontuan izanda',
	'coll-suggest_empty' => 'hutsik',
);

/** Persian (فارسی)
 * @author Bersam
 * @author Ebraminio
 * @author Huji
 * @author Komeil 4life
 * @author Ladsgroup
 * @author MehranVB
 * @author Wayiran
 * @author محک
 */
$messages['fa'] = array(
	'coll-print_export' => 'چاپ/برون‌ریزی',
	'coll-create_a_book' => 'ایجاد کتاب',
	'coll-create_a_book_tooltip' => 'یک کتاب یا مجموعه صفحات ایجاد کن',
	'coll-book_creator' => 'کتاب‌ساز',
	'coll-download_as' => 'بارگیری به‌صورت $1',
	'coll-download_as_tooltip' => 'یک نسخهٔ $1 از این صفحهٔ ویکی را بارگیری کن',
	'coll-disable' => 'غیرفعال',
	'coll-book_creator_disable' => 'کتاب‌ساز را غیرفعال کن',
	'coll-book_creator_disable_tooltip' => 'استفاده از کتاب‌ساز را متوقف کنید',
	'coll-add_linked_article' => 'صفحهٔ ویکی پیونددهی‌شده را به کتابتان اضافه کنید',
	'coll-remove_linked_article' => 'صفحهٔ ویکی پیونددهی‌شده را از کتابتان حذف کنید',
	'coll-add_category' => 'این رده را به کتابتان بیفزایید',
	'coll-add_category_tooltip' => 'همهٔ صفحات ویکی در این رده را به کتابتان بیفزایید',
	'coll-add_this_page' => 'این صفحه را به کتاب‌تان بیفزایید',
	'coll-add_page_tooltip' => 'صفحهٔ فعلی ویکی به کتابتان اضافه شود',
	'coll-bookscategory' => 'کتاب‌های کاربران ویکی‌پدیا',
	'coll-clear_collection' => 'پاک کردن کتاب',
	'coll-clear_collection_confirm' => 'آیا واقعاً می‌خواهید که کتاب خود را به طور کامل پاک کنید؟',
	'coll-clear_collection_tooltip' => 'همهٔ صفحات ویکی را از کتاب فعلیتان حذف کنید',
	'coll-help' => 'راهنما',
	'coll-help_tooltip' => 'راهنمای ایجاد کتاب‌ها را نشان بده',
	'coll-helppage' => 'Help:کتاب‌ها',
	'coll-load_collection' => 'بارکردن کتاب',
	'coll-load_collection_tooltip' => 'این کتاب را به عنوان کتاب فعلی بارگذاری کنید',
	'coll-n_pages' => '$1 {{PLURAL:$1|صفحه|صفحه}}',
	'coll-printable_version_pdf' => 'نسخهٔ پی‌دی‌اف',
	'coll-remove_this_page' => 'این صفحه را از کتابتان حذف کنید',
	'coll-remove_page_tooltip' => 'صفحهٔ ویکی کنونی را از کتابتان حذف کنید',
	'coll-show_collection' => 'نمایش کتاب',
	'coll-show_collection_tooltip' => 'برای ویرایش/بارگیری/سفارش کتاب خود کلیک کنید',
	'coll-not_addable' => 'این صفحه نمی‌تواند اضافه شود',
	'coll-make_suggestions' => 'پیشنهاد صفحات',
	'coll-make_suggestions_tooltip' => 'نمایش پیشنهادات را بر پایهٔ صفحات کتابتان',
	'coll-suggest_empty' => 'خالی',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Olli
 * @author Str4nd
 * @author Zache
 */
$messages['fi'] = array(
	'coll-print_export' => 'Tulosta tai vie',
	'coll-create_a_book' => 'Luo kirja',
	'coll-create_a_book_tooltip' => 'Luo kirja tai sivukokoelma',
	'coll-book_creator' => 'Kirjan luontitila',
	'coll-download_as' => 'Lataa $1-tiedostona',
	'coll-download_as_tooltip' => 'Lataa tämä wikisivu $1-muodossa',
	'coll-disable' => 'poista käytöstä',
	'coll-book_creator_disable' => 'Poista kirjan luontitila käytöstä',
	'coll-book_creator_disable_tooltip' => 'Lopeta kirjan luontitila',
	'coll-add_linked_article' => 'Lisää linkitetty wikisivu kirjaan',
	'coll-remove_linked_article' => 'Poista linkitetty wikisivu kirjastasi',
	'coll-add_category' => 'Lisää tämä luokka kirjaasi',
	'coll-add_category_tooltip' => 'Lisää kaikki wikisivut kirjaasi tästä luokasta',
	'coll-add_this_page' => 'Lisää tämä sivu kirjaasi',
	'coll-add_page_tooltip' => 'Lisää nykyinen wikisivu kirjaasi',
	'coll-bookscategory' => 'Kirjat',
	'coll-clear_collection' => 'Tyhjennä kirja',
	'coll-clear_collection_confirm' => 'Haluatko varmasti tyhjentää kirjasi?',
	'coll-clear_collection_tooltip' => 'Poista kaikki wikisivut nykyisestä kirjastasi',
	'coll-help' => 'Ohje',
	'coll-help_tooltip' => 'Näytä ohje kirjojen luonnista',
	'coll-helppage' => 'Help:Kirjat',
	'coll-load_collection' => 'Avaa kirja',
	'coll-load_collection_tooltip' => 'Avaa tämä kirja nykyiseksi kirjaksesi',
	'coll-n_pages' => '$1 {{PLURAL:$1|sivu|sivua}}',
	'coll-printable_version_pdf' => 'PDF-versio',
	'coll-remove_this_page' => 'Poista tämä sivu kirjastasi',
	'coll-remove_page_tooltip' => 'Poista nykyinen wikisivu kirjastasi',
	'coll-show_collection' => 'Näytä kirja',
	'coll-show_collection_tooltip' => 'Napsauta muokataksesi, ladataksesi tai tilataksesi kirjasi',
	'coll-not_addable' => 'Tätä sivua ei voi lisätä',
	'coll-make_suggestions' => 'Ehdotetut sivut',
	'coll-make_suggestions_tooltip' => 'Näytä ehdotukset, jotka perustuvat kirjan sivuihin',
	'coll-suggest_empty' => 'tyhjä',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author Guillom
 * @author IAlex
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Meithal
 * @author PieRRoMaN
 * @author Verdy p
 */
$messages['fr'] = array(
	'coll-print_export' => 'Imprimer / exporter',
	'coll-create_a_book' => 'Créer un livre',
	'coll-create_a_book_tooltip' => 'Créer un livre ou une collection d’articles',
	'coll-book_creator' => 'Créateur de livres',
	'coll-download_as' => 'Télécharger comme $1',
	'coll-download_as_tooltip' => 'Télécharge une version $1 de cette page wiki',
	'coll-disable' => 'désactiver',
	'coll-book_creator_disable' => 'Désactiver le créateur de livre',
	'coll-book_creator_disable_tooltip' => 'Cesser d’utiliser le créateur de livre',
	'coll-add_linked_article' => 'Ajouter la page wiki liée à votre livre',
	'coll-remove_linked_article' => 'Enlever la page wiki liée de votre livre',
	'coll-add_category' => 'Ajouter cette catégorie à votre livre',
	'coll-add_category_tooltip' => 'Ajouter tous les articles de cette catégorie à votre livre',
	'coll-add_this_page' => 'Ajouter cette page à votre livre',
	'coll-add_page_tooltip' => 'Ajouter la page courante à votre livre',
	'coll-bookscategory' => 'Livres',
	'coll-clear_collection' => 'Vider le livre',
	'coll-clear_collection_confirm' => 'Voulez-vous réellement effacer l’intégralité de votre livre ?',
	'coll-clear_collection_tooltip' => 'Enlever tous les articles de votre livre actuel',
	'coll-help' => 'Aide',
	'coll-help_tooltip' => 'Afficher l’aide sur la création de livres',
	'coll-helppage' => 'Help:Livres',
	'coll-load_collection' => 'Charger un livre',
	'coll-load_collection_tooltip' => 'Charger ce livre en tant que votre livre actuel',
	'coll-n_pages' => '$1 page{{PLURAL:$1||s}}',
	'coll-printable_version_pdf' => 'Version PDF',
	'coll-remove_this_page' => 'Retirer cette page de votre livre',
	'coll-remove_page_tooltip' => 'Retirer la page courante de votre livre',
	'coll-show_collection' => 'Afficher le livre',
	'coll-show_collection_tooltip' => 'Cliquez pour modifier / télécharger / commander votre livre',
	'coll-not_addable' => 'Cette page ne peut pas être ajoutée',
	'coll-make_suggestions' => 'Suggérer des pages',
	'coll-make_suggestions_tooltip' => 'Montrer les suggestions fondées sur les pages dans votre livre',
	'coll-suggest_empty' => 'vide',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'coll-print_export' => 'Emprimar / èxportar',
	'coll-create_a_book' => 'Fâre un lévro',
	'coll-create_a_book_tooltip' => 'Fâre un lévro ou ben una colèccion de pâges',
	'coll-book_creator' => 'Crèator de lévros',
	'coll-download_as' => 'Tèlèchargiér coment $1',
	'coll-download_as_tooltip' => 'Tèlècharge una vèrsion $1 de ceta pâge vouiqui.',
	'coll-disable' => 'dèsactivar',
	'coll-book_creator_disable' => 'Dèsactivar lo crèator de lévro',
	'coll-book_creator_disable_tooltip' => 'Quitar d’utilisar lo crèator de lévro',
	'coll-add_linked_article' => 'Apondre la pâge vouiqui liyê a voutron lévro',
	'coll-remove_linked_article' => 'Enlevar la pâge vouiqui liyê de voutron lévro',
	'coll-add_category' => 'Apondre ceta catègorie a voutron lévro',
	'coll-add_category_tooltip' => 'Apondre totes les pâges vouiqui de ceta catègorie a voutron lévro',
	'coll-add_this_page' => 'Apondre ceta pâge a voutron lévro',
	'coll-add_page_tooltip' => 'Apondre la pâge vouiqui d’ora a voutron lévro',
	'coll-bookscategory' => 'Lévros',
	'coll-clear_collection' => 'Vouedar lo lévro',
	'coll-clear_collection_confirm' => 'Voléd-vos franc èfaciér tot voutron lévro ?',
	'coll-clear_collection_tooltip' => 'Enlevar totes les pâges vouiqui de voutron lévro d’ora',
	'coll-help' => 'Éde',
	'coll-help_tooltip' => 'Fâre vêre l’éde sur la crèacion de lévros',
	'coll-helppage' => 'Help:Lévros',
	'coll-load_collection' => 'Chargiér un lévro',
	'coll-load_collection_tooltip' => 'Chargiér ceti lévro coment voutron lévro d’ora',
	'coll-n_pages' => '$1 pâge{{PLURAL:$1||s}}',
	'coll-printable_version_pdf' => 'Vèrsion PDF',
	'coll-remove_this_page' => 'Enlevar ceta pâge de voutron lévro',
	'coll-remove_page_tooltip' => 'Enlevar la pâge vouiqui d’ora de voutron lévro',
	'coll-show_collection' => 'Fâre vêre lo lévro',
	'coll-show_collection_tooltip' => 'Clicâd por changiér / tèlèchargiér / comandar voutron lévro.',
	'coll-not_addable' => 'Ceta pâge pôt pas étre apondua',
	'coll-make_suggestions' => 'Conselyér des pâges',
	'coll-make_suggestions_tooltip' => 'Montrar los consèlys basâs sur les pâges dens voutron lévro',
	'coll-suggest_empty' => 'vouedo',
);

/** Scottish Gaelic (Gàidhlig)
 * @author Akerbeltz
 */
$messages['gd'] = array(
	'coll-print_export' => 'Clò-bhuail/às-phortaich',
	'coll-create_a_book' => 'Cruthaich leabhar',
	'coll-create_a_book_tooltip' => 'Cruthaich leabhar no cruinneachadh dhuilleagan',
	'coll-book_creator' => 'Cruthadair leabhraichean',
	'coll-download_as' => 'Luchdaich a-nuas mar $1',
	'coll-download_as_tooltip' => 'Luchdaich a-nuas tionndadh $1 dhen duilleag uici seo',
	'coll-disable' => 'cuir à comas',
	'coll-book_creator_disable' => 'Cuir cruthadair nan leabhraichean à comas',
	'coll-book_creator_disable_tooltip' => 'Sguir de chleachdadh cruthadair nan leabhraichean',
	'coll-add_linked_article' => 'Cuir duilleag uici le ceanglaichean ris an leabhar agad',
	'coll-remove_linked_article' => 'Thoir air falbh duilleag uici le ceanglaichean on leabhar agad',
	'coll-add_category' => 'Cuir an roinn-seòrsa ris an leabhar agad',
	'coll-add_category_tooltip' => 'Cuir gach duilleag uici san roinn-seòrsa seo ris an leabhar agad',
	'coll-add_this_page' => 'Cuir an duilleag seo ris an leabhar agad',
	'coll-add_page_tooltip' => 'Cuir an duilleag uici làithreach ris an leabhar agad',
	'coll-bookscategory' => 'Leabhraichean',
	'coll-clear_collection' => 'Falamhaich an leabhar',
	'coll-clear_collection_confirm' => 'A bheil thu cinnteach gu bheil thu airson an leabhar gu lèir fhalamhachadh?',
	'coll-clear_collection_tooltip' => 'Thoir air falbh gach duilleag uici on leabhar làithreach agad',
	'coll-help' => 'Cobhair',
	'coll-help_tooltip' => "Seall a' chobhair mu chruthachadh leabhraichean",
	'coll-helppage' => 'Help:Leabhraichean',
	'coll-load_collection' => 'Luchdaich leabhar',
	'coll-load_collection_tooltip' => 'Luchdaich an leabhar seo mar an leabhar làithreach agad',
	'coll-n_pages' => '$1 {{PLURAL:$1|duilleag|dhuilleag|duilleag|dhuilleag|duilleagan|duilleag}}',
	'coll-printable_version_pdf' => 'Tionndadh PDF',
	'coll-remove_this_page' => 'Thoir an duilleag seo às an leabhar agad',
	'coll-remove_page_tooltip' => 'Thoir air falbh duilleag uici seo on leabhar agad',
	'coll-show_collection' => 'Seall an leabhar',
	'coll-show_collection_tooltip' => 'Dèan briogadh gus an leabhar agad a dheasachadh, a luchdadh a-nuas no òrdugh a chur',
	'coll-not_addable' => 'Cha ghabh an duilleag seo a chur ris',
	'coll-make_suggestions' => 'Mol duilleagan',
	'coll-make_suggestions_tooltip' => 'Seall molaidhean a-rèir nan duilleagan san leabhar agad',
	'coll-suggest_empty' => 'falamh',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'coll-print_export' => 'Imprimir/exportar',
	'coll-create_a_book' => 'Crear un libro',
	'coll-create_a_book_tooltip' => 'Crear un libro ou unha colección de páxinas',
	'coll-book_creator' => 'Creador de libros',
	'coll-download_as' => 'Descargar como $1',
	'coll-download_as_tooltip' => 'Descargar unha versión en formato $1 desta páxina wiki',
	'coll-disable' => 'desactivar',
	'coll-book_creator_disable' => 'Desactivar o creador de libros',
	'coll-book_creator_disable_tooltip' => 'Deixar de usar o creador de libros',
	'coll-add_linked_article' => 'Engadir a páxina wiki ligada ao seu libro',
	'coll-remove_linked_article' => 'Eliminar a páxina wiki ligada do seu libro',
	'coll-add_category' => 'Engadir esta categoría ao seu libro',
	'coll-add_category_tooltip' => 'Engadir todas as páxinas wiki desta categoría ao seu libro',
	'coll-add_this_page' => 'Engadir esta páxina ao seu libro',
	'coll-add_page_tooltip' => 'Engadir a páxina wiki actual ao seu libro',
	'coll-bookscategory' => 'Libros',
	'coll-clear_collection' => 'Borrar o libro',
	'coll-clear_collection_confirm' => 'Realmente quere eliminar por completo o seu libro?',
	'coll-clear_collection_tooltip' => 'Eliminar todas as páxinas wiki do seu libro actual',
	'coll-help' => 'Axuda',
	'coll-help_tooltip' => 'Mostrar a axuda sobre a creación de libros',
	'coll-helppage' => 'Help:Libros',
	'coll-load_collection' => 'Cargar un libro',
	'coll-load_collection_tooltip' => 'Cargar este libro como o seu libro actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|páxina|páxinas}}',
	'coll-printable_version_pdf' => 'Versión PDF',
	'coll-remove_this_page' => 'Eliminar esta páxina do seu libro',
	'coll-remove_page_tooltip' => 'Eliminar a páxina wiki actual do seu libro',
	'coll-show_collection' => 'Mostrar o libro',
	'coll-show_collection_tooltip' => 'Prema para editar/descargar/pedir o seu libro',
	'coll-not_addable' => 'Esta páxina non se pode engadir',
	'coll-make_suggestions' => 'Suxerir as páxinas',
	'coll-make_suggestions_tooltip' => 'Mostrar as suxestións baseadas nas páxinas do seu libro',
	'coll-suggest_empty' => 'baleiro',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'coll-download_as' => 'Καταφορτίζειν ὡς $1',
	'coll-add_category' => 'Προστιθέναι κατηγορίαν εἰς τὸ βιβλίον σου',
	'coll-bookscategory' => 'Βιβλία',
	'coll-help' => 'Βοήθεια',
	'coll-printable_version_pdf' => 'Ἔκδοσις PDF',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'coll-print_export' => 'Drucke/exportiere',
	'coll-create_a_book' => 'Buech aalege',
	'coll-create_a_book_tooltip' => 'E Buech oder e Artikelsammlig aalege',
	'coll-book_creator' => 'Buechgenerator',
	'coll-download_as' => 'As $1 abelade',
	'coll-download_as_tooltip' => 'E $1-Version vu däre Wikisyte abelade',
	'coll-disable' => 'deaktiviere',
	'coll-book_creator_disable' => 'Buechgenerator deaktiviere',
	'coll-book_creator_disable_tooltip' => 'Buechgenerator nit bruche',
	'coll-add_linked_article' => 'Fieg e vergleichti Wikisyte in Dyy Buech yy',
	'coll-remove_linked_article' => 'Nimm e vergleichti Wikisyte us Dyym Buech uuse',
	'coll-add_category' => 'Die Kategorii zue Dyym Buech dezuefiege',
	'coll-add_category_tooltip' => 'Alli Wikisyte in däre Kategorii in Dyy Buech yyfiege',
	'coll-add_this_page' => 'Die Syte zue Dyym Buech zuefiege',
	'coll-add_page_tooltip' => 'Di aktuäll Wikisyte zue Dyynem Buech zuefiege',
	'coll-bookscategory' => 'Buechfunktion',
	'coll-clear_collection' => 'Buech lesche',
	'coll-clear_collection_confirm' => 'Mechtsch Dyy Buech ächt lesche?',
	'coll-clear_collection_tooltip' => 'Alli Wikisyte us Dyynem aktuälle Buech useneh',
	'coll-help' => 'Hilf',
	'coll-help_tooltip' => 'Hilf zum Aalege vu Biecher aazeige',
	'coll-helppage' => 'Help:Biecher',
	'coll-load_collection' => 'Buech lade',
	'coll-load_collection_tooltip' => 'Des Buech as Dyy aktuäll Buech lade',
	'coll-n_pages' => '$1 {{PLURAL:$1|Syte|Syte}}',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-remove_this_page' => 'Die Syte us Dyym Buech useneh',
	'coll-remove_page_tooltip' => 'Di aktuäll Wikisyte us Dyynem Buech uuseneh',
	'coll-show_collection' => 'Buech zeige',
	'coll-show_collection_tooltip' => 'Druck do go Dyy Buech bearbeite/abelade/bstelle',
	'coll-not_addable' => 'Die Syte het nit chenne zuegfiegt wäre',
	'coll-make_suggestions' => 'Syte vorschlaa',
	'coll-make_suggestions_tooltip' => 'Vorschleg zeige, wu uf dr Syte in Dyym Buech basiere',
	'coll-suggest_empty' => 'läär',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 * @author Dsvyas
 * @author Sushant savla
 */
$messages['gu'] = array(
	'coll-print_export' => 'છાપો/નિકાસ',
	'coll-create_a_book' => 'પુસ્તક બનાવો',
	'coll-create_a_book_tooltip' => 'પુસ્તક અથવા પાનાં સંગ્રહ બનાવો',
	'coll-book_creator' => 'પુસ્તક નિર્માતા',
	'coll-download_as' => '$1 તરીકે ડાઉનલોડ કરો',
	'coll-download_as_tooltip' => 'આ વિકિ પાનાની $1 આવૃત્તિ ડાઉનલોડ કરો',
	'coll-disable' => 'નિષ્ક્રિય',
	'coll-book_creator_disable' => 'પુસ્તક નિર્માતા નિષ્ક્રિય કરો',
	'coll-book_creator_disable_tooltip' => 'પુસ્તક નિર્માતા વાપરવાનું બંધ કરો',
	'coll-add_linked_article' => 'સંકળાયેલું વિકિ પાનું તમારા પુસ્તકમાં ઉમેરો',
	'coll-remove_linked_article' => 'સંકળાયેલું વિકિ પાનું તમારા પુસ્તકમાંથી કાઢી નાંખો',
	'coll-add_category' => 'આ શ્રેણી તમારા પુસ્તકમાં ઉમેરો',
	'coll-add_category_tooltip' => 'આ શ્રેણીનાં બધા વિકિ પાનાં તમારા પુસ્તકમાં ઉમેરો',
	'coll-add_this_page' => 'આ પાનું તમારા પુસ્તકમાં ઉમેરો',
	'coll-add_page_tooltip' => 'આ પ્રસ્તુત વિકિ પાનું તમારા પુસ્તકમાં ઉમેરો',
	'coll-bookscategory' => 'પુસ્તકો',
	'coll-clear_collection' => 'પુસ્તક સાફ કરો',
	'coll-clear_collection_confirm' => 'તમે ખરેખર તમારું પુસ્તક સંપૂર્ણપણે સાફ કરવા માંગો છો?',
	'coll-clear_collection_tooltip' => 'તમારા પ્રસ્તુત પુસ્તકમાંથી બધા વિકિ પાનાં દૂર કરો',
	'coll-help' => 'મદદ',
	'coll-help_tooltip' => 'પુસ્તક બનાવવા વિષયક મદદ દર્શાવો',
	'coll-helppage' => 'મદદ:પુસ્તકો',
	'coll-load_collection' => 'પુસ્તક લાદો',
	'coll-load_collection_tooltip' => 'આ પુસ્તકને તમારા પ્રસ્તુત તરીકે લાદો',
	'coll-n_pages' => '$1 {{PLURAL:$1|પાનું|પાના}}',
	'coll-printable_version_pdf' => 'PDF સંસ્કરણ',
	'coll-remove_this_page' => 'આ પાનું તમારા પુસ્તકમાંથી કાઢી નાખો',
	'coll-remove_page_tooltip' => 'પ્રસ્તુત વિકિ પાનું તમારા પુસ્તકમાંથી કાઢી નાંખો',
	'coll-show_collection' => 'પુસ્તક બતાવો',
	'coll-show_collection_tooltip' => 'તમારા પુસ્તકમાં ફેરફાર/ડાઉનલોડ/ફરમાયશ કરવા ક્લિક કરો',
	'coll-not_addable' => 'આ પાનું ઉમેરી શકાશે નહી',
	'coll-make_suggestions' => 'પાનાં સુચવો',
	'coll-make_suggestions_tooltip' => 'તમારા પુસ્તકમાં રહેલા પાનાંને આધારે સુઝાવ બતાવો',
	'coll-suggest_empty' => 'ખાલી',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'coll-create_a_book' => 'My haglym',
	'coll-helppage' => 'Help:Lioaryn',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'coll-print_export' => 'הדפסה/יצוא',
	'coll-create_a_book' => 'יצירת ספר',
	'coll-create_a_book_tooltip' => 'יצירת ספר או אוסף דפים',
	'coll-book_creator' => 'מצב ספר',
	'coll-download_as' => 'הורדה כ־$1',
	'coll-download_as_tooltip' => 'הורדת גרסת $1 של דף ויקי זה',
	'coll-disable' => 'ביטול',
	'coll-book_creator_disable' => 'ביטול מצב ספר',
	'coll-book_creator_disable_tooltip' => 'הפסקת השימוש ביוצר הספרים',
	'coll-add_linked_article' => 'הוספת עמוד ויקי מקושר לספר שלך',
	'coll-remove_linked_article' => 'הסרת עמוד ויקי מקושר מהספר שלך',
	'coll-add_category' => 'הוספת קטגוריה זו לספר שלכם',
	'coll-add_category_tooltip' => 'הוספת כל הדפים בקטגוריה זו לספר שלכם',
	'coll-add_this_page' => 'הוספת דף זה לספר שלכם',
	'coll-add_page_tooltip' => 'הוספת דף הוויקי הנוכחי לספר שלכם',
	'coll-bookscategory' => 'ספרים',
	'coll-clear_collection' => 'ניקוי הספר',
	'coll-clear_collection_confirm' => 'האם אתם בטוחים שברצונכם לנקות לגמרי את הספר שלכם?',
	'coll-clear_collection_tooltip' => 'הסרת כל הדפים מהספר הנוכחי שלך',
	'coll-help' => 'עזרה',
	'coll-help_tooltip' => 'הצגת עזרה על יצירת ספרים',
	'coll-helppage' => 'Help:ספרים',
	'coll-load_collection' => 'טעינת ספר',
	'coll-load_collection_tooltip' => 'טעינת הספר הזה כספר הנוכחי שלך',
	'coll-n_pages' => '{{PLURAL:$1|דף אחד|$1 דפים}}',
	'coll-printable_version_pdf' => 'גרסת PDF',
	'coll-remove_this_page' => 'הסרת דף זה מהספר שלכם',
	'coll-remove_page_tooltip' => 'הסרת דף הוויקי הנוכחי מהספר שלך',
	'coll-show_collection' => 'הצגת ספר',
	'coll-show_collection_tooltip' => 'עריכת/הורדת/הזמנת הספר שלך',
	'coll-not_addable' => 'לא ניתן להוסיף דף זה',
	'coll-make_suggestions' => 'הצעת דפים',
	'coll-make_suggestions_tooltip' => 'הצגת הצעות המבוססות על הדפים הנמצאים בספר',
	'coll-suggest_empty' => 'ריק',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 */
$messages['hi'] = array(
	'coll-print_export' => 'प्रिंट/निर्यात',
	'coll-create_a_book' => 'मेरा कलेक्शन',
	'coll-create_a_book_tooltip' => 'एक पुस्तक या पृष्ठ संग्रह बनाएँ',
	'coll-book_creator' => 'पुस्तक निर्माता',
	'coll-download_as' => '$1 के रूप में डाउनलोड करें',
	'coll-download_as_tooltip' => 'इस विकि पृष्ठ के एक $1 संस्करन डाउनलोड करें',
	'coll-disable' => 'अक्षम करें',
	'coll-book_creator_disable' => 'पुस्तक निर्माता को अक्षम करें',
	'coll-book_creator_disable_tooltip' => 'पुस्तक निर्माता का उपयोग बंद करें',
	'coll-add_linked_article' => 'लिंक्ड विकि पृष्ठ को अपनी पुस्तक से जोड़ें',
	'coll-remove_linked_article' => 'लिंक्ड विकि पृष्ठ को अपनी पुस्तक से निकालें',
	'coll-add_category' => 'इस श्रेणी को अपनी पुस्तक से जोड़ें',
	'coll-add_category_tooltip' => 'इस श्रेणी की सारी विकि पृष्ठ को अपनी पुस्तक से जोड़ें',
	'coll-add_this_page' => 'इस पृष्ठ को अपनी पुस्तक से जोड़ें',
	'coll-add_page_tooltip' => 'बर्त्तमान की विकि पृष्ठ को अपनी पुस्तक से जोड़ें',
	'coll-bookscategory' => 'पुस्तकें',
	'coll-clear_collection' => 'पुस्तक खाली करें',
	'coll-clear_collection_confirm' => 'क्या आप वास्तव में पूरी पुस्तक खाली करना चाहते हैं?',
	'coll-clear_collection_tooltip' => 'सारे विकि पृष्ठ को अपनी बर्त्तमान की पुस्तक से निकालें',
	'coll-help' => 'सहायता',
	'coll-help_tooltip' => 'पुस्तक निर्माण में सहायता दिखाएँ',
	'coll-helppage' => 'Help:कलेक्शन',
	'coll-load_collection' => 'कलेक्शन लोड करें',
	'coll-load_collection_tooltip' => 'बर्त्तमान पुस्तक की तरह इस पुस्तक को लोड़ करें',
	'coll-n_pages' => '$2 {{PLURAL:$1|पृष्ठ|पृष्ठ}}',
	'coll-printable_version_pdf' => 'PDF रूपांतर',
	'coll-remove_this_page' => 'इस पृष्ठ को अपनी पुस्तक से निकालें',
	'coll-remove_page_tooltip' => 'बर्त्तमान की विकि पृष्ठ को अपनी पुस्तक से निकालें',
	'coll-show_collection' => 'कलेक्शन दर्शायें',
	'coll-not_addable' => 'इस पृष्ठ को जोड़ा नहीं जा सकता',
	'coll-make_suggestions' => 'सुझाव पृष्ठों',
	'coll-suggest_empty' => 'खाली',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'coll-print_export' => 'Ispis/izvoz',
	'coll-create_a_book' => 'Napravi zbirku',
	'coll-create_a_book_tooltip' => 'Stvorite zbirku ili kolekciju stranica',
	'coll-book_creator' => 'Alat za stvaranje knjige',
	'coll-download_as' => 'Preuzmi kao $1',
	'coll-download_as_tooltip' => 'Preuzmi $1 inačicu ove wiki stranice',
	'coll-disable' => 'onemogući',
	'coll-book_creator_disable' => 'Onemogući alat za knjige',
	'coll-book_creator_disable_tooltip' => 'Prestani rabiti alat za knjige',
	'coll-add_linked_article' => 'Dodaj povezanu wiki stranicu u svoju knjigu',
	'coll-remove_linked_article' => 'Ukloni povezanu wiki stranicu iz svoje knjige',
	'coll-add_category' => 'Dodaj ovu kategoriju u svoju zbirku',
	'coll-add_category_tooltip' => 'Dodaj sve stranica iz kategoriji u svoju zbirku',
	'coll-add_this_page' => 'Dodaj ovu stranicu u svoju zbirku',
	'coll-add_page_tooltip' => 'Dodajte trenutačnu stranicu u svoju zbirku',
	'coll-bookscategory' => 'Zbirke',
	'coll-clear_collection' => 'Očisti zbirku',
	'coll-clear_collection_confirm' => 'Želite li stvarno očistiti svoju cijelu zbirku?',
	'coll-clear_collection_tooltip' => 'Uklonite sve stranice iz vaše trenutačne zbirke',
	'coll-help' => 'Pomoć',
	'coll-help_tooltip' => 'Prikazuje pomoć za stvaranje zbirke',
	'coll-helppage' => 'Help:Zbirke',
	'coll-load_collection' => 'Učitaj zbirku',
	'coll-load_collection_tooltip' => 'Učitati ovu zbirku kao svoju trenutačnu zbirku',
	'coll-n_pages' => '$1 {{PLURAL:$1|stranica|stranice|stranica}}',
	'coll-printable_version_pdf' => 'PDF inačica',
	'coll-remove_this_page' => 'Ukloni ovu stranicu iz svoje zbirke',
	'coll-remove_page_tooltip' => 'Ukloni trenutnačnu stranicu iz svoje zbirke',
	'coll-show_collection' => 'Pokaži zbirku',
	'coll-show_collection_tooltip' => 'Kliknite da biste uredili/preuzeli/naručili svoju zbirku',
	'coll-not_addable' => 'Ova stranica ne može biti dodana',
	'coll-make_suggestions' => 'Predloži stranice',
	'coll-make_suggestions_tooltip' => 'Pokaži prijedloge na temelju stranica u mojoj knjizi',
	'coll-suggest_empty' => 'prazno',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'coll-print_export' => 'Ćišćeć/eksport',
	'coll-create_a_book' => 'Knihu wutworić',
	'coll-create_a_book_tooltip' => 'Knihu abo zběrku nastawkow wutworić',
	'coll-book_creator' => 'Knižny generator',
	'coll-download_as' => 'Jako $1 sćahnyć',
	'coll-download_as_tooltip' => 'Wersiju $1 tuteje wikijoweje strony sćahnyć',
	'coll-disable' => 'znjemóžnić',
	'coll-book_creator_disable' => 'Knižny generator znjemóžnić',
	'coll-book_creator_disable_tooltip' => 'Wužiwanje knižneho generatora zastajić',
	'coll-add_linked_article' => 'Wotkazanu wikistronu twojej knize přidać',
	'coll-remove_linked_article' => 'Wotkazanu wikistronu z twojeje knihi wotstronić',
	'coll-add_category' => 'Tutu kategoriju twojej knize přidać',
	'coll-add_category_tooltip' => 'Wšě wikistrony w tutej kategoriji twojej knize přidać',
	'coll-add_this_page' => 'Tutu stronu twojej knize přidać',
	'coll-add_page_tooltip' => 'Aktualnu wikijowu stronu twojej knize přidać',
	'coll-bookscategory' => '{{SITENAME}}:Knihi',
	'coll-clear_collection' => 'Knihu wuprózdnić',
	'coll-clear_collection_confirm' => 'Chceš woprawdźe swoju knihu dospołnje wuprózdnić?',
	'coll-clear_collection_tooltip' => 'Wšě wikistrony z twojeje aktualneje knihi wotstronić',
	'coll-help' => 'Pomoc',
	'coll-help_tooltip' => 'Pomoc wo wutworjenju knihow pokazać',
	'coll-helppage' => 'Help:Knihi',
	'coll-load_collection' => 'Knihu začitać',
	'coll-load_collection_tooltip' => 'Tutu knihu jako twoju aktualnu knihu začitać',
	'coll-n_pages' => '$1 {{PLURAL:$1|strona|stronje|strony|stronow}}',
	'coll-printable_version_pdf' => 'PDF-wersija',
	'coll-remove_this_page' => 'Tutu stronu z twojeje knihi wotstronić',
	'coll-remove_page_tooltip' => 'Aktualnu wikijowu stronu z twojeje knihi wotstronić',
	'coll-show_collection' => 'Knihu pokazać',
	'coll-show_collection_tooltip' => 'Klikń, zo by swoju knihu wobdźěłał/sćahnył/skazał',
	'coll-not_addable' => 'Tuta strona njeda so přidać',
	'coll-make_suggestions' => 'Strony namjetować',
	'coll-make_suggestions_tooltip' => 'Namjety pokazać, kotrež na stronach w twojej knize bazuja',
	'coll-suggest_empty' => 'prózdny',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'coll-print_export' => 'Nyomtatás/exportálás',
	'coll-create_a_book' => 'Könyv készítése',
	'coll-create_a_book_tooltip' => 'Könyv vagy lapgyűjtemény készítése',
	'coll-book_creator' => 'Könyvkészítő',
	'coll-download_as' => 'Letöltés mint $1',
	'coll-download_as_tooltip' => 'A wikilap $1 formátumú változatának letöltése',
	'coll-disable' => 'kikapcsolás',
	'coll-book_creator_disable' => 'Könyvkészítő kikapcsolása',
	'coll-book_creator_disable_tooltip' => 'Könyvkészítő használatának befejezése',
	'coll-add_linked_article' => 'Hivatkozott wiki lap hozzáadása a könyvedhez',
	'coll-remove_linked_article' => 'Hivatkozott wiki lap eltávolítása a könyvedből',
	'coll-add_category' => 'Kategória hozzáadása a könyvedhez',
	'coll-add_category_tooltip' => 'Ezen kategória összes lapjának hozzáadása a könyvhöz',
	'coll-add_this_page' => 'Lap hozzáadása a könyvedhez',
	'coll-add_page_tooltip' => 'A jelenlegi lap hozzáadása a könyvhöz',
	'coll-bookscategory' => 'Wikipédia-könyvek',
	'coll-clear_collection' => 'Könyv kiürítése',
	'coll-clear_collection_confirm' => 'Valóban törölni szeretnéd a könyved?',
	'coll-clear_collection_tooltip' => 'Az összes lap eltávolítása a kiválasztott könyvből',
	'coll-help' => 'Segítség',
	'coll-help_tooltip' => 'Segítség megjelenítése a könyvkészítésről',
	'coll-helppage' => 'Help:Könyvek',
	'coll-load_collection' => 'Könyv betöltése',
	'coll-load_collection_tooltip' => 'Könyv betöltése kiválasztott könyvként',
	'coll-n_pages' => '{{PLURAL:$1|egy|$1}} lap',
	'coll-printable_version_pdf' => 'PDF változat',
	'coll-remove_this_page' => 'Ezen lap eltávolítása a könyvedből',
	'coll-remove_page_tooltip' => 'A jelenlegi lap eltávolítása a könyvből',
	'coll-show_collection' => 'Könyv mutatása',
	'coll-show_collection_tooltip' => 'Kattints ide a könyv szerkesztéséhez/letöltéséhez/megrendeléségez',
	'coll-not_addable' => 'Ezt a lapot nem lehet hozzáadni',
	'coll-make_suggestions' => 'Lapok ajánlása',
	'coll-make_suggestions_tooltip' => 'Javaslatok megjelenítése a könyvedben található lapok alapján',
	'coll-suggest_empty' => 'üres',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'coll-create_a_book' => 'Ստեղծել գիրք',
	'coll-download_as' => 'Քաշել որպես $1',
	'coll-add_category' => 'Ավելացնել կատեգորիան',
	'coll-bookscategory' => 'Գրքեր',
	'coll-clear_collection' => 'Ջնջել գիրքը',
	'coll-clear_collection_confirm' => 'Դուք իսկապես ցանկանում եք ամբողջությամբ ջնջե՞լ ձեր գիրքը։',
	'coll-helppage' => 'Help:Գրքեր',
	'coll-load_collection' => 'Բեռնել գիրքը',
	'coll-n_pages' => '$1 {{PLURAL:$1|էջ|էջ}}',
	'coll-printable_version_pdf' => 'PDF-տարբերակ',
	'coll-show_collection' => 'Ցույց տալ գիրքը',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'coll-print_export' => 'Imprimer/exportar',
	'coll-create_a_book' => 'Crear un libro',
	'coll-create_a_book_tooltip' => 'Crear un libro o collection de paginas',
	'coll-book_creator' => 'Creator de libros',
	'coll-download_as' => 'Discargar como $1',
	'coll-download_as_tooltip' => 'Discargar un version $1 de iste pagina wiki',
	'coll-disable' => 'disactivar',
	'coll-book_creator_disable' => 'Disactivar le creator de libros',
	'coll-book_creator_disable_tooltip' => 'Cessar de usar le creator de libros',
	'coll-add_linked_article' => 'Adder le pagina $1 a tu libro',
	'coll-remove_linked_article' => 'Remover le pagina $1 de tu libro',
	'coll-add_category' => 'Adder iste categoria a tu libro',
	'coll-add_category_tooltip' => 'Adder tote le paginas wiki in iste categoria a tu libro',
	'coll-add_this_page' => 'Adder iste pagina a tu libro',
	'coll-add_page_tooltip' => 'Adder le pagina wiki actual a tu libro',
	'coll-bookscategory' => 'Libros',
	'coll-clear_collection' => 'Vacuar libro',
	'coll-clear_collection_confirm' => 'Esque tu realmente vole vacuar completemente tu libro?',
	'coll-clear_collection_tooltip' => 'Remover tote le pagians wiki de tu libro actual',
	'coll-help' => 'Adjuta',
	'coll-help_tooltip' => 'Monstrar adjuta super le creation de libros',
	'coll-helppage' => 'Help:Libros',
	'coll-load_collection' => 'Cargar libro',
	'coll-load_collection_tooltip' => 'Cargar iste libro como tu libro actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagina|paginas}}',
	'coll-printable_version_pdf' => 'Version PDF',
	'coll-remove_this_page' => 'Remover iste pagina de tu libro',
	'coll-remove_page_tooltip' => 'Remover le pagina wiki actual de tu libro',
	'coll-show_collection' => 'Monstrar libro',
	'coll-show_collection_tooltip' => 'Clicca pro modificar/discargar/commandar tu libro',
	'coll-not_addable' => 'Iste pagina non pote esser addite',
	'coll-make_suggestions' => 'Suggerer paginas',
	'coll-make_suggestions_tooltip' => 'Monstrar suggestiones a base del paginas ja presente in tu libo',
	'coll-suggest_empty' => 'vacue',
);

/** Indonesian (Bahasa Indonesia)
 * @author -iNu-
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Rex
 */
$messages['id'] = array(
	'coll-print_export' => 'Cetak/ekspor',
	'coll-create_a_book' => 'Buat buku',
	'coll-create_a_book_tooltip' => 'Buat koleksi buku atau halaman',
	'coll-book_creator' => 'Pembuat buku',
	'coll-download_as' => 'Unduh versi $1',
	'coll-download_as_tooltip' => 'Unduh versi $1 halaman wiki ini',
	'coll-disable' => 'tutup',
	'coll-book_creator_disable' => 'Tutup pembuat buku',
	'coll-book_creator_disable_tooltip' => 'Berhenti menggunakan pembuat buku',
	'coll-add_linked_article' => 'Tambahkan halaman yang terpaut dari halaman ini ke dalam buku Anda',
	'coll-remove_linked_article' => 'Hapus halaman yang terpaut dari halaman ini dari buku Anda',
	'coll-add_category' => 'Tambahkan kategori ini ke buku Anda',
	'coll-add_category_tooltip' => 'Tambahkan semua halaman wiki pada kategori ini ke buku Anda',
	'coll-add_this_page' => 'Tambahkan halaman ini ke dalam buku Anda',
	'coll-add_page_tooltip' => 'Tambahkan halaman wiki ini ke dalam buku Anda',
	'coll-bookscategory' => '{{SITENAME}}:Buku',
	'coll-clear_collection' => 'Hapus buku',
	'coll-clear_collection_confirm' => 'Apakah Anda benar-benar ingin menghapus bersih buku Anda?',
	'coll-clear_collection_tooltip' => 'Hapus semua halaman wiki dari buku Anda',
	'coll-help' => 'Bantuan',
	'coll-help_tooltip' => 'Tunjukkan bantuan pembuatan buku',
	'coll-helppage' => 'Help:Buku',
	'coll-load_collection' => 'Muat buku',
	'coll-load_collection_tooltip' => 'Muat buku ini sebagai buku aktif Anda',
	'coll-n_pages' => '$1 {{PLURAL:$1|halaman|halaman}}',
	'coll-printable_version_pdf' => 'Buat PDF',
	'coll-remove_this_page' => 'Singkirkan halaman ini dari buku Anda',
	'coll-remove_page_tooltip' => 'Buang halaman wiki ini dari buku Anda',
	'coll-show_collection' => 'Lihat buku',
	'coll-show_collection_tooltip' => 'Klik untuk menyunting/mengunduh/memesan buku Anda',
	'coll-not_addable' => 'Halaman ini tidak dapat ditambahkan',
	'coll-make_suggestions' => 'Sarankan halaman',
	'coll-make_suggestions_tooltip' => 'Tampilkan saran berdasarkan halaman dalam buku Anda',
	'coll-suggest_empty' => 'kosong',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'coll-help' => 'Nkwádo',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'coll-print_export' => 'Imaldit/ipan',
	'coll-create_a_book' => 'Agaramid ti libro',
	'coll-create_a_book_tooltip' => 'Agaramid ti maysa a libro wenno naurnong a panid',
	'coll-book_creator' => 'Agar-aramid ti libro',
	'coll-download_as' => 'Ikarga a kas $1',
	'coll-download_as_tooltip' => 'Ikarga ti $1 a bersion iti daytoy a panid ti wiki',
	'coll-disable' => 'ibaldado',
	'coll-book_creator_disable' => 'Ibaldado ti agar-aramid ti libro',
	'coll-book_creator_disable_tooltip' => 'Agsardeng nga agusar ti agar-aramid ti libro',
	'coll-add_linked_article' => 'Agnayon kadagiti nasilpuan a panid dita librom',
	'coll-remove_linked_article' => 'Ikkaten dagiti nasilpuan a panid dita librom',
	'coll-add_category' => 'Inayon daytoy a kategoria dita librom',
	'coll-add_category_tooltip' => 'Inayon amin dagiti pampanid iti daytoy a kategoria dita librom',
	'coll-add_this_page' => 'Inaron daytoy a panid diat librom',
	'coll-add_page_tooltip' => 'Inayon ti agdama a panid ti wiki dita librom',
	'coll-bookscategory' => 'Dagiti libro',
	'coll-clear_collection' => 'Dalusan ti libro',
	'coll-clear_collection_confirm' => 'Kayatmo nga agpayso a dalusan ti librom?',
	'coll-clear_collection_tooltip' => 'Ikkaten amin nga agdama a pampanid manipud dita agdama a librom',
	'coll-help' => 'Tulong',
	'coll-help_tooltip' => 'Agipakita ti tulong a maipanggep ti panagaramid ti liblibro',
	'coll-helppage' => 'Help:Liblibro',
	'coll-load_collection' => 'Ikarga ti libro',
	'coll-load_collection_tooltip' => 'Ikarga daytoy a libro a kasla ti agdama a librom',
	'coll-n_pages' => '$1 {{PLURAL:$1|panid|pampanid}}',
	'coll-printable_version_pdf' => 'PDF a bersion',
	'coll-remove_this_page' => 'Ikkaten daytoy a panid manipud idiay librom',
	'coll-remove_page_tooltip' => 'Inayon ti agdama a panid ti wiki manipud idiay librom',
	'coll-show_collection' => 'Iparang ti libro',
	'coll-show_collection_tooltip' => 'Agtakla tapno maka-urnos/agkarga/agbilin ti librom',
	'coll-not_addable' => 'Saan a mainayon daytoy a panid',
	'coll-make_suggestions' => 'Agisingasing ti pampanid',
	'coll-make_suggestions_tooltip' => 'Iparang dagiti naisingasing babaen kadagiti pampanid iti librom',
	'coll-suggest_empty' => 'awan ti nagyan na',
);

/** Ingush (ГІалгІай Ğalğaj)
 * @author Amire80
 * @author Sapral Mikail
 */
$messages['inh'] = array(
	'coll-bookscategory' => 'Китабаш',
	'coll-clear_collection' => 'Китаба цӀенае',
	'coll-help' => 'Новкъoстал',
	'coll-load_collection' => 'Китаба чуяккха',
	'coll-n_pages' => '$1 {{PLURAL:$1|оагӀув|оагӀувнаш}}',
	'coll-show_collection' => 'Китаба хьахокха',
	'coll-suggest_empty' => 'яьсса',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'coll-create_a_book' => 'Kreez un libro',
	'coll-add_category' => 'Adjuntar kategorio a vua libro',
	'coll-add_this_page' => 'Adjuntez ca pagino a vua libro',
	'coll-bookscategory' => 'Libri',
	'coll-clear_collection' => 'Vakuigar libro',
	'coll-help' => 'Helpo',
	'coll-helppage' => 'Help:Libri',
	'coll-load_collection' => 'Kargar libro',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagino|pagini}}',
	'coll-printable_version_pdf' => 'Versiono PDF',
	'coll-show_collection' => 'Montrar libro',
	'coll-make_suggestions' => 'Sugestez pagini',
	'coll-suggest_empty' => 'vakua',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'coll-create_a_book' => 'Safnið mitt',
	'coll-add_category' => 'Bæta við flokki',
	'coll-load_collection' => 'Hlaða safn',
	'coll-show_collection' => 'Sýna safn',
);

/** Italian (Italiano)
 * @author Beta16
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 * @author Nemo bis
 * @author OrbiliusMagister
 */
$messages['it'] = array(
	'coll-print_export' => 'Stampa/esporta',
	'coll-create_a_book' => 'Crea un libro',
	'coll-create_a_book_tooltip' => 'Crea un libro o una raccolta di articoli',
	'coll-book_creator' => 'Creatore di libri',
	'coll-download_as' => 'Scarica come $1',
	'coll-download_as_tooltip' => 'Scarica una versione $1 di questa pagina wiki',
	'coll-disable' => 'disattiva',
	'coll-book_creator_disable' => 'Disattiva il creatore di libri',
	'coll-book_creator_disable_tooltip' => 'Smetti di usare il creatore di libri',
	'coll-add_linked_article' => 'Aggiungi le pagine collegate a questa al tuo libro.',
	'coll-remove_linked_article' => 'Rimuovi le pagine collegate a questa dal tuo libro.',
	'coll-add_category' => 'Aggiungi questa categoria al tuo libro',
	'coll-add_category_tooltip' => 'Aggiungi tutte le pagine wiki di questa categoria al tuo libro',
	'coll-add_this_page' => 'Aggiungi questa pagina al tuo libro',
	'coll-add_page_tooltip' => 'Aggiungi la pagina wiki corrente al tuo libro',
	'coll-bookscategory' => 'Libri',
	'coll-clear_collection' => 'Svuota libro',
	'coll-clear_collection_confirm' => 'Si desidera veramente svuotare completamente il proprio libro?',
	'coll-clear_collection_tooltip' => 'Rimuovi tutte le pagine wiki dal tuo libro corrente',
	'coll-help' => 'Aiuto',
	'coll-help_tooltip' => "Mostra l'aiuto sulla creazione di libri",
	'coll-helppage' => 'Help:Libri',
	'coll-load_collection' => 'Carica libro',
	'coll-load_collection_tooltip' => 'Carica questo libro come libro corrente',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagina|pagine}}',
	'coll-printable_version_pdf' => 'Versione PDF',
	'coll-remove_this_page' => 'Rimuovi questa pagina dal tuo libro',
	'coll-remove_page_tooltip' => 'Rimuovi la pagina wiki corrente dal tuo libro',
	'coll-show_collection' => 'Mostra libro',
	'coll-show_collection_tooltip' => 'Fai clic per modificare, scaricare o ordinare il tuo libro',
	'coll-not_addable' => 'Questa pagina non può essere aggiunta',
	'coll-make_suggestions' => 'Suggerisci delle pagine',
	'coll-make_suggestions_tooltip' => 'Mostra suggerimenti basati sulle pagine del proprio libro',
	'coll-suggest_empty' => 'vuoto',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Marine-Blue
 * @author Naohiro19
 * @author 青子守歌
 */
$messages['ja'] = array(
	'coll-print_export' => '印刷/エクスポート',
	'coll-create_a_book' => 'ブックの新規作成',
	'coll-create_a_book_tooltip' => 'ブックあるいは記事集を作成する',
	'coll-book_creator' => 'ブッククリエーター',
	'coll-download_as' => '$1としてダウンロード',
	'coll-download_as_tooltip' => 'このウィキページの$1版をダウンロードする',
	'coll-disable' => '無効化',
	'coll-book_creator_disable' => 'ブッククリエーターを無効化',
	'coll-book_creator_disable_tooltip' => 'ブッククリエーターを使うのを止める',
	'coll-add_linked_article' => 'リンクされているウィキページをブックに追加する',
	'coll-remove_linked_article' => 'あなたの本からウィキページのリンクを削除',
	'coll-add_category' => 'このカテゴリを自分のブックに追加する',
	'coll-add_category_tooltip' => 'このカテゴリ中のすべてのページをあなたのブックに追加する',
	'coll-add_this_page' => 'このページを自分のブックに追加する',
	'coll-add_page_tooltip' => '現在のページをあなたのブックに追加する',
	'coll-bookscategory' => 'ブック',
	'coll-clear_collection' => 'ブックを消去',
	'coll-clear_collection_confirm' => '本当にブックを完全に消去しますか？',
	'coll-clear_collection_tooltip' => 'あなたの現在のブックからすべてのウィキページを削除する',
	'coll-help' => 'ヘルプ',
	'coll-help_tooltip' => 'ブックの作成に関するヘルプを表示する',
	'coll-helppage' => 'Help:ブック',
	'coll-load_collection' => 'ブックの読み込み',
	'coll-load_collection_tooltip' => 'このブックをあなたの現在のブックとして読み込む',
	'coll-n_pages' => '$1ページ',
	'coll-printable_version_pdf' => 'PDF版',
	'coll-remove_this_page' => 'このページを自分のブックから削除する',
	'coll-remove_page_tooltip' => '現在のページをあなたのブックから削除する',
	'coll-show_collection' => 'ブックを表示',
	'coll-show_collection_tooltip' => 'クリックしてあなたのブックを編集、ダウンロード、または注文する',
	'coll-not_addable' => 'このページは追加できません',
	'coll-make_suggestions' => 'ページの候補',
	'coll-make_suggestions_tooltip' => 'あなたのブックに保存されたページを元に候補を表示します',
	'coll-suggest_empty' => '空',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'coll-create_a_book' => 'Gawé buku',
	'coll-download_as' => 'Undhuh minangka $1',
	'coll-add_category' => 'Tambahna kategori iki menyang buku panjenengan',
	'coll-clear_collection' => 'Busak buku',
	'coll-clear_collection_confirm' => 'Apa panjenengan pancèn arep mbusak buku panjenengan sakabèhané?',
	'coll-helppage' => 'Help:Buku',
	'coll-load_collection' => 'Unggahna buku',
	'coll-n_pages' => '$1 {{PLURAL:$1|kaca|kaca}}',
	'coll-printable_version_pdf' => 'Vèrsi PDF',
	'coll-show_collection' => 'Tuduhna buku',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Malafaya
 * @author Sopho
 * @author Temuri rajavi
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'coll-print_export' => 'დაბეჭდვა/ექსპორტი',
	'coll-create_a_book' => 'წიგნის შექმნა',
	'coll-create_a_book_tooltip' => 'წიგნის ან სტატიების კოლექციის შექმნა',
	'coll-book_creator' => 'წიგნის ოსტატი',
	'coll-download_as' => 'იწერს როგორც $1',
	'coll-download_as_tooltip' => 'ამ ვიკი-გვერდის $1 ვერსიის ჩაწერა',
	'coll-disable' => 'გათიშვა',
	'coll-book_creator_disable' => 'გათიშეთ წიგნის ოსტატი',
	'coll-book_creator_disable_tooltip' => 'წიგნის ოსტატის გამოყენების შეჩერება',
	'coll-add_linked_article' => 'ჩაამატეთ შესაბამისი ვიკიგვერდი თქვენ წიგნში',
	'coll-remove_linked_article' => 'წაშალეთ შესაბამისი ვიკიგვერდი თქვენი წიგნიდან',
	'coll-add_category' => 'კატეგორიის ჩამატება თქვენ წიგნში',
	'coll-add_category_tooltip' => 'ამ კატეგორიის ყველა ვიკი გვერდის ჩამატება წიგნში',
	'coll-add_this_page' => 'დაამატეთ ეს გვერდი თქვენს წიგნში',
	'coll-add_page_tooltip' => 'შესაბამისი ვიკი გვერდის წიგნში ჩამატება',
	'coll-bookscategory' => 'წიგნები',
	'coll-clear_collection' => 'წიგნის გასუფთავება',
	'coll-clear_collection_confirm' => 'დარწმუნებული ხართ, რომ გსურთ თქვენი წიგნის სრული დასუფთავება?',
	'coll-clear_collection_tooltip' => 'მოცემული წიგნიდან ყველა ვიკი-გვერდის წაშლა.',
	'coll-help' => 'დახმარება',
	'coll-help_tooltip' => 'აჩვენეთ დახმარება წიგნის შექმნასთან დაკავშირებით',
	'coll-helppage' => 'Help:წიგნები',
	'coll-load_collection' => 'წიგნის ატვირთვა',
	'coll-load_collection_tooltip' => 'გადმოტვირთეთ ეს წიგნი როგორც თქვენი მოქმედი წიგნი',
	'coll-n_pages' => '$1 გვერდი',
	'coll-printable_version_pdf' => 'PDF ვერსია',
	'coll-remove_this_page' => 'თქვენი წიგნიდან ამ გვერდის წაშლა',
	'coll-remove_page_tooltip' => 'თქვენი წიგნიდან ამჟამინდელი ვიკი-გვერდის წაშლა',
	'coll-show_collection' => 'წიგნის ჩვენება',
	'coll-show_collection_tooltip' => 'დააჭირეთ წიგნის რედაქტირებსთვის/ატვირთვისთვის/გამოწერისთვის',
	'coll-not_addable' => 'ეს გვერდი არ ემატება',
	'coll-make_suggestions' => 'შეთავაზებული გვერდები',
	'coll-make_suggestions_tooltip' => 'აჩვენეთ მოსაზრებები, რომლებიც დაფუძნებულია თქვენ წიგნში არსებულ გვერდებზე.',
	'coll-suggest_empty' => 'ცარიელი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'coll-print_export' => 'បោះពុម្ព​/នាំចេញ​',
	'coll-create_a_book' => 'បង្កើតសៀវភៅ​',
	'coll-create_a_book_tooltip' => 'បង្កើតសៀវភៅឬកំរងទំព័រ',
	'coll-book_creator' => 'ឧបករណ៍បង្កើតសៀវភៅ',
	'coll-download_as' => 'ទាញយកជា $1',
	'coll-download_as_tooltip' => 'ទាញយកទំរង់ $1 របស់ទំព័រវិគីនេះ',
	'coll-disable' => 'មិនប្រើ',
	'coll-book_creator_disable' => 'មិនប្រើឧបករណ៍បង្កើតសៀវភៅ',
	'coll-book_creator_disable_tooltip' => 'ឈប់ប្រើឧបករណ៍បង្កើតសៀវភៅ',
	'coll-add_linked_article' => 'បន្ថែមទំព័រវិគីដែលទាក់ទិនចូលទៅក្នុងសៀវភៅរបស់អ្នក',
	'coll-remove_linked_article' => 'ដកទំព័រវិគីដែលទាក់ទិនចេញពីសៀវភៅរបស់អ្នក',
	'coll-add_category' => 'បន្ថែមចំណាត់ថ្នាក់ក្រុមនេះដល់សៀវភៅរបស់អ្នក',
	'coll-add_category_tooltip' => 'បន្ថែម​ទំព័រ​វិគី​ទាំងអស់​ក្នុង​ចំណាត់ថ្នាក់ក្រុម​នេះទៅ​ក្នុង​សៀវភៅ​របស់​អ្នក​​',
	'coll-add_this_page' => 'បន្ថែម​ទំព័រនេះ​ទៅក្នុង​សៀវភៅ​របស់អ្នក​',
	'coll-add_page_tooltip' => 'បន្ថែម​ទំព័រ​វីគី​បច្ចុប្បន្នទៅ​សៀវភៅ​របស់​អ្នក​',
	'coll-bookscategory' => 'សៀវភៅ',
	'coll-clear_collection' => 'ជម្រះសៀវភៅ',
	'coll-clear_collection_confirm' => 'តើ​អ្នក​ពិតជា​ចង់​ជម្រះ​សៀវភៅ​របស់​អ្នក​ទាំងស្រុង​ឬ​?',
	'coll-clear_collection_tooltip' => 'ដកយក​ទំព័រ​វីគីទាំងអស់​ពីសៀវភៅ​បច្ចុប្បន្ន​របស់អ្នក​',
	'coll-help' => 'ជំនួយ',
	'coll-help_tooltip' => 'បង្ហាញ​ជំនួយ​អំពី​ការ​បង្កើត​​សៀវភៅ​',
	'coll-helppage' => 'Help: សៀវភៅ',
	'coll-load_collection' => 'ផ្ទុកសៀវភៅ',
	'coll-load_collection_tooltip' => 'ផ្ទុក​សៀវភៅនេះ​ទៅជា​សៀវភៅ​បច្ចុប្បន្ន​របស់អ្នក​',
	'coll-n_pages' => '$1 {{PLURAL:$1|ទំព័រ|ទំព័រ}}',
	'coll-printable_version_pdf' => 'កំណែ PDF',
	'coll-remove_this_page' => 'ដកចេញទំព័រនេះពីសៀវភៅ​របស់​អ្នក​',
	'coll-remove_page_tooltip' => 'ដកចេញទំព័រវិគី​បច្ចុប្បន្ន​ពីសៀវភៅ​របស់អ្នក​',
	'coll-show_collection' => 'បង្ហាញ​សៀវភៅ',
	'coll-show_collection_tooltip' => 'ចុច​ដើម្បី​កែប្រែ​/ទាញ​យក​/បញ្ជា​ទិញ​សៀវភៅ​របស់​អ្នក​',
	'coll-not_addable' => 'ទំព័រនេះមិនអាចបន្ថែមបានទេ',
	'coll-suggest_empty' => 'ទទេ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'coll-help' => 'ಸಹಾಯ',
);

/** Korean (한국어)
 * @author Ilovesabbath
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'coll-print_export' => '인쇄/내보내기',
	'coll-create_a_book' => '책 만들기',
	'coll-create_a_book_tooltip' => '책이나 문서 모음집을 만듭니다',
	'coll-book_creator' => '책 생성기',
	'coll-download_as' => '$1로 다운로드',
	'coll-download_as_tooltip' => '이 위키 문서를 $1 버전으로 다운로드합니다.',
	'coll-disable' => '끄기',
	'coll-book_creator_disable' => '책 생성기를 끄기',
	'coll-book_creator_disable_tooltip' => '책 생성기 사용을 중지합니다.',
	'coll-add_linked_article' => '링크된 위키 문서를 당신의 책에 추가하기',
	'coll-remove_linked_article' => '링크된 위키 문서를 책에서 제거하기',
	'coll-add_category' => '이 분류를 책에 추가하기',
	'coll-add_category_tooltip' => '이 분류에 속하는 문서 모두를 책에 추가하기',
	'coll-add_this_page' => '이 문서를 책에 추가하기',
	'coll-add_page_tooltip' => '이 문서를 책에 추가하기',
	'coll-bookscategory' => '책',
	'coll-clear_collection' => '책 초기화',
	'coll-clear_collection_confirm' => '책에 있는 내용이 완전히 삭제됩니다. 초기화할까요?',
	'coll-clear_collection_tooltip' => '책에 있는 문서 모두를 삭제하기',
	'coll-help' => '도움말',
	'coll-help_tooltip' => '책을 만드는 방법에 대한 도움말 보기',
	'coll-helppage' => 'Help:책 만들기',
	'coll-load_collection' => '책 불러오기',
	'coll-load_collection_tooltip' => '이 책을 책 제작 작업란으로 불러오기',
	'coll-n_pages' => '$1개의 문서',
	'coll-printable_version_pdf' => 'PDF 버전',
	'coll-remove_this_page' => '책에서 해당 페이지를 삭제',
	'coll-remove_page_tooltip' => '책에서 이 문서를 제외합니다',
	'coll-show_collection' => '책 보이기',
	'coll-show_collection_tooltip' => '책을 편집/다운로드/주문하려면 클릭해 주세요',
	'coll-not_addable' => '이 문서를 추가할 수 없습니다.',
	'coll-make_suggestions' => '문서 제안하기',
	'coll-make_suggestions_tooltip' => '당신의 책에 있는 문서에 따라 문서 제안 목록을 보여 줍니다.',
	'coll-suggest_empty' => '비었음',
);

/** Krio (Krio)
 * @author Protostar
 */
$messages['kri'] = array(
	'coll-create_a_book' => 'Mek buk',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'coll-print_export' => 'Dröcke / Äxpotteere',
	'coll-create_a_book' => 'E Booch zesamme_ställe',
	'coll-create_a_book_tooltip' => 'Donn e Booch maache, udder en Sammlong vun Atikele aanlääje',
	'coll-book_creator' => '„Bööscher Maache“',
	'coll-download_as' => 'Als $1 eronger laade',
	'coll-download_as_tooltip' => 'Donn heh di Wiki-Sigg em $1-Fommaat erunger laade',
	'coll-disable' => 'ußschallde',
	'coll-book_creator_disable' => 'Et „Bööscher Maache“ ußschallde',
	'coll-book_creator_disable_tooltip' => 'Hür mem „Bööscher Maache“ op',
	'coll-add_linked_article' => 'Donn de Sigg uss_em Wiki woh dä Lenk drop jeiht bei dat Booch dobei',
	'coll-remove_linked_article' => 'Schmiiß de Sigg uss_em Wiki woh dä Lenk drop jeiht uß Dingem Booch eruß',
	'coll-add_category' => 'Donn heh di Saachjrupp bei dat Booch dobei',
	'coll-add_category_tooltip' => 'Dat deiht all de Atikelle en dä {{NS:Category}} en Ding Booch erin.',
	'coll-add_this_page' => 'Donn heh di Sigg bei Ding Booch dobei',
	'coll-add_page_tooltip' => 'Donn de aktoälle Wiki-Sigg en dat Booch erin',
	'coll-bookscategory' => 'Bööscher',
	'coll-clear_collection' => 'Dat Booch leddisch maache',
	'coll-clear_collection_confirm' => 'Wells De Ding Booch verhaftesch jannz fott schmieße?',
	'coll-clear_collection_tooltip' => 'Hee met schmiiß De alle Sigge fum Wiki uß Dingem aktoälle Booch eruß, un deihs et leddisch maache.',
	'coll-help' => 'Hölp',
	'coll-help_tooltip' => 'Zeisch Hölp zom Bööscher Maache aan',
	'coll-helppage' => 'Help:Bööscher',
	'coll-load_collection' => 'Booch lade',
	'coll-load_collection_tooltip' => 'Deiht dat Booch hee als Ding aktoälles Booch laade.',
	'coll-n_pages' => '{{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigge}}',
	'coll-printable_version_pdf' => '<i lang="en">PDF</i> Version',
	'coll-remove_this_page' => 'Schmiiß die Sigg uß Dingem Booch eruß',
	'coll-remove_page_tooltip' => 'Schmiiß hee di Sigg fum Wiki uß Dingem Booch eruß',
	'coll-show_collection' => 'Booch zeije',
	'coll-show_collection_tooltip' => 'He met kanns De Ding Boch ändere, de zosamme jeshtalle Sigge erunger laade, un jedröck beshtelle.',
	'coll-not_addable' => 'Di Sigg kam_mer nit dobei donn',
	'coll-make_suggestions' => 'Sigge vörschlonn',
	'coll-make_suggestions_tooltip' => 'Donn Vörschlähsch aanzeije, je noh dä Sigge en Dingem Booch',
	'coll-suggest_empty' => 'leddisch',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'coll-help' => 'Alîkarî',
	'coll-printable_version_pdf' => 'Versiyona PDF',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'coll-print_export' => 'Drécken/exportéieren',
	'coll-create_a_book' => 'E Buch uleeën',
	'coll-create_a_book_tooltip' => 'E Buch oder eng Sammlung vun Artikelen uleeën',
	'coll-book_creator' => 'Buchfonctioun',
	'coll-download_as' => 'Als $1 eroflueden',
	'coll-download_as_tooltip' => 'Eng $1 Versioun vun dëser Wiki-Säit eroflueden',
	'coll-disable' => 'Ausschalten',
	'coll-book_creator_disable' => 'Buchfonctioun ausschalten',
	'coll-book_creator_disable_tooltip' => "Ophalen d'Buchfonctioun ze benotzen",
	'coll-add_linked_article' => 'Déi verlinkte Wiki-Säit an däi buch derbäisetzen',
	'coll-remove_linked_article' => 'Déi verlinkte Wiki-Säit aus dengem Buch eraushuelen',
	'coll-add_category' => 'Dës Kategorie an Äert Buch derbäisetzen',
	'coll-add_category_tooltip' => 'All Wiki-Säiten aus dëser Kategorie an Äert Buch derbäisetzen',
	'coll-add_this_page' => 'Dës Säit an Äert Buch derbäisetzen',
	'coll-add_page_tooltip' => 'Déi aktuell Wiki-Säit an Äert Buch derbäisetzen',
	'coll-bookscategory' => 'Bicher',
	'coll-clear_collection' => 'Buch eidel maachen',
	'coll-clear_collection_confirm' => 'Wëllt Dir Äert Buch wierklech ganz läschen?',
	'coll-clear_collection_tooltip' => 'All Wiki-Säiten aus ärem aktuelle Buch eraushuelen',
	'coll-help' => 'Hëllef',
	'coll-help_tooltip' => "Hëllef fir d'Uleë vu Bicher weisen",
	'coll-helppage' => 'Help:Bicher',
	'coll-load_collection' => 'Buch lueden',
	'coll-load_collection_tooltip' => 'Dëst Buch als Äert aktuellt Buch lueden',
	'coll-n_pages' => '$1 {{PLURAL:$1|Säit|Säiten}}',
	'coll-printable_version_pdf' => 'PDF-Versioun',
	'coll-remove_this_page' => 'Dës Säit aus Ärem Buch eraushuelen',
	'coll-remove_page_tooltip' => 'Dës Wiki-Säit aus Ärem buch eraushuelen',
	'coll-show_collection' => "D'Buch weisen",
	'coll-show_collection_tooltip' => "Klickt fir Äert Buch z'änneren/erofzelueden/ze bestellen",
	'coll-not_addable' => 'Dës Säit kann net derbäigesat ginn',
	'coll-make_suggestions' => 'Säite virschloen',
	'coll-make_suggestions_tooltip' => 'Virschléi weisen op Basis vun de Säiten an Ärem Buch',
	'coll-suggest_empty' => 'eidel',
);

/** Lezghian (Лезги)
 * @author Namik
 */
$messages['lez'] = array(
	'coll-bookscategory' => 'Ктаб',
	'coll-help' => 'Куьмек',
	'coll-helppage' => 'Help:Ктабар',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'coll-print_export' => 'Drók aaf/exporteer',
	'coll-create_a_book' => "Maak 'n book",
	'coll-create_a_book_tooltip' => 'Maal book- of paginacolleksje aan',
	'coll-book_creator' => 'Bokemaker',
	'coll-download_as' => 'Óphaole es $1',
	'coll-download_as_tooltip' => "Download 'n $1-versie van dees wikipagina",
	'coll-disable' => 'zèt oet',
	'coll-book_creator_disable' => 'Zèt bokemaker oet',
	'coll-book_creator_disable_tooltip' => 'Gebroek bokemaker neet meer',
	'coll-add_linked_article' => 'Voog de gekoppelde wikipagina aan die book toe',
	'coll-remove_linked_article' => 'Wösj de gekoppelde wikipagina oet die book.',
	'coll-add_category' => 'Voog zeukgroop bie aan die book',
	'coll-add_category_tooltip' => 'Zèt als paasj in dees zeukgroop aan öch book',
	'coll-add_this_page' => 'Voog dees pagina toe aan die book',
	'coll-add_page_tooltip' => "Zèt d'n huujige wikipaasj aan öch book",
	'coll-bookscategory' => 'Beuk',
	'coll-clear_collection' => 'Laeg book',
	'coll-clear_collection_confirm' => 'Wils se dien book èch laege?',
	'coll-clear_collection_tooltip' => 'Wösj als paasj oet öch huujig book',
	'coll-help' => 'Hölp',
	'coll-help_tooltip' => 'Bokemakershólp',
	'coll-helppage' => 'Help:Beuk',
	'coll-load_collection' => 'Laaj book',
	'coll-load_collection_tooltip' => 'Laaj dit book es öch huujig book',
	'coll-n_pages' => "$1 {{PLURAL:$1|pazjena|pazjena's}}",
	'coll-printable_version_pdf' => 'PDF-gaedering',
	'coll-remove_this_page' => 'Dees pagina oet die book ewegsjaffe',
	'coll-remove_page_tooltip' => "Wösj d'n huujig wikipaasj oet öch book",
	'coll-show_collection' => 'Toean book',
	'coll-show_collection_tooltip' => 'Klik óm öch book tö bewèrke/óphaole/bestèlle',
	'coll-not_addable' => 'Dees paasj kos neet toegevoog waere',
	'coll-make_suggestions' => 'Suggereer paazjes',
	'coll-make_suggestions_tooltip' => 'Tuun suggesties oppe bokepaginabasis',
	'coll-suggest_empty' => 'laeg',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Homo
 */
$messages['lt'] = array(
	'coll-print_export' => 'Spausdinti/eksportuoti',
	'coll-create_a_book' => 'Kurti knygą',
	'coll-book_creator' => 'Knygos kūrėjas',
	'coll-download_as' => 'Parsisiųsti kaip $1',
	'coll-download_as_tooltip' => 'Atsisiųsti $1 šio wiki puslapio versiją',
	'coll-disable' => 'išjungti',
	'coll-book_creator_disable' => 'Išjungti knygų kūrėją',
	'coll-book_creator_disable_tooltip' => 'Nebenaudoti knygų kūrėjo',
	'coll-add_category' => 'Pridėti šią kategoriją į savo knygą',
	'coll-add_category_tooltip' => 'Pridėti visus wiki puslapius šioje kategorijoje į savo knygą',
	'coll-add_this_page' => 'Pridėti šį puslapį į savo knygą',
	'coll-add_page_tooltip' => 'Pridėti dabartinį wiki puslapį į savo knygą',
	'coll-bookscategory' => 'Knygos',
	'coll-clear_collection' => 'Išvalyti knygą',
	'coll-clear_collection_confirm' => 'Ar tikrai norite visiškai išvalyti savo knygą?',
	'coll-clear_collection_tooltip' => 'Pašalinti visus wiki puslapius iš savo dabartinės knygos',
	'coll-help' => 'Pagalba',
	'coll-help_tooltip' => 'Rodyti pagalba apie knygų kūrima',
	'coll-helppage' => 'Pagalba: Knygos',
	'coll-load_collection' => 'Įkelti knygas',
	'coll-load_collection_tooltip' => 'Įkelti šią knygą kaip jūsų dabartinę knygą',
	'coll-n_pages' => '$1 {{PLURAL:$1|puslapis|puslapiai}}',
	'coll-printable_version_pdf' => 'PDF versija',
	'coll-remove_this_page' => 'Pašalinti šį puslapį iš jūsų knygos',
	'coll-remove_page_tooltip' => 'Pašalinti dabartinį wiki puslapį iš jūsų knygos',
	'coll-show_collection' => 'Rodyti knyga',
	'coll-show_collection_tooltip' => 'Spustelėkite norėdami redaguoti/atsisiųsti/užsisakyti savo knygą',
	'coll-not_addable' => 'Šis puslapis negali būti pridėtas',
	'coll-make_suggestions' => 'Siūlyti puslapius',
	'coll-suggest_empty' => 'tuščia',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'coll-create_a_book' => 'Iztaiseit gruomotu',
	'coll-load_collection' => 'Atsasyuteit gruomotu',
	'coll-printable_version_pdf' => 'PDF verseja',
	'coll-show_collection' => 'Ruodeit gruomotu',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 * @author Papuass
 */
$messages['lv'] = array(
	'coll-print_export' => 'Drukāt/eksportēt',
	'coll-create_a_book' => 'Izveidot grāmatu',
	'coll-create_a_book_tooltip' => 'Izveidot grāmatu vai lapu kolekciju',
	'coll-book_creator' => 'Grāmatu veidotājs',
	'coll-download_as' => 'Lejupielādēt kā $1',
	'coll-download_as_tooltip' => 'Lejupielādēt šīs lapas $1 versiju',
	'coll-disable' => 'atslēgt',
	'coll-book_creator_disable' => 'Atspējot grāmatu veidotāju',
	'coll-book_creator_disable_tooltip' => 'Beigt lietot grāmatu lietotāju',
	'coll-add_linked_article' => 'Pievienot saistīto viki lapu savai grāmatai',
	'coll-remove_linked_article' => 'Izņemt saistīto viki lapu no savas grāmatas',
	'coll-add_category' => 'Pievienot šo kategoriju savai grāmatai',
	'coll-add_category_tooltip' => 'Pievienot visas šajā kategorijā esošās viki lapas savai grāmatai',
	'coll-add_this_page' => 'Pievienot šo lapu savai grāmatai',
	'coll-add_page_tooltip' => 'Pievienot pašreizējo viki lapu savai grāmatai',
	'coll-bookscategory' => 'Grāmatas',
	'coll-clear_collection' => 'Notīrīt grāmatu',
	'coll-clear_collection_confirm' => 'Vai Jūs tiešām vēlaties pilnībā notīrīt savu grāmatu?',
	'coll-clear_collection_tooltip' => 'Izņem visas viki lapas no Jūsu pašreizējās grāmatas',
	'coll-help' => 'Palīdzība',
	'coll-help_tooltip' => 'Parādīt palīdzību par grāmatu veidošanu',
	'coll-helppage' => 'Help:Grāmatas',
	'coll-load_collection' => 'Ielādēt grāmatu',
	'coll-load_collection_tooltip' => 'Ielādēt šo grāmatu kā Jūsu pašreizējo grāmatu',
	'coll-printable_version_pdf' => 'PDF versija',
	'coll-remove_this_page' => 'Izņemt šo lapu no Jūsu grāmatas',
	'coll-remove_page_tooltip' => 'Izņemt pašreizējo viki lapu no Jūsu grāmatas',
	'coll-show_collection' => 'Parādīt grāmatu',
	'coll-show_collection_tooltip' => 'Klikšķināt, lai labotu/lejupielādētu/pasūtītu Jūsu grāmatu',
	'coll-not_addable' => 'Šo lapu nevar pievienot',
	'coll-make_suggestions' => 'Ieteikt lapas',
	'coll-make_suggestions_tooltip' => 'Parādīt ieteikumus, ņemot vērā lapas Jūsu grāmatā',
	'coll-suggest_empty' => 'tukšs',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'coll-print_export' => 'Печати/извези',
	'coll-create_a_book' => 'Направи книга',
	'coll-create_a_book_tooltip' => 'Направете книга или збирка од страници',
	'coll-book_creator' => 'Книговезница',
	'coll-download_as' => 'Преземи како $1',
	'coll-download_as_tooltip' => 'Преземи $1 верзија на оваа вики-страница',
	'coll-disable' => 'оневозможи',
	'coll-book_creator_disable' => 'Оневозможи ја книговезницата',
	'coll-book_creator_disable_tooltip' => 'Прекини со користење на книговезницата',
	'coll-add_linked_article' => 'Додавај врска до викистраница во книгата',
	'coll-remove_linked_article' => 'Отстрани врска до викистраница од книгата',
	'coll-add_category' => 'Додајте ја категоријава во вашата книга',
	'coll-add_category_tooltip' => 'Додај ги сите вики-страници од оваа категорија во книгата',
	'coll-add_this_page' => 'Додај ја страницава во мојата книга',
	'coll-add_page_tooltip' => 'Додај ја тековната вики-страница во книгата',
	'coll-bookscategory' => 'Книги',
	'coll-clear_collection' => 'Исчиси ја книгата',
	'coll-clear_collection_confirm' => 'Дали навистина сакате сосема да ја исчистите книгата?',
	'coll-clear_collection_tooltip' => 'Отстрани ги сите вики-страници од мојата тековна книга',
	'coll-help' => 'Помош',
	'coll-help_tooltip' => 'Прикажи помош за создавањето на книги',
	'coll-helppage' => 'Help:Книги',
	'coll-load_collection' => 'Вчитај книга',
	'coll-load_collection_tooltip' => 'Вчитај ја книгава како моја тековна книга',
	'coll-n_pages' => '$1 {{PLURAL:$1|страница|страници}}',
	'coll-printable_version_pdf' => 'PDF верзија',
	'coll-remove_this_page' => 'Отстрани ја страницава од мојата книга',
	'coll-remove_page_tooltip' => 'Отстрани ја тековната вики-страница од мојата книга',
	'coll-show_collection' => 'Прикажи ја книгата',
	'coll-show_collection_tooltip' => 'Кликнете за да ја уредите/преземете/порачате книгата',
	'coll-not_addable' => 'Оваа страница не може да се додаде',
	'coll-make_suggestions' => 'Предложи страници',
	'coll-make_suggestions_tooltip' => 'Прикажи предлози засновани на страници од вашата книга',
	'coll-suggest_empty' => 'празно',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'coll-print_export' => 'അച്ചടിയ്ക്കുക/കയറ്റുമതി ചെയ്യുക',
	'coll-create_a_book' => 'പുസ്തകം സൃഷ്ടിക്കുക',
	'coll-create_a_book_tooltip' => 'ഒരു പുസ്തകം അല്ലെങ്കിൽ താളുകളുടെ ശേഖരം സൃഷ്ടിക്കുക',
	'coll-book_creator' => 'പുസ്തക സൃഷ്ടി ഉപകരണം',
	'coll-download_as' => '$1 ആയി ഡൗൺലോഡ് ചെയ്യുക',
	'coll-download_as_tooltip' => 'ഈ വിക്കി താളിന്റെ $1 പതിപ്പ് ഡൗൺലോഡ് ചെയ്യുക',
	'coll-disable' => 'നിർജ്ജീവമാക്കുക',
	'coll-book_creator_disable' => 'പുസ്തക സൃഷ്ടി ഉപകരണം നിർജീവമാക്കുക',
	'coll-book_creator_disable_tooltip' => 'പുസ്തക സൃഷ്ടി ഉപകരണം ഉപയോഗിക്കുന്നതു നിർത്തുക',
	'coll-add_linked_article' => 'താങ്കളുടെ പുസ്തകത്തിൽ കണ്ണിയുള്ള വിക്കിതാൾ കൂട്ടിച്ചേർക്കുക',
	'coll-remove_linked_article' => 'താങ്കളുടെ പുസ്തകത്തിൽനിന്നും  കണ്ണിചേർക്കപ്പെട്ട വിക്കിതാൾ നീക്കംചെയ്യുക',
	'coll-add_category' => 'താങ്കളുടെ പുസ്തകത്തിൽ ഈ വർഗ്ഗം ചേർക്കുക',
	'coll-add_category_tooltip' => 'ഈ വർഗ്ഗത്തിലുള്ള എല്ലാ വിക്കി താളുകളും താങ്കളുടെ പുസ്തകത്തിലേയ്ക്ക് കൂട്ടിച്ചേർക്കുക',
	'coll-add_this_page' => 'ഈ താൾ താങ്കളുടെ പുസ്തകത്തിലേയ്ക്ക് കൂട്ടിച്ചേർക്കുക',
	'coll-add_page_tooltip' => 'ഇപ്പോഴത്തെ താൾ താങ്കളുടെ പുസ്തകത്തിലേയ്ക്ക് ചേർക്കുക',
	'coll-bookscategory' => 'പുസ്തകങ്ങൾ',
	'coll-clear_collection' => 'പുസ്തകം മായ്ക്കുക',
	'coll-clear_collection_confirm' => 'പുസ്തകം പൂർണ്ണമായും ശൂന്യമാക്കാൻ താങ്കൾ ശരിക്കുമാഗ്രഹിക്കുന്നുണ്ടോ?',
	'coll-clear_collection_tooltip' => 'താങ്കളുടെ ഈ പുസ്തകത്തിൽ നിന്നും എല്ലാ താളുകളും നീക്കം ചെയ്യുക',
	'coll-help' => 'സഹായം',
	'coll-help_tooltip' => 'പുസ്തകങ്ങൾ സൃഷ്ടിക്കുന്നതു സംബന്ധിച്ച സഹായം പ്രദർശിപ്പിക്കുക',
	'coll-helppage' => 'Help:പുസ്തകം',
	'coll-load_collection' => 'പുസ്തകം ശേഖരിക്കുക',
	'coll-load_collection_tooltip' => 'താങ്കളുടെ ഇപ്പോഴത്തെ പുസ്തകമായി ഈ പുസ്തകം എടുക്കുക',
	'coll-n_pages' => '{{PLURAL:$1|ഒരു താൾ|$1 താളുകൾ}}',
	'coll-printable_version_pdf' => 'പി.ഡി.എഫ്. പതിപ്പ്',
	'coll-remove_this_page' => 'ഈ താൾ താങ്കളുടെ പുസ്തകത്തിൽ നിന്നും നീക്കുക',
	'coll-remove_page_tooltip' => 'താങ്കളുടെ പുസ്തകത്തിൽ നിന്നും ഇപ്പോഴത്തെ വിക്കി താൾ നീക്കംചെയ്യുക',
	'coll-show_collection' => 'പുസ്തകം പ്രദർശിപ്പിക്കുക',
	'coll-show_collection_tooltip' => 'തിരുത്തുവാൻ/ഡൗൺലോഡ് ചെയ്യാൻ/താങ്കളുടെ പുസ്തകം ആവശ്യപ്പെടാൻ ഞെക്കുക',
	'coll-not_addable' => 'ഈ താൾ കൂട്ടിച്ചേർക്കാൻ കഴിയില്ല',
	'coll-make_suggestions' => 'താളുകൾ നിർദ്ദേശിക്കുക',
	'coll-make_suggestions_tooltip' => 'താങ്കളുടെ പുസ്തകത്തിനനുസരിച്ചുള്ള നിർദ്ദേശങ്ങൾ മുന്നോട്ട് വെയ്ക്കുക',
	'coll-suggest_empty' => 'ശൂന്യം',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'coll-n_pages' => '$1 {{PLURAL:$1|хуудас}}',
);

/** Marathi (मराठी)
 * @author Kaajawa
 * @author Kaustubh
 * @author Rahuldeshmukh101
 * @author Sankalpdravid
 */
$messages['mr'] = array(
	'coll-print_export' => 'छापा/ निर्यात करा',
	'coll-create_a_book' => 'मी गोळा केलेली पाने',
	'coll-create_a_book_tooltip' => 'ग्रंथ बनवा अथवा पृष्ठांचे संकलन करा',
	'coll-book_creator' => 'ग्रंथ निर्माण',
	'coll-download_as' => '$1 असे उतरवा',
	'coll-download_as_tooltip' => 'ह्या विकी पानाची  $1 आवृत्ती उतरवा',
	'coll-disable' => 'अक्षम करा',
	'coll-book_creator_disable' => 'ग्रंथ निर्मिती यंत्रणा अक्षम करा',
	'coll-book_creator_disable_tooltip' => 'ग्रंथ निर्मिती यंत्रणा थांबवा',
	'coll-add_linked_article' => 'दुव्यातील विकी पान आपल्या ग्रंथात समाविष्ट करा',
	'coll-remove_linked_article' => 'दुव्यातील विकी पान आपल्या ग्रंथातून वगळा.',
	'coll-add_category' => 'ह्या वर्गाचा  आपल्या ग्रंथात समावेश करा',
	'coll-add_category_tooltip' => 'ह्या वर्गातील सर्व विकी पाने आपल्या ग्रंथात जोडा',
	'coll-add_this_page' => 'ह्या पानाचा आपल्या ग्रंथात समावेश करा',
	'coll-add_page_tooltip' => 'चालू विकी पान आपल्या ग्रंथास जोडा',
	'coll-bookscategory' => 'ग्रंथ',
	'coll-clear_collection' => 'ग्रंथ कोरा करा',
	'coll-clear_collection_confirm' => 'आपण खरोखरच आपला ग्रंथ पूर्णपणे कोरा करू इच्छिता का ?',
	'coll-clear_collection_tooltip' => 'आपल्या चालू ग्रंथातून सर्व विकी पाने वगळा',
	'coll-help' => 'साहाय्य',
	'coll-help_tooltip' => 'ग्रंथ तयार करण्याविषयीचे साहाय्य पान दाखवा',
	'coll-helppage' => 'Help:ग्रंथ',
	'coll-load_collection' => 'ग्रंथ उघडा',
	'coll-load_collection_tooltip' => 'ह्या ग्रंथास आपला चालू ग्रंथ बनवा',
	'coll-n_pages' => '$1 {{PLURAL:$1|पान|पाने}}',
	'coll-printable_version_pdf' => 'पीडीएफ आवृत्ती',
	'coll-remove_this_page' => 'हे पान आपल्या ग्रंथातून वगळा',
	'coll-remove_page_tooltip' => 'चालू विकी पान आपल्या ग्रंथातून वगळा',
	'coll-show_collection' => 'ग्रंथ दाखवा',
	'coll-show_collection_tooltip' => 'आपल्या ग्रंथाचे संपादन करण्यासाठी / आपला ग्रंथ उतरवण्यासाठी/ आपल्या ग्रंथाची मागणी नोंदवण्यासाठी येथे क्लिक करा',
	'coll-not_addable' => 'हे पान जमा करता येणार नाही',
	'coll-make_suggestions' => 'पाने सुचवा',
	'coll-make_suggestions_tooltip' => 'आपल्या ग्रंथातील पानांनुसार सूचना दाखवा',
	'coll-suggest_empty' => 'रिकामे',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'coll-print_export' => 'Cetak/eksport',
	'coll-create_a_book' => 'Cipta buku',
	'coll-create_a_book_tooltip' => 'Cipta sebuah buku atau koleksi laman',
	'coll-book_creator' => 'Pencipta buku',
	'coll-download_as' => 'Muat turun sebagai $1',
	'coll-download_as_tooltip' => 'Muat turun versi $1 laman wiki ini',
	'coll-disable' => 'matikan',
	'coll-book_creator_disable' => 'Lumpuhkan pencipta buku',
	'coll-book_creator_disable_tooltip' => 'Berhenti menggunakan pencipta buku',
	'coll-add_linked_article' => 'Tambah laman wiki yang dipaut ke dalam buku anda',
	'coll-remove_linked_article' => 'Buang laman wiki yang dipaut daripada buku anda',
	'coll-add_category' => 'Tambah kategori ini ke dalam buku anda',
	'coll-add_category_tooltip' => 'Tambah kesemua laman wiki dalam kategori ini ke dalam buku anda',
	'coll-add_this_page' => 'Tambah laman ini ke dalam buku anda',
	'coll-add_page_tooltip' => 'Tambah laman wiki semasa ke dalam buku anda',
	'coll-bookscategory' => 'Buku',
	'coll-clear_collection' => 'Kosongkan buku',
	'coll-clear_collection_confirm' => 'Betulkah anda mahu mengosongkan buku anda sepenuhnya?',
	'coll-clear_collection_tooltip' => 'Buang kesemua laman wiki daripada buku semasa anda',
	'coll-help' => 'Bantuan',
	'coll-help_tooltip' => 'Tunjukkan bantuan tentang mencipta buku',
	'coll-helppage' => 'Help:Buku',
	'coll-load_collection' => 'Muat buku',
	'coll-load_collection_tooltip' => 'Muatkan buku ini sebagai buku semasa anda',
	'coll-n_pages' => '$1 laman',
	'coll-printable_version_pdf' => 'Versi PDF',
	'coll-remove_this_page' => 'Buang laman ini daripada buku anda',
	'coll-remove_page_tooltip' => 'Buang laman wiki semasa daripada buku anda',
	'coll-show_collection' => 'Tunjukkan buku',
	'coll-show_collection_tooltip' => 'Klik untuk sunting/muat turun/pesan buku anda',
	'coll-not_addable' => 'Laman ini tidak dapat ditambah',
	'coll-make_suggestions' => 'Syorkan laman',
	'coll-make_suggestions_tooltip' => 'Berikan syor berdasarkan laman dalam buku anda',
	'coll-suggest_empty' => 'kosong',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'coll-create_a_book' => 'Шкамс кинига',
	'coll-book_creator' => 'Кинигань шкиця',
	'coll-add_category' => 'Поладомс кинигазот те категориянть',
	'coll-bookscategory' => 'Кинигат',
	'coll-help' => 'Лезкс',
	'coll-helppage' => 'Help:Кинигат',
	'coll-show_collection' => 'Невтемс киниганть',
	'coll-suggest_empty' => 'чаво',
);

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = array(
	'coll-print_export' => 'پرینت/برون‌ریزی',
	'coll-create_a_book' => 'کتاب بساتن',
	'coll-create_a_book_tooltip' => 'یتّا کتاب یا مجموعه صفحات بساج',
	'coll-clear_collection' => 'پاک هاکردن کتاب',
	'coll-clear_collection_confirm' => 'شما راس راسی خانّی کتاب ره کلأ حذف هاکنین؟',
	'coll-clear_collection_tooltip' => 'همهٔ صفحات ویکی ره شه کتاب فعلی جا حذف هاکنین',
	'coll-help' => 'راهنما',
	'coll-load_collection' => 'باربی‌یشتن کتاب',
	'coll-load_collection_tooltip' => 'این کتاب ره به عنوان کتاب فعلی بار بی‌یلین',
	'coll-show_collection' => 'هارشی‌ین کتاب',
	'coll-show_collection_tooltip' => 'شه کتاب دچی‌ین، دانلود یا سفارش وسّه کلیک هاکنین',
);

/** Nahuatl (Nāhuatl)
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'coll-bookscategory' => 'Àmoxtin',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 * @author Simny
 */
$messages['nb'] = array(
	'coll-print_export' => 'Skriv ut / eksporter',
	'coll-create_a_book' => 'Opprett en bok',
	'coll-create_a_book_tooltip' => 'Lag ei bok eller en artikkelsamling',
	'coll-book_creator' => 'Bokskaper',
	'coll-download_as' => 'Last ned som $1',
	'coll-download_as_tooltip' => 'Last ned denne wikisida i $1-format',
	'coll-disable' => 'slå av',
	'coll-book_creator_disable' => 'Slå av bokskaper',
	'coll-book_creator_disable_tooltip' => 'Stopp å bruke bokskaperen',
	'coll-add_linked_article' => 'Legg lenket wikiside til din bok',
	'coll-remove_linked_article' => 'Fjern lenket wikiside fra din bok',
	'coll-add_category' => 'Legg til denne kategorien i boka di',
	'coll-add_category_tooltip' => 'Legg til alle wikisider i denne kategorien til din bok',
	'coll-add_this_page' => 'Legg til denne siden i boka di',
	'coll-add_page_tooltip' => 'Legg til den nåværende wikisiden i din bok',
	'coll-bookscategory' => 'Bøker',
	'coll-clear_collection' => 'Tøm bok',
	'coll-clear_collection_confirm' => 'Vil du virkelig tømme boka?',
	'coll-clear_collection_tooltip' => 'Fjern alle wikisider fra din nåværende bok',
	'coll-help' => 'Hjelp',
	'coll-help_tooltip' => 'Få hjelp med å lage bøker',
	'coll-helppage' => 'Help:Bøker',
	'coll-load_collection' => 'Last bok',
	'coll-load_collection_tooltip' => 'Last denne boka som din nåværende bok',
	'coll-n_pages' => '$1 {{PLURAL:$1|side|sider}}',
	'coll-printable_version_pdf' => 'PDF-versjon',
	'coll-remove_this_page' => 'Fjern denne siden fra boka di',
	'coll-remove_page_tooltip' => 'Fjern den nåværende wikisiden fra din bok',
	'coll-show_collection' => 'Vis bok',
	'coll-show_collection_tooltip' => 'Trykk for å endre/laste ned/bestille din bok',
	'coll-not_addable' => 'Denne siden kan ikke legges til',
	'coll-make_suggestions' => 'Foreslå sider',
	'coll-make_suggestions_tooltip' => 'Vis forslag basert på sidene i boken din',
	'coll-suggest_empty' => 'tom',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'coll-create_a_book' => 'Book opstellen',
	'coll-download_as' => 'As $1 dalladen',
	'coll-add_category' => 'Kategorie tofögen',
	'coll-add_category_tooltip' => 'All Wikisieden ut disse Kategorie to dien Book tofögen',
	'coll-add_page_tooltip' => 'Disse Wikisied to dien Book tofögen',
	'coll-bookscategory' => 'Böker',
	'coll-clear_collection' => 'Book leddigmaken',
	'coll-clear_collection_confirm' => 'Wullt du dien Book worraftig leddig maken?',
	'coll-clear_collection_tooltip' => 'All Wikisieden ut dien Book rutnehmen',
	'coll-helppage' => 'Help:Böker',
	'coll-load_collection' => 'Book laden',
	'coll-load_collection_tooltip' => 'Dit Book as dien aktuell Book laden',
	'coll-n_pages' => '$1 {{PLURAL:$1|Sied|Sieden}}',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-remove_page_tooltip' => 'Disse Wikisied ut dien Book rutnehmen',
	'coll-show_collection' => 'Book wiesen',
	'coll-show_collection_tooltip' => 'Klick hier, dat du dien Book ännern/dalladen/bestellen kannst',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'coll-create_a_book' => 'Boek maken',
	'coll-download_as' => 'Binnenhaolen as $1',
	'coll-add_category' => 'Kategorie bie joew boek doon',
	'coll-bookscategory' => 'Boeken',
	'coll-helppage' => 'Help:Boeken',
	'coll-load_collection' => 'Boek laojen',
	'coll-n_pages' => "$1 {{PLURAL:$1|pagina|pagina's}}",
	'coll-printable_version_pdf' => 'PDF-versie',
	'coll-show_collection' => 'Boek laoten zien',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Romaine
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'coll-print_export' => 'Afdrukken/exporteren',
	'coll-create_a_book' => 'Boek maken',
	'coll-create_a_book_tooltip' => 'Boek of paginacollectie',
	'coll-book_creator' => 'Boekenmaker',
	'coll-download_as' => 'Downloaden als $1',
	'coll-download_as_tooltip' => 'Een $1-versie van deze wikipagina downloaden',
	'coll-disable' => 'uitschakelen',
	'coll-book_creator_disable' => 'Boekenmaker uitschakelen',
	'coll-book_creator_disable_tooltip' => 'Boekenmaker niet meer gebruiken',
	'coll-add_linked_article' => 'De gekoppelde wikipagina aan uw boek toevoegen',
	'coll-remove_linked_article' => 'De gekoppelde wikipagina uit uw boek verwijderen',
	'coll-add_category' => 'Deze categorie aan uw boek toevoegen',
	'coll-add_category_tooltip' => "Alle pagina's in deze categorie aan uw boek toevoegen",
	'coll-add_this_page' => 'Deze pagina aan uw boek toevoegen',
	'coll-add_page_tooltip' => 'De huidige wikipagina aan uw boek toevoegen',
	'coll-bookscategory' => 'Boeken',
	'coll-clear_collection' => 'Boek leegmaken',
	'coll-clear_collection_confirm' => 'Wilt u uw boek werkelijk leegmaken?',
	'coll-clear_collection_tooltip' => "Alle pagina's uit uw huidige boek verwijderen",
	'coll-help' => 'Hulp',
	'coll-help_tooltip' => 'Hulp bij het maken van boeken',
	'coll-helppage' => 'Help:Boeken',
	'coll-load_collection' => 'Boek laden',
	'coll-load_collection_tooltip' => 'Dit boek als uw huidige boek laden',
	'coll-n_pages' => "$1 {{PLURAL:$1|pagina|pagina's}}",
	'coll-printable_version_pdf' => 'PDF-versie',
	'coll-remove_this_page' => 'Deze pagina uit uw boek verwijderen',
	'coll-remove_page_tooltip' => 'De huidige wikipagina uit uw boek verwijderen',
	'coll-show_collection' => 'Boek weergeven',
	'coll-show_collection_tooltip' => 'Klik om uw boek te bewerken/downloaden/bestellen',
	'coll-not_addable' => 'Deze pagina kan niet toegevoegd worden',
	'coll-make_suggestions' => "Pagina's suggereren",
	'coll-make_suggestions_tooltip' => "Suggesties weergeven op basis van de pagina's in uw boek",
	'coll-suggest_empty' => 'leegmaken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'coll-print_export' => 'Skriv ut / eksporter',
	'coll-create_a_book' => 'Opprett ei bok',
	'coll-create_a_book_tooltip' => 'Lag ei bok eller ei artikkelsamling',
	'coll-book_creator' => 'laging av bok',
	'coll-download_as' => 'Last ned som $1',
	'coll-download_as_tooltip' => 'Last ned denne wikisida i $1-format',
	'coll-disable' => 'slå av',
	'coll-book_creator_disable' => 'Slå av funksjonen for å laga bok',
	'coll-book_creator_disable_tooltip' => 'Stopp å bruka funksjonen for å laga bok',
	'coll-add_category' => 'Legg til denne kategorien i boka di',
	'coll-add_category_tooltip' => 'Legg til alle sidene i denne kategorien til boka di',
	'coll-add_this_page' => 'Legg til denne sida i boka di',
	'coll-add_page_tooltip' => 'Legg til den noverande wikisida til boka di',
	'coll-bookscategory' => 'Bøker',
	'coll-clear_collection' => 'Tøm bok',
	'coll-clear_collection_confirm' => 'Vil du verkeleg fjerna alle sidene i boka di?',
	'coll-clear_collection_tooltip' => 'Fjern alle wikisider frå den noverande boka di',
	'coll-help' => 'Hjelp',
	'coll-help_tooltip' => 'Få hjelp med å laga bøker',
	'coll-helppage' => 'Help:Bøker',
	'coll-load_collection' => 'Last bok',
	'coll-load_collection_tooltip' => 'Last denne boka som den noverande boka di',
	'coll-n_pages' => '{{PLURAL:$1|éi sida|$1 sider}}',
	'coll-printable_version_pdf' => 'PDF-versjon',
	'coll-remove_this_page' => 'Fjern denne sida frå boka di',
	'coll-remove_page_tooltip' => 'Fjern den noverande wikisida frå boka di',
	'coll-show_collection' => 'Vis bok',
	'coll-show_collection_tooltip' => 'Trykk for å endra/lasta ned/tinga boka di',
	'coll-not_addable' => 'Denne sida kunne ikkje leggjast til',
	'coll-make_suggestions' => 'Framlegg til sider',
	'coll-make_suggestions_tooltip' => 'Syn framlegg på grunnlag av sidene i boka di',
	'coll-suggest_empty' => 'tom',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'coll-print_export' => 'Estampar / exportar',
	'coll-create_a_book' => 'Crear un libre',
	'coll-create_a_book_tooltip' => 'Crear un libre o una colleccion d’articles',
	'coll-book_creator' => 'Creator de libres',
	'coll-download_as' => 'Telecargat coma $1',
	'coll-download_as_tooltip' => "Telecarga una version $1 d'aquesta pagina wiki",
	'coll-disable' => 'desactivar',
	'coll-book_creator_disable' => 'Desactivar lo creator de libre',
	'coll-book_creator_disable_tooltip' => "Quitar d'utilizar lo creator de libre",
	'coll-add_linked_article' => 'Apondre la pagina wiki ligada a vòstre libre',
	'coll-remove_linked_article' => 'Levar la pagina ligada de vòstre libre',
	'coll-add_category' => 'Apondre una categoria a vòstre libre',
	'coll-add_category_tooltip' => "Apondre totes los articles d'aquesta categoria a vòstre libre",
	'coll-add_this_page' => 'Apondre aquesta pagina a vòstre libre',
	'coll-add_page_tooltip' => 'Apondre la pagina correnta a vòstre libre',
	'coll-bookscategory' => 'Libres',
	'coll-clear_collection' => 'Voidar lo libre',
	'coll-clear_collection_confirm' => 'Sètz segur que volètz escafar l’integralitat de vòstre libre ?',
	'coll-clear_collection_tooltip' => 'Levar totes los articles de vòstre libre actual',
	'coll-help' => 'Ajuda',
	'coll-help_tooltip' => "Afichar l'ajuda sus la creacion de libres",
	'coll-helppage' => 'Help:Libres',
	'coll-load_collection' => 'Cargar un libre',
	'coll-load_collection_tooltip' => 'Cargar aqueste libre en tant que vòstre libre actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagina|paginas}}',
	'coll-printable_version_pdf' => 'Version del PDF',
	'coll-remove_this_page' => 'Levar aquesta pagina de vòstre libre',
	'coll-remove_page_tooltip' => 'Levar la pagina correnta de vòstre libre',
	'coll-show_collection' => 'Afichar lo libre',
	'coll-show_collection_tooltip' => 'Clicatz per modificar / telecargar / comandar vòstre libre',
	'coll-not_addable' => 'Aquesta pagina pòt pas èsser aponduda',
	'coll-make_suggestions' => 'Suggerir de paginas',
	'coll-make_suggestions_tooltip' => 'Far veire las suggestions fondadas sus las paginas dins vòstre libre',
	'coll-suggest_empty' => 'void',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 * @author Jnanaranjan Sahu
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'coll-print_export' => 'ପ୍ରିଣ୍ଟ/ରପ୍ତାନି',
	'coll-create_a_book' => 'ବହି ତିଆରି କରିବେ',
	'coll-create_a_book_tooltip' => 'ଏକ ବହି ବା ପୃଷ୍ଠା ସଙ୍କଳନ ଗଢ଼ିବେ',
	'coll-book_creator' => 'ବହି ଗଢ଼ାଳି',
	'coll-download_as' => '$1 ଭାବରେ ଡାଉନଲୋଡ଼ କରିବେ',
	'coll-download_as_tooltip' => 'ଏକ $1 ସଂସ୍କରଣ ଏହି ଉଇକିରେ ଡାଉନଲୋଡ଼ କରିବେ',
	'coll-disable' => 'ଅଚଳ କରିଦିଆଯାଇଛି',
	'coll-book_creator_disable' => 'ବହି ଗଢ଼ାଳି ଅକାଳ କରାଇବେ',
	'coll-book_creator_disable_tooltip' => 'ବହି ନିର୍ମାତା ବ୍ୟବହାର କରିବା ବନ୍ଦ କରନ୍ତୁ',
	'coll-add_linked_article' => 'ଲିଙ୍କ୍ ଥିବା ଉଇକି ପୃଷ୍ଠାକୁ ଆପଣଙ୍କ ବହିରେ ଯୋଡନ୍ତୁ',
	'coll-remove_linked_article' => 'ଲିଙ୍କ ଥିବା ଉଇକି ପୃଷ୍ଠାକୁ ହଟାଇବେ',
	'coll-add_category' => 'ଏହି ଶ୍ରେଣୀକୁ ଆପଣଙ୍କ ବହିରେ ଯୋଡ଼ନ୍ତୁ',
	'coll-add_category_tooltip' => 'ଏହି ବିଭାଗରେ ଥିବା ସମସ୍ତ ଉଇକିପୃଷ୍ଠାକୁ ଆପଣଙ୍କ ବହିରେ ଯୋଡନ୍ତୁ',
	'coll-add_this_page' => 'ଏହି ପୃଷ୍ଠାକୁ ଆପଣଙ୍କ ବହିରେ ଯୋଡ଼ନ୍ତୁ',
	'coll-add_page_tooltip' => 'ବର୍ତମାନର ଏହି ଉଇକି ପୃଷ୍ଠାକୁ ଆପଣଙ୍କ ବହିରେ ଯୋଡ଼ନ୍ତୁ',
	'coll-bookscategory' => 'ବହି',
	'coll-clear_collection' => 'ବହି ଖାଲି କରନ୍ତୁ',
	'coll-clear_collection_confirm' => 'ଆପଣ ନିଶ୍ଚିତ ଯେ ଆପଣଙ୍କ ବହିକୁ ସମ୍ପୂର୍ଣଭାବେ ସଫା କରିବେ ?',
	'coll-clear_collection_tooltip' => 'ଆପଣଙ୍କର ବର୍ତମାନର ବହିରୁ ସମସ୍ତ ଉଇକି ପୃଷ୍ଠାଗୁଡିକୁ ହଟାଇବେ',
	'coll-help' => 'ସହଯୋଗ',
	'coll-help_tooltip' => 'ବହି ତିଆରି ବିଷୟରେ ସାହାଯ୍ୟ ଦେଖାଇବେ',
	'coll-helppage' => 'Help:ବହି',
	'coll-load_collection' => 'ଲୋଡ଼ ବହି',
	'coll-load_collection_tooltip' => 'ଏହି ବହିଟିକୁ ଆପଣଙ୍କର ଏବେକାର ବହି ଭାବେ ରଖିବେ',
	'coll-n_pages' => '$1 {{PLURAL:$1|ପୃଷ୍ଠା|ପୃଷ୍ଠାସବୁ}}',
	'coll-printable_version_pdf' => 'PDF ସଂସ୍କରଣ',
	'coll-remove_this_page' => 'ଏହି ପୃଷ୍ଠାଟିକୁ ଆପଣଙ୍କ ବହିରୁ ହଟାଇବେ',
	'coll-remove_page_tooltip' => 'ଆପଣଙ୍କ ବହିରୁ ବର୍ତମାନର ଉଇକି ପୃଷ୍ଠାକୁ ବାହାର କରିବେ',
	'coll-show_collection' => 'ବହି ଦେଖାଇବେ',
	'coll-not_addable' => 'ଏହି ପୃଷ୍ଠାଟିକୁ ଯୋଡା ଯାଇପାରିବ ନାହିଁ',
	'coll-make_suggestions' => 'ପୃଷ୍ଠାଗୁଡିକୁ ପ୍ରସ୍ତାବିତ କରିବେ',
	'coll-suggest_empty' => 'ଖାଲି',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'coll-download_as' => 'Æрбавгæн куыд $1',
	'coll-suggest_empty' => 'афтид',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'coll-download_as' => 'Runnerlaade ass $1',
	'coll-bookscategory' => 'Bicher',
	'coll-clear_collection' => 'Buch lösche',
	'coll-help' => 'Hilf',
	'coll-helppage' => 'Help:Bicher',
	'coll-load_collection' => 'Buch laade',
	'coll-n_pages' => '$1 {{PLURAL:$1|Blatt|Bledder}}',
	'coll-printable_version_pdf' => 'PDF-Version',
	'coll-suggest_empty' => 'leer',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Masti
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'coll-print_export' => 'Drukuj lub eksportuj',
	'coll-create_a_book' => 'Utwórz książkę',
	'coll-create_a_book_tooltip' => 'Tworzenie książki lub kolekcji stron',
	'coll-book_creator' => 'Tworzenie książki',
	'coll-download_as' => 'Pobierz jako $1',
	'coll-download_as_tooltip' => 'Pobierz wersję $1 tej strony wiki',
	'coll-disable' => 'wyłącz',
	'coll-book_creator_disable' => 'Wyłącz tworzenie książek',
	'coll-book_creator_disable_tooltip' => 'Wyłącz kreatora tworzenia książki',
	'coll-add_linked_article' => 'Dodaj linkowaną stronę wiki do mojej książki',
	'coll-remove_linked_article' => 'Usuń linkowaną stronę wiki z mojej książki',
	'coll-add_category' => 'Dodaj tę kategorię do książki',
	'coll-add_category_tooltip' => 'Dodaj wszystkie strony wiki znajdujące się w tej kategorii do książki',
	'coll-add_this_page' => 'Dodaj tę stronę do książki',
	'coll-add_page_tooltip' => 'Dodaj bieżącą stronę wiki do książki',
	'coll-bookscategory' => 'Książki',
	'coll-clear_collection' => 'Wyczyść książkę',
	'coll-clear_collection_confirm' => 'Czy jesteś pewien, że chcesz wyczyścić całą zawartość książki?',
	'coll-clear_collection_tooltip' => 'Usuń wszystkie strony wiki z bieżącej książki',
	'coll-help' => 'Pomoc',
	'coll-help_tooltip' => 'Pokaż pomoc na temat tworzenia książek',
	'coll-helppage' => 'Help:Książki',
	'coll-load_collection' => 'Załaduj książkę',
	'coll-load_collection_tooltip' => 'Załaduj tę książkę jako bieżącą',
	'coll-n_pages' => '$1 {{PLURAL:$1|strona|strony|stron}}',
	'coll-printable_version_pdf' => 'Wersja PDF',
	'coll-remove_this_page' => 'Usuń tę stronę z książki',
	'coll-remove_page_tooltip' => 'Usuń bieżącą stronę wiki z książki',
	'coll-show_collection' => 'Pokaż książkę',
	'coll-show_collection_tooltip' => 'Kliknij aby edytować, pobrać lub zamówić książkę',
	'coll-not_addable' => 'Tej strony nie można dodać',
	'coll-make_suggestions' => 'Proponowane strony',
	'coll-make_suggestions_tooltip' => 'Pokaż propozycje na podstawie już dodanych stron',
	'coll-suggest_empty' => 'puste',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'coll-print_export' => 'Stampa/espòrta',
	'coll-create_a_book' => 'Crea un lìber',
	'coll-create_a_book_tooltip' => 'Crea un lìber o na colession ëd pàgine',
	'coll-book_creator' => 'Creator ëd lìber',
	'coll-download_as' => 'Dëscaria com $1',
	'coll-download_as_tooltip' => 'Dëscaria na version $1 dë sta pàgina wiki-sì',
	'coll-disable' => 'Disabìlita',
	'coll-book_creator_disable' => 'Disabìlita ël creator ëd lìber',
	'coll-book_creator_disable_tooltip' => 'Deuvra pi nen ël creator ëd lìber',
	'coll-add_linked_article' => 'Gionta na pàgina colegà wiki a tò lìber',
	'coll-remove_linked_article' => 'Gava na pàgina colegà wiki da tò lìber',
	'coll-add_category' => 'Gionta sta categorìa-sì a tò lìber',
	'coll-add_category_tooltip' => 'Gionta tute le pàgine wiki an sta categorìa-sì a tò lìber',
	'coll-add_this_page' => 'Gionta sta pàgina-sì a tò lìber',
	'coll-add_page_tooltip' => 'Gionta la pàgina wiki corenta a tò lìber',
	'coll-bookscategory' => 'Lìber',
	'coll-clear_collection' => 'Scancela lìber',
	'coll-clear_collection_confirm' => 'It veule da bon scancelé completament tò lìber?',
	'coll-clear_collection_tooltip' => 'Gava tute le pàgine wiki da tò lìber corent',
	'coll-help' => 'Agiut',
	'coll-help_tooltip' => "Mostra l'agiut për creé lìber",
	'coll-helppage' => 'Help:Lìber',
	'coll-load_collection' => 'Caria lìber',
	'coll-load_collection_tooltip' => 'Caria sto lìber-sì com tò lìber corent',
	'coll-n_pages' => '$1 {{PLURAL:$1|pàgina|pàgine}}',
	'coll-printable_version_pdf' => 'Version PDF',
	'coll-remove_this_page' => 'Gava sta pàgina-sì da tò lìber',
	'coll-remove_page_tooltip' => 'Gava la pàgina wiki corenta da tò lìber',
	'coll-show_collection' => 'Mostra lìber',
	'coll-show_collection_tooltip' => 'Sgnaca për modifiché/dëscarié/ordiné tò lìber',
	'coll-not_addable' => 'Sta pàgina-sì a peul pa esse giontà',
	'coll-make_suggestions' => 'Consèja dle pàgine',
	'coll-make_suggestions_tooltip' => 'Mostra consèj basà an sle pàgine an tò lìber',
	'coll-suggest_empty' => 'veuid',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'coll-print_export' => 'چاپول/صادرول',
	'coll-create_a_book' => 'يو کتاب جوړول',
	'coll-create_a_book_tooltip' => 'يو کتاب يا د مخونو ټولګه جوړول',
	'coll-book_creator' => 'کتاب جوړونکی',
	'coll-download_as' => 'د $1 په ډول ښکته کول',
	'coll-disable' => 'ناچارنول',
	'coll-book_creator_disable' => 'کتاب جوړونکی ناچارنول',
	'coll-add_category' => 'دا وېشنيزه په کتاب کې ورګډول',
	'coll-add_this_page' => 'دا مخ په کتاب کې ورګډول',
	'coll-add_page_tooltip' => 'د همدې ويکي مخ خپل کتاب کې ورګډول',
	'coll-bookscategory' => 'کتابونه',
	'coll-clear_collection' => 'کتاب پاکول',
	'coll-help' => 'لارښود',
	'coll-helppage' => 'Help:کتابونه',
	'coll-load_collection' => 'کتاب برسېرول',
	'coll-n_pages' => '$1 {{PLURAL:$1|مخ|مخونه}}',
	'coll-printable_version_pdf' => 'د PDF په بڼه',
	'coll-remove_this_page' => 'دا مخ له کتاب نه ليرې کول',
	'coll-show_collection' => 'کتاب ښکاره کول',
	'coll-not_addable' => 'دا مخ نشي ورګډېدلی',
	'coll-make_suggestions' => 'مخونه وړانديزول',
	'coll-suggest_empty' => 'تش',
);

/** Portuguese (Português)
 * @author 555
 * @author Crazymadlover
 * @author Giro720
 * @author Hamilton Abreu
 * @author Indech
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'coll-print_export' => 'Imprimir/exportar',
	'coll-create_a_book' => 'Criar um livro',
	'coll-create_a_book_tooltip' => 'Cria um livro ou uma colecção de páginas',
	'coll-book_creator' => 'Criador de livros',
	'coll-download_as' => 'Descarregar como $1',
	'coll-download_as_tooltip' => 'Descarregar uma versão $1 desta página wiki',
	'coll-disable' => 'desactivar',
	'coll-book_creator_disable' => 'Desactivar criador de livros',
	'coll-book_creator_disable_tooltip' => 'Terminar de usar o criador de livros',
	'coll-add_linked_article' => 'Adicionar ao livro a página wiki ligada',
	'coll-remove_linked_article' => 'Remover do livro a página wiki ligada',
	'coll-add_category' => 'Adicionar categoria ao seu livro',
	'coll-add_category_tooltip' => 'Adicionar todas as páginas wiki nesta categoria ao seu livro',
	'coll-add_this_page' => 'Adicionar esta página ao seu livro',
	'coll-add_page_tooltip' => 'Adicionar a página wiki actual ao seu livro',
	'coll-bookscategory' => 'Livros',
	'coll-clear_collection' => 'Esvaziar livro',
	'coll-clear_collection_confirm' => 'Deseja realmente limpar completamente o seu livro?',
	'coll-clear_collection_tooltip' => 'Remover todas as páginas wiki do seu livro actual',
	'coll-help' => 'Ajuda',
	'coll-help_tooltip' => 'Mostrar ajuda sobre criação de livros',
	'coll-helppage' => 'Help:Livros',
	'coll-load_collection' => 'Carregar livro',
	'coll-load_collection_tooltip' => 'Carregar este livro como o seu livro actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'coll-printable_version_pdf' => 'Versão em PDF',
	'coll-remove_this_page' => 'Remover esta página do seu livro',
	'coll-remove_page_tooltip' => 'Remover a página wiki actual do livro',
	'coll-show_collection' => 'Mostrar livro',
	'coll-show_collection_tooltip' => 'Clique para editar/descarregar/encomendar o livro',
	'coll-not_addable' => 'Esta página não pode ser adicionada',
	'coll-make_suggestions' => 'Sugerir páginas',
	'coll-make_suggestions_tooltip' => 'Mostrar sugestões com base nas páginas do livro',
	'coll-suggest_empty' => 'vazio',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Jorge Morais
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'coll-print_export' => 'Imprimir/exportar',
	'coll-create_a_book' => 'Criar um livro',
	'coll-create_a_book_tooltip' => 'Criar um livro ou coleção de páginas',
	'coll-book_creator' => 'Criador de livros',
	'coll-download_as' => 'Baixar como $1',
	'coll-download_as_tooltip' => 'Baixe uma versão $1 desta página wiki',
	'coll-disable' => 'desabilitar',
	'coll-book_creator_disable' => 'Desabilitar o criador de livros',
	'coll-book_creator_disable_tooltip' => 'Parar de usar o criador de livros',
	'coll-add_linked_article' => 'Adicionar ao livro a página wiki ligada',
	'coll-remove_linked_article' => 'Remover do livro a página wiki ligada',
	'coll-add_category' => 'Adicionar esta categoria ao seu livro',
	'coll-add_category_tooltip' => 'Adicionar todas as páginas wiki nesta categoria ao seu livro',
	'coll-add_this_page' => 'Adicionar esta página ao seu livro',
	'coll-add_page_tooltip' => 'Adicionar a página wiki atual ao seu livro',
	'coll-bookscategory' => 'Livros',
	'coll-clear_collection' => 'Esvaziar livro',
	'coll-clear_collection_confirm' => 'Realmente deseja esvaziar completamente o seu livro?',
	'coll-clear_collection_tooltip' => 'Remover todas as páginas wiki do seu livro atual',
	'coll-help' => 'Ajuda',
	'coll-help_tooltip' => 'Exibir ajuda sobre a criação de livros',
	'coll-helppage' => 'Help:Livros',
	'coll-load_collection' => 'Carregar livro',
	'coll-load_collection_tooltip' => 'Carregar este livro como o seu livro atual',
	'coll-n_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'coll-printable_version_pdf' => 'Versão em PDF',
	'coll-remove_this_page' => 'Remover esta página do seu livro',
	'coll-remove_page_tooltip' => 'Remover a página wiki atual do seu livro',
	'coll-show_collection' => 'Mostrar livro',
	'coll-show_collection_tooltip' => 'Clique para editar/baixar/encomendar o seu livro',
	'coll-not_addable' => 'Esta página não pode ser adicionada',
	'coll-make_suggestions' => 'Sugerir páginas',
	'coll-make_suggestions_tooltip' => 'Mostrar sugestões baseadas nas páginas do seu livro',
	'coll-suggest_empty' => 'vazio',
);

/** Romansh (Rumantsch)
 * @author Gion-andri
 */
$messages['rm'] = array(
	'coll-print_export' => 'Stampar/exportar',
	'coll-create_a_book' => 'Crear in cudesch',
	'coll-create_a_book_tooltip' => 'Crear in cudesch u ina collecziun dad artitgels',
	'coll-book_creator' => 'Generatur da cudeschs',
	'coll-download_as' => 'Telechargiar sco $1',
	'coll-download_as_tooltip' => 'Telechargiar ina versiun da $1 da questa pagina da wiki',
	'coll-disable' => 'deactivar',
	'coll-book_creator_disable' => 'Deactivar il generatur da cudeschs',
	'coll-book_creator_disable_tooltip' => 'Chalar dad utilisar il generatur da cudeschs',
	'coll-add_linked_article' => 'Agiuntar la pagina da wiki colliada a tes cudesch',
	'coll-remove_linked_article' => 'Allontanar la pagina da wiki colliada da tes cudesch',
	'coll-add_category' => 'Agiuntar questa categoria a tes cudesch',
	'coll-add_category_tooltip' => 'Agiuntar tut las paginas da wiki en questa categoria a tes cudesch',
	'coll-add_this_page' => 'Agiuntar questa pagina a tes cudesch',
	'coll-add_page_tooltip' => 'Agiuntar la pagina da wiki actuala a tes cudesch',
	'coll-bookscategory' => 'Cudeschs',
	'coll-clear_collection' => 'Stizzar il cudesch',
	'coll-clear_collection_confirm' => 'Vuls ti propi stizzar cumplettamain tes cudesch?',
	'coll-clear_collection_tooltip' => 'Allontanar tut las paginas da wiki ord tes cudesch actual',
	'coll-help' => 'Agid',
	'coll-help_tooltip' => "Mussar l'agid davart il crear cudeschs",
	'coll-helppage' => 'Help:Cudeschs',
	'coll-load_collection' => 'Chargiar in cudesch',
	'coll-load_collection_tooltip' => 'Chargiar quest cudesch sco cudesch actual',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagina|paginas}}',
	'coll-printable_version_pdf' => 'Versiun da PDF',
	'coll-remove_this_page' => 'Allontanar questa pagina da tes cudesch',
	'coll-remove_page_tooltip' => 'Allontanar la pagina da wiki actuala da tes cudesch',
	'coll-show_collection' => 'Mussar il cudesch',
	'coll-show_collection_tooltip' => 'Cliccar per modifitgar/telechargiar/empustar tes cudesch',
	'coll-not_addable' => 'Questa pagina na po betg vegnir agiuntada',
	'coll-make_suggestions' => 'Proponer paginas',
	'coll-make_suggestions_tooltip' => 'Mussar propostas che sa basan sin las paginas en tes cudesch',
	'coll-suggest_empty' => 'vid',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 * @author Stelistcristi
 * @author Strainu
 */
$messages['ro'] = array(
	'coll-print_export' => 'Tipărire/exportare',
	'coll-create_a_book' => 'Creare carte',
	'coll-create_a_book_tooltip' => 'Crearea unei cărți sau a unei colecții de pagini',
	'coll-book_creator' => 'Creator de cărți',
	'coll-download_as' => 'Descarcă $1',
	'coll-download_as_tooltip' => 'Descărcați o versiune $1 a acestei pagini wiki',
	'coll-disable' => 'dezactivează',
	'coll-book_creator_disable' => 'Dezactivează creatorul de cărți',
	'coll-book_creator_disable_tooltip' => 'Nu mai folosiți creatorul de cărți',
	'coll-add_linked_article' => 'Adăugați pagina indicată în cartea dumneavoastră',
	'coll-remove_linked_article' => 'Eliminați pagina indicată din cartea dumneavoastră',
	'coll-add_category' => 'Adăugați această categorie în cartea dumneavoastră',
	'coll-add_category_tooltip' => 'Adăugați toate paginile din această categorie în cartea dumneavoastră',
	'coll-add_this_page' => 'Adăugați această pagină în cartea dumneavoastră',
	'coll-add_page_tooltip' => 'Adăugați pagina curentă în cartea dumneavoastră',
	'coll-bookscategory' => 'Cărți',
	'coll-clear_collection' => 'Golește cartea',
	'coll-clear_collection_confirm' => 'Doriți să goliți complet cartea dumneavoastră?',
	'coll-clear_collection_tooltip' => 'Eliminarea tuturor paginilor din cartea curentă',
	'coll-help' => 'Ajutor',
	'coll-help_tooltip' => 'Afișarea ajutorului despre crearea cărților',
	'coll-helppage' => 'Help:Cărți',
	'coll-load_collection' => 'Încărcare carte',
	'coll-load_collection_tooltip' => 'Încărcați cartea de față ca actuala dumneavoastră carte',
	'coll-n_pages' => '$1 {{PLURAL:$1|pagină|pagini|de pagini}}',
	'coll-printable_version_pdf' => 'Versiune PDF',
	'coll-remove_this_page' => 'Eliminați această pagină din cartea dumneavoastră',
	'coll-remove_page_tooltip' => 'Eliminarea paginii actuale din cartea dumneavoastră',
	'coll-show_collection' => 'Arată cartea',
	'coll-show_collection_tooltip' => 'Apăsați pentru a modifica/descărca/comanda cartea dumneavoastră',
	'coll-not_addable' => 'Această pagină nu poate fi adăugată',
	'coll-make_suggestions' => 'Sugerează pagini',
	'coll-make_suggestions_tooltip' => 'Afișează sugestii bazate pe conținutul cărții dumneavoastră',
	'coll-suggest_empty' => 'fără conținut',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'coll-print_export' => 'Stambe/esporte',
	'coll-create_a_book' => "Ccreje 'nu libbre",
	'coll-create_a_book_tooltip' => "Creje 'na colleziune de libbre o de pagene",
	'coll-book_creator' => 'Ccrejatore de libbre',
	'coll-download_as' => 'Scareche cumme $1',
	'coll-download_as_tooltip' => "Scareche 'na $1 versione de sta pàgene de Uicchi",
	'coll-disable' => 'disabbilete',
	'coll-book_creator_disable' => "Disabilite 'u crijatore de libbre",
	'coll-book_creator_disable_tooltip' => "Lasse stà de ausà 'u crijatore de libbre",
	'coll-add_linked_article' => "Aggiunge pagene uicchi cullegate pè 'u libbre toje",
	'coll-remove_linked_article' => "Live le pàggene de Uicchi collegate da 'u libbre tune",
	'coll-add_category' => "Aggiunge sta categorije jndr'à 'u libbre tue",
	'coll-add_category_tooltip' => "Aggiunge tutte le pàgene de sta categorije jndr'à 'u libbre tune",
	'coll-add_this_page' => "Aggiunge sta pàgene a 'u libbre tune",
	'coll-add_page_tooltip' => "Aggiunge 'a pàgene de sta Uicchi a 'u libbre tune",
	'coll-bookscategory' => 'Libbre',
	'coll-clear_collection' => "Pulizze 'u libbre",
	'coll-clear_collection_confirm' => "Avveramende vuè ccu sdevaghe combletamende 'u libbre tune?",
	'coll-clear_collection_tooltip' => "Live tutte le pàòggene de uicchi da 'u libbre tune",
	'coll-help' => 'Aijute',
	'coll-help_tooltip' => "Fa vedè l'aijute pa ccreazione de le libbre",
	'coll-helppage' => 'Help:Libbre',
	'coll-load_collection' => "Careche 'nu libbre",
	'coll-load_collection_tooltip' => "Careche quiste libbre cumme 'u toje libbre in curse",
	'coll-n_pages' => '$1 {{PLURAL:$1|pàgene|pàggene}}',
	'coll-printable_version_pdf' => 'Versione in PDF',
	'coll-remove_this_page' => "Live sta pàgene da 'u libbre tune",
	'coll-remove_page_tooltip' => "Live sta pàgene de Uicchi da 'u libbre tune",
	'coll-show_collection' => "Fà vedè 'nu libbre",
	'coll-show_collection_tooltip' => "Cazze sus a cange/scareche/ordene 'u libbre tune",
	'coll-not_addable' => 'Sta pàgene non ge se pò essere aggiunde',
	'coll-make_suggestions' => 'Pàggene suggerite',
	'coll-make_suggestions_tooltip' => "Fà vedè le suggereminde ca se basane sus a le pàggene d'u libbre tune",
	'coll-suggest_empty' => 'vacande',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Ferrer
 * @author Kaganer
 * @author Putnik
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'coll-print_export' => 'Печать/экспорт',
	'coll-create_a_book' => 'Создать книгу',
	'coll-create_a_book_tooltip' => 'Создать книгу или коллекцию статей',
	'coll-book_creator' => 'Создание книги',
	'coll-download_as' => 'Скачать как $1',
	'coll-download_as_tooltip' => 'Скачать $1-версию этой вики-страницы',
	'coll-disable' => 'выключить',
	'coll-book_creator_disable' => 'Отключить книжного мастера',
	'coll-book_creator_disable_tooltip' => 'Прекратите использование книжного мастера',
	'coll-add_linked_article' => 'Добавить связанную вики-страницу в вашу книгу',
	'coll-remove_linked_article' => 'Удалить связанную вики-страницу из вашей книги',
	'coll-add_category' => 'Добавить эту категорию в вашу книгу',
	'coll-add_category_tooltip' => 'Добавить все вики-страницы этой категории в книгу',
	'coll-add_this_page' => 'Добавить эту страницу в вашу книгу',
	'coll-add_page_tooltip' => 'Добавить текущую вики-страницу в книгу',
	'coll-bookscategory' => 'Книги',
	'coll-clear_collection' => 'Очистить книгу',
	'coll-clear_collection_confirm' => 'Вы действительно желаете полностью очистить вашу книгу?',
	'coll-clear_collection_tooltip' => 'Удалите все вики-страницы из текущей книги',
	'coll-help' => 'Справка',
	'coll-help_tooltip' => 'Показать справку по созданию книг',
	'coll-helppage' => 'Help:Книги',
	'coll-load_collection' => 'Загрузить книгу',
	'coll-load_collection_tooltip' => 'Загрузить эту книгу как вашу текущую книгу',
	'coll-n_pages' => '$1 {{PLURAL:$1|страница|страницы|страниц}}',
	'coll-printable_version_pdf' => 'PDF-версия',
	'coll-remove_this_page' => 'Удалить эту страницу из вашей книги',
	'coll-remove_page_tooltip' => 'Удалить текущую вики-страницу из книги',
	'coll-show_collection' => 'Показать книгу',
	'coll-show_collection_tooltip' => 'Нажмите для редактирования/загрузки/заказа книги',
	'coll-not_addable' => 'Данная страница не может быть добавлена',
	'coll-make_suggestions' => 'Предлагаемые страницы',
	'coll-make_suggestions_tooltip' => 'Показать предложения, основанные на существующих страницах вашей книги',
	'coll-suggest_empty' => 'пуста',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'coll-print_export' => 'Друк/експорт',
	'coll-create_a_book' => 'Створїня книгы',
	'coll-create_a_book_tooltip' => 'Створити книгу або колекцію сторінок',
	'coll-book_creator' => 'Едітор книг',
	'coll-download_as' => 'Скачати як $1',
	'coll-download_as_tooltip' => 'Скачати тоту сторінку вікі як $1',
	'coll-disable' => 'выпнути',
	'coll-book_creator_disable' => 'выпнути едітор книг',
	'coll-book_creator_disable_tooltip' => 'Перестане хоснованя едітора книг',
	'coll-add_linked_article' => 'Придати одказовану сторінку вікі до книгы',
	'coll-remove_linked_article' => 'Одобрати одказовану сторінку вікі з книгы',
	'coll-add_category' => 'Придати тоту катеґорію до вашой книгы',
	'coll-add_category_tooltip' => 'Придати вшыткы сторінкы вікі у тій катеґорії до вашой книгы',
	'coll-add_this_page' => 'Придати тоту сторінку до вашой книгы',
	'coll-add_page_tooltip' => 'Придати актуалну вікі-сторінку до вашой книгы',
	'coll-bookscategory' => 'Книгы',
	'coll-clear_collection' => 'Очістити книгу',
	'coll-clear_collection_confirm' => 'Вы на певно хочете цілком очістити вашу книгу?',
	'coll-clear_collection_tooltip' => 'Одстранити з актуалной книгы вшыткы сторінкы вікі',
	'coll-help' => 'Поміч',
	'coll-help_tooltip' => 'Указати поміч про творбу книг',
	'coll-helppage' => 'Help:Книгы',
	'coll-load_collection' => 'Начітати книгу',
	'coll-load_collection_tooltip' => 'Зволити тоту книгу як актуалну',
	'coll-n_pages' => '$1 {{PLURAL:$1|сторінка|сторінкы|сторінок}}',
	'coll-printable_version_pdf' => 'PDF-верзія',
	'coll-remove_this_page' => 'Одобрати тоту сторінку з вашой книгы',
	'coll-remove_page_tooltip' => 'Одстранити актуалну сторінку з вашой книгы',
	'coll-show_collection' => 'Указати книгу',
	'coll-show_collection_tooltip' => 'Клікнутём собі можете книгу управити/скачати/обїднати',
	'coll-not_addable' => 'Тота сторінка не може быти придана',
	'coll-make_suggestions' => 'Запропоновати сторінкы',
	'coll-make_suggestions_tooltip' => 'Указати пропозіції подля сторінок приданых до вашой книгы',
	'coll-suggest_empty' => 'порожня',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'coll-help' => 'साहाय्यम्',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'coll-print_export' => 'Бэчээт/Экспорт',
	'coll-create_a_book' => 'Кинигэни айарга',
	'coll-create_a_book_tooltip' => 'Кинигэни эбэтэр ыстатыйалар хомуурунньуктарын айыы',
	'coll-book_creator' => 'Кинигэ оҥоруу',
	'coll-download_as' => 'Маннык $1 киллэр',
	'coll-download_as_tooltip' => 'Бу биики-сирэй $1 барылын хачайдаан ылыы',
	'coll-disable' => 'араарыы',
	'coll-book_creator_disable' => 'Кинигэ оҥорооччуну араарыы',
	'coll-book_creator_disable_tooltip' => 'Кинигэ онорооччуну туһаныма',
	'coll-add_linked_article' => 'Сигэммит биикини кинигэҕэр эп',
	'coll-remove_linked_article' => 'Сигэммит биики сирэйи кинигэттэн сот',
	'coll-add_category' => 'Бу категорияны кинигэҕэр эбии',
	'coll-add_category_tooltip' => 'Бу категория биики сирэйдэрин кинигэҕэ киллэр',
	'coll-add_this_page' => 'Бу сирэйи кинигэҕэр киллэр',
	'coll-add_page_tooltip' => 'Кинигэҕэ бу биики-сирэйи эбии',
	'coll-bookscategory' => 'Кинигэлэр',
	'coll-clear_collection' => 'Кинигэни ыраастаа',
	'coll-clear_collection_confirm' => 'Кырдьык кинигэҕин ыраастаары гынаҕын дуо?',
	'coll-clear_collection_tooltip' => 'Кинигэттэн биики сирэйдэри сот',
	'coll-help' => 'Көмө',
	'coll-help_tooltip' => 'Кинигэ айар туһунан көмө',
	'coll-helppage' => 'Help:Кинигэлэр',
	'coll-load_collection' => 'Кинигэни (атын сиртэн ылан) суруттар',
	'coll-load_collection_tooltip' => 'Бу кинигэни билиҥҥи (текущай) кинигэ курдук киллэр',
	'coll-n_pages' => '$1 {{PLURAL:$1|сирэй|сирэйдээх}}',
	'coll-printable_version_pdf' => 'PDF-барыла',
	'coll-remove_this_page' => 'Бу сирэйи кинигэҕиттэн сотуу',
	'coll-remove_page_tooltip' => 'Бу биики сирэйи кинигэттэн сот',
	'coll-show_collection' => 'Кинигэни көрдөр',
	'coll-show_collection_tooltip' => 'Уларытарга маны баттаа/хачайдыырга/кинигэни сакаастыырга',
	'coll-not_addable' => 'Бу сирэй эбиллэр кыаҕа суох',
	'coll-make_suggestions' => 'Бу сирэйдэри туттуоххун сөп',
	'coll-make_suggestions_tooltip' => 'Кинигэҥ баар сирэйдэригэр олоҕуран оҥоһуллубут туттуоххун сөп сирэйдэр тиһиктэрин көрдөр',
	'coll-suggest_empty' => 'кураанах',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'coll-bookscategory' => 'Libros',
	'coll-show_collection' => 'Ammustra libru',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'coll-bookscategory' => 'Libbra',
	'coll-help' => 'Aiutu',
	'coll-show_collection' => 'Talìa libbru',
	'coll-suggest_empty' => 'vacanti',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'coll-print_export' => 'මුද්‍රණය/නිර්යාත කෙරුම',
	'coll-create_a_book' => 'පොතක් නිර්මාණය කරන්න',
	'coll-create_a_book_tooltip' => 'පොතක් හෝ පිටු එකතුවක් තනන්න',
	'coll-book_creator' => 'පොත් තනන්නා',
	'coll-download_as' => '$1 ලෙස බාගන්න',
	'coll-download_as_tooltip' => 'මෙම විකි පිටුවෙහි $1 අනුවාදය බාගන්න',
	'coll-disable' => 'අක්‍රීය කරන්න',
	'coll-book_creator_disable' => 'පොත් තනන්නා අක්‍රීය කරන්න',
	'coll-book_creator_disable_tooltip' => 'පොත් තනන්නා භාවිතා කිරීම නවත්තන්න',
	'coll-add_linked_article' => 'සම්බන්ධ කරන ලද විකි පිටුවක් ඔබේ පොතට එක් කරන්න',
	'coll-remove_linked_article' => 'සම්බන්ධ කරන ලද විකි පිටුවක් ඔබේ පොතෙන් ඉවත් කරන්න',
	'coll-add_category' => 'මෙම ප්‍රවර්ගය ඔබේ පොතට එක් කරන්න',
	'coll-add_category_tooltip' => 'මෙම ප්‍රවර්ගයේ ඇති සියලුම විකි පිටු ඔබේ පොතට එක් කරන්න',
	'coll-add_this_page' => 'මෙම පිටුව ඔබේ පොතට එක් කරන්න',
	'coll-add_page_tooltip' => 'වත්මන් විකි පිටුව ඔබේ පොතට එක් කරන්න',
	'coll-bookscategory' => 'පොත්',
	'coll-clear_collection' => 'පොත සුද්ද කරන්න',
	'coll-clear_collection_confirm' => 'ඔබට ඔබේ පොත සම්පූර්ණයෙන්ම ශුද්ධ කිරීමට අවශ්‍යමද?',
	'coll-clear_collection_tooltip' => 'ඔබේ වත්මන් පොතෙන් සියලුම විකි පිටු ඉවත් කරන්න',
	'coll-help' => 'උදව්',
	'coll-help_tooltip' => 'පොත් තැනීම පිලිබඳ උදව් පෙන්වන්න',
	'coll-helppage' => 'Help:පොත්',
	'coll-load_collection' => 'පොත පූරණය කරන්න',
	'coll-load_collection_tooltip' => 'මෙම පොත් ඔබේ වත්මන් පොත ලෙස පූරණය කරන්න',
	'coll-n_pages' => '{{PLURAL:$1|පිටු|පිටු}} $1 ක්',
	'coll-printable_version_pdf' => 'PDF අනුවාදය',
	'coll-remove_this_page' => 'මෙම පිටුව ඔබේ පොතෙන් ඉවත් කරන්න',
	'coll-remove_page_tooltip' => 'වත්මන් විකි පිටුව ඔබේ පොතෙන් ඉවත් කරන්න',
	'coll-show_collection' => 'පොත පෙන්වන්න',
	'coll-not_addable' => 'මෙම පිටුව එක් කල නොහැක',
	'coll-make_suggestions' => 'පිටු යෝජනා කරන්න',
	'coll-suggest_empty' => 'හිස්',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'coll-print_export' => 'Tlačiť/exportovať',
	'coll-create_a_book' => 'Vytvoriť knihu',
	'coll-create_a_book_tooltip' => 'Vytvoriť knihu alebo kolekciu stránok',
	'coll-book_creator' => 'Tvorba knihy',
	'coll-download_as' => 'Stiahnuť ako $1',
	'coll-download_as_tooltip' => 'Stiahnuť verziu $1 tejto wiki stránky',
	'coll-disable' => 'vypnúť',
	'coll-book_creator_disable' => 'Vypnúť tvorbu knihy',
	'coll-book_creator_disable_tooltip' => 'Zastaviť používanie Tvorby knihy',
	'coll-add_linked_article' => 'Pridať odkazovanú stránku wiki do vašej knihy',
	'coll-remove_linked_article' => 'Odstrániť odkazovanú wiki stránku z vašej knihy',
	'coll-add_category' => 'Pridať túto kategóriu do vašej knihy',
	'coll-add_category_tooltip' => 'Pridať všetky stránky wiki v tejto kategórii do vašej knihy',
	'coll-add_this_page' => 'Pridať túto stránku do vašej knihy',
	'coll-add_page_tooltip' => 'Pridať aktuálnu wiki stránku do vašej knihy',
	'coll-bookscategory' => 'Knihy',
	'coll-clear_collection' => 'Vyčistiť knihu',
	'coll-clear_collection_confirm' => 'Skutočne chcete celkom vyčistiť svoju knihu?',
	'coll-clear_collection_tooltip' => 'Odstrániť všetky stránky wiki z vašej aktuálnej knihy',
	'coll-help' => 'Pomocník',
	'coll-help_tooltip' => 'Zobraziť pomocníka s vytváraním knihy',
	'coll-helppage' => 'Help:Knihy',
	'coll-load_collection' => 'Načítať knihu',
	'coll-load_collection_tooltip' => 'Načítať túto knihu ako vašu aktuálnu knihu',
	'coll-n_pages' => '$1 {{PLURAL:$1|stránka|stránky|stránok}}',
	'coll-printable_version_pdf' => 'PDF verzia',
	'coll-remove_this_page' => 'Odstrániť túto stránku z vašej knihy',
	'coll-remove_page_tooltip' => 'Odstrániť aktuálnu wiki stránku z vašej knihy',
	'coll-show_collection' => 'Zobraziť knihu',
	'coll-show_collection_tooltip' => 'Kliknutím môžete upraviť/stiahnuť/objednať knihu',
	'coll-not_addable' => 'Túto stránku nemožno pridať',
	'coll-make_suggestions' => 'Navrhnúť stránky',
	'coll-make_suggestions_tooltip' => 'Zobraziť návrhy na základe stránok vo vašej knihe',
	'coll-suggest_empty' => 'prázdne',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 * @author Freakolowsky
 * @author Smihael
 */
$messages['sl'] = array(
	'coll-print_export' => 'Tiskanje/izvoz',
	'coll-create_a_book' => 'Ustvari e-knjigo',
	'coll-create_a_book_tooltip' => 'Ustvari e-knjigo ali zbirko strani',
	'coll-book_creator' => 'Ustvarjalec knjige',
	'coll-download_as' => 'Prenesi kot $1',
	'coll-download_as_tooltip' => 'Prenesi $1 različico te wiki strani',
	'coll-disable' => 'onemogoči',
	'coll-book_creator_disable' => 'Onemogoči ustvarjalca knjige',
	'coll-book_creator_disable_tooltip' => 'Prenehaj uporabljati izdelovalca knjige',
	'coll-add_linked_article' => 'Dodajte povezano wikistran v svojo knjigo',
	'coll-remove_linked_article' => 'Odstranite povezano wikistran iz svoje knjige',
	'coll-add_category' => 'Dodajte to kategorijo k svoji knjigi',
	'coll-add_category_tooltip' => 'Dodajte vse wiki strani v tej kategoriji v svojo knjigo',
	'coll-add_this_page' => 'Dodajte to stran v svojo knjigo',
	'coll-add_page_tooltip' => 'Dodajte trenutno wiki stran v svojo knjigo',
	'coll-bookscategory' => 'Knjige',
	'coll-clear_collection' => 'Zbriši knjigo',
	'coll-clear_collection_confirm' => 'Ali res želite popolnoma izbrisati vašo knjigo?',
	'coll-clear_collection_tooltip' => 'Odstrani vse wiki strani iz vaše trenutne knjige',
	'coll-help' => 'Pomoč',
	'coll-help_tooltip' => 'Prikaži pomoč o ustvarjanju knjige',
	'coll-helppage' => 'Help:Knjige',
	'coll-load_collection' => 'Naloži knjige',
	'coll-load_collection_tooltip' => 'Naloži to knjigo kot trenutno',
	'coll-n_pages' => '$1 {{PLURAL:$1|stran|strani}}',
	'coll-printable_version_pdf' => 'Različica PDF',
	'coll-remove_this_page' => 'Odstrani to stran iz vaše knjige',
	'coll-remove_page_tooltip' => 'Odstranite trenutno wiki stran iz vaše knjige',
	'coll-show_collection' => 'Prikaži knjige',
	'coll-show_collection_tooltip' => 'Kliknite za urejanje/prenos/naročilo vaše knjige',
	'coll-not_addable' => 'To stran ni mogoče dodati',
	'coll-make_suggestions' => 'Predlagaj strani',
	'coll-make_suggestions_tooltip' => 'Prikaži predloge glede na strani v vaši knjigi',
	'coll-suggest_empty' => 'prazno',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Nikola Smolenski
 * @author Rancher
 * @author Јованвб
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'coll-print_export' => 'Штампај/извези',
	'coll-create_a_book' => 'Направи књигу',
	'coll-create_a_book_tooltip' => 'Направи књигу или збирку страница',
	'coll-book_creator' => 'Књиговезница',
	'coll-download_as' => 'Преузми као $1',
	'coll-download_as_tooltip' => 'Преузми $1 издање ове странице',
	'coll-disable' => 'онемогући',
	'coll-book_creator_disable' => 'Онемогући књиговезницу',
	'coll-book_creator_disable_tooltip' => 'Престани с коришћењем књиговезнице',
	'coll-add_linked_article' => 'Додај везу до вики странице у своју књигу',
	'coll-remove_linked_article' => 'Уклони везу до вики странице из своје књиге',
	'coll-add_category' => 'Додај ову категорију у своју књигу',
	'coll-add_category_tooltip' => 'Додаје све вики странице у овој категорији у вашу књигу',
	'coll-add_this_page' => 'Додај ову страну у своју књигу',
	'coll-add_page_tooltip' => 'Додаје тренутну вики страницу вашој књизи',
	'coll-bookscategory' => 'Књиге',
	'coll-clear_collection' => 'Очисти књигу',
	'coll-clear_collection_confirm' => 'Да ли заиста желите да потпуно очистите своју књигу?',
	'coll-clear_collection_tooltip' => 'Уклања све вики странице из ваше тренутне књиге',
	'coll-help' => 'Помоћ',
	'coll-help_tooltip' => 'Прикажи помоћ за стварање књига',
	'coll-helppage' => 'Help:Књиге',
	'coll-load_collection' => 'Учитај књигу',
	'coll-load_collection_tooltip' => 'Учитава ову књигу као вашу тренутну књигу',
	'coll-n_pages' => '$1 {{PLURAL:$1|страница|странице|страница}}',
	'coll-printable_version_pdf' => 'PDF издање',
	'coll-remove_this_page' => 'Уклони ову страницу из своје књиге',
	'coll-remove_page_tooltip' => 'Уклања тренутну вики страницу из ваше књиге',
	'coll-show_collection' => 'Прикажи књигу',
	'coll-show_collection_tooltip' => 'Кликните за измену, преузимање или наручивање своје књиге',
	'coll-not_addable' => 'Ова страница се не може додати',
	'coll-suggest_empty' => 'празно',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'coll-print_export' => 'Štampaj/izvezi',
	'coll-create_a_book' => 'Napravi knjigu',
	'coll-create_a_book_tooltip' => 'Napravi knjigu ili kolekciju članaka',
	'coll-book_creator' => 'Knjigoveznica',
	'coll-download_as' => 'Preuzmi kao $1',
	'coll-download_as_tooltip' => 'Preuzmi $1 izdanje ove stranice',
	'coll-disable' => 'onemogući',
	'coll-book_creator_disable' => 'Onemogući knjigoveznicu',
	'coll-book_creator_disable_tooltip' => 'Prestani s korišćenjem knjigoveznice',
	'coll-add_linked_article' => 'Dodaj vezu do viki stranice u svoju knjigu',
	'coll-remove_linked_article' => 'Ukloni vezu do viki stranice iz svoje knjige',
	'coll-add_category' => 'Dodaj ovu kategoriju u svoju knjigu',
	'coll-add_category_tooltip' => 'Dodaje sve viki stranice u ovoj kategoriji u vašu knjigu',
	'coll-add_this_page' => 'Dodaj ovu stranu u svoju knjigu',
	'coll-add_page_tooltip' => 'Dodaje trenutnu viki stranicu vašoj knjizi',
	'coll-bookscategory' => 'Knjige',
	'coll-clear_collection' => 'Očisti knjigu',
	'coll-clear_collection_confirm' => 'Da li zaista želite da potpuno očistite svoju knjigu?',
	'coll-clear_collection_tooltip' => 'Uklanja sve viki stranice iz vaše trenutne knjige',
	'coll-help' => 'Pomoć',
	'coll-help_tooltip' => 'Prikaži pomoć oko pravljenja knjiga',
	'coll-helppage' => 'Help:Knjige',
	'coll-load_collection' => 'Učitaj knjigu',
	'coll-load_collection_tooltip' => 'Učitava ovu knjigu kao vašu trenutnu knjigu',
	'coll-n_pages' => '$1 {{PLURAL:$1|stranica|stranice|stranica}}',
	'coll-printable_version_pdf' => 'PDF verzija',
	'coll-remove_this_page' => 'Ukloni ovu stranicu iz svoje knjige',
	'coll-remove_page_tooltip' => 'Uklanja trenutnu viki stranicu iz vaše knjige',
	'coll-show_collection' => 'Prikaži knjigu',
	'coll-show_collection_tooltip' => 'Kliknite za izmenu, preuzimanje ili naručivanje svoje knjige',
	'coll-not_addable' => 'Ova stranica se ne može dodati',
	'coll-suggest_empty' => 'prazno',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'coll-create_a_book' => 'Kollektion',
	'coll-download_as' => 'As $1 deelleede',
	'coll-add_category' => 'Aal Sieden uut disse Kategorie dien Bouk bietouföigje',
	'coll-clear_collection' => 'Bouk läskje',
	'coll-helppage' => 'Help:Bouke',
	'coll-load_collection' => 'Bouk leede',
	'coll-n_pages' => '$1 {{PLURAL:$1|Siede|Sieden}}',
	'coll-show_collection' => 'Bouk wiese',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'coll-add_category' => 'Nambah kategori',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Boivie
 * @author GameOn
 * @author M.M.S.
 * @author Micke
 * @author Najami
 * @author Poxnar
 * @author Rotsee
 * @author Sannab
 */
$messages['sv'] = array(
	'coll-print_export' => 'Skriv ut/exportera',
	'coll-create_a_book' => 'Skapa en bok',
	'coll-create_a_book_tooltip' => 'Skapa en bok eller artikelsamling',
	'coll-book_creator' => 'Bokskapare',
	'coll-download_as' => 'Hämta som $1',
	'coll-download_as_tooltip' => 'Ladda ner den här wikisidan i $1-format',
	'coll-disable' => 'slå av',
	'coll-book_creator_disable' => 'Avaktiviera bokskapare',
	'coll-book_creator_disable_tooltip' => 'Sluta använda bokskapare',
	'coll-add_linked_article' => 'Lägg till den länkade wiki-sidan till din bok',
	'coll-remove_linked_article' => 'Ta bort den länkade wiki-sidan från din bok',
	'coll-add_category' => 'Lägg till den här kategorin i boken',
	'coll-add_category_tooltip' => 'Lägg till alla wikisidor i den här kategorin till din bok',
	'coll-add_this_page' => 'Lägg till den här sidan i boken',
	'coll-add_page_tooltip' => 'Lägg till den nuvarande wikisidan till din bok',
	'coll-bookscategory' => 'Böcker',
	'coll-clear_collection' => 'Töm bok',
	'coll-clear_collection_confirm' => 'Vill du verkligen helt tömma din bok?',
	'coll-clear_collection_tooltip' => 'Ta bort alla wikisidor från din nuvarande bok',
	'coll-help' => 'Hjälp',
	'coll-help_tooltip' => 'Få hjälp med att skapa böcker',
	'coll-helppage' => 'Help:Böcker',
	'coll-load_collection' => 'Hämta bok',
	'coll-load_collection_tooltip' => 'Ladda den här boken som din nuvarande bok',
	'coll-n_pages' => '$1 {{PLURAL:$1|sida|sidor}}',
	'coll-printable_version_pdf' => 'PDF-version',
	'coll-remove_this_page' => 'Ta bort den här sidan ur boken',
	'coll-remove_page_tooltip' => 'Ta bort den nuvarande wikisidan från din bok',
	'coll-show_collection' => 'Visa bok',
	'coll-show_collection_tooltip' => 'Klicka för att redigera/ladda ner/beställa din bok',
	'coll-not_addable' => 'Denna sida kan inte läggas till',
	'coll-make_suggestions' => 'Föreslå sidor',
	'coll-make_suggestions_tooltip' => 'Visa förslag baserade på sidorna i din bok',
	'coll-suggest_empty' => 'tom',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'coll-print_export' => 'Chapa/peleka nje',
	'coll-create_a_book' => 'Kutunga kitabu',
	'coll-create_a_book_tooltip' => 'Utunge kitabu au mkusanyiko wa kurasa',
	'coll-book_creator' => 'Kitunga kitabu',
	'coll-download_as' => 'Pakua kama $1',
	'coll-download_as_tooltip' => 'Pakua aina $1 ya ukurasa wiki huu',
	'coll-disable' => 'lemaza',
	'coll-book_creator_disable' => 'Lemaza kitunga kitabu',
	'coll-book_creator_disable_tooltip' => 'Acha kutumia kitunga kitabu',
	'coll-add_linked_article' => 'Ingiza ukurasa mwingine ulioungwa katika kitabu chako',
	'coll-remove_linked_article' => 'Ondoa ukurasa mwingine ulioungwa kutoka katika kitabu chako',
	'coll-add_category' => 'Ongeza jamii hii katika kitabu chako',
	'coll-add_category_tooltip' => 'Ongeza kurasa zote zilizopo katika jamii hii katika kitabu chako',
	'coll-add_this_page' => 'Ongeza ukurasa huu katika kitabu chako',
	'coll-add_page_tooltip' => 'Ongeza ukurasa huu huu katika kitabu chako',
	'coll-bookscategory' => 'Vitabu',
	'coll-clear_collection' => 'Pangusa kitabu',
	'coll-clear_collection_confirm' => 'Je, unataka kuondoa kurasa zote zilizopo katika kitabu chako?',
	'coll-clear_collection_tooltip' => 'Ondoa kurasa zilizopo zote kutoka katika kitabu chako cha sasa',
	'coll-help' => 'Msaada',
	'coll-help_tooltip' => 'Onyesha msaada wa kutunga kitabu',
	'coll-helppage' => 'Help:Vitabu',
	'coll-load_collection' => 'Pakia kitabu',
	'coll-load_collection_tooltip' => 'Pakia kitabu hiki kuwa kitabu chako cha sasa',
	'coll-n_pages' => '{{PLURAL:$1|ukurasa|kurasa}} $1',
	'coll-printable_version_pdf' => 'Mtindo wa PDF',
	'coll-remove_this_page' => 'Ondoa ukurasa huu kutoka katika kitabu chako',
	'coll-remove_page_tooltip' => 'Ondoa ukurasa uliopo sasa kutoka katika kitabu chako',
	'coll-show_collection' => 'Onyesha kitabu',
	'coll-not_addable' => 'Ukarasa huu hauwezi kuingizwa',
	'coll-suggest_empty' => 'tupu',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 * @author Shanmugamp7
 * @author TRYPPN
 * @author செல்வா
 */
$messages['ta'] = array(
	'coll-create_a_book' => 'ஒரு புத்தகம் உருவாக்கு',
	'coll-create_a_book_tooltip' => 'புத்தகத்தை அல்லது பக்க தொகுப்பை உருவாக்கு',
	'coll-book_creator' => 'புத்தகம் உருவாக்குபவர்',
	'coll-download_as' => '$1 என தகவலிறக்கு',
	'coll-download_as_tooltip' => 'இந்த விக்கி பக்கத்தின் $1 பதிப்பை தகவலிறக்கம் செய்',
	'coll-disable' => 'செயலிழக்கச் செய்',
	'coll-book_creator_disable' => 'புத்தக உருவாக்குநரை செயலிழக்க செய்',
	'coll-book_creator_disable_tooltip' => 'புத்தக உருவாக்குநர் பயன்படுத்துவதை நிறுத்து',
	'coll-add_linked_article' => 'இணைக்கப்பட்ட விக்கி பக்கத்தை உங்கள் புத்தகத்தில்  சேர்',
	'coll-remove_linked_article' => 'இணைக்கப்பட்ட விக்கி பக்கத்தை உங்கள் புத்தகத்தில்  இருந்து நீக்கு',
	'coll-add_category' => 'இந்த வகையை  உங்கள் புத்தகத்தில்  சேர்',
	'coll-add_category_tooltip' => 'இந்த வகையில் உள்ள எல்லா விக்கி பக்கங்களையும் உங்கள் புத்தகத்தில் சேர்க்கவும்.',
	'coll-add_this_page' => 'உங்கள் புத்தகத்தில் இப்பக்கத்தைச் சேர்க்கவும்',
	'coll-add_page_tooltip' => 'தற்போதைய விக்கி பக்கத்தை உங்கள் புத்தகத்தில் சேர்க்கவும்',
	'coll-bookscategory' => 'நூல்கள்',
	'coll-clear_collection' => 'புத்தகத்தை அழி',
	'coll-clear_collection_confirm' => 'உண்மையிலேயே முழுமையாக உங்கள் புத்தகத்தை வெறுமையாக்க வேண்டுமா?',
	'coll-clear_collection_tooltip' => 'உங்கள் நடப்பு புத்தகத்திலிருந்து அனைத்து விக்கி பக்கங்ககளையும் நீக்கு',
	'coll-help' => 'உதவி',
	'coll-help_tooltip' => 'புத்தகங்கள் உருவாக்குவதை பற்றிய உதவியை காண்பி',
	'coll-helppage' => 'Help:புத்தகங்கள்',
	'coll-load_collection' => 'நூலை ஏற்றவும்',
	'coll-load_collection_tooltip' => 'இந்த புத்தகத்தை  உங்கள் நடப்பு புத்தகம் என தகவலேற்று',
	'coll-n_pages' => '$1 {{PLURAL:$1|பக்கம் |பக்கங்கள்}}',
	'coll-printable_version_pdf' => 'PDF பதிப்பு',
	'coll-remove_this_page' => 'இப்பக்கத்தை  உங்கள் புத்தகத்திலிருந்து நீக்கு',
	'coll-remove_page_tooltip' => 'நடப்பு விக்கி பக்கத்தை உங்கள் புத்தகத்திலிருந்து நீக்கு',
	'coll-show_collection' => 'நூலைக் காட்டவும்',
	'coll-show_collection_tooltip' => 'உங்கள் புத்தகத்தை திருத்த/தகவலிறக்க/ஒழுங்காக்க கிளிக் செய்யவும்',
	'coll-not_addable' => 'இப்பக்கத்தை  சேர்க்க முடியாது',
	'coll-make_suggestions' => 'பக்கங்களை  ஆலோசனை கூறு',
	'coll-make_suggestions_tooltip' => 'உங்கள் புத்தகத்தில் உள்ள  பக்கங்கள் அடிப்படையில் ஆலோசனைகளை காண்பி',
	'coll-suggest_empty' => 'ஒன்றுமில்லாத',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'coll-print_export' => 'ముద్రించండి/ఎగుమతి చేయండి',
	'coll-create_a_book' => 'ఓ పుస్తకాన్ని సృష్టించండి',
	'coll-create_a_book_tooltip' => 'పుస్తకాన్ని లేదా పేజీల సేకరణని సృష్టించండి',
	'coll-book_creator' => 'పుస్తక కూర్పరి',
	'coll-download_as' => '$1 క్రింద దిగుమతి చేసుకోండి',
	'coll-download_as_tooltip' => 'ఈ పేజీ యొక్క $1 సంచికని దించుకోండి',
	'coll-disable' => 'అచేతన పరచు',
	'coll-book_creator_disable' => 'పుస్తకం సృష్టికర్తను అచేతనం చెయ్యి',
	'coll-book_creator_disable_tooltip' => 'పుస్తకం సృష్టికర్తను వాడటం ఆపు',
	'coll-add_linked_article' => 'మీ పుస్తకానికి లింకైన వికీ పేజీని చేర్చు',
	'coll-remove_linked_article' => 'మీ పుస్తకం నుండి లింకున్న వికీ పేజీని తీసెయ్యి',
	'coll-add_category' => 'పుస్తకముకు ఈ వర్గాన్ని చేర్చు',
	'coll-add_category_tooltip' => 'ఈ వర్గంలోని అన్ని వికీ పేజీలనూ పుస్తకంలోనికి చేర్చు',
	'coll-add_this_page' => 'ఈ పేజీని మీ పుస్తకములో చేర్చండి',
	'coll-add_page_tooltip' => 'ప్రస్తుత వికీ పేజీని పుస్తకానికి చేర్చు',
	'coll-bookscategory' => 'పుస్తకాలు',
	'coll-clear_collection' => 'పుస్తకముని తుడిచివేయి',
	'coll-clear_collection_confirm' => 'మీరు నిజంగా మీ పుస్తకమును పూర్తిగా తొలగించాలని అనుకొంటున్నారా?',
	'coll-clear_collection_tooltip' => 'ప్రస్తుత పుస్తకంలో నుండి అన్ని వికీ పేజీలను తీసివేయి',
	'coll-help' => 'సహాయం',
	'coll-help_tooltip' => 'పుస్తకాల్ని తయారుచేయడం గురించి సహాయాన్ని చూడండి',
	'coll-helppage' => 'Help:పుస్తకాలు',
	'coll-load_collection' => 'పుస్తకాన్ని లోడుచెయ్యి',
	'coll-load_collection_tooltip' => 'ఈ పుస్తకాన్ని మీ ప్రస్తుత పుస్తకంగా లోడు చెయ్యండి',
	'coll-n_pages' => '$1 {{PLURAL:$1|పుట|పుటలు}}',
	'coll-printable_version_pdf' => 'PDF కూర్పు',
	'coll-remove_this_page' => 'ఈ పుటని మీ పుస్తకం నుండి తొలగించండి',
	'coll-remove_page_tooltip' => 'ప్రస్తుత వికీ పేజీని నా పుస్తకం నుండి తొలగించు',
	'coll-show_collection' => 'పుస్తకముని చూపించు',
	'coll-show_collection_tooltip' => 'మీ పుస్తకాన్ని మార్చేందుకు/ఎక్కించేందుకు/ఆర్డరు చేసేందుకు నొక్కండి',
	'coll-not_addable' => 'ఈ పేజీని చేర్చలేము',
	'coll-make_suggestions' => 'పేజీలను సూచించు',
	'coll-make_suggestions_tooltip' => 'మీ పుస్తకంలోని పేజీల ఆధారంగా సూచనలని చూపిస్తుంది',
	'coll-suggest_empty' => 'ఖాళీ',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'coll-create_a_book' => 'Kria livru ida',
	'coll-bookscategory' => 'Livru sira',
	'coll-helppage' => 'Help:Livru sira',
	'coll-n_pages' => '{{PLURAL:$1|pájina ida|pájina $1}}',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'coll-create_a_book' => 'Эҷоди як китоб',
	'coll-download_as' => 'Дарёфтан чун $1',
	'coll-add_category' => 'Илова кардани гурӯҳ',
	'coll-clear_collection' => 'Тоза кардани гирдовари',
	'coll-helppage' => 'Help:Гирдовариҳо',
	'coll-load_collection' => 'Бор кардани гирдоварӣ',
	'coll-n_pages' => '$1 {{PLURAL:$1|саҳифа|саҳифаҳо}}',
	'coll-printable_version_pdf' => 'Нусхаи PDF',
	'coll-show_collection' => 'Намоиши гирдоварӣ',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'coll-create_a_book' => 'Eçodi jak kitob',
	'coll-download_as' => 'Darjoftan cun $1',
	'coll-n_pages' => '$1 {{PLURAL:$1|sahifa|sahifaho}}',
	'coll-printable_version_pdf' => 'Nusxai PDF',
);

/** Thai (ไทย)
 * @author Ans
 * @author Harley Hartwell
 * @author Horus
 * @author Manop
 * @author Octahedron80
 */
$messages['th'] = array(
	'coll-print_export' => 'พิมพ์/ส่งออก',
	'coll-create_a_book' => 'สร้างหนังสือ',
	'coll-create_a_book_tooltip' => 'สร้างหนังสือหรือรวบรวมหน้า',
	'coll-book_creator' => 'ตัวสร้างหนังสือ',
	'coll-download_as' => 'ดาวน์โหลดในชื่อ $1',
	'coll-download_as_tooltip' => 'ดาวน์โหลดรูปแบบ $1 ของหน้าวิกินี้',
	'coll-disable' => 'ปิดการใช้งาน',
	'coll-book_creator_disable' => 'ยกเลิกการใช้ตัวสร้างหนังสือ',
	'coll-book_creator_disable_tooltip' => 'เลิกใช้ตัวสร้างหนังสือ',
	'coll-add_linked_article' => 'เพิ่มหน้าวิกิเชื่อมโยงในหนังสือของคุณ',
	'coll-remove_linked_article' => 'นำหน้าวิกิเชื่อมโยงออกจากหนังสือของคุณ',
	'coll-add_category' => 'เพิ่มหมวดหมู่นี้เข้าสู่หนังสือ',
	'coll-add_category_tooltip' => 'เพิ่มหน้าวิกิทั้งหมดในหมวดหมู่นี้ในหนังสือของคุณ',
	'coll-add_this_page' => 'เพิ่มหน้านี้ในหนังสือของคุณ',
	'coll-add_page_tooltip' => 'เพิ่มหน้าวิกิปัจจุบันในหนังสือของคุณ',
	'coll-bookscategory' => 'หนังสือ',
	'coll-clear_collection' => 'เคลียร์หนังสือ',
	'coll-clear_collection_confirm' => 'คุณแน่ใจหรือไม่ที่จะลบหนังสือของคุณ ?',
	'coll-clear_collection_tooltip' => 'นำหน้าวิกิทั้งหมดออกจากหนังสือปัจจุบันของคุณ',
	'coll-help' => 'วิธีใช้',
	'coll-help_tooltip' => 'แสดงคำแนะนำเกี่ยวกับการสร้างหนังสือ',
	'coll-helppage' => 'Help:หนังสือ',
	'coll-load_collection' => 'โหลดหนังสือ',
	'coll-load_collection_tooltip' => 'โหลดหนังสือนี้เป็นหนังสือปัจจุบันของคุณ',
	'coll-n_pages' => '$1 หน้า',
	'coll-printable_version_pdf' => 'รุ่น PDF',
	'coll-remove_this_page' => 'นำหน้านี้ออกจากหนังสือของคุณ',
	'coll-remove_page_tooltip' => 'นำหน้าวิกิปัจจุบันออกจากหนังสือของคุณ',
	'coll-show_collection' => 'แสดงหนังสือ',
	'coll-show_collection_tooltip' => 'คลิกเพื่อแก้ไข ดาวน์โหลด หรือสั่งซื้อหนังสือของคุณ',
	'coll-not_addable' => 'ไม่สามารถเพิ่มหน้านี้ลงหนังสือได้',
	'coll-make_suggestions' => 'หน้าแนะนำ',
	'coll-make_suggestions_tooltip' => 'แสดงคำแนะนำตามหน้าที่อยู่ในหนังสือของคุณ',
	'coll-suggest_empty' => 'ไม่มีคำแนะนำ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'coll-print_export' => 'Print et/eksportirle',
	'coll-create_a_book' => 'Kitap döret',
	'coll-create_a_book_tooltip' => 'Kitap ýa-da sahypa kolleksiýasy döret',
	'coll-book_creator' => 'Kitap dörediji',
	'coll-download_as' => '$1 edip düşür',
	'coll-download_as_tooltip' => 'Bu wiki sahypasynyň $1 wersiýasyny düşür',
	'coll-disable' => 'ýap',
	'coll-book_creator_disable' => 'Kitap döredijini ýap',
	'coll-book_creator_disable_tooltip' => 'Kitap döredijini ulanmagy bes et',
	'coll-add_linked_article' => 'Çykgytly wiki sahypasyny kitabyňyza goşuň',
	'coll-remove_linked_article' => 'Çykgytly wiki sahypasyny kitabyňyzdan aýryň',
	'coll-add_category' => 'Bu kategoriýany kitabyňa goş',
	'coll-add_category_tooltip' => 'Bu kategoriýadaky ähli wiki sahypalaryny kitabyňa goş',
	'coll-add_this_page' => 'Bu sahypany kitabyňa goş',
	'coll-add_page_tooltip' => 'Häzirki wiki sahypasyny kitabyňa goş',
	'coll-bookscategory' => 'Kitaplar',
	'coll-clear_collection' => 'Kitaby boşat',
	'coll-clear_collection_confirm' => 'Kitabyňyzy hakykatdan hem boşadasyňyz gelýärmi?',
	'coll-clear_collection_tooltip' => 'Häzirki kitabyňdan ähli wiki sahypalaryny aýyr',
	'coll-help' => 'Ýardam',
	'coll-help_tooltip' => 'Kitap döretmeklik hakda ýardamy görkez',
	'coll-helppage' => 'Help:Kitaplar',
	'coll-load_collection' => 'Kitap ýükle',
	'coll-load_collection_tooltip' => 'Bu kitaby häzirki kitabyň hökmünde ýükle',
	'coll-n_pages' => '$1 {{PLURAL:$1|sahypa|sahypa}}',
	'coll-printable_version_pdf' => 'PDF wersiýasy',
	'coll-remove_this_page' => 'Bu sahypany kitabyňdan aýyr',
	'coll-remove_page_tooltip' => 'Häzirki wiki sahypasyny kitabyňdan aýyr',
	'coll-show_collection' => 'Kitaby görkez',
	'coll-show_collection_tooltip' => 'Kitabyňyzy redaktirlemek/düşürmek/buýurmak üçin tyklaň',
	'coll-not_addable' => 'Bu sahypany goşup bolmaýar',
	'coll-make_suggestions' => 'Sahypa teklip et',
	'coll-make_suggestions_tooltip' => 'Kitabyňyzdaky sahypalar esasynda teklip görkez',
	'coll-suggest_empty' => 'boş',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'coll-print_export' => 'Ilimbag/iluwas',
	'coll-create_a_book' => 'Lumikha ng isang aklat',
	'coll-create_a_book_tooltip' => 'Lumikha ng isang aklat o kalipunan ng pahina',
	'coll-book_creator' => 'Panglikha ng aklat',
	'coll-download_as' => 'Ikargang-pakuha bilang $1',
	'coll-download_as_tooltip' => 'Magkargang-pababa ng $1 na bersyon ng pahinang pangwiking ito',
	'coll-disable' => 'huwag paganahin',
	'coll-book_creator_disable' => 'Huwag paganahin ang panglikha ng aklat',
	'coll-book_creator_disable_tooltip' => 'Ihinto ang paggamit ng panglikha ng aklat',
	'coll-add_linked_article' => 'Idagdag ang nakakawing na pahinang pangwiki sa aklat mo',
	'coll-remove_linked_article' => 'Tanggalin ang nakakawing na pahinang pangwiki mula sa aklat mo',
	'coll-add_category' => 'Idagdag ang kategoryang ito sa aklat mo',
	'coll-add_category_tooltip' => 'Idagdag ang lahat ng mga pahina ng wiki sa loob ng kauriang ito patungo sa aklat mo',
	'coll-add_this_page' => 'Idagdag ang pahinang ito sa aklat mo',
	'coll-add_page_tooltip' => 'Idagdag ang kasalukuyang pahina ng wiki sa aklat mo',
	'coll-bookscategory' => 'Mga aklat',
	'coll-clear_collection' => 'Hawiin ang aklat',
	'coll-clear_collection_confirm' => 'Talaga bang nais mong hawiin ng lubusan ang aklat mo?',
	'coll-clear_collection_tooltip' => 'Tanggalin ang lahat ng mga pahina ng wiki mula sa pangkasalukuyan mong aklat',
	'coll-help' => 'Tulong',
	'coll-help_tooltip' => 'Ipakita ang pantulong tunkol sa paglikha ng mga aklat',
	'coll-helppage' => 'Help:Mga Aklat',
	'coll-load_collection' => 'Ikarga ang aklat',
	'coll-load_collection_tooltip' => 'Ikarga ang aklat na ito bilang pangkasalukuyang aklat mo',
	'coll-n_pages' => '$1 {{PLURAL:$1|pahina|mga pahina}}',
	'coll-printable_version_pdf' => 'Bersyong PDF',
	'coll-remove_this_page' => 'Alisin ang pahinang ito mula aklat mo',
	'coll-remove_page_tooltip' => 'Tanggalan ang pangkasalukuyang pahina ng wiki mula sa aklat mo',
	'coll-show_collection' => 'Ipakita ang aklat',
	'coll-show_collection_tooltip' => 'Pindutin upang baguhin/magkargang pababa/umorder ng aklat mo',
	'coll-not_addable' => 'Hindi maidaragdag ang pahinang ito',
	'coll-make_suggestions' => 'Magmungkahi ng mga pahina',
	'coll-make_suggestions_tooltip' => 'Ipakita ang mga mungkahi ayon sa mga pahinang nasa loob ng aklat mo',
	'coll-suggest_empty' => 'walang laman',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Mach
 * @author Manco Capac
 * @author Srhat
 */
$messages['tr'] = array(
	'coll-print_export' => 'Yazdır/dışa aktar',
	'coll-create_a_book' => 'Bir kitap oluştur',
	'coll-create_a_book_tooltip' => 'Bir kitap veya sayfa derlemesi oluştur',
	'coll-book_creator' => 'Kitap oluşturucu',
	'coll-download_as' => '$1 olarak indir',
	'coll-download_as_tooltip' => 'Bu viki sayfasının bir $1 sürümünü indir',
	'coll-disable' => 'devre dışı bırak',
	'coll-book_creator_disable' => 'Kitap oluşturucuyu devre dışı bırak',
	'coll-book_creator_disable_tooltip' => 'Kitap oluşturucuyu kullanmayı bırak',
	'coll-add_linked_article' => 'Bağlantılı viki sayfasını kitabınıza ekleyin',
	'coll-remove_linked_article' => 'Bağlantılı viki sayfasını kitabınızdan çıkarın',
	'coll-add_category' => 'Bu kategoriyi kitabınıza ekleyin',
	'coll-add_category_tooltip' => 'Bu kategorideki tüm viki sayfalarını kitabınıza ekleyin',
	'coll-add_this_page' => 'Bu sayfayı kitabınıza ekleyin',
	'coll-add_page_tooltip' => 'Bu sayfayı kitabınıza ekleyin',
	'coll-bookscategory' => 'Viki-kitaplar',
	'coll-clear_collection' => 'Kitabı temizle',
	'coll-clear_collection_confirm' => 'Kitabınızı tamamen temizlemeyi istiyor musunuz?',
	'coll-clear_collection_tooltip' => 'Mevcut kitabınızdaki tüm viki sayfalarını silin',
	'coll-help' => 'Yardım',
	'coll-help_tooltip' => 'Kitap oluşturma hakkında yardım göster',
	'coll-helppage' => 'Help:Kitaplar',
	'coll-load_collection' => 'Kitabı yükle',
	'coll-load_collection_tooltip' => 'Bu kitabı varsayılan kitabınız olarak yükleyin',
	'coll-n_pages' => '$1 {{PLURAL:$1|sayfa|sayfa}}',
	'coll-printable_version_pdf' => 'PDF sürümü',
	'coll-remove_this_page' => 'Bu sayfayı kitabınızdan çıkarın',
	'coll-remove_page_tooltip' => 'Bu sayfayı kitabınızdan çıkarın',
	'coll-show_collection' => 'Kitabı göster',
	'coll-show_collection_tooltip' => 'Tıklayıp kitabınızı düzenleyin/indirin/sipariş edin',
	'coll-not_addable' => 'Sayfa eklenemiyor',
	'coll-make_suggestions' => 'Sayfa öner',
	'coll-make_suggestions_tooltip' => 'Kitabınızdaki mevcut sayfalara göre öneriler göster',
	'coll-suggest_empty' => 'boş',
);

/** Tatar (Татарча/Tatarça)
 * @author Ильнар
 */
$messages['tt'] = array(
	'coll-bookscategory' => 'Китаплар',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'coll-print_export' => 'Бастыру/экспорт',
	'coll-create_a_book' => 'Китап ясау',
	'coll-create_a_book_tooltip' => 'Китап  яки мәкаләләр җыентыган ясау',
	'coll-book_creator' => 'Китап ясау',
	'coll-download_as' => '$1 иттереп алу',
	'coll-download_as_tooltip' => 'Бу битнең $1-юрамасын алу',
	'coll-disable' => 'ябарга',
	'coll-book_creator_disable' => 'Китап төзүчене ябу',
	'coll-book_creator_disable_tooltip' => 'Китап төзүчене ябыгыз',
	'coll-add_linked_article' => 'Бәйләнгән вики-битне сезнең китапка кую',
	'coll-remove_linked_article' => 'Бәйләнгән вики-битне сезнең китаптан алу',
	'coll-add_category' => 'Әлеге төркемне сезнең китапка кую',
	'coll-add_category_tooltip' => 'Әлеге төркемнең вики-битләрен сезнең китапка кую',
	'coll-add_this_page' => 'Әлеге битне сезнең китапка кую',
	'coll-add_page_tooltip' => 'Әлеге вики-битне китапка кую',
	'coll-bookscategory' => 'Китаплар',
	'coll-clear_collection' => 'Китапны чистарту',
	'coll-clear_collection_confirm' => 'Сез дөрестән дә барлык китапны бетермәкче буласызмы?',
	'coll-clear_collection_tooltip' => 'Барлык вики-битләрне бетерегез',
	'coll-help' => 'Ярдәм',
	'coll-help_tooltip' => 'Китап ясау буенча ярдәмче битне карау',
	'coll-helppage' => 'Help:Китаплар',
	'coll-load_collection' => 'Китапны йөкләү',
	'coll-load_collection_tooltip' => 'Яңа китапны әлегесе кебек йөкләргә',
	'coll-n_pages' => '$1 {{PLURAL:$1|бит|битләр}}',
	'coll-printable_version_pdf' => 'PDF-юрама',
	'coll-remove_this_page' => 'Бу битне сезнең китаптан бетерергә',
	'coll-remove_page_tooltip' => 'Әлеге вики-битне китаптан бетерергә',
	'coll-show_collection' => 'Китапны күрсәтү',
	'coll-show_collection_tooltip' => 'Китапны ясау/йөкләү/заказ бирү өчен басыгыз',
	'coll-not_addable' => 'Бу бит йөкләнә алмый',
	'coll-make_suggestions' => 'Тәкъдим ителгән битләр',
	'coll-make_suggestions_tooltip' => 'Минем китапта булган җөмләләрне күрсәтергә',
	'coll-suggest_empty' => 'буш',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Aleksandrit
 * @author Alex Khimich
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'coll-print_export' => 'Друк/експорт',
	'coll-create_a_book' => 'Створення книги',
	'coll-create_a_book_tooltip' => 'Створити книгу або колекцію сторінок',
	'coll-book_creator' => 'Створення книги',
	'coll-download_as' => 'Завантажити як $1',
	'coll-download_as_tooltip' => 'Завантажити $1 версію цієї вікі-сторінки',
	'coll-disable' => 'вимкнути',
	'coll-book_creator_disable' => 'Вимкнути створення книжок',
	'coll-book_creator_disable_tooltip' => 'Припинити використання можливості створення книги',
	'coll-add_linked_article' => "Додати зв'язану вікі-сторінку до вашої книги",
	'coll-remove_linked_article' => 'Вилучити поточну вікі-сторінку з вашої книги',
	'coll-add_category' => 'Додати цю категорію до вашої книги',
	'coll-add_category_tooltip' => 'Додати всі вікі-сторінки цієї категорії до вашої книги',
	'coll-add_this_page' => 'Додати цю сторінку до вашої книги',
	'coll-add_page_tooltip' => 'Додати поточну вікі-сторінку до вашої книги',
	'coll-bookscategory' => 'Книги',
	'coll-clear_collection' => 'Очистити книгу',
	'coll-clear_collection_confirm' => 'Ви дійсно бажаєте повністю очистити вашу книгу?',
	'coll-clear_collection_tooltip' => 'Вилучити всі вікі-сторінки з вашої поточної книги',
	'coll-help' => 'Довідка',
	'coll-help_tooltip' => 'Показати довідку про створення книг',
	'coll-helppage' => 'Help:Книги',
	'coll-load_collection' => 'Завантажити книгу',
	'coll-load_collection_tooltip' => 'Завантажити цю книгу як вашу поточну книгу',
	'coll-n_pages' => '$1 {{PLURAL:$1|сторінка|сторінки|сторінок}}',
	'coll-printable_version_pdf' => 'PDF-версія',
	'coll-remove_this_page' => 'Вилучити цю сторінку з вашої книги',
	'coll-remove_page_tooltip' => 'Вилучити поточну вікі-сторінку з вашої книги',
	'coll-show_collection' => 'Показати книгу',
	'coll-show_collection_tooltip' => 'Натисніть, щоб редагувати/завантажити/замовити вашу книгу',
	'coll-not_addable' => 'Ця сторінка не може бути додана',
	'coll-make_suggestions' => 'Запропонувати сторінки',
	'coll-make_suggestions_tooltip' => 'Показати пропозиції, засновані на сторінках у вашій книзі',
	'coll-suggest_empty' => 'порожня',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'coll-print_export' => 'Stanpa/esporta',
	'coll-create_a_book' => 'Crea un libro',
	'coll-create_a_book_tooltip' => 'Crèa un libro o na racolta de articoli',
	'coll-book_creator' => 'Creador de libri',
	'coll-download_as' => 'Descarga come $1',
	'coll-download_as_tooltip' => 'Descarga na version $1 de sta pagina wiki',
	'coll-disable' => 'disativa',
	'coll-book_creator_disable' => 'Destaca el creador de libri',
	'coll-book_creator_disable_tooltip' => 'Desmeti de doparar el creador de libri',
	'coll-add_linked_article' => 'Zonta al to libro le pagine ligà a sta qua',
	'coll-remove_linked_article' => 'Cava dal to libro le pagine ligà a sta qua',
	'coll-add_category' => 'Zonta sta categoria al to libro',
	'coll-add_category_tooltip' => 'Zonta tute le pagine wiki de sta categoria al to libro',
	'coll-add_this_page' => 'Zonta sta pagina al to libro',
	'coll-add_page_tooltip' => 'Zonta sta pagina wiki al to libro',
	'coll-bookscategory' => 'Libri',
	'coll-clear_collection' => 'Desvòda libro',
	'coll-clear_collection_confirm' => 'Vuto dalbòn netar conpletamente el to libro?',
	'coll-clear_collection_tooltip' => 'Cava tute le pagine wiki dal to libro atuale',
	'coll-help' => 'Jùteme',
	'coll-help_tooltip' => 'Mostra le pagine de ajuto su la creassion dei libri',
	'coll-helppage' => 'Help:Libri',
	'coll-load_collection' => 'Carga libro',
	'coll-load_collection_tooltip' => 'Carga sto libro come el to libro atuale',
	'coll-n_pages' => '$1 {{PLURAL:$1|pàxena|pàxene}}',
	'coll-printable_version_pdf' => 'Versiòn PDF',
	'coll-remove_this_page' => 'Cava sta pagina dal to libro',
	'coll-remove_page_tooltip' => 'Cava sta pagina wiki dal to libro',
	'coll-show_collection' => 'Mostra libro',
	'coll-show_collection_tooltip' => 'Struca el mouse par modificar, descargar o ordinar el to libro',
	'coll-not_addable' => 'Sta pagina no se pol zontarla',
	'coll-make_suggestions' => 'Sugerissi pagine',
	'coll-make_suggestions_tooltip' => 'Fame védar dei sugerimenti basà su le pagine del me libro',
	'coll-suggest_empty' => 'vodo',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'coll-create_a_book' => 'Säta kirj',
	'coll-bookscategory' => 'Kirjad',
	'coll-help' => 'Abu',
	'coll-helppage' => 'Help:Kirjad',
	'coll-printable_version_pdf' => 'PDF-versii',
	'coll-suggest_empty' => "pall'az",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'coll-print_export' => 'In/xuất ra',
	'coll-create_a_book' => 'Tạo một quyển sách',
	'coll-create_a_book_tooltip' => 'Tạo một cuốn sách hoặc sưu tập trang',
	'coll-book_creator' => 'Bộ tạo sách',
	'coll-download_as' => 'Tải về dưới dạng $1',
	'coll-download_as_tooltip' => 'Tải về một phiên bản $1 của trang wiki này',
	'coll-disable' => 'tắt',
	'coll-book_creator_disable' => 'Tắt bộ tạo sách',
	'coll-book_creator_disable_tooltip' => 'Ngừng sử dụng bộ tạo sách',
	'coll-add_linked_article' => 'Thêm trang wiki được liên kết vào quyển sách',
	'coll-remove_linked_article' => 'Bỏ trang wiki được liên kết khỏi quyển sách',
	'coll-add_category' => 'Thêm thể loại này vào cuốn sách',
	'coll-add_category_tooltip' => 'Thêm vào sách các trang wiki thuộc thể loại được liên kết',
	'coll-add_this_page' => 'Thêm trang này vào cuốn sách',
	'coll-add_page_tooltip' => 'Thêm trang wiki này vào sách',
	'coll-bookscategory' => 'Sách',
	'coll-clear_collection' => 'Xóa sách',
	'coll-clear_collection_confirm' => 'Bạn có chắc muốn xóa hẳn sách của bạn?',
	'coll-clear_collection_tooltip' => 'Bỏ tất cả trang wiki ra khỏi sách này',
	'coll-help' => 'Trợ giúp',
	'coll-help_tooltip' => 'Xem giúp đỡ về việc tạo sách',
	'coll-helppage' => 'Help:Sách',
	'coll-load_collection' => 'Mở sách',
	'coll-load_collection_tooltip' => 'Đặt sách này làm sách hiện hành',
	'coll-n_pages' => '$1 {{PLURAL:$1|trang|trang}}',
	'coll-printable_version_pdf' => 'Bản PDF',
	'coll-remove_this_page' => 'Xóa trang này ra khỏi cuốn sách',
	'coll-remove_page_tooltip' => 'Bỏ trang wiki này ra khỏi sách',
	'coll-show_collection' => 'Xem sách',
	'coll-show_collection_tooltip' => 'Nhấn chuột để sửa đổi, tải về, hay đặt sách của bạn',
	'coll-not_addable' => 'Trang này không thêm được',
	'coll-make_suggestions' => 'Đề nghị trang',
	'coll-make_suggestions_tooltip' => 'Hiện đề nghị dựa trên các trang trong cuốn sách',
	'coll-suggest_empty' => 'trống',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'coll-create_a_book' => 'Jafön buki',
	'coll-create_a_book_tooltip' => 'Jafön buki u konleti padas',
	'coll-download_as' => 'Donükön as $1',
	'coll-add_category' => 'Läükön kladi at buke olik',
	'coll-bookscategory' => 'Buks',
	'coll-clear_collection' => 'Vagükön buki',
	'coll-clear_collection_confirm' => 'Vilol-li jenöfo vagükön buki olik lölöfiko?',
	'coll-help' => 'Yuf',
	'coll-helppage' => 'Help:Buks',
	'coll-load_collection' => 'Lodön buki',
	'coll-n_pages' => '{{PLURAL:$1|pad|pads}} $1',
	'coll-printable_version_pdf' => 'fomam-PDF',
	'coll-show_collection' => 'Jonön buki',
	'coll-suggest_empty' => 'vagik',
);

/** Yiddish (ייִדיש)
 * @author Imre
 * @author פוילישער
 */
$messages['yi'] = array(
	'coll-create_a_book' => 'שאַפֿן אַ בוך',
	'coll-download_as' => 'אַראָפלאָדן אַלס $1',
	'coll-download_as_tooltip' => 'אראָפלאָדן אַ $1 ווערסיע פון דעם וויקיפּעדיע בלאַט',
	'coll-disable' => 'אָפאַקטיוויזירן',
	'coll-bookscategory' => 'ביכער',
	'coll-help' => 'הילף',
	'coll-n_pages' => '$1 {{PLURAL:$1|בלאַט|בלעטער}}',
	'coll-suggest_empty' => 'ליידיק',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'coll-print_export' => 'Ìtẹ́síìwé/ìkójáde',
	'coll-create_a_book' => 'Dá ìwé',
	'coll-create_a_book_tooltip' => 'Dá ìwé tàbí ìkójọ ojúewé',
	'coll-book_creator' => 'Olùdá ìwé',
	'coll-download_as' => 'Rùsílẹ̀ gẹ́gẹ́ bíi $1',
	'coll-download_as_tooltip' => 'Rùsílẹ̀ àtẹ́jáde $1 ojúewé wiki yìí',
	'coll-disable' => 'ìdálẹ́kun',
	'coll-book_creator_disable' => 'Ìdálẹ́kun olùdá ìwé',
	'coll-book_creator_disable_tooltip' => 'Jáwọ́ lílo olùdá ìwé',
	'coll-add_linked_article' => 'Ṣàfikún ojúewé wiki jíjápọ̀ mọ́ ìwé yín',
	'coll-add_category' => 'Ṣàfikún ẹ̀ka yìí mọ́ ìwé yín',
	'coll-add_this_page' => 'Ṣàfikún ojúewé yìí mọ́ ìwé yín',
	'coll-bookscategory' => 'Àwọn ìwé',
	'coll-help' => 'Ìrànwọ́',
	'coll-help_tooltip' => 'Àfihàn ìránwọ́ nípa dídá àwọn ìwé',
	'coll-helppage' => 'Help:Àwọn ìwé',
	'coll-load_collection' => 'Gbé ìwé síta',
	'coll-load_collection_tooltip' => 'Gbé ìwé yìí síta bíi ìwé yín lọ́wọ́lọ́wọ́',
	'coll-n_pages' => '{{PLURAL:$1|ojúewé|àwọn ojúewé}} $1',
	'coll-printable_version_pdf' => 'Àtẹ̀jáde PDF',
	'coll-remove_this_page' => 'Ẹ yọ ojúewé yìí kúrò nínú ìwé yín',
	'coll-remove_page_tooltip' => 'Ẹ yọ ojúewé wiki lọ́wọ́lọ́wó yìí kúrò nínú ìwé yín',
	'coll-show_collection' => 'Àfihàn ìwé',
	'coll-not_addable' => 'Ojúewé yìí kò ṣe é ṣàfikún',
	'coll-make_suggestions' => 'Ìdámọ́ràn ojúewé',
	'coll-make_suggestions_tooltip' => 'Àfihàn àwọn ìdámọ̀ràn nípa àwọn ojúewé inú ìwé yín',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'coll-create_a_book' => '整一本書',
	'coll-download_as' => '下載做$1',
	'coll-add_category' => '加分類',
	'coll-bookscategory' => '書',
	'coll-clear_collection' => '清書',
	'coll-clear_collection_confirm' => '你係咪真係想完全噉清晒你本書？',
	'coll-helppage' => 'Help:書',
	'coll-load_collection' => '載入書',
	'coll-n_pages' => '$1版',
	'coll-printable_version_pdf' => 'PDF版',
	'coll-show_collection' => '顯示書',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Liangent
 * @author Wmr89502270
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'coll-print_export' => '打印/导出',
	'coll-create_a_book' => '创建图书',
	'coll-create_a_book_tooltip' => '创建图书或页面集',
	'coll-book_creator' => '图书创建器',
	'coll-download_as' => '下载为$1',
	'coll-download_as_tooltip' => '下载本wiki页面的$1版本',
	'coll-disable' => '停用',
	'coll-book_creator_disable' => '停用图书创建器',
	'coll-book_creator_disable_tooltip' => '停止使用图书创建器',
	'coll-add_linked_article' => '添加相关wiki页面至你的图书',
	'coll-remove_linked_article' => '从你的图书中删除相关wiki页面',
	'coll-add_category' => '添加本分类至你的图书',
	'coll-add_category_tooltip' => '添加本分类中的所有wiki页面至你的图书',
	'coll-add_this_page' => '添加本页面至你的图书',
	'coll-add_page_tooltip' => '添加本wiki页面至你的图书',
	'coll-bookscategory' => '图书',
	'coll-clear_collection' => '清空图书',
	'coll-clear_collection_confirm' => '你真的想要完全清空你的图书？',
	'coll-clear_collection_tooltip' => '删除你的图书中的所有wiki页面',
	'coll-help' => '帮助',
	'coll-help_tooltip' => '显示关于创建图书的帮助',
	'coll-helppage' => 'Help:图书',
	'coll-load_collection' => '载入图书',
	'coll-load_collection_tooltip' => '载入本图书作为你的图书',
	'coll-n_pages' => '$1个页面',
	'coll-printable_version_pdf' => 'PDF版本',
	'coll-remove_this_page' => '从你的图书中删除本页面',
	'coll-remove_page_tooltip' => '从你的图书中删除本wiki页面',
	'coll-show_collection' => '显示图书',
	'coll-show_collection_tooltip' => '单击此处编辑/下载/订购你的图书',
	'coll-not_addable' => '无法添加本页面',
	'coll-make_suggestions' => '建议页面',
	'coll-make_suggestions_tooltip' => '显示根据你的图书中的页面生成的建议',
	'coll-suggest_empty' => '空',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Anakmalaysia
 * @author Liangent
 * @author Xiaomingyan
 */
$messages['zh-hant'] = array(
	'coll-print_export' => '列印/匯出',
	'coll-create_a_book' => '建立圖書',
	'coll-create_a_book_tooltip' => '建立圖書或頁面集合',
	'coll-book_creator' => '圖書創建器',
	'coll-download_as' => '下載為 $1',
	'coll-download_as_tooltip' => '下載這個wiki頁面的$1版本',
	'coll-disable' => '停用',
	'coll-book_creator_disable' => '禁用圖書創建器',
	'coll-book_creator_disable_tooltip' => '停止使用圖書創建器',
	'coll-add_linked_article' => '添加相關維基頁面至你的圖書',
	'coll-remove_linked_article' => '從你的圖書中刪除相關維基頁面',
	'coll-add_category' => '將此分類增加到圖書',
	'coll-add_category_tooltip' => '將這個分類中的所有維基頁面加入您的圖書中',
	'coll-add_this_page' => '將此頁面增加到圖書',
	'coll-add_page_tooltip' => '將當前的維基頁面加入您的圖書中',
	'coll-bookscategory' => '圖書',
	'coll-clear_collection' => '清除記錄',
	'coll-clear_collection_confirm' => '真的要完全清除？',
	'coll-clear_collection_tooltip' => '從您目前的圖書中移除所有維基頁面',
	'coll-help' => '幫助',
	'coll-help_tooltip' => '顯示關於建立圖書的說明',
	'coll-helppage' => 'Help:圖書',
	'coll-load_collection' => '載入圖書',
	'coll-load_collection_tooltip' => '將這本圖書加載為您目前的圖書',
	'coll-n_pages' => '$1個頁面',
	'coll-printable_version_pdf' => 'PDF 版本',
	'coll-remove_this_page' => '從圖書中移除此頁面',
	'coll-remove_page_tooltip' => '將目前維基頁面從您的圖書中移除',
	'coll-show_collection' => '顯示圖書',
	'coll-show_collection_tooltip' => '點擊此處編輯、下載或訂購圖書',
	'coll-not_addable' => '無法加載此頁',
	'coll-make_suggestions' => '建議頁面',
	'coll-make_suggestions_tooltip' => '根據您圖書中的頁面顯示建議',
	'coll-suggest_empty' => '空',
);

