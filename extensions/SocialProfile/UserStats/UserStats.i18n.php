<?php
/**
 * Internationalization file for the UserStats extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Aaron Wright
 * @author David Pean
 */
$messages['en'] = array(
	'user-stats-alltime-title' => 'All-time most points',
	'user-stats-weekly-title' => 'Most points this week',
	'user-stats-monthly-title' => 'Most points this month',
	'topusers' => 'Top users',
	'top-fans-by-points-nav-header' => 'Top fans',
	'top-fans-by-category-nav-header' => 'Top by category',
	'top-fans-total-points-link' => 'Total points',
	'top-fans-weekly-points-link' => 'Points this week',
	'top-fans-monthly-points-link' => 'Points this month',
	'top-fans-points' => 'points',
	'top-fans-by-category-title-edit-count' => 'Top overall edits',
	'top-fans-by-category-title-friends-count' => 'Top overall friends',
	'top-fans-by-category-title-foe-count' => 'Top overall foes',
	'top-fans-by-category-title-gifts-rec-count' => 'Top overall gifts received',
	'top-fans-by-category-title-gifts-sent-count' => 'Top overall gifts sent',
	'top-fans-by-category-title-vote-count' => 'Top overall votes',
	'top-fans-by-category-title-comment-count' => 'Top overall comments',
	'top-fans-by-category-title-referrals-count' => 'Top overall referrals',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Top overall thumbs up',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Top overall thumbs down',
	'top-fans-by-category-title-comment-score-positive-given' => 'Top overall thumbs up given',
	'top-fans-by-category-title-comment-score-negative-given' => 'Top overall thumbs down given',
	'top-fans-by-category-title-monthly-winner-count' => 'Top overall monthly wins',
	'top-fans-by-category-title-weekly-winner-count' => 'Top overall weekly wins',
	'top-fans-bad-field-title' => 'Oops!',
	'top-fans-bad-field-message' => 'The specified stat does not exist.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Vote|Votes}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Monthly win|Monthly wins}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Weekly win|Weekly wins}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edit|Edits}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comment|Comments}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referral|Referrals}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Friend|Friends}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Foe|Foes}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Published opinion|Published opinions}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinion|Opinions}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Thumb up|Thumbs up}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Thumb down|Thumbs down}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Thumb up give|Thumbs up give}}n',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Thumb down given|Thumbs down given}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Gift received|Gifts received}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Gift sent|Gifts sent}}',
	'right-updatepoints' => 'Update edit counts',
	'right-generatetopusersreport' => 'Generate top users reports',
	'level-advanced-to' => 'advanced to level <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'You are now a "$1" on {{SITENAME}}!',
	'level-advance-body' => 'Hi $1.

You are now a "$2" on {{SITENAME}}!

Congratulations,

The {{SITENAME}} team

---
Hey, want to stop getting e-mails from us?

Click $3
and change your settings to disable e-mail notifications.',
	// Special:UpdateEditCounts
	'updateeditcounts' => 'Update Edit Counts',
	'updateeditcounts-updated' => "Updated stats for '''$1''' {{PLURAL:$1|user|users}}",
	'updateeditcounts-updating' => 'Updating $1 with $2 {{PLURAL:$2|edit|edits}}',
	// Special:GenerateTopUsersReport
	'generatetopusersreport' => 'Generate Top Users Report',
	'user-stats-weekly-winners' => 'Weekly {{PLURAL:$1|Winner|Winners}}',
	'user-stats-monthly-winners' => 'Monthly {{PLURAL:$1|Winner|Winners}}',
	'user-stats-weekly-win-congratulations' => 'Congratulations to the following {{PLURAL:$1|user|users}}, who earned a weekly win and $2 extra {{PLURAL:$2|point|points}}!',
	'user-stats-monthly-win-congratulations' => 'Congratulations to the following {{PLURAL:$1|user|users}}, who earned a monthly win and $2 extra {{PLURAL:$2|point|points}}!',
	'user-stats-full-top' => 'Full Top $1',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|point|points}}!",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|point|points}}!",
	'user-stats-report-generation-note' => 'this page was generated automatically',
	'user-stats-report-weekly-edit-summary' => 'automated weekly user report',
	'user-stats-report-monthly-edit-summary' => 'automated monthly user report',
	'user-stats-report-weekly-page-title' => 'Weekly User Points Report ($1)',
	'user-stats-report-monthly-page-title' => 'Monthly User Points Report ($1)',
	'user-stats-report-error-variable-not-set' => 'The variable $wgUserStatsPointValues[\'points_winner_$1\'] must have a value greater than 0 in LocalSettings.php!',
);

/** Message documentation (Message documentation)
 * @author Bennylin
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author McDutchie
 * @author Purodha
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'top-fans-points' => '{{Identical|Point}}',
	'top-fans-by-category-title-gifts-rec-count' => '',
	'top-fans-stats-vote-count' => '{{Identical|Vote}}',
	'top-fans-stats-edit-count' => '{{Identical|Edit}}',
	'top-fans-stats-comment-count' => '{{Identical|Comment}}',
	'right-updatepoints' => '{{doc-right|updatepoints}}',
	'right-generatetopusersreport' => '{{doc-right|generatetopusersreport}}',
	'user-stats-weekly-win-congratulations' => 'Parameters:
* $1 is a number of winning users; used for PLURAL
* $2 is a number of extra points; used for PLURAL.',
	'user-stats-monthly-win-congratulations' => 'Parameters:
* $1 is a number of winning users; used for PLURAL
* $2 is a number of extra points; used for PLURAL.',
	'user-stats-full-top' => 'Parameters:
* $1 is a number (for example: Full Top 20).',
	'user-stats-report-row' => 'Parameters:
* $1 is a rank number
* $2 is a username
* $3 is a number of points; used for PLURAL.',
	'user-stats-report-points' => 'Parameters:
* $1 is a number of points; used for PLURAL.',
	'user-stats-report-weekly-page-title' => 'Parameters:
* $1 is a localised timestamp',
	'user-stats-report-monthly-page-title' => 'Parameters:
* $1 is a localised timestamp',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'user-stats-alltime-title' => 'Meeste punte alle tye',
	'user-stats-weekly-title' => 'Meeste punte hierdie week',
	'user-stats-monthly-title' => 'Meeste punte die maand',
	'topusers' => 'Topgebruikers',
	'top-fans-by-category-nav-header' => 'Top per kategorie',
	'top-fans-total-points-link' => 'Puntetotaal',
	'top-fans-weekly-points-link' => 'Punte die week',
	'top-fans-monthly-points-link' => 'Punte die maand',
	'top-fans-points' => 'punte',
	'top-fans-by-category-title-vote-count' => 'Ranglys totaal aantal stemme',
	'top-fans-bad-field-title' => 'Oeps!',
	'top-fans-bad-field-message' => 'Die gespesifiseerde statistiek bestaan nie.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Stem|Stemme}}',
	'top-fans-stats-monthly-winner-count' => 'Maandelikse {{PLURAL:$1|oorwinning|oorwinnings}}',
	'top-fans-stats-weekly-winner-count' => 'Weeklikse {{PLURAL:$1|oorwinning|oorwinnings}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Wysiging|Wysigings}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Opmerking|Opmerkings}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Verwysing|Verwysings}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Vriend|Vriende}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Vyand|Vyande}}',
	'top-fans-stats-opinions-published' => 'Gepubliseerde {{PLURAL:$1|mening|menings}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Mening|Menings}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Duim|Duime}} omhoog',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Duim|Duime}} omlaag',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Duim|Duime}} omhoog uitgedeel',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Duim|Duime}} omlaag uitgedeel',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Geskenk|Geskenke}} ontvang',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Geskenk|Geskenke}} gestuur',
	'right-updatepoints' => 'Opdateer aantal wysigings',
	'level-advanced-to' => 'is gepromoveer tot vlak <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'U is nou "$1" op {{SITENAME}}',
	'level-advance-body' => 'Hallo $1.

U is nou "$2" op {{SITENAME}}!

Veels geluk.

Die span van {{SITENAME}}

---
Wil u nie langer e-posse van ons ontvang nie?

Klik $3
en wysig u instellings om e-posboodskappe te deaktiveer.',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'top-fans-stats-friends-count' => '{{PLURAL:$1|ወዳጅ|ወዳጆች}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|ጠላት|ጠላቶች}}',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edición|Edicions}}',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'user-stats-alltime-title' => 'أكثر النقاط كل الوقت',
	'user-stats-weekly-title' => 'أكثر النقاط هذا الأسبوع',
	'user-stats-monthly-title' => 'أكثر النقاط هذا الشهر',
	'topusers' => 'أعلى المستخدمين',
	'top-fans-by-points-nav-header' => 'أعلى المعجبين',
	'top-fans-by-category-nav-header' => 'الأعلى بالتصنيف',
	'top-fans-total-points-link' => 'إجمالي النقاط',
	'top-fans-weekly-points-link' => 'النقاط هذا الأسبوع',
	'top-fans-monthly-points-link' => 'النقاط هذا الشهر',
	'top-fans-points' => 'نقاط',
	'top-fans-bad-field-title' => 'آه!',
	'top-fans-bad-field-message' => 'الإحصاءات المحددة غير موجودة.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|لا يوجد تصويت|تصويت|تصويتان|تصويتات}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|لا يوجد فوز شهري|فوز شهري|فوزان شهريان|فوز شهري}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|لا يوجد فوز أسبوعي|فوز أسبوعي|فوزان أسبوعيان|فوز أسبوعي}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|لا توجد تعديلات|تعديل|تعديلان|تعديلات}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|لا توجد تعليقات|تعليق|تعليقان|تعليقات}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|لا توجد إحالات|إحالة|إحالتان|إحالات}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|لا يوجد أصدقاء|صديق|صديقان|أصدقاء}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|لا يوجد أعداء|عدو|عدوان|أعداء}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|لا يوجد رأي منشور|رأي منشور|رأيان منشوران|آراء منشورة}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|لا توجد آراء|رأي|رأيان|آراء}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|لا توجد أوسمة|وسام|وسامان|أوسمة}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|لا توجد استنكارات|استنكار|استنكاران|استنكارات}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|لا توجد إشادات معطاة|إشادة معطاة|إشادتان معطاتان|إشادات معطاة}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|لا توجد استنكارات معطاة|استنكار معطى|استنكاران معطان|استنكارات معطاة}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|لا توجد هدايا مستلمة|هدية مستلمة|هديتان مستلمتان|هدايا مستلمة}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|لا توجد هدايا مرسلة|هدية مرسلة|هديتان مرسلتان|هدايا مرسلة}}',
	'right-updatepoints' => 'تحديث عدادات التعديلات',
	'level-advanced-to' => 'تقدم إلى المستوى <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'أنت الآن "$1" في {{SITENAME}}!',
	'level-advance-body' => 'مرحبا $1:

أنت الآن "$2" في {{SITENAME}}!

تهانينا،

فرق {{SITENAME}}

---
هل تريد التوقف عن تلقي رسائل بريد إلكتروني منا؟

اضغط $3
وغير إعداداتك لتعديل إخطارات البريد الإلكتروني.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'top-fans-points' => 'ܢܘܩܙ̈ܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'user-stats-alltime-title' => 'أكثر النقاط كل الوقت',
	'user-stats-weekly-title' => 'أكثر النقاط هذا الأسبوع',
	'user-stats-monthly-title' => 'أكثر النقاط هذا الشهر',
	'topusers' => 'أعلى اليوزرز',
	'top-fans-by-points-nav-header' => 'أعلى المعجبين',
	'top-fans-by-category-nav-header' => 'الأعلى بالتصنيف',
	'top-fans-total-points-link' => 'إجمالى النقاط',
	'top-fans-weekly-points-link' => 'النقاط هذا الأسبوع',
	'top-fans-monthly-points-link' => 'النقاط هذا الشهر',
	'top-fans-points' => 'نقاط',
	'top-fans-bad-field-title' => 'آه!',
	'top-fans-bad-field-message' => 'الإحصاءات المحددة غير موجودة.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|تصويت|تصويت}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|فوز شهري|فوز شهري}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|فوز أسبوعي|فوز أسبوعي}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|تعديل|تعديل}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|تعليق|تعليق}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|تراجع|تراجع}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|صديق|صديق}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|عدو|عدو}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|رأى منشور|رأى منشور}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|رأي|رأي}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|وسام|وسام}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|عيب|عيب}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|وسام معطى|وسام معطى}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|عيب معطى|عيب معطى}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|هدية تم تلقيها|هدية تم تلقيها}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|هدية مرسلة|هدية مرسلة}}',
	'level-advance-subject' => 'أنت الآن "$1" فى {{SITENAME}}!',
	'level-advance-body' => 'مرحبا $1:

أنت الآن "$2" فى {{SITENAME}}!

تهانينا،

فرق {{SITENAME}}

---
هل تريد التوقف عن تلقى رسائل بريد إلكترونى منا؟

اضغط $3
وغير إعداداتك لتعديل إخطارات البريد الإلكترونى.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Renessaince
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'user-stats-alltime-title' => 'Болей за ўсё пунктаў у гісторыі',
	'user-stats-weekly-title' => 'Болей за ўсё пунктаў у гэтым тыдні',
	'user-stats-monthly-title' => 'Болей за ўсё пунктаў у гэтым месяцы',
	'topusers' => 'Самыя актыўныя ўдзельнікі',
	'top-fans-by-points-nav-header' => 'Самыя актыўныя аматары',
	'top-fans-by-category-nav-header' => 'Самыя актыўныя па катэгорыях',
	'top-fans-total-points-link' => 'Усяго пунктаў',
	'top-fans-weekly-points-link' => 'Пунктаў на гэтым тыдні',
	'top-fans-monthly-points-link' => 'Пунктаў у гэтым месяцы',
	'top-fans-points' => 'пунктаў',
	'top-fans-by-category-title-edit-count' => 'Самыя актыўныя па колькасьці рэдагаваньняў',
	'top-fans-by-category-title-friends-count' => 'Самыя актыўныя па колькасьці сяброў',
	'top-fans-by-category-title-foe-count' => 'Самыя актыўныя па колькасьці ворагаў',
	'top-fans-by-category-title-gifts-rec-count' => 'Самыя актыўныя па колькасьці прынятых падарункаў',
	'top-fans-by-category-title-gifts-sent-count' => 'Самыя актыўныя па колькасьці дасланых падарункаў',
	'top-fans-by-category-title-vote-count' => 'Самыя актыўныя па колькасьці галасоў',
	'top-fans-by-category-title-comment-count' => 'Самыя актыўныя па колькасьці камэнтараў',
	'top-fans-by-category-title-referrals-count' => 'Самыя актыўныя па колькасьці спасылак',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Самыя актыўныя па колькасьці ўхваленьняў',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Самыя актыўныя па колькасьці неўхваленьняў',
	'top-fans-by-category-title-comment-score-positive-given' => 'Самыя актыўныя па колькасьці пададзеных ўхваленьняў',
	'top-fans-by-category-title-comment-score-negative-given' => 'Самыя актыўныя па колькасьці пададзеных неўхваленьняў',
	'top-fans-by-category-title-monthly-winner-count' => 'Самыя актыўныя па колькасьці месячных перамогаў',
	'top-fans-by-category-title-weekly-winner-count' => 'Самыя актыўныя па колькасьці тыднёвых перамогаў',
	'top-fans-bad-field-title' => 'Ой!',
	'top-fans-bad-field-message' => 'Такой статыстыкі няма.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Голас|Галасы|Галасоў}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Пераможца месяца|Пераможцы месяца|Пераможцаў месяца}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Пераможца тыдня|Пераможцы тыдня}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Рэдагаваньне|Рэдагаваньні|Рэдагаваньняў}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Камэнтар|Камэнтары|Камэнтараў}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Прыцягнуты|Прыцягнутых|Прыцягнутых}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Сябар|Сябры|Сяброў}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Вораг|Ворагі|Ворагаў}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Апублікаванае меркаваньне|Апублікаваныя меркаваньні}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Меркаваньне|Меркаваньні|Меркаваньняў}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Атрыманы голас за|Атрыманыя галасы за|Атрыманых галасоў за}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Атрыманы голас супраць|Атрыманыя галасы супраць|Атрыманых галасоў супраць}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Адданы голас за|Адданыя галасы за|Адданых галасоў за}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Адданы голас супраць|Адданыя галасы супраць|Адданых галасоў супраць}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Атрыманы падарунак|Атрыманыя падарункі|Атрыманых падарункаў}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Дасланы падарунак|Дасланыя падарункі|Дасланых падарункаў}}',
	'right-updatepoints' => 'абнаўленьне колькасьці рэдагаваньняў',
	'right-generatetopusersreport' => 'стварэньне справаздач пра лепшых удзельніках',
	'level-advanced-to' => 'палепшаны да ўзроўню <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Цяпер Вы ў групе «$1» у {{SITENAME}}!',
	'level-advance-body' => 'Прывітаньне, $1:

Цяпер Вы «$2» у {{SITENAME}}!

Віншуем,

Каманда {{SITENAME}}

---
Калі Вы не жадаеце болей атрымліваць ад нас лісты па электроннай пошце, націсьніце $3 і зьмяніце Вашыя налады для паведамленьняў.',
	'generatetopusersreport' => 'Стварыць справаздачу пра лепшых удзельніках',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Штотыднёвы пераможца|Штотыднёвыя пераможцы}}',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Штомесячны пераможца|Штомесячныя пераможцы}}',
	'user-stats-weekly-win-congratulations' => 'Віншуем {{PLURAL:$1|наступнага ўдзельніка, які стаў пераможцам тыдню і зарабіў|наступных удзельнікаў, якія сталі пераможцамі тыдню і зарабілі}} $2 {{PLURAL:$2|дадатковае ачко|дадатковыя ачкі|дадатковых ачкоў}}!',
	'user-stats-monthly-win-congratulations' => 'Віншуем {{PLURAL:$1|наступнага ўдзельніка, які стаў пераможцам месяцу і зарабіў|наступных удзельнікаў, якія сталі пераможцамі месяцу і зарабілі}} $2 {{PLURAL:$2|дадатковае ачко|дадатковыя ачкі|дадатковых ачкоў}}!',
	'user-stats-full-top' => 'Поўны сьпіс лепшых $1',
	'user-stats-report-row' => "($1) [[User:$2|$2]] — '''$3''' {{PLURAL:$3|ачко|ачкі|ачкоў}}!",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|пункт|пункты|пунктаў}}!",
	'user-stats-report-generation-note' => 'гэтая старонка была створаная аўтаматычна',
	'user-stats-report-weekly-edit-summary' => 'аўтаматычная штотыднёвая справаздача удзельнікаў',
	'user-stats-report-monthly-edit-summary' => 'аўтаматычная штомесячная справаздача ўдзельнікаў',
	'user-stats-report-weekly-page-title' => 'Штотыднёвая справаздача пунктаў удзельнікаў ($1)',
	'user-stats-report-monthly-page-title' => 'Штомесячная справаздача пунктаў удзельнікаў ($1)',
	'user-stats-report-error-variable-not-set' => 'Зьменная $wgUserStatsPointValues[\'points_winner_$1\'] у LocalSettings.php павінна мець значэньне, большае за 0!',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'user-stats-weekly-title' => 'Най-много точки тази седмица',
	'user-stats-monthly-title' => 'Най-много точки този месец',
	'topusers' => 'Топ потребители',
	'top-fans-by-points-nav-header' => 'Топ фенове',
	'top-fans-total-points-link' => 'Общо точки',
	'top-fans-weekly-points-link' => 'Точки тази седмица',
	'top-fans-monthly-points-link' => 'Точки този месец',
	'top-fans-points' => 'точки',
	'top-fans-bad-field-title' => 'Опа!',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Редакция|Редакции}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Коментар|Коментари}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Приятел|Приятели}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Неприятел|Неприятели}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Мнение|Мнения}}',
	'level-advance-subject' => 'Вече сте „$1“ в {{SITENAME}}!',
	'level-advance-body' => 'Привет $1,

Вече сте с ранг „$2“ в {{SITENAME}}!

Поздравления,

Екипът на {{SITENAME}}

---
Не искате да получавате повече писма от нас?

Можете да промените настройките си за известяване от следната препратка: $3.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'right-updatepoints' => 'সম্পাদনা সংখ্যা হালনাগাদ করো',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 */
$messages['br'] = array(
	'user-stats-alltime-title' => 'Niver uhelañ a boentoù a-viskoazh',
	'user-stats-weekly-title' => 'Poentoù uhelañ er sizhun-mañ',
	'user-stats-monthly-title' => 'Poentoù uhelañ er miz-mañ',
	'topusers' => 'Ar re wellañ eus an implijerien',
	'top-fans-by-points-nav-header' => 'Ar re wellañ eus ar re entanet',
	'top-fans-by-category-nav-header' => 'Ar re wellañ dre rummad',
	'top-fans-total-points-link' => 'Hollad ar poentoù',
	'top-fans-weekly-points-link' => 'Poentoù er sizhun-mañ',
	'top-fans-monthly-points-link' => 'Poentoù er miz-mañ',
	'top-fans-points' => 'poentoù',
	'top-fans-by-category-title-edit-count' => 'Niver brasañ a gemmoù hollek',
	'top-fans-by-category-title-friends-count' => 'Niver brasañ a vignoned hollek',
	'top-fans-by-category-title-foe-count' => 'Niver brasañ a enebourien hollek',
	'top-fans-by-category-title-gifts-rec-count' => 'Niver brasañ a brofoù resevet hollek',
	'top-fans-by-category-title-gifts-sent-count' => 'Niver brasañ a brofoù kaset hollek',
	'top-fans-by-category-title-vote-count' => 'Niver brasañ a votoù hollek',
	'top-fans-by-category-title-comment-count' => 'Niver brasañ a evezhiadennoù hollek',
	'top-fans-by-category-title-referrals-count' => 'Niver brasañ a erbederien hollek',
	'top-fans-by-category-title-comment-score-positive-rec' => "Niver brasañ a c'hourc'hemennoù resevet hollek",
	'top-fans-by-category-title-comment-score-negative-rec' => 'Niver brasañ a nulladennoù hollek',
	'top-fans-by-category-title-comment-score-positive-given' => "Niver brasañ a c'hourc'hemennoù roet hollek",
	'top-fans-by-category-title-comment-score-negative-given' => 'Niver brasañ a nulladennoù roet hollek',
	'top-fans-by-category-title-monthly-winner-count' => "Niver brasañ a c'hounidoù hollek dre viz",
	'top-fans-by-category-title-weekly-winner-count' => "Niver brasañ a c'hounidoù hollek dre sizhun",
	'top-fans-bad-field-title' => 'Chaous !',
	'top-fans-bad-field-message' => "N'eus ket eus ar stadegenn diferet.",
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Mouezh|Mouezh}}',
	'top-fans-stats-monthly-winner-count' => "{{PLURAL:$1|Trec'h er miz|Trec'h er miz}}",
	'top-fans-stats-weekly-winner-count' => "{{PLURAL:$1|Trec'h er sizhun|Trec'h er sizhun}}",
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Aozadenn|Aozadenn}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Evezhiadenn|Evezhiadenn}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Dave|Dave}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Mignon|Mignon}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Enebour|Enebour}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Meno embannet|Meno embannet}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Meno|Meno}}',
	'top-fans-stats-comment-score-positive-rec' => "{{PLURAL:$1|Meud d'an nec'h|Meud d'an nec'h}}",
	'top-fans-stats-comment-score-negative-rec' => "{{PLURAL:$1|Meud d'an traoñ|Meud d'an traoñ}}",
	'top-fans-stats-comment-score-positive-given' => "{{PLURAL:$1|Meud d'an nec'h roet|Meud d'an nec'h roet}}",
	'top-fans-stats-comment-score-negative-given' => "{{PLURAL:$1|Meud d'an traoñ roet|Meud d'an traoñ roet}}",
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|prof resevet|prof resevet}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|prof kaset|prof kaset}}',
	'right-updatepoints' => "Hizivaat ar c'honter aozadennoù",
	'level-advanced-to' => 'zo aet war-raok d\'al live <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => "Bremañ ez oc'h un « $1 » war {{SITENAME}} !",
	'level-advance-body' => "Salud deoc'h, \$1.

