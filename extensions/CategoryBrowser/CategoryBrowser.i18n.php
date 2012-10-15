<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of CategoryBrowser.
 *
 * CategoryBrowser is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CategoryBrowser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CategoryBrowser; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * CategoryBrowser is an AJAX-enabled category filter and browser for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named CategoryBrowser into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/CategoryBrowser/CategoryBrowser.php";
 *
 * @version 0.3.1
 * @link http://www.mediawiki.org/wiki/Extension:CategoryBrowser
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

/**
 * Messages list.
 */

$messages = array();

/** English (English)
 * @author QuestPC
 */
$messages['en'] = array(
	'categorybrowser' => 'Category browser',
	'categorybrowser-desc' => 'Provides a [[Special:CategoryBrowser|special page]] to filter out most populated categories and to navigate them using an AJAX interface',
	'cb_requires_javascript' => 'The category browser extension requires JavaScript to be enabled in the browser.',
	'cb_ie6_warning' => 'The condition editor does not work in Internet Explorer 6.0 or earlier versions.
However, browsing of pre-defined conditions should work normally.
Please change or upgrade your browser, if possible.',
	'cb_show_no_parents_only' => 'Show only categories which have no parents',
	'cb_cat_name_filter' => 'Search for category by name:',
	'cb_cat_name_filter_clear' => 'Press to clear category name filter',
	'cb_cat_name_filter_ci' => 'Case insensitive',
	'cb_copy_line_hint' => 'Use the [+] and [>+] buttons to copy and paste operators into the selected expression',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategory|subcategories}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|page|pages}}',
	'cb_has_files' => '$1 {{PLURAL:$1|file|files}}',
	'cb_has_parentcategories' => 'parent categories (if any)',
	'cb_previous_items_link' => 'Previous',
	'cb_previous_items_stats' => ' ($1 - $2)', # only translate this message to other languages if you have to change it
	'cb_previous_items_line' => '$1 $2', # do not translate or duplicate this message to other languages
	'cb_next_items_link' => 'Next',
	'cb_next_items_stats' => ' (from $1)',
	'cb_next_items_line' => '$1 $2', # do not translate or duplicate this message to other languages
	'cb_cat_subcats' => 'subcategories',
	'cb_cat_pages' => 'pages',
	'cb_cat_files' => 'files',
	'cb_apply_button' => 'Apply',
	'cb_op1_template' => '$1[$2]', # do not translate or duplicate this message to other languages
	'cb_op2_template' => '$1 $2 $3', # do not translate or duplicate this message to other languages
	'cb_all_op' => 'All',
	'cb_lbracket_op' => '(', # do not translate or duplicate this message to other languages
	'cb_rbracket_op' => ')', # do not translate or duplicate this message to other languages
	'cb_or_op' => 'or',
	'cb_and_op' => 'and',
	'cb_ge_op' => '>=', # do not translate or duplicate this message to other languages
	'cb_le_op' => '<=', # do not translate or duplicate this message to other languages
	'cb_eq_op' => '=', # do not translate or duplicate this message to other languages
	'cb_edit_left_hint' => 'Move left, if possible',
	'cb_edit_right_hint' => 'Move right, if possible',
	'cb_edit_remove_hint' => 'Delete, if possible',
	'cb_edit_copy_hint' => 'Copy operator to clipboard',
	'cb_edit_append_hint' => 'Insert operator to last position',
	'cb_edit_clear_hint' => 'Clear current expression (select all)',
	'cb_edit_paste_hint' => 'Paste operator into current position, if possible',
	'cb_edit_paste_right_hint' => 'Paste operator into next position, if possible',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author QuestPC
 * @author Umherirrender
 * @author Yekrats
 */
$messages['qqq'] = array(
	'categorybrowser-desc' => '{{desc}}
CategoryBrowser creates special page which implements AJAX-enabled category filter and browser for MediaWiki. 
For more information, see http://www.mediawiki.org/wiki/Extension:CategoryBrowser',
	'cb_cat_name_filter_ci' => 'Dialog string for case insensitive category name search.',
	'cb_has_pages' => '{{Identical|Page}}',
	'cb_has_files' => '{{Identical|File}}',
	'cb_previous_items_link' => '{{Identical|Previous}}',
	'cb_previous_items_stats' => '{{optional}}',
	'cb_next_items_link' => '{{Identical|Next}}',
	'cb_cat_pages' => '{{Identical|Pages}}',
	'cb_cat_files' => '{{Identical|File}}',
	'cb_apply_button' => '{{Identical|Apply}}',
	'cb_all_op' => 'Operator to select all categories available.
{{Identical|All}}',
	'cb_or_op' => '{{Identical|Or}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'categorybrowser' => 'Kategorie-blaaier',
	'cb_cat_name_filter' => 'Soek vir kategorie met die naam:',
	'cb_cat_name_filter_ci' => 'Kas onsensitief',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subkategorie|subkategorieë}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|bladsy|bladsye}}',
	'cb_has_files' => '$1 {{PLURAL:$1|lêer|lêers}}',
	'cb_has_parentcategories' => 'boonste kategorieë (indien enige)',
	'cb_previous_items_link' => 'Vorige',
	'cb_next_items_link' => 'Volgende',
	'cb_next_items_stats' => '(vanaf $1)',
	'cb_cat_subcats' => 'subkategorië',
	'cb_cat_pages' => 'bladsye',
	'cb_cat_files' => 'lêers',
	'cb_apply_button' => 'Pas toe',
	'cb_all_op' => 'Alle',
	'cb_or_op' => 'of',
	'cb_and_op' => 'en',
	'cb_edit_left_hint' => 'Skuif na links, indien moontlik',
	'cb_edit_right_hint' => 'Skuif na regs, indien moontlik',
	'cb_edit_remove_hint' => 'Verwyder, indien moontlik',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'cb_has_pages' => '$1 {{PLURAL:$1|pachina|pachinas}}',
);

/** Arabic (العربية)
 * @author OsamaK
 * @author روخو
 */
$messages['ar'] = array(
	'cb_has_pages' => '{{PLURAL:$1|لا صفحات|صفحة واحدة|صفحتان|$1 صفحات|$1 صفحة}}',
	'cb_has_files' => '{{PLURAL:$1|لا ملفات|ملف واحد|ملفان|$1 ملفات|$1 ملفًا|$1 ملف}}',
	'cb_previous_items_link' => 'السابق',
	'cb_next_items_link' => 'التالي',
	'cb_next_items_stats' => ' (من $1)',
	'cb_cat_subcats' => 'تصنيفات فرعية',
	'cb_cat_pages' => 'الصفحات',
	'cb_cat_files' => 'ملفات',
	'cb_apply_button' => 'طبّق',
	'cb_all_op' => 'الكل',
	'cb_or_op' => 'أو',
	'cb_and_op' => 'و',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'cb_next_items_stats' => ' (ܡܢ $1)',
	'cb_cat_pages' => 'ܕܦ̈ܐ',
	'cb_cat_files' => 'ܠܦܦ̈ܐ',
	'cb_all_op' => 'ܟܠ',
	'cb_or_op' => 'ܐܘ',
	'cb_and_op' => 'ܘ',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'cb_has_files' => '$1 {{PLURAL:$1|ficheru|ficheros}}',
	'cb_cat_files' => 'ficheros',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Sortilegus
 * @author Vago
 */
$messages['az'] = array(
	'cb_previous_items_link' => 'Əvvəlki',
	'cb_next_items_link' => 'Sonrakı',
	'cb_cat_pages' => 'səhifələr',
	'cb_cat_files' => 'fayllar',
	'cb_apply_button' => 'Tətbit et',
	'cb_all_op' => 'Hamısı',
	'cb_or_op' => 'və ya',
	'cb_and_op' => 'və',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'categorybrowser' => 'Категориялар ҡарау',
	'categorybrowser-desc' => 'Вики-сайттың иң тулы категорияларын һайлау һәм артабан улар булап AJAX-интерфейс ярҙамында йөрөү өсөн [[Special:CategoryBrowser|махсус]] бит менән тәьмин итә.',
	'cb_requires_javascript' => 'Категориялар ҡарау өсөн киңәйтеү браузерҙа Javascript эшләүен талап итә.',
	'cb_ie6_warning' => 'Шарттарҙы мөхәррирләү өсөн ҡорал Internet Explorer браузерының 6.0 һәм элеккерәк өлгөләрендә эшләмәй.
Алдан билдәләнгән шарттарҙы ғына ҡарау мөмкин.
Зинһар, браузерығыҙҙы алыштырығыҙ йәки яңыртығыҙ.',
	'cb_show_no_parents_only' => 'Инә категориялары булмаған категорияларҙы ғына күрһәтергә',
	'cb_cat_name_filter' => 'Категорияны исеме буйынса эҙләү:',
	'cb_cat_name_filter_clear' => 'Категорияны исеме буйынса эҙләүҙе таҙартыу өсөн ошонда баҫығыҙ',
	'cb_cat_name_filter_ci' => 'Ҙур/бәләкәй хәрефкә һиҙгер түгел',
	'cb_copy_line_hint' => 'Операторҙы һайланған аңлатмаға күсереп яҙыр өсөн [+] һәм [>+] төймәләрен ҡулланығыҙ',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|Эске категория}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|бит}}',
	'cb_has_files' => '$1 {{PLURAL:$1|файл}}',
	'cb_has_parentcategories' => 'инә категориялары (әгәр булһа)',
	'cb_previous_items_link' => 'Алдағы',
	'cb_next_items_link' => 'Киләһе',
	'cb_next_items_stats' => '($1 башлап)',
	'cb_cat_subcats' => 'эске категориялар',
	'cb_cat_pages' => 'биттәр',
	'cb_cat_files' => 'файл',
	'cb_apply_button' => 'Ҡулланырға',
	'cb_all_op' => 'Барыһы ла',
	'cb_or_op' => 'йәки',
	'cb_and_op' => 'һәм',
	'cb_edit_left_hint' => 'Әгәр мөмкин булһа, һулға күсерергә',
	'cb_edit_right_hint' => 'Әгәр мөмкин булһа, уңға күсерергә',
	'cb_edit_remove_hint' => 'Әгәр мөмкин булһа, юйырға',
	'cb_edit_copy_hint' => 'Операторҙы ваҡытлы һаҡлағысҡа яҙҙырырға',
	'cb_edit_append_hint' => 'Операторҙы һуңғы урынға өҫтәргә',
	'cb_edit_clear_hint' => 'Әлеге аңлатманы таҙартырға (барыһын да һайларға)',
	'cb_edit_paste_hint' => 'Әгәр мөмкин булһа, операторҙы әлеге урынға өҫтәргә',
	'cb_edit_paste_right_hint' => 'Әгәр мөмкин булһа, операторҙы киләһе урынға өҫтәргә',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'categorybrowser' => 'Прагляд катэгорыяў',
	'categorybrowser-desc' => 'Дадае [[Special:CategoryBrowser|спэцыяльную старонку]] для выбару найбольш поўных катэгорыяў для іх навігацыі з выкарыстаньнем AJAX-інтэрвэйсу',
	'cb_requires_javascript' => 'Пашырэньне для прагляду катэгорыяў патрабуе ўключэньне JavaScript у браўзэры.',
	'cb_ie6_warning' => 'Рэдактар станаў не працуе ў Internet Explorer 6.0 ці больш раньніх вэрсіях.
Тым ня менш, прагляд ужо вызначаных станаў павінен працаваць нармальна.
Калі ласка, зьмяніце ці абнавіце Ваш браўзэр, калі гэта магчыма.',
	'cb_show_no_parents_only' => 'Паказваць толькі катэгорыі без бацькоўскіх',
	'cb_cat_name_filter' => 'Пошук катэгорыяў па назьве:',
	'cb_cat_name_filter_clear' => 'Націсьніце для ачысткі фільтру назваў катэгорыяў',
	'cb_cat_name_filter_ci' => 'Без уліку рэгістру',
	'cb_copy_line_hint' => 'Выкарыстоўвайце кнопкі [+] і [>+] для капіяваньня і ўстаўкі апэратара ў выбраны выраз',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|падкатэгорыя|падкатэгорыі|падкатэгорыяў}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|старонка|старонкі|старонак}}',
	'cb_has_files' => '$1 {{PLURAL:$1|файл|файлы|файлаў}}',
	'cb_has_parentcategories' => 'бацькоўскія катэгорыі (калі ёсьць)',
	'cb_previous_items_link' => 'Папярэднія',
	'cb_next_items_link' => 'Наступныя',
	'cb_next_items_stats' => '(ад $1)',
	'cb_cat_subcats' => 'падкатэгорыі',
	'cb_cat_pages' => 'старонкі',
	'cb_cat_files' => 'файлы',
	'cb_apply_button' => 'Ужыць',
	'cb_all_op' => 'Усе',
	'cb_or_op' => 'ці',
	'cb_and_op' => 'і',
	'cb_edit_left_hint' => 'Перанесьці ўлева, калі магчыма',
	'cb_edit_right_hint' => 'Перанесьці ўправа, калі магчыма',
	'cb_edit_remove_hint' => 'Выдаліць, калі магчыма',
	'cb_edit_copy_hint' => 'Скапіяваць апэратар у буфэр абмену',
	'cb_edit_append_hint' => 'Уставіць апэратар у апошнюю пазыцыю',
	'cb_edit_clear_hint' => 'Ачысьціць цяперашні выраз (выбраць усё)',
	'cb_edit_paste_hint' => 'Уставіць апэратар у цяперашнюю пазыцыю, калі магчыма',
	'cb_edit_paste_right_hint' => 'Уставіць апэратар у наступную пазыцыю, калі магчыма',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'cb_has_subcategories' => '$1 {{PLURAL:$1|подкатегория|подкатегории}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|страница|страници}}',
	'cb_has_files' => '$1 {{PLURAL:$1|файл|файла}}',
	'cb_next_items_stats' => ' (от $1)',
	'cb_cat_subcats' => 'подкатегории',
	'cb_cat_pages' => 'страници',
	'cb_cat_files' => 'файлове',
	'cb_apply_button' => 'Прилагане',
	'cb_all_op' => 'Всички',
	'cb_or_op' => 'или',
	'cb_and_op' => 'и',
	'cb_edit_remove_hint' => 'Изтриване, ако е възможно',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'categorybrowser' => 'বিষয়শ্রেণী পরিদর্শক',
	'cb_requires_javascript' => 'এই বিষয়শ্রেণী পরিদর্শক এক্সটেনশনটি ব্রাউজারে সক্রিয় করতে জাভাস্ক্রিপ্ট প্রয়োজন।',
	'cb_show_no_parents_only' => 'শুধুমাত্র সেই বিষয়শ্রেণীগুলোই প্রদর্শন করো যার কোনো মাতৃ-বিষয়শ্রেণী নেই',
	'cb_cat_name_filter' => 'নাম অনুসারে বিষয়শ্রেণী খুঁজুন:',
	'cb_cat_name_filter_clear' => 'বিষয়শ্রেণী নামের ফিল্টার পরিস্কার করতে বাটন প্রেস করুন',
	'cb_cat_name_filter_ci' => 'কেস সেনসিটিভ',
	'cb_copy_line_hint' => 'নির্ধারিত এক্সপ্রেশনে অপারেটসমূহ কপি ও পেস্ট করতে [+] ও [>+] বাটন ব্যবহার করুন',
	'cb_has_subcategories' => '$1টি {{PLURAL:$1|উপবিষয়শ্রেণী|উপবিষয়শ্রেণীসমূহ}}',
	'cb_has_pages' => '$1টি {{PLURAL:$1|পাতা|পাতা}}',
	'cb_has_files' => '$1টি {{PLURAL:$1|ফাইল|ফাইল}}',
	'cb_has_parentcategories' => 'মাতৃ বিষয়শ্রেণী (যদি থাকে)',
	'cb_previous_items_link' => 'পূর্ববর্তী',
	'cb_next_items_link' => 'পরবর্তী',
	'cb_next_items_stats' => ' ($1 থেকে)',
	'cb_cat_subcats' => 'উপবিষয়শ্রেণী',
	'cb_cat_pages' => 'পাতা',
	'cb_cat_files' => 'ফাইল',
	'cb_apply_button' => 'অাবেদন',
	'cb_all_op' => 'সকল',
	'cb_or_op' => 'অথবা',
	'cb_and_op' => 'এবং',
	'cb_edit_left_hint' => 'সম্ভব হলে, বামে সরান',
	'cb_edit_right_hint' => 'সম্ভব হলে, ডানে সরান',
	'cb_edit_remove_hint' => 'সম্ভব হলে, অপসারণ করুন',
	'cb_edit_copy_hint' => 'অপারেট ক্লিপবোর্ডে কপি করুন',
	'cb_edit_append_hint' => 'সর্বশেষ অবস্থানে অপারেটর যোগ করুন',
	'cb_edit_clear_hint' => 'বর্তমান এক্সপ্রেশন পরিস্কার করুন (সবকিছু নির্বাচন)',
	'cb_edit_paste_hint' => 'সম্ভব হলে, অপারেটর বর্তমান অবস্থানে পেস্ট করুন',
	'cb_edit_paste_right_hint' => 'সম্ভব হলে, অপারেটর সামনের অবস্থানে পেস্ট করুন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'categorybrowser' => 'Merdeer rummadoù',
	'categorybrowser-desc' => 'A ro ur [[Special:CategoryBrowser|bajenn ispisial]] evit silañ ar brasañ eus ar rummadoù ha gellet merdeiñ enno en ur implijout an etrefas AJAX',
	'cb_requires_javascript' => "Merdeer ar rummadoù a c'houlenn ma vefe aotreet JavaScript gant ar merdeer web.",
	'cb_ie6_warning' => "Ne za ket en-dro an embanner amplegadek en Internet Explorer 6.0 pe gant stummoù koshañ.
