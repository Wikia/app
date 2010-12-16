<?php
/**
 * Translations of Page Translation feature of Translate extension.
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$messages = array();

/** English
 * @author Nike
 */
$messages['en'] = array(
	'pagetranslation' => 'Page translation',
	'right-pagetranslation' => 'Mark versions of pages for translation',
	'tpt-desc' => 'Extension for translating content pages',
	'tpt-section' => 'Translation unit $1',
	'tpt-section-new' => 'New translation unit.
Name: $1',
	'tpt-section-deleted' => 'Translation unit $1',
	'tpt-template' => 'Page template',
	'tpt-templatediff' => 'The page template has changed.',

	'tpt-diff-old' => 'Previous text',
	'tpt-diff-new' => 'New text',
	'tpt-submit' => 'Mark this version for translation',

	'tpt-sections-oldnew' => 'New and existing translation units',
	'tpt-sections-deleted' => 'Deleted translation units',
	'tpt-sections-template' => 'Translation page template',
	
	# Specific page on the special page
	'tpt-badtitle' => 'Page name given ($1) is not a valid title',
	'tpt-oldrevision' => '$2 is not the latest version of the page [[$1]].
Only latest versions can be marked for translation.',
	'tpt-notsuitable' => 'Page $1 is not suitable for translation.
Make sure it has <nowiki><translate></nowiki> tags and has a valid syntax.',
	'tpt-saveok' => 'The page [[$1]] has been marked up for translation with $2 {{PLURAL:$2|translation unit|translation units}}.
The page can now be <span class="plainlinks">[$3 translated]</span>.',
	'tpt-badsect' => '"$1" is not a valid name for translation unit $2.',
	'tpt-showpage-intro' => 'Below new, existing and deleted sections are listed.
Before marking this version for translation, check that the changes to sections are minimised to avoid unnecessary work for translators.',
	'tpt-mark-summary' => 'Marked this version for translation',
	'tpt-edit-failed' => 'Could not update the page: $1',
	'tpt-already-marked' => 'The latest version of this page has already been marked for translation.',

	# Page list on the special page
	'tpt-list-nopages' => 'No pages are marked for translation nor ready to be marked for translation.',
	'tpt-old-pages' => 'Some version of {{PLURAL:$1|this page has|these pages have}} been marked for translation.',
	'tpt-new-pages' => '{{PLURAL:$1|This page contains|These pages contain}} text with translation tags, but no version of {{PLURAL:$1|this page is|these pages are}} currently marked for translation.',
	'tpt-rev-latest' => 'latest version',
	'tpt-rev-old' => 'difference to previous marked version',
	'tpt-rev-mark-new' => 'mark this version for translation',
	'tpt-translate-this' => 'translate this page',

	# Source and translation page headers
	'translate-tag-translate-link-desc' => 'Translate this page',
	'translate-tag-markthis' => 'Mark this page for translation',
	'translate-tag-markthisagain' => 'This page has <span class="plainlinks">[$1 changes]</span> since it was last <span class="plainlinks">[$2 marked for translation]</span>.',
	'translate-tag-hasnew' => 'This page contains <span class="plainlinks">[$1 changes]</span> which are not marked for translation.',
	'tpt-translation-intro' => 'This page is a <span class="plainlinks">[$1 translated version]</span> of a page [[$2]] and the translation is $3% complete and up to date.',
	'tpt-translation-intro-fuzzy' => 'Outdated translations are marked like this.',

	'tpt-languages-legend' => 'Other languages:',

	'tpt-target-page' => 'This page cannot be updated manually.
This page is a translation of page [[$1]] and the translation can be updated using [$2 the translation tool].',
	'tpt-unknown-page' => 'This namespace is reserved for content page translations.
The page you are trying to edit does not seem to correspond any page marked for translation.',

	'tpt-install' => 'Run php maintenance/update.php or web install to enable page translation feature.',

	'tpt-render-summary' => 'Updating to match new version of source page',

	'tpt-download-page' => 'Export page with translations',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Mormegil
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'pagetranslation' => 'Title of [[Special:PageTranslation]] and its name in [[Special:SpecialPages]].',
	'right-pagetranslation' => '{{doc-right}}',
	'tpt-desc' => '{{desc}}',
	'tpt-sections-oldnew' => '"New and existing" refers to the sum of: (a) new translation units, that were added, plus (b) the already existing ones, which were retained.',
	'tpt-saveok' => '$1 is a page title,
$2 is a count of sections which can be used with PLURAL,
$3 is an URL.',
	'tpt-mark-summary' => 'This message is used as an edit summary.',
	'tpt-old-pages' => 'The words "some version" refer to "one version of the page", or "a single version of each of the pages", respectively. Each page can have either one or none of its versions marked for translaton.',
	'tpt-rev-old' => '',
	'translate-tag-markthisagain' => '"has changes" is to be understood as "has been altered/edited"',
	'translate-tag-hasnew' => '"has changes" is to be understood as "has been altered/edited"',
	'tpt-languages-legend' => 'The caption of a language selector displayed using <code>&lt;languages /&gt;</code>, e.g. on [[Project list]].',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'pagetranslation' => 'Bladsyvertaling',
	'right-pagetranslation' => 'Merk weergawes van bladsye vir vertaling',
	'tpt-desc' => 'Uitbreiding vir die vertaal van wikibladsye',
	'tpt-section' => 'Vertaaleenheid $1',
	'tpt-section-new' => 'Nuwe vertaaleenheid.
Naam: $1',
	'tpt-section-deleted' => 'Vertaaleenheid $1',
	'tpt-template' => 'Bladsysjabloon',
	'tpt-templatediff' => 'Die bladsysjabloon was gewysig.',
	'tpt-diff-old' => 'Vorige teks',
	'tpt-diff-new' => 'Nuwe teks',
	'tpt-submit' => 'Merk die weergawe vir vertaling',
	'tpt-sections-oldnew' => 'Nuwe en bestaande vertaaleenhede',
	'tpt-sections-deleted' => 'Verwyderde vertaaleenhede',
	'tpt-sections-template' => 'Vertaalbladsjabloon',
	'tpt-badtitle' => "Die naam verskaf ($1) is nie 'n geldige bladsynaam nie",
	'tpt-oldrevision' => '$2 is nie die nuutste weergawe van die bladsy [[$1]] nie.
Slegs die nuutste weergawe kan vir vertaling gemerk word.',
	'tpt-notsuitable' => 'Die bladsy $1 is nie geskik om vir vertaling gemerk te word nie.
Sorg dat dit die etiket <nowiki><translate></nowiki> bevat en dat die sintaks daarvan korrek is.',
	'tpt-saveok' => 'Die bladsy [[$1]] is gemerk vir vertaling met $2 uitstaande {{PLURAL:$2|vertaaleenheid|vertaaleenhede}}.
Die bladsy kan nou <span class="plainlinks">[$3 vertaal]</span> word.',
	'tpt-badsect' => '"$1" is nie \'n geldige naam vir vertaaleenheid $2 nie.',
	'tpt-showpage-intro' => 'Hieronder word nuwe, bestaande en verwyderde afdelings gelys.
Alvorens u die weergawe vir vertaling merk, maak seker dat die veranderinge geminimeer word om onnodig werk vir vertalers te voorkom.',
	'tpt-mark-summary' => 'Merk die weergawe vir vertaling',
	'tpt-edit-failed' => 'Die bladsy "$1" kon nie bygewerk word nie.',
	'tpt-already-marked' => 'Die nuutste weergawe van die bladsy is reeds gemerk vir vertaling.',
	'tpt-list-nopages' => 'Geen bladsye is vir vertaling gemerk of is reg om vir vertaling gemerk te word nie.',
	'tpt-old-pages' => "'n Weergawe van die {{PLURAL:$1|bladsy|bladsye}} is reeds vir vertaling gemerk.",
	'tpt-new-pages' => 'Hierdie {{PLURAL:$1|bladsy bevat|bladsye bevat}} teks met vertalings-etikette, maar geen weergawe van die {{PLURAL:$1|bladsy|bladsye}} is vir vertaling gemerk nie.',
	'tpt-rev-latest' => 'nuutste weergawe',
	'tpt-rev-old' => 'verskil met die vorige gemerkte weergawe',
	'tpt-rev-mark-new' => 'merk die weergawe vir vertaling',
	'tpt-translate-this' => 'vertaal die bladsy',
	'translate-tag-translate-link-desc' => 'Vertaal die bladsy',
	'translate-tag-markthis' => 'Merk die bladsy vir vertaling',
	'translate-tag-markthisagain' => 'Hierdie bladsy is <span class="plainlinks">[$1 kere gewysig]</span> sedert dit laas <span class="plainlinks">[$2 vir vertaling gemerk was]</span>.',
	'translate-tag-hasnew' => 'Daar is <span class="plainlinks">[$1 wysigings]</span> aan die bladsy gemaak wat nie vir vertaling gemerk is nie.',
	'tpt-translation-intro' => 'Die bladsy is \'n <span class="plainlinks">[$1 vertaalde weergawe]</span> van bladsy [[$2]]. Die vertaling van die bladsy is $3% voltooi.',
	'tpt-translation-intro-fuzzy' => 'Verouderde vertalings word so weergegee.',
	'tpt-languages-legend' => 'Ander tale:',
	'tpt-target-page' => "Hierdie bladsy kan nie handmatig gewysig word nie.
Die bladsy is 'n vertaling van die bladsy [[$1]].
Die vertaling kan bygewerk word via die [$2 vertaalgereedskap].",
	'tpt-unknown-page' => 'Hierdie naamruimte is gereserveer vir die vertalings van bladsye.
Die bladsy wat u probeer wysig kom nie ooreen met een wat vir vertaling gemerk is nie.',
	'tpt-install' => 'Voer php maintenance/update.php of die webinstallasie uit om die bladsyvertaling te aktiveer.',
	'tpt-render-summary' => "Besig met bewerkings vanweë 'n nuwe basisweergawe van die bronblad",
	'tpt-download-page' => 'Eksporteer bladsy met vertalings',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 */
$messages['ar'] = array(
	'pagetranslation' => 'ترجمة صفحة',
	'right-pagetranslation' => 'عّلم نسخًا م هذه الصفحة للترجمة',
	'tpt-desc' => 'امتداد لترجمة محتويات الصفحات',
	'tpt-section' => 'وحدة الترجمة $1',
	'tpt-section-new' => 'وحدة ترجمة جديدة.
الاسم: $1',
	'tpt-section-deleted' => 'وحدة الترجمة $1',
	'tpt-template' => 'قالب صفحة',
	'tpt-templatediff' => 'تغيّر قالب الصفحة.',
	'tpt-diff-old' => 'نص سابق',
	'tpt-diff-new' => 'نص جديد',
	'tpt-submit' => 'علّم هذه النسخة للترجمة',
	'tpt-sections-oldnew' => 'وحدات الترجمة الجديدة والموجودة',
	'tpt-sections-deleted' => 'وحدات الترجمة المحذوفة',
	'tpt-sections-template' => 'قالب صفحة ترجمة',
	'tpt-badtitle' => 'اسم الصّفحة المعطى ($1) ليس عنوانا صحيحا',
	'tpt-oldrevision' => '$2 ليست آخر نسخة للصّفحة [[$1]].
فقط آخر النسخ يمكن أن تؤشّر للترجمة.',
	'tpt-notsuitable' => 'الصفحة $1 غير مناسبة للترجمة.
تأكد أن لها وسم <nowiki><translate></nowiki> وأن لها صياغة صحيحة.',
	'tpt-saveok' => 'الصفحة [[$1]] تم التعليم عليها للترجمة ب $2 {{PLURAL:$2|وحدة ترجمة|وحدات ترجمة}}.
الصفحة يمكن الآن <span class="plainlinks">[$3 ترجمتها]</span>.',
	'tpt-badsect' => '"$1" ليس اسمًا صحيحًا لوحدة الترجمة $2.',
	'tpt-showpage-intro' => 'أدناه تُسرد الأقسام الجديدة والموجودة والمحذوفة.
قبل تعليم هذه النسخة للترجمة، تحقق من أن التغييرات على الأقسام مُقلّلة لتفادي العمل غير الضروري من المترجمين.',
	'tpt-mark-summary' => 'علَّم هذه النسخة للترجمة',
	'tpt-edit-failed' => 'تعذّر تحديث الصفحة: $1',
	'tpt-already-marked' => 'آخر نسخة من هذه الصفحة مُعلّمة بالفعل للترجمة.',
	'tpt-list-nopages' => 'لا صفحات مُعلّمة للترجمة أو جاهزة للتعليم للترجمة.',
	'tpt-old-pages' => 'إحدى نسخ {{PLURAL:$1||هذه الصفحة|هاتان الصفحتان|هذه الصفحات}} عُلّمت للترجمة.',
	'tpt-new-pages' => '{{PLURAL:$1|هذه الصفحة تحتوي|هذه الصفحات تحتوي}} على نص بوسوم ترجمة، لكن لا نسخة من {{PLURAL:$1|هذه الصفحة|هذه الصفحات}} معلمة حاليا للترجمة.',
	'tpt-rev-latest' => 'آخر نسخة',
	'tpt-rev-old' => 'الفرق مقابل النسخة المعلّمة السابقة',
	'tpt-rev-mark-new' => 'علّم هذه النسخة للترجمة',
	'tpt-translate-this' => 'ترجم هذه الصّفحة',
	'translate-tag-translate-link-desc' => 'ترجمة هذه الصفحة',
	'translate-tag-markthis' => 'علّم هذه الصفحة للترجمة',
	'translate-tag-markthisagain' => 'هذه الصفحة بها <span class="plainlinks">[$1 تغيير]</span> منذ تم <span class="plainlinks">[$2 تعليمها للترجمة]</span> لآخر مرة.',
	'translate-tag-hasnew' => 'هذه الصفحة تحتوي على <span class="plainlinks">[$1 تغييرات]</span> غير معلمة للترجمة.',
	'tpt-translation-intro' => 'هذه الصفحة هي <span class="plainlinks">[$1 نسخة مترجمة]</span> لصفحة [[$2]] والترجمة مكتملة ومحدثة بنسبة $3%.',
	'tpt-translation-intro-fuzzy' => 'الترجمات غير المُحدّثة مُعلّمة هكذا.',
	'tpt-languages-legend' => 'لغات أخرى:',
	'tpt-target-page' => 'لا يمكن تحديث هذه الصفحة يدويًا.
هذه الصفحة ترجمة لصفحة [[$1]] ويمكن تحديث الترجمة باستخدام [$2 أداة الترجمة].',
	'tpt-unknown-page' => 'هذا النطاق محجوز لترجمات صفحات المحتوى.
الصفحة التي تحاول تعديلها لا يبدو أنها تتبع أي صفحة معلمة للترجمة.',
	'tpt-install' => 'شغل php maintenance/update.php أو نصب من الويب لتفعيل خاصية ترجمة الصفحات.',
	'tpt-render-summary' => 'تحديث لمطابقة نسخة صفحة المصدر الجديدة',
	'tpt-download-page' => 'صدّر الصفحة مع الترجمات',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'pagetranslation' => 'ܬܘܪܓܡܐ ܕܦܐܬܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'pagetranslation' => 'ترجمه صفحة',
	'right-pagetranslation' => 'عّلم نسخًا م هذه الصفحه للترجمة',
	'tpt-desc' => 'امتداد لترجمه محتويات الصفحات',
	'tpt-section' => 'وحده الترجمه $1',
	'tpt-section-new' => 'وحده ترجمه جديده.
الاسم: $1',
	'tpt-section-deleted' => 'وحده الترجمه $1',
	'tpt-template' => 'قالب صفحة',
	'tpt-templatediff' => 'تغيّر قالب الصفحه.',
	'tpt-diff-old' => 'نص سابق',
	'tpt-diff-new' => 'نص جديد',
	'tpt-submit' => 'علّم هذه النسخه للترجمة',
	'tpt-sections-oldnew' => 'وحدات الترجمه الجديده والموجودة',
	'tpt-sections-deleted' => 'وحدات الترجمه المحذوفة',
	'tpt-sections-template' => 'قالب صفحه ترجمة',
	'tpt-badtitle' => 'اسم الصّفحه المعطى ($1) ليس عنوانا صحيحا',
	'tpt-oldrevision' => '$2 ليست آخر نسخه للصّفحه [[$1]].
فقط آخر النسخ يمكن أن تؤشّر للترجمه.',
	'tpt-notsuitable' => 'الصفحه $1 غير مناسبه للترجمه.
تأكد أن لها وسم <nowiki><translate></nowiki> وأن لها صياغه صحيحه.',
	'tpt-saveok' => 'الصفحه [[$1]] تم التعليم عليها للترجمه ب $2 {{PLURAL:$2|وحده ترجمة|وحدات ترجمة}}.
الصفحه يمكن الآن <span class="plainlinks">[$3 ترجمتها]</span>.',
	'tpt-badsect' => '"$1" ليس اسمًا صحيحًا لوحده الترجمه $2.',
	'tpt-showpage-intro' => 'أدناه تُسرد الأقسام الجديده والموجوده والمحذوفه.
قبل تعليم هذه النسخه للترجمه، تحقق من أن التغييرات على الأقسام مُقلّله لتفادى العمل غير الضرورى من المترجمين.',
	'tpt-mark-summary' => 'علَّم هذه النسخه للترجمة',
	'tpt-edit-failed' => 'تعذّر تحديث الصفحة: $1',
	'tpt-already-marked' => 'آخر نسخه من هذه الصفحه مُعلّمه بالفعل للترجمه.',
	'tpt-list-nopages' => 'لا صفحات مُعلّمه للترجمه أو جاهزه للتعليم للترجمه.',
	'tpt-old-pages' => 'إحدى نسخ {{PLURAL:$1||هذه الصفحة|هاتان الصفحتان|هذه الصفحات}} عُلّمت للترجمه.',
	'tpt-new-pages' => '{{PLURAL:$1|هذه الصفحه تحتوي|هذه الصفحات تحتوي}} على نص بوسوم ترجمه، لكن لا نسخه من {{PLURAL:$1|هذه الصفحة|هذه الصفحات}} معلمه حاليا للترجمه.',
	'tpt-rev-latest' => 'آخر نسخة',
	'tpt-rev-old' => 'الفرق مقابل النسخه المعلّمه السابقة',
	'tpt-rev-mark-new' => 'علّم هذه النسخه للترجمة',
	'tpt-translate-this' => 'ترجم هذه الصّفحة',
	'translate-tag-translate-link-desc' => 'ترجمه هذه الصفحة',
	'translate-tag-markthis' => 'علّم هذه الصفحه للترجمة',
	'translate-tag-markthisagain' => 'هذه الصفحه بها <span class="plainlinks">[$1 تغيير]</span> منذ تم <span class="plainlinks">[$2 تعليمها للترجمة]</span> لآخر مره.',
	'translate-tag-hasnew' => 'هذه الصفحه تحتوى على <span class="plainlinks">[$1 تغييرات]</span> غير معلمه للترجمه.',
	'tpt-translation-intro' => 'هذه الصفحه هى <span class="plainlinks">[$1 نسخه مترجمة]</span> لصفحه [[$2]] والترجمه مكتمله ومحدثه بنسبه $3%.',
	'tpt-translation-intro-fuzzy' => 'الترجمات غير المُحدّثه مُعلّمه هكذا.',
	'tpt-languages-legend' => 'لغات أخرى:',
	'tpt-target-page' => 'لا يمكن تحديث هذه الصفحه يدويًا.
هذه الصفحه ترجمه لصفحه [[$1]] ويمكن تحديث الترجمه باستخدام [$2 أداه الترجمة].',
	'tpt-unknown-page' => 'هذا النطاق محجوز لترجمات صفحات المحتوى.
الصفحه التى تحاول تعديلها لا يبدو أنها تتبع أى صفحه معلمه للترجمه.',
	'tpt-install' => 'شغل php maintenance/update.php أو نصب من الويب لتفعيل خاصيه ترجمه الصفحات.',
	'tpt-render-summary' => 'تحديث لمطابقه نسخه صفحه المصدر الجديدة',
	'tpt-download-page' => 'صدّر الصفحه مع الترجمات',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 */
$messages['as'] = array(
	'pagetranslation' => 'পৃষ্ঠা ভাঙনি',
	'tpt-submit' => 'এই সংস্কৰণ ভাঙনিৰ বাবে বাচক',
	'tpt-translate-this' => 'এই পৃষ্ঠা ভাঙনি কৰক',
	'translate-tag-translate-link-desc' => 'এই পৃষ্ঠা ভাঙনি কৰক',
	'tpt-languages-legend' => 'অন্য ভাষা:',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'translate-tag-translate-link-desc' => 'Traducir esta páxina',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'pagetranslation' => 'Пераклад старонкі',
	'right-pagetranslation' => 'пазначаць вэрсіяў старонак для перакладу',
	'tpt-desc' => 'Пашырэньне для перакладу старонак зьместу',
	'tpt-section' => 'Адзінка перакладу $1',
	'tpt-section-new' => 'Новая адзінка перакладу. Назва: $1',
	'tpt-section-deleted' => 'Адзінка перакладу $1',
	'tpt-template' => 'Старонка шаблёну',
	'tpt-templatediff' => 'Старонка шаблёну была зьменена.',
	'tpt-diff-old' => 'Папярэдні тэкст',
	'tpt-diff-new' => 'Новы тэкст',
	'tpt-submit' => 'Пазначыць гэту вэрсію для перакладу',
	'tpt-sections-oldnew' => 'Новыя і існуючыя адзінкі перакладу',
	'tpt-sections-deleted' => 'Выдаленыя адзінкі перакладу',
	'tpt-sections-template' => 'Шаблён старонкі перакладу',
	'tpt-badtitle' => 'Пададзеная назва старонкі ($1) не зьяўляецца слушнай',
	'tpt-oldrevision' => '$2 не зьяўляецца апошняй вэрсіяй старонкі [[$1]].
Толькі апошнія вэрсіі могуць пазначацца для перакладу.',
	'tpt-notsuitable' => 'Старонка $1 ня можа быць перакладзеная.
Упэўніцеся, што яна ўтрымлівае тэгі <nowiki><translate></nowiki> і мае слушны сынтаксіс.',
	'tpt-saveok' => 'Старонка «$1» была пазначаная для перакладу з $2 {{PLURAL:$2|адзінкай перакладу|адзінкамі перакладу|адзінкамі перакладу}}.
Зараз старонка можа быць <span class="plainlinks">[$3 перакладзеная]</span>.',
	'tpt-badsect' => '«$1» не зьяўляецца слушнай назвай для адзінкі перакладу $2.',
	'tpt-showpage-intro' => 'Ніжэй знаходзяцца новыя, існуючыя і выдаленыя сэкцыі.
Перад пазначэньнем гэтай вэрсіі для перакладу, праверце зьмены ў сэкцыях для таго, каб пазьбегнуць непатрэбнай працы для перакладчыкаў.',
	'tpt-mark-summary' => 'Пазначыў гэтую вэрсію для перакладу',
	'tpt-edit-failed' => 'Немагчыма абнавіць старонку: $1',
	'tpt-already-marked' => 'Апошняя вэрсія гэтай старонкі ўжо была пазначана для перакладу.',
	'tpt-list-nopages' => 'Старонкі для перакладу не пазначаныя альбо не падрыхтаваныя.',
	'tpt-old-pages' => 'Некаторыя вэрсіі {{PLURAL:$1|гэтай старонкі|гэтых старонак}} былі пазначаны для перакладу.',
	'tpt-new-pages' => '{{PLURAL:$1|Гэта старонка ўтрымлівае|Гэтыя старонкі ўтрымліваюць}} тэкст з тэгамі перакладу, але {{PLURAL:$1|пазначанай для перакладу вэрсіі гэтай старонкі|пазначаных для перакладу вэрсіяў гэтых старонак}} няма.',
	'tpt-rev-latest' => 'апошняя вэрсія',
	'tpt-rev-old' => 'розьніца з папярэдняй пазначанай вэрсіяй',
	'tpt-rev-mark-new' => 'пазначыць гэту вэрсію для перакладу',
	'tpt-translate-this' => 'перакласьці гэту старонку',
	'translate-tag-translate-link-desc' => 'Перакласьці гэту старонку',
	'translate-tag-markthis' => 'Пазначыць гэту старонку для перакладу',
	'translate-tag-markthisagain' => 'Гэта старонка ўтрымлівае <span class="plainlinks">[$1 зьмены]</span> пасьля апошняй <span class="plainlinks">[$2 пазнакі для перакладу]</span>.',
	'translate-tag-hasnew' => 'Гэта старонка ўтрымлівае <span class="plainlinks">[$1 зьмены]</span> не пазначаныя для перакладу.',
	'tpt-translation-intro' => 'Гэта старонка <span class="plainlinks">[$1 перакладзеная вэрсія]</span> старонкі [[$2]], пераклад завершаны на $3%.',
	'tpt-translation-intro-fuzzy' => 'Састарэлыя пераклады пазначаны наступным чынам.',
	'tpt-languages-legend' => 'Іншыя мовы:',
	'tpt-target-page' => 'Гэта старонка ня можа быць абноўлена ўручную.
Гэта старонка зьяўляецца перакладам старонкі [[$1]], пераклад можа быць абноўлены з выкарыстаньнем [$2 інструмэнта перакладу].',
	'tpt-unknown-page' => 'Гэта прастора назваў зарэзэрваваная для перакладаў старонак зьместу.
Старонка, якую Вы спрабуеце рэдагаваць, верагодна не зьвязана зь якой-небудзь старонкай пазначанай для перакладу.',
	'tpt-install' => 'Запусьціце php maintenance/update.php альбо усталюйце праз вэб-інтэрфэйс для актывізацыі інструмэнтаў перакладу старонак.',
	'tpt-render-summary' => 'Абнаўленьне для адпаведнасьці новай вэрсіі крынічнай старонкі',
	'tpt-download-page' => 'Экспартаваць старонку з перакладамі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'tpt-diff-old' => 'Предишен текст',
	'tpt-diff-new' => 'Нов текст',
	'tpt-rev-latest' => 'най-новата версия',
	'tpt-rev-mark-new' => 'отбелязване на тази версия за превеждане',
	'tpt-translate-this' => 'превеждане на тази страница',
	'translate-tag-translate-link-desc' => 'Превеждане на тази страница',
	'tpt-languages-legend' => 'Други езици:',
	'tpt-download-page' => 'Изнасяне на страница с преводите',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'tpt-rev-latest' => 'সাম্প্রতিকতম সংস্করণ',
	'tpt-translate-this' => 'এই পাতা অনুবাদ করুন',
	'translate-tag-translate-link-desc' => 'এই পাতা অনুবাদ করুন',
	'translate-tag-markthis' => 'অনুবাদের জন্য এই পাতা চিহ্নিত করুন',
	'tpt-languages-legend' => 'অন্য ভাষা:',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'pagetranslation' => 'Troidigezh ur bajenn',
	'right-pagetranslation' => "Merkañ doare pajennoù evit ma 'vefent troet",
	'tpt-desc' => 'Astenn evit treiñ pajennoù gant danvez',
	'tpt-section' => 'Unanenn treiñ $1',
	'tpt-section-new' => 'Unanenn nevez treiñ.
Anv : $1',
	'tpt-section-deleted' => 'Unanenn dreiñ $1',
	'tpt-template' => 'Patrom pajenn',
	'tpt-templatediff' => 'Kemmet eo patrom ar bajenn.',
	'tpt-diff-old' => 'Testenn gent',
	'tpt-diff-new' => 'Testenn nevez',
	'tpt-submit' => "Merkañ ar stumm-se evit ma 'vefe troet",
	'tpt-sections-oldnew' => 'Unanennoù treiñ hag a zo diouto ha re nevez',
	'tpt-sections-deleted' => 'Unanennoù treinn bet diverket',
	'tpt-sections-template' => 'Patrom pajenn dreiñ',
	'tpt-badtitle' => "N'eo ket reizh titl anv ar bajenn ($1) zo bet lakaet",
	'tpt-oldrevision' => "N'eo ket $2 stumm diwezhañ ar bajenn [[$1]].
N'eus nemet ar stummoù diwezhañ a c'hall bezañ merket evit bezañ troet.",
	'tpt-notsuitable' => "N'haller ket treiñ ar bajenn $1.
Gwiria ez eus balizennoù <nowiki><translate></nowiki> enni hag ez eo reizh an ereadurezh anezhi.",
	'tpt-saveok' => 'Merket eo bet ar bajenn [[$1]] evit bezañ troet gant $2 {{PLURAL:$2|unanenn dreiñ|unanenn dreiñ}}.
Gallout a ra ar bajenn bezañ <span class="plainlinks">[$3 troet]</span> bremañ.',
	'tpt-badsect' => 'Direizh eo an anv "$1" evit un unanenn dreiñ $2.',
	'tpt-showpage-intro' => "A-is emañ rollet an troidigezhioù nevez, ar re zo anezho hag ar re bet diverket.
Kent merkañ ar stumm-mañ evit an treiñ, gwiriait mat n'eus ket bet nemeur a gemmoù er rannbennadoù kuit da bourchas labour aner d'an droourien.",
	'tpt-mark-summary' => 'An doare-se a zo bet merket evit bezañ troet',
	'tpt-edit-failed' => "N'eus ket bet gallet hizivaat ar bajenn : $1",
	'tpt-already-marked' => 'Ar stumm ziwezhañ eus ar bajenn-mañ a zo dija bet merket evit bezañ troet.',
	'tpt-list-nopages' => "N'eo bet merket pajenn ebet evit bezañ troet ha n'eus pajenn ebet prest evit en ober.",
	'tpt-old-pages' => "Doareoù 'zo eus ar bajenn{{PLURAL:$1|-mañ|où-se}} a zo bet merket evit bezañ troet.",
	'tpt-new-pages' => '{{PLURAL:$1|Ar bajenn-mañ en|Ar bajennoù-se o}} deus testenn gant balizennoù treinn, met doare ebet eus ar bajenn{{PLURAL:$1|-mañ|où-se}} a zo merket evit bezañ troet.',
	'tpt-rev-latest' => 'stumm diwezhañ',
	'tpt-rev-old' => "diforc'hioù gant an doare merket kozh",
	'tpt-rev-mark-new' => "merkañ an doare-se evit ma 'vefe troet",
	'tpt-translate-this' => 'Treiñ ar bajenn-mañ',
	'translate-tag-translate-link-desc' => 'Treiñ ar bajenn-mañ',
	'translate-tag-markthis' => 'Merkañ ar bajenn-mañ evit an treiñ',
	'translate-tag-markthisagain' => 'Ar bajenn-mañ he deus bet <span class="plainlinks">[$1 kemm]</span> abaoe m\'eo bet <span class="plainlinks">[$2 merket evit bezañ troet]</span>.',
	'translate-tag-hasnew' => 'Ar bajenn-mañ he deus <span class="plainlinks">[$1 kemm]</span> ha n\'int ket merket evit bezañ troet.',
	'tpt-translation-intro' => 'Ar bajenn-mañ a zo un <span class="plainlinks">[$1 droidigezh]</span> eus ar bajenn [[$2]] hag an droidigezh a zo bet kaset da benn da $3% hag hizivaet.',
	'tpt-translation-intro-fuzzy' => 'An troidigezhioù diamzeret zo merket evel-henn.',
	'tpt-languages-legend' => 'Yezhoù all :',
	'tpt-target-page' => "Ne c'hell ket bezañ hizivaet ar bajenn-mañ gant an dorn.
Un doare troet eus [[$1]] eo hag an droidigezh a c'hell bezañ hizivaet en ur implijout [$2 an ostilh treiñ].",
	'tpt-install' => "Lañsit php trezalc'h (maintenance)/update.php pe ar staliadur web evit gweredekaat an arc'hweladur treiñ ar pajennoù.",
	'tpt-render-summary' => 'Hizivadur evit klotañ gant an doare nevez mammenn ar bajenn',
	'tpt-download-page' => 'Ezporzhiañ ar bajenn gant an troidigezhioù',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'pagetranslation' => 'Prijevod stranice',
	'right-pagetranslation' => 'Označanje verzija stranica za prevođenje',
	'tpt-desc' => 'Proširenje za prevođenje stranica sadržaja',
	'tpt-section' => 'Jedinica prevođenja $1',
	'tpt-section-new' => 'Nova jedinica prevođenja. Naziv: $1',
	'tpt-section-deleted' => 'Jedinica prevođenja $1',
	'tpt-template' => 'Šablon stranice',
	'tpt-templatediff' => 'Šablon stranice se izmijenio.',
	'tpt-diff-old' => 'Prethodni tekst',
	'tpt-diff-new' => 'Novi tekst',
	'tpt-submit' => 'Označi ovu verziju za prevođenje',
	'tpt-sections-oldnew' => 'Nove i postojeće prevodilačke jedinice',
	'tpt-sections-deleted' => 'Obrisane prevodilačke jedinice',
	'tpt-sections-template' => 'Šablon stranice prevođenja',
	'tpt-badtitle' => 'Zadano ime stranice ($1) nije valjan naslov',
	'tpt-oldrevision' => '$2 nije posljednja verzija stranice [[$1]].
Jedino posljednje verzije se mogu označiti za prevođenje.',
	'tpt-notsuitable' => 'Stranica $1 nije pogodna za prevođenje.
Provjerite da postoje oznake <nowiki><translate></nowiki> i da ima valjanu sintaksu.',
	'tpt-saveok' => 'Stranica [[$1]] je označena za prevođenje sa $2 {{PLURAL:$2|prevodilačkom jedinicom|prevodilačke jedinice|prevodilačkih jedinica}}.
Stranica se sad može <span class="plainlinks">[$3 prevoditi]</span>.',
	'tpt-badsect' => '"$1" nije valjano ime za jedinicu prevođenja $2.',
	'tpt-showpage-intro' => 'Ispod su navedene nove, postojeće i obrisane sekcije.
Prije nego što označite ovu verziju za prevođenje, provjerite da su izmjene sekcija minimizirane da bi se spriječio nepotrebni rad prevodioca.',
	'tpt-mark-summary' => 'Ova vezija označena za prevođenje',
	'tpt-edit-failed' => 'Nije moguće ažurirati stranicu: $1',
	'tpt-already-marked' => 'Posljednja verzija ove stranice je već označena za prevođenje.',
	'tpt-list-nopages' => 'Nijedna stranica nije označena za prevođenje niti je spremna za označavanje.',
	'tpt-old-pages' => 'Neke verzije {{PLURAL:$1|ove stranice|ovih stranica}} su označene za prevođenje.',
	'tpt-new-pages' => '{{PLURAL:$1|Ova stranica sadrži|Ove stranice sadrže}} tekst sa oznakama prijevoda, ali nijedna od verzija {{PLURAL:$1|ove stranice|ovih stranica}} nije trenutno označena za prevođenje.',
	'tpt-rev-latest' => 'posljednja verzija',
	'tpt-rev-old' => 'razlika od ranije označene verzije',
	'tpt-rev-mark-new' => 'označi ovu verziju za prevođenje',
	'tpt-translate-this' => 'prevedi ovu stranicu',
	'translate-tag-translate-link-desc' => 'Prevedi ovu stranicu',
	'translate-tag-markthis' => 'Označi ovu stranicu za prevođenje',
	'translate-tag-markthisagain' => 'Ova stranica ima <span class="plainlinks">[$1 izmjena]</span> od kako je posljednji put <span class="plainlinks">[$2 označena za prevođenje]</span>.',
	'translate-tag-hasnew' => 'Ova stranica sadrži <span class="plainlinks">[$1 izmjena]</span> koje nisu označene za prevođenje.',
	'tpt-translation-intro' => 'Ova stranica je <span class="plainlinks">[$1 prevedena verzija]</span> stranice [[$2]] a prijevod je $3% dovršen i ažuriran.',
	'tpt-translation-intro-fuzzy' => 'Zastarijeli prijevodi su označeni ovako.',
	'tpt-languages-legend' => 'Drugi jezici:',
	'tpt-target-page' => 'Ova stranica ne može biti ručno ažurirana.
Ova stranica je prijevod stranice [[$1]] a prevodi se mogu ažurirati putem [$2 alata za prevođenje].',
	'tpt-unknown-page' => 'Ovaj imenski prostor je rezervisan za prevode stranica sadržaja.
Stranica koju pokušavate uređivati ne odgovara nekoj od stranica koje su označene za prevođenje.',
	'tpt-install' => 'Pokrenite php maintenance/update.php ili web install da biste omogućili osobinu prevođenja stranica.',
	'tpt-render-summary' => 'Ažuriram na novu verziju izvorne stranice',
	'tpt-download-page' => 'Izvezi stranicu sa prijevodima',
);

/** Buginese (ᨅᨔ ᨕᨘᨁᨗ)
 * @author Kurniasan
 */
$messages['bug'] = array(
	'translate-tag-translate-link-desc' => "Tare'juma iyyedé leppa",
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'pagetranslation' => "Traducció d'una pàgina",
	'tpt-section' => 'Unitat de traducció $1',
	'tpt-section-new' => 'Nova unitat de traducció. Nom: $1',
	'tpt-diff-old' => 'Text anterior',
	'tpt-diff-new' => 'Text nou',
	'tpt-badtitle' => 'El nom de pàgina donat ($1) no és un títol vàlid',
	'tpt-notsuitable' => 'La pàgina $1 no està preparada per a la seva traducció.
Assegureu-vos que té les etiquetes <nowiki><translate></nowiki> i una sintaxi vàlida.',
	'tpt-rev-latest' => 'última versió',
	'translate-tag-translate-link-desc' => 'Traduir aquesta pàgina',
	'tpt-languages-legend' => 'Altres idiomes:',
);

/** Sorani (Arabic script) (‫کوردی (عەرەبی)‬)
 * @author Marmzok
 * @author رزگار
 */
$messages['ckb-arab'] = array(
	'pagetranslation' => 'وەرگێڕانی لاپەڕە',
	'tpt-template' => 'داڕێژەی لاپەڕە',
	'tpt-templatediff' => 'داڕێژەی لاپەڕەکە گۆڕاوە.',
	'tpt-diff-old' => 'دەقی پێشوو',
	'tpt-diff-new' => 'دەقی نوێ',
	'tpt-submit' => 'نیشان‌کردنی ئەم وەشانە بۆ وەرگێڕان',
	'tpt-sections-template' => 'داڕێژی لاپەڕەی وەرگێڕان',
	'tpt-already-marked' => 'دوایین وەشانی ئەم لاپەڕەیە لە پێش‌دا بۆ وەرگێڕان نیشان کراوە.',
	'tpt-rev-latest' => 'دوایین وەشان',
	'tpt-translate-this' => 'وەرگێڕانی ئەم لاپەڕەیە',
	'translate-tag-translate-link-desc' => 'وەرگێڕانی ئەم پەڕە',
	'translate-tag-markthis' => 'نیشان‌کردنی ئەم لاپەڕەیە بۆ وەرگێڕان',
	'tpt-languages-legend' => 'زمانەکانی دیکە:',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'pagetranslation' => 'Překlad stránek',
	'right-pagetranslation' => 'Označování verzí stránek pro překlad',
	'tpt-desc' => 'Rozšíření pro překládání stránek s obsahem',
	'tpt-section' => 'Část překladu $1',
	'tpt-section-new' => 'Nová část překladu.
Název: $1',
	'tpt-section-deleted' => 'Část překladu $1',
	'tpt-template' => 'Šablona stránky',
	'tpt-templatediff' => 'Šablona stránky se změnila.',
	'tpt-diff-old' => 'Předchozí text',
	'tpt-diff-new' => 'Nový text',
	'tpt-submit' => 'Označit tuto verzi pro překlad',
	'tpt-sections-oldnew' => 'Nové a existující části překladu',
	'tpt-sections-deleted' => 'Smazané části překladu',
	'tpt-sections-template' => 'Šablona stránky pro překlad',
	'tpt-badtitle' => 'Zadaný název stránky ($1) je neplatný',
	'tpt-oldrevision' => '$2 není nejnovější verze stránky [[$1]].
Pro překlad je možné označit pouze nejnovější verze.',
	'tpt-notsuitable' => 'Stránka $1 není vhodná pro překlad.
Ujistěte se, že obsahuje značky <code><nowiki><translate></nowiki></code> a má platnou syntaxi.',
	'tpt-saveok' => 'Stránka [[$1]] byla označena pro překlad {{PLURAL:$2|s $2 částí překladu|se $2 částmi překladu|s $2 částmi překladu}}.
Tato stránka může být nyní <span class="plainlinks">[$3 přeložena]</span>.',
	'tpt-badsect' => '„$1“ není platný název části překladu $2.',
	'tpt-showpage-intro' => 'Níže jsou uvedeny nové, současné a smazané části.
Předtím než tuto verzi označíte pro překlad zkontrolujte, že změny částí jsou minimální, abyste zabránili zbytečné práci překladatelů.',
	'tpt-mark-summary' => 'Tato verze je označená pro překlad',
	'tpt-edit-failed' => 'Nelze aktualizovat stránku: $1',
	'tpt-already-marked' => 'Nejnovější verze této stránky už byla označena pro překlad.',
	'tpt-list-nopages' => 'Žádné stránky nejsou označeny pro překlad nebo na to nejsou připraveny.',
	'tpt-old-pages' => 'Některé verze {{PLURAL:$1|této stránky|těchto stránek}} bylo označeny pro překlad.',
	'tpt-new-pages' => '{{PLURAL:$1|Tato stránka obsahuje|Tyto stránky obsahují}} text se značkami pro překlad, ale žádná verze {{PLURAL:$1|této stránky|těchto stránek}} není aktuálně označena pro překlad.',
	'tpt-rev-latest' => 'nejnovější verze',
	'tpt-rev-old' => 'rozdíl oproti předchozí označené verzi',
	'tpt-rev-mark-new' => 'označit tuto verzi pro překlad',
	'tpt-translate-this' => 'přeložit tuto stránku',
	'translate-tag-translate-link-desc' => 'Přeložit tuto stránku',
	'translate-tag-markthis' => 'Označit tuto stránku pro překlad',
	'translate-tag-markthisagain' => 'Tato stránka byla <span class="plainlinks">[$1 změněna]</span> od posledního <span class="plainlinks">[$2 označení pro překlad]</span>.',
	'translate-tag-hasnew' => 'Tato stránka obsahuje <span class="plainlinks">[$1 změny]</span>, které nebyly označeny pro překlad.',
	'tpt-translation-intro' => 'Toto je <span class="plainlinks">[$1 přeložená verze]</span> stránky [[$2]], překlad je úplný a aktuální na $3 %.',
	'tpt-translation-intro-fuzzy' => 'Takto jsou označeny zastaralé části překladu.',
	'tpt-languages-legend' => 'Jiné jazyky:',
	'tpt-target-page' => 'Tuto stránku nelze ručně aktualizovat.
Tato stránka je překladem stránky [[$1]] a překlad lze aktualizovat pomocí [$2 nástroje pro překlad].',
	'tpt-unknown-page' => 'Tento jmenný prostor je vyhrazený pro překlady stránek s obsahem.
Zdá se, že stránka, kterou se pokoušíte upravovat neodpovídá žádné stránce označené pro překlad.',
	'tpt-install' => 'Funkci překladu stránek povolíte spuštěním <code>php maintenance/update.php</code> nebo webové instalace.',
	'tpt-render-summary' => 'Aktualizace na novou verzi zdrojové stránky',
	'tpt-download-page' => 'Exportovat stránky s překlady',
);

/** Danish (Dansk)
 * @author Byrial
 */
$messages['da'] = array(
	'pagetranslation' => 'Sideoversættelse',
	'right-pagetranslation' => 'Markere versioner af sider for oversættelse',
	'tpt-desc' => 'Udvidelse til oversættelse af indholdssider',
	'tpt-section' => 'Oversættelsesenhed $1',
	'tpt-section-new' => 'Ny oversættelsesenhed.
Navn: $1',
	'tpt-section-deleted' => 'Oversættelsesenhed $1',
	'tpt-template' => 'Sideskabelon',
	'tpt-templatediff' => 'Sideskabelonen er blevet ændret.',
	'tpt-diff-old' => 'Forrige tekst',
	'tpt-diff-new' => 'Ny tekst',
	'tpt-submit' => 'Markér denne version for oversættelse',
	'tpt-sections-oldnew' => 'Nye og eksisterende oversættelsesenheder',
	'tpt-sections-deleted' => 'Slettede oversættelsesenheder',
	'tpt-sections-template' => 'Skabelon til oversættelsesside',
	'tpt-badtitle' => 'Det angivne sidenavn ($1) er ikke en gyldig titel',
	'tpt-oldrevision' => '$2 er ikke den seneste version af siden [[$1]].
Kun den seneste version kan markeres for oversættelse.',
	'tpt-notsuitable' => 'Siden $1 er ikke parat til oversættelse.
Sørg for at den har <nowiki><translate></nowiki>-tags og en gyldig syntaks.',
	'tpt-saveok' => 'Siden [[$1]] har blevet markeret for oversættelse med $2 {{PLURAL:$2|oversættelsesenhed|oversættelsesenheder}}.
Siden kan nu <span class="plainlinks">[$3 oversættes]</span>.',
	'tpt-badsect' => '"$1" er ikke et gyldig navn for oversættelsesenhed $2.',
	'tpt-showpage-intro' => 'Herunder er nye, eksisterende og slettede sektioner oplistet.
kontrollér før denne version markeres for oversættelse, at ændringerne i sektionene er så små som muligt for at undgå unødigt arbejde for oversætterne.',
	'tpt-mark-summary' => 'Markerede denne version for oversættelse',
	'tpt-edit-failed' => 'Kunne ikke opdatere siden: $1',
	'tpt-already-marked' => 'Den seneste version af denne side er allerede markeret for oversættelse.',
	'tpt-list-nopages' => 'Ingen sider er markeret for oversættelse eller parate til at blive markeret for oversættelse.',
	'tpt-old-pages' => 'En version af {{PLURAL:$1|denne side|disse sider}} er markeret for oversættelse.',
	'tpt-new-pages' => '{{PLURAL:$1|Denne side|Disse sider}} indeholder tekst med oversættelsestags, men ingen version af {{PLURAL:$1|siden|siderne}} er i øjeblikket markeret for oversættelse.',
	'tpt-rev-latest' => 'seneste version',
	'tpt-rev-old' => 'forskel fra forrige markerede version',
	'tpt-rev-mark-new' => 'markér denne version for oversættelse',
	'tpt-translate-this' => 'oversæt denne side',
	'translate-tag-translate-link-desc' => 'Oversæt denne side',
	'translate-tag-markthis' => 'Markér denne side for oversættelse',
	'translate-tag-markthisagain' => 'Denne side er <span class="plainlinks">[$1 ændret]</span> siden den sidst blev <span class="plainlinks">[$2 markeret for oversættelse]</span>.',
	'translate-tag-hasnew' => 'Denne side indeholder <span class="plainlinks">[$1 ændringer]</span> som ikke er markeret for oversættelse.',
	'tpt-translation-intro' => 'Denne side er en <span class="plainlinks">[$1 oversat version]</span> af en side [[$2]] og oversættelsen er $3 % komplet og opdateret.',
	'tpt-translation-intro-fuzzy' => 'Forældede oversættelser er markeret sådan her.',
	'tpt-languages-legend' => 'Andre sprog:',
	'tpt-target-page' => 'Denne side kan ikke opdateres manuelt.
Siden er en oversættelse af siden [[$1]] og oversættelsen kan opdateres ved at bruge [$2 oversættelsesværktøjet].',
	'tpt-unknown-page' => 'Dette navnerum er reserveret til oversættelser af indholdssider.
Siden som du prøver at redigere, ser ikke ud til at svare til nogen side markeret for oversættelse.',
	'tpt-install' => 'Kør php maintenance/update.php eller webinstallering for at slå sideoversættelsesfunktionen til.',
	'tpt-render-summary' => 'Opdaterer for at passe til en ny version af kildesiden',
	'tpt-download-page' => 'Eksportér side med oversættelser',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Imre
 * @author Purodha
 * @author Umherirrender
 */
$messages['de'] = array(
	'pagetranslation' => 'Übersetzung von Seiten',
	'right-pagetranslation' => 'Seitenversionen für die Übersetzung markieren',
	'tpt-desc' => 'Erweiterung zur Übersetzung von Wikiseiten',
	'tpt-section' => 'Übersetzungseinheit $1',
	'tpt-section-new' => 'Neue Übersetzungseinheit. Name: $1',
	'tpt-section-deleted' => 'Übersetzungseinheit $1',
	'tpt-template' => 'Seitenvorlage',
	'tpt-templatediff' => 'Die Seitenvorlage hat sich geändert.',
	'tpt-diff-old' => 'Vorheriger Text',
	'tpt-diff-new' => 'Neuer Text',
	'tpt-submit' => 'Diese Version zur Übersetzung markieren',
	'tpt-sections-oldnew' => 'Neue und vorhandene Übersetzungseinheiten',
	'tpt-sections-deleted' => 'Gelöschte Übersetzungseinheiten',
	'tpt-sections-template' => 'Übersetzungsseitenvorlage',
	'tpt-badtitle' => 'Der angegebene Seitenname „$1“ ist kein gültiger Titel',
	'tpt-oldrevision' => '$2 ist nicht die letzte Version der Seite [[$1]].
Nur die letzte Version kann zur Übersetzung markiert werden.',
	'tpt-notsuitable' => 'Die Seite $1 ist nicht zum Übersetzen geeignet.
Stelle sicher, dass ein <nowiki><translate></nowiki>-Tag und gültige Syntax verwendet wird.',
	'tpt-saveok' => 'Die Seite [[$1]] wurde mit $2 {{PLURAL:$2|übersetzbarem Abschnitt|übersetzbaren Abschnitten}} für die Übersetzung markiert.
Diese Seite kann nun <span class="plainlinks">[$3 übersetzt]</span> werden.',
	'tpt-badsect' => '„$1“ ist kein gültiger Name für Übersetzungseinheit $2.',
	'tpt-showpage-intro' => 'Untenstehend sind neue, vorhandene und gelöschte Abschnitte aufgelistet.
Bevor du diese Version zur Übersetzung markierst, stelle sicher, dass die Änderungen an den Abschnitten minimal sind, um unnötige Arbeit für Übersetzer zu verhindern.',
	'tpt-mark-summary' => 'Diese Seite wurde zum Übersetzen markiert',
	'tpt-edit-failed' => 'Seite kann nicht aktualisiert werden: $1',
	'tpt-already-marked' => 'Die letzte Version dieser Seite wurde bereits zur Übersetzung markiert.',
	'tpt-list-nopages' => 'Es sind keine Seiten zur Übersetzung markiert und auch keine bereit, zur Übersetzung markiert zu werden.',
	'tpt-old-pages' => 'Eine Version dieser {{PLURAL:$1|Seite|Seiten}} wurde zur Übersetzung markiert.',
	'tpt-new-pages' => '{{PLURAL:$1|Diese Seite beinhaltet|Diese Seiten beinhalten}} Text zum Übersetzen, aber es wurde noch keine Version dieser {{PLURAL:$1|Seite|Seiten}} zur Übersetzung markiert.',
	'tpt-rev-latest' => 'Letzte Version',
	'tpt-rev-old' => 'Unterschied zu vorheriger markierter Version',
	'tpt-rev-mark-new' => 'diese Version zur Übersetzung markieren',
	'tpt-translate-this' => 'diese Seite übersetzen',
	'translate-tag-translate-link-desc' => 'Diese Seite übersetzen',
	'translate-tag-markthis' => 'Diese Seite zur Übersetzung markieren',
	'translate-tag-markthisagain' => 'Diese Seite wurde <span class="plainlinks">[$1 bearbeitet]</span>, nachdem sie zuletzt <span class="plainlinks">[$2 zur Übersetzung markiert]</span> wurde.',
	'translate-tag-hasnew' => 'Diese Seite enthält <span class="plainlinks">[$1 Bearbeitungen]</span>, die nicht zur Übersetzung markiert sind.',
	'tpt-translation-intro' => 'Diese Seite ist eine <span class="plainlinks">[$1 übersetzte Version]</span> der Seite [[$2]] und die Übersetzung ist zu $3 % abgeschlossen und aktuell.',
	'tpt-translation-intro-fuzzy' => 'Nicht aktuelle Übersetzungen werden wie dieser Text markiert.',
	'tpt-languages-legend' => 'Andere Sprachen:',
	'tpt-target-page' => 'Diese Seite kann nicht manuell aktualisiert werden.
Diese Seite ist eine Übersetzung der Seite [[$1]] und die Übersetzung kann mithilfe des [$2 Übersetzungswerkzeuges] aktualisiert werden.',
	'tpt-unknown-page' => 'Dieser Namensraum ist für das Übersetzen von Wikiseiten reserviert.
Die Seite, die gerade bearbeitet wird, hat keine Verbindung zu einer übersetzbaren Seite.',
	'tpt-install' => 'Bitte <tt>maintenance/update.php</tt> oder Webinstallation ausführen, um die Seitenübersetzung zu aktivieren.',
	'tpt-render-summary' => 'Übernehme Bearbeitung einer neuen Version der Quellseite',
	'tpt-download-page' => 'Seite mit Übersetzungen exportieren',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'tpt-notsuitable' => 'Die Seite $1 ist nicht zum Übersetzen geeignet.
Stellen Sie sicher, dass ein <nowiki><translate></nowiki>-Tag und gültige Syntax verwendet wird.',
	'tpt-showpage-intro' => 'Untenstehend sind neue, vorhandene und gelöschte Abschnitte aufgelistet.
Bevor Sie diese Version zur Übersetzung markieren, stellen Sie bitte sicher, dass die Änderungen an den Abschnitten minimal sind, um unnötige Arbeit für Übersetzer zu verhindern.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'pagetranslation' => 'Pśełožowanje bokow',
	'right-pagetranslation' => 'Wersije bokow za pśełožowanje markěrowaś',
	'tpt-desc' => 'Rozšyrjenje za pśełožowanje wopśimjeśowych bokow',
	'tpt-section' => 'Pśełožowańska jadnotka $1',
	'tpt-section-new' => 'Nowa pśełožowańska jadnotka. Mě: $1',
	'tpt-section-deleted' => 'Pśełožowańska jadnotka $1',
	'tpt-template' => 'Bokowa pśedłoga',
	'tpt-templatediff' => 'Bokowa pśedłoga jo se změniła.',
	'tpt-diff-old' => 'Pśedchadny tekst',
	'tpt-diff-new' => 'Nowy tekst',
	'tpt-submit' => 'Toś tu wersiju za pśełožowanje markěrowaś',
	'tpt-sections-oldnew' => 'Nowe a eksistowace pśełožowańske jadnotki',
	'tpt-sections-deleted' => 'Wulašowane pśełožowańske jadnotki',
	'tpt-sections-template' => 'Pśedłoga pśełožowańskego boka',
	'tpt-badtitle' => 'Pódane bokowe mě ($1) njejo płaśiwy titel',
	'tpt-oldrevision' => '$2 njejo aktualna wersija boka [[$1]].
Jano aktualne wersije daju se za pśełožowanje markěrowaś.',
	'tpt-notsuitable' => 'Bok $1 njejo gódny za pśełožowanje.
Zawěsć, až ma toflicki <nowiki><translate></nowiki> a płaśiwu syntaksu.',
	'tpt-saveok' => 'Bok [[$1]] jo se markěrował za pśełožowanje z $2 {{PLURAL:$2|pśełožujobneju jadnotku|pśełožujobnyma jadnotkoma|pśełožujobnymi jadnotkami|pśełožujobnymi jadnotkami}}. Bok móže se něnto <span class="plainlinks">[$3 pśełožowaś]</span>.',
	'tpt-badsect' => '"$1" njejo płaśiwe mě za pśełožowańsku jadnotku $2.',
	'tpt-showpage-intro' => 'Dołojce su nowe, eksistěrujuce a wulašowane wótrězki nalicone.
Nježli až markěrujoš toś tu wersiju za pśełožowanje, pśekontrolěruj, lěc změny na wótrězkach su zminiměrowane, aby se wobinuł njetrěbne źěło za pśełožowarjow.',
	'tpt-mark-summary' => 'Jo toś tu wersiju za pśełožowanje markěrował',
	'tpt-edit-failed' => 'Toś ten bok njejo se dał aktualizěrowaś: $1',
	'tpt-already-marked' => 'Aktualna wersija toś togo boka jo južo za pśełožowanje markěrowana.',
	'tpt-list-nopages' => 'Žedne boki njejsu za pśełožowanje markěrowane ani su gótowe, aby se za pśełožowanje markěrowali.',
	'tpt-old-pages' => 'Někaka wersija {{PLURAL:$1|toś togo boka|toś teju bokowu|toś tych bokow|toś tych bokow}} jo se za pśełožowanje markěrowała.',
	'tpt-new-pages' => '{{PLURAL:$1|Toś ten bok wopśimujo|Toś tej boka wopśumujotej|Toś te boki wopśimuju|Toś te boki wopśimuju}} tekst z pśełožowańskimi toflickami, ale žedna wersija {{PLURAL:$1|toś togo boka|toś teju bokowu|toś tych bokow|toś tych bokow}} njejo tuchylu za pśełožowanje markěrowana.',
	'tpt-rev-latest' => 'aktualna wersija',
	'tpt-rev-old' => 'rozdźěl k pjerwjejšnej markěrowanej wersiji',
	'tpt-rev-mark-new' => 'toś tu wersiju za pśełožowanje markěrowaś',
	'tpt-translate-this' => 'toś ten bok pśełožyś',
	'translate-tag-translate-link-desc' => 'Toś ten bok pśełožyś',
	'translate-tag-markthis' => 'Toś ten bok za pśełožowanje markěrowaś',
	'translate-tag-markthisagain' => 'Toś ten bok ma <span class="plainlinks">[$1 {{PLURAL:$1|změnu|změnje|změny|změnow}}]</span>, wót togo casa, ako jo se slědny raz <span class="plainlinks">[$2 za pśełožowanje markěrował]</span>.',
	'translate-tag-hasnew' => 'Toś ten bok wopśimujo <span class="plainlinks">[$1 {{PLURAL:$1|změnu, kótaraž njejo markěrowana|změnje, kótarejž njejstej markěrowanej|změny, kótare njejsu markěrowane|změnow, kótarež njejsu markěrowane}}]</span> za pśełožowanje.',
	'tpt-translation-intro' => 'Toś ten bok jo <span class="plainlinks">[$1 pśełožona wersija]</span> boka [[$2]] a $3 % pśełožka jo dogótowane a pśełožk jo aktualne.',
	'tpt-translation-intro-fuzzy' => 'Zestarjone pśełožki su kaž toś ten markěrowany.',
	'tpt-languages-legend' => 'Druge rěcy:',
	'tpt-target-page' => 'Toś ten bok njedajo se manuelnje aktualizěrowaś.
Toś ten bok jo pśełožk boka [[$1]] a pśełožk dajo se z pomocu [$2 Pśełožyś] aktualizěrowaś.',
	'tpt-unknown-page' => 'Toś ten mjenjowy rum jo za pśełožki wopśimjeśowych bokow wuměnjony.
Zda se, až bok, kótaryž wopytujoš wobźěłaś, njewótpowědujo bokoju, kótaryž jo za pśełožowanje markěrowany.',
	'tpt-install' => 'Wuwjeź php maintenance/update.php abo webinstalaciju, aby zmóžnił funkciju pśełožowanja bokow.',
	'tpt-render-summary' => 'Aktualizacija pó nowej wersiji žrědłowego boka',
	'tpt-download-page' => 'Bok z pśełožkami eksportěrowaś',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 * @author ZaDiak
 */
$messages['el'] = array(
	'pagetranslation' => 'Μετάφραση σελίδων',
	'right-pagetranslation' => 'Σήμανση εκδόσεων σελίδων προς μετάφραση',
	'tpt-desc' => 'Επέκταση για μετάφραση σελίδων περιεχομένου',
	'tpt-section' => 'Μονάδα μετάφρασης $1',
	'tpt-section-new' => 'Νέα μονάδα μετάφρασης.
Όνομα: $1',
	'tpt-section-deleted' => 'Μονάδα μετάφρασης $1',
	'tpt-template' => 'Πρότυπο σελίδας',
	'tpt-templatediff' => 'Το πρότυπο σελίδας έχει αλλάξει.',
	'tpt-diff-old' => 'Προηγούμενο κείμενο',
	'tpt-diff-new' => 'Νέο κείμενο',
	'tpt-submit' => 'Σήμανση αυτής της έκδοσης για μετάφραση',
	'tpt-sections-oldnew' => 'Νέες και υπάρχοντες μονάδες μετάφρασης',
	'tpt-sections-deleted' => 'Διαγραμμένες μονάδες μετάφρασης',
	'tpt-sections-template' => 'Πρότυπο μετάφρασης σελίδας',
	'tpt-badtitle' => 'Ο τίτλος σελίδας που δώθηκε ($1) δεν είναι έγκυρος τίτλος',
	'tpt-notsuitable' => 'Η σελίδα $1 δεν είναι κατάλληλη για μετάφραση.
Σιγουρέψτε ότι έχει τις ετικέτες <nowiki><translate></nowiki> και έχει εγκυρη σύνταξη.',
	'tpt-badsect' => 'Το "$1" δεν είναι έγκυρο όνομα για τη μονάδα μετάφρασης $2.',
	'tpt-mark-summary' => 'Αυτή η έκδοση σημάνθηκε για μετάφραση',
	'tpt-edit-failed' => 'Δεν ήταν δυνατό να ενημερωθεί η σελίδα: $1',
	'tpt-already-marked' => 'Η τελευταία έκδοση της σελίδας έχει ήδη σημανθεί προς μετάφραση.',
	'tpt-list-nopages' => 'Καμιά σελίδα δεν έχει σημανθεί προς μετάφραση ούτε είναι έτοιμο για σήμανση προς μετάφραση.',
	'tpt-rev-latest' => 'τελευταία έκδοση',
	'tpt-rev-old' => 'διαφορά από την προηγούμενη παραμένουσα αναθεώρηση',
	'tpt-rev-mark-new' => 'σήμανση αυτής της έκδοσης για μετάφραση',
	'tpt-translate-this' => 'μετάφραση αυτής της σελίδας',
	'translate-tag-translate-link-desc' => 'Μεταφράστε αυτή τη σελίδα',
	'translate-tag-markthis' => 'Σήμανση αυτής της σελίδας για μετάφραση',
	'tpt-languages-legend' => 'Άλλες γλώσσες:',
	'tpt-render-summary' => 'Ενημέρωση για να αντιστοιχεί στη νέα έκδοση της σελίδας πηγής',
	'tpt-download-page' => 'Εξαγωγή της σελίδας με τις μεταφράσεις',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'pagetranslation' => 'Paĝa traduko',
	'right-pagetranslation' => 'Marki versiojn de paĝoj por traduki',
	'tpt-desc' => 'Kromprogramo por tradukado de enhavaj paĝoj',
	'tpt-section' => 'Tradukada unuo $1',
	'tpt-section-new' => 'Nova tradukada unuo.
Nomo: $1',
	'tpt-section-deleted' => 'Tradukada unuo $1',
	'tpt-template' => 'Paĝa ŝablono',
	'tpt-templatediff' => 'La paĝa ŝablono estis ŝanĝita.',
	'tpt-diff-old' => 'Antaŭa teksto',
	'tpt-diff-new' => 'Nova teksto',
	'tpt-submit' => 'Marki ĉi tiun version por traduki',
	'tpt-sections-oldnew' => 'Novaj kaj ekzistantaj tradukaĵoj',
	'tpt-sections-deleted' => 'Forigitaj tradukadaj unuoj',
	'tpt-sections-template' => 'Ŝablono por tradukada paĝo',
	'tpt-notsuitable' => 'Paĝo $1 ne taŭgas por traduki.
Certigu ke ĝi havas etikedojn <nowiki><translate></nowiki> kaj havas validan sintakson.',
	'tpt-mark-summary' => 'Markis ĉi tiun version por traduki.',
	'tpt-edit-failed' => 'Ne eblis ĝisdatigi la paĝon: $1',
	'tpt-rev-latest' => 'lasta versio',
	'tpt-rev-old' => 'diferenco de la antaŭa markita versio',
	'tpt-rev-mark-new' => 'marki ĉi tiun version por esti tradukita',
	'tpt-translate-this' => 'traduki ĉi tiun paĝon',
	'translate-tag-translate-link-desc' => 'Traduki ĉi tiun paĝon',
	'translate-tag-markthis' => 'Marki ĉi tiun paĝon por tradukado',
	'tpt-languages-legend' => 'Aliaj lingvoj:',
	'tpt-download-page' => 'Eksporti paĝon kun tradukoj',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Sanbec
 */
$messages['es'] = array(
	'pagetranslation' => 'Traducción de página',
	'right-pagetranslation' => 'Marcar versiones de páginas para traducción',
	'tpt-desc' => 'Extensiones para traducir páginas de contenido',
	'tpt-section' => 'Unidad de traducción $1',
	'tpt-section-new' => 'Nueva unidad de traducción. Nombre: $1',
	'tpt-section-deleted' => 'Unidad de traducción $1',
	'tpt-template' => 'Plantilla de página',
	'tpt-templatediff' => 'La plantilla de página ha cambiado.',
	'tpt-diff-old' => 'Texto previo',
	'tpt-diff-new' => 'Nuevo texto',
	'tpt-submit' => 'Marcar esta versión para traducción',
	'tpt-sections-oldnew' => 'Unidades de traducción nuevas y existentes',
	'tpt-sections-deleted' => 'Unidades de traducción borradas',
	'tpt-sections-template' => 'Plantilla de página de traducción',
	'tpt-badtitle' => 'Nombre de página dado ($1) no es un título válido',
	'tpt-oldrevision' => '$2 no es la última versión de la página [[$1]].
Solamente las últimas versiones pueden ser marcadas para traducción',
	'tpt-notsuitable' => 'La página $1 no es adecuada para traducción.
Asegúrate que tiene etiquetas <nowiki><translate></nowiki> y tiene una sintaxis válida.',
	'tpt-saveok' => 'La página [[$1]] ha sido marcada para traducción con $2 {{PLURAL:$2|unidad de traducción |unidades de traducción}}.
La página puede ser ahora <span class="plainlinks">[$3 traducida]</span>.',
	'tpt-badsect' => '"$1" no es un nombre válido para una unidad de traducción $2.',
	'tpt-showpage-intro' => 'Debajo secciones nuevas, existentes y borradas están listadas.
Antes de marcar esta versión para traducción, verifica que los cambios a las secciones son mínimos para evitar trabajo innecesario a los traductores.',
	'tpt-mark-summary' => 'Marcada esta sección para traducción',
	'tpt-edit-failed' => 'No pudo actualizar la página : $1',
	'tpt-already-marked' => 'La última versión de esta página ya ha sido marcada para traducción.',
	'tpt-list-nopages' => 'Ninguna página está marcada para traducción ni lista para ser marcada para traducción.',
	'tpt-old-pages' => 'Alguna versión de {{PLURAL:$1|esta página|estas páginas han}} sido marcadas para traducción.',
	'tpt-new-pages' => '{{PLURAL:$1|Esta página contiene|Estas páginas contienen}} texto con etiquetas de traducción, pero ninguna versión de {{PLURAL:$1|esta página est|estas páginas están}} actualmente marcadas para traducción.',
	'tpt-rev-latest' => 'última versión',
	'tpt-rev-old' => 'diferenciar a la versión marcada previa',
	'tpt-rev-mark-new' => 'marcar esta versión para traducción',
	'tpt-translate-this' => 'traducir esta página',
	'translate-tag-translate-link-desc' => 'Traducir esta página',
	'translate-tag-markthis' => 'Marcar esta página para traducción',
	'translate-tag-markthisagain' => 'Esta página tiene <span class="plainlinks">[$1 cambios]</span> desde la última vez que fue <span class="plainlinks">[$2 marcada para traducción]</span>.',
	'translate-tag-hasnew' => 'Esta página contiene <span class="plainlinks">[$1 cambios]</span> los cuales no han sido marcados para traducción.',
	'tpt-translation-intro' => 'Esta página es una <span class="plainlinks">[$1 versión traducida]</span> de una página [[$2]] y la traducción está $3% completa y actualizada.',
	'tpt-translation-intro-fuzzy' => 'Traducciones desactualizadas están marcadas así.',
	'tpt-languages-legend' => 'Otros idiomas:',
	'tpt-target-page' => 'Esta página no puede ser actualizada manualmente.
Esta página es una traducción de la página [[$1]] y la traducción puede ser actualizada usando [$2 la herramienta de traducción].',
	'tpt-unknown-page' => 'Este espacio de nombre está reservado para traducciones de páginas de contenido.
La página que estás tratando de editar no parece corresponder con alguna página marcada para traducción.',
	'tpt-install' => 'Corra maintenance/update.php o instale desde la web para activar las funciones de traducción.',
	'tpt-render-summary' => 'Actualizando para hallar una nueva versión de la página fuente',
	'tpt-download-page' => 'Exportar página con traducciones',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Ker
 * @author Pikne
 */
$messages['et'] = array(
	'pagetranslation' => 'Lehekülje tõlkimine',
	'tpt-section' => 'Tõlkeühik $1',
	'tpt-section-new' => 'Uus tõlkeühik.
Nimi: $1',
	'tpt-template' => 'Lehekülje mall',
	'tpt-diff-old' => 'Eelnev tekst',
	'tpt-diff-new' => 'Uus tekst',
	'tpt-sections-deleted' => 'Kustutatud tõlkeühikud',
	'tpt-edit-failed' => 'Lehekülje uuendamine ei õnnestunud: $1',
	'tpt-rev-latest' => 'uusim redaktsioon',
	'tpt-translate-this' => 'tõlgi see lehekülg',
	'translate-tag-translate-link-desc' => 'Tõlgi see leht',
	'tpt-languages-legend' => 'Teistes keeltes:',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'pagetranslation' => 'Orrialdearen itzulpena',
	'tpt-diff-old' => 'Aurreko testua',
	'tpt-diff-new' => 'Testu berria',
	'tpt-edit-failed' => 'Ezin izan da orrialdea eguneratu: $1',
	'tpt-rev-latest' => 'azkenengo bertsioa',
	'tpt-translate-this' => 'Itzuli orrialde hau',
	'translate-tag-translate-link-desc' => 'Itzuli orri hau',
	'tpt-languages-legend' => 'Beste hizkuntzak:',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Silvonen
 */
$messages['fi'] = array(
	'pagetranslation' => 'Sivun kääntäminen',
	'right-pagetranslation' => 'Merkitä versiot, jotka otetaan käännettäviksi',
	'tpt-desc' => 'Laajennus sisältösivujen kääntämiseen.',
	'tpt-section' => 'Käännösosio $1',
	'tpt-section-new' => 'Uusi käännösosio. Nimi: $1',
	'tpt-section-deleted' => 'Käännösosio $1',
	'tpt-template' => 'Sivun mallipohja',
	'tpt-templatediff' => 'Sivun mallipohja on muuttunut.',
	'tpt-diff-old' => 'Aikaisempi teksti',
	'tpt-diff-new' => 'Uusi teksti',
	'tpt-submit' => 'Merkitse tämä versio käännettäväksi',
	'tpt-sections-oldnew' => 'Uudet ja jo olemassa olevat käännösosiot',
	'tpt-sections-deleted' => 'Poistetut käännösosiot',
	'tpt-sections-template' => 'Käännössivun mallipohja',
	'tpt-badtitle' => 'Sivun nimi ($1) jota tarjottiin ei ole kelvollinen otsikko',
	'tpt-oldrevision' => '$2 ei ole uusin versio sivusta [[$1]]. 
Ainoastaan uusimmat versiot voidaan merkitä käännettäviksi.',
	'tpt-notsuitable' => 'Sivu $1 ei sovellu käännettäväksi.
Varmista, että siinä on <nowiki><translate></nowiki>-merkinnät ja että sillä on toimiva syntaksi.',
	'tpt-saveok' => 'Sivu [[$1]] on merkitty käännettäväksi $2 {{PLURAL:$2|käännösosiolla|käännösosioilla}}.
Sivu voidaan nyt <span class="plainlinks">[$3 kääntää]</span>.',
	'tpt-badsect' => '”$1” on epäkelpo nimi käännösosiolle $2.',
	'tpt-showpage-intro' => 'Alempana listattu uusia, nykyisiä ja poistettavia osioita. Ennen kuin merkitset tämän version käännettäväksi, tarkista, että muutokset osioihin on minimoitu, jotta vältämme turhan työn kääntäjille.',
	'tpt-mark-summary' => 'Merkitty tämä versio käännettäväksi',
	'tpt-edit-failed' => 'Ei voitu tallentaa muutosta sivulle: $1',
	'tpt-already-marked' => 'Uusin versio tästä sivusta on jo merkitty käännettäväksi.',
	'tpt-list-nopages' => 'Sivuja ei ole merkitty käännettäväksi eikä valmiina käännettäväksi merkintää varten.',
	'tpt-old-pages' => 'Joku versio {{PLURAL:$1|tästä sivusta on|näistä sivuista on}} on merkitty käännettäväksi.',
	'tpt-new-pages' => '{{PLURAL:$1|Tämä sivu sisältää|Nämä sivut sisältävät}} tekstiä johon on tehty käännösmerkkaus, mutta mikään versio {{PLURAL:$1|tästä sivusta|näistä sivuista}} ei ole tällä hetkellä merkattu käännettäväksi.',
	'tpt-rev-latest' => 'uusin versio',
	'tpt-rev-old' => 'eroavaisuudet edelliseen merkittyyn versioon',
	'tpt-rev-mark-new' => 'merkitse tämä versio käännettäväksi',
	'tpt-translate-this' => 'käännä tämä sivu',
	'translate-tag-translate-link-desc' => 'Käännä tämä sivu',
	'translate-tag-markthis' => 'Merkitse tämä sivu käännettäväksi',
	'translate-tag-markthisagain' => 'Tähän sivuun on tehty <span class="plainlinks">[$1 muutoksia]</span> sen jälkeen kun se viimeksi <span class="plainlinks">[$2 merkittiin käännettäväksi]</span>.',
	'translate-tag-hasnew' => 'Tämä sivu sisältää <span class="plainlinks">[$1 muutoksia],</span> joita ei ole merkitty käännettäväksi.',
	'tpt-translation-intro' => 'Tämä sivu on <span class="plainlinks">[$1 käännetty versio]</span> sivusta [[$2]] ja käännös on $3% täydellinen ja ajan tasalla.',
	'tpt-translation-intro-fuzzy' => 'Vanhentuneet käännökset, joiden lähdeteksti on muuttunut merkitään näin.',
	'tpt-languages-legend' => 'Muut kielet:',
	'tpt-target-page' => 'Tätä sivua ei voi päivittää manuaalisesti. Tämä sivu on käännös sivusta [[$1]] ja käännös voidaan päivittää käyttämällä [$2 käännöstyökalua].',
	'tpt-unknown-page' => 'Nimiavaruus on varattu sisältösivujen käännöksille. Sivu, jota yrität muokata, ei näytä vastaavan mitään sivua joka on merkitty käännettäväksi.',
	'tpt-install' => 'Suorita maintenance/update.php tai verkkoasennus, jotta sivun käännösominaisuus toimii.',
	'tpt-render-summary' => 'Päivittäminen vastaamaan uutta versiota lähdesivusta',
	'tpt-download-page' => 'Sivun vienti käännösten kera',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 */
$messages['fr'] = array(
	'pagetranslation' => 'Traduction de pages',
	'right-pagetranslation' => 'Marquer des versions de pages pour être traduites',
	'tpt-desc' => 'Extension pour traduire des pages de contenu',
	'tpt-section' => 'Unité de traduction $1',
	'tpt-section-new' => 'Nouvelle unité de traduction. Nom : $1',
	'tpt-section-deleted' => 'Unité de traduction $1',
	'tpt-template' => 'Modèle de page',
	'tpt-templatediff' => 'Le modèle de page a changé.',
	'tpt-diff-old' => 'Texte précédent',
	'tpt-diff-new' => 'Nouveau texte',
	'tpt-submit' => 'Marquer cette version pour être traduite',
	'tpt-sections-oldnew' => 'Unités de traduction nouvelles et existantes',
	'tpt-sections-deleted' => 'Unités de traduction supprimées',
	'tpt-sections-template' => 'Modèle de page de traduction',
	'tpt-badtitle' => 'Le nom de page donné ($1) n’est pas un titre valide',
	'tpt-oldrevision' => '$2 n’est pas la dernière version de la page [[$1]].
Seule la dernière version de la page peut être marquée pour être traduite.',
	'tpt-notsuitable' => 'La page $1 n’est pas convenable pour être traduite.
Soyez sûr qu’elle contient la balise <nowiki><translate></nowiki> et qu’elle a une syntaxe correcte.',
	'tpt-saveok' => 'La page « $1 » a été marqué pour être traduite avec $2 {{PLURAL:$2|unité de traduction|unités de traduction}}.
La page peut être <span class="plainlinks">[$3 traduite]</span> dès maintenant.',
	'tpt-badsect' => '« $1 » n’est pas un nom valide pour une unité de traduction $2.',
	'tpt-showpage-intro' => 'Ci-dessous, les nouvelles traductions, celles existantes et supprimées.
Avant de marquer ces versions pour être traduites, vérifier que les modifications aux sections sont minimisées pour éviter du travail inutile aux traducteurs.',
	'tpt-mark-summary' => 'Cette version a été marqué pour être traduite',
	'tpt-edit-failed' => 'Impossible de mettre à jour la page $1',
	'tpt-already-marked' => 'La dernière version de cette page a déjà été marquée pour être traduite.',
	'tpt-list-nopages' => 'Aucune page n’a été marquée pour être traduite ou prête pour l’être.',
	'tpt-old-pages' => 'Des versions de {{PLURAL:$1|cette page|ces pages}} ont été marquées pour être traduites.',
	'tpt-new-pages' => '{{PLURAL:$1|Cette page contient|Ces pages contiennent}} du texte avec des balises de traduction, mais aucune version de {{PLURAL:$1|cette page n’est marqué pour être traduite|ces page ne sont marquées pour être traduites}}.',
	'tpt-rev-latest' => 'dernière version',
	'tpt-rev-old' => 'différence avec la version marquée précédente',
	'tpt-rev-mark-new' => 'marquer cette version pour être traduite',
	'tpt-translate-this' => 'traduire cette page',
	'translate-tag-translate-link-desc' => 'Traduire cette page',
	'translate-tag-markthis' => 'Marquer cette page pour être traduite',
	'translate-tag-markthisagain' => 'Cette page a eu <span class="plainlinks">[$1 des modifications]</span> depuis qu’il a été dernièrement <span class="plainlinks">[$2 marqué pour être traduis]</span>.',
	'translate-tag-hasnew' => 'Cette page contient <span class="plainlinks">[$1 des modifications]</span> qui ne sont pas marqués pour la traduction.',
	'tpt-translation-intro' => 'Cette page est une <span class="plainlinks">[$1 traduction]</span> de la page [[$2]] et la traduction est complétée à $3 % et à jour.',
	'tpt-translation-intro-fuzzy' => 'Les traductions obsolètes sont marquées comme ceci.',
	'tpt-languages-legend' => 'Autres langues :',
	'tpt-target-page' => 'Cette page ne peut pas être mise à jour manuellement.
Elle est une version traduite de [[$1]] et la traduction peut être mise à jour en utilisant [$2 l’outil de traduction].',
	'tpt-unknown-page' => 'Cet espace de noms est réservé pour la traduction de pages.
La page que vous essayé de modifier ne semble pas correspondre à aucune page marqué pour être traduite.',
	'tpt-install' => 'Lancez « php maintenance/update.php » ou l’installation web pour activer la fonctionnalité de traduction de pages.',
	'tpt-render-summary' => 'Mise à jour pour être en accord avec la nouvelle version de la source de la page',
	'tpt-download-page' => 'Exporter la page avec ses traductions',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'pagetranslation' => 'Traduccion de pâges',
	'right-pagetranslation' => 'Marcar des vèrsions de pâges por étre traduites',
	'tpt-desc' => 'Èxtension por traduire des pâges de contegnu.',
	'tpt-section' => 'Unitât de traduccion $1',
	'tpt-section-new' => 'Novèla unitât de traduccion.
Nom : $1',
	'tpt-section-deleted' => 'Unitât de traduccion $1',
	'tpt-template' => 'Modèlo de pâge',
	'tpt-templatediff' => 'Lo modèlo de pâge at changiê.',
	'tpt-diff-old' => 'Tèxto devant',
	'tpt-diff-new' => 'Tèxto novél',
	'tpt-submit' => 'Marcar ceta vèrsion por étre traduita',
	'tpt-sections-oldnew' => 'Unitâts de traduccion novèles et ègzistentes',
	'tpt-sections-deleted' => 'Unitâts de traduccion suprimâs',
	'tpt-sections-template' => 'Modèlo de pâge de traduccion',
	'tpt-badtitle' => 'Lo nom de pâge balyê ($1) est pas un titro valido',
	'tpt-oldrevision' => '$2 est pas la dèrriére vèrsion de la pâge [[$1]].
Solament la dèrriére vèrsion de la pâge pôt étre marcâ por étre traduita.',
	'tpt-notsuitable' => 'La pâge $1 est pas convegnâbla por étre traduita.
Seyâd de sûr que contint la balisa <nowiki><translate></nowiki> et qu’at una sintaxa justa.',
	'tpt-saveok' => 'La pâge « $1 » at étâ marcâ por étre traduita avouéc $2 {{PLURAL:$2|unitât de traduccion|unitâts de traduccion}}.
La pâge pôt étre <span class="plainlinks">[$3 traduita]</span> dês ora.',
	'tpt-badsect' => '« $1 » est pas un nom valido por una unitât de traduccion $2.',
	'tpt-showpage-intro' => 'Ce-desot, les novèles traduccions, celes ègzistentes et suprimâs.
Devant que marcar cetes vèrsions por étre traduites, controlâd que los changements a les sèccions sont petiôts por èvitar de travâly inutilo ux traductors.',
	'tpt-mark-summary' => 'Ceta vèrsion at étâ marcâ por étre traduita',
	'tpt-edit-failed' => 'Empossiblo de betar a jorn la pâge $1',
	'tpt-already-marked' => 'La dèrriére vèrsion de ceta pâge at ja étâ marcâ por étre traduita.',
	'tpt-list-nopages' => 'Niona pâge at étâ marcâ por étre traduita ou ben prèsta por l’étre.',
	'tpt-old-pages' => 'Des vèrsions de {{PLURAL:$1|ceta pâge|cetes pâges}} ont étâ marcâs por étre traduites.',
	'tpt-new-pages' => '{{PLURAL:$1|Ceta pâge contint|Cetes pâges contegnont}} de tèxto avouéc des balises de traduccion, mas niona vèrsion de {{PLURAL:$1|ceta pâge est marcâ por étre traduita|cetes pâges sont marcâs por étre traduites}}.',
	'tpt-rev-latest' => 'dèrriére vèrsion',
	'tpt-rev-old' => 'difèrence avouéc cela vèrsion marcâ',
	'tpt-rev-mark-new' => 'marcar ceta vèrsion por étre traduita',
	'tpt-translate-this' => 'traduire ceta pâge',
	'translate-tag-translate-link-desc' => 'Traduire ceta pâge',
	'translate-tag-markthis' => 'Marcar ceta pâge por étre traduita',
	'translate-tag-markthisagain' => 'Ceta pâge at avu des <span class="plainlinks">[$1 changements]</span> dês qu’at étâ <span class="plainlinks">[$2 marcâ por étre traduita]</span> dèrriérement.',
	'translate-tag-hasnew' => 'Ceta pâge contint des <span class="plainlinks">[$1 changements]</span> que sont pas marcâs por la traduccion.',
	'tpt-translation-intro' => 'Ceta pâge est una <span class="plainlinks">[$1 traduccion]</span> de la pâge [[$2]] et la traduccion est complètâ a $3 % et a jorn.',
	'tpt-translation-intro-fuzzy' => 'Les traduccions dèpassâs sont marcâs d’ense.',
	'tpt-languages-legend' => 'Ôtres lengoues :',
	'tpt-target-page' => 'Ceta pâge pôt pas étre betâ a jorn a la man.
El est una vèrsion traduita de [[$1]] et la traduccion pôt étre betâ a jorn en utilisent l’[$2 outil de traduccion].',
	'tpt-unknown-page' => 'Ceti èspâço de noms est resèrvâ por la traduccion de pâges de contegnu.
La pâge que vos tâchiéd de changiér semble pas corrèspondre a gins de pâge marcâ por étre traduita.',
	'tpt-install' => 'Lanciéd « php maintenance/update.php » ou ben l’enstalacion vouèbe por activar la fonccionalitât de traduccion de pâges.',
	'tpt-render-summary' => 'Misa a jorn por étre en acôrd avouéc la novèla vèrsion de la pâge d’origina',
	'tpt-download-page' => 'Èxportar la pâge avouéc ses traduccions',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'pagetranslation' => 'Tradución da páxina',
	'right-pagetranslation' => 'Marcar as versións de páxinas para seren traducidas',
	'tpt-desc' => 'Extensión para traducir contidos de páxinas',
	'tpt-section' => 'Unidade de tradución $1',
	'tpt-section-new' => 'Nova unidade de tradución. Nome: $1',
	'tpt-section-deleted' => 'Unidade de tradución $1',
	'tpt-template' => 'Modelo de páxina',
	'tpt-templatediff' => 'Cambiou o modelo de páxina.',
	'tpt-diff-old' => 'Texto anterior',
	'tpt-diff-new' => 'Texto novo',
	'tpt-submit' => 'Marcar esta versión para ser traducida',
	'tpt-sections-oldnew' => 'Unidades de tradución novas e existentes',
	'tpt-sections-deleted' => 'Unidades de tradución borradas',
	'tpt-sections-template' => 'Modelo de páxina de tradución',
	'tpt-badtitle' => 'O nome de páxina dado ("$1") non é un título válido',
	'tpt-oldrevision' => '$2 non é a última versión da páxina "[[$1]]".
Só as últimas versións poden ser marcadas para seren traducidas.',
	'tpt-notsuitable' => 'A páxina "$1" non é válida para ser traducida.
Comprobe que teña as etiquetas <nowiki><translate></nowiki> e mais unha sintaxe válida.',
	'tpt-saveok' => 'A páxina "[[$1]]" foi marcada para ser traducida, {{PLURAL:$2|cunha unidade de tradución|con $2 unidades de tradución}}.
A páxina agora pode ser <span class="plainlinks">[$3 traducida]</span>.',
	'tpt-badsect' => '"$1" non é un nome válido para a unidade de tradución $2.',
	'tpt-showpage-intro' => 'A continuación están listadas as seccións existentes e borradas.
Antes de marcar esta versión para ser traducida, comprobe que as modificacións feitas ás seccións foron minimizadas para evitarlles traballo innecesario aos tradutores.',
	'tpt-mark-summary' => 'Marcou esta versión para ser traducida',
	'tpt-edit-failed' => 'Non se puido actualizar a páxina: $1',
	'tpt-already-marked' => 'A última versión desta páxina xa foi marcada para ser traducida.',
	'tpt-list-nopages' => 'Non hai ningunha páxina marcada para ser traducida, nin preparada para ser marcada para ser traducida.',
	'tpt-old-pages' => 'Algunha versión {{PLURAL:$1|desta páxina|destas páxinas}} ten sido marcada para ser traducida.',
	'tpt-new-pages' => '{{PLURAL:$1|Esta páxina contén|Estas páxinas conteñen}} texto con etiquetas de tradución, pero ningunha versión {{PLURAL:$1|desta páxina|destas páxinas}} está actualmente marcada para ser traducida.',
	'tpt-rev-latest' => 'última versión',
	'tpt-rev-old' => 'diferenza coa versión previa marcada',
	'tpt-rev-mark-new' => 'marcar esta versión para ser traducida',
	'tpt-translate-this' => 'traducir esta páxina',
	'translate-tag-translate-link-desc' => 'Traducir esta páxina',
	'translate-tag-markthis' => 'Marcar esta páxina para ser traducida',
	'translate-tag-markthisagain' => 'Esta páxina sufriu <span class="plainlinks">[$1 cambios]</span> desde que foi <span class="plainlinks">[$2 marcada para a súa tradución]</span> por última vez.',
	'translate-tag-hasnew' => 'Esta páxina contén <span class="plainlinks">[$1 cambios]</span> que non están marcados para a súa tradución.',
	'tpt-translation-intro' => 'Esta páxina é unha <span class="plainlinks">[$1 versión traducida]</span> da páxina "[[$2]]" e a tradución está completada e actualizada ao $3%.',
	'tpt-translation-intro-fuzzy' => 'As traducións desfasadas están marcadas coma este texto.',
	'tpt-languages-legend' => 'Outras linguas:',
	'tpt-target-page' => 'Esta páxina non se pode actualizar manualmente.
Esta páxina é unha tradución da páxina "[[$1]]" e a tradución pódese actualizar usando [$2 a ferramenta de tradución].',
	'tpt-unknown-page' => 'Este espazo de nomes está reservado para traducións de páxinas de contido.
A páxina que está intentando editar parece non corresponder a algunha páxina marcada para ser traducida.',
	'tpt-install' => 'Executar o php maintenance/update.php ou o instalador web para activar a funcionalidade de tradución de páxinas.',
	'tpt-render-summary' => 'Actualizando para coincidir coa nova versión da páxina de orixe',
	'tpt-download-page' => 'Exportar a páxina coas traducións',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'pagetranslation' => 'Sytenibersetzig',
	'right-pagetranslation' => 'D Syte, wu sotte ibersetzt wäre, markiere',
	'tpt-desc' => 'Erwyterig fir d Iberstzig vu Inhaltssyte',
	'tpt-section' => 'Iberstzigs-Abschnitt $1',
	'tpt-section-new' => 'Neje Iberstzigs-Abschnitt. Name: $1',
	'tpt-section-deleted' => 'Ibersetzigs-Abschnitt $1',
	'tpt-template' => 'Sytevorlag',
	'tpt-templatediff' => 'D Sytevorlag het sich gänderet.',
	'tpt-diff-old' => 'Vorige Tekscht',
	'tpt-diff-new' => 'Neje Tekscht',
	'tpt-submit' => 'Die Version zum Ibersetze markiere',
	'tpt-sections-oldnew' => 'Neji un vorhandeni Ibersetzigs-Abschnitt',
	'tpt-sections-deleted' => 'Gleschti Ibersetzigs-Abschnitt',
	'tpt-sections-template' => 'Ibersetzigs-Sytevorlag',
	'tpt-badtitle' => 'Dr Sytename, wu Du aagee hesch ($1), isch kei giltige Sytename',
	'tpt-oldrevision' => '$2 isch nit di letscht Version vu dr Syte [[$1]].
Nume di letschte Versione chenne zum Iberseze markiert wäre.',
	'tpt-notsuitable' => 'D Syte $1 cha nit iberstez wäre.
Stell sicher, ass si <nowiki><translate></nowiki>-Markierige un e giltige Syntax het.',
	'tpt-saveok' => 'D Syte [[$1]] isch zum Ibersetze markiert wore mit $2 {{PLURAL:$2|Ibersetzigs-Abschnitt|Ibersetzigs-Abschnitt}}.
D Syte cha jetz <span class="plainlinks">[$3 ibersetzt]</span> wäre.',
	'tpt-badsect' => '"$1" isch kei giltige Name fir dr Iberstzigs-Abschnitt $2.',
	'tpt-showpage-intro' => 'Unte sin Abschnitt ufglischtet, wu nej sin, sonigi wu s git un sonigi wu s nit git.
Voreb Du die Versione zum Ibersetze markiersch, iberprief, ass d Änderige an dr Abschnitt gring ghalte sin go uunetigi Arbed bi dr Ibersetzig vermyde.',
	'tpt-mark-summary' => 'het die Versione zum Ibersetze markiert',
	'tpt-edit-failed' => 'Cha d Syte nit aktualisiere: $1',
	'tpt-already-marked' => 'Di letscht Version vu däre Syte isch scho zum Ibersetze markiert wore.',
	'tpt-list-nopages' => 'S sin kei Syte zum Ibersetze markiert wore un sin au no keini Syte fertig, wu chennte zum Ibersetze markiert wäre',
	'tpt-old-pages' => '{{PLURAL:$1|E Version vu däre Syte isch|E paar Versione vu däne Syte sin}} zum Ibersetze markiert wore',
	'tpt-new-pages' => '{{PLURAL:$1|In däre Syte|In däne Syte}} het s Tekscht mit Ibersetzigs-Markierige, aber zur Zyt isch kei Version {{PLURAL:$1|däre Syte|däne Syte}} zum Ibersetze markiert.',
	'tpt-rev-latest' => 'letschti Version',
	'tpt-rev-old' => 'Unterschid zue dr letschte markierte Version',
	'tpt-rev-mark-new' => 'die Version zum Ibersetze markiere',
	'tpt-translate-this' => 'die Syte ibersetze',
	'translate-tag-translate-link-desc' => 'Die Syte ibersetze',
	'translate-tag-markthis' => 'Die Syte zum ibersetze markiere',
	'translate-tag-markthisagain' => 'An däre Syte het s <span class="plainlinks">[$1 Änderige]</span> gee, syt si s lescht Mol <span class="plainlinks">[$2 zum Ibersetze markiert wore isch]</span>.',
	'translate-tag-hasnew' => 'In däre Syte het s <span class="plainlinks">[$1 Änderige]</span>, wu nit zum Ibersetze markiert sin.',
	'tpt-translation-intro' => 'Die Syte isch e <span class="plainlinks">[$1 ibersetzti Version]</span> vun ere Syte [[$2]] un d Ibersetzig isch zue $3% vollständig un aktuäll.',
	'tpt-translation-intro-fuzzy' => 'Nit aktuälli Ibersetzige wäre wie dää Tekscht markiert.',
	'tpt-languages-legend' => 'Anderi Sproche:',
	'tpt-target-page' => 'Die Syte cha nit vu Hand aktualisiert wäre.
Die Syte isch e Ibersetzig vu dr Syte [[$1]] un d Ibersetzig cha aktualisert wäre mit em [$2 Ibersetzigstool].',
	'tpt-unknown-page' => 'Dää Namensruum isch reserviert fir Ibersetzige vu Inhaltssyte.
D Syte, wu Du witt bearbeite, ghert schyns zue keire Syte, wu zum Ibersetze markiert isch.',
	'tpt-install' => 'php maintenance/update.php oder d Webinstallation laufe loo go s Syte-Ibersetzigs-Feature megli mache.',
	'tpt-render-summary' => 'Aktualisiere zum e neji Version vu dr Quällsyte z finde',
	'tpt-download-page' => 'Syte mit Ibersetzige exportiere',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 */
$messages['gu'] = array(
	'pagetranslation' => 'પાનું ભાષાંતરણ',
	'right-pagetranslation' => 'ભાષાંતર માટેનાં પાનાઓનાં સંસ્કરણો ચિહ્નિત કરો',
	'tpt-section' => 'ભાષાંતર એકમ $1',
	'tpt-section-new' => 'નવું ભાષાંતર એકમ. નામ: $1',
	'tpt-section-deleted' => 'ભાષાંતર એકમ $1',
	'tpt-template' => 'પાનાં ઢાંચો',
	'tpt-templatediff' => 'પાનાંનો ઢાંચો બદલાયો છે.',
	'tpt-diff-old' => 'પહેલાંનું લખાણ',
	'tpt-diff-new' => 'નવું લખાણ',
	'tpt-submit' => 'આ સંસ્કરણને ભાષાંતર માટે ચિહ્નિત કરો',
	'tpt-sections-oldnew' => 'નવાં અને વિદ્યમાન ભાષાંતર એકમો',
	'tpt-sections-deleted' => 'રદ કરાયેલા ભાષાંતર એકમો',
	'tpt-sections-template' => 'ભાષાંતર પાના ઢાંચો',
	'tpt-badtitle' => 'પાનાને અપાયેલું ($1) નામ પ્રમાણભૂત મથાળું નથી',
	'tpt-oldrevision' => '$2 એ પાનાં [[$1]] નું આધુનિક સંસ્કરણ નથી.

ફક્ત આધુનિક સંસ્કરણનેજ ભાષાંતર માટે ચિહ્નિત કરી શકાશે.',
	'tpt-notsuitable' => 'પાનું $1 ભાષાંતર માટે યોગ્ય નથી.

ખાતરી કરો કે તે <nowiki><ભાષાંતર></nowiki> ટેગ અને પ્રમાણભૂત વાક્યરચના ધરાવે છે.',
	'tpt-badsect' => '"$1" એ ભાષાંતર એકમ $2 માટેનું પ્રમાણભૂત નામ નથી.',
	'tpt-mark-summary' => 'આ સંસ્કરણને ભાષાંતર માટે ચિહ્નિત કરાયું',
	'tpt-edit-failed' => 'પાનાં: $1 ને અદ્યતન બનાવી શકાયું નહીં.',
	'tpt-already-marked' => 'આ પાનાનું આધુનિક સંસ્કરણ અગાઉથીજ ભાષાંતર માટે ચિહ્નિત થઇ ચુક્યું છે.',
	'tpt-list-nopages' => 'ન પાનાંઓ ભાષાંતર માટે ચિહ્નિત કરેલા છે કે ન ભાષાંતર માટે ચિહ્નિત થવા તૈયાર છે.',
	'tpt-old-pages' => '{{PLURAL:$1|આ પાનાં|આ પાનાંઓ}}નાં કેટલાક સંસ્કરણ ભાષાંતર માટે ચિહ્નિત કરાયેલા છે.',
	'tpt-new-pages' => '{{PLURAL:$1|આ પાના|આ પાનાઓ}} ભાષાંતર ટેગ શાથેનું લખાણ ધરાવે છે, પરંતુ {{PLURAL:$1|આ પાના|આ પાનાઓ}}નું હાલનું સંસ્કરણ ભાષાંતર માટે ચિહ્નિત કરાયેલ નથી.',
	'tpt-rev-latest' => 'આધુનિકતમ સંસ્કરણ',
	'tpt-rev-old' => 'અગાઉના ચિહ્નિત સંસ્કરણની ભિન્નતા',
	'tpt-rev-mark-new' => 'આ સંસ્કરણને ભાષાંતર માટે ચિહ્નિત કરો',
	'tpt-translate-this' => 'આ પાનાનું ભાષાંતર કરો',
	'translate-tag-translate-link-desc' => 'આ પાનાનું ભાષાંતર કરો',
	'translate-tag-markthis' => 'આ પાનાંને ભાષાંતર માટે ચિહ્નિત કરો',
	'tpt-translation-intro-fuzzy' => 'કાલગ્રસ્ત ભાષાંતરણો આ રીતે ચિહ્નિત થયેલાં.',
	'tpt-languages-legend' => 'અન્ય ભાષાઓ:',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'pagetranslation' => 'תרגום דף',
	'right-pagetranslation' => 'סימון גרסאות של הדפים לתרגום',
	'tpt-desc' => 'הרחבה לתרגום דפי תוכן',
	'tpt-section' => 'יחידת תרגום $1',
	'tpt-section-new' => 'יחידת תרגום חדשה.
שם: $1',
	'tpt-section-deleted' => 'יחידת תרגום $1',
	'tpt-template' => 'תבנית הדף',
	'tpt-templatediff' => 'תבנית הדף שונתה.',
	'tpt-diff-old' => 'הטקסט הקודם',
	'tpt-diff-new' => 'טקסט חדש',
	'tpt-submit' => 'סימון גרסה זו לתרגום',
	'tpt-sections-oldnew' => 'יחידות תרגום חדשות וקיימות',
	'tpt-sections-deleted' => 'יחידות תרגום שנמחקו',
	'tpt-sections-template' => 'תבנית דף תרגום',
	'tpt-badtitle' => 'שם הדף שניתן ($1) אינו כותרת תקינה',
	'tpt-notsuitable' => 'הדף $1 אינו מתאים לתרגום.
אנא ודאו שהוא מכיל תגיות <nowiki><translate></nowiki> ושהתחביר שלו תקין.',
	'tpt-badsect' => 'השם "$1" אינו שם תקין ליחידת התרגום $2.',
	'tpt-mark-summary' => 'גרסה זו סומנה לתרגום',
	'tpt-edit-failed' => 'לא ניתן לעדכן את הדף: $1',
	'tpt-already-marked' => 'הגרסה העדכנית ביותר של דף זה כבר סומנה לתרגום.',
	'tpt-list-nopages' => 'אין דפים המסומנים לתרגום וגם לא דפים המוכנים להיות מסומנים לתרגום.',
	'tpt-rev-latest' => 'הגרסה האחרונה',
	'tpt-rev-old' => 'הבדלים מאז הגרסה האחרונה שסומנה',
	'tpt-rev-mark-new' => 'סימון גרסה זו לתרגום',
	'tpt-translate-this' => 'תרגום דף זה',
	'translate-tag-translate-link-desc' => 'תרגום דף זה',
	'translate-tag-markthis' => 'סימון דף זה לתרגום',
	'translate-tag-hasnew' => 'דף זה מכיל <span class="plainlinks">[$1 שינויים]</span> שאינם מסומנים לתרגום.',
	'tpt-translation-intro-fuzzy' => 'תרגומים שפג תוקפם מסומנים כך.',
	'tpt-languages-legend' => 'שפות אחרות:',
	'tpt-target-page' => 'לא ניתן לעדכן דף זה ידנית.
דף זה הוא תרגום של הדף [[$1]] וניתן לעדכן את התרגום באמצעות [$2 כלי התרגום].',
	'tpt-unknown-page' => 'מרחב שם זה שמור לצורך תרגומי דפי התוכן.
הדף אותו אתם מנסים לערוך אינו תואם לאף דף המסומן לתרגום.',
	'tpt-render-summary' => 'עדכון להתאמת הגרסה החדשה של דף המקור',
	'tpt-download-page' => 'ייצוא דף עם תרגומים',
);

/** Croatian (Hrvatski)
 * @author Ex13
 */
$messages['hr'] = array(
	'translate-tag-translate-link-desc' => 'Prevedi ovu stranicu',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'pagetranslation' => 'Přełožowanje strony',
	'right-pagetranslation' => 'Wersije strony za přełožowanje markěrować',
	'tpt-desc' => 'Rozšěrjenje za přełožowanje wobsahowych stronow',
	'tpt-section' => 'Přełožowanska jednotka $1',
	'tpt-section-new' => 'Nowa přełožowanska jednotka. Mjeno: $1',
	'tpt-section-deleted' => 'Přełožowanska jednotka $1',
	'tpt-template' => 'Předłoha strony',
	'tpt-templatediff' => 'Předłoha strony je so změniła.',
	'tpt-diff-old' => 'Předchadny tekst',
	'tpt-diff-new' => 'Nowy tekst',
	'tpt-submit' => 'Tutu wersiju za přełožowanje markěrować',
	'tpt-sections-oldnew' => 'Nowe a eksistowace přełožowanske jednotki',
	'tpt-sections-deleted' => 'Wušmórnjene přełožowanske jednotki',
	'tpt-sections-template' => 'Předłoha přełožowanskeje strony',
	'tpt-badtitle' => 'Podate mjeno strony ($1) płaćiwy titul njeje',
	'tpt-oldrevision' => '$2 aktualna wersija strony [[$1]] njeje.
Jenož aktualne wersije hodźa so za přełožowanje markěrować.',
	'tpt-notsuitable' => 'Strona $1 za přełožowanje přihódna njeje.
Zaswěsć, zo ma taflički <nowiki><translate></nowiki> a płaćiwu syntaksu.',
	'tpt-saveok' => 'Strona [[$1]] je so za přełožowanje z $2 {{PLURAL:$2|přełožujomnej jednotku|přełožujomnej jednotkomaj|přełožujomnymi jednotkami|přełožujomnymi jednotkami}} markěrowała.
Strona hodźi so nětko <span class="plainlinks">[$3 přełožować]</span>.',
	'tpt-badsect' => '"$1" płaćiwe mjeno za přełožowansku jednotku $2 njeje.',
	'tpt-showpage-intro' => 'Deleka su nowe, eksistowace a wušmórnjene wotrězki nalistowane.
Prjedy hač tutu wersiju za přełožowanje markěruješ, skontroluj, hač změny wotrězkow su miniměrowane, zo by njetrěbne dźěło za přełožowarjow wobešoł.',
	'tpt-mark-summary' => 'Je tutu wersiju za přełožowanje markěrował',
	'tpt-edit-failed' => 'Strona njeda so aktualizować: $1',
	'tpt-already-marked' => 'Akutalna wersija tuteje strony je so hižo za přełožowanje markěrowała.',
	'tpt-list-nopages' => 'Strony njejsu ani za přełožowanje markěrowali ani njejsu hotowe za přełožowanje.',
	'tpt-old-pages' => 'Někajka wersija {{PLURAL:$1|tuteje strony|tuteju stronow|tutych stronow|tutych stronow}} je so za přełožowanje markěrowała.',
	'tpt-new-pages' => '{{PLURAL:$1|Tuta strona wobsahuje|Tutej stronje|Tute strony wobsahuja|Tute strony wobsahuja}} tekst z přełožowanskimi tafličkimi, ale žana wersija {{PLURAL:$1|tuteje strony|tuteju stronow|tutych stronow|tutych stronow}} njeje tuchwilu za přełožowanje markěrowana.',
	'tpt-rev-latest' => 'aktualna wersija',
	'tpt-rev-old' => 'rozdźěl k předchadnej markěrowanej wersiji',
	'tpt-rev-mark-new' => 'tutu wersiju za přełožowanje markěrować',
	'tpt-translate-this' => 'tutu stronu přełožić',
	'translate-tag-translate-link-desc' => 'Tutu stronu přełožić',
	'translate-tag-markthis' => 'Tutu stronu za přełožowanje markěrować',
	'translate-tag-markthisagain' => 'Tuta strona ma <span class="plainlinks">[$1 {{PLURAL:$1|změnu|změnje|změny|změnow}}]</span>, wot toho zo, bu posledni raz <span class="plainlinks">[$2 za přełožowanje markěrowana]</span>.',
	'translate-tag-hasnew' => 'Tuta strona wobsahuje <span class="plainlinks">[$1 {{PLURAL:$1|změna, kotraž njeje markěrowana|změnje, kotrejž njejstej markěrowanej|změny, kotrež njejsu markěrowane|změnow, kotrež njejsu markěrowane}}]</span> za přełožowanje.',
	'tpt-translation-intro' => 'Tuta strona je <span class="plainlinks">[$1 přełožena wersija]</span> strony [[$2]] a $3 % přełožka je dokónčene a přełožk je aktualny.',
	'tpt-translation-intro-fuzzy' => 'Zestarjene přełožki su kaž tutón markěrowane.',
	'tpt-languages-legend' => 'Druhe rěče:',
	'tpt-target-page' => 'Tuta strona njeda so manulenje aktualizować.
Tuta strona je přełožk strony [[$1]] a přełožk hodźi so z pomocu [$2 Přełožić] aktualizować.',
	'tpt-unknown-page' => 'Tutón mjenowy rum je za přełožki wobsahowych stronow wuměnjeny.
Strona, kotruž pospytuješ wobdźěłać, po wšěm zdaću stronje markěrowanej za přełožowanje njewotpowěduje.',
	'tpt-install' => 'Wuwjedź php maintenance/update.php ab webinstalaciju, zo by funkcija přełožowanje stronow zmóžnił.',
	'tpt-render-summary' => 'Aktualizacija po nowej wersiji žórłoweje strony',
	'tpt-download-page' => 'Stronu z přełožkami eksportować',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'pagetranslation' => 'Lap fordítása',
	'right-pagetranslation' => 'Lapok változatainak megjelölése fordítandónak',
	'tpt-desc' => 'Kiterjesztés lapok fordításához',
	'tpt-section' => '$1 fordítási egység',
	'tpt-section-new' => 'Új fordítási egység.
Név: $1',
	'tpt-section-deleted' => '$1 fordítási egység',
	'tpt-template' => 'Lapsablon',
	'tpt-templatediff' => 'A lapsablon megváltozott.',
	'tpt-diff-old' => 'Előző szöveg',
	'tpt-diff-new' => 'Új szöveg',
	'tpt-submit' => 'A változat megjelölése fordításra.',
	'tpt-sections-oldnew' => 'Új és meglevő fordítási egységek',
	'tpt-sections-deleted' => 'Törölt fordítási egységek',
	'tpt-sections-template' => 'Fordítási lapsablonok',
	'tpt-badtitle' => 'A megadott lapnév ($1) nem érvényes cím',
	'tpt-oldrevision' => '$2 nem a(z) [[$1]] lap legutolsó változata.
Csak a legfrissebb változatok jelölhetőek meg fordításra.',
	'tpt-notsuitable' => 'A(z) $1 lap nem alkalmas a fordításra.
Ellenőrizd, hogy szerepelnek-e benne <nowiki><translate></nowiki> tagek, és helyes-e a szintaxisa.',
	'tpt-saveok' => 'A(z) [[$1]] lap $2 fordítási egységgel megjelölve fordításra.
A lap mostantól <span class="plainlinks">[$3 lefordítható]</span>.',
	'tpt-badsect' => '„$1” nem érvényes név a(z) $2 fordítási egységnek.',
	'tpt-showpage-intro' => 'Alább az új, már létező és törölt szakaszok felsorolása látható.
Mielőtt fordításra jelölöd ezt a változatot, ellenőrizd hogy a szakaszok változásai minimálisak, elkerülendő a felesleges munkát a fordítóknak.',
	'tpt-mark-summary' => 'Változat megjelölve fordításra',
	'tpt-edit-failed' => 'Nem sikerült frissíteni a lapot: $1',
	'tpt-already-marked' => 'A lap legutolsó verziója már meg van jelölve fordításra.',
	'tpt-list-nopages' => 'Nincsenek sem fordításra kijelölt, sem kijelölésre kész lapok.',
	'tpt-old-pages' => '{{PLURAL:$1|Ennek a lapnak|Ezeknek a lapoknak}} néhány változata meg van jelölve fordításra.',
	'tpt-new-pages' => '{{PLURAL:$1|Ez a lap tartalmaz|Ezek a lapok tartalmaznak}} fordítási tagekkel ellátott szöveget, de jelenleg egyik {{PLURAL:$1|változata|változatuk}} sincs megjelölve fordításra.',
	'tpt-rev-latest' => 'utolsó változat',
	'tpt-rev-old' => 'eltérés az előző jelölt változathoz képest',
	'tpt-rev-mark-new' => 'ezen változatnak megjelölése fordításra',
	'tpt-translate-this' => 'lap fordítása',
	'translate-tag-translate-link-desc' => 'A lap fordítása',
	'translate-tag-markthis' => 'Lap megjelölése fordításra',
	'translate-tag-markthisagain' => 'Ezen a lapon történtek <span class="plainlinks">[$1 változtatások]</span>, mióta utoljára <span class="plainlinks">[$2 megjelölték fordításra]</span>.',
	'translate-tag-hasnew' => 'Ez a lap tartalmaz <span class="plainlinks">[$1 változtatásokat]</span>, amelyek nincsenek fordításra jelölve.',
	'tpt-translation-intro' => 'Ez a(z) [[$2]] lap egy <span class="plainlinks">[$1 lefordított változata]</span>, és a fordítás $3%-a kész és friss.',
	'tpt-translation-intro-fuzzy' => 'Az elavult fordítások az alábbi módon vannak jelölve.',
	'tpt-languages-legend' => 'Más nyelvek:',
	'tpt-target-page' => 'Ezt a lapot nem lehet kézzel frissíteni.
A(z) [[$1]] lap fordítása, és a fordítását [$2 a fordítás segédeszköz] segítségével lehet frissíteni.',
	'tpt-unknown-page' => 'Ez a névtér a tartalmi lapok fordításainak van fenntartva.
A lap, amit szerkeszteni próbálsz, úgy tűnik hogy nem egyezik egy fordításra jelölt lappal sem.',
	'tpt-install' => 'Futtasd a <code>maintenance/update.php</code>-t vagy a webes telepítőt, hogy engedélyezd a lapfordítás funkciót.',
	'tpt-render-summary' => 'Frissítés, hogy megegyezzen a forráslap új változatával',
	'tpt-download-page' => 'Lap exportálása fordításokkal együtt',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'pagetranslation' => 'Traduction de paginas',
	'right-pagetranslation' => 'Marcar versiones de paginas pro traduction',
	'tpt-desc' => 'Extension pro traducer paginas de contento',
	'tpt-section' => 'Unitate de traduction $1',
	'tpt-section-new' => 'Nove unitate de traduction. Nomine: $1',
	'tpt-section-deleted' => 'Unitate de traduction $1',
	'tpt-template' => 'Patrono de pagina',
	'tpt-templatediff' => 'Le patrono del pagina ha cambiate.',
	'tpt-diff-old' => 'Texto anterior',
	'tpt-diff-new' => 'Texto nove',
	'tpt-submit' => 'Marcar iste version pro traduction',
	'tpt-sections-oldnew' => 'Unitates de traduction nove e existente',
	'tpt-sections-deleted' => 'Unitates de traduction delite',
	'tpt-sections-template' => 'Patrono de pagina de traduction',
	'tpt-badtitle' => 'Le nomine de pagina specificate ($1) non es un titulo valide',
	'tpt-oldrevision' => '$2 non es le version le plus recente del pagina [[$1]].
Solmente le versiones le plus recente pote esser marcate pro traduction.',
	'tpt-notsuitable' => 'Le pagina $1 non es traducibile.
Assecura que illo contine etiquettas <nowiki><translate></nowiki> e ha un syntaxe valide.',
	'tpt-saveok' => 'Le pagina [[$1]] ha essite marcate pro traduction con $2 {{PLURAL:$2|unitate|unitates}} de traduction.
Le pagina pote ora esser <span class="plainlinks">[$3 traducite]</span>.',
	'tpt-badsect' => '"$1" non es un nomine valide pro le unitate de traduction $2.',
	'tpt-showpage-intro' => 'In basso es listate sectiones nove, existente e delite.
Ante de marcar iste version pro traduction, assecura que le modificationes al sectiones sia minimisate pro evitar labor innecessari pro traductores.',
	'tpt-mark-summary' => 'Marcava iste version pro traduction',
	'tpt-edit-failed' => 'Non poteva actualisar le pagina: $1',
	'tpt-already-marked' => 'Le version le plus recente de iste pagina ha jam essite marcate pro traduction.',
	'tpt-list-nopages' => 'Il non ha paginas marcate pro traduction, ni paginas preparate pro isto.',
	'tpt-old-pages' => 'Alcun {{PLURAL:$1|version de iste pagina|versiones de iste paginas}} ha essite marcate pro traduction.',
	'tpt-new-pages' => 'Iste {{PLURAL:$1|pagina|paginas}} contine texto con etiquettas de traduction, ma nulle version de iste {{PLURAL:$1|pagina|paginas}} es actualmente marcate pro traduction.',
	'tpt-rev-latest' => 'ultime version',
	'tpt-rev-old' => 'differentia con previe version marcate',
	'tpt-rev-mark-new' => 'marcar iste version pro traduction',
	'tpt-translate-this' => 'traducer iste pagina',
	'translate-tag-translate-link-desc' => 'Traducer iste pagina',
	'translate-tag-markthis' => 'Marcar iste pagina pro traduction',
	'translate-tag-markthisagain' => 'Iste pagina ha <span class="plainlinks">[$1 modificationes]</span> depost le ultime vice que illo esseva <span class="plainlinks">[$2 marcate pro traduction]</span>.',
	'translate-tag-hasnew' => 'Iste pagina contine <span class="plainlinks">[$1 modificationes]</span> le quales non ha essite marcate pro traduction.',
	'tpt-translation-intro' => 'Iste pagina es un <span class="plainlinks">[$1 version traducite]</span> de un pagina [[$2]] e le traduction es complete e actual a $3%.',
	'tpt-translation-intro-fuzzy' => 'Le traductiones obsolete es marcate assi.',
	'tpt-languages-legend' => 'Altere linguas:',
	'tpt-target-page' => 'Iste pagina non pote esser actualisate manualmente.
Iste pagina es un traduction del pagina [[$1]] e le traduction pote esser actualisate con le [$2 instrumento de traduction].',
	'tpt-unknown-page' => 'Iste spatio de nomines es reservate pro traductiones de paginas de contento.
Le pagina que tu vole modificar non pare corresponder con alcun pagina marcate pro traduction.',
	'tpt-install' => 'Executa maintenance/update.php o le installation web pro activar le traduction de paginas.',
	'tpt-render-summary' => 'Actualisation a un nove version del pagina de origine',
	'tpt-download-page' => 'Exportar pagina con traductiones',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Rex
 */
$messages['id'] = array(
	'pagetranslation' => 'Penerjemahan halaman',
	'right-pagetranslation' => 'Menandai revisi-revisi halaman untuk diterjemahkan',
	'tpt-desc' => 'Ekstensi untuk menerjemahkan halaman-halaman isi',
	'tpt-section' => 'Unit penerjemahan $1',
	'tpt-section-new' => 'Unit penerjemahan baru. Nama: $1',
	'tpt-section-deleted' => 'Unit penerjemahan $1',
	'tpt-template' => 'Templat halaman',
	'tpt-templatediff' => 'Templat halaman telah diubah.',
	'tpt-diff-old' => 'Teks sebelumnya',
	'tpt-diff-new' => 'Teks baru',
	'tpt-submit' => 'Tandai revisi ini untuk diterjemahkan',
	'tpt-sections-oldnew' => 'Unit-unit penerjemahan baru dan yang telah ada',
	'tpt-sections-deleted' => 'Unit penerjemahan yang dihapus',
	'tpt-sections-template' => 'Templat halaman penerjemahan',
	'tpt-badtitle' => 'Nama halaman yang diberikan ($1) tidak valid',
	'tpt-oldrevision' => '$2 bukan revisi terakhir dari halaman [[$1]].
Hanya revisi terakhir yang dapat ditandai untuk diterjemahkan.',
	'tpt-notsuitable' => 'Halaman $1 tidak dapat diterjemahkan.
Pastikan bahwa halaman ini memiliki tag <nowiki><translate></nowiki> dan memiliki sintaksis yang valid.',
	'tpt-saveok' => 'Halaman [[$1]] telah ditandai untuk diterjemahkan dengan $2 {{PLURAL:$2|unit penerjemahan|unit penerjemahan}}.
Halaman ini sekarang dapat <span class="plainlinks"[$3 diterjemahkan]</span>.',
	'tpt-badsect' => '"$1" bukanlah nama yang valid untuk unit penerjemahan $2.',
	'tpt-showpage-intro' => 'Berikut adalah daftar bagian baru, bagian yang telah ada, dan bagian yang dihapus.
Sebelum menandai revisi ini untuk diterjemahkan, harap periksa agar perubahan ke bagian-bagian dapat diminimalisasi guna menghindarkan para penerjemah dari melakukan pekerjaan yang tidak diperlukan.',
	'tpt-mark-summary' => 'Menandai revisi ini untuk diterjemahkan',
	'tpt-edit-failed' => 'Tidak dapat memperbarui halaman: $1',
	'tpt-already-marked' => 'Revisi terakhir halaman ini telah ditandai untuk diterjemahkan.',
	'tpt-list-nopages' => 'Tidak ada halaman yang ditandai untuk diterjemahkan atau siap ditandai untuk diterjemahkan.',
	'tpt-old-pages' => 'Beberapa revisi dari {{PLURAL:$1|halaman ini|halaman-halaman ini}} telah ditandai untuk diterjemahkan.',
	'tpt-new-pages' => '{{PLURAL:$1|Halaman ini berisikan|Halaman-halaman ini berisikan}} teks dengan tag terjemahan, tetapi tidak ada versi {{PLURAL:$1|halaman ini|halaman-halaman ini}} yang sudah ditandai untuk diterjemahkan.',
	'tpt-rev-latest' => 'revisi terakhir',
	'tpt-rev-old' => 'beda dengan revisi terakhir yang ditandai',
	'tpt-rev-mark-new' => 'tandai revisi ini untuk diterjemahkan',
	'tpt-translate-this' => 'terjemahkan halaman ini',
	'translate-tag-translate-link-desc' => 'Terjemahkan halaman ini',
	'translate-tag-markthis' => 'Tandai halaman ini untuk diterjemahkan',
	'translate-tag-markthisagain' => 'Halaman ini telah diubah <span class="plainlinks">[$1 kali]</span> sejak terakhir <span class="plainlinks">[$2 ditandai untuk diterjemahkan]</span>.',
	'translate-tag-hasnew' => 'Halaman ini berisikan <span class="plainlinks">[$1 revisi]</span> yang tidak ditandai untuk diterjemahkan.',
	'tpt-translation-intro' => 'Halaman ini adalah sebuah <span class="plainlinks">[$1 versi terjemahan]</span> dari halaman [[$2]] dan terjemahannya telah selesai $3% dari sumber terkini.',
	'tpt-translation-intro-fuzzy' => 'Terjemahan usang ditandai seperti ini.',
	'tpt-languages-legend' => 'Bahasa lain:',
	'tpt-target-page' => 'Halaman ini tidak dapat diperbarui secara manual.
Halaman ini adalah terjemahan dari halaman [[$1]] dan terjemahannya dapat diperbarui menggunakan [$2 peralatan penerjemahan].',
	'tpt-unknown-page' => 'Ruang nama ini dicadangkan untuk terjemahan halaman isi.
Halaman yang ingin Anda sunting ini tampaknya tidak memiliki hubungan dengan halaman manapun yang ditandai untuk diterjemahkan.',
	'tpt-install' => 'Jalankan php maintenance/update.php atau instalasi web untuk mengaktifkan fitur terjemahan halaman.',
	'tpt-render-summary' => 'Memperbarui ke revisi terbaru halaman sumber',
	'tpt-download-page' => 'Ekspor halaman dengan terjemahan',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'pagetranslation' => 'Ihü kuwariala na asụsụ ozor',
	'tpt-diff-new' => 'Mpkurụ edemede ohúrù',
	'tpt-languages-legend' => 'Asụsụ ndi ozor:',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'pagetranslation' => 'Traduzione pagine',
	'right-pagetranslation' => 'Segna versione di pagine per la traduzione',
	'tpt-desc' => 'Estensione per la traduzione di pagine di contenuti',
	'tpt-diff-old' => 'Testo precedente',
	'tpt-diff-new' => 'Testo successivo',
	'tpt-submit' => 'Segna questa versione per la traduzione',
	'tpt-badtitle' => 'Il nome fornito per la pagina ($1) non è un titolo valido',
	'tpt-oldrevision' => "$2 non è l'ultima versione della pagina [[$1]].
Solo le ultime versioni possono essere segnate per la traduzione.",
	'tpt-notsuitable' => 'La pagina $1 non è adatta per la traduzione.
Assicurarsi che abbia i tag <nowiki><translate></nowiki> e una sintassi valida.',
	'tpt-showpage-intro' => 'Di seguito sono elencate le sezioni nuove, esistenti e cancellate.
Prima di segnare questa versione per la traduzione, controllare che i cambiamenti per le sezioni siano ridotti al minimo per evitare lavoro non necessario ai traduttori.',
	'tpt-edit-failed' => 'Impossibile aggiornare la pagina: $1',
	'tpt-already-marked' => "L'ultima versione di questa pagina è già stata segnata per la traduzione.",
	'tpt-list-nopages' => 'Nessuna pagina è segnata per la traduzione oppure è pronta per essere segnata per la traduzione.',
	'tpt-old-pages' => 'Alcune versioni di {{PLURAL:$1|questa pagina|queste pagine}} sono state segnate per la traduzione.',
	'translate-tag-translate-link-desc' => 'Traduci questa pagina',
	'tpt-languages-legend' => 'Altre lingue:',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'pagetranslation' => 'ページ翻訳',
	'right-pagetranslation' => 'ページの版を翻訳対象に指定する',
	'tpt-desc' => 'コンテンツページの翻訳のための拡張機能',
	'tpt-section' => '翻訳単位 $1',
	'tpt-section-new' => '新規翻訳単位。名前: $1',
	'tpt-section-deleted' => '翻訳単位 $1',
	'tpt-template' => 'ページの雛型',
	'tpt-templatediff' => 'このページの雛型が変更されました。',
	'tpt-diff-old' => '前のテキスト',
	'tpt-diff-new' => '新しいテキスト',
	'tpt-submit' => 'この版を翻訳対象に指定する',
	'tpt-sections-oldnew' => '新規および既存の翻訳単位',
	'tpt-sections-deleted' => '削除された翻訳単位',
	'tpt-sections-template' => '翻訳ページの雛型',
	'tpt-badtitle' => '指定したページ名 ($1) は無効なタイトルです',
	'tpt-oldrevision' => '$2 はページ [[$1]] の最新版ではありません。翻訳対象に指定できるのは最新版のみです。',
	'tpt-notsuitable' => 'ページ $1 は翻訳に対応していません。<nowiki><translate></nowiki>が含まれていること、またマークアップが正しいことを確認してください。',
	'tpt-saveok' => 'ページ [[$1]] は翻訳対象に指定されており、$2{{PLURAL:$2|個}}の翻訳単位を含んでいます。このページを<span class="plainlinks">[$3 翻訳]</span>することができます。',
	'tpt-badsect' => '「$1」は翻訳単位 $2 の名前として無効です。',
	'tpt-showpage-intro' => '以下には新しいセクション、既存のセクション、そして削除されたセクションが一覧されています。この版を翻訳対象に指定する前に、セクションの変更を最小限にすることで不要な翻訳作業を回避できないか確認してください。',
	'tpt-mark-summary' => 'この版を翻訳対象に指定しました',
	'tpt-edit-failed' => 'ページを更新できませんでした: $1',
	'tpt-already-marked' => 'このページの最新版がすでに翻訳対象に指定されています。',
	'tpt-list-nopages' => '翻訳対象に指定されたページがない、または翻訳対象に指定する準備ができているページがありません。',
	'tpt-old-pages' => '{{PLURAL:$1|これらの|この}}ページには翻訳対象に指定された版があります。',
	'tpt-new-pages' => '{{PLURAL:$1|以下のページ}}は本文に翻訳タグを含んでいますが、翻訳対象に指定されている版が{{PLURAL:$1|ありません}}。',
	'tpt-rev-latest' => '最新版',
	'tpt-rev-old' => '以前に翻訳指定された版との差分',
	'tpt-rev-mark-new' => 'この版を翻訳対象に指定する',
	'tpt-translate-this' => 'このページを翻訳する',
	'translate-tag-translate-link-desc' => 'このページを翻訳する',
	'translate-tag-markthis' => 'このページを翻訳対象に指定する',
	'translate-tag-markthisagain' => 'このページには最後に<span class="plainlinks">[$2 翻訳が指定]</span>されて以降の<span class="plainlinks">[$1 変更]</span>があります。',
	'translate-tag-hasnew' => 'このページには翻訳対象に指定されていない<span class="plainlinks">[$1 変更]</span>があります。',
	'tpt-translation-intro' => 'このページはページ [[$2]] の<span class="plainlinks">[$1 翻訳版]</span> です。翻訳は $3% 完了しており、最新の状態を反映しています。',
	'tpt-translation-intro-fuzzy' => '古くなった翻訳はこのような印が付いています。',
	'tpt-languages-legend' => '他言語での翻訳:',
	'tpt-target-page' => 'このページは手動で更新できません。このページはページ [[$1]] の翻訳で、[$2 翻訳ツール]を使用して更新します。',
	'tpt-unknown-page' => 'この名前空間はコンテンツページの翻訳のために使用します。あなたが編集しようとしているページに対応する翻訳対象ページが存在しないようです。',
	'tpt-install' => 'ページ翻訳機能を有効にするために、php maintenance/update.php またはウェブ・インストーラーを実行する。',
	'tpt-render-summary' => '翻訳元ページの新版に適合するように更新中',
	'tpt-download-page' => '翻訳付きでページを書き出し',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'translate-tag-translate-link-desc' => 'Terjemahaké kaca iki',
);

/** Georgian (ქართული)
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'tpt-diff-new' => 'ახალი ტექსტი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'pagetranslation' => 'ការ​បក​ប្រែ​ទំព័រ​',
	'tpt-section' => 'ឯកតាបកប្រែ $1',
	'tpt-section-new' => 'ឯកតាបកប្រែថ្មី។
ឈ្មោះ៖ $1',
	'tpt-section-deleted' => 'ឯកតាបកប្រែ $1',
	'tpt-template' => 'គំរូទំព័រ',
	'tpt-templatediff' => 'គំរូ​ទំព័រ​បានផ្លាស់ប្តូរ​។',
	'tpt-diff-old' => 'អត្ថបទ​​ពីមុន​',
	'tpt-diff-new' => 'អត្ថបទ​ថ្មី​',
	'tpt-submit' => 'សម្គាល់​កំណែ​នេះ​សម្រាប់​ការបកប្រែ​',
	'tpt-sections-oldnew' => 'ឯកតាបកប្រែថ្មីនិងចាស់',
	'tpt-sections-deleted' => 'ឯកតាបកប្រែដែលត្រូវបានលុប',
	'tpt-sections-template' => 'គំរូ​ទំព័រ​បកប្រែ​',
	'tpt-badtitle' => 'ឈ្មោះ​ទំព័រ​សម្រាប់ ($1) គឺមិនមែន​ជា​ចំនងជើង​ត្រឹមត្រូវ​',
	'tpt-mark-summary' => 'បាន​សម្គាល់​កំណែ​នេះ​សម្រាប់​បកប្រែ​',
	'tpt-edit-failed' => 'មិនអាច​បន្ទាន់សម័យ​ទំព័រ​៖ $1',
	'tpt-already-marked' => 'កំណែ​ចុងក្រោយ​នៃទំព័រ​នេះ​ត្រូវបាន​សម្គាល់​ទុកសម្រាប់​បកប្រែ​។',
	'tpt-rev-latest' => 'កំណែ (version) ចុង​ក្រោយ​គេ​',
	'tpt-rev-mark-new' => 'សម្គាល់កំណែ​នេះសម្រាប់បកប្រែ​',
	'tpt-translate-this' => 'បកប្រែទំព័រនេះ',
	'translate-tag-translate-link-desc' => 'បកប្រែទំព័រនេះ',
	'translate-tag-markthis' => 'សម្គាល់​ទំព័រ​​នេះ​សម្រាប់​ការបកប្រែ​',
	'tpt-languages-legend' => 'ជាភាសាដទៃទៀត៖',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'translate-tag-translate-link-desc' => '이 문서 번역하기',
	'tpt-languages-legend' => '다른 언어:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'pagetranslation' => 'Sigge Övversäze',
	'right-pagetranslation' => 'Donn Versione vun Sigge för et Övversäze makeere',
	'tpt-desc' => 'Projrammzohsatz för Sigge vum Enhalt vum Wiki ze övversäze.',
	'tpt-section' => 'Knubbel $1 för ze Övversäze',
	'tpt-section-new' => 'Ene neue Knubbel för ze Övversäze: $1',
	'tpt-section-deleted' => 'Knubbel $1 för ze Övversäze',
	'tpt-template' => 'Siggeschabloon',
	'tpt-templatediff' => 'De Siggeschabloon hät sesch jeändert.',
	'tpt-diff-old' => 'Dä vörrijje Täx',
	'tpt-diff-new' => 'Dä neue Täx',
	'tpt-submit' => 'Donn hee di Version för et Övversäze makeere',
	'tpt-sections-oldnew' => 'De Knubbelle för ze Övversäze (Jez neu, un de älldere, zosamme)',
	'tpt-sections-deleted' => 'Fottjeschmeße Knubbelle för et Övversäze',
	'tpt-sections-template' => 'Övversäzungßsiggschabloon',
	'tpt-badtitle' => 'Dä Name „$1“ es keine jöltijje Tittel för en Sigg',
	'tpt-oldrevision' => '„$2“ es nit de neuste Version fun dä Sigg „[[$1]]“, ävver bloß de neuste kam_mer för et Övversäze makeere.',
	'tpt-notsuitable' => 'Di Sigg „$1“ paß nit för et Övversäze. Maach <code><nowiki><translate></nowiki></code>-Makeerunge erin, un looer dat de Süntax shtemmp.',
	'tpt-saveok' => 'De Sigg „$1“ es för ze Övversäze makeet. Doh dren {{PLURAL:$2|es eine Knubbel|sinn_er $2 Knubbelle|es ävver keine Knubbel}} för ze Övversäze. Di Sigg kam_mer <span class="plainlinks">[$3 jäz övversäze]</span>.',
	'tpt-badsect' => '„$1“ es kein jöltejje Name för dä Knubbel zom Övversäze $2.',
	'tpt-showpage-intro' => 'Hee dronger sin Afschnedde opjeleß, di eruß jenumme woode, un di noch doh sin. Ih dat De hee di Version för ze Övversäze makeere deihß, loor drop, dat esu winnisch wi müjjelesch Änderonge aan Afschnedde doh sin, öm dä Övversäzere et Levve leisch ze maache.',
	'tpt-mark-summary' => 'Han di Version för ze Övversäze makeet',
	'tpt-edit-failed' => 'Kunnt de Sigg „$1“ nit ändere',
	'tpt-already-marked' => 'De neuste Version vun dä Sigg es ald för zem Övversäze makeet.',
	'tpt-list-nopages' => 'Et sinn_er kein Sigge för zem Övversäze makeet, un et sin och kein doh, wo esu en Makeerunge eren künnte.',
	'tpt-old-pages' => 'En Version vun hee dä {{PLURAL:$1|Sigg|Sigge|-}} es för zem Övversäze makeet.',
	'tpt-new-pages' => '{{PLURAL:$1|Di Sigg hät|Di Sigge han|Kein Sigg hät}} ene <code lang="en">translation</code>-Befähl en sesch, ävve kei Version dofun es för ze Övversäze makeet.',
	'tpt-rev-latest' => 'Neuste Version',
	'tpt-rev-old' => 'Ongerscheid zor vörijje makeete Version',
	'tpt-rev-mark-new' => 'donn di Version för et Övversäze makeere',
	'tpt-translate-this' => 'donn di Sigg övversäze',
	'translate-tag-translate-link-desc' => 'Don di Sigg hee övversäze',
	'translate-tag-markthis' => 'Donn hee di Sigg för et Övversäze makeere',
	'translate-tag-markthisagain' => 'Hee di Sigg es <span class="plainlinks">[$1 jeändert woode]</span> zick se et läz <span class="plainlinks">[$2 för ze Övversäze]</span> makeet woode es.',
	'translate-tag-hasnew' => 'Hee di Sigg <span class="plainlinks">[$1 es jeändert woode]</span>, es ävver nit för ze Övversäze makeet woode.',
	'tpt-translation-intro' => 'Hee di Sigg es en <span class="plainlinks">[$1 övversaz Version]</span> vun dä Sigg „[[$2]]“ un es zoh $3% jedonn un om aktoälle Shtandt.',
	'tpt-translation-intro-fuzzy' => 'Övverhollte Övversäzunge wäde su makeet, wi hee dä Täx.',
	'tpt-languages-legend' => 'Ander Shprooche:',
	'tpt-target-page' => 'Hee di Sigg kam_mer nit vun Hand ändere. Dat hee es en Översäzungß_Sigg vun dä Sigg [[$1]]. De Övversäzung kam_mer övver däm Wiki sing [$2 Övversäzungß_Wärkzüsch] op der neußte Shtand bränge.',
	'tpt-unknown-page' => 'Dat Appachtemang hee es för Sigge vum Enhallt vum Wiki ze Övversäze jedaach. Di Sigg, di de jraad ze ändere versöhks, schingk ävver nit met ööhnds en Sigg ze donn ze han, di för zem Övversäze makeet es.',
	'tpt-install' => 'Lohß op Dingem Wiki singem ßööver dat Skrip <code>php maintenance/update.php</code> loufe, udder schmiiß dat Enreeschdungsprojramm övver et Web aan, öm de Müjjeleschkeit för Sigge ze övversäze en däm Wiki aan et Loufe ze bränge.',
	'tpt-render-summary' => 'Ändere, öm op de neue Version fun de Ojinaal_Sigg ze kumme',
	'tpt-download-page' => 'Sigge met Övversäzunge expotteere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'pagetranslation' => 'Iwwersetzung vun der Säit',
	'right-pagetranslation' => 'Versioune vu Säite fir Iwwersetzung markéieren',
	'tpt-desc' => "Erweiderung fir ihaltlech Säiten z'iwwersetzen",
	'tpt-section' => 'Iwwersetzungseenheet $1',
	'tpt-section-new' => 'Numm: $1',
	'tpt-section-deleted' => 'Iwwersetzungseenheet $1',
	'tpt-template' => 'Säiteschabloun',
	'tpt-templatediff' => "D'Säiteschabloun gouf geännert.",
	'tpt-diff-old' => 'Viregen Text',
	'tpt-diff-new' => 'Neien Text',
	'tpt-submit' => "Dës Versioun fir d'Iwwersetze markéieren",
	'tpt-sections-oldnew' => 'Nei an Iwwersetzungseeenheeten déi et scho gëtt',
	'tpt-sections-deleted' => 'Geläschten Iwwersetzungseenheeten',
	'tpt-sections-template' => 'Iwwersetzung Säiteschabloun',
	'tpt-badtitle' => 'De Säitennumm deen ugi gouf ($1) ass kee valabelen Titel',
	'tpt-oldrevision' => "$2 ass net déi lescht Versioun vun der Säit [[$1]].
Nëmmen déi lescht Versioune kënne fir d'Iwwersetzung markéiert ginn.",
	'tpt-notsuitable' => "D'Säit $1 ass net geeegent fir iwwersat ze ginn.
Vergewëssert Iech ob se <nowiki><translate></nowiki>-Taggen  an eng valabel Syntax huet.",
	'tpt-saveok' => 'D\'Säit [[$1]] gouf fir d\'Iwwersetzung mat $2 {{PLURAL:$2|Iwwersetzungseenheet|Iwwersetzungseenheete}} markéiert.
D\'Säit kann elo <span class="plainlinks">[$3 iwwersat]</span> ginn.',
	'tpt-badsect' => '"$1" ass kee valbelen Numm fir d\'Iwwersetzungseenheet $2.',
	'tpt-showpage-intro' => "Ënnendrënner stinn déi nei, aktuell a gescläschten Abschnitter.
Ier dir dës Versioun fir d'iwwersetze markéiert, kuckt w.e.g. no datt d'Ännerunge vun den Abschnitter op e Minimum reduzéiert gi fir onnëtz Aarbecht vun den Iwwersezer ze vermeiden.",
	'tpt-mark-summary' => "huet dës Versioun fir d'Iwwersetzung markéiert",
	'tpt-edit-failed' => "D'Säit $1 konnt net aktualiséiert ginn",
	'tpt-already-marked' => "Déilescht Versioun vun dëser Säit gouf scho fir d'Iwwersetzung markéiert.",
	'tpt-list-nopages' => "Et si keng Säite fir d'Iwwersetzung markéiert respektiv fäerdeg fir fir d'Iwersetzung markéiert ze ginn.",
	'tpt-old-pages' => "Eng Versioun vun {{PLURAL:$1|dëser Säit|dëse Säite}} gouf fir d'Iwwersetze markéiert.",
	'tpt-new-pages' => "Op {{PLURAL:$1|dëser Säit|dëse Säiten}} ass Text mat Iwwersetzungs-Markéierungen, awer keng Versioun vun {{PLURAL:$1|dëser Säit|dëse Säiten}} ass elo fir d'Iwwersetze  markéiert.",
	'tpt-rev-latest' => 'lescht Versioun',
	'tpt-rev-old' => 'Ënnerscheed zu der vireger markéierter Versioun',
	'tpt-rev-mark-new' => "dës Versioun fir d'Iwwersetzung markéieren",
	'tpt-translate-this' => 'dës Säit iwwersetzen',
	'translate-tag-translate-link-desc' => 'Dës Säit iwwersetzen',
	'translate-tag-markthis' => "Dës Säit fir d'Iwwersetzung markéieren",
	'translate-tag-markthisagain' => 'Dës Säit huet <span class="plainlinks">[$1 Ännerungen]</span> zënter datt se fir d\'lescht <span class="plainlinks">[$2 fir d\'Iwwersetzung markéiert gouf]</span>.',
	'translate-tag-hasnew' => 'Op dëser Säit si(nn)s <span class="plainlinks">[$1 Ännerungen]</span> déi net fir d\'iwwersetzung markéiert sinn.',
	'tpt-translation-intro' => 'Dës Säit ass eng <span class="plainlinks">[$1 iwwersate Versioun]</span> vun der Säit [[$2]] an d\'Iwweersetzung ass zu $3 % ofgeschloss an aktuell.',
	'tpt-translation-intro-fuzzy' => 'Net aktuell Iwwersetzunge sinn esou markéiert.',
	'tpt-languages-legend' => 'aner Sproochen:',
	'tpt-target-page' => "Dës Säit kann net manuell aktualiséiert ginn.
Dës Säit ass eng Iwwersetzung vun der Säit [[$1]] an d'Iwwersetzung ka mat Hëllef vun der [$2 Iwwersetzungs-Fonctioun] aktulaiséiert ginn.",
	'tpt-unknown-page' => "Dëse Nummraum ass fir d'Iwwersetze vu Säitemat Inhalt reservéiert.
D'Säit, déi Dir versicht z'änneren schéngt net mat enger Säit déi fir d'iwwersetzung markéiert ass ze korrespondéieren.",
	'tpt-install' => "Lancéiert php maintenance/update.php oder web install fir d'Fonctioun vun der Säiteniwwersetzung anzeschalten.",
	'tpt-render-summary' => 'Aktualiséieren fir mat der neier Versioun vun der Quellsäit iwwereneenzestëmmen',
	'tpt-download-page' => 'Säit mat Iwwersetzungen exportéieren',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'right-pagetranslation' => 'Mamamarika ny santiônam-pejy hodikaina',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'pagetranslation' => 'Превод на страница',
	'right-pagetranslation' => 'Обележување на верзии на страници за преведување',
	'tpt-desc' => 'Проширување за преведување на страници со содржини',
	'tpt-section' => 'Преводна единица $1',
	'tpt-section-new' => 'Нова преводна единица.
Назив: $1',
	'tpt-section-deleted' => 'Преводна единица $1',
	'tpt-template' => 'Шаблон за страница',
	'tpt-templatediff' => 'Шаблонот за страницата е променет.',
	'tpt-diff-old' => 'Претходен текст.',
	'tpt-diff-new' => 'Нов текст',
	'tpt-submit' => 'Обележи ја оваа верзија на преводот',
	'tpt-sections-oldnew' => 'Нови и постоечки преводни единици',
	'tpt-sections-deleted' => 'Избришани преводни едници',
	'tpt-sections-template' => 'Шаблон за страница за превод',
	'tpt-badtitle' => 'Даденото име на страницата ($1) е погрешен наслов',
	'tpt-oldrevision' => '$2 не е најнова верзија на страницата [[$1]].
Само најновите верзии можат да се обележуваат за преведување.',
	'tpt-notsuitable' => 'Страницата $1 не е погодна за преведување.
Проверете дали има ознаки <nowiki><translate></nowiki> и дали има правилна синтакса.',
	'tpt-saveok' => 'Оваа страница [[$1]] е обележана за преведување со $2 {{PLURAL:$2|преводна единица|преводни единици}}.
Страницата сега може да се <span class="plainlinks">[$3 преведува]</span>.',
	'tpt-badsect' => '„$1“ е погрешно име за преводната единица $2.',
	'tpt-showpage-intro' => 'Подолу не наведени нови, постоечки и избришани пасуси делови.
Пред да ја обележите оваа верзија за преведување, проверете дали промените во деловите се сведени на минимум со што би се избегнала непотреба работа за преведувачите.',
	'tpt-mark-summary' => 'Ја означувам оваа верзија за преведување',
	'tpt-edit-failed' => 'Не можев да ја обновам страницата: $1',
	'tpt-already-marked' => 'Најновата верзија на оваа страница е веќе обележана за преведување.',
	'tpt-list-nopages' => 'Нема пораки обележани за преведување, ниту страници готови за обележување за да бидат преведени.',
	'tpt-old-pages' => 'Извесна верзија на {{PLURAL:$1|оваа страница|овие страници}} е обележана за преведување.',
	'tpt-new-pages' => '{{PLURAL:$1|Оваа страница содржи|Овие страници содржат}} текст со ознаки за преведување, но моментално нема верзија на {{PLURAL:$1|оваа страница|овие страници}} која е обележана за преведување.',
	'tpt-rev-latest' => 'најнова верзија',
	'tpt-rev-old' => 'разлики со претходната обележана верзија',
	'tpt-rev-mark-new' => 'обележи ја оваа верзија за преведување',
	'tpt-translate-this' => 'преведете ја страницава',
	'translate-tag-translate-link-desc' => 'Преведи ја оваа страница',
	'translate-tag-markthis' => "Обележи ја оваа страница со 'за преведување'",
	'translate-tag-markthisagain' => 'Оваа страница има <span class="plainlinks">[$1 промени]</span> од последниот пат кога <span class="plainlinks">[$2 обележана за преведување]</span>.',
	'translate-tag-hasnew' => 'Оваа страница содржи <span class="plainlinks">[$1 промени]</span> кои не се обележани за преведување.',
	'tpt-translation-intro' => 'Оваа страница е <span class="plainlinks">[$1 преведена верзија]</span> на страницата [[$2]], а преводот е $3% потполн и тековен.',
	'tpt-translation-intro-fuzzy' => 'Застарените преводи се обележуваат вака.',
	'tpt-languages-legend' => 'Други јазици:',
	'tpt-target-page' => 'Оваа страница не може да се обнови рачно.
Оваа страница е превод на страницата [[$1]] а преводот може да се обнови со помош на [$2 the алатката за преведување].',
	'tpt-unknown-page' => 'Овој именски простор е резервиран за преводи на содржински страници.
Страницата која се обидувате да ја уредите не соодветствува со ниедна страница обележана за преведување.',
	'tpt-install' => 'Пуштете го php maintenance/update.php или интернет-инсталација за да ја добиете можноста за преведување страници.',
	'tpt-render-summary' => 'Обнова за усогласување со новата верзија на изворната страница',
	'tpt-download-page' => 'Извези страница со преводи',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'tpt-diff-old' => 'Икелень текст',
	'tpt-diff-new' => 'Од текст',
	'translate-tag-translate-link-desc' => 'Йутавтык те лопанть',
	'tpt-languages-legend' => 'Лия кельтне:',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'translate-tag-translate-link-desc' => 'Tictlahtōlcuepāz inīn zāzanilli',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'pagetranslation' => 'Paginavertaling',
	'right-pagetranslation' => "Versies van pagina's voor de vertaling markeren",
	'tpt-desc' => "Uitbreiding voor het vertalen van wikipagina's",
	'tpt-section' => 'Vertaaleenheid $1',
	'tpt-section-new' => 'Nieuwe vertaaleenheid.
Naam: $1',
	'tpt-section-deleted' => 'Vertaaleenheid $1',
	'tpt-template' => 'Paginasjabloon',
	'tpt-templatediff' => 'Het paginasjabloon is gewijzigd.',
	'tpt-diff-old' => 'Vorige tekst',
	'tpt-diff-new' => 'Nieuwe tekst',
	'tpt-submit' => 'Deze versie voor vertaling markeren',
	'tpt-sections-oldnew' => 'Nieuwe en bestaande vertaaleenheden',
	'tpt-sections-deleted' => 'Verwijderde vertaaleenheden',
	'tpt-sections-template' => 'Vertaalpaginasjabloon',
	'tpt-badtitle' => 'De opgegeven paginanaam ($1) is geen geldige paginanaam',
	'tpt-oldrevision' => '$2 is niet de meest recente versie van de pagina "[[$1]]".
Alleen de meest recente versie kan voor vertaling gemarkeerd worden.',
	'tpt-notsuitable' => 'De pagina "$1" kan niet voor vertaling gemarkeerd worden.
Zorg ervoor dat de labels <nowiki><translate></nowiki> geplaatst zijn en dat deze juist zijn toegevoegd.',
	'tpt-saveok' => 'De pagina [[$1]] is gemarkeerd voor vertaling met $2 te vertalen {{PLURAL:$2|vertaaleenheid|vertaaleenheden}}.
De pagina kan nu  <span class="plainlinks">[$3 vertaald]</span> worden.',
	'tpt-badsect' => '"$1" is geen geldige naam voor vertaaleenheid $2.',
	'tpt-showpage-intro' => 'Hieronder zijn nieuwe, bestaande en verwijderde secties opgenomen.
Controleer voordat u deze versie voor vertaling markeert of de wijzigingen aan de secties zo klein mogelijk zijn om onnodig werk voor vertalers te voorkomen.',
	'tpt-mark-summary' => 'Heeft deze versie voor vertaling gemarkeerd',
	'tpt-edit-failed' => 'De pagina "$1" kon niet bijgewerkt worden.',
	'tpt-already-marked' => 'De meest recente versie van deze pagina is al gemarkeerd voor vertaling.',
	'tpt-list-nopages' => "Er zijn geen pagina's gemarkeerd voor vertaling, noch klaar om gemarkeerd te worden voor vertaling.",
	'tpt-old-pages' => "Er is al een versie van deze {{PLURAL:$1|pagina|pagina's}} gemarkeerd voor vertaling.",
	'tpt-new-pages' => "Deze {{PLURAL:$1|pagina bevat|pagina's bevatten}} tekst met vertalingslabels, maar van deze {{PLURAL:$1|pagina|pagina's}} is geen versie gemarkeerd voor vertaling.",
	'tpt-rev-latest' => 'meest recente versie',
	'tpt-rev-old' => 'verschil met de vorige gemarkeerde versie',
	'tpt-rev-mark-new' => 'deze versie voor vertaling markeren',
	'tpt-translate-this' => 'deze pagina vertalen',
	'translate-tag-translate-link-desc' => 'Deze pagina vertalen',
	'translate-tag-markthis' => 'Deze pagina voor vertaling markeren',
	'translate-tag-markthisagain' => 'Deze pagina is <span class="plainlinks">[$1 gewijzigd]</span> sinds deze voor het laatst <span class="plainlinks">[$2 voor vertaling gemarkeerd]</span> is geweest.',
	'translate-tag-hasnew' => 'Aan deze pagina zijn <span class="plainlinks">[$1 wijzigingen]</span> gemaakt die niet voor vertaling zijn gemarkeerd.',
	'tpt-translation-intro' => 'Deze pagina is een <span class="plainlinks">[$1 vertaalde versie]</span> van de pagina [[$2]] en de vertaling is $3% compleet en bijgewerkt.',
	'tpt-translation-intro-fuzzy' => 'Verouderde vertaling worden zo weergegeven.',
	'tpt-languages-legend' => 'Andere talen:',
	'tpt-target-page' => 'Deze pagina kan niet handmatig worden bijgewerkt.
Deze pagina is een vertaling van de pagina [[$1]].
De vertaling kan bijgewerkt worden via de [$2 vertaalhulpmiddelen].',
	'tpt-unknown-page' => "Deze naamruimte is gereserveerd voor de vertalingen van van pagina's.
De pagina die u probeert te bewerken lijkt niet overeen te komen met een te vertalen pagina.",
	'tpt-install' => 'Voer php maintenance/update.php of de webinstallatie uit om de paginavertaling te activeren.',
	'tpt-render-summary' => 'Bijgewerkt vanwege een nieuwe basisversie van de bronpagina',
	'tpt-download-page' => 'Pagina met vertalingen exporteren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Frokor
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'pagetranslation' => 'Sideomsetjing',
	'right-pagetranslation' => 'Merk versjonar av sider for omsetjing',
	'tpt-desc' => 'Utviding for omsetjing av innhaldssider',
	'tpt-section' => 'Omsetjingseining $1',
	'tpt-section-new' => 'Ny omsetjingseining. Namn: $1',
	'tpt-section-deleted' => 'Omsetjingseining $1',
	'tpt-template' => 'Sidemal',
	'tpt-templatediff' => 'Sidemalen har vorte endra.',
	'tpt-diff-old' => 'Førre tekst',
	'tpt-diff-new' => 'Ny tekst',
	'tpt-submit' => 'Merk denne versjonen for omsetjing',
	'tpt-sections-oldnew' => 'Nye og eksisterande omsetjingseiningar',
	'tpt-sections-deleted' => 'Sletta omsetjingseiningar',
	'tpt-sections-template' => 'Mal for omsetjingsside',
	'tpt-badtitle' => 'Det gjevne sidenamnet ($1) er ikkje ein gyldig tittel',
	'tpt-oldrevision' => '$2 er ikkje den siste versjonen av sida [[$1]].
Berre siste versjonar kan verta markert for omsetjing.',
	'tpt-notsuitable' => 'Side $1 er ikkje høveleg for omsetjing.
Sjekk at sida er merka med <nowiki><translate></nowiki> merke og har ein gyldig syntaks.',
	'tpt-saveok' => 'Sida [[$1]] er vorten merkt for omsetjing med {{PLURAL:$2|éi omsetjingseining|$2 omsetjingseiningar}}. Ho kan no verta <span class="plainlinks">[$3 sett om]</span>.',
	'tpt-badsect' => '«$1» er ikkje eit gyldig namn for omsetjingseininga $2.',
	'tpt-mark-summary' => 'Markerte denne versjonen for omsetjing',
	'tpt-edit-failed' => 'Kunne ikkje oppdatera sida: $1',
	'tpt-already-marked' => 'Den siste versjonen av denne sida har allereie vorte markert for omsetjing.',
	'tpt-list-nopages' => 'Ingen sider er markerte for omsetjing, eller klar til å verta markert for omsetjing.',
	'tpt-old-pages' => 'Ein versjon av {{PLURAL:$1|denne sida|desse sidene}} er vorten merkt for omsetjing.',
	'tpt-rev-latest' => 'siste versjon',
	'tpt-rev-old' => 'skilnad frå den førre markerte versjonen',
	'tpt-rev-mark-new' => 'marker denne versjonen for omsetjing',
	'tpt-translate-this' => 'set om denne sida',
	'translate-tag-translate-link-desc' => 'Set om denne sida',
	'translate-tag-markthis' => 'Merk denne sida for omsetjing',
	'tpt-translation-intro-fuzzy' => 'Utdaterte omsetjingar er markerte på dette viset.',
	'tpt-languages-legend' => 'Andre språk:',
	'tpt-render-summary' => 'Oppdatering for å svara til ny versjon av kjeldesida',
	'tpt-download-page' => 'Eksporter side med omsetjingar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'pagetranslation' => 'Sideoversetting',
	'right-pagetranslation' => 'Merk versjoner av sider for oversettelse',
	'tpt-desc' => 'Utvidelse for oversetting av innholdssider',
	'tpt-section' => 'Oversettelsesenhet $1',
	'tpt-section-new' => 'Ny oversettelsesenhet. Navn: $1',
	'tpt-section-deleted' => 'Oversettelsesenhet $1',
	'tpt-template' => 'Sidemal',
	'tpt-templatediff' => 'Sidemalen har blitt endret.',
	'tpt-diff-old' => 'Forrige tekst',
	'tpt-diff-new' => 'Ny tekst',
	'tpt-submit' => 'Marker denne versjonen for oversetting',
	'tpt-sections-oldnew' => 'Nye og eksisterende oversettelsesenheter',
	'tpt-sections-deleted' => 'Slettede oversettelsesenheter',
	'tpt-sections-template' => 'Mal for oversettelsesside',
	'tpt-badtitle' => 'Det angitte sidenavnet ($1) er ikke en gyldig tittel',
	'tpt-oldrevision' => '$2 er ikke den siste versjonen av siden [[$1]].
Kun siste versjoner kan bli markert for oversettelse.',
	'tpt-notsuitable' => 'Side $1 er ikke egnet for oversettelse.
Sjekk at siden er merket med <nowiki><translate></nowiki>-merke og har en gyldig syntaks.',
	'tpt-saveok' => 'Siden [[$1]] har blitt markert for oversettelse med {{PLURAL:$2|én oversettelse|$2 oversettelser}}.
Den kan nå bli <span class="plainlinks">[$3 oversatt]</span>.',
	'tpt-badsect' => '«$1» er ikke et gyldig navn for oversettelsen $2.',
	'tpt-showpage-intro' => 'Under er nye, eksisterende og slettede seksjoner listet opp.
Før denne versjonen merkes for oversettelse, sjekk at endringene i seksjonene er minimert for å unngå unødvendig arbeid for oversetterne.',
	'tpt-mark-summary' => 'Markerte denne versjonen for oversettelse',
	'tpt-edit-failed' => 'Kunne ikke oppdatere siden: $1',
	'tpt-already-marked' => 'Den siste versjonen av denne siden har allerede blitt markert for oversettelse.',
	'tpt-list-nopages' => 'Ingen sider er marker for oversettelse, eller er klare for å bli markert for oversettelse.',
	'tpt-old-pages' => 'En versjon av {{PLURAL:$1|denne siden|disse sidene}} har blitt markert for oversettelse.',
	'tpt-new-pages' => '{{PLURAL:$1|Denne siden|Disse sidene}} inneholder tekst med oversettelsesmerker, men ingen versjon av {{PLURAL:$1|denne siden|disse sidene}} er for tiden markert for oversettelse.',
	'tpt-rev-latest' => 'siste versjon',
	'tpt-rev-old' => 'forskjell fra forrige markerte versjon',
	'tpt-rev-mark-new' => 'merk denne versjonen for oversettelse',
	'tpt-translate-this' => 'oversett denne siden',
	'translate-tag-translate-link-desc' => 'Oversett denne siden',
	'translate-tag-markthis' => 'Merk denne siden for oversettelse',
	'translate-tag-markthisagain' => 'Denne siden har hatt <span class="plainlinks">[$1 endringer]</span> siden den sist ble <span class="plainlinks">[$2 markert for oversettelse]</span>.',
	'translate-tag-hasnew' => 'Denne siden inneholder <span class="plainlinks">[$1 endringer]</span> som ikke har blitt markert for oversettelse.',
	'tpt-translation-intro' => 'Denne siden er en <span class="plainlinks">[$1 oversatt versjon]</span> av en side [[$2]] og oversettelsen er $3% ferdig og oppdatert.',
	'tpt-translation-intro-fuzzy' => 'Utdaterte oversettelser er markert på denne måten.',
	'tpt-languages-legend' => 'Andre språk:',
	'tpt-target-page' => 'Denne siden kan ikke oppdateres manuelt.
Denne siden er en oversettelse av siden [[$1]] og oversettelsen kan bli oppdatert ved å bruke [$2 oversettelsesverktøyet].',
	'tpt-unknown-page' => 'Dette navnerommet er reservert for oversettelser av innholdssider.
Denne siden som du prøver å redigere virker ikke å samsvare med noen av sidene som er markert for oversettelse.',
	'tpt-install' => 'Kjør php maintenance/update.php eller webinnstallering for å muliggjøre sideoversettelsesegenskapen.',
	'tpt-render-summary' => 'Oppdaterer for å samsvare ny versjon av kildesiden',
	'tpt-download-page' => 'Eksporter side med oversettelser',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'pagetranslation' => 'Traduccion de paginas',
	'right-pagetranslation' => 'Marcar de versions de paginas per èsser traduchas',
	'tpt-desc' => 'Extension per traduire de paginas de contengut',
	'tpt-section' => 'Unitat de traduccion $1',
	'tpt-section-new' => 'Unitat de traduccion novèla. Nom : $1',
	'tpt-section-deleted' => 'Unitat de traduccion $1',
	'tpt-template' => 'Modèl de pagina',
	'tpt-templatediff' => 'Lo modèl de pagina a cambiat.',
	'tpt-diff-old' => 'Tèxte precedent',
	'tpt-diff-new' => 'Tèxte novèl',
	'tpt-submit' => 'Marcar aquesta version per èsser traducha',
	'tpt-sections-oldnew' => 'Unitats de traduccion novèlas e existentas',
	'tpt-sections-deleted' => 'Unitats de traduccion suprimidas',
	'tpt-sections-template' => 'Modèl de pagina de traduccion',
	'tpt-badtitle' => 'Lo nom de pagina donada ($1) es pas un títol valid',
	'tpt-oldrevision' => '$2 es pas la darrièra version de la pagina [[$1]].
Sola la darrièra version de la pagina pòt èsser marcada per èsser traducha.',
	'tpt-notsuitable' => "La pagina $1 conven pas per èsser traducha.
Siatz segur(a) que conten la balisa <nowiki><translate></nowiki> e qu'a una sintaxi corrècta.",
	'tpt-saveok' => 'La pagina « $1 » es estada marcada per èsser traducha amb $2 {{PLURAL:$2|unitat de traduccion|unitats de traduccion}}.
La pagina pòt èsser <span class="plainlinks">[$3 traducha]</span> tre ara.',
	'tpt-badsect' => '« $1 » es pas un nom valid per una unitat de traduccion $2.',
	'tpt-showpage-intro' => "Çaijós, las traduccions novèlas, las qu'existisson e las suprimidas.
Abans de marcar aquestas versions per èsser traduchas, verificatz que las modificacions a las seccions son minimizadas per evitar de trabalh inutil als traductors.",
	'tpt-mark-summary' => 'Aquesta version es estada marcada per èsser traducha',
	'tpt-edit-failed' => 'Impossible de metre a jorn la pagina $1',
	'tpt-already-marked' => "La darrièra version d'aquesta pagina ja es estada marcada per èsser traducha.",
	'tpt-list-nopages' => "Cap de pagina es pas estada marcada per èsser traducha o prèsta per l'èsser.",
	'tpt-old-pages' => "De versions d'{{PLURAL:$1|aquesta pagina|aquestas paginas}} son estadas marcadas per èsser traduchas.",
	'tpt-new-pages' => "{{PLURAL:$1|Aquesta pagina conten|Aquestas paginas contenon}} de tèxte amb de balisas de traduccion, mas cap de version d'{{PLURAL:$1|aquesta pagina es pas marcada per èsser traducha|aquestas paginas son pas marcadas per èsser traduchas}}.",
	'tpt-rev-latest' => 'darrièra version',
	'tpt-rev-old' => 'diferéncia amb la version marcada precedenta',
	'tpt-rev-mark-new' => 'marcar aquesta version per èsser traducha',
	'tpt-translate-this' => 'traduire aquesta pagina',
	'translate-tag-translate-link-desc' => 'Traduire aquesta pagina',
	'translate-tag-markthis' => 'Marcar aquesta pagina per èsser traducha',
	'translate-tag-markthisagain' => 'Aquesta pagina a agut <span class="plainlinks">[$1 de modificacions]</span> dempuèi qu’es estada darrièrament <span class="plainlinks">[$2 marcada per èsser traducha]</span>.',
	'translate-tag-hasnew' => 'Aquesta pagina conten <span class="plainlinks">[$1 de modificacions]</span> que son pas marcadas per la traduccion.',
	'tpt-translation-intro' => 'Aquesta pagina es una <span class="plainlinks">[$1 traduccion]</span> de la pagina [[$2]] e la traduccion es completada a $3 % e a jorn.',
	'tpt-translation-intro-fuzzy' => 'Las traduccions obsolètas son marcadas atal.',
	'tpt-languages-legend' => 'Autras lengas :',
	'tpt-target-page' => "Aquesta pagina pòt pas èsser mesa a jorn manualament.
Es una version traducha de [[$1]] e la traduccion pòt èsser mesa a jorn en utilizant [$2 l'esplech de traduccion].",
	'tpt-unknown-page' => "Aqueste espaci de noms es reservat per la traduccion de paginas.
La pagina qu'ensajatz de modificar sembla pas correspondre a cap de pagina marcada per èsser traducha.",
	'tpt-install' => "Aviatz php maintenance/update.php o l'installacion web per activar la foncionalitat de traduccion de paginas.",
	'tpt-render-summary' => 'Mesa a jorn per èsser en acòrd amb la version novèla de la font de la pagina',
	'tpt-download-page' => 'Exportar la pagina amb sas traduccions',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'pagetranslation' => 'Iwwersetzing vun Bledder',
	'tpt-translate-this' => 'des Blatt iwwersetze',
	'translate-tag-translate-link-desc' => 'Des Blatt iwwersetze',
	'tpt-languages-legend' => 'Annre Schprooche:',
);

/** Polish (Polski)
 * @author Leinad
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'pagetranslation' => 'Tłumaczenie strony',
	'right-pagetranslation' => 'Oznaczanie wersji stron do przetłumaczenia',
	'tpt-desc' => 'Rozszerzenie pozwalające tłumaczyć strony treści',
	'tpt-section' => 'Jednostka tłumaczenia $1',
	'tpt-section-new' => 'Nowa jednostka tłumaczenia.
Nazwa – $1',
	'tpt-section-deleted' => 'Jednostka tłumaczenia $1',
	'tpt-template' => 'Szablon strony',
	'tpt-templatediff' => 'Szablon strony został zmieniony.',
	'tpt-diff-old' => 'Poprzedni tekst',
	'tpt-diff-new' => 'Nowy tekst',
	'tpt-submit' => 'Oznacz tę wersję do przetłumaczenia',
	'tpt-sections-oldnew' => 'Nowe i istniejące jednostki tłumaczenia',
	'tpt-sections-deleted' => 'Usunięte jednostki tłumaczenia',
	'tpt-sections-template' => 'Szablon strony tłumaczenia',
	'tpt-badtitle' => 'Podana nazwa strony ($1) nie jest dozwolonym tytułem',
	'tpt-oldrevision' => '$2 nie jest najnowszą wersją strony [[$1]].
Tylko najnowsze wersje mogą być oznaczane do tłumaczenia.',
	'tpt-notsuitable' => 'Strona $1 nie nadaje się do tłumaczenia.
Upewnij się, że ma znaczniki <nowiki><translate></nowiki> i właściwą składnię.',
	'tpt-saveok' => 'Strona [[$1]] została oznaczona do tłumaczenia razem z $2 {{PLURAL:$2|jednostką|jednostkami}} tłumaczenia.
Można ją teraz <span class="plainlinks">[$3 przetłumaczyć]</span>.',
	'tpt-badsect' => '„$1” nie jest dozwoloną nazwą jednostki tłumaczenia $2.',
	'tpt-showpage-intro' => 'Poniżej wypisane są nowe, istniejące i usunięte sekcje.
Przed oznaczeniem tej wersji do tłumaczenia, aby uniknąć niepotrzebnej pracy tłumaczy, sprawdź czy zmiany w sekcjach zostały zminimalizowane.',
	'tpt-mark-summary' => 'Oznaczono tę wersję do tłumaczenia',
	'tpt-edit-failed' => 'Nie udało się zaktualizować strony $1',
	'tpt-already-marked' => 'Najnowsza wersja tej strony już wcześniej została oznaczona do tłumaczenia.',
	'tpt-list-nopages' => 'Nie oznaczono stron do tłumaczenia i nie ma stron gotowych do oznaczenia do tłumaczenia.',
	'tpt-old-pages' => 'Niektóre wersje {{PLURAL:$1|tej strony|tych stron}} zostały oznaczone do tłumaczenia.',
	'tpt-new-pages' => '{{PLURAL:$1|Ta strona zawiera|Te strony zawierają}} tekst ze znacznikami tłumaczenia, ale żadna wersja {{PLURAL:$1|tej strony|tych stron}} nie jest aktualnie oznaczona do tłumaczenia.',
	'tpt-rev-latest' => 'ostatnia wersja',
	'tpt-rev-old' => 'zmiana w stosunku do ostatniej oznaczonej wersji',
	'tpt-rev-mark-new' => 'oznacz tę wersję do tłumaczenia',
	'tpt-translate-this' => 'przetłumacz tę stronę',
	'translate-tag-translate-link-desc' => 'Przetłumacz tę stronę',
	'translate-tag-markthis' => 'Oznacz tę stronę do tłumaczenia',
	'translate-tag-markthisagain' => 'Ta strona została <span class="plainlinks">[zmieniona $1 razy]</span>, od kiedy ostatnio była <span class="plainlinks">[$2 oznaczona do tłumaczenia]</span>.',
	'translate-tag-hasnew' => 'Ta strona została <span class="plainlinks">[zmieniona $1 razy]</span> i nie została oznaczona do tłumaczenia.',
	'tpt-translation-intro' => 'Ta strona to <span class="plainlinks">[$1 przetłumaczona wersja]</span> strony [[$2]], a tłumaczenie jest ukończone lub aktualne w $3%.',
	'tpt-translation-intro-fuzzy' => 'Tak są oznaczane nieaktualne tłumaczenia.',
	'tpt-languages-legend' => 'Inne języki:',
	'tpt-target-page' => 'Ta strona nie może zostać zaktualizowana ręcznie.
Jest ona tłumaczeniem strony [[$1]], a tłumaczenie może zostać zmienione za pomocą [$2 narzędzia tłumacza].',
	'tpt-unknown-page' => 'Ta przestrzeń nazw jest zarezerwowana dla tłumaczeń stron z zawartością.
Strona, którą próbujesz edytować, prawdopodobnie nie odpowiada żadnej stronie oznaczonej do tłumaczenia.',
	'tpt-install' => 'Uruchom php maintenance/update.php lub przeprowadź instalację webową, aby włączyć opcję tłumaczenia stron.',
	'tpt-render-summary' => 'Aktualizowanie w celu dopasowania nowej wersji strony źródłowej',
	'tpt-download-page' => 'Wyeksportuj stronę z tłumaczeniami',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'pagetranslation' => 'Tradussion dle pàgine',
	'right-pagetranslation' => 'Marché le version dle pàgine për la tradussion',
	'tpt-desc' => 'Estension për fé la tradussion dle pàgine ëd contnù',
	'tpt-section' => 'Unità ëd tradussion $1',
	'tpt-section-new' => 'Neuva unità ëd tradussion.
Nòm: $1',
	'tpt-section-deleted' => 'Unità ëd tradussion $1',
	'tpt-template' => 'Model ëd pàgina',
	'tpt-templatediff' => "Ël model dla pàgina a l'é cangià.",
	'tpt-diff-old' => 'Test ëd prima',
	'tpt-diff-new' => 'Test neuv',
	'tpt-submit' => 'Marca costa version për la tradussion',
	'tpt-sections-oldnew' => 'Unità ëd tradussion neuve e esistente',
	'tpt-sections-deleted' => 'Unità ëd tradussion eliminà',
	'tpt-sections-template' => 'Model ëd pàgina ëd tradussion',
	'tpt-badtitle' => "Ël nòm dàit a la pàgina ($1) a l'é pa un tìtol bon",
	'tpt-oldrevision' => "$2 a l'é nen l'ùltima version dla pàgina [[$1]].
Mach j'ùltime version a peulo esse marcà për la tradussion.",
	'tpt-notsuitable' => "La pàgina $1 a va nen bin për la tradussion.
Ch'a contròla ch'a l'abia le tichëtte <nowiki><translate></nowiki> e na sintassi bon-a.",
	'tpt-saveok' => 'La pàgina [[$1]] a l\'é stàita marcà për la tradussion con $2 {{PLURAL:$2|unità ëd tradussion|unità ëd tradussion}}.
Adess la pàgina a peul esse <span class="plainlinks">[$3 voltà]</span>.',
	'tpt-badsect' => "«$1» a l'é pa un nòm bon për l'unità ëd tradussion $2.",
	'tpt-showpage-intro' => 'Sì-sota a son listà le session neuve, esistente e sganfà.
Prima ëd marché costa version për la tradussion, controlé che le modìfiche a le session a son minimisà për evité dël travaj inùtil ai tradutor.',
	'tpt-mark-summary' => "Costa version a l'é stàita marcà për la tradussion",
	'tpt-edit-failed' => "Impossìbil d'agiorné la pàgina: $1",
	'tpt-already-marked' => "L'ùltima version ëd sa pàgina a l'é stàita già marcà për la tradussion.",
	'tpt-list-nopages' => 'A-i é gnun-a pàgina marcà për la tradussion ni pronta për esse marcà për la tradussion.',
	'tpt-old-pages' => 'Chèiche version ëd {{PLURAL:$1|costa pàgine|coste pàgine}} a son ëstàite marcà për la tradussion.',
	'tpt-new-pages' => "{{PLURAL:$1|Sa pàgina a conten|Se pàgine a conten-o}} dël test con la tichëtta ëd tradussion, ma gnun-a version ëd {{PLURAL:$1|costa pàgina|coste pàgine}} a l'é al moment marcà për la tradussion.",
	'tpt-rev-latest' => 'ùltima version',
	'tpt-rev-old' => 'diferensa con la version marcà precedenta',
	'tpt-rev-mark-new' => 'marca costa version për la tradussion',
	'tpt-translate-this' => 'fé la tradussion ëd sa pàgina',
	'translate-tag-translate-link-desc' => 'Fé la tradussion ëd sa pàgina',
	'translate-tag-markthis' => 'Marca costa pàgina për la tradussion',
	'translate-tag-markthisagain' => 'Costa pàgina a l\'ha avù <span class="plainlinks">[$1 cangiament]</span> da cand a l\'é stàita <span class="plainlinks">[$2 marcà për la tradussion]</span> l\'ùltima vira.',
	'translate-tag-hasnew' => 'Costa pàgina a conten <span class="plainlinks">[$1 cangiament]</span> ch\'a son pa marcà për la tradussion.',
	'tpt-translation-intro' => 'Sta pàgina-sì a l\'é na <span class="plainlinks">[$1 vërsion traduvùa]</span> ëd na pàgina [[$2]] e la tradussion a l\'é $3% completa e agiornà.',
	'tpt-translation-intro-fuzzy' => 'Tradussion pa agiornà a son marcà com costa.',
	'tpt-languages-legend' => 'Àutre lenghe:',
	'tpt-target-page' => "Sta pàgina-sì a peul pa esse modificà a man. 
Sta pàgina-sì a l'é na tradussion ëd la pàgina [[$1]] e la tradussion a peul esse modificà an dovrand [$2 l'utiss ëd tradussion].",
	'tpt-unknown-page' => "Sto spassi nominal-sì a l'é riservà për tradussion ëd pàgine ëd contnù.
La pàgina ch'it preuve a modifiché a smija pa ch'a corisponda a na pàgina marcà për tradussion.",
	'tpt-install' => "Fa giré ël php maintnance/update php o l'instalassion dl'aragnà për abilité la possibilità ëd tradussion ëd pàgine.",
	'tpt-render-summary' => 'Modifiché për esse com la neuva version dla pàgina sorgiss',
	'tpt-download-page' => 'Espòrta pàgina con tradussion',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'pagetranslation' => 'د مخ ژباړه',
	'tpt-template' => 'د مخ کينډۍ',
	'tpt-templatediff' => 'د مخ کينډۍ بدلون موندلی.',
	'tpt-diff-old' => 'پخوانی متن',
	'tpt-diff-new' => 'نوی متن',
	'tpt-sections-template' => 'د ژباړې د مخ کينډۍ',
	'tpt-translate-this' => 'همدا مخ ژباړل',
	'translate-tag-translate-link-desc' => 'همدا مخ ژباړل',
	'translate-tag-markthis' => 'همدا مخ د ژباړې لپاره په نښه کول',
	'tpt-languages-legend' => 'نورې ژبې:',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'pagetranslation' => 'Tradução de páginas',
	'right-pagetranslation' => 'Marcar versões de páginas para tradução',
	'tpt-desc' => 'Extensão para traduzir páginas de conteúdo',
	'tpt-section' => 'Unidade de tradução $1',
	'tpt-section-new' => 'Nova unidade de tradução. Nome: $1',
	'tpt-section-deleted' => 'Unidade de tradução $1',
	'tpt-template' => 'Modelo de página',
	'tpt-templatediff' => 'O modelo de página foi modificado.',
	'tpt-diff-old' => 'Texto anterior',
	'tpt-diff-new' => 'Novo texto',
	'tpt-submit' => 'Marcar esta versão para tradução',
	'tpt-sections-oldnew' => 'Unidades de tradução novas e existentes',
	'tpt-sections-deleted' => 'Unidades de tradução eliminadas',
	'tpt-sections-template' => 'Modelo de página de tradução',
	'tpt-badtitle' => 'O nome de página fornecido ($1) não é um título válido',
	'tpt-oldrevision' => '$2 não é a versão mais recente da página [[$1]].
Apenas as últimas versões podem ser marcadas para tradução.',
	'tpt-notsuitable' => "A página $1 não é adequada para tradução.
Certifique-se que a mesma contém ''tags'' <nowiki><translate></nowiki> e tem uma sintaxe válida.",
	'tpt-saveok' => 'A página [[$1]] foi marcada para tradução com $2 {{PLURAL:$2|unidade|unidades}} de tradução.
A página pode agora ser <span class="plainlinks">[$3 traduzida]</span>.',
	'tpt-badsect' => '"$1" não é um nome válido para a unidade de tradução $2.',
	'tpt-showpage-intro' => 'Abaixo estão listadas secções novas, existentes e apagadas.
Antes de marcar esta versão para tradução, verifique que as alterações às secções são minimizadas para evitar trabalho desnecessário para os tradutores.',
	'tpt-mark-summary' => 'Marcou esta versão para tradução',
	'tpt-edit-failed' => 'Não foi possível actualizar a página: $1',
	'tpt-already-marked' => 'A versão mais recente desta página já foi marcada para tradução.',
	'tpt-list-nopages' => 'Não existem páginas marcadas para tradução, nem prontas a ser marcadas para tradução.',
	'tpt-old-pages' => 'Uma versão {{PLURAL:$1|desta página|destas páginas}} foi marcada para tradução.',
	'tpt-new-pages' => "{{PLURAL:$1|Esta página contém|Estas páginas contêm}} texto com ''tags'' de tradução, mas nenhuma versão {{PLURAL:$1|da página|das páginas}} está presentemente marcada para tradução.",
	'tpt-rev-latest' => 'versão mais recente',
	'tpt-rev-old' => 'diferenças em relação à versão marcada anterior',
	'tpt-rev-mark-new' => 'marcar esta versão para tradução',
	'tpt-translate-this' => 'traduzir esta página',
	'translate-tag-translate-link-desc' => 'Traduzir esta página',
	'translate-tag-markthis' => 'Marcar esta página para tradução',
	'translate-tag-markthisagain' => 'Esta página tem <span class="plainlinks">[$1 alterações]</span> desde a última vez que foi <span class="plainlinks">[$2 marcada para tradução]</span>.',
	'translate-tag-hasnew' => 'Esta página contém <span class="plainlinks">[$1 alterações]</span> que não estão marcadas para tradução.',
	'tpt-translation-intro' => 'Esta página é uma <span class="plainlinks">[$1 versão traduzida]</span> da página [[$2]] e a tradução está $3% completa e actualizada.',
	'tpt-translation-intro-fuzzy' => 'Traduções desactualizadas estão marcadas desta forma.',
	'tpt-languages-legend' => 'Outras línguas:',
	'tpt-target-page' => 'Esta página não pode ser actualizada manualmente.
Esta página é uma tradução da página [[$1]] e a tradução pode ser actualizada usando [$2 a ferramenta de tradução].',
	'tpt-unknown-page' => 'Este espaço nominal está reservado para traduções de páginas de conteúdo.
A página que está a tentar editar não parece corresponder a nenhuma página marcada para tradução.',
	'tpt-install' => "Execute ''maintenance/update.php'' ou instale através da internet para possibilitar a funcionalidade de tradução de páginas.",
	'tpt-render-summary' => 'A actualizar para corresponder à nova versão da página fonte',
	'tpt-download-page' => 'Exportar a página com traduções',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'pagetranslation' => 'Tradução de páginas',
	'right-pagetranslation' => 'Marca versões de páginas para tradução',
	'tpt-desc' => 'Extensão para traduzir páginas de conteúdo',
	'tpt-section' => 'Unidade de tradução $1',
	'tpt-section-new' => 'Nova unidade de tradução.
Nome: $1',
	'tpt-section-deleted' => 'Unidade de tradução $1',
	'tpt-template' => 'Modelo de página',
	'tpt-templatediff' => 'O modelo de página foi modificado.',
	'tpt-diff-old' => 'Texto anterior',
	'tpt-diff-new' => 'Novo texto',
	'tpt-submit' => 'Marca esta versão para tradução',
	'tpt-sections-oldnew' => 'Unidades de tradução novas e existentes',
	'tpt-sections-deleted' => 'Unidades de tradução apagadas',
	'tpt-sections-template' => 'Modelo de página de tradução',
	'tpt-badtitle' => 'O nome de página dado ($1) não é um título válido',
	'tpt-oldrevision' => '$2 não é a versão atual da página [[$1]].
Apenas as versões atuais pode ser marcadas para tradução.',
	'tpt-notsuitable' => 'A página $1 não está adequada para tradução.
Tenha certeza que ela tem marcas <nowiki><translate></nowiki> e tem a sintaxe válida.',
	'tpt-saveok' => 'A página [[$1]] foi marcada para tradução com $2 {{PLURAL:$2|unidade|unidades}} de tradução.
A página pode ser <span class="plainlinks">[$3 traduzida]</span> agora.',
	'tpt-badsect' => '"$1" não é um nome válido para a unidade de tradução $2.',
	'tpt-showpage-intro' => 'Abaixo estão listadas seções novas, existentes e removidas.
Antes de marcar esta versão para tradução, verifique se as mudanças nas seções foram minimizadas para evitar trabalho desnecessário para os tradutores.',
	'tpt-mark-summary' => 'Marcou esta versão para tradução',
	'tpt-edit-failed' => 'Não foi possível atualizar a página: $1',
	'tpt-already-marked' => 'A versão atual desta página já foi marcada para tradução.',
	'tpt-list-nopages' => 'Nenhuma página está marcada para tradução nem pronta para ser marcada para tradução.',
	'tpt-old-pages' => 'Alguma versão {{PLURAL:$1|desta página|destas páginas}} foi marcada para tradução.',
	'tpt-new-pages' => '{{PLURAL:$1|Esta página contém|Estas páginas contêm}} texto com marcas de tradução, mas nenhuma versão {{PLURAL:$1|desta página|destas páginas}} está atualmente marcada para tradução.',
	'tpt-rev-latest' => 'versão atual',
	'tpt-rev-old' => 'Diferença em relação à versão marcada anterior',
	'tpt-rev-mark-new' => 'marcar esta versão para traduçao',
	'tpt-translate-this' => 'traduzir esta página',
	'translate-tag-translate-link-desc' => 'Traduzir esta página',
	'translate-tag-markthis' => 'Marcar esta página para tradução',
	'translate-tag-markthisagain' => 'Esta página tem <span class="plainlinks">[$1 alterações]</span> desde a última vez em que ela foi <span class="plainlinks">[$2 marcada para tradução]</span>.',
	'translate-tag-hasnew' => 'Esta página contém <span class="plainlinks">[$1 alterações]</span> que não são marcadas para tradução.',
	'tpt-translation-intro' => 'Esta página é uma <span class="plainlinks">[$1 versão traduzida]</span> de uma página [[$2]], e a tradução está $3% completa e atualizada.',
	'tpt-translation-intro-fuzzy' => 'Traduções desatualizadas estão marcadas assim.',
	'tpt-languages-legend' => 'Outros idiomas:',
	'tpt-target-page' => 'Esta página não pode ser atualizada manualmente.
Esta página é uma tradução da página [[$1]] e a tradução pode ser atualizada usando [$2 a ferramenta de tradução].',
	'tpt-unknown-page' => 'Este domínio é reservado para traduções de páginas de conteúdo.
Esta página que você está tentando editar não aparenta corresponder a nenhuma página marcada para tradução.',
	'tpt-install' => 'Execute a manutenção do php/update.php ou a instalação "web" para habilitar a funcionalidade de tradução de páginas.',
	'tpt-render-summary' => 'Atualizando para corresponder a nova versão da página fonte',
	'tpt-download-page' => 'Exportar página com traduções',
);

/** Rhaeto-Romance (Rumantsch)
 * @author Gion-andri
 */
$messages['rm'] = array(
	'pagetranslation' => 'Translaziun da paginas',
	'tpt-diff-old' => 'Ultim text',
	'tpt-diff-new' => 'Nov text',
	'tpt-languages-legend' => 'Autras linguas:',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'pagetranslation' => 'Traducerea paginii',
	'tpt-desc' => 'Extensie pentru traducerea conţinutului paginilor',
	'tpt-section' => 'Unitate de traducere $1',
	'tpt-section-new' => 'Unitate de traducere nouă.
Nume: $1',
	'tpt-section-deleted' => 'Unitate de traducere $1',
	'tpt-template' => 'Şablon pagină',
	'tpt-diff-old' => 'Text precedent',
	'tpt-diff-new' => 'Text nou',
	'tpt-submit' => 'Marchează această versiune pentru traducere',
	'tpt-sections-oldnew' => 'Unităţi de traducere noi şi existente',
	'tpt-sections-deleted' => 'Unităţi de traducere şterse',
	'tpt-badsect' => '"$1" nu este un nume valid pentru unitatea de traducere $2.',
	'tpt-mark-summary' => 'Marcat această versiune pentru traducere',
	'tpt-already-marked' => 'Ultima versiune a acestei pagini a fost deja marcată pentru traducere.',
	'tpt-list-nopages' => 'Nici o pagină nu este marcată pentru traducere sau gata să fie marcată pentru traducere.',
	'tpt-rev-latest' => 'ultima versiune',
	'tpt-rev-mark-new' => 'marchează această versiune pentru traducere',
	'tpt-translate-this' => 'tradu aceasta pagină',
	'translate-tag-translate-link-desc' => 'Tradu această pagină',
	'translate-tag-markthis' => 'Marchează această pagină pentru traducere',
	'tpt-translation-intro-fuzzy' => 'Traducerile învechite sunt marcate în acest fel.',
	'tpt-languages-legend' => 'Alte limbi:',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'tpt-diff-old' => 'Teste precedende',
	'tpt-diff-new' => 'Teste nuève',
	'tpt-rev-latest' => 'urtema versione',
	'tpt-translate-this' => 'traduce stà pàgene',
	'translate-tag-translate-link-desc' => 'Traduce sta vosce',
	'tpt-languages-legend' => 'Otre lènghe:',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'pagetranslation' => 'Перевод страниц',
	'right-pagetranslation' => 'отметка версий страниц для перевода',
	'tpt-desc' => 'Расширение для перевода содержимого страниц',
	'tpt-section' => 'Блок перевода $1',
	'tpt-section-new' => 'Новый блок перевода. Название: $1',
	'tpt-section-deleted' => 'Элемент перевода $1',
	'tpt-template' => 'Страничный шаблон',
	'tpt-templatediff' => 'Этот страничный шаблон изменён.',
	'tpt-diff-old' => 'Предыдущий текст',
	'tpt-diff-new' => 'Новый текст',
	'tpt-submit' => 'Отметить эту версию для перевода',
	'tpt-sections-oldnew' => 'Новые и существующие элементы перевода',
	'tpt-sections-deleted' => 'Удалённые элементы перевода',
	'tpt-sections-template' => 'Шаблон страницы перевода',
	'tpt-badtitle' => 'Указанное название страницы ($1) не является допустимым',
	'tpt-oldrevision' => '$2 не является последней версией страницы [[$1]].
Только последние версии могут быть отмечены для перевода.',
	'tpt-notsuitable' => 'Страницы $1 является неподходящей для перевода.
Убедитесь, что она имеет теги <nowiki><translate></nowiki> и правильный синтаксис.',
	'tpt-saveok' => 'Страница [[$1]] был отмечена для перевода, она содержит $2 {{PLURAL:$2|блок перевода|блока перевода|блоков переводов}}.
Теперь страницу можно <span class="plainlinks">[$3 переводить]</span>.',
	'tpt-badsect' => '«$1» не является допустимым названием для блока перевода $2.',
	'tpt-showpage-intro' => 'Ниже приведены новые, существующие и удалённые разделы.
Перед отметкой этой версии для перевода, убедитесь, что изменения в разделе будут минимальны, это позволит сократить объём работы переводчиков.',
	'tpt-mark-summary' => 'Отметить эту версию для перевода',
	'tpt-edit-failed' => 'Невозможно обновить эту страницу: $1',
	'tpt-already-marked' => 'Последняя версия этой страницы уже была отмечена для перевода.',
	'tpt-list-nopages' => 'Нет страниц, отмеченных для перевода, а также нет страниц готовых к отметке.',
	'tpt-old-pages' => 'Некоторые версии {{PLURAL:$1|этой страницы|этих страниц}} были отмечены для перевода.',
	'tpt-new-pages' => '{{PLURAL:$1|Эта страница содержит|Эти страницы содержат}} текст с тегами перевода, но ни одна из версий {{PLURAL:$1|этой страницы|этих страниц}} не отмечена для перевода.',
	'tpt-rev-latest' => 'последняя версия',
	'tpt-rev-old' => 'различия с предыдущей отмеченной версией',
	'tpt-rev-mark-new' => 'отметить эту версию для перевода',
	'tpt-translate-this' => 'перевести эту страницу',
	'translate-tag-translate-link-desc' => 'Перевести эту страницу',
	'translate-tag-markthis' => 'Отметить эту страницу для перевода',
	'translate-tag-markthisagain' => 'На этой странице было произведено <span class="plainlinks">[$1 изменений]</span> с момента последней <span class="plainlinks">[$2 отметки о переводе]</span>.',
	'translate-tag-hasnew' => 'На этой странице было произведено <span class="plainlinks">[$1 изменений]</span>, которые не отмечены для перевода.',
	'tpt-translation-intro' => 'Эта страница является <span class="plainlinks">[$1 переводом]</span> страницы [[$2]]. Перевод актуален и выполнен на $3%.',
	'tpt-translation-intro-fuzzy' => 'Устаревшие переводы отмечены следующим образом.',
	'tpt-languages-legend' => 'Другие языки:',
	'tpt-target-page' => 'Эта страница не может быть обновлена вручную.
Эта страница является переводом страницы [[$1]], перевод может быть обновлен с помощью специального [$2 инструмента перевода].',
	'tpt-unknown-page' => 'Это пространство имён зарезервировано для переводов текстов страниц.
Страница, которую вы пытаетесь изменить, не соответствует какой-либо странице, отмеченной для перевода.',
	'tpt-install' => 'Запустите php-скрипт maintenance/update.php или веб-установку, чтобы включить возможность перевода страниц.',
	'tpt-render-summary' => 'Обновление для соответствия новой версии исходной страницы.',
	'tpt-download-page' => 'Экспортировать страницу с переводами',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'pagetranslation' => 'Сирэйдэри тылбаастааһын',
	'right-pagetranslation' => 'Тылбаастанар сирэйдэр барылларын бэлиэтээһин',
	'tpt-desc' => 'Сирэй ис хоһоонун тылбаастыырга кэҥэтии',
	'tpt-section' => 'Тылбаас единицата $1',
	'tpt-section-new' => 'Тылбаас саҥа единицата. 
Аата: $1',
	'tpt-section-deleted' => 'Тылбаас элэмиэнэ $1',
	'tpt-template' => 'Сирэй халыыба',
	'tpt-templatediff' => 'Бу сирэй халыыба уларытыллыбыт (уларытылынна).',
	'tpt-diff-old' => 'Бу иннинээҕи тиэкис',
	'tpt-diff-new' => 'Саҥа тиэкис',
	'tpt-submit' => 'Бу барылы тылбаастыырга бэлиэтээһин',
	'tpt-sections-oldnew' => 'Тылбаас саҥа уонна уруккуттан баар элэмиэннэрэ',
	'tpt-sections-deleted' => 'Тылбаас сотуллубут элэмиэннэрэ',
	'tpt-sections-template' => 'Тылбаас сирэйин халыыба',
	'tpt-badtitle' => 'Сирэй ыйыллыбыт аата ($1) аат буолар кыаҕа суох',
	'tpt-oldrevision' => '$2 [[$1]] сирэй бүтэһик барыла буолбатах.
Сирэйдэр бүтэһик эрэ барыллара тылбааска бэлиэтэниэхтэрин сөп.',
	'tpt-notsuitable' => '$1 сирэй тылбаастыырга табыгаһа суох.
<nowiki><translate></nowiki> тиэктээҕин уонна синтаксииһэ сөпкө суруллубутун бэрэбиэркэлээ.',
	'tpt-saveok' => '[[$1]] сирэй тылбаастанарга бэлиэтэммит, кини иһигэр {{PLURAL:$2|биир тылбаастаныахтаах этии|$2 тылбаастаныахтаах этии}} баар.
Билигин сирэйи <span class="plainlinks">[$3 тылбаастыахха]</span> сөп.',
	'tpt-badsect' => '"$1" диэн аат $2 тылбаас единицатын аатыгар сөп түбэспэт.',
	'tpt-showpage-intro' => 'Манна саҥа, билигин баар уонна сотуллубут салаалар көстөллөр.
Бу барылы тылбаастаныахтаах курдук бэлиэтиэҥ иннинэ салааҕа уларытыы төһө кыалларынан аҕыйах буоларын ситиһэ сатыахтааххын өйдөө, ол тылбаасчыттар үлэлэрин аҕыйатыа.',
	'tpt-mark-summary' => 'Бу барылы тылбастаныахтаах курдук бэлиэтииргэ',
	'tpt-edit-failed' => 'Бу сирэйи саҥардар табыллыбата: $1',
);

/** Sinhala (සිංහල)
 * @author චතුනි අලහප්පෙරුම
 */
$messages['si'] = array(
	'tpt-template' => 'පිටු සැකිල්ල',
	'tpt-diff-old' => 'පූර්ව පෙළ',
	'tpt-diff-new' => 'නව පෙළ',
	'tpt-rev-latest' => 'නවතම අනුවාදය',
	'tpt-translate-this' => 'මෙම පිටුව පරිවර්තනය කරන්න',
	'translate-tag-translate-link-desc' => 'මෙම පිටුව පරිවර්තනය කරන්න',
	'tpt-languages-legend' => 'වෙනත් භාෂා:',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Mormegil
 * @author Rudko
 */
$messages['sk'] = array(
	'pagetranslation' => 'Preklad stránky',
	'right-pagetranslation' => 'Označiť verzie stránok na preklad',
	'tpt-desc' => 'Rozšírenie na preklad stránok s obsahom',
	'tpt-section' => 'Jednotka prekladu $1',
	'tpt-section-new' => 'Nová jednotka prekladu. 
Názov: $1',
	'tpt-section-deleted' => 'Jednotka prekladu $1',
	'tpt-template' => 'Šablóna stránky',
	'tpt-templatediff' => 'Šablóna stránky sa zmenila.',
	'tpt-diff-old' => 'Predošlý text',
	'tpt-diff-new' => 'Nový text',
	'tpt-submit' => 'Označiť túto verziu na preklad',
	'tpt-sections-oldnew' => 'Nové a existujúce jednotky prekladu',
	'tpt-sections-deleted' => 'Zmazané jednotky prekladu',
	'tpt-sections-template' => 'Šablóna stránky na preklad',
	'tpt-badtitle' => 'Zadaný názov stránky ($1) nie je platný',
	'tpt-oldrevision' => '$2 nie je najnovšia verzia stránky [[$1]].
Na preklad je možné označiť iba posledné verzie stránok.',
	'tpt-notsuitable' => 'Stránka $1 nie je vhodná na preklad.
Uistite sa, že obsahuje značky <nowiki><translate></nowiki> a má platnú syntax.',
	'tpt-saveok' => 'Stránka [[$1]] bola označená na preklad s $2 {{PLURAL:$2|jednotkou prekladu, ktorú|jednotkami prekladu, ktoré}} možno preložiť.
Túto stránku je teraz možné <span class="plainlinks">[$3 preložiť]</span>.',
	'tpt-badsect' => '„$1“ nie je platný názov jednotky prekladu $2.',
	'tpt-showpage-intro' => 'Dolu sú uvedené nové, súčasné a zmazané sekcie,
Predtým než túto verziu označíte na preklad skontrolujte, že zmeny sekcií sú minimálne aby ste zabránili zbytočnej práci prekladateľov.',
	'tpt-mark-summary' => 'Táto verzia je označená na preklad',
	'tpt-edit-failed' => 'Nebolo možné aktualizovať stránku: $1',
	'tpt-already-marked' => 'Najnovšia verzia tejto stránky už bola označená na preklad.',
	'tpt-list-nopages' => 'Žiadne stránky nie sú označené na preklad alebo na to nie sú pripravené.',
	'tpt-old-pages' => 'Niektoré verzie {{PLURAL:$1|tejto stránky|týchto stránok}} boli označené na preklad.',
	'tpt-new-pages' => '{{PLURAL:$1|Táto stránka obsahuje|Tieto stránky obsahujú}} text so značkami na preklad, ale žiadna verzia {{PLURAL:$1|tejto stránky|týchto stránok}} nie je označená na preklad.',
	'tpt-rev-latest' => 'najnovšia verzia',
	'tpt-rev-old' => 'rozdiel oproti predošlej označenej verzii',
	'tpt-rev-mark-new' => 'označiť túto verziu na preklad',
	'tpt-translate-this' => 'preložiť túto stránku',
	'translate-tag-translate-link-desc' => 'Preložiť túto stránku',
	'translate-tag-markthis' => 'Označiť túto stránku na preklad',
	'translate-tag-markthisagain' => 'Táto stránka obsahuje <span class="plainlinks">[$1 {{PLURAL:$1|zmenu|zmeny|zmien}}]</span> odkedy bola naposledy <span class="plainlinks">[$2 označená na preklad]</span>.',
	'translate-tag-hasnew' => 'Táto stránka obsahuje <span class="plainlinks">[$1 zmeny]</span>, ktoré nie sú označené na preklad.',
	'tpt-translation-intro' => 'Táto stránka je <span class="plainlinks">[$1 preloženou verziou]</span> stránky [[$2]] a preklad je hotový a aktuálny na $3 %.',
	'tpt-translation-intro-fuzzy' => 'Zastaralé preklady sú označené takto.',
	'tpt-languages-legend' => 'Iné jazyky:',
	'tpt-target-page' => 'Túto stránku nemožno aktualizovať ručne.
Táto stránka je prekladom stránky [[$1]] a preklad možno aktualizovať pomocou [$2 nástroja na preklad].',
	'tpt-unknown-page' => 'Tento menný priestor je vyhradený na preklady stránok s obsahom.
Zdá sa, že stránka, ktorú sa pokúšate upravovať nezodpovedá žiadnej stránke označenej na preklad.',
	'tpt-install' => 'Funkciu prekladu webových stránok zapnete spustením php maintenance/update.php alebo webovej inštalácie.',
	'tpt-render-summary' => 'Aktualizácia na novú verziu zdrojovej stránky',
	'tpt-download-page' => 'Exportovať stránky s prekladmi',
);

/** Slovenian (Slovenščina)
 * @author Smihael
 */
$messages['sl'] = array(
	'pagetranslation' => 'Prevajanje strani',
	'right-pagetranslation' => 'Označi različice strani za prevajanje',
	'tpt-desc' => 'Razširitev za prevajanje vsebine strani',
	'tpt-section' => 'Prevajalna enota $1',
	'tpt-section-new' => 'Nove prevajalska enota.
Ime: $1',
	'tpt-section-deleted' => 'Prevajalna enota $1',
	'tpt-templatediff' => 'Predloga te strani se je spremenila.',
	'tpt-diff-old' => 'Prejšnje besedilo',
	'tpt-diff-new' => 'Novo besedilo',
	'tpt-submit' => 'Označi to različico za prevajanje',
	'tpt-sections-oldnew' => 'Nove in obstoječe prevajalske enote',
	'tpt-sections-deleted' => 'Izbrisane prevajalske enote',
	'tpt-sections-template' => 'Prevod predloge strani',
	'tpt-oldrevision' => '$2 ni najnovejša različics strani [[$1]].
Samo zadnje različice se lahko označi za prevod.',
	'tpt-notsuitable' => 'Stran $1 ni primerna za prevod.
Prepričajte se, da ima oznake <nowiki><translate></nowiki> in veljavno sintakso.',
	'tpt-rev-latest' => 'najnovejša različica',
	'tpt-rev-old' => 'razlika s prejšnjimi označeni različici',
	'tpt-rev-mark-new' => 'označi to različico za prevajanje',
	'tpt-translate-this' => 'prevedi to stran',
	'translate-tag-translate-link-desc' => 'Prevedi to stran',
	'translate-tag-markthis' => 'Označi to stran za prevajanje',
	'tpt-languages-legend' => 'Ostali jeziki:',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'translate-tag-translate-link-desc' => 'Преведите ову страну',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'translate-tag-translate-link-desc' => 'Prevedite ovu stranu',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'translate-tag-translate-link-desc' => 'Disse Siede uursätte',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author M.M.S.
 * @author Najami
 * @author Rotsee
 */
$messages['sv'] = array(
	'pagetranslation' => 'Sidöversättning',
	'right-pagetranslation' => 'Märk versioner av sidor för översättning',
	'tpt-desc' => 'Programtillägg för översättning av innehållssidor',
	'tpt-section' => 'Översättningsenhet $1',
	'tpt-section-new' => 'Ny översättningsenhet. Namn: $1',
	'tpt-section-deleted' => 'Översättningsenhet $1',
	'tpt-template' => 'Sidmall',
	'tpt-templatediff' => 'Sidmallen har ändrats.',
	'tpt-diff-old' => 'Föregående text',
	'tpt-diff-new' => 'Ny text',
	'tpt-submit' => 'Märk den här versionen för översättning',
	'tpt-sections-oldnew' => 'Nya och existerande översättningsenheter',
	'tpt-sections-deleted' => 'Raderade översättningsenheter',
	'tpt-sections-template' => 'Mall för översättningssida',
	'tpt-badtitle' => 'Det angivna sidnammet ($1) är inte en giltlig titel',
	'tpt-oldrevision' => '$2 är inte den senaste versionen av sidan [[$1]].
Endast den senaste versionen kan märkas för översättning.',
	'tpt-notsuitable' => 'Sidan $1 är inte redo för översättning.
Se till att sidan har <nowiki><translate></nowiki>-taggar och att syntaxen är giltlig.',
	'tpt-saveok' => 'Sidan [[$1]] har märkts för översättning med {{PLURAL:$2|en översättning|$2 översättningar}}. Sidan kan nu <span class="plainlinks">[$3 översättas]</span>.',
	'tpt-badsect' => '"$1" är inte ett giltligt namn för översättningen $2.',
	'tpt-showpage-intro' => 'Här nedanför finns nya, existerande och raderade sektioner uppradade.
Innan den här versionen märks för översättning, kontrollera att förändringarna i texten är minimala för att undvika extra arbete för översättarna.',
	'tpt-mark-summary' => 'Den här versionen är märkt för översättning',
	'tpt-edit-failed' => 'Sidan "$1" kunde inte uppdateras.',
	'tpt-already-marked' => 'Den senaste versionen av den här sidan har redan märkts för översättning.',
	'tpt-list-nopages' => 'Det finns inga sidor som är märkta för översättning eller är klara att märkas för översättning.',
	'tpt-old-pages' => 'En version av {{PLURAL:$1|den här sidan|de här sidorna}} har märkts för översättning.',
	'tpt-new-pages' => '{{PLURAL:$1|Den här sidan|De här sidorna}} innehåller text med översättningstaggar, men ingen version av {{PLURAL:$1|den här sidan|de här sidorna}} är märkt för översättning.',
	'tpt-rev-latest' => 'senaste versionen',
	'tpt-rev-old' => 'skillnad mot föregående markerad version',
	'tpt-rev-mark-new' => 'märk den här versionen för översättning',
	'tpt-translate-this' => 'översätt den här sidan',
	'translate-tag-translate-link-desc' => 'Översätt den här sidan',
	'translate-tag-markthis' => 'Märk den här sidan för översättning',
	'translate-tag-markthisagain' => 'Den här sidan har <span class="plainlinks">[$1 förändringar]</span> sedan den senast <span class="plainlinks">[$2 märktes för översättning]</span>.',
	'translate-tag-hasnew' => 'Den här sidan innehåller <span class="plainlinks">[$1 förändringar]</span> som inte är märkta för översättning.',
	'tpt-translation-intro' => 'Det här är en <span class="plainlinks">[$1 översatt version]</span> av sidan [[$2]]. Översättningen är till $3% färdig och uppdaterad.',
	'tpt-translation-intro-fuzzy' => 'Föråldrade översättningar visas på det här sättet.',
	'tpt-languages-legend' => 'Andra språk:',
	'tpt-target-page' => 'Den här sidan kan inte uppdateras manuellt. Den här sidan är en översättning av [[$1]] och översättningen kan uppdateras genom att använda [$2 översättningsverktyget].',
	'tpt-unknown-page' => 'Den här namnrymden är reserverad för översättningar av sidor. Sidan du försöker redigera verkar inte stämma överens med någon sida som är märkt för översättning.',
	'tpt-download-page' => 'Exportera sidan med översättningar',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'pagetranslation' => 'పేజీ అనువాదం',
	'right-pagetranslation' => 'పేజీల కూర్పులను అనువాదానికై గుర్తించడం',
	'tpt-desc' => 'విషయపు పేజీలను అనువదించడానికై పొడగింత',
	'tpt-section' => 'అనువాద విభాగం $1',
	'tpt-section-new' => 'కొత్త అనువాద విభాగం. పేరు: $1',
	'tpt-section-deleted' => 'అనువాద విభాగము $1',
	'tpt-template' => 'పేజీ మూస',
	'tpt-diff-old' => 'గత పాఠ్యం',
	'tpt-diff-new' => 'కొత్త పాఠ్యం',
	'tpt-sections-template' => 'అనువాద పేజీ మూస',
	'tpt-badtitle' => 'ఇచ్చిన పేజీ పేరు ($1) సరైన శీర్షిక కాదు',
	'tpt-edit-failed' => 'పేజీని తాజాకరించలేకపోయాం: $1',
	'tpt-already-marked' => 'ఈ పేజీ యొక్క సరికొత్త కూర్పుని ఇప్పటికే అనువాదానికై గుర్తించారు.',
	'tpt-rev-mark-new' => 'ఈ కూర్పుని అనువాదం కొరకై గుర్తించు',
	'tpt-translate-this' => 'ఈ పేజీని అనువదించండి',
	'translate-tag-translate-link-desc' => 'ఈ పేజీని అనువదించండి',
	'translate-tag-markthis' => 'ఈ పేజీని అనువాదం కొరకు గుర్తించు',
	'tpt-languages-legend' => 'ఇతర భాషలు:',
);

/** Thai (ไทย)
 * @author Ans
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'pagetranslation' => 'การแปลภาษา',
	'right-pagetranslation' => 'กำหนดให้รุ่นปรับปรุงนี้เพื่อการแปลภาษา',
	'tpt-desc' => 'ส่วนเพิ่มเติมสำหรับหน้าที่มีการแปลเนื้อหา',
	'tpt-section' => 'หน่วยการแปล $1',
	'tpt-section-new' => 'หน่วยการแปลใหม่

ชื่อ: $1',
	'tpt-section-deleted' => 'หน่วยการแปล $1',
	'tpt-template' => 'แม่แบบของหน้า',
	'tpt-templatediff' => 'แม่แบบของหน้านี้ได้ถูกเปลี่ยนแปลงแล้ว',
	'tpt-diff-old' => 'อักษรก่อนหน้า',
	'tpt-diff-new' => 'คำใหม่',
	'tpt-submit' => 'กำหนดให้รุ่นนี้เพื่อการแปลภาษา',
	'tpt-sections-oldnew' => 'หน่วยการแปลใหม่และที่มีอยู่เดิมแล้ว',
	'tpt-sections-deleted' => 'หน่วยการแปลที่ถูกลบแล้ว',
	'tpt-sections-template' => 'แม่แบบหน้าการแปลภาษา',
	'tpt-badtitle' => 'ชื่อหน้าที่กำหนดมานั้น ($1) ไม่ใช่ชื่อหน้าที่ถูกต้อง',
	'tpt-oldrevision' => '$2 ไม่ใช่รุ่นปรับปรุงล่าสุดของหน้าชื่อ[[$1]]

เฉพาะรุ่นปรับปรุงล่าสุดเท่านั้นที่สา่มารถกำหนดเพื่อการแปลภาษา',
	'tpt-notsuitable' => 'หน้า $1 นั้นไม่เมาะสมในการแปลภาษา

ตรวจสอบให้แน่ใจว่ามีแท็ก <nowiki><translate></nowiki> อยู่และมีประโยคของโค้ดที่ถูกต้อง',
	'tpt-saveok' => 'หน้า [[$1]] ได้ถูกกำหนดไว้สำหรับการแปลภาษากับหน่วยการแปลภาษา $2 หน่วย

หน้านี้สามารถ<span class="plainlinks">[$3 เริ่มแปลภาษาได้แล้ว]</span>',
	'tpt-badsect' => '"$1" ไม่ใช่ชื่อที่ถูกต้องสำหรับหน่วยการแปลภาษา $2',
	'tpt-showpage-intro' => 'ส่วนที่มีการเพิ่มใหม่, มีอยู่เดิม และที่ถูกลบไปแล้วนั้นปรากฎด้านล่างนี้
ก่อนที่จะทำให้รุ่นปรับปรุงนี้สำหรับการแปลภาษา ตรวจสอบให้แน่ใจว่าการเปลี่ยนแปลงของส่วนต่างๆ ได้ถูกลดลงมาเพื่อเป็นการหลีกเลี่ยงงานที่ไม่จำเป็นของผู้แปลภาษา',
	'tpt-mark-summary' => 'กำหนดให้รุ่นปรับปรุงนี้สำหรับการแปลภาษา',
	'tpt-edit-failed' => 'ไม่สามารถปรับปรุงหน้า: $1 ได้',
	'tpt-already-marked' => 'รุ่นปรับปรุงล่าสุดของหน้านี้ได้ถูกกำหนดเพื่อการแปลภาษาแล้ว',
	'tpt-list-nopages' => 'ไม่มีหน้าใดๆ ที่ถูกกำหนดเพื่อการแปลภาษา หรือพร้อมที่จะถูกกำหนดเพื่อการแปลภาษา',
	'tpt-old-pages' => 'รุ่นปรับปรุงบางรุ่นของ{{PLURAL:$1|หน้านี้|หน้าต่างๆ เหล่านี้}} ได้ถูกกำหนดเพื่อการแปลภาษาแล้ว',
	'tpt-new-pages' => '{{PLURAL:$1|หน้านี้|หน้าเหล่านี้}} มีที่คั่นสำหรับการแปลภาษาอยู่ แต่ไม่มีรุ่นปรับปรุงใดๆ เลยของ{{PLURAL:$1|หน้านี้|หน้าแหล่านี้}} ที่ได้ถูกกำหนดเพื่อการแปลภาษา',
	'tpt-rev-latest' => 'รุ่นปรับปรุงล่าสุด',
	'tpt-rev-old' => 'เทียบความแตกต่างไปยังรุ่นที่กำหนดก่อนหน้านี้',
	'tpt-rev-mark-new' => 'กำหนดให้รุ่นปรับปรุงนี้เพื่อการแปลภาษา',
	'tpt-translate-this' => 'แปลหน้านี้',
	'translate-tag-translate-link-desc' => 'แปลหน้านี้',
	'translate-tag-markthis' => 'กำหนดให้หน้านี้เพื่อการแปลภาษา',
	'translate-tag-markthisagain' => 'หน้านี้มี<span class="plainlinks">[$1 ความเปลี่ยนแปลง]</span> นับตั้งแต่ครั้งสุดท้ายที่<span class="plainlinks">[$2 ถูกกำหนดเพื่อการแปลภาษา]</span>.',
	'translate-tag-hasnew' => 'หน้านี้มี<span class="plainlinks">[$1 ความเปลี่ยนแปลง]</span> ที่ไม่ได้ถูกกำหนดเพื่อการแปลภาษา',
	'tpt-translation-intro' => 'หน้านี้คือ<span class="plainlinks">[$1 รุ่นปรับปรุงที่เริ่มแปลแล้ว]</span> ของ [[$2]] และการแปลภาษาเสร็จสิ้นแล้ว $3 เปอร์เซ็นต์ของทั้งหมดและเป็นรุ่นล่าสุด',
	'tpt-translation-intro-fuzzy' => 'การแปลภาษาที่ตกรุ่นแล้วจะถูกกำหนดในลักษณะนี้',
	'tpt-languages-legend' => 'ภาษาอื่นๆ:',
	'tpt-target-page' => 'หน้านี้ไม่สามารถถูกปรับปรุงตามปกติได้

หน้านี้เป็นหน้าการแปลของหน้า[[$1]] และสามารถปรับปรุงการแปลได้โดยใช้[เครื่องมือการแปล $2]',
	'tpt-install' => 'เข้าไปที่ maintenance/update.php ใน PHP หรือเข้าไปที่ตัวติดตั้งในเว็บเพื่อเปิดคุณสมบัติการแปลภาษา',
	'tpt-render-summary' => 'กำลังอัพเดตเพื่อทำให้ตรงกันกับรุ่นปรับปรุงใหม่ของหน้่าโค้ดหลัก',
	'tpt-download-page' => 'ส่งหน้าออกไปพร้อมการแปลภาษา',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'pagetranslation' => 'Terjime sahypasy',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'translate-tag-translate-link-desc' => 'Isalinwika ang pahinang ito',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'pagetranslation' => 'Çeviri sayfası',
	'right-pagetranslation' => 'Sayfa sürümlerini çeviri için işaretler',
	'tpt-desc' => 'İçerik sayfalarının çevirisi için eklenti',
	'tpt-section' => 'Çeviri birimi $1',
	'tpt-section-new' => 'Yeni çeviri birimi.
Ad: $1',
	'tpt-section-deleted' => 'Çeviri birimi $1',
	'tpt-template' => 'Sayfa şablonu',
	'tpt-templatediff' => 'Sayfa şablonu değişti.',
	'tpt-diff-old' => 'Önceki metin',
	'tpt-diff-new' => 'Yeni metin',
	'tpt-submit' => 'Bu sürümü çeviri için işaretle',
	'tpt-sections-oldnew' => 'Yeni ve mevcut çeviri birimleri',
	'tpt-sections-deleted' => 'Silinen çeviri birimleri',
	'tpt-sections-template' => 'Çeviri sayfası şablonu',
	'tpt-badtitle' => 'Verilen sayfa adı ($1) geçerli bir başlık değil',
	'tpt-oldrevision' => '$2, [[$1]] sayfasının en son sürümü değil.
Sadece en son sürümler çeviri için işaretlenebilir.',
	'tpt-saveok' => '[[$1]] adlı sayfa $2 {{PLURAL:$2|çeviri birimi|çeviri birimi}} ile çeviri için işaretlenmiş.
Sayfa artık <span class="plainlinks">[$3 çevrilebilir]</span>.',
	'tpt-badsect' => '"$1", $2 çeviri birimi için geçerli bir ad değil.',
	'tpt-showpage-intro' => 'Aşağıda yeni, mevcut ve silinmiş bölümler listelenmiştir.
Bu sürümü çeviri için işaretlemeden önce, çevirmenlere gereksiz iş çıkarmamak için bölümlerde yapılan değişikliklerin asgari seviyede olduğundan emin olun.',
	'tpt-mark-summary' => 'Bu sürüm çeviri için işaretlendi',
	'tpt-edit-failed' => 'Sayfa güncellenemedi: $1',
	'tpt-already-marked' => 'Bu sayfanın en son sürümü çeviri için işaretlenmiş.',
	'tpt-list-nopages' => 'Çeviri için işaretlenen ya da işaretlenmeye hazır olan herhangi bir sayfa bulunmuyor.',
	'tpt-old-pages' => '{{PLURAL:$1|Bu sayfanın|Bu sayfaların}} bazı sürümleri çeviri için işaretlenmiş.',
	'tpt-rev-latest' => 'en son sürüm',
	'tpt-rev-old' => 'önceki işaretlenmiş sürümdeki fark',
	'tpt-rev-mark-new' => 'bu sürümü çeviri için işaretle',
	'tpt-translate-this' => 'Bu sayfayı çevir',
	'translate-tag-translate-link-desc' => 'Bu sayfayı çevir',
	'translate-tag-markthis' => 'Bu sayfayı çeviri için işaretle',
	'translate-tag-hasnew' => 'Bu sayfa, çeviri için işaretlenmemiş <span class="plainlinks">[$1 değişiklik]</span> içeriyor.',
	'tpt-translation-intro-fuzzy' => 'Tarihi geçen çeviriler bu şekilde işaretlenmiştir.',
	'tpt-languages-legend' => 'Diğer diller:',
	'tpt-render-summary' => 'Kaynak sayfanın yeni sürümü ile eşleme için güncelleniyor',
	'tpt-download-page' => 'Çevirileri olan sayfayı dışa aktar',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Рашат Якупов
 */
$messages['tt-cyrl'] = array(
	'pagetranslation' => 'Битләр тәрҗемәсе',
	'tpt-translate-this' => 'бу битне тәрҗемә итү',
	'translate-tag-translate-link-desc' => 'Бу битне тәрҗемә итү',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'pagetranslation' => 'Переклад сторінок',
	'right-pagetranslation' => 'позначення версій сторінок для перекладу',
	'tpt-desc' => 'Розширення для перекладу статей',
	'tpt-section' => 'Блок перекладу $1',
	'tpt-section-new' => 'Новий блок перекладу. Назва: $1',
	'tpt-section-deleted' => 'Блок перекладу $1',
	'tpt-template' => 'Шаблон сторінки',
	'tpt-templatediff' => 'Шаблон сторінки змінений.',
	'tpt-diff-old' => 'Попередній текст',
	'tpt-diff-new' => 'Новий текст',
	'tpt-submit' => 'Позначити цю версію для перекладу',
	'tpt-sections-oldnew' => 'Нові та існуючі блоки перекладу',
	'tpt-sections-deleted' => 'Вилучені блоки перекладу',
	'tpt-sections-template' => 'Шаблон сторінки перекладу',
	'tpt-badtitle' => 'Зазначена назва сторінки ($1) недопустима',
	'tpt-badsect' => '"$1" не є припустимою назвою для частини перекладів $2.',
	'tpt-mark-summary' => 'Позначено цю версію для перекладу',
	'tpt-edit-failed' => 'Не вдалося оновити сторінку: $1',
	'tpt-rev-latest' => 'остання версія',
	'tpt-rev-old' => 'різниця з попередньою позначеною версією',
	'tpt-rev-mark-new' => 'позначити цю версію для перекладу',
	'tpt-translate-this' => 'перекласти цю сторінку',
	'translate-tag-translate-link-desc' => 'Перекласти цю сторінку',
	'translate-tag-markthis' => 'Позначити цю сторінку для перекладу',
	'tpt-translation-intro-fuzzy' => 'Застарілі переклади позначені так.',
	'tpt-languages-legend' => 'Інші мови:',
	'tpt-download-page' => 'Експортувати сторінку з перекладами',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'translate-tag-translate-link-desc' => 'Tradusi sta pagina',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'tpt-rev-latest' => "jäl'gmäine versii",
	'tpt-translate-this' => "kända nece lehtpol'",
	'translate-tag-translate-link-desc' => "Käta nece lehtpol'",
	'tpt-languages-legend' => 'Toižed keled:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'pagetranslation' => 'Dịch trang',
	'right-pagetranslation' => 'Đánh dấu các phiên bản của trang là cần dịch',
	'tpt-desc' => 'Bộ mở rộng để dịch trang nội dung',
	'tpt-section' => 'Đơn vị dịch thuật $1',
	'tpt-section-new' => 'Đơn vị dịch thuật mới.
Tên: $1',
	'tpt-section-deleted' => 'Đơn vị dịch thuật $1',
	'tpt-template' => 'Mẫu trang',
	'tpt-templatediff' => 'Mẫu trang đã thay đổi.',
	'tpt-diff-old' => 'Văn bản trước',
	'tpt-diff-new' => 'Văn bản mới',
	'tpt-submit' => 'Đánh dấu phiên bản này là cần dịch',
	'tpt-sections-oldnew' => 'Các đơn vị dịch thuật mới và hiện có',
	'tpt-sections-deleted' => 'Các đơn vị dịch thuật đã bị xóa',
	'tpt-sections-template' => 'Bản mẫu trang dịch',
	'tpt-badtitle' => 'Tên trang cung cấp ($1) không phải là tên đúng',
	'tpt-oldrevision' => '$2 không phải là phiên bản mới của trang [[$1]]/
Chỉ có các phiên bản mới nhất mới có thể đánh dấu cần dịch được.',
	'tpt-notsuitable' => 'Trang $1 không phù hợp để dịch thuật.
Hãy đảm bảo là nó có thẻ <nowiki><translate></nowiki> và có cú pháp đúng.',
	'tpt-saveok' => 'Trang [[$1]] đã được đánh dấu chờ dịch với $2 đơn vị dịch thuật.
Bạn có thể <span class="plainlinks">[$3 dịch]</span> trang ngay bây giờ.',
	'tpt-badsect' => '"$1" không phải là tên hợp lệ cho đơn vị dịch thuật $2.',
	'tpt-showpage-intro' => 'Dưới đây là các mục mới, đang tồn tại hoặc đã bị xóa.
Trước khi đánh dấu phiên bản này chờ dịch, hãy kiểm tra những thay đổi tại các mục đã được thu gọn lại để tránh công việc không cần thiết cho biên dịch viên chưa.',
	'tpt-mark-summary' => 'Đánh dấu phiên bản này là cần dịch',
	'tpt-edit-failed' => 'Không thể cập nhật trang: $1',
	'tpt-already-marked' => 'Phiên bản mới nhất của trang này đã được đánh dấu cần dịch rồi.',
	'tpt-list-nopages' => 'Chưa có trang này được đánh dấu cần dịch hoặc chưa sẵn sàng để được đánh dấu cần dịch.',
	'tpt-old-pages' => 'Một phiên bản nào đó của {{PLURAL:$1||các}} trang này đã được đánh dấu cần dịch.',
	'tpt-new-pages' => '{{PLURAL:$1|Trang|Các trang}} này có chứa văn bản có thẻ cần dịch, nhưng không có phiên bản nào của {{PLURAL:$1|nó|chúng}} được đánh dấu cần dịch.',
	'tpt-rev-latest' => 'phiên bản mới nhất',
	'tpt-rev-old' => 'khác biệt với phiên bản đánh dấu trước',
	'tpt-rev-mark-new' => 'đánh dấu phiên bản này là cần dịch',
	'tpt-translate-this' => 'dịch trang này',
	'translate-tag-translate-link-desc' => 'Dịch trang này',
	'translate-tag-markthis' => 'Đánh dấu trang này là cần dịch',
	'translate-tag-markthisagain' => 'Trang này có <span class="plainlinks">[$1 thay đổi]</span> từ khi nó được <span class="plainlinks">[$2 đánh dấu cần dịch]</span> lần cuối.',
	'translate-tag-hasnew' => 'Trang này có <span class="plainlinks">[$1 thay đổi]</span> chưa được đánh dấu cần dịch.',
	'tpt-translation-intro' => 'Trang này là một <span class="plainlinks">[$1 bản dịch]</span> của trang [[$2]] và bản dịch đã hoàn thành $3% và theo phiên bản mới nhất.',
	'tpt-translation-intro-fuzzy' => 'Các bản dịch lỗi thời được đánh dấu như thế này.',
	'tpt-languages-legend' => 'Ngôn ngữ khác:',
	'tpt-target-page' => 'Trang này không thể cập nhật bằng tay.
Nó là một bản dịch của trang [[$1]] và có thể cập nhật bản dịch bằng cách sử dụng [$2 công cụ dịch thuật].',
	'tpt-unknown-page' => 'Không gian tên này được dành cho các bản dịch trang nội dung.
Trang bạn muốn sửa đổi dường như không tương ứng với trang nào đã được đánh dấu cần dịch.',
	'tpt-install' => 'Chạy php maintenance/update.php hoặc cài đặt web để bật tính năng dịch trang.',
	'tpt-render-summary' => 'Cập nhật đến phiên bản mới của trang nguồn',
	'tpt-download-page' => 'Xuất trang cùng các bản dịch',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'translate-tag-translate-link-desc' => 'Tradutön padi at',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'pagetranslation' => 'בלאט טײַטש',
	'tpt-diff-old' => 'פֿריערדיגער טעקסט',
	'tpt-diff-new' => 'נײַער טעקסט',
	'translate-tag-translate-link-desc' => 'פֿארטײַטשט דעם בלאט',
	'tpt-languages-legend' => 'אנדערע שפראַכן:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'pagetranslation' => '页面翻译',
	'right-pagetranslation' => '为翻译标记页面的版本',
	'tpt-desc' => '用于翻译内容页面的扩展',
	'tpt-section' => '翻译单元$1',
	'tpt-section-new' => '新翻译单元。
名字：$1',
	'tpt-section-deleted' => '翻译单元$1',
	'tpt-template' => '页面模板',
	'tpt-templatediff' => '页面模板已改变。',
	'tpt-diff-old' => '上一个文字',
	'tpt-diff-new' => '下一个文字',
	'tpt-translate-this' => '翻译此页',
	'translate-tag-translate-link-desc' => '翻译本页',
	'tpt-languages-legend' => '其他语言：',
	'tpt-download-page' => '汇出含翻译的页面',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'pagetranslation' => '頁面翻譯',
	'right-pagetranslation' => '為翻譯標記頁面的版本',
	'tpt-desc' => '用於翻譯內容頁面的擴展',
	'tpt-section' => '翻譯單元$1',
	'tpt-section-new' => '新翻譯單元。
名字：$1',
	'tpt-section-deleted' => '翻譯單元$1',
	'tpt-template' => '頁面模板',
	'tpt-templatediff' => '頁面模板已改變。',
	'tpt-diff-old' => '上一個文字',
	'tpt-diff-new' => '下一個文字',
	'tpt-translate-this' => '翻譯本頁',
	'translate-tag-translate-link-desc' => '翻譯本頁',
	'tpt-languages-legend' => '其它語言：',
	'tpt-download-page' => '匯出含翻譯的頁面',
);