Bez' hoc'h eus un \"\$2\" war {{SITENAME}} bremañ !

Gourc'hemennoù,

Skipailh {{SITENAME}} 

---
C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war \$3
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bosteloù.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'user-stats-alltime-title' => 'Najviše bodova svih vremena',
	'user-stats-weekly-title' => 'Najviše bodova ove sedmice',
	'user-stats-monthly-title' => 'Najviše bodova ovog mjeseca',
	'topusers' => 'Najkorisnici',
	'top-fans-by-points-nav-header' => 'Najveći obožavatelji',
	'top-fans-by-category-nav-header' => 'Rejting po kategoriji',
	'top-fans-total-points-link' => 'Ukupni bodovi',
	'top-fans-weekly-points-link' => 'Bodova ove sedmice',
	'top-fans-monthly-points-link' => 'Bodova ovog mjeseca',
	'top-fans-points' => 'bodovi',
	'top-fans-by-category-title-edit-count' => 'Najviše izmjena sveukupno',
	'top-fans-by-category-title-friends-count' => 'Najviše prijatelja sveukupno',
	'top-fans-by-category-title-foe-count' => 'Najviše neprijatelja sveukupno',
	'top-fans-by-category-title-gifts-rec-count' => 'Najviše primljenih poklona sveukupno',
	'top-fans-by-category-title-gifts-sent-count' => 'Najviše poslanih poklona',
	'top-fans-by-category-title-vote-count' => 'Najviše ukupnih glasova',
	'top-fans-by-category-title-comment-count' => 'Najviše ukupnih komentara',
	'top-fans-by-category-title-referrals-count' => 'Ukupan broj navođenja',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Ukupni broj glasova za',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Ukupni broj glasova protiv',
	'top-fans-by-category-title-comment-score-positive-given' => 'Ukupni broj datih glasova za',
	'top-fans-by-category-title-comment-score-negative-given' => 'Ukupni broj datih glasova protiv',
	'top-fans-by-category-title-monthly-winner-count' => 'Ukupan broj mjesečnih pobjeda',
	'top-fans-by-category-title-weekly-winner-count' => 'Ukupan broj sedmičnih pobjeda',
	'top-fans-bad-field-title' => 'Ups!',
	'top-fans-bad-field-message' => 'Navedena statistika ne postoji.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Glas|Glasa|Glasova}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Mjesečna pobjeda|Mjesečne pobjede}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Sedmična pobjeda|Sedmične pobjede}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Izmjena|Izmjene|Izmjena}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komentar|Komentari}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Preporuka|Preporuke}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Prijatelj|Prijatelja}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Neprijatelj|Neprijatelja}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Objavljeno mišljenje|Objavljena mišljenja}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Mišljenje|Mišljenja}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Glas za|Glasovi za}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Glas protiv|Glasovi protiv}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Dati glas za|Dati glasovi za}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Dati glas protiv|Dati glasovi protiv}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Poklon primljen|Poklona primljeno}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Poslan poklon|Poslano poklona}}',
	'right-updatepoints' => 'Ažuriranje brojanja izmjena',
	'level-advanced-to' => 'prešao na nivo <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Vi ste sada "$1" na {{SITENAME}}!',
	'level-advance-body' => 'Zdravo $1.

Sada ste "$2" na {{SITENAME}}!

Čestitamo,

Urednici {{SITENAME}}

---
Hej, želite da prestanete dobivati e-mailove od nas?

Kliknite $3
i promijenite Vaše postavke da bi onemogućili e-mail obavještenja.',
);

/** Catalan (Català)
 * @author Solde
 * @author Ssola
 */
$messages['ca'] = array(
	'top-fans-total-points-link' => 'Punts totals',
	'top-fans-weekly-points-link' => 'Punts aquesta setmana',
	'top-fans-monthly-points-link' => 'Punts aquest mes',
	'top-fans-points' => 'punts',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Vot|Vots}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Guany mensual|Guanys mensuals}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Modificació|Modificacions}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comentari|Comentaris}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amic|Amics}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinió|Opinions}}',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'user-stats-alltime-title' => 'Nejvíc bodů celkem',
	'user-stats-weekly-title' => 'Nejvíc bodů tento týden',
	'user-stats-monthly-title' => 'Nejvíc bodů tento měsíc',
	'topusers' => 'Nej uživatelé',
	'top-fans-by-points-nav-header' => 'Nej fanouškové',
	'top-fans-by-category-nav-header' => 'Nej podle kategorie',
	'top-fans-total-points-link' => 'Celkem bodů',
);

/** German (Deutsch)
 * @author Kghbln
 * @author MF-Warburg
 * @author Melancholie
 * @author Purodha
 * @author Revolus
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'user-stats-alltime-title' => 'Am meisten Punkte (gesamt)',
	'user-stats-weekly-title' => 'Am meisten Punkte diese Woche',
	'user-stats-monthly-title' => 'Am meisten Punkte diesen Monat',
	'topusers' => 'Aktivste Benutzer',
	'top-fans-by-points-nav-header' => 'Aktivste Fans',
	'top-fans-by-category-nav-header' => 'Aktivste nach Kategorie',
	'top-fans-total-points-link' => 'Gesamtpunktzahl',
	'top-fans-weekly-points-link' => 'Punkte diese Woche',
	'top-fans-monthly-points-link' => 'Punkte diesen Monat',
	'top-fans-points' => 'Punkte',
	'top-fans-by-category-title-edit-count' => 'Meiste Bearbeitungen insgesamt',
	'top-fans-by-category-title-friends-count' => 'Meiste Freunde insgesamt',
	'top-fans-by-category-title-foe-count' => 'Meiste Gegner insgesamt',
	'top-fans-by-category-title-gifts-rec-count' => 'Meiste Auszeichnungen insgesamt erhalten',
	'top-fans-by-category-title-gifts-sent-count' => 'Meiste Auszeichnungen insgesamt vergeben',
	'top-fans-by-category-title-vote-count' => 'Meiste abgegebene Stimmen insgesamt',
	'top-fans-by-category-title-comment-count' => 'Meiste abgegebene Bemerkungen insgesamt',
	'top-fans-by-category-title-referrals-count' => 'Meiste Diskussionsverweise insgesamt',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Meiste Zustimmungen insgesamt',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Meiste Ablehnungen insgesamt',
	'top-fans-by-category-title-comment-score-positive-given' => 'Meiste Zustimmungen insgesamt vergeben',
	'top-fans-by-category-title-comment-score-negative-given' => 'Meiste Ablehnungen insgesamt vergeben',
	'top-fans-by-category-title-monthly-winner-count' => 'Meiste Monatssiege insgesamt',
	'top-fans-by-category-title-weekly-winner-count' => 'Meiste Wochensiege insgesamt',
	'top-fans-bad-field-title' => 'Hoppla!',
	'top-fans-bad-field-message' => 'Die angegebene Statistik existiert nicht.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Stimme|Stimmen}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Monatsgewinn|Monatsgewinne}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Wochengewinn|Wochengewinne}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Bearbeitung|Bearbeitungen}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Kommentar|Kommentare}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Empfehlung|Empfehlungen}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Freund|Freunde}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Wi­der­sa­cher|Wi­der­sa­cher}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Veröffentlichte Meinung|Veröffentlichte Meinungen}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Meinung|Meinungen}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Daumen nach oben|Daumen nach oben}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Daumen nach unten|Daumen nach unten}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Gegebener Daumen nach oben|Gegebene Daumen nach oben}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Gegebener Daumen nach unten|Gegebene Daumen nach unten}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Geschenk erhalten|Geschenke erhalten}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Geschenk gemacht|Geschenke gemacht}}',
	'right-updatepoints' => 'Beiträgszähler aktualisieren',
	'right-generatetopusersreport' => 'Berichte zu den aktivsten Benutzern generieren',
	'level-advanced-to' => 'erweitert auf Level <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => '[{{SITENAME}}] Du bist jetzt „$1“!',
	'level-advance-body' => 'Hallo $1,

Du bist jetzt ein „$2“ bei {{SITENAME}}!

Es gratuliert das {{SITENAME}}-Team

---
Du willst gar keine E-Mails mehr von uns bekommen?

Klicke $3
und ändere deine Einstellungen, um die E-Mail-Benachrichtigungen abzustellen.',
	'generatetopusersreport' => 'Bericht zu den aktivsten Benutzern generieren',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Wochensieger|Wochensieger}}',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Monatssieger|Monatssieger}}',
	'user-stats-weekly-win-congratulations' => 'Herzlichen Glückwunsch {{PLURAL:$1|dem folgenden Benutzer, der den Wochensieg errungen und {{PLURAL:$2|Zusatzpunkt|Zusatzpunkte}} erhalten hat.|den folgenden Benutzern, die den Wochensieg errungen und {{PLURAL:$2|Zusatzpunkt|Zusatzpunkte}} erhalten haben.}}',
	'user-stats-monthly-win-congratulations' => 'Herzlichen Glückwunsch {{PLURAL:$1|dem folgenden Benutzer, der den Monatssieg errungen und {{PLURAL:$2|Zusatzpunkt|Zusatzpunkte}} erhalten hat.|den folgenden Benutzern, die den Monatssieg errungen und {{PLURAL:$2|Zusatzpunkt|Zusatzpunkte}} erhalten haben.}}',
	'user-stats-full-top' => 'Vollständige Bestenliste $1',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|Punkt|Punkte}}",
	'user-stats-report-points' => "'''$1'''  {{PLURAL:$1|Punkt|Punkte}}",
	'user-stats-report-generation-note' => 'Diese Seite wurde automatisch generiert.',
	'user-stats-report-weekly-edit-summary' => 'automatisierter wöchentlicher Benutzerbericht',
	'user-stats-report-monthly-edit-summary' => 'automatisierter monatlicher Benutzerbericht',
	'user-stats-report-weekly-page-title' => 'Wöchentlicher Benutzerpunktebericht ($1)',
	'user-stats-report-monthly-page-title' => 'Monatlicher Benutzerpunktebericht ($1)',
	'user-stats-report-error-variable-not-set' => 'Für den Parameter $wgUserStatsPointValues[\'points_winner_$1\'] in der Datei LocalSettings.php muss ein Wert größer als 0 angegeben sein.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'level-advance-subject' => '[{{SITENAME}}] Sie sind jetzt „$1“!',
	'level-advance-body' => 'Guten Tag $1,

Sie sind jetzt ein „$2“ bei {{SITENAME}}!

Es gratuliert das {{SITENAME}}-Team.

---
Sie wollen gar keine E-Mails mehr von uns bekommen?

Klicken Sie $3
und ändern Sie Ihre Einstellungen, um die E-Mail-Benachrichtigungen abzustellen.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'user-stats-alltime-title' => 'Absolutnje nejwěcej dypkow',
	'user-stats-weekly-title' => 'Nejwěcej dypkow toś ten tyźeń',
	'user-stats-monthly-title' => 'Nejwěcej dypkow toś ten mjasec',
	'topusers' => 'Nejlěpše wužywarje',
	'top-fans-by-points-nav-header' => 'Nejlěpše fany',
	'top-fans-by-category-nav-header' => 'Nejlěpše pó kategoriji',
	'top-fans-total-points-link' => 'Dypki dogromady',
	'top-fans-weekly-points-link' => 'Dypki toś ten tyźeń',
	'top-fans-monthly-points-link' => 'Dypki toś ten mjasec',
	'top-fans-points' => 'dypki',
	'top-fans-by-category-title-edit-count' => 'Nejwěcej změnow',
	'top-fans-by-category-title-friends-count' => 'Nejwěcej pśijaśelow',
	'top-fans-by-category-title-foe-count' => 'Nejwěcej njepśijaśelow',
	'top-fans-by-category-title-gifts-rec-count' => 'Nejwěcej dostatych darow',
	'top-fans-by-category-title-gifts-sent-count' => 'Nejwěcej pósłanych darow',
	'top-fans-by-category-title-vote-count' => 'Nejwěcej głosow',
	'top-fans-by-category-title-comment-count' => 'Nejwěcej komentarow',
	'top-fans-by-category-title-referrals-count' => 'Nejwěcej pórucenjow',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Nejwěcej pśigłosenjow',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Nejwěcej wótpokazanjow',
	'top-fans-by-category-title-comment-score-positive-given' => 'Nejwěcej danych pśigłosenjow',
	'top-fans-by-category-title-comment-score-negative-given' => 'Nejwěcej danych wótpokazanjow',
	'top-fans-by-category-title-monthly-winner-count' => 'Nejwěcej mjasecnych dobyśow',
	'top-fans-by-category-title-weekly-winner-count' => 'Nejwěcej tyźeńskich dobyśow',
	'top-fans-bad-field-title' => 'Hopla!',
	'top-fans-bad-field-message' => 'Pódana statistika njeeksistěrujo.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Głos|Głosa|Głose|Głosow}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Mjasecne dobyśe|Mjasecnej dobyśi|Mjasecne dobyśa|Mjasecnych dobyśow}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Tyźeńske dobyśe|Tyźeńskej dobyśi|Tyźeńske dobyśa|Tyźeńskich dobyśow}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Změna|Změnje|Změny|Změnow}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komentar|Komentara|Komentary|Komentarow}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Pórucenje|Póruceni|Pórucenja|Pórucenjow}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Pśijaśel|Pśijaśela|Pśijaśele|Pśijaśelow}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Njepśijaśel|Njepśijaśela|Njepśijaśele|Njepśijaśelow}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Wózjawjone měnjenje|Wózjawjonej měnjeni|Wózjawjone měnjenja|Wózjawjonych měnjenjow}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Měnjenje|Měnjeni|Měnjenja|Měnjenjow}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Tłusty palc|Tłustej palca|Tłuste palce|Tłustych palcow}} górjej',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Tłusty palc|Tłustej palca|Tłuste palce|Tłustych palcow}} dołoj',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Dany tłusty palc|Danej tłustej palca|Dane tłuste palce|Danych tłustych palcow}} górjej',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Dany tłusty palc|Danej tłustej palca|Dane tłuste palce|Danych tłustych palcow}} dołoj',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Dar dostaty|Dara dostatej|Dary dostate|Darow dostatych}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Dar pósłany|Dara pósłanej|Dary pósłane|Darow pósłanych}}',
	'right-updatepoints' => 'Licbu změnow wobźěłaś',
	'level-advanced-to' => 'póstupijo k rowninje <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Sy něnto "$1" na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'level-advance-body' => 'Witaj $1.

Sy něnto "$2" na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

Glukužycenje,

Team {{GRAMMAR:genitiw|{{SITENAME}}}}

---
Njocoš wěcej scełego žedne e-maile wót nas dostawaś?

Klikni na $3
a změń swóje nastajenja, aby znjemóžnił zdźělenja pśez e-mail.',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'top-fans-bad-field-title' => 'Tsalele!',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'user-stats-alltime-title' => 'Περισσότεροι πόντοι όλων των εποχών',
	'user-stats-weekly-title' => 'Περισσότεροι πόντοι αυτή την εβδομάδα',
	'user-stats-monthly-title' => 'Περισσότεροι πόντοι αυτό το μήνα',
	'topusers' => 'Κορυφαίοι χρήστες',
	'top-fans-by-points-nav-header' => 'Κορυφαίοι θαυμαστές',
	'top-fans-by-category-nav-header' => 'Κορυφαίοι βάσει κατηγορίας',
	'top-fans-total-points-link' => 'Συνολικοί πόντοι',
	'top-fans-weekly-points-link' => 'Πόντοι αυτή την εβδομάδα',
	'top-fans-monthly-points-link' => 'Πόντοι αυτό το μήνα',
	'top-fans-points' => 'βαθμοί',
	'top-fans-bad-field-title' => 'Ωχ!',
	'top-fans-bad-field-message' => 'Το συγκεκριμένο στατιστικό δεν υπάρχει.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Ψήφος|Ψήφοι}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Μηνιαία νίκη|Μηνιαίες νίκες}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Εβδομαδιαία νίκη|Εβδομαδιαίες νίκες}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Επεξεργασία|Επεξεργασίες}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Σχόλιο|Σχόλια}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Παραπομπή|Παραπομπές}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Φίλος|Φίλοι}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Εχθρός|Εχθροί}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Δημοσιευμένη γνώμη|Δημοσιευμένες γνώμες}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Γνώμη|Γνώμες}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Επιδοκιμασία|Επιδοκιμασίες}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Αποδοκιμασία|Αποδοκιμασίες}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Επιδοκιμασία που δώθηκε|Επιδοκιμασίες που δώθηκαν}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Αποδοκιμασία που δώθηκε|Αποδοκιμασίες που δώθηκαν}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Δώρο λήφθηκε|Δώρα λήφθηκαν}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Δώρο στάλθηκε|Δώρα στάλθηκαν}}',
	'right-updatepoints' => 'Ενημέρωση των μετρήσεων επεξεργασιών',
	'level-advanced-to' => 'προχωρημένος στο επίπεδο <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Τώρα είσαι ένας "$1" στο {{SITENAME}}!',
	'level-advance-body' => 'Γεια $1.

Τώρα είσαι "$2" στο {{SITENAME}}!

Συγχαρητήρια,

Η ομάδα του {{SITENAME}}

---
Θέλεις να μην λαμβάνεις πλέον αυτά τα μέιλ από εμάς;

Κάνε κλικ στο $3
και άλλαξε τις ρυθμίσεις σου για να απενεργοποιήσεις τις ειδοποιήσεις μέσω ηλεκτρονικής αλληλογραφίας.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'user-stats-alltime-title' => 'Ĉiame plej granda poentaro',
	'user-stats-weekly-title' => 'Plej granda poentaro ĉi-semajne',
	'user-stats-monthly-title' => 'Plej granda poentaro ĉi-monate',
	'topusers' => 'Plej aktivaj uzantoj',
	'top-fans-by-points-nav-header' => 'Plej bonaj fervoruloj',
	'top-fans-by-category-nav-header' => 'Plej altaj laŭ kategorio',
	'top-fans-total-points-link' => 'Tutaj poentoj',
	'top-fans-weekly-points-link' => 'Poentoj dum ĉi tiu semajno',
	'top-fans-monthly-points-link' => 'Poentoj dum ĉi tiu monato',
	'top-fans-points' => 'poentoj',
	'top-fans-bad-field-title' => 'Ho ve!',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Voĉdono|Voĉdonoj}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Monata venko|Monataj venkoj}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Semajna venko|Semajnaj venkoj}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Redakto|Redaktoj}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komento|Komentoj}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referenco|Referencoj}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amiko|Amikoj}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Malamiko|Malamikoj}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Eldonita opinio|Eldonitaj opinioj}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinio|Opinioj}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Dikfingro supre|Dikfingroj supre}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Dikfingro malsupre|Dikfingroj malsupre}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Dikfingro supren donita|Dikfingroj supren donitaj}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Dikfingro malsupren donita|Dikfingroj malsupren donitaj}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Donaco ricevita|Donacoj ricevita}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Donaco sendita|Donacoj senditaj}}',
	'right-updatepoints' => 'Ĝisdatigi nombradon de redaktoj',
	'level-advanced-to' => 'rangiĝis al nivelo <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Vi nun estas "$1" en {{SITENAME}}!',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Dferg
 * @author Fitoschido
 * @author Imre
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'user-stats-alltime-title' => 'Mayor puntuación de la historia',
	'user-stats-weekly-title' => 'Mayor puntuación de esta semana',
	'user-stats-monthly-title' => 'Mayor puntuación de este mes',
	'topusers' => 'Usuarios top',
	'top-fans-by-points-nav-header' => 'Fans top',
	'top-fans-by-category-nav-header' => 'Máximo por categoría',
	'top-fans-total-points-link' => 'Puntos totales',
	'top-fans-weekly-points-link' => 'Puntos esta semana',
	'top-fans-monthly-points-link' => 'Puntos este mes',
	'top-fans-points' => 'puntos',
	'top-fans-by-category-title-edit-count' => 'Con mayor cantidad global de ediciones',
	'top-fans-by-category-title-friends-count' => 'Con mayor cantidad global de amigos',
	'top-fans-by-category-title-foe-count' => 'Con mayor cantidad global de enemigos',
	'top-fans-by-category-title-gifts-rec-count' => 'Con mayor cantidad global de regalos recibidos',
	'top-fans-by-category-title-gifts-sent-count' => 'Con mayor cantidad global de regalos enviados',
	'top-fans-by-category-title-vote-count' => 'Con mayor cantidad global de votos',
	'top-fans-by-category-title-comment-count' => 'Con mayor cantidad global de comentarios',
	'top-fans-by-category-title-referrals-count' => 'Con mayor cantidad global de recomendaciones',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Con mayor cantidad global de aprobados',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Con mayor cantidad global de no aprobados',
	'top-fans-by-category-title-comment-score-positive-given' => 'Con mayor cantidad global de aprobados dados',
	'top-fans-by-category-title-comment-score-negative-given' => 'Con mayor cantidad global de no aprobados dados',
	'top-fans-by-category-title-monthly-winner-count' => 'Con mayor cantidad global mensual de éxitos',
	'top-fans-by-category-title-weekly-winner-count' => 'Con mayor cantidad global semanal de éxitos',
	'top-fans-bad-field-title' => '¡Vaya!',
	'top-fans-bad-field-message' => 'La estadística especificada no existe.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Voto|Votos}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|victoria mensual|Victorias mensuales}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Victoria semanal|Victorias semanales}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edición|Ediciones}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comentario|Comentarios}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Remisión|Remisiones}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amigo|Amigos}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Enemigo|Enemigos}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Opinión publicada|Opiniones publicadas}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinión|Opiniones}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Pulgar arriba|Pulgares arriba}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Pulgar abajo|Pulgares abajo}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Pulgar arriba dado|Pulgares arriba dados}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Pulgar abajo dado|Pulgares abajos dados}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Regalo recibido|Regalos recibidos}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Regalo enviado|Regalos enviados}}',
	'right-updatepoints' => 'Actualizar conteos de ediciones',
	'level-advanced-to' => 'avanzó a nivel <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => '¡Ahora eres un «$1» en {{SITENAME}}!',
	'level-advance-body' => 'Hola $1.

¡Usted es ahora un "$2" en {{SITENAME}}!

Felicidades,

El  equipo de {{SITENAME}}

---
¿Desea no recibir más correos electrónicos de nosotros?

Haga click en  $3
y cambie sus configuraciones para deshabilitar notificaciones por correo electrónico.',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'topusers' => 'Tippkasutajad',
	'top-fans-by-points-nav-header' => 'Tippfännid',
	'top-fans-weekly-points-link' => 'Punkte sel nädalal',
	'top-fans-monthly-points-link' => 'Punkte sel kuul',
	'top-fans-points' => 'punktid',
	'top-fans-bad-field-title' => 'Ups!',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'top-fans-total-points-link' => 'Puntuak guztira',
	'top-fans-weekly-points-link' => 'Aste honetako puntuak',
	'top-fans-monthly-points-link' => 'Hilabete honetako puntuak',
	'top-fans-points' => 'puntuak',
	'top-fans-bad-field-title' => 'Hara!',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Bozka|Bozkak}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Aldaketa|Aldaketak}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Iruzkina|Iruzkinak}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Laguna|Lagunak}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Etsaia|Etsaiak}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Iritzia|Iritziak}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Aldekoa|Aldekoak}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Aurkakoa|Aurkakoak}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Opari bat jaso duzu|Opariak jaso dituzu}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Oparia bidali duzu|Opariak bidali dituzu}}',
	'level-advance-body' => 'Kaixo $1!

Orain "$2" zara {{SITENAME}} gunean!

Zorionak!

Agur bero bat {{SITENAME}} gunearen taldearen izenean.

---
Aizu, ez al dituzu gure mezu elektronikoak jaso nahi?

Egizu klik $3
eta alda itzazu ezarpenak e-posta bidezko jakinarazpenak ezgaitzeko.',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Cimon Avaro
 * @author Jack Phoenix <jack@countervandalism.net>
 * @author Str4nd
 */