Koulskoude, merdeadur an amplegadek raktermenet a rankfe mont-en-dro d'un doare normal.
Mar plij, cheñchit pe hizivit ho merdeer.",
	'cb_show_no_parents_only' => 'Diskouez ar rummadoù emzivad',
	'cb_cat_name_filter' => "O klask war-lec'h rummadoù hervez o anv :",
	'cb_cat_name_filter_clear' => 'Pouezit evit dizober sil anv ar rummad',
	'cb_cat_name_filter_ci' => 'Diseblant ouzh ar pennlizherenoù',
	'cb_copy_line_hint' => 'Implijit ar boutonoù [+] ha [>+] evit eilañ ha pegañ an oberataerioù er jedad dibabet',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|isrummad|isrummad}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|pajenn|pajenn}}',
	'cb_has_files' => '$1 {{PLURAL:$1|restr|restr}}',
	'cb_has_parentcategories' => 'Usrummadoù (ma vez reoù)',
	'cb_previous_items_link' => 'Kent',
	'cb_next_items_link' => "War-lerc'h",
	'cb_next_items_stats' => '(eus $1)',
	'cb_cat_subcats' => 'isrummadoù',
	'cb_cat_pages' => 'pajennoù',
	'cb_cat_files' => 'restroù',
	'cb_apply_button' => 'Arloañ',
	'cb_all_op' => 'An holl',
	'cb_or_op' => 'pe',
	'cb_and_op' => 'ha',
	'cb_edit_left_hint' => "Dilec'hiañ a-gleiz, mard eo posubl",
	'cb_edit_right_hint' => "Dilec'hiañ a-zehoù, mard eo posubl",
	'cb_edit_remove_hint' => 'Lemel, mard eo posubl',
	'cb_edit_copy_hint' => 'Eilañ an oberataer er golver',
	'cb_edit_append_hint' => "Ensoc'hañ an oberataer er plas diwezhañ",
	'cb_edit_clear_hint' => 'Dizober ar jedad-mañ (dibab pep tra)',
	'cb_edit_paste_hint' => 'Pegañ an oberataer amañ, mard eo posubl',
	'cb_edit_paste_right_hint' => "Pegañ an oberataer d'al lec'hiadur war-lec'h, mard eo posubl",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'categorybrowser' => 'Preglednik kategorija',
	'categorybrowser-desc' => 'Omogućuje [[Special:CategoryBrowser|posebnu stranicu]] za filtriranje najviše napunjenih kategorija te navigacija u njima putem AJAX interfejsa',
	'cb_requires_javascript' => 'Proširenje za preglednik kategorija zahtjeva da JavaScript bude omogućen u pregledniku.',
	'cb_ie6_warning' => 'Uređivač uslova ne radi u pregledniku Internet Explorer 6.0 ili ranijim verzijama.
Međutim, pregledanje predefiniranih uslova bi trebalo raditi normalno.
Molimo promijenite ili ažurirajte verziju vašeg preglednika, ako je moguće.',
	'cb_show_no_parents_only' => 'Prikaži samo kategorije koje nemaju nadkategoriju',
	'cb_cat_name_filter' => 'Pretraga kategorija po nazivu:',
	'cb_cat_name_filter_clear' => 'Pritisnite za čišćenje filtera naziva kategorije',
	'cb_cat_name_filter_ci' => 'Ne razlikuje velika slova',
	'cb_copy_line_hint' => 'Koristite dugmad [+] i [>+] za kopiranje i lijepljenje operatora na odabrani izraz',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|podkategorija|podkategorije|podkategorija}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|stranica|stranice|stranica}}',
	'cb_has_files' => '$1 {{PLURAL:$1|datoteka|datoteke|datoteka}}',
	'cb_has_parentcategories' => 'nadkategorije (ako ih ima)',
	'cb_previous_items_link' => 'Prethodno',
	'cb_next_items_link' => 'Slijedeći',
	'cb_next_items_stats' => '(od $1)',
	'cb_cat_subcats' => 'potkategorije',
	'cb_cat_pages' => 'stranice',
	'cb_cat_files' => 'datoteke',
	'cb_apply_button' => 'Primijeni',
	'cb_all_op' => 'Sve',
	'cb_or_op' => 'ili',
	'cb_and_op' => 'i',
	'cb_edit_left_hint' => 'Premjesti lijevo, ako je moguće',
	'cb_edit_right_hint' => 'Premjesti desno, ako je moguće',
	'cb_edit_remove_hint' => 'Obriši, ako je moguće',
	'cb_edit_copy_hint' => 'Kopiraj operator u privremenu ostavu',
	'cb_edit_append_hint' => 'Ubaci operator na posljednju poziciju',
	'cb_edit_clear_hint' => 'Očisti trenutni izraz (odaberi sve)',
	'cb_edit_paste_hint' => 'Zalijepi operator na trenutnu poziciju, ako je moguće',
	'cb_edit_paste_right_hint' => 'Zalijepi operator na slijedeću poziciju, ako je moguće',
);

/** Catalan (Català)
 * @author El libre
 * @author Solde
 */
$messages['ca'] = array(
	'categorybrowser' => 'Navegador de categories',
	'cb_show_no_parents_only' => 'Mostra només les categories que no tenen categories superiors',
	'cb_cat_name_filter' => 'Cerca la categoria pel nom:',
	'cb_cat_name_filter_clear' => 'Fes clic aquí per netejar el filtre del nom de categoria',
	'cb_cat_name_filter_ci' => 'No distingeix entre majúscules i minúscules',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategoria|subcategories}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|pàgina|pàgines}}',
	'cb_has_files' => '$1 {{PLURAL:$1|arxiu|arxius}}',
	'cb_has_parentcategories' => "categories superiors (si n'hi ha)",
	'cb_previous_items_link' => 'Anterior',
	'cb_next_items_link' => 'Següent',
	'cb_next_items_stats' => ' (de $1)',
	'cb_cat_subcats' => 'subcategories',
	'cb_cat_pages' => 'pàgines',
	'cb_cat_files' => 'fitxers',
	'cb_apply_button' => 'Aplicar',
	'cb_all_op' => 'Tots',
	'cb_or_op' => 'o',
	'cb_and_op' => 'i',
	'cb_edit_left_hint' => "Mou a l'esquerra, si és possible",
	'cb_edit_right_hint' => 'Mou a la dreta, si és possible',
	'cb_edit_remove_hint' => 'Esborra, si és possible',
	'cb_edit_copy_hint' => "Copia l'operador al portapapers",
	'cb_edit_append_hint' => "Insereix l'operador en l'última posició",
	'cb_edit_clear_hint' => "Neteja l'expressió present (selecciona totes)",
	'cb_edit_paste_hint' => 'Enganxa operador a la seva posició actual, si és possible',
	'cb_edit_paste_right_hint' => 'Enganxa operador a la posició següent, si és possible',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'cb_cat_name_filter' => 'Кадегар лахар цIерашца:',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|бухаркадегар|бухаркадегарш}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|агlо|агlонаш}}',
	'cb_has_files' => '$1 {{PLURAL:$1|хlум|хlумнаш}}',
	'cb_cat_subcats' => 'бухаркадегарш',
	'cb_cat_pages' => 'агlонаш',
	'cb_cat_files' => 'хlумнаш',
	'cb_all_op' => 'Массо',
);

/** Czech (Česky)
 * @author Jkjk
 */
$messages['cs'] = array(
	'categorybrowser' => 'Prohližeč kategorií',
	'categorybrowser-desc' => ' [[Special:CategoryBrowser|Speciální strana]] pro odfiltrování kategorií s největším počtem položek a jejich prohlížení přes rozhraní AJAX.',
	'cb_requires_javascript' => 'Rozšíření prohlížeč kategorií vyžaduje, aby byl JavaScrpt v prohlížeči povolen.',
	'cb_show_no_parents_only' => 'Zobrazí kategorie, které nejsou v žádné nadřazené kategorii',
	'cb_cat_name_filter' => 'Hledat kategorii podle jejího názvu:',
	'cb_cat_name_filter_clear' => 'Stiskněte k vymazání filtru názvu kategorií',
	'cb_cat_name_filter_ci' => 'Citlivost na velká písmena',
	'cb_has_files' => '$1 {{PLURAL:$1|soubor|soubory|souborů}}',
	'cb_has_parentcategories' => 'rodičovské kategorie (pokud existují)',
	'cb_previous_items_link' => 'Předchozí',
	'cb_next_items_link' => 'Další',
	'cb_next_items_stats' => '(z $1)',
	'cb_cat_subcats' => 'podkategorie',
	'cb_cat_pages' => 'stránky',
	'cb_cat_files' => 'soubory',
	'cb_apply_button' => 'Aplikuj',
	'cb_all_op' => 'Všechno',
	'cb_or_op' => 'nebo',
	'cb_and_op' => 'a',
	'cb_edit_remove_hint' => 'Smazat, pokud je to možné',
);

/** Welsh (Cymraeg)
 * @author Pwyll
 */
$messages['cy'] = array(
	'categorybrowser' => 'Porwr categorïau',
	'categorybrowser-desc' => "Yn darparu [[Special:CategoryBrowser|tudalen arbennig]] i hidlo'r categorïau mwyaf poblog ac i'w llywio gan ddefnyddio rhyngwyneb AJAX",
	'cb_requires_javascript' => 'Mae angen galluogi Javascript yn y porwr ar gyfer yr estyniad porwr categorïau.',
	'cb_cat_name_filter' => 'Chwilio am gategori yn ôl enw',
	'cb_cat_name_filter_clear' => "Gwasgwch i glirio'r hidlydd enw categorïau",
	'cb_previous_items_link' => 'Blaenorol',
	'cb_next_items_link' => 'Nesaf',
	'cb_next_items_stats' => '(oddi wrth $1)',
	'cb_cat_subcats' => 'Is-gategorïau',
	'cb_cat_pages' => 'Tudalennau',
);

/** German (Deutsch)
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'categorybrowser' => 'Kategorienbrowser',
	'categorybrowser-desc' => 'Ergänzt eine [[Special:CategoryBrowser|Spezialseite]] mit der die umfangreichsten Kategorien ausgewählt und in ihnen über ein Ajax-Interface navigiert werden kann',
	'cb_requires_javascript' => 'Um den Kategorienbrowser nutzen zu können, muss JavaScript im Browser aktiviert sein.',
	'cb_ie6_warning' => 'Der Editor für Bedingungen funktioniert nicht beim Internet Explorer 6.0 oder einer früheren Version.
Allerdings sollte das Browsen mit vordefinierten Bedingungen normalerweise funktionieren.
Dennoch sollte, sofern irgend möglich, der Browser aktualisiert oder gewechselt werden.',
	'cb_show_no_parents_only' => 'Nur Kategorien ohne übergeordnete Kategorie anzeigen',
	'cb_cat_name_filter' => 'Suche einer Kategorie anhand deren Namen:',
	'cb_cat_name_filter_clear' => 'Zum Zurücksetzen des Filters nach Kategoriename anklicken',
	'cb_cat_name_filter_ci' => 'Schreibungsunabhängig',
	'cb_copy_line_hint' => 'Zum Kopieren und Einfügen von Operatoren in die ausgewählten Ausdrücke, die Schaltflächen [+] und [>+] verwenden',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|Unterkategorie|Unterkategorien}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|Seite|Seiten}}',
	'cb_has_files' => '$1 {{PLURAL:$1|Datei|Dateien}}',
	'cb_has_parentcategories' => 'übergeordneten Kategorien (falls vorhanden)',
	'cb_previous_items_link' => 'Vorherige',
	'cb_next_items_link' => 'Nächste',
	'cb_next_items_stats' => ' (ab $1)',
	'cb_cat_subcats' => 'Unterkategorien',
	'cb_cat_pages' => 'Seiten',
	'cb_cat_files' => 'Dateien',
	'cb_apply_button' => 'Anwenden',
	'cb_all_op' => 'Alle',
	'cb_or_op' => 'oder',
	'cb_and_op' => 'und',
	'cb_edit_left_hint' => 'Nach links bewegen (sofern möglich)',
	'cb_edit_right_hint' => 'Nach rechts bewegen (sofern möglich)',
	'cb_edit_remove_hint' => 'Löschen (sofern möglich)',
	'cb_edit_copy_hint' => 'Operator in die Zwischenablage kopieren',
	'cb_edit_append_hint' => 'Operator an letzter Position einfügen',
	'cb_edit_clear_hint' => 'Aktuelle Ausdrücke entfernen (alle auswählen)',
	'cb_edit_paste_hint' => 'Operator an aktueller Position einfügen (sofern möglich)',
	'cb_edit_paste_right_hint' => 'Operator an nächstmöglicher Position einfügen (sofern möglich)',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'cb_cat_pages' => 'peli',
	'cb_or_op' => 'ya zi',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'categorybrowser' => 'Wobglědowak kategorijow',
	'cb_show_no_parents_only' => 'Jano kategorije pokazaś, kótarež njamaju nadrědowane kategorije.',
	'cb_cat_name_filter' => 'Kategoriju pó mjenju pytaś:',
	'cb_cat_name_filter_ci' => 'Wjelikopisanje ignorěrowaś',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|pódkategorija|pódkategoriji|pódkategorije|pódkategorijow}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|bok|boka|boki|bokow}}',
	'cb_has_files' => '$1 {{PLURAL:$1|dataja|dataji|dataje|datajow}}',
	'cb_has_parentcategories' => 'nadrědowane kategorije (jolic eksistěruju)',
	'cb_previous_items_link' => 'Pjerwjejšny',
	'cb_next_items_link' => 'Pśiducy',
	'cb_next_items_stats' => '(wót $1)',
	'cb_cat_subcats' => 'pódkategorije',
	'cb_cat_pages' => 'boki',
	'cb_cat_files' => 'dataje',
	'cb_apply_button' => 'Nałožyś',
	'cb_all_op' => 'Wšykne',
	'cb_or_op' => 'abo',
	'cb_and_op' => 'a',
	'cb_edit_left_hint' => 'Nalěwo gibnuś, jolic móžno',
	'cb_edit_right_hint' => 'Napšawo gibnuś, jolic móžno',
	'cb_edit_remove_hint' => 'Wulašowaś, jolic móžno',
);

/** Greek (Ελληνικά)
 * @author Glavkos
 */
$messages['el'] = array(
	'cb_previous_items_link' => 'Προηγούμενο',
	'cb_next_items_link' => 'Επόμενο',
	'cb_next_items_stats' => '(από $1 )',
	'cb_cat_subcats' => 'υποκατηγορίες',
	'cb_cat_pages' => 'σελίδες',
	'cb_cat_files' => 'αρχεία',
	'cb_apply_button' => 'Εφαρμογή',
	'cb_all_op' => 'Ὀλα',
	'cb_or_op' => 'ή',
	'cb_and_op' => 'και',
	'cb_edit_left_hint' => 'Μετακινήστε προς τα αριστερά, αν είναι δυνατόν',
	'cb_edit_right_hint' => 'Μετακίνηση δεξιά, αν είναι δυνατόν',
	'cb_edit_remove_hint' => 'Διαγραφή, αν είναι δυνατόν',
	'cb_edit_clear_hint' => 'Διαγραφή τρέχουσας έκφρασης (επιλέξτε όλα)',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'categorybrowser' => 'Navigilo de kategorioj',
	'cb_requires_javascript' => 'La kromprogramo por la kategoria navigilo devigas JavaScript esti ŝalta en la retumilo.',
	'cb_show_no_parents_only' => 'Montri nur kategoriojn kiuj ne havas superajn kategoriojn',
	'cb_cat_name_filter' => 'Serĉi kategorion laŭ nomo:',
	'cb_cat_name_filter_clear' => 'Premi por nuligi filtrilon de kategoria nomo',
	'cb_cat_name_filter_ci' => 'Usklecoblinda',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subkategorio|subkategorioj}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|paĝo|paĝoj}}',
	'cb_has_files' => '$1 {{PLURAL:$1|dosiero|dosieroj}}',
	'cb_has_parentcategories' => 'Superaj kategorioj (se ili ekzistas)',
	'cb_previous_items_link' => 'Antaŭa',
	'cb_next_items_link' => 'Sekva',
	'cb_next_items_stats' => '(de $1)',
	'cb_cat_subcats' => 'subkategorioj',
	'cb_cat_pages' => 'paĝoj',
	'cb_cat_files' => 'dosieroj',
	'cb_apply_button' => 'Apliki',
	'cb_all_op' => 'Ĉiuj',
	'cb_or_op' => 'aŭ',
	'cb_and_op' => 'kaj',
	'cb_edit_left_hint' => 'Maldekstrenigi, se eblas',
	'cb_edit_right_hint' => 'Dekstrenigi, se eblas',
	'cb_edit_remove_hint' => 'Forigi, se eble',
	'cb_edit_copy_hint' => 'Kopii operacion al tondujon',
	'cb_edit_append_hint' => 'Enmeti operacion al lasta pozicio',
	'cb_edit_clear_hint' => 'Nuligi nunan espremon (elekti ĉion)',
	'cb_edit_paste_hint' => 'Gluigi operacion ĉe nuna pozicion, se eble',
	'cb_edit_paste_right_hint' => 'Gluigi operacion ĉe postan pozicion, se eble',
);

/** Spanish (Español)
 * @author Danke7
 * @author Translationista
 */
