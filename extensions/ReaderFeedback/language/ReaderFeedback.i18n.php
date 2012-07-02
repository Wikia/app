<?php
/**
 * Internationalisation file for extension ReaderFeedback (group ReaderFeedback).
 *
 * @file
 * @comment NOTE: SOME LINKS HAVE '[' and ']' around them. These are NOT typos.
 * @comment PLEASE DO NOT RANDOMLY REMOVE THEM FOR THE THIRD TIME, kthx. -aaron
 * @ingroup Extensions
 */

$messages = array();

/** English (en)
 * @author Purodha
 * @author Raimond Spekking
 * @author Siebrand
 */

$messages['en'] = array(
	'readerfeedback-desc'          => 'Page validation allows for readers to give feedback in the form of categorical ratings',
	'readerfeedback'               => 'What do you think of this page?',
	'readerfeedback-text'          => '\'\'Please take a moment to rate this page below. Your feedback is valuable and helps us improve our website.\'\'',
	'readerfeedback-reliability'   => 'Reliability',
	'readerfeedback-completeness'  => 'Completeness',
	'readerfeedback-npov'          => 'Neutrality',
	'readerfeedback-presentation'  => 'Presentation',
	'readerfeedback-overall'       => 'Overall',
	'readerfeedback-level-none'    => '(unsure)',
	'readerfeedback-level-0'       => 'Poor',
	'readerfeedback-level-1'       => 'Low',
	'readerfeedback-level-2'       => 'Fair',
	'readerfeedback-level-3'       => 'High',
	'readerfeedback-level-4'       => 'Excellent',
	'readerfeedback-submit'        => 'Submit',
	'readerfeedback-main'          => 'Only content pages can be rated.',
	'readerfeedback-success'       => '\'\'\'Thank you for reviewing this page!\'\'\' ([$2 see results]) ([$3 comments or questions?]).',
	'readerfeedback-voted'         => '\'\'\'It appears that you already rated this page\'\'\' ([$2 see results]) ([$3 comments or questions?]).',
	'readerfeedback-error'         => '\'\'\'An error has occurred while rating this page\'\'\' ([$2 see results]) ([$3 comments or questions?]).',
	'readerfeedback-submitting'    => 'Submitting …',
	'readerfeedback-finished'      => 'Thank you!',
	'readerfeedback-tagfilter'     => 'Tag:',
	'readerfeedback-tierfilter'    => 'Rating:',
	'readerfeedback-tier-high'     => 'High',
	'readerfeedback-tier-medium'   => 'Moderate',
	'readerfeedback-tier-poor'     => 'Poor',
	'tooltip-ca-ratinghist'        => 'Reader ratings of this page',
	'specialpages-group-feedback'  => 'Viewer opinion',
	'readerfeedback-ak-review'     => 'b', 
	'readerfeedback-tt-review'     => 'Submit review',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author Dani
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Hamilton Abreu
 * @author Huji
 * @author Jon Harald Søby
 * @author Meno25
 * @author Mormegil
 * @author Purodha
 * @author Raymond
 * @author Rex
 * @author SPQRobin
 * @author Siebrand
 * @author Tgr
 */
$messages['qqq'] = array(
	'readerfeedback-desc' => '{{desc}}',
	'readerfeedback-level-0' => 'Must be consistent with:
*{{msg-mw|ratinghistory-ratings}}
*{{msg-mw|ratinghistory-legend}}',
	'readerfeedback-level-1' => 'Must be consistent with:
*{{msg-mw|ratinghistory-ratings}}
*{{msg-mw|ratinghistory-legend}}',
	'readerfeedback-level-2' => 'Must be consistent with:
*{{msg-mw|ratinghistory-ratings}}
*{{msg-mw|ratinghistory-legend}}',
	'readerfeedback-level-3' => 'Must be consistent with:
*{{msg-mw|ratinghistory-ratings}}
*{{msg-mw|ratinghistory-legend}}',
	'readerfeedback-level-4' => 'Must be consistent with:
*{{msg-mw|ratinghistory-ratings}}
*{{msg-mw|ratinghistory-legend}}',
	'readerfeedback-submit' => '{{Identical|Submit}}',
	'readerfeedback-main' => '{{Identical|Content page}}',
	'readerfeedback-submitting' => '{{flaggedrevs}}
{{identical|submitting}}',
	'readerfeedback-tagfilter' => '{{Identical|Tag}}',
	'readerfeedback-tierfilter' => '{{Identical|Rating}}',
	'readerfeedback-tt-review' => 'Pop-up text for the submit button (captioned with {{msg-mw|readerfeedback-submit}}) on review form',
);

/** толышә зывон (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'readerfeedback-submit' => 'Вығәндеј',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'readerfeedback-desc' => 'Die validering van bladsye maak dit vir lesers moontlik om terugvoer te gee in die vorm van kategoriese beoordelings',
	'readerfeedback' => 'Wat dink u van hierdie bladsy?',
	'readerfeedback-text' => "''Neem asseblief 'n oomblik om die bladsy hieronder te waardeer. 
U terugvoer is waardevol en help ons om ons webwerf te verbeter.''",
	'readerfeedback-reliability' => 'Betroubaarheid',
	'readerfeedback-completeness' => 'Volledigheid',
	'readerfeedback-npov' => 'Neutraliteit',
	'readerfeedback-presentation' => 'Voorstelling',
	'readerfeedback-overall' => 'Algeheel',
	'readerfeedback-level-none' => '(onseker)',
	'readerfeedback-level-0' => 'Swak',
	'readerfeedback-level-1' => 'Laag',
	'readerfeedback-level-2' => 'In orde',
	'readerfeedback-level-3' => 'Hoog',
	'readerfeedback-level-4' => 'Uitstekend',
	'readerfeedback-submit' => 'Dien in',
	'readerfeedback-main' => 'Slegs inhoudelike bladsye kan gegradeer word.',
	'readerfeedback-success' => "Dankie vir u waardering van hierdie bladsy!''' ([$2 sien resultate]) ([$3 kommentaar of vrae?]).",
	'readerfeedback-voted' => "'''U het reeds 'n waardering van die bladsy gemaak''' ([$2 sien resultate]) ([$3 kommentaar of vrae?]).",
	'readerfeedback-error' => "''''n Fout het voorgekom met die beoordeling van hierdie bladsy''' ([$2 resultate]) ([$3 opmerkings of vrae?])",
	'readerfeedback-submitting' => 'Besig om in te dien…',
	'readerfeedback-finished' => 'Baie dankie!',
	'readerfeedback-tagfilter' => 'Etiket:',
	'readerfeedback-tierfilter' => 'Gradering:',
	'readerfeedback-tier-high' => 'Hoog',
	'readerfeedback-tier-medium' => 'Gemiddeld',
	'readerfeedback-tier-poor' => 'Laag',
	'tooltip-ca-ratinghist' => 'Lesers se graderings van hierdie bladsy',
	'specialpages-group-feedback' => 'Mening van die leser',
	'readerfeedback-tt-review' => 'Dien beoordeling in',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'readerfeedback-submit' => 'Ninviar',
);

/** Arabic (العربية)
 * @author Antime
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 * @author Prof.Sherif
 */
$messages['ar'] = array(
	'readerfeedback-desc' => 'تحقيق الصفحة يسمح للقراء بإعطاء تعليقات في صورة تقييمات تصنيفية',
	'readerfeedback' => 'ماذا تظن بهذه الصفحة؟',
	'readerfeedback-text' => "''من فضلك دقيقة لتقييم هذه الصفحة بالأسفل. تعليقك قيم ويساعدنا في تحسين موقعنا.''",
	'readerfeedback-reliability' => 'الاعتمادية',
	'readerfeedback-completeness' => 'الاكتمال',
	'readerfeedback-npov' => 'الحيادية',
	'readerfeedback-presentation' => 'التقديم',
	'readerfeedback-overall' => 'إجمالي',
	'readerfeedback-level-none' => '(غير متأكد)',
	'readerfeedback-level-0' => 'فقير',
	'readerfeedback-level-1' => 'منخفض',
	'readerfeedback-level-2' => 'معقول',
	'readerfeedback-level-3' => 'عالي',
	'readerfeedback-level-4' => 'ممتاز',
	'readerfeedback-submit' => 'أرسل',
	'readerfeedback-main' => 'فقط صفحات المحتوى يمكن تقييمها.',
	'readerfeedback-success' => "'''شكرا لك على مراجعة هذه الصفحة!''' ([$2 شاهد النتيجة]) ([$3 تعليقات أو أسئلة؟]).",
	'readerfeedback-voted' => "'''يبدو أنك قيمت هذه الصفحة بالفعل''' ([$2 انظر النتائج]) ([$3 تعليقات أو أسئلة؟]).",
	'readerfeedback-error' => "'''حدث خطأ أثناء تقييم هذه الصفحة''' ([$2 انظر النتائج]) ([$3 تعليقات او أسئلة؟]).",
	'readerfeedback-submitting' => 'يرسل...',
	'readerfeedback-finished' => 'شكرا لك!',
	'readerfeedback-tagfilter' => 'وسم:',
	'readerfeedback-tierfilter' => 'التقييم:',
	'readerfeedback-tier-high' => 'مرتفع',
	'readerfeedback-tier-medium' => 'متوسط',
	'readerfeedback-tier-poor' => 'فقير',
	'tooltip-ca-ratinghist' => 'تقييمات القراء لهذه الصفحة',
	'specialpages-group-feedback' => 'رأي المشاهد',
	'readerfeedback-tt-review' => 'أرسل مراجعة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 * @author Michaelovic
 */
$messages['arc'] = array(
	'readerfeedback-finished' => 'ܬܘܕܝ!',
	'readerfeedback-tier-high' => 'ܛܒܐ',
	'readerfeedback-tier-medium' => 'ܡܨܥܝܐ',
	'readerfeedback-tier-poor' => 'ܡܚܝܠܐ',
	'readerfeedback-tt-review' => 'ܫܕܪ ܬܢܝܬܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'readerfeedback' => 'ماذا تظن بهذه الصفحة؟',
	'readerfeedback-text' => "''من فضلك دقيقة لتقييم هذه الصفحة بالأسفل. تعليقك قيم ويساعدنا فى تحسين موقعنا.''",
	'readerfeedback-reliability' => 'الاعتمادية',
	'readerfeedback-completeness' => 'الاكتمال',
	'readerfeedback-npov' => 'الحيادية',
	'readerfeedback-presentation' => 'التقديم',
	'readerfeedback-overall' => 'إجمالى',
	'readerfeedback-level-none' => '(مش متأكد)',
	'readerfeedback-level-0' => 'فقير',
	'readerfeedback-level-1' => 'منخفض',
	'readerfeedback-level-2' => 'معقول',
	'readerfeedback-level-3' => 'عالى',
	'readerfeedback-level-4' => 'ممتاز',
	'readerfeedback-submit' => 'تنفيذ',
	'readerfeedback-main' => 'فقط صفحات المحتوى يمكن تقييمها.',
	'readerfeedback-success' => "'''شكرا لك على مراجعة هذه الصفحة!''' ([$2 شاهد النتيجة]) ([$3 تعليقات أو أسئلة؟]).",
	'readerfeedback-voted' => "'''يبدو أنك قيمت هذه الصفحة بالفعل''' ([$2 انظر النتائج]) ([$3 تعليقات أو أسئلة؟]).",
	'readerfeedback-submitting' => 'جارى التنفيذ...',
	'readerfeedback-finished' => 'شكرا لك!',
	'tooltip-ca-ratinghist' => 'تقييمات القراء لهذه الصفحة',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'readerfeedback' => "¿Qué camientes d'esta páxina?",
	'readerfeedback-reliability' => 'Fiabilidá',
	'readerfeedback-npov' => 'Neutralidá',
	'readerfeedback-presentation' => 'Presentación',
	'readerfeedback-main' => 'Namái se puen calificar les páxines de conteníu.',
	'readerfeedback-finished' => '¡Gracies!',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Wertuose
 */
$messages['az'] = array(
	'readerfeedback-level-3' => 'Yüksək',
	'readerfeedback-submit' => 'Təsdiq et',
	'readerfeedback-finished' => 'Təşəkkür!',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'readerfeedback-desc' => 'Биттәрҙе тикшереү уҡыусыларға категориялар буйынса баһалауҙар рәүешендә баһаламалар ебәрергә мөмкинлек бирә',
	'readerfeedback' => 'Һеҙ был бит тураһында нимә уйлайһығыҙ?',
	'readerfeedback-text' => "''Зинһар, түбәндәге битте баһалау өсөн бер аҙ ваҡытығыҙҙы бүлегеҙ. Һеҙҙең баһаламағыҙ бик мөһим һәм беҙгә сайтыбыҙҙы яҡшыртырға ярҙам итә.''",
	'readerfeedback-reliability' => 'Дөрөҫлөк',
	'readerfeedback-completeness' => 'Тулылыҡ',
	'readerfeedback-npov' => 'Битарафлыҡ',
	'readerfeedback-presentation' => 'Бәйән итеү',
	'readerfeedback-overall' => 'Дөйөм баһа',
	'readerfeedback-level-none' => '(һайланмаған)',
	'readerfeedback-level-0' => 'Насар',
	'readerfeedback-level-1' => 'Түбән',
	'readerfeedback-level-2' => 'Уртаса',
	'readerfeedback-level-3' => 'Яҡшы',
	'readerfeedback-level-4' => 'Бик шәп',
	'readerfeedback-submit' => 'Ебәрергә',
	'readerfeedback-main' => 'Тик эстәлекле биттәр генә баһалана ала.',
	'readerfeedback-success' => "'''Был битте баһалауығыҙ өсөн рәхмәт!''' ([$2 һөҙөмтәләрҙе ҡарарға]) ([$3 иҫкәрмәләрегеҙ йәки һорауҙарығыҙ бармы?]).",
	'readerfeedback-voted' => "'''Һеҙ был битте баһалағанһығыҙ инде, буғай''' ([$2 һөҙөмтәләрҙе ҡарарға]) ([$3 иҫкәрмәләрегеҙ йәки һорауҙарығыҙ бармы?]).",
	'readerfeedback-error' => "'''Был битте баһалау ваҡытында хата килеп сыҡты''' ([$2 һөҙөмтәләрҙе ҡарарға]) ([$3 иҫкәрмәләрегеҙ йәки һорауҙарығыҙ бармы?]).",
	'readerfeedback-submitting' => 'Ебәреү...',
	'readerfeedback-finished' => 'Рәхмәт!',
	'readerfeedback-tagfilter' => 'Билдә:',
	'readerfeedback-tierfilter' => 'Баһа:',
	'readerfeedback-tier-high' => 'Юғары',
	'readerfeedback-tier-medium' => 'Уртаса',
	'readerfeedback-tier-poor' => 'Түбән',
	'tooltip-ca-ratinghist' => 'Уҡыусыларҙың бsл биткә баһаһы',
	'specialpages-group-feedback' => 'Уҡыусылар фекере',
	'readerfeedback-tt-review' => 'Тикшереүҙе ебәрергә',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'readerfeedback' => 'نظرات وانوکان',
	'readerfeedback-text' => "''لطفا کمی وهد بلیت و ای صفحهء درجه بندی کنیت. شمی نظرات ارزشمنت و په شربوتن می وبسایت ماراء کمک کننت.''",
	'readerfeedback-reliability' => 'اعتبار',
	'readerfeedback-completeness' => 'کامل بوتن',
	'readerfeedback-npov' => 'بی طرفی',
	'readerfeedback-presentation' => 'ارايه',
	'readerfeedback-overall' => 'درکل',
	'readerfeedback-level-0' => 'ضعیف',
	'readerfeedback-level-1' => 'کم',
	'readerfeedback-level-2' => 'قابل قبول',
	'readerfeedback-level-3' => 'بالاد',
	'readerfeedback-level-4' => 'عالی',
	'readerfeedback-submit' => 'دیم دی',
	'readerfeedback-main' => 'فقط صفحات محتوا توننت بازبینی بنت.',
	'tooltip-ca-ratinghist' => 'درجات وانوکان ای صفحه',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'readerfeedback-desc' => 'Праверка старонак дазваляе чытачам даваць водгукі ў форме безумоўных адзнакаў',
	'readerfeedback' => 'Што Вы мяркуеце пра гэтую старонку?',
	'readerfeedback-text' => "''Калі ласка, знайдзіце хвіліну для адзнакі гэтай старонкі. Вашы водгукі вельмі каштоўныя і дапамагаюць паляпшаць {{GRAMMAR:вінавальны|{{SITENAME}}}}.''",
	'readerfeedback-reliability' => 'Пэўнасьць',
	'readerfeedback-completeness' => 'Напоўненасьць',
	'readerfeedback-npov' => 'Нэўтральнасьць',
	'readerfeedback-presentation' => 'Чытальнасьць',
	'readerfeedback-overall' => 'Агульная адзнака',
	'readerfeedback-level-none' => '(ня ведаю)',
	'readerfeedback-level-0' => 'Благая',
	'readerfeedback-level-1' => 'Нізкая',
	'readerfeedback-level-2' => 'Сярэдняя',
	'readerfeedback-level-3' => 'Высокая',
	'readerfeedback-level-4' => 'Выдатная',
	'readerfeedback-submit' => 'Адзначыць',
	'readerfeedback-main' => 'Адзначацца могуць толькі старонкі са зьместам.',
	'readerfeedback-success' => "'''Дзякуем за адзнаку гэтай старонкі!'''  ([$2 глядзіце вынікі]) ([$3 Камэнтары альбо пытаньні?]).",
	'readerfeedback-voted' => "'''Верагодна, Вы ўжо адзначалі гэтую старонку''' ([$2 глядзіце вынікі]) ([$3 Камэнтары альбо пытаньні?]).",
	'readerfeedback-error' => "'''Адбылася памылка пад час адзнакі гэтай старонкі''' ([$2 глядзіце вынікі]) ([$3 камэнтары альбо пытаньні?]).",
	'readerfeedback-submitting' => 'Адпраўка…',
	'readerfeedback-finished' => 'Дзякуем!',
	'readerfeedback-tagfilter' => 'Метка:',
	'readerfeedback-tierfilter' => 'Адзнака:',
	'readerfeedback-tier-high' => 'Высокая',
	'readerfeedback-tier-medium' => 'Сярэдняя',
	'readerfeedback-tier-poor' => 'Нізкая',
	'tooltip-ca-ratinghist' => 'Адзнакі гэтай старонкі чытачамі',
	'specialpages-group-feedback' => 'Меркаваньні чытачоў',
	'readerfeedback-tt-review' => 'Даслаць водгук',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'readerfeedback' => 'Какво мислите за тази страница?',
	'readerfeedback-text' => "''Моля, отделете малко време, за да оцените страницата по-долу. Вашето мнение е ценно и ни помага за подобряването на сайта.''",
	'readerfeedback-reliability' => 'Оценка за достоверност',
	'readerfeedback-completeness' => 'Оценка за изчерпателност',
	'readerfeedback-npov' => 'Оценка за неутралност',
	'readerfeedback-presentation' => 'Оценка за изказ и стил',
	'readerfeedback-overall' => 'Обща оценка',
	'readerfeedback-level-none' => '(неопределено)',
	'readerfeedback-level-0' => 'Много ниска',
	'readerfeedback-level-1' => 'Ниска',
	'readerfeedback-level-2' => 'Средна',
	'readerfeedback-level-3' => 'Висока',
	'readerfeedback-level-4' => 'Отлична',
	'readerfeedback-submit' => 'Изпращане',
	'readerfeedback-main' => 'Могат да бъдат оценямани само страници със съдържание.',
	'readerfeedback-voted' => "'''Изглежда вече сте оценили тази страница''' ([$2 преглед на резултатите]) ([$3 коментари или въпроси?]).",
	'readerfeedback-error' => "'''Имаше грешка при оценяването на тази страница''' ([$2 преглед на резултатите]) ([$3 коментари или въпроси?]).",
	'readerfeedback-submitting' => 'Изпращане...',
	'readerfeedback-finished' => 'Благодарим ви!',
	'readerfeedback-tagfilter' => 'Етикет:',
	'readerfeedback-tierfilter' => 'Оценка:',
	'readerfeedback-tier-high' => 'Висока',
	'readerfeedback-tier-medium' => 'Средна',
	'readerfeedback-tier-poor' => 'Ниска',
	'tooltip-ca-ratinghist' => 'Читателска оценка на страницата',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'readerfeedback' => 'এই পাতা সম্পর্কে আপনি কি ভাবছেন?',
	'readerfeedback-reliability' => 'নির্ভরযোগ্যতা',
	'readerfeedback-completeness' => 'সম্পূর্ণতা',
	'readerfeedback-npov' => 'নিরপেক্ষতা',
	'readerfeedback-presentation' => 'উপস্থাপনা',
	'readerfeedback-overall' => 'সার্বিকভাবে',
	'readerfeedback-level-0' => 'খারাপ',
	'readerfeedback-level-1' => 'ভাল নয়',
	'readerfeedback-level-2' => 'মোটামোটি',
	'readerfeedback-level-3' => 'ভাল',
	'readerfeedback-level-4' => 'খুবই ভাল',
	'readerfeedback-submit' => 'জমা দাও',
	'readerfeedback-submitting' => 'জমা হচ্ছে …',
	'readerfeedback-finished' => 'ধন্যবাদ!',
	'readerfeedback-tagfilter' => 'ট্যাগ:',
	'readerfeedback-tierfilter' => 'রেটিং:',
	'readerfeedback-tier-high' => 'ভাল',
	'readerfeedback-tier-medium' => 'মোটামোটি',
	'readerfeedback-tier-poor' => 'খারাপ',
	'specialpages-group-feedback' => 'দর্শকের মতামত',
	'readerfeedback-tt-review' => 'পর্যালোচনা জমা দিন',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 */
$messages['br'] = array(
	'readerfeedback-desc' => "Kadarnaat ar pennadoù a ro an tu d'al lennerien da reiñ o soñj e stumm burutelladennoù dre rummad.",
	'readerfeedback' => 'Petra a soñjit eus ar bajenn-mañ ?',
	'readerfeedback-text' => "''Tapit un tamm amzer da briziañ ar bajenn a-is mar plij. Talvoudus eo deomp ho soñj pa skoazell ac'hanomp da wellaat hol lec'hienn web.''",
	'readerfeedback-reliability' => 'Fiziuster :',
	'readerfeedback-completeness' => 'Klokter :',
	'readerfeedback-npov' => 'Neptuegezh :',
	'readerfeedback-presentation' => 'Kinnig',
	'readerfeedback-overall' => 'Dre-vras',
	'readerfeedback-level-none' => '(diasur)',
	'readerfeedback-level-0' => 'Dister-kenañ',
	'readerfeedback-level-1' => 'Gwan',
	'readerfeedback-level-2' => 'Etre',
	'readerfeedback-level-3' => 'Mat',
	'readerfeedback-level-4' => 'Eus an dibab',
	'readerfeedback-submit' => 'Kas',
	'readerfeedback-main' => "N'haller priziañ nemet ar pajennoù zo danvez enno",
	'readerfeedback-success' => "'''Ho trugarekaat evit bezañ adlennet ar bajenn-mañ !''' ([$2 gwelet an disoc'hoù]) ([$3 goulennoù pe ur soñj bennak ?]).",
	'readerfeedback-voted' => "'''Evit doare eo bet priziet ar bajenn-mañ ganeoc'h c'hoazh''' ([$2 gwelet an disoc'hoù]) ([$3 goulennoù pe ur soñj bennak?])",
	'readerfeedback-error' => "'''Ur fazi zo bet en ur briziañ ar bajenn-mañ''' ([$2 gwelet an disoc'hoù]) ([$3 notennoù pe goulennoù ?]).",
	'readerfeedback-submitting' => 'O kas...',
	'readerfeedback-finished' => 'Trugarez !',
	'readerfeedback-tagfilter' => 'Balizenn :',
	'readerfeedback-tierfilter' => 'Priziadenn :',
	'readerfeedback-tier-high' => 'Uhel',
	'readerfeedback-tier-medium' => 'Etre',
	'readerfeedback-tier-poor' => 'Dister',
	'tooltip-ca-ratinghist' => 'Priziadenn ar bajenn-mañ gant al lennerien',
	'specialpages-group-feedback' => 'Soñj al lenner',
	'readerfeedback-tt-review' => 'Kas an adweladenn',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'readerfeedback-desc' => 'Ocjenjivanje stranica omogućuje čitaocima da ostave povratne informacije u obliku kategorisanih rejtinga',
	'readerfeedback' => 'Šta mislite o ovoj stranici?',
	'readerfeedback-text' => "''Molimo odvojite trenutak vremena i ocijenite stranicu ispod. Vaša povratna informacija je korisna i pomaže nam da poboljšamo našu web stranicu.''",
	'readerfeedback-reliability' => 'Pouzdanost',
	'readerfeedback-completeness' => 'Cjelovitost',
	'readerfeedback-npov' => 'Neutralnost',
	'readerfeedback-presentation' => 'Prezentacija',
	'readerfeedback-overall' => 'Sveukupno',
	'readerfeedback-level-none' => '(neodlučen)',
	'readerfeedback-level-0' => 'Slabo',
	'readerfeedback-level-1' => 'Nizak',
	'readerfeedback-level-2' => 'Dobro',
	'readerfeedback-level-3' => 'Visok',
	'readerfeedback-level-4' => 'Odlično',
	'readerfeedback-submit' => 'Pošalji',
	'readerfeedback-main' => 'Može se ocijeniti samo sadržaj stranice.',
	'readerfeedback-success' => "'''Hvala Vam za ocijenjivanje ove stranice!''' ([$2 pogledajte rezultate]) ([$3 Komentari ili pitanja?]).",
	'readerfeedback-voted' => "'''Izgleda da ste već ocijenili ovu stranicu''' ([$2 pogledajte rezultate]) ([$3 Komentari ili pitanja?]).",
	'readerfeedback-error' => "'''Desila se greška pri rejtingu ove stranice''' ([$2 pogledajte rezultate]) ([$3 komentari ili pitanja?]).",
	'readerfeedback-submitting' => 'Šaljem …',
	'readerfeedback-finished' => 'Hvala Vam!',
	'readerfeedback-tagfilter' => 'Oznaka:',
	'readerfeedback-tierfilter' => 'Rejting:',
	'readerfeedback-tier-high' => 'Visok',
	'readerfeedback-tier-medium' => 'Umjeren',
	'readerfeedback-tier-poor' => 'Slab',
	'tooltip-ca-ratinghist' => 'Ocjene čitaoca ove stranice',
	'specialpages-group-feedback' => 'Mišljenje čitaoca',
	'readerfeedback-tt-review' => 'Pošalji pregled',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author Juanpabl
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Toniher
 */
$messages['ca'] = array(
	'readerfeedback' => "Què en penseu d'aquesta pàgina?",
	'readerfeedback-reliability' => 'Fiabilitat',
	'readerfeedback-completeness' => 'Completesa',
	'readerfeedback-npov' => 'Neutralitat',
	'readerfeedback-presentation' => 'Presentació',
	'readerfeedback-overall' => 'Global',
	'readerfeedback-level-none' => '(insegur)',
	'readerfeedback-level-0' => 'Pobre',
	'readerfeedback-level-1' => 'Baix',
	'readerfeedback-level-2' => 'Just',
	'readerfeedback-level-3' => 'Alt',
	'readerfeedback-level-4' => 'Exceŀlent',
	'readerfeedback-submit' => 'Tramet',
	'readerfeedback-finished' => 'Gràcies!',
	'readerfeedback-tagfilter' => 'Etiqueta:',
	'readerfeedback-tierfilter' => 'Valoració:',
	'readerfeedback-tier-high' => 'Alta',
	'readerfeedback-tier-medium' => 'Moderada',
	'readerfeedback-tier-poor' => 'Pobre',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'readerfeedback-submit' => 'ناردن',
);

/** Czech (Česky)
 * @author Beren
 * @author Danny B.
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'readerfeedback-desc' => 'Hodnocení stránek umožňuje čtenářům reagovat formou bodování v kategoriích',
	'readerfeedback' => 'Co si myslíte o této stránce?',
	'readerfeedback-text' => "''Věnujte prosím chvilku ohodnocení této stránky. Vaše názory jsou pro nás cenné a pomohou nám vylepšit tento web.''",
	'readerfeedback-reliability' => 'Hodnověrnost',
	'readerfeedback-completeness' => 'Úplnost',
	'readerfeedback-npov' => 'Nezaujatost',
	'readerfeedback-presentation' => 'Podání',
	'readerfeedback-overall' => 'Souhrnné hodnocení',
	'readerfeedback-level-none' => '(nevím)',
	'readerfeedback-level-0' => 'slabé',
	'readerfeedback-level-1' => 'nízké',
	'readerfeedback-level-2' => 'dobré',
	'readerfeedback-level-3' => 'vysoké',
	'readerfeedback-level-4' => 'vynikající',
	'readerfeedback-submit' => 'Odeslat',
	'readerfeedback-main' => 'Hodnotit lze pouze stránky s obsahem.',
	'readerfeedback-success' => "'''Děkujeme za posouzení této stránky!''' ([$2 Zobrazit výsledky.]) ([$3 Máte komentář nebo otázku?])",
	'readerfeedback-voted' => "'''Zřejmě jste již tuto stránku {{GENDER:|hodnotil|hodnotila|hodnotili}}.''' ([$2 Zobrazit výsledky.]) ([$3 Máte komentář nebo otázku?])",
	'readerfeedback-error' => "'''Při hodnocení této stránky došlo k chybě.''' ([$2 Zobrazit výsledky.]) ([$3 Máte komentář nebo otázku?])",
	'readerfeedback-submitting' => 'Odesílá se...',
	'readerfeedback-finished' => 'Děkujeme!',
	'readerfeedback-tagfilter' => 'Kritérium:',
	'readerfeedback-tierfilter' => 'Hodnocení:',
	'readerfeedback-tier-high' => 'Vysoké',
	'readerfeedback-tier-medium' => 'Střední',
	'readerfeedback-tier-poor' => 'Nízké',
	'tooltip-ca-ratinghist' => 'Hodnocení této stránky čtenáři',
	'specialpages-group-feedback' => 'Názory čtenářů',
	'readerfeedback-tt-review' => 'Odeslat hodnocení',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Emilkris33
 * @author Peter Alberti
 */
$messages['da'] = array(
	'readerfeedback-desc' => 'Sidebedømmelse giver mulighed for læserne til at gve tilbagemeldinger i form af bedømmelse inden for et antal kategprier',
	'readerfeedback' => 'Hvad synes du om denne side?',
	'readerfeedback-text' => "''Brug gerne et øjeblik til at vurdere denne side nedenfor. Din tilbagemelding er værdifuld og hjælper os med at forbedre vores websider.''",
	'readerfeedback-reliability' => 'Pålidelighed',
	'readerfeedback-completeness' => 'Fuldstændighed',
	'readerfeedback-npov' => 'Neutralitet',
	'readerfeedback-presentation' => 'Præsentation',
	'readerfeedback-overall' => 'Helhedsindtryk',
	'readerfeedback-level-none' => '(ved ikke)',
	'readerfeedback-level-0' => 'Meget dårlig',
	'readerfeedback-level-1' => 'Dårlig',
	'readerfeedback-level-2' => 'Middel',
	'readerfeedback-level-3' => 'God',
	'readerfeedback-level-4' => 'Meget god',
	'readerfeedback-submit' => 'Indsend',
	'readerfeedback-main' => 'Kun indholdssider kan bedømmes.',
	'readerfeedback-success' => "'''Tak for at du bedømte denne side!''' ([$2 se resultater]) ([$3 kommentarer eller spørgsmål?])",
	'readerfeedback-voted' => "'''Det ser ud til, at du allerede har bedømt denne side.''' ([$2 se resultater]) ([$3 kommentarer eller spørgsmål?])",
	'readerfeedback-submitting' => 'Indsender …',
	'readerfeedback-finished' => 'Tak!',
	'readerfeedback-tagfilter' => 'Bedømmelseskategori:',
	'readerfeedback-tierfilter' => 'Bedømmelse:',
	'readerfeedback-tier-high' => 'Høj',
	'readerfeedback-tier-medium' => 'Middel',
	'readerfeedback-tier-poor' => 'Dårlig',
	'tooltip-ca-ratinghist' => 'Læserbedømmelser af denne side',
	'specialpages-group-feedback' => 'Læserbedømmelse',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Imre
 * @author Kghbln
 * @author MF-Warburg
 * @author Melancholie
 * @author Merlissimo
 * @author Metalhead64
 * @author MichaelFrey
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'readerfeedback-desc' => 'Ergänzt eine Möglichkeit, die dem Leser erlaubt eine Rückmeldung in Form von vorgegebenen Bewertungen über die Seite zu geben',
	'readerfeedback' => 'Was denkst du über diese Seite?',
	'readerfeedback-text' => "''Bitte nimm dir einen Moment Zeit und bewerte diese Seite. Deine Rückmeldung ist wertvoll und hilft uns, das Angebot zu verbessern.''",
	'readerfeedback-reliability' => 'Zuverlässigkeit',
	'readerfeedback-completeness' => 'Vollständigkeit',
	'readerfeedback-npov' => 'Neutralität',
	'readerfeedback-presentation' => 'Präsentation',
	'readerfeedback-overall' => 'Insgesamt',
	'readerfeedback-level-none' => '(unsicher)',
	'readerfeedback-level-0' => 'Mangelhaft',
	'readerfeedback-level-1' => 'Ausreichend',
	'readerfeedback-level-2' => 'Befriedigend',
	'readerfeedback-level-3' => 'Gut',
	'readerfeedback-level-4' => 'Sehr gut',
	'readerfeedback-submit' => 'Speichern',
	'readerfeedback-main' => 'Es können nur Inhaltsseiten bewertet werden.',
	'readerfeedback-success' => "'''Danke für deine Bewertung dieser Seite.''' ([$2 Ergebnisse anschauen]) ([$3 Kommentare oder Fragen?]).",
	'readerfeedback-voted' => "'''Du hast offenbar bereits eine Bewertung für diese Seite abgegeben.''' ([$2 Ergebnisse anschauen]) ([$3 Kommentare oder Fragen?]).",
	'readerfeedback-error' => "'''Während der Bewertung dieser Seite ist ein Fehler aufgetreten''' ([$2 Ergebnisse anschauen]) ([$3 Kommentare oder Fragen?]).",
	'readerfeedback-submitting' => 'Übertragung …',
	'readerfeedback-finished' => 'Vielen Dank!',
	'readerfeedback-tagfilter' => 'Markierung:',
	'readerfeedback-tierfilter' => 'Bewertung:',
	'readerfeedback-tier-high' => 'Ausgezeichnet',
	'readerfeedback-tier-medium' => 'Mittelmäßig',
	'readerfeedback-tier-poor' => 'Schlecht',
	'tooltip-ca-ratinghist' => 'Leserbewertungen dieser Seite',
	'specialpages-group-feedback' => 'Meinung der Betrachter',
	'readerfeedback-tt-review' => 'Bewertung abschicken',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'readerfeedback' => 'Was denken Sie über diese Seite?',
	'readerfeedback-text' => "''Bitte nehmen Sie sich einen Moment Zeit und bewerten diese Seite. Ihre Rückmeldung ist wertvoll und hilft uns, das Angebot zu verbessern.''",
	'readerfeedback-success' => "'''Danke für Ihre Bewertung dieser Seite.''' ([$2 Ergebnisse anschauen]) ([$3 Kommentare oder Fragen?]).",
	'readerfeedback-voted' => "'''Sie haben offenbar bereits eine Bewertung für diese Seite abgegeben.''' ([$2 Ergebnisse anschauen]) ([$3 Kommentare oder Fragen?]).",
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'readerfeedback-desc' => 'Pê pele testik kerdişî, wendekaran eşkeno ser nuşteyan feedback bido',
	'readerfeedback' => 'derheqê no pelî de çi fikrê şima esto?',
	'readerfeedback-text' => "''kerem kerê qey reydayişê no peli re bıne wextê xo bıde. ma qıymet danî cewabê şima.''",
	'readerfeedback-reliability' => 'pawıtışi',
	'readerfeedback-completeness' => 'temam biyayişi',
	'readerfeedback-npov' => 'bêterefi',
	'readerfeedback-presentation' => 'pêşkeşkerdış',
	'readerfeedback-overall' => 'pêro',
	'readerfeedback-level-none' => '(bêqerar)',
	'readerfeedback-level-0' => 'zeyif',
	'readerfeedback-level-1' => 'kêm',
	'readerfeedback-level-2' => 'adil',
	'readerfeedback-level-3' => 'berz',
	'readerfeedback-level-4' => 'mukemmel',
	'readerfeedback-submit' => 'bıerşaw/bıruşn',
	'readerfeedback-main' => 'têna pelê muhtewayi rey bênî',
	'readerfeedback-success' => "'''qey çımçarnayiş3e şıma ma tşk keni!''' ([$2 neticeyan bıvin]) ([$3 persi ya zi mışoreyi?]).",
	'readerfeedback-voted' => "'''wina aseno ke şıma cıwa ver rey dayo no pel''' ([$2 neticeyan bıvin]) ([$3 persi ya zi mışoreyi?]).",
	'readerfeedback-error' => "'''wexta ke şıma no pel derece kerdenê xeta vıraziya''' ([$2 neticeyan bıvin]) ([$3 persi ya zi mışoreyi?]).",
	'readerfeedback-submitting' => 'erşawiyeno/ruşiyeno',
	'readerfeedback-finished' => 'sipas!',
	'readerfeedback-tagfilter' => 'etiket:',
	'readerfeedback-tierfilter' => 'derecekerdış:',
	'readerfeedback-tier-high' => 'berz',
	'readerfeedback-tier-medium' => 'weset',
	'readerfeedback-tier-poor' => 'zeyif',
	'tooltip-ca-ratinghist' => 'derecekerdışê peli yo ziyaretkerdoxi',
	'specialpages-group-feedback' => 'fikrê temaşawanî',
	'readerfeedback-tt-review' => 'qontrol teslim bike',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 * @author Nepl1
 */
$messages['dsb'] = array(
	'readerfeedback-desc' => 'Pśekontrolěrowanje nastawkow zmóžnja cytarjam w formje kategoriskich pógódnośenjow jich měnjenje zwurazniś',
	'readerfeedback' => 'Co źaržyš wó toś tom boku?',
	'readerfeedback-text' => "''Pšosym wzij wokognuśe casa a pógódnoś toś ten bok. Twójo měnjenje jo gódne a pomaga nam našo websedło pólěpšyś.''",
	'readerfeedback-reliability' => 'Spušćobnosć',
	'readerfeedback-completeness' => 'Dopołnosć',
	'readerfeedback-npov' => 'Neutralnosć',
	'readerfeedback-presentation' => 'Prezentacija',
	'readerfeedback-overall' => 'Dogromady',
	'readerfeedback-level-none' => '(njewěsty)',
	'readerfeedback-level-0' => 'Njedosegajucy',
	'readerfeedback-level-1' => 'Dosegajucy',
	'readerfeedback-level-2' => 'Spokojecy',
	'readerfeedback-level-3' => 'Wusoki',
	'readerfeedback-level-4' => 'Ekscelentny',
	'readerfeedback-submit' => 'Wótpósłaś',
	'readerfeedback-main' => 'Jano wopśimjeśowe boki daju se pógódnośiś.',
	'readerfeedback-success' => "'''Źěkujomy se za pśeglědowanje toś togo boka!''' ([$2 glědaj wuslědki]) ([$3 komentary abo pšašanja?]).",
	'readerfeedback-voted' => "'''Zda se, až sy južo pógódnośił toś ten bok''' ([$2 glědaj wuslědki]) ([$3 komentary abo pšašanja?]).",
	'readerfeedback-error' => "'''Pśi pogódnośowanju toś togo boka jo zmólka nastała''' ([$2 glědaj wuslědki]) ([$3 komentary abo pšašanja?]).",
	'readerfeedback-submitting' => 'Wótpósćeła se...',
	'readerfeedback-finished' => 'Źěkujomy se!',
	'readerfeedback-tagfilter' => 'Toflicka:',
	'readerfeedback-tierfilter' => 'Pógódnośenje:',
	'readerfeedback-tier-high' => 'Wusoki',
	'readerfeedback-tier-medium' => 'Srědny',
	'readerfeedback-tier-poor' => 'Špatny',
	'tooltip-ca-ratinghist' => 'Pógódnośenja cytarjow za toś ten bok',
	'specialpages-group-feedback' => 'Měnjenje wobglědowarja',
	'readerfeedback-tt-review' => 'Pśeglědanje wótpósłaś',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Crazymadlover
 * @author Dead3y3
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'readerfeedback' => 'Τι πιστεύετε για αυτή τη σελίδα;',
	'readerfeedback-reliability' => 'Αξιοπιστία',
	'readerfeedback-completeness' => 'Πληρότητα',
	'readerfeedback-npov' => 'Ουδετερότητα',
	'readerfeedback-presentation' => 'Παρουσίαση',
	'readerfeedback-overall' => 'Συνολικό',
	'readerfeedback-level-none' => '(αβέβαιο)',
	'readerfeedback-level-0' => 'Φτωχό',
	'readerfeedback-level-1' => 'Χαμηλός',
	'readerfeedback-level-2' => 'Αρκετά καλό',
	'readerfeedback-level-3' => 'Υψηλός',
	'readerfeedback-level-4' => 'Τέλεια',
	'readerfeedback-submit' => 'Υποβολή',
	'readerfeedback-main' => 'Μόνο σελίδες περιεχομένου μπορούν να βαθμολογηθούν.',
	'readerfeedback-submitting' => 'Υποβολή ...',
	'readerfeedback-finished' => 'Σας ευχαριστούμε!',
	'readerfeedback-tagfilter' => 'Ετικέτα:',
	'readerfeedback-tierfilter' => 'Βαθμολογία:',
	'readerfeedback-tier-high' => 'Υψηλός',
	'readerfeedback-tier-medium' => 'Μέτρια',
	'readerfeedback-tier-poor' => 'Φτωχός',
	'tooltip-ca-ratinghist' => 'Βαθμολογίες αναγνωστών για αυτή τη σελίδα',
	'specialpages-group-feedback' => 'Γνώμη θεατή',
	'readerfeedback-tt-review' => 'Υποβολή αναθεώρησης',
);

/** Esperanto (Esperanto)
 * @author ArnoLagrange
 * @author Castelobranco
 * @author Yekrats
 */
$messages['eo'] = array(
	'readerfeedback-desc' => 'Paĝa validigado permesas por legantoj doni prisondoj per kategoriaj pritaksoj',
	'readerfeedback' => 'Kiel vi opinias pri ĉi tiu paĝo?',
	'readerfeedback-text' => "''Bonvolu taksigi la jenan paĝon. Via opinio estas valora kaj helpas nin plibonigi nian retejon.''",
	'readerfeedback-reliability' => 'Fidindeco',
	'readerfeedback-completeness' => 'Kompleteco',
	'readerfeedback-npov' => 'Neŭtraleco',
	'readerfeedback-presentation' => 'Prezentado',
	'readerfeedback-overall' => 'Entute',
	'readerfeedback-level-none' => '(necerta)',
	'readerfeedback-level-0' => 'Malbonege kvalita',
	'readerfeedback-level-1' => 'Malbonkvalita',
	'readerfeedback-level-2' => 'Mezkvalita',
	'readerfeedback-level-3' => 'Bonkvalita',
	'readerfeedback-level-4' => 'Bonega',
	'readerfeedback-submit' => 'Ek',
	'readerfeedback-main' => 'Nur enhavaj paĝoj estas takseblaj.',
	'readerfeedback-success' => "'''Dankon pro kontrolante ĉi tiun paĝon!''' ([$2 vidi rezultojn]) ([$3 Ĉu komentoj aŭ demandoj?]).",
	'readerfeedback-voted' => "'''Verŝajne vi jam taksis ĉi tiun paĝon.''' ([$2 vidi rezultojn]) ([$3 Ĉu komentoj aŭ demandoj?]).",
	'readerfeedback-error' => "'''Eraro okazis kiam taksante ĉi tiu paĝo''' ([$2 vidi rezultojn]) ([$3 Ĉu komentoj aŭ demandoj?]).",
	'readerfeedback-submitting' => 'Sendante...',
	'readerfeedback-finished' => 'Dankon!',
	'readerfeedback-tagfilter' => 'Etikedo:',
	'readerfeedback-tierfilter' => 'Taksado:',
	'readerfeedback-tier-high' => 'Bonkvalita',
	'readerfeedback-tier-medium' => 'Mezkvalita',
	'readerfeedback-tier-poor' => 'Malbonkvalita',
	'tooltip-ca-ratinghist' => 'Taksoj de legintoj de ĉi tiu paĝo',
	'specialpages-group-feedback' => 'Opinio de vidantaro',
	'readerfeedback-tt-review' => 'Konservi',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Drini
 * @author Imre
 * @author Lin linao
 * @author Locos epraix
 * @author McDutchie
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'readerfeedback-desc' => 'La validación de páginas permite a los lectores a dar respuesta en forma de valoraciones categóricas',
	'readerfeedback' => '¿Qué opinas de esta página?',
	'readerfeedback-text' => "''Por favor, toma un momento para calificar la página. Tu aportación es valiosa y nos ayuda a mejorar el sitio''",
	'readerfeedback-reliability' => 'Confiabilidad',
	'readerfeedback-completeness' => 'Completitud',
	'readerfeedback-npov' => 'Neutralidad',
	'readerfeedback-presentation' => 'Presentación',
	'readerfeedback-overall' => 'En conjunto',
	'readerfeedback-level-none' => '(no seguro)',
	'readerfeedback-level-0' => 'Pobre',
	'readerfeedback-level-1' => 'Baja',
	'readerfeedback-level-2' => 'Aceptable',
	'readerfeedback-level-3' => 'Alto',
	'readerfeedback-level-4' => 'Excelente',
	'readerfeedback-submit' => 'Enviar',
	'readerfeedback-main' => 'Solamente páginas de contenido pueden ser valoradas.',
	'readerfeedback-success' => "'''Gracias por revisar esta página!''' ([$2 ver resultados]) ([$3 Comentarios o preguntas?]).",
	'readerfeedback-voted' => "'''Parece que ya valoraste esta página''' ([$2 ver resultados]) ([$3 comentarios o preguntas?]).",
	'readerfeedback-error' => "'''Un error ha ocurrido cuando se valorizaba esta página''' ([$2 ver resultados]) ([$3 comentarios o preguntas?]).",
	'readerfeedback-submitting' => 'Enviando...',
	'readerfeedback-finished' => '¡Gracias!',
	'readerfeedback-tagfilter' => 'Etiqueta:',
	'readerfeedback-tierfilter' => 'Valorización:',
	'readerfeedback-tier-high' => 'Alta',
	'readerfeedback-tier-medium' => 'Moderada',
	'readerfeedback-tier-poor' => 'Pobre',
	'tooltip-ca-ratinghist' => 'Valoraciones de los lectores de esta página',
	'specialpages-group-feedback' => 'Opinión del espectador',
	'readerfeedback-tt-review' => 'Enviar revisión',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'readerfeedback' => 'Mida arvad sellest leheküljest?',
	'readerfeedback-text' => 'Palun leia hetk selle lehekülje hindamiseks. Sinu tagasiside on tänuväärne ja aitab meil võrgukohta täiustada.',
	'readerfeedback-reliability' => 'Usaldusväärsus',
	'readerfeedback-completeness' => 'Täielikkus',
	'readerfeedback-npov' => 'Erapooletus',
	'readerfeedback-presentation' => 'Esitus',
	'readerfeedback-level-none' => '(ei oska öelda)',
	'readerfeedback-level-0' => 'Väga nõrk',
	'readerfeedback-level-1' => 'Madal',
	'readerfeedback-level-2' => 'Rahuldav',
	'readerfeedback-level-3' => 'Kõrge',
	'readerfeedback-level-4' => 'Suurepärane',
	'readerfeedback-submit' => 'Sobib',
	'readerfeedback-main' => 'Hinnata saab ainult sisulehekülgi.',
	'readerfeedback-success' => "'''Aitäh arvustamise eest!''' ([$2 vaata tulemusi]) ([$3 kommentaare või küsimusi?]).",
	'readerfeedback-voted' => "'''Tuleb välja, et oled seda lehekülge juba hinnanud''' ([$2 vaata tulemusi]) ([$3 kommentaare või küsimusi?]).",
	'readerfeedback-error' => "'''Lehekülje hindamisel ilmnes tõrge''' ([$2 vaata tulemusi]) ([$3 kommentaare või küsimusi?]).",
	'readerfeedback-submitting' => 'Saatmine...',
	'readerfeedback-finished' => 'Aitäh!',
	'readerfeedback-tagfilter' => 'Märgis:',
	'readerfeedback-tierfilter' => 'Hindamine:',
	'readerfeedback-tier-high' => 'Kõrge',
	'readerfeedback-tier-medium' => 'Keskmine',
	'readerfeedback-tier-poor' => 'Nõrk',
	'tooltip-ca-ratinghist' => 'Lugejate hinnangud sellele leheküljele',
	'specialpages-group-feedback' => 'Lugejahinnang',
	'readerfeedback-tt-review' => 'Saada arvustus',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Bengoa
 * @author Joxemai
 * @author Kobazulo
 * @author Unai Fdz. de Betoño
 */
$messages['eu'] = array(
	'readerfeedback' => 'Zer deritzozu orrialde honi buruz?',
	'readerfeedback-text' => "''Har ezazu, mesedez, une bat orri hau baloratzeko. Zure iritzia garrantzitsua da eta gure webgunea hobetzen laguntzen digu.''",
	'readerfeedback-reliability' => 'Fidagarritasuna',
	'readerfeedback-npov' => 'Neutraltasuna',
	'readerfeedback-presentation' => 'Aurkezpena',
	'readerfeedback-overall' => 'Guztira',
	'readerfeedback-level-none' => '(ziurtasun gutxikoa)',
	'readerfeedback-level-0' => 'Txarra',
	'readerfeedback-level-1' => 'Baxua',
	'readerfeedback-level-2' => 'Bidezkoa',
	'readerfeedback-level-3' => 'Altua',
	'readerfeedback-level-4' => 'Bikaina',
	'readerfeedback-submit' => 'Bidali',
	'readerfeedback-submitting' => 'Bidaltzen',
	'readerfeedback-finished' => 'Mila esker!',
	'readerfeedback-tagfilter' => 'Etiketa:',
	'readerfeedback-tierfilter' => 'Balorazioak:',
	'readerfeedback-tier-high' => 'Altua',
	'readerfeedback-tier-poor' => 'Txarra',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Mardetanha
 * @author Sahim
 * @author Wayiran
 */
$messages['fa'] = array(
	'readerfeedback-desc' => 'اعتباردهی به صفحه، به خوانندگان اجازه می‌دهد تا بازخورد را در شکل درجه‌های رده‌بندی‌شده ارائه کنند.',
	'readerfeedback' => 'دربارهٔ این صفحه چه فکر می‌کنید؟',
	'readerfeedback-text' => "''لطفاً چند لحظه صرف ارزیابی صفحهٔ زیر کنید. بازخورد شما ارزشمند است و به ما در بهبود وبگاهمان کمک می‌کند.''",
	'readerfeedback-reliability' => 'اعتمادپذیری',
	'readerfeedback-completeness' => 'کامل بودن',
	'readerfeedback-npov' => 'بی‌طرفانه بودن',
	'readerfeedback-presentation' => 'نمایش',
	'readerfeedback-overall' => 'روی هم رفته',
	'readerfeedback-level-none' => '(نامطمئن)',
	'readerfeedback-level-0' => 'پست',
	'readerfeedback-level-1' => 'پایین',
	'readerfeedback-level-2' => 'متوسط',
	'readerfeedback-level-3' => 'بالا',
	'readerfeedback-level-4' => 'ممتاز',
	'readerfeedback-submit' => 'ارسال',
	'readerfeedback-main' => 'فقط صفحه‌های محتوایی قابل ارزیابی هستند.',
	'readerfeedback-success' => "'''با سپاس از شما برای بازبینی این صفحه!''' ([$2 نتایج را ببینید]) ([$3 نظر و پرسش]).",
	'readerfeedback-voted' => "'''به نظر می‌رسد که شما پیش از این، این صفحه را بازبینی کرده‌اید''' ([$2 نتیجه را ببین]) ([$3 نظر و سوال]).",
	'readerfeedback-error' => "'''هنگام امتیازدهی به این صفحه خطایی رخ داد''' ([$2 مشاهده نتایج]) ([$3 نظر یا سوال؟]).",
	'readerfeedback-submitting' => 'در حال ارسال...',
	'readerfeedback-finished' => 'متشکریم!',
	'readerfeedback-tagfilter' => 'برچسپ:',
	'readerfeedback-tierfilter' => 'ارزش:',
	'readerfeedback-tier-high' => 'زیاد',
	'readerfeedback-tier-medium' => 'متوسط',
	'readerfeedback-tier-poor' => 'ضعیف',
	'tooltip-ca-ratinghist' => 'نمره خوانندگان به این صفحه',
	'specialpages-group-feedback' => 'نظر خوانندگان',
	'readerfeedback-tt-review' => 'ارسال بازبینی',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Nike
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'readerfeedback-desc' => 'Sivun tarkistaminen mahdollistaa lukijoiden antaa palautteensa luokkakohtaisten arvosanojen muodossa.',
	'readerfeedback' => 'Mitä mieltä olet tästä sivusta?',
	'readerfeedback-text' => "''Käytäthän hetken arvioidaksesi alla olevan sivun. Palautteesi on arvokas ja auttaa parantamaan verkkosivustoamme.''",
	'readerfeedback-reliability' => 'Luettavuus',
	'readerfeedback-completeness' => 'Täydellisyys',
	'readerfeedback-npov' => 'Neutraalius',
	'readerfeedback-presentation' => 'Esittäminen',
	'readerfeedback-overall' => 'Kokonaisvaikutelma',
	'readerfeedback-level-none' => '(epävarma)',
	'readerfeedback-level-0' => 'Todella heikko',
	'readerfeedback-level-1' => 'Alhainen',
	'readerfeedback-level-2' => 'Kohtalainen',
	'readerfeedback-level-3' => 'Hyvä',
	'readerfeedback-level-4' => 'Erinomainen',
	'readerfeedback-submit' => 'Lähetä',
	'readerfeedback-main' => 'Vain sisältösivuja voi arvioida.',
	'readerfeedback-success' => "'''Kiitos tämän sivun arvioimisesta.''' ([$2 näytä tulokset]) ([$3 kommentteja tai kysymyksiä?]).",
	'readerfeedback-voted' => "'''Näyttää siltä, että olet jo arvioinut tämän sivun''' ([$2 näytä tulokset]) ([$3 kommentteja tai kysymyksiä?]).",
	'readerfeedback-error' => "'''Virhe tapahtui tätä sivua arvosteltaessa''' ([$2 katso tulokset]) ([$3 kommentteja tai kysymyksiä?]).",
	'readerfeedback-submitting' => 'Lähetetään…',
	'readerfeedback-finished' => 'Kiitos!',
	'readerfeedback-tagfilter' => 'Merkintä:',
	'readerfeedback-tierfilter' => 'Arvostelu',
	'readerfeedback-tier-high' => 'Korkea',
	'readerfeedback-tier-medium' => 'Kohtalainen',
	'readerfeedback-tier-poor' => 'Heikko',
	'tooltip-ca-ratinghist' => 'Lukijoiden arviot tästä sivusta',
	'specialpages-group-feedback' => 'Katsojan mielipide',
	'readerfeedback-tt-review' => 'Lähetä arvio',
);

/** French (Français)
 * @author Cedric31
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 * @author Korrigan
 * @author McDutchie
 * @author Mihai
 * @author Omnipaedista
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author The RedBurn
 * @author Urhixidur
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'readerfeedback-desc' => 'La validation d’articles permet aux lecteurs de rendre leur avis sous forme d’évaluations par catégorie',
	'readerfeedback' => 'Que pensez-vous de cette page ?',
	'readerfeedback-text' => "''Veuillez consacrer un instant pour évaluer cette page ci-dessous. Vos impressions sont précieuses et nous aident à améliorer notre site web.''",
	'readerfeedback-reliability' => 'Fiabilité',
	'readerfeedback-completeness' => 'Complétude',
	'readerfeedback-npov' => 'Neutralité',
	'readerfeedback-presentation' => 'Présentation',
	'readerfeedback-overall' => 'Global',
	'readerfeedback-level-none' => '(non sûr)',
	'readerfeedback-level-0' => 'Faible',
	'readerfeedback-level-1' => 'Médiocre',
	'readerfeedback-level-2' => 'Moyen',
	'readerfeedback-level-3' => 'Bon',
	'readerfeedback-level-4' => 'Excellent',
	'readerfeedback-submit' => 'Soumettre',
	'readerfeedback-main' => 'Seules les pages de contenu peuvent être évaluées.',
	'readerfeedback-success' => "'''Merci d’avoir évalué cette page !''' ([$2 voir les résultats]) ([$3 des questions ou des commentaires ?])",
	'readerfeedback-voted' => "'''Il semble que vous ayez déjà évalué cette page''' ([$2 voir les résultats]) ([$3 des questions ou des commentaires ?])",
	'readerfeedback-error' => "'''Une erreur est survenue lors de l’évaluation de cette page''' ([$2 voir les résultats]) ([$3 remarques ou questions ?]).",
	'readerfeedback-submitting' => 'Soumission…',
	'readerfeedback-finished' => 'Merci !',
	'readerfeedback-tagfilter' => 'Balise:',
	'readerfeedback-tierfilter' => 'Évaluation :',
	'readerfeedback-tier-high' => 'Bonne',
	'readerfeedback-tier-medium' => 'Moyenne',
	'readerfeedback-tier-poor' => 'Mauvaise',
	'tooltip-ca-ratinghist' => 'Évaluations de cette page par les lecteurs',
	'specialpages-group-feedback' => 'Opinion du lecteur',
	'readerfeedback-tt-review' => "Soumettre l'évaluation",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'readerfeedback-desc' => 'La validacion d’articllos pèrmèt ux liésors de rendre lor avis desot fôrma d’èstimacions per catègorie.',
	'readerfeedback' => 'Què pensâd-vos de ceta pâge ?',
	'readerfeedback-text' => "''Volyéd consacrar un moment por èstimar ceta pâge ce-desot. Voutres emprèssions ont de valor et pués nos édont a mèlyorar noutron seto vouèbe.''",
	'readerfeedback-reliability' => 'Fiabilitât',
	'readerfeedback-completeness' => 'Entegritât',
	'readerfeedback-npov' => 'Netralitât',
	'readerfeedback-presentation' => 'Presentacion',
	'readerfeedback-overall' => 'Globâl',
	'readerfeedback-level-none' => '(pas de sûr)',
	'readerfeedback-level-0' => 'Fêblo',
	'readerfeedback-level-1' => 'Prod moyen',
	'readerfeedback-level-2' => 'Moyen',
	'readerfeedback-level-3' => 'Bon',
	'readerfeedback-level-4' => 'Famox',
	'readerfeedback-submit' => 'Sometre',
	'readerfeedback-main' => 'Solament les pâges de contegnu pôvont étre èstimâs.',
	'readerfeedback-success' => "'''Grant-marci d’avêr revu ceta pâge !''' ([$2 vêre los rèsultats]) ([$3 des quèstions ou ben des comentèros ?])",
	'readerfeedback-voted' => "'''Semble que vos èyâd ja èstimâ ceta pâge.''' ([$2 vêre los rèsultats]) ([$3 des quèstions ou ben des comentèros ?])",
	'readerfeedback-error' => "'''Una èrror est arrevâ pendent l’èstimacion de ceta pâge''' ([$2 vêre los rèsultats]) ([$3 remârques ou ben quèstions ?]).",
	'readerfeedback-submitting' => 'Somission...',
	'readerfeedback-finished' => 'Grant-marci !',
	'readerfeedback-tagfilter' => 'Balisa :',
	'readerfeedback-tierfilter' => 'Èstimacion :',
	'readerfeedback-tier-high' => 'Bôna',
	'readerfeedback-tier-medium' => 'Moyena',
	'readerfeedback-tier-poor' => 'Crouye',
	'tooltip-ca-ratinghist' => 'Èstimacions de ceta pâge per los liésors',
	'specialpages-group-feedback' => 'Avis u liésor',
	'readerfeedback-tt-review' => 'Sometre la rèvision',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'readerfeedback-desc' => 'A validación de páxinas permite que os lectores dean a súa opinión en forma de valoracións categóricas',
	'readerfeedback' => 'Que pensa sobre esta páxina?',
	'readerfeedback-text' => "''Por favor, tome un momento para valorar esta páxina. A súa impresión é valiosa e axúdanos a mellorar a nosa páxina web.''",
	'readerfeedback-reliability' => 'Fiabilidade',
	'readerfeedback-completeness' => 'Exhaustividade',
	'readerfeedback-npov' => 'Neutralidade',
	'readerfeedback-presentation' => 'Presentación',
	'readerfeedback-overall' => 'En xeral',
	'readerfeedback-level-none' => '(non seguro)',
	'readerfeedback-level-0' => 'Pobre',
	'readerfeedback-level-1' => 'Baixa',
	'readerfeedback-level-2' => 'Boa',
	'readerfeedback-level-3' => 'Alta',
	'readerfeedback-level-4' => 'Excelente',
	'readerfeedback-submit' => 'Enviar',
	'readerfeedback-main' => 'Só as páxinas con contido poden ser puntuadas.',
	'readerfeedback-success' => "'''Grazas por revisar esta páxina!''' ([$2 vexa os resultados]) ([$3 ten comentarios ou preguntas?]).",
	'readerfeedback-voted' => "'''Semella que xa valorou esta páxina''' ([$2 vexa os resultados]) ([$3 ten comentarios ou preguntas?]).",
	'readerfeedback-error' => "'''Houbo un erro durante a valoración desta páxina''' ([$2 vexa os resultados]) ([$3 ten comentarios ou preguntas?]).",
	'readerfeedback-submitting' => 'Enviando...',
	'readerfeedback-finished' => 'Grazas!',
	'readerfeedback-tagfilter' => 'Etiqueta:',
	'readerfeedback-tierfilter' => 'Valoración:',
	'readerfeedback-tier-high' => 'Alta',
	'readerfeedback-tier-medium' => 'Media',
	'readerfeedback-tier-poor' => 'Baixa',
	'tooltip-ca-ratinghist' => 'Valoracións dos lectores desta páxina',
	'specialpages-group-feedback' => 'Opinión do lector',
	'readerfeedback-tt-review' => 'Enviar a revisión',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'readerfeedback-reliability' => 'ἀξιοπιστία',
	'readerfeedback-completeness' => 'πληρότης',
	'readerfeedback-npov' => 'οὐδετερότης',
	'readerfeedback-presentation' => 'παρουσίασις',
	'readerfeedback-overall' => 'Συνολικῶς',
	'readerfeedback-level-none' => '(ἀβέβαιος)',
	'readerfeedback-level-0' => 'ἀνεπαρκής',
	'readerfeedback-level-1' => 'Χθαμηλή',
	'readerfeedback-level-2' => 'δίκαιη',
	'readerfeedback-level-3' => 'Ὑψηλή',
	'readerfeedback-level-4' => 'ἐξαἰρετος',
	'readerfeedback-submit' => 'Ὑποβάλλειν',
	'readerfeedback-submitting' => 'Ὑποβάλλειν...',
	'readerfeedback-finished' => 'Εὐχαριστοῦμεν!',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Melancholie
 */
$messages['gsw'] = array(
	'readerfeedback-desc' => 'Sytevalidierig macht s Läser megli e Ruckmäldig z gee in Form vu kategorisierte Note',
	'readerfeedback' => 'Was dänksch iber die Syte?',
	'readerfeedback-text' => "''Bitte nimm Der e Momänt derzyt un bewärt die Syte. Dyyni Ruckmäldig isch wärtvoll un hilft is, s Aagebot z verbessere.''",
	'readerfeedback-reliability' => 'Zueverlässigkeit',
	'readerfeedback-completeness' => 'Vollständigkeit',
	'readerfeedback-npov' => 'Neutralität',
	'readerfeedback-presentation' => 'Präsentation',
	'readerfeedback-overall' => 'Insgsamt',
	'readerfeedback-level-none' => '(uusicher)',
	'readerfeedback-level-0' => 'Mangelhaft',
	'readerfeedback-level-1' => 'Längt grad',
	'readerfeedback-level-2' => 's goht',
	'readerfeedback-level-3' => 'Guet',
	'readerfeedback-level-4' => 'Seli guet',
	'readerfeedback-submit' => 'In Ornig',
	'readerfeedback-main' => 'S chenne nume Artikel gwärtet wäre.',
	'readerfeedback-success' => "'''Dankschen fir Dyyni Bewärtig vu däre Syte.''' ([$2 Ergebnis bschaue]) ([$3 Kommentar oder Froge?]).",
	'readerfeedback-voted' => "'''Du hesch schyyns scho ne Bewärtig fir die Syte abgee.''' ([$2 Ergebnis bschaue]) ([$3 Kommentar oder Froge?]).",
	'readerfeedback-error' => "'''E Fähler isch ufträtte bim Bewärte vu däre Syte''' ([$2 Ergebnis bschaue]) ([$3 Kommentar oder Froge?]).",
	'readerfeedback-submitting' => '… bitte warte …',
	'readerfeedback-finished' => 'Merci!',
	'readerfeedback-tagfilter' => 'Tag:',
	'readerfeedback-tierfilter' => 'Bewärtig:',
	'readerfeedback-tier-high' => 'Hoch',
	'readerfeedback-tier-medium' => 'Mittel',
	'readerfeedback-tier-poor' => 'Nider',
	'tooltip-ca-ratinghist' => 'Läserwärtige vu däre Syte',
	'specialpages-group-feedback' => 'Meinig vum Läser',
	'readerfeedback-tt-review' => 'Bewärtig abschicke',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author DoviJ
 * @author Nahum
 * @author Ori229
 * @author Rotemliss
 * @author StuB
 * @author YaronSh
 * @author דניאל ב.
 */
$messages['he'] = array(
	'readerfeedback-desc' => 'אימות דפים המאפשר לקוראים לתת משוב באמצעות טופס לדירוג לפי קטגוריה',
	'readerfeedback' => 'מה אתם חושבים על הדף הזה?',
	'readerfeedback-text' => "'''אנא השקיעו רגע מזמנכם כדי לדרג דף זה. למשוב שתתנו יש ערך רב והוא יעזור לנו לשפר את האתר.'''",
	'readerfeedback-reliability' => 'מהימנות',
	'readerfeedback-completeness' => 'שלמות',
	'readerfeedback-npov' => 'נייטרליות',
	'readerfeedback-presentation' => 'אופן ההצגה',
	'readerfeedback-overall' => 'בסך הכול',
	'readerfeedback-level-none' => '(לא בטוח)',
	'readerfeedback-level-0' => 'גרוע',
	'readerfeedback-level-1' => 'נמוך',
	'readerfeedback-level-2' => 'בינוני',
	'readerfeedback-level-3' => 'גבוה',
	'readerfeedback-level-4' => 'מצוין',
	'readerfeedback-submit' => 'שליחה',
	'readerfeedback-main' => 'רק דפי תוכן ניתנים לדירוג.',
	'readerfeedback-success' => "'''תודה שבדקתם דף זה!''' ([$2 לתוצאות]) ([$3 הערות או שאלות?])",
	'readerfeedback-voted' => "'''נראה שכבר דירגתם דף זה''' ([$2 לתוצאות]) ([$3 הערות או שאלות?]).",
	'readerfeedback-error' => "'''ארעה שגיאה בעת דירוג דף זה''' ([$2 לתוצאות]) ([$3 הערות או שאלות?]).",
	'readerfeedback-submitting' => 'נשלח...',
	'readerfeedback-finished' => 'תודה!',
	'readerfeedback-tagfilter' => 'תגית:',
	'readerfeedback-tierfilter' => 'דירוג:',
	'readerfeedback-tier-high' => 'גבוה',
	'readerfeedback-tier-medium' => 'בינוני',
	'readerfeedback-tier-poor' => 'גרוע',
	'tooltip-ca-ratinghist' => 'דירוג קוראים לדף זה',
	'specialpages-group-feedback' => 'דעת הצופה',
	'readerfeedback-tt-review' => 'שליחת ביקורת',
);

/** Hindi (हिन्दी)
 * @author Mayur
 * @author Vibhijain
 */
$messages['hi'] = array(
	'readerfeedback-desc' => 'पाठकों के लिए स्पष्ट कहा रेटिंग्स के रूप में प्रतिक्रिया देने के लिए पृष्ठ सत्यापन की अनुमति देता है',
	'readerfeedback' => 'आपका इस पृष्ठ के बारे में क्या सोचना है?',
	'readerfeedback-text' => "''इस पृष्ठ के नीचे की दर के लिए एक क्षण ले कृपया. आपकी प्रतिक्रिया बहुमूल्य है और हमें हमारी वेबसाइट को बेहतर बनाने में मदद करता है.''",
	'readerfeedback-reliability' => 'विश्वसनीयता',
	'readerfeedback-completeness' => 'पूर्णता',
	'readerfeedback-npov' => 'तटस्थता',
	'readerfeedback-presentation' => 'प्रस्तुति',
	'readerfeedback-overall' => 'कुल मिलाकर',
	'readerfeedback-level-none' => '(अनिश्चित)',
	'readerfeedback-level-0' => 'अनुपयुक्त',
	'readerfeedback-level-1' => 'कम',
	'readerfeedback-level-2' => 'साफ',
	'readerfeedback-level-3' => 'उच्च',
	'readerfeedback-level-4' => 'उत्कृष्ट',
	'readerfeedback-submit' => 'भेजें',
	'readerfeedback-main' => 'केवल सामग्री पृष्ठों का मूल्यांकन किया जा सकता है.',
	'readerfeedback-success' => "' ' इस पृष्ठ की समीक्षा करने के लिए धन्यवाद! ' ' ([$2 परिणाम देखें]) ([$3 टिप्पणी या प्रश्न?])।",
	'readerfeedback-voted' => "'''ऐसा प्रतीत होता है कि आपने पहले से ही  इस पृष्ठ का मूल्यांकन किया गया है''' ([ $2 परिणाम देखने के]) ([ $3 टिप्पणी या प्रश्न?]).",
	'readerfeedback-error' => "' ' इस पृष्ठ रेटिंग करते समय कोई त्रुटि उत्पन्न हुई ' ' ([$2 परिणाम देखें]) ([$3 टिप्पणी या प्रश्न?])।",
	'readerfeedback-submitting' => 'सबमिट ...',
	'readerfeedback-finished' => 'धन्यवाद!',
	'readerfeedback-tagfilter' => 'टैग:',
	'readerfeedback-tierfilter' => 'रेटिंग(मूल्यांकन):',
	'readerfeedback-tier-high' => 'उच्च',
	'readerfeedback-tier-medium' => 'मध्यम',
	'readerfeedback-tier-poor' => 'अनुपयुक्त',
	'tooltip-ca-ratinghist' => 'इस पृष्ठ के रीडर रेटिंग',
	'specialpages-group-feedback' => 'पाठक मूल्याँकन',
	'readerfeedback-tt-review' => 'समीक्षा भेजें',
);

/** Croatian (Hrvatski)
 * @author Ex13
 * @author Roberta F.
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'readerfeedback-desc' => 'Ocjena stranica omogućava čitateljima davanje povratne informacije o kvaliteti stranica putem ocjena',
	'readerfeedback' => 'Što mislite o ovoj stranici?',
	'readerfeedback-text' => "''Molimo Vas odvojite trenutak kako bi ocijenili ovu stranicu. Vaša ocjena je vrijedna i pomaže nam poboljšati naš projekt.''",
	'readerfeedback-reliability' => 'Pouzdanost',
	'readerfeedback-completeness' => 'Potpunost',
	'readerfeedback-npov' => 'Neutralnost',
	'readerfeedback-presentation' => 'Prezentacija',
	'readerfeedback-overall' => 'Ukupno',
	'readerfeedback-level-none' => '(nisam siguran)',
	'readerfeedback-level-0' => 'Loše i nedovoljno',
	'readerfeedback-level-1' => 'Slabo ali dovoljno',
	'readerfeedback-level-2' => 'Dobro',
	'readerfeedback-level-3' => 'Vrlo dobro',
	'readerfeedback-level-4' => 'Izvrsno',
	'readerfeedback-submit' => 'Pošalji',
	'readerfeedback-main' => 'Samo stranice sa sadržajem mogu biti ocijenjene.',
	'readerfeedback-success' => "'''Hvala vam za ocjenu ove stranice!''' ([$2 vidi rezultate]) ([$3 komentari ili pitanja?]).",
	'readerfeedback-voted' => "'''Čini se da ste već ocijenili ovu stranicu''' ([$2 vidi rezultate]) ([$3 komentari ili pitanja?]).",
	'readerfeedback-error' => "'''Dogodila se pogreška pri ocjenjivanju stranice''' ([$2 vidi rezultate]) ([$3 komentari ili pitanja?]).",
	'readerfeedback-submitting' => 'Šaljem ...',
	'readerfeedback-finished' => 'Hvala!',
	'readerfeedback-tagfilter' => 'Oznaka:',
	'readerfeedback-tierfilter' => 'Rejting:',
	'readerfeedback-tier-high' => 'Visok',
	'readerfeedback-tier-medium' => 'Umjeren',
	'readerfeedback-tier-poor' => 'Slab',
	'tooltip-ca-ratinghist' => 'Ocjene ove stranice',
	'specialpages-group-feedback' => 'Mišljenje čitatelja',
	'readerfeedback-tt-review' => 'Pošaljite recenziju',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 */
$messages['hsb'] = array(
	'readerfeedback-desc' => 'Přepruwowanje nastawkow zmóžnja čitarjam we formje kategoriskich pohodnoćenjow jich měnjenje zwuraznić',
	'readerfeedback' => 'Što mysliš wo tutej stronje?',
	'readerfeedback-text' => "''Prošu bjer sej wokomik čas, zo by tutu stronu pohódnoćił. Twoja wotmołwa je hódnotna a pomha nam naše websydło polěpšić.''",
	'readerfeedback-reliability' => 'Spušćomnosć',
	'readerfeedback-completeness' => 'Dospołnosć',
	'readerfeedback-npov' => 'Neutralita',
	'readerfeedback-presentation' => 'Prezentacija',
	'readerfeedback-overall' => 'Dohromady',
	'readerfeedback-level-none' => '(njewěsty)',
	'readerfeedback-level-0' => 'Špatny',
	'readerfeedback-level-1' => 'Niski',
	'readerfeedback-level-2' => 'Spokojacy',
	'readerfeedback-level-3' => 'Wysoki',
	'readerfeedback-level-4' => 'Wuběrny',
	'readerfeedback-submit' => 'Pósłać',
	'readerfeedback-main' => 'Jenož nastawki hodźa so pohódnoćić.',
	'readerfeedback-success' => "'''Wulki dźak za přepruwowanje tuteje strony!''' ([$2 hlej wuslědki]) ([$3 komentary abo prašenja?]).",
	'readerfeedback-voted' => "'''Zda so, zo sy tutu stronu hižo pohódnoćił''' ([$2 hlej wuslědki]) ([$3 komentary abo prašenja?]).",
	'readerfeedback-error' => "'''Při pohódnočenju tuteje strony je zmylk wustupił''' ([$2 hlej wuslědki]) ([$3 komentary abo prašenja?]).",
	'readerfeedback-submitting' => 'Sćele so...',
	'readerfeedback-finished' => 'Wutrobny dźak!',
	'readerfeedback-tagfilter' => 'Taflička:',
	'readerfeedback-tierfilter' => 'Pohódnoćenje:',
	'readerfeedback-tier-high' => 'Wysoki',
	'readerfeedback-tier-medium' => 'Srěni',
	'readerfeedback-tier-poor' => 'Špatny',
	'tooltip-ca-ratinghist' => 'Pohódnoćenja čitarjow tuteje strony',
	'specialpages-group-feedback' => 'Měnjenje wobhladowarja',
	'readerfeedback-tt-review' => 'Přepruwowanje wotpósłać',
);

/** Hungarian (Magyar)
 * @author Adam78
 * @author Bdamokos
 * @author Bennó
 * @author Dani
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Gondnok
 * @author KossuthRad
 * @author Samat
 * @author Tgr
 */
$messages['hu'] = array(
	'readerfeedback-desc' => 'A lap értékelése lehetővé teszi az olvasóknak, hogy visszajelzést adjanak kategorikus értékelések formájában',
	'readerfeedback' => 'Mit gondolsz erről az oldalról?',
	'readerfeedback-text' => "''Arra kérünk, szánj egy percet a cikk értékelésére! A visszajelzések segítenek az oldal fejlesztésében.''",
	'readerfeedback-reliability' => 'Megbízhatóság',
	'readerfeedback-completeness' => 'Teljesség',
	'readerfeedback-npov' => 'Tárgyilagosság',
	'readerfeedback-presentation' => 'Stílus',
	'readerfeedback-overall' => 'Összességében',
	'readerfeedback-level-none' => '(bizonytalan)',
	'readerfeedback-level-0' => 'rossz',
	'readerfeedback-level-1' => 'gyenge',
	'readerfeedback-level-2' => 'átlagos',
	'readerfeedback-level-3' => 'jó',
	'readerfeedback-level-4' => 'kitűnő',
	'readerfeedback-submit' => 'Küldés',
	'readerfeedback-main' => 'Csak a tartalommal rendelkező lapokat lehet értékelni.',
	'readerfeedback-success' => "'''Köszönjük, hogy értékelted ezt a lapot!''' ([$2 eredmények]) ([$3 megjegyzések vagy kérdések]).",
	'readerfeedback-voted' => "'''Úgy tűnik, hogy már értékelted ezt a lapot.''' ([$2 eredmények]) ([$3 megjegyzések vagy kérdések]).",
	'readerfeedback-error' => "'''Hiba történt a lap értékelése közben''' ([$2 eredmények]) ([$3 megjegyzések vagy kérdések]).",
	'readerfeedback-submitting' => 'Küldés...',
	'readerfeedback-finished' => 'Köszönjük!',
	'readerfeedback-tagfilter' => 'Címke:',
	'readerfeedback-tierfilter' => 'Értékelés:',
	'readerfeedback-tier-high' => 'Kitűnő',
	'readerfeedback-tier-medium' => 'Közepes',
	'readerfeedback-tier-poor' => 'Rossz',
	'tooltip-ca-ratinghist' => 'Olvasói értékelések',
	'specialpages-group-feedback' => 'Olvasói vélemény',
	'readerfeedback-tt-review' => 'Értékelés elküldése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'readerfeedback-desc' => 'Le validation de paginas permitte que lectores da lor opinion in forma de evalutationes per categoria',
	'readerfeedback' => 'Que pensa tu de iste pagina?',
	'readerfeedback-text' => "''Dedica un momento a judicar iste pagina. Tu opinion es importante e nos adjuta a meliorar nostre sito web.''",
	'readerfeedback-reliability' => 'Accuratessa',
	'readerfeedback-completeness' => 'Completessa',
	'readerfeedback-npov' => 'Neutralitate',
	'readerfeedback-presentation' => 'Presentation',
	'readerfeedback-overall' => 'In general',
	'readerfeedback-level-none' => '(non secur)',
	'readerfeedback-level-0' => 'Mal',
	'readerfeedback-level-1' => 'Mediocre',
	'readerfeedback-level-2' => 'Acceptabile',
	'readerfeedback-level-3' => 'Bon',
	'readerfeedback-level-4' => 'Excellente',
	'readerfeedback-submit' => 'Submitter',
	'readerfeedback-main' => 'Solmente le paginas de contento pote esser judicate.',
	'readerfeedback-success' => "'''Gratias pro revider iste pagina!'''  ([$2 vider resultatos]) ([$3 commentos o questiones?]).",
	'readerfeedback-voted' => "'''Il pare que tu ha ja judicate iste pagina''' ([$2 vider resultatos]) ([$3 commentos o questiones?]).",
	'readerfeedback-error' => "'''Un error ha occurrite durante le evalutation de iste pagina''' ([$2 vider resultatos]) ([$3 commentos o questiones?]).",
	'readerfeedback-submitting' => 'Invio in curso…',
	'readerfeedback-finished' => 'Gratias!',
	'readerfeedback-tagfilter' => 'Etiquetta:',
	'readerfeedback-tierfilter' => 'Evalutation:',
	'readerfeedback-tier-high' => 'Bon',
	'readerfeedback-tier-medium' => 'Medie',
	'readerfeedback-tier-poor' => 'Mal',
	'tooltip-ca-ratinghist' => 'Evalutationes de iste pagina per le lectores',
	'specialpages-group-feedback' => 'Opinion del lector',
	'readerfeedback-tt-review' => 'Submitter recension',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'readerfeedback-desc' => 'Validasi halaman memungkinkan pengguna untuk memberikan umpan balik dalam bentuk peringkat berkategori',
	'readerfeedback' => 'Bagaimana menurut Anda halaman ini?',
	'readerfeedback-text' => "''Silakan menilai halaman di bawah ini. Umpan balik Anda sangat berharga dan membantu meningkatkan situs web ini.''",
	'readerfeedback-reliability' => 'Reliabilitas',
	'readerfeedback-completeness' => 'Kelengkapan',
	'readerfeedback-npov' => 'Kenetralan',
	'readerfeedback-presentation' => 'Penyajian',
	'readerfeedback-overall' => 'Keseluruhan',
	'readerfeedback-level-none' => '(tidak yakin)',
	'readerfeedback-level-0' => 'Buruk',
	'readerfeedback-level-1' => 'Rendah',
	'readerfeedback-level-2' => 'Sedang',
	'readerfeedback-level-3' => 'Tinggi',
	'readerfeedback-level-4' => 'Baik sekali',
	'readerfeedback-submit' => 'Kirim',
	'readerfeedback-main' => 'Hanya halaman isi yang dapat diberi nilai.',
	'readerfeedback-success' => "'''Terima kasih telah meninjau halaman ini!''' ([$2 lihat hasil]) ([$3 Komentar atau pertanyaan?])",
	'readerfeedback-voted' => "'''Tampaknya Anda sudah memberikan peringkat untuk halaman ini''' ([$2 lihat hasil])  ([$3 Komentar atau pertanyaan?])",
	'readerfeedback-error' => "'''Terdapat kesalahan selagi mereting halaman ini'''  ([$2 lihat hasil])  ([$3 komentar atau pertanyaan?]).",
	'readerfeedback-submitting' => 'Mengirimkan...',
	'readerfeedback-finished' => 'Terima kasih!',
	'readerfeedback-tagfilter' => 'Tag:',
	'readerfeedback-tierfilter' => 'Reting:',
	'readerfeedback-tier-high' => 'Besar',
	'readerfeedback-tier-medium' => 'Menengah',
	'readerfeedback-tier-poor' => 'Jelek',
	'tooltip-ca-ratinghist' => 'Penilaian pembaca atas halaman ini:',
	'specialpages-group-feedback' => 'Opini pembaca',
	'readerfeedback-tt-review' => 'Kirim tinjauan',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'readerfeedback-overall' => 'Nà íshí níle',
	'readerfeedback-level-0' => 'Ụbịàm',
	'readerfeedback-level-1' => 'Dì ànị',
	'readerfeedback-level-2' => 'Dị asọ anya',
	'readerfeedback-level-3' => 'Élú ukwu',
	'readerfeedback-submit' => 'Dànyé',
	'readerfeedback-finished' => 'Daalụ!',
	'readerfeedback-tier-high' => 'Élú ukwu',
	'readerfeedback-tier-poor' => 'Ụbịàm',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'readerfeedback-finished' => 'Danko!',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Darth Kule
 * @author Gianfranco
 * @author Melos
 * @author Pietrodn
 * @author Una giornata uggiosa '94
 */
$messages['it'] = array(
	'readerfeedback-desc' => 'La valutazione delle pagine permette ai lettori di dare un feedback sotto forma di voti per categorie',
	'readerfeedback' => 'Cosa pensi di questa pagina?',
	'readerfeedback-text' => "''Dedica un momento al giudizio della pagina. Il tuo parere è importante e ci aiuta a migliorare il nostro sito.''",
	'readerfeedback-reliability' => 'Affidabilità',
	'readerfeedback-completeness' => 'Completezza',
	'readerfeedback-npov' => 'Neutralità',
	'readerfeedback-presentation' => 'Aspetto',
	'readerfeedback-overall' => 'Complessivo',
	'readerfeedback-level-none' => '(insicuro)',
	'readerfeedback-level-0' => 'Insufficiente',
	'readerfeedback-level-1' => 'Mediocre',
	'readerfeedback-level-2' => 'Discreto',
	'readerfeedback-level-3' => 'Buono',
	'readerfeedback-level-4' => 'Ottimo',
	'readerfeedback-submit' => 'Invia',
	'readerfeedback-main' => 'Solo le pagine di contenuto possono essere valutate.',
	'readerfeedback-success' => "'''Grazie per aver verificato questa pagina!''' ([$2 vedi risultati]) ([$3 commenti o domande?]).",
	'readerfeedback-voted' => "'''Sembra che tu abbia già valutato questa pagina.''' ([$2 vedi risultati]) ([$3 commenti o domande?]).",
	'readerfeedback-error' => "'''Si è verificato un errore mentre valutavi questa pagina.''' ([$2 vedi risultati]) ([$3 commenti o domande?]).",
	'readerfeedback-submitting' => 'Invio in corso...',
	'readerfeedback-finished' => 'Grazie!',
	'readerfeedback-tagfilter' => 'Etichetta:',
	'readerfeedback-tierfilter' => 'Valutazione:',
	'readerfeedback-tier-high' => 'Alto',
	'readerfeedback-tier-medium' => 'Moderato',
	'readerfeedback-tier-poor' => 'Povero',
	'tooltip-ca-ratinghist' => 'Valutazioni dei lettori per questa pagina',
	'specialpages-group-feedback' => 'Opinione del lettore',
	'readerfeedback-tt-review' => 'Invia recensione',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author 青子守歌
 */
$messages['ja'] = array(
	'readerfeedback-desc' => '読者が尺度別評価式フィードバックによるページ評価ができるようにする',
	'readerfeedback' => 'このページをどう思いますか',
	'readerfeedback-text' => "''このページの評価にぜひご協力ください。貴重なご意見が私たちのウェブサイト改善に役立ちます。''",
	'readerfeedback-reliability' => '信頼度',
	'readerfeedback-completeness' => '完成度',
	'readerfeedback-npov' => '中立度',
	'readerfeedback-presentation' => '分かりやすさ',
	'readerfeedback-overall' => '総合',
	'readerfeedback-level-none' => '(わからない)',
	'readerfeedback-level-0' => 'ひどい',
	'readerfeedback-level-1' => '低い',
	'readerfeedback-level-2' => '可',
	'readerfeedback-level-3' => '高い',
	'readerfeedback-level-4' => 'すばらしい',
	'readerfeedback-submit' => '送信',
	'readerfeedback-main' => '評価の対象となるのは記事のみです。',
	'readerfeedback-success' => "'''評価にご協力いただきありがとうございます！'''（[$2 結果を見る]）（[$3 ご意見・お問い合わせ]）",
	'readerfeedback-voted' => "'''このページは既に評価されているようです。'''（[$2 結果を見る]）（[$3 ご意見・お問い合わせ]）",
	'readerfeedback-error' => "'''ページ評価中にエラーが発生しました。'''（[$2 結果を見る]）（[$3 ご意見・お問い合わせ]）",
	'readerfeedback-submitting' => '送信中…',
	'readerfeedback-finished' => 'ありがとうございます！',
	'readerfeedback-tagfilter' => 'タグ:',
	'readerfeedback-tierfilter' => '評価:',
	'readerfeedback-tier-high' => '高い',
	'readerfeedback-tier-medium' => '中',
	'readerfeedback-tier-poor' => 'ひどい',
	'tooltip-ca-ratinghist' => 'このページの読者による評価',
	'specialpages-group-feedback' => '読者の意見',
	'readerfeedback-tt-review' => 'レビューを送信',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Dawid Deutschland
 * @author ITshnik
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'readerfeedback' => 'რას ფიქრობთ ამ გვერდის შესახებ?',
	'readerfeedback-text' => "''გთხოვთ, გამონახეთ დრო ამ გვერდის შეფასებისათვის. თქვენი პასუხი მნიშვნელოვანია და ჩვენ დაგვეხმარება შემოთავაზების გაუმჯობესებაში.''",
	'readerfeedback-reliability' => 'სისწორე',
	'readerfeedback-completeness' => 'სისრულე',
	'readerfeedback-npov' => 'ნეიტრალობა',
	'readerfeedback-presentation' => 'პრეზენტაცია',
	'readerfeedback-overall' => 'ზოგადი შეფასება',
	'readerfeedback-level-none' => '(არაა არჩეული)',
	'readerfeedback-level-0' => 'დაბალი',
	'readerfeedback-level-1' => 'დაბალი',
	'readerfeedback-level-2' => 'საშუალო',
	'readerfeedback-level-3' => 'მაღალი',
	'readerfeedback-level-4' => 'ჩინებულია',
	'readerfeedback-submit' => 'გაგზავნა',
	'readerfeedback-main' => 'მხოლოდ შინაარსიანი გვერდები შეიძლება შეფასდეს.',
	'readerfeedback-success' => "'''გმადლობთ ამ გვერდის მიმოხილვისთვის!''' ([$2 შედეგების ჩვენება]) ([$3 კომენტარები ან შეკითხვები]).",
	'readerfeedback-voted' => "'''სავარაუდოდ თქვენ ამ გვერდს შეფასება უკვე მიეცით.''' ([$2 შედეგების ხილვა]) ([$3 კომენტარები ან კითხვები?])",
	'readerfeedback-error' => "'''ამ გვერდის შეფასებისას მოხდა რაღაც შეცდომა''' ([$2 შედეგების ხილვა]) ([$3 კომენტარები ან კითხვები?]).",
	'readerfeedback-submitting' => 'ინახება …',
	'readerfeedback-finished' => 'გმადლობთ!',
	'readerfeedback-tagfilter' => 'მინიშნება:',
	'readerfeedback-tierfilter' => 'შეფასება:',
	'readerfeedback-tier-high' => 'მაღალი',
	'readerfeedback-tier-medium' => 'საშუალო',
	'readerfeedback-tier-poor' => 'დაბალი',
	'tooltip-ca-ratinghist' => 'ამ გვერდის მკითხველთა შეფასებები',
	'specialpages-group-feedback' => 'მკიტხველის მოსაზრება!',
	'readerfeedback-tt-review' => 'გაგზავნეთ შემოწმება',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'readerfeedback-completeness' => 'ភាពសម្រេច',
	'readerfeedback-npov' => 'អព្យាក្រឹតភាព',
	'readerfeedback-presentation' => 'ការ​បង្ហាញ',
	'readerfeedback-level-0' => 'ខ្សោយ',
	'readerfeedback-level-1' => 'ទាប',
	'readerfeedback-level-2' => 'មធ្យម',
	'readerfeedback-level-3' => 'ខ្ពស់',
	'readerfeedback-level-4' => 'ល្អប្រសើរ',
	'readerfeedback-submit' => 'ដាក់ស្នើ',
	'readerfeedback-submitting' => 'កំពុង​ដាក់ស្នើ...',
	'readerfeedback-finished' => 'សូមអរគុណ!',
);

/** Korean (한국어)
 * @author Gapo
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'readerfeedback-desc' => '독자에게 부문별로 평가를 할 수 있는 피드백 양식을 제공',
	'readerfeedback' => '이 문서에 대해 어떻게 생각하십니까?',
	'readerfeedback-text' => '아래에 이 문서를 평가하는 데 잠시만 시간을 내 주십시오. 당신의 피드백은 소중하며 우리 웹 사이트를 개선하는 데 도움이 될 것입니다.',
	'readerfeedback-reliability' => '신뢰성',
	'readerfeedback-completeness' => '완성도',
	'readerfeedback-npov' => '중립성',
	'readerfeedback-presentation' => '문서의 외형',
	'readerfeedback-overall' => '종합 의견',
	'readerfeedback-level-none' => '(모름)',
	'readerfeedback-level-0' => '최하',
	'readerfeedback-level-1' => '낮음',
	'readerfeedback-level-2' => '양호',
	'readerfeedback-level-3' => '높음',
	'readerfeedback-level-4' => '우수',
	'readerfeedback-submit' => '제출',
	'readerfeedback-main' => '일반 문서만 평가할 수 있습니다.',
	'readerfeedback-success' => "'''이 문서를 평가해 주셔서 감사합니다!''' ([$2 결과 보기]) ([$3 질문이나 의견이 있으신가요?])",
	'readerfeedback-voted' => "'''당신은 이미 이 문서에 대해 평가한 것으로 보입니다.''' ([$2 결과 보기]) ([$3 의견 및 질문])",
	'readerfeedback-error' => "'''이 문서를 평가하는 도중 오류가 발생했습니다.''' ([$2 결과 보기]) ([$3 의견 및 질문])",
	'readerfeedback-submitting' => '제출하는 중...',
	'readerfeedback-finished' => '감사합니다!',
	'readerfeedback-tagfilter' => '태그:',
	'readerfeedback-tierfilter' => '평가:',
	'readerfeedback-tier-high' => '높음',
	'readerfeedback-tier-medium' => '보통',
	'readerfeedback-tier-poor' => '낮음',
	'tooltip-ca-ratinghist' => '이 문서에 대한 평가',
	'specialpages-group-feedback' => '독자 의견',
	'readerfeedback-tt-review' => '평가 제출',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'readerfeedback-desc' => 'Määt et müjjelesch för der Lesser, noh sing Enschäzung för Sigge beshtemmpte Zoote vun Note ze verdeile.',
	'readerfeedback' => 'Wat dengkß De övver hee di Sigg?',
	'readerfeedback-text' => "''Beß esu joot un donn Der ene Momang nämme, öm dä Sigg hee dronge Note ze jävve. Ding Enschäzung hät iere Wäät un hellef met, de Websigge hee bäßer ze maache.''",
	'readerfeedback-reliability' => 'De Zohverläßeschkeit',
	'readerfeedback-completeness' => 'De Vollschtändeschkeit',
	'readerfeedback-npov' => 'De Onaffhängeschkeit',
	'readerfeedback-presentation' => 'Der Presenteer',
	'readerfeedback-overall' => 'Zersamme jenumme',
	'readerfeedback-level-none' => '(onsescher)',
	'readerfeedback-level-0' => 'Schlääsch',
	'readerfeedback-level-1' => 'Jenöösch',
	'readerfeedback-level-2' => 'Jeiht esu',
	'readerfeedback-level-3' => 'Joot',
	'readerfeedback-level-4' => 'Exzälänt',
	'readerfeedback-submit' => 'Lohß Jonn!',
	'readerfeedback-main' => 'Do kanns bloß esu en Sigge benote, woh em Wiki singe Enhalld drop shteiht.',
	'readerfeedback-success' => "'''Mer bedanke uns för et Nohkike vun hee dä Sigg!''' — ([$2 Wat erus jekumme es]) ([$3 Noch Bemerkunge udder Froore?])",
	'readerfeedback-voted' => "'''Et süüht esu uß, als hätts De för hee di Sigg ald Note enjedraare.'''  — ([$2 Wat erus jekumme es]) ([$3 Noch Bemerkunge udder Froore?])",
	'readerfeedback-error' => "'''Ene Fähler es opjetrodde bem Enschäze vun heh dä Sigg'''  — ([$2 Wat erus jekumme es]) ([$3 Hadd_Er Aanmerkunge udder Froore?])",
	'readerfeedback-submitting' => 'Am Övverdraare&nbsp;…',
	'readerfeedback-finished' => 'Ene schöne Dangk och!',
	'readerfeedback-tagfilter' => 'Makeerung:',
	'readerfeedback-tierfilter' => 'Ennschäzung:',
	'readerfeedback-tier-high' => 'Supper',
	'readerfeedback-tier-medium' => 'Meddelmääßesch',
	'readerfeedback-tier-poor' => 'Mau',
	'tooltip-ca-ratinghist' => 'Wi de Lesser hee di Sigg ennschäze un wat se ier för Note jävve',
	'specialpages-group-feedback' => 'Enschäzunge vum Lesser',
	'readerfeedback-tt-review' => 'Ennschäzung afjävve',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'readerfeedback-level-3' => 'Bilind',
	'readerfeedback-finished' => 'Spas!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'readerfeedback-desc' => 'Page validation erlaabt dem Lieser e Feedback a Form vun enger Bewäertung mat Kategorien ze ginn',
	'readerfeedback' => 'Wat haalt Dir vun dëser Säit?',
	'readerfeedback-text' => "''Huelt Iech w.e.g. e Moment fir dës Säit ze bewerten. Äre Feedback ass wertvoll an hëlleft eis eisen Internet-Site ze verbesseren.''",
	'readerfeedback-reliability' => 'Zouverlässigkeet',
	'readerfeedback-completeness' => 'Vollständegkeet',
	'readerfeedback-npov' => 'Neutralitéit',
	'readerfeedback-presentation' => 'Presentatioun',
	'readerfeedback-overall' => 'Am Ganzen',
	'readerfeedback-level-none' => '(onsécher)',
	'readerfeedback-level-0' => 'Schwaach',
	'readerfeedback-level-1' => 'Niddereg',
	'readerfeedback-level-2' => 'Fair',
	'readerfeedback-level-3' => 'Héich',
	'readerfeedback-level-4' => 'Exzellent',
	'readerfeedback-submit' => 'Späicheren',
	'readerfeedback-main' => 'Nëmme Säite mat Inhalt kënne bewert ginn.',
	'readerfeedback-success' => "'''Merci datt Dir dës Säit bewert hutt!'''([$2 Resultater kucken]) ([$3 Bemierkungen oder Froen?]).",
	'readerfeedback-voted' => "'''Et schéngt wéi wann Dir dës Säit scho bewert hutt''' ([$2 Resultater kucken]) ([$3 Bemierkungen oder Froen?]).",
	'readerfeedback-error' => "'''Beim Bewäerte vun dëser Säit ass e Feeler geschitt''' ([$2 Resultater kucken]) ([$3 Bemierkungen a Froen?]).",
	'readerfeedback-submitting' => 'Späicheren ...',
	'readerfeedback-finished' => 'Merci!',
	'readerfeedback-tagfilter' => 'Markéierung:',
	'readerfeedback-tierfilter' => 'Bewäertung',
	'readerfeedback-tier-high' => 'Héich',
	'readerfeedback-tier-medium' => 'Duerchschnëttlech',
	'readerfeedback-tier-poor' => 'Aarmséileg',
	'tooltip-ca-ratinghist' => 'Lieserbewertunge vun dëser Säit',
	'specialpages-group-feedback' => 'Meenung vun deem dee kuckt',
	'readerfeedback-tt-review' => 'Bewäertung fortschécken',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'readerfeedback-desc' => 'Paginavalidatie laet laezers trukkoppeling gaeven in de vorm van categoriale beoeardeilinge',
	'readerfeedback' => 'Waat vinjs se van dees pazjena?',
	'readerfeedback-text' => "''Nöm de möjde om dees pagina hieronger te waardere.
Diene feedback is waerdevol en help os dees website te verbaetere.''",
	'readerfeedback-reliability' => 'Betroewberhed',
	'readerfeedback-completeness' => 'Vólledighed',
	'readerfeedback-npov' => 'Neutraliteit',
	'readerfeedback-presentation' => 'Presentatie',
	'readerfeedback-overall' => 'Algemein',
	'readerfeedback-level-none' => '(ónwis)',
	'readerfeedback-level-0' => 'Wórd',
	'readerfeedback-level-1' => 'Lieëg',
	'readerfeedback-level-2' => 'Good',
	'readerfeedback-level-3' => 'Hoeag',
	'readerfeedback-level-4' => 'Perfèk',
	'readerfeedback-submit' => 'Slaon óp',
	'readerfeedback-main' => 'Allein inhawd kins se wardere.',
	'readerfeedback-success' => "'''Danke veur 't beoeardeile hievan!''' ([$2 rizzeltate]) ([$3 opmerkinge/vraoge])",
	'readerfeedback-voted' => "'''De hes hie al n beoeardeiling gedaan.''' ([$2 resultate]) ([$3 opmerkinge/vraoge])",
	'readerfeedback-error' => "'''Fout bie paginaboeardeile''' ([$2 resultate]) ([$3 opmerkinge/vraogen])",
	'readerfeedback-submitting' => 'Ópslaondje...',
	'readerfeedback-finished' => 'Danke!',
	'readerfeedback-tagfilter' => 'Label:',
	'readerfeedback-tierfilter' => 'Waardering:',
	'readerfeedback-tier-high' => 'Hoeag',
	'readerfeedback-tier-medium' => 'Middelmaotig',
	'readerfeedback-tier-poor' => 'Wórd',
	'tooltip-ca-ratinghist' => 'Waardering van dees pagina door laezers',
	'specialpages-group-feedback' => 'Meining van de laezer',
	'readerfeedback-tt-review' => 'Slaon beoeardeiling óp',
);

/** Lumbaart (Lumbaart)
 * @author Dakrismeno
 */
$messages['lmo'] = array(
	'readerfeedback' => "Cus'è che te penset de quela pagina chì?",
	'readerfeedback-text' => "''Per piasì töva un mument per vutà 'sta pàgina chì suta. La tua upinión a l'è impurtanta e la jüta a mejurà 'l nòst sit web.''",
	'readerfeedback-reliability' => 'Afidabilità',
	'readerfeedback-completeness' => 'Cumpleteza',
	'readerfeedback-npov' => 'Neutralità',
	'readerfeedback-presentation' => 'Presentazión',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'readerfeedback-level-none' => '(nežinau)',
	'readerfeedback-level-0' => 'Prastas',
	'readerfeedback-level-1' => 'Žemas',
	'readerfeedback-level-2' => 'Geras',
	'readerfeedback-level-3' => 'Aukštas',
	'readerfeedback-level-4' => 'Puikus',
	'readerfeedback-submit' => 'Siųsti',
	'readerfeedback-submitting' => 'Siunčiama ...',
	'readerfeedback-finished' => 'Ačiū!',
	'readerfeedback-tagfilter' => 'Žymė:',
	'readerfeedback-tierfilter' => 'Reitingas:',
	'readerfeedback-tier-high' => 'Aukštas',
	'readerfeedback-tier-medium' => 'Moderuoti',
	'readerfeedback-tier-poor' => 'Prastas',
	'readerfeedback-tt-review' => 'Siųsti apžvalgą',
);

/** Latvian (Latviešu)
 * @author Geimeris
 * @author Papuass
 */
$messages['lv'] = array(
	'readerfeedback' => 'Ko Jūs domājat par šo lapu?',
	'readerfeedback-reliability' => 'Uzticamība',
	'readerfeedback-completeness' => 'Pilnīgums',
	'readerfeedback-npov' => 'Neitralitāte',
	'readerfeedback-level-none' => '(nezinu)',
	'readerfeedback-level-1' => 'Zema',
	'readerfeedback-level-2' => 'Pietiekama',
	'readerfeedback-level-3' => 'Augsta',
	'readerfeedback-submit' => 'Iesniegt',
	'readerfeedback-main' => 'Vērtēt var tikai satura lapas.',
	'readerfeedback-finished' => 'Paldies!',
	'readerfeedback-tierfilter' => 'Vērtējums:',
	'readerfeedback-tier-high' => 'Augsts',
	'readerfeedback-tier-medium' => 'Vidējs',
	'readerfeedback-tier-poor' => 'Zems',
	'readerfeedback-tt-review' => 'Iesniegt atsauksmi',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'readerfeedback-desc' => 'Потврдувањето на страницата им дава можност на читателите да искажат свое мислење во облик на категорични оценки',
	'readerfeedback' => 'Што мислите за оваа страница?',
	'readerfeedback-text' => "''Ве молиме одвојте малку време да ја оцените страницава подолу. Вашите мислења се значајни и ни помагаат да ја подобриме страницата.''",
	'readerfeedback-reliability' => 'Доверливост',
	'readerfeedback-completeness' => 'Целосност',
	'readerfeedback-npov' => 'Неутралност',
	'readerfeedback-presentation' => 'Презентација',
	'readerfeedback-overall' => 'Севкупно',
	'readerfeedback-level-none' => '(неопределено)',
	'readerfeedback-level-0' => 'Слаба',
	'readerfeedback-level-1' => 'Ниска',
	'readerfeedback-level-2' => 'Средна',
	'readerfeedback-level-3' => 'Висока',
	'readerfeedback-level-4' => 'Одлична',
	'readerfeedback-submit' => 'Поднеси',
	'readerfeedback-main' => 'Може да се оценуваат само содржински страници.',
	'readerfeedback-success' => "'''Ви благодариме што ја оценивте страницата!''' ([$2 видете резултати]) ([$3 коментари или прашања?]).",
	'readerfeedback-voted' => "'''Изгледа дека веќе сте ја оцениле оваа страница''' ([$2 видете резултати]) ([$3 коментари и прашања?]).",
	'readerfeedback-error' => "'''Настана грешка при оценувањето на оваа страница''' ([$2 видете резултати]) ([$3 коментари и прашања?]).",
	'readerfeedback-submitting' => 'Поднесувам...',
	'readerfeedback-finished' => 'Ви благодариме!',
	'readerfeedback-tagfilter' => 'Ознака:',
	'readerfeedback-tierfilter' => 'Оценка:',
	'readerfeedback-tier-high' => 'Високо',
	'readerfeedback-tier-medium' => 'Средно',
	'readerfeedback-tier-poor' => 'Слабо',
	'tooltip-ca-ratinghist' => 'Оценки на читателите за оваа страница',
	'specialpages-group-feedback' => 'Мислења од читателите',
	'readerfeedback-tt-review' => 'Поднеси оценка',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'readerfeedback-desc' => 'വർഗ്ഗീകൃത നിലവാരമളക്കൽ പോലെ വായനക്കാർക്ക് അവരുടെ അഭിപ്രായം വഴി താൾ മൂല്യനിർണ്ണയം ചെയ്യാനുള്ള അവസരം നൽകുന്നു.',
	'readerfeedback' => 'ഈ താളിനെ കുറിച്ച് താങ്കൾ എന്തു കരുതുന്നു?',
	'readerfeedback-text' => "''ഈ താളിന്റെ നിലവാരം കണ്ടെത്താൻ ഒരു നിമിഷം ചിലവഴിക്കൂ. താങ്കളുടെ അഭിപ്രായങ്ങൾ വിലയേറിയതും വെബ്‌‌സൈറ്റ് മെച്ചപ്പെടുത്താൻ ഞങ്ങളെ സഹായിക്കുന്നതുമാണ്.''",
	'readerfeedback-reliability' => 'വിശ്വാസയോഗ്യത',
	'readerfeedback-completeness' => 'പൂർണ്ണത',
	'readerfeedback-npov' => 'നിഷ്പക്ഷത',
	'readerfeedback-presentation' => 'പ്രദർശനഗുണം',
	'readerfeedback-overall' => 'എല്ലാംകൂടി',
	'readerfeedback-level-none' => '(ഉറപ്പില്ല)',
	'readerfeedback-level-0' => 'ദരിദ്രം',
	'readerfeedback-level-1' => 'മോശം',
	'readerfeedback-level-2' => 'കൊള്ളാം',
	'readerfeedback-level-3' => 'ഉന്നതം',
	'readerfeedback-level-4' => 'ഒന്നാന്തരം',
	'readerfeedback-submit' => 'സമർപ്പിക്കുക',
	'readerfeedback-main' => 'ഉള്ളടക്ക താളുകളുടെ മാറ്റം നിലവാരമളന്നാൽ മതി.',
	'readerfeedback-success' => "'''ഈ താൾ സംശോധനം ചെയ്തതിനു നന്ദി അറിയിക്കുന്നു!''' ([$2 ഫലങ്ങൾ കാണുക]) ([$3 അഭിപ്രായങ്ങൾ അല്ലെങ്കിൽ ചോദ്യങ്ങൾ?]).",
	'readerfeedback-voted' => "'''ഈ താളിന്റെ മൂല്യനിർണ്ണയം താങ്കൾ നേരത്തേ ചെയ്തിട്ടുണ്ടെന്നു കാണുന്നു''' ([$2 ഫലങ്ങൾ കാണുക]) ([$3 അഭിപ്രായങ്ങൾ അല്ലെങ്കിൽ ചോദ്യങ്ങൾ?]).",
	'readerfeedback-error' => "'''ഈ താളിന്റെ മൂല്യനിർണ്ണയത്തിനിടയ്ക്ക് പിഴവ് സംഭവിച്ചിരിക്കുന്നു''' ([$2 ഫലങ്ങൾ കാണുക]) ([$3 അഭിപ്രായങ്ങൾ അല്ലെങ്കിൽ ചോദ്യങ്ങൾ?]).",
	'readerfeedback-submitting' => 'സമർപ്പിക്കുന്നു …',
	'readerfeedback-finished' => 'നന്ദി!',
	'readerfeedback-tagfilter' => 'റ്റാഗ്:',
	'readerfeedback-tierfilter' => 'മതിപ്പ് നിലവാരം:',
	'readerfeedback-tier-high' => 'ഉന്നതം',
	'readerfeedback-tier-medium' => 'സാമാന്യം',
	'readerfeedback-tier-poor' => 'മോശം',
	'tooltip-ca-ratinghist' => 'വായനക്കാർ ഈ താളിനു നൽകിയ നിലവാരം',
	'specialpages-group-feedback' => 'വായനക്കാരുടെ അഭിപ്രായം',
	'readerfeedback-tt-review' => 'സംശോധനം സമർപ്പിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'readerfeedback-submit' => 'Явуулах',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 */
$messages['ms'] = array(
	'readerfeedback-desc' => 'Pengesahan laman yang membolehkan pembaca untuk memberikan maklum balas dalam bentuk penilaian kategori',
	'readerfeedback' => 'Apakah pandangan anda mengenai laman ini?',
	'readerfeedback-text' => "''Sila luangkan sedikit masa untuk memberi penilaian kepada laman ini. Maklum balas anda amatlah dihargai dan diperlukan untuk memperbaiki tapak web kami.''",
	'readerfeedback-reliability' => 'Kebolehpercayaan',
	'readerfeedback-completeness' => 'Kesempurnaan',
	'readerfeedback-npov' => 'Kekecualian',
	'readerfeedback-presentation' => 'Persembahan',
	'readerfeedback-overall' => 'Keseluruhan',
	'readerfeedback-level-none' => '(tidak pasti)',
	'readerfeedback-level-0' => 'Lemah',
	'readerfeedback-level-1' => 'Rendah',
	'readerfeedback-level-2' => 'Sederhana',
	'readerfeedback-level-3' => 'Tinggi',
	'readerfeedback-level-4' => 'Cemerlang',
	'readerfeedback-submit' => 'Hantar',
	'readerfeedback-main' => 'Hanya laman kandungan boleh diberi penilaian.',
	'readerfeedback-success' => "'''Terima kasih kerana mengulas laman ini!''' ([$2 lihat hasil]) ([$3 ada komen atau soalan?]).",
	'readerfeedback-voted' => "'''Nampaknya anda sudah menilai laman ini''' ([$2 lihat hasil]) ([$3 ada komen atau soalan?]).",
	'readerfeedback-error' => "'''Berlakunya ralat ketika menilai laman ini''' ([$2 lihat hasil]) ([$3 ada komen atau soalan?]).",
	'readerfeedback-submitting' => 'Menyerah...',
	'readerfeedback-finished' => 'Terima kasih!',
	'readerfeedback-tagfilter' => 'Tag:',
	'readerfeedback-tierfilter' => 'Penilaian:',
	'readerfeedback-tier-high' => 'Tinggi',
	'readerfeedback-tier-medium' => 'Sederhana',
	'readerfeedback-tier-poor' => 'Lemah',
	'tooltip-ca-ratinghist' => 'Penilaian pembaca',
	'specialpages-group-feedback' => 'Pendapat pembaca',
	'readerfeedback-tt-review' => 'Serahkan ulasan',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'readerfeedback-level-0' => 'Лавшо',
	'readerfeedback-level-1' => 'Алкыне',
	'readerfeedback-level-2' => 'А берянь',
	'readerfeedback-level-3' => 'Вадря-паро',
	'readerfeedback-level-4' => 'Эйне вадря',
	'readerfeedback-finished' => 'Сюк пря!',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'readerfeedback-submitting' => 'Moihuacah...',
	'readerfeedback-finished' => '¡Tlazohcāmati!',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author EivindJ
 * @author H92
 * @author Harald Khan
 * @author Jon Harald Søby
 * @author Kph
 * @author Laaknor
 * @author Meno25
 * @author Nghtwlkr
 * @author Stigmj
 */
$messages['nb'] = array(
	'readerfeedback-desc' => 'Sidebedømmelse gir mulighet for lese å gi tilbakemeldinger innen flere kategorier',
	'readerfeedback' => 'Hva synes du om denne siden?',
	'readerfeedback-text' => "''Vennligst ta noen minutter for å vurdere denne siden nedenfor. Din tilbakemelding er verdifull og hjelper oss med å forbedre nettstedet vårt.''",
	'readerfeedback-reliability' => 'Pålitelighet',
	'readerfeedback-completeness' => 'Fullstendighet',
	'readerfeedback-npov' => 'Nøytralitet',
	'readerfeedback-presentation' => 'Presentasjon',
	'readerfeedback-overall' => 'Helhetsinntrykk',
	'readerfeedback-level-none' => '(usikker)',
	'readerfeedback-level-0' => 'Veldig dårlig',
	'readerfeedback-level-1' => 'Dårlig',
	'readerfeedback-level-2' => 'OK',
	'readerfeedback-level-3' => 'Bra',
	'readerfeedback-level-4' => 'Veldig bra',
	'readerfeedback-submit' => 'Send',
	'readerfeedback-main' => 'Kun innholdssider kan vurderes.',
	'readerfeedback-success' => "'''Takk for at du anmeldte denne siden!''' ([$2 se resultat]) ([$3 kommentarer eller spørsmål?]).",
	'readerfeedback-voted' => "'''Det ser ut til at du allerede har anmeldt denne siden''' ([$2 se resultat]) ([$3 kommentarer eller spørsmål?]).",
	'readerfeedback-error' => "'''En feil oppsto mens siden ble anmeldt''' ([$2 se resultat]) ([$3 kommentarer eller spørsmål?]).",
	'readerfeedback-submitting' => 'Sender …',
	'readerfeedback-finished' => 'Takk!',
	'readerfeedback-tagfilter' => 'Tagg:',
	'readerfeedback-tierfilter' => 'Karakter:',
	'readerfeedback-tier-high' => 'Høy',
	'readerfeedback-tier-medium' => 'Middels',
	'readerfeedback-tier-poor' => 'Dårlig',
	'tooltip-ca-ratinghist' => 'Leservurderinger av denne siden',
	'specialpages-group-feedback' => 'Mening fra leser',
	'readerfeedback-tt-review' => 'Send vurdering',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'readerfeedback-desc' => 'Paginavalidatie laat lezers terugkoppeling geven in de vorm van categoriale beoordelingen',
	'readerfeedback' => 'Wat vindt u van deze pagina?',
	'readerfeedback-text' => "''Neem de moeite om deze pagina hieronder te waarderen.
Uw terugkoppeling is waardevol en helpt ons deze website te verbeteren.''",
	'readerfeedback-reliability' => 'Betrouwbaarheid',
	'readerfeedback-completeness' => 'Volledigheid',
	'readerfeedback-npov' => 'Neutraliteit',
	'readerfeedback-presentation' => 'Presentatie',
	'readerfeedback-overall' => 'Algemeen',
	'readerfeedback-level-none' => '(weet niet)',
	'readerfeedback-level-0' => 'Slecht',
	'readerfeedback-level-1' => 'Laag',
	'readerfeedback-level-2' => 'In orde',
	'readerfeedback-level-3' => 'Hoog',
	'readerfeedback-level-4' => 'Uitstekend',
	'readerfeedback-submit' => 'Opslaan',
	'readerfeedback-main' => "Alleen pagina's uit de hoofdnaamruimte kunnen gewaardeerd worden.",
	'readerfeedback-success' => "'''Dank u wel voor het waarderen van deze pagina.''' ([$2 resultaten]) ([$3 opmerkingen of vragen?])",
	'readerfeedback-voted' => "'''U hebt al een waardering voor deze pagina opgegeven.''' ([$2 resultaten]) ([$3 opmerkingen of vragen?])",
	'readerfeedback-error' => "'''Er is een fout opgetreden bij het waarderen van deze pagina''' ([$2 resultaten]) ([$3 opmerkingen of vragen?])",
	'readerfeedback-submitting' => 'Bezig met opslaan…',
	'readerfeedback-finished' => 'Bedankt!',
	'readerfeedback-tagfilter' => 'Label:',
	'readerfeedback-tierfilter' => 'Waardering:',
	'readerfeedback-tier-high' => 'Hoog',
	'readerfeedback-tier-medium' => 'Gemiddeld',
	'readerfeedback-tier-poor' => 'Laag',
	'tooltip-ca-ratinghist' => 'Waardering van deze pagina door lezers',
	'specialpages-group-feedback' => 'Mening van de lezer',
	'readerfeedback-tt-review' => 'Beoordeling opslaan',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'readerfeedback' => 'Kva tykkjer du om denne sida?',
	'readerfeedback-text' => "''Nytt gjerne nokre minutt for å vurdera denne sida gjennom vala nedanfor. Tilbakemeldinga di er verdifull og hjelper oss med å betra nettstaden vår.''",
	'readerfeedback-reliability' => 'Truverde',
	'readerfeedback-completeness' => 'Utførleg',
	'readerfeedback-npov' => 'Nøytralitet',
	'readerfeedback-presentation' => 'Presentasjon',
	'readerfeedback-overall' => 'Heilsleg oppfatning',
	'readerfeedback-level-none' => '(usikker)',
	'readerfeedback-level-0' => 'Sers dårleg',
	'readerfeedback-level-1' => 'Dårleg',
	'readerfeedback-level-2' => 'OK',
	'readerfeedback-level-3' => 'Bra',
	'readerfeedback-level-4' => 'Sers bra',
	'readerfeedback-submit' => 'Send',
	'readerfeedback-main' => 'Berre innhaldssider kan verta vurderte.',
	'readerfeedback-success' => "'''Takk for at du vurderte denne sida!''' ([$3 Kommentarar eller spørsmål?])",
	'readerfeedback-voted' => "'''Du har alt vurdert denne sida.''' ([$3 Kommentarar eller spørsmål?])",
	'readerfeedback-submitting' => 'Leverer …',
	'readerfeedback-finished' => 'Takk!',
	'readerfeedback-tier-high' => 'Høg',
	'tooltip-ca-ratinghist' => 'Lesarvurderingar av sida',
	'specialpages-group-feedback' => 'Meining frå lesar',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'readerfeedback-desc' => 'La validacion d’articles permet als lectors de balhar lor vejaire jos forma d’evaluacions per categoria',
	'readerfeedback' => "Qué pensatz d'aquesta pagina ?",
	'readerfeedback-text' => "''Consacratz un moment per notar aquesta pagina çaijós. Vòstras impressions son preciosas e nos ajudan a melhorar nòstre site internet.''",
	'readerfeedback-reliability' => 'Fisabilitat',
	'readerfeedback-completeness' => 'Estat complet',
	'readerfeedback-npov' => 'Neutralitat',
	'readerfeedback-presentation' => 'Presentacion',
	'readerfeedback-overall' => 'General',
	'readerfeedback-level-none' => '(pas segur)',
	'readerfeedback-level-0' => 'Paure',
	'readerfeedback-level-1' => 'Bas',
	'readerfeedback-level-2' => 'Polit',
	'readerfeedback-level-3' => 'Naut',
	'readerfeedback-level-4' => 'Excellent',
	'readerfeedback-submit' => 'Sometre',
	'readerfeedback-main' => 'Sol lo contengut de las paginas pòt èsser notat.',
	'readerfeedback-success' => "'''Mercés per a aver relegit aquesta pagina ! ''' ([$2 veire los resultats]) ([$3 De questions o de comentaris ? ]).",
	'readerfeedback-voted' => "'''Sembla que ja avètz evalorat aquesta pagina''' ([$2 veire los resultats]) ([$3 De questions o de comentaris ?]).",
	'readerfeedback-error' => "'''Una error s'es producha al moment de l'avaloracion d'aquesta pagina''' ([$2 veire los resultats]) ([$3 remarcas o questions ?]).",
	'readerfeedback-submitting' => 'Somission…',
	'readerfeedback-finished' => 'Mercés !',
	'readerfeedback-tagfilter' => 'Balisa :',
	'readerfeedback-tierfilter' => 'Avaloracion :',
	'readerfeedback-tier-high' => 'Bona',
	'readerfeedback-tier-medium' => 'Mejana',
	'readerfeedback-tier-poor' => 'Marrida',
	'tooltip-ca-ratinghist' => "Apreciacions dels lectors d'aquesta pagina",
	'specialpages-group-feedback' => 'Opinion del lector',
	'readerfeedback-tt-review' => 'Sometre la revision',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 */
$messages['or'] = array(
	'readerfeedback-reliability' => 'ବିଶ୍ଵସନୀୟତା',
	'readerfeedback-npov' => 'ନିରପେକ୍ଷତା',
	'readerfeedback-overall' => 'ସବୁ ମିଶିକରି',
	'readerfeedback-submit' => 'ଦାଖଲ କରିବା',
	'readerfeedback-finished' => 'ଆପଣଙ୍କୁ ଧନ୍ୟବାଦ!',
	'readerfeedback-tagfilter' => 'ଟାଗ:',
	'readerfeedback-tier-medium' => 'ମଧ୍ୟମ',
);

/** Polish (Polski)
 * @author Beau
 * @author Derbeth
 * @author Holek
 * @author Jwitos
 * @author Leinad
 * @author Maikking
 * @author McMonster
 * @author Nux
 * @author Pimke
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'readerfeedback-desc' => 'Ocenianie stron pozwala czytelnikom przedstawić swoją opinię w formie kategoryzacji',
	'readerfeedback' => 'Co myślisz o tej stronie?',
	'readerfeedback-text' => "''Poświęć chwilę, aby ocenić tę stronę. Twoja opinia jest ważna i pomoże nam w ulepszeniu naszej witryny.''",
	'readerfeedback-reliability' => 'Wiarygodność',
	'readerfeedback-completeness' => 'Wyczerpanie tematu',
	'readerfeedback-npov' => 'Neutralność',
	'readerfeedback-presentation' => 'Zrozumiałość',
	'readerfeedback-overall' => 'Ogólnie',
	'readerfeedback-level-none' => '(nie wiem)',
	'readerfeedback-level-0' => 'niedostatecznie',
	'readerfeedback-level-1' => 'słabo',
	'readerfeedback-level-2' => 'zadowalająco',
	'readerfeedback-level-3' => 'dobrze',
	'readerfeedback-level-4' => 'bardzo dobrze',
	'readerfeedback-submit' => 'Zapisz',
	'readerfeedback-main' => 'Oceniać można wyłącznie strony z artykułami.',
	'readerfeedback-success' => "'''Dziękujemy za ocenę strony!''' ([$2 wyniki]) ([$3 uwagi lub pytania]).",
	'readerfeedback-voted' => "'''Prawdopodobnie już {{GENDER:|oceniałeś|oceniałaś|oceniałeś(‐aś)}} tę stronę''' ([$2 zobacz wyniki]) ([$3 komentarze lub pytania]).",
	'readerfeedback-error' => "'''Podczas oceniania strony wystąpił błąd''' ([$2 wyniki]) ([$3 komentarze lub pytania]).",
	'readerfeedback-submitting' => 'Zapisywanie...',
	'readerfeedback-finished' => 'Dziękujemy!',
	'readerfeedback-tagfilter' => 'Znacznik',
	'readerfeedback-tierfilter' => 'Ocena:',
	'readerfeedback-tier-high' => 'wysoka',
	'readerfeedback-tier-medium' => 'umiarkowana',
	'readerfeedback-tier-poor' => 'słaba',
	'tooltip-ca-ratinghist' => 'Oceny czytelników tej strony',
	'specialpages-group-feedback' => 'Opinia czytelnika',
	'readerfeedback-tt-review' => 'Prześlij wynik sprawdzenia',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'readerfeedback-desc' => 'La validassion ëd la pàgina a përmet ai letor dë smon-e soa opinion an forma ëd pontegi categorisà',
	'readerfeedback' => "Lòn ch'it pense dë sta pàgina-sì?",
	'readerfeedback-text' => "''Për piasì pija un moment për voté sta pàgina sì-sota. Toa opinion a l'é amportanta e an giuta a mijoré nòst sit.''",
	'readerfeedback-reliability' => 'Afidabilità',
	'readerfeedback-completeness' => 'Completëssa',
	'readerfeedback-npov' => 'Neutralità',
	'readerfeedback-presentation' => 'Presentassion',
	'readerfeedback-overall' => 'Complessiv',
	'readerfeedback-level-none' => '(nen sicur)',
	'readerfeedback-level-0' => 'Pòver',
	'readerfeedback-level-1' => 'Bass',
	'readerfeedback-level-2' => 'Discret',
	'readerfeedback-level-3' => 'Àut',
	'readerfeedback-level-4' => 'Ecelent',
	'readerfeedback-submit' => 'Spediss',
	'readerfeedback-main' => 'Mach pàgine ëd contnù a peulo esse votà.',
	'readerfeedback-success' => "'''Mersì për avèj revisionà sta pàgina-sì!''' ([$2 varda arzultà]) ([$3 coment o custion?]).",
	'readerfeedback-voted' => "'''A smija ch'it l'abie già votà sta pàgina-sì''' ([$2 varda arzultà]) ([$3 coment o custion?]).",
	'readerfeedback-error' => "'''A l'é capitaje n'eror an votand sta pàgina-sì''' ([$2 varda arzultà)] ([$3 coment  custion?]).",
	'readerfeedback-submitting' => 'Spedì ...',
	'readerfeedback-finished' => 'Mersì!',
	'readerfeedback-tagfilter' => 'Tichëtta:',
	'readerfeedback-tierfilter' => 'Vot:',
	'readerfeedback-tier-high' => 'Àut',
	'readerfeedback-tier-medium' => 'Moderà',
	'readerfeedback-tier-poor' => 'Pòver',
	'tooltip-ca-ratinghist' => 'Vot dij letor dë sta pàgina-sì',
	'specialpages-group-feedback' => 'Opinion dij visualisator',
	'readerfeedback-tt-review' => 'Spediss revision',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'readerfeedback-completeness' => 'بشپړتابه',
	'readerfeedback-overall' => 'ټولټال',
	'readerfeedback-level-none' => '(ناډاډه)',
	'readerfeedback-level-0' => 'خراب',
	'readerfeedback-level-1' => 'ټيټ',
	'readerfeedback-level-3' => 'لوړ',
	'readerfeedback-level-4' => 'وتلی',
	'readerfeedback-submit' => 'سپارل',
	'readerfeedback-submitting' => 'د سپارلو په حال کې ...',
	'readerfeedback-finished' => 'مننه!',
	'readerfeedback-tierfilter' => 'ارزونه:',
	'readerfeedback-tier-high' => 'لوړ',
	'readerfeedback-tier-medium' => 'منځوی',
	'readerfeedback-tier-poor' => 'خراب',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Raylton P. Sousa
 * @author Waldir
 */
$messages['pt'] = array(
	'readerfeedback-desc' => 'A validação de páginas permite que os leitores as avaliem, atribuindo-lhes avaliações categóricas',
	'readerfeedback' => 'O que acha desta página?',
	'readerfeedback-text' => "''Por favor, dedique um momento a avaliar esta página. A sua opinião é importante e ajuda-nos a melhorar o ''site''.''",
	'readerfeedback-reliability' => 'Confiabilidade',
	'readerfeedback-completeness' => 'Abrangência',
	'readerfeedback-npov' => 'Neutralidade',
	'readerfeedback-presentation' => 'Apresentação',
	'readerfeedback-overall' => 'em Geral',
	'readerfeedback-level-none' => '(incerto)',
	'readerfeedback-level-0' => 'Péssima',
	'readerfeedback-level-1' => 'Baixa',
	'readerfeedback-level-2' => 'Razoável',
	'readerfeedback-level-3' => 'Alta',
	'readerfeedback-level-4' => 'Excelente',
	'readerfeedback-submit' => 'Enviar',
	'readerfeedback-main' => 'Só páginas de conteúdo podem ser avaliadas.',
	'readerfeedback-success' => "'''Obrigado por avaliar esta página!''' ([$2 ver resultados]) ([$3 comentários ou dúvidas?]).",
	'readerfeedback-voted' => "'''Aparentemente já avaliou esta página''' ([$2 ver resultados]) ([$3 comentários ou dúvidas?]).",
	'readerfeedback-error' => "'''Ocorreu um erro ao avaliar esta página''' ([$2 ver resultados]) ([$3 comentários ou dúvidas?])",
	'readerfeedback-submitting' => 'Enviando...',
	'readerfeedback-finished' => 'Obrigado!',
	'readerfeedback-tagfilter' => 'Etiqueta:',
	'readerfeedback-tierfilter' => 'Avaliação:',
	'readerfeedback-tier-high' => 'Elevado',
	'readerfeedback-tier-medium' => 'Moderado',
	'readerfeedback-tier-poor' => 'Pobre',
	'tooltip-ca-ratinghist' => 'Opinião dos leitores sobre esta página',
	'specialpages-group-feedback' => 'Opinião dos leitores',
	'readerfeedback-tt-review' => 'Enviar revisão',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Luckas Blade
 * @author Raylton P. Sousa
 */
$messages['pt-br'] = array(
	'readerfeedback-desc' => 'A validação de páginas permite que os leitores as avaliem, atribuindo-lhes avaliações categóricas',
	'readerfeedback' => 'O que você acha desta página?',
	'readerfeedback-text' => "''Por gentileza, dedique um momento para avaliar esta página. Sua opinião é importante e nos ajuda a melhorar o website.''",
	'readerfeedback-reliability' => 'Confiabilidade',
	'readerfeedback-completeness' => 'Abrangência',
	'readerfeedback-npov' => 'Neutralidade',
	'readerfeedback-presentation' => 'Apresentação',
	'readerfeedback-overall' => 'Em geral',
	'readerfeedback-level-none' => '(incerto)',
	'readerfeedback-level-0' => 'Péssima',
	'readerfeedback-level-1' => 'Baixa',
	'readerfeedback-level-2' => 'Razoável',
	'readerfeedback-level-3' => 'Alta',
	'readerfeedback-level-4' => 'Excelente',
	'readerfeedback-submit' => 'Enviar',
	'readerfeedback-main' => 'Só páginas de conteúdo podem ser avaliadas.',
	'readerfeedback-success' => "'''Obrigado por avaliar esta página!''' ([$2 ver resultados]) ([$3 comentários ou dúvidas?]).",
	'readerfeedback-voted' => "'''Aparentemente você já avaliou esta página''' ([$2 ver resultados]) ([$3 comentários ou dúvidas?]).",
	'readerfeedback-error' => "'''Ocorreu um erro ao avaliar esta página''' ([$2 ver resultados]) ([$3 comentários ou dúvidas?])",
	'readerfeedback-submitting' => 'Enviando...',
	'readerfeedback-finished' => 'Obrigado!',
	'readerfeedback-tagfilter' => 'Etiqueta:',
	'readerfeedback-tierfilter' => 'Avaliação:',
	'readerfeedback-tier-high' => 'Elevada',
	'readerfeedback-tier-medium' => 'Moderada',
	'readerfeedback-tier-poor' => 'Péssima',
	'tooltip-ca-ratinghist' => 'Opinião dos leitores sobre esta página',
	'specialpages-group-feedback' => 'Opinião dos leitores',
	'readerfeedback-tt-review' => 'Enviar revisão',
);

/** Romanian (Română)
 * @author Cin
 * @author Emily
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'readerfeedback' => 'Ce părere aveți despre această pagină ?',
	'readerfeedback-text' => "''Vă rugăm să acordați câteva momente evaluării paginii de mai jos. Părerea dumneavoastră contează și ne ajută în procesul de îmbunătățire a site-ului nostru.''",
	'readerfeedback-reliability' => 'Fiabilitate',
	'readerfeedback-completeness' => 'Completă',
	'readerfeedback-npov' => 'Neutralitate',
	'readerfeedback-presentation' => 'Prezentare',
	'readerfeedback-overall' => 'Global',
	'readerfeedback-level-none' => '(nesigur)',
	'readerfeedback-level-0' => 'Slab',
	'readerfeedback-level-1' => 'Redus',
	'readerfeedback-level-2' => 'Mediu',
	'readerfeedback-level-3' => 'Ridicat',
	'readerfeedback-level-4' => 'Excelent',
	'readerfeedback-submit' => 'Trimite',
	'readerfeedback-main' => 'Doar conținutul paginilor poate fi evaluat.',
	'readerfeedback-success' => "'''Vă mulțumim pentru revizuirea acestei pagini!''' ([$2 vizualizați rezultatele]) ([$3 comentarii sau întrebări?]).",
	'readerfeedback-voted' => "'''Se pare că ați evaluat deja această pagină''' ([$2 vizualizați rezultatele]) ([$3 comentarii sau întrebări?]).",
	'readerfeedback-error' => "'''A apărut o eroare în timp ce era evaluată această pagină''' ([$2 vedeți rezultatele]) ([$3 comentarii sau întrebări ?]).",
	'readerfeedback-submitting' => 'Se trimite...',
	'readerfeedback-finished' => 'Mulțumim!',
	'readerfeedback-tagfilter' => 'Etichetă:',
	'readerfeedback-tierfilter' => 'Evaluare:',
	'readerfeedback-tier-high' => 'Ridicat',
	'readerfeedback-tier-medium' => 'Moderat',
	'readerfeedback-tier-poor' => 'Slab',
	'tooltip-ca-ratinghist' => 'Evaluările cititorilor despre această pagină',
	'specialpages-group-feedback' => 'Opinia cititorilor',
	'readerfeedback-tt-review' => 'Trimite evaluarea',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'readerfeedback-desc' => "Pàgene de validazione ca permette a le letture de dà 'nu retorne jndr'à 'u module de le pundegge de categorije",
	'readerfeedback' => 'Ce pinze de sta pàgene?',
	'readerfeedback-text' => "''Pe piacere pigghiate 'nu mumende pe dà 'nu pundegge a 'a pàgene d'aqquà sotte. 'A valutazione toje jè 'mbortande e 'n'aiute a aggiustà 'u site.''",
	'readerfeedback-reliability' => 'Affedabbeletà',
	'readerfeedback-completeness' => 'Combletezze',
	'readerfeedback-npov' => 'Neutralità',
	'readerfeedback-presentation' => 'Presendazione',
	'readerfeedback-overall' => 'Sus a tutte',
	'readerfeedback-level-none' => '(insicure)',
	'readerfeedback-level-0' => 'Povere',
	'readerfeedback-level-1' => 'Vasce',
	'readerfeedback-level-2' => 'Medie',
	'readerfeedback-level-3' => 'Ierte',
	'readerfeedback-level-4' => "'A uerre proprie (Eccellende)",
	'readerfeedback-submit' => 'Conferme',
	'readerfeedback-main' => 'Sulamende le pàggene cu le condenute ponne essere valutete.',
	'readerfeedback-success' => "'''Grazie pe avè reviste sta pàgene!''' ([$2 vide le resultate]) ([$3 Commende o dumanne?]).",
	'readerfeedback-voted' => "'''Pare proprie ca tu è già vutate pe sta pàgene''' ([$2 vide le resultate]) ([$3 Commende o dumanne?]).",
	'readerfeedback-error' => "'''<nowiki>'</nowiki>N errore sà verificate quanne ste vutave sta pàgene''' ([$2 vide le resultate]) ([$3 commende o domande?]).",
	'readerfeedback-submitting' => 'In conferme...',
	'readerfeedback-finished' => "Grazie 'mbà",
	'readerfeedback-tagfilter' => 'Tag:',
	'readerfeedback-tierfilter' => 'Valutazione:',
	'readerfeedback-tier-high' => 'Ierte',
	'readerfeedback-tier-medium' => 'Medie',
	'readerfeedback-tier-poor' => 'Povere',
	'tooltip-ca-ratinghist' => 'Pundegge de le letture de sta pàgene',
	'specialpages-group-feedback' => "Visitatore de l'opiniune",
	'readerfeedback-tt-review' => 'Conferme reviste',
);

/** Russian (Русский)
 * @author Ahonc
 * @author AlexSm
 * @author Claymore
 * @author Ferrer
 * @author Kaganer
 * @author Kalan
 * @author Lockal
 * @author Putnik
 * @author Sergey kudryavtsev
 * @author VasilievVV
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'readerfeedback-desc' => 'Проверка страниц позволяет читателям оставлять отзывы в форме оценок по категориям',
	'readerfeedback' => 'Что вы думаете об этой странице?',
	'readerfeedback-text' => "''Пожалуйста, дайте оценку этой странице. Ваши отзывы очень ценны для нас, они помогают работать над улучшением сайта.''",
	'readerfeedback-reliability' => 'Достоверность',
	'readerfeedback-completeness' => 'Полнота',
	'readerfeedback-npov' => 'Нейтральность',
	'readerfeedback-presentation' => 'Подача материала',
	'readerfeedback-overall' => 'Общая оценка',
	'readerfeedback-level-none' => '(не выбрано)',
	'readerfeedback-level-0' => 'плохая',
	'readerfeedback-level-1' => 'низкая',
	'readerfeedback-level-2' => 'средняя',
	'readerfeedback-level-3' => 'хорошая',
	'readerfeedback-level-4' => 'отличная',
	'readerfeedback-submit' => 'Отправить',
	'readerfeedback-main' => 'Оценены могут быть только основные страницы проекта.',
	'readerfeedback-success' => "'''Спасибо за оценку этой страницы!''' ([$2 см. результаты]) ([$3 замечания или вопросы?]).",
	'readerfeedback-voted' => "'''Похоже, вы уже оценивали эту страницу.''' ([$2 см. результаты]) ([$3 замечания или вопросы?]).",
	'readerfeedback-error' => "'''Ошибка обработки оценки страницы''' ([$2 см. результаты]) ([$3 замечания или вопросы?]).",
	'readerfeedback-submitting' => 'Отправка…',
	'readerfeedback-finished' => 'Спасибо!',
	'readerfeedback-tagfilter' => 'Метка:',
	'readerfeedback-tierfilter' => 'Оценка:',
	'readerfeedback-tier-high' => 'Высокая',
	'readerfeedback-tier-medium' => 'Средняя',
	'readerfeedback-tier-poor' => 'Низкая',
	'tooltip-ca-ratinghist' => 'Читательская оценка этой страницы',
	'specialpages-group-feedback' => 'Мнение читателей',
	'readerfeedback-tt-review' => 'Отправить проверку',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'readerfeedback-desc' => 'Перевірка сторінок доволює чітателям реаґовати формов оцїнок в катеґоріях',
	'readerfeedback' => 'Што собі думате о тій сторінцї?',
	'readerfeedback-text' => "''Найдьте собі просиме час на оцїнїня той сторінкы. Вашы назоры суть про нас дорогы і поможуть на вылїпшыти тот веб.''",
	'readerfeedback-reliability' => 'Достовірность',
	'readerfeedback-completeness' => 'Повнота',
	'readerfeedback-npov' => 'Невтралсность',
	'readerfeedback-presentation' => 'Поданя матеріалу',
	'readerfeedback-overall' => 'Цалкова оцінка',
	'readerfeedback-level-none' => '(не знаю)',
	'readerfeedback-level-0' => 'Бідне',
	'readerfeedback-level-1' => 'Низке',
	'readerfeedback-level-2' => 'Середнє',
	'readerfeedback-level-3' => 'Высоке',
	'readerfeedback-level-4' => 'Ексцелентный',
	'readerfeedback-submit' => 'Одослати',
	'readerfeedback-main' => 'Оцїнёвати годен лем сторінкы з обсягом.',
	'readerfeedback-success' => "'''Дякуєме за оцїнку той сторінкы!''' ([$2 резултаты]) ([$3 Є коментарї ці вопросы?]).",
	'readerfeedback-voted' => "'''Очівісно сьте уж тоту сторінку {{GENDER:|оцїнёвав|оцїнёвала|оцїнёвали}}.''' ([$2 Указати резултаты.]) ([$3 Мате коментарь або вопрос?])",
	'readerfeedback-error' => "'''При оцїнёваню той сторінкы дішло ку хыбі.''' ([$2 Указати выслїдкы.]) ([$3 Мате коментарь або вопрос?])",
	'readerfeedback-submitting' => 'Одосылать ся...',
	'readerfeedback-finished' => 'Дякуєме!',
	'readerfeedback-tagfilter' => 'Значка:',
	'readerfeedback-tierfilter' => 'Оцінка:',
	'readerfeedback-tier-high' => 'Высоке',
	'readerfeedback-tier-medium' => 'Середнє',
	'readerfeedback-tier-poor' => 'Низке',
	'tooltip-ca-ratinghist' => 'Оцїнка той сторінкы чітателями',
	'specialpages-group-feedback' => 'Назоры чітателїв',
	'readerfeedback-tt-review' => 'Одослати оцінку',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'readerfeedback-desc' => 'Сирэйи тургуутуу ааҕааччылар категорияннан сыана быһалларын хааччыйар',
	'readerfeedback' => 'Бу сирэй туһунан туох диэтиҥ?',
	'readerfeedback-text' => "''Бука диэн бу сирэйи сыаналаа эрэ. Эн эппитиҥ наһаа наадалаах, саайты тупсарарга көмөлөһүө.''",
	'readerfeedback-reliability' => 'Итэҕэтиитэ, кырдьыга',
	'readerfeedback-completeness' => 'Толорута',
	'readerfeedback-npov' => 'Сабыдыала суоҕа',
	'readerfeedback-presentation' => 'Көрдөрүүтэ (сөпкө көрдөрүүтэ)',
	'readerfeedback-overall' => 'Сыанабыл',
	'readerfeedback-level-none' => '(талыллыбатах)',
	'readerfeedback-level-0' => 'Мөлтөх',
	'readerfeedback-level-1' => 'Намыһах',
	'readerfeedback-level-2' => 'Орто',
	'readerfeedback-level-3' => 'Бэрт',
	'readerfeedback-level-4' => 'Уһулуччу',
	'readerfeedback-submit' => 'Ыыт',
	'readerfeedback-main' => 'Бырайыак сүрүн сирэйдэрэ эрэ сыаналаналлар.',
	'readerfeedback-success' => "'''Бу сирэйи сыаналаабыккар махтал!''' ([$2 көр]) ([$3 Этиилэр дуу ыйытыылар дуу бааллар дуо?]).",
	'readerfeedback-voted' => "'''Арааһа эн бу сирэйи урут сыаналаабыккын''' ([$2 көр]) ([$3 Этиилэр дуу ыйытыылар дуу бааллар дуо?]).",
	'readerfeedback-error' => "'''Сирэй сыанабылын оҥорорго алҕас таҕыста''' ([$2 көр]) ([$3 Этиилэр дуу ыйытыылар дуу бааллар дуо?]).",
	'readerfeedback-submitting' => 'Ыытыы...',
	'readerfeedback-finished' => 'Махтал!',
	'readerfeedback-tagfilter' => 'Тиэк:',
	'readerfeedback-tierfilter' => 'Сыанабыл:',
	'readerfeedback-tier-high' => 'Үрдүк',
	'readerfeedback-tier-medium' => 'Орто',
	'readerfeedback-tier-poor' => 'Мөлтөх',
	'tooltip-ca-ratinghist' => 'Ааҕааччы бу сирэйи сыанабыла',
	'specialpages-group-feedback' => 'Ааҕааччылар санаалара',
	'readerfeedback-tt-review' => 'Тургутууну ыыт',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'readerfeedback-level-3' => 'Bonu',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'readerfeedback-submit' => 'Unesi',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 * @author බිඟුවා
 */
$messages['si'] = array(
	'readerfeedback' => 'මෙම පිටුව ගැන ඔබ මොනවද හිතන්නෙ?',
	'readerfeedback-reliability' => 'විශ්වසනීයත්වය',
	'readerfeedback-completeness' => 'පූර්ණත්වය',
	'readerfeedback-npov' => 'මධ්‍යස්ථතාව',
	'readerfeedback-presentation' => 'ප්‍රදර්ශනය',
	'readerfeedback-overall' => 'සමස්ත',
	'readerfeedback-level-none' => '(අවිශ්වාශ)',
	'readerfeedback-level-0' => 'දුර්වල',
	'readerfeedback-level-1' => 'අවම',
	'readerfeedback-level-2' => 'සතුටුදායක',
	'readerfeedback-level-3' => 'ඉහළ',
	'readerfeedback-level-4' => 'අති විශිෂ්ට',
	'readerfeedback-submit' => 'යොමන්න',
	'readerfeedback-main' => 'අන්තර්ගත පිටු පමණක් තරාතිරම් කල හැක.',
	'readerfeedback-success' => "'''මෙම පිටුව නිරීක්ෂණය කලාට තුති!''' ([$2 ප්‍රතිපල බලන්න]) ([$3 පරිකථන හෝ ප්‍රශ්ණ?]).",
	'readerfeedback-voted' => "'''එහි දිස්වන්නේ ඔබ දැනටමත් මෙම පිටුවට තරාතිරමක් දී ඇති බවය''' ([$2 ප්‍රතිපල බලන්න]) ([$3 පරිකථන හෝ ගැටළු?]).",
	'readerfeedback-error' => "'''මෙම පිටුවට තරාතිරමක් දෙන අතරතුරදී දෝෂයක් හට ගැනුණි''' ([$2 ප්‍රතිපල බලන්න]) ([$3 පරිකථන හෝ ගැටළු?]).",
	'readerfeedback-submitting' => 'යොමු කරමින් …',
	'readerfeedback-finished' => 'ස්තුතියි!',
	'readerfeedback-tagfilter' => 'ටැගය:',
	'readerfeedback-tierfilter' => 'තරාතිරම:',
	'readerfeedback-tier-high' => 'ඉහළ',
	'readerfeedback-tier-medium' => 'මධ්‍යම',
	'readerfeedback-tier-poor' => 'දුර්වල',
	'tooltip-ca-ratinghist' => 'මෙම පිටුව කියවන්නාගේ තරාතිරම්',
	'specialpages-group-feedback' => 'නරඹන්නාගේ අදහස',
	'readerfeedback-tt-review' => 'නිරීක්ෂණය යොමන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'readerfeedback-desc' => 'Overenie stránky umožňuje čitateľom poslať komentáre vo formulári kategorických hodnotení',
	'readerfeedback' => 'Čo si myslíte o tejto stránke?',
	'readerfeedback-text' => "''Prosím, venujte chvíľu ohodnoteniu tejto stránky. Ceníme si vaše pripomienky, pomáhajú nám zlepšiť našu webstránku''",
	'readerfeedback-reliability' => 'Spoľahlivosť',
	'readerfeedback-completeness' => 'Úplnosť',
	'readerfeedback-npov' => 'Neutralita',
	'readerfeedback-presentation' => 'Prezentácia',
	'readerfeedback-overall' => 'Celkovo',
	'readerfeedback-level-none' => '(neistý)',
	'readerfeedback-level-0' => 'Slabá',
	'readerfeedback-level-1' => 'Nízka',
	'readerfeedback-level-2' => 'Dobrá',
	'readerfeedback-level-3' => 'Vysoká',
	'readerfeedback-level-4' => 'Vynikajúca',
	'readerfeedback-submit' => 'Odoslať',
	'readerfeedback-main' => 'Je možné hodnotiť iba stránky s obsahom.',
	'readerfeedback-success' => "'''Ďakujeme za ohodnotenie tejto stránky!''' ([$2 zobraziť výsledky]) (Máte [$3 komentár alebo otázku?]).",
	'readerfeedback-voted' => "'''Zdá sa, že ste túto stránku už ohodnotili.''' ([$2 zobraziť výsledky]) (Máte [$3 komentár alebo otázku?]).",
	'readerfeedback-error' => "'''Pri hodnotení tejto stránky sa vyskytla chyba''' ([$2 zobraziť výsledky]) (Máte [$3 komentár alebo otázku?]).",
	'readerfeedback-submitting' => 'Odosiela sa...',
	'readerfeedback-finished' => 'Ďakujeme!',
	'readerfeedback-tagfilter' => 'Značka:',
	'readerfeedback-tierfilter' => 'Hodnotenie:',
	'readerfeedback-tier-high' => 'Vysoké',
	'readerfeedback-tier-medium' => 'Stredné',
	'readerfeedback-tier-poor' => 'Nízke',
	'tooltip-ca-ratinghist' => 'Hodnotenie tejto stránky čitateľmi',
	'specialpages-group-feedback' => 'Názor čitateľa',
	'readerfeedback-tt-review' => 'Odoslať kontrolu',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'readerfeedback-desc' => 'Vrednotenje strani omogoča uporabnikom podajanje povratne informacije v obliki kategoričnih ocen',
	'readerfeedback' => 'Kaj menite o tej strani?',
	'readerfeedback-text' => "''Prosimo, vzemite si trenutek za ocenitev te strani spodaj. Vaša povratna informacija je dragocena in nam bo pomagala izboljšati našo spletno stran.''",
	'readerfeedback-reliability' => 'Zanesljivost',
	'readerfeedback-completeness' => 'Celovitost',
	'readerfeedback-npov' => 'Nevtralnost',
	'readerfeedback-presentation' => 'Predstavitev',
	'readerfeedback-overall' => 'Celotno',
	'readerfeedback-level-none' => '(negotovo)',
	'readerfeedback-level-0' => 'Slabo',
	'readerfeedback-level-1' => 'Nizko',
	'readerfeedback-level-2' => 'Pošteno',
	'readerfeedback-level-3' => 'Visoko',
	'readerfeedback-level-4' => 'Izvrstno',
	'readerfeedback-submit' => 'Potrdi',
	'readerfeedback-main' => 'Ocenjevati je mogoče samo vsebinske strani.',
	'readerfeedback-success' => "'''Zahvaljujemo se vam za ocenitev te strani!''' ([$2 ogled rezultatov]) ([$3 pripombe ali vprašanja?]).",
	'readerfeedback-voted' => "'''Zdi se, da ste to stran že ocenili''' ([$2 ogled rezultatov]) ([$3 pripombe ali vprašanja?]).",
	'readerfeedback-error' => "'''Med ocenjevanjem te strani je prišlo do napake''' ([$2 ogled rezultatov]) ([$3 pripombe ali vprašanja?]).",
	'readerfeedback-submitting' => 'Potrjevanje …',
	'readerfeedback-finished' => 'Hvala!',
	'readerfeedback-tagfilter' => 'Oznaka:',
	'readerfeedback-tierfilter' => 'Ocena:',
	'readerfeedback-tier-high' => 'Visoko',
	'readerfeedback-tier-medium' => 'Zmerno',
	'readerfeedback-tier-poor' => 'Slabo',
	'tooltip-ca-ratinghist' => 'Ocene bralcev te strani',
	'specialpages-group-feedback' => 'Mnenje obiskovalca',
	'readerfeedback-tt-review' => 'Pošlji pregled',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'readerfeedback' => 'Како Вам се свидела ова страница?',
	'readerfeedback-text' => "''Молим те, посвети мало пажње и оцени страну испод. Твоје мишљење је вредно и помаже нам у унапређивању сајта.''",
	'readerfeedback-reliability' => 'поузданост',
	'readerfeedback-completeness' => 'потпуност',
	'readerfeedback-npov' => 'неутралност',
	'readerfeedback-presentation' => 'презентација',
	'readerfeedback-overall' => 'укупно',
	'readerfeedback-level-0' => 'лоше',
	'readerfeedback-level-1' => 'слабо',
	'readerfeedback-level-2' => 'прихватљиво',
	'readerfeedback-level-3' => 'добро',
	'readerfeedback-level-4' => 'изузетно',
	'readerfeedback-submit' => 'пошаљи',
	'readerfeedback-main' => 'Само стране садржаја могу бити оцењиване.',
	'readerfeedback-submitting' => 'Шаљем…',
	'readerfeedback-finished' => 'Хвала!',
	'readerfeedback-tagfilter' => 'Ознака:',
	'tooltip-ca-ratinghist' => 'Оцене стране од стране читалаца.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'readerfeedback' => 'Kako Vam se svidela ova strana?',
	'readerfeedback-text' => "''Molim te, posveti malo pažnje i oceni stranu ispod. Tvoje mišljenje je vredno i pomaže nam u unapređivanju sajta.''",
	'readerfeedback-reliability' => 'pouzdanost',
	'readerfeedback-completeness' => 'potpunost',
	'readerfeedback-npov' => 'neutralnost',
	'readerfeedback-presentation' => 'prezentacija',
	'readerfeedback-overall' => 'ukupno',
	'readerfeedback-level-0' => 'loše',
	'readerfeedback-level-1' => 'slabo',
	'readerfeedback-level-2' => 'prihvatljivo',
	'readerfeedback-level-3' => 'dobro',
	'readerfeedback-level-4' => 'izuzetno',
	'readerfeedback-submit' => 'pošalji',
	'readerfeedback-main' => 'Samo strane sadržaja mogu biti ocenjivane.',
	'readerfeedback-submitting' => 'Slanje …',
	'readerfeedback-finished' => 'Hvala Vam!',
	'readerfeedback-tagfilter' => 'Tag:',
	'tooltip-ca-ratinghist' => 'Ocene strane od strane čitalaca.',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 * @author Skalman
 */
$messages['sv'] = array(
	'readerfeedback-desc' => 'Sidvalidering tillåter läsare att ge feedback i form av kategori-betyg',
	'readerfeedback' => 'Vad tycker du om den här sidan?',
	'readerfeedback-text' => "''Var snäll och lägg ett par minuter på att bedöma denna sida här nedan. Din feedback är värdefull och hjälper oss att förbättra vår webbplats.''",
	'readerfeedback-reliability' => 'Trovärdighet',
	'readerfeedback-completeness' => 'Fullständighet',
	'readerfeedback-npov' => 'Neutralitet',
	'readerfeedback-presentation' => 'Presentation',
	'readerfeedback-overall' => 'Helhetsintryck',
	'readerfeedback-level-none' => '(osäker)',
	'readerfeedback-level-0' => 'Mycket dålig',
	'readerfeedback-level-1' => 'Dålig',
	'readerfeedback-level-2' => 'Okej',
	'readerfeedback-level-3' => 'Bra',
	'readerfeedback-level-4' => 'Mycket bra',
	'readerfeedback-submit' => 'Skicka',
	'readerfeedback-main' => 'Endast innehållssidor kan granskas.',
	'readerfeedback-success' => "'''Tack för att du granskade den här sidan!''' ([$2 visa resultat]) ([$3 kommentarer eller frågor?])",
	'readerfeedback-voted' => "'''Det verkar som att du redan har betygsatt den här sidan.''' ([$2 visa resultat]) ([$3 kommentarer eller frågor?])",
	'readerfeedback-error' => "'''Ett fel har uppstått vid betygsättandet av denna sida''' ([$2 se resultat]) ([$3 kommentarer eller frågor?])",
	'readerfeedback-submitting' => 'Skickar...',
	'readerfeedback-finished' => 'Tack!',
	'readerfeedback-tagfilter' => 'Tag:',
	'readerfeedback-tierfilter' => 'Klassning:',
	'readerfeedback-tier-high' => 'Hög',
	'readerfeedback-tier-medium' => 'Medel',
	'readerfeedback-tier-poor' => 'Dålig',
	'tooltip-ca-ratinghist' => 'Användarbetyg för den här sidan',
	'specialpages-group-feedback' => 'Läsaråsikt',
	'readerfeedback-tt-review' => 'Skicka recension',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'readerfeedback-submit' => 'Wasilisha',
);

/** Tamil (தமிழ்)
 * @author Mahir78
 * @author TRYPPN
 * @author செல்வா
 */
$messages['ta'] = array(
	'readerfeedback-desc' => 'பக்கங்களை சரிபார்த்தலுக்கு அனுமதிப்பதன் மூலமே வாசகர்கள் தங்களின் கருத்துக்களை தகுதிவாரியாக மதிப்பீடு செய்து தர முடியும்',
	'readerfeedback' => 'இந்தப் பக்கம் பற்றி நீங்கள் என்ன நினைக்கிறீர்கள்?',
	'readerfeedback-text' => "''தயவு செய்து சிறிது அவகாசம் எடுத்து இந்தப் பக்கத்தின் கீழ் அளவீடு செய்யுங்கள். உங்களது கருத்துக்கள் மிக முக்கியமானதும் மற்றும் எங்களது இணையதளத்தின் வளர்ச்சிக்கும் உதவும்.''",
	'readerfeedback-reliability' => 'நன்பகமானது',
	'readerfeedback-completeness' => 'முடிவடைந்தது',
	'readerfeedback-npov' => 'நடுநிலையானது',
	'readerfeedback-presentation' => 'முன்வைத்தல்',
	'readerfeedback-overall' => 'ஒட்டுமொத்தமாக',
	'readerfeedback-level-none' => '(உறுதியற்றது)',
	'readerfeedback-level-0' => 'தரமற்றது',
	'readerfeedback-level-1' => 'கீழ்மதிப்பு',
	'readerfeedback-level-2' => 'நடுமதிப்பு',
	'readerfeedback-level-3' => 'உயர்மதிப்பு',
	'readerfeedback-level-4' => 'மிக உயர்மதிப்பு',
	'readerfeedback-submit' => 'சமர்ப்பி',
	'readerfeedback-main' => 'உள்ளடக்கம் உள்ள பக்கங்களை மட்டுமே மதிப்பீடு சொய்ய முடியும்',
	'readerfeedback-success' => "'''இந்தப் பக்கத்தை மீளாய்வு செயதமைக்கு நன்றி!''' ([$2 முடிவுகளை காண்க]) ([$3 பின்னூட்டங்கள் அல்லது கேள்விகள்?]).",
	'readerfeedback-voted' => "'''தாங்கள் இப்பக்கத்தை முன்பே மதிப்பீடு செய்துவிட்டீர்கள் என்று தோன்றுகிறது''' ([$2 முடிவுகளைக் காண்க]) ([$3 கருத்துக்கள் அல்லது கேள்விகள்?]).",
	'readerfeedback-error' => "'''தாங்கள் இப்பக்கத்தை மதிப்பீடு செய்யும் போது ஒரு சிறு தவறு நிகழந்துவிட்டது''' ([$2 முடிவுகளைக் காண்க]) ([$3 கருத்துக்கள் அல்லது கேள்விகள்?]).",
	'readerfeedback-submitting' => 'சமர்பிக்கப்படுகிறது ...',
	'readerfeedback-finished' => 'நன்றி!',
	'readerfeedback-tagfilter' => 'குறிச்சொல்:',
	'readerfeedback-tierfilter' => 'படிநிலை:',
	'readerfeedback-tier-high' => 'உயர்மதிப்பு',
	'readerfeedback-tier-medium' => 'நடுத்தரமான',
	'readerfeedback-tier-poor' => 'தரமற்ற',
	'tooltip-ca-ratinghist' => 'இந்தப் பக்கத்திற்கான பயனர் படிநிலைகள்',
	'specialpages-group-feedback' => 'பார்வையாளர்கள் கருத்துகள்',
	'readerfeedback-tt-review' => 'மீளாய்வை சமர்ப்பி',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Mpradeep
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'readerfeedback' => 'ఈ పేజీ గురించి మీరేమనుకుంటున్నారు?',
	'readerfeedback-reliability' => 'విశ్వసనీయత',
	'readerfeedback-completeness' => 'సంపూర్ణత',
	'readerfeedback-npov' => 'తటస్థత',
	'readerfeedback-level-none' => '(చెప్పలేం)',
	'readerfeedback-level-2' => 'పర్లేదు',
	'readerfeedback-level-3' => 'ఉత్తమం',
	'readerfeedback-level-4' => 'అత్యుత్తమం',
	'readerfeedback-submit' => 'దాఖలుచేయి',
	'readerfeedback-main' => 'విషయ పేజీలను మాత్రమే మూల్యాకంన చేయగలరు.',
	'readerfeedback-success' => "'''ఈ పేజీని సమీక్షించినందుకు కృతజ్ఞతలు!'''  ([$2 ఫలితాలను చూడండి]) ([$3 సందేహాలు లేదా సూచనలున్నాయా?]).",
	'readerfeedback-voted' => "'''ఈ పేజీకి మీరు ఇప్పటికే రేటింగు ఇచ్చినట్టు అనిపిస్తుంది''' ([$2 ఫలితాలను చూడండి]) ([$3 సందేహాలు లేదా సూచనలు ఉన్నాయా?]).",
	'readerfeedback-error' => "'''ఈ పేజీకి రేటింగుని ఇవ్వడంలో పొరపాటు దొర్లింది''' ([$2 ఫలితాలను చూడండి]) ([$3 సందేహాలు లేదా సూచనలు ఉన్నాయా?]).",
	'readerfeedback-submitting' => 'దాఖలుచేస్తున్నాం …',
	'readerfeedback-finished' => 'ధన్యవాదాలు!',
	'readerfeedback-tierfilter' => 'మూల్యాంకనం:',
	'readerfeedback-tier-high' => 'ఉన్నతం',
	'readerfeedback-tier-medium' => 'సామాన్యం',
	'tooltip-ca-ratinghist' => 'ఈ పుట యొక్క చదువరుల మూల్యాంకనం',
	'specialpages-group-feedback' => 'వీక్షకుల అభిప్రాయం',
	'readerfeedback-tt-review' => 'సమీక్షని దాఖలుచేయండి',
);

/** Thai (ไทย)
 * @author Ans
 * @author Horus
 */
$messages['th'] = array(
	'readerfeedback' => 'คุณคิดอย่างไรกับหน้านี้',
	'readerfeedback-reliability' => 'ความน่าเชื่อถือ',
	'readerfeedback-completeness' => 'ความสมบูรณ์',
	'readerfeedback-npov' => 'ความเป็นกลาง',
	'readerfeedback-presentation' => 'การนำเสนอ',
	'readerfeedback-overall' => 'ภาพรวม',
	'readerfeedback-level-none' => '(ไม่แน่ใจ)',
	'readerfeedback-level-0' => 'แย่มาก',
	'readerfeedback-level-1' => 'แย่',
	'readerfeedback-level-2' => 'พอใช้',
	'readerfeedback-level-3' => 'ดี',
	'readerfeedback-level-4' => 'ดีมาก',
	'readerfeedback-main' => 'สามารถจัดอันดับได้เฉพาะหน้าเนื้อหาเท่านั้น',
	'readerfeedback-finished' => 'ขอบคุณ!',
	'readerfeedback-tierfilter' => 'อันดับ:',
	'readerfeedback-tier-high' => 'ดี',
	'readerfeedback-tier-medium' => 'ปานกลาง',
	'readerfeedback-tier-poor' => 'แย่',
	'tooltip-ca-ratinghist' => 'การจัดอันดับโดยผู้อ่านของหน้านี้',
	'specialpages-group-feedback' => 'ความคิดเห็นจากผู้เข้าชม',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'readerfeedback-desc' => 'Sahypa barlagy okyjylaryň kategoriki derejelendirme görnüşinde seslenme bermegine mümkinçilik berýär',
	'readerfeedback' => 'Bu sahypa hakda pikiriňiz nähili?',
	'readerfeedback-text' => "''Aşakdaky sahypany derejelendirmegiňizi haýyş edýäris. Seslenmäňiz gymmatly we ol web saýtymyzy ösdürmäge kömek eder.''",
	'readerfeedback-reliability' => 'Ygtybarlylyk',
	'readerfeedback-completeness' => 'Dolulyk',
	'readerfeedback-npov' => 'Bitaraplyk',
	'readerfeedback-presentation' => 'Prezentasiýa',
	'readerfeedback-overall' => 'Umumy baha',
	'readerfeedback-level-none' => '(ynamsyz)',
	'readerfeedback-level-0' => 'Ýaramaz',
	'readerfeedback-level-1' => 'Pes',
	'readerfeedback-level-2' => 'Orta gürp',
	'readerfeedback-level-3' => 'Ýagşy',
	'readerfeedback-level-4' => 'Ajaýyp',
	'readerfeedback-submit' => 'Tabşyr',
	'readerfeedback-main' => 'Diňe mazmunly sahypalary derejelendirip bolýar.',
	'readerfeedback-success' => "'''Bu sahypany gözden geçireniňiz üçin sag boluň!''' ([$2 netijeleri gör]) ([$3 teswirler ýa-da soraglar?]).",
	'readerfeedback-voted' => "'''Bu sahypany eýýäm derejelendiripsiňiz ýaly-la''' ([$2 netijeleri gör]) ([$3 teswirler ýa-da soraglar?]).",
	'readerfeedback-error' => "'''Bu sahypany derejelendireniňizde säwlik ýüze çykdy''' ([$2 netijeleri gör]) ([$3 teswirler ýa-da soraglar?]).",
	'readerfeedback-submitting' => 'Tabşyrylýar...',
	'readerfeedback-finished' => 'Sag boluň!',
	'readerfeedback-tagfilter' => 'Teg:',
	'readerfeedback-tierfilter' => 'Derejelendirme:',
	'readerfeedback-tier-high' => 'Ýokary',
	'readerfeedback-tier-medium' => 'Orta tap',
	'readerfeedback-tier-poor' => 'Ýaramaz',
	'tooltip-ca-ratinghist' => 'Bu sahypanyň okyjy derejelendirmeleri',
	'specialpages-group-feedback' => 'Synlaýjy garaýşy',
	'readerfeedback-tt-review' => 'Gözden geçirmäni tabşyr',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'readerfeedback-desc' => 'Ang pahina ng pagpapatunay ay nagbibigay-daan para sa mga mambabasa na magbigay ng balik-hain sa anyo ng mga pag-aantas na pangkategorya',
	'readerfeedback' => 'Ano ba ang tingin mo sa pahinang ito?',
	'readerfeedback-text' => "''Magbigay lamang po sana ng panahon upang makapagbigay sa ibaba ng kaantasan para sa pahinang ito.  Mahalaga ang iyong pagbibigay ng puna at nakatutulong sa amin upang lalo pang mapainam ang websayt namin.''",
	'readerfeedback-reliability' => 'Antas na pagiging katiwatiwala',
	'readerfeedback-completeness' => 'Pagiging walang kakulangan',
	'readerfeedback-npov' => 'Kawalan ng pinapanigan',
	'readerfeedback-presentation' => 'Anyo ng paghahain (presentasyon)',
	'readerfeedback-overall' => 'Pangkalahatan',
	'readerfeedback-level-none' => '(hindi nakatitiyak)',
	'readerfeedback-level-0' => 'Mababa ang uri',
	'readerfeedback-level-1' => 'Mababa',
	'readerfeedback-level-2' => 'Patas',
	'readerfeedback-level-3' => 'Mataas',
	'readerfeedback-level-4' => 'Mahusay',
	'readerfeedback-submit' => 'Ipasa',
	'readerfeedback-main' => 'Tanging mga pahina ng nilalaman lamang ang mabibigyan ng kaantasan.',
	'readerfeedback-success' => "'''Salamat sa muling pagsuri mo ng pahinang ito!''' ([$2 tingnan ang mga kinalabasan])  ([$3 mga puna o mga katanungan?]).",
	'readerfeedback-voted' => "'''Tila parang nabigyan mo na ng antas ang pahinang ito''' ([$2 tingnan ang mga kinalabasan]) ([$3 mga puna o mga katanungan?]).",
	'readerfeedback-error' => "'''Naganap ang isang kamalian habang binibigyan ng antas ang pahinang ito''' ([$2 tingnan ang mga resulta]) ([$3 mga puna o mga tanong?]).",
	'readerfeedback-submitting' => 'Ipinapasa na...',
	'readerfeedback-finished' => 'Salamat sa iyo!',
	'readerfeedback-tagfilter' => 'Tatak:',
	'readerfeedback-tierfilter' => 'Kaantasan:',
	'readerfeedback-tier-high' => 'Mataas',
	'readerfeedback-tier-medium' => 'Katamtaman',
	'readerfeedback-tier-poor' => 'Mahina',
	'tooltip-ca-ratinghist' => 'Mga pagsusukat ng mambabasa para sa pahinang ito',
	'specialpages-group-feedback' => 'Wari ng tumatanaw',
	'readerfeedback-tt-review' => 'Ipasa ang pagsusuri',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Karduelis
 * @author Mach
 * @author Runningfridgesrule
 * @author Srhat
 */
$messages['tr'] = array(
	'readerfeedback-desc' => 'Sayfa doğrulaması, okuyucuların kategorisel derecelendirme formunda geridönüt vermesine izin verir',
	'readerfeedback' => 'Bu sayfa hakkında ne düşünüyorsunuz?',
	'readerfeedback-text' => "''Lütfen bu sayfayı oylamak için vaktinizi ayırın. Cevabınız değerlidir ve websitemizi geliştirmemize yardımcı olacaktır.''",
	'readerfeedback-reliability' => 'Güvenilirlik',
	'readerfeedback-completeness' => 'Tamamlılık',
	'readerfeedback-npov' => 'Tarafsızlık',
	'readerfeedback-presentation' => 'Sunum',
	'readerfeedback-overall' => 'Bütün',
	'readerfeedback-level-none' => '(kararsız)',
	'readerfeedback-level-0' => 'Zayıf',
	'readerfeedback-level-1' => 'Düşük',
	'readerfeedback-level-2' => 'Adil',
	'readerfeedback-level-3' => 'Yüksek',
	'readerfeedback-level-4' => 'Mükemmel',
	'readerfeedback-submit' => 'Gönder',
	'readerfeedback-main' => 'Sadece içerik sayfaları oylanabilir.',
	'readerfeedback-success' => "'''Bu sayfayı gözden geçirdiğiniz için teşekkürler!''' ([$2 sonuçları gör]) ([$3 Yorum ya da sorular?]).",
	'readerfeedback-voted' => "'''Bu sayfayı zaten oylamış görünüyorsunuz''' ([$2 sonuçları gör]) ([$3 Yorum ya da sorular?]).",
	'readerfeedback-error' => "'''Bu sayfayı derecelendirirken bir hata oluştu''' ([$2 sonuçları gör]) ([$3 yorum ya da sorular?]).",
	'readerfeedback-submitting' => 'Gönderiliyor...',
	'readerfeedback-finished' => 'Teşekkürler!',
	'readerfeedback-tagfilter' => 'Etiket:',
	'readerfeedback-tierfilter' => 'Derecelendirme:',
	'readerfeedback-tier-high' => 'Yüksek',
	'readerfeedback-tier-medium' => 'Orta',
	'readerfeedback-tier-poor' => 'Zayıf',
	'tooltip-ca-ratinghist' => 'Bu sayfanın ziyaretçi derecelendirmesi',
	'specialpages-group-feedback' => 'İzleyici görüşü',
	'readerfeedback-tt-review' => 'Gözden geçirmeyi gönder',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'readerfeedback-desc' => 'Перевірка сторінок дозволяє читачам залишати відгуки у формі оцінок за категоріями',
	'readerfeedback' => 'Що ви думаєте про цю сторінку?',
	'readerfeedback-text' => "''Будь ласка, оцініть цю сторінку. Ваші відгуки дуже цінні для нас, вони допомагають нам працювати над покращенням сайту.''",
	'readerfeedback-reliability' => 'Достовірність',
	'readerfeedback-completeness' => 'Повнота',
	'readerfeedback-npov' => 'Нейтральність',
	'readerfeedback-presentation' => 'Подання матеріалу',
	'readerfeedback-overall' => 'Загальна оцінка',
	'readerfeedback-level-none' => '(не обрано)',
	'readerfeedback-level-0' => 'Погана',
	'readerfeedback-level-1' => 'Низька',
	'readerfeedback-level-2' => 'Середня',
	'readerfeedback-level-3' => 'Висока',
	'readerfeedback-level-4' => 'Відмінна',
	'readerfeedback-submit' => 'Надіслати',
	'readerfeedback-main' => 'Можуть бути оцінені тільки сторінки основного простору.',
	'readerfeedback-success' => "'''Дякуємо за оцінку цієї сторінки!''' ([$2 результати]) ([$3 Є коментарі чи запитання?]).",
	'readerfeedback-voted' => "'''Схоже, ви вже оцінювали цю сторінку''' ([$2 результати]) ([$3 Є коментарі чи запитання?]).",
	'readerfeedback-error' => "'''При оцінюванні сторінки сталася помилка''' ([$2 результати]) ([$3 Є коментарі чи запитання?]).",
	'readerfeedback-submitting' => 'Надсилання…',
	'readerfeedback-finished' => 'Дякуємо!',
	'readerfeedback-tagfilter' => 'Мітка:',
	'readerfeedback-tierfilter' => 'Оцінка:',
	'readerfeedback-tier-high' => 'Висока',
	'readerfeedback-tier-medium' => 'Середня',
	'readerfeedback-tier-poor' => 'Низька',
	'tooltip-ca-ratinghist' => 'Читацька оцінка цієї сторінки',
	'specialpages-group-feedback' => 'Читацька думка',
	'readerfeedback-tt-review' => 'Надіслати відгук',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'readerfeedback-desc' => 'La valutazion de le pagine la permete ai lettori de dar un giudissio soto forma de voti par categorie',
	'readerfeedback' => "'Sa ghe ne pensito de sta pàxena?",
	'readerfeedback-text' => "''Par piaser, valuta sta pagina. El to giudissio el xe inportante par jutarne a mejorarne el nostro sito.''",
	'readerfeedback-reliability' => 'Afidabilità',
	'readerfeedback-completeness' => 'Conpletessa',
	'readerfeedback-npov' => 'Neutralità',
	'readerfeedback-presentation' => 'Presentassion',
	'readerfeedback-overall' => 'Conplessivo',
	'readerfeedback-level-none' => '(mia sicuro)',
	'readerfeedback-level-0' => 'Tristo assè',
	'readerfeedback-level-1' => 'Tristo',
	'readerfeedback-level-2' => 'Cussì-cussì',
	'readerfeedback-level-3' => 'Bon',
	'readerfeedback-level-4' => 'Bon assè',
	'readerfeedback-submit' => 'Manda',
	'readerfeedback-main' => 'Solo le pagine de contenuto le se pole valutare.',
	'readerfeedback-success' => "'''Grassie de ver valutà sta pagina!''' ([$2 varda risultati]) ([$3 comenti o domande?])",
	'readerfeedback-voted' => "'''Te ghè zà valutà sta pagina!''' ([$2 varda risultati]) ([$3 comenti o domande?])",
	'readerfeedback-error' => "'''Se gà verificà un eror finché te seri drio valutar sta pagina!''' ([$2 varda risultati]) ([$3 comenti o domande?])",
	'readerfeedback-submitting' => "So' drio mandarlo...",
	'readerfeedback-finished' => 'Grassie!',
	'readerfeedback-tagfilter' => 'Eticheta:',
	'readerfeedback-tierfilter' => 'Valutassion:',
	'readerfeedback-tier-high' => 'Bona',
	'readerfeedback-tier-medium' => 'Cussì-cussì',
	'readerfeedback-tier-poor' => 'Trista',
	'tooltip-ca-ratinghist' => 'Valutassion dei letori par sta pagina',
	'specialpages-group-feedback' => 'Opinion del letor',
	'readerfeedback-tt-review' => 'Invia recension',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'readerfeedback-desc' => "Lehtpolen vahvištoitand laskeb lugijoile avaita heiden mel'pidegid kategorižen arvostelendan formas",
	'readerfeedback' => 'Mitä meletat nece lehtpolen polhe?',
	'readerfeedback-text' => "''Olgat hüväd, arvostelgat nece lehtpol'. Teiden arvastelendad oma lujas kal'hed meile, ned abutadas paremboita sait.''",
	'readerfeedback-reliability' => 'Todesižuz',
	'readerfeedback-completeness' => 'Täuduz',
	'readerfeedback-npov' => 'Neitraližuz',
	'readerfeedback-presentation' => 'Materialan prezentacii',
	'readerfeedback-overall' => 'Ühthine arvsana',
	'readerfeedback-level-none' => '(en teda)',
	'readerfeedback-level-0' => 'hond',
	'readerfeedback-level-1' => 'madal',
	'readerfeedback-level-2' => 'Keskmäine',
	'readerfeedback-level-3' => 'korged',
	'readerfeedback-level-4' => 'Lujas hüvä',
	'readerfeedback-submit' => 'Oigeta',
	'readerfeedback-main' => 'Sab arvostelda vaiše projektan pälehtpoled',
	'readerfeedback-success' => "'''Kitän, miše olet arvostelnuded necidä lehtpol't!''' ([$3 Om-ik hoimaičendoid vai küzundoid?]).",
	'readerfeedback-voted' => "'''Näguse, tö olet jo arvostelnuded necen lehtpolen.''' ([$3 Om-ik homaičendoid vai küzundoid?]).",
	'readerfeedback-error' => "'''Petuz ozaižihe necen lehtpolen arvostelendan aigan''' ([$3 kommentarijad vai küzundad?]).",
	'readerfeedback-submitting' => 'Oigendamine...',
	'readerfeedback-finished' => 'Kitäm!',
	'readerfeedback-tagfilter' => 'Teg:',
	'readerfeedback-tierfilter' => 'Lugusana:',
	'readerfeedback-tier-high' => 'Korged',
	'readerfeedback-tier-medium' => 'Keskmäine',
	'readerfeedback-tier-poor' => 'Hond',
	'tooltip-ca-ratinghist' => 'Necen lehtpolen lugijoiden arvsanad',
	'specialpages-group-feedback' => "Lugijan mel'pideg",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'readerfeedback-desc' => 'Kiểm định trang cho phép người đọc đưa ra phản hồi ở dạng xếp hạng phân mục',
	'readerfeedback' => 'Bạn nghĩ sao về trang này?',
	'readerfeedback-text' => "''Xin hãy để dành một chút thời gian để đánh giá trang này ở dưới. Chúng ta coi trọng ý kiến của bạn và dùng nó để cải tiến website này.''",
	'readerfeedback-reliability' => 'Đáng tin cậy',
	'readerfeedback-completeness' => 'Tính đầy đủ',
	'readerfeedback-npov' => 'Tính trung lập',
	'readerfeedback-presentation' => 'Cách trình bày',
	'readerfeedback-overall' => 'Nói chung',
	'readerfeedback-level-none' => '(không chắc)',
	'readerfeedback-level-0' => 'Tệ',
	'readerfeedback-level-1' => 'Dở',
	'readerfeedback-level-2' => 'Vừa',
	'readerfeedback-level-3' => 'Khá',
	'readerfeedback-level-4' => 'Tốt',
	'readerfeedback-submit' => 'Đệ trình',
	'readerfeedback-main' => 'Chỉ đánh giá được những trang nội dung.',
	'readerfeedback-success' => "'''Cám ơn bạn vì đã duyệt trang này!''' ([$2 Xem kết quả]&nbsp;– [$3 Bình luận hoặc câu hỏi?])",
	'readerfeedback-voted' => "'''Dường như bạn đã xếp hạng trang này rồi.''' ([$2 Xem kết quả]&nbsp;– [$3 Bình luận hoặc câu hỏi?])",
	'readerfeedback-error' => "'''Xảy ra lỗi khi đang xếp hạng trang này.''' ([$2 Xem kết quả]&nbsp;– [$3 Bình luận hoặc câu hỏi?])",
	'readerfeedback-submitting' => 'Đang gửi…',
	'readerfeedback-finished' => 'Cám ơn!',
	'readerfeedback-tagfilter' => 'Thẻ:',
	'readerfeedback-tierfilter' => 'Xếp hạng:',
	'readerfeedback-tier-high' => 'Cao',
	'readerfeedback-tier-medium' => 'Trung bình',
	'readerfeedback-tier-poor' => 'Kém',
	'tooltip-ca-ratinghist' => 'Các đánh giá của độc giả về trang này',
	'specialpages-group-feedback' => 'Ý kiến của người xem',
	'readerfeedback-tt-review' => 'Đăng bản duyệt',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'readerfeedback-finished' => 'Danö!',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'readerfeedback-level-3' => 'הויך',
	'readerfeedback-submit' => 'אײַנגעבן',
	'readerfeedback-main' => 'נאר אינהאַלט־בלעטער קען מען אָפשאַצן.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenzw
 * @author Gaoxuewei
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'readerfeedback-desc' => '页面验证允许读者提供反馈的形式明确评级',
	'readerfeedback' => '您对这个页面有什么意见？',
	'readerfeedback-text' => "''请花一点时间来评价下面这个页面。您反馈的意见将帮助我们改进我们的网站。''",
	'readerfeedback-reliability' => '可靠性',
	'readerfeedback-completeness' => '完整性',
	'readerfeedback-npov' => '中立性',
	'readerfeedback-presentation' => '展示',
	'readerfeedback-overall' => '总结',
	'readerfeedback-level-none' => '（不确定）',
	'readerfeedback-level-0' => '差',
	'readerfeedback-level-1' => '不好',
	'readerfeedback-level-2' => '一般',
	'readerfeedback-level-3' => '好',
	'readerfeedback-level-4' => '极好',
	'readerfeedback-submit' => '提交',
	'readerfeedback-main' => '只有内容页才可被评级。',
	'readerfeedback-success' => "'''感谢您对本页的评论！'''（[$2 查看结果]） （[$3 留言或者有疑问？]）",
	'readerfeedback-voted' => "'''您已经对本页评论过了'''（[$2 查看结果]） （[$3 留言或者有疑问？]）",
	'readerfeedback-error' => "'''评论本页时出现了一个错误'''（[$2 查看结果]） （[$3 留言或者有疑问？]）",
	'readerfeedback-submitting' => '提交中...',
	'readerfeedback-finished' => '谢谢您！',
	'readerfeedback-tagfilter' => '标签：',
	'readerfeedback-tierfilter' => '评级：',
	'readerfeedback-tier-high' => '高',
	'readerfeedback-tier-medium' => '中',
	'readerfeedback-tier-poor' => '低',
	'tooltip-ca-ratinghist' => '读者对本页的评级',
	'specialpages-group-feedback' => '浏览者意见',
	'readerfeedback-tt-review' => '提交审查',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Gaoxuewei
 * @author Horacewai2
 * @author Mark85296341
 * @author Waihorace
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'readerfeedback-desc' => '頁面驗證允許讀者提供回饋意見的形式明確評級',
	'readerfeedback' => '您對這個頁面有什麽意見？',
	'readerfeedback-text' => "''請花一點時間來評價下面這個頁面。您回饋的意見將幫助我們改進我們的網站。''",
	'readerfeedback-reliability' => '可靠性',
	'readerfeedback-completeness' => '完整性',
	'readerfeedback-npov' => '中立性',
	'readerfeedback-presentation' => '展示',
	'readerfeedback-overall' => '總結',
	'readerfeedback-level-none' => '（不確定）',
	'readerfeedback-level-0' => '差',
	'readerfeedback-level-1' => '不好',
	'readerfeedback-level-2' => '一般',
	'readerfeedback-level-3' => '好',
	'readerfeedback-level-4' => '極好',
	'readerfeedback-submit' => '提交',
	'readerfeedback-main' => '只有內容頁才可被評級。',
	'readerfeedback-success' => "'''感謝您對本頁的評論！'''（[$2 檢視結果]） （[$3 留言或者有疑問？]）",
	'readerfeedback-voted' => "'''您已經對本頁評論過了'''（[$2 檢視結果]） （[$3 留言或者有疑問？]）",
	'readerfeedback-error' => "'''評論本頁時出現了一個錯誤'''（[$2 檢視結果]） （[$3 留言或者有疑問？]）",
	'readerfeedback-submitting' => '提交中...',
	'readerfeedback-finished' => '謝謝您！',
	'readerfeedback-tagfilter' => '標籤：',
	'readerfeedback-tierfilter' => '評級：',
	'readerfeedback-tier-high' => '高',
	'readerfeedback-tier-medium' => '中',
	'readerfeedback-tier-poor' => '低',
	'tooltip-ca-ratinghist' => '本頁面的讀者評分',
	'specialpages-group-feedback' => '瀏覽者意見',
	'readerfeedback-tt-review' => '提交審查',
);