$messages['fi'] = array(
	'user-stats-alltime-title' => 'Kaikkien aikojen suurimmat pistemäärät',
	'user-stats-weekly-title' => 'Eniten pisteitä tällä viikolla',
	'user-stats-monthly-title' => 'Eniten pisteitä tässä kuussa',
	'topusers' => 'Huippukäyttäjät',
	'top-fans-by-points-nav-header' => 'Huippufanit',
	'top-fans-by-category-nav-header' => 'Huiput luokittain',
	'top-fans-total-points-link' => 'Pisteitä yhteensä',
	'top-fans-weekly-points-link' => 'Pisteitä tällä viikolla',
	'top-fans-monthly-points-link' => 'Pisteitä tässä kuussa',
	'top-fans-points' => 'pistettä',
	'top-fans-by-category-title-edit-count' => 'Eniten muokkauksia',
	'top-fans-by-category-title-friends-count' => 'Eniten ystäviä',
	'top-fans-by-category-title-foe-count' => 'Eniten vihollisia',
	'top-fans-by-category-title-gifts-rec-count' => 'Eniten saatuja lahjoja',
	'top-fans-by-category-title-gifts-sent-count' => 'Eniten lähetettyjä lahjoja',
	'top-fans-by-category-title-vote-count' => 'Eniten ääniä',
	'top-fans-by-category-title-comment-count' => 'Eniten kommentteja',
	'top-fans-by-category-title-referrals-count' => 'Eniten lähetettyjä käyttäjiä',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Eniten peukaloita ylös',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Eniten peukaloita alas',
	'top-fans-by-category-title-comment-score-positive-given' => 'Eniten annettuja peukaloita ylös',
	'top-fans-by-category-title-comment-score-negative-given' => 'Eniten annettuja peukaloita alas',
	'top-fans-by-category-title-monthly-winner-count' => 'Eniten kuukausittaisia voittoja',
	'top-fans-by-category-title-weekly-winner-count' => 'Eniten viikottaisia voittoja',
	'top-fans-bad-field-title' => 'Ups!',
	'top-fans-bad-field-message' => 'Määritettyä tilastotietoa ei ole olemassa.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|ääni|ääniä}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|kuukausittainen voitto|kuukausittaista voittoa}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|viikottainen voitto|viikottaista voittoa}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|muokkaus|muokkausta}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|kommentti|kommenttia}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Viite|Viitteet}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|ystävä|ystävää}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|vihollinen|vihollista}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|julkaistu mielipide|julkaistua mielipidettä}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|mielipide|mielipidettä}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|peukalo ylös|peukaloa ylös}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|peukalo alas|peukaloa alas}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Tykkäät|Tykkäävät}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Et pidä|Eivät pidä}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|saatu lahja|saatua lahjaa}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|lähetetty lahja|lähetettyä lahjaa}}',
	'right-updatepoints' => 'Päivittää muokkausmääriä',
	'right-generatetopusersreport' => 'Luoda huippukäyttäjäraportteja',
	'level-advanced-to' => 'pääsi tasolle <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Olet nyt "$1" {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'level-advance-body' => 'Hei $1:

Olet nyt "$2" {{GRAMMAR:inessive|{{SITENAME}}}}!

Onneksi olkoon,

{{GRAMMAR:genitive|{{SITENAME}}}} tiimi

---
Hei, etkö enää halua saada sähköpostia meiltä?

Napsauta $3
ja muuta asetuksiasi poistaaksesi sähköposti-ilmoitukset käytöstä.',
	'generatetopusersreport' => 'Luo raportti huippukäyttäjistä',
	'user-stats-weekly-winners' => 'Viikon {{PLURAL:$1|voittaja|voittajat}}',
	'user-stats-monthly-winners' => 'Kuukauden {{PLURAL:$1|voittaja|voittajat}}',
	'user-stats-weekly-win-congratulations' => 'Onnittelumme {{PLURAL:$1|seuraavalle käyttäjälle, joka sai|seuraaville käyttäjille, jotka saivat}} viikottaisen voiton ja $2 lisäpistettä!',
	'user-stats-monthly-win-congratulations' => 'Onnittelumme {{PLURAL:$1|seuraavalle käyttäjälle, joka sai|seuraaville käyttäjille, jotka saivat}} kuukausittaisen voiton ja $2 lisäpistettä!',
	'user-stats-full-top' => 'Täysi huippukäyttäjien top $1 -lista',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' pistettä",
	'user-stats-report-points' => "'''$1''' pistettä",
	'user-stats-report-generation-note' => 'tämä sivu luotiin automaattisesti',
	'user-stats-report-weekly-edit-summary' => 'automatisoitu viikottainen käyttäjäraportti',
	'user-stats-report-monthly-edit-summary' => 'automatisoitu kuukausittainen käyttäjäraportti',
	'user-stats-report-weekly-page-title' => 'Viikottainen raportti käyttäjien pisteistä ($1)',
	'user-stats-report-monthly-page-title' => 'Kuukausittainen raportti käyttäjien pisteistä ($1)',
	'user-stats-report-error-variable-not-set' => 'Muuttujan $wgUserStatsPointValues[\'points_winner_$1\'] arvo LocalSettings.php-tiedostossa tulee olla suurempi kuin 0!',
);

/** French (Français)
 * @author Cedric31
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author Hashar
 * @author IAlex
 * @author McDutchie
 * @author Urhixidur
 */
$messages['fr'] = array(
	'user-stats-alltime-title' => 'Points les plus élevés toutes périodes confondues',
	'user-stats-weekly-title' => 'Points les plus élevés cette semaine',
	'user-stats-monthly-title' => 'Points les plus élevés ce mois-ci',
	'topusers' => 'Top des utilisateurs',
	'top-fans-by-points-nav-header' => 'Top des fans',
	'top-fans-by-category-nav-header' => 'Top par catégorie',
	'top-fans-total-points-link' => 'Total des points',
	'top-fans-weekly-points-link' => 'Points de cette semaine',
	'top-fans-monthly-points-link' => 'Points de ce mois-ci',
	'top-fans-points' => 'points',
	'top-fans-by-category-title-edit-count' => 'Meilleur nombre de modifications global',
	'top-fans-by-category-title-friends-count' => 'Meilleur nombre d’amis global',
	'top-fans-by-category-title-foe-count' => 'Meilleur nombre d’ennemis global',
	'top-fans-by-category-title-gifts-rec-count' => 'Meilleur nombre de cadeaux reçus global',
	'top-fans-by-category-title-gifts-sent-count' => 'Meilleur nombre de cadeaux envoyés global',
	'top-fans-by-category-title-vote-count' => 'Meilleur nombre de votes global',
	'top-fans-by-category-title-comment-count' => 'Meilleur nombre de commentaires global',
	'top-fans-by-category-title-referrals-count' => 'Meilleur nombre de référenceurs global',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Meilleur nombre de bravos reçus global',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Meilleur nombre de nuls reçus global',
	'top-fans-by-category-title-comment-score-positive-given' => 'Meilleur nombre de bravos donnés global',
	'top-fans-by-category-title-comment-score-negative-given' => 'Meilleur nombre de nuls donnés global',
	'top-fans-by-category-title-monthly-winner-count' => 'Meilleur nombre de gains par mois global',
	'top-fans-by-category-title-weekly-winner-count' => 'Meilleur nombre de gain par semaine global',
	'top-fans-bad-field-title' => 'Zut !',
	'top-fans-bad-field-message' => 'La statistique indiquée n’existe pas.',
	'top-fans-stats-vote-count' => 'Vote{{PLURAL:$1||s}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|victoire mensuelle|victoires mensuelles}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|victoire hebdomadaire|victoires hebdomadaires}}',
	'top-fans-stats-edit-count' => 'modification{{PLURAL:$1||s}}',
	'top-fans-stats-comment-count' => 'commentaire{{PLURAL:$1||s}}',
	'top-fans-stats-referrals-completed' => 'référence{{PLURAL:$1||s}}',
	'top-fans-stats-friends-count' => 'ami{{PLURAL:$1||s}}',
	'top-fans-stats-foe-count' => 'ennemi{{PLURAL:$1||s}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|opinion publiée|opinions publiées}}',
	'top-fans-stats-opinions-created' => 'opinion{{PLURAL:$1||s}}',
	'top-fans-stats-comment-score-positive-rec' => 'bravo{{PLURAL:$1||s}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|nul|nuls}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|bravo attribué|bravos attribués}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|nul attribué|nuls attribués}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|cadeau reçu|cadeaux reçus}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|cadeau envoyé|cadeaux envoyés}}',
	'right-updatepoints' => 'Mise à jour du compteur d’éditions',
	'right-generatetopusersreport' => 'Générer les rapports des utilisateurs principaux',
	'level-advanced-to' => 'a avancé vers le niveau <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Vous avez désormais un « $1 » sur {{SITENAME}} !',
	'level-advance-body' => 'Salut $1 :

Vous avez maintenant un « $2 » sur {{SITENAME}} !

Toutes nos félicitations,

L’équipe de {{SITENAME}}

---
Voulez-vous arrêter de recevoir des courriels de notre part ?

Cliquez $3
et modifiez vos paramètres en désactivant les notifications par courriel.',
	'generatetopusersreport' => 'Générer le rapport des utilisateurs principaux',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Gagnant de la semaine|Gagnants de la semaine}}',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Gagnant|Gagnants}} du mois',
	'user-stats-weekly-win-congratulations' => "Félicitations {{PLURAL:$1|à l'utilisateur suivant|aux utilisateurs suivants}}, qui {{PLURAL:$1|a|ont}} gagné un prix hebdomadaire et $2 {{PLURAL:$2|point supplémentaire|points supplémentaires}}!",
	'user-stats-monthly-win-congratulations' => "Félicitations {{PLURAL:$1|à l'utilisateur suivant|aux utilisateurs suivants}}, qui {{PLURAL:$1|a|ont}} gagné un prix mensuel et $2 {{PLURAL:$2|point supplémentaire|points supplémentaires}}!",
	'user-stats-full-top' => 'Top $1 complet',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|point|points}}!",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|point|points}}!",
	'user-stats-report-generation-note' => 'cette page a été générée automatiquement',
	'user-stats-report-weekly-edit-summary' => 'Rapport utilisateur hebdomadaire',
	'user-stats-report-monthly-edit-summary' => 'Rapport utilisateur mensuel',
	'user-stats-report-weekly-page-title' => 'Rapport hebdomadaire des points utilisateur ($1)',
	'user-stats-report-monthly-page-title' => 'Rapport mensuel des points utilisateur ($1)',
	'user-stats-report-error-variable-not-set' => 'La variable $wgUserStatsPointValues[\'points_winner_$1\'] doit avoir une valeur supérieure à 0 dans LocalSettings.php!',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'top-fans-points' => 'pouents',
	'top-fans-bad-field-title' => 'Crenom !',
	'top-fans-stats-vote-count' => 'Voto{{PLURAL:$1||s}}',
	'top-fans-stats-monthly-winner-count' => 'Victouère{{PLURAL:$1||s}} du mês',
	'top-fans-stats-weekly-winner-count' => 'Victouère{{PLURAL:$1||s}} de la semana',
	'top-fans-stats-edit-count' => 'changement{{PLURAL:$1||s}}',
	'top-fans-stats-comment-count' => 'Comentèro{{PLURAL:$1||s}}',
	'top-fans-stats-referrals-completed' => 'Recomandacion{{PLURAL:$1||s}}',
	'top-fans-stats-friends-count' => 'Ami{{PLURAL:$1||s}}',
	'top-fans-stats-foe-count' => 'Ènemi{{PLURAL:$1||s}}',
	'top-fans-stats-opinions-published' => 'Avis publeyê{{PLURAL:$1||s}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Avis|Avis}}',
	'top-fans-stats-comment-score-positive-rec' => 'Bravô{{PLURAL:$1||s}}',
	'top-fans-stats-comment-score-negative-rec' => 'Zérô{{PLURAL:$1||s}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Bravô balyê|Bravôs balyês}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Zérô balyê|Zérôs balyês}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Present reçu|Presents reçus}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Present mandâ|Presents mandâs}}',
	'level-advanced-to' => 'at avanciê vers lo nivél <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Vos avéd dês ora un « $1 » dessus {{SITENAME}} !',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' pouent{{PLURAL:$3||s}} !",
	'user-stats-report-points' => "'''$1''' pouent{{PLURAL:$1||s}} !",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'user-stats-alltime-title' => 'Os que obtiveron máis puntos en total',
	'user-stats-weekly-title' => 'Máis puntos nesta semana',
	'user-stats-monthly-title' => 'Máis puntos neste mes',
	'topusers' => 'Usuarios máis votados',
	'top-fans-by-points-nav-header' => 'Seguidores máis votados',
	'top-fans-by-category-nav-header' => 'Máis votados por categoría',
	'top-fans-total-points-link' => 'Puntos totais',
	'top-fans-weekly-points-link' => 'Puntos nesta semana',
	'top-fans-monthly-points-link' => 'Puntos neste mes',
	'top-fans-points' => 'puntos',
	'top-fans-by-category-title-edit-count' => 'Maior número de edicións globais',
	'top-fans-by-category-title-friends-count' => 'Maior número de amigos',
	'top-fans-by-category-title-foe-count' => 'Maior número de inimigos',
	'top-fans-by-category-title-gifts-rec-count' => 'Maior número de agasallos recibidos',
	'top-fans-by-category-title-gifts-sent-count' => 'Maior número de agasallos enviados',
	'top-fans-by-category-title-vote-count' => 'Maior número de votos',
	'top-fans-by-category-title-comment-count' => 'Maior número de comentarios',
	'top-fans-by-category-title-referrals-count' => 'Maior número de referencias',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Maior número de positivos',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Maior número de negativos',
	'top-fans-by-category-title-comment-score-positive-given' => 'Maior número de positivos dados',
	'top-fans-by-category-title-comment-score-negative-given' => 'Maior número de negativos dados',
	'top-fans-by-category-title-monthly-winner-count' => 'Maior número de vitorias mensuais',
	'top-fans-by-category-title-weekly-winner-count' => 'Maior número de vitorias semanais',
	'top-fans-bad-field-title' => 'Vaites!',
	'top-fans-bad-field-message' => 'A estatística especificada non existe.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Voto|Votos}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Vitoria mensual|Vitorias mensuais}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Vitoria semanal|Vitorias semanais}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edición|Edicións}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comentario|Comentarios}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referencia|Referencias}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amigo|Amigos}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Inimigo|Inimigos}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Opinión publicada|Opinións publicadas}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinión|Opinións}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Aprobación|Aprobacións}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Desaprobación|Desaprobacións}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Aprobación dada|Aprobacións dadas}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Desaprobación dada|Desaprobacións dadas}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Agasallo recibido|Agasallos recibidos}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Agasallo enviado|Agasallos enviados}}',
	'right-updatepoints' => 'Actualizar o contador de edicións',
	'right-generatetopusersreport' => 'Xerar informes dos principais usuarios',
	'level-advanced-to' => 'avanzou ata o nivel <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Agora é un "$1" en {{SITENAME}}!',
	'level-advance-body' => 'Ola $1:

Agora é un "$2" en {{SITENAME}}!

Parabéns,

O equipo de {{SITENAME}}

---
Quere deixar de recibir correos electrónicos nosos?

Faga clic $3
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
	'generatetopusersreport' => 'Xerar o informe dos principais usuarios',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Gañador|Gañadores}} da semana',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Gañador|Gañadores}} do mes',
	'user-stats-weekly-win-congratulations' => 'Parabéns {{PLURAL:$1|ao seguinte usuario|aos seguintes usuarios}}, que {{PLURAL:$1|gañou|gañaron}} un premio semanal e $2 {{PLURAL:$2|punto adicional|puntos adicionais}}!',
	'user-stats-monthly-win-congratulations' => 'Parabéns {{PLURAL:$1|ao seguinte usuario|aos seguintes usuarios}}, que {{PLURAL:$1|gañou|gañaron}} un premio mensual e $2 {{PLURAL:$2|punto adicional|puntos adicionais}}!',
	'user-stats-full-top' => 'Os $1 primeiros',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|punto|puntos}}!",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|punto|puntos}}",
	'user-stats-report-generation-note' => 'esta páxina foi xerada automaticamente',
	'user-stats-report-weekly-edit-summary' => 'informe de usuarios semanal automático',
	'user-stats-report-monthly-edit-summary' => 'informe de usuarios mensual automático',
	'user-stats-report-weekly-page-title' => 'Informe semanal de puntos dos usuarios ($1)',
	'user-stats-report-monthly-page-title' => 'Informe mensual de puntos dos usuarios ($1)',
	'user-stats-report-error-variable-not-set' => 'A variable $wgUserStatsPointValues[\'points_winner_$1\'] debe ter un valor maior que 0 en LocalSettings.php!',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Σχόλιον|Σχόλια}}',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'user-stats-alltime-title' => 'Am meischte Pinkt (insgsamt)',
	'user-stats-weekly-title' => 'Am meischte Pinkt in däre Wuche',
	'user-stats-monthly-title' => 'Am meische Pinkt in däm Monet',
	'topusers' => 'Top-Benutzer',
	'top-fans-by-points-nav-header' => 'Top-Fan',
	'top-fans-by-category-nav-header' => 'Top-per-Kategorii',
	'top-fans-total-points-link' => 'Gsamtpunktzahl',
	'top-fans-weekly-points-link' => 'Pinkt in däre Wuche',
	'top-fans-monthly-points-link' => 'Pinkt in däm Monet',
	'top-fans-points' => 'Pinkt',
	'top-fans-by-category-title-edit-count' => 'Ranglischte Gsamtzahl Bearbeitige',
	'top-fans-by-category-title-friends-count' => 'Ranglischte Gsamtzahl Frynd',
	'top-fans-by-category-title-foe-count' => 'Ranglischte Gsamtzahl Fynd',
	'top-fans-by-category-title-gifts-rec-count' => 'Ranglischte Gsamtzahl empfangeni Gschänk',
	'top-fans-by-category-title-gifts-sent-count' => 'Ranglischte Gsamtzahl verschickti Gschänk',
	'top-fans-by-category-title-vote-count' => 'Ranglischte Gsamtzahl Stimme',
	'top-fans-by-category-title-comment-count' => 'Ranglischte Gsamtzahl Aamerkige',
	'top-fans-by-category-title-referrals-count' => 'Ranglischte Gsamtzahl Empfählige',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Ranglischte Gsamtzahl Duume uffe',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Ranglischte Gsamtzahl Duume aabe',
	'top-fans-by-category-title-comment-score-positive-given' => 'Ranglischte Gsamtzahl Duume uffe zeigt',
	'top-fans-by-category-title-comment-score-negative-given' => 'Ranglischte Gsamtzahl Duume aabe zeigt',
	'top-fans-by-category-title-monthly-winner-count' => 'Ranglischte Gsamtzahl Monatligi Gwinn',
	'top-fans-by-category-title-weekly-winner-count' => 'Ranglischte Gsamtzahl Wuchegwinn',
	'top-fans-bad-field-title' => 'Hoppla!',
	'top-fans-bad-field-message' => 'Die Statischtik git s nit.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Stimm|Stimme}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Monetsgwinn|Monatsgwinn}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Wuchegwinn|Wuchegwinn}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Bearbeitig|Bearbeitige}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Kommentar|Kommentar}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Empfählig|Empfählige}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Frynd|Frynd}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Fynd|Fynd}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Vereffentligti Meinig|Vereffentligti Meinige}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Meinig|Meinige}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Duume ufezues|Dyyme ufezues}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Duume abezues|Dyyme aabezues}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Duume ufezues|Dyyme ufezues}} gee',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Duume abezues|Dyyme abezues}} gee',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Gschänk iberchu|Gschänk inerchu}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Gschänk gmacht|Gschänk gmacht}}',
	'right-updatepoints' => 'Bearbeitigszeller aktualisiere',
	'right-generatetopusersreport' => 'Bericht über di aktivste Benutzern generiere',
	'level-advanced-to' => 'furtgschritte zum Level <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Du bisch jetz „$1“ uf {{SITENAME}}!',
	'level-advance-body' => 'Sali $1,

Du bisch jetz e „$2“ uf {{SITENAME}}!

S {{SITENAME}}-Team grateliert Dir!

---
Du witt gar kei E-Mail vu uns iberchu?

Druck $3
un ändere Dyyi Yystellige go d E-Mail-Benochrichtigunge abzstelle.',
	'generatetopusersreport' => 'Bericht über di aktivste Benutzern generiere',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Wuchesiiger|Wuchesiiger}}',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Monetssiiger|Monetssiiger}}',
	'user-stats-weekly-win-congratulations' => 'Härzliche Glickwunsch aa {{PLURAL:$1|de Benutzer, wo de Wuchesiig errunge un {{PLURAL:$2|Zuesatzpunkt|Zuesatzpinkt}} erhalte het.|e Benutzer, wo de Wuchesiig errunge un {{PLURAL:$2|Zuesatzpunkt|Zuesatzpinkt}} erhalte hen.}}',
	'user-stats-monthly-win-congratulations' => 'Härzliche Glickwunsch aa {{PLURAL:$1|de Benutzer, wo de Monetsiig errunge un {{PLURAL:$2|Zuesatzpunkt|Zuesatzpinkt}} erhalte het.|e Benutzer, wo de Monetsiig errunge un {{PLURAL:$2|Zuesatzpunkt|Zuesatzpinkt}} erhalte hen.}}',
	'user-stats-full-top' => 'Alli Top $1',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|Punkt|Pünkt}}",
	'user-stats-report-points' => '$1 {{PLURAL:$1|Punkt|Pinkt}}',
	'user-stats-report-generation-note' => 'Die Syte isch automatisch generiert worde.',
	'user-stats-report-weekly-edit-summary' => 'automatisierter wöchentlicher Benutzerbericht',
	'user-stats-report-monthly-edit-summary' => 'automatisierter monatlicher Benutzerbericht',
	'user-stats-report-weekly-page-title' => 'Wöchentlicher Benutzerpunktbericht ($1)',
	'user-stats-report-monthly-page-title' => 'Monatlicher Benutzerpunktebericht ($1)',
	'user-stats-report-error-variable-not-set' => 'Für de Parameter $wgUserStatsPointValues[\'points_winner_$1\'] in de Datei LocalSettings.php muess en Wärt größer wie 0 aagee sy.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'user-stats-alltime-title' => 'מספר הנקודות המירבי בכל הזמנים',
	'user-stats-weekly-title' => 'מספר הנקודות המירבי השבוע',
	'user-stats-monthly-title' => 'מספר הנקודות המירבי החודש',
	'topusers' => 'המשתמשים המובילים',
	'top-fans-by-points-nav-header' => 'המעריצים המובילים',
	'top-fans-by-category-nav-header' => 'מובילים לפי קטגוריה',
	'top-fans-total-points-link' => 'סך כל הנקודות',
	'top-fans-weekly-points-link' => 'נקודות השבוע',
	'top-fans-monthly-points-link' => 'נקודות החודש',
	'top-fans-points' => 'נקודות',
	'top-fans-by-category-title-edit-count' => 'סך הכול עריכות',
	'top-fans-by-category-title-friends-count' => 'סך הכול חברים',
	'top-fans-by-category-title-foe-count' => 'סך הכול יריבים',
	'top-fans-by-category-title-gifts-rec-count' => 'סך הכול מתנות שהתקבלו',
	'top-fans-by-category-title-gifts-sent-count' => 'סך הכול מתנות שנשלחו',
	'top-fans-by-category-title-vote-count' => 'סך הכול הצבעות',
	'top-fans-by-category-title-comment-count' => 'סך הכול הערות',
	'top-fans-by-category-title-referrals-count' => 'סך הכול הפניות',
	'top-fans-by-category-title-comment-score-positive-rec' => 'סך הכול המלצות',
	'top-fans-by-category-title-comment-score-negative-rec' => 'סך הכול גינויים',
	'top-fans-by-category-title-comment-score-positive-given' => 'סך הכול המלצות שניתנו',
	'top-fans-by-category-title-comment-score-negative-given' => 'סך הכול גינויים שניתנו',
	'top-fans-by-category-title-monthly-winner-count' => 'סך הכול ניצחונות חודשיים',
	'top-fans-by-category-title-weekly-winner-count' => 'סך הכול ניצחונות שבועיים',
	'top-fans-bad-field-title' => 'אופס!',
	'top-fans-bad-field-message' => 'הסטטיסטיקה שצוינה אינה קיימת.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|הצבעה|הצבעות}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|נצחון חודשי|נצחונות חודשיים}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|נצחון שבועי|נצחונות שבועיים}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|עריכה|עריכות}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|הערה|הערות}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|הפניה|הפניות}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|חבר|חברים}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|יריב|יריבים}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|דעה שפורסמה|דעות שפורסמו}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|דעה|דעות}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|המלצה|המלצות}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|גינוי|גינויים}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|ניתנה המלצה|ניתנו המלצות}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|ניתן גינוי|ניתנו גינויים}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|התקבלה מתנה|התקבלו מתנות}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|נשלחה מתנה|נשלחו מתנות}}',
	'right-updatepoints' => 'עדכון מספרי העריכות',
	'level-advanced-to' => 'התקדמות לשלב <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'כעת הינכם  "$1" ב{{grammar:תחילית|{{SITENAME}}}}!',
	'level-advance-body' => 'שלום $1:

כעת הנכם "$2" ב{{grammar:תחילית|{{SITENAME}}}}!

ברכותינו,

צוות {{SITENAME}}

---
מעוניינים להפסיק לקבל מאיתנו הודעות?

לחצו $3
ושנו את הגדרותיכם כדי לבטל התראות בדואר אלקטרוני.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'user-stats-alltime-title' => 'Najwjace dypkow za cyłu dobu',
	'user-stats-weekly-title' => 'Najwjace dypkow tutón tydźeń',
	'user-stats-monthly-title' => 'Najwjace dypkow tutón měsac',
	'topusers' => 'Najlěpši wužiwarjo',
	'top-fans-by-points-nav-header' => 'Najlěpši přiwisnicy',
	'top-fans-by-category-nav-header' => 'Najlěpši po kategoriji',
	'top-fans-total-points-link' => 'Dypki w cyłku',
	'top-fans-weekly-points-link' => 'Dypki tutón tydźeń',
	'top-fans-monthly-points-link' => 'Dypki tutón měsac',
	'top-fans-points' => 'dypki',
	'top-fans-by-category-title-edit-count' => 'Najwjace změnow',
	'top-fans-by-category-title-friends-count' => 'Najwjace přećelow',
	'top-fans-by-category-title-foe-count' => 'Najwjace njepřećelow',
	'top-fans-by-category-title-gifts-rec-count' => 'Najwjace dóstanych darow',
	'top-fans-by-category-title-gifts-sent-count' => 'Najwjace datych darow',
	'top-fans-by-category-title-vote-count' => 'Najwjace hłosow',
	'top-fans-by-category-title-comment-count' => 'Najwjace komentarow',
	'top-fans-by-category-title-referrals-count' => 'Najwjace poručenjow',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Najwjace přihłosowanjow',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Najwjace wotpokazanjow',
	'top-fans-by-category-title-comment-score-positive-given' => 'Najwjace datych přihłosowanjow',
	'top-fans-by-category-title-comment-score-negative-given' => 'Najwjace datych wotpokazanjow',
	'top-fans-by-category-title-monthly-winner-count' => 'Najwjace měsačnych dobyćow',
	'top-fans-by-category-title-weekly-winner-count' => 'Najwjace tydźenskich dobyćow',
	'top-fans-bad-field-title' => 'Hopla!',
	'top-fans-bad-field-message' => 'Podata statistika njeeksistuje.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|hłós|hłosaj|hłosy|hłosow}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Měsačne dobyće|Měsačnej dobyći|Měsačne dobyća|Měsačnych dobyćow}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Tydźenske dobyće|Tydźenskej dobyći|Tydźenske dobyća|Tydźenskich dobyćow}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|$1|ZMěna|Změnje|Změny|Změnow}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komentar|Komentaraj|Komentary|Komentarow}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referenca|Referency|Referency|Referencow}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Přećel|Přećelej|Přećeljo|Přećelow}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Njepřećel|Njepřećelej|Njepřećeljo|Njepřećelow}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Wozjewjene měnjenje|Wozjewjenej měnjeni|Wozjewjene měnjenja|Wozjewjenych měnjenjow}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Měnjenje|Měnjeni|Měnjenja|Měnjenjow}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Palc|Palcaj|Palcy|Palcow}} horje',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Palc|Palcaj|Palcy|Palcow}} dele',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Data sława|Datej sławje|Date sławy|Datych sławow}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Podata fujwołanje|Podatej fujwołani|Podate fujwołanja|Podatych fujwołanjow}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Dóstany dar|Dóstanej daraj|Dóstane dary|Dóstanych darow}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Pósłany dar|Pósłanej daraj|Pósłane dary|Pósłanych darow}}',
	'right-updatepoints' => 'Ličbu změnow aktualizować',
	'level-advanced-to' => 'postupi k runinje <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Sy nětko "$1" na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'level-advance-body' => 'Witaj $1:

Sy nětko "$2" na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

Zbožopřeća,

Team {{GRAMMAR:genitiw|{{SITENAME}}}}

---
Nochceš hižo žane e-mejlki wot nas dóstać?

Klikń na $3
a změn swoje nastajenja, zo by e-mejlowe zdźělenki znjemóžnił.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'user-stats-alltime-title' => 'Minden idők legtöbb pontjai',
	'user-stats-weekly-title' => 'Legtöbb pont a héten',
	'user-stats-monthly-title' => 'Legtöbb pont a hónapban',
	'topusers' => 'Vezető felhasználók',
	'top-fans-by-points-nav-header' => 'Vezető rajongók',
	'top-fans-by-category-nav-header' => 'Vezetők kategória szerint',
	'top-fans-total-points-link' => 'Összes pont',
	'top-fans-weekly-points-link' => 'Pontok ezen a héten',
	'top-fans-monthly-points-link' => 'Pontok ebben a hónapban',
	'top-fans-points' => 'pont',
	'top-fans-by-category-title-edit-count' => 'Összesített szerkesztések toplista',
	'top-fans-by-category-title-friends-count' => 'Összesített barátok toplista',
	'top-fans-by-category-title-foe-count' => 'Összesített ellenségek toplista',
	'top-fans-by-category-title-gifts-rec-count' => 'Összesített ajándékok toplista',
	'top-fans-by-category-title-gifts-sent-count' => 'Összesített küldött ajándékok toplista',
	'top-fans-by-category-title-vote-count' => 'Összesített szavazatok toplista',
	'top-fans-by-category-title-comment-count' => 'Összesített megjegyzések toplista',
	'top-fans-by-category-title-referrals-count' => 'Összesített beszámolók toplista',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Összesített felfelé tartott hüvelykujjak toplista',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Összesített lefelé tartott hüvelykujjak toplista',
	'top-fans-by-category-title-comment-score-positive-given' => 'Összesített adott felfelé tartott hüvelykujjak toplista',
	'top-fans-by-category-title-comment-score-negative-given' => 'Összesített adott lefelé tartott hüvelykujjak toplista',
	'top-fans-by-category-title-monthly-winner-count' => 'Összesített havi győzelmek toplista',
	'top-fans-by-category-title-weekly-winner-count' => 'Összesített heti győzelmek toplista',
	'top-fans-bad-field-title' => 'Hupsz!',
	'top-fans-bad-field-message' => 'A megadott statisztika nem létezik.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|szavazat|szavazat}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|havi győzelem|havi győzelem}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|heti győzelem|heti győzelem}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|szerkesztés|szerkesztés}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|megjegyzés|megjegyzés}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|ajánlás|ajánlás}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|barát|barát}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|ellenség|ellenség}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|publikált vélemény|publikált vélemény}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|vélemény|vélemény}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|felfelé tartott hüvelykujj|felfelé tartott hüvelykujj}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|lefelé tartott hüvelykujj|lefelé tartott hüvelykujj}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|adott felfelé tartott hüvelykujj|adott felfelé tartott hüvelykujj}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|adott lefelé tartott hüvelykujj|adott lefelé tartott hüvelykujj}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|fogadott ajándék|fogadott ajándék}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|küldött ajándék|küldött ajándék}}',
	'right-updatepoints' => 'Szerkesztésszámláló frissítése',
	'level-advanced-to' => 'előlépett a(z) <span style="font-weight:800;">$1</span> szintre',
	'level-advance-subject' => 'Mostantól „$1” vagy a {{SITENAME}} oldalon!',
	'level-advance-body' => 'Szia, $1!