$messages['es'] = array(
	'categorybrowser' => 'Navegador de categoría',
	'categorybrowser-desc' => 'Proporciona una [[Special:CategoryBrowser|página especial]] para filtrar las categorías con más entradas y navegarlas con una interfaz AJAX',
	'cb_requires_javascript' => 'La extensión del navegador de categorías requiere que Javascript esté habilitado en el navegador.',
	'cb_ie6_warning' => 'El editor de condición no funciona en Internet Explorer 6.0 o versiones anteriores. 
Sin embargo, la exploración de las condiciones predefinidas debería funcionar normalmente. 
Por favor, cambia o actualiza el navegador, de ser posible.',
	'cb_show_no_parents_only' => ' Mostrar sólo las categorías que no tienen categorías superiores',
	'cb_cat_name_filter' => ' Buscar la categoría por el nombre:',
	'cb_cat_name_filter_clear' => 'Haz clic aquí para limpiar el filtro del nombre de categoría',
	'cb_cat_name_filter_ci' => 'no distingue mayúsculas de minúsculas',
	'cb_copy_line_hint' => 'Use los botones [+] y [>+] para copiar y pegar operadores en la expresión seleccionada',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategoría|subcategorías}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'cb_has_files' => '$1 {{PLURAL:$1|archivo|archivos}}',
	'cb_has_parentcategories' => 'categorías superiores (si las hubiese)',
	'cb_previous_items_link' => 'Anterior',
	'cb_next_items_link' => 'Siguiente',
	'cb_next_items_stats' => '(de $1)',
	'cb_cat_subcats' => 'subcategorías',
	'cb_cat_pages' => 'páginas',
	'cb_cat_files' => 'archivos',
	'cb_apply_button' => 'Aplicar',
	'cb_all_op' => 'Todos',
	'cb_or_op' => 'o',
	'cb_and_op' => 'y',
	'cb_edit_left_hint' => 'Mover a la izquierda, si es posible',
	'cb_edit_right_hint' => 'Mover a la derecha, si es posible',
	'cb_edit_remove_hint' => 'Borrar, si es posible',
	'cb_edit_copy_hint' => 'Copiar el operador al portapapeles',
	'cb_edit_append_hint' => 'Insertar el operador en la última posición',
	'cb_edit_clear_hint' => 'Limpiar la expresión actual (seleccionar todo)',
	'cb_edit_paste_hint' => 'Pegar el operador en la posición actual, de ser posible',
	'cb_edit_paste_right_hint' => 'Pegar el operador en la posición siguiente, de ser posible',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Mjbmr
 */
$messages['fa'] = array(
	'cb_show_no_parents_only' => 'فقط نمایش رده‌هایی که دارای والد نیستند',
	'cb_previous_items_link' => 'قبلی',
	'cb_next_items_link' => 'بعدی',
	'cb_cat_subcats' => 'زیررده‌ها',
	'cb_cat_files' => 'پرونده‌ها',
	'cb_all_op' => 'همه',
	'cb_or_op' => 'یا',
	'cb_and_op' => 'و',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Nike
 */
$messages['fi'] = array(
	'categorybrowser' => 'Luokkaselain',
	'categorybrowser-desc' => 'Tarjoaa [[Special:CategoryBrowser|toimintosivun]] suodattamaan pois suosituimmat luokat ja navigoimaan niillä AJAX-rajapintaa käyttäen.',
	'cb_requires_javascript' => 'Luokkaselainlaajennus edellyttää, että JavaScript on käytössä selaimessa.',
	'cb_ie6_warning' => 'Ehtomuokkain ei toimi Internet Explorer 6.0 -selaimessa tai sitä varhaisemmissa selaimissa. 
Esimääriteltyjen ehtojen selailun pitäisi kuitenkin toimia normaalisti.
Vaihda tai päivitä selaintasi, jos mahdollista.',
	'cb_show_no_parents_only' => 'Näytä vain luokkia, joilla ei ole pääluokkia',
	'cb_cat_name_filter' => 'Etsi luokkaa nimen avulla:',
	'cb_cat_name_filter_clear' => 'Nollaa luokkanimisuodattimen napsauttamalla',
	'cb_cat_name_filter_ci' => 'Kirjainkoosta riippuva',
	'cb_copy_line_hint' => 'Käytä painikkeita [+] ja [>+] kopioidaksesi ja liittääksesi operaattoreita valittuun lausekkeeseen',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|alaluokka|alaluokkaa}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|sivu|sivua}}',
	'cb_has_files' => '$1 {{PLURAL:$1|tiedosto|tiedostoa}}',
	'cb_has_parentcategories' => 'yläluokat (vain tarvittaessa)',
	'cb_previous_items_link' => 'Edellinen',
	'cb_next_items_link' => 'Seuraava',
	'cb_next_items_stats' => ' (kohteesta $1)',
	'cb_cat_subcats' => 'alaluokat',
	'cb_cat_pages' => 'sivut',
	'cb_cat_files' => 'tiedostot',
	'cb_apply_button' => 'Käytä',
	'cb_all_op' => 'Kaikki',
	'cb_or_op' => 'tai',
	'cb_and_op' => 'ja',
	'cb_edit_left_hint' => 'Siirrä vasemmalle, jos mahdollista',
	'cb_edit_right_hint' => 'Siirrä oikealle, jos mahdollista',
	'cb_edit_remove_hint' => 'Poista, jos mahdollista',
	'cb_edit_copy_hint' => 'Kopioi operaattori leikepöydälle',
	'cb_edit_append_hint' => 'Lisää operaattori viimeiselle paikalle',
	'cb_edit_clear_hint' => 'Tyhjennä nykyinen lauseke (valitse kaikki)',
	'cb_edit_paste_hint' => 'Liitä operaattori nykyiseen sijaintiin, jos mahdollista',
	'cb_edit_paste_right_hint' => 'Liitä operaattori seuraavaan sijaintiin, jos mahdollista',
);

/** French (Français)
 * @author Grondin
 * @author Sherbrooke
 * @author The Evil IP address
 */
$messages['fr'] = array(
	'categorybrowser' => 'Navigateur de catégories',
	'categorybrowser-desc' => 'Offre une [[Special:CategoryBrowser|page spéciale]] pour filtrer la plupart des catégories et y naviguer en utilisant une interface Ajax',
	'cb_requires_javascript' => 'Le navigateur de catégories exige que JavaScript soit autorisé par le navigateur web.',
	'cb_ie6_warning' => "L'éditeur conditionnel ne fonctionne pas dans Internet Explorer 6.0 ou versions antérieures. Toutefois, la navigation des conditions pré-défini devrait fonctionner normalement. S'il vous plaît, changer ou mettre à jour votre navigateur.",
	'cb_show_no_parents_only' => 'Afficher uniquement les catégories sans catégorie-mère',
	'cb_cat_name_filter' => 'Recherche de catégories par le nom :',
	'cb_cat_name_filter_clear' => 'Appuyer pour effacer le filtre de nom de catégorie',
	'cb_cat_name_filter_ci' => 'Casse insensible',
	'cb_copy_line_hint' => "Utilisez les boutons [+] et [>+] pour copier et coller les opérateurs dans l'expression choisie",
	'cb_has_subcategories' => '$1 {{PLURAL:$1|sous-catégorie|sous-catégories}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|page|pages}}',
	'cb_has_files' => '$1 {{PLURAL:$1|fichier|fichiers}}',
	'cb_has_parentcategories' => 'Catégorie mère (si elle existe)',
	'cb_previous_items_link' => 'Précédent',
	'cb_next_items_link' => 'Suivant',
	'cb_next_items_stats' => '(à partir de $1)',
	'cb_cat_subcats' => 'sous-catégories',
	'cb_cat_pages' => 'pages',
	'cb_cat_files' => 'fichiers',
	'cb_apply_button' => 'Appliquer',
	'cb_all_op' => 'Toutes',
	'cb_or_op' => 'ou',
	'cb_and_op' => 'et',
	'cb_edit_left_hint' => 'Déplacer à gauche, si possible',
	'cb_edit_right_hint' => 'Déplacer à droite, si possible',
	'cb_edit_remove_hint' => 'Supprimer, si possible',
	'cb_edit_copy_hint' => "Copier l'opérateur vers le presse-papier",
	'cb_edit_append_hint' => "Insérer l'opérateur en dernière position",
	'cb_edit_clear_hint' => 'Effacer la présente expression (tout sélectionner)',
	'cb_edit_paste_hint' => "Coller, si possible, l'opérateur à cet endroit",
	'cb_edit_paste_right_hint' => "Coller, si possible, l'opérateur à la position suivante",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'categorybrowser' => 'Navigator de catègories',
	'cb_show_no_parents_only' => 'Fâre vêre ren que les catègories sen catègorie mâre',
	'cb_cat_name_filter' => 'Rechèrche de catègories per lo nom :',
	'cb_cat_name_filter_clear' => 'Apoyér por èfaciér lo filtro de nom de catègorie',
	'cb_cat_name_filter_ci' => 'Pas sensiblo a la câssa',
	'cb_copy_line_hint' => 'Utilisâd los botons [+] et [>+] por copiyér et côlar los opèrators dens l’èxprèssion chouèsia',
	'cb_has_subcategories' => '$1 sot-catègorie{{PLURAL:$1||s}}',
	'cb_has_pages' => '$1 pâge{{PLURAL:$1||s}}',
	'cb_has_files' => '$1 fichiér{{PLURAL:$1||s}}',
	'cb_has_parentcategories' => 'catègorie mâre (s’ègziste)',
	'cb_previous_items_link' => 'Devant',
	'cb_next_items_link' => 'Aprés',
	'cb_next_items_stats' => '(dês $1)',
	'cb_cat_subcats' => 'sot-catègories',
	'cb_cat_pages' => 'pâges',
	'cb_cat_files' => 'fichiérs',
	'cb_apply_button' => 'Aplicar',
	'cb_all_op' => 'Totes',
	'cb_or_op' => 'ou ben',
	'cb_and_op' => 'et',
	'cb_edit_left_hint' => 'Dèplaciér a gôche, se possiblo',
	'cb_edit_right_hint' => 'Dèplaciér a drêta, se possiblo',
	'cb_edit_remove_hint' => 'Suprimar, se possiblo',
	'cb_edit_copy_hint' => 'Copiyér l’opèrator vers lo prèssa-papiérs',
	'cb_edit_append_hint' => 'Entrebetar l’opèrator en dèrriére posicion',
	'cb_edit_clear_hint' => 'Èfaciér la presenta èxprèssion (chouèsir tot)',
	'cb_edit_paste_hint' => 'Côlar, se possiblo, l’opèrator a cela posicion',
	'cb_edit_paste_right_hint' => 'Côlar, se possiblo, l’opèrator a ceta posicion',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'categorybrowser' => 'Navegador de categorías',
	'categorybrowser-desc' => 'Proporciona unha [[Special:CategoryBrowser|páxina especial]] para filtrar as categorías máis populares e navegar por elas a través dunha interface AJAX',
	'cb_requires_javascript' => 'A extensión do navegador de categorías necesita que o navegador teña o JavaScript activado.',
	'cb_ie6_warning' => 'O editor de condicións non funciona no Internet Explorer 6.0 ou calquera versión anterior.
Porén, a navegación polas condicións predefinidas debería funcionar correctamente.
Cambie ou actualice o seu navegador, se fose posible.',
	'cb_show_no_parents_only' => 'Mostrar unicamente as categorías que non colgan de ningunha outra',
	'cb_cat_name_filter' => 'Procurar por nome de categoría:',
	'cb_cat_name_filter_clear' => 'Prema para limpar o filtro de nome de categoría',
	'cb_cat_name_filter_ci' => 'Sen distinción entre maiúsculas e minúsculas',
	'cb_copy_line_hint' => 'Empregue os botóns [+] e [>+] para copiar e pegar os operadores na expresión seleccionada',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategoría|subcategorías}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|páxina|páxinas}}',
	'cb_has_files' => '$1 {{PLURAL:$1|ficheiro|ficheiros}}',
	'cb_has_parentcategories' => 'categorías das que colga (se houbese algunha)',
	'cb_previous_items_link' => 'Anterior',
	'cb_next_items_link' => 'Seguinte',
	'cb_next_items_stats' => ' (de $1)',
	'cb_cat_subcats' => 'subcategorías',
	'cb_cat_pages' => 'páxinas',
	'cb_cat_files' => 'ficheiros',
	'cb_apply_button' => 'Aplicar',
	'cb_all_op' => 'Todas',
	'cb_or_op' => 'ou',
	'cb_and_op' => 'e',
	'cb_edit_left_hint' => 'Mover á esquerda, se fose posible',
	'cb_edit_right_hint' => 'Mover á dereita, se fose posible',
	'cb_edit_remove_hint' => 'Borrar, se fose posible',
	'cb_edit_copy_hint' => 'Copiar o operador na memoria',
	'cb_edit_append_hint' => 'Inserir o operador na última posición',
	'cb_edit_clear_hint' => 'Limpar a expresión actual (selecciona todas)',
	'cb_edit_paste_hint' => 'Pegar o operador na posición actual, se fose posible',
	'cb_edit_paste_right_hint' => 'Pegar o operador na seguinte posición, se fose posible',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'categorybrowser' => 'Kategoriebrowser',
	'categorybrowser-desc' => 'Ergänzt e [[Special:CategoryBrowser|Spezialsyte]], wu di umfangryychschte Kategorie chenne uusgwehlt wäre un zum Navigiere in emne iber e Aax-Interface',
	'cb_requires_javascript' => 'Go dr Kategoriebrowser nutze mueß JavaScript im Browser aktiviert syy.',
	'cb_ie6_warning' => 'Dr Editor fir Bedingige funktioniert nit bim Internet Explorer 6.0 oder ere friejere Version.
S Browse mit vordefinierte Bedingige sott aber normalerwyys funktioniere.
Wänn megli, tue Dyy Browser aktualisiere oder wächsle.',
	'cb_show_no_parents_only' => 'Nume Kategorie ohni ibergordneti Kategori aazeige',
	'cb_cat_name_filter' => 'E Kategori noch em Name sueche:',
	'cb_cat_name_filter_clear' => 'Zum Zrucksetze vum Filter no Kategoriname do klicke',
	'cb_cat_name_filter_ci' => 'Uuabhängig vu dr Groß-/Chleischryybig',
	'cb_copy_line_hint' => 'Zum Kopiere un Yyfiege vu Operatore in di uusgwehlte Uusdruck, d Schaltfleche [+] un [>+] bruche',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|Unterkategori|Unterkategorie}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|Syte|Syte}}',
	'cb_has_files' => '$1 {{PLURAL:$1|Datei|Dateie}}',
	'cb_has_parentcategories' => 'ibergordnete Kategorie (wänn s het)',
	'cb_previous_items_link' => 'Vorigi',
	'cb_next_items_link' => 'Negschti',
	'cb_next_items_stats' => ' (ab $1)',
	'cb_cat_subcats' => 'Unterkategorie',
	'cb_cat_pages' => 'Syte',
	'cb_cat_files' => 'Dateie',
	'cb_apply_button' => 'Aawände',
	'cb_all_op' => 'Alli',
	'cb_or_op' => 'oder',
	'cb_and_op' => 'un',
	'cb_edit_left_hint' => 'No links bewege (wänn megli)',
	'cb_edit_right_hint' => 'No rächts bewege (wänn megli)',
	'cb_edit_remove_hint' => 'Lesche (wänn megli)',
	'cb_edit_copy_hint' => 'Operator in d Zwischenablag kopiere',
	'cb_edit_append_hint' => 'Operator an dr letschte Position yyfiege',
	'cb_edit_clear_hint' => 'Aktuälli Uusdruck uuseneh (alli uuswehle)',
	'cb_edit_paste_hint' => 'Operator an dr aktuälle Position yyfiege (wänn megli)',
	'cb_edit_paste_right_hint' => 'Operator an dr negschte Position yyfiege (wänn megli)',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'categorybrowser' => 'סייר הקטגוריות',
	'categorybrowser-desc' => 'יצירת [[Special:CategoryBrowser|דף מיוחד]] לסינון הקטגוריות הפופולריות ביותר ולניווט בהן באמצעות ממשק AJAX',
	'cb_requires_javascript' => 'כדי שהרחבת הדפדפן לקטגוריות תעבוד, התמיכה ב־JavaScript צריכה להיות מופעלת.',
	'cb_ie6_warning' => 'עורך התנים אינו עובר ב־Microsoft Internet Explorer 6.0 ובגרסאות ישנות יותר.
עיון בתנאים מוגדרים מראש אמור לעבוד טוב.
במית האפשר, החליפו או עדכנו את הדפדפן שלכם.',
	'cb_show_no_parents_only' => 'להציג רק קטגוריות ללא הורים',
	'cb_cat_name_filter' => 'חיפוש קטגוריה לפי שם:',
	'cb_cat_name_filter_clear' => 'ניקוי מסנן שמות הקטגוריות',
	'cb_cat_name_filter_ci' => 'ללא תלות ברישיות',
	'cb_copy_line_hint' => 'השתמשו בכפתורים [+] ו־[>+] להעתקה והדבקה של אופרטורים לביטוי הנבחר',
	'cb_has_subcategories' => '{{PLURAL:$1|תת־קטגוריה אחת|$1 תת־קטגוריות}}',
	'cb_has_pages' => '{{PLURAL:$1|דף אחד|$1 דפים}}',
	'cb_has_files' => '{{PLURAL:$1|קובץ אחד|$1 קבצים}}',
	'cb_has_parentcategories' => 'קטגוריות אב (אם ישנן)',
	'cb_previous_items_link' => 'הקודם',
	'cb_next_items_link' => 'הבא',
	'cb_next_items_stats' => '(מתוך $1)',
	'cb_cat_subcats' => 'תת־קטגוריות',
	'cb_cat_pages' => 'דפים',
	'cb_cat_files' => 'קבצים',
	'cb_apply_button' => 'החלה',
	'cb_all_op' => 'הכול',
	'cb_or_op' => 'או',
	'cb_and_op' => 'וגם',
	'cb_edit_left_hint' => 'הזזה שמאלה, אם ניתן',
	'cb_edit_right_hint' => 'הזזה ימינה, אם ניתן',
	'cb_edit_remove_hint' => 'מחיקה, אם ניתן',
	'cb_edit_copy_hint' => 'העתקת האופרטור ללוח גזירה',
	'cb_edit_append_hint' => 'להכניס את האופרטור למיקום האחרון',
	'cb_edit_clear_hint' => 'לנקות את הביטוי הנוכחי (לבחור הכול)',
	'cb_edit_paste_hint' => 'להדביק את האופרטור למיקום הנוכחי, אם אפשר',
	'cb_edit_paste_right_hint' => 'להדביק את האופרטור למיקום הבא, אם אפשר',
);

/** Hindi (हिन्दी)
 * @author Siddhartha Ghai
 */
$messages['hi'] = array(
	'cb_cat_name_filter' => 'श्रेणी को नाम से खोजें:',
	'cb_previous_items_link' => 'पिछला',
	'cb_next_items_link' => 'अगला',
	'cb_cat_subcats' => 'उपश्रेणियाँ',
	'cb_cat_pages' => 'पन्ने',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'categorybrowser' => 'Wobhladowak kategorijow',
	'categorybrowser-desc' => 'Steji [[Special:CategoryBrowser|specialnu stronu]] k dispoziciji, zo bychu so najbóle woblubowane kategorije wufiltrowali a zo by z pomocu AJAX-powjercha nawigowało',
	'cb_requires_javascript' => 'Kategorijowy wobhladowak trjeba JavaScript, zo by we wobhladowaku fungował.',
	'cb_ie6_warning' => 'Editor za wuměnjenja w Internet Explorer 6.0 abo staršich wersijach njefunguje.
Ale, přehladowanje z předdefinowanymi wuměnjenjemi měło normalnje fungować.
Prošu změń abo zaktualizuj swój wobhladowak, jeli móžno.',
	'cb_show_no_parents_only' => 'Jenož kategorije pokazać, kotrež nadrjadowane kategorije nimaja.',
	'cb_cat_name_filter' => 'Kategoriju po mjenje pytać',
	'cb_cat_name_filter_clear' => 'Kliknyć, zo by so filter po kategorijowym mjenje wotstronił',
	'cb_cat_name_filter_ci' => 'Njedźiwajo na wulkopisanje',
	'cb_copy_line_hint' => 'Za kopěrowanje a zasunjenje operatorow do wubraneho wuraza tłóčatce [+] a [>+] wužiwać',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|kategorija|kategoriji|kategorije|kategorijow}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|strona|stronje|strony|stronow}}',
	'cb_has_files' => '$1 {{PLURAL:$1|dataja|dataji|dataje|datajow}}',
	'cb_has_parentcategories' => 'nadrjadowane kategorije (jeli tajke su)',
	'cb_previous_items_link' => 'Předchadna',
	'cb_next_items_link' => 'Přichodna',
	'cb_next_items_stats' => '(z $1)',
	'cb_cat_subcats' => 'podkategorije',
	'cb_cat_pages' => 'strony',
	'cb_cat_files' => 'dataje',
	'cb_apply_button' => 'Nałožić',
	'cb_all_op' => 'Wšě',
	'cb_or_op' => 'abo',
	'cb_and_op' => 'a',
	'cb_edit_left_hint' => 'Dolěwa přesunyć, jeli móžno',
	'cb_edit_right_hint' => 'Doprawa přesunyć, jeli móžno',
	'cb_edit_remove_hint' => 'Wušmórnyć, jeli móžno',
	'cb_edit_copy_hint' => 'Operator do mjezyskłada kopěrować',
	'cb_edit_append_hint' => 'Operator na poslednjej poziciji zasunyć',
	'cb_edit_clear_hint' => 'Aktualny wuraz wotstronić (wšě wubrać)',
	'cb_edit_paste_hint' => 'Operator na aktualnej poziciji zasunyć, jeli móžno',
	'cb_edit_paste_right_hint' => 'Operator na přichodnej poziciji zasunyć, jeli móžno',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'categorybrowser' => 'Kategóriaböngésző',
	'cb_cat_name_filter_ci' => 'Ne különböztesse meg a kis- és nagybetűket',
	'cb_has_subcategories' => '{{PLURAL:$1|egy|$1}} alkategória',
	'cb_has_pages' => '{{PLURAL:$1|egy|$1}} lap',
	'cb_has_files' => '{{PLURAL:$1|egy|$1}} fájl',
	'cb_has_parentcategories' => 'szülőkategóriák (ha vannak)',
	'cb_previous_items_link' => 'Előző',
	'cb_next_items_link' => 'Következő',
	'cb_cat_subcats' => 'alkategóriák',
	'cb_cat_pages' => 'lapok',
	'cb_cat_files' => 'fájlok',
	'cb_apply_button' => 'Alkalmazás',
	'cb_all_op' => 'Összes',
	'cb_or_op' => 'vagy',
	'cb_and_op' => 'és',
	'cb_edit_left_hint' => 'Mozgás balra, ha lehetséges',
	'cb_edit_right_hint' => 'Mozgás jobbra, ha lehetséges',
	'cb_edit_remove_hint' => 'Törlés, ha lehetséges',
	'cb_edit_copy_hint' => 'Operátor másolása a vágólapra',
	'cb_edit_append_hint' => 'Operátor beillesztése a legutolsó helyre',
	'cb_edit_clear_hint' => 'Kifejezés törlése (összes kijelölése)',
	'cb_edit_paste_hint' => 'Operátor beillesztése a jelenlegi helyre, ha lehetséges',
	'cb_edit_paste_right_hint' => 'Operátor beillesztése a következő helyre, ha lehetséges',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'categorybrowser' => 'Navigator de categorias',
	'categorybrowser-desc' => 'Provide un [[Special:CategoryBrowser|pagina special]] pro filtrar le categorias le plus popular e pro navigar per illos usante un interfacie AJAX',
	'cb_requires_javascript' => 'Le extension de navigator de categorias require JavaScript pro esser activate in le navigator del web.',
	'cb_ie6_warning' => 'Le editor de conditiones non functiona in Internet Explorer 6.0 o versiones anterior.
Nonobstante, le navigation de categorias predefinite debe functionar normalmente.
Per favor cambia o actualisa le navigator del web, si possibile.',
	'cb_show_no_parents_only' => 'Monstrar solmente categorias sin categoria superior',
	'cb_cat_name_filter' => 'Cerca un categoria per nomine:',
	'cb_cat_name_filter_clear' => 'Preme pro rader le filtro de nomine de categoria',
	'cb_cat_name_filter_ci' => 'Non distingue inter majusculas e minusculas',
	'cb_copy_line_hint' => 'Usa le buttones [+] and [>+] pro copiar e collar operatores in le expression seligite',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategoria|subcategorias}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|pagina|paginas}}',
	'cb_has_files' => '$1 {{PLURAL:$1|file|files}}',
	'cb_has_parentcategories' => 'categorias superior (si existe)',
	'cb_previous_items_link' => 'Precedente',
	'cb_next_items_link' => 'Sequente',
	'cb_next_items_stats' => ' (ab $1)',
	'cb_cat_subcats' => 'subcategorias',
	'cb_cat_pages' => 'paginas',
	'cb_cat_files' => 'files',
	'cb_apply_button' => 'Applicar',
	'cb_all_op' => 'Totes',
	'cb_or_op' => 'o',
	'cb_and_op' => 'e',
	'cb_edit_left_hint' => 'Displaciar a sinistra, si possibile',
	'cb_edit_right_hint' => 'Displaciar a dextra, si possibile',
	'cb_edit_remove_hint' => 'Deler, si possibile',
	'cb_edit_copy_hint' => 'Copiar le operator al area de transferentia',
	'cb_edit_append_hint' => 'Inserer le operator al ultime position',
	'cb_edit_clear_hint' => 'Rader le actual expression (seliger toto)',
	'cb_edit_paste_hint' => 'Collar le operator in le actual position, si possibile',
	'cb_edit_paste_right_hint' => 'Collar le operator in le sequente position, si possibile',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'categorybrowser' => 'Penelusur kategori',
	'categorybrowser-desc' => 'Menyediakan [[Special:CategoryBrowser|halaman istimewa]] untuk menyaring kategori terpadat dan menelusurinya dengan menggunakan antarmuka AJAX',
	'cb_requires_javascript' => 'Ekstensi penelusur kategori memerlukan pengaktifan JavaScript peramban.',
	'cb_ie6_warning' => 'Editor kondisi tidak bekerja di Internet Explorer 6.0 atau versi sebelumnya. 
Namun, penelusuran kondisi yang telah ditentukan seharusnya bekerja normal. 
Jika memungkinkan, silakan ganti atau mutakhirkan peramban Anda.',
	'cb_show_no_parents_only' => 'Tampilkan hanya kategori yang tidak memiliki induk',
	'cb_cat_name_filter' => 'Cari kategori dengan nama:',
	'cb_cat_name_filter_clear' => 'Tekan untuk menghapus filter nama kategori',
	'cb_cat_name_filter_ci' => 'Tidak peka kapitalisasi',
	'cb_copy_line_hint' => 'Gunakan tombol [+] dan [>+] untuk menyalin dan merekatkan operator ke ekspresi yang dipilih',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subkategori|subkategori}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|halaman|halaman}}',
	'cb_has_files' => '$1 {{PLURAL:$1|berkas|berkas}}',
	'cb_has_parentcategories' => 'kategori induk (jika ada)',
	'cb_previous_items_link' => 'Sebelumnya',
	'cb_next_items_link' => 'Selanjutnya',
	'cb_next_items_stats' => '(dari $1)',
	'cb_cat_subcats' => 'subkategori',
	'cb_cat_pages' => 'halaman',
	'cb_cat_files' => 'berkas',
	'cb_apply_button' => 'Terapkan',
	'cb_all_op' => 'Semua',
	'cb_or_op' => 'atau',
	'cb_and_op' => 'dan',
	'cb_edit_left_hint' => 'Pindah ke kiri, jika mungkin',
	'cb_edit_right_hint' => 'Pindah ke kanan, jika mungkin',
	'cb_edit_remove_hint' => 'Hapus, jika mungkin',
	'cb_edit_copy_hint' => 'Salin operator ke papan tempel',
	'cb_edit_append_hint' => 'Sisipkan operator ke posisi terakhir',
	'cb_edit_clear_hint' => 'Kosongkan ekspresi yang ada (pilih semua)',
	'cb_edit_paste_hint' => 'Rekatkan operator ke posisi saat ini, jika mungkin',
	'cb_edit_paste_right_hint' => 'Rekatkan operator ke posisi selanjutnya, jika mungkin',
);

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'cb_has_subcategories' => '$1 {{PLURAL:$1|sottocategoria|sottocategorie}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|pagina|pagine}}',
	'cb_cat_subcats' => 'sottocategorie',
	'cb_cat_pages' => 'pagine',
	'cb_apply_button' => 'Applica',
	'cb_or_op' => 'o',
	'cb_and_op' => 'e',
	'cb_edit_remove_hint' => 'Cancella, se possibile',
);

/** Japanese (日本語)
 * @author Tommy6
 * @author Yanajin66
 * @author 青子守歌
 */
$messages['ja'] = array(
	'categorybrowser' => 'カテゴリーブラウザ',
	'categorybrowser-desc' => '最もページなどが格納されたカテゴリをフィルターにかけ、それらをAJAXを使ったインターフェースで案内する[[Special:CategoryBrowser|特別ページ]]を提供する',
	'cb_requires_javascript' => 'カテゴリブラウザを利用するにはブラウザのJavaScriptを有効にする必要があります。',
	'cb_ie6_warning' => '条件エディタはInternet Explorer 6.0以前のバージョンでは稼働しません。
ただし、事前に定義された条件のブラウジングは正常に稼働するでしょう。 
もし、可能であればブラウザを変更するか、アップデートしてください。',
	'cb_show_no_parents_only' => '親のないカテゴリのみを表示する',
	'cb_cat_name_filter' => '名前によるカテゴリの検索:',
	'cb_cat_name_filter_clear' => 'カテゴリ名フィルターをクリアするために押す',
	'cb_cat_name_filter_ci' => '大文字、小文字を区別しない場合',
	'cb_copy_line_hint' => '選択された式に演算子をコピーまたはペーストする場合は、[+] と[>+]ボタンを使用する',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|サブカテゴリ|総サブカテゴリ数}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|ページ|総ページ数}}',
	'cb_has_files' => '$1 {{PLURAL:$1|ファイル|総ファイル数}}',
	'cb_has_parentcategories' => '親元のカテゴリー(いかなる場合においても)',
	'cb_previous_items_link' => '前',
	'cb_next_items_link' => '次',
	'cb_next_items_stats' => '（$1から）',
	'cb_cat_subcats' => 'サブカテゴリ',
	'cb_cat_pages' => 'ページ',
	'cb_cat_files' => 'ファイル',
	'cb_apply_button' => '適用',
	'cb_all_op' => 'すべて',
	'cb_or_op' => 'または',
	'cb_and_op' => 'および',
	'cb_edit_left_hint' => '可能であれば、左に移動',
	'cb_edit_right_hint' => '可能であれば、右に移動',
	'cb_edit_remove_hint' => '可能であれば、削除する',
	'cb_edit_copy_hint' => 'クリップボードに演算子をコピーする',
	'cb_edit_append_hint' => '最後の位置に演算子を挿入する',
	'cb_edit_clear_hint' => '現在の式をクリアする（選択したすべての）',
	'cb_edit_paste_hint' => '可能であれば、現在の位置に演算子を貼付ける',
	'cb_edit_paste_right_hint' => '可能であれば、次の位置に演算子を貼付ける',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'cb_show_no_parents_only' => 'បង្ហាញតែចំណាត់ថ្នាក់ក្រុមណាដែលគ្មានមេ',
	'cb_cat_name_filter' => 'ស្វែងរកចំណាត់ថ្នាក់ក្រុមដោយប្រើឈ្មោះ',
	'cb_has_subcategories' => '$1 ចំណាត់ថ្នាក់ក្រុមរង',
	'cb_has_pages' => '$1 ទំព័រ',
	'cb_has_files' => '$1 ឯកសារ',
	'cb_has_parentcategories' => 'ចំណាត់ថ្នាក់ក្រុមមេ (បើមាន)',
	'cb_next_items_stats' => ' (ពី $1)',
	'cb_cat_subcats' => 'ចំណាត់ថ្នាក់រង',
	'cb_cat_pages' => 'ទំព័រ',
	'cb_cat_files' => 'ឯកសារ',
	'cb_apply_button' => 'អនុវត្ត',
	'cb_all_op' => 'ទាំងអស់',
	'cb_or_op' => 'ឬ',
	'cb_and_op' => 'និង',
	'cb_edit_left_hint' => 'រំកិលទៅឆ្វេង បើអាច',
	'cb_edit_right_hint' => 'រំកិលទៅស្ដាំ បើអាច',
	'cb_edit_remove_hint' => 'លុបចោល បើអាច',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'cb_all_op' => 'ಎಲ್ಲಾ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'categorybrowser' => 'En Saachjroppe bläddere',
	'categorybrowser-desc' => 'Deiht en [[Special:CategoryBrowser|Extrasigg]] en et Wiki, öm de vollste Saachjroppe ze fenge un en dänne övver en AJAX-Schnettställ ze bläddere.',
	'cb_requires_javascript' => 'Öm et Saachjroppe-Bläddere bruche ze künne, moß em Brauser JavaSkrepp zohjelohße sin.',
	'cb_ie6_warning' => 'Dat Enjävve vun Bedengunge deiht et nit met dä Version 6.0 vum Internet Explorer udder ällder Versione.
Ävver Met Bedengunge ärbeide, di ald doh sin, sullt janz nomaal fluppe.
Nemm ene neuere Brauser, wann De kanns.',
	'cb_show_no_parents_only' => 'Bloß de Saachjroppe zeije, di sellver en kein Saachjroppe dren sin',
	'cb_cat_name_filter' => 'Söhk en Saachjropp ovver dä iehre Name:',
	'cb_cat_name_filter_clear' => 'Deiht dä Name vun dä Saachjropp zom donoh söhke leddish maache',
	'cb_cat_name_filter_ci' => 'Jruß- un Kleinboochshtaabe sin ejaal',
	'cb_copy_line_hint' => 'Nemm de [+] un [>+] Knöpp, öm di Rääschezeijshe en dä usjewählte Ußdrock ze donn',
	'cb_has_subcategories' => '{{PLURAL:$1|Ein Ongerjropp|$1 Ongerjroppe|Kei Ongerjropp}}',
	'cb_has_pages' => '{{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigge}}',
	'cb_has_files' => '{{PLURAL:$1|Ein Datei|$1 Dateie|Kein Datteije}}',
	'cb_has_parentcategories' => 'de övverjeoodente Saachjroppe (wann et welshe jitt)',
	'cb_previous_items_link' => 'Vörijje',
	'cb_next_items_link' => 'Nächs',
	'cb_next_items_stats' => '(vun $1 aff)',
	'cb_cat_subcats' => 'Ungerjruppe',
	'cb_cat_pages' => 'Sigge',
	'cb_cat_files' => 'Dateie',
	'cb_apply_button' => 'Aanwände',
	'cb_all_op' => 'All',
	'cb_or_op' => 'udder',
	'cb_and_op' => 'un',
	'cb_edit_left_hint' => 'Noh lengks donn, wann müjjelesch',
	'cb_edit_right_hint' => 'Noh räähß donn, wann müjjelesch',
	'cb_edit_remove_hint' => 'Fott nämme, wann müjjelesch',
	'cb_edit_copy_hint' => 'Dat Rääschezeijshe merke',
	'cb_edit_append_hint' => 'Dat Rääschezeijshe aan et Engk aanhänge',
	'cb_edit_clear_hint' => 'Donn dä äktoälle Ußdrock fott nämme (alles ußwähle)',
	'cb_edit_paste_hint' => 'Dat Rääschezeijshe aan de aktoälle Pussizjuhn endraare, wann müjjelesch',
	'cb_edit_paste_right_hint' => 'Dat Rääschezeijshe aan de näächste Pussizjuhn endraare, wann müjjelesch',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'cb_next_items_stats' => '  (ji $1)',
	'cb_cat_pages' => 'rûpelan',
	'cb_all_op' => 'Hemû',
	'cb_and_op' => 'û',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'categorybrowser' => 'Kategoriebrowser',
	'categorybrowser-desc' => 'Mécht eng [[Special:CategoryBrowser|Spezialsäit]] fir déi Kategorie mat de meeschten Elementer erauszefilteren a mat engem AJAX-Interface driwwer ze navigéieren',
	'cb_requires_javascript' => "D'Erweiderung Kategriebrowser brauch ageschalte Javascript am Browser.",
	'cb_ie6_warning' => "Dësen Editeur fir Bedingung fonctionnéiert net mam Internet Explorer 6.0 oder méi ale Versiounen.