$2 lettél a(z) {{SITENAME}} wikin!

Gratulálunk,
a(z) {{SITENAME}} csapata

---
Szeretnéd, ha nem zaklatnánk több e-maillel?

Kattints a következő hivatkozásra: $3
és tiltsd le az e-mailes értesítéseket a beállításaidban.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'user-stats-alltime-title' => 'Le plus punctos de omne tempore',
	'user-stats-weekly-title' => 'Le plus punctos de iste septimana',
	'user-stats-monthly-title' => 'Le plus punctos de iste mense',
	'topusers' => 'Usatores supreme',
	'top-fans-by-points-nav-header' => 'Admiratores supreme',
	'top-fans-by-category-nav-header' => 'Summitate per categoria',
	'top-fans-total-points-link' => 'Total del punctos',
	'top-fans-weekly-points-link' => 'Punctos de iste septimana',
	'top-fans-monthly-points-link' => 'Punctos de iste mense',
	'top-fans-points' => 'punctos',
	'top-fans-by-category-title-edit-count' => 'Classamento global de modificationes',
	'top-fans-by-category-title-friends-count' => 'Classamento global de amicos',
	'top-fans-by-category-title-foe-count' => 'Classamento global de inimicos',
	'top-fans-by-category-title-gifts-rec-count' => 'Classamento global de presentes recipite',
	'top-fans-by-category-title-gifts-sent-count' => 'Classamento global de presentes inviate',
	'top-fans-by-category-title-vote-count' => 'Classamento global de votos',
	'top-fans-by-category-title-comment-count' => 'Classamento global de commentos',
	'top-fans-by-category-title-referrals-count' => 'Classamento global de referimentos',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Classamento global de approbationes',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Classamento global de denunciationes',
	'top-fans-by-category-title-comment-score-positive-given' => 'Classamento global de approbationes date',
	'top-fans-by-category-title-comment-score-negative-given' => 'Classamento global de denunciationes date',
	'top-fans-by-category-title-monthly-winner-count' => 'Classamento global de ganios mensual',
	'top-fans-by-category-title-weekly-winner-count' => 'Classamento global de ganios septimanal',
	'top-fans-bad-field-title' => 'Ups!',
	'top-fans-bad-field-message' => 'Le statistica specificate non existe.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Voto|Votos}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Victoria mensual|Victorias mensual}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Victoria septimanal|Victorias septimanal}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Modification|Modificationes}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Commento|Commentos}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referentia|Referentias}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amico|Amicos}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Inimico|Inimicos}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Opinion|Opiniones}} publicate',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinion|Opiniones}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Acclamation|Acclamationes}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Disapprobation|Disapprobationes}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Acclamation|Acclamationes}} date',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Disapprobation|Disapprobationes}} date',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Dono|Donos}} recipite',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Dono|Donos}} inviate',
	'right-updatepoints' => 'Actualisar le contator de modificationes',
	'right-generatetopusersreport' => 'Generar reportos del usatores le plus active',
	'level-advanced-to' => 'avantiava verso le nivello <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Tu es ora un "$1" in {{SITENAME}}!',
	'level-advance-body' => 'Salute $1,

Tu es ora un "$2" in {{SITENAME}}!

Felicitationes,

Le equipa de {{SITENAME}}

---
Tu non vole reciper plus e-mail de nos?

Clicca $3
e disactiva in tu preferentias le notificationes per e-mail.',
	'generatetopusersreport' => 'Generar reporto del usatores le plus active',
	'user-stats-weekly-winners' => 'Le {{PLURAL:$1|ganiator|ganiatores}} del septimana',
	'user-stats-monthly-winners' => 'Le {{PLURAL:$1|ganiator|ganiatores}} del mense',
	'user-stats-weekly-win-congratulations' => 'Felicitationes al sequente {{PLURAL:$1|usator|usatores}} que meritava un ganio septimanal e $2 {{PLURAL:$2|puncto|punctos}} extra!',
	'user-stats-monthly-win-congratulations' => 'Felicitationes al sequente {{PLURAL:$1|usator|usatores}} que meritava un ganio mensual e $2 {{PLURAL:$2|puncto|punctos}} extra!',
	'user-stats-full-top' => 'Le top $1 complete',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|puncto|punctos}}",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|puncto|punctos}}!",
	'user-stats-report-generation-note' => 'iste pagina ha essite generate automaticamente',
	'user-stats-report-weekly-edit-summary' => 'reporto de usator septimanal automatic',
	'user-stats-report-monthly-edit-summary' => 'reporto de usator mensual automatic',
	'user-stats-report-weekly-page-title' => 'Reporto de punctos de usator septimanal ($1)',
	'user-stats-report-monthly-page-title' => 'Reporto de punctos de usator mensual ($1)',
	'user-stats-report-error-variable-not-set' => 'Le variabile $wgUserStatsPointValues[\'points_winner_$1\'] debe haber un valor superior a 0 in LocalSettings.php!',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 */
$messages['id'] = array(
	'user-stats-alltime-title' => 'Poin terbanyak sepanjang masa',
	'user-stats-weekly-title' => 'Poin terbanyak minggu ini',
	'user-stats-monthly-title' => 'Poin terbanyak bulan ini',
	'topusers' => 'Pengguna teratas',
	'top-fans-by-points-nav-header' => 'Penggemar teratas',
	'top-fans-by-category-nav-header' => 'Teratas menurut kategori',
	'top-fans-total-points-link' => 'Poin total',
	'top-fans-weekly-points-link' => 'Poin minggu ini',
	'top-fans-monthly-points-link' => 'Poin bulan ini',
	'top-fans-points' => 'poin',
	'top-fans-by-category-title-edit-count' => 'Suntingan keseluruhan teratas',
	'top-fans-by-category-title-friends-count' => 'Teman keseluruhan teratas',
	'top-fans-by-category-title-foe-count' => 'Musuh keseluruhan teratas',
	'top-fans-by-category-title-gifts-rec-count' => 'Hadiah diterima keseluruhan teratas',
	'top-fans-by-category-title-gifts-sent-count' => 'Hadiah terkirim keseluruhan teratas',
	'top-fans-by-category-title-vote-count' => 'Suara keseluruhan teratas',
	'top-fans-by-category-title-comment-count' => 'Komentar keseluruhan teratas',
	'top-fans-by-category-title-referrals-count' => 'Saran keseluruhan teratas',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Jempol naik keseluruhan teratas',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Jempol turun keseluruhan teratas',
	'top-fans-by-category-title-comment-score-positive-given' => 'Hadiah jempol naik keseluruhan teratas',
	'top-fans-by-category-title-comment-score-negative-given' => 'Hadiah jempol turun keseluruhan teratas',
	'top-fans-by-category-title-monthly-winner-count' => 'Pemenang bulanan keseluruhan teratas',
	'top-fans-by-category-title-weekly-winner-count' => 'Pemenang mingguan keseluruhan teratas',
	'top-fans-bad-field-title' => 'Oh tidak!',
	'top-fans-bad-field-message' => 'Statistik yang diminta tidak ada.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1||}}Suara',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1||}}Kemenangan bulanan',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1||}}Kemenangan mingguan',
	'top-fans-stats-edit-count' => '{{PLURAL:$1||}}Suntingan',
	'top-fans-stats-comment-count' => '{{PLURAL:$1||}}Komentar',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1||}}Rujukan',
	'top-fans-stats-friends-count' => '{{PLURAL:$1||}}Kawan',
	'top-fans-stats-foe-count' => '{{PLURAL:$1||}}Lawan',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1||}}Opini yang dipublikasikan',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1||}}Opini',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1||}}Bagus',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1||}}Jelek',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1||}}Nilai bagus yang diberikan',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1||}}Nilai jelek yang diberikan',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1||}}Hadiah yang diterima',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1||}}Hadiah yang diberikan',
	'right-updatepoints' => 'Mutakhirkan penghitungan suntingan',
	'level-advanced-to' => 'naik ke level <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Anda sekarang adalah "$1" di {{SITENAME}}!',
	'level-advance-body' => 'Halo $1.

Sekarang Anda adalah "$2" di {{SITENAME}}!

Selamat,

Tim {{SITENAME}}

---
Mau berhenti mendapatkan pesan ini?

Klik $3
dan ganti seting Anda untuk mematikan pemberitahuan lewat surel.',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Redaktajo|Redaktaji}}',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Modifica|Modifiche}}',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'user-stats-alltime-title' => '通算最高得点者',
	'user-stats-weekly-title' => '今週の最高得点者',
	'user-stats-monthly-title' => '今月の最高得点者',
	'topusers' => '上位利用者',
	'top-fans-by-points-nav-header' => '上位ファン',
	'top-fans-by-category-nav-header' => 'カテゴリ別上位者',
	'top-fans-total-points-link' => '総得点',
	'top-fans-weekly-points-link' => '今週の得点',
	'top-fans-monthly-points-link' => '今月の得点',
	'top-fans-points' => '得点',
	'top-fans-by-category-title-edit-count' => '編集総数上位',
	'top-fans-by-category-title-friends-count' => '友人総数上位',
	'top-fans-by-category-title-foe-count' => '敵総数上位',
	'top-fans-by-category-title-gifts-rec-count' => '贈り物受け取り総数上位',
	'top-fans-by-category-title-gifts-sent-count' => '贈り物送信総数上位',
	'top-fans-by-category-title-vote-count' => '投票総数上位',
	'top-fans-by-category-title-comment-count' => 'コメント総数上位',
	'top-fans-by-category-title-referrals-count' => '推薦総数上位',
	'top-fans-by-category-title-comment-score-positive-rec' => '賛成総数上位',
	'top-fans-by-category-title-comment-score-negative-rec' => '反対総数上位',
	'top-fans-by-category-title-comment-score-positive-given' => '賛成受け取り総数上位',
	'top-fans-by-category-title-comment-score-negative-given' => '反対受け取り総数上位',
	'top-fans-by-category-title-monthly-winner-count' => '月間勝利総数上位',
	'top-fans-by-category-title-weekly-winner-count' => '週間勝利総数上位',
	'top-fans-bad-field-title' => 'おっと！',
	'top-fans-bad-field-message' => '指定した統計は存在しません。',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|投票}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|月間勝者}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|週間勝者}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|編集}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|コメント}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|推薦}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|友人}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|敵}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|公表された意見}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|意見}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|拍手}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|ブーイング}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|拍手}}をうけました',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|ブーイング}}を受けました',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|贈り物}}を受け取りました',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|贈り物}}を送りました',
	'right-updatepoints' => '編集回数を更新する',
	'level-advanced-to' => 'レベル<span style="font-weight:800;">$1</span>に上がりました',
	'level-advance-subject' => '{{SITENAME}}の"$1"になりました！',
	'level-advance-body' => '$1さん、こんにちは。

おめでとうございます。
$1さんは{{SITENAME}}の「$2」になりました！

{{SITENAME}}チーム

---
メール受信を停止したい場合は、
$3
をクリックして、メール通知を無効にするよう設定変更してください。',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'user-stats-alltime-title' => 'ពិន្ទុ​ខ្ពស់​បំផុត​សម្រាប់​រយៈពេល​ទាំងអស់',
	'user-stats-weekly-title' => 'ពិន្ទុ​ខ្ពស់បំផុត​សម្រាប់​សប្ដាហ៍​នេះ',
	'user-stats-monthly-title' => 'ពិន្ទុ​ខ្ពស់បំផុត​សម្រាប់​ខែ​នេះ',
	'topusers' => 'អ្នកប្រើប្រាស់​កំពូល',
	'top-fans-by-points-nav-header' => 'អ្នកគាំទ្រ​កំពូល',
	'top-fans-by-category-nav-header' => 'ច្រើនបំផុតតាម​​ចំណាត់ថ្នាក់ក្រុម',
	'top-fans-total-points-link' => 'ពិន្ទុ​សរុប',
	'top-fans-weekly-points-link' => 'ពិន្ទុ​សប្ដាហ៍​នេះ',
	'top-fans-monthly-points-link' => 'ពិន្ទុ​ខែ​នេះ',
	'top-fans-points' => 'ពិន្ទុ',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|បោះឆ្នោត|បោះឆ្នោត}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|អ្នកឈ្នះ​ប្រចាំខែ|អ្នកឈ្នះ​ប្រចាំខែ}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|អ្នកឈ្នះ​ប្រចាំសប្ដាហ៍|អ្នកឈ្នះ​ប្រចាំសប្ដាហ៍}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|កែប្រែ|កែប្រែ}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|វចនាធិប្បាយ|វចនាធិប្បាយ}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|ការផ្ទេរ|ការផ្ទេរ}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|មិត្តភ័ក្ដិ|មិត្តភ័ក្ដិ}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|បច្ចាមិត្ត|បច្ចាមិត្ត}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|ជម្រើស​បោះពុម្ពផ្សាយ|ជម្រើស​បោះពុម្ពផ្សាយ}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|ជម្រើស|ជម្រើស}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|ពង្រីក|ពង្រីក}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|បង្រួម|បង្រួម}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|ជំនូន​ដែល​បាន​ទទួល|ជំនូន​ដែល​បាន​ទទួល}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|ជំនូន​ដែល​បាន​ផ្ញើ|ជំនូន​ដែល​បាន​ផ្ញើ}}',
	'level-advance-subject' => 'ឥឡូវនេះ អ្នក​មាន "$1" នៅ {{SITENAME}}!',
	'level-advance-body' => 'សួស្ដី $1:

ឥឡូវនេះ អ្នក​មាន "$2" នៅ​លើ {{SITENAME}}!

សូមអបអរសាទរ,

ក្រុម {{SITENAME}}

---
ហេ៎, តើ​អ្នក​ពិតជា​ចង់​បញ្ឈប់​ការ​ទទួល​អ៊ីមែល​ពី​យើង​មែន​ឬ​?

សូម​ចុច $3
និង​ផ្លាស់ប្ដូរ​ការកំណត់​របស់​អ្នក ដើម្បី​បិទ​មិន​ទទួល​សេចក្ដីជូនដំណឹង​តាម​អ៊ីមែល​។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|ಸಂಪಾದನೆ|ಸಂಪಾದನೆಗಳು}}',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'user-stats-alltime-title' => 'De miehßte Punkte övver alle Zick',
	'user-stats-weekly-title' => 'De miehßte Punkte övver diß Woch',
	'user-stats-monthly-title' => 'De miehßte Punkte disse Mohnd',
	'topusers' => 'Spetze-Metmaachere',
	'top-fans-by-points-nav-header' => 'Aan de Spetz per Stemme',
	'top-fans-by-category-nav-header' => 'Aan der Spetz per Saachjropp',
	'top-fans-total-points-link' => 'Punkte ensjesamp',
	'top-fans-weekly-points-link' => 'Punkte diß Woch',
	'top-fans-monthly-points-link' => 'Punkte disse Mohnd',
	'top-fans-points' => 'Punkte',
	'top-fans-by-category-title-edit-count' => 'De miehßte Änderonge enßjesamp',
	'top-fans-by-category-title-friends-count' => 'De miehßte Fründe enßjesamp',
	'top-fans-by-category-title-foe-count' => 'De miehßte Feinde enßjesamp',
	'top-fans-by-category-title-gifts-rec-count' => 'De miehßte Jeschengke enßjesamp krääje',
	'top-fans-by-category-title-gifts-sent-count' => 'De miehßte Geschengke enßjesamp verdeilt',
	'top-fans-by-category-title-vote-count' => 'De miehßte Shtemme enßjesamp',
	'top-fans-by-category-title-comment-count' => 'De miehßte Kommentaare enßjesamp',
	'top-fans-by-category-title-referrals-count' => 'De miehßte Lengks enßjesamp',
	'top-fans-by-category-title-comment-score-positive-rec' => 'De miehßte „Duume erop“ enßjesamp krääje',
	'top-fans-by-category-title-comment-score-negative-rec' => 'De miehßte „Duume eraf“ enßjesamp krääje',
	'top-fans-by-category-title-comment-score-positive-given' => 'De miehßte Duume noh bovve enßjesamp verdeilt',
	'top-fans-by-category-title-comment-score-negative-given' => 'De miehßte Duume noh unge enßjesamp verdeilt',
	'top-fans-by-category-title-monthly-winner-count' => 'De miehßte Jewenne en enem Mohnd enßjesamp',
	'top-fans-by-category-title-weekly-winner-count' => 'De miehßte Jewenne en ene Woch enßjesamp',
	'top-fans-bad-field-title' => 'Hoppalla!',
	'top-fans-bad-field-message' => 'De aanjejovve Statistik jidd_et nit.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Stemm|Stemme}}',
	'top-fans-stats-monthly-winner-count' => 'Jewenn{{PLURAL:$1||e|—}} vum Mohnd',
	'top-fans-stats-weekly-winner-count' => 'wöschentlesche Jewenn{{PLURAL:$1||e|—}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Änderung|Änderunge}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Kommentaa|Kommentaare}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Verwies|Verwiese}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Frünnd|Frünnde}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Feind|Feinde}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|öffentlesch afjejovve Meinung|veröffentleschte Meinunge}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Meinung|Meinunge}}',
	'top-fans-stats-comment-score-positive-rec' => '<!--{{PLURAL:$1}}-->„Duume erop“',
	'top-fans-stats-comment-score-negative-rec' => '<!--{{PLURAL:$1}}-->„Dume eraf“',
	'top-fans-stats-comment-score-positive-given' => '<!--{{PLURAL:$1}}-->Duume noh bovve',
	'top-fans-stats-comment-score-negative-given' => '<!--{{PLURAL:$1}}-->Duume noh unge',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Jeschenk|Jeschenke}} kräje',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Jeschenk|Jeschenke}} jejovve',
	'right-updatepoints' => 'De Aanzahl Änderunge ändere',
	'level-advanced-to' => 'opjeschtoof op dat Nivoh <span style="font-weight:800">$1</span>',
	'level-advance-subject' => 'Do bes jätz ene „$1“ {{GRAMMAR:vum|{{SITENAME}}}}!',
	'level-advance-body' => 'Hallo $1,

Do bes jetz ene $2 {{GRAMMAR:vum|{{SITENAME}}}}!

Hätzlesche Jlöckwonsch fun de janze {{SITENAME}}

---