D'Browse mat virdefinierte Bedingunge misst awer normal fonctionnéieren.
Wiesselt Äre Borwseroder maacht en Update, wa méiglech.",
	'cb_show_no_parents_only' => 'Nëmme Kategorie weisen déi keng Kategorie driwwer hunn',
	'cb_cat_name_filter' => 'Sich no enger Kategorie nom Numm:',
	'cb_cat_name_filter_clear' => 'Dréckt fir de Filter vum Kategoriennumm eidelzemaachen',
	'cb_cat_name_filter_ci' => 'Ënnerscheed tëschent groussen a klenge Buschtawen',
	'cb_copy_line_hint' => "Benotzt d'Knäppecher [+] an [>+] fir d'Operateuren an den erausgesichten Ausdrock dranzesetzen",
	'cb_has_subcategories' => '$1 {{PLURAL:$1|Ënnerkategorie|Ënnerkategorien}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|Säit|Säiten}}',
	'cb_has_files' => '$1 {{PLURAL:$1|Fichier|Fichieren}}',
	'cb_has_parentcategories' => 'iwwergeuerdent Kategorie (wann et eng gëtt)',
	'cb_previous_items_link' => 'Vireg',
	'cb_next_items_link' => 'Nächst',
	'cb_next_items_stats' => '(vu(n) $1)',
	'cb_cat_subcats' => 'Ënnerkategorien',
	'cb_cat_pages' => 'Säiten',
	'cb_cat_files' => 'Fichieren',
	'cb_apply_button' => 'Applizéieren',
	'cb_all_op' => 'All',
	'cb_or_op' => 'oder',
	'cb_and_op' => 'an',
	'cb_edit_left_hint' => 'No lénks réckelen, wa méiglech',
	'cb_edit_right_hint' => 'No riets réckelen, wa méiglech',
	'cb_edit_remove_hint' => 'Läschen, wa méiglech',
	'cb_edit_copy_hint' => 'Operateur an den Tëschespäicher kopéieren',
	'cb_edit_append_hint' => 'Operateur u leschter Positioun drasetzen',
	'cb_edit_clear_hint' => 'Aktuellen Ausdrock ewechhuelen (alles uwielen)',
	'cb_edit_paste_hint' => 'Operateur an déi aktuell Positioun drasetzen (wa méiglech)',
	'cb_edit_paste_right_hint' => 'Operateur an déi nächst Positioun drasetzen (wa méiglech)',
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'categorybrowser' => 'Categorieë doorblajere',
	'categorybrowser-desc' => "Maak 'n [[Special:CategoryBrowser|speciaal pagina]] besjikbaar om categorieë mit de meiste illemènte te selektere en ze te verkènne via 'n AJAX-interface",
	'cb_requires_javascript' => "De oetbreijing veur 't doorblajere van categorieë vereis dat JavaScript is ingesjakeld in de browser.",
	'cb_ie6_warning' => "De teksverwèrker veur condities wirk neet in Internet Explorer 6.0 of ierder versies.
Veuraaf gedefinieerde condities kinne evels wel normaal waere betrach.
Gebroek 'ne angere browser of wirk diene browser bie, es mäögelijk.",
	'cb_show_no_parents_only' => 'Allein categorieë weergaeve die gein boveliggende categorieë höbbe',
	'cb_cat_name_filter' => 'Zeuk nao categorieë op naam:',
	'cb_cat_name_filter_clear' => 'Klik um de categorienaamfilter laeg te make',
	'cb_cat_name_filter_ci' => 'Hooflètteróngeveulig',
	'cb_copy_line_hint' => 'Gebroek de knoppe [+] en [>+] um de operators in de geselekteerde expressies te kopiëre en plakke',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategorie|subcategorieë}}',
	'cb_has_pages' => "$1 {{PLURAL:$1|pagina|pagina's}}",
	'cb_has_files' => '$1 {{PLURAL:$1|besjtand|besjtande}}',
	'cb_has_parentcategories' => 'baovenlikgende categorieë (es die bestaon)',
	'cb_previous_items_link' => 'Veurige',
	'cb_next_items_link' => 'Volgende',
	'cb_next_items_stats' => '(van $1)',
	'cb_cat_subcats' => 'subcategorieë',
	'cb_cat_pages' => "pagina's",
	'cb_cat_files' => 'besjtande',
	'cb_apply_button' => 'Toepasse',
	'cb_all_op' => 'Alle',
	'cb_or_op' => 'of',
	'cb_and_op' => 'en',
	'cb_edit_left_hint' => 'Nao links verplaatse, es mäögelik',
	'cb_edit_right_hint' => 'Nao rechts verplaatse, es mäögelik',
	'cb_edit_remove_hint' => 'Ewegsjaffe, es mäögelik',
	'cb_edit_copy_hint' => 'Operator nao klembord kopiëre',
	'cb_edit_append_hint' => 'Operator nao lèste positie inveuge',
	'cb_edit_clear_hint' => 'Hujige expressie wisse (alles selektere)',
	'cb_edit_paste_hint' => 'Es mäögelik de operator op de hujige positie inveuge',
	'cb_edit_paste_right_hint' => 'Es mäögelik de operator op de volgende positie inveuge',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Ignas693
 */
$messages['lt'] = array(
	'categorybrowser' => 'Kategorijos naršyklės',
	'categorybrowser-desc' => 'Numato [[specialus: CategoryBrowser|special puslapis]] filtruoti iš labiausiai apgyvendintos kategorijų ir pereiti juos naudojant AJAX sąsaja',
	'cb_requires_javascript' => 'Kategorijos naršyklės plėtinys reikalauja JavaScript naršyklėje įgalinti.',
	'cb_ie6_warning' => 'Sąlyga redaktorius neveikia Internet Explorer 6.0 arba ankstesnėse versijose.
Tačiau naršymo iš anksto apibrėžtų sąlygų turėtų dirbti paprastai.
Prašome pakeisti arba atnaujinti savo naršyklę, jei įmanoma.',
	'cb_show_no_parents_only' => 'Rodyti tik kategorijos, kurios turi Nr tėvai',
	'cb_cat_name_filter' => 'Ieškoti pagal pavadinimą kategorijos:',
	'cb_cat_name_filter_clear' => 'Norėdami išvalyti kategorijos pavadinimas filtro, paspauskite',
	'cb_cat_name_filter_ci' => 'Didžiąsias ir mažąsias raides',
	'cb_copy_line_hint' => 'Naudoti [+] ir [> +] mygtukus kopijuoti ir įklijuoti operatoriai į pasirinktą išraiška',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|kategorija|kategorijos|kategorijų}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|kadras|kadrai|kadrų}}',
	'cb_has_files' => '$1 {{PLURAL:$1|kadras|kadrai|kadrų}}',
	'cb_has_parentcategories' => 'pagrindinės kategorijos (jei yra)',
	'cb_previous_items_link' => 'Ankstesnis',
	'cb_next_items_link' => 'Sekantis',
	'cb_next_items_stats' => '$1 (iš $2 )',
	'cb_cat_subcats' => 'subkategorijos',
	'cb_cat_pages' => 'puslapiai',
	'cb_cat_files' => 'failai',
	'cb_apply_button' => 'Taikyti',
	'cb_all_op' => 'VISI',
	'cb_or_op' => 'arba',
	'cb_and_op' => 'ir',
	'cb_edit_left_hint' => 'Perkelti į kairę, jei įmanoma',
	'cb_edit_right_hint' => 'Perkelti į dešinę, jei įmanoma',
	'cb_edit_remove_hint' => 'Ištrinti, jei įmanoma',
	'cb_edit_copy_hint' => 'Kopijuoti operatorius į mainų sritį',
	'cb_edit_append_hint' => 'Įterpti paskutinės padėties operatorius',
	'cb_edit_clear_hint' => 'Išvalyti dabartinių sąvoka (pasirinkite Visi)',
	'cb_edit_paste_hint' => 'Įklijuoti operatorius į dabartinę padėtį, jei įmanoma',
	'cb_edit_paste_right_hint' => 'Įklijuoti operatorius į dabartinę padėtį, jei įmanoma',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'cb_cat_pages' => 'puslopys',
	'cb_all_op' => 'Vysi',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'categorybrowser' => 'Прелистувач на категории',
	'categorybrowser-desc' => 'Дава [[Special:CategoryBrowser|специјална страница]] за филтрирање на најисполнети категории и движење низ истите со помош на AJAX-посредник',
	'cb_requires_javascript' => 'Додатокот за прелистување на категории бара прелистувачот да има овозможено JavaScript',
	'cb_ie6_warning' => 'Уредникот на услови не работи на Internet Explorer 6.0 и постари верзии.
Меѓутоа прелистувањето на предодредени услови би требало да функционира нормално.
Сменете си го прелистувачот или подновете го.',
	'cb_show_no_parents_only' => 'Прикажувај само категории без матични категории',
	'cb_cat_name_filter' => 'Пребарување на категорија по име:',
	'cb_cat_name_filter_clear' => 'Притиснете тука за да го исчистите полето за пребарување категории по име',
	'cb_cat_name_filter_ci' => 'Не разликува големи/мали букви',
	'cb_copy_line_hint' => 'Користете ги копчињата [+] и [>+] за да копирање и лепење оператори во избраниот израз',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|поткатегорија|поткатегории}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|страница|страници}}',
	'cb_has_files' => '$1 {{PLURAL:$1|податотека|податотеки}}',
	'cb_has_parentcategories' => 'матични категории (ако има)',
	'cb_previous_items_link' => 'Претходни',
	'cb_next_items_link' => 'Следни',
	'cb_next_items_stats' => ' (од $1)',
	'cb_cat_subcats' => 'поткатегории',
	'cb_cat_pages' => 'страници',
	'cb_cat_files' => 'податотеки',
	'cb_apply_button' => 'Примени',
	'cb_all_op' => 'Сè',
	'cb_or_op' => 'или',
	'cb_and_op' => 'и',
	'cb_edit_left_hint' => 'Премести лево, ако може',
	'cb_edit_right_hint' => 'Премести десно, ако може',
	'cb_edit_remove_hint' => 'Избриши, ако може',
	'cb_edit_copy_hint' => 'Ископирај го операторот во оставата за копии',
	'cb_edit_append_hint' => 'Вметни го операторот во последната позиција',
	'cb_edit_clear_hint' => 'Исчисти го тековниот израз (избери сè)',
	'cb_edit_paste_hint' => 'Залепи го операторот во тековната позиција, ако може',
	'cb_edit_paste_right_hint' => 'Залепи го операторот во следната позиција, ако може',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'categorybrowser' => 'വർഗ്ഗം ബ്രൗസർ',
	'categorybrowser-desc' => 'ഏറ്റവുമധികം സൃഷ്ടിക്കപ്പെട്ടിട്ടുള്ള വർഗ്ഗങ്ങളെ തിരഞ്ഞെടുക്കാനും അവയിലൂടെ അജാക്സ് സമ്പർക്കമുഖമുപയോഗിച്ച് കേറിയിറങ്ങാനുമുള്ള അരിപ്പയ്ക്കുള്ള [[Special:CategoryBrowser|പ്രത്യേക താൾ]] തരുന്നു',
	'cb_requires_javascript' => 'വർഗ്ഗം ബ്രൗസർ എക്സ്റ്റെൻഷൻ പ്രവർത്തിക്കാൻ താങ്കളുടെ ബ്രൗസറിൽ ജാവാസ്ക്രിപ്റ്റ് സജ്ജമായിരിക്കണം.',
	'cb_ie6_warning' => 'തിരുത്തുവാനുള്ള ഉപാധി ഇന്റർനെറ്റ് എക്സ്പ്ലോററിലും അതിനും മുമ്പത്തെ പതിപ്പുകളിലും പ്രവർത്തിക്കില്ല.
എന്നിരുന്നാലും, മുമ്പേ നിർവചിച്ചിട്ടുള്ള വ്യവസ്ഥകൾ സാധാരണ പോലെ പ്രവർത്തിക്കുന്നതാണ്.
സാദ്ധ്യമെങ്കിൽ താങ്കളുടെ ബ്രൗസർ പുതുക്കുക, മറ്റൊരു ബ്രൗസർ തിരഞ്ഞെടുക്കുകയോ ചെയ്യുക.',
	'cb_show_no_parents_only' => 'താവഴി വർഗ്ഗങ്ങളില്ലാത്ത വർഗ്ഗങ്ങൾ മാത്രം പ്രദർശിപ്പിക്കുക',
	'cb_cat_name_filter' => 'പേരനുസരിച്ച് വർഗ്ഗം തിരയുക:',
	'cb_cat_name_filter_clear' => 'വർഗ്ഗത്തിന്റെ പേരിന്റെ അരിപ്പ ശൂന്യമാക്കാൻ ഞെക്കുക',
	'cb_cat_name_filter_ci' => 'കേസ് അധിഷ്ഠിതമല്ല',
	'cb_copy_line_hint' => 'തിരഞ്ഞെടുത്ത എക്സ്‌പ്രെഷനിൽ ഓപ്പറേറ്ററുകൾ പകർത്താനും ചേർക്കാനും [+] ഒപ്പം [>+] ബട്ടണുകൾ ഉപയോഗിക്കുക.',
	'cb_has_subcategories' => '{{PLURAL:$1|ഒരു ഉപവർഗ്ഗം|$1 ഉപവർഗ്ഗങ്ങൾ}}',
	'cb_has_pages' => '{{PLURAL:$1|ഒരു താൾ|$1 താളുകൾ}}',
	'cb_has_files' => '{{PLURAL:$1|ഒരു പ്രമാണം|$1 പ്രമാണങ്ങൾ}}',
	'cb_has_parentcategories' => 'താവഴി വർഗ്ഗങ്ങൾ (ഉണ്ടെങ്കിൽ)',
	'cb_previous_items_link' => 'മുമ്പത്തെ',
	'cb_next_items_link' => 'അടുത്തത്',
	'cb_next_items_stats' => ' ($1 എന്നതിൽ നിന്ന്)',
	'cb_cat_subcats' => 'ഉപവർഗ്ഗങ്ങൾ',
	'cb_cat_pages' => 'താളുകൾ',
	'cb_cat_files' => 'പ്രമാണങ്ങൾ',
	'cb_apply_button' => 'ബാധകമാക്കുക',
	'cb_all_op' => 'എല്ലാം',
	'cb_or_op' => 'അഥവാ',
	'cb_and_op' => 'ഒപ്പം',
	'cb_edit_left_hint' => 'സാദ്ധ്യമെങ്കിൽ ഇടത്തോട്ട് മാറ്റുക',
	'cb_edit_right_hint' => 'സാദ്ധ്യമെങ്കിൽ വലത്തോട്ട് മാറ്റുക',
	'cb_edit_remove_hint' => 'സാദ്ധ്യമെങ്കിൽ മായ്ക്കുക',
	'cb_edit_copy_hint' => 'ഓപ്പറേറ്റർ ക്ലിപ്ബോർഡിലേയ്ക്ക് പകർത്തുക',
	'cb_edit_append_hint' => 'ഓപ്പറേറ്റർ അവസാന സ്ഥാനത്ത് ഉൾപ്പെടുത്തുക',
	'cb_edit_clear_hint' => 'ഇപ്പോഴത്തെ എക്സ്പ്രെഷൻ ശൂന്യമാക്കുക (എല്ലാം തിരഞ്ഞെടുക്കുക)',
	'cb_edit_paste_hint' => 'സാദ്ധ്യമെങ്കിൽ ഇപ്പോഴത്തെ സ്ഥാനത്തേയ്ക്ക് ഓപ്പറേറ്റർ ഉൾപ്പെടുത്തുക',
	'cb_edit_paste_right_hint' => 'സാദ്ധ്യമെങ്കിൽ അടുത്ത സ്ഥാനത്തേയ്ക്ക് ഓപ്പറേറ്റർ ചേർക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'cb_has_pages' => '$1 {{PLURAL:$1|хуудас}}',
	'cb_all_op' => 'Бүгдийг',
);

/** Marathi (मराठी)
 * @author Htt
 */
$messages['mr'] = array(
	'cb_previous_items_link' => 'मागे',
	'cb_next_items_link' => 'पुढे',
	'cb_all_op' => 'सर्व',
	'cb_or_op' => 'किंवा',
	'cb_and_op' => 'आणि',
	'cb_edit_left_hint' => 'शक्य असल्यास, डावीकडे हलवा',
	'cb_edit_right_hint' => 'शक्य असल्यास, उजवीकडे हलवा',
	'cb_edit_remove_hint' => 'शक्य असल्यास वगळा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'categorybrowser' => 'Penyemak seimbas kategori',
	'categorybrowser-desc' => 'Menyediakan [[Special:CategoryBrowser|laman khas]] untuk mengasingkan kebanyakan kategori yang berisi serta memandu arahnya dengan menggunakan antara muka AJAX',
	'cb_requires_javascript' => 'Sambungan pelayar kategori memerlukan JavaScript dihidupkan dalam pelayar.',
	'cb_ie6_warning' => 'Editor syarat tidak berfungsi dalam Internet Explorer 6.0 atau versi-versi sebelumnya.
Namun demikian, syarat-syarat yang sudah ditakrifkan dijangka boleh disemak seimbas seperti biasa.
Sila tukar atau naik taraf pelayar anda jika boleh.',
	'cb_show_no_parents_only' => 'Tunjukkan kategori tanpa induk sahaja',
	'cb_cat_name_filter' => 'Cari kategori mengikut nama:',
	'cb_cat_name_filter_clear' => 'Tekan untuk mengosongkan penapis nama kategori',
	'cb_cat_name_filter_ci' => 'Tidak peka besar kecil huruf',
	'cb_copy_line_hint' => 'Gunakan butang [+] dan [>+] untuk menyalin dan menampalkan operator dalam ungkapan yang terpilih',
	'cb_has_subcategories' => '$1 subkategori',
	'cb_has_pages' => '$1 laman',
	'cb_has_files' => '$1 fail',
	'cb_has_parentcategories' => 'kategori induk (jika ada)',
	'cb_previous_items_link' => 'Sebelumnya',
	'cb_next_items_link' => 'Berikutnya',
	'cb_next_items_stats' => ' (dari $1)',
	'cb_cat_subcats' => 'subkategori',
	'cb_cat_pages' => 'laman',
	'cb_cat_files' => 'fail',
	'cb_apply_button' => 'Gunakan',
	'cb_all_op' => 'Semua',
	'cb_or_op' => 'atau',
	'cb_and_op' => 'dan',
	'cb_edit_left_hint' => 'Alihkan ke kiri, jika boleh',
	'cb_edit_right_hint' => 'Alihkan ke kanan, jika boleh',
	'cb_edit_remove_hint' => 'Hapuskan, jika boleh',
	'cb_edit_copy_hint' => 'Salin operator ke papan keratan',
	'cb_edit_append_hint' => 'Isikan operator di kedudukan terakhir',
	'cb_edit_clear_hint' => 'Padamkan ungkapan semasa (pilih semua)',
	'cb_edit_paste_hint' => 'Tampalkan operator dalam kedudukan semasa, jika boleh',
	'cb_edit_paste_right_hint' => 'Tampalkan operator dalam kedudukan berikutnya, jika boleh',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'cb_previous_items_link' => 'Удалов',
	'cb_previous_items_stats' => ' ($1 - $2)',
	'cb_next_items_link' => 'Седе тов',
	'cb_cat_pages' => 'лопат',
	'cb_cat_files' => 'файлат',
	'cb_all_op' => 'Весе',
	'cb_or_op' => 'эли',
	'cb_and_op' => 'ды',
	'cb_edit_left_hint' => 'Керш пелев шаштови, шаштык',
	'cb_edit_right_hint' => 'Вить пелев шаштови, шаштык',
	'cb_edit_remove_hint' => 'Нардави, нардык',
);

/** Nahuatl (Nāhuatl)
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'categorybrowser' => 'Tlatlaìxmatkàtlàlilòyàn nẻmini',
	'categorybrowser-desc' => 'Tèmàktia sè [[Special:CategoryBrowser|nònkuâkìski tlaìxtlapalli]] tlèn ìka mokintlapêpenia in tlaìxmatkàtlàlilòmë tlèn okachi mokintekìuhtia wàn tèkàwilia ìntech nènèmòwas ìka sè AJAX netzòwilìxtli',
	'cb_show_no_parents_only' => 'Monèxtìs san tlaìxmatkàtlalilòmë tlèn âmò kipiâkë tlapantlaìxmatkàtlàlilòmë',
	'cb_cat_name_filter' => 'Motèmòs in tlaìxmatkàtlàlilòtl ìka ìtòka:',
	'cb_cat_name_filter_clear' => 'Xikpàchilwi nikàn ìka tikìxpôpolòs in tlaìxmatkàtlàlilòtòkâtli',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|tlaìxmatkàtlàlilòpilli|tlaìxmatkàtlàlilòpiltìn}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|tlaìxtlapalli|tlaìxtlapaltin}}',
	'cb_has_files' => '$1 {{PLURAL:$1|èwalli|èwaltin}}',
	'cb_has_parentcategories' => 'Tlapantlaìxmatkàtlàlilòmë (intlà katêkë)',
	'cb_previous_items_link' => 'Achtỏpan',
	'cb_next_items_link' => 'Oksèya',
	'cb_next_items_stats' => '(ìpan $1)',
	'cb_cat_subcats' => 'tlaìxmatkàtlàlilòpilòltin',
	'cb_cat_pages' => 'tlaìxtlapaltin',
	'cb_cat_files' => 'èwaltin',
	'cb_apply_button' => 'Motlàlilìs',
	'cb_all_op' => 'Mochtìn',
	'cb_or_op' => 'nòso',
	'cb_and_op' => 'wàn',
	'cb_edit_left_hint' => 'opòchkan mòlinìs, intlà kualli',
	'cb_edit_right_hint' => 'Yèuhkàn mòlinìs, intlà kualli',
	'cb_edit_remove_hint' => 'Mìxpôpolòs, intlà kualli',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'categorybrowser' => 'Kategorileser',
	'categorybrowser-desc' => 'Tilbyr en [[Special:CategoryBrowser|spesialside]] til å filtrere ut de mest populære kategoriene og til å navigere dem ved hjelp av et AJAX-grensesnitt',
	'cb_requires_javascript' => 'Kategorileserutvidelsen krever at JavaScript er aktivert i nettleseren.',
	'cb_ie6_warning' => 'Vilkårseditoren virker ikke i Internet Explorer 6.0 eller tidligere versjoner.
Imidlertid, lesing av forhåndsdefinerte vilkår bør virke normalt.
Endre eller oppgrader nettleseren din, om mulig.',
	'cb_show_no_parents_only' => 'Bare vis kategorier uten foreldre',
	'cb_cat_name_filter' => 'Søk etter kategori ved navn:',
	'cb_cat_name_filter_clear' => 'Trykk for å tømme kategorinavnefileteret',
	'cb_cat_name_filter_ci' => 'Tar ikke hensyn til store eller små bokstaver',
	'cb_copy_line_hint' => 'Bruk [+]- og [>+]-knappene for å kopiere og lime inn operatorer i det valgte uttrykket',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|underkategori|underkategorier}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|side|sider}}',
	'cb_has_files' => '$1 {{PLURAL:$1|fil|filer}}',
	'cb_has_parentcategories' => 'foreldrekategorier (om noen)',
	'cb_previous_items_link' => 'Forrige',
	'cb_next_items_link' => 'Neste',
	'cb_next_items_stats' => ' (fra $1)',
	'cb_cat_subcats' => 'underkategorier',
	'cb_cat_pages' => 'sider',
	'cb_cat_files' => 'filer',
	'cb_apply_button' => 'Bruk',
	'cb_all_op' => 'Alle',
	'cb_or_op' => 'eller',
	'cb_and_op' => 'og',
	'cb_edit_left_hint' => 'Flytt til venstre, om mulig',
	'cb_edit_right_hint' => 'Flytt til høyre, om mulig',
	'cb_edit_remove_hint' => 'Slett, om mulig',
	'cb_edit_copy_hint' => 'Kopier operator til utklippstavle',
	'cb_edit_append_hint' => 'Sett inn operator til siste posisjon',
	'cb_edit_clear_hint' => 'Tøm nåværende uttrykk (velg alle)',
	'cb_edit_paste_hint' => 'Lim operator inn i nåværende posisjon, om mulig',
	'cb_edit_paste_right_hint' => 'Lim operator inn i neste posisjon, om mulig',
);

/** Dutch (Nederlands)
 * @author Kjell
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'categorybrowser' => 'Categorieën doorbladeren',
	'categorybrowser-desc' => 'Maakt een [[Special:CategoryBrowser|speciale pagina]] beschikbaar om categorieën met de meeste elementen te selecteren en ze te verkennen via een AJAX-interface',
	'cb_requires_javascript' => 'De uitbreiding voor het doorbladeren van categorieën vereist dat JavaScript is ingeschakeld in de browser.',
	'cb_ie6_warning' => 'De tekstverwerker voor condities werkt niet in Internet Explorer 6.0 of eerdere versies.
Vooraf gedefinieerde voorwaarden doorbladeren hoort normaal te werken.
Gebruik een andere browser of werkt deze bij, als mogelijk.',
	'cb_show_no_parents_only' => 'Alleen categorieën weergeven die geen bovenliggende categorieën hebben',
	'cb_cat_name_filter' => 'Op naam naar categorie zoeken:',
	'cb_cat_name_filter_clear' => 'Klik om het categorienaamfilter te verwijderen',
	'cb_cat_name_filter_ci' => 'Hoofdletterongevoelig',
	'cb_copy_line_hint' => 'Gebruik de knoppen [+] en [>+] om de operators in de geselecteerde expressie te kopiëren en plakken',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategorie|subcategorieën}}',
	'cb_has_pages' => "$1 {{PLURAL:$1|pagina|pagina's}}",
	'cb_has_files' => '$1 {{PLURAL:$1|bestand|bestanden}}',
	'cb_has_parentcategories' => 'bovenliggende categorieën (als die bestaan)',
	'cb_previous_items_link' => 'Vorige',
	'cb_next_items_link' => 'Volgende',
	'cb_next_items_stats' => '(van $1)',
	'cb_cat_subcats' => 'ondercategorieën',
	'cb_cat_pages' => "pagina's",
	'cb_cat_files' => 'bestanden',
	'cb_apply_button' => 'Toepassen',
	'cb_all_op' => 'Alles',
	'cb_or_op' => 'of',
	'cb_and_op' => 'en',
	'cb_edit_left_hint' => 'Naar links verplaatsen, indien mogelijk',
	'cb_edit_right_hint' => 'Naar rechts verplaatsen, indien mogelijk',
	'cb_edit_remove_hint' => 'Verwijderen, indien mogelijk',
	'cb_edit_copy_hint' => 'Operator naar klembord kopiëren',
	'cb_edit_append_hint' => 'Operator na laatste positie invoegen',
	'cb_edit_clear_hint' => 'Huidige expressie wissen (alles selecteren)',
	'cb_edit_paste_hint' => 'Als mogelijk de operator op de huidige positie invoegen',
	'cb_edit_paste_right_hint' => 'Als mogelijk de operator op de volgende positie invoegen',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'cb_ie6_warning' => 'De tekstverwerker voor condities werkt niet in Internet Explorer 6.0 of eerdere versies.
Vooraf gedefinieerde voorwaarden doorbladeren hoort normaal te werken.
Gebruik een andere browser of werkt deze bij, als mogelijk.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'cb_previous_items_link' => 'Førre',
	'cb_next_items_link' => 'Neste',
	'cb_next_items_stats' => ' (frå $1)',
	'cb_cat_subcats' => 'underkategoriar',
	'cb_cat_pages' => 'sider',
	'cb_cat_files' => 'filer',
	'cb_all_op' => 'Alle',
	'cb_and_op' => 'og',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jnanaranjan Sahu
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'cb_previous_items_link' => 'ପୂର୍ବବର୍ତ୍ତୀ',
	'cb_next_items_link' => 'ପର',
	'cb_cat_files' => 'ଫାଇଲ',
	'cb_edit_left_hint' => 'ଯଦି ସମ୍ଭବ, ବାମକୁ ଘୁଞ୍ଚାନ୍ତୁ',
	'cb_edit_right_hint' => 'ଯଦି ସମ୍ଭବ, ଡାହାଣକୁ ଘୁଞ୍ଚାନ୍ତୁ',
	'cb_edit_remove_hint' => 'ଯଦି ସମ୍ଭବ, ଲିଭାନ୍ତୁ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'cb_has_subcategories' => '$1 {{PLURAL:$1|Unnerabdeeling|Unnerabdeelinge}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|Blatt|Bledder}}',
	'cb_has_files' => '$1 {{PLURAL:$1|Feil|Feils}}',
	'cb_next_items_link' => 'Neegschte',
	'cb_cat_pages' => 'Bledder',
	'cb_cat_files' => 'Feils',
	'cb_all_op' => 'All',
	'cb_or_op' => 'odder',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'cb_previous_items_link' => 'Voriche',
	'cb_next_items_link' => 'Negschte',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'categorybrowser' => 'Przeglądarka kategorii',
	'categorybrowser-desc' => '[[Special:CategoryBrowser|Strona specjalna]] do odnajdywania najczęściej wykorzystywanych kategorii i do przeglądania ich z wykorzystaniem interfejsu wykonanego w technologii AJAX',
	'cb_requires_javascript' => 'Przeglądarka kategorii wymaga włączonej w przeglądarce obsługi JavaScript',
	'cb_ie6_warning' => 'Edytor warunków nie działa poprawnie w przeglądarce Internet Explorer 6.0 i jej wcześniejszych wersjach.
Można jednak przeglądać wcześniej zdefiniowane warunki.
Jeśli to możliwe zmień lub uaktualnij swoją przeglądarkę.',
	'cb_show_no_parents_only' => 'Pokaż wyłącznie kategorie, które nie mają kategorii nadrzędnych',
	'cb_cat_name_filter' => 'Szukaj kategorii według nazwy',
	'cb_cat_name_filter_clear' => 'Naciśnij, aby wyczyścić filtr nazw kategorii',
	'cb_cat_name_filter_ci' => 'Ignoruj wielkość liter',
	'cb_copy_line_hint' => 'Użyj przycisków [+] i [>+] aby skopiować i wkleić operatory w wybranym wyrażeniu',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|podkategoria|podkategorie|podkategorii}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|strona|strony|stron}}',
	'cb_has_files' => '$1 {{PLURAL:$1|plik|pliki|plików}}',
	'cb_has_parentcategories' => 'kategorię nadrzędne (jeśli są)',
	'cb_previous_items_link' => 'poprzednie',
	'cb_next_items_link' => 'następne',
	'cb_next_items_stats' => '(od $1)',
	'cb_cat_subcats' => 'podkategorie',
	'cb_cat_pages' => 'strony',
	'cb_cat_files' => 'pliki',
	'cb_apply_button' => 'Zastosuj',
	'cb_all_op' => 'Wszystkie',
	'cb_or_op' => 'lub',
	'cb_and_op' => 'i',
	'cb_edit_left_hint' => 'Jeśli to możliwe przesuń w lewo',
	'cb_edit_right_hint' => 'Jeśli to możliwe przesuń w prawo',
	'cb_edit_remove_hint' => 'Jeśli to możliwe usuń',
	'cb_edit_copy_hint' => 'Skopiuj operator do schowka',
	'cb_edit_append_hint' => 'Wstaw operator na ostatnią pozycję',
	'cb_edit_clear_hint' => 'Wyczyść aktualne wyrażenie (wybierz wszystko)',
	'cb_edit_paste_hint' => 'Jeśli to możliwe wstaw operator na aktualną pozycję',
	'cb_edit_paste_right_hint' => 'Jeśli to możliwe wstaw operator na następną pozycję',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'categorybrowser' => 'Navigador ëd categorìe',
	'categorybrowser-desc' => "A dà na [[Special:CategoryBrowser|pàgina special]] për filtré le categorìe pi popolar e për scorje an dovrand n'antërfacia AJAX",
	'cb_requires_javascript' => "L'estension ëd navigador ëd categorìa a ciama che JavaScript a sia abilità ant ël navigador.",
	'cb_ie6_warning' => "L'editor condissional a marcia pa con Internet Explorer 6.0 o version pi veje.
An tùit ij cas, la navigassion dle condission predefinìe a dovrìa travajé normalment.
Për piasì, ch'a cangia o ch'a modìfica sò navigador, se possìbil.",
	'cb_show_no_parents_only' => "Smon-e mach le categorìe ch'a l'han pa ëd categorìa mare",
	'cb_cat_name_filter' => 'Sërché dle categorìe për nòm:',
	'cb_cat_name_filter_clear' => 'Sgnaché për scancelé ij fìlter ëd nòm ëd categorìa',
	'cb_cat_name_filter_ci' => 'Pa sensìbil a minùscol/maiùscol',
	'cb_copy_line_hint' => "Ch'a deuvra ij boton [+] and [>+] për copié e ancolé j'operador ant l'espression selessionà",
	'cb_has_subcategories' => '$1 {{PLURAL:$1|sotcategorìa|sotcategorìe}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|pàgina|pàgine}}',
	'cb_has_files' => '$1 {{PLURAL:$1|archivi|archivi}}',
	'cb_has_parentcategories' => "categorìe mare (s'a-i na j'é)",
	'cb_previous_items_link' => 'Prima',
	'cb_next_items_link' => 'Apress',
	'cb_next_items_stats' => '(da $1)',
	'cb_cat_subcats' => 'sotcategorìe',
	'cb_cat_pages' => 'pàgine',
	'cb_cat_files' => 'archivi',
	'cb_apply_button' => 'Fà',
	'cb_all_op' => 'Tùit',
	'cb_or_op' => 'o',
	'cb_and_op' => 'e',
	'cb_edit_left_hint' => 'Va a snista, se possìbil',
	'cb_edit_right_hint' => 'Va a drita, se possìbil',
	'cb_edit_remove_hint' => 'Scancelé, se possìbil',
	'cb_edit_copy_hint' => "Copié l'operador an sla giojera",
	'cb_edit_append_hint' => "Anserì l'operador ant l'ùltima posission",
	'cb_edit_clear_hint' => "Scancelé l'espression corenta (selessioné tut)",
	'cb_edit_paste_hint' => "Ancolé l'operador ant la posission corenta, se possìbil",
	'cb_edit_paste_right_hint' => "Ancolé l'operador ant la posission apress, se possìbil",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'categorybrowser' => 'وېشنيزه سپړونکی',
	'cb_cat_subcats' => 'هېڅ څېرمه وېشنيزې نشته',
	'cb_cat_pages' => 'مخونه',
	'cb_cat_files' => 'دوتنې',
	'cb_all_op' => 'ټول',
	'cb_or_op' => 'يا',
	'cb_and_op' => 'او',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'categorybrowser' => 'Navegação de categorias',
	'categorybrowser-desc' => 'Fornece uma [[Special:CategoryBrowser|página especial]] para filtrar as categorias mais povoadas e navegá-las com uma interface AJAX',
	'cb_requires_javascript' => 'A extensão para navegação de categorias necessita que o JavaScript tenha sido activado no seu browser.',
	'cb_ie6_warning' => 'O editor de condições não funciona no Internet Explorer versão 6.0 ou anteriores.
No entanto, a navegação de condições predefinidas deve funcionar normalmente.
Se for possível, mude ou actualize o seu browser, por favor.',
	'cb_show_no_parents_only' => 'Mostrar só as categorias que não têm categorias superiores',
	'cb_cat_name_filter' => 'Procurar a categoria pelo nome:',
	'cb_cat_name_filter_clear' => 'Clique para limpar o filtro do nome da categoria',
	'cb_cat_name_filter_ci' => 'Sem distinguir maiúsculas de minúsculas',
	'cb_copy_line_hint' => 'Use os botões [+] e [>+] para copiar e inserir operadores na expressão seleccionada',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategoria|subcategorias}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'cb_has_files' => '$1 {{PLURAL:$1|ficheiro|ficheiros}}',
	'cb_has_parentcategories' => 'categorias superiores (se existirem)',
	'cb_previous_items_link' => 'Anterior',
	'cb_previous_items_stats' => ' ($1 - $2)',
	'cb_next_items_link' => 'Seguinte',
	'cb_next_items_stats' => ' (de $1)',
	'cb_cat_subcats' => 'subcategorias',
	'cb_cat_pages' => 'páginas',
	'cb_cat_files' => 'ficheiros',
	'cb_apply_button' => 'Aplicar',
	'cb_all_op' => 'Todas',
	'cb_or_op' => 'ou',
	'cb_and_op' => 'e',
	'cb_edit_left_hint' => 'Mover para a esquerda, se possível',
	'cb_edit_right_hint' => 'Mover para a direita, se possível',
	'cb_edit_remove_hint' => 'Apagar, se possível',
	'cb_edit_copy_hint' => 'Copiar o operador',
	'cb_edit_append_hint' => 'Inserir o operador na última posição',
	'cb_edit_clear_hint' => 'Limpar a expressão presente (seleccionar todas)',
	'cb_edit_paste_hint' => 'Inserir o operador na posição actual, se possível',
	'cb_edit_paste_right_hint' => 'Inserir o operador na posição seguinte, se possível',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'categorybrowser' => 'Navegador de categorias',
	'categorybrowser-desc' => 'Fornece uma [[Special:CategoryBrowser|página especial]] para filtrar as categorias mais povoadas e navegá-las com uma interface AJAX',
	'cb_requires_javascript' => 'A extensão para navegação de categorias necessita que o JavaScript tenha sido ativado no seu navegador.',
	'cb_ie6_warning' => 'O editor de condições não funciona no Internet Explorer versão 6.0 ou anteriores.
No entanto, a navegação de condições predefinidas deve funcionar normalmente.
Se for possível, mude ou atualize o seu navegador, por favor.',
	'cb_show_no_parents_only' => 'Mostrar só as categorias que não têm categorias superiores',
	'cb_cat_name_filter' => 'Procurar categoria por  nome:',
	'cb_cat_name_filter_clear' => 'Clique para limpar o filtro do nome da categoria',
	'cb_cat_name_filter_ci' => 'Não diferenciar maiúsculas/minúsculas',
	'cb_copy_line_hint' => 'Use os botões [+] e [>+] para copiar e inserir operadores na expressão selecionada',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|subcategoria|subcategorias}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|página|páginas}}',
	'cb_has_files' => '$1 {{PLURAL:$1|arquivo|arquivos}}',
	'cb_has_parentcategories' => 'categorias superiores (se existirem)',
	'cb_previous_items_link' => 'Anteriores',
	'cb_next_items_link' => 'Próximos',
	'cb_next_items_stats' => ' (de $1)',
	'cb_cat_subcats' => 'subcategorias',
	'cb_cat_pages' => 'páginas',
	'cb_cat_files' => 'arquivos',
	'cb_apply_button' => 'Aplicar',
	'cb_all_op' => 'Todos',
	'cb_or_op' => 'ou',
	'cb_and_op' => 'e',
	'cb_edit_left_hint' => 'Mover para esquerda, se possível',
	'cb_edit_right_hint' => 'Mover para direita, se possível',
	'cb_edit_remove_hint' => 'Apagar, se possível',
	'cb_edit_copy_hint' => 'Copiar o operador',
	'cb_edit_append_hint' => 'Inserir o operador na última posição',
	'cb_edit_clear_hint' => 'Limpar a expressão presente (selecionar todas)',
	'cb_edit_paste_hint' => 'Inserir o operador na posição atual, se possível',
	'cb_edit_paste_right_hint' => 'Inserir o operador na posição seguinte, se possível',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'cb_previous_items_link' => 'Precedentele',
	'cb_next_items_link' => 'Următoarele',
	'cb_cat_subcats' => 'subcategorii',
	'cb_cat_pages' => 'pagini',
	'cb_cat_files' => 'fişier',
	'cb_apply_button' => 'Aplică',
	'cb_all_op' => 'Toţi',
	'cb_or_op' => 'sau',
	'cb_and_op' => 'şi',
	'cb_edit_left_hint' => 'Mută la stânga, dacă e posibil',
	'cb_edit_right_hint' => 'Mută la dreapta, dacă e posibil',
	'cb_edit_remove_hint' => 'Şterge, dacă e posibil',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'cb_previous_items_link' => 'Precedende',
	'cb_next_items_link' => 'Prossime',
	'cb_next_items_stats' => ' (da $1)',
	'cb_cat_subcats' => 'sotte categorije',
	'cb_cat_pages' => 'pàggene',
	'cb_cat_files' => 'file',
	'cb_apply_button' => 'Appleche',
	'cb_all_op' => 'Tutte',
	'cb_or_op' => 'o',
	'cb_and_op' => 'e',
);

/** Russian (Русский)
 * @author MaxSem
 * @author QuestPC
 */