Wells De kein e-mail fun uns han? Dann kleck
$3
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'user-stats-alltime-title' => 'Am Meeschte Punkte vn allen Zäiten',
	'user-stats-weekly-title' => 'Am Meeschte Punkten dës Woch',
	'user-stats-monthly-title' => 'Am meeschte Punkten dëse Mount',
	'topusers' => 'Top Benotzer',
	'top-fans-by-points-nav-header' => 'Top vun de Fans',
	'top-fans-by-category-nav-header' => 'Top pro Kategorie',
	'top-fans-total-points-link' => 'Total vun de Punkten',
	'top-fans-weekly-points-link' => 'Punkte vun dëser Woch',
	'top-fans-monthly-points-link' => 'Punkte vun dësem Mount',
	'top-fans-points' => 'Punkten',
	'top-fans-by-category-title-edit-count' => 'héichsten Zuel vu globalen Ännerungen',
	'top-fans-by-category-title-friends-count' => 'Héichst Zuel vu globale Frënn',
	'top-fans-by-category-title-foe-count' => 'mat de meeschte Feinden',
	'top-fans-by-category-title-gifts-rec-count' => 'Am meeschte Cadeaue kritt',
	'top-fans-by-category-title-gifts-sent-count' => 'Am meeschte Cadeaue gemaach',
	'top-fans-by-category-title-vote-count' => 'Am meeschte Stëmmen',
	'top-fans-by-category-title-comment-count' => 'Am meeschte Bemierkungen',
	'top-fans-by-category-title-referrals-count' => 'Am meeschte Referenzen',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Am meeschten Dommen no uewen',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Am meeschten Dommen no ënnen',
	'top-fans-by-category-title-comment-score-positive-given' => 'Am meeschten Dommen no uewe verdeelt',
	'top-fans-by-category-title-comment-score-negative-given' => 'Am meeschten Dommen no ënne verdeelt',
	'top-fans-by-category-title-monthly-winner-count' => 'Am dackste Gewënner vum Mount',
	'top-fans-by-category-title-weekly-winner-count' => 'Am dackste Gewënner vun der Woch',
	'top-fans-bad-field-title' => 'Ups!',
	'top-fans-bad-field-message' => 'Déi gefrote Statistik gëtt et net.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Stëmm|Stëmmen}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Gewënner vum Mount|Gewënner vum Mount}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Gewënn vun der Woch|Gewënner vun der Woch}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Ännerung|Ännerungen}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Bemierkung|Bemierkungen}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referenz|Referenzen}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Frënd|Frënn}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Géigner|Géigner}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Verëffentlecht Meenung| Verëffentlecht Meenungen}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Meenung|Meenungen}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Daum no uewen|Daumen no uewen}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Daum no ënnen|Daumen no ënnen}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Daum no uewe|Daumen no uewe}} ginn',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Daum no ënne|Daumen no ënne}} ginn',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Cadeau kritt|Cadeaue kritt}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Cadeau|Cadeauë}} geschéckt',
	'right-updatepoints' => 'De Compteur vun den Ännerungen aktualiséieren',
	'level-advanced-to' => 'ass op den Niveau <span style="font-weight:800;">$1</span> komm',
	'level-advance-subject' => 'Dir sidd elo "$1" op {{SITENAME}}!',
	'level-advance-body' => 'Bonjour $1:

Dir sidd elo e(n) "$2" op {{SITENAME}}!

Eis Felicitatiounen!

D\'Equipe vu(n) {{SITENAME}}

--
Wëllt Dir keng E-Maile méi vun eis kréien?

Klickt $3
an ännert Är Astellungen a schalt den E-Mai-Benoriichtungssystem aus.',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Gewënner|Gewënner}} vun der Woch',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Gewënner|Gewënner}} vum Mount',
	'user-stats-full-top' => 'Komplett Top $1',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|Punkt|Pukten}}",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|Punkt|Punkten}}",
	'user-stats-report-generation-note' => 'Dës Säit gouf automatesch generéiert',
	'user-stats-report-weekly-edit-summary' => 'automatesche Benotzer-Rapport pro Woch',
	'user-stats-report-monthly-edit-summary' => 'automatesche Benotzer-Rapport pro Mount',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'user-stats-alltime-title' => 'Највеќе бодови на сите времиња',
	'user-stats-weekly-title' => 'Највеќе бодови за неделава',
	'user-stats-monthly-title' => 'Највеќе бодови за месецов',
	'topusers' => 'Водечки корисници',
	'top-fans-by-points-nav-header' => 'Водечки обожаватели',
	'top-fans-by-category-nav-header' => 'Водечки по категорија',
	'top-fans-total-points-link' => 'Вкупно бодови',
	'top-fans-weekly-points-link' => 'Бодови за неделава',
	'top-fans-monthly-points-link' => 'Бодови за овој месец',
	'top-fans-points' => 'бода',
	'top-fans-by-category-title-edit-count' => 'Водечки вкупни уредувања',
	'top-fans-by-category-title-friends-count' => 'Водечки вкупни пријатели',
	'top-fans-by-category-title-foe-count' => 'Водечки вкупни непријатели',
	'top-fans-by-category-title-gifts-rec-count' => 'Водечки вкупни примени подароци',
	'top-fans-by-category-title-gifts-sent-count' => 'Најкоторани вкупни подароци',
	'top-fans-by-category-title-vote-count' => 'Водечки вкупни гласови',
	'top-fans-by-category-title-comment-count' => 'Водечки вкупни коментари',
	'top-fans-by-category-title-referrals-count' => 'Навеќе вкупни упати',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Навеќе вкупни гласови „За“',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Навеќе вкупни гласови „Против“',
	'top-fans-by-category-title-comment-score-positive-given' => 'Навеќе вкупни дадени гласови „За“',
	'top-fans-by-category-title-comment-score-negative-given' => 'Навеќе вкупни дадени гласови „Против“',
	'top-fans-by-category-title-monthly-winner-count' => 'Водечки вкупни месечни победи',
	'top-fans-by-category-title-weekly-winner-count' => 'Водечки вкупни неделни победи',
	'top-fans-bad-field-title' => 'Упс!',
	'top-fans-bad-field-message' => 'Наведената статистика не постои.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Глас|Гласа}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Месечна победа|Месечни победи}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Неделна победа|Неделни победи}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Уредување|Уредувања}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Коментар|Коментари}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Упатување|Упатувања}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Пријател|Пријатели}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Непријател|Непријатели}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Објавено мислење|Објавени мислења}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Мислење|Мислења}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Глас „За“|Гласови „За“}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Глас „Против“|Гласови „Против“}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Дадени глас „За“|Дадени гласови „За“}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Даден глас „Против“|Дадени гласови „Против“}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Добиен подарок|Добиени подароци}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Испратен подарок|Испратени подароци}}',
	'right-updatepoints' => 'Подновување на бројачот на уредуваања',
	'right-generatetopusersreport' => 'Создавање на извештаи за корисници-предводници',
	'level-advanced-to' => 'прејде на ниво <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Сега сте „$1“ на {{SITENAME}}!',
	'level-advance-body' => 'Здраво $1.

Сега сте „$2“ на {{SITENAME}}!

Честитаме,

Екипата на {{SITENAME}}

---
Ако сакате повеќе да не примате писма од нас:

Кликнете $3
и во вашите прилагодувања оневозможете известувања по е-пошта.',
	'generatetopusersreport' => 'Создај извештај за корисници-предводници',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Победник|Победници}} за неделава',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Победник|Победници}} за месецов',
	'user-stats-weekly-win-congratulations' => '{{PLURAL:$1|Му честитаме на следниов корисник|Им честитаме на следниве корисници}} за освоената неделна победа и {{PLURAL:$2|дополнителниот $2 бод|дополнителните $2 бода}}!!',
	'user-stats-monthly-win-congratulations' => '{{PLURAL:$1|Му честитаме на следниов корисник|Им честитаме на следниве корисници}} за освоената месечна победа и {{PLURAL:$2|дополнителниот $2 бод|дополнителните $2 бода}}!!',
	'user-stats-full-top' => 'Сите $1 предводници',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|бод|бода}}!",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|бод|бода}}!",
	'user-stats-report-generation-note' => 'оваа страница е автоматски создадена',
	'user-stats-report-weekly-edit-summary' => 'автоматизиран неделен кориснички извештај',
	'user-stats-report-monthly-edit-summary' => 'автоматизиран месечен кориснички извештај',
	'user-stats-report-weekly-page-title' => 'Неделен извештај за короснички бодови ($1)',
	'user-stats-report-monthly-page-title' => 'Месечен извештај за короснички бодови ($1)',
	'user-stats-report-error-variable-not-set' => 'Променливата $wgUserStatsPointValues[\'points_winner_$1\'] мора да има вредност поголема од 0 во LocalSettings.php!',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Сэтгэгдэл|Сэтгэгдлүүд}}',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'top-fans-bad-field-title' => 'Harap maaf',
	'top-fans-bad-field-message' => 'Statistik yang dinyatakan tidak wujud.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Undian|Undian}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Kemenangan bulanan|Kemenangan bulanan}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Kemenangan mingguan|Kemenangan mingguan}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Suntingan|Suntingan}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komen|Komen}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Rujukan|Rujukan}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Kawan|Kawan}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Musuh|Musuh}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Pendapat tersiar|Pendapat tersiar}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Pendapat|Pendapat}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Suka|Suka}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Tak suka|Tak suka}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Undian suka|Undian suka}} yang diberikan',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Undian tak suka|Undian tak suka}} yang diberikan',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Hadiah diterima|Hadiah diterima}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Hadiah dihantar|Hadiah dihantar}}',
	'right-updatepoints' => 'Mengemas kini kiraan suntingan',
	'right-generatetopusersreport' => 'Menjana laporan pengguna terunggul',
	'level-advanced-to' => 'maju ke tahap <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Kini, anda seorang "$1" di {{SITENAME}}!',
	'generatetopusersreport' => 'Jana Laporan Pengguna Terunggul',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Pemenang|Pemenang}} Mingguan',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Pemenang|Pemenang}} Bulanan',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' mata",
	'user-stats-report-weekly-page-title' => 'Laporan Mata Pengguna Mingguan ($1)',
	'user-stats-report-monthly-page-title' => 'Laporan Mata Pengguna Bulanan ($1)',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'topusers' => 'Huēyi tlatequitiltilīlli',
	'top-fans-by-points-nav-header' => 'Huēyi fans',
	'top-fans-by-category-nav-header' => 'Huēyi neneuhcāyōcopa',
	'top-fans-bad-field-title' => '¡Ō!',
);

/** Dutch (Nederlands)
 * @author Purodha
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'user-stats-alltime-title' => 'Meeste punten aller tijden',
	'user-stats-weekly-title' => 'Meeste punten deze week',
	'user-stats-monthly-title' => 'Meeste punten deze maand',
	'topusers' => 'Topgebruikers',
	'top-fans-by-points-nav-header' => 'Topfans',
	'top-fans-by-category-nav-header' => 'Top per categorie',
	'top-fans-total-points-link' => 'Totaal punten',
	'top-fans-weekly-points-link' => 'Punten deze week',
	'top-fans-monthly-points-link' => 'Punten per maand',
	'top-fans-points' => 'punten',
	'top-fans-by-category-title-edit-count' => 'Ranglijst totaal aantal bewerkingen',
	'top-fans-by-category-title-friends-count' => 'Ranglijst totaal aantal vrienden',
	'top-fans-by-category-title-foe-count' => 'Ranglijst totaal aantal tegenstanders',
	'top-fans-by-category-title-gifts-rec-count' => 'Ranglijst totaal aantal ontvangen presentjes',
	'top-fans-by-category-title-gifts-sent-count' => 'Ranglijst totaal aantal verstuurde presentjes',
	'top-fans-by-category-title-vote-count' => 'Ranglijst totaal aantal stemmen',
	'top-fans-by-category-title-comment-count' => 'Ranglijst totaal aantal opmerkingen',
	'top-fans-by-category-title-referrals-count' => 'Ranglijst totaal aantal vrienden',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Ranglijst totaal aantal schouderklopjes',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Ranglijst totaal aantal duimen omlaag',
	'top-fans-by-category-title-comment-score-positive-given' => 'Ranglijst totaal aantal schouderklopjes gegeven',
	'top-fans-by-category-title-comment-score-negative-given' => 'Ranglijst totaal aantal duimen omlaag gegeven',
	'top-fans-by-category-title-monthly-winner-count' => 'Ranglijst totaal aantal maandoverwinningen',
	'top-fans-by-category-title-weekly-winner-count' => 'Ranglijst totaal aantal weekoverwinningen',
	'top-fans-bad-field-title' => 'Oeps!',
	'top-fans-bad-field-message' => 'De opgegeven statistiek bestaat niet.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Stem|Stemmen}}',
	'top-fans-stats-monthly-winner-count' => 'Maandelijkse {{PLURAL:$1|overwinning|overwinningen}}',
	'top-fans-stats-weekly-winner-count' => 'Wekelijkse {{PLURAL:$1|overwinning|overwinningen}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Bewerking|Bewerkingen}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Opmerking|Opmerkingen}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Verwijzing|Verwijzingen}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Vriend|Vrienden}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Tegenstander|Tegenstanders}}',
	'top-fans-stats-opinions-published' => 'Gepubliceerde {{PLURAL:$1|mening|meningen}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Mening|Meningen}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Duim|Duimen}} omhoog',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Duim|Duimen}} omlaag',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Duim|Duimen}} omhoog uitgedeeld',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Duim|Duimen}} omlaag uitgedeeld',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Cadeautje|Cadeautjes}} ontvangen',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Cadeautje|Cadeautjes}} gestuurd',
	'right-updatepoints' => 'Bewerkingstellers bijwerken',
	'right-generatetopusersreport' => 'Topgebruikersrapportages aanmaken',
	'level-advanced-to' => 'is gepromoveerd tot niveau tot niveau <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'U bent nu "$1" op {{SITENAME}}',
	'level-advance-body' => 'Hallo $1.

U bent nu "$2" op {{SITENAME}}

Van harte gefeliciteerd.

Het team van {{SITENAME}}

---
Wilt u niet langer e-mails van ons ontvangen?

Klik $3
en wijzig uw instellingen om e-mailberichten uit te schakelen.",',
	'generatetopusersreport' => 'Topgebruikersrapportage aanmaken',
	'user-stats-weekly-winners' => 'Wekelijkse {{PLURAL:$1|winnaar|winnaars}}',
	'user-stats-monthly-winners' => 'Maandelijkse {{PLURAL:$1|winnaar|winnaars}}',
	'user-stats-weekly-win-congratulations' => 'Felicitaties aan de volgende {{PLURAL:$1|gebruiker|gebruikers}} die deze week gewonnen {{PLURAL:$1|heeft|hebben}} en $2 extra {{PLURAL:$2|punt|punten}} {{PLURAL:$1|verdient|verdienen}}!',
	'user-stats-monthly-win-congratulations' => 'Felicitaties aan de volgende {{PLURAL:$1|gebruiker|gebruikers}} die deze maand gewonnen {{PLURAL:$1|heeft|hebben}} en $2 extra {{PLURAL:$2|punt|punten}} {{PLURAL:$1|verdient|verdienen}}!',
	'user-stats-full-top' => 'Volledige top $1',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' {{PLURAL:$3|punt|punten}}!",
	'user-stats-report-points' => "'''$1''' {{PLURAL:$1|punt|punten}}!",
	'user-stats-report-generation-note' => 'Deze pagina is automatisch gegenereerd',
	'user-stats-report-weekly-edit-summary' => 'automatische wekelijkse gebruikersrapportage',
	'user-stats-report-monthly-edit-summary' => 'automatische maandelijkse gebruikersrapportage',
	'user-stats-report-weekly-page-title' => 'Wekelijkse gebruikerspuntenrapportage ($1)',
	'user-stats-report-monthly-page-title' => 'Maandelijkse gebruikerspuntenrapportage ($1)',
	'user-stats-report-error-variable-not-set' => 'De variabele $wgUserStatsPointValues[\'points_winner_$1\'] moet een waarde groter dan 0 hebben in LocalSettings.php!',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'user-stats-alltime-title' => 'Flest poeng nokosinne',
	'user-stats-weekly-title' => 'Flest poeng denne veka',
	'user-stats-monthly-title' => 'Flest poeng denne månaden',
	'topusers' => 'Beste brukarar',
	'top-fans-by-points-nav-header' => 'Beste tilhengjarar',
	'top-fans-by-category-nav-header' => 'Beste etter katgegori',
	'top-fans-total-points-link' => 'Poeng totalt',
	'top-fans-weekly-points-link' => 'Poeng denne veka',
	'top-fans-monthly-points-link' => 'Poeng denne månaden',
	'top-fans-points' => 'poeng',
	'top-fans-bad-field-title' => 'Ops!',
	'top-fans-bad-field-message' => 'Den oppgjevne statistikken finst ikkje.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Røyst|Røyster}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Månadleg siger|Månadlege sigrar}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Vekesiger|Vekesigrar}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Endring|Endringar}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Kommentar|Kommentarar}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referanse|Referansar}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Ven|Vener}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Fiende|Fiendar}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Publisert meining|Publiserte meiningar}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Meining|Meiningar}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Tommel opp|Tomlar opp}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Tommel ned|Tomlar ned}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Tommel opp gjeven|Tomlar opp gjevne}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Tommel ned gjeven|Tomlar ned gjevne}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Gåva motteke|Gåver mottekne}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Gavå sendt|Gåver sendte}}',
	'level-advance-subject' => 'Du er no $1 på {{SITENAME}}!',
	'level-advance-body' => 'Hei, $1.

Du er no ein «$2» på {{SITENAME}}.

Gratulerer,

{{SITENAME}}-laget

----
Vil du ikkje lenger motta e-postar frå oss?

Trykk $3
og endra innstillingane dine for å slå av e-postmeldingar.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'user-stats-alltime-title' => 'Flest poeng noensinne',
	'user-stats-weekly-title' => 'Flest poeng denne uka',
	'user-stats-monthly-title' => 'Flest poeng denne måneden',
	'topusers' => 'Beste brukere',
	'top-fans-by-points-nav-header' => 'Beste tilhengere',
	'top-fans-by-category-nav-header' => 'Beste per kategori',
	'top-fans-total-points-link' => 'Poeng totalt',
	'top-fans-weekly-points-link' => 'Poeng denne uka',
	'top-fans-monthly-points-link' => 'Poeng denne måneden',
	'top-fans-points' => 'poeng',
	'top-fans-by-category-title-edit-count' => 'Topp antall redigeringer',
	'top-fans-by-category-title-friends-count' => 'Topp antall venner',
	'top-fans-by-category-title-foe-count' => 'Topp antall fiender',
	'top-fans-by-category-title-gifts-rec-count' => 'Topp antall mottatte gaver',
	'top-fans-by-category-title-gifts-sent-count' => 'Topp antall sendte gaver',
	'top-fans-by-category-title-vote-count' => 'Topp antall stemmer',
	'top-fans-by-category-title-comment-count' => 'Topp antall kommentarer',
	'top-fans-by-category-title-referrals-count' => 'Topp antall henvisninger',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Topp antall tommelen opp',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Topp antall tommelen ned',
	'top-fans-by-category-title-comment-score-positive-given' => 'Topp antall gitt tommelen opp',
	'top-fans-by-category-title-comment-score-negative-given' => 'Topp antall gitt tommelen ned',
	'top-fans-by-category-title-monthly-winner-count' => 'Topp antall månedlige seire',
	'top-fans-by-category-title-weekly-winner-count' => 'Topp antall ukentlige seire',
	'top-fans-bad-field-title' => 'Ups!',
	'top-fans-bad-field-message' => 'Den valgte statistikken finnes ikke.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Stemme|Stemmer}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Månedlig seier|Månedlige seire}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Ukentlig seier|Ukentlige seire}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Redigering|Redigeringer}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Kommentar|Kommentarer}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referering|Refereringer}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Venn|Venner}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Fiende|Fiender}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Publisert mening|Publiserte meninger}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Mening|Meninger}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Tommel opp|Tomler opp}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Tommel ned|Tomler ned}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Tommel opp gitt|Tomler opp gitt}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Tommel ned gitt|Tomler ned gitt}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Gave mottatt|Gaver mottatt}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Gave|Gaver}} sendt',
	'right-updatepoints' => 'Oppdater redigeringsteller',
	'level-advanced-to' => 'avanserte til nivå <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Du er nå $1 på {{SITENAME}}.',
	'level-advance-body' => 'Hei, $1.

Du er nå $2 på {{SITENAME}}.

Gratulerer,
{{SITENAME}}-teamet

----
Vil du ikke lenger motta e-poster fra oss?

Klikk $3
og endre innstillingene dine for å slå av e-postmeldinger.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'user-stats-alltime-title' => 'Punts los mai elevats totes periòdes confonduts',
	'user-stats-weekly-title' => 'Punts los mai elevats aquesta setmana',
	'user-stats-monthly-title' => 'Punts los mai elevats aqueste mes',
	'topusers' => 'Top dels utilizaires',
	'top-fans-by-points-nav-header' => 'Top dels fans',
	'top-fans-by-category-nav-header' => 'Top per categoria',
	'top-fans-total-points-link' => 'Total dels punts',
	'top-fans-weekly-points-link' => "Punts d'aquesta setmana",
	'top-fans-monthly-points-link' => "Punts d'aqueste mes",
	'top-fans-points' => 'punts',
	'top-fans-bad-field-title' => 'Au!',
	'top-fans-bad-field-message' => "L'estatistica indicada existís pas.",
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Vòt|Vòts}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|victòria mesadièra|victòrias mesadièras}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|victòria setmanièra|victòrias setmanièras}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|modificacion|modificacions}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comentari|Comentaris}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|referéncia|referéncias}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|amic|amics}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|enemic|enemics}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|opinion publicada|opinions publicadas}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinion|Opinions}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|òsca|òscas}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|nul|nuls}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|òsca atribuit|òscas atribuits}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|nul atribuit|nuls atribuits}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|present recebut|presents recebuts}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|present mandat|presents mandats}}',
	'right-updatepoints' => "Mesa a jorn del comptador d'edicions",
	'level-advanced-to' => 'a avançat cap al nivèl <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => "D'ara enlà, avètz un « $1 » sus {{SITENAME}} !",
	'level-advance-body' => "Adiu $1 :

Ara avètz un « $2 » sus {{SITENAME}} !

Totas nòstras felicitacions,

L'equipa de {{SITENAME}}

---
Volètz arrestar de recebre de corrièrs electronics de nòstra part ?

Clicatz $3
e modificatz vòstres paramètres en desactivant las notificacions per corrièr electronic.",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'top-fans-bad-field-title' => 'ଓଃ!',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Aamaericking|Aamaerickinge}}',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Bearwaidung|Bearwaidunge}}',
);

/** Polish (Polski)
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'user-stats-alltime-title' => 'Najwięcej punktów w historii',
	'user-stats-weekly-title' => 'Najwięcej punktów w tym tygodniu',
	'user-stats-monthly-title' => 'Najwięcej punktów w tym miesiącu',
	'topusers' => 'Najwyżej notowani użytkownicy',
	'top-fans-by-points-nav-header' => 'Najwyżej notowani wielbiciele',
	'top-fans-by-category-nav-header' => 'Najwyżej notowani według kategorii',
	'top-fans-total-points-link' => 'Suma punktów',
	'top-fans-weekly-points-link' => 'Punkty w tym tygodniu',
	'top-fans-monthly-points-link' => 'Punkty w tym miesiącu',
	'top-fans-points' => 'punktów',
	'top-fans-by-category-title-edit-count' => 'Największa liczba edycji',
	'top-fans-by-category-title-friends-count' => 'Najwięcej przyjaciół',
	'top-fans-by-category-title-foe-count' => 'Najwięcej wrogów',
	'top-fans-by-category-title-gifts-rec-count' => 'Najwięcej otrzymanych prezentów',
	'top-fans-by-category-title-gifts-sent-count' => 'Najwięcej wysłanych prezentów',
	'top-fans-by-category-title-vote-count' => 'Najwięcej głosów',
	'top-fans-by-category-title-comment-count' => 'Najwięcej komentarzy',
	'top-fans-by-category-title-referrals-count' => 'Najwięcej polecających',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Najwięcej kciuków do góry',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Najwięcej kciuków do dołu',
	'top-fans-by-category-title-comment-score-positive-given' => 'Dał najwięcej kciuków do góry',
	'top-fans-by-category-title-comment-score-negative-given' => 'Dał najwięcej kciuków do dołu',
	'top-fans-by-category-title-monthly-winner-count' => 'Najwięcej zwycięstw w miesiącu',
	'top-fans-by-category-title-weekly-winner-count' => 'Najwięcej zwycięstw w tygodniu',
	'top-fans-bad-field-title' => 'Oj!',
	'top-fans-bad-field-message' => 'Brak takiej statystyki.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Głos|Głosy}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Zwycięzca miesiąca|Zwycięzcy miesiąca}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Zwycięzca tygodnia|Zwycięzcy tygodnia}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edycja|Edycje}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komentarz|Komentarze}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Rekomendacja|Rekomendacje}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Znajomy|Znajomych}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Wróg|Wrogów}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Opublikowana opinia|Opublikowane opinie}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinia|Opinie}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Otrzymany głos|Otrzymane głosy}} poparcia',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Otrzymany głos|Otrzymane głosy}} sprzeciwu',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Oddany głos|Oddane głosy}} poparcia',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Oddany głos|Oddane głosy}} sprzeciwu',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Otrzymany prezent|Otrzymane prezenty}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Podarowany prezent|Podarowane prezenty}}',
	'right-updatepoints' => 'Aktualizacja liczników edycji',
	'level-advanced-to' => 'awansowany do poziomu <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Należysz teraz do grupy „$1” na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'level-advance-body' => 'Witaj $1.

Jesteś „$2” w {{GRAMMAR:Ms.lp|{{SITENAME}}}}!

Gratulacje

od zespołu {{GRAMMAR:D.lp|{{SITENAME}}}}

---
Jeżeli nie chcesz otrzymywać od nas więcej wiadomości, kliknij na poniższy link i zmień swoje ustawienia powiadamiania:

$3',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'user-stats-alltime-title' => 'Pi gran pontegi ëd tùit ij temp',
	'user-stats-weekly-title' => 'Pi gran pontegi dë sta sman-a-sì',
	'user-stats-monthly-title' => 'Pi gran pontegi dë sto mèis-sì',
	'topusers' => 'Utent an testa',
	'top-fans-by-points-nav-header' => 'Tifos an testa',
	'top-fans-by-category-nav-header' => 'An testa për categorìa',
	'top-fans-total-points-link' => 'Pont totaj',
	'top-fans-weekly-points-link' => 'Pont sta sman-a-sì',
	'top-fans-monthly-points-link' => 'Pont sto mèis-sì',
	'top-fans-points' => 'pont',
	'top-fans-by-category-title-edit-count' => 'Modìfiche an tut',
	'top-fans-by-category-title-friends-count' => 'Amis an tut',
	'top-fans-by-category-title-foe-count' => 'Nemis an tut',
	'top-fans-by-category-title-gifts-rec-count' => 'Mej cadò arseivù an tut',
	'top-fans-by-category-title-gifts-sent-count' => 'Mej cadò arseivù an tut',
	'top-fans-by-category-title-vote-count' => 'Vot an tut',
	'top-fans-by-category-title-comment-count' => 'Coment an tut',
	'top-fans-by-category-title-referrals-count' => 'Arferiment an tut',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Pòles su an tut',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Pòles giù an tut',
	'top-fans-by-category-title-comment-score-positive-given' => 'Pòles su assignà an tut',
	'top-fans-by-category-title-comment-score-negative-given' => 'Pòles giù assignà an tut',
	'top-fans-by-category-title-monthly-winner-count' => 'Vìnsite mensij an tut',
	'top-fans-by-category-title-weekly-winner-count' => 'Vìnsite pì àute dla sman-a an tut',
	'top-fans-bad-field-title' => 'Contacc!',
	'top-fans-bad-field-message' => 'Lë stat spessificà a esist pa.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Vot|Vot}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Vincitor dël mèis|Vincitor dël mèis}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Vincitor dla sman-a|Vincitor dla sman-a}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Modìfica|Modìfiche}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Coment|Coment}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Arferiment|Arferiment}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amis|Amis}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Nemis|Nemis}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Opinion publicà|Opinion publicà}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinion|Opinion}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Pòles su|Pòles su}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Pòles giù|Pòles giù}}',
	'top-fans-stats-comment-score-positive-given' => "{{PLURAL:$1|Pòles ch'a s'àussa|Pòles ch'a s'àussa}}",
	'top-fans-stats-comment-score-negative-given' => "{{PLURAL:$1|Pòles ch'as bassa|Pòles ch'as bassa}}",
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Cadò arseivù|Cadò arseivù}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Cadò mandà|Cadò mandà}}',
	'right-updatepoints' => 'Modìfica ij conteur ëd le modìfiche',
	'level-advanced-to' => 'avansà al livel <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Adess it ses a "$1" dzora {{SITENAME}}!',
	'level-advance-body' => 'Cerea $1.

Adess it ses un "$2" dzora {{SITENAME}}!

Congratulassion,

L\'echip ëd {{SITENAME}}

---
Scota, veus-to pi nen arsèive ëd mëssagi ëd pòsta eletrònica da nojàutri?

Sgnaca $3
e cambia toe ampostassion për disabilité le notìfiche an pòsta eletrònica.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'topusers' => 'د سر کارنان',
	'top-fans-by-points-nav-header' => 'د سر مينه وال',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|رايه|رايې}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|سمون|سمونونه}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|تبصره|تبصرې}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|ملګری|ملګري}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|سيال|سيالان}}',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Vanessa Sabino
 * @author Waldir
 */