$messages['ru'] = array(
	'categorybrowser' => 'Просмотр категорий',
	'categorybrowser-desc' => 'Предоставляет [[Special:CategoryBrowser|специальную страницу]] для выбора наиболее ёмких категорий вики-сайта с целью последующей навигации с использованием AJAX-интерфейса',
	'cb_requires_javascript' => 'Расширение для просмотра категорий требует включения поддержки Javascript в браузере',
	'cb_ie6_warning' => 'Редактор выражений не поддерживается в Internet Explorer версии 6.0 или более ранних.
Возможен лишь просмотр предопределенных выражений.
Пожалуйста поменяйте или обновите ваш браузер.',
	'cb_show_no_parents_only' => 'Показывать только категории без родителей',
	'cb_cat_name_filter' => 'Поиск категории по имени:',
	'cb_cat_name_filter_clear' => 'Нажмите здесь для очистки поля поиска категории по имени',
	'cb_cat_name_filter_ci' => 'Без учёта регистра',
	'cb_copy_line_hint' => 'Используйте кнопки [+] и [>+] для копирования оператора в выбранное выражение',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|подкатегория|подкатегории|подкатегорий}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|страница|страницы|страниц}}',
	'cb_has_files' => '$1 {{PLURAL:$1|файл|файла|файлов}}',
	'cb_has_parentcategories' => 'родительские категории (если есть)',
	'cb_previous_items_link' => 'Предыдущие',
	'cb_next_items_link' => 'Следующие',
	'cb_next_items_stats' => ' (начиная с $1)',
	'cb_cat_subcats' => 'подкатегорий',
	'cb_cat_pages' => 'страниц',
	'cb_cat_files' => 'файлов',
	'cb_apply_button' => 'Применить',
	'cb_all_op' => 'Все',
	'cb_or_op' => 'или',
	'cb_and_op' => 'и',
	'cb_edit_left_hint' => 'Переместить влево, если возможно',
	'cb_edit_right_hint' => 'Переместить вправо, если возможно',
	'cb_edit_remove_hint' => 'Удалить, если возможно',
	'cb_edit_copy_hint' => 'Скопировать оператор в буфер обмена',
	'cb_edit_append_hint' => 'Вставить оператор в последнюю позицию',
	'cb_edit_clear_hint' => 'Очистить текущее выражение (выбрать всё)',
	'cb_edit_paste_hint' => 'Вставить оператор в текущую позицию, если возможно',
	'cb_edit_paste_right_hint' => 'Вставить оператор в следующую позицию, если возможно',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'categorybrowser' => 'Перегляд катеґорій',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|підкатеґорія|підкатеґорії|підкатеґорій}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|сторінка|сторінкы|сторінок}}',
	'cb_has_files' => '$1 {{PLURAL:$1|файл|файлы|файлів}}',
	'cb_previous_items_link' => 'Попереднї',
	'cb_next_items_link' => 'Далшы',
	'cb_cat_subcats' => 'підкатеґорій',
	'cb_cat_pages' => 'сторінок',
	'cb_cat_files' => 'файлы',
	'cb_all_op' => 'Вшыткы',
	'cb_or_op' => 'або',
	'cb_and_op' => 'і',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'cb_previous_items_link' => "'N arreri",
	'cb_next_items_link' => "'N avanti",
	'cb_cat_pages' => 'pàggini',
	'cb_all_op' => 'Tutti',
	'cb_or_op' => 'o',
	'cb_and_op' => 'e',
);

/** Tachelhit (Tašlḥiyt/ⵜⴰⵛⵍⵃⵉⵜ)
 * @author Dalinanir
 */
$messages['shi'] = array(
	'categorybrowser' => 'Amuddu ɣ tilɣiwin',
	'cb_next_items_link' => 'Amdfr (wali d idfarn)',
	'cb_edit_paste_right_hint' => 'Zdi, iɣ as tufit, ɣ ugmmaḍ d ittfrn',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'categorybrowser' => 'Prehliadač kategórií',
	'categorybrowser-desc' => 'Poskytuje [[Special:CategoryBrowser|špeciánu stránku]] na filtrovanie najpoužívanejších kategórií a navigáciu medzi nimi pomocou rozhrania AJAX',
	'cb_requires_javascript' => 'Rozšírenie prehliadač kategórií vyžaduje, aby bol v prehliadači povolený JavaScript.',
	'cb_ie6_warning' => 'Editor podmienok nefunguje v Internet Explorer 6.0 alebo starších verziách.
Prehliadanie už definovaných podmienok by však malo pracovať normálne.
Prosím, aktualizujte svoj prehliadač alebo použite iný, ak je to možné.',
	'cb_show_no_parents_only' => 'Zobraziť iba kategórie, ktoré nemajú nadradené kategórie',
	'cb_cat_name_filter' => 'Hľadať kategóriu podľa názvu:',
	'cb_cat_name_filter_clear' => 'Stlačením tlačidla zrušíte filter názov kategórie',
	'cb_cat_name_filter_ci' => 'Nerozlišovať veľkosť písmen',
	'cb_copy_line_hint' => 'Pomocou tlačidiel [+] a [>+] môžete kopírovať a vkladať operátory do vybraného výrazu',
	'cb_has_subcategories' => '{{PLURAL:$1|podkategória|podkategórie|podkategórií}}:',
	'cb_has_pages' => '$1 {{PLURAL:$1|stránka|stránky|stránok}}',
	'cb_has_files' => '$1 {{PLURAL:$1|súbor|súbory|súborov}}',
	'cb_has_parentcategories' => 'nadradené kategórie (ak existujú)',
	'cb_previous_items_link' => 'Predošlá',
	'cb_next_items_link' => 'Ďalšia',
	'cb_next_items_stats' => ' (od $1)',
	'cb_cat_subcats' => 'podkategórie',
	'cb_cat_pages' => 'stránky',
	'cb_cat_files' => 'súbory',
	'cb_apply_button' => 'Použiť',
	'cb_all_op' => 'Všetky',
	'cb_or_op' => 'alebo',
	'cb_and_op' => 'a',
	'cb_edit_left_hint' => 'Posunúť doľava, ak je to možné',
	'cb_edit_right_hint' => 'Posunúť doprava, ak je to možné',
	'cb_edit_remove_hint' => 'Odstrániť, ak je to možné',
	'cb_edit_copy_hint' => 'Kopírovať operátor do schránky',
	'cb_edit_append_hint' => 'Vložte operátor na poslednú pozíciu',
	'cb_edit_clear_hint' => 'Vymazať aktuálny výraz (vybrať všetko)',
	'cb_edit_paste_hint' => 'Vložiť operátor na aktuálnu pozíciu, ak je to možné',
	'cb_edit_paste_right_hint' => 'Vložiť operátor na aktuálnu ďalšiu, ak je to možné',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'categorybrowser' => 'Brskalnik po kategorijah',
	'categorybrowser-desc' => 'Nudi [[Special:CategoryBrowser|posebno stran]] za izločanje najbolj poseljenih kategorij in navigiranje po njih z uporabo vmesnika Ajax',
	'cb_requires_javascript' => 'Razširitev brskanja po kategorijah v brskalniku zahteva omogočen JavaScript.',
	'cb_ie6_warning' => 'Urejevalnik pogojev ne deluje v Internet Explorer 6.0 ali starejših različicah.
Kljub temu brskanje po vnaprej določenih pogojih deluje normalno.
Prosimo, spremenite ali posodobite svoj brskalnik, če je le mogoče.',
	'cb_show_no_parents_only' => 'Prikaži samo kategorije, ki nimajo staršev',
	'cb_cat_name_filter' => 'Iskanje kategorije po imenu:',
	'cb_cat_name_filter_clear' => 'Protisnite, da počistite filter imena kategorije',
	'cb_cat_name_filter_ci' => 'Neobčutljivo na velikost črk',
	'cb_copy_line_hint' => 'Uporabite gumba [+] in [>+] za kopiranje in lepljenje operatorjev v izbrani izraz',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|podkategorija|podkategoriji|podkategorije|podkategorij}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|stran|strani}}',
	'cb_has_files' => '$1 {{PLURAL:$1|datoteka|datoteki|datoteke|datotek}}',
	'cb_has_parentcategories' => 'starševske kategorije (če obstajajo)',
	'cb_previous_items_link' => 'Prejšnja',
	'cb_next_items_link' => 'Naslednja',
	'cb_next_items_stats' => ' (od $1)',
	'cb_cat_subcats' => 'podkategorije',
	'cb_cat_pages' => 'strani',
	'cb_cat_files' => 'datoteke',
	'cb_apply_button' => 'Uporabi',
	'cb_all_op' => 'Vse',
	'cb_or_op' => 'ali',
	'cb_and_op' => 'in',
	'cb_edit_left_hint' => 'Prestavi levo, če je mogoče',
	'cb_edit_right_hint' => 'Prestavi desno, če je mogoče',
	'cb_edit_remove_hint' => 'Izbriši, če je mogoče',
	'cb_edit_copy_hint' => 'Kopiraj operator v odložišče',
	'cb_edit_append_hint' => 'Vstavi operator na zadnje mesto',
	'cb_edit_clear_hint' => 'Počisti trenutni izraz (izberi vse)',
	'cb_edit_paste_hint' => 'Prilepi operator na trenutni položaj, če je mogoče',
	'cb_edit_paste_right_hint' => 'Prilepi operator na naslednji položaj, če je mogoče',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'cb_previous_items_link' => 'Претходно',
	'cb_previous_items_stats' => ' ($1 - $2)',
	'cb_next_items_link' => 'Следеће',
	'cb_next_items_stats' => ' (од $1)',
	'cb_cat_subcats' => 'поткатегорије',
	'cb_cat_pages' => 'странице',
	'cb_cat_files' => 'датотеке',
	'cb_apply_button' => 'Примени',
	'cb_all_op' => 'Све',
	'cb_or_op' => 'или',
	'cb_and_op' => 'и',
	'cb_edit_left_hint' => 'Премести лево, ако је могуће',
	'cb_edit_right_hint' => 'Премести десно, ако је могуће',
	'cb_edit_remove_hint' => 'Обриши, ако је могуће',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'cb_previous_items_stats' => ' ($1 - $2)',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'categorybrowser' => 'Kategoriläsare',
	'cb_cat_name_filter' => 'Sök efter kategori med namn:',
	'cb_cat_name_filter_clear' => 'Tryck för att rensa filter för kategorinamn',
	'cb_cat_name_filter_ci' => 'Okänslig för versaler',
	'cb_copy_line_hint' => 'Använd [+] och [>+] knapparna för att kopiera och klistra in aktörerna i det valda uttrycket',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|underkategori|underkategorier}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|sida|sidor}}',
	'cb_has_files' => '$1 {{PLURAL:$1|fil|filer}}',
	'cb_previous_items_link' => 'Föregående',
	'cb_next_items_link' => 'Nästa',
	'cb_next_items_stats' => '(från $1)',
	'cb_cat_subcats' => 'underkategorier',
	'cb_cat_pages' => 'sidor',
	'cb_cat_files' => 'filer',
	'cb_apply_button' => 'Verkställ',
	'cb_all_op' => 'Alla',
	'cb_or_op' => 'eller',
	'cb_and_op' => 'och',
	'cb_edit_left_hint' => 'Flytta åt vänster, om möjligt',
	'cb_edit_right_hint' => 'Flytta åt höger, om möjligt',
	'cb_edit_remove_hint' => 'Radera, om möjligt',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'cb_previous_items_link' => 'முந்தைய',
	'cb_next_items_link' => 'அடுத்தது',
	'cb_cat_subcats' => 'துணைப் பகுப்புகள்',
	'cb_cat_pages' => 'பக்கங்கள்',
	'cb_cat_files' => 'கோப்புக்கள்',
	'cb_apply_button' => 'பயன்பாட்டிற்கு கொண்டுவா',
	'cb_all_op' => 'அனைத்தும்',
	'cb_or_op' => 'அல்லது',
	'cb_and_op' => 'மற்றும்',
	'cb_edit_left_hint' => 'முடிந்தால் இடது பக்கம் நகர்த்தவும்',
	'cb_edit_right_hint' => 'முடிந்தால் வலது பக்கம் நகர்த்தவும்',
	'cb_edit_remove_hint' => 'முடிந்தால் நீக்கவும்',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'categorybrowser' => 'వర్గ విహారిణి',
	'categorybrowser-desc' => 'ఎక్కువ పేజీలున్న వర్గాలను వడపోసి, AJAX ఇంటరుఫేసు ద్వారా వాటిని శోధించగలిగే [[Special:CategoryBrowser|ప్రత్యేక పేజీ]]ని చూపిస్తుంది',
	'cb_requires_javascript' => 'వర్గశోధిని పొడిగింత పనిచెయ్యాలంటే బ్రౌజరులో JavaScript చేతనమై ఉండాలి.',
	'cb_ie6_warning' => 'కండిషను ఎడిటరు Internet Explorer 6.0, మరియు దాని పూర్వపు వెర్షన్లలో పని చెయ్యదు.