$messages['pt'] = array(
	'user-stats-alltime-title' => 'Maior pontuação da história',
	'user-stats-weekly-title' => 'Maior pontuação desta semana',
	'user-stats-monthly-title' => 'Maior pontuação deste mês',
	'topusers' => 'Utilizadores de topo',
	'top-fans-by-points-nav-header' => 'Fãs de topo',
	'top-fans-by-category-nav-header' => 'Top por categoria',
	'top-fans-total-points-link' => 'Pontos totais',
	'top-fans-weekly-points-link' => 'Pontos esta semana',
	'top-fans-monthly-points-link' => 'Pontos este mês',
	'top-fans-points' => 'pontos',
	'top-fans-by-category-title-edit-count' => 'Top global de edições',
	'top-fans-by-category-title-friends-count' => 'Top global de amigos',
	'top-fans-by-category-title-foe-count' => 'Top global de inimigos',
	'top-fans-by-category-title-gifts-rec-count' => 'Top global de presentes recebidos',
	'top-fans-by-category-title-gifts-sent-count' => 'Top global de presentes enviados',
	'top-fans-by-category-title-vote-count' => 'Top global de votos',
	'top-fans-by-category-title-comment-count' => 'Top global de comentários',
	'top-fans-by-category-title-referrals-count' => 'Top global de recomendações',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Top global de aprovações',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Top global de desaprovações',
	'top-fans-by-category-title-comment-score-positive-given' => 'Top global de aprovações dadas',
	'top-fans-by-category-title-comment-score-negative-given' => 'Top global de desaprovações dadas',
	'top-fans-by-category-title-monthly-winner-count' => 'Top global de vitórias mensais',
	'top-fans-by-category-title-weekly-winner-count' => 'Top global de vitórias semanais',
	'top-fans-bad-field-title' => 'Ui!',
	'top-fans-bad-field-message' => 'O status especificado não existe.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Voto|Votos}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Vitória mensal|Vitórias mensais}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Vitória semanal|Vitórias semanais}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edição|Edições}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comentário|Comentários}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Indicação|Indicações}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amigo|Amigos}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Inimigo|Inimigos}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Opinião publicada|Opiniões publicadas}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinião|Opiniões}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Aprovação|Aprovações}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Desaprovação|Desaprovações}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Aprovação dada|Aprovações dadas}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Desaprovação dada|Desaprovações dadas}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Prenda recebida|Prendas recebidas}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Prenda enviada|Prendas enviadas}}',
	'right-updatepoints' => 'Actualizar contadores de edições',
	'right-generatetopusersreport' => 'Gerar relatórios dos utilizadores de topo',
	'level-advanced-to' => 'avançou para o nível <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Agora é um "$1" na {{SITENAME}}!',
	'level-advance-body' => 'Olá $1,

Agora é um "$2" na {{SITENAME}}!

Parabéns,

A equipa da {{SITENAME}}

---
Olhe, quer parar de receber as nossas mensagens?

Clique $3
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'generatetopusersreport' => 'Gerar Relatórios dos Utilizadores de Topo',
	'user-stats-weekly-winners' => '{{PLURAL:$1|Vencedor|Vencedores}} da Semana',
	'user-stats-monthly-winners' => '{{PLURAL:$1|Vencedor|Vencedores}} do Mês',
	'user-stats-weekly-win-congratulations' => 'Parabéns {{PLURAL:$1|ao seguinte utilizador, que obteve|aos seguintes utilizadores, que obtiveram}} uma vitória da semana e $2 pontos extra!',
	'user-stats-monthly-win-congratulations' => 'Parabéns {{PLURAL:$1|ao seguinte utilizador, que obteve|aos seguintes utilizadores, que obtiveram}} uma vitória do mês e $2 pontos extra!',
	'user-stats-full-top' => 'Top $1 Completo',
	'user-stats-report-row' => "($1) [[User:$2|$2]] - '''$3''' pontos",
	'user-stats-report-points' => "'''$1''' pontos",
	'user-stats-report-generation-note' => 'esta página foi gerada automaticamente',
	'user-stats-report-weekly-edit-summary' => 'relatório de utilizadores semanal automatizado',
	'user-stats-report-monthly-edit-summary' => 'relatório de utilizadores mensal automatizado',
	'user-stats-report-weekly-page-title' => 'Relatório Semanal de Pontos dos Utilizadores ($1)',
	'user-stats-report-monthly-page-title' => 'Relatório Mensal de Pontos dos Utilizadores ($1)',
	'user-stats-report-error-variable-not-set' => 'A variável $wgUserStatsPointValues[\'points_winner_$1\'] tem de ter um valor maior do que 0 no ficheiro LocalSettings.php!',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'user-stats-alltime-title' => 'Mais pontos de todo o tempo',
	'user-stats-weekly-title' => 'Mais pontos esta semana',
	'user-stats-monthly-title' => 'Mais pontos deste mês',
	'topusers' => 'Melhores utilizadores',
	'top-fans-by-points-nav-header' => 'Maiores Fãs',
	'top-fans-by-category-nav-header' => 'Melhores por categoria',
	'top-fans-total-points-link' => 'Pontos totais',
	'top-fans-weekly-points-link' => 'Pontos esta semana',
	'top-fans-monthly-points-link' => 'Pontos este mês',
	'top-fans-points' => 'pontos',
	'top-fans-by-category-title-edit-count' => 'Top global de edições',
	'top-fans-by-category-title-friends-count' => 'Top global de amigos',
	'top-fans-by-category-title-foe-count' => 'Top global de inimigos',
	'top-fans-by-category-title-gifts-rec-count' => 'Top global de presentes recebidos',
	'top-fans-by-category-title-gifts-sent-count' => 'Top global de presentes enviados',
	'top-fans-by-category-title-vote-count' => 'Top global de votos',
	'top-fans-by-category-title-comment-count' => 'Top global de comentários',
	'top-fans-by-category-title-referrals-count' => 'Top global de recomendações',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Top global de aprovações',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Top global de desaprovações',
	'top-fans-by-category-title-comment-score-positive-given' => 'Top global de aprovações dadas',
	'top-fans-by-category-title-comment-score-negative-given' => 'Top global de desaprovações dadas',
	'top-fans-by-category-title-monthly-winner-count' => 'Top global de vitórias mensais',
	'top-fans-by-category-title-weekly-winner-count' => 'Top global de vitórias semanais',
	'top-fans-bad-field-title' => 'Ops!',
	'top-fans-bad-field-message' => 'O status especificado não existe.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Voto|Votos}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|vencedor do mês|vencedores do mês}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|vencedor da semana|vencedores da semana}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edição|Edições}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comentário|Comentários}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Indicação|Indicações}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amigo|Amigos}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Inimigo|Inimigos}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Opinião publicada|Opiniões publicadas}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opinião|Opiniões}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Polegar para cima|Polegares para cima}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Polegar para baixo|Polegares para baixo}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Polegar para cima dado|Polegares para cima dados}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Polegar para baixo dado|Polegares para baixo dados}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Presente recebido|Presentes recebidos}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Presente enviado|Presentes enviados}}',
	'right-updatepoints' => 'Atualizar contadores de edição',
	'level-advanced-to' => 'Avançou para o nível <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Você agora é um "$1" em {{SITENAME}}!',
	'level-advance-body' => 'Oi $1:

Você agora é um "$2" em {{SITENAME}}!

Parabéns,

O Time de {{SITENAME}}

---
Ei, quer parar de receber e-mails de nós?

Clique $3
e altere suas preferências para desabilitar e-mails de notificação',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'user-stats-weekly-title' => 'Cele mai multe puncte în această săptămână',
	'user-stats-monthly-title' => 'Cele mai multe puncte în această lună',
	'topusers' => 'Top utilizatori',
	'top-fans-by-points-nav-header' => 'Top fani',
	'top-fans-by-category-nav-header' => 'Top după categorie',
	'top-fans-total-points-link' => 'Total puncte',
	'top-fans-weekly-points-link' => 'Puncte în această săptămână',
	'top-fans-monthly-points-link' => 'Puncte în această lună',
	'top-fans-points' => 'puncte',
	'top-fans-bad-field-title' => 'Ups!',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Vot|Voturi}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Câștig lunar|Câștiguri lunare}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Câștig săptămânal|Câștiguri săptămânale}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Modificare|Modificări}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Comentariu|Comentarii}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Prieten|Prieteni}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Cadou primit|Cadouri primite}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Cadou oferit|Cadouri oferite}}',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'user-stats-alltime-title' => 'Cchiù punde da sembre',
	'user-stats-weekly-title' => 'Cchiù punde pe sta sumane',
	'user-stats-monthly-title' => 'Cchiù punde stu mese',
	'topusers' => 'Le megghie utinde',
	'top-fans-by-points-nav-header' => 'Le megghie tefuse',
	'top-fans-by-category-nav-header' => 'Le megghie pe categorije',
	'top-fans-total-points-link' => 'Punde totale',
	'top-fans-weekly-points-link' => 'Punde pe sta sumane',
	'top-fans-monthly-points-link' => 'Punde pe stu mese',
	'top-fans-points' => 'punde',
	'top-fans-bad-field-title' => "Ohhhhh! C'è scritte!",
	'top-fans-stats-vote-count' => "{{PLURAL:$1|'u Vote|le Vote}}",
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|vingita menzile|vingite menzile}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|vingita settimanele|vingite settimanele}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Cangiamende|Cangiaminde}}',
	'top-fans-stats-comment-count' => "{{PLURAL:$1|'u Commende|le Commende}}",
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|referimende|refereminde}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Amiche|Amice}}',
	'level-advance-subject' => 'Tu, mò, si \'nu "$1" sus a {{SITENAME}}!',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'user-stats-alltime-title' => 'Больше всего очков за всё время',
	'user-stats-weekly-title' => 'Больше всего очков на этой неделе',
	'user-stats-monthly-title' => 'Больше всего очков в этом месяце',
	'topusers' => 'Рейтинг участников',
	'top-fans-by-points-nav-header' => 'Рейтинг болельщиков',
	'top-fans-by-category-nav-header' => 'Рейтинг по категориям',
	'top-fans-total-points-link' => 'Всего очков',
	'top-fans-weekly-points-link' => 'Очков за эту неделю',
	'top-fans-monthly-points-link' => 'Очков за этот месяц',
	'top-fans-points' => 'очков',
	'top-fans-by-category-title-edit-count' => 'Общий рейтинг по правкам',
	'top-fans-by-category-title-friends-count' => 'Общий рейтинг по друзьям',
	'top-fans-by-category-title-foe-count' => 'Общий рейтинг по недругам',
	'top-fans-by-category-title-gifts-rec-count' => 'Общий рейтинг по подаркам',
	'top-fans-by-category-title-gifts-sent-count' => 'Общий рейтинг по отправленным подаркам',
	'top-fans-by-category-title-vote-count' => 'Общий рейтинг по голосам',
	'top-fans-by-category-title-comment-count' => 'Общий рейтинг по комментариям',
	'top-fans-by-category-title-referrals-count' => 'Общий рейтинг по ссылкам',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Общий рейтинг по голосам за',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Общий рейтинг по голосам против',
	'top-fans-by-category-title-comment-score-positive-given' => 'Общий рейтинг по отданным голосам за',
	'top-fans-by-category-title-comment-score-negative-given' => 'Общий рейтинг по отданным голосам против',
	'top-fans-by-category-title-monthly-winner-count' => 'Общий рейтинг по месячным победам',
	'top-fans-by-category-title-weekly-winner-count' => 'Общий рейтинг по недельным победам',
	'top-fans-bad-field-title' => 'Ой!',
	'top-fans-bad-field-message' => 'Указанной статистики не существует.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Голос|Голосов}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Побед за месяц|Побед за месяц}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Побед за неделю|Побед за неделю}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Правка|Правок}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Комментарий|Комментариев}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Направление|Направлений}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Друг|Друзей}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Недруг|Недругов}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Опубликовано мнений|Опубликовано мнений}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Мнение|Мнений}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Голосов за|Голосов за}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Голосов против|Голосов против}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Подано голосов за|Подано голосов за}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Подано голосов против|Подано голосов против}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Получено подарков|Получено подарков}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Отправлено подарков|Отправлено подарков}}',
	'right-updatepoints' => 'обновление счётчика правок',
	'level-advanced-to' => 'перешёл на уровень <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Вы теперь «$1» в проекте {{SITENAME}}!',
	'level-advance-body' => 'Привет, $1.