అయితే, పూర్వ నిశ్చిత కండిషన్ల శోధన మామూలుగానే పనిచేస్తాయి.
వీలైతే, మీ బ్రౌజరును మార్చడంగానీ, ఉన్నతీకరించడంగానీ చెయ్యండి.',
	'cb_show_no_parents_only' => 'మాతృవర్గాలు లేని వర్గాలను మాత్రమే చూపించు',
	'cb_cat_name_filter' => 'ఈ పేరుతో ఉన్న వర్గాల కోసం వెతుకు:',
	'cb_cat_name_filter_clear' => 'వర్గం పేరు వడపోతకాన్ని క్లియరు చేసేందుకు నొక్కండి',
	'cb_cat_name_filter_ci' => 'కేస్ ఇన్సెన్సిటివ్',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|ఉపవర్గం|ఉపవర్గాలు}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|పుట|పుటలు}}',
	'cb_has_files' => '$1 {{PLURAL:$1|దస్త్రం|దస్త్రాలు}}',
	'cb_has_parentcategories' => 'మాతృవర్గాలు (ఉంటే)',
	'cb_previous_items_link' => 'గత',
	'cb_next_items_link' => 'తదుపరి',
	'cb_next_items_stats' => ' ($1 నుండి)',
	'cb_cat_subcats' => 'ఉపవర్గాలు',
	'cb_cat_pages' => 'పుటలు',
	'cb_cat_files' => 'దస్త్రాలు',
	'cb_apply_button' => 'ఆపాదించు',
	'cb_all_op' => 'అన్నీ',
	'cb_or_op' => 'లేదా',
	'cb_and_op' => 'మరియు',
	'cb_edit_left_hint' => 'వీలైతే, ఎడమవైపుకు జరుపు',
	'cb_edit_right_hint' => 'వీలైతే, కుడివైపుకు జరుపు',
	'cb_edit_remove_hint' => 'వీలైతే, తొలగించు',
	'cb_edit_copy_hint' => 'ఆపరేటరును క్లిప్పుబోర్డుకు కాపీ చెయ్యి',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'cb_has_pages' => '{{PLURAL:$1|pájina ida|pájina $1}}',
	'cb_cat_pages' => 'pájina sira',
	'cb_all_op' => 'Hotu',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'categorybrowser' => 'Pantingin-tingin ng kategorya',
	'categorybrowser-desc' => 'Nagbibigay ng isang [[Special:CategoryBrowser|natatanging pahina]] upang salain ang pinakamaraming-lamang mga kategorya at upang malibot sila na ginagamitan ng ugnayang-mukhang AJAX',
	'cb_requires_javascript' => 'Ang pandugtong ng pantingin-tingin ng kategorya ay nangangailangan ng JavaScript upang mapagana ito sa pantingin-tingin.',
	'cb_ie6_warning' => 'Ang pamatnugot ng kundisyon ay hindi gumagana sa Internet Explorer 6.0 or mas naunang mga bersyon.
Subalit, ang pagtingin-tingin ng paunang nilarawang mga kundisyon ay dapat na gumana ng normal.
Paki bago o itaas ang antas ng iyong pantingin-tingin, kung maaari.',
	'cb_show_no_parents_only' => 'Ipakita lamang ang mga kategoryang walang mga magulang',
	'cb_cat_name_filter' => 'Maghanap ng mga kategorya ayon sa pangalan:',
	'cb_cat_name_filter_clear' => 'Pindutin upang malinis ang pansala ng pangalan ng kategorya',
	'cb_cat_name_filter_ci' => 'Hindi sensitibo sa uri ng panitik',
	'cb_copy_line_hint' => 'Gamitin ang mga pindutang [+] at [>+] upang kopyahin at idikit ang mga bantas sa napiling mga pagsasaad',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|kabahaging kategorya|kabahaging mga kategorya}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|pahina|mga pahina}}',
	'cb_has_files' => '$1 {{PLURAL:$1|talaksan|mga talaksan}}',
	'cb_has_parentcategories' => 'magulang na mga kategorya (kung mayroon)',
	'cb_previous_items_link' => 'Nakaraan',
	'cb_next_items_link' => 'Kasunod',
	'cb_next_items_stats' => '(mula $1)',
	'cb_cat_subcats' => 'kabahaging mga kategorya',
	'cb_cat_pages' => 'mga pahina',
	'cb_cat_files' => 'mga talaksan',
	'cb_apply_button' => 'Gamitin',
	'cb_all_op' => 'Lahat',
	'cb_or_op' => 'o',
	'cb_and_op' => 'at',
	'cb_edit_left_hint' => 'Ilipat sa kaliwa, kung maaari',
	'cb_edit_right_hint' => 'Ilipat sa kanan, kung maaari',
	'cb_edit_remove_hint' => 'Burahin, kung maaari',
	'cb_edit_copy_hint' => 'Kopyahin ang bantas sa tablang-ipitan',
	'cb_edit_append_hint' => 'Isingit ang bantas sa huling posisyon',
	'cb_edit_clear_hint' => 'Linisin ang pangkasalukuyang pagsasaad (piliing lahat)',
	'cb_edit_paste_hint' => 'Idikit ang bantas sa pangkasalukuyang posisyon, kung maaari',
	'cb_edit_paste_right_hint' => 'Idikit ang bantas sa kasunod na posisyon, kung maaari',
);

/** Turkish (Türkçe)
 * @author CnkALTDS
 * @author Emperyan
 */
$messages['tr'] = array(
	'categorybrowser' => 'Kategori tarayıcısı',
	'cb_cat_name_filter_ci' => 'Büyük küçük harf',
	'cb_has_subcategories' => '{{PLURAL:$1|altkategori|altkategoriler}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|sayfa|sayfalar}}',
	'cb_has_files' => '$1 {{PLURAL:$1|dosya|dosya}}',
	'cb_has_parentcategories' => 'Ana Kategoriler (varsa)',
	'cb_previous_items_link' => 'Önceki',
	'cb_next_items_link' => 'Sonraki',
	'cb_next_items_stats' => '($1)',
	'cb_cat_subcats' => 'Alt Kategoriler',
	'cb_cat_pages' => 'Sayfalar',
	'cb_cat_files' => 'Dosyalar',
	'cb_apply_button' => 'Uygula',
	'cb_all_op' => 'Hepsi',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'cb_previous_items_link' => 'Алдагы',
	'cb_next_items_link' => 'Киләсе',
	'cb_next_items_stats' => ' ( $1 башлап)',
	'cb_cat_subcats' => 'төркемчәләр',
	'cb_cat_pages' => 'битләр',
	'cb_cat_files' => 'файллар',
	'cb_apply_button' => 'Сакларга',
	'cb_all_op' => 'Барысы',
	'cb_or_op' => 'яки',
	'cb_and_op' => 'һәм',
	'cb_edit_left_hint' => 'Мөмкин булса сулга күчерергә',
	'cb_edit_right_hint' => 'Мөмкин булса уңга күчерергә',
	'cb_edit_remove_hint' => 'Мөмкин булса бетерегә',
	'cb_edit_copy_hint' => 'Бирелешне алмаш буферга күчермәләү',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 * @author Тест
 */
$messages['uk'] = array(
	'categorybrowser' => 'Перегляд категорій',
	'categorybrowser-desc' => 'Додає [[Special:CategoryBrowser|спеціальну сторінку]] для відфільтрування найбільш переповнених категорій та керування ними за допомогою інтерфейсу AJAX',
	'cb_requires_javascript' => 'Додаток для перегляду категорій потребує в браузері ввімкнений JavaScript.',
	'cb_ie6_warning' => 'Редактор умов не працює в Internet Explorer 6.0 або в більш ранніх версіях. 
 Однак, переглядаючи попередньо визначені умови, він повинен працювати нормально. 
 Будь ласка, замініть або оновіть ваш браузер, якщо це можливо.',
	'cb_show_no_parents_only' => 'Показати тільки категорії, які не мають батьків',
	'cb_cat_name_filter' => 'Пошук категорії за назвою:',
	'cb_cat_name_filter_clear' => 'Натисніть, щоб видалити назву фільтра категорій',
	'cb_cat_name_filter_ci' => 'Без урахування регістру',
	'cb_copy_line_hint' => 'Використовуйте [+] і [> +] кнопки для копіювання і вставки операторів у вибраний вираз',
	'cb_has_subcategories' => '$1 {{PLURAL:$1|підкатегорія|підкатегорії|підкатегорій}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|сторінка|сторінки|сторінок}}',
	'cb_has_files' => '$1 {{PLURAL:$1|файл|файли|файлів}}',
	'cb_has_parentcategories' => 'батьківські категорії (якщо такі є)',
	'cb_previous_items_link' => 'Попередні',
	'cb_next_items_link' => 'Наступні',
	'cb_next_items_stats' => '(починаючи від $1)',
	'cb_cat_subcats' => 'підкатегорій',
	'cb_cat_pages' => 'сторінок',
	'cb_cat_files' => 'файлів',
	'cb_apply_button' => 'Застосувати',
	'cb_all_op' => 'Усі',
	'cb_or_op' => 'або',
	'cb_and_op' => 'і',
	'cb_edit_left_hint' => 'Переміщення вліво, якщо це можливо',
	'cb_edit_right_hint' => 'Переміщення вправо, якщо це можливо',
	'cb_edit_remove_hint' => 'Видалити, якщо це можливо',
	'cb_edit_copy_hint' => 'Скопіювати оператор в буфер',
	'cb_edit_append_hint' => 'Вставка оператора в останню позицію',
	'cb_edit_clear_hint' => 'Очистити поточний вираз (виділити все)',
	'cb_edit_paste_hint' => 'Вставити оператор у поточну позицію, якщо це можливо',
	'cb_edit_paste_right_hint' => 'Вставити оператора в наступну позицію, якщо це можливо',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'cb_previous_items_link' => 'Edeližed',
	'cb_next_items_link' => "Jäl'geližed",
	'cb_next_items_stats' => ' ($1-späi augotaden)',
	'cb_cat_subcats' => 'alakategorijad',
	'cb_cat_pages' => "lehtpol't",
	'cb_cat_files' => 'failad',
	'cb_apply_button' => 'Kävutada',
	'cb_all_op' => 'Kaik',
	'cb_or_op' => 'vai',
	'cb_and_op' => 'da',
	'cb_edit_left_hint' => 'Sirta hurale, ku voib',
	'cb_edit_right_hint' => 'Sirta oiktale, ku voib',
	'cb_edit_remove_hint' => 'Čuta poiš, ku voib',
	'cb_edit_copy_hint' => 'Kopiruida operator vajehtamižbuferha',
	'cb_edit_append_hint' => "Panda operator jäl'gmäižhe pozicijaha",
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'categorybrowser' => 'קאַטעגאָריע בלעטערער',
	'cb_requires_javascript' => 'דער קאטעגאריע בלעטערער דארף JavaScript צו ווערן אקטיווירט אין דעם בלעטערער.',
	'cb_cat_name_filter' => 'זוכן א קאַטעגאָריע לויטן נאָמען:',
	'cb_has_subcategories' => '{{PLURAL:$1|אונטערקאטעגאריע|$1 אונטערקאטעגאריעס}}',
	'cb_has_pages' => '$1 {{PLURAL:$1|בלאַט|בלעטער}}',
	'cb_has_files' => '$1 {{PLURAL:$1|טעקע|טעקעס}}',
	'cb_has_parentcategories' => 'אויבער קאטעגאריעס (ווען פאראן)',
	'cb_previous_items_link' => 'פֿריערדיקער',
	'cb_next_items_link' => 'נעקסט',
	'cb_next_items_stats' => '(פֿון $1 )',
	'cb_cat_subcats' => 'אונטערקאַטעגאָריעס',
	'cb_cat_pages' => 'בלעטער',
	'cb_cat_files' => 'טעקעס',
	'cb_apply_button' => 'אָנווענדן',
	'cb_all_op' => 'אַלע',
	'cb_or_op' => 'אָדער',
	'cb_and_op' => 'און',
	'cb_edit_left_hint' => 'באַוועגן לינקס, ווען מעגלעך',
	'cb_edit_right_hint' => 'באַוועגן רעכטס, ווען מעגלעך',
	'cb_edit_remove_hint' => 'אויסמעקן, ווען מעגלעך',
	'cb_edit_append_hint' => 'ארײַנלייגן אָפּעראַטאָר אין דער לעצטע פאזיציע',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Xiaomingyan
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'categorybrowser' => '类别浏览器',
	'categorybrowser-desc' => '提供了[[Special:CategoryBrowser|特殊页面]]以筛选最受欢迎的类别，并使用AJAX界面浏览。',
	'cb_requires_javascript' => '类别浏览器扩展需要在浏览器中启用的 JavaScript。',
	'cb_ie6_warning' => '条件编辑器无法在Internet Explorer 6.0 或更早版本上正常工作。
然而，浏览预定义的条件应当正常。
如有可能请更换或升级您的浏览器。',
	'cb_show_no_parents_only' => '仅显示没有上级的类别',
	'cb_cat_name_filter' => '按名称搜索类别：',
	'cb_cat_name_filter_clear' => '按此清除类别名称筛选器',
	'cb_cat_name_filter_ci' => '区分大小写',
	'cb_copy_line_hint' => '使用[+]和[>+] 按钮，复制并粘贴运算符到选定的表达式中。',
	'cb_has_subcategories' => '$1个 {{PLURAL:$1|subcategory|subcategories}}',
	'cb_has_pages' => '$1个页面',
	'cb_has_files' => '$1个 {{PLURAL:$1|file|files}}',
	'cb_has_parentcategories' => '上级类别(如果存在)',
	'cb_previous_items_link' => '上一页',
	'cb_next_items_link' => '下一页',
	'cb_next_items_stats' => '(自 $1)',
	'cb_cat_subcats' => '子类别',
	'cb_cat_pages' => '页',
	'cb_cat_files' => '文件',
	'cb_apply_button' => '应用',
	'cb_all_op' => '全部',
	'cb_or_op' => '或',
	'cb_and_op' => '和',
	'cb_edit_left_hint' => '如有可能移至左侧',
	'cb_edit_right_hint' => '如有可能移至右侧',
	'cb_edit_remove_hint' => '如果可能则删除',
	'cb_edit_copy_hint' => '复制运算符到剪贴板',
	'cb_edit_append_hint' => '在最后一个位置插入运算符',
	'cb_edit_clear_hint' => '清除当前表达式 (选择全部)',
	'cb_edit_paste_hint' => '如有可能，将运算符粘贴到当前的位置',
	'cb_edit_paste_right_hint' => '如有可能，将运算符粘贴到下一个位置',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'categorybrowser' => '類別瀏覽器',
	'categorybrowser-desc' => '提供了[[Special:CategoryBrowser|特殊頁面]]以篩選最受歡迎的類別，並使用AJAX界面瀏覽。',
	'cb_requires_javascript' => '類別瀏覽器擴展需要在瀏覽器中啟用的 JavaScript。',
	'cb_ie6_warning' => '條件編輯器無法在Internet Explorer 6.0 或更早版本上正常工作。
然而，瀏覽預定義的條件應當正常。
如有可能請更換或升級您的瀏覽器。',
	'cb_show_no_parents_only' => '僅顯示沒有上級的類別',
	'cb_cat_name_filter' => '按名稱搜索類別：',
	'cb_cat_name_filter_clear' => '按此清除類別名稱篩選器',
	'cb_cat_name_filter_ci' => '區分大小寫',
	'cb_copy_line_hint' => '使用[+]和[>+] 按鈕，複製並粘貼運算符到選定的表達式中。',
	'cb_has_subcategories' => '$1個 {{PLURAL:$1|subcategory|subcategories}}',
	'cb_has_pages' => '$1個頁面',
	'cb_has_files' => '$1個 {{PLURAL:$1|file|files}}',
	'cb_has_parentcategories' => '上級類別(如果存在)',
	'cb_previous_items_link' => '上一頁',
	'cb_next_items_link' => '下一頁',
	'cb_next_items_stats' => '(自 $1)',
	'cb_cat_subcats' => '子類別',
	'cb_cat_pages' => '頁',
	'cb_cat_files' => '文件',
	'cb_apply_button' => '應用',
	'cb_all_op' => '全部',
	'cb_or_op' => '或',
	'cb_and_op' => '和',
	'cb_edit_left_hint' => '如有可能移至左側',
	'cb_edit_right_hint' => '如有可能移至右側',
	'cb_edit_remove_hint' => '如果可能則刪除',
	'cb_edit_copy_hint' => '複製運算符到剪貼板',
	'cb_edit_append_hint' => '在最後一個位置插入運算符',
	'cb_edit_clear_hint' => '清除當前表達式 (選擇全部)',
	'cb_edit_paste_hint' => '如有可能，將運算符粘貼到當前的位置',
	'cb_edit_paste_right_hint' => '如有可能，將運算符粘貼到下一個位置',
);