Вы теперь «$2» в проекте {{SITENAME}}!

Поздравляем!

Команда проекта {{SITENAME}}

---
Эй, не хотите больше получать таких писем от нас?

Нажмите $3
и измените настройки отправки уведомлений по эл. почте.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'topusers' => 'Най хоснователї',
	'top-fans-by-points-nav-header' => 'Най фанушікы',
	'top-fans-by-category-nav-header' => 'Най подля катеґорії',
	'top-fans-bad-field-title' => 'Уупс!',
);

/** Sinhala (සිංහල)
 * @author Singhalawap
 */
$messages['si'] = array(
	'top-fans-bad-field-title' => 'අයියෝ !',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'user-stats-alltime-title' => 'Najviac bodov celkom',
	'user-stats-weekly-title' => 'Najviac bodov tento týždeň',
	'user-stats-monthly-title' => 'Najviac bodov tento mesiac',
	'topusers' => 'Naj používatelia',
	'top-fans-by-points-nav-header' => 'Naj fanúšikovia',
	'top-fans-by-category-nav-header' => 'Naj podľa kategórie',
	'top-fans-total-points-link' => 'Celkom bodov',
	'top-fans-weekly-points-link' => 'Bodov tento týždeň',
	'top-fans-monthly-points-link' => 'Bodov tento mesiac',
	'top-fans-points' => 'bodov',
	'top-fans-bad-field-title' => 'Ops!',
	'top-fans-bad-field-message' => 'Uvedená štatistika neexistuje.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Hlas|Hlasy|Hlasov}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Mesačná výhra|Mesačné výhry|Mesačných výhier}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Týždenná výhra|Týždenné výhry|Týždenných výhier}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Úprava|Úpravy|Úprav}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komentár|Komentáre|Komentárov}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Odkazujúci|Odkazujúci|Odkazujúcich}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Priateľ|Priatelia|Priateľov}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Nepriateľ|Nepriatelia|Nepriateľov}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Zverejnený názor|Zverejnené názory|Zverejnených názorov}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Názor|Názory|Názorov}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Pochvala|Pochvaly|Pochvál}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Pokarhanie|Pokarhania|Pokarhaní}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Daná pochvala|Dané pochvaly|Daných pochvál}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Dané pokarhanie|Dané pokarhania|Daných pokarhaní}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Obdržaný dar|Obdržané dary|Obdržaných darov}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Poslaný dar|Poslané dary|Poslaných darov}}',
	'right-updatepoints' => 'Aktualizovať počty úprav',
	'level-advanced-to' => 'postúpil na úroveň <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Teraz ste „$1” na {{GRAMMAR:lokál|{{SITENAME}}}}!',
	'level-advance-body' => 'Ahoj $1:

Teraz ste „$2” na {{GRAMMAR:lokál|{{SITENAME}}}}!

Gratulujeme,

Tím {{GRAMMAR:genitív|{{SITENAME}}}}

---
Nechcete ďalej dostávať tieto emaily?

Kliknite na $3
a vypnite v svojich nastaveniach upozornenia emailom.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'top-fans-bad-field-title' => 'Ups!',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'topusers' => 'Најбољи корисници',
	'top-fans-by-points-nav-header' => 'Највећи фанови',
	'top-fans-total-points-link' => 'Укупно поена',
	'top-fans-weekly-points-link' => 'Поена ове недеље',
	'top-fans-monthly-points-link' => 'Поена овог месеца',
	'top-fans-points' => 'бодова',
	'top-fans-bad-field-title' => 'Упс!',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Глас|Гласа|Гласа|Гласа|Гласова}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Недељна победа|Недељних победа}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|измена|измена}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Коментар|Коментара}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Пријатељ|Пријатеља}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Непријатељ|Непријатеља}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Објављно мишљење|Објављена мишљења|Објављена мишљења|Објављена мишљења|Објављених мишљења}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Опција|Опције|Опције|Опције|Опција}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Палац нагоре|Палчева нагоре}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Палац надоле|Палаца надоле}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Палац нагоре дат|Палаца нагоре дато}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Палац надоле дат|Палаца надоле дато}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Поклон примљен|Поклона примљено}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Поклон послат|Поклона послато}}',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'top-fans-total-points-link' => 'Ukupno poena',
	'top-fans-weekly-points-link' => 'Poena ove nedelje',
	'top-fans-monthly-points-link' => 'Poena ovog meseca',
	'top-fans-points' => 'poena',
	'top-fans-bad-field-title' => 'Ups!',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Glas|Glasa|Glasa|Glasa|Glasova}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Nedeljna pobeda|Nedeljnih pobeda}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|izmena|izmena}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Komentar|Komentara}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Prijatelj|Prijatelja}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Neprijatelj|Neprijatelja}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Objavljno mišljenje|Objavljena mišljenja|Objavljena mišljenja|Objavljena mišljenja|Objavljenih mišljenja}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Opcija|Opcije|Opcije|Opcije|Opcija}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Palac nagore|Palčeva nagore}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Palac nadole|Palaca nadole}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Palac nagore dat|Palaca nagore dato}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Palac nadole dat|Palaca nadole dato}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Poklon primljen|Poklona primljeno}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Poklon poslat|Poklona poslato}}',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Najami
 * @author Per
 */
$messages['sv'] = array(
	'user-stats-alltime-title' => 'Flest poäng någonsin',
	'user-stats-weekly-title' => 'Flest poäng den här veckan',
	'user-stats-monthly-title' => 'Flest poäng den här månaden',
	'topusers' => 'Bästa användare',
	'top-fans-by-points-nav-header' => 'Bästa fans',
	'top-fans-by-category-nav-header' => 'Bästa per kategori',
	'top-fans-total-points-link' => 'Poäng totalt',
	'top-fans-weekly-points-link' => 'Poäng den här veckan',
	'top-fans-monthly-points-link' => 'Poäng den här månaden',
	'top-fans-points' => 'poäng',
	'top-fans-bad-field-title' => 'Hoppsan!',
	'top-fans-bad-field-message' => 'Den valda statistiken finns inte.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Röst|Röster}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Månadsvis vinst|Månadsvisa vinster}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Veckovis vinst|Veckovisa vinster}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Redigering|Redigeringar}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Kommentar|Kommentarer}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Referering|Refereringar}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Vän|Vänner}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Ovän|Ovänner}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Publiserad åsikt|Publicerade åsikter}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Åsikt|Åsikter}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Tummen upp|Tummen upp}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Tummen ner|Tummen ner}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Given tummen upp|Givna tummen upp}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Given tummen ner|Givna tummen ner}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Fådd present|Fådda presenter}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Skickad present|Skickade presenter}}',
	'right-updatepoints' => 'Uppdatera redigeringsräknare',
	'level-advanced-to' => 'avancerat till nivå <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Du är nu en "$1" på {{SITENAME}}!',
	'level-advance-body' => 'Hej $1!

Du är nu en "$2" på {{SITENAME}}!

Grattis,

{{SITENAME}}-teamet

---
Förresten, vill du slippa få epost från oss?

Klicka $3
och ändra dina inställningar för att avaktivera epost-meddelanden.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'user-stats-alltime-title' => 'ఇప్పటివరకు ఎక్కువ పాయింట్లు',
	'user-stats-weekly-title' => 'ఈ వారంలో ఎక్కువ పాయింట్లు',
	'user-stats-monthly-title' => 'ఈ నెలలో ఎక్కువ పాయింట్లు',
	'topusers' => 'క్రియాశీల వాడుకరులు',
	'top-fans-total-points-link' => 'మొత్తం పాయింట్లు',
	'top-fans-weekly-points-link' => 'ఈ వారం పాయింట్లు',
	'top-fans-monthly-points-link' => 'ఈ నెల పాయింట్లు',
	'top-fans-points' => 'పాయింట్లు',
	'top-fans-bad-field-title' => 'అయ్యో!',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|వోటు|వోట్లు}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|నెలవారీ గెలుపు|నెలవారీ గెలుపులు}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|వారపు గెలుపు|వారపు గెలుపులు}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|మార్పు|మార్పులు}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|వ్యాఖ్య|వ్యాఖ్యలు}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|మిత్రుడు|మిత్రులు}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|శతృవు|శతృవులు}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|అభిప్రాయం|అభిప్రాయాలు}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|అందుకున్న బహుమతి|అందుకున్న బహుమతులు}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|ఇచ్చిన బహుమతి|ఇచ్చిన బహుమతులు}}',
	'level-advance-subject' => '{{SITENAME}}లో మీరిప్పుడు "$1"!',
	'level-advance-body' => 'హాయ్ $1:

మీరిప్పుడు {{SITENAME}}లో "$2"!

అభినందనలు,

{{SITENAME}} బృందం

---
మా నుండి ఈ-మెయిళ్ళు వద్దనుకుంటున్నారా?

$3 ని నొక్కి
ఈ-మెయిలు గమనింపులని అచేతనం చేసుకునేందుకు అమరికలని మార్చుకోండి.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Edisaun|Edisaun}}',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Özgerdiş|Özgerdiş}}',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'user-stats-alltime-title' => 'Pinakamaraming mga puntos sa lahat ng mga panahon',
	'user-stats-weekly-title' => 'Pinakamaraming mga puntos sa linggong ito',
	'user-stats-monthly-title' => 'Pinakamaraming mga puntos sa buwang ito',
	'topusers' => 'Nangungunang mga tagagamit',
	'top-fans-by-points-nav-header' => 'Nangungunang mga tagahanga',
	'top-fans-by-category-nav-header' => 'Nangunguna ayon sa kaurian',
	'top-fans-total-points-link' => 'Kabuoang mga puntos',
	'top-fans-weekly-points-link' => 'Mga puntos sa linggong ito',
	'top-fans-monthly-points-link' => 'Mga puntos sa buwang ito',
	'top-fans-points' => 'mga puntos',
	'top-fans-by-category-title-edit-count' => 'Pinakamataas na panlahatang mga pagbago',
	'top-fans-by-category-title-friends-count' => 'Pinakamataas na panlahatang mga kaibigan',
	'top-fans-by-category-title-foe-count' => 'Pinakamataas na panlahatang mga kalaban',
	'top-fans-by-category-title-gifts-rec-count' => 'Pinakamataas na panlahatang natanggap na mga regalo',
	'top-fans-by-category-title-gifts-sent-count' => 'Pinakamataas na panlahatang ipinadalang mga regalo',
	'top-fans-by-category-title-vote-count' => 'Pinakamataas na panlahatang mga boto',
	'top-fans-by-category-title-comment-count' => 'Pinakamataas na panlahatang mga puna',
	'top-fans-by-category-title-referrals-count' => 'Pinakamataas na panlahatang mga pagbanggit na pumunta',
	'top-fans-by-category-title-comment-score-positive-rec' => 'Pinakamataas na panlahatang mga pagtaas ng hinlalaki',
	'top-fans-by-category-title-comment-score-negative-rec' => 'Pinakamataas na panlahatang mga pagbaba ng hinlalaki',
	'top-fans-by-category-title-comment-score-positive-given' => 'Pinakamataas na panlahatang pagbigay ng mga pagtaas ng hinlalaki',
	'top-fans-by-category-title-comment-score-negative-given' => 'Pinakamataas na panlahatang pagbigay ng mga pagbaba ng hinlalaki',
	'top-fans-by-category-title-monthly-winner-count' => 'Pinakamataas na panlahatang buwanang mga pagwawagi',
	'top-fans-by-category-title-weekly-winner-count' => 'Pinakamataas na panlahatang lingguhang mga pagwawagi',
	'top-fans-bad-field-title' => 'Ay!',
	'top-fans-bad-field-message' => 'Hindi umiiral ang tinukoy na estadistika.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Boto|Mga boto}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Buwanang pagwawagi|Buwanang mga pagwawagi}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Lingguhang pagwawagi|Lingguhang mga pagwawagi}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Pagbabago|Mga pagbabago}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Kumento|Mga kumento}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Pagsangguni|Mga pagsangguni}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Kaibigan|Mga kaibigan}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Katunggali|Mga katunggali}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Nalathalang pananaw|Nalathalang mga pananaw}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Pananaw|Mga pananaw}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Pagtaas ng hinlalaki|Pagtataas ng mga hinlalaki}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Pagbaba ng mga hinlalagi|Pagbababa ng mga hinlalaki}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Ibinigay na pagtaas ng hinlalaki|Ibinigay na mga pagtataas ng mga hinlalaki}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Ibinigay na pagbaba ng hinlalaki|Ibinigay na mga pagbababa ng mga hinlalaki}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Natanggap na handog|Natanggap na mga handog}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Naipadalang handog|Naipadalang mga handog}}',
	'right-updatepoints' => 'Isapanahon ang mga pagbilang ng pagbago',
	'level-advanced-to' => 'isinulong sa antas na <span style="font-weight:800;">$1</span>',
	'level-advance-subject' => 'Isa ka na ngayong "$1" sa {{SITENAME}}!',
	'level-advance-body' => 'Kumusta ka $1:

Isa ka na ngayong "$2" sa {{SITENAME}}!

Maligayang bati,

Ang Pangkat {{SITENAME}}

---
Hoy, nais mo bang matigil ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $3
at baguhin ang mga pagtatakda mo upang huwag nang paganahin ang mga pagpapabatid sa pamamagitan ng e-liham.',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'user-stats-alltime-title' => 'Tüm zamanların en çok puanı',
	'user-stats-weekly-title' => 'Bu hafta en çok puan',
	'user-stats-monthly-title' => 'Bu ay en çok puan',
	'topusers' => 'En önemli kullanıcılar',
	'top-fans-by-points-nav-header' => 'En önemli hayranlar',
	'top-fans-by-category-nav-header' => 'Kategoriye göre en önemliler',
	'top-fans-total-points-link' => 'Toplam puan',
	'top-fans-weekly-points-link' => 'Bu haftadaki puanlar',
	'top-fans-monthly-points-link' => 'Bu ayki puanlar',
	'top-fans-points' => 'puan',
	'top-fans-bad-field-title' => 'Hay aksi!',
	'top-fans-bad-field-message' => 'Belirtilen istatistik mevcut değil.',
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Oy|Oylar}}',
	'top-fans-stats-monthly-winner-count' => '{{PLURAL:$1|Aylık kazanç|Aylık kazançlar}}',
	'top-fans-stats-weekly-winner-count' => '{{PLURAL:$1|Haftalık kazanç|Haftalık kazançlar}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Değişiklik|Değişiklikler}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Yorum|Yorumlar}}',
	'top-fans-stats-referrals-completed' => '{{PLURAL:$1|Başvuru|Başvurular}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Arkadaş|Arkadaşlar}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Düşman|Düşmanlar}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Yayınlanan fikir|Yayınlanan fikirler}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Fikir|Fikirler}}',
	'top-fans-stats-comment-score-positive-rec' => '{{PLURAL:$1|Beğeni|Beğeni}}',
	'top-fans-stats-comment-score-negative-rec' => '{{PLURAL:$1|Beğenmeme|Beğenmeme}}',
	'top-fans-stats-comment-score-positive-given' => '{{PLURAL:$1|Beğen|Beğen}}',
	'top-fans-stats-comment-score-negative-given' => '{{PLURAL:$1|Beğenilmedi|Beğenilmedi}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Alınan hediye|Alınan hediyeler}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Gönderilen hediye|Gönderilen hediyeler}}',
	'right-updatepoints' => 'Değişiklik sayılarını günceller',
	'level-advanced-to' => '<span style="font-weight:800;">$1</span> seviyesine yükseldi',
	'level-advance-subject' => 'Artık {{SITENAME}} bünyesinde "$1" statüsündesiniz!',
	'level-advance-body' => 'Merhaba $1.

Artık {{SITENAME}} bünyesinde "$2" statüsündesiniz!

Tebrikler,

{{SITENAME}} ekibi

---
Hey, bizden e-posta alımı durdurmak ister misiniz?

$3 bağlantısına tıklayın ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'top-fans-stats-vote-count' => '{{PLURAL:$1|Голос|Голоси|Голосів}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Редагування|Редагувань}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Коментар|Коментарі}}',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'top-fans-bad-field-title' => 'Oi!',
	'top-fans-stats-vote-count' => "{{PLURAL:$1|Än'|Än't}}",
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Redakcii|Redakcijad}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Sebranik|Sebranikad}}',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'top-fans-total-points-link' => 'Điểm tổng cộng',
	'top-fans-weekly-points-link' => 'Số điểm tuần này',
	'top-fans-monthly-points-link' => 'Số điểm tháng này',
	'top-fans-points' => 'điểm',
	'top-fans-bad-field-title' => 'Oái!',
	'top-fans-stats-vote-count' => 'Lá phiếu{{PLURAL:$1||}}',
	'top-fans-stats-edit-count' => 'Lần sửa đổi{{PLURAL:$1||}}',
	'top-fans-stats-friends-count' => 'Người bạn{{PLURAL:$1||}}',
	'top-fans-stats-opinions-created' => 'Ý kiến{{PLURAL:$1||}}',
	'right-updatepoints' => 'Cập nhật số lần sửa đổi',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'top-fans-bad-field-message' => 'Statit pavilöl no dabinon.',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|Redakam|Redakams}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|Küpet|Küpets}}',
	'top-fans-stats-friends-count' => '{{PLURAL:$1|Flen|Flens}}',
	'top-fans-stats-foe-count' => '{{PLURAL:$1|Neflen|Neflens}}',
	'top-fans-stats-opinions-published' => '{{PLURAL:$1|Ced pepüböl|Ceds pepüböl}}',
	'top-fans-stats-opinions-created' => '{{PLURAL:$1|Ced|Ceds}}',
	'top-fans-stats-gifts-rec-count' => '{{PLURAL:$1|Legivot pegetöl|Legivots pegetöl}}',
	'top-fans-stats-gifts-sent-count' => '{{PLURAL:$1|Legivot pesedöl|Legivots pesedöl}}',
	'level-advance-subject' => 'Anu binol „$1“ in {{SITENAME}}!',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'top-fans-stats-edit-count' => '{{PLURAL:$1|רעדאַקטירונג|רעדאַקטירונגען}}',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'top-fans-stats-edit-count' => '$1次编辑',
	'top-fans-stats-friends-count' => '$1名朋友',
	'top-fans-stats-foe-count' => '$1名仇敌',
	'top-fans-stats-opinions-created' => '$1个意见',
	'top-fans-stats-gifts-rec-count' => '接获的$1礼物',
	'top-fans-stats-gifts-sent-count' => '发送的$1礼物',
	'right-updatepoints' => '更新编辑次数',
	'level-advanced-to' => '已升至第<span style="font-weight:800;">$1</span>级',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'top-fans-stats-vote-count' => '{{PLURAL:$1|投票|投票}}',
	'top-fans-stats-edit-count' => '{{PLURAL:$1|編輯|次編輯}}',
	'top-fans-stats-comment-count' => '{{PLURAL:$1|評論|評論}}',
	'top-fans-stats-friends-count' => '$1 名朋友',
	'top-fans-stats-foe-count' => '$1 名仇人',
	'top-fans-stats-opinions-created' => '$1 個意見',
	'top-fans-stats-gifts-rec-count' => '已收到禮物',
	'top-fans-stats-gifts-sent-count' => '已傳送禮物',
	'right-updatepoints' => '更新編輯次數',
	'level-advanced-to' => '已升至第 <span style="font-weight:800;">$1</span> 級',
);

